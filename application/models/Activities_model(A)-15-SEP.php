<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 class Activities_model extends CI_Model
 {
  /**
  * Count organizations for the current company within a given date or date range (admin only).
  * @example
  * $result = $this->Activities_model->get_all_org('2025-01-01|2025-12-31','filter');
  * print_r($result); // Array ( [total_org] => 5 )
  * @param {{string}} {{$currDate}} - Date string: either a single date 'YYYY-MM-DD' or a range 'YYYY-MM-DD|YYYY-MM-DD'.
  * @param {{string}} {{$fltr}} - Filter flag; use 'filter' to apply the first date as a start date, otherwise exact match for single date.
  * @returns {{array|false}} Return associative array with key 'total_org' containing the count on success, or false if no rows found.
  */
  public function get_all_org($currDate,$fltr)
    {
		$session_comp_email = $this->session->userdata('company_email');
		$sess_eml = $this->session->userdata('email');
		$session_company = $this->session->userdata('company_name');
		$type = $this->session->userdata('type');
		
       if($type == "admin")
        {
		  $this->db->select('count("org_name") as total_org');
		  $this->db->from('organization');
		  $this->db->where('session_company', $session_company);
		  $this->db->where('session_comp_email', $session_comp_email);
		  $this->db->where('delete_status', 1);
		  $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
          $query = $this->db->get();
          if($query-> num_rows() > 0)
          {
            return $query->row_array();
          }
          else 
          {
            return false;
          }
	    }
	}
	
   ////////////To get count of Organization ends //////////////
   
   //////////// To get count of Leads starts //////////
   
    /**
    * Get the total number of leads for the current session's company filtered by date or date range.
    * @example
    * $result = $this->Activities_model->get_leads_status('2025-01-01|2025-01-31','filter');
    * print_r($result); // Array ( [total_leads] => 42 )
    * @param {string} $currDate - Date string or date range separated by "|" (e.g. "2025-01-01" or "2025-01-01|2025-01-31").
    * @param {string} $fltr - Filter flag; use 'filter' to apply a "from" date when a single date is provided, otherwise exact date match.
    * @returns {array|false} Returns associative array with key 'total_leads' on success, or false if no rows found.
    */
    public function get_leads_status($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("name") as total_leads');
      $this->db->from('lead');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	       $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
  }
   /**
   * Retrieve leads from the "lead" table filtered by date, status and current session company.
   * @example
   * $result = $this->Activities_model->leads_status('filter','2025-01-01','open');
   * print_r($result); // sample output: Array ( [0] => Array ( [id] => 123 [lead_status] => open [currentdate] => 2025-01-02 [session_company] => "Acme"] )
   * @param {string} $fltr - Filter mode: use 'filter' to get leads on/after $currentdate, otherwise matches exact date.
   * @param {string} $currentdate - Date string (YYYY-MM-DD) used to filter the lead currentdate field.
   * @param {string} $leadStatus - Optional lead status to filter results (e.g., 'open', 'closed').
   * @returns {array} Array of associative arrays representing matched leads for the current session company.
   */
   public function leads_status($fltr,$currentdate='',$leadStatus='')
   {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    
	
	 if($fltr=='filter'){
		$this->db->where('currentdate >=',$currentdate);
	 }else{
		$this->db->where('currentdate',$currentdate);
	 }
		  
	if($leadStatus!=''){
		$this->db->where('lead_status',$leadStatus);
	}
		
		$this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_comp_email);
		$query =$this->db->get('lead');
		$this->db->where('delete_status',1);
		return $query->result_array();
   }
   //////////////////////////////////////////////////////////////// To get count of Leads ends /////////////////////////////////////////////////////
   
   //////////////////////////////////////////////////////////////// To get count of Opportunities starts ///////////////////////////////////////////
   /**
   * Count opportunities for the current session company filtered by a date or date range (admin-only).
   * @example
   * $result = $this->Activities_model->get_opp_stage('2025-01-01|2025-01-31', 'filter');
   * echo $result['total_opp']; // e.g. 3
   * @param string $currDate - Date string in 'YYYY-MM-DD' or a range 'YYYY-MM-DD|YYYY-MM-DD'. If a range is provided both dates are treated inclusively.
   * @param string $fltr - Filter mode. When $currDate is a single date, use 'filter' to apply ">=" (from that date onward); any other value will match the date exactly.
   * @returns array|false Returns an associative array with key 'total_opp' containing the counted opportunities on success, or false if no matching rows are found or access is not permitted.
   */
   public function get_opp_stage($currDate,$fltr)
   {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("name") as total_opp');
      $this->db->from('opportunity');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
	   $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
   }
   
   
   /**
   * Retrieve the summed initial_total for opportunities in the current company within a given date or date range (admin only).
   * @example
   * // Single date
   * $result = $this->Activities_model->get_opp_stage_count('2025-01-15', ''); 
   * print_r($result); // Example output: false || Array ( [0] => Array ( ['initial_total'] => '12345.67' ) )
   * // Date range using pipe and 'filter' flag
   * $result = $this->Activities_model->get_opp_stage_count('2025-01-01|2025-01-31', 'filter'); 
   * print_r($result); // Example output: Array ( [0] => Array ( ['initial_total'] => '67890.00' ) )
   * @param {string} $currDate - Date string in 'YYYY-MM-DD' or range 'YYYY-MM-DD|YYYY-MM-DD'.
   * @param {string} $fltr - If set to 'filter' and a single date is given, the function treats it as a start date for a range; otherwise used to control date filtering behavior.
   * @returns {array|false|null} Returns result_array containing the summed 'initial_total' on success, false if no matching rows, or null if the current session user is not an admin.
   */
   public function get_opp_stage_count($currDate,$fltr)
   {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select_sum('initial_total');
      $this->db->from('opportunity');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
	   $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->result_array();
      }
      else 
      {
        return false;
      }
    }
   }
   
   
   /**
   * Retrieve opportunity records filtered by date, stage and the current session's company/email.
   * @example
   * $result = $this->Activities_model->opport_status('filter', '2025-12-01', 'Negotiation');
   * echo json_encode($result) // render sample output: [{"id":123,"stage":"Negotiation","currentdate":"2025-12-01","session_company":"Acme Corp","session_comp_email":"info@acme.com"}];
   * @param {{string}} {{$fltr}} - Filter mode. Use 'filter' to apply "currentdate >= $currentdate", otherwise exact match "currentdate == $currentdate".
   * @param {{string}} {{$currentdate}} - Date string used to filter the currentdate column (format e.g. 'YYYY-MM-DD').
   * @param {{string}} {{$oppStatus}} - Opportunity stage to filter (e.g. 'Negotiation', 'Closed Won').
   * @returns {{array}} Return an array of opportunity records (each record is an associative array) matching the filters.
   */
   public function opport_status($fltr,$currentdate='', $oppStatus='')
   {
		
		$session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
		
		if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }	
  	    $this->db->where('stage',$oppStatus);	
  	    $this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_comp_email);
	
		$query =$this->db->get('opportunity');
		$this->db->where('delete_status',1);
		return $query->result_array();
   }
   ////////////////////////////////////////////// To get count of Opportunities ends//////// //////////////////////////////////////////////
   
   ////////////////////////////////////////////////////////////// To get count of Quoatation starts ///////////////////////////////////////////////
   /**
   * Retrieve total quotes and their stage for the current admin session company for a given date or date range.
   * @example
   * $result = $this->Activities_model->get_quote_stage('2025-01-01|2025-01-31','filter');
   * print_r($result); // e.g. Array ( [total_quotes] => 12 [quote_stage] => 'Proposal' )
   * @param {string} $currDate - Date string in 'YYYY-MM-DD' or range 'YYYY-MM-DD|YYYY-MM-DD' format used to filter quotes.
   * @param {string} $fltr - Filter flag; pass 'filter' to treat a single date as a start date for a range.
   * @returns {array|false} Associative array with keys 'total_quotes' and 'quote_stage' on success, or false if no matching rows are found or the caller is not an admin.
   */
   public function get_quote_stage($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("subject") as total_quotes,quote_stage');
      $this->db->from('quote');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
	   $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }  
  }
  /**
  * Retrieve quotes for the current session company filtered by date and quote status.
  * @example
  * $result = $this->Activities_model->quote_status('filter', '2025-12-01', 'approved');
  * print_r($result); // Example output: array(0 => array('id'=>123, 'currentdate'=>'2025-12-05', 'quote_stage'=>'approved', ...))
  * @param string $fltr - 'filter' to apply "currentdate >= $currentdate"; any other value applies "currentdate = $currentdate".
  * @param string $currentdate - Date string used for comparison against the quote.currentdate column (e.g. '2025-12-01').
  * @param string $qtStatus - Quote stage/status to filter by (e.g. 'approved', 'pending').
  * @returns array Returns an array of matching quote records; returns an empty array if no records found. (Note: a delete_status filter is set after the query and therefore is not applied to the returned results.)
  */
  public function quote_status($fltr, $currentdate='',$qtStatus='')
  {
   
   	    $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        
		if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }	
	    $this->db->where('quote_stage',$qtStatus);
        $this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_comp_email);
    	$query =$this->db->get('quote');
    	$this->db->where('delete_status',1);
         return $query->result_array();
  }
 ////////////////////////////////////////////////////////////// To get count of Quoatation end /////////////////////////////////////////////
  
  
  ////////////////////////////////////////////////////////////// To get count of Sales starts ///////////////////////////////////////////////
   /**
   * Get total number of sales (total_sales) for the current company within a given date or date range; only returns data for admin users.
   * @example
   * $result = $this->Activities_model->get_sales_stage('2025-01-01|2025-01-31', 'filter');
   * echo $result['total_sales']; // render some sample output value; e.g. 42
   * @param {string} $currDate - Date string in 'YYYY-MM-DD' or range 'YYYY-MM-DD|YYYY-MM-DD'.
   * @param {string} $fltr - Filter mode; if 'filter' and no range provided, treats $currDate as a start date (>=), otherwise matches exact date.
   * @returns {array|false|null} Returns associative array with key 'total_sales' on success, false if no rows found, or null if current user is not an admin.
   */
   public function get_sales_stage($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("status") as total_sales');
      $this->db->from('salesorder');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
	  $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
  }
  
   /**
   * Retrieve salesorder rows filtered by date, pending percentage and the current session company.
   * @example
   * $result = $this->Activities_model->sales_status('filter', '2025-12-17', '50');
   * print_r($result); // sample output: array( array('id' => 1, 'currentdate' => '2025-12-17', 'total_percent' => '50', ... ) );
   * @param {string} $fltr - 'filter' to use "currentdate >= $currentdate", otherwise exact match on currentdate.
   * @param {string} $currentdate - Date string used to filter the salesorder.currentdate column (e.g. '2025-12-17').
   * @param {string|int} $pending - Value matched against salesorder.total_percent (e.g. '50').
   * @returns {array} Array of associative arrays representing matching salesorder rows.
   */
   public function sales_status($fltr, $currentdate='', $pending='')
    {
        $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
		if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }	
		$this->db->where('total_percent',$pending);
	    $this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_company);
        $query = $this->db->get('salesorder');
	    return $query->result_array();
    } 
    
    /////////  To get count of Sales end //// /////
   
   ///////// /// To get count of Purchaseorders starts /////// /////
   
   /**
   * Get the total number of purchase orders for the current session company within a given date or date range (admin only).
   * @example
   * $result = $this->Activities_model->get_purchase('2025-06-01|2025-06-30', 'filter');
   * echo $result['total_purch']; // e.g. 42
   * @param {string} $currDate - Date string in 'YYYY-MM-DD' for a single day or 'YYYY-MM-DD|YYYY-MM-DD' for a date range.
   * @param {string} $fltr - Filter mode; pass 'filter' to treat $currDate as the start of a range when only one side is provided, otherwise use exact date matching.
   * @returns {array|false} Return associative array with key 'total_purch' containing the count on success, or false if no rows found or caller is not admin.
   */
   public function get_purchase($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("subject") as total_purch');
      $this->db->from('purchaseorder');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
	   $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query->num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
    
  } ////////////////////////////////////////////////////////////// To get count of Purchaseorders end /////////////////////////////////////////////
  
  ////////////////////////////////////////////////////////////// To get count of Task starts ///////////////////////////////////////////////
   /**
   * Get the total count of tasks for the current company optionally within a date or date range.
   * @example
   * $result = $this->Activities_model->get_task('2025-12-01|2025-12-31', 'filter');
   * var_dump($result); // sample output: array('total_task' => '5') or bool(false) if none found
   * @param {string} $currDate - Date string or date range separated by "|" (e.g. 'YYYY-MM-DD' or 'YYYY-MM-DD|YYYY-MM-DD').
   * @param {string} $fltr - Filter indicator; pass 'filter' to treat a single date as a range start, otherwise exact date match is used.
   * @returns {array|false} Returns an associative array with key 'total_task' containing the count on success, or false if no rows found.
   */
   public function get_task($currDate,$fltr)
   {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("task_subject") as total_task');
      $this->db->from('opp_task');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	    $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    } 
  } 
  
  
  
   /**
   * Retrieve tasks for the current session company filtered by date or due flags.
   * @example
   * $result = $this->Activities_model->task_status('filter', '2025-01-10', '');
   * print_r($result); // e.g., Array ( [0] => Array ( 'task_id' => 123, 'task_due_date' => '2025-01-10', 'status' => 'open', ... ) )
   * $today = date('Y-m-d');
   * $result = $this->Activities_model->task_status('', $today, 'todaydue');
   * var_export($result); // e.g., array of tasks due today
   * @param {{string}} {{$fltr}} - 'filter' to use "currentdate >=" comparison; any other value uses equality on currentdate.
   * @param {{string}} {{$currentdate}} - Date string (YYYY-MM-DD) used to filter tasks by currentdate or as base for due calculations.
   * @param {{string}} {{$duedate}} - If 'todaydue' or 'tomarrowdue' filters by task_due_date; otherwise treated as a status filter when empty/other.
   * @returns {{array}} Array of associative arrays representing tasks matching the filters.
   */
   public function task_status($fltr, $currentdate='',$duedate='')
   {
        $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
			
	 
	 if($duedate!='' && $duedate=='todaydue'){
		$this->db->where('task_due_date',$currentdate);
	 }else if($duedate!='' && $duedate=='tomarrowdue'){
	     $date = strtotime("+1 day", strtotime($currentdate));
        $newData= date("Y-m-d", $date);
		$this->db->where('task_due_date',$newData);
	 }else{
	    if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }
	    $this->db->where('status',$duedate); 
	 }
	  $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $query = $this->db->get('opp_task');
	  $this->db->where('delete_status',1);
	  return $query->result_array();  
   }
   
   
  ////////////////////////////////////////////////////////////// To get count of Task end /////////////////////////////////////////////
  
  ////////////////////////////////////////////////////////////// To get count of Meeting get_call starts ///////////////////////////////////////////////
   /**
   * Retrieve the total count of meetings for the current admin session filtered by a date or date range.
   * @example
   * $result = $this->Activities_model->get_meeting('2025-01-01|2025-01-31', '');
   * print_r($result); // Array ( [total_meeting] => 5 )
   * @param {{string}} {{currDate}} - Date string "YYYY-MM-DD" or range "YYYY-MM-DD|YYYY-MM-DD".
   * @param {{string}} {{fltr}} - Use 'filter' to apply a >= comparison for a single date; otherwise exact match or range.
   * @returns {{array|false}} Associative array with key 'total_meeting' containing the meeting count for admin, or false if the user is not an admin.
   */
   public function get_meeting($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("meeting_title") as total_meeting');
      $this->db->from('meeting');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	   $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
    
    
   
    /**
    * Retrieve meetings filtered by date, filter mode and meeting status for the current session company/email.
    * @example
    * $this->load->model('Activities_model');
    * // Example 1: get meetings on or after 2025-12-17 (filter mode)
    * $result = $this->Activities_model->meeting_status('filter', '2025-12-17', '');
    * print_r($result); // sample output: Array ( [0] => Array ( 'id' => 12, 'from_date' => '2025-12-18', 'status' => 'pending', ... ) )
    * // Example 2: get meetings scheduled today
    * $todayMeetings = $this->Activities_model->meeting_status('', '2025-12-17', 'todayMetting');
    * print_r($todayMeetings); // sample output: Array ( ... )
    * @param {string} $fltr - 'filter' to use currentdate >= $currentdate, any other value uses exact date match.
    * @param {string} $currentdate - Date in 'YYYY-MM-DD' format used for filtering (default '').
    * @param {string} $duedate - If 'todayMetting' or 'tomarroeMetting' overrides date filter; otherwise treated as status when $fltr != 'filter' (default '').
    * @returns {array} Return array of meeting rows matching the applied filters (empty array if none).
    */
    public function meeting_status($fltr, $currentdate='',$duedate='')
    {
        $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
			
	 
	 if($duedate!='' && $duedate=='todayMetting'){
		$this->db->where('from_date',$currentdate);
	 }else if($duedate!='' && $duedate=='tomarroeMetting'){
	     $date = strtotime("+1 day", strtotime($currentdate));
        $newData= date("Y-m-d", $date);
		$this->db->where('from_date',$newData);
	 }else{
	    if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }
	    $this->db->where('status',$duedate); 
	 }
	  $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $query = $this->db->get('meeting');
	  $this->db->where('delete_status',1);
	  return $query->result_array();  
   }
   
   
   
	 //////////////////////////////////////
	 /// To get count of call end//////// /////////////////////////////////////
  ////////////////////////////////////////////////////////////// To get count of  Call starts ///////////////////////////////////////////////
   /**
   * Get the total number of calls for the current company within a given date or date range (admin only).
   * @example
   * $result = $this->Activities_model->get_call('2025-12-01|2025-12-31', 'filter');
   * echo $result['total_call']; // 42
   * @param {string} $currDate - Date string in "YYYY-MM-DD" or a range "YYYY-MM-DD|YYYY-MM-DD".
   * @param {string} $fltr - Filter flag; use 'filter' to apply the start date as a lower bound when a single date is provided.
   * @returns {array|false} Returns an associative array with key 'total_call' containing the count for admin sessions, or false for non-admin sessions.
   */
   public function get_call($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("call_purpose") as total_call');
      $this->db->from('create_call');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	    $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
 /**
 * Retrieve call records for a given date with optional filtering and prospecting status.
 * @example
 * // Using the model from a controller
 * $result = $this->Activities_model->call_status('filter', '2025-12-01', 'open');
 * print_r($result); // sample output:
 * // Array
 * // (
 * //     [0] => Array
 * //         (
 * //             [id] => 123
 * //             [currentdate] => 2025-12-01
 * //             [status] => open
 * //             [delete_status] => 1
 * //         )
 * //     [1] => Array
 * //         (
 * //             [id] => 124
 * //             [currentdate] => 2025-12-01
 * //             [status] => open
 * //             [delete_status] => 1
 * //         )
 * // )
 * @param {string} $fltr - Filter mode; use 'filter' to apply "currentdate >= $currentdate", otherwise an exact match is used.
 * @param {string} $currentdate - Date string to filter by (e.g. '2025-12-01').
 * @param {string} $prospecting - Optional status to filter by (e.g. 'open', 'closed'); empty string disables status filtering.
 * @returns {array} Return array of associative arrays representing rows from the create_call table that match the filters.
 */
	public function call_status($fltr, $currentdate='',$prospecting='')
     {
      if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }
    	 
	 if($prospecting!=''){
		$this->db->where('status',$prospecting);
	 }
	 
	  $this->db->where('delete_status',1);
      $query = $this->db->get('create_call');
	  return $query->result_array(); 
   }
     ///////////////////////////////////////////////////////////
	 /// To get count of call end /////////////////////////////////////////////
	 
	 ////////////////////////////////////////////////////////////// To get count of  Vendors starts ///////////////////////////////////////////////
   /**
   * Get the count of vendors for the current session's company (admin only) within a given date or date range.
   * @example
   * $result = $this->Activities_model->get_vendors('2025-01-01|2025-01-31', 'filter');
   * echo $result['total_vendors']; // e.g. 12
   * @param {string} $currDate - Date string in 'YYYY-MM-DD' for single day or 'YYYY-MM-DD|YYYY-MM-DD' for a range.
   * @param {string} $fltr - Filter mode; when 'filter' and a single date is provided it's treated as a start date, otherwise exact date match.
   * @returns {array|false} Returns associative array with key 'total_vendors' on success, or false if the user is not admin or no rows found.
   */
   public function get_vendors($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("name") as total_vendors');
      $this->db->from('vendor');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	   $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
     ////////////////////////////////////////////////////////////// To get count of Vendors end /////////////////////////////////////////////
	 
	 ////////////////////////////////////////////////////////////// To get count of  Proforma invoice starts ///////////////////////////////////////////////
   /**
   * Get the count of proforma invoices (total_pi) for the current company within a given date or date range; only available to admin users.
   * @example
   * $result = $this->Activities_model->get_proforma('2025-01-01|2025-01-31','filter');
   * print_r($result); // Example output: Array ( [total_pi] => 12 )
   * $result = $this->Activities_model->get_proforma('2025-01-15','');
   * var_dump($result); // Example output: array('total_pi' => 3) or bool(false)
   * @param string $currDate - Date string or date range separated by '|' (e.g. 'YYYY-MM-DD' or 'YYYY-MM-DD|YYYY-MM-DD').
   * @param string $fltr - Filter flag; use 'filter' to treat a single date as a lower bound (>=). Otherwise a single date is matched exactly.
   * @returns array|false Returns associative array with key 'total_pi' on success, or false if the session user is not admin or there is no result.
   */
   public function get_proforma($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("page_name") as total_pi');
      $this->db->from('performa_invoice');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	   $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
    
    
    ///////// To get count of Proforma invoice end ///////////
    
    
    ///////////// To get count of  Roles starts //////////////
   /**
   * Count roles for the current session company filtered by a date or date range.
   * @example
   * $result = get_roles('2025-01-01|2025-12-31', 'filter');
   * print_r($result); // e.g. Array ( [total_roles] => 42 )
   * @param {string} $currDate - Single date 'YYYY-MM-DD' or date range 'YYYY-MM-DD|YYYY-MM-DD' used to filter the currentdate column.
   * @param {string} $fltr - Filter mode; use 'filter' to apply '>=' for a single date, otherwise an exact date match is used.
   * @returns {array|false|null} Return associative array ['total_roles' => int] when matching rows are found; false if the session user is not an admin; null if admin but no matching rows found.
   */
   public function get_roles($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("role_name") as total_roles');
      $this->db->from('roles');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	   $currDateExpl=explode("|",$currDate);
		  if(isset($currDateExpl[1])){
    		  $this->db->where('currentdate >=',$currDateExpl[0]);
    		  $this->db->where('currentdate <=',$currDateExpl[1]);
		  }else{
    		  if($fltr=='filter'){
    		      $this->db->where('currentdate >=',$currDateExpl[0]);
    		  }else{
    		    $this->db->where('currentdate',$currDateExpl[0]);
    		  }
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
    
    
    
   /**
   * Get roles from the database optionally filtered by date and role name.
   * @example
   * $result = $this->Activities_model->roles_status('2025-01-01', 'admin');
   * print_r($result); // e.g. Array ( [0] => Array ( [id] => 1 [role_name] => admin [currentdate] => 2025-01-01 [delete_status] => 1 ) )
   * @param {string} $currentdate - Optional date (YYYY-MM-DD) to filter roles by the currentdate column.
   * @param {string} $rolename - Optional role name to filter results (e.g. 'admin').
   * @returns {array} Array of associative arrays representing matching role rows; empty array if no matches.
   */
   public function roles_status($currentdate='',$rolename='')
   {
      if($currentdate!=''){
		$this->db->where('currentdate',$currentdate);	
	   }
	 if($rolename!=''){
		$this->db->where('role_name','Role name');
	  }
      $query = $this->db->get('roles');
	  $this->db->where('delete_status',1);
	  return $query->result_array();  
     }
	 ////////////////////////////////////////////////////////////// To get count of Roles end /////////////////////////////////////////////
	 
	public function get_by_id()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('organization');
		return $query->result_array();
    }
	public function get_by_leads()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('lead');
		return $query->result_array();
    }
	public function lead_status($lead_id,$status)
      {
		$this->db->set('lead_status',$status);
		$this->db->where('lead_id', $lead_id);
		$query = $this->db->get('lead');
		return $query->result_array();
     }
	public function get_by_opport()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('opportunity');
		return $query->result_array();
    }
	public function get_by_quotat()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('quote');
		return $query->result_array();
     }
	 public function get_by_sales()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('salesorder');
		return $query->result_array();
     }
	 public function get_by_task()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('opp_task');
		return $query->result_array();
     } 
	 public function get_by_meeting()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('meeting');
		return $query->result_array();
     }
	 public function get_by_call()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('create_call');
		return $query->result_array();
     }
	 public function get_by_purch()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('purchaseorder');
		return $query->result_array();
     }
	 public function get_by_vendors()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('vendor');
		return $query->result_array();
     }
	 public function get_by_proforma()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('performa_invoice');
		return $query->result_array();
     }
	 public function get_by_roles()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('roles');
		return $query->result_array();
     }
	 ///////Select Date Start///////
	 /////////////////////

 /**
 * Build and apply DataTables query filters to the CodeIgniter query builder for the "organization" table.
 * This private method configures FROM, WHERE, LIKE, grouping and ORDER clauses based on session type (admin/standard),
 * session data (email, company_email, company_name), POST parameters (searchDate, search[value], order) and delete_status.
 * It does not execute the query; it only prepares $this->db for subsequent get() calls.
 * @example
 * // Called inside the model before executing $this->db->get()
 * // Example scenario:
 * // - session type: 'admin'
 * // - session company_email: 'acme@example.com'
 * // - POST['searchDate'] = 'This Week'
 * // - POST['search']['value'] = 'Acme'
 * // - POST['order'][0]['column'] = 1, POST['order'][0]['dir'] = 'asc'
 * $this->_get_datatables_query();
 * $query = $this->db->get(); // returns filtered rows from "organization"
 * // Example result: an array of organization rows matching the search and date constraints.
 * @param {void} none - No parameters; uses session and POST data available in the model.
 * @returns {void} Applies conditions to the $this->db query builder; does not return a value.
 */
	private function _get_datatables_query()
     {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')==='admin')
    {
      $this->db->from('organization');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('currentdate >=',$search_date);
        }
      }
      $this->db->where('delete_status',1);
    }
    elseif($this->session->userdata('type')==='standard')
    {
      $this->db->from('organization');
      $this->db->where('sess_eml',$sess_eml);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('currentdate >=',$search_date);
        }
      }
      $this->db->where('delete_status',1);
    }
    $i = 0;
    foreach ($this->search_by as $item) // loop column
    {
      if($_POST['search']['value']) // if datatable send POST for search
      {
        if($i===0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
          $this->db->or_like($item, $_POST['search']['value']);
        }
        if(count($this->search_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
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
  }
 }
?>