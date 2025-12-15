<?php $this->load->view('common_navbar');?>
<script src="https://kit.fontawesome.com/db85a9eb98.js" crossorigin="anonymous"></script>
<style>

/*pop up open in salesorder*/
@media (max-width: 768px) {
    .modal-dialog {
        width: 100%;
        margin: 10px;
    }
 
    .modal-xl {
        max-width: 100%;
    }
 
    .table-responsive {
        overflow-x: auto;
    }
 
    .modal-body {
        padding: 10px;
    }
 
    th, td {
        font-size: 12px;
    }
}
 
@media (min-width: 768px) and (max-width: 1200px) {
    th, td {
        font-size: 14px;
    }
}
 
/* Media query for MacBook Air 1559px width and 975px height */
@media screen and (min-width: 1559px) and (max-width: 1559px) and (min-height: 975px) and (max-height: 975px) {
    .modal-content {
        width: 72% !important; /* Adjust modal width */
        margin: 20px auto !important; /* Center the modal */
    }
 
}
/* === Small Devices: Up to 500px === */
@media (max-width: 500px) {
    .modal-dialog {
        margin: auto;
    }
    .modal-dialog .modal-content .modal-body table thead tr th,
    .modal-dialog .modal-content .modal-body table tbody tr td {
        font-weight: 400;
        vertical-align: middle;
        padding: 5px;
        font-size: 0.4rem;
    }
}

/* === Medium Devices: 1000px to 1400px === */
@media (min-width: 1000px) and (max-width: 1400px) {
    .modal-content {
        width: 70% !important;
        margin: 20px auto !important;
    }
    
    .modal-dialog .modal-content .modal-body table thead tr th, 
    .modal-dialog .modal-content .modal-body table tbody tr td {
        font-weight: 400;
        vertical-align: middle;
        padding: 5px;
        font-size: 0.8rem;
    }
}


/*end pop salesorder*/
   .statusso{
   height: 55px;
   cursor:pointer;
   }

   .quoteaccordion{
  margin:4px auto;
  border-radius:5px;
  background:rgba(197,180,227,0.1);
   border-top:none;
   border-left:5px solid purple;
   
   

}

.quoteacc_head{
  border-radius:5px;
  padding:2px;
  background:rgba(197,180,227,0.2);
  cursor:pointer;
 
  
}
.quoteaccordion1 {
        margin-bottom: 20px; /* Adjust the margin as needed */
    }
    .quoteaccordion {
         /* Adjust the margin as needed */
    }
    .quoteacc_head {
        padding: 15px; /* Adjust the padding as needed */
    }
    .quotaccbody {
        padding: 15px; /* Adjust the padding as needed */
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
   font-size: 14px;
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
.btn_inprog_st{
   color:#845ADF;
   background:#845ADF1A;
   border-radius:10px;
   font-size:13px;
   font-weight:700;
   /* border:1px solid rgba(100,0,130,0.2) */
}
.btn_invoicepending_st{
   COLOR:#E6533C;
   background:#E6533C1A;
   border-radius:10px;
   font-size:13px;
   font-weight:700;
   /* border:1px solid rgba(100,160,130,0.2) */
}
.btn_pending_st{
   COLOR:#F5B849;
   background:#F5B8491A;
   border-radius:10px;
   font-size:13px;
   font-weight:700;
   /* border:1px solid rgba(200,160,0,0.2) */
}


    .topstatuscards {
        position: relative;
        margin:5px;
    }

    .topstatuscards:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 35%;
        background-color: rgba(250, 200, 250, 0.2); /* You can adjust the color and opacity */
        border-top-right-radius: 5px; /* Adjust the border radius if needed */
        border-bottom-right-radius: 5px;
    }

    .card-title,
    .card-text {
        z-index: 1;
    }

    .card1{
      border-radius:12px;
      border-left:5px solid #eeda24;
    }
    .card2{
      border-radius:12px;
      border-left:5px solid #125baa;
    }
    .card3{
      border-radius:12px;
      border-left: 5px solid #ffb6c1  ;
    }
    .card4{
      border-radius:12px;
      border-left:5px solid #82d324;
    }

    .topstatusicon {
        position: absolute;
       
        right: 10%; /* Adjust the right offset */
        /* transform: translateY(-50%); */
        z-index: 2;
    }
    div.refresh_button button.btnstopcorner {
    
    border-radius: 4px;
    background: #f2f3f4;
    color: #ccc;
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

   .firstDiv:hover{
   transform: translateY(-9px);
   /*-webkit-transition: all 0.6s;
   -moz-transition: all 0.6s;*/
   border-bottom: 9px solid #eeda24;
   }
   .secondDiv:hover{
   transform: translateY(-9px);
   border-bottom: 9px solid #125baa;
   }
   .thirdDiv:hover{
   transform: translateY(-9px);
   border-bottom: 9px solid #828587;
   }
   .fourthDiv:hover{
   transform: translateY(-9px);
   border-bottom: 9px solid #82d324;
   }
   .activediv{
   transform: translateY(-9px);
   border-bottom: 9px solid #82d324;
   }

   .filterbox{
  display:flex;
  height:10vw;
  width:85vw;
  border-radius:15px;
  margin-left:20px;`
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

  @media (max-width:1400px) {
      #ajax_datatable tbody tr td {
        font-size:11px;
      }
    }
    
</style>


      <!--All Data Filter Modal -->
                    
                   <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="     true" data-keyboard="false" data-backdrop="static">
                      <div class="modal-dialog modal-dialog-scrollable" id="filterMdl" role="document" style="position: fixed; right: 0px; margin: auto; width: 20%;">
                     
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Filter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                     
                          <div class="modal-body">
                            <form method="post">

                              <!-- Start Pending -->
                              <div class="col-lg-12 mb-2">
                                 <div class="col-md-12 mb-5 statusso" data-status="100" data-color="eeda24">
                                    <div class="card card1">
                                        <div class="card-body topstatuscards d-flex justify-content-between align-items-center">
                                            <div class="">
                                                <h5 class="card-title">Pending</h5>
                                                <p class="card-text"><b>₹</b> : <span id="dendingData">0.00</span></p>
                                            </div>
                                            <i class="fas topstatusicon fa-clock fa-beat fa-2x" style="color: #eeda24; background-color: rgba(238, 218, 36, 0.2); padding: 10px; border-radius: 50%;"></i>
                                        </div>
                                    </div>
                                </div>

                              </div>
                    
                              <!-- Start In Progress -->
                              <div class="col-lg-12 mb-2">
                                 <div class="col-md-12 statusso mb-5" data-status="50" data-color="125baa">
                                    <div class="card card2">
                                        <div class="card-body topstatuscards d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="card-title">In Progress</h5>
                                                <p class="card-text"><b>₹</b> : <span id="inProgressData">0.00</span></p>
                                            </div>
                                            <i class="fas topstatusicon fa-spinner fa-flip fa-2x" style="color: #125baa; background-color: rgba(18, 91, 170, 0.2); padding: 10px; border-radius: 50%;"></i>
                                        </div>
                                    </div>
                                </div>
                              </div>
                     
                              <!-- Start Invoice Pending -->
                              <div class="col-lg-12 mb-2">
                                 <div class="col-md-12 mb-5 statusso" data-status="invoice" data-color="828587">
                                      <div class="card card3">
                                          <div class="card-body topstatuscards d-flex justify-content-between align-items-center">
                                              <div>
                                                  <h5 class="card-title">Invoice Pending</h5>
                                                  <p class="card-text"><b>₹</b> : <span id="invoicePendData">0.00</span></p>
                                              </div>
                                              <i class=""></i>
                                              <i class="fa-solid fa-receipt  fa-flip topstatusicon fa-2x" style="color: pink; background-color:rgba(255,192,203,0.4); padding: 10px; width:52px; border-radius: 50%;"></i>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                     
                              <!-- Start Complete -->
                              <div class="col-lg-12 mb-2">
                                    <div class="col-md-12  mb-5 statusso" data-status="complete" data-color="82d324">
                                      <div class="card card4">
                                          <div class="card-body topstatuscards d-flex justify-content-between align-items-center">
                                              <div>
                                                  <h5 class="card-title">Complete</h5>
                                                  <p class="card-text"><b>₹</b> : <span id="completeData">0.00</span></p>
                                              </div>
                                            
                                              <i class="fas topstatusicon fa-check-circle fa-beat fa-2x" style="color: #82d324; background-color: rgba(130, 211, 36, 0.2); padding: 10px; border-radius: 50%;"></i>
                                          </div>
                                      </div>
                                    </div>
                              </div>
                     
                              <!-- Sales ID Selection -->
                              <div class="col-lg-12 mb-2">
                                  <!-- <label for="po_filterAll" style="font-size: 0.85rem;"> Day / Date : </label> -->
                                  <div class="first-one custom-dropdown dropdown">
                                          <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Select Day / Date
                                          </button>
                                        
                                          
                                          <input type="hidden" id="date_filter" value="" name="date_filter">
                                                          <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                              <li data-value="This Week">This Week</li>
                                                              <?php $week = strtotime("-7 Day"); ?>
                                                              <li data-value="<?= date('y.m.d', $week); ?>" onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','getsovalue', 'date_filter', 'dummyParam'); setSelectedFilter('Last Week');">Last Week</li>
                                                              <?php $fifteen = strtotime("-15 Day"); ?>
                                                              <li data-value="<?= date('y.m.d', $fifteen); ?>" onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','getsovalue','date_filter', 'dummyParam'); setSelectedFilter('Last 15 days');">Last 15 days</li>
                                                              <?php $thirty = strtotime("-30 Day"); ?>
                                                              <li data-value="<?= date('y.m.d', $thirty); ?>" onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','getsovalue','date_filter', 'dummyParam'); setSelectedFilter('Last 30 days');">Last 30 days</li>
                                                              <?php $fortyfive = strtotime("-45 Day"); ?>
                                                              <li data-value="<?= date('y.m.d', $fortyfive); ?>" onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','getsovalue', 'date_filter', 'dummyParam'); setSelectedFilter('Last 45 days');">Last 45 days</li>
                                                              <?php $sixty = strtotime("-60 Day"); ?>
                                                              <li data-value="<?= date('y.m.d', $sixty); ?>" onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','getsovalue', 'date_filter', 'dummyParam'); setSelectedFilter('Last 60 days');">Last 60 days</li>
                                                              <?php $ninty = strtotime("-90 Day"); ?>
                                                              <li data-value="<?= date('y.m.d', $ninty); ?>" onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','getsovalue','date_filter', 'dummyParam'); setSelectedFilter('Last 3 Months');">Last 3 Months</li>
                                                              <?php $six_month = strtotime("-180 Day"); ?>
                                                              <li data-value="<?= date('y.m.d', $six_month); ?>" onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','getsovalue', 'date_filter', 'dummyParam'); setSelectedFilter('Last 6 Months');">Last 6 Months</li>
                                                              <?php $one_year = strtotime("-365 Day"); ?>
                                                              <li data-value="<?= date('y.m.d', $one_year); ?>" onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','getsovalue', 'date_filter', 'dummyParam'); setSelectedFilter('Last 1 Year');">Last 1 Year</li>
                                                        
                                                              <li class="dropdown-item" id="addnewdeliverychallan">
                                                                  <a style="color:#212529; padding-left:0px; font:14px ui-sans-serif, system-ui;" href="javascript:void(0);">Custom By Date</a>
                                                              </li>
                                                          </ul>
                                  </div>
                              </div>
                     
                              <!------ Start User------- -->
                              <div class="col-lg-12 mb-2">
                                <!-- <label for="po_filterAll" style="font-size: 0.85rem;"> User : </label> -->
                                
                                  <?php if($this->session->userdata('type')==='admin'): ?>
                                    <div class="first-one custom-dropdown dropdown">
                                        <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Select User
                                        </button>
                                        
                                        <input type="hidden" id="user_filter" value="" name="user_filter">
                                                          <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonn">
                                                            
                                                              <?php foreach($admin as $adminDtl): ?>
                                                              <li data-value="<?= $adminDtl['admin_email']; ?>" onclick="getfilterdData('<?= $adminDtl['admin_email']; ?>','getsovalue','user_filter','dummyParam'); setSelectedUser('<?= $adminDtl['admin_name']; ?>');"><?= $adminDtl['admin_name']; ?></li>
                                                              <?php endforeach; ?>
        
                                                              <?php foreach($user as $userDtl): ?>
                                                              <li data-value="<?= $userDtl['standard_email']; ?>" onclick="getfilterdData('<?= $userDtl['standard_email']; ?>','getsovalue','user_filter','dummyParam'); setSelectedUser('<?= $userDtl['standard_name']; ?>');"><?= $userDtl['standard_name']; ?></li>
                                                              <?php endforeach; ?>
                                                          </ul>
                                                          
                                    </div>
                                  <?php endif; ?>
                            
                              </div>

                               <!--- Start New and Renewel -->
                              <div class="col-lg-12 mb-2">
                                <!-- <label for="new_Renew" style="font-size: 0.85rem;">Order Type : </label> -->
                                    <div class="first-one custom-dropdown dropdown">
                                        <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonNew" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:0.9rem;">
                                          Select New/Renew
                                        </button>
                                        <input type="hidden" id="new_filter" value="" name="new_filter">
                                            <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonNew">
                                                    <!-- <li data-value="custom"> Custom </li> -->
                                                    <?php $new = "new"; ?>
                                                    <li data-value="<?= $new; ?>" onclick="getfilterdData('<?= $new; ?>','getsovalue', 'new_filter', 'dummyParam'); setSelectedNew('New');"> New</li>
                                                    <?php $renew = "renew"; ?>
                                                    <li data-value="<?= $renew; ?>" onclick="getfilterdData('<?= $renew; ?>','getsovalue','new_filter', 'dummyParam'); setSelectedNew(' Renew');">Renew</li>
                                          </ul>
                                    </div>
                                
                              </div>
                     
                              <!-- Start Customer Name -->
                              <div class="col-lg-12 mb-2">
                                <!-- <label for="po_date" style="font-size: 0.85rem;"> Customer : </label> -->
                                    <div id="external_search" class="dataTables_filter">
                                        <label>
                                            <input type="search" style="height: 2.4rem; border: 1px solid #f2f3f4;" name ="customerName" id ="customerName" 
                                                  class="form-control form-control-sm" placeholder="Customer Name"
                                                  aria-controls="ajax_datatable">
                                        </label>
                                    </div>
                                
                              </div>


                              <!---- Start Customer Po---->
                              <div class="col-lg-12 mb-2">
                                <div class="first-one custom-dropdown dropdown">
                                <input type="hidden" id="cust_filter" value="" name="cust_filter">
                                    <input type="text" name="po_filter" id="po_filter" onkeyup="applyDateFilter()" class="form-control" placeholder="Customer PO. Number" aria-label="Start Date" aria-describedby="basic-addon1" style="height: 2.4rem; border: 1px solid #f2f3f4;">
                                  
                                </div>
                              </div>
                     
                             
                     
                            </form>
                          </div>
                     
                          <div class="modal-footer">

                            <button type="button" class="btn btn-primary btn-sm" onclick="refreshPage()" style="font-size: 0.85rem;">Filter Clear</button>
                            <button type="button" class="btn btn-primary btn-sm" id="" style="font-size: 0.85rem;">Apply Filter test</button> 

                            <a href="#" data-dismiss="modal" style="font-size: 0.85rem;">Cancel</a>
                          </div>
                     
                        </div>
                      </div>
                    </div>
 
                    <!-- All Data Filter Model -->  

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
                            <option value="subject"> Subject </option>
                            <option value="owner"> Owner </option>
                            <option value="opp_name">Opportunity Name </option>
                          
                            <option value="customer_mobile">Customer Mobile</option>
                            <option value="customer_email"> Customer Email</option>
                            <option value="contact_name">Contact Name</option>

                            <option value="due_date">Due Date </option>
                            <option value="currentdate"> Sales Order Date </option>
                            <option value="po_date">Po Date </option>

                            <option value="renewal_date"> Renewal Date With Calendar </option>

                            <option value="excise_duty">Excise Duty</option>

                            <option value="po_no">Po Number </option>
                            <option value="pending">Pending </option>
                            <option value="sales_commission">Sales Commission </option>
                            <option value="payment_terms"> Payment Terms (in days) </option>
                            <option value="carrier"> Courier </option>
                      
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
                          <input type="date" class="form-control po_date-select" id="po_date_select" placeholder="select date" style="display: none;"> 
                          <input type="date" class="form-control renewal_date-select" id="renewal_date_select" placeholder="select date" style="display: none;"> 
                          <input type="date" class="form-control due_date-select" id="due_date_select" placeholder="select date" style="display: none;">
                          <input type="date" class="form-control currentdate-select" id="currentdate_select" placeholder="select date" style="display: none;">

                        

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


                                            
                          <!-- Opp Carrier Type -->
                          <select class="form-control carrier-select" id="carrier_select" style="display: none;">
                            <option value="">Select Courier</option>
                            <option value="FedEx">FedEx</option>
                            <option value="UPS">UPS</option>
                            <option value="USPS">USPS</option>
                            <option value="DHL">DHL </option>
                            <option value="BlueDart">BlueDart</option>
                            <option value="NA"> other </option>
                          </select>


                          <!-- payment_terms  --> 
                          <select class="form-control payment_terms-select" id="payment_terms_select" style="display: none;">
                            <option value=""> Payment Terms</option>

                            <?php for($i=1; $i<=30; $i++){ ?>
                              <option value="<?=$i;?>" <?php if($dataPy==$i){ echo "selected"; } ?> ><?=$i;?></option>
                            <?php } ?>
                              <option value="After Delivery"> After Delivery </option>
                              <option value="Against Advance">Against Advance</option>
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
               <h1 class="m-0 text-dark">SalesOrder</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                  <li class="breadcrumb-item active">SalesOrder</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
          <!-- <div class="container-fliud" class="filterbtncon"  style="border-radius:12px; background:#fff; padding-top:22px; padding-right:12px; padding-left:24px; margin:12px; margin-right:32px;"> -->
            
              <!-- <form id="filterForm" onsubmit="return filter_Export();"> -->

                <!-- <div class="row mb-3">
                    <div class="col-lg-2">
                        <div class="first-one custom-dropdown dropdown">
                            <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Filter by days
                            </button>
                          
                            
                            <input type="hidden" id="date_filter" value="" name="date_filter">
                                                <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li data-value="This Week">This Week</li>
                                                    <?php $week = strtotime("-7 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $week); ?>" onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','getsovalue', 'date_filter', 'dummyParam'); setSelectedFilter('Last Week');">Last Week</li>
                                                    <?php $fifteen = strtotime("-15 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $fifteen); ?>" onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','getsovalue','date_filter', 'dummyParam'); setSelectedFilter('Last 15 days');">Last 15 days</li>
                                                    <?php $thirty = strtotime("-30 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $thirty); ?>" onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','getsovalue','date_filter', 'dummyParam'); setSelectedFilter('Last 30 days');">Last 30 days</li>
                                                    <?php $fortyfive = strtotime("-45 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $fortyfive); ?>" onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','getsovalue', 'date_filter', 'dummyParam'); setSelectedFilter('Last 45 days');">Last 45 days</li>
                                                    <?php $sixty = strtotime("-60 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $sixty); ?>" onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','getsovalue', 'date_filter', 'dummyParam'); setSelectedFilter('Last 60 days');">Last 60 days</li>
                                                    <?php $ninty = strtotime("-90 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $ninty); ?>" onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','getsovalue','date_filter', 'dummyParam'); setSelectedFilter('Last 3 Months');">Last 3 Months</li>
                                                    <?php $six_month = strtotime("-180 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $six_month); ?>" onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','getsovalue', 'date_filter', 'dummyParam'); setSelectedFilter('Last 6 Months');">Last 6 Months</li>
                                                    <?php $one_year = strtotime("-365 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $one_year); ?>" onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','getsovalue', 'date_filter', 'dummyParam'); setSelectedFilter('Last 1 Year');">Last 1 Year</li>
                                              
                                                    <li class="dropdown-item" id="addnewdeliverychallan">
                                                        <a style="color:#212529; padding-left:0px; font:14px ui-sans-serif, system-ui;" href="javascript:void(0);">Custom By Date</a>
                                                    </li>
                                                </ul>
                        </div>
                    </div>
               
                            <div class="col-lg-2">
                                <?php if($this->session->userdata('type')==='admin'): ?>
                                <div class="first-one custom-dropdown dropdown">
                                    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Select User
                                    </button>
                                    
                                    <input type="hidden" id="user_filter" value="" name="user_filter">
                                                      <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonn">
                                                        
                                                          <?php foreach($admin as $adminDtl): ?>
                                                          <li data-value="<?= $adminDtl['admin_email']; ?>" onclick="getfilterdData('<?= $adminDtl['admin_email']; ?>','getsovalue','user_filter','dummyParam'); setSelectedUser('<?= $adminDtl['admin_name']; ?>');"><?= $adminDtl['admin_name']; ?></li>
                                                          <?php endforeach; ?>
    
                                                          <?php foreach($user as $userDtl): ?>
                                                          <li data-value="<?= $userDtl['standard_email']; ?>" onclick="getfilterdData('<?= $userDtl['standard_email']; ?>','getsovalue','user_filter','dummyParam'); setSelectedUser('<?= $userDtl['standard_name']; ?>');"><?= $userDtl['standard_name']; ?></li>
                                                          <?php endforeach; ?>
                                                      </ul>
                                                      
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-lg-2">
                                <div id="external_search" class="dataTables_filter">
                                    <label>
                                        <input type="search" style="height: 2.4rem; border: 1px solid #f2f3f4;" name ="customerName" id ="customerName" 
                                              class="form-control form-control-sm" placeholder="Customer Name"
                                              aria-controls="ajax_datatable">
                                    </label>
                                </div>
                            </div>
                      
                        <div class="col-lg-2">
                            <div class="first-one custom-dropdown dropdown">
                            <input type="hidden" id="cust_filter" value="" name="cust_filter">
                                <input type="text" name="po_filter" id="po_filter" onkeyup="applyDateFilter()" class="form-control" placeholder="Customer PO. Number" aria-label="Start Date" aria-describedby="basic-addon1" style="height: 2.4rem; border: 1px solid #f2f3f4;">
                              
                            </div>
                        </div>
    
                        <div class="col-lg-2">
                            <div class="first-one custom-dropdown dropdown">
                                <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonNew" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:0.9rem;">
                                  Select New/Renew
                                </button>
                              
                                
                                <input type="hidden" id="new_filter" value="" name="new_filter">
                                    <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonNew">
                                          
                                            <?php $new = "new"; ?>
                                            <li data-value="<?= $new; ?>" onclick="getfilterdData('<?= $new; ?>','getsovalue', 'new_filter', 'dummyParam'); setSelectedNew('New');"> New</li>
                                            <?php $renew = "renew"; ?>
                                            <li data-value="<?= $renew; ?>" onclick="getfilterdData('<?= $renew; ?>','getsovalue','new_filter', 'dummyParam'); setSelectedNew(' Renew');">Renew</li>
                                  </ul>
                            </div>
                        </div>
    
                      
                </div> -->
              <!-- </form> -->
            
            
        <!-- </div>  -->
        
                            <!-- Modal Custom Date Start -->
                            <div class="modal fade" id="linkedinvoiceform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Custom Date testing</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="deliveryForm">
                                                <div class="form-row">
                                                    <!-- From Date Column -->
                                                    <div class="form-group col-md-6">
                                                        <label for="start_date">From Date</label>
                                                        <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Start Date">
                                                    </div>
                                                    <!-- End Date Column -->
                                                    <div class="form-group col-md-6">
                                                        <label for="end_date">To Date</label>
                                                        <input type="date" name="end_date" id="end_date" class="form-control" placeholder="End Date">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="applyFilterBtn">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Custom Date End -->


        <div class="container-fliud" class="filterbtncon"  style="border-radius:12px; background:#fff; padding-top:22px; padding-right:12px; padding-left:24px; margin:12px; margin-right:32px;">
        
            <div class="row mb-3">

             <div class="col-lg-6">
                    
                </div>

               <!-- <div class="col-lg-2">
                    <div class="first-one custom-dropdown dropdown float-right">
                     <button class=" btnstopcorner btn" onClick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
                    </div>
                </div> -->

            <div class="col-lg-2">
                 <div class="dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="<?php echo base_url() . "home"; ?>#">   
                             <div class="refresh_button float-right d-md-block d-none ml-2 d-flex"> 
                              <button class=" btncorner btn" onClick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
                                 <button class="btncorner btn"> Export</button>
                             </div>                       
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-sm mt-2" aria-labelledby="dropdown-profile">                      
                        <li><a class="dropdown-item">
                             <form id="filterForm" onsubmit="return filter_Export();" style="display: inline;">
                                <?php if($this->session->userdata('type')=='admin'){ ?>
                                  <button class="btncorner btn" type="submit"> Export All Data </button>
                                <?php }?>
                             </form>
                            </a>
                        </li>
                        <li> <?php if($this->session->userdata('type')=='admin'){ ?>
                            <a href='Export_data/export_po' class="dropdown-item" ><button class="btncorner btn">Export With PO </button></a>
                                <?php } ?>   
                        </li>
                        <li> <?php if($this->session->userdata('type')=='admin'){ ?>
                            <a href='Salesorders/export_without_po' class="dropdown-item" ><button class="btncorner btn">Export Without PO </button></a>
                        <?php } ?>
                        </li>
                      
                    </ul>
                 </div>
             </div>

                  <!---------------------------------------------  Start New and Renewel------------------- -->
                

                  <div class="col-lg-2" >
                    <div class="refresh_button align-items-center">
                       
                        <?php if(check_permission_status('Salesorders','create_u')==true){
                          if($this->session->userdata('account_type')=="Trial" && $countSO>=500){ ?> 
                              <button class="btncorner btn" onclick="infoModal('You are exceeded  your salesorder limit - 500')" > Add New</button>
                          <?php }else{ ?>  
                           <a href="<?= base_url('add-salesorder')?>" style="color:#fff; padding: 0px;"> <button class="btncorner btn">Add New </button></a>

                          <?php } } ?>
                    </div>
                </div>
                     

                      <div class="col-lg-2">
                          <div class="first-one custom-dropdown dropdown text-right" style="margin-top: -16px;">          
                            <button class="btnstop" data-toggle="modal" data-target="#exampleModalScrollable" id="btn1" style="font-size:40px;"><i class="fas fa-filter"></i></button>       
                          </div>
                      </div>
                  
                  
                  <!-- ---------------------------- End Po Create ----------------------------- -->

            
            </div>
        </div> 
                   
        <input type="hidden" name="status_filter" id="status_filter">

        <!-- <div class="container-fluid">
            <div class="row  text-center p-1">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6  mb-5 statusso" data-status="100" data-color="eeda24">
                      <div class="card card1">
                          <div class="card-body topstatuscards d-flex justify-content-between align-items-center">
                              <div class="">
                                  <h5 class="card-title">Pending test</h5>
                                  <p class="card-text"><b>₹</b> : <span id="dendingData">0.00</span></p>
                              </div>
                              <i class="fas topstatusicon fa-clock fa-beat fa-2x" style="color: #eeda24; background-color: rgba(238, 218, 36, 0.2); padding: 10px; border-radius: 50%;"></i>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-6 statusso mb-5" data-status="50" data-color="125baa">
                      <div class="card card2">
                          <div class="card-body topstatuscards d-flex justify-content-between align-items-center">
                              <div>
                                  <h5 class="card-title">In Progress</h5>
                                  <p class="card-text"><b>₹</b> : <span id="inProgressData">0.00</span></p>
                              </div>
                              <i class="fas  topstatusicon fa-spinner fa-flip fa-2x" style="color: #125baa; background-color: rgba(18, 91, 170, 0.2); padding: 10px; border-radius: 50%;"></i>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-6 mb-5 statusso" data-status="invoice" data-color="828587">
                      <div class="card card3">
                          <div class="card-body topstatuscards d-flex justify-content-between align-items-center">
                              <div>
                                  <h5 class="card-title">Invoice Pending</h5>
                                  <p class="card-text"><b>₹</b> : <span id="invoicePendData">0.00</span></p>
                              </div>
                              <i class=""></i>
                              <i class="fa-solid fa-receipt  fa-flip topstatusicon fa-2x" style="color: pink; background-color:rgba(255,192,203,0.4); padding: 10px; width:52px; border-radius: 50%;"></i>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-6  mb-5 statusso" data-status="complete" data-color="82d324">
                      <div class="card card4">
                          <div class="card-body topstatuscards d-flex justify-content-between align-items-center">
                              <div>
                                  <h5 class="card-title">Complete</h5>
                                  <p class="card-text"><b>₹</b> : <span id="completeData">0.00</span></p>
                              </div>
                            
                              <i class="fas topstatusicon fa-check-circle fa-beat fa-2x" style="color: #82d324; background-color: rgba(130, 211, 36, 0.2); padding: 10px; border-radius: 50%;"></i>
                          </div>
                      </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card mx-md-4 mt-2 mb-0 px-5 py-4" style="border-radius:12px;">
                  <div class="row">
                      <div class="col-md-12">
                        <div class="quoteaccordion quoteaccordion1" >
                          <div class="quoteacc_head" id="faqhead1" data-toggle="collapse" data-target="#faq1" aria-expanded="false" aria-controls="faq1" > <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> Sales order Summary</a>
                          </div>
                          <div id="faq1" class="collapse" aria-labelledby="faqhead1" data-parent="#faq">
                              <div class="card-body quotaccbody">
                                Total Sales orders : <?= $countSO; ?>
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="quoteaccordion ">
                            <div class="quoteacc_head" id="faqhead2" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq2" > <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> Sales Orders Graph</a>
                            </div>
                            <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq2">
                                <div class="card-body quotaccbody">
                                  <div id="chart-line"></div>
                                </div>
                            </div>
                        </div> 
                      </div>
                  </div>
                </div>
              </div>
            </div>
        </div> -->
                  </div>
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
                                  <tr>
                                  <td></td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked style="display: none;"></td>
                                </tr>
                                
                                <tr>
                                <td>Customer Name</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked  ></td>
                                </tr>
                                 <tr>
                                  <td>Subject</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Salesorder ID</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Owner</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>SO Stage</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Status</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                  <td>Added Date</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                
                                <tr>
                                  <td>PO. NO.</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                
                                <tr>
                                  <td>PO. Date</td>
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
            <div class="card-header mb-2"><b style="font-size:21px;">Salesorder</b> <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                      <a id="mass_model" href="#" style="text-decoration:none;">
                            <button type="button" id="mass_product" class="btn" style="display:none; border-radius: 2rem; margin-bottom: 1rem; background: #845ADF; color:#fff; font-weight: 500;">
                              Mass Update
                            </button>
                        </a>
                     
                     </div>
            <div class="card-body">
               <table id="ajax_datatable" class="table table-striped  table-bordered table-responsive-lg" cellspacing="4" width="100%" style="font-size: 15px; ">
              
                  <thead>

                     <tr>
                        <?php if(check_permission_status('Salesorders','delete_u')==true): ?>
                        <th><button class="btn" type="button" name="delete_all" id="delete_all2"><i class="fa fa-trash text-light"></i></button></th>
                        <?php endif; ?>
                        <th class="th-sm">Customer Name</th>
                        <th class="th-sm">Subject</th>
                        
                        <th class="th-sm" >Salesorder ID</th>
                        <th class="th-sm" style="width:10%;">Owner</th>
                        <th class="th-sm">SO Stage</th>
                        <th class="th-sm">Status</th>
                        <th class="th-sm">Added Date</th>
                          <th class="th-sm">Customer PO. NO.</th>
                              <th class="th-sm">Customer PO. Date</th>
                        <th class="th-sm" style="width:13%;">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
               </div>
                        </div>
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.row (main row) -->
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php if(check_permission_status('Salesorders','retrieve_u')==true):?>
<?php //SalesOrder Renewal Modal Starts ?>
<div class="modal fade" id="sales_alert" role="dialog" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content" >
         <div class="modal-header">
            <h4 class="modal-title sales_alert">Renewal&nbsp;Alert </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body form">
            <!-- <button class="btn btn-secondary float-right" onclick="reload_notify_table()"><i class="fas fa-sync-alt"></i></button> -->
            <table class="table">
               <thead>
                  <tr>
                     <th>SO&nbsp;Id</th>
                     <th>Subject</th>
                     <th>Organization&nbsp;Name</th>
                     <th>Renewal&nbsp;Date</th>
                     <th>Owner</th>
                     <th>Action</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody id="notify_table">
                  <?php $cnt=0;if(!empty($renewal_data)) { foreach($renewal_data as $renew) { $cnt=1;?>
                  <tr>
                     <td><?= $renew['saleorder_id']; ?></td>
                     <td><?= $renew['subject']; ?></td>
                     <td><?= $renew['org_name']; ?></td>
                     <td><?= $renew['renewal_date']; ?></td>
                     <td><?= $renew['owner']; ?></td>
                     <td>
                        <button class="btn btn-primary btn-sm" onclick="view_so(<?= $renew['id'];?>);">View</button>
                     </td>
                     <td><button class="btn btn-danger btn-sm" onclick="end_renewal(<?= $renew['id'];?>);">End</button></td>
                  </tr>
                  <?php } } ?>
               </tbody>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary " data-dismiss="modal" onclick="close_notify_sess();">Close</button>
         </div>
      </div>
   </div>
</div>
<?php //Purchaseorder Renewal Modal Ends ?>
<?php endif;?>


<!-- Purchaseorder create Modal Start -->
<?php if(!empty($po_popup)):?>
<!-- SalesOrder Renewal Modal Starts  -->
<div class="modal fade" id="salescreate_alert" role="dialog" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-xl">
      <div class="modal-content" >
         <div class="modal-header">
            <h4 class="modal-title sales_alert">
               Purchase Order Pending&nbsp;Alert 
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body form">
            <table class="table">
               <thead style="background:rgba(35,0,140,0.8);" >
                  <tr>
                     <th>SO&nbsp;Id</th>
                     <th>Subject</th>
                     <th>Organization&nbsp;Name</th>
                     <th>Salesorder&nbsp;Date</th>
                     <th style="min-width:80px;">Due&nbsp;Date</th>
                     <th style="min-width:100px;">Owner</th>
                     <th style="min-width:80px;">Amount</th>
                     <th style="min-width:80px;">Profit</th>
                     <th colspan="2" class="text-center">Action</th>
                     <!-- <th>Action</th> -->
                  </tr>
               </thead>
               <tbody id="notify_PO">
                  <?php 
                     $cpo=0; 
                     if(!empty($po_popup)) 
                     { 
                       $amount = 0;
                       $profit = 0;
                     foreach($po_popup as $sales) { 
                       $cpo=1;
                       $sid = $sales['saleorder_id'];
                       $ex = explode('/', $sid);
                       $so_id = end($ex); 
                     
                       $cu = $sales['currentdate'];
                       $currentdate = date("d-m-y", strtotime($cu));
                     
                       $du = $sales['due_date'];
                       $duedate = date("d-m-y", strtotime($du));
                     ?>
                  <tr>
                     <td><?= $so_id; ?></td>
                     <td><?= $sales['subject']; ?></td>
                     <td><?= $sales['org_name']; ?></td>
                     <td><?= $currentdate; ?></td>
                     <td><?= $duedate; ?></td>
                     <td><?= $sales['owner']; ?></td>
                     <td><?= IND_money_format((int)$sales['initial_total']); ?>&#8377;</td>
                     <td><?= number_format((int)$sales['profit_by_user']); ?>&#8377;</td>
                     <td>
                        <a style="text-decoration:none" href="<?= base_url(); ?>salesorders/view_pi_so/<?= $sales['id'];?>" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Sales Details" ></i></a>
                     </td>
                     <td>
                        <a style="text-decoration:none" href="<?= base_url();?>add-purchase-order?so=<?= $sales['id'];?>" class="text-info border-right">
                        <i class="fas fa-shopping-basket sub-icn-po m-1" data-toggle="tooltip" data-container="body" title="Create Purchase Order" ></i></a>
                     </td>
                  </tr>
                  <?php $amount += $sales['initial_total'];
                     $profit += $sales['profit_by_user'] ;   } } ?>
                  <tr style="background:rgba(245,245,250,0.8); padding-top:20px;">
                     <td colspan="6" style="text-align:right;  padding-top:20px; padding-bottom:15px;color:green">Total : </td>
                     <td style=" padding-top:20px; padding-bottom:15px;"><?= IND_money_format((int)$amount); ?>&#8377;</td>
                     <td colspan="2"style=" padding-top:20px; padding-bottom:15px;"><?= IND_money_format((int)$profit); ?>&#8377;</td>
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
<!-- Purchaseorder Renewal Modal End -->
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<?php if(isset($_GET['soid'])){
   $soid=$_GET['soid'];
   $ntid=$_GET['ntid'];
   }else{
   $soid='';
   $ntid='';
   }  ?>

   
      <script>
        // Date Filter
        function setSelectedFilter(selectedText) {
          document.getElementById('dropdownMenuButton').innerText = selectedText;
        }
                
        // User name or Owner name
        function setSelectedUser(selectedText) {
            document.getElementById('dropdownMenuButtonn').innerText = selectedText;
        }
                       
        // Po filter js
        function applyDateFilter() {
            var selectedDate = document.getElementById('po_filter').value;
    
            if (selectedDate === '') {
               getfilterdData('', 'getsovalue', 'cust_filter');
              } else {
              getfilterdData(selectedDate, 'getsovalue', 'cust_filter');
              }
        }

        // <!-- New / renew js -->
        function setSelectedNew(selectedTextNew) {
            document.getElementById('dropdownMenuButtonNew').innerText = selectedTextNew;

        }

        // Customer Name
        $(document).ready(function() {
            var table = $('#ajax_datatable').DataTable();
            $('#external_search input').on('keyup', function() {
              var searchTerm = this.value;
              table.search(searchTerm).draw();
              $('#ajax_datatable_filter input').val('');
           });

          $('#external_search input').on('focus', function() {
              $('#ajax_datatable_filter input').val('');
          });
        });

      </script>
                
                


                   <!-- Related Custom Date Filter -->
                            <script>
                                $(document).ready(function() {
                                    // Trigger the filter action on 'Apply Filter' button click
                                    $('#applyFilterBtn').on('click', function() {
                                        var startDate = $('#start_date').val();
                                        var endDate = $('#end_date').val();
                            
                                        // Ensure both start and end dates are selected
                                        if (startDate && endDate) {
                                            // Call the filtering function
                                            getfilterdData(startDate, endDate, 'getsovalue', 'cust_filter');
                                          
                                            // Close the modal after applying the filter
                                            $('#linkedinvoiceform').modal('hide');
                            
                                            // $('#start_date').val('');
                                            // $('#end_date').val('');
                                        } else {
                                            alert('Please select both start and end dates.');
                                        }
                                    });
                                });
                            </script>

                            <!-- jQuery Script to trigger modal -->
                              <script>
                                  $(document).ready(function() {
                                      // Bind click event to 'Add New Delivery Challan'
                                      $('#addnewdeliverychallan').on('click', function() {
                                          $('#linkedinvoiceform').modal('show');  // Show the modal
                                      });
                        
                                      // Handle submit button action
                                      $('#saveChangesBtn').on('click', function() {
                                          $('#deliveryForm').submit();  // Submit the form
                                      });
                                  });
                              </script>
                    
                    
                    
                              <script>
                                $(document).ready(function() {
                                  $('#customByDate').on('click', function() {
                                      $('#dateModal').modal('show');  // Show the modal
                                  });
                    
                                  $('#submitDate').on('click', function() {
                                      var startDate = $('#startDate').val();
                                      var endDate = $('#endDate').val();
                                    
                                      // Perform any validation or actions here
                                      console.log("Selected Dates:", startDate, endDate);
                    
                                      // Close the modal after submit
                                      $('#dateModal').modal('hide');
                                  });
                              });
                              </script>



<script>

   // Filter Export function
                      function filter_Export() {
                        const selected_date_Value     = document.getElementById('date_filter').value;
                        const selected_user_Value     = document.getElementById('user_filter').value;
                        const selected_customer_Value = document.getElementById('customerName').value;
                        const selected_custpo_Value   = document.getElementById('cust_filter').value;
                        const selected_new_Value      = document.getElementById('new_filter').value;

                        // Create a form dynamically
                        const form = document.createElement("form");
                        form.method = "POST";
                        form.action = "<?= site_url('salesorders/export_filter_Data'); ?>";

                        const addField = (name, value) => {
                            const input = document.createElement("input");
                            input.type = "hidden";
                            input.name = name;
                            input.value = value;
                            form.appendChild(input);
                        };

                        // Append all fields
                        addField("searchDate", selected_date_Value);
                        addField("searchUser", selected_user_Value);
                        addField("customer", selected_customer_Value);
                        addField("custpo", selected_custpo_Value);
                        addField("newValue", selected_new_Value);

                        // Submit form
                        document.body.appendChild(form);
                        form.submit();
                        document.body.removeChild(form);

                        return false;
                    }
</script>




   <script>
    document.addEventListener("DOMContentLoaded", function() {
        var select = document.getElementById("custom-select");
        var optionsContainer = document.getElementById("custom-options");
        var options = document.querySelectorAll("#custom-options li");

        select.addEventListener("click", function() {
            optionsContainer.classList.toggle("show");
        });

        options.forEach(function(option) {
            option.addEventListener("click", function() {
                select.innerHTML = this.innerHTML;
                optionsContainer.classList.remove("show");
            });
        });
    });
</script>

<script>
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

     <?php if(check_permission_status('Salesorders','retrieve_u')==true):?>
       table = $('#ajax_datatable').DataTable({
         "processing": true, 
         "serverSide": true, 
          "pageLength": 15,
         "order": [], 
         "ajax": {
           "url": "<?= base_url('salesorders/ajax_list'); ?>",
           "type": "POST",
           "data" : function(data)
            {
              data.searchDate = $('#date_filter').val();
               data.searchDateFil = $('#po_filter').val();
               data.searchUser = $('#user_filter').val();
               data.searchStatus = $('#status_filter').val();
               data.start_date = $('#start_date').val(); // Include start date
               data.end_date = $('#end_date').val(); 
                data.new_Renew = $('#new_filter').val(); 
            },
            "dataSrc": function(json) {
           
                $('#totalRecordsFilter').text("Total Filter data : " + json.recordsFiltered);
                  return json.data; 
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
   
       
   
    $('.statusso').click(function(){
     $('.statusso').css('border-bottom','');
     $('.statusso').css('transform','');
     var clr=$(this).data('color');
     //$(this).addClass('activediv');
     $(this).css('transform','translateY(-9px)');
     $(this).css('border-bottom','9px solid #'+clr);
     
     var value=$(this).data('status');
     
     $('#status_filter').val(value);
           table.ajax.reload();
     
       });
       function reload_table()
       {
           table.ajax.reload(null,false);
       }
    
    
   function getsovalue(){
   var searchDate   = $('#date_filter').val();
   var searchUser   = $('#user_filter').val();
   var search     = $('#ajax_datatable_filter input').val();
     $.ajax({
    url   : "<?= site_url('salesorders/getstatusvalue');?>",
    method  : "post",
    data  : "searchDate="+searchDate+"&searchUser="+searchUser+'&search_data='+search,
    dataType: "JSON",
    success : function(result){
      if(result.pening){
      $("#dendingData").html(numberToIndPrice(result.pening));
        }
        if(result.inProgress){
      $("#inProgressData").html(numberToIndPrice(result.inProgress));
        }
        if(result.invoicePend){
      $("#invoicePendData").html(numberToIndPrice(result.invoicePend));
        }
        if(result.complete){
      $("#completeData").html(numberToIndPrice(result.complete));
        }
    }
     });
     }
   getsovalue(); 
     <?php endif; ?>
     
     
     function changeNotiStatus(){
   var noti_id="<?=$ntid;?>";
   url = "<?= site_url('notification/update_notification');?>";
      $.ajax({
        url : url,
        type: "POST",
        data: "noti_id="+noti_id+"&notifor=salesorders",
        success: function(data)
        { }
      });
     }
   
   
   
   function approve_entry(soid,soidapp,stts,textid) {
   if(stts==1){  
   toastr.info('Please wait while we are processing your request..');
   }
     var urlst = "salesorders/changeStatus";
   $("#"+textid).html('');
     $.ajax({
         url : urlst,
         type: "POST",
         data: "soid="+soid+'&sovalue='+stts,
         success: function(data)
         { 
             if(data==1){
      toastr.success('Sales order ID #'+soidapp+" has been approved successfully.");
             }else if(data==0){
                 toastr.error('Sales order ID #'+soidapp+" disapproved successfully.");
             }else{
                 toastr.success('Sales Order ID #'+soidapp+" has been Approved Successfully.");
             }
     table.ajax.reload();
         }
     });
   };  
     
     
   <?php if(check_permission_status('Salesorders','create_u')==true): ?>
    
     function ValidateSize(file)
     {
       var FileSize = file.files[0].size / 1024 / 1024; // in MB
       if (FileSize > 2)
       {
         alert('File is larger than 2MB');
         $(file).val(''); //for clearing with Jquery
       }
       else
       {
   
       }
     }
   <?php endif; ?>
   
</script>
<script>
   $(document).ready(function(){
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
     deleteBulkItem('salesorders/delete_bulk'); 
   });
</script>
<script>
   <?php if(check_permission_status('Salesorders','delete_u')==true):?>
     function delete_entry(id,soid)
     {
   
       if(confirm('Are you sure delete this data?'))
       {
         // ajax delete data to database
         $.ajax({
           url : "<?= base_url('salesorders/delete'); ?>/"+id+"/"+soid,
           type: "POST",
           dataType: "JSON",
           success: function(data)
           {
             if(data.status){
             //if success reload ajax table
             $('#sales_popup').modal('hide');
             //reload_table();
             refreshPage();
             }
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
   // $(document).ready(function()
   // {
   //     var countRn='<?php echo $cnt;?>';
   //     if(countRn>0){
   //         $("#sales_alert").modal('show');
   //     }
   // });
   
   $(document).ready(function()
   {
       var countSO='<?php echo $cpo;?>';
       if(countSO>0){
           $("#salescreate_alert").modal('show');
       }
   });
   
   function end_renewal(id)
   {
     $.ajax({
       url:'<?=site_url("salesorders/end_renewal")?>',
       method: 'post',
       data: {id:id},
       dataType: 'json',
       success: function(response)
       {
         $.ajax({
           url:'<?=site_url("salesorders/update_renewal_data")?>',
           method: 'post',
           data: {id:id},
           dataType: 'json',
           success: function(response)
           {
             $("#notify_table").empty();
             var table;
             $.each(response,function(index,data)
             {
               table = "<tr><td>"+data['saleorder_id']+"</td>"+"<td>"+data['subject']+"</td>"+"<td>"+data['org_name']+"</td>"+"<td>"+data['renewal_date']+"</td>"+""+"<td>"+data['owner']+"</td>"+"<td><button class='btn btn-primary btn-sm' onclick='view_so("+data['id']+")'>View</button></td>"+"<td><button class='btn btn-danger btn-sm' onclick='end_renewal("+data['id']+")'>End</button></td>"+"</tr>";
               $("#notify_table").append(table);  
             });
           }
         });
       }
     });
   }
   
   function view_so(sales_id){
    window.location.href = "<?=base_url('salesorders/view_pi_so/'); ?>"+sales_id; 
   }
   function refreshPage(){
       window.location.reload();
   } 
   
</script>
<script>
 $.ajax({
  url:'<?php echo site_url('salesorders/so_graph')?>',
              method:'post',
              success:function(response){
              if (response.status === 'success') {
              
var so_amount = [];
var xAxisCategories=[];
for (var i = 0; i < response.data.length; i++) {
  so_amount.push(parseFloat(response.data[i].subtotal)); 
    xAxisCategories.push(response.data[i].month + "/" + response.data[i].year);
}


var options = {
    series: [
        { name: 'Total SO Amount of month', data: so_amount },
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
    }
};
        var chart = new ApexCharts(document.querySelector("#chart-line"), options);
        chart.render();

              }
             }
    });

    // function getfilterdData(e,f,g){

    //   var id = "#" + g;
    //   $(id).val(e);
    //   window[f]();
    //   table.ajax.reload();
    // }
    
       function getfilterdData(selectedValue, functionName, filterId, dummyParam) {
            var id = "#" + filterId;
            $(id).val(selectedValue); // Set the selected user email to the hidden input
         
            // Here you can add any logic to handle the dummy parameter if necessary
            console.log('Dummy Parameter:', dummyParam);
         
            // Call the function based on the provided function name
            if (functionName === 'getsovalue') {
                // Any specific logic for 'getsovalue' can go here
            }
         
            // Reload the DataTable to fetch new data
            table.ajax.reload();
        }


</script>



<!---------------------------- New Ajax Start MAss UPdate ---------------------------->
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
    'org_name','subject','opp_name','customer_mobile', 'customer_email','sales_commission','po_no','payment_terms','carrier','po_date','due_date','excise_duty','currentdate','renewal_date',
    'owner','pending','contact_name', 'billing_country',
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
       const po_dateSelect = wrapper.querySelector('.po_date-select'); 
       const renewal_dateSelect = wrapper.querySelector('.renewal_date-select'); 
       const due_dateSelect = wrapper.querySelector('.due_date-select');
       const currentdateSelect = wrapper.querySelector('.currentdate-select');

      const lead_sourceSelect = wrapper.querySelector('.lead_source-select');
      const pipelineSelect = wrapper.querySelector('.pipeline-select');
      const industrySelect = wrapper.querySelector('.industry-select');
      const Select = wrapper.querySelector('.customertype-select');

      const carrierSelect = wrapper.querySelector('.carrier-select'); 
      const payment_termsSelect = wrapper.querySelector('.payment_terms-select'); 



      if (typesRequiringLength.includes(selectedType)) {
        lengthWrapper.style.display = 'block';
        dummytextWrapper.style.display = 'none';

        // Hide all first
        input.style.display = 'none';
        po_dateSelect.style.display = 'none';
        renewal_dateSelect.style.display = 'none';
        due_dateSelect.style.display = 'none';
        currentdateSelect.style.display = 'none';

        lead_sourceSelect.style.display = 'none';
        pipelineSelect.style.display = 'none';
        industrySelect.style.display = 'none';

        carrierSelect.style.display = 'none';
        payment_termsSelect.style.display = 'none';

        // Show appropriate one 
        if (selectedType === 'po_date') {
          po_dateSelect.style.display = 'block';
        }else if (selectedType === 'renewal_date') { 
          renewal_dateSelect.style.display = 'block';
        }else if (selectedType === 'due_date') { 
          due_dateSelect.style.display = 'block';
        }else if (selectedType === 'currentdate') {
          currentdateSelect.style.display = 'block';
        }else if (selectedType === 'lead_source') {
          lead_sourceSelect.style.display = 'block';
        }else if (selectedType === 'pipeline') {
          pipelineSelect.style.display = 'block';
        }else if (selectedType === 'industry') {
          industrySelect.style.display = 'block';
        }else if (selectedType === 'carrier') {
          carrierSelect.style.display = 'block';
        }else if (selectedType === 'payment_terms') {
          payment_termsSelect.style.display = 'block';
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
    if (selectedType === 'po_date') {
      finalValue = $('#po_date_select').val();
    }else if (selectedType === 'renewal_date') {
      finalValue = $('#renewal_date_select').val();
    }else if (selectedType === 'due_date') {
      finalValue = $('#due_date_select').val();
    }else if (selectedType === 'currentdate') {
      finalValue = $('#currentdate_select').val();
    }else if (selectedType === 'lead_source') {
      finalValue = $('#lead_source_select').val();
    }else if (selectedType === 'pipeline') {
      finalValue = $('#pipeline_select').val();
    }else if (selectedType === 'industry') {
      finalValue = $('#industry_select').val();
    }else if (selectedType === 'carrier') {
      finalValue = $('#carrier_select').val();
    }else if (selectedType === 'payment_terms') {
      finalValue = $('#payment_terms_select').val();
    }else {
      finalValue = $('#value_input').val();
    }

    // Set hidden field
    $('#final_value_input').val(finalValue);

    // Submit via AJAX
    var formData = $('#massForm').serialize();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('salesorders/add_mass'); ?>",
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
