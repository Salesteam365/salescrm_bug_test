<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Password_model extends CI_Model
{
	 public function __construct()
        {
            
        }
   

/*##########CHECK EXIST##########*/	
public function checkPass($pass){
			$email				= $this->session->userdata('email');
			$session_company 	= $this->session->userdata('company_name');
			$session_comp_email = $this->session->userdata('company_email');
			$data_type 			= $this->session->userdata('type');
			$userid 			= $this->session->userdata('id');
		$this->db->where('company_name' , $session_company);
		$this->db->where('company_email' , $session_comp_email);
		$this->db->where('id' , $userid);
	if($data_type=='admin'){
		$this->db->where('admin_password' , md5($pass));
		$this->db->where('admin_email' , $email);
		$query = $this->db->get('admin_users');
	}else{
      $this->db->where('standard_email' , $email);
      $this->db->where('standard_password' , md5($pass));
      $query = $this->db->get('standard_users');
	}
      $this->db->where('status' , 1);
      if($query->num_rows()>0)
      {
        return true;
      }else
      {
        return false;
      }

}

public function changePassword($newpass){
	    $userid = $this->session->userdata('id');
		$data_type = $this->session->userdata('type');
	if($data_type=='admin'){
		$data=array('admin_password'=>md5(trim($newpass)));
		$this->db->where('id' , $userid);
		$this->db->update('admin_users', $data);
		return true;
	}else{
	  $dataArr=array('standard_password'=>md5($newpass));
	  $this->db->where('id' , $userid);
	  $this->db->update('standard_users', $dataArr);
	  return true;
	}
	
	   
	
}


}