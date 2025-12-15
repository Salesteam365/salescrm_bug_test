<?php $this->load->view('common_navbar');?>
<style>
.lbla {
    text-decoration: none;
    margin: 1px 0px;
    border-radius: 5px;
    font-size: 12px;
    padding: 0px 6px;
    background: #1a6aae;
    color: #faf9f8 !important;
}
.quote_st_bn{
  border-radius:10px;
   font-size:13px;
   font-weight:700;
}
.quoteaccordion{
  margin:15px auto;
  border-radius:5px;
  background:rgba(197,180,227,0.1);
   border-top:none;
   border-left:5px solid purple;
}
.quoteacc_head{
  border-radius:10px;
  padding:7px;
  background:rgba(197,180,227,0.2);
  cursor:pointer;
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
   background:rgba(35, 0, 140, 0.8);
  

}
#ajax_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 14px;
   border-bottom:none;
   
  

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
.filterbox{
  display:flex;
  height:10vw;
  width:85vw;
  border-radius:15px;
  margin-left:20px;
  background:rgba(230,242,255,0.4);
}
.form-control{
  border:1px solid lightgrey;
  border-radius:2px;
  background-color:white;
}

.form-control:hover{
  border-color:purple;
  border-radius:0px;
  background-color:white;
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
                           <option value="org_name">Organization Name</option>
                           <option value="owner"> Owner </option>
                           <option value="opp_name">Opportunity Name </option>
                           <option value="subject"> Subject</option>
                           <option value="contact_name">Contact Name</option>
                           <option value="email">Email</option>

                           <option value="quote_stage">Quote Stage</option> 

                           <!-- <option value="lead_source">Lead Source</option>
                           <option value="pipeline"> Pipeline</option> 
                           <option value="industry">Industry Type</option>
                           <option value="lost_reason">Lost Reason</option>  -->

                          
                           <option value="currentdate">Quote Creation Date </option>
                           <option value="valid_until">Valid Until Date </option>
                        
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
                        <input type="date" class="form-control valid_until-select" id="valid_until_select" placeholder="Quote Creation Date" style="display: none;">
                        <input type="date" class="form-control currentdate-select" id="crrentdate_select" placeholder="Valid Until Date" style="display: none;">

                       

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
                        <select class="form-control quote_stage-select" id="quote_stage_select" style="display: none;">
                           <option value="">Select Quote Stage</option>
                           <option value="Draft">Draft</option>
                           <option value="Negotiation">Negotiation</option>
                           <option value="Delivered">Delivered</option>
                           <option value="On Hold">On Hold</option>
                           <option value="Confirmed">Confirmed</option>
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
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);overflow-x:clip;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Quotation</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Quotation</li>
            </ol>
          </div><!-- /.col -->
        </div>
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
        <!-- /.row -->
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

          <div class="col-lg-2">
                  <div class="first-one custom-dropdown dropdown">
            <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Select Option
            </button> 
              <input  type="hidden" id="stage_filter" name="stage_filter">
              <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <!-- <select class="custom-select" name="user_filter" id="user_filter"> -->
                          <li onclick="getfilterdData('Draft','stage_filter');">Draft</li>
                          <li onclick="getfilterdData('Negotiation','stage_filter');">Negotiation</li>
                          <li onclick="getfilterdData('Delivered','stage_filter');">Deliveredt</li>
                          <li onclick="getfilterdData('On Hold','stage_filter');">On Hold</li>
                          <li onclick="getfilterdData('Confirmed','stage_filter');">Confirmed</li>
                          <li onclick="getfilterdData('Closed Won','stage_filter');">Closed Won</li>
                          <li onclick="getfilterdData('Closed Lost','stage_filter');">Closed Lost</li>
                          
                        
                        
                    </ul>
                    </div>
		      </div>

          <div class ="col-lg-2">
               <div class="first-one custom-dropdown dropdown">
             <a id="mass_model" href="#" style="text-decoration:none;">
                  <button type="button" id="mass_product" class="btn" style="display:none; border-radius: 2rem; margin-bottom: 1rem; background: #845ADF; color:#fff; font-weight: 500;">
                    Mass Update
                  </button>
              </a>
            </div>
          </div>
		
            <div class="col-lg-4">
                <div class="refresh_button float-right">
                    <button class="btnstopcorner" onclick="listgrdvw('listview','gridview')"><i class="fas fa-list-ul"></i></button>
				<button class="btnstopcorner" onclick="listgrdvw('gridview','listview','grid')"><i class="fas fa-th"></i></button>
                    <button class="btnstopcorner" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
					<?php if($this->session->userdata('type')=='admin'){ ?>
					<a href='Export_data/export_quotation' class="p-2" ><button class="btncorner">Export Data</button></a>
					<?php } ?>
					<?php if(check_permission_status('Quotations','create_u')==true){
						 if($this->session->userdata('account_type')=="Trial" && $countQuote>=500){
					?> 
					<button class="btnstop" onclick="infoModal('You are exceeded  your quotation limit - 500')"  >Add New</button>
					<?php }else{ ?>
					<!-- <button class="btn btn-info" >Add New</button> -->
      
  <a class="btnstop dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid #ccc; 
    border-radius: 4px;
    background: #845ADF;
    color: #fff;
    font-weight:600;">
   Add New
  </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="<?php echo base_url('add-quote');?>">Add New Quotation</a></div>
    <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="#">Create New Performa Invoice</a></div>
    <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="<?php echo base_url('invoices/new-invoice'); ?>">Create New Invoice</a></div>
  </div>

					<?php } } ?>
                </div>
            </div>
          </div>
          </div>
      </div><!-- /.container-fluid -->
    </div>
    <div class="card mx-md-5 mt-2 mb-0 px-5 py-4" style="border-radius:12px;">
         <div class="accordion mx-3" id="faq" >
            <div class="quoteaccordion">
               <div class="quoteacc_head" id="faqhead1" data-toggle="collapse" data-target="#faq1" aria-expanded="false" aria-controls="faq1"> <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> Quotation Summary</a>
               </div>
               <div id="faq1" class="collapse" aria-labelledby="faqhead1" data-parent="#faq">
                  <div class="card-body accbody">
                     Total Quotations : <?= $countQuote; ?>
                  </div>
               </div>
            </div>
            <div class="quoteaccordion">
               <div class="quoteacc_head" id="faqhead2" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq2"> <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> Quotation Graph</a>
               </div>
               <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                  <div class="card-body accbody">
                        <div id="chart-line">
                        </div>
                  </div>
               </div>
          </div>
          </div>
          </div>
          
    <!-- /.content-header -->
      <!-- Main content -->
      
      <section class="content">
        <div class="container-fluid">
          <!-- Main row -->
           <!-- Map card -->
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
                <!-- /.card-header -->
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
                                  <td>Subject</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Organization Name</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked  ></td>
                                </tr>
                                <tr>
                                <td>Quote ID</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Owner</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Added Date</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Quote Stage</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Quoted Amount</td>
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
            <div class="card-header mb-2"><b style="font-size:21px;">Quotation</b> <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button></div>
            <div class="card-body">
                
                  <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                <!-- modelstart     -->
      
           <!-- model end -->
                    <thead>
                      <tr>
                        <?php if(check_permission_status('Quotations','delete_u')==true):?>
                          <th style="width:4%;" ><button class="btn" type="button" name="delete_all" id="delete_all2"><i class="fa fa-trash text-light"></i></button></th>
                        <?php endif; ?>
                        
                        <th class="th-sm" style="width: 275px;">Organization Name</th>
                        <th class="th-sm" style="width:20%;" >Subject</th>
                        
                        <th class="th-sm">Quote ID</th>
                        <th class="th-sm">Owner</th>
                        <th class="th-sm">Added Date</th>
                        <th class="th-sm">Quote Stage</th>
                        <th class="th-sm">Quoted Amount</th>
                        <th class="th-sm">Action</th>
                      </tr>
                    </thead>
                    <tbody>                                     
                    </tbody>
                  </table>
                
                </div>
            </div>
                <!-- GRID VIEW -->
            <div class="card-body" id="gridview" style="display:none;" >
        <input type="text" class="form-control" id="searchRecord" name="searchRecord" style="margin-bottom: 13px; width: 33%;" placeholder="Search Data">
        <div class="row" style="width: 100%;">
          <?php 
            $leadStatus=array('Negotiation','On Hold','Draft','Confirmed','Closed Lost','Closed Won','Delivered');
           for($i=0; $i<count($leadStatus); $i++){ 
            $ind=str_replace(' ','',$leadStatus[$i]);
            $ind=str_replace('-','',$ind);
           ?>
             <div class="hdr">
              <span><?=$leadStatus[$i];?></span>
              <br>
              <input type="hidden" id="<?=$ind;?>" value="<?php if($price[$ind]['initial_total']){ echo $price[$ind]['initial_total']; }else{ echo "0"; }?>">
              <span>₹<text id="txt<?=$ind;?>" data-min='<?php if($price[$ind]['initial_total']){ echo $price[$ind]['initial_total']; }else{ echo "0"; }?>'  data-delay='3' data-increment="99" ><?=IND_money_format($price[$ind]['initial_total']);?></text></span>
             </div>
          <?php  } ?>
        </div>
        <div class="row" style="width: 100%;" id="putLeadData"></div>
        <div   id="pagination_link"></div>
      </div> 
        </div>
      </section>
  </div>

 <?php $this->load->view('footer');?>
 
<!-- ./wrapper -->
<?php $this->load->view('common_footer');?>
<?php if(isset($_GET['qtid'])){
  $qtid=$_GET['qtid'];
  $ntid=$_GET['ntid'];
}else{
  $qtid='';
  $ntid='';
} ?>

<script>
 
 document.addEventListener('click', function(event) {
    if (event.target.classList.contains('copyquote')) {
        var siblingInput = event.target.nextElementSibling;
        copyy(); // Adjust this based on your HTML structure
    }
    else if(event.target.parentElement.classList.contains('copyquote')){
      var siblingInput = event.target.parentElement.nextElementSibling;
      copyy();
    }
        // Select and copy the text
        function copyy(){
        siblingInput.select();
        siblingInput.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(siblingInput.value);

        // Show notification
        var notyInstance = new Noty({
            type: 'success',
            layout: 'topRight',
            theme: 'semanticui',
            text: 'Link Copied',
            timeout: 400 
        });

        notyInstance.show();
      }
    
   
});

 
 

  

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
   
  var search    = $("#searchRecord").val();
  if(dateFilter===undefined){
    dateFilter='';
  }
  $.ajax({
   url:"<?php echo base_url(); ?>quotation/pagination/"+page,
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
    var dateFilter  = $("#date_filter").val();
    load_country_data(page,dateFilter);
    getDataGrid(dateFilter,'',page);
 });


    //addElements();
  getDataGrid('','',1);
  function getDataGrid(dateFilter='',search='',page=''){
    $.ajax({
      url : "<?= site_url('quotation/gridview');?>",
      type: "POST",
      data: "leadid=123&searchDate="+dateFilter+"&search="+search+'&page='+page,
      success: function(data){
        $("#putLeadData").html(data);
      }
    });
  }
  
  $("#searchRecord").keyup(function(){
    var search    = $(this).val();
    var date_filter = $("#date_filter").val();
    getDataGrid(date_filter,search,1);
    load_country_data(1);
  });

  

</script>

<script type="text/javascript">
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
  
  <?php if(check_permission_status('Quotations','retrieve_u')==true):?>
    //datatables
  
 // ...
 table = $('#ajax_datatable').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
        "url": "<?php echo site_url('quotation/ajax_list')?>",
        "type": "POST",
        "data": function (data) {
            data.searchDate = $('#date_filter').val();
            data.searchUser = $('#user_filter').val();
            data.searchStage = $('#stage_filter').val();
        }
    },
    "createdRow": function (row, data, dataIndex) {
        if (data[3] == "<?=$qtid;?>") {
            $(row).css('background-color', 'rgb(84 81 81 / 44%)');
            changeNotiStatus();
        }
    },
    "columnDefs": [
        {
            "targets": [0], // Last column
            "orderable": false, // Set not orderable
        },
    ],
    "columns": colarr
    
});
   function disableClick(e) {
        e.stopPropagation();
        e.preventDefault();
    }

    // Attach the click event handler to the element with ID 'ajax_datatable_filter'
    $('#ajax_datatable_filter').on('click', disableClick);

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
        var search    = $("#searchRecord").val();
      var date_filter = $("#date_filter").val();
      getDataGrid(date_filter,search,1);
      load_country_data(1,date_filter);
      table.ajax.reload();
    });
  
  $('#user_filter,#stage_filter').change(function(){
      table.ajax.reload();
    });
    //datepicker
    
    
   function changeNotiStatus(){
  var noti_id="<?=$ntid;?>";
  url = "<?= site_url('notification/update_notification');?>";
  $.ajax({
    url : url,
    type: "POST",
    data: "noti_id="+noti_id+"&notifor=quotation",
    success: function(data)
    {
    
    }
  });
} 
    
    
  <?php endif; ?>
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }
  

  <?php if(check_permission_status('Quotations','delete_u')==true):?>
    function delete_entry(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
        $.ajax({
            url : "<?= site_url('quotation/delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
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
});


$("#confirmed").click(function(){
  deleteBulkItem('quotation/delete_bulk'); 
});

 function refreshPage()
  {
    window.location.reload();
  }
</script>

<script>
 
      ////////////////////////////////////// fetch the data of month wise quotation amount for quotation graph/////////////////////////////////////
 $.ajax({
  url:'<?php echo site_url('quotation/getquotationgraph')?>',
              method:'post',
              success:function(response){
              if (response.status === 'success') {
              
var Quotaion_amount = [];
var xAxisCategories=[];
for (var i = 0; i < response.data.length; i++) {
  Quotaion_amount.push(parseFloat(response.data[i].subtotal)); 
    xAxisCategories.push(response.data[i].month + "/" + response.data[i].year);
}


var options = {
    series: [
        { name: 'Quoted Amount of month', data: Quotaion_amount },
    ],
    chart: {
        height: 250,
        type: 'area'
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth',
        width: 1
    },
    xaxis: {
        categories: xAxisCategories,
        tickAmount: Math.ceil(xAxisCategories.length / 3),
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
                return '₹ '+new Intl.NumberFormat('en-IN').format(value);
            }
        }
    },
    // colors: ['#6a0dad']
};
        var chart = new ApexCharts(document.querySelector("#chart-line"), options);
        chart.render();

              }
             }
    });

    function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

table.ajax.reload();
}

      
</script>




<!---------------------------- New Ajax Start ---------------------------->

<script>
function showAction(id) {
  //  alert('test');
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
    'name','org_name', 'subject','opp_name','quote_stage',
    'owner','contact_name','email','currentdate','valid_until', 'billing_country',
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
      const valid_untilSelect = wrapper.querySelector('.valid_until-select');
      const currentdateSelect = wrapper.querySelector('.currentdate-select');
      const quote_stageSelect = wrapper.querySelector('.quote_stage-select');
      



      if (typesRequiringLength.includes(selectedType)) {
        lengthWrapper.style.display = 'block';
        dummytextWrapper.style.display = 'none';

        // Hide all first
        input.style.display = 'none';
        valid_untilSelect.style.display = 'none';
        currentdateSelect.style.display = 'none';
        quote_stageSelect.style.display = 'none';


        // Show appropriate one
        if (selectedType === 'valid_until') {
          valid_untilSelect.style.display = 'block';
        } else if (selectedType === 'currentdate') {
          currentdateSelect.style.display = 'block';
        }else if (selectedType === 'quote_stage') {
          quote_stageSelect.style.display = 'block';
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
    if (selectedType === 'valid_until') {
      finalValue = $('#valid_until_select').val();
    }else if (selectedType === 'quote_stage') {
      finalValue = $('#quote_stage_select').val();
    }else if (selectedType === 'currentdate') {
      finalValue = $('#currentdate_select').val();
    }else {
      finalValue = $('#value_input').val();
    }

    // Set hidden field
    $('#final_value_input').val(finalValue);

    // Submit via AJAX
    var formData = $('#massForm').serialize();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('quotation/add_mass'); ?>",
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

