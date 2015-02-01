<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

/**************************
Home class, after logging in
**************************/

class Home extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('travelRoutes','',TRUE);
	}
 
	function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$sessionData = $this->session->userdata('logged_in');
			$usernameId = $sessionData['id'];
			//$result = $this->travelRoutes->data($usernameId);
			//if($result) {
			//	$data['volunteerData'] = $result;
			//}
			$data['username'] = $sessionData['username'];
			$this->load->view('home_view', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
 
	function interests() {
		if($this->session->userdata('logged_in'))
		{
			$sessionData = $this->session->userdata('logged_in');
			$usernameId = $sessionData['id'];
			$result = $this->travelRoutes->data($usernameId);
			if($result) {
				$data['volunteerData'] = $result;
			}
			$data['username'] = $sessionData['username'];
			$this->load->view('interests_view', $data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
	
	function add() {
	 $from = $_POST['from'];
	 $to = $_POST['to'];
	 $sessionData = $this->session->userdata('logged_in');
	 $usernameId = $sessionData['id'];
	$result = $this->travelRoutes->dataAdd($usernameId, $from, $to);
	}
	
	function delete() {
	 $id = $_GET['id'];
	 $result = $this->travelRoutes->delete($id);
	 redirect('home/interests', 'refresh');
	}
	
	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('home', 'refresh');
	}
}

