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
	
 /**
 * Retrieve sales orders that are marked for renewal within the next 31 days for a given company/session.
 * @example
 * $result = $this->Cron_model->get_renewal_so('billing@acme.com', 'ACME Ltd', 'user@acme.com');
 * print_r($result); // sample output: Array ( [0] => Array ( 'id' => '12', 'org_name' => 'ACME Ltd', 'contact_name' => 'John Doe', 'subject' => 'Service Renewal', 'renewal_date' => '2025-01-15', 'saleorder_id' => 'SO123', 'owner' => 'owner@acme.com' ) )
 * @param {string} $session_comp_email - Company contact email used to filter sales orders.
 * @param {string} $session_company - Company identifier used to filter sales orders.
 * @param {string} $sess_eml - Optional session email to further restrict results (default: '').
 * @returns {array} Array of associative arrays representing sales orders matching the renewal criteria.
 */
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
  
  
  /**
  * Check if a workflow exists for the given company, company email, module and workflow name and return its database row.
  * @example
  * $result = $this->Cron_model->check_workflows('admin@acme.com', 'AcmeCorp', 'invoices', 'Invoice Approval');
  * print_r($result); // Example output: Array ( [id] => 12 [workflow_name] => Invoice Approval [module] => invoices [session_company] => AcmeCorp [session_comp_email] => admin@acme.com ... )
  * @param string $session_comp_email - Company email from session used to filter the workflow.
  * @param string $session_company - Company name from session used to filter the workflow.
  * @param string $moduleName - Module name to filter the workflow (e.g. 'invoices', 'sales').
  * @param string $workFlowName - Name of the workflow to check (e.g. 'Invoice Approval').
  * @returns array|false Return associative array of the workflow row if found, otherwise false.
  */
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
