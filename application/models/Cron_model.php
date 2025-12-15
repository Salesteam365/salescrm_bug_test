<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cron_model extends CI_Model
{
    
    public function __construct(){
        parent::__construct();
    }
	
  public function get_adminemail()
  {
      $this->db->select('id,admin_email,company_email,company_name');
      $this->db->from('admin_users');
	  $this->db->where('status',1);
	  $this->db->where('account_type<>','End');
      $query = $this->db->get();
      return $query->result_array();
  }	
  
  public function get_std_user($session_comp_email,$session_company)
  {
      $this->db->select('id,standard_email,standard_name');
      $this->db->from('standard_users');
	  $this->db->where('status',1);
	  $this->db->where('delete_status',1);
	  $this->db->where('company_email',$session_comp_email);
	  $this->db->where('company_name',$session_company);
      $query = $this->db->get();
      return $query->result_array();
  }	
	
 public function get_renewal_so($session_comp_email,$session_company,$sess_eml=''){
   
      $start_date = date('Y-m-d');
      $thirty_one = strtotime("31 Day"); // Add thirty one days to start date
      $last_date  = date('Y-m-d', $thirty_one); //One Month later date
      $this->db->select('id,org_name,contact_name,subject,renewal_date,saleorder_id,owner');
      
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      if($sess_eml!=""){
      $this->db->where('sess_eml', $sess_eml);
      }
      $this->db->where('delete_status',1);
      $this->db->where('is_renewal',1);
      $this->db->where('renewal_date >=',$start_date);
      $this->db->where('renewal_date <=',$last_date);
      $this->db->where('end_renewal',0);
      $query = $this->db->get('salesorder');
      return $query->result_array();
  
    
  }
  public function update_end_renewal($id)
  {
    $this->db->set('end_renewal',1);
    $this->db->where('id',$id);
    $this->db->update('salesorder');
  }
  
  
  public function check_workflows($session_comp_email,$session_company,$moduleName,$workFlowName){
	//$session_company 	= $this->session->userdata('company_name');
	//$session_comp_email = $this->session->userdata('company_email');
	$this->db->select('*');
	$this->db->where('session_company' , $session_company);
	$this->db->where('session_comp_email' , $session_comp_email);
	$this->db->where('workflow_name' , $workFlowName);
	$this->db->where('module' , $moduleName);
	$query = $this->db->get('workflow');
    $this->db->where('delete_status' , 1);
    if($query->num_rows()>0){
        return $query->row_array();
    }else{
        return false;
    }
  }
  
  
  
  

// PLease write code above this
}
?>
