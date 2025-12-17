<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact_model extends CI_Model
{
  var $table = 'contact';
  var $sort_by = array(null,'name','org_name','email','mobile','assigned_to','datetime');
  var $search_by = array('name','org_name','email','mobile','datetime');
  var $order = array('id' => 'desc');
  /**
   * Build and apply DataTables filtering, searching and ordering to the model's active CI database query based on session and POST input.
   * @example
   * // Example usage (no direct arguments). Assumes session and POST populated:
   * $_POST['search']['value'] = 'john';
   * $_POST['order'][0]['column'] = 1;
   * $_POST['order'][0]['dir'] = 'asc';
   * $this->session->set_userdata([
   *   'type' => 'standard',
   *   'email' => 'user@example.com',
   *   'company_email' => 'comp@example.com',
   *   'company_name' => 'ExampleCo'
   * ]);
   * $this->_get_datatables_query();
   * $query = $this->db->get();
   * $result = $query->result();
   * // echo $this->db->last_query();
   * // Sample rendered SQL:
   * // SELECT * FROM `contacts` WHERE `sess_eml` = 'user@example.com' AND `session_comp_email` = 'comp@example.com' AND `session_company` = 'ExampleCo' AND `delete_status` = 1 AND (`name` LIKE '%john%' OR `email` LIKE '%john%') ORDER BY `created_at` ASC
   * @return void Modifies the model's $this->db query builder (applies FROM, WHERE, LIKE and ORDER BY); does not return a value.
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
  public function create($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  public function primary_contact($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  /**
  * Update the contact_id field for a specific contact record.
  * @example
  * $result = $this->Contact_model->contact_id(123, 5);
  * echo $result; // true (on success) or false (on failure)
  * @param {int} $contact_id - The contact_id value to set on the record (e.g., 123).
  * @param {int} $con_id - The primary key id of the record to update (e.g., 5).
  * @returns {bool} True if the database update succeeded, false otherwise.
  */
  public function contact_id($contact_id,$con_id)
  {
    $data = array(
      'contact_id' => $contact_id,
    );
    $this->db->where('id',$con_id);
    if($this->db->update($this->table,$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }
  /**
   * Update records in the model's table. If the current session user is not an admin,
   * the update is constrained to rows matching the session email (sess_eml).
   * @example
   * $where = ['id' => 5];
   * $data  = ['name' => 'John Doe', 'email' => 'john@example.com'];
   * $result = $this->Contact_model->update($where, $data);
   * echo $result; // e.g. 1
   * @param array|string|int $where - Where clause (associative array, raw string, or ID) to select rows to update.
   * @param array $data - Associative array of column => value pairs to update.
   * @returns int Number of affected rows.
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
  
  /**
  * Update vendor record(s) in the contacts table; for non-admin sessions the update is restricted to the current session's email.
  * @example
  * $result = $this->Contact_model->vendorupdate(['id' => 5], ['name' => 'Acme Corporation']);
  * echo $result // e.g., 1
  * @param {array} $where - Associative array of WHERE conditions (e.g. ['id' => 5]).
  * @param {array} $data - Associative array of column => value pairs to update (e.g. ['name' => 'Acme Corporation']).
  * @returns {int} Number of affected rows.
  */
  public function vendorupdate($where,$data)
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
  public function auto_delete($name)
  {
    $this->db->where('name', $name);
    $this->db->delete($this->table);
    return true;
  }
  /**
  * Get organization rows for the given organization name, filtered by the current session's company name and company email.
  * @example
  * $result = $this->Contact_model->getOrgValue(['org_name' => 'Acme Corporation']);
  * echo print_r($result, true); // sample output: Array ( [0] => Array ( [id] => 1 [org_name] => Acme Corporation [session_company] => MyCompany [session_comp_email] => info@mycompany.com ) )
  * @param {array} $org_name - Associative array containing 'org_name' (e.g. ['org_name' => 'Acme Corporation']).
  * @returns {array} Array of organization rows as associative arrays, or an empty array if no match is found.
  */
  public function getOrgValue($org_name)
  {
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
        $response = array();
		$this->db->select('*');
        $this->db->where('org_name',$org_name['org_name']);
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $o = $this->db->get('organization');
        $response = $o->result_array();

	
    return $response;
  }
  /**
  * Retrieve contacts for the current session's company filtered by organization and optional contact name.
  * @example
  * $postData = ['org_name' => 'Acme Corporation', 'cnt_name' => 'John Doe'];
  * $result = $this->Contact_model->getContacts($postData);
  * print_r($result); // sample output: Array ( [0] => Array ( [id] => 12 [name] => "John Doe" [email] => "john@acme.com" [mobile] => "1234567890" [office_phone] => "0987654321" [org_name] => "Acme Corporation" ) )
  * @param {{array}} {{postData}} - Associative array with filter values. Required key: 'org_name' (string). Optional key: 'cnt_name' (string) to filter by contact name.
  * @returns {{array}} Returns an array of associative arrays representing contacts. Each contact includes keys: id, name, email, mobile, office_phone, org_name.
  */
  public function getContacts($postData)
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_company 	= $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $response = array();
    $this->db->select('id,name,email,mobile,office_phone,org_name');
    $this->db->order_by("id", "desc");
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('org_name', $postData['org_name']);
    if(isset($postData['cnt_name']) && $postData['cnt_name']!=""){
        $this->db->where('name', $postData['cnt_name']);
    }
    $contacts = $this->db->get($this->table);
    $response = $contacts->result_array();
    return $response;
  }
  /**
  * Insert multiple contacts in a single batch into the contact table and return success status.
  * @example
  * $result = $this->Contact_model->contact_batch(
  *     'user@example.com',
  *     'Acme Ltd',
  *     'info@acme.com',
  *     ['John Doe', 'Jane Smith'],
  *     123,
  *     'Acme Corporation',
  *     ['john@acme.com', 'jane@acme.com'],
  *     'https://acme.com',
  *     ['(555) 123-4567', '(555) 987-6543'],
  *     ['+15551234567', '+15559876543'],
  *     'agent_01',
  *     'Standard SLA',
  *     'Client',
  *     'USA',
  *     'CA',
  *     'USA',
  *     'CA',
  *     'Los Angeles',
  *     '90001',
  *     'San Jose',
  *     '95101',
  *     '123 Main St',
  *     '456 Other Ave',
  *     'Initial contact import',
  *     '2025-12-17 12:00:00'
  * );
  * echo $result; // render some sample output value; // 1 (true) or empty (false)
  * @param {{string}} {{$sess_eml}} - Session email of the current user (e.g. 'user@example.com').
  * @param {{string}} {{$session_company}} - Current session company name (e.g. 'Acme Ltd').
  * @param {{string}} {{$session_comp_email}} - Company email from session (e.g. 'info@acme.com').
  * @param {{string[]}} {{$contact_name_batch}} - Array of contact names to insert (e.g. ['John Doe','Jane Smith']).
  * @param {{int|string}} {{$org_id}} - Organization ID associated with the contacts (e.g. 123).
  * @param {{string}} {{$org_name}} - Organization name (e.g. 'Acme Corporation').
  * @param {{string[]}} {{$email_batch}} - Array of emails corresponding to each contact (e.g. ['john@acme.com','jane@acme.com']).
  * @param {{string}} {{$website}} - Organization or contact website (e.g. 'https://acme.com').
  * @param {{string[]}} {{$phone_batch}} - Array of office phone numbers for each contact.
  * @param {{string[]}} {{$mobile_batch}} - Array of mobile phone numbers for each contact.
  * @param {{string}} {{$assigned_to}} - Identifier of the user assigned to the contacts (e.g. 'agent_01').
  * @param {{string}} {{$sla_name}} - SLA name applied to the contacts (e.g. 'Standard SLA').
  * @param {{string}} {{$contact_type}} - Type/category of the contact (e.g. 'Client').
  * @param {{string}} {{$billing_country}} - Billing country name (e.g. 'USA').
  * @param {{string}} {{$billing_state}} - Billing state/region (e.g. 'CA').
  * @param {{string}} {{$shipping_country}} - Shipping country name (e.g. 'USA').
  * @param {{string}} {{$shipping_state}} - Shipping state/region (e.g. 'CA').
  * @param {{string}} {{$billing_city}} - Billing city (e.g. 'Los Angeles').
  * @param {{string}} {{$billing_zipcode}} - Billing postal code (e.g. '90001').
  * @param {{string}} {{$shipping_city}} - Shipping city (e.g. 'San Jose').
  * @param {{string}} {{$shipping_zipcode}} - Shipping postal code (e.g. '95101').
  * @param {{string}} {{$billing_address}} - Billing street address (e.g. '123 Main St').
  * @param {{string}} {{$shipping_address}} - Shipping street address (e.g. '456 Other Ave').
  * @param {{string}} {{$description}} - Description or notes for the contacts (e.g. 'Initial contact import').
  * @param {{string}} {{$currentdate}} - Current timestamp string used for record creation (e.g. '2025-12-17 12:00:00').
  * @returns {{bool}} Return true on successful batch insert, false otherwise.
  */
  public function contact_batch($sess_eml,$session_company,$session_comp_email,$contact_name_batch,$org_id,$org_name,$email_batch,$website,$phone_batch,$mobile_batch,$assigned_to,$sla_name,$contact_type,$billing_country,$billing_state,$shipping_country,$shipping_state,$billing_city,$billing_zipcode,$shipping_city,$shipping_zipcode,$billing_address,$shipping_address,$description,$currentdate)
  {
    for ($i = 0; $i < count($contact_name_batch); $i++)
    {
      $data[$i] = array(
        'sess_eml' => $sess_eml,
        'session_company' => $session_company,
        'session_comp_email' => $session_comp_email,
        'contact_owner' => $this->session->userdata('name'),
        'name' => $contact_name_batch[$i],
        'org_id' => $org_id,
        'org_name' => $org_name,
        'email' => $email_batch[$i],
        'website' => $website,
        'office_phone' => $phone_batch[$i],
        'mobile' => $mobile_batch[$i],
        'assigned_to' => $assigned_to,
        'sla_name' => $sla_name,
        'contact_type' => $contact_type,
        'billing_country' => $billing_country,
        'billing_state' => $billing_state,
        'shipping_country' => $shipping_country,
        'shipping_state' => $shipping_state,
        'billing_city' => $billing_city,
        'billing_zipcode' => $billing_zipcode,
        'shipping_city' => $shipping_city,
        'shipping_zipcode' => $shipping_zipcode,
        'billing_address' => $billing_address,
        'shipping_address' => $shipping_address,
        'description' => $description,
        'currentdate' => $currentdate,
      );
    }
    if($this->db->insert_batch('contact',$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  /**
  * Insert multiple contact records into the 'contact' table in a single batch.
  * @example
  * $contact_names = ['Alice Smith', 'Bob Jones'];
  * $emails = ['alice@example.com', 'bob@example.com'];
  * $phones = ['(415) 555-0001', '(415) 555-0002'];
  * $mobiles = ['+14155550001', '+14155550002'];
  * $result = $this->Contact_model->contact_batch2(
  *   'user@example.com',
  *   'Acme Inc',
  *   'info@acme.com',
  *   $contact_names,
  *   'Acme Inc',
  *   $emails,
  *   $phones,
  *   $mobiles,
  *   'https://acme.example',
  *   'sales_manager',
  *   'lead',
  *   'USA',
  *   'CA',
  *   'San Francisco',
  *   '94105',
  *   '123 Market St',
  *   'Imported contacts batch'
  * );
  * echo $result; // 125
  * @param string $sess_eml - Session user's email address.
  * @param string $session_company - Session company name (organization performing the import).
  * @param string $session_comp_email - Session company email address.
  * @param string[] $contact_name_batch - Array of contact full names to insert.
  * @param string $name - Organization name (org_name) to associate with each contact.
  * @param string[] $email_batch - Array of contact email addresses corresponding to contact_name_batch.
  * @param string[] $phone_batch - Array of office phone numbers corresponding to contact_name_batch.
  * @param string[] $mobile_batch - Array of mobile phone numbers corresponding to contact_name_batch.
  * @param string $website - Website URL to set for each contact.
  * @param string|int $asigned_to - Identifier (name or ID) of the user the contacts are assigned to.
  * @param string $contact_type - Contact type/category (e.g. 'lead', 'customer').
  * @param string $country - Billing country for each contact.
  * @param string $state - Billing state for each contact.
  * @param string $city - Billing city for each contact.
  * @param string $zipcode - Billing zipcode/postal code for each contact.
  * @param string $address - Billing/street address for each contact.
  * @param string $description - Description or notes to store for each contact.
  * @returns int|false Return the last insert ID on success (int) or false on failure.
  */
  public function contact_batch2($sess_eml,$session_company,$session_comp_email,$contact_name_batch,
  $name,$email_batch,$phone_batch,$mobile_batch,$website,$asigned_to,$contact_type,$country,$state,$city,
  $zipcode,$address,$description)
  {
    for ($i = 0; $i < count($contact_name_batch); $i++)
    {
      $data[$i] = array(
        'sess_eml' => $sess_eml,
        'session_company' => $session_company,
        'session_comp_email' => $session_comp_email,
        'contact_owner' => $this->session->userdata('name'),
        'name' => $contact_name_batch[$i],
        'org_name' => $name,
        'email' => $email_batch[$i],
        'office_phone' => $phone_batch[$i],
        'mobile' => $mobile_batch[$i],
        'website' => $website,
        'assigned_to' => $asigned_to,
        'contact_type' => $contact_type,
        'billing_country' => $country,
        'billing_state' => $state,
        'billing_city' => $city,
        'billing_zipcode' => $zipcode,
        'billing_address' => $address,
        'description' => $description,
      );
    }
    if($this->db->insert_batch('contact',$data))
    {
      return $this->db->insert_id();
    }
    else
    {
      return false;
    }
  }
  
  
  
  function insert_excel($data)
  {
    $this->db->insert_batch('contact', $data);
  }
  /**
  * Check for duplicate contact by name within a specific organization and return the contact row if found.
  * @example
  * $result = check_duplicate_contact_name('John Doe', 'Acme Inc');
  * echo print_r($result, true); // render sample output: Array ( [id] => 123 [sess_eml] => sess123 [name] => John Doe [org_name] => Acme Inc [email] => john.doe@example.com )
  * @param {{string}} {{$contact_name}} - Contact full name to search for.
  * @param {{string}} {{$organization}} - Organization name to match the contact against.
  * @returns {{array|false}} Return associative array of contact fields (id, sess_eml, name, org_name, email) if found, or false if no duplicate exists.
  */
  function check_duplicate_contact_name($contact_name,$organization)
  {
    $this->db->select('id,sess_eml,name,org_name,email');
    $this->db->from('contact');
    $this->db->where('name',$contact_name);
    $this->db->where('org_name',$organization);
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
  /**
  * Check whether a contact name already exists for the current session's company and company email; returns 202 if found (duplicate) or 200 if not found.
  * @example
  * $result = $this->Contact_model->check_contact_name('Acme Support');
  * echo $result; // 202
  * @param {string} $contact_name - Contact name to check for existence.
  * @returns {int} HTTP-like status code: 202 if contact exists, 200 if contact does not exist.
  */
  public function check_contact_name($contact_name)
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->where('name' , $contact_name);
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

  public function mass_save($mass_id, $dataArry)
  {
    // print_r($mass_id);die;
    $this->db->where('id', $mass_id);
    if($this->db->update('contact', $dataArry)){
		  return true;
		}else{
      return false;
    }
  }


// Please write code above this  
}
?>
