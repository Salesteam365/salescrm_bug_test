<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Organization_model extends CI_Model
{
  var $table = 'organization';
  var $sort_by = array(null,'org_name','customer_type','email','website','mobile','billing_city',null);
  var $search_by = array('org_name','email','website','mobile','customer_type');
  var $order = array('id' => 'desc');
  
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
