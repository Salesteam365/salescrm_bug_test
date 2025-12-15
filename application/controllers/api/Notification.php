<?php
   
require APPPATH . 'libraries/REST_Controller.php';

class Notification extends REST_Controller {
    
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
        
        $this->db->from('notification');
		$this->db->select('*');
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		
		if($this->session->userdata('type')==='standard')
		{
		 $this->db->where('sess_eml',$sess_eml);
		}
		
		$notiId = $this->input->post('notiId');
		
		if(isset($notiId) && $notiId!=""){
			$this->db->where('id>',$notiId);
		}			
		
		$this->db->limit(50);
		$this->db->order_by('id','desc');
		$this->db->where('notification.seen_status',0);
       
        $data = $this->db->get();
        $quotdata = $data->result_array();
        // if($quotdata->num_rows()>0){
        //     $this->response($quotdata->result_array(), REST_Controller::HTTP_OK);
        // }else{
        //   $this->response(['No data available.'], REST_Controller::HTTP_OK); 
        // }
        
		$arrayData      =  array();
		$jsnData        =  array();
		
		
		foreach($quotdata as $row){
		    if($row['noti_for'] == 'opportunity'){
		    	$urlName = base_url()."opportunities?oppid=".$row['opp_id']."&itm=opportunity&ntid=".$row['id'];
		  //  	$dtRow = $this->Notification_model->getTableData('opportunity','owner,name as subject ',$row['opp_id']);
		    	$this->db->from('opportunity');
        		$this->db->select('owner,name as subject ');
        		$this->db->where('session_comp_email',$session_comp_email);
        		$this->db->where('session_company',$session_company);
        		if($this->session->userdata('type')==='standard')
        		{
        		 $this->db->where('sess_eml',$sess_eml);
        		}
        		$this->db->where('id',$row['opp_id']);
        		$query = $this->db->get();
        		$dtRow = $query->row_array();
			    
			}else if(isset($row['noti_for']) && $row['noti_for']=='quotation'){
				$urlName = base_url().'quotation/view_pi_qt/'.$row['quote_id'].'?itm=quotation&ntid='.$row["id"].'&qr=get-data';
				// $dtRow = $this->Notification_model->getTableData('quote','owner,subject',$row['quote_id']);
				$this->db->from('quote');
        		$this->db->select('owner,subject');
        		$this->db->where('session_comp_email',$session_comp_email);
        		$this->db->where('session_company',$session_company);
        		if($this->session->userdata('type')==='standard')
        		{
        		 $this->db->where('sess_eml',$sess_eml);
        		}
        		$this->db->where('id',$row['quote_id']);
        		$query = $this->db->get();
        		$dtRow = $query->row_array();
        		
			}else if(isset($row['noti_for']) && $row['noti_for']=='salesorders'){
				$urlName=base_url().'salesorders/view_pi_so/'.$row['so_id'].'?itm=salesorders&ntid='.$row["id"].'&qr=get-data';
				// $dtRow = $this->Notification_model->getTableData('salesorder','owner,subject',$row['so_id']);
				$this->db->from('salesorder');
        		$this->db->select('owner,subject');
        		$this->db->where('session_comp_email',$session_comp_email);
        		$this->db->where('session_company',$session_company);
        		if($this->session->userdata('type')==='standard')
        		{
        		 $this->db->where('sess_eml',$sess_eml);
        		}
        		$this->db->where('id',$row['so_id']);
        		$query = $this->db->get();
        		$dtRow = $query->row_array();
        		
			}else if(isset($row['noti_for']) && $row['noti_for']=='purchaseorders'){
				$urlName=base_url().'purchaseorders/view_pi_po/'.$row['po_id'].'?itm=purchaseorders&ntid='.$row["id"].'&qr=get-data';
				// $dtRow = $this->Notification_model->getTableData('purchaseorder','owner,subject',$row['po_id']);
					$this->db->from('purchaseorder');
        		$this->db->select('owner,subject');
        		$this->db->where('session_comp_email',$session_comp_email);
        		$this->db->where('session_company',$session_company);
        		if($this->session->userdata('type')==='standard')
        		{
        		 $this->db->where('sess_eml',$sess_eml);
        		}
        		$this->db->where('id', $row['po_id']);
        		$query = $this->db->get();
        		$dtRow = $query->row_array();
			}
					
				$arrayData['id'] 		= $row['id'];
				$arrayData['url'] 		= $urlName;
				$arrayData['subject'] 	= substr($dtRow['subject'],0,35);
				$arrayData['owner'] 	= ucwords($dtRow['owner']);
				$arrayData['created_date'] 	= time_elapsed_string($row['created_date']);
				$jsnData[]=$arrayData;
			}
			$notdata =  array('notidata'=>$jsnData);
			
		    if(!empty($notdata)){
            $this->response($notdata, REST_Controller::HTTP_OK);
        }else{
          $this->response(['No data available.'], REST_Controller::HTTP_OK); 
        }
	    
	}
	
	public function listcount_post()
    {
        $id                = $this->post('id');
        $sess_eml          = $this->post('sess_eml');
        $session_company   = $this->post('session_company');
        $session_comp_email= $this->post('session_comp_email');
        $org_name          = $this->post('org_name');
        
        $this->db->from('notification');
		$this->db->select('*');
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		if($this->session->userdata('type')==='standard')
		{
		 $this->db->where('sess_eml',$sess_eml);
		}
		$notiId = $this->input->post('notiId');
		if(isset($notiId) && $notiId!=""){
			$this->db->where('id>',$notiId);
		}			
		$this->db->where('notification.seen_status',0);
       
        $data = $this->db->get();
        
        if($data->num_rows()>0){
            $this->response($data->num_rows(), REST_Controller::HTTP_OK);
        }else{
           $this->response(['No data available.'], REST_Controller::HTTP_OK); 
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