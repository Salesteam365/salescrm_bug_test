<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Export_model extends CI_Model
{
  
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
