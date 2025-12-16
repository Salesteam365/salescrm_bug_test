<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Export_model extends CI_Model
{
  
    /**
     * Retrieve organization/user details for the current session company filtered to customers.
     * @example
     * $result = $this->Export_model->getUserDetails();
     * print_r($result);
     * /* Sample output:
     * Array
     * (
     *     [0] => Array
     *         (
     *             [sess_eml] => "user@example.com"
     *             [org_name] => "Example Corp"
     *             [primary_contact] => "Jane Doe"
     *             [email] => "contact@example.com"
     *             [website] => "https://example.com"
     *             [office_phone] => "0123456789"
     *             [mobile] => "0987654321"
     *             [employees] => "50-100"
     *             [industry] => "Software"
     *             [annual_revenue] => "1,000,000"
     *             [ownership] => "Private"
     *             [assigned_to] => "sales_rep"
     *             [sic_code] => "1234"
     *             [sla_name] => "Standard"
     *             [region] => "North"
     *             [gstin] => "22AAAAA0000A1Z5"
     *             [panno] => "ABCDE1234F"
     *             [billing_country] => "India"
     *             [shipping_country] => "India"
     *             [billing_city] => "Mumbai"
     *             [shipping_city] => "Mumbai"
     *             [billing_state] => "Maharashtra"
     *             [shipping_state] => "Maharashtra"
     *             [billing_zipcode] => "400001"
     *             [shipping_zipcode] => "400001"
     *             [billing_address] => "123 Billing St"
     *             [shipping_address] => "123 Shipping St"
     *             [description] => "Customer description"
     *             [datetime] => "2025-01-01 12:00:00"
     *         )
     * )
     * */
    public function getUserDetails(){
		$session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
 		$response = array();
		$this->db->select('sess_eml,org_name,primary_contact,email,website,office_phone,mobile,employees,industry,annual_revenue,ownership,assigned_to,sic_code,sla_name,region,gstin,panno,billing_country,shipping_country,billing_city,shipping_city,billing_state,shipping_state,billing_zipcode,shipping_zipcode,billing_address,shipping_address,description,datetime');
		$this->db->where('delete_status','1');
		$this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
		$this->db->group_start();
        $this->db->where('customer_type', 'Customer');
        $this->db->or_where('customer_type', 'Both');
        $this->db->group_end();
		$q = $this->db->get('organization');
		$response = $q->result_array();
	 	return $response;
	}
 /**
 * Retrieve vendor (and "Both") organization details for the current session's company.
 * @example
 * $result = $this->Export_model->getUserDetails_vendor();
 * print_r($result); // Array ( [0] => Array ( [sess_eml] => "vendor@example.com" [org_name] => "Vendor Co" [primary_contact] => "John Doe" [email] => "contact@vendor.com" [website] => "https://vendor.example" [office_phone] => "1234567890" [mobile] => "0987654321" [employees] => "50-100" [industry] => "Manufacturing" [annual_revenue] => "1M-5M" [ownership] => "Private" [assigned_to] => "Sales Rep" [sic_code] => "1234" [sla_name] => "Standard" [region] => "North" [gstin] => "22AAAAA0000A1Z5" [panno] => "AAAAA0000A" [billing_country] => "Country" [shipping_country] => "Country" [billing_city] => "City" [shipping_city] => "City" [billing_state] => "State" [shipping_state] => "State" [billing_zipcode] => "123456" [shipping_zipcode] => "123456" [billing_address] => "123 Billing St" [shipping_address] => "456 Shipping Ave" [description] => "Vendor description" [datetime] => "2025-01-01 12:00:00" ) )
 * @param void $none - No arguments are required.
 * @returns array Array of vendor organization records (each record is an associative array of selected organization fields).
 */
	public function getUserDetails_vendor(){
		$session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
 		$response = array();
		$this->db->select('sess_eml,org_name,primary_contact,email,website,office_phone,mobile,employees,industry,annual_revenue,ownership,assigned_to,sic_code,sla_name,region,gstin,panno,billing_country,shipping_country,billing_city,shipping_city,billing_state,shipping_state,billing_zipcode,shipping_zipcode,billing_address,shipping_address,description,datetime');
		$this->db->where('delete_status','1');
		$this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
		$this->db->group_start();
        $this->db->where('customer_type', 'Vendor');
        $this->db->or_where('customer_type', 'Both');
        $this->db->group_end();
		$q = $this->db->get('organization');
		$response = $q->result_array();
	 	return $response;
	}
	
	// Export Contact Data....
 /**
  * Retrieve contact records filtered by the current session company and email.
  * @example
  * // Load model and call the method (from a controller)
  * $this->load->model('Export_model');
  * $result = $this->Export_model->getUserDetails_contact();
  * print_r($result);
  * // Sample output:
  * // Array (
  * //   [0] => Array (
  * //     'sess_eml' => 'user@company.com',
  * //     'contact_owner' => 'John Owner',
  * //     'org_name' => 'Acme Corp',
  * //     'org_id' => '42',
  * //     'name' => 'Jane Doe',
  * //     'email' => 'jane.doe@example.com',
  * //     'website' => 'https://example.com',
  * //     'office_phone' => '+1-555-0100',
  * //     'mobile' => '+1-555-0101',
  * //     'assigned_to' => 'sales_rep',
  * //     'sla_name' => 'Standard',
  * //     'billing_country' => 'USA',
  * //     'shipping_country' => 'USA',
  * //     'billing_city' => 'New York',
  * //     'shipping_city' => 'New York',
  * //     'billing_state' => 'NY',
  * //     'shipping_state' => 'NY',
  * //     'billing_zipcode' => '10001',
  * //     'shipping_zipcode' => '10001',
  * //     'billing_address' => '123 Main St',
  * //     'shipping_address' => '123 Main St',
  * //     'description' => 'Primary contact for Acme Corp',
  * //     'datetime' => '2025-01-01 12:00:00'
  * //   )
  * // )
  * @param void $none - This method does not accept parameters; it uses session data internally.
  * @returns array Returns an array of associative arrays representing contact records.
  */
	public function getUserDetails_contact(){
		$session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
 		$response = array();
		$this->db->select('sess_eml,contact_owner,org_name,org_id,name,email,website,office_phone,mobile,assigned_to,sla_name,billing_country,shipping_country,billing_city,shipping_city,billing_state,shipping_state,billing_zipcode,shipping_zipcode,billing_address,shipping_address,description,datetime');
		$this->db->where('delete_status','1');
		$this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
		
		$q = $this->db->get('contact');
		$response = $q->result_array();
	 	return $response;
	}
	
    /**
    * Export opportunity records for the current session company.
    * @example
    * $this->load->model('Export_model');
    * $result = $this->Export_model->export_opportunity_data();
    * print_r($result); // Example output:
    * // Array
    * // (
    * //   [0] => Array
    * //     (
    * //       [sess_eml] => "company@example.com"
    * //       [owner] => "Jane Smith"
    * //       [org_name] => "Example Co"
    * //       [name] => "Opportunity A"
    * //       [contact_name] => "John Contact"
    * //       [expclose_date] => "2025-12-31"
    * //       [pipeline] => "Sales"
    * //       [stage] => "Negotiation"
    * //       [lead_source] => "Referral"
    * //       [next_step] => "Follow up"
    * //       [type] => "New Business"
    * //       [probability] => "75"
    * //       [industry] => "Technology"
    * //       [employees] => "50"
    * //       [weighted_revenue] => "75000"
    * //       [email] => "contact@example.com"
    * //       [mobile] => "555-1234"
    * //       [lost_reason] => ""
    * //       [description] => "Opportunity description"
    * //       [product_name] => "Product X"
    * //       [quantity] => "10"
    * //       [unit_price] => "100"
    * //       [total] => "1000"
    * //       [initial_total] => "1000"
    * //       [discount] => "0"
    * //       [sub_total] => "1000"
    * //       [pro_description] => "Product description"
    * //       [datetime] => "2025-01-01 12:00:00"
    * //     )
    * // )
    * @param void none - This function accepts no parameters.
    * @returns array Returns an array of associative arrays representing opportunity rows filtered by delete_status = '1' and the current session company.
    */
    public function export_opportunity_data(){
		$session_comp_email = $this->session->userdata('company_email');
        $session_company 	= $this->session->userdata('company_name');
 		$response = array();
		$this->db->select('sess_eml,owner,org_name,name,contact_name,expclose_date,pipeline,stage,lead_source,next_step,type,probability,industry,employees,weighted_revenue,email,mobile,lost_reason,description,product_name,quantity,unit_price,total,initial_total,discount,sub_total,pro_description,datetime');
		$this->db->where('delete_status','1');
		$this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
		$q = $this->db->get('opportunity');
		$response = $q->result_array();
	 	return $response;
	}
	
    /**
    * Export quotation data for the currently logged-in session company as an array of associative records.
    * @example
    * // Load model and call the method
    * $this->load->model('Export_model');
    * $result = $this->Export_model->export_quotation_data();
    * print_r($result);
    * // sample output:
    * // array(
    * //   0 => array(
    * //     'sess_eml' => 'user@example.com',
    * //     'owner' => 'John Doe',
    * //     'opp_name' => 'Opportunity A',
    * //     'subject' => 'Quote for services',
    * //     'org_name' => 'Acme Corp',
    * //     'contact_name' => 'Jane Smith',
    * //     'quote_stage' => 'Draft',
    * //     'valid_until' => '2025-12-31',
    * //     'carrier' => 'FedEx',
    * //     'email' => 'client@example.com',
    * //     'billing_country' => 'USA',
    * //     'billing_state' => 'CA',
    * //     'billing_city' => 'San Francisco',
    * //     'billing_zipcode' => '94105',
    * //     'billing_address' => '123 Market St',
    * //     'shipping_country' => 'USA',
    * //     'shipping_state' => 'CA',
    * //     'shipping_city' => 'San Francisco',
    * //     'shipping_zipcode' => '94105',
    * //     'shipping_address' => '123 Market St',
    * //     'product_name' => 'Widget',
    * //     'hsn_sac' => '1234',
    * //     'sku' => 'WGT-001',
    * //     'quantity' => '10',
    * //     'unit_price' => '9.99',
    * //     'total' => '99.90',
    * //     'initial_total' => '99.90',
    * //     'discount' => '0.00',
    * //     'pro_description' => 'High quality widget',
    * //     'sub_totalq' => '99.90',
    * //     'gst' => '18.00',
    * //     'igst' => '0.00',
    * //     'cgst' => '9.00',
    * //     'sgst' => '9.00',
    * //     'pro_discount' => '0.00',
    * //     'total_igst' => '0.00',
    * //     'total_cgst' => '9.00',
    * //     'total_sgst' => '9.00',
    * //     'type' => 'product',
    * //     'sub_total_with_gst' => '117.90',
    * //     'datetime' => '2025-01-01 12:00:00'
    * //   )
    * // )
    * @param void No parameters — the method uses session company email and name to filter quotes.
    * @returns array Associative array of quotation records for the current session company.
    */
    public function export_quotation_data(){  
	
		$session_comp_email = $this->session->userdata('company_email');
        $session_company 	= $this->session->userdata('company_name');
 		$response = array();
		$this->db->select('sess_eml,owner,opp_name,subject,org_name,contact_name,quote_stage,valid_until,carrier,email,billing_country,billing_state,billing_city,billing_zipcode,billing_address,shipping_country,shipping_state,shipping_city,shipping_zipcode,shipping_address,product_name,hsn_sac,sku,quantity,unit_price,total,initial_total,discount,pro_description,sub_totalq,gst,igst,cgst,sgst,pro_discount,total_igst,total_cgst,total_sgst,type,sub_total_with_gst,datetime');
		$this->db->where('delete_status','1');
		$this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
		$q = $this->db->get('quote');
		$response = $q->result_array();
	 	return $response;
	}

	// <------------------------------- Debit Note ---------------------------------------------->
 /**
 * Retrieve debit note records joined with invoice data for the current session company.
 * @example
 * $CI =& get_instance();
 * $CI->load->model('Export_model');
 * $result = $CI->Export_model->export_debitnote_data();
 * print_r($result); // sample output: Array ( [0] => Array ( ['sess_eml'] => 'company@example.com', ['session_company'] => 'ACME Ltd', ['owner'] => 'John Doe', ['debitnote_date'] => '2025-01-15', ['debitnote_no'] => 'DN-1001', ['sub_total'] => '150.00', ['invoice_no'] => 'INV-2001', ['invoice_sub_total'] => '150.00', ['invoice_date'] => '2025-01-10' ) )
 * @param void $none - No parameters.
 * @returns array Array of associative arrays representing debit notes joined with invoices (keys: sess_eml, session_company, owner, debitnote_date, debitnote_no, sub_total, invoice_no, invoice_sub_total, invoice_date).
 */
	public function export_debitnote_data() {
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
		$response = array();
	
		$this->db->select('c.sess_eml, c.session_company, c.owner, c.debitnote_date, c.debitnote_no, c.sub_total, i.invoice_no, i.sub_total as invoice_sub_total, i.invoice_date');
		$this->db->from('debitnote c');
		$this->db->join('invoices i', 'c.invoice_id = i.id', 'left');
	
		$this->db->where('c.delete_status', '1');
		$this->db->where('c.session_comp_email', $session_comp_email);
		$this->db->where('c.session_company', $session_company);
	
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
	}
	

	// <------------------------------------- Credit Note -------------------------------------------->
 /**
 * Export credit note data filtered by the current session company and company email.
 * Retrieves credit notes joined with their related invoice data and returns them as an array of associative arrays.
 * @example
 * // From a controller
 * $this->load->model('Export_model');
 * $result = $this->Export_model->export_creditnote_data();
 * var_export($result);
 * // Sample output:
 * // array(
 * //   0 => array(
 * //     'sess_eml' => 'acct@example.com',
 * //     'session_company' => 'Example Company Ltd',
 * //     'owner' => 'John Doe',
 * //     'creditnote_date' => '2025-06-01',
 * //     'creditnote_no' => 'CN-1001',
 * //     'sub_total' => '150.00',
 * //     'invoice_no' => 'INV-500',
 * //     'invoice_sub_total' => '200.00',
 * //     'invoice_date' => '2025-05-25'
 * //   ),
 * //   ...
 * // )
 * @param void No parameters required.
 * @returns array Array of associative arrays where each item represents a credit note record joined with invoice data.
 */
	public function export_creditnote_data() {
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
		$response = array();
	
		$this->db->select('c.sess_eml, c.session_company, c.owner, c.creditnote_date, c.creditnote_no, c.sub_total, i.invoice_no, i.sub_total as invoice_sub_total, i.invoice_date');
		$this->db->from('creditnote c');
		$this->db->join('invoices i', 'c.invoice_id = i.id', 'left');
	
		$this->db->where('c.delete_status', '1');
		$this->db->where('c.session_comp_email', $session_comp_email);
		$this->db->where('c.session_company', $session_company);
	
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
	}

	// < ----------------------------------- Delivery Challan ---------------------------------------->
 /**
  * Export delivery challan data filtered by the current session's company email and company name.
  * Retrieves rows from the 'deliverychallan' table left-joined with 'invoices' and returns them as an array.
  * @example
  * $this->load->model('Export_model');
  * $result = $this->Export_model->export_deliverychallan_data();
  * print_r($result);
  * // Sample output:
  * // [
  * //   [
  * //     'sess_eml' => 'company@example.com',
  * //     'session_company' => 'Example Company',
  * //     'owner' => 'John Doe',
  * //     'deliverychallan_date' => '2025-12-01',
  * //     'deliverychallan_no' => 'DC-1001',
  * //     'sub_total' => '1500.00',
  * //     'invoice_no' => 'INV-2001',
  * //     'invoice_sub_total' => '1500.00',
  * //     'invoice_date' => '2025-11-30'
  * //   ],
  * //   // ...
  * // ]
  * @returns array Array of associative arrays representing delivery challan records joined with invoice data.
  */
	public function export_deliverychallan_data() {
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
		$response = array();
	
		$this->db->select('c.sess_eml, c.session_company, c.owner, c.deliverychallan_date, c.deliverychallan_no, c.sub_total, i.invoice_no, i.sub_total as invoice_sub_total, i.invoice_date');
		$this->db->from('deliverychallan c');
		$this->db->join('invoices i', 'c.invoice_id = i.id', 'left');
	
		$this->db->where('c.delete_status', '1');
		$this->db->where('c.session_comp_email', $session_comp_email);
		$this->db->where('c.session_company', $session_company);
	
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
	}

	// <--------------------------------- Expenditure Management -------------------------------------->
 /**
  * Export expenditure data for the currently logged-in company. Retrieves rows from the "expenditure"
  * table joined with "purchaseorder" for the active session company email and name, excluding deleted entries.
  * @example
  * $this->load->model('Export_model');
  * $result = $this->Export_model->export_expenditure_data();
  * print_r($result); // e.g. Array ( [0] => Array ( [sess_eml] => "info@company.com" [session_company] => "Acme Corp" [expenditure_date] => "2025-01-15" [expenditure_no] => "EXP-0001" [currentdate] => "2025-01-15" [purchaseorder_id] => "PO-123" [owner] => "Jane Doe" [sub_total] => "1500.00" ) )
  * @returns {array} Array of associative arrays representing expenditure records joined with purchase order details (empty array if none).
  */
	public function export_expenditure_data() {
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
		$response = array();
	
		$this->db->select('c.sess_eml, c.session_company, c.expenditure_date, c.expenditure_no, i.currentdate, i.purchaseorder_id, c.owner,c.sub_total');
		$this->db->from('expenditure c');
		$this->db->join('purchaseorder i', 'c.po_id = i.id', 'left');
	
		$this->db->where('c.delete_status', '1');
		$this->db->where('c.session_comp_email', $session_comp_email);
		$this->db->where('c.session_company', $session_company);
	
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
	}

	// <--------------------------------- Payment Reciept -------------------------------------->
 /**
 * Export payment receipt data for the current session company/email as an array of records.
 * @example
 * $result = $this->Export_model->export_paymentreciept_data();
 * print_r($result);
 * // Sample output:
 * // Array(
 * //   [0] => Array(
 * //     'sess_eml' => 'company@example.com',
 * //     'session_company' => 'Acme Inc',
 * //     'paymentreceipt_date' => '2025-01-15',
 * //     'paymentreceipt_no' => 'PR-0001',
 * //     'org_name' => 'Acme Incorporated',
 * //     'currency' => 'USD',
 * //     'owner' => 'John Doe',
 * //     'sub_total' => '1500.00'
 * //   )
 * // )
 * @param {void} $none - This method accepts no arguments; it uses session data internally to filter results.
 * @returns {array} Array of associative arrays representing payment receipt rows (keys: sess_eml, session_company, paymentreceipt_date, paymentreceipt_no, org_name, currency, owner, sub_total).
 */
	public function export_paymentreciept_data() {
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
		$response = array();
	
		$this->db->select('c.sess_eml, c.session_company, c.paymentreceipt_date	, c.paymentreceipt_no, c.org_name, c.currency, c.owner,c.sub_total');
		$this->db->from('paymentreceipt c');
		$this->db->group_by('c.paymentreceipt_no');
		$this->db->join('purchaseorder i', 'c.auto_id = i.id', 'left');
	
		$this->db->where('c.delete_status', '1');
		$this->db->where('c.session_comp_email', $session_comp_email);
		$this->db->where('c.session_company', $session_company);
	
		$q = $this->db->get();
		$response = $q->result_array();
		return $response;
	}
	

	
 /**
 * Retrieve all non-deleted sales orders for the currently logged session company.
 * @example
 * $this->load->model('Export_model');
 * $result = $this->Export_model->export_so_data();
 * print_r($result);
 * // Example output:
 * // Array (
 * //     [0] => Array (
 * //         'sess_eml' => 'company@example.com',
 * //         'owner' => 'John Owner',
 * //         'opp_name' => 'Opportunity 1',
 * //         'subject' => 'Sales Order Subject',
 * //         'org_name' => 'Organization Ltd',
 * //         'contact_name' => 'Jane Contact',
 * //         'pending' => '0',
 * //         'due_date' => '2025-12-31',
 * //         'product_name' => 'Product A',
 * //         'hsn_sac' => '1001',
 * //         'sku' => 'SKU123',
 * //         'quantity' => '10',
 * //         'unit_price' => '15.00',
 * //         'total' => '150.00',
 * //         'gst' => '18.00',
 * //         'cgst' => '9.00',
 * //         'sgst' => '9.00',
 * //         'status' => 'Confirmed',
 * //         'billing_country' => 'Country',
 * //         'billing_state' => 'State',
 * //         'billing_city' => 'City',
 * //         'billing_zipcode' => '12345',
 * //         'billing_address' => 'Billing address line',
 * //         'shipping_address' => 'Shipping address line',
 * //         'datetime' => '2025-12-01 10:00:00'
 * //     ),
 * //     ...
 * // )
 * @param void $none - This method does not accept any parameters.
 * @returns array Array of associative arrays, each representing a sales order record filtered by current session company and delete_status = '1'.
 */
	public function export_so_data(){
		$session_comp_email = $this->session->userdata('company_email');
        $session_company 	= $this->session->userdata('company_name');
 		$response = array();
		$this->db->select('sess_eml,owner,opp_name,subject,org_name,contact_name,pending,due_date,carrier,payment_terms,pay_terms_status,approved_by,status,billing_country,billing_state,billing_city,billing_zipcode,billing_address,shipping_country,shipping_state,shipping_city,shipping_zipcode,shipping_address,product_name,hsn_sac,sku,quantity,unit_price,estimate_purchase_price,total,initial_total,initial_estimate_purchase_price,discount,pro_description,sub_totals,total_estimate_purchase_price,gst,igst,cgst,sgst,pro_discount,total_igst,total_cgst,total_sgst,type,sub_total_with_gst,total_orc,is_renewal,renewal_date,advanced_payment,pending_payment,datetime');
		$this->db->where('delete_status','1');
		$this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
		$q = $this->db->get('salesorder');
		$response = $q->result_array();
	 	return $response;
	}
	
	
 /**
 * Retrieve sales order records for the current session company (excluding provided sale order IDs) with a specific set of fields suitable for export without a purchase order.
 * @example
 * $soIds = [10, 20]; 
 * $result = $this->Export_model->data_without_po($soIds);
 * print_r($result); // e.g. Array ( [0] => Array ( 'sess_eml' => 'info@example.com', 'owner' => 'John Doe', 'opp_name' => 'Opportunity 1', 'product_name' => 'Widget', 'quantity' => '5', 'unit_price' => '100.00', 'total' => '500.00', ... ) )
 * @param {array} $soId - Optional array of saleorder_id integers to exclude from the query (defaults to empty array).
 * @returns {array} Array of associative arrays representing matching salesorder rows (selected fields only).
 */
	public function data_without_po($soId = []){
		$session_comp_email = $this->session->userdata('company_email');
        $session_company 	= $this->session->userdata('company_name');
 		$response = array();
		$this->db->select('sess_eml,owner,opp_name,subject,org_name,contact_name,pending,due_date,carrier,payment_terms,pay_terms_status,approved_by,status,billing_country,billing_state,billing_city,billing_zipcode,billing_address,shipping_country,shipping_state,shipping_city,shipping_zipcode,shipping_address,product_name,hsn_sac,sku,quantity,unit_price,estimate_purchase_price,total,initial_total,initial_estimate_purchase_price,discount,pro_description,sub_totals,total_estimate_purchase_price,gst,igst,cgst,sgst,pro_discount,total_igst,total_cgst,total_sgst,type,sub_total_with_gst,total_orc,is_renewal,renewal_date,advanced_payment,pending_payment,datetime');
		$this->db->where('delete_status','1');
		$this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
		if (!empty($soId)) {
			$this->db->where_not_in('saleorder_id', $soId);
		}
        // $this->db->where('saleorder_id !=', $soId); 
		$q = $this->db->get('salesorder');
		$response = $q->result_array();
	 	return $response;
	}
	


 /**
 * Export filtered salesorder records as an array based on provided filters and current session company context.
 * @example
 * $result = $this->Export_model->export_filterData('2025-12-01', 'sales.user@example.com', 'Acme Corporation', 'PO12345', 'new');
 * // Sample output (truncated):
 * // array(
 * //   array(
 * //     'sess_eml' => 'sales.user@example.com',
 * //     'owner' => 'John Doe',
 * //     'opp_name' => 'Opportunity 1',
 * //     'subject' => 'Proposal for Acme',
 * //     'org_name' => 'Acme Corporation',
 * //     'total' => '1500.00',
 * //     'datetime' => '2025-12-01 10:30:00'
 * //   ),
 * //   ...
 * // );
 * @param {{string|null}} {{$searchDate}} - Date filter. Use "This Week" to filter from last Monday, or provide a date string (YYYY-MM-DD) to include records on/after that date. Default null.
 * @param {{string|null}} {{$searchUser}} - Session user email (sess_eml) to filter results. Default null.
 * @param {{string|null}} {{$customer}} - Customer/organization name (org_name) to filter results. Default null.
 * @param {{string|null}} {{$custpo}} - Customer PO number (po_no) to filter results. Default null.
 * @param {{string|null}} {{$newValue}} - Item type filter: "new" => salesorder_item_type = '0', "renew" => salesorder_item_type = '1'. Default null.
 * @returns {{array}} Array of associative arrays representing matching salesorder rows (selected fields include sess_eml, owner, opp_name, subject, org_name, product_name, total, datetime, etc.).
 */
	public function export_filterData($searchDate = null, $searchUser = null, $customer = null, $custpo = null, $newValue = null)
	{
		$session_comp_email = $this->session->userdata('company_email');
		$session_company     = $this->session->userdata('company_name');

		$response = array();

		$this->db->select('sess_eml,owner,opp_name,subject,org_name,contact_name,pending,due_date,carrier,payment_terms,pay_terms_status,approved_by,status,billing_country,billing_state,billing_city,billing_zipcode,billing_address,shipping_country,shipping_state,shipping_city,shipping_zipcode,shipping_address,product_name,hsn_sac,sku,quantity,unit_price,estimate_purchase_price,total,initial_total,initial_estimate_purchase_price,discount,pro_description,sub_totals,total_estimate_purchase_price,gst,igst,cgst,sgst,pro_discount,total_igst,total_cgst,total_sgst,type,sub_total_with_gst,total_orc,is_renewal,renewal_date,advanced_payment,pending_payment,datetime');

		$this->db->where('delete_status', '1');
		$this->db->where('session_comp_email', $session_comp_email);
		$this->db->where('session_company', $session_company);

		if ($searchDate == "This Week") {
			$this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
		} elseif (!empty($searchDate)) {
			$this->db->where('currentdate >=', $searchDate);
		}

		if (!empty($searchUser)) {
			$this->db->where('sess_eml', $searchUser);
		}

		if (!empty($custpo)) {
			$this->db->where('po_no', $custpo);
		}

		if ($newValue === "new") {
			$this->db->where('salesorder_item_type', '0');
		} elseif ($newValue === "renew") {
			$this->db->where('salesorder_item_type', '1');
		}

		if (!empty($customer)) {
			$this->db->where('org_name', $customer);
		}

		$q = $this->db->get('salesorder');
		$response = $q->result_array();
		return $response;
	}
	
	
 /**
 * Retrieve purchase order data for the current session company where delete_status = '1'.
 * @example
 * // In a CodeIgniter controller after loading the model:
 * $this->load->model('Export_model');
 * $result = $this->Export_model->export_po_data();
 * // Sample output (one item shown):
 * // Array
 * // (
 * //     [0] => Array
 * //         (
 * //             [sess_eml] => company@example.com
 * //             [owner] => John Doe
 * //             [subject] => "Purchase Order #PO123"
 * //             [contact_name] => "Jane Smith"
 * //             [billing_gstin] => "27ABCDE1234F2Z5"
 * //             [shipping_gstin] => "27ABCDE1234F2Z5"
 * //             [billing_country] => "India"
 * //             [billing_state] => "Maharashtra"
 * //             [billing_city] => "Mumbai"
 * //             [billing_zipcode] => "400001"
 * //             [billing_address] => "123 Business St"
 * //             [supplier_name] => "Supplier Co"
 * //             [product_name] => "Widget"
 * //             [quantity] => "10"
 * //             [unit_price] => "100.00"
 * //             [total] => "1000.00"
 * //             [gst] => "18"
 * //             [datetime] => "2025-01-01 12:00:00"
 * //         )
 * // )
 * @param void $none - This method does not accept any parameters.
 * @returns array Array of associative arrays representing matching purchase orders (rows from 'purchaseorder' table).
 */
	public function export_po_data(){
		$session_comp_email = $this->session->userdata('company_email');
        $session_company 	= $this->session->userdata('company_name');
 		$response = array();
		$this->db->select('sess_eml,owner,subject,contact_name,billing_gstin,shipping_gstin	billing_country,billing_state,billing_city,billing_zipcode,billing_address,shipping_country,shipping_state,shipping_city,shipping_zipcode,shipping_address,	supplier_name,supplier_contact,supplier_comp_name,supplier_email,supplier_gstin,supplier_country,supplier_state,supplier_city,supplier_zipcode,supplier_address,type,product_name,hsn_sac,sku,quantity,unit_price,total,gst,igst,cgst,sgst,sub_total_with_gst,total_igst,total_cgst,total_sgst,pro_discount,extra_charge_label,extra_charge_value,delete_status,total_orc_po,estimate_purchase_price_po,initial_estimate_purchase_price_po,total_estimate_purchase_price_po,profit_by_user_po,pro_description,initial_total,discount,after_discount_po,sub_total,terms_condition,customer_company_name,customer_name,customer_email,customer_mobile,microsoft_lan_no,promo_id,customer_address,approve_status,approved_by,so_owner,so_owner_email,org_name,end_renewal,is_renewal,renewal_date,datetime');
		
		$this->db->where('delete_status','1');
		$this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
		$q = $this->db->get('purchaseorder');
		$response = $q->result_array();
// 		print_r($response);die;
	 	return $response;
	}
	
	
	
	
	
 /**
 * Export invoice data for the currently logged-in company session.
 * @example
 * $CI =& get_instance();
 * $CI->load->model('Export_model');
 * $result = $CI->Export_model->export_invoice_data();
 * print_r($result); // Sample output: Array ( [0] => Array ( [sess_eml] => "company@example.com" [owner] => "Owner Name" [so_owner] => "Sales Owner" [saleorder_id] => "SO-1001" [invoice_no] => "INV-1001" [invoice_date] => "2025-01-15" [due_date] => "2025-02-14" [buyer_date] => "2025-01-15" [inv_terms] => "NET 30" [extra_field_label] => "" [extra_field_value] => "" [org_name] => "Customer Co" [cust_order_no] => "PO-500" [invoice_declaration] => "" [declaration_status] => "1" [notes] => "Notes here" [type] => "invoice" [pro_description] => "Product description" [enquiry_email] => "contact@customer.com" [enquiry_mobile] => "1234567890" [product_name] => "Product A" [hsn_sac] => "9983" [gst] => "18" [quantity] => "2" [unit_price] => "500.00" [total] => "1000.00" [sgst] => "90.00" [cgst] => "90.00" [igst] => "0.00" [sub_total_with_gst] => "1180.00" [total_igst] => "0.00" [total_cgst] => "90.00" [total_sgst] => "90.00" [pro_discount] => "0.00" [extra_charge_label] => "" [extra_charge_value] => "0.00" [terms_condition] => "" [total_discount] => "0.00" [discount_type] => "fixed" [discount] => "0.00" [initial_total] => "1000.00" [sub_total] => "1000.00" [advanced_payment] => "0.00" [pending_payment] => "1180.00" [currentdate] => "2025-01-15" ) )
 * @param {void} $none - No parameters are required; function reads company context from session.
 * @returns {array} Array of associative arrays where each element represents an invoice row with selected fields.
 */
	public function export_invoice_data(){
		$session_comp_email = $this->session->userdata('company_email');
        $session_company 	= $this->session->userdata('company_name');
 		$response = array();
		$this->db->select('sess_eml,owner,so_owner,saleorder_id,invoice_no,invoice_date,due_date,buyer_date,inv_terms,extra_field_label,extra_field_value,org_name,cust_order_no,invoice_declaration,declaration_status,notes,type,pro_description,enquiry_email,enquiry_mobile,product_name,hsn_sac,gst,quantity,unit_price,total,sgst,cgst,igst,sub_total_with_gst,total_igst,total_cgst,total_sgst,pro_discount,extra_charge_label,extra_charge_value,terms_condition,total_discount,discount_type,discount,initial_total,sub_total,advanced_payment,pending_payment,currentdate');
		
		$this->db->where('delete_status','1');
		$this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
		$q = $this->db->get('invoices');
		$response = $q->result_array();
	 	return $response;
	}
	
  
  
// Please Write Code Above This  
}
?>
