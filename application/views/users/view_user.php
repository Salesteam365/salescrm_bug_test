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

/* #ajax_datatable tbody tr td:nth-child(3) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
} */
div.refresh_button button.btnstopcorner {
    border: 1px solid #ccc; /* Light grey border on hover */
    border-radius: 4px;
    background: white;
    color: rgba(30, 0, 75);
  }

  div.refresh_button button.btnstopcorner:hover {
    background:lightgrey;
    border: 1px solid #ccc; /* Light grey border on hover */
  }
   </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>home">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row mb-3">
          <div class="col-lg-2">
            <div class="first-one">
            </div>
          </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-6">
              <div class="refresh_button float-right">
                  <button class="btn btnstopcorner btn-sm" onclick="reload_table()"><i class="fas fa-redo-alt"></i></button>
                  <button class="btn btnstopcorner btn-sm check_user" data-toggle="modal" data-target="#add_user_popup"><i class="fas fa-user-plus"></i> Add User</button>
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
                            <th class="th-sm">User image</th>
                            <th class="th-sm">Username</th>
                            <th class="th-sm">Email ID</th>
                            <th class="th-sm">Contact No.</th>
                            <th class="th-sm">Website</th>
                            <th class="th-sm">GSTIN</th>
                            <th class="th-sm">License Type</th>
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
<div style="text-align:center" id="show_msgs"></div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Add new modal -->
    <div class="modal fade show" id="add_user_popup" role="dialog" aria-modal="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="organization_add_edit">Add User</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            
           <div class="modal-body form">
              <form action="" id="add_user_form" name="add_user_form" class="form-horizontal" enctype="multipart/form-data" method="post">
                
                <div class="form-body form-row">
                  <div class="col-md-6 mb-3">
                      <label>First Name<span style="color: #f76c6c;">*</span></label>
                      <input type="text" class="form-control onlyLetters" name="first_name" id="first_name" placeholder="First Name">
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Last Name<span style="color: #f76c6c;">*</span></label>
                      <input type="text" class="form-control onlyLetters" name="last_name" id="last_name" placeholder="Last Name">
                      <span id="duplicate_name_error" style="color: red;float: left;font-size: 14px;"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Email<span style="color: #f76c6c;">*</span></label>
                      <input type="email" class="form-control " name="standard_email" id="standard_email" placeholder="Email" autocomplete="off">
                      <span id="standard_email_error" style="color: red;float: left;font-size: 14px;"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Mobile<span style="color: #f76c6c;">*</span></label>
                      <input type="tel" class="form-control numeric" name="standard_mobile" id="standard_mobile" placeholder="Mobile"maxlength="10">
                      <span id="standard_mobile_error"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Password<span style="color: #f76c6c;">*</span></label>
                      <input type="password" class="form-control " id="first_password" placeholder="Password">
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Confirm Password<span style="color: #f76c6c;">*</span></label>
                      <input type="password" class="form-control " name="standard_password" id="second_password" placeholder="Confirm Password" onkeyup="match_pass();return false;">
                      <span id="match_pass_error" style="color: red;float: left;font-size: 14px;"></span>
                  </div>
				  <div class="col-md-6 mb-3">
				      <label>Role</label>
                      <select class="form-control " name="sel_role" id="sel_roles">
                        <option>Select Role</option>
                        <?php foreach($roles as $role) { ?>
							<option value="<?=$role['id'] ?>" ><?=$role['role_name'] ?></option>
						<?php } ?>
                        
                      </select>
                  </div>
				  <div class="col-md-6 mb-3">
				      <label>Report To</label>
                      <input type="text" class="form-control " name="reports_to" id="reports_autocomplete" placeholder="Report To">
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Licence Type <span class="text-danger">*</span></label>
                      <?php    $CI 	= &get_instance();  ?>
                      <select class="form-control " name="license_type" id="license_type">
                            <option value="0">Select Licence Type</option>
                        <?php 
                          for($i=0; $i<count($plan_name); $i++){
            		        $dataPl=  $CI->Login_model->plan_name($plan_name[$i]['plan_id']);
            		    ?>
                        <option value="<?=$dataPl['id'];?>"><?=$dataPl['plan_name'];?></option>
                        <?php } ?>
                        <!--<option value="Enterprise Plan">Enterprise Plan</option>-->
                      </select>
                  </div>
				  <div class="col-md-6 mb-3">
                      <label>User Type<span style="color: #f76c6c;">*</span></label>
                      <select class="form-control " name="user_type" id="user_type">
                        <option>User Type</option>
						<option value="Sales Manager">Sales Manager</option>
                        <option value="Sales Person">Sales Person</option>
                        <option value="Purchase Person">Purchase Person</option>
                        <option value="Account Person">Account Person</option>
						<option value="Support Person">Support Person</option>
                      </select>
                  </div>
                  
                  <!--upload user-->
                 <div class="col-md-6 mb-3">
                    <label class="upload_logo">Upload User </label>
                      <input type="file" name="profile_image" id="profile_image"> <p class = "text-success small"> Please Select jpg | jpeg | png Image. </p>
                  </div>
            
              
                </div>
              </form>
            </div>
            <div class="modal-body">
              <p class="text-center" id="show_msg_error" style="color: #ff7878;margin-bottom: 0;"></p>
            </div>
            <div class="modal-footer">
              <button type="button" id="add_user_btn" onclick="save()" class="btn btn-info btn-sm">Save</button>
            </div>
        </div>
      </div>
    </div>
  <!-- Add new modal -->
  
<!-- View User modal -->
<div class="modal fade show" id="view_user" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="organization_add_edit">View User</h3>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body form">
          <form id="view" class="row" action="#">
            <div class="col-sm-12  rounded">
              <h5 class="text-primary" id="company_name"></h5>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Name:</b></span><h6 class="text-primary" id="standard_name"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Subdomain:</b></span><h6 class="text-primary" id="subdomain"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Mobile:</b></span><h6 class="text-primary" id="standard_mobile"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Email:</b></span><h6 class="text-primary" id="standard_email"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Licence:</b></span>
              <h6 class="text-primary" id="licencePut"></h6>
            </div>
			<div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Role:</b></span><h6 class="text-primary" id="roles"></h6>
            </div>
			<div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Report To:</b></span><h6 class="text-primary" id="view_reports_to"></h6>
            </div>
			<div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>User Type:</b></span><h6 class="text-primary" id="view_user_type"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Company Mobile:</b></span><h6 class="text-primary" id="company_mobile"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Company Email:</b></span><h6 class="text-primary" id="company_email"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>GSTIN:</b></span><h6 class="text-primary" id="company_gstin"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>PAN:</b></span><h6 class="text-primary" id="pan_number"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>CIN:</b></span><h6 class="text-primary" id="cin"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Country:</b></span><h6 class="text-primary" id="country"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>State:</b></span><h6 class="text-primary" id="state"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>City:</b></span><h6 class="text-primary" id="city"></h6>
            </div>
            <div class="col-sm-6 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Zipcode:</b></span><h6 class="text-primary" id="zipcode"></h6>
            </div>
            <div class="col-sm-12 shadow-sm p-3 bg-body rounded">
              <span class="text-secondary"><b>Address:</b></span><h6 class="text-primary" id="company_address"></h6>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>
<!-- View user modal -->

   <!-- update user modal -->
<div class="modal fade show" id="updation_user" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="update_user">Update User Details</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body form">
                  <form action="#" id="update_user_form" class="form-horizontal" enctype="multipart/form-data" method="post">
                    <div class="form-body form-row">
                      <div class="col-md-6 mb-3">
                          <label>Name<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control onlyLetters" name="standard_name" id="standard_name_update" placeholder="Name">
                          <span id="standard_name_update_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label>Contact<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control numeric" name="standard_mobile" maxlength="10" id="standard_mobile_update"  placeholder="Contact" >
                           <span id="standard_mobile_update_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label>Email<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control " name="standard_email" readonly id="standard_email_update" placeholder="Email">
                           <span id="standard_email_update_error"></span>
                      </div>
                      
                      <div class="col-md-6 mb-3">
					    <label>Select Licence Type</label>
					    <?php // print_r($plan_name); ?>
					    <input type="hidden" name="sel_lic_type_hidden" id="sel_lic_type_hidden">
                        <select class="form-control " name="sel_lic_type" id="sel_lic_type">
                            <option value="0">Select Licence Type</option>
                        <?php 
                          for($i=0; $i<count($plan_name); $i++){
            		    ?>
                        <option value="<?=$plan_name[$i]['plan_id'];?>"><?=$plan_name[$i]['plan_name'];?></option>
                        <?php } ?>
                        
                        </select>
                        </div>
                      
					  <div class="col-md-6 mb-3">
					    <label>Role</label>
                        <select class="form-control " name="sel_role" id="sel_role">
                            <option>Select Role</option>
                        <?php foreach($roles as $role) { ?>
							<option value="<?=$role['id'] ?>" ><?=$role['role_name'] ?></option>
						<?php } ?>
                        
                      </select>
                  </div>
				  <div class="col-md-6 mb-3">
				      <label>Report To</label>
                      <input type="text" class="form-control " name="reports_to" id="reports_to" placeholder="Report To">
                  </div>
				  <div class="col-md-6 mb-3">
                      <label>User Type<span style="color: #f76c6c;">*</span></label>
                      <select class="form-control " name="user_typeUpdate" id="user_typeUpdate">
                        <option>User Type</option>
						<option value="Sales Manager">Sales Manager</option>
                        <option value="Sales Person">Sales Person</option>
                        <option value="Purchase Person">Purchase Person</option>
                        <option value="Account Person">Account Person</option>
						<option value="Support Person">Support Person</option>
                      </select>
					  <span id="user_type_update_error"></span>
                  </div>
                      <div class="col-md-6 mb-3">
                          <label>Country<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control onlyLetters" name="country" id="country_update" placeholder="Country">
                           <span id="country_update_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label>State<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control onlyLetters" name="state" id="state_update" placeholder="State">
                           <span id="state_update_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label>City<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control onlyLetters" name="city" id="city_update" placeholder="City">
                           <span id="city_update_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label>Zipcode<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control numeric" name="zipcode" id="zipcode_update" placeholder="Zipcode">
                           <span id="zipcode_update_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label>GSTIN<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control " name="company_gstin" id="company_gstin_update" placeholder="GSTIN">
                           <span id="company_gstin_update_error"></span>
                      </div>
                      
                      <!--update user-->
                        <div class="col-md-6 mb-3">
                            <label class="upload_logo">Upload User </label>
                           <input type="file" name="profile_image" id="profile_image_update"> <p class = "text-success small"> Please Select jpg | jpeg | png Image. </p>
                           <span id = "profile_image_update_error"></span> 
                        </div>
                     
                     
                      <div class="col-md-12 mb-6">
                          <label>Address<span style="color: #f76c6c;">*</span></label>
                          <textarea type="text" class="form-control " name="company_address" id="company_address_update" placeholder="Address"></textarea>
                           <span id="company_address_update_error"></span>
                      </div>
                      
                      <div class="col-md-12 mb-6 text-center form-control">
                        <span class="h4"><b>Permission</b><span>
                      </span></span></div>
					  
					  <div class="col-md-12 mb-6 text-center form-control">
                        <span class="h6"><b>Check for All Permission</b>
							&nbsp;&nbsp;<input type="checkbox"  id="checkAll" name="checkAll" value="all" >
						</span>
					  </div>
					  
                      <div class="col-md-4 mb-4">
                        <span class="h5">Module</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <span class="h5">Create</span>
                      </div>
                      
                      <div class="col-md-2 mb-2">
                        <span class="h5">Retrieve</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <span class="h5">Update</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <span class="h5">Delete</span>
                      </div>
                      <div class="col-md-4 mb-4">
                        <span class="h6">Organization</span>
                      </div>
					  
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="create_org" name="create_org" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="retrieve_org" name="retrieve_org" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="update_org" name="update_org" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="delete_org" name="delete_org" >
                      </div>
                      <div class="col-md-4 mb-4">
                        <span class="h6">Contact</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="create_contact" name="create_contact" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="retrieve_contact" name="retrieve_contact" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="update_contact" name="update_contact" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="delete_contact" name="delete_contact" >
                      </div>
                      <div class="col-md-4 mb-4">
                        <span class="h6">Leads</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="create_lead" name="create_lead" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="retrieve_lead" name="retrieve_lead" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="update_lead" name="update_lead" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="delete_lead" name="delete_lead" >
                      </div>
                      <div class="col-md-4 mb-4">
                        <span class="h6">Opportunity</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="create_opp" name="create_opp" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="retrieve_opp" name="retrieve_opp" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="update_opp" name="update_opp" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="delete_opp" name="delete_opp" >
                      </div>
                      <div class="col-md-4 mb-4">
                        <span class="h6">Quotations</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="create_quote" name="create_quote" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="retrieve_quote" name="retrieve_quote" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="update_quote" name="update_quote" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="delete_quote" name="delete_quote" >
                      </div>
                      <div class="col-md-4 mb-4">
                        <span class="h6">Salesorders</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="create_so" name="create_so" >
                      </div>
                      
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="retrieve_so" name="retrieve_so"  >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="update_so" name="update_so" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="delete_so" name="delete_so" >
                      </div>
                      <div class="col-md-4 mb-4">
                        <span class="h6">Vendor</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="create_vendor" name="create_vendor" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="retrieve_vendor" name="retrieve_vendor" value="1">
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="update_vendor" name="update_vendor" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="delete_vendor" name="delete_vendor" >
                     </div>
                      <div class="col-md-4 mb-4">
                        <span class="h6">Purchaseorder</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="create_po" name="create_po" >
                      </div>
                      
                     <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="retrieve_po" name="retrieve_po" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl"  id="update_po" name="update_po" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="delete_po" name="delete_po" >
                      </div>
                      <div class="col-md-4 mb-4">
                        <span class="h6">Invoice</span>
                      </div> 
                       <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="create_inv" name="create_inv" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="retrieve_inv" name="retrieve_inv" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="update_inv" name="update_inv" >
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox"  class="forchkcl" id="delete_inv" name="delete_inv" >
                      </div>
                      
                       <div class="col-md-4 mb-4">
                        <span class="h6">Proforma Invoice</span>
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox" class="forchkcl" id="create_pi" name="create_pi">
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox" class="forchkcl" id="retrieve_pi" name="retrieve_pi">
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox" class="forchkcl" id="update_pi" name="update_pi">
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox" class="forchkcl" id="delete_pi" name="delete_pi">
                      </div>
                      
                      
                      <div class="col-md-12 mb-6">
                        <span class="h5">Permission for user<span>
                      </div>
                      
                      <div class="col-md-4 mb-2">
                        Pending payment mail
                      </div>
                      <div class="col-md-2 mb-2">
                           <input type="checkbox" class="forchkcl" id="pendingPayment" name="pendingPayment">
                      </div>
                      <div class="col-md-12 mb-6">
                      </div>
                      <div class="col-md-4 mb-2">
                        Accept Payment Mail
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox" class="forchkcl" id="acceptMail" name="acceptMail">
                      </div>
                      <div class="col-md-12 mb-6">
                      </div>
                      <div class="col-md-4 mb-2">
                       Approve So mail
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox" class="forchkcl" id="approveMail" name="approveMail">
                      </div>
                      <div class="col-md-12 mb-6">
                      </div>
                      <div class="col-md-4 mb-2">
                        SO Approval
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox" class="forchkcl" id="approveSO" name="approveSO">
                      </div>
                      
					  <div class="col-md-12 mb-6">
                      </div>
                      <div class="col-md-4 mb-2">
                        PO Approval
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox" class="forchkcl" id="approvePO" name="approvePO">
                      </div>
					  
                      <div class="col-md-12 mb-6">
                      </div>
                      <div class="col-md-4 mb-2">
                        Not Required SO Approval
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox" class="forchkcl" id="notapproveSO" name="notapproveSO">
                      </div>
					  <div class="col-md-12 mb-6">
                      </div>
                      <div class="col-md-4 mb-2">
                        Not Required PO Approval
                      </div>
                      <div class="col-md-2 mb-2">
                        <input type="checkbox" class="forchkcl" id="notapprovePO" name="notapprovePO">
                      </div>
                      
                    </div>
                    <input type="hidden" name="update_id" id="update_id">
                  </form>
                </div>
        <div class="modal-footer">
          <button type="button" id="btnSave_update" onclick="update_data();" class="btn btn-info btn-sm">Update</button>
        </div>
    </div>
  </div>
</div>
<!-- update user modal -->

      <!-- Add data modal -->
          <div class="modal fade show" id="target_popup" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title" id="organization_add_edit">Set target</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body form">
                    <form action="#" id="target_form" name="target_form" class="form-horizontal" enctype="multipart/form-data" method="post">
                      <div class="form-body form-row">
                        <input type="hidden" id="chkixst" value="exist">
                         <div class="col-md-4 mb-2 text-center">
                            <label for="" class="">Select Date</label>
                        </div>
                        <div class="col-md-2 mb-2 text-center">
                            <label> - </label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="date" value="<?php echo date('Y-m-01');?>" class="form-control " name="quota_month" id="quota_month" >
                        </div>


                        <div class="col-md-4 mb-2 text-center">
                            <label for="" class="">Sales Quota</label>
                        </div>
                        <div class="col-md-2 mb-2 text-center">
                            <label> - </label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control  numeric" name="sales_quota" id="sales_quota" placeholder="Emter Sales Quota">
                            
                        </div>
                        <div class="col-md-4 mb-2 text-center">
                            <label for="" class="">Profit Quota</label>
                        </div>
                        <div class="col-md-2 mb-2 text-center">
                            <label> - </label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control  numeric" name="profit_quota" id="profit_quota" placeholder="Enter Profit Quota">
                            
                        </div>
                      </div>
                      <input type="hidden" name="data_id" id="data_id" value="">
                      <input type="hidden" name="data_type" id="data_type" value="">
                      <input type="hidden" name="data_email" id="data_email" value="">
                    </form>
                  </div>
                  <div class="modal-footer"><span id="msgcheck"></span>
                    <button type="button" id="btnSave" onclick="save_target();return false;" class="btn btn-info btn-sm">Save</button>
                  </div>
              </div>
            </div>
          </div>

  <?php $this->load->view('footer');?>
</div>
<?php $this->load->view('common_footer');?>
<script>
  var table;
$(document).ready(function () {
   table = $('#ajax_datatable').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
         "url": "<?= base_url('home/ajax_user_table')?>",
         "type": "POST",
         "data": function (data) {
            data.searchDate = $('#date_filter').val();
         }
      },
      "columnDefs": [{
         "targets": [-1], //last column
         "orderable": false, //set not orderable
      }, ],
   });

   $('#date_filter').change(function () {
      table.ajax.reload();
   });

   $('.delete_checkbox').click(function () {
      if ($(this).is(':checked')) {
         $(this).closest('tr').addClass('removeRow');
      } else {
         $(this).closest('tr').removeClass('removeRow');
      }
   });
   $('#delete_all').click(function () {
      var checkbox = $('.delete_checkbox:checked');
      if (checkbox.length > 0) {
         var checkbox_value = [];
         $(checkbox).each(function () {
            checkbox_value.push($(this).val());
         });
         $.ajax({
            url: "<?= base_url('home/delete_bulk')?>",
            method: "POST",
            data: {
               checkbox_value: checkbox_value
            },
            success: function () {
               $('.removeRow').fadeOut();
               reload_table();
            }
         })
      } else {
         alert('Select atleast one records');
      }
   });
});

function reload_table() {
   table.ajax.reload(null, false); //reload datatable ajax
}

function checkValUser() {
   var first_name = $("#first_name").val();
   var last_name = $("#last_name").val();
   var standard_email = $("#standard_email").val();
   var standard_mobile = $("#standard_mobile").val();
   var first_password = $("#first_password").val();
   var second_password = $("#second_password").val();
   var user_type = $("#user_type").val();
   var license_type = $("#license_type").val();


   if (first_name == "") {
      $("#first_name").css("border-color", "red");
      setTimeout(function () {
         $("#first_name").css("border-color", "");
      }, 3000);
      return false;
   } else if (last_name == "") {
      $("#last_name").css("border-color", "red");
      setTimeout(function () {
         $("#last_name").css("border-color", "");
      }, 3000);
      return false;
   } else if (standard_email == "") {
      $("#standard_email").css("border-color", "red");
      setTimeout(function () {
         $("#standard_email").css("border-color", "");
      }, 3000);
      return false;
   } else if (standard_mobile == "") {
      $("#standard_mobile").css("border-color", "red");
      setTimeout(function () {
         $("#standard_mobile").css("border-color", "");
      }, 3000);
      return false;
   } else if (first_password == "") {
      $("#first_password").css("border-color", "red");
      setTimeout(function () {
         $("#first_password").css("border-color", "");
      }, 3000);
      return false;
   } else if (second_password == "" || first_password != second_password) {
      $("#second_password").css("border-color", "red");
      setTimeout(function () {
         $("#second_password").css("border-color", "");
      }, 3000);
      return false;
   } else if (license_type == "0" || license_type == "") {
      $("#license_type").css("border-color", "red");
      setTimeout(function () {
         $("#license_type").css("border-color", "");
      }, 3000);
      return false;
   } else if (user_type == "" || user_type === undefined) {
      $("#user_type").css("border-color", "red");
      setTimeout(function () {
         $("#user_type").css("border-color", "");
      }, 3000);
      return false;
   } else {
      return true;
   }
}

//$('.check_user').click(function(){
/*********autoload ajax***********/
$.ajax({
   url: "<?= base_url('home/checkUserPartner'); ?>",
   type: "POST",
   data: "",
   dataType: "JSON",
   success: function (data) {
      console.log(data);
      if (data.st == 200) {
         $('.check_user').attr('disabled', false);
      } else if (data.st == 201) {
         $("#show_msgs").html(data.show_msg);
         $('.check_user').attr('disabled', true);
      }


   }
});

//});

function ValidateSize(file) {
    var FileSize = file.files[0].size / 1024 / 1024; // in MB
    if (FileSize > 2) {
      alert('File is larger than 2MB');
      $(file).val(''); //for clearing with Jquery
    } else {

    }
  }

function save() {
   if (checkValUser() == true) {
       
     var formDataa = new FormData($('#add_user_form')[0]);
    //   $('#add_user_form').serialize(),
      $.ajax({
         url: "<?= base_url('home/checkUserExist'); ?>",
         type: "POST",
         data: formDataa,
         contentType: false,
         processData: false,
         success: function (data) {
            $("#standard_email_error").html(data);
            setTimeout(function () {
               $("#standard_email_error").html('');
            }, 3000);
            var userEmail = $("#standard_email").val();
            if (userEmail != "") {
               $('#add_user_btn').text('saving...'); //change button text
               $('#add_user_btn').attr('disabled', true); //set button disable
               var url;
            //   var formData;
               url = "<?= base_url('home/create'); ?>";
            //   formData = $('#add_user_form').serialize();
              
            var formData = new FormData($('#add_user_form')[0]);
               // ajax adding data to database
               $.ajax({
                  url: url,
                  type: "POST",
                  data: formData,
                  contentType: false,
                  processData: false,
                  dataType: "JSON",
                  success: function (data) {
                     ///console.log(data)
                     if (data.status) {
                        $('#add_user_popup').modal('hide');
                        $('#add_user_form')[0].reset();
                        reload_table();
                        toastr.success('A new user adedd successfully.');
                        ///window.location.reload();
                     }
                     if (data.st == 202) {
                        $("#standard_email_error").html(data.standard_email);
                        $("#standard_mobile_error").html(data.standard_mobile);
                        $('#add_user_btn').text('save'); //change button text
                        $('#add_user_btn').attr('disabled', false);
                        toastr.error('Something went wrong, Please try later .');
                     } else if (data.st == 200) {
                        $("#standard_email_error").html('');
                        $("#standard_mobile_error").html('');
                        $('#add_user_btn').text('saving...'); //change button text
                        $('#add_user_btn').attr('disabled', true); //set button disable
                        $('#add_user_popup').modal('hide');
                        toastr.error('Something went wrong, Please try later .');
                        setInterval('location.reload()', 500);
                     } else if (data.st == 201) {
                        toastr.error('Something went wrong, Please try later .');
                        $("#show_msg_error").html(data.show_msg);
                        $('#add_user_btn').text('save'); //change button text
                        $('#add_user_btn').attr('disabled', true); //set button disable
                        setInterval(function () {
                           $("#show_msg_error").html('');
                           $('#add_user_btn').attr('disabled', false);
                           $('#add_user_popup').modal('hide');
                        }, 4000);
                     }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                     toastr.error('Something went wrong, Please try later .');
                     alert('Error adding / update data');
                     $('#add_user_btn').text('save'); //change button text
                     $('#add_user_btn').attr('disabled', false); //set button enable
                  }
               });
            }

         }
      });
   }

}

function match_pass() {
   if (document.getElementById('first_password').value ==
      document.getElementById('second_password').value) {
      document.getElementById('second_password').style.borderColor = 'green';
      document.getElementById('match_pass_error').innerHTML = '';

   } else {
      document.getElementById('second_password').style.borderColor = 'red';
      document.getElementById('match_pass_error').innerHTML = 'Password Not Matched';
   }
}
$("#standard_email").blur(function () {
   var standard_email = $('#standard_email').val();
   //var last_name = $('#last_name').val();
   //var standard_name = first_name+" "+last_name;
   $.ajax({
      url: '<?php echo base_url("home/check_duplicate_user"); ?>',
      type: 'POST',
      data: {
         'standard_name': standard_email
      },
      dataType: 'JSON',
      success: function (data) {
         if (data.st == 200) {
            $('#standard_email_error').html('');
            $('#add_user_btn').attr('disabled', false); //set button enable
         } else if (data.st == 202) {
            $('#standard_email_error').html('User Already Exists');
            $('#add_user_btn').attr('disabled', true); //set button enable
         }
      }
   })
});


function delete_entry(id) {
   if (confirm('Are you sure delete this data?')) {
      // ajax delete data to database
      $.ajax({
         url: "<?= site_url('home/delete')?>/" + id,
         type: "POST",
         dataType: "JSON",
         success: function (data) {
            //if success reload ajax table
            $('#modal_form').modal('hide');
            reload_table();
            window.location.reload();
         },
         error: function (jqXHR, textStatus, errorThrown) {
            alert('Error deleting data');
         }
      });
   }
}


function view(id) {
   $('#view')[0].reset(); // reset form on modals
   $.ajax({
      url: "<?php echo base_url('home/getuserbyId/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function (data) {
         var role_id = data.role_id;

         $.ajax({
            url: "<?php echo base_url('roles/getrolesbyId/')?>",
            type: "post",
            data: {
               dataid: role_id
            },
            dataType: "JSON",
            success: function (response) {
               $('[id="roles"]').text(response.role_name)
            }
         });

         $.ajax({
            url: "<?php echo base_url('home/planName/')?>",
            type: "post",
            data: {
               dataid: data.your_plan_id
            },
            success: function (result) {
               $('[id="licencePut"]').text(result);
            }
         });


         $('[id="company_name"]').text(data.company_name);
         $('[id="standard_name"]').text(data.standard_name);
         $('[id="standard_mobile"]').text(data.standard_mobile);
         $('[id="subdomain"]').text(data.sub_domain);
         $('[id="standard_email"]').text(data.standard_email);


         $('[id="company_email"]').text(data.company_email);
         $('[id="company_mobile"]').text(data.company_mobile);
         $('[id="company_gstin"]').text(data.company_gstin);
         $('[id="pan_number"]').text(data.pan_number);
         $('[id="view_reports_to"]').text(data.reports_to);
         //if(data.user_type){
         $('[id="view_user_type"]').text(data.user_type);
         $('[id="cin"]').text(data.cin);
         $('[id="country"]').text(data.country);
         $('[id="state"]').text(data.state);
         $('[id="city"]').text(data.city);
         $('[id="zipcode"]').text(data.zipcode);
         $('[id="company_address"]').text(data.company_address);
         $('#view_user').modal('show'); // show bootstrap modal when complete loaded
         //$('.modal-title').text('User'); // Set title to Bootstrap modal title
      },
      error: function (jqXHR, textStatus, errorThrown) {
         alert('Error Retrieving Data From Database');
      }
   });
}

$("#checkAll").click(function () {
   if ($(this).prop('checked') == true) {
      $(".forchkcl").prop('checked', true);
      $(".forchkcl").val(1);
   } else {
      $(".forchkcl").prop('checked', false);
      $(".forchkcl").val(0);
   }
});
function update(id) {

   $('#update_user_form')[0].reset(); // reset form on modals
   $('#btnSave_update').text('Update'); //change button text
   $('#btnSave_update').attr('disabled', false); //set button disable
   //Ajax Load data from ajax
   $.ajax({
      url: "<?php echo base_url('home/getuserbyId/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function (data) {
         $('#update_id').val(id);
         $('#standard_name_update').val(data.standard_name);
         $('#standard_mobile_update').val(data.standard_mobile);
         $('#standard_email_update').val(data.standard_email);
         $('#sel_lic_type').val(data.your_plan_id);
         $('#sel_lic_type_hidden').val(data.your_plan_id);


         $('#country_update').val(data.country);
         $('#state_update').val(data.state);
         $('#city_update').val(data.city);
         $('#zipcode_update').val(data.zipcode);
         $('#company_gstin_update').val(data.company_gstin);
         $('#company_address_update').val(data.company_address);
         $('#reports_to').val(data.reports_to);
         $('#sel_role').val(data.role_id);
         $('#user_typeUpdate').val(data.user_type);
         //alert(data.reports_to);
         if (data.create_org == true) {
            $("#create_org").attr('checked', true);
            $("#create_org").val(data.create_org);
         } else {
            $("#create_org").attr('checked', false);
            $("#create_org").val(data.create_org);
         }
         if (data.retrieve_org == true) {
            $("#retrieve_org").attr('checked', true);
            $("#retrieve_org").val(data.retrieve_org);
         } else {
            $("#retrieve_org").attr('checked', false);
            $("#retrieve_org").val(data.retrieve_org);
         }
         if (data.update_org == true) {
            $("#update_org").attr('checked', true);
            $("#update_org").val(data.update_org);
         } else {
            $("#update_org").attr('checked', false);
            $("#update_org").val(data.update_org);
         }
         if (data.delete_org == true) {
            $("#delete_org").attr('checked', true);
            $("#delete_org").val(data.delete_org);
         } else {
            $("#delete_org").attr('checked', false);
            $("#delete_org").val(data.delete_org);
         }
         if (data.create_contact == true) {
            $("#create_contact").attr('checked', true);
            $("#create_contact").val(data.create_contact);
         } else {
            $("#create_contact").attr('checked', false);
            $("#create_contact").val(data.create_contact);
         }
         if (data.retrieve_contact == true) {
            $("#retrieve_contact").attr('checked', true);
            $("#retrieve_contact").val(data.retrieve_contact);
         } else {
            $("#retrieve_contact").attr('checked', false);
            $("#retrieve_contact").val(data.retrieve_contact);
         }
         if (data.update_contact == true) {
            $("#update_contact").attr('checked', true);
            $("#update_contact").val(data.update_contact);
         } else {
            $("#update_contact").attr('checked', false);
            $("#update_contact").val(data.update_contact);
         }
         if (data.delete_contact == true) {
            $("#delete_contact").attr('checked', true);
            $("#delete_contact").val(data.delete_contact);
         } else {
            $("#delete_contact").attr('checked', false);
            $("#delete_contact").val(data.delete_contact);
         }
         if (data.create_lead == true) {
            $("#create_lead").attr('checked', true);
            $("#create_lead").val(data.create_lead);
         } else {
            $("#create_lead").attr('checked', false);
            $("#create_lead").val(data.create_lead);
         }
         if (data.retrieve_lead == true) {
            $("#retrieve_lead").attr('checked', true);
            $("#retrieve_lead").val(data.retrieve_lead);
         } else {
            $("#retrieve_lead").attr('checked', false);
            $("#retrieve_lead").val(data.retrieve_lead);
         }
         if (data.update_lead == true) {
            $("#update_lead").attr('checked', true);
            $("#update_lead").val(data.update_lead);
         } else {
            $("#update_lead").attr('checked', false);
            $("#update_lead").val(data.update_lead);
         }
         if (data.delete_lead == true) {
            $("#delete_lead").attr('checked', true);
            $("#delete_lead").val(data.delete_lead);
         } else {
            $("#delete_lead").attr('checked', false);
            $("#delete_lead").val(data.delete_lead);
         }
         if (data.create_opp == true) {
            $("#create_opp").attr('checked', true);
            $("#create_opp").val(data.create_opp);
         } else {
            $("#create_opp").attr('checked', false);
            $("#create_opp").val(data.create_opp);
         }
         if (data.retrieve_opp == true) {
            $("#retrieve_opp").attr('checked', true);
            $("#retrieve_opp").val(data.retrieve_opp);
         } else {
            $("#retrieve_opp").attr('checked', false);
            $("#retrieve_opp").val(data.retrieve_opp);
         }
         if (data.update_opp == true) {
            $("#update_opp").attr('checked', true);
            $("#update_opp").val(data.update_opp);
         } else {
            $("#update_opp").attr('checked', false);
            $("#update_opp").val(data.update_opp);
         }
         if (data.delete_opp == true) {
            $("#delete_opp").attr('checked', true);
            $("#delete_opp").val(data.delete_opp);
         } else {
            $("#delete_opp").attr('checked', false);
            $("#delete_opp").val(data.delete_opp);
         }
         if (data.create_quote == true) {
            $("#create_quote").attr('checked', true);
            $("#create_quote").val(data.create_quote);
         } else {
            $("#create_quote").attr('checked', false);
            $("#create_quote").val(data.create_quote);
         }
         if (data.retrieve_quote == true) {
            $("#retrieve_quote").attr('checked', true);
            $("#retrieve_quote").val(data.retrieve_quote);
         } else {
            $("#retrieve_quote").attr('checked', false);
            $("#retrieve_quote").val(data.retrieve_quote);
         }
         if (data.update_quote == true) {
            $("#update_quote").attr('checked', true);
            $("#update_quote").val(data.update_quote);
         } else {
            $("#update_quote").attr('checked', false);
            $("#update_quote").val(data.update_quote);
         }
         if (data.delete_quote == true) {
            $("#delete_quote").attr('checked', true);
            $("#delete_quote").val(data.delete_quote);
         } else {
            $("#delete_quote").attr('checked', false);
            $("#delete_quote").val(data.delete_quote);
         }
         if (data.create_so == true) {
            $("#create_so").attr('checked', true);
            $("#create_so").val(data.create_so);
         } else {
            $("#create_so").attr('checked', false);
            $("#create_so").val(data.create_so);
         }
         if (data.retrieve_so == true) {
            $("#retrieve_so").attr('checked', true);
            $("#retrieve_so").val(data.retrieve_so);
         } else {
            $("#retrieve_so").attr('checked', false);
            $("#retrieve_so").val(data.retrieve_so);
         }
         if (data.update_so == true) {
            $("#update_so").attr('checked', true);
            $("#update_so").val(data.update_so);
         } else {
            $("#update_so").attr('checked', false);
            $("#update_so").val(data.update_so);
         }
         if (data.delete_so == true) {
            $("#delete_so").attr('checked', true);
            $("#delete_so").val(data.delete_so);
         } else {
            $("#delete_so").attr('checked', false);
            $("#delete_so").val(data.delete_so);
         }
         if (data.create_vendor == true) {
            $("#create_vendor").attr('checked', true);
            $("#create_vendor").val(data.create_vendor);
         } else {
            $("#create_vendor").attr('checked', false);
            $("#create_vendor").val(data.create_vendor);
         }
         if (data.retrieve_vendor == true) {
            $("#retrieve_vendor").attr('checked', true);
            $("#retrieve_vendor").val(data.retrieve_vendor);
         } else {
            $("#retrieve_vendor").attr('checked', false);
            $("#retrieve_vendor").val(data.retrieve_vendor);
         }
         if (data.update_vendor == true) {
            $("#update_vendor").attr('checked', true);
            $("#update_vendor").val(data.update_vendor);
         } else {
            $("#update_vendor").attr('checked', false);
            $("#update_vendor").val(data.update_vendor);
         }
         if (data.delete_vendor == true) {
            $("#delete_vendor").attr('checked', true);
            $("#delete_vendor").val(data.delete_vendor);
         } else {
            $("#delete_vendor").attr('checked', false);
            $("#delete_vendor").val(data.delete_vendor);
         }
         if (data.create_po == true) {
            $("#create_po").attr('checked', true);
            $("#create_po").val(data.create_po);
         } else {
            $("#create_po").attr('checked', false);
            $("#create_po").val(data.create_po);
         }
         if (data.retrieve_po == true) {
            $("#retrieve_po").attr('checked', true);
            $("#retrieve_po").val(data.retrieve_po);
         } else {
            $("#retrieve_po").attr('checked', false);
            $("#retrieve_po").val(data.retrieve_po);
         }
         if (data.update_po == true) {
            $("#update_po").attr('checked', true);
            $("#update_po").val(data.update_po);
         } else {
            $("#update_po").attr('checked', false);
            $("#update_po").val(data.update_po);
         }
         if (data.delete_po == true) {
            $("#delete_po").attr('checked', true);
            $("#delete_po").val(data.delete_po);
         } else {
            $("#delete_po").attr('checked', false);
            $("#delete_po").val(data.delete_po);
         }
         if (data.create_inv == true) {
            $("#create_inv").attr('checked', true);
            $("#create_inv").val(data.create_inv);
         } else {
            $("#create_inv").attr('checked', false);
            $("#create_inv").val(data.create_inv);
         }
         if (data.retrieve_inv == true) {
            $("#retrieve_inv").attr('checked', true);
            $("#retrieve_inv").val(data.retrieve_inv);
         } else {
            $("#retrieve_inv").attr('checked', false);
            $("#retrieve_inv").val(data.retrieve_inv);
         }
         if (data.update_inv == true) {
            $("#update_inv").attr('checked', true);
            $("#update_inv").val(data.update_inv);
         } else {
            $("#update_inv").attr('checked', false);
            $("#update_inv").val(data.update_inv);
         }
         if (data.delete_inv == true) {
            $("#delete_inv").attr('checked', true);
            $("#delete_inv").val(data.delete_inv);
         } else {
            $("#delete_inv").attr('checked', false);
            $("#delete_inv").val(data.delete_inv);
         }

         if (data.create_pi == true) {
            $("#create_pi").attr('checked', true);
            $("#create_pi").val(data.create_pi);
         } else {
            $("#create_pi").attr('checked', false);
            $("#create_pi").val(data.create_pi);
         }
         if (data.retrieve_pi == true) {
            $("#retrieve_pi").attr('checked', true);
            $("#retrieve_pi").val(data.retrieve_pi);
         } else {
            $("#retrieve_pi").attr('checked', false);
            $("#retrieve_pi").val(data.retrieve_pi);
         }
         if (data.update_pi == true) {
            $("#update_pi").attr('checked', true);
            $("#update_pi").val(data.update_pi);
         } else {
            $("#update_pi").attr('checked', false);
            $("#update_pi").val(data.update_pi);
         }

         if (data.delete_pi == true) {
            $("#delete_pi").attr('checked', true);
            $("#delete_pi").val(data.delete_pi);
         } else {
            $("#delete_pi").attr('checked', false);
            $("#delete_pi").val(data.delete_pi);
         }


         if (data.pending_payment_mail == true) {
            $("#pendingPayment").attr('checked', true);
            $("#pendingPayment").val(data.pending_payment_mail);
         } else {
            $("#pendingPayment").attr('checked', false);
            $("#pendingPayment").val(data.pending_payment_mail);
         }
         if (data.accept_payment_mail == true) {
            $("#acceptMail").attr('checked', true);
            $("#acceptMail").val(data.accept_payment_mail);
         } else {
            $("#acceptMail").attr('checked', false);
            $("#acceptMail").val(data.accept_payment_mail);
         }
         if (data.so_approve_mail == true) {
            $("#approveMail").attr('checked', true);
            $("#approveMail").val(data.so_approve_mail);
         } else {
            $("#approveMail").attr('checked', false);
            $("#approveMail").val(data.so_approve_mail);
         }
         if (data.so_approval == true) {
            $("#approveSO").attr('checked', true);
            $("#approveSO").val(data.so_approval);
         } else {
            $("#approveSO").attr('checked', false);
            $("#approveSO").val(data.so_approval);
         }
         if (data.po_approval == true) {
            $("#approvePO").attr('checked', true);
            $("#approvePO").val(data.po_approval);
         } else {
            $("#approvePO").attr('checked', false);
            $("#approvePO").val(data.po_approval);
         }
         if (data.notapprovalSO == true) {
            $("#notapproveSO").attr('checked', true);
            $("#notapproveSO").val(data.notapprovalSo);
         } else {
            $("#notapproveSO").attr('checked', false);
            $("#notapproveSO").val(data.notapprovalSO);
         }
         if (data.notapprovalPO == true) {
            $("#notapprovePO").attr('checked', true);
            $("#notapprovePO").val(data.notapprovalPO);
         } else {
            $("#notapprovePO").attr('checked', false);
            $("#notapprovePO").val(data.notapprovalPO);
         }

         $('#updation_user').modal('show'); // show bootstrap modal when complete loaded
         //$('.modal-title').text('Update User Details'); // Set title to Bootstrap modal title
      },
      error: function (jqXHR, textStatus, errorThrown) {
         alert('Error Retrieving Data From Database');
      }
   });
}

function delete_user(id) {
   if (confirm('Are you sure delete this data?')) {
      // ajax delete data to database
      $.ajax({
         url: "<?= site_url('home/delete')?>/" + id,
         type: "POST",
         dataType: "JSON",
         success: function (data) {
            //if success reload ajax table
            $('#modal_form').modal('hide');
            reload_table();
         },
         error: function (jqXHR, textStatus, errorThrown) {
            alert('Error deleting data');
         }
      });
   }
}

function update_data() {
   $('#btnSave_update').text('saving...'); //change button text
   $('#btnSave_update').attr('disabled', true); //set button disable
   
    var formData = new FormData($('#update_user_form')[0]);
    // var formData = $('#update_user_form').serialize();
   $.ajax({
      url: '<?php echo base_url("home/update");?>',
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "JSON",
      success: function (data) {
         if (data.st == 202) {
            $('#standard_name_update_error').html(data.standard_name);
            $('#standard_email_update_error').html(data.standard_email);
            $('#standard_mobile_update_error').html(data.standard_mobile);
            $('#user_type_update_error').html(data.user_typeUpdate);
            $('#country_update_error').html(data.country);
            $('#state_update_error').html(data.state);
            $('#city_update_error').html(data.city);
            $('#zipcode_update_error').html(data.zipcode);
            $('#company_address_update_error').html(data.company_address);
            $('#btnSave_update').text('Update'); //change button text
            $('#btnSave_update').attr('disabled', false); //set button disable
         } else if (data.st == 200) {
            $('#standard_name_update_error').html('');
            $('#standard_email_update_error').html('');
            $('#standard_mobile_update_error').html('');
            $('#user_type_update_error').html('');
            $('#country_update_error').html('');
            $('#state_update_error').html('');
            $('#city_update_error').html('');
            $('#zipcode_update_error').html('');
            $('#company_address_update_error').html('');
            $('#updation_user').modal('hide');
            reload_table();
         } else if (data.st == 201) {
            toastr.error(data.show_msg);
         }
      }
   });
}


</script>
<script >
  function set_target(id)
  {
    $('#target_form')[0].reset(); // reset form on modals
    $("#data_id").val(id);
    $('#target_popup').modal('show');
    $.ajax({
      url : '<?php echo base_url('home/get_target_data'); ?>',
      type : 'POST',
      data : { 'id' : id },
      dataType: "JSON",
      success : function(data)
      {
        $('#sales_quota_val').html('Target set : '+ data.sales_quota);
        $('#profit_quota_val').html('Target set : '+ data.profit_quota);
      }

    });
  }
  
  function save_target()
  {
    $.ajax({
      url : '<?php echo base_url('home/set_target'); ?>',
      type: "POST",
      data: $("#target_form").serialize(),
      dataType: "JSON",
      success: function(data)
      {
        if(data.st==200)
        {
          $("#target_popup").modal('hide');
        }
      }
    });
  }
  
  function set_target(id,username,type,email)
  {
    $("#organization_add_edit").html("Set target for <i>"+username+"</i>");
    $('#target_form')[0].reset(); // reset form on modals
    $("#data_id").val(id);
    $("#data_type").val(type);
    $("#data_email").val(email);
    $('#target_popup').modal('show');
  }
  
  
  function save_target()
  {
    $("#msgcheck").html('');
    var qmonth=$("#quota_month").val();
    var qsales=$("#sales_quota").val();
    var qprofit=$("#profit_quota").val();
    var data_type=$("#data_type").val();
    if(qmonth=="" || qmonth===undefined || qmonth==null){
          $("#quota_month").css('border-color','red');
          setTimeout(function(){ $("#quota_month").css('border-color',''); },3000);
    }else if(qsales=="" || qsales===undefined || qsales==null){
          $("#sales_quota").css('border-color','red');
           setTimeout(function(){ $("#sales_quota").css('border-color',''); },3000);
    }else if(qprofit=="" || qprofit===undefined || qprofit==null){
          $("#profit_quota").css('border-color','red');
           setTimeout(function(){ $("#profit_quota").css('border-color',''); },3000);
    }else{
      $.ajax({
          url : '<?php echo base_url('target/checkExist'); ?>',
          type: "POST",
          data: $("#target_form").serialize(),
          success: function(data)
          { 
		 
            if(data==0)
            { 
              $.ajax({
                url : '<?php echo base_url('target/set_target'); ?>',
                type: "POST",
                data: $("#target_form").serialize(),
                dataType: "JSON",
                success: function(data)
                {
					console.log(data);
                  if(data.st==200)
                  {
                    $("#target_popup").modal('hide');
                  }
                }
              });
            }else{
              $("#msgcheck").html('<text style="color:red;">Target setted already for this month</text>');
              setTimeout(function(){$("#msgcheck").html(''); },3000);

            }
          }
      })
    }
  }
   $("#sales_quota,#profit_quota").keyup(function(){
	var price = $(this).val();
	price = price.replace(/,/g, "");
    var pricetwo=numberToIndPrice(price);
	$(this).val(pricetwo);
	});
</script>
<script>
$("input[type='checkbox']").on('change', function(){
   this.value = this.checked ? 1 : 0;
   // alert(this.value);
}).change();
</script>
<script type="text/javascript">

$("#sel_roles").change(function(){
    var role_id = $("#sel_roles").val();
    //alert(role_id);
 $.ajax({
      url : '<?php echo base_url('roles/get_rolebyid'); ?>',
      type: "POST",
      data: {role_id:role_id},
      dataType: "JSON",
      success: function(data)
      {
        // console.log(data);
         if(data=='201'){
            $("#reports_autocomplete").val('Company owner') 
         }else{
            $("#reports_autocomplete").val(data.role_name);
         }
       
      }
    });
});

$("#sel_role").change(function(){
    var role_id = $("#sel_role").val();
    //alert(role_id);
 $.ajax({
      url : '<?php echo base_url('roles/get_rolebyid'); ?>',
      type: "POST",
      data: {role_id:role_id},
      dataType: "JSON",
      success: function(data)
      {
        // console.log(data);
         if(data=='201'){
            $("#reports_to").val('Company owner') 
         }else{
            $("#reports_to").val(data.role_name);
         }
       
      }
    });
});

</script>
</body>
</html>