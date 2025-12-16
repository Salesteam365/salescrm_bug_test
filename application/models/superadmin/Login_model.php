<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model
{
  var $table = 'standard_users';
  var $sort_by = array('standard_name','standard_email','standard_mobile','company_website','company_gstin',null);
  var $search_by = array('standard_name','standard_email','standard_mobile','company_website');
  var $order = array('id' => 'desc');
  /**
  * Build the active CodeIgniter query for server-side DataTables: applies admin session filters (company_email, delete_status), global search across configured columns ($this->search_by), and ordering ($this->sort_by or $this->order).
  * @example
  * // Example usage (typically called internally by the model before executing the query)
  * $_POST['search']['value'] = 'Acme'; // global search term
  * $_POST['order']['0']['column'] = 1; // column index to sort by
  * $_POST['order']['0']['dir'] = 'asc'; // sort direction
  * $this->session->set_userdata([
  *   'type' => 'admin',
  *   'email' => 'admin@acme.com',
  *   'company_name' => 'Acme',
  *   'company_email' => 'admin@acme.com'
  * ]);
  * $this->login_model->_get_datatables_query();
  * $result = $this->db->get()->result(); // sample output: array of matching rows (stdClass objects)
  * @returns {void} Builds the query using $this->db; does not return a value.
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
  * Register a new admin user in the admin_users table and return the inserted record ID on success.
  * @example
  * $result = $this->Login_model->register('Alice Admin','alice@example.com','+1234567890','s3cr3tP@ss','company@example.com',1,1,'ABC123TOKEN');
  * echo $result; // e.g. 42 (insert_id) or false
  * @param {string} $admin_name - Admin's full name.
  * @param {string} $admin_email - Admin's email address.
  * @param {string} $admin_mobile - Admin's mobile phone number.
  * @param {string} $admin_password - Admin's password (store hashed in production).
  * @param {string} $company_email - Associated company email address.
  * @param {int} $type - Admin user type identifier (e.g. 1 = superadmin).
  * @param {int|bool} $active - Active status flag (1/true = active, 0/false = inactive).
  * @param {string} $activation_code - Activation code or token for account verification.
  * @returns {int|false} Return newly inserted admin user ID on success, or false on failure.
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
  * Activate a user account by matching the provided activation code and user ID, then updating the active flag in the admin_users table.
  * @example
  * $result = $this->Login_model->activate_account('abc123', 1, 42);
  * echo $result // 1
  * @param {string} $activation_code - The activation code associated with the user account.
  * @param {int|bool} $active - Value to set for the active flag (1 or true to activate, 0 or false to deactivate).
  * @param {int} $id - The database ID of the admin user to update.
  * @returns {bool} Returns true if the update succeeded, false otherwise.
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
  * Retrieve standard users for the currently logged-in company ordered by name.
  * @example
  * $this->load->model('superadmin/Login_model');
  * $result = $this->Login_model->getusername();
  * print_r($result); // Example output: array(0 => array('id' => '1', 'standard_name' => 'Alice', 'company_name' => 'Acme Corp', 'company_email' => 'info@acme.com')) OR bool(false)
  * @param void $none - This method accepts no parameters.
  * @returns array|false Returns an array of associative arrays representing users when records are found, or FALSE if no users exist.
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
   * Retrieve branch records for the currently logged-in company filtered by branch name.
   * @example
   * $postData = ['branch_name' => 'Main Branch'];
   * $result = $this->Login_model->getbranchVals($postData);
   * print_r($result); // Example output: [ ['id' => '1', 'company_name' => 'Acme Ltd', 'branch_name' => 'Main Branch', 'address' => '123 Main St', ...] ]
   * @param array $postData - Associative array containing request data; expects 'branch_name' key.
   * @returns array Array of matching branch rows as associative arrays; returns empty array if no match or if 'branch_name' is not provided.
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
  * Retrieve the currently logged-in user's data (admin or standard) from the database based on session values.
  * @example
  * // Example when session type is 'admin' and email is 'admin@example.com'
  * $this->load->model('superadmin/Login_model');
  * $result = $this->Login_model->getuserdata();
  * print_r($result); // Example output: Array ( [0] => Array ( ['admin_id'] => 1, ['admin_email'] => 'admin@example.com', ['company_logo'] => 'logo.png' ) )
  * @param void $none - No arguments; method reads user type and email from session.
  * @returns array|false Returns an array of user row(s) when a matching record is found, or FALSE if no record exists.
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
  * Update an admin user's password reset key and return the updated user record.
  * @example
  * $result = $this->Login_model->get_password_link('admin@example.com', 'ABC123', '2025-12-31 23:59:59');
  * echo '<pre>'; print_r($result); // sample output: Array ( [0] => Array ( [admin_id] => 1 [admin_email] => admin@example.com [password_key] => ABC123 [password_key_valid_untill] => 2025-12-31 23:59:59 ) )
  * @param {string} $email - Admin email address to update.
  * @param {string} $code - Password reset key/token to store (password_key).
  * @param {string} $key - Expiration datetime string for the key (password_key_valid_untill).
  * @returns {array|false} Return the user record as an array on success, or FALSE if no matching user was found.
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
   * Update the password reset key and its expiry for a user identified by email, then return the user's record.
   * @example
   * $result = $this->Login_model->get_u_password_link('user@example.com', 'reset123token', 1700000000);
   * print_r($result); // Example output: Array ( [0] => Array ( [standard_id] => 1 [standard_email] => user@example.com [password_key] => reset123token [password_key_valid_untill] => 1700000000 ... ) ) or FALSE
   * @param string $email - The user's email address used to locate the record.
   * @param string $code - The password reset key/token to store for the user.
   * @param int|string $key - Expiration timestamp (Unix seconds) or string representation when the reset key becomes invalid.
   * @returns array|FALSE Return the user's row(s) as an array if found and updated, otherwise FALSE.
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
  * Update an admin user's password reset key for the given mobile number and return the updated user record.
  * @example
  * $result = $this->Login_model->get_password_link_mobile('14151234567', 'abc123', '2025-01-01 00:00:00');
  * echo var_export($result, true); // sample output: array(0 => array('admin_id' => '1', 'admin_mobile' => '14151234567', 'password_key' => 'abc123', 'password_key_valid_untill' => '2025-01-01 00:00:00', ...));
  * @param {string} $mobile - Admin mobile number to identify the user (e.g. '14151234567').
  * @param {string} $code - Password reset code to set as password_key (e.g. 'abc123').
  * @param {string} $key - Expiration timestamp/string for the password key (password_key_valid_untill) (e.g. '2025-01-01 00:00:00').
  * @returns {array|false} Return the user row as an array inside a result set on success, or FALSE if no matching mobile is found.
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
  * Update a user's password reset key and its expiry for the given mobile number, then return the updated user record.
  * @example
  * $result = $this->Login_model->get_u_password_link_mobile('9988776655', 'abc123', '2025-12-31 23:59:59');
  * print_r($result); // e.g. Array ( [0] => Array ( 'id' => '1', 'standard_mobile' => '9988776655', 'password_key' => 'abc123', 'password_key_valid_untill' => '2025-12-31 23:59:59', ... ) ) or bool(false)
  * @param {string} $mobile - User's mobile number to identify the user.
  * @param {string} $code - Password reset key/token to store for the user.
  * @param {string} $key - Expiration datetime for the password key (format: 'YYYY-MM-DD HH:MM:SS').
  * @returns {array|false} Returns an array of user data if the mobile exists; FALSE if no matching user is found.
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
   * Reset an admin user's password in the admin_users table by user ID.
   * @example
   * $result = $this->Login_model->reset_password('newPassw0rd!', 5);
   * var_dump($result); // bool(true)
   * @param string $password - New password to set for the admin user (plain text or hashed depending on caller).
   * @param int $id - ID of the admin user whose password will be updated.
   * @returns bool Return true on successful update, false otherwise.
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
  * Reset a user's password by updating the standard_users.standard_password field for the given user ID.
  * @example
  * $result = $this->Login_model->reset_u_password('NewP@ssw0rd', 42);
  * echo $result; // true
  * @param {string} $password - New plain-text password to set for the user.
  * @param {int} $id - ID of the user record to update.
  * @returns {bool} Return true if the password was updated successfully, false otherwise.
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
   * Update company details for an admin user identified by session email.
   * @example
   * $result = $this->Login_model->add_company_details(
   *     'admin@example.com',
   *     'Acme Ltd',
   *     'https://www.acme.example',
   *     'contact@acme.example',
   *     '9123456789',
   *     'ABCDE1234F',
   *     'U12345MH1999PTC000000',
   *     '27ABCDE1234F1Z5',
   *     'India',
   *     'Maharashtra',
   *     'Mumbai',
   *     '400001',
   *     '123 Acme Street, Business Park',
   *     'Customer terms text...',
   *     'Seller terms text...'
   * );
   * echo $result ? 'true' : 'false'; // render some sample output value;
   * @param string $sess_eml - Admin session email used to locate the record to update.
   * @param string $company_name - Company name.
   * @param string $company_website - Company website URL.
   * @param string $company_email - Company contact email.
   * @param string $company_mobile - Company mobile/phone number.
   * @param string $pan_number - Company PAN number.
   * @param string $cin - Company CIN (Corporate Identification Number).
   * @param string $company_gstin - Company GSTIN.
   * @param string $country - Country name.
   * @param string $state - State name.
   * @param string $city - City name.
   * @param string $zipcode - Postal / ZIP code.
   * @param string $company_address - Full company address.
   * @param string $terms_condition_customer - Terms & conditions text for customers.
   * @param string $terms_condition_seller - Terms & conditions text for sellers.
   * @returns bool Return true if the database update succeeded, false otherwise.
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
  * Add a new branch record for a company into the user_branch table.
  * @example
  * $result = $this->Login_model->addBranch('admin@example.com', 123, 'Acme Pvt Ltd', 'branch@example.com', '+911234567890', 'ABCDE1234F', 'U12345MH2020PTC000000', '27ABCDE1234F1Z5', 'India', 'Maharashtra', 'Mumbai', '400001', '123 Marine Drive, Colaba');
  * var_export($result); // true or false
  * @param {string} $sess_eml - Session email of the user performing the operation.
  * @param {int} $sess_id - Company id (session company identifier).
  * @param {string} $company_name - Name of the company.
  * @param {string} $company_email - Email address for the new branch.
  * @param {string} $company_mobile - Contact/mobile number for the branch.
  * @param {string} $pan_number - PAN number of the company/branch.
  * @param {string} $cin - Corporate Identification Number (CIN) of the company.
  * @param {string} $company_gstin - GSTIN of the company.
  * @param {string} $country - Country where the branch is located.
  * @param {string} $state - State where the branch is located.
  * @param {string} $city - City name used as the branch name and city field.
  * @param {string} $zipcode - Postal/ZIP code for the branch address.
  * @param {string} $company_address - Full address of the branch.
  * @returns {bool} True if insert succeeded, otherwise false.
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
  * Increment a user's login count by one and update their last_login timestamp in the given users table.
  * @example
  * // For an admin user currently with login_count = 3
  * $this->update_login_count('admin_users', 'jane.doe', 'jane@example.com', 'Acme Inc', 3);
  * // After call: login_count becomes 4 and last_login set to current datetime.
  * @param {string} $table_count - Database table to update (e.g., 'admin_users' or 'standard_users').
  * @param {string} $user_name - Username to match for the update.
  * @param {string} $user_email - Email to match for the update.
  * @param {string} $company_name - Company name to match for the update.
  * @param {int} $login_count - Current login count for the user (will be incremented by one).
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
  * Update a user's profile in the database. Chooses the admin_users table if the current session user type is 'admin', otherwise updates the standard_users table.
  * @example
  * $result = $this->Login_model->update_profile(['email' => 'new@example.com', 'name' => 'John Doe'], 42);
  * // This method does not return a value; it performs the update operation on the database.
  * @param array $data - Associative array of column => value pairs to update (e.g. ['email' => 'new@example.com']).
  * @param int|string $id - ID of the user record to update (e.g. 42 or '42').
  * @returns void Returns nothing; performs the database update on the appropriate table.
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
   * Get admin name and email for the company stored in session.
   * @example
   * // If session has: company_name = 'Acme Ltd', company_email = 'admin@acme.com'
   * $result = $this->Login_model->getadminname();
   * // Sample $result:
   * // [
   * //   0 => ['admin_email' => 'admin@acme.com', 'admin_name' => 'John Doe']
   * // ]
   * print_r($result);
   * @returns array|false Returns an array of admin rows (with 'admin_email' and 'admin_name') on success, or false if no matching admin found.
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
  * Retrieve opportunities for the given company email for the previous day.
  * @example
  * $result = $this->Login_model->pending_opp('sales@example.com');
  * var_dump($result); // sample output: array(0 => array('id' => '12', 'session_comp_email' => 'sales@example.com', 'currentdate' => '24.12.25', ...)) or bool(false)
  * @param string $company_email - Company email address used to filter opportunity records.
  * @returns array|false Return an array of associative result rows when records exist, otherwise FALSE.
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
  * Retrieve sales orders for the given company that were created yesterday.
  * @example
  * $result = $this->Login_model->yesterday_so('admin@company.com');
  * print_r($result); // Example output: Array ( [0] => Array ( 'id' => '123', 'session_comp_email' => 'admin@company.com', 'currentdate' => '25.12.24', ... ) ) or bool(false)
  * @param {string} $company_email - Company email used to filter sales orders by session_comp_email.
  * @returns {array|false} Array of associative arrays representing yesterday's sales orders, or FALSE if no records found.
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
  * Get purchase orders from yesterday for the specified company email.
  * @example
  * $result = $this->Login_model->yesterday_po('company@example.com');
  * print_r($result); // Example output: Array ( [0] => Array ( 'id' => '123', 'session_comp_email' => 'company@example.com', 'currentdate' => '25.12.24', ... ) ) or bool(false)
  * @param {string} $company_email - Company email used to filter yesterday's purchase orders.
  * @returns {array|false} Purchase orders as an array when records are found, or FALSE if none exist.
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
   * Fetch pending opportunities for the given standard email for yesterday's date.
   * @example
   * $result = $this->Login_model->pending_opp_s('user@example.com');
   * echo '<pre>'; print_r($result); // Example output: Array ( [0] => Array ( [id] => 42, [sess_eml] => 'user@example.com', [currentdate] => '24.12.15', [other_field] => 'value' ) ) or bool(FALSE)
   * @param {string} $standard_email - Standard email (sess_eml) used to filter opportunity records.
   * @returns {array|false} Returns an array of opportunity rows (ordered by id desc) for yesterday's date, or FALSE if no records found.
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
  * Retrieve purchase orders for a given email that are due for renewal in 30 days.
  * @example
  * $result = $this->Login_model->po_renewal('user@example.com');
  * print_r($result); // sample output: array(0 => array('id' => '123', 'sess_eml' => 'user@example.com', 'is_renewal' => '1', 'renewal_date' => '2025-01-15', ...)) or FALSE
  * @param {string} $email - Email address used to filter purchase orders for 30-day renewal.
  * @returns {array|false} Return an array of matching purchase orders when found, otherwise FALSE.
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
  * Update the renewal alert date for a specific purchase order.
  * @example
  * $result = $this->Login_model->update_renewal_date('2025-12-31', 123);
  * echo $result // render some sample output value; // 1 (true) on success, empty/0 on failure
  * @param {string} $update_alert - New renewal alert date in 'YYYY-MM-DD' format.
  * @param {int} $po_id - Purchase order ID to update (e.g. 123).
  * @returns {bool} Return true on successful update, false otherwise.
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
  * $exists = $this->Login_model->checkemail('admin@example.com');
  * echo $exists ? 'true' : 'false'; // renders 'true' if email exists, otherwise 'false'
  * @param string $admin_email - The admin email address to check for existence.
  * @returns bool True if the admin email exists in the admin_users table, false otherwise.
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
  * Check whether an admin user with the given mobile number exists.
  * @example
  * $result = $this->Login_model->checkmobile('9876543210');
  * var_dump($result); // bool(true) if mobile exists, bool(false) otherwise
  * @param {string} $admin_mobile - Admin user's mobile number to check.
  * @returns {bool} True if a user with the provided mobile exists, false otherwise.
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
   * $result = $this->Login_model->get_image_name(5);
   * echo $result['company_logo']; // outputs "company_logo.png"
   * @param {int} $id - Admin user ID to look up.
   * @returns {array|false} Associative array with 'company_logo' on success, or false if no record found.
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
  * Retrieve the profile_image column for a user by ID.
  * @example
  * $this->load->model('superadmin/Login_model');
  * $result = $this->Login_model->get_user_profile_image(42);
  * print_r($result); // Array ( [profile_image] => 'uploads/profiles/user42.jpg' ) on success, or bool(false) on failure
  * @param int $id - The ID of the user to fetch the profile image for.
  * @returns array|false Associative array with key 'profile_image' on success, or false if the user is not found.
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
  * Retrieve all users that belong to the currently logged-in company.
  * @example
  * // Assuming session values: company_email = 'acme@example.com', company_name = 'Acme Inc.'
  * $users = $this->Login_model->get_company_users();
  * print_r($users); // e.g. array([0] => ['id'=>12,'name'=>'Jane Doe','email'=>'jane@acme.com', ...]) or bool(false)
  * @param void $none - No parameters; company information is taken from session data.
  * @returns array|false Returns an array of users (result_array) when matches exist, or false if no users found.
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
  * Check if a standard user name already exists in the standard_users table.
  * @example
  * $result = $this->Login_model->check_duplicate_user('john_doe');
  * echo $result // 202 (user exists) or 200 (user does not exist);
  * @param {string} $standard_name - User name to check for duplication (e.g. 'john_doe').
  * @returns {int} HTTP-like status code: 202 when the user exists, 200 when the user does not exist.
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
  * Get total sales order amounts for the current session/company for the current month when type is "standard".
  * @example
  * $result = $this->Login_model->get_total_so_amount('standard');
  * print_r($result); // Example output: Array ( [status] => confirmed [owner] => John Doe [sub_totals] => 1500.00 [after_discount] => 1400.00 )
  * @param {string} $type - Type of total to compute; currently accepts "standard".
  * @returns {array|false} Returns an associative array of summed fields (sub_totals, after_discount) plus status and owner when records exist, or false if no records found.
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
  * Get total profit quota sums for the current session company and user from the beginning of the current month.
  * @example
  * $result = $this->Login_model->get_total_profit_quota('monthly');
  * print_r($result); // Example output: Array ( [after_discount] => 1500.00 [after_discount_po] => 500.00 )
  * @param {string} $type - Optional filter type (not used by current implementation; e.g., 'monthly').
  * @returns {array|false} Return associative array with summed values ('after_discount' and 'after_discount_po') or false if no matching records.
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
  * Update a user's target values in the standard_users table by user id.
  * @example
  * $result = $this->Login_model->set_user_target(12, ['target' => 5000]);
  * echo $result; // 200
  * @param {int} $id - The ID of the user to update.
  * @param {array} $data - Associative array of column => value pairs to update (e.g. ['target' => 5000]).
  * @returns {int} HTTP-like status code: 200 on successful update, 202 on failure.
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
