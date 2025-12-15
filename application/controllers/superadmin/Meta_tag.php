<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meta_tag extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Login_model');
		$this->load->model('Branch_model');
		$this->load->model('Reports_model');
		$this->load->model('superadmin/home_model','superadmin');
	}
	
	public function index()
  	{
	    if(!empty($this->session->userdata('loggedsuperadmin_in')))
	    {
	    	
	        $data = array();
			$data['meta_details']= $this->superadmin->get_all_meta_tag();
		    $this->load->view('superadmin/meta_tag',$data);
	    }
	    else
	    {
	      redirect('superadmin/login');
	    }
	}
	public function ajax_list()
	{
		
		$meta_details= $this->superadmin->get_all_meta_tag();
		$i= $_POST['start'];
		$msg="'Are you sure you want to delete this item?'";
		foreach ($meta_details as $post)
		{
		  
		   $row = array();
		   $row[] = $i++;
		   /*$first_row = "";
		   $first_row.= $post['page_title'].'<div class="links">';
		  $first_row.= '</div>';
		  $row[] = $first_row;*/
		  $row[] = $post['page_title'];
		  $row[] = $post['meta_title'];
		  $row[] = $post['meta_keyword'];
		  $row[] = $post['meta_description'];
		   
		  $select_row = "";
		  $select_row.='<select class="form-control change_status" onchange="change_status('.$post["id"].')" name="update_status"> <option value= "1"';
					if($post['status'] == "1" ) { 
							 $select_row.='selected'; 
							 }
				$select_row.='>Active</option> <option value="0" ';
					if($post['status'] == "0" ) {
							$select_row.='selected'; 
							}
				$select_row.= '>Non-active</option></select>';
		   $row[] = $select_row;			   
		   $row[] = '<div><a href="'.base_url("superadmin/meta_tag/meta_addUpdate/".$post["id"]).'">Update</a></div><div><a href="'.base_url("superadmin/meta_tag/meta_tagDelete/".$post["id"]).'" onclick="return confirm('.$msg.');" >Delete</a></div>';
			  $data[] = $row;
		}
		$output = array(
		  "draw" => $_POST['draw'],
		  "recordsTotal" => $this->superadmin->meta_count_all(),
		  "recordsFiltered" => $this->superadmin->meta_count_filtered(),
		  "data" => $data,
		);
		//output to json format
		echo json_encode($output);
	  
		//$this->load->view('superadmin/meta_tagaddUpdate',$data);
	}
	// public function meta_count_all(){
	// print_r($this->superadmin->meta_count_filtered());
	// }
	
	public function meta_addUpdate()
	{
		$meta_id = $this->uri->segment(4);
		$data = array();
		$data['meta_details']= $this->superadmin->get_metatag_by_id($meta_id);
		
		$this->load->view('superadmin/meta_tagaddUpdate',$data);
	}
	public function meta_add()
	{
	   $meta_id = $this->uri->segment(4);
		$data = array();
		$data['meta_details']= $this->superadmin->get_metatag_by_id($meta_id);
		//
		//if($_POST['add']){
			//print_r($this->input->post()); die;
		$this->form_validation->set_rules('page_name', 'Page Name','required');
		$this->form_validation->set_rules('meta_title', 'Meta Title','required');
		$this->form_validation->set_rules('meta_keyword', 'Meta Keyword','required');
		$this->form_validation->set_rules('meta_desc', 'Meta Description','required');
		
		if ($this->form_validation->run() == FALSE) {
			//redirect(base_url('superadmin/meta_tag/meta_addUpdate'));
			$this->load->view('superadmin/meta_tagaddUpdate',$data);
			
		}else{
			
		$input_data = array(
		    'page_title'       => $this->input->post('page_name'),
			'meta_title'       => $this->input->post('meta_title'),
			'meta_keyword'     => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_desc')			
		);
			if($this->superadmin->add_metaTag($input_data)){
				$this->session->set_userdata('success_msg','Meta Tag Add Successfully!');
				redirect(base_url('superadmin/meta_tag'));
			}else{
				$this->session->set_userdata('error_msg','Some Error Occure.Please Try Again!');
				redirect(base_url('superadmin/meta_tag/meta_addUpdate'));
			}
		//}
	}
	}
	public function meta_update($meta_id)
	{
	    //$meta_id = $this->uri->segment(4);
		$data = array();
		$data['meta_details']= $this->superadmin->get_metatag_by_id($meta_id);
		
		if($this->input->post('update')=="" && $meta_id){
			
		$this->form_validation->set_rules('page_name', 'Page Name','required');
		$this->form_validation->set_rules('meta_title', 'Meta Title','required');
		$this->form_validation->set_rules('meta_keyword', 'Meta Keyword','required');
		$this->form_validation->set_rules('meta_desc', 'Meta Description','required');
		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('superadmin/meta_tagaddUpdate',$data);
			
		}else{
			
			$input_data = array(
		    'page_title'       => $this->input->post('page_name'),
			'meta_title'       => $this->input->post('meta_title'),
			'meta_keyword'     => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_desc')			
		    );
			if($this->superadmin->update_metaTag($meta_id,$input_data)){
				$this->session->set_userdata('success_msg','Meta Tag Updated Successfully!');
				redirect(base_url('superadmin/meta_tag'));
			}else{
				$this->session->set_userdata('error_msg','Some Error Occure.Please Try Again!');
				redirect(base_url('superadmin/meta_tag/meta_addUpdate/'.$meta_id));
			}
		}
	}
  }
    public function meta_tagDelete($meta_id)
	{
		if($this->superadmin->delete_metaTag($meta_id)){
				$this->session->set_userdata('success_msg','Meta Tag Deleted Successfully!');
				redirect(base_url('superadmin/meta_tag'));
			}else{
				$this->session->set_userdata('error_msg','Some Error Occure.Please Try Again!');
				redirect(base_url('superadmin/meta_tag'));
			}
	}
}