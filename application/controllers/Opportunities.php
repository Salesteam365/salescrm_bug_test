<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Opportunities extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Opportunity_model','Opportunity');
    $this->load->model('Quotation_model','Quotation');
    $this->load->model('Lead_model','Lead');
    $this->load->model('Login_model');
    $this->load->library(array('upload','email_lib'));
     date_default_timezone_set('Asia/Kolkata');
  }
  public function index()
  {
    if(!empty($this->session->userdata('email')))
    {
       if(checkModuleForContr('Create Opportunities')<1){
	        redirect('home');
	        exit;
	    } 
		if(check_permission_status('Opportunity','retrieve_u')==true){       
		  $date= "15 days";
		  $data['opp_popup'] = $this->Opportunity->get_pending_opportunity($date);
		  $data['users_data'] = $this->Login_model->get_company_users();
		  $data['user']  		= $this->Login_model->getusername();
		  $data['admin'] 		= $this->Login_model->getadminname();
		  
		  //sub opp Data fetch
		  $data['sub_opp_popup'] = $this->Opportunity->get_pending_sub_opportunity();
		  
		  $leadStatus=array('New','Qualifying','Closed Lost','Ready To Close','Value Proposition','Closed Won','Negotiation','Proposal','Needs Analysis');
			for($i=0; $i<count($leadStatus); $i++){
				$ind=str_replace(' ','',$leadStatus[$i]);
				$ind=str_replace('-','',$ind);
				$data2[$ind]=$this->Opportunity->getTotalPrice($leadStatus[$i]); 
			}
			$data['price']=$data2;
		  $data['countOpp'] = $this->Opportunity->count_all();	
		  $this->load->view('sales/opportunity',$data);
		}else{
			
		}
		
    }
    else
    {
      redirect('login');
    }
  }
  
   public function add_opportunity(){
	   
	 $sub_opp_id = $this->input->get('sub_opp');
    $data['sub_oppData'] = $this->Opportunity->get_sub_opp_for_create($sub_opp_id);
	   
	if(check_permission_status('Opportunity','create_u')==true || check_permission_status('Opportunity','update_u')==true){     
	   $id=$this->uri->segment(2);  
	   if(isset($_GET['ld']) && $_GET['ld']!=""){
		   $data['record'] = $this->Lead->get_data_for_update($_GET['ld']);
		   $data['action']=array('data'=>'add','from'=>'lead');
	   }else if(isset($id) && $id!=""){
		   $data['record'] = $this->Opportunity->get_data_for_update($id);
		   $data['action'] = array('data'=>'update','from'=>'opportunity');
	   }else{
		   $data['action'] = array('data'=>'add','from'=>'direct');
	   }
	$data['user'] 		= $this->Login_model->getusername();
    $data['admin'] 		= $this->Login_model->getadminname();  
	$data['users_data'] = $this->Login_model->get_company_users();
	$data['countOpp'] 	= $this->Opportunity->count_all();
	$this->load->view('sales/add-opportunity',$data);
	}else{

	}		
  }
  
    
  public function returngrid($list,$leadStatus,$count,$dataCount){
      $ind=str_replace(' ','',$leadStatus);
      $ind=str_replace('-','',$ind);
	  
	$delete_opp		=0;
	$update_opp		=0;
	$retrieve_opp	=0;
	$create_quote	=0;  
	if(check_permission_status('Opportunity','delete_u')==true){
		$delete_opp=1;
	}
	if(check_permission_status('Quotations','create_u')==true){
		$create_quote=1;
	}
	if(check_permission_status('Opportunity','retrieve_u')==true){
		$retrieve_opp=1;
	}
	if(check_permission_status('Opportunity','update_u')==true){
		$update_opp=1;
	} 
	  
      ?>
     <div class="lists" data-status="<?=$leadStatus;?>" data-textid="<?=$ind;?>" id="list<?=$count;?>">
	  <?php if(isset($dataCount[$leadStatus])){
				$r=1; 
				foreach($list as $row){ 
				if($row['stage']==$leadStatus){
					
                    $CountQt = $this->Quotation->check_quote_exist($row['opportunity_id']);
				?>
				<div id='item<?=$row['id'];?>' data-id="<?=$row['id'];?>" data-putid="<?=$ind;?>" data-price="<?=$row['initial_total'];?>" class="col-lg-12 mt-2 divli">
				<div class="leadname"><?=$row['name'];?></div>
				<div style="font-size: 13px;">
				<i class="fas fa-university" style="margin-right: 5px;"></i>
				<?=$row['org_name'];?></div>
				<div style="font-size: 12px;">
				 <i class="fas fa-rupee-sign" style="margin-right: 5px;"></i><?=IND_money_format($row['initial_total']);?>
				</div>
				<div style="font-size: 12px;">
				    <i class="far fa-calendar-alt" style="margin-right: 5px;"></i>
    				<?php
    				    $date=date_create($row['currentdate']);
    				    echo date_format($date,"d M Y");
    				?>
				</div>
				<div style="font-size: 12px;">
						<i class="far fa-user" style="margin-right: 4px;"></i>
						<?=$row['owner'];?>
				</div>
				<label>
				 <?php 
				 if($create_quote==1 && $CountQt<1):
                    $firstRow= '<a style="text-decoration:none" href="javascript:void(0)" onclick="quote('."'".$row['id']."'".')" class="text-info">+ Quote</a>';
                    echo $firstRow;
                  endif; ?>
					<span style="float: right;">
				<?php if($update_opp==1){ ?>	    
					<i class="far fa-edit" style="margin-right: 10px; cursor:pointer; color:#111;" onclick="update('<?=$row['id'];?>')"></i> 
				<?php } if($retrieve_opp==1){ ?>	
					<i class="far fa-eye"  style="margin-right: 10px; cursor:pointer; color:#111;" onclick="view('<?=$row['id'];?>')" ></i>
				<?php } if($delete_opp==1){ ?>	
					<i class="far fa-trash-alt" style="cursor:pointer; color:#111;" onclick="delete_entry('<?=$row['id'];?>')" ></i>
				<?php } ?>	
					</span>
				 </label>
				</div>
			<?php $r++; } } }?>
			
		</div>
	
	<?php  
  }
  

   public function gridview(){
	  $per_page=10;
	  $page = $this->input->post('page');
      $start = ($page - 1) * $per_page;
	  $searchDate	= $this->input->post('searchDate');
	  $search		= $this->input->post('search');
	  $list = $this->Opportunity->get_all_opp($searchDate,$search,$per_page, $start);
	   $sort = array();
		foreach($list as $k=>$v) {
		   $sort['stage'][$k] = $v['stage'];
		}
		
		if(count($sort)){
		array_multisort($sort['stage'], SORT_ASC,$list);
		}
		
		$dataCount= array_count_values(array_column($list, 'stage')); 
		
		$leadStatus=array('New','Qualifying','Closed Lost','Ready To Close','Value Proposition','Closed Won','Negotiation','Proposal','Needs Analysis');
        $m=1;
        for($i=0; $i<count($leadStatus); $i++){
    		$this->returngrid($list,$leadStatus[$i],$m,$dataCount);
    		$m++;
    	}
	 
	  ?>
	  
		<script>
		    $(function () {
        $("#list1, #list2, #list3, #list4, #list5, #list6, #list7, #list8, #list9").sortable({
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
					url : "<?= site_url('opportunities/update_status');?>",
					type: "POST",
					data: "leadid="+dataid+"&status="+status,
					dataType: "JSON",
					success: function(data)
					{
						
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
	$searchDate	= $_GET['searchDate'];
	if(isset($_GET['selectUser'])){
	$selectUser	= $_GET['selectUser'];
	}else{
		$selectUser='';
	}
	if(isset($_GET['endDate']) && isset($_GET['startDate'])){
		$endDate	= $_GET['endDate'];
		$startDate	= $_GET['startDate'];
	}else{
		$endDate	= '';
		$startDate	= '';
	}
	
	
	if(isset($_GET['search'])){
		$search		= $_GET['search'];
	}else{
		$search='';
	}
	  
  $AllData   = $this->Opportunity->get_all_count($searchDate,$search,$selectUser,$endDate,$startDate);
  //echo $searchDate; 
  
  //exit;
  $config = array();
  $config["base_url"] = "#";
  $config["total_rows"] = $AllData;
  $config["per_page"] = 10;
  $config["uri_segment"] = 3;
  $config["use_page_numbers"] = TRUE;
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

  $output = array(
   'pagination_link'  => $this->pagination->create_links()
  );
  echo json_encode($output);
 }
  

   public function update_status(){
	  $leadid=$this->input->post('leadid');
	  $status=$this->input->post('status');
	  $dataArr=array('stage'=>$status);
	  $data = $this->Opportunity->update_status($dataArr,$leadid);
    echo json_encode($data);
	  
  }
  
  
  public function ajax_list()
  {
	$delete_opp		=0;
	$update_opp		=0;
	$retrieve_opp	=0;
	$create_quote	=0;  
	if(check_permission_status('Opportunity','delete_u')==true){
		$delete_opp=1;
	}
	if(check_permission_status('Quotations','create_u')==true){
		$create_quote=1;
	}
	if(check_permission_status('Opportunity','retrieve_u')==true){
		$retrieve_opp=1;
	}
	if(check_permission_status('Opportunity','update_u')==true){
		$update_opp=1;
	}  
	  
    $list = $this->Opportunity->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
		$CountQt = $this->Quotation->check_quote_exist($post->opportunity_id);
		$dataAct=$this->input->post('actDate');
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
      if($delete_opp==1) { 
           if($dataAct!='actdata'){
              // $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">'; 
              $row[] = '<input type="checkbox" class="delete_checkbox" onClick="checkCheckbox(); showAction(' . $post->id . ');" name="action_ck" value="'.$post->id.'">';
           }
      }

      $first_row = "";
      $first_row.= ucfirst($post->name).'<!--<div class="links">';
      if($retrieve_opp==1):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".')" class="text-success">View</a>|';
      endif;
      if($update_opp==1):
        $first_row.= '<a style="text-decoration:none" href="'.base_url().'add-opportunity/'.$post->id.'"   class="text-primary">Update</a>|';
      endif;
      if($create_quote==1 && $CountQt<1):
        $first_row.= '<a style="text-decoration:none" href="'.base_url().'add-quote?opp='.$post->id.'"onclick="quote('."'".$post->id."'".')" class="text-info">Create Quote</a>|';
      endif;
      if($delete_opp==1):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger">Delete</a>';
      endif;
      $first_row.= '</div>-->';
      $companydetail = "
    <div class='d-flex align-items-center'>
        <img src='".base_url('')."/application/views/assets/images/faces/4.jpg' alt='img'
            class='rounded-circle mr-2' style='width: 1.75rem; height: 1.75rem;'>
        <div>
            <span>".ucfirst($post->org_name)."</span><br>
            <i style='color:#bfc1c2;font-weight:500;'>".$post->email."</i>
        </div>
    </div>";
    $idopportunity =" 
    <span style='color: rgba(140, 80, 200, 1);
    font-weight: 700;'>".ucfirst($post->opportunity_id)."</span>"
    ;

      // $row[] = $companydetail;
       $row[] = '<a style="text-decoration:none" onclick="view(' . "'" . $post->id . "'" . ')">' . $companydetail . '</a>';
      $row[] = $first_row;
      
      $row[] = $idopportunity;
      // $row[] = $post->email;
      $row[] = $post->mobile;
      
      
    //   dd($post);
    // if($post->datetime!=)
    if($post->datetime!=null){
      $newDate = date("Y-m-d H:i:s", strtotime($post->datetime));

    }else{ $newDate = date("Y-m-d H:i:s", strtotime($post->currentdate));
     }
       // Format the date
        
        // Assuming `time_elapsed_string` is a custom function that returns a human-readable time elapsed string
    $timeElapsedString = time_elapsed_string($newDate);
    // dd($timeElapsedString);
    // Use the formatted date as the tooltip and display the time elapsed string
    $row[] = "<text style='font-size: 13px;' data-toggle='tooltip' data-container='body' title='".$newDate."' >".$timeElapsedString."</text>";
      if($dataAct=='actdata'){
          $row[] = $post->owner;
          $row[] = "₹ ".IND_money_format($post->initial_total);
      }
	  if($dataAct!='actdata'){
	  $action='<div class="row" style="font-size: 15px;">';
				if($retrieve_opp==1){
					$action.='<a style="text-decoration:none" href="javascript:void(0)"  onclick="view('."'".$post->id."'".')" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Opportunity Details" ></i></a>';
				}
				if($update_opp==1){
					$action.='<a style="text-decoration:none" href="'.base_url().'add-opportunity/'.$post->id.'" class="text-primary border-right">
					<i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Opportunity Details" ></i></a>';
				}
				if($retrieve_opp==1){
					$action.='<a style="text-decoration:none" href="'.base_url().'opportunities/view/'.$post->id.'" target="_blank" class="text-info border-right">
					<i class="far fa-file-pdf sub-icn-pi m-1" data-toggle="tooltip" data-container="body" title="View PDF" ></i></a>';
				}	
				
				if($create_quote==1 && $CountQt<1){
					$action.='<a style="text-decoration:none" href="'.base_url().'add-quote?opp='.$post->id.'"  class="text-info border-right">
					<i class="far fa-file-alt sub-icn-po m-1" data-toggle="tooltip" data-container="body" title="Create Quotation" ></i></a>';
				}		
				if($delete_opp==1){	
					$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')"  class="text-danger">
					<i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Opportunity" ></i></a>';
				}
				$action.='</div>';
           
	    $row[]=$action;
	  }
	  
	  
          $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Opportunity->count_all(),
      "recordsFiltered" => $this->Opportunity->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }

  
  public function create()
  {
	  
    $validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
    }else
    {
      if(!empty($this->input->post('lead_id')))
      {
        $lead_id = $this->input->post('lead_id');
        $status = "In Progress";
        $this->Lead->lead_status($lead_id,$status);
      }
	  $initial_total= str_replace(",", "",$this->input->post('initial_total'));
      $unit_price 	= str_replace(",", "",$this->input->post('unit_price'));
      $total 		= str_replace(",", "",$this->input->post('total'));
      $sub_total 	= str_replace(",", "",$this->input->post('sub_total'));
      $discount 	= str_replace(",", "",$this->input->post('discount'));
      
      $sub_opp_id = $this->input->post('sub_opp_id');
       
	  $stageName=$this->input->post('stage');
	  if($stageName==""){
		$stageName='Qualifying';  
	  }
      $data = array(
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'lead_id' 			=> $this->input->post('lead_id'),
        'owner' 			=> $this->input->post('owner'),
        'org_name' 			=> $this->input->post('org_name'),
		'org_id'			=> $this->input->post('org_id_act'),
		'cont_id'			=> $this->input->post('cnt_id_act'),
        'name' 				=> $this->input->post('name'),
        'contact_name' 		=> $this->input->post('contact_name'),
        'expclose_date' 	=> $this->input->post('expclose_date'),
        'pipeline' 			=> $this->input->post('pipeline'),
        'stage' 			=> $stageName,
        'lead_source' 		=> $this->input->post('lead_source'),
        'type' 				=> $this->input->post('type'),
        'probability' 		=> $this->input->post('probability'),
        'industry' 			=> $this->input->post('industry'),
        'employees' 		=> $this->input->post('employees'),
        'weighted_revenue'  => $this->input->post('weighted_revenue'),
        'email' 			=> $this->input->post('email'),
        'mobile' 			=> $this->input->post('mobile'),
        'lost_reason' 		=> $this->input->post('lost_reason'),
        'product_name' 		=> implode("<br>",$this->input->post('product_name')),
        'quantity' 			=> implode("<br>",$this->input->post('quantity')),
        'unit_price' 		=> implode("<br>",$unit_price),
        'total' 			=> implode("<br>",$total),
        //'percent' 			=> implode("<br>",$this->input->post('percent')),
        'pro_description'   => implode("<br>",$this->input->post('pro_description')),
        'initial_total' 	=> $initial_total,
        'discount' 			=> $discount,
        'sub_total' 		=> $sub_total,
        'total_percent' 	=> $this->input->post('total_percent'),
        'currentdate' 		=> date("Y.m.d H:i:s"),
        'sub_opp_id' 		=> $sub_opp_id,
        'track_status' 		=> 'opportunity'
      );
      $id 		= $this->Opportunity->create($data);
      
      if($id){
          if($sub_opp_id != "0"){
            $this->Opportunity->sub_opp_update_track_status($sub_opp_id);
    		  
    	  }
          
      }
      
      $updataId	= updateid($id,'opportunity','opportunity_id');
      $opp_data = array('opportunity_id' => $updataId, 'track_status' => 'opportunity');
      $this->Lead->update_lead_track_status(array('lead_id' => $this->input->post('lead_id')),$opp_data);
      $this->load->model('Notification_model');
      $data		= $this->Notification_model->addNotification('opportunity',$id);
      $saveDatatask=$this->input->post('saveDatatask');
	  add_customer_activity($id, $this->input->post('org_name'),$this->input->post('org_id_act'),$this->input->post('cnt_id_act'),$this->input->post('contact_name'),'customer_opportunity');
   if($saveDatatask=='1'){
       $this->AddTask($id);
   }
   
   
   ################# ADD MEETING ####################### 
   $addData=$this->input->post('saveDatamtng');
   if($addData=='1'){
       $this->addMeeting($id);
   }
   
    $saveDataCall=$this->input->post('saveDataCall');
    if($saveDataCall=='1'){
       $this->addCall($id);
    }  
	
	$workFlowStsAdmin	= check_workflow_status('Admin','Mail notification on opportunity created');
	$workFlowStsStsUser	= check_workflow_status('Opportunity','Mail notification to opportunity owner on opportunity created');
	$permissionSts		= check_permission_status('Receive mail on create opportunity','other');
	
	if($permissionSts==true && $workFlowStsStsUser==true){
			$messageBody='';
			$subjectLine="A new opportunity created by you - team365 | CRM";
			$messageBody.='<div class="f-fallback">
            <h1>Dear , '.ucwords($this->session->userdata('name')).'!</h1>';
            $messageBody.='<p>You just created a opportunity from team365 | CRM</p>';
    		$messageBody.='<p>Your opportunity detail are given bellow:-</p>';
			$messageBody.='<p>Opportunity Name : '.$this->input->post('subject').'</p>';
    		$messageBody.='<p>
			Customer Name : '.$this->input->post('org_name').'
			<br>
			Contact Name : '.$this->input->post('contact_name').'
			<br>
			Opportunity ID : '.$updataId.'
			</p></div>';
			sendMailWithTemp($this->session->userdata('email'),$messageBody,$subjectLine);
	    }  
		  
		 /*  SEND TO ADMIN  */
		if($workFlowStsAdmin==true){ 
		 $messagetoAdmin='';
		 $subjectAdmin="A new opportunity created - team365 | CRM";
		 $messagetoAdmin.='<div class="f-fallback">
            <h1>Dear , Admin!</h1>';
            $messagetoAdmin.='<p>A new opportunity "'.$this->input->post('subject').'", Created.</p>';
    		$messagetoAdmin.='<p>Opportunity detail:-</p>';
			$messagetoAdmin.='<p>Opportunity name : '.$this->input->post('subject').'</p>';
    		$messagetoAdmin.='<p>
			Opportunity created by  : '.$this->session->userdata('name').'
			<br>
			Opportunity ID : '.$updataId.'
			Customer Name : '.$this->input->post('org_name').'
			<br>
			Contact Name : '.$this->input->post('contact_name').'
			<br>
			Product : '.implode(", ",$this->input->post('product_name')).'
			</p>';
    		$messagetoAdmin.='</div>';
			sendMailWithTemp($this->session->userdata('company_email'),$messagetoAdmin,$subjectAdmin);  
		} 
	
      echo json_encode(array("status" => TRUE));
    }
  }
  
  public function getbyId($id)
  {
    $data = $this->Opportunity->get_by_id($id);
    echo json_encode($data);
  }
  public function update()
  {
    $validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
    }
    else
    {
	  $initial_total = str_replace(",", "",$this->input->post('initial_total'));
      $unit_price = str_replace(",", "",$this->input->post('unit_price'));
      $total = str_replace(",", "",$this->input->post('total'));
      $sub_total = str_replace(",", "",$this->input->post('sub_total'));
      $discount = str_replace(",", "",$this->input->post('discount'));
	  $stageName	= $this->input->post('stage');
	  if($stageName==""){
		$stageName='Qualifying';  
	  }
		
      $data = array(
        'org_name'      => $this->input->post('org_name'),
        'name'          => $this->input->post('name'),
        'contact_name'  => $this->input->post('contact_name'),
        'expclose_date' => $this->input->post('expclose_date'),
        'pipeline'      => $this->input->post('pipeline'),
        'stage'         => $stageName,
        'lead_source'   => $this->input->post('lead_source'),
        'type'          => $this->input->post('type'),
		'org_id'			=> $this->input->post('org_id_act'),
		'cont_id'			=> $this->input->post('cnt_id_act'),
        'probability'   => $this->input->post('probability'),
        'industry'      => $this->input->post('industry'),
        'employees'     => $this->input->post('employees'),
        'weighted_revenue' => $this->input->post('weighted_revenue'),
        'email'         => $this->input->post('email'),
        'mobile'        => $this->input->post('mobile'),
        'lost_reason'   => $this->input->post('lost_reason'),
        'product_name'  => implode("<br>",$this->input->post('product_name')),
        'quantity'      => implode("<br>",$this->input->post('quantity')),
        'unit_price'    => implode("<br>",$unit_price),
        'total'         => implode("<br>",$total),
        //'percent'       => implode("<br>",$this->input->post('percent')),
        'pro_description'   => implode("<br>",$this->input->post('pro_description')),
        'initial_total' => $initial_total,
        'discount'      => $discount,
        'sub_total'     => $sub_total,
        'total_percent' => $this->input->post('total_percent'),
      );
      $this->Opportunity->update(array('id' => $this->input->post('id'),'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
      echo json_encode(array("status" => TRUE));
    }
  }
  
  
  public function delete($id)
  {
    $this->Opportunity->delete($id);
	$this->load->model('Activity_model','Activity');
	$this->Activity->delete_act($id,'customer_opportunity');
    echo json_encode(array("status" => TRUE));
  }
  
  public function sub_opp_delete($id)
  {
    $this->Opportunity->delete_sub_opp($id);

    echo json_encode(array("status" => TRUE));
  }
  
  
  
  public function delete_bulk()
  {
    if($this->input->post('checkbox_value'))
    {
      $id = $this->input->post('checkbox_value');
      for($count = 0; $count < count($id); $count++)
      {
        $this->Opportunity->delete_bulk($id[$count]);
      }
    }
  }
  
  
   public function view()
  {
    $this->load->library('pdf');
    if($this->uri->segment(3)){
          $download = $this->uri->segment(4);
          $id 		= $this->uri->segment(3);
          $html_content = '';
          $html_content .= $this->Opportunity->view($id, $download);
		  
		  //print_r($html_content); exit;
		  
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
    	  if(isset($download) && $download=='dn'){
    		$this->dompdf->stream("QUOTATION_".$id.".pdf", array("Attachment"=>1));  
    	  }else{
    		$this->dompdf->stream("QUOTATION_".$id.".pdf", array("Attachment"=>0));  
    	  }
    }
  }
  
  
  
  
  
  public function getContactVal()
  {
    $postData = $this->input->post();
    $data = $this->Opportunity->getContactVals($postData);
    echo json_encode($data);
  }
  public function check_validation()
  {
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    $this->form_validation->set_rules('name', 'Opportunity Name', 'required|trim');
    $this->form_validation->set_rules('org_name', 'Organization Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
    $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
    $this->form_validation->set_rules('contact_name', 'Contact Name', 'required|trim');
   // $this->form_validation->set_rules('type', 'Type', 'required|trim');
    $this->form_validation->set_rules('lead_source', 'Lead Source', 'required|trim');
    $this->form_validation->set_rules('industry', 'Industry', 'required|trim');
	
    $this->form_validation->set_rules('product_name[]', 'Product', 'required|trim');
    $this->form_validation->set_rules('quantity[]', 'Product Quantity', 'required|trim');
    $this->form_validation->set_rules('unit_price[]', 'Per Product Price', 'required|trim');
    $this->form_validation->set_rules('total[]', 'Total Price', 'required|trim');
    $this->form_validation->set_rules('initial_total', 'Initial Total', 'required|trim');
    $this->form_validation->set_rules('discount', 'Discount', 'required|trim');
    $this->form_validation->set_rules('sub_total', 'Sub Total', 'required|trim');
	
	
    $this->form_validation->set_message('required', '%s is required');
    $this->form_validation->set_message('valid_email', '%s is not valid');
    $this->form_validation->set_message('regex_match','%s is invalid');
    if ($this->form_validation->run() == FALSE)
    {
      return json_encode(array('st'=>202, 'org_name'=> form_error('org_name'), 'name'=> form_error('name'),'email'=> form_error('email'), 'mobile'=> form_error('mobile'), 'contact_name'=> form_error('contact_name'), 'type'=> form_error('type'), 'lead_source' => form_error('lead_source'), 'industry' => form_error('industry') , 'product_name' => form_error('product_name[]'), 'quantity' => form_error('quantity[]'), 'unit_price' => form_error('unit_price[]'), 'total' => form_error('total[]'), 'initial_total' => form_error('initial_total'), 'discount' => form_error('discount'), 'sub_total' => form_error('sub_total')  ));
    }else
    {
      return 200;
    }
  }
  public function getnotifyfilter()
  {
    $date = $this->input->post('notify_date');
    $data = $this->Opportunity->get_pending_opportunity($date);
    echo json_encode($data);
  }


   public function getContactValAdd(){
    $postData = $this->input->post();
    $data = $this->Opportunity->getContactValsDeatil($postData);
    echo json_encode($data);
  }
  
  
  ################################
  #         Add Task             #
  ################################
  private function AddTask($id){
       if($this->input->post('taskUser')){
           $explodeData=implode("<br>",$this->input->post('taskUser'));
       }else{
           $explodeData='';
       }
       
      $dataArrTask=array(
            'sess_eml' 			=> $this->session->userdata('email'),
            'session_company' 	=> $this->session->userdata('company_name'),
            'session_comp_email'=> $this->session->userdata('company_email'),
            'opportunity_id'    => $id,
            'task_owner'        => $this->input->post('taskOwner'),
            'task_subject'      => $this->input->post('taskSubject'),
            'task_from_date'    => $this->input->post('taskFromDate'),
            'task_due_date'     => $this->input->post('taskDueDate'),
            'task_priority'     => $this->input->post('taskPriority'),
            'asign_to'          => $explodeData,
            'remarks'           => $this->input->post('taskRemarks'),
            'status'            => $this->input->post('taskStatus'),
            'ip'                => $this->input->ip_address(),
            'currentdate'       => date('Y-m-d'),
            'delete_status'     => 1
          );
          
         if($this->input->post('taskReminder')){ 
           $dataArrTask['task_reminder']=$this->input->post('taskReminder');
         }
         if($this->input->post('taskRepeat')){ 
           $dataArrTask['task_repeat']=$this->input->post('taskRepeat');
         }
      
    $dataRow=$this->Opportunity->addTask($dataArrTask);
   if($dataRow){
    $userEmail=$this->input->post('taskUser');
	if($userEmail){
    for($i=0; $i<count($userEmail); $i++){
        $messageBody='
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
                   .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:20px;}
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
                                <a href="https://team365.io/" class="f-fallback email-masthead_name">
                                <img src="https://team365.io/assets/img/new-logo-team.png"></a>
                              </a>
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
                                        <h1>Hi, '.$userEmail[$i].'!</h1>
                                        <p>The folllowing task has been assigned to you by '.$this->input->post('taskOwner').':</p>
                                        <!-- Action -->
                                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                          <tr>
                                            <td align="center">
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr>
                                                  <td align="center">
                                                    <a href="https://allegient.team365.io/task" class="f-fallback button" target="_blank">Open Task..</a>
                                                  </td>
                                                </tr>
                                              </table>
                                            </td>
                                          </tr>
                                        </table>
                                        <p>Task information:</p>
                                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                          <tr>
                                            <td class="attributes_content">
                                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									  <strong>Task:</strong> '.$this->input->post('taskSubject').'
                									</span>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									  <strong>Task Priority:</strong> '.$this->input->post('taskPriority').'
                									</span>
                                                  </td>
                                                </tr>
                                                
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									  <strong>From Date:</strong> '.$this->input->post('taskFromDate').'
                									</span>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									  <strong>End Date:</strong> '.$this->input->post('taskDueDate').'
                									</span>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									  <strong>Description:</strong> '.$this->input->post('taskRemarks').'
                									</span>
                                                  </td>
                                                </tr>
                                              </table>
                                            </td>
                                          </tr>
                                        </table>
                                      </div>
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
                                      <p class="f-fallback sub align-center">&copy; '.date("Y").' team365. All rights reserved</p>
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
                $subject='A new task assigned to you';           
                $this->email_lib->send_email($userEmail[$i],$subject,$messageBody);
   
    }
	}
}     
  }
  
  
  
  private function addMeeting($id){
       
  
  $addData=$this->input->post('saveDatamtng');
  $saveDatamtngid=$this->input->post('saveDatamtngid');
  
    if($this->input->post('mtngParticepants')) { 
           $mtngParticepants= implode("<br>",$this->input->post('mtngParticepants'));
    }
  
   if($addData=='1'){
        $dataArrMtng=array(
            'sess_eml' 			=> $this->session->userdata('email'),
            'session_company' 	=> $this->session->userdata('company_name'),
            'session_comp_email'=> $this->session->userdata('company_email'),
            'opportunity_id'    => $id,
            'host_name'         => $this->input->post('mtngHost'),
            'meeting_title'     => $this->input->post('mtngTitle'),
            'location'          => $this->input->post('mtngLocation'),
            'from_date'         => $this->input->post('mtngFromDate'),
            'from_time'         => $this->input->post('mtngFromTime'),
            'to_date'           => $this->input->post('mtngToDate'),
            'to_time'           => $this->input->post('mtngToTime'),
            'reminder'          => $this->input->post('mtngReminder'),
            'remarks'           => $this->input->post('taskRemarks'),
            'status'            => $this->input->post('taskStatus'),
             'ip'                => $this->input->ip_address(),
            'currentdate'       => date('Y-m-d'),
            'delete_status'     => 1
          );
        
            if($this->input->post('mtngAllday')) { 
               $dataArrMtng['all_day'] = $this->input->post('mtngAllday');
            }
            
            if($this->input->post('mtngParticepants')) { 
               $dataArrMtng['particepants'] = $mtngParticepants;
            }
          
            $dataRow= $this->Opportunity->addMeeting($dataArrMtng);
   if($dataRow){

     $userEmail=$this->input->post('mtngParticepants');
    for($i=0; $i<count($userEmail); $i++){
        $messageBody='
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
                   .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:20px;}
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
                                <a href="https://team365.io/" class="f-fallback email-masthead_name">
                                <img src="https://team365.io/assets/img/new-logo-team.png"></a>
                              </a>
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
                                        <h1>Hi, '.$userEmail[$i].'!</h1>
                                        <p>I would like to invite you to a meeting at '.$this->input->post('mtngLocation').'</p>
                                        
                                        <p>
                                        The meeting will take place on the '.$this->input->post('mtngFromDate').', starting at '.$this->input->post('mtngFromTime').' 
                                        and finishing at '.$this->input->post('mtngToDate').'  '.$this->input->post('mtngToTime').'. 
                                        Could you please confirm whether you will be able to participate?
                                        </p>
                                        <!-- Action -->
                                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                          <tr>
                                            <td align="center">
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr>
                                                  <td align="center">
                                                    <a href="https://allegient.team365.io/meeting" class="f-fallback button" target="_blank">Read More..</a>
                                                  </td>
                                                </tr>
                                              </table>
                                            </td>
                                          </tr>
                                        </table>
                                        <p>Task information:</p>
                                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                          <tr>
                                            <td class="attributes_content">
                                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									  <strong>Meeting:</strong> '.$this->input->post('mtngTitle').'
                									</span>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									  <strong>Host By:</strong> '.$this->input->post('mtngHost').'
                									</span>
                                                  </td>
                                                </tr>
                                                
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									 '.$this->input->post('taskRemarks').'
                									</span>
                                                  </td>
                                                </tr>
                                               
                                              </table>
                                            </td>
                                          </tr>
                                        </table>
                                      </div>
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
                                      <p class="f-fallback sub align-center">&copy; '.date("Y").' team365. All rights reserved</p>
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
                $subject='Get ready for new meeting - '.$this->input->post('mtngTitle');           
                $this->email_lib->send_email($userEmail[$i],$subject,$messageBody);
            }
          }
        }  
    }
  
  
  
  private function addCall($id){
       $dataArrMtng=array(
            'sess_eml' 			=> $this->session->userdata('email'),
            'session_company' 	=> $this->session->userdata('company_name'),
            'session_comp_email'=> $this->session->userdata('company_email'),
            'opportunity_id'    => $id,
            'contact_name'     => $this->input->post('callContactName'),
            'call_subject'     => $this->input->post('callSubject'),
            'call_purpose'     => $this->input->post('callPurpose'),
            'related_to'       => $this->input->post('callRelated'),
            'call_type'        => $this->input->post('callType'),
            'call_detail'      => $this->input->post('callDeatils'),
            'call_description' => $this->input->post('callDescription'),
            'remarks'          => '',
            'currentdate'      => date('Y-m-d'),
            'delete_status'    => 1,
            'status'           => 1,
            'ip'               => $this->input->ip_address()
          );
          
    $this->Opportunity->addCall($dataArrMtng);
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
			$mass_data = $this->Opportunity->mass_save($mass_id, $dataArry);
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
  
  
  
//please write code above this
}
?>
