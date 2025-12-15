<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Purchaseorders extends REST_Controller {
    
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
            $data = $this->db->get("purchaseorder");
       
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
            $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
            $this->form_validation->set_rules('contact_name', 'Contact Name', 'required|trim');
            $this->form_validation->set_rules('billing_country', 'Billing Country', 'required|trim');
            $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
            $this->form_validation->set_rules('shipping_country', 'Shipping Country', 'required|trim');
            $this->form_validation->set_rules('shipping_state', 'Shipping State', 'required|trim');
            $this->form_validation->set_rules('billing_city', 'Billing City', 'required|trim');
           // $this->form_validation->set_rules('billing_zipcode', 'Billing Zipcode', 'required|trim');
            $this->form_validation->set_rules('shipping_zipcode', 'Shipping Zipcode', 'required|trim');
            $this->form_validation->set_rules('shipping_city', 'Shipping City', 'required|trim');
            $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
            $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'required|trim');
            $this->form_validation->set_rules('supplier_comp_name', 'Supplier Company Name', 'required|trim');
            $this->form_validation->set_rules('supplier_contact', 'Supplier Contact', 'required|trim');
            $this->form_validation->set_rules('supplier_email', 'Supplier Email', 'required|trim');
            $this->form_validation->set_message('required', '%s is required');
        if ($this->form_validation->run() == true)
        {
            $input = $this->input->post();
            $this->db->insert('purchaseorder',$input);
            $this->response(['Purchaseorders created successfully.'], REST_Controller::HTTP_OK);
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
        $this->db->update('purchaseorder', $input, array('id'=>$id));
     
        $this->response(['Purchaseorders updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('purchaseorder', array('id'=>$id));
       
        $this->response(['Purchaseorders deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}
?>