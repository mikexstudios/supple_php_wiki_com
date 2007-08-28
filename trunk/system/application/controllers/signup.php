<?php

class Signup extends Controller {

	function Signup()
	{
		parent::Controller();	
	}
	
	function _prepForm() {
		$this->load->library('validation');
		$this->validation->set_error_delimiters('<div class="error">', '</div>');
		
		//Set validation rules
		//Note we should also validate that the name does not already exist!
		$rules['username'] = 'required|trim|min_length[4]|max_length[20]|alpha_dash|callback__signup_user_exist_check';
		$rules['email'] = 'required|trim|max_length[300]|valid_email|matches[email_again]';
		$rules['email_again'] = 'required|trim|max_length[300]|valid_email|matches[email]';
		$rules['password'] = 'required|trim|matches[password_again]'; //Should add a min_length in the future
		$rules['password_again'] = 'required|trim|matches[password]';
		$rules['signup_for'] = 'required|trim|alpha';
		$this->validation->set_rules($rules);
		
		//Also repopulate the form
		$fields['username'] = 'Username';
		$fields['email'] = 'Email Address';
		$fields['email_again'] = 'Email Address Again';
		$fields['password'] = 'Password';
		$fields['password_again'] = 'Password Again';
		$fields['signup_for'] = 'What would you like';
		$this->validation->set_fields($fields);
	}

	function _does_user_exist($in_username) {
		$this->users_model->username = $in_username;
		$uid_temp = $this->users_model->get_value('uid');

		if(!empty($uid_temp))
		{
			return true; //User exists!
		}
		
		return false;	
	}	

	function _signup_user_exist_check($in_username) {
		if($this->_does_user_exist($in_username) === TRUE)
		{
			$this->validation->set_message('_signup_user_exist_check', 'The username you selected already exists! Please try picking another username.');
			return false; //User exists!
		}
		return true;
	}
	
	function index()
	{
		$this->newuser();
	}
	
	function newuser() {	
		$this->_prepForm();
		
		if($this->validation->run() === TRUE)
		{
			die('here');
			
			//The form is successful! This is where we sign the user up.
			$this->load->library('signup');
			$this->signup->setUsersURL(base_url().$this->config->item('users_dir').'/');
			$this->signup->setUsersDirectory($this->config->item('users_path'));
			$this->signup->setScriptFilesDirectory($this->config->item('script_files_path'));
			
			$this->signup->setName($this->validation->name);
			$this->signup->setEmail($this->validation->email);
			
			
			//Create new home directory for the user with symbolic links to the st-system
			$this->signup->createNewDirectory();
			$this->signup->copyOverScriptFiles();
			
			//Generate config file
			$this->signup->generateConfigFile();
			
			
			//Create new database table
			$this->signup->createAndPopulateDatabase();
			
			//Create subdomain
			
			//Send confirmation email
			$data['user_url'] = $this->signup->full_user_url;
			$this->load->view('signup_success', $data);
		}
		
		$this->load->view('signup');
	}
}
?>
