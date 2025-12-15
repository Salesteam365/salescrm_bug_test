<!-- common header include -->
<?php $this->load->view('common_navbar');?>
<!-- common header include -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<style>
    .content-header {background: #f2f2f2;}

    .linkscontainer{
  width:65vw;
  padding:20px;
  padding-top:50px;
  border-radius:10px;
  box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
  margin:auto auto;
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
$proArr=array();
$ci 	=& get_instance();
$ci->load->model('Purchaseorders_model','Purchaseorders');
$prddata= $ci->Purchaseorders->check_product($record['saleorder_id']);
for($i=0; $i<count($prddata); $i++){
	$proArr2=explode("<br>",$prddata[$i]['product_name']);
	for($k=0; $k<count($proArr2); $k++){
		$proArr[]=$proArr2[$k];
	}
}

$proArrPro=explode("<br>",$record['product_name']);

$PiCount 	= $ci->Quotation->check_pi_exist($record['saleorder_id']);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
							 <li class="list-group-item text-center"><a href="<?=base_url('salesorders');?>"><div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"/></div>Back</a>
                            </li>
							<li class="list-group-item text-center"><a href="<?=base_url();?>add-salesorder/<?=$record['id'];?>"><div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"/></div>Edit</a>
                            </li>
							<?php  if($this->session->userdata('create_po')=='1'){ ?>
							<?php if(count($proArr)!=count($proArrPro) && count($proArr)<count($proArrPro)){ 
							?>
							<li class="list-group-item text-center"><?php  if(isset($record['pay_terms_status']) && $record['pay_terms_status']==1){ ?>
							<a href="<?=base_url();?>add-purchase-order?so=<?=$record['id'];?>" >
							<?php }else{  ?>
							<a href="#" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending" >
							<?php } ?><div><img src="https://img.icons8.com/fluent/18/000000/purchase-order.png"/></div>Create Purchase Order</a>
                            </li>
							<?php }else{ ?>
							<li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Sales order already created"><a href="#" style="cursor: not-allowed;" ><div><img src="https://img.icons8.com/fluent/18/000000/purchase-order.png"/></div>Create Purchase Order</a>
                            </li>
							<?php } } ?>
							<?php  if($this->session->userdata('create_pi')=='1' && $PiCount<1){ ?>
							<!--<li class="list-group-item text-center"><a href="<?=base_url();?>proforma_invoice/create_newProforma?pg=salesorder&qt=<?=$record['saleorder_id'];?>"><div><img src="https://img.icons8.com/nolan/18/invoice-1.png"/></div>Create PI</a>-->
       <!--                     </li>-->
							<?php } ?> 
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons d-flex justify-content-end">
                        <ul class="list-group list-group-horizontal">
                             
							<?php  if(isset($record['pay_terms_status']) && $record['pay_terms_status']==1){ ?>
							
							<li class="list-group-item text-center"><a href="<?=base_url();?>salesorders/view/<?=$record['id']?>" target="_blank"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>
                            </li>
                            <li class="list-group-item text-center"><a href="<?=base_url();?>salesorders/view/<?=$record['id']?>/dn" target="_blank"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>
                            </li>
                            <li class="list-group-item text-center" onclick="update_billedby(15)" style="cursor:pointer;" ><a><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>
                            </li>
                            <!--<li class="list-group-item text-center" onClick="shareEmail();"><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>Email invoice</a>-->
                            <!--</li>-->
							<?php if($this->session->userdata('type') == 'admin' || $this->session->userdata('so_approval')==1){ ?>
							<li class="list-group-item text-center" <?php if(count($proArr)!=count($proArrPro) && count($proArr)<count($proArrPro)){ 
							?> data-toggle="tooltip" title="Sales Order Approved" onclick="approve_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','0')" <?php }else{ ?> data-toggle="tooltip" title="You can't disapprove, b'coz po already generated" <?php } ?> ><a href="#" ><div><img src="https://img.icons8.com/color/18/000000/check-all--v1.png"/></div><span class="ptTxt">Click to Disapprove</span></a>
                            </li>
							<?php } }else{  ?>
							
							<li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>
                            </li>
                            <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>
                            </li>
                            <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>
                            </li>
                            <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"  ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"></div>Email invoice</a>
                            </li>
                            <?php if($this->session->userdata('type') == 'admin' || $this->session->userdata('so_approval')==1){ ?>
							<li class="list-group-item text-center" data-toggle="tooltip" title="Sales Order Approval in pending" onclick="approve_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','1')" ><a href="#" ><div><img src="https://img.icons8.com/emoji/18/000000/cross-mark-button-emoji.png"/></div><span class="ptTxt">Click to approve</span></a>
                            </li>
							<?php } }  ?>
							
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main" class="content">
        <div class="container-fluid">
            <div class="accordion" id="faq">
                <div class="card rounded-bottom">
                    <div class="card-header" id="faqhead1"> <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1"><i class="fas fa-file-alt"></i> Quick Sales Order Detail</a>
                    </div>
                    <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <b>Sales Order Id</b>
                                    <p><?=$record['saleorder_id']?></p>
                                </div>
                                <div class="col">
                                    <b>Billed To</b>
                                    <p><?=$record['org_name']?></p>
                                </div>
                                <div class="col">
                                    <b>Total Amount</b>
									
                                    <p>₹ <?=$record['sub_totals']?></p>
                                </div>
                                <div class="col">
                                    <b>Sales Order Date</b>
									<?php 
									//$date=date_create($record['invoice_date']);?>
                                    <p><?=date('d-M-Y',strtotime($record['currentdate']));?></p>
                                </div>
                                <div class="col">
                                    <b>Due Date</b>
                                    <p><?=date('d-M-Y',strtotime($record['due_date'])); ?></p>
                                </div>
                                <div class="col">
								<?php  if(isset($record['pay_terms_status']) && $record['pay_terms_status']==1){ ?>
								 <b>SO Status <i class="far fa-check-circle" style="color: #07c107;"></i></b>
                                    <p>SO approved by <b><?=ucwords($record['approved_by']);?></b></p>
								<?php }else{ ?>
                                    <b>SO Status <i class="far fa-times-circle" style="color: #ff6384;" ></i></b>
                                    <p>SO approval in pending</p>
								<?php } ?>
                                </div>
                            </div>
							<hr>
							<div class="row">
								<div class="col">
                                    <b class="text-info">Sub Total</b>
                                    <p>₹ <?=IND_money_format($record['sub_totals'])?></p>
                                </div>
                                <div class="col">
                                    <b class="text-info">Advanced Payment</b>
                                    <p>₹ <?=IND_money_format($record['advanced_payment'])?></p>
                                </div>
                                <div class="col">
                                    <b class="text-info">Pending Payment</b>
                                    <p>₹ <?=IND_money_format($record['pending_payment'])?></p>
                                </div>
                                <div class="col">
                                    <b class="text-info">Payment Date</b>
									<?php 
									//$date=date_create($record['invoice_date']);?>
                                    <p><?=date('d-M-Y',strtotime($record['currentdate']));?></p>
                                </div>
                                <div class="col">
                                    <b class="text-info">Renewal</b>
                                    <p><?php if($record['is_renewal']==1){ echo "Yes"; }else{ echo "NA"; }  ?></p>
                                </div>
                                <div class="col">
								 <b class="text-info">Rewnewal Date </b>
                                    <p><?php if($record['is_renewal']==1){ ?>
									<?=date('d-M-Y',strtotime($record['renewal_date'])); ?>
										<?php } ?></p>
                                </div>
                            </div>
							
							<hr>
							<div class="row">
								<div class="col">
                                    <b class="text-success">Promo discount</b>
                                    <p>₹ <?=IND_money_format($record['total_orc'])?></p>
                                </div>
								<div class="col">
                                    <b class="text-success">Courier</b>
                                    <p><?=$record['carrier'];?></p>
                                </div>
								<div class="col">
                                    <b class="text-success">Payment Terms</b>
                                    <p><?=$record['payment_terms']?><?php if(is_numeric($record['payment_terms'])==true){ echo " days"; } ?></p>
                                </div>
								<div class="col">
								</div>
								<div class="col">
								</div>
								<div class="col">
								</div>
                            </div>
                        </div>
                    </div>
                </div>
               
               <!-- <div class="card">
                    <div class="card-header" id="faqhead7"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq7" aria-expanded="true" aria-controls="faq7"><i class="fas fa-link"></i>Sales order <span class="paid-btn">Renewal</span></a>
                    </div>
                    <div id="faq7" class="collapse" aria-labelledby="faqhead7" data-parent="#faq">
                        <div class="card-body">
                            <table class="table table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Sales Order#</th>
                                        <th>Sales Order Date</th>
										<th>Renewal</th>
										<?php if($record['is_renewal']==1){ ?>
										<th>Renewal Date</th>
										<?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=$record['saleorder_id']?></td>
                                        <td><?=date('d-M-Y',strtotime($record['currentdate'])); ?></td>
										<td><?php if($record['is_renewal']==1){ echo "Yes"; }else{ echo "NA"; }  ?></td>
										<?php if($record['is_renewal']==1){ ?>
										<td><?=date('d-M-Y',strtotime($record['renewal_date'])); ?></td>
										<?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
				
				
				<div class="card">
                    <div class="card-header" id="faqhead8"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq8" aria-expanded="true" aria-controls="faq8"><img src="https://img.icons8.com/dusk/24/000000/payment-history.png" class="mr-2"/>Payment<span class="paid-btn">Activity</span></a>
                    </div>
                    <div id="faq8" class="collapse" aria-labelledby="faqhead8" data-parent="#faq">
                        <div class="card-body">
                            <table id="ajax_datatable" class="table table-bordered table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Pay Mode</th>
                                        <th>Total Amount</th>
                                        <th>Adv. Payment</th>
                                        <th>Total Pending</th>
                                        <th>Pay Date</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php 
								$update_inv		= 0;
								$retrieve_inv	= 0; 
								if(check_permission_status('Accept Payment','retrieve_u')==true){
									$retrieve_inv=1;
								}
								if(check_permission_status('Accept Payment','update_u')==true){
									$update_inv=1;
								}
								
								if(isset($paymentAd) && count($paymentAd)){
								for($i=0; $i<count($paymentAd); $i++){ ?>
                                    <tr>
                                        <td>
										<?=$paymentAd[$i]['payment_mode'];?>
										<div class="links">
										<?php if($retrieve_inv==1): ?>
										<a style="text-decoration:none" href="#" class="text-success" onclick="viewPayment('<?=$paymentAd[$i]['id'];?>')" >View</a> | 
										<?php endif; 
										if($update_inv==1): ?>
										<a style="text-decoration:none" href="javascript:void(0)" onclick="deletePayment('<?=$paymentAd[$i]['id'];?>')" class="text-danger">Delete</a> <?php endif; ?>
										</div>
										</td>
                                        <td><?=$paymentAd[$i]['total_payment'];?></td>
                                        <td><?=$paymentAd[$i]['adv_payment'];?></td>
                                        <td><?=$paymentAd[$i]['pending_payment'];?></td>
                                        <td><?=$paymentAd[$i]['payment_date'];?></td>
                                    </tr>
								<?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->
				
				
            </div>
        </div>
    </div>
    <div class="linkscontainer">
    <div class="invoice-type">
        <div class="container">
            <h1>Sales Order</h1>
            <hr>
            <div class="row mt-3">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                    <p>Sales Order</p>
                    <p>Sales Order Id#</p>
                    <p>Sales Order Date</p>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-6">
                    <p><b><?=$record['subject']?></b></p>
                    <p><b><?=$record['saleorder_id']?></b></p>
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
                            <th style="width:40%;">Product/Services</th>
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
					$totaliGst=0;
					$totalsGst=0;
					$totalcGst=0;
					$initTot=0;
					if($record['product_name']!=""){
						$product_name=explode("<br>",$record['product_name']);
						if(!empty($record['gst'])){
						$gst=explode("<br>",$record['gst']);
						}
						$salesorder_item_type = explode("<br>", $record['salesorder_item_type']);
						$quantity=explode("<br>",$record['quantity']);
						$unit_price=explode("<br>",$record['unit_price']);
						$hsnsac = explode("<br>",$record['hsn_sac']);
						$total=explode("<br>",$record['total']);
						$descriptionPro=explode("<br>",$record['pro_description']);
						for($rw=0; $rw<count($product_name); $rw++){
							$num = $rw + 1;
						?>
                        <tr>
						    <td><?=$num;?></td>
                            <td style="cursor:pointer;" data-toggle="collapse" href="#proDesc<?=$rw;?>" ><?=$product_name[$rw];?></td>
                            <td></td>
                            <td><?=$hsnsac[$rw];?></td>
							<?php if(!empty($gst)){ ?>
							<td><?='GST@'.$gst[$rw].'%';?></td>
							<?php }else{ ?>
							<td><?='GST@18%';?></td>
							<?php } ?>
                            <td><?=$quantity[$rw];?></td>
                            <td>₹<?=IND_money_format($unit_price[$rw]);?></td>
							<?php if(count($discount)>0){ ?>
							<td>₹<?php if(isset($discount[$rw])){ echo IND_money_format($discount[$rw]); }else{ echo "0"; } ?></td>
							<?php } $initTot = $initTot+$total[$rw];?>
							<td>₹<?=IND_money_format($total[$rw]);?></td>
                        </tr>
						<tr class="collapse" id="proDesc<?=$rw;?>" >
						    <td colspan="7" style="border-top: 0px solid !important; font-size: 14px;"><?php if(isset($descriptionPro[$rw]) && $descriptionPro[$rw]!=""){echo $descriptionPro[$rw]; }else{ echo "NA"; } ?></td>
						</tr>
					<?php   } } ?>
                    </tbody>
                </table>
            </div>
            <div class="bank-total">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-6">
                        <div class="bank-total-left">
                            <p>Total In Words: <b>
							<?php 
								if($record['sub_totals']){	
									$get_amount= AmountInWords($record['sub_totals']);
							echo $get_amount;
								}
							?></b></p>
                        </div>
                        
                        <?php if(!empty($record['customer_company_name'])) { ?>
        		
                        <table width="100%" border="0" style="max-width:800px; border-radius:5px; background:rgba(35, 0, 140, 0.8); color: #fffcf9; font-size:14px;padding:20px;display:block;">
                               <tr>
                                <td colspan="3">
                                  
                                    <h5 style="margin-top: 0px;margin-bottom: 10px; font-size:16px;font-weight:600;">Customer Details (If Required)</h5>
                                </td>
                               </tr>
                               
                                <?php if($record['customer_company_name']!=""){ ?>
                                <tr>
                                   <th style="text-align:left; padding-left:10px;width: 35%;">  Name:  <th>
                                   <td><?php echo ucfirst($record['customer_company_name']); ?></td>
                               </tr>
                               <?php } 
                               if($record['customer_address']!=""){ ?>
                                <tr>
                                   <th style="text-align:left; padding-left:10px;">  Address:  <th>
                                   <td><?php echo ucfirst($record['customer_address']); ?></td>
                               </tr>
                            <?php }
                               if($record['customer_name']!=""){ ?>
                                <tr>
                                   <th style="text-align:left; padding-left:10px;">  Contact Person:  <th>
                                   <td><?php echo ucfirst($record['customer_name']); ?></td>
                               </tr>
                               <?php }
                               if($record['customer_email']!=""){ ?>
                                <tr>
                                   <th style="text-align:left; padding-left:10px;">  E-mail:  <th>
                                   <td><?php echo $record['customer_email']; ?></td>
                               </tr>
                               <?php }
                                if($record['customer_mobile']!="" && $record['customer_mobile']!="0"){ ?>
                                <tr>
                                   <th style="text-align:left; padding-left:10px;"> Contact No: <th>
                                   <td><?php echo $record['customer_mobile']; ?></td>
                               </tr>
                                <?php }
                                if($record['microsoft_lan_no']!=""){ ?>
                                <tr>
                                   <th style="text-align:left;  padding-left:10px;">Licence No. :<th> 
                                   <td><?php echo $record['microsoft_lan_no']; ?></td>
                               </tr>
                                <?php } ?>
                                 
                                </table> 
                    
                  <?php }  ?>
                        
                        
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
							<?php } 
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
								<?php } 
							}else{ ?>
								<?php if($record['total_cgst']>0){ ?>
								<div class="row">
									<div class="col">CGST</div>
									<div class="col text-right">
											₹ <?=IND_money_format($record['total_cgst']); ?>
									</div>
								</div>
								<?php }
							 ?>
							<?php if($record['total_sgst']>0){?>
							<div class="row">
								<div class="col">SGST</div>
								<div class="col text-right">
										₹ <?=IND_money_format($record['total_sgst']); ?>
								</div>
							</div>
							<?php } 
							
							} ?>
                          
							
							<?php if(isset($record['extra_charge_label'])){
								$labelExra=explode("<br>",$record['extra_charge_label']);
								$valueExra=explode("<br>",$record['extra_charge_value']);
								for($i=0; $i<count($labelExra); $i++){
									if($valueExra[$i]>0){
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
                                    ₹ <?=IND_money_format($record['sub_totals']);?>
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
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                    <div class="right-buttons">
						<ul class="list-group list-group-horizontal">
						 <!--   <li class="list-group-item text-center">-->
						 <!--       <a href="<?=base_url('salesorders');?>">-->
    			<!--			    <div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"/>-->
    			<!--			    </div>Back</a>-->
       <!--                     </li>-->
    
							<!--<li class="list-group-item text-center"><a href="<?=base_url();?>add-salesorder/<?=$record['id'];?>"><div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"/></div>Edit</a>-->
       <!--                     </li>-->
                            
							<?php if($this->session->userdata('create_po')=='1'){ ?>
    							<?php if(count($proArr)!=count($proArrPro) && count($proArr)<count($proArrPro)){ ?>
        							<!--<li class="list-group-item text-center">-->
        							<!--    <?php  if(isset($record['pay_terms_status']) && $record['pay_terms_status']==1){ ?>-->
            			<!--				<a href="<?=base_url();?>add-purchase-order?so=<?=$record['id'];?>" >-->
            			<!--				<?php }else{  ?>-->
            			<!--				<a href="#" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending" >-->
            			<!--				<?php } ?>-->
            			<!--				    <div>-->
            			<!--				    <img src="https://img.icons8.com/fluent/18/000000/purchase-order.png"/>-->
            			<!--				    </div>Create Purchase Order</a>-->
               <!--                     </li>-->
							    <?php }else{ ?>
        							<!--<li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Sales order already created">-->
        							<!--    <a href="#" style="cursor: not-allowed;" >-->
        							<!--        <div>-->
        							<!--            <img src="https://img.icons8.com/fluent/18/000000/purchase-order.png"/>-->
        							<!--        </div>Create Purchase Order</a>-->
               <!--                     </li>-->
							    <?php } 
							} ?>
							
							<!--<?php  if($this->session->userdata('create_pi')=='1' && $PiCount<1){ ?>-->
    			<!--				<li class="list-group-item text-center">-->
    			<!--				    <a href="<?=base_url();?>proforma_invoice/create_newProforma?pg=salesorder&qt=<?=$record['saleorder_id'];?>">-->
    			<!--				        <div>-->
    			<!--				            <img src="https://img.icons8.com/nolan/18/invoice-1.png"/>-->
    			<!--				         </div>Create PI</a>-->
       <!--                         </li>-->
							<!--<?php } ?> -->
						</ul>
					</div>
				</div>
               
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12">
                    <div class="right-buttons d-flex justify-content-end">
					
					<ul class="list-group list-group-horizontal">
					
							<?php  if(isset($record['pay_terms_status']) && $record['pay_terms_status']==1){ ?>
							
    							<!--<li class="list-group-item text-center"><a href="<?=base_url();?>salesorders/view/<?=$record['id']?>" target="_blank"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>-->
           <!--                     </li>-->
           <!--                     <li class="list-group-item text-center"><a href="<?=base_url();?>salesorders/view/<?=$record['id']?>/dn" target="_blank"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>-->
           <!--                     </li>-->
           <!--                     <li class="list-group-item text-center" onclick="update_billedby(15)" style="cursor:pointer;" ><a><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>-->
           <!--                     </li>-->
           <!--                     <li class="list-group-item text-center" onClick="shareEmail();"><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>Email invoice</a>-->
           <!--                     </li>-->
                                
								<?php if($this->session->userdata('type') == 'admin' || $this->session->userdata('so_approval')==1){ ?>
								<!--disapprove button if needs then copy abave proper-->
								<!--<span class="ptTxt">Click to Disapprove</span>-->
							
							<?php } 
							}else{  ?>
							
							<!--<li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>-->
       <!--                     </li>-->
       <!--                     <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>-->
       <!--                     </li>-->
       <!--                     <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>-->
       <!--                     </li>-->
       <!--                     <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"  ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"></div>Email invoice</a>-->
       <!--                     </li>-->
                          <?php if($this->session->userdata('type') == 'admin' || $this->session->userdata('so_approval')==1){ ?>
							<!--<li class="list-group-item text-center" data-toggle="tooltip" title="Sales Order Approval in pending" onclick="approve_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','1')" ><a href="#" ><div><img src="https://img.icons8.com/emoji/18/000000/cross-mark-button-emoji.png"/></div><span class="ptTxt">Click to approve</span></a>-->
       <!--                     </li>-->
							<?php } } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="milestones" id="my2" style = "top:1.5rem;"></div>
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
			   <?php $actual_link = base_url()."salesorders/view/".$record['id']; ?>
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
			  <input type="text" class="form-control" value="<?=$record['email'];?>" name="orgEmail" id="orgEmail">
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
			  <input type="text" class="form-control" value="Salesorder For <?=$record['org_name'];?> - #<?=$record['saleorder_id'];?>" name="subEmail" id="subEmail">
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
				<p>Please find attached sales order #<?=$record['saleorder_id'];?>.</p>
				<p>Sales Order Id: #<?=$record['saleorder_id'];?></p>
				<p>Billed To: <?=$record['org_name'];?></p>
				<p>Total Amount: ₹ <?=IND_money_format($record['sub_totals']);?></p>
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

<?php  
$stage=1.5;
$checks=1;
if(isset($record['pay_terms_status']) && $record['pay_terms_status']==1){ 
	$stage=2.5;
	$checks=2;
}
if(count($proArr)!=count($proArrPro) && count($proArr)>0){ 
	$stage=2.8;
	$checks=2;
}

if(count($proArr)==count($proArrPro) || count($proArr)>count($proArrPro)){ 
	$stage=3;
	$checks=3;
}

?>
<?php if(isset($_GET['ntid'])){
	//$soid=$_GET['soid'];
	$ntid=$_GET['ntid'];
}else{
	//$soid='';
	$ntid='';
}	?>

 <?php $this->load->view('footer');?>
<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<!-- common footer include -->
<script>
var editor = CKEDITOR.replace( 'descriptionTxt' );
CKEDITOR.config.height='150px';
</script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
function share() { 
        var message =  "<?php echo base_url();?>salesorders/view/<?=$record['id']?>"; 
        window.open("https://web.whatsapp.com/send?text=" + message, '_blank'); 
}  


function changeNotiStatus(){
	var noti_id="<?=$ntid;?>";
	url = "<?= site_url('notification/update_notification');?>";
    	$.ajax({
    		url : url,
    		type: "POST",
    		data: "noti_id="+noti_id+"&notifor=salesorders",
    		success: function(data)
    		{ console.log(data); }
    	});
    }
   
 var ntid = "<?=$ntid;?>"; 
 if(ntid!=""){ 	changeNotiStatus(); }

function update_billedby(id){ 
	$('#branch_details').modal('show'); 
}

function shareEmail(){ 
    $('#branch_details').modal('hide'); 
	$('#emailModel').modal('show'); 
}

function approve_entry(soid,soidapp,stts) {
	$(".ptTxt").html('Please wait...<div class="spinner-grow spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>');
    var urlst = "<?=base_url();?>salesorders/changeStatus";
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
			 location.reload();
        }
    });
};
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
	var invoiceurl="<?php echo base_url();?>/salesorders/view/<?=$record['id']?>";
	var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
	var so_id ="<?=$record['id'];?>";
	$("#sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
	
	$.ajax({
     url: "<?= site_url(); ?>/salesorders/send_email",
     method: "POST",
     data: {orgName:orgName,orgEmail:orgEmail,ccEmail:ccEmail,subEmail:subEmail,descriptionTxt:descriptionTxt,invoiceurl:invoiceurl,so_id,so_id},
     success: function(dataSucc){
      if(dataSucc==1){
		    $("#formDiv, #footerDiv").hide();
			$("#messageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your sales order shared successfully.');
			$("#messageDiv").css('display','block');
			$("#sendEmail").html('Send Email');
			setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); $('#emailModel').modal('hide'); },4000)
	  }else{
		  $("#formDiv, #footerDiv").hide();
		  $("#messageDiv").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Your sales order shared failed.');
		  $("#messageDiv").css('display','block');
		  $("#sendEmail").html('Send Email');
		  setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); },4000)
	  }
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
    labels: ["SO Details","SO Status","PO Created"]
  });
  
  
 
  
</script>