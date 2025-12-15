<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Performainvoice_model extends CI_Model
{
 
   var $table 		= 'performa_invoice';
  
  var $sort_by 		= array('invoice_no','billedto_orgname','page_name','final_total','pi_status','invoice_date',null);
  var $search_by 	= array('invoice_no','billedto_orgname','page_name','final_total','pi_status','invoice_date');
  var $order 		= array('id' => 'desc');
  
   private function _get_datatables_query()
   {
		$sess_eml           = $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company    = $this->session->userdata('company_name');
    
        $this->db->from($this->table);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
        //$this->db->where('advanced_payment<sub_totals');     
        if($this->session->userdata('type')==='standard')
        {
             $this->db->where('sess_eml',$sess_eml);
        }   
      if($this->input->post('searchUser'))
      { 
		$this->db->where('sess_eml',$this->input->post('searchUser'));
      }
      
      if($this->input->post('fromDate') && $this->input->post('toDate')){
          $this->db->where('currentdate >=',$this->input->post('fromDate'));
          $this->db->where('currentdate <=',$this->input->post('toDate'));
        }else if($this->input->post('firstDate') < $this->input->post('secondDate')){
          
          $this->db->where('invoice_date >=',$this->input->post('firstDate'));
          $this->db->where('invoice_date <=',$this->input->post('secondDate'));
          
      }else if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('invoice_date >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('invoice_date >=',$search_date);
        }
      }
	  
      $this->db->where('delete_status',1);
    
    $i = 0;
    foreach ($this->search_by as $item) // loop column
    {  
	      $searchVl=$this->input->post('search');
		 if(isset($_POST['search']['value'])) 
		  {
			$dataSearch=$_POST['search']['value'];  
		  }else{
			  $dataSearch=$searchVl;
		  }
		 
      if(isset($dataSearch)) 
      {
        if($i===0) 
        {
          $this->db->group_start(); 
          $this->db->like($item, $dataSearch);
        }else{
          $this->db->or_like($item, $dataSearch);
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
  public function get_datatables()
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all()
  {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }
  
  public function getBranchData($branchId)
  {
    $this->db->from('user_branch');
    $this->db->where('id',$branchId);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  public function get_Comp($branchId)
  {
    $this->db->from('admin_users');
    $this->db->where('company_email',$branchId);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  public function get_gst(){
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->select('*');
    $this->db->from('gst');
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('delete_status',1);
    $this->db->where('tax_name','GST');
    $query = $this->db->get();
    return $query->result_array();
  }
  
  
  public function getVendorOrgData($orgName,$pgname)
  {
	  if($pgname=="purchaseorder"){
		  $this->db->select('*');
		  $this->db->from('vendor');
		  $this->db->where('name',$orgName);
	  }else {
		  $this->db->select('email, mobile,billing_country as country, billing_city as city, primary_contact,billing_address,billing_state,billing_zipcode');
		  $this->db->from('organization');
		  $this->db->where('org_name',$orgName);
		  $this->db->group_start();
          $this->db->where('customer_type', 'Customer');
          $this->db->or_where('customer_type', 'Both');
          $this->db->group_end();
	  }
    
    $query = $this->db->get();
    return $query->row_array();
  } 
  
  public function get_Owner($get_Owner)
  {
		$this->db->select('*');
		$this->db->from('standard_users');
		$this->db->where('standard_email',$get_Owner);
		$query = $this->db->get();
		return $query->row_array();
  }
  public function get_Admin($get_Owner)
  {
		$this->db->select('admin_name as standard_name, admin_mobile as standard_mobile');
		$this->db->from('admin_users');
		$this->db->where('admin_email',$get_Owner);
		$query = $this->db->get();
		return $query->row_array();
  }
  
  public function get_data_detail($page,$pageid)
  {
	  $sess_eml           = $this->session->userdata('email');
	  $session_comp_email = $this->session->userdata('company_email');
	  $session_company    = $this->session->userdata('company_name');
	  
	  $this->db->select('*');
	  if($page=="quotation"){
		  $this->db->from('quote');
		  $this->db->where('quote_id',$pageid);
	  }
	  if($page=="salesorder"){
		  $this->db->from('salesorder');
		  $this->db->where('saleorder_id',$pageid);
	  }
	  if($page=="purchaseorder"){
		  $this->db->from('purchaseorder');
		  $this->db->where('purchaseorder_id',$pageid);
	  }
	  $this->db->where('session_company',$session_company);
	  $this->db->where('session_comp_email',$session_comp_email);
	  if($this->session->userdata('type')==='standard'){
		  $this->db->where('sess_eml',$sess_eml);
	  }
	$query = $this->db->get();
    return $query->row_array();
  }
 
 
  public function create_pi($data)
  {
    $this->db->insert("performa_invoice", $data);
    return $this->db->insert_id();
  }
  
  public function update_pi($data,$id)
  {
	  $this->db->where('id', $id);
      $this->db->update("performa_invoice", $data);
      return $this->db->affected_rows();
  }
  
  public function delete_pi($id)
  {
    $this->db->set('delete_status',2);
    $this->db->where('id', $id);
	$this->db->update($this->table);
  }
  
  public function create_bank_detail($data)
  {
    $this->db->insert("account_details", $data);
    return $this->db->insert_id();
  }
  
  public function update_bank_detail($data,$id)
  {
	  $this->db->where('id', $id);
      return $this->db->update("account_details", $data);
      //return $this->db->affected_rows();
  }
  
  public function get_branch()
  {
    $cid = $this->session->userdata('id');
    $company_name = $this->session->userdata('company_name');
    $this->db->from('user_branch');
    //$this->db->where('company_id',$cid);
    $this->db->where('company_name',$company_name);
    $this->db->where('delete_status',"1");
	return $this->db->get()->result();
  }
  
  public function get_organization()
  {
    $sess_eml           = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company    = $this->session->userdata('company_name');
    $this->db->from('organization');
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    if($this->session->userdata('type')==='standard'){
		  $this->db->where('sess_eml',$sess_eml);
	}
    $this->db->where('delete_status',"1");
    $this->db->group_start();
    $this->db->where('customer_type', 'Customer');
    $this->db->or_where('customer_type', 'Both');
    $this->db->group_end();
	return $this->db->get()->result();
  }
  
  public function get_pi_byId($piid,$company='',$comEml='')
  {
	  if($company==''){
		$session_company = $this->session->userdata('company_name');
	  }else{
		 $session_company=$company; 
	  }
	  if($comEml==''){
		$session_comp_email = $this->session->userdata('company_email');
	  }else{
		 $session_comp_email=$comEml; 
	  }
    $this->db->from('performa_invoice');
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('id',$piid);
	$query = $this->db->get();
    return $query->row_array();
  }
  
  public function get_vendor()
  {
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->select('name as org_name');
    $this->db->from('vendor');
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('delete_status',"1");
	return $this->db->get()->result();
  }
  
  
  public function check_invice_no($invoice_no)
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->where('invoice_no' , $invoice_no);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $query = $this->db->get('performa_invoice');
    if($query->num_rows()>0)
    {
     return true;
    }
    else
    {
     return false;
    }  
  }
  
  public function get_bank_details()
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->where('delete_status' ,1);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $query = $this->db->get('account_details');
    return $query->row();
  }


// Please Write Code Above This 
  
}