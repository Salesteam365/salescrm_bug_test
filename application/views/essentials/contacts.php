<?php $this->load->view('common_navbar');?>
<style>
 #ajax_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   padding-top:18px;
  padding-bottom:18px;
  

}


#ajax_datatable tbody tr td {
  background-color: #fff; /* Set background color */
  font-size: 14px; /* Increase font size */
  font-family: system-ui;
  font-weight: 651;
  color:rgba(0,0,0,0.7);
  padding-top:16px;
  padding-bottom:16px;
   /* Change font family */
  /* Add any other styles as needed */
}

#ajax_datatable tbody tr td:nth-child(4) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
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
                        <option value="name">Contact Name</option>
                        <option value="org_name">Organization Name</option>
                        <option value="mobile"> Primary Phone</option>
                        <option value="email">Primary Email</option>

                        <option value="title">Title</option>
                        <option value="contact_type">Contact Type</option>

                        <option value="website"> Website </option> 
                        <option value="sla_name">SLA Name</option>
                        <option value="reports_to">Reports To</option>
                        <option value="department">Department</option>
                        <option value="contact_owner">Ownership</option> 
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
                        <option value="description">Description</option>

                     </select>
                  </div>
                  </div>

                  <!-- Input or Dropdown Field -->
                  <div class="col pl-1 length-wrapper" style="display: none;">
                  <div class="form-group">
                     <!-- Text Input -->
                     <input type="text" class="form-control length-input" id="value_input" placeholder="Enter Value">

                     <!-- title -->
                     <select class="form-control title-select" id="title_select" style="display: none;">
                        <option value="">Select Title</option>
                         <option value="CEO">CEO</option>
                            <option value="VP">VP</option>
                            <option value="Director">Director</option>
                            <option value="Sales Manager">Sales Manager</option>
                            <option value="Support Manager">Support Manager</option>
                            <option value="Sales Representative">Sales Representative</option>
                            <option value="Support Agent">Support Agent</option>
                            <option value="Procurment Manager">Procurment Manager</option>
                     </select>
                                         
                     <!-- Customer Type -->
                     <select class="form-control contact_type-select" id="contact_type_select" style="display: none;">
                        <option value="">Select Customer Type</option>
                        <option value="Customer">Customer</option>
                        <option value="Vendor">Vendor</option>
                        <option value="Both">Both</option>
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"  style="background-color:rgba(240,240,246,0.8);overflow-x:clip;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Contacts</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>home">Home</a></li>
              <li class="breadcrumb-item active">Contacts</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="container-fliud filterbtncon"  >
        <?php 
                                   $fifteen = strtotime("-15 Day"); 
                                   $thirty = strtotime("-30 Day"); 
                                   $fortyfive = strtotime("-45 Day"); 
                                   $sixty = strtotime("-60 Day"); 
                                   $ninty = strtotime("-90 Day"); 
                                   $six_month = strtotime("-180 Day"); 
                                   $one_year = strtotime("-365 Day");
                            ?>
         <div class="row mb-3">

         <div class="col-lg-2">
         <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
    <input type="hidden" id="date_filter" value="" name="date_filter">
    <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li data-value="This Week">This Week</li>
        <?php $week = strtotime("-7 Day"); ?>
        <li data-value="<?= date('y.m.d', $week); ?>" onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','date_filter');">Last Week</li>
        <?php $fifteen = strtotime("-15 Day"); ?>
        <li data-value="<?= date('y.m.d', $fifteen); ?>" onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','date_filter');">Last 15 days</li>
        <?php $thirty = strtotime("-30 Day"); ?>
        <li data-value="<?= date('y.m.d', $thirty); ?>" onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','date_filter');">Last 30 days</li>
        <?php $fortyfive = strtotime("-45 Day"); ?>
        <li data-value="<?= date('y.m.d', $fortyfive); ?>" onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','date_filter');">Last 45 days</li>
        <?php $sixty = strtotime("-60 Day"); ?>
        <li data-value="<?= date('y.m.d', $sixty); ?>" onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','date_filter');">Last 60 days</li>
        <?php $ninty = strtotime("-90 Day"); ?>
        <li data-value="<?= date('y.m.d', $ninty); ?>" onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','date_filter');">Last 3 Months</li>
        <?php $six_month = strtotime("-180 Day"); ?>
        <li data-value="<?= date('y.m.d', $six_month); ?>" onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','date_filter');">Last 6 Months</li>
        <?php $one_year = strtotime("-365 Day"); ?>
        <li data-value="<?= date('y.m.d', $one_year); ?>" onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','date_filter');">Last 1 Year</li>
    </ul>
</div>
   </div>

          <div class="col-lg-4">
             <a id="mass_model" href="#" style="text-decoration:none;">
                <button type="button" id="mass_product" class="btn" style="display:none; border-radius: 2rem; margin-bottom: 1rem; background: #845ADF; color:#fff; font-weight: 500;">
                    Mass Update
                </button>
               </a>
          </div>
        
          <div class="col-lg-6">
              <div class="refresh_button float-right">
                  <button class="btnstopcorner" onclick="refreshPage();"><i class="fas fa-redo-alt"></i></button>
				  <?php if($this->session->userdata('type')=='admin'){ ?>
				  <a href='Export_data/export_customer_contact_csv' class="p-0" ><button class="btnstopcorn">Export Data</button></a>
				  <?php } ?>
				  
				  <?php if(check_permission_status('Contacts','create_u')==true){
					 if($this->session->userdata('account_type')=="Trial" && (isset($countContact) && $countContact>=2000)){
						?>
					<button class="btnstop" onclick="infoModal('You are exceeded  your customer/contact limit - 2,000')" >Add New</button>
					 <?php }else{ ?>	
                  <button class="btncorner" onclick="import_excel();">Import Excel</button>
                  <button class="btnstop" onclick="add_form();">Add New</button>
					 <?php } } ?>
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                          <?php if(check_permission_status('Contacts','delete_u')==true):?>
                            <th><button class="btn" type="button" name="delete_all" id="delete_all2"><i class="fa fa-trash text-light"></i></button></th>
                          <?php endif; ?>
                          <th class="th-sm">Organization Name</th>
                          <th class="th-sm">Contact Name</th>
                          
                          <th class="th-sm">Primary Email</th>
                          <th class="th-sm">Primary Phone</th>
                          <th class="th-sm">Contact Owner</th>
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
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
  <?php if(check_permission_status('Contacts','create_u')==true):?>
    <!-- Add new modal -->
      <div class="modal fade show" id="excel_modal" role="dialog" aria-modal="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="organization_add_edits">Import CSV File</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body form">
                <form method="post" id="import_form" enctype="multipart/form-data">
                  <label>Select CSV File</label>
                  <input type="file" name="file" id="file" required accept=".csv" >
                  <a href="<?= base_url(); ?>assets/excel/sample.csv">View CSV File Sample</a>
                  <br>
                  <p>Note:-Mandatory fields<br>
                    Contact Name, Contact Owner, Organization, Mobile, Billing & Shipping Address details.
                    </p>
                  <div id="excel_table">
                    <b>**Note : These Entries Already Existed</b>
                    <table class="table table-responsive-lg-sm table-striped table-bordered" id="duplicate_entry">
                      <tbody>
                        <tr>
                          <th>Name</th>
                          <th>Organization</th>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                      <label style="padding-top: 7px;float: left;"><i class="fas fa-info-circle" style="color:red"></i> Only csv file accepted.</label>
                  
                    <button type="submit" name="import" id="import_button" value="Import"  onclick="" class="btn btn-info btn-sm">Import</button>
                  </div>
                </form>
              </div>
              
          </div>
        </div>
      </div>
    <!-- Add new modal -->
  <?php endif; ?>
    
    <?php if(check_permission_status('Contacts','create_u')==true):?>
      <!-- Add new modal -->
      <div class="modal fade show" id="addnew_modal" role="dialog" aria-modal="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="organization_add_edits"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                      <input type="hidden" name="save_method" id="save_method">
                      <input type="hidden"  name="id">
                      <div class="form-body form-row">
                        <div class="col-md-6 mb-3">
                          <label>Contact Name <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control onlyLetters" name="name" id="contact_name_check" placeholder="Contact Name" onChange="check_contact()">
                          <span id="name_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Ownership</label>
                          <input type="text" class="form-control" name="assigned_to" placeholder="Ownership" value="<?= $this->session->userdata('name')?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Organization Name <span style="color: #f76c6c;">*</span></label>
                          <div class="input-group-append">
                            <input type="text" class="form-control ui-autocomplete-input" name="org_name" placeholder="Organization Name" id="org_name" >
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="add_formOrg('Customer')" ><i class="fa fa-plus"></i></button>
                          </div>
                          <span id="org_name_error" style="display: block;width: 100%;"></span>
                        </div>
                         
                        <div class="col-md-6 mb-3">
                          <label>Website</label>
                          <input type="text" class="form-control" id="website" name="website" placeholder="Website">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Email ID</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email ID">
                          <span id="email_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Office Phone</label>
                          <input type="number" class="form-control landline" maxlength="10" id="office_phone" name="office_phone" placeholder="Office Phone" maxlength="15">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Mobile Number <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control phonePaste numeric" maxlength="10" id="mobile" name="mobile" placeholder="Enter Mobile Number">
                          <span id="mobile_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>SLA Name</label>
                          <input type="text" class="form-control onlyLetters" id="sla_name" name="sla_name" placeholder="SLA Name">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Reports To</label>
                          <input type="text" class="form-control onlyLetters" name="report_to" id="report_to" placeholder="Reports To">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Title</label>
                          <select class="form-control" name="title">
                            <option value="" selected=" disabled"></option>
                            <option value="CEO">CEO</option>
                            <option value="VP">VP</option>
                            <option value="Director">Director</option>
                            <option value="Sales Manager">Sales Manager</option>
                            <option value="Support Manager">Support Manager</option>
                            <option value="Sales Representative">Sales Representative</option>
                            <option value="Support Agent">Support Agent</option>
                            <option value="Procurment Manager">Procurment Manager</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Department</label>
                          <input type="text" class="form-control onlyLetters" name="department" id="department" placeholder="Department">
                        </div>
                        <div class="col-md-6 mb-3">
                        </div>
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
                          <input type="text" class="form-control ui-autocomplete-input" name="billing_country" placeholder="Country" id="country" required>
                          <input type="hidden" class="form-control" id="country_ids" >
                          <span id="billing_country_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>State <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="billing_state" placeholder="State" id="states" required="">
                          <input type="hidden" class="form-control" id="state_id" >
                          <span id="billing_state_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Country <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="shipping_country" placeholder="Country" id="s_country" required>
                          <input type="hidden" class="form-control" id="s_country_id" >
                          <span id="shipping_country_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>State <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="shipping_state" placeholder="State" id="s_states" required>
                          <input type="hidden" class="form-control" id="s_state_id" >
                          <span id="shipping_state_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>City <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="billing_city" placeholder="City" id="cities" required>
                          <span id="billing_city_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Zipcode <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control numeric" maxlength="6" name="billing_zipcode" placeholder="Zipcode" id="zipcode" required>
                          <span id="billing_zipcode_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>City <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="shipping_city" placeholder="City" id="s_cities" required>
                          <span id="shipping_city_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Zipcode <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control numeric" maxlength="6" name="shipping_zipcode" placeholder="Zipcode" id="s_zipcode" required>
                          <span id="shipping_zipcode_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Address <span style="color: #f76c6c;">*</span></label>
                          <textarea type="text" class="form-control" name="billing_address" placeholder="Enter Address" id="address" required></textarea>
                          <span id="billing_address_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Address <span style="color: #f76c6c;">*</span></label>
                          <textarea type="text" class="form-control" name="shipping_address" placeholder="Address" id="s_address" required></textarea>
                          <span id="shipping_address_error"></span>
                        </div>
                        <div class="col-md-12 mb-3">
                          <label>Description</label>
                          <textarea type="text" class="form-control" name="description" id="descriptionTxt" placeholder="Enter Description"></textarea>
                        </div>
                      </div>
                    </form>
                  </div>
              <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save();return false;" class="btn btn-info btn-sm">Save</button>
              </div>
          </div>
        </div>
      </div>
      <!-- Add new modal -->
    <?php endif; ?>
      <?php if(check_permission_status('Contacts','retrieve_u')==true):?>
	  
      <!-- View modal -->
      <div class="modal fade show" id="view_modal" role="dialog" aria-modal="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="contact_add_edit">Contact Form</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body form">
                <form id="view" class="row" action="#">
                  <div class="col-sm-12">
                    <h5 class="text-primary" id="name"></h5>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Created&nbsp;Date:</span><h6 class="text-primary" id="created_date"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Ownership:</span><h6 class="text-primary" id="assigned_to"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Organization&nbsp;Name:</span><h6 class="text-primary" id="org_name_view"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Email:</span><h6 class="text-primary" id="email"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Office&nbsp;Phone:</span><h6 class="text-primary" id="office_phone"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Mobile:</span><h6 class="text-primary" id="mobile"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">SLA&nbsp;Name:</span><h6 class="text-primary" id="sla_name"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Reports&nbsp;To:</span><h6 class="text-primary" id="report_to"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Title:</span><h6 class="text-primary" id="title"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Department:</span><h6 class="text-primary" id="department"></h6>
                  </div>
                  <div class="col-sm-12">
                    <h5>Address&nbsp;Details:</h5>
                  </div>
                  <div class="col-sm-3">
                    <span class="text-secondary">Billing&nbsp;Country:</span><h6 class="text-primary" id="billing_country"></h6>
                  </div>
                  <div class="col-sm-3">
                    <span class="text-secondary">Billing&nbsp;State:</span><h6 class="text-primary" id="billing_state"></h6>
                  </div>
                  <div class="col-sm-3">
                    <span class="text-secondary">Shipping&nbsp;Country:</span><h6 class="text-primary" id="shipping_country"></h6>
                  </div>
                  <div class="col-sm-3">
                    <span class="text-secondary">Shipping&nbsp;State:</span><h6 class="text-primary" id="shipping_state"></h6>
                  </div>
                  <div class="col-sm-3">
                    <span class="text-secondary">Billing&nbsp;City:</span><h6 class="text-primary" id="billing_city"></h6>
                  </div>
                  <div class="col-sm-3">
                    <span class="text-secondary">Billing&nbsp;Zipcode:</span><h6 class="text-primary" id="billing_zipcode"></h6>
                  </div>
                  <div class="col-sm-3">
                    <span class="text-secondary">Shipping&nbsp;City:</span><h6 class="text-primary" id="shipping_city"></h6>
                  </div>
                  <div class="col-sm-3">
                    <span class="text-secondary">Shipping&nbsp;Zipcode:</span><h6 class="text-primary" id="shipping_zipcode"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Billing&nbsp;Address:</span><h6 class="text-primary" id="billing_address"></h6>
                  </div>
                  <div class="col-sm-6">
                    <span class="text-secondary">Shipping&nbsp;Address:</span><h6 class="text-primary" id="shipping_address"></h6>
                  </div>
                  <div class="col-sm-12">
                    <span class="text-secondary">Description:</span><h6 class="text-primary" id="description"></h6>
                  </div>
                </form>
              </div>
          </div>
        </div>
      </div>
      <!-- View modal -->
    <?php endif; ?>
 
</div>
<?php $this->load->view('footer');?>
<!-- ./wrapper -->

<style>
.text-secondary {
    color: #383737!important;
}
</style>

<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<?php $this->load->view('commonAddorg_modal');?>


<script>
var editor = CKEDITOR.replace( 'descriptionTxt' );
CKEDITOR.config.height='100px';
</script>
<script>
function copy(form)
{
  form.shipping_country.value=form.billing_country.value;
  form.shipping_state.value=form.billing_state.value;
  form.shipping_city.value=form.billing_city.value;
  form.shipping_zipcode.value=form.billing_zipcode.value;
  form.shipping_address.value=form.billing_address.value;
}
</script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<script>
$(document).ready(function () {
  var save_method; //for save method string
  var table;
  <?php if(check_permission_status('Contacts','retrieve_u')==true): ?>
 
    table = $('#ajax_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url('contacts/ajax_list')?>",
            "type": "POST",
            "data" : function(data)
            {
                data.searchDate = $('#date_filter').val();
            }
        },
        "columnDefs": [
        {
          "targets": [0], //last column
          "orderable": false, //set not orderable
        },
        ],
    });

    $('#date_filter').change(function(){
      
      table.ajax.reload();
    });


    

  <?php endif; ?>
});
</script>
<script>
  <?php if(check_permission_status('Contacts','create_u')==true):?>
    function add_form()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#addnew_modal').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add Contact'); // Set Title to Bootstrap modal title
       CKEDITOR.instances['descriptionTxt'].setData('');
      //Reset Form Errors
      $("#name_error").html('');
      $("#org_name_error").html('');
      $("#mobile_error").html('');
      $("#email_error").html('');
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
    }
  <?php endif; ?>
  <?php if(check_permission_status('Contacts','create_u')==true || check_permission_status('Contacts','update_u')==true):?>
    function save() 
    {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable
      var url;
      if(save_method == 'add') {
          url = "<?= site_url('contacts/create')?>";
      } else {
          url = "<?= site_url('contacts/update')?>";
      }
	    for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
		};
      // ajax adding data to database
      $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
          if(data.status) //if success close modal and reload ajax table
          {
            $('#addnew_modal').modal('hide');
            window.location.reload();
          }
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable

          if(data.st==202)
          {
            $("#name_error").html(data.name);
            $("#org_name_error").html(data.org_name);
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
          }
          else if(data.st==200)
          {
            $("#name_error").html('');
            $("#email_error").html('');
            $("#org_name_error").html('');
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
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error adding / update data');
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
        }
      });
    }
  <?php endif; ?>
  <?php if(check_permission_status('Contacts','retrieve_u')==true):?>
    function view(id)
    {
      $('#view')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      //Ajax Load data from ajax
      $.ajax({
          url : "<?php echo site_url('contacts/getbyId/')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            $('[id="name"]').text(data.name);
            $('[id="created_date"]').text(data.datetime);
            $('[id="org_name_view"]').text(data.org_name);
            $('[id="email"]').text(data.email);
            $('[id="website"]').text(data.website);
            $('[id="office_phone"]').text(data.office_phone);
            $('[id="mobile"]').text(data.mobile);
            $('[id="assigned_to"]').text(data.contact_owner);
            $('[id="sla_name"]').text(data.sla_name);
            $('[id="report_to"]').text(data.report_to);
            $('[id="title"]').text(data.title);
            $('[id="department"]').text(data.department);
            $('[id="billing_country"]').text(data.billing_country);
            $('[id="billing_state"]').text(data.billing_state);
            $('[id="shipping_country"]').text(data.shipping_country);
            $('[id="shipping_state"]').text(data.shipping_state);
            $('[id="billing_city"]').text(data.billing_city);
            $('[id="billing_zipcode"]').text(data.billing_zipcode);
            $('[id="shipping_city"]').text(data.shipping_city);
            $('[id="shipping_zipcode"]').text(data.shipping_zipcode);
            $('[id="billing_address"]').text(data.billing_address);
            $('[id="shipping_address"]').text(data.shipping_address);
            $('[id="description"]').html(data.description);
            $('#view_modal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Contact'); // Set title to Bootstrap modal title
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error Retrieving Data From Database');
          }
      });
    }
  <?php endif; ?>
  <?php if(check_permission_status('Contacts','update_u')==true):?>
    function update(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Reset Form Errors
        $("#name_error").html('');
        $("#org_name_error").html('');
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

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('contacts/getbyId/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              $('[name="id"]').val(data.id);
              $('[name="name"]').val(data.name);
              $('[name="org_name"]').val(data.org_name);
              $('[name="email"]').val(data.email);
              $('[name="website"]').val(data.website);
              $('[name="office_phone"]').val(data.office_phone);
              $('[name="mobile"]').val(data.mobile);
              $('[name="assigned_to"]').val(data.contact_owner);
              $('[name="sla_name"]').val(data.sla_name);
              $('[name="report_to"]').val(data.report_to);
              $('[name="title"]').val(data.title);
              $('[name="department"]').val(data.department);
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
              //$('[name="description"]').val(data.description);
			  CKEDITOR.instances['descriptionTxt'].setData(data.description);
              $('#addnew_modal').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Update Contact'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Retrieving Data From Database');
            }
        });
    }
  <?php endif; ?>
  <?php if(check_permission_status('Contacts','delete_u')==true):?>
    function delete_entry(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?= site_url('contacts/delete')?>/"+id,
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
  jQuery(function(){
        jQuery('.show_div').click(function(){
              jQuery('.targetDiv').hide();
              jQuery('#div'+$(this).attr('target')).show();
        });
  });
</script>

<script>
$(document).ready(function(){
  $(".add_row").click(function()
  {
    var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
    "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control' type='text' placeholder='Contact Name'></td>"+
    "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control' type='text' placeholder='Email'></td>"+
    "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control start' type='text' placeholder='Work Phone'></td>"+
    "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control' type='text' placeholder='Mobile'></td>";
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
 
});


$('#delete_all2').click(function(){
  var checkbox = $('.delete_checkbox:checked');
  if(checkbox.length > 0)
  {
   $("#delete_confirmation").modal('show'); 
  }else{
   alert('Select atleast one records');
  }
 });
 
$("#confirmed").click(function(){
  deleteBulkItem('contacts/delete_bulk'); 
});


function check_contact()
{
  var contact_name = $('#contact_name_check').val();
  if(contact_name != '')
  {
    $.ajax({
     url: "<?= base_url(); ?>contacts/check_contact",
     method: "POST",
     data: {contact_name:contact_name},
     success: function(data)
     {
        $('#name_error').html(data);
     }
    });
  }
}
function import_excel()
{
  $('#excel_modal').modal('show'); // show bootstrap modal
  $('#file').val('');
  $("#excel_table").hide();
  $("#duplicate_entry").empty();
  $("#import_button").attr('disabled',false);
}
</script>
<!-- AUTOCOMPLETE QUERY -->
<script type="text/javascript">
$(document).ready(function(){
  $('#org_name').autocomplete({
    source: "<?= base_url('organizations/autocomplete_org');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#org_name').each(function(){
        var org_name = $(this).val();
        // AJAX request
        $.ajax({
          url:'<?=base_url('contacts/get_org_details')?>',
          method: 'post',
          data: {org_name: org_name},
          dataType: 'json',
          success: function(response){
            var len = response.length;
            if(len > 0)
            {
              var email = response[0].email;
              var website = response[0].website;
              var mobile = response[0].mobile;
              var phone = response[0].phone;
              var sla_name = response[0].sla_name;
              var billing_country = response[0].billing_country;
              var billing_state = response[0].billing_state;
              var billing_city = response[0].billing_city;
              var billing_zipcode = response[0].billing_zipcode;
              var billing_address = response[0].billing_address;
              var shipping_country = response[0].shipping_country;
              var shipping_state = response[0].shipping_state;
              var shipping_city = response[0].shipping_city;
              var shipping_zipcode = response[0].shipping_zipcode;
              var shipping_address = response[0].shipping_address;
              $('#website').val(website);
            //   $('#email').val(email);
            //   $('#mobile').val(mobile);
              $('#office_phone').val(phone);
              $('#sla_name').val(sla_name);
              $('#country').val(billing_country);
              $('#states').val(billing_state);
              $('#cities').val(billing_city);
              $('#zipcode').val(billing_zipcode);
              $('#address').val(billing_address);
              $('#s_country').val(shipping_country);
              $('#s_states').val(shipping_state);
              $('#s_cities').val(shipping_city);
              $('#s_zipcode').val(shipping_zipcode);
              $('#s_address').val(shipping_address);
            }
            else
            {
              $('#website').val('');
              $('#email').val('');
              $('#mobile').val('');
              $('#office_phone').val('');
              $('#sla_name').val('');
              $('#country').val('');
              $('#states').val('');
              $('#cities').val('');
              $('#zipcode').val('');
              $('#address').val('');
              $('#s_country').val('');
              $('#s_states').val('');
              $('#s_cities').val('');
              $('#s_zipcode').val('');
              $('#s_address').val('');
            }
          }
        });
      });
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('#country').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
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
      $(this).val(ui.item.label);
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
<?php if(isset($_GET['cnt']) && $_GET['cnt']!=""){ ?>
<script>
	view("<?=$_GET['cnt'];?>");
	var urlCur      = window.location.href;
	var  myArr 		= urlCur.split("?");
	var url			= myArr[0];
	if (window.history.replaceState) {
	   window.history.replaceState('', '', url);
	}
  
</script>
<?php } ?>


<script>
$(document).ready(function(){
  
  $("#excel_table").hide();
 $('#import_form').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"<?php echo base_url(); ?>contacts/import",
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
      alert(response.msg);
    }
    else if(response.st == 200)
    {
      $('#file').val('');
      alert(response.msg);
      $('#excel_modal').modal('hide');
      window.location.reload();
    }
    else 
    {
      // To append the Excel data
      $.each(response, function() 
      {
        $("#excel_table").show();
        var message = "<tr><td>"+this.name+"</td><td>"+this.org_name+"</td></tr>";
        $("#duplicate_entry").append(message);
       
     });
      
      $("#import_button").attr('disabled',true);
    }
    
   }
  })
 });

});
</script>
<script>
function refreshPage(){
    window.location.reload();
} 
function getfilterdData(e,g){
  var id = "#" + g;
  $(id).val(e);
  $("#ajax_datatable").DataTable().ajax.reload();
}

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
    'name','org_name', 'mobile', 'email', 'website', 'contact_type', 'title',
    'contact_owner','sla_name','reports_to','department', 'office_phone', 'billing_country',
    'billing_state', 'billing_city', 'billing_zipcode', 'billing_address',
    'shipping_country', 'shipping_state', 'shipping_city', 'shipping_zipcode',
    'shipping_address', 'description'
  ];

  document.addEventListener('change', function (e) {
    if (e.target.matches('.type-select')) {
      const selectedType = e.target.value.trim().toLowerCase();

      const wrapper = e.target.closest('.form-row');
      const lengthWrapper = wrapper.querySelector('.length-wrapper');

      const input = wrapper.querySelector('.length-input');
      const titleSelect = wrapper.querySelector('.title-select');
      const Select = wrapper.querySelector('.customertype-select');

      const contactTypeSelect = wrapper.querySelector('.contact_type-select');



      if (typesRequiringLength.includes(selectedType)) {
        lengthWrapper.style.display = 'block';

        // Hide all first
        input.style.display = 'none';
        titleSelect.style.display = 'none';
        contactTypeSelect.style.display = 'none';

        // Show appropriate one
        if (selectedType === 'title') {
          titleSelect.style.display = 'block';
        } else if (selectedType === 'contact_type') {
          contactTypeSelect.style.display = 'block';
        }else {
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
    if (selectedType === 'title') {
      finalValue = $('#title_select').val();
    } else if (selectedType === 'contact_type') {
      finalValue = $('#contact_type_select').val();
    }else {
      finalValue = $('#value_input').val();
    }

    // Set hidden field
    $('#final_value_input').val(finalValue);

    // Submit via AJAX
    var formData = $('#massForm').serialize();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('contacts/add_mass'); ?>",
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

