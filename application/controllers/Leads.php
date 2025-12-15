<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Leads extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Lead_model', 'Lead');
        $this->load->model('Opportunity_model', 'Opportunity');
        $this->load->model('Login_model');
    }
    public function index()
    {
        if (!empty($this->session->userdata('email'))) {
            if (checkModuleForContr('Lead Generation') < 1) {
                redirect('home');
                exit();
            }

            if (check_permission_status('Leads', 'retrieve_u') == true) {
                $data['user'] = $this->Login_model->getusername();
                $data['admin'] = $this->Login_model->getadminname();
                $data['users_data'] = $this->Login_model->get_company_users();

                // $assignedto 	= $data['user'];
                // $idArr 	= array();
                // for($k=0; $k<count($assignedto); $k++){
                // $assignUser=$this->Lead->assignedUser($assignedto[$k]['standard_email']);
                // if(isset($assignUser) && count($assignUser)>0){
                // $idArr[]= $assignUser['id'];
                // }else{
                // echo $assignedto[$k]['standard_email']."<br>";
                // }
                // }
                // $idUSerAssi=min($idArr);

                // $assignUser=$this->Lead->assignedUser('',$idUSerAssi);
                // print_r($assignUser);

                // exit;

                $leadStatus = ['Pre-Qualified', 'Contacted', 'Junk Lead', 'Lost Lead', 'Not Contacted', 'Contact in Future', 'In Progress'];
                for ($i = 0; $i < count($leadStatus); $i++) {
                    $ind = str_replace(' ', '', $leadStatus[$i]);
                    $ind = str_replace('-', '', $ind);
                    $data2[$ind] = $this->Lead->getTotalPrice($leadStatus[$i]);
                }
                $data['price'] = $data2;
                $data['countLead'] = $this->Lead->count_all();
                $this->load->view('sales/leads', $data);
            } else {
                $this->load->view('permission');
            }
        } else {
            redirect('login');
        }
    }
    public function view_lead($id)
    {
        if (!empty($this->session->userdata('email'))) {
            if (checkModuleForContr('Create Salesorder') < 1) {
                redirect('home');
                exit();
            }
            $this->db->select('*');
            $this->db->where('id', $id);
            $this->db->from('lead');
            $data['record'] = $this->db->get()->row_array();
            $this->load->view('sales/view-lead', $data);

            if ($this->session->userdata('type') == 'admin') {
                $this->load->model('Notification_model');
                $qid = $id;
                $notifor = 'salesorders';
                $podata = $this->Notification_model->update_noti('so_id', $qid, $notifor);
            }
        } else {
            redirect('login');
        }
    }
    public function add_leads()
    {
        if (check_permission_status('Leads', 'update_u') == true || check_permission_status('Leads', 'create_u') == true) {
            $id = $this->uri->segment(2);
            
            $data['lead_status'] = $this->Lead->get_leatStatus();
             
            $data['user'] = $this->Login_model->getusername();
            $data['admin'] = $this->Login_model->getadminname();
            $data['record'] = $this->Lead->get_data_for_update($id);
            $data['countLead'] = $this->Lead->count_all();
            $this->load->view('sales/add-lead', $data);
        } else {
            $this->load->view('permission');
        }
    }
    public function view_leads()
    {
        if (check_permission_status('Leads', 'retrieve_u') == true) {
            $id = $this->uri->segment(2);
            $data['user'] = $this->Login_model->getusername();
            $data['admin'] = $this->Login_model->getadminname();
            $data['record'] = $this->Lead->get_data_for_update($id);
            $this->load->view('sales/view-lead', $data);
        } else {
            redirect(base_url() . 'home');
        }
    }
    public function returngrid($list, $leadStatus, $count, $dataCount)
    {
        $ind = str_replace(' ', '', $leadStatus);
        $ind = str_replace('-', '', $ind);
        ?>
      <div class="lists" data-status="<?= $leadStatus ?>" data-textid="<?= $ind ?>"  id="list<?= $count ?>">
			<?php if (isset($dataCount[$leadStatus])) {
       $r = 1;
       $delete_lead = 0;
       $update_lead = 0;
       $retrieve_lead = 0;
       $create_opp = 0;

       if (check_permission_status('Leads', 'delete_u') == true) {
           $delete_lead = 1;
       }
       if (check_permission_status('Opportunity', 'create_u') == true) {
           $create_opp = 1;
       }
       if (check_permission_status('Leads', 'retrieve_u') == true) {
           $retrieve_lead = 1;
       }
       if (check_permission_status('Leads', 'update_u') == true) {
           $update_lead = 1;
       }
       foreach ($list as $row) {
           if ($row['lead_status'] == $leadStatus) {
               $OppCount = $this->Opportunity->check_opp_exist($row['lead_id']); ?>
				<div id='item<?= $row['id'] ?>' data-id="<?= $row['id'] ?>" data-putid="<?= $ind ?>" data-price="<?= $row['initial_total'] ?>"  class="col-lg-12 mt-2 divli">
				<div class="leadname"><?= $row['name'] ?></div>
				<div style="font-size: 13px;">
				<i class="fas fa-university" style="margin-right: 5px;"></i>
				<?= $row['org_name'] ?></div>
				<div style="font-size: 12px;">
				<i class="fas fa-rupee-sign" style="margin-right: 5px;"></i>
				 <?= IND_money_format($row['initial_total']) ?>
				</div>
				<div style="font-size: 12px;">
				<i class="far fa-calendar-alt" style="margin-right: 5px;"></i>
				<?php
    $date = date_create($row['currentdate']);
    echo date_format($date, "d M Y");
    ?>
				</div>
				<div style="font-size: 12px;">
					<i class="far fa-user" style="margin-right: 4px;"></i>
					<?= $row['lead_owner'] ?>
				</div>
				 <label>
				 <?php if ($create_opp == 1 && $OppCount < 1):
         $firstRow = '<a style="text-decoration:none;" data-toggle="tooltip" title="Create Opportunity" href="' . base_url() . 'add-opportunity?ld=' . $row['id'] . '" class="text-info">+ Opp</a>';
         echo $firstRow;
     endif; ?>
					<span style="float: right;">
				<?php
    if ($update_lead == 1) { ?>	    
					<a style="text-decoration:none;" data-toggle="tooltip" title="Update Lead" href="<?= base_url() ?>add-lead/<?= $row[
    'id'
] ?>"> <i class="far fa-edit" data-toggle="tooltip" title="Update Lead" style="margin-right: 10px; cursor:pointer; color:#111;"></i> </a>
				<?php }
    if ($retrieve_lead == 1) { ?>	
					<i class="far fa-eye" data-toggle="tooltip" title="View Details" style="margin-right: 10px; cursor:pointer; color:#111;" onclick="view('<?= $row['id'] ?>')" ></i>
				<?php }
    if ($delete_lead == 1) { ?>	
					<i class="far fa-trash-alt" data-toggle="tooltip" title="Delete Lead" style="cursor:pointer; color:#111;" onclick="delete_entry('<?= $row['id'] ?>')" ></i>
				<?php }
    ?>	
					</span>
				 </label>
				</div>
				<?php $r++;
           }
       }
   } ?>
			
		</div>
      <?php
    }
    public function gridview()
    {
        $per_page = 10;
        $page = $this->input->post('page');
        $assigned = $this->input->post('assigned');
        $start = ($page - 1) * $per_page;
        $searchDate = $this->input->post('searchDate');
        $search = $this->input->post('search');
        $list = $this->Lead->get_all_lead($searchDate, $search, $per_page, $start, $assigned);
        $sort = [];
        foreach ($list as $k => $v) {
            $sort['lead_status'][$k] = $v['lead_status'];
        }
        if (count($sort)) {
            array_multisort($sort['lead_status'], SORT_ASC, $list);
        }
        $dataCount = array_count_values(array_column($list, 'lead_status'));
        $leadStatus = ['Pre-Qualified', 'Contacted', 'Junk Lead', 'Lost Lead', 'Not Contacted', 'Contact in Future', 'In Progress'];
        $m = 1;
        for ($i = 0; $i < count($leadStatus); $i++) {
            $this->returngrid($list, $leadStatus[$i], $m, $dataCount);
            $m++;
        }
        ?>
	<script>
	 $(function () {
        $("#list1, #list2, #list3, #list4, #list5, #list6, #list7").sortable({
            connectWith: ".lists",
            cursor: "move",
			delay:500,
			receive: function( event, ui ) { 
				var dropid=this.id; // Where the item is dropped
				var cameid=ui.sender[0].id; // Where it came from
				var itemid=ui.item[0].id; // Which item
				var dataid=$("#"+itemid).data('id');
				var status=$("#"+dropid).data('status');
				var textid=$("#"+dropid).data('textid');
				var price=$("#"+itemid).data('price');
				var staputid=$("#"+itemid).data('putid');
				//alert(status);
				
				var newPrice=$("#"+textid).val();
				price=parseFloat(price);
				newPrice=parseFloat(newPrice);
				finalPrice=(price+newPrice);
				$("#"+textid).val(finalPrice);
			    numberRoller('txt'+textid,finalPrice);
				 $.ajax({
					url : "<?= site_url('leads/update_status') ?>",
					type: "POST",
					data: "leadid="+dataid+"&status="+status,
					dataType: "JSON",
					success: function(data)
					{
						console.log(data);
					}
				 });
			
			}
        }).disableSelection();
    });
		</script>
<?php
    }
    public function pagination()
    {
        $this->load->library("pagination");
        $searchDate = $_GET['searchDate'];

        $assigned = $this->input->post('assigned');
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
        } else {
            $search = '';
        }

        $AllData = $this->Lead->get_all_count($searchDate, $search, $assigned);
        //echo $searchDate;

        //exit;
        $config = [];
        $config["base_url"] = "#";
        $config["total_rows"] = $AllData;
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = true;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li>';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li>';
        $config["last_tag_close"] = '</li>';
        $config['next_link'] = '&gt;';
        $config["next_tag_open"] = '<li>';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='activli'><a href='#'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["num_links"] = 1;
        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];

        $output = [
            'pagination_link' => $this->pagination->create_links(),
        ];
        echo json_encode($output);
    }
    public function update_status()
    {
        $leadid = $this->input->post('leadid');
        $status = $this->input->post('status');
        $dataArr = ['lead_status' => $status];
        $data = $this->Lead->update_status($dataArr, $leadid);
        echo json_encode($data);
    }


    public function ajax_list()
    {
        $list = $this->Lead->get_datatables();
        $data = [];
        $no = $_POST['start'];
        $delete_lead = 0;
        $update_lead = 0;
        $retrieve_lead = 0;
        $create_opp = 0;
        if (check_permission_status('Leads', 'delete_u') == true) {
            $delete_lead = 1;
        }
        if (check_permission_status('Opportunity', 'create_u') == true) {
            $create_opp = 1;
        }
        if (check_permission_status('Leads', 'retrieve_u') == true) {
            $retrieve_lead = 1;
        }
        if (check_permission_status('Leads', 'update_u') == true) {
            $update_lead = 1;
        }
        foreach ($list as $post) {
            $OppCount = $this->Opportunity->check_opp_exist($post->lead_id);
            $dataAct = $this->input->post('actDate');
            $no++;
            $row = [];
            // APPEND HTML FOR ACTION
            if ($delete_lead == 1) {
                if ($dataAct != 'actdata') {
                    // $row[] = '<input type="checkbox" class="delete_checkbox" onClick="checkCheckbox()" name="action_ck" value="' . $post->id . '">';
                    $row[] = '<input type="checkbox" class="delete_checkbox" onClick="checkCheckbox(); showAction(' . $post->id . ');" name="action_ck" value="' . $post->id . '">';
                    

                }
            }
            $companydetail = "
    <div class='d-flex align-items-center'>
        <img src='".base_url('')."/application/views/assets/images/faces/4.jpg' alt='img'
            class='rounded-circle mr-2' style='width: 1.75rem; height: 1.75rem;'>
        <div>
            <span>".ucfirst($post->org_name)."</span><br>
            
        </div>
    </div>";
            $first_row = "";
            $first_row .= ucfirst($post->name) . '<!--<div class="links">';
            if ($retrieve_lead == 1):
                $first_row .= '<a style="text-decoration:none" href="javascript:void(0)" onclick="view(' . "'" . $post->id . "'" . ')" class="text-success">View</a>';
            endif;
            if ($update_lead == 1):
                $first_row .= ' | <a style="text-decoration:none" href="' . base_url() . 'add-lead/' . $post->id . '"  class="text-primary">Update</a>';
            endif;
            if ($create_opp == 1 && $OppCount < 1):
                $first_row .= ' | <a style="text-decoration:none"  href="' . base_url() . 'add-opportunity?ld=' . $post->id . '"   class="text-info">Create Opportunity</a>';
            endif;
            if ($delete_lead == 1):
                $first_row .= ' | <a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry(' . "'" . $post->id . "'" . ')" class="text-danger">Delete</a>';
            endif;
            $first_row .= '</div>-->';
           
            $row[] = '<a style="text-decoration:none" onclick="view(' . "'" . $post->id . "'" . ')">' . $companydetail . '</a>';
            $row[] = $first_row;
            $row[] = ucfirst($post->lead_owner);
            $row[] = $post->email;
            $row[] = ucfirst($post->assigned_to_name);
            if ($post->lead_status == "") {
                $row[] = $post->lead_status;
            } elseif ($post->lead_status != "In Progress" && $post->lead_status != "Closed Won" && $post->lead_status != "Closed Lost" && $post->lead_status != 'Lost Lead' && $post->lead_status != 'Contacted') {
                $row[] = '<label class="text-primary" >' . $post->lead_status . '</label>';
            } elseif ($post->lead_status == "In Progress") {
                $row[] = '<label class="text-primary" >' . $post->lead_status . '</label>';
            } elseif ($post->lead_status == "Contacted") {
                $row[] = '<label class="text-info" >' . $post->lead_status . '</label>';
            } elseif ($post->lead_status == "Closed Won") {
                $row[] = '<label class="text-success" >' . $post->lead_status . '</label>';
            } elseif ($post->lead_status == "Closed Lost" || $post->lead_status == 'Lost Lead') {
                $row[] = '<label class="text-danger" >' . $post->lead_status . '</label>';
            }

            if ($dataAct != 'actdata') {
                $action = '<div class="row" style="font-size: 15px;">';
                if ($retrieve_lead == 1) {
                    $action .=
                        '<a style="text-decoration:none" href="javascript:void(0)" onclick="view(' .
                        "'" .
                        $post->id .
                        "'" .
                        ')" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Lead Details" ></i></a>';
                }
                if ($update_lead == 1) {
                    $action .=
                        '<a style="text-decoration:none" href="' .
                        base_url() .
                        'add-lead/' .
                        $post->id .
                        '" class="text-primary border-right">
					<i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Lead Details" ></i></a>';
                }
                if ( ($create_opp == 1) && ($OppCount < 1) && ($post->assigned!=1) ) {
                    $action .=
                        '<a style="text-decoration:none" href="' .
                        base_url() .
                        'add-opportunity?ld=' .
                        $post->id .
                        '"  class="text-info border-right">
					<i class="fas fa-briefcase sub-icn-po m-1" data-toggle="tooltip" data-container="body" title="Create Opportunity" ></i></a>';
                }
                if ($delete_lead == 1) {
                    $action .=
                        '<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry(' .
                        "'" .
                        $post->id .
                        "'" .
                        ')"  class="text-danger">
					<i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Lead" ></i></a>';
                }
                $action .= '</div>';

                $row[] = $action;
            }

            // $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
            $data[] = $row;
        }
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Lead->count_all(),
            "recordsFiltered" => $this->Lead->count_filtered(),
            "data" => $data,
        ];
        //output to json format
        echo json_encode($output);
    }
    public function assignlead_user()
    {
        $allId = $this->input->post('selected');
        $userforlead = $this->input->post('userforlead');
        $username = $this->input->post('username');

        $data = [
            'assigned_status' => 1,
            'assigned_to' => $userforlead,
            'assigned_to_name' => $username,
        ];

        if ($allId) {
            $explVal = explode(',', $allId);
            for ($i = 0; $i < count($explVal); $i++) {
                if ($explVal[$i] != "") {
                    $st = $this->Lead->update(['id' => $explVal[$i], 'session_company' => $this->session->userdata('company_name'), 'session_comp_email' => $this->session->userdata('company_email')], $data);
                }
            }
            echo $st;
        }
    }
    public function create()
    {
        $validation = $this->check_validation();
        if ($validation != 200) {
            echo $validation;
            die();
        } else {
            if ($this->input->post('assigned_to') != $this->session->userdata('email')) {
                $assigned_status = '1';
            } else {
                $assigned_status = '0';
            }

            $initial_total = str_replace(",", "", $this->input->post('initial_total'));
            $unit_price = str_replace(",", "", $this->input->post('unit_price'));
            $total = str_replace(",", "", $this->input->post('total'));
            $sub_total = str_replace(",", "", $this->input->post('sub_total'));
            $discount = str_replace(",", "", $this->input->post('discount'));

            $data = [
                'sess_eml' => $this->session->userdata('email'),
                'session_company' => $this->session->userdata('company_name'),
                'session_comp_email' => $this->session->userdata('company_email'),
                'name' => $this->input->post('name'),
                'org_name' => $this->input->post('org_name'),
                'lead_owner' => $this->input->post('lead_owner'),
                'email' => $this->input->post('email'),
                'office_phone' => $this->input->post('office_phone'),
                'mobile' => $this->input->post('mobile'),
                'lead_source' => $this->input->post('lead_source'),
                'lead_status' => $this->input->post('lead_status'),
                'industry' => $this->input->post('industry'),
                'employees' => $this->input->post('employees'),
                'annual_revenue' => $this->input->post('annual_revenue'),
                'rating' => $this->input->post('rating'),
                'website' => $this->input->post('website'),
                'secondary_email' => $this->input->post('secondary_email'),
                'assigned_to' => $this->input->post('assigned_to'),
                'assigned_to_name' => $this->input->post('assigned_to_name'),
                'org_id' => $this->input->post('org_id_act'),
                'cont_id' => $this->input->post('cnt_id_act'),
                'contact_name' => $this->input->post('contact_name'),
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
                //'description' 		=> $this->input->post('description'),
                'product_name' => implode("<br>", $this->input->post('product_name')),
                'quantity' => implode("<br>", $this->input->post('quantity')),
                'unit_price' => implode("<br>", $unit_price),
                'total' => implode("<br>", $total),
                //'percent' 			=> implode("<br>",$this->input->post('percent')),
                'pro_description' => implode("<br>", $this->input->post('pro_description')),
                'initial_total' => $initial_total,
                'discount' => $discount,
                'sub_total' => $sub_total,
                'total_percent' => '100.00',
                'assigned_status' => $assigned_status,
                'currentdate' => date("y.m.d"),
                'track_status' => 'lead',
            ];
            $id = $this->Lead->create($data);
            $lead_id = updateid($id, 'lead', 'lead_id');
            echo json_encode(["status" => true]);
            if ($id) {
                $workFlowStsAdmin = check_workflow_status('Admin', 'Mail notification on leads created');
                $workFlowStsStsUser = check_workflow_status('Lead', 'Mail notification to lead owner on lead created');
                $permissionSts = check_permission_status('Receive mail on create lead', 'other');

                add_customer_activity($id, $this->input->post('org_name'), $this->input->post('org_id_act'), $this->input->post('cnt_id_act'), $this->input->post('contact_name'), 'customer_lead');

                if ($permissionSts == true && $workFlowStsStsUser == true) {
                    $messageBody = '';
                    $subjectLine = "A new lead added by you - team365 | CRM";
                    $messageBody .=
                        '<div class="f-fallback">
            <h1>Dear , ' .
                        ucwords($this->session->userdata('name')) .
                        '!</h1>';
                    $messageBody .= '<p>You just created a lead from team365 | CRM</p>';
                    $messageBody .= '<p>Your Lead Detail are given bellow:-</p>';
                    $messageBody .= '<p>Lead Name : ' . $this->input->post('name') . '</p>';
                    $messageBody .=
                        '<p>
			Customer Name : ' .
                        $this->input->post('org_name') .
                        '
			<br>
			Contact Name : ' .
                        $this->input->post('contact_name') .
                        '
			<br>
			Lead ID : ' .
                        $lead_id .
                        '
			</p></div>';
                    sendMailWithTemp($this->session->userdata('email'), $messageBody, $subjectLine);
                }

                /*  SEND TO ADMIN  */
                if ($workFlowStsAdmin == true) {
                    $messagetoAdmin = '';
                    $subjectAdmin = "A new lead created - team365 | CRM";
                    $messagetoAdmin .= '<div class="f-fallback">
            <h1>Dear , Admin!</h1>';
                    $messagetoAdmin .= '<p>A new lead "' . $this->input->post('name') . '", Created.</p>';
                    $messagetoAdmin .= '<p>Lead detail:-</p>';
                    $messagetoAdmin .= '<p>Lead name : ' . $this->input->post('name') . '</p>';
                    $messagetoAdmin .=
                        '<p>
			Lead created by  : ' .
                        $this->session->userdata('name') .
                        '
			<br>
			Product : ' .
                        str_replace("<br>", ", ", $this->input->post('product_name')) .
                        '
			</p>';
                    $messagetoAdmin .= '</div>';
                    sendMailWithTemp($this->session->userdata('company_email'), $messagetoAdmin, $subjectAdmin);
                }
            }
        }
    }
    public function getbyId($id)
    {
        $data = $this->Lead->get_by_id($id);
        echo json_encode($data);
    }
    public function update()
    {
        $validation = $this->check_validation();
        if ($validation != 200) {
            echo $validation;
            die();
        } else {
            if ($this->input->post('assigned_to') != $this->session->userdata('email')) {
                $assigned_status = '1';
            } else {
                $assigned_status = '0';
            }

            $initial_total = str_replace(",", "", $this->input->post('initial_total'));
            $unit_price = str_replace(",", "", $this->input->post('unit_price'));
            $total = str_replace(",", "", $this->input->post('total'));
            $sub_total = str_replace(",", "", $this->input->post('sub_total'));
            $discount = str_replace(",", "", $this->input->post('discount'));

            $data = [
                'name' => $this->input->post('name'),
                'org_name' => $this->input->post('org_name'),
                'email' => $this->input->post('email'),
                'office_phone' => $this->input->post('office_phone'),
                'mobile' => $this->input->post('mobile'),
                'lead_source' => $this->input->post('lead_source'),
                'lead_status' => $this->input->post('lead_status'),
                'industry' => $this->input->post('industry'),
                'employees' => $this->input->post('employees'),
                'org_id' => $this->input->post('org_id_act'),
                'cont_id' => $this->input->post('cnt_id_act'),
                'annual_revenue' => $this->input->post('annual_revenue'),
                'rating' => $this->input->post('rating'),
                'website' => $this->input->post('website'),
                'secondary_email' => $this->input->post('secondary_email'),
                'assigned_to' => $this->input->post('assigned_to'),
                'assigned_to_name' => $this->input->post('assigned_to_name'),
                'contact_name' => $this->input->post('contact_name'),
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
                //'description' 		=> $this->input->post('description'),
                'product_name' => implode("<br>", $this->input->post('product_name')),
                'quantity' => implode("<br>", $this->input->post('quantity')),
                'unit_price' => implode("<br>", $unit_price),
                'total' => implode("<br>", $total),
                //'percent' 			=> implode("<br>",$this->input->post('percent')),
                'pro_description' => implode("<br>", $this->input->post('pro_description')),
                'initial_total' => $initial_total,
                'discount' => $discount,
                'sub_total' => $sub_total,
                'total_percent' => '100.00',
                'assigned_status' => $assigned_status,
            ];

            $st = $this->Lead->update(['id' => $this->input->post('id'), 'session_company' => $this->session->userdata('company_name'), 'session_comp_email' => $this->session->userdata('company_email')], $data);
            echo json_encode(["status" => $st]);
        }
    }
    public function delete($id)
    {
        $this->Lead->delete($id);
        echo json_encode(["status" => true]);
    }
    public function delete_bulk()
    {
        if ($this->input->post('checkbox_value')) {
            $id = $this->input->post('checkbox_value');
            for ($count = 0; $count < count($id); $count++) {
                $this->Lead->delete_bulk($id[$count]);
            }
        }
    }
    public function assigned()
    {
        if (!empty($this->session->userdata('email'))) {
            if (checkModuleForContr('Lead Generation') < 1) {
                redirect('home');
                exit();
            }

            $data['user'] = $this->Login_model->getusername();
            $data2 = [];
            $leadStatus = ['Pre-Qualified', 'Contacted', 'Junk Lead', 'Lost Lead', 'Not Contacted', 'Contact in Future', 'In Progress'];
            for ($i = 0; $i < count($leadStatus); $i++) {
                $ind = str_replace(' ', '', $leadStatus[$i]);
                $ind = str_replace('-', '', $ind);
                $data2[$ind] = $this->Lead->getTotalPrice($leadStatus[$i], 'assigned');
            }
            $data['price'] = $data2;
            $this->load->view('sales/assignedlead', $data);
        } else {
            redirect('login');
        }
    }
    public function ajax_list_assigned()
    {
        $list = $this->Lead->get_datatables_assigned();

        $delete_lead = 0;
        $update_lead = 0;
        $retrieve_lead = 0;
        $create_opp = 0;

        if (check_permission_status('Leads', 'delete_u') == true) {
            $delete_lead = 1;
        }
        if (check_permission_status('Opportunity', 'create_u') == true) {
            $create_opp = 1;
        }
        if (check_permission_status('Leads', 'retrieve_u') == true) {
            $retrieve_lead = 1;
        }
        if (check_permission_status('Leads', 'update_u') == true) {
            $update_lead = 1;
        }

        $data = [];
        $no = $_POST['start'];
        foreach ($list as $post) {
            $OppCount = $this->Opportunity->check_opp_exist($post->lead_id);
            $no++;
            $row = [];
            // APPEND HTML FOR ACTION

            if ($delete_lead == 1) {
                $row[] = '<input type="checkbox" class="delete_checkbox" value="' . $post->id . '">';
            }

            $companydetail = "
    <div class='d-flex align-items-center'>
        <img src='".base_url('')."/application/views/assets/images/faces/4.jpg' alt='img'
            class='rounded-circle mr-2' style='width: 1.75rem; height: 1.75rem;'>
        <div>
            <span>".ucfirst($post->org_name)."</span><br>
            
        </div>
    </div>";
            $first_row = "";
            $first_row .= ucfirst($post->name) . '<!--<div class="links">';
            if ($this->session->userdata('retrieve_lead') == '1'):
                $first_row .= '<a style="text-decoration:none" href="javascript:void(0)" onclick="view(' . "'" . $post->id . "'" . ')" class="text-success">View</a>|';
            endif;
            if ($this->session->userdata('update_lead') == '1'):
                $first_row .= '<a style="text-decoration:none" href="' . base_url() . 'add-lead/' . $post->id . '" class="text-primary">Update</a>|';
            endif;
            /*if($this->session->userdata('retrieve_lead')=='1'):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="chats('."'".$post->id."'".')" class="text-warning">Chat</a>|';
      endif;*/
            if ($this->session->userdata('create_opp') == '1'):
                $first_row .= '<a style="text-decoration:none" href="' . base_url() . 'add-opportunity?ld=' . $post->id . '" class="text-info">Create Opportunity</a>|';
            endif;
            if ($this->session->userdata('delete_lead') == '1'):
                $first_row .= '<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry(' . "'" . $post->id . "'" . ')" class="text-danger">Delete</a>';
            endif;
            $first_row .= '</div>-->';
            $row[] =  $companydetail;
            $row[] = $first_row;
            
            $row[] = $post->email;
            $row[] = $post->lead_owner;
            if ($post->lead_status == "") {
                $row[] = $post->lead_status;
            } elseif ($post->lead_status != "In Progress" && $post->lead_status != "Closed Won" && $post->lead_status != "Closed Lost" && $post->lead_status != 'Lost Lead' && $post->lead_status != 'Contacted') {
                $row[] = '<label class="text-primary" >' . $post->lead_status . '</label>';
            } elseif ($post->lead_status == "In Progress") {
                $row[] = '<label class="text-primary" >' . $post->lead_status . '</label>';
            } elseif ($post->lead_status == "Contacted") {
                $row[] = '<label class="text-info" >' . $post->lead_status . '</label>';
            } elseif ($post->lead_status == "Closed Won") {
                $row[] = '<label class="text-success" >' . $post->lead_status . '</label>';
            } elseif ($post->lead_status == "Closed Lost" || $post->lead_status == 'Lost Lead') {
                $row[] = '<label class="text-danger" >' . $post->lead_status . '</label>';
            }

            $action = '<div class="row" style="font-size: 15px;">';
            if ($retrieve_lead == 1) {
                $action .=
                    '<a style="text-decoration:none" href="javascript:void(0)" onclick="view(' .
                    "'" .
                    $post->id .
                    "'" .
                    ')" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Lead Details" ></i></a>';
            }
            if ($update_lead == 1) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'add-lead/' .
                    $post->id .
                    '" class="text-primary border-right">
					<i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Lead Details" ></i></a>';
            }
            if ($create_opp == 1 && $OppCount < 1) {
                $action .=
                    '<a style="text-decoration:none" href="' .
                    base_url() .
                    'add-opportunity?ld=' .
                    $post->id .
                    '" class="text-info border-right">
					<i class="fas fa-briefcase sub-icn-po m-1" data-toggle="tooltip" data-container="body" title="Create Opportunity" ></i></a>';
            }
            if ($delete_lead == 1) {
                $action .=
                    '<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry(' .
                    "'" .
                    $post->id .
                    "'" .
                    ')"  class="text-danger">
					<i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Lead" ></i></a>';
            }
            $action .= '</div>';

            $row[] = $action;

            $data[] = $row;
        }
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Lead->count_all_assigned(),
            "recordsFiltered" => $this->Lead->count_filtered_assigned(),
            "data" => $data,
        ];
        //output to json format
        echo json_encode($output);
    }
    public function getleadId($id)
    {
        $data = $this->Lead->get_lead_id($id);
        echo json_encode($data);
    }
    public function getchatbyId()
    {
        $id = $this->input->post('data');
        $data1 = $this->Lead->get_chat_by_id($id);
        echo json_encode($data1);
    }
    public function sendmsg()
    {
        $validation = $this->chat_validation();
        if ($validation != 200) {
            echo $validation;
            die();
        } else {
            $data = [
                'sess_eml' => $this->session->userdata('email'),
                'session_company' => $this->session->userdata('company_name'),
                'session_comp_email' => $this->session->userdata('company_email'),
                'sess_name' => $this->session->userdata('name'),
                'entry_id' => $this->input->post('entry_id'),
                'messages' => $this->input->post('messages'),
                'currentdate' => date("y.m.d"),
            ];
            $id = $this->Lead->sendmsg($data);
            echo json_encode(["status" => true]);
        }
    }
    public function check_validation()
    {
        $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('org_name', 'Organization', 'required|trim');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'regex_match[/^[0-9]{10}$/]|trim');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
        $this->form_validation->set_rules('lead_source', 'Lead Source', 'required|trim');
        $this->form_validation->set_rules('lead_status', 'Lead Status', 'required|trim');
        $this->form_validation->set_rules('billing_country', 'Billing Country', 'required|trim');
        $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
        $this->form_validation->set_rules('shipping_country', 'Shipping Country', 'required|trim');
        $this->form_validation->set_rules('shipping_state', 'Sipping State', 'required|trim');
        $this->form_validation->set_rules('billing_city', 'Billing City', 'required|trim');
        $this->form_validation->set_rules('billing_zipcode', 'Billing Zipcode', 'required|trim');
        $this->form_validation->set_rules('shipping_zipcode', 'Shipping Zipcode', 'required|trim');
        $this->form_validation->set_rules('shipping_city', 'Shipping City', 'required|trim');
        $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
        $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'required|trim');

        $this->form_validation->set_rules('product_name[]', 'Product', 'required|trim');
        $this->form_validation->set_rules('quantity[]', 'Product Quantity', 'required|trim');
        $this->form_validation->set_rules('unit_price[]', 'Per Product Price', 'required|trim');
        $this->form_validation->set_rules('total[]', 'Total Price', 'required|trim');
        $this->form_validation->set_rules('initial_total', 'Initial Total', 'required|trim');
        $this->form_validation->set_rules('discount', 'Discount', 'required|trim');
        $this->form_validation->set_rules('sub_total', 'Sub Total', 'required|trim');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_message('valid_email', '%s is not valid');
        $this->form_validation->set_message('regex_match', '%s is not valid');
        if ($this->form_validation->run() == false) {
            return json_encode([
                'st' => 202,
                'name' => form_error('name'),
                'org_name' => form_error('org_name'),
                'mobile' => form_error('mobile'),
                'email' => form_error('email'),
                'lead_source' => form_error('lead_source'),
                'lead_status' => form_error('lead_status'),
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
                'product_name' => form_error('product_name[]'),
                'quantity' => form_error('quantity[]'),
                'unit_price' => form_error('unit_price[]'),
                'total' => form_error('total[]'),
                'initial_total' => form_error('initial_total'),
                'discount' => form_error('discount'),
                'sub_total' => form_error('sub_total'),
            ]);
        } else {
            return 200;
        }
    }
    public function chat_validation()
    {
        $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
        $this->form_validation->set_rules('messages', 'Message', 'required|trim');
        $this->form_validation->set_message('required', '%s is required');
        if ($this->form_validation->run() == false) {
            return json_encode(['st' => 202, 'messages' => form_error('messages')]);
        } else {
            return 200;
        }
    }
    public function import()
    {
        $this->load->library('csvimport');
        if (check_permission_status('Leads', 'create_u') == true) {
            if (isset($_FILES["file"]["name"])) {
                $duplicate_array = [];
                $message_array = [];
                $file_data = $this->csvimport->get_array($_FILES["file"]["tmp_name"]);
                foreach ($file_data as $row) {
                    $lead_name = $row["lead_name"];
                    $org_name = $row["organization_name"];
                    $contact_name = $row["contact_name"];
                    $email = $row["email"];
                    $phone = $row["phone"];
                    $source = $row["source"];
                    $lead_status = $row["lead_status"];
                    $assignedName = $row["assigned_to_name"];
                    $assignedEmail = $row["assigned_to_email"];
                    $currentdate = date('Y-m-d');
                    $delete_status = 1;

                    $dataArr = [
                        'sess_eml' => $this->session->userdata('email'),
                        'session_company' => $this->session->userdata('company_name'),
                        'session_comp_email' => $this->session->userdata('company_email'),
                        'org_name' => $org_name,
                        'name' => $lead_name,
                        'contact_name' => $contact_name,
                        'email' => $email,
                        'mobile' => $phone,
                        'lead_source' => $source,
                        'lead_status' => $lead_status,
                        'assigned_to_name' => $assignedName,
                        'assigned_to' => $assignedEmail,
                        'currentdate' => $currentdate,
                        'delete_status' => $delete_status,
                    ];

                    if (empty($email) || empty($phone)) {
                        echo json_encode(['st' => 202, 'msg' => 'Import Failed All Fields Are Required']);
                    } elseif (!empty($email) && !empty($phone)) {
                        $id = $this->Lead->create($dataArr);
                        $lead_id = updateid($id, 'lead', 'lead_id');
                        $message_array = ['st' => 200, 'msg' => 'Data Imported Successfully'];
                    }
                }
                if (count($duplicate_array) > 0) {
                    echo json_encode($duplicate_array);
                } else {
                    echo json_encode($message_array);
                }
            }
        }
    }
    
    
      public function add_leadStatus()
	{
        // print_r('test');die;
		if ($this->input->is_ajax_request()) {
            $data = [
                'sess_eml' => $this->session->userdata('email'),
                'session_company' => $this->session->userdata('company_name'),
                'session_comp_email' => $this->session->userdata('company_email'),
                'name' => $this->input->post('leadstatus')
            ];

            $id = $this->Lead->save_lead_status($data);

			if (!empty($id)) {
				$response = array(
					'success' => true,
					'message' => 'Satus Save Successfully',
					'id' => $id
				);
				echo json_encode($response);
			} else {
				$response = array(
					'success' => false,
					'message' => 'Status Add Failed'
				);
				echo json_encode($response);
			}
		} else {
			echo "Invalid request";
		}
	}



    public function add_mass()
	{
		if ($this->input->is_ajax_request()) {

      $mass_id = $this->input->post('mass_id');
      $mass_name = $this->input->post('mass_name');
      $mass_value = $this->input->post('mass_value');
			$dataArry = array(
				$mass_name => $mass_value,
				'currentdate' => date('Y-m-d')
				
			);
        // print_r($dataArry);die;
			$mass_data = $this->Lead->mass_save($mass_id, $dataArry);
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
