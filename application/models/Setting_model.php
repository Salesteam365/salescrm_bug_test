<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_model extends CI_Model
{
  var $table = 'contact';
  var $sort_by = array('meeting_title','host_name','location','from_date',null);
  var $search_by = array('meeting_title','host_name','location','from_date');
  var $order = array('id' => 'desc');
  
  /**
  * Build the active record query for server-side DataTables processing.
  * This private method configures $this->db (FROM, WHERE, LIKE, ORDER BY) based on session user type
  * (admin or standard), optional POST filter 'searchDate', global search value ($_POST['search']['value'])
  * and ordering ($_POST['order']). It does not execute the query — call $this->db->get() after this method.
  * @example
  * // Example usage inside the model
  * $this->_get_datatables_query();
  * $query = $this->db->get(); // execute built query
  * var_export($query->result());
  * // Sample output:
  * // array(0 => (object) ['id' => 1, 'title' => 'Team Meeting', 'sess_eml' => 'user@example.com', 'currentdate' => '2025-12-01', ...])
  * @param void none - This method does not accept parameters; it uses session data and POST input.
  * @returns void No return value; the method modifies the active record query builder ($this->db).
  */
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
  
  /**
  * Prepare datatables query for states: applies base filters (delete_status = 1, country_id = 101), adds searchable WHERE clauses across configured columns, and applies ordering from POST or default configuration.
  * @example
  * // Example usage (simulate datatable POST parameters and execute):
  * $_POST['search']['value'] = 'York';                    // search term
  * $_POST['order'][0]['column'] = 1;                      // column index to sort by
  * $_POST['order'][0]['dir'] = 'desc';                    // sort direction
  * $this->Setting_model->_get_datatables_query_state();   // builds the query on $this->db
  * $query = $this->db->get();                             // execute built query
  * $result = $query->result();                            // sample output: array of state objects matching 'York'
  * print_r($result);
  * @param {void} none - No parameters; method reads $_POST and uses model properties ($search_by_state, $sort_by_state, $order_state).
  * @returns {void} No direct return; configures the CI query builder ($this->db) for subsequent get() calls.
  */
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
  
  /**
  * Build a CodeIgniter DB query for the tasks datatable according to session type, company context and POST filters.
  * @example
  * // Example (inside controller/model before executing the query):
  * $this->session->set_userdata([
  *   'email' => 'user@example.com',
  *   'company_email' => 'comp@example.com',
  *   'company_name' => 'Acme Corp',
  *   'type' => 'standard' // or 'admin'
  * ]);
  * // Simulate DataTables / filter input:
  * $_POST['search']['value'] = 'keyword';
  * $_POST['order']['0']['column'] = 1;
  * $_POST['order']['0']['dir'] = 'asc';
  * $this->input->post('searchDate'); // e.g. '2025-01-01' or 'This Week'
  * $this->input->post('tstStatus'); // e.g. 'active' or 'deactive'
  *
  * // Prepare the query:
  * $this->setting_model->_get_datatables_query_tsk();
  * // Execute and fetch results:
  * $rows = $this->db->get()->result();
  * // Sample returned row:
  * // (object) ['id' => 10, 'title' => 'Follow up', 'status' => 1, 'currentdate' => '2025-01-02', ...]
  * @param void $none - No direct parameters; method uses session data and POST input to build the query.
  * @returns void Prepares the CI query builder (active record) state for fetching filtered, searched and ordered task rows.
  */
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
  
  
  
 /**
 * Retrieve a single opportunity task by its ID, scoped to the current session company.
 * @example
 * $result = $this->Setting_model->get_by_id_task(42, 'view');
 * print_r($result); // sample output: Array ( [id] => 42 [title] => "Call client" [session_comp_email] => "org@example.com" ... )
 * @param int|string $id - ID of the task to fetch.
 * @param string $view - Optional flag; if non-empty returns an associative array, otherwise returns an object.
 * @returns array|object|null Return associative array when $view is non-empty, object when $view is empty, or null if no record is found.
 */
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
  
  /**
   * Retrieve all tasks formatted for a calendar for the current session company.
   * @example
   * $this->load->model('Setting_model');
   * $result = $this->Setting_model->getAllTaskCal();
   * print_r($result); // render sample output
   * // Sample output:
   * // [
   * //   (object) ['title' => 'Call with client', 'description' => 'Discuss contract details', 'start' => '2025-01-10', 'end' => '2025-01-10'],
   * //   (object) ['title' => 'Project kickoff', 'description' => 'Initial meeting with team', 'start' => '2025-01-15', 'end' => '2025-01-15']
   * // ]
   * @returns array Array of stdClass objects, each containing title, description, start and end values.
   */
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
  
  /**
   * Get tasks that should trigger reminder emails (due on or before today, reminder enabled and repeating).
   * @example
   * $this->load->model('Setting_model');
   * $result = $this->Setting_model->getTaskForMail();
   * print_r($result); // Example output: Array ( [0] => stdClass Object ( [task_id] => 123 [task_due_date] => "2025-12-17" [status] => 1 [task_reminder] => 1 [task_repeat] => 1 ) )
   * @returns array Array of stdClass objects representing tasks that are due on or before today, have task_reminder = 1 and task_repeat = 1 (statuses other than 0 or 2).
   */
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
  
  
  
  
  
   /**
   * Fetch opportunity by ID constrained to the current session company (company_email and company_name).
   * @example
   * $result = $this->Setting_model->get_by_id_opp(42);
   * echo $result->name; // "Sales Opportunity A"
   * echo $result->org_name; // "Acme Corp"
   * @param {int|string} $id - Opportunity ID to look up.
   * @returns {object|null} Returns an object with properties 'name' and 'org_name' when found, otherwise null.
   */
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
  
  /**
  * Build and prepare the Active Record query used by DataTables for the "create_call" table.
  * Sets FROM, WHERE, LIKE (search across columns) and ORDER BY clauses based on session data,
  * POST filters (searchDate, search value, order) and the model's configuration properties.
  * The method modifies $this->db (CodeIgniter query builder) but does not execute the query.
  * @example
  * // Typical (internal) usage inside the model:
  * $this->_get_datatables_query_call();
  * $query = $this->db->get(); // execute and fetch results afterwards
  *
  * // Example scenario with sample values:
  * // session type = 'standard', session email = 'user@example.com',
  * // session_comp_email = 'comp@example.com', session_company = 'Acme Inc.'
  * // POST['searchDate'] = '2025-01-01', $_POST['search']['value'] = 'Acme', $_POST['order'][0]['column'] = 2, $_POST['order'][0]['dir'] = 'desc'
  * // Resulting query will include:
  * // WHERE sess_eml = 'user@example.com' AND session_comp_email = 'comp@example.com'
  * // AND session_company = 'Acme Inc.' AND currentdate >= '2025-01-01' AND delete_status = 1
  * // AND (col1 LIKE '%Acme%' OR col2 LIKE '%Acme%' ...) ORDER BY <column_for_index_2> DESC
  * @returns {void} Modifies the model's $this->db query builder; no direct return value.
  */
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
  
  /**
   * Build and apply a CodeIgniter active record query for GST datatables based on current session, role, filters and POSTed search/order parameters.
   * @example
   * // Within a controller/model context where $this refers to the model instance:
   * $this->session->set_userdata([
   *   'email' => 'user@example.com',
   *   'company_email' => 'comp@example.com',
   *   'company_name' => 'Acme Corp',
   *   'type' => 'admin' // or 'standard'
   * ]);
   * // Example POST inputs:
   * $_POST['search'] = ['value' => 'GSTIN123'];
   * $_POST['order'] = [['0' => ['column' => 1, 'dir' => 'asc']]];
   * $_POST['searchDate'] = 'This Week'; // or '2025-01-01'
   * // Call (private method; typically invoked inside the model)
   * $this->_get_datatables_query_gst();
   * // After this call, $this->db will have FROM 'gst', appropriate WHERE/LIKE/ORDER BY clauses applied.
   * @returns void Applies query clauses to $this->db (no direct return value).
   */
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
  
  
  
  
    /**
    * Retrieve the latest non-empty value of a given column for the current session company.
    * @example
    * $result = $this->Setting_model->getallid('company_settings', 'company_id');
    * echo $result['company_id']; // render some sample output value, e.g. 123
    * @param {string} $table - Name of the database table to query.
    * @param {string} $getid - Column name whose latest non-empty value should be returned.
    * @returns {array} Associative array of the first matching row (selected column), or an empty array if none found.
    */
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
  
  
   /**
   * Retrieve the stored prefix_id for a given module for the current session company.
   * @example
   * $result = $this->Setting_model->getprefixID('invoice');
   * print_r($result); // sample output: Array ( [prefix_id] => "INV-2025" )
   * @param {string} $module - Module name to look up the prefix for (e.g. 'invoice').
   * @returns {array|null} Associative array containing 'prefix_id' on success, or null/empty if not found.
   */
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
  

  /**
  * Check if a prefix record exists for a given module (table) within the current company session.
  * @example
  * $result = $this->Setting_model->checkExistPrefix('invoice','INV');
  * print_r($result); // Example output: Array ( [id] => 5 )
  * @param {{string}} $tablename - Module/table name to look up (e.g. 'invoice').
  * @param {{string}} $prefixid - Prefix identifier to check (e.g. 'INV') - currently unused in the query.
  * @returns {{array}} Return an associative array of the matched prefix row (e.g. ['id' => 5]) or an empty array if not found.
  */
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
