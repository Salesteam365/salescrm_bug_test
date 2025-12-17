<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Performainvoice_model extends CI_Model
{
 
   var $table 		= 'performa_invoice';
  
  var $sort_by 		= array('invoice_no','billedto_orgname','page_name','final_total','pi_status','invoice_date',null);
  var $search_by 	= array('invoice_no','billedto_orgname','page_name','final_total','pi_status','invoice_date');
  var $order 		= array('id' => 'desc');
  
   /**
   * Prepare and apply DataTables server-side filters, search and ordering to the model's active Query Builder for performance invoices (applies session/company scoping, optional user/date filters, search across configured columns, and ordering).
   * @example
   * // Example usage inside the model or controller (no arguments)
   * // Assume relevant session/post values are set:
   * // $_SESSION['email'] = 'alice@example.com';
   * // $_SESSION['company_email'] = 'acme@example.com';
   * // $_POST['search']['value'] = 'Invoice123';
   * // $_POST['order'][0]['column'] = 1; $_POST['order'][0]['dir'] = 'desc';
   * $this->performainvoice_model->_get_datatables_query();
   * $query = $this->db->get(); // execute the prepared query
   * $rows = $query->result();
   * echo count($rows); // e.g. 5
   * @returns void Applies filtering, searching and ordering clauses to $this->db; does not return a value.
   */
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
  
  /**
  * Get GST entries for the current session's company.
  * @example
  * $result = $this->Performainvoice_model->get_gst();
  * print_r($result); // Example output: Array ( [0] => Array ( ['id'] => '1', ['tax_name'] => 'GST', ['tax_percent'] => '18', ['session_comp_email'] => 'company@example.com', ['session_company'] => 'Example Company', ['delete_status'] => '1' ) )
  * @param {void} $no_params - No parameters required.
  * @returns {array} Array of associative arrays representing GST rows (empty array if none).
  */
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
  
  
  /**
  * Retrieve vendor or organization contact data by organization name and page context.
  * @example
  * $result = $this->Performainvoice_model->getVendorOrgData('Acme Corp', 'purchaseorder');
  * print_r($result); // Sample output for purchaseorder: Array ( [id] => 12 [name] => Acme Corp [email] => vendor@example.com [mobile] => 1234567890 )
  * @param {string} $orgName - Organization or vendor name to search for.
  * @param {string} $pgname - Page/context name; use 'purchaseorder' to fetch from the vendor table, otherwise fetches customer organization fields.
  * @returns {array|null} Return associative array of the first matching row (contact fields) or null if not found.
  */
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
  
  /**
  * Retrieve a single record row from a page-specific table (quote, salesorder or purchaseorder) filtered by current session company context.
  * @example
  * $result = $this->Performainvoice_model->get_data_detail('quotation', 123);
  * print_r($result); // e.g. Array ( ['quote_id'] => 123, ['customer_name'] => 'Acme Ltd', ... )
  * @param {string} $page - The page type: 'quotation', 'salesorder' or 'purchaseorder'.
  * @param {int|string} $pageid - The ID of the record to retrieve.
  * @returns {array|null} Associative array of the found row data, or null/empty if no matching record is found.
  */
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
  
  /**
  * Retrieve organization records visible to the current session/company.
  * @example
  * $result = $this->Performainvoice_model->get_organization();
  * // Example usage:
  * // var_export($result);
  * // Sample output:
  * // array(
  * //   0 => (object) ['id' => '1', 'company_name' => 'Acme Corp', 'customer_type' => 'Customer', 'sess_eml' => 'user@example.com'],
  * // )
  * // Access a field:
  * echo $result[0]->company_name; // Acme Corp
  * @param void none - This function does not accept any parameters.
  * @returns object[] Array of organization objects matching the current session/company and filtered to customer types ('Customer' or 'Both') with delete_status = "1".
  */
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
  
  /**
  * Retrieve a performa_invoice record by its ID, constrained to the provided or current session company and company email.
  * @example
  * $result = $this->Performainvoice_model->get_pi_byId(123, 'Acme Ltd', 'billing@acme.com');
  * print_r($result); // e.g. Array ( [id] => 123 [invoice_no] => PI-2025-001 [session_company] => Acme Ltd [session_comp_email] => billing@acme.com ... )
  * @param {int} $piid - Performa invoice ID to fetch.
  * @param {string} $company - Optional company name; if empty the session 'company_name' will be used.
  * @param {string} $comEml - Optional company email; if empty the session 'company_email' will be used.
  * @returns {array|null} Return associative array of the performa_invoice row if found, otherwise null.
  */
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
  
  
  /**
  * Check whether a performa invoice with the specified invoice number exists for the current session company.
  * @example
  * $result = $this->Performainvoice_model->check_invice_no('INV-2025-001');
  * var_export($result); // bool(true) if invoice exists, bool(false) otherwise
  * @param {string} $invoice_no - Invoice number to check (e.g. 'INV-2025-001').
  * @returns {bool} True if an invoice with the provided number exists for the current session company and email, otherwise false.
  */
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