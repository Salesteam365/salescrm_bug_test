<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Search_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        
        $this->load->model('Login_model');
        
    }
	
	
	
/**
 * Grep DB
 *
 * Completes a text search on a MYSQL databases' tables' data
 * And returns the matching rows from all tables
 * Written for CodeIgniter DB class, but all queries written 
 * Can be fairly easily changed to work in any/no framework 
 * 
 * @package   	CodeIgniter  http://ellislab.com/codeigniter
 * @author	Jamison Valenta	http://jamisonvalenta.com
 * @param	str	Name of the target database
 * @param 	array	Array of Search Terms, Example: 'review.com%' OR 'badtext'
 * @return	array	Search Results
 */

function grep_db($db_name, $search_values)
{
	// Init vars
	$table_fields = array();
	$cumulative_results = array();

	// Pull all table columns that have character data types
	$result = $this->db->query("
		SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE
		FROM  `INFORMATION_SCHEMA`.`COLUMNS` 
		WHERE  `TABLE_SCHEMA` =  '{$db_name}'
		AND `DATA_TYPE` IN ('varchar', 'text')
		")->result_array();
	
	// Build table-keyed columns so we know which to query
	/*$DataArr=array('admin_users','account_details','api_detail','become_partner','blogs','chat','chats','chat_login_details','chat_users','enquiry','external_po','fb_app_detail','licence_detail','mail_config','meta_tag','partner','payment_details','payment_history','plan_module','reports_table','standard_users','std_user_target','superadmin_email_automation','support','team365admin','team365_plan','user_branch','user_restriction','cities','countries','states','email_from_csv','inventory_data');*/
	
	$DataArr=array('customer_activity','contact','create_call','invoices','lead','meeting','opportunity','opp_task','organization','performa_invoice','product','purchaseorder','quote','salesorder','vendor','workflow');
	
	
	foreach ( $result  as $o ) 
	{
		
		if(in_array($o['TABLE_NAME'],$DataArr) ){
			//echo $o['TABLE_NAME']."<br>";
			$table_fields[$o['TABLE_NAME']][] = $o['COLUMN_NAME'];
		}		
	}

	// Build search query to pull the affected rows
	// Search Each Row for matches
	
	
	$data=array();
	foreach($table_fields as $table_name => $fields)
	{
		// Clear search array
		$search_array = array();
		$search_fld = array();
		$columArr=array('sess_eml','session_company','session_comp_email','owner','ownership','contact_owner','lead_owner','host_name');
		// Add a search for each search match
		foreach($fields as $field)
		{
			foreach($search_values as $value) 
			{ 
				if(!in_array($field,$columArr)){
					
					$search_array[] = " `{$field}` LIKE '%{$value}%' ";
					$search_fld[] = "`{$field}`";
				}
			}
		}
		
		// Implode $search_array
		$session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
		$search_string = implode (' OR ', $search_array);
		$fldGet=implode (',', $search_fld);
		
		//echo str_replace("LIKE",',',$search_string);
		
		$query_string = "SELECT ".$fldGet.",`id`,`currentdate` FROM `{$table_name}` WHERE  session_comp_email='".$session_comp_email."' AND session_company='".$session_company."' AND ( {$search_string} )  order by currentdate desc";
		
		//echo $query_string;
		
		//echo "<br><br>";
		
		
		$table_results = $this->db->query($query_string)->result_array();
		$table_results['table_name']=$table_name;

// print_r($table_results);		

// echo "<br><br>";

		$data[]=$table_results;
		$cumulative_results = array_merge($cumulative_results, $table_results);
	}
	
	return $data;
}
	
	
	
// PLease write code above this
}
?>
