<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************
Verifyregister class, verifying the details user has entered before registering
**************************/

class Verifyregister extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user','',TRUE);
	}
 
	function index()
	{
		//This method will have the credentials validation
		$this->load->library('form_validation');
 
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
 
		if($this->form_validation->run() == FALSE)
		{
			//Field validation failed.  User redirected to registration page
			$this->load->view('register_view');
		}
		else
		{
			$this->register_database();
		}
	}
 
	function register_database()
	{
		$username = $this->input->post('username');
		$result = $this->user->usernameCheck($username);
		
		if(!$result) {
			$this->user->register();
			redirect('register/success');
		}
		else {
			redirect('register/failure');
		}
	}
}

