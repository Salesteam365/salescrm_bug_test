<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forecast_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->db->query('SET SESSION sql_mode =
                  REPLACE(REPLACE(REPLACE(
                  @@sql_mode,
                  "ONLY_FULL_GROUP_BY,", ""),
                  ",ONLY_FULL_GROUP_BY", ""),
                  "ONLY_FULL_GROUP_BY", "")');
    }
  var $table = 'opportunity';
  var $sort_by = array(null,'name','org_name','email','mobile','opportunity_id');
  var $search_by = array('name','org_name','email','mobile','opportunity_id');
  var $order = array('id' => 'desc');
  
  
  /**
  * Retrieve summed opportunity totals grouped by owner for a date range and company session.
  * @example
  * $result = $this->Forecast_model->get_forcast('2024-01-01', '2024-01-31', 'self');
  * print_r($result); // e.g. Array ( [0] => stdClass Object ( [owner] => "Alice" [sess_eml] => "alice@example.com" [op_total] => "12500.00" ) )
  * @param {string} $startDate - Start date inclusive filter in YYYY-MM-DD format.
  * @param {string} $endDate - End date inclusive filter in YYYY-MM-DD format.
  * @param {string} $self - Use 'self' to restrict results to the current session user; any other value fetches all owners.
  * @returns {array} Return array of stdClass objects with properties: owner, sess_eml and op_total.
  */
  public function get_forcast($startDate, $endDate,$self)
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
       $this->db->where('currentdate>=',$startDate);
       $this->db->where('currentdate<=',$endDate);
       if($this->session->userdata('type')=='standard' || $self=='self')
       {
        $this->db->where('sess_eml',$sess_eml);
       }
       $this->db->group_by(array('owner'));
    $query = $this->db->get();
    return $query->result();

  }
  
  /**
  * Get forecast totals per user between two dates, optionally filtering by closed-won and/or a specific user email.
  * @example
  * $result = $this->Forecast_model->get_forcast_user('2025-01-01', '2025-01-31', '', 'sales@example.com');
  * echo json_encode($result); // [{"owner":"Alice","sess_eml":"sales@example.com","op_total":"12345.67"}]
  * @param {string} $startDate - Start date (inclusive) of the forecast range in YYYY-MM-DD format.
  * @param {string} $endDate - End date (inclusive) of the forecast range in YYYY-MM-DD format.
  * @param {string} $closeWon - Optional; non-empty value (e.g. '1') limits results to opportunities with stage 'closed won'. Default '' (no stage filter).
  * @param {string} $sessEml - Optional; override session user email to filter results for a specific user. Default ''.
  * @returns {array} Array of objects (rows) containing owner, sess_eml and op_total aggregated per owner.
  */
  public function get_forcast_user($startDate, $endDate,$closeWon='',$sessEml)
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	   if($closeWon!=""){
	       $this->db->where('stage','closed won');
	   }
       $this->db->where('currentdate>=',$startDate);
       $this->db->where('currentdate<=',$endDate);
	   
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();

  }
  
  /**
  * Get summed initial_total (best-case forecast) grouped by owner for the current session/company within a date range.
  * @example
  * $result = $this->Forecast_model->get_forcast_bestCase('2025-01-01', '2025-01-31', 'agent@example.com');
  * print_r($result); // sample output: [ (object) ['owner'=>'Alice','sess_eml'=>'agent@example.com','op_total'=>'12500.00'], (object) ['owner'=>'Bob','sess_eml'=>'agent2@example.com','op_total'=>'8400.00'] ]
  * @param {string} $startDate - Start date (inclusive) in 'YYYY-MM-DD' format.
  * @param {string} $endDate - End date (inclusive) in 'YYYY-MM-DD' format.
  * @param {string} $sessEml - Optional session email to filter results; pass empty string to skip this filter.
  * @returns {array} Array of result objects; each object contains: owner, sess_eml and op_total (summed initial_total).
  */
  public function get_forcast_bestCase($startDate, $endDate,$sessEml){
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	    $this->db->group_start();
	    $this->db->or_where('stage','closed won');
        $this->db->or_where('stage','Ready To Close');
        $this->db->or_where('stage','Negotiation');
        $this->db->group_end();
	 
       $this->db->where('currentdate>=',$startDate);
       $this->db->where('currentdate<=',$endDate);
	   
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  
  /**
  * Get forecast commit totals grouped by owner for a given date range and optional session email filter.
  * @example
  * $startDate = '2025-01-01';
  * $endDate   = '2025-12-31';
  * $sessEml   = 'sales.user@company.com';
  * $result = $this->Forecast_model->get_forcast_Commit($startDate, $endDate, $sessEml);
  * print_r($result); // Example output: [ (object) ['owner'=>'Alice','sess_eml'=>'sales.user@company.com','op_total'=>'15000.00'], ... ]
  * @param {string} $startDate - Start date (inclusive) in 'YYYY-MM-DD' format.
  * @param {string} $endDate - End date (inclusive) in 'YYYY-MM-DD' format.
  * @param {string} $sessEml - Optional session email to filter results (empty string to ignore).
  * @returns {object[]} Return an array of result objects (each object contains owner, sess_eml and op_total).
  */
  public function get_forcast_Commit($startDate, $endDate,$sessEml){
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	    $this->db->group_start();
	    $this->db->or_where('stage','closed won');
        $this->db->or_where('stage','Ready To Close');
        $this->db->group_end();
	 
       $this->db->where('currentdate>=',$startDate);
       $this->db->where('currentdate<=',$endDate);
	   
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  
  
  
  
  /**
  * Get monthly forecast totals grouped by owner for the specified year and month, filtered by the current session company and optionally limited to the current user.
  * @example
  * $result = $this->forecast_model->get_forcast_monthly(2025, 12, 'self');
  * print_r($result); // sample output: [0 => (object) ['owner' => 'alice@example.com', 'sess_eml' => 'alice@example.com', 'op_total' => '12345.67'], ...]
  * @param int $year - Year to filter (e.g., 2025).
  * @param int $month - Month to filter (1-12, e.g., 12).
  * @param string $self - Scope flag: pass 'self' to restrict results to the current session user, otherwise include all owners (e.g., 'self' or 'all').
  * @returns object[]|array Array of stdClass result objects containing owner, sess_eml and op_total (sum of initial_total).
  */
  public function get_forcast_monthly($year, $month,$self)
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       if($self=='self'){
          $this->db->where('sess_eml',$sess_eml); 
       }
       $this->db->where('delete_status',1);
       $this->db->where('YEAR(currentdate)',$year);
       $this->db->where('MONTH(currentdate)',$month);
       $this->db->group_by(array('owner'));
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
    $query = $this->db->get();
    return $query->result();

  }
  
  /**
  * Retrieve monthly forecast totals per user for a given year and month.
  * @example
  * $result = $this->Forecast_model->get_forcast_user_monthly(2025, 7, '1', 'alice@company.com');
  * echo json_encode($result); // [{"owner":"Alice","sess_eml":"alice@company.com","op_total":"15000.00"}, {"owner":"Bob","sess_eml":"bob@company.com","op_total":"12000.00"}]
  * @param {{int}} {{$year}} - Four-digit year to filter the opportunities (e.g., 2025).
  * @param {{int}} {{$month}} - Month number to filter the opportunities (1-12, e.g., 7).
  * @param {{string}} {{$closeWon}} - Optional flag; if non-empty, only include opportunities with stage 'closed won' (e.g., '1' or '').
  * @param {{string}} {{$sessEml}} - Optional user email to restrict results to a specific owner (e.g., 'alice@company.com').
  * @returns {{array}} Array of result objects, each containing owner, sess_eml and op_total for the given month.
  */
  public function get_forcast_user_monthly($year, $month,$closeWon='',$sessEml)
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	   if($closeWon!=""){
	       $this->db->where('stage','closed won');
	   }
       $this->db->where('YEAR(currentdate)',$year);
       $this->db->where('MONTH(currentdate)',$month);
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();

  }
  
  /**
  * Fetch monthly "best case" forecast totals grouped by owner for a given year and month, scoped to the current session's company and optionally to a specific user email.
  * @example
  * $result = $this->Forecast_model->get_forcast_bestCase_monthly(2025, 12, 'sales@example.com');
  * print_r($result); // Example output: [ (object) ['owner' => 'Alice','op_total' => '12345.67'], (object) ['owner' => 'Bob','op_total' => '8901.23'] ]
  * @param {{int}} {{year}} - Year to filter opportunities (four-digit year, e.g., 2025).
  * @param {{int}} {{month}} - Month number (1-12) to filter opportunities (e.g., 12).
  * @param {{string}} {{sessEml}} - Optional session email to restrict results to a specific user; pass empty string to ignore (e.g., 'user@example.com').
  * @returns {{array}} Array of result objects (each object contains owner and op_total) for the requested month and year.
  */
  public function get_forcast_bestCase_monthly($year, $month,$sessEml){
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	    $this->db->group_start();
	    $this->db->or_where('stage','closed won');
        $this->db->or_where('stage','Ready To Close');
        $this->db->or_where('stage','Negotiation');
        $this->db->group_end();
	 
       $this->db->where('YEAR(currentdate)',$year);
       $this->db->where('MONTH(currentdate)',$month);
	   
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  
  /**
  * Get committed forecast totals per owner for a given year and month.
  * @example
  * $result = $this->Forecast_model->get_forcast_Commit_monthly(2025, 12, 'sales@example.com');
  * echo json_encode($result); // [{"owner":"Alice","sess_eml":"sales@example.com","op_total":"12500.00"}]
  * @param int $year - Four-digit year to filter records.
  * @param int $month - Month number (1-12) to filter records.
  * @param string $sessEml - Optional session email to override current session user filter (pass empty string to use session or no extra filter).
  * @returns array Array of result objects aggregated by owner (each object contains owner, sess_eml and op_total).
  */
  public function get_forcast_Commit_monthly($year, $month,$sessEml){
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	    $this->db->group_start();
	    $this->db->or_where('stage','closed won');
        $this->db->or_where('stage','Ready To Close');
        $this->db->group_end();
	 
       $this->db->where('YEAR(currentdate)',$year);
       $this->db->where('MONTH(currentdate)',$month);
	   
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
    /**
     * Retrieve active sales standard users (Sales Person or Sales Manager) for the current session's company.
     * @example
     * $result = $this->Forecast_model->salesStdUser();
     * echo json_encode($result); // [{"id":"12","company_email":"acme@example.com","company_name":"Acme Corp","user_type":"Sales Person","status":"1","name":"John Doe"}, {"id":"15","company_email":"acme@example.com","company_name":"Acme Corp","user_type":"Sales Manager","status":"1","name":"Jane Smith"}]
     * @returns array Array of stdClass objects representing matching users; returns an empty array if no users found.
     */
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
  
  /**
  * Retrieve the forecast quota record for a specific user and financial year from the quota table.
  * @example
  * $result = $this->Forecast_model->get_forcast_quota('sales.user@example.com', '2024-25');
  * print_r($result); // e.g. Array ( [finacial_year] => 2024-25 [quota] => 12000 [jan_month] => 1000 [feb_month] => 1000 [mar_month] => 1000 [apr_month] => 1000 [may_month] => 1000 [jun_month] => 1000 [jul_month] => 1000 [aug_month] => 1000 [sep_month] => 1000 [oct_month] => 1000 [nov_month] => 1000 [dec_month] => 1000 [quat1] => 3000 [quat2] => 3000 [quat3] => 3000 [quat4] => 3000 )
  * @param {string} $user_email - User email used to filter the quota record.
  * @param {string} $financialYr - Financial year to retrieve (e.g. '2024-25').
  * @returns {array|null} Return associative array of quota fields for the matching row, or an empty array/null if no record is found.
  */
  public function get_forcast_quota($user_email,$financialYr){
     $session_comp_email = $this->session->userdata('company_email');
     $session_company 	 = $this->session->userdata('company_name');
	 $this->db->from('quota');
	 $this->db->select('quota.finacial_year,quota.quota,quota.jan_month,quota.feb_month,quota.mar_month,quota.apr_month,quota.may_month,quota.jun_month,quota.jul_month,quota.aug_month,quota.sep_month,quota.oct_month,quota.nov_month,quota.dec_month,quota.quat1,quota.quat2,quota.quat3,quota.quat4');
	// $this->db->join('standard_users','quota.user_email=standard_users.standard_email');
	 $this->db->where('quota.user_email',$user_email);
	 $this->db->where('quota.session_comp_email',$session_comp_email);
     $this->db->where('quota.session_company',$session_company);
     $this->db->where('quota.finacial_year',$financialYr);
	 $this->db->where('quota.delete_status','1');
	 $query = $this->db->get();
     return $query->row_array();
  }
  
    public function createQuota($adddata){
	 $this->db->insert('quota',$adddata); 
	 return $this->db->insert_id(); 
    }
   
   public function exitquotaUser($user_id){
	 $this->db->select('*');
	 $this->db->where('user_email',$user_id);    
	 $query = $this->db->get("quota");
     return $query->row_array();	 
   }
  
 
  

//Please write code above this
}
?>
