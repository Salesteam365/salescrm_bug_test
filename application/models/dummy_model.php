<?php 

Class dummy_model extends CI_Model{
    /**
    * Fetch a user record from the "users" table by ID, optionally filtering by email.
    * @example
    * $result = $this->dummy_model->fetch_Data(42, 'jane.doe@example.com');
    * print_r($result); // Array ( [id] => 42 [email] => 'jane.doe@example.com' [name] => 'Jane Doe' )
    * @param {int|string} $id - User ID to fetch.
    * @param {string} $email - Optional email to further filter the user; defaults to an empty string.
    * @returns {array|false} Returns an associative array of the user row when found, or false if no matching record exists.
    */
    public function fetch_Data($id, $email = ''){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        if (!empty($email)) {
            $this->db->where('email', $email);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $Query->row_array();
        }else{
            return false;
        }   
    }

    /**
    * Insert a new record into the 'user' table and return the inserted record ID or false on failure.
    * @example
    * $sample_data = ['username' => 'alice', 'email' => 'alice@example.com'];
    * $result = $this->dummy_model->insert_Data($sample_data);
    * echo $result // 42 or false;
    * @param {array} $data - Associative array of column => value pairs to insert into the 'user' table.
    * @returns {int|false} Insert ID on success, or false on failure or when $data is empty.
    */
    public function insert_Data($data){
        if (!empty($data)) {
            $this->db->insert('user', $data);
            $id = $query->insert_id();
           if ($id) {
                return $id;
           }else{
            return false;
           }
        }else{
            return false;
        }  
    }

    public function Delete_data($id){
        $this->db->where('id', $id);
        $this->db->delete('user');
        if ($this->db->affected_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function update_data($id, $email, $data){
        $this->db->where('id', $id);
        $this->db->where('email', $email);
        $this->db->update('user', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }else{
            return false;
        }

    }


    public function fetch_multiple_tbl_data($id){
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('id', $id);
            $tbl_data = $this->db->get();
            return $tbl_data;  
        }else{
            return false;
        } 
    }


    


public function get_datatables(){
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
}


    var $table = 'salesorder';
  var $sort_by = array(null,'subject','org_name','saleorder_id','owner','status','approved_by','datetime',null);
  var $search_by = array('subject','org_name','saleorder_id','owner','status','approved_by','datetime');
  var $order = array('id' => 'desc');
  
  /**
  * Build the Active Record/Query Builder for server-side DataTables (applies filters, search, date range, ordering and optional sum selection).
  * @example
  * // from inside the model (private method), example usage:
  * $this->_get_datatables_query('sum');
  * $query = $this->db->get();
  * echo $query->num_rows(); // e.g. 10
  * @param {string} $action - Optional action flag (default ''). If non-empty the query will select SUM(sub_totals) (example values: 'sum', 'export').
  * @returns {void} No direct return; the method modifies $this->db query builder state.
  */
  private function _get_datatables_query($action='')
  {
	$sess_eml = $this->session->userdata('email');
    if($action!=""){
      $this->db->select_sum('sub_totals');
    }

	$this->db->from($this->table);

	
    if($this->input->post('searchUser'))
    { 
        $searchUser = $this->input->post('searchUser');
		$this->db->where('sess_eml',$searchUser);  
    } 
   

    if($this->input->post('fromDate') && $this->input->post('toDate')){
            $this->db->where('currentdate >=',$this->input->post('fromDate'));
            $this->db->where('currentdate <=',$this->input->post('toDate'));
      }else if($this->input->post('searchDate')){ 
          $search_date = $this->input->post('searchDate');
          if($search_date == "This Week")
          {
            $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
          }else{
            $this->db->where('currentdate >=',$search_date);
          }
      }
      
      $this->db->where('delete_status',1);
    
      $i = 0;
      foreach ($this->search_by as $item)
      {
      $search_data='';
      if(isset($_POST['search']['value']) && $_POST['search']['value']!=""){
        $search_data=$_POST['search']['value'];
      }else if($this->input->post('search_data')){
        $search_data=$this->input->post('search_data');
      }
      if(isset($search_data) && $search_data!="" ) 
      {
        if($i===0)
        {
          $this->db->group_start(); 
          $this->db->like($item, $search_data);
        }
        else
        {
          $this->db->or_like($item, $search_data);
        }
        if(count($this->search_by) - 1 == $i) 
          $this->db->group_end(); 
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