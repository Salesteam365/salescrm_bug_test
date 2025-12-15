<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Permission_model extends CI_Model
{
	public function __construct()
    {
            
    }
   

/*##########CHECK EXIST##########*/	
public function check_exist($mdlName,$userEmail,$userid){
	$email				= $userEmail;
	$session_company 	= $this->session->userdata('company_name');
	$session_comp_email = $this->session->userdata('company_email');
			
	$this->db->select('id');
	$this->db->where('session_company' , $session_company);
	$this->db->where('session_comp_email' , $session_comp_email);
	$this->db->where('user_id' , $userid);
	$this->db->where('user_email' , $email);
	$this->db->where('module_name' , $mdlName);
	$query = $this->db->get('user_restriction');
    $this->db->where('delete_status' , 1);
    if($query->num_rows()>0){
        return $query->row_array();
    }else{
        return false;
    }

}

public function get_all_module($userid){
	$session_company 	= $this->session->userdata('company_name');
	$session_comp_email = $this->session->userdata('company_email');
			
	$this->db->select('*');
	$this->db->where('session_company' , $session_company);
	$this->db->where('session_comp_email' , $session_comp_email);
	$this->db->where('user_id' , $userid);
	$query = $this->db->get('user_restriction');
    $this->db->where('delete_status' , 1);
    if($query->num_rows()>0){
        return $query->result_array();
    }else{
        return false;
    }
}

public function check_permission($moduleName,$userid){
	$session_company 	= $this->session->userdata('company_name');
	$session_comp_email = $this->session->userdata('company_email');
	$this->db->select('*');
	$this->db->where('session_company' , $session_company);
	$this->db->where('session_comp_email' , $session_comp_email);
	$this->db->where('user_id' , $userid);
	$this->db->where('module_name' , $moduleName);
	$query = $this->db->get('user_restriction');
    $this->db->where('delete_status' , 1);
    if($query->num_rows()>0){
        return $query->row_array();
    }else{
        return false;
    }
}


public function insert_status($arrData){
    $this->db->insert('user_restriction', $arrData);
    return $this->db->insert_id();
}

public function update_status($DataArr,$id){
	$this->db->where('id' , $id);
	$this->db->update('user_restriction', $DataArr);
}


}