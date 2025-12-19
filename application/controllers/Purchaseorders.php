<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchaseorders extends CI_Controller
{
    /**
    * Purchaseorders controller constructor — initializes the parent controller and loads required helpers, models and libraries.
    * @example
    * $purchaseorders = new Purchaseorders();
    * // Controller is initialized; models (Quotation, Salesorders, Reports, Purchaseorders, Login, Lead, Opportunity, Workflow)
    * // and libraries (upload, pdf) are available via $this inside the controller.
    * @param void $none - No parameters are accepted.
    * @returns void Constructs the controller and prepares helpers, models and libraries for use.
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Quotation_model', 'Quotation');
        $this->load->model('Salesorders_model', 'Salesorders');
        $this->load->model('Reports_model', 'Reports');
        $this->load->model('Purchaseorders_model', 'Purchaseorders');
        $this->load->model('Login_model', 'Login');
        $this->load->model('Lead_model', 'Lead');
        $this->load->model('Opportunity_model', 'Opportunity');
        $this->load->model('Workflow_model');
        $this->load->library('upload');
        $this->load->library(['pdf']);
    }
    /**
     * Display the Purchase Orders page or redirect based on session and permission checks.
     * @example
     * // If user is logged in and has 'Purchase Order' retrieve permission:
     * // $data passed to the view (sample values):
     * // $data = [
     * //   'branch' => 'Main Branch',
     * //   'renewal_data' => [['po_id' => 123, 'status' => 'pending_renewal']],
     * //   'workflow_details' => [['id' => 1, 'name' => 'Purchaseorder approved by user']],
     * //   'user' => 'jdoe',
     * //   'admin' => 'adminUser',
     * //   'countPO' => 42
     * // ];
     * // Usage:
     * $controller = new Purchaseorders();
     * $controller->index();
     * @returns {void} Loads the 'inventory/purchaseorders' view with prepared data or redirects to 'permission' or 'login'.
     */
    public function index()
    {
        if (!empty($this->session->userdata('email'))) {
            /*if(checkModuleForContr('Inventory')<1){
	        redirect('home');
	    }*/
            if (check_permission_status('Purchase Order', 'retrieve_u') == true) {
                $data['branch'] = $this->Login->branch_name();
                $data['renewal_data'] = $this->Purchaseorders->get_renewal_po();
                $data['workflow_details'] = $this->Workflow_model->get_workflows_byModule('Purchaseorders', 'Purchaseorder approved by user');
                $data['user'] = $this->Login->getusername();
                $data['admin'] = $this->Login->getadminname();
                $data['countPO'] = $this->Purchaseorders->count_all();
                $this->load->view('inventory/purchaseorders', $data);
            } else {
                redirect('permission');
            }
        } else {
            redirect('login');
        }
    }
    /**
     * Load and render the "subpurchaseorders" view after verifying the user session and permissions.
     * @example
     * // From a controller context
     * $this->Purchaseorders->subpurchaseorders();
     * // Renders the 'inventory/subpurchaseorders' view populated with:
     * //   $data['branch'] => string (e.g. 'Main Branch')
     * //   $data['renewal_data'] => array (e.g. [['po_id' => 123, 'status' => 'renewal']])
     * //   $data['workflow_details'] => array (e.g. [['id' => 1, 'name' => 'Purchaseorder approved by user']])
     * //   $data['user'] => string (e.g. 'jdoe')
     * //   $data['admin'] => string (e.g. 'adminuser')
     * //   $data['countPO'] => int (e.g. 42)
     * // If the session is not present it redirects to 'login'. If the user lacks retrieve permission it redirects to 'permission'.
     * @returns void Performs redirects on failure or loads the 'inventory/subpurchaseorders' view on success.
     */
    public function subpurchaseorders(){
        if (!empty($this->session->userdata('email'))) {
            /*if(checkModuleForContr('Inventory')<1){
	        redirect('home');
	    }*/
            if (check_permission_status('Purchase Order', 'retrieve_u') == true) {
                $data['branch'] = $this->Login->branch_name();
                $data['renewal_data'] = $this->Purchaseorders->get_renewal_po();
                $data['workflow_details'] = $this->Workflow_model->get_workflows_byModule('Purchaseorders', 'Purchaseorder approved by user');
                $data['user'] = $this->Login->getusername();
                $data['admin'] = $this->Login->getadminname();
                $data['countPO'] = $this->Purchaseorders->count_all();
                $this->load->view('inventory/subpurchaseorders', $data);
            } else {
                redirect('permission');
            }
        } else {
            redirect('login');
        }
    }

    /**
     * Load the Add Purchase Order page: prepares data (record, action, branch, gstPer, countPO) and renders the 'inventory/add-purchase-order' view after checking create/update permissions.
     * @example
     * // Example 1: direct add (no URI segment or GET parameter)
     * $this->Purchaseorders->add_purchase();
     * // Expected behavior: renders 'inventory/add-purchase-order' with $data['action'] = ['data' => 'add', 'from' => 'direct'].
     *
     * // Example 2: add from a quotation via GET parameter
     * $_GET['so'] = 'SO123';
     * $this->Purchaseorders->add_purchase();
     * // Expected behavior: $data['record'] loaded from Salesorders->get_data_for_update('SO123') and view rendered with ['data' => 'add', 'from' => 'quotation'].
     *
     * // Example 3: update via URI segment (e.g. /purchaseorders/45)
     * // When $this->uri->segment(2) returns '45':
     * $this->Purchaseorders->add_purchase();
     * // Expected behavior: $data['record'] loaded from Purchaseorders->get_data_for_update(45) and view rendered with ['data' => 'update', 'from' => 'salesorder'].
     *
     * @param void $none - No arguments.
     * @returns void Does not return a value; either renders the purchase order view with prepared data or redirects to 'permission' if access is denied.
     */
    public function add_purchase()
    {
        if (check_permission_status('Purchase Order', 'create_u') == true || check_permission_status('Purchase Order', 'update_u') == true) {
            $id = $this->uri->segment(2);
            if (isset($_GET['so']) && $_GET['so'] != "") {
                $data['record'] = $this->Salesorders->get_data_for_update($_GET['so']);
                $data['action'] = ['data' => 'add', 'from' => 'quotation'];
            } elseif (isset($id) && $id != "") {
                $data['record'] = $this->Purchaseorders->get_data_for_update($id);
                $data['action'] = ['data' => 'update', 'from' => 'salesorder'];
            } else {
                $data['action'] = ['data' => 'add', 'from' => 'direct'];
            }
            $data['branch'] = $this->Login->branch_name();
            $data['gstPer'] = $this->Salesorders->get_gst();
            $data['countPO'] = $this->Purchaseorders->count_all();
            
            $this->load->view('inventory/add-purchase-order', $data);
        } else {
            redirect('permission');
        }
    }

    /**
     * Add or update a sub-purchase order view based on user permissions and request context.
     * Determines whether to load data for a sales order, an existing purchase order (including subscription PO), 
     * or prepare a direct add action, then loads the 'inventory/add-subpurchaseorder' view or redirects to permission page.
     * @example
     * // Controller invocation example:
     * $this->Purchaseorders->add_subpurchase();
     * // Expected behavior: loads view 'inventory/add-subpurchaseorder' with $data (e.g. branch, gstPer, countPO, action, record)
     * // or redirects to 'permission' if the user lacks create/update Purchase Order permission.
     * @param void $none - No parameters required.
     * @returns void Executes view loading or redirect; does not return a value.
     */
    public function add_subpurchase()
    {
        if (check_permission_status('Purchase Order', 'create_u') == true || check_permission_status('Purchase Order', 'update_u') == true) {
            $id = $this->uri->segment(2);
            if (isset($_GET['so']) && $_GET['so'] != "") {
                $data['record'] = $this->Salesorders->get_data_for_update($_GET['so']);
                $data['action'] = ['data' => 'add', 'from' => 'quotation'];
            } elseif (isset($id) && $id != "") {
                $data['record'] = $this->Purchaseorders->get_data_for_update($id);
                $issubscr_poexixsts=$this->Purchaseorders->checkexists('subscription_po',['po_id'=>$id]);
                $data['subscr_po'] = $this->Purchaseorders->get_data_for_update_subscr_po($issubscr_poexixsts['id']);
                
                if($issubscr_poexixsts){
                    $data['action'] = ['data' => 'update', 'from' => 'salesorder'];
                }
                else{
                    $data['action'] = ['data' => 'add', 'from' => 'direct'];
                }
            } else {
                $data['action'] = ['data' => 'add', 'from' => 'direct'];
            }
            $data['branch'] = $this->Login->branch_name();
            $data['gstPer'] = $this->Salesorders->get_gst();
            $data['countPO'] = $this->Purchaseorders->count_all();
            
            $this->load->view('inventory/add-subpurchaseorder', $data);
        } else {
            redirect('permission');
        }
    }
    

    /**
    * Change the approval status of a purchase order (based on POST input) and send notification emails according to workflow and permissions.
    * @example
    * // Called via HTTP POST (for example from an AJAX request or form submission)
    * $_POST['poid'] = 123;
    * $_POST['povalue'] = 1;
    * $this->Purchaseorders->changeStatus();
    * // echoes '1' on success, '0' on update failure, '2' if the user lacks permission
    * @param {int} $poid - Purchase order ID passed via POST (key: 'poid'), e.g. 123.
    * @param {int} $povalue - Approval flag passed via POST (key: 'povalue'): 1 to approve, other to unapprove, e.g. 1.
    * @returns {int|string} Echoed status: 1 = success, 0 = failure, 2 = permission denied.
    */
    public function changeStatus()
    {
        if (check_permission_status('Purchase Order can approve', 'other') == true) {
            $purchase_data = $this->Purchaseorders->get_by_id($this->input->post('poid'));
            $value = $this->input->post('povalue');
            if ($value == 1) {
                $stts = 1;
            } else {
                $stts = 0;
            }
            $approved_by = $this->session->userdata('name');
            $chngeSt = ['approve_status' => $stts, 'approved_by' => $approved_by];
            $where = ['id' => $this->input->post('poid')];
            $data = $this->Purchaseorders->statusPOapprove($where, $chngeSt, $stts);
            echo $data;
            if ($data == 1) {
                $workFlowStsStsUser = check_workflow_status('Purchase order', 'Mail notification to PO owner on purchase order approve');
                $checkPermissionStatus = check_permission_status('Receive mail on approving purchase order', 'other');
                if ($checkPermissionStatus == true && $workFlowStsStsUser == true) {
                    $messagetoSoWoner = '';
                    $subjectSoWoner = "Your purchase order status confirmation - team365 | CRM";
                    $messagetoSoWoner .=
                        '<div class="f-fallback">
            <h1>Dear , ' .
                        $purchase_data->owner .
                        '!</h1>';
                    $messagetoSoWoner .= '<p>Your "' . $purchase_data->subject . '", purchase order has been approved.</p>';
                    $messagetoSoWoner .= '<p>Purchase order detail:-</p>';
                    $messagetoSoWoner .= '<p>Subject : ' . $purchase_data->subject . '</p>';
                    $messagetoSoWoner .=
                        '<p>
			Sales Order ID : ' .
                        $purchase_data->purchaseorder_id .
                        '
			<br>
			Product : ' .
                        str_replace("<br>", ", ", $purchase_data->product_name) .
                        '
			<br>
			Approved By : ' .
                        $approved_by .
                        '
			</p>';
                    $messagetoSoWoner .=
                        'For More details <a href="' .
                        base_url() .
                        'purchaseorders/view_pi_po/' .
                        $purchase_data->id .
                        '"> click here</a> or copy this url and paste in your browser<br>
			URL - ' .
                        base_url() .
                        'purchaseorders/view_pi_po/' .
                        $purchase_data->id .
                        '
			</p>';
                    $messagetoSoWoner .= '</div>';
                    sendMailWithTemp($purchase_data->sess_eml, $messagetoSoWoner, $subjectSoWoner);
                }

                $workFlowStsAdmin = check_workflow_status('Admin', 'Mail notification on approve purchase order');
                /*  SEND TO ADMIN  */
                if ($workFlowStsAdmin == true) {
                    $messagetoAdmin = '';
                    $subjectAdmin = "Purchase order status confirmation - team365 | CRM";
                    $messagetoAdmin .= '<div class="f-fallback">
            <h1>Dear , Admin!</h1>';
                    $messagetoAdmin .= '<p>A "' . $purchase_data->subject . '", purchase order has been approved.</p>';
                    $messagetoAdmin .= '<p>Purchase order detail:-</p>';
                    $messagetoAdmin .= '<p>Subject : ' . $purchase_data->subject . '</p>';
                    $messagetoAdmin .=
                        '<p>
			Purchase order ID : ' .
                        $purchase_data->saleorder_id .
                        '
			<br>
			Product : ' .
                        str_replace("<br>", ", ", $purchase_data->product_name) .
                        '
			<br>
			Approved By : ' .
                        $approved_by .
                        '
			</p>';
                    $messagetoSoWoner .=
                        'For more details <a href="' .
                        base_url() .
                        'purchaseorders/view_pi_po/' .
                        $purchase_data->id .
                        '"> click here</a> or copy this url and paste in your browser<br>
			URL - ' .
                        base_url() .
                        'purchaseorders/view_pi_po/' .
                        $purchase_data->id .
                        '
			</p>';
                    $messagetoAdmin .= '</div>';
                    sendMailWithTemp($purchase_data->session_comp_email, $messagetoAdmin, $subjectAdmin);
                }
            }
        } else {
            echo '2';
        }
    }


    /////////////////////////////////////////////////////// fetch data for po_graph (monthwise) starts/////////////////////////////////


    public function po_graph(){
        $data['grouped_data'] = $this->Purchaseorders->getpo_graph();
        $response = [
            'status' => 'success',
            'data' => $data['grouped_data']  
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


 /////////////////////////////////////////////////////// fetch data for po_graph (monthwise) ends/////////////////////////////////


    /**
    * Generate and echo a DataTables-compatible JSON list of purchase orders for AJAX requests.
    * @example
    * // Example: list all purchase orders
    * $this->ajax_list(null);
    * // Example: list purchase orders for subscription id 5
    * $this->ajax_list(5);
    * // Sample output (trimmed):
    * // {"draw":1,"recordsTotal":42,"recordsFiltered":10,"data":[["<a href='...'>Company</a>","Supplier Name","Subject","PO123","Owner","<i class='...'></i>","01 Jan 2025","<div class='row'>...</div>"], ...]}
    * @param {{int|null}} $subscr - Optional subscription/filter id; pass null to retrieve all purchase orders.
    * @returns {{void}} Outputs JSON directly (echos a DataTables-formatted response and does not return a value).
    */
    public function ajax_list($subscr=null)
    {
       
       
        $delete_po = 0;
        $update_po = 0;
        $retrieve_po = 0;
        $po_approval = 0;
        if (check_permission_status('Purchase Order', 'delete_u') == true) {
            $delete_po = 1;
        }
        if (check_permission_status('Purchase Order', 'retrieve_u') == true) {
            $retrieve_po = 1;
        }
        if (check_permission_status('Purchase Order', 'update_u') == true) {
            $update_po = 1;
        }
        if (check_permission_status('Sales Order can approve', 'other') == true) {
            $po_approval = 1;
        }
        if($subscr != null){
            $list = $this->Purchaseorders->get_datatables($subscr);
        }else{
            $list = $this->Purchaseorders->get_datatables();
        }
        $data = [];
        $no = $_POST['start'];
        $dataAct = $this->input->post('actDate');

        foreach ($list as $post) {
            $no++;
            $row = [];
            // APPEND HTML FOR ACTION
            if ($delete_po == 1) {
                if ($dataAct != 'actdata') {
                    // $row[] = '<input type="checkbox" class="delete_checkbox" value="' . $post->id . '">';
                     $row[] = '<input type="checkbox" class="delete_checkbox" onClick="checkCheckbox(); showAction(' . $post->id . ');" name="action_ck" value="'.$post->id.'">';
                }
            }
            $companydetail = "
            <div class='d-flex align-items-center'>
                <img src='".base_url('')."/application/views/assets/images/faces/4.jpg' alt='img'
                    class='rounded-circle mr-2' style='width: 1.75rem; height: 1.75rem;'>
                <div>
                    <span>".ucfirst($post->customer_company_name)."</span><br>
                    
                </div>
            </div>";
            $first_row = "";
            $first_row .= ucfirst($post->supplier_comp_name) . '<!--<div class="links">';
            if ($retrieve_po == 1):
                $first_row .= '<a style="text-decoration:none" href="' . base_url() . 'purchaseorders/view_pi_po/' . $post->id . '" class="text-success">View</a>';
            endif;
            if ($update_po == 1):
                $first_row .= '|<a style="text-decoration:none" href="' . base_url() . 'add-purchase-order/' . $post->id . '" class="text-primary">Update</a>';
            endif;
            if ($delete_po == 1):
                $first_row .= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry(' . "'" . $post->id . "'" . ',' . "'" . $post->saleorder_id . "'" . ')" class="text-danger">Delete</a>';
            endif;
            $first_row .= '</div> -->';
            $idpurchaseorder =" 
                <span style='color: rgba(140, 80, 200, 1);
                font-weight: 700;'>".ucfirst($post->purchaseorder_id)."</span>";       
            // $row[] = $companydetail ;
             $row[] = '<a style="text-decoration:none" href="' . base_url() . 'purchaseorders/view_pi_po/' . $post->id . '">' . $companydetail . '</a>';
            $row[] = $first_row;
            
            $row[] = ucfirst($post->supplier_name);
            $row[] = $post->subject;
            $row[] = $idpurchaseorder;
            $row[] = ucfirst($post->owner);

            /*if(isset($post->approve_status) && $post->approve_status==1){
			    $StatusSo= '';
				$StatusSo.="Approved by ".ucwords($post->approved_by);
				if($po_approval==1):
				$StatusSo.='<div class="links"><a style="text-decoration:none" href="javascript:void(0)"  id="textid'.$post->id.'" class="text-success" onclick="approve_po_entry('."'".$post->id."'".',`'.$post->purchaseorder_id.'`,`0`,`textid'.$post->id.'`)" >Click to disapprove</a></div>';
				endif;
				$row[] = $StatusSo;
			}else{
			    $StatusSo= '';
				$StatusSo.= '<span class="text-danger" style="padding:2px;">Approval Pending</span>';
				if($po_approval==1):
				$StatusSo.='<div class="links"><a style="text-decoration:none;" href="javascript:void(0)" id="textid'.$post->id.'"  class="text-primary" onclick="approve_po_entry('."'".$post->id."'".',`'.$post->purchaseorder_id.'`,`1`,`textid'.$post->id.'`)">Click to approve</a></div>';
			    endif;
				$row[] = $StatusSo;
			}*/

            if (isset($post->approve_status) && $post->approve_status == 1) {
                $StatusSo = '';
                $StatusSo .= '<div class="text-center"><i class="far fa-check-circle text-success" data-toggle="tooltip" data-container="body" title="Approved by ' . ucwords($post->approved_by) . '" ></i></div>';
                $row[] = $StatusSo;
            } else {
                $StatusSo = '';
                $StatusSo .= '<div class="text-center"><i class="far fa-times-circle text-danger"  data-toggle="tooltip" data-container="body" title="Approval Pending"></i></div>';
                $row[] = $StatusSo;
            }

            //
            $newDate = date("d M Y", strtotime($post->datetime));
            $row[] = $newDate;
            // $row[] = "<text style='font-size: 12px;' data-toggle='tooltip' data-container='body' title='".$newDate."' >".time_elapsed_string($post->datetime)."</text>";

            $action = '<div class="row" style="font-size: 15px;">';
            if ($retrieve_po == 1) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'purchaseorders/view_pi_po/' .
                    $post->id .
                    '"  class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Purchase Order Details" ></i></a>';
            }
            if ($update_po == 1) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'add-purchase-order/' .
                    $post->id .
                    '"class="text-primary border-right">
					<i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Purchase Order Details" ></i></a>';
            }

            if (isset($post->approve_status) && $post->approve_status == 1) {
                if ($po_approval == 1):
                    $action .=
                        '<a style="text-decoration:none" href="javascript:void(0)" id="textid' .
                        $post->id .
                        '" class="text-success border-right" onclick="approve_po_entry(' .
                        "'" .
                        $post->id .
                        "'" .
                        ',`' .
                        $post->purchaseorder_id .
                        '`,`0`,`textid' .
                        $post->id .
                        '`)" ><i class="far fa-thumbs-up text-success m-1"  data-toggle="tooltip" data-container="body" title="Click to disapprove"></i></a>';
                endif;
            } else {
                if ($po_approval == 1):
                    $action .=
                        '<a style="text-decoration:none;" href="javascript:void(0)" id="textid' .
                        $post->id .
                        '"  class="text-primary border-right" onclick="approve_po_entry(' .
                        "'" .
                        $post->id .
                        "'" .
                        ',`' .
                        $post->purchaseorder_id .
                        '`,`1`,`textid' .
                        $post->id .
                        '`)" ><i class="far fa-thumbs-down text-info m-1"  data-toggle="tooltip" data-container="body" title="Click to approve"></i></a>';
                endif;
            }

            if ($delete_po == 1) {
                $action .=
                    '<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry(' .
                    "'" .
                    $post->id .
                    "'" .
                    ',' .
                    "'" .
                    $post->saleorder_id .
                    "'" .
                    ')"   class="text-danger">
					<i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Purchase Order" ></i></a>';
            }
            $action .='
            
            <a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            &nbsp; <i class="fas fa-ellipsis-h fa-1x" style="color:purple;"></i>
  
  </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="">
    <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="'.base_url().'purchaseorders/view_pi_po/' . $post->id . '">Open</a></div>
    <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="'.base_url().'add-purchaseorder/' . $post->id . '">Edit</a></div>
    <div class="dropdown-item sendmailpo" data-id="'.$post->id.'" data-po_number="'.$post->purchaseorder_id.'"><a style="color:black; padding-left:0px;"  href="javascript:void(0);">Send Email</a></div>
    <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="">Send Whatsapp</a></div>
    <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="">Duplicate</a></div>
    <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="">Copy Quotation link</a></div>
    <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="'.base_url().'purchaseorders/view/' . $post->id . '/dn">Download</a></div>
    <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="javascript:void(0)" onclick="">Delete</a></div>
  </div>
  
           ';
            $action .= '</div>';

            $row[] = $action;

            $data[] = $row;
        }
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Purchaseorders->count_all(),
            "recordsFiltered" => $this->Purchaseorders->count_filtered(),
            "data" => $data,
        ];
        //output to json format
        echo json_encode($output);
    }




    /**
     * Prepare and echo JSON for an AJAX DataTable listing of purchase orders (optionally filtered by subscription).
     * Builds each row's HTML (company info, links, action icons) according to the current user's permissions
     * and returns a DataTables-compatible JSON payload containing draw, recordsTotal, recordsFiltered and data.
     * @example
     * // Example: call from a controller method or AJAX endpoint
     * $sample_subscr = 12; // e.g. subscription id to filter by, or null to fetch all
     * $this->subscrpo_ajax_list($sample_subscr);
     * // Sample output (abridged):
     * // {"draw":1,"recordsTotal":42,"recordsFiltered":10,"data":[["<a...>","Supplier Name","Subject","PO-123","Owner","type","01 Jan 2025","<actions>"], ...]}
     * @param int|null $subscr - Optional subscription/filter id used to limit the purchase orders list.
     * @returns void Echoes JSON directly (no return value).
     */
    public function subscrpo_ajax_list($subscr=null)
    {
        $delete_po = 0;
        $update_po = 0;
        $retrieve_po = 0;
        $po_approval = 0;
        if (check_permission_status('Purchase Order', 'delete_u') == true) {
            $delete_po = 1;
        }
        if (check_permission_status('Purchase Order', 'retrieve_u') == true) {
            $retrieve_po = 1;
        }
        if (check_permission_status('Purchase Order', 'update_u') == true) {
            $update_po = 1;
        }
        if (check_permission_status('Sales Order can approve', 'other') == true) {
            $po_approval = 1;
        }
        if($subscr != null){
            $list = $this->Purchaseorders->get_datatables($subscr);
        }else{
            $list = $this->Purchaseorders->get_datatables();
        }
        $data = [];
        $no = $_POST['start'];
        $dataAct = $this->input->post('actDate');

        foreach ($list as $post) {
            $no++;
            $row = [];
            // APPEND HTML FOR ACTION
            if ($delete_po == 1) {
                if ($dataAct != 'actdata') {
                    // $row[] = '<input type="checkbox" class="delete_checkbox" value="' . $post->id . '">';
                     $row[] = '<input type="checkbox" class="delete_checkbox" onClick="checkCheckbox(); showAction(' . $post->id . ');" name="action_ck" value="'.$post->id.'">';
                    // $row[]='<span> <i class="fas fa-angle-right left"></i></span>';
                    
                }
            }
            $companydetail = "
    <div class='d-flex align-items-center'>
        <img src='".base_url('')."/application/views/assets/images/faces/4.jpg' alt='img'
            class='rounded-circle mr-2' style='width: 1.75rem; height: 1.75rem;'>
        <div>
            <span>".ucfirst($post->customer_company_name)."</span><br>
            
        </div>
    </div>";
            $first_row = "";
            $first_row .= ucfirst($post->supplier_comp_name) . '<!--<div class="links">';
            if ($retrieve_po == 1):
                $first_row .= '<a style="text-decoration:none" href="' . base_url() . 'purchaseorders/view_pi_po/' . $post->id . '" class="text-success">View</a>';
            endif;
            if ($update_po == 1):
                $first_row .= '|<a style="text-decoration:none" href="' . base_url() . 'add-purchase-order/' . $post->id . '" class="text-primary">Update</a>';
            endif;
            if ($delete_po == 1):
                $first_row .= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry(' . "'" . $post->id . "'" . ',' . "'" . $post->saleorder_id . "'" . ')" class="text-danger">Delete</a>';
            endif;
            $first_row .= '</div> -->';
            $idpurchaseorder =" 
            <span style='color: rgba(140, 80, 200, 1);
            font-weight: 700;'>".ucfirst($post->purchaseorder_id)."</span>";
            // $row[] = $companydetail ;
            $row[] = '<a style="text-decoration:none" href="' . base_url() . 'purchaseorders/view_pi_po/' . $post->id . '">' . $companydetail . '</a>';
            $row[] = $first_row;
            
            $row[] = ucfirst($post->supplier_name);
            $row[] = $post->subject;
            $row[] = $idpurchaseorder;
            $row[] = ucfirst($post->owner);

            $row[]='<div>'. $post->subscr_type .'</div>';

            //
            $newDate = date("d M Y", strtotime($post->datetime));
            $row[] = $newDate;
            // $row[] = "<text style='font-size: 12px;' data-toggle='tooltip' data-container='body' title='".$newDate."' >".time_elapsed_string($post->datetime)."</text>";

            $action = '<div class="row" style="font-size: 15px;">';
            if ($retrieve_po == 1) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'purchaseorders/view_pi_po/' .
                    $post->id .
                    '"  class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Purchase Order Details" ></i></a>';
            }
            if ($update_po == 1) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'add-subpurchaseorder/' .
                    $post->id .
                    '"class="text-primary border-right">
					<i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Purchase Order Details" ></i></a>';
            }

            if (isset($post->approve_status) && $post->approve_status == 1) {
                if ($po_approval == 1):
                    $action .=
                        '<a style="text-decoration:none" href="javascript:void(0)" id="textid' .
                        $post->id .
                        '" class="text-success border-right" onclick="approve_po_entry(' .
                        "'" .
                        $post->id .
                        "'" .
                        ',`' .
                        $post->purchaseorder_id .
                        '`,`0`,`textid' .
                        $post->id .
                        '`)" ><i class="far fa-thumbs-up text-success m-1"  data-toggle="tooltip" data-container="body" title="Click to disapprove"></i></a>';
                endif;
            } else {
                if ($po_approval == 1):
                    $action .=
                        '<a style="text-decoration:none;" href="javascript:void(0)" id="textid' .
                        $post->id .
                        '"  class="text-primary border-right" onclick="approve_po_entry(' .
                        "'" .
                        $post->id .
                        "'" .
                        ',`' .
                        $post->purchaseorder_id .
                        '`,`1`,`textid' .
                        $post->id .
                        '`)" ><i class="far fa-thumbs-down text-info m-1"  data-toggle="tooltip" data-container="body" title="Click to approve"></i></a>';
                endif;
            }

           
           
            $action .= '</div>';

            $row[] = $action;

            $data[] = $row;
        }
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Purchaseorders->count_all(),
            "recordsFiltered" => $this->Purchaseorders->count_filtered(),
            "data" => $data,
        ];
        //output to json format
        echo json_encode($output);
    }
    /**
     * Return JSON autocomplete suggestions for Sales Order IDs based on the GET 'term' query string and current session context.
     * @example
     * // Request (HTTP GET):
     * // GET /purchaseorders/autocomplete_soid?term=SO123
     * // Example successful JSON response:
     * // [{"label":"SO123"},{"label":"SO124"}]
     * // Example when no matches found:
     * // [{"label":"No Salesorder Found"}]
     * @param string|null $term - Optional search term passed via $_GET['term'] used to match saleorder_id values.
     * @returns string JSON-encoded array (echoed) of suggestion objects, each with a single "label" property.
     */
    public function autocomplete_soid()
    {
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
        if (isset($_GET['term'])) {
            $result = $this->Purchaseorders->get_so_id($_GET['term'], $sess_eml, $session_company, $session_comp_email);
            if (count($result) > 0) {
                foreach ($result as $row) {
                    $arr_result[] = [
                        'label' => $row->saleorder_id,
                    ];
                }
                echo json_encode($arr_result);
            } else {
                $arr_result[] = [
                    'label' => "No Salesorder Found",
                ];
                echo json_encode($arr_result);
            }
        }
    }

    public function check_product_po()
    {
        $saleorderId = $this->input->post('saleorder_id');
        $ProName = $this->input->post('productName');
        $data = $this->Purchaseorders->getProductInfo($saleorderId, $ProName);
        if (count($data) > 0) {
            echo $data[0]['pro_name'];
        } else {
            echo 'found';
        }
    }

    /**
    * Retrieve Sale Order details from POST data (saleorder_id) and echo a JSON response containing SO fields and only those products that are not already present in Purchase Orders. If all products already have POs, an error message JSON is returned.
    * @example
    * // Example (controller context, POST contains saleorder_id)
    * $_POST = ['saleorder_id' => 101];
    * $this->input->set_post($_POST); // CodeIgniter input population example
    * $this->get_SO_details();
    * // Possible successful output:
    * // {"id":"45","opportunity_id":"23","org_name":"Acme Corp","product_name":"Widget A<br>Widget C","quantity":"2<br>1", ...}
    * // Possible error output:
    * // {"error_msg":"<i class=\"fas fa-info-circle\" style=\"color:red;\"></i>&nbsp;&nbsp;PO already created of this SO."}
    * @param array $postData - POST input (retrieved via $this->input->post()), expected to include 'saleorder_id' (int).
    * @returns string JSON-encoded string echoed to output: filtered SO details for PO creation or an error message.
    */
    public function get_SO_details()
    {
        $saleorder_id = $this->input->post();
        $data = $this->Purchaseorders->getSOValue($saleorder_id);

        $proName = explode("<br>", $data[0]['product_name']);

        $proNamepo = 0;
        $soId = $data[0]['saleorder_id'];
        $poList = $this->Salesorders->CountOrder($soId);
        foreach ($poList as $Popost) {
            $proNamepo2 = explode("<br>", $Popost->product_name);

            $proNamepo = $proNamepo + count($proNamepo2);
        }
        $SOProNameCnt = count($proName);
        $POProNameCnt = $proNamepo;
        $arrayData = [];
        if ($SOProNameCnt != $POProNameCnt) {
            $arrayData['id'] = $data[0]['id'];
            $arrayData['opportunity_id'] = $data[0]['opportunity_id'];
            $arrayData['org_name'] = $data[0]['org_name'];
            $arrayData['currentdate'] = $data[0]['currentdate'];
            $arrayData['owner'] = $data[0]['owner'];
            $arrayData['product_line'] = $data[0]['product_line'];
            $arrayData['sess_eml'] = $data[0]['sess_eml'];
            $arrayData['contact_name'] = $data[0]['contact_name'];
            $arrayData['billing_country'] = $data[0]['billing_country'];
            $arrayData['billing_state'] = $data[0]['billing_state'];
            $arrayData['billing_city'] = $data[0]['billing_city'];
            $arrayData['billing_zipcode'] = $data[0]['billing_zipcode'];
            $arrayData['billing_address'] = $data[0]['billing_address'];
            $arrayData['shipping_country'] = $data[0]['shipping_country'];
            $arrayData['shipping_state'] = $data[0]['shipping_state'];
            $arrayData['shipping_city'] = $data[0]['shipping_city'];
            $arrayData['shipping_zipcode'] = $data[0]['shipping_zipcode'];

            $arrayData['shipping_address'] = $data[0]['shipping_address'];
            $arrayData['type'] = $data[0]['type'];
            $arrayData['pay_terms_status'] = $data[0]['pay_terms_status'];

            $producrName = explode("<br>", $data[0]['product_name']);
            $quantity = explode("<br>", $data[0]['quantity']);
            $unit_price = explode("<br>", $data[0]['unit_price']);
            $total = explode("<br>", $data[0]['total']);
            $percent = explode("<br>", $data[0]['percent']);
            $hsn_sac = explode("<br>", $data[0]['hsn_sac']);
            $hsn_sac = explode("<br>", $data[0]['hsn_sac']);

            $gst = explode("<br>", $data[0]['gst']);
            $initial_estimate_purchase_price = explode("<br>", $data[0]['initial_estimate_purchase_price']);
            $estimate_purchase_price = explode("<br>", $data[0]['estimate_purchase_price']);
            $sku = explode("<br>", $data[0]['sku']);

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
            for ($rw = 0; $rw < count($producrName); $rw++) {
                $prname = $producrName[$rw];
                $dataPr = $this->Purchaseorders->getProductInfo($soId, $prname);
                if (count($dataPr) < 1) {
                    $ArrTOStrPr[] = $producrName[$rw];
                    $ArrTOStrQty[] = $quantity[$rw];
                    $ArrTOStrUPr[] = $unit_price[$rw];
                    $ArrTOStrTtl[] = $total[$rw];
                    $ArrTOStrPer[] = $percent[$rw];
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
            $arrayData['hsn_sac'] = implode("<br>", $ArrTOStrHsn);
            $arrayData['sku'] = implode("<br>", $ArrTOStrSku);
            $arrayData['gst'] = implode("<br>", $ArrTOStrGst);
            $arrayData['initial_estimate_purchase_price'] = implode("<br>", $ArrTOStrIni);
            $arrayData['estimate_purchase_price'] = implode("<br>", $ArrTOStrEst);

            $arrayData['initial_total'] = $data[0]['initial_total'];
            $arrayData['discount'] = $data[0]['discount'];
            $arrayData['after_discount'] = $data[0]['after_discount'];
            $arrayData['igst12'] = $data[0]['igst12'];
            $arrayData['igst18'] = $data[0]['igst18'];
            $arrayData['igst28'] = $data[0]['igst28'];
            $arrayData['cgst6'] = $data[0]['cgst6'];

            $arrayData['sgst6'] = $data[0]['sgst6'];
            $arrayData['cgst9'] = $data[0]['cgst9'];
            $arrayData['sgst9'] = $data[0]['sgst9'];
            $arrayData['cgst14'] = $data[0]['cgst14'];
            $arrayData['sgst14'] = $data[0]['sgst14'];
            $arrayData['sub_totals'] = $data[0]['sub_totals'];
            $arrayData['customer_company_name'] = $data[0]['customer_company_name'];
            $arrayData['customer_name'] = $data[0]['customer_name'];

            $arrayData['customer_email'] = $data[0]['customer_email'];
            $arrayData['customer_mobile'] = $data[0]['customer_mobile'];
            $arrayData['customer_address'] = $data[0]['customer_address'];
            $arrayData['microsoft_lan_no'] = $data[0]['microsoft_lan_no'];
            $arrayData['promo_id'] = $data[0]['promo_id'];
            $arrayData['total_estimate_purchase_price'] = $data[0]['total_estimate_purchase_price'];
            $arrayData['total_percent'] = $data[0]['total_percent'];

            echo json_encode($arrayData);
        } else {
            $arr_result = [
                'error_msg' => '<i class="fas fa-info-circle" style="color:red;"></i>&nbsp;&nbsp;PO already created of this SO.',
            ];
            echo json_encode($arr_result);
        }
    }
    public function get_sub_total()
    {
        $saleorder_id = $this->input->post();
        $val = $this->Purchaseorders->fetch_val($saleorder_id);
        echo json_encode($val);
    }
    public function get_sub_total_wotax()
    {
        $saleorder_id = $this->input->post();
        $val2 = $this->Purchaseorders->fetch_val_wotax($saleorder_id);
        echo json_encode($val2);
    }
    /**
    * Autocomplete vendor names (returns JSON array of {label: org_name}) based on the 'term' GET parameter and current session.
    * @example
    * // Example: simulate a request and session then call the controller method:
    * $_GET['term'] = 'Acme';
    * $this->session->set_userdata('email', 'user@example.com');
    * $this->session->set_userdata('company_name', 'Acme Co');
    * $this->session->set_userdata('company_email', 'info@acme.com');
    * $this->autocomplete_vendor();
    * // Output echoed (example): [{"label":"Acme Supplies"}]
    * @param void $none - No direct function arguments; method reads $_GET['term'] and session userdata.
    * @returns void Echoes a JSON-encoded array of vendor label objects or [{"label":"No Vendor Found"}] when none match.
    */
    public function autocomplete_vendor()
    {
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
      
        
        if (isset($_GET['term'])) {
            $result = $this->Purchaseorders->get_vendor_name($_GET['term'], $sess_eml, $session_company, $session_comp_email);
            // print_r($result);die;
            if (count($result) > 0) {
                foreach ($result as $row) {
                    $arr_result[] = [
                        'label' => $row->org_name,
                    ];
                }
                echo json_encode($arr_result);
            } else {
                $arr_result[] = [
                    'label' => "No Vendor Found",
                ];
                echo json_encode($arr_result);
            }
        }
    }
    public function get_vendor_details()
    {
        $supplier_name = $this->input->post('supplier_name');
        $data = $this->Purchaseorders->get_vendor_details($supplier_name);

        $data2 = $this->Purchaseorders->get_vendor_contact($supplier_name);
        $data3 = array_merge($data, $data2);
        echo json_encode($data);
    }
    /**
    * Create a new purchase order from POSTed form data, validate input, persist records, update related sales order/opportunity/lead, and trigger notifications. Outputs JSON on success/failure or echoes a validation error code.
    * @example
    * // Example: simulate POST inputs then call controller method
    * $_POST = [
    *   'saleorder_id' => 'SO123',
    *   'product_name' => ['Widget A'],
    *   'unit_price' => ['1,000'],
    *   'total' => ['1,000'],
    *   'sub_total' => '1000',
    *   'after_discount' => '1000',
    *   'owner' => '2',
    *   'supplier_email' => 'vendor@example.com'
    * ];
    * $this->Purchaseorders->create();
    * // Possible output (sample): {"status":true,"id":456} or echoes numeric validation code (e.g. 400)
    * @param {array} $_POST - Request POST data containing purchase order fields (e.g. saleorder_id, product_name[], unit_price[], total[], sub_total, after_discount, owner, supplier_email, etc.).
    * @returns {void} Prints a JSON response ({"status":true,"id":<id>} on success or {"st":false} on failure) or echoes a validation error code and terminates.
    */
    public function create()
    {
        $validation = $this->check_validation();
        if ($validation != 200) {
            echo $validation;
            die();
        } else {
            $saleorder_id = $this->input->post('saleorder_id');
            $progress_remain = $this->input->post('progress_remain');
            $sess_eml = $this->session->userdata('email');
            $session_company = $this->session->userdata('company_name');
            $session_comp_email = $this->session->userdata('company_email');
            $sub_total = $this->input->post('sub_total');
            $after_discount = $this->input->post('after_discount');
            $so_owner = $this->input->post('so_owner');
            $so_owner_email = $this->input->post('so_owner_email');
            $org_name = $this->input->post('org_name');
            $currentdate = date("Y-m-d");
            if(isset($_POST['subscr_type'])){
                $subscrtype= $this->input->post('subscr_type');
            }
            else{
                $subscrtype='notselected';
            }
            if ($this->input->post('terms_condition')) {
                $terms_condition = implode("<br>", $this->input->post('terms_condition'));
            } else {
                $terms_condition = "";
            }

            $proArr = [];
            $prddata = $this->Purchaseorders->check_product($saleorder_id);
            for ($i = 0; $i < count($prddata); $i++) {
                $proArr2 = explode("<br>", $prddata[$i]['product_name']);
                for ($k = 0; $k < count($proArr2); $k++) {
                    if (isset($proArr2[$k]) && $proArr2[$k] != "") {
                        $proArr[] = $proArr2[$k];
                    }
                }
            }

            $initial_total = str_replace(",", "", $this->input->post('initial_total'));
            $unit_price = str_replace(",", "", $this->input->post('unit_price'));
            $total = str_replace(",", "", $this->input->post('total'));
            $after_discount = str_replace(",", "", $this->input->post('after_discount'));
            $sub_total = str_replace(",", "", $this->input->post('sub_total'));
            $estimate_purchase_price = str_replace(",", "", $this->input->post('estimate_purchase_price'));
            $initial_est_purchase_price = str_replace(",", "", $this->input->post('initial_est_purchase_price'));
            $total_est_purchase_price = str_replace(",", "", $this->input->post('total_est_purchase_price'));
            $profit_by_user = str_replace(",", "", $this->input->post('profit_by_user'));

            $type = $this->input->post('type');
            $renewal_date = $this->input->post('renewal_date');
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

            if ($this->input->post('product_Id') != "") {
                $proId = implode("<br>", $this->input->post('product_Id'));
            } else {
                $proId = '';
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

            if (check_permission_status('No need to approve purchase order', 'other') == true) {
                $sttsAuto = 1;
                $approved_by = 'Auto';
            } else {
                $sttsAuto = 0;
                $approved_by = '';
            }
            
            if ($this->input->post('companyName_check')) {
                $checkComp_name = $this->input->post('companyName_check');
            } else {
                $checkComp_name = '';  
            }

            /*$checkPer = check_workflows('Purchase order','Auto approve by limit PO');
		if(isset($checkPer['trigger_workflow_on']) && $checkPer['trigger_workflow_on']==1 && $sub_total<=$checkPer['price_limit']){
		    $sttsAuto=1;
			$approved_by='Auto, less than limit';
		    
		}*/

            $data = [
                'sess_eml' => $sess_eml,
                'session_company' => $session_company,
                'session_comp_email' => $session_comp_email,
                'owner' => $this->input->post('owner'),
                'saleorder_id' => $saleorder_id,
                'subject' => $this->input->post('subject'),
                'contact_name' => $this->input->post('contact_name'),
                'billing_gstin' => $this->input->post('billing_gstin'),
                'shipping_gstin' => $this->input->post('shipping_gstin'),
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
                'supplier_name' => $this->input->post('supplier_name'),
                'supplier_contact' => $this->input->post('supplier_contact'),
                'supplier_gstin' => $this->input->post('supplier_gstin'),
                'supplier_comp_name' => $this->input->post('supplier_comp_name'),
                'supplier_email' => $this->input->post('supplier_email'),
                'supplier_country' => $this->input->post('supplier_country'),
                'supplier_state' => $this->input->post('supplier_state'),
                'supplier_city' => $this->input->post('supplier_city'),
                'supplier_zipcode' => $this->input->post('supplier_zipcode'),
                'supplier_address' => $this->input->post('supplier_address'),
                'pro_dummy_id' => $proId,
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
                'after_discount_po' => $after_discount,
                'type' => $type,
                'subscr_type'=>$subscrtype,
                'igst12' => str_replace(',', '', $this->input->post('igst12')),
                'igst18' => str_replace(',', '', $this->input->post('igst18')),
                'igst28' => str_replace(',', '', $this->input->post('igst28')),
                'cgst6' => str_replace(',', '', $this->input->post('cgst6')),
                'sgst6' => str_replace(',', '', $this->input->post('sgst6')),
                'cgst9' => str_replace(',', '', $this->input->post('cgst9')),
                'sgst9' => str_replace(',', '', $this->input->post('sgst9')),
                'cgst14' => str_replace(',', '', $this->input->post('cgst14')),
                'sgst14' => str_replace(',', '', $this->input->post('sgst14')),
                'sub_total' => $sub_total,
                'total_percent' => $this->input->post('total_percent'),
                'approve_status' => $sttsAuto,
                'approved_by' => $approved_by,
                //'progress' 			=> $this->input->post('progress'),
                //'progress_remain' 	=> $progress_remain,
                'terms_condition' => $terms_condition,
                'checkComp_name'  => $checkComp_name,
                'customer_company_name' => $this->input->post('company_name'),
                'customer_name' => $this->input->post('customer_name'),
                'customer_email' => $this->input->post('customer_email'),
                'customer_mobile' => $this->input->post('customer_mobile'),
                'microsoft_lan_no' => $this->input->post('microsoft_lan_no'),
                'promo_id' => $this->input->post('promo_id'),
                'customer_address' => $this->input->post('customer_address'),
                'currentdate' => $currentdate,
                'estimate_purchase_price_po' => implode("<br>", $estimate_purchase_price),
                'initial_estimate_purchase_price_po' => implode("<br>", $initial_est_purchase_price),
                //'total_estimate_purchase_price_po' 	=> $total_est_purchase_price,
                'profit_by_user_po' => $profit_by_user,
                'so_owner' => $this->input->post('owner'),
                'so_owner_email' => $sess_eml,
                'opportunity_id' => $this->input->post('opportunity_id'),
                'org_name' => $org_name,
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

            $id = $this->Purchaseorders->create($data);
            $val = $this->input->post('val');
            $val2 = $this->input->post('val2');

            /*$workflow_details = $this->Workflow_model->get_workflows_byModule('Purchaseorders','Purchaseorder approved by value');
         if(!empty($workflow_details) && count($workflow_details)>0){
             $povalue_workflowCH = $workflow_details['limit_so'];
         }else{
             $povalue_workflowCH=0;
         }*/

            if (!empty($id)) {
                $initial_total = str_replace(",", "", $this->input->post('initial_total'));
                $unit_price_prt = str_replace(",", "", $this->input->post('unit_price'));
                $total_prt = str_replace(",", "", $this->input->post('total'));
                $after_discount = str_replace(",", "", $this->input->post('after_discount'));
                $sub_total = str_replace(",", "", $this->input->post('sub_total'));
                $quantity_p = str_replace(",", "", $this->input->post('quantity'));
                $estimate_purchase_price_prt = str_replace(",", "", $this->input->post('estimate_purchase_price'));
                $initial_est_purchase_price_prt = str_replace(",", "", $this->input->post('initial_est_purchase_price'));
                $total_est_purchase_price = str_replace(",", "", $this->input->post('total_est_purchase_price'));
                $profit_by_user = str_replace(",", "", $this->input->post('profit_by_user'));
                $x = "100";
                $purchaseorder_id = updateid($id, 'purchaseorder', 'purchaseorder_id');
                $proName = $this->input->post('product_name');
                $totalSoProduct = $this->input->post('total_so_product');
                $po_product_total = count($proArr) + count($proName);
                if ($po_product_total >= $totalSoProduct) {
                    $this->Salesorders->total_percent(0, $saleorder_id);
                } else {
                    $this->Salesorders->total_percent(50, $saleorder_id);
                }
                $productLine = $this->input->post('productLine');
                $cntProduct = count($proName);
                $totalLine = intval($productLine) - intval($cntProduct);

                $this->Purchaseorders->purchaseorder_id($purchaseorder_id, $id);

                $this->load->model('Notification_model');
                $this->Notification_model->addNotification('purchaseorders', $id);

                $productQty = count($proName);

                $calc = '';
                for ($pr = 0; $pr < $productQty; $pr++) {
                    $soDetails = $this->Purchaseorders->soProfitDetails($saleorder_id, $proName[$pr]);
                    if (!empty($soDetails)) {
                        foreach ($soDetails as $postSo) {
                            $calc = intval($postSo['so_pro_total']) - intval($total_prt[$pr]);
                            $proId = $postSo['id'];
                        }
                        $dtatArr = [
                            'po_id' => $purchaseorder_id,
                            'po_qty' => $quantity_p[$pr],
                            'po_q_price' => $unit_price_prt[$pr],
                            'po_est_price' => $estimate_purchase_price_prt[$pr],
                            'po_total_est_price' => $initial_est_purchase_price_prt[$pr],
                            'po_total_price' => $total_prt[$pr],
                            'po_after_discount' => $after_discount,
                            'sales_person_margin' => $profit_by_user,
                            'actual_profit' => $calc,
                        ];
                        $this->Purchaseorders->UpdateProductProfit($dtatArr, $proId, $saleorder_id);
                    }
                }

                $data = $this->Purchaseorders->get_by_id2($id);
                /* .....  setup mail to so owner.........*/

                if (!empty($data)) {
                    foreach ($data as $row) {
                        /*$workFlowStsStsUser	= check_workflow_status('Purchase order','Mail notification to sales owner on purchase order created');
            $permissionSts = check_permission_status('Receive mail on create purchase order of user sales order','other');
            
            $workFlowStsCusto	= check_workflow_status('Customer','Mail notification on quotation created');
            
			if($permissionSts==true && $workFlowStsStsUser==true){
				$messageToSoOwner='';
				$subjectLine="Purchase order loaded of your sales order - team365 | CRM";
				$messageToSoOwner.='<div class="f-fallback">
				<h1>Dear , '.ucwords($so_owner).'!</h1>';
				$messageToSoOwner.='<p>Purchase order  just loaded for sales order #"'.$row['saleorder_id'].'" sales order from team365 | CRM</p>';
				$messageToSoOwner.='<p>Purchase order loaded by '.ucwords($this->session->userdata('name')).' </p>';
				$messageToSoOwner.='<p>Product : '.$row['product_name'].'</p>';
				$messageToSoOwner.='</div>';
				sendMailWithTemp($row['so_owner_email'],$messageToSoOwner,$subjectLine);
			}*/

                        /* .....  setup mail to po owner.........*/
                        /*$workFlowStsStsPoUser	= check_workflow_status('Purchase order','Mail notification to purchase order owner on purchase order created');
	$permissionStsPoOw = check_permission_status('Receive mail on create purchase order','other');
	
		if($permissionStsPoOw==true && $workFlowStsStsPoUser==true){
			$messageBody='';
			$subjectLine="Purchase Order Confirmation - team365 | CRM";
			$messageBody.='<div class="f-fallback">
            <h1>Dear , '.ucwords($this->session->userdata('name')).'!</h1>';
            $messageBody.='<p>You just loaded a purchase order from team365 | CRM</p>';
    		$messageBody.='<p>Your order detail are given bellow:-</p>';
			$messageBody.='<p>Subject : '.$row['subject'].'</p>';
    		$messageBody.='<p>
			Supplier Company Name : '.$row['supplier_comp_name'].'
			<br>
			Sales Order ID : '.$row['saleorder_id'].'
			<br>
			Purchase Order ID : '.$row['purchaseorder_id'].'
			</p>';
			$messageBody.='For More details <a href="'.base_url().'purchaseorders/view_pi_po/'.$row['id'].'"> click here</a></p>';
    		$messageBody.=' </div>';
			sendMailWithTemp($this->session->userdata('email'),$messageBody,$subjectLine);
		}*/
                        /*
		$workFlowStsAdmin	= check_workflow_status('Admin','Mail notification on purchase order created');
		if($workFlowStsAdmin==true){
			$messageToAdmin='';
			$subEmailAdmin = 'A new purchase order loaded by '.$this->session->userdata('name');
            $messageToAdmin='<div class="f-fallback">
            <h1>Dear, Admin!</h1>';
    		$messageToAdmin.='<p>A new purchase order loaded by '.$this->session->userdata('name').'.</p>';
    		$messageToAdmin.='<p>Purchase Order Details</p>';
    		$messageBody.='<p>Subject : '.$row['subject'].'</p>';
    		$messageBody.='<p>
			Supplier Company Name : '.$row['supplier_comp_name'].'
			<br>
			Sales Order ID : '.$row['saleorder_id'].'
			<br>
			Purchase Order ID : '.$row['purchaseorder_id'].'
			</p>';
			$messageBody.='For More details <a href="'.base_url().'purchaseorders/view_pi_po/'.$row['id'].'"> click here</a></p>';
    		$messageBody.=' </div>'; 
			sendMailWithTemp($this->session->userdata('company_email'),$messageToAdmin,$subEmailAdmin);
		}*/

                        ####### SEND MAIL TO VENDOR ##############

                        /*$workFlowStsVnr	= check_workflow_status('Vendor','Mail notification on created purchase order');
		if($workFlowStsVnr==true){
			$messageToAdmin='';
			$subEmailAdmin = 'Acknowledgement  of purchase order';
            $messageToAdmin='<div class="f-fallback">
            <h1>Dear, '.$row['supplier_comp_name'].'!</h1>';
    		$messageToAdmin.='<p>A new purchase order loaded by '.$this->session->userdata('name').'.</p>';
    		$messageToAdmin.='<p>Purchase Order Summary</p>';
    		$messageBody.='<p>Subject : '.$row['subject'].'</p>';
    		$messageBody.='<p>
			Supplier Company Name : '.$row['supplier_comp_name'].'
			<br>
			Purchase Order ID : '.$row['purchaseorder_id'].'
			</p>';
    		$messageBody.=' </div>'; 
			sendMailWithTemp($row['supplier_email'],$messageToAdmin,$subEmailAdmin);
		}*/
                    }
                }

                /**** end code mail*******/

                if ($progress_remain <= 1) {
                    $status = "Approved";
                    $this->Salesorders->status($status, $saleorder_id);
                } else {
                    $status = "Pending";
                    $this->Salesorders->status($status, $saleorder_id);
                }

                $po_data = ['track_status' => 'purchaseorder'];
                $this->Lead->update_lead_track_status(['opportunity_id' => $this->input->post('opportunity_id')], $po_data);
                $this->Opportunity->update_opp_track_status(['opportunity_id' => $this->input->post('opportunity_id')], $po_data);
                echo json_encode(["status" => true, 'id' => $id]);
            } else {
                echo json_encode(["st" => false]);
            }
        }
    }
    public function getbyId($id)
    {
        $data = $this->Purchaseorders->get_by_id($id);
        echo json_encode($data);
    }
    /**
    * Update an existing purchase order using POST/GET input: validates request, sanitizes numeric fields, updates the purchase order record, adjusts per-product profit details and emits a JSON status response.
    * @example
    * // Example (controller receives HTTP POST/GET). Sample POST values:
    * // $_POST = [
    * //   'id' => 125,
    * //   'subject' => 'Office Supplies Purchase',
    * //   'initial_total' => '1,200.00',
    * //   'unit_price' => ['400.00','800.00'],
    * //   'total' => ['400.00','800.00'],
    * //   'product_name' => ['Pens','Notebooks'],
    * //   'quantity' => ['10','5'],
    * //   'estimate_purchase_price' => ['200.00','500.00'],
    * //   'is_newed' => 1,
    * //   // ... other expected POST fields ...
    * // ];
    * $this->update();
    * // On success this echoes:
    * // {"status":true,"id":125}
    * // On update failure this echoes:
    * // {"st":false}
    * // If validation fails the function echoes a validation error code (e.g. 400) and exits.
    * @param void $none - The method does not accept direct arguments; it reads input from POST/GET and session data.
    * @returns void Echoes JSON response or a validation error code; does not return a PHP value.
    */
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
            //$total_orc 		= str_replace(",", "",$this->input->post('total_orc'));
            $estimate_purchase_price = str_replace(",", "", $this->input->post('estimate_purchase_price'));
            $initial_est_purchase_price = str_replace(",", "", $this->input->post('initial_est_purchase_price'));
            $total_est_purchase_price = str_replace(",", "", $this->input->post('total_est_purchase_price'));
            $profit_by_user = str_replace(",", "", $this->input->post('profit_by_user'));
            if ($this->input->post('terms_condition')) {
                $terms_condition = implode("<br>", $this->input->post('terms_condition'));
            } else {
                $terms_condition = "";
            }
            $id = $this->input->get('id');

            $type = $this->input->post('type');
            $renewal_date = $this->input->post('renewal_date');
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

            if ($this->input->post('product_Id') != "") {
                $proId = implode("<br>", $this->input->post('product_Id'));
            } else {
                $proId = '';
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
            
            if ($this->input->post('companyName_check')) {
                $checkComp_name = $this->input->post('companyName_check');
            } else {
                $checkComp_name = '';
            }

            $data = [
                'subject' => $this->input->post('subject'),
                'contact_name' => $this->input->post('contact_name'),
                'billing_gstin' => $this->input->post('billing_gstin'),
                'shipping_gstin' => $this->input->post('shipping_gstin'),
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
                'supplier_name' => $this->input->post('supplier_name'),
                'supplier_gstin' => $this->input->post('supplier_gstin'),
                'supplier_contact' => $this->input->post('supplier_contact'),
                'supplier_comp_name' => $this->input->post('supplier_comp_name'),
                'supplier_email' => $this->input->post('supplier_email'),
                'supplier_country' => $this->input->post('supplier_country'),
                'supplier_state' => $this->input->post('supplier_state'),
                'supplier_city' => $this->input->post('supplier_city'),
                'supplier_zipcode' => $this->input->post('supplier_zipcode'),
                'supplier_address' => $this->input->post('supplier_address'),
                'pro_dummy_id' => $proId,
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
                'discount' => $this->input->post('discount'),
                'after_discount_po' => $after_discount,
                'type' => $this->input->post('type_hidden'),

                /* 'igst12' 			=> str_replace(',','',$this->input->post('igst12')),
          'igst18' 			=> str_replace(',','',$this->input->post('igst18')),
          'igst28' 			=> str_replace(',','',$this->input->post('igst28')),
          'cgst6' 			=> str_replace(',','',$this->input->post('cgst6')),
          'sgst6' 			=> str_replace(',','',$this->input->post('sgst6')),
          'cgst9' 			=> str_replace(',','',$this->input->post('cgst9')),
          'sgst9' 			=> str_replace(',','',$this->input->post('sgst9')),
          'cgst14' 			=> str_replace(',','',$this->input->post('cgst14')),
          'sgst14' 			=> str_replace(',','',$this->input->post('sgst14')),*/

                'sub_total' => $sub_total,
                'total_percent' => $this->input->post('total_percent'),
                //'progress' 			=> $this->input->post('progress'),
                'progress_remain' => $this->input->post('progress_remain'),
                'terms_condition' => $terms_condition,
                'checkComp_name'  =>$checkComp_name,
                'customer_company_name' => $this->input->post('company_name'),
                'customer_name' => $this->input->post('customer_name'),
                'customer_email' => $this->input->post('customer_email'),
                'customer_mobile' => $this->input->post('customer_mobile'),
                'microsoft_lan_no' => $this->input->post('microsoft_lan_no'),
                'promo_id' => $this->input->post('promo_id'),
                'customer_address' => $this->input->post('customer_address'),
                'estimate_purchase_price_po' => implode("<br>", $estimate_purchase_price),
                'initial_estimate_purchase_price_po' => implode("<br>", $initial_est_purchase_price),
                // 'total_estimate_purchase_price_po' 	=> $total_est_purchase_price,
                'profit_by_user_po' => $profit_by_user,
                'is_renewal' => $this->input->post('is_newed'),
                'renewal_date' => $renewaldate,
                'type' => $type,
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
            //print_r($data);die;
            $result = $this->Purchaseorders->update(['id' => $this->input->post('id'), 'session_company' => $this->session->userdata('company_name'), 'session_comp_email' => $this->session->userdata('company_email')], $data);

            if (!empty($result)) {
                $reportdate = date("y.m.d");
                $x = "100";
                $slo = $id + $x;
                $saleorder_id = "SO/" . date('Y') . "/" . $slo;
                $this->Reports->salesorder_reportdate($reportdate, $saleorder_id);

                $proName = $this->input->post('product_name');
                $saleorderId = $this->input->post('saleorder_id');
                $initial_total = str_replace(",", "", $this->input->post('initial_total'));
                $unit_price_prt = str_replace(",", "", $this->input->post('unit_price'));
                $total_prt = str_replace(",", "", $this->input->post('total'));
                $after_discount = str_replace(",", "", $this->input->post('after_discount'));
                $sub_total = str_replace(",", "", $this->input->post('sub_total'));
                $quantity_p = str_replace(",", "", $this->input->post('quantity'));
                $estimate_purchase_price_prt = str_replace(",", "", $this->input->post('estimate_purchase_price'));
                $initial_est_purchase_price_prt = str_replace(",", "", $this->input->post('initial_est_purchase_price'));
                $total_est_purchase_price = str_replace(",", "", $this->input->post('total_est_purchase_price'));
                $profit_by_user = str_replace(",", "", $this->input->post('profit_by_user'));

                $productQty = count($proName);

                $calc = '';
                for ($pr = 0; $pr < $productQty; $pr++) {
                    $soDetails = $this->Purchaseorders->soProfitDetails($saleorderId, $proName[$pr]);
                    if (!empty($soDetails)) {
                        foreach ($soDetails as $postSo) {
                            $calc = intval($postSo['so_pro_total']) - intval($total_prt[$pr]);
                            $proId = $postSo['id'];
                        }
                        $dtatArr = [
                            'po_qty' => $quantity_p[$pr],
                            'po_q_price' => $unit_price_prt[$pr],
                            'po_est_price' => $estimate_purchase_price_prt[$pr],
                            'po_total_est_price' => $initial_est_purchase_price_prt[$pr],
                            'po_total_price' => $total_prt[$pr],
                            'po_after_discount' => $after_discount,
                            'sales_person_margin' => $profit_by_user,
                            'actual_profit' => $calc,
                        ];
                        $this->Purchaseorders->UpdateProductProfit($dtatArr, $proId, $saleorderId);
                    }
                }

                echo json_encode(["status" => true, 'id' => $this->input->post('id')]);
            } else {
                echo json_encode(["st" => false]);
            }
        }
    }

    /**
    * Create a sub purchase order from POST input, validate the request, store the PO and echo a JSON response with the created record id.
    * @example
    * $_POST = [
    *   'saleorder_id' => 456,
    *   'product_name' => ['Widget A','Widget B'],
    *   'unit_price' => ['100.00','50.00'],
    *   'sub_total' => '150.00',
    *   'po_id' => 'PO-2025-001',
    *   'owner' => 'Alice'
    * ];
    * $this->subpo_create();
    * // echoes sample output on success: {"status":true,"id":123}
    * @param array $postData - Associative array of POST inputs used by the method (e.g. 'saleorder_id' => 456, 'product_name' => ['Product A'], 'unit_price' => ['100.00'], 'sub_total' => '100.00', 'po_id' => 'PO123', 'owner' => 'John Doe').
    * @returns void Echoes JSON with {"status":true,"id":<created_id>} on success or {"st":false} on failure.
    */
    public function subpo_create(){
        $validation = $this->check_validation();
        if ($validation != 200) {
            echo $validation;
            die();
        } else {
            $saleorder_id = $this->input->post('saleorder_id');
            $progress_remain = $this->input->post('progress_remain');
            $sess_eml = $this->session->userdata('email');
            $session_company = $this->session->userdata('company_name');
            $session_comp_email = $this->session->userdata('company_email');
            $sub_total = $this->input->post('sub_total');
            $discount = $this->input->post('discount_price');
            $so_owner = $this->input->post('so_owner');
            $so_owner_email = $this->input->post('so_owner_email');
            $org_name = $this->input->post('org_name');
            $currentdate = date("Y-m-d");
            $subscrtype= $this->input->post('subscr_type');
             

            $proArr = [];
            $prddata = $this->Purchaseorders->check_product($saleorder_id);
            for ($i = 0; $i < count($prddata); $i++) {
                $proArr2 = explode("<br>", $prddata[$i]['product_name']);
                for ($k = 0; $k < count($proArr2); $k++) {
                    if (isset($proArr2[$k]) && $proArr2[$k] != "") {
                        $proArr[] = $proArr2[$k];
                    }
                }
            }

            $initial_total = str_replace(",", "", $this->input->post('initial_total'));
            $unit_price = str_replace(",", "", $this->input->post('unit_price'));
            $total = str_replace(",", "", $this->input->post('total'));
            $discount = str_replace(",", "", $this->input->post('discount_price'));
            $sub_total = str_replace(",", "", $this->input->post('sub_total'));
            $estimate_purchase_price = str_replace(",", "", $this->input->post('estimate_purchase_price'));
            $initial_est_purchase_price = str_replace(",", "", $this->input->post('initial_est_purchase_price'));
            $total_est_purchase_price = str_replace(",", "", $this->input->post('total_est_purchase_price'));
            $profit_by_user = str_replace(",", "", $this->input->post('profit_by_user'));

            $type = $this->input->post('type');
            $renewal_date = $this->input->post('renewal_date');
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

            if ($this->input->post('product_Id') != "") {
                $proId = implode("<br>", $this->input->post('product_Id'));
            } else {
                $proId = '';
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

            if (check_permission_status('No need to approve purchase order', 'other') == true) {
                $sttsAuto = 1;
                $approved_by = 'Auto';
            } else {
                $sttsAuto = 0;
                $approved_by = '';
            }

            /*$checkPer = check_workflows('Purchase order','Auto approve by limit PO');
		if(isset($checkPer['trigger_workflow_on']) && $checkPer['trigger_workflow_on']==1 && $sub_total<=$checkPer['price_limit']){
		    $sttsAuto=1;
			$approved_by='Auto, less than limit';
		    
		}*/

            $data = [
                'sess_eml' => $sess_eml,
                'session_company' => $session_company,
                'session_comp_email' => $session_comp_email,
                'owner' => $this->input->post('owner'),
                'po_id'=>$this->input->post('po_id'),
                // 'saleorder_id' => $saleorder_id,
                // 'subject' => $this->input->post('subject'),
                // 'contact_name' => $this->input->post('contact_name'),
                // 'billing_gstin' => $this->input->post('billing_gstin'),
                // 'shipping_gstin' => $this->input->post('shipping_gstin'),
                // 'billing_country' => $this->input->post('billing_country'),
                // 'billing_state' => $this->input->post('billing_state'),
                // 'shipping_country' => $this->input->post('shipping_country'),
                // 'shipping_state' => $this->input->post('shipping_state'),
                // 'billing_city' => $this->input->post('billing_city'),
                // 'billing_zipcode' => $this->input->post('billing_zipcode'),
                // 'shipping_city' => $this->input->post('shipping_city'),
                // 'shipping_zipcode' => $this->input->post('shipping_zipcode'),
                // 'billing_address' => $this->input->post('billing_address'),
                // 'shipping_address' => $this->input->post('shipping_address'),
                // 'supplier_name' => $this->input->post('supplier_name'),
                // 'supplier_contact' => $this->input->post('supplier_contact'),
                // 'supplier_gstin' => $this->input->post('supplier_gstin'),
                // 'supplier_comp_name' => $this->input->post('supplier_comp_name'),
                // 'supplier_email' => $this->input->post('supplier_email'),
                // 'supplier_country' => $this->input->post('supplier_country'),
                // 'supplier_state' => $this->input->post('supplier_state'),
                // 'supplier_city' => $this->input->post('supplier_city'),
                // 'supplier_zipcode' => $this->input->post('supplier_zipcode'),
                // 'supplier_address' => $this->input->post('supplier_address'),
                // 'pro_dummy_id' => $proId,
                'product_name' => implode("<br>", $this->input->post('product_name')),
                // 'hsn_sac' => implode("<br>", $this->input->post('hsn_sac')),
                // 'sku' => implode("<br>", $this->input->post('sku')),
                // 'gst' => implode("<br>", $this->input->post('gst')),
                // 'quantity' => implode("<br>", $this->input->post('quantity')),
                'unit_price' => implode("<br>", $unit_price),
                // 'total' => implode("<br>", $total),
                //'percent' 			=> implode("<br>",$this->input->post('percent')),
                // 'pro_description' => implode("<br>", $this->input->post('pro_description')),
                // 'initial_total' => $initial_total,
                'discount' 			=> implode("<br>", $discount),
                // 'after_discount_po' => $after_discount,
                // 'type' => $type,
                'subscr_type'=>$subscrtype,
                // 'igst12' => str_replace(',', '', $this->input->post('igst12')),
                // 'igst18' => str_replace(',', '', $this->input->post('igst18')),
                // 'igst28' => str_replace(',', '', $this->input->post('igst28')),
                // 'cgst6' => str_replace(',', '', $this->input->post('cgst6')),
                // 'sgst6' => str_replace(',', '', $this->input->post('sgst6')),
                // 'cgst9' => str_replace(',', '', $this->input->post('cgst9')),
                // 'sgst9' => str_replace(',', '', $this->input->post('sgst9')),
                // 'cgst14' => str_replace(',', '', $this->input->post('cgst14')),
                // 'sgst14' => str_replace(',', '', $this->input->post('sgst14')),
                // 'sub_total' => $sub_total,
                // 'total_percent' => $this->input->post('total_percent'),
                // 'approve_status' => $sttsAuto,
                // 'approved_by' => $approved_by,
                //'progress' 			=> $this->input->post('progress'),
                //'progress_remain' 	=> $progress_remain,
                // 'terms_condition' => $terms_condition,
                // 'customer_company_name' => $this->input->post('company_name'),
                // 'customer_name' => $this->input->post('customer_name'),
                // 'customer_email' => $this->input->post('customer_email'),
                // 'customer_mobile' => $this->input->post('customer_mobile'),
                // 'microsoft_lan_no' => $this->input->post('microsoft_lan_no'),
                // 'promo_id' => $this->input->post('promo_id'),
                // 'customer_address' => $this->input->post('customer_address'),
                'created_at' => $currentdate,
               
                'estimated_po_price' => implode("<br>", $estimate_purchase_price),
                'delete_status'=>1,
                // 'initial_estimate_purchase_price_po' => implode("<br>", $initial_est_purchase_price),
                // //'total_estimate_purchase_price_po' 	=> $total_est_purchase_price,
                // 'profit_by_user_po' => $profit_by_user,
                // 'so_owner' => $this->input->post('owner'),
                // 'so_owner_email' => $sess_eml,
                // 'opportunity_id' => $this->input->post('opportunity_id'),
                // 'org_name' => $org_name,
                // 'is_renewal' => $this->input->post('is_newed'),
                // 'renewal_date' => $renewaldate,
                // 'igst' => $igst,
                // 'cgst' => $cgst,
                // 'sgst' => $sgst,
                // 'sub_total_with_gst' => implode("<br>", $this->input->post('sub_total_with_gst')),
                // 'extra_charge_label' => $extra_charge,
                // 'extra_charge_value' => $extra_chargevalue,
                // 'pro_discount' => implode("<br>", $this->input->post('discount_price')),
                // 'total_igst' => str_replace(",", "", $this->input->post('total_igst')),
                // 'total_cgst' => str_replace(",", "", $this->input->post('total_cgst')),
                // 'total_sgst' => str_replace(",", "", $this->input->post('total_sgst')),
            ];
        
           
            $id = $this->Purchaseorders->create_subpo($data);
            $val = $this->input->post('val');
            $val2 = $this->input->post('val2');

            

            if (!empty($id)) {
                $initial_total = str_replace(",", "", $this->input->post('initial_total'));
                $unit_price_prt = str_replace(",", "", $this->input->post('unit_price'));
                $total_prt = str_replace(",", "", $this->input->post('total'));
                $after_discount = str_replace(",", "", $this->input->post('after_discount'));
                $sub_total = str_replace(",", "", $this->input->post('sub_total'));
                $quantity_p = str_replace(",", "", $this->input->post('quantity'));
                $estimate_purchase_price_prt = str_replace(",", "", $this->input->post('estimate_purchase_price'));
                $initial_est_purchase_price_prt = str_replace(",", "", $this->input->post('initial_est_purchase_price'));
                $total_est_purchase_price = str_replace(",", "", $this->input->post('total_est_purchase_price'));
                $profit_by_user = str_replace(",", "", $this->input->post('profit_by_user'));
                $x = "100";
                $purchaseorder_id = updateid($id, 'purchaseorder', 'purchaseorder_id');
                $proName = $this->input->post('product_name');
                $totalSoProduct = $this->input->post('total_so_product');
                $po_product_total = count($proArr) + count($proName);
                if ($po_product_total >= $totalSoProduct) {
                    $this->Salesorders->total_percent(0, $saleorder_id);
                } else {
                    $this->Salesorders->total_percent(50, $saleorder_id);
                }
                $productLine = $this->input->post('productLine');
                $cntProduct = count($proName);
                $totalLine = intval($productLine) - intval($cntProduct);
                $this->Purchaseorders->purchaseorder_id($purchaseorder_id, $id);
                $this->load->model('Notification_model');
                $this->Notification_model->addNotification('purchaseorders', $id);

                $productQty = count($proName);

                $calc = '';
                for ($pr = 0; $pr < $productQty; $pr++) {
                    $soDetails = $this->Purchaseorders->soProfitDetails($saleorder_id, $proName[$pr]);
                    if (!empty($soDetails)) {
                        foreach ($soDetails as $postSo) {
                            $calc = intval($postSo['so_pro_total']) - intval($total_prt[$pr]);
                            $proId = $postSo['id'];
                        }
                        $dtatArr = [
                            'po_id' => $purchaseorder_id,
                            'po_qty' => $quantity_p[$pr],
                            'po_q_price' => $unit_price_prt[$pr],
                            'po_est_price' => $estimate_purchase_price_prt[$pr],
                            'po_total_est_price' => $initial_est_purchase_price_prt[$pr],
                            'po_total_price' => $total_prt[$pr],
                            'po_after_discount' => $after_discount,
                            'sales_person_margin' => $profit_by_user,
                            'actual_profit' => $calc,
                        ];
                        // $this->Purchaseorders->UpdateProductProfit($dtatArr, $proId, $saleorder_id);
                    }
                }

                // $data = $this->Purchaseorders->get_by_id2($id);
                /* .....  setup mail to so owner.........*/

                if (!empty($data)) {
                    foreach ($data as $row) {
          
                    }
                }

                /**** end code mail*******/

                // if ($progress_remain <= 1) {
                //     $status = "Approved";
                //     $this->Salesorders->status($status, $saleorder_id);
                // } else {
                //     $status = "Pending";
                //     $this->Salesorders->status($status, $saleorder_id);
                // }

                // $po_data = ['track_status' => 'purchaseorder'];
                // $this->Lead->update_lead_track_status(['opportunity_id' => $this->input->post('opportunity_id')], $po_data);
                // $this->Opportunity->update_opp_track_status(['opportunity_id' => $this->input->post('opportunity_id')], $po_data);
                echo json_encode(["status" => true, 'id' => $id]);
            } else {
                echo json_encode(["st" => false]);
            }
        }
    }
    /**
    * Update a purchase order (subpo) using POSTed form data and current session, persist changes via Purchaseorders->updatesubpo and echo a JSON status.
    * @example
    * // Simulate POST and session data, then call the controller method (example values)
    * $_POST['id'] = 'PO123';
    * $_POST['saleorder_id'] = 'SO456';
    * $_POST['product_name'] = ['Widget A','Widget B'];
    * $_POST['unit_price'] = ['1,000','2,500'];
    * $_POST['discount_price'] = ['0','50'];
    * $_POST['sub_total'] = '3,450';
    * $_POST['subscr_type'] = 'monthly';
    * $_POST['owner'] = 'John Doe';
    * $this->session->set_userdata(['email' => 'user@example.com', 'company_name' => 'Acme Ltd', 'company_email' => 'info@acme.example']);
    * $this->subpo_update(); // echoes {"status":"true"}
    * @param {{string}} {{id}} - Purchase order record identifier (POST 'id').
    * @param {{string}} {{saleorder_id}} - Associated sale order id (POST 'saleorder_id').
    * @param {{string|int}} {{progress_remain}} - Remaining progress value (POST 'progress_remain').
    * @param {{string}} {{sub_total}} - Sub total amount (POST 'sub_total', formatted string, commas allowed).
    * @param {{string}} {{discount_price}} - Discount values per product (POST 'discount_price', may be array or comma-separated).
    * @param {{string}} {{so_owner}} - Sale order owner name (POST 'so_owner').
    * @param {{string}} {{so_owner_email}} - Sale order owner email (POST 'so_owner_email').
    * @param {{string}} {{org_name}} - Organization name (POST 'org_name').
    * @param {{string}} {{subscr_type}} - Subscription type (POST 'subscr_type', e.g. "monthly").
    * @param {{array|string}} {{product_name}} - Product names array (POST 'product_name') which will be imploded with "<br>".
    * @param {{array|string}} {{product_Id}} - Product IDs (POST 'product_Id', optional, imploded with "<br>").
    * @param {{array|string}} {{unit_price}} - Unit prices for products (POST 'unit_price', commas allowed, imploded).
    * @param {{string}} {{initial_total}} - Initial total (POST 'initial_total', formatted string).
    * @param {{string}} {{total}} - Line totals (POST 'total', formatted string).
    * @param {{string}} {{estimate_purchase_price}} - Estimated purchase price values (POST 'estimate_purchase_price', formatted).
    * @param {{string}} {{initial_est_purchase_price}} - Initial estimated purchase price (POST 'initial_est_purchase_price').
    * @param {{string}} {{total_est_purchase_price}} - Total estimated purchase price (POST 'total_est_purchase_price').
    * @param {{string}} {{profit_by_user}} - Profit entered by user (POST 'profit_by_user').
    * @param {{string}} {{type}} - Generic type field (POST 'type').
    * @param {{string}} {{renewal_date}} - Renewal date (POST 'renewal_date').
    * @param {{string}} {{renewal_date_cal}} - Renewal date from calendar (POST 'renewal_date_cal', overrides 'renewal_date' when present).
    * @param {{array|string}} {{igst}} - IGST tax values (POST 'igst', optional array imploded with "<br>").
    * @param {{array|string}} {{cgst}} - CGST tax values (POST 'cgst', optional array imploded with "<br>").
    * @param {{array|string}} {{sgst}} - SGST tax values (POST 'sgst', optional array imploded with "<br>").
    * @param {{int}} {{is_newed}} - Renewal indicator flag (POST 'is_newed', 0 or 1).
    * @param {{array|string}} {{extra_charge}} - Extra charge labels (POST 'extra_charge', optional array imploded with "<br>").
    * @param {{array|string}} {{extra_chargevalue}} - Extra charge values (POST 'extra_chargevalue', optional array imploded with "<br>").
    * @param {{string}} {{owner}} - Owner field used when updating (POST 'owner').
    * @param {{string}} {{session_email}} - Session user email (session 'email').
    * @param {{string}} {{session_company}} - Session company name (session 'company_name').
    * @param {{string}} {{session_comp_email}} - Session company email (session 'company_email').
    * @returns {{void}} Echoes a JSON encoded status string (e.g. {"status":"true"}) on success or validation code on failure.
    */
    public function subpo_update(){
        $validation = $this->check_validation();
        if ($validation != 200) {
            echo $validation;
            die();
        } else {
            
            $saleorder_id = $this->input->post('saleorder_id');
            $progress_remain = $this->input->post('progress_remain');
            $sess_eml = $this->session->userdata('email');
            $session_company = $this->session->userdata('company_name');
            $session_comp_email = $this->session->userdata('company_email');
            $sub_total = $this->input->post('sub_total');
            $discount = $this->input->post('discount_price');
            $so_owner = $this->input->post('so_owner');
            $so_owner_email = $this->input->post('so_owner_email');
            $org_name = $this->input->post('org_name');
            $currentdate = date("Y-m-d");
            $subscrtype= $this->input->post('subscr_type');
             

            $proArr = [];
            $prddata = $this->Purchaseorders->check_product($saleorder_id);
            
            for ($i = 0; $i < count($prddata); $i++) {
                $proArr2 = explode("<br>", $prddata[$i]['product_name']);
                for ($k = 0; $k < count($proArr2); $k++) {
                    if (isset($proArr2[$k]) && $proArr2[$k] != "") {
                        $proArr[] = $proArr2[$k];
                    }
                }
            }

            $initial_total = str_replace(",", "", $this->input->post('initial_total'));
            $unit_price = str_replace(",", "", $this->input->post('unit_price'));
            $total = str_replace(",", "", $this->input->post('total'));
            $discount = str_replace(",", "", $this->input->post('discount_price'));
            $sub_total = str_replace(",", "", $this->input->post('sub_total'));
            $estimate_purchase_price = str_replace(",", "", $this->input->post('estimate_purchase_price'));
            $initial_est_purchase_price = str_replace(",", "", $this->input->post('initial_est_purchase_price'));
            $total_est_purchase_price = str_replace(",", "", $this->input->post('total_est_purchase_price'));
            $profit_by_user = str_replace(",", "", $this->input->post('profit_by_user'));

            $type = $this->input->post('type');
            $renewal_date = $this->input->post('renewal_date');
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

            if ($this->input->post('product_Id') != "") {
                $proId = implode("<br>", $this->input->post('product_Id'));
            } else {
                $proId = '';
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

            if (check_permission_status('No need to approve purchase order', 'other') == true) {
                $sttsAuto = 1;
                $approved_by = 'Auto';
            } else {
                $sttsAuto = 0;
                $approved_by = '';
            }

            /*$checkPer = check_workflows('Purchase order','Auto approve by limit PO');
		if(isset($checkPer['trigger_workflow_on']) && $checkPer['trigger_workflow_on']==1 && $sub_total<=$checkPer['price_limit']){
		    $sttsAuto=1;
			$approved_by='Auto, less than limit';
		    
		}*/

            $data = [
                'sess_eml' => $sess_eml,
                'session_company' => $session_company,
                'session_comp_email' => $session_comp_email,
                'owner' => $this->input->post('owner'),
                // 'saleorder_id' => $saleorder_id,
                // 'subject' => $this->input->post('subject'),
                // 'contact_name' => $this->input->post('contact_name'),
                // 'billing_gstin' => $this->input->post('billing_gstin'),
                // 'shipping_gstin' => $this->input->post('shipping_gstin'),
                // 'billing_country' => $this->input->post('billing_country'),
                // 'billing_state' => $this->input->post('billing_state'),
                // 'shipping_country' => $this->input->post('shipping_country'),
                // 'shipping_state' => $this->input->post('shipping_state'),
                // 'billing_city' => $this->input->post('billing_city'),
                // 'billing_zipcode' => $this->input->post('billing_zipcode'),
                // 'shipping_city' => $this->input->post('shipping_city'),
                // 'shipping_zipcode' => $this->input->post('shipping_zipcode'),
                // 'billing_address' => $this->input->post('billing_address'),
                // 'shipping_address' => $this->input->post('shipping_address'),
                // 'supplier_name' => $this->input->post('supplier_name'),
                // 'supplier_contact' => $this->input->post('supplier_contact'),
                // 'supplier_gstin' => $this->input->post('supplier_gstin'),
                // 'supplier_comp_name' => $this->input->post('supplier_comp_name'),
                // 'supplier_email' => $this->input->post('supplier_email'),
                // 'supplier_country' => $this->input->post('supplier_country'),
                // 'supplier_state' => $this->input->post('supplier_state'),
                // 'supplier_city' => $this->input->post('supplier_city'),
                // 'supplier_zipcode' => $this->input->post('supplier_zipcode'),
                // 'supplier_address' => $this->input->post('supplier_address'),
                // 'pro_dummy_id' => $proId,
                'product_name' => implode("<br>", $this->input->post('product_name')),
                // 'hsn_sac' => implode("<br>", $this->input->post('hsn_sac')),
                // 'sku' => implode("<br>", $this->input->post('sku')),
                // 'gst' => implode("<br>", $this->input->post('gst')),
                // 'quantity' => implode("<br>", $this->input->post('quantity')),
                'unit_price' => implode("<br>", $unit_price),
                // 'total' => implode("<br>", $total),
                //'percent' 			=> implode("<br>",$this->input->post('percent')),
                // 'pro_description' => implode("<br>", $this->input->post('pro_description')),
                // 'initial_total' => $initial_total,
                'discount' 			=> implode("<br>", $discount),
                // 'after_discount_po' => $after_discount,
                // 'type' => $type,
                'subscr_type'=>$subscrtype,
                // 'igst12' => str_replace(',', '', $this->input->post('igst12')),
                // 'igst18' => str_replace(',', '', $this->input->post('igst18')),
                // 'igst28' => str_replace(',', '', $this->input->post('igst28')),
                // 'cgst6' => str_replace(',', '', $this->input->post('cgst6')),
                // 'sgst6' => str_replace(',', '', $this->input->post('sgst6')),
                // 'cgst9' => str_replace(',', '', $this->input->post('cgst9')),
                // 'sgst9' => str_replace(',', '', $this->input->post('sgst9')),
                // 'cgst14' => str_replace(',', '', $this->input->post('cgst14')),
                // 'sgst14' => str_replace(',', '', $this->input->post('sgst14')),
                // 'sub_total' => $sub_total,
                // 'total_percent' => $this->input->post('total_percent'),
                // 'approve_status' => $sttsAuto,
                // 'approved_by' => $approved_by,
                //'progress' 			=> $this->input->post('progress'),
                //'progress_remain' 	=> $progress_remain,
                // 'terms_condition' => $terms_condition,
                // 'customer_company_name' => $this->input->post('company_name'),
                // 'customer_name' => $this->input->post('customer_name'),
                // 'customer_email' => $this->input->post('customer_email'),
                // 'customer_mobile' => $this->input->post('customer_mobile'),
                // 'microsoft_lan_no' => $this->input->post('microsoft_lan_no'),
                // 'promo_id' => $this->input->post('promo_id'),
                // 'customer_address' => $this->input->post('customer_address'),
                'created_at' => $currentdate,
                'estimated_po_price' => implode("<br>", $estimate_purchase_price),
                // 'initial_estimate_purchase_price_po' => implode("<br>", $initial_est_purchase_price),
                // //'total_estimate_purchase_price_po' 	=> $total_est_purchase_price,
                // 'profit_by_user_po' => $profit_by_user,
                // 'so_owner' => $this->input->post('owner'),
                // 'so_owner_email' => $sess_eml,
                // 'opportunity_id' => $this->input->post('opportunity_id'),
                // 'org_name' => $org_name,
                // 'is_renewal' => $this->input->post('is_newed'),
                // 'renewal_date' => $renewaldate,
                // 'igst' => $igst,
                // 'cgst' => $cgst,
                // 'sgst' => $sgst,
                // 'sub_total_with_gst' => implode("<br>", $this->input->post('sub_total_with_gst')),
                // 'extra_charge_label' => $extra_charge,
                // 'extra_charge_value' => $extra_chargevalue,
                // 'pro_discount' => implode("<br>", $this->input->post('discount_price')),
                // 'total_igst' => str_replace(",", "", $this->input->post('total_igst')),
                // 'total_cgst' => str_replace(",", "", $this->input->post('total_cgst')),
                // 'total_sgst' => str_replace(",", "", $this->input->post('total_sgst')),
            ];

            $result = $this->Purchaseorders->updatesubpo(['po_id' => $this->input->post('id'), 'session_company' => $this->session->userdata('company_name'), 'session_comp_email' => $this->session->userdata('company_email')], $data);
         
            /*$workflow_details = $this->Workflow_model->get_workflows_byModule('Purchaseorders','Purchaseorder approved by value');
         if(!empty($workflow_details) && count($workflow_details)>0){
             $povalue_workflowCH = $workflow_details['limit_so'];
         }else{
             $povalue_workflowCH=0;
         }*/
               echo json_encode(['status'=>'true']);
        }
    }
    /**
    * Validate purchase order form inputs and return validation errors or a success code.
    * @example
    * $result = $this->check_validation();
    * echo $result;
    * // Possible output on validation failure (JSON string):
    * // {"st":202,"subject":"Subject is required","contact_name":"Contact Name is required","billing_country":"Billing Country is required","billing_state":"Billing State is required","shipping_country":"Shipping Country is required","shipping_state":"Shipping State is required","billing_city":"Billing City is required","billing_zipcode":"Billing Zipcode is required","shipping_city":"Shipping City is required","shipping_zipcode":"Shipping Zipcode is required","billing_address":"Billing Address is required","shipping_address":"Shipping Address is required","supplier_comp_name":"Supplier Company Name is required","supplier_contact":"Supplier Contact is required","supplier_email":"Supplier Email is required"}
    * // Possible output on success:
    * // 200
    * @returns {int|string} Integer 200 on success, or a JSON-encoded string containing validation error messages on failure.
    */
    public function check_validation()
    {
        $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
        //$this->form_validation->set_rules('saleorder_id', 'Salesorder Id', 'required|trim');
        $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
        $this->form_validation->set_rules('contact_name', 'Contact Name', 'required|trim');
        $this->form_validation->set_rules('billing_country', 'Billing Country', 'required|trim');
        $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
        $this->form_validation->set_rules('shipping_country', 'Shipping Country', 'required|trim');
        $this->form_validation->set_rules('shipping_state', 'Shipping State', 'required|trim');
        $this->form_validation->set_rules('billing_city', 'Billing City', 'required|trim');
        $this->form_validation->set_rules('billing_zipcode', 'Billing Zipcode', 'required|trim');
        $this->form_validation->set_rules('shipping_zipcode', 'Shipping Zipcode', 'required|trim');
        $this->form_validation->set_rules('shipping_city', 'Shipping City', 'required|trim');
        $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
        $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'required|trim');
        $this->form_validation->set_rules('supplier_comp_name', 'Supplier Company Name', 'required|trim');
        $this->form_validation->set_rules('supplier_contact', 'Supplier Contact', 'required|trim');
        $this->form_validation->set_rules('supplier_email', 'Supplier Email', 'required|trim');
        $this->form_validation->set_message('required', '%s is required');
        if ($this->form_validation->run() == false) {
            return json_encode([
                'st' => 202,
                'subject' => form_error('subject'),
                'contact_name' => form_error('contact_name'),
                'billing_country' => form_error('billing_country'),
                'billing_state' => form_error('billing_state'),
                'shipping_country' => form_error('shipping_country'),
                'shipping_state' => form_error('shipping_state'),
                'billing_city' => form_error('billing_city'),
                'billing_zipcode' => form_error('billing_zipcode'),
                'shipping_city' => form_error('shipping_city'),
                'shipping_zipcode' => form_error('shipping_zipcode'),
                'billing_address' => form_error('billing_address'),
                'shipping_address' => form_error('shipping_address'),
                'supplier_comp_name' => form_error('supplier_comp_name'),
                'supplier_contact' => form_error('supplier_contact'),
                'supplier_email' => form_error('supplier_email'),
            ]);
        } else {
            return 200;
        }
    }
    public function delete($id)
    {
        $this->Purchaseorders->delete($id);
        $soid = $this->input->post('soid');
        $this->Salesorders->total_percent(100, $soid);
        echo json_encode(["status" => true]);
    }
    public function delete_bulk()
    {
        if ($this->input->post('checkbox_value')) {
            $id = $this->input->post('checkbox_value');
            for ($count = 0; $count < count($id); $count++) {
                $this->Purchaseorders->delete_bulk($id[$count]);
            }
        }
    }
    public function getbranchVal()
    {
        $postData = $this->input->post();
        $data = $this->Login->getbranchVals($postData);
        echo json_encode($data);
    }
    /**
     * Generate and stream (or force download) a PDF of a purchase order determined by URI segments; redirects if no ID is provided.
     * @example
     * // To view the purchase order PDF in the browser for ID 123:
     * // Access URL: /purchaseorders/view/123
     * $this->view(); // Streams "PURCHASE_123.pdf" inline
     *
     * // To force download the purchase order PDF for ID 123:
     * // Access URL: /purchaseorders/view/123/dn
     * $this->view(); // Streams "PURCHASE_123.pdf" as a download
     * @param void $none - No direct arguments; function reads URI segments: segment(3) => purchase order ID, segment(4) => optional 'dn' flag to force download.
     * @returns void Streams a PDF to the client or redirects to the purchaseorders listing if no ID is present.
     */
    public function view()
    {
        //if(!empty($this->session->userdata('email')))
        // {
        if ($this->uri->segment(3)) {
            $download = $this->uri->segment(4);
            $id = $this->uri->segment(3);
            $html_content = '';
            $html_content .= $this->Purchaseorders->view($id);
            // print_r($html_content);die;
            $this->dompdf->loadHtml($html_content);
            ini_set('memory_limit', '128M');
            $this->dompdf->render();
            $this->dompdf->setPaper('A4', 'landscape');

            $canvas = $this->dompdf->getCanvas();
            $pdf = $canvas->get_cpdf();

            foreach ($pdf->objects as &$o) {
                if ($o['t'] === 'contents') {
                    $o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
                }
            }

            if (isset($download) && $download == 'dn') {
                $this->dompdf->stream("PURCHASE_" . $id . ".pdf", ["Attachment" => 1]);
            } else {
                $this->dompdf->stream("PURCHASE_" . $id . ".pdf", ["Attachment" => 0]);
            }
            //$this->dompdf->stream("PURCHASE".$id.".pdf", array("Attachment"=>0));
        } else {
            redirect('purchaseorders');
        }
        /* }
    else
    {
      redirect('login');
    }*/
    }
    public function end_renewal()
    {
        $id = $this->input->post('id');
        $this->Purchaseorders->update_end_renewal($id);
        echo json_encode(true);
    }
    public function update_renewal_data()
    {
        $data = $this->Purchaseorders->get_renewal_po();
        echo json_encode($data);
    }
    public function get_po_renewal()
    {
        $data = $this->Purchaseorders->get_renewal_po();
        echo json_encode($data);
    }

    /**
    * Display the purchase order view for the given ID if the user is authenticated; otherwise redirect to login.
    * @example
    * $this->purchaseorders->view_pi_po(123);
    * // Loads the 'inventory/view-purchase-order' view for purchase order ID 123 (or redirects to 'login' if not authenticated).
    * @param {int} $id - Purchase order database ID to view.
    * @returns {void} Loads a view or redirects; does not return a value.
    */
    public function view_pi_po($id)
    {
        if (!empty($this->session->userdata('email'))) {
            $session_company = $this->session->userdata('company_name');
            $session_comp_email = $this->session->userdata('company_email');
            $this->db->where('id', $id);
            $this->db->where('session_company', $session_company);
            $this->db->where('session_comp_email', $session_comp_email);
            $data['record'] = $this->db->get('purchaseorder')->row_array();
            $this->load->view('inventory/view-purchase-order', $data);
            if ($this->session->userdata('type') == 'admin') {
                $this->load->model('Notification_model');
                $qid = $id;
                $notifor = 'purchaseorders';
                $podata = $this->Notification_model->update_noti('so_id', $qid, $notifor);
            }
        } else {
            redirect('login');
        }
    }

    /**
    * Generate a PDF for a purchase order, save it to assets/img and return the saved file path.
    * @example
    * $result = $this->Purchaseorders->generate_pdf_attachment(123);
    * echo $result; // outputs: assets/img/PURCHASE_123.pdf
    * @param int $po_id - Purchase order ID.
    * @returns string Path to the generated PDF file (relative), e.g. 'assets/img/PURCHASE_123.pdf'.
    */
    public function generate_pdf_attachment($po_id)
    {
        $this->load->library('pdf');

        //$download='';
        $html_content = '';
        $html_content .= $this->Purchaseorders->view($po_id);
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
        $path = "assets/img/PURCHASE_" . $po_id . ".pdf";
        file_put_contents($path, $attachmentpdf);
        return $path;
    }

    /**
    * Send a purchase order invoice email to a recipient using POSTed form data, optionally attaching a generated PDF.
    * @example
    * // Sample POST values before calling the controller method
    * $_POST = [
    *   'orgName' => 'Acme Corp',
    *   'orgEmail' => 'billing@acme.example.com',
    *   'ccEmail' => 'accounting@acme.example.com',
    *   'subEmail' => 'Purchase Order Invoice #1234',
    *   'descriptionTxt' => '<p>Thank you for your business.</p>',
    *   'invoiceurl' => 'https://example.com/invoices/1234',
    *   'po_id' => 1234
    * ];
    * $controller = new Purchaseorders();
    * $controller->send_email(); // echoes "1" on success or "0" on failure and exits
    * @param {string} orgName - Recipient organization or contact name (POST field 'orgName').
    * @param {string} orgEmail - Recipient email address to which the invoice will be sent (POST field 'orgEmail').
    * @param {string} ccEmail - CC email address(es) for the message (POST field 'ccEmail').
    * @param {string} subEmail - Email subject text (POST field 'subEmail').
    * @param {string} descriptionTxt - HTML description or message body fragment inserted into the email (POST field 'descriptionTxt').
    * @param {string} invoiceurl - Public URL to view the purchase order invoice (POST field 'invoiceurl').
    * @param {int} po_id - Purchase order identifier used to generate the PDF attachment (POST field 'po_id').
    * @returns {void} Echoes "1" if email sent successfully, otherwise echoes "0". The method unlinks the temporary PDF and calls exit().
    */
    public function send_email()
    {
        $orgName = $this->input->post('orgName');
        $orgEmail = $this->input->post('orgEmail');
        $ccEmail = $this->input->post('ccEmail');
        $subEmail = $this->input->post('subEmail');
        $descriptionTxt = $this->input->post('descriptionTxt');
        $invoiceurl = $this->input->post('invoiceurl');
        $po_id = $this->input->post('po_id');
        //attachment
        $attach_pdf = $this->generate_pdf_attachment($po_id);

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
            '" class="f-fallback button" target="_blank">View Purchaseorder Invoice</a>
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

    //Please write code above this
    // start devendra coding

    // retrive supplier name list on change event of supplier company name
    /**
    * Retrieve supplier names matching a posted supplier company name and echo HTML <option> elements.
    * @example
    * $_POST['supplier_comp_name'] = 'Acme Corporation';
    * $this->getSupplierName();
    * // Example output:
    * // '<option value="Acme Corporation">Acme Corporation</option>'
    * @param string $supplier_comp_name - Supplier company name passed via POST input (required).
    * @returns string Echoes an HTML string of <option> elements for matching supplier names, or the text "validation error" / "Post error" on failure.
    */
    public function getSupplierName()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('supplier_comp_name', 'supplier company name', 'required');
            if ($this->form_validation->run() == false) {
                echo "validation error";
            } else {
                $supplier_comp_name = $this->input->post('supplier_comp_name');
                $SupplierNameList = $this->Purchaseorders->dbGetSupplierName($supplier_comp_name)->result_array();
                // echo $this->db->last_query();
                // exit;
                $output = '';
                // '<option value="">Supplier Contact Number</option><option selected value="' .
                // $this->Purchaseorders->dbGetSupplierName($supplier_comp_name)->row()->id .
                // '">' .
                // $this->Purchaseorders->dbGetSupplierName($supplier_comp_name)->row()->primary_contact .
                // '</option>';
                // foreach ($SupplierNameList as $row) {
                //     $output .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                // }
                
                 foreach ($SupplierNameList as $row) {
                    $output .= '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                }
                echo $output;
            }
        } else {
            echo "Post error";
        }
    }
    // retrive supplier details list on change event of supplier supplier name
    /**
    * Fetch supplier details based on a POSTed supplier_name and echoes a JSON-encoded response.
    * @example
    * // Example using curl (POST supplier_name):
    * // curl -X POST -d "supplier_name=Acme%20Corp" https://example.com/purchaseorders/getSupplierDetails
    * // Sample JSON response:
    * // [{"id":123,"name":"Acme Corp","address":"123 Main St","phone":"(555) 123-4567"}]
    * @param string $supplier_name - Supplier company name or identifier sent via POST.
    * @returns string Echoes JSON-encoded supplier details on success; echoes plain text error messages on validation or request errors.
    */
    public function getSupplierDetails()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('supplier_name', 'supplier company name', 'required');
            if ($this->form_validation->run() == false) {
                echo "validation error";
            } else {
                // echo "here";
                // exit;
                $supplier_name = $this->input->post('supplier_name');
                $getSupplierDetails = $this->Purchaseorders->dbGetSupplierDetails($supplier_name);
                // echo $this->db->last_query();
                // exit;
                header('Content-Type: application/x-json; charset=utf-8');
                echo json_encode($getSupplierDetails);
                // $CheckPrimaryContact = $this->db->where(['id' => $supplier_name])->get('organization');
                // if ($CheckPrimaryContact->num_rows() > 0) {
                //     $getSupplierDetails = $this->Purchaseorders->dbGetSupplierPrimartyDetails($supplier_name);
                //     // echo $this->db->last_query();
                //     header('Content-Type: application/x-json; charset=utf-8');
                //     echo json_encode($getSupplierDetails);
                // } else {
                //     $getSupplierDetails = $this->Purchaseorders->dbGetSupplierDetails($contact_name_id);
                //     // echo $this->db->last_query();
                //     // exit;
                //     header('Content-Type: application/x-json; charset=utf-8');
                //     echo json_encode($getSupplierDetails);
                // }
            }
        } else {
            echo "Post error";
        }
    }
    /**
    * Sends a purchase order PDF as an email to a recipient using POSTed form data.
    * @example
    * $_POST['to'] = 'recipient@example.com';
    * $_POST['cc'] = 'manager@example.com';
    * $_POST['subject'] = 'Purchase Order #12345';
    * $_POST['po_id'] = '12345';
    * $this->sharepobymail();
    * echo 'Email sent'; // Example output: Email sent
    * @param {string} to - Recipient email address (provided via POST 'to').
    * @param {string} cc - CC email address(es), comma separated (provided via POST 'cc').
    * @param {string} subject - Email subject line (provided via POST 'subject').
    * @param {int|string} po_id - Purchase Order ID used to generate PDF attachment (provided via POST 'po_id').
    * @returns {void} Sends an email with the generated PDF attachment; does not return a value.
    */
    public function sharepobymail(){
        $to=$this->input->post('to');
        $cc=$this->input->post('cc');
        $subject=$this->input->post('subject');
        $po_id=$this->input->post('po_id');
        $attach_pdf = $this->generate_pdf_attachment($po_id);

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
            ucwords($to) .
            '!</h1>';

        $messageBody .= 'Please find the attachment below.';
       

        $messageBody .=
            '<!-- Action -->
                                <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                  <tr>
                                    <td align="center">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                        <tr>
                                          <td align="center">
                                            <a href="
           
            " class="f-fallback button" target="_blank">View Purchaseorder Invoice</a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>';
       
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

        $this->email_lib->send_email($to, $subject, $messageBody,$cc,$attach_pdf);
          
        }



        
    //<-----------------------  Mass Update --------------------------------->

    /**
    * Add or update a mass field for a purchase order via AJAX; reads POST fields (mass_id, mass_name, mass_value) and saves with current date.
    * @example
    * // Example jQuery AJAX call:
    * $.post('/purchaseorders/add_mass', { mass_id: '123', mass_name: 'weight', mass_value: '45kg' }, function(response){ console.log(response); });
    * // Sample successful JSON response:
    * // {"success":true,"message":"Mass Update Successfully"}
    * // Sample failure JSON response:
    * // {"success":false,"message":"Mass Update Failed"}
    * @param string $mass_id - ID of the mass entry to update (provided via POST).
    * @param string $mass_name - Name/key of the mass field to set (provided via POST).
    * @param mixed $mass_value - Value to assign to the mass field (provided via POST).
    * @returns void Echoes a JSON-encoded success/failure response on AJAX requests; echoes plain text "Invalid request" for non-AJAX requests.
    */
    public function add_mass()
	{

      
	    if ($this->input->is_ajax_request()) {
        $mass_id = $this->input->post('mass_id');
        
        $mass_name = $this->input->post('mass_name');
        $mass_value = $this->input->post('mass_value');
        // print_r($mass_id);die;
                $dataArry = array(
                    $mass_name => $mass_value,
                    'datetime' => date('Y-m-d')
                    
                );

			$mass_data = $this->Purchaseorders->mass_save($mass_id, $dataArry);
            // print_r($mass_data);die;
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


}
?>
