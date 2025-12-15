<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Salesorders extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    
    public function __construct() {
       parent::__construct();
       $this->load->database();
	   $this->load->model('Lead_model','Lead');
	   $this->load->model('Opportunity_model','Opportunity');
	   $this->load->model('Salesorders_model','Salesorders');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    
	public function list_post()
	{
	    $url               = $this->uri->segment(4);
	    $id                = $this->post('id');
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        
        if($session_company !='' && $session_comp_email !=''){
            
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
        
        if($id !=''){
            $this->db->where('id',$id);
        }
        
        if($url=='Pending')
        {
            $this->db->where('status',$url);
        }
        
        if($url=='Approved')
        {
            $this->db->where('status',$url);
        }
        
        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
        $this->db->where('delete_status',1);
            $data = $this->db->get("salesorder");
       
        if($data->num_rows()>0){
            $this->response($data->result_array(), REST_Controller::HTTP_OK);
        }else{
           $this->response(['No data available.'], REST_Controller::HTTP_OK); 
        }
        
        }else{
            $this->response(['Company name and company email required.'], REST_Controller::HTTP_OK);  
        }
        
	}
	
	public function revenue_post()
	{
	    $url               = $this->uri->segment(4);
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        
        if($session_company !='' && $session_comp_email !=''){
            
            $this->db->select_sum("sub_totals");
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
       
            if($this->post('sess_eml')){
                $this->db->where('sess_eml',$sess_eml);
            }
            
             if($url=='Pending')
            {
                $this->db->where('status',$url);
            }
            
            if($url=='Approved')
            {
                $this->db->where('status',$url);
            }
            $this->db->where('delete_status',1);
            $data = $this->db->get("salesorder");
            $total = $data->row_array();
            
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
       
            if($this->post('sess_eml')){
                $this->db->where('sess_eml',$sess_eml);
            }
            
            if($url=='Pending')
            {
                $this->db->where('status',$url);
            }
            
            if($url=='Approved')
            {
                $this->db->where('status',$url);
            }
            $this->db->where('delete_status',1);
            $data = $this->db->get("salesorder");
            $rcount = $data->num_rows();
       
            $this->response(['sub_total'=>$total['sub_totals'], 'row_count'=>$rcount], REST_Controller::HTTP_OK);
        
        }else{
            $this->response(['Company name and company email required.'], REST_Controller::HTTP_OK);  
        }
        
	}
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    
    public function index_post()
    {       
            $this->form_validation->set_rules('quote_id', 'Quotation Id', 'required|trim');
            $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
            $this->form_validation->set_rules('contact_name', 'Contact Name', 'required|trim');
            $this->form_validation->set_rules('opp_name', 'Opportunity Name', 'required|trim');
            $this->form_validation->set_rules('billing_country', 'Billing Country', 'required|trim');
            $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
            $this->form_validation->set_rules('shipping_country', 'Shipping Country', 'required|trim');
            $this->form_validation->set_rules('shipping_state', 'Sipping State', 'required|trim');
            $this->form_validation->set_rules('billing_city', 'Billing City', 'required|trim');
            $this->form_validation->set_rules('billing_zipcode', 'Billing Zipcode', 'required|trim');
            $this->form_validation->set_rules('shipping_zipcode', 'Shipping Zipcode', 'required|trim');
            $this->form_validation->set_rules('shipping_city', 'Shipping City', 'required|trim');
            $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
            $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'required|trim');
            $this->form_validation->set_message('required', '%s is required');
            
        if($this->form_validation->run() == true)
		{
            $input = $this->input->post();
            $this->db->insert('salesorder',$input);
            $this->response(['Salesorder created successfully.'], REST_Controller::HTTP_OK);
        }else{
            $error = validation_errors();
            $this->response([$error], REST_Controller::HTTP_OK);
        }     
    } 
     
    
    /*public function index_post_old()
    {
        //$input = $this->input->post();
		
		$owner 			    = $this->input->post('owner');
        $subject 			= $this->input->post('subject');
        $status 			= $this->input->post('status');
        $sub_totals 		= $this->input->post('sub_total');
        $after_discount 	= $this->input->post('after_discount');
        $page_source 		= $this->input->post('page_source');
		$initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
        $unit_price 	= str_replace(",", "",$this->input->post('unit_price'));
        $total 			= str_replace(",", "",$this->input->post('total'));
        $after_discount = str_replace(",", "",$this->input->post('after_discount'));
        $sub_total 		= str_replace(",", "",$this->input->post('sub_total')); 
		$total_orc 		= str_replace(",", "",$this->input->post('total_orc'));
		$estimate_purchase_price 	= str_replace(",", "",$this->input->post('estimate_purchase_price'));
        $initial_est_purchase_price = str_replace(",", "",$this->input->post('initial_est_purchase_price'));
        $total_est_purchase_price 	= str_replace(",", "",$this->input->post('total_est_purchase_price'));
		$profit_by_user				= str_replace(",", "",$this->input->post('profit_by_user'));
		if($this->input->post('terms_condition')){
		  $terms_condition=implode("<br>",$this->input->post('terms_condition'));
	    }else{
		  $terms_condition="";
	    }
		if($this->input->post('product_name')){
		  $product_name=implode("<br>",$this->input->post('product_name'));
	    }else{
		  $product_name="";
	    }
		if($this->input->post('hsn_sac')){
		  $hsn_sac=implode("<br>",$this->input->post('hsn_sac'));
	    }else{
		  $hsn_sac="";
	    }
		if($this->input->post('sku')){
		  $sku=implode("<br>",$this->input->post('sku'));
	    }else{
		  $sku="";
	    }
		if($this->input->post('gst')){
		  $gst=implode("<br>",$this->input->post('gst'));
	    }else{
		  $gst="";
	    }
		if($this->input->post('quantity')){
		  $quantity=implode("<br>",$this->input->post('quantity'));
	    }else{
		  $quantity="";
	    }
		if($unit_price){
		  $unit_price=implode("<br>",$unit_price);
	    }else{
		  $unit_price="";
	    }
		if($total){
		  $total=implode("<br>",$total);
	    }else{
		  $total="";
	    }
		if($this->input->post('percent')){
		  $percent=implode("<br>",$this->input->post('percent'));
	    }else{
		  $percent="";
	    }
		if($estimate_purchase_price){
		  $estimate_purchase_price=implode("<br>",$estimate_purchase_price);
	    }else{
		  $estimate_purchase_price="";
	    }
		if($initial_est_purchase_price){
		  $initial_est_purchase_price=implode("<br>",$initial_est_purchase_price);
	    }else{
		  $initial_est_purchase_price="";
	    }
		
        $input = array(
          'sess_eml' 			=> $sess_eml='',
          'session_company' 	=> $session_company='',
          'session_comp_email' 	=> $session_comp_email='',
          'owner' 				=> $owner,
          'org_name' 			=> $this->input->post('org_name'),
          'subject' 			=> $subject,
          'contact_name' 		=> $this->input->post('contact_name_hidden'),
          'opp_name' 			=> $this->input->post('opp_name'),
          'pending' 			=> $this->input->post('pending'),
          'quote_id' 			=> $this->input->post('quote_id'),
          'excise_duty' 		=> $this->input->post('excise_duty'),
          'due_date' 			=> $this->input->post('due_date'),
          'carrier' 			=> $this->input->post('carrier'),
          'status' 				=> $status,
          'sales_commision' 	=> $this->input->post('sales_commission'),
          'billing_country' 	=> $this->input->post('billing_country'),
          'billing_state' 		=> $this->input->post('billing_state'),
          'shipping_country' 	=> $this->input->post('shipping_country'),
          'shipping_state' 		=> $this->input->post('shipping_state'),
          'billing_city' 		=> $this->input->post('billing_city'),
          'billing_zipcode' 	=> $this->input->post('billing_zipcode'),
          'shipping_city' 		=> $this->input->post('shipping_city'),
          'shipping_zipcode' 	=> $this->input->post('shipping_zipcode'),
          'billing_address' 	=> $this->input->post('billing_address'),
          'shipping_address' 	=> $this->input->post('shipping_address'),
          'type' 				=> $this->input->post('type_hidden'),
          'product_name' 		=> $product_name,
          'hsn_sac' 			=> $hsn_sac,
          'sku' 				=> $sku,
          'gst' 				=> $gst,
          'quantity' 			=> $quantity,
          'unit_price' 			=> $unit_price,
          'total' 				=> $total,
          'percent' 			=> $percent,
          'initial_total' 		=> $initial_total,
          'discount' 			=> $this->input->post('discount'),
          'after_discount' 		=> $after_discount,
          'igst12' 				=> $this->input->post('igst12'),
          'igst18' 				=> $this->input->post('igst18'),
          'igst28' 				=> $this->input->post('igst28'),
          'cgst6' 				=> $this->input->post('cgst6'),
          'sgst6' 				=> $this->input->post('sgst6'),
          'cgst9' 				=> $this->input->post('cgst9'),
          'sgst9' 				=> $this->input->post('sgst9'),
          'cgst14' 				=> $this->input->post('cgst14'),
          'sgst14' 				=> $this->input->post('sgst14'),
          'sub_totals' 			=> $sub_total,
          'total_percent' 		=> $this->input->post('total_percent'),
          'profit_by_user' 		=> $profit_by_user,
          'terms_condition' 	=> $terms_condition,
          'customer_company_name' => $this->input->post('customer_company_name'),
          'customer_name' 		=> $this->input->post('customer_name'),
          'customer_email' 		=> $this->input->post('customer_email'),
          'customer_mobile' 	=> $this->input->post('customer_mobile'),
          'microsoft_lan_no' 	=> $this->input->post('microsoft_lan_no'),
          'promo_id' 			=> $this->input->post('promo_id'),
          'customer_address' 	=> $this->input->post('customer_address'),
          'estimate_purchase_price' 		=> $estimate_purchase_price,
          'initial_estimate_purchase_price' => $initial_est_purchase_price,
          'total_estimate_purchase_price' 	=> $total_est_purchase_price,
          'total_orc' 			=> $total_orc,
          //'product_line' 		=> count($product_name),
          'currentdate' 		=> date("y.m.d"),
          //'attached_file' => $new_name,
          'opportunity_id' 		=> $this->input->post('opportunity_id'),
		  );
		
        //$this->db->insert('salesorder',$input);
		//$id = $this->db->insert_id();
		$id = $this->Salesorders->create($input);
		if(!empty($id))
        {
        $x = "100";
        $slo = $id+$x;
        $saleorder_id = "SO/".date('Y')."/".$slo;
		/*$data = array(
		  'saleorder_id' => $saleorder_id
		);
		//update salesorder
		$this->db->where('id',$id);
		$this->db->update('salesorder',$data);--
		$this->Salesorders->saleorder_id($saleorder_id,$id);
       
	    $datas = array( 'track_status' => 'salesorder');
        $this->Lead->update_lead_track_status(array('opportunity_id' => $this->input->post('opportunity_id')),$datas);
        $this->Opportunity->update_opp_track_status(array('opportunity_id' => $this->input->post('opportunity_id')),$datas);
        $this->load->model('Notification_model');
	    //$data=$this->Notification_model->addNotification('salesorders',$id);
        }
     
        $this->response(['Salesorders created successfully.'], REST_Controller::HTTP_OK);
    } */
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('salesorder', $input, array('id'=>$id));
		$result = $this->db->affected_rows();
     
        $this->response(['Salesorders updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('salesorder', array('id'=>$id));
       
        $this->response(['Salesorders deleted successfully.'], REST_Controller::HTTP_OK);
    }
    
}
?>