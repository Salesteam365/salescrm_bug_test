<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Quotation_model extends CI_Model
{
	public function __construct()
  {
    parent::__construct();    
	$this->load->model('Performainvoice_model','Performainvoice');
	$this->load->model('Login_model');
   
  }
  var $table = 'quote';
  var $sort_by =array(null,'subject','org_name','quote_id','currentdate','owner','datetime',null);
  var $search_by = array('subject','org_name','quote_id','currentdate', 'owner','datetime');
  var $order = array('id' => 'desc');
  /**
  * Build and apply DataTables query filters and ordering on the model's CI query builder based on session data and POST inputs.
  * @example
  * // Called internally in the model before executing the query for DataTables
  * $this->_get_datatables_query();
  * // Example POST/session values:
  * // $_POST['search']['value'] = 'Acme';
  * // $_POST['order'][0]['column'] = 2; $_POST['order'][0]['dir'] = 'desc';
  * // $this->input->post('searchDate') = '2025-01-01';
  * // $this->session->userdata('type') = 'admin';
  * // After calling, $this->db will have appropriate FROM, WHERE, LIKE, GROUP and ORDER BY clauses applied.
  * @param {void} $none - No arguments are accepted.
  * @returns {void} Applies filters/order to $this->db; does not return a value.
  */
  private function _get_datatables_query()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')==='admin')
    {
      $this->db->from($this->table);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($this->input->post('fromDate') && $this->input->post('toDate')){
          $this->db->where('currentdate >=',$this->input->post('fromDate'));
          $this->db->where('currentdate <=',$this->input->post('toDate'));
        }else if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('currentdate >=',$search_date);
        }
      }
	  if($this->input->post('searchUser'))
      { 
        $searchUser = $this->input->post('searchUser');
        $this->db->where('sess_eml',$searchUser);
      }
	  
	  if($this->input->post('searchStage'))
      { 
        $searchStage = $this->input->post('searchStage');
        $this->db->where('quote_stage',$searchStage);
      }
	  
      $this->db->where('delete_status',1);
    }
    elseif($this->session->userdata('type')==='standard')
    {
      $this->db->from($this->table);
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
	  if($this->input->post('searchStage'))
      { 
        $searchStage = $this->input->post('searchStage');
        $this->db->where('stage',$searchStage);
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

 //////////////////////////////////////////////////// monthwise chart for quotatiion graph starts/////////////////////////////////////////////////////////////////////
    
 /**
 * Retrieve monthly quote subtotal totals grouped by year and month for the current session company.
 * Admin users receive results for the entire company; standard users receive results filtered by the logged-in user's email.
 * Only quotes with delete_status = 1 are included. Results are grouped and ordered by year and month (derived from the `currentdate` column).
 * @example
 * // From a controller:
 * $this->load->model('Quotation_model');
 * $result = $this->Quotation_model->getquotegraph();
 * // Example returned value:
 * // [
 * //   (object) ['year' => '2025', 'month' => '6', 'subtotal' => '1234.56'],
 * //   (object) ['year' => '2025', 'month' => '7', 'subtotal' => '987.65']
 * // ]
 * @param void $none - This method does not accept any parameters.
 * @returns array|null Array of result objects (properties: year, month, subtotal) on success, or null if a database error occurred.
 */
 public function getquotegraph() {
  $sess_eml = $this->session->userdata('email');
  $session_comp_email = $this->session->userdata('company_email');
  $session_company = $this->session->userdata('company_name');
  if($this->session->userdata('type')=='admin'){
  $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_totalq) AS subtotal')
      ->where('session_comp_email', $session_comp_email)
      ->where('session_company', $session_company)
      ->where('delete_status', 1)
      ->group_by('year, month')
      ->order_by('year, month')
      ->get('quote');

  if (!$query) {
      $error = $this->db->error();
      echo "Database Error: " . $error['message'];
  } else {
      return $query->result();
  }

 }
 else if($this->session->userdata('type')=='standard'){
  $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_totalq) AS subtotal')
  ->where('session_comp_email', $session_comp_email)
  ->where('session_company', $session_company)
  ->where('sess_eml', $sess_eml)
  ->where('delete_status', 1)
  ->group_by('year, month')
  ->order_by('year, month')
  ->get('quote');

   if (!$query) {
  $error = $this->db->error();
  echo "Database Error: " . $error['message'];
   } else {
  return $query->result();
    }

}
 
}

 //////////////////////////////////////////////////// monthwise chart for quotatiion graph ends/////////////////////////////////////////////////////////////////////

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

  // public function monthwise_quote(){
  //   $session_comp_email = $this->session->userdata('company_email');
  //   $session_company = $this->session->userdata('company_name');
  //   $this->db->from($this->table);
	//   $this->db->where('session_company',$session_company);
  //   $this->db->where('session_comp_email',$session_comp_email);
  //   return $this->db->count_all_results();
  // }
  
  
  public function check_quote_exist($oppid)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company    = $this->session->userdata('company_name');
    $this->db->from($this->table);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('opportunity_id',$oppid);
    $this->db->where('delete_status',1);
    return $this->db->count_all_results();
  }
  
  public function check_pi_exist($qtnid)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company    = $this->session->userdata('company_name');
    $this->db->from('performa_invoice');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('page_id',$qtnid);
    $this->db->where('delete_status',1);
    return $this->db->count_all_results();
  }
  

  
  public function get_opp_id($opportunity_id,$sess_eml,$session_company,$session_comp_email)
  {
    $this->db->like('opportunity_id', $opportunity_id , 'both');
    $this->db->where('sess_eml',$sess_eml);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->order_by('currentdate', 'DESC');
    $this->db->limit(5);
    return $this->db->get('opportunity')->result();
  }
  /**
  * Retrieve opportunity records for a given opportunity_id from the 'opportunity' table.
  * @example
  * $result = $this->Quotation_model->getOppValue(['opportunity_id' => 123]);
  * print_r($result); // sample output: Array ( [0] => Array ( [opportunity_id] => 123 [name] => 'Acme Project' [value] => '10000' ) )
  * @param {array} $opportunity_id - Associative array containing the 'opportunity_id' key (int) used to filter the query.
  * @returns {array} Array of matching opportunity rows (each row as an associative array); returns an empty array if no id provided or no matches found.
  */
  public function getOppValue($opportunity_id)
  {
    $response = array();
    if($opportunity_id['opportunity_id'])
    {
      $this->db->select('*');
      $this->db->where('opportunity_id',$opportunity_id['opportunity_id']);
      $o = $this->db->get('opportunity');
      $response = $o->result_array();
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
    $session_company 	= $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('id',$id);
    $query = $this->db->get($this->table);
    return $query->row_array();
  }
  
    /**
    * Retrieve a paginated list of quotations filtered by session company/user, date range and optional search term.
    * @example
    * $result = $this->Quotation_model->get_all_quot('This Week', 'Acme', 10, 0);
    * print_r($result); // sample output: Array ( [0] => Array ( 'id' => 123, 'currentdate' => '2025-12-15', 'company' => 'Acme Corp', 'sess_eml' => 'user@example.com', 'quote_number' => 'Q-0001' ) )
    * @param string $search_date - Date filter; use "This Week" to filter from last Monday or provide a 'YYYY-MM-DD' date string.
    * @param string $search - Optional search term to match across configured searchable columns.
    * @param int $per_page - Number of records to return (pagination limit).
    * @param int $start - Offset for pagination (starting record index).
    * @returns array Returns an array of quotation records (each record as an associative array).
    */
    public function get_all_quot($search_date,$search,$per_page, $start)
  {
	  
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
    $this->db->from($this->table);
	if($this->session->userdata('type')==='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    //$this->db->where('stage',$status);
	    if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else if($search_date!="")
        {
          $this->db->where('currentdate >=',$search_date);
        }else{
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
		}
	 $i = 0;
    foreach ($this->search_by as $item) // loop column
    {
      if($search) 
      {
        if($i===0) 
        {
          $this->db->group_start(); 
          $this->db->like($item, $search);
        }
        else
        {
          $this->db->or_like($item, $search);
        }
        if(count($this->search_by) - 1 == $i) 
        $this->db->group_end(); 
      }
      $i++;
    }
	
    //$this->db->order_by('lead_status','desc');
    $this->db->order_by('id','DESC');
	$this->db->limit($per_page, $start);
	$query = $this->db->get();
    return $query->result_array();
  }
  
  /**
  * Get the total count of quotations filtered by date, search term and current user/company session.
  * @example
  * $result = $this->Quotation_model->get_all_count('This Week', 'Acme');
  * echo $result; // 12
  * @param {string} $search_date - Start date (YYYY-MM-DD) or the special value "This Week" to use last Monday; empty string defaults to last Monday.
  * @param {string} $search - Search keyword used with LIKE across searchable columns; empty string disables search.
  * @returns {int} Total number of matching rows.
  */
  public function get_all_count($search_date,$search){
	$sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
    $this->db->from($this->table);
	if($this->session->userdata('type')==='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
	    if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        { 	if($search_date!=""){
				$this->db->where('currentdate >=',$search_date);
			}else{
				$this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
			}
        }
	 $i = 0;
	  foreach ($this->search_by as $item) // loop column
    {
      if($search) 
      {
        if($i===0) 
        {
          $this->db->group_start(); 
          $this->db->like($item, $search);
        }
        else
        {
          $this->db->or_like($item, $search);
        }
        if(count($this->search_by) - 1 == $i) 
        $this->db->group_end(); 
      }
      $i++;
    }
	$query = $this->db->get();
    return $query->num_rows();
  }
  
    /**
    * Get the summed initial_total for quotes in a specific quote stage for the current session/company.
    * @example
    * $result = $this->Quotation_model->getTotalPrice('approved');
    * echo print_r($result, true); // Array ( [quote_stage] => approved [initial_total] => 12345.67 )
    * @param string|int $stage - Quote stage to filter by (e.g. 'approved' or 2).
    * @returns array Associative array with keys 'quote_stage' and 'initial_total' (sum of initial_total for the given stage).
    */
    public function getTotalPrice($stage){
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->select('quote_stage');
    $this->db->select_sum('initial_total');
    $this->db->from($this->table);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    if($this->session->userdata('type')==='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
    $this->db->where('delete_status',1);
    $this->db->where('quote_stage',$stage);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  /**
  * Get GST records for the current session's company from the 'gst' table.
  * @example
  * $this->load->model('Quotation_model');
  * $result = $this->Quotation_model->get_gst();
  * print_r($result); // Example output:
  * // array(
  * //   0 => array(
  * //     'id' => '1',
  * //     'tax_name' => 'GST',
  * //     'tax_value' => '18',
  * //     'session_comp_email' => 'billing@company.com',
  * //     'session_company' => 'Example Company',
  * //     'delete_status' => '1'
  * //   )
  * // )
  * @param {void} $none - This method does not accept any parameters.
  * @returns {array} Array of associative arrays containing GST rows for the current company (empty array if none).
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
  
  
  /**
   * Update a record in the quotations table by ID using the provided data array.
   * @example
   * $result = $this->Quotation_model->update_status(['status' => 'closed'], 42);
   * echo $result ? 'true' : 'false'; // outputs 'true' on success
   * @param array $leadArr - Associative array of columns to update (e.g. ['status' => 'closed']).
   * @param int|string $id - Record primary key ID to match for the update (e.g. 42).
   * @returns bool Return true if the update succeeded, false otherwise.
   */
  public function update_status($leadArr,$id)
  { 
    $this->db->where('id',$id);
    if($this->db->update($this->table,$leadArr))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  
  
  public function create($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  /**
  * Update the quote_id field for a record identified by its id.
  * @example
  * $result = $this->Quotation_model->quote_id(123, 45);
  * echo $result // true
  * @param int|string $quote_id - New quote identifier to set.
  * @param int $id - Database primary key id of the record to update.
  * @returns bool True if the update succeeded, false otherwise.
  */
  public function quote_id($quote_id,$id)
  {
    $data = array(
      'quote_id' => $quote_id,
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
   * Update records in the model's table. If current session user type is not 'admin',
   * the update will be restricted to rows matching the session email (sess_eml).
   * @example
   * $result = $this->Quotation_model->update(['id' => 5], ['status' => 'approved']);
   * echo $result // render some sample output value; // e.g. 1
   * @param {{array|string}} {{\$where}} - WHERE clause to select rows to update (array or SQL string).
   * @param {{array}} {{\$data}} - Associative array of column => value pairs to be updated.
   * @returns {{int}} Number of affected rows.
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
  public function delete_bulk($id)
  {
    $this->db->set('delete_status',2);
    $this->db->where('id', $id);
    $this->db->update($this->table);
  }
  
  /*********Old pdf template************/
  public function view_old($id,$download)
  {
    $this->db->where('id', $id);
    $data = $this->db->get($this->table);
	$bank_details_terms = $this->Performainvoice->get_bank_details();
    foreach($data->result() as $row)
    {
     
      $output = '<!DOCTYPE html>
      <html>
      <head>
        <title>Team365 | Quotation</title>
		 <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
      </head>
      <body>
        <table width="100%">
            <tr>
              <td colspan="12" style="text-align:center;">
				<h5><b>QUOTATION</b></h5>
				<hr style="width: 230px; border: 1px solid #50b1bd; margin-top: 10px;">
			  </td>
            </tr>

			<tr>
				<td colspan="6" style="padding:0px; margin-top:15px; font-size: 14px;">
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
                    <span>QUOTATION ID : </span>&nbsp;<span>'.$row->quote_id.'</span><br>
        				<b>DATE : </b><span >'.date('d-M-Y').'</span><br>
						<b>VALID UNTIL : </b><span>'.date('d-M-Y',strtotime($row->valid_until)).'</span>
                        </td>
                        </tr>
                    </table>
				</td>
            </tr>
			<tr>
				<td colspan="6" style="padding:20px 0 40px; font-size: 12px;"> 
				  <b>ADDRESS :- </b><br>
				  <span class="h6 text-primary">'.$row->org_name.'</span><br>
				  <b>CONTACT&nbsp;PERSON</b> :&nbsp;<span>'.$row->contact_name.'</span><br>
				  <span style="white-space: pre-line">'.$row->billing_address.'</span>,
				  <span>'.$row->billing_state.'</span><br>
				  <span>'.$row->billing_city.'</span>&nbsp;,<span>'.$row->billing_zipcode.'</span>&nbsp;,<span>'.$row->billing_country.'</span><br>
				
				</td>

				<td colspan="6" style="padding:20px 0 40px; text-align:left; font-size: 12px;">
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

            <tbody style="background: #f5f5f5; color: #000000;  font-size: 12px;">';
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

        <table width="100%; margin-top:20px; border:1px; margin-bottom:40px;" >
            <tr>
				<td colspan="6" style="font-size: 12px;">
				<br>
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
					<table class="float-right" style="border: 1px solid #ffffff; font-size:12px;">
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
							$output .='<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst18).'/-</span></td></tr>';
							}
							
							$output .='
						<tr style="line-height:35px;">
							<td style="padding:0px;" class="bg-info text-white"><b>Sub Total:</b></td>
							<td style="padding:0px; border-right: 1px solid #17a2b8; " class="bg-info text-white"><span class="float-right"><b>INR '.IND_money_format($row->sub_totalq).'/-</b></span></td>
						</tr>
					</table>
				</td>
        </tr>
			
        </table><br><br><br>';
        if(isset($download) && $download=='dn'){
        if($bank_details_terms->enable_payment==1){
			
		$output .='<table width="100%; margin-top:20px; border:1px; margin-bottom:40px;" >
            <tr>
				<td colspan="6">
					
					<a href="'.base_url().'" style="text-decoration:none; display:block; margin: 25px auto 15px; width:100%; color:#fff; background:#17a2b8; text-align:center; padding:10px;><i class="fas fa-money-bill-wave-alt"></i>Pay Now</a>
				</td>
			</tr>
        </table>';

		}  }
		
        $output .='<table width="100%" style="position:fixed; bottom: 60; font-size:11px;">

          <tr style="height:40px;">
            <td style="width:65%">
			<b>Accepted By</b><br>
			<b>Accepted Date</b> : '.date('d F Y').'
			
			</td>
			
			<td colspan="3">
			</td>
			<td style="width:35%">
    			<table>
    			<tr>
    			<td>
    			<b>Quotation Created By</b> : </td><td>'.ucfirst($row->owner).'</td>
    			</tr>
    			<tr>
    			<td>
    			<b>Quotation Created Date : </td><td>'.date("d F Y", strtotime($row->datetime)).'</td></tr>
    			</table>
			
			</td>
			
          </tr>
		 
		  
        </table>

        <footer>
        <div style="position: fixed;bottom: 8;">
          <center>
		  <span style="font-size:12px"><b>"This is System Generated Quotation Sign and Stamp not Required"</b></span><br>
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
  
  
  
  /******New pdf template*****/
  
 
  /**
  * Generate and return the full HTML markup for a quotation identified by the given ID.
  * @example
  * $result = $this->Quotation_model->view(123, 'dn');
  * echo $result // renders the generated HTML quotation (starts with "<!DOCTYPE html>...").
  * @param {int|string} $id - Quotation record identifier (e.g. 123).
  * @param {string} $download - Optional download flag; use 'dn' to include payment link for downloadable view (e.g. 'dn' or '').
  * @returns {string} HTML string containing the complete quotation document.
  */
  public function view($id,$download)
  {
    $this->db->where('id', $id);
    $data = $this->db->get($this->table);
	$bank_details_terms = $this->Performainvoice->get_bank_details();
    foreach($data->result() as $row)
    {
       $admin_details = $this->Login_model->get_company_details($row->session_company,$row->session_comp_email);
       $output = '<!DOCTYPE html>
              <html>
              <head>
                <title>Team365 | Quotation</title>
                <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
                
                <style>
                 @page{
                      margin-top: 20px;
                    }
                    footer .pagenum:before {
                        content: counter(page, decimal);
                    }
                </style>
              </head>
        
              <body style="font-family: Quicksand, sans-serif;">
              
                <footer style="position: fixed;bottom: 30;border-top:1px dashed #333; " >
                  <div class="pagenum-container"style="text-align:right;font-size:12px;">Page <span class="pagenum"> </span>of TPAGE</div>
                  <center>
        		  <span style="font-size:12px"><b>"This is System Generated Quotation, Sign and Stamp not Required"</b></span><br>
                  <b><span style="font-size: 10px;">E-mail - '.$admin_details['company_email'].'</br>
                        | Ph. - +91-'.$admin_details['company_mobile'].'</br>
                        | GSTIN: '.$admin_details['company_gstin'].'</br>
                        | CIN: '.$admin_details['cin'].'</span></b> <br>
                        <b><span style="font-size:12px;">Powered By <a href="https://team365.io/" >Team365 CRM</a></span></b>
                  </center>
                
                </footer>
              
              <main style="margin-bottom:30px;">
              
              <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                       <td>
                         <h3 style="color: #6539c0; margin-top:0px;margin-bottom: -5px;">Quotation</h3>
                         <p style="margin-bottom: 0;font-size: 12px;">
                         <text style="color: #9c9999; display:inline-block; ">Quotation No#</text> <text style="display:inline-block; padding-left:5px;">'.$row->quote_id.'</text><br>
                        <text style="color: #9c9999; display:inline-block; ">Quotation Date: </text><text style="display:inline-block; padding-left:5px;">'. date("d F Y", strtotime($row->currentdate)).'</text><br>
                       </p>
                       </td>
                       <td>
                       <p style="margin-bottom: 0;font-size: 12px;">
                        <span style="float: right"><text style="color: #9c9999; display:inline-block; padding-left:50px;">Validity Date: </text><text style="display:inline-block; padding-left:5px;">'. date("d F Y", strtotime($row->valid_until)).'</text></span></p>
                        </td>
                       <td colspan="2" style="text-align:right">';
        					$image = $admin_details["company_logo"];
        					if(!empty($image))
        					{
        					$output .=  '<img style="width: 70px;" src="./uploads/company_logo/'.$image.'">';
        					}
        					else
        					{
        					$output .=  '<span class="h5 text-primary">'.$admin_details["company_name"].'</span>';
        					}
        					$output .= '
        				</td>
                    </tr>
                 </tbody>
                </table>
                 <table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
                
                    <tr>
                       <td style="width: 49.5%; padding: 10px; vertical-align: top;">
                         
                            <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Quotation From</h4>
                            <p style="margin: 0;font-size: 14px;">'.$admin_details["company_name"].'</p>';
                            
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
                       
                          <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Quotation For</h4>
                          <p style="margin: 0;font-size: 12px; ">'.
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
                          $output .= '<p style="margin-bottom: 0;font-size: 12px;margin-top: 0px;"><b>Contact Name:</b> '.$row->contact_name.'</p>';
                           }
                            if(isset($row->email)){
                          $output .= '<p style="margin-bottom: 0;font-size: 12px;margin-top:0px;"><b>Email:</b> '.$row->email;
                            }
                            if(isset($row->mobile)){
                          $output .= '<p style="margin-bottom: 0;font-size: 12px;margin-top:0px;"><b>Contact No.:</b> '.$row->mobile;
                            }
                       $output .= '  
                       </td>
                    </tr>
                </table>
                <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                      <td align="left" style="font-size:12px;width: 49.5%; ">
                        <p><b>Country of Supply : </b>'.$row->billing_country.'</p>
                      </td>
                      <td></td>
                      <td align="left" style="font-size:12px;width: 49.5%; ">
                        <p><b>Place of Supply : </b>'.$row->billing_state.'</p>
                      </td>
                    </tr>
                 </tbody>
                </table>';
				$pro_discount = explode("<br>",$row->pro_discount);
				$totalDiscpunt= array_sum($pro_discount);
                $output .='<table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; border-radius: 7px; background: #efebf9;">
                   <thead style="color: #fff;" align="left">
                    <tr>
                       <th width="30%" style="font-size: 12px;">
                        <div style="background: #6539c0;border-top-left-radius: 7px; padding: 11px;">
                       Product/Services</div></th>
                       <th><div style="background: #6539c0; padding: 11px;font-size: 12px;">HSN/SAC</div></th>
                       <th><div style="background: #6539c0; padding: 11px;font-size: 12px;">SKU</div></th>
                       <th><div style="background: #6539c0; padding: 11px;font-size: 12px;">Qty</div></th>
                       <th><div style="background: #6539c0; padding: 11px;font-size: 12px;">Rate</div></th>';
					   if($totalDiscpunt>0){
                       $output .='<th><div style="background: #6539c0; padding: 11px;font-size: 12px;">Discount</div></th>';
					   }
                       $output .='<th><div style="background: #6539c0; padding: 11px;font-size: 12px;">Tax</div></th>
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
        				$newLenth=($arrlength);
        				$rw=0;
						$initTot=0;
        				for($x = 0; $x < $newLenth; $x++){
        				    //$rw++;
        					$num = $x + 1;
        					$output .='<tr >
        						
        						<td style="font-size: 12px; padding:10px; border-top: 1px solid #dee2e6;">'.$product_name[$x].'</td>
        						
        						<td style="font-size: 12px; border-top: 1px solid #dee2e6;">'.$hsnsac[$x].'</td>
        						<td style="font-size: 12px; border-top: 1px solid #dee2e6;">'.$sku[$x].'</td>
        						<td style="font-size: 12px; border-top: 1px solid #dee2e6;">'.$quantity[$x].'</td>
        						<td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($unit_price[$x]).'</td>';
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
						$output.='<tr >
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
                      <p style="font-size:12px;"><b>Total in words:</b> <text> '.AmountInWords($row->sub_totalq).' only</text></p>';
                   
                    //if(isset($bank_details_terms)){
                       if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){
               
                        $output .='<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a; font-size:12px;padding:7px;">
                               <tr>
                                <td colspan="3">
                                 
                                    <h5 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0; font-size:13px;">Bank Details</h5>
                                </td>
                               </tr>
                              
                               <tr>
                                   <th style="text-align:left; padding-left:10px;">  Account Holder Name:  </th>
                                   <td>'.ucfirst($bank_details_terms->acc_holder_name).'</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;">  Account Number:  </th>
                                   <td>'.$bank_details_terms->account_no.'</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;">  IFSC:  </th>
                                   <td>'.$bank_details_terms->ifsc_code.'</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;"> Account Type:  </th>
                                   <td>'.ucfirst($bank_details_terms->account_type).'</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;"> Bank Name: </th>
                                   <td>'.ucfirst($bank_details_terms->bank_name).'</td>
                               </tr><tr>';
                              
                                if($bank_details_terms->upi_id!=""){
                                $output .= '<th style="text-align:left;  padding-left:10px;">UPI Id:</th>
                                   <td>'.$bank_details_terms->upi_id.'</td>';
                                }
                                //$output .= '</tr>';
                               if(isset($download , $bank_details_terms) && $download=='dn' ){
                                  $output .= '<th style="text-align:left;padding-left:10px;"><a href="'.base_url("home").'" style="text-decoration:none; background:#6539c0; color:#fff; font-size:10px; padding:4px; display:inline-block; border-radius:3px;">Pay Now</a></th>';
                                }
                                  
                                 $output .= '</tr></table>';
                   
                   }  
                   
                     $output .='</td>
                    <td align="" width="40%" style="text-align:right;">
                      <table align="" width="100%" style="text-align:right; position: absolute;top: 0px;">
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
                           $output .='
                          <tr>
                            <th style="font-size: 12px;" align="left">Initial Amount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->initial_total).'</td>
                          </tr>';
						  if($row->discount>0){
                          $output .='<tr>
                            <th style="font-size: 12px;" align="left">Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$row->discount.'</td>
                          </tr>
                          <tr>
                            <th style="font-size: 12px;" align="left">After Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->after_discount).'</td>
                          </tr>';
                          }
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
        							/*$output .='<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst18).'</td></tr>';*/
									
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
									
								if(isset($row->extra_charge_label) && !empty($row->extra_charge_label) ){
								$labelExra=explode("<br>",$row->extra_charge_label);
								$valueExra=explode("<br>",$row->extra_charge_value);
									for($i=0; $i<count($labelExra); $i++){
										$output .='<tr><th style="font-size: 12px;" align="left">'.$labelExra[$i].':</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($valueExra[$i]).'</td></tr>';
									}
								}
									
									
        						
                          $output .='
                          <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
                          <tr>
                          
                            <th style="font-size: 12px;" align="left">TOTAL</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sub_totalq).'</td>
                          </tr>
                        </tbody>
                        
                      </table>
                    </td>
                  </tr>
                  </tbody>
                </table>';
        
                $output .='<table width="60%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-top:';
                    if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){ 
                        $output .='0px;">';
                        
                    }else{ 
                        $output .='-20px;">'; 
                        
                    }
                    $output .='<tbody>
                    <tr>
                  <td align="left">
                    <h5 style="color: #6539c0;margin-bottom: 10px;">Terms and Conditions</h5>
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
        
              </body>
              </html>';
      //return $output;
      
      }
    return $output;
  }


  public function mass_save($mass_id, $dataArry)
  {
    // print_r($mass_id);die;
    $this->db->where('id', $mass_id);
    if($this->db->update('quote', $dataArry)){
		  return true;
		}else{
      return false;
    }
  }
  

//please write code above this
}
?>
