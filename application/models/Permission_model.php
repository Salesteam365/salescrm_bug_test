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

/**
* Retrieve all module restriction records for a given user within the current company session.
* @example
* $result = $this->Permission_model->get_all_module(123);
* // Example output when records exist:
* // Array
* // (
* //     [0] => Array
* //         (
* //             [id] => 1
* //             [user_id] => 123
* //             [module] => "dashboard"
* //             [session_company] => "Acme Inc"
* //             [session_comp_email] => "info@acme.com"
* //         )
* // )
* // When no records are found the function returns: false
* @param {int} $userid - User ID to fetch module restriction records for.
* @returns {array|false} Array of user restriction records if found, or false if none exist.
*/
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

/**
 * Check if a specific user has a restriction entry for a given module within the current session company.
 * @example
 * $result = $this->Permission_model->check_permission('invoices', 123);
 * var_export($result); // sample output: array('id' => 45, 'user_id' => 123, 'module_name' => 'invoices', 'session_company' => 'Acme Ltd', 'session_comp_email' => 'info@acme.com', 'delete_status' => 1)
 * @param string $moduleName - Module name to check permission for.
 * @param int $userid - User ID to check permission against.
 * @returns array|false Returns associative array of the matching restriction row if found, or false if none exists.
 */
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