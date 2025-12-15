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
	    
	}
  else{
	     redirect(base_url('home'));
	}
	
	
	 $type = $this->session->userdata('type');
    if($type == "standard" && $this->session->userdata('account_type')=='End')
    {
       $this->session->set_flashdata('msg','<i class="fa fa-info-circle" style="color: red; margin-right: 10px;"></i>Your team365 trial expired');
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
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>css/team.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <!-- navbar css -->
  <link rel="stylesheet" type="text/css" href="<?php echo NAVBAR_CSS; ?>">
  <!-- menubar css -->
  <link rel="stylesheet" type="text/css" href="<?php echo MENUBAR_CSS; ?>">
  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="<?php echo STYLE_CSS; ?>">
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

<!--onload="selectgst()"-->
<body class="hold-transition sidebar-mini layout-fixed" onload="StartTimers();" onmousemove="ResetTimers();" onkeypress="ResetTimers()" onclick="ResetTimers()">
    
<?php
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
            
                
    //if($days <="20")
   // {
?>
    <header>
        <div class="container-fluid">
            <p>You are currently in Free... <a href="https://www.team365.io/pricing">Upgrade Now</a></p>
        </div>
    </header>
<?php  }else if($account_type == 'Paid'){  
        
    	   $license_expiration_date = date_create($admin_data['license_expiration_date']);
           $current_date 	         = date_create(date('Y-m-d'));
           $diff 			         = date_diff($license_expiration_date,$current_date);
           $days 				     = $diff->format("%a"); 
                
                   
    if($days <= 30)
    {
?>
     <header>
        <div class="container-fluid">
            <p>Your Paid account is going to be expire in <?=$days;?> days... <a href="https://www.team365.io/pricing">Upgrade Now</a></p>
        </div>
    </header>
<?php } }  }?>
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="<?php echo base_url()."assets/"; ?>#"><i class="fas fa-bars"></i></a>
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
</style>
  <style>
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

  <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
<!--       <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalPush">Launch modal</button> -->

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="<?php echo base_url()."home"; ?>#">
          <i class="far fa-bell"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" id="putNotiFication">

           <a href="#" class="dropdown-item" data-toggle="modal" data-target="#opportunity-modal">
            Opportunity&nbsp;&nbsp;<label class="notiicationLbl">0</label>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" data-toggle="modal" data-target="#salesorder-modal">
            Sales Order
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" data-toggle="modal" data-target="#renewal-modal">
            Renewal 
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" data-toggle="modal" data-target="#dailyreport-modal">
            Daily Report 
          </a>
        </div>
      </li>

      <!-- user Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="<?php echo base_url()."home"; ?>#">
          <i class="far fa-user-circle"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <p class=""><?= ucwords($this->session->userdata('name')); ?></p>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('profile'); ?>" class="dropdown-item"><i class="fas fa-user"></i>
            Profile
          </a>
		  <?php if($this->session->userdata('type')=='admin'){ ?>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('viewUser'); ?>" class="dropdown-item"><i class="fas fa-users"></i>
            View User
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('branches'); ?>" class="dropdown-item"><i class="far fa-building"></i>
            Branch
          </a>
		  <?php } ?>
		   <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('change-password'); ?>" class="dropdown-item"><i class="fas fa-key"></i>
            Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('login/logout'); ?>" class="dropdown-item"><i class="fas fa-power-off"></i>
            Logout
          </a>
          
        </div>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->
  <style>
  .activeli{
	  background:#b7b3b3e0;
	  color: white;
  }
  </style>
<?php 

    $page = $this->uri->segment(1);
  ?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
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
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               
        <?php if(empty($this->session->userdata('company_name')) && empty($_GET['cnp']))
    	    { if($url!='company'){ redirect(base_url('company')); }  } ?>       
               
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url()."home"; ?>" class="nav-link <?php if($page=='home'){ echo "activeli"; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
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
      
       <li class="nav-item has-treeview">
            <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{ ?>   href="<?php echo base_url()."activities"; ?>" <?php } ?> class="nav-link <?php if($page=='activities'){ echo "activeli"; } ?>" >
              <i class="fas fa-clipboard-check"></i>
              <p>
                Activities
              </p>
            </a>
        </li>
          
      
    <?php   } ?>
          
          
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link " >
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Essentials
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url()."organizations"; ?>" class="nav-link <?php if($page=='organizations'){ echo "activeli"; } ?>">
                  <i  class="fas fa-building nav-icon " id="org_nav"></i>
                  <p>Organizations</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()."contacts"; ?>" class="nav-link <?php if($page=='contacts'){ echo "activeli"; } ?>">
                  <i class="fas fa-address-book nav-icon " id="con_nav"></i>
                  <p>Contacts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()."find-duplicate"; ?>" class="nav-link <?php if($page=='find-duplicate'){ echo "activeli"; } ?>">
                  <i class="fa fa-clone" id="con_nav"></i>
                  <p>Find Duplicate</p>
                </a>
              </li>
            </ul>
          </li>
        
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-coins"></i>
              <p>
               Sales
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url()."leads"; ?>" class="nav-link <?php if($page=='leads'){ echo "activeli"; } ?>">
                  <i class="fab fa-angellist nav-icon" id="leads_nav"></i>
                  <p>Leads</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()."opportunities"; ?>" class="nav-link <?php if($page=='opportunities'){ echo "activeli"; } ?>">
                  <i class="fas fa-briefcase nav-icon" id="opp_nav"></i>
                  <p>Opportunity</p>
                </a>
              </li>
              <!--<li class="nav-item">
                <a href="<?php echo base_url()."pipeline_performance"; ?>" class="nav-link <?php if($page=='pipeline_performance'){ echo "activeli"; } ?>">
                  <i class="fas fa-briefcase nav-icon" id="opp_nav"></i>
                  <p>Pipeline Performance</p>
                </a>
              </li>-->
              <li class="nav-item">
                <a href="<?php echo base_url()."quotation"; ?>" class="nav-link <?php if($page=='quotation'){ echo "activeli"; } ?>">
                  <i class="far fa-file-alt nav-icon" id="quote_nav"></i>
                  <p>Quotations</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()."salesorders"; ?>" class="nav-link <?php if($page=='salesorders'){ echo "activeli"; } ?>">
                  <i class="fas fa-chart-line nav-icon" id="so_nav"></i>
                  <p>Sales Orders</p>
                </a>
              </li>
               <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."proforma_invoice"; ?>" <?php } ?> class="nav-link" <?php if($url == 'proforma_invoice') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
                  <i  class="fas fa-file-invoice " id="inv_nav"></i>
                  <p>Proforma Invoice</p>
                </a>
              </li>
              
            </ul>
          </li>
          
		  <?php if($this->session->userdata('type')=='admin') { ?>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-mail-bulk"></i>
              <p>
               Follow Up
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item"  >
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."task"; ?>" <?php } ?> class="nav-link" <?php if($url == 'task') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
               
                  <i class="fas fa-tasks nav-icon"></i>
                  <p>Task</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."meeting"; ?>" <?php } ?> class="nav-link" <?php if($url == 'meeting') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
                
                  <i class="far fa-handshake nav-icon"></i>
                  <p>Meetings</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?>  href="<?php echo base_url()."index.php/call"; ?>" <?php } ?> class="nav-link" <?php if($url == 'call') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
                  <i class="fas fa-phone-square-alt nav-icon"></i>
                  <p>Call</p>
                </a>
              </li>
            </ul>
          </li>
          
        <?php } ?>
         
          
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Inventory
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <?php if($this->session->userdata('type') == 'admin') { ?>
			 <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."product-manager"; ?>" <?php } ?> class="nav-link <?php if($page=='product-manager'){ echo "activeli"; } ?>">
                  <i class="fab fa-product-hunt nav-icon"></i>
                  <p>Product Manager</p>
                </a>
              </li>
              <?php } ?>
              <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."vendors"; ?>" <?php } ?> class="nav-link <?php if($page=='vendors'){ echo "activeli"; } ?>">
                  <i class="fas fa-store-alt nav-icon" id="ven_nav"></i>
                  <p>Vendors</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."purchaseorders"; ?>" <?php } ?> class="nav-link <?php if($page=='purchaseorders'){ echo "activeli"; } ?>">
                  <i class="fas fa-dollar-sign nav-icon" id="po_nav"></i>
                  <p>Purchase Orders</p>
                </a>
              </li>
			   <li class="nav-item">
				<a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{ ?>   href="<?php echo base_url()."invoices"; ?>" <?php } ?> class="nav-link <?php if($page=='invoices'){ echo "activeli"; } ?>" >
				  <i class="fas fa-file-invoice"></i>
				  <p>
					Invoices
				  </p>
				</a>
              </li>
			  
            </ul>
          </li>
		
		<li class="nav-item has-treeview menu-open <?php if($url == 'reports' || $url == 'forecast') { echo'menu-open'; } ?>">
            <a href="" class="nav-link " >
             <i class="far fa-flag"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          <ul class="nav nav-treeview">
           <li class="nav-item">
            <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."reports"; ?>" <?php } ?> class="nav-link <?php if($page=='reports'){ echo "activeli"; } ?>">
              <i class="nav-icon fas fa-flag"></i>
              <p>
                Report
              </p>
            </a>
          </li>
            <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?>  href="<?php echo base_url()."forecast"; ?>" <?php } ?> class="nav-link <?php if($page=='forecast'){ echo "activeli"; } ?>">
                  <i class="fas fa-funnel-dollar"></i>
                  <p>Forecast & Quota</p>
                </a>
             </li>
          </ul>
          </li>
		  
		     <?php   
    $type = $this->session->userdata('type');
    if($type == "admin")
    {
      ?>  
		  <li class="nav-item has-treeview menu-open <?php if($url == 'roles' || $url == 'gst') { echo'menu-open'; } ?>">
            <a href="" class="nav-link " >
             <i class="fas fa-cog"></i>
              <p>
                Setting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."roles"; ?>" <?php } ?> class="nav-link" <?php if($url == 'roles') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
                  <i  class="fas fa-file-invoice " id="inv_nav"></i>
                  <p>Roles</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a  <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."gst"; ?>" <?php } ?> class="nav-link" <?php if($url == 'gst') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>><i class="fa fa-percent" id="inv_nav"></i>
                  
                  <p>Add GST</p>
                </a>
              </li> 
              
             <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."integration"; ?>" <?php } ?> class="nav-link" <?php if($url == 'integration') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
                  <i  class="fas fa-file-invoice " id="inv_nav"></i>
                  <p>Integration</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."workflows"; ?>" <?php } ?> class="nav-link" <?php if($url == 'workflows') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
                  <i  class="fas fa-tasks nav-icon" id="inv_nav"></i>
                  <p>Workflows</p>
                </a>
              </li> 
              <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."email-marketing"; ?>" <?php } ?> class="nav-link" <?php if($url == 'email-marketing') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
                  <i class="fas fa-envelope-open-text" id="inv_nav"></i>
                  <p>Email Marketing</p>
                </a>
              </li>
              <li class="nav-item">
                <a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."sent-email"; ?>" <?php } ?> class="nav-link" <?php if($url == 'sent-email') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
                  <i  class="fa fa-envelope " id="inv_nav"></i>
                  <p>Sent Mail</p>
                </a>
              </li>
               <li class="nav-item">
				<a <?php if($this->session->userdata('account_type')=='End'){ ?>  onclick="add_modal()" <?php }else{  ?> href="<?php echo base_url()."target"; ?>" <?php } ?> class="nav-link <?php if($page=='target'){ echo "activeli"; } ?>">
				  <i class="nav-icon fas fa-user"></i>
				  <p>
					User Target
				  </p>
				</a>
			  </li>
              
            </ul>
          </li>
	<?php } ?>  
		  
        </ul>          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>