<!-- common header include -->
<?php $this->load->view('common_navbar');?>
<!-- common header include -->
<style>
    .content-header {background: #f2f2f2;}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
                             <li class="list-group-item"><a href="<?=base_url('salesorders');?>"><i class="fas fa-arrow-circle-left"></i>Back</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons">
                        <ul class="list-group list-group-horizontal">
                             <li class="list-group-item"><a href="<?=base_url();?>salesorders/view/<?=$record['id']?>" target="_blank"><i class="fas fa-print"></i>Print</a>
                            </li>
                            <li class="list-group-item"><a href="<?=base_url();?>salesorders/view/<?=$record['id']?>/dn" target="_blank"><i class="fas fa-download"></i>Download</a>
                            </li>
                            <li class="list-group-item" onclick="update_billedby(15)" style="cursor:pointer;" ><a   ><i class="fas fa-share-alt"></i>Share</a>
                            </li>
                            <li class="list-group-item" onClick="shareEmail();"><a href="#" ><i class="fas fa-file-alt"></i>Email invoice</a>
                            </li>
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
                    <div class="card-header" id="faqhead1"> <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1"><i class="fas fa-file-alt"></i> Quick Salesorder Detail</a>
                    </div>
                    <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <b>Salesorder Id</b>
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
                                    <b>Salesorder Date</b>
									<?php 
									//$date=date_create($record['invoice_date']);?>
                                    <p><?=date('d-M-Y',strtotime($record['currentdate']));?></p>
                                </div>
                                <div class="col">
                                    <b>Due Date</b>
                                    <p><?=date('d-M-Y',strtotime($record['due_date'])); ?></p>
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
                    <div class="card-header" id="faqhead7"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq7" aria-expanded="true" aria-controls="faq7"><i class="fas fa-link"></i> Linked Saleorders <span class="paid-btn">Created</span></a>
                    </div>
                    <div id="faq7" class="collapse" aria-labelledby="faqhead7" data-parent="#faq">
                        <div class="card-body">
                            <table class="table table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Saleorders#</th>
                                        <th><?=$record['saleorder_id']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Saleorders Date</td>
                                        <td><?=date('d-M-Y',strtotime($record['currentdate'])); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="invoice-type">
        <div class="container">
            <h1>Saleorders</h1>
            <hr>
            <div class="row mt-3">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                    <p>Salesorder Id#</p>
                    <p>Salesorder Date</p>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-6">
                    <p><b><?=$record['saleorder_id']?></b></p>
                    <p><b><?=date('d-M-Y');?></b></p>
                </div>
            </div>
            <div class="invoice-address-info mt-3">
                <div class="row">
                    <div class="col">
                        <div class="billed-by">
                            <h3>Billed By</h3>
                            <b><?=$this->session->userdata('company_name');?></b>
                            <p><?=$this->session->userdata('company_address');?></p>
                            <p><?=$this->session->userdata('city');?></p>
                            <p><?=$this->session->userdata('state');?>-<?=$this->session->userdata('zipcode');?>, <?=$this->session->userdata('country');?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="billed-to billed-by">
                            <h3>Billed To</h3>
                            <b><?=$record['contact_name'];?></b><br>
                            <b><?=$record['org_name'];?></b><br>
							<b><?=$record['billing_address'];?></b><br>
                            <p><?=$record['billing_city'];?>,<?=$record['billing_state'];?>-<?=$record['billing_zipcode'];?>, <?=$record['billing_country'];?></p>
                            <!--<p><b>Email:</b> <?=$record['email'];?></p>
                            <p><b>Phone:</b> +91-<?=$record['mobile'];?></p>-->
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
                <table class="table table-responsive-lg">
                    <thead>
                        <tr>
						    <th>S.No</th>
                            <th style="width:40%;">Product/Services</th>
							<th>HSN/SAC</th>
                            <th>Tax</th>
                            <th>Qty</th>
                            <th>Rate</th>
							<th>Amount</th>
						 
                        </tr>
                    </thead>
                    <tbody>
					<?php 
					$totaliGst=0;
					$totalsGst=0;
					$totalcGst=0;
					if($record['product_name']!=""){
						$product_name=explode("<br>",$record['product_name']);
						if(!empty($record['gst'])){
						$gst=explode("<br>",$record['gst']);
						}
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
                            <td><?=$hsnsac[$rw];?></td>
							<?php if(!empty($gst)){ ?>
							<td><?='GST@'.$gst[$rw].'%';?></td>
							<?php }else{ ?>
							<td><?='GST@18%';?></td>
							<?php } ?>
                            <td><?=$quantity[$rw];?></td>
                            <td>₹ <?=IND_money_format($unit_price[$rw]);?></td>
							<td>₹ <?=IND_money_format($total[$rw]);?></td>
							<!--<?php if($igst[$rw]!=="" && $igst[$rw]!=='0.00'){ ?>
                            <td>₹ <?=IND_money_format($igst[$rw]);?></td>
							<td>₹ <?=IND_money_format($sub_totalwithgst[$rw]);?></td>
							<?php $totaliGst=$totaliGst+$igst[$rw]; }else if($cgst[$rw]!=""){  ?>
                            <td>₹ <?=IND_money_format($cgst[$rw]);?></td>
                            <td>₹ <?=IND_money_format($sgst[$rw]);?></td>
							<td>₹ <?=IND_money_format($sub_totalwithgst[$rw]);?></td>
							<?php $totalsGst=$totalsGst+$sgst[$rw];
									$totalcGst=$totalcGst+$cgst[$rw];
							} ?>-->
                            
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
							<?php  $get_amount= AmountInWords($record['sub_totals']);
							echo $get_amount;
							?></b></p>
                        </div>
                        
                        <?php if(!empty($record['customer_company_name'])) { ?>
        		
                        <table width="100%" border="0" style="max-width:800px; border-radius:5px; background: #636979;color: #fffcf9; font-size:14px;padding:20px;display:block;">
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
                                   <th style="text-align:left;  padding-left:10px;">Microsoft Lan_no:<th> 
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
                            <!--<div class="row">
                                <div class="col">
                                    Amount
                                </div>
                                <div class="col text-right">
                                    ₹1,980
                                </div>
                            </div>-->
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
								 <?php }elseif($record['cgst6'] == '0' && $record['cgst9'] !== '0' && $record['cgst14'] == '0') { ?>
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
								<?php   } }else{ ?> 
								<div class="row">
									<div class="col">
										IGST@18%
									</div>
									<div class="col text-right">
										₹ <?=IND_money_format($record['igst18']); ?>
									</div>
								</div>
								<?php   } ?> 
							
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
                            <!--<li class="list-group-item"><a href="<?=base_url();?>proforma_invoice/create_newProforma/<?=$record['id']?>"><i class="fas fa-pencil-alt"></i>Edit Invoice</a>
                            </li>
                            <li class="list-group-item"><a href="#"><i class="fas fa-money-bill-wave"></i>Add Payment Details</a>
                            </li>
                            <li class="list-group-item"><a href="#"><i class="fas fa-envelope"></i>Send Reciept</a>
                            </li>-->
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons">
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item"><a href="<?=base_url();?>salesorders/view/<?=$record['id']?>" target="_blank"><i class="fas fa-print"></i>Print</a>
                            </li>
                            <li class="list-group-item"><a href="<?=base_url();?>salesorders/view/<?=$record['id']?>/dn" target="_blank"><i class="fas fa-download"></i>Download</a>
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

<div class="modal fade" id="emailModel">
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
				<p>Please find attached Salesorder #<?=$record['saleorder_id'];?>.</p>
				<p>Salesorder Id: #<?=$record['saleorder_id'];?></p>
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
        var message =  "<?php echo base_url();?>salesorders/view/<?=$record['id']?>"; 
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
			$("#messageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your Saleorders shared successfully.');
			$("#messageDiv").css('display','block');
			$("#sendEmail").html('Send Email');
			setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); $('#emailModel').modal('hide'); },4000)
	  }else{
		  $("#formDiv, #footerDiv").hide();
		  $("#messageDiv").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Your Saleorders shared failed.');
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
    stage: 2,
    checks: 1,
    stageclass: 'doneclass',
    labels: ["Invoice Details","Your Bank Details","Download or Email Invoice"]
  });
  
  
 
  
</script>