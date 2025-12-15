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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);overflow-x:clip;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Vendor</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home">Home</a></li>
              <li class="breadcrumb-item active">Vendor</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="container-fliud filterbtncon"  >
        <div class="row mb-3">
        
		  <?php if(check_permission_status('Vendor','retrieve_u')==true): ?>
        <?php 
                                  //  $fifteen = strtotime("-15 Day"); 
                                  //  $thirty = strtotime("-30 Day"); 
                                  //  $fortyfive = strtotime("-45 Day"); 
                                  //  $sixty = strtotime("-60 Day"); 
                                  //  $ninty = strtotime("-90 Day"); 
                                  //  $six_month = strtotime("-180 Day"); 
                                  //  $one_year = strtotime("-365 Day");
                            ?>
         
         <div class="col-lg-2">
         <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
    <input type="hidden" id="date_filter" value="" name="date_filter">
    <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
    <li data-value="This Week">This Week</li>
        <?php $week = strtotime("-7 Day"); ?>
        <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','date_filter');">Last Week</li>
        <?php $fifteen = strtotime("-15 Day"); ?>
        <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','date_filter');">Last 15 days</li>
        <?php $thirty = strtotime("-30 Day"); ?>
        <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','date_filter');">Last 30 days</li>
        <?php $fortyfive = strtotime("-45 Day"); ?>
        <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','date_filter');">Last 45 days</li>
        <?php $sixty = strtotime("-60 Day"); ?>
        <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','date_filter');">Last 60 days</li>
        <?php $ninty = strtotime("-90 Day"); ?>
        <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','date_filter');">Last 3 Months</li>
        <?php $six_month = strtotime("-180 Day"); ?>
        <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','date_filter');">Last 6 Months</li>
        <?php $one_year = strtotime("-365 Day"); ?>
        <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','date_filter');">Last 1 Year</li>
    </ul>
</div>
   </div>
          <?php endif; ?>
          <div class="col-lg-4"></div>
          <div class="col-lg-6">
           
              <div class="refresh_button float-right">
					<button class="btnstopcorner" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
				<?php if($this->session->userdata('type')=='admin'){ ?>
					<a href='Export_data/export_vendor_csv' class="p-0" ><button class="btncorner">Export Data</button></a>
				<?php } ?>
				<?php if(check_permission_status('Vendor','create_u')==true): ?>
					<button class=" btnstop" onclick="add_form();">Add New</button>
              </div>
				<?php endif; ?>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php if(check_permission_status('Vendor','retrieve_u')==true): ?>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
              <div class="card org_div">
                <div class="card-body">
                  <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <?php if(check_permission_status('Vendor','delete_u')==true):?>
                              <th><button class="btn" type="button" name="delete_all" id="delete_all"><i class="fa fa-trash text-light"></i></button></th>
                          <?php endif; ?>
                          <th class="th-sm">Vendor Name</th>
                          <th class="th-sm">Customer Type</th>
                          <th class="th-sm">Primary Email</th>
                          <th class="th-sm">Primary Phone</th>
                          <th class="th-sm">Created By</th>
                          <th class="th-sm">Assigned To</th>
                          <th class="th-sm" style="width:8%;">Action</th>
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
    <?php endif; ?>

  </div>
    <!-- View data modal -->
<div class="modal fade show" id="view_popup" role="dialog" aria-modal="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="organization_add_edit">Customer</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body form">
          <form id="view" class="row" action="#">
            <div class="col-sm-12">
              <h5 class="text-primary" id="org_name"></h5>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Customer Type:</span><h6 class="text-primary" id="cust_types_view"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Created&nbsp;Date:</span><h6 class="text-primary" id="created_date"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Ownership:</span><h6 class="text-primary" id="ownership"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Primary&nbsp;Contact&nbsp;Name:</span><h6 class="text-primary" id="primary_contact"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Email:</span><h6 class="text-primary" id="email"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Website:</span><h6 class="text-primary" id="website"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Office&nbsp;Phone:</span><h6 class="text-primary" id="office_phone"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Mobile:</span><h6 class="text-primary" id="mobile"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Employees:</span><h6 class="text-primary" id="employees"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Industry:</span><h6 class="text-primary" id="industry"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Assigned&nbsp;To:</span><h6 class="text-primary" id="assigned_to"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Annual&nbsp;Revenue:</span><h6 class="text-primary" id="annual_revenue"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Type:</span><h6 class="text-primary" id="type"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Region:</span><h6 class="text-primary" id="region"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">SIC&nbsp;Code:</span><h6 class="text-primary" id="sic_code"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">SLA&nbsp;Name:</span><h6 class="text-primary" id="sla_name"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">GSTIN:</span><h6 class="text-primary" id="gstin"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Pan No:</span><h6 class="text-primary" id="pan_no"></h6>
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
              <table style="margin-bottom:5px;" id="view_add" width="100%">
                <tbody><tr>
                  
                  <td width="24%"><span class="text-secondary">Name:</span></td>
                  <td width="24%"><span class="text-secondary">Email:</span></td>
                  <td width="24%"><span class="text-secondary">Work Phone:</span></td>
                  <td width="24%"><span class="text-secondary">Mobile:</span></td>
                </tr>
              <tr><td width="24%"><input name="contact_name_batch[]" id="contact_name_batch" class="form-control " type="text" placeholder="Contact Name" value="Anirban Mondal" readonly=""></td><td width="24%"><input name="email_batch[]" id="email_batch" class="form-control " type="text" placeholder="Email" value="anirban.mondal@parashospitals.com" readonly=""></td><td width="24%"><input name="phone_batch[]" id="phone_batch" class="form-control  start" type="text" placeholder="Work Phone" value="1244585555" readonly=""></td><td width="24%"><input name="mobile_batch[]" id="mobile_batch" class="form-control " type="text" placeholder="Mobile" value="9667806308" readonly=""></td></tr><tr><td width="24%"><input name="contact_name_batch[]" id="contact_name_batch" class="form-control " type="text" placeholder="Contact Name" value="Nitin Ailawadi" readonly=""></td><td width="24%"><input name="email_batch[]" id="email_batch" class="form-control " type="text" placeholder="Email" value="anirban.mondal@parashospitals.com" readonly=""></td><td width="24%"><input name="phone_batch[]" id="phone_batch" class="form-control  start" type="text" placeholder="Work Phone" value="1244585555" readonly=""></td><td width="24%"><input name="mobile_batch[]" id="mobile_batch" class="form-control " type="text" placeholder="Mobile" value="0" readonly=""></td></tr></tbody></table>
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

<style>
.bgclr{
	background: #086371fc;
}
</style>

  <!-- Add new modal -->
<div class="modal fade show" id="modal_form" role="dialog" aria-modal="true" data-keyboard="false" data-backdrop="static">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
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
                         <label>Customer Name<span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control onlyLetters" name="org_name" id="org_name_check" placeholder="Customer Name" onChange="check_org()" required>
                        <span id="org_name_error"></span>
                      </div>
                        <div class="col-md-6 mb-3">
                        <label>Customer Type<span style="color: #f76c6c;">*</span></label>    
                          <select class="form-control" name="cust_types" id="cust_type_select">
                            <option value="">Select Customer Type</option>
							<option value="Vendor" selected>Vendor</option>
                          </select>
						  <span id="customer_type_error"></span>
                        </div>
                      <div class="col-md-6 mb-3">
                        <label>Ownership</label>
                        <input type="text" class="form-control " name="ownership" placeholder="Ownership" value="<?= $this->session->userdata('name'); ?>" readonly>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Primary Contact<span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control" maxlength="10" name="primary_contact" id="primary_contact_org" placeholder="Primary Contact Name">
                        <span id="primary_contact_error"></span>
                      </div>
                      
                      <div class="col-md-6 mb-3">
                        <label>Email<span style="color: #f76c6c;">*</span></label>  
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
                        <input type="tel" class="form-control numeric" maxlength="10"  name="office_phone" id="officePhone" placeholder="Office Phone" required="">
                        <span id="office_phone_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Mobile<span style="color: #f76c6c;">*</span></label>  
                        <input type="tel" class="form-control numeric" name="mobile" maxlength="10" id="mobileId" placeholder="Mobile" required="">
                        <span id="mobile_error"></span>
                      </div>
                      
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_div" target="1" id="forTarget1" style="width:100%;color:#ffffff">Other Details</a>
                      </div>
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_div" target="2" id="forTarget2" style="width:100%;color:#ffffff">Address Details</a>
                      </div>
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_div" target="3" style="width:100%;color:#ffffff">Contact Person</a>
                      </div>
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_div" target="4" style="width:100%;color:#ffffff">Description</a>
                      </div>
                      <div class="col-md-3 mb-3">
                      </div>

                      <div id="div1" class="targetDiv form-row col-md-12" style="display: none;">
                        <div class="col-md-6 mb-3">
                          <label>Employees</label>
                          <input type="number" class="form-control " name="employees" id="employeesId" placeholder="Employees">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Industry<span style="color: #f76c6c;">*</span></label>    
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
                          <label>Type<span style="color: #f76c6c;">*</span></label>    
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
                          <label>Region<span style="color: #f76c6c;">*</span></label>    
						  <select class="form-control " name="region" id="regionID" >
							<option value="">Region</option>
							<option value="NAM">NAM</option>
							<option value="LAM">LAM</option>
							<option value="EU">EU</option>
							<option value="APAC">APAC</option>
							<option value="MEA">MEA</option>
						  </select>
                        </div>
                        <!--<div class="col-md-6 mb-3">
                          <label>SIC Code</label>    
                          <input type="text" class="form-control " name="sic_code" id="sicCode" placeholder="SIC Code">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>SLA Name</label>    
                          <input type="text" class="form-control " name="sla_name" id="slaName" placeholder="SLA Name">
                        </div>-->
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
                          <label>Country<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="billing_country" placeholder="Country" id="country"  required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="country_ids" >
                          <span id="billing_country_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>State<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="billing_state" placeholder="State" id="states" required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="state_id" >
                           <span id="billing_state_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Country<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="shipping_country" placeholder="Country" id="s_country" required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="s_country_id" >
                           <span id="shipping_country_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>State<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="shipping_state" placeholder="State" id="s_states" required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="s_state_id" >
                          <span id="shipping_state_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>City<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="billing_city" placeholder="City" id="cities" required="" autocomplete="off">
                          <span id="billing_city_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Zipcode<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control numeric" maxlength="6" name="billing_zipcode" placeholder="Zipcode" required="" id="billingZipcode">
                           <span id="billing_zipcode_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>City<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="shipping_city" placeholder="City" id="s_cities" required="" autocomplete="off">
                           <span id="shipping_city_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Zipcode<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control numeric" maxlength="6" name="shipping_zipcode" placeholder="Zipcode" required="" id="shippingZipcode">
                          <span id="shipping_zipcode_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Address<span style="color: #f76c6c;">*</span></label>
                          <textarea type="text" class="form-control " name="billing_address" placeholder="Address" required="" id="billingAddress"></textarea>
                          <span id="billing_address_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Address<span style="color: #f76c6c;">*</span></label>
                          <textarea type="text" class="form-control " name="shipping_address" placeholder="Address" required="" id="shippingAddress"></textarea>
                          <span id="shipping_address_error"></span>
                        </div>
                      </div>

                      <div id="div3" class="targetDiv form-row col-md-12" style="display: none;">
                        <div class="col-md-12 mb-6">
                          <table style="margin-bottom:5px;" id="add">
                            <tbody>
                                <tr>
                                    <td width="4%">
                                        <input id="checkbox" type="checkbox">
                                    </td>
                                    <td width="24%">
                                        <input name="contact_name_batch[]" id="contact_name_batch" class="form-control " data-toggle="tooltip" title="Tittle" type="text"  placeholder="Contact Name">
                                    </td>
                                    <td width="24%">
                                        <input name="email_batch[]" id="email_batch" class="form-control " data-toggle="tooltip" title="Tittle" type="text" placeholder="Email">
                                    </td>
                                    <td width="24%">
                                        <input name="phone_batch[]" id="phone_batch" class="form-control  start" data-toggle="tooltip" maxlength="10" title="Tittle" type="text" placeholder="Work Phone">
                                    </td>
                                    <td width="24%">
                                        <input name="mobile_batch[]" id="mobile_batch" maxlength="10" class="form-control " data-toggle="tooltip" title="Tittle" type="text" placeholder="Mobile">
                                    </td>
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
                  <span id="error_msg" style="color: red;font-size: 14px;font-weight: 200px;"></span>
                  <button type="button" id="btnSave" onclick="save()" class="btn btn-info btn-sm">Save</button>
                </div>
            </div>
          </div>
        </div>
<!-- Add new modal -->

		<div class="modal fade" id="modal_import_org" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">CSV File&nbsp;Import for Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                  <form method="post" id="import_form" enctype="multipart/form-data">
                   <p><label>Select CSV File</label>
                   <input type="file" name="file" id="file" required accept=".csv" />
                   <br><a href="<?php echo SAMPLE_EXCEL;?>org_sample.csv">View CSV File sample</a>
                  </p>

                   <br />
                   <div id="excel_table">
                    <b>**Note : These Entries Already Existed</b>
                      <table id="duplicate_entry" style="width: 100%;">
                        <tr>
                          <th>Name</th>
                          <th>Customer</th>
                        </tr>
                      </table>
                    </div>
                    <br>
                   <!-- <input type="submit" name="import" value="Import" class="btn btn-info" id="import_button" /> -->
                   <button type="submit" name="import" value="Import" class="btn btn-info" id="import_button">Import</button>
                  <label style="padding-top: 7px;float: right;"><i class="fas fa-info-circle" style="color:red"></i> Only csv file accepted.</label>
                  </form>
                </div>
              </div>
            </div>
        </div>
</div>

<?php $this->load->view('footer');?>

<!-- ./wrapper -->

<!-- common footer include -->
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
</script>
<script>
$(document).ready(function(){
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
        //alert('hii check');
      //console.log(response);
    if(response.st == 202)
    {
      $('#file').val('');
      alert(response.msg);
    }
    else if(response.st == 200)
    {
      $('#file').val('');
      alert(response.msg);
      $('#modal_import_org').modal('hide');
      window.location.reload();//reload datatable ajax
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

});
</script>

<script>
$(document).ready(function () {
  
   <?php if(check_permission_status('Vendor','retrieve_u')==true): ?>
    //datatables
    table = $('#ajax_datatable').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('vendors/ajax_list')?>",
            "type": "POST",
             "data" : function(data)
             {
                data.searchDate = $('#date_filter').val();
             }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ 0 ], //last column
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
    <?php if(check_permission_status('Vendor','create_u')==true): ?>
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
          "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile'></td></tr>";
          $("#add").append(markup);
          $("#add_row").show();
          $("#delete_row").show();
		  $("#org_name_check").attr('readonly', false);
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

  var typeId=$('#typeId').val();
  var industryId=$('#industryId').val();
  var regionID=$('#regionID').val();

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
  
    if(org_name_check=="" || org_name_check===undefined){
      changeClr('org_name_check');
      return false;
    }else if(cust_types=="" || cust_types===undefined || cust_types===null){
      changeClr('cust_type_select');
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
    }else if(typeId=="" || typeId===undefined || typeId===null){
      changeClr('typeId');
      $('#forTarget1').click();
      return false;
    }else if(industryId=="" || industryId===undefined || industryId===null){
      changeClr('industryId');
      $('#forTarget1').click();
      return false;
    }else if(regionID=="" || regionID===undefined || regionID===null){
      changeClr('regionID');
      $('#forTarget1').click();
      return false;
    }else if(country=="" || country===undefined || country===null){
      changeClr('country');
      $('#forTarget2').click();
	  console.log('country');
      return false;
    }else if(states=="" || states===undefined || states===null){
      changeClr('states');
      $('#forTarget2').click();
	  console.log('state');
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


    <?php if(check_permission_status('Vendor','create_u')==true || check_permission_status('Vendor','update_u')==true): ?>
        function save()
        {
			if(checkValidation()==true){
          $('#btnSave').text('saving...'); //change button text
          $('#btnSave').attr('disabled',true); //set button disable
          var url;
          if(save_method == 'add') {
              url = "<?= base_url('organizations/create')?>";
          } else {
              url = "<?= base_url('organizations/update')?>";
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
                    $('#modal_form').modal('hide');
                     window.location.reload();
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

                if(data.st==202)
                {
                  $("#org_name_error").html(data.org_name);
                  $("#customer_type_error").html(data.cust_types);
                  $("#primary_contact_error").html(data.primary_contact);
                  $("#email_error").html(data.email);
                  $("#office_phone_error").html(data.office_phone);
                  $("#mobile_error").html(data.mobile);
                  $("#gstin_error").html(data.gstin);
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
                  $("#error_msg").html('');
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
        }
    <?php endif; ?>
    <?php if(check_permission_status('Vendor','retrieve_u')==true): ?>
        function view(id)
        {
            $('#view')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $("#view_add").find("tr").not(':first').remove();
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo base_url('organizations/getbyId/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                  $('[id="org_name"]').text(data.org_name);
                  $('[id="cust_types_view"]').text(data.customer_type);
                  $('[id="created_date"]').text(data.datetime);
                  $('[id="ownership"]').text(data.ownership);
                  $('[id="primary_contact"]').text(data.primary_contact);
                  $('[id="email"]').text(data.email);
                  $('[id="website"]').text(data.website);
                  $('[id="office_phone"]').text(data.office_phone);
                  $('[id="mobile"]').text(data.mobile);
                  $('[id="employees"]').text(data.employees);
                  $('[id="industry"]').text(data.industry);
                  $('[id="assigned_to"]').text(data.assigned_to);
                  $('[id="annual_revenue"]').text(data.annual_revenue);
                  $('[id="type"]').text(data.type);
                  $('[id="region"]').text(data.region);
                  $('[id="sic_code"]').text(data.sic_code);
                  $('[id="sla_name"]').text(data.sla_name);
                  $('[id="gstin"]').text(data.gstin);
                  $('[id="pan_no"]').text(data.panno);
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
                  $('[id="description"]').text(data.description);
                  $('[id="description"]').html(data.description);
				  
                  $('#view_popup').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Customer'); // Set title to Bootstrap modal title
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
                  var markup = "<tr>"+
                  "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name' value='"+data[i].name+"' readonly></td>"+
                  "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email' value='"+data[i].email+"' readonly></td>"+
                  "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone' value='"+data[i].office_phone+"' readonly></td>"+
                  "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile' value='"+data[i].mobile+"' readonly></td>";
                  $("#view_add").append(markup);
                });
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
                alert('Error Retrieving Data From Database');
             }
            });
        }
    <?php endif; ?>
    <?php if(check_permission_status('Vendor','update_u')==true): ?>
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
        $("#checkbox").hide();
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
            //$('[name="description"]').val(data.description);
			CKEDITOR.instances['descriptionTxt'].setData(data.description);
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
               var keys = Object.keys(data);
                var last = keys[keys.length-1];
              var v = i+1;
              
              var markup = "<tr><td width='4%'>"+v+"</td>"+
              "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name' value='"+data[i].name+"'></td>"+
              "<input name='cid[]' id='cid' class='form-control ' type='hidden'  value='"+data[i].id+"'>"+
              "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email' value='"+data[i].email+"'></td>"+
              "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone' value='"+data[i].office_phone+"'></td>"+
              "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile' value='"+data[i].mobile+"'></td>";
              if(i!=last)
              {
                   $("#add").append(markup);
              }
             
              
             
            });
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error Retrieving Data From Database');
          }
        });
      }
    <?php endif; ?>
    <?php if(check_permission_status('Vendor','delete_u')==true):?>
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

function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

table.ajax.reload();
}

</script>
