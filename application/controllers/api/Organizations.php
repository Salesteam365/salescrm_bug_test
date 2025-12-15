<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Organizations extends REST_Controller {
    
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
        $org_name          = $this->post('org_name');
        
        if($session_company !='' && $session_comp_email !=''){
            
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
        
        if($id !=''){
            $this->db->where('id',$id);
        }
        
        if($org_name !=''){
            $this->db->where('org_name',$org_name);
        }
        
        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
            $this->db->where('delete_status',1);
            $data = $this->db->get("organization");
       
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
        $org_name          = $this->post('org_name');
        
        if($session_company !='' && $session_comp_email !=''){
            
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
        
            if($org_name !=''){
                $this->db->where('org_name',$org_name);
            }
            
            if($this->post('sess_eml')){
                $this->db->where('sess_eml',$sess_eml);
            }
                $this->db->where('delete_status',1);
                $data = $this->db->get("organization");
           
            if($data->num_rows()>0){
                $this->response(['row_count'=>$data->num_rows()], REST_Controller::HTTP_OK);
            }else{
               $this->response(['No data available.'], REST_Controller::HTTP_OK); 
            }
        
        }else{
            $this->response(['Company name and company email required.'], REST_Controller::HTTP_OK);  
        }
	}
	
	public function org_cont_list_post()
	{
	    $inp               = $this->post('token');
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        $org_name          = $this->post('org_name');
        
        if($session_company !='' && $session_comp_email !=''){
            
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
        
        if($inp !=''){
            $this->db->like('organization_id', $inp);
            $this->db->or_like('customer_type', $inp);
            $this->db->or_like('primary_contact', $inp);
            $this->db->or_like('email', $inp);
            $this->db->or_like('mobile', $inp);
        }
        
        if($org_name !=''){
            $this->db->where('org_name',$org_name);
        }
        
        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
        
        $this->db->join('organization','contact.id = organization.id');
        $data = $this->db->get('organization');
        // $data = $this->db->get('organization');
        // $data =  $this->db->last_query();
        // print_r($data);
        //   exit;
        
        if($data->num_rows()>0){
            $this->response($data->result_array(), REST_Controller::HTTP_OK);
        }else{
           $this->response(['No data available.'], REST_Controller::HTTP_OK); 
        }
        
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
        $org_name          = $this->post('org_name');
        if($session_company !='' && $session_comp_email !=''){
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
        if($org_name !=''){
            $this->db->where('org_name',$org_name);
        }
        if($id !=''){
            $this->db->where('id',$id);
        }
        
        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
           //$this->db->order_by('org_name',"asc");
            $this->db->order_by('id','desc');
            $this->db->limit(10, $v);
            $data = $this->db->get("organization");
       
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
        $input = $this->input->post();
		    $this->form_validation->set_rules('org_name', 'Organization Name', 'required|trim');
            $this->form_validation->set_rules('primary_contact', 'Primary Contact', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]|trim');
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
        if($this->form_validation->run() == true)
		{
        
            $this->db->insert('organization',$input);
            $this->response(['Organization created successfully.'], REST_Controller::HTTP_OK);
            
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
        $this->db->update('organization', $input, array('id'=>$id));
     
        $this->response(['Organization updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('organization', array('id'=>$id));
       
        $this->response(['Organization deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}
?>