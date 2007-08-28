<?php

class Home extends Controller {

	function Home()
	{
		parent::Controller();	
	}
	
	function _prepForm() {
		$this->load->library('validation');
		$this->validation->set_error_delimiters('<div class="error">', '</div>');
		
		//Set validation rules
		//Note we should also validate that the name does not already exist!
		$rules['name'] = "trim|required|alpha_dash|min_length[4]|max_length[20]|xss_clean";
		$rules['email'] = "trim|required|valid_email";
		$this->validation->set_rules($rules);
		
		//Also repopulate the form
		$fields['name'] = 'Wiki Name'; //These names correspond to what is shown in error message.
		$fields['email'] = 'Email Address';
		$this->validation->set_fields($fields);
	}
	
	function index()
	{
		$this->load->helper(array('form'));		
		$this->_prepForm();
		
		//$this->load->view('signup_success');
		$this->load->view('home');
	}
	
	function signup() {
		$this->_prepForm();
		
		if ($this->validation->run() == FALSE)
		{
			$this->load->helper(array('form'));	
			$this->load->view('home');
		}
		else
		{
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
	}
}
?>
