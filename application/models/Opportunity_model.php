<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Opportunity_model extends CI_Model
{
  var $table = 'opportunity';
  var $sort_by = array(null,'name','org_name','email','mobile','opportunity_id','datetime');
  var $search_by = array('name','org_name','email','mobile','opportunity_id','datetime');
  
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
        if($this->input->post('fromDate') && $this->input->post('toDate')){
          $this->db->where('currentdate >=',$this->input->post('fromDate'));
          $this->db->where('currentdate <=',$this->input->post('toDate'));
        }else if($search_date == "This Week")
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
	  
	  if($this->input->post('searchStage'))
      { 
        $searchStage = $this->input->post('searchStage');
        $this->db->where('stage',$searchStage);
        
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
	  if($this->input->post('searchStage'))
      { 
        $searchStage = $this->input->post('searchStage');
        $this->db->where('stage',$searchStage);
        
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
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from($this->table);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    return $this->db->count_all_results();
  } 
  
  
  public function check_opp_exist($leadId)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company    = $this->session->userdata('company_name');
    $this->db->from($this->table);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('lead_id',$leadId);
    $this->db->where('delete_status',1);
    return $this->db->count_all_results();
  }
  
   public function get_all_opp($search_date,$search,$per_page, $start)
  {
	  
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
    $this->db->from($this->table);
	if($this->session->userdata('type')==='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('delete_status',1);
	if($this->input->post('selectUser')){ 
        $search_user = $this->input->post('selectUser');
        $this->db->where('sess_eml',$search_user);
    }
	 if($this->input->post('endDate')){ 
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $this->db->where('expclose_date>=',$startDate);
        $this->db->where('expclose_date<=',$endDate);
     }else{
	    if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else if($search_date!="")
        {
          $this->db->where('currentdate >=',$search_date);
        }else{
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
		}
	 }
		
	 $i = 0;
    foreach ($this->search_by as $item) // loop column
    {
      if($search) 
      {
        if($i===0) {
          $this->db->group_start(); 
          $this->db->like($item, $search);
        }else{
          $this->db->or_like($item, $search);
        }
        if(count($this->search_by) - 1 == $i) 
          
        $this->db->group_end(); 
      }
      $i++;
    }
	
    //$this->db->order_by('lead_status','desc');
    $this->db->order_by('id','DESC');
	$this->db->limit($per_page, $start);
	$query = $this->db->get();
    return $query->result_array();
  }
  
  public function get_all_count($search_date,$search,$selectUser,$endDate,$startDate){
	$sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
    $this->db->from($this->table);
	
	
	if($this->session->userdata('type')==='standard')
    {
		$this->db->where('sess_eml',$sess_eml);
	}
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
	
	if($selectUser!=""){ 
        $this->db->where('sess_eml',$selectUser);
    }
	 if($endDate!=""){ 
        $this->db->where('expclose_date>=',$startDate);
        $this->db->where('expclose_date<=',$endDate);
     }else{
	    if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        { 	if($search_date!=""){
				$this->db->where('currentdate >=',$search_date);
			}else{
				$this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
			}
        }
	 }
	 $i = 0;
	  foreach ($this->search_by as $item) // loop column
    {
      if($search) 
      {
        if($i===0) 
        {
          $this->db->group_start(); 
          $this->db->like($item, $search);
        }
        else
        {
          $this->db->or_like($item, $search);
        }
        if(count($this->search_by) - 1 == $i) 
        $this->db->group_end(); 
      }
      $i++;
    }
	$query = $this->db->get();
    return $query->num_rows();
  }
  
    public function getTotalPrice($stage){
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->select('stage');
    $this->db->select_sum('initial_total');
    $this->db->from($this->table);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    if($this->session->userdata('type')==='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
    $this->db->where('delete_status',1);
    $this->db->where('stage',$stage);
    $query = $this->db->get();
    return $query->row_array();
  }
 
  
  public function update_status($leadArr,$id)
  { 
    $this->db->where('id',$id);
    if($this->db->update($this->table,$leadArr))
    {
      return true;
    }
    else
    {
      return false;
    }
  } 
  
  
  public function create($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  
  
  public function addTask($data)
  {
    $this->db->insert('opp_task', $data);
    return $this->db->insert_id();
  }
  
  public function addMeeting($data)
  {
    $this->db->insert('meeting', $data);
    return $this->db->insert_id();
  }
  
  public function addCall($data)
  {
    $this->db->insert('create_call', $data);
    return $this->db->insert_id();
  }
  
  
  
  
  public function opportunity_id($opportunity_id,$id)
  {
    $data = array(
      'opportunity_id' => $opportunity_id,
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
  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }
  
  public function get_data_for_update($id)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from($this->table);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row_array();
  }
  
   public function get_sub_opp_for_create($sub_opp_id)
      {
        $this->db->from('sub_opportunity');
        $this->db->where('delete_status',1);
        $this->db->where('id',$sub_opp_id);
        $query = $this->db->get();
        return $query->row_array();
      }
      
    public function sub_opp_update_track_status($sub_opp_id)
      {
        $this->db->set('track_status','opportunity');
        $this->db->where('id', $sub_opp_id);
		$this->db->update('sub_opportunity');
		
      }
      
      
    public function delete_sub_opp($id)
      {
        $this->db->set('delete_status',2);
        $this->db->where('id', $id);
    	$this->db->update('sub_opportunity');
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
  
  
  public function delete_bulk($id)
  {
    $this->db->set('delete_status',2);
    $this->db->where('id', $id);
    $this->db->update($this->table);
  }
  
  public function getContactValsDeatil($postData)
  {
    $response = array();
    if($postData['name'])
    {
      $this->db->select('*');
      $this->db->where('org_name',$postData['name']);
      $o = $this->db->get('contact');
      $response = $o->result_array();
    }
    return $response;
  }
  
  
  public function getContactVals($postData)
  {
    $response = array();
    if($postData['name'])
    {
      $this->db->select('*');
      $this->db->where('name',$postData['name']);
      $o = $this->db->get('contact');
      $response = $o->result_array();
    }
    return $response;
  }
  public function update_opp_track_status($where,$data)
  {
    $this->db->update($this->table, $data, $where);
  }
  public function get_pending_opportunity($filter_date)
  {
    if($this->session->userdata('type') == 'admin')
    {
      if($filter_date != "null")
      {
        $date = date('Y-m-d');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->select('*');
        $this->db->from('opportunity');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('delete_status',1);
        if($filter_date=="15 days")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime("-15 Day")));
        }
        else if($filter_date != "null")
        {
          $this->db->where('currentdate >=',$filter_date);
        }
      }
      
    }
    else if($this->session->userdata('type')=='standard')
    {
      if($filter_date != "null")
      {
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->select('*');
        $this->db->from('opportunity');
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('sess_eml',$sess_eml);
        $this->db->where('delete_status',1);
        if($filter_date == '15 days')
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime("-15 Day")));
        }
        else if($filter_date != "null")
        {
          $this->db->where('currentdate >=',$filter_date);
        }
      }
    }
    $this->db->where('stage!=','Closed Lost');
    $this->db->where('track_status!=','salesorder');
    $this->db->where('track_status!=','purchaseorder');
    $this->db->order_by('id', 'Desc');
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    if($query->num_rows() > 0)
    {
      return $query->result_array();
    }
    else
    {
      return false;
    }
  }
  
  
   //<-----------   sub opp Data fetch -------------->
   public function get_pending_sub_opportunity()
    {
        $this->db->select('*');
        $this->db->from('sub_opportunity');
    
        // Apply filters
        $this->db->where('track_status', 'sub_opportunity');
        $this->db->where('delete_status', 1);
        $this->db->order_by('id', 'DESC');
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result_array(); 
        } else {
            return false; 
        }
    }
  
  
  public function view($id,$download)
  {
    $this->db->where('id', $id);
    $data = $this->db->get($this->table);
	//$bank_details_terms = $this->Performainvoice->get_bank_details();
    foreach($data->result() as $row)
    {
       $admin_details = $this->Login_model->get_company_details($row->session_company,$row->session_comp_email);
       $output = '<!DOCTYPE html>
              <html>
              <head>
                <title>Team365 | Opportunity</title>
                <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
                
                <style>
                 @page{
                      margin-top: 20px;
                    }
                    footer .pagenum:before {
                        content: counter(page, decimal);
                    }
                </style>
              </head>
        
              <body style="font-family: Quicksand, sans-serif;">
              
                <footer style="position: fixed;bottom: 40;border-top:1px dashed #333; " >
                  <div class="pagenum-container"style="text-align:right;font-size:12px;">Page <span class="pagenum"> </span>of TPAGE</div>
                  <center>
        		  <span style="font-size:12px"><b>"This is System Generated Quotation, Sign and Stamp not Required"</b></span><br>
                  <b><span style="font-size: 10px;">E-mail - '.$admin_details['company_email'].'</br>
                        | Ph. - +91-'.$admin_details['company_mobile'].'</br>
                        | GSTIN: '.$admin_details['company_gstin'].'</br>
                        | CIN: '.$admin_details['cin'].'</span></b> <br>
                        <b><span style="font-size:12px;">Powered By <a href="https://team365.io/" >Team365 CRM</a></span></b>
                  </center>
                
                </footer>
              
              <main style="margin-bottom:30px;">
              
              <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                       <td>
                         <h3 style="color: #6539c0; margin-top:0px;margin-bottom: -5px;">Opportunity</h3>
                         <p style="margin-bottom: 0;font-size: 12px;">
                         <text style="color: #9c9999; display:inline-block; width:25%;">Opportunity No#</text> <text style="display:inline-block;">'.$row->opportunity_id.'</text><br>
                        <text style="color: #9c9999; display:inline-block; width:25%;">Opportunity Date: </text><text style="display:inline-block;">'. date("d F Y", strtotime($row->currentdate)).'</text></p>
                       </td>
                       <td colspan="2" style="text-align:right">';
        					$image = $admin_details["company_logo"];
        					if(!empty($image))
        					{
        					$output .=  '<img style="width: 70px;" src="./uploads/company_logo/'.$image.'">';
        					}
        					else
        					{
        					$output .=  '<span class="h5 text-primary">'.$admin_details["company_name"].'</span>';
        					}
        					$output .= '
        				</td>
                    </tr>
                 </tbody>
                </table>
                 <table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
                
                    <tr>
                       <td style="width: 49.5%; padding: 10px; vertical-align: top;">
                         
                            <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Opportunity From</h4>
                            <p style="margin: 0;font-size: 14px;">'.$admin_details["company_name"].'</p>';
                            
                          if($admin_details["company_address"]!=""){
                          
                          $output .=  ' <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">'.$admin_details["company_address"];
                          }
                          if($admin_details["city"]!=""){
                          $output .=  ', '.$admin_details["city"];
                          }
                          if($admin_details["zipcode"]!=""){
                          $output .=  ' - '.$admin_details["zipcode"];
                          }
                          if($admin_details["state"]!=""){
                          $output .=  ', '.$admin_details["state"];
                          }
                          
                          if($admin_details["country"]!=""){
                          $output .=  ', '.$admin_details["country"];
                          }
                          $output .=  '</p>
                          <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;"><b>Email:</b> '.$admin_details["company_email"].' <br>
                          <b>Phone:</b> +91-'.$admin_details["company_mobile"].'</p>
                        
                       </td>
                       <td style="width: 1%; background:#fff;"></td>
                       <td style="width: 49.5%; padding: 10px; vertical-align: top;">
                       
                          <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Opportunity For</h4>
                          <p style="margin: 0;font-size: 12px; ">'.
        				  $row->org_name;
                           $output .= '</p>
                            
                          <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">';
                          
                          if(!empty($row->billing_address)){
                           $output .= $row->billing_address;
                          }
                          if(!empty($row->billing_city)){
                           $output .= ', '.$row->billing_city;
                          }
                          if(!empty($row->billing_zipcode)){
                           $output .= ' - '.$row->billing_zipcode;
                          }
                          if(!empty($row->billing_state)){
                           $output .= ', '.$row->billing_state;
                          }
                          if(!empty($row->billing_country)){
                           $output .= ', '.$row->billing_country;
                          }
                           $output .= '</p>';
                           if(!empty($row->contact_name)){
                          $output .= '<p style="margin-bottom: 0;font-size: 12px;margin-top: 0px;"><b>Contact Name:</b> '.$row->contact_name.'</p>';
                           }
                            if(isset($row->email)){
                          $output .= '<p style="margin-bottom: 0;font-size: 12px;margin-top:0px;"><b>Email:</b> '.$row->email;
                            }
                            if(isset($row->mobile)){
                          $output .= '<p style="margin-bottom: 0;font-size: 12px;margin-top:0px;"><b>Contact No.:</b> '.$row->mobile;
                            }
                       $output .= '  
                       </td>
                    </tr>
                </table>
				<table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse; margin-top:15px; margin-bottom:15px;">
                    <tr>
                       <td style="width: 49.5%; padding: 10px; vertical-align: top;">
                            <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Other Details</h4>
                            ';
                          if($row->name){
                          $output .=  '<p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">Opportuntiy Name : '.$row->name.'</p>';
                          }
						  if($row->expclose_date){
                          $output .=  '<p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">Expected Closing Date : '.$row->expclose_date.'</p>';
                          }
						  if($row->stage){
                          $output .=  '<p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">Opportunity Stage : '.$row->stage.'</p>';
                          }
                          $output .=  '
                       </td>
                    </tr>
                </table>';
                $output .='<table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; border-radius: 7px; background: #efebf9;">
                   <thead style="color: #fff;" align="left">
                    <tr>
                       <th width="30%" style="font-size: 12px;">
                        <div style="background: #6539c0;border-top-left-radius: 7px; padding: 11px;">Product/Services</div></th>
                       <th style="font-size: 12px; background: #6539c0;">Qty</th>
                       <th style="font-size: 12px; background: #6539c0;">Rate</th>';
                       $output .='
                       <th style="font-size: 12px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 11px;">Amount</div></th>
                     </tr>
                   </thead>
                   <tbody>';
                        $product_name = explode("<br>",$row->product_name);
        				$quantity 	  = explode("<br>",$row->quantity);
        				$unit_price   = explode("<br>",$row->unit_price);
        				$total = explode("<br>",$row->total);
        			    $proDesc = explode("<br>",$row->pro_description);
        				$arrlength = count($product_name);
        				$newLenth=($arrlength);
        				$rw=0;
        				for($x = 0; $x < $newLenth; $x++){
        					$num = $x + 1;
        					$output .='<tr>
        						<td style="font-size: 12px; padding:10px; border-top: 1px solid #dee2e6;">'.$product_name[$x].'</td>
        						<td style="font-size: 12px; border-top: 1px solid #dee2e6;">'.$quantity[$x].'</td>
        						<td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($unit_price[$x]).'</td>';
        					$output .='<td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($total[$x]).'</td>
        					</tr>';
						if(isset($proDesc[$x]) && $proDesc[$x]!=""){	
						$output.='<tr >
        					<td colspan="7" style="font-size: 12px; padding:10px;">'.$proDesc[$x].'</td></tr>';
						}								
        			    }
        			  
                        $output .='
                  </tbody>
                </table>
                <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
                  <tbody>
                    <tr>
                    <td align="left" width="60%" style="position: relative;">
                      <p style="font-size:12px;"><b>Total in words:</b> <text> '.AmountInWords($row->sub_total).' only</text></p>';
                     $output .='</td>
                    <td align="" width="40%" style="text-align:right;">
                      <table align="" width="100%" style="text-align:right; position: absolute;top: 0px;">
                        <tbody>
                          <tr>
                            <th style="font-size: 12px;" align="left">Initial Amount</th>
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->initial_total).'</td>
                          </tr>';
						  if($row->discount>0){
                          $output .='<tr>
                            <th style="font-size: 12px;" align="left">Discount</th>
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$row->discount.'</td>
                          </tr>
                          <tr>
                            <th style="font-size: 12px;" align="left">After Discount</th>
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->after_discount).'</td>
                          </tr>';
                          }
                          $output .='
                          <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
                          <tr>
                            <th style="font-size: 12px;" align="left">TOTAL</th>
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->sub_total).'</td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                  </tbody>
                </table>';
        
                $output .='<!--<table width="60%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-top:-20px;">';
                    
                $output .='<tbody>
                    <tr>
                  <td align="left">
                    <h5 style="color: #6539c0;margin-bottom: 10px;">Terms and Conditions</h5>
                    <ol style="padding: 0 15px; font-size:12px;">';
                     /*$custTerm=explode("<br>",$row->terms_condition); $no=1;
					 for($i=0; $i<count($custTerm); $i++){ 
					   $output .='<li>'.$custTerm[$i].'</li>'; 
					 }*/
                      //'.nl2br($row->terms_condition).'
                    $output .='</ol>
                    
                  </td>
                </tr>
                  </tbody>
                </table>-->
        
              </main>
        
              </body>
              </html>';
      //return $output;
      
      }
    return $output;
  }


  
public function mass_save($mass_id, $dataArry)
  {
    // print_r($mass_id);die;
    $this->db->where('id', $mass_id);
    if($this->db->update('opportunity', $dataArry)){
		  return true;
		}else{
      return false;
    }
  }
  
  
  
  

//Please write code above this
}
?>
