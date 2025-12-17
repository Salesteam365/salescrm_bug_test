<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Base_model extends CI_Model
{

  var $table 		= 'creditnote';
  var $sort_by 		= array('creditnote_no','org_name','owner','sub_total','pi_status','creditnote_date',null);
  var $search_by 	= array('creditnote_no','org_name','owner', 'sub_total','pi_status','creditnote_date');
  var $order 		= array('id' => 'desc');


    /**
    * Get rows selected from a table with an optional where clause; returns the query result or 0 if no rows.
    * @example
    * $result = $this->Base_model->getlast_id('id', 'users', array('status' => 'active'));
    * if ($result !== 0) {
    *     echo $result->num_rows(); // e.g. 3
    * } else {
    *     echo 0; // no rows found
    * }
    * @param {string} $sel - Columns to select (e.g. 'id' or 'id, name').
    * @param {string} $tbl - Table name (e.g. 'users').
    * @param {array|string|null} $where - Optional WHERE clause as associative array or SQL string (e.g. array('status' => 'active')).
    * @returns {CI_DB_result|int} Return CI_DB_result when rows found, otherwise 0.
    */
    public function getlast_id($sel, $tbl, $where = NULL) {
        $this->db->select($sel);
        $this->db->from($tbl);
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query= $this->db->get();
        if($query->num_rows() >0 ){
            return $query;
        }
        else{
            return 0;
        }
    }

    /**
    * Insert a row into a database table if the provided invoice_id is present and not already stored.
    * @example
    * $data = ['invoice_id' => 123, 'customer' => 'ACME Corp', 'amount' => 500.00];
    * $result = $this->Base_model->insertdata('invoices', $data);
    * echo $result; // 1 (success) or 0 (missing/existing invoice_id) or 2 (insert failure)
    * @param string $tbl - Table name to insert the data into.
    * @param array $data - Associative array of column => value. Must include 'invoice_id'.
    * @returns int Return code: 0 = missing invoice_id or a row with the same invoice_id and delete_status = 1 already exists, 1 = insert succeeded, 2 = insert failed.
    */
    public function insertdata($tbl,$data){

        if (!isset($data['invoice_id'])) {
            return 0;
        }

        $existingData = $this->db->get_where($tbl, array('invoice_id' => $data['invoice_id'],'delete_status'=>1));
            if ($existingData->num_rows() > 0) {
                // Data already exists, return 0 indicating failure
                return 0;
            }
            
        $query=$this->db->insert($tbl,$data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }
        
    }

    /**
     * Build and apply the ActiveRecord query used for DataTables list retrieval.
     * 
     * This method composes a CodeIgniter query on $this->db using session values and POST inputs:
     * - Applies company/session constraints (company_email, company_name) and delete_status = 1
     * - Optional date filters: firstDate/secondDate range or searchDate (e.g. "This Week" or a specific date)
     * - Optional user filter via searchUser
     * - Restricts results for standard users without create_po permission to the current session email
     * - Applies global search across configured $this->search_by columns
     * - Applies ordering from POST['order'] or the model default $this->order
     * 
     * The method does not execute the query; it only modifies $this->db (ActiveRecord) so the caller
     * should call $this->db->get() afterwards to fetch results.
     *
     * @example
     * // Typical internal usage inside the model before executing the query:
     * $this->_get_datatables_query();
     * $query = $this->db->get(); // fetch results
     *
     * // Example POST/session values that influence the generated query:
     * // $_POST['firstDate'] = '2025-01-01';
     * // $_POST['secondDate'] = '2025-01-31';
     * // $_POST['searchDate'] = 'This Week' OR '2025-01-10';
     * // $_POST['searchUser'] = 'user@example.com';
     * // $_POST['search']['value'] = 'Acme';
     * // $_POST['order'][0]['column'] = 1;
     * // $_POST['order'][0]['dir'] = 'desc';
     * // $this->session->set_userdata(['email'=>'me@company.com','company_email'=>'co@org','company_name'=>'MyCo']);
     *
     * @param void - This method does not accept parameters; it reads input from $this->input and $this->session.
     * @returns void Modifies $this->db query builder; no direct return value.
     */
    private function _get_datatables_query()
    {
        
          $sess_eml           = $this->session->userdata('email');
          $session_comp_email = $this->session->userdata('company_email');
          $session_company    = $this->session->userdata('company_name');
      
          $this->db->from($this->table);
          $this->db->where('session_comp_email',$session_comp_email);
          $this->db->where('session_company',$session_company);

        if($this->input->post('firstDate') < $this->input->post('secondDate')){
           
            $this->db->where('creditnote_date >=',$this->input->post('firstDate'));
            $this->db->where('creditnote_date <=',$this->input->post('secondDate'));
            
        }else if($this->input->post('searchDate')){ 
          $search_date = $this->input->post('searchDate');
        //   print_r($search_date);die;
          if($search_date == "This Week"){
            $this->db->where('creditnote_date >=',date('Y-m-d',strtotime('last monday')));
          }else{
           $this->db->where('creditnote_date >=',$search_date);
          }
        }

        if($this->input->post('searchUser')){ 
                $searchUser = $this->input->post('searchUser');
                $this->db->where('sess_eml',$searchUser);  
            }
 

        $this->db->where('delete_status',1);
      
        if($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po')!='1' ){
            $this->db->where('sess_eml',$sess_eml);
          }

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


    public function getdata_credit(){
      
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // fetch invoices by id
    public function get_data_invoices($ino_id) {
        $this->db->select('*');
        $this->db->from('invoices');
        $this->db->where('id', $ino_id);
        $query = $this->db->get()->row_array();
       
        return $query;
    } 

    // fetch creditnote by id
    /**
    * Retrieve a credit note record by invoice ID, scoped to the current session company/email or provided decoded values.
    * @example
    * $result = $this->Base_model->get_creditnote_by_id(123, 'Acme Corporation', 'billing@acme.com');
    * echo print_r($result, true); // sample output: Array ( [invoice_id] => 123 [credit_note_number] => CN-2025-001 [amount] => 1500.00 [session_company] => Acme Corporation [session_comp_email] => billing@acme.com )
    * @param int|string $id - Invoice ID to search for.
    * @param string $decoded_cnp - Optional decoded company name to override session company (default: '').
    * @param string $decoded_ceml - Optional decoded company email to override session email (default: '').
    * @returns array|null Return associative array of the credit note record, or null if not found.
    */
    public function get_creditnote_by_id($id,$decoded_cnp = '',$decoded_ceml = '')
    {	
        if ($decoded_cnp == '') {
            $session_company = $this->session->userdata('company_name');
        } else {
            $session_company = $decoded_cnp;
        }
        
        if ($decoded_ceml == '') {
            $session_comp_email = $this->session->userdata('company_email');
        } else {
            $session_comp_email = $decoded_ceml;
        }
    
        $this->db->select('*');
        $this->db->from('creditnote');
        $this->db->where('invoice_id', $id);
        $this->db->where('delete_status', 1);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
    
        return $this->db->get()->row_array();

    }

     // fetch invoices no. by id
     public function get_ino_no($id){
        $this->db->select('invoice_no ,buyer_date ,cust_order_no');
        $this->db->from('invoices');
        $this->db->where('id', $id);
        $this->db->where('delete_status', 1);
        return $this->db->get()->row_array();
        

    }


    // fetch branch user data
    public function get_Branch_Data($branchId)
    {
    
      $this->db->from('user_branch');
      $this->db->where('id',$branchId);
      $query = $this->db->get();
      return $query->row_array();
    }

    // fetch organization data
    public function get_org_by_id($id) 
    {
        $this->db->from('organization');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }


    // fetch bank details
    public function get_bank_detailss()
    {
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
        $this->db->where('delete_status' ,1);
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $query = $this->db->get('account_details');
        return $query->row();
    }

  
    public function delete_creditnote_id($id)
    {
        $this->db->set('delete_status', 2);
        $this->db->where('invoice_id', $id);
        $this->db->update('creditnote');
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }


    /**
    * Check whether any credit note exists for a given invoice ID and return the count and latest delete status.
    * @example
    * $result = $this->Base_model->creditnote_exists(123);
    * // Sample output:
    * // $result = ['count' => 1, 'delete_status' => 0];
    * echo $result['count']; // 1
    * echo $result['delete_status']; // 0
    * @param {int} $invoice_update_id - Invoice ID to check for existing credit notes.
    * @returns {array} Returns an associative array with keys 'count' (int) and 'delete_status' (int|null).
    */
    public function creditnote_exists($invoice_update_id)
    {

        $this->db->select('COUNT(*) as count, MAX(id) as max_id');
        $this->db->select('(SELECT `delete_status` FROM creditnote WHERE id = (SELECT MAX(id) FROM creditnote WHERE invoice_id = ' . $invoice_update_id . ')) as delstatus');
        $this->db->from('creditnote');
        $this->db->where('invoice_id', $invoice_update_id);
    
        if ($cond != null) {
            // Apply additional condition if provided
            // Here assuming $cond is a field to be checked
            $this->db->where($cond);
        }
    
      
        $query = $this->db->get();
    
        $row = $query->row();
        $count = $row->count;
        $delete_status = $row->delstatus;
    
        if ($count > 0) {
            return array(
                'count' => $count,
                'delete_status' => $delete_status
            );
        } else {
            return array(
                'count' => 0,
                'delete_status' => null
            );
        }


    }

    public function creditnote_no($id)
    {
            $this->db->select('*');
            $this->db->from('creditnote');
            $this->db->where('invoice_id', $id);
            $this->db->where('delete_status', 1);
            return $this->db->get()->row();
    }

    public function update_credit_note($invoice_id ,$data){
        $this->db->where('invoice_id', $invoice_id);
        $this->db->where('delete_status', 1);
        $query = $this->db->update('creditnote', $data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }  
    }

    public function count_all()
    {
      $session_comp_email = $this->session->userdata('company_email');
      $session_company = $this->session->userdata('company_name');
      $this->db->from('creditnote');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
    }

    public function count_Total()
    {
        $this->db->select_sum('sub_total', 'total_amount');
        $this->db->where('delete_status', 1);
        $query = $this->db->get('creditnote');
        return $query->row()->total_amount;
    }

    public function count_filtered_c()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all_c()
  {
    $this->db->from('creditnote');
    $this->db->where('delete_status', 1);
    return $this->db->count_all_results();
    // print_r($data);die;
  }


    // <---------------------------------- Credit note end ----------------------------------------------------------->

    

    // <-------------------------------------- Start Debit Note ----------------------------------------------------->

    public function count_all_debit()
    {
      $session_comp_email = $this->session->userdata('company_email');
      $session_company = $this->session->userdata('company_name');
      $this->db->from('debitnote');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
    }

    public function count_Total_debit()
    {
        $this->db->select_sum('sub_total', 'total_amount');
        $this->db->where('delete_status', 1);
        $query = $this->db->get('debitnote');
        return $query->row()->total_amount;
    }


    public function Record_deb_total()
    {
      $this->_get_datatables_query_debit();
      $query = $this->db->get();
      return $query->num_rows();
    }
    public function amount_deb_total()
    {
      $this->db->from('debitnote');
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
      // print_r($data);die;
    }

    /**
    * Get selected columns from a table (commonly used to fetch the last debit id). Returns the query result when rows are found or 0 when no rows exist.
    * @example
    * $result = $this->Base_model->getlast_id_debit('MAX(id) as last_id', 'transactions', ['type' => 'debit']);
    * if ($result !== 0) {
    *     // Example output when row exists:
    *     echo $result->row()->last_id; // e.g. "42"
    * } else {
    *     // No rows found
    *     echo 0;
    * }
    * @param {string|array} $sel - Columns to select (string or array of column names).
    * @param {string} $tbl - Table name to query.
    * @param {array|string|null} $where - Optional WHERE clause as associative array or SQL string. Default null.
    * @returns {CI_DB_result|int} Return CI_DB_result when rows are found, otherwise 0.
    */
    public function getlast_id_debit($sel, $tbl, $where = NULL) {
        $this->db->select($sel);
        $this->db->from($tbl);
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query= $this->db->get();
        if($query->num_rows() >0 ){
            return $query;
        }
        else{
            return 0;
        }
    }


    /**
     * Check whether any debit note exists for the given invoice ID and return the count and the latest delete status.
     * @example
     * $result = $this->Base_model->debitnote_exists(123);
     * print_r($result); // Array ( [count] => 2 [delete_status] => 0 )
     * @param int $invoice_update_id - Invoice ID to check for associated debit notes.
     * @returns array Return associative array with keys 'count' (int) and 'delete_status' (int|null) in one line.
     */
    public function debitnote_exists($invoice_update_id) {

        $this->db->select('COUNT(*) as count, MAX(id) as max_id');
        $this->db->select('(SELECT `delete_status` FROM debitnote WHERE id = (SELECT MAX(id) FROM debitnote WHERE invoice_id = ' . $invoice_update_id . ')) as delstatus');
        $this->db->from('debitnote');
        $this->db->where('invoice_id', $invoice_update_id);
    
        if ($cond != null) {
            // Apply additional condition if provided
            // Here assuming $cond is a field to be checked
            $this->db->where($cond);
        }
    
      
        $query = $this->db->get();
    
        $row = $query->row();
        $count = $row->count;
        $delete_status = $row->delstatus;
    
        if ($count > 0) {
            return array(
                'count' => $count,
                'delete_status' => $delete_status
            );
        } else {
            return array(
                'count' => 0,
                'delete_status' => null
            );
        }
    }

    public function debitnote_no($id) {
        $this->db->select('*');
        $this->db->from('debitnote');
        $this->db->where('invoice_id', $id);
        $this->db->where('delete_status', 1);
        return $this->db->get()->row();
    }


    /**
     * Insert debit data into a table if 'invoice_id' is provided and no non-deleted record exists for that invoice.
     * @example
     * $data = ['invoice_id' => 'INV123', 'amount' => 150.75, 'delete_status' => 1, 'created_by' => 2];
     * $result = $this->Base_model->insert_debit_data('debits', $data);
     * echo $result; // 1 (inserted), 0 (missing invoice_id or already exists), 2 (insert failed)
     * @param {string} $tbl - Name of the database table to insert into.
     * @param {array} $data - Associative array of column => value; must include 'invoice_id'.
     * @returns {int} Return code: 1 = insert success, 0 = missing invoice_id or record already exists, 2 = insert failure.
     */
    public function insert_debit_data($tbl,$data){
        if (!isset($data['invoice_id'])) {
            return 0;
        }

        $existingData = $this->db->get_where($tbl, array('invoice_id' => $data['invoice_id'],'delete_status'=>1));
            if ($existingData->num_rows() > 0) {
                // Data already exists, return 0 indicating failure
                return 0;
            }
            
        $query=$this->db->insert($tbl,$data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }
        
    }

    public function update_debit_note($invoice_id ,$data){
        $this->db->where('invoice_id', $invoice_id);
        $query = $this->db->update('debitnote', $data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }  
    }

    
     public function get_ino_debit_no($ino_id){
        $this->db->select('*');
        $this->db->from('invoices');
        $this->db->where('id', $ino_id);
        return $this->db->get()->row_array();
        

    }

    /**
    * Build and apply CodeIgniter QueryBuilder filters for server-side DataTables on the "debitnote" table.
    * This private helper configures WHERE, LIKE and ORDER BY clauses based on session data and POST inputs
    * (date range, predefined date filters like "This Week", user filter, global search, and column ordering),
    * and restricts results to the current company and non-deleted records.
    * @example
    * // Example usage inside the same model/controller (no direct return value):
    * // Sample runtime state:
    * // $this->session->userdata('company_email') => 'acct@example.com'
    * // $this->session->userdata('company_name')  => 'Example Co'
    * // $_POST = [
    * //   'firstDate' => '2025-01-01',
    * //   'secondDate' => '2025-01-31',
    * //   'search' => ['value' => 'INV-100'],
    * //   'order' => [['column' => 0, 'dir' => 'asc']]
    * // ];
    * $this->_get_datatables_query_debit();
    * // After calling, $this->db will have the appropriate where/like/order clauses applied
    * // and can be used to fetch results, e.g. $query = $this->db->get();
    * @param void $none - No parameters; method reads from $this->session and $this->input->post().
    * @returns void Applies QueryBuilder conditions to $this->db; does not return a value.
    */
    private function _get_datatables_query_debit()
    {
     $table 		= 'debitnote';
     $sort_by 		= array('debitnote_no','org_name','owner','sub_total','pi_status','debitnote_date',null);
     $search_by 	= array('debitnote_no','org_name','owner', 'sub_total','pi_status','debitnote_date');
     $order 		= array('id' => 'desc');
        
          $sess_eml           = $this->session->userdata('email');
          $session_comp_email = $this->session->userdata('company_email');
          $session_company    = $this->session->userdata('company_name');
      
          $this->db->from($table);
          $this->db->where('session_comp_email',$session_comp_email);
          $this->db->where('session_company',$session_company);

        if($this->input->post('firstDate') < $this->input->post('secondDate')){
           
            $this->db->where('debitnote_date >=',$this->input->post('firstDate'));
            $this->db->where('debitnote_date <=',$this->input->post('secondDate'));
            
        }else if($this->input->post('searchDate')){ 
          $search_date = $this->input->post('searchDate');
        //   print_r($search_date);die;
          if($search_date == "This Week"){
            $this->db->where('debitnote_date >=',date('Y-m-d',strtotime('last monday')));
          }else{
           $this->db->where('debitnote_date >=',$search_date);
          }
        }

        if($this->input->post('searchUser')){ 
                $searchUser = $this->input->post('searchUser');
                $this->db->where('sess_eml',$searchUser);  
            }
 

        $this->db->where('delete_status',1);
      
        if($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po')!='1' ){
            $this->db->where('sess_eml',$sess_eml);
          }

      $i = 0;
      foreach ($search_by as $item) // loop column
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
          if(count($search_by) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
        }
        $i++;
      }


      if(isset($_POST['order'])) // here order processing
      {
        $this->db->order_by($sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      }
      else if(isset($order))
      {
        $order = $order;
        $this->db->order_by(key($order), $order[key($order)]);
      }
    }

    public function getdata_debit() {

        $this->_get_datatables_query_debit();
     
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
    * Retrieve a debit note record by its invoice ID, constrained to the current session company/email or provided decoded values.
    * @example
    * $result = $this->Base_model->get_debitnote_by_id(123, 'Acme Ltd', 'billing@acme.com');
    * echo print_r($result, true); // render sample output:
    * // Array (
    * //   [id] => 45
    * //   [invoice_id] => 123
    * //   [amount] => 100.00
    * //   [session_company] => Acme Ltd
    * //   [session_comp_email] => billing@acme.com
    * //   [delete_status] => 1
    * // )
    * @param int|string $id - Invoice ID to search debit note for.
    * @param string $decoded_cnp - (Optional) Decoded company name to use instead of session company_name. Pass empty string to use session value.
    * @param string $decoded_ceml - (Optional) Decoded company email to use instead of session company_email. Pass empty string to use session value.
    * @returns array|null Return associative array of the debit note row if found, or null/empty if not found.
    */
    public function get_debitnote_by_id($id, $decoded_cnp = '', $decoded_ceml = '')
    {
        if ($decoded_cnp == '') {
            $session_company = $this->session->userdata('company_name');
        } else {
            $session_company = $decoded_cnp;
        }
        
        if ($decoded_ceml == '') {
            $session_comp_email = $this->session->userdata('company_email');
        } else {
            $session_comp_email = $decoded_ceml;
        }
    
        $this->db->select('*');
        $this->db->from('debitnote');
        $this->db->where('invoice_id', $id);
        $this->db->where('delete_status', 1);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
    
        return $this->db->get()->row_array();
    }

      public function debit_get_org_by_id($id) 
      {
          $this->db->from('organization');
          $this->db->where('id',$id);
          $query = $this->db->get();
          return $query->row();
      }

    public function debit_get_Branch_Data($branchId)
    {
      $this->db->from('user_branch');
      $this->db->where('id',$branchId);
      $query = $this->db->get();
      return $query->row_array();
    }

    public function delete_debitnote_id($id){
        $this->db->set('delete_status', 2);
        $this->db->where('invoice_id', $id);
        $this->db->update('debitnote');
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function get_Owner_debit($get_Owner)
    {
        $this->db->select('*');
        $this->db->from('standard_users');
        $this->db->where('standard_email', $get_Owner);
        $query = $this->db->get();
        
        return $query->row_array();
    }

    public function get_Admin_debit($get_Owner)
  {
		$this->db->select('admin_name as standard_name, admin_mobile as standard_mobile');
		$this->db->from('admin_users');
		$this->db->where('admin_email',$get_Owner);
		$query = $this->db->get();
		return $query->row_array();
  }

  public function get_Comp_debit($branchId)
  {
		$session_company    = $this->session->userdata('company_name');
        $this->db->from('admin_users');
        $this->db->where('company_email',$branchId);
        $this->db->where('company_name',$session_company);
        $this->db->where('type','admin');
        $query = $this->db->get();
        return $query->row_array();
  }

  public function getBranchData_debit($branchId)
  {
  
    $this->db->from('user_branch');
    $this->db->where('id',$branchId);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function getorg_by_id_debit($id)
  {
    $this->db->from('organization');
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }
    
    // <-------------------------------------------------------debit note end ------------------------------------------------->


    // <-----------------------------------------------------------delivery challan start----------------------------------------------->
    public function count_all_delivery(){
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from('deliverychallan');
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('delete_status', 1);
    return $this->db->count_all_results();
    }

    public function count_Total_delivery()
    {
        $this->db->select_sum('sub_total', 'total_amount');
        $this->db->where('delete_status', 1);
        $query = $this->db->get('deliverychallan');
        return $query->row()->total_amount;
    }

    public function count_all_del()
    {
      $this->_get_datatables_query_deliverychallan();
      $query = $this->db->get();
      return $query->num_rows();
    }
    public function count_filtered_del()
    {
      $this->db->from('deliverychallan');
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
      // print_r($data);die;
    }


    /**
     * Check whether a delivery challan exists for a given invoice ID and return the total count and the delete status of the latest challan.
     * @example
     * $result = $this->deliverychallan_exists(123, ['status' => 'active']);
     * print_r($result); // Array ( [count] => 2 [delete_status] => 0 )
     * @param int $invoice_update_id - Invoice ID to check for delivery challans.
     * @param string|array|null $cond - Optional additional where condition (string or associative array) or null.
     * @returns array Returns associative array with keys 'count' (int) and 'delete_status' (int|null).
     */
    public function deliverychallan_exists($invoice_update_id, $cond =null)
    {
        $this->db->select('COUNT(*) as count, MAX(id) as max_id');
        $this->db->select('(SELECT `delete_status` FROM deliverychallan WHERE id = (SELECT MAX(id) FROM deliverychallan WHERE invoice_id = ' . $invoice_update_id . ')) as delstatus');
        $this->db->from('deliverychallan');
        $this->db->where('invoice_id', $invoice_update_id);
    
        if ($cond != null) {
            // Apply additional condition if provided
            // Here assuming $cond is a field to be checked
            $this->db->where($cond);
        }
    
      
        $query = $this->db->get();
    
        $row = $query->row();
        $count = $row->count;
        $delete_status = $row->delstatus;
    
        if ($count > 0) {
            return array(
                'count' => $count,
                'delete_status' => $delete_status
            );
        } else {
            return array(
                'count' => 0,
                'delete_status' => null
            );
        }

    }

    /**
    * Retrieve a delivery challan record by its invoice ID, filtered by session company and email (or provided decoded values).
    * @example
    * $result = $this->Base_model->get_deliverychallan_by_id(123, 'ACME Corp', 'info@acme.com');
    * print_r($result); // render sample output: Array ( [id] => 1 [invoice_id] => 123 [session_company] => ACME Corp [session_comp_email] => info@acme.com [delete_status] => 1 ... )
    * @param {int|string} $id - Invoice ID of the delivery challan to retrieve.
    * @param {string} $decoded_cnp - Optional decoded company name; if empty the session value 'company_name' will be used.
    * @param {string} $decoded_ceml - Optional decoded company email; if empty the session value 'company_email' will be used.
    * @returns {array|null} Return associative array of the deliverychallan record if found, or null if not found.
    */
    public function get_deliverychallan_by_id($id,$decoded_cnp = '',$decoded_ceml = '')
    {	
        if ($decoded_cnp == '') {
            $session_company = $this->session->userdata('company_name');
        } else {
            $session_company = $decoded_cnp;
        }
        
        if ($decoded_ceml == '') {
            $session_comp_email = $this->session->userdata('company_email');
        } else {
            $session_comp_email = $decoded_ceml;
        }
    
        $this->db->select('*');
        $this->db->from('deliverychallan');
        $this->db->where('invoice_id', $id);
        $this->db->where('delete_status', 1);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
    
        return $this->db->get()->row_array();

    }

    public function delivery_no($id)
    {
            $this->db->select('*');
            $this->db->from('deliverychallan');
            $this->db->where('invoice_id', $id);
            $this->db->where('delete_status', 1);
            return $this->db->get()->row();
    }

    /**
    * Get the last delivery query result for a given selection and table (returns query result or 0 when no rows).
    * @example
    * $result = $this->Base_model->getlast_delivery_id('delivery_id', 'deliveries', ['status' => 'sent']);
    * if ($result !== 0) {
    *     // sample output: object containing rows, access first row's delivery_id:
    *     echo $result->row()->delivery_id; // e.g. "12345"
    * } else {
    *     echo 0; // no rows found
    * }
    * @param {string|array} $sel - Columns to select (string like 'delivery_id' or array of columns).
    * @param {string} $tbl - Table name to query (e.g. 'deliveries').
    * @param {array|string|null} $where - Optional WHERE clause as associative array or SQL string, default NULL.
    * @returns {CI_DB_result|int} Returns the CI_DB_result query object when rows are found, otherwise returns 0.
    */
    public function getlast_delivery_id($sel, $tbl, $where = NULL) {
        $this->db->select($sel);
        $this->db->from($tbl);
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query= $this->db->get();
        if($query->num_rows() >0 ){
            return $query;
        }
        else{
            return 0;
        }
    }


    /**
    * Insert delivery data into a table if invoice_id is present and no existing (delete_status = 1) record with that invoice_id exists.
    * @example
    * $data = ['invoice_id' => 123, 'customer' => 'Acme Corp', 'amount' => 49.99];
    * $result = $this->Base_model->insert_delivery_data('deliveries', $data);
    * echo $result; // render 1  (1 = inserted successfully; 0 = missing invoice_id or already exists; 2 = insert failed)
    * @param {string} $tbl - Table name to insert the delivery data into.
    * @param {array} $data - Associative array of delivery data; must include 'invoice_id'.
    * @returns {int} Return 1 on successful insert, 0 if missing invoice_id or record already exists, 2 on insert failure.
    */
    public function insert_delivery_data($tbl,$data){
        if (!isset($data['invoice_id'])) {
            return 0;
        }

        $existingData = $this->db->get_where($tbl, array('invoice_id' => $data['invoice_id'],'delete_status'=>1));
            if ($existingData->num_rows() > 0) {
                return 0;
            }
        
        $query=$this->db->insert($tbl,$data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }
    
    }


    public function update_delivery($invoice_id ,$data){
        $this->db->where('invoice_id', $invoice_id);
        $this->db->where('delete_status', 1);
        $query = $this->db->update('deliverychallan', $data);
        if($query){
            return 1;
        }else{
            return 2;
        }  
    }

    public function delete_deliverychallan_id($id)
    {
        $this->db->set('delete_status', 2);
        $this->db->where('invoice_id', $id);
        $this->db->update('deliverychallan');
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function getdata_delivery_challan() {

        $this->_get_datatables_query_deliverychallan();
    
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    /**
    * Build CodeIgniter query builder filters for the deliverychallan datatables (applies session/company scopes, date/user/search filters and ordering).
    * @example
    * // Called inside the model (private method) to prepare the query
    * $this->_get_datatables_query_deliverychallan();
    * // After calling the method, fetch results:
    * $rows = $this->db->get('deliverychallan')->result();
    * // Example sample output element:
    * // stdClass {
    * //   id: 1,
    * //   deliverychallan_no: "DC-1001",
    * //   org_name: "Acme Corp",
    * //   owner: "John Doe",
    * //   sub_total: "1250.00",
    * //   pi_status: "Pending",
    * //   deliverychallan_date: "2025-12-01"
    * // }
    * @param {void} $none - No arguments; uses $this->session and $this->input (POST) for filtering.
    * @returns {void} Applies WHERE/LIKE/ORDER conditions to $this->db (query builder); does not return a value.
    */
    private function _get_datatables_query_deliverychallan()
    {
     $table 		= 'deliverychallan';
     $sort_by 		= array('deliverychallan_no','org_name','owner','sub_total','pi_status','deliverychallan_date',null);
     $search_by 	= array('deliverychallan_no','org_name','owner', 'sub_total','pi_status','deliverychallan_date');
     $order 		= array('id' => 'desc');
        
          $sess_eml           = $this->session->userdata('email');
          $session_comp_email = $this->session->userdata('company_email');
          $session_company    = $this->session->userdata('company_name');
      
          $this->db->from($table);
          $this->db->where('session_comp_email',$session_comp_email);
          $this->db->where('session_company',$session_company);

        if($this->input->post('firstDate') < $this->input->post('secondDate')){
           
            $this->db->where('deliverychallan_date >=',$this->input->post('firstDate'));
            $this->db->where('deliverychallan_date <=',$this->input->post('secondDate'));
            
        }else if($this->input->post('searchDate')){ 
          $search_date = $this->input->post('searchDate');
        //   print_r($search_date);die;
          if($search_date == "This Week"){
            $this->db->where('deliverychallan_date >=',date('Y-m-d',strtotime('last monday')));
          }else{
           $this->db->where('deliverychallan_date >=',$search_date);
          }
        }

        if($this->input->post('searchUser')){ 
                $searchUser = $this->input->post('searchUser');
                $this->db->where('sess_eml',$searchUser);  
            }
 

        $this->db->where('delete_status',1);
      
        if($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po')!='1' ){
            $this->db->where('sess_eml',$sess_eml);
          }

      $i = 0;
      foreach ($search_by as $item) // loop column
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
          if(count($search_by) - 1 == $i) 
          $this->db->group_end(); 
        }
        $i++;
      }


      if(isset($_POST['order'])) 
      {
        $this->db->order_by($sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      }
      else if(isset($order))
      {
        $order = $order;
        $this->db->order_by(key($order), $order[key($order)]);
      }
    }
    // <-------------------------------------------------------Delivery Challan end ------------------------------------------------->


    //  <------------------------------------------- Expenditure management Start ------------------------------------------------------------>
        public function getpodata($where){
            $this->db->select('id');
            $this->db->where($where);
            return $this->db->get('purchaseorder');
        }

        /**
        * Check whether any expenditure records exist for a given purchase order ID and return the count and latest delete status.
        * @example
        * $result = $this->expanse_exists(123, ['status' => 'approved']);
        * print_r($result); // Example output: Array ( [count] => 2 [delete_status] => 0 )
        * @param {int} $po_update_id - Purchase order ID to search expenditures for.
        * @param {string|array|null} $cond - Optional additional WHERE condition (string or associative array) or null.
        * @returns {array} Returns associative array with keys 'count' (int) and 'delete_status' (int|null).
        */
        public function expanse_exists($po_update_id, $cond = null)
        {
            $this->db->select('COUNT(*) as count, MAX(id) as max_id');
            $this->db->select('(SELECT `delete_status` FROM expenditure WHERE id = (SELECT MAX(id) FROM expenditure WHERE po_id = ' . $po_update_id . ')) as delstatus');
            $this->db->from('expenditure');
            $this->db->where('po_id', $po_update_id);

            if ($cond != null) {
                // Apply additional condition if provided
                // Here assuming $cond is a field to be checked
                $this->db->where($cond);
            }

            $query = $this->db->get();

            $row = $query->row();
            $count = $row->count;
            $delete_status = $row->delstatus;

            if ($count > 0) {
                return array(
                    'count' => $count,
                    'delete_status' => $delete_status
                );
            } else {
                return array(
                    'count' => 0,
                    'delete_status' => null
                );
            }
        }

        public function expanse_data_by_po_no($id)
        {
                $this->db->select('*');
                $this->db->from('expenditure');
                $this->db->where('po_id', $id);
                $this->db->where('delete_status', 1);
                return $this->db->get()->row();
        }

        /**
         * Get the last expense identifier or result set based on a select expression and optional where clause.
         * @example
         * $this->load->model('Base_model');
         * $result = $this->Base_model->getlast_expanse_id('MAX(id) as last_id', 'expenses', array('user_id' => 5));
         * if ($result !== 0) {
         *     echo $result->row()->last_id; // e.g. 42
         * } else {
         *     echo 0; // no matching rows
         * }
         * @param string $sel - Select expression (columns or aggregate) to fetch, e.g. 'MAX(id) as last_id'.
         * @param string $tbl - Table name to query, e.g. 'expenses'.
         * @param array|string|null $where - Optional WHERE clause as array or string, e.g. array('user_id' => 5).
         * @returns CI_DB_result|int Returns the CI_DB_result object on success or integer 0 if no rows found.
         */
        public function getlast_expanse_id($sel, $tbl, $where = NULL) {
            $this->db->select($sel);
            $this->db->from($tbl);
            if ($where !== NULL) {
                $this->db->where($where);
            }
            $query= $this->db->get();
            if($query->num_rows() >0 ){
                return $query;
            }
            else{
                return 0;
            }
        }

        /**
        * Insert expenditure data into the specified table if 'po_id' is provided and not already present.
        * @example
        * $sample_tbl = 'expenditures';
        * $sample_data = array('po_id' => 123, 'amount' => 1500, 'description' => 'Office supplies');
        * $result = $this->insert_expenditure_data($sample_tbl, $sample_data);
        * echo $result; // 1 (success), 0 (missing po_id or record already exists), 2 (insert failed)
        * @param {string} $tbl - Database table name to insert the expenditure into.
        * @param {array} $data - Associative array of expenditure data; must include 'po_id'.
        * @returns {int} Return status: 1 on successful insert, 0 if 'po_id' is missing or record already exists, 2 on insert failure.
        */
        public function insert_expenditure_data($tbl,$data)
        {
            if (!isset($data['po_id'])) {
                return 0;
            }
            $existingData = $this->db->get_where($tbl, array('po_id' => $data['po_id'],'delete_status'=>1));
                if ($existingData->num_rows() > 0) {
                    return 0;
                }
            //   print_r($data);die;  
            $query=$this->db->insert($tbl,$data);
            if($query){
                return 1;
            }
            else{
                return 2;
            }
            
        }

        public function update_expanse($po_id ,$data){
            $this->db->where('po_id', $po_id);
            $query = $this->db->update('expenditure', $data);
            if($query){
                return 1;
            }else{
                return 2;
            }  
        }


        public function getdata_expanse() {

                $this->_get_datatables_query_expanse();
            
                if($_POST['length'] != -1)
                $this->db->limit($_POST['length'], $_POST['start']);
                $query = $this->db->get();
                return $query->result_array();
        }


        /**
        * Build and apply DataTables server-side filtering, searching, date/user/session constraints and ordering for the 'expenditure' table.
        * @example
        * // Called inside the model before fetching results from the DB
        * $this->_get_datatables_query_expanse();
        * $query = $this->db->get(); // execute the query after conditions applied
        * $result = $query->result();
        * echo count($result); // render some sample output value: 5
        * @param void $none - No parameters; this method uses $this->input and $this->session internally.
        * @returns void Apply query conditions to $this->db query builder; does not return a value.
        */
        private function _get_datatables_query_expanse()
        {
         $table 		= 'expenditure';
         $sort_by 		= array('expenditure_no','org_name','owner','sub_total','pi_status','expenditure_date',null);
         $search_by 	= array('expenditure_no','org_name','owner', 'sub_total','pi_status','expenditure_date');
         $order 		= array('id' => 'desc');
            
              $sess_eml           = $this->session->userdata('email');
              $session_comp_email = $this->session->userdata('company_email');
              $session_company    = $this->session->userdata('company_name');
          
              $this->db->from($table);
              $this->db->where('session_comp_email',$session_comp_email);
              $this->db->where('session_company',$session_company);
    
            if($this->input->post('firstDate') < $this->input->post('secondDate')){
               
                $this->db->where('expenditure_date >=',$this->input->post('firstDate'));
                $this->db->where('expenditure_date <=',$this->input->post('secondDate'));
                
            }else if($this->input->post('searchDate')){ 
              $search_date = $this->input->post('searchDate');
            //   print_r($search_date);die;
              if($search_date == "This Week"){
                $this->db->where('expenditure_date >=',date('Y-m-d',strtotime('last monday')));
              }else{
               $this->db->where('expenditure_date >=',$search_date);
              }
            }
    
            if($this->input->post('searchUser')){ 
                    $searchUser = $this->input->post('searchUser');
                    $this->db->where('sess_eml',$searchUser);  
                }
     
    
            $this->db->where('delete_status',1);
          
            if($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po')!='1' ){
                $this->db->where('sess_eml',$sess_eml);
              }
    
          $i = 0;
          foreach ($search_by as $item) // loop column
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
              if(count($search_by) - 1 == $i) 
              $this->db->group_end(); 
            }
            $i++;
          }
    
    
          if(isset($_POST['order'])) 
          {
            $this->db->order_by($sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
          }
          else if(isset($order))
          {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
          }
        }

        public function get_expanse_no($po_id){
            $this->db->select('*');
            $this->db->from('purchaseorder');
            $this->db->where('id', $po_id);
            $this->db->where('delete_status', 1);
            return $this->db->get()->row_array();
        }

        public function count_all_expanse(){
            $session_comp_email = $this->session->userdata('company_email');
            $session_company = $this->session->userdata('company_name');
            $this->db->from('expenditure');
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
            $this->db->where('delete_status', 1);
            return $this->db->count_all_results();
        }


        /**
         * Get summed expenditure totals from the "expenditure" table (sums 'sub_total' and 'pending_payment').
         * @example
         * $this->load->model('Base_model');
         * $result = $this->Base_model->count_Total_expanse();
         * // sample output:
         * // array(
         * //   'total_amount'   => 12345.67,
         * //   'pending_payment' => 234.56
         * // );
         * print_r($result);
         * @param void $none - No parameters.
         * @returns array Associative array with keys 'total_amount' (float) and 'pending_payment' (float) containing summed values.
         */
        public function count_Total_expanse()
        {
            $this->db->select_sum('sub_total', 'total_amount');
            $this->db->select_sum('pending_payment', 'pending_payment');
            $this->db->where('delete_status', 1);
            $query = $this->db->get('expenditure');

            return array(
                'total_amount' =>$query->row()->total_amount,
                'pending_payment' => $query->row()->pending_payment
              
            );
           
        }


        public function count_all_exp()
        {
          $this->_get_datatables_query_expanse();
          $query = $this->db->get();
          return $query->num_rows();
        }
        public function count_filtered_exp()
        {
          $this->db->from('expenditure');
          $this->db->where('delete_status', 1);
          return $this->db->count_all_results();
          // print_r($data);die;
        }

        /**
        * Retrieve a single expenditure record by purchase order ID for the current (or provided) company session.
        * @example
        * $result = $this->get_expenditure_by_id(123, 'Acme Company', 'finance@acme.com');
        * echo print_r($result, true); // Array ( [po_id] => 123 [amount] => 100.00 [session_company] => Acme Company [session_comp_email] => finance@acme.com [delete_status] => 1 ... )
        * @param {{int}} $id - Expenditure purchase order ID to retrieve.
        * @param {{string}} $decoded_cnp - Optional company name override; if empty, session company_name is used.
        * @param {{string}} $decoded_ceml - Optional company email override; if empty, session company_email is used.
        * @returns {{array|null}} Associative array of the expenditure row when found; NULL if no matching record exists.
        */
        public function get_expenditure_by_id($id,$decoded_cnp = '',$decoded_ceml = '')
        {	
            if ($decoded_cnp == '') {
                $session_company = $this->session->userdata('company_name');
            } else {
                $session_company = $decoded_cnp;
            }
            
            if ($decoded_ceml == '') {
                $session_comp_email = $this->session->userdata('company_email');
            } else {
                $session_comp_email = $decoded_ceml;
            }
        
            $this->db->select('*');
            $this->db->from('expenditure');
            $this->db->where('po_id', $id);
            $this->db->where('delete_status', 1);
            $this->db->where('session_comp_email', $session_comp_email);
            $this->db->where('session_company', $session_company);
        
            return $this->db->get()->row_array();
        }

        public function delete_expanse_id($id)
        {
            $this->db->set('delete_status', 2);
            $this->db->where('po_id', $id);
            $this->db->update('expenditure');
            if($this->db->affected_rows() > 0){
                return true;
            } else {
                return false;
            }
        }

        // fetch total expenditure data for acounting report page
        

            

            /**
            * Fetch expenditure records filtered by optional date range and scoped to the current session (company/user) where applicable.
            * @example
            * $result = $this->Base_model->fetchData_expenditure_by('2024-01-01', '2024-01-31');
            * print_r($result); // sample output: Array ( [0] => Array ( 'id' => '1', 'expenditure_date' => '2024-01-05', 'amount' => '150.00', 'description' => 'Office supplies', ... ) )
            * @param string|null $startDate - Start date filter in 'YYYY-MM-DD' format or null to ignore date lower bound.
            * @param string|null $endDate - End date filter in 'YYYY-MM-DD' format or null to ignore date upper bound.
            * @returns array Returns an array of associative arrays representing expenditure rows; returns an empty array if no records found or on query failure.
            */
            public function fetchData_expenditure_by($startDate = null, $endDate = null) {
                $session_comp_email = $this->session->userdata('company_email');
                $sess_eml = $this->session->userdata('email');
                $session_company = $this->session->userdata('company_name');
                $type = $this->session->userdata("type");
            
                $this->db->select('*');
                $this->db->from('expenditure'); 
            
                if (!empty($startDate) && !empty($endDate)) {
                    $this->db->where('expenditure_date >=', $startDate);
                    $this->db->where('expenditure_date <=', $endDate);
                }
            
                if ($type == "admin" || $type == "standard") {
                    $this->db->where('session_comp_email', $session_comp_email);
                    $this->db->where('session_company', $session_company);
                }
            
                if ($type == "standard") {
                    $this->db->where('sess_eml', $sess_eml);
                }
            
                $this->db->where('pi_status', 1);
                $this->db->where('delete_status', 1);
                $query = $this->db->get();
            
                if ($query === false) {
                    return []; 
                }
            
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return []; 
                }
            }
            
            
            
            


            /**
            * Fetch purchase orders optionally between two dates, filtered by the current session's company/user and active status.
            * @example
            * $result = $this->Base_model->fetchData_Purchaseorders_by('2025-01-01', '2025-01-31');
            * print_r($result); // example output: Array ( [0] => Array ( 'id' => '123', 'currentdate' => '2025-01-05', 'pi_status' => '1', ... ) )
            * @param {{string|null}} {{startDate}} - Optional start date (YYYY-MM-DD) to filter purchase orders.
            * @param {{string|null}} {{endDate}} - Optional end date (YYYY-MM-DD) to filter purchase orders.
            * @returns {{array}} Returns an array of purchase order rows (empty array if none found or on query failure).
            */
            public function fetchData_Purchaseorders_by($startDate = null, $endDate = null) {
               
                $session_comp_email = $this->session->userdata('company_email');
                $sess_eml = $this->session->userdata('email');
                $session_company = $this->session->userdata('company_name');
                $type = $this->session->userdata("type");

                $this->db->select('*');
                $this->db->from('purchaseorder');
                
                if (!empty($startDate) && !empty($endDate)) {
                    $this->db->where('currentdate >=', $startDate);
                    $this->db->where('currentdate <=', $endDate);
                }

                if ($type == "admin" || $type == "standard") {
                    $this->db->where('session_comp_email', $session_comp_email);
                    $this->db->where('session_company', $session_company);
                }
            
                if ($type == "standard") {
                    $this->db->where('sess_eml', $sess_eml);
                }

                $this->db->where('pi_status',1);
                $this->db->where('delete_status', 1);


                $query = $this->db->get();
                if ($query === false) {
                    return []; 
                }
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return [];
                }

              

            }

            /**
            * Fetch invoices filtered by an optional date range and constrained by the current session (company/user) as well as pi_status and delete_status flags.
            * @example
            * $result = $this->Base_model->fetchData_invoices_by('2025-01-01', '2025-01-31');
            * print_r($result); // Example output: Array ( [0] => Array ( 'invoice_id' => 'INV-123', 'invoice_date' => '2025-01-05', 'amount' => '150.00', 'session_comp_email' => 'acme@example.com' ) )
            * @param {string|null} $startDate - Start date in 'YYYY-MM-DD' format to filter invoices, or null to ignore the lower bound.
            * @param {string|null} $endDate - End date in 'YYYY-MM-DD' format to filter invoices, or null to ignore the upper bound.
            * @returns {array} Returns an array of associative arrays representing invoice rows; returns an empty array on query failure or when no rows match.
            */
            public function fetchData_invoices_by($startDate = null, $endDate = null) {
                $session_comp_email = $this->session->userdata('company_email');
                $sess_eml = $this->session->userdata('email');
                $session_company = $this->session->userdata('company_name');
                $type = $this->session->userdata("type");
            
                $this->db->select('*');
                $this->db->from('invoices'); 
               
            
                if (!empty($startDate) && !empty($endDate)) {
                    $this->db->where('invoice_date >=', $startDate);
                    $this->db->where('invoice_date <=', $endDate);
                }
            
                if ($type == "admin" || $type == "standard") {
                    $this->db->where('session_comp_email', $session_comp_email);
                    $this->db->where('session_company', $session_company);
                }
            
                if ($type == "standard") {
                    $this->db->where('sess_eml', $sess_eml);
                }
                $this->db->where('pi_status',1);
                $this->db->where('delete_status', 1);

                $query = $this->db->get();

                if ($query === false) {
                  
                    return []; 
                }

                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return [];
                }

            
               
            }
            
    

        //<-------------------------------- Expenditure management End --------------------------------------------->

    
      /**
      * Get invoices for a specific client that have pending payments within the current session/company context.
      * @example
      * $result = $this->Base_model->getInvoicesByClientId(42);
      * print_r($result); // Example output: Array ( [0] => stdClass Object ( [id] => 1001 [cust_id] => 42 [pending_payment] => 150.00 [session_comp_email] => "example@company.com" ) )
      * @param {int} $clientId - Client ID to filter invoices by.
      * @returns {array} Returns an array of invoice stdClass objects or an empty array if none found.
      */
      public function getInvoicesByClientId($clientId) {
            // print_r($clientId);die;
            $session_comp_email = $this->session->userdata('company_email');
            $sess_eml = $this->session->userdata('email');
            $session_company = $this->session->userdata('company_name');
            $type = $this->session->userdata("type");

            $this->db->select('*');
            $this->db->from('invoices');

            if($type == "admin")
            {
            
              $this->db->where('session_comp_email',$session_comp_email);
              $this->db->where('session_company',$session_company);
            }
            else if ($type == "standard") 
            {
            
              $this->db->where('session_comp_email',$session_comp_email);
              $this->db->where('session_company',$session_company);
              $this->db->where('sess_eml',$sess_eml);
            }

            $this->db->where('cust_id', $clientId);
            $this->db->where('delete_status', 1);
            $this->db->where('pending_payment >', 0);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return array();
            }
        }


        /**
         * Retrieve performa invoices for a given client id, constrained by current session permissions (admin or standard).
         * @example
         * $invoices = $this->Base_model->get_piInvoicesByClientId(123);
         * var_dump($invoices); // e.g. array(1) { [0]=> object(stdClass) (["id"]=> int(1) ["cust_id"]=> int(123) ["total"]=> float(150.00)) }
         * @param {{int|string}} $clientId - Client identifier used to filter performa invoices.
         * @returns {{array}} Array of invoice result objects when found; empty array when no invoices match.
         */
        public function get_piInvoicesByClientId($clientId) {
       
            $session_comp_email = $this->session->userdata('company_email');
            $sess_eml = $this->session->userdata('email');
            $session_company = $this->session->userdata('company_name');
            $type = $this->session->userdata("type");

            $this->db->select('*');
            $this->db->from('performa_invoice');

            if($type == "admin")
            {
            
              $this->db->where('session_comp_email',$session_comp_email);
              $this->db->where('session_company',$session_company);
            }
            else if ($type == "standard") 
            {
            
              $this->db->where('session_comp_email',$session_comp_email);
              $this->db->where('session_company',$session_company);
              $this->db->where('sess_eml',$sess_eml);
            }

            $this->db->where('cust_id', $clientId);
            $this->db->where('delete_status', 1);
            $query = $this->db->get();
            // print_r($query);die;
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return array();
            }
        }



        /**
        * Retrieve invoice record(s) by invoice ID (only returns records with delete_status = 1).
        * @example
        * $result = $this->Base_model->getpo_InvoicesByClientId(123);
        * print_r($result); // Example output: Array ( [0] => stdClass Object ( [id] => 123 [client_id] => 45 [amount] => 250.00 [delete_status] => 1 ... ) )
        * @param int $invoicesId - Invoice ID to fetch.
        * @returns array Returns an array of stdClass invoice objects; returns an empty array if no record is found.
        */
        public function getpo_InvoicesByClientId($invoicesId) {
            // print_r($clientId);die;
            $this->db->select('*');
            $this->db->from('invoices');
            $this->db->where('id', $invoicesId);
            $this->db->where('delete_status', 1);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return array();
            }
        }


      /**
      * Insert a payment record into the given database table.
      * @example
      * $data = ['user_id' => 5, 'amount' => 100.50, 'method' => 'card', 'created_at' => '2025-12-17 12:00:00'];
      * $result = $this->Base_model->insertpayment_rec('payments', $data);
      * echo $result; // 1 on success, 2 on failure
      * @param {string} $tbl - Name of the database table to insert into (e.g., 'payments').
      * @param {array} $data - Associative array of column => value pairs to insert (e.g., ['amount' => 100.5, 'user_id' => 5]).
      * @returns {int} 1 if insert succeeded, 2 if insert failed.
      */
      public function insertpayment_rec($tbl,$data){
    
            // print_r($data);die;    
        $query=$this->db->insert($tbl,$data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }
        
    }
   
    /**
     * Retrieve all payment receipts that are not deleted.
     * @example
     * $result = $this->Base_model->get_payments();
     * if ($result) {
     *     // Example output when records exist:
     *     // Array of objects, e.g.:
     *     // [
     *     //   (object) ['id' => 1, 'amount' => '100.00', 'delete_status' => 1, 'created_at' => '2025-01-10 12:00:00'],
     *     //   (object) ['id' => 2, 'amount' => '50.00', 'delete_status' => 1, 'created_at' => '2025-02-05 09:30:00']
     *     // ]
     *     print_r($result);
     * } else {
     *     // Example output when no records found:
     *     echo $result; // 0
     * }
     * @param void $none - No parameters required.
     * @returns array|int Returns an array of result objects when records are found, otherwise returns integer 0.
     */
    public function get_payments() {
        $this->db->where('delete_status', 1);
        $query = $this->db->get('payment_receipt');
       
        if ($query->num_rows() > 0) {
         
            return $query->result();
        } else {
           
            return 0;
        }
        
    }

    public function update_payment_rec($paymentId ,$update_data){
        $this->db->where('id', $paymentId);
        $this->db->where('delete_status', 1);
        $query = $this->db->update('payment_receipt', $update_data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }  
    }


    /**
    * Retrieve a single payment receipt record by its ID if it exists and is not marked as deleted.
    * @example
    * $result = $this->Base_model->get_payment_receipt_details(123);
    * print_r($result); // Example output: Array ( [id] => 123 [amount] => "49.99" [payment_method] => "card" [created_at] => "2025-06-01 10:30:00" )
    * @param {int} $paymentId - Payment receipt ID to look up.
    * @returns {array|null} Returns associative array of the payment_receipt row when found and delete_status = 1, or null if not found.
    */
    public function get_payment_receipt_details($paymentId) {
        $query = $this->db->get_where('payment_receipt', array('id' => $paymentId));
        $this->db->where('delete_status', 1);
        
        if ($query->num_rows() > 0) {
         
            return $query->row_array();
        } else {
           
            return null;
        }
    }


    /**
    * Mark a payment receipt record as deleted by setting its delete_status to 2.
    * @example
    * $result = $this->base_model->delete_payment_receipt(123);
    * echo $result ? 'true' : 'false'; // outputs 'true' if the record was updated, 'false' otherwise
    * @param {int} $payment_id - The payment receipt ID to mark as deleted.
    * @returns {bool} True if a row was affected (delete flag set), false otherwise.
    */
    public function delete_payment_receipt($payment_id) {
        $this->db->set('delete_status', 2);
        $this->db->where('id',$payment_id);
        $this->db->update('payment_receipt');
        if ($this->db->affected_rows() > 0) {
            return true; 
        } else {
            return false; 
        }
    
    
}

    //-<------------------------------------------------------- New Payment receipt ------------------------------------------------------>
/**
 * Check whether any payment receipts exist for a given invoice and return the count and delete status of the latest receipt.
 * @example
 * $result = $this->Base_model->paymentreceipt_exists(123);
 * // Possible sample outputs:
 * // When receipts exist:
 * // array('count' => 2, 'delete_status' => 0)
 * // When no receipts exist:
 * // array('count' => 0, 'delete_status' => null)
 * @param {int} $invoice_update_id - Invoice ID to check for existing payment receipts.
 * @returns {array} Associative array with keys 'count' (int number of receipts) and 'delete_status' (int|null delete status of the latest receipt).
 */
public function paymentreceipt_exists($invoice_update_id)
{

    $this->db->select('COUNT(*) as count, MAX(id) as max_id');
    $this->db->select('(SELECT `delete_status` FROM paymentreceipt WHERE id = (SELECT MAX(id) FROM paymentreceipt WHERE invoice_id = ' . $invoice_update_id . ')) as delstatus');
    $this->db->from('paymentreceipt');
    $this->db->where('invoice_id', $invoice_update_id);

    if ($cond != null) {
        // Apply additional condition if provided
        // Here assuming $cond is a field to be checked
        $this->db->where($cond);
    }

  
    $query = $this->db->get();

    $row = $query->row();
    $count = $row->count;
    $delete_status = $row->delstatus;

    if ($count > 0) {
        return array(
            'count' => $count,
            'delete_status' => $delete_status
        );
    } else {
        return array(
            'count' => 0,
            'delete_status' => null
        );
    }


}


public function paymentreceipt_no($id)
{
        $this->db->select('*');
        $this->db->from('paymentreceipt');
        $this->db->where('invoice_id', $id);
        $this->db->where('delete_status', 1);
        return $this->db->get()->row();
}


        /**
        * Get the numeric suffix of the last payment receipt number (value after the final "/") from the paymentreceipt table, or 0 if no receipts exist.
        * @example
        * $last = $this->Base_model->get_last_paymentreceipt_no();
        * echo $last; // e.g. 42
        * @param {void} none - No parameters.
        * @returns {int} Highest numeric suffix of paymentreceipt_no or 0 when no receipts exist.
        */
        public function get_last_paymentreceipt_no() {
            // $this->db->select_max('paymentreceipt_no');
            $this->db->select_max('CAST(SUBSTRING_INDEX(paymentreceipt_no, "/", -1) AS UNSIGNED)', 'max_no');
            $query = $this->db->get('paymentreceipt');
            $last_paymentreceipt_no = $query->row()->max_no;
            
            // print_r($last_paymentreceipt_no);die;
            if ($last_paymentreceipt_no !== null) {
            
                return $last_paymentreceipt_no;
            } else {
                
                return 0;
            }
        }




        /**
         * Prepare the active record (Query Builder) for Payment Receipt datatables.
         *
         * Builds and applies WHERE, GROUP BY and ORDER BY clauses on $this->db based on:
         * - current session (company_email, company_name, user email, user type),
         * - POST filters (firstDate, secondDate, searchDate, searchUser),
         * - global search (POST['search']['value']),
         * - column ordering (POST['order']).
         *
         * The method does not return a value; it mutates $this->db so subsequent
         * list/retrieval methods can execute the prepared query.
         *
         * @example
         * // Example usage inside the model (called before executing the query):
         * // Simulate session and POST inputs:
         * $this->session->set_userdata([
         *   'company_email' => 'acme@example.com',
         *   'company_name'  => 'ACME Ltd',
         *   'email'         => 'jane.doe@acme.com',
         *   'type'          => 'standard',
         *   'create_po'     => '0'
         * ]);
         * $_POST['search'] = ['value' => 'PR-2025-001'];          // global search term
         * $_POST['order']  = [['column' => 0, 'dir' => 'desc']];  // order by paymentreceipt_no desc
         * // Date range example:
         * $_POST['firstDate']  = '2025-01-01';
         * $_POST['secondDate'] = '2025-01-31';
         *
         * // Call the private method within the model context:
         * $this->_get_datatables_query_payment();
         *
         * // Result: $this->db contains a prepared query filtered by session company,
         * // date range, search term and ordering. No direct return; subsequent
         * // methods will run $this->db->get() to fetch rows.
         *
         * @param void No parameters — reads from $this->session and $this->input->post().
         * @returns void Modifies the model's $this->db query builder; does not return a value.
         */
        private function _get_datatables_query_payment()
        {
            $table = 'paymentreceipt';  // Define the table name
            $sort_by = ['paymentreceipt_no', 'org_name', 'owner', 'sub_total', 'pi_status', 'paymentreceipt_date', null];
            $search_by = ['paymentreceipt_no', 'org_name', 'owner', 'sub_total', 'pi_status', 'paymentreceipt_date'];
            $default_order = ['id' => 'desc']; 
            
            // Session data
            $session_comp_email = $this->session->userdata('company_email');
            $session_company = $this->session->userdata('company_name');
            $sess_eml = $this->session->userdata('email');
            
            
            $this->db->from($table);
            $this->db->where('session_comp_email', $session_comp_email);
            $this->db->where('session_company', $session_company);
            $this->db->where('delete_status', 1);

            // Filter by date range
            // Ensure the date handling logic here is properly commenting out/in as per your requirements
            
            // if (!empty($this->input->post('firstDate')) && !empty($this->input->post('secondDate'))) {
            //     $this->db->where('paymentreceipt_date >=', $this->input->post('firstDate'));
            //     $this->db->where('paymentreceipt_date <=', $this->input->post('secondDate'));
            // }


            if($this->input->post('firstDate') < $this->input->post('secondDate')){
           
                $this->db->where('paymentreceipt_date >=',$this->input->post('firstDate'));
                $this->db->where('paymentreceipt_date <=',$this->input->post('secondDate'));
                
            }else if($this->input->post('searchDate')){ 
              $search_date = $this->input->post('searchDate');
            //   print_r($search_date);die;
              if($search_date == "This Week"){
                $this->db->where('paymentreceipt_date >=',date('Y-m-d',strtotime('last monday')));
              }else{
               $this->db->where('paymentreceipt_date >=',$search_date);
              }
            }


            
            

        
            if ($this->input->post('searchUser')) {
                $this->db->where('sess_eml', $this->input->post('searchUser'));
            }


            if ($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po') != '1') {
                $this->db->where('sess_eml', $sess_eml);
            }

        
            if (!empty($this->input->post('search')['value'])) {
                $searchValue = $this->input->post('search')['value'];
                $this->db->group_start();
                foreach ($search_by as $index => $item) {
                    if ($index == 0) {
                        $this->db->like($item, $searchValue);
                    } else {
                        $this->db->or_like($item, $searchValue);
                    }
                }
                $this->db->group_end();

              
            }
            $this->db->group_by('paymentreceipt_no');

            // Order by logic
            if (isset($_POST['order'])) {
                $order_col_index = $_POST['order'][0]['column'];
                $order_dir = $_POST['order'][0]['dir'];
                if (isset($sort_by[$order_col_index])) {
                    $this->db->order_by($sort_by[$order_col_index], $order_dir);
                }
            } else {
                foreach ($default_order as $key => $dir) {
                    $this->db->order_by($key, $dir);
                }
            }
        }


        /**
         * Retrieve payment rows for DataTables with server-side pagination.
         * @example
         * $result = $this->Base_model->getdata_payment();
         * print_r($result); // e.g. array(0 => array('id' => '123', 'amount' => '100.00', 'status' => 'paid'), ...)
         * @param {void} $none - No direct arguments. Pagination is controlled via $_POST['length'] and $_POST['start'].
         * @returns {array} Array of associative arrays representing payment records fetched from the database.
         */
        public function getdata_payment()
        {
            $this->_get_datatables_query_payment();
            if ($_POST['length'] != -1) {
                $this->db->limit($_POST['length'], $_POST['start']);
            }

            $query = $this->db->get();
            $data = $query->result_array();
        // print_r($data);die;
            return $data;
        }



    
    public function save_payment($payment_data) 
    {
        $this->db->insert('payment_receipt', $payment_data);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id(); 
            // return true; 
        } else {
            return false; 
        }
    }


    public function save_bank_data($data) {
         $this->db->insert('payment_receipt_details', $data);
         if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id(); 
            // return true; 
        } else {
            return false; 
        }
    }

    public function save_employee_data($data) {
         $this->db->insert('payment_receipt_details', $data);
         if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id(); 
            return true; 
        } else {
            return false; 
        }
    }

    public function save_other_data($data) {
         $this->db->insert('payment_receipt_details', $data);
         if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id(); 
           
            // return true; 
        } else {
            return false; 
        }
    }

    public function get_Bank_data(){
        $this->db->select('*'); 
        $this->db->from('payment_receipt_details');
        
        return $this->db->get()->result_array(); 
    }
    


    public function add_payment_all($tbl,$data){
    //  print_r($data);die;
        $query=$this->db->insert($tbl,$data);
       
        if($query){
            return 1;
        }
        else{
            return 2;
        }
    }


    /**
     * Retrieves a single payment receipt record by its auto_id, constrained to the current session company/email
     * (or optional overrides provided).
     * @example
     * $result = $this->Base_model->get_paymentreceipt_by_id(123, 'Acme Company', 'billing@acme.com');
     * print_r($result); // sample output: Array ( [auto_id] => 123 [amount] => '100.00' [session_company] => 'Acme Company' [session_comp_email] => 'billing@acme.com' [delete_status] => 1 ... )
     * @param {int} $id - The auto_id of the paymentreceipt record to retrieve.
     * @param {string} $decoded_cnp - Optional company name override; if empty, the session's company_name is used.
     * @param {string} $decoded_ceml - Optional company email override; if empty, the session's company_email is used.
     * @returns {array|null} Associative array of the paymentreceipt row when found, or null/empty when not found.
     */
    public function get_paymentreceipt_by_id($id,$decoded_cnp = '',$decoded_ceml = '')
    {	
        if ($decoded_cnp == '') {
            $session_company = $this->session->userdata('company_name');
        } else {
            $session_company = $decoded_cnp;
        }
        
        if ($decoded_ceml == '') {
            $session_comp_email = $this->session->userdata('company_email');
        } else {
            $session_comp_email = $decoded_ceml;
        }
    
        $this->db->select('*');
        $this->db->from('paymentreceipt');
        $this->db->where('auto_id', $id);
        $this->db->where('delete_status', 1);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
    
        return $this->db->get()->row_array();

    }


    public function delete_paymentreciept_id($id)
    {
        $this->db->set('delete_status', 2);
        $this->db->where('id', $id);
        $this->db->update('paymentreceipt');
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function count_all_payment()
    {
      $session_comp_email = $this->session->userdata('company_email');
      $session_company = $this->session->userdata('company_name');
      $this->db->group_by('paymentreceipt_no');
      $this->db->from('paymentreceipt');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
    }

    public function count_Total_payment()  
    {
        
        $this->db->select_sum('sub_total', 'total_amount');
        $this->db->where('delete_status', 1);
        $this->db->group_by('paymentreceipt_no');
        $query = $this->db->get('paymentreceipt');
        return $query->row()->total_amount;
    }


    public function count_all_pay()
    {
      $this->_get_datatables_query_payment();
      $query = $this->db->get();
      return $query->num_rows();
    }
    public function count_filtered_pay()
    {
      $this->db->from('paymentreceipt');
      $this->db->group_by('paymentreceipt_no');
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
      // print_r($data);die;
    }


    /**
    * Retrieve a single invoice record by ID if it exists and is not marked deleted.
    * @example
    * $result = $this->Base_model->get_invoice_data(123);
    * echo $result->invoice_number; // e.g. "INV-2025-0001"
    * @param int $invoice_id - Invoice record ID to fetch.
    * @returns object|null Returns the invoice row object when found, or null if not found.
    */
    public function get_invoice_data($invoice_id)  
    {
        $this->db->select('*');
        $this->db->from('invoices');
        $this->db->where('delete_status', 1);
        $this->db->where('id', $invoice_id); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row(); 
        } else {
            return null; 
        }
    }


    public function paymentmethod_Data($paymentreceipt_no)
    {
      $this->db->from('paymentreceipt');
      $this->db->where('paymentreceipt_no',$paymentreceipt_no);
      $this->db->where('delete_status', 1);
      $query = $this->db->get();
      return $query->result_array();
    }

    public function paymentmethod_all($paymentreceipt_no)
    {
      $this->db->from('paymentreceipt');
      $this->db->where('paymentreceipt_no',$paymentreceipt_no);
      $this->db->where('delete_status', 1);
      $query = $this->db->get();
      return $query->result_array();
    }

    

   //////////////////////////////////////////////////// monthwise chart for payment receipt graph starts/////////////////////////////////////////////////////////////////////
    
 /**
 * Retrieve monthly payment totals grouped by year and month for the current session's company (and user if standard).
 * @example
 * $this->load->model('Base_model');
 * $result = $this->Base_model->getpaymentgraph();
 * print_r($result);
 * // Sample output:
 * // Array
 * // (
 * //     [0] => stdClass Object
 * //         (
 * //             [year] => 2025
 * //             [month] => 6
 * //             [subtotal] => 12345.67
 * //         )
 * //     [1] => stdClass Object
 * //         (
 * //             [year] => 2025
 * //             [month] => 7
 * //             [subtotal] => 9876.54
 * //         )
 * // )
 * @returns {array|object[]} Array of stdClass objects where each object contains year (int), month (int) and subtotal (float) summed for that month. Returns null if the session type is not handled; on DB errors the error message is echoed.
 */
 public function getpaymentgraph() { 
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('delete_status', 1)
        ->group_by('paymentreceipt_no')
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('paymentreceipt');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
  
   }
   else if($this->session->userdata('type')=='standard'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml', $sess_eml)
    ->where('delete_status', 1)
    ->group_by('paymentreceipt_no')
    ->group_by('year, month')
    ->order_by('year, month')
    ->get('paymentreceipt');
  
     if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
     } else {
    return $query->result();
      }
  
  }
   
  }


  /**
  * Get aggregated monthly expenditure totals grouped by year and month for the current session/company. Uses session data to determine whether to include all company records (admin) or only the current user's records (standard).
  * @example
  * $result = $this->Base_model->getexpansegraph();
  * // Sample output (array of stdClass objects):
  * // [
  * //   (object) ['year' => 2024, 'month' => 5, 'subtotal' => '1234.56'],
  * //   (object) ['year' => 2024, 'month' => 6, 'subtotal' => '789.00']
  * // ]
  * @param void $none - This method accepts no parameters; it reads session values internally.
  * @returns array An array of stdClass objects, each with properties: year (int), month (int) and subtotal (string/decimal) representing the summed expenditures for that year/month.
  */
  public function getexpansegraph() { 
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('delete_status', 1)
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('expenditure');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
  
   }
   else if($this->session->userdata('type')=='standard'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml', $sess_eml)
    ->where('delete_status', 1)
    ->group_by('year, month')
    ->order_by('year, month')
    ->get('expenditure');
  
     if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
     } else {
    return $query->result();
      }
  
  }
   
  }
  
   //////////////////////////////////////////////////// monthwise chart for payment receipt graph ends////////////////
   
   /**
   * Retrieve aggregated credit note totals grouped by year and month for the current session company.
   * @example
   * $result = $this->Base_model->getcreditnotegraph();
   * // Example output:
   * // echo json_encode($result);
   * // [{"year":"2024","month":"1","subtotal":"1234.56"},{"year":"2024","month":"2","subtotal":"789.00"}]
   * @param {void} $none - No parameters required.
   * @returns {array|null} Returns an array of objects (each with properties: year, month, subtotal) on success, or null if a database error occurs.
   */
   public function getcreditnotegraph() { 
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('delete_status', 1)
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('creditnote');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
  
   }
   else if($this->session->userdata('type')=='standard'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml', $sess_eml)
    ->where('delete_status', 1)
    ->group_by('year, month')
    ->order_by('year, month')
    ->get('creditnote');
  
     if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
     } else {
    return $query->result();
      }
  
  }
   
  }


   
  /**
  * Retrieve monthly aggregated debit note subtotals for the current session/company.
  * @example
  * $this->load->model('Base_model');
  * $result = $this->Base_model->getdebitnotegraph();
  * // Example output (array of stdClass):
  * // [
  * //   (object) ['year' => '2025', 'month' => '1', 'subtotal' => '1234.56'],
  * //   (object) ['year' => '2025', 'month' => '2', 'subtotal' => '789.00'],
  * // ]
  * @returns {array|null} Array of stdClass result objects with properties 'year', 'month' and 'subtotal', or null if a database error occurred.
  */
  public function getdebitnotegraph() { 
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('delete_status', 1)
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('debitnote');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
  
   }
   else if($this->session->userdata('type')=='standard'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml', $sess_eml)
    ->where('delete_status', 1)
    ->group_by('year, month')
    ->order_by('year, month')
    ->get('debitnote');
  
     if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
     } else {
    return $query->result();
      }
  
  }
   
  }

  /**
  * Retrieve monthly delivery challan subtotals grouped by year and month for the current session/company.
  * @example
  * $result = $this->Base_model->getchallangraph();
  * print_r($result); // sample output:
  * // Array
  * // (
  * //   [0] => stdClass Object ( [year] => 2025 [month] => 1 [subtotal] => 12345.67 )
  * //   [1] => stdClass Object ( [year] => 2025 [month] => 2 [subtotal] => 9876.50 )
  * // )
  * @param void $none - This method accepts no arguments.
  * @returns array|null Array of stdClass objects with properties 'year' (int), 'month' (int) and 'subtotal' (float/string), or null if a database error occurs.
  */
  public function getchallangraph() { 
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('delete_status', 1)
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('deliverychallan');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
  
   }
   else if($this->session->userdata('type')=='standard'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml', $sess_eml)
    ->where('delete_status', 1)
    ->group_by('year, month')
    ->order_by('year, month')
    ->get('deliverychallan');
  
     if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
     } else {
    return $query->result();
      }
  
  }
   
  }
    
}


