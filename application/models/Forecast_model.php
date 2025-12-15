<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forecast_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->db->query('SET SESSION sql_mode =
                  REPLACE(REPLACE(REPLACE(
                  @@sql_mode,
                  "ONLY_FULL_GROUP_BY,", ""),
                  ",ONLY_FULL_GROUP_BY", ""),
                  "ONLY_FULL_GROUP_BY", "")');
    }
  var $table = 'opportunity';
  var $sort_by = array(null,'name','org_name','email','mobile','opportunity_id');
  var $search_by = array('name','org_name','email','mobile','opportunity_id');
  var $order = array('id' => 'desc');
  
  
  public function get_forcast($startDate, $endDate,$self)
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
       $this->db->where('currentdate>=',$startDate);
       $this->db->where('currentdate<=',$endDate);
       if($this->session->userdata('type')=='standard' || $self=='self')
       {
        $this->db->where('sess_eml',$sess_eml);
       }
       $this->db->group_by(array('owner'));
    $query = $this->db->get();
    return $query->result();

  }
  
  public function get_forcast_user($startDate, $endDate,$closeWon='',$sessEml)
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	   if($closeWon!=""){
	       $this->db->where('stage','closed won');
	   }
       $this->db->where('currentdate>=',$startDate);
       $this->db->where('currentdate<=',$endDate);
	   
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();

  }
  
  public function get_forcast_bestCase($startDate, $endDate,$sessEml){
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	    $this->db->group_start();
	    $this->db->or_where('stage','closed won');
        $this->db->or_where('stage','Ready To Close');
        $this->db->or_where('stage','Negotiation');
        $this->db->group_end();
	 
       $this->db->where('currentdate>=',$startDate);
       $this->db->where('currentdate<=',$endDate);
	   
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  
  public function get_forcast_Commit($startDate, $endDate,$sessEml){
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	    $this->db->group_start();
	    $this->db->or_where('stage','closed won');
        $this->db->or_where('stage','Ready To Close');
        $this->db->group_end();
	 
       $this->db->where('currentdate>=',$startDate);
       $this->db->where('currentdate<=',$endDate);
	   
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  
  
  
  
  public function get_forcast_monthly($year, $month,$self)
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       if($self=='self'){
          $this->db->where('sess_eml',$sess_eml); 
       }
       $this->db->where('delete_status',1);
       $this->db->where('YEAR(currentdate)',$year);
       $this->db->where('MONTH(currentdate)',$month);
       $this->db->group_by(array('owner'));
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
    $query = $this->db->get();
    return $query->result();

  }
  
  public function get_forcast_user_monthly($year, $month,$closeWon='',$sessEml)
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	   if($closeWon!=""){
	       $this->db->where('stage','closed won');
	   }
       $this->db->where('YEAR(currentdate)',$year);
       $this->db->where('MONTH(currentdate)',$month);
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();

  }
  
  public function get_forcast_bestCase_monthly($year, $month,$sessEml){
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	    $this->db->group_start();
	    $this->db->or_where('stage','closed won');
        $this->db->or_where('stage','Ready To Close');
        $this->db->or_where('stage','Negotiation');
        $this->db->group_end();
	 
       $this->db->where('YEAR(currentdate)',$year);
       $this->db->where('MONTH(currentdate)',$month);
	   
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  
  public function get_forcast_Commit_monthly($year, $month,$sessEml){
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
	
       $this->db->select('owner, sess_eml, SUM(initial_total) as op_total'); 
       $this->db->from('opportunity');
       $this->db->where('session_comp_email',$session_comp_email);
       $this->db->where('session_company',$session_company);
       $this->db->where('delete_status',1);
	    $this->db->group_start();
	    $this->db->or_where('stage','closed won');
        $this->db->or_where('stage','Ready To Close');
        $this->db->group_end();
	 
       $this->db->where('YEAR(currentdate)',$year);
       $this->db->where('MONTH(currentdate)',$month);
	   
       $this->db->group_by(array('owner'));
      
    if($this->session->userdata('type')=='standard')
    {
        $this->db->where('sess_eml',$sess_eml);
    }
	if($sessEml!="")
    {
        $this->db->where('sess_eml',$sessEml);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
    public function salesStdUser(){
       
     $session_comp_email = $this->session->userdata('company_email');
     $session_company 	= $this->session->userdata('company_name');	   
     $this->db->select('*');
	 $this->db->where('company_email',$session_comp_email);
     $this->db->where('company_name',$session_company);
	 $this->db->where('status','1');	 
     $this->db->group_start();	
     $this->db->where('user_type','Sales Person');	 
     $this->db->or_where('user_type','Sales Manager');
     $this->db->group_end();
	 $query = $this->db->get("standard_users");
     return $query->result();
  } 
  
  public function get_forcast_quota($user_email,$financialYr){
     $session_comp_email = $this->session->userdata('company_email');
     $session_company 	 = $this->session->userdata('company_name');
	 $this->db->from('quota');
	 $this->db->select('quota.finacial_year,quota.quota,quota.jan_month,quota.feb_month,quota.mar_month,quota.apr_month,quota.may_month,quota.jun_month,quota.jul_month,quota.aug_month,quota.sep_month,quota.oct_month,quota.nov_month,quota.dec_month,quota.quat1,quota.quat2,quota.quat3,quota.quat4');
	// $this->db->join('standard_users','quota.user_email=standard_users.standard_email');
	 $this->db->where('quota.user_email',$user_email);
	 $this->db->where('quota.session_comp_email',$session_comp_email);
     $this->db->where('quota.session_company',$session_company);
     $this->db->where('quota.finacial_year',$financialYr);
	 $this->db->where('quota.delete_status','1');
	 $query = $this->db->get();
     return $query->row_array();
  }
  
    public function createQuota($adddata){
	 $this->db->insert('quota',$adddata); 
	 return $this->db->insert_id(); 
    }
   
   public function exitquotaUser($user_id){
	 $this->db->select('*');
	 $this->db->where('user_email',$user_id);    
	 $query = $this->db->get("quota");
     return $query->row_array();	 
   }
  
 
  

//Please write code above this
}
?>
