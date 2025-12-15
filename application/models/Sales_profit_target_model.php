<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sales_profit_target_model extends CI_Model
{
    
     public function __construct(){
        parent::__construct();
        $this->load->model('Login_model');
        $this->db->query('SET SESSION sql_mode =
                  REPLACE(REPLACE(REPLACE(
                  @@sql_mode,
                  "ONLY_FULL_GROUP_BY,", ""),
                  ",ONLY_FULL_GROUP_BY", ""),
                  "ONLY_FULL_GROUP_BY", "")');
        
     }
  var $table = 'quota';
  var $sort_by = array(null,'subject','org_name','saleorder_id','owner','status');
  var $search_by = array('subject','org_name','saleorder_id','owner','status');
  var $order = array('quota.id' => 'desc');
  
  public function getData($financialYear){
    	$sess_eml = $this->session->userdata('email');
    	$session_comp_email = $this->session->userdata('company_email');
    	$session_company = $this->session->userdata('company_name');
    	$this->db->select('quota.id,quota.finacial_year,quota.quota,quota.profit_quota,standard_users.standard_name,standard_users.standard_email');
    	$this->db->from('quota');
    	$this->db->join('standard_users','quota.user_email=standard_users.standard_email');
    	
    	$this->db->where('quota.finacial_year',$financialYear);
    	$this->db->where('quota.session_comp_email',$session_comp_email);
    	$this->db->where('quota.session_company',$session_company);
    	
    	if($this->input->post('fromDate') && $this->input->post('toDate')){
            $this->db->where('quota.currentdate >=',$this->input->post('fromDate'));
            $this->db->where('quota.currentdate <=',$this->input->post('toDate'));
        }else if($this->input->post('searchDate')){ 
            $search_date = $this->input->post('searchDate');
            if($search_date == "This Week")
            {
              $this->db->where('quota.currentdate >=',date('Y-m-d',strtotime('last monday')));
            }else{
              $this->db->where('quota.currentdate >=',$search_date);
            }
        }
        $this->db->where('quota.delete_status',1);
    	if($this->session->userdata('type') == 'standard') 
        {
    		$this->db->where('quota.user_email',$sess_eml);
    	}
       
        if(isset($_POST['order'])) // here order processing
        {
          $this->db->order_by($this->sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
          $order = $this->order;
          $this->db->order_by(key($order), $order[key($order)]);
        }
        
        $query = $this->db->get();
        // $Q = $this->db->last_query();
        // return $Q;
        return $query->result_array();
      
   }
   
  public function getDataAdmin($financialYear){
    	$sess_eml = $this->session->userdata('email');
    	$session_comp_email = $this->session->userdata('company_email');
    	$session_company = $this->session->userdata('company_name');
    	
    	$this->db->select('quota.id,quota.finacial_year,quota.quota,quota.profit_quota,admin_users.admin_name,admin_users.admin_email');
    	$this->db->from('quota');
    	$this->db->join('admin_users','quota.user_email=admin_users.admin_email');
    	$this->db->where('quota.finacial_year',$financialYear);
    	$this->db->where('quota.session_comp_email',$session_comp_email);
    	$this->db->where('quota.session_company',$session_company);
    	$this->db->where('admin_users.company_email',$session_comp_email);
    	$this->db->where('admin_users.company_name',$session_company);
    	if($this->input->post('fromDate') && $this->input->post('toDate')){
            $this->db->where('quota.currentdate >=',$this->input->post('fromDate'));
            $this->db->where('quota.currentdate <=',$this->input->post('toDate'));
        }else if($this->input->post('searchDate')){ 
            $search_date = $this->input->post('searchDate');
            if($search_date == "This Week")
            {
              $this->db->where('quota.currentdate >=',date('Y-m-d',strtotime('last monday')));
            }else{
              $this->db->where('quota.currentdate >=',$search_date);
            }
        }
        $this->db->where('quota.delete_status',1);
    	$this->db->where('quota.sess_eml',$sess_eml);
        if(isset($_POST['order'])) // here order processing
        {
          $this->db->order_by($this->sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
          $order = $this->order;
          $this->db->order_by(key($order), $order[key($order)]);
        }
        
        $query = $this->db->get();
        return $query->result_array();
      
   }
   
   
   public function getDataForGraph($financialYear){
    	$sess_eml = $this->session->userdata('email');
    	$session_comp_email = $this->session->userdata('company_email');
    	$session_company = $this->session->userdata('company_name');
    	
    	$this->db->select('*');
    	$this->db->from('quota');
    	$this->db->where('finacial_year',$financialYear);
    	$this->db->where('session_comp_email',$session_comp_email);
    	$this->db->where('session_company',$session_company);
    	
    	
        $this->db->where('delete_status',1);
    	if($this->session->userdata('type') == 'standard') 
        {
    		$this->db->where('user_email',$sess_eml);
    	}
       
        if(isset($_POST['order'])) // here order processing
        {
          $this->db->order_by($this->sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
          $order = $this->order;
          $this->db->order_by(key($order), $order[key($order)]);
        }
        
        $query = $this->db->get();
        return $query->result_array();
      
   }
   
   
   
   
   public function getquotbyid($id){
    $sess_eml           = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company    = $this->session->userdata('company_name');
    $this->db->select("*");
    $this->db->from('quota');
    $this->db->where('id',$id); 
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);   
    if($this->session->userdata('type')=='standard'){
      $this->db->where('user_email',$sess_eml);
    }
      $query = $this->db->get();
      return $query->row_array();
    }
   
//     public function getDataSo($userEmail='',$startDate,$endDate){
//       $year = explode('-', $startDate);
//       $month = explode('-', $endDate);
//       // print_r($month[1]); exit();
//       $sess_eml 			= $this->session->userdata('email');
//       $session_comp_email = $this->session->userdata('company_email');
//       $session_company 	= $this->session->userdata('company_name');
	     
//       $this->db->select('SUM(initial_total) as subTotal,SUM(profit_by_user) as profit'); 
//       $this->db->from('salesorder');
//       $this->db->where('session_comp_email',$session_comp_email);
//       $this->db->where('session_company',$session_company);
//       $this->db->where('delete_status',1);
//       $this->db->where('total_percent','0');
//       $this->db->where('YEAR(currentdate)',$year[0]);
//       $this->db->where('MONTH(currentdate)',$month[1]);
//       // $this->db->where('currentdate>=',$startDate);
//       // $this->db->where('currentdate<=',$endDate);
	   
//         if($this->session->userdata('type')=='standard'){
//             $this->db->where('sess_eml',$sess_eml);
//         }
//     	if($userEmail!=""){
//             $this->db->where('sess_eml',$userEmail);
//         }
//         $query = $this->db->get();
//         // return $query->result_array();

//         $data = $this->db->last_query();
//         return $data;
//   }
   
   //new 
    public function getDataSo($userEmail='',$startDate,$endDate,$org=NULL){
      
       $sess_eml 			= $this->session->userdata('email');
       $session_comp_email = $this->session->userdata('company_email');
       $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('SUM(initial_total) as subTotal,SUM(profit_by_user) as profit, org_name'); 
       $this->db->from('salesorder');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
       $this->db->where('total_percent','0');
       $this->db->where('currentdate>=',$startDate);
       $this->db->where('currentdate<=',$endDate);
	   
        if($this->session->userdata('type')=='standard'){
            $this->db->where('sess_eml',$sess_eml);
        }
    	if($userEmail!=""){
            $this->db->where('sess_eml',$userEmail);
        }
      if($org != NULL){
        $this->db->group_by('org_name');
      }
     
        $query = $this->db->get();
        return $query->result_array();
        // $data = $this->db->last_query();
        // return $data;
   }



public function getDataByOrgAndMonth($orgName, $starting_date, $end_date) {

  $sess_eml = $this->session->userdata('email');
  $session_comp_email = $this->session->userdata('company_email');
  $session_company = $this->session->userdata('company_name');

  $this->db->select('*'); 
  $this->db->from('salesorder');
  $this->db->where('session_comp_email',$session_comp_email);
  $this->db->where('session_company',$session_company);
  $this->db->where('delete_status',1);
  $this->db->where('org_name', $orgName);
  $this->db->where('currentdate>=',$starting_date);
  $this->db->where('currentdate<=',$end_date);

   if($this->session->userdata('type')=='standard'){
       $this->db->where('sess_eml',$sess_eml);
   }
 
   $query = $this->db->get();
   return $query->result_array();
}


public function get_PO_Number($orgName, $starting_date, $end_date) {

  $sess_eml = $this->session->userdata('email');
  $session_comp_email = $this->session->userdata('company_email');
  $session_company = $this->session->userdata('company_name');

  $this->db->select('saleorder_id ,org_name ,initial_total ,profit_by_user'); 
  $this->db->from('salesorder');
  $this->db->where('session_comp_email',$session_comp_email);
  $this->db->where('session_company',$session_company);
  $this->db->where('delete_status',1);
  $this->db->where('org_name', $orgName);
  $this->db->where('currentdate>=',$starting_date);
  $this->db->where('currentdate<=',$end_date);

   if($this->session->userdata('type')=='standard'){
       $this->db->where('sess_eml',$sess_eml);
   }
 
   $query = $this->db->get();
   return $query->result_array();
}

public function get_PO_ID($sales_order_ids) {
  // Ensure session variables are set
  $sess_eml = $this->session->userdata('email');
  $session_comp_email = $this->session->userdata('company_email');
  $session_company = $this->session->userdata('company_name');

  // Convert sales_order_ids to an array if it's not already
  if (!is_array($sales_order_ids)) {
      $sales_order_ids = array($sales_order_ids);
  }

  // Start building the database query
  $this->db->select('*'); // Select only purchaseorder_id
  $this->db->from('purchaseorder');
  $this->db->where('purchaseorder.session_comp_email', $session_comp_email);
  $this->db->where('purchaseorder.session_company', $session_company);
  $this->db->where('purchaseorder.delete_status', 1);
  $this->db->where_in('purchaseorder.saleorder_id', $sales_order_ids); // Use where_in for an array of values

  // Add condition for standard type
  if ($this->session->userdata('type') == 'standard') {
      $this->db->where('purchaseorder.sess_eml', $sess_eml);
  }

  // Execute the query
  $query = $this->db->get();
  return $query->result_array();
}











public function getDataSoForAllOrgs($startDate, $endDate, $Allorg_names) {
  // print_r($endDate);die;
  // Retrieve session variables
  $sess_eml = $this->session->userdata('email');
  $session_comp_email = $this->session->userdata('company_email');
  $session_company = $this->session->userdata('company_name');

  // Check if session variables are set
  if (!$sess_eml || !$session_comp_email || !$session_company) {
      // Handle session variables not set
      return array();
  }

  // Check if the organization names array is not empty
  if (empty($Allorg_names)) {
      // Handle empty organization names array
      return array();
  }

  // Initialize an array to store the result for each organization
  $result = array();

  // Loop through each organization name
  foreach ($Allorg_names as $org_name) {
      // Select data from the 'salesorder' table
      $this->db->select('*');
      $this->db->from('salesorder');
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status', 1);
      $this->db->where('total_percent', '0');
      $this->db->where('currentdate >=', $startDate);
      $this->db->where('currentdate <=', $endDate);

      // Filter data for the current organization name
      $this->db->where('org_name', $org_name);

      // Apply additional conditions based on user type
      if ($this->session->userdata('type') == 'standard') {
          $this->db->where('sess_eml', $sess_eml);
      }

      // Execute the query
      $query = $this->db->get();

      // Store the result for the current organization name
      $result[$org_name] = $query->result_array();
  }

  // Return the result
  return $result;
}






   //End new
   
   
  public function salesStdUser(){
     $session_comp_email = $this->session->userdata('company_email');
     $session_company 	= $this->session->userdata('company_name');	   
     $this->db->select('*');
	 $this->db->where('company_email',$session_comp_email);
     $this->db->where('company_name',$session_company);
	 $this->db->where('status','1');
     $this->db->group_start();	
     $this->db->where('user_type','Sales Person');	 
     $this->db->or_where('user_type','Sales Manager');
     $this->db->group_end();
	 $query = $this->db->get("standard_users");
     return $query->result();
  }
  
  public function createQuota($adddata){
	 $this->db->insert('quota',$adddata); 
	 return $this->db->insert_id(); 
  }
    
  public function updateQuota($id,$adddata){
         $this->db->where('id',$id);
    	 $this->db->update('quota',$adddata); 
    	 return $this->db->affected_rows(); 
  }


  public function exitquotaUser($user_id,$finacial_year){
	 $this->db->select('*');
	 $this->db->where('user_email',$user_id);
	 $this->db->where('finacial_year',$finacial_year);
	 $query = $this->db->get("quota");
     return $query->row_array();	 
  }


// PLease write code above this
}
?>
