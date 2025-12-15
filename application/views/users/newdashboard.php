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
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" class="light" data-header-styles="light" data-menu-styles="dark">

    

<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <!-- Tell the browser to be responsive to screen width -->
        <!-- META DATA -->
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="Author" content="Customer Success Technology">
        <meta name="Description" content="Ynex - PHP Tailwind CSS Admin & Dashboard Template">
        <meta name="keywords" content="admin template, admin dashboard, php admin panel, admin, tailwind css dashboard, php admin dashboard, tailwind admin template, tailwind template, php dashboard, dashboard, tailwind, tailwind dashboard, tailwind css, tailwind css template">
        
        <!-- TITLE -->
        <title><?= $title; ?> | Team365 CRM</title>

        <!-- FAVICON -->
        <!-- <link rel="icon" href="https://php.spruko.com/tailwind/ynex/ynex/assets/images/brand-logos/favicon.ico" type="image/x-icon"> -->

        <!-- ICONS CSS -->
        <link href="<?php echo base_url(''); ?>/application/views/assets/css/icons.css" rel="stylesheet">
        
        <!-- STYLE CSS -->
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/application/views/assets/css/style.css">

                        
        <!-- SIMPLEBAR CSS -->
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/application/views/assets/libs/simplebar/simplebar.min.css">

        <!-- COLOR PICKER CSS -->
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/application/views/assets/libs/%40simonwep/pickr/themes/nano.min.css">
        
        <!-- MAIN JS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/js/main.js"></script>
        <script src="https://kit.fontawesome.com/db85a9eb98.js" crossorigin="anonymous"></script>
        



        
	</head>

	<body style="overflow:hidden;">
	    <script>
       setTimeout(function(){
           $("body").removeAttr('style');
       },200);
     </script>
  <style>
    
        .modalappear{
          background-color: rgba(255, 255, 255, 0.5);
          filter: brightness(0.5);
        }
        .modalappearbody{
            backdrop-filter: brightness(0.5);
            height:100vh;
            overflow:hidden;
            position:fixed;
        }

          .modalbox{
            display:none;
            width:50vw;
           max-height:90vh;
            background:white;
            border-radius:10px;
            position:fixed;
            top:80px;
            left:50%;
           
            z-index:999999;
            transform:translateX(-50%);
            box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
            
          }
          .modal-body{
               overflow-y: auto; /* Enables vertical scrolling */
               max-height:80vh;
          }
          .custommodal-header{
            height:60px;
            border-bottom:1px solid rgba(0,0,0,0.1);
            padding:12px;
            margin-bottom:10px;
          }
          .custommodalclose{
            position:absolute;
            position:absolute;
            right:15px;
            top:13px;
            font-size:20px;
          }
          .custommodaltable{
            width:95%;
            margin:auto;
          }
          .custommodaltable thead{
            height:45px;
           
          }
          .custommodaltable thead tr th{
           /*border-bottom:1px solid grey;*/
           font-size:16px;
           
          }
          .custommodal-footer{
            height:60px;
            border-top:1px solid rgba(0,0,0,0.1);
            padding:12px;
            margin-top:10px;
          }
          
          #recentactivitybody{
            display:flex;
            justify-content:space-between;
            width:100%;
           
          }
          #recentactivityassignedto{
            align-self:flex-end;
          }
          /*.modal-tr{*/
          /*    border-bottom:1px solid grey;*/
             
          /*}*/
          .modal-tr td{
               padding:6px;
               color:black;
               font-weight:500;
               font-size:13px;
          }
          /*.btnviewmodal{*/
          /*    background:rgba(0,30,200,0.9);*/
          /*    border-radius:4px;*/
          /*    color:white;*/
          /*    padding:7px;*/
          /*}*/
          /*.btnendmodal{*/
          /*    background:rgba(200,0,0,0.9);*/
          /*    border-radius:4px;*/
          /*    color:white;*/
          /*    padding:7px;*/
          /*}*/
          
          
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
            
             /* Media query for modalbox */

           @media screen and (max-width: 991px) {
           .modalbox {
            width:96vw;
            }
            .custommodaltable thead tr th{
              font-size:7px;
            }

            .modal-tr td {
              padding: 6px;
              color: black;
              font-weight: 500;
              font-size: 7px;
            }
          }
        </style>
               <?php if (check_permission_status('Salesorders', 'retrieve_u') == true) : ?>
<div class="modalbox" id="custommodalbox">
<div class="modal fade" id="sales_alert" role="dialog" data-keyboard="false" data-backdrop="static">
      <div class="modal-content">
        <div class="custommodal-header">
          <h4 class="modal-title sales_alert" style="color:black;">Renewal&nbsp;Alert </h4>
          <button style="color:black;" class="custommodalclose" id="custommodalclose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body form table-responsive">
          <!-- <button class="btn btn-secondary float-right" onclick="reload_notify_table()"><i class="fas fa-sync-alt"></i></button> -->
          <table class="custommodaltable table whitespace min-w-full">
            <thead >
              <tr >
                <th scope="col" class="text-start">SO&nbsp;Id</th>
                <th scope="col" class="text-start">Subject</th>
                <th scope="col" class="text-start">Organization&nbsp;Name</th>
                <th scope="col" class="text-start">Renewal&nbsp;Date</th>
                <th scope="col" class="text-start">Owner</th>
                <th scope="col" class="text-start">Action</th>
                <th scope="col" class="text-start">Action</th>
              </tr>
            </thead>
            <tbody id="notify_table">
              <?php $cnt = 0; 
     
              if (!empty($renewal_data)) {
                foreach ($renewal_data as $renew) {
                  $cnt = 1; ?>
                  <tr class="modal-tr border-b border-defaultborder">
                    <td style=" padding-left:12px;"><?= end(explode('/',$renew['saleorder_id'])); ?></td>
                    <td><?= $renew['subject']; ?></td>
                
<td><?= $renew['org_name'];?>&nbsp;<?php if($renew['customer_company_name'] != '' && $renew['customer_company_name'] != $renew['org_name']){ echo "(".$renew['customer_company_name'].")";}?></td>
                    <td><?= date("d/m/Y", strtotime($renew['renewal_date'])); ?></td>
                    <td><?= $renew['owner']; ?></td>
                    <td>
                      <button class="btnviewmodal badge bg-outline-primary" onclick="view_so(<?= $renew['id']; ?>);">View</button>
                    </td>
                    <td><button class="btnendmodal badge bg-outline-secondary" onclick="end_renewal(<?= $renew['id']; ?>);">End</button></td>
                  </tr>
              <?php }
              } ?>
            </tbody>
          </table>
        </div>
        <div class="custommodal-footer">
          <!--<button type="button" class="btn btn-secondary " data-dismiss="modal" onclick="close_notify_sess();">Close</button>-->
        </div>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>
        <!-- SWITCHER -->

        <div id="container">
            <div id="hs-overlay-switcher" class="hs-overlay hidden ti-offcanvas ti-offcanvas-right" tabindex="-1">
                <div class="ti-offcanvas-header z-10 relative">
                    <h5 class="ti-offcanvas-title">
                    Switcher
                    </h5>
                    <button type="button"
                    class="ti-btn flex-shrink-0 p-0  transition-none text-defaulttextcolor dark:text-defaulttextcolor/70 hover:text-gray-700 focus:ring-gray-400 focus:ring-offset-white  dark:hover:text-white/80 dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                    data-hs-overlay="#hs-overlay-switcher">
                    <span class="sr-only">Close modal</span>
                    <i class="ri-close-circle-line leading-none text-lg"></i>
                    </button>
                </div>
                <div class="ti-offcanvas-body !p-0 !border-b dark:border-white/10 z-10 relative !h-auto">
                    <div class="flex rtl:space-x-reverse" aria-label="Tabs" role="tablist">
                    <button type="button"
                        class="hs-tab-active:bg-success/20 w-full !py-2 !px-4 hs-tab-active:border-b-transparent text-defaultsize border-0 hs-tab-active:text-success dark:hs-tab-active:bg-success/20 dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-success -mb-px bg-white font-semibold text-center  text-defaulttextcolor dark:text-defaulttextcolor/70 rounded-none hover:text-gray-700 dark:bg-bodybg dark:border-white/10  active"
                        id="switcher-item-1" data-hs-tab="#switcher-1" aria-controls="switcher-1" role="tab">
                        Theme Style
                    </button>
                    <button type="button"
                        class="hs-tab-active:bg-success/20 w-full !py-2 !px-4 hs-tab-active:border-b-transparent text-defaultsize border-0 hs-tab-active:text-success dark:hs-tab-active:bg-success/20 dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-success -mb-px  bg-white font-semibold text-center  text-defaulttextcolor dark:text-defaulttextcolor/70 rounded-none hover:text-gray-700 dark:bg-bodybg dark:border-white/10  dark:hover:text-gray-300"
                        id="switcher-item-2" data-hs-tab="#switcher-2" aria-controls="switcher-2" role="tab">
                        Theme Colors
                    </button>
                    </div>
                </div>
                <div class="ti-offcanvas-body" id="switcher-body">
                    <div id="switcher-1" role="tabpanel" aria-labelledby="switcher-item-1" class="">
                    <div class="">
                        <p class="switcher-style-head">Theme Color Mode:</p>
                        <div class="grid grid-cols-3 switcher-style">
                        <div class="flex items-center">
                            <input type="radio" name="theme-style" class="ti-form-radio" id="switcher-light-theme" checked>
                            <label for="switcher-light-theme"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Light</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="theme-style" class="ti-form-radio" id="switcher-dark-theme">
                            <label for="switcher-dark-theme"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Dark</label>
                        </div>
                        </div>
                    </div>
                    <div>
                        <p class="switcher-style-head">Directions:</p>
                        <div class="grid grid-cols-3  switcher-style">
                        <div class="flex items-center">
                            <input type="radio" name="direction" class="ti-form-radio" id="switcher-ltr" checked>
                            <label for="switcher-ltr" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">LTR</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="direction" class="ti-form-radio" id="switcher-rtl">
                            <label for="switcher-rtl" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">RTL</label>
                        </div>
                        </div>
                    </div>
                    <div>
                        <p class="switcher-style-head">Navigation Styles:</p>
                        <div class="grid grid-cols-3  switcher-style">
                        <div class="flex items-center">
                            <input type="radio" name="navigation-style" class="ti-form-radio" id="switcher-vertical" checked>
                            <label for="switcher-vertical"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Vertical</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="navigation-style" class="ti-form-radio" id="switcher-horizontal">
                            <label for="switcher-horizontal"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Horizontal</label>
                        </div>
                        </div>
                    </div>
                    <div>
                        <p class="switcher-style-head">Navigation Menu Style:</p>
                        <div class="grid grid-cols-2 gap-2 switcher-style">
                        <div class="flex">
                            <input type="radio" name="navigation-data-menu-styles" class="ti-form-radio" id="switcher-menu-click"
                            checked>
                            <label for="switcher-menu-click" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Menu
                            Click</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="navigation-data-menu-styles" class="ti-form-radio" id="switcher-menu-hover">
                            <label for="switcher-menu-hover" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Menu
                            Hover</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="navigation-data-menu-styles" class="ti-form-radio" id="switcher-icon-click">
                            <label for="switcher-icon-click" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Icon
                            Click</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="navigation-data-menu-styles" class="ti-form-radio" id="switcher-icon-hover">
                            <label for="switcher-icon-hover" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Icon
                            Hover</label>
                        </div>
                        </div>
                        <div class="px-4 text-secondary text-xs"><b class="me-2">Note:</b>Works same for both Vertical and
                        Horizontal
                        </div>
                    </div>
                    <div class=" sidemenu-layout-styles">
                        <p class="switcher-style-head">Sidemenu Layout Syles:</p>
                        <div class="grid grid-cols-2 gap-2 switcher-style">
                        <div class="flex">
                            <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-default-menu" checked>
                            <label for="switcher-default-menu"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold ">Default
                            Menu</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-closed-menu">
                            <label for="switcher-closed-menu" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold ">
                            Closed
                            Menu</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-icontext-menu">
                            <label for="switcher-icontext-menu" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold ">Icon
                            Text</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-icon-overlay">
                            <label for="switcher-icon-overlay" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold ">Icon
                            Overlay</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-detached">
                            <label for="switcher-detached"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold ">Detached</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-double-menu">
                            <label for="switcher-double-menu" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Double
                            Menu</label>
                        </div>
                        </div>
                        <div class="px-4 text-secondary text-xs"><b class="me-2">Note:</b>Navigation menu styles won't work
                        here.</div>
                    </div>
                    <div>
                        <p class="switcher-style-head">Page Styles:</p>
                        <div class="grid grid-cols-3  switcher-style">
                        <div class="flex">
                            <input type="radio" name="data-page-styles" class="ti-form-radio" id="switcher-regular" checked>
                            <label for="switcher-regular"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Regular</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="data-page-styles" class="ti-form-radio" id="switcher-classic">
                            <label for="switcher-classic"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Classic</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="data-page-styles" class="ti-form-radio" id="switcher-modern">
                            <label for="switcher-modern"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold"> Modern</label>
                        </div>
                        </div>
                    </div>
                    <div>
                        <p class="switcher-style-head">Layout Width Styles:</p>
                        <div class="grid grid-cols-3 switcher-style">
                        <div class="flex">
                            <input type="radio" name="layout-width" class="ti-form-radio" id="switcher-full-width" checked>
                            <label for="switcher-full-width"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">FullWidth</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="layout-width" class="ti-form-radio" id="switcher-boxed">
                            <label for="switcher-boxed" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Boxed</label>
                        </div>
                        </div>
                    </div>
                    <div>
                        <p class="switcher-style-head">Menu Positions:</p>
                        <div class="grid grid-cols-3  switcher-style">
                        <div class="flex">
                            <input type="radio" name="data-menu-positions" class="ti-form-radio" id="switcher-menu-fixed" checked>
                            <label for="switcher-menu-fixed"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Fixed</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="data-menu-positions" class="ti-form-radio" id="switcher-menu-scroll">
                            <label for="switcher-menu-scroll"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Scrollable </label>
                        </div>
                        </div>
                    </div>
                    <div>
                        <p class="switcher-style-head">Header Positions:</p>
                        <div class="grid grid-cols-3 switcher-style">
                        <div class="flex">
                            <input type="radio" name="data-header-positions" class="ti-form-radio" id="switcher-header-fixed" checked>
                            <label for="switcher-header-fixed" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">
                            Fixed</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="data-header-positions" class="ti-form-radio" id="switcher-header-scroll">
                            <label for="switcher-header-scroll"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Scrollable
                            </label>
                        </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Loader:</p>
                        <div class="grid grid-cols-3 switcher-style">
                        <div class="flex">
                            <input type="radio" name="page-loader" class="ti-form-radio" id="switcher-loader-enable" checked>
                            <label for="switcher-loader-enable" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">
                            Enable</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="page-loader" class="ti-form-radio" id="switcher-loader-disable">
                            <label for="switcher-loader-disable"
                            class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Disable
                            </label>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div id="switcher-2" class="hidden" role="tabpanel" aria-labelledby="switcher-item-2">
                    <div class="theme-colors">
                        <p class="switcher-style-head">Menu Colors:</p>
                        <div class="flex switcher-style space-x-3 rtl:space-x-reverse">
                        <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                            <input class="hs-tooltip-toggle ti-form-radio color-input color-white" type="radio" name="menu-colors"
                            id="switcher-menu-light" checked>
                            <span
                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                            role="tooltip">
                            Light Menu
                            </span>
                        </div>
                        <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                            <input class="hs-tooltip-toggle ti-form-radio color-input color-dark" type="radio" name="menu-colors"
                            id="switcher-menu-dark" checked>
                            <span
                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                            role="tooltip">
                            Dark Menu
                            </span>
                        </div>
                        <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                            <input class="hs-tooltip-toggle ti-form-radio color-input color-primary" type="radio" name="menu-colors"
                            id="switcher-menu-primary">
                            <span
                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                            role="tooltip">
                            Color Menu
                            </span>
                        </div>
                        <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                            <input class="hs-tooltip-toggle ti-form-radio color-input color-gradient" type="radio" name="menu-colors"
                            id="switcher-menu-gradient">
                            <span
                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                            role="tooltip">
                            Gradient Menu
                            </span>
                        </div>
                        <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                            <input class="hs-tooltip-toggle ti-form-radio color-input color-transparent" type="radio" name="menu-colors"
                            id="switcher-menu-transparent">
                            <span
                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                            role="tooltip">
                            Transparent Menu
                            </span>
                        </div>
                        </div>
                        <div class="px-4 text-[#8c9097] dark:text-white/50 text-[.6875rem]"><b class="me-2">Note:</b>If you want to change color Menu
                        dynamically
                        change from below Theme Primary color picker.</div>
                    </div>
                    <div class="theme-colors">
                        <p class="switcher-style-head">Header Colors:</p>
                        <div class="flex switcher-style space-x-3 rtl:space-x-reverse">
                        <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                            <input class="hs-tooltip-toggle ti-form-radio color-input color-white !border" type="radio" name="header-colors"
                            id="switcher-header-light" checked>
                            <span
                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                            role="tooltip">
                            Light Header
                            </span>
                        </div>
                        <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                            <input class="hs-tooltip-toggle ti-form-radio color-input color-dark" type="radio" name="header-colors"
                            id="switcher-header-dark">
                            <span
                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                            role="tooltip">
                            Dark Header
                            </span>
                        </div>
                        <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                            <input class="hs-tooltip-toggle ti-form-radio color-input color-primary" type="radio" name="header-colors"
                            id="switcher-header-primary">
                            <span
                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                            role="tooltip">
                            Color Header
                            </span>
                        </div>
                        <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                            <input class="hs-tooltip-toggle ti-form-radio color-input color-gradient" type="radio" name="header-colors"
                            id="switcher-header-gradient">
                            <span
                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                            role="tooltip">
                            Gradient Header
                            </span>
                        </div>
                        <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                            <input class="hs-tooltip-toggle ti-form-radio color-input color-transparent" type="radio"
                            name="header-colors" id="switcher-header-transparent">
                            <span
                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                            role="tooltip">
                            Transparent Header
                            </span>
                        </div>
                        </div>
                        <div class="px-4 text-[#8c9097] dark:text-white/50 text-[.6875rem]"><b class="me-2">Note:</b>If you want to change color
                        Header dynamically
                        change from below Theme Primary color picker.</div>
                    </div>
                    <div class="theme-colors">
                        <p class="switcher-style-head">Theme Primary:</p>
                        <div class="flex switcher-style space-x-3 rtl:space-x-reverse">
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-primary-1" type="radio" name="theme-primary"
                            id="switcher-primary">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-primary-2" type="radio" name="theme-primary"
                            id="switcher-primary1">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-primary-3" type="radio" name="theme-primary"
                            id="switcher-primary2">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-primary-4" type="radio" name="theme-primary"
                            id="switcher-primary3">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-primary-5" type="radio" name="theme-primary"
                            id="switcher-primary4">
                        </div>
                        <div class="ti-form-radio switch-select ps-0 mt-1 color-primary-light">
                            <div class="theme-container-primary"></div>
                            <div class="pickr-container-primary"></div>
                        </div>
                        </div>
                    </div>
                    <div class="theme-colors">
                        <p class="switcher-style-head">Theme Background:</p>
                        <div class="flex switcher-style space-x-3 rtl:space-x-reverse">
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-bg-1" type="radio" name="theme-background"
                            id="switcher-background">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-bg-2" type="radio" name="theme-background"
                            id="switcher-background1">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-bg-3" type="radio" name="theme-background"
                            id="switcher-background2">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-bg-4" type="radio" name="theme-background"
                            id="switcher-background3">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-bg-5" type="radio" name="theme-background"
                            id="switcher-background4">
                        </div>
                        <div class="ti-form-radio switch-select ps-0 mt-1 color-bg-transparent">
                            <div class="theme-container-background hidden"></div>
                            <div class="pickr-container-background"></div>
                        </div>
                        </div>
                    </div>
                    <div class="menu-image theme-colors">
                        <p class="switcher-style-head">Menu With Background Image:</p>
                        <div class="flex switcher-style space-x-3 rtl:space-x-reverse flex-wrap gap-3">
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio bgimage-input bg-img1" type="radio" name="theme-images" id="switcher-bg-img">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio bgimage-input bg-img2" type="radio" name="theme-images" id="switcher-bg-img1">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio bgimage-input bg-img3" type="radio" name="theme-images" id="switcher-bg-img2">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio bgimage-input bg-img4" type="radio" name="theme-images" id="switcher-bg-img3">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio bgimage-input bg-img5" type="radio" name="theme-images" id="switcher-bg-img4">
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="ti-offcanvas-footer sm:flex justify-between">
                    <a href="https://themeforest.net/item/ynex-php-tailwind-css-admin-dashboard-template/49911130" target="_blank" class="w-full ti-btn ti-btn-primary-full m-1">Buy Now</a>
                    <a href="https://themeforest.net/user/spruko/portfolio" target="_blank" class="w-full ti-btn ti-btn-secondary-full m-1">Our Portfolio</a>
                    <a href="javascript:void(0);" id="reset-all" class="w-full ti-btn ti-btn-danger-full m-1">Reset</a>
                </div>
            </div>
        <!-- END SWITCHER -->

        <!-- LOADER -->
		<div id="loader">
			<img src="https://php.spruko.com/tailwind/ynex/ynex/assets/images/media/loader.svg" alt="">
		</div>
		<!-- END LOADER -->
 
        <!-- PAGE -->
		<div class="page">

            <!-- HEADER -->

            
            <header class="app-header">
                <nav class="main-header !h-[3.75rem]" aria-label="Global">
                    <div class="main-header-container ps-[0.725rem] pe-[1rem] ">

                        <div class="header-content-left">
                            <!-- Start::header-element -->
                            <div class="header-element">
                                <div class="horizontal-logo">
                                <a href="index.html" class="header-logo">
                        <img src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="desktop-logo">
                        <img src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="toggle-logo">
                        <img src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="desktop-dark">
                        <img src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="toggle-dark">
                        <img src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="desktop-white">
                        <img src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="toggle-white">
                    </a>
                    <a href="<?php echo base_url('home') . ""; ?>" class="d-block" style="color:white;">
                     <!-- <span>T</span> -->TEAM 365
                  </a>
                                </div>
                            </div>
                            <!-- End::header-element -->

                            <!-- Start::header-element -->
                            <div class="header-element md:px-[0.325rem] !items-center">
                                <!-- Start::header-link -->
                                <a aria-label="Hide Sidebar"
                                    class="sidemenu-toggle animated-arrow  hor-toggle horizontal-navtoggle inline-flex items-center" href="javascript:void(0);"><span></span></a>
                                <!-- End::header-link -->
                            </div>
                            <!-- End::header-element -->
                        </div>

                        <div class="header-content-right">




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
                                                    <p class="!text-[0.8125rem] font-medium"><a href="<?php echo base_url() . "add-lead"; ?>" class="nav-link <?= ($page == 'add-lead' || $page == 'add-lead') ? "activeli" : null; ?>">Lead</a></p>
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






                            <!-- <div class="header-element py-[1rem] md:px-[0.65rem] px-2 header-search">
                                <button aria-label="button" type="button" data-hs-overlay="#search-modal"
                                    class="inline-flex flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium focus:ring-offset-0 focus:ring-offset-white transition-all text-xs dark:bg-bgdark dark:hover:bg-black/20 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10">
                                    <i class="bx bx-search-alt-2 header-link-icon"></i>
                                </button>
                            </div> -->

                            <!-- start header country -->
                            <!-- <div class="header-element py-[1rem] md:px-[0.65rem] px-2  header-country hs-dropdown ti-dropdown  hidden sm:block [--placement:bottom-left]">
                                <button id="dropdown-flag" type="button"
                                    class="hs-dropdown-toggle ti-dropdown-toggle !p-0 flex-shrink-0  !border-0 !rounded-full !shadow-none">
                                    <img src="<?php echo base_url(''); ?>/application/views/assets/images/flags/us_flag.jpg" alt="flag-img" class="h-[1.25rem] w-[1.25rem] rounded-full">
                                </button>

                                <div class="hs-dropdown-menu ti-dropdown-menu min-w-[10rem] hidden !-mt-3" aria-labelledby="dropdown-flag">
                                    <div class="ti-dropdown-divider divide-y divide-gray-200 dark:divide-white/10">
                                        <div class="py-2 first:pt-0 last:pb-0">
                                            <div class="ti-dropdown-item !p-[0.65rem] ">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] flex items-center w-[1.375rem] rounded-full">
                                                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/flags/us_flag.jpg" alt="flag-img"
                                                            class="h-[1rem] w-[1rem] rounded-full">
                                                    </div>
                                                    <div>
                                                        <p class="!text-[0.8125rem] font-medium">
                                                            English
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center rounded-full">
                                                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/flags/spain_flag.jpg" alt="flag-img"
                                                            class="h-[1rem] w-[1rem] rounded-full">
                                                    </div>
                                                    <div>
                                                        <p class="!text-[0.8125rem] font-medium">
                                                            Spanish
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center rounded-full">
                                                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/flags/french_flag.jpg" alt="flag-img"
                                                            class="h-[1rem] w-[1rem] rounded-full">
                                                    </div>
                                                    <div>
                                                        <p class="!text-[0.8125rem] font-medium">
                                                            French
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center rounded-full">
                                                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/flags/germany_flag.jpg" alt="flag-img"
                                                            class="h-[1rem] w-[1rem] rounded-full">
                                                    </div>
                                                    <div>
                                                        <p class="!text-[0.8125rem] font-medium">
                                                            German
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center rounded-full">
                                                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/flags/italy_flag.jpg" alt="flag-img"
                                                            class="h-[1rem] w-[1rem] rounded-full">
                                                    </div>
                                                    <div>
                                                        <p class="!text-[0.8125rem] font-medium">
                                                            Italian
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ti-dropdown-item !p-[0.65rem]">
                                                <div class="flex items-center space-x-2 rtl:space-x-reverse w-full">
                                                    <div class="h-[1.375rem] w-[1.375rem] flex items-center  rounded-sm">
                                                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/flags/russia_flag.jpg" alt="flag-img"
                                                            class="h-[1rem] w-[1rem] rounded-full">
                                                    </div>
                                                    <div>
                                                        <p class="!text-[0.8125rem] font-medium">
                                                            Russian
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- end header country -->

                            <!-- light and dark theme -->
                            <div class="header-element header-theme-mode hidden !items-center sm:block !py-[1rem] md:!px-[0.65rem] px-2">
                                <a aria-label="anchor"
                                    class="hs-dark-mode-active:hidden flex hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium transition-all text-xs dark:bg-bgdark dark:hover:bg-black/20 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                                    href="javascript:void(0);" data-hs-theme-click-value="dark">
                                    <i class="bx bx-moon header-link-icon"></i>
                                </a>
                                <a aria-label="anchor"
                                    class="hs-dark-mode-active:flex hidden hs-dark-mode group flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium text-defaulttextcolor  transition-all text-xs dark:bg-bodybg dark:bg-bgdark dark:hover:bg-black/20 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                                    href="javascript:void(0);" data-hs-theme-click-value="light">
                                    <i class="bx bx-sun header-link-icon"></i>
                                </a>
                            </div>
                            <!-- End light and dark theme -->

                            <!-- Header Cart item -->
                            <!-- <div class="header-element cart-dropdown hs-dropdown ti-dropdown md:!block !hidden py-[1rem] md:px-[0.65rem] px-2 [--placement:bottom-left]">
                                <button id="dropdown-cart" type="button"
                                    class="hs-dropdown-toggle relative ti-dropdown-toggle !p-0 !border-0 flex-shrink-0  !rounded-full !shadow-none align-middle text-xs">
                                    <i class="bx bx-cart header-link-icon"></i>
                                    <span class="flex absolute h-5 w-5 -top-[0.25rem] end-0 -me-[0.6rem]">
                                    <span class="relative inline-flex rounded-full h-[14.7px] w-[14px] text-[0.625rem] bg-primary text-white justify-center items-center"
                                        id="cart-icon-badge">5</span>
                                    </span>
                                </button>

                                <div class="main-header-dropdown bg-white !-mt-3 !p-0 hs-dropdown-menu ti-dropdown-menu w-[22rem] border-0 border-defaultborder hidden"
                                    aria-labelledby="dropdown-cart">

                                    <div class="ti-dropdown-header !bg-transparent flex justify-between items-center !m-0 !p-4">
                                        <p class="text-defaulttextcolor  !text-[1.0625rem] dark:text-[#8c9097] dark:text-white/50 font-semibold">Cart Items</p>
                                        <a href="javascript:void(0)"
                                            class="font-[600] py-[0.25/2rem] px-[0.45rem] rounded-[0.25rem] bg-success/10 text-success text-[0.75em] "
                                            id="cart-data">5 Items</a>
                                    </div>
                                    <div>
                                        <hr class="dropdown-divider dark:border-white/10">
                                    </div>
                                    <ul class="list-none mb-0" id="header-cart-items-scroll">
                                    <li class="ti-dropdown-item border-b dark:border-defaultborder/10 border-defaultborder ">
                                        <div class="flex items-start cart-dropdown-item">

                                            <img src="<?php echo base_url(''); ?>/application/views/assets/images/ecommerce/jpg/1.jpg" alt="img"
                                            class="!h-[1.75rem] !w-[1.75rem] leading-[1.75rem] text-[0.65rem] rounded-[50%] br-5 me-3">

                                            <div class="grow">
                                                <div class="flex items-start justify-between mb-0">
                                                    <div class="mb-0 !text-[0.8125rem] text-[#232323] font-semibold dark:text-[#8c9097] dark:text-white/50">
                                                        <a href="cart.html">Some Thing Phone</a>
                                                    </div>

                                                    <div class="inline-flex">
                                                        <span class="text-black mb-1 dark:text-white !font-medium">$1,299.00</span>
                                                        <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove ltr:float-right rtl:float-left dropdown-item-close"><i
                                                            class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="min-w-fit flex  items-start justify-between">
                                                    <ul class="header-product-item dark:text-white/50 flex">
                                                        <li>Metallic Blue</li>
                                                        <li>6gb Ram</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="ti-dropdown-item border-b dark:border-defaultborder/10 border-defaultborder">
                                        <div class="flex items-start cart-dropdown-item">
                                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/ecommerce/jpg/3.jpg" alt="img"
                                            class="!h-[1.75rem] !w-[1.75rem] leading-[1.75rem] text-[0.65rem]  rounded-[50%] br-5 me-3">
                                        <div class="grow">
                                            <div class="flex items-start justify-between mb-0">
                                            <div class="mb-0 text-[0.8125rem] text-[#232323] dark:text-[#8c9097] dark:text-white/50 font-semibold">
                                                <a href="cart.html">Stop Watch</a>
                                            </div>
                                            <div class="inline-flex">
                                                <span class="text-black dark:text-white !font-medium mb-1">$179.29</span>
                                                <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove ltr:float-right rtl:float-left dropdown-item-close"><i
                                                    class="ti ti-trash"></i></a>
                                            </div>
                                            </div>
                                            <div class="min-w-fit flex items-start justify-between">
                                            <ul class="header-product-item">
                                                <li>Analog</li>
                                                <li><span
                                                    class="font-[600] py-[0.25rem] px-[0.45rem] rounded-[0.25rem] bg-pink/10 text-pink text-[0.625rem]">Free
                                                    shipping</span></li>
                                            </ul>
                                            </div>
                                        </div>
                                        </div>
                                    </li>
                                    <li class="ti-dropdown-item border-b dark:border-defaultborder/10 border-defaultborder">
                                        <div class="flex items-start cart-dropdown-item">
                                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/ecommerce/jpg/5.jpg" alt="img"
                                            class="!h-[1.75rem] !w-[1.75rem] leading-[1.75rem] text-[0.65rem]  rounded-[50%] br-5 me-3">
                                        <div class="grow">
                                            <div class="flex items-start justify-between mb-0">
                                            <div class="mb-0 text-[0.8125rem] text-[#232323] font-semibold dark:text-[#8c9097] dark:text-white/50">
                                                <a href="cart.html">Photo Frame</a>
                                            </div>
                                            <div class="inline-flex">
                                                <span class="text-black !font-medium mb-1 dark:text-white">$29.00</span>
                                                <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove ltr:float-right rtl:float-left dropdown-item-close"><i
                                                    class="ti ti-trash"></i></a>
                                            </div>
                                            </div>
                                            <div class="min-w-fit flex items-start justify-between">
                                            <ul class="header-product-item flex">
                                                <li>Decorative</li>
                                            </ul>
                                            </div>
                                        </div>
                                        </div>
                                    </li>
                                    <li class="ti-dropdown-item border-b dark:border-defaultborder/10 border-defaultborder">
                                        <div class="flex items-start cart-dropdown-item">
                                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/ecommerce/jpg/4.jpg" alt="img"
                                            class="!h-[1.75rem] !w-[1.75rem] leading-[1.75rem] text-[0.65rem]  rounded-[50%] br-5 me-3">
                                        <div class="grow">
                                            <div class="flex items-start justify-between mb-0">
                                            <div class="mb-0 text-[0.8125rem] text-[#232323] font-semibold dark:text-[#8c9097] dark:text-white/50">
                                                <a href="cart.html">Kikon Camera</a>
                                            </div>
                                            <div class="inline-flex">
                                                <span class="text-black !font-medium mb-1 dark:text-white">$4,999.00</span>
                                                <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove ltr:float-right rtl:float-left dropdown-item-close"><i
                                                    class="ti ti-trash"></i></a>
                                            </div>
                                            </div>
                                            <div class="min-w-fit flex items-start justify-between">
                                            <ul class="header-product-item flex">
                                                <li>Black</li>
                                                <li>50MM</li>
                                            </ul>
                                            </div>
                                        </div>
                                        </div>
                                    </li>
                                    <li class="ti-dropdown-item">
                                        <div class="flex items-start cart-dropdown-item">
                                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/ecommerce/jpg/6.jpg" alt="img"
                                            class="!h-[1.75rem] !w-[1.75rem] leading-[1.75rem] text-[0.65rem]  rounded-[50%] br-5 me-3">
                                        <div class="grow">
                                            <div class="flex items-start justify-between mb-0">
                                            <div class="mb-0 text-[0.8125rem] text-[#232323] font-semibold dark:text-[#8c9097] dark:text-white/50">
                                                <a href="cart.html">Canvas Shoes</a>
                                            </div>
                                            <div class="inline-flex">
                                                <span class="text-black !font-medium mb-1 dark:text-white">$129.00</span>
                                                <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove ltr:float-right rtl:float-left dropdown-item-close"><i
                                                    class="ti ti-trash"></i></a>
                                            </div>
                                            </div>
                                            <div class="flex items-start justify-between">
                                            <ul class="header-product-item flex">
                                                <li>Gray</li>
                                                <li>Sports</li>
                                            </ul>
                                            </div>
                                        </div>
                                        </div>
                                    </li>
                                    </ul>
                                    <div class="p-3 empty-header-item border-t">
                                    <div class="grid">
                                        <a href="checkout.html" class="w-full ti-btn ti-btn-primary-full p-2">Proceed to checkout</a>
                                    </div>
                                    </div>
                                    <div class="p-[3rem] empty-item hidden">
                                    <div class="text-center">
                                        <span class="!w-[4rem] !h-[4rem] !leading-[4rem] rounded-[50%] avatar bg-warning/10 !text-warning">
                                        <i class="ri-shopping-cart-2-line text-[2rem]"></i>
                                        </span>
                                        <h6 class="font-bold mb-1 mt-3 text-[1rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">Your Cart is Empty</h6>
                                        <span class="mb-3 !font-normal text-[0.8125rem] block text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">Add some items to make me happy :)</span>
                                        <a href="products.html" class="ti-btn ti-btn-primary btn-wave ti-btn-wave btn-sm m-1 !text-[0.75rem] !py-[0.25rem] !px-[0.5rem]"
                                        data-abc="true">continue shopping <i class="bi bi-arrow-right ms-1"></i></a>
                                    </div>
                                    </div>

                                </div>
                            </div> -->
                            <!--End Header cart item  -->

                            <!--Header Notifictaion -->
                            <!-- <div class="header-element py-[1rem] md:px-[0.65rem] px-2 notifications-dropdown header-notification hs-dropdown ti-dropdown !hidden md:!block [--placement:bottom-left]">
                                <button id="dropdown-notification" type="button"
                                    class="hs-dropdown-toggle relative ti-dropdown-toggle !p-0 !border-0 flex-shrink-0  !rounded-full !shadow-none align-middle text-xs">
                                    <i class="bx bx-bell header-link-icon  text-[1.125rem]"></i>
                                    <span class="flex absolute h-5 w-5 -top-[0.25rem] end-0  -me-[0.6rem]">
                                    <span
                                        class="animate-slow-ping absolute inline-flex -top-[2px] -start-[2px] h-full w-full rounded-full bg-secondary/40 opacity-75"></span>
                                    <span
                                        class="relative inline-flex justify-center items-center rounded-full  h-[14.7px] w-[14px] bg-secondary text-[0.625rem] text-white"
                                        id="notification-icon-badge">5</span>
                                    </span>
                                </button>
                                <div class="main-header-dropdown !-mt-3 !p-0 hs-dropdown-menu ti-dropdown-menu bg-white !w-[22rem] border-0 border-defaultborder hidden !m-0"
                                    aria-labelledby="dropdown-notification">

                                    <div class="ti-dropdown-header !m-0 !p-4 !bg-transparent flex justify-between items-center">
                                    <p class="mb-0 text-[1.0625rem] text-defaulttextcolor font-semibold dark:text-[#8c9097] dark:text-white/50">Notifications</p>
                                    <span class="text-[0.75em] py-[0.25rem/2] px-[0.45rem] font-[600] rounded-sm bg-secondary/10 text-secondary"
                                        id="notifiation-data">5 Unread</span>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <ul class="list-none !m-0 !p-0 end-0" id="header-notification-scroll">
                                    <li class="ti-dropdown-item dropdown-item ">
                                        <div class="flex items-start">
                                        <div class="pe-2">
                                            <span
                                            class="inline-flex text-primary justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem] !bg-primary/10 !rounded-[50%]"><i
                                                class="ti ti-gift text-[1.125rem]"></i></span>
                                        </div>
                                        <div class="grow flex items-center justify-between">
                                            <div>
                                            <p class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[0.8125rem] font-semibold"><a
                                                href="notifications.html">Your Order Has Been Shipped</a></p>
                                            <span class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Order No: 123456
                                                Has Shipped To Your Delivery Address</span>
                                            </div>
                                            <div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                                class="ti ti-x text-[1rem]"></i></a>
                                            </div>
                                        </div>
                                        </div>
                                    </li>
                                    <li class="ti-dropdown-item dropdown-item !flex-none">
                                        <div class="flex items-start">
                                        <div class="pe-2">
                                            <span
                                            class="inline-flex text-secondary justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-secondary/10 rounded-[50%]"><i
                                                class="ti ti-discount-2 text-[1.125rem]"></i></span>
                                        </div>
                                        <div class="grow flex items-center justify-between">
                                            <div>
                                            <p class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[0.8125rem]  font-semibold"><a
                                                href="notifications.html">Discount Available</a></p>
                                            <span class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Discount
                                                Available On Selected Products</span>
                                            </div>
                                            <div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit  text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                                class="ti ti-x text-[1rem]"></i></a>
                                            </div>
                                        </div>
                                        </div>
                                    </li>
                                    <li class="ti-dropdown-item dropdown-item">
                                        <div class="flex items-start">
                                        <div class="pe-2">
                                            <span
                                            class="inline-flex text-pink justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-pink/10 rounded-[50%]"><i
                                                class="ti ti-user-check text-[1.125rem]"></i></span>
                                        </div>
                                        <div class="grow flex items-center justify-between">
                                            <div>
                                            <p class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[0.8125rem]  font-semibold"><a
                                                href="notifications.html">Account Has Been Verified</a></p>
                                            <span class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Your Account Has
                                                Been Verified Sucessfully</span>
                                            </div>
                                            <div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                                class="ti ti-x text-[1rem]"></i></a>
                                            </div>
                                        </div>
                                        </div>
                                    </li>
                                    <li class="ti-dropdown-item dropdown-item">
                                        <div class="flex items-start">
                                        <div class="pe-2">
                                            <span
                                            class="inline-flex text-warning justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-warning/10 rounded-[50%]"><i
                                                class="ti ti-circle-check text-[1.125rem]"></i></span>
                                        </div>
                                        <div class="grow flex items-center justify-between">
                                            <div>
                                            <p class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50  text-[0.8125rem]  font-semibold"><a
                                                href="notifications.html">Order Placed <span class="text-warning">ID: #1116773</span></a></p>
                                            <span class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Order Placed
                                                Successfully</span>
                                            </div>
                                            <div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                                class="ti ti-x text-[1rem]"></i></a>
                                            </div>
                                        </div>
                                        </div>
                                    </li>
                                    <li class="ti-dropdown-item dropdown-item">
                                        <div class="flex items-start">
                                        <div class="pe-2">
                                            <span
                                            class="inline-flex text-success justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-success/10 rounded-[50%]"><i
                                                class="ti ti-clock text-[1.125rem]"></i></span>
                                        </div>
                                        <div class="grow flex items-center justify-between">
                                            <div>
                                            <p class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50  text-[0.8125rem]  font-semibold"><a
                                                href="notifications.html">Order Delayed <span class="text-success">ID: 7731116</span></a></p>
                                            <span class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Order Delayed
                                                Unfortunately</span>
                                            </div>
                                            <div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                                class="ti ti-x text-[1rem]"></i></a>
                                            </div>
                                        </div>
                                        </div>
                                    </li>
                                    </ul>

                                    <div class="p-4 empty-header-item1 border-t mt-2">
                                    <div class="grid">
                                        <a href="notifications.html" class="ti-btn ti-btn-primary-full !m-0 w-full p-2">View All</a>
                                    </div>
                                    </div>
                                    <div class="p-[3rem] empty-item1 hidden">
                                    <div class="text-center">
                                        <span class="!h-[4rem]  !w-[4rem] avatar !leading-[4rem] !rounded-full !bg-secondary/10 !text-secondary">
                                        <i class="ri-notification-off-line text-[2rem]  "></i>
                                        </span>
                                        <h6 class="font-semibold mt-3 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[1rem]">No New Notifications</h6>
                                    </div>
                                    </div>
                                </div>
                            </div> -->
                            
                            <!--End Header Notifictaion -->

                            <!-- Related Apps -->
                            <!-- <div class="header-element header-apps dark:text-[#8c9097] dark:text-white/50 py-[1rem] md:px-[0.65rem] px-2 hs-dropdown ti-dropdown md:!block !hidden [--placement:bottom-left]">

                                <button aria-label="button" id="dropdown-apps" type="button"
                                    class="hs-dropdown-toggle ti-dropdown-toggle !p-0 !border-0 flex-shrink-0  !rounded-full !shadow-none text-xs">
                                    <i class="bx bx-grid-alt header-link-icon text-[1.125rem]"></i>
                                </button>

                                <div
                                    class="main-header-dropdown !-mt-3 hs-dropdown-menu ti-dropdown-menu !w-[22rem] border-0 border-defaultborder   hidden"
                                    aria-labelledby="dropdown-apps">

                                    <div class="p-4">
                                        <div class="flex items-center justify-between">
                                            <p class="mb-0 text-defaulttextcolor text-[1.0625rem] dark:text-[#8c9097] dark:text-white/50 font-semibold">Related Apps</p>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider mb-0"></div>
                                    <div class="ti-dropdown-divider divide-y divide-gray-200 dark:divide-white/10 main-header-shortcuts p-2" id="header-shortcut-scroll">
                                        <div class="grid grid-cols-3 gap-2">
                                            <div class="">
                                                <a href="javascript:void(0);" class="p-4 items-center related-app block text-center rounded-sm hover:bg-gray-50 dark:hover:bg-black/20">
                                                    <div>
                                                    <img src="<?php echo base_url(''); ?>/application/views/assets/images/apps/figma.png" alt="figma"
                                                        class="!h-[1.75rem] !w-[1.75rem] text-2xl text-primary flex justify-center items-center mx-auto">
                                                    <div class="text-[0.75rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">Figma</div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="">
                                                <a href="javascript:void(0);" class="p-4 items-center related-app block text-center rounded-sm hover:bg-gray-50 dark:hover:bg-black/20">
                                                    <img src="<?php echo base_url(''); ?>/application/views/assets/images/apps/microsoft-powerpoint.png" alt="miscrosoft"
                                                    class="leading-[1.75] text-2xl !h-[1.75rem] !w-[1.75rem] align-middle flex justify-center mx-auto">
                                                    <div class="text-[0.75rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">Power Point</div>
                                                </a>
                                            </div>
                                            <div class="">
                                                <a href="javascript:void(0);" class="p-4 items-center related-app block text-center rounded-sm hover:bg-gray-50 dark:hover:bg-black/20">
                                                    <img src="<?php echo base_url(''); ?>/application/views/assets/images/apps/microsoft-word.png" alt="miscrodoftword"
                                                    class="leading-none
                                                    text-2xl !h-[1.75rem] !w-[1.75rem] align-middle flex justify-center mx-auto">
                                                    <div class="text-[0.75rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">MS Word</div>
                                                </a>
                                            </div>
                                            <div class="">
                                                <a href="javascript:void(0);" class="p-4 items-center related-app block text-center rounded-sm hover:bg-gray-50 dark:hover:bg-black/20">
                                                    <img src="<?php echo base_url(''); ?>/application/views/assets/images/apps/calender.png" alt="calander"
                                                    class="leading-none text-2xl !h-[1.75rem] !w-[1.75rem] align-middle flex justify-center mx-auto">
                                                    <div class="text-[0.75rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">Calendar</div>
                                                </a>
                                            </div>
                                            <div class="">
                                                <a href="javascript:void(0);" class="p-4 items-center related-app block text-center rounded-sm hover:bg-gray-50 dark:hover:bg-black/20">
                                                    <img src="<?php echo base_url(''); ?>/application/views/assets/images/apps/sketch.png" alt="apps"
                                                    class="leading-none text-2xl !h-[1.75rem] !w-[1.75rem] align-middle flex justify-center mx-auto">
                                                    <div class="text-[0.75rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">Sketch</div>
                                                </a>
                                            </div>
                                            <div class="">
                                                <a href="javascript:void(0);" class="p-4 items-center related-app block text-center rounded-sm hover:bg-gray-50 dark:hover:bg-black/20">
                                                    <img src="<?php echo base_url(''); ?>/application/views/assets/images/apps/google-docs.png" alt="docs"
                                                    class="leading-none text-2xl !h-[1.75rem] !w-[1.75rem] align-middle flex justify-center mx-auto">
                                                    <div class="text-[0.75rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">Docs</div>
                                                </a>
                                            </div>
                                            <div class="">
                                                <a href="javascript:void(0);" class="p-4 items-center related-app block text-center rounded-sm hover:bg-gray-50 dark:hover:bg-black/20">
                                                    <img src="<?php echo base_url(''); ?>/application/views/assets/images/apps/google.png" alt="google"
                                                    class="leading-none text-2xl !h-[1.75rem] !w-[1.75rem] align-middle flex justify-center mx-auto">
                                                    <div class="text-[0.75rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">Google</div>
                                                </a>
                                            </div>
                                            <div class="">
                                                <a href="javascript:void(0);" class="p-4 items-center related-app block text-center rounded-sm hover:bg-gray-50 dark:hover:bg-black/20">
                                                    <img src="<?php echo base_url(''); ?>/application/views/assets/images/apps/translate.png" alt="translate"
                                                    class="leading-none text-2xl !h-[1.75rem] !w-[1.75rem] align-middle flex justify-center mx-auto">
                                                    <div class="text-[0.75rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">Translate</div>
                                                </a>
                                            </div>
                                            <div class="">
                                                <a href="javascript:void(0);" class="p-4 items-center related-app block text-center rounded-sm hover:bg-gray-50 dark:hover:bg-black/20">
                                                    <img src="<?php echo base_url(''); ?>/application/views/assets/images/apps/google-sheets.png" alt="sheets"
                                                    class="leading-none text-2xl !h-[1.75rem] !w-[1.75rem] align-middle flex justify-center mx-auto">
                                                    <div class="text-[0.75rem] text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50">Sheets</div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4 first:pt-0 border-t">
                                        <a class="w-full ti-btn ti-btn-primary-full p-2 !m-0" href="javascript:void(0);">
                                            View All
                                        </a>
                                    </div>

                                </div>
                            </div> -->
                            <!--End Related Apps -->

                            <!-- Fullscreen -->
                            <div class="header-element header-fullscreen py-[1rem] md:px-[0.65rem] px-2">
                                <!-- Start::header-link -->
                                <a aria-label="anchor" onclick="openFullscreen();" href="javascript:void(0);"
                                    class="inline-flex flex-shrink-0 justify-center items-center gap-2  !rounded-full font-medium dark:hover:bg-black/20 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10">
                                    <i class="bx bx-fullscreen full-screen-open header-link-icon"></i>
                                    <i class="bx bx-exit-fullscreen full-screen-close header-link-icon hidden"></i>
                                </a>
                                <!-- End::header-link -->
                            </div>
                            <!-- End Full screen -->

                            <!-- Header Profile -->
                            <div class="header-element md:!px-[0.65rem] px-2 hs-dropdown !items-center ti-dropdown [--placement:bottom-left]">

                                <button id="dropdown-profile" type="button"
                                    class="hs-dropdown-toggle ti-dropdown-toggle !gap-2 !p-0 flex-shrink-0 sm:me-2 me-0 !rounded-full !shadow-none text-xs align-middle !border-0 !shadow-transparent ">
                                    <!--<img class="inline-block rounded-full " src="<?php echo base_url(''); ?>/application/views/assets/images/faces/9.jpg"  width="32" height="32" alt="Image Description">-->
                                    

                                     <!-- User Image -->

                                     <?php 
                                        $type = $this->session->userdata('type');
                                        if ($type == 'admin') { ?>

                                            <!-- Display admin-specific images -->
                                            <img class="inline-block rounded-full image-user" src="<?php echo base_url("uploads/company_logo/admin_user.jpg"); ?>" width="32" height="32"/>

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
                                </button>
                                <div class="md:block hidden dropdown-profile">
                                    <p class="font-semibold mb-0 leading-none text-[#536485] text-[0.813rem] "><?php echo $this->session->userdata('name');?></p>
                                    <!-- <span class="opacity-[0.7] font-normal text-[#536485] block text-[0.6875rem] ">Web Designer</span> -->
                                </div>
                                <div
                                    class="hs-dropdown-menu ti-dropdown-menu !-mt-3 border-0 w-[11rem] !p-0 border-defaultborder hidden main-header-dropdown  pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                                    aria-labelledby="dropdown-profile">

                                    <ul class="text-defaulttextcolor font-medium dark:text-[#8c9097] dark:text-white/50">
                                        <li>
                                            <a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0  !p-[0.65rem] !inline-flex" href="<?php echo base_url('profile'); ?>">
                                            <i class="ti ti-user-circle text-[1.125rem] me-2 opacity-[1.0]"></i>Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0  !p-[0.65rem] !inline-flex" href="<?php echo base_url('upgrade-plan'); ?>"><i
                                                class="ti ti-inbox text-[1.125rem] me-2 opacity-[1.0]"></i> Upgrade Plan
                                                <!-- <span
                                                class="!py-1 !px-[0.45rem] !font-semibold !rounded-sm text-success text-[0.75em] bg-success/10 ms-auto">25</span> -->
                                            </a>
                                        </li>
                                        <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0 !p-[0.65rem] !inline-flex" href="<?php echo base_url('extend-subscription'); ?>"><i
                                                class="ti ti-clipboard-check text-[1.125rem] me-2 opacity-[1.0]"></i>   Extend Subscription</a></li>
                                        <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0 !p-[0.65rem] !inline-flex" href="<?php echo base_url('viewUser'); ?>"><i
                                                class="ti ti-adjustments-horizontal text-[1.125rem] me-2 opacity-[1.0]"></i> View User</a></li>
                                        <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !gap-x-0 !p-[0.65rem] !inline-flex " href="<?php echo base_url('branches'); ?>"><i
                                                class="ti ti-wallet text-[1.125rem] me-2 opacity-[1.0]"></i>Branch</a></li>
                                        <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex" href="<?php echo base_url('change-password'); ?>"><i
                                                class="ti ti-headset text-[1.125rem] me-2 opacity-[1.0]"></i>Change Password</a></li>
                                        <li><a class="w-full ti-dropdown-item !text-[0.8125rem] !p-[0.65rem] !gap-x-0 !inline-flex" href="<?= base_url('login/logout'); ?>"><i
                                            class="ti ti-logout text-[1.125rem] me-2 opacity-[1.0]"></i>Log Out</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End Header Profile -->

                            <!-- Switcher Icon -->
                            <div class="header-element md:px-[0.48rem]">
                                <button aria-label="button" type="button"
                                    class="hs-dropdown-toggle switcher-icon inline-flex flex-shrink-0 justify-center items-center gap-2  rounded-full font-medium  align-middle transition-all text-xs dark:text-[#8c9097] dark:text-white/50 dark:hover:text-white dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                                    data-hs-overlay="#hs-overlay-switcher">
                                    <i class="bx bx-cog header-link-icon animate-spin-slow"></i>
                                </button>
                            </div>
                            <!-- Switcher Icon -->

                        </div>
                        <!-- End::header-element -->
                    </div>
                </nav>
            </header>
            <!-- END HEADER -->

            <!-- SIDEBAR -->

            
            <aside class="app-sidebar" id="sidebar">

                <!-- Start::main-sidebar-header -->
                <div class="main-sidebar-header">
                    <a href="index.html" class="header-logo" >
                        <img style="height:44px;" src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="desktop-logo">
                        <img style="height:44px;"src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="toggle-logo">
                        <img style="height:44px;"src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="desktop-dark">
                        <img style="height:44px;"src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="toggle-dark">
                        <img style="height:44px;"src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="desktop-white">
                        <img style="height:44px;"src="<?php echo base_url(''); ?>assets/img/team-logo.png" alt="logo" class="toggle-white">
                    </a>
                    <a href="<?php echo base_url('home') . ""; ?>" class="d-block" style="color:white; font-size:16px;">
                     <!-- <span>T</span> -->TEAM 365
                  </a>
                </div>
                <!-- End::main-sidebar-header -->

                <!-- Start::main-sidebar -->
                <div class="main-sidebar" id="sidebar-scroll">

                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills flex-column sub-open">
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                            </svg></div>
                        <ul class="main-menu">
                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Main</span></li>
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                            <?php if (empty($this->session->userdata('company_name')) && empty($_GET['cnp'])) {
                     if ($url != 'company') {
                       redirect(base_url('company'));
                     }
                     } ?>
                                <a  class="side-menu__item"  href="<?php echo base_url() . "home"; ?>" class="nav-link <?= ($page == 'home') ? "activeli" : null; ?>">
                                    <i class="bx bx-home side-menu__icon"></i>
                                    <span class="side-menu__label">Dashboards
                                          </span>
                                </a>
                                <ul class="slide-menu child1">
                                    <!-- <li class="slide side-menu__label1">
                                        <a  href="<?php echo base_url() . "home"; ?>" class="nav-link <?= ($page == 'home') ? "activeli" : null; ?>">Dashboards</a>
                                    </li> -->
                                    
                                </ul>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Pages</span></li>
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <?php 
                            if ($type == "admin") {  ?>
                            <li class="slide has-sub">
                                <a  class="side-menu__item" <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("activities") . '"'; ?> class="nav-link <?= ($page == 'activities') ? "activeli" : null; ?>">
                                    <i class="bx bx-file-blank side-menu__icon"></i>
                                    <span class="side-menu__label">Activities
                                      
                                      </span>
                                    
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1"><a href="javascript:void(0)">Activities</a></li>
                                    
                                </ul>
                            </li>
                            <?php  } if ($type == "admin" || $this->session->userdata('userType') == 'Sales Person' || $this->session->userdata('userType') == 'Sales Manager') {   ?>
                  <?php if (in_array("Create Customers", $mdl) ||  in_array("Create Contacts", $mdl)) {?>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-task side-menu__icon"></i>
                                    <span class="side-menu__label">Essentials
                                      
                                      </span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Essentials</a>
                                    </li>
                                    <?php if (in_array("Create Customers", $mdl)) { ?>
                                    <li class="slide">
                                        <a  class="side-menu__item" href="<?php echo base_url() . "organizations"; ?>" class="nav-link <?= ($page == 'organizations' || $page == 'view-customer') ? "activeli" : null; ?>">Organizations</a>
                                    </li>
                                    <?php }
                           if (in_array("Create Contacts", $mdl)) { ?>
                                    <li class="slide">
                                        <a  class="side-menu__item" href="<?php echo base_url() . "contacts"; ?>" class="nav-link <?= ($page == 'contacts') ? "activeli" : null; ?>">Contacts</a>
                                    </li>
                                    <?php } ?>
                        <?php if ($type == "admin") {  ?>
                                    <li class="slide">
                                        <a class="side-menu__item" href="<?php echo base_url() . "find-duplicate"; ?>" class="nav-link <?= ($page == 'find-duplicate') ? "activeli" : null; ?>">Find Duplicates</a>
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
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-fingerprint side-menu__icon"></i>
                                    <span class="side-menu__label"> Sales</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                               
                                    <li class="slide side-menu__label1"><a href="javascript:void(0)"> Sales</a></li>
                                    <?php if (in_array("Lead Generation", $mdl)) { ?>
                                    <li class="slide"><a  class="side-menu__item" href="<?php echo base_url() . "leads"; ?>" class="nav-link <?= ($page == 'leads' || $page == 'add-lead') ? "activeli" : null; ?>">Leads</a></li>
                                    <?php }
                           if (in_array("Create Opportunities", $mdl)) { ?>
                                    <li class="slide"><a  class="side-menu__item" href="<?php echo base_url() . "opportunities"; ?>" class="nav-link <?= ($page == 'opportunities' || $page == 'add-opportunity') ? "activeli" : null; ?>">Opportunity</a></li>
                                    <?php }
                           if (in_array("Create Quotation", $mdl)) { ?>
                                    <li class="slide"><a  class="side-menu__item" href="<?php echo base_url() . "quotation"; ?>" class="nav-link <?= ($page == 'quotation' || $page == 'add-quote') ? "activeli" : null; ?>">Quotations</a></li>
                                    <?php }
                           if (in_array("Create Salesorder", $mdl)) { ?>
                                    <li class="slide"><a  class="side-menu__item" href="<?php echo base_url() . "salesorders"; ?>" class="nav-link <?= ($page == 'salesorders' || $page == 'add-salesorder') ? "activeli" : null; ?>">Sales Orders</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <?php }
                     }
                     if ($this->session->userdata('type') == 'admin') {
                       if (in_array("Create Followup", $mdl)) { ?>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-error side-menu__icon"></i>
                                    <span class="side-menu__label">Follow Up</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Follow Up</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "task"; ?>" <?php } ?> class="nav-link <?= ($url == 'task') ? "activeli" : null; ?>">Task</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "meeting"; ?>" <?php } ?> class="nav-link <?= ($url == 'meeting') ? "activeli" : null; ?>">Meeting</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "call"; ?>" <?php } ?> class="nav-link <?= ($url == 'call') ? "activeli" : null; ?>">Call</a>
                                    </li>
                                </ul>
                            </li>
                            <?php }
                     } ?>
                            <!-- End::slide -->

                            <!-- Start::slide__category -->
                            <!-- <li class="slide__category"><span class="category-name">General</span></li> -->
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <?php if (in_array("Inventory", $mdl)) { ?>
                           
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-box side-menu__icon"></i>
                                    <span class="side-menu__label">Inventory</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1 mega-menu">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Inventory</a>
                                    </li>
                                    <?php if (in_array("Inventory", $mdl)) { ?>
                        <?php if ($this->session->userdata('type') == 'admin') { ?>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "product-manager"; ?>" <?php } ?> class="nav-link <?php if ($page == 'product-manager') {
                              echo "activeli";
                              } ?>">Product Managers</a>
                                    </li>
                                    <?php } ?>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "vendors"; ?>" <?php } ?> class="nav-link <?php if ($page == 'vendors' || $page == 'view-vendor') {
                              echo "activeli";
                              } ?>">Purchase Orders</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "purchaseorders"; ?>" <?php } ?> class="nav-link <?php if ($page == 'purchaseorders' || $page == 'add-purchase-order') {
                              echo "activeli";
                              } ?>">Vendors</a>
                                    </li>
                                    <li class="slide">
                                        <a class="side-menu__item"  <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "subpurchaseorders"; ?>" <?php } ?> class="nav-link <?php if ($page == 'subpurchaseorders' || $page = 'add-subpurchaseorder') {
                              echo "activeli";
                              } ?>">Subscription PO</a>
                                    </li>
                        
                                    <?php }  ?>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <?php } ?>
                  
                  <!-- starts -->
                  <?php if ($this->session->userdata('type')=='admin'){ ?>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-medal side-menu__icon"></i>
                                    <span class="side-menu__label">Accounting
                                    <span
                                        class="text-secondary text-[0.75em] rounded-sm badge !py-[0.25rem] !px-[0.45rem] !bg-secondary/10 ms-2">New</span>
                                    </span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Accounting</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("invoices") . '"'; ?> class="nav-link <?= ($page == 'invoices' || $page == 'add-invoice') ? 'activeli' : null; ?>">Invoice</a>
                                    </li>
                                    <?php if (in_array("Inventory", $mdl)) { ?>
                           <?php if ($this->session->userdata('type') == 'admin') { ?>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "proforma_invoice"; ?>" <?php } ?> class="nav-link <?php if ($url == 'proforma_invoice') { ?> activeli <?php } ?>">Performa Invoice </a>
                                    </li>
                                    <?php } ?>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "accounting-report"; ?>" <?php } ?> class="nav-link <?php if ($page == 'Accountingreport' || $page == 'view-vendor') {
                                 echo "activeli";
                                 } ?>">Accounting Report</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "expanse-manage"; ?>" <?php } ?> class="nav-link <?php if ($page == 'expansemanage' || $page == 'add-purchase-order') {
                                 echo "activeli";
                                 } ?>">Expanse Management</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "payment-reciept"; ?>" <?php } ?> class="nav-link <?php if ($page == 'Reciept' || $page == 'add-Reciept') {
                                 echo "activeli";
                                 } ?>">Payment Reciept</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "delivery-Chalan"; ?>" <?php } ?> class="nav-link <?php if ($page == 'Chalan' || $page == 'add-Chalan') {
                                 echo "activeli";
                                 } ?>">Delivery Chalan</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "credit-note"; ?>" <?php } ?> class="nav-link <?php if ($page == 'creditnote' || $page == 'add-creditnote') {
                                 echo "activeli";
                                 } ?>">Credit Note</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "debit-note"; ?>" <?php } ?> class="nav-link <?php if ($page == 'debitnote' || $page == 'add-debitnote') {
                                 echo "activeli";
                                 } ?>">Debit Note</a>
                                    </li>
                                    <?php }  ?>
                                </ul>
                            </li>

                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <?php } ?>
               <!-- ends -->
                   <?php  if ($this->session->userdata('type') == 'admin') { ?>
                  <?php if (in_array("Email Marketing", $mdl)) { ?>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-file  side-menu__icon"></i>
                                    <span class="side-menu__label">Marketing</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Marketing</a>
                                    </li>
                                    
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "email-marketing"; ?>" <?php } ?> class="nav-link <?php if ($url == 'email-marketing') { ?> activeli <?php } ?>">Email Marketing</a>
                                    </li>
                                    
                                    <li class="slide">
                                        <a class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "sent-email"; ?>" <?php } ?> class="nav-link <?php if ($url == 'sent-email') { ?> activeli <?php } ?>">Sent Mail</a>
                                    </li>
                                    
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <?php }
                     } ?>
                  <?php if (in_array("Create Report", $mdl) || in_array("Forecast and Quota", $mdl)) { ?>

                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-party side-menu__icon"></i>
                                    <span class="side-menu__label">Report</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                <?php if (in_array("Create Report", $mdl)) { ?>
                                    <li class="slide side-menu__label1"><a href="javascript:void(0)">Report</a></li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "reports"; ?>" <?php } ?> class="nav-link <?php if ($page == 'reports') {
                              echo "activeli";
                              } ?>">Report</a>
                                    </li>
                                    <?php }
                           if (in_array("Forecast and Quota", $mdl)) { ?>
                                    <li class="slide"><a class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "forecast"; ?>" <?php } ?> class="nav-link <?php if ($page == 'forecast') {
                              echo "activeli";
                              } ?>">Forecast & Quota</a></li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "sales-profit-target"; ?>" <?php } ?> class="nav-link <?php if ($page == 'sales-profit-target') {
                              echo "activeli";
                              } ?>">Sales-Profit Target</a>
                                    </li>
                                    
                                    <?php } ?>

                                </ul>
                            </li>
                            <!-- End::slide -->

                            <?php } if ($type == "admin") { ?>

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <i class="bx bx-grid-alt side-menu__icon"></i>
                                    <span class="side-menu__label">Setting
                                     
                                      </span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Setting</a>
                                    </li>
                                    <li class="slide">
                                        <a class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "roles"; ?>" <?php } ?> class="nav-link <?php if ($url == 'roles') { ?> activeli <?php } ?>">Roles</a>
                                    </li>
                                    <?php if (in_array("Tax", $mdl)) { ?>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "gst"; ?>" <?php } ?> class="nav-link <?php if ($url == 'gst') { ?> activeli <?php } ?>">Add GST</a>
                                    </li>
                                    <?php }
                           if (in_array("Integrations", $mdl)) { ?>
                                    <li class="slide">
                                        <a class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "integration"; ?>" <?php } ?> class="nav-link <?php if ($url == 'integration') { ?> activeli <?php } ?>">Integration</a>
                                    </li>
                                    <?php }
                           if (in_array("Create Workflow", $mdl)) { ?>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "workflows"; ?>" <?php } ?> class="nav-link <?php if ($url == 'workflows') { ?> activeli <?php } ?>">Workflows</a>
                                    </li>
                                    <?php }
                           if (in_array("Set User Target", $mdl)) { ?>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "target"; ?>" <?php } ?> class="nav-link <?php if ($page == 'target') {
                              echo "activeli";
                              } ?>">User Target</a>
                                    </li>
                                    <?php } ?>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "set-prefix"; ?>" <?php } ?> class="nav-link <?php if ($url == 'set-prefix') { ?> activeli <?php } ?>">Set Prefix ID</a>
                                    </li>
                                    <li class="slide">
                                        <a  class="side-menu__item" <?php if ($this->session->userdata('account_type') == 'End') { ?> onclick="add_modal()" <?php } else {  ?> href="<?php echo base_url() . "state-list"; ?>" <?php } ?> class="nav-link <?php if ($url == 'state-list') { ?> activeli <?php } ?>">State List</a>
                                    </li>

                                    
                                   
                                </ul>
                                
                                  <li class="slide has-sub">
                                    <a  class="side-menu__item" <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("customreports") . '"'; ?> class="nav-link <?= ($page == 'customreports') ? "activeli" : null; ?>">
                                        <i class="bx bx-file-blank side-menu__icon"></i>
                                        <span class="side-menu__label">Bussiness Insights
                                          
                                          </span>
                                        
                                    </a>
                                    <ul class="slide-menu child1">
                                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Bussiness Insights</a></li>
                                        
                                    </ul>
                                </li>
                                
                                
                                 <li class="slide has-sub">
                                    <a  class="side-menu__item" <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("aifilters") . '"'; ?> class="nav-link <?= ($page == 'aifilters') ? "activeli" : null; ?>">
                                        <i class="bx bx-file-blank side-menu__icon"></i>
                                        <span class="side-menu__label"> AI Filter
                                          
                                          </span>
                                        
                                    </a>
                                    <ul class="slide-menu child1">
                                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Bussiness Insights</a></li>
                                        
                                    </ul>
                                </li>
                                
                                
                            <!--     <li class="slide has-sub">-->
                            <!--    <a href="javascript:void(0);" class="side-menu__item">-->
                            <!--    <i class="fa-solid fa-filter"></i> -->
                            <!--        <span class="side-menu__label"> &nbsp; AI Filter </span>-->
                            <!--        <i class="fe fe-chevron-right side-menu__angle"></i>-->
                            <!--    </a>-->
                            <!--    <ul class="slide-menu child1">-->
                            <!--    <?php if (in_array("Create Report", $mdl)) { ?>-->
                                  
                            <!--        <li class="slide">-->
                            <!--            <a  class="side-menu__item" <?= ($this->session->userdata('account_type') == 'End') ? 'onclick="add_modal()"' : 'href="' . base_url("aifilters") . '"'; ?> class="nav-link <?= ($page == 'aifilters') ? "activeli" : null; ?>"> ai filter </a>-->
                            <!--        </li>-->
                            <!--        <?php } ?>-->
                                   

                            <!--    </ul>-->
                            <!--</li>-->




                            
                            </li>
                            </li>
                            <?php } ?>
                  <?php ?>
                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                            </svg>
                        </div>
                    </nav>
                    <!-- End::nav -->

                </div>
                <!-- End::main-sidebar -->

            </aside>
            <!-- END SIDEBAR -->

            <!-- MAIN-CONTENT -->
            <div class="content">
              <div class="container-fluid">
                <div class="main-content">
            
                    
                  <!-- Start::page-header -->
                  <div class="md:flex block items-center justify-between my-[1.5rem] page-header-breadcrumb">
                    <div class="flex items-center" style="align-items: baseline;"> <!-- Added inline style for alignment -->
                        <p class="font-semibold text-[1.125rem] text-defaulttextcolor dark:text-defaulttextcolor/70 !mb-0" id="greeting">
                            Welcome back, <?php echo $this->session->userdata('name');?> !
                        </p>
                        <img src="<?php echo base_url(''); ?>/application/views/assets/images/faces/00.png" alt=""
                             class="w-[1.75rem] h-[1.75rem] leading-[1.75rem] text-[0.65rem] rounded ml-2">
                             
                    </div>
    
                </div>
                    <p class="font-normal text-[#8c9097] dark:text-white/50 text-[0.813rem] ml-2" style="margin-top:-24px;margin-left:-2px;">
                        Track your sales activity, leads and deals here.
                    </p>

                <div class="flex items-center justify-start" style="font-size:16px; margin:12px 0px;"> <!-- Container for anchor tags -->
                <a href="<?= base_url('add-salesorder')?>" style="margin-right: 7%;"><i class="fa-solid fa-bolt-lightning" style="color: #74C0FC;"></i>  Quick Order</a> <!-- Added inline style for right margin -->
                
                    <a href="<?php echo base_url('add-quote');?>" style="margin-right: 7%;"><i class="fa-solid fa-table-list" style="color: #74C0FC;"></i>  Start quote </a> <!-- Added inline style for right margin -->
                
                    <a href="<?php echo base_url('customreports');?>"><i class="fa-solid fa-chart-line" style="color: #74C0FC;"></i>  Business Insights </a>
                
                </div>

                    <div class="btn-list md:mt-0 mt-2">
                      <!-- <button type="button"
                        class="ti-btn bg-primary text-white btn-wave !font-medium !me-[0.375rem] !ms-0 !text-[0.85rem] !rounded-[0.35rem] !py-[0.51rem] !px-[0.86rem] shadow-none">
                        <i class="ri-filter-3-fill  inline-block"></i>Filters
                      </button>
                      <button type="button"
                        class="ti-btn ti-btn-outline-secondary btn-wave !font-medium  !me-[0.375rem]  !ms-0 !text-[0.85rem] !rounded-[0.35rem] !py-[0.51rem] !px-[0.86rem] shadow-none">
                        <i class="ri-upload-cloud-line  inline-block"></i>Export
                      </button> -->
                    </div>
                  </div>
                  
                  
                  <!-- End::page-header -->
                <script>
                    // Get the current hour
                    var hour = new Date().getHours();
                    var greeting = "";
                
                    // Define the greeting based on the time of day
                    if (hour >= 5 && hour < 12) {
                        greeting = "Good morning";
                    } else if (hour >= 12 && hour < 17) {
                        greeting = "Good afternoon";
                    } else if (hour >= 17 && hour < 20) {
                        greeting = "Good evening";
                    } else {
                        greeting = "Good night";
                    }
                
                    // Update the greeting message in the HTML
                    document.getElementById("greeting").innerHTML = greeting + ", <?php echo $this->session->userdata('name');?> !";
                </script>
                
                
                
                  <div class="grid grid-cols-12 gap-x-6">
                    <div class="xxl:col-span-9 xl:col-span-12  col-span-12">
                      <div class="grid grid-cols-12 gap-x-6">
                        <div class="xxl:col-span-4 xl:col-span-4  col-span-12">
                          <div class="xxl:col-span-12 xl:col-span-12 col-span-12">
                            <div class="box crm-highlight-card">
                              <div class="box-body">
                                <div class="flex items-center justify-between">
                                  <div>
                                    <div class="font-semibold text-[1.125rem] text-white mb-2" id="targetstatus_define">Your sales target is incomplete</div>
                                    <span class="block text-[0.75rem] text-white"><span class="opacity-[0.7]">You have
                                        completed</span>
                                      <span class="font-semibold text-warning" id="profitscore"></span> <span class="opacity-[0.7]">of the given
                                        target, you can also check your status</span>.</span>
                                    <span class="block font-semibold mt-[0.125rem]"><a class="text-white text-[0.813rem]"
                                        href="javascript:void(0);"><u>Click
                                          here</u></a></span>
                                  </div>
                                  <div>
                                    <div id="crm-main"></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          

                              <?php
                                      $fifteen = strtotime("-15 Day"); 
                                       $thirty = strtotime("-30 Day"); 
                                       $fortyfive = strtotime("-45 Day"); 
                                       $sixty = strtotime("-60 Day"); 
                                       $ninty = strtotime("-90 Day"); 
                                       $six_month = strtotime("-180 Day"); 
                                       $one_year = strtotime("-365 Day");
                                ?>

                          <div class="xxl:col-span-12 xl:col-span-12 col-span-12">
                            <div class="box">
                              <div class="box-header flex justify-between">
                                <div class="box-title">
                                  Top Deals
                                </div>
                                <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    <span id="selectedFilter">View</span><i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <input type="hidden" id="topcus_filter" value="" name="topcus_filter">
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">        
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','gettoptencus','topcus_filter');setSelectedFilter('-15 days');">Last 15 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>' ,'gettoptencus','topcus_filter');setSelectedFilter('-30 days');">Last 30 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>' ,'gettoptencus','topcus_filter');setSelectedFilter('-45 days');">Last 45 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>' ,'gettoptencus','topcus_filter');setSelectedFilter('-60 days');">Last 60 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>' ,'gettoptencus','topcus_filter');setSelectedFilter('-90 days');">Last 90 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>' ,'gettoptencus','topcus_filter');setSelectedFilter('-180 days');">Last 180 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>' ,'gettoptencus','topcus_filter');setSelectedFilter('Last 1 year');">Last 1 year</a></li>
                                  </ul>
                                </div>
                             

                              <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    <span id="selectedFilterYears">Years</span><i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <input type="hidden" id="topcus_year" value="" name="topcus_year">
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                  <?php foreach ($dateyrGraph as $key => $value) {
                                      $dataU = $value->month;
                                      $date = date_create("01-01-" . $dataU);
                                      $year = ($date != null) ? date_format($date, "Y") : null;
                                  ?>
                                    <li onclick="updateSelectedFilter('<?= $year; ?>', 'selectedFilterYears');getfilterdData('<?= $year; ?>','gettoptencus','topcus_year');"><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" <?= (date('Y') == $year) ? "aria-current=\"true\"" : null; ?>><?= $year; ?></a></li>
                                  <?php } ?>
                                  </ul>
                              </div>
                           
                              
                              <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    <span id="selectedFilterMonths">Months</span><i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <input type="hidden" id="topcus_month" value="" name="topcus_month">
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                  <?php foreach ($datemnthGraph as $key => $value) {
                                     $dataU = $value->month;
                                     $date = date_create('01-' . $dataU . '-2020');
                                     $dayMnt = ($date != null) ? date_format($date, "F") : null;
                                     $dayMnt2 = ($date != null) ? date_format($date, "m") : null;
                                 ?>
                                    <li onclick="updateSelectedFiltermonth('<?= $dayMnt; ?>', 'selectedFilterMonths');getfilterdData('<?= $dayMnt2; ?>','gettoptencus','topcus_month');"><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                            href="javascript:void(0);" <?= (date('F') == $dayMnt) ? "aria-current=\"true\"" : null; ?>>
                                            <?= $dayMnt; ?></a></li>
                                 <?php } ?>
                                  </ul>
                              </div>

                                
                              </div>
                           
                                <ul class="list-none crm-top-deals mb-0" id="toptencust" style="margin:6px;">
                                  
                                </ul>
                              
                            </div>
                          </div>
                                    
                        </div>

                        
                        <div class="xxl:col-span-8  xl:col-span-8  col-span-12">
                          <div class="grid grid-cols-12 gap-x-6">
                            <div class="xxl:col-span-6 xl:col-span-6 col-span-12">
                              <div class="box overflow-hidden">
                                <div class="box-body">
                                  <div class="flex items-top justify-between">
                                    <div>
                                      <span
                                        class="!text-[0.8rem]  !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !rounded-full inline-flex items-center justify-center bg-primary">
                                        <i class="ti ti-users text-[1rem] text-white"></i>
                                      </span>
                                    </div>
                                    <div class="flex-grow ms-4">
                                      <div class="flex items-center justify-between flex-wrap">
                                        <div>
                                          <p class="text-[#8c9097] dark:text-white/50 text-[0.813rem] mb-0">Total Customers</p>
                                          <h4 class="font-semibold  text-[1.5rem] !mb-2 "><?= IND_money_format($total_org['total_org']); ?></h4>
                                        </div>
                                        <div id="crm-total-customers"></div>
                                      </div>
                                      <div class="flex items-center justify-between !mt-1">
                                        <div>
                                          <a class="text-primary text-[0.813rem]" href="<?= base_url(''); ?>organizations">View All<i
                                              class="ti ti-arrow-narrow-right ms-2 font-semibold inline-block"></i></a>
                                        </div>
                                        <div class="text-end">
                                          <p class="mb-0 text-success text-[0.813rem] font-semibold" id="custincrpercent"></p>
                                          <p class="text-[#8c9097] dark:text-white/50 opacity-[0.7] text-[0.6875rem]">this month</p>
                                        </div>
                                      </div>
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="xxl:col-span-6 xl:col-span-6 col-span-12">
                              <div class="box overflow-hidden">
                                <div class="box-body">
                                  <div class="flex items-top justify-between">
                                      
                                    <div>
                                      <span
                                        class="!text-[0.8rem]  !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !rounded-full inline-flex items-center justify-center bg-secondary">
                                        <i class="ti ti-wallet text-[1rem] text-white"></i>
                                      </span>
                                    </div>
                                    <div class="flex-grow ms-4">
                                      <div class="flex items-center justify-between flex-wrap">
                                        <div>
                                          <p class="text-[#8c9097] dark:text-white/50 text-[0.813rem] mb-0">Total Leads</p>
                                          <h4 class="font-semibold text-[1.5rem] !mb-2 "><?= IND_money_format($total_leads['total_leads']); ?></h4>
                                        </div>
                                        <div id="crm-total-revenue"></div>
                                      </div>
                                      <div class="flex items-center justify-between mt-1">
                                        <div>
                                          <a class="text-secondary text-[0.813rem]" href="<?= base_url(''); ?>leads">View All<i
                                              class="ti ti-arrow-narrow-right ms-2 font-semibold inline-block"></i></a>
                                        </div>
                                        <div class="text-end">
                                          <p class="mb-0 text-success text-[0.813rem] font-semibold" id="leadincrpercent"></p>
                                          <p class="text-[#8c9097] dark:text-white/50 opacity-[0.7] text-[0.6875rem]">this month</p>
                                        </div>
                                      </div>
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class="xxl:col-span-6 xl:col-span-6 col-span-12">
                              <div class="box overflow-hidden">
                                <div class="box-body">
                                  <div class="flex items-top justify-between">
                                    <div>
                                      <span
                                        class="!text-[0.8rem]  !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !rounded-full inline-flex items-center justify-center bg-success">
                                        <i class="ti ti-wave-square text-[1rem] text-white"></i>
                                      </span>
                                    </div>
                                    <div class="flex-grow ms-4">
                                      <div class="flex items-center justify-between flex-wrap">
                                        <div>
                                          <p class="text-[#8c9097] dark:text-white/50 text-[0.813rem] mb-0">Total Opportunities</p>
                                          <h4 class="font-semibold text-[1.5rem] !mb-2 "><?= IND_money_format($total_opp['total_opp']); ?></h4>
                                        </div>
                                        <div id="crm-conversion-ratio"></div>
                                      </div>
                                      <div class="flex items-center justify-between mt-1">
                                        <div>
                                          <a class="text-success text-[0.813rem]" href="<?= base_url(''); ?>opportunities">View All<i
                                              class="ti ti-arrow-narrow-right ms-2 font-semibold inline-block"></i></a>
                                        </div>
                                        <div class="text-end">
                                          <p class="mb-0 text-danger text-[0.813rem] font-semibold" id="oppincrpercent"></p>
                                          <p class="text-[#8c9097] dark:text-white/50 opacity-[0.7] text-[0.6875rem]">this month</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="xxl:col-span-6 xl:col-span-6 col-span-12">
                              <div class="box overflow-hidden">
                                <div class="box-body">
                                  <div class="flex items-top justify-between">
                                    <div>
                                      <span
                                        class="!text-[0.8rem]  !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !rounded-full inline-flex items-center justify-center bg-warning">
                                        <i class="ti ti-briefcase text-[1rem] text-white"></i>
                                      </span>
                                    </div>
                                    <div class="flex-grow ms-4">
                                      <div class="flex items-center justify-between flex-wrap">
                                        <div>
                                          <p class="text-[#8c9097] dark:text-white/50 text-[0.813rem] mb-0">Total Quotations</p>
                                          <h4 class="font-semibold text-[1.5rem] !mb-2 "><?= IND_money_format($total_quotes['total_quotes']); ?></h4>
                                        </div>
                                        <div id="crm-total-deals"></div>
                                      </div>
                                      <div class="flex items-center justify-between mt-1">
                                        <div>
                                          <a class="text-warning text-[0.813rem]" href="<?= base_url(''); ?>quotation">View All<i
                                              class="ti ti-arrow-narrow-right ms-2 font-semibold inline-block"></i></a>
                                        </div>
                                        <div class="text-end">
                                          <p class="mb-0 text-success text-[0.813rem] font-semibold" id="quoteincrpercent"></p>
                                          <p class="text-[#8c9097] dark:text-white/50  opacity-[0.7] text-[0.6875rem]">this month</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="xxl:col-span-12 xl:col-span-12 col-span-12">
                            <div class="box">
                              <div class="box-header justify-between">
                                <div class="box-title">Profit Earned</div>

                                <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    <span id="selectedFilterprofit">View</span><i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <input type="hidden" id="profit_filter_new" value="<?= date('Y-m-d',strtotime("-30 Day")); ?>" name="profit_filter_new">
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu"> 
                                  
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','getChartData','profit_filter_new');setSelectedFilterprofit('-15 days');">Last 15 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>' ,'getChartData','profit_filter_new');setSelectedFilterprofit('-30 days');">Last 30 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>' ,'getChartData','profit_filter_new');setSelectedFilterprofit('-45 days');">Last 45 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>' ,'getChartData','profit_filter_new');setSelectedFilterprofit('-60 days');"">Last 60 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>' ,'getChartData','profit_filter_new');setSelectedFilterprofit('-90 days');"">Last 90 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>' ,'getChartData','profit_filter_new');setSelectedFilterprofit('-180 days');"">Last 180 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>' ,'getChartData','profit_filter_new');setSelectedFilterprofit('Last 1 year');"">Last 1 year</a></li>
                                  </ul>
                                </div>
                              
                             

                              <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    <span id="selectedFilterYearsprofit">Years</span><i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <input type="hidden" name="so_frofit_year" value="<?=date('Y');?>"id="so_frofit_year">
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                    
                                  <?php foreach ($dateyrGraph as $key => $value) {
                                      $dataU = $value->month;
                                      $date = date_create("01-01-" . $dataU);
                                      $year = ($date != null) ? date_format($date, "Y") : null;
                                  ?>
                                      <li onclick="updateSelectedFilterprofit('<?= $year; ?>', 'selectedFilterYearsprofit');getfilterdData('<?= $year; ?>','getChartData','so_frofit_year');"><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" <?= (date('Y') == $year) ? "aria-current=\"true\"" : null; ?>><?= $year; ?></a></li>
                                  <?php } ?>
                                  </ul>
                              </div>
                           
                              
                              <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    <span id="selectedFilterMonthsprofit">Months</span><i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <input  type="hidden" value="<?= date('m');?>" name="so_frofit_month" id="so_frofit_month">
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                  <?php foreach ($datemnthGraph as $key => $value) {
                                     $dataU = $value->month;
                                     $date = date_create('01-' . $dataU . '-2020');
                                     $dayMnt = ($date != null) ? date_format($date, "F") : null;
                                     $dayMnt2 = ($date != null) ? date_format($date, "m") : null;
                                 ?>
                                     <li onclick="updateSelectedFiltermonthprofit('<?= $dayMnt; ?>', 'selectedFilterMonthsprofit');getfilterdData('<?= $dayMnt2; ?>','getChartData','so_frofit_month');"><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                            href="javascript:void(0);" <?= (date('F') == $dayMnt) ? "aria-current=\"true\"" : null; ?>>
                                            <?= $dayMnt; ?></a></li>
                                 <?php } ?>
                                  </ul>
                              </div>

                              </div>
                              
                              <div class="box-body !py-0 !ps-0">
                                <div id="profit"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                                 
                        
                       
                    <div class="xxl:col-span-12 xl:col-span-12 col-span-12">
                              <div class="box">

                                <div class="box-header !gap-0 !m-0 justify-between">
                                  <div class="box-title">
                                    Revenue Analytics
                                  </div>

                                  <div class="hs-dropdown ti-dropdown">
                                  
                                  </div>
                              

                                  <div class="hs-dropdown ti-dropdown">
                                      <!-- <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                        aria-expanded="false">
                                        Years<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                      </a>
                                      <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                      <?php foreach ($dateyrGraph as $key => $value) {
                                          $dataU = $value->month;
                                          $date = date_create("01-01-" . $dataU);
                                          $year = ($date != null) ? date_format($date, "Y") : null;
                                      ?>
                                          <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                                  href="javascript:void(0);" <?= (date('Y') == $year) ? "aria-current=\"true\"" : null; ?>><?= $year; ?></a></li>
                                      <?php } ?>
                                      </ul> -->
                                  </div>
                           
                              
                                <div class="hs-dropdown ti-dropdown">
                                    <!-- <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                      aria-expanded="false">
                                      Months<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                    </a>
                                    <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                    <?php foreach ($datemnthGraph as $key => $value) {
                                      $dataU = $value->month;
                                      $date = date_create('01-' . $dataU . '-2020');
                                      $dayMnt = ($date != null) ? date_format($date, "F") : null;
                                      $dayMnt2 = ($date != null) ? date_format($date, "m") : null;
                                  ?>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" <?= (date('F') == $dayMnt) ? "aria-current=\"true\"" : null; ?>>
                                              <?= $dayMnt; ?></a></li>
                                  <?php } ?>
                                    </ul> -->
                                </div>
                                </div>
                                <div class="box-body !py-5">
                                  <div id="chart-line"></div> 
                                </div>
                              </div>
                            </div>
                          </div>
                                  
                          <div class="xxl:col-span-12 xl:col-span-12 col-span-12">
                          
                          <div class="box custom-card">
                            <div class="box-header justify-between">
                              <div class="box-title">
                                Deals Statistics
                              </div>
                              <div class="flex flex-wrap gap-2">
                                <!-- <div>
                                  <input class="ti-form-control form-control-sm" type="text" placeholder="Search Here"
                                    aria-label=".form-control-sm example">
                                </div> -->

                                <div class="hs-dropdown ti-dropdown">
                                  <!-- <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    View<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">        
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-15 Day")) ?>')">Last 15 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-30 Day")) ?>')">Last 30 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-45 Day")) ?>')">Last 45 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-60 Day")) ?>')">Last 60 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-900 Day")) ?>')">Last 3 months</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-180 Day")) ?>')">Last 6 months</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-365 Day")) ?>')">Last 1 year</a></li>
                                  </ul> -->
                                </div>
                             

                              <div class="hs-dropdown ti-dropdown">
                                  <!-- <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    Years<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                  <?php foreach ($dateyrGraph as $key => $value) {
                                      $dataU = $value->month;
                                      $date = date_create("01-01-" . $dataU);
                                      $year = ($date != null) ? date_format($date, "Y") : null;
                                  ?>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" <?= (date('Y') == $year) ? "aria-current=\"true\"" : null; ?>><?= $year; ?></a></li>
                                  <?php } ?>
                                  </ul> -->
                              </div>
                           
                              
                              <div class="hs-dropdown ti-dropdown">
                                  <!-- <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    Months<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                  <?php foreach ($datemnthGraph as $key => $value) {
                                     $dataU = $value->month;
                                     $date = date_create('01-' . $dataU . '-2020');
                                     $dayMnt = ($date != null) ? date_format($date, "F") : null;
                                     $dayMnt2 = ($date != null) ? date_format($date, "m") : null;
                                 ?>
                                     <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                            href="javascript:void(0);" <?= (date('F') == $dayMnt) ? "aria-current=\"true\"" : null; ?>>
                                            <?= $dayMnt; ?></a></li>
                                 <?php } ?>
                                  </ul> -->
                              </div>

                                <!-- <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);"
                                    class="ti-btn ti-btn-primary !bg-primary !text-white !py-1 !px-2 !text-[0.75rem] !m-0 !gap-0 !font-medium"
                                    aria-expanded="false">
                                    Sort By<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                        href="javascript:void(0);">New</a></li>
                                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                        href="javascript:void(0);">Popular</a></li>
                                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                        href="javascript:void(0);">Relevant</a></li>
                                  </ul>
                                </div> -->
                                
                              </div>
                            </div>


                            <div class="box-body">
                              <div class="overflow-x-auto">
                                <table class="table min-w-full whitespace-nowrap table-hover border table-bordered">
                                  <thead>
                                    <tr class="border border-inherit border-solid dark:border-defaultborder/10">
                                      <th scope="row" class="!ps-4 !pe-5"><input class="form-check-input" type="checkbox"
                                          id="checkboxNoLabel1" value="" aria-label="..."></th>
                                      <th scope="col" class="!text-start !text-[0.85rem] min-w-[200px]">Company Name</th>
                                      <th scope="col" class="!text-start !text-[0.85rem]">Email</th>
                                      <th scope="col" class="!text-start !text-[0.85rem]">Amount</th>
                                      <th scope="col" class="!text-start !text-[0.85rem]">Quote Stage</th>
                                      <th scope="col" class="!text-start !text-[0.85rem]">Quote Date</th>
                                      <th scope="col" class="!text-start !text-[0.85rem]">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody id="topquotebody">
                                    
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="box-footer">
                              <div class="sm:flex items-center">
                                <div class="text-defaulttextcolor dark:text-defaulttextcolor/70">
                                  Showing 5 Entries <i class="bi bi-arrow-right ms-2 font-semibold"></i>
                                </div>
                                <div class="ms-auto">
                                  <nav aria-label="Page navigation" class="pagination-style-4">
                                    <ul class="ti-pagination mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="javascript:void(0);">
                                                Prev
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link active" href="javascript:void(0);">1</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                        <li class="page-item">
                                            <a class="page-link !text-primary" href="javascript:void(0);">
                                                next
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                   
                    <div class="xxl:col-span-3 xl:col-span-9 col-span-12" >
                      <div class="grid grid-cols-12 gap-x-6" >
                        <div class="xxl:col-span-12 xl:col-span-12  col-span-12" >
                          <div class="box" style="padding-bottom:16px;">
                            <div class="box-header justify-between">
                              <div class="box-title">
                             Sales order 
                              </div>
                              <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    <span id="selectedFiltersalesorder">View</span><i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <input type="hidden" class="form-control" name="salesorder_filter" id="salesorder_filter" value="<?= date('Y-m-d',$thirty); ?>">
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">        
                                  <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="updateSelectedFiltersalesorder('-15 days', 'selectedFiltersalesorder');getfilterdData('<?= date('Y-m-d',$fifteen); ?>','change_salesorder','salesorder_filter');">Last 15 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="updateSelectedFiltersalesorder('-30 days', 'selectedFiltersalesorder');getfilterdData('<?= date('Y-m-d',$thirty); ?>' ,'change_salesorder','salesorder_filter');">Last 30 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="updateSelectedFiltersalesorder('-45 days', 'selectedFiltersalesorder');getfilterdData('<?= date('Y-m-d',$fortyfive); ?>' ,'change_salesorder','salesorder_filter');">Last 45 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="updateSelectedFiltersalesorder('-60 days', 'selectedFiltersalesorder');getfilterdData('<?= date('Y-m-d',$sixty); ?>' ,'change_salesorder','salesorder_filter');">Last 60 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="updateSelectedFiltersalesorder('-90 days', 'selectedFiltersalesorder');getfilterdData('<?= date('Y-m-d',$ninty); ?>' ,'change_salesorder','salesorder_filter');">Last 90 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="updateSelectedFiltersalesorder(' -180 days', 'selectedFiltersalesorder');getfilterdData('<?= date('Y-m-d',$six_month); ?>' ,'change_salesorder','salesorder_filter');">Last 180 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="updateSelectedFiltersalesorder('Last 1 year', 'selectedFiltersalesorder');getfilterdData('<?= date('Y-m-d',$one_year); ?>' ,'change_salesorder','salesorder_filter');">Last 1 year</a></li>
                                  </ul>
                                </div>
                             

                              <!-- <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    Years<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                  <?php foreach ($dateyrGraph as $key => $value) {
                                      $dataU = $value->month;
                                      $date = date_create("01-01-" . $dataU);
                                      $year = ($date != null) ? date_format($date, "Y") : null;
                                  ?>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" <?= (date('Y') == $year) ? "aria-current=\"true\"" : null; ?>><?= $year; ?></a></li>
                                  <?php } ?>
                                  </ul>
                              </div>
                           
                              
                              <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    Months<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                  <?php foreach ($datemnthGraph as $key => $value) {
                                     $dataU = $value->month;
                                     $date = date_create('01-' . $dataU . '-2020');
                                     $dayMnt = ($date != null) ? date_format($date, "F") : null;
                                     $dayMnt2 = ($date != null) ? date_format($date, "m") : null;
                                 ?>
                                     <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                            href="javascript:void(0);" <?= (date('F') == $dayMnt) ? "aria-current=\"true\"" : null; ?>>
                                            <?= $dayMnt; ?></a></li>
                                 <?php } ?>
                                  </ul>
                              </div> -->
                            </div>
                           
                              <div class="leads-source-chart flex items-center justify-center">
                                <!-- <canvas id="leads-source" class="chartjs-chart w-full"></canvas> -->
                                <div id="salesorders"></div>
                                <div class="lead-source-value " >
                                  <span class="block text-[0.875rem] ">Total</span>
                                  <span class="block  font-bold" id="totalsovalue" style="font-size:1.02rem;"></span>
                                </div>
                              
                            </div>
                            
                              
                            </div>
                          </div>
                        </div>
                        <div class="xxl:col-span-12 xl:col-span-6  col-span-12">
                          <div class="box">
                            <div class="box-header justify-between">
                              <div class="box-title">
                                Deals Status
                                <!-- <?= "<pre>"; print_r($dealstats);  "</pre>"; ?> -->
                              </div>
                              <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    View<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">        
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-15 Day")) ?>')">Last 15 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-30 Day")) ?>')">Last 30 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-45 Day")) ?>')">Last 45 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-60 Day")) ?>')">Last 60 days</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-900 Day")) ?>')">Last 3 months</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-180 Day")) ?>')">Last 6 months</a></li>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" onclick="change_estimate_sales('<?= date('Y-m-d', strtotime("-365 Day")) ?>')">Last 1 year</a></li>
                                  </ul>
                                </div>
                             

                              <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    Years<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                  <?php foreach ($dateyrGraph as $key => $value) {
                                      $dataU = $value->month;
                                      $date = date_create("01-01-" . $dataU);
                                      $year = ($date != null) ? date_format($date, "Y") : null;
                                  ?>
                                      <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                              href="javascript:void(0);" <?= (date('Y') == $year) ? "aria-current=\"true\"" : null; ?>><?= $year; ?></a></li>
                                  <?php } ?>
                                  </ul>
                              </div>
                            
                              
                              <div class="hs-dropdown ti-dropdown">
                                  <a href="javascript:void(0);" class="px-2 font-normal text-[0.75rem] text-[#8c9097] dark:text-white/50"
                                    aria-expanded="false">
                                    Months<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                  </a>
                                  <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                  <?php foreach ($datemnthGraph as $key => $value) {
                                     $dataU = $value->month;
                                     $date = date_create('01-' . $dataU . '-2020');
                                     $dayMnt = ($date != null) ? date_format($date, "F") : null;
                                     $dayMnt2 = ($date != null) ? date_format($date, "m") : null;
                                 ?>
                                     <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                            href="javascript:void(0);" <?= (date('F') == $dayMnt) ? "aria-current=\"true\"" : null; ?>>
                                            <?= $dayMnt; ?></a></li>
                                 <?php } ?>
                                  </ul>
                              </div>
                            </div>
                            <div class="box-body">
                              <div class="flex items-center mb-[0.8rem]">
                                <h4 class="font-bold mb-0 text-[1.5rem] ">4,289</h4>
                                <div class="ms-2">
                                  <span
                                    class="py-[0.18rem] px-[0.45rem] rounded-sm text-success !font-medium !text-[0.75em] bg-success/10">1.02<i
                                      class="ri-arrow-up-s-fill align-mmiddle ms-1"></i></span>
                                  <span class="text-[#8c9097] dark:text-white/50 text-[0.813rem] ms-1">compared to last week</span>
                                </div>
                              </div>

                              <div class="flex w-full h-[0.3125rem] mb-6 rounded-full overflow-hidden">
                                <div class="flex flex-col justify-center rounded-s-[0.625rem] overflow-hidden bg-primary w-[21%]" >
                                </div>
                                <div class="flex flex-col justify-center rounded-none overflow-hidden bg-info w-[26%]" >
                                </div>
                                <div class="flex flex-col justify-center rounded-none overflow-hidden bg-warning w-[35%]" >
                                </div>
                                <div class="flex flex-col justify-center rounded-e-[0.625rem] overflow-hidden bg-success w-[18%]" >
                                </div>
                              </div>
                              <?php
                              $countcomplete=0;
                               foreach($dealstats as $dealstats){
                                    if($dealstats['status'] =="Confirmed" || $dealstats['status'] =="Approved"){ 
                                      $countcomplete += $dealstats['counts']; 
                                    }
                                   else if($dealstats['status'] =="pending" || $dealstats['status'] =="Pending/ On Hold"){

                                   }
                                   else if($dealstats['status'] =="Confirmed" || $dealstats['status'] =="Approved"){

                                   }
                                   else if($dealstats['status'] =="Confirmed" || $dealstats['status'] =="Approved"){

                                   }
                                  }
                                  ?>
                              <ul class="list-none mb-0 pt-2 crm-deals-status">
                                <li class="primary">
                                  <div class="flex items-center text-[0.813rem]  justify-between">
                                    <div>Successful Deals</div>
                                    <div class="text-[0.75rem] text-[#8c9097] dark:text-white/50"><?= $countcomplete; ?></div>
                                  </div>
                                </li>
                                <li class="info">
                                  <div class="flex items-center text-[0.813rem]  justify-between">
                                    <div>Pending Deals</div>
                                    <div class="text-[0.75rem] text-[#8c9097] dark:text-white/50">1,073 deals</div>
                                  </div>
                                </li>
                                <li class="warning">
                                  <div class="flex items-center text-[0.813rem]  justify-between">
                                    <div>Rejected Deals</div>
                                    <div class="text-[0.75rem] text-[#8c9097] dark:text-white/50">1,674 deals</div>
                                  </div>
                                </li>
                                <li class="success">
                                  <div class="flex items-center text-[0.813rem]  justify-between">
                                    <div>Upcoming Deals</div>
                                    <div class="text-[0.75rem] text-[#8c9097] dark:text-white/50">921 deals</div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="xxl:col-span-12 xl:col-span-6  col-span-12">
                          <div class="box">
                            <div class="box-header justify-between">
                              <div class="box-title">
                                Recent Activity
                              </div>
                              <div class="hs-dropdown ti-dropdown">
                                <a href="javascript:void(0);" class="text-[0.75rem] px-2 font-normal text-[#8c9097] dark:text-white/50"
                                  aria-expanded="false">
                                  View All<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                                </a>
                                <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                  <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                      href="javascript:void(0);">Today</a></li>
                                  <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                      href="javascript:void(0);">This Week</a></li>
                                  <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                      href="javascript:void(0);">Last Week</a></li>
                                </ul>
                              </div>
                            </div>
                            <div class="box-body">
                              <div>
                                <ul class="list-none mb-0 crm-recent-activity">
                                <?php if (!empty($leads)) {
    foreach ($leads as $lead) { ?>
        <li class="crm-recent-activity-content">
            <div class="flex items-start">
                <div class="me-4">
                    <span class="w-[1.25rem] h-[1.25rem] inline-flex items-center justify-center font-medium leading-[1.25rem] text-[0.65rem] text-primary bg-primary/10 rounded-full">
                        <i class="bi bi-circle-fill text-[0.5rem]"></i>
                    </span>
                </div>
             
                    <div class="crm-timeline-content text-defaultsize " id ="recentactivitybody">
                        <div >
                            <div><span class="font-semibold"><?= $lead['lead_id'] ?></span></div>
                            <div><a href="javascript:void(0);" class="text-primary font-semibold"><?= $lead['lead_status'] ?></a></div>
                        </div>
                        
                          
                            <div  id="recentactivityassignedto"><?= $lead['assigned_to_name'] ?></div>
                       
                   
                </div>
            </div>
        </li>
<?php }
} ?>





                                  <!-- <li class="crm-recent-activity-content">
                                    <div class="flex items-start  text-defaultsize">
                                      <div class="me-4">
                                        <span
                                          class="w-[1.25rem] h-[1.25rem] leading-[1.25rem] inline-flex items-center justify-center font-medium text-[0.65rem] text-secondary bg-secondary/10 rounded-full">
                                          <i class="bi bi-circle-fill text-[0.5rem]"></i>
                                        </span>
                                      </div>
                                      <div class="crm-timeline-content">
                                        <span>New theme for <span class="font-semibold">Spruko Website</span> completed</span>
                                        <span class="block text-[0.75rem] text-[#8c9097] dark:text-white/50">Lorem ipsum, dolor sit amet.</span>
                                      </div>
                                      <div class="flex-grow text-end">
                                        <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem] opacity-[0.7]">3 hrs</span>
                                      </div>
                                    </div>
                                  </li>
                                  <li class="crm-recent-activity-content  text-defaultsize">
                                    <div class="flex items-start">
                                      <div class="me-4">
                                        <span
                                          class="w-[1.25rem] h-[1.25rem] leading-[1.25rem] inline-flex items-center justify-center font-medium text-[0.65rem] text-success bg-success/10 rounded-full">
                                          <i class="bi bi-circle-fill  text-[0.5rem]"></i>
                                        </span>
                                      </div>
                                      <div class="crm-timeline-content">
                                        <span>Created a <span class="text-success font-semibold">New Task</span> today <span
                                            class="w-[1.25rem] h-[1.25rem] leading-[1.25rem] text-[0.65rem] inline-flex items-center justify-center font-medium bg-purple/10 rounded-full ms-1"><i
                                              class="ri-add-fill text-purple text-[0.75rem]"></i></span></span>
                                      </div>
                                      <div class="flex-grow text-end">
                                        <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem] opacity-[0.7]">22 hrs</span>
                                      </div>
                                    </div>
                                  </li>
                                  <li class="crm-recent-activity-content  text-defaultsize">
                                    <div class="flex items-start">
                                      <div class="me-4">
                                        <span
                                          class="w-[1.25rem] h-[1.25rem] leading-[1.25rem] inline-flex items-center justify-center font-medium text-[0.65rem] text-pink bg-pink/10 rounded-full">
                                          <i class="bi bi-circle-fill text-[0.5rem]"></i>
                                        </span>
                                      </div>
                                      <div class="crm-timeline-content">
                                        <span>New member <span
                                            class="py-[0.2rem] px-[0.45rem] font-semibold rounded-sm text-pink text-[0.75em] bg-pink/10">@andreas
                                            gurrero</span> added today to AI Summit.</span>
                                      </div>
                                      <div class="flex-grow text-end">
                                        <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem] opacity-[0.7]">Today</span>
                                      </div>
                                    </div>
                                  </li>
                                  <li class="crm-recent-activity-content  text-defaultsize">
                                    <div class="flex items-start">
                                      <div class="me-4">
                                        <span
                                          class="w-[1.25rem] h-[1.25rem] leading-[1.25rem] inline-flex items-center justify-center font-medium text-[0.65rem] text-warning bg-warning/10 rounded-full">
                                          <i class="bi bi-circle-fill text-[0.5rem]"></i>
                                        </span>
                                      </div>
                                      <div class="crm-timeline-content">
                                        <span>32 New people joined summit.</span>
                                      </div>
                                      <div class="flex-grow text-end">
                                        <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem] opacity-[0.7]">22 hrs</span>
                                      </div>
                                    </div>
                                  </li>
                                  <li class="crm-recent-activity-content  text-defaultsize">
                                    <div class="flex items-start">
                                      <div class="me-4">
                                        <span
                                          class="w-[1.25rem] h-[1.25rem] leading-[1.25rem] inline-flex items-center justify-center font-medium text-[0.65rem] text-info bg-info/10 rounded-full">
                                          <i class="bi bi-circle-fill text-[0.5rem]"></i>
                                        </span>
                                      </div>
                                      <div class="crm-timeline-content">
                                        <span>Neon Tarly added <span class="text-info font-semibold">Robert Bright</span> to AI
                                          summit project.</span>
                                      </div>
                                      <div class="flex-grow text-end">
                                        <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem] opacity-[0.7]">12 hrs</span>
                                      </div>
                                    </div>
                                  </li>
                                  <li class="crm-recent-activity-content  text-defaultsize">
                                    <div class="flex items-start">
                                      <div class="me-4">
                                        <span
                                          class="w-[1.25rem] h-[1.25rem] leading-[1.25rem] inline-flex items-center justify-center font-medium text-[0.65rem] text-[#232323] dark:text-white bg-[#232323]/10 dark:bg-white/20 rounded-full">
                                          <i class="bi bi-circle-fill text-[0.5rem]"></i>
                                        </span>
                                      </div>
                                      <div class="crm-timeline-content">
                                        <span>Replied to new support request <i
                                            class="ri-checkbox-circle-line text-success text-[1rem] align-middle"></i></span>
                                      </div>
                                      <div class="flex-grow text-end">
                                        <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem] opacity-[0.7]">4 hrs</span>
                                      </div>
                                    </div>
                                  </li>
                                  <li class="crm-recent-activity-content  text-defaultsize">
                                    <div class="flex items-start">
                                      <div class="me-4">
                                        <span
                                          class="w-[1.25rem] h-[1.25rem] leading-[1.25rem] inline-flex items-center justify-center font-medium text-[0.65rem] text-purple bg-purple/10 rounded-full">
                                          <i class="bi bi-circle-fill text-[0.5rem]"></i>
                                        </span>
                                      </div>
                                      <div class="crm-timeline-content">
                                        <span>Completed documentation of <a href="javascript:void(0);"
                                            class="text-purple underline font-semibold">AI Summit.</a></span>
                                      </div>
                                      <div class="flex-grow text-end">
                                        <span class="block text-[#8c9097] dark:text-white/50 text-[0.6875rem] opacity-[0.7]">4 hrs</span>
                                      </div>
                                    </div>
                                  </li> -->
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


              
            <footer class="footer mt-auto xl:ps-[15rem] font-normal font-inter bg-white text-defaultsize leading-normal text-[0.813] shadow-[0_0_0.4rem_rgba(0,0,0,0.1)] dark:bg-bodybg py-4 text-center">
                <div class="container">
                    <span class="text-gray dark:text-defaulttextcolor/50"> Copyright © <span id="year"></span> <a
                            href="javascript:void(0);" class="text-defaulttextcolor font-semibold dark:text-defaulttextcolor">Team 365</a>.
                        Designed with <span class="bi bi-heart-fill text-danger"></span> by <a href="javascript:void(0);">
                            <span class="font-semibold text-primary underline">Customer Success Technology Pvt. Ltd.</span>
                        </a> All
                        rights
                        reserved
                    </span>
                </div>

            </footer>
            </div>
            </div>
            <!-- END MAIN-CONTENT -->
  
            
            <!-- END FOOTER -->

	
        <!-- END PAGE-->

        <!-- SCRIPTS -->

        
        <!-- SCROLL-TO-TOP -->
        <div class="scrollToTop">
                <span class="arrow"><i class="ri-arrow-up-s-fill text-xl"></i></span>
        </div>
        <div id="responsive-overlay"></div>
        
        
</div>
        <!-- PRELINE JS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/libs/preline/preline.js"></script>

        <!-- POPPER JS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/libs/%40popperjs/core/umd/popper.min.js"></script>

        <!-- COLOR PICKER JS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/libs/%40simonwep/pickr/pickr.es5.min.js"></script>

        <!-- SWITCH JS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/js/switch.js"></script>
        
        <!-- SIMPLEBAR JS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/libs/simplebar/simplebar.min.js"></script>
        
        <!-- JSVector Maps JS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/libs/jsvectormap/js/jsvectormap.min.js"></script>

        <!-- JSVector Maps MapsJS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/libs/jsvectormap/maps/world-merc.js"></script>

        <!-- Apex Charts JS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Chartjs Chart JS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/libs/chart.js/chart.min.js"></script>

        <!-- CRM-Dashboard -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/js/crm-dashboard.js"></script>

        <!-- DEFAULTMENU JS -->
		    <script src="<?php echo base_url(''); ?>/application/views/assets/js/defaultmenu.js"></script>

        <!-- STICKY JS -->
		    <script src="<?php echo base_url(''); ?>/application/views/assets/js/sticky.js"></script>
 
        <!-- CUSTOM JS -->
		    <script src="<?php echo base_url(''); ?>/application/views/assets/js/custom.js"></script>

        <!-- CUSTOM-SWITCHER JS -->
        <script src="<?php echo base_url(''); ?>/application/views/assets/js/custom-switcher.js"></script>

        <!-- END SCRIPTS -->
        <script>
    function setSelectedFilter(label) {
        document.getElementById('selectedFilter').innerText = label;
    }
    
    function updateSelectedFilter(label, id) {
        document.getElementById(id).innerText = label;
    }

    function updateSelectedFiltermonth(label, id) {
        document.getElementById(id).innerText = label;
    }
    function setSelectedFilterprofit(label) {
        document.getElementById('selectedFilterprofit').innerText = label;
    }
    function updateSelectedFilterprofit(label, id) {
        document.getElementById(id).innerText = label;
    }

    function updateSelectedFiltermonthprofit(label, id) {
        document.getElementById(id).innerText = label;
    }
    function updateSelectedFiltersalesorder(label, id) {
      document.getElementById('selectedFiltersalesorder').innerText = label;
    }
</script>


<script>

  ////////////////////////////////////////////////////////////////////// cards graph starts ////////////////////////////////////////////////////////////////////
   function view_so(sales_id) {
    window.location.href = "<?= base_url('salesorders/view_pi_so/'); ?>" + sales_id;
  }
//   function end_renewal(id) {
//     $.ajax({
//       url: '<?= site_url("salesorders/end_renewal") ?>',
//       method: 'post',
//       data: {
//         id: id
//       },
//       dataType: 'json',
//       success: function(response) {
//         $.ajax({
//           url: '<?= site_url("salesorders/update_renewal_data") ?>',
//           method: 'post',
//           data: {
//             id: id
//           },
//           dataType: 'json',
//           success: function(response) {
//             $("#notify_table").empty();
//             var table;
//             $.each(response, function(index, data) {
//               table = "<tr><td>" + data['saleorder_id'] + "</td>" + "<td>" + data['subject'] + "</td>" + "<td>" + data['org_name'] + "</td>" + "<td>" + data['renewal_date'] + "</td>" + "" + "<td>" + data['owner'] + "</td>" + "<td><button class='btn btn-primary btn-sm' onclick='view_so(" + data['id'] + ")'>View</button></td>" + "<td><button class='btn btn-danger btn-sm' onclick='end_renewal(" + data['id'] + ")'>End</button></td>" + "</tr>";
//               $("#notify_table").append(table);
//             });
//           }
//         });
//       }
//     });
//   }
  
  
  
    function end_renewal(id) {
    $.ajax({
        url: '<?= site_url("salesorders/end_renewal") ?>',
        method: 'post',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            // After ending the renewal, update the table with new data
            refresh_modal_table();
        }
    });
    }
 
    function refresh_modal_table() {
        $.ajax({
            url: '<?= site_url("salesorders/update_renewal_data") ?>',
            method: 'post',
            data: {},
            dataType: 'json',
            success: function(response) {
                // Empty the table before appending new rows
                $("#notify_table").empty();
     
                // Populate the table with the updated data
                $.each(response, function(index, data) {
                    var tableRow = "<tr>" +
                                   "<td style='padding-left:12px;'>" + data['saleorder_id'] + "</td>" +
                                   "<td>" + data['subject'] + "</td>" +
                                   "<td>" + data['org_name'] + "</td>" +
                                   "<td>" + data['renewal_date'] + "</td>" +
                                   "<td>" + data['owner'] + "</td>" +
                                   "<td><button class='btnviewmodal badge bg-outline-primary' onclick='view_so(" + data['id'] + ")'>View</button></td>" +
                                   "<td><button class='btnendmodal badge bg-outline-secondary' onclick='end_renewal(" + data['id'] + ")'>End</button></td>" +
                                   "</tr>";
                    $("#notify_table").append(tableRow);
                });
            }
        });
    }
  









 $.ajax({
  url:'<?php echo base_url('home/getyeargraph'); ?>',
  method:'post',
  dataType:'json',
  data:{},
  success:function(resp){
    
    
   
       var totalcustarr=resp['totalcustarr'];
       var totalopparr = resp['totalopparr'];
       var totalleadarr = resp['totalleadarr'];
       var totalquotearr = resp['totalquotearr'];
   
        function renderchart(data,colorcode,id){
    var chart = {
        chart: {
            type: 'line',
            height: 40,
            width: 100,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 1.5,
            dashArray: 0,
        },
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.9,
                opacityTo: 0.9,
                stops: [0, 98],
            }
        },
        series: [{
            name: 'Value',
            data:data
        }],
        yaxis: {
            min: 0,
            show: false,
            axisBorder: {
                show: false
            },
        },
        xaxis: {
            show: false,
            axisBorder: {
                show: false
            },
        },
        tooltip: {
            enabled: false,
        },
        colors: [colorcode],
    }
    var crm1 = new ApexCharts(document.querySelector("#"+id), chart);
    crm1.render();
  }
  
  
        function increment(arr,id){
    console.log(arr);
    var lastmonthcount = arr[0];
    console.log(lastmonthcount);
    var  restOfArray = arr.slice(0, -1);
    var restelement = restOfArray.reduce((max, current) => Math.max(max, current), restOfArray[0]);
    console.log(Math.max(restelement)+"  "+lastmonthcount);
    
    var percent =  ((lastmonthcount/Math.max(restelement))*100)-100;
    percent = parseFloat(percent.toFixed(2));
    if(percent>0){
      $("#"+id).html("+"+percent+"%");
      $("#"+id).css('color','green');
    }
    else{
      $("#"+id).html(percent+"%");
      $("#"+id).css('color','rgba(255,70,10,0.8)');
    }
   
  }
  
      increment(totalcustarr,"custincrpercent");
      increment(totalopparr,"oppincrpercent");
      increment(totalleadarr,"leadincrpercent");
      increment(totalquotearr,"quoteincrpercent");
      
      renderchart(totalcustarr.reverse(),"rgb(132, 90, 223)","crm-total-customers");
      renderchart(totalopparr.reverse(),"rgb(132, 190, 223)","crm-conversion-ratio");
      renderchart(totalleadarr.reverse(),"rgb(132,240,200)","crm-total-revenue");
      renderchart(totalquotearr.reverse(),"rgb(160,50,249)","crm-total-deals");
    }
 })
   






  ////////////////////////////////////////////////////////////////////// cards graph ends ///////////////////////////////////////////////////////////////////////

  ////////////////////////////////////////////////////////////////////// target graph starts ///////////////////////////////////////////////////////////////////
          
  
  var setData = 'profit Score';
  var urlP = "<?php echo base_url(); ?>Sales_profit_target/getSalesOrderPer";

  $.ajax({
    url: urlP,
    method: "POST",
    dataType: 'JSON',
    data: {
      'getData': setData
    },
    success: function(data) {

      saleOrderScore(data.sales_score, 'containerScore', 'Sales');
      saleOrderScore(data.profit_score, 'containerScoreProfit', 'Profit');
    }
    });

function saleOrderScore(score, scoreDivId, text) {
  // score=100;
 if(score>=100){
  $("#targetstatus_define").html("Your target is Completed");
 }

  
  $("#profitscore").html(score+"%");
      var options = {
        chart: {
            height: 127,
            width: 100,
            type: "radialBar",
        },

        series: [score],
        colors: ["rgba(255,255,255,0.9)"],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 0,
                    size: "55%",
                    background: "#fff"
                },
                dataLabels: {
                    name: {
                        offsetY: -10,
                        color: "#4b9bfa",
                        fontSize: ".625rem",
                        show: false
                    },
                    value: {
                        offsetY: 5,
                        color: "#4b9bfa",
                        fontSize: ".875rem",
                        show: true,
                        fontWeight: 600
                    }
                }
            }
        },
        stroke: {
            lineCap: "round"
        },
        labels: ["Status"]
    };
    $("#crm-main").html("");
    var chart = new ApexCharts(document.querySelector("#crm-main"), options);
    chart.render();
   
      
}
      

  ////////////////////////////////////////////////////////////target graph ends ///////////////////////////////////////////////////////////////////

  ////////////////////////////////////////////////////////////change estimate sales graph starts///////////////////////////////////////////////

  function change_estimate_sales() {
    var date = $("#estimate_filter").val();
    $.ajax({
      url: "<?php echo base_url(); ?>home/sort_estimate_graph",
      method: "POST",
      dataType: 'JSON',
      data: {
        'date': date
      },
      success: function(response) {
        //console.log(response);
        var owner = [];
        var sub_total = [];
        for (var i in response) {
          owner.push(response[i].owner + ' (₹) ');
          sub_total.push(parseInt(response[i].sub_totalq));
         
        }
        console.log(sub_total);
        var options = {
          series:sub_total,
          labels:owner,
          chart: {
         width:450,
          type: 'donut',
        },
        plotOptions: {
          pie: {
            startAngle: -90,
            endAngle: 270
          }
        },
        
        dataLabels: {
          enabled: false
        },
        fill: {
          type: 'gradient',
        },
        legend: {
          formatter: function(val, opts) {
            return val + " - " + opts.w.globals.series[opts.seriesIndex]
          }
        },
        title: {
          text: ''
        },
        responsive: [{
          breakpoint: 320,
          options: {
            chart: {
              width:290
            },
            legend: {
              position: 'top'
            }
          }
        }]
        };
        $("#estimates").html('');
         var chart = new ApexCharts(document.querySelector("#estimates"), options);
         chart.render();
       
        // estimateGraph.options.labels = owner;
        // estimateGraph.options.datasets[0].data = sub_total;
        // estimateGraph.update();
      }
    });
  }

  ////////////////////////////////////////////////////////////// change estimate sales graph ends////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////// Sales order graph starts /////////////////////////////////////////////////////
function openFullscreen() {
    var elem = document.documentElement;

    if (!document.fullscreenElement) {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.mozRequestFullScreen) { /* Firefox */
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE/Edge */
            elem.msRequestFullscreen();
        }

        // Toggle visibility of fullscreen icons
        document.querySelector('.full-screen-open').classList.add('hidden');
        document.querySelector('.full-screen-close').classList.remove('hidden');
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) { /* Firefox */
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { /* IE/Edge */
            document.msExitFullscreen();
        }

        // Toggle visibility of fullscreen icons
        document.querySelector('.full-screen-open').classList.remove('hidden');
        document.querySelector('.full-screen-close').classList.add('hidden');
    }
}


change_salesorder();

  function change_salesorder() {
    var salesGraph;
    var date = $("#salesorder_filter").val();
                     
    $.ajax({
      url: "<?php echo base_url(); ?>home/getSO",
      method: "POST",
      data: {
        'date': date
      },
      dataType: 'JSON',
      success: function(data) {
        var owner = [];
        var sub_totals = [];
        for (var i in data) {
          owner.push(data[i].owner + ' (₹) ');
          sub_totals.push(parseInt(data[i].sub_totals));
        }
        var sum_so = 0;
        Array.from(	sub_totals).forEach((e)=>{
          sum_so += e;
        })
        
       $("#totalsovalue").html("₹ "+numberToIndPrice(sum_so));

        var options = {
    series: sub_totals,
    labels: owner,
    chart: {
        width: 350,
        type: 'donut',
    },
    plotOptions: {
        pie: {
            startAngle: -90,
            endAngle: 270,
            donut: {
                size: '85%' // Aap yahaan par donut ka size customize kar sakte hain
            }
        }
    },
    dataLabels: {
        enabled: false
    },
    fill: {
        type: 'gradient',
    },
    legend: {
        position: 'bottom', // Legend ko bottom par shift kiya gaya hai
        formatter: function(val, opts) {
            return val + " - " + opts.w.globals.series[opts.seriesIndex]
        }
    },
    title: {
        text: ''
    },
    responsive: [{
        breakpoint: 1600,
        options: {
            chart: {
                width: 300
            },
            legend: {
                position: 'top'
            }
        }
    }]
};

        $("#salesorders").html('');
        var chart = new ApexCharts(document.querySelector("#salesorders"), options);
        chart.render();
        
    }});}
        
      

////////////////////////////////////////////////////////////////// Sales order graph ends /////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////// (line Chart) sales profit graph starts ///////////////////////////////////////////////////////////

$.ajax({
  url:'<?php echo site_url('salesorders/so_graph')?>',
              method:'post',
              success:function(response){
              if (response.status === 'success') {
              
var so_amount = [];
var profit =[];
var xAxisCategories=[];
for (var i = 0; i < response.data.length; i++) {
  so_amount.push(parseFloat(response.data[i].subtotal)); 
    xAxisCategories.push(response.data[i].month + "/" + response.data[i].year);
}
for (var i = 0; i < response.data.length; i++) {
  profit.push(parseFloat(response.data[i].profit)); 
 
}
var so_amountrev = so_amount.reverse();
var profitrev = profit.reverse();
var xAxisCategoriesrev = xAxisCategories.reverse();

var options = {
    series: [
        { name: 'Total SO Amount of month', data: so_amountrev },
        { name: 'Total Profit of month', data: profitrev }
    ],
    chart: {
        height: 300,
        type: 'line',
       
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth',
        width: 3,
        dashArray: [5,5],
        dropShadow: {
            enabled: true,
            top: 1,
            left: 1,
            blur: 10,
            opacity: 0.9
        }
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            type: 'vertical',
            shadeIntensity: 0.5,
            gradientToColors: ['#FDD835'],
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        },
    },
    xaxis: {
        categories: xAxisCategoriesrev,
        tickAmount: Math.ceil(xAxisCategoriesrev.length / 1),
        tickPlacement: 'on'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                // Format the y-axis labels using Indian numbering system
                return '₹ ' + new Intl.NumberFormat('en-IN').format(value);
            }
        }
    }
};

        var chart = new ApexCharts(document.querySelector("#chart-line"), options);
        chart.render();

              }
             }
    });

////////////////////////////////////////////////////////////////(line Chart) sales profit graph ends ////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////// Top 10 customers starts //////////////////////////////////////////////////////////

function gettoptencus(){
    var company=[];
    var amount=[];
    var profit=[];
    var toptencustomer=``;
    var profitDate = $("#topcus_filter").val();
    var profitYear = $("#topcus_year").val();
    var profitMoth = $("#topcus_month").val();
    var financial_year = $("#Financial_year").val();

     $.ajax({
        url:'<?php echo base_url();?>/home/gettoptencus',
        method:'post',
        dataType:'JSON',
        data:{
          'searchDate': profitDate,
          'profitYear': profitYear,
          'profitMoth': profitMoth,
          'financial_year':financial_year
        },
        success:function(resp){
          $("#topcus_filter").val("");
          $("#Financial_year").val("");
          
          if (resp.toptencus) {
           resp.toptencus.forEach(function(item) {
              company.push(item.org_name);
              amount.push(item.total_subtotal);
              profit.push(item.totalprofit);
              var org = item.org_name;
              var orgwrapped = org.substring(0, 15)

              toptencustomer  += `<li class="mb-[0.8rem]">
                                    <div class="flex items-start flex-wrap">
                                      <div class="me-2">
                                        <span class=" inline-flex items-center justify-center">
                                          <img src="<?php echo base_url(''); ?>/application/views/assets/images/faces/10.jpg" alt=""
                                            class="w-[1.75rem] h-[1.75rem] leading-[1.75rem] text-[0.65rem]  rounded-full">
                                        </span>
                                      </div>
                                      <div class="flex-grow" >
                                        <p class="font-semibold mb-[1.4px]  text-[0.113rem]" style="max-width: 120px;">${orgwrapped}...
                                        </p>
                                        <p class="text-[#8c9097] dark:text-white/50 text-[0.75rem]">${item.owner}</p>
                                      </div>
                                      <div class="font-semibold text-[0.2375rem] ">${new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', minimumFractionDigits: 0,
    maximumFractionDigits: 0 }).format(item.total_subtotal)}<br>  <span style="font-size: smaller; color:green;">${new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', minimumFractionDigits: 0,
    maximumFractionDigits: 0 }).format(item.totalprofit)}</span></div>
                                    </div>
                                  </li>`;
       });
    }
 $("#toptencust").html(toptencustomer);
        }
     })
}
gettoptencus();

/////////////////////////////////////////////////////////////// Top 10 customers ends ////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////// Profit by sales order graph starts //////////////////////////////////////////
     $("#so_frofit_month").change(function() {
    $("#profit_filter_new").val('');
  });

  getChartData();

  function getChartData() {

    var profitDate = $("#profit_filter_new").val();
    var profitYear = $("#so_frofit_year").val();
    var profitMoth = $("#so_frofit_month").val();

    var url = "<?php echo base_url(); ?>/home/getdata";
    var chart;
    $.ajax({
      url: url,
      method: "POST",
      dataType: 'JSON',
      data: {
        'searchDate': profitDate,
        'profitYear': profitYear,
        'profitMoth': profitMoth
      },
      success: function(data) {

        var owner = [];
        var content =[];
        var sub_total_salesorder = [];
        var sub_initial_total = [];
        for (var i in data) {
          owner.push(data[i].owner);
          sub_total_salesorder.push(data[i].profit_by_user);
          sub_initial_total.push(data[i].initial_total);
        }
        
      for(var own of owner){
         var series = 
          {
            name:'Sales By '+own,
            group:'Sales',
            data:sub_total_salesorder,
          }

        content.push(series);
      }
       
        var options = {
          series: [{
            name: 'Total Sales Price (₹)',
            data: sub_initial_total,
            color: 'rgb(120,50,240)'
          }, {
            name: 'Total Net Profit (₹)',
            data: sub_total_salesorder,
            color: 'rgb(10,200,255)'
          }],
          chart: {
            brush: {
        enabled: false,
        target: undefined,
        autoScaleYaxis: false
      },
            type: 'bar',
            // stacked: true,
            height: 290
          },
          plotOptions: {
            bar: {
              borderRadius:'5',
              horizontal: false,
              columnWidth: '40%',
              endingShape: 'flat',
              color:'purple'
              
            },
          },
          stroke: {
            // show: true,
            // curve:'smooth',
            width: 1,
            colors: ['transparent']
          },
          dataLabels: {
          enabled: false,
        },
        grid:{
          show:false
        },
        
          xaxis: {
            categories: owner,
           
          },
          yaxis: {
            title: {
              text: '(Indian Ruppes)'
            },
            labels: {
            formatter: (val) => {
              return val / 1000 + 'K'
            }
          }
          },
          fill: {
            opacity: 1,
            

          },
          tooltip: {
    y: {
        formatter: function(val) {
            return numberToIndPrice(val);
        }
    }
},
legend: {
    show: false
  }

          }
        $("#profit").html('');
        var chart = new ApexCharts(document.querySelector("#profit"), options);
        chart.render();
      },
      error: function(data) {
        //console.log(data);
      }
    });

  }

  getMonth();

  function getMonth() {
    $("#profit_filter_new").val('');
    var yearsDt = $('#so_frofit_year').val();
    url = "<?= site_url('home/getMonth') ?>";
    $.ajax({
      url: url,
      type: "POST",
      data: 'yearsDt=' + yearsDt,
      success: function(data) {
        $('#so_frofit_month').html(data);
        //getChartachiveData();
      }
    });
  }

  $('#so_frofit_year').change(function() {
    getMonth();
  });

/////////////////////////////////////////////////////////////////// profit by sales order graphs ends////////////////////////////////////////////////

function getfilterdData(e,f,g){
      var id = "#" + g;
      $(id).val(e);
      window[f]();
      getMonth();
}

function numberToIndPrice(price){
  return new Intl.NumberFormat().format(price);
}

//////////////////////////////////////////////////////////////////// deal statistics graph starts //////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////// deal statistics graph ends //////////////////////////////////////////////////////////////

function topquotes(){
  $.ajax({
    url: '<?= site_url('home/topquotes'); ?>',
    method: 'post',
    dataType: 'json',
    data: {},
    success: function(resp){
      $("#topquotebody").html(resp);
    }
  });
}


topquotes();
</script>
   <?php if (check_permission_status('Salesorders', 'retrieve_u') == true) : ?>
<script>
$("#custommodalbox").css('display','block');
     $('body').addClass('modalappearbody');
      
    $(".content").each(function(){
        $(this).addClass('modalappear');
    });
$("#custommodalclose").click(function(){
  $("#custommodalbox").fadeOut(200);
  $('body').removeClass('modalappearbody');
      
    $(".content").each(function(){
        $(this).removeClass('modalappear');
    });
})</script>
<?php endif; ?>
<!--// setTimeout(function(){-->
<!--//     $("#custommodalbox").css('display','block');-->
<!--//     $('body').css('backdrop-filter','brightness(0.5)');-->
<!--//     $(".content").each(function(){-->
<!--//         $(this).addClass('modalappear');-->
<!--//     });-->
<!--//   }, 30000);-->

<!--// $("#custommodalclose").click(function(){-->
<!--//   $("#custommodalbox").fadeOut(200);-->
<!--//   $('body').css('backdrop-filter','brightness(1.0)');-->
<!--//     $(".content").each(function(){-->
<!--//         $(this).removeClass('modalappear');-->
<!--//     });-->
<!--// })-->
<!--// please write code above this line-->

</script>
	</body>


</html>     