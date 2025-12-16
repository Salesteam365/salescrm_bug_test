<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home_model extends CI_Model
{
  
 /******* Superadmin model ************/
  var $table = 'admin_users';
  var $sort_by = array(null,'company_name','admin_email','company_website','admin_mobile');
  var $search_by = array('admin_name','company_name','admin_email','company_website','admin_mobile','user_type','license_activation_date','invoice_license_active_date','license_expiration_date','invoice_license_exp_date','license_type','invoice_license_type','invoice_account_type','license_duration','invoice_license_duration','invoice_lic_amnt');
  var $order = array('id' => 'desc');
  /**
   * Builds and applies DataTables filters to the model's query builder based on POST input and the given product type.
   * @example
   * $this->_get_datatables_query('software');
   * $rows = $this->db->get()->result();
   * print_r($rows); // sample output: Array ( [0] => stdClass Object ( [id] => 1 [name] => "Example" [product_type] => "software" ... ) )
   * @param string $product_type - Product type to filter results (e.g. 'software').
   * @returns void Sets up the query on $this->db (applies date range, account/invoice filters, search and order); does not return a value.
   */
  private function _get_datatables_query($product_type)
  {
    
      $this->db->from($this->table);     
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
		$search_todate = $this->input->post('searchToDate');
        
		$this->db->where('created_date >=',$search_date);
		$this->db->where('created_date <=',$search_todate);
      } 
	  if($this->input->post('account_type'))
      { 
			$cust_date = $this->input->post('account_type');
			$this->db->where('account_type',$cust_date);
      }
	  if($this->input->post('invoice_type'))
      { 
			$cust_date = $this->input->post('invoice_type');
			$this->db->where('invoice_account_type',$cust_date);
      }
	  if($this->input->post('invoice_license_type'))
      { 
			$cust_date = $this->input->post('invoice_license_type');
			$this->db->where('invoice_license_type',$cust_date);
      }
	  
      $this->db->where('type','admin');
	  $this->db->where('product_type',$product_type);
	 
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
  public function get_datatables($product_type)
  {
    $this->_get_datatables_query($product_type);
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
  }
  public function count_filtered($product_type)
  {
    $this->_get_datatables_query($product_type);
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all()
  {
    $this->db->from($this->table);
   // $session_comp_email = $this->session->userdata('supercompany_email');
   // $session_company = $this->session->userdata('supercompany_name');
	//$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('type','admin');
    return $this->db->count_all_results();
  }
  
 
 
  public function get_allOrganization($company_email, $company_name)
  {
      $this->db->select('*');
      $this->db->where('session_comp_email',$company_email);
	  $this->db->where('session_company',$company_name);
      $query = $this->db->get('organization');
      return $query;
  }
  
   public function get_all_loginadmin()
  {
      $this->db->select('*');
      $this->db->from('admin_users');
      $this->db->where('type','admin');
	  //$this->db->where('active',1);
      $query = $this->db->get();
      return $query->result_array();
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
  
   public function get_all_standarduser($company_email, $company_name)
  {
      $this->db->select('*');
      $this->db->from('standard_users');
      $this->db->where('company_email',$company_email);
	  $this->db->where('company_name',$company_name);
      $query = $this->db->get();
      return $query->result_array();
  }
    public function get_all_Trialloginadmin()
  {
      $this->db->select('*');
      $this->db->where('account_type','trial');
	  $this->db->where('type','admin');
      $query = $this->db->get('admin_users');
      return $query->result_array();
  }
  //////////////////////////////////////////////////////////////// Dashboard Queries Starts  //////////////////////////////////////////////////////
  
  //////////////////////////////////////////////////////////////// To get count of ragisteradmin starts /////////////////////////////////////////////
  /**
  * Get the total number of registered admin users when the current session user is a superadmin.
  * @example
  * $this->load->model('superadmin/Home_model_bkp');
  * $result = $this->Home_model_bkp->get_all_ragisterAdmin();
  * print_r($result); // e.g. array('total_admin' => '5')
  * @param void $none - No parameters.
  * @returns array|null Return associative array with key 'total_admin' containing the count of admin users when the current session user type is 'superadmin'; returns null otherwise.
  */
  public function get_all_ragisterAdmin()
  {
    
    $type = $this->session->userdata('types');//die;
	
    if($type == "superadmin")
    {  
       
       $this->db->select('count("admin_name") as total_admin');
       $this->db->from('admin_users');
       $this->db->where('type','admin'); 
       	   
       
       $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      return $query->row_array();
    }
    }
   
  }
  //////////////////////////////////////////////////////////////// To get count of ragisteradmin starts /////////////////////////////////////////////
  /**
  * Get the total count of active admin users when the current session user is a superadmin.
  * @example
  * $result = $this->Home_model_bkp->get_all_activeAdmin();
  * echo $result['total_admin']; // e.g. 5
  * @param void $none - No parameters are required.
  * @returns array|null Associative array with key 'total_admin' containing the count of active admins, or null if the session type is not 'superadmin' or no rows found.
  */
  public function get_all_activeAdmin()
  {
    
    $type = $this->session->userdata('types');
	
    if($type == "superadmin")
    {
	  $this->db->select('count("admin_name") as total_admin');
      $this->db->from('admin_users');
      $this->db->where('type','admin');
      $this->db->where('active',1);
	  
      $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      return $query->row_array();
    }      
    
    }
   
    
  }
   //////////////////////////////////////////////////////////////// To get count of ragisteradmin starts /////////////////////////////////////////////
  /**
  * Get the number of inactive admin users when the current session is a superadmin.
  * @example
  * $result = $this->Home_model_bkp->get_all_inactiveAdmin();
  * echo $result['total_admin']; // 5
  * @param void None - This method accepts no parameters.
  * @returns array|null Associative array with key 'total_admin' containing the count of inactive admin users, or NULL if the current session is not a superadmin or there are no results.
  */
  public function get_all_inactiveAdmin()
  {
    
    $type = $this->session->userdata('types');
	
    
    if($type == "superadmin")
    { 
      $this->db->select('count("admin_name") as total_admin');
      $this->db->from('admin_users');
      $this->db->where('type','admin'); 
      $this->db->where('active',0); 	  
      $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      return $query->row_array();
    }
    }
   
    
  }
   //////////////////////////////////////////////////////////////// To get count of ragisteradmin starts /////////////////////////////////////////////
  /**
   * Get the count of admin users registered in the current month for a superadmin.
   * @example
   * $result = $this->Home_model_bkp->get_all_currmonReg();
   * echo $result['total_admin']; // e.g. 5
   * @returns array|null Associative array with key 'total_admin' containing the count of admin users for the current month, or null if the current session user is not a superadmin or no records are found.
   */
  public function get_all_currmonReg()
  {
    
    $type = $this->session->userdata('types');
	
    if($type == "superadmin")
    {
		
		$this->db->select('count("admin_name") as total_admin');
		$this->db->from('admin_users');
        $this->db->where('type','admin'); 
		//$this->db->where('active',1);
        $this->db->where('Month(created_date)',date('m'));
        $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      return $query->row_array();
    }	  
    
    }
   
   
  }
  /********start meta tag********/
  var $search_meta_by = array('page_title','meta_title','meta_keyword','meta_description');
  private function _getAllMetaTag()
  {
      $this->db->select('*');     
      $this->db->where('status',1);	
	  $i=0;
    foreach ($this->search_meta_by as $item) // loop column
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
        if(count($this->search_meta_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
     
  }
  
  public function get_all_meta_tag()
  {
      //$this->_getAllMetaTag();
	  $this->db->select('*'); 
      $this->db->where('status',1);	
      $query = $this->db->get('meta_tag');
      return $query->result_array();
  }
  
   public function get_metatag_by_id($id)
  {
      $this->db->select('*'); 
      $this->db->where('id',$id);   	  
      $this->db->where('status',1);	 
      $query = $this->db->get('meta_tag');
      return $query->row_array();
  }
   public function meta_count_filtered()
  {
      $this->_getAllMetaTag(); 
      $query = $this->db->get('meta_tag');
      return $query->num_rows();
  }
  public function meta_count_all()
  {    
      $this->db->where('status',1);	 
      return $this->db->count_all_results('meta_tag');
      //return $this->db->count_all_results();
  }
  public function add_metaTag($data)
  {    
      return $this->db->insert('meta_tag', $data);
      
  }
  public function update_metaTag($id, $data)
  {
       $this->db->where('id',$id);
      return $this->db->update('meta_tag', $data);
      
  }
  public function delete_metaTag($id)
  {
       $this->db->where('id',$id);
      return $this->db->delete('meta_tag');
      
  }
  /*********end meta tag section ******/
  
  
  /* partner section */
  public function get_partner(){
      $this->db->select('*'); 
       $this->db->order_by('id','DESC'); 
      $query = $this->db->get('become_partner');
      return $query->result_array();
      
  }
  
  public function get_partner_detail($uid,$org){
       $this->db->select('*'); 
       $this->db->where('id',$uid);
       $this->db->where('Company_name',$org);
       $query = $this->db->get('become_partner');
      return $query->result_array();
  }
  
  public function get_data($cid,$tbl){
       $this->db->select('name'); 
       $this->db->where('id',$cid);
       $query = $this->db->get($tbl);
       return $query->row_array();
  }
  public function checkExistAdmin($email){
       $this->db->select('id'); 
       $this->db->where('admin_email',$email);
       $query = $this->db->get('admin_users');
       return $query->row_array();
  }
  
  public function checkExistStr($email){
       $this->db->select('id'); 
       $this->db->where('standard_email',$email);
       $query = $this->db->get('standard_users');
       return $query->row_array();
  }
  
  
  public function create_admin($data){
      return $this->db->insert('admin_users', $data);
  }
  
  
  public function update_partner($statusArr,$id){
      $this->db->where('id',$id);
      $this->db->update('become_partner', $statusArr);
  }
  
    /**********Extend trial date*****/
    public function extends_update($ex_id,$trd)
    {
		$this->db->where('id',$ex_id);
		return $this->db->update('admin_users',$trd);
	}
    public function get_by_id($id)
    {
		$this->db->where('id',$id);
		$query = $this->db->get('admin_users');
		return $query->row_array();
    }
	
	////CRM ORDER LIST DETAILS
	var $tables = 'payment_details';
    var $sort_bys = array(null,'order_id','payment_id','trans_id','user_name','company_name','company_email','user_mobile','product_name','licence_type','final_price','payment_method','payment_status');
    var $search_bys = array('order_id','payment_id','trans_id','user_name','company_name','company_email','user_mobile','product_name','licence_type','final_price','payment_method','payment_status');
  var $orders = array('id' => 'desc');
  /**
  * Prepare the active query builder with search and ordering clauses for DataTables filtered by product type.
  * @example
  * // Called inside the model to build the query used by DataTables
  * $this->_get_datatables_order_query('electronics');
  * $rows = $this->db->get()->result();
  * echo json_encode($rows); // [{"id":1,"product_name":"electronics","name":"Smartphone",...}]
  * @param {string} $product_type - Product type to filter the datatables query (e.g. 'electronics').
  * @returns {void} No direct return; the method modifies the CI query builder ($this->db) to apply WHERE, LIKE (search) and ORDER BY clauses.
  */
  private function _get_datatables_order_query($product_type)
  {
    
      $this->db->from($this->tables);
    
	  $this->db->where('product_name',$product_type);
	 
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
	public function get_datatables_order_list($product_type)
    {
    $this->_get_datatables_order_query($product_type);
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result();
   }
   public function count_filtered_order_list($product_type)
   {
    $this->_get_datatables_order_query($product_type);
    $query = $this->db->get();
    return $query->num_rows();
   }
   public function count_all_order_list()
   {
    $this->db->from($this->table);
    return $this->db->count_all_results();
   }
   public function get_all_order_list()
   {
      $this->db->select('*');
      $query = $this->db->get('payment_details');
      return $query->result_array();
  }
  
//Please write code above this  
}
?>
