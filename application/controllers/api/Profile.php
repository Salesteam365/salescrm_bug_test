<?php
require APPPATH . 'libraries/REST_Controller.php';
     
class Profile extends REST_Controller {
    
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
     
	public function list_post()
	{
	    $id                = $this->post('id');
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        
        if($session_company !='' && $session_comp_email !=''){
            $this->db->where('company_name',$session_company);
            $this->db->where('company_email',$session_comp_email);
        if($id !=''){
            $this->db->where('id',$id);
        }
        
        if($this->post('sess_eml')){
            $this->db->where('admin_email',$sess_eml);
        }
        $this->db->where('account_type<>','End');
            $data = $this->db->get("admin_users");
       
        if($data->num_rows()>0){
            $this->response($data->result_array(), REST_Controller::HTTP_OK);
        }else{
           $this->response(['No data available.'], REST_Controller::HTTP_OK); 
        }
        
        }else{
            $this->response(['Company name and company email required.'], REST_Controller::HTTP_OK);  
        }
	    
        
	}
	
	public function plan_post()
	{
	    $id                = $this->post('id');
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        
        if($session_company !='' && $session_comp_email !=''){
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
        if($id !=''){
            $this->db->where('admin_id',$id);
        }
        
        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
        
        $data = $this->db->get("licence_detail");
       
        if($data->num_rows()>0){
            $this->response($data->result_array(), REST_Controller::HTTP_OK);
        }else{
           $this->response(['No data available.'], REST_Controller::HTTP_OK); 
        }
        
        }else{
            $this->response(['Company name and company email required.'], REST_Controller::HTTP_OK);  
        }
	    
        
	}
	
	
	
      
    /*
    public function index_post()
    {
        
        if($this->input->post('contact_type')=='Vendor'){
            $this->form_validation->set_rules('name', 'Contact Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
            
        }else{
        
            $this->form_validation->set_rules('name', 'Contact Name', 'required|trim');
            $this->form_validation->set_rules('org_name', 'Organization Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
            $this->form_validation->set_rules('billing_country', 'Billing Country', 'required|trim');
            $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
            $this->form_validation->set_rules('shipping_country', 'Shipping Country', 'required|trim');
            $this->form_validation->set_rules('shipping_state', 'Shipping State', 'required|trim');
            $this->form_validation->set_rules('billing_city', 'Billing City', 'required|trim');
            $this->form_validation->set_rules('billing_zipcode', 'Billing Zipcode', 'required|trim');
            $this->form_validation->set_rules('shipping_zipcode', 'Shipping Zipcode', 'required|trim');
            $this->form_validation->set_rules('shipping_city', 'Shipping City', 'required|trim');
            $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
            $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'required|trim');
            $this->form_validation->set_message('required', '%s is required');
            $this->form_validation->set_message('valid_email', '%s is not valid');
        }
        
        if($this->form_validation->run() == true)
		{
            $input = $this->input->post();
            $this->db->insert('contact',$input);
         
            $this->response(['Contact created successfully.'], REST_Controller::HTTP_OK);
		}else{
            $error = validation_errors();
            $this->response([$error], REST_Controller::HTTP_OK);
        }
        
    } 
    */
    
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    /*
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('contact', $input, array('id'=>$id));
     
        $this->response(['Contact updated successfully.'], REST_Controller::HTTP_OK);
    }
     */
    /**
     * Get All Data from this method.
     *
     * @return Response
    *//*
    public function index_delete($id)
    {
        $this->db->delete('contact', array('id'=>$id));
       
        $this->response(['Contact deleted successfully.'], REST_Controller::HTTP_OK);
    }*/
    	
}
?>