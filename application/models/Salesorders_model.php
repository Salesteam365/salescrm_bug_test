<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Salesorders_model extends CI_Model
{
    
     public function __construct(){
        parent::__construct();
        $this->load->model('Login_model');
        
     }
  var $table = 'salesorder';
  var $sort_by = array(null,'subject','org_name','saleorder_id','owner','status','approved_by','datetime',null);
  var $search_by = array('subject','org_name','saleorder_id','owner','status','approved_by','datetime');
  var $order = array('id' => 'desc');
  
  /**
  * Builds and applies database filters for DataTables queries related to sales orders.
  * @example
  * $result = $this->Salesorders_model->_get_datatables_query('invoice');
  * echo $result // null because the method configures the CI query builder and does not return a value;
  * @param {string} $action - Action or status filter to apply (e.g., 'invoice', 'complete', 50, 100, or '' for no action).
  * @returns {void} Does not return a value; sets up $this->db query builder for subsequent execution.
  */
  private function _get_datatables_query($action='')
  {
		$sess_eml = $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
	
    if($action!=""){
      $this->db->select_sum('sub_totals');
    }
		$this->db->from($this->table);
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
	
    if($this->input->post('searchUser'))
    { 
        $searchUser = $this->input->post('searchUser');
		$this->db->where('sess_eml',$searchUser);
        
    } 
    if($action==""){
      if($this->input->post('searchStatus'))
      { 
        $searchStatus = $this->input->post('searchStatus');
        if($searchStatus==50){
          $this->db->where('total_percent>',0);
          $this->db->where('total_percent<',100);
        }else if($searchStatus=='invoice'){
          $this->db->where('total_percent',0);
          $this->db->where('invoice_id',"");
        }else if($searchStatus==100){
          $this->db->where('total_percent',100);
          $this->db->where('invoice_id',"");
        }else if($searchStatus=='complete'){
          $this->db->where('total_percent',0);
          $this->db->where('invoice_id<>',"");
        }
        
      }
    }else{
      
      if($action==50){
        $this->db->where('total_percent>',0);
        $this->db->where('total_percent<',100);
      }else if($action=='invoice'){
        $this->db->where('total_percent',0);
        $this->db->where('invoice_id',"");
      }else if($action==100){
        $this->db->where('total_percent',100);
        $this->db->where('invoice_id',"");
      }else if($action=='complete'){
        $this->db->where('total_percent',0);
        $this->db->where('invoice_id<>',"");
      }
      
    }
    if($this->input->post('fromDate') && $this->input->post('toDate')){
            $this->db->where('currentdate >=',$this->input->post('fromDate'));
            $this->db->where('currentdate <=',$this->input->post('toDate'));
      }else if($this->input->post('searchDate'))
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
      
      // < ------------------Search data by date --------------------->
        if ($this->input->post('start_date') && $this->input->post('end_date')) {
          $startDate = $this->input->post('start_date');
          $endDate = $this->input->post('end_date');
          // print_r($startDate);die;
          // Apply the date filtering
          $this->db->where('currentdate >=', $startDate);
          $this->db->where('currentdate <=', $endDate);
      }

        // < ------------------Search data by date --------------------->
          if ($this->input->post('searchDateFil')) {
            $search_date_fil = $this->input->post('searchDateFil');
            // $cust_date_filt = DateTime::createFromFormat('Y-m-d', $search_date_fil);
          
            if (!empty($search_date_fil)) {
            // print_r($cust_date_filter);die;

              
                $this->db->like('po_no', $search_date_fil);
            }else{
              
            }
          }
          
          //<--------------------------- New Renew Filter ------------------------->
          if ($this->input->post('new_Renew')) {
            $new_Renew = $this->input->post('new_Renew');
            
            if ($new_Renew === "new") {
                // Match rows that contain only "0" or any format with "0" in it
                $this->db->like('salesorder_item_type', '0');
            } elseif ($new_Renew === "renew") {
                // Match rows that contain only "1" or any format with "1" in it
                $this->db->like('salesorder_item_type', '1');
            }
          }
      
      $this->db->where('delete_status',1);
    
    if($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po')!='1' ) 
      {
      $this->db->where('sess_eml',$sess_eml);
    }
    
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
        // In your Salesorders model, create a method to check if PO number exists
        public function checkPoNumberExists($po_no)
        {
            $this->db->where('po_no', $po_no);
            $query = $this->db->get('salesorder'); // Change 'salesorder' to your actual table name
        
            return $query->num_rows() > 0; // Returns true if exists, false otherwise
        }
  
  
  ///////////////////////////////////// get  data for so graph (monthwise) starts /////////////////////////////////////////////////////////////////

  /**
  * Retrieve aggregated sales order data (last 12 months) grouped by year and month for the current session's company.
  * @example
  * // From a controller:
  * $this->load->model('Salesorders_model');
  * $result = $this->Salesorders_model->getso_graph();
  * // Sample returned value (array of stdClass objects):
  * // [
  * //   (object) ['year' => 2025, 'month' => 12, 'subtotal' => '12345.67', 'profit' => '2345.67'],
  * //   (object) ['year' => 2025, 'month' => 11, 'subtotal' => '9876.54', 'profit' => '1234.56'],
  * // ]
  * @returns {array} An array of stdClass objects each containing year (int), month (int), subtotal (numeric string/float) and profit (numeric string/float). Database errors are echoed directly.*/
  public function getso_graph(){
    $sess_eml = $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
      $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_totals) AS subtotal , SUM(profit_by_user) AS profit')
      ->where('session_comp_email', $session_comp_email)
      ->where('session_company', $session_company)
      ->group_by('year, month') // Group only by 'year' and 'month'
      ->order_by('year, month','desc')
      ->limit(12)
      ->get('salesorder');

  if (!$query) {
      $error = $this->db->error();
      echo "Database Error: " . $error['message'];
  } else {
      return $query->result();
  }
    }
    else if($this->session->userdata('type')=='standard'){
      $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_totals) AS subtotal,SUM(profit_by_user) AS profit')
      ->where('session_comp_email', $session_comp_email)
      ->where('session_company', $session_company)
      ->where('sess_eml', $sess_eml)
      ->group_by('year, month') // Group only by 'year' and 'month'
      ->order_by('year, month','desc')
      ->limit(12)
      ->get('salesorder');

  if (!$query) {
      $error = $this->db->error();
      echo "Database Error: " . $error['message'];
  } else {
      return $query->result();
  }
    }
   
}

   ///////////////////////////////////// get  data for so graph (monthwise) ends /////////////////////////////////////////////////////////////////
/**
* Retrieve up to 12 grouped yearly/monthly aggregate rows for the current session/company, taking session type into account.
* @example
* $result = $this->Salesorders_model->yeargraph('COUNT(id) AS total, YEAR(datetime) AS year, MONTH(datetime) AS month', 'sales_orders');
* print_r($result); // e.g. CI_DB_result object containing up to 12 grouped rows like: [ ['year'=>2025,'month'=>12,'total'=>42], ... ]
* @param {{string|array}} {{$sel}} - Columns or expression(s) to select (string or array). Example: 'COUNT(id) AS total, YEAR(datetime) AS year, MONTH(datetime) AS month'.
* @param {{string}} {{$tbl}} - Table name to query. Example: 'sales_orders'.
* @returns {{CI_DB_result|null}} Return CI_DB_result on success (query result), or null if a database error occurred (an error message is echoed). */
public function yeargraph($sel,$tbl){
  $sess_eml = $this->session->userdata('email');
  $session_comp_email = $this->session->userdata('company_email');
  $session_company = $this->session->userdata('company_name');
 
  if($this->session->userdata('type')=='admin'){
    $query = $this->db->select($sel)
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('datetime!=','0000-00-00')
    ->where('delete_status', 1)
    ->group_by('year, month') // Group only by 'year' and 'month'
    ->order_by('year, month','desc')
    ->limit(12)
    ->get($tbl);

if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
} else {
    return $query;
}
  }
  else if($this->session->userdata('type')=='standard'){
    
    $query = $this->db->select($sel)
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml',$sess_eml)
    ->where('datetime!=','0000-00-00')
    ->where('delete_status', 1)
    ->group_by('year, month') // Group only by 'year' and 'month'
    ->order_by('year, month','desc')
    ->limit(12)
    ->get($tbl);

if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
} else {
    return $query;
}
  }
 
}

   
  public function get_datatables(){
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  
  public function get_datatables_action_value($data){
    $this->_get_datatables_query($data);
    return $this->db->get()->row_array();
  }
  
  
  public function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all()
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from($this->table);
	$this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    return $this->db->count_all_results();
  }
  
   public function check_quot_exist($quotId)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company    = $this->session->userdata('company_name');
    $this->db->from($this->table);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('quote_id',$quotId);
    $this->db->where('delete_status',1);
    return $this->db->count_all_results();
  }
  
  
  /**
  * Retrieve product_name values from the purchaseorder table for the given sale order ID and current session company.
  * @example
  * $soId = 123;
  * $result = $this->Salesorders_model->CountOrder($soId);
  * print_r($result); // e.g. Array ( [0] => stdClass Object ( [product_name] => "Widget A" ) )
  * @param {int|string} $soId - Sale order ID to filter purchase orders.
  * @returns {array} Array of result objects where each object contains the product_name field.
  */
  public function CountOrder($soId)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->select('product_name');
    $this->db->from('purchaseorder');
	$this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('delete_status',1);
    $this->db->where('saleorder_id',$soId);
    $query = $this->db->get();
    return $query->result();
  }
  
  public function get_quote_id($quote_id,$sess_eml,$session_company,$session_comp_email)
  {
    $this->db->like('quote_id', $quote_id , 'both');
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->order_by('currentdate', 'DESC');
    $this->db->limit(5);
    return $this->db->get('quote')->result();
  }
  /**
  * Retrieve quote record(s) for a given quote_id and return the query result as an array.
  * @example
  * $result = $this->Salesorders_model->getQuoteValue(['quote_id' => 123]);
  * print_r($result); // e.g. Array ( [0] => stdClass Object ( [quote_id] => 123 [customer_name] => "ACME Inc." [total] => "150.00" ) )
  * @param {array} $quote_id - Associative array containing the key 'quote_id' with the quote identifier.
  * @returns {array} Array of result objects (empty array if quote_id not provided or no record found).
  */
  public function getQuoteValue($quote_id)
  {
    $response = array();
    if($quote_id['quote_id'])
    {
      $this->db->select('*');
      $this->db->where('quote_id',$quote_id['quote_id']);
      $o = $this->db->get('quote');
      $response = $o->result();
    }
    return $response;
  }
  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }
  
  public function get_data_for_update($id)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from($this->table);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  public function statusSopayment($where,$data,$stts){
   
      $this->db->update($this->table, $data, $where);
      return $stts; 
    
 }
 
 /**
 * Retrieve sales orders marked for renewal within the next 31 days for the current session user (admin sees company-wide, standard sees owned records).
 * @example
 * $result = $this->Salesorders_model->get_renewal_so();
 * // Sample usage and possible output:
 * // If records found:
 * // print_r($result);
 * // Array
 * // (
 * //     [0] => Array
 * //         (
 * //             [id] => 123
 * //             [org_name] => "Example Org"
 * //             [subject] => "Annual Support Renewal"
 * //             [renewal_date] => "2026-01-15"
 * //             [saleorder_id] => "SO-2026-0001"
 * //             [owner] => "John Doe"
 * //             [customer_company_name] => "Example Corp"
 * //         )
 * // )
 * // If no records found:
 * // var_dump($result); // bool(false)
 * @returns {array|false} Returns an array of associative arrays for each renewal sales order when matches exist, or false when none found.
 */
 public function get_renewal_so()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin')
    {
      $start_date = date('Y-m-d');
      $thirty_one = strtotime("31 Day"); // Add thirty one days to start date
      $last_date = date('Y-m-d', $thirty_one); //One Month later date
      $this->db->select('id,org_name,subject,renewal_date,saleorder_id,owner,customer_company_name');
      
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status',1);
      $this->db->where('is_renewal',1);
      $this->db->where('renewal_date >=',$start_date);
      $this->db->where('renewal_date <=',$last_date);
      $this->db->where('end_renewal',0);
    }
    else if($this->session->userdata('type')=='standard')
    {
      $start_date = date('Y-m-d');
      $thirty_one = strtotime("31 Day"); // Add thirty one days to start date
      $last_date = date('Y-m-d', $thirty_one); //One Month later date
      $this->db->select('id,org_name,subject,renewal_date,saleorder_id,owner,customer_company_name');
     
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      //$this->db->where('sess_eml', $sess_eml);
      $this->db->where('owner', $this->session->userdata('name'));
      $this->db->where('delete_status',1);
      $this->db->where('is_renewal',1);
      $this->db->where('renewal_date >=',$start_date);
      $this->db->where('renewal_date <=',$last_date);
      $this->db->where('end_renewal',0);
    } 
    $query = $this->db->get('salesorder');
    //echo $this->db->last_query();die;
    if($query->num_rows() > 0)
    {
      return $query->result_array();
    }
    else
    {
      return false;
    }
  }
  public function update_end_renewal($id)
  {
    $this->db->set('end_renewal',1);
    $this->db->where('id',$id);
    $this->db->update('salesorder');
  }
  
  
  /**
  * Fetch GST tax records for the currently logged-in session company.
  * @example
  * $result = $this->Salesorders_model->get_gst();
  * print_r($result); // Sample output: Array ( [0] => Array ( [id] => 1 [tax_name] => GST [rate] => 18 [session_comp_email] => company@example.com [session_company] => "Acme Corp" [delete_status] => 1 ) )
  * @param void $none - No arguments required.
  * @returns array Array of GST records as associative arrays.
  */
  public function get_gst(){
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->select('*');
    $this->db->from('gst');
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('delete_status',1);
    $this->db->where('tax_name','GST');
    $query = $this->db->get();
    return $query->result_array();
  }
  
  
  public function create($data)
  { //echo"<pre>";print_r($data);die;
    $this->db->insert('salesorder', $data);
    return $this->db->insert_id();
  }
  /**
  * Update records in the sales orders table. Admin users can update any matching rows; non-admin users are restricted to rows with sess_eml equal to their session email.
  * @example
  * $result = $this->Salesorders_model->update(['id' => 123], ['status' => 'shipped']);
  * echo $result; // 1
  * @param {{array|string}} {{$where}} - WHERE clause as an associative array or SQL string to select rows to update.
  * @param {{array}} {{$data}} - Associative array of column => value pairs to update.
  * @returns {{int}} Number of rows affected by the update (db->affected_rows()).
  */
  public function update($where,$data)
  {
    if($this->session->userdata('type') == 'admin')
    {
      $this->db->update($this->table, $data, $where);
    }
    else
    {
      $this->db->where('sess_eml',$this->session->userdata('email'));
      $this->db->update($this->table, $data, $where);
    }
    return $this->db->affected_rows();
  }
  public function delete($id)
  {
    $this->db->set('delete_status',2);
    $this->db->where('id', $id);
    $this->db->update($this->table);
  }
  
  public function ProDuctDelete($soid)
  {
    $this->db->set('delete_status',2);
    $this->db->where('id', $soid);
    $this->db->update('product_wise_profit');
  }
  public function delete_bulk($id)
  {
    $this->db->set('delete_status',2);
    $this->db->where('id', $id);
    $this->db->update($this->table);
  }
  /**
  * Update the saleorder_id field for a sales order record by its primary id.
  * @example
  * $result = $this->Salesorders_model->saleorder_id(12345, 10);
  * var_export($result); // bool(true) on success or bool(false) on failure
  * @param {int} $saleorder_id - New sale order identifier to set.
  * @param {int} $id - ID of the record to update in the sales orders table.
  * @returns {bool} True if the database update succeeded, false otherwise.
  */
  public function saleorder_id($saleorder_id,$id)
  {
    $data = array(
      'saleorder_id' => $saleorder_id,
    );
    $this->db->where('id',$id);
    if($this->db->update($this->table,$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  /**
  * Update the sale order's total_percent field with the provided progress remaining value.
  * @example
  * $result = $this->Salesorders_model->total_percent(85, 432);
  * var_dump($result); // bool(true) on success, bool(false) on failure
  * @param {int|float} $progress_remain - Progress remaining percentage (e.g. 85 or 85.5).
  * @param {int} $saleorder_id - Identifier of the sale order to update (e.g. 432).
  * @returns {bool} True on successful database update, false otherwise.
  */
  public function total_percent($progress_remain,$saleorder_id)
  {
    $data = array
    (
      'total_percent' => $progress_remain,
    );
    $this->db->where('saleorder_id',$saleorder_id);
    if($this->db->update($this->table,$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  /**
  * Update product line for a sale order by its ID.
  * @example
  * $result = $this->Salesorders_model->update_product_line(123, ['status' => 'confirmed', 'quantity' => 10]);
  * echo $result // render some sample output value; // 1 (true) on success, empty/0 (false) on failure
  * @param {int} $saleorder_id - Sale order ID to identify the record to update.
  * @param {array} $dataArr - Associative array of column => value pairs to update.
  * @returns {bool} True if the update succeeded, false otherwise.
  */
  public function update_product_line($saleorder_id,$dataArr)
  {
    
    $this->db->where('saleorder_id',$saleorder_id);
    if($this->db->update($this->table,$dataArr))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  /**
  * Update the status of a sale order record by its ID.
  * @example
  * $result = $this->Salesorders_model->status('shipped', 123);
  * echo $result; // true if the update succeeded, false otherwise
  * @param string $status - New status value to set for the sale order (e.g. 'pending', 'shipped', 'cancelled').
  * @param int $saleorder_id - Identifier of the sale order to update (e.g. 123).
  * @returns bool Return true on successful update, false on failure.
  */
  public function status($status,$saleorder_id)
  {
    $data = array
    (
      'status' => $status,
    );
    $this->db->where('saleorder_id',$saleorder_id);
    if($this->db->update($this->table,$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  /*****Old pdf template*********/
  public function view_old($id)
  {
    $this->db->where('id', $id);
    $data = $this->db->get($this->table);
     
	  foreach($data->result() as $row)
    {
      $output = '<!DOCTYPE html>
      <html>
      <head>
        <title>Team365 | Sales Order</title>
		 <link rel="shortcut icon" type="image/png" href="https://allegient.team365.io/assets/images/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
      </head>
      <body>
        <table width="100%">
            <tr>
              <td colspan="12" style="text-align:center;">
				<h5><b>Sales Order</b></h5>
				<hr style="width: 230px; border: 1px solid #50b1bd; margin-top: 10px;">
			  </td>
            </tr>
			<tr>
				<td colspan="6" style="padding:0px; margin-top:15px; font-size: 12px;">
				  <span><b>'.$this->session->userdata('company_name').'</b></span><br>
				  <span>'.$this->session->userdata('company_address').'</span><br>
				  <span>'.$this->session->userdata('city').',&nbsp;'.$this->session->userdata('state').'&nbsp;'.$this->session->userdata('zipcode').'</span><br>
				  <span><a style="text-decoration:none" href="'.$this->session->userdata('company_website').'">'.$this->session->userdata('company_website').'</a></span><br>
				  <span>'.$this->session->userdata('company_mobile').'</span><br>
				  <span><b>GSTIN:</b>&nbsp;'.$this->session->userdata('company_gstin').'</span><br>
				  <span><b>CIN:</b>&nbsp;'.$this->session->userdata('cin').'</span><br>
				</td>
				<td colspan="6" style="padding:0px 0 0px; text-align:left; font-size: 12px;">
				
				
				   <table>
                     <tr> 
					 <td colspan="2" style="text-align:right">';
					$image = $this->session->userdata('company_logo');
					if(!empty($image))
					{
					$output .=  '<img style="width: 100px;" src="./uploads/company_logo/'.$image.'">';
					}
					else
					{
					$output .=  '<span class="h5 text-primary">'.$this->session->userdata('company_name').'</span>';
					}
					$output .= '
				   </td>
                     </tr>
                    <tr><td colspan="2">
                    <span style="font-weight: bold;">SALES ORDER ID : </span>&nbsp;<span>'.$row->saleorder_id.'</span><br>
        			<b>DATE : </b><span >'.date('d-M-Y').'</span><br>
						<b>VALID UNTIL : </b><span>'.date('d-M-Y',strtotime($row->due_date)).'</span>
                        </td>
                        </tr>
                    </table>
				
				</td>
            </tr>
			<tr>
				<td colspan="6" style="padding:30px 0 40px; font-size: 12px;"> 
				  <b>ADDRESS :- </b><br>
				  <span class="h6 text-primary">'.$row->org_name.'</span><br>
				  <b>CONTACT&nbsp;PERSON</b> :&nbsp;<span>'.$row->contact_name.'</span><br>
				  <span style="white-space: pre-line" style=" word-wrap: break-word; white-space: -moz-pre-wrap; white-space: pre-wrap;" >'.$row->billing_address.'</span>,
				  <span>'.$row->billing_state.'</span><br>
				  <span>'.$row->billing_city.'</span>&nbsp;,<span>'.$row->billing_zipcode.'</span>&nbsp;,<span>'.$row->billing_country.'</span><br>
				
				</td>

				<td colspan="6" style="padding:30px 0 40px; text-align:left; font-size: 12px;">
					<b>Place Of supply</b> : 
					<span>'.$row->billing_state.'</span><br>
					<b>Sales Person</b> : 
					<span>'.$row->owner.'</span><br>
					<b>Sales Person Mob</b> : 
					<span>'.$this->session->userdata('mobile').'</span><br>
					
				</td>
			</tr>
			
        </table>  

        <table class="table-responsive-sm table-striped text-center table-bordered" style="width:100% !important;">
            <thead style="background: #50b1bd; color: #fff; font-size: 12px;">
                <tr>
                    <th>S.No.</th>
                    <th>Product/Services</th>
                    <th>HSN/SAC</th>
                    <th>SKU</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Tax</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody style="background: #f5f5f5; color: #000000; font-weight: 500; font-size: 12px;">';
				$product_name = explode("<br>",$row->product_name);
				$quantity = explode("<br>",$row->quantity);
				$unit_price = explode("<br>",$row->unit_price);
				$total = explode("<br>",$row->total);
				$sku = explode("<br>",$row->sku);
				$hsnsac = explode("<br>",$row->hsn_sac);
				if(!empty($row->gst)){
				  $gst = explode("<br>",$row->gst);
				}
				$arrlength = count($product_name);
				$arrlength = count($product_name);
				for($x = 0; $x < $arrlength; $x++){
					$num = $x + 1;
					$output .='<tr>
						<td style="padding:5px; 0px;">'.$num.'</td>
						<td style="padding:5px; 0px;">'.$product_name[$x].'</td>
						<td style="padding:5px; 0px;">'.$hsnsac[$x].'</td>
						<td style="padding:5px; 0px;">'.$sku[$x].'</td>
						<td style="padding:5px; 0px;">'.$quantity[$x].'</td>
						<td style="padding:5px; 0px;">'.IND_money_format($unit_price[$x]).'</td>';
						if(!empty($gst)){
						  $output .='<td style="padding:5px; 0px;">GST@'.$gst[$x].'%</td>';
						}else{
						  $output .='<td style="padding:5px; 0px;">GST@18%</td>';
						}
						  $output .='<td style="padding:5px; 0px;">'.IND_money_format($total[$x]).'/-</td>
					</tr>';		
			    }
                $output .='
            </tbody>
        </table>

        <table width="100%; margin-top:20px; border:1px; margin-bottom:20px;" >
            <tr>
				<td colspan="6" style="font-size: 12px;">
					<span class="h6">Terms And Conditions :-</span><br>
					<span style="white-space: pre-line;font-size: 10px;"></span><br>
					<span>'.nl2br($row->terms_condition).'</span><br>';
					if(!empty($row->customer_company_name) && !empty($row->customer_address))
					{
						$output .='<hr>
						<span class="h6">CUSTOMER DETAILS (IF REQUIRED)</span><br>
						<span style="white-space: pre-line;font-size: 10px;"></span><br>';
						  if(!empty($row->customer_company_name))
						  {
						  $output .='<span>Name:&nbsp;'.ucfirst($row->customer_company_name).'</span><br>';
						  }
						  if(!empty($row->customer_address))
						  {
						  $output .='<span>Address :&nbsp;'.ucwords($row->customer_address).'</span><br>';
						  }
						  if(!empty($row->customer_name))
						  {
						  $output .='<span>Contact Person :&nbsp;'.ucfirst($row->customer_name).'</span><br>';
						  }
						  if(!empty($row->customer_email))
						  {
						  $output .='<span>E-mail :&nbsp;'.$row->customer_email.'</span><br>';
						  }
						  if(!empty($row->customer_mobile))
						  {
						  $output .='<span>Contact&nbsp;No :&nbsp;'.$row->customer_mobile.'</span>';
						  }
						  $output .='
						<hr>';
					 }
					$output .='
				</td>
				<td colspan="2">
				</td>
				<td colspan="4" style="padding:3px;">
					<table class="float-right" style="margin-top:20px; border: 1px solid #ffffff; font-size:12px;">
						<tr style="line-height:35px;">
							<td style="padding:0px;">
							<b>Initial Total:</b></td>
							<td style="padding:0px;"><span class="float-right" id="">'.IND_money_format($row->initial_total).'/-</span></td>
						</tr>
						<tr style="line-height:35px;">
							<td style="padding:0px;"><b>Discount:</b></td>
							<td style="padding:0px;"><span class="float-right" id="">'.$row->discount.'/-</span></td>
						</tr>
						<tr style="line-height:35px;">
							<td style="padding:0px;"><b>After Discount:</b></td>
							<td style="padding:0px;"><span class="float-right" id="">'.IND_money_format($row->after_discount).'/-</span></td>
						</tr>';
							
							$type = $row->type;
							if($type == "Interstate")
							{
							  if($row->igst12 != '0' && $row->igst18 != '0' && $row->igst28 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst12).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst18).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst28).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 != '0' && $row->igst18 == '0' && $row->igst28 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst12).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 == '0' && $row->igst18 != '0' && $row->igst28 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst18).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 == '0' && $row->igst18 == '0' && $row->igst28 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst28).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 != '0' && $row->igst18 != '0' && $row->igst28 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst12).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst18).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 == '0' && $row->igst18 != '0' && $row->igst28 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst18).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst28).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 != '0' && $row->igst18 == '0' && $row->igst28 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst12).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst28).'/-</span></td></tr>';
							  }
							}
							else if($type == "Instate")
							{
							  if($row->cgst6 != '0' && $row->cgst9 != '0' && $row->cgst14 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst14).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst14).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 != '0' && $row->cgst9 == '0' && $row->cgst14 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst6).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 == '0' && $row->cgst9 != '0' && $row->cgst14 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst9).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 == '0' && $row->cgst9 == '0' && $row->cgst14 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst14).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst14).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 != '0' && $row->cgst9 != '0' && $row->cgst14 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst9).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 == '0' && $row->cgst9 != '0' && $row->cgst14 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst14).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst14).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 != '0' && $row->cgst9 == '0' && $row->cgst14 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst14).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst14).'/-</span></td></tr>';
							  }
							}
							else
							{
							$output .='<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;">'.IND_money_format($row->igst18).'/-</td></tr>';
							}
							
							$output .='
						<tr style="line-height:35px;">
							<td style="padding:0px; " class="bg-info text-white"><b>Sub Total:</b></td>
							<td style="padding:0px; border-right: 1px solid #17a2b8;" class="bg-info text-white"><b>INR '.IND_money_format($row->sub_totals).'/-</b></td>
						</tr>
					</table>
				</td>
        </tr>
			
        </table>
        <br>
       
        <table width="100%" style="position:fixed; bottom:80px; page-break-inside:avoid; page-break-after:auto; font-size:11px;">

          <tr>
            <td style="width:70%">
			<b>Accepted By</b><br>
			<b>Accepted Date</b> : '.date('d F Y').'
			
			<td colspan="3">
			</td>
			<td style="width:30%">
    			<table>
    			<tr>
    			<td>
    			<b>SO Created By</b> : </td><td>'.ucfirst($row->owner).'</td>
    			</tr>
    			<tr>
    			<td>
    			<b>SO Created Date</b> : </td><td>'.date("d F Y", strtotime($row->datetime)).'</td></tr>
    			</table>
			</td>
          </tr>
		 
		  
        </table>

        <footer>
        <div style="position: fixed;bottom: 8;">
          <center>
		  <span style="font-size:12px"><b>"This is System Generated SO Sign and Stamp not Required"</b></span><br>
          <b><span style="font-size: 10px;">E-mail - '.$this->session->userdata('company_email').'</br>
             | Ph. - +91-'.$this->session->userdata('company_mobile').'</br>
              | GSTIN: '.$this->session->userdata('company_gstin').'</br>
               | CIN: '.$this->session->userdata('cin').'</span></b>
          </center>
        </div>
        </footer>
      </body>
      </html>';
    }
     return $output;
  }
  
  /********new pdf template*****/
  public function view($id)
  {
   
    $this->db->where('id', $id);
   
    $data = $this->db->get($this->table);
     
	  foreach($data->result() as $row)
      {
        $admin_details = $this->Login_model->get_company_details($row->session_company,$row->session_comp_email);  
        $output = '<!DOCTYPE>
              <html>
              <head>
                <title>Team365 | Salesorder</title>
                <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
                <style>
                 @page{
                      margin-top: 30px; /* create space for header */
                    }
                    footer .pagenum:before {
                        content: counter(page, decimal);
                    }
                </style>
              </head>
        
              <body style="font-family: Quicksand, sans-serif;" >
              
               
              
              <main style="margin-bottom:30px;"> 
              <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                       <td>
                         <h3 style="color: #6539c0; margin-top:0px;margin-bottom: -5px;">Salesorder</h3>
                         <p style="margin-bottom: 0;font-size: 12px;"><text style="color: #9c9999;display:inline-block; width:25%;">Salesorder No#</text><text style="display:inline-block;"> '.$row->saleorder_id.'</text> <br>
                        <text style="color: #9c9999; display:inline-block; width:25%;"> Salesorder Date: </text><text style="display:inline-block;"> '.date("d F Y", strtotime($row->datetime)).'</text></p>
                       </td>
                       <td colspan="2" style="text-align:right">';
        					$image = $admin_details["company_logo"];
                 
        					if(!empty($image))
        					{
        					$output .=  '<img style="width: 70px;" src="'.base_url().'/uploads/company_logo/'.$image.'">';
                
        					}
        					else
        					{
        					$output .=  '<span class="h5 text-primary">'. $admin_details["company_name"].'</span>';
        					}
        					$output .= '
        				</td>
                    </tr>
                 </tbody>
                </table>
                 <table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
                
                    <tr>
                       <td style="width: 49.5%; padding: 10px; vertical-align: top;">
                          
                            <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Salesorder From</h4>
                            <p style="margin: 0;font-size: 14px;">'.$admin_details["company_name"].'</p>
        					
                           ';
                          if($admin_details["company_address"]!=""){
                          $output .=  ' <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">'.$admin_details["company_address"];
                          }
                          if($admin_details["city"]!=""){
                          $output .=  ', '.$admin_details["city"];
                          }
                          if($admin_details["zipcode"]!=""){
                          $output .=  ' - '.$admin_details["zipcode"];
                          }
                          if($admin_details["state"]!=""){
                          $output .=  ', '.$admin_details["state"];
                          }
                          
                          if($admin_details["country"]!=""){
                          $output .=  ', '.$admin_details["country"];
                          }
                          $output .=  '</p>
                          <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;"><b>Email:</b> '.$admin_details["company_email"].' <br>
                          <b>Phone:</b> +91-'.$admin_details["company_mobile"].'</p>
                          
                          
                       </td>
                       <td style="width: 1%; background:#fff;"></td>
                       <td style="width: 49.5%; padding: 10px; vertical-align: top;">
                       
                          <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Salesorder For</h4>
                          <p style="margin: 0;font-size: 12px;">'.
        				  $row->org_name;
        				  
                           $output .= '</p>
                            
                          <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">';
                          
                          if(!empty($row->billing_address)){
                           $output .= $row->billing_address;
                          }
                          if(!empty($row->billing_city)){
                           $output .= ', '.$row->billing_city;
                          }
                          if(!empty($row->billing_zipcode)){
                           $output .= ' - '.$row->billing_zipcode;
                          }
                          if(!empty($row->billing_state)){
                           $output .= ', '.$row->billing_state;
                          }
                          if(!empty($row->billing_country)){
                           $output .= ', '.$row->billing_country;
                          }
                           $output .= '</p>';
                          if(!empty($row->contact_name)){
                          $output .= '<p style="margin-bottom: 0;font-size: 12px;margin-top: 0px;><text style="font-size:12px;">
                            <b>Contact Name :</b> '.$row->contact_name."</text></p>";
                           }
                          if(isset($row->customer_email)){
                          $output .= '<p style="margin-bottom: 0;font-size: 12px;margin-top: 0px;"><b>Email:</b>'.$row->customer_email;
                            }
                       $output .= '</td>
                     </tr>
                </table>
                <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                      <td align="left" style="font-size:12px;width: 49.5%; ">
                        <p><b>Country of Supply : </b>'.$row->billing_country.'</p>
                      </td>
                      <td></td>
                      <td align="left" style="font-size:12px;width: 49.5%;">
                        <p><b>Place of Supply : </b>'.$row->billing_state.'</p>
                      </td>
                    </tr>
                 </tbody>
                </table>';
				$pro_discount = explode("<br>",$row->pro_discount);
				$totalDiscpunt= array_sum($pro_discount);
                $output .='<table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; border-radius:7px; background: #efebf9;">
                   <thead style="color: #fff;" align="left">
                    <tr>
                       <th width="30%" style="font-size: 12px;">
                        <div style="background: #6539c0;border-top-left-radius: 7px; padding: 11px;">
                       Product/Services</div></th>
                       <th><div style="font-size: 12px; background: #6539c0; padding: 11px;">HSN/SAC</div></th>
                       <th><div style="font-size: 12px; background: #6539c0; padding: 11px;">SKU</div></th>
                       <th><div style="font-size: 12px; background: #6539c0; padding: 11px;">Qty</div></th>
                       <th><div style="font-size: 12px; background: #6539c0; padding: 11px;">Rate</div></th>';
					   if($totalDiscpunt>0){
                       $output .='<th><div style="font-size: 12px; background: #6539c0; padding: 11px;">Discount</div></th>';
					   }
                       $output .='
                       <th><div style="font-size: 12px; background: #6539c0; padding: 11px;">Tax</div></th>
                       <th style="font-size: 12px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 11px;">Amount</div></th>
                       
                     </tr>
                   </thead>
                   <tbody >';
                   
                        $product_name = explode("<br>",$row->product_name);
        				$quantity = explode("<br>",$row->quantity);
        				$unit_price = explode("<br>",$row->unit_price);
        				$total = explode("<br>",$row->total);
        				$sku = explode("<br>",$row->sku);
        				$hsnsac = explode("<br>",$row->hsn_sac);
        				if(!empty($row->gst)){
        				  $gst = explode("<br>",$row->gst);
        				}
						$proDesc = explode("<br>",$row->pro_description);
        				$arrlength = count($product_name);
        			
						$initTot=0;
        				$rw=0;
        				for($x = 0; $x < $arrlength; $x++){
        				
        					$num = $x + 1;
        					$output .='<tr >
        						
        						<td style="font-size: 12px; padding:10px;border-top: 1px solid #dee2e6;">'.$product_name[$x].'</td>
        						
        						<td style="font-size: 12px;border-top: 1px solid #dee2e6;">'.$hsnsac[$x].'</td>
        						<td style="font-size: 12px;border-top: 1px solid #dee2e6;">'.$sku[$x].'</td>
        						<td style="font-size: 12px;border-top: 1px solid #dee2e6;">'.$quantity[$x].'</td>
        						<td style="font-size: 12px;border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($unit_price[$x]).'</td>';
								if($totalDiscpunt>0){
								$output .='<td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($pro_discount[$x]).'</td>';
								}
								
        						if(!empty($gst)){
        						  $output .='<td style="font-size: 12px; border-top: 1px solid #dee2e6;">GST@'.$gst[$x].'%</td>';
        						}else{
        						  $output .='<td style="font-size: 12px; border-top: 1px solid #dee2e6;">GST@18%</td>';
        						}
        						
        						  $output .='<td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($total[$x]).'</td>
        					</tr>';
							if(isset($proDesc[$x]) && $proDesc[$x]!=""){	
							$output.='<tr style="background: #efebf9;" >
									<td colspan="7" style="font-size: 12px; padding:10px;">'.$proDesc[$x].'</td></tr>';
							}

							$initTot=$initTot+$total[$x];	
        			    }
        			  
                        $output .='
                  </tbody>
                </table>
        
                <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
                  <tbody>
                    <tr>
                    <td align="left" width="60%" style="position: relative;">
                      <p style="font-size:12px;"><b>Total in words:</b> <text> '.AmountInWords($row->sub_totals).' only</text></p>';
                    
                      
                    if(!empty($row->customer_company_name))
                    {
               
                        $output .='<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a; font-size:12px;padding:7px;">
                               <tr>
                                <td colspan="3">
                                 
                                    <h5 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0; font-size:13px;">Customer Details (If Required)</h5>
                                </td>
                               </tr';
                                if($row->customer_company_name!=""){
                                $output .= '<tr>
                                   <th style="text-align:left; padding-left:10px;">  Name:  <th>
                                   <td>'.ucfirst($row->customer_company_name).'</td>
                               </tr>';
                                }
                               if($row->customer_address!=""){
                                $output .= '<tr>
                                   <th style="text-align:left; padding-left:10px;">  Address:  <th>
                                   <td>'.ucfirst($row->customer_address).'</td>
                               </tr>';
                               }
                               if($row->customer_name!=""){
                                $output .= '<tr>
                                   <th style="text-align:left; padding-left:10px;">  Contact Person:  <th>
                                   <td>'.ucfirst($row->customer_name).'</td>
                               </tr>';
                               }
                               if($row->customer_email!=""){
                                $output .= '<tr>
                                   <th style="text-align:left; padding-left:10px;">  E-mail:  <th>
                                   <td>'.$row->customer_email.'</td>
                               </tr>';
                               }
                                if($row->customer_mobile!="" && $row->customer_mobile!="0"){
                                $output .= '<tr>
                                   <th style="text-align:left; padding-left:10px;"> Contact No: <th>
                                   <td>'.$row->customer_mobile.'</td>
                               </tr>';
                                }
                                if($row->microsoft_lan_no!=""){
                                $output .= '<tr>
                                   <th style="text-align:left;  padding-left:10px;">Licence No.:<th>
                                   <td>'.$row->microsoft_lan_no.'</td>
                               </tr>';
                                }
                                
                                 $output .= '
                             
                        </table>';
                   
                   }
                    
                    
                     $output .='</td>
                    <td align="" width="20%" style="text-align:right;">
                      <table align="" width="100%" style="text-align:right;position: absolute;top: 0px;">
                        <tbody>';
						
							if(($row->overall_discount)>0){
						   $output .='<tr>
                            <th style="font-size: 12px;" align="left">Amount</th>';
        
                             $output .='<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($initTot).'</td>';
							 
                           $output .='</tr>
						  <tr>
                            <th style="font-size: 12px;" align="left">Over All Discount</th>';
							 if($row->discount_type=='in_percentage'){ 
								$output .='<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->overall_discount).'%</td>';
							 }else{
								$output.='<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->overall_discount).'</td>'; 
							 }
							}
                           $output .='</tr>
                          <tr>
                            <th style="font-size: 12px;" align="left">Initial Amount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->initial_total).'</td>
                          </tr>';
						  if($row->discount>0){
                          $output .='
                          <tr>
                            <th style="font-size: 12px;" align="left">Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$row->discount.'</td>
                          </tr>';
						  }
                           $output .='<!--<tr>
                            <th style="font-size: 12px;" align="left">After Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->after_discount).'</td>
                          </tr>-->';
                          
                          $type = $row->type;
        							if($type == "Interstate")
        							{
        							  if($row->igst12 != '0' && $row->igst18 != '0' && $row->igst28 != '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">IGST@12%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst12).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst18).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">IGST@28%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst28).'</td></tr>';
        							  }
        							  elseif($row->igst12 != '0' && $row->igst18 == '0' && $row->igst28 == '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">IGST@12%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst12).'</td></tr>';
        							  }
        							  elseif($row->igst12 == '0' && $row->igst18 != '0' && $row->igst28 == '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst18).'</td></tr>';
        							  }
        							  elseif($row->igst12 == '0' && $row->igst18 == '0' && $row->igst28 != '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">IGST@28%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst28).'</td></tr>';
        							  }
        							  elseif($row->igst12 != '0' && $row->igst18 != '0' && $row->igst28 == '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">IGST@12%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst12).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst18).'</td></tr>';
        							  }
        							  elseif($row->igst12 == '0' && $row->igst18 != '0' && $row->igst28 != '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst18).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">IGST@28%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst28).'</td></tr>';
        							  }
        							  elseif($row->igst12 != '0' && $row->igst18 == '0' && $row->igst28 != '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">IGST@12%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst12).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">IGST@28%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst28).'</td></tr>';
        							  }
        							}
        							else if($type == "Instate")
        							{
        							  if($row->cgst6 != '0' && $row->cgst9 != '0' && $row->cgst14 != '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">CGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst6).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst6).'</td></tr>
        							<tr"><th style="font-size: 12px;" align="left">CGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst9).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst9).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">CGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst14).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst14).'</td></tr>';
        							  }
        							  elseif($row->cgst6 != '0' && $row->cgst9 == '0' && $row->cgst14 == '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">CGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst6).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst6).'</td></tr>';
        							  }
        							  elseif($row->cgst6 == '0' && $row->cgst9 != '0' && $row->cgst14 == '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">CGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst9).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst9).'</td></tr>';
        							  }
        							  elseif($row->cgst6 == '0' && $row->cgst9 == '0' && $row->cgst14 != '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">CGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst14).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst14).'</td></tr>';
        							  }
        							  elseif($row->cgst6 != '0' && $row->cgst9 != '0' && $row->cgst14 == '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">CGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst6).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst6).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">CGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst9).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst9).'</td></tr>';
        							  }
        							  elseif($row->cgst6 == '0' && $row->cgst9 != '0' && $row->cgst14 != '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">CGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst9).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst9).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">CGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst14).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst14).'</td></tr>';
        							  }
        							  elseif($row->cgst6 != '0' && $row->cgst9 == '0' && $row->cgst14 != '0')
        							  {
        							$output .='
        							<tr><th style="font-size: 12px;" align="left">CGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->cgst6).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst6).'</td></tr>
        							<tr><th>CGST@14%:</th><td style="font-size: 12px;">'.IND_money_format($row->cgst14).'</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sgst14).'</td></tr>';
        							  }
        							}
        							else
        							{
        							//$output .='<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst18).'</td></tr>';
        							}
									if($row->total_igst>0){
										$output .='<tr><th style="font-size: 12px;" align="left">IGST:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->total_igst).'</td></tr>';
									}
									if($row->total_cgst>0){
										$output .='<tr><th style="font-size: 12px;" align="left">CGST:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->total_cgst).'</td></tr>';
									}
									if($row->total_sgst>0){
										$output .='<tr><th style="font-size: 12px;" align="left">SGST:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->total_sgst).'</td></tr>';
									}
									
								if(isset($row->extra_charge_label) && !empty($row->extra_charge_label)){
								$labelExra=explode("<br>",$row->extra_charge_label);
								$valueExra=explode("<br>",$row->extra_charge_value);
								if(count($labelExra)>0){
									for($i=0; $i<count($labelExra); $i++){
										$output .='<tr><th style="font-size: 12px;" align="left">'.$labelExra[$i].':</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($valueExra[$i]).'</td></tr>';
									}
								}
								}
        						
                          $output .='
                          <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
                          <tr>
                          
                            <th style="font-size: 12px;" align="left">TOTAL</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sub_totals).'</td>
                          </tr>
                        </tbody>
                        
                      </table>
                    </td>
                  </tr>
                  </tbody>
                </table>';
        
                $output .='<table width="60%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-top:';
                    if(!empty($row->customer_company_name)){ 
                        $output .='0px;">';
                        
                    }else{ 
                        $output .='-20px;">'; 
                        
                    }
                    $output .='<tbody>
                    <tr>
                  <td align="left">
                    <h4 style="color: #6539c0;margin-top:-3px;">Terms and Conditions</h4>
                    <ol style="padding: 0 15px; font-size:12px;">';
                     $custTerm=explode("<br>",$row->terms_condition); $no=1;
					 for($i=0; $i<count($custTerm); $i++){ 
					   $output .='<li>'.$custTerm[$i].'</li>'; 
					 }
                      //'.nl2br($row->terms_condition).'
                    $output .='</ol>
                  </td>
                </tr>
                  </tbody>
                </table>
        
              </main>
              <footer style=" border-top:1px dashed #333;" >
              <div class="pagenum-container"style="text-align:right;font-size:12px;">Page <span class="pagenum"> </span>of TPAGE</div>
              <center>
          <span style="font-size:12px;"><b>"This is System Generated SO, Sign and Stamp not Required"</b></span><br>
                <b><span style="font-size: 10px;">E-mail - '.$admin_details["company_email"].'</br>
                    | Ph. - +91-'.$admin_details["company_mobile"].'</br>
                    | GSTIN: '.$admin_details["company_gstin"].'</br>
                    | CIN: '.$admin_details["cin"].'</span></b> <br>
                <b><span style="font-size:12px;">Powered By <a href="https://team365.io/" >Team365 CRM</a></span></b>
              </center>
            
            </footer>
              </body>
              </html>';  
         
    }
	 
   return  $output;
  }
  
  /**
  * Get pending purchase orders (sales orders with status 'Pending' and due_date >= today) for the current session company/user.
  * @example
  * $this->load->model('Salesorders_model');
  * $result = $this->Salesorders_model->get_pending_purchaseorder();
  * // Possible sample output:
  * // $result = [
  * //   ['id' => 12, 'order_no' => 'PO-2025-001', 'status' => 'Pending', 'due_date' => '2025-12-20', 'session_company' => 'Acme Ltd', 'session_comp_email' => 'billing@acme.com', ...],
  * //   ['id' => 15, 'order_no' => 'PO-2025-002', 'status' => 'Pending', 'due_date' => '2025-12-25', 'session_company' => 'Acme Ltd', 'session_comp_email' => 'billing@acme.com', ...],
  * // ];
  * @param {void} None - This method uses session data and accepts no arguments.
  * @returns {array|false} Returns an array of pending purchase orders (associative arrays) if found, or false if no matching records exist.
  */
  public function get_pending_purchaseorder()
  {
    if($this->session->userdata('type') == 'admin')
    {
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->select('*');
        $this->db->from('salesorder');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('delete_status',1);
        $this->db->where('status','Pending');
        $this->db->where('due_date >=',date('Y-m-d'));
       
        //  $this->db->order_by('id', 'DESC');
      
      
    }
    else if($this->session->userdata('type')=='standard')
    {
     
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->select('*');
        $this->db->from('salesorder');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('sess_eml',$sess_eml);
        $this->db->where('delete_status',1);
        $this->db->where('status','Pending');
        $this->db->where('due_date >=',date('Y-m-d'));
        
        // $this->db->order_by('id', 'DESC');
      
    }
    
    $query = $this->db->get();
    // echo $this->db->last_query();die;
    if($query->num_rows() > 0)
    {
      return $query->result_array();
    }
    else
    {
      return false;
    }
  }
  /**
  * Get pending sales orders filtered by date for the current session user (admin or standard).
  * @example
  * $result = $this->Salesorders_model->get_pending_salesorder('15 days');
  * print_r($result); // Example output: Array ( [0] => Array ( ['id'] => 123, ['order_no'] => 'SO-001', ['status'] => 'Pending', ['currentdate'] => '2025-12-10' ) )
  * @param {string} $filter_date - Date filter: '15 days' for last 15 days, a 'YYYY-MM-DD' date to fetch orders on/after that date, or "null" to disable date filtering.
  * @returns {array|false} Returns an array of pending sales orders (associative arrays) when found, or false if none exist.
  */
  public function get_pending_salesorder($filter_date)
  {
    if($this->session->userdata('type') == 'admin')
    {
      if($filter_date != "null")
      {
        $date = date('Y-m-d');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->select('*');
        $this->db->from('salesorder');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('delete_status',1);
        $this->db->where('status','Pending');
        if($filter_date=="15 days")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime("-15 Day")));
        }
        else if($filter_date != "null")
        {
          $this->db->where('currentdate >=',$filter_date);
        }
      }
      
    }
    else if($this->session->userdata('type')=='standard')
    {
      if($filter_date != "null")
      {
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->select('*');
        $this->db->from('salesorder');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('sess_eml',$sess_eml);
        $this->db->where('delete_status',1);
        $this->db->where('status','Pending');
        if($filter_date == '15 days')
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime("-15 Day")));
        }
        else if($filter_date != "null")
        {
          $this->db->where('currentdate >=',$filter_date);
        }
      }
    }
    
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    if($query->num_rows() > 0)
    {
      return $query->result_array();
    }
    else
    {
      return false;
    }
  }
  
  
	public function addProductProfit($data){
		$this->db->insert('product_wise_profit', $data);
		return $this->db->last_query();
	}
  
  /**
  * Update a product_wise_profit row for the current session/company using provided data.
  * @example
  * $data = array('profit' => 150.75, 'product_id' => 45, 'updated_at' => '2025-12-17 10:00:00');
  * // from a controller or other model:
  * $this->Salesorders_model->goForUpdate($data, 123);
  * // This will attempt to update the record with id = 123 for the logged-in user's session/company.
  * @param {array} $dtatArr - Associative array of column => value pairs to update (e.g. ['profit' => 150.75]).
  * @param {int|string} $id - Primary key id of the record to update.
  * @returns {void} Performs the database update; does not return a value.*/
  public function goForUpdate($dtatArr,$id)
  {
	    $sess_eml 			= $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company 	= $this->session->userdata('company_name');
		if($this->session->userdata('type')=='standard')
		{
			$this->db->where('sess_eml',$sess_eml);
		}
	  $this->db->where('id',$id);
	  $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
	  $this->db->update('product_wise_profit',$dtatArr);
	  
  } 
 
		 
    /**
    * Check whether a product entry exists in product_wise_profit for a given sale order and product name for the current session/company.
    * @example
    * $result = $this->Salesorders_model->checkForUpdate(123, 'Widget A');
    * var_export($result); // sample output: array(0 => array('id' => '45')) or false
    * @param {int|string} $saleorder_id - Sale order ID to search for (e.g. 123).
    * @param {string} $productName - Product name to search for (e.g. 'Widget A').
    * @returns {array|false} Returns result array when a matching record exists, otherwise false.
    */
    public function checkForUpdate($saleorder_id,$productName){
		    $sess_eml	= $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company 	= $this->session->userdata('company_name');
        $this->db->select('id');
        $this->db->from('product_wise_profit');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
		if($this->session->userdata('type')=='standard')
		{
			$this->db->where('sess_eml',$sess_eml);
		}
		$this->db->where('so_id',$saleorder_id);
		$this->db->where('pro_name',$productName);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
		  return $query->result_array();
		}
		else
		{
			return false;
			
		}
	}
  
  
 /**
 * Counts the number of invoices for a given sale order within the current session's company context.
 * @example
 * $result = $this->Salesorders_model->CountInvoice(123);
 * echo $result; // e.g. 5
 * @param {int|string} $saleorder_id - Sale order identifier to count invoices for.
 * @returns {int} Number of matching invoices (rows) for the provided sale order and current session company.
 */
	public function CountInvoice($saleorder_id){
		    $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company 	= $this->session->userdata('company_name');
        $this->db->select('id');
        $this->db->from('invoices');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('saleorder_id',$saleorder_id);
        $this->db->where('delete_status',1);
        $query = $this->db->get();
        return $query->num_rows();
	}
  

   /**
   * Get purchase team members for a given module based on the current session company and email.
   * @example
   * $result = $this->Salesorders_model->getuserPurchaseTeam('purchase');
   * print_r($result); // Array ( [0] => Array ( [user_id] => 5 [user_email] => 'purchasing@example.com' ) )
   * @param {string} $moduleName - Module name to filter user restrictions (e.g. 'purchase').
   * @returns {array|false} Returns an array of user rows (user_id, user_email) when found, or false if none.
   */
   public function getuserPurchaseTeam($moduleName){
        $session_comp_email = $this->session->userdata('company_email');
        $session_company 	= $this->session->userdata('company_name');
        $this->db->select('user_id,user_email');
        $this->db->from('user_restriction');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('module_name',$moduleName);
        $this->db->where('other',1);
        $query = $this->db->get();
		if($query->num_rows() > 0){
		  return $query->result_array();
		}else{
			return false;
		}
	}

//< ----------------- Mass Update --------------------------- >
  public function mass_save($mass_id, $dataArry)
  {
    $this->db->where('id', $mass_id);
    if($this->db->update('salesorder', $dataArry)){
		  return true;
		}else{
      return false;
    }
  }


  
  
}
?>
