<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Leads extends REST_Controller {
    
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
            $data = $this->db->get("lead");
       
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
            $data = $this->db->get("lead");
       
        if($data->num_rows()>0){
            $this->response(['row_count'=>$data->num_rows()], REST_Controller::HTTP_OK);
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
        
        if($session_company !='' && $session_comp_email !=''){
            
	        
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
        
            if($id !=''){
                $this->db->where('id',$id);
            }
            
            if($this->post('sess_eml')){
                $this->db->where('sess_eml',$sess_eml);
            }
            $this->db->order_by('id', 'desc');
            $this->db->limit(10, $v);
            $this->db->where('delete_status', 1);
            $data = $this->db->get("lead");
           
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
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('org_name', 'Organization', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'regex_match[/^[0-9]{10}$/]|trim');
            //$this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
            $this->form_validation->set_message('required', '%s is required');
            //$this->form_validation->set_message('valid_email', '%s is not valid');
        
        if($this->form_validation->run() == true)
		{
            $input = $this->input->post();
            $this->db->insert('lead',$input);
            $this->response(['Lead created successfully.'], REST_Controller::HTTP_OK);
		}else{
            $error = validation_errors();
            $this->response([$error], REST_Controller::HTTP_OK);
        }    
    } 
    
    
    
    
    public function add_post()
    {   
        $input = $this->input->post();
        $this->db->insert('lead',$input);
        $id=$this->db->insert_id();
        updateidForApi($id,'lead','lead_id');
        $this->response(['Lead created successfully.'], REST_Controller::HTTP_OK);
	  
    } 
    
    
    
    
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('lead', $input, array('id'=>$id));
     
        $this->response(['Lead updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('lead', array('id'=>$id));
       
        $this->response(['Lead deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}
?>