<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{
  var $table = 'standard_users';
  var $sort_by = array('standard_name','standard_email','standard_mobile','company_website','company_gstin',null);
  var $search_by = array('standard_name','standard_email','standard_mobile','company_website');
  var $order = array('id' => 'desc');
  /**
   * Build the active CodeIgniter query for server-side DataTables.
   * Applies a company_email filter for admin sessions, enforces delete_status = '1',
   * adds a global search across configured $this->search_by columns when $_POST['search']['value'] is present,
   * and applies ordering from $_POST['order'] (falls back to $this->order if set).
   * @example
   * // Example session (implicit):
   * // $this->session->userdata('type') => 'admin'
   * // $this->session->userdata('email') => 'admin@company.com'
   * // $this->session->userdata('company_email') => 'admin@company.com'
   * // Example POST for search/order (implicit):
   * // $_POST['search']['value'] => 'john'
   * // $_POST['order'][0]['column'] => 1
   * // $_POST['order'][0]['dir'] => 'desc'
   * $this->_get_datatables_query();
   * // To inspect the generated SQL:
   * echo $this->db->get_compiled_select();
   * // Possible output (example):
   * // SELECT * FROM `login` WHERE `company_email` = 'admin@company.com' AND `delete_status` = '1' 
   * // AND (`username` LIKE '%john%' OR `email` LIKE '%john%') ORDER BY `id` DESC
   * @param array|null $post Optional global POST data used for search and ordering (reads $_POST['search']['value'] and $_POST['order']).
   * @returns void Modifies the $this->db query builder; does not return a value.
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
    $this->db->where('delete_status','1');
    return $this->db->count_all_results();
  }
  
  public function plan_name($plnid){
      
    $this->db->from('team365_plan');
	$this->db->where('id',$plnid);
    $query = $this->db->get();
    return $query->row_array();
  }
  
 public function updateLicence($arrData,$id)
  {
    $this->db->where('session_company',$this->session->userdata('company_name'));
    $this->db->where('id',$id);
    $this->db->update('licence_detail', $arrData);
    return $this->db->affected_rows();
  }
  
  public function insertplan($arrData)
  {
    $this->db->insert('licence_detail', $arrData);
    return $this->db->insert_id();
  }
  
   public function updateofferrow($data,$id)
  {
      $this->db->where('admin_id',$id);
      $this->db->where('licence_type', 'offer' );
      $this->db->update('licence_detail', $data);
      return $this->db->affected_rows();
  }
  
  /**
  * Retrieve a single 'offer' licence record for the given admin/session ID.
  * @example
  * $offer = $this->Login_model->getoffer(42);
  * print_r($offer); // Array ( [id] => 7 [admin_id] => 42 [licence_type] => offer [licence_key] => ABC123 [expires_at] => 2026-01-01 )
  * @param {int|string} $sess_id - Admin/session identifier used to filter licence records.
  * @returns {array|null} Return associative array of the licence_detail row when found, or null if no record exists.
  */
  public function getoffer($sess_id)
  {
        $id = $this->session->userdata('id');
        $this->db->select('*');
        $this->db->from('licence_detail');
        $this->db->where('admin_id', $sess_id);
        $this->db->where('licence_type', 'offer' );
        $this->db->limit(1);
        $query = $this->db->get();
    
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
  }
  
  
   /**
   * Retrieve licence detail(s) joined with plan information for the current session/company; returns a single associative array when a plan ID is provided or an array of associative arrays when no plan ID is given.
   * @example
   * $result = $this->Login_model->yourplanid('3');
   * print_r($result); // sample output when planId provided: Array ( [id] => 12 [plan_id] => 3 [plan_name] => "Pro" [month_price] => "29.00" [annual_price] => "290.00" [session_company] => "ExampleCo" [session_comp_email] => "info@example.co" )
   * $all = $this->Login_model->yourplanid();
   * print_r($all); // sample output when no planId: Array ( [0] => Array ( ... ), [1] => Array ( ... ) )
   * @param string $planId - Optional plan ID to filter licence details; pass empty string to fetch all licences for the current session/company.
   * @returns array|array[] Return a single associative array when $planId is provided, otherwise an array of associative arrays.
   */
   public function yourplanid($planId=""){
      
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $id = $this->session->userdata('id');
    $this->db->select('licence_detail.*,team365_plan.plan_name,team365_plan.month_price,team365_plan.annual_price');
    $this->db->from('licence_detail');
    $this->db->join('team365_plan','team365_plan.id=licence_detail.plan_id');
    if($planId==""){
    $this->db->where('licence_detail.admin_id' , $id);
    }
    // $this->db->where('licence_detail.delete_status' , 1);
	$this->db->where('licence_detail.session_company',$session_company);
    $this->db->where('licence_detail.session_comp_email',$session_comp_email);
    if($planId!=""){
       $this->db->where('licence_detail.plan_id',$planId); 
    }
    $query = $this->db->get();
    if($planId!="")
    {
        return $query->row_array();
    }else{
        return $query->result_array();
    }
      
  }
 
  
  public function get_admin_detail()
  {
    $session_comp_email = $this->session->userdata('company_email');
	$this->db->select('*');
    $this->db->from('admin_users');
	$this->db->where('company_email',$session_comp_email);
	$this->db->where('company_name',$this->session->userdata('company_name'));
	$this->db->where('type','admin');
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
  
  /**
  * Update the one-time password (OTP) activation code and its expiration key for an admin user identified by email.
  * @example
  * $result = $this->Login_model->updateOtpCode('admin@example.com', 'ABC123', '2025-12-31 23:59:59', 'email');
  * echo $result // 1
  * @param {string} $email - Admin user's email address used to identify the record.
  * @param {string} $activation_code - OTP or activation code to store (e.g. 'ABC123').
  * @param {string} $key - Expiration timestamp or key for the activation code (e.g. '2025-12-31 23:59:59').
  * @param {string} $toupdate - Which code to update: use 'email' to set activation_code, any other value will set mo_activation_code.
  * @returns {int} Number of rows affected by the update (0 if no change, 1 if updated).
  */
  public function updateOtpCode($email,$activation_code,$key,$toupdate)
  {
      if($toupdate=='email'){
    	  $data=array(
    	  'activation_code' =>$activation_code,
    	  'password_key_valid_untill' => $key
    	  );
      }else{
         $data=array(
    	  'mo_activation_code' =>$activation_code,
    	  'password_key_valid_untill' => $key
    	  ); 
      }
	 $this->db->where('admin_email',$email);
     $this->db->update("admin_users", $data);
     return $this->db->affected_rows();
  }
  
   public function updateOtpCodeStd($email,$activation_code,$key,$toupdate)
  {
    	  $data=array(
    	  'otp_code' =>$activation_code,
    	  'password_key_valid_untill' => $key
    	  );
	 $this->db->where('standard_email',$email);
     $this->db->update("standard_users", $data);
     return $this->db->affected_rows();
  }
  
  public function updateCheckOtpStd($otp){
	$this->db->from('standard_users');
	$email=$this->session->userdata('email_secur');
    $this->db->where('standard_email',$email);
    $this->db->where('otp_code',$otp);
    $query = $this->db->get();
    return $query->row();  
  }
   public function updateCheckOtp($otp){
	$this->db->from('admin_users');
    $email=$this->session->userdata('email_secur');
    $this->db->where('mo_activation_code',$otp);
    $query = $this->db->get();
    return $query->row();  
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
  
  // CheckLogin via team365
  public function check_admin($subdomain_name,$code)
  {
    $this->db->where('sub_domain',$subdomain_name);
    $this->db->where('sub_domain_login',$code);
    $result = $this->db->get('admin_users',1);
    return $result;
  }
  
   public function check_user($subdomain_name,$code)
  {
    $this->db->where('sub_domain',$subdomain_name);
    $this->db->where('sub_domain_login',$code);
    $result = $this->db->get('standard_users',1);
    return $result;
  }
  
  public function change_code($id)
  {
    $this->db->set('sub_domain_login','');
    $this->db->where('id',$id);
    $this->db->update('admin_users');
  }
  
  /* IT IS ONLY FOR LOCAL*/
  /*public function validate_admin($email,$password, $product_type='')
  {
    $this->db->where('admin_email',$email);
    $this->db->where('admin_password',$password);
    if($product_type != ''){
      $this->db->where('product_type',$product_type); 
    }
    $result = $this->db->get('admin_users',1);
    return $result;
  }
  public function validate_user($email,$password,$product_type='')
  {
    $this->db->where('standard_email',$email);
    $this->db->where('standard_password',$password);
    if($product_type != ''){
      $this->db->where('product_type',$product_type); 
    }
    $result = $this->db->get('standard_users',1);
    return $result;
  }*/
  
  public function validate_admin($email,$password,$subDomain, $product_type='')
  {
    $this->db->where('admin_email',$email);
    $this->db->where('admin_password',$password);
    $this->db->where('sub_domain',$subDomain);
    if($product_type != ''){
      $this->db->where('product_type',$product_type); 
    }
    $result = $this->db->get('admin_users',1);
    return $result;
  }
  public function validate_user($email,$password,$subDomain,$product_type='')
  {
    $this->db->where('standard_email',$email);
    $this->db->where('standard_password',$password);
    $this->db->where('sub_domain',$subDomain);
    if($product_type != ''){
      $this->db->where('product_type',$product_type); 
    }
    $result = $this->db->get('standard_users',1);
    return $result;
  }
  
  
  public function available_loginUser($company_name,$company_email)
  {
    $this->db->where('company_name',$company_name);
    $this->db->where('company_email',$company_email);
    $result = $this->db->get('admin_users')->row_array();
    return $result;
  }
  
  
  /**
  * Register a new admin user (inserts a record into admin_users table) and return the new record ID or false on failure.
  * @example
  * $result = $this->Login_model->register('John Doe','john@example.com','5551234567','P@ssw0rd','company@example.com','owner','standard',1,'ACTCODE123','johndoe');
  * echo $result; // 42
  * @param string $admin_name - Admin user's full name.
  * @param string $admin_email - Admin user's email address.
  * @param string $admin_mobile - Admin user's mobile number.
  * @param string $admin_password - Admin user's password (stored as provided).
  * @param string $company_email - Company contact email.
  * @param string $type - Account type/category.
  * @param string $product_type - Product type assigned to the account.
  * @param int|bool $active - Active flag (1 or true = active, 0 or false = inactive).
  * @param string $activation_code - Mobile/activation code for the account.
  * @param string $yourUrlname - Requested sub-domain / URL name (sub_domain).
  * @returns int|false Return insert_id (int) on success, or false on failure.
  */
  public function register($admin_name,$admin_email,$admin_mobile,$admin_password,$company_email,$type,$product_type,$active,$activation_code,$yourUrlname)
  {
    $data = array(
      'sub_domain' 		=> $yourUrlname,
      'admin_name' 		=> $admin_name,
      'admin_email' 	=> $admin_email,
      'admin_mobile' 	=> $admin_mobile,
      'admin_password' 	=> $admin_password,
      'company_email' 	=> $company_email,
      'account_type' 	=> "Trial",
      'trial_end_date' 	=> date('Y-m-d', strtotime('+1 year')),
      'type' 			=> $type,
      'product_type' 	=> $product_type,
      'active' 			=> $active,
      'mo_activation_code' => $activation_code,
      'your_plan_id'    => 4
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
  * Activates an admin user account by validating activation codes and setting the active flag.
  * @example
  * $result = $this->Login_model->activate_account('ACT12345','MOB67890',1,42);
  * echo $result; // true (if activation succeeded) or false (if activation failed)
  * @param {{string}} {{$activation_code}} - Primary activation code to validate the account.
  * @param {{string}} {{$mobile_activation_code}} - Mobile activation code to validate the account.
  * @param {{int}} {{$active}} - Value to set for the 'active' column (e.g., 1 for active, 0 for inactive).
  * @param {{int}} {{$id}} - ID of the admin user record to update.
  * @returns {{bool}} Return true if a single row was updated (activation successful), false otherwise.
  */
  public function activate_account($activation_code,$mobile_activation_code,$active,$id)
  {
    $data = array(
      'active'=>$active
    );
		$this->db->where('id', $id);
		$this->db->where('activation_code', $activation_code);
		$this->db->where('mo_activation_code', $mobile_activation_code);
		$this->db->update('admin_users', $data);
		if ($this->db->affected_rows() == '1') {
		    return true;
		}else
		{
		    return false;
		}
  }
  public function get_account_status($id)
  {
    $this->db->select('admin_name,admin_email,admin_mobile,account_type,active,trial_end_date,created_date');
    $this->db->where('id',$id);
    $this->db->from("admin_users");
    $query = $this->db->get();
    return $query->row();
  }
  //get super admin
  public function get_superadminDetails()
  {
    $this->db->select('admin_email');
    $this->db->where('type','superadmin');
	$this->db->where('active',1);
    $this->db->from("admin_users");
    $query = $this->db->get();
    return $query->row_array();
  }
  
  /**
  * Retrieve list of standard users for the currently logged-in company, ordered by standard_name ascending.
  * @example
  * $result = $this->Login_model->getusername();
  * // Sample successful output:
  * // Array (
  * //   [0] => Array (
  * //     [id] => 1
  * //     [standard_name] => 'Alice Johnson'
  * //     [company_name] => 'Acme Corp'
  * //     [company_email] => 'info@acme.com'
  * //   )
  * //   [1] => Array (
  * //     [id] => 2
  * //     [standard_name] => 'Bob Smith'
  * //     [company_name] => 'Acme Corp'
  * //     [company_email] => 'info@acme.com'
  * //   )
  * // )
  * // Or FALSE if no matching rows found:
  * // bool(false)
  * @param {void} $none - No arguments.
  * @returns {array|false} Array of user associative arrays when records exist, otherwise FALSE.
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
  
  // check admin user type
  /**
  * Check if a user exists for the current session company and is not marked deleted.
  * @example
  * $this->load->model('Login_model');
  * // session data: company_name = 'Acme Ltd', company_email = 'info@acme.test'
  * $result = $this->Login_model->checkuser();
  * echo $result; // e.g. 1
  * @returns {int} Number of matching active users for the current session company (0 if none).
  */
  public function checkuser()
  {
	
    $company_email = $this->session->userdata('company_email');
    $company_name = $this->session->userdata('company_name');
    $this->db->select('*');
    $this->db->from('standard_users');
    $this->db->where('company_name',$company_name);
    $this->db->where('company_email',$company_email);
    $this->db->where('delete_status','1');
    $query = $this->db->get();
	return $query->num_rows();
	
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
  * Retrieve branch records for the current company that match the provided branch name.
  * @example
  * $postData = ['branch_name' => 'Main Branch'];
  * $result = $this->Login_model->getbranchVals($postData);
  * print_r($result); // Example output: Array ( [0] => Array ( [id] => 1 [company_name] => "Acme Ltd" [branch_name] => "Main Branch" [delete_status] => 1 ) )
  * @param {array} $postData - Associative array expected to contain the key 'branch_name'.
  * @returns {array} Array of associative arrays representing matching branch rows (empty array if none or if 'branch_name' not provided).
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
      $this->db->where('delete_status',1);
      $o = $this->db->get('user_branch');
      $response = $o->result_array();
    }
    return $response;
  }
  
  /**
  * Retrieve the currently logged-in user's data from the database based on session type (admin or standard).
  * @example
  * // For an admin user
  * $this->session->set_userdata(['type' => 'admin', 'email' => 'admin@example.com']);
  * $this->load->model('Login_model');
  * $result = $this->Login_model->getuserdata();
  * print_r($result); // e.g. Array ( [0] => Array ( [admin_id] => 1 [admin_email] => admin@example.com [company_logo] => logo.png ... ) )
  * // For a standard user
  * $this->session->set_userdata(['type' => 'standard', 'email' => 'user@example.com']);
  * $result = $this->Login_model->getuserdata();
  * print_r($result); // e.g. Array ( [0] => Array ( [standard_id] => 5 [standard_email] => user@example.com [company_logo] => logo.png ... ) )
  * @param void $none - No arguments; uses session userdata ('type' and 'email') internally.
  * @returns array|false Return an array of associative arrays containing user data on success, or FALSE if no matching row is found.
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
  * Update the admin user's record with a password reset key and return the updated user row or FALSE if not found.
  * @example
  * $result = $this->Login_model->get_password_link('admin@example.com', 'abc123resetcode', 1700000000);
  * print_r($result); // Example output: array(0 => array('admin_id' => '1', 'admin_email' => 'admin@example.com', 'password_key' => 'abc123resetcode', 'password_key_valid_untill' => 1700000000, ...));
  * @param {string} $email - Admin user's email address to identify the record.
  * @param {string} $code - Password reset key to store in the user's record.
  * @param {int|string} $key - Expiration value (timestamp or datetime string) for the password key.
  * @returns {array|false} Return the resulting user row as an array when the email exists, or FALSE when no matching record is found.
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
  * Update a user's password reset key and return the user's database record.
  * @example
  * $result = $this->Login_model->get_u_password_link('user@example.com', 'resetCode123', '2025-12-31 23:59:59');
  * print_r($result); // Example output: Array ( [0] => Array ( [id] => 1 [standard_email] => user@example.com [password_key] => resetCode123 [password_key_valid_untill] => 2025-12-31 23:59:59 ... ) )
  * @param {string} $email - The user's email address to update.
  * @param {string} $code - The password reset key to store for the user.
  * @param {string} $key - The expiry datetime for the reset key (e.g. 'YYYY-MM-DD HH:MM:SS').
  * @returns {array|false} Return the user's row as an array if found, or FALSE if no matching user exists.
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
  * Set a password reset token and its expiry for an admin user identified by mobile number, then return the updated user record.
  * @example
  * $result = $this->Login_model->get_password_link_mobile('9123456789', 'reset_token_ABC123', '2025-12-01 12:00:00');
  * print_r($result); // Example output: Array ( [0] => Array ( ['admin_id'] => '1' ['admin_mobile'] => '9123456789' ['password_key'] => 'reset_token_ABC123' ['password_key_valid_untill'] => '2025-12-01 12:00:00' ... ) )
  * @param {string} $mobile - Mobile number of the admin user to update (e.g., '9123456789').
  * @param {string} $code - Password reset token to store in the password_key field (e.g., 'reset_token_ABC123').
  * @param {string} $key - Expiration datetime for the token (e.g., '2025-12-01 12:00:00').
  * @returns {array|false} Return the updated user row as an array if the user exists and was fetched, or FALSE if no matching user was found.
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
  * Update a user's password reset token and expiration by mobile number, then return the updated user record.
  * @example
  * $result = $this->Login_model->get_u_password_link_mobile('9876543210', 'resetToken123', '2025-01-01 12:00:00');
  * print_r($result); // render some sample output: Array ( [0] => Array ( [id] => 42 [standard_mobile] => 9876543210 [password_key] => resetToken123 [password_key_valid_untill] => 2025-01-01 12:00:00 ... ) )
  * @param {string} $mobile - Mobile number of the user to update and fetch.
  * @param {string} $code - Password reset token to assign to the user.
  * @param {string} $key - Expiration timestamp or datetime for the reset token.
  * @returns {array|false} Return user record array on success, or FALSE if no matching user found.
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
  * Reset the admin user's password for a given user ID by updating the admin_users table.
  * @example
  * $CI =& get_instance();
  * $CI->load->model('Login_model');
  * $result = $CI->Login_model->reset_password('newPass!234', 5);
  * echo $result; // true (on success) or false (on failure)
  * @param string $password - New password (plaintext or already hashed) to store.
  * @param int $id - ID of the admin user whose password will be reset.
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
  * Reset a user's password by updating the standard_users table for the given user id.
  * @example
  * $result = $this->Login_model->reset_u_password('S3cur3P@ss', 42);
  * var_dump($result); // bool(true) on success, bool(false) on failure
  * @param {string} $password - The new password value to store (plain-text or already hashed).
  * @param {int} $id - The numeric ID of the user whose password will be updated.
  * @returns {bool} True if the update operation succeeded, false otherwise.
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
  * Update the company details for an admin user identified by session email.
  * @example
  * $result = $this->Login_model->add_company_details('admin@example.com','Acme Corporation','https://www.acme.com','contact@acme.com','+11234567890','ABCDE1234F','U12345MH1975PTC000000','27ABCDE1234F2Z5','India','Maharashtra','Mumbai','400001','123 Acme Street, Business Park','Customer terms text here','Seller terms text here','Invoice declaration text here');
  * echo $result; // render some sample output value: true or false
  * @param string $sess_eml - Session email of the admin user to update.
  * @param string $company_name - Company name.
  * @param string $company_website - Company website URL.
  * @param string $company_email - Company contact email.
  * @param string $company_mobile - Company contact mobile number.
  * @param string $pan_number - Company PAN number.
  * @param string $cin - Company CIN (Corporate Identification Number).
  * @param string $company_gstin - Company GSTIN.
  * @param string $country - Company country.
  * @param string $state - Company state.
  * @param string $city - Company city.
  * @param string $zipcode - Company postal / ZIP code.
  * @param string $company_address - Full company address.
  * @param string $terms_condition_customer - Terms and conditions text for customers.
  * @param string $terms_condition_seller - Terms and conditions text for sellers.
  * @param string $invoice_declaration - Invoice declaration text.
  * @returns bool True if the update to admin_users succeeded, false otherwise.
  */
  public function add_company_details($sess_eml,$company_name,$company_website,$company_email,$company_mobile,$pan_number,$cin,
  $company_gstin,$country,$state,$city,$zipcode,$company_address,$terms_condition_customer,$terms_condition_seller,$invoice_declaration)
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
      'invoice_declaration' => $invoice_declaration,
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
  * Add a new branch record to the user_branch table for a given company.
  * @example
  * $result = $this->Login_model->addBranch('owner@company.com', 42, 'Acme Pvt Ltd', 'branch@acme.com', '9123456780', 'ABCDE1234F', 'U12345MH2019PTC123456', '27AAAPL0000A1Z5', 'India', 'Maharashtra', 'Mumbai', '400001', '123 Business St, Mumbai');
  * var_export($result); // true on success, false on failure
  * @param {{string}} {{sess_eml}} - Session or user email associated with the company.
  * @param {{int}} {{sess_id}} - Company ID (session/company identifier).
  * @param {{string}} {{company_name}} - Company name.
  * @param {{string}} {{company_email}} - Branch email address.
  * @param {{string}} {{company_mobile}} - Branch contact/mobile number.
  * @param {{string}} {{pan_number}} - Company PAN number.
  * @param {{string}} {{cin}} - Company CIN (Corporate Identification Number).
  * @param {{string}} {{company_gstin}} - Company GSTIN number.
  * @param {{string}} {{country}} - Country name.
  * @param {{string}} {{state}} - State name.
  * @param {{string}} {{city}} - City name (also used as the branch name).
  * @param {{string}} {{zipcode}} - Postal/ZIP code.
  * @param {{string}} {{company_address}} - Full postal address of the branch.
  * @returns {{bool}} Return true if the insert succeeded, false otherwise.
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
  * Update the user's login count and last_login timestamp in the given table.
  * @example
  * $this->load->model('Login_model');
  * // For an admin user with current login_count = 5
  * $this->Login_model->update_login_count('admin_users', 'jdoe', 'jdoe@example.com', 'AcmeCorp', 5);
  * // After call: login_count will be 6 and last_login set to current datetime
  * @param {string} $table_count - Name of the table to update (e.g. "admin_users" or "standard_users").
  * @param {string} $user_name - Username to match for the update (e.g. "jdoe").
  * @param {string} $user_email - User email to match for the update (e.g. "jdoe@example.com").
  * @param {string} $company_name - Company name to match for the update (e.g. "AcmeCorp").
  * @param {int} $login_count - Current login count to be incremented (e.g. 5).
  * @returns {void} Performs the update on the database; does not return a value.
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
  * Update a user's profile in the appropriate users table based on current session type.
  * @example
  * $data = ['name' => 'Jane Doe', 'email' => 'jane@example.com'];
  * $result = $this->Login_model->update_profile($data, 42);
  * echo $result; // 1 (true) on success,  (false) on failure
  * @param array $data - Associative array of column => value pairs to update.
  * @param int $id - ID of the user record to update.
  * @returns bool Returns TRUE on successful update, FALSE on failure.
  */
  public function update_profile($data,$id)
  {
    if($this->session->userdata('type') == 'admin') 
    {
      $this->db->where('id',$id);
      return $this->db->update('admin_users',$data);
    }
    else
    {
      $this->db->where('id',$id);
      return $this->db->update('standard_users',$data);
    }
  }
  
  /**
   * Get admin user(s) for the currently active company from session data.
   * @example
   * $this->load->model('Login_model');
   * $result = $this->Login_model->getadminname();
   * // Sample $result on success:
   * // [
   * //   ['admin_email' => 'admin@example.com', 'admin_name' => 'Alice Admin'],
   * //   ['admin_email' => 'support@example.com', 'admin_name' => 'Support Team'],
   * // ]
   * // Or boolean false if no matching admin users found:
   * // false
   * @returns {{array|false}} Array of associative arrays each containing 'admin_email' and 'admin_name' on success, or false when no records are found.
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
  
  
   public function deactivateAcc($admin_email,$company_email){
    	$data=array('account_type'=>"End",'status'=>"0");  
    	$this->db->where('admin_email',$admin_email);
    	$this->db->where('company_email',$company_email);
        if($this->db->update('admin_users',$data)){
          return true;
        }else {
          return false;
        }
    }
    
    public function deactivateAccUser($company_email){
    	$data=array('account_type'=>"End",'status'=>"0");  
    	$this->db->where('company_email',$company_email);
        if($this->db->update('standard_users',$data)){
          return true;
        }else {
          return false;
        }
    }
  
  
  /**
   * Retrieve opportunities for the given company email that match yesterday's date.
   * @example
   * $result = $this->Login_model->pending_opp('company@example.com');
   * print_r($result); // e.g. array(0 => array('id' => '123', 'session_comp_email' => 'company@example.com', 'currentdate' => '24.12.16', 'other_column' => 'value')) or bool(false)
   * @param {string} $company_email - Company email to filter opportunities by (matches session_comp_email column).
   * @returns {array|false} Array of associative arrays representing DB rows when records exist, otherwise FALSE.
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
  * Retrieve sales orders for the company session email from yesterday.
  * @example
  * $result = $this->Login_model->yesterday_so('company@example.com');
  * print_r($result); // sample output: Array ( [0] => Array ( ['id'] => '123' ['session_comp_email'] => 'company@example.com' ['currentdate'] => '25.12.24' ... ) )
  * @param {string} $company_email - Company session email used to filter sales orders for yesterday.
  * @returns {array|false} Returns an array of sales order rows if found, otherwise FALSE.
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
  * Retrieve purchase orders created yesterday for the specified company email.
  * @example
  * $result = $this->Login_model->yesterday_po('company@example.com');
  * print_r($result); // sample output: array( [0] => array('id' => 123, 'session_comp_email' => 'company@example.com', 'currentdate' => '25.12.24', ... ) ) or bool(false)
  * @param {string} $company_email - Company email used to filter purchase orders.
  * @returns {array|bool} Array of purchase orders (each as an associative array) when any exist, otherwise FALSE.
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
   * Retrieve opportunity records for the previous day matching the provided email.
   * @example
   * $result = $this->Login_model->pending_opp_s('user@example.com');
   * print_r($result); // Example output: Array ( [0] => Array ( 'id' => '15', 'sess_eml' => 'user@example.com', 'currentdate' => '24.12.25', ... ) ) or bool(false)
   * @param {string} $standard_email - Email address used to filter opportunity records for the previous day.
   * @returns {array|false} Return array of result rows if matches are found, otherwise FALSE.
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
   * Retrieve purchase orders scheduled for renewal in 30 days for the given email.
   * @example
   * $result = $this->Login_model->po_renewal('user@example.com');
   * // sample output when rows found:
   * // array(
   * //   array('id' => '123', 'sess_eml' => 'user@example.com', 'is_renewal' => '1', 'renewal_date' => '2025-01-15', ...),
   * // )
   * // or FALSE when none found:
   * // FALSE
   * @param string $email - User email used to filter purchase orders (matches sess_eml).
   * @returns array|false Returns an array of purchase order rows if any match, or FALSE if none found.
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
  * Update the renewal alert date for a specific purchase order record.
  * @example
  * $result = update_renewal_date('2025-12-31', 123);
  * echo $result; // true (on success) or false (on failure)
  * @param {string} $update_alert - New renewal alert date in 'YYYY-MM-DD' format.
  * @param {int} $po_id - Purchase order ID to update.
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
  * Check if a provided email belongs to an admin or a standard user.
  * @example
  * $result = $this->Login_model->checkemail('admin@example.com');
  * echo $result // 'admin' (if found in admin_users), 'standard_users' (if found in standard_users), or false;
  * @param {string} $admin_email - Email address to look up in admin_users and standard_users tables.
  * @returns {string|false} 'admin' when found in admin_users, 'standard_users' when found in standard_users, otherwise false.
  */
  public function checkemail($admin_email)
  {
    $this->db->where('admin_email' , $admin_email);
    $query = $this->db->get('admin_users');
	
	$this->db->where('standard_email' , $admin_email);
	$query2 = $this->db->get('standard_users');
	
    if($query->num_rows()>0){
      return 'admin';
    }else if($query2->num_rows()>0) {
      return 'standard_users';
    }else{
		return false;
	}		
	
  }
  /**
  * Check whether an admin mobile number exists in the admin_users table.
  * @example
  * $this->load->model('Login_model');
  * $exists = $this->Login_model->checkmobile('9876543210');
  * var_dump($exists); // bool(true) if mobile exists, bool(false) otherwise
  * @param {string} $admin_mobile - Admin mobile number to check (e.g. '9876543210').
  * @returns {bool} Return true if a record with the given mobile exists, false otherwise.
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
  
  /**
  * Check if an admin user exists for the given subdomain.
  * @example
  * $result = $this->Login_model->checkurl('admin.example');
  * var_dump($result); // bool(true) or bool(false)
  * @param {string} $admin_url - The subdomain (admin URL) to look up in the admin_users table.
  * @returns {bool} True if an admin user with the provided subdomain exists, false otherwise.
  */
  public function checkurl($admin_url)
  {
    $this->db->where('sub_domain' , $admin_url);
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
  * Get the company logo filename for a given admin user ID.
  * @example
  * $result = $this->Login_model->get_image_name(5);
  * // $result => ['company_logo' => 'company_logo_5.png']
  * if ($result !== false) {
  *     echo $result['company_logo']; // prints 'company_logo_5.png'
  * }
  * @param {int} $id - Admin user ID to look up.
  * @returns {array|false} Associative array with key 'company_logo' on success, or false if no record found.
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
  * Get the user's profile image (profile_image column) from the standard_users table by user ID.
  * @example
  * $result = $this->Login_model->get_user_profile_image(42);
  * // Sample successful output:
  * // print_r($result); // Array ( [profile_image] => 'uploads/avatars/user42.png' )
  * // Sample not found:
  * // var_dump($result); // bool(false)
  * @param {int} $id - User ID to fetch the profile image for.
  * @returns {array|false} Associative array with 'profile_image' on success, or false if no matching user found.
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
   * Retrieve company users for the currently active company in session, with optional search and ordering from POST.
   * @example
   * // Prepare session and optional POST parameters
   * $this->session->set_userdata('company_email', 'info@acme.com');
   * $this->session->set_userdata('company_name', 'Acme Inc.');
   * // Optional: server-side DataTables style search and order:
   * $_POST['search']['value'] = 'john'; // search term (optional)
   * $_POST['order'][0]['column'] = 1; $_POST['order'][0]['dir'] = 'asc'; // ordering (optional)
   * // Call model method
   * $result = $this->Login_model->get_company_users();
   * print_r($result); // sample output: [
   * //   ['id' => '1', 'email' => 'john@acme.com', 'company_name' => 'Acme Inc.', 'company_email' => 'info@acme.com', ...],
   * //   ['id' => '2', 'email' => 'jane@acme.com', ...],
   * // ]
   * @returns array Array of associative arrays for users belonging to the company (uses CI query result_array()).
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
    
    $i = 0;
		foreach ($this->search_by as $item) 
		{
		  if(isset($_POST['search']['value'])) 
		  {
			if($i===0) 
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
		}else if(isset($this->order))
		{
		  $order = $this->order;
		  $this->db->order_by(key($order), $order[key($order)]);
		}
	
    $query = $this->db->get();
    return $query->result_array();
   
  }

  ////////////// To check Duplicate User //////////////
  /**
  * Check whether a standard user with the given email already exists in the database.
  * @example
  * $result = $this->Login_model->check_duplicate_user('user@example.com');
  * echo $result; // outputs 202 if user exists, or 200 if user does not exist
  * @param {string} $standard_email - Email address of the standard user to check.
  * @returns {int} Returns 202 when a user with the email exists, or 200 when no user exists.
  */
  public function check_duplicate_user($standard_email)
  {
    $this->db->select('id');
    $this->db->from('standard_users');
    $this->db->where('standard_email', $standard_email);
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
  * Get aggregated sales order totals for the current session/company filtered by type (e.g. "standard").
  * @example
  * $result = $this->Login_model->get_total_so_amount('standard');
  * print_r($result); // sample output: Array ( [status] => approved [owner] => john.doe@example.com [sub_totals] => 12345.67 [after_discount] => 12000.00 )
  * @param {string} $type - Type of totals to retrieve; currently supports "standard" to return totals for the logged-in session user.
  * @returns {array|false} Returns associative array with keys 'status', 'owner', 'sub_totals', and 'after_discount' on success, or false if no matching records are found.
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
  * Get total profit quota sums for sales and purchase orders for the current session/company (current month).
  * @example
  * $result = $this->Login_model->get_total_profit_quota('monthly');
  * print_r($result); // Example output: Array ( [after_discount] => 12345.67 [after_discount_po] => 4567.89 ) or bool(false)
  * @param {string} $type - Optional type flag (not used by this method; can be 'monthly' for clarity).
  * @returns {array|false} Returns associative array with summed keys 'after_discount' and 'after_discount_po' on success, or false if no rows found.
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
  * Update a user's target value in the standard_users table by ID.
  * @example
  * $result = $this->Login_model->set_user_target(123, ['target' => 75]);
  * echo $result; // 200 on success, 202 on failure
  * @param {int} $id - The user ID to update.
  * @param {array} $data - Associative array of column => value pairs to update (e.g. ['target' => 75]).
  * @returns {int} Return status code: 200 if update succeeded, 202 if update failed.
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
  
  	public function get_company_details($company_name,$company_email){
	
		$this->db->select('*');
		$this->db->where('company_name',$company_name);
        $this->db->where('company_email',$company_email);
		$query = $this->db->get('admin_users');
		return $query->row_array();
		
	}
	
  /**
  * Retrieve a single standard user record matching the current session company name and email.
  * @example
  * $result = $this->Login_model->getusercontrol(1);
  * var_export($result); // e.g. array(array('id' => '5', 'standard_name' => 'Jane Doe', 'company_name' => 'Acme Corp', 'company_email' => 'info@acme.com')) or FALSE
  * @param {int} $d - Integer input (multiplied by 10 internally but not used in the query).
  * @returns {array|false} Array of user record(s) when a matching row is found, or FALSE if no matching records.
  */
	 public function getusercontrol($d)
    {
        $rd = $d*10;
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
        $this->db->select("*");
        $this->db->where('company_name',$session_company);
        $this->db->where('company_email',$session_comp_email);
        $this->db->from("standard_users");
        $this->db->order_by('standard_name','ASC');
        $this->db->limit(1, 3);
        $query = $this->db->get();
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }

//Please write code above this  
}
?>
