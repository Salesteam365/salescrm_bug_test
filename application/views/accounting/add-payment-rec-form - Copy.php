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
   font-size: 16px;
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

#ajax_datatable tbody tr td:nth-child(3) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
}
.filterbox{
  display:flex;
 
  width:77vw;
  border-radius:5px;
  background:rgba(197,180,227,0.2);
   border-top:none;
   border-left:5px solid purple;
  margin-left:18px;
  
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
  a.btnstopcorner {
    border: 1px solid #ccc; /* Light grey border on hover */
    border-radius: 4px;
    background: white;
    color: rgba(30, 0, 75);
  }

  a.btnstopcorner:hover {
    background:lightgrey;
    border: 1px solid #ccc; /* Light grey border on hover */
  }

    h5{
      font-size:16px;
    }
    h4{
      font-size:20px;
      font-weight:bolder;
    }
    /* Custom select box */
.custom-select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 8px 32px 8px 8px;
  border: none; /* Remove border */
  background-color: transparent; /* Make background transparent */
  font-size: 14px;
  color: #495057;
  cursor: pointer; /* Show pointer cursor */
}

.custom-select::after {
  /* content: '\25BC';  */
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  pointer-events: none; /* Ensure clicks go through */
}

.custom-select:hover {
  color: #000; /* Change text color on hover */
}

.custom-select option {
  background-color:#ccc; /* Change background color */
  color: #000; /* Change text color */
  border:none !important;
}

.custom-select option:hover {
  background-color: #f0f0f0; /* Change background color on hover */
}

#btnSave {
  background-color: initial;
  background-image: linear-gradient(#8614f8 0, #760be0 100%);
  border-radius: 5px;
  border-style: none;
  box-shadow: rgba(245, 244, 247, .25) 0 1px 1px inset;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  font-family: Inter, sans-serif;
  font-size: 16px;
  font-weight: 500;
  height: 40px;
  line-height: 20px;
  margin-left: -4px;
  outline: 0;
  text-align: center;
  transition: all .3s cubic-bezier(.05, .03, .35, 1);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: bottom;
  width: 160px;
}

#btnSave:hover {
  opacity: .7;
}

@media screen and (max-width: 1000px) {
  #btnSave {
    font-size: 14px;
    height: 55px;
    line-height: 55px;
    width: 150px;
  }
}


</style>

<style>
    .custom-select-wrapper {
        position: relative;
    }

    .custom-select {
        display: inline-block;
        position: relative;
    }

    .select-button {
        background-color: #fff;
        border: 1px solid #ccc;
        padding: 10px;
        width: 200px;
        text-align: left;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #ccc;
        /* width: 200px; */
        z-index: 1;
    }

    .dropdown-button {
        background-color: transparent;
        border: none;
        padding: 10px;
        width: 100%;
        text-align: left;
    }

    .dropdown-button:hover {
        background-color: #f0f0f0;
    }
</style>

<style>
    /* CSS for left alignment and hover effect */
    .form-group {
        font-family: Arial, sans-serif;
      
    }

    .form-check {
        border: 1px solid gray;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: flex-start; /* Align to the left */
        transition: border-color 0.3s ease; /* Smooth transition for border color */
        cursor: pointer; /* Change cursor to pointer on hover */
        border-radius: 10px;
        
    }

    /* Hide default radio button */
    .form-check input[type="radio"] {
        display: none;
    }

    /* Custom radio button */
    .checkmark {
        width: 20px;
        height: 20px;
        border: 1px solid gray;
        border-radius: 3px;
        margin-right: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Show checkmark when radio button is checked */
    .form-check input[type="radio"]:checked + .checkmark::after {
        content: '';
        width: 12px;
        height: 12px;
        background-color: blue;
        border-radius: 10%;
    }

    /* Change border color of form-check when radio button is checked */
    .form-check input[type="radio"]:checked + .checkmark {
        border-color: blue;
    }
</style>
<!-- Add Payment Placeholder -->
<style>
    
</style>

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.3);">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">New Payment Receipt</h1>
                    </div><!-- /.col -->

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Payment Reciept</li>
                        </ol>
                    </div><!-- /.col -->

                </div>
                    <!-- /.row -->

                <div class="row">
              
                        <!-- <div class="col-lg-2">
                            <?php if($this->session->userdata('type') == 'admin') { ?>
                            <select class="form-control" name="user_filter" id="user_filter">
                                <option selected value="">Select User</option>
                                <?php foreach($admin as $adminU) { ?>
                                <option value="<?= $adminU['admin_email']; ?>"><?= $adminU['admin_name']; ?> (Admin)</option>
                                <?php } foreach($user as $users) { ?>
                                <option value="<?= $users['standard_email']?>"><?= $users['standard_name']?></option>
                                <?php } ?>
                            </select>
                            <?php } ?>
                        </div> -->
                    
                </div>

            </div><!-- /.container-fluid -->
        </div>


        <form class="form-horizontal"  id="form_payment" method="post" enctype = "multipart/form-data">
            <div class="card mx-md-5 mt-2 mb-0 px-5 py-4" style="border-radius:12px;">
                <div class="accordion mx-4" id="faq" >

                    <div class="quoteaccordion">
                        <div class="quoteacc_head" id="faqhead1" data-toggle="collapse" data-target="#faq1" aria-expanded="false" aria-controls="faq1"> <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> 1. Select Client</a>
                        </div>

                        <div id="faq1" class="collapse" aria-labelledby="faqhead1" data-parent="#faq">

                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                            <label for="">&nbsp;&nbsp;Payment Received From<span style="color: #f76c6c;">*</span>:</label>
                                            <select class="form-control" name="org_clients" id="org_clients" value ="">
                                            <option selected value="">select</option>
                                            </select>
                                        
                                    </div>
                                </div>


                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" id ="invoicehide">
                                    <div class="form-group">
                                            <label for="">Invoice<span style="color: #f76c6c;">*</span>:</label>
                                            <select class="form-control" name="invoice_no_select" id="invoice_no_select" style="padding-right: 150px;">
                                                <option value="" selected disabled >Select Invoice</option>
                                            
                                            </select>
                                        
                                    </div>
                                </div>


                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" id ="piinvoicehide">
                                    <div class="form-group"> 
                                            <label for="">Proforma Invoice<span style="color: #f76c6c;">*</span>:</label>
                                            <select class="form-control" name="pi_invoice_no_select" id="pi_invoice_no_select" style="padding-right: 150px;">
                                                <option value="" selected disabled >Select Proforma Invoice</option>
                                            
                                            </select>
                                        
                                    </div>
                                </div>
                            

                            
                            </div>

                            <div class = "row">

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for=""> &nbsp;&nbsp;Payment Receipt No<span style="color: #f76c6c;">*</span>:</label>
                                            <input type="text" class="form-control" name="paymentreceipt_no" placeholder="Payment Receipt No" id="paymentreceipt_no" value="<?php echo $receipt_number; ?>">
                                            <span id="invoice_no_error"></span>

                                        </div>
                                    
                                </div>


                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="">Currency<span style="color: #f76c6c;">*</span>:</label>
                                            <select class="form-control" name="currency" id="currency">
                                            <option selected value="INR">INR</option>
                                            <!-- <option selected value="draft">Draft</option> -->
                                            
                                            </select>
                                        
                                        </div>
                                </div>

                               
                            </div>
                            <div class = "row">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label for="">&nbsp;&nbsp;Payment Receipt Date<span style="color: #f76c6c;">*</span>:</label>
					                    <input type="date" class="form-control" name="paymentreceipt_date" placeholder="" id="paymentreceipt_date" value="<?php echo date('Y-m-d');?>">
                                    </div>
                                </div>
                            </div>


                            <div class ="row" style = "padding-left: 10px;">
                                <div class="quoteacc_head" id="faqhead2" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq1"> <a href="#" class="btn btn-primary" > Continue</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="quoteaccordion">
                            <div class="quoteacc_head" id="faqhead2" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq1"> <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> 2. Add Payment Records</a>
                            </div>

                            <!-- Bootstrap 4 table initially hidden -->
                            <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                                <div class="row">
                                    <div class="container">
                                        <div class="row justify-content-center text-center">
                                            <div class="table-responsive">  
                                                <table id="paymentListing" class="table table-striped">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <!-- <th>Auto No.</th>  -->
                                                            <th>Deposited To</th> 
                                                            <th>Payment Method</th>
                                                            <th>Amount Received</th>
                                                            <th>Tds(%)</th>
                                                            <th>Transaction Charge</th>
                                                            <th>Tds</th>
                                                            <th>Ref ID</th>
                                                        
                                                            <!-- <th>Additional Notes</th> -->
                                                            <th>Action</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                
                                                    
                                                    </tbody>
                                                    <thead class ="thead-light">
                                                    <tr>
                                                            <td>Total</td>
                                                            <td></td>
                                                        
                                                            <td id="totalAmountReceived"></td>
                                                            <td></td>
                                                            <td id="totalTransactionCharge"></td>
                                                            <td id="totalTds"> </td>
                                                            <td></td>
                                                            <td></td>
        
                                                            
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            
                                            <div class="table-responsive">
                                                <table id="paymentList" class="table table-striped">
                                                    
                                                    <tbody>
                                                  
                                                    </tbody>
                                                </table>
                                            </div>

                                         
                                                <div class="col-md-4">
                                        
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4> <p>Record Payments</p> </h4> <br>
                                                            <p>Record multiple payments against multiple invoices</p> <br>
                                                            <button id="addpaymentbtn" type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Record Payment Received</button>

                                                        </div>
                                                    </div>
                                                </div>
                                                
                                        </div>
                                    </div>
                                </div>
                                <div class ="row"style = "padding-left: 10px;">
                                    <div class="quoteacc_head" id="faqhead3" data-toggle="collapse" data-target="#faq3" aria-expanded="false" aria-controls="faq1"> <a href="#" class="btn btn-primary" > Continue</a>
                                    </div>
                                </div>


                            </div>

                               

                    </div>

                    <div class="quoteaccordion selectedDiv" id ="div1payment" style="display:none;">
                            <div class="quoteacc_head" id="faqhead3" data-toggle="collapse" data-target="#faq3" aria-expanded="false" aria-controls="faq1"> <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> 3. Settle Unpaid Invoices</a>
                            </div>

                        <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq">


                            <!-- < ------------------------------- table invoices -----------------------------------------------> 



                            <div id="invoicesContainer">
                                <table id="invoicesTable" class="table table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Invoice No.</th>
                                            <th> Due Date</th>
                                            <th> Invoice Amount</th>
                                            <th> Previous Due Amount</th>
                                            <th> Amount Received</th>
                                            <th> Txn Charges</th>
                                            <th> TDS Withheld</th>
                                            <th> Amount to Settle</th>
                                            <th> Amount Due</th>
                                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                                    
                                    </tbody>
                                </table>

                                <table id="" class="table table-striped">
                                        <thead class ="thead-light">
                                            <tr>
                                                <th>Total</th>
                                                <th> &nbsp;</th>
                                                <th id ="totalSubTotal_i"> </th>
                                                <th id ="totalSubTotal_due_i"> </th>
                                                <th id="totalAmountReceived_i"></th>
                                                <th id="totalTransactionCharge_i"></th>
                                                <th id="totalTds_i"> </th>
                                                <th id ="totalAmountReceived_settle_i"> </th>
                                                <th id = "totalDue_i"> </th>
        
                                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                                    
                                        </tbody>
                                </table>


                            </div>


                                <!-------------------------------------------- table end ---------------------------------------------- -->

                                <div class="col-md-12 text-center" id = "clientbtn">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <picture class="sc-hZSUBg jJxbfx picture">
                                                    <noscript></noscript>
                                                    <img src="https://og.refrens.com/img/no_invoices_found_15aec0563b.png?fq=eyJ3Ijo1NiwiaCI6NTYsImJ1Y2tldCI6InJlZnJlbnMuZWxpc2lmLm1lZGlhIiwiX192IjoyfQ%3D%3D" class="sc-cMhqgX dMPAqg only-js ls-is-cached lazyloaded mx-auto" alt="NetworkPopup" title="NetworkPopup" data-src="https://og.refrens.com/img/no_invoices_found_15aec0563b.png?fq=eyJ3Ijo1NiwiaCI6NTYsImJ1Y2tldCI6InJlZnJlbnMuZWxpc2lmLm1lZGlhIiwiX192IjoyfQ%3D%3D" height="56" width="56">
                                                </picture> <br>
                                                <h4>No unpaid invoices found</h4> <br>
                                                <div class="row text-center">
                                                    <h6 style="margin: auto;"><p>There are no unpaid invoices against this client. This payment will be recorded as advance payment.</p></h6>
                                                </div> <br>

                                                <div class="row text-center justify-content-center">
                                                    <a href="<?= site_url('organizations'); ?>">
                                                        <button type="button" class="btn btn-outline-primary d-flex align-items-center justify-content-center mx-auto" data-toggle="" data-target=""> 
                                                            <span style="display: flex; align-items: center;">See Client Statement</span>
                                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M18 13V19C18 19.5304 17.7893 20.0391 17.4142 20.4142C17.0391 20.7893 16.5304 21 16 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V8C3 7.46957 3.21071 6.96086 3.58579 6.58579C3.96086 6.21071 4.46957 6 5 6H11" stroke="#7341FB" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M15 3H21V9" stroke="#7341FB" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M10 14L21 3" stroke="#7341FB" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </button>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                </div>



                                <div class="notes" style="padding: 20px 0;">
                                    <div class="container">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <a href="javascript:void(0);" class="add_notes"><img src="https://img.icons8.com/fluent/22/000000/note.png" style="margin-bottom: 4px;" > Add Notes</a>
                                        <div class="notes_left" <?php if(empty($record['notes'])){ echo "style='display:none;'"; } ?> >
                                            <textarea class="form-control" name="p_notes" rows="5" style="padding-right: 25px;" placeholder="Enter Notes"><?php if(isset($record['notes'])){ echo $record['notes']; } ?></textarea>
                                            <button class="remove_notes" type="button" style="top: 8px;" ><img src="https://img.icons8.com/cotton/24/000000/delete-sign--v2.png"/></button>
                                        </div>
                                        </div>
                                        
                                        
                                    </div>
                                    </div>
                                </div>


                                <div class="contact_details">
                                    <div class="container">
                                        <p>Your contact details :</p>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <p>For any enquiry, reach out via email at</p>
                                                <input type="email" name="enquiry_email" value="<?=$this->session->userdata('company_email');?>">
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <p>Or you can call on</p><label style="display: inline; border: 0; border-bottom: 1px solid #ccc;  background-color: transparent; ">+91-</label>
                                                <input type="text" style="width:90%;" name="enquiry_mobile" value="<?=$this->session->userdata('company_mobile');?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="save-btn text-left">
                                        <button type="button" id="btnPayment" onclick="savepayment();" class = "btn btn-primary">Save & Continue</button>
                                        <button type="button" id="btnPaymentCls" style="display:none;">Validating Data...</button>
                                    </div>
                                   
                                </div>

                               
                                
                                

                        </div>
                           
                            
                    </div> 


                    

                    <div class="quoteaccordion selectedDiv" id ="div2payment" style="display:none;">
                            <div class="quoteacc_head" id="faqhead4" data-toggle="collapse" data-target="#faq4" aria-expanded="false" aria-controls="faq1"> <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> 3. Add Additional Details</a>
                            </div>

                        <div id="faq4" class="collapse" aria-labelledby="faqhead4" data-parent="#faq">
                            <div id="invoicesContainer">


                                <div class="notes" style="padding: 20px 0;">
                                    <div class="container">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <a href="javascript:void(0);" class="add_notes"><img src="https://img.icons8.com/fluent/22/000000/note.png" style="margin-bottom: 4px;" > Add Notes</a>
                                        <div class="notes_left" <?php if(empty($record['notes'])){ echo "style='display:none;'"; } ?> >
                                            <textarea class="form-control" name="c_notes" rows="5" style="padding-right: 25px;" placeholder="Enter Notes"><?php if(isset($record['notes'])){ echo $record['notes']; } ?></textarea>
                                            <button class="remove_notes" type="button" style="top: 8px;" ><img src="https://img.icons8.com/cotton/24/000000/delete-sign--v2.png"/></button>
                                        </div>
                                        </div>
                                        
                                        
                                    </div>
                                    </div>
                                </div>


                                <div class="contact_details">
                                    <div class="container">
                                        <p>Your contact details :</p>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <p>For any enquiry, reach out via email at</p>
                                                <input type="email" name="enquiry_email" value="<?=$this->session->userdata('company_email');?>">
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <p>Or you can call on</p><label style="display: inline; border: 0; border-bottom: 1px solid #ccc;  background-color: transparent; ">+91-</label>
                                                <input type="text" style="width:90%;" name="enquiry_mobile" value="<?=$this->session->userdata('company_mobile');?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="save-btn text-left">
                                        <button type="button" id="btnPayment" onclick="savepayment();" class = "btn btn-primary">Save & Continue</button>
                                        <button type="button" id="btnPaymentCls" style="display:none;">Validating Data...</button>
                                    </div>
                                   
                                </div>

                            </div>
                           
                            
                        </div>

                    </div>

                               
                </div>
            </div>
        </form>
        </div>
        

</div>


        <!--  Add Payment Records Modal -->
        <div class="modal" id="myModal" data-updateid='1' data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
              <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                      <h4 class="modal-title">Record Payment Received</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                        
                  <!-- Modal Body -->
                  
                  <form class="form-horizontal"  id="payment_receipt" method="post" enctype = "multipart/form-data">
                        <div class="modal-body">
                            <?php 
                            $currentDate = date('d-m-Y');
                            echo "<p>Payment Receipt Date: $currentDate</p>";
                            ?>
                            <br> 
                          
                            <input type="hidden" id="autoIncrementField" name="payment_id" class="form-control text-right">

                            <div class="form-group row">
                                <label for="payment_method" class="col-auto">Payment Method<span style="color: #f76c6c;">*</span>:</label>
                                <div class="col-auto ml-auto">
                                    <select class="custom-select custom-select-lg" name="payment_method" id="payment_method" style ="padding-left: ; width:260px">
                                    <option value="" selected disabled hidden>Select Payment</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="upi">UPI</option> 
                                    <option value="cheque"> Cheque </option> 
                                    <option value="other"> Other </option> 
                                    <option value="demand"> Demand Draft </option> 
                                    <option value="digital_wallet"> Digital Wallet </option> 
                                    </select>
                                   
                                </div>
                                <span id="payment_method_error" style="color: #f76c6c;padding-left:210px"></span>
                            </div>

                            <div class="form-group row">
                                <label for="deposited_to" class="col-auto">Deposited To<span style="color: #f76c6c;">*</span>:</label>
                                <div class="col-auto ml-auto">
                                    <div class="custom-select-wrapper">
                                        <div class="custom-select0">


                                            <input type="text" name="deposited_to" id="deposited_to" class="select-button form-control text-right" value="" style="width:260px" placeholder="Select Payment Account">
                                            <!-- <input type="text" id="deposited_to" class="select-button form-control text-right" placeholder="Select Payment Account" value =""> -->

                                            <div class="dropdown-content dropdown_content">
                                        
                                                <button type="button" class="dropdown-button" id="AddNewAccountBtn" style="background-color: blue; color: white; text-align: center; width: 100%; border-radius: 5px;">Add New Payment Account</button>

                                            </div>
                                        </div>
                                    </div>
                                    <span id="deposited_to_error" style="color: #f76c6c;"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount_received" class="col-auto">Amount received <span style="color: #f76c6c;">*</span>:</label>
                                <div class="col-auto ml-auto">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">INR</span>
                                        </div>
                                        <input type="number" name="amount_received" id="amount_received" class="form-control text-right" placeholder="">
                                    </div>
                                    <span id="amount_received_error" style="color: #f76c6c;"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tds" class="col-auto"> TDS (%) </label>
                                <div class="col-auto ml-auto">
                                    <div class="input-group mb-3">
                                        <input type="text" name="tds" id="tds" class="form-control text-right" placeholder="TDS Charges" style="width:260px" >
                                    </div>
                                    <span id="tds_error" style="color: #f76c6c;"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tds_Withheld" class="col-auto"> TDS Withheld </label>
                                <div class="col-auto ml-auto">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">INR</span>
                                        </div>
                                        <input type="number" name="tds_Withheld" id="tds_Withheld" class="form-control text-right" placeholder="">
                                    </div>
                                    <span id="tds_Withheld_error" style="color: #f76c6c;"></span>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="amount_received" class="col-auto">Transaction Charge </label>
                                <div class="col-auto ml-auto">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">INR</span>
                                        </div>
                                        <input type="number" name="transaction_charge" id="transaction_charge" class="form-control text-right" placeholder="">
                                        
                                    </div>
                                    <span id="transaction_charge_error" style="color: #f76c6c;"></span>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-secondary" id="toggleRefIdButton"><i class="fa fa-plus"></i> Ref ID </button> 
                        

                            <div class="form-group row" id="refIdField" style="display: none;">
                                <label for="amount_received" class="col-auto">Ref ID </label>
                                <div class="col-auto ml-auto">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">INR</span>
                                        </div>
                                        <input type="text" name="ref_id" id="ref_id" class="form-control text-right" placeholder="">
                                        
                                    </div>
                                    <span id="ref_id_error" style="color: #f76c6c;"></span>
                                </div>
                            </div>
                                
                            <button type="button" class="btn btn-outline-secondary" id="toggleAdditionalNotesButton"><i class="fa fa-plus"></i> Additional Notes </button>

                            <div class="form-group row" id="additionalNotesField" style="display: none;">
                                <label for="amount_received" class="col-auto">Additional Notes </label>
                                <div class="col-auto ml-auto">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">INR</span>
                                        </div>
                                        <input type="text" name="additional_notes" id="additional_notes" class="form-control text-right" placeholder="">
                                        
                                    </div>
                                    <span id="additional_notes_error" style="color: #f76c6c;"></span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="btn-group mr-auto">
                                <!-- <button type="button" class="btn btn-primary">Save & Continue</button> -->
                                <button type="button" id="btnSave" onclick=" save();">Save</button>
                                
                            
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                  </form>                                 
                  <!-- Modal Footer -->
                 
              </div>
          </div>
        </div>

         <!-- First Select Payment recipt or Clients Advance Modal -->
         <div class="modal" id="myModalpayment">
          <div class="modal-dialog">
              <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                      <h4 class="modal-title">Record New Received</h4>
                      <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                  </div>
                        
                  <!-- Modal Body -->
                  <form class="form-horizontal" id="pym_receipt" method="post" enctype="multipart/form-data">
                      <div class="modal-body">
                          <div class="text-center">
                              <span class="center">Which payment would you like to record?</span>
                          </div>
                          <br>
                          <div class="row justify-content-center">
                                <div class="col text-center">
                                    <div class="card mb-3"> 
                                        <button data-isadvance="false" class="sc-gZMcBi apHCR sc-kGYfcE hbCJxu" type="button" onclick="selectDiv('div1payment')">
                                            <div class="card-body" style="padding: 54px;">
                                                <div class="d-flex flex-column align-items-center">
                                                        <svg width="32" height="32" viewBox="0 0 31 32" fill="none" color="#000" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.75 7H22.75M19 13.75H13.375C12.6788 13.75 12.0111 13.9871 11.5188 14.409C11.0266 14.831 10.75 15.4033 10.75 16C10.75 16.5967 11.0266 17.169 11.5188 17.591C12.0111 18.0129 12.6788 18.25 13.375 18.25H17.125C17.8212 18.25 18.4889 18.4871 18.9812 18.909C19.4734 19.331 19.75 19.9033 19.75 20.5C19.75 21.0967 19.4734 21.669 18.9812 22.091C18.4889 22.5129 17.8212 22.75 17.125 22.75H10.75M15.25 11.5V25M28.7413 2.30147L27.7505 1.75432L26.7466 1.19402C26.5225 1.06712 26.27 1.00048 26.0132 1.00048C25.7564 1.00048 25.5039 1.06712 25.2798 1.19402L24.0683 1.89001C23.8412 2.01725 23.5858 2.084 23.3262 2.084C23.0666 2.084 22.8112 2.01725 22.5841 1.89001L21.3553 1.19402C21.1336 1.06704 20.8831 1.0003 20.6284 1.0003C20.3736 1.0003 20.1232 1.06704 19.9014 1.19402L18.6726 1.89001C18.4517 2.01702 18.2019 2.0838 17.9478 2.0838C17.6937 2.0838 17.444 2.01702 17.2231 1.89001L15.9769 1.19402C15.7534 1.06791 15.5016 1.00171 15.2457 1.00171C14.9897 1.00171 14.738 1.06791 14.5144 1.19402L13.2812 1.89001C13.0572 2.01692 12.8046 2.08355 12.5478 2.08355C12.291 2.08355 12.0385 2.01692 11.8144 1.89001L10.5856 1.19402C10.3639 1.06704 10.1134 1.0003 9.85865 1.0003C9.60388 1.0003 9.35344 1.06704 9.13173 1.19402L7.87692 1.89001C7.6576 2.01709 7.40924 2.08395 7.15649 2.08395C6.90374 2.08395 6.65538 2.01709 6.43606 1.89001L5.16394 1.19402C4.94542 1.0669 4.69775 1 4.44567 1C4.19359 1 3.94593 1.0669 3.7274 1.19402L2.76683 1.72367L1.75 2.30147V29.6726L3.74038 30.7756C3.9621 30.9026 4.21253 30.9694 4.46731 30.9694C4.72208 30.9694 4.97252 30.9026 5.19423 30.7756L6.42308 30.1103C6.65019 29.9831 6.90554 29.9163 7.16514 29.9163C7.42475 29.9163 7.6801 29.9831 7.90721 30.1103L9.13173 30.8063C9.35344 30.9333 9.60388 31 9.85865 31C10.1134 31 10.3639 30.9333 10.5856 30.8063L11.8144 30.1103C12.0361 29.9833 12.2866 29.9166 12.5413 29.9166C12.7961 29.9166 13.0466 29.9833 13.2683 30.1103L14.5144 30.7844C14.7361 30.9114 14.9866 30.9781 15.2413 30.9781C15.4961 30.9781 15.7466 30.9114 15.9683 30.7844L17.2058 30.1103C17.4299 29.9834 17.6824 29.9168 17.9392 29.9168C18.196 29.9168 18.4485 29.9834 18.6726 30.1103L19.9014 30.8063C20.1232 30.9333 20.3736 31 20.6284 31C20.8831 31 21.1336 30.9333 21.3553 30.8063L22.6144 30.1103C22.8309 29.9864 23.0753 29.9213 23.324 29.9213C23.5727 29.9213 23.8172 29.9864 24.0337 30.1103L25.3317 30.7844C25.5511 30.9115 25.7994 30.9783 26.0522 30.9783C26.3049 30.9783 26.5533 30.9115 26.7726 30.7844L28.75 29.6945V2.30147H28.7413Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg> <br>
                                                        <span class="sc-bdVaJa jPnDks">Payment Receipt</span>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <div class="col text-center">
                                    <div class="card mb-3"> 
                                        <button data-isadvance="false" class="sc-gZMcBi apHCR sc-kGYfcE hbCJxu" type="button" onclick="selectDiv('div2payment')">
                                            <div class="card-body" style="padding: 55px;">
                                                <div class="d-flex flex-column align-items-center">
                                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" color="#000" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.7901 6.83763C16.7901 9.49833 14.6354 11.6148 12.0018 11.6148C9.42815 11.6148 7.27344 9.43786 7.27344 6.83763C7.27344 4.17693 9.42815 2 12.0018 2C14.6354 2 16.7901 4.17693 16.7901 6.83763Z" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M2.00454 20.5975C1.94469 21.3292 2.48337 22 3.2016 22H20.7984C21.5166 22 22.0553 21.3292 21.9955 20.5975C21.3371 15.5973 17.0875 11.6946 12 11.6946C6.91249 11.6946 2.66293 15.5973 2.00454 20.5975Z" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg> <br>
                                                    <span class="sc-bdVaJa jPnDks"> Client Advance</span>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                              

                          </div>
                      </div>
                  </form>

                  <!-- Modal Footer -->
                  <div class="modal-footer">
                    <div class="btn-group mr-auto">
                      
                    </div>
                    <div class="btn-group">
                    <button type="button" id="btnSavepayment" onclick="submitForm()">Submit</button>
                    </div>
                  </div>
              </div>
          </div>
        </div>


        <!-- Modal check box-->
        <div class="modal" id="addNewAccountModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
              <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                      <h4 class="modal-title">Add New Payment Account</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>                                    
                  <!-- Modal Body -->
                  <div class="modal-body">
                      <!-- Your form for adding a new payment account goes here -->
                      <form>                                               
                          <div class="form-group">
                              <label>Which account would you like to add?</label>
                              <label class="form-check">
                                  <input type="radio" checked class="form-check-input" name="accountType" value="Bank Account">
                                  <div class="checkmark"></div>
                                  <div>
                                      <span>Bank Account</span>
                                      <p class="text-muted small">All types of bank accounts</p>
                                  </div>
                             </label>
                              <label class="form-check">
                                  <input type="radio" class="form-check-input" name="accountType" value="Employee Account">
                                  <div class="checkmark"></div>
                                  <div>
                                      <span>Employee Account</span>
                                      <p class="text-muted small">Add your employees to manage and track salaries & reimbursements.</p>
                                  </div>
                              </label>
                              <label class="form-check">
                                  <input type="radio" class="form-check-input" name="accountType" value="Other Account">
                                  <div class="checkmark"></div>
                                  <div>
                                      <span>Other Account</span>
                                      <p class="text-muted small">Cash, Debit/Credit cards, UPI, Wallets and more.</p>
                                  </div>
                              </label>
                            </div>                                                  
                      </form>
                  </div>           
                  <!-- Modal Footer -->
                  <div class="modal-footer">
                      <button type="button" class="btn btn-primary" onclick="openConfirmationModal()">Continue</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>       
              </div>
            </div>
        </div>

                            

                                <!-- Confirmation Modal -->
                                <div class="modal" id="confirmationModal" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <!-- Modal Body -->
                                        <form id="bankmyForm">
                                            <div class="modal-body">
                                        
                                                <!-- <p>You have selected:</p> -->
                                                <ul id="selectedAccounts" style="display: none;"></ul>

                                                <!-- Bank Account Confirmation fields -->
                                                <div id="bankAccountConfirmationFields" style="display: none;">
                                                        <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Add New Bank Account</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div><br>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="countryConfirmation">Country<span style="color: #f76c6c;">*</span>:</label>
                                                            <select class="form-control" id="countryConfirmation" name ="countryConfirmation">
                                                                <option value="india">INDIA</option>
                                                                <!-- Add more currency options as needed -->
                                                            </select>
                                                            <span id="country_error" style="color: #f76c6c;"></span>
                                                        
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="bankNameConfirmation">Bank Name<span style="color: #f76c6c;">*</span>:</label>
                                                            <input type="text" class="form-control" id="bankNameConfirmation" name = "bankNameConfirmation">
                                                        </div>
                                                        <span id="bankname_error" style="color: #f76c6c;"></span>
                                                    </div>
                                                
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="accountNumberConfirmation">Account Number<span style="color: #f76c6c;">*</span>:</label>
                                                            <input type="text" class="form-control" id="accountNumberConfirmation" name = "accountNumberConfirmation">
                                                        </div>
                                                        <span id="accountnumber_error" style="color: #f76c6c;"></span>
                                                        <div class="form-group col-md-6">
                                                            <label for="confirmAccountNumberConfirmation">Confirm Account Number<span style="color: #f76c6c;">*</span>:</label>
                                                            <input type="text" class="form-control" id="confirmAccountNumberConfirmation" name = "confirmAccountNumberConfirmation">
                                                        </div>
                                                        <span id="confirmaccountnumber_error" style="color: #f76c6c;"></span>
                                                    </div>
                                                    
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="ifscCodeConfirmation">IFSC Code<span style="color: #f76c6c;">*</span>:</label>
                                                            <input type="text" class="form-control" id="ifscCodeConfirmation" name = "ifscCodeConfirmation">
                                                        </div>
                                                        <span id="ifsc_error" style="color: #f76c6c;"></span>
                                                        <div class="form-group col-md-6">
                                                            <label for="accountHolderNameConfirmation">Account Holder Name<span style="color: #f76c6c;">*</span>:</label>
                                                            <input type="text" class="form-control" id="accountHolderNameConfirmation" name = "accountHolderNameConfirmation">
                                                        </div>
                                                        <span id="accountholder_error" style="color: #f76c6c;"></span>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="bankAccountTypeConfirmation">Bank Account Type<span style="color: #f76c6c;">*</span>:</label>
                                                            <select class="form-control" id="bankAccountTypeConfirmation" name = "bankAccountTypeConfirmation">
                                                                <option value="Savings">Savings</option>
                                                                <option value="Current">Current</option>
                                                            </select>
                                                            <span id="bankaccounttype_error" style="color: #f76c6c;"></span>
                                                        
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="currencyConfirmation">Currency<span style="color: #f76c6c;">*</span>:</label>
                                                            <select class="form-control" id="currencyConfirmation" name = "currencyConfirmation">
                                                                <option value="INR">INR</option>
                                                            </select>
                                                            <span id="currency_error" style="color: #f76c6c;"></span>
                                                        </div>
                                                    </div>
                                                

                                                    <div class = "form-row">
                                                        <div class="form-group col-md-6">
                                                        <button type="button" class="btn btn-outline-secondary" id="swiftcodeButton"><i class="fa fa-plus"></i>  Add SWIFT Code </button> 
                                                                

                                                                <div class="form-group row" id="swiftcodeField" style="display: none;">
                                                                    <label for="amount_received" class="col-auto">Add SWIFT Code:  </label>
                                                                    <div class="col-auto ml-auto">
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="swift_id" id="swift_id" class="form-control text-right" placeholder="">
                                                                            
                                                                        </div>
                                                                        <span id="swift_id_error" style="color: #f76c6c;"></span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group col-md-6">

                                                                <button type="button" class="btn btn-outline-secondary" id="ibancodeButton"><i class="fa fa-plus"></i> Add IBAN Code </button> 
                                                                

                                                                <div class="form-group row" id="ibancodeField" style="display: none;">
                                                                    <label for="amount_received" class="col-auto"> Add IBAN Code: </label>
                                                                    <div class="col-auto ml-auto">
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="iban" id="iban" class="form-control text-right" placeholder="">
                                                                            
                                                                        </div>
                                                                        <span id="iban_error" style="color: #f76c6c;"></span>
                                                                    </div>
                                                                </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            


                                                <!-- Employee Account Confirmation fields -->
                                                <div id="employeeAccountConfirmationFields" style="display: none;">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                            <h4 class="modal-title">Employee Account<span style="color: #f76c6c;">*</span>:</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div><br>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="countryConfirmation">Country<span style="color: #f76c6c;">*</span>:</label>
                                                            <select class="form-control" id="country_employee" name ="country_employee">
                                                                <option value="india">INDIA</option>
                                                            
                                                            </select>
                                                        
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="employeeNameConfirmation">Employee Name<span style="color: #f76c6c;">*</span>:</label>
                                                            <input type="text" class="form-control" id="employee_name" name = "employeeName">
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="departmentConfirmation">Department<span style="color: #f76c6c;">*</span>:</label>
                                                            <input type="text" class="form-control" id="department_employee" name = "department_employee">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="countryConfirmation">Currency<span style="color: #f76c6c;">*</span>:</label>
                                                            <select class="form-control" id="currency_employee" name = "currency_employee">
                                                                <option value="inr">INR</option>
                                                            </select>
                                                        
                                                        </div>
                                                    </div>

                                                    <div class = "form-row">
                                                        <div class="form-group col-md-6">
                                                        <button type="button" class="btn btn-outline-secondary" id="AddLevelButton"><i class="fa fa-plus"></i> Add Level </button> 
                                                                
                                                                <div class="form-group row" id="AddLevelField" style="display: none;">
                                                                    <label for="amount_received" class="col-auto">  Add Level:</label>
                                                                    <div class="col-auto ml-auto">
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="level" id="level" class="form-control text-right" placeholder="">
                                                                            
                                                                        </div>
                                                                        <span id="level_error" style="color: #f76c6c;"></span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group col-md-6">

                                                                <button type="button" class="btn btn-outline-secondary" id="EmployeeIdButton"><i class="fa fa-plus"></i> Add Employee Id</button> 
                                                                

                                                                <div class="form-group row" id="EmployeeIdField" style="display: none;">
                                                                    <label for="amount_received" class="col-auto"> Add Employee Id : </label>
                                                                    <div class="col-auto ml-auto">
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="employee_Id" id="employee_Id" class="form-control text-right" placeholder="">
                                                                            
                                                                        </div>
                                                                        <span id="employee_Id_error" style="color: #f76c6c;"></span>
                                                                    </div>
                                                                </div>
                                                        </div>

                                                    </div>

                                                    <div class = "form-row">
                                                        <div class="form-group col-md-6">
                                                        <button type="button" class="btn btn-outline-secondary" id="PhoneNumberButton"><i class="fa fa-plus"></i> Add Phone Number</button> 
                                                                

                                                                <div class="form-group row" id="PhoneNumberField" style="display: none;">
                                                                    <label for="amount_received" class="col-auto"> Add Phone Number:</label>
                                                                    <div class="col-auto ml-auto">
                                                                        <div class="input-group mb-3">
                                                                        <div class="input-group-append">
                                                                                    <span class="input-group-text"><i class="fa fa-flag"></i></span>
                                                                                </div>
                                                                            <input type="text" name="phone_number" id="phone_number" class="form-control text-right" placeholder="">
                                                                            
                                                                        </div>
                                                                        <span id="phone_number_error" style="color: #f76c6c;"></span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    

                                                    </div>


                                                </div>
                                            
                                                <!-- Other Account Confirmation fields -->
                                                <div id="otherAccountConfirmationFields" style="display: none;">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Other Account</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div><br>

                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="accountNameConfirmation">Account Name<span style="color: #f76c6c;">*</span>:</label>
                                                                <input type="text" class="form-control" id="accountName_other" name = "accountName_other">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="accounttypeConfirmation">Account Type<span style="color: #f76c6c;">*</span>:</label>
                                                                <select class="form-control" id="accounttype_other" name = "accounttype_other">
                                                                    <option value="" selected disabled hidden>Select Payment</option>
                                                                    <option value="Credit Card">Credit Card</option>
                                                                    <option value="Debit Card">Debit Card</option>
                                                                    <option value="Cash">Cash</option>
                                                                    <option value="Bank Transfer">Bank</option>
                                                                    <option value="upi">UPI</option> 
                                                                    <option value="cheque"> Employee </option> 
                                                                    <option value="demand"> Payment Gateway </option> 
                                                                    <option value="digital_wallet"> Digital Caed </option>
                                                                    <option value="other"> Other </option>  
                                                                </select>
                                                                <span id="accounttype_error" style="color: #f76c6c;"></span>
                                                                
                                                            
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <!-- <div class="form-group col-md-6">
                                                                <label for="departmentConfirmation">Department:</label>
                                                                <input type="text" class="form-control" id="departmentConfirmation">
                                                            </div> -->
                                                            <div class="form-group col-md-6">
                                                                <label for="countryConfirmation">Currency<span style="color: #f76c6c;">*</span>:</label>
                                                                <select class="form-control" id="currency_other" name = "currency_other">
                                                                    <option value="">Select Currency</option>
                                                                    <option value="inr">INR</option>
                                                                </select>
                                                            
                                                            </div>
                                                        </div>

                                                        <div class = "form-row">
                                                        <div class="form-group col-md-6">
                                                        <button type="button" class="btn btn-outline-secondary" id="LinkBankAccountButton"><i class="fa fa-plus"></i>  Link Bank Account </button> 
                                                                

                                                                <div class="form-group row" id="LinkBankAccountField" style="display: none;">
                                                                    <label for="amount_received" class="col-auto"> Link Bank Account:</label>
                                                                    <div class="col-auto ml-auto">
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="link_bank" id="link_bank" class="form-control text-right" placeholder="">
                                                                            
                                                                        </div>
                                                                        <span id="link_bank_error" style="color: #f76c6c;"></span>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="form-group col-md-6">

                                                                <button type="button" class="btn btn-outline-secondary" id="LinkEmployeeAccountButton"><i class="fa fa-plus"></i>Link Employee Account</button> 
                                                                

                                                                <div class="form-group row" id="LinkEmployeeAccountField" style="display: none;">
                                                                    <label for="amount_received" class="col-auto"> Link Employee Account : </label>
                                                                    <div class="col-auto ml-auto">
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" name="link_employee_account" id="link_employee_account" class="form-control text-right" placeholder="">
                                                                            
                                                                        </div>
                                                                        <span id="link_employee_account_error" style="color: #f76c6c;"></span>
                                                                    </div>
                                                                </div>
                                                        </div>

                                                    </div>


                                                    </div>
                                                </div>
                                            
                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                </div>
                                            
                                            </div>
                                        </form>
                                    </div>
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

 <!-- < ------------------------------------------------------------ Payment receipt ------------------------------------------------------------------------------ > -->

<script>

    //add notes
	$('.add_notes').click(function() {   
	    $('.add_notes').hide();
		$('.notes_left').show();
	});
	$('.remove_notes').click(function() {   
	    $('.add_notes').show();
		$('.notes_left').hide();
		$('[name="notes"]').val(function() {
        return this.defaultValue;
        });
	});
</script>

<script>

    // Function to open the confirmation modal
    function openConfirmationModal() {
        var selectedAccountType = $('input[name="accountType"]:checked').val();
        $('#selectedAccounts').text(selectedAccountType);

        if (selectedAccountType === "Bank Account") {
            $('#bankAccountConfirmationFields').show();
            $('#employeeAccountConfirmationFields').hide();
            $('#otherAccountConfirmationFields').hide();
        } else if (selectedAccountType === "Employee Account") {
            $('#bankAccountConfirmationFields').hide();
            $('#employeeAccountConfirmationFields').show();
            $('#otherAccountConfirmationFields').hide();
        } else if (selectedAccountType === "Other Account") {
            $('#bankAccountConfirmationFields').hide();
            $('#employeeAccountConfirmationFields').hide();
            $('#otherAccountConfirmationFields').show();
            }
            $('#confirmationModal').modal('show');
               
    }

            $(document).ready(function(){
                    $('#bankmyForm').submit(function(e){
                        var selectedAccountType = $('input[name="accountType"]:checked').val();
                        e.preventDefault();
                        var url = '';
                        if (selectedAccountType === "Bank Account") {
                            url = '<?= site_url('Accounting/save_bank_data') ?>';
                        } else if (selectedAccountType === "Employee Account") {
                            url = '<?= site_url('Accounting/save_employee_data') ?>';
                        } else if (selectedAccountType === "Other Account") {
                            url = '<?= site_url('Accounting/save_other_data') ?>';
                        }

                        var formData = $(this).serialize();
                
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response){
                                console.log(response);
                                    if (response.success) {
                                        
                                        save_Payment_ReceiptDetails_Data();
                                        
                                        toastr.success(response.message);
                                        $('#confirmationModal').modal('hide');
                                        $('#addNewAccountModal').modal('hide');
                          
                                    } else {
                                    
                                        toastr.error(response.message);
                                        // $('#confirmationModal').modal('hide');
                                        // $('#addNewAccountModal').modal('hide');
                                    }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                    toastr.error('An error occurred while saving data.');
                                    console.error('AJAX Error:', textStatus, errorThrown);
                                }
                        });
                        
                    });
                });


        // Show the confirmation modal
       
    $(document).ready(function() {
    // Load bank data when the page loads
    save_Payment_ReceiptDetails_Data();
    $(document).on('click', '#AddNewAccountBtn', function() {
        // Open the modal when the button is clicked
        // Replace 'modalId' with the actual ID of your modal
        $('#addNewAccountModal').modal('show'); 
    });
    
    });

function save_Payment_ReceiptDetails_Data() {
    $.ajax({
        url: '<?= site_url('Accounting/Bank_Data') ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                var bankData = response.bank_data;
                var dropdownContent = $('.dropdown_content');
                dropdownContent.empty(); // Clear existing buttons

                // Loop through the data and append options for bank accounts
                $.each(bankData, function(index, bankItem) {
                    var accountNumber = bankItem.account_number;
                    var lastFourDigits = accountNumber.slice(-4);
                    var BankAttribute = bankItem.bank_name + '-' + lastFourDigits;
                    var empAttribute = bankItem.employeeName;
                    var otherAttribute = bankItem.accountName_other;
                    

                    if (bankItem.bank_name) {
                        dropdownContent.append('<button data-name="' + BankAttribute + '" class="dropdown-button">' + bankItem.bank_name + ' ' + lastFourDigits + '</button>'); 
                    }

                    if (bankItem.employeeName) {
                        dropdownContent.append('<button data-name="' + "Employee - " + empAttribute + '" class="dropdown-button">' + 'Employee - ' + bankItem.employeeName + '</button>');
                    }

                    if (bankItem.accountName_other) {
                        dropdownContent.append('<button data-name="' + otherAttribute + '" class="dropdown-button" >' + bankItem.accountName_other + '</button>');
                    }
                    deposit_to_box();
                });

         
                // Append the "Add New Payment Account" button at the end of the dropdown
                dropdownContent.append($('<button>', {
                    type: 'button',
                    class: 'dropdown-button',
                    id: 'AddNewAccountBtn',
                    style: 'background-color: blue; color: white; text-align: center; width: 100%; border-radius: 5px;',
                    text: 'Add New Payment Account',
                    click: function() {
                        // Handle the click event for the button if needed
                    }
                }));
            } else {
                console.log('Error fetching bank data: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching Bank Details data:', error);
        }
    });
}
function deposit_to_box(){
    setTimeout(function(){
        $(".dropdown-button").each(function(){
          
        $(this).click(function(e){
            e.preventDefault();

          
            $('#deposited_to').val($(this).data('name'));
            $('.dropdown_content').hide(); 
        })
    })
      
    },500);
  
}
deposit_to_box();

    document.addEventListener("DOMContentLoaded", function() {
        var selectButton = document.querySelector('.select-button');
        var dropdownContent = document.querySelector('.dropdown-content');

        selectButton.addEventListener('click', function() {
            dropdownContent.style.display = (dropdownContent.style.display === 'block') ? 'none' : 'block';
        });

        var dropdownButtons = document.querySelectorAll('.dropdown-button');
        dropdownButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                selectButton.textContent = button.textContent;
                dropdownContent.style.display = 'none';
            });
        });
    });
</script>

 
 <script>
   var editor = CKEDITOR.replace( 'descriptionTxt' );
   CKEDITOR.config.height='100px';
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

<script>
   $(document).ready(function(){
     $(".add_row").click(function()
     {
       var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
       "<td width='24%'><input name='fieldname_batch[]' id='fieldname_batch' class='form-control ' type='text' placeholder='Field Name'></td>"+
       "<td width='24%'><input name='value_batch[]' id='value_batch' class='form-control ' type='text' placeholder='Value'></td>";
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
 
// open 1. Select client withouth click
 $(document).ready(function() {
        $('#faq1').collapse('show');
    });
// payment option modal
  $(document).ready(function(){
    $('#myModalpayment').modal({
      backdrop: 'static',
      keyboard: false
    });
    
    $("#btnSavepayment").click(function() {
      $('#myModalpayment').modal('hide');
    });
  });

// for refIdField clickable
document.getElementById('toggleRefIdButton').addEventListener('click', function() { 
    var refIdField = document.getElementById('refIdField');
    var toggleRefIdButton = document.getElementById('toggleRefIdButton');
    
    refIdField.style.display = 'block';
    toggleRefIdButton.style.display = 'none';
});

// for additionalNotesField clickable
document.getElementById('toggleAdditionalNotesButton').addEventListener('click', function() {
    var additionalNotesField = document.getElementById('additionalNotesField');
    var toggleAdditionalNotesButton = document.getElementById('toggleAdditionalNotesButton');
    
    additionalNotesField.style.display = 'block';
    toggleAdditionalNotesButton.style.display = 'none';
});


// for swiftcodeButton clickable
document.getElementById('swiftcodeButton').addEventListener('click', function() { 
    var refIdField = document.getElementById('swiftcodeField');
    var swiftcodeButton = document.getElementById('swiftcodeButton');
    
    swiftcodeField.style.display = 'block';
    swiftcodeButton.style.display = 'none';
});


// for ibancodeButton clickable
document.getElementById('ibancodeButton').addEventListener('click', function() { 
    var refIdField = document.getElementById('ibancodeField');
    var ibancodeButton = document.getElementById('ibancodeButton');
    
    refIdField.style.display = 'block';
    ibancodeButton.style.display = 'none';
});

// for AddLevelButton clickable
document.getElementById('AddLevelButton').addEventListener('click', function() { 
    var refIdField = document.getElementById('AddLevelField');
    var AddLevelButton = document.getElementById('AddLevelButton');
    
    refIdField.style.display = 'block';
    AddLevelButton.style.display = 'none';
});

// for EmployeeIdButton clickable
document.getElementById('EmployeeIdButton').addEventListener('click', function() { 
    var refIdField = document.getElementById('EmployeeIdField');
    var EmployeeIdButton = document.getElementById('EmployeeIdButton');
    
    refIdField.style.display = 'block';
    EmployeeIdButton.style.display = 'none';
});


// for PhoneNumberButton clickable
document.getElementById('PhoneNumberButton').addEventListener('click', function() { 
    var refIdField = document.getElementById('PhoneNumberField');
    var PhoneNumberButton = document.getElementById('PhoneNumberButton');
    
    refIdField.style.display = 'block';
    PhoneNumberButton.style.display = 'none';
});

// for LinkBankAccountButton clickable
document.getElementById('LinkBankAccountButton').addEventListener('click', function() { 
    var refIdField = document.getElementById('LinkBankAccountField');
    var LinkBankAccountButton = document.getElementById('LinkBankAccountButton');
    
    refIdField.style.display = 'block';
    LinkBankAccountButton.style.display = 'none';
});


// for LinkEmployeeAccountButton clickable
document.getElementById('LinkEmployeeAccountButton').addEventListener('click', function() { 
    var refIdField = document.getElementById('LinkEmployeeAccountField');
    var LinkEmployeeAccountButton = document.getElementById('LinkEmployeeAccountButton');
    
    refIdField.style.display = 'block';
    LinkEmployeeAccountButton.style.display = 'none';
});





        // tds (%) calculatuion based on amount received
        document.addEventListener("DOMContentLoaded", function() {
            var amountReceivedInput = document.getElementById("amount_received");
            var tdsInput = document.getElementById("tds");
            var tdsWithheldInput = document.getElementById("tds_Withheld");
            amountReceivedInput.addEventListener("input", function() {
                calculateTDSWithheld();
            });

            tdsInput.addEventListener("input", function() {
                calculateTDSWithheld();
            });

            function calculateTDSWithheld() {
                var amountReceived = parseFloat(amountReceivedInput.value);
                var tdsPercentage = parseFloat(tdsInput.value);
                if (!isNaN(amountReceived) && !isNaN(tdsPercentage)) {
                    var tdsWithheld = (amountReceived * tdsPercentage) / 100;
                    tdsWithheldInput.value = tdsWithheld.toFixed(2); // Limiting to 2 decimal places
                } else {
                    tdsWithheldInput.value = ''; // Reset value if inputs are not valid
                }
            }
        });

  

        var paymentIdCount = 0;
        var isModalOpened = false;

        function autoIncrementPaymentId() {
            $('#autoIncrementField').val(paymentIdCount++);
        }
        $("#addpaymentbtn").click(function(){
            $('#autoIncrementField').val(paymentIdCount++);
             $("#myModal").data('updateid',paymentIdCount);
        })

        $('#myModal').on('shown.bs.modal', function () {
            if (!isModalOpened) {
               
                isModalOpened = true;
            }
        });


    function save() {
        var deposited_to = $('#deposited_to').val().trim();
        // alert(deposited_to)
        var payment_method = $('#payment_method').val();
        var amount_received = $('#amount_received').val().trim();
        var updateid = $("#myModal").data('updateid');
        
        

        if (!payment_method) {
            $('#payment_method_error').text('Please select a payment method.');
            return;
        } else {
            $('#payment_method_error').text('');
        }

        if (!deposited_to) {
            $('#deposited_to_error').text('Please select a deposited account.');
            return;
        } else {
            $('#deposited_to_error').text('');
        }

        if (amount_received === '') {
            $('#amount_received_error').text('Amount received field is required.');
            return;
        } else {
            $('#amount_received_error').text('');
        }

        $('#btnSave').hide();
        $('#btnSaveCls').show();

        var paymentData = {
            autoNumberField: paymentIdCount,
            deposited_to: deposited_to,
            payment_method: payment_method,
            amount_received: amount_received,
            ref_id: $('#ref_id').val(),
            transaction_charge: $('#transaction_charge').val(),
            tds_Withheld: $('#tds_Withheld').val(),
            tds: $('#tds').val(),
            additional_notes: $('#additional_notes').val()
        };

        // Determine whether to save or update based on payment method
        var url =  '<?= site_url('Accounting/save_payment_data') ?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: paymentData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    addPaymentRow(paymentData,updateid);
                } else {
                    toastr.error(response.message);
                }

                updateTotals();
                $('#payment_receipt')[0].reset();
                $('#myModal').modal('hide');
                Clients_org();
                $('#btnSaveCls').hide();
                $('#btnSave').show();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error('An error occurred while saving data.');
                console.error('AJAX Error:', textStatus, errorThrown);
                $('#btnSaveCls').hide();
                $('#btnSave').show();
            }
        });

        updateTotals();
        $('#payment_receipt')[0].reset();
        $('#myModal').modal('hide');
        Clients_org();
        $('#btnSaveCls').hide();
        $('#btnSave').show();
}



        function addPaymentRow(paymentData, updateid=1) {
            var paymentTableBody = $('#paymentListing tbody');
             var autoNumberContent = $('#paymentListing tbody tr:nth-child(' + updateid + ') td:first-child').text();
                console.log(autoNumberContent+ " => "+updateid);
                if (autoNumberContent == updateid) {
                
                        var paymentRow = 
                            '<td style="display: none;">' + updateid + '</td>' +
                            '<td>' + paymentData.deposited_to + '</td>' +
                            '<td>' + paymentData.payment_method + '</td>' +
                            '<td class="amount-received">' + paymentData.amount_received + '</td>' +
                            '<td>' + paymentData.tds + '</td>' +
                            '<td class="transaction-charge">' + paymentData.transaction_charge + '</td>' +
                            '<td class="tds-withheld">' + paymentData.tds_Withheld + '</td>' +
                            '<td>' + paymentData.ref_id + '</td>' +
                            '<td style="display: none;">' + paymentData.additional_notes + '</td>' +
                            '<td>' +
                            '<a href="#" class="editBtn"><i class="far fa-edit sub-icn-so m-1"></i></a>' +
                            '<a href="#" class="deleteBtn"><i class="far fa-trash-alt text-danger m-1"></i></a>' +
                            '</td>';

                            $('#paymentListing tbody tr:nth-child(' + updateid + ')').html(paymentRow); 
                            toastr.success('Payment data Updated successfully.');
                    
                } else {
                
                    var paymentRow = '<tr>' +
                            '<td style="display: none;">' + paymentData.autoNumberField + '</td>' +
                            // <td style="display: none;">' + paymentData.autoNumberField + '</td> +

                            '<td>' + paymentData.deposited_to + '</td>' +
                            '<td>' + paymentData.payment_method + '</td>' +
                            '<td class="amount-received">' + paymentData.amount_received + '</td>' +
                            '<td>' + paymentData.tds + '</td>' +
                            '<td class="transaction-charge">' + paymentData.transaction_charge + '</td>' +
                            '<td class="tds-withheld">' + paymentData.tds_Withheld + '</td>' +
                            '<td>' + paymentData.ref_id + '</td>' +
                            '<td style="display: none;">' + paymentData.additional_notes + '</td>' +
                            '<td>' +
                            '<a href="#" class="editBtn"><i class="far fa-edit sub-icn-so m-1"></i></a>' +
                            '<a href="#" class="deleteBtn"><i class="far fa-trash-alt text-danger m-1"></i></a>' +
                            '</td>' +
                            '</tr>';
                            paymentTableBody.append(paymentRow);
                            toastr.success('Payment data added successfully.');
                            
                    $('#autoIncrementField').val(paymentData.autoNumberField++);

                }
        }






            var globalTotalAmountReceived = 0;
            var globalTotalTransactionCharge = 0;
            var globalTotalTds = 0;
        
        function updateTotals() {
            var totalAmountReceived = 0;
            var totalTransactionCharge = 0;
            var totalTds = 0;

            $('#paymentListing .amount-received').each(function() {
                totalAmountReceived += parseFloat($(this).text()) || 0;
            });

            $('#paymentListing .transaction-charge').each(function() {
                totalTransactionCharge += parseFloat($(this).text()) || 0;
            });

            $('#paymentListing .tds-withheld').each(function() {
                totalTds += parseFloat($(this).text()) || 0;
            });


                // Update global variables
            globalTotalAmountReceived = totalAmountReceived;
            globalTotalTransactionCharge = totalTransactionCharge;
            globalTotalTds = totalTds;

            // Display the updated totals
            $('#totalAmountReceived').text(totalAmountReceived.toFixed(2));
            $('#totalTransactionCharge').text(totalTransactionCharge.toFixed(2));
            $('#totalTds').text(totalTds.toFixed(2));
        }

        $(document).on('click', '.editBtn', function() {
            var row = $(this).closest('tr');
            var autoNumberField = row.find('td:nth-child(1)').text();
            var deposited_to = row.find('td:nth-child(2)').text();
            var payment_method = row.find('td:nth-child(3)').text();
            var amount_received = row.find('.amount-received').text();
            var tds = row.find('td:nth-child(5)').text();
            var tds_Withheld = row.find('.tds-withheld').text();
            var transaction_charge = row.find('.transaction-charge').text();
            var ref_id = row.find('td:nth-child(8)').text();
            var additional_notes = row.find('td:nth-child(9)').text();
            // alert(autoNumberField)
             
            // Populate the form fields with the row data for editing
            $('#autoIncrementField').val(autoNumberField);
            $('#deposited_to').val(deposited_to);
            $('#payment_method').val(payment_method);
            $('#amount_received').val(amount_received);
            $('#tds').val(tds);
            $('#tds_Withheld').val(tds_Withheld);
            $('#transaction_charge').val(transaction_charge);
            $('#ref_id').val(ref_id);
            $('#additional_notes').val(additional_notes);
           $("#myModal").data('updateid',autoNumberField);
           console.log($("#myModal").data('updateid')+'=>'+autoNumberField);
           
            // Open the modal for editing
            $('#myModal').modal('show');
        });

        
    //  client side payment receipt modal all process
    $(document).ready(function() {
        $('#paymentListing').on('click', '.deleteBtn', function(event) {
            event.preventDefault(); 
            var row = $(this).closest('tr'); 
            row.remove(); 
            updateTotals();
        });

    });


    // plugins used for search org
    $(function(){
        //$('#customer_name').searchableSelect();
        $("#org_clients").select2();
  
    });
        // Function to fetch Clients Name to organization table  
        function Clients_org() {
        $.ajax({
            url: '<?= site_url('Accounting/fetch_Clients_org_data') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    var selectElement = $('#org_clients'); 
                    selectElement.empty(); 
                    
                    selectElement.append($('<option>', {
                        value: '',
                        text: 'Select Clients'
                    }));
                    
                    // Append options for each client
                    $.each(data, function(index, clientOrgData) {
                        selectElement.append($('<option>', {
                            value: clientOrgData.id, 
                            text: clientOrgData.org_name 
                        }));
                    });
                    
                } else {
                    // If no data is found, display a message
                    $('#org_clients').html('<option value="">No clients found</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching client organization data:', error);
            }
        });
        }

        // Initial call to fetch Clients data when the page loads
        Clients_org();



$(document).ready(function() {
    $('#invoice_no_select').change(function() {
        var InvoiceId = $(this).val();

        if (!InvoiceId) {
            $('#invoicesTable tbody').html('<tr><td colspan="10">Please select a client to view invoices.</td></tr>');
            return;
        }

         // AJAX request to fetch data based on the selected client ID
        $.ajax({
            url: '<?php echo site_url('Accounting/fetch_invoices_data') ?>',
            type: 'POST',
            dataType: 'json',
            data: { id: InvoiceId },
            success: function(response) {
                // console.log('Total Amount Received:', globalTotalAmountReceived, 'Transaction Charge:', globalTotalTransactionCharge, 'TDS:', globalTotalTds);
               
                if (response.status === 'success') {
                    var invoice = response.invoices;
                    // alert(invoices)
                    var tableContent = '';
                    var totalSubTotal_ino = 0;
                    var totalpending_payment = 0;
                    var totalSubTotal_due = 0; 
                    
                        var dueTotal = parseFloat(invoice.pending_payment) - parseFloat(globalTotalAmountReceived);
                        totalSubTotal_ino += parseFloat(invoice.sub_total);
                        totalpending_payment += parseFloat(invoice.pending_payment);
                        totalSubTotal_due += dueTotal;

                        tableContent += '<tr>' +
                                            '<td>' + invoice.invoice_no + '</td>' +
                                            '<td>' + invoice.invoice_date + '</td>' +
                                            '<td>' + parseFloat(invoice.sub_total).toFixed(2) + '</td>' +
                                            '<td>' + parseFloat(invoice.pending_payment).toFixed(2) + '</td>' +
                                            '<td>' + parseFloat(globalTotalAmountReceived).toFixed(2) + '</td>' +
                                            '<td>' + parseFloat(globalTotalTransactionCharge).toFixed(2) + '</td>' +
                                            '<td>' + parseFloat(globalTotalTds).toFixed(2) + '</td>' +
                                            '<td>' + parseFloat(globalTotalAmountReceived).toFixed(2) + '</td>' +
                                            '<td>' + dueTotal.toFixed(2) + '</td>' +
                                        '</tr>';
                    

                    $('#invoicesTable tbody').html(tableContent);

                    // Display aggregated totals
                    $('#totalSubTotal_i').text(totalSubTotal_ino.toFixed(2));
                    $('#totalSubTotal_due_i').text(totalpending_payment.toFixed(2));
                    $('#totalAmountReceived_i').text(parseFloat(globalTotalAmountReceived).toFixed(2));
                    $('#totalTransactionCharge_i').text(parseFloat(globalTotalTransactionCharge).toFixed(2));
                    $('#totalTds_i').text(parseFloat(globalTotalTds).toFixed(2));
                    $('#totalAmountReceived_settle_i').text(parseFloat(globalTotalAmountReceived).toFixed(2));
                    $('#totalDue_i').text(totalSubTotal_due.toFixed(2));
                } else {
                    $('#invoicesTable tbody').html('<tr><td colspan="10">No invoices found or an error occurred.</td></tr>');
                }
            },
            error: function() {
                // If AJAX call fails
                $('#invoicesTable tbody').html('<tr><td colspan="10">Failed to retrieve data. Please try again.</td></tr>');
            }
        });
    });

});


//< ----------------- option payment receipt and Client advance ---------------------->
    var selectedDivId = null;
    function selectDiv(divId) {
        selectedDivId = divId;
    }

    function submitForm() {
            if (selectedDivId !== null) {
                var selectedDiv = document.getElementById(selectedDivId);
                var allDivs = document.querySelectorAll('.selectedDiv');
                
                allDivs.forEach(function(div) {
                    div.style.display = 'none';
                });
                selectedDiv.style.display = 'block';

                
                    if (selectedDivId === 'div1payment') {
                    
                        document.getElementById('invoice_no_select').style.display = 'block'; 
                        document.getElementById('invoicehide').style.display = 'block'; 
                        document.getElementById('pi_invoice_no_select').style.display = 'none';
                        document.getElementById('piinvoicehide').style.display = 'none';

                        
                            // invoices number data fetch
                            $(document).ready(function() {
                                // Function to handle change event of the select box
                                $('#org_clients').change(function() {
                                    var selectedClientId = $(this).val();
                                    if (!selectedClientId) {
                                        return;
                                    }



                                    $.ajax({
                                        url: '<?= site_url('Accounting/fetch_invoices_OnClients_id_data') ?>',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: { clientId: selectedClientId },

                                        success: function(response) {
                                            if (response.status === 'success') {
                                                var invoices = response.invoices;
                                                $('#invoice_no_select').empty();
                                                if (invoices.length > 0) {
                                                    $('#invoice_no_select').append('<option value=""> Select invoices</option>');

                                                    $.each(invoices, function(index, invoice) {

                                                        $('#invoice_no_select').append('<option value="' + invoice.id + '">' + invoice.invoice_no + '</option>');
                                                        $('#clientbtn').hide();
                                                    });
                                                } else {
                                                   
                                                    $('#invoice_no_select').html('<option value="">No invoices found</option>');
                                                }
                                            } else {
                                                $('#invoice_no_select').html('<option value="">No invoices found</option>');
                                                $('#clientbtn').show();
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error fetching invoices:', error);
                                        }
                                    });

                                });

                            });
                    } else if (selectedDivId === 'div2payment') {
                    
                        document.getElementById('invoice_no_select').style.display = 'none';
                        document.getElementById('invoicehide').style.display = 'none';
                        document.getElementById('pi_invoice_no_select').style.display = 'block';
                        document.getElementById('piinvoicehide').style.display = 'block';

                        // Po invoices number data fetch
                            $(document).ready(function() {
                                $('#org_clients').change(function() {
                                    var selectedClientId = $(this).val();
                                    if (!selectedClientId) {
                                        return;
                                    }
                                    
                                    $.ajax({
                                        url: '<?= site_url('Accounting/fetch_pi_invoices_OnClients_id_data') ?>', 
                                        type: 'POST', 
                                        dataType: 'json', 
                                        data: { clientId: selectedClientId },
                                        success: function(response) {
                                            if (response.status === 'success') {
                                                var PIinvoicesData = response.PIinvoicesData;
                                                $('#pi_invoice_no_select').empty();
                                                if (PIinvoicesData.length > 0) {
                                                    $('#pi_invoice_no_select').append('<option value=""> Select PI </option>');

                                                $.each(PIinvoicesData, function(index, invoice) {
                                                    $('#pi_invoice_no_select').append('<option value="' + invoice.id + '">' + invoice.invoice_no + '</option>');
                                                });
                                            }else{
                                                
                                                    $('#pi_invoice_no_select').html('<option value="">No invoices found</option>');
                                                }
                                            } else {
                                                // Handle scenarios where the status is not 'success'
                                                $('#pi_invoice_no_select').html('<option value="">No invoices found</option>');
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            // Handle errors from AJAX request
                                            console.error('Error fetching invoices:', error);
                                        }
                                    });
                                });

                            });
                    }
            } else {
                console.log("No div is selected");
            }
    }
// <--------------------- end payment receipt and client advance ------------------------------>




    function savepayment() {
        
        if ($('#org_clients').val() === '') {
            toastr.error('Please Select Organization Name.');
            return;
        }

        if ($('#invoice_no_select').val() === '') {
            toastr.error('Please Select Invoice Number.');
            return;
        }

        if ($('#paymentListing tbody tr').length === 0) {
            toastr.error('Please Fill Payment Receipt Details.');
            return;
        }

        toastr.info('Please wait while we are processing your request');
        $('#btnPayment').hide();
        $('#btnPaymentCls').show();
                
        var url = "<?= site_url('Accounting/add_payment')?>";   

        // Include global variables in the data object
        var formData = $('#form_payment').serialize();
        formData += '&globalTotalAmountReceived=' + encodeURIComponent(globalTotalAmountReceived);
        formData += '&globalTotalTransactionCharge=' + encodeURIComponent(globalTotalTransactionCharge);
        formData += '&globalTotalTds=' + encodeURIComponent(globalTotalTds);


                //         var invoicesTableData = [];
                // $('#invoicesTable tbody tr').each(function() {
                //     var rowData = {
                //         invoice_no: $(this).find('td:eq(0)').text(),
                //         due_date: $(this).find('td:eq(1)').text(),
                //         invoice_amount: $(this).find('td:eq(2)').text(),
                //         previous_due_amount: $(this).find('td:eq(3)').text(),
                //         amount_received: $(this).find('td:eq(4)').text(),
                //         txn_charges: $(this).find('td:eq(5)').text(),
                //         tds_withheld: $(this).find('td:eq(6)').text(),
                //         amount_to_settle: $(this).find('td:eq(7)').text(),
                //         amount_due: $(this).find('td:eq(8)').text()
                //     };
                //     invoicesTableData.push(rowData);
                // });

                // alert(invoicesTableData)

        // Collect data from the dynamic table
        var dynamicTableData = [];
        $('#paymentListing tbody tr').each(function() {
            var rowData = {
                deposited_to: $(this).find('td:eq(1)').text(),
                payment_method: $(this).find('td:eq(2)').text(),
                amount_received: $(this).find('td.amount-received').text(),
                tds: $(this).find('td:eq(4)').text(),
                transaction_charge: $(this).find('td.transaction-charge').text(),
                tds_Withheld: $(this).find('td.tds-withheld').text(),
                ref_id: $(this).find('td:eq(7)').text(),
                additional_notes: $(this).find('td:eq(8)').text()
            };
            dynamicTableData.push(rowData);
        });

        

        // Convert dynamic table data to JSON and append to formData
        formData += '&dynamicTableData=' + encodeURIComponent(JSON.stringify(dynamicTableData));
        // formData += '&invoicesTableData=' + encodeURIComponent(JSON.stringify(invoicesTableData));

        $.ajax({
            url : url,
            type: "POST",
            data: formData,
            dataType: "JSON",
            success: function(data) { 
                if(data.success) {
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
                $('#btnPaymentCls').hide(); 
                $('#btnPayment').show();
                if(data.st==202) {
                    toastr.error('Validation Error, Please fill all star marks fields'); 
                } else if(data.st==200) {
                    toastr.error('Something went wrong, Please try later.');  
                }
                window.location.href = '<?php echo base_url("payment-reciept"); ?>';
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.error('Something went wrong, Please try later.'); 
                $('#btnPaymentCls').hide(); 
                $('#btnPayment').show();
            }
        });
    }


   

// < --------------------------------------------------------------- payment receipt -------------------------------------------------------------------------->



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


    
      
</script>