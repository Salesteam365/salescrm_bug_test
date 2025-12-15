<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Salesorders extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'crm_helper']);
        $this->load->model('Quotation_model', 'Quotation');
        $this->load->model('Salesorders_model', 'Salesorders');
        $this->load->model('Purchaseorders_model', 'Purchaseorders');
        $this->load->model('Reports_model', 'Reports');
        $this->load->model('Lead_model', 'Lead');
        $this->load->model('Login_model', 'Login');
        $this->load->model('Contact_model');
        $this->load->model('Workflow_model');
        
         $this->load->model(array('Export_model'));
         
        $this->load->model('Opportunity_model', 'Opportunity');
        $this->load->library('upload');
        $this->load->library(['pdf', 'email_lib']);
    }

    public function index()
    {
        if (!empty($this->session->userdata('email'))) {
            if (checkModuleForContr('Create Salesorder') < 1) {
                redirect('home');
            }
            if (check_permission_status('Salesorders', 'retrieve_u') == true) {
                $date = "15 days";
                $data['so_popup'] = $this->Salesorders->get_pending_salesorder($date);
                $data['po_popup'] = $this->Salesorders->get_pending_purchaseorder();
                $data['branch'] = $this->Login->branch_name();
                $data['renewal_data'] = $this->Salesorders->get_renewal_so();
                $data['user'] = $this->Login->getusername();
                $data['admin'] = $this->Login->getadminname();
                //$data['record'] = $this->Salesorders->get_data_for_update();
                //$data['workflow_details'] = $this->Workflow_model->get_workflows_byModule('Salesorders','salesorder approved by user');
                $data['countSO'] = $this->Salesorders->count_all();
                $this->load->view('sales/salesorders', $data);
            } else {
                redirect('permission');
            }
        } else {
            redirect('login');
        }
    }
    
	public function handleFileUpload($inputName, $uploadPath, $allowedTypes, $maxSize) {
        if (!empty($_FILES[$inputName]["name"])) {
            $config["upload_path"] = $uploadPath;
            $config["max_size"] = $maxSize;
            $config["allowed_types"] = $allowedTypes;
            $CI = & get_instance(); 
            $CI->load->library("upload", $config);
            $CI->upload->initialize($config); 
            if ($CI->upload->do_upload($inputName)) {
                $uploadData = $CI->upload->data();
				return $uploadData['file_name'];
            } else {
                $CI->session->set_flashdata("error", $CI->upload->display_errors());
                return false;
            }
        } else {
            return ""; 
            
        }
    }

    public function add_salesorder()
    {
        if (check_permission_status('Salesorders', 'create_u') == true || check_permission_status('Salesorders', 'update_u') == true) {
            $id = $this->uri->segment(2);
            if (isset($_GET['qt']) && $_GET['qt'] != "") {
                $data['record'] = $this->Quotation->get_data_for_update($_GET['qt']);
                $data['action'] = ['data' => 'add', 'from' => 'quotation'];
            } elseif (isset($id) && $id != "") {
                $data['record'] = $this->Salesorders->get_data_for_update($id);
                $data['action'] = ['data' => 'update', 'from' => 'salesorder'];
            } else {
                $data['action'] = ['data' => 'add', 'from' => 'direct'];
            }
            $data['user'] = $this->Login_model->getusername();
            $data['gstPer'] = $this->Quotation->get_gst();
            $data['countSO'] = $this->Salesorders->count_all();
            
            // print_r($data['record']);die;
            $this->load->view('sales/add-salesorder', $data);
        } else {
            redirect('permission');
        }
    }

    public function changeStatus()
    {
        if (check_permission_status('Sales Order can approve', 'other') == true) {
            $sales_data = $this->Salesorders->get_by_id($this->input->post('soid'));
            $value = $this->input->post('sovalue');
            if ($value == 1) {
                $stts = 1;
            } else {
                $stts = 0;
            }
            $approved_by = $this->session->userdata('name');
            $chngeSt = ['pay_terms_status' => $stts, 'approved_by' => $approved_by];
            $where = ['id' => $this->input->post('soid')];
            $data = $this->Salesorders->statusSopayment($where, $chngeSt, $stts);

            echo $data;

            if ($data == 1) {
                $workFlowStsStsUser = check_workflow_status('Sales order', 'Mail notification to all PO creater on sales order approve');
                if ($workFlowStsStsUser == true) {
                    $dataMail = $this->Salesorders->getuserPurchaseTeam('Receive mail on approving sales order for purchase team');
                    $arraMail = [];
                    for ($i = 0; $i < count($dataMail); $i++) {
                        $arraMail[] = $dataMail[$i]['user_email'];
                    }
                    $mailData = implode(",", $arraMail);
                    if (count($arraMail) > 0) {
                        $messageToPoTeam = '';
                        $subjectLine = "Sales Order Status Confirmation - team365 | CRM";
                        $messageToPoTeam .= '<div class="f-fallback">
            <h1>Dear , Purchase Team!</h1>';
                        $messageToPoTeam .= '<p>' . $sales_data->subject . ', sales order has been approved. Please check and create your purchase order.</p>';
                        $messageToPoTeam .= '<p>Sales Order Detail:-</p>';
                        $messageToPoTeam .= '<p>Subject : ' . $sales_data->subject . '</p>';
                        $messageToPoTeam .=
                            '<p>
			Sales Order ID : ' .
                            $sales_data->saleorder_id .
                            '
			<br>
			Product : ' .
                            str_replace("<br>", ", ", $sales_data->product_name) .
                            '
			</p>';
                        $messageToPoTeam .=
                            'For More details <a href="' .
                            base_url() .
                            'salesorders/view_pi_so/' .
                            $id .
                            '"> click here</a> or copy this url and paste in your browser<br>
			URL - ' .
                            base_url() .
                            'salesorders/view_pi_so/' .
                            $sales_data->id .
                            '
			</p>';
                        $messageToPoTeam .= '</div>';
                        sendMailWithTemp($mailData, $messageToPoTeam, $subjectLine);
                    }
                }

                $workFlowStsAdmin = check_workflow_status('Admin', 'Mail notification on approve sales order');
                $workFlowStsStsUser = check_workflow_status('Sales order', 'Mail notification to sales owner on sales order approve');
                $permissionSts = check_permission_status('Receive mail on approving sales order', 'other');

                if ($permissionSts == true && $workFlowStsStsUser == true) {
                    $messagetoSoWoner = '';
                    $subjectSoWoner = "Your Sales Order Status Confirmation - team365 | CRM";
                    $messagetoSoWoner .=
                        '<div class="f-fallback">
            <h1>Dear , ' .
                        $sales_data->owner .
                        '!</h1>';
                    $messagetoSoWoner .= '<p>Your "' . $sales_data->subject . '", sales order has been approved.</p>';
                    $messagetoSoWoner .= '<p>Sales Order Detail:-</p>';
                    $messagetoSoWoner .= '<p>Subject : ' . $sales_data->subject . '</p>';
                    $messagetoSoWoner .=
                        '<p>
			Sales Order ID : ' .
                        $sales_data->saleorder_id .
                        '
			<br>
			Product : ' .
                        str_replace("<br>", ", ", $sales_data->product_name) .
                        '
			<br>
			Approved By : ' .
                        $approved_by .
                        '
			</p>';
                    $messagetoSoWoner .=
                        'For More details <a href="' .
                        base_url() .
                        'salesorders/view_pi_so/' .
                        $sales_data->id .
                        '"> click here</a> or copy this url and paste in your browser<br>
			URL - ' .
                        base_url() .
                        'salesorders/view_pi_so/' .
                        $sales_data->id .
                        '
			</p>';
                    $messagetoSoWoner .= '</div>';
                    sendMailWithTemp($sales_data->sess_eml, $messagetoSoWoner, $subjectSoWoner);
                }

                /*  SEND TO ADMIN  */
                if ($workFlowStsAdmin == true) {
                    $messagetoAdmin = '';
                    $subjectAdmin = "Sales Order Status Confirmation - team365 | CRM";
                    $messagetoAdmin .= '<div class="f-fallback">
            <h1>Dear , Admin!</h1>';
                    $messagetoAdmin .= '<p>A "' . $sales_data->subject . '", sales order has been approved.</p>';
                    $messagetoAdmin .= '<p>Sales Order Detail:-</p>';
                    $messagetoAdmin .= '<p>Subject : ' . $sales_data->subject . '</p>';
                    $messagetoAdmin .=
                        '<p>
			Sales Order ID : ' .
                        $sales_data->saleorder_id .
                        '
			<br>
			Product : ' .
                        str_replace("<br>", ", ", $sales_data->product_name) .
                        '
			<br>
			Approved By : ' .
                        $approved_by .
                        '
			</p>';
                    $messagetoAdmin .=
                        'For More details <a href="' .
                        base_url() .
                        'salesorders/view_pi_so/' .
                        $sales_data->id .
                        '"> click here</a> or copy this url and paste in your browser<br>
			URL - ' .
                        base_url() .
                        'salesorders/view_pi_so/' .
                        $sales_data->id .
                        '
			</p>';
                    $messagetoAdmin .= '</div>';
                    sendMailWithTemp($sales_data->session_comp_email, $messagetoAdmin, $subjectAdmin);
                }
            }
        } else {
            echo '2';
        }
    }

    ///////////////////////////////////////////////////////////// fetch data for so_graph (monthwise) starts /////////////////////////////////////////////////////

        public function so_graph(){
            $data['grouped_data'] = $this->Salesorders->getso_graph();
            $response = [
                'status' => 'success',
                'data' => $data['grouped_data']  
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }

    ///////////////////////////////////////////////////////////// fetch data for so_graph (monthwise) ends  /////////////////////////////////////////////////////

    public function ajax_list()
    {
        $list = $this->Salesorders->get_datatables();
        $delete_so = 0;
        $update_so = 0;
        $retrieve_so = 0;
        $create_po = 0;
        $create_pi = 0;
        $so_approval = 0;
        $create_Invoice = 0;

        if (check_permission_status('Salesorders', 'delete_u') == true) {
            $delete_so = 1;
        }
        if (check_permission_status('Purchase Order', 'create_u') == true) {
            $create_po = 1;
        }
        if (check_permission_status('Salesorders', 'retrieve_u') == true) {
            $retrieve_so = 1;
        }
        if (check_permission_status('Salesorders', 'update_u') == true) {
            $update_so = 1;
        }
        if (check_permission_status('Proforma Invoice', 'create_u') == true) {
            $create_pi = 1;
        }
        if (check_permission_status('Invoice', 'create_u') == true) {
            $create_Invoice = 1;
        }
        if (check_permission_status('Sales Order can approve', 'other') == true) {
            $so_approval = 1;
        }

        $data = [];
        $no = $_POST['start'];
        $dataAct = $this->input->post('actDate');

        foreach ($list as $post) {
            $no++;
            $row = [];
            // APPEND HTML FOR ACTION

            $proName = explode("<br>", $post->product_name);

            $proNamepo = 0;
            $soId = $post->saleorder_id;
            $poList = $this->Salesorders->CountOrder($soId);
            $PiCount = $this->Quotation->check_pi_exist($post->saleorder_id);
            $invoiceCount = $this->Salesorders->CountInvoice($post->saleorder_id);

            foreach ($poList as $Popost) {
                $proNamepo2 = explode("<br>", $Popost->product_name);
                $proNamepo = $proNamepo + count($proNamepo2);
            }

            $SOProNameCnt = count($proName);
            $POProNameCnt = $proNamepo;

            if ($delete_so == 1) {
                if ($dataAct != 'actdata') {
                    // $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
                      $row[] = '<input type="checkbox" class="delete_checkbox" onClick="checkCheckbox(); showAction(' . $post->id . ');" name="action_ck" value="'.$post->id.'">';
                }
            }
            
            $first_row = "";
            $first_row .= ucfirst($post->subject) . '<!---<div class="links">';
            if ($retrieve_so == 1) {
                $first_row .= '<a style="text-decoration:none" href="' . base_url() . 'salesorders/view_pi_so/' . $post->id . '" class="text-success">View</a>';
            }
            if ($update_so == 1) {
                $first_row .= '|<a style="text-decoration:none" href="' . base_url() . 'add-salesorder/' . $post->id . '" class="text-primary">Update</a>';
            }
            if ($create_po == 1 && $SOProNameCnt > $POProNameCnt) {
                $first_row .= '|<a style="text-decoration:none" href="' . base_url() . 'add-purchase-order?so=' . $post->id . '" class="text-info">Create Purchaseorder</a>';
            }

            if ($create_pi == 1 && $PiCount < 1) {
                $first_row .= '|<a style="text-decoration:none" href="' . base_url() . 'proforma_invoice/create_newProforma?pg=salesorder&qt=' . $post->saleorder_id . '"  class="text-info">Create PI</a>';
            }

            if ($create_Invoice == 1 && $invoiceCount < 1) {
                $first_row .= '|<a style="text-decoration:none" href="' . base_url() . 'add-invoice?so=' . $post->id . '" class="text-info">Create Invoice</a>';
            }

            if ($delete_so == 1) {
                $first_row .= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry(' . "'" . $post->id . "'" . ',`' . $post->saleorder_id . '`)" class="text-danger">Delete</a>';
            }
            $first_row .= '</div>-->';
            
            $companydetail = "
                <div class='d-flex align-items-center'>
                    <img src='".base_url('')."/application/views/assets/images/faces/4.jpg' alt='img'
                        class='rounded-circle mr-2' style='width: 1.75rem; height: 1.75rem;'>
                    <div>
                        <span>".ucfirst($post->org_name)."</span><br>
                        <i style='color:#4e6d7c;font-weight:400;'>".$post->customer_email."</i>
                    </div>
                </div>";

                $salesid =" 
                <span style='color: rgba(140, 80, 200, 1);
                font-weight: 700;'>".ucfirst($post->saleorder_id)."</span>"
                ;

            // $row[] = $companydetail;
             $row[] = '<a style="text-decoration:none" href="' . base_url() . 'salesorders/view_pi_so/' . $post->id . '">' . $companydetail . '</a>';
            $row[] = $first_row;
           
            $row[] = $salesid;
            $row[] = ucfirst($post->owner);
            if ($post->total_percent == '0') {
                if ($invoiceCount > 0 && $post->invoice_id != "") {
                    $row[] = '<span class="btn btn_complete_st p-0">Complete</span>';
                } else {
                    $row[] = '<span class="btn btn_invoicepending_st p-0">Invoice Pending</span>';
                }
            } elseif ($post->total_percent == '100') {
                $row[] = '<span class="btn btn_pending_st p-0">Pending</span>';
            } elseif ($post->total_percent > 0 || $post->total_percent < 100) {
                $row[] = '<span class="btn btn_inprog_st p-0">In Progress</span>';
            }

            if (isset($post->pay_terms_status) && $post->pay_terms_status == 1) {
                $StatusSo = '';
                $StatusSo .= '<div class="text-center"><i class="far fa-check-circle text-success" data-toggle="tooltip" data-container="body" title="Approved by ' . ucwords($post->approved_by) . '" ></i></div>';

                //"Approved by ".ucwords($post->approved_by);
                /*	if($so_approval==1):
				$StatusSo.='<!--<div class="links"><a style="text-decoration:none" href="javascript:void(0)" id="textid'.$post->id.'" class="text-success" onclick="approve_entry('."'".$post->id."'".',`'.$post->saleorder_id.'`,`0`,`textid'.$post->id.'`)" >Click To Disapprove</a></div>-->';
				endif;*/
                $row[] = $StatusSo;
            } else {
                $StatusSo = '';

                $StatusSo .= '<div class="text-center"><i class="far fa-times-circle text-danger"  data-toggle="tooltip" data-container="body" title="Approval Pending"></i></div>';
                //$StatusSo.=' <span class="text-danger" style="padding:2px;">Pending</span><i class="far fa-times-circle text-danger"  data-toggle="tooltip" title="Approval Pending"  data-original-title="Approval Pending" ></i>';
                /*if($so_approval==1):
				$StatusSo.='<!--<div class="links"><a style="text-decoration:none;" href="javascript:void(0)" id="textid'.$post->id.'"  class="text-primary" onclick="approve_entry('."'".$post->id."'".',`'.$post->saleorder_id.'`,`1`,`textid'.$post->id.'`)">Click To Approve</a></div>-->';
				endif;*/
                $row[] = $StatusSo;
            }

            $newDate = date("d M Y", strtotime($post->currentdate));
            //$row[] = "<text style='font-size: 12px;'>".time_elapsed_string($post->datetime)."</text>";
            $row[] = "<text style='font-size: 12px;'>" . $newDate . "</text>";
            
            // Start po show 
            $pono = "";

                if (!empty($post->po_no)) {
                    $pono = "<span style='color: rgba(140, 80, 200, 1); font-weight: 700;'>" . ucfirst($post->po_no) . "</span>";
                }

                $row[] = $pono;

                $newDatepo = "";

                if (!empty($post->po_date)) {
                    $newDatepo = date("d M Y", strtotime($post->po_date));
                }

                $row[] = !empty($newDatepo) ? "<text style='font-size: 12px;'>" . $newDatepo . "</text>" : "";
            // end po 

            $action = '<div class="row" style="font-size: 15px;">';
            if ($retrieve_so == 1) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'salesorders/view_pi_so/' .
                    $post->id .
                    '" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Sales Details" ></i></a>';
            }
            if ($update_so == 1) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'add-salesorder/' .
                    $post->id .
                    '" class="text-primary border-right">
					<i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Sales Details" ></i></a>';
            }
            //&& $SOProNameCnt>$POProNameCnt
            if ($create_po == 1 && $SOProNameCnt > $POProNameCnt) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'add-purchase-order?so=' .
                    $post->id .
                    '" class="text-info border-right">
					<i class="fas fa-shopping-basket sub-icn-po m-1" data-toggle="tooltip" data-container="body" title="Create Purchase Order" ></i></a>';
            }
            if ($create_Invoice == 1 && $invoiceCount < 1) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'add-invoice?so=' .
                    $post->id .
                    '" class="text-info border-right">
					<i class="fas fa-file-invoice sub-icn-invoice m-1"  data-toggle="tooltip" data-container="body" title="Create Invoice" ></i></a>';
            }
            if ($create_pi == 1 && $PiCount < 1) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'proforma_invoice/create_newProforma?pg=salesorder&qt=' .
                    $post->saleorder_id .
                    '"  class="text-info border-right">
					<i class="fas fa-file-invoice-dollar sub-icn-pi m-1"  data-toggle="tooltip" data-container="body" title="Create PI" ></i></a>';
            }

            if (isset($post->pay_terms_status) && $post->pay_terms_status == 1) {
                if ($so_approval == 1):
                    $action .=
                        '<a style="text-decoration:none" href="javascript:void(0)" id="textid' .
                        $post->id .
                        '" class="text-success border-right" onclick="approve_entry(' .
                        "'" .
                        $post->id .
                        "'" .
                        ',`' .
                        $post->saleorder_id .
                        '`,`0`,`textid' .
                        $post->id .
                        '`)" ><i class="far fa-thumbs-up text-success m-1"  data-toggle="tooltip" data-container="body" title="Click to disapprove"></i></a>';
                endif;
            } else {
                if ($so_approval == 1):
                    $action .=
                        '<a style="text-decoration:none;" href="javascript:void(0)" id="textid' .
                        $post->id .
                        '"  class="text-primary border-right" onclick="approve_entry(' .
                        "'" .
                        $post->id .
                        "'" .
                        ',`' .
                        $post->saleorder_id .
                        '`,`1`,`textid' .
                        $post->id .
                        '`)"><i class="far fa-thumbs-down text-info m-1"  data-toggle="tooltip" data-container="body" title="Click to approve"></i></a>';
                endif;
            }
            
            $action .='
            
                        <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            &nbsp; <i class="fas fa-ellipsis-h fa-1x" style="color:purple;"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="">
                            <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="'.base_url().'salesorders/view_pi_so/' . $post->id . '">Open</a></div>
                            <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="'.base_url().'add-salesorder/' . $post->id . '">Edit</a></div>
                            <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="">Send Email</a></div>
                            <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="https://web.whatsapp.com/send?text='.base_url('').'salesorders/view/' . $post->id . '">Send Whatsapp</a></div>
                            <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="'.base_url().'add-invoice?so='.$post->id.'">Convert to Invoice</a></div>
                            <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="' . base_url() . 'proforma_invoice/create_newProforma?pg=quotation&qt=' . $post->quote_id . '">Convert to Performa Invoice</a></div>
                            <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="">Duplicate</a></div>
                            <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="">Copy Quotation link</a></div>
                            <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="'.base_url().'quotation/view/' . $post->id . '/dn">Download</a></div>
                            <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="javascript:void(0)" onclick="delete_entry('. "'". $post->id . "'" .')">Delete</a></div>
                        </div>
            
                    ';
            $action .= '</div>';

            $row[] = $action;

            $data[] = $row;
        }
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Salesorders->count_all(),
            "recordsFiltered" => $this->Salesorders->count_filtered(),
            "data" => $data,
        ];
        //output to json format
        echo json_encode($output);
    }
    
    
     public function export_filter_Data(){ 
         // print_r($customer);die;
		$filename = 'filter_so_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");

        $searchDate   = $this->input->post('searchDate');
        $searchUser   = $this->input->post('searchUser');
        $customer     = $this->input->post('customer');
        $custpo       = $this->input->post('custpo');
        $newValue     = $this->input->post('newValue');

		// $list = $this->Salesorders->get_datatables();
		
		$usersData = $this->Export_model->export_filterData($searchDate, $searchUser, $customer, $custpo, $newValue);
        // print_r($usersData);die;

		$file = fopen('php://output', 'w');
		$header = array('ADDED BY EMAIL','ADDED BY NAME','SUBJECT','CONTACT NAME','BILLING GSTIN','SHIPPING GSTIN','BILLING COUNTRY','BILLING STATE','BILLING CITY','BILLING ZIPCODE','BILLING ADDRESS','SHIPPING COUNTRY','SHIPPING STATE','SHIPPING CITY','SHIPPING ZIPCODE','SHIPPING ADDRESS','	SUPPLIER NAME','SUPPLIER CONTACT','SUPPLIER COMP NAME','SUPPLIER EMAIL','SUPPLIER GSTIN','SUPPLIER COUNTRY','SUPPLIER STATE','SUPPLIER CITY','SUPPLIER ZIPCODE','SUPPLIER ADDRESS','TYPE','PRODUCT NAME','HSN SAC','SKU,QUANTITY','UNIT PRICE','TOTAL','GST','IGST','CGST','SGST','SUB TOTAL WITH GST','TOTAL IGST','TOTAL CGST','TOTAL SGST','PRO DISCOUNT','EXTRA CHARGE LABEL','EXTRA CHARGE VALUE','DELETE STATUS','TOTAL ORC PO','ESTIMATE PURCHASE PRICE PO','INITIAL ESTIMATE PURCHASE PRICE PO','TOTAL ESTIMATE PURCHASE PRICE PO','PROFIT BY USER PO','PRO DESCRIPTION','INITIAL TOTAL','DISCOUNT','AFTER DISCOUNT PO','SUB TOTAL','TERMS CONDITION','CUSTOMER COMPANY NAME','CUSTOMER NAME','CUSTOMER EMAIL','CUSTOMER MOBILE','LAN_NO','PROMO ID','CUSTOMER ADDRESS','APPROVE STATUS','APPROVED BY','SO OWNER','SO OWNER_EMAIL','ORG NAME','END RENEWAL','IS RENEWAL','RENEWAL DATE','DATETIME');
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}


//     public function export_without_po() {
//         $filename = 'so_withoutPo_data_'.date('Ymd').'.csv'; 
// 		header("Content-Description: File Transfer"); 
// 		header("Content-Disposition: attachment; filename=$filename"); 
// 		header("Content-Type: application/csv; ");
       
//         //   print_r('test');die;

//         $list_po = $this->Purchaseorders->get_datatables();
//          print_r($list_po);die;
        
//         $soId = [];
       
//         foreach ($list_po as $post) {
//             $soId[] = $post->saleorder_id;
//         }
//         $without_po_data = $this->Export_model->data_without_po($soId);
//         $all_data = []; // To collect all rows

//         if (!empty($without_po_data)) {
//         // Assuming data_without_po returns an array of rows
//             foreach ($without_po_data as $row) {
//                 $all_data[] = $row;
//             }
//         }
        
//         $file = fopen('php://output', 'w');
//         $header = array(
//             'ADDED BY EMAIL','ADDED BY NAME','OPPORTUNITY NAME','SUBJECT','CUSTOMER NAME',
//             'CONTACT NAME','PENDING','DUE UNTIL','CARRIER','PAYMENT TERMS','PAY TERMS STATUS',
//             'APPROVED BY','STATUS','BILLING COUNTRY','BILLING STATE','BILLING CITY','BILLING ZIPCODE',
//             'BILLING ADDRESS','SHIPPING COUNTRY','SHIPPING STATE','SHIPPING CITY','SHIPPING ZIPCODE',
//             'SHIPPING ADDRESS','PRODUCT NAME','HSN SAC','SKU','QUANTITY','UNIT PRICE',
//             'ESTIMATE PURCHASE PRICE','TOTAL','INITIAL TOTAL','INITIAL ESTIMATE PURCHASE PRICE',
//             'DISCOUNT','PRO DESCRIPTION','SUB TOTAL','TOTAL ESTIMATE PURCHASE PRICE','GST','IGST',
//             'CGST','SGST','PRODUCT DISCOUNT','TOTAL IGST','TOTAL CGST','TOTAL SGST','TYPE',
//             'SUB TOTAL WITH GST','TOTAL ORC','IS RENEWAL','RENEWAL DATE','ADVANCED PAYMENT',
//             'PENDING PAYMENT','DATETIME'
//         );
//         fputcsv($file, $header);
//         foreach ($all_data as $line) {
//             fputcsv($file, $line);
//         }

//         fclose($file);
//         exit;
//     }
    
    public function export_without_po() {
        // Clean any existing output buffer (important on live servers)
        if (ob_get_length()) {
            ob_end_clean();
        }
     
        // Increase limits (in case of large data export)
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300); // 5 minutes
     
        // Generate file name
        $filename = 'so_withoutPo_data_' . date('Ymd') . '.csv';
     
        // Set headers to prompt file download
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/csv");
     
        // Load the data
        $list_po = $this->Purchaseorders->get_datatables();
        $soId = [];
        foreach ($list_po as $post) {
            $soId[] = $post->saleorder_id;
        }
     
        // Get export data
        $without_po_data = $this->Export_model->data_without_po($soId);
        $all_data = [];
     
        if (!empty($without_po_data)) {
            foreach ($without_po_data as $row) {
                $all_data[] = (array) $row; // Make sure it's an array
            }
        }
     
        // Open file stream for output
        $file = fopen('php://output', 'w');
     
        // CSV Header row
        $header = [
            'ADDED BY EMAIL','ADDED BY NAME','OPPORTUNITY NAME','SUBJECT','CUSTOMER NAME',
            'CONTACT NAME','PENDING','DUE UNTIL','CARRIER','PAYMENT TERMS','PAY TERMS STATUS',
            'APPROVED BY','STATUS','BILLING COUNTRY','BILLING STATE','BILLING CITY','BILLING ZIPCODE',
            'BILLING ADDRESS','SHIPPING COUNTRY','SHIPPING STATE','SHIPPING CITY','SHIPPING ZIPCODE',
            'SHIPPING ADDRESS','PRODUCT NAME','HSN SAC','SKU','QUANTITY','UNIT PRICE',
            'ESTIMATE PURCHASE PRICE','TOTAL','INITIAL TOTAL','INITIAL ESTIMATE PURCHASE PRICE',
            'DISCOUNT','PRO DESCRIPTION','SUB TOTAL','TOTAL ESTIMATE PURCHASE PRICE','GST','IGST',
            'CGST','SGST','PRODUCT DISCOUNT','TOTAL IGST','TOTAL CGST','TOTAL SGST','TYPE',
            'SUB TOTAL WITH GST','TOTAL ORC','IS RENEWAL','RENEWAL DATE','ADVANCED PAYMENT',
            'PENDING PAYMENT','DATETIME'
        ];
        fputcsv($file, $header);
     
        // Output data rows
        foreach ($all_data as $line) {
            fputcsv($file, $line);
        }
     
        // Close file stream
        fclose($file);
     
        // End script to prevent additional output
        exit;
    }
    
    public function getstatusvalue()
    {
        $inProgress = $this->Salesorders->get_datatables_action_value(50);
        $invoicePend = $this->Salesorders->get_datatables_action_value('invoice');
        $pening = $this->Salesorders->get_datatables_action_value(100);
        $complete = $this->Salesorders->get_datatables_action_value('complete');
        echo json_encode(['inProgress' => $inProgress['sub_totals'], 'invoicePend' => $invoicePend['sub_totals'], 'pening' => $pening['sub_totals'], 'complete' => $complete['sub_totals']]);
    }

    public function end_renewal()
    {
        $id = $this->input->post('id');
        $this->Salesorders->update_end_renewal($id);
        echo json_encode(true);
    }
    public function update_renewal_data()
    {
        $data = $this->Salesorders->get_renewal_so();
        echo json_encode($data);
    }

    public function autocomplete_quoteid()
    {
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
        if (isset($_GET['term'])) {
            $result = $this->Salesorders->get_quote_id($_GET['term'], $sess_eml, $session_company, $session_comp_email);
            if (count($result) > 0) {
                foreach ($result as $row) {
                    $arr_result[] = [
                        'label' => $row->quote_id,
                    ];
                }
                echo json_encode($arr_result);
            } else {
                $arr_result[] = [
                    'label' => "No Quotation Found",
                ];
                echo json_encode($arr_result);
            }
        }
    }

    public function get_quote_details()
    {
        $quote_id = $this->input->post();
        $CountQt = $this->Salesorders->check_quot_exist($quote_id['quote_id']);
        if ($CountQt < 1) {
            $data = $this->Salesorders->getQuoteValue($quote_id);
            echo json_encode($data);
        } else {
            $arr_result[] = [
                'error_msg' => '<i class="fas fa-info-circle" style="color:red;"></i>&nbsp;&nbsp;Quotation Id Exists Already.',
            ];
            echo json_encode($arr_result);
        }
    }
    
    
     public function create()
    {
        
            // Retrieve the PO number from POST data
            $po_no = $this->input->post('po_no');
            // Check if PO number is filled
            if (!empty($po_no)) {
                // Check if PO number exists in the database
                $po_exists = $this->Salesorders->checkPoNumberExists($po_no);
        
                if ($po_exists) {
                    // Return an error response if PO number exists
                    echo json_encode(["status" => false, "message" => "PO number already exists."]);
                    return; // Stop further execution
                }
            }
    
    
        
        if ($this->input->post('opportunity_id') == '' || $this->input->post('quote_id') == '') {
            if ($this->input->post('opportunity_id') == '') {
                $opportunity_id = create_opportunity($_POST); //call function from helper
                // print_r($opportunity_id);die;
            } else {
                $opportunity_id = $this->input->post('opportunity_id');
                // print_r($opportunity_id);die;
            }
            if ($this->input->post('quote_id') == '') {
                $quote_id = create_quote($_POST, $opportunity_id); //call function from helper
            } else {
                $quote_id = $this->input->post('quote_id');
            }
        } else {
            $opportunity_id = $this->input->post('opportunity_id');
            $quote_id = $this->input->post('quote_id');
        }

        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
        $owner = $this->input->post('owner');
        $subject = $this->input->post('subject');
        $status = $this->input->post('status');
        $sub_totals = $this->input->post('sub_total');
        $after_discount = $this->input->post('after_discount');
        $page_source = $this->input->post('page_source');

        if ($this->input->post('terms_condition')) {
            $terms_condition = implode("<br>", $this->input->post('terms_condition'));
        } else {
            $terms_condition = "";
        }

        $initial_total = str_replace(",", "", $this->input->post('initial_total'));
        $unit_price = str_replace(",", "", $this->input->post('unit_price'));
        $total = str_replace(",", "", $this->input->post('total'));
        $after_discount = str_replace(",", "", $this->input->post('after_discount'));
        $sub_total = str_replace(",", "", $this->input->post('sub_total'));
        $total_orc = str_replace(",", "", $this->input->post('total_orc'));
        $overallDiscount = str_replace(",", "", $this->input->post('overallDiscount'));
        $discountType = str_replace(",", "", $this->input->post('discountType'));

        $estimate_purchase_price = str_replace(",", "", $this->input->post('estimate_purchase_price'));
        $initial_est_purchase_price = str_replace(",", "", $this->input->post('initial_est_purchase_price'));
        $total_est_purchase_price = str_replace(",", "", $this->input->post('total_est_purchase_price'));
        $profit_by_user = str_replace(",", "", $this->input->post('profit_by_user'));

        $renewal_date = $this->input->post('renewal_date');
        $type = $this->input->post('type');
        $contact_name = $this->input->post('contact_name');
        if(isset($_POST['subscr_type'])){
            $subscrtype= $this->input->post('subscr_type');
        }
        else{
            $subscrtype='notselected';
        }
        
        $renewal_date_cal = $this->input->post('renewal_date_cal');
        if ($renewal_date_cal != "") {
            $renewaldate = $renewal_date_cal;
        } else {
            $renewaldate = $renewal_date;
        }
        if ($this->input->post('igst') != "") {
            $igst = implode("<br>", $this->input->post('igst'));
        } else {
            $igst = '';
        }

        if ($this->input->post('product_Id') != "") {
            $proId = implode("<br>", $this->input->post('product_Id'));
        } else {
            $proId = '';
        }

        if ($this->input->post('cgst') != "") {
            $cgst = implode("<br>", $this->input->post('cgst'));
        } else {
            $cgst = '';
        }
        if ($this->input->post('sgst') != "") {
            $sgst = implode("<br>", $this->input->post('sgst'));
        } else {
            $sgst = '';
        }

        if ($this->input->post('is_newed')) {
            $is_newed = $this->input->post('is_newed');
        } else {
            $is_newed = 0;
        }

        if ($this->input->post('extra_charge') != "") {
            $extra_charge = implode("<br>", $this->input->post('extra_charge'));
        } else {
            $extra_charge = '';
        }
        if ($this->input->post('extra_chargevalue') != "") {
            $extra_chargevalue = implode("<br>", $this->input->post('extra_chargevalue'));
        } else {
            $extra_chargevalue = '';
        }

        if (check_permission_status('No need to approve sales order', 'other') == true) {
            $sttsAuto = 1;
            $approved_by = 'Auto';
        } else {
            $sttsAuto = 0;
            $approved_by = '';
        }

        $checkPer = check_workflow('Sales order', 'Auto approve by limit SO');
        if (isset($checkPer['trigger_workflow_on']) && $checkPer['trigger_workflow_on'] == 1 && $sub_total <= $checkPer['price_limit']) {
            $sttsAuto = 1;
            $approved_by = 'Auto, less than limit';
        }

        $advanced_payment = str_replace(",", "", $this->input->post('advance_payment'));
        if ($advanced_payment == "") {
            $advanced_payment = 0;
        }
        $pendingPayment = $sub_total - $advanced_payment;
        $carrier = $this->input->post('carrier');
        if ($carrier == 'other') {
            $carrier = $this->input->post('other_courier_name');
        }

        $currentdate = $this->input->post('currentdate');
        if ($currentdate != '') {
            $createdDate = $currentdate;
        } else {
            $createdDate = date("Y-m-d");
        }

        $data = [
            'sess_eml' => $sess_eml,
            'session_company' => $session_company,
            'session_comp_email' => $session_comp_email,
            'owner' => $owner,
            'org_name' => $this->input->post('org_name'),
            'org_id' => $this->input->post('org_id_act'),
            'cont_id' => $this->input->post('cnt_id_act'),
            'subject' => $subject,
            'contact_name' => $contact_name,
            'opp_name' => $this->input->post('opp_name'),
            'pending' => $this->input->post('pending'),
            'quote_id' => $quote_id,
            'excise_duty' => $this->input->post('excise_duty'),
            'due_date' => $this->input->post('due_date'),
            
             'po_date' => $this->input->post('po_date'),
            'po_no' => $po_no,
            
            
            'courier_docket_no' => $this->input->post('courier_docket_no'),
            'carrier' => $carrier,
            'status' => $status,
            'sales_commision' => $this->input->post('sales_commission'),
            'payment_terms' => $this->input->post('paymentTerms'),
            'billing_country' => $this->input->post('billing_country'),
            'billing_state' => $this->input->post('billing_state'),
            'shipping_country' => $this->input->post('shipping_country'),
            'shipping_state' => $this->input->post('shipping_state'),
            'billing_city' => $this->input->post('billing_city'),
            'billing_zipcode' => $this->input->post('billing_zipcode'),
            'shipping_city' => $this->input->post('shipping_city'),
            'shipping_zipcode' => $this->input->post('shipping_zipcode'),
            'billing_address' => $this->input->post('billing_address'),
            'shipping_address' => $this->input->post('shipping_address'),
            'type' => $type,
            'subscr_type'=>$subscrtype,
            'pro_dummy_id' => $proId,
            'salesorder_item_type' => implode("<br>", $this->input->post('salesorder_item_type')),
            'product_name' => implode("<br>", $this->input->post('product_name')),
            'hsn_sac' => implode("<br>", $this->input->post('hsn_sac')),
            'sku' => implode("<br>", $this->input->post('sku')),
            'gst' => implode("<br>", $this->input->post('gst')),
            'quantity' => implode("<br>", $this->input->post('quantity')),
            'unit_price' => implode("<br>", $unit_price),
            'total' => implode("<br>", $total),
            //'percent' 			=> implode("<br>",$this->input->post('percent')),
            'pro_description' => implode("<br>", $this->input->post('pro_description')),
            'initial_total' => $initial_total,
            //'discount' 			=> $this->input->post('discount'),
            'discount_type' => $discountType,
            'overall_discount' => $overallDiscount,
            'after_discount' => $after_discount,
            'sub_totals' => $sub_total,
            'total_percent' => $this->input->post('total_percent'),
            'profit_by_user' => $profit_by_user,
            'terms_condition' => $terms_condition,
            'pay_terms_status' => $sttsAuto,
            'approved_by' => $approved_by,
            'customer_company_name' => $this->input->post('customer_company_name'),
            'advanced_payment' => $advanced_payment,
            'pending_payment' => $pendingPayment,
            'customer_name' => $this->input->post('customer_name'),
            'customer_email' => $this->input->post('customer_email'),
            'customer_mobile' => $this->input->post('customer_mobile'),
            'microsoft_lan_no' => $this->input->post('microsoft_lan_no'),
            'promo_id' => $this->input->post('promo_id'),
            'customer_address' => $this->input->post('customer_address'),
            'estimate_purchase_price' => implode("<br>", $estimate_purchase_price),
            'initial_estimate_purchase_price' => implode("<br>", $initial_est_purchase_price),
            'total_estimate_purchase_price' => $total_est_purchase_price,
            'total_orc' => $total_orc,
            'product_line' => count($this->input->post('product_name')),
            'currentdate' => $createdDate,
            'opportunity_id' => $opportunity_id,
            'is_renewal' => $is_newed,
            'renewal_date' => $renewaldate,
            'igst' => $igst,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'sub_total_with_gst' => implode("<br>", $this->input->post('sub_total_with_gst')),
            'extra_charge_label' => $extra_charge,
            'extra_charge_value' => $extra_chargevalue,
            'pro_discount' => implode("<br>", $this->input->post('discount_price')),
            'total_igst' => str_replace(",", "", $this->input->post('total_igst')),
            'total_cgst' => str_replace(",", "", $this->input->post('total_cgst')),
            'total_sgst' => str_replace(",", "", $this->input->post('total_sgst')),
        ];

        $checkPerCmp = check_workflow('Sales order', 'Comolete sales order without purchase order');
        if (isset($checkPerCmp['trigger_workflow_on']) && $checkPerCmp['trigger_workflow_on'] == 1) {
            $data['total_percent'] = '0';
        }

        if (isset($data)) {
            $id = $this->Salesorders->create($data);

            $saleorder_id = updateid($id, 'salesorder', 'saleorder_id');

            $reportdate = date("y.m.d");
            $data = ['track_status' => 'salesorder'];
            $this->Lead->update_lead_track_status(['opportunity_id' => $opportunity_id], $data);
            $data['stage'] = 'Closed Won';
            $this->Opportunity->update_opp_track_status(['opportunity_id' => $opportunity_id], $data);
            $this->load->model('Notification_model');
            $data = $this->Notification_model->addNotification('salesorders', $id);

            add_customer_activity($id, 
            $this->input->post('org_name'), 
            $this->input->post('org_id_act'), 
            $this->input->post('cnt_id_act'), 
            $this->input->post('contact_name'), 
            'customer_sales_order');

            $productName = $this->input->post('product_name');
            $hsn_sac = $this->input->post('hsn_sac');
            $sku = $this->input->post('sku');
            $gst = $this->input->post('gst');
            $quantity = $this->input->post('quantity');
            $unit_price = $unit_price;
            $total = $total;

            $productQty = count($productName);
            for ($pr = 0; $pr < $productQty; $pr++) {
                $dtatArr = [
                    'sess_eml' => $sess_eml,
                    'session_company' => $session_company,
                    'session_comp_email' => $session_comp_email,
                    'so_id' => $saleorder_id,
                    'pro_name' => $productName[$pr],
                    'hsn_code' => $hsn_sac[$pr],
                    'sku' => $sku[$pr],
                    'pro_gst' => $gst[$pr],
                    'so_qty' => $quantity[$pr],
                    'so_q_price' => $unit_price[$pr],
                    'so_pro_total' => $total[$pr],
                    'so_after_discount' => $after_discount,
                    //'so_discount'		=> $this->input->post('discount'),
                    'so_orc' => $total_orc,
                    'so_created_date' => date('Y-m-d'),
                    'so_owner' => $owner,
                ];

                $this->Salesorders->addProductProfit($dtatArr);
            }

            echo json_encode(["status" => true, 'id' => $id]);

            $contact_email = $this->Contact_model->check_duplicate_contact_name($contact_name, $this->input->post('org_name'));

            /*
	$workFlowStsAdmin	= check_workflow_status('Admin','Mail notification on sales order created');
	$workFlowStsStsUser	= check_workflow_status('Sales order','Mail notification to sales order owner on sales order created');
	$workFlowStsStsCust	= check_workflow_status('Customer','Mail notification on so created');
	
	$permissionSts		= check_permission_status('Receive mail on create sales order','other');
	
	if($workFlowStsAdmin==true){
		$messageBody='';
		$subjectLine="Sales Order Confirmation - team365 | CRM";
		$messageBody.='<div class="f-fallback">
            <h1>Dear , '.ucwords($this->session->userdata('company_name')).'!</h1>';
            $messageBody.='<p>A sales order just loaded  from team365 | CRM</p>';
            $messageBody.='<p>Order loaded by '.ucwords($this->session->userdata('name')).'</p>';
    		$messageBody.='<p>Order detail are given bellow:-</p>';
			$messageBody.='<p>Subject : '.$subject.'</p>';
    		$messageBody.='<p>
			Customer Name : '.$this->input->post('org_name').'
			<br>
			Contact Name : '.$contact_name.'
			<br>
			Salesorder ID : '.$saleorder_id.'
			</p>';
			$messageBody.='For More details <a href="'.base_url().'salesorders/view_pi_so/'.$id.'"> click here</a></p>';
    		$messageBody.=' </div>';
			sendMailWithTemp($this->session->userdata('company_email'),$messageBody,$subjectLine);
	}
	
	if($permissionSts==true && $workFlowStsStsUser==true){
		$messageBody='';
		$subjectLine="Order Confirmation - team365 | CRM";
		$messageBody.='<div class="f-fallback">
            <h1>Dear , '.ucwords($this->session->userdata('name')).'!</h1>';
            $messageBody.='<p>You just loaded a sales order from team365 | CRM</p>';
    		$messageBody.='<p>Your Order Detail are given bellow:-</p>';
			$messageBody.='<p>Subject : '.$subject.'</p>';
    		$messageBody.='<p>
			Customer Name : '.$this->input->post('org_name').'
			<br>
			Contact Name : '.$contact_name.'
			<br>
			Salesorder ID : '.$saleorder_id.'
			</p>';
			$messageBody.='For More details <a href="'.base_url().'salesorders/view_pi_so/'.$id.'"> click here</a></p>';
    		$messageBody.=' </div>';
			sendMailWithTemp($this->session->userdata('email'),$messageBody,$subjectLine);
	}
	
		if($this->input->post('is_email')){
			$is_email=$this->input->post('is_email');
		}else{
			$is_email=0;
		}
	
	
	    if($workFlowStsStsCust==true || $is_email){
			$messageBody='';
            $messageBody='<div class="f-fallback">
            <h1>Dear , '.ucwords($contact_name).'!</h1>';
    		$messageBody.='<p>Thank you for shopping at '.$this->session->userdata('company_name').'.</p>';
    		$messageBody.='<p>We appreciate your continued patronage and feel honored that you have chosen our product.</p>';
    		$messageBody.='<p>Our company will do the best of our abilities to meet your expectations and provide the service that you deserve.</p>';
    		$messageBody.='<p>We have grown so much as a corporation because of customers like you, and we certainly look forward to more years of partnership with you.</p>
    		<p>Again, thank you for your business.</p><br>
    		<p>Sincerely,</p> <p>'.$this->session->userdata('company_name').'</p>';
    		$messageBody.=' </div>';    
			$subEmail = 'Salesorder confirmation | '.$this->session->userdata('company_name');
			sendMailWithTemp($contact_email['email'],$messageBody,$subEmail);
	    }*/
        }
    }
    
    public function getbyId($id)
    {
        $data = $this->Salesorders->get_by_id($id);
        echo json_encode($data);
    }

    public function getbyId_for_po($id)
    {
        $this->load->model('Purchaseorders_model', 'Purchaseorders');
        $data = $this->Salesorders->get_by_id($id);
        $arrayData = [];

        $arrayData['id'] = $data->id;
        $arrayData['saleorder_id'] = $data->saleorder_id;
        $arrayData['subject'] = $data->subject;

        $arrayData['opportunity_id'] = $data->opportunity_id;
        $arrayData['org_name'] = $data->org_name;
        $arrayData['currentdate'] = $data->currentdate;
        $arrayData['owner'] = $data->owner;
        $arrayData['product_line'] = $data->product_line;
        $arrayData['sess_eml'] = $data->sess_eml;
        $arrayData['contact_name'] = $data->contact_name;
        $arrayData['billing_country'] = $data->billing_country;
        $arrayData['billing_state'] = $data->billing_state;
        $arrayData['billing_city'] = $data->billing_city;
        $arrayData['billing_zipcode'] = $data->billing_zipcode;
        $arrayData['billing_address'] = $data->billing_address;
        $arrayData['shipping_country'] = $data->shipping_country;
        $arrayData['shipping_state'] = $data->shipping_state;
        $arrayData['shipping_city'] = $data->shipping_city;
        $arrayData['shipping_zipcode'] = $data->shipping_zipcode;

        $arrayData['shipping_address'] = $data->shipping_address;
        $arrayData['type'] = $data->type;
        $arrayData['pay_terms_status'] = $data->pay_terms_status;
        $arrayData['is_renewal'] = $data->is_renewal;
        $arrayData['renewal_date'] = $data->renewal_date;

        $producrName = explode("<br>", $data->product_name);
        $quantity = explode("<br>", $data->quantity);
        $unit_price = explode("<br>", $data->unit_price);
        $total = explode("<br>", $data->total);
        $percent = explode("<br>", $data->percent);
        $prodescription = explode("<br>", $data->pro_description);
        $hsn_sac = explode("<br>", $data->hsn_sac);

        $gst = explode("<br>", $data->gst);
        $initial_estimate_purchase_price = explode("<br>", $data->initial_estimate_purchase_price);
        $estimate_purchase_price = explode("<br>", $data->estimate_purchase_price);
        $sku = explode("<br>", $data->sku);

        $ArrTOStrPr = [];
        $ArrTOStrQty = [];
        $ArrTOStrUPr = [];
        $ArrTOStrTtl = [];
        $ArrTOStrPer = [];
        $ArrTOStrHsn = [];
        $ArrTOStrSku = [];
        $ArrTOStrGst = [];
        $ArrTOStrIni = [];
        $ArrTOStrEst = [];
        $ArrTOStrDescr = [];

        for ($rw = 0; $rw < count($producrName); $rw++) {
            $prname = $producrName[$rw];
            $dataPr = $this->Purchaseorders->getProductInfo($data->saleorder_id, $prname);
            if (count($dataPr) < 1) {
                $ArrTOStrPr[] = $producrName[$rw];
                $ArrTOStrQty[] = $quantity[$rw];
                $ArrTOStrUPr[] = $unit_price[$rw];
                $ArrTOStrTtl[] = $total[$rw];
                $ArrTOStrPer[] = $percent[$rw];
                $ArrTOStrDescr[] = $prodescription[$rw];
                $ArrTOStrHsn[] = $hsn_sac[$rw];
                $ArrTOStrSku[] = $sku[$rw];
                $ArrTOStrGst[] = $gst[$rw];
                $ArrTOStrIni[] = $initial_estimate_purchase_price[$rw];
                $ArrTOStrEst[] = $estimate_purchase_price[$rw];
            }
        }

        $arrayData['product_name'] = implode("<br>", $ArrTOStrPr);
        $arrayData['quantity'] = implode("<br>", $ArrTOStrQty);
        $arrayData['unit_price'] = implode("<br>", $ArrTOStrUPr);
        $arrayData['total'] = implode("<br>", $ArrTOStrTtl);
        $arrayData['percent'] = implode("<br>", $ArrTOStrPer);
        $arrayData['pro_description'] = implode("<br>", $ArrTOStrDescr);
        $arrayData['hsn_sac'] = implode("<br>", $ArrTOStrHsn);
        $arrayData['sku'] = implode("<br>", $ArrTOStrSku);
        $arrayData['gst'] = implode("<br>", $ArrTOStrGst);
        $arrayData['initial_estimate_purchase_price'] = implode("<br>", $ArrTOStrIni);
        $arrayData['estimate_purchase_price'] = implode("<br>", $ArrTOStrEst);

        $arrayData['initial_total'] = $data->initial_total;
        $arrayData['discount'] = $data->discount;
        $arrayData['after_discount'] = $data->after_discount;
        $arrayData['igst12'] = $data->igst12;
        $arrayData['igst18'] = $data->igst18;
        $arrayData['igst28'] = $data->igst28;
        $arrayData['cgst6'] = $data->cgst6;

        $arrayData['sgst6'] = $data->sgst6;
        $arrayData['cgst9'] = $data->cgst9;
        $arrayData['sgst9'] = $data->sgst9;
        $arrayData['cgst14'] = $data->cgst14;
        $arrayData['sgst14'] = $data->sgst14;
        $arrayData['sub_totals'] = $data->sub_totals;
        $arrayData['customer_company_name'] = $data->customer_company_name;
        $arrayData['customer_name'] = $data->customer_name;

        $arrayData['customer_email'] = $data->customer_email;
        $arrayData['customer_mobile'] = $data->customer_mobile;
        $arrayData['customer_address'] = $data->customer_address;
        $arrayData['microsoft_lan_no'] = $data->microsoft_lan_no;
        $arrayData['promo_id'] = $data->promo_id;
        $arrayData['total_estimate_purchase_price'] = $data->total_estimate_purchase_price;
        $arrayData['total_percent'] = $data->total_percent;

        echo json_encode($arrayData);

        // echo json_encode($data);
    }

    public function update()
    {
        $validation = $this->check_validation();
        if ($validation != 200) {
            echo $validation;
            die();
        } else {
            $initial_total = str_replace(",", "", $this->input->post('initial_total'));
            $unit_price = str_replace(",", "", $this->input->post('unit_price'));
            $total = str_replace(",", "", $this->input->post('total'));
            $after_discount = str_replace(",", "", $this->input->post('after_discount'));
            $sub_total = str_replace(",", "", $this->input->post('sub_total'));
            $total_orc = str_replace(",", "", $this->input->post('total_orc'));
            $overallDiscount = str_replace(",", "", $this->input->post('overallDiscount'));
            $discountType = str_replace(",", "", $this->input->post('discountType'));
            $estimate_purchase_price = str_replace(",", "", $this->input->post('estimate_purchase_price'));
            $initial_est_purchase_price = str_replace(",", "", $this->input->post('initial_est_purchase_price'));
            $total_est_purchase_price = str_replace(",", "", $this->input->post('total_est_purchase_price'));
            $profit_by_user = str_replace(",", "", $this->input->post('profit_by_user'));
            $renewal_date_cal = $this->input->post('renewal_date_cal');
            $renewal_date = $this->input->post('renewal_date');
            if ($renewal_date_cal != "") {
                $renewaldate = $renewal_date_cal;
            } else {
                $renewaldate = $renewal_date;
            }

            if ($this->input->post('terms_condition')) {
                $terms_condition = implode("<br>", $this->input->post('terms_condition'));
            } else {
                $terms_condition = "";
            }

            if ($this->input->post('product_Id') != "") {
                $proId = implode("<br>", $this->input->post('product_Id'));
            } else {
                $proId = '';
            }

            if ($this->input->post('igst') != "") {
                $igst = implode("<br>", $this->input->post('igst'));
            } else {
                $igst = '';
            }
            if ($this->input->post('cgst') != "") {
                $cgst = implode("<br>", $this->input->post('cgst'));
            } else {
                $cgst = '';
            }
            if ($this->input->post('sgst') != "") {
                $sgst = implode("<br>", $this->input->post('sgst'));
            } else {
                $sgst = '';
            }

            if ($this->input->post('extra_charge') != "") {
                $extra_charge = implode("<br>", $this->input->post('extra_charge'));
            } else {
                $extra_charge = '';
            }
            if ($this->input->post('extra_chargevalue') != "") {
                $extra_chargevalue = implode("<br>", $this->input->post('extra_chargevalue'));
            } else {
                $extra_chargevalue = '';
            }

            $advanced_payment = str_replace(",", "", $this->input->post('advance_payment'));
            if ($advanced_payment == "") {
                $advanced_payment = 0;
            }
            $pendingPayment = $sub_total - $advanced_payment;
            $carrier = $this->input->post('carrier');
            if ($carrier == 'other') {
                $carrier = $this->input->post('other_courier_name');
            }
            $id = $this->input->get('id');
        //    $ids = $this->input->post('id');
        //     print_r($ids);die;
            $data = [
                'org_name' => $this->input->post('org_name'),
                'subject' => $this->input->post('subject'),
                'contact_name' => $this->input->post('contact_name'),
                'opp_name' => $this->input->post('opp_name'),
                'pending' => $this->input->post('pending'),
                'quote_id' => $this->input->post('quote_id'),
                'excise_duty' => $this->input->post('excise_duty'),
                'due_date' => $this->input->post('due_date'),
                
                 'po_date' => $this->input->post('po_date'),
                'po_no' => $this->input->post('po_no'),
            
                'courier_docket_no' => $this->input->post('courier_docket_no'),
                'carrier' => $carrier,
                'status' => $this->input->post('status'),
                'sales_commision' => $this->input->post('sales_commission'),
                'payment_terms' => $this->input->post('paymentTerms'),
                'billing_country' => $this->input->post('billing_country'),
                'billing_state' => $this->input->post('billing_state'),
                'shipping_country' => $this->input->post('shipping_country'),
                'shipping_state' => $this->input->post('shipping_state'),
                'billing_city' => $this->input->post('billing_city'),
                'billing_zipcode' => $this->input->post('billing_zipcode'),
                'shipping_city' => $this->input->post('shipping_city'),
                'shipping_zipcode' => $this->input->post('shipping_zipcode'),
                'billing_address' => $this->input->post('billing_address'),
                'shipping_address' => $this->input->post('shipping_address'),
                'type' => $this->input->post('type_hidden'),
                'pro_dummy_id' => $proId,
                'salesorder_item_type' => implode("<br>", $this->input->post('salesorder_item_type')),
                'product_name' => implode("<br>", $this->input->post('product_name')),
                'hsn_sac' => implode("<br>", $this->input->post('hsn_sac')),
                'sku' => implode("<br>", $this->input->post('sku')),
                'gst' => implode("<br>", $this->input->post('gst')),
                'quantity' => implode("<br>", $this->input->post('quantity')),
                'unit_price' => implode("<br>", $unit_price),
                'total' => implode("<br>", $total),
                //'percent' 		=> implode("<br>",$this->input->post('percent')),
                'pro_description' => implode("<br>", $this->input->post('pro_description')),
                'initial_total' => $initial_total,
                'discount' => $this->input->post('discount'),
                'discount_type' => $discountType,
                'overall_discount' => $overallDiscount,
                'after_discount' => $after_discount,
                /*'igst12' 			=> $this->input->post('igst12'),
                  'igst18' 			=> $this->input->post('igst18'),
                  'igst28' 			=> $this->input->post('igst28'),
                  'cgst6' 			=> $this->input->post('cgst6'),
                  'sgst6' 			=> $this->input->post('sgst6'),
                  'cgst9' 			=> $this->input->post('cgst9'),
                  'sgst9' 			=> $this->input->post('sgst9'),
                  'cgst14' 			=> $this->input->post('cgst14'),
                  'sgst14' 			=> $this->input->post('sgst14'),*/
                'sub_totals' => $sub_total,
                //'total_percent' => $this->input->post('total_percent'),
                'advanced_payment' => $advanced_payment,
                'pending_payment' => $pendingPayment,
                'profit_by_user' => $profit_by_user,
                'terms_condition' => $terms_condition,
                'customer_company_name' => $this->input->post('customer_company_name'),
                'customer_name' => $this->input->post('customer_name'),
                'customer_email' => $this->input->post('customer_email'),
                'customer_mobile' => $this->input->post('customer_mobile'),
                'microsoft_lan_no' => $this->input->post('microsoft_lan_no'),
                'promo_id' => $this->input->post('promo_id'),
                'customer_address' => $this->input->post('customer_address'),
                'estimate_purchase_price' => implode("<br>", $estimate_purchase_price),
                'initial_estimate_purchase_price' => implode("<br>", $initial_est_purchase_price),
                'total_estimate_purchase_price' => $total_est_purchase_price,
                'total_orc' => $total_orc,
                'product_line' => count($this->input->post('product_name')),
                'is_renewal' => $this->input->post('is_newed'),
                'renewal_date' => $renewaldate,
                'igst' => $igst,
                'cgst' => $cgst,
                'sgst' => $sgst,
                'sub_total_with_gst' => implode("<br>", $this->input->post('sub_total_with_gst')),
                'extra_charge_label' => $extra_charge,
                'extra_charge_value' => $extra_chargevalue,
                'pro_discount' => implode("<br>", $this->input->post('discount_price')),
                'total_igst' => str_replace(",", "", $this->input->post('total_igst')),
                'total_cgst' => str_replace(",", "", $this->input->post('total_cgst')),
                'total_sgst' => str_replace(",", "", $this->input->post('total_sgst')),
            ];

            $currentdate = $this->input->post('currentdate');
            if ($currentdate != '') {
                $createdDate = $currentdate;
                $data['currentdate'] = $currentdate;
            }
            $result = $this->Salesorders->update([
                'id' => $this->input->post('id'), 
                'session_company' => $this->session->userdata('company_name'), 
                'session_comp_email' => $this->session->userdata('company_email')], $data);
            // Update purchase order 
            $purdata = [
                'product_name' => implode("<br>", $this->input->post('product_name')),
                'unit_price' => implode("<br>", $estimate_purchase_price),
                'quantity' => implode("<br>", $this->input->post('quantity')),
            ];
            $res2 = $this->Purchaseorders->update(
                ['saleorder_id' => $this->input->post('saleorderId'), 
                'session_company' => $this->session->userdata('company_name'), 
                'session_comp_email' => $this->session->userdata('company_email')],
                $purdata
            );

            $saleorderId = $this->input->post('saleorderId');
            $productName = $this->input->post('product_name');
            $hsn_sac = $this->input->post('hsn_sac');
            $sku = $this->input->post('sku');
            $gst = $this->input->post('gst');
            $quantity = $this->input->post('quantity');
            $owner = $this->input->post('owner');
            $unit_price = $unit_price;
            $total = $total;
            $productQty = count($productName);
            for ($pr = 0; $pr < $productQty; $pr++) {
                $dtatArr = [
                    'hsn_code' => $hsn_sac[$pr],
                    'sku' => $sku[$pr],
                    'pro_gst' => $gst[$pr],
                    'so_qty' => $quantity[$pr],
                    'so_q_price' => $unit_price[$pr],
                    'so_pro_total' => $total[$pr],
                    'so_after_discount' => $after_discount,
                    //'so_discount'		=> $this->input->post('discount'),
                    'so_orc' => $total_orc,
                ];
                $upresult = $this->Salesorders->checkForUpdate($saleorderId, $productName[$pr]);

                if ($upresult != false) {
                    $this->Salesorders->goForUpdate($dtatArr, $upresult[0]['id']);
                } else {
                    $sess_eml = $this->session->userdata('email');
                    $session_comp_email = $this->session->userdata('company_email');
                    $session_company = $this->session->userdata('company_name');

                    $dtatArr['sess_eml'] = $sess_eml;
                    $dtatArr['session_company'] = $session_company;
                    $dtatArr['session_comp_email'] = $session_comp_email;
                    $dtatArr['so_id'] = $saleorderId;
                    $dtatArr['pro_name'] = $productName[$pr];
                    $dtatArr['so_created_date'] = date('Y-m-d');
                    $dtatArr['so_owner'] = $owner;

                    $this->Salesorders->addProductProfit($dtatArr);
                }
            }
            if (!empty($result)) {
                $reportdate = date("y.m.d");
                $x = "100";
                $slo = $id + $x;
                $saleorder_id = "SO/" . date('Y') . "/" . $slo;
                $this->Reports->salesorder_reportdate($reportdate, $saleorder_id);

                echo json_encode(["status" => true, 'id' => $this->input->post('id')]);
            } else {
                echo json_encode(["status" => false]);
            }
        }
    }

    public function check_validation()
    {
        // $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
        // $this->form_validation->set_rules('quote_id', 'Quotation Id', 'required|trim');
        // $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
        // $this->form_validation->set_rules('contact_name', 'Contact Name', 'required|trim');
        // $this->form_validation->set_rules('opp_name', 'Opportunity Name', 'required|trim');
        // $this->form_validation->set_rules('billing_country', 'Billing Country', 'required|trim');
        // $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
        // $this->form_validation->set_rules('shipping_country', 'Shipping Country', 'required|trim');
        // $this->form_validation->set_rules('shipping_state', 'Sipping State', 'required|trim');
        // $this->form_validation->set_rules('billing_city', 'Billing City', 'required|trim');
        // $this->form_validation->set_rules('billing_zipcode', 'Billing Zipcode', 'required|trim');
        // $this->form_validation->set_rules('shipping_zipcode', 'Shipping Zipcode', 'required|trim');
        // $this->form_validation->set_rules('shipping_city', 'Shipping City', 'required|trim');
        // $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
        // $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'required|trim');
        // $this->form_validation->set_message('required', '%s is required');
        // if ($this->form_validation->run() == false) {
        //     return json_encode([
        //         'st' => 202,
        //         'quote_id' => form_error('quote_id'),
        //         'subject' => form_error('subject'),
        //         'opp_name' => form_error('opp_name'),
        //         'contact_name' => form_error('contact_name'),
        //         'billing_country' => form_error('billing_country'),
        //         'billing_state' => form_error('billing_state'),
        //         'shipping_country' => form_error('shipping_country'),
        //         'shipping_state' => form_error('shipping_state'),
        //         'billing_city' => form_error('billing_city'),
        //         'billing_zipcode' => form_error('billing_zipcode'),
        //         'shipping_city' => form_error('shipping_city'),
        //         'shipping_zipcode' => form_error('shipping_zipcode'),
        //         'billing_address' => form_error('billing_address'),
        //         'shipping_address' => form_error('shipping_address'),
        //     ]);
        // } else {
        //     return 200;
        // }
        // return 202;
        return true;
    }
    public function delete($id, $soid)
    {
        $this->Salesorders->delete($id);
        $this->Salesorders->ProDuctDelete($soid);
        echo json_encode(["status" => true]);
    }
    public function delete_bulk()
    {
        if ($this->input->post('checkbox_value')) {
            $id = $this->input->post('checkbox_value');
            for ($count = 0; $count < count($id); $count++) {
                $this->Salesorders->delete_bulk($id[$count]);
            }
        }
    }
     public function view()
    {
        $this->load->library('pdf');
        if ($this->uri->segment(3)) {
            // $download = $this->uri->segment(4);
            $id = $this->uri->segment(3);
            $html_content = '';
            $html_content .= $this->Salesorders->view($id);
            // print_r($html_content);die;
            $this->dompdf->loadHtml($html_content);
            ini_set('memory_limit', '128M');
            $this->dompdf->render();

            $canvas = $this->dompdf->getCanvas();
            $pdf = $canvas->get_cpdf();

            foreach ($pdf->objects as &$o) {
                if ($o['t'] === 'contents') {
                    $o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
                }
            }

            if (isset($download) && $download == 'dn') {
                $this->dompdf->stream("SALESORDER_" . $id . ".pdf", ["Attachment" => 1]);
            } else {
                $this->dompdf->stream("SALESORDER_" . $id . ".pdf", ["Attachment" => 0]);
            }
        }
    }
    public function getnotifyfilter()
    {
        $date = $this->input->post('notify_date');
        $data = $this->Salesorders->get_pending_salesorder($date);
        echo json_encode($data);
    }
    public function view_pi_so($id)
    {
        if (!empty($this->session->userdata('email'))) {
            if (checkModuleForContr('Create Salesorder') < 1) {
                redirect('home');
                exit();
            }

            $this->db->select('so.*,org.email');
            $this->db->where('so.id', $id);
            $this->db->from('salesorder as so');
            $this->db->join('organization as org', 'org.org_name=so.org_name');
            $data['record'] = $this->db->get()->row_array();
            $this->load->view('sales/view-salesorder', $data);

            if ($this->session->userdata('type') == 'admin') {
                $this->load->model('Notification_model');
                $qid = $id;
                $notifor = 'salesorders';
                $podata = $this->Notification_model->update_noti('so_id', $qid, $notifor);
            }

            //$data['paymentAd'] = $this->invoice_model->get_inv_payment($product_id);
        } else {
            redirect('login');
        }
    }

    public function generate_pdf_attachment($so_id)
    {
        $this->load->library('pdf');

        //$download='';
        $html_content = '';
        $html_content .= $this->Salesorders->view($so_id);
        $this->dompdf->loadHtml($html_content);
        ini_set('memory_limit', '128M');
        $this->dompdf->render();
        $canvas = $this->dompdf->getCanvas();
        $pdf = $canvas->get_cpdf();

        foreach ($pdf->objects as &$o) {
            if ($o['t'] === 'contents') {
                $o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
            }
        }
        $attachmentpdf = $this->dompdf->output();
        $path = "assets/img/SALESORDER" . $so_id . ".pdf";
        file_put_contents($path, $attachmentpdf);
        return $path;
    }

    public function send_email()
    {
        $orgName = $this->input->post('orgName');
        $orgEmail = $this->input->post('orgEmail');
        $ccEmail = $this->input->post('ccEmail');
        $subEmail = $this->input->post('subEmail');
        $descriptionTxt = $this->input->post('descriptionTxt');
        $invoiceurl = $this->input->post('invoiceurl');
        $so_id = $this->input->post('so_id');
        //attachment
        $attach_pdf = $this->generate_pdf_attachment($so_id);

        $messageBody = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title></title>
        <style type="text/css" rel="stylesheet" media="all">
        body{width:100%!important;height:100%;margin:0;-webkit-text-size-adjust:none}a{color:#3869d4}td{word-break:break-word}
       body,td,th{font-family:"Nunito Sans",Helvetica,Arial,sans-serif}h1{margin-top:0;color:#333;font-size:22px;font-weight:700;text-align:left}
       td,th{font-size:16px}blockquote,ol,p,ul{margin:.4em 0 1.1875em;font-size:16px;line-height:1.625}p.sub{font-size:13px}.align-right{text-align:right}
       .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:0}
       .related{width:100%;margin:0;padding:25px 0 0 0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0}
       .related_item{padding:10px 0;color:#cbcccf;font-size:15px;line-height:18px}.related_item-title{display:block;margin:.5em 0 0}
       .related_heading{border-top:1px solid #cbcccf;text-align:center;padding:25px 0 10px}body{background-color:#f4f4f7;color:#51545e}p{color:#51545e}p.sub{color:#6b6e76}   .email-body{width:100%;margin:0;padding:0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0;background-color:#fff}
       .body-sub{margin-top:25px;padding-top:25px;border-top:1px solid #eaeaec}.content-cell{padding:35px}@media only screen and (max-width:600px){.email-body_inner,
       .email-footer{width:100%!important}}@media (prefers-color-scheme:dark){.email-body,.email-body_inner,.email-content,.email-footer,
       </style>
      </head>
      <body>
        <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td align="center">
              <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="email-masthead" align="center">
                    <a href="https://team365.io/" class="f-fallback email-masthead_name">';
        $image = $this->session->userdata('company_logo');
        if (!empty($image)) {
            $messageBody .= '<img  src="' . base_url() . '/uploads/company_logo/' . $image . '">';
        } else {
            $messageBody .= '<span class="h5 text-primary">' . $this->session->userdata('company_name') . '</span>';
        }
        $messageBody .=
            '</a>
                  </td>
                </tr>
                <!-- Email Body -->
                <tr>
                  <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                    <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                      <!-- Body content -->
                      <tr>
                        <td class="content-cell">
                          <div class="f-fallback">
                            <h1>Hi, ' .
            ucwords($orgName) .
            '!</h1>';

        $messageBody .= '<p>Thank you for shopping at ' . $this->session->userdata('company_name') . '.</p>';
        $messageBody .= '<p>We appreciate your continued patronage and feel honored that you have chosen our product.</p>';
        $messageBody .= '<p>Our company will do the best of our abilities to meet your expectations and provide the service that you deserve.</p>';
        $messageBody .= '<p>We have grown so much as a corporation because of customers like you, and we certainly look forward to more years of partnership with you.</p>';

        $messageBody .=
            '<!-- Action -->
                            <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                              <tr>
                                <td align="center">
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                    <tr>
                                      <td align="center">
                                        <a href="' .
            $invoiceurl .
            '" class="f-fallback button" target="_blank">View Salesorder Invoice</a>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>';
        $messageBody .= $descriptionTxt;
        $messageBody .=
            '</div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                      <tr>
                        <td class="content-cell" align="center">
                          <p class="f-fallback sub align-center">&copy; ' .
            date("Y") .
            ' team365. All rights reserved</p>
                          <p class="f-fallback sub align-center">team365</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </body>
    </html>';

        if (!$this->email_lib->send_email($orgEmail, $subEmail, $messageBody, $ccEmail, $attach_pdf)) {
            echo "0";
        } else {
            echo "1";
        }
        unlink($attach_pdf);
        exit();
    }


    //<-----------------------  Mass Update --------------------------------->

    public function add_mass()
	{
        
	    if ($this->input->is_ajax_request()) {

        $mass_id = $this->input->post('mass_id');
        $mass_name = $this->input->post('mass_name');
        $mass_value = $this->input->post('mass_value');
			$dataArry = array(
				$mass_name => $mass_value,
				'datetime' => date('Y-m-d')
				
			);
        // print_r($dataArry);die;
			$mass_data = $this->Salesorders->mass_save($mass_id, $dataArry);
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
?>
