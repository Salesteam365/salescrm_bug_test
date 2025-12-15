<!-- common header include -->
<?php $this->load->view('common_navbar');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
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
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item text-center"><a href="<?=base_url('purchaseorders');?>"><div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"/></div>Back</a>
                            </li>
							<li class="list-group-item text-center"><a href="<?=base_url();?>add-purchase-order/<?=$record['id'];?>"><div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"/></div>Edit</a>
                            </li>
                           
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons d-flex justify-content-end">
                        <ul class="list-group list-group-horizontal">
						<?php 
						if($record['approve_status']=='1'){ ?>
							<li class="list-group-item text-center"><a href="<?=base_url();?>purchaseorders/view/<?=$record['id']?>" target="_blank"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>
                            </li>
                            <li class="list-group-item text-center"><a href="<?=base_url();?>purchaseorders/view/<?=$record['id']?>/dn" target="_blank"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>
                            </li>
                            <li class="list-group-item text-center" onclick="update_billedby(15)" style="cursor:pointer;" ><a><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>
                            </li>
                            <!--<li class="list-group-item text-center" onClick="shareEmail();"><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>Email invoice</a>-->
                            <!--</li>-->
							
							<?php if(check_permission_status('Purchase Order can approve','other')==true){ ?>
							
							<li class="list-group-item text-center" data-toggle="tooltip" title="Purchase Order Approved" onclick="approve_po_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','0')" ><a href="#" ><div><img src="https://img.icons8.com/color/18/000000/check-all--v1.png"/></div><span class="ptTxt">Click to Disapprove</span></a>
                            </li>
						<?php } }else{ ?>
							<li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>
                            </li>
                            <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>
                            </li>
                            <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>
                            </li>
                            <!--<li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"  ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"></div>Email invoice</a>-->
                            </li>
                            <?php if(check_permission_status('Purchase Order can approve','other')==true){ ?>
							<li class="list-group-item text-center" data-toggle="tooltip" title="Purchase Order Approval in pending" onclick="approve_po_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','1')" ><a href="#" ><div><img src="https://img.icons8.com/emoji/18/000000/cross-mark-button-emoji.png"/></div><span class="ptTxt">Click to approve</span></a>
                            </li>
						
						<?php } } ?>
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
                    <div class="card-header" id="faqhead1"> <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1" style="background:rgba(230,242,255,0.4);color:black;"><i class="fas fa-file-alt"></i> Quick Purchase Order Detail</a>
                    </div>
                    <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <b>Purchase order id</b>
                                    <p><?=$record['purchaseorder_id']?></p>
                                </div>
                                <div class="col">
                                    <b>Supplier name</b>
                                    <p><?=$record['supplier_comp_name']?></p>
                                </div>
                                <div class="col">
                                    <b>Total Amount</b>
									
                                    <p>₹ <?=$record['sub_total']?></p>
                                </div>
                                <div class="col">
                                    <b>Purchase order Date</b>
									<?php 
									//$date=date_create($record['invoice_date']);?>
                                    <p><?=date('d-M-Y',strtotime($record['currentdate']));?></p>
                                </div>
                               
                                <div class="col">
								<?php  if(isset($record['approve_status']) && $record['approve_status']==1){ ?>
								 <b>PO Status <i class="far fa-check-circle" style="color: #07c107;"></i></b>
                                    <p>PO approved by <b><?=ucwords($record['approved_by']);?></b></p>
								<?php }else{ ?>
                                    <b>PO Status <i class="far fa-times-circle" style="color: #ff6384;" ></i></b>
                                    <p>PO approval in pending</p>
								<?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="faqhead7"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq7" aria-expanded="true" aria-controls="faq7" style="background:rgba(230,242,255,0.4);color:black;"><i class="fas fa-link"></i> Linked Purchase Order <span class="paid-btn">Created</span></a>
                    </div>
                    <div id="faq7" class="collapse" aria-labelledby="faqhead7" data-parent="#faq">
                        <div class="card-body">
                            <table class="table table-responsive-lg">
                                <thead style="background:#fff;color:#000; ">
								    <tr>
                                        <th><b>Purchase order #</b></th>
                                        <th><b>Purchase order Date</b></th>
										<th><b>Renewal</b></th>
										<?php if($record['is_renewal']==1){ ?>
										<th><b>Renewal Date</b></th>
										<?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
									 <tr>
                                        <td><?=$record['purchaseorder_id']?></td>
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
            </div>
        </div>
    </div>
	<div class="linkscontainer">
    <div class="invoice-type">
        <div class="container">
            <h1>Purchase Order</h1>
            <hr>
            <div class="row mt-3">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                    <p>Purchase Order</p>
                    <p>Purchase Order Id#</p>
                    <p>Purchase Order Date</p>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-6">
                    <p><b><?=$record['subject']?></b></p>
                    <p><b><?=$record['purchaseorder_id']?></b></p>
                    <p><b><?=date('d-M-Y');?></b></p>
                </div>
            </div>
            <div class="invoice-address-info mt-3">
                <div class="row">
                    <div class="col">
                        <div class="billed-by" style="background:rgba(35, 0, 140, 0.8)">
                            <h3>SUPPLIER NAME</h3>
                            <b><?=$record['supplier_name'];?></b><br>
                            <b><?=$record['supplier_comp_name'];?></b><br>
							<b><?=$record['supplier_address'];?></b><br>
                            <p><?=$record['supplier_city'];?>,<?=$record['supplier_state'];?>-<?=$record['supplier_zipcode'];?>, <?=$record['supplier_country'];?></p><br>
							<b><?=$record['supplier_gstin'];?></b><br>
                        </div>
                    </div>
                    <div class="col">
                        <div class="billed-to billed-by" style="background:rgba(35, 0, 140, 0.8)">
                            <h3>SHIP TO</h3>
                            <b><?=$record['owner'];?></b><br>
                            <b><?=$this->session->userdata('company_name');?></b><br>
							<b><?=$record['shipping_address'];?></b><br>
                            <p><?=$record['shipping_city'];?>,<?=$record['shipping_state'];?>-<?=$record['shipping_zipcode'];?>, <?=$record['shipping_country'];?></p>                           
                            <p><b>Phone:</b> +91-<?=$this->session->userdata('mobile');?></p>
							<p><b>Gstin:</b> <?=$record['shipping_gstin'];?></p>
							<p><b>Cin:</b> <?=$this->session->userdata('cin');?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="invoice-table mt-3 text-left">
                <div class="row">
                    <div class="col">
                        <p><b>Country of Supply :</b> <?=$record['shipping_country'];?></p>
                    </div>
                    <div class="col">
                        <p><b>Place of Supply :</b> <?=$record['shipping_city'];?> (<?=$record['shipping_zipcode'];?>)</p>
                    </div>
                </div>
				<?php $discount		= explode("<br>",$record['pro_discount']); ?>
                <table class="table table-responsive-lg">
                    <thead style="background:rgba(35, 0, 140, 0.8)">
                        <tr>
						    <th>S.No</th>
                            <th style="width:40%;">Product/Services</th>
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
				//	echo "<pre>";
				//	print_r($record);
					$totaliGst=0;
					$totalsGst=0;
					$totalcGst=0;
					if($record['product_name']!=""){
						$product_name=explode("<br>",$record['product_name']);
						if(!empty($record['gst'])){
						$gst=explode("<br>",$record['gst']);
						}
						$quantity=explode("<br>",$record['quantity']);
						$unit_price=explode("<br>",$record['estimate_purchase_price_po']);
						$hsnsac = explode("<br>",$record['hsn_sac']);
						$total=explode("<br>",$record['initial_estimate_purchase_price_po']);
						$descriptionPro=explode("<br>",$record['pro_description']);
						
						for($rw=0; $rw<count($product_name); $rw++){
							$num = $rw + 1;
						?>
                        <tr>
						    <td><?=$num;?></td>
                            <td style="cursor:pointer;" data-toggle="collapse" href="#proDesc<?=$rw;?>" ><?=$product_name[$rw];?></td>
                            <td><?=$hsnsac[$rw];?></td>
							<?php if(!empty($gst)){ ?>
							<td><?='GST@'.$gst[$rw].'%';?></td>
							<?php }else{ ?>
							<td><?='GST@18%';?></td>
							<?php } ?>
                            <td><?=$quantity[$rw];?></td>
                            <td>₹ <?=IND_money_format($unit_price[$rw]);?></td>
							<?php if(count($discount)>0){ ?>
							<td>₹ <?php if(isset($discount[$rw])){ echo IND_money_format($discount[$rw]); }else{ echo "0"; } ?></td>
							<?php } ?>
							<td>₹ <?=IND_money_format($total[$rw]);?></td>
                            
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
							<?php  $get_amount= AmountInWords($record['sub_total']);
							echo $get_amount;
							?></b></p>
                        </div>
                        
                    <?php if(!empty($record['customer_company_name'])) { ?>
        		
                        <table width="100%" border="0" style="max-width:800px; border-radius:5px; background:rgba(35, 0, 140, 0.8);color: #fffcf9; font-size:14px;padding:20px;display:block;">
                               <tr>
                                <td colspan="3">
                                  
                                    <h5 style="margin-top: 0px;margin-bottom: 10px; font-size:16px;font-weight:600;">Customer Details (If Required)</h5>
                                </td>
                               </tr>
                               
                                <?php if($record['customer_company_name']!=""){ ?>
                                <tr>
                                   <th style="text-align:left; padding-left:10px;width: 20%;">  Name:  <th>
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
                                    Sub Total
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($record['initial_total']);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Discount
                                </div>
                                <div class="col text-right">
                                    (₹ <?=IND_money_format($record['discount']);?>)
                                </div>
                            </div>
                            <?php if($record['total_igst']>0){?>
							<div class="row">
								<div class="col">IGST</div>
								<div class="col text-right">
										₹ <?=IND_money_format($record['total_igst']); ?>
								</div>
							</div>
							<?php } ?>
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
							<?php } ?>
							<?php $type = $record['type'];
							if($type == "Interstate")
							{
							  if($record['igst12'] != '0' && $record['igst18'] != '0' && $record['igst28'] != '0')
							  { ?>
						        <div class="row">
									<div class="col">
										IGST@12%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst12']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										IGST@18%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst18']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										IGST@28%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst28']); ?>
									</div>
								</div>
								<?php }elseif($record['igst12'] != '0' && $record['igst18'] == '0' && $record['igst28'] == '0') { ?>
								<div class="row">
									<div class="col">
										IGST@12%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst12']); ?>
									</div>
								</div>
								<?php }elseif($record['igst12'] == '0' && $record['igst18'] != '0' && $record['igst28'] == '0') { ?>
								<div class="row">
									<div class="col">
										IGST@18%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst18']); ?>
									</div>
								</div>
								<?php }elseif($record['igst12'] == '0' && $record['igst18'] == '0' && $record['igst28'] != '0') { ?>
								<div class="row">
									<div class="col">
										IGST@28%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst28']); ?>
									</div>
								</div>
								<?php }elseif($record['igst12'] != '0' && $record['igst18'] != '0' && $record['igst28'] == '0') { ?>
								<div class="row">
									<div class="col">
										IGST@12%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst12']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										IGST@18%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst18']); ?>
									</div>
								</div>
								<?php }elseif($record['igst12'] == '0' && $record['igst18'] != '0' && $record['igst28'] != '0') { ?>
								<div class="row">
									<div class="col">
										IGST@18%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst18']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										IGST@28%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst28']); ?>
									</div>
								</div>
								<?php }elseif($record['igst12'] != '0' && $record['igst18'] == '0' && $record['igst28'] != '0') { ?>
								<div class="row">
									<div class="col">
										IGST@12%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst12']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										IGST@28%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst28']); ?>
									</div>
								</div>
								<?php  } }else if($type == "Instate") {
							      if($record['cgst6'] != '0' && $record['cgst9'] != '0' && $record['cgst14'] != '0')
							       { ?>
							    <div class="row">
									<div class="col">
										CGST@6%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst6']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@6%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst6']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										CGST@9%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst9']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@9%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst9']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										CGST@14%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst14']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@14%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst14']); ?>
									</div>
								</div>
								   <?php }elseif($record['cgst6'] != '0' && $record['cgst9'] == '0' && $record['cgst14'] == '0') { ?>
								   
							    <div class="row">
									<div class="col">
										CGST@6%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst6']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@6%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst6']); ?>
									</div>
								</div>
								 <?php }elseif($record['cgst6'] == '0' && $record['cgst9'] != '0' && $record['cgst14'] == '0') { ?>
							    <div class="row">
									<div class="col">
										CGST@9%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst9']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@9%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst9']); ?>
									</div>
								</div>
								 <?php }elseif($record['cgst6'] == '0' && $record['cgst9'] == '0' && $record['cgst14'] != '0') { ?>
							    <div class="row">
									<div class="col">
										CGST@14%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst14']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@14%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst14']); ?>
									</div>
								</div>
								<?php }elseif($record['cgst6'] != '0' && $record['cgst9'] != '0' && $record['cgst14'] == '0') { ?>
							    <div class="row">
									<div class="col">
										CGST@6%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst6']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@6%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst6']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										CGST@9%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst9']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@9%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst9']); ?>
									</div>
								</div>
								<?php }elseif($record['cgst6'] == '0' && $record['cgst9'] != '0' && $record['cgst14'] != '0') { ?>
							    <div class="row">
									<div class="col">
										CGST@9%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst9']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@9%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst9']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										CGST@14%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst14']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@14%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst14']); ?>
									</div>
								</div>
								<?php }elseif($record['cgst6'] != '0' && $record['cgst9'] == '0' && $record['cgst14'] != '0') { ?>
							    <div class="row">
									<div class="col">
										CGST@6%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst6']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@6%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst6']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										CGST@14%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['cgst14']); ?>
									</div>
								</div>
								<div class="row">
									<div class="col">
										SGST@14%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['sgst14']); ?>
									</div>
								</div>
								<?php   } }else{ /* ?> 
								<div class="row">
									<div class="col">
										IGST@18%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst18']); ?>
									</div>
								</div>
								<?php */  }  ?> 
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
                                    ₹ <?=IND_money_format($record['sub_total']);?>
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
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="right-buttons d-flex justify-content-end">
                        <ul class="list-group list-group-horizontal">
						<?php 
						if($record['approve_status']=='1'){ ?>
							<!--<li class="list-group-item text-center"><a href="<?=base_url();?>purchaseorders/view/<?=$record['id']?>" target="_blank"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>-->
       <!--                     </li>-->
       <!--                     <li class="list-group-item text-center"><a href="<?=base_url();?>purchaseorders/view/<?=$record['id']?>/dn" target="_blank"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>-->
       <!--                     </li>-->
       <!--                     <li class="list-group-item text-center" onclick="update_billedby(15)" style="cursor:pointer;" ><a><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>-->
       <!--                     </li>-->
       <!--                     <li class="list-group-item text-center" onClick="shareEmail();"><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>Email invoice</a>-->
       <!--                     </li>-->
                            
							<?php if(check_permission_status('Purchase Order can approve','other')==true){ ?>
							
							<!--<li class="list-group-item text-center" data-toggle="tooltip" title="Purchase Order Approved" onclick="approve_po_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','0')" ><a href="#" ><div><img src="https://img.icons8.com/color/18/000000/check-all--v1.png"/></div><span class="ptTxt">Click to Disapprove</span></a>-->
       <!--                     </li>-->
                            <?php } ?>
                            
						<?php }else{ ?>
							<!--<li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>-->
       <!--                     </li>-->
       <!--                     <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>-->
       <!--                     </li>-->
       <!--                     <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>-->
       <!--                     </li>-->
       <!--                     <li class="list-group-item text-center" style="cursor: not-allowed;" data-toggle="tooltip" title="Approval in pending"><a href="#" style="cursor: not-allowed;"  ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"></div>Email invoice</a>-->
       <!--                     </li>-->
                            
                            <?php if(check_permission_status('Purchase Order can approve','other')==true){ ?>
                            
							<!--<li class="list-group-item text-center" data-toggle="tooltip" title="Purchase Order Approval in pending" onclick="approve_po_entry('<?=$record['id']?>','<?=$record['saleorder_id']?>','1')" ><a href="#" ><div><img src="https://img.icons8.com/emoji/18/000000/cross-mark-button-emoji.png"/></div><span class="ptTxt">Click to approve</span></a>-->
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
			  <?php $actual_link = base_url()."purchaseorders/view/".$record['id']; ?>
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
			  <input type="text" class="form-control" value="<?=$record['supplier_comp_name'];?>" name="orgName" id="orgName">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Client's Email:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$record['supplier_email'];?>" name="orgEmail" id="orgEmail">
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
			  <input type="text" class="form-control" value="Purchaseorder For <?=$record['supplier_comp_name'];?> - #<?=$record['purchaseorder_id'];?>" name="subEmail" id="subEmail">
            </div>
			<div class="col-md-12 lbl">
				<label for="">Message*:</label>
			</div>
			<div class="col-md-12" style="font-size: 11px; margin: 3px 0px;">
				Invoice PDF attachment and Online Link will be added to the email automatically.
			</div>
			
			<div class="col-md-12">
			  <textarea class="form-control" id="descriptionTxt"   name="descriptionTxt">
				<p>Hi <?=$record['supplier_comp_name'];?>,</p>
				<p>Please find attached Purchase Order #<?=$record['purchaseorder_id'];?>.</p>
				<p>Purchase Order Id: #<?=$record['purchaseorder_id'];?></p>
				<p>Billed To: <?=$record['supplier_comp_name'];?></p>
				<p>Total Amount: ₹ <?=IND_money_format($record['sub_total']);?></p>
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
if(isset($record['approve_status']) && $record['approve_status']==1){ 
	$stage=3;
	$checks=3;
}
// if(count($proArr)!=count($proArrPro) && count($proArr)>0){ 
	// $stage=2.8;
	// $checks=2;
// }

// if(count($proArr)==count($proArrPro) || count($proArr)>count($proArrPro)){ 
	// $stage=3;
	// $checks=3;
// }
 if(isset($_GET['ntid'])){
	//$soid=$_GET['soid'];
	$ntid=$_GET['ntid'];
}else{
	//$soid='';
	$ntid='';
}	?>

<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>

<script>
var editor = CKEDITOR.replace( 'descriptionTxt' );
CKEDITOR.config.height='150px';
</script>
<script>
function share() { 
        var message =  "<?php echo base_url();?>purchaseorders/view/<?=$record['id']?>"; 
        window.open("https://web.whatsapp.com/send?text=" + message, '_blank'); 
}  

function changeNotiStatus(){
	var noti_id="<?=$ntid;?>";
	url = "<?= site_url('notification/update_notification');?>";
    	$.ajax({
    		url : url,
    		type: "POST",
    		data: "noti_id="+noti_id+"&notifor=purchaseorders",
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

function approve_po_entry(poid,poidapp,stts) {
	$(".ptTxt").html('Please wait...<div class="spinner-grow spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div>');
    var urlst = "<?=base_url();?>purchaseorders/changeStatus";
    $.ajax({
        url : urlst,
        type: "POST",
        data: "poid="+poid+'&povalue='+stts,
        success: function(data)
        { 
            if(data==1){
				toastr.success('Purchase order ID #'+soidapp+" has been approved successfully.");
            }else if(data==0){
                toastr.error('Purchase order ID #'+soidapp+" disapproved successfully.");
            }else{
                toastr.success('Purchase Order ID #'+soidapp+" has been Approved Successfully.");
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
	var invoiceurl="<?php echo base_url();?>/purchaseorders/view/<?=$record['id']?>";
	var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
	var po_id ="<?=$record['id'];?>";
	$("#sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
	
	$.ajax({
     url: "<?= site_url(); ?>/purchaseorders/send_email",
     method: "POST",
     data: {orgName:orgName,orgEmail:orgEmail,ccEmail:ccEmail,subEmail:subEmail,descriptionTxt:descriptionTxt,invoiceurl:invoiceurl,po_id,po_id},
     success: function(dataSucc){
         
      if(dataSucc==1){
		    $("#formDiv, #footerDiv").hide();
			$("#messageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your Purchaseorders shared successfully.');
			$("#messageDiv").css('display','block');
			$("#sendEmail").html('Send Email');
			setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); $('#emailModel').modal('hide'); },4000)
	  }else{
		  $("#formDiv, #footerDiv").hide();
		  $("#messageDiv").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Your Purchaseorders shared failed.');
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
    labels: ["PO Details","PO Status","Download or Email Invoice"]
  });
</script>