<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Creditnote_model extends CI_Model
{
 
   var $table 		= 'creditnote';
  
  var $sort_by 		= array('invoice_no','org_name','sub_total','pi_status','invoice_date',null);
  var $search_by 	= array('invoice_no','org_name','sub_total','pi_status','invoice_date');
  var $order 		= array('id' => 'desc');
  
   /**
   * Build and apply DataTables query filters (session/company scope, optional user filter, date range/search, global column search and ordering) to the CI query builder.
   * @example
   * $this->creditnote_model->_get_datatables_query();
   * // Then retrieve results built by the query:
   * $rows = $this->db->get()->result();
   * var_export($rows); // e.g. array( (object) ['id' => 123, 'invoice_date' => '2025-01-15', 'sess_eml' => 'user@example.com', ...] )
   * @param void $none - This method accepts no parameters; it uses session data and $this->input->post() values for filtering.
   * @returns void Applies query constraints to $this->db and does not return a value.
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
 

  /**
  * Retrieve vendor record from the database by vendor ID.
  * @example
  * // From a model or controller where creditnote_model is loaded
  * $result = $this->creditnote_model->getVendorOrgData(42);
  * print_r($result); // Array ( [id] => 42 [vendor_name] => "ACME Pvt Ltd" [email] => "sales@acme.com" [mobile] => "1234567890" [address] => "123 Main St" )
  * @param int $vnd_id - Vendor ID to look up in the 'vendor' table.
  * @returns array|null Return associative array of the vendor row (column => value) or null/empty if no row found.
  */
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
  
  /**
  * Retrieve payment history rows for a given invoice filtered by the current session company/email and active status (delete_status = 1).
  * @example
  * $result = $this->creditnote_model->get_inv_payment(123);
  * print_r($result); // Example output: Array ( [0] => Array ( 'id' => 5, 'invoice_id' => 123, 'amount' => '150.00', 'session_comp_email' => 'acct@example.com', 'session_company' => 'Acme Ltd', 'delete_status' => 1 ) )
  * @param {{int|string}} {{$id}} - Invoice ID to fetch payments for.
  * @returns {{array}} Return an array of payment history rows matching the invoice and session context.
  */
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
  
  /**
  * Fetch a single payment history record by ID for the current session company/email where delete_status = 1.
  * @example
  * $result = $this->creditnote_model->get_payment_byid(42);
  * print_r($result); // e.g. Array ( [id] => 42 [amount] => "150.00" [session_comp_email] => "acct@example.com" [session_company] => "ExampleCo" [delete_status] => 1 )
  * @param {int} $id - Payment record ID to fetch.
  * @returns {array|null} Associative array of the payment record or null if not found.
  */
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
  
  /**
  * Get advanced payment, pending payment and sub total for a credit note by ID for the current session company.
  * @example
  * $result = $this->creditnote_model->get_payment_adv(123);
  * print_r($result); // Array ( [advanced_payment] => "100.00" [pending_payment] => "50.00" [sub_total] => "150.00" )
  * @param {int} $id - Credit note ID to fetch payment values for.
  * @returns {array} Associative array with keys 'advanced_payment', 'pending_payment' and 'sub_total' (empty array if no record found).
  */
  public function get_payment_adv($id)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
    $this->db->select('advanced_payment,pending_payment,sub_total');
    $this->db->from('creditnote');
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
  
  /**
  * Retrieve a single record row for a given document type and ID filtered by the current session company and (for standard users) the current user.
  * @example
  * $this->load->model('creditnote_model');
  * $result = $this->creditnote_model->get_data_detail('quotation', 123);
  * print_r($result); // Example output: Array ( [quote_id] => 123 [customer_name] => "Acme Corp" [total] => "1000.00" )
  * @param {string} $page - Document type to fetch: 'quotation', 'salesorder', or 'purchaseorder'.
  * @param {int|string} $pageid - ID of the document to fetch.
  * @returns {array|null} Return associative array of the matched database row, or NULL if no row is found.
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
    $this->db->insert("creditnote", $data);
    return $this->db->insert_id();
  }
  
  public function update_pi($data,$id)
  {
	  $this->db->where('id', $id);
      $this->db->update("creditnote", $data);
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
    /**
     * Retrieve organizations for the current company session filtered by customer type.
     * This returns organizations that belong to the current session (company email and name),
     * have customer_type either "Customer" or "Both", and have delete_status set to "1".
     * @example
     * $result = $this->creditnote_model->get_organization_bytype();
     * print_r($result); // Sample output:
     * // Array
     * // (
     * //     [0] => Array
     * //         (
     * //             [id] => 12
     * //             [name] => Acme Corp
     * //             [customer_type] => Customer
     * //             [session_comp_email] => billing@acme.example
     * //             [session_company] => Acme Corporation
     * //             [delete_status] => 1
     * //         )
     * //     [1] => Array
     * //         (
     * //             [id] => 23
     * //             [name] => Beta LLC
     * //             [customer_type] => Both
     * //             [session_comp_email] => billing@acme.example
     * //             [session_company] => Acme Corporation
     * //             [delete_status] => 1
     * //         )
     * // )
     * @param void $none - This method does not accept any parameters.
     * @returns array Array of associative arrays representing matching organizations.
     */
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
  
  /**
   * Retrieve a credit note (purchase invoice) record by its ID, scoped to a company and company email.
   * Falls back to session-stored company name and email when those parameters are not provided.
   * @example
   * $result = $this->creditnote_model->get_pi_byId(123, 'Acme Ltd', 'billing@acme.com');
   * echo '<pre>'; print_r($result); echo '</pre>'; // sample output: Array ( [id] => 123 [session_company] => Acme Ltd [session_comp_email] => billing@acme.com [amount] => 150.00 )
   * @param {int|string} $piid - The ID of the credit note to retrieve.
   * @param {string} $company - Optional company name to scope the query; if empty the session value is used.
   * @param {string} $comEml - Optional company email to scope the query; if empty the session value is used.
   * @returns {array|null} Return associative array of the credit note row, or NULL if not found.
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
    $this->db->from('creditnote');
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
  
  /**
   * Retrieve organization details (org_name, email, primary_contact) for a given organization ID,
   * constrained to the current session's company/email and only if not deleted.
   * @example
   * $this->load->model('creditnote_model');
   * $result = $this->creditnote_model->orgDetail(12);
   * print_r($result); // sample output: array('org_name' => 'Acme Ltd', 'email' => 'info@acme.com', 'primary_contact' => 'John Doe')
   * @param {int} $id - Organization ID to retrieve.
   * @returns {array|null} Associative array with keys 'org_name', 'email', 'primary_contact' or null if not found.
   */
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
  
  
  /**
  * Check whether an invoice number exists for the current session's company and company email.
  * @example
  * $result = $this->creditnote_model->check_invice_no('INV-1001');
  * var_dump($result); // bool(true) or bool(false)
  * @param {string} $invoice_no - Invoice number to check (e.g. 'INV-1001').
  * @returns {bool} True if the invoice number exists in the creditnote table for the session company/email, false otherwise.
  */
  public function check_invice_no($invoice_no)
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->where('invoice_no' , $invoice_no);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $query = $this->db->get('creditnote');
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
	
 /**
 * Get total number of credit notes for the current session/company. Respects user type (admin or standard) and applies filters pi_status = 1 and delete_status = 1.
 * @example
 * $result = $this->creditnote_model->get_all_creditnote();
 * print_r($result); // Example output: Array ( [total_creditnote] => 12 )
 * @param void $none - This method accepts no parameters.
 * @returns array|null Associative array with key 'total_creditnote' (int) on success, or null if no matching rows.
 */
	public function get_all_creditnote()
    {
		$session_comp_email = $this->session->userdata('company_email');
		$sess_eml = $this->session->userdata('email');
		$session_company = $this->session->userdata('company_name');
		$type = $this->session->userdata("type");
		$this->db->select('count("invoice_no") as total_creditnote');
		$this->db->from('creditnote');
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
	
	
    //invoice graph
   /**
    * Retrieve monthly credit note counts for a given year filtered by the current session and POST data.
    * @example
    * $this->load->model('creditnote_model');
    * // Example: no POST date -> uses current year; with POST 'date' => specific year (e.g. 2024)
    * $result = $this->creditnote_model->get_invoice_graph();
    * print_r($result); // sample output:
    * // Array
    * // (
    * //     [0] => stdClass Object ( [count] => 5 [month_name] => January )
    * //     [1] => stdClass Object ( [count] => 2 [month_name] => February )
    * // )
    * @param void $none - No direct arguments; function relies on session values and optional POST 'date'.
    * @returns array Array of stdClass objects where each object has 'count' (int) and 'month_name' (string).
    */
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
			
		    $filter_query =  $this->db->query("SELECT COUNT(id) as count,MONTHNAME(currentdate) as month_name FROM creditnote WHERE YEAR(currentdate) = '" . $sort_date . "'  AND  session_company = '".$session_company."' AND  session_comp_email = '".$session_comp_email."' AND  delete_status = '1' GROUP BY YEAR(currentdate),MONTH(currentdate)"); 
 
         $filter_record = $filter_query->result();
     
	      return $filter_record;  
		  }else{
			 
		    $query =  $this->db->query("SELECT COUNT(id) as count,MONTHNAME(currentdate) as month_name FROM creditnote WHERE YEAR(currentdate) = '" . date('Y') . "'  AND  session_company = '".$session_company."' AND  session_comp_email = '".$session_comp_email."' AND  delete_status = '1' GROUP BY YEAR(currentdate),MONTH(currentdate)"); 
 
         $record = $query->result();
     
	      return $record; 
		  }
		  
		}else if($type == "standard"){
			$sort_date = $this->input->post('date');
	      //$salesorder = $this->login_model->get_all_signupuser_by_date($sort_date,$type);

		  if($sort_date){
			
		    $filter_query =  $this->db->query("SELECT COUNT(id) as count,MONTHNAME(currentdate) as month_name FROM creditnote WHERE YEAR(currentdate) = '" . $sort_date . "'  AND  session_company = '".$session_company."' AND  session_comp_email = '".$session_comp_email."' AND  sess_eml = '".$sess_eml."' AND  delete_status = '1' GROUP BY YEAR(currentdate),MONTH(currentdate)"); 
 
         $filter_record = $filter_query->result();
     
	       return $filter_record;  
		  }else{
			 
		    $query =  $this->db->query("SELECT COUNT(id) as count,MONTHNAME(currentdate) as month_name FROM creditnote WHERE YEAR(currentdate) = '" . date('Y') . "'  AND  session_company = '".$session_company."' AND  session_comp_email = '".$session_comp_email."' AND  sess_eml = '".$sess_eml."' AND  delete_status = '1' GROUP BY YEAR(currentdate),MONTH(currentdate)"); 
 
         $record = $query->result();
     
	       return $record; 
		  }
		}
  	}
  
    /**
    * Return count of credit notes (invoices) for the current month for the company stored in session.
    * @example
    * $result = $this->creditnote_model->total_invoiceMonth();
    * echo $result; // e.g. 7
    * @param void $none - No parameters required.
    * @returns int Number of credit notes for the current month for the session company.
    */
    public function total_invoiceMonth()
    {
		$session_comp_email = $this->session->userdata('company_email');
		$sess_eml = $this->session->userdata('email');
		$session_company = $this->session->userdata('company_name');
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		$this->db->where('MONTH(currentdate)',date('m'));
		$query = $this->db->get('creditnote');
		return $query->num_rows();
	
    }
	
	public function update_inv_payment($where,$data)
	{
		$this->db->update('creditnote', $data, $where);
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

  
	
  
// Please Write Code Above This 
  
}