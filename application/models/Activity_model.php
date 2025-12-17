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
  

  /**
  * Retrieve active standard users for the currently logged company (based on session).
  * @example
  * // If session has company_email = 'acme@example.com' and company_name = 'Acme Inc.'
  * $result = $this->Activity_model->get_user();
  * print_r($result);
  * // Example output:
  * // Array (
  * //   [0] => Array ( [id] => 12 [standard_email] => 'user1@acme.com' [standard_name] => 'John Doe' ),
  * //   [1] => Array ( [id] => 13 [standard_email] => 'user2@acme.com' [standard_name] => 'Jane Smith' )
  * // )
  * @returns array Array of associative arrays containing 'id', 'standard_email' and 'standard_name'.
  */
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
  
  /**
  * Get the active admin user record for the currently logged-in company (based on session company_email and company_name).
  * @example
  * $result = $this->Activity_model->get_admin_user();
  * // Sample output:
  * // Array(
  * //   [0] => Array(
  * //     'id' => '1',
  * //     'admin_email' => 'admin@example.com',
  * //     'admin_name' => 'Acme Admin'
  * //   )
  * // );
  * print_r($result);
  * @param void $none - No parameters are accepted.
  * @returns array Array of associative arrays representing the admin user row(s). Returns an empty array if no active admin found.
  */
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
  
  /**
  * Retrieve customer activity records for a given organization, optionally filtered by activity name.
  * @example
  * $result = $this->Activity_model->get_customer_activity(12, 'Purchase');
  * print_r($result); // Example output: Array ( [0] => Array ( ['id']=>45 ['org_id']=>12 ['activity_name']=>'Purchase' ['session_comp_email']=>'info@example.com' ... ) )
  * @param {int} $id - Organization ID to retrieve activities for.
  * @param {string} $activity_name - Optional activity name to filter results.
  * @returns {array} Returns an array of matching customer activity records.
  */
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
  /**
  * Fetch a single activity row from the specified table for the current session/company and given ID.
  * @example
  * $result = $this->Activity_model->getActivity('activities', 'id, title, created_at', 42);
  * print_r($result); // Array ( [id] => 42 [title] => 'Sample Activity' [created_at] => '2025-01-01 10:00:00' )
  * @param {string} $tableName - Name of the database table to query.
  * @param {string|array} $selectClm - Column(s) to select (string of columns or array of column names).
  * @param {int|string} $id - ID value used in the where condition to fetch the specific row.
  * @returns {array|null} Array of row data if found, or null/empty if no matching row exists.
  */
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
  /**
   * Get a standard user record for the current session's company by email.
   * @example
   * $result = $this->Activity_model->getUser('jane.doe@example.com');
   * print_r($result);
   * // Array
   * // (
   * //   [standard_name] => Jane Doe
   * //   [id] => 123
   * //   [standard_email] => jane.doe@example.com
   * // )
   * @param {string} $userEmail - Standard user's email address to look up.
   * @returns {array|null} Return associative array with keys 'standard_name', 'id', 'standard_email' on success, or null/empty array if no matching user is found.
   */
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
  /**
  * Retrieve an admin user record by email for the currently active session company.
  * @example
  * $result = $this->Activity_model->getUserAdmin('admin@example.com');
  * print_r($result); // Array ( [admin_name] => 'John Doe' [id] => 5 [admin_email] => 'admin@example.com' )
  * @param {string} $userEmail - Admin user's email address to look up.
  * @returns {array|null} Return associative array of admin user fields (admin_name, id, admin_email) or null if not found.
  */
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
