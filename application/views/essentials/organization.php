<?php $this->load->view('common_navbar');?>
<style>
   #ajax_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 1rem;
   border-bottom:none;
   /* padding-top:18px;
  padding-bottom:18px; */
  

}


#ajax_datatable tbody tr td {
  background-color: #fff; /* Set background color */
  font-size: 13px; /* Increase font size */
  font-family: system-ui;
  font-weight: 651;
  color:rgba(0,0,0,0.7);
  padding-top:16px;
  padding-bottom:16px;
   /* Change font family */
  /* Add any other styles as needed */
}

#ajax_datatable tbody tr td:nth-child(5) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
}

  #ajax_datatable{
   width: 100% !important;
}

</style>


 <!-- modal Mass Product start-->
 <div class="modal fade" id="mass_product_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Mass Update </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="massForm" method="post" action="">
            <div class="col-lg-12">
               <div class="form-row d-flex align-items-end">

                  <!-- ID Field -->
                  <input type="hidden" id="mass_id" name="mass_id" placeholder="Enter ID" class="form-control">

                  <!-- Field Selection -->
                  <div class="col pr-1">
                  <div class="form-group">
                     <label>Select Field</label>
                     <select class="form-control type-select" name="mass_name" id="mass_name" required>
                        <option value="" selected disabled>Select a Field</option>
                        <option value="org_name">Customer/Company Name</option>
                        <option value="mobile">Mobile</option>
                        <option value="email">Email</option>
                        <option value="industry">Industry</option>
                        <option value="customer_type">Customer Type</option>
                        <option value="type">Type</option>
                        <option value="region">Region</option>
                        <option value="website"> Website </option> 
                        <option value="primary_contact">Contact Person</option>
                        <option value="ownership">Ownership</option> 
                        <option value="office_phone">Office Phone</option>
                        <option value="billing_country">Billing Country</option> 
                        <option value="billing_state">Billing State</option> 
                        <option value="billing_city">Billing City</option>
                        <option value="billing_zipcode">Billing Zipcode</option>
                        <option value="billing_address">Billing Address</option>
                        <option value="shipping_country">Shipping Country</option>
                        <option value="shipping_state">Shipping State</option>
                        <option value="shipping_city">Shipping City</option>
                        <option value="shipping_zipcode">Shipping Zipcode</option> 
                        <option value="shipping_address">Shipping Address</option>
                        <option value="gstin">GSTIN</option> 
                        <option value="panno">Pan Number</option> 
                        <option value="description">Description</option>

                     </select>
                  </div>
                  </div>

                  <!-- Input or Dropdown Field -->
                  <div class="col pl-1 length-wrapper" style="display: none;">
                  <div class="form-group">
                     <!-- Text Input -->
                     <input type="text" class="form-control length-input" id="value_input" placeholder="Enter Value">

                     <!-- Industry -->
                     <select class="form-control industry-select" id="industry_select" style="display: none;">
                        <option value="">Select Industry</option>
                        <option value="Technology">Technology</option>
                        <option value="Retail">Retail</option>
                        <option value="">Select Industry</option>
                        <option value="Government">Government</option>
                        <option value="Other">Other</option> 
                        <option value="Utilies">Utilies</option>
                        <option value="Transportation">Transportation</option>
                        <option value="Telecommunications">Telecommunications</option>
                        <option value="'Shipping">Shipping</option> 
                        <option value="Recreation">Recreation</option>
                        <option value="Not For Profit">Not For Profit</option>
                        <option value="Media">Media</option>
                        <option value="Manufacturing">Manufacturing</option> 
                        <option value="Machinery">Machinery</option>
                        <option value="Insurance">Insurance</option>
                        <option value="Hospitality">Hospitality</option> 
                        <option value="Healthcare">Healthcare</option>
                        <option value="Apparel">Apparel</option>
                        <option value="Food and Baverage">Food and Baverage</option>
                        <option value="Finance">Finance</option>
                        <option value="Environmental">Environmental</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Engineering">Engineering</option> 
                        <option value="Energy">Energy</option>
                        <option value="Electronic">Electronic</option> 
                        <option value="Education">Education</option>
                        <option value="Consulting">Consulting</option> 
                        <option value="Construction">Construction</option> 
                        <option value="Communications">Communications</option>
                        <option value="Chemicals">Chemicals</option> 
                        <option value="Biotechnology">Biotechnology</option>
                        <option value="Banking">Banking</option>
                     </select>
                                         

                     <!-- Customer Type -->
                     <select class="form-control customertype-select" id="customer_type_select" style="display: none;">
                        <option value="">Select Customer Type</option>
                        <option value="Customer">Customer</option>
                        <option value="Vendor">Vendor</option>
                        <option value="Both">Both</option>
                     </select>

                     <!-- Type -->
                     <select class="form-control types-select" id="types_select" style="display: none;">
                        <option value="">Select Type</option>
                        <option value="Lead">Lead</option>
                        <option value="Customer">Customer</option>
                        <option value="">Select Type</option>
                        <option value="Sales Qualified Lead">Sales Qualified Lead</option> 
                        <option value="Compatitor">Compatitor</option> 
                        <option value="Partner">Partner</option>
                        <option value="Analyst">Analyst</option>
                        <option value="Vendor">Vendor</option>
                     </select>

                     <!-- Region -->
                     <select class="form-control region-select" id="region_select" style="display: none;">
                        <option value="">Select Region</option>
                        <option value="NAM">NAM</option>
                        <option value="EU">EU</option>
                        <option value="APAC">APAC</option>
                         <option value="LAM">LAM</option>
                        <option value="MEA">MEA</option>

                     </select>
                  </div>
                  </div>
               </div>
            </div>

            
            <!-- Hidden field that carries final value -->
            <input type="hidden" name="mass_value" id="final_value_input">

            <!-- Submit Button -->
            <!-- <button type="submit" id="massUpdateBtn" class="btn btn-primary mt-2">Mass Update</button> -->
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="massUpdateBtn">Update</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal Mass Product end-->




<!-- Start Page Main Content -->
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);overflow-x:clip;">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">Customer</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                  <li class="breadcrumb-item active">Customer</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
         <div class="container-fliud filterbtncon"  >
         <?php 
                                 //   $fifteen = strtotime("-15 Day"); 
                                 //   $thirty = strtotime("-30 Day"); 
                                 //   $fortyfive = strtotime("-45 Day"); 
                                 //   $sixty = strtotime("-60 Day"); 
                                 //   $ninty = strtotime("-90 Day"); 
                                 //   $six_month = strtotime("-180 Day"); 
                                 //   $one_year = strtotime("-365 Day");
                            ?>
         <div class="row mb-3">

          <div class="col-lg-2">
               <a id="mass_model" href="#" style="text-decoration:none;">
                <button type="button" id="mass_product" class="btn" style="display:none; border-radius: 2rem; margin-bottom: 1rem; background: #845ADF; color:#fff; font-weight: 500;">
                    Mass Product
                </button>
               </a>
         </div>


         <div class="col-lg-2">
         <div class="first-one custom-dropdown dropdown">
            <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Select Option
            </button>
            <input type="hidden" id="date_filter" value="" name="date_filter">
            <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li data-value="This Week"onclick="getfilterdData('<?= 'This Week'?>','date_filter');">This Week</li>
               <?php $week = strtotime("-7 Day"); ?>
               <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('y.m.d',$week); ?>','date_filter');">Last 7 days</li>
               <?php $fifteen = strtotime("-15 Day"); ?>
               <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('y.m.d',$fifteen); ?>','date_filter');">Last 15 days</li>
               <?php $thirty = strtotime("-30 Day"); ?>
               <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('y.m.d',$thirty); ?>','date_filter');">Last 30 days</li>
               <?php $fortyfive = strtotime("-45 Day"); ?>
               <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('y.m.d',$fortyfive); ?>','date_filter');">Last 45 days</li>
               <?php $sixty = strtotime("-60 Day"); ?>
               <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('y.m.d',$sixty); ?>','date_filter');">Last 60 days</li>
               <?php $ninty = strtotime("-90 Day"); ?>
               <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('y.m.d',$ninty); ?>','date_filter');">Last 3 Months</li>
               <?php $six_month = strtotime("-180 Day"); ?>
               <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('y.m.d',$six_month); ?>','date_filter');">Last 6 Months</li>
               <?php $one_year = strtotime("-365 Day"); ?>
               <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('y.m.d',$one_year); ?>','date_filter');">Last 1 Year</li>
            </ul>
         </div>
   </div>

   
         <div class="col-lg-2">
            <div class="first-one custom-dropdown dropdown">
               <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Select Option
               </button> 
                  <input  type="hidden" id="cust_types" name="cust_types">
                  <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <!-- <select class="custom-select" name="user_filter" id="user_filter"> -->
                              
                              <li onclick="getfilterdData('Customer','cust_types');">Customer</li>
                              <li onclick="getfilterdData('Vendor','cust_types');">Vendor</li>
                              <li onclick="getfilterdData('Both','cust_types');">Both</li>
                              
                           
                           
                        </ul>
            </div>
		   </div>

        <div class="col-lg-2">
            <?php if($this->session->userdata('type') == 'admin') { ?>
                  <div class="first-one custom-dropdown dropdown">
                     <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select Option
                     </button>
                     <input type="hidden" id="user_filter" value="" name="user_filter">
                     <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                           
                              <?php foreach($admin as $adminDtl) { ?>
                              <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$adminDtl['admin_email'];?>','user_filter');"><?=$adminDtl['admin_name'];?></li>
                              <?php } ?>
                              <?php  foreach($user as $userDtl) { ?>
                              <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$userDtl['standard_email'];?>','user_filter');"><?=$userDtl['standard_name'];?></li>
                              
                              <?php } ?>
                              </ul>
                  </div>
               <?php } ?>
        </div>

        

            <div class="col-lg-4">
               <div class="refresh_button float-right">
                  <button class="btnstopcorner" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
                  <?php if($this->session->userdata('type')=='admin'){ ?>
                  <a href='Export_data/export_customer_csv' class="p-0" ><button class="btnstopcorn">Export Data</button></a>
                  <?php } ?>
                  <?php if(check_permission_status('Customer','create_u')==true){ 
                     if($this->session->userdata('account_type')=="Trial" && ($countOrg>=2000 || $countContact>=2000)){
                     ?>
                  <button class="btnstop" onclick="infoModal('You are exceeded  your customer/contact limit - 2,000')" >Add New</button>
                  <?php }else{ ?>
                  <button class="btncorner" onclick="import_excel()">Import&nbsp;Customer</button>
                  <button class="btnstop" onclick="add_form()">Add New</button>
                  <?php  } } ?>
               </div>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <!-- Main row -->
         <!-- Map card -->
         <div class="card org_div">
            
            <div class="card-body">
               <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                  <thead>
                     <tr>
                        <?php if(check_permission_status('Customer','delete_u')==true): ?>
                        <th><button class="btn" type="button" name="delete_all" id="delete_all"><i class="fa fa-trash text-light"></i></button></th>
                        <?php endif; ?>
                        <th class="th-sm">Customer Name</th>
                        <th class="th-sm">Customer Type</th>
                        <th class="th-sm">Email</th>
                        <th class="th-sm">Website</th>
                        <th class="th-sm">Mobile</th>
                        <th class="th-sm">Billing City</th>
                        <th class="th-sm" style="width:9%">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.row (main row) -->
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
<!-- End Page Main Content -->
<!-- Add new modal -->
<?php if($this->session->userdata('account_type')=="Trial" && ($countOrg>=2000 || $countContact>=2000)){  }else{ ?>
<div class="modal fade show" id="modal_form" role="dialog" aria-modal="true" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-lg ModalRight">
      <div class="modal-content Modalht100">
         <div class="modal-header">
            <h3 class="modal-title" id="organization_add_edit">Add Customer</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">
               <input type="hidden" value="" name="id">
               <input type="hidden" value="" name="sess_eml">
               <input type="hidden" value="" name="save_method" id="save_method">
               <div class="form-body form-row">
                  <div class="col-md-6 mb-3">
                     <label>Customer Type <span style="color: #f76c6c;">*</span></label>    
                     <select class="form-control" name="cust_types" id="cust_type_select">
                        <option value="">Select Customer Type</option>
                        <option value="Customer">Customer</option>
                        <option value="Vendor">Vendor</option>
                        <option value="Both">Both</option>
                     </select>
                     <span id="customer_type_error"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Ownership</label>
                      <input type="text" class="form-control " name="ownership" placeholder="Ownership" value="<?= $this->session->userdata('name'); ?>" <?php if($this->session->userdata('type')!='admin'){echo "readonly";} ?>>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Customer Company Name<span style="color: #f76c6c;">*</span></label>
                     <input type="text" class="form-control onlyLetters" name="org_name" id="org_name_check" placeholder="Customer Name" onChange="check_org()" required>
                     <span id="org_name_error"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                     <input type="hidden" name="primary_contact_hide" id="primary_contact_hide">
                     <label>Primary Contact Person <span style="color: #f76c6c;">*</span></label>
                     <input type="text" class="form-control onlyLetters" name="primary_contact" id="primary_contact_org" placeholder="Primary Contact Name">
                     <span id="primary_contact_error"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Email <span style="color: #f76c6c;">*</span></label>  
                     <input type="email" class="form-control " name="email" id="emailId" placeholder="Email">
                     <span id="email_error"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Website</label> 
                     <input type="url" class="form-control " name="website" id="websiteId" placeholder="Website" required>
                     <span id="website_error"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Office Phone</label>  
                     <input type="tel" class="form-control landline" maxlength="15"  name="office_phone" id="officePhone" placeholder="Office Phone" required="">
                     <span id="office_phone_error"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Mobile <span style="color: #f76c6c;">*</span></label>  
                     <input type="text" class="form-control phonePaste numeric"  maxlength="10"  name="mobile" id="mobileId" placeholder="Mobile" required="">
                     <span id="mobile_error"></span>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a class="btn btn-info btn-sm show_div" target="1" id="forTarget1" style="width:100%;color:#ffffff;background:rgba(35,0,140,0.8)">Other Details</a>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a class="btn btn-info btn-sm show_div" target="2" id="forTarget2" style="width:100%;color:#ffffff;background:rgba(35,0,140,0.8)">Address Details</a>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a class="btn btn-info btn-sm show_div" target="3" style="width:100%;color:#ffffff; background:rgba(35,0,140,0.8)">Contact Person</a>
                  </div>
                  <div class="col-md-3 mb-3">
                     <a class="btn btn-info btn-sm show_div" target="4" style="width:100%;color:#ffffff; background:rgba(35,0,140,0.8)">Description</a>
                  </div>
                  <div class="col-md-3 mb-3">
                  </div>
                  <div id="div1" class="targetDiv form-row col-md-12" style="display: none;">
                     <div class="col-md-6 mb-3">
                        <label>Employees</label>
                        <input type="number" class="form-control " name="employees" id="employeesId" placeholder="Employees">
                     </div>
                     <div class="col-md-6 mb-3">
                        <label>Industry</label>    
                        <select class="form-control " name="industry" id="industryId" required="">
                           <option value="">Industry</option>
                           <option value="Government">Government</option>
                           <option value="Other">Other</option>
                           <option value="Utilies">Utilies</option>
                           <option value="Transportation">Transportation</option>
                           <option value="Telecommunications">Telecommunications</option>
                           <option value="Technology">Technology</option>
                           <option value="'Shipping">Shipping</option>
                           <option value="Retail">Retail</option>
                           <option value="Recreation">Recreation</option>
                           <option value="Not For Profit">Not For Profit</option>
                           <option value="Media">Media</option>
                           <option value="Manufacturing">Manufacturing</option>
                           <option value="Machinery">Machinery</option>
                           <option value="Insurance">Insurance</option>
                           <option value="Hospitality">Hospitality</option>
                           <option value="Healthcare">Healthcare</option>
                           <option value="Apparel">Apparel</option>
                           <option value="Food and Baverage">Food and Baverage</option>
                           <option value="Finance">Finance</option>
                           <option value="Environmental">Environmental</option>
                           <option value="Entertainment">Entertainment</option>
                           <option value="Engineering">Engineering</option>
                           <option value="Energy">Energy</option>
                           <option value="Electronic">Electronic</option>
                           <option value="Education">Education</option>
                           <option value="Consulting">Consulting</option>
                           <option value="Construction">Construction</option>
                           <option value="Communications">Communications</option>
                           <option value="Chemicals">Chemicals</option>
                           <option value="Biotechnology">Biotechnology</option>
                           <option value="Banking">Banking</option>
                        </select>
                     </div>
                     <div class="col-md-6 mb-3">
                        <label>Assign To</label>
                        <input type="text" class="form-control onlyLetters" name="assigned_to" id="assigned_to" placeholder="Assigned To">
                     </div>
                     <div class="col-md-6 mb-3">
                        <label>Annual Revenue</label>
                        <input type="number" class="form-control " name="annual_revenue" id="annualRevenue" placeholder="Annual Revenue">
                     </div>
                     <div class="col-md-6 mb-3">
                        <label>Type</label>    
                        <select class="form-control " name="type" id="typeId">
                           <option value="">Type</option>
                           <option value="Lead">Lead</option>
                           <option value="Sales Qualified Lead">Sales Qualified Lead</option>
                           <option value="Customer">Customer</option>
                           <option value="Compatitor">Compatitor</option>
                           <option value="Partner">Partner</option>
                           <option value="Analyst">Analyst</option>
                           <option value="Vendor">Vendor</option>
                        </select>
                     </div>
                     <div class="col-md-6 mb-3">
                        <label>Region</label>    
                        <select class="form-control" name="region" id="regionID" >
                           <option value="">Region</option>
                           <option value="NAM">NAM</option>
                           <option value="LAM">LAM</option>
                           <option value="EU">EU</option>
                           <option value="APAC">APAC</option>
                           <option value="MEA">MEA</option>
                        </select>
                     </div>
                     <div class="col-md-6 mb-3">
                        <label>GSTIN</label>    
                        <input type="text" class="form-control " name="gstin" id="gstinId" placeholder="GSTIN" maxlength="15">
                        <span id="gstin_error" style="color:red;font-size: 14px;"></span>
                     </div>
                     <div class="col-md-6 mb-3">
                        <label>Pan Number</label>    
                        <input type="text" class="form-control " name="panno" id="panno" placeholder="Pan Number" maxlength="10">
                        <span id="panno_error"></span>
                     </div>
                  </div>
                  <div id="div2" class="targetDiv form-row col-md-12" style="display: none;">
                     <div class="col-md-6 mb-3">
                        <h6>Billing Address</h6>
                     </div>
                     <div class="col-md-5 mb-2">
                        <h6>Shipping Address</h6>
                     </div>
                     <div class="col-md-1 mb-1">
                        <button type="button" class="btn btn-info btn-sm" onclick="copy(this.form)">Copy</button>
                     </div>
                     <div class="col-md-3 mb-3">
                        <label>Country <span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control  ui-autocomplete-input" name="billing_country" placeholder="Country" id="country"  required="" autocomplete="off">
                        <input type="hidden" class="form-control " id="country_ids" >
                        <span id="billing_country_error"></span>
                     </div>
                     <div class="col-md-3 mb-3">
                        <label>State <span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control  ui-autocomplete-input" name="billing_state" placeholder="State" id="states" required="" autocomplete="off">
                        <input type="hidden" class="form-control " id="state_id" >
                        <span id="billing_state_error"></span>
                     </div>
                     <div class="col-md-3 mb-3">
                        <label>Country <span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control  ui-autocomplete-input" name="shipping_country" placeholder="Country" id="s_country" required="" autocomplete="off">
                        <input type="hidden" class="form-control " id="s_country_id" >
                        <span id="shipping_country_error"></span>
                     </div>
                     <div class="col-md-3 mb-3">
                        <label>State <span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control  ui-autocomplete-input" name="shipping_state" placeholder="State" id="s_states" required="" autocomplete="off">
                        <input type="hidden" class="form-control " id="s_state_id" >
                        <span id="shipping_state_error"></span>
                     </div>
                     <div class="col-md-3 mb-3">
                        <label>City <span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control  ui-autocomplete-input" name="billing_city" placeholder="City" id="cities" required="" autocomplete="off">
                        <span id="billing_city_error"></span>
                     </div>
                     <div class="col-md-3 mb-3">
                        <label>Zipcode <span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control numeric" maxlength="6" name="billing_zipcode" placeholder="Zipcode" required="" id="billingZipcode">
                        <span id="billing_zipcode_error"></span>
                     </div>
                     <div class="col-md-3 mb-3">
                        <label>City <span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control  ui-autocomplete-input" name="shipping_city" placeholder="City" id="s_cities" required="" autocomplete="off">
                        <span id="shipping_city_error"></span>
                     </div>
                     <div class="col-md-3 mb-3">
                        <label>Zipcode <span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control numeric" maxlength="6" name="shipping_zipcode" placeholder="Zipcode" required="" id="shippingZipcode">
                        <span id="shipping_zipcode_error"></span>
                     </div>
                     <div class="col-md-6 mb-3">
                        <label>Address <span style="color: #f76c6c;">*</span></label>
                        <textarea type="text" class="form-control " name="billing_address" placeholder="Address" required="" id="billingAddress"></textarea>
                        <span id="billing_address_error"></span>
                     </div>
                     <div class="col-md-6 mb-3">
                        <label>Address <span style="color: #f76c6c;">*</span></label>
                        <textarea type="text" class="form-control " name="shipping_address" placeholder="Address" required="" id="shippingAddress"></textarea>
                        <span id="shipping_address_error"></span>
                     </div>
                  </div>
                  <div id="div3" class="targetDiv form-row col-md-12" style="display: none;">
                     <div class="col-md-12 mb-6">
                        <table style="margin-bottom:5px;" id="add">
                           <tbody>
                              <tr>
                                 <td width="4%"><input id="checkbox" type="checkbox"></td>
                                 <td width="24%"><input name="contact_name_batch[]" id="contact_name_batch" class="form-control " data-toggle="tooltip" title="Tittle" type="text" placeholder="Contact Name"></td>
                                 <td width="24%"><input name="email_batch[]" id="email_batch" class="form-control " data-toggle="tooltip" title="Tittle" type="text" placeholder="Email"></td>
                                 <td width="24%"><input name="phone_batch[]" id="phone_batch" class="form-control  start" data-toggle="tooltip" title="Tittle" type="text" placeholder="Work Phone"></td>
                                 <td width="24%"><input name="mobile_batch[]" id="mobile_batch" class="form-control phonePaste numeric"  maxlength="10" data-toggle="tooltip" title="Tittle" type="text" placeholder="Mobile"></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div class="col-md-2">
                        <input type="button" class="add_row btn btn-outline-info btn-sm" value="Add Row" id="add_row">
                     </div>
                     <div class="col-md-2">
                        <button type="button" class="delete_row btn btn-outline-danger btn-sm" id="delete_row">Delete Row</button>
                     </div>
                     <div class="col-md-8">
                     </div>
                  </div>
                  <div id="div4" class="targetDiv form-row col-md-12" style="display: none;">
                     <div class="col-md-12 mb-3">
                        <label>Description</label>
                        <textarea type="text" class="form-control" name="description" id="descriptionTxt"  placeholder="Description"></textarea>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <span id="error_msg" style="color: red;font-size: 14px;font-weight: 200px; "></span>
            <button type="button" id="btnSave" onclick="save()" class="btn btn-info btn-sm"style="background:rgba(35,0,140,0.8);">Save</button>
         </div>
      </div>
   </div>
</div>
<!-- Start New Customer Model -->
<div class="modal fade" id="modal_import_org" role="dialog" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">CSV File&nbsp;Import for Customer</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <form method="post" id="import_form" enctype="multipart/form-data">
               <p><h5>Select CSV File</h5>
                  <input type="file" name="file" id="file" required accept=".csv" />
                  <br><a href="<?php echo SAMPLE_EXCEL;?>org_sample.csv">View CSV File sample</a>
               </p>
               <p>Note:-Mandatory fields<br>
                  Organization Name, Contact Person, Email, Mobile, Type, Billing & Shipping Address details.
               </p>
               <br />
               <div id="excel_table">
                  <b>**Note : These Entries Already Existed</b>
                  <table id="duplicate_entry" style="width: 100%;">
                     <tr>
                        <th>Name</th>
                        <th>Organization</th>
                     </tr>
                  </table>
               </div>
               <br>
               <!-- <input type="submit" name="import" value="Import" class="btn btn-info" id="import_button" /> -->
               <button type="submit" name="import" value="Import" class="btn btn-info ripple" id="import_button"style="background:rgba(35,0,140,0.8);">Import</button>
               <label style="padding-top: 7px;float: right;"><i class="fas fa-info-circle" style="color:red"></i> Only csv file accepted.</label>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
<!-- End New Customer Model -->
<?php } ?>	
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<script>
   var editor = CKEDITOR.replace( 'descriptionTxt' );
   CKEDITOR.config.height='100px';
</script>
<script>
   function import_excel()
   {
     $('#modal_import_org').modal('show'); // show bootstrap modal
     $('#file').val('');
     $("#excel_table").hide();
     $("#duplicate_entry").empty();
     $("#import_button").attr('disabled',false);
   }
      $("#excel_table").hide();
   $('#import_form').on('submit', function(event){
   event.preventDefault();
   $.ajax({
    url:"<?php echo base_url(); ?>organizations/import",
    method:"POST",
    data:new FormData(this),
    dataType : 'JSON',
    contentType:false,
    cache:false,
    processData:false,
    success:function(response)
    {
     
     if(response.st == 202)
     {
       $('#file').val('');
       toastr.info(response.msg);
       
     }
     else if(response.st == 200)
     {
       $('#file').val('');
       toastr.success(response.msg);
       $('#modal_import_org').modal('hide');
       window.location.reload();
     }
     else 
     {
       // To append the Excel data
       $.each(response, function() 
       {
         $("#excel_table").show();
         var message = "<tr><td>"+this.org_name+"</td><td>"+this.email+"</td><td>"+this.primary_contact+"</td></tr>";
        $("#duplicate_entry").append(message);
      });
       $("#import_button").attr('disabled',true);
     }
     
    }
   })
   });
      <?php if(check_permission_status('Customer','retrieve_u')==true): ?>
       var table;
       table = $('#ajax_datatable').DataTable({
           "processing": true, 
           "serverSide": true, 
           "order": [], 
           "ajax": {
               "url": "<?= base_url('organizations/ajax_list')?>",
               "type": "POST",
               "data" : function(data)
               {
                   data.searchDate = $('#date_filter').val();
                   data.cust_types = $('#cust_types').val();
                   data.searchUser = $("#user_filter").val();
               }
           },
           "columnDefs": [
           {
             "targets": [0],
             "orderable": false, 
           },
           ],
       });
       $('#date_filter').change(function(){
         table.ajax.reload();
       });
       $('#cust_types').change(function(){
       table.ajax.reload();
       });
   <?php endif; ?>
   
   
   var save_method;
   function copy(form)
   {
     form.shipping_country.value=form.billing_country.value;
     form.shipping_state.value=form.billing_state.value;
     form.shipping_city.value=form.billing_city.value;
     form.shipping_zipcode.value=form.billing_zipcode.value;
     form.shipping_address.value=form.billing_address.value;
   }
   function check_org()
   {
     var org_name = $('#org_name_check').val();
     if(org_name != ''){
       $.ajax({
        url: "<?= base_url(); ?>organizations/check_org",
        method: "POST",
        data: {org_name:org_name},
        success: function(data){
         $('#org_name_error').html(data);
        }
       });
     }
   }
   <?php if(check_permission_status('Customer','create_u')==true): ?>
       function add_form()
       {
         save_method = 'add';
         $("#save_method").val('add');
         $('#form')[0].reset(); // reset form on modals
         $('.form-group').removeClass('has-error'); // clear error class
         $('.help-block').empty(); // clear error string
         $('#modal_form').modal('show'); // show bootstrap modal
         $('.modal-title').text('Add Customer'); // Set Title to Bootstrap modal title
         $("#add").find("tr").remove();
         CKEDITOR.instances['descriptionTxt'].setData('');
         var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
         "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name'></td>"+
         "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email'></td>"+
         "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone'></td>"+
         "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control phonePaste numeric'  maxlength='10' type='text' placeholder='Mobile'></td></tr>";
         $("#add").append(markup);
         $("#add_row").show();
         $("#delete_row").show();
         $("#org_name_check").attr('readonly', false);
         $("#org_name_error").html('');
         $("#primary_contact_error").html('');
         $("#email_error").html('');
         $("#office_phone_error").html('');
         $("#mobile_error").html('');
         $("#gstin_error").html('');
         $("#billing_country_error").html('');
         $("#billing_state_error").html('');
         $("#shipping_country_error").html('');
         $("#shipping_state_error").html('');
         $("#billing_city_error").html('');
         $("#billing_zipcode_error").html('');
         $("#shipping_city_error").html('');
         $("#shipping_zipcode_error").html('');
         $("#billing_address_error").html('');
         $("#shipping_address_error").html('');
         $('#btnSave').text('Save'); //change button text
       }
   <?php endif; ?>
   
   
   /****** VALIDATION FUNCTION FOR ORG*********/
   function changeClr(idinpt){
   $('#'+idinpt).css('border-color','red');
   $('#'+idinpt).focus();
   setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
   }
   
   function checkValidation(){
   var org_name_check=$('#org_name_check').val();
   var cust_types = $('#cust_type_select').val();
   var primary_contact=$('#primary_contact_org').val();
   var emailId=$('#emailId').val();
   var mobileId=$('#mobileId').val();
   var country=$('#country').val();
   var states=$('#states').val();
   var cities=$('#cities').val();
   var billingZipcode=$('#billingZipcode').val();
   var billingAddress=$('#billingAddress').val();
   var s_country=$('#s_country').val();
   var s_states=$('#s_states').val();
   var s_cities=$('#s_cities').val();
   var shippingZipcode=$('#shippingZipcode').val();
   var shippingAddress=$('#shippingAddress').val();
   
   if(cust_types=="" || cust_types===undefined || cust_types===null){
       changeClr('cust_type_select');
     
     return false;
   }else if(org_name_check=="" || org_name_check===undefined){
     changeClr('org_name_check');
     return false;  
   }else if(primary_contact=="" || primary_contact===undefined){
     changeClr('primary_contact_org');
     return false;
   }else if(emailId=="" || emailId===undefined){
     changeClr('emailId');
     return false;
   }else if(mobileId=="" || mobileId===undefined){
     changeClr('mobileId');
     return false;
   }else if(country=="" || country===undefined || country===null){
     changeClr('country');
     $('#forTarget2').click();
   console.log('country');
     return false;
   }else if(states=="" || states===undefined || states===null){
     changeClr('states');
     $('#forTarget2').click();
     return false;
   }else if(cities=="" || cities===undefined){
     changeClr('cities');
     $('#forTarget2').click();
   console.log('city');
     return false;
   }else if(billingZipcode=="" || billingZipcode===undefined || billingZipcode===null){
     changeClr('billingZipcode');
     $('#forTarget2').click();
   console.log('bzip');
     return false;
   }else if(billingAddress=="" || billingAddress===undefined){
     changeClr('billingAddress');
     $('#forTarget2').click();
   console.log('address');
     return false;
   }else if(s_country=="" || s_country===undefined){
     changeClr('s_country');
     $('#forTarget2').click();
   console.log('s_country');
     return false;
   }else if(s_states=="" || s_states===undefined){
     changeClr('s_states');
     $('#forTarget2').click();
   console.log('s_states');
     return false;
   }else if(s_cities=="" || s_cities===undefined){
     changeClr('s_cities');
     $('#forTarget2').click();
   console.log('s_cities');
     return false;
   }else if(shippingZipcode=="" || shippingZipcode===undefined){
     changeClr('shippingZipcode');
     $('#forTarget2').click();
   console.log('s_zip');
     return false;
   }else if(shippingAddress=="" || shippingAddress===undefined){
     changeClr('shippingAddress');
   console.log('a_add');
     $('#forTarget2').click();
     return false;
   }else{
     return true;
   } 
   }
   
   
   $('.form-control').keypress(function(){
   $(this).css('border-color','')
   });
   $('.form-control').change(function(){
   $(this).css('border-color','')
   });
   function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

$("#ajax_datatable").DataTable().ajax.reload();
}
   
   
   
   
   <?php if(check_permission_status('Customer','create_u')==true || check_permission_status('Customer','update_u')==true ): ?>
       function save()
       {
   if(checkValidation()==true){
             $('#btnSave').text('saving...'); //change button text
             $('#btnSave').attr('disabled',true); //set button disable
             var url;
             if(save_method == 'add') {
                 url = "<?= base_url('Organizations/create')?>";
             } else {
                 url = "<?= base_url('Organizations/update')?>";
             }
   		  
   for (var i in CKEDITOR.instances) {
           CKEDITOR.instances[i].updateElement();
   };
         $.ajax({
             url : url,
             type: "POST",
             data: $('#form').serialize(),
             dataType: "JSON",
             cache:false,
             success: function(data)
             {
                 console.log(data)
               if(data.status) 
               {
                   toastr.success('Your customer has been added successfully.');
                   $('#modal_form').modal('hide');
                   table.ajax.reload();
               }
               $('#btnSave').text('save'); //change button text
               $('#btnSave').attr('disabled',false); //set button enable
               if(data.st==202)
               {
                 $("#org_name_error").html(data.org_name);
                 $("#customer_type_error").html(data.cust_types);
                 $("#primary_contact_error").html(data.primary_contact);
                 $("#email_error").html(data.email);
                 $("#mobile_error").html(data.mobile);
                 $("#billing_country_error").html(data.billing_country);
                 $("#billing_state_error").html(data.billing_state);
                 $("#shipping_country_error").html(data.shipping_country);
                 $("#shipping_state_error").html(data.shipping_state);
                 $("#billing_city_error").html(data.billing_city);
                 $("#billing_zipcode_error").html(data.billing_zipcode);
                 $("#shipping_city_error").html(data.shipping_city);
                 $("#shipping_zipcode_error").html(data.shipping_zipcode);
                 $("#billing_address_error").html(data.billing_address);
                 $("#shipping_address_error").html(data.shipping_address);
                 $("#error_msg").html('oops! there will be some error ');
               }
               else if(data.st==200)
               {
                 $("#org_name_error").html('');
                 $("#customer_type_error").html('');
                 $("#primary_contact_error").html('');
                 $("#email_error").html('');
                 $("#mobile_error").html('');
                 $("#billing_country_error").html('');
                 $("#billing_state_error").html('');
                 $("#shipping_country_error").html('');
                 $("#shipping_state_error").html('');
                 $("#billing_city_error").html('');
                 $("#billing_zipcode_error").html('');
                 $("#shipping_city_error").html('');
                 $("#shipping_zipcode_error").html('');
                 $("#billing_address_error").html('');
                 $("#shipping_address_error").html('');
                 $("#error_msg").html('');
               }
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
                 toastr.error('Something went wrong, Please try later.');
                 $('#btnSave').text('save');
                 $('#btnSave').attr('disabled',false); 
             }
         });
   }
       }
   <?php endif; ?>
   
   <?php if(check_permission_status('Customer','update_u')==true ): ?>
     function update(id)
     {
       save_method = 'update';
       $("#save_method").val('update');
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       $("#add").find("tr").remove();
       $("#add_row").hide();
       $("#delete_row").hide();
      $("#org_name_check").attr('readonly', true);
       // Reset Form Errors
       $("#org_name_error").html('');
       $("#primary_contact_error").html('');
       $("#email_error").html('');
       $("#office_phone_error").html('');
       $("#mobile_error").html('');
       $("#gstin_error").html('');
       $("#billing_country_error").html('');
       $("#billing_state_error").html('');
       $("#shipping_country_error").html('');
       $("#shipping_state_error").html('');
       $("#billing_city_error").html('');
       $("#billing_zipcode_error").html('');
       $("#shipping_city_error").html('');
       $("#shipping_zipcode_error").html('');
       $("#billing_address_error").html('');
       $("#shipping_address_error").html('');
       $('#btnSave').text('Update'); //change button text
   
       //Ajax Load data from ajax
       $.ajax({
         url : "<?php echo base_url('organizations/getbyId/')?>/" + id,
         type: "GET",
         dataType: "JSON",
         success: function(data)
         {
           $('[name="id"]').val(data.id);
           $('[name="sess_eml"]').val(data.sess_eml);
           $('[name="org_name"]').val(data.org_name);
           $('[id="cust_type_select"]').val(data.customer_type);
           $('[name="ownership"]').val(data.ownership);
           $('[name="primary_contact"]').val(data.primary_contact);
           $('[name="primary_contact_hide"]').val(data.primary_contact);
           $('[name="email"]').val(data.email);
           $('[name="website"]').val(data.website);
           $('[name="office_phone"]').val(data.office_phone);
           $('[name="mobile"]').val(data.mobile);
           $('[name="employees"]').val(data.employees);
           $('[name="industry"]').val(data.industry);
           $('[name="assigned_to"]').val(data.assigned_to);
           $('[name="annual_revenue"]').val(data.annual_revenue);
           $('[name="type"]').val(data.type);
           $('[name="region"]').val(data.region);
           $('[name="sic_code"]').val(data.sic_code);
           $('[name="sla_name"]').val(data.sla_name);
           $('[name="gstin"]').val(data.gstin);
           $('[name="panno"]').val(data.panno);
           $('[name="billing_country"]').val(data.billing_country);
           $('[name="billing_state"]').val(data.billing_state);
           $('[name="shipping_country"]').val(data.shipping_country);
           $('[name="shipping_state"]').val(data.shipping_state);
           $('[name="billing_city"]').val(data.billing_city);
           $('[name="billing_zipcode"]').val(data.billing_zipcode);
           $('[name="shipping_city"]').val(data.shipping_city);
           $('[name="shipping_zipcode"]').val(data.shipping_zipcode);
           $('[name="billing_address"]').val(data.billing_address);
           $('[name="shipping_address"]').val(data.shipping_address);
           $('[name="description"]').val(data.description);
           
            // CKEDITOR.instances['descriptionTxt'].setData(data.description);
            
           $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
           $('.modal-title').text('Update Customer'); // Set title to Bootstrap modal title
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
           alert('Error Retrieving Data From Database');
         }
       });
       $.ajax({
         url : "<?php echo base_url('organizations/getcontactById/')?>" + id,
         type: "GET",
         dataType: "JSON",
         success: function(data)
         {
           $.each(data, function(i, item) 
           {
             var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
             "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name' value='"+data[i].name+"' readonly></td>"+
             "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email' value='"+data[i].email+"' readonly></td>"+
             "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone' value='"+data[i].office_phone+"' readonly></td>"+
             "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile' value='"+data[i].mobile+"' readonly></td>";
             $("#add").append(markup);
           });
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
           alert('Error Retrieving Data From Database');
         }
       });
     }
   <?php endif; ?>
   <?php if(check_permission_status('Customer','delete_u')==true ):?>
     function delete_org(id)
     {
         if(confirm('Are you sure, You want to delete this data?'))
         {
             // ajax delete data to database
             $.ajax({
                 url : "<?= base_url('organizations/delete')?>/"+id,
                 type: "POST",
                 dataType: "JSON",
                 success: function(data)
                 {
                     //if success reload ajax table
                     $('#modal_form').modal('hide');
                      window.location.reload();
                 },
                 error: function (jqXHR, textStatus, errorThrown)
                 {
                     alert('Error deleting data');
                 }
             });
         }
     }
   <?php endif; ?>
</script>
<script>
</script>
<script>
   jQuery(function(){
         jQuery('.show_div').click(function(){
   	$('.show_div').removeClass('bgclr');
               jQuery('.targetDiv').hide();
               jQuery('#div'+$(this).attr('target')).show();
   	  $(this).addClass('bgclr');
   	  
         });
   });
</script>
<?php
   if(isset($_GET['up']) && $_GET['up']!=""){
   ?>
<script>
   update("<?=$_GET['up'];?>");
   var urlCur      = window.location.href;
    var  myArr = urlCur.split("?");
   var url = myArr[0];
   
   if (window.history.replaceState) {
      window.history.replaceState('', '', url);
   }
   
</script>
<?php } ?>
<script>
   $(document).ready(function(){
     $(".add_row").click(function()
     {
       var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
       "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control onlyLetters' type='text' placeholder='Contact Name'></td>"+
       "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email'></td>"+
       "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone'></td>"+
       "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile'></td>";
       $("#add").append(markup);
     });
     // Find and remove selected table rows
     $(".delete_row").click(function()
     {
       $("#add").find('input[id="checkbox"]').each(function()
       {
         if($(this).is(":checked"))
         {
           $(this).parents("tr").remove();
         }
       });
     });
     
    $('.delete_checkbox').click(function(){
     if($(this).is(':checked'))
     {
      $(this).closest('tr').addClass('removeRow');
     }
     else
     {
      $(this).closest('tr').removeClass('removeRow');
     }
    });
        $('#delete_all').click(function(){
           var checkbox = $('.delete_checkbox:checked');
           if(checkbox.length > 0)
           {
            $("#delete_confirmation").modal('show'); 
           }else{
              alert('Select atleast one records');
           }
        });
   });
   $("#confirmed").click(function(){
     deleteBulkItem('organizations/delete_bulk'); 
   });
</script>
<script>
   function refreshPage(){
       window.location.reload();
   } 
</script>
<!-- AUTOCOMPLETE QUERY -->
<script type="text/javascript">
   $('#gstinId').change(function(){
       
       $('#gstin_error').text(''); 
       $('#country').val('');
       $('#states').val('');
       $('#state_id').val('');
       $('#panno').val('');
       var gstin =  $('#gstinId').val();
    if(gstin.length == 15){
       var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
   
       if (gstinformat.test(gstin)) {
        //return true; 
       var tin = gstin.substring(0, 2);
       var panno =gstin.substring(2, 12);
       //alert(tin);
           $.ajax({ 
                   url: "<?= site_url('login/fetchstatebytin');?>",
                   data: {tin: tin},
                   dataType: "json",
                   type: "POST",
                   success: function(data){
                       //console.log(data.country);
                       $('#country').val(data.country);
                       $('#states').val(data.state);
                       $('#state_id').val(data.state_id);
                   }    
           });
       
       //console.log(tin);
       //console.log(panno);
       $('#panno').val(panno);
       }else{
       $('#gstin_error').text('GST Identification Number is not valid. It should be in this "11AAAAA1111Z1A1" format');
        setTimeout(function(){ $('#gstin_error').text(''); },4000);
    }
    }else{
       $('#gstin_error').text('Enter max 15 digit'); 
       setTimeout(function(){ $('#gstin_error').text(''); },3000);
    }
   });
   
   $('#gstinId').keypress(function(){
      $('#gstin_error').text('');
   });
   $(document).ready(function(){
     $('#country').autocomplete({
       source: "<?= site_url('login/autocomplete_countries');?>",
       select: function (event, ui) {
         $('#country').val(ui.item.label);
         $('#country_ids').val(ui.item.values);
         return false;
       }
     });
   });
</script>
<script>
   $(document).ready(function(){
     $('#states').autocomplete({
           source: function(request, response) {
              var country_id =$('#country_ids').val();
                $.ajax({ 
                   url: "<?= site_url('login/autocomplete_states');?>",
                   data: { terms: request.term, country_id: country_id},
                   dataType: "json",
                   type: "POST",
                   success: function(data){
                       response(data);
                   }    
                 });
               },
       //source: "<?= site_url('login/autocomplete_states');?>",
       select: function (event, ui) {
         $('#states').val(ui.item.label);
         $('#state_id').val(ui.item.values);
       }
     });
   });
</script>
<script>
   $(document).ready(function(){
     $('#cities').autocomplete({
         source: function(request, response) {
              var state_id =$('#state_id').val();
                $.ajax({ 
                   url: "<?= site_url('login/autocomplete_cities');?>",
                   data: { terms: request.term, state_id: state_id},
                   dataType: "json",
                   type: "POST",
                   success: function(data){
                       response(data);
                   }    
                 });
               },
       //source: "<?= site_url('login/autocomplete_cities');?>",
       select: function (event, ui) {
         $(this).val(ui.item.label);
       }
     });
   });
</script>
<script type="text/javascript">
   $(document).ready(function(){
     $('#s_country').autocomplete({
       source: "<?= site_url('login/autocomplete_countries');?>",
       select: function (event, ui) {
         $(this).val(ui.item.label);
         $('#s_country_id').val(ui.item.values);
       }
     });
   });
</script>
<script>
   $(document).ready(function(){
     $('#s_states').autocomplete({
         source: function(request, response) {
              var country_id =$('#s_country_id').val();
                $.ajax({ 
                   url: "<?= site_url('login/autocomplete_states');?>",
                   data: { terms: request.term, country_id: country_id},
                   dataType: "json",
                   type: "POST",
                   success: function(data){
                       response(data);
                   }    
                 });
               },
       //source: "<?= site_url('login/autocomplete_states');?>",
       select: function (event, ui) {
         $(this).val(ui.item.label);
         $('#s_state_id').val(ui.item.values);
       }
     });
   });
</script>
<script>
   $(document).ready(function(){
     $('#s_cities').autocomplete({
         source: function(request, response) {
              var state_id =$('#s_state_id').val();
                $.ajax({ 
                   url: "<?= site_url('login/autocomplete_cities');?>",
                   data: { terms: request.term, state_id: state_id},
                   dataType: "json",
                   type: "POST",
                   success: function(data){
                       response(data);
                   }    
                 });
               },
       //source: "<?= site_url('login/autocomplete_cities');?>",
       select: function (event, ui) {
         $(this).val(ui.item.label);
       }
     });
   });
</script>



<script>
function showAction(id) {
    var checkbox = $('input[value="' + id + '"].delete_checkbox');
 
    if (checkbox.is(':checked')) {
        $('#mass_id').val(id);
        // Show the button
        $('#mass_product').show();
    } else {
        // Hide the button if unchecked
        $('#mass_product').hide();
        
    }
}


$("#mass_model").click(function(){
      $('#mass_product_model').modal('show')
 });

</script>

<script>
  const typesRequiringLength = [
    'org_name', 'mobile', 'email', 'website', 'customer_type', 'type', 'industry',
    'primary_contact', 'ownership', 'region', 'office_phone', 'billing_country',
    'billing_state', 'billing_city', 'billing_zipcode', 'billing_address',
    'shipping_country', 'shipping_state', 'shipping_city', 'shipping_zipcode',
    'shipping_address', 'description', 'gstin', 'panno'
  ];

  document.addEventListener('change', function (e) {
    if (e.target.matches('.type-select')) {
      const selectedType = e.target.value.trim().toLowerCase();

      const wrapper = e.target.closest('.form-row');
      const lengthWrapper = wrapper.querySelector('.length-wrapper');

      const input = wrapper.querySelector('.length-input');
      const industrySelect = wrapper.querySelector('.industry-select');
      const customerTypeSelect = wrapper.querySelector('.customertype-select');
      const typesSelect = wrapper.querySelector('.types-select');
      const regionSelect = wrapper.querySelector('.region-select');

      if (typesRequiringLength.includes(selectedType)) {
        lengthWrapper.style.display = 'block';

        // Hide all first
        input.style.display = 'none';
        industrySelect.style.display = 'none';
        customerTypeSelect.style.display = 'none';
        typesSelect.style.display = 'none';
        regionSelect.style.display = 'none';

        // Show appropriate one
        if (selectedType === 'industry') {
          industrySelect.style.display = 'block';
        } else if (selectedType === 'customer_type') {
          customerTypeSelect.style.display = 'block';
        } else if (selectedType === 'type') {
          typesSelect.style.display = 'block';
        } else if (selectedType === 'region') {
          regionSelect.style.display = 'block';
        } else {
          input.style.display = 'block';
          input.placeholder = 'Enter value';
        }
      } else {
        lengthWrapper.style.display = 'none';
        input.value = '';
      }
    }
  });

  $('#massUpdateBtn').click(function (event) {
    event.preventDefault();

    // Get selected type
    var selectedType = $('#mass_name').val();
    var finalValue = '';

    // Decide which input to pick from
    if (selectedType === 'industry') {
      finalValue = $('#industry_select').val();
    } else if (selectedType === 'customer_type') {
      finalValue = $('#customer_type_select').val();
    } else if (selectedType === 'type') {
      finalValue = $('#types_select').val();
    } else if (selectedType === 'region') {
      finalValue = $('#region_select').val();
    } else {
      finalValue = $('#value_input').val();
    }

    // Set hidden field
    $('#final_value_input').val(finalValue);

    // Submit via AJAX
    var formData = $('#massForm').serialize();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('organizations/add_mass'); ?>",
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          alert(response.message);
          $('#mass_product_model').modal('hide');
           window.location.reload();
        } else {
          alert(response.message);
          window.location.reload();
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        alert('An error occurred while processing your request.');
      }
    });
  });
</script>
