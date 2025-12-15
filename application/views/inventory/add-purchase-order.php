<!--common header include -->
<?php $this->load->view('common_navbar');?>
<!-- common header include -->
<style>
   .pro_descrption{ display:none; } .delIcn{color: #ef8d91; margin-right: 7px;} 
   .addIcn{color: #709870; margin-right: 7px;} #putExtraVl{ width:100%;}
   .inrIcn{padding-top: 6px; text-align: right; height: calc(2.25rem + 2px); }
   .inrRp{padding-top: 6px;   height: calc(2.25rem + 2px); }
   .dropdown-box-wrapper, .result, .filter-box { height: calc(2.25rem + 2px);   display: block;
   width: 100%;
   height: calc(2.25rem + 2px);
   padding: .375rem .75rem;
   font-size: 1rem;
   font-weight: 400;
   line-height: 1.5;
   color: #495057;
   background-color: transparent;
   background-clip: padding-box;
   border:0;
   border-bottom: 1px solid #ced4da;
   border-radius: .25rem;
   box-shadow: inset 0 0 0 transparent;
   transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; }
   .form-proforma .row {
   background: #f8faff;
   padding: 15px;
   margin: 0;
   }
   .form-proforma {
   background: #ffffff;
   padding: 0;
   }
   .form-footer-section .container {
   background: #f8faff;
   padding: 20px;
   }
   .form-footer-section {
   background: #ffffff;
   padding: 0;
   }
   .contact_details .container {
   background: #f8faff;
   padding: 15px;
   }
   .contact_details {
   padding: 0;
   background-color: #ffffff;
   }
   .table td, .table th {
   padding: .75rem .3rem;
   }
   .is-invalid{
   border: 1px solid #c62828 !important;  
   }
   .clkLabel{
   background: #f8faff;
   border: none;
   }
   .linkscontainer{
    width:70vw;
    padding:20px;
    padding-top:50px;
    border-radius:10px;
    box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    margin:20px auto;
    margin-bottom:50px;
 
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
@media screen and (max-width: 576px) {
.linkscontainer {
 width: 100vw;
}
}
has context menu
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <?php
      if($this->session->userdata('account_type')=="Trial" && $countSO>=500){ 
      ?>
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-md-12 mb-3 mt-5 text-center">
               <i class="fas fa-exclamation-triangle" style="color: #f59393; font-size: 28px;"></i>
            </div>
            <div class="col-md-12 mb-3 text-center">
               You are now using trial account.<br>
               <text>You are exceeded  your opportunity limit - 1,000</text>
               <br>
               <text>You can add only  1,000 opportunity on trial account</text>
               <br>
               Please upgrade your plan to click bellow button.
            </div>
            <div class="col-md-12 mb-3 text-center">
               <a href="https://team365.io/pricing"><button class="btn btn-info">Buy Now</button></a>
            </div>
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <?php }else{ ?>
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-12">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                     <a href="<?php echo base_url()." home "; ?>">Home</a> 
                  </li>
                  <li class="breadcrumb-item">
                     <a href="<?php echo base_url()."purchaseorders "; ?>">Purchase Order</a>
                  </li>
                  <li class="breadcrumb-item active"><?php if(isset($action['data']) && $action['data']=='update'){ echo "Update"; }else{ echo "Add"; } ?>  Purchase Order</li>
               </ol>
            </div>
            <div class="col-lg-12">
               <h1 class="m-0 text-dark text-center" style="-webkit-text-fill-color: unset;">
                  <?php if(isset($action['data']) && $action['data']=='update'){ echo "Update"; }else{ echo "Add"; } ?> Purchase Order Form
               </h1>
            </div>
            <!-- /.col -->
            
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <div class="linkscontainer">
   <form class="form-horizontal"  id="form" method="post" enctype = "multipart/form-data">
      <div class="form-proforma">
         <div class="container">
            <div class="row">
               <input type="hidden" name="save_method" id="save_method" value="<?php if(isset($action['data']) && $action['data']=='update'){ echo 'Update'; }else{ echo "add";  }  ?>" >
               <input type="hidden"  name="id"  id="id" value="<?php if(isset($record['id']) &&  $action['from']=='salesorder'){ echo $record['id']; }  ?>">
               <input type="hidden"  name="lead_id"  id="lead_id" value="<?php if(isset($record['id']) && $action['from']=='quotation' ){ echo $record['id']; }  ?>">
               <input type="hidden"  name="lead_id_uri"  id="lead_id_uri" value="<?php if(!empty($this->uri->segment(2))){ echo $this->uri->segment(2); }?>">
               <input id="lead_test_val" name="total_percent" type="hidden" value="<?php if(isset($record['total_percent'])){ echo $record['total_percent']; }else{ echo "100.00"; }  ?>">
               <input type="hidden" class="form-control" name="saleorderId" id="saleorderId" value="<?php if(isset($record['saleorder_id'])){ echo $record['saleorder_id']; }else{ echo "Pending"; }  ?>" >
               <input type="hidden" class="form-control" name="opportunity_id" id="opportunity_id" value="<?php if(isset($record['opportunity_id'])){ echo $record['opportunity_id']; }  ?>" >
               <input type="hidden" class="form-control" name="status" id="status" value="<?php if(isset($record['status'])){ echo $record['status']; }else{ echo "Pending"; }  ?>" >
               <input type="hidden" class="form-control" name="progress_remain" id="progress_remain" value="<?php if(isset($record['status'])){ echo $record['status']; }else{ echo "Pending"; }  ?>" >
               <input type="hidden"  name="so_owner"  id="so_owner" value="<?php if(isset($record['so_owner']) ){ echo $record['so_owner']; }  ?>">
               <input type="hidden"  name="so_owner_email"  id="so_owner_email" value="<?php if(isset($record['so_owner']) ){ echo $record['so_owner']; }  ?>">
               <input type="hidden"  name="total_percent"  id="total_percent" value="<?php if(isset($record['total_percent']) ){ echo $record['total_percent']; }  ?>">
               <?php $proName	= explode("<br>",$record['product_name']); ?>
               <input type="hidden"  name="total_so_product"  id="total_so_product" value="<?php echo count($proName); ?>">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Salesorder ID #:</label>
                     <input type="text" class="form-control" name="saleorder_id" id="saleorder_id" value="<?php if(isset($record['saleorder_id'])){ echo $record['saleorder_id']; }  ?>" placeholder="Sales Order ID">
                     <span id="name_error"></span>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Purchase Order Owner<span class="text-danger">*</span>:</label>
                     <input type="text" class="form-control" name="owner" placeholder="Purchase Order Owner"  value="<?php if(isset($record['owner'])){ echo $record['owner']; }else{ echo $this->session->userdata('name'); }?>" readonly >
                     <span id="invoice_no_error"></span>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Customer Name<span class="text-danger">*</span>:</label>
                     <input type="text" class="form-control  checkvl" name="org_name" placeholder="Organization Name" id="org_name" required  autocomplete="off" value="<?php if(isset($record['org_name'])){ echo $record['org_name']; }  ?>" >
                     <span id="org_name_error"></span>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Contact Name<span class="text-danger">*</span>:</label>
                     <select class="form-control orgContact checkvl" name="contact_name" id="contact_name">
                        <?php if(!isset($record['contact_name'])){  ?>
                        <option value="" selected="" disabled="">Select Contact Name</option>
                        <?php } ?>	
                        <option value="<?php if(isset($record['contact_name'])){ echo $record['contact_name']; }  ?>" selected=""  ><?php if(isset($record['contact_name'])){ echo $record['contact_name']; }  ?></option>
                     </select>
                     <span id="invoice_no_error"></span>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Subject<span class="text-danger">*</span>:</label>
                     <input type="text" class="form-control checkvl" name="subject" id="subject" value="<?php if(isset($record['subject'])){ echo $record['subject']; }  ?>" placeholder="Subject">
                     <span id="name_error"></span>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <?php if($action['data']=='update'){ ?>
                     <label for="">PO Status:</label>
                     <?php 
                        if(isset($record['approve_status']) && $record['approve_status']==1){ ?>
                     <label class="text-success" style="margin-top: 14px;">Purchase Order Approved By <?=ucwords($record['approved_by']);?></label>
                     <!--<a style="text-decoration:none" href="javascript:void(0)"  class="text-primary" onclick="approve_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','0')" >click to disapprove</a>-->
                     <?php }else{ ?>
                     <label class="text-danger" style="margin-top: 14px;">Purchase Order approval in pending</label>
                     <!--<a style="text-decoration:none" href="javascript:void(0)"  class="text-primary" onclick="approve_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','1')" >Click To Approve</a>--->
                     <?php } ?> 
                     <?php }else{ ?>
                     <label for="">SO Status:</label>
                     <?php 
                        if(isset($record['pay_terms_status']) && $record['pay_terms_status']==1){ ?>
                     <label class="text-success" style="margin-top: 14px;">Sales Order Approved By <?=ucwords($record['approved_by']);?></label>
                     <!--<a style="text-decoration:none" href="javascript:void(0)"  class="text-primary" onclick="approve_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','0')" >click to disapprove</a>-->
                     <?php }else{ ?>
                     <label class="text-danger" style="margin-top: 14px;">Sales Order approval in pending</label>
                     <!--<a style="text-decoration:none" href="javascript:void(0)"  class="text-primary" onclick="approve_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','1')" >Click To Approve</a>--->
                     <?php } ?> 
                     <?php } ?>
                  </div>
               </div>
               <div class="col-lg-12">
                  <div class="form-group">
                     <label for="">Renewal:</label>
                     <label class="switch">
                     <input type="checkbox" name="is_newed" id="is_newed" value="1" <?php if(isset($record['is_renewal']) && $record['is_renewal']==1){ echo "checked"; }  ?> >
                     <span class="slider round"></span>
                     </label>
                  </div>
               </div>
               <div class="col-lg-6 isRenewal" <?php if(isset($record['is_renewal'])  && $record['is_renewal']==1){  } else{  ?> style="display:none;" <?php } ?> >
                  <div class="form-group">
                     <label for="">Select Date With Calendar :</label>
                     <input type="text" onfocus="(this.type='date')" class="form-control" id="renewal_date_cal" name="renewal_date_cal" placeholder="Select Date (DD-MM-YYYY)" value="<?php if(isset($record['renewal_date'])){ echo $record['renewal_date']; }  ?>" >
                     <span id="invoice_no_error"></span>
                  </div>
               </div>
               <div class="col-lg-6 isRenewal"  <?php if(isset($record['is_renewal'])  && $record['is_renewal']==1){  } else{  ?> style="display:none;" <?php } ?>>
                  <div class="form-group">
                     <label for="">Select Month :</label>
                     <?php if(isset($record['renewal_date'])){ 
                        $dataDate=$record['renewal_date']; 
                        }else{
                        	$dataDate='';
                        } ?>
                     <select class="form-control" name="renewal_date" id="renewal_date">
                        <option value="">Select Renewal Month</option>
                        <?php $thirty = strtotime("30 Day"); ?>
                        <option value="<?= date('Y-m-d', $thirty); ?>" <?php if($dataDate==date('Y-m-d', $thirty)){ echo "selected"; } ?> >1 Month</option>
                        <?php $sixty = strtotime("60 Day"); ?>
                        <option value="<?= date('Y-m-d', $sixty); ?>" <?php if($dataDate==date('Y-m-d', $sixty)){ echo "selected"; } ?> >2 Month</option>
                        <?php $ninty = strtotime("90 Day"); ?>
                        <option value="<?= date('Y-m-d', $ninty); ?>" <?php if($dataDate==date('Y-m-d', $ninty)){ echo "selected"; } ?> >3 Months</option>
                        <?php $one_twenty = strtotime("120 Day"); ?>
                        <option value="<?= date('Y-m-d', $one_twenty); ?>" <?php if($dataDate==date('Y-m-d', $one_twenty)){ echo "selected"; } ?> >4 Months</option>
                        <?php $one_fifty = strtotime("150 Day"); ?>
                        <option value="<?= date('Y-m-d', $one_fifty); ?>" <?php if($dataDate==date('Y-m-d', $one_fifty)){ echo "selected"; } ?> >5 Months</option>
                        <?php $six_month = strtotime("180 Day"); ?>
                        <option value="<?= date('Y-m-d', $six_month); ?>" <?php if($dataDate==date('Y-m-d', $six_month)){ echo "selected"; } ?> >6 Months</option>
                        <?php $two_ten = strtotime("210 Day"); ?>
                        <option value="<?= date('Y-m-d', $two_ten); ?>" <?php if($dataDate==date('Y-m-d', $two_ten)){ echo "selected"; } ?>  >7 Months</option>
                        <?php $two_forty = strtotime("240 Day"); ?>
                        <option value="<?= date('Y-m-d', $two_forty); ?>" <?php if($dataDate==date('Y-m-d', $two_forty)){ echo "selected"; } ?>  >8 Months</option>
                        <?php $two_seventy = strtotime("270 Day"); ?>
                        <option value="<?= date('Y-m-d', $two_seventy); ?>" <?php if($dataDate==date('Y-m-d', $two_seventy)){ echo "selected"; } ?>  >9 Months</option>
                        <?php $three_hundred = strtotime("300 Day"); ?>
                        <option value="<?= date('Y-m-d', $three_hundred); ?>" <?php if($dataDate==date('Y-m-d', $three_hundred)){ echo "selected"; } ?>  >10 Months</option>
                        <?php $three_thirty = strtotime("330 Day"); ?>
                        <option value="<?= date('Y-m-d', $three_thirty); ?>" <?php if($dataDate==date('Y-m-d', $three_thirty)){ echo "selected"; } ?>  >11 Months</option>
                        <?php $one_year = strtotime("365 Day"); ?>
                        <option value="<?= date('Y-m-d', $one_year); ?>" <?php if($dataDate==date('Y-m-d', $one_year)){ echo "selected"; } ?>  >1 Year</option>
                        <?php $two_year = strtotime("730 Day"); ?>
                        <option value="<?= date('Y-m-d', $two_year); ?>" <?php if($dataDate==date('Y-m-d', $two_year)){ echo "selected"; } ?>  >2 Year</option>
                        <?php $three_year = strtotime("1195 Day"); ?>
                        <option value="<?= date('Y-m-d', $three_year); ?>" <?php if($dataDate==date('Y-m-d', $three_year)){ echo "selected"; } ?>  >3 Year</option>
                     </select>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="billing-section">
         <div class="container">
            <div class="row">
               <div class="col-md-6 mb-3">
                  <h6>Billing Address</h6>
               </div>
               <div class="col-md-6 mb-3">
                  <h6>Shipping Address</h6>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="">Select Branch :</label>
                     
                     <select class="form-control" name="branch_name" id="branch">
                        <option value="">Select Branch</option>
                       <?php
                        if (!empty($branch)) {
                            foreach ($branch as $bname) {
                                if ($bname['delete_status'] == 1) { 
                        ?>
                                <option value="<?= $bname['branch_name']; ?>"><?= $bname['branch_name']; ?></option>
                        <?php
                                }
                            }
                        }
                        ?>

                     </select>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="">Select Branch :</label>
                     <select class="form-control" name="branch_name_s" id="branch_s">
                        <option value="">Select Branch</option>
                        <?php
                        if (!empty($branch)) {
                            foreach ($branch as $bname) {
                                if ($bname['delete_status'] == 1) { 
                        ?>
                                <option value="<?= $bname['branch_name']; ?>"><?= $bname['branch_name']; ?></option>
                        <?php
                                }
                            }
                        }
                        ?>
                     </select>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label for="">GSTIN<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control checkvl" name="billing_gstin" placeholder="Enter GSTIN" id="gstin"  value="<?php if(isset($record['billing_gstin'])){ echo $record['billing_gstin']; }  ?>" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Country<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control checkvl" name="billing_country" placeholder="Country" id="billing_country" value="<?php if(isset($record['billing_country']) && $action['data']=='update' ){ echo $record['billing_country']; }  ?>"  >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">State<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control checkvl" name="billing_state" placeholder="State" id="billing_state" value="<?php if(isset($record['billing_state']) && $action['data']=='update'){ echo $record['billing_state']; }  ?>"  >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">City<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control checkvl" name="billing_city" placeholder="City" id="billing_city" value="<?php if(isset($record['billing_city']) && $action['data']=='update'){ echo $record['billing_city']; }  ?>" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Zipcode<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control checkvl" name="billing_zipcode" placeholder="Zipcode" id="billing_zipcode" value="<?php if(isset($record['billing_zipcode']) && $action['data']=='update'){ echo $record['billing_zipcode']; }  ?>" >
                        </div>
                     </div>
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label for="">Address<span class="text-danger">*</span>:</label>
                           <textarea type="text" class="form-control checkvl" name="billing_address" placeholder="Enter Address" id="billing_address" required=""><?php if(isset($record['billing_address']) && $action['data']=='update'){ echo $record['billing_address']; }  ?></textarea>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label for="">GSTIN<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control  checkvl" name="shipping_gstin" placeholder="Enter GSTIN" id="s_gstin" value="<?php if(isset($record['shipping_gstin']) && $action['data']=='update'){ echo $record['shipping_gstin']; }  ?>" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Country<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control checkvl" name="shipping_country" placeholder="Country" id="shipping_country" value="<?php if(isset($record['shipping_country']) && $action['data']=='update'){ echo $record['shipping_country']; }  ?>"  >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">State<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control checkvl" name="shipping_state" placeholder="State" id="shipping_state" value="<?php if(isset($record['shipping_state']) && $action['data']=='update'){ echo $record['shipping_state']; }  ?>" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">City<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control checkvl" name="shipping_city" placeholder="City" id="shipping_city" value="<?php if(isset($record['shipping_city']) && $action['data']=='update'){ echo $record['shipping_city']; }  ?>" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Zipcode<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control checkvl" name="shipping_zipcode" placeholder="Zipcode" id="shipping_zipcode" value="<?php if(isset($record['shipping_zipcode']) && $action['data']=='update'){ echo $record['shipping_zipcode']; }  ?>" >
                        </div>
                     </div>
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label for="">Address<span class="text-danger">*</span>:</label>
                           <textarea type="text" class="form-control checkvl" name="shipping_address" placeholder="Enter Address" id="shipping_address" ><?php if(isset($record['shipping_address']) && $action['data']=='update'){ echo $record['shipping_address']; }  ?></textarea>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--------Start Supplier Details-------->
            <div class="row">
               <div class="col-md-6 mb-3 mt-4">
                  <h6>Supplier Details</h6>
               </div>
               <div class="col-md-6 mb-3 mt-4">
                  <h6>Supplier Address Details</h6>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label for="">Supplier Company Name(Vendor)<span class="text-danger">*</span>:</label>
                           <div class="input-group">
                              <input type="text" class="form-control supName checkvl" name="supplier_comp_name" placeholder="Enter Supplier / Vendor" id="supplier_comp_name" required  value="<?php if(isset($record['supplier_comp_name'])){ echo $record['supplier_comp_name']; }  ?>" >
                              <div class="input-group-append" style="cursor:pointer" onclick="add_formOrg('Vendor','form')">
                                 <span class="input-group-text" style="border-radius: 0px;">
                                    <!--<i class="fas fa-plus-circle"></i>-->
                                    <img src="https://img.icons8.com/fluent/24/000000/plus.png"/>
                                 </span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Supplier Name<span class="text-danger">*</span>:</label>
                           <!--<input type="text" class="form-control orgContact checkvl" name="supplier_name" id="supplier_name" required  placeholder="Enter Supplier Name"  value="<?php if(isset($record['supplier_name'])){ echo $record['supplier_name']; }  ?>" >-->
                           <select name="supplier_name" class="form-control" id="supplier_name">
                              <option value="">Supplier Contact Name</option>
                           </select>
                           <span id="supplier_name_error"></span>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Contact Number<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control orgMobile checkvl" name="supplier_contact" placeholder="Enter Contact No." id="supplier_contact" autocomplete="off" required value="<?php if(isset($record['supplier_contact'])){ echo $record['supplier_contact']; }  ?>" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Supplier Email<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control orgEmail checkvl" name="supplier_email" placeholder="Enter Supplier Email" id="supplier_email" required="" autocomplete="off" value="<?php if(isset($record['supplier_email'])){ echo $record['supplier_email']; }  ?>" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Supplier GSTIN<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control orgGstin checkvl" name="supplier_gstin" placeholder="Enter GSTIN" id="supplier_gstin" required=""  value="<?php if(isset($record['supplier_gstin'])){ echo $record['supplier_gstin']; }  ?>" >
                           <span id="billing_zipcode_error"></span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Country<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control ui-autocomplete-input orgCountry checkvl" name="supplier_country" placeholder="Supplier Country" id="supplier_country" required  value="<?php if(isset($record['supplier_country'])){ echo $record['supplier_country']; }  ?>" >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">State<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control ui-autocomplete-input orgShippingState checkvl" name="supplier_state" placeholder="Supplier State" id="supplier_state" required="" autocomplete="off" value="<?php if(isset($record['supplier_state'])){ echo $record['supplier_state']; }  ?>"  >
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">City<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control ui-autocomplete-input orgCity checkvl" name="supplier_city" placeholder="Supplier City" id="supplier_city" required="" autocomplete="off"  value="<?php if(isset($record['supplier_city'])){ echo $record['supplier_city']; }  ?>"  >
                           <span id="shipping_city_error"></span>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="">Zipcode<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control orgZipcode checkvl" name="supplier_zipcode" placeholder="Zipcode" id="supplier_zipcode" required="" value="<?php if(isset($record['supplier_zipcode'])){ echo $record['supplier_zipcode']; }  ?>">
                        </div>
                     </div>
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label for="">Address<span class="text-danger">*</span>:</label>
                           <input type="text" class="form-control orgAddress checkvl" name="supplier_address" placeholder="Enter Address" id="supplier_address" required="" value="<?php if(isset($record['supplier_address'])){ echo $record['supplier_address']; }  ?>">
                           <span id="shipping_address_error"></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--------End Supplier Details------->
            <div class="proforma-table-main">
               <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                     <ul class="list-inline">
                        <li class="list-inline-item">
                           <label> <input type="checkbox"  id="add_gst" checked > Add GST
                        </li>
                        </label>
                     </ul>
                     <?php
                        if(isset($record['igst'])){ 
                            $igst = explode("<br>",$record['igst']);
                        }else{
                        	$igst=array();
                        }
                        if(isset($record['cgst'])){ 
                            $cgst = explode("<br>",$record['cgst']);
                        }else{
                        	$cgst=array();
                        }	
                        //echo $record['type'];
                        ?>
                     <ul class="list-inline hide_gst_checkbox">
                        <li class="list-inline-item">
                           <label><input type="radio" name="type" value="Interstate"  id="igst_checked" checked <?php if(isset($record['type']) && $record['type']=='Interstate' ){ echo "checked"; } ?> > IGST</label>
                        </li>
                        <li class="list-inline-item">
                           <label><input type="radio" name="type" value="Instate" id="csgst_checked" <?php if(isset($record['type']) && $record['type']=='Instate'){ echo "checked"; } ?>> CGST & SGST</label>
                        </li>
                     </ul>
                  </div>
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="proforma-table">
                        <table class="table table-responsive-lg" width="100%" id="add_new_line" >
                           <thead>
                              <tr>
                                 <th style="width: 15%;">Items</th>
                                 <th>HSN/SAC</th>
                                 <th>SKU</th>
                                 <th class="gst" style="width: 7%;" >GST(%)</th>
                                 <th style="width: 7%;">Quantity</th>
                                 <th>Rate</th>
                                 <th style="width: 8%;" >Discount</th>
                                 <th>Est. PO Price</th>
                                 <th>Tot. Est. PO</th>
                                 <th>Amount</th>
                              </tr>
                           </thead>
                           <?php 
                              $rw=45;
                              $dataList='';
                              $dataList.='<datalist id="taxName">';  
                              foreach($gstPer as $gstrow){ 
                                          $dataList.='<option value="'.$gstrow['gst_percentage'].'">'.$gstrow['tax_name'].'@</option>';
                                          }
                                          $dataList.='</datalist>';
                              
                              if(isset($record['product_name'])){
                              	$proName	= explode("<br>",$record['product_name']);
                              	$proDummyId	= explode("<br>",$record['pro_dummy_id']);
                              	
                              	$pro_dummy_id = explode("<br>",$record['pro_dummy_id']);
                              	
                              	if(isset($record['hsn_sac'])){	
                              	$hsn_sac	= explode("<br>",$record['hsn_sac']); 
                              	}else{
                              	$hsn_sac=array();	
                              	}
                              	
                              	if(isset($record['sku'])){	
                              	$sku	= explode("<br>",$record['sku']); 
                              	}else{
                              	$sku=array();	
                              	}
                              	
                              	
                              	$quantity	= explode("<br>",$record['quantity']); 
                              	$unit_price	= explode("<br>",$record['unit_price']); 
                              	$total		= explode("<br>",$record['total']); 
                              	if(isset($record['gst'])){	
                              	$gst		= explode("<br>",$record['gst']); 
                              	}else{
                              	$gst		= array(); 	
                              	}
                              	$sgst=array();
                              	$cgst=array();
                              	$igst=array();
                              	$estimatePurchase=array();
                              	$proDiscount=array();
                              	$proUnitPrice=array();
                              	$initialEstimatePurchase=array();
                              	$proDescription=array();
                              	if(isset($record['sgst'])){
                              		$sgst=explode("<br>",$record['sgst']); 
                              	}
                              	if(isset($record['cgst'])){ 
                              		$cgst=explode("<br>",$record['cgst']); 
                              	}
                              	if(isset($record['igst'])){ 
                              		$igst=explode("<br>",$record['igst']); 
                              	}
                              	if(isset($record['pro_description'])){ 
                              		$proDescription=explode("<br>",$record['pro_description']); 
                              	}
                              	
                              	if(isset($record['pro_discount'])){ 
                              		$proDiscount=explode("<br>",$record['pro_discount']); 
                              	}
                              	
                              	if(isset($record['estimate_purchase_price']) && $action['data']=='add'){ 
                              		$proUnitPrice=explode("<br>",$record['estimate_purchase_price']); 
                              	}else if(isset($record['unit_price']) && $action['data']=='update'){ 
                              		$proUnitPrice=explode("<br>",$record['unit_price']); 
                              	}
                              	
                              	if(isset($record['estimate_purchase_price_po']) && $action['data']=='update'){ 
                              		$estimatePurchase=explode("<br>",$record['estimate_purchase_price_po']); 
                              	}
                              	
                                if(isset($record['initial_estimate_purchase_price'])){ 
                              		$initialEstimatePurchase=explode("<br>",$record['initial_estimate_purchase_price']); 
                              	}
                              	
                              $proArr=array();
                              $proArrId=array();
                              if($action['data']!='update'){
                              $ci 	=& get_instance();
                              $prddata= $ci->Purchaseorders->check_product($record['saleorder_id']);
                              for($i=0; $i<count($prddata); $i++){
                              	$proArr2		= explode("<br>",$prddata[$i]['product_name']);
                              	$pro_dummy_id2	= explode("<br>",$prddata[$i]['pro_dummy_id']);
                              	for($k=0; $k<count($proArr2); $k++){
                              		$proArr[]=$proArr2[$k];
                              		$proArrId[]=$pro_dummy_id2[$k];
                              	}
                              }
                              }
                              
                              for($pr=0; $pr<count($proName); $pr++){ 
                              	if (!in_array($proName[$pr], $proArr) || !in_array($proDummyId[$pr], $proArrId))
                              	{
                              ?>
                           <tr class="removCL<?=$rw;?>">
                              <td>
                                 <input type="hidden" name="product_Id[]" id="proId<?=$rw;?>" value="<?=$proDummyId[$pr];?>">
                                 <input type="text" name="product_name[]"  class="form-control productItm checkvl" id="proName<?=$rw;?>" data-cntid="<?=$rw;?>" onkeyup="getproductinfo();"  placeholder="Items name(required)" value="<?=$proName[$pr];?>"><span id="items_error"></span>
                              </td>
                              <td><input type="text" name="hsn_sac[]" class="form-control" id="hsn<?=$rw;?>" placeholder="HSN/SAC" value="<?php if(isset($hsn_sac[$pr])){ echo $hsn_sac[$pr]; } ?>"></td>
                              <td>
                                 <input type="text" name="sku[]" class="form-control" id="sku<?=$rw;?>" placeholder="SKU"  value="<?php if(isset($sku[$pr])){ echo $sku[$pr]; } ?>" >
                              </td>
                              <td class="gst">
                                 <input type="text" name="gst[]" class="form-control checkvl"  onkeyup="calculate_pro_price()" id="gst<?=$rw;?>" placeholder="GST in %" value="<?php if(isset($gst[$pr])){ echo $gst[$pr]; } ?>" list="taxName">
                                 <?php echo $dataList; ?>
                              </td>
                              <td><input type="text"  onkeyup="calculate_pro_price()" name="quantity[]" id="qty<?=$rw;?>" class="form-control checkvl numeric"  placeholder="qty" value="<?=$quantity[$pr];?>"><span id="quantity_error"></span></td>
                              <td><input type="text" onkeyup="calculate_pro_price()" name="unit_price[]" id="price<?=$rw;?>" class="form-control start  price_float"  placeholder="rate" value="<?=$proUnitPrice[$pr];?>" readonly ><span id="unit_price_error"></span></td>
                              <td><input type="text" onkeyup="calculate_pro_price()" name="discount_price[]" id="disc<?=$rw;?>" class="form-control price_float"  placeholder="Discount Price" minlength="0" value="<?php if(isset($proDiscount[$pr]) && $action['data']=='update' ){ echo $proDiscount[$pr]; }else{ echo "0"; } ?>"></td>
                              <td><input type="text" onkeyup="calculate_pro_price()" name="estimate_purchase_price[]"   class="form-control  price_float"  placeholder="Estimate Price" maxlength="<?=$proUnitPrice[$pr];?>" value="<?php if(isset($estimatePurchase[$pr])){ echo $estimatePurchase[$pr]; } ?>"></td>
                              <td><input type="text" onkeyup="calculate_pro_price()" name="initial_est_purchase_price[]"   class="form-control price_float" placeholder="Total Estimate Price" value="<?php if(isset($initialEstimatePurchase[$pr])){ echo $initialEstimatePurchase[$pr]; } ?>" readonly > </td>
                              <td><input type="text" name="total[]" class="form-control" class="" readonly value="<?=$total[$pr];?>">
                                 <input type="hidden" name="cgst[]" value="<?php if(isset($cgst[$pr])){ echo $cgst[$pr]; } ?>" class="" readonly>
                                 <input type="hidden" name="sgst[]" value="<?php if(isset($sgst[$pr])){ echo  $sgst[$pr]; } ?>" class="" readonly>
                                 <input type="hidden" name="igst[]" value="<?php if(isset($igst[$pr])){ echo  $igst[$pr]; }?>" class="" readonly>
                                 <input type="hidden" name="sub_total_with_gst[]" class="" readonly>
                              </td>
                           </tr>
                           <tr class=" <?php if(empty($proDescription[$pr])){ ?> pro_descrption <?php } ?>  removCL<?=$rw;?> addCL<?=$rw;?>" <?php if(empty($proDescription[$pr])){ ?> style="display:none;" <?php } ?> >
                              <td colspan="10">
                                 <input type="text" name="pro_description[]" class="form-control" value="<?php if(isset($proDescription[$pr])){ echo $proDescription[$pr]; }?>"  placeholder="Description">
                              </td>
                           </tr>
                           <tr class="removCL<?=$rw;?>">
                              <td class="delete_new_line" colspan="2" >
                                 <a href="javascript:void(0);" onClick="removeRow('removCL<?=$rw;?>');" ><i class="far fa-trash-alt delIcn"></i> Delete Row</a>
                              </td>
                              <td colspan="8">
                                 <a href="javascript:void(0);" class="add_desc deschd<?=$rw;?>" onClick="addDesc('addCL<?=$rw;?>','deschd<?=$rw;?>')" <?php if(!empty($proDescription[$pr])){ ?> style="display:none;" <?php } ?> ><i class="far fa-plus-square addIcn"></i> Add Description</a>
                              </td>
                           </tr>
                           <?php $rw++; } } }else{  ?>
                           <tr class="removCL<?=$rw;?>">
                              <td>
                                 <input type="text" name="product_name[]"  class="form-control productItm checkvl" id="proName<?=$rw;?>" data-cntid="<?=$rw;?>" onkeyup="getproductinfo();"  placeholder="Items name(required)" value="">
                                 <span id="items_error"></span>
                              </td>
                              <td><input type="text" name="hsn_sac[]" class="form-control" id="hsn<?=$rw;?>" placeholder="HSN/SAC" value=""></td>
                              <td>
                                 <input type="text" name="sku[]" class="form-control" id="sku<?=$rw;?>" placeholder="SKU"  value="" >
                              </td>
                              <td class="gst">
                                 <input type="text" name="gst[]" id="gst<?=$rw;?>" class="form-control checkvl"  onkeyup="calculate_pro_price()" placeholder="GST in %" value=""list="taxName">
                                 <?php echo $dataList; ?>
                              </td>
                              <td ><input type="text"  onkeyup="calculate_pro_price()" name="quantity[]" id="qty<?=$rw;?>" class="form-control checkvl numeric"  placeholder="qty" value=""><span id="quantity_error"></span></td>
                              <td><input type="text" class="start form-control" onkeyup="calculate_pro_price()" name="unit_price[]" id="price<?=$rw;?>" class="form-control start  price_float" id="unit_price" placeholder="rate" value=""><span id="unit_price_error"></span></td>
                              <td><input type="text" onkeyup="calculate_pro_price()" name="discount_price[]" id="disc<?=$rw;?>" class="form-control price_float"  placeholder="Discount Price" value="0"></td>
                              <td><input type="text" onkeyup="calculate_pro_price()" name="estimate_purchase_price[]"   class="form-control start  price_float"  placeholder="Estimate Price" ></td>
                              <td><input type="text" onkeyup="calculate_pro_price()" name="initial_est_purchase_price[]"   class="form-control price_float" placeholder="Total Estimate Price" readonly > </td>
                              <td><input type="text" name="total[]" class="form-control" class="" readonly value="">
                                 <input type="hidden" name="cgst[]" value="" class="" readonly>
                                 <input type="hidden" name="sgst[]" value="" class="" readonly>
                                 <input type="hidden" name="igst[]" value="" class="" readonly>
                                 <input type="hidden" name="sub_total_with_gst[]" class="" readonly>
                              </td>
                           </tr>
                           <tr class="pro_descrption removCL<?=$rw;?> addCL<?=$rw;?>"  style="display:none;" >
                              <td colspan="10">
                                 <input type="text" name="pro_description[]" class="form-control" value=""  placeholder="Description">
                              </td>
                           </tr>
                           <tr class="removCL<?=$rw;?>">
                              <td class="delete_new_line" colspan="2" >
                                 <a href="javascript:void(0);" onClick="removeRow('removCL<?=$rw;?>');" ><i class="far fa-trash-alt delIcn"></i> Delete Row</a>
                              </td>
                              <td colspan="8">
                                 <a href="javascript:void(0);" class="add_desc deschd<?=$rw;?>" onClick="addDesc('addCL<?=$rw;?>','deschd<?=$rw;?>')" ><i class="far fa-plus-square addIcn"></i> Add Description</a>
                              </td>
                           </tr>
                           <?php } ?>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            <!--<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
               <div class="row">
                 <div  class="add_line"> <a href="javascript:void(0);"><i class="far fa-plus-square"></i> Add New Line</a>
                 </div>
               </div>
               </div>-->
         </div>
      </div>
      <div class="price-breakup">
         <div class="container">
            <div class="row">
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="price-breakup-right">
                     <div class="row">
                        <div class="col-xl-6 col-lg-6">
                           <p class="paymentTermsSts">Payment terms status: </p>
                        </div>
                        <div class="col-xl-6 col-lg-6 text-right">
                           <p class="paymentTermsSts">
                              <?php if(isset($record['approve_status']) && $record['approve_status']==1 && $action['data']=='update'){ ?> <label class="text-success"> PO approved by <?=ucwords($record['approved_by']);?> </label> <?php } ?>
                              <?php 
                                 if(isset($record['pay_terms_status']) && $record['pay_terms_status']==1 && $action['data']=='add'){ ?>
                              <label class="text-success">Sales Order Approved By <?=ucwords($record['approved_by']);?></label>
                              <?php }else if($action['data']=='add'){ ?>
                              <label class="text-danger" style="margin-top: 14px;">Sales Order approval in pending</label>
                              <?php } ?> 
                           </p>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                           <p class="discountProfit">Overall your profit: </p>
                        </div>
                        <div class="col-xl-6 col-lg-6 text-right">
                           <input type="hidden" id="userProfit" name="profit_by_user">
                           <p class="discountMargin text-success" >
                              ₹ 
                              <text id="ptMargin">0.00</text>
                           </p>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                           <p class="discountProfit">Overall profit in (%): </p>
                        </div>
                        <div class="col-xl-6 col-lg-6  text-right">
                           <input type="hidden" id="userProfit" name="userProfit">
                           <p class="discountMargin">
                              <text id="profit_byUserPercent">0.00%</text>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="price-breakup-right">
                     <div class="row">
                        <input type="hidden" name="initial_total"  id="initial_total">
                        <input type="hidden" name="total_discount" id="total_discount">
                        <input type="hidden" name="after_discount" id="after_discount">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                           <p class="sub_amount">Amount :</p>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                           <p class="sub_amount" id="show_subAmount">₹0.00</p>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                           <p class="sgst">SGST :</p>
                           <p class="cgst">CGST :</p>
                           <p class="igst">IGST :</p>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                           <p class="sgst" id="show_sgst">₹0.00</p>
                           <p class="cgst" id="show_cgst">₹0.00</p>
                           <p class="igst" id="show_igst">₹0.00</p>
                           <input type="hidden" name="total_igst" id="total_igst" value="0">
                           <input type="hidden" name="total_cgst" id="total_cgst" value="0">
                           <input type="hidden" name="total_sgst" id="total_sgst" value="0">
                        </div>
                        <input type="hidden" id="discounts" name="total_orc" onkeyup="calculate_pro_price()" value="0">
                        <!---Discount Field--->	
                        <!--<div class="row" style="width: 100%; border-bottom: 1px solid #eae7e7; margin-bottom: 15px;">
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                              <p class="discount">Overall Discount(ORC):<br>
                              ₹ <b id="cal_disc"></b>
                              </p>
                                 </div>
                                 <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5 text-right">
                                    <p class="discount">
                                        <input type="text" id="discounts" name="total_orc" onkeyup="calculate_pro_price()" value="<?php if(isset($record['total_orc_po']) && $record['total_orc_po']!=""){ echo $record['total_orc_po'];  }?>" class="form-control">
                                    </p>
                                 </div>
                                 
                                 <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right">
                                    <p class="discount"><a href="javascript:void(0);" id="remove_discount"><i class="fas fa-times"></i></a></p>
                                 </div>  
                           
                           </div>-->	
                        <div class="row" id="putExtraVl">
                           <?php 
                              if(isset($record['extra_charge_label']) && $record['extra_charge_label']!=""){ 
                              $extraChargeName=explode("<br>",$record['extra_charge_label']);
                              $extraChargeValue=explode("<br>",$record['extra_charge_value']);
                              $td=30;
                              for($ex=0; $ex<count($extraChargeName); $ex++){
                              ?>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="ext<?=$td;?>" style="margin-bottom: 3%;">
                              <input type="text" name="extra_charge[]" value="<?php echo $extraChargeName[$ex]; ?>" placeholder="Extra Charges" class="form-control clkLabel" >
                           </div>
                           <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5" id="extVl<?=$td;?>" style="margin-bottom: 3%;">
                              <input type="text" onkeyup="calculate_pro_price()" name="extra_chargevalue[]" id="floatvald<?=$td;?>"  value="<?php echo $extraChargeValue[$ex]; ?>" class="form-control inptvl">
                           </div>
                           <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right" id="rows<?=$td;?>" style="margin-bottom: 3%;">
                              <a href="javascript:void(0);" class="remove_additionalchg" id="<?=$td;?>"><i class="fas fa-times"></i></a>
                           </div>
                           <?php $td++; } } ?>				
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                           <!-- <p class="add_discount"><a href="javascript:void(0);"><i class="fas fa-tag"></i> Add Discount</a>
                              </p> -->
                           <p>
                              <a href="javascript:void(0);" class="add_additionalchg">
                                 <!--<i class="far fa-plus-square"></i>--><img src="https://img.icons8.com/doodle/22/000000/add.png"> Add Additional Charges
                              </a>
                           </p>
                           <hr>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                           <div class="total-price">
                              <div class="row">
                                 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 inrRp">
                                    <h4>Total (INR)</h4>
                                 </div>
                                 <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 inrIcn">
                                    <h4>
                                       <img src="https://img.icons8.com/office/22/000000/rupee.png"/><!--₹-->
                                    </h4>
                                 </div>
                                 <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                                    <input id="final_total" name="sub_total" class="form-control" type="text" readonly>
                                 </div>
                              </div>
                           </div>
                           <hr>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                           <div class="price_in_words text-right">
                              <h6><b>Total (in words)</b></h6>
                              <h6 id="digittowords">Zero Ruppes Only</h6>
                           </div>
                        </div>
                     </div>
                  </div>
                  <hr>
               </div>
            </div>
         </div>
      </div>
      <div class="form-footer-section py-5">
         <?php
            if(isset($record['terms_condition']) && $record['terms_condition']!="" && $action['data']=='update'){
            	$terms_condition=$record['terms_condition'];
            }else{
            	$terms_condition=$this->session->userdata('terms_condition_seller');
            }
            
            ?>
         <div class="container">
            <?php if(empty($terms_condition)){ ?> 
            <a href="javascript:void(0);" class="add_terms"><i class="far fa-plus-square addIcn"></i> Add Terms</a>
            <?php } ?> 
            <div id="show_terms" <?php if(empty($terms_condition)){ ?> style="display:none;" <?php } ?>  >
               <p><img src="https://img.icons8.com/nolan/26/terms-and-conditions.png"/>  Terms and Condition :</p>
               <span id="terms_condition">
                  <?php if(!empty($terms_condition)){ 
                     $termsCondition=explode("<br>",$terms_condition);
                     $p=1;
                     $dm=14;
                     for($tm=0; $tm<count($termsCondition); $tm++){
                      ?>
                  <div class="row" id="addterms<?=$dm;?>">
                     <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right">
                        <p><?=$p;?></p>
                     </div>
                     <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10"> 
                        <input type="text" name="terms_condition[]" value="<?=$termsCondition[$tm];?>" placeholder="Write Your Conditions">
                     </div>
                     <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1"> 
                        <a href="javascript:void(0);" class="remove_terms" id="<?=$dm;?>">X</a>
                     </div>
                  </div>
                  <?php $p++; $dm++; } } ?>
               </span>
               <div class="row m-0" id="add_terms_condition"> <a href="javascript:void(0);"><img src="https://img.icons8.com/doodle/22/000000/add.png"/> Add New Term & Condition</a>
               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="col-lg-12">
            <h6><a id="addEndCust" data-toggle="collapse" href="#multiCollapseExample1" ><img src="https://img.icons8.com/bubbles/26/000000/gender-neutral-user.png"/>&nbsp;&nbsp;Add End Customer Details</a></h6>
         </div>
         
         <div class="collapse multi-collapse <?php if(isset($record['customer_company_name']) && $record['customer_company_name']!=""){ echo "show";  } ?>  " id="multiCollapseExample1">
            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Company Name:  &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="switch">
                        <input type="checkbox" name="companyName_check" id="companyName_check" value="1" <?php if(isset($record['checkComp_name']) && $record['checkComp_name']==1){ echo "checked"; }  ?> >
                        <span class="slider round"></span></label>
                     <input type="text" class="form-control onlyLetters" name="company_name" placeholder="Company Name" id="company_name" value="<?php if(isset($record['customer_company_name'])){ echo $record['customer_company_name'];  } ?>">
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Customer Name:</label>
                     <input type="text" class="form-control" name="customer_name" placeholder="Customer Name" id="customer_name" value="<?php if(isset($record['customer_name'])){ echo $record['customer_name'];  } ?>" >
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Customer Email:</label>
                     <input type="email" class="form-control" name="customer_email" placeholder="Customer Email" id="customer_email" value="<?php if(isset($record['customer_email'])){ echo $record['customer_email'];  } ?>">
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Customer Mobile Number:</label>
                     <input type="text" class="form-control" name="customer_mobile" placeholder="Enter Customer Mobile Number" id="customer_mobile" value="<?php if(isset($record['customer_mobile'])){ echo $record['customer_mobile'];  } ?>">
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Licence No.:</label>
                     <input type="text" class="form-control" name="microsoft_lan_no" placeholder="Licence Number" id="microsoft_lan_no" value="<?php if(isset($record['microsoft_lan_no'])){ echo $record['microsoft_lan_no'];  } ?>" >
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Promo Id:</label>
                     <input type="text" class="form-control" name="promo_id" placeholder="Promo Id" id="promo_id" value="<?php if(isset($record['promo_id'])){ echo $record['promo_id'];  } ?>"  >
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="">Customer Address:</label>
                     <textarea class="form-control" name="customer_address" placeholder="Enter Customer Address" id="customer_address"><?php if(isset($record['customer_address'])){ echo $record['customer_address'];  } ?></textarea>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="notes">
         <div class="container">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <a href="javascript:void(0);" class="add_notes">
                     <!--<i class="fas fa-calendar-minus addIcn"></i> --><img src="https://img.icons8.com/fluent/22/000000/note.png"/> Add Notes
                  </a>
                  <div class="notes_left" <?php if(empty($record['notes'])){ echo "style='display:none;'"; } ?> >
                     <textarea class="form-control" name="notes" rows="8" placeholder="Notes"><?php if(isset($record['notes'])){ echo $record['notes']; } ?></textarea>
                     <button class="remove_notes" type="button"><img src="https://img.icons8.com/plasticine/30/000000/x.png"/></button>
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
                  <p>Or you can call on</p>
                  <label style="display: inline; border: 0; border-bottom: 1px solid #ccc;  background-color: transparent; ">+91-</label>
                  <input type="text" style="width:90%;" name="enquiry_mobile" value="<?=$this->session->userdata('company_mobile');?>">
               </div>
            </div>
            <div class="row mt-5" id="errorMsgbox">
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                  <div class="error-popup-msg-for-user">
                     <p><i class="fas fa-exclamation-circle"></i>
                        Please fill the following details:
                     </p>
                     <ol id="ErrorMsg">
                     </ol>
                  </div>
               </div>
               <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"></div>
            </div>
            <div class="row mt-5">
               <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                  <!--<div class="draft-btn text-right">
                     <button>Save As Draft</button>
                     </div>-->
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="save-btn text-left">
                     <button type="button" id="btnSave" onclick="save();">Save & Continue</button>
                     <button type="button" id="btnSaveAftr" style="display:none;">Validating..</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </form>
   <?php } ?>
   <!-- /.content-header -->
</div>
<!-- common footer include -->
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<?php $this->load->view('commonAddorg_modal');?>
<?php $this->load->view('product_onkeyup');?>
<script>
function save(){
	if(checkValidationWithClass('form')==1){
	        toastr.info('Please wait while we are processing your request');
			$('#btnSave').hide();
			$('#btnSaveAftr').show();
			var url;
		    var save_method=$("#save_method").val();
			if(save_method == 'add') {
				url = "<?= site_url('purchaseorders/create')?>";
			} else {
				url = "<?= site_url('purchaseorders/update')?>";
			}
			$.ajax({
				url : url,
				type: "POST",
				data: $('#form').serialize(),
				dataType: "JSON",
				success: function(data)
				{  
				    console.log(data);
				    console.log('hii');
				  if(data.status) 
				  {
				    $('#btnSaveAftr').html('Redirecting.....');  
				    toastr.success('Purchase order has been added successfully.');
				    setTimeout(function(){
				        window.location.href = '<?=base_url()?>purchaseorders/view_pi_po/'+data.id; 
				    },2000);
					 
				  }
				  if(data.st==202)
				  {
				      toastr.error('Validation Error, Please fill all star marks fields'); 
					$("#opportunity_id_error").html(data.opportunity_id);
					$("#contact_name_error").html(data.contact_name);
					$("#quote_stage_error").html(data.quote_stage);
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
					checkValidationWithClass('form');
					    $('#btnSaveAftr').hide();
						$('#btnSave').show();
				  }else if(data.st==200)
				  {
					  
					$("#opportunity_id_error").html('');
					$("#contact_name_error").html('');
					$("#quote_stage_error").html('');
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
					toastr.error('Something went wrong, Please try later.'); 
					$('#btnSaveAftr').hide();
					$('#btnSave').show();
				  }
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
				  toastr.error('Something went wrong, Please try later.'); 
				  $('#btnSaveAftr').hide();
				  $('#btnSave').show();
				}
			});
		}
    }


/*START CALCULATION FUNCTION */
function calculate_pro_price()
{
	  var Amount	=0;
	  var IGST 		=0;
	  var cal_discount=0;
	  var extraCharge=0;
	  var SCGST = 0;
	  var DiscpriceT=0;
	  var totalEstmatePrice=0;
	  var outputSoPriceTotal=0;
	  var total_percent = 0;
	$("input[name='quantity[]']").each(function (index) {
		
		  var price = $("input[name='unit_price[]']").eq(index).val();
		  price = price.replace(/,/g, "");
		  var estPrice = $("input[name='estimate_purchase_price[]']").eq(index).val();
		  estPrice = estPrice.replace(/,/g, "");
		  if(parseFloat(estPrice)>parseFloat(price)){
			 $("input[name='estimate_purchase_price[]']").eq(index).css('border-color','red');
			  $("input[name='estimate_purchase_price[]']").eq(index).val(numberToIndPrice(price));
		  }
		
		
		
		    var quantity = $("input[name='quantity[]']").eq(index).val();
            var price = $("input[name='unit_price[]']").eq(index).val();
			
			
			price = price.replace(/,/g, "");
			var pricetwo=numberToIndPrice(price);
			$("input[name='unit_price[]']").eq(index).val(pricetwo);
			
			//Dicount Price
            var Discprice = $("input[name='discount_price[]']").eq(index).val();
			Discprice = Discprice.replace(/,/g, "");
			DiscpriceT=parseFloat(DiscpriceT)+parseFloat(Discprice);
			var Discpricetwo=numberToIndPrice(Discprice);
			$("input[name='discount_price[]']").eq(index).val(Discpricetwo);
			
			// Estimate Price For PO
			var estMatePrice = $("input[name='estimate_purchase_price[]']").eq(index).val();
			estMatePrice = estMatePrice.replace(/,/g, "");
			DiscpriceT=parseFloat(DiscpriceT)+parseFloat(Discprice);
			
			var estMatePricetwo=numberToIndPrice(estMatePrice);
			$("input[name='estimate_purchase_price[]']").eq(index).val(estMatePricetwo);
			
            var gst = $("input[name='gst[]']").eq(index).val();
			if(gst==""){
				gst=0;
			}
			
			
			var output = parseInt(quantity) * parseFloat(estMatePrice);
            var outputUnotTotal = parseInt(quantity) * parseFloat(price);
			
			//var outputEstmt = parseInt(quantity) * parseFloat(estMatePrice);
			outputSoPriceTotal=parseFloat(outputSoPriceTotal)+parseFloat(outputUnotTotal);
			 $("input[name='initial_est_purchase_price[]']").eq(index).val(numberToIndPrice(output.toFixed(2)));
			
			output=parseFloat(output)-parseFloat(Discprice);
            var tax = parseFloat(output) * parseFloat(gst)/100;
			if (!isNaN(output))
            {
				Amount=parseFloat(Amount)+parseFloat(output);
                $("input[name='total[]']").eq(index).val(numberToIndPrice(outputUnotTotal.toFixed(2)));
				if($('#add_gst').is(":checked"))
                {   
					IGST = parseFloat(IGST)+parseFloat(tax);
					SCGST = parseFloat(IGST)/2;
					var addgst_subTotal = parseFloat(tax) + parseFloat(output);
					$("input[name='sub_total_with_gst[]']").eq(index).val(addgst_subTotal.toFixed(2));
					if($('#igst_checked').is(":checked")){
						
					$("input[name='igst[]']").eq(index).val(tax.toFixed(2));
					   $("input[name='cgst[]']").eq(index).val('');
					   $("input[name='sgst[]']").eq(index).val('');
					}else if($('#csgst_checked').is(":checked"))
					{
						$("input[name='igst[]']").eq(index).val('');
						var taxs = parseFloat(tax)/2;
					   $("input[name='cgst[]']").eq(index).val(taxs.toFixed(2));
					   $("input[name='sgst[]']").eq(index).val(taxs.toFixed(2));
				    }
				}
				
			}
	});
	
	
	var userMargin=parseFloat(outputSoPriceTotal)-parseFloat(Amount);
	
	var discount = document.getElementById('discounts').value;
	
	if(discount!="" && discount!=0){
	discount = discount.replace(/,/g, "");
	var cal_discount = parseFloat(discount);
	}else{
	var cal_discount=0;	
	}
	$('#discounts').val(numberToIndPrice(discount));
	
	$('#cal_disc').html(numberToIndPrice(cal_discount.toFixed(2)));
	$('#total_discount').val(numberToIndPrice(cal_discount.toFixed(2)));

   if(Amount>0){
	var TotalMargin=parseFloat(userMargin)-parseFloat(cal_discount);
	$("#ptMargin").html(numberToIndPrice(TotalMargin));
	$("#userProfit").val(TotalMargin);
	
	var cal_percent = (parseFloat(TotalMargin)*100)/(parseFloat(Amount));
    $("#profit_byUserPercent").html(cal_percent.toFixed(2)+'%');
	}else{
		$("#profit_byUserPercent").html("0.00%");
		$("#ptMargin").html('0.00');
		$("#userProfit").val('0');
	}
	

	//var GrandAmount=parseFloat(Amount)+parseFloat(IGST);
	var GrandAmount=parseFloat(Amount);
	GrandAmount=parseFloat(GrandAmount)-parseFloat(cal_discount);
	GrandAmount=parseFloat(GrandAmount)+parseFloat(IGST);
	$('#after_discount').val(GrandAmount);
	$("input[name='extra_chargevalue[]']").each(function (index) {
		var extra_charge = $("input[name='extra_chargevalue[]']").eq(index).val();
		extra_charge = extra_charge.replace(/,/g, "");
		$("input[name='extra_chargevalue[]']").eq(index).val(numberToIndPrice(extra_charge));
		if(extra_charge!== undefined && extra_charge!="")
		{
			extraCharge=parseFloat(extraCharge)+parseFloat(extra_charge);		    
		}
	});
	
	
	GrandAmount=parseFloat(GrandAmount)+parseFloat(extraCharge);
	
	$("#show_subAmount").html("₹&nbsp;"+numberToIndPrice(Amount.toFixed(2)));
	$('#initial_total').val(Amount.toFixed(2));
	$("#show_igst").html("₹&nbsp;"+numberToIndPrice(IGST.toFixed(2)));
	$("#show_cgst").html("₹&nbsp;"+numberToIndPrice(SCGST.toFixed(2)));
	$("#show_sgst").html("₹&nbsp;"+numberToIndPrice(SCGST.toFixed(2)));
	if($('#igst_checked').is(":checked")){
		$("#total_igst").val(IGST.toFixed(2));
		$("#total_cgst").val('');
		$("#total_sgst").val('');
	}else{
		$("#total_cgst").val(SCGST.toFixed(2));
		$("#total_sgst").val(SCGST.toFixed(2));
		$("#total_igst").val('');
	}
	
	
	$('#final_total').val(numberToIndPrice(GrandAmount.toFixed(2)));
	$('#digittowords').html(digit_to_words(GrandAmount));
}

/*END CALCULATION FUNCTION */



	i=1;
    var rowid=400;	
	$(".add_line").click(function()
    {
	  i++;
	  rowid++;
     var markup = '<tr class="removCL'+i+'" ><td><input type="text" name="product_name[]" class="form-control productItm checkvl" id="proName'+rowid+'" data-cntid="'+rowid+'" placeholder="Items name(required)"><span id="items_error"></span></td>'+
      '<td><input type="text" name="hsn_sac[]" class="form-control" id="hsn'+rowid+'" placeholder="HSN/SAC"></td>'+
	  '<td><input type="text" name="sku[]" class="form-control" id="sku'+rowid+'"  placeholder="SKU"></td>'+
      '<td class="gst"><input type="text" name="gst[]" class="form-control checkvl"  onkeyup="calculate_pro_price()" id="gst'+rowid+'" value="" placeholder="GST in %" list="taxName" ></td>'+
      '<td><input type="text" onkeyup="calculate_pro_price()" id="qty'+rowid+'" class="form-control checkvl integer_validqty'+i+'" name="quantity[]" placeholder="qty"><span id="quantity_error"></span></td>'+
      '<td><input type="text" name="unit_price[]"  id="price'+rowid+'" class="form-control start  price_float" onkeyup="calculate_pro_price()" placeholder="rate"><span id="unit_price_error"></td>'+ 
	  '<td><input type="text" onkeyup="calculate_pro_price()" name="discount_price[]" id="disc<?=$rw;?>" class="form-control price_float"  placeholder="Discount Price" value="0"></td>'+
	  '<td><input type="text" onkeyup="calculate_pro_price()" name="estimate_purchase_price[]" class="form-control start price_float"  placeholder="Estimate Price" ></td>'+
	  '<td><input type="text" onkeyup="calculate_pro_price()" name="initial_est_purchase_price[]"   class="form-control  price_float" placeholder="Total Estimate Price" readonly > </td>'+
	  '<td><input type="text" name="total[]" class="form-control" readonly>'+
       '<input type="hidden" name="cgst[]"  readonly>'+
      ' <input type="hidden" name="sgst[]" readonly>'+
       '<input type="hidden" name="igst[]"  readonly>'+
		'<input type="hidden" name="sub_total_with_gst[]" readonly></td> </tr>'+
		'<tr class="pro_descrption removCL'+i+' addCL'+i+'"><td colspan="10">'+
           '<input type="text" name="pro_description[]" class="form-control" id="" placeholder="Description"></td></tr>'+
          '<tr class="removCL'+i+'"><td class="delete_new_line" colspan="2" onClick="removeRow(`removCL'+i+'`);" >'+
                '<a href="javascript:void(0);"><i class="far fa-trash-alt delIcn"></i> Delete Row</a></td>'+ 
               '<td colspan="8"><a href="javascript:void(0);" class="add_desc deschd'+i+'" onClick="addDesc(`addCL'+i+'`,`deschd'+i+'`);"><i class="far fa-plus-square addIcn"></i> Add Description</a></td></tr>';
      $("#add_new_line").append(markup);
	  
	  $('.igst,.gst,.sub_total,.cgst,.sgst').hide();
	  
		if($('#add_gst').is(":checked"))
        {
			if($('#igst_checked').is(":checked"))
			{
				$('.sub_amount,.sub_total,.gst,.igst').show();
				$('.cgst,.sgst').hide();
				
				calculate_pro_price();
			}else if($('#csgst_checked').is(":checked"))
			{
				$('.sub_amount,.gst,.sub_total').show();
				$('.cgst,.sgst').show();
				$('.igst').hide();
				
				calculate_pro_price();
			}
		}
	//only integer validation on quantity		
	$(".integer_validqty"+i+"").inputFilter(function(value) {
      return /^-?\d*$/.test(value); });
	$(".float_validup"+i+"").inputFilter(function(value) {
     return /^-?\d*[.,]?\d{0,2}$/.test(value); });  
    });
	
   function removeRow(removCL){
       $("."+removCL).remove();
       calculate_pro_price();
   }
   
   function addDesc(addCL,deschd){
       $("."+addCL).show();
       $("."+deschd).hide();
       
   }
   
calculate_pro_price();
</script>

<script>
$(document).ready(function(){
	 $('#is_newed').click(function() {
		if($('#is_newed').is(":checked"))
        {
			$('.isRenewal').show();
		}else{
			$('.isRenewal').hide();
			$('#renewal_date_cal').val('');
			$('#renewal_date').val('');
			
		}
	 });
	
	
    $('#add_gst').click(function() {
		if($('#add_gst').is(":checked"))
        {
			$('.hide_gst_checkbox').show();
		    $('.gst,.igst,.sub_amount,.sub_total').show();
		    $('.cgst,.sgs').hide();
		    calculate_pro_price();
		}else{
		  $('.hide_gst_checkbox').hide();
		  $('').hide();
		  $('.gst,.igst,.cgst,.sgst,.sub_amount,.sub_total').hide();
          calculate_pro_price();		  
		}
		
    });
	
	/******by default show and hide start**********/
	//hide_gst_checkbox
	//$('.hide_gst_checkbox').toggle("hide");
	$('.sub_amount,.cgst,.sgst,.discount').hide();
	$('#errorMsgbox').hide();
	$('.add_discount,.add_signature,.add_attach').show();
	
	/*<?php if(isset($record['gst']) && $record['gst']!=""){ ?> $('#add_gst').click(); <?php } ?>*/
	
	/******by default show and hide end**********/
	
	
   $('#igst_checked').click(function() {	
	  gstShow();
   });
   $('#csgst_checked').click(function() {
	   gstShow();
   });
   
   gstShow();
   function gstShow(){
	   $('.sub_amount').show();
	   $('.gst').show();
	   $('.sub_total').show();
	   if($('#igst_checked').is(":checked"))
       {
			$('.igst').show();
			$('.cgst').hide();
			$('.sgst').hide(); 
	   }else if($('#csgst_checked').is(":checked")){
			$('.igst').hide();
			$('.cgst').show();
			$('.sgst').show();  
	   }
	   calculate_pro_price();
   }
   
  
   //add product description 
   $('.add_desc').click(function() {   
	    $(this).hide();
	});
	
	
	
	//add discount
	$('.add_discount').click(function() {   
	    $('.add_discount').hide();
		$('.discount').show();
	});
	$('#remove_discount').click(function() {   
	    $('.add_discount').show();
		$('.discount').hide();
		$('#discounts').val("");
		$('#cal_disc').html("");
		calculate_pro_price();
	});
	<?php if(isset($record['discount']) && $record['discount']!=""){ ?>
		$('.add_discount').click(); 
	<?php } ?>
	
	
	
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
	
	
	
	//add more extra charge and value 
	var i = 1;
	$('.add_additionalchg').click(function() {  
	    i++;
	    var markup = '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="ext'+i+'" style="margin-bottom: 3%;"> <input type="text" name="extra_charge[]" value="Enter Charge Name" placeholder="Extra Charges" class="form-control clkLabel" ></div>'+
		'<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5" id="extVl'+i+'" style="margin-bottom: 3%;"><input type="text" onkeyup="calculate_pro_price()" name="extra_chargevalue[]" id="floatvald'+i+'"  value="" class="form-control inptvl"></div>'+
             '<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right" id="rows'+i+'" style="margin-bottom: 3%;"><a href="javascript:void(0);" class="remove_additionalchg" id="'+i+'"><i class="fas fa-times"></i></a></div>';

	  $("#putExtraVl").append(markup);
	  $("#floatvald"+i+"").inputFilter(function(value) {
       return /^-?\d*[.,]?\d{0,2}$/.test(value); });
	  
	});
	
	$(document).on('click','.remove_additionalchg',function(){
        var button_id = $(this).attr("id");
        $("#ext"+button_id+", #extVl"+button_id+", #rows"+button_id).remove();
		$("#floatvald"+button_id).val("");
		calculate_pro_price()
    });
	
	$("input[name='extra_charge[]']").click(function(){
		$(this).removeClass('clkLabel');
		$(this).addClass('form-control');
	});
	$("input[name='extra_charge[]']").mouseleave(function(){
		$(this).addClass('clkLabel');
	});
	
	
	
	
});
</script>
<script>
$(document).ready(function()
{
	 var i = 0;
    $("#add_terms_condition").click(function()
    {
		 i++;
        var markup = '<div class="row" id="addterms'+i+'"> <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right">'+
          '<p>'+i+'.</p></div> <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10"> <input type="text" name="terms_condition[]" placeholder="Write Your Conditions">'+
        '</div><div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1"> <a href="javascript:void(0);" class="remove_terms" id="'+i+'">X</a></div> </div>';
		
		$("#terms_condition").append(markup);
		countPtg();
	});
		
    // Find and remove selected table rows
	$("#terms_condition").on('click','.remove_terms',function(){
        var button_id = $(this).attr("id");
        $("#addterms"+button_id+"").remove();
        countPtg();

    });
    
    function countPtg(){
        var arr = $('#terms_condition p');
        var cnt=1;
        for(i=0;i<arr.length;i++)
        {
          $(arr[i]).html(cnt+".");
          cnt++;
        }
    }
    
    
	
});


</script>
<script type='text/javascript'>
function changeGst(adminGst,otherGst){
	var stateNo=otherGst.substring(0, 2);
	var yourStateNo=adminGst.substring(0, 2);
	if(stateNo==yourStateNo){
		$("#igst_checked").attr('checked', false);
		$("#csgst_checked").attr('checked', true);
		$('#csgst_checked').click();
		//gstShow();
	}
}



    $('#branch').change(function(){
      var branch_name = $(this).val();
      // AJAX request   
      $.ajax({
        url:'<?=base_url('purchaseorders/getbranchVal')?>',
        method: 'post',
        data: {branch_name: branch_name},
        dataType: 'json',
        success: function(response){
          var len = response.length;
          if(len > 0)
          {
            var country = response[0].country;
            var state = response[0].state;
            var city = response[0].city;
            var zipcode = response[0].zipcode;
            var address = response[0].address;
            var gstin = response[0].gstin;
			 
            var supplier_gstin = $('#supplier_gstin').val();
			
			changeGst(gstin,supplier_gstin);
            $('#billing_country').val(country);
            $('#billing_state').val(state);
            $('#billing_city').val(city);
            $('#billing_zipcode').val(zipcode);
            $('#billing_address').val(address);
            $('#gstin').val(gstin);
			
          }
          else
          {
            $('#billing_country').val('');
            $('#billing_state').val('');
            $('#billing_city').val('');
            $('#billing_zipcode').val('');
            $('#billing_address').val('');
            $('#gstin').val('');
          }
        }
      });
    });
  </script>
  
  <script type='text/javascript'>
  $(document).ready(function(){
        $("#supplier_comp_name").change(function () {
        var supplier_comp_name = $(this).val();
        // alert(supplier_comp_name);

        $.ajax({
          url : "<?php echo base_url('Purchaseorders/getSupplierName');?>",
          type : "Post",
          data : {supplier_comp_name:supplier_comp_name},
          success : function (response)
          {
            $("#supplier_name").html(response);
            
          },
          error: function () {
            alert('data not found');
          },
        });
      });
      $(document).on('change', '#supplier_name', function ()
      {
        var supplier_name = $(this).val();
        $.ajax({
          url : "<?php echo base_url('Purchaseorders/getSupplierDetails');?>",
          type : "Post",
          data : {supplier_name:supplier_name},
          success : function (data)
          {
            $("#supplier_contact").val(data[0].mobile);
            $("#supplier_email").val(data[0].email);
          },
          error: function () {
            alert('data not found');
          },
        });
      });
    $('#branch_s').change(function(){
      var branch_name = $(this).val();
      // AJAX request
      $.ajax({
        url:'<?=base_url('purchaseorders/getbranchVal')?>',
        method: 'post',
        data: {branch_name: branch_name},
        dataType: 'json',
        success: function(response){
          var len = response.length;
          if(len > 0)
          {
            var country = response[0].country;
            var state = response[0].state;
            var city = response[0].city;
            var zipcode = response[0].zipcode;
            var address = response[0].address;
            var gstin = response[0].gstin;
            $('#shipping_country').val(country);
            $('#shipping_state').val(state);
            $('#shipping_city').val(city);
            $('#shipping_zipcode').val(zipcode);
            $('#shipping_address').val(address);
            $('#s_gstin').val(gstin);
          }
          else
          {
            $('#shipping_country').val('');
            $('#shipping_state').val('');
            $('#shipping_city').val('');
            $('#shipping_zipcode').val('');
            $('#shipping_address').val('');
            $('#s_gstin').val('');
          }
        }
      });
    });
  });
  
  </script>
  <script>
    
      $('#supplier_comp_name').autocomplete({
        source: "<?= base_url('purchaseorders/autocomplete_vendor');?>",
        select: function (event, ui) {
          $(this).val(ui.item.label);
          $('#supplier_comp_name').each(function(){
            var supplier_name = $(this).val();
            $.ajax({
              url:'<?=base_url('purchaseorders/get_vendor_details')?>',
              method: 'post',
              data: {supplier_name: supplier_name},
              dataType: 'json',
              success: function(response){
                var len = response.length;
                if(len > 0)
                {
                  $('#supplier_contact').val(response[0].mobile);
                  $('#supplier_name').val(response[0].primary_contact);
                  $('#supplier_email').val(response[0].email);
                  $('#supplier_country').val(response[0].shipping_country);
                  $('#supplier_state').val(response[0].shipping_state);
                  $('#supplier_city').val(response[0].shipping_city);
                  $('#supplier_zipcode').val(response[0].shipping_zipcode);
                  $('#supplier_address').val(response[0].shipping_address);
                  $('#supplier_gstin').val(response[0].gstin);
                  $('#supplier_gstin').val(response[0].gstin);
				  var userGst=$('#gstin').val();
				  changeGst(userGst,response[0].gstin);
                }
                else
                {
                  $('#supplier_contact').val('');
                  $('#supplier_name').val('');
                  $('#supplier_email').val('');
                  $('#supplier_country').val('');
                  $('#supplier_state').val('');
                  $('#supplier_city').val('');
                  $('#supplier_zipcode').val('');
                  $('#supplier_address').val('');
                  $('#supplier_gstin').val('');
                }
              }
            });
          });
        }
      });
  </script>
<script>

	$('.add_terms').click(function() {   
	    $('#show_terms').show();
        $('.add_terms').hide();		
	});
	<?php if(isset($record['terms_condition'])){ ?>
		$('#show_terms').show();
        $('.add_terms').hide();	
	<?php } ?>
</script>
