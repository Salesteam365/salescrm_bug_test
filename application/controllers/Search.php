<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Search_model');
    $this->load->library('email_lib');
  }
  
	public function index()
	{
		if(isset($_GET['q']) && $_GET['q']!=""){
	    $data['result']=$this->Search_model->grep_db('admintea_team365',array($_GET['q']));
		$data['search']=$_GET['q'];
		$this->load->view('reports/search-list',$data);
		}else{
			redirect(base_url().'home');
		}
	}
	
}
?>