<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Vendors extends REST_Controller {
    
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
            $data = $this->db->get("vendor");
       
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
            $this->form_validation->set_rules('name', 'Vendor Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]|trim');
            $this->form_validation->set_rules('gstin', 'GST Number', 'required|trim');
            $this->form_validation->set_rules('gst_rtype', 'GST Type', 'required|trim');
            $this->form_validation->set_message('required', '%s is required');
            $this->form_validation->set_message('valid_email', '%s is not valid');
            $this->form_validation->set_message('regex_match','%s is invalid'); 
        if($this->form_validation->run() == true)
        {
            $input = $this->input->post();
            $this->db->insert('vendor',$input);
            $this->response(['Vendors created successfully.'], REST_Controller::HTTP_OK);
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
        $this->db->update('vendor', $input, array('id'=>$id));
     
        $this->response(['Vendors updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('vendor', array('id'=>$id));
       
        $this->response(['Vendors deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}
?>