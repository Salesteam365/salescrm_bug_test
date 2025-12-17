<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model
{

     public function __construct(){
         parent::__construct();
         $this->db->query('SET SESSION sql_mode =  REPLACE(REPLACE(REPLACE(
                  @@sql_mode,
                  "ONLY_FULL_GROUP_BY,", ""),
                  ",ONLY_FULL_GROUP_BY", ""),
                  "ONLY_FULL_GROUP_BY", "")');
     }
	
 /**
 * Retrieve up to 5 products whose names contain the given search term for the current session company.
 * @example
 * // Assume session values: company_name = 'Acme Inc', company_email = 'contact@acme.com'
 * $result = $this->Product_model->get_pro_name('Widget');
 * print_r($result);
 * // e.g. Array
 * // (
 * //   [0] => stdClass Object
 * //     (
 * //       [product_id] => 12
 * //       [product_name] => Widget A
 * //       [session_company] => Acme Inc
 * //       [session_comp_email] => contact@acme.com
 * //       ...
 * //     )
 * // )
 * @param {string} $product_name - Partial product name to search for (matches anywhere in product_name).
 * @returns {array} Array of stdClass result objects of matching products (max 5), ordered by product_name ASC.
 */
	public function get_pro_name($product_name)
	{
		$sess_eml 			= $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company 	= $this->session->userdata('company_name');
		
		//$this->db->from('product');
		$this->db->like('product_name', $product_name , 'both');
		//$this->db->where('sess_eml',$sess_eml);
		$this->db->where('session_company',$session_company);
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->order_by('product_name', 'ASC');
		$this->db->limit(5);
		return $this->db->get($this->table)->result();
    }
  /**
  * Retrieve product records for the current session's company filtered by product name.
  * @example
  * $result = $this->Product_model->getProValue(['product_name' => 'Widget A']);
  * echo print_r($result, true); // render sample output: Array ( [0] => Array ( [id] => 12 [product_name] => Widget A [price] => 19.99 [session_company] => Acme Inc. [session_comp_email] => billing@acme.com ) )
  * @param {array} $product_name - Associative array containing key 'product_name' to filter products.
  * @returns {array} Returns an array of matching product rows (empty array if none found).
  */
  public function getProValue($product_name)
  {
    $response = array();
    if($product_name['product_name'])
    {
      $sess_eml 			= $this->session->userdata('email');
	  $session_comp_email = $this->session->userdata('company_email');
	  $session_company 	= $this->session->userdata('company_name');  
        
      $this->db->select('*');
      $this->db->where('session_company',$session_company);
	  $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('product_name',$product_name['product_name']);
      $o = $this->db->get('product');
      $response = $o->result_array();
    }
    return $response;
  } 
  

	 
  var $table = 'product';
  var $sort_by = array(null,'product_name','sku','hsn_code','product_category',null,'product_unit_price','product_quantity','stock_alert',null);
  
  var $search_by = array('product_name','sku','hsn_code','product_category','product_unit_price','product_quantity','stock_alert');
  var $order = array('id' => 'desc');
  
  /**
  * Build and apply the CodeIgniter query used for server-side DataTables (applies session scoping, optional date filters including "This Week", searchable columns, ordering and soft-delete condition).
  * @example
  * // Example: standard user, searching for "widget" and ordering by column 1 ascending
  * $this->session->set_userdata([
  *   'email' => 'user@example.com',
  *   'company_email' => 'comp@example.com',
  *   'company_name' => 'ACME Corp',
  *   'type' => 'standard'
  * ]);
  * $_POST['search']['value'] = 'widget';
  * $_POST['order'][0]['column'] = 1;
  * $_POST['order'][0]['dir'] = 'asc';
  * // call within the model (private): $this->_get_datatables_query();
  * $this->_get_datatables_query();
  * $query = $this->db->get();
  * echo $query->num_rows(); // e.g. 12
  * @param void $none - This function accepts no parameters.
  * @returns void Applies filtering, searching and ordering to $this->db; does not return a value.
  */
  private function _get_datatables_query()
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
    if($this->session->userdata('type')==='admin')
    {
      $this->db->select('*');
      $this->db->from('product');
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
  public function count_all()
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
    $this->db->from('product');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    return $this->db->count_all_results();
  }
  
  

 /**
 * Insert a product record into the database and return the insert ID or a failure code.
 * @example
 * $result = $this->Product_model->insertData(['name' => 'Sample Product', 'price' => 9.99, 'sku' => 'SKU123']);
 * echo $result; // e.g. 15 (insert ID) or 202 (failure)
 * @param {array} $dataArr - Associative array of product fields to insert (e.g. ['name'=>'Sample','price'=>9.99]).
 * @returns {int} Inserted record ID on success, or 202 if the insert failed.
 */
	public function insertData($dataArr)
	{
		
        if($this->db->insert('product', $dataArr))
        {
          return $this->db->insert_id();
        }
        else
        {
          return 202;
        }

    }
	
 /**
 * Update the product table's product_id column for a specific product record.
 * @example
 * $result = $this->Product_model->product_id(123, 5);
 * echo $result; // true (if update succeeded) or false (if update failed)
 * @param int $pro_id - New product_id value to set.
 * @param int $id - ID of the product row to update.
 * @returns bool Return true on successful update, false on failure.
 */
	public function product_id($pro_id,$id)
    {
		$data = array('product_id' => $pro_id);
		$this->db->where('id',$id);
		if($this->db->update('product',$data))
		{
		  return true;
		}
		else
		{ 
		  return false;
		}
    }
	public function updateData($data,$id){
		$this->db->where('id',$id);
		if($this->db->update('product',$data))
		{
		  return $id;
		}
		else
		{ 
		  return 0;
		}
	}

 /**
 * Retrieve product records by ID constrained to the current session's company and company email.
 * If the logged-in user's type is 'standard', results are further restricted to that user's email.
 * @example
 * $result = $this->Product_model->getById(123);
 * print_r($result); // Example output: Array ( [0] => stdClass Object ( [id] => 123 [name] => "Sample Product" [session_company] => "Acme Inc" [session_comp_email] => "info@acme.com" ) )
 * @param {int} $id - The ID of the product to fetch (e.g., 123).
 * @returns {array} Array of stdClass result objects matching the provided ID and current session constraints.
 */
	public function getById($id){
		
		$sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
  
		$this->db->from('product');
		$this->db->select('*');
		$this->db->where('id',$id);
		$this->db->where('session_company',$session_company);
		$this->db->where('session_comp_email',$session_comp_email);
		if($this->session->userdata('type') == 'standard')
		{
		$this->db->where('sess_eml',$sess_eml);
		}
		
		$query = $this->db->get();
		return $query->result();
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
  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }
  
  
  /**
  * Check for an existing product with the same name, price and SKU for the current session/company.
  * @example
  * $result = $this->Product_model->check_duplicate_product('Sample Product', 9.99, 'SKU123');
  * print_r($result); // Array ( [product_name] => "Sample Product" [sku] => "SKU123" [product_unit_price] => "9.99" )
  * @param {string} $proName - Product name to check for duplicates.
  * @param {float|string} $price - Product unit price to check (float or numeric string).
  * @param {string} $sku - Product SKU to check for duplicates.
  * @returns {array|false} Return product row as associative array if duplicate exists, otherwise false.
  */
  public function check_duplicate_product($proName,$price,$sku)
  {
    $this->db->select('product_name,sku,product_unit_price');
    $this->db->from($this->table);
    $this->db->where('product_name',$proName);
    $this->db->where('product_unit_price',$price);
	$this->db->where('sku',$sku);
	$this->db->where('delete_status',1);
	$sess_eml 			= $this->session->userdata('email');
	$session_comp_email = $this->session->userdata('company_email');
	$session_company 	= $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
	$this->db->where('session_company',$session_company);
	
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
   * Update a product record identified by ID with the provided data array.
   * @example
   * $result = $this->Product_model->mass_save(123, ['name' => 'New Product', 'price' => 9.99]);
   * echo $result ? 'success' : 'failure'; // outputs 'success' on update, 'failure' otherwise
   * @param int|string $mass_id - The product ID to update.
   * @param array $dataArry - Associative array of column => value pairs to update.
   * @returns bool True if the database update succeeded, false otherwise.
   */
  public function mass_save($mass_id, $dataArry)
  {
  //  print_r($mass_id);die;
    $this->db->where('id', $mass_id);
    if($this->db->update('product', $dataArry)){
		  return true;
		}else{
      return false;
    }
   


  }
  


}