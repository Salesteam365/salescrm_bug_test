<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice_model extends CI_Model
{
 
   var $table 		= 'invoices';
  
  var $sort_by 		= array('invoice_no','org_name','sub_total','pi_status','invoice_date',null);
  var $search_by 	= array('invoice_no','org_name','sub_total','pi_status','invoice_date');
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
      
      if($this->input->post('searchUser'))
      { 
		$this->db->where('sess_eml',$this->input->post('searchUser'));
      }
      
      if($this->input->post('firstDate') < $this->input->post('secondDate')){
          
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
      	
		$session_company    = $this->session->userdata('company_name');
        $this->db->from('admin_users');
        $this->db->where('company_email',$branchId);
        $this->db->where('company_name',$session_company);
        $this->db->where('type','admin');
        $query = $this->db->get();
        return $query->row_array();
  }
  public function getVendorOrgData($vnd_id)
  {
	  //if($pgname=="purchaseorder"){
		  $this->db->select('*');
		  $this->db->from('vendor');
		  $this->db->where('id',$vnd_id);
	 /* }else {
		  $this->db->select('email, mobile,billing_country as country, billing_city as city, primary_contact,billing_address,billing_state,billing_zipcode');
		  $this->db->from('organization');
		  $this->db->where('org_name',$orgName);
	  }*/
    
    $query = $this->db->get();
    return $query->row_array();
  } 
  
  public function get_data_for_update($id)
  {
    $session_comp_email = $this->session->userdata('company_email');
      $session_company = $this->session->userdata('company_name');
      $this->db->from($this->table);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  public function get_inv_payment($id)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from('payment_history');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('invoice_id',$id);
    $this->db->where('delete_status',1);
    $query = $this->db->get();
    return $query->result_array();
  }
  
  public function get_payment_byid($id)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from('payment_history');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('id',$id);
	$this->db->where('delete_status',1);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  public function get_declaration()
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
    $this->db->select('invoice_declaration');
    $this->db->from('admin_users');
	$this->db->where('company_email',$session_comp_email);
    $this->db->where('company_name',$session_company);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  public function get_payment_adv($id)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
    $this->db->select('advanced_payment,pending_payment,sub_total');
    $this->db->from('invoices');
	$this->db->where('id',$id);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
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
  
  
  
  public function getsalesbyid($saleorderid)
  {
		$this->db->select('sess_eml');
		$this->db->from('salesorder');
		$this->db->where('saleorder_id',$saleorderid);
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
    $this->db->insert("invoices", $data);
    return $this->db->insert_id();
  }
  
  public function update_pi($data,$id)
  {
    // print_r($data);die;
	  $this->db->where('id', $id);
      $this->db->update("invoices", $data);
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
    $sess_eml = $this->session->userdata('email');
    $sess_id = $this->session->userdata('id');
    $this->db->from('user_branch');
    $this->db->where('sess_eml',$sess_eml);
    $this->db->where('company_id',$sess_id);
    $this->db->where('delete_status',"1");
	return $this->db->get()->result();
  }
  
  public function get_organization()
  {
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from('organization');
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('delete_status',"1");
	return $this->db->get()->result();
  }
    public function get_organization_bytype()
    {
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
		$this->db->from('organization');
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		$this->db->group_start();
		$this->db->where('customer_type','Customer');
		$this->db->or_where('customer_type','Both');
		$this->db->group_end();
		$this->db->where('delete_status',"1");
		return $this->db->get()->result_array();
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
    $this->db->from('invoices');
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
	$this->db->select('name');
    $this->db->from('vendor');
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('delete_status',"1");
	return $this->db->get()->result();
  }
  
  public function orgDetail($id)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->select('org_name,email,primary_contact');
    $this->db->from('organization');
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('id',$id);
    $this->db->where('delete_status',"1");
	$query = $this->db->get();
    return $query->row_array();
  }
  
  
  public function check_invice_no($invoice_no)
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->where('invoice_no' , $invoice_no);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $query = $this->db->get('invoices');
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

  /* public function getVndValue($vendor_name)
   {
      $response = array();
    
      $this->db->select('id,address as shipping_address,country as shipping_country,state as shipping_state,city as shipping_city,zipcode as shipping_zipcode, email, mobile,gstin,pan_no');
      $this->db->where('name',$vendor_name);
      $o = $this->db->get('vendor');
      $response = $o->result_array();
    
    return $response;
   }*/
   public function getall_terms()
   {
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
		$this->db->from('invoice_terms');
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		$this->db->where('delete_status',"1");
		return $this->db->get()->result_array();
   }
    public function create_payment_term($data)
    {
		$this->db->insert("invoice_terms",$data);
		return $this->db->insert_id();
    }
	
	public function update_payment_term($terms_id, $data)
    {
		$this->db->where('id',$terms_id);
		return $this->db->update("invoice_terms",$data);
		
    }
	public function delete_payment_term($terms_id)
    {
		$this->db->where('id',$terms_id);
		return $this->db->delete("invoice_terms");
		
    }
	
    // count all invices
	public function get_all_invoices()
    {
      $session_comp_email = $this->session->userdata('company_email');
      $sess_eml = $this->session->userdata('email');
      $session_company = $this->session->userdata('company_name');
      $type = $this->session->userdata("type");
      $this->db->select('count("invoice_no") as total_invoices');
      $this->db->from('invoices');
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
      
      $this->db->where('pi_status',1);
      $this->db->where('delete_status', 1);
      $query = $this->db->get();
      if($query->num_rows() > 0)
      {
        return $query->row_array();
      }
    }

    // total invoices amount
    // public function get_total_invoices_ammount()
    //   {
    //     $session_comp_email = $this->session->userdata('company_email');
    //     $sess_eml = $this->session->userdata('email');
    //     $session_company = $this->session->userdata('company_name');
    //     $type = $this->session->userdata("type");
    //     $this->db->select('SUM(sub_total) as total_amount');
    //     $this->db->from('invoices');

    //     if($type == "admin")
    //     {
        
    //       $this->db->where('session_comp_email',$session_comp_email);
    //       $this->db->where('session_company',$session_company);
    //     }
    //     else if ($type == "standard") 
    //     {
        
    //       $this->db->where('session_comp_email',$session_comp_email);
    //       $this->db->where('session_company',$session_company);
    //       $this->db->where('sess_eml',$sess_eml);
    //     }
        
    //     $this->db->where('pi_status',1);
    //     $this->db->where('delete_status', 1);
    //     $query = $this->db->get();
    //     if($query->num_rows() > 0)
    //     {
    //       return $query->row()->total_amount;
    //     }else{
    //       return 0;
    //     }
    //   }

      // fetch total invoices list
      public function get_invoices()
      {
        $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $type = $this->session->userdata("type");
        $this->db->select('*');
        $this->db->from('invoices');

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
        
        $this->db->where('pi_status',1);
        $this->db->where('delete_status', 1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
          return $query->result_array();
        }else{
          return 0;
        }
      }

      
	
	
    //invoice graph
  	public function get_invoice_graph()
  	{
	    $session_comp_email = $this->session->userdata('company_email');
      $sess_eml = $this->session->userdata('email');
      $session_company = $this->session->userdata('company_name');
      $type = $this->session->userdata('type');
        if($type == "admin")
        {
          $sort_date = $this->input->post('date');
          //$salesorder = $this->login_model->get_all_signupuser_by_date($sort_date,$type);

        if($sort_date){
        
          $filter_query =  $this->db->query("SELECT COUNT(id) as count,MONTHNAME(currentdate) as month_name FROM invoices WHERE YEAR(currentdate) = '" . $sort_date . "'  AND  session_company = '".$session_company."' AND  session_comp_email = '".$session_comp_email."' AND  delete_status = '1' GROUP BY YEAR(currentdate),MONTH(currentdate)"); 
  
          $filter_record = $filter_query->result();
      
          return $filter_record;  
        }else{
        
          $query =  $this->db->query("SELECT COUNT(id) as count,MONTHNAME(currentdate) as month_name FROM invoices WHERE YEAR(currentdate) = '" . date('Y') . "'  AND  session_company = '".$session_company."' AND  session_comp_email = '".$session_comp_email."' AND  delete_status = '1' GROUP BY YEAR(currentdate),MONTH(currentdate)"); 
  
          $record = $query->result();
      
          return $record; 
        }
        
      }else if($type == "standard"){
        $sort_date = $this->input->post('date');
          //$salesorder = $this->login_model->get_all_signupuser_by_date($sort_date,$type);

        if($sort_date){
        
          $filter_query =  $this->db->query("SELECT COUNT(id) as count,MONTHNAME(currentdate) as month_name FROM invoices WHERE YEAR(currentdate) = '" . $sort_date . "'  AND  session_company = '".$session_company."' AND  session_comp_email = '".$session_comp_email."' AND  sess_eml = '".$sess_eml."' AND  delete_status = '1' GROUP BY YEAR(currentdate),MONTH(currentdate)"); 
  
          $filter_record = $filter_query->result();
      
          return $filter_record;  
        }else{
        
          $query =  $this->db->query("SELECT COUNT(id) as count,MONTHNAME(currentdate) as month_name FROM invoices WHERE YEAR(currentdate) = '" . date('Y') . "'  AND  session_company = '".$session_company."' AND  session_comp_email = '".$session_comp_email."' AND  sess_eml = '".$sess_eml."' AND  delete_status = '1' GROUP BY YEAR(currentdate),MONTH(currentdate)"); 
  
          $record = $query->result();
      
          return $record; 
        }
      }
  	}
  
    public function total_invoiceMonth()
    {
		$session_comp_email = $this->session->userdata('company_email');
		$sess_eml = $this->session->userdata('email');
		$session_company = $this->session->userdata('company_name');
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		$this->db->where('MONTH(currentdate)',date('m'));
		$query = $this->db->get('invoices');
		return $query->num_rows();
	
    }
	
	public function update_inv_payment($where,$data)
	{
		$this->db->update('invoices', $data, $where);
		return $this->db->affected_rows();
	}
	public function update_so_payment($where,$data)
	{
		$this->db->update('salesorder', $data, $where);
		return $this->db->affected_rows();
	}
	
	public function updatePayment_history($where,$data)
	{
		$this->db->update('payment_history', $data, $where);
		return $this->db->affected_rows();
	}
	
	//Insert payment history
	public function create_paymentHistory($data){
		$this->db->insert('payment_history', $data);
		return $this->db->insert_id();
	}

  public function getinvoicedata($where){
    $this->db->select('id');
    $this->db->where($where);
    return $this->db->get('invoices');
  }
	
  
// Please Write Code Above This 
  
}