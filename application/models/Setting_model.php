<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_model extends CI_Model
{
  var $table = 'contact';
  var $sort_by = array('meeting_title','host_name','location','from_date',null);
  var $search_by = array('meeting_title','host_name','location','from_date');
  var $order = array('id' => 'desc');
  
  private function _get_datatables_query()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
    if($this->session->userdata('type')==='admin')
    {
      $this->db->from('meeting');
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
      $this->db->from('meeting');
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
  public function get_datatables()
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all()
  {
    $this->db->from('meeting');
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    return $this->db->count_all_results();
  }
  
  
  public function getbyid_meeting($id)
  {
    $this->db->from('meeting');
    $this->db->where('id',$id);
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get();
    return $query->row();
  }
  
  
  public function updateMeeting($dataArr, $id)
  {
      $this->db->where('id',$id);
      $this->db->update('meeting',$dataArr);
      return $this->db->affected_rows();
  }
  
  public function addMeeting($dataArr)
  {     
      $this->db->insert('meeting',$dataArr);
      return $this->db->insert_id();
  }
  
  
  
  public function AddFbData($dataArr)
  {     
      $this->db->insert('fb_app_detail',$dataArr);
      return $this->db->insert_id();
  }
  
  public function UpdateFbData($dataArr,$formId){
      $this->db->where('fb_form_id',$formId);
      $this->db->update('fb_app_detail',$dataArr);
      return $this->db->affected_rows();
  }
  
  public function checkExistFbApp($formId,$token=''){
    $this->db->from('fb_app_detail');
    $this->db->where('fb_form_id',$formId);
    if($token!=""){
    $this->db->where('fb_access_token',$token);
    }
    
    $query = $this->db->get();
    return $query->row();
  }
  
  
  // End COde For Meeting
  
  
  
  // START CODE FOR STATE LIST
  var $sort_by_state = array(null,'name','tin','country_id');
  var $search_by_state = array('name','tin','country_id');
  var $order_state = array('name' => 'asc');
  
  private function _get_datatables_query_state()
  {
    
    
      $this->db->from('states');
      $this->db->where('delete_status',1);
      $this->db->where('country_id',101);
   
   
    $i = 0;
    foreach ($this->search_by_state as $item) // loop column
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
        if(count($this->search_by_state) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->sort_by_state[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->order_state))
    {
      $order = $this->order_state;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
  public function get_datatables_state()
  {
    $this->_get_datatables_query_state();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered_state()
  {
    $this->_get_datatables_query_state();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all_state()
  {
    $this->db->from('opp_task');
    return $this->db->count_all_results();
  }
  
  // END CODE STATE LIST
  
  
  
  
  
  /*   Start Code For Task*/
  
  
  
  var $sort_by_tsk = array('task_subject','task_owner','task_priority','task_due_date',null);
  var $search_by_tsk = array('task_subject','task_owner','task_priority','task_due_date');
  var $order_tsk = array('task_due_date' => 'asc');
  
  private function _get_datatables_query_tsk()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
    if($this->session->userdata('type')==='admin')
    {
      $this->db->from('opp_task');
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
      if($this->input->post('tstStatus'))
      { 
        $search_status = $this->input->post('tstStatus');
        $this->db->where('status',$search_status);
      }
      
      $this->db->where('delete_status',1);
    }
    elseif($this->session->userdata('type')==='standard')
    {
      $this->db->from('opp_task');
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
      if($this->input->post('tstStatus'))
      { 
        $search_status = $this->input->post('tstStatus');
        if($search_status=="deactive"){
                $this->db->where('status',0);
        }else{
             $this->db->where('status',$search_status);
        }
      }
      $this->db->where('delete_status',1);
    }
    $i = 0;
    foreach ($this->search_by_tsk as $item) // loop column
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
        if(count($this->search_by_tsk) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->sort_by_tsk[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->order_tsk))
    {
      $order = $this->order_tsk;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
  public function get_datatables_tsk()
  {
    $this->_get_datatables_query_tsk();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered_tsk()
  {
    $this->_get_datatables_query_tsk();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all_tsk()
  {
    $this->db->from('opp_task');
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    return $this->db->count_all_results();
  }
  
  
  
 public function get_by_id_task($id,$view='')
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');  
    $this->db->from('opp_task');
    $this->db->where('id',$id);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get();
	if($view!=""){
		return $query->row_array();
	}else{
		return $query->row();
	}
  }
  
  public function UpdateTask($dataArr, $id)
  {
      $this->db->where('id',$id);
      $this->db->update('opp_task',$dataArr);
      return $this->db->affected_rows();
  }
  
  public function getAllTask()
  {
    $this->db->select('task_subject as title, task_from_date as start, task_due_date as end');
    $this->db->from('opp_task');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get();
    return $query->result();
  }
  
  public function getAllTaskCal()
  {
      
     
      
      
      
    $this->db->select('task_subject as title, remarks as description, task_from_date as start, task_due_date as end');
    $this->db->from('opp_task');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get();
    return $query->result();
  }
  
  
  
  
  
  public function addTask($dataArr)
  {
      $this->db->insert('opp_task',$dataArr);
      return $this->db->insert_id();
  }
  
  public function getTaskForMail()
  {
      
    $this->db->from('opp_task');
    
    /*  
	
     // $session_comp_email = $this->session->userdata('company_email');
    //  $session_company    = $this->session->userdata('company_name');
    \\  $this->db->where('session_comp_email',$session_comp_email);
     \\ $this->db->where('session_company',$session_company);
	
    */
     
    $this->db->where('task_due_date <=',date('Y-m-d'));
    $this->db->where('status<>',2);
    $this->db->where('status<>',0);
    $this->db->where('task_reminder',1);
    $this->db->where('task_repeat',1);
    $query = $this->db->get();
    return $query->result();
  }  
  
  
  
  
  
   public function get_by_id_opp($id)
  {
    $this->db->select('name,org_name');  
    $this->db->from('opportunity');
    $this->db->where('id',$id);
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get();
    return $query->row();
  }
  
  
  
  
  /*  END CODE FOR TASK*/
  
  
  
   /*  START CODE FOR CALL*/ 
  
  var $sort_by_call = array('call_subject','contact_name','call_purpose','related_to',null);
  var $search_by_call = array('call_subject','contact_name','call_purpose','related_to');
  var $order_call = array('id' => 'desc');
  
  private function _get_datatables_query_call()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
    if($this->session->userdata('type')==='admin')
    {
      $this->db->from('create_call');
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
      $this->db->from('create_call');
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
    foreach ($this->search_by_call as $item) // loop column
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
        if(count($this->search_by_call) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->sort_by_call[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->order_call))
    {
      $order = $this->order_call;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
  public function get_datatables_call()
  {
    $this->_get_datatables_query_call();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered_call()
  {
    $this->_get_datatables_query_call();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all_call()
  {
    $this->db->from('create_call');
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    return $this->db->count_all_results();
  }
  
  
  public function getbyid_Call($id)
  {
    $this->db->from('create_call');
    $this->db->where('id',$id);
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get();
    return $query->row();
  }
  
  
  public function updateCall($dataArr, $id)
  {
      $this->db->where('id',$id);
      $this->db->update('create_call',$dataArr);
      return $this->db->affected_rows();
  }
  
  public function addCall($dataArr)
  {
    $this->db->insert('create_call',$dataArr);
    return $this->db->insert_id();
  }
 
 
 /*********Start Code For GST***********/
  
   var $sort_by_gst = array('tax_name','description','collection_of_sale','collection_of_purchases','gst_percentage',null);
   var $search_by_gst = array('tax_name','description','collection_of_sale','collection_of_purchases','gst_percentage');
   var $order_gst = array('id' => 'desc');
  
  private function _get_datatables_query_gst()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    
    if($this->session->userdata('type')==='admin')
    {
      $this->db->from('gst');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('create_date >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('create_date >=',$search_date);
        }
        
        
      }
      $this->db->where('delete_status',1);
    }
    elseif($this->session->userdata('type')==='standard')
    {
      $this->db->from('gst');
      $this->db->where('sess_eml',$sess_eml);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('create_date >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('create_date >=',$search_date);
        }
        
        
      }
      $this->db->where('delete_status',1);
    }
    $i = 0;
    foreach ($this->search_by_gst as $item) // loop column
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
        if(count($this->search_by_gst) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->sort_by_gst[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->order_gst))
    {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
  public function get_datatables_gst()
  {
    $this->_get_datatables_query_gst();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered_gst()
  {
    $this->_get_datatables_query_gst();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all_gst()
  {
    $this->db->from('gst');
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    return $this->db->count_all_results();
  }
  
  
  public function getbyid_gst($id)
  {
    $this->db->from('gst');
    $this->db->where('id',$id);
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get();
    return $query->row();
  }
  
  
  public function updategst($dataArr, $id)
  {
      $this->db->where('id',$id);
      return $this->db->update('gst',$dataArr);
      //return $this->db->affected_rows();
  }
  
  public function addgst($dataArr)
  {     
      $this->db->insert('gst',$dataArr);
      return $this->db->insert_id();
  }
  

  /*  END CODE FOR GST*/
  
  
  
  
    public function getallid($table,$getid)
  {
    $this->db->from($table);
    $this->db->select($getid);
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where($getid."<>","");
    $this->db->order_by('id',"desc");
    $query = $this->db->get();
    return $query->row_array();
  } 
    public function coutdata($table)
  {
    $this->db->from("`".$table."`");
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get();
    return $query->num_rows();
  } 
  
  
   public function getprefixID($module)
  {
    $this->db->from('prefix_id');
    $this->db->select('prefix_id');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('module',$module);
    $query = $this->db->get();
    return $query->row_array();
  } 
  
  
  public function dataDetail($table,$tid)
  {
    $this->db->from("`".$table."`");
    $this->db->select('session_company, session_comp_email');
	$this->db->where('id',$tid);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  public function coutdataForApi($table,$session_company, $session_comp_email)
  {
    $this->db->from("`".$table."`");
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get();
    return $query->num_rows();
  } 
  
  public function getprefixIDForapi($module,$session_company, $session_comp_email)
  {
    $this->db->from('prefix_id');
    $this->db->select('prefix_id');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('module',$module);
    $query = $this->db->get();
    return $query->row_array();
  }
  

  public function checkExistPrefix($tablename,$prefixid)
  {
    $this->db->from('prefix_id');
    $this->db->select('id');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('module',$tablename);
    //$this->db->where('prefix_id',$prefixid);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  public function updateprefixData($dataArr,$id){
	  $this->db->where('id',$id);
      $this->db->update('prefix_id',$dataArr);
      return $this->db->affected_rows();
  }
  
  
   public function saveprefixData($dataArr){
	   $this->db->insert('prefix_id',$dataArr);
      return $this->db->insert_id();  
   }

	public function update_id($arraData,$id,$table){
	  $this->db->where('id',$id);
      $this->db->update($table,$arraData);
      return $this->db->affected_rows();	
	}




// Please write code above this  
}
?>
