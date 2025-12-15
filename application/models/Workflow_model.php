<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Workflow_model extends CI_Model
{
 
   var $table 		= 'workflow';
  
  var $sort_by 		= array('workflow_name','module','Recurrence','entry_all_con','entry_any_con','description',null);
  var $search_by 	= array('workflow_name','module','Recurrence','entry_all_con','entry_any_con','description');
  var $order 		= array('id' => 'desc');
  
  
  
  public function check_workflows($moduleName,$workFlowName){
	$session_company 	= $this->session->userdata('company_name');
	$session_comp_email = $this->session->userdata('company_email');
	$this->db->select('*');
	$this->db->where('session_company' , $session_company);
	$this->db->where('session_comp_email' , $session_comp_email);
	$this->db->where('workflow_name' , $workFlowName);
	$this->db->where('module' , $moduleName);
	$query = $this->db->get('workflow');
    $this->db->where('delete_status' , 1);
    if($query->num_rows()>0){
        return $query->row_array();
    }else{
        return false;
    }
  }
  
	public function insert_status($arrData){
		$this->db->insert('workflow', $arrData);
		return $this->db->insert_id();
	}

	public function update_status($DataArr,$id){
		$this->db->where('id' , $id);
		$this->db->update('workflow', $DataArr);
	}
  
  
   private function _get_datatables_query()
   {
		$sess_eml           = $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company    = $this->session->userdata('company_name');
    
        $this->db->from($this->table);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
        //$this->db->where('advanced_payment<sub_totals');     
         
      /*if($this->input->post('searchUser'))
      { 
		$this->db->where('sess_eml',$this->input->post('searchUser'));
      }
      
      if($this->input->post('firstDate') < $this->input->post('secondDate')){
          
          $this->db->where('invoice_date >=',$this->input->post('firstDate'));
          $this->db->where('invoice_date <=',$this->input->post('secondDate'));
          
      }else*/ 
	  if($this->input->post('searchModule'))
      { 
        $search_module = $this->input->post('searchModule');
        
        $this->db->where('module',$search_module);
        
      }
	  
      $this->db->where('delete_status',1);
    
    $i = 0;
    foreach ($this->search_by as $item) // loop column
    {  
	      $searchVl=$this->input->post('search');
		 if(isset($_POST['search']['value'])) 
		  {
			$dataSearch=$_POST['search']['value'];  
		  }else{
			  $dataSearch=$searchVl;
		  }
		 
      if(isset($dataSearch)) 
      {
        if($i===0) 
        {
          $this->db->group_start(); 
          $this->db->like($item, $dataSearch);
        }else{
          $this->db->or_like($item, $dataSearch);
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
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }
  
 
   public function create_workflow($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  
  public function update_workflow($workflowId,$data)
  {
	  $this->db->where('id', $workflowId);
      return $query = $this->db->update($this->table,$data);
  }
  
  public function delete_workflow($id)
  {
    $this->db->set('delete_status',2);
    $this->db->where('id', $id);
	return $this->db->update($this->table);
  }
  
   public function get_workflow_byId($workflow_id)
  {
    $this->db->where('id' , $workflow_id);
    $query = $this->db->get($this->table);
	return $query->row_array();
  }
  
  
  public function get_workflows_byModule($module,$workflow_name)
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->where('module' , $module);
    $this->db->where('workflow_name' , $workflow_name);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('status' , 1);
    $this->db->where('delete_status' , 1);
    $query = $this->db->get($this->table);
    if($query->num_rows()>0)
    {
     return $query->row_array();
    }
    else
    {
     return 0;
    }  
  }
  
    public function getStatusModule($module, $Recurrence){
	$session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select('trigger_workflow_on');
    $this->db->where('module' , $module);
    $this->db->where('Recurrence' , $Recurrence);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('status' , 1);
    $this->db->where('delete_status' , 1);
    $query = $this->db->get($this->table);
    if($query->num_rows()>0)
    {
     return $query->row_array();
    }
    else
    {
     return false;
    }   
  }
  
  
   public function getPlanId($admin_id){
      $session_company = $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
      
      // $this->db->where('admin_id' , $admin_id);
      // $this->db->where('session_company',$session_company);
      // $this->db->where('session_comp_email',$session_comp_email);
      // $query = $this->db->get('licence_detail');
      
      $query = $this->db->query("SELECT * FROM `licence_detail` WHERE `admin_id` = '$admin_id' AND `session_company` = '$session_company' AND `session_comp_email` = '$session_comp_email'");
    
      if($query->num_rows()>0)
      {
        return $query->result_array();
      }
      else
      {
        return false;
      }   
  }
  
   public function getYourModule($planid){
    $this->db->select('module_name,limit_upto');
    $this->db->where('plan_id' , $planid);
    $this->db->where('delete_status' , 1);
    $this->db->where('status',1);
    $query = $this->db->get('plan_module');
    if($query->num_rows()>0)
    {
     return $query->result_array();
    }
    else
    {
     return false;
    }   
  }
  
  public function checkModuleForContr($madule){
        $sess_eml           = $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company    = $this->session->userdata('company_name');
		$this->db->from('plan_module');
    $this->db->select('plan_module.id');
    $this->db->join('licence_detail', 'plan_module.plan_id = licence_detail.plan_id');
    $this->db->where('plan_module.module_name' , $madule);
    $this->db->where('licence_detail.session_company' , $session_company);
    $this->db->where('licence_detail.session_comp_email' , $session_comp_email);
    $this->db->where("(account_type='Paid' OR account_type='Trial')", NULL, FALSE);
    $this->db->where('plan_module.delete_status' , 1);
    $this->db->where('plan_module.status',1);
    $query = $this->db->get();
    return $query->num_rows();
  }
  
  
  

// Please Write Code Above This 
  
}