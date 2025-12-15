<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Product_manager extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Product_model','Product');
  }
  public function index()
  {
    if(!empty($this->session->userdata('email')))
    {
        if(checkModuleForContr('Inventory')<1){
	        redirect('home');
	        exit;
	    }
		if(check_permission_status('Product','retrieve_u')==true){
			$this->load->view('inventory/product-manager');
		}
    }
    else
    {
      redirect('login');
    }
  }
  
  
  
  public function ajax_list()
  {
	$data = array();
	$delete_product	=0;
	$update_product	=0;
	$retrieve_product=0; 
	if(check_permission_status('Product','delete_u')==true){
		$delete_product=1;
	}
	if(check_permission_status('Product','retrieve_u')==true){
		$retrieve_product=1;
	}
	if(check_permission_status('Product','update_u')==true){
		$update_product=1;
	}
	     
	$this->load->model('Product_model');
    $list = $this->Product_model->get_datatables();
	
    $no = $_POST['start'];
        foreach ($list as $post)
        {
          $no++;
          $row = array();
          // APPEND HTML FOR ACTION
        //   if($delete_product==1) { 
        //     $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
        //   }

		  if($delete_product == 1) {
                 $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'" onclick="showAction(' . $post->id . ')">';
				//    $row[] = '<input type="checkbox" class="delete_checkbox" onClick="checkCheckbox(); showAction(' . $post->id . ');" name="action_ck" value="'.$post->id.'">';
            }
          $first_row = "";
          $first_row = ucwords($post->product_name);
			$row[] = '<a href="javascript:void(0)" onclick="view(\'' . $post->id . '\')">' . $first_row . '</a>';

          $row[] = $post->sku;
          $row[] = $post->hsn_code;
          $row[] = ucfirst($post->product_category);
          $row[] = substr($post->product_description,0,50);
          $row[] = IND_money_format($post->product_unit_price);
          $row[] = ucfirst($post->product_quantity);
          $row[] = ucfirst($post->stock_alert);
		  
		  $action='<div class="row" style="font-size: 15px;">';
			if($retrieve_product==1){
				$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".')"  class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Product Details" ></i></a>';
			}
			if($update_product==1){
				$action.='<a style="text-decoration:none" href="'.base_url().'inventory-form/'.$post->id.'"   class="text-primary border-right">
					<i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Product" ></i></a>';
			}	
			
			if($delete_product==1){	
				$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger">
					<i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Product" ></i></a>';
			}
			$action.='</div>';
			$row[]=$action; 
            $data[] = $row;
        }
		
		
    $output = array(
      "draw" 			=> $_POST['draw'],
      "recordsTotal" 	=> $this->Product_model->count_all(),
      "recordsFiltered" => $this->Product_model->count_filtered(),
      "data" 			=> $data
    );
    //output to json format 
    echo json_encode($output);
  }
  
  public function getbyId($id)
  {
	$this->load->model('Product_model');
    $data = $this->Product_model->get_by_id($id);
    echo json_encode($data);
  }
  
  
 public function autocomplete_product()
  {
	  $this->load->model('Product_model');
    if (isset($_GET['term'])) {
      $result = $this->Product_model->get_pro_name($_GET['term']);
      
        foreach ($result as $row){
        $arr_result[] = array(
          'label'   => $row->product_name,
          'data'   => "1",
          'name'   => $_GET['term']
          );
        }
      
        $arr_result[] = array(
          'label'   => "+ Add '".$_GET['term']."'",
          'data'   => "2",
          'name'   => $_GET['term']
        );
        echo json_encode($arr_result);
     
    }
  }
  public function get_pro_details()
  {
	$this->load->model('Product_model');
    $org_name = $this->input->post();
    $data = $this->Product_model->getProValue($org_name);
    echo json_encode($data);
  }
 
  
  public function inventory_form(){
	if(!empty($this->session->userdata('email')))
    {
        if(checkModuleForContr('Inventory')<1){
	        redirect('home');
	    }
	  $product_id = $this->uri->segment(2);
	  $data['pro'] = $this->Product->getById($product_id);
      $this->load->view('inventory/inventory-form',$data);
    }
    else
    {
      redirect('login');
    }
  }
  
   public function  createFromInvoice(){
	  $this->load->model('Product_model','Product');
	 if($this->input->post('proname')){
		$proname	=$this->input->post('proname'); 
		$prosku		=$this->input->post('prosku'); 
		$prohsn		=$this->input->post('prohsn'); 
		$proprice	=$this->input->post('proprice'); 
		$prodesc	=$this->input->post('prodesc'); 
		$proGST		=$this->input->post('proGST');  
		$proisbn    =$this->input->post('proisbn');  
		$sess_eml           = $this->session->userdata('email');
        $session_company    = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
        
		$dataArr=array(
			'sess_eml' 			 => $sess_eml,
			'session_company' 	 => $session_company,
			'session_comp_email' => $session_comp_email,
			'sku'				 => $prosku,
			'isbn'				 => $proisbn,
			'hsn_code'			 => $prohsn,
			'product_name'		 => $proname,
			'product_unit_price' => $proprice,
			'product_description'=> $prodesc,
			'pro_gst'			 => $proGST,
			'currentdate'		 => date('Y-m-d')
		);
 
		$id = $this->Product->insertData($dataArr);
		if(!empty($id))
		{
			$x = "100";
			$vd = $id+$x;
			$pro_id = "PROD/".date('Y')."/".$vd;
			$this->Product->product_id($pro_id,$id);
			echo json_encode(array("status" => TRUE));
		}else 
		{
			echo json_encode(array("status" => FALSE));
		}
	 }else{
      return json_encode(array('st'=>202));
	 }
  }
  
  
  public function  create(){
	  $this->load->model('Product_model','Product');
	 if($this->input->post('proname')){
		$proname	=$this->input->post('proname'); 
		$prosku		=$this->input->post('prosku'); 
		$prohsn		=$this->input->post('prohsn'); 
		$prounit	=$this->input->post('prounit'); 
		$procategory=$this->input->post('procategory'); 
		$proprice	=$this->input->post('proprice'); 
		$prodesc	=$this->input->post('prodesc'); 
		$proIncAcc	=$this->input->post('proIncAcc'); 
		$proInvAssAcc	=$this->input->post('proInvAssAcc'); 
		$proGST			=$this->input->post('proGST'); 
		$proRevCharge	=$this->input->post('proRevCharge'); 
		$proPrefSupp	=$this->input->post('proPrefSupp'); 
		$proLowAlert	=$this->input->post('proLowAlert'); 
		$proisbn	=$this->input->post('proisbn'); 
		$proQty	=$this->input->post('proQty'); 
		
		$sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
  
		$dataArr=array(
			'sess_eml' 			 => $sess_eml,
			'session_company' 	 => $session_company,
			'session_comp_email' => $session_comp_email,
			'product_category'   => $procategory,
			'sku'				 => $prosku,
			'isbn'				 => $proisbn,
			'hsn_code'			 => $prohsn,
			'unit'				 => $prounit,
			'product_name'		 => $proname,
			'product_quantity'	 => $proQty,
			'product_unit_price' => $proprice,
			'product_description'=> $prodesc,
			'reverse_charge'	 => $proRevCharge,
			'preferred_supplier' => $proPrefSupp,
			'stock_alert'		 => $proLowAlert,
			'pro_gst'			 => $proGST,
			'income_account'	 => $proIncAcc,
			'currentdate'		 => date('Y-m-d')
		);
  
		$id = $this->Product->insertData($dataArr);
		if(!empty($id))
		{
			$x = "100";
			$vd = $id+$x;
			$pro_id = "PROD/".date('Y')."/".$vd;
			$this->Product->product_id($pro_id,$id);
			echo json_encode(array("status" => TRUE));
		}else 
		{
			echo json_encode(array("status" => FALSE));
		}
	 }else{
      return json_encode(array('st'=>202));
	 }
  }
  
  
  public function update_form(){
	  $this->load->model('Product_model','Product');
	 if($this->input->post('proname')){
		$proname	=$this->input->post('proname'); 
		$prosku		=$this->input->post('prosku'); 
		$prohsn		=$this->input->post('prohsn'); 
		$prounit	=$this->input->post('prounit'); 
		$procategory=$this->input->post('procategory'); 
		$proprice	=$this->input->post('proprice'); 
		$prodesc	=$this->input->post('prodesc'); 
		$proIncAcc	=$this->input->post('proIncAcc'); 
		$proInvAssAcc	=$this->input->post('proInvAssAcc'); 
		$proGST			=$this->input->post('proGST'); 
		$proRevCharge	=$this->input->post('proRevCharge'); 
		$proPrefSupp	=$this->input->post('proPrefSupp'); 
		$proLowAlert	=$this->input->post('proLowAlert'); 
		$proisbn	=$this->input->post('proisbn'); 
		$proQty	=$this->input->post('proQty'); 
		
  
		$dataArr=array(
			'product_category'   => $procategory,
			'sku'				 => $prosku,
			'isbn'				 => $proisbn,
			'hsn_code'			 => $prohsn,
			'unit'				 => $prounit,
			'product_name'		 => $proname,
			'product_quantity'	 => $proQty,
			'product_unit_price' => $proprice,
			'product_description'=> $prodesc,
			'reverse_charge'	 => $proRevCharge,
			'preferred_supplier' => $proPrefSupp,
			'stock_alert'		 => $proLowAlert,
			'pro_gst'			 => $proGST,
			'income_account'	 => $proIncAcc
		);
  $product_id = $this->input->post('proid');
		$id = $this->Product->updateData($dataArr,$product_id);
		if(!empty($id))
		{
			echo json_encode(array("status" => $id));
		}else 
		{
			echo json_encode(array("status" => FALSE));
		}
	 }else{
      echo  json_encode(array('st'=>202));
	 }
  }
  
  
  public function service_create(){
	 $this->load->model('Product_model','Product');
	
		// echo json_encode(array("status" => FALSE)); exit;
	 if($this->input->post('servicename')){
		// echo json_encode(array("status" => FALSE)); exit;
		$servicename	=$this->input->post('servicename'); 
		$servicesku		=$this->input->post('servicesku'); 
		$serviceSAC		=$this->input->post('serviceSAC'); 
		$serviceUnit	=$this->input->post('serviceUnit'); 
		$serviceValue	=$this->input->post('serviceValue'); 
		$serviceCategory=$this->input->post('serviceCategory'); 
		$servicePrice	=$this->input->post('servicePrice'); 
		$serviceDesc	=$this->input->post('serviceDesc'); 
		$serviceIncAcc	=$this->input->post('serviceIncAcc'); 
		$serviceAssAcc	=$this->input->post('serviceAssAcc'); 
		//$proGST			=$this->input->post('proGST'); 
		$serviceTax		=$this->input->post('serviceTax'); 
		$serviceAbatement=$this->input->post('serviceAbatement'); 
		$serviceType	=$this->input->post('serviceType'); 
		$serviceInfo	=$this->input->post('serviceInfo'); 
		$serviceQuantity=$this->input->post('serviceQuantity'); 
		
		$sess_eml 			= $this->session->userdata('email');
        $session_company 	= $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
  
		$dataArr=array(
			'sess_eml' 			 => $sess_eml,
			'session_company' 	 => $session_company,
			'session_comp_email' => $session_comp_email,
			'product_category'   => $serviceCategory,
			'sku'				 => $servicesku,
			//'isbn'				 => $proisbn,
			//'hsn_code'			 => $prohsn,
			'unit'				 => $serviceUnit,
			'service_name'		 => $servicename,
			'service_quantity'	 => $serviceQuantity,
			'service_unit_price' => $servicePrice,
			'product_description'=> $serviceDesc,
			'currentdate'		 => date('Y-m-d')
		);
   // print_r($dataArr); exit;
		$id = $this->Product->insertData($dataArr);
		if(!empty($id))
		{
			$x = "100";
			$vd = $id+$x;
			$pro_id = "PROD/".date('Y')."/".$vd;
			$this->Product->product_id($pro_id,$id);
			echo json_encode(array("status" => TRUE));
		}else 
		{
			echo json_encode(array("status" => FALSE));
		}
	 }else{
      return json_encode(array('st'=>202));
	 } 
	  
	  
  }
  
  
  
  public function service_form(){
	if(!empty($this->session->userdata('email')))
    {
        if(checkModuleForContr('Inventory')<1){
	        redirect('home');
	    }
      $this->load->view('inventory/service-form');
    }
    else
    {
      redirect('login');
    }
  }
  
      public function delete($id)
	  {
		  $this->load->model('Product_model');
		$this->Product_model->delete($id);
		echo json_encode(array("status" => TRUE));
	  }
	  
	  public function delete_bulk()
	  { $this->load->model('Product_model');
		if($this->input->post('checkbox_value'))
		{
		  $id = $this->input->post('checkbox_value');
		  for($count = 0; $count < count($id); $count++)
		  {
			$this->Product_model->delete_bulk($id[$count]);
		  }
		}
	  }
  
 
 public function import()
	{
		$this->load->library('csvimport');
		
		if(isset($_FILES["file"]["name"]))
		{
			
		$duplicate_array = array();
		$message_array = array();
		
		$file_data = $this->csvimport->get_array($_FILES["file"]["tmp_name"]);

			foreach($file_data as $row)
			{
			
			$proName		= $row["product_name"];
			$sku 	        = $row["sku"];
			$hsn_code     = $row["hsn_code"];
			$isbn_code    = $row["isbn_code"];
			$price 	    = $row["unit_price"];
			$gstTax		= $row["gst_tax"];
			$description  = $row["description"];
			$currentdate  = date('Y-m-d');  
			$delete_status= 1;  
			
			if($sku==""){ $sku='';  }
			if($hsn_code==""){ $hsn_code='';}
			if($isbn_code==""){ $isbn_code=''; }
			if($price==""){ $price='';}
			if($gstTax==""){ $gstTax='';}
			if($description==""){$description='';}
			
			$dataArr = array(
				'sess_eml' 			=> $this->session->userdata('email'),
				'session_company' 	=> $this->session->userdata('company_name'),
				'session_comp_email'=> $this->session->userdata('company_email'),
				'product_name'      => $proName,
				'sku'    	        => $sku,
				'isbn' 	            => $isbn_code,
				'hsn_code'          => $hsn_code,
				'pro_gst'           => $gstTax,
				'product_unit_price'=> $price,
				'product_description'=> $description,
				'currentdate'  		=> $currentdate,
				'delete_status'  	=> $delete_status
			);
		
				if(empty($proName) || empty($price) || empty($gstTax))
				{
				echo json_encode(array('st'=> 202, 'msg'=> 'Import Failed All Fields Are Required'));
				}else if(!empty($proName) && !empty($price))
				{	 
					$result = $this->Product->check_duplicate_product($proName,$price,$sku);
					
					if(!empty($result)){ 
						array_push($duplicate_array, $result);
					}else{
						$id = $this->Product->insertData($dataArr);
						$x = "100";
						$vd = $id+$x;
						$pro_id = "PROD/".date('Y')."/".$vd;
						$this->Product->product_id($pro_id,$id);
						$message_array=array('st'=> 200, 'msg'=> 'Data Imported Successfully');
						
					}
				}
			}
			
		if(count($duplicate_array)>0){
				echo json_encode($duplicate_array);
		}else{
			echo json_encode($message_array);
		}
		
		} 
	}



	public function add_mass()
	{
		$this->load->model('Product_model');
		if ($this->input->is_ajax_request()) {
			
			$mass_id=$this->input->post('mass_id');
			$mass_name=$this->input->post('mass_name');
			$mass_value=$this->input->post('mass_value');
				// print_r('test2');die;
			// print_r($mass_id);die;

			$dataArry = array(
				$mass_name => $mass_value,
				'currentdate' => date('Y-m-d')
				
			);

			$mass_data = $this->Product_model->mass_save($mass_id, $dataArry);
			if (!empty($mass_data)) {
				$response = array(
					'success' => true,
					'message' => 'Mass Update Successfully'
				);
				echo json_encode($response);
			} else {
				$response = array(
					'success' => false,
					'message' => 'Mass Update Failed'
				);
				echo json_encode($response);
			}
		} else {
			echo "Invalid request";
		}
	}
 
//Please write code above this  
}