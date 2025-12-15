<?php $this->load->view('common_navbar');?>
<style>
.hdr{
width:10%;
}
.lists{
width:10%;
}
#btnshowhide{
    color:grey; 
    border-color:lightgrey;
    cursor:pointer;
    float:right;
    height:30px;
   margin-right:12px;
    line-height:10px;
}
#btnshowhide:hover{
  background:rgba(230,242,255,0.4);
}
#ajax_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   /* padding-top:18px;
  padding-bottom:18px;
   */

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

/* #ajax_datatable tbody tr td:nth-child(4) {
   
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
                           <option value="owner"> Owner </option>
                           <option value="name">Opportunity Name </option>
                           <option value="mobile"> Phone</option>
                           <option value="email"> Email</option>
                           <option value="contact_name">Contact Name</option>

                           <option value="lead_source">Lead Source</option>
                           <option value="pipeline"> Pipeline</option> 
                           <option value="industry">Industry Type</option> 
                           <option value="stage">Opportunity Stage</option> 
                           <option value="lost_reason">Lost Reason</option> 

                           <option value="employees">Total Employees</option>
                           <option value="weighted_revenue">Annual Revenue</option>
                           <option value="probability">Probability </option>
                           <option value="expclose_date">Expected Closing Date </option>
                        
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
                           <!-- <option value="description">Description</option> -->

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
                        <input type="date" class="form-control expclose_date-select" id="expclose_date_select" placeholder="select date" style="display: none;">

                       

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
                        <select class="form-control pipeline-select" id="pipeline_select" style="display: none;">
                          <option value="">Select Pipeline </option>
                          <option value="Pipeline">Pipeline</option>
                          <option value="Standard">Standard</option>
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


                                          
                        <!-- Opp stage Type -->
                        <select class="form-control stage-select" id="stage_select" style="display: none;">
                           <option value="">Select Opportunity stage</option>
                           <option value="Qualifying">Qualifying</option>
                           <option value="Needs Analysis">Needs Analysis</option>
                           <option value="Proposal">Proposal</option>
                           <option value="Negotiation">Negotiation </option>
                           <option value="Closed Won">Closed Won</option>
                           <option value="Closed Lost">Closed Lost</option>
                        </select>

                        <!-- Opp lost_reason  -->
                        <select class="form-control lost_reason-select" id="lost_reason_select" style="display: none;">
                           <option value="">Select Lost Reason</option>
                            <option value="Lost To Competitor">Lost To Competitor</option>
                            <option value="NO Budget/Lost Funding">No Budget/Lost Funding</option>
                            <option value="No Decision/Non-Responsive">No Decision/Non-Responsive</option>
                            <option value="Price">Price</option>
                            <option value="Other">Other</option>
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
            <h1 class="m-0 text-dark">Opportunity</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Opportunity</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="container-fliud filterbtncon"  >
        <?php 
                                  //  $fifteen = strtotime("-15 Day"); 
                                  //  $thirty = strtotime("-30 Day"); 
                                  //  $fortyfive = strtotime("-45 Day"); 
                                  //  $sixty = strtotime("-60 Day"); 
                                  //  $ninty = strtotime("-90 Day"); 
                                  //  $six_month = strtotime("-180 Day"); 
                                  //  $one_year = strtotime("-365 Day");
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

          <div class="col-lg-2">
              <div class="first-one custom-dropdown dropdown">
                <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Select Option
                </button> 
                  <input  type="hidden" id="stage_filter" name="stage_filter">
                  <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <!-- <select class="custom-select" name="user_filter" id="user_filter"> -->
                              <li onclick="getfilterdData('Qualifying','stage_filter');">Qualifying</li>
                              <li onclick="getfilterdData('Needs Analysis','stage_filter');">Needs Analysis</li>
                              <li onclick="getfilterdData('Proposal','stage_filter');">Proposal</li>
                              
                              <li onclick="getfilterdData('Negotiation','stage_filter');">Negotiation</li>
                              <li onclick="getfilterdData('Closed Won','stage_filter');">Closed Won</li>
                              <li onclick="getfilterdData('Closed Lost','stage_filter');">Closed Lost</li>
                              
                            
                            
                        </ul>
              </div>
          </div>


           <div class="col-lg-2">
              <a id="mass_model" href="#" style="text-decoration:none;">
                  <button type="button" id="mass_product" class="btn" style="display:none; border-radius: 2rem; margin-bottom: 1rem; background: #845ADF; color:#fff; font-weight: 500;">
                    Mass Update
                  </button>
              </a>
          </div>

      <!-- <div class="col-lg-3"></div> -->
          <div class="col-lg-4">
              <div class="refresh_button float-right">
                  <button class="btnstopcorner" onclick="listgrdvw('listview','gridview')"><i class="fas fa-list-ul"></i></button>
				          <button class="btnstopcorner" onclick="listgrdvw('gridview','listview','grid')"><i class="fas fa-th"></i></button>
                  <button class="btnstopcorner" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>

                  <?php if($this->session->userdata('type')=='admin'){ ?>
                  <a href='Export_data/export_opportunity' class="p-2" ><button class="btncorner">Export Data</button></a>
                  <?php } if(check_permission_status('Opportunity','create_u')==true){
                  if($this->session->userdata('account_type')=="Trial" && $countOpp>=1000){
                  ?> 
                  <button class="btnstop" onclick="infoModal('You are exceeded  your leads limit - 1,000')" >Add New</button>
                  <?php }else{ ?>
                          <button class="btnstop" ><a href="<?= base_url('add-opportunity')?>" style="color:#fff; padding: 0px;">Add New</a></button>
                  <?php } } ?>
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
          </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
		<div class="container-fluid">
    <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                   <!-- <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button> -->
                </div>
              </div>
          </div>
            <div class=" org_div" id="listview">
              <div class="card-body">
              

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Column visibility</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                        <table class="table table-striped">
                            <thead style="background:rgba(60,60,170)">
                              <tr>
                                <th>Columns</th>
                                <th>Visibility</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php if($this->session->userdata('type')=='admin'){?> 
                                 <tr>
                                  <td>Delete</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                <td>Oppurtunity Name</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked  ></td>
                                </tr>
                                <tr>
                                <td>Organization name</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <!-- <tr>
                                <td>Email</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr> -->
                                <tr>
                                <td>Primary Phone</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Oppurtunity ID</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                  <td>Created Date</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Action</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                            </tbody>
                          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="savecolvis">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="wrapper card p-4" style="border-radius:12px;border:none;box-shadow:0px;">
            <div class="card-header mb-2"><b style="font-size:21px;">Opportunity</b>
                <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button>

            </div>


            


            <div class="card-body">
                <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                          <?php if(check_permission_status('Opportunity','delete_u')==true):?>
                            <th><button class="btn" type="button" name="delete_all" id="delete_all2"><i class="fa fa-trash text-light"></i></button></th>
                          <?php endif; ?>
                          <th class="th-sm">Organization Name</th>
                          <th class="th-sm">Opportunity Name</th>
                         
                          <th class="th-sm">Opportunuity ID</th>
                          <!-- <th class="th-sm">Email</th> -->
                          <th class="th-sm">Primary Phone</th>
                          
                          <th class="th-sm">Created Date</th>
                          <th class="th-sm" style="width: 10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
              </div>
            </div>
			<!--GRID VIEW DIV-->
            <div class="card-body" id="gridview"  style="display:none;" >
				<input type="text" class="form-control" id="searchRecord" name="searchRecord" style="margin-bottom: 13px; width: 33%;" placeholder="Search Data">
				<div class="row" style="width: 125%;">
					<?php
					  $leadStatus=array('New','Qualifying','Closed Lost','Ready To Close','Value Proposition','Closed Won','Negotiation','Proposal','Needs Analysis');
				   
					for($i=0; $i<count($leadStatus); $i++){ 
						$ind=str_replace(' ','',$leadStatus[$i]);
						$ind=str_replace('-','',$ind);
					 ?>
					<div class="hdr">
						<span><?=$leadStatus[$i];?></span><br>
						<input type="hidden" id="<?=$ind;?>" value="<?php if($price[$ind]['initial_total']){ echo $price[$ind]['initial_total']; }else{ echo "0"; }?>">
						<span>₹ <text id="txt<?=$ind;?>" data-min='<?php if($price[$ind]['initial_total']){ echo $price[$ind]['initial_total']; }else{ echo "0"; }?>'  data-delay='3' data-increment="99" > <?=IND_money_format($price[$ind]['initial_total']);?></text></span>
					</div>
				  <?php  }  ?>
				</div>
				<div class="row" style="width: 125%;" id="putLeadData">	
				</div>
		       <div   id="pagination_link"></div>
			</div> 
        </div>
    </section>
  </div>
  <?php if(check_permission_status('Opportunity','retrieve_u')==true): ?>
  
    <!-- View modal -->
    <div class="modal fade show" id="view_popup" role="dialog" aria-modal="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="opp_view">Opportunity</h4>
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
                  <h5 class="text-primary" id="name"></h5>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Ownership:</span><h6 class="text-primary" id="owner"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Conatact&nbsp;Name:</span><h6 class="text-primary" id="contact_name"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Expecting&nbsp;Closing&nbsp;Date:</span><h6 class="text-primary" id="expclose_date"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Pipeline:</span><h6 class="text-primary" id="pipeline"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Stage:</span><h6 class="text-primary" id="stage_view"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Lead&nbsp;Source:</span><h6 class="text-primary" id="lead_source"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Type:</span><h6 class="text-primary" id="type"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Probability:</span><h6 class="text-primary" id="probability"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Industry:</span><h6 class="text-primary" id="industry"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Employees:</span><h6 class="text-primary" id="employees"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Weighted&nbsp;Revenue:</span><h6 class="text-primary" id="weighted_revenue"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Secondary&nbsp;Email:</span><h6 class="text-primary" id="email"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Mobile:</span><h6 class="text-primary" id="mobile"></h6>
                </div>
                <table class="table-responsive-lg-sm" style="margin-bottom:5px; width: 100%;" id="view_add">
                  <tbody>
                    <tr style="border-top: 1px solid #ece8e8; border-bottom: 1px solid #ece8e8;">
                     
                      <td width="50%">Product&nbsp;Name</td>
                      <td width="16%">Quantity</td>
                      <td width="16%">Unit&nbsp;Price</td>
                      <td width="16%">Total</td>
                    </tr>
                    <tr>
                      <td width="2%"></td><td width="52%">
                        <input name="product_name[]" class="form-control productItm" value="" type="text" onKeyup="getproductinfo();" placeholder="Product Name" readonly="">
                      </td>
                      <td width="16%">
                        <input name="quantity[]" class="form-control" value="" type="text" placeholder="Quantity" readonly="">
                      </td>
                      <td width="16%">
                        <input name="unit_price[]" class="form-control start" value="" type="text" placeholder="Unit Price" readonly="">
                      </td>
                      <td width="16%">
                        <input name="total[]" class="form-control" value="" type="text" placeholder="Total" readonly="">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="col-sm-12">
                </div>
                <div class="col-sm-4">Initial&nbsp;Total:<h6 class="text-primary" id="initial_total"></h6>
                </div>
                <div class="col-sm-4">Overall&nbsp;Discount:<h6 class="text-primary" id="discount"></h6>
                </div>
                <div class="col-sm-4">Sub&nbsp;Total:<h6 class="text-primary" id="sub_total"></h6>
                </div>
              </form>
            </div>
        </div>
      </div>
    </div>
    <!-- View modal -->
  <?php endif; ?>
  
  
  
   <!-- Sub opp Data pop Modal Starts  -->
    <?php if(!empty($sub_opp_popup)):?>
        <div class="modal fade" id="sub_opp_alert" role="dialog" data-keyboard="false" data-backdrop="static">
           <div class="modal-dialog modal-xl">
              <div class="modal-content" >
                 <div class="modal-header">
                    <h4 class="modal-title sales_alert">
                       Opportunity Pending&nbsp;Alert 
                    </h4>
                    <button type="button" class="close d-block" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <!--<span onclick="close_notify_sess();" style="background:rgba(35,0,140,0.8);">Close</span>-->
                    
                 </div>
                 <div class="modal-body form">
                    <table class="table">
                       <thead style="background:rgba(35,0,140,0.8);" >
                          <tr>
                            
                             <th>Organization&nbsp;Name</th>
                             <th>Opportunity &nbsp;Name</th>
                             <th style="min-width:100px;">Owner</th>
                             <th style="min-width:80px;">Amount</th>
                             <!-- <th style="min-width:80px;">Profit</th> -->
                              <th>Expected Closing &nbsp;Date</th>
                              <th>Create &nbsp;Date</th>
                             <th colspan="2" class="text-center">Action</th>
                             <!-- <th>Action</th> -->
                          </tr>
                       </thead>
                       <tbody id="notify_PO">
                          <?php 
                             $cpo=0; 
                             if(!empty($sub_opp_popup)) 
                             { 
                               $amount = 0;
                               $profit = 0;
                             foreach($sub_opp_popup as $sales) { 
                               $cpo=1;
                               
                             
                               $cu = $sales['currentdate'];
                               $currentdate = date("d-m-y", strtotime($cu));
        
                               $Expected_Closing_Date = $sales['expclose_date'];
                               $Exp_Closing_Date = date("d-m-y", strtotime($Expected_Closing_Date));
                             
                             ?>
                          <tr>
                            
                             <td><?= $sales['org_name']; ?></td>
                             <td><?= $sales['name']; ?></td>
                             <td><?= $sales['owner']; ?></td>
                             <td><?= IND_money_format((int)$sales['sub_total']); ?>&#8377;</td>
                             <!-- <td><?= number_format((int)$sales['profit_by_user']); ?>&#8377;</td> -->
                              <td><?= $Exp_Closing_Date; ?></td>
                              <td><?= $currentdate; ?></td>
                             
                               
                             
                             <td>
                                  <a style="text-decoration:none" class="text-success border-right">
                                      <i class="far fa-trash-alt text-danger m-1" onclick="delete_sub_opp_entry('<?=$sales['id'];?>')" data-toggle="tooltip" data-container="body" title="Delete Opportunity Details" ></i></a>
                                <a style="text-decoration:none" href="<?= base_url();?>add-opportunity?sub_opp=<?= $sales['id'];?>" class="text-info">
                                <i class="fas fa-shopping-basket sub-icn-po m-1" data-toggle="tooltip" data-container="body" title="Create Opportunity" ></i></a>
                             </td>
                          </tr>
                          <?php $amount += $sales['sub_total'];
                            //  $profit += $sales['profit_by_user'] ;  
                              } } ?>
        
                          <tr style="background:rgba(245,245,250,0.8); padding-top:20px;">
                             <td colspan="6" style="text-align:right;  padding-top:20px; padding-bottom:15px;color:green">Total : </td>
                             <td style=" padding-top:20px; padding-bottom:15px;"><?= IND_money_format((int)$amount); ?>&#8377;</td>
                             <!-- <td colspan="2"style=" padding-top:20px; padding-bottom:15px;"><?= IND_money_format((int)$profit); ?>&#8377;</td> -->
                             <td></td>
                          </tr>
                       </tbody>
                    </table>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-dismiss="modal" onclick="close_notify_sess();" style="background:rgba(35,0,140,0.8);">Close</button>
                 </div>
              </div>
           </div>
        </div>
        </div>
    <?php endif;?>
 
  
 <?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?> 


     
  <!-- jQuery + Bootstrap JS (include if not already included) -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- If using Bootstrap 4 -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
  <!-- JS to Auto Show Modal -->
<script>



$(document).ready(function () {
  $('#sub_opp_alert').modal({
    backdrop: 'static',
    keyboard: false
  }).modal('show');

  // Optional: disable the close button
  $('.modal .close').hide();
});

// Optional function if needed to handle close button manually
function close_notify_sess() {
  $('#sub_opp_alert').modal('hide');
}
</script>
  
   
  
<?php if(isset($_GET['oppid'])){
	$oppid=$_GET['oppid'];
	$ntid=$_GET['ntid'];
}else{
	$oppid='';
	$ntid='';
} ?>



<script>

 function delete_sub_opp_entry(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
        $.ajax({
          url : "<?= base_url('opportunities/sub_opp_delete')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
              //if success reload ajax table
            //   $('#add_popup').modal('hide');
              reload_table();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error deleting data');
          }
        });
      }
    }





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
		$("#stage_filter").hide();
	}else{
		$("#user_filter").show();
		$("#stage_filter").show();
	}
	$('#'+idhide).hide();
	$('#'+dispid).show();
}

 function load_country_data(page,dateFilter)
 { 
	var search		= $("#searchRecord").val();
	var startDate	= $('#startDate').val();
	var endDate  	= $('#endDate').val();
	var selectUser  = $('#selectUser').val();
	if(startDate!="" && startDate!==undefined && endDate!=""){
		var dateUrl='&startDate='+startDate+'&endDate='+endDate;
	}else{ var dateUrl=''; }
	if(selectUser!="" && selectUser!==undefined){
		var userUrl='&selectUser='+selectUser;
	}else{ var userUrl=''; }
	if(dateFilter===undefined){ dateFilter=''; }
	
  $.ajax({
   url:"<?php echo base_url(); ?>opportunities/pagination/"+page,
   method:"GET",
   data:"searchDate="+dateFilter+"&search="+search+dateUrl+userUrl,
   dataType:"json",
   success:function(data)
   {
	  // console.log(data);
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
		
		var startDate	= $('#startDate').val();
		var endDate  	= $('#endDate').val();
		var selectUser  = $('#selectUser').val();
		if(startDate!="" && startDate!==undefined && endDate!=""){
			var dateUrl='&startDate='+startDate+'&endDate='+endDate;
		}else{ var dateUrl=''; }
		if(selectUser!="" && selectUser!==undefined){
			var userUrl='&selectUser='+selectUser;
		}else{ var userUrl=''; }
		
		$.ajax({
			url : "<?= site_url('opportunities/gridview');?>",
			type: "POST",
			data: "leadid=123&searchDate="+dateFilter+"&search="+search+'&page='+page+dateUrl+userUrl,
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

<script type="text/javascript">
var save_method; //for save method string
var table;
  var colarr=[];
  var changed = [];
  var showcol = [];
  var saveChangesClicked;

$('#exampleModal').on('show.bs.modal', function () {
    saveChangesClicked = false;
    changed=[];
    $(".inputbox").each(function(){
         var index = $(".inputbox").index(this);
         if(this.checked){
          showcol.push(index);
         }
     
    });
   
 });
  


$('#exampleModal').on('hidden.bs.modal', function () {
 
    if (!saveChangesClicked) {
      changed.forEach(function (index) {
            if (!$(".inputbox").eq(index).prop('checked')) {
                $(".inputbox").eq(index).prop('checked', true);
            } else {
                $(".inputbox").eq(index).prop('checked', false);
            }
        });
        
        changed=[];
    }
  
});

////////////////////////////////////////////// it triggers automatically when page load (starts)///////////////////////////////////////////////////////////
    $(".inputbox").each(function(){

      var index = $(".inputbox").index(this);
      if(this.checked){
        
       colarr.push({'visible':true})
      }
      else{
        colarr.push({'visible':false})
      }
     
      $(this).change(function(){

           changed.push(index);
           var value  = parseInt(index);
      
           if(this.checked){
               showcol.push(value);
            }
            else{
                  showcol = showcol.filter(function(item){
                 return item != value;
                  });
            }
        })
    });
  ////////////////////////////////////////////// it triggers automatically when page load (starts)///////////////////////////////////////////////////////////

$(document).ready(function() {
  <?php if(check_permission_status('Opportunity','retrieve_u')==true):?>
    table = $('#ajax_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [], 
        "ajax": {
            "url": "<?= base_url('opportunities/ajax_list')?>",
            "type": "POST",
            "data" : function(data)
             {
                data.searchDate  = $('#date_filter').val();
                data.searchUser  = $('#user_filter').val();
                data.searchStage = $('#stage_filter').val();
             }
        },
        "columnDefs": [
        {
            "targets": [ 0 ], //last column
            "orderable": false, //set not orderable
        },
        ],
        "columns":colarr
    });
    $("#savecolvis").click(function () {
    var columnVisibility = [];
    saveChangesClicked = true;
    // Set visibility to false for columns in showcol array
    for (var i = 0; i < showcol.length; i++) {
        var columnIndex = showcol[i];
        if (columnIndex < table.columns().header().length) {
            columnVisibility.push(columnIndex);
        }
    }
    console.log(columnVisibility);
    // Set column visibility
    table.columns().visible(false);
    table.columns(columnVisibility).visible(true);

    // Redraw the table
    table.draw();
});
    $('#date_filter').change(function(){
        var search		= $("#searchRecord").val();
		var date_filter	= $("#date_filter").val();
		getDataGrid(date_filter,search,1);
		load_country_data(1,date_filter);
      table.ajax.reload();
    });
    $('#user_filter,#stage_filter').change(function(){
      table.ajax.reload();
    });
    
    

    
    
  });
  <?php endif; ?>
  
    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax
    }
 
  <?php if(check_permission_status('Opportunity','retrieve_u')==true):?>
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
      $("#view_add").find("tr").not(':first').remove();
      //Ajax Load data from ajax
      $.ajax({
          url : "<?php echo base_url('opportunities/getbyId/')?>" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            $('[id="name"]').text(data.name); 
            $('[id="owner"]').text(data.owner);
            $('[id="org_id"]').text(data.org_name);
            $('[id="id"]').text(data.id);
            $('[id="contact_name"]').text(data.contact_name);
            $('[id="expclose_date"]').text(data.expclose_date);
            $('[id="pipeline"]').text(data.pipeline);
            $('[id="stage_view"]').text(data.stage);
            $('[id="lead_source"]').text(data.lead_source);
            $('[id="type"]').text(data.type);
            $('[id="probability"]').text(data.probability);
            $('[id="industry"]').text(data.industry);
            $('[id="employees"]').text(data.employees);
            $('[id="weighted_revenue"]').text(data.weighted_revenue);
            $('[id="email"]').text(data.email);
            $('[id="mobile"]').text(data.mobile);
            $('[id="lost_reason"]').text(data.lost_reason);
            var product_name = data.product_name;
            var quantity = data.quantity;
            var unit_price = data.unit_price;
            var total = data.total;
            var p_name = product_name.split('<br>');
            var qty = quantity.split('<br>');
            var u_prc = unit_price.split('<br>');
            var ttl = total.split('<br>');
			var pro_description = data.pro_description;
            var description = pro_description.split('<br>');
            for (var i=0; i < p_name.length; i++)
            {
				if(description[i]===undefined || description[i]==""){
					var descriptionDisp='';
				}else{
					var descriptionDisp=description[i];
				}
              var markup = "<tr>"+
              "<td width='52%'><span class='text-secondary'>"+p_name[i]+"</span></td>"+
                "<td width='16%'><span class='text-secondary'>"+
                qty[i]+"</span></td>"+
                "<td width='16%'><span class='text-secondary'>"+numberToIndPrice(u_prc[i])+"</span></td>"+
                "<td width='16%'><span class='text-secondary'>"+numberToIndPrice(ttl[i])+"</span></td></tr><tr style='border-bottom: 1px solid #ece8e8;'><td colspan='5'><span class='text-secondary'>"+descriptionDisp+"</span></td></tr>";
              $("#view_add").append(markup);
            }
            $('[id="initial_total"]').text(numberToIndPrice(data.initial_total));
            $('[id="discount"]').text(data.discount);
            $('[id="sub_total"]').text(numberToIndPrice(data.sub_total));
            if(data.track_status == "opportunity")
            {
              $('#opportunity').addClass('selected');
              $('#quote').addClass('selected_red');
              $('#salesorder').addClass('selected_red');
              $('#purchaseorder').addClass('selected_red');
            }
            else if(data.track_status == "quote")
            {
              $('#opportunity').addClass('selected');
              $('#quote').addClass('selected');
              $('#salesorder').addClass('selected_red');
              $('#purchaseorder').addClass('selected_red');
            }
            else if(data.track_status == "salesorder")
            {
              $('#opportunity').addClass('selected');
              $('#quote').addClass('selected');
              $('#salesorder').addClass('selected');
              $('#purchaseorder').addClass('selected_red');
            }
            else if(data.track_status == "purchaseorder")
            {
              $('#opportunity').addClass('selected');
              $('#quote').addClass('selected');
              $('#salesorder').addClass('selected');
              $('#purchaseorder').addClass('selected');
            }
            else if(data.track_status == "")
            {
              $('#opportunity').addClass('selected');
              $('#quote').addClass('selected_red');
              $('#salesorder').addClass('selected_red');
              $('#purchaseorder').addClass('selected_red');
            }
            $('#view_popup').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Opportunity'); // Set title to Bootstrap modal title
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error Retrieving Data From Database');
          }
      });
    }
  <?php endif; ?>

  <?php 
  if(check_permission_status('Opportunity','delete_u')==true):?>
    function delete_entry(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
        $.ajax({
          url : "<?= base_url('opportunities/delete')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
              //if success reload ajax table
              $('#add_popup').modal('hide');
              reload_table();
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
$(document).ready(function(){
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
 <?php if(check_permission_status('Opportunity','delete_u')==true):?>
   $('#delete_all2').click(function(){
    var checkbox = $('.delete_checkbox:checked');
    if(checkbox.length > 0)
    {
        $("#delete_confirmation").modal('show');
    }
    else
    {
     alert('Select atleast one records');
    }
   });
 <?php endif; ?>
});

$("#confirmed").click(function(){
  deleteBulkItem('opportunities/delete_bulk'); 
});


function changeNotiStatus(){
	var noti_id="<?=$ntid;?>";
	url = "<?= site_url('notification/update_notification');?>";
	$.ajax({
		url : url,
		type: "POST",
		data: "noti_id="+noti_id+"&notifor=opportunity",
		success: function(data)
		{	
		}
	});
}
</script>


<?php
if(isset($_GET['oppid']) && $_GET['oppid']!=""){
?>

<script>
  view("<?=$_GET['oppid'];?>");
  var urlCur      = window.location.href;
  var  myArr = urlCur.split("?");
  var url = myArr[0];

  if (window.history.replaceState) {
    window.history.replaceState('', '', url);
  }
  changeNotiStatus();
</script>

<?php } ?>

<script>
$(document).ready(function() {
  $('#stage').change(function() {
    if( $(this).val() == "Closed Lost") {
          $('#lost_reason').prop( "disabled", false );
    } else {
      $('#lost_reason').prop( "disabled", true );
    }
  });
});

function getfilterdData(e,g){
  var id = "#" + g;
  $(id).val(e);
  table.ajax.reload();
}

function refreshPage(){
    window.location.reload();
} 
</script>




<!---------------------------- New Ajax Start ---------------------------->

<script>

 function checkCheckbox(){
  
  }

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
    'name','org_name', 'mobile', 'email','expclose_date', 'website','lead_source','pipeline','industry', 'stage','lost_reason',
    'lead_owner','secondary_email','reports_to','contact_name','employees','weighted_revenue','probability', 'office_phone', 'billing_country',
    'billing_state', 'billing_city', 'billing_zipcode', 'billing_address',
    'shipping_country', 'shipping_state', 'shipping_city', 'shipping_zipcode',
    'shipping_address'
  ];

  document.addEventListener('change', function (e) {
    if (e.target.matches('.type-select')) {
      
      
      const selectedType = e.target.value.trim().toLowerCase();

      const wrapper = e.target.closest('.form-row');
      const lengthWrapper = wrapper.querySelector('.length-wrapper');
      const dummytextWrapper = wrapper.querySelector('.dummytext');

      const input = wrapper.querySelector('.length-input');
      const lead_sourceSelect = wrapper.querySelector('.lead_source-select');
      const expclose_dateSelect = wrapper.querySelector('.expclose_date-select');
      const pipelineSelect = wrapper.querySelector('.pipeline-select');
      const industrySelect = wrapper.querySelector('.industry-select');

      const Select = wrapper.querySelector('.customertype-select');
      const stageSelect = wrapper.querySelector('.stage-select'); 
      const lost_reasonSelect = wrapper.querySelector('.lost_reason-select'); 



      if (typesRequiringLength.includes(selectedType)) {
        lengthWrapper.style.display = 'block';
        dummytextWrapper.style.display = 'none';

        // Hide all first
        input.style.display = 'none';
        lead_sourceSelect.style.display = 'none';
        expclose_dateSelect.style.display = 'none';
        pipelineSelect.style.display = 'none';
        industrySelect.style.display = 'none';

        stageSelect.style.display = 'none';
        lost_reasonSelect.style.display = 'none';

        // Show appropriate one 
        if (selectedType === 'expclose_date') {
          expclose_dateSelect.style.display = 'block';
        }else if (selectedType === 'lead_source') {
          lead_sourceSelect.style.display = 'block';
        }else if (selectedType === 'pipeline') {
          pipelineSelect.style.display = 'block';
        }else if (selectedType === 'industry') {
          industrySelect.style.display = 'block';
        }else if (selectedType === 'stage') {
          stageSelect.style.display = 'block';
        }else if (selectedType === 'lost_reason') {
          lost_reasonSelect.style.display = 'block';
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
    if (selectedType === 'expclose_date') {
      finalValue = $('#expclose_date_select').val();
    }else if (selectedType === 'lead_source') {
      finalValue = $('#lead_source_select').val();
    }else if (selectedType === 'pipeline') {
      finalValue = $('#pipeline_select').val();
    }else if (selectedType === 'industry') {
      finalValue = $('#industry_select').val();
    }else if (selectedType === 'stage') {
      finalValue = $('#stage_select').val();
    }else if (selectedType === 'lost_reason') {
      finalValue = $('#lost_reason_select').val();
    }else {
      finalValue = $('#value_input').val();
    }

    // Set hidden field
    $('#final_value_input').val(finalValue);

    // Submit via AJAX
    var formData = $('#massForm').serialize();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('opportunities/add_mass'); ?>",
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

