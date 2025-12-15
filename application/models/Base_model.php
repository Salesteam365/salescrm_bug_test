<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Base_model extends CI_Model
{

  var $table 		= 'creditnote';
  var $sort_by 		= array('creditnote_no','org_name','owner','sub_total','pi_status','creditnote_date',null);
  var $search_by 	= array('creditnote_no','org_name','owner', 'sub_total','pi_status','creditnote_date');
  var $order 		= array('id' => 'desc');


    public function getlast_id($sel, $tbl, $where = NULL) {
        $this->db->select($sel);
        $this->db->from($tbl);
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query= $this->db->get();
        if($query->num_rows() >0 ){
            return $query;
        }
        else{
            return 0;
        }
    }

    public function insertdata($tbl,$data){

        if (!isset($data['invoice_id'])) {
            return 0;
        }

        $existingData = $this->db->get_where($tbl, array('invoice_id' => $data['invoice_id'],'delete_status'=>1));
            if ($existingData->num_rows() > 0) {
                // Data already exists, return 0 indicating failure
                return 0;
            }
            
        $query=$this->db->insert($tbl,$data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }
        
    }

    private function _get_datatables_query()
    {
        
          $sess_eml           = $this->session->userdata('email');
          $session_comp_email = $this->session->userdata('company_email');
          $session_company    = $this->session->userdata('company_name');
      
          $this->db->from($this->table);
          $this->db->where('session_comp_email',$session_comp_email);
          $this->db->where('session_company',$session_company);

        if($this->input->post('firstDate') < $this->input->post('secondDate')){
           
            $this->db->where('creditnote_date >=',$this->input->post('firstDate'));
            $this->db->where('creditnote_date <=',$this->input->post('secondDate'));
            
        }else if($this->input->post('searchDate')){ 
          $search_date = $this->input->post('searchDate');
        //   print_r($search_date);die;
          if($search_date == "This Week"){
            $this->db->where('creditnote_date >=',date('Y-m-d',strtotime('last monday')));
          }else{
           $this->db->where('creditnote_date >=',$search_date);
          }
        }

        if($this->input->post('searchUser')){ 
                $searchUser = $this->input->post('searchUser');
                $this->db->where('sess_eml',$searchUser);  
            }
 

        $this->db->where('delete_status',1);
      
        if($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po')!='1' ){
            $this->db->where('sess_eml',$sess_eml);
          }

      $i = 0;
      foreach ($this->search_by as $item) // loop column
      {  
       
            $searchVl=$this->input->post('search');
           if(isset($_POST['search']['value'])) 
            {
              $dataSearch=$_POST['search']['value'];  
            }else{
                $dataSearch=$searchVl;
            }
           
        if(isset($dataSearch)) 
        {
          if($i===0) 
          {
            $this->db->group_start(); 
            $this->db->like($item, $dataSearch);
          }else{
            $this->db->or_like($item, $dataSearch);
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


    public function getdata_credit(){
      
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // fetch invoices by id
    public function get_data_invoices($ino_id) {
        $this->db->select('*');
        $this->db->from('invoices');
        $this->db->where('id', $ino_id);
        $query = $this->db->get()->row_array();
       
        return $query;
    } 

    // fetch creditnote by id
    public function get_creditnote_by_id($id,$decoded_cnp = '',$decoded_ceml = '')
    {	
        if ($decoded_cnp == '') {
            $session_company = $this->session->userdata('company_name');
        } else {
            $session_company = $decoded_cnp;
        }
        
        if ($decoded_ceml == '') {
            $session_comp_email = $this->session->userdata('company_email');
        } else {
            $session_comp_email = $decoded_ceml;
        }
    
        $this->db->select('*');
        $this->db->from('creditnote');
        $this->db->where('invoice_id', $id);
        $this->db->where('delete_status', 1);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
    
        return $this->db->get()->row_array();

    }

     // fetch invoices no. by id
     public function get_ino_no($id){
        $this->db->select('invoice_no ,buyer_date ,cust_order_no');
        $this->db->from('invoices');
        $this->db->where('id', $id);
        $this->db->where('delete_status', 1);
        return $this->db->get()->row_array();
        

    }


    // fetch branch user data
    public function get_Branch_Data($branchId)
    {
    
      $this->db->from('user_branch');
      $this->db->where('id',$branchId);
      $query = $this->db->get();
      return $query->row_array();
    }

    // fetch organization data
    public function get_org_by_id($id) 
    {
        $this->db->from('organization');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }


    // fetch bank details
    public function get_bank_detailss()
    {
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
        $this->db->where('delete_status' ,1);
        $this->db->where('session_company',$session_company);
        $this->db->where('session_comp_email',$session_comp_email);
        $query = $this->db->get('account_details');
        return $query->row();
    }

  
    public function delete_creditnote_id($id)
    {
        $this->db->set('delete_status', 2);
        $this->db->where('invoice_id', $id);
        $this->db->update('creditnote');
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }


    public function creditnote_exists($invoice_update_id)
    {

        $this->db->select('COUNT(*) as count, MAX(id) as max_id');
        $this->db->select('(SELECT `delete_status` FROM creditnote WHERE id = (SELECT MAX(id) FROM creditnote WHERE invoice_id = ' . $invoice_update_id . ')) as delstatus');
        $this->db->from('creditnote');
        $this->db->where('invoice_id', $invoice_update_id);
    
        if ($cond != null) {
            // Apply additional condition if provided
            // Here assuming $cond is a field to be checked
            $this->db->where($cond);
        }
    
      
        $query = $this->db->get();
    
        $row = $query->row();
        $count = $row->count;
        $delete_status = $row->delstatus;
    
        if ($count > 0) {
            return array(
                'count' => $count,
                'delete_status' => $delete_status
            );
        } else {
            return array(
                'count' => 0,
                'delete_status' => null
            );
        }


    }

    public function creditnote_no($id)
    {
            $this->db->select('*');
            $this->db->from('creditnote');
            $this->db->where('invoice_id', $id);
            $this->db->where('delete_status', 1);
            return $this->db->get()->row();
    }

    public function update_credit_note($invoice_id ,$data){
        $this->db->where('invoice_id', $invoice_id);
        $this->db->where('delete_status', 1);
        $query = $this->db->update('creditnote', $data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }  
    }

    public function count_all()
    {
      $session_comp_email = $this->session->userdata('company_email');
      $session_company = $this->session->userdata('company_name');
      $this->db->from('creditnote');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
    }

    public function count_Total()
    {
        $this->db->select_sum('sub_total', 'total_amount');
        $this->db->where('delete_status', 1);
        $query = $this->db->get('creditnote');
        return $query->row()->total_amount;
    }

    public function count_filtered_c()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all_c()
  {
    $this->db->from('creditnote');
    $this->db->where('delete_status', 1);
    return $this->db->count_all_results();
    // print_r($data);die;
  }


    // <---------------------------------- Credit note end ----------------------------------------------------------->

    

    // <-------------------------------------- Start Debit Note ----------------------------------------------------->

    public function count_all_debit()
    {
      $session_comp_email = $this->session->userdata('company_email');
      $session_company = $this->session->userdata('company_name');
      $this->db->from('debitnote');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
    }

    public function count_Total_debit()
    {
        $this->db->select_sum('sub_total', 'total_amount');
        $this->db->where('delete_status', 1);
        $query = $this->db->get('debitnote');
        return $query->row()->total_amount;
    }


    public function Record_deb_total()
    {
      $this->_get_datatables_query_debit();
      $query = $this->db->get();
      return $query->num_rows();
    }
    public function amount_deb_total()
    {
      $this->db->from('debitnote');
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
      // print_r($data);die;
    }

    public function getlast_id_debit($sel, $tbl, $where = NULL) {
        $this->db->select($sel);
        $this->db->from($tbl);
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query= $this->db->get();
        if($query->num_rows() >0 ){
            return $query;
        }
        else{
            return 0;
        }
    }


    public function debitnote_exists($invoice_update_id) {

        $this->db->select('COUNT(*) as count, MAX(id) as max_id');
        $this->db->select('(SELECT `delete_status` FROM debitnote WHERE id = (SELECT MAX(id) FROM debitnote WHERE invoice_id = ' . $invoice_update_id . ')) as delstatus');
        $this->db->from('debitnote');
        $this->db->where('invoice_id', $invoice_update_id);
    
        if ($cond != null) {
            // Apply additional condition if provided
            // Here assuming $cond is a field to be checked
            $this->db->where($cond);
        }
    
      
        $query = $this->db->get();
    
        $row = $query->row();
        $count = $row->count;
        $delete_status = $row->delstatus;
    
        if ($count > 0) {
            return array(
                'count' => $count,
                'delete_status' => $delete_status
            );
        } else {
            return array(
                'count' => 0,
                'delete_status' => null
            );
        }
    }

    public function debitnote_no($id) {
        $this->db->select('*');
        $this->db->from('debitnote');
        $this->db->where('invoice_id', $id);
        $this->db->where('delete_status', 1);
        return $this->db->get()->row();
    }


    public function insert_debit_data($tbl,$data){
        if (!isset($data['invoice_id'])) {
            return 0;
        }

        $existingData = $this->db->get_where($tbl, array('invoice_id' => $data['invoice_id'],'delete_status'=>1));
            if ($existingData->num_rows() > 0) {
                // Data already exists, return 0 indicating failure
                return 0;
            }
            
        $query=$this->db->insert($tbl,$data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }
        
    }

    public function update_debit_note($invoice_id ,$data){
        $this->db->where('invoice_id', $invoice_id);
        $query = $this->db->update('debitnote', $data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }  
    }

    
     public function get_ino_debit_no($ino_id){
        $this->db->select('*');
        $this->db->from('invoices');
        $this->db->where('id', $ino_id);
        return $this->db->get()->row_array();
        

    }

    private function _get_datatables_query_debit()
    {
     $table 		= 'debitnote';
     $sort_by 		= array('debitnote_no','org_name','owner','sub_total','pi_status','debitnote_date',null);
     $search_by 	= array('debitnote_no','org_name','owner', 'sub_total','pi_status','debitnote_date');
     $order 		= array('id' => 'desc');
        
          $sess_eml           = $this->session->userdata('email');
          $session_comp_email = $this->session->userdata('company_email');
          $session_company    = $this->session->userdata('company_name');
      
          $this->db->from($table);
          $this->db->where('session_comp_email',$session_comp_email);
          $this->db->where('session_company',$session_company);

        if($this->input->post('firstDate') < $this->input->post('secondDate')){
           
            $this->db->where('debitnote_date >=',$this->input->post('firstDate'));
            $this->db->where('debitnote_date <=',$this->input->post('secondDate'));
            
        }else if($this->input->post('searchDate')){ 
          $search_date = $this->input->post('searchDate');
        //   print_r($search_date);die;
          if($search_date == "This Week"){
            $this->db->where('debitnote_date >=',date('Y-m-d',strtotime('last monday')));
          }else{
           $this->db->where('debitnote_date >=',$search_date);
          }
        }

        if($this->input->post('searchUser')){ 
                $searchUser = $this->input->post('searchUser');
                $this->db->where('sess_eml',$searchUser);  
            }
 

        $this->db->where('delete_status',1);
      
        if($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po')!='1' ){
            $this->db->where('sess_eml',$sess_eml);
          }

      $i = 0;
      foreach ($search_by as $item) // loop column
      {  
       
            $searchVl=$this->input->post('search');
           if(isset($_POST['search']['value'])) 
            {
              $dataSearch=$_POST['search']['value'];  
            }else{
                $dataSearch=$searchVl;
            }
           
        if(isset($dataSearch)) 
        {
          if($i===0) 
          {
            $this->db->group_start(); 
            $this->db->like($item, $dataSearch);
          }else{
            $this->db->or_like($item, $dataSearch);
          }
          if(count($search_by) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
        }
        $i++;
      }


      if(isset($_POST['order'])) // here order processing
      {
        $this->db->order_by($sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      }
      else if(isset($order))
      {
        $order = $order;
        $this->db->order_by(key($order), $order[key($order)]);
      }
    }

    public function getdata_debit() {

        $this->_get_datatables_query_debit();
     
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_debitnote_by_id($id, $decoded_cnp = '', $decoded_ceml = '')
    {
        if ($decoded_cnp == '') {
            $session_company = $this->session->userdata('company_name');
        } else {
            $session_company = $decoded_cnp;
        }
        
        if ($decoded_ceml == '') {
            $session_comp_email = $this->session->userdata('company_email');
        } else {
            $session_comp_email = $decoded_ceml;
        }
    
        $this->db->select('*');
        $this->db->from('debitnote');
        $this->db->where('invoice_id', $id);
        $this->db->where('delete_status', 1);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
    
        return $this->db->get()->row_array();
    }

      public function debit_get_org_by_id($id) 
      {
          $this->db->from('organization');
          $this->db->where('id',$id);
          $query = $this->db->get();
          return $query->row();
      }

    public function debit_get_Branch_Data($branchId)
    {
      $this->db->from('user_branch');
      $this->db->where('id',$branchId);
      $query = $this->db->get();
      return $query->row_array();
    }

    public function delete_debitnote_id($id){
        $this->db->set('delete_status', 2);
        $this->db->where('invoice_id', $id);
        $this->db->update('debitnote');
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function get_Owner_debit($get_Owner)
    {
        $this->db->select('*');
        $this->db->from('standard_users');
        $this->db->where('standard_email', $get_Owner);
        $query = $this->db->get();
        
        return $query->row_array();
    }

    public function get_Admin_debit($get_Owner)
  {
		$this->db->select('admin_name as standard_name, admin_mobile as standard_mobile');
		$this->db->from('admin_users');
		$this->db->where('admin_email',$get_Owner);
		$query = $this->db->get();
		return $query->row_array();
  }

  public function get_Comp_debit($branchId)
  {
		$session_company    = $this->session->userdata('company_name');
        $this->db->from('admin_users');
        $this->db->where('company_email',$branchId);
        $this->db->where('company_name',$session_company);
        $this->db->where('type','admin');
        $query = $this->db->get();
        return $query->row_array();
  }

  public function getBranchData_debit($branchId)
  {
  
    $this->db->from('user_branch');
    $this->db->where('id',$branchId);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function getorg_by_id_debit($id)
  {
    $this->db->from('organization');
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }
    
    // <-------------------------------------------------------debit note end ------------------------------------------------->


    // <-----------------------------------------------------------delivery challan start----------------------------------------------->
    public function count_all_delivery(){
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from('deliverychallan');
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('delete_status', 1);
    return $this->db->count_all_results();
    }

    public function count_Total_delivery()
    {
        $this->db->select_sum('sub_total', 'total_amount');
        $this->db->where('delete_status', 1);
        $query = $this->db->get('deliverychallan');
        return $query->row()->total_amount;
    }

    public function count_all_del()
    {
      $this->_get_datatables_query_deliverychallan();
      $query = $this->db->get();
      return $query->num_rows();
    }
    public function count_filtered_del()
    {
      $this->db->from('deliverychallan');
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
      // print_r($data);die;
    }


    public function deliverychallan_exists($invoice_update_id, $cond =null)
    {
        $this->db->select('COUNT(*) as count, MAX(id) as max_id');
        $this->db->select('(SELECT `delete_status` FROM deliverychallan WHERE id = (SELECT MAX(id) FROM deliverychallan WHERE invoice_id = ' . $invoice_update_id . ')) as delstatus');
        $this->db->from('deliverychallan');
        $this->db->where('invoice_id', $invoice_update_id);
    
        if ($cond != null) {
            // Apply additional condition if provided
            // Here assuming $cond is a field to be checked
            $this->db->where($cond);
        }
    
      
        $query = $this->db->get();
    
        $row = $query->row();
        $count = $row->count;
        $delete_status = $row->delstatus;
    
        if ($count > 0) {
            return array(
                'count' => $count,
                'delete_status' => $delete_status
            );
        } else {
            return array(
                'count' => 0,
                'delete_status' => null
            );
        }

    }

    public function get_deliverychallan_by_id($id,$decoded_cnp = '',$decoded_ceml = '')
    {	
        if ($decoded_cnp == '') {
            $session_company = $this->session->userdata('company_name');
        } else {
            $session_company = $decoded_cnp;
        }
        
        if ($decoded_ceml == '') {
            $session_comp_email = $this->session->userdata('company_email');
        } else {
            $session_comp_email = $decoded_ceml;
        }
    
        $this->db->select('*');
        $this->db->from('deliverychallan');
        $this->db->where('invoice_id', $id);
        $this->db->where('delete_status', 1);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
    
        return $this->db->get()->row_array();

    }

    public function delivery_no($id)
    {
            $this->db->select('*');
            $this->db->from('deliverychallan');
            $this->db->where('invoice_id', $id);
            $this->db->where('delete_status', 1);
            return $this->db->get()->row();
    }

    public function getlast_delivery_id($sel, $tbl, $where = NULL) {
        $this->db->select($sel);
        $this->db->from($tbl);
        if ($where !== NULL) {
            $this->db->where($where);
        }
        $query= $this->db->get();
        if($query->num_rows() >0 ){
            return $query;
        }
        else{
            return 0;
        }
    }


    public function insert_delivery_data($tbl,$data){
        if (!isset($data['invoice_id'])) {
            return 0;
        }

        $existingData = $this->db->get_where($tbl, array('invoice_id' => $data['invoice_id'],'delete_status'=>1));
            if ($existingData->num_rows() > 0) {
                return 0;
            }
        
        $query=$this->db->insert($tbl,$data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }
    
    }


    public function update_delivery($invoice_id ,$data){
        $this->db->where('invoice_id', $invoice_id);
        $this->db->where('delete_status', 1);
        $query = $this->db->update('deliverychallan', $data);
        if($query){
            return 1;
        }else{
            return 2;
        }  
    }

    public function delete_deliverychallan_id($id)
    {
        $this->db->set('delete_status', 2);
        $this->db->where('invoice_id', $id);
        $this->db->update('deliverychallan');
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function getdata_delivery_challan() {

        $this->_get_datatables_query_deliverychallan();
    
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    private function _get_datatables_query_deliverychallan()
    {
     $table 		= 'deliverychallan';
     $sort_by 		= array('deliverychallan_no','org_name','owner','sub_total','pi_status','deliverychallan_date',null);
     $search_by 	= array('deliverychallan_no','org_name','owner', 'sub_total','pi_status','deliverychallan_date');
     $order 		= array('id' => 'desc');
        
          $sess_eml           = $this->session->userdata('email');
          $session_comp_email = $this->session->userdata('company_email');
          $session_company    = $this->session->userdata('company_name');
      
          $this->db->from($table);
          $this->db->where('session_comp_email',$session_comp_email);
          $this->db->where('session_company',$session_company);

        if($this->input->post('firstDate') < $this->input->post('secondDate')){
           
            $this->db->where('deliverychallan_date >=',$this->input->post('firstDate'));
            $this->db->where('deliverychallan_date <=',$this->input->post('secondDate'));
            
        }else if($this->input->post('searchDate')){ 
          $search_date = $this->input->post('searchDate');
        //   print_r($search_date);die;
          if($search_date == "This Week"){
            $this->db->where('deliverychallan_date >=',date('Y-m-d',strtotime('last monday')));
          }else{
           $this->db->where('deliverychallan_date >=',$search_date);
          }
        }

        if($this->input->post('searchUser')){ 
                $searchUser = $this->input->post('searchUser');
                $this->db->where('sess_eml',$searchUser);  
            }
 

        $this->db->where('delete_status',1);
      
        if($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po')!='1' ){
            $this->db->where('sess_eml',$sess_eml);
          }

      $i = 0;
      foreach ($search_by as $item) // loop column
      {  
       
            $searchVl=$this->input->post('search');
           if(isset($_POST['search']['value'])) 
            {
              $dataSearch=$_POST['search']['value'];  
            }else{
                $dataSearch=$searchVl;
            }
           
        if(isset($dataSearch)) 
        {
          if($i===0) 
          {
            $this->db->group_start(); 
            $this->db->like($item, $dataSearch);
          }else{
            $this->db->or_like($item, $dataSearch);
          }
          if(count($search_by) - 1 == $i) 
          $this->db->group_end(); 
        }
        $i++;
      }


      if(isset($_POST['order'])) 
      {
        $this->db->order_by($sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      }
      else if(isset($order))
      {
        $order = $order;
        $this->db->order_by(key($order), $order[key($order)]);
      }
    }
    // <-------------------------------------------------------Delivery Challan end ------------------------------------------------->


    //  <------------------------------------------- Expenditure management Start ------------------------------------------------------------>
        public function getpodata($where){
            $this->db->select('id');
            $this->db->where($where);
            return $this->db->get('purchaseorder');
        }

        public function expanse_exists($po_update_id, $cond = null)
        {
            $this->db->select('COUNT(*) as count, MAX(id) as max_id');
            $this->db->select('(SELECT `delete_status` FROM expenditure WHERE id = (SELECT MAX(id) FROM expenditure WHERE po_id = ' . $po_update_id . ')) as delstatus');
            $this->db->from('expenditure');
            $this->db->where('po_id', $po_update_id);

            if ($cond != null) {
                // Apply additional condition if provided
                // Here assuming $cond is a field to be checked
                $this->db->where($cond);
            }

            $query = $this->db->get();

            $row = $query->row();
            $count = $row->count;
            $delete_status = $row->delstatus;

            if ($count > 0) {
                return array(
                    'count' => $count,
                    'delete_status' => $delete_status
                );
            } else {
                return array(
                    'count' => 0,
                    'delete_status' => null
                );
            }
        }

        public function expanse_data_by_po_no($id)
        {
                $this->db->select('*');
                $this->db->from('expenditure');
                $this->db->where('po_id', $id);
                $this->db->where('delete_status', 1);
                return $this->db->get()->row();
        }

        public function getlast_expanse_id($sel, $tbl, $where = NULL) {
            $this->db->select($sel);
            $this->db->from($tbl);
            if ($where !== NULL) {
                $this->db->where($where);
            }
            $query= $this->db->get();
            if($query->num_rows() >0 ){
                return $query;
            }
            else{
                return 0;
            }
        }

        public function insert_expenditure_data($tbl,$data)
        {
            if (!isset($data['po_id'])) {
                return 0;
            }
            $existingData = $this->db->get_where($tbl, array('po_id' => $data['po_id'],'delete_status'=>1));
                if ($existingData->num_rows() > 0) {
                    return 0;
                }
            //   print_r($data);die;  
            $query=$this->db->insert($tbl,$data);
            if($query){
                return 1;
            }
            else{
                return 2;
            }
            
        }

        public function update_expanse($po_id ,$data){
            $this->db->where('po_id', $po_id);
            $query = $this->db->update('expenditure', $data);
            if($query){
                return 1;
            }else{
                return 2;
            }  
        }


        public function getdata_expanse() {

                $this->_get_datatables_query_expanse();
            
                if($_POST['length'] != -1)
                $this->db->limit($_POST['length'], $_POST['start']);
                $query = $this->db->get();
                return $query->result_array();
        }


        private function _get_datatables_query_expanse()
        {
         $table 		= 'expenditure';
         $sort_by 		= array('expenditure_no','org_name','owner','sub_total','pi_status','expenditure_date',null);
         $search_by 	= array('expenditure_no','org_name','owner', 'sub_total','pi_status','expenditure_date');
         $order 		= array('id' => 'desc');
            
              $sess_eml           = $this->session->userdata('email');
              $session_comp_email = $this->session->userdata('company_email');
              $session_company    = $this->session->userdata('company_name');
          
              $this->db->from($table);
              $this->db->where('session_comp_email',$session_comp_email);
              $this->db->where('session_company',$session_company);
    
            if($this->input->post('firstDate') < $this->input->post('secondDate')){
               
                $this->db->where('expenditure_date >=',$this->input->post('firstDate'));
                $this->db->where('expenditure_date <=',$this->input->post('secondDate'));
                
            }else if($this->input->post('searchDate')){ 
              $search_date = $this->input->post('searchDate');
            //   print_r($search_date);die;
              if($search_date == "This Week"){
                $this->db->where('expenditure_date >=',date('Y-m-d',strtotime('last monday')));
              }else{
               $this->db->where('expenditure_date >=',$search_date);
              }
            }
    
            if($this->input->post('searchUser')){ 
                    $searchUser = $this->input->post('searchUser');
                    $this->db->where('sess_eml',$searchUser);  
                }
     
    
            $this->db->where('delete_status',1);
          
            if($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po')!='1' ){
                $this->db->where('sess_eml',$sess_eml);
              }
    
          $i = 0;
          foreach ($search_by as $item) // loop column
          {  
           
                $searchVl=$this->input->post('search');
               if(isset($_POST['search']['value'])) 
                {
                  $dataSearch=$_POST['search']['value'];  
                }else{
                    $dataSearch=$searchVl;
                }
               
            if(isset($dataSearch)) 
            {
              if($i===0) 
              {
                $this->db->group_start(); 
                $this->db->like($item, $dataSearch);
              }else{
                $this->db->or_like($item, $dataSearch);
              }
              if(count($search_by) - 1 == $i) 
              $this->db->group_end(); 
            }
            $i++;
          }
    
    
          if(isset($_POST['order'])) 
          {
            $this->db->order_by($sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
          }
          else if(isset($order))
          {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
          }
        }

        public function get_expanse_no($po_id){
            $this->db->select('*');
            $this->db->from('purchaseorder');
            $this->db->where('id', $po_id);
            $this->db->where('delete_status', 1);
            return $this->db->get()->row_array();
        }

        public function count_all_expanse(){
            $session_comp_email = $this->session->userdata('company_email');
            $session_company = $this->session->userdata('company_name');
            $this->db->from('expenditure');
            $this->db->where('session_company',$session_company);
            $this->db->where('session_comp_email',$session_comp_email);
            $this->db->where('delete_status', 1);
            return $this->db->count_all_results();
        }


        public function count_Total_expanse()
        {
            $this->db->select_sum('sub_total', 'total_amount');
            $this->db->select_sum('pending_payment', 'pending_payment');
            $this->db->where('delete_status', 1);
            $query = $this->db->get('expenditure');

            return array(
                'total_amount' =>$query->row()->total_amount,
                'pending_payment' => $query->row()->pending_payment
              
            );
           
        }


        public function count_all_exp()
        {
          $this->_get_datatables_query_expanse();
          $query = $this->db->get();
          return $query->num_rows();
        }
        public function count_filtered_exp()
        {
          $this->db->from('expenditure');
          $this->db->where('delete_status', 1);
          return $this->db->count_all_results();
          // print_r($data);die;
        }

        public function get_expenditure_by_id($id,$decoded_cnp = '',$decoded_ceml = '')
        {	
            if ($decoded_cnp == '') {
                $session_company = $this->session->userdata('company_name');
            } else {
                $session_company = $decoded_cnp;
            }
            
            if ($decoded_ceml == '') {
                $session_comp_email = $this->session->userdata('company_email');
            } else {
                $session_comp_email = $decoded_ceml;
            }
        
            $this->db->select('*');
            $this->db->from('expenditure');
            $this->db->where('po_id', $id);
            $this->db->where('delete_status', 1);
            $this->db->where('session_comp_email', $session_comp_email);
            $this->db->where('session_company', $session_company);
        
            return $this->db->get()->row_array();
        }

        public function delete_expanse_id($id)
        {
            $this->db->set('delete_status', 2);
            $this->db->where('po_id', $id);
            $this->db->update('expenditure');
            if($this->db->affected_rows() > 0){
                return true;
            } else {
                return false;
            }
        }

        // fetch total expenditure data for acounting report page
        

            

            public function fetchData_expenditure_by($startDate = null, $endDate = null) {
                $session_comp_email = $this->session->userdata('company_email');
                $sess_eml = $this->session->userdata('email');
                $session_company = $this->session->userdata('company_name');
                $type = $this->session->userdata("type");
            
                $this->db->select('*');
                $this->db->from('expenditure'); 
            
                if (!empty($startDate) && !empty($endDate)) {
                    $this->db->where('expenditure_date >=', $startDate);
                    $this->db->where('expenditure_date <=', $endDate);
                }
            
                if ($type == "admin" || $type == "standard") {
                    $this->db->where('session_comp_email', $session_comp_email);
                    $this->db->where('session_company', $session_company);
                }
            
                if ($type == "standard") {
                    $this->db->where('sess_eml', $sess_eml);
                }
            
                $this->db->where('pi_status', 1);
                $this->db->where('delete_status', 1);
                $query = $this->db->get();
            
                if ($query === false) {
                    return []; 
                }
            
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return []; 
                }
            }
            
            
            
            


            public function fetchData_Purchaseorders_by($startDate = null, $endDate = null) {
               
                $session_comp_email = $this->session->userdata('company_email');
                $sess_eml = $this->session->userdata('email');
                $session_company = $this->session->userdata('company_name');
                $type = $this->session->userdata("type");

                $this->db->select('*');
                $this->db->from('purchaseorder');
                
                if (!empty($startDate) && !empty($endDate)) {
                    $this->db->where('currentdate >=', $startDate);
                    $this->db->where('currentdate <=', $endDate);
                }

                if ($type == "admin" || $type == "standard") {
                    $this->db->where('session_comp_email', $session_comp_email);
                    $this->db->where('session_company', $session_company);
                }
            
                if ($type == "standard") {
                    $this->db->where('sess_eml', $sess_eml);
                }

                $this->db->where('pi_status',1);
                $this->db->where('delete_status', 1);


                $query = $this->db->get();
                if ($query === false) {
                    return []; 
                }
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return [];
                }

              

            }

            public function fetchData_invoices_by($startDate = null, $endDate = null) {
                $session_comp_email = $this->session->userdata('company_email');
                $sess_eml = $this->session->userdata('email');
                $session_company = $this->session->userdata('company_name');
                $type = $this->session->userdata("type");
            
                $this->db->select('*');
                $this->db->from('invoices'); 
               
            
                if (!empty($startDate) && !empty($endDate)) {
                    $this->db->where('invoice_date >=', $startDate);
                    $this->db->where('invoice_date <=', $endDate);
                }
            
                if ($type == "admin" || $type == "standard") {
                    $this->db->where('session_comp_email', $session_comp_email);
                    $this->db->where('session_company', $session_company);
                }
            
                if ($type == "standard") {
                    $this->db->where('sess_eml', $sess_eml);
                }
                $this->db->where('pi_status',1);
                $this->db->where('delete_status', 1);

                $query = $this->db->get();

                if ($query === false) {
                  
                    return []; 
                }

                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return [];
                }

            
               
            }
            
    

        //<-------------------------------- Expenditure management End --------------------------------------------->

    
      public function getInvoicesByClientId($clientId) {
            // print_r($clientId);die;
            $session_comp_email = $this->session->userdata('company_email');
            $sess_eml = $this->session->userdata('email');
            $session_company = $this->session->userdata('company_name');
            $type = $this->session->userdata("type");

            $this->db->select('*');
            $this->db->from('invoices');

            if($type == "admin")
            {
            
              $this->db->where('session_comp_email',$session_comp_email);
              $this->db->where('session_company',$session_company);
            }
            else if ($type == "standard") 
            {
            
              $this->db->where('session_comp_email',$session_comp_email);
              $this->db->where('session_company',$session_company);
              $this->db->where('sess_eml',$sess_eml);
            }

            $this->db->where('cust_id', $clientId);
            $this->db->where('delete_status', 1);
            $this->db->where('pending_payment >', 0);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return array();
            }
        }


        public function get_piInvoicesByClientId($clientId) {
       
            $session_comp_email = $this->session->userdata('company_email');
            $sess_eml = $this->session->userdata('email');
            $session_company = $this->session->userdata('company_name');
            $type = $this->session->userdata("type");

            $this->db->select('*');
            $this->db->from('performa_invoice');

            if($type == "admin")
            {
            
              $this->db->where('session_comp_email',$session_comp_email);
              $this->db->where('session_company',$session_company);
            }
            else if ($type == "standard") 
            {
            
              $this->db->where('session_comp_email',$session_comp_email);
              $this->db->where('session_company',$session_company);
              $this->db->where('sess_eml',$sess_eml);
            }

            $this->db->where('cust_id', $clientId);
            $this->db->where('delete_status', 1);
            $query = $this->db->get();
            // print_r($query);die;
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return array();
            }
        }



        public function getpo_InvoicesByClientId($invoicesId) {
            // print_r($clientId);die;
            $this->db->select('*');
            $this->db->from('invoices');
            $this->db->where('id', $invoicesId);
            $this->db->where('delete_status', 1);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return array();
            }
        }


      public function insertpayment_rec($tbl,$data){
    
            // print_r($data);die;    
        $query=$this->db->insert($tbl,$data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }
        
    }
   
    public function get_payments() {
        $this->db->where('delete_status', 1);
        $query = $this->db->get('payment_receipt');
       
        if ($query->num_rows() > 0) {
         
            return $query->result();
        } else {
           
            return 0;
        }
        
    }

    public function update_payment_rec($paymentId ,$update_data){
        $this->db->where('id', $paymentId);
        $this->db->where('delete_status', 1);
        $query = $this->db->update('payment_receipt', $update_data);
        if($query){
            return 1;
        }
        else{
            return 2;
        }  
    }


    public function get_payment_receipt_details($paymentId) {
        $query = $this->db->get_where('payment_receipt', array('id' => $paymentId));
        $this->db->where('delete_status', 1);
        
        if ($query->num_rows() > 0) {
         
            return $query->row_array();
        } else {
           
            return null;
        }
    }


    public function delete_payment_receipt($payment_id) {
        $this->db->set('delete_status', 2);
        $this->db->where('id',$payment_id);
        $this->db->update('payment_receipt');
        if ($this->db->affected_rows() > 0) {
            return true; 
        } else {
            return false; 
        }
    
    
}

    //-<------------------------------------------------------- New Payment receipt ------------------------------------------------------>
public function paymentreceipt_exists($invoice_update_id)
{

    $this->db->select('COUNT(*) as count, MAX(id) as max_id');
    $this->db->select('(SELECT `delete_status` FROM paymentreceipt WHERE id = (SELECT MAX(id) FROM paymentreceipt WHERE invoice_id = ' . $invoice_update_id . ')) as delstatus');
    $this->db->from('paymentreceipt');
    $this->db->where('invoice_id', $invoice_update_id);

    if ($cond != null) {
        // Apply additional condition if provided
        // Here assuming $cond is a field to be checked
        $this->db->where($cond);
    }

  
    $query = $this->db->get();

    $row = $query->row();
    $count = $row->count;
    $delete_status = $row->delstatus;

    if ($count > 0) {
        return array(
            'count' => $count,
            'delete_status' => $delete_status
        );
    } else {
        return array(
            'count' => 0,
            'delete_status' => null
        );
    }


}


public function paymentreceipt_no($id)
{
        $this->db->select('*');
        $this->db->from('paymentreceipt');
        $this->db->where('invoice_id', $id);
        $this->db->where('delete_status', 1);
        return $this->db->get()->row();
}


        public function get_last_paymentreceipt_no() {
            // $this->db->select_max('paymentreceipt_no');
            $this->db->select_max('CAST(SUBSTRING_INDEX(paymentreceipt_no, "/", -1) AS UNSIGNED)', 'max_no');
            $query = $this->db->get('paymentreceipt');
            $last_paymentreceipt_no = $query->row()->max_no;
            
            // print_r($last_paymentreceipt_no);die;
            if ($last_paymentreceipt_no !== null) {
            
                return $last_paymentreceipt_no;
            } else {
                
                return 0;
            }
        }




        private function _get_datatables_query_payment()
        {
            $table = 'paymentreceipt';  // Define the table name
            $sort_by = ['paymentreceipt_no', 'org_name', 'owner', 'sub_total', 'pi_status', 'paymentreceipt_date', null];
            $search_by = ['paymentreceipt_no', 'org_name', 'owner', 'sub_total', 'pi_status', 'paymentreceipt_date'];
            $default_order = ['id' => 'desc']; 
            
            // Session data
            $session_comp_email = $this->session->userdata('company_email');
            $session_company = $this->session->userdata('company_name');
            $sess_eml = $this->session->userdata('email');
            
            
            $this->db->from($table);
            $this->db->where('session_comp_email', $session_comp_email);
            $this->db->where('session_company', $session_company);
            $this->db->where('delete_status', 1);

            // Filter by date range
            // Ensure the date handling logic here is properly commenting out/in as per your requirements
            
            // if (!empty($this->input->post('firstDate')) && !empty($this->input->post('secondDate'))) {
            //     $this->db->where('paymentreceipt_date >=', $this->input->post('firstDate'));
            //     $this->db->where('paymentreceipt_date <=', $this->input->post('secondDate'));
            // }


            if($this->input->post('firstDate') < $this->input->post('secondDate')){
           
                $this->db->where('paymentreceipt_date >=',$this->input->post('firstDate'));
                $this->db->where('paymentreceipt_date <=',$this->input->post('secondDate'));
                
            }else if($this->input->post('searchDate')){ 
              $search_date = $this->input->post('searchDate');
            //   print_r($search_date);die;
              if($search_date == "This Week"){
                $this->db->where('paymentreceipt_date >=',date('Y-m-d',strtotime('last monday')));
              }else{
               $this->db->where('paymentreceipt_date >=',$search_date);
              }
            }


            
            

        
            if ($this->input->post('searchUser')) {
                $this->db->where('sess_eml', $this->input->post('searchUser'));
            }


            if ($this->session->userdata('type') == 'standard' && $this->session->userdata('create_po') != '1') {
                $this->db->where('sess_eml', $sess_eml);
            }

        
            if (!empty($this->input->post('search')['value'])) {
                $searchValue = $this->input->post('search')['value'];
                $this->db->group_start();
                foreach ($search_by as $index => $item) {
                    if ($index == 0) {
                        $this->db->like($item, $searchValue);
                    } else {
                        $this->db->or_like($item, $searchValue);
                    }
                }
                $this->db->group_end();

              
            }
            $this->db->group_by('paymentreceipt_no');

            // Order by logic
            if (isset($_POST['order'])) {
                $order_col_index = $_POST['order'][0]['column'];
                $order_dir = $_POST['order'][0]['dir'];
                if (isset($sort_by[$order_col_index])) {
                    $this->db->order_by($sort_by[$order_col_index], $order_dir);
                }
            } else {
                foreach ($default_order as $key => $dir) {
                    $this->db->order_by($key, $dir);
                }
            }
        }


        public function getdata_payment()
        {
            $this->_get_datatables_query_payment();
            if ($_POST['length'] != -1) {
                $this->db->limit($_POST['length'], $_POST['start']);
            }

            $query = $this->db->get();
            $data = $query->result_array();
        // print_r($data);die;
            return $data;
        }



    
    public function save_payment($payment_data) 
    {
        $this->db->insert('payment_receipt', $payment_data);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id(); 
            // return true; 
        } else {
            return false; 
        }
    }


    public function save_bank_data($data) {
         $this->db->insert('payment_receipt_details', $data);
         if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id(); 
            // return true; 
        } else {
            return false; 
        }
    }

    public function save_employee_data($data) {
         $this->db->insert('payment_receipt_details', $data);
         if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id(); 
            return true; 
        } else {
            return false; 
        }
    }

    public function save_other_data($data) {
         $this->db->insert('payment_receipt_details', $data);
         if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id(); 
           
            // return true; 
        } else {
            return false; 
        }
    }

    public function get_Bank_data(){
        $this->db->select('*'); 
        $this->db->from('payment_receipt_details');
        
        return $this->db->get()->result_array(); 
    }
    


    public function add_payment_all($tbl,$data){
    //  print_r($data);die;
        $query=$this->db->insert($tbl,$data);
       
        if($query){
            return 1;
        }
        else{
            return 2;
        }
    }


    public function get_paymentreceipt_by_id($id,$decoded_cnp = '',$decoded_ceml = '')
    {	
        if ($decoded_cnp == '') {
            $session_company = $this->session->userdata('company_name');
        } else {
            $session_company = $decoded_cnp;
        }
        
        if ($decoded_ceml == '') {
            $session_comp_email = $this->session->userdata('company_email');
        } else {
            $session_comp_email = $decoded_ceml;
        }
    
        $this->db->select('*');
        $this->db->from('paymentreceipt');
        $this->db->where('auto_id', $id);
        $this->db->where('delete_status', 1);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
    
        return $this->db->get()->row_array();

    }


    public function delete_paymentreciept_id($id)
    {
        $this->db->set('delete_status', 2);
        $this->db->where('id', $id);
        $this->db->update('paymentreceipt');
        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function count_all_payment()
    {
      $session_comp_email = $this->session->userdata('company_email');
      $session_company = $this->session->userdata('company_name');
      $this->db->group_by('paymentreceipt_no');
      $this->db->from('paymentreceipt');
      $this->db->where('session_company',$session_company);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
    }

    public function count_Total_payment()  
    {
        
        $this->db->select_sum('sub_total', 'total_amount');
        $this->db->where('delete_status', 1);
        $this->db->group_by('paymentreceipt_no');
        $query = $this->db->get('paymentreceipt');
        return $query->row()->total_amount;
    }


    public function count_all_pay()
    {
      $this->_get_datatables_query_payment();
      $query = $this->db->get();
      return $query->num_rows();
    }
    public function count_filtered_pay()
    {
      $this->db->from('paymentreceipt');
      $this->db->group_by('paymentreceipt_no');
      $this->db->where('delete_status', 1);
      return $this->db->count_all_results();
      // print_r($data);die;
    }


    public function get_invoice_data($invoice_id)  
    {
        $this->db->select('*');
        $this->db->from('invoices');
        $this->db->where('delete_status', 1);
        $this->db->where('id', $invoice_id); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row(); 
        } else {
            return null; 
        }
    }


    public function paymentmethod_Data($paymentreceipt_no)
    {
      $this->db->from('paymentreceipt');
      $this->db->where('paymentreceipt_no',$paymentreceipt_no);
      $this->db->where('delete_status', 1);
      $query = $this->db->get();
      return $query->result_array();
    }

    public function paymentmethod_all($paymentreceipt_no)
    {
      $this->db->from('paymentreceipt');
      $this->db->where('paymentreceipt_no',$paymentreceipt_no);
      $this->db->where('delete_status', 1);
      $query = $this->db->get();
      return $query->result_array();
    }

    

   //////////////////////////////////////////////////// monthwise chart for payment receipt graph starts/////////////////////////////////////////////////////////////////////
    
 public function getpaymentgraph() { 
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('delete_status', 1)
        ->group_by('paymentreceipt_no')
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('paymentreceipt');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
  
   }
   else if($this->session->userdata('type')=='standard'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml', $sess_eml)
    ->where('delete_status', 1)
    ->group_by('paymentreceipt_no')
    ->group_by('year, month')
    ->order_by('year, month')
    ->get('paymentreceipt');
  
     if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
     } else {
    return $query->result();
      }
  
  }
   
  }


  public function getexpansegraph() { 
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('delete_status', 1)
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('expenditure');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
  
   }
   else if($this->session->userdata('type')=='standard'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml', $sess_eml)
    ->where('delete_status', 1)
    ->group_by('year, month')
    ->order_by('year, month')
    ->get('expenditure');
  
     if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
     } else {
    return $query->result();
      }
  
  }
   
  }
  
   //////////////////////////////////////////////////// monthwise chart for payment receipt graph ends////////////////
   
   public function getcreditnotegraph() { 
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('delete_status', 1)
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('creditnote');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
  
   }
   else if($this->session->userdata('type')=='standard'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml', $sess_eml)
    ->where('delete_status', 1)
    ->group_by('year, month')
    ->order_by('year, month')
    ->get('creditnote');
  
     if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
     } else {
    return $query->result();
      }
  
  }
   
  }


   
  public function getdebitnotegraph() { 
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('delete_status', 1)
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('debitnote');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
  
   }
   else if($this->session->userdata('type')=='standard'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml', $sess_eml)
    ->where('delete_status', 1)
    ->group_by('year, month')
    ->order_by('year, month')
    ->get('debitnote');
  
     if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
     } else {
    return $query->result();
      }
  
  }
   
  }

  public function getchallangraph() { 
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')=='admin'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('delete_status', 1)
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('deliverychallan');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
  
   }
   else if($this->session->userdata('type')=='standard'){
    $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
    ->where('session_comp_email', $session_comp_email)
    ->where('session_company', $session_company)
    ->where('sess_eml', $sess_eml)
    ->where('delete_status', 1)
    ->group_by('year, month')
    ->order_by('year, month')
    ->get('deliverychallan');
  
     if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
     } else {
    return $query->result();
      }
  
  }
   
  }
    
}


