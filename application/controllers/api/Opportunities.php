<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Opportunities extends REST_Controller {
    
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
	    $url =  $this->uri->segment(4);
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
        
        if($url=='Negotiation')
        {
            $this->db->where('stage',$url);
        }
        
        if($url=='Closed_Lost')
        {
            $this->db->where('stage','Closed Lost');
        }
            $this->db->where('delete_status', 1);
            $data = $this->db->get("opportunity");
       
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
	    $url =  $this->uri->segment(4);
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        
        if($session_company !='' && $session_comp_email !=''){
            
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
       
        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
        
        if($url=='Negotiation')
        {
            $this->db->where('stage',$url);
        }
        
        if($url=='Closed_Lost')
        {
            $this->db->where('stage','Closed Lost');
        }
            $this->db->where('delete_status', 1);
            $data = $this->db->get("opportunity");
       
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
	    $url =  $this->uri->segment(4);
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        
        if($session_company !='' && $session_comp_email !=''){
            
            $this->db->select_sum("sub_total");
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
       
            if($this->post('sess_eml')){
                $this->db->where('sess_eml',$sess_eml);
            }
            if($url=='Negotiation')
            {
                $this->db->where('stage',$url);
            }
            
            if($url=='Closed_Lost')
            {
                $this->db->where('stage', 'Closed Lost');
            }
            $this->db->where('delete_status', 1);   
            $data = $this->db->get("opportunity");
            $total = $data->row_array();
            
            
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
       
            if($this->post('sess_eml')){
                $this->db->where('sess_eml',$sess_eml);
            }
            if($url=='Negotiation')
            {
                $this->db->where('stage',$url);
            }
            
            if($url=='Closed_Lost')
            {
                $this->db->where('stage','Closed Lost');
            }
            
            $this->db->where('delete_status', 1);
            $data = $this->db->get("opportunity");
            $rcount = $data->num_rows();
       
            if($data->num_rows()>0){
                $this->response(['sub_total'=>$total['sub_total'], 'Row_count'=> $rcount], REST_Controller::HTTP_OK);
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
        $session_comp_email= $this->post('session_comp_email');
        $customer          = $this->post('customer');
        
        $offset          = $this->post('offset');
        $limit           = $this->post('limit');
        
        if($session_company !='' && $session_comp_email !=''){
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
        
        if($id !=''){
            $this->db->where('id',$id);
        }
        if(isset($customer) && $customer!=""){
            $this->db->where('org_name',$customer);
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
        
        
        
        
        $data = $this->db->get("opportunity");
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
            $this->form_validation->set_rules('name', 'Opportunity Name', 'required|trim');
            $this->form_validation->set_rules('org_name', 'Organization Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
            $this->form_validation->set_rules('contact_name', 'Contact Name', 'required|trim');
           
            $this->form_validation->set_message('required', '%s is required');
            $this->form_validation->set_message('valid_email', '%s is not valid');
        if($this->form_validation->run() == true)
		{    
            $input = $this->input->post();
            $this->db->insert('opportunity',$input);
            $this->response(['Opportunity created successfully.'], REST_Controller::HTTP_OK);
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
        $this->db->update('opportunity', $input, array('id'=>$id));
     
        $this->response(['Opportunity updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('opportunity', array('id'=>$id));
       
        $this->response(['Opportunity deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}
?>