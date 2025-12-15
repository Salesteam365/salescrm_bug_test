<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact_model extends CI_Model
{
  var $table = 'contact';
  var $sort_by = array(null,'name','org_name','email','mobile','assigned_to','datetime');
  var $search_by = array('name','org_name','email','mobile','datetime');
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
