<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php 
  
    $url = $this->uri->segment(1);
    if($url == 'home') { $title = 'Home'; }
    else if($url == 'profile') { $title = 'Profile'; }
    else if($url == 'viewUser') { $title = 'Users'; }
    else if($url == 'branches') { $title = 'Branches'; }
    else if($url == 'organizations') { $title = 'Organizations'; }
    else if($url == 'contacts') { $title = 'Contacts'; }
    else if($url == 'leads') { $title = 'Leads'; }
    else if($url == 'opportunities') { $title = 'Opportunities'; }
    else if($url == 'quotation') { $title = 'Quotations'; }
    else if($url == 'salesorders') { $title = 'Salesorders'; }
    else if($url == 'vendors') { $title = 'Vendors'; }
    else if($url == 'purchaseorders') { $title = 'Purchaseorders'; }
    else if($url == 'reports') { $title = 'Reports'; }
	else if($url == 'product-manager') { $title = 'product manager'; }
	else if($url == 'inventory-form') { $title = 'inventory form'; }
	else if($url == 'workflows') { $title = 'Workflows'; }
	else if($url == 'gst') { $title = 'GST'; }
	else{ 
	    $title=str_replace("_"," ",$url);
	    $title=str_replace("-"," ",$title);
	    $title=ucwords($title);
	}
	
	if($url=='profile' || $url=='home' || $url=='organizations' || $url=='leads' || $url=='opportunities' || $url=='quotation' || $url=='salesorders' || $this->session->userdata('account_type')!='End'){
	    
	}else{
	     redirect(base_url('home'));
	}
	
	
	########################
	#	Check Module	   #
	########################
	$mdl=checkModule(); 
	
	
	 $type = $this->session->userdata('type');
    if($type == "standard" && $this->session->userdata('account_type')=='End')
    {
       $this->session->set_flashdata('msg','<i class="fa fa-info-circle" style="color: red; margin-right: 10px;"></i>Your team365 trial account has been expired');
        redirect(base_url());
    }
    
    
       /* if($this->session->userdata('email') && empty($this->session->userdata('company_name'))) {
            redirect('locked');
        }*/
	
  ?>
  <title><?= $title; ?> | Team365 CRM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
   <link rel="shortcut icon" type="image/png" href="<?= base_url();?>assets/images/favicon.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>css/team.min.css?v=<?=rand(1,99);?>">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <!-- navbar css -->
  <link rel="stylesheet" type="text/css" href="<?php echo NAVBAR_CSS; ?>?v=<?=rand(1,99);?>">
  <!-- menubar css -->
  <link rel="stylesheet" type="text/css" href="<?php echo MENUBAR_CSS; ?>?v=<?=rand(1,99);?>">
  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="<?php echo STYLE_CSS; ?>?v=<?=rand(1,99);?>">
  <link rel="stylesheet" type="text/css" href="<?php echo RESPONSIVE_CSS; ?>">
 
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery-ui.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Baloo+2:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
  <!-- datatable -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/"; ?>css/milestones.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
  <style type="text/css">
    .active_nav { color: red; }
  </style>
  
  <script type="text/javascript">
   // Set timeout variables.
    var timoutNow = 900000;// Timeout of 15 mins - time in ms
    var logoutUrl = "<?= base_url('locked')?>"; // URL to logout page.

    var timeoutTimer;

    // Start timer
    function StartTimers() {
      timeoutTimer = setTimeout("IdleTimeout()", timoutNow);
    }

    // Reset timer
    function ResetTimers() {
      clearTimeout(timeoutTimer);
      StartTimers();
    }

    // Logout user
    function IdleTimeout() {
     // window.location = logoutUrl;
    }
 </script>
 
</head>

<!--onload="selectgst()"  sidebar-collapse -->
<body class="hold-transition sidebar-mini layout-fixed " onload="StartTimers();" onmousemove="ResetTimers();" onkeypress="ResetTimers()" onclick="ResetTimers()">

    <?php $hdrshow=0;
        if($this->session->userdata('type') == 'admin') {
        $session_company = $this->session->userdata('company_name');
		$session_comp_email = $this->session->userdata('company_email');
		$CI =& get_instance();
		$CI->load->model('login_model');
        $admin_data = $CI->login_model->get_company_details($session_company,$session_comp_email);
        $account_type   = $admin_data['account_type'];
        if($account_type == 'Trial'){
            
			$trial_end_date = date_create($admin_data['trial_end_date']);
            $current_date 	= date_create(date('Y-m-d'));
            $diff 			= date_diff($trial_end_date,$current_date);
            $days 			= $diff->format("%a");
			$hdrshow=1;
				
        	if($days > 5){
            ?>
            <header style="top: 0;">
                <div class="container-fluid">
                    <p>You are currently in Free... <a href="https://www.team365.io/pricing">Upgrade Now</a></p>
                </div>
            </header>
            <?php 
            }else{ ?>
                <header style="top: 0;">
                    <div class="container-fluid">
                    <p>your trial account will be expire after <?= $days; ?> days . . . <a href="https://www.team365.io/pricing">Upgrade Now</a> Get 20% Discount</p>
                  </div>
                </header>
            <?php } 
            
        }
        else if($account_type == 'Paid'){  
        
    	   $license_expiration_date = date_create($admin_data['license_expiration_date']);
           $current_date 	         = date_create(date('Y-m-d'));
           $diff 			         = date_diff($license_expiration_date,$current_date);
           $days 				     = $diff->format("%a"); 
                
                   
    if($days <= 30)
    {
		$hdrshow=1;
?>
     <header style="top: 0;">
        <div class="container-fluid">
            <p>Your Paid account is going to be expire in <?=$days;?> days... <a href="https://www.team365.io/pricing">Upgrade Now</a></p>
        </div>
    </header>
<?php } }  } ?>
<div class="wrapper" <?php if($hdrshow==1){ ?>style="margin-top: 2%;" <?php } ?> >

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="<?php echo base_url()."home"; ?>#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

<style>
.notiicationLbl{
	background-color: #f14503;
    padding: 1px 6px;
    color: #fff;
    border-radius: 35px;
	font-size: 12px;
	float: right;
}
  .inputbootomBor{
	border: 0;
    border-radius: 0px;
    border-bottom: 1px solid #bfb9b9;
  }
  .numberDisp{
    margin-left: 10px;
    padding-top: 18px;

  }
  </style>
    <ul class="navbar-nav ml-auto">
	
		<li>
			<!--<div class="searchBox">
				<input type="search" placeholder="Search" id="searchbox">
				<i class="fa fa-search" id="searchBtn"></i>
			</div>--->
			
			 <div class="searchbox">
				<input type="search" placeholder="Search......" id="searchbox" class="searchbox-input" onkeyup="buttonUp();" required>
				<input type="button" id="searchBtn" class="searchbox-submit" value="GO">
				<span class="searchbox-icon"><i class="fas fa-search"></i></span>
			</div>
			
		</li>
	
	 <!--<li class="nav-item dropdown">
        <div class="input-group mt-1">
		  <input type="text" class="form-control" id="searchbox" placeholder="Search">
		  <div class="input-group-append">
			<span class="input-group-text" id="searchBtn"><i class="fas fa-search"></i></span>
		  </div>
		</div>
     </li>-->
	
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="<?php echo base_url()."home"; ?>#">
          <!-- <i class="far fa-bell"></i> -->
          <img src="<?php echo base_url("assets/navicon/");?>appointment-reminders--v1.png"/> 
		  <!-- <span class="badge badge-danger" style="margin-left: -12px; border: 1px solid #f40404; background: none;color: #111;" id="putCountNoti">00</span> -->
        </a>
        <div class="dropdown">
    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdown-notification" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>
        <span class="notification-badge">5</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-notification">
        <li><div class="dropdown-header">Notifications</div></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Your Order Has Been Shipped</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">View All</a></li>
    </ul>
</div>

        <!-- <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="width: 230px;">
		<input type="hidden" id="notiicationLbl">
		<input type="hidden" id="putCountNotiLbl">
		<input type="hidden" id="YourGstNo" value="<?=$this->session->userdata('company_gstin');?>">
		<input type="hidden" id="YourStateName" value="<?=$this->session->userdata('state');?>">
           <ul class="nav nav-treeview overflowclass" id="putNotiFication" ></ul>
        </div> -->
      </li>

      <!-- user Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="<?php echo base_url()."home"; ?>#">
          <!-- <i class="far fa-user-circle"></i> -->
          <img src="<?php echo base_url("assets/navicon/");?>user.png"/>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <p class=""><?= ucwords($this->session->userdata('name')); ?></p>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('profile'); ?>" class="dropdown-item">
          <!-- <i class="fas fa-user"></i> -->
          <img src="<?php echo base_url("assets/navicon/");?>single-user.png"/>
            Profile
          </a>
		  <?php if($this->session->userdata('type')=='admin'){ ?>
		  <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('upgrade-plan'); ?>" class="dropdown-item">
          <!-- <i class="fas fa-arrow-alt-circle-up"></i> -->
          <img src="<?php echo base_url("assets/navicon/");?>return-purchase.png"/>
            Upgrade Plan
          </a>
		  <?php  if($this->session->userdata('account_type')=='Paid'){ ?>
		  <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('extend-subscription'); ?>" class="dropdown-item">
          <!-- <i class="fas fa-arrow-alt-circle-up"></i> -->
          <img src="<?php echo base_url("assets/navicon/");?>return-purchase.png"/>
            Extend Subscription
          </a>
		  <?php } ?>
          
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('viewUser'); ?>" class="dropdown-item">
          <!-- <i class="fas fa-users"></i> -->
          <img src="<?php echo base_url("assets/navicon/");?>conference-call.png"/>
            View User
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('branches'); ?>" class="dropdown-item">
          <!-- <i class="far fa-building"></i> -->
          <img src="<?php echo base_url("assets/navicon/");?>city-buildings.png"/>
            Branch
          </a>
		  <?php } ?>
		   <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('change-password'); ?>" class="dropdown-item">
          <!-- <i class="fas fa-key"></i> -->
          <img src="<?php echo base_url("assets/navicon/");?>password.png"/>
            Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('login/logout'); ?>" class="dropdown-item">
          <!-- <i class="fas fa-power-off"></i> -->
          <img src="<?php echo base_url("assets/navicon/");?>exit.png"/>
            Logout
          </a>
		  
		    <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
          <div class="theme-switch-wrapper">
             <label class="theme-switch" for="checkbox">
              <input type="checkbox" id="checkbox">
              <div class="sliderr round"></div>
            </label>
          </div>
          </a>  
        </div>
      </li>
	 

    </ul>
  </nav>
  <!-- /.navbar -->
  <style>
  .activeli{
	  background:#212529;
  }
  </style>
<?php   $page = $this->uri->segment(1);  ?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4" <?php if($hdrshow==1){ ?>style="margin-top: 2%;" <?php } ?> >
    <div class="sidebar">
      <div class="user-panel mt-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url().""; ?>assets/img/team-logo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php echo base_url('home').""; ?>" class="d-block"><!-- <span>T</span> -->TEAM 365</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php if(empty($this->session->userdata('company_name')) && empty($_GET['cnp']))
    	    { if($url!='company'){ redirect(base_url('company')); }  } ?>       
               
          <li class="nav-item has-treeview ripple">
            <a href="<?php echo base_url()."home"; ?>" class="nav-link <?php if($page=='home'){ echo "activeli"; } ?>">
              <i class="nav-icon fas fa-tachometer-alt icn-home"></i> 
              <!-- <img src="<?php echo base_url("assets/navicon/");?>dashboard-layout.png"/>-->
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
           <?php   
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      ?>  
      
       <li class="nav-item has-treeview ripple">
            <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{ ?>   href="<?php echo base_url()."activities"; ?>" <?php } ?> class="nav-link <?php if($page=='activities'){ echo "activeli"; } ?>" >
               <i class="fas fa-clipboard-check nav-icon icn-act"></i> 
              <!--<img src="<?php echo base_url("assets/navicon/");?>laptop-metrics.png"/>-->
              <p>
                Activities
              </p>
            </a>
        </li>
          
      
    <?php  } 
	    if($type == "admin" || $this->session->userdata('userType')=='Sales Person' || $this->session->userdata('userType')=='Sales Manager')
        { 	?>
        <?php if(in_array("Create Customers",$mdl) ||  in_array("Create Contacts",$mdl)  ){ ?>
          <li class="nav-item has-treeview <?php if($page=='organizations' || $page=='view-customer' || $page=='contacts'){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link " >
				<i class="nav-icon fa fa-users icn-cust"></i>
               <!--<i class="nav-icon fas fa-chart-pie text-warning"></i> 
              <img src="<?php echo base_url("assets/navicon/");?>warning-triangle.png"/>-->
              <p>
                Essentials
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if(in_array("Create Customers",$mdl)){ ?>
              <li class="nav-item ripple">
                <a href="<?php echo base_url()."organizations"; ?>" class="nav-link <?php if($page=='organizations' || $page=='view-customer'){ echo "activeli"; } ?>">
                   <i  class="fas fa-building nav-icon sub-icn-cust" id="org_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>/parallel-tasks.png"/>-->
                  <p>Customers</p>
                </a>
              </li>
            <?php } if(in_array("Create Contacts",$mdl)){ ?>
              <li class="nav-item ripple">
                <a href="<?php echo base_url()."contacts"; ?>" class="nav-link <?php if($page=='contacts'){ echo "activeli"; } ?>">
                   <i class="fas fa-address-book nav-icon sub-icn-contact" id="con_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>add-contact-to-company.png"/>-->
                  <p>Contacts</p>
                </a>
              </li>
            <?php } ?>  
			   <?php if($type == "admin") {  ?>
              <li class="nav-item ripple">
                <a href="<?php echo base_url()."find-duplicate"; ?>" class="nav-link <?php if($page=='find-duplicate'){ echo "activeli"; } ?>">
                   <i class="fa fa-clone nav-icon sub-icn-duplicate" id="con_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>copy-link.png"/>-->
                  <p>Find Duplicate</p>
                </a>
              </li>
			   <?php  } ?>
            </ul>
          </li>
        <?php }  }
		    if($type == "admin" || $this->session->userdata('userType')=='Sales Person' || $this->session->userdata('userType')=='Sales Manager')
            {
		?>
		<?php if(in_array("Lead Generation",$mdl) ||  in_array("Create Opportunities",$mdl)  || in_array("Create Quotation",$mdl) || in_array("Create Salesorder",$mdl) || in_array("Create Proforma Invoice",$mdl) || in_array("Generate Invoicing",$mdl) ){
		?>
		
          <li class="nav-item has-treeview <?php if($page=='leads' || $page=='opportunities' || $page=='pipeline-performance' || $page=='quotation' || $page=='salesorders' || $page=='add-salesorder' || $page=='proforma_invoice' || $page=='add-lead' || $page=='add-opportunity' || $page=='add-quote' || $page=='invoices' || $page=='add-invoice' ){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link">
               <i class="nav-icon fas fa-coins icn-sales"></i> 
             <!-- <img src="<?php echo base_url("assets/navicon/");?>sales-performance--v2.png"/>-->
              <p>
               Sales
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <?php if(in_array("Lead Generation",$mdl)){ ?>
              <li class="nav-item ripple">
                <a href="<?php echo base_url()."leads"; ?>" class="nav-link <?php if($page=='leads' || $page=='add-lead' ){ echo "activeli"; } ?>">
                   <i class="fab fa-angellist nav-icon sub-icn-lead" id="leads_nav"></i>
                 <!-- <img src="<?php echo base_url("assets/navicon/");?>find-user-male.png"/> -->
                  <p>Leads</p>
                </a>
              </li>
              <?php }  if(in_array("Create Opportunities",$mdl)){ ?>
              <li class="nav-item ripple">
                <a href="<?php echo base_url()."opportunities"; ?>" class="nav-link <?php if($page=='opportunities' || $page=='add-opportunity' ){ echo "activeli"; } ?>">
                   <i class="fas fa-briefcase nav-icon sub-icn-opp" id="opp_nav"></i> 
                 <!-- <img src="<?php echo base_url("assets/navicon/");?>find-matching-job.png"/>-->
                  <p>Opportunity</p>
                </a>
              </li>
              <!--<li class="nav-item ripple">
                <a href="<?php echo base_url()."pipeline-performance"; ?>" class="nav-link <?php if($page=='pipeline-performance'){ echo "activeli"; } ?>">
                  <i class="fas fa-briefcase nav-icon" id="opp_nav"></i>
                  <p>Pipeline Performance</p>
                </a>
              </li>-->
              <?php }  if(in_array("Create Quotation",$mdl)){ ?>
              <li class="nav-item ripple">
                <a href="<?php echo base_url()."quotation"; ?>" class="nav-link <?php if($page=='quotation' || $page=='add-quote' ){ echo "activeli"; } ?>">
                   <i class="far fa-file-alt nav-icon sub-icn-quote" id="quote_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>term.png"/>-->
                  <p>Quotations</p>
                </a>
              </li>
              <?php }  if(in_array("Create Salesorder",$mdl)){ ?>
              <li class="nav-item ripple" >
                <a href="<?php echo base_url()."salesorders"; ?>" class="nav-link <?php if($page=='salesorders' || $page=='add-salesorder' ){ echo "activeli"; } ?>">
                   <i class="fas fa-chart-line nav-icon sub-icn-so" id="so_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>total-sales-1.png"/>-->
                  <p>Sales Orders</p>
                </a>
              </li>
              <?php } 
              
              if(in_array("Generate Invoicing",$mdl)){  ?>  
			   <li class="nav-item ripple">
				<a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{ ?>   href="<?php echo base_url()."invoices"; ?>" <?php } ?> class="nav-link <?php if($page=='invoices' || $page=='add-invoice'){ echo "activeli"; } ?>" >
				   <i class="fas fa-file-invoice nav-icon sub-icn-invoice"></i> 
					<!--<img src="<?php echo base_url("assets/navicon/");?>invoice-1.png"/>-->
				  <p>
					Invoices
				  </p>
				</a>
              </li>
			<?php }  
              if(in_array("Create Proforma Invoice",$mdl)){ ?>
               <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."proforma_invoice"; ?>" <?php } ?> class="nav-link <?php if($url == 'proforma_invoice') { ?> activeli <?php } ?>">
                   <i  class="fas fa-file-invoice-dollar nav-icon sub-icn-pi" id="inv_nav"></i>				   
                  <!--<img src="<?php echo base_url("assets/navicon/");?>invoice-1.png"/>-->
                  <p>Proforma Invoice</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
          
			<?php } } if($this->session->userdata('type')=='admin') { 
	   if(in_array("Create Followup",$mdl)){ ?>	
		
          <li class="nav-item has-treeview <?php if($page=='task' || $page=='meeting' || $page=='call'){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link">
               <i class="nav-icon fas fa-mail-bulk icn-follow-up"></i> 
              <!--<img src="<?php echo base_url("assets/navicon/");?>check-file.png"/>-->
              <p>
               Follow Up
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item ripple"  >
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."task"; ?>" <?php } ?> class="nav-link <?php if($url == 'task') { ?> activeli <?php } ?>">
                   <i class="fas fa-tasks nav-icon sub-icn-task"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>task.png"/>-->
                  <p>Task</p>
                </a>
              </li>
              <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."meeting"; ?>" <?php } ?> class="nav-link <?php if($url == 'meeting') { ?> activeli <?php } ?>">
                   <i class="far fa-handshake nav-icon sub-icn-meeting"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>calendar-10.png"/>-->
                  <p>Meetings</p>
                </a>
              </li>
              <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?>  href="<?php echo base_url()."index.php/call"; ?>" <?php } ?> class="nav-link <?php if($url == 'call') { ?> activeli <?php } ?>">
                   <i class="fas fa-phone-square-alt nav-icon sub-icn-call"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>phone-disconnected.png"/>-->
                  <p>Call</p>
                </a>
              </li>
            </ul>
          </li>
          
        <?php }  } ?>
		
        <?php if(in_array("Inventory",$mdl)){ ?>  
          <li class="nav-item has-treeview <?php if($page=='product-manager' || $page=='vendors' || $page=='purchaseorders' || $page=='add-purchase-order' || $page=='view-vendor' ){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link">
			   <i class="nav-icon fas fa-cart-plus icn-inventory"></i>
              <!-- <i class="nav-icon fas fa-warehouse icn-inventory"></i> 
			  <img src="<?php echo base_url("assets/navicon/");?>warehouse.png"/>-->
              <p>
                Inventory
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if(in_array("Inventory",$mdl)){ ?>   
                <?php if($this->session->userdata('type') == 'admin') { ?>
            
			 <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."product-manager"; ?>" <?php } ?> class="nav-link <?php if($page=='product-manager'){ echo "activeli"; } ?>">
                   <i class="fab fa-product-hunt nav-icon sub-icn-product"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>service.png"/>-->
                  <p>Product Manager</p>
                </a>
              </li>
              <?php } ?>
              <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."vendors"; ?>" <?php } ?> class="nav-link <?php if($page=='vendors' || $page=='view-vendor'){ echo "activeli"; } ?>">
                   <i class="fas fa-store-alt nav-icon sub-icn-vendor" id="ven_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>pos-terminal.png"/>-->
                  <p>Vendors</p>
                </a>
              </li>
              <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."purchaseorders"; ?>" <?php } ?> class="nav-link <?php if($page=='purchaseorders' || $page=='add-purchase-order' ){ echo "activeli"; } ?>">
					<i class="fas fa-shopping-basket nav-icon sub-icn-po" id="po_nav"></i>
                  <!-- <i class="fas fa-dollar-sign nav-icon" id="po_nav"></i> 
				  <img src="<?php echo base_url("assets/navicon/");?>purchase-order.png"/>-->
                  <p>Purchase Orders</p>
                </a>
              </li>
            <?php }  ?> 
            </ul>
          </li>
			<?php }  if($this->session->userdata('type') == 'admin') { ?>	
		<?php  if(in_array("Email Marketing",$mdl)){ ?>	
		  <li class="nav-item has-treeview  <?php if($page=='email-marketing' || $page=='sent-email'){ echo "menu-open"; } ?>">
            <a href="#" class="nav-link">
               <i class="nav-icon fas fa-mail-bulk icn-marketing"></i> 
              <!--<img src="<?php echo base_url("assets/navicon/");?>exhibitor.png"/>-->
              <p>
                Marketing
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">             
			 <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."email-marketing"; ?>" <?php } ?> class="nav-link <?php if($url == 'email-marketing') { ?> activeli <?php } ?>">
                   <i class="fas fa-envelope-open-text nav-icon sub-icn-email" id="inv_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>email-marketing.png"/>-->
                  <p>Email Marketing</p>
                </a>
              </li>
			  
              <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."sent-email"; ?>" <?php } ?> class="nav-link <?php if($url == 'sent-email') { ?> activeli <?php } ?>">
                   <i  class="fa fa-envelope nav-icon sub-icn-sentemail" id="inv_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>email.png"/>-->
                  <p>Sent Mail</p>
                </a>
              </li>
			</ul>
		  </li>
	<?php }  } ?>
	
	<?php if(in_array("Create Report",$mdl) || in_array("Forecast and Quota",$mdl) ){ ?> 
		<li class="nav-item has-treeview <?php if($url == 'reports' || $url == 'forecast' || $url == 'sales-profit-target') { echo'menu-open'; } ?>">
            <a href="" class="nav-link " >
              <i class="nav-icon far fa-flag icn-reports"></i> 
             <!--<img src="<?php echo base_url("assets/navicon/");?>report-file.png"/>-->
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          <ul class="nav nav-treeview">
              
        <?php  if(in_array("Create Report",$mdl)){ ?>	
           <li class="nav-item ripple">
            <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."reports"; ?>" <?php } ?> class="nav-link <?php if($page=='reports'){ echo "activeli"; } ?>">
               <i class="nav-icon fas fa-flag nav-icon sub-icn-reports"></i> 
              <!--<img src="<?php echo base_url("assets/navicon/");?>system-report.png"/>-->
              <p>
                Report
              </p>
            </a>
          </li>
        <?php } if(in_array("Forecast and Quota",$mdl)){ ?>  
            <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?>  href="<?php echo base_url()."forecast"; ?>" <?php } ?> class="nav-link <?php if($page=='forecast'){ echo "activeli"; } ?>">
                   <i class="fas fa-funnel-dollar nav-icon sub-icn-forecast"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>sell-stock.png"/>-->
                  <p>Forecast & Quota</p>
                </a>
             </li>
             
             <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?>  href="<?php echo base_url()."sales-profit-target"; ?>" <?php } ?> class="nav-link <?php if($page=='sales-profit-target'){ echo "activeli"; } ?>">
				   <i class="far fa-dot-circle nav-icon sub-icn-target"></i>
                  <!--<i class="fas fa-funnel-dollar nav-icon"></i>
				  <img src="<?php echo base_url("assets/navicon/");?>economic-improvement.png"/>-->
                  <p>Sales-Profit Target</p>
                </a>
             </li>
             
        <?php } ?>     
          </ul>
          </li>
	<?php    }
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      ?>  
		  <li class="nav-item has-treeview <?php if($url == 'roles' || $url == 'gst' || $url == 'integration' || $url == 'workflows' || $url == 'target' || $url == 'set-prefix' || $url == 'state-list' ) { echo'menu-open'; } ?>">
            <a href="" class="nav-link " >
              <i class="nav-icon  fas fa-cog icn-setting"></i> 
             <!--<img src="<?php echo base_url("assets/navicon/");?>settings--v1.png"/>-->
              <p>
                Setting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."roles"; ?>" <?php } ?> class="nav-link <?php if($url == 'roles') { ?> activeli <?php } ?>">
                   <i  class="fas fa-file-invoice nav-icon sub-icn-rolles" id="inv_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>commercial-development-management.png"/>-->
                  <p>Roles</p>
                </a>
              </li>
            <?php if(in_array("Tax",$mdl)){ ?>  
              <li class="nav-item ripple">
                <a  <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."gst"; ?>" <?php } ?> class="nav-link <?php if($url == 'gst') { ?> activeli <?php } ?>">
                 <i class="fa fa-percent nav-icon sub-icn-gst" id="inv_nav"></i> 
                <!--<img src="<?php echo base_url("assets/navicon/");?>accounting.png"/>-->
                  <p>Add GST</p>
                </a>
              </li> 
            <?php }  if(in_array("Integrations",$mdl)){ ?>  
             <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."integration"; ?>" <?php } ?> class="nav-link <?php if($url == 'integration') { ?> activeli <?php } ?>">
                   <i  class="fas fa-file-invoice nav-icon sub-icn-integration" id="inv_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>api.png"/>-->
                  <p>Integration</p>
                </a>
              </li>
             <?php }  if(in_array("Create Workflow",$mdl)){ ?>
              
              <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."workflows"; ?>" <?php } ?> class="nav-link <?php if($url == 'workflows') { ?> activeli <?php } ?>">
                   <i  class="fas fa-tasks nav-icon sub-icn-workflow" id="inv_nav"></i> 
                  <!--<img src="<?php echo base_url("assets/navicon/");?>workflow.png"/>-->
                  <p>Workflows</p>
                </a>
              </li> 
            <?php }  if(in_array("Set User Target",$mdl)){ ?>  
               <li class="nav-item ripple">
				<a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."target"; ?>" <?php } ?> class="nav-link <?php if($page=='target'){ echo "activeli"; } ?>">
				  <i class="nav-icon fas fa-user nav-icon sub-icn-frefixid"></i> 
          <!-- <img src="<?php echo base_url("assets/navicon/");?>user-location.png"/>-->
				  <p>
					User Target
				  </p>
				</a>
			  </li>
			<?php } ?>  
			  <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."set-prefix"; ?>" <?php } ?> class="nav-link <?php if($url == 'set-prefix') { ?> activeli <?php } ?>">
				   <i class="fas fa-hashtag nav-icon sub-icn-frefixid"></i> 
          <!--<img src="<?php echo base_url("assets/navicon/");?>medical-id.png"/>-->
                  <p>Set Prefix ID</p>
                </a>
              </li>
			  
			   <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."state-list"; ?>" <?php } ?> class="nav-link <?php if($url == 'state-list') { ?> activeli <?php } ?>">
				   <i class="far fa-list-alt nav-icon sub-icn-meeting"></i> 
                  <p>State List</p>
                </a>
              </li>
              
            </ul>
          </li>
	<?php } ?>  
		  
	<?php if($this->session->userdata('userType')=='Account Person'){ ?>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-coins"></i>
              <p>
               Sales
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <?php  if(in_array("Create Quotation",$mdl)){ ?>  
              <li class="nav-item ripple">
                <a href="<?php echo base_url()."quotation"; ?>" class="nav-link <?php if($page=='quotation'){ echo "activeli"; } ?>">
                  <i class="far fa-file-alt nav-icon" id="quote_nav"></i>
                  <p>Quotations</p>
                </a>
              </li>
              <?php }  if(in_array("Create Salesorder",$mdl)){ ?>
              <li class="nav-item ripple">
                <a href="<?php echo base_url()."salesorders"; ?>" class="nav-link <?php if($page=='salesorders'){ echo "activeli"; } ?>">
                  <i class="fas fa-chart-line nav-icon" id="so_nav"></i>
                  <p>Sales Orders</p>
                </a>
              </li>
              <?php }  if(in_array("Create Proforma Invoice",$mdl)){ ?>
               <li class="nav-item ripple">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."proforma_invoice"; ?>" <?php } ?> class="nav-link" <?php if($url == 'proforma_invoice') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
                  <i  class="fas fa-file-invoice nav-icon" id="inv_nav"></i>
                  <p>Proforma Invoice</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
			<?php } ?>
        </ul>          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>