<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Email_Marketing_model extends CI_Model
{
var $table = 'email_automation';
  var $sort_by = array('client_name','client_email','subject','read_status','currentdate',null);
  var $search_by = array('client_name','client_email','subject');
  var $order = array('id' => 'desc');
  /**
  * Build and apply the datatables query to $this->db based on session, POST search and ordering parameters.
  * @example
  * // Example setup (inside a controller/model context)
  * $this->session->set_userdata([
  *   'email' => 'admin@example.com',
  *   'company_email' => 'company@example.com',
  *   'company_name' => 'ExampleCo',
  *   'type' => 'admin'
  * ]);
  * $_POST['search']['value'] = 'john'; // global search term
  * $_POST['order'] = [['column' => 1, 'dir' => 'asc']]; // order by second column ascending
  * $_POST['searchDate'] = 'This Week'; // or '2025-01-01'
  * $this->_get_datatables_query();
  * $query = $this->db->get(); // execute the built query
  * $result = $query->result();
  * print_r($result); // sample output: array of result objects matching filters
  * @param string|null $searchDate - POST param 'searchDate' (date string or 'This Week') used to filter currentdate.
  * @param string|null $searchValue - POST global search value at $_POST['search']['value'] used to like-search across $this->search_by columns.
  * @param array|null $order - POST ordering array at $_POST['order'] used to order results (column index and dir).
  * @returns void Applies filters and ordering to $this->db query builder; does not return a value.
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
    $this->db->from($this->table);
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    return $this->db->count_all_results();
  }
 
 public function cusr_type(){
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->distinct();
    $this->db->select('customer_type');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get('organization');
    return $query->result_array();
 } 
  
 public function getemail($id){
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->select('*');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('id',$id);
    $query = $this->db->get('email_automation');
    return $query->result_array();
 } 
  
  
  public function update_status($id){
    $this->db->where('id', $id);
    $this->db->update('email_automation', array('read_status' => 1));
    return true;
  }
  
  public function create_automation_email($data)
   {
    $this->db->insert("email_automation",$data);
    return $this->db->insert_id();
  }
 public function getOrgData()
  {
	  $this->db->select('*');
	  $session_comp_email = $this->session->userdata('company_email');
         $session_company = $this->session->userdata('company_name');
	    $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
	  $this->db->from('organization');
	  $query = $this->db->get();
	  return $query->row_array();
  } 

  public function get_by_id($id)
  {
    $this->db->from('organization');
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row_array();
  }
  /**
  * Get multiple email values from the organization table filtered by customer type and current session company.
  * @example
  * $result = $this->Email_Marketing_model->multiple_emailValue('Client');
  * print_r($result); // sample output: Array ( [0] => Array ( [email] => user@example.com ) [1] => Array ( [email] => foo@bar.com ) )
  * @param {string} $type - Customer type to filter by. If 'Other' will fetch records where customer_type is empty; if omitted or empty string fetches all emails for the current session company.
  * @returns {array} Return array of associative arrays containing 'email' keys for matching organizations.
  */
  public function multiple_emailValue($type='')
  {
      $session_company      = $this->session->userdata('company_name');
      $session_comp_email   = $this->session->userdata('company_email');
	  
	  $this->db->select('email');
	  if($type!=""){
	      if($type=="Other"){
            $this->db->where('customer_type',"");
          }else{
            $this->db->where('customer_type',$orgType);
          }
	  }
	  $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('delete_status',1);
      $this->db->from('organization');
      $query = $this->db->get();
      return $query->result_array();
  }
  
  public function getemailcsv_details()
   {
	$this->db->select('primary_contact,email,mobile,org_name');
	$query= $this->db->get('organization');
    return $query->result_array();
  }	
  
  public function unsubscribeEmail($Email,$cEmail,$cnyName){
    $this->db->where('client_email', $Email);
    $this->db->where('session_comp_email', $cEmail);
    $this->db->where('session_company', $cnyName);
    $this->db->update('email_automation', array('subscription_status' => 0));
    return true;
  }
  
  public function getunsubscribemail(){
      $session_company      = $this->session->userdata('company_name');
      $session_comp_email   = $this->session->userdata('company_email');
	  $this->db->select('client_email');
	  $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('subscription_status',0);
      $this->db->from('email_automation');
      $query = $this->db->get();
      return $query->result_array();  
  }
  
  
  
  
}
?>