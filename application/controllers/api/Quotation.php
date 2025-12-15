<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Quotation extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    
	public function list_post()
	{
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
        
        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
            $this->db->where('delete_status', 1);
            $data = $this->db->get("quote");
       
        if($data->num_rows()>0){
            $this->response($data->result_array(), REST_Controller::HTTP_OK);
        }else{
           $this->response(['No data available.'], REST_Controller::HTTP_OK); 
        }
        
        }else{
            $this->response(['Company name and company email required.'], REST_Controller::HTTP_OK);  
        }
	}
	
	public function listcount_post()
	{
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        
        if($session_company !='' && $session_comp_email !=''){
            
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);

        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
            $this->db->where('delete_status', 1);
            $data = $this->db->get("quote");
       
        if($data->num_rows()>0){
            $this->response(['row_count'=>$data->num_rows()], REST_Controller::HTTP_OK);
        }else{
           $this->response(['No data available.'], REST_Controller::HTTP_OK); 
        }
        
        }else{
            $this->response(['Company name and company email required.'], REST_Controller::HTTP_OK);  
        }
	}
	
	public function revenue_post()
	{
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        
        if($session_company !='' && $session_comp_email !=''){
            
            $this->db->select_sum("sub_totalq");
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);

            if($this->post('sess_eml')){
                $this->db->where('sess_eml',$sess_eml);
            }
            $this->db->where('delete_status', 1);
            $data = $this->db->get("quote");
            $total = $data->row_array();
            
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);

            if($this->post('sess_eml')){
                $this->db->where('sess_eml',$sess_eml);
            }
            $this->db->where('delete_status', 1);
            $data = $this->db->get("quote");
            $rcount = $data->num_rows();
       
            $this->response(['sub_total'=>$total['sub_totalq'], 'row_count' =>$rcount], REST_Controller::HTTP_OK);
        
        }else{
            $this->response(['Company name and company email required.'], REST_Controller::HTTP_OK);  
        }
	}
	
		public function clist_post()
	{
	    $num = $this->input->get('num');
	    $v= ($num*10)-10;
        $id                = $this->post('id');
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        $offset          = $this->post('offset');
        $limit           = $this->post('limit');
        
        if($session_company !='' && $session_comp_email !=''){
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
            if($id!=''){
                $this->db->where('id',$id);
            }
            if($this->post('sess_eml')){
                $this->db->where('sess_eml',$sess_eml);
            }
            $this->db->where('delete_status', 1);
            $this->db->order_by('id','desc');
            $this->db->limit(10, $v);
           /* if(isset($offset) && $offset!="" && isset($limit) && $limit!=""){
            $this->db->limit($limit,$offset);
            }*/
        
            
            $data = $this->db->get("quote");
            if($data->num_rows()>0){
                $this->response($data->result_array(), REST_Controller::HTTP_OK);
            }else{
               $this->response(['No data available.'], REST_Controller::HTTP_OK); 
            }
        
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
            $this->form_validation->set_rules('contact_name', 'Contact Name', 'required|trim');
            $this->form_validation->set_rules('quote_stage', 'Quote Stage', 'required|trim');
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
            $this->db->insert('quote',$input);
            $this->response(['Quotation created successfully.'], REST_Controller::HTTP_OK);
        }else{
            $error = validation_errors();
            $this->response([$error], REST_Controller::HTTP_OK);
        }    
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('quote', $input, array('id'=>$id));
     
        $this->response(['Quotation updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('quote', array('id'=>$id));
       
        $this->response(['Quotation deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}
?>