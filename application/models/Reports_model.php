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