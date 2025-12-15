<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 class Activities_model extends CI_Model
 {
  public function get_all_org($currDate,$fltr)
    {
		$session_comp_email = $this->session->userdata('company_email');
		$sess_eml = $this->session->userdata('email');
		$session_company = $this->session->userdata('company_name');
		$type = $this->session->userdata('type');
		
       if($type == "admin")
        {
		  $this->db->select('count("org_name") as total_org');
		  $this->db->from('organization');
		  $this->db->where('session_company', $session_company);
		  $this->db->where('session_comp_email', $session_comp_email);
		  $this->db->where('delete_status', 1);
		  if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
          $query = $this->db->get();
          if($query-> num_rows() > 0)
          {
            return $query->row_array();
          }
          else 
          {
            return false;
          }
	    }
	}
	
   ////////////To get count of Organization ends //////////////
   
   //////////// To get count of Leads starts //////////
   
    public function get_leads_status($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("name") as total_leads');
      $this->db->from('lead');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	      if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
  }
   public function leads_status($currentdate='',$leadStatus='',$fltr)
   {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    
	
	 if($fltr=='filter'){
		$this->db->where('currentdate >=',$currentdate);
	 }else{
		$this->db->where('currentdate',$currentdate);
	 }
		  
	if($leadStatus!=''){
		$this->db->where('lead_status',$leadStatus);
	}
		
		$this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_comp_email);
		$query =$this->db->get('lead');
		$this->db->where('delete_status',1);
		return $query->result_array();
   }
   //////////////////////////////////////////////////////////////// To get count of Leads ends /////////////////////////////////////////////////////
   
   //////////////////////////////////////////////////////////////// To get count of Opportunities starts ///////////////////////////////////////////
   public function get_opp_stage($currDate,$fltr)
   {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("name") as total_opp');
      $this->db->from('opportunity');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
	  if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
   }
   public function opport_status($currentdate='', $oppStatus='',$fltr)
   {
		
		$session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
		
		if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }	
  	    $this->db->where('stage',$oppStatus);	
  	    $this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_comp_email);
	
		$query =$this->db->get('opportunity');
		$this->db->where('delete_status',1);
		return $query->result_array();
   }
   ////////////////////////////////////////////// To get count of Opportunities ends//////// //////////////////////////////////////////////
   
   ////////////////////////////////////////////////////////////// To get count of Quoatation starts ///////////////////////////////////////////////
   public function get_quote_stage($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("subject") as total_quotes,quote_stage');
      $this->db->from('quote');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
	  if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }  
  }
  public function quote_status($currentdate='',$qtStatus='',$fltr)
  {
   
   	    $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        
		if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }	
	    $this->db->where('quote_stage',$qtStatus);
        $this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_comp_email);
    	$query =$this->db->get('quote');
    	$this->db->where('delete_status',1);
         return $query->result_array();
  }
 ////////////////////////////////////////////////////////////// To get count of Quoatation end /////////////////////////////////////////////
  
  
  ////////////////////////////////////////////////////////////// To get count of Sales starts ///////////////////////////////////////////////
   public function get_sales_stage($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("status") as total_sales');
      $this->db->from('salesorder');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
	 if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
  }
  
   public function sales_status($currentdate='', $pending='',$fltr)
    {
        $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
		if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }	
		$this->db->where('total_percent',$pending);
	    $this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_company);
        $query = $this->db->get('salesorder');
	    return $query->result_array();
    } 
    
    /////////  To get count of Sales end //// /////
   
   ///////// /// To get count of Purchaseorders starts /////// /////
   
   public function get_purchase($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("subject") as total_purch');
      $this->db->from('purchaseorder');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status',1);
	  if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query->num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
    
  } ////////////////////////////////////////////////////////////// To get count of Purchaseorders end /////////////////////////////////////////////
  
  ////////////////////////////////////////////////////////////// To get count of Task starts ///////////////////////////////////////////////
   public function get_task($currDate,$fltr)
   {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("task_subject") as total_task');
      $this->db->from('opp_task');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	   if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
      {
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    } 
  } 
  
  
  
   public function task_status($currentdate='',$duedate='',$fltr)
   {
        $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
			
	 
	 if($duedate!='' && $duedate=='todaydue'){
		$this->db->where('task_due_date',$currentdate);
	 }else if($duedate!='' && $duedate=='tomarrowdue'){
	     $date = strtotime("+1 day", strtotime($currentdate));
        $newData= date("Y-m-d", $date);
		$this->db->where('task_due_date',$newData);
	 }else{
	    if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }
	    $this->db->where('status',$duedate); 
	 }
	  $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $query = $this->db->get('opp_task');
	  $this->db->where('delete_status',1);
	  return $query->result_array();  
   }
   
   
  ////////////////////////////////////////////////////////////// To get count of Task end /////////////////////////////////////////////
  
  ////////////////////////////////////////////////////////////// To get count of Meeting get_call starts ///////////////////////////////////////////////
   public function get_meeting($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("meeting_title") as total_meeting');
      $this->db->from('meeting');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	  if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
    
    
   
    public function meeting_status($currentdate='',$duedate='',$fltr)
    {
        $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
			
	 
	 if($duedate!='' && $duedate=='todayMetting'){
		$this->db->where('from_date',$currentdate);
	 }else if($duedate!='' && $duedate=='tomarroeMetting'){
	     $date = strtotime("+1 day", strtotime($currentdate));
        $newData= date("Y-m-d", $date);
		$this->db->where('from_date',$newData);
	 }else{
	    if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }
	    $this->db->where('status',$duedate); 
	 }
	  $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $query = $this->db->get('meeting');
	  $this->db->where('delete_status',1);
	  return $query->result_array();  
   }
   
   
   
	 //////////////////////////////////////
	 /// To get count of call end//////// /////////////////////////////////////
  ////////////////////////////////////////////////////////////// To get count of  Call starts ///////////////////////////////////////////////
   public function get_call($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("call_purpose") as total_call');
      $this->db->from('create_call');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	   if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
	public function call_status($currentdate='',$prospecting='',$fltr)
     {
      if($fltr=='filter'){
		    $this->db->where('currentdate >=',$currentdate);
    	 }else{
    		$this->db->where('currentdate',$currentdate);
    	 }
    	 
	 if($prospecting!=''){
		$this->db->where('status',$prospecting);
	 }
	 
	  $this->db->where('delete_status',1);
      $query = $this->db->get('create_call');
	  return $query->result_array(); 
   }
     ///////////////////////////////////////////////////////////
	 /// To get count of call end /////////////////////////////////////////////
	 
	 ////////////////////////////////////////////////////////////// To get count of  Vendors starts ///////////////////////////////////////////////
   public function get_vendors($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("name") as total_vendors');
      $this->db->from('vendor');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	  if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
     ////////////////////////////////////////////////////////////// To get count of Vendors end /////////////////////////////////////////////
	 
	 ////////////////////////////////////////////////////////////// To get count of  Proforma invoice starts ///////////////////////////////////////////////
   public function get_proforma($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("page_name") as total_pi');
      $this->db->from('performa_invoice');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	  if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
    
    
    ///////// To get count of Proforma invoice end ///////////
    
    
    ///////////// To get count of  Roles starts //////////////
   public function get_roles($currDate,$fltr)
    {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      $this->db->select('count("role_name") as total_roles');
      $this->db->from('roles');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
	  if($fltr=='filter'){
		      $this->db->where('currentdate >=',$currDate);
		  }else{
		    $this->db->where('currentdate',$currDate);
		  }
      $query = $this->db->get();
      if($query-> num_rows() > 0)
        return $query->row_array();
      }
      else 
      {
        return false;
      }
    }
    
    
    
   public function roles_status($currentdate='',$rolename='')
   {
      if($currentdate!=''){
		$this->db->where('currentdate',$currentdate);	
	   }
	 if($rolename!=''){
		$this->db->where('role_name','Role name');
	  }
      $query = $this->db->get('roles');
	  $this->db->where('delete_status',1);
	  return $query->result_array();  
     }
	 ////////////////////////////////////////////////////////////// To get count of Roles end /////////////////////////////////////////////
	 
	public function get_by_id()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('organization');
		return $query->result_array();
    }
	public function get_by_leads()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('lead');
		return $query->result_array();
    }
	public function lead_status($lead_id,$status)
      {
		$this->db->set('lead_status',$status);
		$this->db->where('lead_id', $lead_id);
		$query = $this->db->get('lead');
		return $query->result_array();
     }
	public function get_by_opport()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('opportunity');
		return $query->result_array();
    }
	public function get_by_quotat()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('quote');
		return $query->result_array();
     }
	 public function get_by_sales()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('salesorder');
		return $query->result_array();
     }
	 public function get_by_task()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('opp_task');
		return $query->result_array();
     } 
	 public function get_by_meeting()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('meeting');
		return $query->result_array();
     }
	 public function get_by_call()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('create_call');
		return $query->result_array();
     }
	 public function get_by_purch()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('purchaseorder');
		return $query->result_array();
     }
	 public function get_by_vendors()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('vendor');
		return $query->result_array();
     }
	 public function get_by_proforma()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('performa_invoice');
		return $query->result_array();
     }
	 public function get_by_roles()
     {
		$this->db->where('currentdate',date('Y-m-d'));
		$query = $this->db->get('roles');
		return $query->result_array();
     }
	 ///////Select Date Start///////
	 /////////////////////

	private function _get_datatables_query()
     {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')==='admin')
    {
      $this->db->from('organization');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('currentdate >=',$search_date);
        }
      }
      $this->db->where('delete_status',1);
    }
    elseif($this->session->userdata('type')==='standard')
    {
      $this->db->from('organization');
      $this->db->where('sess_eml',$sess_eml);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('currentdate >=',$search_date);
        }
      }
      $this->db->where('delete_status',1);
    }
    $i = 0;
    foreach ($this->search_by as $item) // loop column
    {
      if($_POST['search']['value']) // if datatable send POST for search
      {
        if($i===0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
          $this->db->or_like($item, $_POST['search']['value']);
        }
        if(count($this->search_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->order))
    {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
 }
?>