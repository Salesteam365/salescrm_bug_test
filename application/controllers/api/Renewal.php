<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Renewal extends REST_Controller {
    
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
    
    
  public function list_post(){
        $id                = $this->post('id');
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
    
    if($session_company !='' && $session_comp_email !=''){
      $this->db->select('id,org_id,owner,saleorder_id,org_name,subject,renewal_date,sub_totals,currentdate,product_name');
   
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('delete_status',1);
      $this->db->where('is_renewal',1);
	
	    if($id !=''){
            $this->db->where('id',$id);
        }
        
        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
	  
	  if($this->input->post('monthDate'))
      { 
          $year_date = $this->input->post('yearDate');
          $month_date = $this->input->post('monthDate');
          $curndth=$year_date."-".$month_date."-01";
          $a_date = date($curndth);
          $lastday=date("Y-m-t", strtotime($a_date)); 
          $this->db->where('renewal_date >=',$curndth);
          $this->db->where('renewal_date <=',$lastday);
      }else if($this->input->post('searchFromDate')){ 
          $search_from_date = $this->input->post('searchFromDate');
          $search_to_date   = $this->input->post('searchToDate');
          $this->db->where('renewal_date >=',$search_from_date);
          $this->db->where('renewal_date <=',$search_to_date);
      }else{
		  $curndth=date('Y-m-d',strtotime('+1 month'));
          $this->db->where('renewal_date <=',$curndth);        
      }
         $this->db->order_by('id','desc');
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
    
     public function listcount_post(){
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
       
    
    if($session_company !='' && $session_comp_email !=''){
         $this->db->select('id,org_id,owner,saleorder_id,org_name,subject,renewal_date,sub_totals,currentdate,product_name');
         $this->db->where('session_comp_email',$session_comp_email);
         $this->db->where('session_company',$session_company);
         $this->db->where('delete_status',1);
         $this->db->where('is_renewal',1);
	 
        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
    
	  if($this->input->post('monthDate'))
      { 
        $year_date = $this->input->post('yearDate');
        $month_date = $this->input->post('monthDate');
        $curndth=$year_date."-".$month_date."-01";
        $a_date = date($curndth);
        $lastday=date("Y-m-t", strtotime($a_date)); 
        $this->db->where('renewal_date >=',$curndth);
        $this->db->where('renewal_date <=',$lastday);
        
      }else if($this->input->post('searchFromDate')){ 
          $search_from_date = $this->input->post('searchFromDate');
          $search_to_date   = $this->input->post('searchToDate');
          $this->db->where('renewal_date >=',$search_from_date);
          $this->db->where('renewal_date <=',$search_to_date);
      }else{
// 		$year_date = date('Y');
// 		$month_date = date('m');
// 		$curndth=$year_date."-".$month_date."-01";
//         $this->db->where('renewal_date >=',$curndth); 
            $curndth=date('Y-m-d',strtotime('+1 month'));
          $this->db->where('renewal_date <=',$curndth);
      }
      
       $data = $this->db->get("salesorder");
       
        if($data->num_rows()>0){
            $this->response(['row_count'=>$data->num_rows()], REST_Controller::HTTP_OK);
        }else{
           $this->response(['No data available.'], REST_Controller::HTTP_OK); 
        }
        
    }else{
           $this->response(['Company name and company email required.'], REST_Controller::HTTP_OK);  
    }  
       
  } 
    
    
    public function clist_post(){
        $num = $this->input->get('num');
	    $v= ($num*10)-10;
        $id                = $this->post('id');
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        $offset          = $this->post('offset');
        $limit           = $this->post('limit');
    
    if($session_company !='' && $session_comp_email !=''){
          $this->db->select('id,org_id,owner,saleorder_id,org_name,subject,renewal_date,sub_totals,currentdate,product_name');
          $this->db->where('session_comp_email',$session_comp_email);
          $this->db->where('session_company',$session_company);
          $this->db->where('delete_status',1);
          $this->db->where('is_renewal',1);
	
	    if($id !=''){
            $this->db->where('id',$id);
        }
        
        if($this->post('sess_eml')){
            $this->db->where('sess_eml',$sess_eml);
        }
        
	  
	  if($this->input->post('monthDate'))
      { 
        $year_date = $this->input->post('yearDate');
        $month_date = $this->input->post('monthDate');
        $curndth=$year_date."-".$month_date."-01";
        $a_date = date($curndth);
        $lastday=date("Y-m-t", strtotime($a_date)); 
        $this->db->where('renewal_date >=',$curndth);
        $this->db->where('renewal_date <=',$lastday);
        
      }else if($this->input->post('searchFromDate')){ 
          $search_from_date = $this->input->post('searchFromDate');
          $search_to_date   = $this->input->post('searchToDate');
          $this->db->where('renewal_date >=',$search_from_date);
          $this->db->where('renewal_date <=',$search_to_date);
      }else{
//  	  $year_date = date('Y');
// 	      $month_date = date('m');
// 		  $curndth=$year_date."-".$month_date."-01";
//        $this->db->where('renewal_date >=',$curndth); 
          $curndth=date('Y-m-d',strtotime('+1 month'));
          $this->db->where('renewal_date <=',$curndth);
      }
      
       $this->db->order_by('id','desc');
       $this->db->limit(10, $v);
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
    

    
}
?>