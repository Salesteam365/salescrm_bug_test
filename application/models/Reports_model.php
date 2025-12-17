<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->db->query('SET SESSION sql_mode =REPLACE(REPLACE(REPLACE(
                  @@sql_mode,"ONLY_FULL_GROUP_BY,", ""),",ONLY_FULL_GROUP_BY", ""),"ONLY_FULL_GROUP_BY", "")');
    }
    
    
  //////////// Dashboard Queries Starts  //////////////
  
  //////// To get count of Organization starts //////////////
  /**
  * Get the total number of organizations for the current session/company, filtered by user type and customer type (Customer, Vendor, Both).
  * @example
  * $result = $this->Reports_model->get_all_org();
  * echo $result['total_org']; // e.g. 42
  * @returns {array|null} Return associative array with key 'total_org' containing the count of organizations, or null if no rows found.
  */
  public function get_all_org()
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    $this->db->select('count("org_name") as total_org');
    $this->db->from('organization');
    
    if($type == "admin")
    {
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
    }
    else if($type == "standard")
    {
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml', $sess_eml);
    }
   
    $this->db->where('delete_status', 1);
    $this->db->group_start();
    $this->db->where('customer_type', 'Customer');
    $this->db->or_where('customer_type', 'Vendor');
    $this->db->or_where('customer_type', 'Both');
    $this->db->group_end();
    $query = $this->db->get();
    
    if($query->num_rows() > 0)
    {
      return $query->row_array();
    }
  }
  //////////////////////////////////////////////////////////////// To get count of Organization ends /////////////////////////////////////////////

  //////////////////////////////////////////////////////////////// To get count of Leads starts /////////////////////////////////////////////////
  
  /**
  * Retrieve the total number of non-deleted leads for the current session/company and (if applicable) the logged-in user.
  * @example
  * $result = $this->Reports_model->get_all_leads();
  * // sample output:
  * // array('total_leads' => 42)
  * @param void None - This method accepts no parameters.
  * @returns array|null Associative array with key 'total_leads' containing the count on success, or NULL if no matching rows.
  */
  public function get_all_leads()
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    // $lead_status = "Contacted";
    $this->db->select('count("name") as total_leads');
    $this->db->from('lead');
    if($type == "admin")
    {
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
    }
    else if($type == "standard")
    {
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml', $sess_eml);
    }
    
    // $this->db->where('lead_status',$lead_status);
    $this->db->where('delete_status', 1);
    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
     return $query->row_array();
    }
  }
  //////////////////////////////////////////////////////////////// To get count of Leads ends /////////////////////////////////////////////////////

  //////////////////////////////////////////////////////////////// To get count of Opportunities starts ///////////////////////////////////////////
  /**
  * Get the total number of opportunities for the current session's company/user.
  * @example
  * $result = $this->Reports_model->get_all_opportunities();
  * print_r($result); // e.g. Array ( [total_opp] => 5 )
  * @param void $none - No arguments.
  * @returns array|null Return associative array with key 'total_opp' containing the count of opportunities (filtered by session company/email and user type), or null if no records found.
  */
  public function get_all_opportunities()
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    $this->db->select('count("name") as total_opp');
    $this->db->from('opportunity');
    if($type == "admin")
    {
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
    }
    else if ($type == "standard") 
    {
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);
    }
    
    // $this->db->where('stage!=','Closed Won');
    // $this->db->where('stage!=','Closed Lost');
    $this->db->where('delete_status', 1);
    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      return $query->row_array();
    }
  }
  ////////////////////////////////////////////////////////////// To get count of Opportunities ends //////////////////////////////////////////////

  ////////////////////////////////////////////////////////////// To get count of Quoatation starts ///////////////////////////////////////////////
  /**
  * Get the count of all non-closed and non-deleted quotations for the current session user/company.
  * @example
  * $this->load->model('Reports_model');
  * $result = $this->Reports_model->get_all_quotation();
  * print_r($result); // Example output: Array ( [total_quotes] => 5 )
  * @returns array|null Return associative array with key 'total_quotes' containing the count of matching quotes, or null if no rows found.
  */
  public function get_all_quotation()
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata("type");
    $this->db->select('count("subject") as total_quotes');
    $this->db->from('quote');
    if($type == "admin")
    {
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
    }
    else if ($type == "standard") 
    {
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);
    }
   
    $this->db->where('quote_stage!=','Closed Won');
    $this->db->where('quote_stage!=','Closed Lost');
    $this->db->where('delete_status', 1);
    $query = $this->db->get();
    
    if($query->num_rows() > 0)
    {
      return $query->row_array();
    }
  }
  ////////////////////////////////////////////////////////////// To get count of Opportunities starts /////////////////////////////////////////////
  
  
   /**
   * Retrieve the top 3 users by profit for the current month for the active session company.
   * @example
   * $this->load->model('Reports_model');
   * $result = $this->Reports_model->highestTargetGetter();
   * // Sample output (array of stdClass objects):
   * // [
   * //   (object)[
   * //     "standard_name" => "Jane Smith",
   * //     "sales_quota" => "60000",
   * //     "profit_quota" => "10000",
   * //     "for_month" => "2025-12-01",
   * //     "status" => "1",
   * //     "sub_totals" => "55000.00",
   * //     "after_discount" => "54000.00",
   * //     "profituser" => "12000.00"
   * //   ],
   * //   (object)[ ... ],
   * //   (object)[ ... ]
   * // ]
   * @returns {array} Array of result objects (stdClass) containing fields: standard_name, sales_quota, profit_quota, for_month, status, sub_totals, after_discount, profituser.
   */
   public function highestTargetGetter()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
    $this->db->select('standard.standard_name,std_user_target.sales_quota,std_user_target.profit_quota,std_user_target.for_month,std_user_target.status');
	
    $this->db->from("std_user_target");
    $this->db->join('standard_users as standard','std_user_target.std_user_id=standard.id');
    $this->db->select_sum('so.sub_totals');
    $this->db->select_sum('so.after_discount');
    $this->db->select_sum('so.profit_by_user','profituser');
    $this->db->join('salesorder as so','standard.standard_email=so.sess_eml');
    $this->db->join('purchaseorder as PO','PO.saleorder_id=so.saleorder_id');
    $this->db->where('so.delete_status',1);
    $this->db->where('PO.delete_status',1);
    $this->db->where('so.session_company',$session_company);
    $this->db->where('so.session_comp_email',$session_comp_email);
    $this->db->where('so.status','Approved');
    $this->db->where('std_user_target.status',"1");
    $this->db->where('std_user_target.for_month',date('Y-m-01'));
    $a_date = date("Y-m-01");
    $lastday=date("Y-m-t", strtotime($a_date)); 
    $this->db->where('PO.currentdate>=',$a_date);
    $this->db->where('PO.currentdate<=',$lastday);
    $this->db->group_by('so.owner');
    $this->db->order_by('profituser','desc');
    $this->db->limit('3');
    $query = $this->db->get();
    //return $this->db->last_query();
    return $query->result();
   
  }
  
  
  /**
   * Get the top 3 users (admins) by profit for the current month within the logged-in company's scope.
   * This method aggregates sales and profit from salesorder and purchaseorder joined with std_user_target and admin_users,
   * filters by current month, approved orders and active targets, then returns the top 3 owners ordered by profit.
   * @example
   * $result = $this->Reports_model->highestTargetGetterAdmin();
   * // Sample output (array of stdClass objects):
   * // [
   * //   (object)[
   * //     'admin_name'    => 'John Doe',
   * //     'sales_quota'   => '10000',
   * //     'profit_quota'  => '2000',
   * //     'for_month'     => '2025-12-01',
   * //     'status'        => '1',
   * //     'sub_totals'    => '15000.00',
   * //     'after_discount'=> '14500.00',
   * //     'profituser'    => '3500.00'
   * //   ],
   * //   (object)[ ... ],
   * //   (object)[ ... ]
   * // ]
   * @returns array Array of stdClass objects representing the top 3 users with aggregated sales/profit metrics for the current month.
   */
  public function highestTargetGetterAdmin()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
    $this->db->select('admin.admin_name,std_user_target.sales_quota,std_user_target.profit_quota,std_user_target.for_month,std_user_target.status');
	
    $this->db->from("std_user_target");
    $this->db->join('admin_users as admin','std_user_target.std_user_id=admin.id');
    $this->db->select_sum('so.sub_totals');
    $this->db->select_sum('so.after_discount');
    $this->db->select_sum('so.profit_by_user','profituser');
    $this->db->join('salesorder as so','admin.admin_email=so.sess_eml');
    $this->db->join('purchaseorder as PO','PO.saleorder_id=so.saleorder_id');
    $this->db->where('so.delete_status',1);
    $this->db->where('PO.delete_status',1);
    $this->db->where('so.session_company',$session_company);
    $this->db->where('so.session_comp_email',$session_comp_email);
    $this->db->where('so.status','Approved');
    $this->db->where('std_user_target.status',"1");
    $this->db->where('std_user_target.for_month',date('Y-m-01'));
    $a_date = date("Y-m-01");
    $lastday=date("Y-m-t", strtotime($a_date)); 
    $this->db->where('PO.currentdate>=',$a_date);
    $this->db->where('PO.currentdate<=',$lastday);
    $this->db->group_by('so.owner');
    $this->db->order_by('profituser','desc');
    $this->db->limit('3');
    $query = $this->db->get();
    //return $this->db->last_query();
    return $query->result();
   
  }
  
  /**
  * Retrieve the logged-in user's target and aggregated sales/profit totals for the current month.
  * @example
  * $result = $this->Reports_model->TargetGetterUser();
  * echo json_encode($result); // Example output: [{"standard_name":"Jane Smith","sales_quota":"10000","profit_quota":"2000","for_month":"2025-12-01","status":"1","sub_totals":"9500","after_discount":"9000","profit_by_user":"1200"}];
  * @param void $none - This method does not accept any arguments; it uses session data internally.
  * @returns array Array of result objects containing standard_name, sales_quota, profit_quota, for_month, status, sub_totals, after_discount and profit_by_user.
  */
  public function TargetGetterUser(){

    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $sess_eml = $this->session->userdata('email');
    $this->db->select('standard.standard_name,std_user_target.sales_quota,std_user_target.profit_quota,std_user_target.for_month,std_user_target.status');
    $this->db->from("std_user_target");
    $this->db->join('standard_users as standard','std_user_target.std_user_id=standard.id');
    $this->db->select_sum('so.sub_totals');
    $this->db->select_sum('so.after_discount');
    $this->db->select_sum('so.profit_by_user');
    $this->db->join('salesorder as so','standard.standard_email=so.sess_eml');
    $this->db->join('purchaseorder as PO','PO.saleorder_id=so.saleorder_id');
    $this->db->where('so.delete_status',1);
    $this->db->where('PO.delete_status',1);
    $this->db->where('so.session_company',$session_company);
    $this->db->where('so.session_comp_email',$session_comp_email);
    $this->db->where('so.sess_eml',$sess_eml);
    $this->db->where('so.status','Approved');
    $this->db->where('std_user_target.status',"1");
    $this->db->where('std_user_target.for_month',date('Y-m-01'));
    $a_date = date("Y-m-01");
    $lastday=date("Y-m-t", strtotime($a_date)); 
    $this->db->where('PO.currentdate>=',$a_date);
    $this->db->where('PO.currentdate<=',$lastday);
    $this->db->group_by('so.owner');
    $this->db->limit('1');
    $query = $this->db->get();
    //return $this->db->last_query();
    return $query->result();

}
  
  //////////////// To get profit graph starts(Admin) //////////////
  
  
  ##old function before using service todays###
  /**
  * Retrieve aggregated profit data grouped by owner to build the profit graph.
  * This method queries salesorder and purchaseorder tables, applies session and optional POST filters
  * (searchUser and searchDate), aggregates sums (after_discount_po, after_discount, total_orc) and groups results by owner.
  * @example
  * $this->load->model('Reports_model');
  * $result = $this->Reports_model->get_profit_graph_1();
  * var_export($result);
  * // Sample output on success:
  * // array(
  * //   0 => (object) array(
  * //     'owner' => 'Owner A',
  * //     'after_discount_po' => '1500.00',
  * //     'after_discount' => '2000.00',
  * //     'total_orc' => '2200.00',
  * //     // ... other selected fields from SO and PO
  * //   ),
  * //   ...
  * // )
  * @param void none - This method accepts no arguments; it uses session and POST data for filtering.
  * @returns array|false Array of result objects grouped by owner on success, or false if no records found.
  */
  public function get_profit_graph_1()
  {
		$sess_eml = $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
		if($this->session->userdata('type')=='admin')
		{
			$this->db->select('SO.*,PO.id,PO.purchaseorder_id,PO.sub_total as PO_subtotal,PO.saleorder_id as PO_saleorder_id,PO.after_discount_po');
			$this->db->select_sum('PO.after_discount_po');
			$this->db->select_sum('SO.after_discount');
			$this->db->select_sum('SO.total_orc');
			$this->db->from('salesorder as SO');
			$this->db->join('purchaseorder as PO', 'SO.saleorder_id = PO.saleorder_id AND SO.owner = PO.so_owner');
			$this->db->where('SO.session_comp_email',$session_comp_email);
			$this->db->where('SO.session_company',$session_company);
			$this->db->where('PO.session_comp_email',$session_comp_email);
			$this->db->where('PO.session_company',$session_company);
			$this->db->where('SO.delete_status',1);
			$this->db->where('SO.status','Approved');
			$this->db->where('PO.delete_status',1);
			if($this->input->post('searchUser'))
			{ 
				$search_user = $this->input->post('searchUser');
				$this->db->where('SO.sess_eml',$search_user);
			}
			if($this->input->post('searchDate'))
			{ 
				$search_date = $this->input->post('searchDate');
				if($search_date == "This Week")
				{
				  $this->db->where('SO.currentdate >=',date('Y-m-d',strtotime('last monday')));
				}
				else
				{
				  $this->db->where('SO.currentdate >=',$search_date);
				}
			}else{
				$y = strtotime('-1day');
				$x = date('d',$y);
				$w = strtotime('-'.$x.'days');
				$this->db->where('SO.currentdate >=',date('Y-m-d', $w));
				$this->db->where('PO.currentdate >=',date('Y-m-d', $w));
			}
		  
		}
		
		$this->db->group_by('SO.owner');
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		if($query -> num_rows() > 0)
		{
		  return $query->result();
		}
		else
		{
		  return false;
		}
  }
  
   /**
   * Retrieve aggregated profit metrics grouped by sales owner for the current session/company, with optional POST filters (searchUser, searchDate, profitYear, profitMoth).
   * @example
   * $this->load->model('Reports_model');
   * $result = $this->Reports_model->get_profit_graph();
   * print_r($result); // sample output:
   * // Array (
   * //   [0] => stdClass Object (
   * //       [owner] => "jane.doe@example.com",
   * //       [after_discount] => "1200.00",
   * //       [profit_by_user] => "300.00",
   * //       [initial_total] => "1500.00",
   * //       [total_orc] => "1500.00"
   * //   )
   * // )
   * @param void $none - No parameters are accepted by this method.
   * @returns array|false Returns an array of stdClass result objects (sums grouped by SO.owner) on success, or false if no rows found.
   */
   public function get_profit_graph()
   {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
      $this->db->select('SO.owner');
      $this->db->select_sum('SO.after_discount');
      $this->db->select_sum('SO.profit_by_user');
      $this->db->select_sum('SO.initial_total');
      $this->db->select_sum('SO.total_orc');
      $this->db->from('salesorder as SO');
      $this->db->where('SO.session_comp_email',$session_comp_email);
      $this->db->where('SO.session_company',$session_company);
      $this->db->where('SO.delete_status',1);
      //$this->db->where('SO.status','Approved');
      
      $this->db->where('SO.total_percent','0');
      if($this->session->userdata('type')=='standard')
      {
         $this->db->where('SO.sess_eml',$sess_eml); 
      }else if($this->input->post('searchUser'))
      { 
        $search_user = $this->input->post('searchUser');
        $this->db->where('SO.sess_eml',$search_user);
      }
      
     
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('SO.currentdate >=',date('Y-m-d',strtotime('last monday')));
        }else if($search_date=="last month")
        {
            $currentdate = date("Y-m-d");
            $first_day = '01';
            $last_day = '31';
            $last_month = date("Y.m", strtotime("-1 month"));
            $start_date = $last_month.'.'.$first_day;
            $end_date = $last_month.'.'.$last_day;
            $this->db->where('SO.currentdate >=', $start_date);
            $this->db->where('SO.currentdate <=', $end_date);
        }else
        {
          $this->db->where('SO.currentdate >=',$search_date);
        }
      }else{
          if($this->input->post('profitYear'))
          { 
            $search_yrs = $this->input->post('profitYear');
            $this->db->where('YEAR(SO.currentdate)',$search_yrs);
          }
          if($this->input->post('profitMoth'))
          { 
            $search_Mnth = $this->input->post('profitMoth');
            $this->db->where('MONTH(SO.currentdate)',$search_Mnth);
          }
          else
          {
          	$this->db->where('SO.currentdate>=',date('Y-m-01'));
          }
     }
      
    $this->db->group_by('SO.owner');
    $query = $this->db->get();
    // $data = $this->db->last_query();
    // return $data;
    if($query -> num_rows() > 0)
    {
      return $query->result();
    }
    else
    {
      return false;
    }
  }
  
  
  /**
  * Retrieve distinct year(s) or month(s) from the salesorder.currentdate column.
  * @example
  * $result = $this->Reports_model->get_DateYear('year');
  * var_export($result); // e.g. array( (object) ['month' => '2024'], (object) ['month' => '2023'] );
  * $result = $this->Reports_model->get_DateYear('month', 2023);
  * var_export($result); // e.g. array( (object) ['month' => 1], (object) ['month' => 2], ..., (object) ['month' => 12] );
  * @param {string} $value - 'year' to return distinct years; any other value returns months.
  * @param {int|string|null} $dataVl - Optional year filter when requesting months (e.g. 2023). Pass null or empty to omit filter.
  * @returns {array} Return array of result objects from the query; each object has a 'month' property (year number when requesting years, month number when requesting months).
  */
  public function get_DateYear($value='',$dataVl='')
{
	if($value=='year'){
		$this->db->select('YEAR(currentdate) as month');
		$this->db->order_by("month desc");
	}else{
		$this->db->select('MONTH(currentdate) as month');
		if(!empty($dataVl)){
			$this->db->where('YEAR(currentdate)',$dataVl);
		}
		$this->db->order_by("month asc");
	}
	$this->db->distinct();
    $this->db->from("salesorder");
    
    $query = $this->db->get();
    return $query->result();
}


  
  
  /////////////////////// To get profit graph ends(Admin) //////////////////////////////

  ////////////////////////// To get profit graph Starts(User) ///////////////////////////
  /**
  * Retrieve aggregated sales totals grouped by sales owner for the current company user session.
  * @example
  * $result = $this->Reports_model->get_all_sales_by_user();
  * // Example returned value (when rows exist):
  * // [
  * //   { "owner":"alice@example.com", "salesorder_id":"101", "total_orc":"2500.00", "after_discount_po":"2400.00", "after_discount":"2450.00" },
  * //   { "owner":"bob@example.com",   "salesorder_id":"102", "total_orc":"1800.00", "after_discount_po":"1700.00", "after_discount":"1725.00" }
  * // ]
  * @param void $none - No arguments are required.
  * @returns array|false Returns an array of result objects (grouped by owner with summed fields) or FALSE if no records found.
  */
  public function get_all_sales_by_user()
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'days');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $status = "Approved";
    $this->db->select('SO.owner,SO.id as salesorder_id,SO.total_orc');
    $this->db->select_sum('PO.after_discount_po');
    $this->db->select_sum('SO.after_discount');
    $this->db->from('purchaseorder as PO');
    $this->db->join('salesorder as SO','PO.saleorder_id=SO.saleorder_id AND PO.so_owner = SO.owner','inner');
    $this->db->where('SO.session_company',$session_company);
    $this->db->where('SO.session_comp_email',$session_comp_email);
    $this->db->where('SO.sess_eml',$sess_eml);
    $this->db->where('SO.status',$status);
    $this->db->where('SO.currentdate >=',date('Y-m-d', $w));
    $this->db->group_by('SO.owner');
    //get records
    $query = $this->db->get();
    //return fetched data
    return ($query->num_rows() > 0)?$query->result():FALSE;
  }
  //////////////////////////////////////////////////////////////// To get profit graph ends(User) //////////////////////////////////

  //////////////////////////////////////////////////////////////// Sort profit graph starts /////////////////////////////////////////
  /**
   * Retrieve aggregated sales entries on or after a given date (or for "last month") for admin or standard users.
   * @example
   * $result = $this->Reports_model->get_all_sales_by_date('last month', 'admin');
   * // or for a user:
   * $result = $this->Reports_model->get_all_sales_by_date('2025-11-01', 'standard');
   * var_dump($result); // e.g. array of rows with summed after_discount and total_orc, or FALSE if none for standard.
   * @param string $date - Start date in "Y-m-d" format, or the string "last month" to query the previous month.
   * @param string $type - User type: "admin" to aggregate per company session (sess_eml), "standard" to aggregate per owner.
   * @returns array|object|false|null Returns aggregated result rows: admin returns array (result_array) when rows exist, standard returns array of objects (result) or FALSE if no records; admin may return NULL if no rows found.
   */
  public function get_all_sales_by_date($date,$type)
  {
    /////////////////////////////////////////////// Sorting for Admin //////////////////////////////////////////////////////////////
    if($type == "admin")
    {
      $session_company = $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
      $sess_eml = $this->session->userdata('sess_eml');
      $status = "Approved";
      $this->db->select('*');
      $this->db->select_sum('after_discount');
      $this->db->select_sum('total_orc');
      $this->db->from('salesorder');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('status',$status);
      if($date=="last month")
      {
        $currentdate = date("Y-m-d");
        $first_day = '01';
        $last_day = '31';
        $last_month = date("Y.m", strtotime("-1 month"));
        $start_date = $last_month.'.'.$first_day;
        $end_date = $last_month.'.'.$last_day;
        $this->db->where('currentdate >=', $start_date);
        $this->db->where('currentdate <=', $end_date);
      }
      else
      {
        $this->db->where('currentdate >=',$date);
      }
      
      $this->db->where('delete_status',1);
      $this->db->group_by('sess_eml');
      $query = $this->db->get();
      //echo $this->db->last_query();die;
      if($query->num_rows() > 0)
      {
        return $query->result_array();
      }
    }
    /////////////////////////////////////////////// Sorting for Admin //////////////////////////////////////////////////////////////

    /////////////////////////////////////////////// Sorting for Users ////////////////////////////////////////////////////////////
    else if($type == "standard")
    {
      $session_company = $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
      $sess_eml = $this->session->userdata('email');
      $status = "Approved";
      $this->db->select('SO.owner,SO.id as salesorder_id,SO.total_orc');
      $this->db->select_sum('PO.after_discount_po');
      $this->db->select_sum('SO.after_discount');
      $this->db->from('purchaseorder as PO');
      $this->db->join('salesorder as SO','PO.saleorder_id=SO.saleorder_id','left');
      $this->db->where('SO.session_company',$session_company);
      $this->db->where('SO.session_comp_email',$session_comp_email);
      $this->db->where('SO.sess_eml',$sess_eml);
      $this->db->where('SO.status',$status);
      if($date=="last month")
      {
        $currentdate = date("Y-m-d");
        $first_day = '01';
        $last_day = '31';
        $last_month = date("Y-m", strtotime("-1 month"));
        $start_date = $last_month.'.'.$first_day;
        $end_date = $last_month.'.'.$last_day;
        $this->db->where('SO.currentdate >=', $start_date);
        $this->db->where('SO.currentdate <=', $end_date);
      }
      else
      {
        $this->db->where('SO.currentdate >=',$date);
      }
      $this->db->group_by('SO.owner');
      //get records
      $query = $this->db->get();
      //return fetched data
      return ($query->num_rows() > 0)?$query->result():FALSE;
    }
    /////////////////////////////////////////////// Sorting for Users /////////////////////////////////////////////////////////////
    
  }
  //////////////////////////////////////////////// After Discount value By SO Owner //////////////////////////////////////////////
  /**
  * Get summed after-discount purchase order totals for a given sales order owner within the current month (from the first day up to yesterday).
  * @example
  * $result = $this->Reports_model->get_after_discount_po('owner@example.com');
  * // Example output (sample values):
  * // Array ( ['so_owner'] => 'owner@example.com', ['after_discount_po'] => '1234.56', ... )
  * @param {string} $so_owner - Sales order owner identifier (e.g. username or email).
  * @returns {array|null} Return associative array containing purchase order fields and summed after_discount_po grouped by so_owner, or NULL if no matching records.
  */
  public function get_after_discount_po($so_owner)
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'days');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $status = "Approved";
    $this->db->select('PO.*');
    $this->db->select_sum('after_discount_po');
    $this->db->from('purchaseorder as PO');
    $this->db->join('salesorder as SO','PO.saleorder_id=SO.saleorder_id AND SO.status ="Approved"','inner');
    $this->db->where('SO.session_company',$session_company);
    $this->db->where('SO.session_comp_email',$session_comp_email);
    $this->db->where('PO.currentdate >=',date('y-m-d', $w));
    $this->db->where('SO.currentdate >=',date('y-m-d', $w));
    $this->db->where('PO.delete_status',1);
    $this->db->where('SO.delete_status',1);
    $this->db->where('PO.so_owner',$so_owner);
    $this->db->group_by('PO.so_owner');
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    if($query -> num_rows() > 0)
    {
      return $query->row_array();
    }
  }
  //////////////////////////////////////////////// After Discount value By SO Owner /////////////////////////////////////////////////////

  //////////////////////////////////////////////////////////////// Sort profit graph ends //////////////////////////////////////////////

  //////////////////////////////////////////////////////////////// To get Estimate sales Satrts ////////////////////////////////////////
  /**
  * Get aggregated estimates (sum of sub_totalq) grouped by owner for quotes marked "Closed Won" within the session company since the computed start date (calculated relative to the current day).
  * @example
  * $result = $this->Reports_model->get_all_estimate('admin');
  * // Sample output:
  * // [
  * //   (object) ['owner' => 'Alice', 'sub_totalq' => '12500.00'],
  * //   (object) ['owner' => 'Bob',   'sub_totalq' => '9800.50'],
  * // ]
  * @param {string} $type - User type: 'admin' returns results for all owners in the company; 'standard' returns results only for the logged-in user.
  * @returns {array} Array of stdClass objects containing aggregated results (typically with properties 'owner' and summed 'sub_totalq'), or an empty array if no records are found.
  */
  public function get_all_estimate($type)
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'days');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $quote_stage = "Closed Won";
    if($type=="admin")
    {
      $this->db->select('*');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('quote_stage',$quote_stage);
      $this->db->where('currentdate >=',date('Y-m-d', $w));
      $this->db->select_sum('sub_totalq');
      $this->db->group_by('owner');
      $this->db->from('quote');
      $this->db->order_by('sub_totalq','Desc');
      //get records
      $query = $this->db->get();
      //return fetched data
      return $query->result();
    }
    else if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->select('owner');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('sess_eml',$sess_eml);
      $this->db->where('quote_stage',$quote_stage);
      $this->db->where('currentdate >=',date('Y-m-d', $w));
      $this->db->select_sum('sub_totalq');
      $this->db->from('quote');
      $this->db->order_by('sub_totalq','Desc');
      //get records
      $query = $this->db->get();
      //return fetched data
      return $query->result();
    }
  }

  //////////////////////////////////////////////////////////////// To get Estimate sales Ends ///////////////////////////////////////

  //////////////////////////////////////////////////////////////// Sort Estimate Garph Sarts ////////////////////////////////////////
  /**
  * Get summed estimates grouped by owner for quotes in the "Closed Won" stage, filtered by date and user type.
  * @example
  * $result = $this->Reports_model->get_all_estimate_by_date('last month', 'admin');
  * print_r($result); // e.g. Array ( [0] => stdClass Object ( [owner] => 'Alice' [sub_totalq] => '12345.00' ) )
  * @param string $date - Date filter. Use the literal 'last month' to select the previous calendar month, or provide a start date string to filter records where currentdate >= $date.
  * @param string $type - User scope type: 'admin' for company-wide results, 'standard' for company + current user results.
  * @returns array Returns an array of stdClass objects representing grouped results (includes fields such as 'owner' and aggregated 'sub_totalq').
  */
  public function get_all_estimate_by_date($date,$type)
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $quote_stage = "Closed Won";
    $this->db->select('*');
    if($type == "admin")
    {
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
    }
    else if($type == "standard")
    {
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('sess_eml', $sess_eml);
    }
    
    $this->db->where('quote_stage',$quote_stage);
    if($date=="last month")
    {
      $currentdate = date("y-m-d");
      $first_day = '01';
      $last_day = '31';
      $last_month = date("y.m", strtotime("-1 month"));
      $start_date = $last_month.'.'.$first_day;
      $end_date = $last_month.'.'.$last_day;
      $this->db->where('currentdate >=', $start_date);
      $this->db->where('currentdate <=', $end_date);
    }
    else
    {
      $this->db->where('currentdate >=',$date);
    }
    $this->db->select_sum('sub_totalq');
    $this->db->group_by('owner');
    $this->db->from('quote');
    $this->db->order_by('sub_totalq','Desc');
    //get records
    $query = $this->db->get();
    //return fetched data
    return $query->result();
    
  }
  ////////// Sort Estimate Garph Ends ///////////////


  ///////////////// Get Top Opportunities Starts ///////////////////
  /**
  * Retrieve the top 10 opportunities by user since the start of the current month, excluding "closed won" and "closed lost".
  * @example
  * // For a standard user (returns rows for the logged-in user)
  * $result = $this->Reports_model->get_top_opp_by_user('standard');
  * // Sample output (array of stdClass objects) :
  * // [
  * //   0 => (object) ['sub_total' => '1500.00', 'owner' => 'alice@example.com', 'currentdate' => '2025-12-01'],
  * //   1 => (object) ['sub_total' => '1200.00', 'owner' => 'alice@example.com', 'currentdate' => '2025-12-10'],
  * // ]
  *
  * // For an admin user (returns aggregated SUM(sub_total) grouped by owner)
  * $result = $this->Reports_model->get_top_opp_by_user('admin');
  * // Sample output (array of stdClass objects) :
  * // [
  * //   0 => (object) ['sub_total' => '2700.00', 'owner' => 'alice@example.com'],
  * //   1 => (object) ['sub_total' => '1800.00', 'owner' => 'bob@example.com'],
  * // ]
  * @param string $type - Type of query to run: "standard" for the current user's rows, "admin" for aggregated results by owner.
  * @returns array|false Array of result objects on success (each row as stdClass), or false if no records found.
  */
  public function get_top_opp_by_user($type)
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'day');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $stage = "closed won";
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->select('sub_total,owner,currentdate');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);
     
    }
    else if($type=="admin")
    {
      $this->db->select('SUM(sub_total) as sub_total,owner');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->group_by('owner');
    }
      $this->db->where('stage !=',$stage);
      $this->db->where('stage !=',"closed lost");
      $this->db->where('currentdate >=',date('Y-m-d', $w));
      $this->db->order_by('sub_total','desc');
      $this->db->limit('10');
      //fetch records
      $query = $this->db->get('opportunity');
      // check records
      if($query->num_rows() > 0)
      {
        //return fetched data
        return $query->result();
      }
      else
      {
        return false;
      }
    
  }
  /////////////////////////////////////////////////////////////// Get Top Opportunities Ends ///////////////////////////////////

  ////////////////////////////////////////////////////////////// Sort Opportunity Starts ////////////////////////////////////////
  /**
  * Get top opportunities by date for 'standard' or 'admin' view, limited to top 10 owners ordered by sub_total.
  * @example
  * $result = $this->Reports_model->get_top_opp_by_date('admin', '', '2025-01-01', '2025-06-30');
  * // sample returned value (array of objects):
  * // [ (object) ['owner' => 'Alice', 'sub_total' => '12345.67'], (object) ['owner' => 'Bob', 'sub_total' => '9876.54'] ]
  * @param {string} $type - "standard" to filter by current session user, "admin" to aggregate across company.
  * @param {string} $date - Optional single date filter (applies currentdate >= $date). Example: '2025-06-01'.
  * @param {string} $from_date - Optional start date for range filter (requires $to_date). Example: '2025-01-01'.
  * @param {string} $to_date - Optional end date for range filter (requires $from_date). Example: '2025-06-30'.
  * @returns {array|false} Returns array of result objects when records found, or false if no records.
  */
  public function get_top_opp_by_date($type, $date='', $from_date='', $to_date='')
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $stage = "closed won";
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->select('sub_total,owner,currentdate');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);
    }
    else if($type=="admin")
    {
      $this->db->select('SUM(sub_total) as sub_total,owner');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->group_by('owner');
    }
      
    if($date !="")
    {
      $this->db->where('currentdate >=',$date);
    }

    
    if($from_date !="" && $to_date !="")
    {
       $this->db->where('currentdate >=', $from_date);
       $this->db->where('currentdate <=', $to_date);
    } 
      $this->db->where('stage !=',$stage);
      $this->db->where('stage !=',"closed lost");
      $this->db->where('delete_status',1);
      $this->db->order_by('sub_total','desc');
      $this->db->limit('10');
     
      //fetch records
      $query = $this->db->get('opportunity');
      // check records
      if($query->num_rows() > 0)
      {
        //return fetched data
        return $query->result();
      }
      else
      {
        return false;
      }
    
  }
  //////////////////////////////////////////////////////////////// Sort Opportunity Ends //////////////////////////////////////////////

  ///////////////////////////////////////////////////// Get Top Quotation Starts //////////////////////////////////////////////////////
  /**
  * Get top quotations grouped by owner for the current company for the month-to-date (queries from the first day of the current month).
  * @example
  * $result = $this->Reports_model->get_top_quotation_by_user('standard');
  * // For 'standard' this returns up to 10 records for the logged-in user/company.
  * // Example returned value:
  * // [
  * //   (object) ['owner' => 'alice@example.com', 'sub_totalq' => '1250.00', 'currentdate' => '2025-12-05'],
  * //   (object) ['owner' => 'bob@example.com', 'sub_totalq' => '1100.00', 'currentdate' => '2025-12-03'],
  * //   ...
  * // ]
  * @param {string} $type - Mode selector: 'standard' to restrict results to the current logged-in user, 'admin' to aggregate across the company.
  * @returns {array|false} Returns an array of result objects (CodeIgniter result() array) when records are found, or false if no records.*/
  public function get_top_quotation_by_user($type)
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'day');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->select('owner,sub_totalq,currentdate');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);
    }else if($type=="admin")
    {
      $this->db->select('owner,max(sub_totalq) as sub_totalq');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
    } 
      $this->db->where('currentdate >=',date('Y-m-d', $w));
      $this->db->where('delete_status',1);
      $this->db->order_by('sub_totalq','desc');
      $this->db->group_by('owner');
      $this->db->limit(10);
      // fetch data
      $query = $this->db->get('quote');
      //check records
      if($query->num_rows() > 0)
      {
        //return fetched data
        return $query->result();
      }
      else
      {
        return false;
      }
    
  }
  /**
  * Retrieve top quotes filtered by date for a given user type (standard or admin), limited to 10 results ordered by sub_totalq.
  * @example
  * $result = $this->Reports_model->get_top_quote_by_date('standard', '2025-01-01');
  * print_r($result); // sample output: array( (object) ['owner'=>'John Doe','sub_totalq'=>'1234.56','currentdate'=>'2025-01-01'], ... ) or false
  * @param {string} $type - Type of user: 'standard' uses the current session user email; 'admin' aggregates max(sub_totalq) by owner.
  * @param {string} $date - Optional single date filter; retrieves quotes with currentdate >= $date. Default ''.
  * @param {string} $from_date - Optional start date for a date range filter (used with $to_date). Default ''.
  * @param {string} $to_date - Optional end date for a date range filter (used with $from_date). Default ''.
  * @returns {array|false} Returns an array of result objects (up to 10 records) ordered by sub_totalq desc, or false if no records found.
  */
  public function get_top_quote_by_date($type,$date='',$from_date='',$to_date='')
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    
     if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->select('owner,sub_totalq,currentdate');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);
    }else if($type=="admin")
    {
      $this->db->select('owner,max(sub_totalq) as sub_totalq');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->group_by('owner');
    } 
    if($date !="")
    {
      $this->db->where('currentdate >=',$date);
    }
    
    if($from_date !="" && $to_date !="")
    {
       $this->db->where('currentdate >=', $from_date);
       $this->db->where('currentdate <=', $to_date);
    } 
      $this->db->where('delete_status',1);
      $this->db->order_by('sub_totalq','desc');
      $this->db->limit(10);
      //get records
      $query = $this->db->get('quote');
      // check no. of records
      if($query->num_rows() > 0)
      {
        //return result
        return $query->result();
      }
      else
      {
        return false;
      }
    
  
  }
  ////////// Get Top Quotation Ends /////////////////
  
  

  /////////////////////// Salesorder Graph Starts ///////////////
  
  
  /**
  * Retrieve sales orders totals for the current session company, optionally filtered by user type and date range.
  * Supports two modes: 'standard' (limits results to the logged-in user's email) and 'admin' (aggregates by owner).
  * Date range can be provided via POST 'date' (e.g. "This Week", "last month", or a start date); otherwise defaults to the beginning of the current month window as computed in the function.
  * @example
  * $result = $this->Reports_model->get_all_so_by_user('standard');
  * var_dump($result);
  * // Example output:
  * // array(1) {
  * //   [0]=>
  * //   object(stdClass) {
  * //     ["status"]=> string(8) "Approved"
  * //     ["owner"]=> string(15) "alice@example.com"
  * //     ["sub_totals"]=> string(7) "12345.67"
  * //     ["after_discount"]=> string(7) "12000.00"
  * //   }
  * // }
  * @param string $type - 'standard' or 'admin' to control scoping of results.
  * @returns array|false Array of stdClass rows (each contains at least status, owner, sub_totals, after_discount) on success, or false if no records found.
  */
  public function get_all_so_by_user($type)
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'day');
    
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->select('status,owner');
      $this->db->select_sum('sub_totals');
      $this->db->select_sum('after_discount');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('sess_eml',$sess_eml);
      //$this->db->group_by('status');
      
    }
    else if($type=="admin")
    {
      $this->db->select('status,owner');
      $this->db->select_sum('sub_totals');
      $this->db->select_sum('after_discount');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      //$this->db->where('status','Approved');
      $this->db->group_by('owner');
    }
    
    if($this->input->post('date'))
    { 
        $search_date = $this->input->post('date');
        if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }else if($search_date=="last month")
        {
            $currentdate = date("Y-m-d");
            $first_day = '01';
            $last_day = '31';
            $last_month = date("Y.m", strtotime("-1 month"));
            $start_date = $last_month.'.'.$first_day;
            $end_date = $last_month.'.'.$last_day;
            $this->db->where('currentdate >=', $start_date);
            $this->db->where('currentdate <=', $end_date);
        }else
        {
          $this->db->where('currentdate >=',$search_date);
        }
    }else{
        $this->db->where('currentdate >=',date('Y-m-d', $w));
    }
    
    $this->db->where('delete_status',1);
    $this->db->order_by('sub_totals','desc');
    $query = $this->db->get('salesorder');
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return false;
    }
    
  }
  
  
  //////// //// Salesorder Graph Ends //////// ///////////////

  //////////// //////////// Sort Salesorder Graph Starts ///// ///////////
  /**
  * Get aggregated sales orders filtered by date (grouped by owner for admins or by status for standard users) for the current session company.
  * @example
  * $result = $this->Reports_model->get_all_so_by_date('admin', '2025-01-01');
  * print_r($result); // Example output: [(object) ['status'=>'Approved','owner'=>'John Doe','sub_totals'=>'1500.00'], (object) ['status'=>'Approved','owner'=>'Jane Smith','sub_totals'=>'1200.00']]
  * @param {string} $type - User type context: 'admin' (groups by owner and only Approved) or 'standard' (groups by status and scoped to current user).
  * @param {string} $date - Optional single-date filter; selects records with currentdate >= this date. Format: 'YYYY-MM-DD'.
  * @param {string} $from_date - Optional start date for a date range filter. Format: 'YYYY-MM-DD'.
  * @param {string} $to_date - Optional end date for a date range filter. Format: 'YYYY-MM-DD'.
  * @returns {array|false} Returns an array of result objects (fields include status, owner, sub_totals) on success, or false if no records found.
  */
  public function get_all_so_by_date($type,$date='',$from_date='',$to_date='')
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $this->db->select('status,owner');
    $this->db->select_sum('sub_totals');
    if($type == "admin")
    {
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('status','Approved');
      $this->db->group_by('owner');
    }
    else if($type == "standard")
    {
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('sess_eml', $sess_eml);
      $this->db->group_by('status');
    }
    
    if($date !="")
    {
      $this->db->where('currentdate >=',$date);
    }
    
    if($from_date !="" && $to_date !="")
    {
       $this->db->where('currentdate >=', $from_date);
       $this->db->where('currentdate <=', $to_date);
    } 
    
    $this->db->where('delete_status',1);
    $this->db->order_by('sub_totals','desc');
    
    //get records
    $query = $this->db->get('salesorder');
    //echo $this->db->last_query();die;
    if($query->num_rows() > 0)
    {
      //return fetched data
      return $query->result();
    }
    else
    {
      return false;
    }
    
  }
  //////////////////////////////////////////////////////////////// Sort Salesorder Graph Ends ///////////////////////////////////////////////
  ////////////////////////////////////////////////////////////// PurchaseOrder Graph Starts ////////////////////////////////////////////////
  /**
  * Retrieve the top 10 purchase orders (by subtotal) for the current company since the first day of the current month.
  * @example
  * $result = $this->Reports_model->get_top_po_by_user('standard');
  * // Possible output example for 'standard':
  * // array(
  * //   (object) ['currentdate' => '2025-12-01', 'sub_total' => '1234.56', 'subject' => 'PO-1001'],
  * //   ...
  * // )
  * $adminResult = $this->Reports_model->get_top_po_by_user('admin');
  * // Possible output example for 'admin':
  * // array(
  * //   (object) ['currentdate' => '2025-12-01', 'sub_total' => '9876.54', 'owner' => 'owner@example.com'],
  * //   ...
  * // )
  * @param {string} $type - Either 'standard' to return individual purchase orders for the logged-in user, or 'admin' to return summed sub_total grouped by owner.
  * @returns {array|false} Return an array of result objects when rows are found, otherwise false.
  */
  public function get_top_po_by_user($type)
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'day');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->select('currentdate,sub_total,subject');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('sess_eml',$sess_eml);
      
    }
    else if($type=="admin")
    {
      $this->db->select('currentdate,SUM(sub_total) as sub_total,owner');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->group_by('owner');
    }  
      $this->db->where('currentdate >=',date('Y-m-d', $w));
      $this->db->where('delete_status',1);
      $this->db->order_by('sub_total','desc');
      $this->db->limit(10);
      $query = $this->db->get('purchaseorder');
      if($query->num_rows() > 0)
      {
        return $query->result();
      }
      else
      {
        return false;
      }
    

  }
  /////////////////////////////////////////////////////////////PurchaseOrder Graph Ends ////////////////////////////////////////////////////
  ///////////////////////////////////////////////// Top PO ////////////////////////////////////////////////////////////////////////////////
  /**
  * Get top purchase orders for the current session company, optionally filtered by a date or a date range. For "standard" type it returns individual purchase orders (currentdate, sub_total, subject). For "admin" type it returns aggregated sub_total per owner.
  * @example
  * $result = $this->Reports_model->get_top_po_by_date('admin', '2025-01-01', '2025-01-01', '2025-01-31');
  * print_r($result); // e.g. Array ( [0] => stdClass Object ( [currentdate] => 2025-01-15 [owner] => Acme Co [sub_total] => 12345.67 ) ... )
  * @param {string} $type - 'standard' to fetch individual POs for the logged-in user, 'admin' to fetch aggregated totals per owner.
  * @param {string} $date - Optional single start date (YYYY-MM-DD). If provided, filters records with currentdate >= $date.
  * @param {string} $from_date - Optional range start date (YYYY-MM-DD). Used together with $to_date to filter a date range.
  * @param {string} $to_date - Optional range end date (YYYY-MM-DD). Used together with $from_date to filter a date range.
  * @returns {array|bool} Return array of result objects (CI result()) when records are found, or false when no records match.
  */
  public function get_top_po_by_date($type,$date='',$from_date='',$to_date='')
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->select('currentdate,sub_total,subject');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('sess_eml',$sess_eml);
      
    }
    else if($type=="admin")
    {
      $this->db->select('currentdate,owner,SUM(sub_total) as sub_total');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->group_by('owner');
    }  
      if($date !="")
      {
         $this->db->where('currentdate >=', $date);
      }
    
      if($from_date !="" && $to_date !="")
      {
         $this->db->where('currentdate >=', $from_date);
         $this->db->where('currentdate <=', $to_date);
      } 
      
      $this->db->where('delete_status',1);
      $this->db->order_by('sub_total','desc');
      $this->db->limit(10);
      $query = $this->db->get('purchaseorder');
      if($query->num_rows() > 0)
      {
        return $query->result();
      }
      else
      {
        return false;
      }
    

  }

  ///////////////////////////////////////////////// Top PO ///////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////// Assigned Lead Data Starts ///////////////////////////////////////////////
  /**
  * Retrieve up to 8 most recent leads assigned to other users within a company session (excludes leads assigned to the session user).
  * @example
  * $result = $this->Reports_model->assigned_lead_status('company@example.com','user@example.com','Example Company');
  * print_r($result); // e.g. Array ( [0] => Array ( 'id' => '123', 'assigned_to' => 'other@example.com', 'assigned_to_name' => 'John Doe', ... ) ) or FALSE
  * @param {string} $session_comp_email - Company session email used to filter leads.
  * @param {string} $sess_eml - Session user email; leads assigned to this email will be excluded.
  * @param {string} $session_company - Company name or identifier for the session.
  * @returns {array|false} Return an array of lead records (up to 8) when found, or FALSE if none exist.
  */
  public function assigned_lead_status($session_comp_email,$sess_eml,$session_company)
  {
    $this->db->select('*');
    $this->db->where('sess_eml',$sess_eml);
    $this->db->where('assigned_to !=',$sess_eml);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('assigned_to_name!=',"");
    $this->db->where('delete_status',1);
    $this->db->order_by('currentdate', 'DESC');
    $this->db->limit('8');
    $this->db->from('lead');
    //get records
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    //return fetched data
    return ($query->num_rows() > 0)?$query->result_array():FALSE;

  }
  //////////////////////////////////////////////////////////////// Assigned Lead Data Starts //////////////////////////////////////////////////

  //////////////////////////////////////////////////////////////// Dashboard Profit Table starts //////////////////////////////////////////////////
  var $sort_by = array('owner','So_total','So_total_estimate_price',null);
  var $search_by = array('SO.owner');
  var $order = array('SO.id' => 'desc');
 var $sort_by_dash = array('owner','So_total','So_total_estimate_price',null);
  var $search_by_dash = array('SO.owner');
  var $order_dash = array('SO.id' => 'desc');
  
 /**
  * Prepare the CodeIgniter query builder for the dashboard profit datatables (groups profit per owner for current fiscal year).
  * @example
  * $this->_get_dashboard_profit_datatables_query();
  * // execute the prepared query and fetch results
  * $rows = $this->db->get()->result();
  * var_export($rows);
  * // sample output:
  * // array(
  * //   (object) ['owner' => 'Alice', 'So_total' => '15000.00', 'So_total_estimate_price' => '9000.00', 'profitUser' => '6000.00'],
  * //   (object) ['owner' => 'Bob',   'So_total' => '8000.00',  'So_total_estimate_price' => '5000.00', 'profitUser' => '3000.00']
  * // );
  * @param {{void}} {{none}} - No parameters; uses session and POST data internally.
  * @returns {{void}} Modifies the model's $this->db query builder (selects owner, sums totals and profit, applies session/company/date filters, search and ordering). 
  */
 private function _get_dashboard_profit_datatables_query()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
   
    $this->db->select('SO.owner, SUM(SO.sub_totals) as So_total,SUM(SO.total_estimate_purchase_price) as So_total_estimate_price, SUM(SO.profit_by_user) as profitUser'); 
      $this->db->from('salesorder as SO');
      
      $this->db->where('SO.session_comp_email',$session_comp_email);
      $this->db->where('SO.session_company',$session_company);
     // $this->db->where('SO.status','Approved');
      $this->db->where('SO.delete_status',1);
      
    $fiscal_year_for_date = calculateFiscalYearForDate(date('m'));
    $dateToGet=explode(':',$fiscal_year_for_date); 
      
       $this->db->where('SO.currentdate>=',$dateToGet[0]);
       $this->db->where('SO.currentdate<=',$dateToGet[1]);
       $this->db->group_by(array('SO.owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('SO.sess_eml',$sess_eml);
    }
   
    $i = 0;
    foreach ($this->search_by_dash as $item) // loop column
    {
      if($_POST['search']['value']) 
      {
        if($i===0) 
        {
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
          $this->db->or_like($item, $_POST['search']['value']);
        }
        if(count($this->search_by_dash) - 1 == $i) 
        $this->db->group_end(); 
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->sort_by_dash[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->order))
    {
      //$order = $this->order;
      //$this->db->order_by(key($order), $order[key($order)]);
    }
  }
  
  
  public function get_dashboard_profit_datatables()
  {
    $this->_get_dashboard_profit_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  
  public function count_filtered_dashboard_profit()
  {
    $this->_get_dashboard_profit_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  
   /**
   * Count distinct sales order owners for dashboard profit within the current fiscal year and session/company scope.
   * @example
   * $result = $this->Reports_model->count_all_dashboard_profit();
   * echo $result; // e.g. 5
   * @param {void} none - No arguments.
   * @returns {int} Number of distinct owners (count of grouped salesorder records) matching the session/company and fiscal year filters.
   */
   public function count_all_dashboard_profit()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
    $this->db->select('salesorder.id');
    $this->db->from('salesorder');
    $fiscal_year_for_date = calculateFiscalYearForDate(date('m'));
    $dateToGet=explode(':',$fiscal_year_for_date); 
      
    $this->db->where('salesorder.currentdate>=',$dateToGet[0]);
    $this->db->where('salesorder.currentdate<=',$dateToGet[1]);
    $this->db->where('salesorder.session_comp_email',$session_comp_email);
    $this->db->where('salesorder.session_company',$session_company);
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('salesorder.sess_eml',$sess_eml);
    }
    $this->db->group_by(array('salesorder.owner'));
    return $this->db->count_all_results();
  }
  
  //////////////////////////////////////////////////////////////// Dashboard Profit Table ends ////////////////////////////////////////

  //////////////////////////////////////////////////////////////// Dashboard Queries Ends  ////////////////////////////////////////////////
  /**
  * Update the report date for a sales order record by saleorder_id.
  * @example
  * // Update report date to 2025-12-17 for sale order ID 123
  * $result = $this->Reports_model->salesorder_reportdate('2025-12-17', 123);
  * echo $result ? 'Updated' : 'Update failed';
  * @param {string} $reportdate - Report date string (e.g. '2025-12-17' or '2025-12-17 14:30:00').
  * @param {int} $saleorder_id - Sale order ID to update (e.g. 123).
  * @returns {bool} True on successful update, false on failure.
  */
  public function salesorder_reportdate($reportdate,$saleorder_id)
  {
    $data = array(
      'reportdate' => $reportdate,
    );
    $this->db->where('saleorder_id',$saleorder_id);
    if($this->db->update('salesorder',$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
        ##################################
        #    PO PROFIT GRAPH 23.01.21    #
        ##################################

/**
* Retrieve aggregated purchase profit grouped by owner for the current company and session.
* @example
* $this->load->model('Reports_model');
* $result = $this->Reports_model->get_purchase_profit_graph();
* print_r($result); // Array ( [0] => stdClass Object ( [owner] => "John Doe" [profit_by_user_po] => "1234.56" ) )
* @param void $none - No arguments required.
* @returns array Returns an array of objects (stdClass) where each object contains 'owner' (string) and 'profit_by_user_po' (string|float) representing the summed profit for that owner.
*/
public function get_purchase_profit_graph(){
    
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
   
      $this->db->select('PO.owner');
      $this->db->select_sum('PO.profit_by_user_po');
      
     // $this->db->from('salesorder as SO');
      $this->db->from('purchaseorder as PO');
      //$this->db->where('SO.session_comp_email',$session_comp_email);
      //$this->db->where('SO.session_company',$session_company);
      $this->db->where('PO.session_comp_email',$session_comp_email);
      $this->db->where('PO.session_company',$session_company);
      //$this->db->where('SO.delete_status',1);
      $this->db->where('PO.delete_status',1);
     
	
	 if($this->session->userdata('type')==='standard')
	 {
		$this->db->where('PO.sess_eml',$sess_eml);
		
	 }else if($this->input->post('searchUser'))
      { 
        $search_user = $this->input->post('searchUser');
        $this->db->where('PO.sess_eml',$search_user);
      }
	  
	 if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('PO.currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('PO.currentdate >=',$search_date);
        }
      }else{
          if($this->input->post('poProfitYear'))
          { 
            $search_yrs = $this->input->post('poProfitYear');
            $this->db->where('YEAR(PO.currentdate)',$search_yrs);
          }
          if($this->input->post('poProfitMonth'))
          { 
            $search_Mnth = $this->input->post('poProfitMonth');
            $this->db->where('MONTH(PO.currentdate)',$search_Mnth);
          }
          else
          {
          	$this->db->where('PO.currentdate>=',date('Y-m-01'));
          }
     }
	  
    $this->db->group_by(array('PO.owner'));
    $query = $this->db->get();
    return $query->result();
    
}

  /**
  * Retrieve aggregated sales orders grouped by owner for the current session company, optionally filtered by date range and search parameters.
  * @example
  * $result = $this->Reports_model->get_so_for_record('Month', [
  *   'search' => [
  *     'keywords' => 'John',
  *     'sortBy'   => '2025-01-01',
  *     'sortFrom' => '2025-01-01',
  *     'sortTo'   => '2025-12-31'
  *   ],
  *   'start' => 0,
  *   'limit' => 10
  * ]);
  * print_r($result); // Example output: Array ( [0] => Array ( [id] => 12 [status] => Approved [owner] => John Doe [sub_totals] => 12345.67 ) )
  * @param {string} $date - Date filter mode. Pass "Month" to restrict results to the past month relative to today; other values do not apply the month filter.
  * @param {array} $params - Optional parameters array. Supported keys: 'search' => ['keywords' => string, 'sortBy' => 'YYYY-MM-DD', 'sortFrom' => 'YYYY-MM-DD', 'sortTo' => 'YYYY-MM-DD'], and optional pagination keys 'start' (int) and 'limit' (int).
  * @returns {array} Return array of associative arrays grouped by 'owner' with summed 'sub_totals' (each item contains keys: id, status, owner, sub_totals). Returns an empty array if no records found.
  */
  public function get_so_for_record($date, $params = array())
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'days');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select('id,status,owner');
    $this->db->select_sum('sub_totals');
    $this->db->from('salesorder');
    //filter data by searched keywords
    if(!empty($params['search']['keywords'])){
        $this->db->like(array('owner'=>$params['search']['keywords']));
    }
    //sort data by ascending or desceding order
    if(!empty($params['search']['sortBy'])){
        $this->db->where(array('currentdate >='=>$params['search']['sortBy']));
        $this->db->order_by('owner','asc');
    }else{
      $this->db->order_by('owner','asc');
    }
    //sort data by ascending or desceding order
    if(!empty($params['search']['sortFrom'])){
        $this->db->where(array('currentdate >'=>$params['search']['sortFrom']));
    }else{
        $this->db->order_by('owner','asc');
    }
    //sort data by ascending or desceding order
    if(!empty($params['search']['sortTo'])){
        $this->db->where(array('currentdate <'=>$params['search']['sortTo']));
    }else{
        $this->db->order_by('owner','asc');
    }
    //set start and limit
    
    // if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
    //     $this->db->limit($params['limit'],$params['start']);
    // }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
    // {
    //     $this->db->limit($params['limit']);
    // }
    
    if($date=="Month")
    {
      $this->db->where('currentdate>=',date('Y-m-d', $w));
    }
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('status','Approved');
    $this->db->where('delete_status',1);
    $this->db->order_by('sub_totals','desc');
    $this->db->group_by('owner');
    //get records
    $query = $this->db->get();
    //return fetched data
    if($query->num_rows() > 0)
    {
      return $query->result_array();
    }
  }

  // public function get_po_for_record($params = array(),$date)
  // {
  //   $y = strtotime('-1day');
  //   $x = date('d',$y);
  //   $w = strtotime('-'.$x.'days');
  //   $session_company = $this->session->userdata('company_name');
  //   $session_comp_email = $this->session->userdata('company_email');
  //   $this->db->select('id,currentdate,owner');
  //   $this->db->select_sum('sub_total');
  //   $this->db->from('purchaseorder');
  //   //filter data by searched keywords
  //   if(!empty($params['search']['keywords'])){
  //       $this->db->like(array('owner'=>$params['search']['keywords']));
  //   }
  //   //sort data by ascending or desceding order
  //   if(!empty($params['search']['sortBy'])){
  //       $this->db->where(array('currentdate >='=>$params['search']['sortBy']));
  //       $this->db->order_by('owner','asc');
  //   }else{
  //     $this->db->order_by('owner','asc');
  //   }
  //   //sort data by ascending or desceding order
  //   if(!empty($params['search']['sortFrom'])){
  //       $this->db->where(array('currentdate >'=>$params['search']['sortFrom']));
  //   }else{
  //       $this->db->order_by('owner','asc');
  //   }
  //   //sort data by ascending or desceding order
  //   if(!empty($params['search']['sortTo'])){
  //       $this->db->where(array('currentdate <'=>$params['search']['sortTo']));
  //   }else{
  //       $this->db->order_by('owner','asc');
  //   }
  //   //set start and limit
  //   if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
  //       $this->db->limit($params['limit'],$params['start']);
  //   }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
  //   {
  //       $this->db->limit($params['limit']);
  //   }
  //   if($date=="Month")
  //   {
  //     $this->db->where('currentdate>=',date('Y-m-d', $w));
  //   }
  //   $this->db->where('session_comp_email',$session_comp_email);
  //   $this->db->where('session_company',$session_company);
  //   $this->db->where('delete_status',1);
  //   $this->db->order_by('sub_total','desc');
  //   $this->db->group_by('owner');
  //   //get records
  //   $query = $this->db->get();
  //   //return fetched data
  //   if($query->num_rows() > 0)
  //   {
  //     return $query->result_array();
  //   }
  // }

  // public function get_opp_for_record($params = array(),$date)
  // {
  //   $y = strtotime('-1day');
  //   $x = date('d',$y);
  //   $w = strtotime('-'.$x.'days');
  //   $session_company = $this->session->userdata('company_name');
  //   $session_comp_email = $this->session->userdata('company_email');
  //   $stage = "closed won";
  //   $this->db->select('id,owner');
  //   $this->db->select_sum('sub_total');
  //   $this->db->from('opportunity');
  //   //filter data by searched keywords
  //   if(!empty($params['search']['keywords'])){
  //       $this->db->like(array('owner'=>$params['search']['keywords']));
  //   }
  //   //sort data by ascending or desceding order
  //   if(!empty($params['search']['sortBy'])){
  //       $this->db->where(array('currentdate >='=>$params['search']['sortBy']));
  //       $this->db->order_by('owner','asc');
  //   }else{
  //     $this->db->order_by('owner','asc');
  //   }
  //   //sort data by ascending or desceding order
  //   if(!empty($params['search']['sortFrom'])){
  //       $this->db->where(array('currentdate >'=>$params['search']['sortFrom']));
  //   }else{
  //       $this->db->order_by('owner','asc');
  //   }
  //   //sort data by ascending or desceding order
  //   if(!empty($params['search']['sortTo'])){
  //       $this->db->where(array('currentdate <'=>$params['search']['sortTo']));
  //   }else{
  //       $this->db->order_by('owner','asc');
  //   }
  //   //set start and limit
  //   if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
  //       $this->db->limit($params['limit'],$params['start']);
  //   }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
  //   {
  //       $this->db->limit($params['limit']);
  //   }
  //   if($date=="Month")
  //   {
  //     $this->db->where('currentdate>=',date('Y-m-d', $w));
  //   }
  //   $this->db->where('session_comp_email',$session_comp_email);
  //   $this->db->where('session_company',$session_company);
  //   $this->db->where('stage !=',$stage);
  //   $this->db->where('stage !=',"closed lost");
  //   $this->db->where('delete_status',1);
  //   $this->db->order_by('sub_total','desc');
  //   $this->db->group_by('owner');
  //   //get records
  //   $query = $this->db->get();
  //   //return fetched data
  //   if($query->num_rows() > 0)
  //   {
  //     return $query->result_array();
  //   }
  // }
  /**
   * Retrieve counts of leads grouped by their status for the current company when the session user is an admin.
   * Queries the `lead` table filtering by the session company (session key 'company_name'), `delete_status = 1`
   * and excluding empty `lead_status` values, then returns grouped counts per `lead_status`.
   * @example
   * $result = $this->Reports_model->get_leads_status();
   * print_r($result);
   * // Sample output:
   * // Array
   * // (
   * //     [0] => Array ( [total_count] => 12 [lead_status] => New )
   * //     [1] => Array ( [total_count] => 5  [lead_status] => Contacted )
   * // )
   * @param void None - This method does not accept any parameters.
   * @returns array|false Returns an array of associative arrays with keys 'total_count' and 'lead_status' on success, or false if no matching rows are found or the current session user is not an admin.
   */
  public function get_leads_status()
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count(lead_status) as total_count, lead_status');
      $this->db->from('lead');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
      $this->db->where('lead_status !=', '');
     // $this->db->where('lead_status !=', 'Attempted To Contact');
      //$this->db->where('lead_status !=', 'Closed Lost');
      //$this->db->where('lead_status !=', 'Contact In Future');
     // $this->db->where('lead_status !=', 'Lost Lead');
      //$this->db->where('lead_status !=', 'Not-Qualified');
      //$this->db->where('lead_status !=', 'Conatact In Future');
      //$this->db->where('lead_status !=', 'Conatacted');
      $this->db->group_by('lead_status');
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
  * Retrieve opportunity counts grouped by stage for the current session company (admin users only).
  * @example
  * $result = $this->Reports_model->get_opp_stage();
  * // Example successful result:
  * // [
  * //   ['total_count' => '10', 'stage' => 'Proposal'],
  * //   ['total_count' => '4',  'stage' => 'Negotiation'],
  * // ]
  * echo json_encode($result); // prints sample JSON array or "false"
  * @returns array|false|null Returns an array of associative arrays with keys 'total_count' and 'stage' when records exist; returns false if no rows are found; returns null if the current session user is not an admin.
  */
  public function get_opp_stage()
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count(sess_eml) as total_count, stage');
      $this->db->from('opportunity');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
       $this->db->where('stage !=', '');
      //$this->db->where('stage !=', 'Closed Lost');
      //$this->db->where('stage !=', 'Needs Analysis');
      //$this->db->where('stage !=', 'New');
      //$this->db->where('stage !=', 'Ready To Close');
      //$this->db->where('stage !=', 'Value Proposition');
      $this->db->group_by('stage');
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
  * Retrieve counts of quotes grouped by quote_stage for the current company (admin users only).
  * @example
  * $result = $this->Reports_model->get_quote_stage();
  * print_r($result); // e.g. Array ( [0] => Array ( [total_count] => 12 [quote_stage] => Proposal ) [1] => Array ( [total_count] => 5 [quote_stage] => Closed Won ) )
  * @param {void} $none - No parameters.
  * @returns {array|false|null} Returns an array of associative arrays with keys 'total_count' and 'quote_stage' when records exist, false when no matching records are found, or null if the current session user is not an admin.
  */
  public function get_quote_stage()
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count(sess_eml) as total_count, quote_stage');
      $this->db->from('quote');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
      $this->db->where('quote_stage !=', '');
      //$this->db->where('quote_stage !=', 'Closed Lost');
      //$this->db->where('quote_stage !=', 'Draft');
      //$this->db->where('quote_stage !=', 'Negotiation');
      $this->db->group_by('quote_stage');
      $query = $this->db->get();
      //echo $this->db->last_query();die;
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
  * Get lead counts grouped by lead owner for the current company within the current month window.
  * @example
  * $result = $this->Reports_model->get_report_leads_by_user('standard');
  * print_r($result);
  * // Sample output:
  * // Array
  * // (
  * //   [0] => stdClass Object
  * //       (
  * //           [id] => 12
  * //           [lead_owner] => "john.doe@example.com"
  * //           [total_leads] => 42
  * //       )
  * // )
  * @param {string} $type - Report type: 'standard' filters by the current session user; 'admin' returns company-wide results.
  * @returns {array|false} Array of stdClass result rows (each with id, lead_owner, total_leads) on success, or false if no records found.
  */
  public function get_report_leads_by_user($type)
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'day');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select('id,lead_owner,count("lead_owner") as total_leads');
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);
      
    }else if($type=="admin")
    {
      
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
    }
    // $this->db->where('session_comp_email',$session_comp_email);
     // $this->db->where('session_company',$session_company);
      $this->db->where('currentdate >=',date('Y-m-d', $w));
      $this->db->where('delete_status',1);
      $this->db->group_by('lead_owner');
      //get records
      $query = $this->db->get('lead');
      //echo $this->db->last_query();die;
      // check no. of records
      if($query->num_rows() > 0)
      {
        //return result
        return $query->result();
      }
      else
      {
        return false;
      }
    
  }
  var $table = 'lead';
  var $lead_sort_by = array(null,'lead_owner');
  var $lead_search_by = array('lead_owner');
  var $lead_order = array('id' => 'desc');

  /**
  * Build a CodeIgniter active-record query that groups leads by lead_owner and applies session-, company-, date-, search- and order-based filters.
  * @example
  * $_POST['sortdate'] = '2025-12-01';
  * $_POST['startDate'] = '2025-11-01';
  * $_POST['endDate'] = '2025-11-30';
  * $this->session->set_userdata(['type' => 'standard', 'email' => 'user@example.com', 'company_email' => 'acme@example.com', 'company_name' => 'Acme Inc']);
  * $this->Reports_model->_get_lead_for_record_query();
  * // No direct return; the method configures $this->db. After this call:
  * // $rows = $this->db->get()->result();
  * // Example $rows output: [{"lead_owner":"Alice","total_leads":"5"},{"lead_owner":"Bob","total_leads":"3"}]
  * @param {{void}} {{none}} - This method accepts no parameters; it reads session and POST data instead.
  * @returns {{void}} Configures and builds the DB query (select, where, group_by, order_by) but does not return a value.
  */
  private function _get_lead_for_record_query()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'days');
    // $session_company = $this->session->userdata('company_name');
    // $session_comp_email = $this->session->userdata('company_email');
    if($this->session->userdata('type')=='standard')
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->select('id,lead_owner,count("lead_owner") as total_leads');
      $this->db->from('lead');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);

      if($this->input->post('sortdate'))
      {
        $sort_by_date = $this->input->post('sortdate');
        $this->db->where('currentdate>=',$sort_by_date);
      }
      else
      {
        $this->db->where('currentdate>=',date('Y-m-d', $w));
      }

      if ($this->input->post('startDate') && $this->input->post('endDate')) {
        $start_date = $this->input->post('startDate');
        $end_date = $this->input->post('endDate');
    
        // Debugging output
        // print_r("Start Date: " . $start_date . " End Date: " . $end_date); die;
    
        // Ensure the date filtering works as expected
        $this->db->where('currentdate >=', $start_date);
        $this->db->where('currentdate <=', $end_date);
      }
      $this->db->where('delete_status',1);
      $this->db->group_by('lead_owner');
      //get records
    }else if($this->session->userdata('type')=='admin')
    {
      $this->db->select('lead_owner,count("lead_owner") as total_leads');
      $this->db->from('lead');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      
      if($this->input->post('sortdate'))
      {
        $sort_by_date = $this->input->post('sortdate');
        $this->db->where('currentdate>=',$sort_by_date);
      }
      else
      {
        $this->db->where('currentdate>=',date('Y-m-d', $w));
      }

      if ($this->input->post('startDate') && $this->input->post('endDate')) {
        $start_date = $this->input->post('startDate');
        $end_date = $this->input->post('endDate');
    
        // Debugging output
        // print_r("Start Dateadmin: " . $start_date . " End Date: " . $end_date); die;
    
        // Ensure the date filtering works as expected
        $this->db->where('currentdate >=', $start_date);
        $this->db->where('currentdate <=', $end_date);
      }

      $this->db->where('delete_status',1);
      $this->db->group_by('lead_owner');
      //get records
    }


    $i = 0;
    foreach ($this->lead_search_by as $item) // loop column
    {
      if(isset($_POST['search']['value'])) // if datatable send POST for search
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
        if(count($this->lead_search_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->lead_sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->lead_order))
    {
      $lead_order = $this->lead_order;
      $this->db->order_by(key($lead_order), $lead_order[key($lead_order)]);
    }
  }
  
  /**
  * Retrieve leads grouped by lead_owner filtered by session type and date(s).
  * @example
  * $this->load->model('Reports_model');
  * $result = $this->Reports_model->get_all_leads_by_date('standard', '2025-01-01');
  * // Example returned value:
  * // [ (object) ['id' => 1, 'lead_owner' => 'alice@example.com', 'total_leads' => 10], ... ] or false
  * @param {string} $type - Session type: "standard" (filters by current user) or "admin" (company-wide).
  * @param {string} $date - Optional single date (YYYY-MM-DD). Applies filter currentdate >= $date.
  * @param {string} $from_date - Optional start date (YYYY-MM-DD) for range filtering when used with $to_date.
  * @param {string} $to_date - Optional end date (YYYY-MM-DD) for range filtering when used with $from_date.
  * @returns {array|false} Array of result objects (keys: id, lead_owner, total_leads) grouped by lead_owner, or false if no records found.
  */
  public function get_all_leads_by_date($type,$date='',$from_date='',$to_date='')
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select('id,lead_owner,count("lead_owner") as total_leads');
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);
    }else if($type=="admin")
    {
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
    } 
    if($date !="")
    {
      $this->db->where('currentdate >=',$date);
    }
    
    if($from_date !="" && $to_date !="")
    {
       $this->db->where('currentdate >=', $from_date);
       $this->db->where('currentdate <=', $to_date);
    } 
     $this->db->where('delete_status ', 1);
     $this->db->group_by('lead_owner');
      //get records
      $query = $this->db->get('lead');
      // check no. of records
      if($query->num_rows() > 0)
      {
        //return result
        return $query->result();
      }
      else
      {
        return false;
      }
    
  }
  
  
  
  public function get_lead_for_record()
  {
    $this->_get_lead_for_record_query();
	if(isset($_POST['length'])){
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
	}
    $query = $this->db->get();
    return $query->result();
  }
  
  
  public function count_filtered_leads()
  {
    $this->_get_lead_for_record_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  /**
  * Count all leads for the current session/company. If the current user type is 'standard', the count is limited to leads owned by the user's email.
  * @example
  * $result = $this->Reports_model->count_all_leads();
  * echo $result; // e.g., 42
  * @returns {int} Total number of leads matching the current session/company filters.
  */
  public function count_all_leads()
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from($this->table);
	$sess_eml = $this->session->userdata('email');
	if($this->session->userdata('type')=='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    return $this->db->count_all_results();
  }
  var $opp_table = 'opportunity';
  var $opp_sort_by = array(null,'owner');
  var $opp_search_by = array('owner');
  var $opp_order = array('id' => 'desc');

  /**
  * Build the active record query to fetch opportunities grouped by owner and ordered by summed sub_total, applying session and POST-based filters.
  * @example
  * $this->_get_opp_for_record_query();
  * $query = $this->db->get(); // Execute the prepared query to retrieve results
  * // Example result row: (object) ['id' => 1, 'owner' => 'Acme Sales', 'sub_total' => '12500.00']
  * @param {void} none - No direct function parameters; uses $this->session (company_name, company_email) and $this->input->post() keys: 'sortdate', 'startDate', 'endDate', datatable 'search' and 'order'.
  * @returns {void} Prepares/modifies $this->db query builder for later execution; does not return a value.
  */
  private function _get_opp_for_record_query()
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'day');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $stage = "closed won";
    $this->db->select('id,owner,SUM(sub_total) as sub_total');
    //$this->db->select_sum('sub_total');
    $this->db->from('opportunity');
    
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('stage !=',$stage);
    $this->db->where('stage !=',"closed lost");
    $this->db->where('delete_status',1);

    if($this->input->post('sortdate'))
    {
      $sort_by_date = $this->input->post('sortdate');
      $this->db->where('currentdate>=',$sort_by_date);
    }
    else
    {
      $this->db->where('currentdate>=',date('Y-m-d', $w));
    }

    if ($this->input->post('startDate') && $this->input->post('endDate')) {
      $start_date = $this->input->post('startDate');
      $end_date = $this->input->post('endDate');
  
      // Debugging output
      // print_r("Start Date: " . $start_date . " End Date: " . $end_date); die;
  
      // Ensure the date filtering works as expected
      $this->db->where('currentdate >=', $start_date);
      $this->db->where('currentdate <=', $end_date);
    }

    $this->db->order_by('sub_total','desc');
    $this->db->group_by('owner');
    
    $i = 0;
    foreach ($this->opp_search_by as $item) // loop column
    {
      if(isset($_POST['search']['value'])) // if datatable send POST for search
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
        if(count($this->opp_search_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->opp_sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->opp_order))
    {
      $opp_order = $this->opp_order;
      $this->db->order_by(key($opp_order), $opp_order[key($opp_order)]);
    }
  }

  public function get_opp_for_record()
  {
    $this->_get_opp_for_record_query();
	if(isset($_POST['length'])){
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
	}
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered_opp()
  {
    $this->_get_opp_for_record_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  /**
  * Count all opportunity records for the current session's company/email, optionally limited to the current user when the session type is 'standard'.
  * @example
  * $count = $this->Reports_model->count_all_opp();
  * echo $count; // e.g. 42
  * @returns {int} Total number of matching opportunity records.
  */
  public function count_all_opp()
  {
	$session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->from($this->opp_table);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
	$sess_eml = $this->session->userdata('email');
	if($this->session->userdata('type')=='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
    return $this->db->count_all_results();
  }

  var $quote_table = 'quote';
  var $quote_sort_by = array(null,'owner','sub_totalq','total_quote');
  var $quote_search_by = array('owner','sub_totalq');
  var $quote_order = array('id' => 'desc');

  /**
   * Build the CodeIgniter active-record query to retrieve quote records grouped by owner,
   * applying session-based company filters, optional date range (POST startDate/endDate or sortdate),
   * search (DataTables style) across configured columns, and ordering rules.
   * @example
   * // Setup (example)
   * $this->session->set_userdata('company_name', 'Acme Ltd');
   * $this->session->set_userdata('company_email', 'sales@acme.example');
   * // Optional POST inputs (examples)
   * $_POST['startDate'] = '2025-12-01';
   * $_POST['endDate']   = '2025-12-15';
   * $_POST['search']['value'] = 'John';
   * $_POST['order'][0]['column'] = 1;
   * $_POST['order'][0]['dir'] = 'desc';
   *
   * // Usage
   * $this->_get_quote_for_record_query();
   * $query = $this->db->get(); // execute the built query
   * print_r($query->result());
   *
   * // Sample rendered output (one row example):
   * // Array ( [0] => stdClass Object ( [id] => 123 [owner] => John Doe [total_quote] => 4 [sub_totalq] => 250.00 ) )
   *
   * @param {void} none - This method accepts no arguments and uses session/POST/internal properties.
   * @returns {void} Configures $this->db query builder (select, where, group_by, order_by) but does not return a value.
   */
  private function _get_quote_for_record_query()
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'days');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select('id,owner,count("owner") as total_quote');
    $this->db->select_max('sub_totalq');
    $this->db->from('quote');
    
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('delete_status',1);
    $this->db->group_by('owner');

    if($this->input->post('sortdate'))
    {
      $sort_by_date = $this->input->post('sortdate');
      $this->db->where('currentdate>=',$sort_by_date);
    }
    else
    {
      $this->db->where('currentdate>=',date('Y-m-d', $w));
    }

    if ($this->input->post('startDate') && $this->input->post('endDate')) {
      $start_date = $this->input->post('startDate');
      $end_date = $this->input->post('endDate');
  
      // Debugging output
      // print_r("Start Date: " . $start_date . " End Date: " . $end_date); die;
  
      // Ensure the date filtering works as expected
      $this->db->where('currentdate >=', $start_date);
      $this->db->where('currentdate <=', $end_date);
    }


    $i = 0;
    foreach ($this->quote_search_by as $item) // loop column
    {
      if(isset($_POST['search']['value'])) // if datatable send POST for search
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
        if(count($this->quote_search_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->quote_sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->quote_order))
    {
      $quote_order = $this->quote_order;
      $this->db->order_by(key($quote_order), $quote_order[key($quote_order)]);
    }
  }

  public function get_quote_for_record()
  {
    $this->_get_quote_for_record_query();
	
    if(isset($_POST['length']) && $_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered_quote()
  {
    $this->_get_quote_for_record_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  /**
  * Count all quote records for the current session company and company email.
  * If the logged-in user's session type is 'standard', the count is further limited to that user's email.
  * @example
  * $count = $this->Reports_model->count_all_quote();
  * echo $count; // e.g. 42
  * @returns {int} Total number of matching quote records.
  */
  public function count_all_quote()
  {
	$session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->from($this->quote_table);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
	$sess_eml = $this->session->userdata('email');
	if($this->session->userdata('type')=='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
    return $this->db->count_all_results();
  }
  // Salesorder Normal Table
  var $sales_table = 'salesorder';
  var $sales_sort_by = array(null,'owner','sub_totals');
  var $sales_search_by = array('owner','sub_totals');
  var $sales_order = array('id' => 'desc');

  /**
   * Build and configure a CodeIgniter DB query to aggregate sales totals per owner.
   * The method applies session-based company filters, status/delete checks, date range
   * filters (from POST: sortdate, startDate, endDate), search across configured columns,
   * grouping by owner and ordering as requested.
   * @example
   * // Example usage inside the model (method does not return a value; it configures $this->db)
   * // Simulate POST filters:
   * $_POST['sortdate'] = '2025-12-01';
   * $_POST['startDate'] = '2025-12-01';
   * $_POST['endDate'] = '2025-12-31';
   * $_POST['search']['value'] = 'Acme';
   * $_POST['order'] = [['column' => 0, 'dir' => 'desc']];
   * // Call the internal query builder
   * $this->_get_sales_for_record_query();
   * // Execute the configured query and fetch results
   * $query = $this->db->get();
   * $result = $query->result();
   * // Sample returned row (example output)
   * // Array (
   * //   [0] => stdClass Object (
   * //       [id] => 123,
   * //       [status] => "Approved",
   * //       [owner] => "John Doe",
   * //       [sub_totals] => "1500.00"
   * //   )
   * // )
   * @returns void Configures the active CI query builder ($this->db) for fetching aggregated sales; does not return a value.
   */
  private function _get_sales_for_record_query()
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'days');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select('id,status,owner');
    $this->db->select_sum('sub_totals');
    $this->db->from('salesorder');
    
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('status','Approved');
    $this->db->where('delete_status',1);
    $this->db->order_by('sub_totals','desc');
    $this->db->group_by('owner');

    if($this->input->post('sortdate'))
    {
      $sort_by_date = $this->input->post('sortdate');
      $this->db->where('currentdate>=',$sort_by_date);
    }else{
      $this->db->where('currentdate>=',date('Y-m-d', $w));
    }


    if ($this->input->post('startDate') && $this->input->post('endDate')) {
      $start_date = $this->input->post('startDate');
      $end_date = $this->input->post('endDate');
  
      // Debugging output
      // print_r("Start Date: " . $start_date . " End Date: " . $end_date); die;
  
      // Ensure the date filtering works as expected
      $this->db->where('currentdate >=', $start_date);
      $this->db->where('currentdate <=', $end_date);
    }



    $i = 0;
    foreach ($this->sales_search_by as $item) // loop column
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
        if(count($this->sales_search_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->sales_sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->sales_order))
    {
      $sales_order = $this->sales_order;
      $this->db->order_by(key($sales_order), $sales_order[key($sales_order)]);
    }
  }
  public function get_sales_for_record()
  {
    $this->_get_sales_for_record_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered_sales()
  {
    $this->_get_sales_for_record_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  /**
  * Count all sales records for the current session company. If the current user is of type 'standard', only count sales created by that user's email.
  * @example
  * $count = $this->Reports_model->count_all_sales();
  * echo $count; // e.g. 42
  * @returns {int} Total number of matching sales records.
  */
  public function count_all_sales()
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from($this->sales_table);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
	$sess_eml = $this->session->userdata('email');
	if($this->session->userdata('type')=='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
    return $this->db->count_all_results();
  }

   // <---------------------------- ------- Salesorder Profit Table ---------------------------------->
  var $so_sort_by = array('owner','currentdate','saleorder_id','org_name','due_date','after_discount',null);
  var $so_search_by = array('owner','currentdate','saleorder_id','org_name','due_date','after_discount');
  var $so_order = array('id' => 'desc');

  /**
  * Builds and applies the active record (Query Builder) filters for fetching approved sales orders for DataTables based on session and POST inputs.
  * @example
  * // Example usage inside the model:
  * $this->_get_datatables_query_so();
  * // After calling the method the query is prepared in $this->db. To execute:
  * $query = $this->db->get('salesorder')->result(); // sample output: array of sales order objects
  * @param {void} none - This function accepts no arguments.
  * @returns {void} No direct return; the method configures $this->db with WHERE, LIKE, and ORDER BY clauses for later execution.
  */
  private function _get_datatables_query_so()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin')
    {
      $this->db->select('*');
      $this->db->from('salesorder');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('delete_status',1);
      $this->db->where('status','Approved');

      if($this->input->post('searchUser'))
      { 
        $search_user = $this->input->post('searchUser');
        // print_r($search_user);die;
        $this->db->where('sess_eml',$search_user);
      }


      if ($this->input->post('startDate') && $this->input->post('endDate')) {
        $start_date = $this->input->post('startDate');
        $end_date = $this->input->post('endDate');
    
        // Debugging output
        // print_r("Start Date: " . $start_date . " End Date: " . $end_date); die;
    
        // Ensure the date filtering works as expected
        $this->db->where('currentdate >=', $start_date);
        $this->db->where('currentdate <=', $end_date);
      }

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
      // else
      // {
      //   $y = strtotime('-1day');
      //   $x = date('d',$y);
      //   $w = strtotime('-'.$x.'days');
      //   $this->db->where('currentdate >=',date('Y-m-d', $w));
      // }
    }
    else if($this->session->userdata('type')=='standard')
    {
      $this->db->select('*');
      $this->db->from('salesorder');
      $this->db->where('sess_eml',$sess_eml);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('status','Approved');
      $this->db->where('delete_status',1);

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
      else
      {
        $y = strtotime('-1day');
        $x = date('d',$y);
        $w = strtotime('-'.$x.'days');
        $this->db->where('currentdate >=',date('Y-m-d', $w));
      }
    }

    $i = 0;
    foreach ($this->so_search_by as $item) // loop column
    {
      if(isset($_POST['search']['value'])) // if datatable send POST for search
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
        if(count($this->so_search_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->so_sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->so_order))
    {
      $so_order = $this->so_order;
      $this->db->order_by(key($so_order), $so_order[key($so_order)]);
    }
  }

  public function get_so_profit_datatables()
  {
    $this->_get_datatables_query_so();
    if(isset($_POST['length']) && $_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
    // $data = $query->result();
    // print_r($data);die;
  }

  public function count_filtered_so()
  {
    $this->_get_datatables_query_so();
    $query = $this->db->get();
    return $query->num_rows();
  }
  /**
  * Count total sales orders for the current company (and restrict to the current user when the session user type is 'standard').
  * @example
  * $result = $this->Reports_model->count_all_so();
  * echo $result // e.g. 42
  * @param void $none - No parameters.
  * @returns int Total number of matching sales orders.
  */
  public function count_all_so()
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from('salesorder');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
	$sess_eml = $this->session->userdata('email');
	if($this->session->userdata('type')=='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
    return $this->db->count_all_results();
  }
  var $po_table = 'purchaseorder';
  var $po_sort_by = array(null,'owner','sub_total');
  var $po_search_by = array('owner','sub_total');
  var $po_order = array('id' => 'desc');

  /**
  * Prepare a CodeIgniter DB query that aggregates purchase orders by owner and applies session, date, search and ordering filters for reports/datatable usage.
  * @example
  * // Called from within the Reports_model (private method)
  * $this->_get_po_for_record_query();
  * // execute the prepared query afterwards
  * $results = $this->db->get('purchaseorder')->result();
  * print_r($results); // sample output: Array ( [0] => stdClass Object ( [id] => 123 [currentdate] => 2025-12-01 [owner] => "Acme Ltd" [sub_total] => "1500.00" ) )
  * @param void - No parameters.
  * @returns void Builds/modifies the CI query builder for purchaseorder records (grouped by owner) and does not return a value.
  */
  private function _get_po_for_record_query()
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'days');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select('id,currentdate,owner');
    $this->db->select_sum('sub_total');
    $this->db->from('purchaseorder');
    
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('delete_status',1);
    $this->db->order_by('sub_total','desc');
    $this->db->group_by('owner');

    if($this->input->post('sortdate'))
    {
      $sort_by_date = $this->input->post('sortdate');
      $this->db->where('currentdate>=',$sort_by_date);
    }
    else
    {
      $this->db->where('currentdate>=',date('Y-m-d', $w));
    }

    if ($this->input->post('startDate') && $this->input->post('endDate')) {
      $start_date = $this->input->post('startDate');
      $end_date = $this->input->post('endDate');
  
      // Debugging output
      // print_r("Start Date: " . $start_date . " End Date: " . $end_date); die;
  
      // Ensure the date filtering works as expected
      $this->db->where('currentdate >=', $start_date);
      $this->db->where('currentdate <=', $end_date);
    }

    $this->db->order_by('sub_total','desc');
    $this->db->group_by('owner');
    $i = 0;
    foreach ($this->po_search_by as $item) // loop column
    {
      if(isset($_POST['search']['value'])) // if datatable send POST for search
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
        if(count($this->po_search_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->po_sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->po_order))
    {
      $po_order = $this->po_order;
      $this->db->order_by(key($po_order), $po_order[key($po_order)]);
    }
  }

  public function get_po_for_record()
  {
    $this->_get_po_for_record_query();
    if(isset($_POST['length']) && $_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered_po()
  {
    $this->_get_po_for_record_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  /**
  * Count total purchase orders (PO) accessible for the current session/company.
  * @example
  * // within a controller or model where Reports_model is loaded
  * $result = $this->reports_model->count_all_po();
  * echo $result; // render sample output value: 42
  * @param void $no_params - No parameters are required.
  * @returns int Total number of purchase orders matching the current session/company filters.
  */
  public function count_all_po()
  {
	  
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from($this->po_table);
	if($this->session->userdata('type')=='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
	$this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    return $this->db->count_all_results();
  }
  
  
  
  #*************** To get Profit....*****************/###
  #														#
  #														#
  #######################################################
  
  /*  New Code Running...*/
 
  var $pro_sort_by = array('owner','saleorder_id','subject','org_name','after_discount','total_estimate_purchase_price','total_orc',null);
  var $pro_search_by = array('owner','saleorder_id','subject','org_name','after_discount','total_estimate_purchase_price','total_orc');
  var $pro_order = array('id' => 'desc');
  
  /**
  * Build a filtered CodeIgniter query for product/salesorder datatables (applies WHERE, SELECT, ORDER and search filters to $this->db).
  * @example
  * // Load model and build a query that selects the sum of profit_by_user:
  * $this->load->model('Reports_model');
  * $this->Reports_model->_get_product_datatables_query('profit');
  * // Build a query that selects detailed columns (owner, saleorder_id, subject, etc.):
  * $this->Reports_model->_get_product_datatables_query('');
  * @param {string} $profit - Optional. If set to 'profit' the query will select the summed profit_by_user; any other value (or empty) selects detailed columns.
  * @returns {void} Modifies the model's $this->db query builder and does not return a value.
  */
  public function _get_product_datatables_query($profit='')
  {
    $sess_eml           = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company    = $this->session->userdata('company_name');
   
      if($profit=="profit"){
      //$this->db->select('owner');
      $this->db->select_sum('profit_by_user');
      }else{
        $this->db->select('owner,saleorder_id,subject,org_name,after_discount,  total_estimate_purchase_price,total_orc,profit_by_user,currentdate');
      }

          $this->db->from('salesorder');
          $this->db->where('session_comp_email',$session_comp_email);
          $this->db->where('session_company',$session_company);

          // if($this->input->post('searchUser'))
          // { 
          //     $searchUser = $this->input->post('searchUser');
          //     // print_r($searchUser);die;
          //     $this->db->where('sess_eml',$searchUser);
          // }
          
          if($this->session->userdata('type')==='standard'){
            $this->db->where('sess_eml',$sess_eml);
          }else if($this->input->post('searchUser')){ 
          
                $search_user = $this->input->post('searchUser');
                $this->db->where('sess_eml',$search_user);
            }
          
          if($this->input->post('search_data'))
          {
            $searchOrg = $this->input->post('search_data');
            // print_r($searchOrg);die;
            $this->db->where('org_name', $searchOrg);
          }
    
          if($this->input->post('searchMonth'))
          { 
            // print_r('test1');die;
            $year_date = $this->input->post('searchYear');
            $month_date = $this->input->post('searchMonth');
            $curndth=$year_date."-".$month_date."-01";
            $a_date = date($curndth);
            $lastday=date("Y-m-t", strtotime($a_date)); 
            $this->db->where('currentdate >=',$curndth);
            $this->db->where('currentdate <=',$lastday);
            
          }

         // Check if the year is provided
          if ($this->input->post('searchYear')) {
            $year_date = $this->input->post('searchYear');
            
            $start_date = $year_date . "-01-01"; 
            $end_date = $year_date . "-12-31";   

            // Debugging output (optional)
            // print_r('Start Date: ' . $start_date . ' End Date: ' . $end_date); die;
            $this->db->where('currentdate >=', $start_date);
            $this->db->where('currentdate <=', $end_date);
          }
        
          
          
          if($this->input->post('searchDate')){ 
            // print_r('test2');die;
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
          

          if ($this->input->post('startDate') && $this->input->post('endDate')) {
            $start_date = $this->input->post('startDate');
            $end_date = $this->input->post('endDate');
        
            // Debugging output
            // print_r("Start Date: " . $start_date . " End Date: " . $end_date); die;
        
            // Ensure the date filtering works as expected
            $this->db->where('currentdate >=', $start_date);
            $this->db->where('currentdate <=', $end_date);
          }


          $this->db->where('total_percent','0');
          $this->db->where('delete_status',1);


          // else{
          //   print_r('test3');die;
          //   $y = strtotime('-1day');
          //   $x = date('d',$y);
          //   $w = strtotime('-'.$x.'days');
          //   $this->db->where('currentdate >=',date('Y-m-d', $w));
          // }

      $i = 0;
      
      foreach ($this->pro_search_by as $item) // loop column
      {
        $search_data='';
        if($this->input->post('search_data')){
          $search_data=$this->input->post('search_data');
        }else if(isset($_POST['search']['value'])){
          $search_data=$_POST['search']['value'];
        }
        
          if($search_data!="") // if datatable send POST for search
          {
            if($i===0) // first loop
            {
              $this->db->group_start(); 
              $this->db->like($item, $search_data);
            }
            else
            {
              $this->db->or_like($item, $search_data);
            }
            if(count($this->pro_search_by) - 1 == $i) //last loop
            $this->db->group_end(); //close bracket
          }
          $i++;
      }
    
   
    
    
      if(isset($_POST['order'])) // here order processing
      {
        $this->db->order_by($this->pro_sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      }
      else if(isset($this->pro_order))
      {
        $order = $this->pro_order;
        $this->db->order_by(key($order), $order[key($order)]);
      }
  } 
 
 /*  Old Code Running...*/
  var $pro_sort_by_old = array('SO.owner','SO.saleorder_id','SO.subject','SO.sub_totals','PO.sub_total','SO.total_orc',null);
  var $pro_search_by_old = array('SO.owner','SO.saleorder_id','SO.subject','SO.sub_totals','PO.sub_total','SO.total_orc');
  var $pro_order_old = array('SO.id' => 'desc');
  /**
  * Builds the CodeIgniter QueryBuilder used to populate the product reports datatable. Applies session-based access control (admin vs standard), joins salesorder and purchaseorder, applies search and date filters (including "This Week"), enforces approved/delete status, and sets ordering for datatables.
  * @example
  * // Called from within the model/controller; no arguments required
  * $this->Reports_model->_get_pro_datatables_query_old();
  * // Example: when called by an admin with session company "Acme Co" and POST searchDate = "2023-12-01" this prepares a query similar to:
  * // SELECT SO.owner, SO.saleorder_id, SO.subject, SO.after_discount, SO.total_orc, PO.id, PO.purchaseorder_id, PO.after_discount_po
  * // FROM salesorder AS SO
  * // JOIN purchaseorder AS PO ON SO.saleorder_id = PO.saleorder_id
  * // WHERE SO.session_comp_email = 'admin@acme.com' AND SO.session_company = 'Acme Co' AND SO.status = 'Approved' AND SO.delete_status = 1 AND SO.currentdate >= '2023-12-01' ...
  * @returns void Prepares and configures the active $this->db QueryBuilder instance for later execution; does not return a value.
  */
  private function _get_pro_datatables_query_old()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin')
    {
      $this->db->select('SO.owner,SO.saleorder_id,SO.subject,SO.after_discount,SO.total_orc,PO.id,PO.purchaseorder_id,PO.after_discount_po');
      $this->db->from('salesorder as SO');
      $this->db->join('purchaseorder as PO', 'SO.saleorder_id = PO.saleorder_id');
      $this->db->where('SO.session_comp_email',$session_comp_email);
      $this->db->where('SO.session_company',$session_company);
      $this->db->where('PO.session_comp_email',$session_comp_email);
      $this->db->where('PO.session_company',$session_company);
      $this->db->where('SO.status','Approved');
      $this->db->where('SO.delete_status',1);
      $this->db->where('PO.delete_status',1);
      if($this->input->post('searchUser'))
      { 
        $search_user = $this->input->post('searchUser');
        $this->db->where('SO.sess_eml',$search_user);
      }
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('SO.currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('SO.currentdate >=',$search_date);
        }
      }
      else
      {
        $y = strtotime('-1day');
        $x = date('d',$y);
        $w = strtotime('-'.$x.'days');
        $this->db->where('SO.currentdate >=',date('Y-m-d', $w));
        $this->db->where('PO.currentdate >=',date('Y-m-d', $w));
      }
      
    }
    else if($this->session->userdata('type')=='standard')
    {
      $this->db->select('SO.*,PO.id,PO.purchaseorder_id,PO.sub_total as PO_subtotal,PO.saleorder_id as PO_saleorder_id,PO.after_discount_po');
      $this->db->from('salesorder as SO');
      $this->db->join('purchaseorder as PO', 'SO.saleorder_id = PO.saleorder_id');
      $this->db->where('SO.sess_eml',$sess_eml);
      $this->db->where('SO.session_comp_email',$session_comp_email);
      $this->db->where('SO.session_company',$session_company);
      $this->db->where('PO.session_comp_email',$session_comp_email);
      $this->db->where('PO.session_company',$session_company);
      $this->db->where('SO.status','Approved');
      $this->db->where('SO.delete_status',1);
      $this->db->where('PO.delete_status',1);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('SO.currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('SO.currentdate >=',$search_date);
        }
      }
      else
      {
        $y = strtotime('-1day');
        $x = date('d',$y);
        $w = strtotime('-'.$x.'days');
        $this->db->where('SO.currentdate >=',date('Y-m-d', $w));
        $this->db->where('PO.currentdate >=',date('Y-m-d', $w));
      }
    }
    $i = 0;
    foreach ($this->pro_search_by as $item) // loop column
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
      $this->db->order_by($this->pro_sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->pro_order))
    {
      $pro_order = $this->pro_order;
      $this->db->order_by(key($pro_order), $pro_order[key($pro_order)]);
    }
  }
  
  
  
  public function get_profit_pro_datatables()
  {
    $this->_get_product_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    // $data = $query->result();
    // print_r($data);die;
    return $query->result();
  }
  public function count_filtered_pro()
  {
    $this->_get_product_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  
  public function count_profit_user_so()
  {
    $this->_get_product_datatables_query('profit');
    $query = $this->db->get();
	//return $this->db->last_query();
    return $query->row_array();
  }
  
  
  /**
   * Count all sales orders visible to the current session's company/user.
   * @example
   * $result = $this->Reports_model->count_all_pro();
   * echo $result; // e.g., 42
   * @param void $none - This method accepts no parameters; it uses session data.
   * @returns int Total number of matching salesorder records.
   */
  public function count_all_pro()
  {
	  $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
    $this->db->from('salesorder');
    if($this->session->userdata('type')=='standard')
      {
      $this->db->where('sess_eml',$sess_eml);
    }
    $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
    
      return $this->db->count_all_results();
  }
  
  
  
  
  /*  New  Code ...*/
   // <-------------------------------- CustomData_7 ----------------------------------------------->
  
  var $pro_ws_sort_by = array('PO.owner','PO.saleorder_id','PO.purchaseorder_id','PO.subject','PO.profit_by_user_po');
 
 var $pro_ws_search_by = array('PO.owner','PO.saleorder_id','PO.purchaseorder_id','PO.subject','PO.profit_by_user_po');
  var $pro_ws_order = array('PO.id' => 'desc');
  
 
/**
* Prepare the CodeIgniter query builder for product-wise purchase order datatables applying session, company, user and date filters, search and ordering.
* @example
* // Called from a controller or model to build the query, then execute it:
* $this->Reports_model->_get_pro_datatables_query_product_wise();
* $query = $this->db->get('purchaseorder as PO');
* $result = $query->result();
* print_r($result); // e.g. Array ( [0] => stdClass Object ( [owner] => "Alice", [saleorder_id] => "SO123", [purchaseorder_id] => "PO456", [profit_by_user_po] => "150.00", [subject] => "Widget restock" ) )
* @param {void} void - No parameters are accepted; the method reads session and POST inputs.
* @returns {void} Does not return a value; modifies $this->db query builder with the necessary WHERE, LIKE and ORDER BY clauses. */
private function _get_pro_datatables_query_product_wise(){

    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
   
    $this->db->select('PO.owner,PO.saleorder_id,PO.purchaseorder_id,PO.profit_by_user_po,PO.subject');
    $this->db->from('purchaseorder as PO');
    $this->db->where('PO.session_comp_email',$session_comp_email);
    $this->db->where('PO.session_company',$session_company);
  
	
      if($this->session->userdata('type')==='standard'){
        $this->db->where('PO.sess_eml',$sess_eml);
      }else if($this->input->post('searchUser')){ 
      
            $search_user = $this->input->post('searchUser');
            $this->db->where('PO.sess_eml',$search_user);
        }

        // if($this->input->post('searchUser'))
        // { 
        //     $searchUser = $this->input->post('searchUser');
        //     // print_r($searchUser);die;
        //     $this->db->where('PO.sess_eml',$search_user);
        // }

      if($this->input->post('monthDate')){ 
          $year_date  = $this->input->post('yearDate');
          $month_date = $this->input->post('monthDate');
          $curndth    = $year_date."-".$month_date."-01";
          $a_date     = date($curndth);
          $lastday    = date("Y-m-t", strtotime($a_date));
          
          $this->db->where('PO.currentdate >=',$curndth);
          $this->db->where('PO.currentdate <=',$lastday);   
      }

       // Check if the year is provided
       if ($this->input->post('yearDate')) {
        $year_date = $this->input->post('yearDate');
        
        $start_date = $year_date . "-01-01"; 
        $end_date = $year_date . "-12-31";   

        // Debugging output (optional)
        // print_r('Start Date: ' . $start_date . ' End Date: ' . $end_date); die;
        $this->db->where('PO.currentdate >=', $start_date);
        $this->db->where('PO.currentdate <=', $end_date);
      }

      if($this->input->post('searchDate')){
          
          $search_date = $this->input->post('searchDate');
          if($search_date == "This Week"){
          
              $this->db->where('PO.currentdate >=',date('Y-m-d',strtotime('last monday')));
          }else{
            
            $this->db->where('PO.currentdate >=',$search_date);
          }
      }
   
      if ($this->input->post('startDate') && $this->input->post('endDate')) {
      
        $start_date = $this->input->post('startDate');
        $end_date = $this->input->post('endDate');
    
        // Debugging output
        // print_r("Start Date: " . $start_date . " End Date: " . $end_date); die;
        $this->db->where('PO.currentdate >=', $start_date);
        $this->db->where('PO.currentdate <=', $end_date);
      }

    // else{
    //     $y = strtotime('-1day');
    //     $x = date('d',$y);
    //     $w = strtotime('-'.$x.'days');
    //     $this->db->where('PO.currentdate >=',date('Y-m-d', $w));
    // }

    $this->db->where('PO.delete_status',1);
    
    $i = 0;
    foreach ($this->pro_ws_search_by as $item){
        if(isset($_POST['search']['value'])){
            if($i===0){
                $this->db->group_start();
                $this->db->like($item, $_POST['search']['value']);
            }else{
                $this->db->or_like($item, $_POST['search']['value']);
            }
            if(count($this->pro_ws_search_by) - 1 == $i) 
            $this->db->group_end();
        }
        $search_data=$this->input->post('search_data');
        if(isset($search_data) && $search_data!=''){
            if($i===0){
                $this->db->group_start();
                $this->db->like($item, $search_data);
            }else{
                $this->db->or_like($item, $search_data);
            }
            if(count($this->pro_ws_search_by) - 1 == $i) 
            $this->db->group_end();
        }
        $i++;
    }
    
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->pro_ws_sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->pro_ws_order))
    {
      $pro_order = $this->pro_ws_order;
      $this->db->order_by(key($pro_order), $pro_order[key($pro_order)]);
    }
	  
   
  }
  

  public function get_profit_datatables_product_wise()
  {
    $this->_get_pro_datatables_query_product_wise();
	
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);

    $query = $this->db->get();
    return $query->result();
	
  }
  public function count_filtered_pro_product_wise()
  {
    $this->_get_pro_datatables_query_product_wise();
    $query = $this->db->get();
    return $query->num_rows();
  }
  /**
  * Count all purchase orders for the current session's company (product-wise).
  * This method applies session-based filters: it always filters by session_company and session_comp_email,
  * and if the logged-in user type is 'standard' it also filters by the user's sess_eml.
  * @example
  * $result = $this->Reports_model->count_all_pro_product_wise();
  * echo $result // 42
  * @param void none - No parameters.
  * @returns int Total number of matching purchaseorder records.
  */
  public function count_all_pro_product_wise()
  {
	$sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
    $this->db->from('purchaseorder');
    $this->db->select('id');
	if($this->session->userdata('type')=='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
	$this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    return $this->db->count_all_results();
  }
  
  
  /**
  * Retrieve aggregated product-wise actual profit sums for a given sales order (and optional purchase order) filtered by the current session company and user.
  * @example
  * $result = $this->Reports_model->get_Actual_profit_datatables_product_wise(123, 456);
  * echo print_r($result, true) // render some sample output value; e.g. Array ( [0] => Array ( [po_total_price] => 1000.00 [so_pro_total] => 1200.00 [so_id] => 123 ) )
  * @param {int|string} $soid - Sales order ID to filter the aggregated results.
  * @param {int|string} $poid - Purchase order ID (currently unused in the query, kept for compatibility).
  * @returns {array} Return aggregated sums (po_total_price, so_pro_total, so_id) as an array of result rows.
  */
  public function get_Actual_profit_datatables_product_wise($soid,$poid){
	  
	$sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
    $this->db->from('product_wise_profit');
	$this->db->select_sum('po_total_price');
	$this->db->select_sum('so_pro_total');
	$this->db->select_sum('so_id');
	$this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('so_id',$soid);
	
	if($this->session->userdata('type')=='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
	$query = $this->db->get();
    return $query->result_array();
  }
  
  
  
/**
* Prepare the CodeIgniter query to fetch product-wise profit rows and apply filters for datatables count.
* @example
* // Prepare the query builder with session, company, user and date filters applied
* $this->Reports_model->_get_pro_datatables_query_product_wise_count();
* // Then get the count of matching rows from the prepared query
* $count = $this->db->count_all_results();
* echo $count; // e.g. 42
* @param void $none - This method accepts no arguments.
* @returns void Prepares the CI DB Query Builder ($this->db) with joins and WHERE/LIKE clauses; does not return a value.
*/
private function _get_pro_datatables_query_product_wise_count()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
   
    $this->db->select('SO.owner,SO.saleorder_id,SO.subject,SO.discount,SO.after_discount,SO.total_orc,PO.id,PO.purchaseorder_id,PO.after_discount_po,PO.discount as p_discount,PWP.*');
      $this->db->from('salesorder as SO');
      $this->db->join('purchaseorder as PO', 'SO.saleorder_id = PO.saleorder_id');
      $this->db->join('product_wise_profit as PWP', 'PO.purchaseorder_id = PWP.po_id');
      $this->db->where('SO.session_comp_email',$session_comp_email);
      $this->db->where('SO.session_company',$session_company);
      $this->db->where('PO.session_comp_email',$session_comp_email);
      $this->db->where('PO.session_company',$session_company);
      $this->db->where('PWP.po_id<>',"");
		
      $this->db->where('SO.status','Approved');
      $this->db->where('SO.delete_status',1);
      $this->db->where('PO.delete_status',1);
	
	 if($this->session->userdata('type')==='standard')
	 {
		$this->db->where('SO.sess_eml',$sess_eml);
		
	 }else if($this->input->post('searchUser'))
     { 
        $search_user = $this->input->post('searchUser');
        $this->db->where('SO.sess_eml',$search_user);
     }
	  
	  
	  if($this->input->post('monthDate'))
      { 
        $year_date = $this->input->post('yearDate');
        $month_date = $this->input->post('monthDate');
        $curndth=$year_date."-".$month_date."-01";
        $a_date = date($curndth);
        $lastday=date("Y-m-t", strtotime($a_date)); 
        $this->db->where('SO.currentdate >=',$curndth);
        $this->db->where('SO.currentdate <=',$lastday);
        
      }else if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('SO.currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('SO.currentdate >=',$search_date);
        }
      }
      else
      {
        $y = strtotime('-1day');
        $x = date('d',$y);
        $w = strtotime('-'.$x.'days');
        $this->db->where('SO.currentdate >=',date('Y-m-d', $w));
        $this->db->where('PO.currentdate >=',date('Y-m-d', $w));
      }
	  
	  $i = 0;
    foreach ($this->pro_ws_search_by as $item) // loop column
    { 
		$searchData = $this->input->post('search_data');
      if($searchData ) // if datatable send POST for search
      {
        if($i===0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $searchData );
        }
        else
        {
          $this->db->or_like($item, $searchData );
        }
        if(count($this->pro_ws_search_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    
	
	
  }  
  
  

  // < ----------------------- Renewal Query ------------------------------->
 var $pro_renewal_sort_by  = array('owner','org_name','product_name','saleorder_id','renewal_date','currentdate','sub_totals');
 var $pro_renewal_search_by = array('owner','org_name','product_name','saleorder_id','renewal_date','currentdate','sub_totals');
 var $pro_renewal_order     = array('id' => 'desc');
  
  /**
  * Prepare a CodeIgniter DB query to fetch renewal sales orders or the sum of their subtotals.
  * @example
  * // Example: get detailed renewal rows (no direct return; query is built on $this->db)
  * $this->Reports_model->_renewal_data_so('');
  * // Example: build a query that selects the sum of sub_totals
  * $this->Reports_model->_renewal_data_so('sum');
  * @param {string} $sum - Optional flag; if non-empty (e.g. 'sum') the method selects SUM(sub_totals), otherwise it selects detailed fields.
  * @returns {void} Does not return a value; configures the active CI query builder with filters (session company/email, searchUser, monthDate, yearDate, searchFromDate, search_data, ordering) for renewal sales orders.
  */
  private function _renewal_data_so($sum='')
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
    if($sum!=""){
      $this->db->select_sum('sub_totals');
    }else{
      $this->db->select('id,org_id,owner,saleorder_id,org_name,subject,renewal_date,sub_totals,currentdate,product_name');
    }
      $this->db->from('salesorder');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('delete_status',1);
      $this->db->where('is_renewal',1);
	
    // if($this->session->userdata('type')==='standard'){
    //   $this->db->where('sess_eml',$sess_eml);
    // }else if($this->input->post('searchUser')){ 
    //       $search_user = $this->input->post('searchUser');
    //       $this->db->where('sess_eml',$search_user);
    //   }


    if($this->input->post('searchUser')){ 
     
          $search_user = $this->input->post('searchUser');
          // print_r($search_user);die;
          $this->db->where('sess_eml',$search_user);
      }
	  
	  
        if($this->input->post('monthDate'))
        { 
          $year_date = $this->input->post('yearDate');
          $month_date = $this->input->post('monthDate');
          $curndth=$year_date."-".$month_date."-01";
          $a_date = date($curndth);
          $lastday=date("Y-m-t", strtotime($a_date)); 
          $this->db->where('renewal_date >=',$curndth);
          $this->db->where('renewal_date <=',$lastday);
          
        } 

       if ($this->input->post('yearDate')) {
        $year_date = $this->input->post('yearDate');
        $start_date = $year_date . "-01-01"; 
        $end_date = $year_date . "-12-31";   

        // Debugging output (optional)
        // print_r('Start Date: ' . $start_date . ' End Date: ' . $end_date); die;
        $this->db->where('renewal_date >=', $start_date);
        $this->db->where('renewal_date <=', $end_date);
      }
        
        if($this->input->post('searchFromDate')){ 
          $search_from_date = $this->input->post('searchFromDate');
          $search_to_date   = $this->input->post('searchToDate');
            $this->db->where('renewal_date >=',$search_from_date);
            $this->db->where('renewal_date <=',$search_to_date);
          
        }
        
      //   else{
      // $year_date = date('Y');
      // $month_date = date('m');
      // $curndth=$year_date."-".$month_date."-01";
      //     $this->db->where('renewal_date >=',$curndth);        
      //   }
	  
	  $i = 0;
    foreach ($this->pro_renewal_search_by as $item) 
    { 
		$searchData = $this->input->post('search_data');
		if(isset($_POST['search']['value']) && $_POST['search']['value']!="")
		{ 
			$searchData=$_POST['search']['value'];
		}
		if(isset($searchData) && $searchData!="" ){
			if($i===0){
			  $this->db->group_start(); 
			  $this->db->like($item, $searchData );
			}else{
			  $this->db->or_like($item, $searchData );
			}
			if(count($this->pro_renewal_search_by) - 1 == $i)
			$this->db->group_end(); 
		}
        $i++;
    }
    
    if(isset($_POST['order'])) // here order processing
      {
        $this->db->order_by($this->pro_renewal_sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      }
      else if(isset($this->pro_renewal_sort_by))
      {
        $order = $this->pro_renewal_sort_by;
        $this->db->order_by(key($order), $order[key($order)]);
      }
    
  } 
  
  /**
  * Retrieve distinct organizations (grouped by org_name) from the salesorder table for the current session user.
  * @example
  * $result = $this->Reports_model->getOrg();
  * print_r($result);
  * // Sample output:
  * // Array
  * // (
  * //     [0] => Array
  * //         (
  * //             [org_name] => Acme Inc
  * //             [id] => 12
  * //             [session_company] => Acme
  * //             [sess_eml] => user@example.com
  * //         )
  * //
  * //     [1] => Array
  * //         (
  * //             [org_name] => Beta LLC
  * //             [id] => 37
  * //             [session_company] => Beta
  * //             [sess_eml] => user@example.com
  * //         )
  * // )
  * @returns {array|false} Array of associative arrays (rows) grouped by org_name, or false if no records found.
  */
  public function getOrg()
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $this->db->select('*');
    $this->db->from('salesorder');
    // $this->db->where('session_company',$session_company);
    $this->db->where('sess_eml',$sess_eml);
    // $this->db->where('session_comp_email',$session_comp_email);
    $this->db->group_by('org_name');
    $query = $this->db->get();
    if($query ->num_rows() > 0)
    {
      return $query->result_array();
    //   return $this->db->last_query();
    }
    else
    {
      return false;
    }
  }

  public function get_renewal_data_so()
  {
    $this->_renewal_data_so();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  
  public function get_sub_totals_renewal()
  {
    $this->_renewal_data_so('sum');
    $query = $this->db->get();
    return $query->row_array();
  }
  
  public function count_filtered_renewal_data_so()
  {
    $this->_renewal_data_so();
    $query = $this->db->get();
    return $query->num_rows();
  }  
  
  /**
  * Count renewal sales orders for the current session company (and current user when session type is 'standard').
  * @example
  * $result = $this->Reports_model->count_renewal_data_so();
  * echo $result; // e.g., 12
  * @param void $none - No parameters; function uses session data (company_email, company_name, email, type).
  * @returns int Number of renewal sales orders matching the current session's company (and user when type is 'standard').
  */
  public function count_renewal_data_so()
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from('salesorder');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
	$this->db->where('is_renewal',1);
	$sess_eml = $this->session->userdata('email');
	if($this->session->userdata('type')=='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
    return $this->db->count_all_results();
  }
  
  

 public function get_profit_datatables_product_wise_for_count()
 {
    $this->_get_pro_datatables_query_product_wise();
    $query = $this->db->get();
    return $query->result();
   // return $this->db->last_query();
	
 }
  ///////////////////////////////////////////////////////////////////////////get top 10 customers starts ///////////////////////////////////////////////////

  /**
  * Retrieve top customers grouped by organization ordered by total subtotal (limited to top 8).
  * @example
  * $result = $this->Reports_model->gettoptencus(['status' => 'completed'], null, null, '2024-04-01', '2024-06-30', null);
  * print_r($result); // e.g. Array ( [0] => stdClass Object ( [owner] => '123' [org_name] => 'Acme Inc' [total_subtotal] => '15000.00' [totalprofit] => '3000.00' ) )
  * @param {array|string|null} $where - Additional WHERE clause as associative array or SQL string to filter results.
  * @param {int|null} $profityear - Year to filter by YEAR(currentdate) (used when date range and financial are not provided).
  * @param {int|null} $profitmonth - Month (1-12) to further filter within $profityear.
  * @param {string|null} $dateRangeStart - Start date (YYYY-MM-DD) for a BETWEEN date range filter.
  * @param {string|null} $dateRangeEnd - End date (YYYY-MM-DD) for a BETWEEN date range filter.
  * @param {int|null} $financial - Financial year start (e.g. 2024) to filter April-to-March period spanning that year and the next.
  * @returns {array} Return array of stdClass objects each containing owner, org_name, total_subtotal and totalprofit.
  */
  public function gettoptencus($where = null, $profityear = null, $profitmonth = null, $dateRangeStart = null, $dateRangeEnd = null, $financial = null) {
    $this->db->select('owner,org_name, SUM(sub_totals) as total_subtotal, SUM(profit_by_user) as totalprofit');
    $this->db->from('salesorder');

    if ($where != null) {
        $this->db->where($where);
    }

    if ($dateRangeStart != null && $dateRangeEnd != null) {
        $this->db->where("currentdate BETWEEN '$dateRangeStart' AND '$dateRangeEnd'");
    } elseif ($financial != null) {
        $this->db->where("(YEAR(currentdate) = '$financial' AND MONTH(currentdate) >= 4)
            OR
            (YEAR(currentdate) = " . ($financial + 1) . " AND MONTH(currentdate) <= 3)");
    } elseif ($profityear != null) {
        $this->db->where("YEAR(`currentdate`)", $profityear);
        if ($profitmonth != null) {
            $this->db->where("MONTH(`currentdate`)", $profitmonth);
        }
    }

    $this->db->group_by('org_name');
    $this->db->order_by('total_subtotal', 'desc');
    $this->db->limit(8);

    $query = $this->db->get();

   
    return $query->result();
}


/**
* Get the top five quotes ordered by sub_totalq (highest first) with optional filtering by where conditions, profit year/month, date range or financial year.
* @example
* $result = $this->Reports_model->toptenquote(['status' => 'confirmed'], 2024, 6, '2024-04-01', '2025-03-31', 2024);
* print_r($result->result_array()); // sample output: array of up to 5 quote rows with highest sub_totalq
* @param {array|string|null} $where - Optional where clause as associative array or SQL string to filter quotes.
* @param {int|null} $profityear - Optional profit year to filter by YEAR(currentdate) (e.g., 2024).
* @param {int|null} $profitmonth - Optional profit month to filter by MONTH(currentdate) (1-12).
* @param {string|null} $dateRangeStart - Optional start date for range filter in 'YYYY-MM-DD' format.
* @param {string|null} $dateRangeEnd - Optional end date for range filter in 'YYYY-MM-DD' format.
* @param {int|null} $financial - Optional financial year start (e.g., 2024) used to filter April–March spanning two calendar years.
* @returns {CI_DB_result} Query result object containing up to 5 top quote rows ordered by sub_totalq descending.
*/
public function toptenquote($where = null, $profityear = null, $profitmonth = null, $dateRangeStart = null, $dateRangeEnd = null, $financial = null) {
  $this->db->select('*');
  $this->db->from('quote');

  if ($where != null) {
      $this->db->where($where);
  }

  if ($dateRangeStart != null && $dateRangeEnd != null) {
      $this->db->where("currentdate BETWEEN '$dateRangeStart' AND '$dateRangeEnd'");
  } elseif ($financial != null) {
      $this->db->where("(YEAR(currentdate) = '$financial' AND MONTH(currentdate) >= 4)
          OR
          (YEAR(currentdate) = " . ($financial + 1) . " AND MONTH(currentdate) <= 3)");
  } elseif ($profityear != null) {
      $this->db->where("YEAR(`currentdate`)", $profityear);
      if ($profitmonth != null) {
          $this->db->where("MONTH(`currentdate`)", $profitmonth);
      }
  }

  $this->db->order_by('sub_totalq', 'desc');
  $this->db->limit(5);

  $query = $this->db->get();

 
  return $query;
}

public function count_deal_status(){
  $cond= "status = 'in progress' or status = 'pending' or status = 'complete' or status = 'invoice pending'";
   $this->db->select('status ,COUNT(status) as counts');
   $this->db->from('salesorder');
  //  $this->db->where($cond);
   $this->db->group_by('status');
   return $this->db->get();
}







  ///////////////////////////////////////////////////////////////////////get top 10 customers ends ////////////////////////////////////////////////////////
  
  
//Please write code above this
}
?>