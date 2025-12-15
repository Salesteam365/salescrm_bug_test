<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
        $this->load->model(array('Invoice_model','vendors_model','organization_model','Base_model'));
		$this->load->model('Organization_model','Organization');
        $this->load->model('Salesorders_model', 'Salesorders');
		$this->load->model('Contact_model','Contact');
		$this->load->model('Login_model'); 
		$this->load->model('Purchaseorders_model'); 
		$this->load->model('Reports_model','Reports');
		$this->load->model('Activities_model','Todo_work');
		$this->load->library('excel');

   }


//   -----------------Start Accounting Report -------------------------------> 
   public function reports() 
   { 
	   $this->load->view('accounting/account-reports');
   }

public function fetch_Date_filter() {
    $startDate = $this->input->post('startDate');
    $endDate = $this->input->post('endDate');

    // Fetch data with default dates if start and end dates are not provided
    if ($startDate === null || $endDate === null) {
        $startDate = '';
        $endDate = '';
    }

    $data['expenditureList'] = $this->Base_model->fetchData_expenditure_by($startDate, $endDate);
    $data['invoicesList'] = $this->Base_model->fetchData_invoices_by($startDate, $endDate);
    $data['PurchaseordersList'] = $this->Base_model->fetchData_Purchaseorders_by($startDate, $endDate);
	// print_r($data['expenditureList']);die;
    
    $response = [
        'count_ino' => 0,
        'total_subtotal_ino' => 0,
        'total_pending_payment_ino' => 0,
		'total_gst_ino' => 0,

        'count_par' => 0,
        'total_subtotal_par' => 0,

        'count_expenditure' => 0,
        'total_subtotal_exp' => 0,
        'total_pending_payment_exp' => 0
    ];

    if (!empty($data['invoicesList'])) {
        $total_ino = count($data['invoicesList']);
        $total_subtotal_ino = array_sum(array_column($data['invoicesList'], 'sub_total'));
        $ino_pending_payment = array_sum(array_column($data['invoicesList'], 'pending_payment'));
        $total_gst_ino = array_sum(array_column($data['invoicesList'], 'gst'));

        $response['count_ino'] = $total_ino;
        $response['total_subtotal_ino'] = $total_subtotal_ino;
        $response['total_pending_payment_ino'] = $ino_pending_payment;
        $response['total_gst_ino'] = $total_gst_ino;
    }

    if (!empty($data['PurchaseordersList'])) {
        $total_par = count($data['PurchaseordersList']);
        $total_subtotal_par = array_sum(array_column($data['PurchaseordersList'], 'sub_total'));

        $response['count_par'] = $total_par;
        $response['total_subtotal_par'] = $total_subtotal_par;
    }

    if (!empty($data['expenditureList'])) {
        $total_expenditure = count($data['expenditureList']);
        $total_subtotal_exp = array_sum(array_column($data['expenditureList'], 'sub_total'));
        $exp_pending_payment = array_sum(array_column($data['expenditureList'], 'pending_payment'));

        $response['count_expenditure'] = $total_expenditure;
        $response['total_subtotal_exp'] = $total_subtotal_exp;
        $response['total_pending_payment_exp'] = $exp_pending_payment;
    }

    echo json_encode($response);
}





// ----------------------------- End Accunting Report --------------------------------- >

public function get_paymentreceipt_graph(){ 
	$data['grouped_data'] = $this->Base_model->getpaymentgraph();
	$response = [
		'status' => 'success',
		'data' => $data['grouped_data']  // Corrected variable name
	];
	$this->output->set_content_type('application/json')->set_output(json_encode($response));
}


   public function paymentreciept()  
   {
		$data['user'] = $this->Login_model->getusername();
		$data['admin'] = $this->Login_model->getadminname();
	   $this->load->view('accounting/paymentreciept' ,$data);
   }

public function add_paymentreciept() 
{
    $last_paymentreceipt_no = $this->Base_model->get_last_paymentreceipt_no();
	// print_r($last_paymentreceipt_no);die;
	// $string =$last_paymentreceipt_no;
	// 		$parts = explode('/', $string);
	// 		$last_digit = end($parts);
		
    $new_paymentreceipt_no = $last_paymentreceipt_no + 1;
    $data['receipt_number'] = generateserialnum($new_paymentreceipt_no, 'paymentreceipt', 'paymentreceipt_no');

    $this->load->view('accounting/add-payment-rec-form', $data);
}


   public function fetch_invoices_OnClients_id_data() {
		$clientId = $this->input->post('clientId');
		$invoicesData = $this->Base_model->getInvoicesByClientId($clientId);
		if ($invoicesData) {	
			echo json_encode(array(
				'status' => 'success',
				'invoices' => $invoicesData
			));
		} else {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'No invoices found for the specified client ID.'
			));
		}
	}


	public function fetch_pi_invoices_OnClients_id_data() {
		$clientId = $this->input->post('clientId');
		$PIinvoicesData = $this->Base_model->get_piInvoicesByClientId($clientId);
		if ($PIinvoicesData) {	
			echo json_encode(array(
				'status' => 'success',
				'PIinvoicesData' => $PIinvoicesData
			));
		} else {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'No PI invoices found for the specified client ID.'
			));
		}
	}


	public function fetch_invoices_match_data() {
		$invoicesId = $this->input->post('id');
		$invoiceData = $this->Base_model->getInvoicesByino_Id($invoicesId);
		if ($invoiceData) {
			echo json_encode(array(
				'status' => 'success',
				'invoices' => $invoiceData
			));
		} else {
			// If no data is found, return an empty array or handle the error accordingly
			echo json_encode(array(
				'status' => 'error',
				'message' => 'No invoices found for the specified invoice ID.'
			));
		}
	}


	// fetch data for update
	public function fetch_payment_details() {
		
		$paymentId = $this->input->get('paymentId');
		$paymentDetails = $this->Base_model->get_payment_details($paymentId);
		header('Content-Type: application/json');
		echo json_encode($paymentDetails);
	}


	public function fetch_Clients_org_data(){ 
		if ($this->input->is_ajax_request()) {
		$client_org 	= $this->Organization->get_datatables();
		// print_r($client_org);die;
		echo json_encode($client_org);
		} else {
			show_404();
		}
	}

		public function fetch_invoices_data()
		{
		if ($this->input->is_ajax_request()) {
			$invoice_id = $this->input->post('id');
		
			$invoice_data = $this->Base_model->get_invoice_data($invoice_id);

			if ($invoice_data) {

				$this->session->set_userdata('invoice_data', $invoice_data);
				// If data is found, return it as JSON
				echo json_encode(array(
					'status' => 'success',
					'invoices' => $invoice_data
				));
			} else {
				// If no data is found, return an empty array or handle the error accordingly
				echo json_encode(array(
					'status' => 'error',
					'message' => 'No invoices found for the specified invoice ID.'
				));
			}

		
		} else {
			show_404();
		}
		}


		public function save_payment_data() 
			{
				
				$deposited_to = $this->input->post('deposited_to');
				$deposited_to = $this->input->post('deposited_to');
				$payment_method = $this->input->post('payment_method');
				$amount_received = $this->input->post('amount_received');
				$ref_id = $this->input->post('ref_id');
				$transaction_charge = $this->input->post('transaction_charge');
				$tds = $this->input->post('tds');
				$tds_Withheld = $this->input->post('tds_Withheld');
				$additional_notes = $this->input->post('additional_notes');

				$payment_data = array(
					'deposited_to' => $deposited_to,
					'payment_method' => $payment_method,
					'amount_received' => $amount_received,
					'ref_id' => $ref_id,
					'transaction_charge' => $transaction_charge,
					'tds' => $tds,
					'tds_Withheld' => $tds_Withheld,
					'additional_notes' => $additional_notes
				);

			
				$insert_result = $this->Base_model->save_payment($payment_data);
					// print_r($insert_result);die;

				// Prepare the response
				$response = array();
				if ($insert_result) {
					$response['success'] = true;
					$response['message'] = "Payment data saved successfully.";
					// $response['inserted_id'] = $insert_result;
				} else {
					$response['success'] = false;
					$response['message'] = "Failed to save payment data.";
				}

				// Send JSON response back to the client-side JavaScript
				echo json_encode($response);
			}





		public function add_payment() 
		{			
			$org_clients = $this->input->post('org_clients');
			$invoice_no_select = $this->input->post('invoice_no_select');
			$pi_invoice_no_select = $this->input->post('pi_invoice_no_select');


			if(!$invoice_no_select =="") {
				$invoice_data = $this->session->userdata('invoice_data');
			// if ($invoice_data && isset($invoice_data->id)) {
				// print_r('testing');die;
				$paymentreceipt_no = $this->input->post('paymentreceipt_no');
				$currency = $this->input->post('currency');
				$paymentreceipt_date = $this->input->post('paymentreceipt_date');
				$p_notes = $this->input->post('p_notes');
				


				  // Retrieve global variables from POST data
				  $globalTotalAmountReceived = $this->input->post('globalTotalAmountReceived');
				  $globalTotalTransactionCharge = $this->input->post('globalTotalTransactionCharge');
				  $globalTotalTds = $this->input->post('globalTotalTds');

				$invoice_data->TotalAmountReceived = $globalTotalAmountReceived;
				$invoice_data->TotalTransactionCharge = $globalTotalTransactionCharge;
				$invoice_data->TotalTds = $globalTotalTds;

				$invoice_data->paymentreceipt_no = $paymentreceipt_no;
				$invoice_data->currency = $currency;
				$invoice_data->paymentreceipt_date = $paymentreceipt_date;
				$invoice_data->p_notes = $p_notes;
				$invoice_data->is_advance = "no"; 

				// print_r($invoice_data);die;

				$inputData = $this->input->post();

				$dynamicTableData = json_decode($inputData['dynamicTableData'], true);


				// print_r($dynamicTableData);die;
				// $invoicesTableData = json_decode($inputData['invoicesTableData'], true);

				 foreach ($dynamicTableData as $dynamicData) {
					$dataToInsert = array_merge((array) $invoice_data, $dynamicData);

				
					// Insert $dataToInsert into the database using your model method
					$insertdata = $this->Base_model->add_payment_all('paymentreceipt', $dataToInsert);
				}

				// $insertdata = $this->Base_model->add_payment_all('paymentreceipt', $invoice_data);
				$response = array();
		
				if ($insertdata == 1) {
					$response['success'] = true;
					$response['message'] = "Data inserted successfully";
				} else {
					$response['success'] = false;
					$response['message'] = "Failed to insert data";
				}
		
				echo json_encode($response);
			} else {
				
				$invoice_data = $this->session->userdata('invoice_data');
				
				$paymentreceipt_no = $this->input->post('paymentreceipt_no');
				$currency = $this->input->post('currency');
				$paymentreceipt_date = $this->input->post('paymentreceipt_date');
				$p_notes = $this->input->post('c_notes');
				

				  // Retrieve global variables from POST data
				  $globalTotalAmountReceived = $this->input->post('globalTotalAmountReceived');
				  $globalTotalTransactionCharge = $this->input->post('globalTotalTransactionCharge');
				  $globalTotalTds = $this->input->post('globalTotalTds');


				$invoice_data->TotalAmountReceived = $globalTotalAmountReceived;
				$invoice_data->TotalTransactionCharge = $globalTotalTransactionCharge;
				$invoice_data->TotalTds = $globalTotalTds;

				// $invoice_data->org_clients = $org_clients;
				$invoice_data->pi_invoice_no_select = $pi_invoice_no_select;
				$invoice_data->paymentreceipt_no = $paymentreceipt_no;
				$invoice_data->currency = $currency;
				$invoice_data->paymentreceipt_date = $paymentreceipt_date;
				$invoice_data->p_notes = $p_notes;
				$invoice_data->is_advance = "yes"; 

				$inputData = $this->input->post(); 

				// Extract dynamic table data
				$dynamicTableData = json_decode($inputData['dynamicTableData'], true);

				 // Iterate through dynamic table data and combine with invoice data
				 foreach ($dynamicTableData as $dynamicData) {
					$dataToInsert = array_merge((array) $invoice_data, $dynamicData);
					
					$insertdata = $this->Base_model->add_payment_all('paymentreceipt', $dataToInsert);
					
				}

				$response = array();
				if ($insertdata == 1) {
					$response['success'] = true;
					$response['message'] = "Data inserted successfully";
				} else {
					$response['success'] = false;
					$response['message'] = "Failed to insert data";
				}
		
				echo json_encode($response);


				// echo "Invoice data not found in the session or ID is missing.";
			}
		
		}


		// Save Bank details Payment
		public function save_bank_data() {
			// print_r('testing');die;
			// Set validation rules
			$this->form_validation->set_rules('countryConfirmation', 'Country', 'required');
			$this->form_validation->set_rules('bankNameConfirmation', 'Bank Name', 'required');
			$this->form_validation->set_rules('accountNumberConfirmation', 'Account Number', 'required|numeric');
			$this->form_validation->set_rules('confirmAccountNumberConfirmation', 'Confirm Account Number', 'required|matches[accountNumberConfirmation]');
			$this->form_validation->set_rules('ifscCodeConfirmation', 'IFSC Code', 'required');
			$this->form_validation->set_rules('accountHolderNameConfirmation', 'Account Holder Name', 'required');
			$this->form_validation->set_rules('bankAccountTypeConfirmation', 'Bank Account Type', 'required');
			$this->form_validation->set_rules('currencyConfirmation', 'Currency', 'required');
	
			// Check if form validation passes
			if ($this->form_validation->run() == FALSE) {
				// If validation fails
				$response['success'] = false;
				$response['message'] = validation_errors();
			} else {
				// If validation passes, proceed to save data
				$data = array(
					'country' => $this->input->post('countryConfirmation'),
					'bank_name' => $this->input->post('bankNameConfirmation'),
					'account_number' => $this->input->post('accountNumberConfirmation'),
					'ifsc_code' => $this->input->post('ifscCodeConfirmation'),
					'account_holder_name' => $this->input->post('accountHolderNameConfirmation'),
					'bank_account_type' => $this->input->post('bankAccountTypeConfirmation'),
					'currency' => $this->input->post('currencyConfirmation'),
					'swift_id' => $this->input->post('swift_id'),
					'iban' => $this->input->post('iban')
					
				);
				// print_r($data);die;
				$insert_id = $this->Base_model->save_bank_data($data);
	
				if ($insert_id) {
					// If data saved successfully
					$response['success'] = true;
					$response['message'] = 'Bank data saved successfully.';
				} else {
					// If failed to save data
					$response['success'] = false;
					$response['message'] = 'Failed to save bank data.';
				}
			}
	
			// Send JSON response
			echo json_encode($response);
		}

		public function save_employee_data(){
			$this->form_validation->set_rules('country_employee', 'Country Name ', 'required');
			$this->form_validation->set_rules('employeeName', 'Employee Name', 'required');
			$this->form_validation->set_rules('department_employee', 'Department', 'required');
			$this->form_validation->set_rules('currency_employee', 'Currency', 'required');
			if ($this->form_validation->run() == FALSE) {
				$response['success'] = false;
				$response['message'] = validation_errors();
			} else {
				$data = array(
					'country_employee' => $this->input->post('country_employee'),
					'employeeName' => $this->input->post('employeeName'),
					'department_employee' => $this->input->post('department_employee'),
					'currency_employee' => $this->input->post('currency_employee'),

					'level' => $this->input->post('level'),
					'employee_Id' => $this->input->post('employee_Id'),
					'phone_number' => $this->input->post('phone_number'),
				);
				$insert_id = $this->Base_model->save_employee_data($data);
	
				if ($insert_id) {
					$response['success'] = true;
					$response['message'] = 'Employee data saved successfully.';
				} else {
					$response['success'] = false;
					$response['message'] = 'Failed to save bank data.';
				}
			}
			// print_r($data);die;
			echo json_encode($response);
		}

		public function save_other_data(){
			$this->form_validation->set_rules('accountName_other', 'Account Name', 'required');
			$this->form_validation->set_rules('accounttype_other', 'Account type', 'required');
			$this->form_validation->set_rules('currency_other', 'Currency', 'required');
	
			// Check if form validation passes
			if ($this->form_validation->run() == FALSE) {
				// If validation fails
				$response['success'] = false;
				$response['message'] = validation_errors();
			} else {
				// If validation passes, proceed to save data
				$data = array(
					'accountName_other' => $this->input->post('accountName_other'),
					'accounttype_other' => $this->input->post('accounttype_other'),
					'currency_other' => $this->input->post('currency_other'),
					'link_bank_other' => $this->input->post('link_bank'),
					'link_employee_account_other' => $this->input->post('link_employee_account'),
					// Add more fields as needed
				);
				// print_r($data);die;
	
				// Save data to database
				$insert_id = $this->Base_model->save_other_data($data);
	
				if ($insert_id) {
					// If data saved successfully
					$response['success'] = true;
					$response['message'] = 'Other data saved successfully.';
				} else {
					// If failed to save data
					$response['success'] = false;
					$response['message'] = 'Failed to save bank data.';
				}
			}
	
			// Send JSON response
			echo json_encode($response);
		}

		public function Bank_Data()
		{
		if ($this->input->is_ajax_request()) {
		
			$bank_data = $this->Base_model->get_Bank_data();
			// print_r($bank_data);die;

			if ($bank_data) {
				echo json_encode(array(
					'status' => 'success',
					'bank_data' => $bank_data
				));
			} else {
				// If no data is found, return an empty array or handle the error accordingly
				echo json_encode(array(
					'status' => 'error',
					'message' => 'No Bank Details.'
				));
			}

		
		} else {
			show_404();
		}
		}
		

	public function ajax_listpayment()
	{
		// print_r('test');die;
	 
		$delete_inv	=0;
		$update_inv	=0;
		$retrieve_inv=0; 
		if(check_permission_status('Invoice','delete_u')==true){
			$delete_inv=1;
		}
		if(check_permission_status('Invoice','retrieve_u')==true){
			$retrieve_inv=1;
		}
		if(check_permission_status('Invoice','update_u')==true){
			$update_inv=1;
		}
		
		$list = $this->Base_model->getdata_payment();
		// print_r($list);die;
 
	 $data = array();
	 $no = $_POST['start'];
	  $output = "";
	  $i =1;
	  foreach ($list as $item) {
		 
		//  $ino_id = $item['invoice_id'];
		//   $list_ino = $this->Base_model->get_data_invoices($ino_id);
		 // print_r($item);
 

		  
		 $encrypted_id 	= base64_encode($item['auto_id']);
		//  $encrypted_id 	= $item['auto_id'];
		//  print_r($encrypted_id);die;
		 $sessionEmail 	= base64_encode($this->session->userdata('company_email'));
		 $sessionCompany	= base64_encode($this->session->userdata('company_name'));
		 $row=[];
 
			  $row[].= $i++;
				$row[].=$item['paymentreceipt_date'];
				$row[] = "<span style='color: rgba(140, 80, 200, 1);font-weight: 700;'>{$item['paymentreceipt_no']}</span>";

				$row[].=$item['org_name'];
				$row[] = "<span style='color: rgba(140, 80, 200, 1);font-weight: 700;'>{$item['invoice_no']}</span>";
				$row[].=$item['currency'];
				$row[].=$item['TotalAmountReceived'];
				
				// $row[].=$item['invoice_date'];
				// $row[].=$item['owner']; 
			  
				
				$row[]="<a style='text-decoration:none'href='". base_url('view-paymentreceipt').'?inv_id='.urlencode($encrypted_id).'&cnp='.urlencode($sessionCompany). '&ceml='.urlencode($sessionEmail)."'  class='text-success border-right'><i class='far fa-eye sub-icn-opp m-1' data-toggle='tooltip' data-container='body' title='View Payment Receipt Details' ></i></a>
				<a style='text-decoration:none' href='" . base_url('add-debitnote/') . $item['invoice_id'] . "' class='text-primary border-right'> <i class='far fa-edit sub-icn-so m-1' data-toggle='tooltip' data-container='body' title='Update Payment Details' ></i></a>
				 
				<a style='text-decoration:none' href='javascript:void(0)'  onclick='delete_paymentreciept(" . $item['id'] . ")' class='text-danger'>
				<i class='far fa-trash-alt text-danger m-1'  data-toggle='tooltip' data-container='body' title='Delete Payment Receipt' ></i></a>
				</td> 
			  
			 </tr>";
			 
 
			$data[]=$row;
	  }
	  $i++;
	 
	  
	  $action = [
		 "draw" => $_POST['draw'],
		  "recordsTotal" => $this->Base_model->count_all_payment(),
		  "Totalamount" => $this->Base_model->count_Total_payment(),

		 	"recordsTotal" =>$this->Base_model->count_all_pay(),
			"recordsFiltered" => $this->Base_model->count_filtered_pay(),
 
		  "data" => $data, 
	  ];
	 echo json_encode($action);
 
	} 

	public function view_load_paymentreceipt() 
	{

	 if($this->session->userdata('email'))
	 {
		 if(checkModuleForContr('Generate Invoicing')<1){
			 redirect('home');
		   }
		 if(check_permission_status('Invoice','retrieve_u')==true){
	 
		 $id = base64_decode($_GET['inv_id']);
		 $decoded_ceml = base64_decode( $_GET['ceml']);
		 $decoded_cnp = base64_decode( $_GET['cnp']);
 
		//  if (isset($id)) {
		// 	 $data['inov_no']=$this->Base_model->get_ino_no($id);
		//  }

		$data['view_paymentreceipt']= $this->Base_model->get_paymentreceipt_by_id($id,$decoded_cnp,$decoded_ceml);

		// echo "<pre>";
		//  print_r($data['view_paymentreceipt']);die;
		$data['bank_details_terms'] = $this->Base_model->get_bank_detailss();
		
		if($data['view_paymentreceipt']['id']){
			$data['otherdata'] =array();

			$data['paymentmethod'] = $this->Base_model->paymentmethod_Data($data['view_paymentreceipt']['paymentreceipt_no']);
	

			$data['branch'] = $this->Base_model->debit_get_Branch_Data($data['view_paymentreceipt']['branch_id']);
			$data['clientDtl'] = $this->Base_model->debit_get_org_by_id($data['view_paymentreceipt']['cust_id']);
			$this->load->view('accounting/view_paymentreceipt' ,$data);
			
		}
			
		}else{
			redirect("permission");
		}
		}else{
			redirect('login');		
		}

 	}

	
	 public function paymentreciept_delete($id)
	 {
	  $delete=$this->Base_model->delete_paymentreciept_id($id);
	  if($delete){
		  echo json_encode(array("status" => TRUE));
	  }
  
  	}


	   /*****new generate pdf template*****/
	 public function generate_pdf_paymentreceipt()
	 {
		// print_r('testing');die;
	
		$id = base64_decode($_GET['inv_id']);
		$decoded_cnp = base64_decode( $_GET['cnp']);
		$decoded_ceml = base64_decode( $_GET['ceml']);
	
		   $row= $this->Base_model->get_paymentreceipt_by_id($id,$decoded_cnp,$decoded_ceml);
		   $inov_no=$this->Base_model->get_ino_no($id);
		  
		
		if($row['id']){

		   $rowOwner = $this->Base_model->get_Owner_debit($row['sess_eml']);
		   if(empty($rowOwner['standard_name'])){
			   $rowOwner = $this->Base_model->get_Admin_debit($row['sess_eml']);
			
		   }

		   $compnyDtail= $this->Base_model->get_Comp_debit($row['session_comp_email']);
		
		   $branch = $this->Base_model->getBranchData_debit($row['branch_id']); 
		  
		   $clientDtl = $this->Base_model->getorg_by_id_debit($row['cust_id']);
		   $Allpaymentmethod = $this->Base_model->paymentmethod_all($row['paymentreceipt_no']);
		   
		
		   $bank_details_terms = $this->Base_model->get_bank_detailss();
		//    print_r($Allpaymentmethod);die;
		 
		 $output = '<!DOCTYPE html>
				 <html>
				 <head>
				   <title>Team365 | Payment receipt</title>
				   <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
				   <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
				 <style>
					@page{
						 margin-top: 10px; /* create space for header */
					   }
					footer .pagenum:before {
						content: counter(page, decimal);
					   }
				   </style>
				 </head>
		   
				 <body style="font-family: Quicksand, sans-serif;">';
					 if($row['declaration_status'] == 1) {  
				   $output .= '<footer style="position: fixed;  bottom: 110;border-top:0.5px solid #333; " >';
					 }else{
						 
					 $output .= '<footer style="position: fixed;  bottom: 80;border-top:0.5px solid #333; " >';
					 }
				   
					$output .= ' <table style="font-size:11px; width:100%; text-align:center;">';
						 
						 
					   if($row['declaration_status'] == 1) {   
					   $output .= '<tr>
						   <td style="font-size:10px;">
						   <text><b>Declaration:-</b></text>
						   '.$row['invoice_declaration'].'
						   </td>
						 </tr>';
					   }
					   if($row['jurisdiction']!="") {  
					   $output .= ' <tr>
						   <td style="font-size:10px;"><b>"SUBJECT TO '.strtoupper($row['jurisdiction']).' JURISDICTION"</b></td>
						 </tr>';
					   }
					   if($row['late_charge']!="") {  
					   $output .= '  <tr>
						   <td style="font-size:10px;">INTEREST@ '.$row['late_charge'].'% P.A WILL BE CHARGED IF THE PAYMENT IS NOT MADE WITHIN THE STIPULATED TIME.</td>
						 </tr>';
					   }
					   $output .= '  <tr>
						   <td><div class="pagenum-container"style="text-align:right;font-size:10px; border-top:1px dashed #333; ">Page <span class="pagenum"></span></div></td>
						 </tr>
						 <tr>
						   <td><b>"This is system generated  Debit Note, Sign and stamp not required"</b></td>
						 </tr>
						 <tr>
						   <td><b><span style="font-size: 10px;">E-mail - '.$branch['branch_email'].'</br>
						| Ph. - +91-'.$branch['contact_number'].'</br>
						 | GSTIN: '.$branch['gstin'].'</br>
						  | CIN: '.$branch['cin'].'</span></b><br>
					   <b><span style="font-size:11px;">Powered By <a href="https://team365.io/">Team365 CRM</a></span></b> </td>
						 </tr>
					 </table>
					
				   
				   </footer>
				 
				 <main style="margin-bottom:10px;">
				 <table width="100%" style="max-width:800px; background:#fff;">
					<tbody>
					   <tr>
						  <td style="width:35%; vertical-align: top;">
						   <table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
						   <tr>
							   <td colspan="2"><text style="color: #6539c0;font-size:13px;"><b>Tax Payment Receipt</b></text></td>
						   </tr>
						   <tr style="line-height: 0.8;">
							   <td style="color: #615e5e;" > Payment Receipt No.</td><td>'.$row['paymentreceipt_no'].'</td> 
						   </tr>
						  
						   <tr style="line-height: 0.8;">
							   <td style="color: #615e5e;"> Payment Receipt Date.</td><td>'.date("d F Y", strtotime($row['paymentreceipt_date'])).'</td>
						   </tr>
						   <tr style="line-height: 0.8;">
							   <td style="color: #615e5e;">Terms</td><td>';
						   if($row['inv_terms'] == 'end_of_month') { 
							   $output .= 'Due end of month';
						   }else if($row['inv_terms'] == 'end_next_month'){
							   $output .= 'Due end of next month';
						   }else if($row['inv_terms'] == 'due_receipt'){
							   $output .= 'Due on reciept';
						   }else if($row['inv_terms'] == 'custom'){
							   $output .= 'Custom';
						   }else{
							   $output .= $row["inv_terms"];
						   }		
						   $output .= '</td>
						   </tr>
						   <tr style="line-height: 0.8;">
							   <td style="color: #615e5e;">Due Date</td><td>'.date("d F Y", strtotime($row['due_date'])).'</td>
						   </tr>
						   </table>
						  </td>
						  <td style="text-align:left; width:35%; padding-top:15px; vertical-align: top; ">
						  
						   <table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
						   <tr><td colspan="2"></td></tr>
						   <tr style="line-height: 0.8;">
							   <td style="color: #615e5e;">Supplier'."'".'s Ref:</td><td>'.$row['so_owner'].'</td>
						   </tr>
						   <tr style="line-height: 0.8;">
							   <td style="color: #615e5e;">Other Reference(s):</td><td>'.$row['owner'].'</td>
						   </tr>
						  
						   </table>
						  
						  </td>
						  <td style="text-align:right; width:30%;">';
						   $image = $compnyDtail['company_logo'];
							   if(!empty($image))
							   {
							   $output .=  '<img style="width: 70px;" src="./uploads/company_logo/'.$image.'">';
							   }
							   else
							   {
							   $output .=  '<span class="h5 text-primary">'.$compnyDtail['company_name'].'</span>';
							   }
							   $output .= '
						   </td>
					   </tr>
						</tbody>
					   </table>
						<table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
					   
						   <tr>
						   
						   <td style="width: 49.5%; padding: 2px 10px 4px 10px; vertical-align: top;">
							   <h5 style="margin-top: 0px;margin-bottom: 2px;color: #6539c0;">Payment receipt From</h5>
							   <p style="margin: 0;font-size: 12px;">'.$branch['company_name'].'</p>
							  ';
							 if($branch["address"]!=""){
							 $output .=' <p style="margin: 0;font-size: 11px;">'.$branch["address"];
							 }
							 if($branch["city"]!=""){
							 $output .=  ', '.$branch["city"];
							 }
							 if($branch["zipcode"]!=""){
							 $output .=  ' - '.$branch["zipcode"];
							 }
							 if($branch["state"]!=""){
							 $output .=  ', '.$branch["state"];
							 }
							 
							 if($branch["country"]!=""){
							 $output .=  ', '.$branch["country"];
							 }
							 $output .=  '</p>';
							 if($branch["gstin"]!=""){
							 $output .=  '<p style="margin: 0;font-size: 11px;"><b>GSTIN:</b> '.$branch["gstin"].'</p>';
							 }
							 if($branch["branch_email"]!="" && $branch["show_email"]== 1){
							  $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">'.$branch["branch_email"].'</p>';
							 }
							 if($branch["contact_number"]!=""){
							  $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">+91-'.$branch["contact_number"].'</p>';
							 }
							 $output .=  ' </td>
							  
							<td style="width: 1%;background:#fff;"></td>
							
							<td style="width: 49.5%; padding:0px 10px 4px 10px; vertical-align: top;">
							   <h5 style="margin-top: 0px;margin-bottom: 0px;color: #6539c0;"> Payment receipt To</h5>
							 <p style="margin: 0;font-size: 12px;">'.
							 $clientDtl->org_name.'</p>';
							 if(!empty($clientDtl->primary_contact)){
							 $output .= '<p style="margin: 0;font-size: 11px;">
							   <b>Contact Name :</b> '.$clientDtl->primary_contact.'</p>';
							  }
							  $output .= '
							 <p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">';
							 
							 if(!empty($clientDtl->shipping_address)){
							  $output .= $clientDtl->shipping_address;
							 }
							 if(!empty($clientDtl->shipping_city)){
							  $output .= ', '.$clientDtl->shipping_city;
							 }
							 if(!empty($clientDtl->shipping_zipcode)){
							  $output .= ' - '.$clientDtl->shipping_zipcode;
							 }
							 if(!empty($clientDtl->shipping_state)){
							  $output .= ', '.$clientDtl->shipping_state;
							 }
							 if(!empty($clientDtl->shipping_country)){
							  $output .= ', '.$clientDtl->shipping_country;
							 }
							  $output .= '</p>';
							  
							 if(!empty($clientDtl->gstin!="")){
							 $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>GSTIN:</b> '.$clientDtl->gstin.'</p>';
							 }
							   if(isset($clientDtl->email)){
							 $output .= '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>Email:</b>'.$clientDtl->email.' <br>
							 <b>Phone:</b> +91-'.$clientDtl->mobile.'</p>';
							   }
						  $output .= '</td>
							 
					   </tr>
				   </table>';

				
				   
				   $output .= ' <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-top:0px;">
				   <tbody>
					   <tr>
						   <th align="left" style="font-size:12px;width: 20.5%;"> Payment Method </th>
						  
						   <th align="left" style="font-size:12px;width: 20.5%;"> Amount Received </th>';
			  
								if (!empty($row['pi_invoice_no_select'])) {
									
									
									$output .= '<th align="left" style="font-size:12px;width: 20.5%;"> Txn Charge  </th>
											
												<th align="left" style="font-size:12px;width: 20.5%;"> TDS Charge </th>
												<th align="left" style="font-size:12px;width: 20.5%;"> Amount to Settle </th>';
								}
								$output .= '</tr>';
								
								$totalAmount = 0;
								$Transaction_charge = 0;
								$Tds_Withheld = 0;
								$row_sum_Total = 0;
								
								foreach ($Allpaymentmethod as $payment) {
									// Update total amounts
									$totalAmount += $payment['amount_received']; 
									if (!empty($row['pi_invoice_no_select'])) {
										// If $row['pi_invoice_no_select'] is available, update additional totals
										$Transaction_charge += $payment['transaction_charge']; 
										$Tds_Withheld += $payment['tds_Withheld']; 
										$row_sum = $payment['amount_received'] + $payment['transaction_charge'] + $payment['tds_Withheld']; 
										$row_sum_Total += $row_sum; 
									}
								
									$output .= '<tr>
										<td style="font-size:12px;">' . $payment['payment_method'] . '</td>
										
										<td style="font-size:12px;">' . $payment['amount_received'] . '</td>';
									// Add additional columns if $row['pi_invoice_no_select'] is available
									if (!empty($row['pi_invoice_no_select'])) {
										$output .= '<td style="font-size:12px;">' . $payment['transaction_charge'] . '</td>
													<td style="font-size:12px;">' . $payment['tds_Withheld'] . '</td>
													<td style="font-size:12px;">' . $row_sum . '</td>';
									}
									$output .= '</tr>';
								}
								
								$output .= '<tr>
									<th align="left" style="font-size:12px;width: 20.5%;"> Total </th>
									<td style="font-size:12px;">' . $totalAmount . '</td>';
								// Add totals for additional columns if $row['pi_invoice_no_select'] is available
								if (!empty($row['pi_invoice_no_select'])) {
									$output .= '<td style="font-size:12px;">' . $Transaction_charge . '</td>
												<td style="font-size:12px;">' . $Tds_Withheld . '</td>
												<td style="font-size:12px;">' . $row_sum_Total . '</td>';
								}
								$output .= '</tr> </br>';
								
								if (empty($row['pi_invoice_no_select'])) {
								$output .='<tr>
									<th align="left" style="font-size:12px;width: 20.5%;"> Invoices No. </th>
									<th align="left" style="font-size:12px;width: 20.5%;"> Invoices Amount  </th>
									<th align="left" style="font-size:12px;width: 20.5%;"> Invoices Received  </th>
									<th align="left" style="font-size:12px;width: 20.5%;"> Settled Amount  </th>
									<th align="left" style="font-size:12px;width: 20.5%;"> Due Amount </th><hr>'; 
			  
								
								$output .= '</tr>';
									// Update total amounts
									$totalAmount += $payment['amount_received']; 
									$settle_amountb = round($payment['pending_payment'] - $payment['sub_total'], 2);
                                    $settle_amountb_formatted = number_format($settle_amountb, 2);
									
								
									$output .= '<tr>
										<td style="font-size:12px;">' . $payment['invoice_no'] . '</td>
										<td style="font-size:12px;">' . $payment['sub_total'] . '</td>
										<td style="font-size:12px;">' . $payment['TotalAmountReceived'] . '</td>
										<td style="font-size:12px;">' . $payment['TotalAmountReceived'] . '</td>
										<td style="font-size:12px;">' . $settle_amountb_formatted. '</td>';
									// Add additional columns if $row['pi_invoice_no_select'] is available
									
									$output .= '</tr>';

								
								}
								
					$output .= '</tbody>
					</table>';

					if (!empty($row['pi_invoice_no_select'])) {

					$output .= '<hr><div class="bank-total">
						<table class="table">
								
							<tr>
								<td class="bank-total-right">
									Total In Words: <b>' . AmountInWords($row_sum_Total) . '</b>
								</td>
								<td class="bank-total-right">
								&nbsp;&nbsp;&nbsp;&nbsp;Total TDS Withheld: 	&nbsp;&nbsp; <b>₹' . IND_money_format($Tds_Withheld) . ' </b>
								</td>

								
							</tr>
							&nbsp;&nbsp;
							<tr>
							<td class="bank-total-right">
							&nbsp;&nbsp;
								</td>
								
								<td class="bank-total-right">
								&nbsp;&nbsp; &nbsp;&nbsp;Total Amount Received: &nbsp;&nbsp; 	&nbsp;&nbsp;&nbsp;&nbsp;<b>₹' . IND_money_format($totalAmount) . ' </b>
								</td>
							</tr>	&nbsp;&nbsp;
							<tr>  

							&nbsp;&nbsp;
							<tr>
							<td class="bank-total-right">
							&nbsp;&nbsp;
								</td>
								
								<td class="bank-total-right">
								&nbsp;&nbsp; &nbsp;&nbsp; Advance Received: &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<b>₹' . IND_money_format($row_sum_Total) . ' </b>
								</td>
							</tr>	&nbsp;&nbsp;
							<tr> 
							
							<td class="bank-total-right">
							&nbsp;&nbsp;
								</td>
							<td class="bank-total-right"><hr>
							&nbsp;&nbsp; &nbsp;&nbsp; Total (INR) Amount:	&nbsp;&nbsp; <b>₹' . IND_money_format($row_sum_Total) . ' </b>
								<hr></td>
							</tr>
						</table>';
					}
					$output .= '</div>';

					if (empty($row['pi_invoice_no_select'])) {
					$output .= '<hr><div class="bank-total">
						<table class="table">
								
							<tr>
								<td class="bank-total-right">
									Total In Words: <b>' . AmountInWords($payment['sub_total']) . '</b>
								</td>
								<td class="bank-total-right">
								&nbsp;&nbsp;&nbsp;&nbsp;Total Amount Received: &nbsp;&nbsp; <b>₹' . IND_money_format($payment['sub_total']) . ' </b>
								</td>

								
							</tr>
							&nbsp;&nbsp;
							<tr>
							<td class="bank-total-right">
							&nbsp;&nbsp;
								</td>
								
								<td class="bank-total-right">
								&nbsp;&nbsp; &nbsp;&nbsp;Settled Against Invoices: &nbsp;&nbsp; 	&nbsp;&nbsp;&nbsp;&nbsp;<b>₹' . IND_money_format($settle_amountb_formatted) . ' </b>
								</td>
							</tr>	&nbsp;&nbsp;
							<tr>
							
							<td class="bank-total-right">
							&nbsp;&nbsp;
								</td>
							<td class="bank-total-right"><hr>
							&nbsp;&nbsp; &nbsp;&nbsp; Total (INR) Amount:	&nbsp;&nbsp; <b>₹' . IND_money_format($settle_amountb_formatted) . ' </b>
								<hr></td>
							</tr>
						</table>';
					}
					$output .= '</div>


		   
				   <table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; margin-top:10px; border-radius: 7px; background: #efebf9;">
					  <thead style="color: #fff;" align="left">';
					  
						   $igsttotal=0;
						   $sgsttotal=0;
						   $cgsttotal=0;
						   
						   $igst = explode("<br>",$row['igst']);
						   $sgst = explode("<br>",$row['sgst']);
						   $cgst = explode("<br>",$row['cgst']);
						   $proDiscount = explode("<br>",$row['pro_discount']);
						   $totalDiscount=array_sum($proDiscount);
					  
							$output .= '<tr>
								<th width="3%" style="font-size: 11px;">
								<div style="background: #6539c0;border-top-left-radius: 7px;  padding: 6px;">
								S.No.</div></th>
								<th width="18%" style="font-size: 11px; background: #6539c0;">
								Product/Services</th>
								<th style="font-size: 11px; background: #6539c0;">HSN/SAC</th>
								
								<th style="font-size: 11px; background: #6539c0;">Qty</th>
								<th style="font-size: 11px; background: #6539c0;">Tax</th>
								<th style="font-size: 11px; background: #6539c0;">Rate</th>';
								if($totalDiscount>0){
								$output .= '<th style="font-size: 11px; background: #6539c0;">Discount</th>';
								}
								$output .= '<th style="font-size: 11px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 6px;">Tot. Price</div></th>
								</tr>
					  </thead>
					  <tbody >';
					  
						   $product_name = explode("<br>",$row['product_name']);
						   $quantity = explode("<br>",$row['quantity']);
						   $unit_price = explode("<br>",$row['unit_price']);
						   $total = explode("<br>",$row['total']);
						   $total_withgst = explode("<br>",$row['sub_total_with_gst']);
						   $hsnsac = explode("<br>",$row['hsn_sac']);
						   $after_discount = ($row['initial_total']-$row['total_discount']);
						   if(!empty($row['gst'])){
							 $gst = explode("<br>",$row['gst']);
						   }
						   $proDesc = explode("<br>",$row['pro_description']);
						   
						   
						   $arrlength = count($product_name);
						   $rw=0;
						   $sr=1;
						   for($x = 0; $x < $arrlength; $x++){
							   $rw++;
							   $num = $x + 1;
							   
							   if(isset($igst[$x]) && $igst[$x]!=""){
								   $igsttotal=$igsttotal+$igst[$x];
							   }
							   if(isset($sgst[$x]) && $sgst[$x]!=""){
								   $sgsttotal=$sgsttotal+$sgst[$x];
							   }
							   if(isset($igst[$x]) && $cgst[$x]!=""){
								   $cgsttotal=$cgsttotal+$cgst[$x];
							   }
				   
							   
							   $output .='<tr>
								   <td style="font-size: 11px;padding: 5px 10px;">'.$sr.'</td>
								   <td style="font-size: 11px;padding: 5px 10px;">'.$product_name[$x].'</td>
								   
								   <td style="font-size: 11px;padding: 5px 10px;">'.$hsnsac[$x].'</td>
								   
								   <td style="font-size: 11px;padding: 5px 10px;">'.$quantity[$x].'</td>
								   <td style="font-size: 11px;padding: 5px 10px;">GST@'.$gst[$x].'%</td>
								   <td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($unit_price[$x]).'</td>';
								   if($totalDiscount>0){
								   $output .='<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($proDiscount[$x]).'</td>';
								   }
								   $output .='<td style="font-size: 11px;padding: 5px 10px; "><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($total[$x]).'</td>
							   </tr>';
							   if(isset($proDesc[$x]) && $proDesc[$x]!=""){	
							   $output.='<tr>
									   <td style="font-size: 11px; padding:5px 10px;"></td>
									   <td colspan="6" style="font-size: 11px; padding:5px 10px;">'.$proDesc[$x].'</td></tr>';
							   }
						   $sr++;
						   }
						   
						   $output .='
					 </tbody>
				   </table>
		   
				   <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
					 <tbody>
					   <tr>
					   <td align="left" width="60%" style="position: relative;">
						 <p style="font-size:12px; margin-top:0px; margin-bottom:8px;"><b style="font-size:12px;">Total in words:</b> <text style="font-size:11px;"> '.AmountInWords($row["sub_total"]).' only</text></p>';
						  if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){
				  
						   $output .='<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a;font-size:11px;">
								  <tr>
								   <td colspan="3">
									   <h5 style="margin: 0px 0px 0px 8px; color: #6539c0; font-size:12px;">Bank Details</h5>
								   </td>
								  </tr>
								  <tr style="line-height: 0.8;">
									  <th style="text-align:left; padding-left:10px;">Account Holder Name:  <th>
									  <td>'.ucfirst($bank_details_terms->acc_holder_name).'</td>
								  </tr>
								  <tr style="line-height: 0.8;">
									  <th style="text-align:left; padding-left:10px;">  Account Number:  <th>
									  <td>'.$bank_details_terms->account_no.'</td>
								  </tr>
								  <tr style="line-height: 0.8;">
									  <th style="text-align:left; padding-left:10px;">  IFSC:  <th>
									  <td>'.$bank_details_terms->ifsc_code.'</td>
								  </tr>
								  <tr style="line-height: 0.8;">
									  <th style="text-align:left; padding-left:10px;"> Account Type:  <th>
									  <td>'.ucfirst($bank_details_terms->account_type).'</td>
								  </tr>
								  <tr style="line-height: 0.8;">
									  <th style="text-align:left; padding-left:10px;"> Bank Name: <th>
									  <td>'.ucfirst($bank_details_terms->bank_name).'</td>
								  </tr><tr style="line-height: 0.8;">';
								 
								   if($bank_details_terms->upi_id!=""){
								   $output .= '<th style="text-align:left;  padding-left:10px;">UPI Id:<th>
									  <td>'.$bank_details_terms->upi_id.'</td>';
								   }
								   if(isset($_GET['dn']) && $_GET['dn']==1){
									 $output .= '<th style="text-align:left;padding-left:10px;"><a href="'.base_url("home").'" style="text-decoration:none; background:#6539c0; color:#fff; font-size:10px; padding:4px; display:inline-block; border-radius:3px;">Pay Now</a></th>';
								   }
								   
									$output .= '</tr>
								</table>';
					  
					  }  
					  
						$output .='</td>
					   <td align="" width="40%" style="text-align:right;">
						 <table align="" width="100%" style="text-align:right;position: absolute;top: 0px;">
						   <tbody>
							 <tr>
							   <th style="font-size: 12px;" align="left">Initial Amount</th>
		   
							   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["initial_total"]).'</td>
							 </tr>';
							 if($row["discount"]>0){
							 $output .='<tr>
							   <th style="font-size: 12px;" align="left">Discount</th>
		   
							   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$row["discount"].'</td>
							 </tr>';
							 
							 $output .='<tr>
							   <th style="font-size: 12px;" align="left">After Discount</th>
		   
							   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($after_discount).'</td>
							 </tr>';
							 }
							 if($igsttotal!=0){	
							   $output .='<tr><th style="font-size: 12px;" align="left">IGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($igsttotal).'</td></tr>';
							 }else{
							   
								   if($sgsttotal!=0){	
									   $output .='<tr><th style="font-size: 12px;" align="left">SGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($sgsttotal).'</td></tr>';
								   }
								   if($cgsttotal!=0){	
									   $output .='<tr><th style="font-size: 12px;" align="left">CGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($cgsttotal).'</td></tr>';
								   }
							   }
							   if($row['extra_charge_label']!=""){
								$extraCharge_name=explode("<br>",$row['extra_charge_label']);
								$extraCharge_value=explode("<br>",$row['extra_charge_value']);
							   for($y=0; $y<count($extraCharge_name); $y++){	
								   $output .='<tr><th style="font-size: 12px;" align="left">'.$extraCharge_name[$y].'</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($extraCharge_value[$y]).'</td></tr>';
							   }
							   }
									   
							 $output .='
							 <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
							 <tr>
							 
							   <th style="font-size: 12px;" align="left">TOTAL</th>
		   
							   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["sub_total"]).'</td>
							 </tr>
						   </tbody>
						   
						 </table>
					   </td>
					 </tr>
					 </tbody>
				   </table>';
		   
				   $output .='<table width="100%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-bottom:30px margin-top:';
					   if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){ 
						   $output .='0px;">';
						   
					   }else{ 
						   $output .='-20px;">'; 
						   
					   }
					   $output .='<tbody>
					   <tr>
					 <td align="left" style="width:60%; padding:1px;">
					   <h5 style="color: #6539c0;margin: 0px;">Terms and conditions</h5>
					   <ol style="padding: 0 8px; font-size:11px; margin: 1px;">';
						$custTerm=explode("<br>",$row["terms_condition"]); $no=1;
						for($i=0; $i<count($custTerm); $i++){ 
						  $output .='<li>'.$custTerm[$i].'</li>'; 
						}
						 //'.nl2br($row->terms_condition).'
					   $output .='</ol>
					 </td>';
					 
					 $output .='<td style="text-align:center;">';
						   $image = $row['signature_img'];
						   if(!empty($image)){
						   $output .=  '<img style="width: 90px;" src="./assets/pi_images/'.$image.'">	';
						   }else{
							   //$output .= '<text style="color: #615e5e; font-size:11px;">For '.$this->session->userdata('company_name').' (signature)</text>';
						   }
					 $output .= '</td>';
							   $output .= '</tr>
							   
					   
					 </tbody>
				   </table>';
				   
					
		   
				 $output .='</main>
		   
				 </body>
				 </html>';
		 //return $output;
		 
		   }
		//    echo $output; exit;
		//    print_r($output); die;
		 $this->load->library('pdf');
		 $this->dompdf->loadHtml($output);
		 ini_set('memory_limit', '128M');
		 $this->dompdf->render();
		 $canvas = $this->dompdf->getCanvas();
		 $pdf = $canvas->get_cpdf();
   
		 foreach ($pdf->objects as &$o) {
		   if ($o['t'] === 'contents') {
			   $o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
		   }
		 }
		 
		 if(isset($_GET['dn']) && $_GET['dn']==1){
		   $this->dompdf->stream("Paymentreceipt".$id.".pdf", array("Attachment"=>1));  
		 }else{
		   $this->dompdf->stream("paymentreceipt".$id.".pdf", array("Attachment"=>0));  
		 }
		 
		 
	 }
	
	

// < -------------------------------------------------------- Payment reciept end ----------------------------------------------- >

   public function newdashboard()
   {
	   $this->load->view('users/newdashboard');
   }



// <--------------------------------------------- Start Credit Note ------------------------------------------------------------->
   
public function get_creditnote_graph(){ 
	$data['grouped_data'] = $this->Base_model->getcreditnotegraph();
	$response = [
		'status' => 'success',
		'data' => $data['grouped_data']  // Corrected variable name
	];
	$this->output->set_content_type('application/json')->set_output(json_encode($response));
}

public function creditnote()
   {  
		$data['user'] = $this->Login_model->getusername();
		$data['admin'] = $this->Login_model->getadminname();
	  	 $this->load->view('accounting/creditnote', $data);
   }


public function add_creditnote()
{
    // Check if it's an AJAX request
    if ($this->input->is_ajax_request()) {
        $id = $this->input->post('invoicenum');
        
        $cond = ['invoice_no' => $id];
        $invoice_data = $this->Invoice_model->getinvoicedata($cond)->result_array();

        if (!empty($invoice_data)) {
            // If invoice found, return success response with invoice ID
            $response = array(
                'success' => true,
                'invoice_id' => $invoice_data[0]['id']
            );
            echo json_encode($response);
        } else {
            // If invoice not found, return error response
            $response = array(
                'success' => false,
                'message' => 'Invoice not found'
            );
            echo json_encode($response);
        }
    } else {
        // If it's not an AJAX request, handle accordingly (optional)
        echo "Invalid request";
    }
}



   public function loadcreditnote_view()
   	{
		if($this->session->userdata('email'))
		{
			if(checkModuleForContr('Generate Invoicing')<1){
				redirect('home');
				exit;
			} 

			if(check_permission_status('Invoice','create_u')==true){
				$data['branch_details'] 	= $this->Invoice_model->get_branch();
				$data['customer_details']   = $this->Invoice_model->get_organization_bytype(); 
				$data['invoice_terms'] 		= $this->Invoice_model->getall_terms();
				$data['declaration'] 		= $this->Invoice_model->get_declaration();
				$id=$this->uri->segment(2);
				
				
				if(isset($_GET['so']) && $_GET['so']!=""){
					$data['record'] = $this->Salesorders->get_data_for_update($_GET['so']);
				
					$data['action']=array('data'=>'add','from'=>'quotation');
					
				}else if(isset($id) && $id!=""){
					$data['record'] = $this->Invoice_model->get_data_for_update($id);
					$iscreditnote_exists=$this->Base_model->creditnote_exists($id);

					if($iscreditnote_exists['delete_status']==1){
							
						$creditnote_no = $this->Base_model->creditnote_no($id);
						$data['creditnotenum'] = $creditnote_no->creditnote_no;
						$data['action']=array('data'=>'update','from'=>'salesorder');
									
					}else{

						$creditnoteid=$data['creditnoteid']=$this->Base_model->getlast_id('MAX(id) as lastid','creditnote')->row_array();
						
							if(isset($creditnoteid['lastid'])){
							$lastcreditnote = $creditnoteid['lastid']+1;
						
							}else{
							$lastcreditnote = 1;
						}
						$data['creditnotenum']=generateserialnum($lastcreditnote,'creditnote','creditnote_no');
						// print_r ($data['creditnotenum']);die;
					}



				}else{
				
					$data['action']=array('data'=>'add','from'=>'direct');
				}
				
				$data['gstPer']     = $this->Salesorders->get_gst();
			
			
				
				$this->load->view('accounting/add-creditnote',$data);
				
			}else{
				redirect("permission");
			}			
		
		}else{
			redirect('login');
			}
      
   	}

    
   public function add_creditnoteDetails() 
   {
	
	// $validation = $this->check_validation();
    if(1==200){
      echo $validation;die;
	  
    }else{
		
		if($this->input->post('igst')!=""){
			$igst=implode("<br>", $this->input->post('igst'));
		}else{ $igst=''; }
		if($this->input->post('cgst')!=""){
			$cgst=implode("<br>", $this->input->post('cgst'));
		}else{ 	$cgst=''; }
		if($this->input->post('sgst')!=""){
			$sgst=implode("<br>", $this->input->post('sgst'));
		}else{ $sgst=''; }
		
		if($this->input->post('discount_price')!=""){
			$discount_price=implode("<br>", $this->input->post('discount_price'));
		}else{ $discount_price=''; }
		
		if($this->input->post('terms_condition')){
			$terms_condition=implode("<br>",$this->input->post('terms_condition'));
		}else{ $terms_condition=''; }
		if($this->input->post('extra_charge')!=""){
			$extra_charge=implode("<br>", $this->input->post('extra_charge'));
		}else{ $extra_charge=''; }
		if($this->input->post('extra_chargevalue')!=""){
			$extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
		}else{ $extra_chargevalue=''; }	
		if($this->input->post('label')){
			$lable=implode("<br>",$this->input->post('label'));
	    }else{ $lable='';}
	    if($this->input->post('label_value')){
			$label_value=implode("<br>",$this->input->post('label_value'));
	    }else{ $label_value='';}
	    if($this->input->post('product_desc')){
			$product_desc=implode("<br>",$this->input->post('product_desc'));
	    }else{ $product_desc=''; }
	   
	   if($this->input->post('sub_total_with_gst')){
			$sub_totalwithgst=implode("<br>",$this->input->post('sub_total_with_gst'));
	    }else{ $sub_totalwithgst=''; }
	   
	   
      $unit_price 		= str_replace(",", "",$this->input->post('unit_price'));
      $total 			= str_replace(",", "",$this->input->post('total'));
	  $after_discount 	= str_replace(",", "",$this->input->post('after_discount'));
	  $initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
	  $total_discount 	= str_replace(",", "",$this->input->post('discount'));
	  $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
	  
	    $advanced_payment = str_replace(",", "",$this->input->post('advance_payment'));
		if($advanced_payment==""){
			$advanced_payment=0;
		}
		$pendingPayment=$sub_total-$advanced_payment;
		
	  $org_name = $this->input->post('customer_name');
	  $org_id = $this->input->post('customer_id');
       
	  
      $creditnotedata = array(
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'saleorder_id' 		=> $this->input->post('saleorder_id'),
        'so_owner' 			=> $this->input->post('supplier'),
        'owner' 			=> $this->input->post('owner'),
		'creditnote_no'     => $this->input->post('creditnote_no'),
		'creditnote_date'   => $this->input->post('creditnote_date'),
        'cust_order_no'		=> $this->input->post('order_no'),
        'invoice_date' 		=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
        'due_date' 			=> date('Y-m-d',strtotime($this->input->post('invoice_dueDate'))),
		'inv_terms' 		=> $this->input->post('terms_select'),
        'extra_field_label' => $lable,
		'extra_field_value' => $label_value,
        'org_name' 	    	=> $org_name,
        'cust_id' 	    	=> $org_id,
        'invoice_declaration'=> $this->input->post('invoice_declaration'),
        'branch_id'   		=> $this->input->post('shipto'),
		//'discount_type' 	=> $this->input->post('sel_disc'),
		//'discount' 	    => $this->input->post('discount'),
		'notes' 			=> $this->input->post('notes'),
		//'attachment' 		=> $attachment,
		//'signature_img' 	=> $signature_img,
		'pro_description' 	=> $product_desc,		
		'enquiry_email' 	=> $this->input->post('enquiry_email'),
		'enquiry_mobile' 	=> $this->input->post('enquiry_mobile'),
		'jurisdiction' 		=> $this->input->post('jurisdiction'),
		'late_charge' 		=> $this->input->post('late_charge'),
        'product_name' 		=> implode("<br>",$this->input->post('product_name')),
        'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
		'gst' 				=> implode("<br>",$this->input->post('gst')),
		'quantity' 			=> implode("<br>",$this->input->post('quantity')),
        'unit_price' 		=> implode("<br>",$unit_price),
        'pro_discount' 		=> $discount_price,
        'total' 			=> implode("<br>",$total),
		'sgst' 				=> $sgst,
		'igst' 				=> $igst,
		'cgst' 				=> $cgst,
		'type' 				=> $this->input->post('type'),
		'sub_total_with_gst'=> $sub_totalwithgst,
		'extra_charge_label'=> $extra_charge,
		'extra_charge_value'=> $extra_chargevalue,
		'terms_condition' 	=> $terms_condition,
        'total_discount' 	=> $total_discount,
        'initial_total' 	=> $initial_total,        
        'sub_total' 		=> $sub_total,
		'total_igst' 		=> str_replace(",", "",$this->input->post('total_igst')),
        'total_cgst' 		=> str_replace(",", "",$this->input->post('total_cgst')),
        'total_sgst' 		=> str_replace(",", "",$this->input->post('total_sgst')),
		'advanced_payment' 	=> $advanced_payment,
        'pending_payment' 	=> $pendingPayment,
		'invoice_id'     => $this->input->post('invc_id')	        

      );
	
        $insertdata=$this->Base_model->insertdata('creditnote',$creditnotedata);
		$response=array();
		if($insertdata == 1){
            $response['success'] = true;
            $response['message'] = "Data inserted successfully";
		}
        echo json_encode($response);
      
	}
   }


   public function update_creditnoteDetails()
   {
	// $validation = $this->check_validation();
    if(1==200){
		 echo $validation;die;
	  
    	}else{
		
		if($this->input->post('igst')!=""){
			$igst=implode("<br>", $this->input->post('igst'));
		}else{ $igst=''; }
		if($this->input->post('cgst')!=""){
			$cgst=implode("<br>", $this->input->post('cgst'));
		}else{ 	$cgst=''; }
		if($this->input->post('sgst')!=""){
			$sgst=implode("<br>", $this->input->post('sgst'));
		}else{ $sgst=''; }
		
		if($this->input->post('discount_price')!=""){
			$discount_price=implode("<br>", $this->input->post('discount_price'));
		}else{ $discount_price=''; }
		
		if($this->input->post('terms_condition')){
			$terms_condition=implode("<br>",$this->input->post('terms_condition'));
		}else{ $terms_condition=''; }
		if($this->input->post('extra_charge')!=""){
			$extra_charge=implode("<br>", $this->input->post('extra_charge'));
		}else{ $extra_charge=''; }
		if($this->input->post('extra_chargevalue')!=""){
			$extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
		}else{ $extra_chargevalue=''; }	
		if($this->input->post('label')){
			$lable=implode("<br>",$this->input->post('label'));
	    }else{ $lable='';}
	    if($this->input->post('label_value')){
			$label_value=implode("<br>",$this->input->post('label_value'));
	    }else{ $label_value='';}
	    if($this->input->post('product_desc')){
			$product_desc=implode("<br>",$this->input->post('product_desc'));
	    }else{ $product_desc=''; }
	   
	   if($this->input->post('sub_total_with_gst')){
			$sub_totalwithgst=implode("<br>",$this->input->post('sub_total_with_gst'));
	    }else{ $sub_totalwithgst=''; }
	   
	   
      $unit_price 		= str_replace(",", "",$this->input->post('unit_price'));
      $total 			= str_replace(",", "",$this->input->post('total'));
	  $after_discount 	= str_replace(",", "",$this->input->post('after_discount'));
	  $initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
	  $total_discount 	= str_replace(",", "",$this->input->post('discount'));
	  $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
	  
	    $advanced_payment = str_replace(",", "",$this->input->post('advance_payment'));
		if($advanced_payment==""){
			$advanced_payment=0;
		}
		$pendingPayment=$sub_total-$advanced_payment;
		
	  $org_name = $this->input->post('customer_name');
	  $org_id = $this->input->post('customer_id');
	  $invoice_update_id = $this->input->post('id');
       
	  
      $creditnotedata = array(
		'invoice_id'        => $invoice_update_id,
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'saleorder_id' 		=> $this->input->post('saleorder_id'),
        'so_owner' 			=> $this->input->post('supplier'),
        'owner' 			=> $this->input->post('owner'),
		'creditnote_no'     => $this->input->post('creditnote_no'),
		'creditnote_date'   => $this->input->post('creditnote_date'),
        'cust_order_no'		=> $this->input->post('order_no'),
        'invoice_date' 		=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
        'due_date' 			=> date('Y-m-d',strtotime($this->input->post('invoice_dueDate'))),
		'inv_terms' 		=> $this->input->post('terms_select'),
        'extra_field_label' => $lable,
		'extra_field_value' => $label_value,
        'org_name' 	    	=> $org_name,
        'cust_id' 	    	=> $org_id,
        'invoice_declaration'=> $this->input->post('invoice_declaration'),
        'branch_id'   		=> $this->input->post('shipto'),
		//'discount_type' 	=> $this->input->post('sel_disc'),
		//'discount' 	    => $this->input->post('discount'),
		'notes' 			=> $this->input->post('notes'),
		//'attachment' 		=> $attachment,
		//'signature_img' 	=> $signature_img,
		'pro_description' 	=> $product_desc,		
		'enquiry_email' 	=> $this->input->post('enquiry_email'),
		'enquiry_mobile' 	=> $this->input->post('enquiry_mobile'),
		'jurisdiction' 		=> $this->input->post('jurisdiction'),
		'late_charge' 		=> $this->input->post('late_charge'),
        'product_name' 		=> implode("<br>",$this->input->post('product_name')),
        'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
		'gst' 				=> implode("<br>",$this->input->post('gst')),
		'quantity' 			=> implode("<br>",$this->input->post('quantity')),
        'unit_price' 		=> implode("<br>",$unit_price),
        'pro_discount' 		=> $discount_price,
        'total' 			=> implode("<br>",$total),
		'sgst' 				=> $sgst,
		'igst' 				=> $igst,
		'cgst' 				=> $cgst,
		'type' 				=> $this->input->post('type'),
		'sub_total_with_gst'=> $sub_totalwithgst,
		'extra_charge_label'=> $extra_charge,
		'extra_charge_value'=> $extra_chargevalue,
		'terms_condition' 	=> $terms_condition,
        'total_discount' 	=> $total_discount,
        'initial_total' 	=> $initial_total,        
        'sub_total' 		=> $sub_total,
		'total_igst' 		=> str_replace(",", "",$this->input->post('total_igst')),
        'total_cgst' 		=> str_replace(",", "",$this->input->post('total_cgst')),
        'total_sgst' 		=> str_replace(",", "",$this->input->post('total_sgst')),
		'advanced_payment' 	=> $advanced_payment,
        'pending_payment' 	=> $pendingPayment	        

      );
	// print_r($creditnotedata);die;

        $invoice_id=$this->Base_model->creditnote_exists($invoice_update_id);
		// print_r($invoice_id);die;
		if($invoice_id === $invoice_update_id){
			$response=array();
				$response['success'] = false;
				$response['message'] = "Data already exit";
			
				echo json_encode($response);
		}else{
			// print_r($invoice_update_id);die;
			$updatedata=$this->Base_model->update_credit_note($invoice_update_id ,$creditnotedata);
			$response=array();
			if($updatedata == 1){
				$response['success'] = true;
				$response['message'] = "Data update successfully";
			}
			echo json_encode($response);
		}
      
	}
   }


   public function getcreditnotedata()
   {

	
	$delete_inv	=0;
	$update_inv	=0;
	$retrieve_inv=0; 
	if(check_permission_status('Invoice','delete_u')==true){
		$delete_inv=1;
	}
	if(check_permission_status('Invoice','retrieve_u')==true){
		$retrieve_inv=1;
	}
	if(check_permission_status('Invoice','update_u')==true){
		$update_inv=1;
	}
	  
    $list = $this->Base_model->getdata_credit();

	$data = array();
    $no = $_POST['start'];
	 $output = "";
	 $i =1;
	 foreach ($list as $item) {
		
		$ino_id = $item['invoice_id'];
		 $list_ino = $this->Base_model->get_data_invoices($ino_id);
		// print_r($item);

		$row=[];
		 
		$encrypted_id 	= base64_encode($item['invoice_id']);
		$sessionEmail 	= base64_encode($this->session->userdata('company_email'));
		$sessionCompany	= base64_encode($this->session->userdata('company_name'));

			 $row[].= $i++;
			   $row[].=$item['creditnote_date'];
				$row[] = "<span style='color: rgba(140, 80, 200, 1);font-weight: 700;'>{$item['creditnote_no']}</span>";
			   $row[].=$item['sub_total'];
			  
				$row[] = "<span style='color: rgba(140, 80, 200, 1);font-weight: 700;'>{$list_ino['invoice_no']}</span>";

			   $row[].=$list_ino['sub_total'];
			   $row[].=$list_ino['org_name']; 
			   $row[].=$list_ino['invoice_date'];
			   $row[].=$item['owner']; 
			 
			   
			   $row[]="<a style='text-decoration:none'href='". base_url('view-creditnote').'?inv_id='.urlencode($encrypted_id).'&cnp='.urlencode($sessionCompany). '&ceml='.urlencode($sessionEmail)."'  class='text-success border-right'><i class='far fa-eye sub-icn-opp m-1' data-toggle='tooltip' data-container='body' title='View Credit Note Details' ></i></a> 

			    <a style='text-decoration:none' href='" . base_url('add-creditnote/') . $item['invoice_id'] . "' class='text-primary border-right'> <i class='far fa-edit sub-icn-so m-1' data-toggle='tooltip' data-container='body' title='Update Credit Note Details' ></i></a>
				

			   <a style='text-decoration:none' href='javascript:void(0)'  onclick='delete_creditnote(" . $item['invoice_id'] . ")' class='text-danger'>
			   <i class='far fa-trash-alt text-danger m-1'  data-toggle='tooltip' data-container='body' title='Delete Credit Note' ></i></a></td> 
			 
			</tr>";
			

           $data[]=$row;
	 }
	 $i++;
	
	 
	 $action = [
		"draw" => $_POST['draw'],
		 "recordsTotal_cc" => $this->Base_model->count_all(),
		 "recordsFiltered_cc" => $this->Base_model->count_Total(),
		 "recordsTotal" =>$this->Base_model->count_all_c(),
		 "recordsFiltered" => $this->Base_model->count_filtered_c(),
		 "data" => $data, // Store the HTML table rows directly, no need for an array
	 ];

	//  print_r($action);die;
	echo json_encode($action);

   } 

   public function view_load_creditnote() 
   	{



		if($this->session->userdata('email'))
		{
			if(checkModuleForContr('Generate Invoicing')<1){
				redirect('home');
			  }
			if(check_permission_status('Invoice','retrieve_u')==true){
		
			$id = base64_decode($_GET['inv_id']);
			$decoded_ceml = base64_decode( $_GET['ceml']);
			$decoded_cnp = base64_decode( $_GET['cnp']);

			// print_r($decoded_cnp);die;
	
		if (isset($id)) {
			$data['inov_no']=$this->Base_model->get_ino_no($id);
		}

		$data['view_creditnote']= $this->Base_model->get_creditnote_by_id($id,$decoded_cnp,$decoded_ceml);
		// print_r($data['view_creditnote']);die;
		$data['bank_details_terms'] = $this->Base_model->get_bank_detailss();
		
		if($data['view_creditnote']['id']){
			$data['otherdata'] =array();
			$data['branch'] = $this->Base_model->debit_get_Branch_Data($data['view_creditnote']['branch_id']);
			$data['clientDtl'] = $this->Base_model->debit_get_org_by_id($data['view_creditnote']['cust_id']);
			$this->load->view('accounting/view_creditnote' ,$data);
			
		}
			
		}else{
			redirect("permission");
		}
		}else{
			redirect('login');		
		}

	}

   public function creditnote_delete($id)
   	{
		$delete=$this->Base_model->delete_creditnote_id($id);
		if($delete){
			echo json_encode(array("status" => TRUE));
		}
	
	}

	public function generate_pdf_credit()
		 {
			// print_r('testing');die;
		
			$id = base64_decode($_GET['inv_id']);
			$decoded_cnp = base64_decode( $_GET['cnp']);
			$decoded_ceml = base64_decode( $_GET['ceml']);
		
			   $row= $this->Base_model->get_creditnote_by_id($id,$decoded_cnp,$decoded_ceml);
			   $inov_no=$this->Base_model->get_ino_no($id);
			  
			
			if($row['id']){

			   $rowOwner = $this->Base_model->get_Owner_debit($row['sess_eml']);
			   if(empty($rowOwner['standard_name'])){
				   $rowOwner = $this->Base_model->get_Admin_debit($row['sess_eml']);
				
			   }

			   $compnyDtail= $this->Base_model->get_Comp_debit($row['session_comp_email']);
			
			   $branch = $this->Base_model->getBranchData_debit($row['branch_id']); 
			  
			   $clientDtl = $this->Base_model->getorg_by_id_debit($row['cust_id']);
			
			   $bank_details_terms = $this->Base_model->get_bank_detailss();
				//    print_r($bank_details_terms);die;
			 
			 $output = '<!DOCTYPE html>
					 <html>
					 <head>
					   <title>Team365 | Debit Note</title>
					   <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
					   <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
					 <style>
						@page{
							 margin-top: 10px; /* create space for header */
						   }
						footer .pagenum:before {
							content: counter(page, decimal);
						   }
					   </style>
					 </head>
			   
					 <body style="font-family: Quicksand, sans-serif;">';
						 if($row['declaration_status'] == 1) {  
					   $output .= '<footer style="position: fixed;  bottom: 110;border-top:0.5px solid #333; " >';
						 }else{
							 
						 $output .= '<footer style="position: fixed;  bottom: 80;border-top:0.5px solid #333; " >';
						 }
					   
						$output .= ' <table style="font-size:11px; width:100%; text-align:center;">';
							 
							 
						   if($row['declaration_status'] == 1) {   
						   $output .= '<tr>
							   <td style="font-size:10px;">
							   <text><b>Declaration:-</b></text>
							   '.$row['invoice_declaration'].'
							   </td>
							 </tr>';
						   }
						   if($row['jurisdiction']!="") {  
						   $output .= ' <tr>
							   <td style="font-size:10px;"><b>"SUBJECT TO '.strtoupper($row['jurisdiction']).' JURISDICTION"</b></td>
							 </tr>';
						   }
						   if($row['late_charge']!="") {  
						   $output .= '  <tr>
							   <td style="font-size:10px;">INTEREST@ '.$row['late_charge'].'% P.A WILL BE CHARGED IF THE PAYMENT IS NOT MADE WITHIN THE STIPULATED TIME.</td>
							 </tr>';
						   }
						   $output .= '  <tr>
							   <td><div class="pagenum-container"style="text-align:right;font-size:10px; border-top:1px dashed #333; ">Page <span class="pagenum"></span></div></td>
							 </tr>
							 <tr>
							   <td><b>"This is system generated  Debit Note, Sign and stamp not required"</b></td>
							 </tr>
							 <tr>
							   <td><b><span style="font-size: 10px;">E-mail - '.$branch['branch_email'].'</br>
							| Ph. - +91-'.$branch['contact_number'].'</br>
							 | GSTIN: '.$branch['gstin'].'</br>
							  | CIN: '.$branch['cin'].'</span></b><br>
						   <b><span style="font-size:11px;">Powered By <a href="https://team365.io/">Team365 CRM</a></span></b> </td>
							 </tr>
						 </table>
						
					   
					   </footer>
					 
					 <main style="margin-bottom:10px;">
					 <table width="100%" style="max-width:800px; background:#fff;">
						<tbody>
						   <tr>
							  <td style="width:35%; vertical-align: top;">
							   <table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
							   <tr>
								   <td colspan="2"><text style="color: #6539c0;font-size:13px;"><b>Tax  Credit Note</b></text></td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;" > Credit Note No.</td><td>'.$row['creditnote_no'].'</td> 
							   </tr>
							   <tr style="line-height: 0.8;">
							  	 <td style="color: #615e5e;" > Invoice No.</td><td>'.$inov_no['invoice_no'].'</td> 
						   		</tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Credit Note Date.</td><td>'.date("d F Y", strtotime($row['creditnote_date'])).'</td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Terms</td><td>';
							   if($row['inv_terms'] == 'end_of_month') { 
								   $output .= 'Due end of month';
							   }else if($row['inv_terms'] == 'end_next_month'){
								   $output .= 'Due end of next month';
							   }else if($row['inv_terms'] == 'due_receipt'){
								   $output .= 'Due on reciept';
							   }else if($row['inv_terms'] == 'custom'){
								   $output .= 'Custom';
							   }else{
								   $output .= $row["inv_terms"];
							   }		
							   $output .= '</td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Due Date</td><td>'.date("d F Y", strtotime($row['due_date'])).'</td>
							   </tr>
							   </table>
							  </td>
							  <td style="text-align:left; width:35%; padding-top:15px; vertical-align: top; ">
							  
							   <table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
							   <tr><td colspan="2"></td></tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Supplier'."'".'s Ref:</td><td>'.$row['so_owner'].'</td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Other Reference(s):</td><td>'.$row['owner'].'</td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Buyer'."'".'s Order No.:</td><td>'.$inov_no['cust_order_no'].'</td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Buyer'."'".'s Order Date:</td><td>'.date("d F Y", strtotime($inov_no['buyer_date'])).'</td>
							   </tr>
							   </table>
							  
							  </td>
							  <td style="text-align:right; width:30%;">';
							   $image = $compnyDtail['company_logo'];
								   if(!empty($image))
								   {
								   $output .=  '<img style="width: 70px;" src="./uploads/company_logo/'.$image.'">';
								   }
								   else
								   {
								   $output .=  '<span class="h5 text-primary">'.$compnyDtail['company_name'].'</span>';
								   }
								   $output .= '
							   </td>
						   </tr>
							</tbody>
						   </table>
							<table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
						   
							   <tr>
							   
							   <td style="width: 49.5%; padding: 2px 10px 4px 10px; vertical-align: top;">
								   <h5 style="margin-top: 0px;margin-bottom: 2px;color: #6539c0;">Debit Note From</h5>
								   <p style="margin: 0;font-size: 12px;">'.$branch['company_name'].'</p>
								  ';
								 if($branch["address"]!=""){
								 $output .=' <p style="margin: 0;font-size: 11px;">'.$branch["address"];
								 }
								 if($branch["city"]!=""){
								 $output .=  ', '.$branch["city"];
								 }
								 if($branch["zipcode"]!=""){
								 $output .=  ' - '.$branch["zipcode"];
								 }
								 if($branch["state"]!=""){
								 $output .=  ', '.$branch["state"];
								 }
								 
								 if($branch["country"]!=""){
								 $output .=  ', '.$branch["country"];
								 }
								 $output .=  '</p>';
								 if($branch["gstin"]!=""){
								 $output .=  '<p style="margin: 0;font-size: 11px;"><b>GSTIN:</b> '.$branch["gstin"].'</p>';
								 }
								 if($branch["branch_email"]!="" && $branch["show_email"]== 1){
								  $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">'.$branch["branch_email"].'</p>';
								 }
								 if($branch["contact_number"]!=""){
								  $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">+91-'.$branch["contact_number"].'</p>';
								 }
								 $output .=  ' </td>
								  
								<td style="width: 1%;background:#fff;"></td>
								
								<td style="width: 49.5%; padding:0px 10px 4px 10px; vertical-align: top;">
								   <h5 style="margin-top: 0px;margin-bottom: 0px;color: #6539c0;">Debit Note To</h5>
								 <p style="margin: 0;font-size: 12px;">'.
								 $clientDtl->org_name.'</p>';
								 if(!empty($clientDtl->primary_contact)){
								 $output .= '<p style="margin: 0;font-size: 11px;">
								   <b>Contact Name :</b> '.$clientDtl->primary_contact.'</p>';
								  }
								  $output .= '
								 <p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">';
								 
								 if(!empty($clientDtl->shipping_address)){
								  $output .= $clientDtl->shipping_address;
								 }
								 if(!empty($clientDtl->shipping_city)){
								  $output .= ', '.$clientDtl->shipping_city;
								 }
								 if(!empty($clientDtl->shipping_zipcode)){
								  $output .= ' - '.$clientDtl->shipping_zipcode;
								 }
								 if(!empty($clientDtl->shipping_state)){
								  $output .= ', '.$clientDtl->shipping_state;
								 }
								 if(!empty($clientDtl->shipping_country)){
								  $output .= ', '.$clientDtl->shipping_country;
								 }
								  $output .= '</p>';
								  
								 if(!empty($clientDtl->gstin!="")){
								 $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>GSTIN:</b> '.$clientDtl->gstin.'</p>';
								 }
								   if(isset($clientDtl->email)){
								 $output .= '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>Email:</b>'.$clientDtl->email.' <br>
								 <b>Phone:</b> +91-'.$clientDtl->mobile.'</p>';
								   }
							  $output .= '</td>
								 
						   </tr>
					   </table>
					   <!--<table width="100%" style="max-width:800px; background:#fff;">
						<tbody>
						   <tr>
							 <td align="left" style="font-size:12px;width: 49.5%;">
							   <p><b>Country of Supply : </b>'.$clientDtl->shipping_country.'</p>
							 </td>
							 <td></td>
							 <td align="left" style="font-size:12px;width: 49.5%;">
							   <p><b>Place of Supply : </b>'.$clientDtl->shipping_state.'</p>
							 </td>
						   </tr>
						</tbody>
					   </table>-->
			   
					   <table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; margin-top:10px; border-radius: 7px; background: #efebf9;">
						  <thead style="color: #fff;" align="left">';
						  
							   $igsttotal=0;
							   $sgsttotal=0;
							   $cgsttotal=0;
							   
							   $igst = explode("<br>",$row['igst']);
							   $sgst = explode("<br>",$row['sgst']);
							   $cgst = explode("<br>",$row['cgst']);
							   $proDiscount = explode("<br>",$row['pro_discount']);
							   $totalDiscount=array_sum($proDiscount);
						  
						   $output .= '<tr>
							 <th width="3%" style="font-size: 11px;">
							   <div style="background: #6539c0;border-top-left-radius: 7px;  padding: 6px;">
							  S.No.</div></th>
							  <th width="18%" style="font-size: 11px; background: #6539c0;">
							  Product/Services</th>
							  <th style="font-size: 11px; background: #6539c0;">HSN/SAC</th>
							 
							  <th style="font-size: 11px; background: #6539c0;">Qty</th>
							  <th style="font-size: 11px; background: #6539c0;">Tax</th>
							  <th style="font-size: 11px; background: #6539c0;">Rate</th>';
							  if($totalDiscount>0){
							  $output .= '<th style="font-size: 11px; background: #6539c0;">Discount</th>';
							  }
							   $output .= '<th style="font-size: 11px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 6px;">Tot. Price</div></th>
							  </tr>
						  </thead>
						  <tbody >';
						  
							   $product_name = explode("<br>",$row['product_name']);
							   $quantity = explode("<br>",$row['quantity']);
							   $unit_price = explode("<br>",$row['unit_price']);
							   $total = explode("<br>",$row['total']);
							   $total_withgst = explode("<br>",$row['sub_total_with_gst']);
							   $hsnsac = explode("<br>",$row['hsn_sac']);
							   $after_discount = ($row['initial_total']-$row['total_discount']);
							   if(!empty($row['gst'])){
								 $gst = explode("<br>",$row['gst']);
							   }
							   $proDesc = explode("<br>",$row['pro_description']);
							   
							   
							   $arrlength = count($product_name);
							   $rw=0;
							   $sr=1;
							   for($x = 0; $x < $arrlength; $x++){
								   $rw++;
								   $num = $x + 1;
								   
								   if(isset($igst[$x]) && $igst[$x]!=""){
									   $igsttotal=$igsttotal+$igst[$x];
								   }
								   if(isset($sgst[$x]) && $sgst[$x]!=""){
									   $sgsttotal=$sgsttotal+$sgst[$x];
								   }
								   if(isset($igst[$x]) && $cgst[$x]!=""){
									   $cgsttotal=$cgsttotal+$cgst[$x];
								   }
					   
								   
								   $output .='<tr>
									   <td style="font-size: 11px;padding: 5px 10px;">'.$sr.'</td>
									   <td style="font-size: 11px;padding: 5px 10px;">'.$product_name[$x].'</td>
									   
									   <td style="font-size: 11px;padding: 5px 10px;">'.$hsnsac[$x].'</td>
									   
									   <td style="font-size: 11px;padding: 5px 10px;">'.$quantity[$x].'</td>
									   <td style="font-size: 11px;padding: 5px 10px;">GST@'.$gst[$x].'%</td>
									   <td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($unit_price[$x]).'</td>';
									   if($totalDiscount>0){
									   $output .='<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($proDiscount[$x]).'</td>';
									   }
									   $output .='<td style="font-size: 11px;padding: 5px 10px; "><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($total[$x]).'</td>
								   </tr>';
								   if(isset($proDesc[$x]) && $proDesc[$x]!=""){	
								   $output.='<tr>
										   <td style="font-size: 11px; padding:5px 10px;"></td>
										   <td colspan="6" style="font-size: 11px; padding:5px 10px;">'.$proDesc[$x].'</td></tr>';
								   }
							   $sr++;
							   }
							   
							   $output .='
						 </tbody>
					   </table>
			   
					   <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
						 <tbody>
						   <tr>
						   <td align="left" width="60%" style="position: relative;">
							 <p style="font-size:12px; margin-top:0px; margin-bottom:8px;"><b style="font-size:12px;">Total in words:</b> <text style="font-size:11px;"> '.AmountInWords($row["sub_total"]).' only</text></p>';
							  if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){
					  
							   $output .='<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a;font-size:11px;">
									  <tr>
									   <td colspan="3">
										   <h5 style="margin: 0px 0px 0px 8px; color: #6539c0; font-size:12px;">Bank Details</h5>
									   </td>
									  </tr>
									  <tr style="line-height: 0.8;">
										  <th style="text-align:left; padding-left:10px;">Account Holder Name:  <th>
										  <td>'.ucfirst($bank_details_terms->acc_holder_name).'</td>
									  </tr>
									  <tr style="line-height: 0.8;">
										  <th style="text-align:left; padding-left:10px;">  Account Number:  <th>
										  <td>'.$bank_details_terms->account_no.'</td>
									  </tr>
									  <tr style="line-height: 0.8;">
										  <th style="text-align:left; padding-left:10px;">  IFSC:  <th>
										  <td>'.$bank_details_terms->ifsc_code.'</td>
									  </tr>
									  <tr style="line-height: 0.8;">
										  <th style="text-align:left; padding-left:10px;"> Account Type:  <th>
										  <td>'.ucfirst($bank_details_terms->account_type).'</td>
									  </tr>
									  <tr style="line-height: 0.8;">
										  <th style="text-align:left; padding-left:10px;"> Bank Name: <th>
										  <td>'.ucfirst($bank_details_terms->bank_name).'</td>
									  </tr><tr style="line-height: 0.8;">';
									 
									   if($bank_details_terms->upi_id!=""){
									   $output .= '<th style="text-align:left;  padding-left:10px;">UPI Id:<th>
										  <td>'.$bank_details_terms->upi_id.'</td>';
									   }
									   if(isset($_GET['dn']) && $_GET['dn']==1){
										 $output .= '<th style="text-align:left;padding-left:10px;"><a href="'.base_url("home").'" style="text-decoration:none; background:#6539c0; color:#fff; font-size:10px; padding:4px; display:inline-block; border-radius:3px;">Pay Now</a></th>';
									   }
									   
										$output .= '</tr>
									</table>';
						  
						  }  
						  
							$output .='</td>
						   <td align="" width="40%" style="text-align:right;">
							 <table align="" width="100%" style="text-align:right;position: absolute;top: 0px;">
							   <tbody>
								 <tr>
								   <th style="font-size: 12px;" align="left">Initial Amount</th>
			   
								   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["initial_total"]).'</td>
								 </tr>';
								 if($row["discount"]>0){
								 $output .='<tr>
								   <th style="font-size: 12px;" align="left">Discount</th>
			   
								   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$row["discount"].'</td>
								 </tr>';
								 
								 $output .='<tr>
								   <th style="font-size: 12px;" align="left">After Discount</th>
			   
								   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($after_discount).'</td>
								 </tr>';
								 }
								 if($igsttotal!=0){	
								   $output .='<tr><th style="font-size: 12px;" align="left">IGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($igsttotal).'</td></tr>';
								 }else{
								   
									   if($sgsttotal!=0){	
										   $output .='<tr><th style="font-size: 12px;" align="left">SGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($sgsttotal).'</td></tr>';
									   }
									   if($cgsttotal!=0){	
										   $output .='<tr><th style="font-size: 12px;" align="left">CGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($cgsttotal).'</td></tr>';
									   }
								   }
								   if($row['extra_charge_label']!=""){
									$extraCharge_name=explode("<br>",$row['extra_charge_label']);
									$extraCharge_value=explode("<br>",$row['extra_charge_value']);
								   for($y=0; $y<count($extraCharge_name); $y++){	
									   $output .='<tr><th style="font-size: 12px;" align="left">'.$extraCharge_name[$y].'</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($extraCharge_value[$y]).'</td></tr>';
								   }
								   }
										   
								 $output .='
								 <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
								 <tr>
								 
								   <th style="font-size: 12px;" align="left">TOTAL</th>
			   
								   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["sub_total"]).'</td>
								 </tr>
							   </tbody>
							   
							 </table>
						   </td>
						 </tr>
						 </tbody>
					   </table>';
			   
					   $output .='<table width="100%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-bottom:30px margin-top:';
						   if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){ 
							   $output .='0px;">';
							   
						   }else{ 
							   $output .='-20px;">'; 
							   
						   }
						   $output .='<tbody>
						   <tr>
						 <td align="left" style="width:60%; padding:1px;">
						   <h5 style="color: #6539c0;margin: 0px;">Terms and conditions</h5>
						   <ol style="padding: 0 8px; font-size:11px; margin: 1px;">';
							$custTerm=explode("<br>",$row["terms_condition"]); $no=1;
							for($i=0; $i<count($custTerm); $i++){ 
							  $output .='<li>'.$custTerm[$i].'</li>'; 
							}
							 //'.nl2br($row->terms_condition).'
						   $output .='</ol>
						 </td>';
						 
						 $output .='<td style="text-align:center;">';
							   $image = $row['signature_img'];
							   if(!empty($image)){
							   $output .=  '<img style="width: 90px;" src="./assets/pi_images/'.$image.'">	';
							   }else{
								   //$output .= '<text style="color: #615e5e; font-size:11px;">For '.$this->session->userdata('company_name').' (signature)</text>';
							   }
						 $output .= '</td>';
								   $output .= '</tr>
								   
						   
						 </tbody>
					   </table>';
					   
						
			   
					 $output .='</main>
			   
					 </body>
					 </html>';
					//return $output;
					
					}
					//echo $output; exit;
					//print_r($output); die;
					$this->load->library('pdf');
					$this->dompdf->loadHtml($output);
					ini_set('memory_limit', '128M');
					$this->dompdf->render();
					$canvas = $this->dompdf->getCanvas();
					$pdf = $canvas->get_cpdf();
			
					foreach ($pdf->objects as &$o) {
					if ($o['t'] === 'contents') {
						$o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
					}
					}
					
					if(isset($_GET['dn']) && $_GET['dn']==1){
					$this->dompdf->stream("CreditNote".$id.".pdf", array("Attachment"=>1));  
					}else{
					$this->dompdf->stream("CreditNote".$id.".pdf", array("Attachment"=>0));  
					}
			 
			 
		 }
// <------------------------------------------ Credit note end --------------------------------------------------->




// <--------------------------------------------- Debit Note Start ------------------------------------------------->

public function get_debitnote_graph(){ 
	$data['grouped_data'] = $this->Base_model->getdebitnotegraph();
	// print_r($data);die;
	$response = [
		'status' => 'success',
		'data' => $data['grouped_data']  // Corrected variable name
	];

	$this->output->set_content_type('application/json')->set_output(json_encode($response));

}


	public function debitnote()
	{
		$data['user'] = $this->Login_model->getusername();
		$data['admin'] = $this->Login_model->getadminname();

			$this->load->view('accounting/debitnote' ,$data);
	}


	public function add_debitnote()
		{
			if ($this->input->is_ajax_request()) {
				$id=$this->input->post('invoicenum');
				$cond = ['invoice_no' => $id];
				$invoice_data = $this->Invoice_model->getinvoicedata($cond)->result_array();

				if (!empty($invoice_data)) {
					$response = array(
						'success' => true,
						'invoice_id' => $invoice_data[0]['id']
					);
					echo json_encode($response);
				} else {
					$response = array(
						'success' => false,
						'message' => 'Invoice not found'
					);
					echo json_encode($response);
				}
			} else {
				echo "Invalid request";
			}
		}



   public function loaddebitnote_view()
   {
    if($this->session->userdata('email'))
    {
        
        if(checkModuleForContr('Generate Invoicing')<1){
	        redirect('home');
	        exit;
	    } 

		if(check_permission_status('Invoice','create_u')==true){
			$data['branch_details'] 	= $this->Invoice_model->get_branch();
			$data['customer_details']   = $this->Invoice_model->get_organization_bytype(); 
			$data['invoice_terms'] 		= $this->Invoice_model->getall_terms();
			$data['declaration'] 		= $this->Invoice_model->get_declaration();

			$id=$this->uri->segment(2);

			if(isset($_GET['so']) && $_GET['so']!=""){
				$data['record'] = $this->Salesorders->get_data_for_update($_GET['so']);
				$data['action']=array('data'=>'add','from'=>'quotation');
				


			}else if(isset($id) && $id!=""){
				$data['record'] = $this->Invoice_model->get_data_for_update($id);

				// $isdebitnote_exists=$this->Base_model->debitnote_exists($id);
				$isdebitnote_exists=$this->Base_model->debitnote_exists($id);


				if($isdebitnote_exists['delete_status']==1){
							
						$debitnote_no = $this->Base_model->debitnote_no($id);
						$data['debitnotenum'] = $debitnote_no->debitnote_no;
				
						$data['action']=array('data'=>'update','from'=>'salesorder');
									
				}else{

					$debitnoteid=$data['debitnoteid']=$this->Base_model->getlast_id_debit('MAX(id) as lastid','debitnote')->row_array();
				
				    if(isset($debitnoteid['lastid'])){
					$lastcreditnote = $debitnoteid['lastid']+1;
				
				    }else{
				  	$lastcreditnote = 1;
				   }
					$data['debitnotenum']=generateserialnum($lastcreditnote,'debitnote','debitnote_no');
				// print_r ($data['creditnotenum']);die;
				}
			}else{
			
				$data['action']=array('data'=>'add','from'=>'direct');
			}
			
			$data['gstPer']     = $this->Salesorders->get_gst();
			
			// print_r($data);die;
            $this->load->view('accounting/add-debitnote',$data);
			
		}else{
			redirect("permission");
		}			
	
    }
    else
    {
      redirect('login');
    }
   
      
   }

   public function add_debitnoteDetails() 
   {

	// $validation = $this->check_validation();
    if(1==200){
      echo $validation;die;
	  
    }else{
		
		if($this->input->post('igst')!=""){
			$igst=implode("<br>", $this->input->post('igst'));
		}else{ $igst=''; }
		if($this->input->post('cgst')!=""){
			$cgst=implode("<br>", $this->input->post('cgst'));
		}else{ 	$cgst=''; }
		if($this->input->post('sgst')!=""){
			$sgst=implode("<br>", $this->input->post('sgst'));
		}else{ $sgst=''; }
		
		if($this->input->post('discount_price')!=""){
			$discount_price=implode("<br>", $this->input->post('discount_price'));
		}else{ $discount_price=''; }
		
		if($this->input->post('terms_condition')){
			$terms_condition=implode("<br>",$this->input->post('terms_condition'));
		}else{ $terms_condition=''; }
		if($this->input->post('extra_charge')!=""){
			$extra_charge=implode("<br>", $this->input->post('extra_charge'));
		}else{ $extra_charge=''; }
		if($this->input->post('extra_chargevalue')!=""){
			$extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
		}else{ $extra_chargevalue=''; }	
		if($this->input->post('label')){
			$lable=implode("<br>",$this->input->post('label'));
	    }else{ $lable='';}
	    if($this->input->post('label_value')){
			$label_value=implode("<br>",$this->input->post('label_value'));
	    }else{ $label_value='';}
	    if($this->input->post('product_desc')){
			$product_desc=implode("<br>",$this->input->post('product_desc'));
	    }else{ $product_desc=''; }
	   
	   if($this->input->post('sub_total_with_gst')){
			$sub_totalwithgst=implode("<br>",$this->input->post('sub_total_with_gst'));
	    }else{ $sub_totalwithgst=''; }
	   
	   
      $unit_price 		= str_replace(",", "",$this->input->post('unit_price'));
      $total 			= str_replace(",", "",$this->input->post('total'));
	  $after_discount 	= str_replace(",", "",$this->input->post('after_discount'));
	  $initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
	  $total_discount 	= str_replace(",", "",$this->input->post('discount'));
	  $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
	  
	    $advanced_payment = str_replace(",", "",$this->input->post('advance_payment'));
		if($advanced_payment==""){
			$advanced_payment=0;
		}
		$pendingPayment=$sub_total-$advanced_payment;
		
	  $org_name = $this->input->post('customer_name');
	  $org_id = $this->input->post('customer_id');
       
	  
      $debitnote = array(
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'saleorder_id' 		=> $this->input->post('saleorder_id'),
        'so_owner' 			=> $this->input->post('supplier'),
        'owner' 			=> $this->input->post('owner'),
		'debitnote_no'     => $this->input->post('creditnote_no'),
		'debitnote_date'   => $this->input->post('creditnote_date'),
        'cust_order_no'		=> $this->input->post('order_no'),
        'invoice_date' 		=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
        'due_date' 			=> date('Y-m-d',strtotime($this->input->post('invoice_dueDate'))),
		'inv_terms' 		=> $this->input->post('terms_select'),
        'extra_field_label' => $lable,
		'extra_field_value' => $label_value,
        'org_name' 	    	=> $org_name,
        'cust_id' 	    	=> $org_id,
        'invoice_declaration'=> $this->input->post('invoice_declaration'),
        'branch_id'   		=> $this->input->post('shipto'),
		//'discount_type' 	=> $this->input->post('sel_disc'),
		//'discount' 	    => $this->input->post('discount'),
		'notes' 			=> $this->input->post('notes'),
		//'attachment' 		=> $attachment,
		//'signature_img' 	=> $signature_img,
		'pro_description' 	=> $product_desc,		
		'enquiry_email' 	=> $this->input->post('enquiry_email'),
		'enquiry_mobile' 	=> $this->input->post('enquiry_mobile'),
		'jurisdiction' 		=> $this->input->post('jurisdiction'),
		'late_charge' 		=> $this->input->post('late_charge'),
        'product_name' 		=> implode("<br>",$this->input->post('product_name')),
        'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
		'gst' 				=> implode("<br>",$this->input->post('gst')),
		'quantity' 			=> implode("<br>",$this->input->post('quantity')),
        'unit_price' 		=> implode("<br>",$unit_price),
        'pro_discount' 		=> $discount_price,
        'total' 			=> implode("<br>",$total),
		'sgst' 				=> $sgst,
		'igst' 				=> $igst,
		'cgst' 				=> $cgst,
		'type' 				=> $this->input->post('type'),
		'sub_total_with_gst'=> $sub_totalwithgst,
		'extra_charge_label'=> $extra_charge,
		'extra_charge_value'=> $extra_chargevalue,
		'terms_condition' 	=> $terms_condition,
        'total_discount' 	=> $total_discount,
        'initial_total' 	=> $initial_total,        
        'sub_total' 		=> $sub_total,
		'total_igst' 		=> str_replace(",", "",$this->input->post('total_igst')),
        'total_cgst' 		=> str_replace(",", "",$this->input->post('total_cgst')),
        'total_sgst' 		=> str_replace(",", "",$this->input->post('total_sgst')),
		'advanced_payment' 	=> $advanced_payment,
        'pending_payment' 	=> $pendingPayment,
		'invoice_id'     => $this->input->post('invc_id')	        

      );
	// print_r($debitnote);die;
        $insertdata=$this->Base_model->insert_debit_data('debitnote',$debitnote);
		$response=array();
		if($insertdata == 1){
            $response['success'] = true;
            $response['message'] = "Data inserted successfully";
		}
        echo json_encode($response);
      
	}
   }


   public function update_debitnoteDetails()
   {
	// print_r('testupdate');die;
	// $validation = $this->check_validation();
    if(1==200){
		 echo $validation;die;
	  
    	}else{
		
		if($this->input->post('igst')!=""){
			$igst=implode("<br>", $this->input->post('igst'));
		}else{ $igst=''; }
		if($this->input->post('cgst')!=""){
			$cgst=implode("<br>", $this->input->post('cgst'));
		}else{ 	$cgst=''; }
		if($this->input->post('sgst')!=""){
			$sgst=implode("<br>", $this->input->post('sgst'));
		}else{ $sgst=''; }
		
		if($this->input->post('discount_price')!=""){
			$discount_price=implode("<br>", $this->input->post('discount_price'));
		}else{ $discount_price=''; }
		
		if($this->input->post('terms_condition')){
			$terms_condition=implode("<br>",$this->input->post('terms_condition'));
		}else{ $terms_condition=''; }
		if($this->input->post('extra_charge')!=""){
			$extra_charge=implode("<br>", $this->input->post('extra_charge'));
		}else{ $extra_charge=''; }
		if($this->input->post('extra_chargevalue')!=""){
			$extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
		}else{ $extra_chargevalue=''; }	
		if($this->input->post('label')){
			$lable=implode("<br>",$this->input->post('label'));
	    }else{ $lable='';}
	    if($this->input->post('label_value')){
			$label_value=implode("<br>",$this->input->post('label_value'));
	    }else{ $label_value='';}
	    if($this->input->post('product_desc')){
			$product_desc=implode("<br>",$this->input->post('product_desc'));
	    }else{ $product_desc=''; }
	   
	   if($this->input->post('sub_total_with_gst')){
			$sub_totalwithgst=implode("<br>",$this->input->post('sub_total_with_gst'));
	    }else{ $sub_totalwithgst=''; }
	   
	   
      $unit_price 		= str_replace(",", "",$this->input->post('unit_price'));
      $total 			= str_replace(",", "",$this->input->post('total'));
	  $after_discount 	= str_replace(",", "",$this->input->post('after_discount'));
	  $initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
	  $total_discount 	= str_replace(",", "",$this->input->post('discount'));
	  $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
	  
	    $advanced_payment = str_replace(",", "",$this->input->post('advance_payment'));
		if($advanced_payment==""){
			$advanced_payment=0;
		}
		$pendingPayment=$sub_total-$advanced_payment;
		
	  $org_name = $this->input->post('customer_name');
	  $org_id = $this->input->post('customer_id');
	  $invoice_update_id = $this->input->post('id');
       
	  
      $debitnotedata = array(
		'invoice_id'        => $invoice_update_id,
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'saleorder_id' 		=> $this->input->post('saleorder_id'),
        'so_owner' 			=> $this->input->post('supplier'),
        'owner' 			=> $this->input->post('owner'),
		'debitnote_no'     => $this->input->post('creditnote_no'),
		'debitnote_date'   => $this->input->post('creditnote_date'),
        'cust_order_no'		=> $this->input->post('order_no'),
        'invoice_date' 		=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
        'due_date' 			=> date('Y-m-d',strtotime($this->input->post('invoice_dueDate'))),
		'inv_terms' 		=> $this->input->post('terms_select'),
        'extra_field_label' => $lable,
		'extra_field_value' => $label_value,
        'org_name' 	    	=> $org_name,
        'cust_id' 	    	=> $org_id,
        'invoice_declaration'=> $this->input->post('invoice_declaration'),
        'branch_id'   		=> $this->input->post('shipto'),
		//'discount_type' 	=> $this->input->post('sel_disc'),
		//'discount' 	    => $this->input->post('discount'),
		'notes' 			=> $this->input->post('notes'),
		//'attachment' 		=> $attachment,
		//'signature_img' 	=> $signature_img,
		'pro_description' 	=> $product_desc,		
		'enquiry_email' 	=> $this->input->post('enquiry_email'),
		'enquiry_mobile' 	=> $this->input->post('enquiry_mobile'),
		'jurisdiction' 		=> $this->input->post('jurisdiction'),
		'late_charge' 		=> $this->input->post('late_charge'),
        'product_name' 		=> implode("<br>",$this->input->post('product_name')),
        'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
		'gst' 				=> implode("<br>",$this->input->post('gst')),
		'quantity' 			=> implode("<br>",$this->input->post('quantity')),
        'unit_price' 		=> implode("<br>",$unit_price),
        'pro_discount' 		=> $discount_price,
        'total' 			=> implode("<br>",$total),
		'sgst' 				=> $sgst,
		'igst' 				=> $igst,
		'cgst' 				=> $cgst,
		'type' 				=> $this->input->post('type'),
		'sub_total_with_gst'=> $sub_totalwithgst,
		'extra_charge_label'=> $extra_charge,
		'extra_charge_value'=> $extra_chargevalue,
		'terms_condition' 	=> $terms_condition,
        'total_discount' 	=> $total_discount,
        'initial_total' 	=> $initial_total,        
        'sub_total' 		=> $sub_total,
		'total_igst' 		=> str_replace(",", "",$this->input->post('total_igst')),
        'total_cgst' 		=> str_replace(",", "",$this->input->post('total_cgst')),
        'total_sgst' 		=> str_replace(",", "",$this->input->post('total_sgst')),
		'advanced_payment' 	=> $advanced_payment,
        'pending_payment' 	=> $pendingPayment	        

      );
	
        $invoice_id=$this->Base_model->debitnote_exists($invoice_update_id);
		// print_r($invoice_id);die;
		if($invoice_id === $invoice_update_id){
			$response=array();
				$response['success'] = false;
				$response['message'] = "Data already exit";
			
				echo json_encode($response);
		}else{
			// print_r($invoice_update_id);die;
			// print_r($debitnotedata);die;
			$updatedata=$this->Base_model->update_debit_note($invoice_update_id ,$debitnotedata);
			$response=array();
			if($updatedata == 1){
				$response['success'] = true;
				$response['message'] = "Data updated successfully";
			}
			echo json_encode($response);
		}
      
	}
   }

   public function getdebitnotedata()
   {
	
	$delete_inv	=0;
	$update_inv	=0;
	$retrieve_inv=0; 
	if(check_permission_status('Invoice','delete_u')==true){
		$delete_inv=1;
	}
	if(check_permission_status('Invoice','retrieve_u')==true){
		$retrieve_inv=1;
	}
	if(check_permission_status('Invoice','update_u')==true){
		$update_inv=1;
	}
	  
	
	 $list = $this->Base_model->getdata_debit();


	 $data = array();
	 $no = $_POST['start'];
	 $output = "";
	 $i =1;
	 foreach ($list as $item) {
		$ino_id = $item['invoice_id'];
		 $list_ino = $this->Base_model->get_ino_debit_no($ino_id);

		$encrypted_id 	= base64_encode($item['invoice_id']);
		$sessionEmail 	= base64_encode($this->session->userdata('company_email'));
		$sessionCompany	= base64_encode($this->session->userdata('company_name'));

		$row=[];
		 
			 
				$row[].= $i++;
			   $row[].=$item['debitnote_date'];
				$row[] = "<span style='color: rgba(140, 80, 200, 1);font-weight: 700;'>{$list_ino['debitnote_no']}</span>";
			   $row[].=$item['sub_total'];
				$row[] = "<span style='color: rgba(140, 80, 200, 1);font-weight: 700;'>{$list_ino['invoice_no']}</span>";
			   $row[].=$list_ino['sub_total'];
			   $row[].=$list_ino['invoice_date']; 
			   $row[].=$list_ino['org_name'];
			   $row[].=$item['owner']; 
			 
			   
			   $row[]="<a style='text-decoration:none'href='" . base_url('view-debitnote').'?inv_id='.urlencode($encrypted_id).'&cnp='.urlencode($sessionCompany). '&ceml='.urlencode($sessionEmail)."'  class='text-success border-right'><i class='far fa-eye sub-icn-opp m-1' data-toggle='tooltip' data-container='body' title='View Debit Note Details' ></i></a> 

			    <a style='text-decoration:none' href='" . base_url('add-debitnote/') . $item['invoice_id'] . "' class='text-primary border-right'> <i class='far fa-edit sub-icn-so m-1' data-toggle='tooltip' data-container='body' title='Update Debit Note Details' ></i></a>
				

			   <a style='text-decoration:none' href='javascript:void(0)'  onclick='delete_debitnote(" . $item['invoice_id'] . ")' class='text-danger'>
			   <i class='far fa-trash-alt text-danger m-1'  data-toggle='tooltip' data-container='body' title='Delete Debit Note' ></i></a></td> 
			 
			</tr>";
			

           $data[]=$row;
	 }
	 $i++;
	
	
	 $action = [
		"draw" => $_POST['draw'],
		 "recordsTotal_debit" => $this->Base_model->count_all_debit(),
		 "Totalamount_debit" => $this->Base_model->count_Total_debit(),

		 "recordsTotal" => $this->Base_model->Record_deb_total(),
		 "recordsFiltered" => $this->Base_model->amount_deb_total(),
		 "data" => $data, // Store the HTML table rows directly, no need for an array
	 ];

	// print_r($action);die;
	echo json_encode($action);

   } 

   public function view_load_debitnote() 
   	{
		if($this->session->userdata('email'))
		{
			if(checkModuleForContr('Generate Invoicing')<1){
				redirect('home');
			  }
			if(check_permission_status('Invoice','retrieve_u')==true){
		
			$id = base64_decode($_GET['inv_id']);
			$decoded_ceml = base64_decode( $_GET['ceml']);
			$decoded_cnp = base64_decode( $_GET['cnp']);
	
		if (isset($id)) {
			$data['inov_no']=$this->Base_model->get_ino_debit_no($id);
		}

		$data['view_debitnote']= $this->Base_model->get_debitnote_by_id($id,$decoded_cnp,$decoded_ceml);

		$data['bank_details_terms'] = $this->Base_model->get_bank_detailss();
		
		if($data['view_debitnote']['id']){
			$data['otherdata'] =array();
			$data['branch_debit'] = $this->Base_model->debit_get_Branch_Data($data['view_debitnote']['branch_id']);
			$data['clientDtl'] = $this->Base_model->debit_get_org_by_id($data['view_debitnote']['cust_id']);
			$this->load->view('accounting/view_debitnote' ,$data);
			
		}
			
		}else{
			redirect("permission");
		}
		}else{
			redirect('login');		
		}
	}

	public function debitnote_delete($id)
	{
		$delete=$this->Base_model->delete_debitnote_id($id);
		if($delete){
			echo json_encode(array("status" => TRUE));
		}

	}

	public function generate_pdf()
	{
		
			$id = base64_decode($_GET['inv_id']);
			$decoded_cnp = base64_decode( $_GET['cnp']);
			$decoded_ceml = base64_decode( $_GET['ceml']);
		
			   $row= $this->Base_model->get_debitnote_by_id($id,$decoded_cnp,$decoded_ceml);
			   $inov_no=$this->Base_model->get_ino_no($id);
			  
			
			if($row['id']){

			   $rowOwner = $this->Base_model->get_Owner_debit($row['sess_eml']);
			   if(empty($rowOwner['standard_name'])){
				   $rowOwner = $this->Base_model->get_Admin_debit($row['sess_eml']);
				
			   }

			   $compnyDtail= $this->Base_model->get_Comp_debit($row['session_comp_email']);
			
			   $branch = $this->Base_model->getBranchData_debit($row['branch_id']); 
			  
			   $clientDtl = $this->Base_model->getorg_by_id_debit($row['cust_id']);
			
			   $bank_details_terms = $this->Base_model->get_bank_detailss();
			//    print_r($bank_details_terms);die;
			 
			 $output = '<!DOCTYPE html>
					 <html>
					 <head>
					   <title>Team365 | Debit Note</title>
					   <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
					   <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
					 <style>
						@page{
							 margin-top: 10px; /* create space for header */
						   }
						footer .pagenum:before {
							content: counter(page, decimal);
						   }
					   </style>
					 </head>
			   
					 <body style="font-family: Quicksand, sans-serif;">';
						 if($row['declaration_status'] == 1) {  
					   $output .= '<footer style="position: fixed;  bottom: 110;border-top:0.5px solid #333; " >';
						 }else{
							 
						 $output .= '<footer style="position: fixed;  bottom: 80;border-top:0.5px solid #333; " >';
						 }
					   
						$output .= ' <table style="font-size:11px; width:100%; text-align:center;">';
							 
							 
						   if($row['declaration_status'] == 1) {   
						   $output .= '<tr>
							   <td style="font-size:10px;">
							   <text><b>Declaration:-</b></text>
							   '.$row['invoice_declaration'].'
							   </td>
							 </tr>';
						   }
						   if($row['jurisdiction']!="") {  
						   $output .= ' <tr>
							   <td style="font-size:10px;"><b>"SUBJECT TO '.strtoupper($row['jurisdiction']).' JURISDICTION"</b></td>
							 </tr>';
						   }
						   if($row['late_charge']!="") {  
						   $output .= '  <tr>
							   <td style="font-size:10px;">INTEREST@ '.$row['late_charge'].'% P.A WILL BE CHARGED IF THE PAYMENT IS NOT MADE WITHIN THE STIPULATED TIME.</td>
							 </tr>';
						   }
						   $output .= '  <tr>
							   <td><div class="pagenum-container"style="text-align:right;font-size:10px; border-top:1px dashed #333; ">Page <span class="pagenum"></span></div></td>
							 </tr>
							 <tr>
							   <td><b>"This is system generated  Debit Note, Sign and stamp not required"</b></td>
							 </tr>
							 <tr>
							   <td><b><span style="font-size: 10px;">E-mail - '.$branch['branch_email'].'</br>
							| Ph. - +91-'.$branch['contact_number'].'</br>
							 | GSTIN: '.$branch['gstin'].'</br>
							  | CIN: '.$branch['cin'].'</span></b><br>
						   <b><span style="font-size:11px;">Powered By <a href="https://team365.io/">Team365 CRM</a></span></b> </td>
							 </tr>
						 </table>
						
					   
					   </footer>
					 
					 <main style="margin-bottom:10px;">
					 <table width="100%" style="max-width:800px; background:#fff;">
						<tbody>
						   <tr>
							  <td style="width:35%; vertical-align: top;">
							   <table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
							   <tr>
								   <td colspan="2"><text style="color: #6539c0;font-size:13px;"><b>Tax  Debit Note</b></text></td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;" > Debit Note No.</td><td>'.$row['debitnote_no'].'</td> 
							   </tr>
							   <tr style="line-height: 0.8;">
							  	 <td style="color: #615e5e;" > Invoice No.</td><td>'.$inov_no['invoice_no'].'</td> 
						   		</tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Debit Note Date.</td><td>'.date("d F Y", strtotime($row['debitnote_date'])).'</td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Terms</td><td>';
							   if($row['inv_terms'] == 'end_of_month') { 
								   $output .= 'Due end of month';
							   }else if($row['inv_terms'] == 'end_next_month'){
								   $output .= 'Due end of next month';
							   }else if($row['inv_terms'] == 'due_receipt'){
								   $output .= 'Due on reciept';
							   }else if($row['inv_terms'] == 'custom'){
								   $output .= 'Custom';
							   }else{
								   $output .= $row["inv_terms"];
							   }		
							   $output .= '</td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Due Date</td><td>'.date("d F Y", strtotime($row['due_date'])).'</td>
							   </tr>
							   </table>
							  </td>
							  <td style="text-align:left; width:35%; padding-top:15px; vertical-align: top; ">
							  
							   <table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
							   <tr><td colspan="2"></td></tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Supplier'."'".'s Ref:</td><td>'.$row['so_owner'].'</td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Other Reference(s):</td><td>'.$row['owner'].'</td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Buyer'."'".'s Order No.:</td><td>'.$inov_no['cust_order_no'].'</td>
							   </tr>
							   <tr style="line-height: 0.8;">
								   <td style="color: #615e5e;">Buyer'."'".'s Order Date:</td><td>'.date("d F Y", strtotime($inov_no['buyer_date'])).'</td>
							   </tr>
							   </table>
							  
							  </td>
							  <td style="text-align:right; width:30%;">';
							   $image = $compnyDtail['company_logo'];
								   if(!empty($image))
								   {
								   $output .=  '<img style="width: 70px;" src="./uploads/company_logo/'.$image.'">';
								   }
								   else
								   {
								   $output .=  '<span class="h5 text-primary">'.$compnyDtail['company_name'].'</span>';
								   }
								   $output .= '
							   </td>
						   </tr>
							</tbody>
						   </table>
							<table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
						   
							   <tr>
							   
							   <td style="width: 49.5%; padding: 2px 10px 4px 10px; vertical-align: top;">
								   <h5 style="margin-top: 0px;margin-bottom: 2px;color: #6539c0;">Debit Note From</h5>
								   <p style="margin: 0;font-size: 12px;">'.$branch['company_name'].'</p>
								  ';
								 if($branch["address"]!=""){
								 $output .=' <p style="margin: 0;font-size: 11px;">'.$branch["address"];
								 }
								 if($branch["city"]!=""){
								 $output .=  ', '.$branch["city"];
								 }
								 if($branch["zipcode"]!=""){
								 $output .=  ' - '.$branch["zipcode"];
								 }
								 if($branch["state"]!=""){
								 $output .=  ', '.$branch["state"];
								 }
								 
								 if($branch["country"]!=""){
								 $output .=  ', '.$branch["country"];
								 }
								 $output .=  '</p>';
								 if($branch["gstin"]!=""){
								 $output .=  '<p style="margin: 0;font-size: 11px;"><b>GSTIN:</b> '.$branch["gstin"].'</p>';
								 }
								 if($branch["branch_email"]!="" && $branch["show_email"]== 1){
								  $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">'.$branch["branch_email"].'</p>';
								 }
								 if($branch["contact_number"]!=""){
								  $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">+91-'.$branch["contact_number"].'</p>';
								 }
								 $output .=  ' </td>
								  
								<td style="width: 1%;background:#fff;"></td>
								
								<td style="width: 49.5%; padding:0px 10px 4px 10px; vertical-align: top;">
								   <h5 style="margin-top: 0px;margin-bottom: 0px;color: #6539c0;">Debit Note To</h5>
								 <p style="margin: 0;font-size: 12px;">'.
								 $clientDtl->org_name.'</p>';
								 if(!empty($clientDtl->primary_contact)){
								 $output .= '<p style="margin: 0;font-size: 11px;">
								   <b>Contact Name :</b> '.$clientDtl->primary_contact.'</p>';
								  }
								  $output .= '
								 <p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">';
								 
								 if(!empty($clientDtl->shipping_address)){
								  $output .= $clientDtl->shipping_address;
								 }
								 if(!empty($clientDtl->shipping_city)){
								  $output .= ', '.$clientDtl->shipping_city;
								 }
								 if(!empty($clientDtl->shipping_zipcode)){
								  $output .= ' - '.$clientDtl->shipping_zipcode;
								 }
								 if(!empty($clientDtl->shipping_state)){
								  $output .= ', '.$clientDtl->shipping_state;
								 }
								 if(!empty($clientDtl->shipping_country)){
								  $output .= ', '.$clientDtl->shipping_country;
								 }
								  $output .= '</p>';
								  
								 if(!empty($clientDtl->gstin!="")){
								 $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>GSTIN:</b> '.$clientDtl->gstin.'</p>';
								 }
								   if(isset($clientDtl->email)){
								 $output .= '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>Email:</b>'.$clientDtl->email.' <br>
								 <b>Phone:</b> +91-'.$clientDtl->mobile.'</p>';
								   }
							  $output .= '</td>
								 
						   </tr>
					   </table>
					   <!--<table width="100%" style="max-width:800px; background:#fff;">
						<tbody>
						   <tr>
							 <td align="left" style="font-size:12px;width: 49.5%;">
							   <p><b>Country of Supply : </b>'.$clientDtl->shipping_country.'</p>
							 </td>
							 <td></td>
							 <td align="left" style="font-size:12px;width: 49.5%;">
							   <p><b>Place of Supply : </b>'.$clientDtl->shipping_state.'</p>
							 </td>
						   </tr>
						</tbody>
					   </table>-->
			   
					   <table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; margin-top:10px; border-radius: 7px; background: #efebf9;">
						  <thead style="color: #fff;" align="left">';
						  
							   $igsttotal=0;
							   $sgsttotal=0;
							   $cgsttotal=0;
							   
							   $igst = explode("<br>",$row['igst']);
							   $sgst = explode("<br>",$row['sgst']);
							   $cgst = explode("<br>",$row['cgst']);
							   $proDiscount = explode("<br>",$row['pro_discount']);
							   $totalDiscount=array_sum($proDiscount);
						  
						   $output .= '<tr>
							 <th width="3%" style="font-size: 11px;">
							   <div style="background: #6539c0;border-top-left-radius: 7px;  padding: 6px;">
							  S.No.</div></th>
							  <th width="18%" style="font-size: 11px; background: #6539c0;">
							  Product/Services</th>
							  <th style="font-size: 11px; background: #6539c0;">HSN/SAC</th>
							 
							  <th style="font-size: 11px; background: #6539c0;">Qty</th>
							  <th style="font-size: 11px; background: #6539c0;">Tax</th>
							  <th style="font-size: 11px; background: #6539c0;">Rate</th>';
							  if($totalDiscount>0){
							  $output .= '<th style="font-size: 11px; background: #6539c0;">Discount</th>';
							  }
							   $output .= '<th style="font-size: 11px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 6px;">Tot. Price</div></th>
							  </tr>
						  </thead>
						  <tbody >';
						  
							   $product_name = explode("<br>",$row['product_name']);
							   $quantity = explode("<br>",$row['quantity']);
							   $unit_price = explode("<br>",$row['unit_price']);
							   $total = explode("<br>",$row['total']);
							   $total_withgst = explode("<br>",$row['sub_total_with_gst']);
							   $hsnsac = explode("<br>",$row['hsn_sac']);
							   $after_discount = ($row['initial_total']-$row['total_discount']);
							   if(!empty($row['gst'])){
								 $gst = explode("<br>",$row['gst']);
							   }
							   $proDesc = explode("<br>",$row['pro_description']);
							   
							   
							   $arrlength = count($product_name);
							   $rw=0;
							   $sr=1;
							   for($x = 0; $x < $arrlength; $x++){
								   $rw++;
								   $num = $x + 1;
								   
								   if(isset($igst[$x]) && $igst[$x]!=""){
									   $igsttotal=$igsttotal+$igst[$x];
								   }
								   if(isset($sgst[$x]) && $sgst[$x]!=""){
									   $sgsttotal=$sgsttotal+$sgst[$x];
								   }
								   if(isset($igst[$x]) && $cgst[$x]!=""){
									   $cgsttotal=$cgsttotal+$cgst[$x];
								   }
					   
								   
								   $output .='<tr>
									   <td style="font-size: 11px;padding: 5px 10px;">'.$sr.'</td>
									   <td style="font-size: 11px;padding: 5px 10px;">'.$product_name[$x].'</td>
									   
									   <td style="font-size: 11px;padding: 5px 10px;">'.$hsnsac[$x].'</td>
									   
									   <td style="font-size: 11px;padding: 5px 10px;">'.$quantity[$x].'</td>
									   <td style="font-size: 11px;padding: 5px 10px;">GST@'.$gst[$x].'%</td>
									   <td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($unit_price[$x]).'</td>';
									   if($totalDiscount>0){
									   $output .='<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($proDiscount[$x]).'</td>';
									   }
									   $output .='<td style="font-size: 11px;padding: 5px 10px; "><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($total[$x]).'</td>
								   </tr>';
								   if(isset($proDesc[$x]) && $proDesc[$x]!=""){	
								   $output.='<tr>
										   <td style="font-size: 11px; padding:5px 10px;"></td>
										   <td colspan="6" style="font-size: 11px; padding:5px 10px;">'.$proDesc[$x].'</td></tr>';
								   }
							   $sr++;
							   }
							   
							   $output .='
						 </tbody>
					   </table>
			   
					   <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
						 <tbody>
						   <tr>
						   <td align="left" width="60%" style="position: relative;">
							 <p style="font-size:12px; margin-top:0px; margin-bottom:8px;"><b style="font-size:12px;">Total in words:</b> <text style="font-size:11px;"> '.AmountInWords($row["sub_total"]).' only</text></p>';
							  if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){
					  
							   $output .='<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a;font-size:11px;">
									  <tr>
									   <td colspan="3">
										   <h5 style="margin: 0px 0px 0px 8px; color: #6539c0; font-size:12px;">Bank Details</h5>
									   </td>
									  </tr>
									  <tr style="line-height: 0.8;">
										  <th style="text-align:left; padding-left:10px;">Account Holder Name:  <th>
										  <td>'.ucfirst($bank_details_terms->acc_holder_name).'</td>
									  </tr>
									  <tr style="line-height: 0.8;">
										  <th style="text-align:left; padding-left:10px;">  Account Number:  <th>
										  <td>'.$bank_details_terms->account_no.'</td>
									  </tr>
									  <tr style="line-height: 0.8;">
										  <th style="text-align:left; padding-left:10px;">  IFSC:  <th>
										  <td>'.$bank_details_terms->ifsc_code.'</td>
									  </tr>
									  <tr style="line-height: 0.8;">
										  <th style="text-align:left; padding-left:10px;"> Account Type:  <th>
										  <td>'.ucfirst($bank_details_terms->account_type).'</td>
									  </tr>
									  <tr style="line-height: 0.8;">
										  <th style="text-align:left; padding-left:10px;"> Bank Name: <th>
										  <td>'.ucfirst($bank_details_terms->bank_name).'</td>
									  </tr><tr style="line-height: 0.8;">';
									 
									   if($bank_details_terms->upi_id!=""){
									   $output .= '<th style="text-align:left;  padding-left:10px;">UPI Id:<th>
										  <td>'.$bank_details_terms->upi_id.'</td>';
									   }
									   if(isset($_GET['dn']) && $_GET['dn']==1){
										 $output .= '<th style="text-align:left;padding-left:10px;"><a href="'.base_url("home").'" style="text-decoration:none; background:#6539c0; color:#fff; font-size:10px; padding:4px; display:inline-block; border-radius:3px;">Pay Now</a></th>';
									   }
									   
										$output .= '</tr>
									</table>';
						  
						  }  
						  
							$output .='</td>
						   <td align="" width="40%" style="text-align:right;">
							 <table align="" width="100%" style="text-align:right;position: absolute;top: 0px;">
							   <tbody>
								 <tr>
								   <th style="font-size: 12px;" align="left">Initial Amount</th>
			   
								   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["initial_total"]).'</td>
								 </tr>';
								 if($row["discount"]>0){
								 $output .='<tr>
								   <th style="font-size: 12px;" align="left">Discount</th>
			   
								   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$row["discount"].'</td>
								 </tr>';
								 
								 $output .='<tr>
								   <th style="font-size: 12px;" align="left">After Discount</th>
			   
								   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($after_discount).'</td>
								 </tr>';
								 }
								 if($igsttotal!=0){	
								   $output .='<tr><th style="font-size: 12px;" align="left">IGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($igsttotal).'</td></tr>';
								 }else{
								   
									   if($sgsttotal!=0){	
										   $output .='<tr><th style="font-size: 12px;" align="left">SGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($sgsttotal).'</td></tr>';
									   }
									   if($cgsttotal!=0){	
										   $output .='<tr><th style="font-size: 12px;" align="left">CGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($cgsttotal).'</td></tr>';
									   }
								   }
								   if($row['extra_charge_label']!=""){
									$extraCharge_name=explode("<br>",$row['extra_charge_label']);
									$extraCharge_value=explode("<br>",$row['extra_charge_value']);
								   for($y=0; $y<count($extraCharge_name); $y++){	
									   $output .='<tr><th style="font-size: 12px;" align="left">'.$extraCharge_name[$y].'</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($extraCharge_value[$y]).'</td></tr>';
								   }
								   }
										   
								 $output .='
								 <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
								 <tr>
								 
								   <th style="font-size: 12px;" align="left">TOTAL</th>
			   
								   <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["sub_total"]).'</td>
								 </tr>
							   </tbody>
							   
							 </table>
						   </td>
						 </tr>
						 </tbody>
					   </table>';
			   
					   $output .='<table width="100%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-bottom:30px margin-top:';
						   if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){ 
							   $output .='0px;">';
							   
						   }else{ 
							   $output .='-20px;">'; 
							   
						   }
						   $output .='<tbody>
						   <tr>
						 <td align="left" style="width:60%; padding:1px;">
						   <h5 style="color: #6539c0;margin: 0px;">Terms and conditions</h5>
						   <ol style="padding: 0 8px; font-size:11px; margin: 1px;">';
							$custTerm=explode("<br>",$row["terms_condition"]); $no=1;
							for($i=0; $i<count($custTerm); $i++){ 
							  $output .='<li>'.$custTerm[$i].'</li>'; 
							}
							 //'.nl2br($row->terms_condition).'
						   $output .='</ol>
						 </td>';
						 
						 $output .='<td style="text-align:center;">';
							   $image = $row['signature_img'];
							   if(!empty($image)){
							   $output .=  '<img style="width: 90px;" src="./assets/pi_images/'.$image.'">	';
							   }else{
								   //$output .= '<text style="color: #615e5e; font-size:11px;">For '.$this->session->userdata('company_name').' (signature)</text>';
							   }
						 $output .= '</td>';
								   $output .= '</tr>
								   
						   
						 </tbody>
					   </table>';
					   
						
			   
					 $output .='</main>
			   
					 </body>
					 </html>';
			 //return $output;
			 
			   }
			   //echo $output; exit;
			   //print_r($output); die;
			 $this->load->library('pdf');
			 $this->dompdf->loadHtml($output);
			 ini_set('memory_limit', '128M');
			 $this->dompdf->render();
			 $canvas = $this->dompdf->getCanvas();
			 $pdf = $canvas->get_cpdf();
	   
			 foreach ($pdf->objects as &$o) {
			   if ($o['t'] === 'contents') {
				   $o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
			   }
			 }
			 
			 if(isset($_GET['dn']) && $_GET['dn']==1){
			   $this->dompdf->stream("DebitNote".$id.".pdf", array("Attachment"=>1));  
			 }else{
			   $this->dompdf->stream("DebitNote".$id.".pdf", array("Attachment"=>0));  
			 }
			 
			 
	}
// <-------------------------------------------- Debit Note end ---------------------------------------------------------->



// <--------------------------------------------  Start Delivery challan ------------------------------------------------>

		public function get_challan_graph(){ 
			$data['grouped_data'] = $this->Base_model->getchallangraph();
			// print_r($data);die;
			$response = [
				'status' => 'success',
				'data' => $data['grouped_data']  // Corrected variable name
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($response));

		}

		public function deliverychallan()
		{
			$data['user'] = $this->Login_model->getusername();
			$data['admin'] = $this->Login_model->getadminname();
			$this->load->view('accounting/deliverychallan' ,$data);
		}

		// public function add_deliverychallan()
		// {
		// 	$id=$this->input->post('invoicenum');
		// 	$cond=['invoice_no'=>$id];
		// 	$data['invoiceid'] = $this->Invoice_model->getinvoicedata($cond)->result_array();
		// 	redirect('add-deliverychallan/'.$data['invoiceid'][0]['id']);
		// }


		public function add_deliverychallan()
		{
			if ($this->input->is_ajax_request()) {
				$id=$this->input->post('invoicenum');
				$cond=['invoice_no'=>$id];
				$invoice_data = $this->Invoice_model->getinvoicedata($cond)->result_array();

				if (!empty($invoice_data)) {
					$response = array(
						'success' => true,
						'invoice_id' => $invoice_data[0]['id']
					);
					echo json_encode($response);
				} else {
					$response = array(
						'success' => false,
						'message' => 'Invoice not found'
					);
					echo json_encode($response);
				}
			} else {
				echo "Invalid request";
			}
		}


		public function loaddeliverychallan_view()
		{
			if($this->session->userdata('email'))
			{
				if(checkModuleForContr('Generate Invoicing')<1){
					redirect('home');
					exit;
				} 

				if(check_permission_status('Invoice','create_u')==true){
					$data['branch_details'] 	= $this->Invoice_model->get_branch();
					$data['customer_details']   = $this->Invoice_model->get_organization_bytype(); 
					$data['invoice_terms'] 		= $this->Invoice_model->getall_terms();
					$data['declaration'] 		= $this->Invoice_model->get_declaration();
					$id=$this->uri->segment(2);
					
					

					if(isset($_GET['so']) && $_GET['so']!=""){
						$data['record'] = $this->Salesorders->get_data_for_update($_GET['so']);
					
						$data['action']=array('data'=>'add','from'=>'quotation');
						
					}else if(isset($id) && $id!=""){
						$data['record'] = $this->Invoice_model->get_data_for_update($id);
						
						$isdelivery_exists=$this->Base_model->deliverychallan_exists($id);
						
						if($isdelivery_exists['delete_status']==1){
							$delivery_no = $this->Base_model->delivery_no($id);
							$data['creditnotenum'] = $delivery_no->deliverychallan_no;
						
								$data['action']=array('data'=>'update','from'=>'salesorder');
							}else{
						
								$creditnoteid=$data['creditnoteid']=$this->Base_model->getlast_delivery_id('MAX(id) as lastid','deliverychallan')->row_array();
							
								if(isset($creditnoteid['lastid'])){
								$lastcreditnote = $creditnoteid['lastid']+1;
							
								}else{
								$lastcreditnote = 1;
							}
							$data['creditnotenum']=generateserialnum($lastcreditnote,'deliverychallan','deliverychallan_no');
						
						}
					}else{
					
						$data['action']=array('data'=>'add','from'=>'direct');
					}
					
					$data['gstPer']     = $this->Salesorders->get_gst();
				
				
					// print_r($data);die;
					$this->load->view('accounting/add-deliverychallan',$data);
					
				}else{
					redirect("permission");
				}			
			
			}else{
				redirect('login');
				}		
		}

	   public function add_deliveryDetails() 
	   {
			
		// $validation = $this->check_validation();
		if(1==200){
		  echo $validation;die;
		  
		}else{
			
			if($this->input->post('igst')!=""){
				$igst=implode("<br>", $this->input->post('igst'));
			}else{ $igst=''; }
			if($this->input->post('cgst')!=""){
				$cgst=implode("<br>", $this->input->post('cgst'));
			}else{ 	$cgst=''; }
			if($this->input->post('sgst')!=""){
				$sgst=implode("<br>", $this->input->post('sgst'));
			}else{ $sgst=''; }
			
			if($this->input->post('discount_price')!=""){
				$discount_price=implode("<br>", $this->input->post('discount_price'));
			}else{ $discount_price=''; }
			
			if($this->input->post('terms_condition')){
				$terms_condition=implode("<br>",$this->input->post('terms_condition'));
			}else{ $terms_condition=''; }
			if($this->input->post('extra_charge')!=""){
				$extra_charge=implode("<br>", $this->input->post('extra_charge'));
			}else{ $extra_charge=''; }
			if($this->input->post('extra_chargevalue')!=""){
				$extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
			}else{ $extra_chargevalue=''; }	
			if($this->input->post('label')){
				$lable=implode("<br>",$this->input->post('label'));
			}else{ $lable='';}
			if($this->input->post('label_value')){
				$label_value=implode("<br>",$this->input->post('label_value'));
			}else{ $label_value='';}
			if($this->input->post('product_desc')){
				$product_desc=implode("<br>",$this->input->post('product_desc'));
			}else{ $product_desc=''; }
		   
		   if($this->input->post('sub_total_with_gst')){
				$sub_totalwithgst=implode("<br>",$this->input->post('sub_total_with_gst'));
			}else{ $sub_totalwithgst=''; }
		   
		   
		  $unit_price 		= str_replace(",", "",$this->input->post('unit_price'));
		  $total 			= str_replace(",", "",$this->input->post('total'));
		  $after_discount 	= str_replace(",", "",$this->input->post('after_discount'));
		  $initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
		  $total_discount 	= str_replace(",", "",$this->input->post('discount'));
		  $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
		  
			$advanced_payment = str_replace(",", "",$this->input->post('advance_payment'));
			if($advanced_payment==""){
				$advanced_payment=0;
			}
			$pendingPayment=$sub_total-$advanced_payment;
			
		  $org_name = $this->input->post('customer_name');
		  $org_id = $this->input->post('customer_id');
		   
		  
		  $creditnotedata = array(
			'sess_eml' 			=> $this->session->userdata('email'),
			'session_company' 	=> $this->session->userdata('company_name'),
			'session_comp_email'=> $this->session->userdata('company_email'),
			'saleorder_id' 		=> $this->input->post('saleorder_id'),
			'so_owner' 			=> $this->input->post('supplier'),
			'owner' 			=> $this->input->post('owner'),
			'deliverychallan_no'     => $this->input->post('deliverychallan_no'),
			'deliverychallan_date'   => $this->input->post('deliverychallan_date'),
			'cust_order_no'		=> $this->input->post('order_no'),
			'invoice_date' 		=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
			'due_date' 			=> date('Y-m-d',strtotime($this->input->post('invoice_dueDate'))),
			'inv_terms' 		=> $this->input->post('terms_select'),
			'extra_field_label' => $lable,
			'extra_field_value' => $label_value,
			'org_name' 	    	=> $org_name,
			'cust_id' 	    	=> $org_id,
			'invoice_declaration'=> $this->input->post('invoice_declaration'),
			'branch_id'   		=> $this->input->post('shipto'),
			//'discount_type' 	=> $this->input->post('sel_disc'),
			//'discount' 	    => $this->input->post('discount'),
			'notes' 			=> $this->input->post('notes'),
			//'attachment' 		=> $attachment,
			//'signature_img' 	=> $signature_img,
			'pro_description' 	=> $product_desc,		
			'enquiry_email' 	=> $this->input->post('enquiry_email'),
			'enquiry_mobile' 	=> $this->input->post('enquiry_mobile'),
			'jurisdiction' 		=> $this->input->post('jurisdiction'),
			'late_charge' 		=> $this->input->post('late_charge'),
			'product_name' 		=> implode("<br>",$this->input->post('product_name')),
			'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
			'gst' 				=> implode("<br>",$this->input->post('gst')),
			'quantity' 			=> implode("<br>",$this->input->post('quantity')),
			'unit_price' 		=> implode("<br>",$unit_price),
			'pro_discount' 		=> $discount_price,
			'total' 			=> implode("<br>",$total),
			'sgst' 				=> $sgst,
			'igst' 				=> $igst,
			'cgst' 				=> $cgst,
			'type' 				=> $this->input->post('type'),
			'sub_total_with_gst'=> $sub_totalwithgst,
			'extra_charge_label'=> $extra_charge,
			'extra_charge_value'=> $extra_chargevalue,
			'terms_condition' 	=> $terms_condition,
			'total_discount' 	=> $total_discount,
			'initial_total' 	=> $initial_total,        
			'sub_total' 		=> $sub_total,
			'total_igst' 		=> str_replace(",", "",$this->input->post('total_igst')),
			'total_cgst' 		=> str_replace(",", "",$this->input->post('total_cgst')),
			'total_sgst' 		=> str_replace(",", "",$this->input->post('total_sgst')),
			'advanced_payment' 	=> $advanced_payment,
			'pending_payment' 	=> $pendingPayment,
			'invoice_id'     => $this->input->post('invc_id')	        
	
		  );
		
		  	// print_r($creditnotedata);die;
			$insertdata=$this->Base_model->insert_delivery_data('deliverychallan',$creditnotedata);
			$response=array();
			if($insertdata == 1){
				$response['success'] = true;
				$response['message'] = "Data inserted successfully";
			}
			echo json_encode($response);
		  
		}
	   }
	
	   public function update_deliveryDetails()
	   {
		// $validation = $this->check_validation();
		
		if(1==200){
			 echo $validation;die;
		  
			}else{
			
			if($this->input->post('igst')!=""){
				$igst=implode("<br>", $this->input->post('igst'));
			}else{ $igst=''; }
			if($this->input->post('cgst')!=""){
				$cgst=implode("<br>", $this->input->post('cgst'));
			}else{ 	$cgst=''; }
			if($this->input->post('sgst')!=""){
				$sgst=implode("<br>", $this->input->post('sgst'));
			}else{ $sgst=''; }
			
			if($this->input->post('discount_price')!=""){
				$discount_price=implode("<br>", $this->input->post('discount_price'));
			}else{ $discount_price=''; }
			
			if($this->input->post('terms_condition')){
				$terms_condition=implode("<br>",$this->input->post('terms_condition'));
			}else{ $terms_condition=''; }
			if($this->input->post('extra_charge')!=""){
				$extra_charge=implode("<br>", $this->input->post('extra_charge'));
			}else{ $extra_charge=''; }
			if($this->input->post('extra_chargevalue')!=""){
				$extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
			}else{ $extra_chargevalue=''; }	
			if($this->input->post('label')){
				$lable=implode("<br>",$this->input->post('label'));
			}else{ $lable='';}
			if($this->input->post('label_value')){
				$label_value=implode("<br>",$this->input->post('label_value'));
			}else{ $label_value='';}
			if($this->input->post('product_desc')){
				$product_desc=implode("<br>",$this->input->post('product_desc'));
			}else{ $product_desc=''; }
		   
		   if($this->input->post('sub_total_with_gst')){
				$sub_totalwithgst=implode("<br>",$this->input->post('sub_total_with_gst'));
			}else{ $sub_totalwithgst=''; }
		   
		   
		  $unit_price 		= str_replace(",", "",$this->input->post('unit_price'));
		  $total 			= str_replace(",", "",$this->input->post('total'));
		  $after_discount 	= str_replace(",", "",$this->input->post('after_discount'));
		  $initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
		  $total_discount 	= str_replace(",", "",$this->input->post('discount'));
		  $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
		  
			$advanced_payment = str_replace(",", "",$this->input->post('advance_payment'));
			if($advanced_payment==""){
				$advanced_payment=0;
			}
			$pendingPayment=$sub_total-$advanced_payment;
			
		  $org_name = $this->input->post('customer_name');
		  $org_id = $this->input->post('customer_id');
		  $invoice_update_id = $this->input->post('id');
		   
		  
		  $creditnotedata = array(
			'invoice_id'        => $invoice_update_id,
			'sess_eml' 			=> $this->session->userdata('email'),
			'session_company' 	=> $this->session->userdata('company_name'),
			'session_comp_email'=> $this->session->userdata('company_email'),
			'saleorder_id' 		=> $this->input->post('saleorder_id'),
			'so_owner' 			=> $this->input->post('supplier'),
			'owner' 			=> $this->input->post('owner'),
			'deliverychallan_no'     => $this->input->post('deliverychallan_no'),
			'deliverychallan_date'   => $this->input->post('deliverychallan_date'),
			'cust_order_no'		=> $this->input->post('order_no'),
			'invoice_date' 		=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
			'due_date' 			=> date('Y-m-d',strtotime($this->input->post('invoice_dueDate'))),
			'inv_terms' 		=> $this->input->post('terms_select'),
			'extra_field_label' => $lable,
			'extra_field_value' => $label_value,
			'org_name' 	    	=> $org_name,
			'cust_id' 	    	=> $org_id,
			'invoice_declaration'=> $this->input->post('invoice_declaration'),
			'branch_id'   		=> $this->input->post('shipto'),
			//'discount_type' 	=> $this->input->post('sel_disc'),
			//'discount' 	    => $this->input->post('discount'),
			'notes' 			=> $this->input->post('notes'),
			//'attachment' 		=> $attachment,
			//'signature_img' 	=> $signature_img,
			'pro_description' 	=> $product_desc,		
			'enquiry_email' 	=> $this->input->post('enquiry_email'),
			'enquiry_mobile' 	=> $this->input->post('enquiry_mobile'),
			'jurisdiction' 		=> $this->input->post('jurisdiction'),
			'late_charge' 		=> $this->input->post('late_charge'),
			'product_name' 		=> implode("<br>",$this->input->post('product_name')),
			'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
			'gst' 				=> implode("<br>",$this->input->post('gst')),
			'quantity' 			=> implode("<br>",$this->input->post('quantity')),
			'unit_price' 		=> implode("<br>",$unit_price),
			'pro_discount' 		=> $discount_price,
			'total' 			=> implode("<br>",$total),
			'sgst' 				=> $sgst,
			'igst' 				=> $igst,
			'cgst' 				=> $cgst,
			'type' 				=> $this->input->post('type'),
			'sub_total_with_gst'=> $sub_totalwithgst,
			'extra_charge_label'=> $extra_charge,
			'extra_charge_value'=> $extra_chargevalue,
			'terms_condition' 	=> $terms_condition,
			'total_discount' 	=> $total_discount,
			'initial_total' 	=> $initial_total,        
			'sub_total' 		=> $sub_total,
			'total_igst' 		=> str_replace(",", "",$this->input->post('total_igst')),
			'total_cgst' 		=> str_replace(",", "",$this->input->post('total_cgst')),
			'total_sgst' 		=> str_replace(",", "",$this->input->post('total_sgst')),
			'advanced_payment' 	=> $advanced_payment,
			'pending_payment' 	=> $pendingPayment	        
	
		  );
		// print_r($creditnotedata);die;
	
			$invoice_id=$this->Base_model->deliverychallan_exists($invoice_update_id);
			// print_r($invoice_id);die;
			if($invoice_id === $invoice_update_id){
				$response=array();
					$response['success'] = false;
					$response['message'] = "Data already exit";
				
					echo json_encode($response);
			}else{
				// print_r($invoice_update_id);die;
				$updatedata=$this->Base_model->update_delivery($invoice_update_id ,$creditnotedata);
				$response=array();
				if($updatedata == 1){
					$response['success'] = true;
					$response['message'] = "Data update successfully";
				}
				echo json_encode($response);
			}
		  
		}
	   }


		public function get_deliverychallan()
		{
			$delete_inv	=0;
			$update_inv	=0;
			$retrieve_inv=0; 
			if(check_permission_status('Invoice','delete_u')==true){
				$delete_inv=1;
			}
			if(check_permission_status('Invoice','retrieve_u')==true){
				$retrieve_inv=1;
			}
			if(check_permission_status('Invoice','update_u')==true){
				$update_inv=1;
			}
			
			
			$list = $this->Base_model->getdata_delivery_challan();
			$data = array();
			$no = $_POST['start'];
			$output = "";
			$i =1;
			foreach ($list as $item) {
				$ino_id = $item['invoice_id'];
				$list_ino = $this->Base_model->get_ino_debit_no($ino_id);

				$encrypted_id 	= base64_encode($item['invoice_id']);
				$sessionEmail 	= base64_encode($this->session->userdata('company_email'));
				$sessionCompany	= base64_encode($this->session->userdata('company_name'));

				$row=[];
				
					
						$row[].= $i++;
					$row[].=$item['deliverychallan_date'];
					$row[] = "<span style='color: rgba(140, 80, 200, 1);font-weight: 700;'>{$item['deliverychallan_no']}</span>";
					$row[] = "<span style='color: rgba(140, 80, 200, 1);font-weight: 700;'>{$list_ino['invoice_no']}</span>";

					$row[].=$item['org_name'];
					$row[].=$item['currentdate'];
					$row[].=$item['sub_total'];
					//    $row[].='<a href="#">Created</a>';
					//    $row[].=$list_ino['invoice_no'];
					//    $row[].=$list_ino['invoice_date']; 
					$row[].=$item['']; 
					$row[].=$item['']; 
					$row[].=$item['session_company'];
					//    $row[].=$item['owner']; 
					$row[].=$item['pending_payment']; 
					
					
					$row[]="<a style='text-decoration:none'href='" . base_url('view-deliverychallan').'?inv_id='.urlencode($encrypted_id).'&cnp='.urlencode($sessionCompany). '&ceml='.urlencode($sessionEmail)."'  class='text-success border-right'><i class='far fa-eye sub-icn-opp m-1' data-toggle='tooltip' data-container='body' title='View Delivery Challan Details' ></i></a> 

						<a style='text-decoration:none' href='" . base_url('add-deliverychallan/') . $item['invoice_id'] . "' class='text-primary border-right'> <i class='far fa-edit sub-icn-so m-1' data-toggle='tooltip' data-container='body' title='Update Delivery Challan Details' ></i></a>
						

					<a style='text-decoration:none' href='javascript:void(0)'  onclick='delete_deliverychallan(" . $item['invoice_id'] . ")' class='text-danger'>
					<i class='far fa-trash-alt text-danger m-1'  data-toggle='tooltip' data-container='body' title='Delete Delivery Challan' ></i></a></td> 
					
					</tr>";
					

				$data[]=$row;
			}
			$i++;
			
			
			$action = [
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Base_model->count_all_delivery(),
				"Totalamount" => $this->Base_model->count_Total_delivery(),

				"recordsTotal" =>$this->Base_model->count_all_del(),
				 "recordsFiltered" => $this->Base_model->count_filtered_del(),
				"data" => $data, // Store the HTML table rows directly, no need for an array
			];

			// print_r($action);die;
			echo json_encode($action);

		} 

		public function view_load_deliverychallan() 
		{
			if($this->session->userdata('email')){
				if(checkModuleForContr('Generate Invoicing')<1){
					redirect('home');
				}
				if(check_permission_status('Invoice','retrieve_u')==true){
			
				$id = base64_decode($_GET['inv_id']);
				$decoded_ceml = base64_decode( $_GET['ceml']);
				$decoded_cnp = base64_decode( $_GET['cnp']);

				if (isset($id)) {
					$data['inov_no']=$this->Base_model->get_ino_no($id);
				}

				$data['view_deliverychallan']= $this->Base_model->get_deliverychallan_by_id($id,$decoded_cnp,$decoded_ceml);
				
				$data['bank_details_terms'] = $this->Base_model->get_bank_detailss();
				
				if($data['view_deliverychallan']['id']){
					$data['otherdata'] =array();
					$data['branch'] = $this->Base_model->debit_get_Branch_Data($data['view_deliverychallan']['branch_id']);
					$data['clientDtl'] = $this->Base_model->debit_get_org_by_id($data['view_deliverychallan']['cust_id']);
					$this->load->view('accounting/view_deliverychallan' ,$data);
					
				}
					
				}else{
					redirect("permission");
				}
				}else{
					redirect('login');		
				}
		}

		public function deliverychallan_delete($id) 
		{
			$delete=$this->Base_model->delete_deliverychallan_id($id);
			if($delete){
				echo json_encode(array("status" => TRUE));
			}
	
		}

		public function generate_pdf_deliverychallan()
		{
			
		
			$id = base64_decode($_GET['inv_id']);
			$decoded_cnp = base64_decode( $_GET['cnp']);
			$decoded_ceml = base64_decode( $_GET['ceml']);
			//  print_r($id);die;
		
				$row= $this->Base_model->get_deliverychallan_by_id($id,$decoded_cnp,$decoded_ceml);
				$inov_no=$this->Base_model->get_ino_no($id);
			
			
			if($row['id']){

				$rowOwner = $this->Base_model->get_Owner_debit($row['sess_eml']);
				if(empty($rowOwner['standard_name'])){
					$rowOwner = $this->Base_model->get_Admin_debit($row['sess_eml']);
				
				}

				$compnyDtail= $this->Base_model->get_Comp_debit($row['session_comp_email']);
			
				$branch = $this->Base_model->getBranchData_debit($row['branch_id']); 
			
				$clientDtl = $this->Base_model->getorg_by_id_debit($row['cust_id']);
			
				$bank_details_terms = $this->Base_model->get_bank_detailss();
			//    print_r($bank_details_terms);die;
			
			$output = '<!DOCTYPE html>
					<html>
					<head>
						<title>Team365 | Debit Note</title>
						<link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
						<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
					<style>
						@page{
							margin-top: 10px; /* create space for header */
							}
						footer .pagenum:before {
							content: counter(page, decimal);
							}
						</style>
					</head>
				
					<body style="font-family: Quicksand, sans-serif;">';
						if($row['declaration_status'] == 1) {  
						$output .= '<footer style="position: fixed;  bottom: 110;border-top:0.5px solid #333; " >';
						}else{
							
						$output .= '<footer style="position: fixed;  bottom: 80;border-top:0.5px solid #333; " >';
						}
						
						$output .= ' <table style="font-size:11px; width:100%; text-align:center;">';
							
							
							if($row['declaration_status'] == 1) {   
							$output .= '<tr>
								<td style="font-size:10px;">
								<text><b>Declaration:-</b></text>
								'.$row['invoice_declaration'].'
								</td>
							</tr>';
							}
							if($row['jurisdiction']!="") {  
							$output .= ' <tr>
								<td style="font-size:10px;"><b>"SUBJECT TO '.strtoupper($row['jurisdiction']).' JURISDICTION"</b></td>
							</tr>';
							}
							if($row['late_charge']!="") {  
							$output .= '  <tr>
								<td style="font-size:10px;">INTEREST@ '.$row['late_charge'].'% P.A WILL BE CHARGED IF THE PAYMENT IS NOT MADE WITHIN THE STIPULATED TIME.</td>
							</tr>';
							}
							$output .= '  <tr>
								<td><div class="pagenum-container"style="text-align:right;font-size:10px; border-top:1px dashed #333; ">Page <span class="pagenum"></span></div></td>
							</tr>
							<tr>
								<td><b>"This is system generated  Debit Note, Sign and stamp not required"</b></td>
							</tr>
							<tr>
								<td><b><span style="font-size: 10px;">E-mail - '.$branch['branch_email'].'</br>
							| Ph. - +91-'.$branch['contact_number'].'</br>
							| GSTIN: '.$branch['gstin'].'</br>
							| CIN: '.$branch['cin'].'</span></b><br>
							<b><span style="font-size:11px;">Powered By <a href="https://team365.io/">Team365 CRM</a></span></b> </td>
							</tr>
						</table>
						
						
						</footer>
					
					<main style="margin-bottom:10px;">
					<table width="100%" style="max-width:800px; background:#fff;">
						<tbody>
							<tr>
							<td style="width:35%; vertical-align: top;">
								<table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
								<tr>
									<td colspan="2"><text style="color: #6539c0;font-size:13px;"><b>Tax  Credit Note</b></text></td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;" > Credit Note No.</td><td>'.$row['deliverychallan_no'].'</td> 
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;" > Invoice No.</td><td>'.$inov_no['invoice_no'].'</td> 
									</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Credit Note Date.</td><td>'.date("d F Y", strtotime($row['deliverychallan_date'])).'</td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Terms</td><td>';
								if($row['inv_terms'] == 'end_of_month') { 
									$output .= 'Due end of month';
								}else if($row['inv_terms'] == 'end_next_month'){
									$output .= 'Due end of next month';
								}else if($row['inv_terms'] == 'due_receipt'){
									$output .= 'Due on reciept';
								}else if($row['inv_terms'] == 'custom'){
									$output .= 'Custom';
								}else{
									$output .= $row["inv_terms"];
								}		
								$output .= '</td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Due Date</td><td>'.date("d F Y", strtotime($row['due_date'])).'</td>
								</tr>
								</table>
							</td>
							<td style="text-align:left; width:35%; padding-top:15px; vertical-align: top; ">
							
								<table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
								<tr><td colspan="2"></td></tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Supplier'."'".'s Ref:</td><td>'.$row['so_owner'].'</td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Other Reference(s):</td><td>'.$row['owner'].'</td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Buyer'."'".'s Order No.:</td><td>'.$inov_no['cust_order_no'].'</td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Buyer'."'".'s Order Date:</td><td>'.date("d F Y", strtotime($inov_no['buyer_date'])).'</td>
								</tr>
								</table>
							
							</td>
							<td style="text-align:right; width:30%;">';
								$image = $compnyDtail['company_logo'];
									if(!empty($image))
									{
									$output .=  '<img style="width: 70px;" src="./uploads/company_logo/'.$image.'">';
									}
									else
									{
									$output .=  '<span class="h5 text-primary">'.$compnyDtail['company_name'].'</span>';
									}
									$output .= '
								</td>
							</tr>
							</tbody>
							</table>
							<table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
							
								<tr>
								
								<td style="width: 49.5%; padding: 2px 10px 4px 10px; vertical-align: top;">
									<h5 style="margin-top: 0px;margin-bottom: 2px;color: #6539c0;">Debit Note From</h5>
									<p style="margin: 0;font-size: 12px;">'.$branch['company_name'].'</p>
								';
								if($branch["address"]!=""){
								$output .=' <p style="margin: 0;font-size: 11px;">'.$branch["address"];
								}
								if($branch["city"]!=""){
								$output .=  ', '.$branch["city"];
								}
								if($branch["zipcode"]!=""){
								$output .=  ' - '.$branch["zipcode"];
								}
								if($branch["state"]!=""){
								$output .=  ', '.$branch["state"];
								}
								
								if($branch["country"]!=""){
								$output .=  ', '.$branch["country"];
								}
								$output .=  '</p>';
								if($branch["gstin"]!=""){
								$output .=  '<p style="margin: 0;font-size: 11px;"><b>GSTIN:</b> '.$branch["gstin"].'</p>';
								}
								if($branch["branch_email"]!="" && $branch["show_email"]== 1){
								$output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">'.$branch["branch_email"].'</p>';
								}
								if($branch["contact_number"]!=""){
								$output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">+91-'.$branch["contact_number"].'</p>';
								}
								$output .=  ' </td>
								
								<td style="width: 1%;background:#fff;"></td>
								
								<td style="width: 49.5%; padding:0px 10px 4px 10px; vertical-align: top;">
									<h5 style="margin-top: 0px;margin-bottom: 0px;color: #6539c0;">Debit Note To</h5>
								<p style="margin: 0;font-size: 12px;">'.
								$clientDtl->org_name.'</p>';
								if(!empty($clientDtl->primary_contact)){
								$output .= '<p style="margin: 0;font-size: 11px;">
									<b>Contact Name :</b> '.$clientDtl->primary_contact.'</p>';
								}
								$output .= '
								<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">';
								
								if(!empty($clientDtl->shipping_address)){
								$output .= $clientDtl->shipping_address;
								}
								if(!empty($clientDtl->shipping_city)){
								$output .= ', '.$clientDtl->shipping_city;
								}
								if(!empty($clientDtl->shipping_zipcode)){
								$output .= ' - '.$clientDtl->shipping_zipcode;
								}
								if(!empty($clientDtl->shipping_state)){
								$output .= ', '.$clientDtl->shipping_state;
								}
								if(!empty($clientDtl->shipping_country)){
								$output .= ', '.$clientDtl->shipping_country;
								}
								$output .= '</p>';
								
								if(!empty($clientDtl->gstin!="")){
								$output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>GSTIN:</b> '.$clientDtl->gstin.'</p>';
								}
									if(isset($clientDtl->email)){
								$output .= '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>Email:</b>'.$clientDtl->email.' <br>
								<b>Phone:</b> +91-'.$clientDtl->mobile.'</p>';
									}
							$output .= '</td>
								
							</tr>
						</table>
						<!--<table width="100%" style="max-width:800px; background:#fff;">
						<tbody>
							<tr>
							<td align="left" style="font-size:12px;width: 49.5%;">
								<p><b>Country of Supply : </b>'.$clientDtl->shipping_country.'</p>
							</td>
							<td></td>
							<td align="left" style="font-size:12px;width: 49.5%;">
								<p><b>Place of Supply : </b>'.$clientDtl->shipping_state.'</p>
							</td>
							</tr>
						</tbody>
						</table>-->
				
						<table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; margin-top:10px; border-radius: 7px; background: #efebf9;">
						<thead style="color: #fff;" align="left">';
						
								$igsttotal=0;
								$sgsttotal=0;
								$cgsttotal=0;
								
								$igst = explode("<br>",$row['igst']);
								$sgst = explode("<br>",$row['sgst']);
								$cgst = explode("<br>",$row['cgst']);
								$proDiscount = explode("<br>",$row['pro_discount']);
								$totalDiscount=array_sum($proDiscount);
						
							$output .= '<tr>
							<th width="3%" style="font-size: 11px;">
								<div style="background: #6539c0;border-top-left-radius: 7px;  padding: 6px;">
							S.No.</div></th>
							<th width="18%" style="font-size: 11px; background: #6539c0;">
							Product/Services</th>
							<th style="font-size: 11px; background: #6539c0;">HSN/SAC</th>
							
							<th style="font-size: 11px; background: #6539c0;">Qty</th>
							<th style="font-size: 11px; background: #6539c0;">Tax</th>
							<th style="font-size: 11px; background: #6539c0;">Rate</th>';
							if($totalDiscount>0){
							$output .= '<th style="font-size: 11px; background: #6539c0;">Discount</th>';
							}
								$output .= '<th style="font-size: 11px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 6px;">Tot. Price</div></th>
							</tr>
						</thead>
						<tbody >';
						
								$product_name = explode("<br>",$row['product_name']);
								$quantity = explode("<br>",$row['quantity']);
								$unit_price = explode("<br>",$row['unit_price']);
								$total = explode("<br>",$row['total']);
								$total_withgst = explode("<br>",$row['sub_total_with_gst']);
								$hsnsac = explode("<br>",$row['hsn_sac']);
								$after_discount = ($row['initial_total']-$row['total_discount']);
								if(!empty($row['gst'])){
								$gst = explode("<br>",$row['gst']);
								}
								$proDesc = explode("<br>",$row['pro_description']);
								
								
								$arrlength = count($product_name);
								$rw=0;
								$sr=1;
								for($x = 0; $x < $arrlength; $x++){
									$rw++;
									$num = $x + 1;
									
									if(isset($igst[$x]) && $igst[$x]!=""){
										$igsttotal=$igsttotal+$igst[$x];
									}
									if(isset($sgst[$x]) && $sgst[$x]!=""){
										$sgsttotal=$sgsttotal+$sgst[$x];
									}
									if(isset($igst[$x]) && $cgst[$x]!=""){
										$cgsttotal=$cgsttotal+$cgst[$x];
									}
						
									
									$output .='<tr>
										<td style="font-size: 11px;padding: 5px 10px;">'.$sr.'</td>
										<td style="font-size: 11px;padding: 5px 10px;">'.$product_name[$x].'</td>
										
										<td style="font-size: 11px;padding: 5px 10px;">'.$hsnsac[$x].'</td>
										
										<td style="font-size: 11px;padding: 5px 10px;">'.$quantity[$x].'</td>
										<td style="font-size: 11px;padding: 5px 10px;">GST@'.$gst[$x].'%</td>
										<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($unit_price[$x]).'</td>';
										if($totalDiscount>0){
										$output .='<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($proDiscount[$x]).'</td>';
										}
										$output .='<td style="font-size: 11px;padding: 5px 10px; "><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($total[$x]).'</td>
									</tr>';
									if(isset($proDesc[$x]) && $proDesc[$x]!=""){	
									$output.='<tr>
											<td style="font-size: 11px; padding:5px 10px;"></td>
											<td colspan="6" style="font-size: 11px; padding:5px 10px;">'.$proDesc[$x].'</td></tr>';
									}
								$sr++;
								}
								
								$output .='
						</tbody>
						</table>
				
						<table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
						<tbody>
							<tr>
							<td align="left" width="60%" style="position: relative;">
							<p style="font-size:12px; margin-top:0px; margin-bottom:8px;"><b style="font-size:12px;">Total in words:</b> <text style="font-size:11px;"> '.AmountInWords($row["sub_total"]).' only</text></p>';
							if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){
					
								$output .='<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a;font-size:11px;">
									<tr>
										<td colspan="3">
											<h5 style="margin: 0px 0px 0px 8px; color: #6539c0; font-size:12px;">Bank Details</h5>
										</td>
									</tr>
									<tr style="line-height: 0.8;">
										<th style="text-align:left; padding-left:10px;">Account Holder Name:  <th>
										<td>'.ucfirst($bank_details_terms->acc_holder_name).'</td>
									</tr>
									<tr style="line-height: 0.8;">
										<th style="text-align:left; padding-left:10px;">  Account Number:  <th>
										<td>'.$bank_details_terms->account_no.'</td>
									</tr>
									<tr style="line-height: 0.8;">
										<th style="text-align:left; padding-left:10px;">  IFSC:  <th>
										<td>'.$bank_details_terms->ifsc_code.'</td>
									</tr>
									<tr style="line-height: 0.8;">
										<th style="text-align:left; padding-left:10px;"> Account Type:  <th>
										<td>'.ucfirst($bank_details_terms->account_type).'</td>
									</tr>
									<tr style="line-height: 0.8;">
										<th style="text-align:left; padding-left:10px;"> Bank Name: <th>
										<td>'.ucfirst($bank_details_terms->bank_name).'</td>
									</tr><tr style="line-height: 0.8;">';
									
										if($bank_details_terms->upi_id!=""){
										$output .= '<th style="text-align:left;  padding-left:10px;">UPI Id:<th>
										<td>'.$bank_details_terms->upi_id.'</td>';
										}
										if(isset($_GET['dn']) && $_GET['dn']==1){
										$output .= '<th style="text-align:left;padding-left:10px;"><a href="'.base_url("home").'" style="text-decoration:none; background:#6539c0; color:#fff; font-size:10px; padding:4px; display:inline-block; border-radius:3px;">Pay Now</a></th>';
										}
										
										$output .= '</tr>
									</table>';
						
						}  
						
							$output .='</td>
							<td align="" width="40%" style="text-align:right;">
							<table align="" width="100%" style="text-align:right;position: absolute;top: 0px;">
								<tbody>
								<tr>
									<th style="font-size: 12px;" align="left">Initial Amount</th>
				
									<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["initial_total"]).'</td>
								</tr>';
								if($row["discount"]>0){
								$output .='<tr>
									<th style="font-size: 12px;" align="left">Discount</th>
				
									<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$row["discount"].'</td>
								</tr>';
								
								$output .='<tr>
									<th style="font-size: 12px;" align="left">After Discount</th>
				
									<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($after_discount).'</td>
								</tr>';
								}
								if($igsttotal!=0){	
									$output .='<tr><th style="font-size: 12px;" align="left">IGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($igsttotal).'</td></tr>';
								}else{
									
										if($sgsttotal!=0){	
											$output .='<tr><th style="font-size: 12px;" align="left">SGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($sgsttotal).'</td></tr>';
										}
										if($cgsttotal!=0){	
											$output .='<tr><th style="font-size: 12px;" align="left">CGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($cgsttotal).'</td></tr>';
										}
									}
									if($row['extra_charge_label']!=""){
									$extraCharge_name=explode("<br>",$row['extra_charge_label']);
									$extraCharge_value=explode("<br>",$row['extra_charge_value']);
									for($y=0; $y<count($extraCharge_name); $y++){	
										$output .='<tr><th style="font-size: 12px;" align="left">'.$extraCharge_name[$y].'</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($extraCharge_value[$y]).'</td></tr>';
									}
									}
											
								$output .='
								<tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
								<tr>
								
									<th style="font-size: 12px;" align="left">TOTAL</th>
				
									<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["sub_total"]).'</td>
								</tr>
								</tbody>
								
							</table>
							</td>
						</tr>
						</tbody>
						</table>';
				
						$output .='<table width="100%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-bottom:30px margin-top:';
							if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){ 
								$output .='0px;">';
								
							}else{ 
								$output .='-20px;">'; 
								
							}
							$output .='<tbody>
							<tr>
						<td align="left" style="width:60%; padding:1px;">
							<h5 style="color: #6539c0;margin: 0px;">Terms and conditions</h5>
							<ol style="padding: 0 8px; font-size:11px; margin: 1px;">';
							$custTerm=explode("<br>",$row["terms_condition"]); $no=1;
							for($i=0; $i<count($custTerm); $i++){ 
							$output .='<li>'.$custTerm[$i].'</li>'; 
							}
							//'.nl2br($row->terms_condition).'
							$output .='</ol>
						</td>';
						
						$output .='<td style="text-align:center;">';
								$image = $row['signature_img'];
								if(!empty($image)){
								$output .=  '<img style="width: 90px;" src="./assets/pi_images/'.$image.'">	';
								}else{
									//$output .= '<text style="color: #615e5e; font-size:11px;">For '.$this->session->userdata('company_name').' (signature)</text>';
								}
						$output .= '</td>';
									$output .= '</tr>
									
							
						</tbody>
						</table>';
						
						
				
					$output .='</main>
				
					</body>
					</html>';
			//return $output;
			
				}
				//echo $output; exit;
				//print_r($output); die;
			$this->load->library('pdf');
			$this->dompdf->loadHtml($output);
			ini_set('memory_limit', '128M');
			$this->dompdf->render();
			$canvas = $this->dompdf->getCanvas();
			$pdf = $canvas->get_cpdf();
		
			foreach ($pdf->objects as &$o) {
				if ($o['t'] === 'contents') {
					$o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
				}
			}
			
			if(isset($_GET['dn']) && $_GET['dn']==1){
				$this->dompdf->stream("Delivery Challan".$id.".pdf", array("Attachment"=>1));  
			}else{
				$this->dompdf->stream("Delivery Challan".$id.".pdf", array("Attachment"=>0));  
			}
			
			
		}
// <----------------------------------------------------  Delivery challan end ---------------------------------------------->


// <---------------------------------------Expenditure Start --------------------------------------------------------------->

public function get_expanse_graph(){ 
	$data['grouped_data'] = $this->Base_model->getexpansegraph();
	$response = [
		'status' => 'success',
		'data' => $data['grouped_data']  // Corrected variable name
	];
	$this->output->set_content_type('application/json')->set_output(json_encode($response));
}

	public function expansemanage()
	{
		$data['user'] = $this->Login_model->getusername();
		$data['admin'] = $this->Login_model->getadminname();
		$this->load->view('accounting/expansemanagement', $data);
	}
	
	// public function add_expanse()
	// {
	// 		$poid=$this->input->post('ponum');
	// 		$cond=['purchaseorder_id'=>$poid];
	// 		$data['purchaseorder_id'] = $this->Base_model->getpodata($cond)->result_array();
	// 		redirect('add-expanse/'.$data['purchaseorder_id'][0]['id']);
	// }

	public function add_expanse()
	{
		if ($this->input->is_ajax_request()) {
			$poid=$this->input->post('ponum');
			$cond=['purchaseorder_id'=>$poid];
			$invoice_data = $this->Base_model->getpodata($cond)->result_array();

			if (!empty($invoice_data)) {
				$response = array(
					'success' => true,
					'invoice_id' => $invoice_data[0]['id']
				);
				echo json_encode($response);
			} else {
				$response = array(
					'success' => false,
					'message' => 'Po not found'
				);
				echo json_encode($response);
			}
		} else {
			echo "Invalid request";
		}
	}




	public function expanse_view()
	{
		if($this->session->userdata('email'))
			{
				if(checkModuleForContr('Generate Invoicing')<1){
					redirect('home');
					exit;
				} 

				if(check_permission_status('Invoice','create_u')==true){
					$data['branch_details'] 	= $this->Invoice_model->get_branch();
					$data['customer_details']   = $this->Invoice_model->get_organization_bytype(); 
					$data['invoice_terms'] 		= $this->Invoice_model->getall_terms();
					$data['declaration'] 		= $this->Invoice_model->get_declaration();
					$id=$this->uri->segment(2);
					
				

					if(isset($_GET['so']) && $_GET['so']!=""){
						$data['record'] = $this->Salesorders->get_data_for_update($_GET['so']);
					
						$data['action']=array('data'=>'add','from'=>'quotation');
						
					}else if(isset($id) && $id!=""){
						$data['record'] = $this->Purchaseorders_model->get_data_for_update($id);
	
						$ispo_exists=$this->Base_model->expanse_exists($id);
						// print_r ($ispo_exists);die;
						
					
						if($ispo_exists['delete_status']==1){
							
						$po_num = $this->Base_model->expanse_data_by_po_no($id);
						$data['creditnotenum'] = $po_num->expenditure_no;
						// print_r ($data['expenditurenum']);die;
						
							$data['action']=array('data'=>'update','from'=>'salesorder');
						}else{
					
							$creditnoteid=$data['creditnoteid']=$this->Base_model->getlast_expanse_id('MAX(id) as lastid','expenditure')->row_array();
						
							if(isset($creditnoteid['lastid'])){
							$lastcreditnote = $creditnoteid['lastid']+1;
						
							}else{
							$lastcreditnote = 1;
							}
						$data['creditnotenum']=generateserialnum($lastcreditnote,'expenditure','purchaseorder_no');
						// print_r ($data['expenditurenum']);die;
						}
					}else{
					
						$data['action']=array('data'=>'add','from'=>'direct');
					}
					
					$data['gstPer']     = $this->Salesorders->get_gst();
				
				
					// print_r($data);die;
					$this->load->view('accounting/add-expanse',$data);
					
				}else{
					redirect("permission");
				}			
			
			}else{
				redirect('login');
				}		
	}

	public function add_expanseDetails() 
	{
		
	 // $validation = $this->check_validation();
	 if(1==200){
	   echo $validation;die;
	   
	 }else{
		 
		 if($this->input->post('igst')!=""){
			 $igst=implode("<br>", $this->input->post('igst'));
		 }else{ $igst=''; }
		 if($this->input->post('cgst')!=""){
			 $cgst=implode("<br>", $this->input->post('cgst'));
		 }else{ 	$cgst=''; }
		 if($this->input->post('sgst')!=""){
			 $sgst=implode("<br>", $this->input->post('sgst'));
		 }else{ $sgst=''; }
		 
		 if($this->input->post('discount_price')!=""){
			 $discount_price=implode("<br>", $this->input->post('discount_price'));
		 }else{ $discount_price=''; }
		 
		 if($this->input->post('terms_condition')){
			 $terms_condition=implode("<br>",$this->input->post('terms_condition'));
		 }else{ $terms_condition=''; }
		 if($this->input->post('extra_charge')!=""){
			 $extra_charge=implode("<br>", $this->input->post('extra_charge'));
		 }else{ $extra_charge=''; }
		 if($this->input->post('extra_chargevalue')!=""){
			 $extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
		 }else{ $extra_chargevalue=''; }	
		 if($this->input->post('label')){
			 $lable=implode("<br>",$this->input->post('label'));
		 }else{ $lable='';}
		 if($this->input->post('label_value')){
			 $label_value=implode("<br>",$this->input->post('label_value'));
		 }else{ $label_value='';}
		 if($this->input->post('product_desc')){
			 $product_desc=implode("<br>",$this->input->post('product_desc'));
		 }else{ $product_desc=''; }
		
		if($this->input->post('sub_total_with_gst')){
			 $sub_totalwithgst=implode("<br>",$this->input->post('sub_total_with_gst'));
		 }else{ $sub_totalwithgst=''; }
		
		
	   $unit_price 		= str_replace(",", "",$this->input->post('unit_price'));
	   $total 			= str_replace(",", "",$this->input->post('total'));
	   $after_discount 	= str_replace(",", "",$this->input->post('after_discount'));
	   $initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
	   $total_discount 	= str_replace(",", "",$this->input->post('discount'));
	   $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
	   
		 $advanced_payment = str_replace(",", "",$this->input->post('advance_payment'));
		 if($advanced_payment==""){
			 $advanced_payment=0;
		 }
		 $pendingPayment=$sub_total-$advanced_payment;
		 
	   $org_name = $this->input->post('customer_name');
	   $org_id = $this->input->post('customer_id');
		
	   
	   $expansedata = array(
		 'sess_eml' 			=> $this->session->userdata('email'),
		 'session_company' 	=> $this->session->userdata('company_name'),
		 'session_comp_email'=> $this->session->userdata('company_email'),
		 'saleorder_id' 		=> $this->input->post('saleorder_id'),
		 'so_owner' 			=> $this->input->post('supplier'),
		 'owner' 			=> $this->input->post('owner'),
		 'expenditure_no'     => $this->input->post('expenditure_no'),
		 'expenditure_date'   => $this->input->post('expenditure_date'),
		 'cust_order_no'		=> $this->input->post('order_no'),
		 'po_no' 		=> date('Y-m-d',strtotime($this->input->post('po_no'))),
		 'po_date' 			=> date('Y-m-d',strtotime($this->input->post('po_date'))),
		 'inv_terms' 		=> $this->input->post('terms_select'),
		 'extra_field_label' => $lable,
		 'extra_field_value' => $label_value,
		 'org_name' 	    	=> $org_name,
		 'cust_id' 	    	=> $org_id,
		 'invoice_declaration'=> $this->input->post('invoice_declaration'),
		 'branch_id'   		=> $this->input->post('shipto'),
		 //'discount_type' 	=> $this->input->post('sel_disc'),
		 //'discount' 	    => $this->input->post('discount'),
		 'notes' 			=> $this->input->post('notes'),
		 //'attachment' 		=> $attachment,
		 //'signature_img' 	=> $signature_img,
		 'pro_description' 	=> $product_desc,		
		 'enquiry_email' 	=> $this->input->post('enquiry_email'),
		 'enquiry_mobile' 	=> $this->input->post('enquiry_mobile'),
		 'jurisdiction' 		=> $this->input->post('jurisdiction'),
		 'late_charge' 		=> $this->input->post('late_charge'),
		 'product_name' 		=> implode("<br>",$this->input->post('product_name')),
		 'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
		 'gst' 				=> implode("<br>",$this->input->post('gst')),
		 'quantity' 			=> implode("<br>",$this->input->post('quantity')),
		 'unit_price' 		=> implode("<br>",$unit_price),
		 'pro_discount' 		=> $discount_price,
		 'total' 			=> implode("<br>",$total),
		 'sgst' 				=> $sgst,
		 'igst' 				=> $igst,
		 'cgst' 				=> $cgst,
		 'type' 				=> $this->input->post('type'),
		 'sub_total_with_gst'=> $sub_totalwithgst,
		 'extra_charge_label'=> $extra_charge,
		 'extra_charge_value'=> $extra_chargevalue,
		 'terms_condition' 	=> $terms_condition,
		 'total_discount' 	=> $total_discount,
		 'initial_total' 	=> $initial_total,        
		 'sub_total' 		=> $sub_total,
		 'total_igst' 		=> str_replace(",", "",$this->input->post('total_igst')),
		 'total_cgst' 		=> str_replace(",", "",$this->input->post('total_cgst')),
		 'total_sgst' 		=> str_replace(",", "",$this->input->post('total_sgst')),
		 'advanced_payment' 	=> $advanced_payment,
		 'pending_payment' 	=> $pendingPayment,
		 'po_id'     => $this->input->post('po_id')	        
 
	   );
	 
		    // print_r($expansedata);die;
		
		 $insertdata=$this->Base_model->insert_expenditure_data('expenditure',$expansedata);
			
		 $response=array();
		 if($insertdata == 1){
			 $response['success'] = true;
			 $response['message'] = "Data inserted successfully";
		 }
		 echo json_encode($response);
	   
	 }
	}
 
 
	public function update_expanseDetails()
	{
	 // $validation = $this->check_validation();
	 
	 if(1==200){
		  echo $validation;die;
	   
		 }else{
		 
		 if($this->input->post('igst')!=""){
			 $igst=implode("<br>", $this->input->post('igst'));
		 }else{ $igst=''; }
		 if($this->input->post('cgst')!=""){
			 $cgst=implode("<br>", $this->input->post('cgst'));
		 }else{ 	$cgst=''; }
		 if($this->input->post('sgst')!=""){
			 $sgst=implode("<br>", $this->input->post('sgst'));
		 }else{ $sgst=''; }
		 
		 if($this->input->post('discount_price')!=""){
			 $discount_price=implode("<br>", $this->input->post('discount_price'));
		 }else{ $discount_price=''; }
		 
		 if($this->input->post('terms_condition')){
			 $terms_condition=implode("<br>",$this->input->post('terms_condition'));
		 }else{ $terms_condition=''; }
		 if($this->input->post('extra_charge')!=""){
			 $extra_charge=implode("<br>", $this->input->post('extra_charge'));
		 }else{ $extra_charge=''; }
		 if($this->input->post('extra_chargevalue')!=""){
			 $extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
		 }else{ $extra_chargevalue=''; }	
		 if($this->input->post('label')){
			 $lable=implode("<br>",$this->input->post('label'));
		 }else{ $lable='';}
		 if($this->input->post('label_value')){
			 $label_value=implode("<br>",$this->input->post('label_value'));
		 }else{ $label_value='';}
		 if($this->input->post('product_desc')){
			 $product_desc=implode("<br>",$this->input->post('product_desc'));
		 }else{ $product_desc=''; }
		
		if($this->input->post('sub_total_with_gst')){
			 $sub_totalwithgst=implode("<br>",$this->input->post('sub_total_with_gst'));
		 }else{ $sub_totalwithgst=''; }
		
		
	   $unit_price 		= str_replace(",", "",$this->input->post('unit_price'));
	   $total 			= str_replace(",", "",$this->input->post('total'));
	   $after_discount 	= str_replace(",", "",$this->input->post('after_discount'));
	   $initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
	   $total_discount 	= str_replace(",", "",$this->input->post('discount'));
	   $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
	   
		 $advanced_payment = str_replace(",", "",$this->input->post('advance_payment'));
		 if($advanced_payment==""){
			 $advanced_payment=0;
		 }
		 $pendingPayment=$sub_total-$advanced_payment;
		 
	   $org_name = $this->input->post('customer_name');
	   $org_id = $this->input->post('customer_id');
	   $invoice_update_id = $this->input->post('id');
	  
		
	   
	   $expansedata = array(
		 'po_id'        => $invoice_update_id,
		 'sess_eml' 			=> $this->session->userdata('email'),
		 'session_company' 	=> $this->session->userdata('company_name'),
		 'session_comp_email'=> $this->session->userdata('company_email'),
		 'saleorder_id' 		=> $this->input->post('saleorder_id'),
		 'so_owner' 			=> $this->input->post('supplier'),
		 'owner' 			=> $this->input->post('owner'),
		 'expenditure_no'     => $this->input->post('expenditure_no'),
		 'expenditure_date'   => $this->input->post('expenditure_date'),
		 'cust_order_no'		=> $this->input->post('order_no'),
		 'po_no' 				=> date('Y-m-d',strtotime($this->input->post('po_no'))),
		 'po_date' 			=> date('Y-m-d',strtotime($this->input->post('po_date'))),
		 'inv_terms' 		=> $this->input->post('terms_select'),
		 'extra_field_label' => $lable,
		 'extra_field_value' => $label_value,
		 'org_name' 	    	=> $org_name,
		 'cust_id' 	    	=> $org_id,
		 'invoice_declaration'=> $this->input->post('invoice_declaration'),
		 'branch_id'   		=> $this->input->post('shipto'),
		 //'discount_type' 	=> $this->input->post('sel_disc'),
		 //'discount' 	    => $this->input->post('discount'),
		 'notes' 			=> $this->input->post('notes'),
		 //'attachment' 		=> $attachment,
		 //'signature_img' 	=> $signature_img,
		 'pro_description' 	=> $product_desc,		
		 'enquiry_email' 	=> $this->input->post('enquiry_email'),
		 'enquiry_mobile' 	=> $this->input->post('enquiry_mobile'),
		 'jurisdiction' 		=> $this->input->post('jurisdiction'),
		 'late_charge' 		=> $this->input->post('late_charge'),
		 'product_name' 		=> implode("<br>",$this->input->post('product_name')),
		 'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
		 'gst' 				=> implode("<br>",$this->input->post('gst')),
		 'quantity' 			=> implode("<br>",$this->input->post('quantity')),
		 'unit_price' 		=> implode("<br>",$unit_price),
		 'pro_discount' 		=> $discount_price,
		 'total' 			=> implode("<br>",$total),
		 'sgst' 				=> $sgst,
		 'igst' 				=> $igst,
		 'cgst' 				=> $cgst,
		 'type' 				=> $this->input->post('type'),
		 'sub_total_with_gst'=> $sub_totalwithgst,
		 'extra_charge_label'=> $extra_charge,
		 'extra_charge_value'=> $extra_chargevalue,
		 'terms_condition' 	=> $terms_condition,
		 'total_discount' 	=> $total_discount,
		 'initial_total' 	=> $initial_total,        
		 'sub_total' 		=> $sub_total,
		 'total_igst' 		=> str_replace(",", "",$this->input->post('total_igst')),
		 'total_cgst' 		=> str_replace(",", "",$this->input->post('total_cgst')),
		 'total_sgst' 		=> str_replace(",", "",$this->input->post('total_sgst')),
		 'advanced_payment' 	=> $advanced_payment,
		 'pending_payment' 	=> $pendingPayment	        
 
	   );
	 // print_r($expansedata);die;
 
		 $po_id=$this->Base_model->expanse_exists($invoice_update_id);
		 // print_r($invoice_id);die;
		 if($po_id === $invoice_update_id){
			 $response=array();
				 $response['success'] = false;
				 $response['message'] = "Data already exit";
			 
				 echo json_encode($response);
		 }else{
			//  print_r($expansedata);die;
			 $updatedata=$this->Base_model->update_expanse($invoice_update_id ,$expansedata);
			 $response=array();
			 if($updatedata == 1){
				 $response['success'] = true;
				 $response['message'] = "Data update successfully";
			 }
			 echo json_encode($response);
		 }
	   
	 }
	}


	public function ajax_list()
	{
			
			$delete_inv	=0;
			$update_inv	=0;
			$retrieve_inv=0; 
			if(check_permission_status('Invoice','delete_u')==true){
				$delete_inv=1;
			}
			if(check_permission_status('Invoice','retrieve_u')==true){
				$retrieve_inv=1;
			}
			if(check_permission_status('Invoice','update_u')==true){
				$update_inv=1;
			}
			
			
			$list = $this->Base_model->getdata_expanse();
			// print_r($list);die;
			$data = array();
			$no = $_POST['start'];
			$output = "";
			$i =1;
			foreach ($list as $item) {
				$po_id = $item['po_id'];
			
				$list_po = $this->Base_model->get_expanse_no($po_id);
				// print_r($item['po_id']);die;
				$encrypted_id 	= base64_encode($item['po_id']);
					
				$sessionEmail 	= base64_encode($this->session->userdata('company_email'));
				$sessionCompany	= base64_encode($this->session->userdata('company_name'));

				$row=[];
				
					
					$row[].= $i++;
					$row[].=$item['expenditure_date'];
					$row[] = "<span style='color: rgba(140, 80, 200, 1);font-weight: 700;'>{$item['expenditure_no']}</span>";
					$row[].=$list_po['currentdate'];
					$row[] = "<span style='color: rgba(140, 80, 200, 1);font-weight: 700;'>{$list_po['purchaseorder_id']}</span>";
					$row[].=$item['owner'];
					$row[].=$item['sub_total'];
				
					// $row[].=$item['']; 
					// $row[].=$item['']; 
					// $row[].=$item['org_name'];
					//    $row[].=$item['owner']; 
					// $row[].=$item['pending_payment']; 
					
					
					$row[]="<a style='text-decoration:none'href='" . base_url('view-expenditure').'?inv_id='.urlencode($encrypted_id).'&cnp='.urlencode($sessionCompany). '&ceml='.urlencode($sessionEmail)."'  class='text-success border-right'><i class='far fa-eye sub-icn-opp m-1' data-toggle='tooltip' data-container='body' title='View Expenditure Details' ></i></a> 

						<a style='text-decoration:none' href='" . base_url('add-expanse/') . $item['po_id'] . "' class='text-primary border-right'> <i class='far fa-edit sub-icn-so m-1' data-toggle='tooltip' data-container='body' title='Update Expenditure  Details' ></i></a>
						

					<a style='text-decoration:none' href='javascript:void(0)'  onclick='delete_expanse(" . $item['po_id'] . ")' class='text-danger'>
					<i class='far fa-trash-alt text-danger m-1'  data-toggle='tooltip' data-container='body' title='Delete Expenditure' ></i></a></td> 
					
					</tr>";
					

				$data[]=$row;
			}
			$i++;
			
			
			$action = [
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Base_model->count_all_expanse(),
				"sum_data" => $this->Base_model->count_Total_expanse(),

				 "recordsTotal" =>$this->Base_model->count_all_exp(),
				 "recordsFiltered" => $this->Base_model->count_filtered_exp(),
				"data" => $data,
			];

			// print_r($action);die;
			echo json_encode($action);

	} 

		public function view_load_expenditure() 
		{
			
			if($this->session->userdata('email')){
				if(checkModuleForContr('Generate Invoicing')<1){
					redirect('home');
				}
				if(check_permission_status('Invoice','retrieve_u')==true){
			
				$id = base64_decode($_GET['inv_id']);
			
				$decoded_ceml = base64_decode( $_GET['ceml']);
				
				$decoded_cnp = base64_decode( $_GET['cnp']);

				if (isset($id)) {
					$data['inov_no']=$this->Base_model->get_expanse_no($id);
				}

				$data['view_expenditure']= $this->Base_model->get_expenditure_by_id($id,$decoded_cnp,$decoded_ceml);
				$data['bank_details_terms'] = $this->Base_model->get_bank_detailss();
				
				if($data['view_expenditure']['id']){
					$data['otherdata'] =array();
					$data['branch'] = $this->Base_model->debit_get_Branch_Data($data['view_expenditure']['branch_id']);
					$data['clientDtl'] = $this->Base_model->debit_get_org_by_id($data['view_expenditure']['cust_id']);
					$this->load->view('accounting/view_expenditure' ,$data);
					
				}
					
				}else{
					redirect("permission");
				}
				}else{
					redirect('login');		
				}
		}

		public function expanse_delete($id)
		{
			$delete=$this->Base_model->delete_expanse_id($id);
			if($delete){
				echo json_encode(array("status" => TRUE));
			}
	
		}


		public function generate_pdf_expanse()
		{
			// print_r('testing');die;
			
		
			$id = base64_decode($_GET['inv_id']);
			$decoded_cnp = base64_decode( $_GET['cnp']);
			$decoded_ceml = base64_decode( $_GET['ceml']);
		
		
				$row= $this->Base_model->get_expenditure_by_id($id,$decoded_cnp,$decoded_ceml);
				$inov_no=$this->Base_model->get_expanse_no($id);
				//  print_r($inov_no);die;
			
			
			if($row['id']){

				$rowOwner = $this->Base_model->get_Owner_debit($row['sess_eml']);
				if(empty($rowOwner['standard_name'])){
					$rowOwner = $this->Base_model->get_Admin_debit($row['sess_eml']);
				
				}

				$compnyDtail= $this->Base_model->get_Comp_debit($row['session_comp_email']);
			
				$branch = $this->Base_model->getBranchData_debit($row['branch_id']); 
			
				$clientDtl = $this->Base_model->getorg_by_id_debit($row['cust_id']);
			
				$bank_details_terms = $this->Base_model->get_bank_detailss();
			//    print_r($bank_details_terms);die;
			
			$output = '<!DOCTYPE html>
					<html>
					<head>
						<title>Team365 | Expenditure</title>
						<link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
						<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
					<style>
						@page{
							margin-top: 10px; /* create space for header */
							}
						footer .pagenum:before {
							content: counter(page, decimal);
							}
						</style>
					</head>
				
					<body style="font-family: Quicksand, sans-serif;">';
						if($row['declaration_status'] == 1) {  
						$output .= '<footer style="position: fixed;  bottom: 110;border-top:0.5px solid #333; " >';
						}else{
							
						$output .= '<footer style="position: fixed;  bottom: 80;border-top:0.5px solid #333; " >';
						}
						
						$output .= ' <table style="font-size:11px; width:100%; text-align:center;">';
							
							
							if($row['declaration_status'] == 1) {   
							$output .= '<tr>
								<td style="font-size:10px;">
								<text><b>Declaration:-</b></text>
								'.$row['invoice_declaration'].'
								</td>
							</tr>';
							}
							if($row['jurisdiction']!="") {  
							$output .= ' <tr>
								<td style="font-size:10px;"><b>"SUBJECT TO '.strtoupper($row['jurisdiction']).' JURISDICTION"</b></td>
							</tr>';
							}
							if($row['late_charge']!="") {  
							$output .= '  <tr>
								<td style="font-size:10px;">INTEREST@ '.$row['late_charge'].'% P.A WILL BE CHARGED IF THE PAYMENT IS NOT MADE WITHIN THE STIPULATED TIME.</td>
							</tr>';
							}
							$output .= '  <tr>
								<td><div class="pagenum-container"style="text-align:right;font-size:10px; border-top:1px dashed #333; ">Page <span class="pagenum"></span></div></td>
							</tr>
							<tr>
								<td><b>"This is system generated  Expenduter Management, Sign and stamp not required"</b></td>
							</tr>
							<tr>
								<td><b><span style="font-size: 10px;">E-mail - '.$branch['branch_email'].'</br>
							| Ph. - +91-'.$branch['contact_number'].'</br>
							| GSTIN: '.$branch['gstin'].'</br>
							| CIN: '.$branch['cin'].'</span></b><br>
							<b><span style="font-size:11px;">Powered By <a href="https://team365.io/">Team365 CRM</a></span></b> </td>
							</tr>
						</table>
						
						
						</footer>
					
					<main style="margin-bottom:10px;">
					<table width="100%" style="max-width:800px; background:#fff;">
						<tbody>
							<tr>
							<td style="width:35%; vertical-align: top;">
								<table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
								<tr>
									<td colspan="2"><text style="color: #6539c0;font-size:13px;"><b>Tax Expenditure </b></text></td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;" > Expenditure No.</td><td>'.$row['expenditure_no'].'</td> 
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;" > Po No.</td><td>'.$inov_no['purchaseorder_id'].'</td> 
									</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Expenditure Date.</td><td>'.date("d F Y", strtotime($row['expenditure_date'])).'</td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Terms</td><td>';
								if($row['inv_terms'] == 'end_of_month') { 
									$output .= 'Due end of month';
								}else if($row['inv_terms'] == 'end_next_month'){
									$output .= 'Due end of next month';
								}else if($row['inv_terms'] == 'due_receipt'){
									$output .= 'Due on reciept';
								}else if($row['inv_terms'] == 'custom'){
									$output .= 'Custom';
								}else{
									$output .= $row["inv_terms"];
								}		
								$output .= '</td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Due Date</td><td>'.date("d F Y", strtotime($row['due_date'])).'</td>
								</tr>
								</table>
							</td>
							<td style="text-align:left; width:35%; padding-top:15px; vertical-align: top; ">
							
								<table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
								<tr><td colspan="2"></td></tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Supplier'."'".'s Ref:</td><td>'.$row['so_owner'].'</td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Other Reference(s):</td><td>'.$row['owner'].'</td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Buyer'."'".'s Order No.:</td><td>'.$inov_no['cust_order_no'].'</td>
								</tr>
								<tr style="line-height: 0.8;">
									<td style="color: #615e5e;">Buyer'."'".'s Order Date:</td><td>'.date("d F Y", strtotime($inov_no['buyer_date'])).'</td>
								</tr>
								</table>
							
							</td>
							<td style="text-align:right; width:30%;">';
								$image = $compnyDtail['company_logo'];
									if(!empty($image))
									{
									$output .=  '<img style="width: 70px;" src="./uploads/company_logo/'.$image.'">';
									}
									else
									{
									$output .=  '<span class="h5 text-primary">'.$compnyDtail['company_name'].'</span>';
									}
									$output .= '
								</td>
							</tr>
							</tbody>
							</table>
							<table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
							
								<tr>
								
								<td style="width: 49.5%; padding: 2px 10px 4px 10px; vertical-align: top;">
									<h5 style="margin-top: 0px;margin-bottom: 2px;color: #6539c0;">Expenditure Management From</h5>
									<p style="margin: 0;font-size: 12px;">'.$branch['company_name'].'</p>
								';
								if($branch["address"]!=""){
								$output .=' <p style="margin: 0;font-size: 11px;">'.$branch["address"];
								}
								if($branch["city"]!=""){
								$output .=  ', '.$branch["city"];
								}
								if($branch["zipcode"]!=""){
								$output .=  ' - '.$branch["zipcode"];
								}
								if($branch["state"]!=""){
								$output .=  ', '.$branch["state"];
								}
								
								if($branch["country"]!=""){
								$output .=  ', '.$branch["country"];
								}
								$output .=  '</p>';
								if($branch["gstin"]!=""){
								$output .=  '<p style="margin: 0;font-size: 11px;"><b>GSTIN:</b> '.$branch["gstin"].'</p>';
								}
								if($branch["branch_email"]!="" && $branch["show_email"]== 1){
								$output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">'.$branch["branch_email"].'</p>';
								}
								if($branch["contact_number"]!=""){
								$output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">+91-'.$branch["contact_number"].'</p>';
								}
								$output .=  ' </td>
								
								<td style="width: 1%;background:#fff;"></td>
								
								<td style="width: 49.5%; padding:0px 10px 4px 10px; vertical-align: top;">
									<h5 style="margin-top: 0px;margin-bottom: 0px;color: #6539c0;"> Expenditure To</h5>
								<p style="margin: 0;font-size: 12px;">'.
								$clientDtl->org_name.'</p>';
								if(!empty($clientDtl->primary_contact)){
								$output .= '<p style="margin: 0;font-size: 11px;">
									<b>Contact Name :</b> '.$clientDtl->primary_contact.'</p>';
								}
								$output .= '
								<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">';
								
								if(!empty($clientDtl->shipping_address)){
								$output .= $clientDtl->shipping_address;
								}
								if(!empty($clientDtl->shipping_city)){
								$output .= ', '.$clientDtl->shipping_city;
								}
								if(!empty($clientDtl->shipping_zipcode)){
								$output .= ' - '.$clientDtl->shipping_zipcode;
								}
								if(!empty($clientDtl->shipping_state)){
								$output .= ', '.$clientDtl->shipping_state;
								}
								if(!empty($clientDtl->shipping_country)){
								$output .= ', '.$clientDtl->shipping_country;
								}
								$output .= '</p>';
								
								if(!empty($clientDtl->gstin!="")){
								$output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>GSTIN:</b> '.$clientDtl->gstin.'</p>';
								}
									if(isset($clientDtl->email)){
								$output .= '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>Email:</b>'.$clientDtl->email.' <br>
								<b>Phone:</b> +91-'.$clientDtl->mobile.'</p>';
									}
							$output .= '</td>
								
							</tr>
						</table>
						<!--<table width="100%" style="max-width:800px; background:#fff;">
						<tbody>
							<tr>
							<td align="left" style="font-size:12px;width: 49.5%;">
								<p><b>Country of Supply : </b>'.$clientDtl->shipping_country.'</p>
							</td>
							<td></td>
							<td align="left" style="font-size:12px;width: 49.5%;">
								<p><b>Place of Supply : </b>'.$clientDtl->shipping_state.'</p>
							</td>
							</tr>
						</tbody>
						</table>-->
				
						<table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; margin-top:10px; border-radius: 7px; background: #efebf9;">
						<thead style="color: #fff;" align="left">';
						
								$igsttotal=0;
								$sgsttotal=0;
								$cgsttotal=0;
								
								$igst = explode("<br>",$row['igst']);
								$sgst = explode("<br>",$row['sgst']);
								$cgst = explode("<br>",$row['cgst']);
								$proDiscount = explode("<br>",$row['pro_discount']);
								$totalDiscount=array_sum($proDiscount);
						
							$output .= '<tr>
							<th width="3%" style="font-size: 11px;">
								<div style="background: #6539c0;border-top-left-radius: 7px;  padding: 6px;">
							S.No.</div></th>
							<th width="18%" style="font-size: 11px; background: #6539c0;">
							Product/Services</th>
							<th style="font-size: 11px; background: #6539c0;">HSN/SAC</th>
							
							<th style="font-size: 11px; background: #6539c0;">Qty</th>
							<th style="font-size: 11px; background: #6539c0;">Tax</th>
							<th style="font-size: 11px; background: #6539c0;">Rate</th>';
							if($totalDiscount>0){
							$output .= '<th style="font-size: 11px; background: #6539c0;">Discount</th>';
							}
								$output .= '<th style="font-size: 11px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 6px;">Tot. Price</div></th>
							</tr>
						</thead>
						<tbody >';
						
								$product_name = explode("<br>",$row['product_name']);
								$quantity = explode("<br>",$row['quantity']);
								$unit_price = explode("<br>",$row['unit_price']);
								$total = explode("<br>",$row['total']);
								$total_withgst = explode("<br>",$row['sub_total_with_gst']);
								$hsnsac = explode("<br>",$row['hsn_sac']);
								$after_discount = ($row['initial_total']-$row['total_discount']);
								if(!empty($row['gst'])){
								$gst = explode("<br>",$row['gst']);
								}
								$proDesc = explode("<br>",$row['pro_description']);
								
								
								$arrlength = count($product_name);
								$rw=0;
								$sr=1;
								for($x = 0; $x < $arrlength; $x++){
									$rw++;
									$num = $x + 1;
									
									if(isset($igst[$x]) && $igst[$x]!=""){
										$igsttotal=$igsttotal+$igst[$x];
									}
									if(isset($sgst[$x]) && $sgst[$x]!=""){
										$sgsttotal=$sgsttotal+$sgst[$x];
									}
									if(isset($igst[$x]) && $cgst[$x]!=""){
										$cgsttotal=$cgsttotal+$cgst[$x];
									}
						
									
									$output .='<tr>
										<td style="font-size: 11px;padding: 5px 10px;">'.$sr.'</td>
										<td style="font-size: 11px;padding: 5px 10px;">'.$product_name[$x].'</td>
										
										<td style="font-size: 11px;padding: 5px 10px;">'.$hsnsac[$x].'</td>
										
										<td style="font-size: 11px;padding: 5px 10px;">'.$quantity[$x].'</td>
										<td style="font-size: 11px;padding: 5px 10px;">GST@'.$gst[$x].'%</td>
										<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($unit_price[$x]).'</td>';
										if($totalDiscount>0){
										$output .='<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($proDiscount[$x]).'</td>';
										}
										$output .='<td style="font-size: 11px;padding: 5px 10px; "><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($total[$x]).'</td>
									</tr>';
									if(isset($proDesc[$x]) && $proDesc[$x]!=""){	
									$output.='<tr>
											<td style="font-size: 11px; padding:5px 10px;"></td>
											<td colspan="6" style="font-size: 11px; padding:5px 10px;">'.$proDesc[$x].'</td></tr>';
									}
								$sr++;
								}
								
								$output .='
						</tbody>
						</table>
				
						<table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
						<tbody>
							<tr>
							<td align="left" width="60%" style="position: relative;">
							<p style="font-size:12px; margin-top:0px; margin-bottom:8px;"><b style="font-size:12px;">Total in words:</b> <text style="font-size:11px;"> '.AmountInWords($row["sub_total"]).' only</text></p>';
							if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){
					
								$output .='<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a;font-size:11px;">
									<tr>
										<td colspan="3">
											<h5 style="margin: 0px 0px 0px 8px; color: #6539c0; font-size:12px;">Bank Details</h5>
										</td>
									</tr>
									<tr style="line-height: 0.8;">
										<th style="text-align:left; padding-left:10px;">Account Holder Name:  <th>
										<td>'.ucfirst($bank_details_terms->acc_holder_name).'</td>
									</tr>
									<tr style="line-height: 0.8;">
										<th style="text-align:left; padding-left:10px;">  Account Number:  <th>
										<td>'.$bank_details_terms->account_no.'</td>
									</tr>
									<tr style="line-height: 0.8;">
										<th style="text-align:left; padding-left:10px;">  IFSC:  <th>
										<td>'.$bank_details_terms->ifsc_code.'</td>
									</tr>
									<tr style="line-height: 0.8;">
										<th style="text-align:left; padding-left:10px;"> Account Type:  <th>
										<td>'.ucfirst($bank_details_terms->account_type).'</td>
									</tr>
									<tr style="line-height: 0.8;">
										<th style="text-align:left; padding-left:10px;"> Bank Name: <th>
										<td>'.ucfirst($bank_details_terms->bank_name).'</td>
									</tr><tr style="line-height: 0.8;">';
									
										if($bank_details_terms->upi_id!=""){
										$output .= '<th style="text-align:left;  padding-left:10px;">UPI Id:<th>
										<td>'.$bank_details_terms->upi_id.'</td>';
										}
										if(isset($_GET['dn']) && $_GET['dn']==1){
										$output .= '<th style="text-align:left;padding-left:10px;"><a href="'.base_url("home").'" style="text-decoration:none; background:#6539c0; color:#fff; font-size:10px; padding:4px; display:inline-block; border-radius:3px;">Pay Now</a></th>';
										}
										
										$output .= '</tr>
									</table>';
						
						}  
						
							$output .='</td>
							<td align="" width="40%" style="text-align:right;">
							<table align="" width="100%" style="text-align:right;position: absolute;top: 0px;">
								<tbody>
								<tr>
									<th style="font-size: 12px;" align="left">Initial Amount</th>
				
									<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["initial_total"]).'</td>
								</tr>';
								if($row["discount"]>0){
								$output .='<tr>
									<th style="font-size: 12px;" align="left">Discount</th>
				
									<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$row["discount"].'</td>
								</tr>';
								
								$output .='<tr>
									<th style="font-size: 12px;" align="left">After Discount</th>
				
									<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($after_discount).'</td>
								</tr>';
								}
								if($igsttotal!=0){	
									$output .='<tr><th style="font-size: 12px;" align="left">IGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($igsttotal).'</td></tr>';
								}else{
									
										if($sgsttotal!=0){	
											$output .='<tr><th style="font-size: 12px;" align="left">SGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($sgsttotal).'</td></tr>';
										}
										if($cgsttotal!=0){	
											$output .='<tr><th style="font-size: 12px;" align="left">CGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($cgsttotal).'</td></tr>';
										}
									}
									if($row['extra_charge_label']!=""){
									$extraCharge_name=explode("<br>",$row['extra_charge_label']);
									$extraCharge_value=explode("<br>",$row['extra_charge_value']);
									for($y=0; $y<count($extraCharge_name); $y++){	
										$output .='<tr><th style="font-size: 12px;" align="left">'.$extraCharge_name[$y].'</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($extraCharge_value[$y]).'</td></tr>';
									}
									}
											
								$output .='
								<tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
								<tr>
								
									<th style="font-size: 12px;" align="left">TOTAL</th>
				
									<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["sub_total"]).'</td>
								</tr>
								</tbody>
								
							</table>
							</td>
						</tr>
						</tbody>
						</table>';
				
						$output .='<table width="100%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-bottom:30px margin-top:';
							if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){ 
								$output .='0px;">';
								
							}else{ 
								$output .='-20px;">'; 
								
							}
							$output .='<tbody>
							<tr>
						<td align="left" style="width:60%; padding:1px;">
							<h5 style="color: #6539c0;margin: 0px;">Terms and conditions</h5>
							<ol style="padding: 0 8px; font-size:11px; margin: 1px;">';
							$custTerm=explode("<br>",$row["terms_condition"]); $no=1;
							for($i=0; $i<count($custTerm); $i++){ 
							$output .='<li>'.$custTerm[$i].'</li>'; 
							}
							//'.nl2br($row->terms_condition).'
							$output .='</ol>
						</td>';
						
						$output .='<td style="text-align:center;">';
								$image = $row['signature_img'];
								if(!empty($image)){
								$output .=  '<img style="width: 90px;" src="./assets/pi_images/'.$image.'">	';
								}else{
									//$output .= '<text style="color: #615e5e; font-size:11px;">For '.$this->session->userdata('company_name').' (signature)</text>';
								}
						$output .= '</td>';
									$output .= '</tr>
									
							
						</tbody>
						</table>';
						
						
				
					$output .='</main>
				
					</body>
					</html>';
			//return $output;
			
				}
				//echo $output; exit;
				// print_r($output); die;
			$this->load->library('pdf');
			$this->dompdf->loadHtml($output);
			ini_set('memory_limit', '128M');
			$this->dompdf->render();
			$canvas = $this->dompdf->getCanvas();
			$pdf = $canvas->get_cpdf();
		
			foreach ($pdf->objects as &$o) {
				if ($o['t'] === 'contents') {
					$o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
				}
			}
			
			if(isset($_GET['dn']) && $_GET['dn']==1){
				$this->dompdf->stream("Expenditure".$id.".pdf", array("Attachment"=>1));  
			}else{
				$this->dompdf->stream("Expenditure".$id.".pdf", array("Attachment"=>0));  
			}
			
			
		}

	// < --------------------------------------------------- Expenditure Management end------------------------------------------- >

}
