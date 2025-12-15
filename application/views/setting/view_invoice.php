<!-- common header include -->
<?php $this->load->view('common_navbar');?>
<!-- common header include -->
<style>
    .content-header {background: #f2f2f2;}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
                            <?php if($this->session->userdata('update_pi')=='1'): ?>
                            <li class="list-group-item"><a href="<?=base_url();?>invoices/edit-invoice/<?=$record['id']?>"><i class="fas fa-pencil-alt"></i>Edit Invoice</a>
                            </li>
                            <?php endif; ?>
                             <li class="list-group-item"><a href="<?=base_url('invoices');?>"><i class="fas fa-arrow-circle-left"></i></i>Back</a>
                            </li>
                            <!--<li class="list-group-item"><a href="#"><i class="fas fa-money-bill-wave"></i>Add Payment Details</a>
                            </li>
                            <li class="list-group-item"><a href="#"><i class="fas fa-envelope"></i>Send Reciept</a>
                            </li>-->
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons">
                        <ul class="list-group list-group-horizontal">
						    
                            <li class="list-group-item"><a href="<?=base_url();?>invoices/generate-pdf?inv_id=<?=$_GET['inv_id'];?>&cnp=<?=$_GET['cnp'];?>&ceml=<?=$_GET['ceml'];?>" target="_blank"><i class="fas fa-print"></i>Print</a>
                            </li>
                            <li class="list-group-item"><a href="<?=base_url();?>invoices/generate-pdf?inv_id=<?=$_GET['inv_id'];?>&cnp=<?=$_GET['cnp'];?>&ceml=<?=$_GET['ceml'];?>&dn=1" target="_blank"><i class="fas fa-download"></i>Download</a>
                            </li>
                            <li class="list-group-item" onclick="update_billedby(15)" style="cursor:pointer;" ><a   ><i class="fas fa-share-alt"></i>Share</a>
                            </li>
                            <li class="list-group-item" onClick="shareEmail();"><a href="#" ><i class="fas fa-file-alt"></i>Email invoice</a>
                            </li>
                            <!--<li class="list-group-item"><a href="#"><i class="fas fa-angle-down"></i>More</a>
                            </li>--->
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
                    <div class="card-header" id="faqhead1"> <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1"><i class="fas fa-file-alt"></i> Quick Invoices Detail</a>
                    </div>
                    <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <b>Invoice</b>
                                    <p><?=$record['invoice_no']?></p>
                                </div>
                                <div class="col">
                                    <b>Customer Name</b>
                                    <p><?=$clientDtl->org_name?></p>
                                </div>
                                <div class="col">
                                    <b>Total Amount</b>
									
                                    <p>₹ <?=$record['final_total']?></p>
                                </div>
                                <div class="col">
                                    <b>Invoice Date</b>
									<?php 
									$date=date_create($record['invoice_date']);?>
                                    <p><?=date_format($date,"d M Y");?></p>
                                </div>
                                <div class="col">
                                    <b>Due Date</b>
                                    <p><?php 
									if($record['due_date']!=""){
										$date=date_create($record['due_date']);
										echo date_format($date,"d F Y");
									}else{ echo "Not Set"; } ?></p>
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
                    <div class="card-header" id="faqhead2"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq2" aria-expanded="true" aria-controls="faq2"><i class="fas fa-university"></i> Bank And UPI Detail</a>
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
                                                      <span class="slider round"  style="background-color:#f1f1f1;" ></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bank-name">
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10">
                                                    <div class="bank-details-inner">
                                                        <a href="javascript:void(0)" onClick="addBankupi();" class="float-right"><i class="fas fa-check"></i> Selected</a>
                                                        <h4><?=$bank_details_terms->bank_name;?></h4>
                                                        <span><?=$bank_details_terms->acc_holder_name;?></span> <br>
                                                        <span>Acc. No: <?=$bank_details_terms->account_no;?></span><br>
														<span>IFSC: <?=$bank_details_terms->ifsc_code;?></span>
                                                    </div>
                                                    <a href="javascript:void(0)" onClick="addBankupi();"><i class="fas fa-cog"></i> Edit Bank Details</a>
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
							     <!--<li class="list-group-item" onClick="addBankupi();"><a href="#"><i class="fas fa-cog"></i> Edit Bank details</a></li>-->
							<?php } else{ ?>
                                 <li class="list-group-item" onClick="addBankupi();"><a href="javascript:void(0)"><i class="fas fa-cog"></i> Add Bank</a></li>
								 <p>Bank Account details are required to show them on Invoice and to enable payment options.</p>
							<?php } ?>	 
                                <!--<li class="list-group-item"><a href="#"><i class="fas fa-cog"></i> Add UPI</a></li>-->
                            </ul>
                            
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="faqhead3"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq3" aria-expanded="true" aria-controls="faq3"><i class="fab fa-cc-visa"></i> Online Payment Options</a>
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
                <!-- <div class="card">
                    <div class="card-header" id="faqhead4"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq4" aria-expanded="true" aria-controls="faq4"><i class="fas fa-envelope"></i> Emails to Client &nbsp<span>(<i class="fas fa-check-double"></i> Email delivered on Feb 11, 2021 | 02:48 PM)</span></a>
                    </div>
                    <div id="faq4" class="collapse" aria-labelledby="faqhead4" data-parent="#faq">
                        <div class="card-body">
                            <table class="table table-bordered table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Sent</th>
                                        <th>Opened</th>
                                        <th>Opened By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Invoice Email</td>
                                        <td>Feb 11, 2021 | 02:47 PM</td>
                                        <td><i class="fas fa-check-double"></i></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="faqhead5"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq5" aria-expanded="true" aria-controls="faq5"><i class="fas fa-file-invoice"></i> Invoice Payments <span class="paid-btn">Part Paid</span></a>
                    </div>
                    <div id="faq5" class="collapse" aria-labelledby="faqhead5" data-parent="#faq">
                        <div class="card-body">
                            <table class="table table-bordered table-hover table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Mode</th>
                                        <th>Amount</th>
                                        <th>TDS</th>
                                        <th>Notes</th>
                                        <th>Added By</th>
                                        <th>Settled Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>January 25, 2021</td>
                                        <td>UPI</td>
                                        <td>₹1,782</td>
                                        <td>₹198</td>
                                        <td>-</td>
                                        <td>Vendor</td>
                                        <td>₹1,980</td>
                                        <td><i class="fas fa-times-circle"></i> Remove</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="faqhead6"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq6" aria-expanded="true" aria-controls="faq6"><i class="fas fa-percentage"></i> EarlyPay Discount</a>
                    </div>
                    <div id="faq6" class="collapse" aria-labelledby="faqhead6" data-parent="#faq">
                        <div class="card-body"></div>
                    </div>
                </div>
				-->
                 <!--<div class="card">
                    <div class="card-header" id="faqhead7"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq7" aria-expanded="true" aria-controls="faq7"><i class="fas fa-link"></i> Linked <?=ucwords($record['page_name'])?> <span class="paid-btn">Created</span></a>
                    </div>
                    <div id="faq7" class="collapse" aria-labelledby="faqhead7" data-parent="#faq">
                        <div class="card-body">
                            <table class="table table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th><?=ucwords($record['page_name'])?>#</th>
                                        <th><?=$record['page_id']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=ucwords($record['page_name'])?> Date</td>
                                        <td><?php 
									if($otherdata['currentdate']!=""){
										$date=date_create($otherdata['currentdate']);
										echo date_format($date,"d F Y");
									} ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               <div class="card">
                    <div class="card-header" id="faqhead8"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq8" aria-expanded="true" aria-controls="faq8"><i class="fas fa-palette"></i> Change Invoice Design</a>
                    </div>
                    <div id="faq8" class="collapse" aria-labelledby="faqhead8" data-parent="#faq">
                        <div class="card-body"></div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
    <div class="invoice-type">
        <div class="container">
            <h1>Invoices</h1><span>Part Paid</span>
            <hr>
            <div class="row mt-3">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                    <p>Invoice No#</p>
                    <p>Invoice Date</p>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-6">
                    <p><b><?=$record['invoice_no']?></b></p>
                    <p><b>
					<?php $date=date_create($record['invoice_date']);?>
                    <?=date_format($date,"d F Y");?>
					</b></p>
                </div>
            </div>
			
            <div class="invoice-address-info mt-3">
                <div class="row">
                    <div class="col">
                        <div class="billed-to billed-by">
                            <h3>Vendors Details</h3>
                            <b><?=$clientDtl->org_name;?></b>
                            <p><?=$clientDtl->shipping_address;?>, <?=$clientDtl->shipping_city;?>, <?=$clientDtl->shipping_state;?>-<?=$clientDtl->shipping_zipcode;?>, <?=$clientDtl->shipping_country;?></p>
                            <p><b>Email:</b> <?=$clientDtl->email;?></p>
                            <p><b>Phone:</b> +91-<?=$clientDtl->mobile;?></p>
							<p><b>GSTIN: </b> <?=$clientDtl->gstin;?> </p>
				            
                        </div>
                    </div>
                    <div class="col">
					    <div class="billed-by">
                            <h3>Ship To</h3>
                            <b><?=$branch['company_name'];?></b>
                            <p><?=$branch['address'];?>, <?=$branch['city'];?>, <?=$branch['state'];?>-<?=$branch['zipcode'];?>, <?=$branch['country'];?></p>
                            <p><b>Email:</b> <?=$branch['branch_email'];?></p>
                            <p><b>Phone:</b> +91-<?=$branch['contact_number'];?></p>
							<p><b>GSTIN: </b> <?=$branch['gstin'];?> </p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="invoice-table mt-3 text-left">
                <div class="row">
                    <div class="col">
                        <p><b>Country of Supply :</b> <?=$branch['country'];?></p>
                    </div>
                    <div class="col">
                        <p><b>Place of Supply :</b> <?=$branch['city'];?> (<?=$branch['zipcode'];?>)</p>
                    </div>
                </div>
                <table class="table table-responsive-lg">
                    <?php 
                	    $igst=explode("<br>",$record['igst']);
                    ?>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>GST</th>
                            <th>Quantity</th>
                            <th>Rate</th>
							<th>Amount</th>
							<?php if($igst[0]!=""){?>
                            <th>IGST</th>
							<?php }else{ ?>
                            <th>CGST</th>
                            <th>SGST</th>
							<?php } ?>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php 
					$totaliGst=0;
					$totalsGst=0;
					$totalcGst=0;
					if($record['product_name']!=""){
						$product_name=explode("<br>",$record['product_name']);
						$gst=explode("<br>",$record['gst']);
						$quantity=explode("<br>",$record['quantity']);
						$unit_price=explode("<br>",$record['unit_price']);
						$igst=explode("<br>",$record['igst']);
						$sgst=explode("<br>",$record['sgst']);
						$cgst=explode("<br>",$record['cgst']);
						$total=explode("<br>",$record['total']);
						$sub_totalwithgst=explode("<br>",$record['sub_totalwithgst']);
						for($rw=0; $rw<count($product_name); $rw++){
						?>
                        <tr>
                            <td><?=$product_name[$rw];?></td>
                            <td><?=$gst[$rw];?>%</td>
                            <td><?=$quantity[$rw];?></td>
                            <td>₹ <?=IND_money_format($unit_price[$rw]);?></td>
							<td>₹ <?=IND_money_format($total[$rw]);?></td>
							<?php if($igst[$rw]!=""){ ?>
                            <td>₹ <?=IND_money_format($igst[$rw]);?></td>
							<?php $totaliGst=$totaliGst+$igst[$rw]; }else if($cgst[$rw]!=""){  ?>
                            <td>₹ <?=IND_money_format($cgst[$rw]);?></td>
                            <td>₹ <?=IND_money_format($sgst[$rw]);?></td>
							<?php $totalsGst=$totalsGst+$sgst[$rw];
									$totalcGst=$totalcGst+$cgst[$rw];
							} ?>
                            <td>₹ <?=IND_money_format($sub_totalwithgst[$rw]);?></td>
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
							<?php  $get_amount= AmountInWords($record['final_total']);
							echo $get_amount;
							?></b></p>
                        </div>
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
                                    (₹ <?=IND_money_format($record['total_discount']);?>)
                                </div>
                            </div>
                            <!--<div class="row">
                                <div class="col">
                                    Amount
                                </div>
                                <div class="col text-right">
                                    ₹1,980
                                </div>
                            </div>-->
								<?php if($igst[0]!=""){ ?>
							<div class="row">
                                <div class="col">
                                    IGST
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($totaliGst); ?>
                                </div>
                            </div>
							<?php }else if($record['sgst']!=""){?>
                            <div class="row">
                                <div class="col">
                                    SGST
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($totalsGst);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    CGST
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($totalcGst);?>
                                </div>
                            </div>
							<?php } ?>
							
							
							<?php  if($record['extraCharge_value']!=""){ 
							$extraCharge_name=explode("<br>",$record['extraCharge_name']);
							$extraCharge_value=explode("<br>",$record['extraCharge_value']);
							for($i=0; $i<count($extraCharge_value); $i++){
							?>
                            <div class="row">
                                <div class="col">
                                    <?=$extraCharge_name[$i];?>
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($extraCharge_value[$i]);?>
                                </div>
                            </div>
							<?php } } ?>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    Total (INR)
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($record['final_total']);?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="terms-condition">
                <p>Terms and Condition</p>
                <ol>
				<?php if($record['terms_condition']!=""){
					$terms_condition=explode("<br>",$record['terms_condition']);
					for($in=0; $in<count($terms_condition); $in++){
					?>
                    <li><?=$terms_condition[$in];?></li>
					<?php } } ?>
                </ol>
            </div>
            <!--<div class="payment-details">
                <table class="table table-responsive-lg table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Mode</th>
                            <th>Amount</th>
                            <th>TDS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>January 25, 2021</td>
                            <td>UPI</td>
                            <td>₹1,782</td>
                            <td>₹198</td>
                        </tr>
                    </tbody>
                </table>
            </div>-->
        </div>
    </div>
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
                             <?php if($this->session->userdata('update_pi')=='1'): ?>
                            <li class="list-group-item"><a href="<?=base_url();?>invoices/edit-invoice/<?=$record['id']?>"><i class="fas fa-pencil-alt"></i>Edit Invoice</a>
                            </li>
                            <?php endif; ?>
                            <!--<li class="list-group-item"><a href="#"><i class="fas fa-money-bill-wave"></i>Add Payment Details</a>
                            </li>
                            <li class="list-group-item"><a href="#"><i class="fas fa-envelope"></i>Send Reciept</a>
                            </li>-->
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons">
                        <ul class="list-group list-group-horizontal">
						    
                            <li class="list-group-item"><a href="<?=base_url();?>invoices/generate-pdf?inv_id=<?=$_GET['inv_id'];?>&cnp=<?=$_GET['cnp'];?>&ceml=<?=$_GET['ceml'];?>" target="_blank"><i class="fas fa-print"></i>Print</a>
                            </li>
                            <li class="list-group-item"><a href="<?=base_url();?>invoices/generate-pdf?inv_id=<?=$_GET['inv_id'];?>&cnp=<?=$_GET['cnp'];?>&ceml=<?=$_GET['ceml'];?>&dn=1" target="_blank"><i class="fas fa-download"></i>Download</a>
                            </li>
                            <li class="list-group-item" onclick="update_billedby(15)" style="cursor:pointer;" ><a   ><i class="fas fa-share-alt"></i>Share</a>
                            </li>
                            <li class="list-group-item" onClick="shareEmail();"><a href="#" ><i class="fas fa-file-alt"></i>Email invoice</a>
                            </li>
                            <!--<li class="list-group-item"><a href="#"><i class="fas fa-angle-down"></i>More</a>
                            </li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="milestones mt-5" id="my2"></div>
        </div>
    </div>
</div>
<style>
.shareIcn{
	font-size: 33px;
	cursor: pointer;
}
.fa-whatsapp{
	color: #4caf5094;
}
.fa-envelope{
	color: #ff57228c;
}

.lbl{
	padding-top: 12px;
}
</style>

<div class="modal fade" id="branch_details">
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
			   <?php $actual_link = base_url()."invoices/generate-pdf?inv_id=".$_GET['inv_id']."&cnp=".$_GET['cnp']."&ceml=".$_GET['ceml']; ?>
			  
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

<div class="modal fade" id="emailModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title">Email Invoice</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
       <input type="hidden" class="form-control" value="<?=$record['id'];?>" id="piid">
	   <input type="hidden" class="form-control" value="<?=$record['session_comp_email'];?>" id="compeml">
		<input type="hidden" class="form-control" value="<?=$record['session_company'];?>" id="compname">
      <div class="modal-body" style="padding: 5%;">
          <div class="row" id="formDiv">
            <div class="col-md-2 lbl">
				<label for="">Client's Name:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control onlyLetters" value="<?=$clientDtl->org_name;?>" name="orgName" id="orgName">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Client's Email:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$clientDtl->email;?>" name="orgEmail" id="orgEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">CC:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$branch['branch_email'];?>" name="ccEmail" id="ccEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Subject:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="Invoices For <?=$clientDtl->org_name;?> - #<?=$record['invoice_no'];?>" name="subEmail" id="subEmail">
            </div>
			<div class="col-md-12 lbl">
				<label for="">Message*:</label>
			</div>
			<div class="col-md-12" style="font-size: 11px; margin: 3px 0px;">
				Invoice PDF attachment and Online Link will be added to the email automatically.
			</div>
			
			<div class="col-md-12">
			  <textarea class="form-control" id="descriptionTxt"   name="descriptionTxt">
				<p>Hi <?=$clientDtl->org_name;?>,</p>
				<p>Please find attached invoice #<?=$record['invoice_no'];?>.</p>
				<p>Invoice No: #<?=$record['invoice_no'];?></p>
				<p>Billed To: <?=$clientDtl->org_name;?></p>
				<p>Total Amount: ₹ <?=IND_money_format($record['final_total']);?></p>
				<p>Thank you for your business.</p>
				<p>Regards ,</p>
				<p><?=$branch['company_name'];?>, <?=$branch['branch_name'];?></p>
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

<div class="modal fade" id="addbankmodal">
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
				 <input type="text" name="bank_country" id="bank_country" class="form-control onlyLetters">
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
                <input type="text" name="bank_name" id="bank_name" class="form-control onlyLetters">
				<span id="bank_name_error" style="color:red;"></span>
            </div>
            <div class="col-md-6 form-group">
                <label><span>*</span> Account Number</label>
                <input type="text" name="account_no" id="account_no" class="form-control numeric">
				<span id="account_no_error" style="color:red;"></span>
            </div>
            <div class="col-md-6 form-group">
                <label><span>*</span> Confirm Account Number</label>
                <input type="text" id="caccount_no" class="form-control numeric">
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
                <input type="text" name="acc_holder_name" id="acc_holder_name" class="form-control onlyLetters">
				<span id="acc_holder_name_error" style="color:red;"></span>
            </div>

            <div class="col-md-6 form-group">
                <label><span>*</span> Your Phone Number</label>
                <input type="text" name="mobile_no" id="mobile_no" value="" class="form-control numeric" maxlength="10">
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




<!-- common footer include -->
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<!-- common footer include -->
<script>
var editor = CKEDITOR.replace( 'descriptionTxt' );
CKEDITOR.config.height='150px';
</script>
<script>
function share() { 
			
				
    var message =  "<?php echo base_url();?>invoices/generate-pdf?inv_id=<?=$_GET['inv_id']?>&cnp=<?=$_GET['cnp'];?>&ceml=<?=$_GET['ceml'];?>"; 
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
	var orgName   = $("#orgName").val();
	var orgEmail  = $("#orgEmail").val();
	var ccEmail   = $("#ccEmail").val();
	var subEmail  = $("#subEmail").val();
	var piid      = $("#piid").val();
	var compeml   = $("#compeml").val();
	var compname  = $("#compname").val();
	 $("#sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
	//alert(piid);
		//alert(compeml);
			//alert(compname);
	var invoiceurl="<?php echo base_url();?>invoices/generate-pdf?inv_id=<?=$_GET['inv_id']?>&cnp=<?=$_GET['cnp'];?>&ceml=<?=$_GET['ceml'];?>";
	var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
	$.ajax({
     url: "<?= site_url(); ?>invoices/send_email",
     method: "POST",
     data: {orgName:orgName,orgEmail:orgEmail,ccEmail:ccEmail,subEmail:subEmail,descriptionTxt:descriptionTxt,invoiceurl:invoiceurl,piid:piid,compeml:compeml,compname:compname},
     
     success: function(dataSucc){
         console.log(dataSucc);
      if(dataSucc==1){
          
		    $("#formDiv, #footerDiv").hide();
			$("#messageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your invoice shared successfully.');
			$("#messageDiv").css('display','block');
			$("#sendEmail").html('Send Email');
			setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); $('#emailModel').modal('hide'); },4000)
	  }else{
		  $("#formDiv, #footerDiv").hide();
		  $("#messageDiv").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Your invoice shared failed.');
		  $("#messageDiv").css('display','block');
		  $("#sendEmail").html('Send Email');
		  setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); },4000)
	  }
     }
    });
});


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
            url : "<?php echo site_url('invoices/getbankdetails')?>/",
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
            url : "<?php echo site_url('invoices/changebankstatus')?>",
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
					}else{
					    $("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Payment options successfully disable.');
						$("#alert_popup").modal('show');
						setTimeout(function(){ $("#alert_popup").modal('hide');  },2000);
					}
				}else{
					    $("#common_popupmsg").html('<i class="fa fa-exclamation-triangle" style="color: red;"></i><br>Some error occure!');
						$("#alert_popup").modal('show');
						setTimeout(function(){ $("#alert_popup").modal('hide');  },2000);
					//alert('some error occure!');
				}
			}
	});	
}
<?php if(isset($bank_details_terms->enable_payment)) { if($bank_details_terms->enable_payment==1){ ?> $(".bank-name").show(); <?php } }?>

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
          url = "<?= site_url('invoices/create_bankDetails')?>";
      } else {
          url = "<?= site_url('invoices/update_bankDetails')?>";
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
    stage: 2,
    checks: 1,
    stageclass: 'doneclass',
    labels: ["Invoice Details","Your Bank Details","Download or Email Invoice"]
  });

</script>
<script>
$(document).ready(function()
{
	 var i = 0;
    $("#add_terms_conditionb").click(function()
    {
		 i++;
        var markup = '<div class="row" id="addterms'+i+'"> <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right">'+
          '<p>'+i+'.</p></div> <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10"> <input type="text" name="terms_conditionbnk[]" placeholder="Write Your Conditions">'+
        '</div><div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1"> <a href="javascript:void(0);" class="remove_terms" id="'+i+'">X</a></div> </div>';
		
		$("#terms_conditionb").append(markup);
		countPtg();
	});
		
    // Find and remove selected table rows
	$("#terms_conditionb").on('click','.remove_terms',function(){
        var button_id = $(this).attr("id");
        $("#addterms"+button_id+"").remove();
        countPtg();

    });
    
    function countPtg(){
        var arr = $('#terms_conditionb p');
        var cnt=1;
        for(i=0;i<arr.length;i++)
        {
          $(arr[i]).html(cnt+".");
          cnt++;
        }
    }
    
    
	
});
</script>