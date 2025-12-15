<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Activity_model extends CI_Model
{
 
  public function insertData($data,$tableName)
  {
    $this->db->insert($tableName, $data);
    return $this->db->insert_id();
  }
  public function delete_act($act_id,$act_name)
  {
	$data=array('delete_status'=>0);  
	$this->db->where('activity_id',$act_id);
	$this->db->where('activity_name',$act_name);
    $this->db->update('customer_activity', $data);
  }
  

  public function get_user()
  {
    $this->db->select('id,standard_email,standard_name');
    $this->db->from('standard_users');
	$session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	$this->db->where('company_email',$session_comp_email);
    $this->db->where('company_name',$session_company);
    $this->db->where('delete_status',1);
    $query = $this->db->get();
    return $query->result_array();
  }
  
  public function get_admin_user()
  {
    $this->db->select('id,admin_email,admin_name');
    $this->db->from('admin_users');
	$session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	$this->db->where('company_email',$session_comp_email);
    $this->db->where('company_name',$session_company);
    $this->db->where('status',1);
    $this->db->limit(1);
    $query = $this->db->get();
    return $query->result_array();
  }
  
  public function get_customer_activity($id,$activity_name='')
  {
	$session_comp_email = $this->session->userdata('company_email');
    $sess_eml 			= $this->session->userdata('email');
    $session_company 	= $this->session->userdata('company_name');
    $this->db->select('*');
    $this->db->from('customer_activity');
	$this->db->where('org_id',$id);
	if($activity_name!=""){
		$this->db->where('activity_name',$activity_name);
	}
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('delete_status',1);
    $this->db->order_by('id','desc');
    $query = $this->db->get();
    return $query->result_array();
  } 
  public function getActivity($tableName,$selectClm,$id)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $sess_eml 			= $this->session->userdata('email');
    $session_company 	= $this->session->userdata('company_name');
    $this->db->select($selectClm);
    $this->db->from($tableName);
	$this->db->where('id',$id);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('delete_status',1);
    $query = $this->db->get();
    return $query->row_array();
  }
  public function getUser($userEmail)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $sess_eml 			= $this->session->userdata('email');
    $session_company 	= $this->session->userdata('company_name');
    $this->db->select('standard_name,id,standard_email');
    $this->db->from('standard_users');
	$this->db->where('standard_email',$userEmail);
	$this->db->where('company_email',$session_comp_email);
    $this->db->where('company_name',$session_company);
    $this->db->where('delete_status',1);
    $query = $this->db->get();
    return $query->row_array();
  }
  public function getUserAdmin($userEmail)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $sess_eml 			= $this->session->userdata('email');
    $session_company 	= $this->session->userdata('company_name');
    $this->db->select('admin_name,id,admin_email');
    $this->db->from('admin_users');
	$this->db->where('admin_email',$userEmail);
	$this->db->where('company_email',$session_comp_email);
    $this->db->where('company_name',$session_company);
    //$this->db->where('delete_status',1);
    $query = $this->db->get();
    return $query->row_array();
  }
  

// Please Write Code Above This  
}
?>
