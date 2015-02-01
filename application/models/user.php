<?php 

Class user extends CI_Model
{
 function login($username, $password)
 {
   $this->db ->select('id, username, password');
   $this->db->from('users');
   $this->db->where('username', $username);
   $this->db->where('password', MD5($password));
   $this->db->limit(1);
 
   $query = $this->db->get();
 
   if($query->num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 function usernameCheck($username)
 {
   $this->db ->select('id, username, password');
   $this->db->from('users');
   $this->db->where('username', $username);
   $this->db->limit(1);
 
   $query = $this->db->get();
 
   if($query->num_rows() == 1)
   {
     return true;
   }
   else
   {
     return false;
   }
 }
 
 function register() {
 
	$data = array(
		'username' => $this->input->post('username'),
		'email' => $this->input->post('email'),
		'password' => MD5($this->input->post('password'))
		);
	$this->db->insert('users', $data);
 }
}
?>