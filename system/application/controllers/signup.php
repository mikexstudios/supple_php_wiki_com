<?php

class Signup extends Controller {

	function Signup()
	{
		parent::Controller();	
		$this->load->model('users_model');
	}
	
	function _initialize() {
		//Unfortunately, we can't put the below code in the constructor since
		//$this isn't fully initialized yet in the constructor (for some reason).
		
		$this->load->library('authorization'); //Requires session
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
	
	function _signup_for_check($in_option) {
		if($in_option == 'wiki' || $in_option == 'user')
		{
			return true;
		}
		
		$this->validation->set_message('_signup_for_check', 'The "What would you like" option you selected is invalid.');
		return false;
	}
	
	function index()
	{
		$this->newuser();
	}
	
	function newuser() {	
		$this->_initialize();
		if($this->authorization->is_logged_in())
		{
			//If user is logged in, we do not show the sign up page. Rather we
			//show the add wiki page
			redirect('/signup/newwiki');
		}
		//Prep form
		$this->load->library('validation');
		$this->validation->set_error_delimiters('<div class="error">', '</div>');
		
		//Set validation rules
		//Note we should also validate that the name does not already exist!
		$rules['username'] = 'required|trim|min_length[4]|max_length[20]|alpha_dash|callback__signup_user_exist_check';
		$rules['email'] = 'required|trim|max_length[300]|valid_email|matches[email_again]';
		$rules['email_again'] = 'required|trim|max_length[300]|valid_email|matches[email]';
		$rules['password'] = 'required|trim|matches[password_again]'; //Should add a min_length in the future
		$rules['password_again'] = 'required|trim|matches[password]';
		$rules['signup_for'] = 'required|trim|alpha|callback__signup_for_check';
		$this->validation->set_rules($rules);
		
		//Also repopulate the form
		$fields['username'] = 'Username';
		$fields['email'] = 'Email Address';
		$fields['email_again'] = 'Email Address Again';
		$fields['password'] = 'Password';
		$fields['password_again'] = 'Password Again';
		$fields['signup_for'] = 'What would you like';
		$this->validation->set_fields($fields);
		
		if($this->validation->run() === TRUE)
		{
			//Okay, so we create the new user first. Then if needed, we send the user
			//to create a new wiki			
			$this->users_model->username = $this->validation->username;
			$this->users_model->set_value('uid', $this->users_model->get_next_uid());
			$this->load->library('encrypt');
			$hashed_password = $this->encrypt->sha1($this->config->item('encryption_salt').$this->validation->password);		
			$this->users_model->set_value('password', $hashed_password);
			$this->users_model->set_value('email', $this->validation->email);
			//User role is now set in Createwiki.php for each specific wiki
			
			//We might want to send an email here.
			
			//Log the user in here
			$this->authorization->set_logged_in($this->validation->username);
			
			//Check to see if the user wants to create a wiki
			if($this->validation->signup_for == 'wiki')
			{
				redirect('/signup/newwiki'); 
			}
			
			//Otherwise, display signup successful page.
			$data['page_title'] = 'User signup successful!';
			$data['page_css'] = '@import url("'.site_url('css/signup.css').'");';
			$this->load->view('signup-usersuccess', $data);
		}
		
		$data['page_title'] = 'Sign up for your own free wiki!';
		$data['page_css'] = '@import url("'.site_url('css/signup.css').'");';
		$this->load->view('signup-newuser', $data);
	}
	
	function newwiki() {
		$this->_initialize();
		
		if(!$this->authorization->is_logged_in())
		{
			//If user is not logged in, we prompt for login
			$this->session->set_userdata('redirect_to', '/signup/newwiki');
			redirect('/admin/users/login');
		}
		
		$this->load->library('createwiki');
		
		//Prep form
		$this->load->library('validation');
		$this->validation->set_error_delimiters('<div class="error">', '</div>');
		
		//Set validation rules
		//Note we should also validate that the name does not already exist!
		$rules['domain'] = 'required|trim|min_length[4]|max_length[20]|alpha_numeric|callback__signup_wiki_exist_check';
		$rules['title'] = 'required|trim|max_length[300]|xss_filter';
		$this->validation->set_rules($rules);
		
		//Also repopulate the form
		$fields['domain'] = 'Wiki Domain';
		$fields['title'] = 'Wiki Title';
		$this->validation->set_fields($fields);
		
		if($this->validation->run() === TRUE)
		{

			$this->load->library('createwiki');
			$this->createwiki->users_path = $this->config->item('wikis_path');
			$this->createwiki->wiki_domain = $this->validation->domain;
			$this->createwiki->wiki_title = $this->validation->title;
			$this->createwiki->script_files_path = $this->config->item('script_files_path');
			$this->createwiki->users_url = base_url().$this->config->item('wikis_dir').'/';
			$this->createwiki->base_domain = 'suppletext.com';
			$this->createwiki->username = get_logged_in_username();
			
			
			//Create new home directory for the user with symbolic links to the st-system
			$this->createwiki->create_new_directory();
			$this->createwiki->copy_over_script_files();
			
			//Generate config file
			$this->createwiki->generate_config_file();
			
			//Create new database table
			$this->createwiki->create_and_populate_database();
			
			//Create subdomain
			
			//Send confirmation email
			//$data['user_url'] = $this->createwiki->full_user_url;
			$data['page_title'] = 'Your new wiki has been successfully created!';
			$data['page_css'] = '@import url("'.site_url('css/signup.css').'");';
			$data['wiki_url'] = $this->validation->domain.'.suppletext.com';
			$this->load->helper('url'); //prep_url in the theme
			$this->load->view('signup-wikisuccess', $data);
		}
		else
		{
			$data['page_title'] = 'Sign up for your own free wiki!';
			$data['page_css'] = '@import url("'.site_url('css/signup.css').'");';
			$this->load->view('signup-newwiki', $data);
		}
	}
	
	function _signup_wiki_exist_check($in_wiki) {
		if($this->createwiki->does_wiki_exist($in_wiki) === TRUE)
		{
			$this->validation->set_message('_signup_wiki_exist_check', 'The wiki domain you selected already exists! Please try picking another wiki domain.');
			return false; //Wiki exists!
		}
		return true;
	}
}
?>
