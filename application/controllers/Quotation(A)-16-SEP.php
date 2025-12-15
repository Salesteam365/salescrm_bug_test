<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Quotation extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Quotation_model','Quotation');
    $this->load->model('Lead_model','Lead');
    $this->load->model('Opportunity_model','Opportunity');
    $this->load->model('Salesorders_model','Salesorders');
	$this->load->model('Performainvoice_model','Performainvoice');
    $this->load->library('email_lib');
    
  }
  public function index()
  {
    if(!empty($this->session->userdata('email')))
    {
        if(checkModuleForContr('Create Quotation')<1){
        	    redirect('home');
        	    exit;
        }
		if(check_permission_status('Quotations','retrieve_u')==true){	
        $data2=array();
		$leadStatus=array('Negotiation','On Hold','Draft','Confirmed','Closed Lost','Closed Won','Delivered');
        for($i=0; $i<count($leadStatus); $i++){
            $ind=str_replace(' ','',$leadStatus[$i]);
            $ind=str_replace('-','',$ind);
            $data2[$ind]=$this->Quotation->getTotalPrice($leadStatus[$i]); 
        }
		$data['user']  		= $this->Login_model->getusername();
		$data['admin'] 		= $this->Login_model->getadminname();
		$data['countQuote'] = $this->Quotation->count_all();
        $data['price']=$data2;
        $this->load->view('sales/quotation',$data);
		}else{
			
		}
    }else{
      redirect('login');
    }
  }
  
  
  public function add_quote(){
	if(check_permission_status('Quotations','create_u')==true || check_permission_status('Quotations','update_u')==true){  
	$id=$this->uri->segment(2);  
	   if(isset($_GET['opp']) && $_GET['opp']!=""){
		   $data['record'] = $this->Opportunity->get_data_for_update($_GET['opp']);
		   $data['action']=array('data'=>'add','from'=>'opportunity');
		   
		   $this->load->model('Organization_model','Organization');
		   $data['org_dtls'] = $this->Organization->get_by_id_view($data['record']['org_id']);
		   
	   }else if(isset($id) && $id!=""){
		   $data['record'] = $this->Quotation->get_data_for_update($id);
		   $data['action']=array('data'=>'update','from'=>'quotation');
	   }else{
		   $data['action']=array('data'=>'add','from'=>'direct');
	   }
	$data['user'] 		= $this->Login_model->getusername();
	$data['gstPer']     = $this->Quotation->get_gst();
	$data['countQuote'] = $this->Quotation->count_all();
	$this->load->view('sales/add-quotation',$data);   
	}
  }
  
  
  
   public function returngrid($list,$leadStatus,$count,$dataCount){
    $ind=str_replace(' ','',$leadStatus);
    $ind=str_replace('-','',$ind);
	   ?>
      <div class="lists" data-status="<?=$leadStatus;?>" data-textid="<?=$ind;?>"  id="list<?=$count;?>">
	  
			<?php if(isset($dataCount[$leadStatus])){
				$r=1; 
				
			$delete_quote	=0;
			$update_quote	=0;
			$retrieve_quote	=0;
			$create_so		=0;  
			$create_pi		=0;  
			if(check_permission_status('Quotations','delete_u')==true){
				$delete_quote=1;
			}
			if(check_permission_status('Salesorders','create_u')==true){
				$create_so=1;
			}
			if(check_permission_status('Quotations','retrieve_u')==true){
				$retrieve_quote=1;
			}
			if(check_permission_status('Quotations','update_u')==true){
				$update_quote=1;
			}
			if(check_permission_status('Proforma Invoice','create_u')==true){
				$create_pi=1;
			}
				
				
				foreach($list as $row){ 
				if($row['quote_stage']==$leadStatus){
					
                    $QuotCount = $this->Salesorders->check_quot_exist($row['quote_id']);
                    $PiCount   = $this->Quotation->check_pi_exist($row['quote_id']);
				?>
				<div id='item<?=$row['id'];?>' data-id="<?=$row['id'];?>" data-putid="<?=$ind;?>" data-price="<?=$row['initial_total'];?>" class="col-lg-12 mt-2 divli">
				<div class="leadname"><?=$row['subject'];?></div>
				<div style="font-size: 13px;"><i class="fas fa-university" style="margin-right: 4px;"></i><?=$row['org_name'];?></div>
				<div style="font-size: 12px;"><i class="fas fa-rupee-sign" style="margin-right: 4px;"></i><?=IND_money_format($row['initial_total']);?>
				</div>
				<div style="font-size: 12px;"><i class="far fa-user" style="margin-right: 4px;"></i><?=$row['owner'];?></div>
				<div style="font-size: 12px;"><i class="far fa-calendar-alt" style="margin-right: 5px;"></i>
    				<?php
    				$date=date_create($row['currentdate']);
    				echo date_format($date,"d M Y");
    				?>
				</div>
				<label>
				 <?php 
				 if($create_so==1 && $QuotCount<1):
                    $firstRow= '<a class="lbla"  href="javascript:void(0)" onclick="salesorder('."'".$row['id']."'".')" class="text-info">+ SO</a>';
                    echo $firstRow;
                  endif; ?>
                  <?php 
				 if($create_pi==1 && $PiCount<1):
                    $firstPiow= '<a class="lbla" href="'.base_url("proforma_invoice/create_newProforma?pg=quote&qt=".$row['quote_id']."").'"  class="text-info">+ PI</a>';
                     echo $firstPiow;
                 endif;
                   ?>
					<span style="float: right;">
				<?php if($update_quote==1){ ?>	    
					<i class="far fa-edit" style="margin-right: 10px; cursor:pointer; color:#111;" onclick="update('<?=$row['id'];?>')"></i> 
				<?php } 
				if($retrieve_quote==1){ ?>	
				    <a style="text-decoration:none;" href="<?=base_url().'index.php/quotation/view_pi_qt/'.$row['id'];?>">
				        <i class="far fa-eye"  style="margin-right: 10px; color:#111;"></i>
				    </a>
				<?php } 
				if($delete_quote==1){ ?>	
					<i class="far fa-trash-alt" style="cursor:pointer; color:#111;" onclick="delete_entry('<?=$row['id'];?>')" ></i>
				<?php } ?>	
					</span>
				 </label>
				</div>
			<?php $r++; } } }?>
			
		</div>
  <?php }
  
  
  
   public function gridview(){
	  $per_page=10;
	  $page = $this->input->post('page');
      $start = ($page - 1) * $per_page;
	  $searchDate	= $this->input->post('searchDate');
	  $search		= $this->input->post('search');
	 
	  $list = $this->Quotation->get_all_quot($searchDate,$search,$per_page, $start);
	   $sort = array();
		foreach($list as $k=>$v) {
		   $sort['quote_stage'][$k] = $v['quote_stage'];
		}
		
		if(count($sort)){
		array_multisort($sort['quote_stage'], SORT_ASC,$list);
		}
		
		$dataCount= array_count_values(array_column($list, 'quote_stage')); 
	    $leadStatus=array('Negotiation','On Hold','Draft','Confirmed','Closed Lost','Closed Won','Delivered');
        $m=1;
        for($i=0; $i<count($leadStatus); $i++){
    		$this->returngrid($list,$leadStatus[$i],$m,$dataCount);
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
				var newPrice=$("#"+textid).val();
				price=parseFloat(price);
				newPrice=parseFloat(newPrice);
				finalPrice=(price+newPrice);
				$("#"+textid).val(finalPrice);
			    numberRoller('txt'+textid,finalPrice);
				 $.ajax({
					url : "<?= site_url('Quotation/update_status');?>",
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
	$searchDate	= $_GET['searchDate'];
	if(isset($_GET['search'])){
		$search		= $_GET['search'];
	}else{
		$search='';
	}
	  
  $AllData   = $this->Quotation->get_all_count($searchDate,$search);
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
	  $dataArr=array('quote_stage'=>$status);
	  $data = $this->Quotation->update_status($dataArr,$leadid);
    echo json_encode($data);
	  
  }
  
  
  public function ajax_list()
  {
    $list = $this->Quotation->get_datatables();
    $data = array();
    $no = $_POST['start'];
	
	$delete_quote	=0;
	$update_quote	=0;
	$retrieve_quote	=0;
	$create_so		=0;  
	$create_pi		=0;  
	if(check_permission_status('Quotations','delete_u')==true){
		$delete_quote=1;
	}
	if(check_permission_status('Salesorders','create_u')==true){
		$create_so=1;
	}
	if(check_permission_status('Quotations','retrieve_u')==true){
		$retrieve_quote=1;
	}
	if(check_permission_status('Quotations','update_u')==true){
		$update_quote=1;
	}
	if(check_permission_status('Proforma Invoice','create_u')==true){
		$create_pi=1;
	}

    foreach ($list as $post)
    {
      $no++;
      $row = array();
	  
	  $QuotCount = $this->Salesorders->check_quot_exist($post->quote_id);
	  $PiCount = $this->Quotation->check_pi_exist($post->quote_id);
		
      // APPEND HTML FOR ACTION
      if($delete_quote==1) { 
        $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
      }
      $first_row = "";
      $first_row.= ucfirst($post->subject).'<!--<div class="links">';
      if($retrieve_quote==1):
        $first_row.= ' <a style="text-decoration:none" href="'.base_url().'quotation/view_pi_qt/'.$post->id.'" class="text-success">View</a>|';
      endif;
      if($update_quote==1):
        $first_row.= '<a style="text-decoration:none" href="'.base_url().'add-quote/'.$post->id.'" class="text-primary">Update</a>|';
      endif;
      if($create_so==1 && $QuotCount<1):
        $first_row.= '<a style="text-decoration:none" href="'.base_url().'add-salesorder?qt='.$post->id.'" class="text-info">Create Salesorder</a>|';
      endif;
	  if($create_pi==1 && $PiCount<1):
        $first_row.= '<a style="text-decoration:none" href="'.base_url().'proforma_invoice/create_newProforma?pg=quotation&qt='.$post->quote_id.'"  class="text-info">Create PI</a>|';
      endif;
      if($delete_quote==1):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger">Delete</a>';
      endif;
      $first_row.= '</div>-->';
      $row[] = $first_row;
      $row[] = ucfirst($post->org_name);
      $row[] = $post->quote_id;
      $row[] = ucfirst($post->owner);
	  
	  $newDate = date("d M Y", strtotime($post->datetime));
      $row[] = "<text style='font-size: 13px;' data-toggle='tooltip' data-container='body' title='".$newDate."' >".time_elapsed_string($post->datetime)."</text>";
	   
	 $action='<div class="row" style="font-size: 15px;">';
			if($retrieve_quote==1){
				$action.='<a style="text-decoration:none" href="'.base_url().'quotation/view_pi_qt/'.$post->id.'" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Quotation Details" ></i></a>';
			}
			if($update_quote==1){
				$action.='<a style="text-decoration:none" href="'.base_url().'add-quote/'.$post->id.'" class="text-primary border-right">
					<i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Quotation Details" ></i></a>';
			}	
			if($create_so==1 && $QuotCount<1){
				$action.='<a style="text-decoration:none" href="'.base_url().'add-salesorder?qt='.$post->id.'"  class="text-info border-right">
					<i class="fas fa-chart-line text-info m-1" data-toggle="tooltip" data-container="body" title="Create Salesorder" ></i></a>';
			}
			if($create_pi==1 && $PiCount<1){		
				$action.='<a style="text-decoration:none" href="'.base_url().'proforma_invoice/create_newProforma?pg=quotation&qt='.$post->quote_id.'"  class="text-info border-right">
					<i class="fas fa-file-invoice-dollar sub-icn-pi m-1"  data-toggle="tooltip" data-container="body" title="Create PI" ></i></a>';
			}
			if($delete_quote==1){	
				$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')"  class="text-danger">
					<i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Quotation" ></i></a>';
			}
				$action.='</div>';
           
	    $row[]=$action;
	  
	   
	   
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Quotation->count_all(),
      "recordsFiltered" => $this->Quotation->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  public function autocomplete_oppid()
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    if (isset($_GET['term'])) {
      $result = $this->Quotation->get_opp_id($_GET['term'],$sess_eml,$session_company,$session_comp_email);
      if (count($result) > 0)
      {
        foreach ($result as $row)
        $arr_result[] = array(
          'label' => $row->opportunity_id,
          );
        echo json_encode($arr_result);
      }
      else
      {
        $arr_result[] = array(
          'label' => "No Opportunity Found",
        );
        echo json_encode($arr_result);
      }
    }
  }
  public function get_opp_details()
  {
    $opportunity_id = $this->input->post();
	$CountQt = $this->Quotation->check_quote_exist($opportunity_id['opportunity_id']);
	if($CountQt<1){
		$data = $this->Quotation->getOppValue($opportunity_id);
		echo json_encode($data);
	}else{
		$arr_result[] = array(
          'error_msg' => '<i class="fas fa-info-circle" style="color:red;"></i>&nbsp;&nbsp;Opportunity Id Exists Already.'
        );
        echo json_encode($arr_result);
	}
  }
  public function create()
  {
    $validation = $this->check_validation('create');
    if($validation!=200)
    {
      echo $validation;die;
    }
    else
    {
		//for reversal add
		if($this->input->post('opportunity_id')=='' || $this->input->post('opportunity_id')==null){	
			$opportunity_id = create_opportunity($_POST); //call function from helper
		}else{
			$opportunity_id = $this->input->post('opportunity_id');			  
		}
		
		$initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
        $unit_price 	= str_replace(",", "",$this->input->post('unit_price'));
        $total 			= str_replace(",", "",$this->input->post('total'));
        $after_discount = str_replace(",", "",$this->input->post('after_discount'));
        $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
        $overallDiscount= str_replace(",", "",$this->input->post('overallDiscount'));
        $discountType	= str_replace(",", "",$this->input->post('discountType'));
		
		if($this->input->post('igst')!=""){
			$igst=implode("<br>", $this->input->post('igst'));
		}else{
			$igst='';
		}
		if($this->input->post('cgst')!=""){
			$cgst=implode("<br>", $this->input->post('cgst'));
		}else{
			$cgst='';
		}
		if($this->input->post('sgst')!=""){
			$sgst=implode("<br>", $this->input->post('sgst'));
		}else{
			$sgst='';
		}
		
		if($this->input->post('terms_condition')){
			$terms_condition=implode("<br>",$this->input->post('terms_condition'));
		}else{
			$terms_condition='';
		}
		if($this->input->post('extra_charge')!=""){
			$extra_charge=implode("<br>", $this->input->post('extra_charge'));
		}else{ $extra_charge=''; }
		if($this->input->post('extra_chargevalue')!=""){
			$extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
		}else{ $extra_chargevalue=''; }
		
		$carrier=$this->input->post('carrier');
		if($carrier=='other'){
			$carrier=$this->input->post('other_courier_name');
		}
		
		
     $data = array(
                    'sess_eml' => $this->session->userdata('email'),
                    'session_company' => $this->session->userdata('company_name'),
                    'session_comp_email' => $this->session->userdata('company_email'),
                    'opportunity_id' => $opportunity_id,
                    'owner' => $this->input->post('owner'),
                    'org_name' => $this->input->post('org_name'),
                    'org_id' => $this->input->post('org_id_act'),
                    'cont_id' => $this->input->post('cnt_id_act'),
                    'subject' => $this->input->post('subject'),
                    'contact_name' => $this->input->post('contact_name'),
                    'opp_name' => $this->input->post('opp_name'),
                    'quote_stage' => $this->input->post('quote_stage'),
                    'valid_until' => $this->input->post('valid_until'),
                    'courier_docket_no' => $this->input->post('courier_docket_no'),
                    'carrier' => $carrier,
                    'email' => $this->input->post('email'),
                    'billing_country' => $this->input->post('billing_country'),
                    'billing_state' => $this->input->post('billing_state'),
                    'billing_city' => $this->input->post('billing_city'),
                    'billing_zipcode' => $this->input->post('billing_zipcode'),
                    'billing_address' => $this->input->post('billing_address'),
                    'shipping_country' => $this->input->post('shipping_country'),
                    'shipping_state' => $this->input->post('shipping_state'),
                    'shipping_city' => $this->input->post('shipping_city'),
                    'shipping_zipcode' => $this->input->post('shipping_zipcode'),
                    'shipping_address' => $this->input->post('shipping_address'),
                    'product_name' => implode("<br>", $this->input->post('product_name')),
                    'quote_item_type' => implode("<br>", $this->input->post('quote_item_type')),
                    'hsn_sac' => implode("<br>", $this->input->post('hsn_sac')),
                    'sku' => implode("<br>", $this->input->post('sku')),
                    'gst' => implode("<br>", $this->input->post('gst')),
                    'quantity' => implode("<br>", $this->input->post('quantity')),
                    'unit_price' => implode("<br>", $unit_price),
                    'total' => implode("<br>", $total),
                    'pro_description' => implode("<br>", $this->input->post('pro_description')),
                    'initial_total' => $initial_total,
                    //'discount' => str_replace(",", "",$this->input->post('discount')),
                    'discount_type' => $discountType,
                    'overall_discount' => $overallDiscount,
                    'after_discount' => $after_discount,
                    'type' => $this->input->post('type'),
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
                    'sub_totalq' => $sub_total,
                    'total_percent' => $this->input->post('total_percent'),
                    'terms_condition' => $terms_condition,
                    'currentdate' => $this->input->post('quotationDate'),
                );
      $id = $this->Quotation->create($data);
      $quote_id = updateid($id,'quote','quote_id');
      $quote_data = array( 'track_status' => 'quote');
      $this->Lead->update_lead_track_status(array('opportunity_id' => $opportunity_id),$quote_data);
	  $quote_data['stage'] = 'Proposal';
      $this->Opportunity->update_opp_track_status(array('opportunity_id' => $opportunity_id),$quote_data);
      $this->load->model('Notification_model');
	  $data=$this->Notification_model->addNotification('quotation',$id);
	  
	  add_customer_activity($id, $this->input->post('org_name'),$this->input->post('org_id_act'),$this->input->post('cnt_id_act'),$this->input->post('contact_name'),'customer_quotation');
	  
	  if($id){
	    /*  
	    $workFlowStsAdmin	= check_workflow_status('Admin','Mail notification on quotation created');
	    $workFlowStsCusto	= check_workflow_status('Customer','Mail notification on quotation created');
		$workFlowStsStsUser	= check_workflow_status('Quotation','Mail notification to quotation owner on quotation created');
		$permissionSts		= check_permission_status('Receive mail on create quotation','other'); 
		  */
		/*if($permissionSts==true && $workFlowStsStsUser==true){
			$messageBody='';
			$subjectLine="A new quotation created by you - team365 | CRM";
			$messageBody.='<div class="f-fallback">
            <h1>Dear , '.ucwords($this->session->userdata('name')).'!</h1>';
            $messageBody.='<p>You just created a quotation from team365 | CRM</p>';
    		$messageBody.='<p>Your quotation detail are given bellow:-</p>';
			$messageBody.='<p>Quotation Name : '.$this->input->post('subject').'</p>';
    		$messageBody.='<p>
			Customer Name : '.$this->input->post('org_name').'
			<br>
			Contact Name : '.$this->input->post('contact_name').'
			<br>
			Quotation ID : '.$quote_id.'
			</p></div>';
			sendMailWithTemp($this->session->userdata('email'),$messageBody,$subjectLine);
	    }  */
		  
		  
		 /*  SEND TO CUSTOMER  */
		/*if($workFlowStsCusto==true){ 
		 $messagetoAdmin='';
		 $subjectAdmin="Acknowledgement of receipt of purchase order";
		 $messagetoAdmin.='<div class="f-fallback">
            <h1>Dear Mr./Mrs. '.ucwords($this->input->post('contact_name')).' Purchasing Manager ,</h1>';
            $messagetoAdmin.='<p>We thank you for your order.</p>';
    		$messagetoAdmin.='<p>Quotation detail:-</p>';
			$messagetoAdmin.='<p>Quotation name : '.$this->input->post('subject').'</p>';
    		$messagetoAdmin.='<p>
			Quotation created by  : '.$this->session->userdata('name').'
			<br>
			Quotation ID : '.$quote_id.'
			Customer Name : '.$this->input->post('org_name').'
			<br>
			Contact Name : '.$this->input->post('contact_name').'
			<br>
			Product : '.implode(", ",$this->input->post('product_name')).'
			</p>';
    		$messagetoAdmin.='</div>';
			sendMailWithTemp($this->input->post('email'),$messagetoAdmin,$subjectAdmin);  
		}   */
		  
		  
		  
		 /*  SEND TO ADMIN  */
		/*if($workFlowStsAdmin==true){ 
		 $messagetoAdmin='';
		 $subjectAdmin="A new quotation created - team365 | CRM";
		 $messagetoAdmin.='<div class="f-fallback">
            <h1>Dear , Admin!</h1>';
            $messagetoAdmin.='<p>A new quotation "'.$this->input->post('subject').'", Created.</p>';
    		$messagetoAdmin.='<p>Quotation detail:-</p>';
			$messagetoAdmin.='<p>Quotation name : '.$this->input->post('subject').'</p>';
    		$messagetoAdmin.='<p>
			Quotation created by  : '.$this->session->userdata('name').'
			<br>
			Quotation ID : '.$quote_id.'
			Customer Name : '.$this->input->post('org_name').'
			<br>
			Contact Name : '.$this->input->post('contact_name').'
			<br>
			Product : '.implode(", ",$this->input->post('product_name')).'
			</p>';
    		$messagetoAdmin.='</div>';
			sendMailWithTemp($this->session->userdata('company_email'),$messagetoAdmin,$subjectAdmin);  
		} 
	*/
		
		echo json_encode(array("status" => TRUE,'id'=>$id));
	  }else{
		echo json_encode(array("st" => FALSE));  
	  }
    }
  }
  
  public function getbyId($id)
  {
    $data = $this->Quotation->get_by_id($id);
    echo json_encode($data);
  }
  public function update()
  {
    $validation = $this->check_validation('update');
    if($validation!=200)
    {
      echo $validation;die;
    }
    else
    {
		$initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
        $unit_price 	= str_replace(",", "",$this->input->post('unit_price'));
        $total 			= str_replace(",", "",$this->input->post('total'));
        $after_discount = str_replace(",", "",$this->input->post('after_discount'));
        $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
		$overallDiscount= str_replace(",", "",$this->input->post('overallDiscount'));
        $discountType	= str_replace(",", "",$this->input->post('discountType'));
		if($this->input->post('terms_condition')){
			$terms_condition=implode("<br>",$this->input->post('terms_condition'));
		}else{ $terms_condition=''; }
		if($this->input->post('igst')!=""){
			$igst=implode("<br>", $this->input->post('igst'));
		}else{ $igst=''; }
		if($this->input->post('cgst')!=""){
			$cgst=implode("<br>", $this->input->post('cgst'));
		}else{ $cgst=''; }
		if($this->input->post('sgst')!=""){
			$sgst=implode("<br>", $this->input->post('sgst'));
		}else{ 	$sgst=''; }
		
		if($this->input->post('extra_charge')!=""){
			$extra_charge=implode("<br>", $this->input->post('extra_charge'));
		}else{ $extra_charge=''; }
		if($this->input->post('extra_chargevalue')!=""){
			$extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
		}else{ $extra_chargevalue=''; }
		
		$opportunity_id = $this->input->post('opportunity_id');	
		$carrier=$this->input->post('carrier');
		if($carrier=='other'){
			$carrier=$this->input->post('other_courier_name');
		}
      $data = array(
          'org_name' 			=> $this->input->post('org_name'),
		  'org_id'				=> $this->input->post('org_id_act'),
		  'cont_id'				=> $this->input->post('cnt_id_act'),
          'subject' 			=> $this->input->post('subject'),
          'contact_name' 		=> $this->input->post('contact_name'),
          'opp_name' 			=> $this->input->post('opp_name'),
          'quote_stage' 		=> $this->input->post('quote_stage'),
          'valid_until' 		=> $this->input->post('valid_until'),
		  'courier_docket_no'   => $this->input->post('courier_docket_no'),
          'carrier' 			=> $carrier,
          'email' 				=> $this->input->post('email'),
          'billing_country' 	=> $this->input->post('billing_country'),
          'billing_state' 		=> $this->input->post('billing_state'),
          'billing_city' 		=> $this->input->post('billing_city'),
          'billing_zipcode' 	=> $this->input->post('billing_zipcode'),
          'billing_address' 	=> $this->input->post('billing_address'),
          'shipping_country' 	=> $this->input->post('shipping_country'),
          'shipping_state' 		=> $this->input->post('shipping_state'),
          'shipping_city' 		=> $this->input->post('shipping_city'),
          'shipping_zipcode' 	=> $this->input->post('shipping_zipcode'),
          'shipping_address' 	=> $this->input->post('shipping_address'),
          'product_name' 		=> implode("<br>",$this->input->post('product_name')),
          'quote_item_type' => implode("<br>", $this->input->post('quote_item_type')),
          'hsn_sac' 			=> implode("<br>", $this->input->post('hsn_sac')),
          'sku' 				=> implode("<br>", $this->input->post('sku')),
          'gst' 				=> implode("<br>", $this->input->post('gst')),
          'quantity' 			=> implode("<br>", $this->input->post('quantity')),
          'unit_price' 			=> implode("<br>", $unit_price),
          'total' 				=> implode("<br>", $total),
          'pro_description'     => implode("<br>",$this->input->post('pro_description')),
          'initial_total' 		=> $initial_total,
          //'discount' 			=> str_replace(",", "",$this->input->post('discount')),
		  'discount_type'		=> $discountType,
          'overall_discount'	=> $overallDiscount,
          'after_discount' 		=> $after_discount,
          'type' 				=> $this->input->post('type'),
          'igst' 				=> $igst,
          'cgst' 				=> $cgst,
          'sgst' 				=> $sgst,
          'sub_total_with_gst'  => implode("<br>", $this->input->post('sub_total_with_gst')),
		  'extra_charge_label'  => $extra_charge,
          'extra_charge_value'  => $extra_chargevalue,
		  'pro_discount'  		=> implode("<br>", $this->input->post('discount_price')),
		  'total_igst' 			=> str_replace(",", "",$this->input->post('total_igst')),
          'total_cgst' 			=> str_replace(",", "",$this->input->post('total_cgst')),
          'total_sgst' 			=> str_replace(",", "",$this->input->post('total_sgst')),
          'sub_totalq' 			=> $sub_total,
          'total_percent' 		=> $this->input->post('total_percent'),
          'terms_condition' 	=> $terms_condition,
		  'currentdate' 		=> $this->input->post('quotationDate')
        );
      $this->Quotation->update(array('id' => $this->input->post('id'),'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
      echo json_encode(array("status" => TRUE,'id'=>$this->input->post('id')));
    }
  }
  
  public function check_validation($method='')
  {
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    //$this->form_validation->set_rules('opportunity_id', 'Opportunity Id', 'required|trim');
    if($this->input->post('form_type')=='add'):
      $this->form_validation->set_rules('contact_name', 'Contact Name', 'required|trim');
    endif;
    
    $this->form_validation->set_rules('quote_stage', 'Quote Stage', 'required|trim');
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
	$this->form_validation->set_rules('quote_item_type[]', 'Product', 'required|trim');
	$this->form_validation->set_rules('quantity[]', 'Product Quantity', 'required|trim');
	$this->form_validation->set_rules('unit_price[]', 'Per Product Price', 'required|trim');
	$this->form_validation->set_rules('gst[]', 'GST', 'required|trim');
	$this->form_validation->set_rules('total[]', 'Total Price', 'required|trim');
	
    
    $this->form_validation->set_rules('initial_total', 'Initial Total', 'required|trim');
    //$this->form_validation->set_rules('discount_q', 'Discount', 'required|trim');
    $this->form_validation->set_rules('sub_total', 'Sub Total', 'required|trim');
    
    $this->form_validation->set_message('required', '%s is required');
    if ($this->form_validation->run() == FALSE)
    {
		
			return json_encode(array('st'=>202,'contact_name'=> form_error('contact_name'), 'quote_stage'=> form_error('quote_stage'), 'billing_country'=> form_error('billing_country'), 'billing_state'=> form_error('billing_state'), 'shipping_country'=> form_error('shipping_country'),'shipping_state'=> form_error('shipping_state'), 'billing_city'=> form_error('billing_city'), 'billing_zipcode'=> form_error('billing_zipcode'), 'shipping_city'=> form_error('shipping_city'), 'shipping_zipcode'=> form_error('shipping_zipcode'), 'billing_address'=> form_error('billing_address'), 'shipping_address'=> form_error('shipping_address') , 'product_name' => form_error('product_name[]'), 'quantity' => form_error('quantity[]'), 'unit_price' => form_error('unit_price[]'), 'total' => form_error('total[]'), 'initial_total' => form_error('initial_total'), 'sub_total' => form_error('sub_total'), 'gst' => form_error('gst[]') ));
		
    }else{
      return 200;
    }
  }
  public function delete($id)
  {
    $this->Quotation->delete($id);
    echo json_encode(array("status" => TRUE));
  }
  public function delete_bulk()
  {
    if($this->input->post('checkbox_value'))
    {
      $id = $this->input->post('checkbox_value');
      for($count = 0; $count < count($id); $count++)
      {
        $this->Quotation->delete_bulk($id[$count]);
      }
    }
  }
  public function view()
  {
    $this->load->library('pdf');
    if($this->uri->segment(3)){
          $download = $this->uri->segment(4);
          $id = $this->uri->segment(3);
          $html_content = '';
          $html_content .= $this->Quotation->view($id, $download);
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
  

    public function view_pi_qt($id)
    {
        if(!empty($this->session->userdata('email')))
        {
        $this->db->select('quote.*,org.email as org_email');
		$this->db->where('quote.id', $id);
		$this->db->from('quote');
		$this->db->join('organization as org','org.org_name=quote.org_name');
		//$this->db->where('id', $id);
        $data['record'] = $this->db->get()->row_array();
		$data['bank_details_terms'] = $this->Performainvoice->get_bank_details();
  	    $this->load->view('sales/view-quotation',$data);
  	    
  	    if($this->session->userdata('type')=='admin')
        {
			$this->load->model('Notification_model');
			$qid 		= $id;
			$notifor	= 'quotation';
			$podata 	= $this->Notification_model->update_noti('quote_id',$qid,$notifor);
		}
  	    
  	    
        }
        else
        {
          redirect('login');
        }
    
    }
    
    public function generate_pdf_attachment($quote_id)
    {
        
          $this->load->library('pdf');
          
          $download='';
          $html_content = '';
          $html_content .= $this->Quotation->view($quote_id,$download);
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
    	  $attachmentpdf =  $this->dompdf->output();
    	  $path = "assets/img/QUOTATION_".$quote_id.".pdf";	 
          file_put_contents($path, $attachmentpdf);
    	  return $path;
    
    }
	 public function send_email(){
	  
	  $orgName		= $this->input->post('orgName');
	  $orgEmail		= $this->input->post('orgEmail');
	  $ccEmail		= $this->input->post('ccEmail');
	  $subEmail		= $this->input->post('subEmail');
	  $descriptionTxt=$this->input->post('descriptionTxt');
	  $invoiceurl	=$this->input->post('invoiceurl');
	  $quote_id	=$this->input->post('quote_id');
	  //attachment 
	  $attach_pdf = $this->generate_pdf_attachment($quote_id);
	  
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
				if(!empty($image))
				{ $messageBody .=  '<img  src="'.base_url().'/uploads/company_logo/'.$image.'">'; }
				else {
					$messageBody .=  '<span class="h5 text-primary">'.$this->session->userdata('company_name').'</span>';
				}
		$messageBody.='</a>
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
                        <h1>Hi, '.ucwords($orgName).'!</h1>';
						
                        $messageBody.='<p>Thank you for shopping at '.$this->session->userdata('company_name').'.</p>';
						$messageBody.='<p>We appreciate your continued patronage and feel honored that you have chosen our product.</p>';
						$messageBody.='<p>Our company will do the best of our abilities to meet your expectations and provide the service that you deserve.</p>';
						$messageBody.='<p>We have grown so much as a corporation because of customers like you, and we certainly look forward to more years of partnership with you.</p>';
						
						
                        $messageBody.='<!-- Action -->
                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                <tr>
                                  <td align="center">
                                    <a href="'.$invoiceurl.'" class="f-fallback button" target="_blank">View Quotation Invoice</a>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>';
                         $messageBody.=$descriptionTxt;
                      $messageBody.='</div>
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
	
     if(!$this->email_lib->send_email($orgEmail,$subEmail,$messageBody,$ccEmail,$attach_pdf)){
		echo "0";
	}else{
		echo "1";
	}
	  unlink($attach_pdf); exit;
	  
  }
  

//Please write code above this
}
?>
