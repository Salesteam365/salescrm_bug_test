<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Aifilters_model extends CI_Model
{

  var $table = 'salesorder';
  var $sort_by = array(null,'subject','org_name','saleorder_id','owner','status','approved_by','datetime',null);
  var $search_by = array('subject','org_name','saleorder_id','owner','status','approved_by','datetime');
  var $order = array('id' => 'desc');
  
  /**
  * Build ActiveRecord query for server-side DataTables applying POST filters (dates, user, customer, sale/PO filters, new/renew flag, global search and ordering) and session-based company/user restrictions.
  * @example
  * // Inside a controller or model where CI instance and this model are available:
  * $this->aifilters_model->_get_datatables_query('export');
  * // The method modifies $this->db. You can inspect the compiled SQL:
  * $sql = $this->db->get_compiled_select();
  * echo $sql; // e.g. "SELECT * FROM sales_orders WHERE session_comp_email = 'company@example.com' AND currentdate >= '2025-01-01' AND currentdate <= '2025-01-31' ..."
  * @param {string} $action - Optional action name to alter query behavior (e.g., 'export'). Default is an empty string.
  * @returns {void} Does not return a value; it configures the CI $this->db query builder for subsequent get()/count queries.
  */
  private function _get_datatables_query($action='')
  {
    // print_r('testinf');die;
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');

        $this->db->from($this->table);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);

    // < ------------------Search data by date --------------------->
    if ($this->input->post('start_date') && $this->input->post('end_date')) {
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');
        // print_r('test');die;
        // Apply the date filtering
        $this->db->where('currentdate >=', $startDate);
        $this->db->where('currentdate <=', $endDate);
    }

    if($this->input->post('searchUser'))
    { 
      $searchUser = $this->input->post('searchUser');
        $this->db->where('sess_eml',$searchUser); 
    }

    if($this->input->post('searchcustomer'))
    { 
        $searchcustomer = $this->input->post('searchcustomer');
        $this->db->where('org_id',$searchcustomer);  
    }

    if($this->input->post('searchsaleID'))
    { 
        $searchsalesID = $this->input->post('searchsaleID');
        $this->db->where('saleorder_id',$searchsalesID);  
    }

    if($this->input->post('searchPo'))
    { 
        $searchPo = $this->input->post('searchPo');
        $this->db->where('po_no',$searchPo);  
    }

    if($this->input->post('searchPoDate'))
    { 
        $searchPoDate = $this->input->post('searchPoDate');
        $this->db->where('po_date >=', $searchPoDate);
        $this->db->where('po_date <=', $searchPoDate);
        
    }


    if ($this->input->post('new_Renew')) {
          $new_Renew = $this->input->post('new_Renew');
            if($new_Renew === "new") {
                  $this->db->like('salesorder_item_type', '0');
            }elseif ($new_Renew === "renew") {
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



   /**
   * Fetches rows from a specified table with optional select, where, group, order and limit clauses.
   * @example
   * $result = $this->Aifilters_model->getdata('id, name', 'Users', ['status' => 'active'], 'user', 'created_at', 'asc', 10);
   * print_r($result); // Example output: Array ( [0] => Array ( [id] => 1 [name] => 'Alice' ) )
   * @param {string|null} $sel - Columns to select (e.g. 'id, name') or null to select default/all.
   * @param {string} $tbl - Table name to query (e.g. 'Users' or 'Lead').
   * @param {array|string|null} $whr - WHERE clause as associative array (['status' => 'active']) or raw SQL string, or null for no filtering.
   * @param {string|null} $grp - Group by key; special handling: 'organization' -> 'org_name', 'user' -> 'lead_owner' (for 'Lead' table) or 'owner' for other tables.
   * @param {string|null} $orderby - Column name to order by (defaults to 'subtotal' when null).
   * @param {string} $order - Order direction, 'asc' or 'desc' (default 'desc').
   * @param {int|null} $limit - Maximum number of rows to return or null for no limit.
   * @returns {array} Return result set as an array of associative rows.
   */
   public function getdata($sel, $tbl, $whr = null, $grp = null,$orderby= null,$order='desc',$limit=null) 
   {
   
        // Reset any previous selections
        $this->db->reset_query();

            if($grp == 'organization'){
                $grp = 'org_name';
            }
            else if($grp == 'user'){
                if($tbl=='Lead'){
                $grp = 'lead_owner';
            }
            else{
                $grp = 'owner';
            }
            }
            
        // Construct the select statement
        if ($sel !== null) {
            $this->db->select($sel);
        }
        
        $this->db->from($tbl);
        
        // Apply the WHERE clause if provided and not equal to 'all'
        if ($whr !== null) {
            $this->db->where($whr);
        }
        // Apply the GROUP BY clause if provided
        if ($grp !== null) {
            $this->db->group_by($grp);

        }
        if($orderby != null){
            $this->db->order_by($orderby,$order);
        }
        else{
            $this->db->order_by('subtotal','desc');
        }
      if($limit != null){
        $this->db->limit($limit);
      }
    
        //    $this->db->limit(20);
        // Execute the query
        $query = $this->db->get();
       
        // Return the result as an array
        return $query->result_array();
    }

    public function getcoldata($sel,$tbl,$cond){
      
        $this->db->select($sel);
        $this->db->from($tbl);
        $this->db->where($cond);
        $this->db->group_by($sel);
        return $this->db->get();
    }

// < --------------------------- Star Ai Filters ------------------------------------------>


    public function get_all_customers() {
        $this->db->select('id, org_name');
        $this->db->from('organization');
        $this->db->where('delete_status',1);
        $this->db->group_by('org_name');
    
        $query = $this->db->get();
        $customers = $query->result_array();
        return $customers;
    }

    public function get_all_saleId() {
        $this->db->select('id, saleorder_id');
        $this->db->from('salesorder');
        $this->db->where('delete_status',1);
        $this->db->where('org_id !=', 0);
        $query = $this->db->get();
        $saleId = $query->result_array();
        return $saleId;
    }
    
    /**
     * Retrieve all salesorder records, optionally filtered by organization ID.
     * @example
     * $result = $this->Aifilters_model->get_all_org(5);
     * echo '<pre>'; print_r($result); echo '</pre>'; // sample output: array of associative arrays for matching salesorder rows
     * @param {{int|null}} {$orgId} - Optional organization ID to filter salesorder records. Pass null to return all organizations.
     * @returns {{array}} Array of associative arrays where each item represents a salesorder row.
     */
    public function get_all_org($orgId = null) {
        // print_r($orgId);die;
        $this->db->select('*');      
        $this->db->from('salesorder');

        if (!empty($orgId)) {
            $this->db->where('org_id', $orgId);
        }

        $this->db->where('delete_status',1);
        $query = $this->db->get();
        $orgName= $query->result_array();
        return $orgName;
    }


    // public function get_filtered_Alldata()
    // {
    //     // Select the necessary columns
    //     $this->db->select('*');
    //     $this->db->from('salesorder');
    //     $this->db->where('delete_status', 1);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }


    /**
     * Retrieve aggregated salesorder data grouped by organization (org_id).
     * @example
     * $result = $this->Aifilters_model->get_filtered_Alldata();
     * print_r($result);
     * // Sample output:
     * // Array
     * // (
     * //     [0] => Array
     * //         (
     * //             [org_id] => 5
     * //             [total_initial_total] => 2500.00
     * //             [total_sub_total] => 2400.00
     * //             [delete_status] => 1
     * //             // ... other selected columns ...
     * //         )
     * //     [1] => Array
     * //         (
     * //             [org_id] => 12
     * //             [total_initial_total] => 1800.50
     * //             [total_sub_total] => 1750.50
     * //             [delete_status] => 1
     * //         )
     * // )
     * @returns {array} Array of rows with aggregated totals (grouped by org_id).
     */
    public function get_filtered_Alldata()
    {
        // Select the necessary columns
        $this->db->select('*');
        $this->db->select('SUM(initial_total) as total_initial_total, SUM(sub_totals) as total_sub_total');
        $this->db->from('salesorder');
        
        $this->db->where('delete_status', 1);
        // Group by organization name
        $this->db->group_by('org_id');
        $this->db->where('org_id!=' ,0);
    
        // Execute the query
        $query = $this->db->get();
        // echo $this->db->last_query($query); die;

        // Return the result as an array
        return $query->result_array();
    }


    /**
    * Retrieves filtered sales order data aggregated by organization with summed totals.
    * @example
    * $result = $this->Aifilters_model->get_filtered_data('jdoe', 12, 34, '2025-01-01', '2025-01-31');
    * print_r($result); // e.g. Array ( [0] => Array ( [total_initial_total] => 12345.67 [total_sub_total] => 11000.00 [org_id] => 12 ... ) )
    * @param {int|string|null} $filterUser - Owner identifier or username to filter by (optional).
    * @param {int|null} $org_id - Organization ID to filter results by (optional).
    * @param {int|null} $salesId - Specific sales order ID to filter by (optional).
    * @param {string|null} $startDate - Start date (YYYY-MM-DD) to include records from (optional).
    * @param {string|null} $endDate - End date (YYYY-MM-DD) to include records up to (optional).
    * @returns {array} Returns an array of results grouped by org_id with summed initial_total and sub_totals.
    */
    public function get_filtered_data($filterUser = null, $org_id = null, $salesId = null, $startDate = null, $endDate = null) {
        // Select the necessary columns
        $this->db->select('*');
        $this->db->select('SUM(initial_total) as total_initial_total, SUM(sub_totals) as total_sub_total');
        $this->db->from('salesorder');
        
        // Apply filters if they are provided
        if (!empty($filterUser)) {
            $this->db->where('owner', $filterUser);
        }
    
        if (!empty($org_id)) {
            $this->db->where('org_id', $org_id);
        }
    
        if (!empty($salesId)) {
            $this->db->where('saleorder_id', $salesId);
        }
    
        if (!empty($startDate)) {
            $this->db->where('currentdate >=', $startDate);
        }
    
        if (!empty($endDate)) {
            $this->db->where('currentdate <=', $endDate);
        }
    
        $this->db->where('delete_status', 1);
        // Group by organization name
        $this->db->group_by('org_id');
        $this->db->where('org_id!=' ,0);
    
        // Execute the query
        $query = $this->db->get();
        // echo $this->db->last_query($query); die;

        // Return the result as an array
        return $query->result_array();
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



    public function get_datatables(){
        // print_r('test');die;
        $this->_get_datatables_query();

        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


/**
* Retrieve product_name entries from purchaseorder for a given sale order ID and current session company.
* @example
* $result = $this->Aifilters_model->CountOrder(123);
* print_r($result); // Array ( [0] => stdClass Object ( [product_name] => "Widget A" ) )
* @param {int} $soId - Sale order ID to filter purchaseorder records by.
* @returns {array} Array of result objects containing product_name for the matched sale order.
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

  /**
   * Count invoices for a given sale order constrained to the current session/company.
   * @example
   * $this->load->model('Aifilters_model');
   * $result = $this->Aifilters_model->CountInvoice(123);
   * echo $result; // e.g. 2
   * @param {int} $saleorder_id - Sale order ID used to filter invoices (e.g. 123).
   * @returns {int} Number of matching invoices (integer count).
   */
  public function CountInvoice($saleorder_id){
        $sess_eml           = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company    = $this->session->userdata('company_name');
        $this->db->select('id');
        $this->db->from('invoices');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('saleorder_id',$saleorder_id);
        $this->db->where('delete_status',1);
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
  



    // < ------------------------------------ End Ai Filters ----------------------------------->
    
}



?>

