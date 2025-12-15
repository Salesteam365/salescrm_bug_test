<!-- common header include -->
<?php $this->load->view('common_navbar');?>
<!-- common header include -->
<style>
   .content-header {background: #fff;}

   .linkscontainer{
  width:65vw;
  padding:20px;
  padding-top:50px;
  border-radius:10px;
  box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
  margin:50px auto;
  margin-bottom:50px;
  
}
@media screen and (max-width: 576px) {
  .linkscontainer {
    width: 100vw;
  }
}
</style>
<!-- Content Wrapper. Contains page content -->
<?php 
   $ci 		=& get_instance();
   $QuotCount 	= $ci->Salesorders->check_quot_exist($record['quote_id']);
   $PiCount 	= $ci->Quotation->check_pi_exist($record['quote_id']);
   ?>
<div class="content-wrapper">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
               <div class="left-buttons">
                  <ul class="list-group list-group-horizontal">
                     <li class="list-group-item text-center">
                        <a href="<?=base_url('quotation');?>">
                           <div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"/></div>
                           Back
                        </a>
                     </li>
                     <li class="list-group-item text-center">
                        <a href="<?=base_url();?>add-quote/<?=$record['id'];?>">
                           <div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"/></div>
                           Edit
                        </a>
                     </li>
                     <?php  if($this->session->userdata('create_so')=='1' && $QuotCount<1){ ?>
                     <li class="list-group-item text-center">
                        <a href="<?=base_url();?>add-salesorder?qt=<?=$record['id'];?>">
                           <div><img src="https://img.icons8.com/fluent/18/000000/create-order.png"/></div>
                           Create Sales Order
                        </a>
                     </li>
                     <?php } ?>
                     <?php  if($this->session->userdata('create_pi')=='1' && $PiCount<1){ ?>
                     <!--<li class="list-group-item text-center">-->
                     <!--   <a href="<?=base_url();?>proforma_invoice/create_newProforma?pg=quotation&qt<?=$record['quote_id'];?>">-->
                     <!--      <div><img src="https://img.icons8.com/nolan/18/invoice-1.png"/></div>-->
                     <!--      Create PI-->
                     <!--   </a>-->
                     <!--</li>-->
                     <?php } ?>  
                  </ul>
               </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
               <div class="right-buttons d-flex justify-content-end">
                  <ul class="list-group list-group-horizontal">
                     <li class="list-group-item text-center">
                        <a href="<?=base_url();?>quotation/view/<?=$record['id']?>" target="_blank">
                           <div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>
                           Print
                        </a>
                     </li>
                     <li class="list-group-item text-center">
                        <a href="<?=base_url();?>quotation/view/<?=$record['id']?>/dn" target="_blank">
                           <div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>
                           Download
                        </a>
                     </li>
                     <li class="list-group-item text-center" onclick="update_billedby(15)" style="cursor:pointer;" >
                        <a>
                           <div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>
                           Share
                        </a>
                     </li>
                     <!--<li class="list-group-item text-center" onClick="shareEmail();">-->
                     <!--   <a href="javascript:void(0)" >-->
                     <!--      <div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>-->
                     <!--      Email invoice-->
                     <!--   </a>-->
                     <!--</li>-->
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div id="main" class="content">
      <div class="container-fluid">
         <div class="accordion" id="faq">
            <div class="card">
               <div class="card-header" id="faqhead1"> <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1" style="background:rgba(230,242,255,0.4); color:black;"><i class="fas fa-file-alt"></i> Quick Quotation Detail</a>
               </div>
               <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                  <div class="card-body">
                     <div class="row">
                        <div class="col">
                           <b>Quotation Id</b>
                           <p><?=$record['quote_id']?></p>
                        </div>
                        <div class="col">
                           <b>Billed To</b>
                           <p><?=$record['org_name']?></p>
                        </div>
                        <div class="col">
                           <b>Total Amount</b>
                           <p>₹ <?=$record['sub_totalq']?></p>
                        </div>
                        <div class="col">
                           <b>Quotation Date</b>
                           <?php 
                              //$date=date_create($record['invoice_date']);?>
                           <p><?=date('d-M-Y',strtotime($record['currentdate']));?></p>
                        </div>
                        <div class="col">
                           <b>Due Date</b>
                           <p><?=date('d-M-Y',strtotime($record['valid_until'])); ?></p>
                        </div>
                        <div class="col">
                           <b>Share</b>
                           <p><i class="fas fa-check-double"></i> Email Delivered</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header" id="faqhead2"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq2" aria-expanded="true" aria-controls="faq2" style="background:rgba(230,242,255,0.4); color:black;"><i class="fas fa-university"></i> Bank And UPI Detail</a>
               </div>
               <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                  <div class="card-body">
                     <?php if(isset($bank_details_terms->account_no)){ ?>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-sm-6">
                              <div class="bank-left">
                                 <div class="row">
                                    <div class="col-sm-2">
                                       <span><i class="fas fa-university"></i></span>
                                    </div>
                                    <div class="col-sm-8">
                                       <div class="bank-details-inner">
                                          <h4>Bank Account Transfer</h4>
                                          <p>NEFT, IMPS, CASH</p>
                                          <span>Benefits: Free for you</span> <br>
                                          <span>Transaction Charges: None</span>
                                       </div>
                                    </div>
                                    <div class="col-sm-2">
                                       <div class="details-switch">
                                          <label class="switch">
                                          <input type="checkbox" id="slider_check" onChange="enable_bank('<?=$bank_details_terms->id;?>')" name="slider_check" <?php if($bank_details_terms->enable_payment==1){ echo 'checked'; }?>>
                                          <span class="slider round" ></span>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="bank-name">
                                    <div class="row">
                                       <div class="col-sm-2"></div>
                                       <div class="col-sm-10">
                                          <div class="bank-details-inner">
                                             <a href="#" onClick="addBankupi();" class="float-right"><i class="fas fa-check"></i> Selected</a>
                                             <h4><?=$bank_details_terms->bank_name;?></h4>
                                             <span><?=$bank_details_terms->acc_holder_name;?></span> <br>
                                             <span>Acc. No: <?=$bank_details_terms->account_no;?></span><br>
                                             <span>IFSC: <?=$bank_details_terms->ifsc_code;?></span>
                                          </div>
                                          <a href="#" onClick="addBankupi();"><i class="fas fa-cog"></i> Edit Bank Details</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="bank-left">
                                 <div class="row">
                                    <div class="col-sm-2">
                                       <span><i class="fas fa-rupee-sign"></i></span>
                                    </div>
                                    <div class="col-sm-8">
                                       <div class="bank-details-inner">
                                          <h4>UPI</h4>
                                          <p>GooglePay, PhonePe, BHIM</p>
                                          <span>Benefits: Convenient for You</span> <br>
                                          <span>Transaction Charges: None</span>
                                       </div>
                                    </div>
                                    <!--<div class="col-sm-2">
                                       <div class="details-switch">
                                           <label class="switch">
                                             <input type="checkbox" checked>
                                             <span class="slider round"></span>
                                           </label>
                                       </div>
                                       </div>-->
                                 </div>
                                 <div class="bank-name">
                                    <div class="row">
                                       <div class="col-sm-2"></div>
                                       <div class="col-sm-10">
                                          <?php if($bank_details_terms->upi_id!==""){ ?>
                                          <span>UPI ID: <?=$bank_details_terms->upi_id;?></span>
                                          <?php } ?>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-2"></div>
                                       <div class="col-sm-10">
                                          <div class="bank-details-inner" style="visibility: hidden;"></div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <ul class="list-group list-group-horizontal">
                        <?php } else{ ?>
                        <li class="list-group-item" onClick="addBankupi();"><a href="#"><i class="fas fa-cog"></i> Add Bank</a></li>
                        <p>Bank Account details are required to show them on Invoice and to enable payment options.</p>
                        <?php } ?>	
                     </ul>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header" id="faqhead3"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq3" aria-expanded="true" aria-controls="faq3" style="background:rgba(230,242,255,0.4); color:black;"><i class="fab fa-cc-visa"></i> Online Payment Options</a>
               </div>
               <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq">
                  <div class="card-body">
                     <h3>Bank Account details are required to show them on Invoice and to enable payment options.</h3>
                     <h5>Terms And Conditions</h5>
                     <ul>
                        <?php if(isset($bank_details_terms->terms_condition)){ 
                           $terms_condition=explode("<br>",$bank_details_terms->terms_condition);
                           $i=1;
                           for($tm=0; $tm<count($terms_condition); $tm++){
                           ?>
                        <li><?=$terms_condition[$tm];?></li>
                        <?php } } ?>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="card">
               <div class="card-header" id="faqhead7"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq7" aria-expanded="true" aria-controls="faq7" style="background:rgba(230,242,255,0.4); color:black;"><i class="fas fa-link"></i> Linked Quotation</a>
               </div>
               <div id="faq7" class="collapse" aria-labelledby="faqhead7" data-parent="#faq">
                  <div class="card-body">
                     <table class="table table-responsive-lg">
                        <thead>
                           <tr>
                              <th>Quotation#</th>
                              <th>Quotation Date</th>
                              <th>Quote Stage</th>
                              <th>Courier</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><?=$record['quote_id']?></td>
                              <td><?=date('d-M-Y',strtotime($record['currentdate'])); ?></td>
                              <td><?=$record['quote_stage']?></td>
                              <td><?=$record['carrier']?></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="linkscontainer">
   <div class="invoice-type">
      <div class="container">
         <h1>Quotation</h1>
         <hr>
         <div class="row mt-3">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
               <p>Quotation</p>
               <p>Quotation Id#</p>
               <p>Quotation Date</p>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-6">
               <p><b><?=$record['subject']?></b></p>
               <p><b><?=$record['quote_id']?></b></p>
               <p><b><?=date('d-M-Y');?></b></p>
            </div>
         </div>
         <div class="invoice-address-info mt-3">
            <div class="row">
               <div class="col">
                  <div class="billed-by" style="background:rgba(35, 0, 140, 0.8)">
                     <h3>Billed By</h3>
                     <b><?=$this->session->userdata('company_name');?></b>
                     <p><?=$this->session->userdata('company_address');?></p>
                     <p><?=$this->session->userdata('city');?></p>
                     <p><?=$this->session->userdata('state');?>-<?=$this->session->userdata('zipcode');?>, <?=$this->session->userdata('country');?></p>
                  </div>
               </div>
               <div class="col">
                  <div class="billed-to billed-by" style="background:rgba(35, 0, 140, 0.8)">
                     <h3>Billed To</h3>
                     <b><?=$record['contact_name'];?></b><br>
                     <b><?=$record['org_name'];?></b><br>
                     <b><?=$record['billing_address'];?></b><br>
                     <p><?=$record['billing_city'];?>,<?=$record['billing_state'];?>-<?=$record['billing_zipcode'];?>, <?=$record['billing_country'];?></p>
                  </div>
               </div>
            </div>
         </div>
         <div class="invoice-table mt-3 text-left">
            <div class="row">
               <div class="col">
                  <p><b>Country of Supply :</b> <?=$record['billing_country'];?></p>
               </div>
               <div class="col">
                  <p><b>Place of Supply :</b> <?=$record['billing_city'];?> (<?=$record['billing_zipcode'];?>)</p>
               </div>
            </div>
            <?php $discount		= explode("<br>",$record['pro_discount']); ?>
            <table class="table table-responsive-lg">
               <thead style="background:rgba(35, 0, 140, 0.8)">
                  <tr>
                     <th>S.No</th>
                     <th>Product/Services</th>
                     <th>Type</th>
                     <th>HSN/SAC</th>
                     <th>Tax</th>
                     <th>Qty</th>
                     <th>Rate</th>
                     <?php if(count($discount)>0){ ?>
                     <th>Discount</th>
                     <?php } ?>
                     <th>Amount</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $totaliGst = 0;
                     $totalsGst = 0;
                     $totalcGst = 0;
                     
                     if ($record['product_name'] != "") {
                         $product_name = explode("<br>", $record['product_name']);
                         if (!empty($record['gst'])) {
                             $gst = explode("<br>", $record['gst']);
                         }
                         $quantity = explode("<br>", $record['quantity']);
                         $unit_price = explode("<br>", $record['unit_price']);
                         $hsnsac = explode("<br>", $record['hsn_sac']);
                         $quote_item_type = explode("<br>", $record['quote_item_type']);
                         $total = explode("<br>", $record['total']);
                         $descriptionPro = explode("<br>", $record['pro_description']);
                         $initTot = 0;
                     
                         for ($rw = 0; $rw < count($product_name); $rw++) {
                             $num = $rw + 1;
                             ?>
                  <tr>
                     <td><?= $num; ?></td>
                     <td style="cursor:pointer;" data-toggle="collapse" href="#proDesc<?=$rw;?>" ><?=$product_name[$rw];?></td>
                     <td><?php if($quote_item_type[$rw] == 0){echo "New";}else{echo "Renew";}?></td>
                     <td><?=$hsnsac[$rw];?></td>
                     <td><?= !empty($gst) ? 'GST@'.$gst[$rw].'%' : 'GST@18%'; ?></td>
                     <td><?=$quantity[$rw];?></td>
                     <td>₹ <?= IND_money_format($unit_price[$rw]);?></td>
                     <td>₹ <?php if (isset($discount[$rw])) { echo IND_money_format($discount[$rw]); } else { echo "0"; }?></td>
                     <?php $initTot = $initTot + $total[$rw]; ?>
                     <td>₹ <?= IND_money_format($total[$rw]);?></td>
                  </tr>
                  <tr class="collapse" id="proDesc<?=$rw;?>" >
                     <td colspan="8" style="border-top: 0px solid !important; font-size: 14px;"><?php if (isset($descriptionPro[$rw]) && $descriptionPro[$rw] != "") { echo $descriptionPro[$rw]; } else { echo "NA"; } ?></td>
                  </tr>
                  <?php } 
                     } 
                     ?>
               </tbody>
            </table>
         </div>
         <div class="bank-total">
            <div class="row">
               <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-6">
                  <div class="bank-total-left">
                     <p>Total In Words: <b>
                        <?php  $get_amount= AmountInWords($record['sub_totalq']);
                           echo $get_amount;
                           ?></b>
                     </p>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                  <div class="bank-total-right">
                     <div class="row">
                        <div class="col">
                           Initial Total
                        </div>
                        <div class="col text-right">
                           ₹ <?=IND_money_format($initTot);?>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col">
                           Over All Discount
                        </div>
                        <?php if($record['discount_type']=='in_percentage'){ ?>
                        <div class="col text-right">
                           <?=IND_money_format($record['overall_discount']);?> %
                        </div>
                        <?php }else{ ?>
                        <div class="col text-right">
                           ₹ <?=IND_money_format($record['overall_discount']);?>
                        </div>
                        <?php } ?>
                     </div>
                     <div class="row">
                        <div class="col">
                           Sub Total
                        </div>
                        <div class="col text-right">
                           ₹ <?=IND_money_format($record['initial_total']);?>
                        </div>
                     </div>
                     <?php if($record['discount']>0){?>
                     <div class="row">
                        <div class="col">
                           Discount
                        </div>
                        <div class="col text-right">
                           (₹ <?=IND_money_format($record['discount']);?>)
                        </div>
                     </div>
                     <?php 
                        }
                        $type = $record['type'];
                        if($type == "Interstate")
                        {
                        if($record['total_igst']>0){ ?>
                     <div class="row">
                        <div class="col">IGST</div>
                        <div class="col text-right">
                           ₹ <?=IND_money_format($record['total_igst']); ?>
                        </div>
                     </div>
                     <?php } }else{ ?>
                     <?php if($record['total_cgst']>0){?>
                     <div class="row">
                        <div class="col">CGST</div>
                        <div class="col text-right">
                           ₹ <?=IND_money_format($record['total_cgst']); ?>
                        </div>
                     </div>
                     <?php } ?>
                     <?php if($record['total_sgst']>0){?>
                     <div class="row">
                        <div class="col">SGST</div>
                        <div class="col text-right">
                           ₹ <?=IND_money_format($record['total_sgst']); ?>
                        </div>
                     </div>
                     <?php } } ?>
                     <?php if(isset($record['extra_charge_label'])){
                        $labelExra=explode("<br>",$record['extra_charge_label']);
                        $valueExra=explode("<br>",$record['extra_charge_value']);
                        for($i=0; $i<count($labelExra); $i++){
                            if(isset($labelExra[$i]) && !empty($labelExra[$i])){
                        ?>
                     <div class="row">
                        <div class="col"><?php echo $labelExra[$i]; ?></div>
                        <div class="col text-right">
                           ₹ <?=IND_money_format($valueExra[$i]); ?>
                        </div>
                     </div>
                     <?php } } } ?>
                     <hr>
                     <div class="row">
                        <div class="col">
                           Total (INR)
                        </div>
                        <div class="col text-right">
                           ₹ <?=IND_money_format($record['sub_totalq']);?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="terms-condition">
            <p>Terms and Condition</p>
            <ol style="list-style:decimal;">
               <?php if($record['terms_condition']!=""){
                  $terms_condition=explode("<br>",$record['terms_condition']);
                  for($in=0; $in<count($terms_condition); $in++){
                  ?>
               <li><?=$terms_condition[$in];?></li>
               <?php } } ?>
            </ol>
         </div>
      </div>
   </div>
</div>


   <div class="content-header">
      <div class="container">
         <div class="row">
            <!--<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">-->
            <!--   <div class="left-buttons">-->
            <!--      <ul class="list-group list-group-horizontal">-->
            <!--         <li class="list-group-item text-center">-->
            <!--            <a href="<?=base_url('quotation');?>">-->
            <!--               <div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"/></div>-->
            <!--               Back-->
            <!--            </a>-->
            <!--         </li>-->
            <!--         <li class="list-group-item text-center">-->
            <!--            <a href="<?=base_url();?>add-quote/<?=$record['id'];?>">-->
            <!--               <div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"/></div>-->
            <!--               Edit-->
            <!--            </a>-->
            <!--         </li>-->
            <!--         <?php  if($this->session->userdata('create_so')=='1' && $QuotCount<1){ ?>-->
            <!--         <li class="list-group-item text-center">-->
            <!--            <a href="<?=base_url();?>add-salesorder?qt=<?=$record['id'];?>">-->
            <!--               <div><img src="https://img.icons8.com/fluent/18/000000/create-order.png"/></div>-->
            <!--               Create Sales Order-->
            <!--            </a>-->
            <!--         </li>-->
            <!--         <?php } ?>-->
            <!--         <?php  if($this->session->userdata('create_pi')=='1' && $PiCount<1){ ?>-->
                     <!--<li class="list-group-item text-center">-->
                     <!--   <a href="<?=base_url();?>proforma_invoice/create_newProforma?pg=quotation&qt<?=$record['quote_id'];?>">-->
                     <!--      <div><img src="https://img.icons8.com/nolan/18/invoice-1.png"/></div>-->
                     <!--      Create PI-->
                     <!--   </a>-->
                     <!--</li>-->
            <!--         <?php } ?>  -->
            <!--      </ul>-->
            <!--   </div>-->
            <!--</div>-->
            
            <!--<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">-->
            <!--   <div class="right-buttons d-flex justify-content-end">-->
            <!--      <ul class="list-group list-group-horizontal">-->
            <!--         <li class="list-group-item text-center">-->
            <!--            <a href="<?=base_url();?>quotation/view/<?=$record['id']?>" target="_blank">-->
            <!--               <div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>-->
            <!--               Print-->
            <!--            </a>-->
            <!--         </li>-->
            <!--         <li class="list-group-item text-center">-->
            <!--            <a href="<?=base_url();?>quotation/view/<?=$record['id']?>/dn" target="_blank">-->
            <!--               <div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>-->
            <!--               Download-->
            <!--            </a>-->
            <!--         </li>-->
            <!--         <li class="list-group-item text-center" onclick="update_billedby(15)" style="cursor:pointer;" >-->
            <!--            <a>-->
            <!--               <div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>-->
            <!--               Share-->
            <!--            </a>-->
            <!--         </li>-->
            <!--         <li class="list-group-item text-center" onClick="shareEmail();">-->
            <!--            <a href="javascript:void(0)">-->
            <!--               <div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>-->
            <!--               Email invoice-->
            <!--            </a>-->
            <!--         </li>-->
            <!--      </ul>-->
            <!--   </div>-->
            <!--</div>-->
         </div>
         <div class="milestones" id="my2"></div>
      </div>
   </div>
</div>
<style>
   .shareIcn{
   font-size: 33px;
   cursor: pointer;
   }
   .fa-whatsapp{
   color: #4caf5094
   }
   .fa-envelope{
   color: #ff57228c;
   }
   .fa-link{
   color: #1918188c;
   }
   .lbl{
   padding-top: 12px;
   }
</style>
<div class="modal fade" id="branch_details" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header text-center">
            <h4 class="modal-title">Share Invoice Link</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12 text-center">
                  <h6>A link is genereted for this invoice. Share the link with your client to get paid.</h6>
               </div>
            </div>
            <div class="row">
               <div class="col-md-3"></div>
               <div class="col-md-6">
                  <div class="row text-center " style="padding-top: 5%;">
                     <div class="col-md-4">
                        <i class="fab fa-whatsapp shareIcn" onClick="share();"></i>
                        <text style="display: block;">WhatsApp</text>
                     </div>
                     <div class="col-md-4">
                        <i class="far fa-envelope shareIcn" onClick="shareEmail();"></i>
                        <text style="display: block;">Email</text>
                     </div>
                     <div class="col-md-4">
                        <?php $actual_link = base_url()."quotation/view/".$record['id']; ?>
                        <input type="hidden" name="invoiceurlCp" id="invoiceurlCp" value="<?=$actual_link;?>" >
                        <i class="fas fa-link shareIcn iconcopy" onclick='copyToClipboard("<?=$actual_link;?>")'></i>
                        <text style="display: block;" id="copy_linkmsg">Copy Link</text>
                     </div>
                  </div>
               </div>
               <div class="col-md-3"></div>
            </div>
            <div class="row">
               <div class="col-md-12 text-center" style="padding-top: 5%;">
                  Note: Anyone with the link can view this invoice.
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="emailModel" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header text-center">
            <h4 class="modal-title">Email Invoice</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body" style="padding: 5%;">
            <div class="row" id="formDiv">
               <div class="col-md-2 lbl">
                  <label for="">Client's Name:</label>
               </div>
               <div class="col-md-10">
                  <input type="text" class="form-control" value="<?=$record['org_name'];?>" name="orgName" id="orgName">
               </div>
               <div class="col-md-2 lbl">
                  <label for="">Client's Email:</label>
               </div>
               <div class="col-md-10">
                  <input type="text" class="form-control" value="<?=$record['org_email'];?>" name="orgEmail" id="orgEmail">
               </div>
               <div class="col-md-2 lbl">
                  <label for="">CC:</label>
               </div>
               <div class="col-md-10">
                  <input type="text" class="form-control" value="<?=$record['session_comp_email'];?>" name="ccEmail" id="ccEmail">
               </div>
               <div class="col-md-2 lbl">
                  <label for="">Subject:</label>
               </div>
               <div class="col-md-10">
                  <input type="text" class="form-control" value="Quotation For <?=$record['org_name'];?> - #<?=$record['quote_id'];?>" name="subEmail" id="subEmail">
               </div>
               <div class="col-md-12 lbl">
                  <label for="">Message*:</label>
               </div>
               <div class="col-md-12" style="font-size: 11px; margin: 3px 0px;">
                  Invoice PDF attachment and Online Link will be added to the email automatically.
               </div>
               <div class="col-md-12">
                  <textarea class="form-control" id="descriptionTxt"   name="descriptionTxt">
				<p>Hi <?=$record['org_name'];?>,</p>
				<p>Please find attached Quotation #<?=$record['quote_id'];?>.</p>
				<p>Quotation Id: #<?=$record['quote_id'];?></p>
				<p>Billed To: <?=$record['org_name'];?></p>
				<p>Total Amount: ₹ <?=IND_money_format($record['sub_totalq']);?></p>
				<p>Thank you for your business.</p>
				<p>Regards ,</p>
				<p><?=$this->session->userdata['company_name'];?>, <?=$this->session->userdata('city');?></p>
			  </textarea>
               </div>
            </div>
            <div class="row text-center"   id="messageDiv" style="display:none; padding: 5%; " >
            </div>
            <div class="row" id="footerDiv">
               <div class="col-md-10" style="padding-top: 5%;">
                  <i class="fas fa-info-circle"></i>&nbsp;&nbsp;Note: Anyone with the link can view this invoice.
               </div>
               <div class="col-md-2 text-center" style="padding-top: 5%;">
                  <button class="btn btn-info" id="sendEmail">Send Email</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!------ add bank modal---------->
<div class="modal fade" id="addbankmodal" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title" id="modal_title">Update Bank Account</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="row text-center"   id="bnkmessageDiv" style="display:none; padding: 5%; " >
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <form method="post" id="bank_details">
               <div class="row">
                  <input type="hidden" name="account_details_id" id="account_details_id" class="form-control">
                  <div class="col-md-6 form-group">
                     <label>Country</label>
                     <input type="text" name="bank_country" id="bank_country" class="form-control">
                     <!--<select class="form-control" name="bank_country" id="bank_country">
                        <option>India</option>
                        <option>USA</option>
                        <option>Uk</option>
                        <option>Nepal</option>
                        <option>Korea</option>
                        </select>-->
                     <span id="bank_country_error" style="color:red;"></span>
                  </div>
                  <div class="col-md-6 form-group">
                     <label><span>*</span> Bank's Name</label>
                     <input type="text" name="bank_name" id="bank_name" class="form-control">
                     <span id="bank_name_error" style="color:red;"></span>
                  </div>
                  <div class="col-md-6 form-group">
                     <label><span>*</span> Account Number</label>
                     <input type="text" name="account_no" id="account_no" class="form-control">
                     <span id="account_no_error" style="color:red;"></span>
                  </div>
                  <div class="col-md-6 form-group">
                     <label><span>*</span> Confirm Account Number</label>
                     <input type="text" id="caccount_no" class="form-control">
                     <span id="caccount_no_error" style="color:red;"></span>
                  </div>
                  <div class="col-md-6 form-group">
                     <label><span>*</span>IFSC</label>
                     <input type="text" name="ifsc_code" id="ifsc_code" class="form-control">
                     <span id="ifsc_code_error" style="color:red;"></span>
                  </div>
                  <div class="col-md-6 form-group">
                     <label>Account Type</label>
                     <select class="form-control" name="account_type" id="account_type">
                        <option value="saving">Saving</option>
                        <option value="current">Current</option>
                     </select>
                  </div>
                  <div class="col-md-6 form-group">
                     <label><span>*</span> Account Holder's Name</label>
                     <input type="text" name="acc_holder_name" id="acc_holder_name" class="form-control">
                     <span id="acc_holder_name_error" style="color:red;"></span>
                  </div>
                  <div class="col-md-6 form-group">
                     <label><span>*</span> Your Phone Number</label>
                     <input type="text" name="mobile_no" id="mobile_no" value="" class="form-control">
                     <span id="mobile_no_error" style="color:red;"></span>
                  </div>
                  <div class="col-md-12 form-group"> 
                     <label>
                     <input type="checkbox" id="show_upi_id" name="check_upi" value="checked_upi">
                     Add UPI
                     </label>
                  </div>
                  <div class="col-md-12 form-group" id="showhidediv" style="display:none;">                
                     <label>UPI</label>
                     <input type="text" name="upi_id" id="upi_id"  class="form-control">
                     <span id="upi_id_error" style="color:red;"></span>
                  </div>
                  <div class="col-md-12 form-group"> 
                     <label>	Payment Terms & Conditions </label> 
                  </div>
                  <div class="col-md-12 form-group">
                     <div class="row" id="putline">
                     </div>
                  </div>
                  <div class="col-md-12 form-group">
                     <a id="addtermsLine" style="cursor: pointer;" > <i class="fas fa-plus-circle"></i> Add terms & conditions</a>
                  </div>
               </div>
            </form>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="btnSave">Update</button>
         </div>
      </div>
   </div>
</div>


<!------ add bank modal---------->
<?php  
$stage=1.5;
$checks=1;
if(isset($QuotCount) && $QuotCount>0){ 
	$stage=2.5;
	$checks=2;
}

if(isset($$PiCount) && $$PiCount>0){ 
	$stage=3;
	$checks=3;
}

// if(count($proArr)==count($proArrPro) || count($proArr)>count($proArrPro)){ 
	// $stage=3;
	// $checks=3;
// }

?>

 <?php $this->load->view('footer');?>
<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<!-- common footer include -->
<script>
var editor = CKEDITOR.replace( 'descriptionTxt' );
CKEDITOR.config.height='150px';
</script>
<script>
function share() { 
        var message =  "<?php echo base_url();?>quotation/view/<?=$record['id']?>"; 
        window.open("https://web.whatsapp.com/send?text=" + message, '_blank'); 
}  

function update_billedby(id){ 
	$('#branch_details').modal('show'); 
}

function shareEmail(){ 
    $('#branch_details').modal('hide'); 
	$('#emailModel').modal('show'); 
}

/*function CopyFunction() {
  var copyText = document.getElementById("invoiceurlCp");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
  $('#branch_details').modal('hide');
}*/
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val(element).select();
  document.execCommand("copy");
  $temp.remove();
  $('#copy_linkmsg').text('Link copied'); 
  $('#copy_linkmsg').css('color','rgb(37 211 102)');
  $('.iconcopy').css('color','rgb(37 211 102)');
  setTimeout(function(){ $("#copy_linkmsg").text('Copy link'); $("#copy_linkmsg, .iconcopy").css('color','');  },4000)
  
}
    
$("#sendEmail").click(function(){
	var orgName=$("#orgName").val();
	var orgEmail=$("#orgEmail").val();
	var ccEmail=$("#ccEmail").val();
	var subEmail=$("#subEmail").val();
	var invoiceurl="<?php echo base_url();?>/quotation/view/<?=$record['id']?>";
	var quote_id ="<?=$record['id'];?>";
	var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
// 	var descriptionTxt = document.querySelector('#descriptionTxt').value;
// 	var descriptionTxt = document.querySelector('#descriptionTxt').innerHTML;


	$("#sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
	
	$.ajax({
        url: "<?= base_url('quotation/send_email'); ?>",
        method: "POST",
        data: {orgName:orgName,orgEmail:orgEmail,ccEmail:ccEmail,subEmail:subEmail,invoiceurl:invoiceurl,quote_id:quote_id},
        success: function(dataSucc){
            console.log(dataSucc);
            if(dataSucc==1){
        	    $("#formDiv, #footerDiv").hide();
            	$("#messageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your Quotation shared successfully.');
            	$("#messageDiv").css('display','block');
            	$("#sendEmail").html('Send Email');
            	setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); $('#emailModel').modal('hide'); },4000)
        	}
        	else{
        	 $("#formDiv, #footerDiv").hide();
        	 $("#messageDiv").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Your Quotation shared failed.');
        	 $("#messageDiv").css('display','block');
        	 $("#sendEmail").html('Send Email');
        	 setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); },4000)
        	}
        }
    });
});

</script>
<script>
/********Bank upi details*********/
function addBankupi(){      
	$('#addbankmodal').modal('show'); 
	//$('#bank_details')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

        // Reset error fields
        $("#bank_country_error").html('');
        $("#bank_name_error").html('');
        $("#account_no_error").html('');
        $("#caccount_no_error").html('');
        $("#mobile_no_error").html('');
		$("#ifsc_code_error").html('');
        $("#upi_id_error").html('');
       
		 $.ajax({
            url : "<?php echo site_url('proforma_invoice/getbankdetails')?>/",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
				if(data.st == 'add'){
					$('#bank_details')[0].reset();
				    $('#modal_title').text('Add Bank Details'); // Set title to Bootstrap modal title
					$('#btnSave').html('Add');
					save_method = 'add';
				}else{
               save_method = 'update';
              
			  $("#account_details_id").val(data.id);
              $("#bank_country").val(data.bank_country);
              $('#bank_name').val(data.bank_name);
			  $('#account_no').val(data.account_no);
			  $('#acc_holder_name').val(data.acc_holder_name);
			  $('#caccount_no').val(data.account_no);
			  $('#ifsc_code').val(data.ifsc_code);
			  /*if(data.account_type=='saving'){
			        $('#account_type').attr('selected',true);
			  }else if(data.account_type=='current'){
				   $('#account_type').attr('selected',true);
			  }*/
			  //
			  var type = data.account_type;
			  if(type!==''){
			      $("#account_type").find("option").remove();
			  if(type == 'saving'){
			      var acc_type = "<option value='saving' selected>Saving</option><option value='current'>Current</option>";
			  }else if(type == 'current'){
                 var acc_type = "<option value='saving'>Saving</option><option value='current' selected>Current</option>";
			  }
			   $("#account_type").append(acc_type);
				}
			  //alert(acc_type);
             
			  $('#mobile_no').val(data.register_mobile);
			  $('#upi_id').val(data.upi_id);
			  if(data.upi_id!==''){
				  //alert(data.upi_id);
				  $("#show_upi_id").attr('checked',true);
				  $("#showhidediv").show();
			  }
			  
			  var termsCondition = data.terms_condition.split('<br>');
			  if(termsCondition.length>0){
				$("#putline").html('');  
			  }
			  var no=252;
			  for (var i=0; i < termsCondition.length; i++)
              { 
				no++;
				appendLineb('putline',no,'terms_conditionbnk',termsCondition[i]);
			  }
			  
			  $('#modal_title').text('Update Bank Details'); // Set title to Bootstrap modal title
			  $('#btnSave').html('Update');
             
				}
			}
		 });
}
//show hide bank upi
$("#show_upi_id").click(function(){	
	if($("#show_upi_id").is(':checked')){
		//alert('checked');
		$("#showhidediv").show();		
	}else{		
		$("#showhidediv").hide();
		$('#upi_id').val("");
	}
});

function enable_bank(bankdetails_id){ 
	//alert(bankdetails_id);
	if($("#slider_check").is(':checked')){
	    $(".bank-name").show();
	    var bank_status = 1;	  
	}else{
		$(".bank-name").hide();
		var bank_status = 0;
	}
	$.ajax({
            url : "<?php echo site_url('proforma_invoice/changebankstatus')?>",
            type: "post",
			data:{bankdetails_id:bankdetails_id,bank_status:bank_status},
            dataType: "JSON",
            success: function(data)
            {
				if(data.st == 200){
					if($("#slider_check").is(':checked')){
						$("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Payment options successfully enable.');
						$("#alert_popup").modal('show');
						setTimeout(function(){ $("#alert_popup").modal('hide');  },2000);
					  //alert('payment options sucessfully enable');
					}else{
						$("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Payment options successfully disable.');
						$("#alert_popup").modal('show');
						setTimeout(function(){ $("#alert_popup").modal('hide'); },2000);
					  //alert('payment options sucessfully disable');
					}
				}else{
					$("#common_popupmsg").html('<i class="fa fa-exclamation-triangle" style="color: red;"></i><br>Some error occure!');
					$("#alert_popup").modal('show');
					setTimeout(function(){ $("#alert_popup").modal('hide');  },2000);
				}
			}
	});	
}
<?php if(isset($bank_details_terms->enable_payment) && $bank_details_terms->enable_payment==1){ ?> $(".bank-name").show(); <?php }?>

var no=421;
$("#addtermsLine").click(function(){
	no++;
	appendLineb('putline',no,'terms_conditionbnk','');
});

function countPtgb(pid){
        var arr = $('#'+pid+' p');
        var cnt=1;
        for(i=0;i<arr.length;i++)
        {
          $(arr[i]).html(cnt+".");
          cnt++;
        }
}

function appendLineb(appendDataid,no,inputName,value=''){
		var appendData='<div class="col-md-1 numberDisp " id="noid'+no+'"><p>'+no+'.</p></div>'+
		'<div class="col-md-10" id="inptdv'+no+'"><input type="text" id="inpt'+no+'" class="form-control inputbootomBor" name="'+inputName+'[]" value="'+value+'" placeholder="Online payment Terms & Condition" ></div>'+
		'<div class="numberDisp" style="" id="rm'+no+'"><i class="far fa-times-circle" onClick="removeRow('+no+',`'+appendDataid+'`)" ></i></div>';
		$("#"+appendDataid).append(appendData);
		countPtgb(appendDataid);
}
</script>
<script>
    $("#btnSave").click(function(e)
    {
      e.preventDefault();
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable
      var url;
      if(save_method == 'add') {
          url = "<?= site_url('proforma_invoice/create_bankDetails')?>";
      } else {
          url = "<?= site_url('proforma_invoice/update_bankDetails')?>";
      }
      
      // ajax adding data to database
     // var form=$("#bank_details").get(0);
     // var formData = new FormData(form);
	  
      var FormData = $('#bank_details').serialize();
	  //console.log(FormData);
	 
    if(checkValidationBank()==true){
       //alert(url); 
      $.ajax({
        url : url,
        type: "POST",
        data: FormData,
        dataType: "JSON",
       // async:false,
        success: function(data)
        {
			console.log(data);
          
          if(data.status) //if success close modal and reload ajax table
          {			
			$("#bnkmessageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Bank details updated successfully.');
			$("#bnkmessageDiv").css('display','block');
			setTimeout(function(){ $("#bnkmessageDiv").hide(); $('#addbankmodal').modal('hide'); },2000)
            //$('#addbankmodal').modal('hide');
            //reload_table();
          }
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
          if(data.st==202)
          {
			
            $("#bank_country_error").html(data.bank_country);
            $("#bank_name_error").html(data.bank_name);
            $("#account_no_error").html(data.account_no);
            $("#caccount_no_error").html(data.caccount_no);
			$("#ifsc_code_error").html(data.ifsc_code);
			$("#acc_holder_name_error").html(data.acc_holder_name);
            $("#mobile_no_error").html(data.mobile_no);           
            $("#upi_id_error").html(data.upi_id);
            
          }
          else if(data.st==200)
          {
            $("#bank_country_error").html();
            $("#bank_name_error").html();
            $("#account_no_error").html();
            $("#caccount_no_error").html();
            $("#mobile_no_error").html();
            $("#ifsc_code_error").html();
			$("#acc_holder_name_error").html();
            $("#upi_id_error").html();
          }
		 }
        // },
        // error: function (jqXHR, textStatus, errorThrown)
        // {
          // alert('Error adding / update data');
          // $('#btnSave').text('save'); //change button text
          // $('#btnSave').attr('disabled',false); //set button enable
        // }
      });
    }else{
          $('#btnSave').text('save'); 
          $('#btnSave').attr('disabled',false);
    }
    });
	
	 
/****** VALIDATION FUNCTION*********/
function changeClr(idinpt){
  $('#'+idinpt).css('border-color','red');
  $('#'+idinpt).focus();
  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
}

  function checkValidationBank(){

  var bank_country=$('#bank_country').val();
  var bank_name=$('#bank_name').val();
  var account_no=$('#account_no').val();
  var acc_holder_name=$('#acc_holder_name').val();
  var caccount_no=$('#caccount_no').val();
  var ifsc_code=$('#ifsc_code').val();
  var mobile_no=$('#mobile_no').val();
  var upi_id=$('#upi_id').val();
  //var show_upi_id=$('#show_upi_id').val();

    if(bank_country=="" || bank_country===undefined){
      changeClr('bank_country');
	  $("#bank_country_error").html("Country is a required field");
      return false;   
    }else if(bank_name=="" || bank_name===undefined){
      changeClr('bank_name');
	  $("#bank_name_error").html("Bank's Name is a required field");
      return false;   
    }else if(account_no=="" || account_no===undefined){
      changeClr('account_no');
	  $("#account_no_error").html("Account Number is a required field");
      return false;
    }else if(caccount_no=="" || caccount_no===undefined){
      changeClr('caccount_no');
	  $("#caccount_no_error").html('Confirm Account Number is a required field');
      return false;
    }else if(caccount_no!==account_no){
      changeClr('caccount_no');
	  $("#caccount_no_error").html('Confirm Account Number is not match');
      return false;
    }else if(ifsc_code=="" || ifsc_code===undefined){
      changeClr('ifsc_code');
	  $("#ifsc_code_error").html('IFSC code is a required field');
      return false;
	}else if(acc_holder_name=="" || acc_holder_name===undefined){
      changeClr('acc_holder_name');
	  $("#acc_holder_name_error").html("Account Holder's Name is a required field");
      return false;	
    }else if(mobile_no=="" || mobile_no===undefined){
      changeClr('mobile_no');
	  $("#mobile_no_error").html('Your Phone Number is a required field');
      return false;
    }else if($("#show_upi_id").is(':checked')){
		if(upi_id=="" || upi_id===undefined){
            changeClr('upi_id');
			$("#upi_id_error").html('UPI ID is a required field');
			return false;
		}else{
			return true;
		}
         
    }else{
      return true;
    } 
}


$('.form-control').keypress(function(){
  $(this).css('border-color','')
  $("#bank_details span").html("");
});
$('.form-control').change(function(){
  $(this).css('border-color','')
});

</script>

<script type="text/javascript">
$(document).ready(function(){
  $('#bank_country').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      //$('#country_ids').val(ui.item.values);
    }
  });
});
</script>

<script>document.getElementsByTagName("html")[0].className += " js";</script>
<script>
  $('#my2').milestones({
    stage: "<?=$stage?>",
    checks: "<?=$checks?>",
    stageclass: 'doneclass',
    labels: ["Quotatopn Details","SO Generated","PI Generated"]
  });
  
  
 
  
</script>