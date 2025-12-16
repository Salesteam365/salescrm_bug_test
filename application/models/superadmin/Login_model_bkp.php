<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model
{
  var $table = 'standard_users';
  var $sort_by = array('standard_name','standard_email','standard_mobile','company_website','company_gstin',null);
  var $search_by = array('standard_name','standard_email','standard_mobile','company_website');
  var $order = array('id' => 'desc');
  /**
  * Build the ActiveRecord query for server-side DataTables.
  * This private method configures $this->db by:
  * - restricting rows to the current admin's company_email from session,
  * - enforcing delete_status = "1",
  * - applying a global search across columns listed in $this->search_by using $_POST['search']['value'],
  * - applying ordering from $_POST['order'] or falling back to $this->order.
  * It modifies the query builder but does not return a value.
  * @example
  * // example called from inside the model (sample session/post values)
  * $this->session->set_userdata([
  *   'type' => 'admin',
  *   'email' => 'admin@example.com',
  *   'company_email' => 'company@example.com'
  * ]);
  * $_POST['search']['value'] = 'john';
  * $_POST['order'][0]['column'] = 1;
  * $_POST['order'][0]['dir'] = 'asc';
  * $this->_get_datatables_query();
  * $query = $this->db->get();
  * $result = $query->result();
  * echo count($result); // e.g. 5
  * @param void $none - No parameters.
  * @returns void Modifies $this->db query builder; does not return a value.
  */
  private function _get_datatables_query()
  {
	if($this->session->userdata('type')=='admin')
    {  
		$sess_eml = $this->session->userdata('email');
		$this->db->from($this->table);
		$this->db->where('company_email',$sess_eml);
		
		$session_company = $this->session->userdata('company_name');
		$session_comp_email = $this->session->userdata('company_email'); 
		$session_company = $this->session->userdata('company_name');
		$session_comp_email = $this->session->userdata('company_email'); 
		$this->db->where('delete_status',"1");
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
		}else if(isset($this->order))
		{
		  $order = $this->order;
		  $this->db->order_by(key($order), $order[key($order)]);
		}
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
	$session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');  
    $this->db->from($this->table);
	$this->db->where('company_name',$session_company);
    $this->db->where('company_email',$session_comp_email);
    return $this->db->count_all_results();
  }
  
  public function get_admin_detail()
  {
    $session_comp_email = $this->session->userdata('company_email');
	$this->db->select('*');
    $this->db->from('admin_users');
	$this->db->where('company_email',$session_comp_email);
	$this->db->where('company_name',$this->session->userdata('company_name'));
    $query = $this->db->get();
    return $query->result();
  }
  
  
  public function create($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }
  public function update($where,$data)
  {
    $this->db->update($this->table, $data, $where);
    $this->db->where('company_name',$this->session->userdata('company_name'));
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }
  
  public function updateOtpCode($email,$activation_code,$key)
  {
	  $data=array(
	  'activation_code' =>$activation_code,
	  'password_key_valid_untill' => $key
	  );
	 $this->db->where('admin_email',$email);
     $this->db->update("admin_users", $data);
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
  public function validate_admin($email,$password)
  {
    $this->db->where('admin_email',$email);
    $this->db->where('admin_password',$password);
    $this->db->where('type','superadmin');
    $result = $this->db->get('admin_users',1);
    return $result;
  }
  public function validate_user($email,$password)
  {
    $this->db->where('standard_email',$email);
    $this->db->where('standard_password',$password);
    $result = $this->db->get('standard_users',1);
    return $result;
  }
  /**
  * Register a new admin user into the admin_users table and return the inserted record ID on success.
  * @example
  * $result = $this->Login_model_bkp->register('John Doe','john@example.com','+1234567890','s3cr3t','company@example.com',1,1,'abc123');
  * echo $result; // e.g. 42
  * @param {{string}} {{$admin_name}} - Admin full name.
  * @param {{string}} {{$admin_email}} - Admin email address.
  * @param {{string}} {{$admin_mobile}} - Admin mobile phone number.
  * @param {{string}} {{$admin_password}} - Admin password (hashed or plain depending on caller).
  * @param {{string}} {{$company_email}} - Associated company email address.
  * @param {{int}} {{$type}} - User type identifier (e.g. 1 for superadmin).
  * @param {{int|bool}} {{$active}} - Active flag (1/true = active, 0/false = inactive).
  * @param {{string}} {{$activation_code}} - Activation code for account verification.
  * @returns {{int|false}} Insert ID of the newly created admin user on success, or false on failure.
  */
  public function register($admin_name,$admin_email,$admin_mobile,$admin_password,$company_email,
  $type,$active,$activation_code)
  {
    $data = array(
      'admin_name' => $admin_name,
      'admin_email' => $admin_email,
      'admin_mobile' => $admin_mobile,
      'admin_password' => $admin_password,
      'company_email' => $company_email,
      'type' => $type,
      'active' => $active,
      'activation_code' => $activation_code,
    );
    if($this->db->insert('admin_users',$data))
    {
      return $this->db->insert_id();
    }
    else
    {
      return false;
    }
  }
  /**
  * Activate an admin user's account by matching the provided activation code and user ID, setting the active flag.
  * @example
  * $result = $this->Login_model_bkp->activate_account('ABC123', 1, 42);
  * echo $result; // bool(true) or bool(false) - true on success, false on failure
  * @param {string} $activation_code - Activation code used to verify the admin user (e.g. 'ABC123').
  * @param {int} $active - Value to set the 'active' column to (1 for active, 0 for inactive).
  * @param {int} $id - Admin user's ID (primary key) in the admin_users table.
  * @returns {bool} Return true if the database update succeeded, false otherwise.
  */
  public function activate_account($activation_code,$active,$id)
  {
    $data = array(
      'active'=>$active
    );
		$this->db->where('id', $id);
		$this->db->where('activation_code', $activation_code);
		if($this->db->update('admin_users', $data))
		{
		    return true;
		}
		else
		{
		    return false;
		}
  }
  public function get_account_status($id)
  {
    $this->db->select('active');
    $this->db->where('id',$id);
    $this->db->from("admin_users");
    $query = $this->db->get();
    return $query->row()->active;
  }
  /**
  * Retrieve standard users for the currently logged-in session company.
  * @example
  * $result = $this->Login_model_bkp->getusername();
  * // Sample output (array of user rows) or FALSE if no users found:
  * // array(
  * //   array(
  * //     'id' => '1',
  * //     'standard_name' => 'Alice Smith',
  * //     'company_name' => 'Acme Corp',
  * //     'company_email' => 'info@acme.com',
  * //     // ... other columns
  * //   ),
  * //   array(
  * //     'id' => '2',
  * //     'standard_name' => 'Bob Jones',
  * //     'company_name' => 'Acme Corp',
  * //     'company_email' => 'info@acme.com',
  * //     // ... other columns
  * //   )
  * // )
  * @returns {array|false} Array of associative arrays (user rows) ordered by standard_name ASC, or FALSE if no rows found.
  */
  public function getusername()
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select("*");
    $this->db->where('company_name',$session_company);
    $this->db->where('company_email',$session_comp_email);
    $this->db->from("standard_users");
    $this->db->order_by('standard_name','ASC');
    $query = $this->db->get();
    return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  public function branch_name()
  {
    $company_name = $this->session->userdata('company_name');
    $this->db->select('*');
    $this->db->where('company_name',$company_name);
    $this->db->from("user_branch");
    $query = $this->db->get();
    return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  /**
  * Retrieve branch records for the provided branch name scoped to the current session company.
  * @example
  * $postData = array('branch_name' => 'Head Office');
  * $result = $this->Login_model_bkp->getbranchVals($postData);
  * print_r($result); // e.g. array(array('id' => '1', 'company_name' => 'AcmeCorp', 'branch_name' => 'Head Office', 'address' => '123 Main St', ...))
  * @param {array} $postData - Associative array expected to contain 'branch_name' key.
  * @returns {array} Array of matching branch records; returns empty array if 'branch_name' is not provided or no records found.
  */
  public function getbranchVals($postData)
  {
    $response = array();
    if($postData['branch_name'])
    {
      $company_name = $this->session->userdata('company_name');
      $this->db->select('*');
      $this->db->where('company_name',$company_name);
      $this->db->where('branch_name',$postData['branch_name']);
      $o = $this->db->get('user_branch');
      $response = $o->result_array();
    }
    return $response;
  }
  /**
  * Retrieve the currently logged-in user's data based on session type ('admin' or standard user).
  * @example
  * $this->load->model('superadmin/Login_model_bkp');
  * $result = $this->Login_model_bkp->getuserdata();
  * print_r($result); // Example output: Array ( [0] => Array ( [admin_email] => 'admin@example.com' [company_logo] => 'logo.png' ... ) ) or bool(false)
  * @param {void} none - No parameters required.
  * @returns {array|false} Returns an array of user data rows if a matching record is found, otherwise FALSE.
  */
  public function getuserdata()
  {
    $type = $this->session->userdata('type');
    $sess_eml = $this->session->userdata('email');
    if($type == 'admin')
    {
      $this->db->select('*');
      $this->db->where('admin_email',$sess_eml);
      $this->db->from("admin_users");
    }
    else
    {
      $this->db->select('standard.*,admin.company_logo as company_logo');
      $this->db->from("standard_users as standard");
      $this->db->join('admin_users as admin','admin.company_email=standard.company_email');
      $this->db->where('standard_email',$sess_eml);
      
    }
    $query = $this->db->get();
    return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  /**
  * Update an admin user's password reset key and expiry, then fetch and return the user row.
  * @example
  * $result = $this->Login_model_bkp->get_password_link('user@example.com', 'abc123', 1609459200);
  * echo print_r($result, true); // Array ( [0] => Array ( [admin_id] => 1 [admin_email] => 'user@example.com' [password_key] => 'abc123' [password_key_valid_untill] => 1609459200 ) )
  * @param {string} $email - Admin user's email address.
  * @param {string} $code - Password reset code/token to store.
  * @param {int|string} $key - Expiration value for the reset key (unix timestamp or datetime string).
  * @returns {array|false} Returns the user record as an array of associative arrays if found, or FALSE on failure.
  */
  public function get_password_link($email,$code,$key)
  {
    $data = array(
      'password_key' => $code,
      'password_key_valid_untill' => $key,
      );
      $this->db->where('admin_email',$email);
      $this->db->update('admin_users',$data);
      $this->db->select("*");
      $this->db->where('admin_email',$email);
      $this->db->from("admin_users");
      $query = $this->db->get();
      return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  /**
  * Update a user's password reset key and return the updated user record.
  * @example
  * $result = $this->Login_model_bkp->get_u_password_link('user@example.com', 'abc123', 1609459200);
  * print_r($result); // render sample output: array(0 => array('id' => '1', 'standard_email' => 'user@example.com', 'password_key' => 'abc123', 'password_key_valid_untill' => '1609459200', ...))
  * @param {string} $email - User email address to update the password reset key for.
  * @param {string} $code - Password reset key to store for the user.
  * @param {int|string} $key - Expiration timestamp (int) or datetime string for the password key.
  * @returns {array|false} Returns the updated user row as an array on success, or FALSE if no matching user was found.
  */
  public function get_u_password_link($email,$code,$key)
  {
    $data = array(
      'password_key' => $code,
      'password_key_valid_untill' => $key,
      );
      $this->db->where('standard_email',$email);
      $this->db->update('standard_users',$data);
      $this->db->select("*");
      $this->db->where('standard_email',$email);
      $this->db->from("standard_users");
      $query = $this->db->get();
      return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  public function get_password_link1($id)
  {
    $this->db->select("*");
    $this->db->where('id',$id);
    $this->db->from("admin_users");
    $query = $this->db->get();
    return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  public function get_u_password_link1($id)
  {
    $this->db->select("*");
    $this->db->where('id',$id);
    $this->db->from("standard_users");
    $query = $this->db->get();
    return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  /**
  * Update the admin user identified by mobile with a password reset key and expiry, then return the updated record.
  * @example
  * $result = $this->Login_model_bkp->get_password_link_mobile('15551234567', 'c0de1234', '2025-12-31 23:59:59');
  * echo print_r($result, true); // sample output: Array ( [0] => Array ( [admin_id] => 1 [admin_mobile] => 15551234567 [password_key] => c0de1234 [password_key_valid_untill] => 2025-12-31 23:59:59 ... ) )
  * @param {string} $mobile - Admin user's mobile number to identify the record (e.g., '15551234567').
  * @param {string} $code - Password reset key to store (e.g., 'c0de1234').
  * @param {string} $key - Expiry timestamp for the password key (e.g., '2025-12-31 23:59:59').
  * @returns {array|FALSE} Returns an array of the matching admin user record(s) if found, otherwise FALSE.
  */
  public function get_password_link_mobile($mobile,$code,$key)
  {
    $data = array(
      'password_key' => $code,
      'password_key_valid_untill' => $key,
      );
      $this->db->where('admin_mobile',$mobile);
      $this->db->update('admin_users',$data);
      $this->db->select("*");
      $this->db->where('admin_mobile',$mobile);
      $this->db->from("admin_users");
      $query = $this->db->get();
      return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  /**
  * Set a password reset key and its validity for a user identified by mobile number, then return the updated user record(s) or FALSE.
  * @example
  * $result = $this->Login_model_bkp->get_u_password_link_mobile('9876543210','resetKey123','1690000000');
  * print_r($result); // e.g. Array ( [0] => Array ( [id] => 12 [standard_mobile] => 9876543210 [password_key] => resetKey123 [password_key_valid_untill] => 1690000000 ... ) )
  * @param {string} $mobile - Mobile number of the user to update (e.g. '9876543210').
  * @param {string} $code - Password reset key to store for the user (e.g. 'resetKey123').
  * @param {int|string} $key - Expiration timestamp or validity value for the password key (e.g. 1690000000).
  * @returns {array|false} Return the updated user record(s) as an array if found, otherwise FALSE.
  */
  public function get_u_password_link_mobile($mobile,$code,$key)
  {
    $data = array(
      'password_key' => $code,
      'password_key_valid_untill' => $key,
      );
      $this->db->where('standard_mobile',$mobile);
      $this->db->update('standard_users',$data);
      $this->db->select("*");
      $this->db->where('standard_mobile',$mobile);
      $this->db->from("standard_users");
      $query = $this->db->get();
      return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  public function match_otp($id,$password_key)
  {
    $this->db->select("*");
    $this->db->where('id',$id);
    $this->db->where('password_key',$password_key);
    $this->db->from("admin_users");
    $query = $this->db->get();
    return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  public function match_otp_u($id,$password_key)
  {
    $this->db->select("*");
    $this->db->where('id',$id);
    $this->db->where('password_key',$password_key);
    $this->db->from("standard_users");
    $query = $this->db->get();
    return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  /**
  * Reset the admin user's password for the specified admin ID.
  * @example
  * $result = $this->Login_model_bkp->reset_password('NewPass!234', 42);
  * echo $result; // render true or false
  * @param string $password - New plaintext password to set for the admin user.
  * @param int $id - Admin user ID whose password will be updated.
  * @returns bool True on successful update, false otherwise.
  */
  public function reset_password($password,$id)
  {
    $data = array(
        'admin_password' => $password,
    );
    $this->db->where('id',$id);
    // $this->db->where('password_key',$password_key);
    if($this->db->update('admin_users',$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  /**
  * Reset a user's password by updating the 'standard_password' field for the given user ID.
  * @example
  * $result = $this->Login_model_bkp->reset_u_password('newP@ssw0rd', 42);
  * var_dump($result); // bool(true) on success, bool(false) on failure
  * @param {string} $password - The new password to set for the user (plain text).
  * @param {int} $id - The ID of the user whose password should be updated.
  * @returns {bool} True if the update succeeded, false otherwise.
  */
  public function reset_u_password($password,$id)
  {
    $data = array(
        'standard_password' => $password,
    );
    $this->db->where('id',$id);
    // $this->db->where('password_key',$password_key);
    if($this->db->update('standard_users',$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  /**
   * Update an admin user's company details in the admin_users table using the session email.
   * @example
   * $result = $this->Login_model_bkp->add_company_details('admin@example.com', 'Acme Ltd', 'https://acme.example', 'info@acme.example', '+911234567890', 'ABCDE1234F', 'U12345MH1990PTC012345', '27ABCDE1234F1Z5', 'India', 'Maharashtra', 'Mumbai', '400001', '123 Acme St', 'Customer terms text...', 'Seller terms text...');
   * var_export($result); // bool(true) on success, bool(false) on failure
   * @param {string} $sess_eml - Session/admin email used to identify the record to update.
   * @param {string} $company_name - Company name to save.
   * @param {string} $company_website - Company website URL to save.
   * @param {string} $company_email - Company contact email to save.
   * @param {string} $company_mobile - Company mobile/phone number to save.
   * @param {string} $pan_number - Company PAN number to save.
   * @param {string} $cin - Company CIN (Corporate Identification Number) to save.
   * @param {string} $company_gstin - Company GSTIN to save.
   * @param {string} $country - Country name to save.
   * @param {string} $state - State name to save.
   * @param {string} $city - City name to save.
   * @param {string} $zipcode - Postal/ZIP code to save.
   * @param {string} $company_address - Company address to save.
   * @param {string} $terms_condition_customer - Terms and conditions text for customers.
   * @param {string} $terms_condition_seller - Terms and conditions text for sellers.
   * @returns {bool} True if the database update succeeded, false otherwise.
   */
  public function add_company_details($sess_eml,$company_name,$company_website,$company_email,$company_mobile,$pan_number,$cin,
  $company_gstin,$country,$state,$city,$zipcode,$company_address,$terms_condition_customer,$terms_condition_seller)
  {
    $data = array(
      'company_name' => $company_name,
      'company_website' => $company_website,
      'company_email' => $company_email,
      'company_mobile' => $company_mobile,
      'pan_number' => $pan_number,
      'cin' => $cin,
      'company_gstin' => $company_gstin,
      'country' => $country,
      'state' => $state,
      'city' => $city,
      'zipcode' => $zipcode,
      'company_address' => $company_address,
      'terms_condition_customer' => $terms_condition_customer,
      'terms_condition_seller' => $terms_condition_seller,
    );
    $this->db->where('admin_email',$sess_eml);
    if($this->db->update('admin_users',$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  /**
  * Insert a new branch record for a company into the user_branch table.
  * @example
  * $result = $this->Login_model_bkp->addBranch('admin@example.com', 42, 'Acme Pvt. Ltd.', 'branch@acme.com', '+919876543210', 'ABCDE1234F', 'U12345MH1984PTC012345', '27ABCDE1234F2Z5', 'India', 'Maharashtra', 'Mumbai', '400001', '123 Business St, Mumbai');
  * var_export($result); // displays true on successful insert, false otherwise
  * @param {string} $sess_eml - Session/email of the user performing the operation.
  * @param {int} $sess_id - Company ID associated with the branch.
  * @param {string} $company_name - Registered company name.
  * @param {string} $company_email - Email address for the branch.
  * @param {string} $company_mobile - Contact mobile number for the branch.
  * @param {string} $pan_number - PAN number of the company/branch.
  * @param {string} $cin - Corporate Identification Number (CIN).
  * @param {string} $company_gstin - GSTIN number of the company.
  * @param {string} $country - Country where the branch is located.
  * @param {string} $state - State where the branch is located.
  * @param {string} $city - City where the branch is located (also used as branch_name).
  * @param {string} $zipcode - Postal / ZIP code for the branch address.
  * @param {string} $company_address - Full street address of the branch.
  * @returns {bool} Return true if insert succeeds, false on failure.
  */
  public function addBranch($sess_eml,$sess_id,$company_name,$company_email,$company_mobile,$pan_number,$cin,
        $company_gstin,$country,$state,$city,$zipcode,$company_address)
  {
    $data = array(
      'company_id' => $sess_id,
      'sess_eml' => $sess_eml,
      'company_name' => $company_name,
      'branch_name' => $city,
      'country' => $country,
      'state' => $state,
      'city' => $city,
      'zipcode' => $zipcode,
      'address' => $company_address,
      'pan' => $pan_number,
      'cin' => $cin,
      'gstin' => $company_gstin,
      'branch_email' => $company_email,
      'contact_number' => $company_mobile,
    );
    if($this->db->insert('user_branch',$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  /**
  * Update the login count and last login timestamp for a user in the specified table.
  * @example
  * // Example for an admin user:
  * $this->load->model('superadmin/Login_model_bkp');
  * $this->Login_model_bkp->update_login_count('admin_users', 'john_doe', 'john.doe@example.com', 'Acme Ltd', 5);
  * // After execution, the record for john_doe will have login_count = 6 and last_login set to the current datetime.
  * @param {string} $table_count - Table name to update (e.g. 'admin_users' or 'standard_users').
  * @param {string} $user_name - User name to match in the selected table.
  * @param {string} $user_email - User email to match in the selected table.
  * @param {string} $company_name - Company name to match in the selected table.
  * @param {int} $login_count - Current login count for the user (the function will increment this by 1).
  * @returns {void} Performs a database update; does not return a value.
  */
  public function update_login_count($table_count,$user_name,$user_email,$company_name,$login_count)
  {
    $data = array(
	   'login_count' => $login_count+1,
	   'last_login' => date('Y-m-d H:i:s')
	);
    if($table_count == "admin_users")
    {
      $this->db->where('admin_name',$user_name);
      $this->db->where('admin_email',$user_email);
      $this->db->where('company_name',$company_name);
    }
    else if($table_count == 'standard_users')
    {
      $this->db->where('standard_name',$user_name);
      $this->db->where('standard_email',$user_email);
      $this->db->where('company_name',$company_name);
    }
    $this->db->update($table_count,$data);
  }
  /**
  * Update the profile data for a user (updates admin_users if session type is 'admin', otherwise standard_users).
  * @example
  * $data = ['name' => 'Jane Doe', 'email' => 'jane@example.com'];
  * $result = $this->Login_model_bkp->update_profile($data, 42);
  * // No value is returned; the function performs the DB update. Check $this->db->affected_rows() to verify.
  * @param {array} $data - Associative array of column => value pairs to update (e.g. ['name' => 'Jane Doe', 'email' => 'jane@example.com']).
  * @param {int} $id - User ID of the record to update (e.g. 42).
  * @returns {void} No direct return value; executes an update on either admin_users or standard_users table based on session type.
  */
  public function update_profile($data,$id)
  {
    if($this->session->userdata('type') == 'admin') 
    {
      $this->db->where('id',$id);
      $this->db->update('admin_users',$data);
    }
    else
    {
      $this->db->where('id',$id);
      $this->db->update('standard_users',$data);
    }
  }
  /**
   * Retrieve the admin user(s) (name and email) for the company stored in session.
   * @example
   * // Called from a model/controller context:
   * $result = $this->Login_model_bkp->getadminname();
   * // Sample returned value:
   * // $result = [
   * //   ['admin_email' => 'admin@example.com', 'admin_name' => 'John Admin'],
   * // ];
   * print_r($result);
   * @returns {array|false} Returns an array of admin records (each with 'admin_email' and 'admin_name') when found, or false if none.
   */
  public function getadminname()
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $this->db->select('admin_email,admin_name');
    $this->db->from('admin_users');
    $this->db->where('company_name',$session_company);
    $this->db->where('company_email',$session_comp_email);
    $query = $this->db->get();
    if($query ->num_rows() > 0)
    {
      return $query->result_array();
    }
    else
    {
      return false;
    }
  }
  public function get_adminemail()
  {
      $this->db->select('*');
      $this->db->from('admin_users');
      $query = $this->db->get();
      return($query->num_rows()>0)?$query->result_array():FALSE;
  }
  /**
   * Retrieve opportunities for the given company email that were recorded on the previous day.
   * @example
   * $result = $this->Login_model_bkp->pending_opp('company@example.com');
   * print_r($result); // e.g. array([0] => ['id' => '12', 'session_comp_email' => 'company@example.com', 'currentdate' => '24.12.25', ...]) or FALSE
   * @param {string} $company_email - Company email used to filter the 'session_comp_email' column.
   * @returns {array|false} Array of associative arrays representing matching rows, or FALSE if no records found.
   */
  public function pending_opp($company_email)
  {
      $day = strtotime("-1 Day");
      $this->db->select('*');
      $this->db->from('opportunity');
      $this->db->where('session_comp_email',$company_email);
      $this->db->where('currentdate',date('y.m.d',$day));
      $this->db->order_by('id','desc');
      $query = $this->db->get();
    //   echo $this->db->last_query();die;
      return($query->num_rows()>0)?$query->result_array():FALSE;
  }
  /**
  * Retrieve sales orders from the database for yesterday for the given company email.
  * @example
  * $result = $this->Login_model_bkp->yesterday_so('company@example.com');
  * // Sample output when orders exist:
  * // Array (
  * //   [0] => Array (
  * //     'id' => '123',
  * //     'session_comp_email' => 'company@example.com',
  * //     'currentdate' => '25.12.15',
  * //     'other_field' => 'value'
  * //   )
  * // )
  * @param {string} $company_email - Company email used to filter sales orders for yesterday.
  * @returns {array|false} Return an array of sales order records if any rows found, otherwise FALSE.
  */
  public function yesterday_so($company_email)
  {
      $day = strtotime("-1 Day");
      $this->db->select('*');
      $this->db->from('salesorder');
      $this->db->where('session_comp_email',$company_email);
      $this->db->where('currentdate',date('y.m.d',$day));
      $this->db->order_by('id','desc');
      $query = $this->db->get();
    //   echo $this->db->last_query();die;
      return($query->num_rows()>0)?$query->result_array():FALSE;
  }
  /**
  * Retrieve purchase orders created yesterday for a given company email.
  * @example
  * $result = $this->Login_model_bkp->yesterday_po('admin@acme.com');
  * print_r($result); // Example output: array( [0] => array('id' => 42, 'session_comp_email' => 'admin@acme.com', 'currentdate' => '24.12.15', ... ) ) or bool(false)
  * @param {string} $company_email - Company email used to filter purchase orders.
  * @returns {array|false} Array of purchase order rows (associative arrays) if found, otherwise FALSE.
  */
  public function yesterday_po($company_email)
  {
      $day = strtotime("-1 Day");
      $this->db->select('*');
      $this->db->from('purchaseorder');
      $this->db->where('session_comp_email',$company_email);
      $this->db->where('currentdate',date('y.m.d',$day));
      $this->db->order_by('id','desc');
      $query = $this->db->get();
    //   echo $this->db->last_query();die;
      return($query->num_rows()>0)?$query->result_array():FALSE;
  }
  public function get_standardemail()
  {
      $this->db->select('*');
      $this->db->from('standard_users');
      $query = $this->db->get();
      return($query->num_rows()>0)?$query->result_array():FALSE;
  }
  /**
  * Retrieve opportunities for the given email that were recorded on yesterday's date.
  * @example
  * $result = $this->Login_model_bkp->pending_opp_s('user@example.com');
  * print_r($result);
  * // Sample output when rows exist:
  * // Array (
  * //   [0] => Array (
  * //     [id] => 123,
  * //     [sess_eml] => 'user@example.com',
  * //     [currentdate] => '24.12.15',
  * //     [title] => 'Sample Opportunity',
  * //     ...other fields...
  * //   )
  * // )
  * // When no rows found:
  * // bool(false)
  * @param {string} $standard_email - Email (sess_eml) used to filter opportunity records.
  * @returns {array|false} Return associative array of result rows if found, otherwise FALSE.
  */
  public function pending_opp_s($standard_email)
  {
      $day = strtotime("-1 Day");
      $this->db->select('*');
      $this->db->from('opportunity');
      $this->db->where('sess_eml',$standard_email);
      $this->db->where('currentdate',date('y.m.d',$day));
      $this->db->order_by('id','desc');
      $query = $this->db->get();
    //   echo $this->db->last_query();die;
      return($query->num_rows()>0)?$query->result_array():FALSE;
  }
  /**
  * Fetch purchase orders for a given session email that are marked for renewal exactly 30 days from today.
  * @example
  * $result = $this->Login_model_bkp->po_renewal('user@example.com');
  * // Possible sample output:
  * // $result = [
  * //   [
  * //     'id' => '123',
  * //     'sess_eml' => 'user@example.com',
  * //     'is_renewal' => '1',
  * //     'renewal_date' => '2025-01-15',
  * //     // ... other fields ...
  * //   ]
  * // ];
  * @param {string} $email - The session email used to filter purchase orders.
  * @returns {array|false} An array of matching purchase order records if found, or FALSE if none exist.
  */
  public function po_renewal($email)
  {
      $day = strtotime("+30 Day");
      $this->db->select('*');
      $this->db->from('purchaseorder');
      $this->db->where('sess_eml',$email);
      $this->db->where('is_renewal','1');
      $this->db->where('renewal_date',date('Y-m-d',$day));
      $this->db->order_by('id','desc');
      $query = $this->db->get();
    //   echo $this->db->last_query();die;
      return($query->num_rows()>0)?$query->result_array():FALSE;
  }
  /**
  * Update the renewal alert date for a given purchase order.
  * @example
  * $result = $this->Login_model_bkp->update_renewal_date('2025-01-01', 123);
  * echo $result ? 'true' : 'false'; // outputs 'true' when update succeeded, 'false' otherwise
  * @param {string} $update_alert - Renewal alert date (e.g. 'YYYY-MM-DD').
  * @param {int} $po_id - Purchase order ID to update (e.g. 123).
  * @returns {bool} Return true on successful update, false on failure.
  */
  public function update_renewal_date($update_alert,$po_id)
  {
      $data = array(
          'renewal_alert_date' => $update_alert,
          );
    $this->db->where('purchaseorder_id',$po_id);
    if($this->db->update('purchaseorder',$data))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  /**
  * Check whether an admin email exists in the admin_users table.
  * @example
  * $this->load->model('superadmin/Login_model_bkp');
  * $result = $this->Login_model_bkp->checkemail('admin@example.com');
  * var_dump($result); // bool(true) if exists, bool(false) if not
  * @param string $admin_email - Admin email address to check for existence.
  * @returns bool True if the email exists in admin_users, false otherwise.
  */
  public function checkemail($admin_email)
  {
    $this->db->where('admin_email' , $admin_email);
    $query = $this->db->get('admin_users');
    if($query->num_rows()>0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  /**
  * Check if an admin mobile number exists in the admin_users table.
  * @example
  * $result = $this->Login_model_bkp->checkmobile('9876543210');
  * echo $result // render some sample output value; // 1 for true, '' for false
  * @param {string} $admin_mobile - Admin mobile number to check.
  * @returns {bool} Return true if the mobile exists, false otherwise.
  */
  public function checkmobile($admin_mobile)
  {
    $this->db->where('admin_mobile' , $admin_mobile);
    $query = $this->db->get('admin_users');
    if($query->num_rows()>0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  public function update_standard_user_profile($logo_name)
  {
      $session_comp_email = $this->session->userdata('company_email');
      $data = array(
                    'company_logo' => $logo_name,
                    );
      $this->db->where('company_email',$session_comp_email);
      $this->db->update('standard_users',$data);
  }
  /**
  * Get the company logo filename for an admin user by ID.
  * @example
  * $result = $this->Login_model_bkp->get_image_name(12);
  * // on success
  * echo $result['company_logo']; // e.g. "company_logo.png"
  * // on failure
  * var_export($result); // false
  * @param {int} $id - Admin user ID to fetch the company_logo for.
  * @returns {array|false} Return associative array with key 'company_logo' on success, or false if no record found.
  */
  public function get_image_name($id)
  {
    $this->db->select('company_logo');
    $this->db->from('admin_users');
    $this->db->where('id',$id);
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
   * Retrieve a user's profile image record from the standard_users table by user ID.
   * @example
   * $result = $this->Login_model_bkp->get_user_profile_image(42);
   * // Sample output when a record exists:
   * // array('profile_image' => 'avatar_42.png')
   * echo isset($result['profile_image']) ? $result['profile_image'] : 'no image';
   * @param {int} $id - User ID to retrieve the profile image for.
   * @returns {array|false} Return associative array with key 'profile_image' if found, otherwise false.
   */
  public function get_user_profile_image($id)
  {
    $this->db->select('profile_image');
    $this->db->from('standard_users');
    $this->db->where('id',$id);
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
  public function active_basic_lic()
  {
    $license_type = "Basic";
    $company_email = $this->session->userdata('company_email');
    $company_name = $this->session->userdata('company_name');
    $this->db->where('license_type',$license_type);
    $this->db->where('company_email',$company_email);
    $this->db->where('company_name',$company_name);
    $result = $this->db->get('standard_users')->num_rows();
      return $result;
  }
  public function active_business_lic()
  {
    $license_type = "Business";
    $company_email = $this->session->userdata('company_email');
    $company_name = $this->session->userdata('company_name');
    $this->db->where('license_type',$license_type);
    $this->db->where('company_email',$company_email);
    $this->db->where('company_name',$company_name);
    $result = $this->db->get('standard_users')->num_rows();
    return $result;
  }
  public function active_enterprise_lic()
  {
    $license_type = "Enterprise";
    $company_email = $this->session->userdata('company_email');
    $company_name = $this->session->userdata('company_name');
    $this->db->where('license_type',$license_type);
    $this->db->where('company_email',$company_email);
    $this->db->where('company_name',$company_name);
    $result = $this->db->get('standard_users')->num_rows();
    return $result;
  }
  /**
  * Retrieve active users for the currently logged-in company.
  * @example
  * // From a controller after loading the model:
  * $this->load->model('superadmin/Login_model_bkp');
  * $users = $this->Login_model_bkp->get_company_users();
  * print_r($users);
  * // Sample output:
  * // Array
  * // (
  * //     [0] => Array
  * //         (
  * //             [id] => 12
  * //             [username] => johndoe
  * //             [email] => john@example.com
  * //             [company_name] => Acme Ltd
  * //             [company_email] => contact@acme.com
  * //             [delete_status] => 1
  * //         )
  * // )
  * @param {void} $none - No parameters; company info is read from session (company_email, company_name).
  * @returns {array|false} Returns an array of associative user records when found, or false if no users exist.
  */
  public function get_company_users()
  {
    $company_email = $this->session->userdata('company_email');
    $company_name = $this->session->userdata('company_name');
    $this->db->select('*');
    $this->db->from('standard_users');
    $this->db->where('company_name',$company_name);
    $this->db->where('company_email',$company_email);
    $this->db->where('delete_status','1');
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

  ////////////// To check Duplicate User //////////////
  /**
  * Check whether a standard user name already exists and return a status code.
  * @example
  * $result = $this->Login_model_bkp->check_duplicate_user('john_doe');
  * echo $result // 202 if user exists, 200 if user does not exist;
  * @param {string} $standard_name - The standardized username to check for duplication.
  * @returns {int} Return status code: 202 if the user exists, 200 if the user does not exist.
  */
  public function check_duplicate_user($standard_name)
  {
    $this->db->select('id');
    $this->db->from('standard_users');
    $this->db->where('standard_name', $standard_name);
    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      return 202; //User exist
    }
    else
    {
      return 200; //User not exist
    }
  }
  /**
  * Get total sales order amounts filtered by the current session and type.
  * @example
  * $result = $this->Login_model_bkp->get_total_so_amount('standard');
  * print_r($result);
  * // Sample output:
  * // Array (
  * //   [status] => 'confirmed',
  * //   [owner] => 'Alice Smith',
  * //   [sub_totals] => '12345.67',
  * //   [after_discount] => '12000.00'
  * // )
  * @param string $type - Type of aggregation to perform; currently supports "standard".
  * @returns array|false Associative array with keys 'status', 'owner', 'sub_totals', 'after_discount' on success, or false if no matching records found.
  */
  public function get_total_so_amount($type)
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'days');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->select('status,owner');
      $this->db->select_sum('sub_totals');
      $this->db->select_sum('after_discount');
      $this->db->from('salesorder');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('sess_eml',$sess_eml);
      $this->db->where('currentdate >=',date('y.m.d', $w));
      $this->db->where('delete_status',1);
      $this->db->group_by('sess_eml');
      // $this->db->order_by('afrtetrt','desc');
      //get records
      $query = $this->db->get();
      if($query->num_rows() > 0)
      {
        //return fetched data
        return $query->row_array();
      }
      else
      {
        return false;
      }
    }
  }
  /**
  * Get the total profit quota by summing sales and purchase order discounts for the current session/company since the start of the current month.
  * @example
  * // Example usage from a controller or model where Login_model_bkp is loaded
  * $result = $this->Login_model_bkp->get_total_profit_quota('monthly');
  * // Sample output (when rows exist)
  * // array('after_discount' => '12345.67', 'after_discount_po' => '2345.67')
  * var_export($result);
  * @param string $type - (unused) A type label (e.g. 'monthly', 'yearly'); currently ignored by the method.
  * @returns array|false Returns an associative array with summed fields (keys: after_discount, after_discount_po) on success, or false if no rows found.
  */
  public function get_total_profit_quota($type)
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'days');

    $this->db->select_sum('SO.after_discount');
    $this->db->select_sum('PO.after_discount_po');
    $this->db->from('salesorder as SO');
    $this->db->join('purchaseorder as PO', 'SO.saleorder_id = PO.saleorder_id AND PO.so_owner = SO.owner');
    $this->db->where('SO.sess_eml',$sess_eml);
    $this->db->where('SO.session_comp_email',$session_comp_email);
    $this->db->where('SO.session_company',$session_company);
    $this->db->where('PO.session_comp_email',$session_comp_email);
    $this->db->where('PO.session_company',$session_company);
    $this->db->where('SO.status','Approved');
    $this->db->where('SO.delete_status',1);
    $this->db->where('PO.delete_status',1);
    $this->db->where('SO.currentdate >=',date('y.m.d', $w));
    $this->db->where('PO.currentdate >=',date('y.m.d', $w));
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    if($query->num_rows() > 0)
    {
      return $query->row_array();
    }
    else
    {
      return false;
    }
  }
  public function get_user_target_data($id)
  {
      $this->db->select('sales_quota,profit_quota');
      $this->db->from('standard_users');
      $this->db->where('id',$id);
      $query = $this->db->get();
      return $query->row();
  }
  /**
  * Update a user's record in the 'standard_users' table for the given user id.
  * @example
  * $result = $this->Login_model_bkp->set_user_target(123, ['target' => 500]);
  * echo $result; // render some sample output value: 200
  * @param {int} $id - User ID to identify the row in 'standard_users' (e.g. 123).
  * @param {array} $data - Associative array of column => value pairs to update (e.g. ['target' => 500]).
  * @returns {int} Return code: 200 on successful update, 202 on failure.
  */
  public function set_user_target($id,$data)
  {
      $this->db->where('id',$id);
      if($this->db->update('standard_users', $data))
      {
        return 200;
      }
      else
      {
        return 202;
      }
  }
  
 /******* Superadmin model ************/
   public function get_all_loginadmin($id=0)
  {
      $this->db->select('*');
      $this->db->from('admin_users');
	  if($id !== 0){
		$this->db->where('id',$id);  
	  }
      $this->db->where('type','admin');
	  //$this->db->where('active',1);
      $query = $this->db->get();
      return $query;
  }
  
   public function status_update($id, $data)
  {
       $this->db->where('id',$id);
      if($this->db->update('admin_users', $data))
      {
        return 200;
      }
  }
  
   public function statusUser_update($id, $data)
  {
       $this->db->where('id',$id);
      if($this->db->update('standard_users', $data))
      {
        return 200;
      }
  }
  
   public function get_all_standarduser($company_email,$company_name)
  {
      $this->db->select('*');
      $this->db->from('standard_users');
      $this->db->where('company_email',$company_email);
	  $this->db->where('company_name',$company_name);
     return  $query = $this->db->get();
      //return $query->num_rows();
  }
    public function get_all_Trialloginadmin()
  {
      $this->db->select('*');
      $this->db->where('account_type','trial');
	  $this->db->where('type','admin');
      $query = $this->db->get('admin_users');
      return $query->result_array();
  }
  
  function filter_data($search_date)
       {
        $this->db->select("*");		 
        $this->db->where('status',$search_date);
	  
        return $this->db->get('standard_users');
        }
		  
   public function get_allOrganization($company_email, $company_name)
  {
      $this->db->select('*');
      $this->db->where('session_comp_email',$company_email);
	  $this->db->where('session_company',$company_name);
      $query = $this->db->get('organization');
      return $query;
  }
  
//Please write code above this  
}
?>
