<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <title>Team365</title>
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
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/"; ?>css/navbar.css">
  <!-- menubar css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/"; ?>css/menubar.css">
  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/"; ?>css/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/"; ?>css/timeline.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/"; ?>css/milestones.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2:wght@400;500&display=swap" rel="stylesheet">


  <!-- datatable -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
  <!-- charts -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  
</head>

<body class="hold-transition sidebar-mini layout-fixed">
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
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="<?php echo base_url()."assets/"; ?>#">
          <i class="far fa-user-circle"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <p class="">Mahendra</p>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('home/profile').""; ?>" class="dropdown-item"><i class="fas fa-user"></i>
            Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?php echo base_url('login');?>" class="dropdown-item"><i class="fas fa-power-off"></i>
            Logout
          </a>
          <div class="dropdown-divider"></div>
          <div class="theme-switch-wrapper">
             <label class="theme-switch" for="checkbox">
              <input type="checkbox" id="checkbox" />
              <div class="sliderr round"></div>
            </label>
          </div>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 mb-3 d-flex">
        <h5><a href="#">TEAM 365 (Operator)</a></h5>
        <!-- <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url().""; ?>#" class="nav-link">
              <p>
                  AUTPL
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="<?php echo base_url()."home/staff"; ?>" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>AUTPL</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()."home/"; ?>" class="nav-link">
                  <i class="fas fa-child nav-icon"></i>
                  <p>---</p>
                </a>
              </li>
            </ul>
          </li>
        </ul> --> 
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="<?php echo base_url()."home"; ?>" class="nav-link active">
              <i class="fas fa-home nav-icon"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url()."home/followup"; ?>" class="nav-link">
              <i class="fas fa-bars nav-icon"></i>
              <p>Follow Up</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url()."logs"; ?>" class="nav-link">
              <i class="fas fa-phone-alt nav-icon"></i>
              <p>Logs</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url()."users"; ?>" class="nav-link">
              <i class="fas fa-users nav-icon"></i>
              <p>Users</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url()."cashbook"; ?>" class="nav-link">
             <i class="far fa-chart-bar nav-icon"></i>
              <p>Reports</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url()."home/bulk_payment"; ?>" class="nav-link">
              <i class="fas fa-tasks nav-icon"></i>
              <p>Manage</p>
            </a>
          </li>
        </ul>          
      </nav>
      <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
    
  </aside>