<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php 
       $url = $this->uri->segment(2);
	if($url == 'home') { $title = 'Home'; }
	else if($url == 'user_details') { $title = 'User Details'; }
	else if($url == 'view_userDetails') { $title = ' View  User Details'; }
    else if($url == 'profile') { $title = 'Profile'; }
    else if($url == 'change-password') { $title = 'Change Password'; }
    else if($url == 'branches') { $title = 'Branches'; }
    else if($url == 'meta_tag') { $title = 'Meta Tag'; }
    else if($url == 'contacts') { $title = 'Contacts'; }
    else if($url == 'leads') { $title = 'Leads'; }
    else if($url == 'opportunities') { $title = 'Opportunities'; }
    else if($url == 'quotation') { $title = 'Quotations'; }
    else if($url == 'salesorders') { $title = 'Salesorders'; }
    else if($url == 'vendors') { $title = 'Vendors'; }
    else if($url == 'purchaseorders') { $title = 'Purchaseorders'; }
    else if($url == 'reports') { $title = 'Reports'; }

  ?>
  <title>Team365 | <?= $title; ?></title>
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

  <style type="text/css">
    .active_nav { color: red; }
  </style>
</head>
<!--onload="selectgst()"-->
<body class="hold-transition sidebar-mini layout-fixed"  >
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="<?php echo base_url()."assets/"; ?>#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>



  <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
<!--       <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalPush">Launch modal</button> -->

      <!-- Notifications Dropdown Menu 
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="<?php echo base_url()."assets/"; ?>#">
          <i class="far fa-bell"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">

          <a href="#" class="dropdown-item" data-toggle="modal" data-target="#opportunity-modal">
            Opportunity
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
      </li>-->

      <!-- user Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="<?php echo base_url()."assets/"; ?>#">
          <i class="far fa-user-circle"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <p class=""><?= ucwords($this->session->userdata('superadmin_name')); ?></p>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('superadmin/profile'); ?>" class="dropdown-item"><i class="fas fa-user"></i>
            Profile
          </a>
		  
		  <?php if($this->session->userdata('types')=='superadmin'){ ?>
          <!--<div class="dropdown-divider"></div>
          <a href="<?php echo base_url('viewUser'); ?>" class="dropdown-item"><i class="fas fa-users"></i>
            View User
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('branches'); ?>" class="dropdown-item"><i class="far fa-building"></i>
            Branch
          </a>-->
		  <?php } ?>
		   <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('superadmin/change-password'); ?>" class="dropdown-item"><i class="fas fa-key"></i>
            Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('superadmin/login/logout'); ?>" class="dropdown-item"><i class="fas fa-power-off"></i>
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

    $page = $this->uri->segment(2);
  ?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url().""; ?>assets/img/team-logo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php echo base_url('superadmin/home').""; ?>" class="d-block"><!-- <span>T</span> -->TEAM 365</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
			 <li class="nav-item has-treeview">
            <a href="<?php echo base_url()."superadmin/home"; ?>" class="nav-link <?php if($page=='home'){ echo "activeli"; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>   
			   
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url()."superadmin/user_details"; ?>" class="nav-link <?php if($page=='user_details'){ echo "activeli"; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Admin Details
              </p>
            </a>
          </li>
		  
		  <li class="nav-item has-treeview">
            <a href="<?php echo base_url()."superadmin/meta_tag"; ?>" class="nav-link <?php if($page=='meta_tag'){ echo "activeli"; } ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
               Meta Tag
              </p>
            </a>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url()."superadmin/partner"; ?>" class="nav-link <?php if($page=='partner'){ echo "activeli"; } ?>">
              <i class="nav-icon far fa-handshake"></i>
              <p>Partner</p>
            </a>
          </li>
          
        </ul>          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>