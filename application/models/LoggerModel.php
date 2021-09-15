<?php

class LoggerModel extends CI_Model
{
public function insertInfo($data)
{
	return $this->db->insert('logininfo', $data);
}	
public function getInfo($email)
{
     $query = $this->db->get_where('logininfo', array('email'=>$email));
	 return $query->row_array();
}	
public function getAllInfo($email, $cached)
{
     
     $this->db->select('user, password, email');
     $query = $this->db->get_where('logininfo', array('email'=>$email, 'password'=>$cached));
	 return $query->row_array();
}	
}