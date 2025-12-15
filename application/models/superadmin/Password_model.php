<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Password_model extends CI_Model
{
	 public function __construct()
        {
            
        }
   

/*##########CHECK EXIST##########*/	
public function checkPass($pass){
			$email				= $this->session->userdata('superadmin_email');
			$session_company 	= $this->session->userdata('supercompany_name');
			$session_comp_email = $this->session->userdata('supercompany_email');
			$data_type 			= $this->session->userdata('types');
			$userid 			= $this->session->userdata('superadmin_id');
		$this->db->where('company_name' , $session_company);
		$this->db->where('company_email' , $session_comp_email);
		$this->db->where('id' , $userid);
	if($data_type=='superadmin'){
		$this->db->where('admin_password' , md5($pass));
		$this->db->where('admin_email' , $email);
		$query = $this->db->get('admin_users');
	}
      $this->db->where('active' , 1);
      if($query->num_rows()>0)
      {
        return true;
      }else
      {
        return false;
      }

}

public function changePassword($newpass){
	    $userid = $this->session->userdata('superadmin_id');
		$data_type = $this->session->userdata('types');
	if($data_type=='superadmin'){
		$data=array('admin_password'=>md5(trim($newpass)));
		$this->db->where('id' , $userid);
		$this->db->update('admin_users', $data);
		return true;
	}

}


}