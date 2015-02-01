<?php 

Class travelRoutes extends CI_Model
{

function data($usernameId) 
 {
   $this->db ->select('id, from, to, date');
   $this->db->from('interests');
   $this->db->where('username_id', $usernameId);
   $query = $this->db->get();
   if($query->num_rows() > 0) 
   {
	return $query->result();
   }
   else 
   {
	return false;
   }
 }
 
 function delete($id) {
	
	$this->db->delete('interests', array('id' => $id)); 
 }
 
 
 function dataAdd($usernameId, $from, $to) {
 date_default_timezone_set('UTC');
	$data = array(
				'username_id' => $usernameId,
				'from' => $from,
				'to' => $to,
				'date' => (string)date("Y-m-d H:i:s")
			);
	$this->db->insert('interests', $data);
 }
}
?>