<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************
Register class, if the user registers for the first time
**************************/

class Register extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
 
	function index()
	{
		$this->load->helper(array('form'));
		$this->load->view('register_view');
	}
	
	function success()
	{
		$this->load->view('register_success');
	}
	
	function failure()
	{
		$this->load->view('register_failure');
	}
}

