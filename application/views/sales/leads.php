<?php $this->load->view('common_navbar');?>
<!-- Content Wrapper. Contains page content -->
<style>
   #ajax_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   /* padding-top:18px;
  padding-bottom:18px; */
  

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

/* #ajax_datatable tbody tr td:nth-child(2) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
} */

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
                           <option value="org_name">Organization Name</option>
                           <option value="lead_owner">Lead Owner </option>
                           <option value="name">Lead Name </option>
                           <option value="mobile"> Phone</option>
                           <option value="email"> Email</option>
                           <option value="website"> Website </option> 
                           <option value="secondary_email">Secondory Email</option>
                           <option value="office_phone">Office Phone</option>
                           <option value="contact_name">Contact Name</option>

                           <option value="assigned_to_name">Assigned To</option>
                           <option value="lead_source">Lead Source</option>
                           <option value="lead_status">Lead Status</option> 
                           <option value="industry">Industry Type</option> 
                           <option value="rating">Rating</option>

                           <option value="employees">Total Employees</option>
                           <option value="annual_revenue">Annual Revenue</option>
                        
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
                     
                  <div class="col pr-1 dummytext" >
                     <div class ="form-group">
                        <input type="text" id ="dummytext" placeholder="Enter Value" class="form-control" readonly>
                     </div>
                  </div> 

                  <!-- Input or Dropdown Field -->
                  <div class="col pl-1 length-wrapper" style="display: none;">
                     <div class="form-group">
                        <!-- Text Input -->
                        <input type="text" class="form-control length-input" id="value_input" placeholder="Enter Value">

                        <!-- assigned_to_name -->
                  
                        <?php if(isset($record['assigned_to'])){$assigned_to=$record['assigned_to']; }else{ $assigned_to=''; }?>
                        <select class="form-control assigned_to_name-select" id="assigned_to_name_select" style="display: none;">
                           <option value="">Select Assigned To</option>

                           <option value="Yourself">Yourself</option>
                           <?php foreach($user as $users) { ?>
                           <option value="<?= $users['standard_name']?>" <?php if($assigned_to==$users['standard_name']){ echo "selected"; } ?> ><?= $users['standard_name']?></option>
                           <?php } ?>
                           <?php if($this->session->userdata('type') != 'admin') { ?>
                           <option value="<?= $admin['admin_name']; ?>" <?php if($assigned_to==$admin['admin_email']){ echo "selected"; } ?> ><?= $admin['admin_name']; ?></option>
                           <?php } ?>
                     
                           
                        </select>

                        <!-- lead_source Type -->
                        <select class="form-control lead_source-select" id="lead_source_select" style="display: none;">
                           <option value="">Select Lead Source </option>

                              <option value="Advertisement">Advertisement</option>
                              <option value="Cold Call"> Cold Call </option>
                              <option value="Employee Referral">Employee Referral</option>
                              <option value="External Referral">External Referral</option>
                              <option value="Online Store">Online Store</option>
                              <option value="Partner">Partner</option>
                              <option value="Public Relation">Public Relation</option>
                              <option value="Sales Email Alias">Sales Email Alias</option>
                              <option value="Seminar Partner">Seminar Partner</option>
                              <option value="Internal Seminar">Internal Seminar</option>
                              <option value="Trade show">Trade Show</option>
                              <option value="Web Download">Web Download</option>
                              <option value="Web Research">Web Research</option>
                              <option value="chat">Chat</option>
                              <option value="Twitter">Twitter</option>
                              <option value="Facebook">Facebook</option>
                              <option value="Google+">Google+</option>
                              <option value="Existing Customer">Existing Customer</option>
                        </select>


                        <!-- Lead Status -->
                        <select class="form-control lead_status-select" id="lead_status_select" style="display: none;">
                           <option value="">Select lead Status </option>
                           <option value="Attempted To Contact">Attempted To Contact</option>
                           <option value="Contacted In Future">Contact In Future</option>
                           <option value="Contacted">Contacted</option>
                           <option value="Junk Lead">Junk Lead</option>
                           <option value="Lost Lead">Lost Lead</option>
                           <option value="Not Contacted">Not Contacted</option>
                           <option value="Pre-Qualified">Pre-Qualified</option>
                           <option value="Not-Qualified">Not-Qualified</option>
                        </select>



                        <!-- industry -->
                        <select class="form-control industry-select" id="industry_select" style="display: none;">
                           <option value="">Select Industry Type</option>
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


                                          
                        <!-- Rating Type -->
                        <select class="form-control rating-select" id="rating_select" style="display: none;">
                           <option value="">Select Rating</option>
                           <option value="Acquired">Acquired</option>
                           <option value="Active">Active</option>
                           <option value="Market Field">Market Field</option>
                           <option value="Project Cancelled">Project Cancelled</option>
                           <option value="Shut Down">Shut Down</option>
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




<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);overflow-x:clip;">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">Leads</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url()."home"; ?>">Home</a></li>
                  <li class="breadcrumb-item active">Leads</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
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
         <!-- /.row -->
         <div class="row mb-3">
            <div class="col-lg-2">
            <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
                  <input type="hidden" name="date_filter" id="date_filter">
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
            <div class="col-lg-2">
                <?php if($this->session->userdata('type')==='admin'){ ?>
                <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
               <input type="hidden" id="user_filter" value="" name="user_filter">
               <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <!-- <select class="custom-select" name="user_filter" id="user_filter"> -->
                     <option selected  value="">Select User</option>
                     <?php foreach($admin as $adminDtl){ ?>
                      <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$adminDtl['admin_email'];?>','user_filter');"><?=$adminDtl['admin_name'];?></li>
                     <!-- <option value="<?=$adminDtl['admin_email'];?>"><?=$adminDtl['admin_name'];?></option> -->
                     <?php } ?>
                     <?php foreach($user as $userDtl){ ?>
                      <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$userDtl['standard_email'];?>','user_filter');"><?=$userDtl['standard_name'];?></li>
                     <!-- <option value="<?=$userDtl['standard_email'];?>"><?=$userDtl['standard_name'];?></option> -->
                     <?php } ?>
                  <!-- </select> -->
                     </ul>
               </div>
               <?php } ?>
            </div>
            <div class="col-lg-2">
            <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button> 
               <input  type="hidden" name="status_filter" id="status_filter">
               <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <!-- <select class="custom-select" name="user_filter" id="user_filter"> -->
                  <li onclick="getfilterdData('Attempted To Contact','status_filter');">Attempted To Contact</li>
                  <li onclick="getfilterdData('Contact In Future','status_filter');">Contact In Future</li>
                  <li onclick="getfilterdData('Contacted','status_filter');">Contacted</li>
                  <li onclick="getfilterdData('Junk Lead','status_filter');">Junk Lead</li>
                  <li onclick="getfilterdData('Lost Lead','status_filter');">Lost Lead</li>
                  <li onclick="getfilterdData('Not Contacted','status_filter');">Not Contacted</li>
                  <li onclick="getfilterdData('Pre-Qualified','status_filter');">Pre-Qualified</li>
                  <li onclick="getfilterdData('Not-Qualified','status_filter');">Not-Qualified</li>

                 
                 
                     </ul>
            </div>
                     </div>
                     <!-- <div class="col-lg-3"></div> -->
            <div class="col-lg-6">
               <div class="refresh_button float-right">
                  <button class="btnstopcorner" onclick="listgrdvw('listview','gridview')"><i class="fas fa-list-ul"></i></button>
                  <button class="btnstopcorner" onclick="listgrdvw('gridview','listview','grid')"><i class="fas fa-th"></i></button>
                  <button class="btnstopcorner" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
                  <?php if(check_permission_status('Leads Assigned','retrieve_u')==true){ ?>
                  <button class="btnstopcorn"><a href="<?= base_url('leads/assigned')?>" style=" padding: 2px;">Assigned Leads</a></button>
                  <?php } if(check_permission_status('Leads','create_u')==true){
                     if($this->session->userdata('account_type')=="Trial" && $countLead>=1000){
                     ?> 
                  <button class="btncorner" onclick="infoModal('You are exceeded  your leads limit - 1,000')" >Add New</button>
                  <?php }else{?>
                  
                  <button class="btncorner" onclick="import_excel()">Import&nbsp;Leads</button>
                  <button class="btnstop" ><a href="<?= base_url('add-lead')?>" style="color:#fff; padding: 0px;">Add New</a></button>
                  <?php }  } 
                     ?>  
               </div>
            </div>
         </div>
      </div>
      <!-- /.container-fluid  onclick="add_form()" -->
   </div></div>
   <!-- /.content-header -->
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <!-- Main row -->
         <!-- Map card -->
         <!-- <div class="card org_div" id="listview"> -->
            <!-- /.card-header -->
            <div class="wrapper card p-4" style="border-radius:12px;border:none;box-shadow:0px;">
            <div class="card-header mb-2"><b style="font-size:21px;">Leads</b>
             <!-- <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button> -->
                  </div>
            <div class="card-body">
               <div class="row" id="actionDiv" style="display:none;">
                  <div class="col-lg-2 p-2">
                     <div id="assignlead" class="text-info" style="cursor:pointer;"> Assign lead to user</div>
                  </div>
                  <div class="col-lg-2">
                     <?php if(check_permission_status('Leads','delete_u')==true):?>
                     <button class="btn text-danger" type="button" name="delete_all" id="delete_all2" >
                        Delete Leads
                     </button>
                     <?php endif; ?>
                  </div>
                  <div class ="col-lg-2">
                      <a id="mass_model" href="#" style="text-decoration:none;">
                        <button type="button" id="mass_product" class="btn" style="display:none; border-radius: 2rem; margin-bottom: 1rem; background: #845ADF; color:#fff; font-weight: 500;">
                           Mass Update
                        </button>
                        </a>
                  </div>
               </div>
               <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                  <thead>
                     <tr>
                        <?php if(check_permission_status('Leads','delete_u')==true):?>
                        <th>#</th>
                        <?php endif; ?>
                        <th class="th-sm">Organisation Name</th>
                        <th class="th-sm">Lead Name</th>
                        <th class="th-sm">Lead Owner</th>
                        <th class="th-sm">Email</th>
                        <th class="th-sm">Assigned To</th>
                        <th class="th-sm">Lead Status</th>
                        <th class="th-sm">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
            <!-- /.card-body -->
         </div>
         <div class="card-body" id="gridview"  style="display:none;" >
            <input type="text" class="form-control" id="searchRecord" name="searchRecord" style="margin-bottom: 13px; width: 33%;" placeholder="Search Data">
            <div class="row" style="width: 100%;">
               <?php
                  $leadStatus=array('Pre-Qualified','Contacted','Junk Lead','Lost Lead','Not Contacted','Contact in Future','In Progress');
                  for($i=0; $i<count($leadStatus); $i++){ 
                  	$ind=str_replace(' ','',$leadStatus[$i]);
                  	$ind=str_replace('-','',$ind);
                  ?>
               <div class="hdr">
                  <span><?=$leadStatus[$i];?></span>
                  <br>
                  <input type="hidden" id="<?=$ind;?>" value="<?php if($price[$ind]['initial_total']){ echo $price[$ind]['initial_total']; }else{ echo "0"; }?>">
                  <span>
                     ₹ 
                     <text id="txt<?=$ind;?>" data-min='<?php if($price[$ind]['initial_total']){ echo $price[$ind]['initial_total']; }else{ echo "0"; }?>'  data-delay='3' data-increment="99" > <?=IND_money_format($price[$ind]['initial_total']);?></text>
                  </span>
               </div>
               <?php  } ?>
            </div>
            <div class="row" style="width: 100%;" id="putLeadData"></div>
            <!-- Paginate -->
            <div   id="pagination_link"></div>
         </div>
      </div>
   </section>
</div>
<!-- /.content-wrapper -->
<?php if(check_permission_status('Leads','retrieve_u')==true):?>
<!-- View Lead Modal -->
<div class="modal fade show" id="addnew_modal" role="dialog" aria-modal="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="lead_view">Lead Form</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body form">
            <form id="view" class="row" action="javascript:void(0);">
               <div class="col-sm-12">
                  <div class="timeline-one">
                     <div class="events">
                        <ol>
                           <ul>
                              <li>
                                 <a  href="javascript:void(0);" id="leads" class="">Lead</a>
                              </li>
                              <li>
                                 <a href="javascript:void(0);" id="opportunity" class="">Opportunity</a>
                              </li>
                              <li>
                                 <a href="javascript:void(0);" id="quote" class="">Quote</a>
                              </li>
                              <li>
                                 <a href="javascript:void(0);" id="salesorder" class="">Salesorder</a>
                              </li>
                              <li>
                                 <a href="javascript:void(0);" id="purchaseorder" class="">Purchaseorder</a>
                              </li>
                           </ul>
                        </ol>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12">
                  <h5 class="text-primary" id="track_status"></h5>
                  <input type="hidden" id="track_status_hidden" value="">
               </div>
               <div class="col-sm-12">
                  <h5 class="text-primary" id="name"></h5>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Organization&nbsp;Name:</span>
                  <h6 class="text-primary" id="org_name_view"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Ownership:</span>
                  <h6 class="text-primary" id="lead_owner"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Email:</span>
                  <h6 class="text-primary" id="email"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Office&nbsp;Phone:</span>
                  <h6 class="text-primary" id="office_phone"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Mobile:</span>
                  <h6 class="text-primary" id="mobile"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Lead&nbsp;Source:</span>
                  <h6 class="text-primary" id="lead_source"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Lead&nbsp;Status:</span>
                  <h6 class="text-primary" id="lead_status"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Industry:</span>
                  <h6 class="text-primary" id="industry"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Employees:</span>
                  <h6 class="text-primary" id="employees"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Annual&nbsp;Revenue:</span>
                  <h6 class="text-primary" id="annual_revenue"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Rating:</span>
                  <h6 class="text-primary" id="rating"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Website:</span>
                  <h6 class="text-primary" id="website"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Secondary&nbsp;Email:</span>
                  <h6 class="text-primary" id="secondary_email"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Assigned&nbsp;To:</span>
                  <h6 class="text-primary" id="assigned_to"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Contact&nbsp;Name:</span>
                  <h6 class="text-primary" id="contact_name"></h6>
               </div>
               <div class="col-sm-12">
                  <h5>Address&nbsp;Details:</h5>
               </div>
               <div class="col-sm-3">
                  <span class="text-secondary">Billing&nbsp;Country:</span>
                  <h6 class="text-primary" id="billing_country"></h6>
               </div>
               <div class="col-sm-3">
                  <span class="text-secondary">Billing&nbsp;State:</span>
                  <h6 class="text-primary" id="billing_state"></h6>
               </div>
               <div class="col-sm-3">
                  <span class="text-secondary">Shipping&nbsp;Country:</span>
                  <h6 class="text-primary" id="shipping_country"></h6>
               </div>
               <div class="col-sm-3">
                  <span class="text-secondary">Shipping&nbsp;State:</span>
                  <h6 class="text-primary" id="shipping_state"></h6>
               </div>
               <div class="col-sm-3">
                  <span class="text-secondary">Billing&nbsp;City:</span>
                  <h6 class="text-primary" id="billing_city"></h6>
               </div>
               <div class="col-sm-3">
                  <span class="text-secondary">Billing&nbsp;Zipcode:</span>
                  <h6 class="text-primary" id="billing_zipcode"></h6>
               </div>
               <div class="col-sm-3">
                  <span class="text-secondary">Shipping&nbsp;City:</span>
                  <h6 class="text-primary" id="shipping_city"></h6>
               </div>
               <div class="col-sm-3">
                  <span class="text-secondary">Shipping&nbsp;Zipcode:</span>
                  <h6 class="text-primary" id="shipping_zipcode"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Billing&nbsp;Address:</span>
                  <h6 class="text-primary" id="billing_address"></h6>
               </div>
               <div class="col-sm-6">
                  <span class="text-secondary">Shipping&nbsp;Address:</span>
                  <h6 class="text-primary" id="shipping_address"></h6>
               </div>
               <div class="col-sm-12">
                  <span class="text-secondary">Description:</span>
                  <h6 class="text-primary" id="description"></h6>
               </div>
               <div class="col-md-12 mb-6">
                  <h5>Add&nbsp;Product&nbsp;Details</h5>
               </div>
               <div class="col-sm-12">
                  <table class="table-responsive-lg-sm" id="add2" width="100%">
                     <tbody>
                        <tr style="border-top: 1px solid #ece8e8; border-bottom: 1px solid #ece8e8;">
                           <td>Product&nbsp;Name</td>
                           <td>Quantity</td>
                           <td>Unit&nbsp;Price</td>
                           <td>Total</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <div class="col-md-6">
               </div>
               <div class="col-md-6">
                  <table class="float-right table table-responsive-lg-sm" width="100%">
                     <tbody>
                        <tr>
                           <td><span class="text-secondary">Initial&nbsp;Total:</span></td>
                           <td>
                              <h6 class="text-primary" id="initial_total"></h6>
                           </td>
                        </tr>
                        <tr>
                           <td><span class="text-secondary">Overall&nbsp;Discount:</span></td>
                           <td>
                              <h6 class="text-primary" id="discount"></h6>
                           </td>
                        </tr>
                        <tr>
                           <td><span class="text-secondary">Sub&nbsp;Total:</span></td>
                           <td>
                              <h6 class="text-primary" id="sub_total"></h6>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- View Lead Modal -->
<?php endif; ?>
<div class="modal fade" id="assignedLeadModel" role="dialog" aria-modal="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="lead_view">Assign Lead</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body form">
            <form id="formAssignLead" class="row" action="javascript:void(0);">
               <input type="hidden" name="allleaddatat" id="allleaddatat">
               <div class="col-md-12">
                  <div class="form-group">
                     <label for="userforlead">Select User</label>
                     <select class="form-control" id="userforlead" name="userforlead">
                        <option value="">Select User</option>
                        <?php foreach($user as $users) { ?>
                        <option value="<?= $users['standard_email']?>"><?= $users['standard_name']?></option>
                        <?php } ?>
                        <?php if($this->session->userdata('type') != 'admin') { ?>
                        <option value="<?= $admin['admin_email']; ?>"><?= $admin['admin_name']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-12 text-right">
                  <button class="btn btn-info" id="saveleadAssi" name="saveleadAssi" >Save</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
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
                  <br><a href="<?php echo SAMPLE_EXCEL;?>lead_sample.csv">View CSV File sample</a>
               </p>
               <p>Note:-Mandatory fields<br>
                  Email, Mobile
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
               <button type="submit" name="import" value="Import" class="btn btn-info ripple" id="import_button">Import</button>
               <label style="padding-top: 7px;float: right;"><i class="fas fa-info-circle" style="color:red"></i> Only csv file accepted.</label>
            </form>
         </div>
      </div>
   </div>
</div>




<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>

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
   $("#excel_table").hide();
   $('#import_form').on('submit', function(event){
    
   event.preventDefault();
   $.ajax({
   url:"<?php echo base_url(); ?>leads/import",
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
      
       $("#import_button").attr('disabled',true);
     }
     
    }
   })
   });
   
</script>

<script>
   function numberRoller(pttxt,maxprice){
              var min=parseInt($("#"+pttxt).attr('data-min'));
              var max=parseInt(maxprice);
              var timediff=parseInt($("#"+pttxt).attr('data-delay'));
              var increment=parseInt($("#"+pttxt).attr('data-increment'));
              var numdiff=max-min;
              var timeout=(timediff*1000)/numdiff;
              numberRoll(pttxt,min,max,increment,timeout);
      }
      function numberRoll(pttxt,min,max,increment,timeout){
          if(min<=max){
              $("#"+pttxt).html(min);
              min=parseInt(min)+parseInt(increment);
              setTimeout(function(){
   		numberRoll(pttxt,eval(min),eval(max),eval(increment),eval(timeout))
   		},timeout);
          }else{
              $("#"+pttxt).html(max);
          }
      }
   
   
   function listgrdvw(dispid,idhide,grid=''){
   if(grid=='grid'){
   	$("#user_filter").hide();
   	$("#status_filter").hide();
   }else{
   	$("#user_filter").show();
   	$("#status_filter").show();
   }
   $('#'+idhide).hide();
   $('#'+dispid).show();
   }
   
   function load_country_data(page,dateFilter)
   {
   var search		= $("#searchRecord").val();
   if(dateFilter===undefined){
   	dateFilter='';
   }
    $.ajax({
     url:"<?php echo base_url(); ?>leads/pagination/"+page,
     method:"GET",
     data:"searchDate="+dateFilter+"&search="+search,
     dataType:"json",
     success:function(data)
     {
      $('#pagination_link').html(data.pagination_link);
     }
    });
   }
   
   load_country_data(1);
   
   $(document).on("click", ".pagination li a", function(event){
    event.preventDefault();
   	var page = $(this).data("ci-pagination-page");
   	var dateFilter	= $("#date_filter").val();
   	load_country_data(page,dateFilter);
   	getDataGrid(dateFilter,'',page);
   });
   
   
      //addElements();
   getDataGrid('','',1);
   function getDataGrid(dateFilter='',search='',page=''){
   	$.ajax({
   		url : "<?= site_url('leads/gridview');?>",
   		type: "POST",
   		data: "leadid=123&searchDate="+dateFilter+"&search="+search+'&page='+page,
   		success: function(data){
   			$("#putLeadData").html(data);
   		}
   	});
   }
   
   $("#searchRecord").keyup(function(){
   	var search		= $(this).val();
   	var date_filter	= $("#date_filter").val();
   	getDataGrid(date_filter,search,1);
   	load_country_data(1);
   });
</script>
<?php if(check_permission_status('Leads','retrieve_u')==true):?>
<script>
   $(document).ready(function(){
     var track_status = document.getElementById('track_status').value;
   });
</script>

<script>
   var sel1 = document.querySelector('#sel1');
   var sel2 = document.querySelector('#sel2');
   var options2 = document.querySelectorAll('option');
   function giveSelection(selValue) {
     sel2.innerHTML = '';
     for(var i = 0; i < options2.length; i++) {
       if(options2[i].dataset.option === selValue) {
         sel2.appendChild(options2[i]);
       }
     }
   }
   giveSelection(sel1.value);
</script>
<script>
   jQuery(function(){
     jQuery('.show_div').click(function(){
           jQuery('.targetDiv').hide();
           jQuery('#div'+$(this).attr('target')).show();
     });
   });
</script>
<?php endif; ?>
<script>
   <?php if(check_permission_status('Leads','retrieve_u')==true):?>
     var table;
     $(document).ready(function () {
       table = $('#ajax_datatable').DataTable({
           "processing": true, 
           "serverSide": true, 
           "order": [], 
           "ajax": {
               "url": "<?= base_url('leads/ajax_list')?>",
               "type": "POST",
               "data" : function(data){
                  data.searchDate = $('#date_filter').val();
                  data.searchUser = $('#user_filter').val();
                  data.searchStaus = $('#status_filter').val();
               }
           },
           "columnDefs": [
           { 
               "targets": [ 0 ],
               "orderable": false,
           },
           ],
       });
       $('#date_filter').change(function(){
         table.ajax.reload();
          var searchDate = $('#date_filter').val();
      getDataGrid(searchDate,'',1)
   load_country_data(1,searchDate);
       });
    $('#user_filter,#status_filter').change(function(){
   	table.ajax.reload();
       });
     });
   <?php endif; ?>
   
   $('#delete_all2').click(function(){
     var checkbox = $('.delete_checkbox:checked');
     if(checkbox.length > 0){
         $("#delete_confirmation").modal('show');
     }else{
         toastr.warning('Please select at least one row');
     }
    });
   
   
   $("#confirmed").click(function(){
    deleteBulkItem('leads/delete_bulk'); 
   }); 
   
   
   
   $("#assignlead").click(function(){
   var selected = new Array();
   $("input:checkbox[name=action_ck]:checked").each(function() {
   	   selected.push($(this).val());
   });
   if(selected.length>0){
   	$('#assignedLeadModel').modal('show');
   	$('#allleaddatat').val(selected);
   }else{
   	toastr.warning('Please select at least one row');
   }
   });
   
   function checkCheckbox(){
   var selected = new Array();
   $("input:checkbox[name=action_ck]:checked").each(function() {
   selected.push($(this).val());
   });	
   if(selected.length>0){
   $("#actionDiv").show();
   }else{
   $("#actionDiv").hide();
   }
   }
   
   
   $("#saveleadAssi").click(function(){
   var selected = new Array();
   $("input:checkbox[name=action_ck]:checked").each(function() {
   	selected.push($(this).val());
   });
   if(selected.length>0){
   	var username=$('#userforlead option:selected').text();
   	var url = "<?= base_url('leads/assignlead_user')?>";
   	var dataString = $("#formAssignLead").serialize();
   	$.ajax({
   		url : url,
   		type: "POST",
   		data: dataString+'&selected='+selected+'&username='+username,
   		success: function(data){  
   		  if(data==1){
   			  var username=$('#userforlead option:selected').text();
   			  toastr.success('Selected leads assigned to '+username);  
   			  $('#assignedLeadModel').modal('hide');
   			  $('#userforlead').val('');
   			  //$('#userforlead').val('');
   			  table.ajax.reload();
   		  }else{
   			  toastr.error('Something went wrong please try later.');
   		  }
   		}
   	});
   }else{
   	toastr.warning('Please select at least one row');
   	// alert('Please Select Items.');
   }
   
   });

   function getfilterdData(e,g){
   var id = "#" + g;
   $(id).val(e);
   table.ajax.reload();
   }
   
   
   
   function reload_table()
   {
     table.ajax.reload(null,false); //reload datatable ajax
   }
   
   <?php if(check_permission_status('Leads','retrieve_u')==true):?>
   
     function view(id)
     {
       $('#opportunity').removeClass('selected');
       $('#opportunity').removeClass('selected_red');
       $('#quote').removeClass('selected');
       $('#quote').removeClass('selected_red');
       $('#salesorder').removeClass('selected');
       $('#salesorder').removeClass('selected_red');
       $('#purchaseorder').removeClass('selected');
       $('#purchaseorder').removeClass('selected_red');
       $('#view')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string
       //Ajax Load data from ajax
       $.ajax({
         url : "<?= base_url('leads/getbyId/')?>/" + id,
         type: "GET",
         dataType: "JSON",
         success: function(data)
         {
           $("#add2").find("tr").not(':first').remove();
           $('[id="name"]').text(data.name);
           $('[id="org_name_view"]').text(data.org_name);
           $('[id="lead_owner"]').text(data.lead_owner);
           $('[id="email"]').text(data.email);
           $('[id="website"]').text(data.website);
           $('[id="office_phone"]').text(data.office_phone);
           $('[id="mobile"]').text(data.mobile);
           $('[id="lead_source"]').text(data.lead_source);
           $('[id="lead_status"]').text(data.lead_status);
           $('[id="industry"]').text(data.industry);
           $('[id="employees"]').text(data.employees);
           $('[id="annual_revenue"]').text(data.annual_revenue);
           $('[id="rating"]').text(data.rating);
           $('[id="website"]').text(data.website);
           $('[id="secondary_email"]').text(data.secondary_email);
           $('[id="assigned_to"]').text(data.assigned_to);
           $('[id="assigned_to_name"]').text(data.assigned_to_name);
           $('[id="contact_name"]').text(data.contact_name);
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
           var product_name 	= data.product_name;
           var quantity 		= data.quantity;
           var unit_price 	= data.unit_price;
           var total 		= data.total;
           var percent 		= data.percent;
     var proDescription= data.pro_description;
           var p_name 		= product_name.split('<br>');
           var qty 			= quantity.split('<br>');
           var u_prc 		= unit_price.split('<br>');
           var ttl 			= total.split('<br>');
     var description 			= proDescription.split('<br>');
           for (var i=0; i < p_name.length; i++)
           {
             var markup = "<tr><td><h6 class='text-primary'>"+p_name[i]+"</h6></td>"+
             "<td><h6 class='text-primary'>"+qty[i]+"</h6></td>"+
             "<td><h6 class='text-primary'>"+numberToIndPrice(u_prc[i])+"</h6></td>"+
             "<td><h6 class='text-primary'>"+numberToIndPrice(ttl[i])+"</h6></td></tr><tr style='border-bottom: 1px solid #e8e3e3;'><td colspan='4'><h6 class='text-primary'>"+description[i]+"</h6></td></tr>";
             $("#add2").append(markup);
           }
           $('[id="initial_total"]').text(numberToIndPrice(data.initial_total));
           $('[id="discount"]').text(data.discount);
           $('[id="sub_total"]').text(numberToIndPrice(data.sub_total));
           $('[id="total_percent"]').text(data.total_percent);
            if(data.track_status == "lead")
           { 
             $('#leads').addClass('selected');
             $('#opportunity').addClass('selected_red');
             $('#quote').addClass('selected_red');
             $('#salesorder').addClass('selected_red');
             $('#purchaseorder').addClass('selected_red');
           }
           else if(data.track_status == "opportunity")
           {
             $('#leads').addClass('selected');
             $('#opportunity').addClass('selected');
             $('#quote').addClass('selected_red');
             $('#salesorder').addClass('selected_red');
             $('#purchaseorder').addClass('selected_red');
           }
           else if(data.track_status == "quote")
           {
             $('#leads').addClass('selected');
             $('#opportunity').addClass('selected');
             $('#quote').addClass('selected');
             $('#salesorder').addClass('selected_red');
             $('#purchaseorder').addClass('selected_red');
           }
           else if(data.track_status == "salesorder")
           {
             $('#leads').addClass('selected');
             $('#opportunity').addClass('selected');
             $('#quote').addClass('selected');
             $('#salesorder').addClass('selected');
             $('#purchaseorder').addClass('selected_red');
           }
           else if(data.track_status == "purchaseorder")
           {
             $('#leads').addClass('selected');
             $('#opportunity').addClass('selected');
             $('#quote').addClass('selected');
             $('#salesorder').addClass('selected');
             $('#purchaseorder').addClass('selected');
           }
           else if(data.track_status == "")
           {
             $('#leads').addClass('selected');
             $('#opportunity').addClass('selected_red');
             $('#quote').addClass('selected_red');
             $('#salesorder').addClass('selected_red');
             $('#purchaseorder').addClass('selected_red');
           }
           $('#addnew_modal').modal('show'); // show bootstrap modal when complete loaded
           $('.modal-title').text('Lead'); // Set title to Bootstrap modal title
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
           toastr.error('Error retrieving data from database');
         }
       });
     }
   
   <?php endif; ?>
   
   
   
   <?php if(check_permission_status('Leads','delete_u')==true):?>
     function delete_entry(id)
     {
       if(confirm('Are you sure delete this data?'))
       {
         $.ajax({
           url : "<?= base_url('leads/delete')?>/"+id,
           type: "POST",
           dataType: "JSON",
           success: function(data)
           {
               $('#lead_modal').modal('hide');
               table.ajax.reload();
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
             toastr.error('Error deleting data');
           }
         });
       }
     }
   <?php endif; ?>
</script>

<?php if(isset($_GET['lid']) && $_GET['lid']!=""){ ?>
<script>
   view("<?=$_GET['lid'];?>");
   var urlCur      = window.location.href;
   var  myArr 		= urlCur.split("?");
   var url			= myArr[0];
   if (window.history.replaceState) {
      window.history.replaceState('', '', url);
   }
</script>
<?php } ?>
<!-- AUTOCOMPLETE QUERY -->
<script>
   function refreshPage(){
       window.location.reload();
   } 
</script>


<!---------------------------- New Ajax Start ---------------------------->

<script>
function showAction(id) {
    var checkbox = $('input[value="' + id + '"].delete_checkbox');
//  alert('test');
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
    'name','org_name', 'mobile', 'email', 'website','lead_source','lead_status','industry', 'rating', 'assigned_to_name',
    'lead_owner','secondary_email','reports_to','contact_name','employees','annual_revenue', 'office_phone', 'billing_country',
    'billing_state', 'billing_city', 'billing_zipcode', 'billing_address',
    'shipping_country', 'shipping_state', 'shipping_city', 'shipping_zipcode',
    'shipping_address', 'pro_description'
  ];

  document.addEventListener('change', function (e) {
    if (e.target.matches('.type-select')) {
      
      
      const selectedType = e.target.value.trim().toLowerCase();

      const wrapper = e.target.closest('.form-row');
      const lengthWrapper = wrapper.querySelector('.length-wrapper');
      const dummytextWrapper = wrapper.querySelector('.dummytext');

      const input = wrapper.querySelector('.length-input');
      const assigned_to_nameSelect = wrapper.querySelector('.assigned_to_name-select');
      const lead_sourceSelect = wrapper.querySelector('.lead_source-select');
      const lead_statusSelect = wrapper.querySelector('.lead_status-select');
      const industrySelect = wrapper.querySelector('.industry-select');

      const Select = wrapper.querySelector('.customertype-select');
      const ratingSelect = wrapper.querySelector('.rating-select');



      if (typesRequiringLength.includes(selectedType)) {
        lengthWrapper.style.display = 'block';
        dummytextWrapper.style.display = 'none';

        // Hide all first
        input.style.display = 'none';
        assigned_to_nameSelect.style.display = 'none';
        lead_sourceSelect.style.display = 'none';
        lead_statusSelect.style.display = 'none';
        industrySelect.style.display = 'none';

        ratingSelect.style.display = 'none';

        // Show appropriate one
        if (selectedType === 'assigned_to_name') {
          assigned_to_nameSelect.style.display = 'block';
        } else if (selectedType === 'lead_source') {
          lead_sourceSelect.style.display = 'block';
        }else if (selectedType === 'lead_status') {
          lead_statusSelect.style.display = 'block';
        }else if (selectedType === 'industry') {
          industrySelect.style.display = 'block';
        }else if (selectedType === 'rating') {
          ratingSelect.style.display = 'block';
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
    if (selectedType === 'assigned_to_name') {
      finalValue = $('#assigned_to_name_select').val();
    }else if (selectedType === 'lead_source') {
      finalValue = $('#lead_source_select').val();
    }else if (selectedType === 'lead_status') {
      finalValue = $('#lead_status_select').val();
    }else if (selectedType === 'industry') {
      finalValue = $('#industry_select').val();
    }else if (selectedType === 'rating') {
      finalValue = $('#rating_select').val();
    }else {
      finalValue = $('#value_input').val();
    }

    // Set hidden field
    $('#final_value_input').val(finalValue);

    // Submit via AJAX
    var formData = $('#massForm').serialize();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('leads/add_mass'); ?>",
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


