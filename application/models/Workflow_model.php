<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Workflow_model extends CI_Model
{
 
   var $table 		= 'workflow';
  
  var $sort_by 		= array('workflow_name','module','Recurrence','entry_all_con','entry_any_con','description',null);
  var $search_by 	= array('workflow_name','module','Recurrence','entry_all_con','entry_any_con','description');
  var $order 		= array('id' => 'desc');
  
  
  
  /**
  * Check if a workflow exists for the given module and workflow name for the current session company.
  * @example
  * $result = $this->Workflow_model->check_workflows('Sales', 'Invoice Approval');
  * var_dump($result); // sample output: array('id' => 5, 'workflow_name' => 'Invoice Approval', 'module' => 'Sales', 'session_company' => 'Acme Ltd', 'session_comp_email' => 'info@acme.com', ... );
  * @param string $moduleName - Module name to search workflows for.
  * @param string $workFlowName - Workflow name to search for.
  * @returns array|false Return associative array of the workflow row if found, otherwise false.
  */
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
  
  
   /**
    * Build and apply a CodeIgniter query for server-side DataTables: applies company/session filters, optional module filter, column search (from POST['search'] or custom POST field), grouping of LIKE conditions, delete_status filter, and ordering (from POST['order'] or default).
    * @example
    * // Example inside the model before fetching results:
    * // Assume session: company_email='acme@example.com', company_name='ACME'
    * // Assume POST: $_POST['search']['value'] = 'invoice123', $_POST['order'][0]['column'] = 1, $_POST['order'][0]['dir'] = 'desc'
    * $this->_get_datatables_query();
    * $query = $this->db->get(); // returns CI_DB_result object containing the filtered rows
    * // Sample output (conceptual): CI_DB_result with rows matching company and search 'invoice123'
    * @param void $none - This method does not accept parameters; it uses $this->session and $this->input->post()/$_POST directly.
    * @returns void Prepares and modifies $this->db (Query Builder) for subsequent get()/count operations; does not return a value.
    */
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
  
  
  /**
  * Retrieve an active workflow row for the current session company by module and workflow name.
  * @example
  * $result = $this->Workflow_model->get_workflows_byModule('invoices', 'approval');
  * echo print_r($result, true); // render sample output like Array ( [id] => 5 [module] => invoices [workflow_name] => approval [status] => 1 ... )
  * @param {string} $module - Module identifier to filter workflows (e.g., 'invoices').
  * @param {string} $workflow_name - Workflow name to filter workflows (e.g., 'approval').
  * @returns {array|int} Return associative array of the workflow row when found, or 0 if none found.
  */
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
  
    /**
    * Get the workflow trigger setting ('trigger_workflow_on') for a given module and recurrence for the current session company.
    * @example
    * $result = $this->Workflow_model->getStatusModule('Leads', 'weekly');
    * print_r($result); // sample output: Array ( [trigger_workflow_on] => 'on_create' )
    * @param {string} $module - Module name to check (e.g., 'Leads', 'Deals').
    * @param {string} $Recurrence - Recurrence identifier to check (e.g., 'daily', 'weekly', 'monthly').
    * @returns {array|false} Return associative array with 'trigger_workflow_on' when a matching active record exists, otherwise false.
    */
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
  
  
   /**
   * Retrieve licence_detail rows for the given admin ID using the current session company and email.
   * @example
   * $result = $this->Workflow_model->getPlanId(123);
   * print_r($result); // e.g. Array ( [0] => Array ( 'id' => '1', 'admin_id' => '123', 'plan_id' => 'gold', 'session_company' => 'Acme Ltd', 'session_comp_email' => 'admin@acme.com' ) )
   * @param int|string $admin_id - Admin identifier to filter licence records.
   * @returns array|false Return an array of matching database rows if found, otherwise false.
   */
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
  
   /**
    * Retrieve active, non-deleted modules for a given plan (returns module_name and limit_upto).
    * @example
    * $result = $this->Workflow_model->getYourModule(3);
    * // Sample output:
    * // [
    * //   ['module_name' => 'task_management', 'limit_upto' => '10'],
    * //   ['module_name' => 'time_tracking', 'limit_upto' => '5']
    * // ]
    * @param {int} $planid - Plan ID to fetch modules for.
    * @returns {array|false} Returns an array of associative arrays (keys: 'module_name', 'limit_upto') when modules exist, or false if none found.
    */
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
  
  /**
  * Check whether a given module is assigned and active (Paid or Trial) for the current company session.
  * @example
  * $result = $this->Workflow_model->checkModuleForContr('Contractor');
  * echo $result; // e.g. 1
  * @param {string} $madule - Module name to check (matches plan_module.module_name).
  * @returns {int} Number of matching licensed, active module rows (0 if not available).
  */
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