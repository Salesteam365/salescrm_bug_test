<?php
   defined('BASEPATH') or exit('No direct script access allowed');
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <?php
         $url = $this->uri->segment(1);
         if ($url == 'home') {
           $title = 'Home';
         } else if ($url == 'profile') {
           $title = 'Profile';
         } else if ($url == 'viewUser') {
           $title = 'Users';
         } else if ($url == 'branches') {
           $title = 'Branches';
         } else if ($url == 'organizations') {
           $title = 'Organizations';
         } else if ($url == 'contacts') {
           $title = 'Contacts';
         } else if ($url == 'leads') {
           $title = 'Leads';
         } else if ($url == 'opportunities') {
           $title = 'Opportunities';
         } else if ($url == 'quotation') {
           $title = 'Quotations';
         } else if ($url == 'salesorders') {
           $title = 'Salesorders';
         } else if ($url == 'vendors') {
           $title = 'Vendors';
         } else if ($url == 'purchaseorders') {
           $title = 'Purchaseorders';
         } else if ($url == 'reports') {
           $title = 'Reports';
        }else if ($url == 'aifilters') {
            $title = 'aifilters';
          
         } else if ($url == 'product-manager') {
           $title = 'product manager';
         } else if ($url == 'inventory-form') {
           $title = 'inventory form';
         } else if ($url == 'workflows') {
           $title = 'Workflows';
         } else if ($url == 'gst') {
           $title = 'GST';
         } else {
           $title = str_replace("_", " ", $url);
           $title = str_replace("-", " ", $title);
           $title = ucwords($title);
         }
         
         if ($url == 'profile' || $url == 'home' || $url == 'organizations' || $url == 'leads' || $url == 'opportunities' || $url == 'quotation' || $url == 'salesorders' || $this->session->userdata('account_type') != 'End') {
         } else {
           redirect(base_url('home'));
         }
         
         
         ########################
         #	Check Module	   #
         ########################
         $mdl = checkModule();
         $type = $this->session->userdata('type');
         
         if ($type == "standard" && $this->session->userdata('account_type') == 'End') {
           $this->session->set_flashdata('msg', '<i class="fa fa-info-circle" style="color: red; margin-right: 10px;"></i>Your team365 trial account has been expired');
           redirect(base_url());
         }
         
         
         /* if($this->session->userdata('email') && empty($this->session->userdata('company_name'))) {
                   redirect('locked');
               }*/
         
         ?>
      <title><?= $title; ?> | Team365 CRM</title>
      <script>
         console.log("<?= base_url('assets/images/favicon.png'); ?>");
      </script>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="shortcut icon" type="image/png" href="<?= base_url(); ?>assets/images/favicon.png">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>plugins/fontawesome-free/css/all.min.css">
      <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eY11gZZJMOerC8BSwEjK02v22G3jtcqJC4u1WjI5ZPWb7jHZ4O5z3XuSf2Yz9Pq1" crossorigin="anonymous">

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-DuY6BOEedHLOOIjOt46FpVjZqfRV+6cFB83v94y+Yk6DyboqW0hYmRLkhBjGm3z6" crossorigin="anonymous"></script>

      <!-- Tempusdominus Bbootstrap 4 -->
      <link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
      <!-- JQVMap -->
      <link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>plugins/jqvmap/jqvmap.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>css/team.min.css?v=<?= rand(1, 99); ?>">
      <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
      <script src="https://kit.fontawesome.com/db85a9eb98.js" crossorigin="anonymous"></script>
      <!-- navbar css -->
      <!-- <link rel="stylesheet" type="text/css" href="<?php echo NAVBAR_CSS; ?>?v=<?= rand(1, 99); ?>"> -->
      <!-- menubar css -->
      <link rel="stylesheet" type="text/css" href="<?php echo MENUBAR_CSS; ?>?v=<?= rand(1, 99); ?>">
      <!-- custom css -->
      <link rel="stylesheet" type="text/css" href="<?php echo STYLE_CSS; ?>?v=<?= rand(1, 99); ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo RESPONSIVE_CSS; ?>">
      <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery-ui.min.css">
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>plugins/daterangepicker/daterangepicker.css">
      <!-- summernote -->
      <link rel="stylesheet" href="<?php echo base_url() . "assets/"; ?>plugins/summernote/summernote-bs4.css">
      <!-- Google Font: Source Sans Pro -->
      <!-- <link href="https://fonts.googleapis.com/css?family=Baloo+2:400,700&display=swap" rel="stylesheet"> -->
      <!-- <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet"> -->
      <!-- datatable -->
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
      <!-- <script src="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"></script> -->
      <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
       <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
       <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
       <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"> -->
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"> -->
    
      <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/"; ?>css/milestones.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.1.4/lib/noty.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js" integrity="sha512-lOrm9FgT1LKOJRUXF3tp6QaMorJftUjowOWiDcG5GFZ/q7ukof19V0HKx/GWzXCdt9zYju3/KhBNdCLzK8b90Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

     <style type="text/css">
         .active_nav {
         color: red;
         }
         header{
            background:rgba(50,100,255);
         }
         .content-wrapper{
            /* background:rgba(230,230,243,0.6); */
         }
         
            /*Start  User Style */

         .image-user {
             
               animation: borderGlow 2s infinite;
            }
          /* Keyframes for glowing animation with smaller spread */
               @keyframes borderGlow {
                  0% {
                  box-shadow: 0 0 5px 2px #ff0000;
                  }
                  50% {
                  box-shadow: 0 0 10px 3px #00ff00;
                  }
                  100% {
                  box-shadow: 0 0 5px 2px #ff0000;
                  }
               }
           

            /* end user style */
         
      </style>
      <script type="text/javascript">
         // Set timeout variables.
         var timoutNow = 900000; // Timeout of 15 mins - time in ms
         var logoutUrl = "<?= base_url('locked') ?>"; // URL to logout page.
         
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
      <?php $hdrshow = 0;
         if ($this->session->userdata('type') == 'admin') {
           $session_company = $this->session->userdata('company_name');
           $session_comp_email = $this->session->userdata('company_email');
           $CI = &get_instance();
           $CI->load->model('login_model');
           $admin_data = $CI->login_model->get_company_details($session_company, $session_comp_email);
           $account_type   = $admin_data['account_type'];
           if ($account_type == 'Trial') {
         
             $trial_end_date = date_create($admin_data['trial_end_date']);
             $current_date   = date_create(date('Y-m-d'));
             $diff       = date_diff($trial_end_date, $current_date);
             $days       = $diff->format("%a");
             $hdrshow = 1;
         
             if ($days > 5) {
         ?>
      <header style="top: 0;">
         <div class="container-fluid">
            <p>You are currently in Free... <a href="<?= PRE_MY_DOMAIN_NAME . MAIN_DOMAIN . 'pricing'; ?>">Upgrade Now</a></p>
         </div>
      </header>
      <?php
         } else { ?>
      <header style="top: 0;">
         <div class="container-fluid">
            <p>your trial account will be expire after <?= $days; ?> days . . . <a href="<?= PRE_MY_DOMAIN_NAME . MAIN_DOMAIN . 'pricing'; ?>">Upgrade Now</a> Get 20% Discount</p>
         </div>
      </header>
      <?php }
         } else if ($account_type == 'Paid') {
         
           $license_expiration_date = date_create($admin_data['license_expiration_date']);
           $current_date            = date_create(date('Y-m-d'));
           $diff                = date_diff($license_expiration_date, $current_date);
           $days              = $diff->format("%a");
         
         
           if ($days <= 30) {
             $hdrshow = 1;
           ?>
      <header style="top: 0;">
         <div class="container-fluid">
            <p>Your Paid account is going to be expire in <?= $days; ?> days... <a href="<?= PRE_MY_DOMAIN_NAME . MAIN_DOMAIN . 'pricing'; ?>">Upgrade Now</a></p>
         </div>
      </header>
      <?php }
         }
         } ?>
      <div class="wrapper" <?php if ($hdrshow == 1) { ?>style="margin-top: 2%;" <?php } ?>>
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white " style="z-index:1;">
         <!-- Left navbar links -->
         <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link" data-widget="pushmenu" href="<?php echo base_url() . "home"; ?>#"><i style="color:rgba(10,22,64,0.96);"class="fas fa-bars"></i></a>
            </li>
         </ul>
         <style>
            .notiicationLbl {
            background-color: #f14503;
            padding: 1px 6px;
            color: #fff;
            border-radius: 35px;
            font-size: 12px;
            float: right;
            }
            .inputbootomBor {
            border: 0;
            border-radius: 0px;
            border-bottom: 1px solid #bfb9b9;
            }
            .numberDisp {
            margin-left: 10px;
            padding-top: 18px;
            }
            .notification {
    max-height: 300px; /* Dropdown menu ki maximum height ko 300px set karein */
    width: 400px;
    overflow-y: auto; /* Y-axis par scrollbar add karein, agar content height se zyada ho */
    overflow-x: hidden; /* X-axis par scrollbar ko hide karein */
}

            .dropdown-menu .dropdown-item:hover {
    background-color: rgba(230,230,250,0.4)!important ;
    color:rgba(128,0,138,0.8)!important ;
    font-weight:400!important ;
}


 .dropdown-menu {
   
    border: none; 
 
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px; 
} 

.custom-dropdown {
        position: relative;
        width: 100%;
    }

    .custom-select {
        cursor: pointer;
        padding: 10px;
        border: 1px solid #f2f3f4 ;
        border-radius: 4px;
        margin-bottom:20px;
    }

    .custom-options {
        position: absolute;
        display: none;
        background-color: #fff;
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
        border: none;
        border-radius: 4px;
        list-style: none;
        padding: 10px;
        margin: 0;
        width: 100%;
        z-index: 999;
        font-size:14px;
    }

    .custom-options li {
        padding: 4px;
        cursor: pointer;
    }

    .custom-options li:hover {
      background-color: rgba(230,230,250,0.4);
      color:rgba(147,112,219);
    }

    .custom-select.bt.dropdown-toggle {
    background-image: none;
}

div.refresh_button button.btnstopcorner {
    
    border-radius: 4px;
    background: #f2f3f4;
    color: #ccc;
    font-weight:600;
  }

  /* div.refresh_button button.btnstopcorner:hover {
    background:lightgrey;
    border: 1px solid #ccc; 
  } */
    
  div.refresh_button button.btnstop{
    border: 1px solid #ccc; 
    border-radius: 4px;
    background: #845ADF;
    color: #fff;
    font-weight:600;
  }

  div.refresh_button button.btnstop:hover{
    
    color:#fff!important;
  }

  div.refresh_button button.btncorner {
   
    border-radius: 4px;
    background: #26BF941A  ;
    color: #26BF94 ;
    font-weight:600;
  }

  div.refresh_button button.btncorner:hover {
    background:#26BF94 ;
    color: #fff; 
  }
  div.refresh_button button.btnstopcorn{
   border-radius: 4px;
    background: #E6533C1A ;
    color: #E6533C ;
    font-weight:600;
  }

  .filterbtncon{
   border-radius:12px; 
   background:#fff; 
   padding-top:22px;
    padding-right:12px;
     padding-left:24px; 
     margin:12px;
      margin-right:32px;
}

         </style>


         <ul class="navbar-nav ml-auto" >


         



            <!-- <li>
               <div class="searchbox"  style="margin-right:24px;">
                  <input type="search" placeholder="Search......" id="searchbox" class="searchbox-input" onkeyup="buttonUp();" required>
                  <input type="button" id="searchBtn" class="searchbox-submit" value="GO">
                  <span class="searchbox-icon" ><i class="fas fa-search"></i></span>
               </div>
            </li> -->


                <div class="header-element py-[1rem] md:px-[0.65rem] px-2  header-country hs-dropdown ti-dropdown  hidden sm:block [--placement:bottom-left] mt-3">
                     <!-- <button id="dropdown-flag" type="button"
                        class="hs-dropdown-toggle ti-dropdown-toggle !p-0 flex-shrink-0 !border-0 !rounded-full !shadow-none w-[1.5rem] h-[1.5rem] flex items-center justify-center bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                     </button>
   
                     <div class="hs-dropdown-menu ti-dropdown-menu min-w-[10rem] hidden !-mt-3 max-h-96 overflow-y-auto"
                                       aria-labelledby="dropdown-flag">
                                       <div class="ti-dropdown-divider divide-y divide-gray-200 dark:divide-white/10">
                                          <div class="py-2 first:pt-0 last:pb-0">
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "leads"; ?>">Lead</a></p>
                                                   </div>
                                             </div>
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "opportunities"; ?>">Opportunity</a></p>
                                                   </div>
                                             </div>
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "quotation"; ?>">Quote</a></p>
                                                   </div>
                                             </div>
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "salesorders"; ?>">Sales Order</a></p>
                                                   </div>
                                             </div>
   
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "purchaseorders"; ?>">Purchase Order</a></p>
                                                   </div>
                                             </div>
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "contacts"; ?>">Contact</a></p>
                                                   </div>
                                             </div>
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="#">Account</a></p>
                                                   </div>
                                             </div>
   
   
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "task"; ?>">Task</a></p>
                                                   </div>
                                             </div>
   
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "meeting"; ?>">Meeting</a></p>
                                                   </div>
                                             </div>
   
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "call"; ?>">Call</a></p>
                                                   </div>
                                             </div>
   
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "product-manager"; ?>">Product</a></p>
                                                   </div>
                                             </div>
   
   
   
   
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "invoices"; ?>">Invoice</a></p>
                                                   </div>
                                             </div>
   
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="#">Campaign</a></p>
                                                   </div>
                                             </div>
   
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "vendors"; ?>">Vendor</a></p>
                                                   </div>
                                             </div>
   
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "subpurchaseorders"; ?>">Subscriton Po</a></p>
                                                   </div>
                                             </div>
   
                                             <div class="ti-dropdown-item !p-[0.65rem]">
                                                   <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                      <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                      <p class="!text-[0.8125rem] font-medium"><a href="#">Case</a></p>
                                                   </div>
                                             </div>
                                          </div>
                                       </div>
                     </div> -->

                    <!-- start header country -->
                            <div class="header-element py-[1rem] md:px-[0.65rem] px-2  header-country hs-dropdown ti-dropdown  hidden sm:block [--placement:bottom-left]">
                                <button id="dropdown-flag" type="button"
                                    class="hs-dropdown-toggle ti-dropdown-toggle !p-0 flex-shrink-0 !border-0 !rounded-full !shadow-none w-[1.5rem] h-[1.5rem] flex items-center justify-center bg-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
 
                                <div class="hs-dropdown-menu ti-dropdown-menu min-w-[10rem] hidden !-mt-3 max-h-96 overflow-y-auto"
                                    aria-labelledby="dropdown-flag">
                                    <div class="ti-dropdown-divider divide-y divide-gray-200 dark:divide-white/10">
                                        <div class="py-2 first:pt-0 last:pb-0">
 
                                            <!-- Items start -->
                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                    <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "add-lead"; ?>">Lead</a></p>
                                                </div>
                                            </div>
                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                    <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "add-opportunity"; ?>">Opportunity</a></p>
                                                </div>
                                            </div>
                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                    <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "add-quote"; ?>">Quote</a></p>
                                                </div>
                                            </div>
                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                    <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "add-salesorder"; ?>">Sales Order</a></p>
                                                </div>
                                            </div>
 
                                          
 

                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                    <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "inventory-form"; ?>">Product</a></p>
                                                </div>
                                            </div>
 
 
 
 
                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center justify-center rounded-full text-gray-700">+</div>
                                                    <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "invoices/new-invoice"; ?>">Invoice</a></p>
                                                </div>
                                            </div>
 

                        
                                            <!-- Items end -->
 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end header country -->
               </div>
               <!-- PRELINE JS -->
               <script src="<?php echo base_url(''); ?>/application/views/assets/libs/preline/preline.js"></script>


                     
                     <li class="nav-item dropdown" style="margin-right:12px;">
                        <a class="nav-link position-relative" data-toggle="dropdown" href="<?php echo base_url() . "home"; ?>#">
                           <img src="<?php echo base_url("assets/navicon/"); ?>appointment-reminders--v1.png" />
                           <span class="badge badge-danger position-absolute top-0 start-100 translate-middle" style="margin-left: -12px; background:rgba(0,128,0,0.8); border-radius:50%;color: #fff;" id="putCountNoti">00</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right notification mt-4">
                           <input type="hidden" id="notiicationLbl">
                           <input type="hidden" id="putCountNotiLbl">
                           <input type="hidden" id="YourGstNo" value="<?= $this->session->userdata('company_gstin'); ?>">
                           <input type="hidden" id="YourStateName" value="<?= $this->session->userdata('state'); ?>">
                           <ul class="nav nav-treeview overflowclass" id="putNotiFication"></ul>
                        </div>
                     </li>

           
         

         <div class="dropdown">
         
            <a class="nav-link" data-toggle="dropdown" href="<?php echo base_url() . "home"; ?>#">
               <div class="d-flex align-items-center" style="margin-right:24px;">
                     <!-- Image -->
                     <!--<img src="<?php echo base_url("assets/navicon/"); ?>user.png" />-->
                     
                     <!-- User Image -->
                              <?php 
                                    $type = $this->session->userdata('type');
                                    if ($type == 'admin') { ?>
                                       <!-- Display admin-specific image -->
                                       <img class="inline-block rounded-full image-user" src="<?php echo base_url("uploads/company_logo/admin_user.jpg"); ?>" width="32" height="32" />

                                    <?php 
                                    } elseif (!empty($this->session->userdata('user_photo'))) { ?>
                                       
                                       <!-- Display image from session -->
                                       <img class="inline-block rounded-full image-user" src="<?php echo base_url("uploads/company_logo/" . $this->session->userdata('user_photo')); ?>" alt="User" width="32" height="32">

                                    <?php 
                                    } else { ?>
                                       
                                       <!-- Display static image -->
                                       <img class="inline-block rounded-full image-user" src="<?php echo base_url("assets/navicon/user.png"); ?>" width="32" height="32" />

                                    <?php } ?>
                                    <!-- End User -->

                     <!-- Name and Role -->
                     <div class="d-md-block d-none ml-2">
                        <p class="font-semibold mb-0 leading-none text-[#536485] text-[0.813rem]"><?php echo $this->session->userdata('');?></p>
                        <!-- <span class="opacity-70 font-normal text-[#536485] block text-[0.6875rem]">Web Designer</span> -->
                     </div>
               </div>
            </a>
        
            




            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-sm mt-2" aria-labelledby="dropdown-profile">
               <!-- <li>
                     <p class="dropdown-item"><?= ucwords($this->session->userdata('name')); ?></p>
               </li>
               <li><hr class="dropdown-divider"></li> -->

               <li>
                  <a href="<?php echo base_url('profile'); ?>" class="dropdown-item">
                              <!-- <i class="fas fa-user"></i> -->
                              <!-- <img src="<?php echo base_url("assets/navicon/"); ?>single-user.png" /> -->
                              <i class="fa-regular fa-circle-user" style="color:#000;"></i> Profile
                           </a>
               </li>

               <li>
                     <a href="<?php echo base_url('upgrade-plan'); ?>" class="dropdown-item">
                              <!-- <i class="fas fa-arrow-alt-circle-up"></i> -->
                              <!-- <img src="<?php echo base_url("assets/navicon/"); ?>return-purchase.png" /> -->
                              <i class="fa-solid fa-arrow-up-from-bracket" style="color:#000;"></i> Upgrade Plan
                           </a>
               </li>
               <li>
                  <a href="<?php echo base_url('extend-subscription'); ?>" class="dropdown-item">
                              <!-- <i class="fas fa-arrow-alt-circle-up"></i> -->
                              <!-- <img src="<?php echo base_url("assets/navicon/"); ?>return-purchase.png" /> -->
                              <i class="fa-solid fa-sliders" style="color:#000;"></i> Extend Subscription
                           </a>
               </li>
               <li>
                  <a href="<?php echo base_url('viewUser'); ?>" class="dropdown-item">
                              <!-- <i class="fas fa-users"></i> -->
                              <!-- <img src="<?php echo base_url("assets/navicon/"); ?>conference-call.png" /> -->
                              <i class="fa-solid fa-user" style="color:#000;"></i> View User
                           </a>
               </li>
               <li>
                  <a href="<?php echo base_url('branches'); ?>" class="dropdown-item">
                              <!-- <i class="far fa-building"></i> -->
                              <!-- <img src="<?php echo base_url("assets/navicon/"); ?>city-buildings.png" /> -->
                              <i class="fa-solid fa-code-branch" style="color:#000;"></i> Branch
                           </a>
                           
               </li>
               <li>
                  <a href="<?php echo base_url('change-password'); ?>" class="dropdown-item">
                              <!-- <i class="fas fa-key"></i> -->
                              <!-- <img src="<?php echo base_url("assets/navicon/"); ?>password.png" /> -->
                              <i class="fa-solid fa-lock" style="color:#000;"></i> Change Password
                           </a>
               </li>
               <li>
                  <a href="<?= base_url('login/logout'); ?>" class="dropdown-item">
                              <!-- <i class="fas fa-power-off"></i> -->
                              <!-- <img src="<?php echo base_url("assets/navicon/"); ?>exit.png" /> -->
                              <i class="fa-solid fa-arrow-right-from-bracket" style="color:#000;"></i> Logout
                           </a>
               </li>
            </ul>



         </div>



<script>
    $(document).ready(function(){
        $('.dropdown-toggle').dropdown();
    });
</script>
         </ul>
      </nav>
      <!-- /.navbar -->
      <style>
         .activeli {
         /* background: rgba(245,245,248,0.6); */
         color:white;
         /* margin:5px; */
         }
         .activeli p{
            color:rgba(255,255,255);
            font-weight:bolder;
         }
         #mainsidebar{
            background:rgba(10,22,64,0.96);
            color:rgba(240,240,240);
            
         }
         #mainsidebar ul li a p{
            /* background:rgba(10,22,56,0.99); */
            color:rgba(190,190,220);
            font-size:14px;
            /* font-weight:lighter; */
            
         }
         .accbody{
            border-top:1px solid rgba(230,230,235);
         }
         .quoteaccordion{
            background:white;
         }
         #mainsidebar ul li a i{
            /* background:rgba(10,22,56,0.99); */
            color:rgba(190,190,220);
            
         }
         .category-name{
            color:rgba(255,255,255,0.4);
            font-size:13px;
            list-style-type:none;
            margin-left:5px;
         }
      </style>
      <?php $page = $this->uri->segment(1);  ?>
      <aside class="main-sidebar sidebar-light-primary elevation-4" id="mainsidebar"<?php if ($hdrshow == 1) { ?>style="margin-top: 2%; " <?php } ?>>
         <div class="sidebar">
            <div class="user-panel mt-3 mb-3 d-flex">
               <div class="image">
                  <img src="<?php echo base_url() . ""; ?>assets/img/team-logo.png" class="img-circle elevation-2" alt="User Image">
               </div>
               <div class="info mb-2">
                  <a href="<?php echo base_url('home') . ""; ?>" class="d-block" style="color:white;">
                     <!-- <span>T</span> -->TEAM 365
                  </a>
               </div>
            </div>
            <!-- Sidebar Menu -->
            <li class="category-name"><span class="category-name">Main</span></li>
            <nav class="mt-2">
               <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <?php if (empty($this->session->userdata('company_name')) && empty($_GET['cnp'])) {
                     if ($url != 'company') {
                       redirect(base_url('company'));
                     }
                     } ?>
                  <li class="nav-item has-treeview ripple">
                     <a href="<?php echo base_url() . "home"; ?>" class="nav-link <?= ($page == 'home') ? "activeli" : null; ?>">
                        <i class="nav-icon fas fa-tachometer-alt icn-home"></i>
                        <!-- <img src="<?php echo base_url("assets/navicon/"); ?>dashboard-layout.png"/>-->
                        <p>
                           Dashboard
                        </p>
                     </a>
                  </li>
                  </ul>
                  <li class="category-name"><span class="category-name">Pages</span></li>
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <?php if ($type == "admin") { ?>
                  <li class="nav-item has-treeview ripple">
                     <a <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("activities") . '"'; ?> class="nav-link <?= ($page == 'activities') ? "activeli" : null; ?>">
                        <i class="fas fa-clipboard-check nav-icon icn-act"></i>
                        <!--<img src="<?php echo base_url("assets/navicon/"); ?>laptop-metrics.png"/>-->
                        <p>
                           Activities
                        </p>
                     </a>
                  </li>
                  <?php  }
                     if ($type == "admin" || $this->session->userdata('userType') == 'Sales Person' || $this->session->userdata('userType') == 'Sales Manager') {   ?>
                  <?php if (in_array("Create Customers", $mdl) ||  in_array("Create Contacts", $mdl)) { ?>
                  <li class="nav-item has-treeview <?= (in_array($page,['organizations','view-customer','contacts','find-duplicate'])) ? "menu-open" : null; ?>">
                     <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-users icn-cust"></i>
                        <!--<i class="nav-icon fas fa-chart-pie text-warning"></i> 
                           <img src="<?php echo base_url("assets/navicon/"); ?>warning-triangle.png"/>-->
                        <p> Essentials<i class="right fas fa-angle-left"></i> </p>
                     </a>
                     <ul class="nav nav-treeview">
                        <?php if (in_array("Create Customers", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a href="<?php echo base_url() . "organizations"; ?>" class="nav-link <?= ($page == 'organizations' || $page == 'view-customer') ? "activeli" : null; ?>">
                              <i class="fas fa-building nav-icon sub-icn-cust" id="org_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>/parallel-tasks.png"/>-->
                              <p>Organizations</p>
                           </a>
                        </li>
                        <?php }
                           if (in_array("Create Contacts", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a href="<?php echo base_url() . "contacts"; ?>" class="nav-link <?= ($page == 'contacts') ? "activeli" : null; ?>">
                              <i class="fas fa-address-book nav-icon sub-icn-contact" id="con_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>add-contact-to-company.png"/>-->
                              <p>Contacts</p>
                           </a>
                        </li>
                        <?php } ?>
                        <?php if ($type == "admin") {  ?>
                        <li class="nav-item ripple">
                           <a href="<?php echo base_url() . "find-duplicate"; ?>" class="nav-link <?= ($page == 'find-duplicate') ? "activeli" : null; ?>">
                              <i class="fa fa-clone nav-icon sub-icn-duplicate" id="con_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>copy-link.png"/>-->
                              <p>Find Duplicate</p>
                           </a>
                        </li>
                        <?php  } ?>
                     </ul>
                  </li>
                  <?php }
                     }
                     if ($type == "admin" || $this->session->userdata('userType') == 'Sales Person' || $this->session->userdata('userType') == 'Sales Manager') {
                       ?>
                  <?php if (in_array("Lead Generation", $mdl) ||  in_array("Create Opportunities", $mdl)  || in_array("Create Quotation", $mdl) || in_array("Create Salesorder", $mdl) || in_array("Create Proforma Invoice", $mdl) || in_array("Generate Invoicing", $mdl)) {
                     ?>
                  <li class="nav-item has-treeview <?= ($page == 'leads' || $page == 'opportunities' || $page == 'pipeline-performance' || $page == 'quotation' || $page == 'salesorders' || $page == 'add-salesorder' || $page == 'proforma_invoice' || $page == 'add-lead' || $page == 'add-opportunity' || $page == 'add-quote' || $page == 'invoices' || $page == 'add-invoice') ? "menu-open" : null; ?>">
                     <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-coins icn-sales"></i>
                        <!-- <img src="<?php echo base_url("assets/navicon/"); ?>sales-performance--v2.png"/>-->
                        <p>
                           Sales
                           <i class="fas fa-angle-left right"></i>
                        </p>
                     </a>
                     <ul class="nav nav-treeview">
                        <?php if (in_array("Lead Generation", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a href="<?php echo base_url() . "leads"; ?>" class="nav-link <?= ($page == 'leads' || $page == 'add-lead') ? "activeli" : null; ?>">
                              <i class="fab fa-angellist nav-icon sub-icn-lead" id="leads_nav"></i>
                              <!-- <img src="<?php echo base_url("assets/navicon/"); ?>find-user-male.png"/> -->
                              <p>Leads</p>
                           </a>
                        </li>
                        <?php }
                           if (in_array("Create Opportunities", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a href="<?php echo base_url() . "opportunities"; ?>" class="nav-link <?= ($page == 'opportunities' || $page == 'add-opportunity') ? "activeli" : null; ?>">
                              <i class="fas fa-briefcase nav-icon sub-icn-opp" id="opp_nav"></i>
                              <!-- <img src="<?php echo base_url("assets/navicon/"); ?>find-matching-job.png"/>-->
                              <p>Opportunity</p>
                           </a>
                        </li>
                        <!--<li class="nav-item ripple">
                           <a href="<?php echo base_url() . "pipeline-performance"; ?>" class="nav-link <?= ($page == 'pipeline-performance') ? "activeli" : null; ?>">
                             <i class="fas fa-briefcase nav-icon" id="opp_nav"></i>
                             <p>Pipeline Performance</p>
                           </a>
                           </li>-->
                        <?php }
                           if (in_array("Create Quotation", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a href="<?php echo base_url() . "quotation"; ?>" class="nav-link <?= ($page == 'quotation' || $page == 'add-quote') ? "activeli" : null; ?>">
                              <i class="far fa-file-alt nav-icon sub-icn-quote" id="quote_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>term.png"/>-->
                              <p>Quotations</p>
                           </a>
                        </li>
                        <?php }
                           if (in_array("Create Salesorder", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a href="<?php echo base_url() . "salesorders"; ?>" class="nav-link <?= ($page == 'salesorders' || $page == 'add-salesorder') ? "activeli" : null; ?>">
                              <i class="fas fa-chart-line nav-icon sub-icn-so" id="so_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>total-sales-1.png"/>-->
                              <p>Sales Orders</p>
                           </a>
                        </li>
                        <?php }
                           if (in_array("Generate Invoicing", $mdl)) {  ?>
                        
                        <?php }
                           if (in_array("Create Proforma Invoice", $mdl)) { ?>
                        <!--<li class="nav-item ripple">-->
                          <!-- <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "proforma_invoice"; ?>" <?php } ?> class="nav-link <?php if ($url == 'proforma_invoice') { ?> activeli <?php } ?>"> -->
                        <!--      <i class="fas fa-file-invoice-dollar nav-icon sub-icn-pi" id="inv_nav"></i>-->
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>invoice-1.png"/>-->
                        <!--      <p>Proforma Invoice</p>-->
                        <!--   </a>-->
                        <!--</li>-->
                        <?php } ?>
                     </ul>
                  </li>
                  <?php }
                     }
                     if ($this->session->userdata('type') == 'admin') {
                       if (in_array("Create Followup", $mdl)) { ?>
                  <li class="nav-item has-treeview <?= ($page == 'task' || $page == 'meeting' || $page == 'call') ? "menu-open" : null; ?>">
                     <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-mail-bulk icn-follow-up"></i>
                        <!--<img src="<?php echo base_url("assets/navicon/"); ?>check-file.png"/>-->
                        <p>
                           Follow Up
                           <i class="fas fa-angle-left right"></i>
                        </p>
                     </a>
                     <ul class="nav nav-treeview">
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "task"; ?>" <?php } ?> class="nav-link <?= ($url == 'task') ? "activeli" : null; ?>">
                              <i class="fas fa-tasks nav-icon sub-icn-task"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>task.png"/>-->
                              <p>Task</p>
                           </a>
                        </li>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "meeting"; ?>" <?php } ?> class="nav-link <?= ($url == 'meeting') ? "activeli" : null; ?>">
                              <i class="far fa-handshake nav-icon sub-icn-meeting"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>calendar-10.png"/>-->
                              <p>Meetings</p>
                           </a>
                        </li>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "call"; ?>" <?php } ?> class="nav-link <?= ($url == 'call') ? "activeli" : null; ?>">
                              <i class="fas fa-phone-square-alt nav-icon sub-icn-call"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>phone-disconnected.png"/>-->
                              <p>Call</p>
                           </a>
                        </li>
                     </ul>
                  </li>
                  <?php }
                     } ?>
         <!-- starts -->

          <!-- ends -->

                  <?php if (in_array("Inventory", $mdl)) { ?>
                  <li class="nav-item has-treeview <?= (in_array($page,['product-manager','vendors','purchaseorders','add-purchase-order','view-vendor'])) ? 'menu-open': null; ?>">
                     <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus icn-inventory"></i>
                        <!-- <i class="nav-icon fas fa-warehouse icn-inventory"></i> 
                           <img src="<?php echo base_url("assets/navicon/"); ?>warehouse.png"/>-->
                        <p>
                           Inventory
                           <i class="fas fa-angle-left right"></i>
                        </p>
                     </a>
                     <ul class="nav nav-treeview">
                        <?php if (in_array("Inventory", $mdl)) { ?>
                        <?php if ($this->session->userdata('type') == 'admin') { ?>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "product-manager"; ?>" <?php } ?> class="nav-link <?php if ($page == 'product-manager') {
                              echo "activeli";
                              } ?>">
                              <i class="fab fa-product-hunt nav-icon sub-icn-product"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>service.png"/>-->
                              <p>Product Manager</p>
                           </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "vendors"; ?>" <?php } ?> class="nav-link <?php if ($page == 'vendors' || $page == 'view-vendor') {
                              echo "activeli";
                              } ?>">
                              <i class="fas fa-store-alt nav-icon sub-icn-vendor" id="ven_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>pos-terminal.png"/>-->
                              <p>Vendors</p>
                           </a>
                        </li>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "purchaseorders"; ?>" <?php } ?> class="nav-link <?php if ($page == 'purchaseorders' || $page == 'add-purchase-order') {
                              echo "activeli";
                              } ?>">
                              <i class="fas fa-shopping-basket nav-icon sub-icn-po" id="po_nav"></i>
                              <!-- 
                                 <i class="fas fa-dollar-sign nav-icon" id="po_nav"></i> 
                                 <img src="<?php echo base_url("assets/navicon/"); ?>purchase-order.png"/>
                                 -->
                              <p>Purchase Orders</p>
                           </a>
                        </li>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "subpurchaseorders"; ?>" <?php } ?> class="nav-link <?php if ($page == 'subpurchaseorders' || $page = 'add-subpurchaseorder') {
                              echo "activeli";
                              } ?>">
                              <i class="fas fa-shopping-basket nav-icon sub-icn-po" id="subpo_nav"></i>
                              <!-- 
                                 <i class="fas fa-dollar-sign nav-icon" id="po_nav"></i> 
                                 <img src="<?php echo base_url("assets/navicon/"); ?>purchase-order.png"/>
                                 -->
                              <p>Subscription PO</p>
                           </a>
                        </li>
                        <?php }  ?>
                     </ul>
                  </li>
                  <?php } ?>
                  
                  <!-- starts -->
                  <?php if ($this->session->userdata('type')=='admin'){ ?>
                     <li class="nav-item has-treeview <?= (in_array($page,['accounting-report','expanse-manage','payment-reciept','delivery-Chalan','credit-note','debit-note'])) ? 'menu-open': null; ?>">
                        <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-calculator icn-inventory" style="color:orange;"></i>
                           <!-- <i class="nav-icon fas fa-warehouse icn-inventory"></i> 
                              <img src="<?php echo base_url("assets/navicon/"); ?>warehouse.png"/>-->
                           <p>
                              Accounting
                              <i class="fas fa-angle-left right"></i>
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <?php if (in_array("Inventory", $mdl)) { ?>
                           <?php if ($this->session->userdata('type') == 'admin') { ?>
                           
                           <?php } ?>
                           <li class="nav-item ripple">
                           <a <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("invoices") . '"'; ?> class="nav-link <?= ($page == 'invoices' || $page == 'add-invoice') ? 'activeli' : null; ?>">
                              <i class="fas fa-file-invoice nav-icon sub-icn-invoice"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>invoice-1.png"/>-->
                              <p>Invoices</p>
                           </a>
                        </li>
                        
                        <!--<li class="slide">-->
                        <!--                <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "proforma_invoice"; ?>" <?php } ?> class="nav-link <?php if ($url == 'proforma_invoice') { ?> activeli <?php } ?>">Performa Invoice </a>-->
                        <!--            </li>-->
                                    
                        
                        
                        <li class="nav-item ripple">
                           <a <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("proforma_invoice") . '"'; ?> class="nav-link <?= ($page == 'proforma_invoice' || $page == 'add-invoice') ? 'activeli' : null; ?>">
                              <i class="fas fa-file-invoice nav-icon sub-icn-invoice"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>invoice-1.png"/>-->
                              <p> Performa Invoice </p>
                           </a>
                        </li>
                        
                        
                        
                        
                           <li class="nav-item ripple">
                              <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "accounting-report"; ?>" <?php } ?> class="nav-link <?php if ($page == 'Accountingreport' || $page == 'view-vendor') {
                                 echo "activeli";
                                 } ?>">
                                 <i class="fas fa-file-invoice-dollar nav-icon sub-icn-vendor" id="ar_nav"></i>
                                 <!--<img src="<?php echo base_url("assets/navicon/"); ?>pos-terminal.png"/>-->
                                 <p>Accounting Report</p>
                              </a>
                           </li>
                           <li class="nav-item ripple">
                              <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "expanse-manage"; ?>" <?php } ?> class="nav-link <?php if ($page == 'expansemanage' || $page == 'add-purchase-order') {
                                 echo "activeli";
                                 } ?>">
                                 <i class="fas fa-dollar-sign nav-icon " style="color:lightgreen;" id="em_nav"></i>
                                 <!-- 
                                    <i class="fas fa-dollar-sign nav-icon" id="po_nav"></i> 
                                    <img src="<?php echo base_url("assets/navicon/"); ?>purchase-order.png"/>
                                    -->
                                 <p>Expanse Management</p>
                              </a>
                           </li>
                           <li class="nav-item ripple">
                              <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "payment-reciept"; ?>" <?php } ?> class="nav-link <?php if ($page == 'Reciept' || $page == 'add-Reciept') {
                                 echo "activeli";
                                 } ?>">
                                 <i class="fas fa-receipt nav-icon " style="color:indigo;" id="pr_nav"></i>
                                 <!-- 
                                    <i class="fas fa-dollar-sign nav-icon" id="po_nav"></i> 
                                    <img src="<?php echo base_url("assets/navicon/"); ?>purchase-order.png"/>
                                    -->
                                 <p>Payment Reciept</p>
                              </a>
                           </li>
                           <li class="nav-item ripple">
                              <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "delivery-Chalan"; ?>" <?php } ?> class="nav-link <?php if ($page == 'Chalan' || $page == 'add-Chalan') {
                                 echo "activeli";
                                 } ?>">
                                 <i class="fas fa-box nav-icon " style="color:grey;" id="dc_nav"></i>
                                 <!-- 
                                    <i class="fas fa-dollar-sign nav-icon" id="po_nav"></i> 
                                    <img src="<?php echo base_url("assets/navicon/"); ?>purchase-order.png"/>
                                    -->
                                 <p>Delivery Chalan</p>
                              </a>
                           </li>
                          
                           <li class="nav-item ripple">
                              <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "credit-note"; ?>" <?php } ?> class="nav-link <?php if ($page == 'creditnote' || $page == 'add-creditnote') {
                                 echo "activeli";
                                 } ?>">
                                 <i class="fas fa-credit-card nav-icon " style="color:skyblue;" id="cn_nav"></i>
                                 <!-- 
                                    <i class="fas fa-dollar-sign nav-icon" id="po_nav"></i> 
                                    <img src="<?php echo base_url("assets/navicon/"); ?>purchase-order.png"/>
                                    -->
                                 <p>Credit Note</p>
                              </a>
                           </li>
                           <li class="nav-item ripple">
                              <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "debit-note"; ?>" <?php } ?> class="nav-link <?php if ($page == 'debitnote' || $page == 'add-debitnote') {
                                 echo "activeli";
                                 } ?>">
                                 <i class="fas fa-money-bill nav-icon" style="color:orange;" id="dn_nav"></i>
                                 <!-- 
                                    <i class="fas fa-dollar-sign nav-icon" id="po_nav"></i> 
                                    <img src="<?php echo base_url("assets/navicon/"); ?>purchase-order.png"/>
                                    -->
                                 <p>Debit Note</p>
                              </a>
                           </li>
                           <?php }  ?>
                        </ul>
                     </li>
                     <?php } ?>
               <!-- ends -->
                   <?php  if ($this->session->userdata('type') == 'admin') { ?>
                  <?php if (in_array("Email Marketing", $mdl)) { ?>
                  <li class="nav-item has-treeview  <?php if ($page == 'email-marketing' || $page == 'sent-email') {
                     echo "menu-open";
                     } ?>">
                     <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-mail-bulk icn-marketing"></i>
                        <!--<img src="<?php echo base_url("assets/navicon/"); ?>exhibitor.png"/>-->
                        <p>
                           Marketing
                           <i class="fas fa-angle-left right"></i>
                        </p>
                     </a>
                     <ul class="nav nav-treeview">
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "email-marketing"; ?>" <?php } ?> class="nav-link <?php if ($url == 'email-marketing') { ?> activeli <?php } ?>">
                              <i class="fas fa-envelope-open-text nav-icon sub-icn-email" id="inv_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>email-marketing.png"/>-->
                              <p>Email Marketing</p>
                           </a>
                        </li>
                        
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "sent-email"; ?>" <?php } ?> class="nav-link <?php if ($url == 'sent-email') { ?> activeli <?php } ?>">
                              <i class="fa fa-envelope nav-icon sub-icn-sentemail" id="inv_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>email.png"/>-->
                              <p>Sent Mail</p>
                           </a>
                        </li>
                     </ul>
                  </li>
                  <?php }
                     } ?>
                  <?php if (in_array("Create Report", $mdl) || in_array("Forecast and Quota", $mdl)) { ?>
                  <li class="nav-item has-treeview <?php if ($url == 'reports' || $url == 'forecast' || $url == 'sales-profit-target') {
                     echo 'menu-open';
                     } ?>">
                     <a href="" class="nav-link ">
                        <i class="nav-icon far fa-flag icn-reports"></i>
                        <!--<img src="<?php echo base_url("assets/navicon/"); ?>report-file.png"/>-->
                        <p>
                           Report
                           <i class="right fas fa-angle-left"></i>
                        </p>
                     </a>
                     <ul class="nav nav-treeview">
                        <?php if (in_array("Create Report", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "reports"; ?>" <?php } ?> class="nav-link <?php if ($page == 'reports') {
                              echo "activeli";
                              } ?>">
                              <i class="nav-icon fas fa-flag nav-icon sub-icn-reports"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>system-report.png"/>-->
                              <p>
                                 Report
                              </p>
                           </a>
                        </li>
                        <?php }
                           if (in_array("Forecast and Quota", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "forecast"; ?>" <?php } ?> class="nav-link <?php if ($page == 'forecast') {
                              echo "activeli";
                              } ?>">
                              <i class="fas fa-funnel-dollar nav-icon sub-icn-forecast"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>sell-stock.png"/>-->
                              <p>Forecast & Quota</p>
                           </a>
                        </li>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "sales-profit-target"; ?>" <?php } ?> class="nav-link <?php if ($page == 'sales-profit-target') {
                              echo "activeli";
                              } ?>">
                              <i class="far fa-dot-circle nav-icon sub-icn-target"></i>
                              <!--
                                 <i class="fas fa-funnel-dollar nav-icon"></i>
                                 <img src="<?php echo base_url("assets/navicon/"); ?>economic-improvement.png"/>
                                 -->
                              <p>Sales-Profit Target</p>
                           </a>
                        </li>
                        <?php } ?>
                     </ul>
                  </li>
                  <?php } if ($type == "admin") { ?>
                  <li class="nav-item has-treeview <?= (in_array($url,['roles','gst','integration','workflows','target','set-prefix','state-list'])) ? 'menu-open' : null ;?>">
                     <a href="" class="nav-link ">
                        <i class="nav-icon  fas fa-cog icn-setting"></i>
                        <!--<img src="<?php echo base_url("assets/navicon/"); ?>settings--v1.png"/>-->
                        <p>
                           Setting
                           <i class="right fas fa-angle-left"></i>
                        </p>
                     </a>
                     <ul class="nav nav-treeview">
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "roles"; ?>" <?php } ?> class="nav-link <?php if ($url == 'roles') { ?> activeli <?php } ?>">
                              <i class="fas fa-file-invoice nav-icon sub-icn-rolles" id="inv_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>commercial-development-management.png"/>-->
                              <p>Roles</p>
                           </a>
                        </li>
                        <?php if (in_array("Tax", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "gst"; ?>" <?php } ?> class="nav-link <?php if ($url == 'gst') { ?> activeli <?php } ?>">
                              <i class="fa fa-percent nav-icon sub-icn-gst" id="inv_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>accounting.png"/>-->
                              <p>Add GST</p>
                           </a>
                        </li>
                        <?php }
                           if (in_array("Integrations", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "integration"; ?>" <?php } ?> class="nav-link <?php if ($url == 'integration') { ?> activeli <?php } ?>">
                              <i class="fas fa-file-invoice nav-icon sub-icn-integration" id="inv_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>api.png"/>-->
                              <p>Integration</p>
                           </a>
                        </li>
                        <?php }
                           if (in_array("Create Workflow", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "workflows"; ?>" <?php } ?> class="nav-link <?php if ($url == 'workflows') { ?> activeli <?php } ?>">
                              <i class="fas fa-tasks nav-icon sub-icn-workflow" id="inv_nav"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>workflow.png"/>-->
                              <p>Workflows</p>
                           </a>
                        </li>
                        <?php }
                           if (in_array("Set User Target", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "target"; ?>" <?php } ?> class="nav-link <?php if ($page == 'target') {
                              echo "activeli";
                              } ?>">
                              <i class="nav-icon fas fa-user nav-icon sub-icn-frefixid"></i>
                              <!-- <img src="<?php echo base_url("assets/navicon/"); ?>user-location.png"/>-->
                              <p>
                                 User Target
                              </p>
                           </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "set-prefix"; ?>" <?php } ?> class="nav-link <?php if ($url == 'set-prefix') { ?> activeli <?php } ?>">
                              <i class="fas fa-hashtag nav-icon sub-icn-frefixid"></i>
                              <!--<img src="<?php echo base_url("assets/navicon/"); ?>medical-id.png"/>-->
                              <p>Set Prefix ID</p>
                           </a>
                        </li>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "state-list"; ?>" <?php } ?> class="nav-link <?php if ($url == 'state-list') { ?> activeli <?php } ?>">
                              <i class="far fa-list-alt nav-icon sub-icn-meeting"></i>
                              <p>State List</p>
                           </a>
                        </li>
                     </ul>
                  </li>
                  <?php } ?>
                  <?php if ($this->session->userdata('userType') == 'Account Person') { ?>
                  <li class="nav-item has-treeview menu-open">
                     <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>
                           Sales
                           <i class="fas fa-angle-left right"></i>
                        </p>
                     </a>
                     <ul class="nav nav-treeview">
                        <?php if (in_array("Create Quotation", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a href="<?php echo base_url() . "quotation"; ?>" class="nav-link <?php if ($page == 'quotation') {
                              echo "activeli";
                              } ?>">
                              <i class="far fa-file-alt nav-icon" id="quote_nav"></i>
                              <p>Quotations</p>
                           </a>
                        </li>
                        <?php }
                           if (in_array("Create Salesorder", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a href="<?php echo base_url() . "salesorders"; ?>" class="nav-link <?php if ($page == 'salesorders') {
                              echo "activeli";
                              } ?>">
                              <i class="fas fa-chart-line nav-icon" id="so_nav"></i>
                              <p>Sales Orders</p>
                           </a>
                        </li>
                        <?php }
                           if (in_array("Create Proforma Invoice", $mdl)) { ?>
                        <li class="nav-item ripple">
                           <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "proforma_invoice"; ?>" <?php } ?> class="nav-link" <?php if ($url == 'proforma_invoice') { ?>style="background-color: #4c4c4c;color:white" <?php } ?>>
                              <i class="fas fa-file-invoice nav-icon" id="inv_nav"></i>
                              <p>Proforma Invoice</p>
                           </a>
                        </li>
                        <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  
                  
                  <li class="nav-item has-treeview ripple">
                     <a <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("customreports") . '"'; ?> class="nav-link <?= ($page == 'customreports') ? "activeli" : null; ?>">
                        <i class="fas fa-clipboard-check nav-icon icn-act"></i>
                        <!--<img src="<?php echo base_url("assets/navicon/"); ?>laptop-metrics.png"/>-->
                        <p>
                          Bussiness Insights
                        </p>
                     </a>
                  </li>
                  
                  
                  <li class="nav-item has-treeview ripple">
                     <a <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("aifilters") . '"'; ?> class="nav-link <?= ($page == 'aifilters') ? "activeli" : null; ?>">
                        <i class="fas fa-clipboard-check nav-icon icn-act"></i>
                        <!--<img src="<?php echo base_url("assets/navicon/"); ?>laptop-metrics.png"/>-->
                        <p>
                          AI Filter
                        </p>
                     </a>
                  </li>


                   <li class="nav-item has-treeview ripple">
                     <a <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("tbl_list") . '"'; ?> class="nav-link <?= ($page == 'tbl_list') ? "activeli" : null; ?>">
                        <i class="fas fa-clipboard-check nav-icon icn-act"></i>
                        <p>
                          Create tbl
                        </p>
                     </a>
                  </li>
                  
                  
                  <!-- <li class="nav-item has-treeview <?php if ($url == 'aifilters' || $url == 'forecast' || $url == 'sales-profit-target') { echo 'menu-open'; } ?>">-->
                  <!--   <a href="" class="nav-link "> <i class="fa-solid fa-filter"></i>-->
                  <!--      <p> AI Filter <i class="right fas fa-angle-left"></i></p>-->
                  <!--   </a>-->

                  <!--   <ul class="nav nav-treeview">-->
                  <!--      <?php if (in_array("Create Report", $mdl)) { ?>-->
                  <!--      <li class="nav-item ripple">-->
                  <!--         <a <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "aifilters"; ?>" <?php } ?> class="nav-link <?php if ($page == 'aifilters') { echo "activeli";  } ?>">-->
                  <!--              <i class="fa-solid fa-filter"></i> <p> ai filter </p>-->
                  <!--         </a>-->
                  <!--      </li>-->
                  <!--      <?php } ?>-->

                  <!--   </ul>-->
                  <!--</li>-->
                  
                  
               </ul>
            </nav>
            <!-- /.sidebar-menu -->
            
         </div>
         <!-- /.sidebar -->
      </aside>
