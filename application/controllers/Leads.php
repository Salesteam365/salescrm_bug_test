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
    /**
    * Display the leads dashboard: checks session and permissions, prepares lead counts and total prices per status, then loads the sales/leads view or redirects as needed.
    * @example
    * $leadsController = new Leads();
    * $leadsController->index();
    * // Renders 'sales/leads' view and populates $data, for example:
    * // $data['user'] = ['username' => 'jdoe', 'standard_email' => 'jdoe@example.com'];
    * // $data['admin'] = ['username' => 'admin'];
    * // $data['users_data'] = [['standard_email' => 'jdoe@example.com'], ['standard_email' => 'asmith@example.com']];
    * // $data['price'] = ['PreQualified' => 1500.00, 'Contacted' => 300.00, 'JunkLead' => 0.00];
    * // $data['countLead'] = 42;
    * @param {void} $none - No parameters.
    * @returns {void} Does not return a value; outputs a view or performs a redirect.
    */
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
    /**
    * Display a lead record by ID and render the sales/view-lead view. Checks user session and permissions; may redirect to login or home. If the current user is an admin, related notifications are updated.
    * @example
    * // Call from the Leads controller to render lead with ID 123
    * $this->view_lead(123);
    * // Renders 'sales/view-lead' with the lead record or redirects to 'login' / 'home'
    * @param {int} $id - Lead ID to load and display.
    * @returns {void} No return value; this method outputs a view or performs a redirect.
    */
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
    /**
    * Load the add/edit leads page after verifying create/update permissions and preparing data for the view.
    * @example
    * // Typically invoked by the framework when visiting the controller route, or from another controller:
    * $this->load->controller('Leads')->add_leads();
    * // If permitted, the method will load the view 'sales/add-lead' with data such as:
    * // $data['lead_status'] => array('New', 'Contacted', 'Qualified');
    * // $data['user'] => 'jdoe';
    * // $data['admin'] => 'adminuser';
    * // $data['record'] => array('id' => 5, 'name' => 'Acme Corp', 'status' => 'New');
    * // $data['countLead'] => 42;
    * @param {void} - No parameters are accepted by this controller method.
    * @returns {void} Loads a view ('sales/add-lead' or 'permission') and does not return a value.
    */
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
    /**
     * Display the lead view page for a single lead if the current user has 'retrieve' permission; otherwise redirect to the home page.
     * @example
     * // Example when visiting URL: /leads/123
     * $id = 123; // extracted from $this->uri->segment(2)
     * $this->view_leads(); // loads 'sales/view-lead' with sample data:
     * // $data = [
     * //   'user'   => 'jdoe', 
     * //   'admin'  => 'admin1', 
     * //   'record' => ['id' => 123, 'name' => 'Acme Corp', 'email' => 'contact@acme.com']
     * // ];
     * @param int $id - Lead ID extracted from the URI segment(2); used to fetch the lead record for viewing.
     * @returns void No return value; loads the view on success or redirects to base_url().'home' when permission is denied.
     */
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
    /**
    * Render a column grid of leads for a specific lead status as HTML (outputs directly).
    * @example
    * $list = [
    *   ['id' => 12, 'lead_id' => 5, 'lead_status' => 'New Lead', 'name' => 'Acme Corp', 'org_name' => 'Acme', 'initial_total' => 15000, 'currentdate' => '2025-12-01', 'lead_owner' => 'Alice']
    * ];
    * $dataCount = ['New Lead' => 1];
    * $this->returngrid($list, 'New Lead', 1, $dataCount);
    * // Prints a <div class="lists" ...> with lead items (HTML is echoed directly)
    * @param array $list - Array of lead records; each record should contain keys: id, lead_id, lead_status, name, org_name, initial_total, currentdate, lead_owner.
    * @param string $leadStatus - The lead status to render (e.g. 'New Lead').
    * @param int $count - Index used to build the container element id (e.g. 1).
    * @param array $dataCount - Associative array mapping lead statuses to counts (e.g. ['New Lead' => 3]).
    * @returns void Outputs HTML directly; does not return a value.
    */
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
    /**
    * Render a Kanban-style grid of leads grouped by status and output the necessary HTML and JavaScript
    * to enable drag-and-drop reordering between status columns. The method reads pagination and filter
    * inputs from POST, fetches leads, sorts and counts them by status, renders seven status columns and
    * binds a jQuery UI sortable handler that posts status updates to the leads/update_status endpoint.
    * @example
    * // From a controller context (no arguments). This call will directly echo HTML + JS to the response.
    * $this->Leads->gridview();
    * // Example fragment of what is rendered:
    * // "<div id='list1' class='lists' data-status='Pre-Qualified'>...lead items...</div><script>/* sortable + AJAX to update_status */
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
    /**
    * Generate JSON pagination links for the Leads listing (initializes CodeIgniter pagination using optional filters).
    * @example
    * $_GET['searchDate'] = '2025-01-01';
    * $_GET['search'] = 'Acme';
    * $_POST['assigned'] = '12';
    * $this->pagination();
    * // Outputs: {"pagination_link":"<ul class=\"pagination\"><li class='activli'><a href='#'>1</a></li><li><a href='#'>2</a></li></ul>"}
    * @param string|null $searchDate - Optional GET parameter 'searchDate' used to filter leads.
    * @param string|null $search - Optional GET parameter 'search' used to filter leads.
    * @param string|null $assigned - Optional POST parameter 'assigned' used to filter leads.
    * @returns string JSON encoded object with key 'pagination_link' containing the HTML for the pagination links.
    */
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


    /**
    * Generate and echo a JSON response for DataTables containing the leads list with action HTML based on user permissions.
    * @example
    * $_POST = ['start' => 0, 'draw' => 1, 'actDate' => '']; 
    * $controller = new Leads();
    * $controller->ajax_list();
    * // Outputs (example): {"draw":1,"recordsTotal":42,"recordsFiltered":42,"data":[["<a...>...</a>","John Doe","owner@example.com","Assignee","<label class=\"text-primary\">Open</label>","<div class=\"row\">...</div>"], ...]}
    * @param array $post - POST input array (expects 'start' => int, 'draw' => int, optional 'actDate' => string) used to paginate and tailor the response.
    * @returns void Echoes a JSON-encoded string containing keys: draw, recordsTotal, recordsFiltered, and data (rows with HTML for display/actions).
    */
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
    /**
    * Assign selected leads to a specified user by updating assigned_status, assigned_to, and assigned_to_name.
    * @example
    * $_POST['selected'] = '12,15,';
    * $_POST['userforlead'] = '23';
    * $_POST['username'] = 'Jane Doe';
    * $this->assignlead_user();
    * // Outputs: 1
    * @param {string} selected - Comma-separated list of lead IDs from POST (e.g. "12,15,")
    * @param {int|string} userforlead - ID of the user to assign leads to (e.g. 23)
    * @param {string} username - Display name of the user to assign leads to (e.g. "Jane Doe")
    * @returns {int|bool} Result of the last update operation (typically 1 or true on success, 0/false on failure).
    */
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
    /**
     * Create a new lead from POSTed form data, persist it, trigger workflow emails and echo a JSON status.
     *
     * Validates input via check_validation(). If validation fails, the method echoes the validation HTTP code and terminates.
     * On success the method:
     *  - sanitizes numeric values (removes thousands separators like ","),
     *  - composes lead data from POST and session values,
     *  - inserts the lead via $this->Lead->create(),
     *  - updates the lead id token, logs customer activity,
     *  - optionally sends notification emails to the lead owner and admin according to workflow/permission settings,
     *  - echoes a JSON response ({"status":true}) and continues execution.
     *
     * @example
     * // Simulate POST data (typical values)
     * $_POST = [
     *   'name' => 'John Doe Lead',
     *   'org_name' => 'Acme Inc.',
     *   'lead_owner' => 'owner@example.com',
     *   'email' => 'lead@example.com',
     *   'office_phone' => '0123456789',
     *   'mobile' => '0987654321',
     *   'lead_source' => 'Website',
     *   'lead_status' => 'New',
     *   'industry' => 'Software',
     *   'employees' => '50',
     *   'annual_revenue' => '1000000',
     *   'rating' => 'Hot',
     *   'website' => 'https://acme.example',
     *   'secondary_email' => 'alt@example.com',
     *   'assigned_to' => 'assignee@example.com',
     *   'assigned_to_name' => 'Assignee Name',
     *   'org_id_act' => '123',
     *   'cnt_id_act' => '456',
     *   'contact_name' => 'Jane Contact',
     *   'billing_country' => 'USA',
     *   'billing_state' => 'CA',
     *   'shipping_country' => 'USA',
     *   'shipping_state' => 'CA',
     *   'billing_city' => 'San Francisco',
     *   'billing_zipcode' => '94105',
     *   'shipping_city' => 'San Francisco',
     *   'shipping_zipcode' => '94105',
     *   'billing_address' => '100 Market St',
     *   'shipping_address' => '100 Market St',
     *   'product_name' => ['Product A','Product B'],
     *   'quantity' => ['1','2'],
     *   'unit_price' => ['1,234.56','789.00'],
     *   'total' => ['1,234.56','1,578.00'],
     *   'pro_description' => ['Desc A','Desc B'],
     *   'initial_total' => '2,812.56',
     *   'discount' => '0.00',
     *   'sub_total' => '2,812.56'
     * ];
     *
     * // Call (within controller context)
     * $this->Leads->create();
     *
     * // Typical echoed output on success:
     * // {"status":true}
     *
     * @param string $name - Lead full name (POST: 'name').
     * @param string $org_name - Organization / Customer name (POST: 'org_name').
     * @param string $lead_owner - Lead owner identifier or email (POST: 'lead_owner').
     * @param string $email - Lead email address (POST: 'email').
     * @param string $office_phone - Office phone number (POST: 'office_phone').
     * @param string $mobile - Mobile phone number (POST: 'mobile').
     * @param string $lead_source - Source of the lead (POST: 'lead_source').
     * @param string $lead_status - Current lead status (POST: 'lead_status').
     * @param string $industry - Industry name (POST: 'industry').
     * @param string|int $employees - Number of employees (POST: 'employees').
     * @param string|float $annual_revenue - Annual revenue (POST: 'annual_revenue').
     * @param string $rating - Lead rating (POST: 'rating').
     * @param string $website - Company website (POST: 'website').
     * @param string $secondary_email - Secondary email (POST: 'secondary_email').
     * @param string $assigned_to - Assignee email (POST: 'assigned_to').
     * @param string $assigned_to_name - Assignee full name (POST: 'assigned_to_name').
     * @param string|int $org_id_act - Associated organization id (POST: 'org_id_act').
     * @param string|int $cnt_id_act - Associated contact id (POST: 'cnt_id_act').
     * @param string $contact_name - Primary contact name (POST: 'contact_name').
     * @param string $billing_country - Billing country (POST: 'billing_country').
     * @param string $billing_state - Billing state (POST: 'billing_state').
     * @param string $shipping_country - Shipping country (POST: 'shipping_country').
     * @param string $shipping_state - Shipping state (POST: 'shipping_state').
     * @param string $billing_city - Billing city (POST: 'billing_city').
     * @param string $billing_zipcode - Billing postal/zipcode (POST: 'billing_zipcode').
     * @param string $shipping_city - Shipping city (POST: 'shipping_city').
     * @param string $shipping_zipcode - Shipping postal/zipcode (POST: 'shipping_zipcode').
     * @param string $billing_address - Billing street address (POST: 'billing_address').
     * @param string $shipping_address - Shipping street address (POST: 'shipping_address').
     * @param string[] $product_name - Array of product names (POST: 'product_name').
     * @param string[] $quantity - Array of quantities per product (POST: 'quantity').
     * @param string[] $unit_price - Array of unit prices per product (POST: 'unit_price', may include commas).
     * @param string[] $total - Array of total prices per product (POST: 'total', may include commas).
     * @param string[] $pro_description - Array of product descriptions (POST: 'pro_description').
     * @param string|float $initial_total - Initial total amount (POST: 'initial_total', may include commas).
     * @param string|float $discount - Discount amount (POST: 'discount', may include commas).
     * @param string|float $sub_total - Sub total amount (POST: 'sub_total', may include commas).
     *
     * @returns void Echoes JSON(true) on success: {"status":true}. If validation fails it echoes the validation code (non-200) and terminates the request. Session values (email, company_name, company_email, name) are used during processing and for email notifications.
     */
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
    /**
     * Update an existing lead record using POSTed form data, validate input and echo a JSON status response.
     * @example
     * // Example HTTP POST (curl) with sample values:
     * // curl -X POST https://example.com/leads/update \
     * //   -F "id=123" \
     * //   -F "name=Acme Corp" \
     * //   -F "org_name=Acme Organization" \
     * //   -F "email=contact@acme.test" \
     * //   -F "assigned_to=user@example.com" \
     * //   -F "assigned_to_name=Jane Doe" \
     * //   -F "product_name[]=Widget A" -F "product_name[]=Widget B" \
     * //   -F "quantity[]=2" -F "quantity[]=1" \
     * //   -F "unit_price[]=1,200.00" -F "unit_price[]=300.00" \
     * //   -F "initial_total=1500.00" -F "sub_total=1400.00" -F "discount=100.00"
     * // Sample response:
     * // {"status":1}
     * @param {array} $postData - Associative array of POST fields expected from the form (examples: id, name, org_name, email, office_phone, mobile, lead_source, lead_status, industry, employees, org_id_act, cnt_id_act, annual_revenue, rating, website, secondary_email, assigned_to, assigned_to_name, contact_name, billing_country, billing_state, billing_city, billing_zipcode, billing_address, shipping_country, shipping_state, shipping_city, shipping_zipcode, shipping_address, product_name[], quantity[], unit_price[], total[], pro_description[], initial_total, discount, sub_total)
     * @returns {string} JSON-encoded string containing a "status" key (e.g. {"status":1}) indicating whether the update succeeded.
     */
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
    /**
    * Retrieve assigned leads page: verifies session and module permission, aggregates total prices by lead status for leads assigned to the user, and loads the 'sales/assignedlead' view.
    * @example
    * // From a controller context (authenticated user with permission):
    * $this->assigned();
    * // The view receives $data['user'] and $data['price'] where $data['price'] is an associative array like:
    * // ['PreQualified' => 1200.50, 'Contacted' => 300.00, 'JunkLead' => 0.00, 'LostLead' => 50.00, 'NotContacted' => 0.00, 'ContactinFuture' => 0.00, 'InProgress' => 250.00]
    * @param {void} $none - No arguments required.
    * @returns {void} Loads the assigned leads view or redirects to 'login'/'home' (no direct return value).
    */
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
    /**
    * Retrieve assigned leads for DataTables and echo a JSON response suitable for DataTables consumption.
    * @example
    * // Called from a controller route; this method prints JSON directly:
    * $this->ajax_list_assigned();
    * // Sample output (formatted):
    * // {"draw":1,"recordsTotal":12,"recordsFiltered":12,"data":[["<input type=\"checkbox\" value=\"3\">","<div class='d-flex'>...Org Name...</div>","John Doe","john@example.com","Lead Owner","<label class='text-primary'>New</label>","<div class='row'>...actions...</div>"], ...]}
    * @param array $_POST - POST payload expected from DataTables with keys 'start' (int) and 'draw' (int).
    * @returns void Outputs JSON containing keys 'draw' (int), 'recordsTotal' (int), 'recordsFiltered' (int) and 'data' (array of table rows).
    */
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
    /**
    * Send a chat message for a lead: validates the request, collects session and POST data, forwards it to the Lead model, and echoes a JSON success response.
    * @example
    * // Example usage (within controller context). Ensure POST contains 'entry_id' and 'messages' and session contains user/company data:
    * $_POST = ['entry_id' => 123, 'messages' => 'Hello, I am interested in this lead.'];
    * $this->session->set_userdata(['email' => 'user@example.com', 'company_name' => 'Acme Inc', 'company_email' => 'info@acme.com', 'name' => 'Jane Doe']);
    * $this->sendmsg();
    * // Output (echoed):
    * // {"status":true}
    * @param void $none - This method accepts no direct parameters; it reads input from POST and session.
    * @returns void Echoes a JSON object with a boolean "status" key indicating success.
    */
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
    /**
    * Validate lead form input using CodeIgniter form_validation; returns JSON errors on failure or 200 on success.
    * @example
    * $result = $this->check_validation();
    * echo $result; // On failure: {"st":202,"name":"Name is required","email":"Email is not valid"} On success: 200
    * @param void $none - This method does not accept any arguments.
    * @returns int|string Returns 200 on successful validation or a JSON-encoded string (status 202 and field-specific HTML error messages) on failure.
    */
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
    /**
     * Import leads from an uploaded CSV file.
     * Checks create permission, parses the CSV rows using the csvimport library,
     * validates required fields (email and phone), creates lead records, and echoes a JSON response.
     * @example
     * // Send a POST request with the CSV file under the "file" field:
     * // curl -X POST -F "file=@leads.csv" https://example.com/leads/import
     * // Example responses:
     * // Success: {"st":200,"msg":"Data Imported Successfully"}
     * // Missing required fields: {"st":202,"msg":"Import Failed All Fields Are Required"}
     * // Duplicates: [{"row":2,"error":"duplicate entry for email or phone"}]
     * @param array $_FILES - PHP $_FILES superglobal; expects a CSV file in $_FILES['file'] (tmp_name is read by the importer).
     * @returns string JSON encoded response (echoed) indicating the operation status or duplicate details.
     */
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
    
    
      /**
       * Add a new lead status from an AJAX request and return a JSON response.
       * @example
       * // jQuery AJAX example sending a new lead status:
       * $.post('/leads/add_leadStatus', { leadstatus: 'New Lead' }, function(response) {
       *     // sample success response: {"success":true,"message":"Satus Save Successfully","id":123}
       *     // sample failure response: {"success":false,"message":"Status Add Failed"}
       *     console.log(response);
       * }, 'json');
       * @param {string} $leadstatus - Lead status value supplied in POST data (key: 'leadstatus').
       * @returns {string} JSON encoded response string with keys:
       *                    - success (bool) whether the save succeeded,
       *                    - message (string) human readable result message,
       *                    - id (int|null) the new record id when success; if not an AJAX request the plain string "Invalid request" is echoed.
       */
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



    /**
    * Add or update a mass field based on AJAX POST data and echo a JSON response.
    * @example
    * $_POST = ['mass_id' => 123, 'mass_name' => 'weight', 'mass_value' => '75kg'];
    * $result = $this->Leads->add_mass();
    * echo $result; // {"success":true,"message":"Mass Update Successfully"} or {"success":false,"message":"Mass Update Failed"} or "Invalid request"
    * @param int|null $mass_id - ID of the mass entry from POST (nullable; new record if empty).
    * @param string $mass_name - The name/key of the mass field from POST.
    * @param string $mass_value - The value for the mass field from POST.
    * @returns string JSON encoded response indicating success or failure, or a plain string "Invalid request".
    */
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
