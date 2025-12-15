<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Aifilters_model extends CI_Model
{

  var $table = 'salesorder';
  var $sort_by = array(null,'subject','org_name','saleorder_id','owner','status','approved_by','datetime',null);
  var $search_by = array('subject','org_name','saleorder_id','owner','status','approved_by','datetime');
  var $order = array('id' => 'desc');
  
  private function _get_datatables_query($action='')
  {
    // print_r('testinf');die;
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');

        $this->db->from($this->table);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);

    // < ------------------Search data by date --------------------->
    if ($this->input->post('start_date') && $this->input->post('end_date')) {
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');
        // print_r('test');die;
        // Apply the date filtering
        $this->db->where('currentdate >=', $startDate);
        $this->db->where('currentdate <=', $endDate);
    }

    if($this->input->post('searchUser'))
    { 
      $searchUser = $this->input->post('searchUser');
        $this->db->where('sess_eml',$searchUser); 
    }

    if($this->input->post('searchcustomer'))
    { 
        $searchcustomer = $this->input->post('searchcustomer');
        $this->db->where('org_id',$searchcustomer);  
    }

    if($this->input->post('searchsaleID'))
    { 
        $searchsalesID = $this->input->post('searchsaleID');
        $this->db->where('saleorder_id',$searchsalesID);  
    }

    if($this->input->post('searchPo'))
    { 
        $searchPo = $this->input->post('searchPo');
        $this->db->where('po_no',$searchPo);  
    }

    if($this->input->post('searchPoDate'))
    { 
        $searchPoDate = $this->input->post('searchPoDate');
        $this->db->where('po_date >=', $searchPoDate);
        $this->db->where('po_date <=', $searchPoDate);
        
    }


    if ($this->input->post('new_Renew')) {
          $new_Renew = $this->input->post('new_Renew');
            if($new_Renew === "new") {
                  $this->db->like('salesorder_item_type', '0');
            }elseif ($new_Renew === "renew") {
                  $this->db->like('salesorder_item_type', '1');
            }
    }

      $this->db->where('delete_status',1);
      if($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po')!='1' ) 
        {
        $this->db->where('sess_eml',$sess_eml);
      }
    
    $i = 0;
    foreach ($this->search_by as $item)
    {
        $search_data='';
        if(isset($_POST['search']['value']) && $_POST['search']['value']!=""){
            $search_data=$_POST['search']['value'];
        }else if($this->input->post('search_data')){
            $search_data=$this->input->post('search_data');
        }
        if(isset($search_data) && $search_data!="" ) 
        {
            if($i===0)
            {
                $this->db->group_start(); 
                $this->db->like($item, $search_data);
            }
            else
            {
                $this->db->or_like($item, $search_data);
            }
            if(count($this->search_by) - 1 == $i) 
                $this->db->group_end(); 
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



   public function getdata($sel, $tbl, $whr = null, $grp = null,$orderby= null,$order='desc',$limit=null) 
   {
   
        // Reset any previous selections
        $this->db->reset_query();

            if($grp == 'organization'){
                $grp = 'org_name';
            }
            else if($grp == 'user'){
                if($tbl=='Lead'){
                $grp = 'lead_owner';
            }
            else{
                $grp = 'owner';
            }
            }
            
        // Construct the select statement
        if ($sel !== null) {
            $this->db->select($sel);
        }
        
        $this->db->from($tbl);
        
        // Apply the WHERE clause if provided and not equal to 'all'
        if ($whr !== null) {
            $this->db->where($whr);
        }
        // Apply the GROUP BY clause if provided
        if ($grp !== null) {
            $this->db->group_by($grp);

        }
        if($orderby != null){
            $this->db->order_by($orderby,$order);
        }
        else{
            $this->db->order_by('subtotal','desc');
        }
      if($limit != null){
        $this->db->limit($limit);
      }
    
        //    $this->db->limit(20);
        // Execute the query
        $query = $this->db->get();
       
        // Return the result as an array
        return $query->result_array();
    }

    public function getcoldata($sel,$tbl,$cond){
      
        $this->db->select($sel);
        $this->db->from($tbl);
        $this->db->where($cond);
        $this->db->group_by($sel);
        return $this->db->get();
    }

// < --------------------------- Star Ai Filters ------------------------------------------>


    public function get_all_customers() {
        $this->db->select('id, org_name');
        $this->db->from('organization');
        $this->db->where('delete_status',1);
        $this->db->group_by('org_name');
    
        $query = $this->db->get();
        $customers = $query->result_array();
        return $customers;
    }

    public function get_all_saleId() {
        $this->db->select('id, saleorder_id');
        $this->db->from('salesorder');
        $this->db->where('delete_status',1);
        $this->db->where('org_id !=', 0);
        $query = $this->db->get();
        $saleId = $query->result_array();
        return $saleId;
    }
    
    public function get_all_org($orgId = null) {
        // print_r($orgId);die;
        $this->db->select('*');      
        $this->db->from('salesorder');

        if (!empty($orgId)) {
            $this->db->where('org_id', $orgId);
        }

        $this->db->where('delete_status',1);
        $query = $this->db->get();
        $orgName= $query->result_array();
        return $orgName;
    }


    // public function get_filtered_Alldata()
    // {
    //     // Select the necessary columns
    //     $this->db->select('*');
    //     $this->db->from('salesorder');
    //     $this->db->where('delete_status', 1);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }


    public function get_filtered_Alldata()
    {
        // Select the necessary columns
        $this->db->select('*');
        $this->db->select('SUM(initial_total) as total_initial_total, SUM(sub_totals) as total_sub_total');
        $this->db->from('salesorder');
        
        $this->db->where('delete_status', 1);
        // Group by organization name
        $this->db->group_by('org_id');
        $this->db->where('org_id!=' ,0);
    
        // Execute the query
        $query = $this->db->get();
        // echo $this->db->last_query($query); die;

        // Return the result as an array
        return $query->result_array();
    }


    public function get_filtered_data($filterUser = null, $org_id = null, $salesId = null, $startDate = null, $endDate = null) {
        // Select the necessary columns
        $this->db->select('*');
        $this->db->select('SUM(initial_total) as total_initial_total, SUM(sub_totals) as total_sub_total');
        $this->db->from('salesorder');
        
        // Apply filters if they are provided
        if (!empty($filterUser)) {
            $this->db->where('owner', $filterUser);
        }
    
        if (!empty($org_id)) {
            $this->db->where('org_id', $org_id);
        }
    
        if (!empty($salesId)) {
            $this->db->where('saleorder_id', $salesId);
        }
    
        if (!empty($startDate)) {
            $this->db->where('currentdate >=', $startDate);
        }
    
        if (!empty($endDate)) {
            $this->db->where('currentdate <=', $endDate);
        }
    
        $this->db->where('delete_status', 1);
        // Group by organization name
        $this->db->group_by('org_id');
        $this->db->where('org_id!=' ,0);
    
        // Execute the query
        $query = $this->db->get();
        // echo $this->db->last_query($query); die;

        // Return the result as an array
        return $query->result_array();
    }

public function get_datatables_action_value($data){
  $this->_get_datatables_query($data);
  return $this->db->get()->row_array();
}


public function count_filtered()
{
  $this->_get_datatables_query();
  $query = $this->db->get();
  return $query->num_rows();
}



    public function get_datatables(){
        // print_r('test');die;
        $this->_get_datatables_query();

        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


public function CountOrder($soId)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->select('product_name');
    $this->db->from('purchaseorder');
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('delete_status',1);
    $this->db->where('saleorder_id',$soId);
    $query = $this->db->get();
    return $query->result();
  }

  public function CountInvoice($saleorder_id){
        $sess_eml           = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company    = $this->session->userdata('company_name');
        $this->db->select('id');
        $this->db->from('invoices');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('saleorder_id',$saleorder_id);
        $this->db->where('delete_status',1);
        $query = $this->db->get();
        return $query->num_rows();
    }


public function count_all()
  {
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from($this->table);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    return $this->db->count_all_results();
  }
  



    // < ------------------------------------ End Ai Filters ----------------------------------->
    
}



?>

