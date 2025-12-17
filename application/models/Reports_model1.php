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
   * Get total count of organizations visible to the current session user (Customer/Vendor/Both).
   * @example
   * $CI =& get_instance();
   * $CI->load->model('Reports_model1');
   * $result = $CI->Reports_model1->get_all_org();
   * print_r($result); // sample output: Array ( [total_org] => 42 )
   * @param void $none - No arguments.
   * @returns array|null Associative array with key 'total_org' containing the integer count, or NULL if no rows found.
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
  * Get the total number of leads for the current session/company and user.
  * @example
  * $this->load->model('Reports_model1');
  * $result = $this->Reports_model1->get_all_leads();
  * // Sample output:
  * // Array ( [total_leads] => 42 )
  * print_r($result);
  * @returns array|null Return associative array with key 'total_leads' (int) containing the count of leads, or null if no records found.
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
  * Get the total number of opportunities for the current session/company taking into account the user type (admin or standard).
  * @example
  * $result = $this->Reports_model1->get_all_opportunities();
  * echo $result['total_opp']; // render some sample output value, e.g. 42
  * @param void $none - No arguments.
  * @returns array|null Return associative array with key 'total_opp' (int) when a row is found, or null if no rows. 
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
  * Get the total count of active quotations (not "Closed Won"/"Closed Lost" and not deleted) for the current session/company.
  * @example
  * $result = $this->Reports_model1->get_all_quotation();
  * echo $result['total_quotes']; // renders sample output: 42
  * @param {void} None - This method does not accept any parameters.
  * @returns {array|null} Returns an associative array with key 'total_quotes' (int) containing the count of matching quotations, or null if no rows found.
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
   * Retrieve the top 3 users by realized profit for the current month.
   * This method builds a query joining std_user_target, standard_users, salesorder and purchaseorder,
   * filters by session company/email, approved sales orders, non-deleted records and targets set for the current month,
   * groups results by owner and returns the highest profit users ordered descending.
   * @example
   * $results = $this->Reports_model1->highestTargetGetter();
   * print_r($results);
   * // Sample output:
   * // Array (
   * //   [0] => stdClass Object (
   * //     [standard_name] => "Alice Johnson"
   * //     [sales_quota] => "10000"
   * //     [profit_quota] => "2000"
   * //     [for_month] => "2025-12-01"
   * //     [status] => "1"
   * //     [sub_totals] => "15000.00"
   * //     [after_discount] => "14500.00"
   * //     [profituser] => "3500.00"
   * //   )
   * //   [1] => stdClass Object ( ... )
   * //   [2] => stdClass Object ( ... )
   * // )
   * @param void $none - No parameters required; uses session data and current month.
   * @returns array Array of result objects (stdClass) containing fields: standard_name, sales_quota, profit_quota, for_month, status, sub_totals, after_discount, profituser.
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
  * Retrieve the top 3 admin users for the current month ordered by profit, including their target and aggregated sales/purchase totals.
  * @example
  * // From a controller:
  * $this->load->model('Reports_model1');
  * $result = $this->Reports_model1->highestTargetGetterAdmin();
  * // Sample returned array (simplified):
  * // [
  * //   (object)[
  * //     'admin_name' => 'Alice Johnson',
  * //     'sales_quota' => '50000',
  * //     'profit_quota' => '10000',
  * //     'for_month' => '2025-12-01',
  * //     'status' => '1',
  * //     'sub_totals' => '45000.00',
  * //     'after_discount' => '43000.00',
  * //     'profituser' => '12000.00'
  * //   ],
  * //   (object)[ ... ],
  * //   (object)[ ... ]
  * // ]
  * @param void None - This method accepts no arguments.
  * @returns array Array of result objects (maximum 3) with fields: admin_name, sales_quota, profit_quota, for_month, status, sub_totals, after_discount, profituser.
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
   * Retrieve the current session user's monthly target and aggregated sales/profit totals for the current company.
   * @example
   * // Load model and call method:
   * $this->load->model('Reports_model1');
   * $result = $this->Reports_model1->TargetGetterUser();
   * // Sample output (array with a single stdClass result for the month):
   * // [0] => stdClass {
   * //   standard_name: "jane.doe@example.com",
   * //   sales_quota: "10000",
   * //   profit_quota: "2000",
   * //   for_month: "2025-12-01",
   * //   status: "1",
   * //   sub_totals: "9500.00",
   * //   after_discount: "9000.00",
   * //   profit_by_user: "1500.00"
   * // }
   * @param void None - This method does not accept any parameters.
   * @returns array|object[] Returns an array of result objects containing the user's standard fields and aggregated sums for the current month.
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
  * Get profit graph data grouped by owner with summed sales and purchase order values, filtered by session/company and optional POST search criteria.
  * @example
  * $this->load->model('Reports_model1');
  * $result = $this->Reports_model1->get_profit_graph_1();
  * if ($result) {
  *     print_r($result); // Example output: Array ( [0] => stdClass Object ( [after_discount_po] => "1500.00" [after_discount] => "2000.00" [total_orc] => "2500.00" [id] => "12" [purchaseorder_id] => "PO-001" [PO_subtotal] => "1800.00" [PO_saleorder_id] => "SO-001" ... ) )
  * } else {
  *     echo false; // no records found
  * }
  * @param void $none - No direct parameters; function uses session data and optional POST fields ('searchUser', 'searchDate').
  * @returns array|false Returns an array of result objects when records are found, or false when no records match.
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
    * Retrieve aggregated profit and totals grouped by sales owner with optional filtering by session, posted user and date criteria.
    * @example
    * // Load model and call the method (CodeIgniter)
    * $this->load->model('Reports_model1');
    * $result = $this->Reports_model1->get_profit_graph();
    * print_r($result);
    * // Example output:
    * // Array
    * // (
    * //     [0] => stdClass Object
    * //         (
    * //             [owner] => "john.doe@example.com"
    * //             [after_discount] => "1000.00"
    * //             [profit_by_user] => "250.00"
    * //             [initial_total] => "1250.00"
    * //             [total_orc] => "0.00"
    * //         )
    * // )
    * @param void $none - No direct parameters. Filters are read from session data and POST inputs (searchUser, searchDate, profitYear, profitMoth).
    * @returns object[]|false Returns an array of result objects (aggregated rows per owner) on success, or false if no rows found.
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
   * Retrieve distinct year or month values from the salesorder table.
   * @example
   * $result = $this->Reports_model1->get_DateYear('month', 2023);
   * print_r($result);
   * // Example output:
   * // Array
   * // (
   * //     [0] => stdClass Object
   * //         (
   * //             [month] => 1
   * //         )
   * //     [1] => stdClass Object
   * //         (
   * //             [month] => 2
   * //         )
   * // )
   * @param string $value - Use 'year' to select distinct years; any other value selects months.
   * @param int|string $dataVl - Optional year filter (e.g., 2023) applied when retrieving months.
   * @returns array Array of stdClass objects, each containing a single property 'month' (numeric year or month).
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
  * Get aggregated sales and purchase totals grouped by sales owner for the current session company, limited to Approved sales from the start of the current month.
  * @example
  * $result = $this->Reports_model1->get_all_sales_by_user();
  * // Example returned value (array of objects) or FALSE when no rows:
  * // [
  * //   (object) [
  * //     'owner' => 'Alice Johnson',
  * //     'salesorder_id' => 'SO123',
  * //     'total_orc' => '1500.00',
  * //     'after_discount_po' => '1400.00', // sum of PO.after_discount_po
  * //     'after_discount' => '1450.00'     // sum of SO.after_discount
  * //   ],
  * //   (object) [ ... ]
  * // ]
  * @returns {object[]|false} Array of result objects grouped by owner on success; FALSE if no records found.
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
  * Retrieve aggregated sales records from the database starting from a given date (or for "last month") filtered by session and user type.
  * @example
  * // For admin: grouped by sess_eml, returns an array of associative arrays with summed totals
  * $result = $this->Reports_model1->get_all_sales_by_date('2025-11-01','admin');
  * print_r($result); // e.g. [ ['sess_eml' => 'user@example.com', 'after_discount' => '1234.50', 'total_orc' => '1500.00', ...], ... ]
  * // For standard user: grouped by owner, returns result objects or FALSE if none
  * $result = $this->Reports_model1->get_all_sales_by_date('last month','standard');
  * var_dump($result); // e.g. array(object(...)) or bool(false)
  * @param {string} $date - Start date (YYYY-MM-DD) or the literal string 'last month' to query the previous month.
  * @param {string} $type - User type filter: 'admin' to group by sess_eml, 'standard' to group by owner.
  * @returns {array|object|false} Aggregated result set: for admin an array of associative arrays, for standard an array of objects, or FALSE when no records found.
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
  * Get the summed "after_discount_po" value for a given sales order owner filtered by the current session company/email and limited to the current month.
  * @example
  * $result = $this->Reports_model1->get_after_discount_po(5);
  * // sample output as an associative array:
  * // Array ( 'after_discount_po' => '12345.67', 'so_owner' => '5', ... )
  * echo $result['after_discount_po']; // renders 12345.67
  * @param {int|string} $so_owner - Sales order owner identifier used to filter purchase orders.
  * @returns {array|null} Return an associative array (row) containing the summed "after_discount_po" and related PO fields when matching records exist; returns null when no records are found.
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
  * Retrieve closed-won quote totals (sum of sub_totalq) grouped by owner for the past month window.
  * @example
  * $result = $this->Reports_model1->get_all_estimate('admin');
  * print_r($result); // Example output: Array ( [0] => stdClass Object ( [owner] => 'Alice' [sub_totalq] => '1250.75' ) )
  * @param string $type - "admin" to aggregate for all owners in the company, "standard" to aggregate only for the current logged-in user.
  * @returns array Array of stdClass result objects, each containing at least "owner" and the summed "sub_totalq".
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
  * Retrieve summed estimates grouped by owner for a given date or the last month, filtered by user type and session company.
  * @example
  * $result = $this->Reports_model1->get_all_estimate_by_date('last month', 'admin');
  * echo json_encode($result); // [{"owner":"Alice","sub_totalq":"12345.67"},{"owner":"Bob","sub_totalq":"9876.54"}]
  * @param {string} $date - Date string used as start (e.g. '2025-11-01') or special value 'last month' to query the previous calendar month.
  * @param {string} $type - User type filter: 'admin' (company-wide) or 'standard' (company + user-specific).
  * @returns {array} Return array of result objects (each object contains at least 'owner' and summed 'sub_totalq').
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
  * Get the top opportunities by user/company limited to recent records (used to build leaderboards).
  * @example
  * $result = $this->Reports_model1->get_top_opp_by_user('standard');
  * print_r($result); // sample output: Array ( [0] => stdClass Object ( [sub_total] => 12500.50 [owner] => "alice@example.com" [currentdate] => "2025-12-01" ) )
  * @param {string} $type - 'standard' to return current user's opportunities, 'admin' to return summed opportunities grouped by owner.
  * @returns {array|false} Return array of result objects (rows) on success, or false if no records found.
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
  * Retrieve top opportunities filtered by date and user type, returning the top 10 results ordered by sub_total.
  * @example
  * $result = $this->Reports_model1->get_top_opp_by_date('admin', '2025-01-01', '2025-01-01', '2025-12-31');
  * print_r($result); // Example output: array of result objects or false if none found
  * @param {string} $type - Type of query to run, either 'standard' (current user) or 'admin' (grouped by owner).
  * @param {string} $date - Optional single start date filter in 'YYYY-MM-DD' format (applies as currentdate >= $date).
  * @param {string} $from_date - Optional range start date in 'YYYY-MM-DD' format.
  * @param {string} $to_date - Optional range end date in 'YYYY-MM-DD' format.
  * @returns {array|false} Return array of result objects (up to 10) ordered by sub_total desc, or false if no records found.
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
  * Get top quotations by user for the current company from the beginning of the current month (returns top 10 owners ordered by subtotal).
  * @example
  * $result = $this->Reports_model1->get_top_quotation_by_user('admin');
  * var_dump($result); // e.g. array(0 => (object) ['owner' => 'Acme Ltd', 'sub_totalq' => '12500'], 1 => (object) ['owner' => 'John Doe', 'sub_totalq' => '9800']);
  * @param {string} $type - Report type: 'standard' to filter by the logged-in user, 'admin' to aggregate across all owners.
  * @returns {array|false} Array of stdClass result objects when records are found, or false if no records exist.
  */
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
  * Retrieve top quotes by date for the current session company (limited to 10, ordered by sub_totalq desc).
  * @example
  * // For a standard user - returns up to 10 quotes for the current user on or after 2025-01-01
  * $result = $this->Reports_model1->get_top_quote_by_date('standard', '2025-01-01');
  * // sample returned value (array of objects) e.g.:
  * // [
  * //   (object)['owner' => 'john.doe@example.com', 'sub_totalq' => '1200.00', 'currentdate' => '2025-01-02'],
  * //   (object)['owner' => 'john.doe@example.com', 'sub_totalq' => '900.00', 'currentdate' => '2025-01-05']
  * // ]
  * @param {string} $type - 'standard' to filter by current session user or 'admin' to get max sub_totalq per owner.
  * @param {string} $date - Optional single date (YYYY-MM-DD) to include records on or after this date.
  * @param {string} $from_date - Optional start date (YYYY-MM-DD) for a date range filter.
  * @param {string} $to_date - Optional end date (YYYY-MM-DD) for a date range filter.
  * @returns {array|false} Array of result objects (max 10) when records found, or false when no records match.
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
  * Get aggregated sales orders for the current session company filtered by user type and date range.
  * @example
  * $result = $this->Reports_model1->get_all_so_by_user('standard');
  * print_r($result); // sample output: [0 => stdClass { status: "Approved", owner: "user@example.com", sub_totals: "1500.00", after_discount: "1400.00" }, ...] or bool(false)
  * @param {{string}} {{$type}} - Type of aggregation: 'standard' to limit to the logged-in user, 'admin' to aggregate by owner.
  * @returns {{array|false}} Returns an array of result objects (stdClass) when records are found, or false if no records exist.
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
  * Get summed sales orders grouped and filtered by date and user type.
  * @example
  * $result = $this->Reports_model1->get_all_so_by_date('admin', '2025-01-01');
  * var_dump($result); // Example output: array( (object) ['status'=>'Approved','owner'=>'Alice','sub_totals'=>'1234.56'], ... ) or bool(false)
  * @param {string} $type - 'admin' to filter Approved and group by owner, 'standard' to group by status.
  * @param {string} $date - (optional) single date filter; fetch records on or after this date. Format: 'YYYY-MM-DD'. Example: '2025-01-01'.
  * @param {string} $from_date - (optional) range start date. Format: 'YYYY-MM-DD'. Example: '2025-01-01'.
  * @param {string} $to_date - (optional) range end date. Format: 'YYYY-MM-DD'. Example: '2025-01-31'.
  * @returns {array|false} Returns an array of result objects with summed sub_totals grouped by the chosen key, or false if no records found.
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
  * Get the top purchase orders for the current period, either for the logged-in user or aggregated by owner (admin).
  * @example
  * $result = $this->Reports_model1->get_top_po_by_user('standard');
  * // sample output (array of objects):
  * // array(1) { [0]=> object(stdClass)#1 (3) { ["currentdate"]=> string(10) "2025-12-16" ["sub_total"]=> string(7) "1500.00" ["subject"]=> string(6) "PO-123" } }
  * @param {string} $type - Report type: 'standard' to return top POs for the logged-in user; 'admin' to return top POs aggregated by owner.
  * @returns {array|false} Returns an array of result objects (fields include currentdate, sub_total and subject for 'standard', or currentdate, sub_total (SUM) and owner for 'admin') or false if no records found.
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
  * Get the top 10 purchase orders by sub_total (descending), optionally filtered by a single date or a date range. For 'standard' type the results are user-specific, for 'admin' type results are grouped by owner.
  * @example
  * $result = $this->Reports_model1->get_top_po_by_date('standard', '2025-01-01', '2025-01-01', '2025-01-31');
  * print_r($result); // Sample output: [ (object) ['currentdate'=>'2025-01-15','sub_total'=>'1250.00','subject'=>'PO-123'], (object) ['currentdate'=>'2025-01-10','sub_total'=>'950.00','subject'=>'PO-122'] ]
  * @param {string} $type - Type of query: 'standard' (user-specific) or 'admin' (group by owner).
  * @param {string} $date - Optional single date filter (applies as currentdate >= $date). Format: 'YYYY-MM-DD'.
  * @param {string} $from_date - Optional start date for range filter (format 'YYYY-MM-DD').
  * @param {string} $to_date - Optional end date for range filter (format 'YYYY-MM-DD').
  * @returns {array|false} Return array of result objects when records are found, or false if no records. 
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
  * Retrieve up to 8 leads assigned to other users within the same session company and company email.
  * @example
  * $result = $this->assigned_lead_status('acme@company.com', 'john.doe@company.com', 'Acme Corp');
  * print_r($result); // sample output: array( [0] => array('id' => 123, 'assigned_to' => 'jane.doe@company.com', 'assigned_to_name' => 'Jane Doe', ...) ) or bool(false)
  * @param string $session_comp_email - Company email associated with the current session.
  * @param string $sess_eml - Current user's email; leads assigned to this email are excluded.
  * @param string $session_company - Current session company identifier or name.
  * @returns array|false Return an array of lead records (max 8) matching the filters, or FALSE if no records found.
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
  * Prepare the CodeIgniter query builder used to populate the dashboard "profit" DataTable.
  * Builds a grouped SELECT (by SO.owner) with aggregated totals, applies session/company constraints,
  * filters to the current fiscal year, optional user search (from $_POST['search']['value']), and ordering
  * (from $_POST['order']). This method configures $this->db but does not execute the query or return data.
  * @example
  * // Called internally inside Reports_model1 (private). Example usage for debugging:
  * $this->_get_dashboard_profit_datatables_query();
  * // Then inspect the compiled SQL (debugging example):
  * echo $this->db->get_compiled_select('salesorder as SO');
  * // Example of a possible compiled SQL (simplified):
  * // SELECT SO.owner, SUM(SO.sub_totals) AS So_total, SUM(SO.total_estimate_purchase_price) AS So_total_estimate_price, SUM(SO.profit_by_user) AS profitUser
  * // FROM `salesorder` as SO
  * // WHERE SO.session_comp_email = 'company@example.com' AND SO.session_company = 'ACME' AND SO.delete_status = 1
  * //   AND SO.currentdate >= '2025-04-01' AND SO.currentdate <= '2026-03-31'
  * // GROUP BY SO.owner
  * @param void $none - No direct parameters; the method reads session data and $_POST for filtering and ordering.
  * @returns void Configures the active record query on $this->db; does not return a result set.
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
   * Count grouped sales orders for the dashboard within the current fiscal year for the active session company.
   * @example
   * $count = $this->Reports_model1->count_all_dashboard_profit();
   * echo $count; // e.g. 5
   * @param void $none - No parameters are accepted by this method.
   * @returns int Total number of salesorder groups (grouped by owner) that match the fiscal-year date range and session company/email filters.
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
  * Update the report date for a specific sales order.
  * @example
  * $result = $this->Reports_model1->salesorder_reportdate('2025-12-17', 123);
  * echo $result; // true on successful update, false on failure
  * @param {string} $reportdate - New report date (e.g., 'YYYY-MM-DD') to set for the sales order.
  * @param {int} $saleorder_id - ID of the sales order to update.
  * @returns {bool} True if the salesorder record was updated successfully, false otherwise.
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
* Get purchase profit grouped by owner for the current company and applied filters.
* @example
* $result = $this->Reports_model1->get_purchase_profit_graph();
* print_r($result); // sample output: Array ( [0] => stdClass Object ( [owner] => 'john.doe@example.com' [profit_by_user_po] => '1234.56' ) )
* @param {void} none - No arguments.
* @returns {array} Array of stdClass objects where each object contains 'owner' (string) and 'profit_by_user_po' (float) representing aggregated profit per owner.
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
  * Get sales orders grouped by owner with summed sub_totals, filtered by date and search parameters.
  * @example
  * $params = array(
  *   'search' => array(
  *     'keywords'  => 'Alice',                 // owner name to search
  *     'sortBy'    => '2025-01-01',           // currentdate >= this value
  *     'sortFrom'  => '2025-01-01',           // currentdate > this value
  *     'sortTo'    => '2025-12-31'            // currentdate < this value
  *   ),
  *   'start' => 0,
  *   'limit' => 10
  * );
  * // Example: get month-to-date grouped sales orders for company in session
  * $result = $this->Reports_model1->get_so_for_record('Month', $params);
  * print_r($result); // e.g. Array ( [0] => Array ( [id] => 5 [status] => Approved [owner] => Alice [sub_totals] => 12345.67 ) )
  * @param {string} $date - Period specifier; if set to "Month" the query filters to month-to-date.
  * @param {array} $params - Optional associative array of query modifiers. Recognized keys:
  *                          'search' => array with 'keywords', 'sortBy', 'sortFrom', 'sortTo';
  *                          'start' => int (offset for limit), 'limit' => int (max rows).
  * @returns {array|null} Return array of grouped sales order rows with summed sub_totals when records exist, or null if none found.
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
    if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
        $this->db->limit($params['limit'],$params['start']);
    }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
    {
        $this->db->limit($params['limit']);
    }
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
   * Retrieve lead counts grouped by status for the current company (admin only).
   *
   * @example
   * // Called from a controller or another model after session is initialized for an admin user
   * $result = $this->Reports_model1->get_leads_status();
   * // Possible sample $result:
   * // [
   * //   ['total_count' => '25', 'lead_status' => 'New'],
   * //   ['total_count' => '10', 'lead_status' => 'Contacted'],
   * // ]
   * // Or when there are no matching rows:
   * // false
   *
   * @return array|false Array of associative arrays with keys 'total_count' and 'lead_status', or false if no rows found.
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
   * Get counts of opportunities grouped by their stage for the current company (admin only).
   * @example
   * $this->load->model('Reports_model1');
   * $result = $this->Reports_model1->get_opp_stage();
   * // Sample output:
   * // [
   * //   ['total_count' => '5', 'stage' => 'Proposal'],
   * //   ['total_count' => '3', 'stage' => 'Negotiation']
   * // ]
   * @param void $none - This method uses session data and accepts no arguments.
   * @returns array|false|null Returns an array of associative arrays with keys 'total_count' and 'stage' grouped by stage when records exist, false if no matching records are found, or null if the current user is not an admin (no result returned).
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
  * Get quote counts grouped by quote_stage for the current company (admin only).
  * @example
  * // From a controller or anywhere the model is loaded:
  * $this->load->model('Reports_model1');
  * $result = $this->Reports_model1->get_quote_stage();
  * // Example successful return:
  * // [
  * //   ['total_count' => 12, 'quote_stage' => 'Prospecting'],
  * //   ['total_count' => 5,  'quote_stage' => 'Negotiation'],
  * // ]
  * var_export($result);
  * @param void $none - No parameters.
  * @returns array|false|null Returns an array of associative arrays (keys: 'total_count' => int, 'quote_stage' => string) when rows exist, false if the query returned no rows, or null if the current session user is not an admin.
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
   * Get leads report grouped by user for the current company and date range (from start of current month to today).
   * @example
   * $result = $this->Reports_model1->get_report_leads_by_user('standard');
   * // sample output (array of objects):
   * // [
   * //   (object) ['id' => 10, 'lead_owner' => 'john.doe@example.com', 'total_leads' => '5'],
   * //   (object) ['id' => 12, 'lead_owner' => 'jane.smith@example.com', 'total_leads' => '3'],
   * // ]
   * print_r($result);
   * @param string $type - Type of report scope: 'standard' (restrict to current session user) or 'admin' (company-wide).
   * @returns array|false Return an array of result objects (each contains id, lead_owner and total_leads) on success, or false if no records found.
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
   * Prepare the active record query to fetch lead counts grouped by lead owner.
   * This helper configures $this->db (select, from, where, group_by, order_by, like)
   * based on current session (admin or standard), optional POST 'sortdate',
   * search value (DataTables), and ordering parameters. It does not execute the query.
   *
   * @example
   * // Example: for a standard user session:
   * // $_SESSION['type'] = 'standard';
   * // $_SESSION['email'] = 'user@example.com';
   * // $_SESSION['company_email'] = 'comp@example.com';
   * // $_SESSION['company_name'] = 'Acme Inc';
   * $this->_get_lead_for_record_query();
   * // Execute and fetch:
   * // $query = $this->db->get();
   * // $result = $query->result_array(); // e.g. [['lead_owner' => 'Alice', 'total_leads' => 5], ...]
   *
   * @returns {void} Sets up the query on $this->db; no value is returned.
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
      $this->db->group_by('lead_owner');
      //get records
    }
    else if($this->session->userdata('type')=='admin')
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
  * Retrieve leads grouped by lead owner and count total leads, optionally filtered by a single date or a date range and scoped by user type and session company.
  * @example
  * $result = $this->Reports_model1->get_all_leads_by_date('standard','2025-01-15','2025-01-01','2025-01-31');
  * print_r($result); // Example output: Array ( [0] => stdClass Object ( [id] => 1 [lead_owner] => Alice [total_leads] => 5 ) )
  * @param {{string}} {{type}} - User type scope: 'standard' (limits to current user + session company) or 'admin' (limits to session company only).
  * @param {{string}} {{date}} - Optional single date filter (YYYY-MM-DD). When provided, applies WHERE currentdate >= $date.
  * @param {{string}} {{from_date}} - Optional start date for range filter (YYYY-MM-DD). Used together with $to_date to apply a date range.
  * @param {{string}} {{to_date}} - Optional end date for range filter (YYYY-MM-DD). Used together with $from_date to apply a date range.
  * @returns {{array|false}} Returns an array of result objects grouped by lead_owner with fields (id, lead_owner, total_leads) or false if no records found.
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
  * Count all leads for the current session/company (respects 'standard' user restriction).
  * @example
  * $result = $this->Reports_model1->count_all_leads();
  * echo $result; // e.g. 42
  * @param void $none - This method accepts no parameters.
  * @returns int Total number of lead records matching the current session/company and user type.
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
  * Build and configure a CodeIgniter query that aggregates opportunity sub_totals by owner for recent records, excluding closed stages.
  * @example
  * $this->Reports_model1->_get_opp_for_record_query();
  * $query = $this->db->get(); // execute the configured query
  * print_r($query->result()); // e.g. Array ( [0] => stdClass Object ( [id] => 1 [owner] => "John Doe" [sub_total] => "12345.67" ) )
  * @param {void} none - No arguments.
  * @returns {void} Configures the active CI query builder; does not return a value.
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
  * Count all opportunity records for the current session's company and company email.
  * Applies an additional filter by the session user's email when the session user type is 'standard'.
  * @example
  * // from a controller
  * $this->load->model('Reports_model1');
  * $result = $this->Reports_model1->count_all_opp();
  * echo $result; // e.g. 42
  * @param void $none - This method accepts no parameters.
  * @returns int Total number of matching opportunity records.
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
  * Build and prepare the database query to fetch aggregated quote records filtered by current session company/email, date range, delete status, search and ordering parameters for datatable usage.
  * @example
  * // Called internally from the model to prepare the query builder:
  * $this->_get_quote_for_record_query();
  * // No direct return; prepares $this->db query selecting id, owner, COUNT("owner") as total_quote and MAX(sub_totalq)
  * @param {void} none - No arguments required.
  * @returns {void} Prepares the query on $this->db; does not return a value.
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
  * Count all quotes for the current session's company (and for the current user when session type is 'standard').
  * @example
  * $result = $this->Reports_model1->count_all_quote();
  * echo $result; // 42
  * @param void - No parameters.
  * @returns int Total number of quotes filtered by session company and company_email; restricted to the session email when user type is 'standard'.
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
   * Prepare the query builder to retrieve approved sales orders aggregated by owner.
   * This method configures $this->db (CodeIgniter query builder) to:
   * - select id, status, owner and SUM(sub_totals)
   * - filter by current session company name/email
   * - include only Approved and non-deleted records
   * - filter by date (POST 'sortdate' if provided, otherwise a default range)
   * - apply search filtering using $this->sales_search_by and $_POST['search']['value']
   * - apply ordering from $_POST['order'] or $this->sales_order
   * @example
   * // Called inside Reports_model1 (no arguments). After calling, execute the query:
   * $this->_get_sales_for_record_query();
   * $query = $this->db->get(); // execute prepared query
   * $rows = $query->result(); // sample result: array of objects
   * // sample single row output:
   * // (object) ['id' => 42, 'status' => 'Approved', 'owner' => 'Jane Doe', 'sub_totals' => '1250.50']
   * @param void None - Uses session and POST data internally; no parameters required.
   * @returns void Prepares/sets the active query on $this->db; does not return a value.
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
    }
    else
    {
      $this->db->where('currentdate>=',date('Y-m-d', $w));
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
  * Count all sales matching the current session's company and, if the session user is of type "standard", limited to that user's email.
  * @example
  * $this->load->model('Reports_model1');
  * $result = $this->Reports_model1->count_all_sales();
  * echo $result; // e.g. 42
  * @param void $none - No parameters.
  * @returns int Number of sales records matching the session filters.
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
   // Salesorder Profit Table
  var $so_sort_by = array('owner','currentdate','saleorder_id','org_name','due_date','after_discount',null);
  var $so_search_by = array('owner','currentdate','saleorder_id','org_name','due_date','after_discount');
  var $so_order = array('id' => 'desc');
  /**
   * Build the CodeIgniter query used by DataTables for Sales Orders (salesorder table).
   * This private method applies session-based filters (admin vs standard), optional POST filters
   * (searchUser, searchDate), a default date range (from the first day of the current month),
   * global search across configured columns ($this->so_search_by) and ordering from DataTables
   * ($_POST['order']) or the model's default order ($this->so_order). The method configures
   * $this->db but does not execute the query (no direct return).
   * @example
   * $this->load->model('Reports_model1');
   * // inside the model or controller context that has $this->db available:
   * $this->Reports_model1->_get_datatables_query_so();
   * $query = $this->db->get('salesorder');
   * $results = $query->result();
   * echo count($results); // e.g. 12
   * @param void - No parameters.
   * @returns void Builds and configures the CI query for DataTables (no direct return).
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
        $this->db->where('sess_eml',$search_user);
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
      else
      {
        $y = strtotime('-1day');
        $x = date('d',$y);
        $w = strtotime('-'.$x.'days');
        $this->db->where('currentdate >=',date('Y-m-d', $w));
      }
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
  }
  public function count_filtered_so()
  {
    $this->_get_datatables_query_so();
    $query = $this->db->get();
    return $query->num_rows();
  }
  /**
  * Count all sales orders (SO) for the current company session.
  * @example
  * $count = $this->Reports_model1->count_all_so();
  * echo $count; // e.g. 42
  * @returns {int} Total number of salesorder records matching the session filters.
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
  * Prepare and apply a purchase order aggregation query to $this->db (grouped by owner, filtered by session company/email, date range and search/order parameters).
  * @example
  * // Call the method to build the query on the active CI database object, then execute the query to fetch results:
  * $this->reports_model1->_get_po_for_record_query();
  * $result = $this->db->get()->result();
  * echo json_encode($result); // sample output: [{"owner":"Acme Corp","sub_total":"12345.67"}]
  * @param void none - This method accepts no parameters; it reads session and POST data internally.
  * @returns void Applies SELECT, WHERE, GROUP BY and ORDER BY clauses to $this->db; does not return a value.
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
  * Count all purchase orders for the current session/company.
  * @example
  * $count = $this->Reports_model1->count_all_po();
  * echo $count; // e.g., 42
  * @returns {int} Total number of purchase orders matching the current session/company.
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
  * Prepare a CodeIgniter query for product datatables applying session and POST filters and ordering; if $profit === 'profit' the query selects the SUM(profit_by_user) instead of row columns.
  * @example
  * // Prepare query to get summed profit for current filters
  * $this->Reports_model1->_get_product_datatables_query('profit');
  * $result = $this->db->get()->row_array(); // execute the prepared query
  * echo $result['profit_by_user']; // e.g. "1250.50"
  * @param string $profit - Optional. Set to 'profit' to select SUM(profit_by_user). Default is '' to select individual columns (owner, saleorder_id, subject, etc.).
  * @returns void Prepares and modifies the $this->db query builder state; does not return a value.
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
    $searchUser = $this->input->post('searchUser');
      if($this->session->userdata('type')=='standard')
      {
         $this->db->where('sess_eml',$sess_eml);
      }else if($searchUser!=""){
         $this->db->where('sess_eml',$searchUser);  
      }
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      
      if($this->input->post('search_data'))
      {
        
         $searchOrg = $this->input->post('search_data');
         $this->db->where('org_name', $searchOrg);
      }
     
      $this->db->where('total_percent','0');
      $this->db->where('delete_status',1);
      if($this->input->post('searchMonth'))
      { 
        $year_date = $this->input->post('searchYear');
        $month_date = $this->input->post('searchMonth');
        $curndth=$year_date."-".$month_date."-01";
        $a_date = date($curndth);
        $lastday=date("Y-m-t", strtotime($a_date)); 
        $this->db->where('currentdate >=',$curndth);
        $this->db->where('currentdate <=',$lastday);
        
      }else if($this->input->post('searchDate'))
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
  * Build the CodeIgniter query for product-related datatables based on session type, POST filters and model search/sort configuration.
  * @example
  * // Call from within the same model to prepare the query builder with filters applied
  * $this->_get_pro_datatables_query_old();
  * $query = $this->db->get(); // execute the prepared query
  * $results = $query->result();
  * print_r($results); // sample output:
  * // Array
  * // (
  * //     [0] => stdClass Object
  * //         (
  * //             [owner] => "john.doe@example.com"
  * //             [saleorder_id] => "SO-123"
  * //             [purchaseorder_id] => "PO-456"
  * //             [subject] => "Website Redesign"
  * //             [after_discount] => "950.00"
  * //             [after_discount_po] => "900.00"
  * //         )
  * // )
  * @param void None - This method accepts no arguments; it relies on session data, POST input and model properties.
  * @returns void Configures the active CI DB query builder (no direct return). 
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
  * Count all sales orders for the current session/company, and if the logged-in user is of type 'standard' limit the count to that user's email.
  * @example
  * $result = $this->Reports_model1->count_all_pro();
  * echo $result; // e.g. 42
  * @param void $none - This method accepts no parameters; it uses session data internally.
  * @returns int Total number of matching rows in the 'salesorder' table.
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
  
  var $pro_ws_sort_by = array('PO.owner','PO.saleorder_id','PO.purchaseorder_id','PO.subject','PO.profit_by_user_po');
 
 var $pro_ws_search_by = array('PO.owner','PO.saleorder_id','PO.purchaseorder_id','PO.subject','PO.profit_by_user_po');
  var $pro_ws_order = array('PO.id' => 'desc');
  

/**
* Build and apply a CodeIgniter DB query for product-wise purchase order datatables (applies filters, search and ordering to $this->db).
* @example
* // Called from model or controller (method is private; typically invoked internally)
* $this->Reports_model1->_get_pro_datatables_query_product_wise();
* // After calling, execute the query and fetch results:
* $query = $this->db->get(); // CI_DB_result
* $rows = $query->result(); // sample output: array of stdClass objects representing purchase orders
* // Example sample output for one row:
* // stdClass Object ( [owner] => "Alice" [saleorder_id] => "SO123" [purchaseorder_id] => "PO456" [profit_by_user_po] => "150.00" [subject] => "Product A" )
* @param {void} $none - No parameters required; function reads input and session data internally.
* @returns {void} Applies query clauses (select, where, like, group, order) to $this->db; does not return a value.*/
private function _get_pro_datatables_query_product_wise(){
   
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
   
    $this->db->select('PO.owner,PO.saleorder_id,PO.purchaseorder_id,PO.profit_by_user_po,PO.subject');
    $this->db->from('purchaseorder as PO');
    $this->db->where('PO.session_comp_email',$session_comp_email);
    $this->db->where('PO.session_company',$session_company);
    $this->db->where('PO.delete_status',1);
	
	if($this->session->userdata('type')==='standard'){
		$this->db->where('PO.sess_eml',$sess_eml);
	}else if($this->input->post('searchUser')){ 
        $search_user = $this->input->post('searchUser');
        $this->db->where('PO.sess_eml',$search_user);
    }

    if($this->input->post('monthDate')){ 
        $year_date  = $this->input->post('yearDate');
        $month_date = $this->input->post('monthDate');
        $curndth    = $year_date."-".$month_date."-01";
        $a_date     = date($curndth);
        $lastday    = date("Y-m-t", strtotime($a_date));
        
        $this->db->where('PO.currentdate >=',$curndth);
        $this->db->where('PO.currentdate <=',$lastday);
        
    }else if($this->input->post('searchDate')){
          
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week"){
            $this->db->where('PO.currentdate >=',date('Y-m-d',strtotime('last monday')));
        }else{
          $this->db->where('PO.currentdate >=',$search_date);
        }
    }else{
        $y = strtotime('-1day');
        $x = date('d',$y);
        $w = strtotime('-'.$x.'days');
        $this->db->where('PO.currentdate >=',date('Y-m-d', $w));
    }
    
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
  * Count all purchase order records for the current user/company session.
  * @example
  * $count = $this->Reports_model1->count_all_pro_product_wise();
  * echo $count; // e.g. 42
  * @param {void} none - No function arguments; uses session data (email, company_name, company_email, user type) internally.
  * @returns {int} Total number of matching purchaseorder records.
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
   * Retrieve aggregated product-wise profit sums for a specific sales order filtered by the current session company.
   * @example
   * $result = $this->Reports_model1->get_Actual_profit_datatables_product_wise(123, 456);
   * print_r($result); // sample output: array(array('po_total_price' => '1500.00', 'so_pro_total' => '1200.00', 'so_id' => '123'))
   * @param int $soid - Sales order ID used to filter the product-wise profit totals.
   * @param int $poid - Purchase order ID (currently unused in the query, provided for API consistency).
   * @returns array Return an array of aggregated sums (po_total_price, so_pro_total, so_id) matching the filters.
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
* Build the CodeIgniter query used by product-wise profit DataTables, applying session/company filters, date range, user filters and search conditions.
* @example
* // Called from within the model (no arguments required)
* $this->_get_pro_datatables_query_product_wise_count();
* $query = $this->db->get(); // execute the built query
* echo $query->num_rows(); // render some sample output value, e.g. 42
* @param void none - No parameters.
* @returns void Returns nothing; the method prepares the active record query on $this->db.
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
  
  
 var $pro_renewal_sort_by  = array('owner','org_name','product_name','saleorder_id','renewal_date','currentdate','sub_totals');
 var $pro_renewal_search_by = array('owner','org_name','product_name','saleorder_id','renewal_date','currentdate','sub_totals');
 var $pro_renewal_order     = array('id' => 'desc');
  
  /**
  * Prepare a filtered salesorder renewal query. Builds CodeIgniter query builder conditions for renewal sales orders (filters by session company/email, user type or posted searchUser, date ranges, searchable columns and ordering). When $sum is non-empty the method selects SUM(sub_totals); otherwise it selects detailed columns for each renewal record.
  * @example
  * // Prepare a summed total of sub_totals for renewals (for current session/company and current month)
  * $this->Reports_model1->_renewal_data_so('sum');
  * // Execute the prepared query and fetch the summed value:
  * $row = $this->db->get('salesorder')->row();
  * echo $row->sub_totals; // sample output: 12345.67
  * @param {string} $sum - Optional flag (default ''). If non-empty, the query will select SUM(sub_totals) instead of detailed columns.
  * @returns {void} Configures the active CI query builder; does not return a value. */
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
	
	if($this->session->userdata('type')==='standard'){
		$this->db->where('sess_eml',$sess_eml);
	}else if($this->input->post('searchUser')){ 
        $search_user = $this->input->post('searchUser');
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
        
      }else if($this->input->post('searchFromDate')){ 
        $search_from_date = $this->input->post('searchFromDate');
        $search_to_date   = $this->input->post('searchToDate');
          $this->db->where('renewal_date >=',$search_from_date);
          $this->db->where('renewal_date <=',$search_to_date);
        
      }else{
		$year_date = date('Y');
		$month_date = date('m');
		$curndth=$year_date."-".$month_date."-01";
        $this->db->where('renewal_date >=',$curndth);        
      }
	  
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
   * $result = $this->Reports_model1->getOrg();
   * // Example output when records exist:
   * // Array (
   * //   [0] => Array ( 'org_name' => 'Acme Corp', 'sess_eml' => 'user@example.com', 'other_field' => 'value' ),
   * //   [1] => Array ( 'org_name' => 'Beta LLC', 'sess_eml' => 'user@example.com', 'other_field' => 'value' )
   * // )
   * // Example when no records:
   * // bool(false)
   * @param void $none - No parameters.
   * @returns array|false Return array of associative arrays (grouped by org_name) on success, or false if no matching records are found.
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
  * Count renewal sales orders for the current session's company and user scope.
  * @example
  * $result = $this->Reports_model1->count_renewal_data_so();
  * echo $result; // e.g. 5
  * @returns {int} Total number of renewal sales orders matching the current session filters.
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
  * Retrieve top customers by subtotal and profit (grouped by organization) limiting to top 8.
  * @example
  * $result = $this->Reports_model1->gettoptencus(['status' => 'completed'], 2024, 6, '2024-01-01', '2024-12-31', null);
  * print_r($result); // sample output: Array of stdClass objects with properties owner, org_name, total_subtotal, totalprofit
  * @param {array|string|null} $where - Optional where clause (array or SQL string) to filter records.
  * @param {int|null} $profityear - Optional year to filter by YEAR(currentdate).
  * @param {int|null} $profitmonth - Optional month to filter by MONTH(currentdate) (used with profityear).
  * @param {string|null} $dateRangeStart - Optional start date (YYYY-MM-DD) for a date range filter.
  * @param {string|null} $dateRangeEnd - Optional end date (YYYY-MM-DD) for a date range filter.
  * @param {int|null} $financial - Optional financial year start (e.g., 2023 representing Apr 2023 - Mar 2024) used when date range is not provided.
  * @returns {array} Returns an array of result objects (stdClass) grouped by org_name with fields owner, org_name, total_subtotal and totalprofit.
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
* Retrieve the top five quotes ordered by sub_totalq (descending) with optional filtering by where clause, profit year/month, date range, or financial year.
* @example
* $result = $this->Reports_model1->toptenquote(['status' => 'approved'], 2024, 5);
* echo print_r($result->result_array(), true); // Example output: array of up to 5 quote rows ordered by sub_totalq desc
* @param array|string|null $where - Additional WHERE condition (associative array or SQL string) to apply to the query.
* @param int|null $profityear - Year to filter quotes by YEAR(currentdate) (e.g., 2024).
* @param int|null $profitmonth - Month to filter quotes by MONTH(currentdate) (1-12).
* @param string|null $dateRangeStart - Start date for range filter in 'YYYY-MM-DD' format.
* @param string|null $dateRangeEnd - End date for range filter in 'YYYY-MM-DD' format.
* @param int|null $financial - Financial year start (integer year). When provided, filters from April of this year through March of the next (e.g., 2023 for Apr 2023 - Mar 2024).
* @returns CI_DB_result Query result object containing up to 5 matching quote rows ordered by sub_totalq descending.
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