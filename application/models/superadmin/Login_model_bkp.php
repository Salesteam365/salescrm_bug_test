<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model
{
  var $table = 'standard_users';
  var $sort_by = array('standard_name','standard_email','standard_mobile','company_website','company_gstin',null);
  var $search_by = array('standard_name','standard_email','standard_mobile','company_website');
  var $order = array('id' => 'desc');
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
