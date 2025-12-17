<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Organization_model extends CI_Model
{
  var $table = 'organization';
  var $sort_by = array(null,'org_name','customer_type','email','website','mobile','billing_city',null);
  var $search_by = array('org_name','email','website','mobile','customer_type');
  var $order = array('id' => 'desc');
  
  /**
  * Prepare and apply the DataTables server-side filters and ordering to $this->db for retrieving organization records.
  * @example
  * // called from within the model/controller (no arguments)
  * $this->_get_datatables_query();
  * $query = $this->db->get(); // execute the prepared query
  * echo $query->num_rows(); // render some sample output value; e.g. 12
  * @param void $none - No parameters; query is built using session data and $_POST inputs (fromDate, toDate, searchDate, searchUser, cust_types, search/order).
  * @returns void Builds and sets the active query on $this->db; does not return any value directly.
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
       if($this->input->post('searchUser'))
      { 
        $searchUser = $this->input->post('searchUser');
        $this->db->where('sess_eml',$searchUser);
      }
      if($this->input->post('cust_types'))
      { 
			$cust_date = $this->input->post('cust_types');
			$this->db->where('customer_type',$cust_date);
      }else{
            $this->db->group_start();
            $this->db->where('customer_type', 'Customer');
            $this->db->or_where('customer_type', 'Vendor');
            $this->db->or_where('customer_type', 'Both');
            $this->db->group_end();
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
      if($this->input->post('cust_types'))
      { 
			$cust_date = $this->input->post('cust_types');
			$this->db->where('customer_type',$cust_date);
      }else{
          $this->db->group_start();
         $this->db->where('customer_type', 'Customer');
         $this->db->or_where('customer_type', 'Vendor');
         $this->db->or_where('customer_type', 'Both');
         $this->db->group_end();
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
          $this->db->group_start(); 
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
  /**
  * Count all organization records for the current session's company where customer_type is 'Customer' or 'Both'.
  * @example
  * $CI =& get_instance();
  * $CI->load->model('Organization_model');
  * $count = $CI->Organization_model->count_all();
  * echo $count; // e.g. 42
  * @param {void} none - No arguments required.
  * @returns {int} Total number of matching organization records.
  */
  public function count_all()
  {
    $this->db->from($this->table);
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->group_start();
    $this->db->where('customer_type', 'Customer');
    $this->db->or_where('customer_type', 'Both');
    $this->db->group_end();
    return $this->db->count_all_results();
  }
  public function create($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  
  /**
   * Update the organization_id field for a specific record in the model's table.
   * @example
   * $result = $this->Organization_model->organization_id(123, 45);
   * echo $result; // outputs 1 on success or empty string on failure
   * @param {int} $organization_id - New organization ID to set (e.g., 123).
   * @param {int} $id - Record primary key ID to update (e.g., 45).
   * @returns {bool} True if the update succeeded, false otherwise.
   */
  public function organization_id($organization_id,$id)
  {
    $data = array(
      'organization_id' => $organization_id,
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
  * Retrieve lead records for a given organization filtered by the current session's company and company email.
  * @example
  * $result = $this->Organization_model->get_leads('Acme Inc');
  * print_r($result); // sample output:
  * // Array (
  * //   [0] => Array (
  * //     'id' => '1',
  * //     'lead_id' => 'L-100',
  * //     'name' => 'Website redesign',
  * //     'lead_owner' => 'John Doe',
  * //     'lead_status' => 'Open',
  * //     'contact_name' => 'Jane Smith',
  * //     'sub_total' => '1500.00',
  * //     'currentdate' => '2025-01-15'
  * //   )
  * // )
  * @param {string} $org_name - Organization name to filter leads.
  * @returns {array} Array of associative arrays representing lead records (keys: id, lead_id, name, lead_owner, lead_status, contact_name, sub_total, currentdate).
  */
  public function get_leads($org_name)
  {
    $this->db->select('id,lead_id,name,lead_owner,lead_status,contact_name,sub_total,currentdate');
    $this->db->from('lead');
	$session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('org_name',$org_name);
    $query = $this->db->get();
    return $query->result_array();
  }
  /**
  * Retrieve opportunities for a given organization filtered by the current session's company email and company name.
  * @example
  * $result = $this->Organization_model->get_opportunity('Acme Corp');
  * print_r($result); // Example output: Array ( [0] => Array ( [id] => '1', [name] => 'Opportunity A', [opportunity_id] => 'OPP-001', [owner] => 'John Doe', [stage] => 'Qualification', [sub_total] => '1500.00', [currentdate] => '2025-01-15' ) )
  * @param {string} $org_name - Organization name to filter opportunities.
  * @returns {array} Array of associative arrays representing matching opportunity rows (id, name, opportunity_id, owner, stage, sub_total, currentdate).
  */
  public function get_opportunity($org_name)
  {
    $this->db->select('id,name,opportunity_id,owner,stage,sub_total,currentdate');
    $this->db->from('opportunity');
	$session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('org_name',$org_name);
    $query = $this->db->get();
    return $query->result_array();
  }
  
  public function get_quotation($org_name)
  {
    $this->db->from('quote');
	$session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('org_name',$org_name);
    $query = $this->db->get();
    return $query->result_array();
  } 
	public function get_sales_order($org_name)
	{
		$this->db->from('salesorder');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company 	= $this->session->userdata('company_name');
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		$this->db->where('org_name',$org_name);
		$query = $this->db->get();
		return $query->result_array();
	} 

  
  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }
  public function get_by_id_view($id)
  {
    $this->db->from($this->table);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row_array();
  }
  /**
  * Update records in the organizations table using the provided where condition and data. Admins can update any record; non-admins are limited to rows matching the current session email.
  * @example
  * $where = ['id' => 5];
  * $data  = ['name' => 'Acme Corporation', 'status' => 'active'];
  * $result = $this->Organization_model->update($where, $data);
  * echo $result; // e.g. 1
  * @param {array|string} $where - Where clause as associative array or SQL string (e.g. ['id' => 5]).
  * @param {array} $data - Associative array of column => value pairs to update (e.g. ['name' => 'Acme Corporation']).
  * @returns {int} Number of affected rows.
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
  
  /**
  * Retrieve the organization name for a given organization ID filtered by the current session's company and company email.
  * @example
  * $result = $this->Organization_model->get_org_data(5);
  * print_r($result); // Sample output: Array ( [0] => stdClass Object ( [org_name] => "Acme Corp" ) )
  * @param int $id - Organization ID to look up.
  * @returns array Array of stdClass objects each containing the 'org_name' property for the matched record.
  */
  public function get_org_data($id)
  {
      
    $this->db->select('org_name');  
    $session_comp_email = $this->session->userdata('company_email');
    $session_company    = $this->session->userdata('company_name');
    $this->db->where('id', $id);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    return $this->db->get($this->table)->result();
    
  }
  
  public function deleteContact($dataArr,$orgName)
  {
    //$this->db->set('delete_status',2);
    $this->db->where('org_name', $orgName);
   // $this->db->where('contact_type', 'Customer');
    $this->db->update('contact',$dataArr);
  }
  
  
  
  public function delete_bulk($id)
  {
    $this->db->set('delete_status',2);
    $this->db->where('id', $id);
    $this->db->update($this->table);
  }
  
  
  /**
  * Retrieve organizations whose name partially matches the provided query and belong to the current session company/email, filtered to active customers/vendors.
  * @example
  * $result = $this->Organization_model->get_org_name('Acme', 'user@example.com', 'Acme Corp', 'comp@example.com');
  * print_r($result); // e.g. Array ( [0] => stdClass Object ( [org_name] => Acme Corp [customer_type] => Customer [session_company] => Acme Corp [session_comp_email] => comp@example.com ) )
  * @param {string} $org_name - Partial or full organization name to search for.
  * @param {string} $sess_eml - Session email of the current user (not used in query but kept for signature compatibility).
  * @param {string} $session_company - Company identifier from the current session to restrict results.
  * @param {string} $session_comp_email - Company email from the current session to restrict results.
  * @returns {array} Array of result objects representing matching organizations (empty array if none).
  */
  public function get_org_name($org_name,$sess_eml,$session_company,$session_comp_email)
  {
    $this->db->like('org_name', $org_name , 'both');
    //$this->db->where('sess_eml',$sess_eml);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('delete_status', '1');
    $this->db->group_start();
    $this->db->where('customer_type', 'Customer');
    $this->db->or_where('customer_type', 'Vendor');
    $this->db->or_where('customer_type', 'Both');
    $this->db->group_end();
    $this->db->order_by('org_name', 'ASC');
    // $this->db->limit(5);
    return $this->db->get($this->table)->result();
  }
  /**
  * Get organization rows for a given organization name where customer_type is 'Customer' or 'Both'.
  * @example
  * $result = $this->Organization_model->getOrgValue(['org_name' => 'Acme Corp']);
  * echo json_encode($result); // e.g. [{"id":"1","org_name":"Acme Corp","customer_type":"Customer","created_at":"2023-01-01 00:00:00"}]
  * @param array $org_name - Associative array with key 'org_name' (string) to search for.
  * @returns array Return array of database rows (result_array) matching the org_name and customer_type filter, or empty array if not found or input missing.
  */
  public function getOrgValue($org_name)
  {
    $response = array();
    if($org_name['org_name'])
    {
      $this->db->select('*');
      $this->db->where('org_name',$org_name['org_name']);
      $this->db->group_start();
      $this->db->where('customer_type', 'Customer');
      $this->db->or_where('customer_type', 'Both');
      $this->db->group_end();
      $o = $this->db->get($this->table);
      $response = $o->result_array();
    }
    return $response;
  }
  /**
  * Retrieve the organization name (org_name) for a given organization ID, constrained by the current session's company and email and the deletion status.
  * @example
  * $result = $this->Organization_model->OrgForCon(5);
  * echo $result // Acme Corporation
  * @param {int} $id - Organization record ID to look up.
  * @returns {string|null} Organization name if found, or null if no matching record exists.
  */
  public function OrgForCon($id)
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select("org_name");
    if($this->session->userdata('type') == 'admin')
    {
      $this->db->where('id',$id);
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
    }
    else
    {
      $this->db->where('id',$id);
      $this->db->where('sess_eml',$sess_eml);
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
    }
    $this->db->where('delete_status',1);
    $this->db->from($this->table);
    $query = $this->db->get();
    return $query->row()->org_name;
  }
  /**
  * Retrieve contacts for the current session filtered by organization name.
  * @example
  * $result = $this->Organization_model->getByOrg('Acme Corporation');
  * // $result => [
  * //   ['id' => 10, 'org_name' => 'Acme Corporation', 'name' => 'John Doe', 'email' => 'john@example.com', ...],
  * //   ...
  * // ] or FALSE when no records found
  * @param {string} $org_name - Organization name to filter contacts by.
  * @returns {array|false} Array of associative arrays representing contact rows ordered by id desc, or FALSE if none found.
  */
  public function getByOrg($org_name)
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select("*");
    $this->db->where('org_name',$org_name);
    $this->db->where('sess_eml',$sess_eml);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->from("contact");
    $this->db->order_by("id", "desc");
    $query = $this->db->get();
    return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  /**
  * Check whether an organization with the given name (and optional email) exists for the current session company.
  * @example
  * $result = $this->Organization_model->check_org('Acme Inc', 'info@acme.example');
  * echo $result; // 202 if exists, 200 if not
  * @param {string} $org_name - Organization name to check.
  * @param {string} $email - (optional) Email address to match; provide empty string to ignore email check.
  * @returns {int} HTTP-like status code: 202 when a matching record exists, 200 when no record is found.
  */
  public function check_org($org_name, $email='')
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->where('org_name' , $org_name);
	if($email!=""){
		$this->db->where('email' , $email);
	}
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $query = $this->db->get($this->table);
    if($query->num_rows()>0)
    {
     return 202;
    }
    else
    {
     return 200;
    }  
  }
  
    
  /**
  * Check whether an organization with the same primary contact, name and email already exists (only active records where delete_status = 1 and customer_type is 'Customer' or 'Both').
  * @example
  * $result = check_duplicate_org_name(42, 'Acme Corp', 'info@acme.com');
  * print_r($result); // sample output: Array ( [sess_eml] => 'abc123' [org_name] => 'Acme Corp' [primary_contact] => '42' [email] => 'info@acme.com' )
  * @param int $primary_contact - Primary contact ID to match.
  * @param string $organization - Organization name to check for duplicates.
  * @param string $email - Email address of the organization to match.
  * @returns array|false Returns the organization row as an associative array if a duplicate exists, or false if none found.
  */
  function check_duplicate_org_name($primary_contact,$organization,$email)
  {
    $this->db->select('sess_eml,org_name,primary_contact,email');
    $this->db->from('organization');
    $this->db->where('primary_contact',$primary_contact);
    $this->db->where('org_name',$organization);
	$this->db->where('email',$email);
	$this->db->where('delete_status',1);
	$this->db->group_start();
    $this->db->where('customer_type', 'Customer');
    $this->db->or_where('customer_type', 'Both');
    $this->db->group_end();
	
    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      return $query->row_array();
    }
    else
    {
      return false;
    }
  }

// Please Write Code Above This  

    function OrganizationListLast() {
        $this->db->select('*');
        $this->db->from('organization');
        $this->db->where('MONTH(datetime)', 'MONTH(NOW()) - 1', FALSE);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get()->result_array();
    }


  public function mass_save($mass_id, $dataArry)
  {
    // print_r($mass_id);die;
    $this->db->where('id', $mass_id);
    if($this->db->update('organization', $dataArry)){
		  return true;
		}else{
      return false;
    }
  }
}
?>
