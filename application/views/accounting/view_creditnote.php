<?php $this->load->view('common_navbar');?>
<style>
    .content-header {background: #f2f2f2;}
	.acountDeatils{
	background: #6539c01a;
    width: 70%;
    padding: 10px;
    font-size: 14px;
    border-radius: 7px;
	}
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

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
                            <li class="list-group-item text-center">
							<a href="<?=base_url('credit-note');?>"><div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"></div>Back</a>
                            </li>
							<?php if($this->session->userdata('update_pi')=='1'): ?>
                            <li class="list-group-item text-center"><a href="<?=base_url();?>add-creditnote/<?=$view_creditnote['invoice_id']?>"><div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"></div>Edit Credit Note</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons d-flex justify-content-end">
                        <ul class="list-group list-group-horizontal">
						
						
						    <li class="list-group-item text-center"><a href="<?=base_url();?>Accounting/generate-pdf-credit?inv_id=<?=$_GET['inv_id'];?>&cnp=<?=$_GET['cnp'];?>&ceml=<?=$_GET['ceml'];?>" target="_blank"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>
                            </li>
                            <li class="list-group-item text-center"><a href="<?=base_url();?>Accounting/generate-pdf-credit?inv_id=<?=$_GET['inv_id'];?>&cnp=<?=$_GET['cnp'];?>&ceml=<?=$_GET['ceml'];?>&dn=1" target="_blank"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>
                            </li>
                            <li class="list-group-item text-center" onclick="update_billedby(15)" style="cursor:pointer;" ><a><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>
                            </li>
                            <li class="list-group-item text-center" onClick="shareEmail();"><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>Email Credit Note</a>
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
                    <div class="card-header" id="faqhead1"> <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1"><i class="fas fa-file-alt"></i> Credit Note Summary</a>
                    </div>
                    <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <b>Credit Note No.</b>
                                    <p><?=$view_creditnote['creditnote_no']?></p>
                                </div>
                                <div class="col">
                                    <b>Customer Name</b>
                                    <p><?=$view_creditnote['org_name']?></p>
                                </div>
                                <div class="col">
                                    <b>Total Amount</b>
									
                                    <p>₹ <?=$view_creditnote['sub_total']?></p>
                                </div>
                                <div class="col">
                                    <b>Customer Balance</b>
									
                                    <p>₹ <?=$view_creditnote['pending_payment']?> (Due)</p>
                                </div>
                                <div class="col">
                                    <b>Credit Note Date</b>
									<p><?php 
									if($view_creditnote['creditnote_date']!=""){
										$date=date_create($view_creditnote['creditnote_date']);
										echo date_format($date,"d F Y");
									}else{ echo "Not Set"; } ?></p>
                                </div>
                                <div class="col">
                                    <b>Due Date</b>
                                    <p><?php 
									if($view_creditnote['due_date']!=""){
										$date=date_create($view_creditnote['due_date']);
										echo date_format($date,"d F Y");
									}else{ echo "Not Set"; } ?></p>
                                </div>
                                <div class="col">
                                    <b>Other Reference(s)</b>
                                    <p><?=$view_creditnote['owner']?></p>
                                </div>

                                <div class="col">
                                    <b> Supplier's Ref.</b>
                                    <p><?=$view_creditnote['so_owner']?></p>
                                </div>

                                <div class="col">
                                    <b>Buyer's Order No.</b>
                                    <p><?=$view_creditnote['cust_order_no']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div id="main" class="content">
        <div class="container-fluid">
            <div class="accordion" id="faq">
                <div class="card">
                    <div class="card-header" id="faqhead1"> <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1" style="background:rgba(230,242,255,0.4); color:black;"> <img src="https://img.icons8.com/plasticine/24/000000/invoice-1.png"/>Quick Invoices Detail</a>
                    </div>
                    <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <b>Invoice</b>
                                    <p><?=$view_creditnote['creditnote_no']?></p>
                                </div>
                                <div class="col">
                                    <b>Customer Name</b>
                                    <p><?=$clientDtl->org_name?></p>
                                </div>
                                <div class="col">
                                    <b>Total Amount</b>
									
                                    <p>₹ <?=IND_money_format($view_creditnote['sub_total']);?></p>
                                </div>
                                <div class="col">
                                    <b>Invoice Date</b>
									<?php 
									$date=date_create($view_creditnote['creditnote_date']);?>
                                    <p><?=date_format($date,"d M Y");?></p>
                                </div>
                                <div class="col">
                                    <b>Due Date</b>
                                    <p><?php 
									if($view_creditnote['due_date']!=""){
										$date=date_create($view_creditnote['due_date']);
										echo date_format($date,"d F Y");
									}else{ echo "Not Set"; } ?></p>
                                </div>
                                <div class="col">
                                    <b>Other Reference(s)</b>
                                    <p><?=$view_creditnote['owner'];?></p>
                                </div>
								<div class="col">
                                    <b>Supplier's Ref.</b>
                                    <p><?=$view_creditnote['so_owner'];?></p>
                                </div>
								<div class="col">
                                    <b>Buyer's Order No.</b>
                                    <p><?=$view_creditnote['cust_order_no'];?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                
               
            </div>
        </div>
    </div> -->
    
    <div class="linkscontainer">
    <div class="invoice-type">
        <div class="container">
            <h1>Credit Note</h1><span>Part Paid</span>
            <hr>
         
            <div class="row mt-3">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
				<?php if(isset($view_creditnote['saleorder_id']) && $view_creditnote['saleorder_id']!=""){?>
					<p>Sales Order ID</p>
				<?php } ?> 
                    <p>Link Invoice No#</p>
                    <p>Credit Note No#</p>
                    <p>Credit Note Date</p>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-6">
				<?php if(isset($view_creditnote['saleorder_id']) && $view_creditnote['saleorder_id']!=""){ ?>
				    <p><b><?=$view_creditnote['saleorder_id']?></b></p>
				<?php } ?>	
                    <p><b><?=$inov_no['invoice_no']?></b></p>
                    <p><b><?=$view_creditnote['creditnote_no']?></b></p>
                    <p><b>
					<?php $date=date_create($view_creditnote['creditnote_date']);?>
                    <?=date_format($date,"d F Y");?>
					</b></p>
                </div>
            </div>
			
            <div class="invoice-address-info mt-3">
                <div class="row">
				   <div class="col">
					    <div class="billed-by" style="background:rgba(35, 0, 140, 0.8)">
                            <h3>Billed By</h3>
                            <b><?=$branch['company_name'];?></b>
                            <p><?=$branch['address'];?>, <?=$branch['city'];?>, <?=$branch['state'];?>-<?=$branch['zipcode'];?>, <?=$branch['country'];?></p>
                            <p><b>Email:</b> <?=$branch['branch_email'];?></p>
                            <p><b>Phone:</b> +91-<?=$branch['contact_number'];?></p>
							<p><b>GSTIN: </b> <?=$branch['gstin'];?> </p>
                        </div>
                        
                    </div>
                    <div class="col">
                        <div class="billed-to billed-by" style="background:rgba(35, 0, 140, 0.8)">
                            <h3>Billed To</h3>
                            <b><?=$clientDtl->org_name;?></b>
                            <p><?=$clientDtl->shipping_address;?>, <?=$clientDtl->shipping_city;?>, <?=$clientDtl->shipping_state;?>-<?=$clientDtl->shipping_zipcode;?>, <?=$clientDtl->shipping_country;?></p>
                            <p><b>Email:</b> <?=$clientDtl->email;?></p>
                            <p><b>Phone:</b> +91-<?=$clientDtl->mobile;?></p>
							<p><b>GSTIN: </b> <?=$clientDtl->gstin;?> </p>
				            
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
                	    $igst=explode("<br>",$view_creditnote['igst']);
                    $discount = explode("<br>",$view_creditnote['pro_discount']); ?>
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
					$totaliGst=0;
					$totalsGst=0;
					$totalcGst=0;
					if($view_creditnote['product_name']!=""){
						$product_name=explode("<br>",$view_creditnote['product_name']);
						if(!empty($view_creditnote['gst'])){
						$gst=explode("<br>",$view_creditnote['gst']);
						}
						$quantity=explode("<br>",$view_creditnote['quantity']);
						$unit_price=explode("<br>",$view_creditnote['unit_price']);
						$hsnsac = explode("<br>",$view_creditnote['hsn_sac']);
						$total=explode("<br>",$view_creditnote['total']);
						$descriptionPro=explode("<br>",$view_creditnote['pro_description']);
						for($rw=0; $rw<count($product_name); $rw++){
							$num = $rw + 1;
						?>
                        <tr>
						    <td><?=$num;?></td>
                            <td style="cursor:pointer;" data-toggle="collapse" href="#proDesc<?=$rw;?>" ><?=$product_name[$rw];?></td>
                            <td><?=$hsnsac[$rw];?></td>
							<?php if(!empty($gst)){ ?>
							<td><?='GST@'.$gst[$rw].'%';?></td>
							<?php } ?>
                            <td><?=$quantity[$rw];?></td>
                            <td>₹ <?=IND_money_format($unit_price[$rw]);?></td>
							<?php if(count($discount)>0){ ?>
							<td>₹ <?php if(isset($discount[$rw])){ echo IND_money_format($discount[$rw]); }else{ echo "0"; } ?></td>
							<?php } ?>
							<td>₹ <?=IND_money_format($total[$rw]);?></td>
                        </tr>
						<tr class="collapse" id="proDesc<?=$rw;?>" >
						    <td colspan="8" style="border-top: 0px solid !important; font-size: 14px;"><?php if(isset($descriptionPro[$rw]) && $descriptionPro[$rw]!=""){echo $descriptionPro[$rw]; }else{ echo "NA"; } ?></td>
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
							<?php  $get_amount= AmountInWords($view_creditnote['sub_total']);
							echo $get_amount;
							?></b></p>
                        </div>
						<?php if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){ ?>
						<div class="bank-total-left acountDeatils">
							<div class="row">
                                <div class="col">
                                    <b>Bank Details</b>
                                </div>
                            </div>
							<div class="row">
                                <div class="col">
                                    Account Holder Name:
                                </div>
                                <div class="col text-right">
                                    <?=ucfirst($bank_details_terms->acc_holder_name);?>
                                </div>
                            </div>
							<div class="row">
                                <div class="col">
                                    Account Number:
                                </div>
                                <div class="col text-right">
                                    <?=$bank_details_terms->account_no;?>
                                </div>
                            </div>
							<div class="row">
                                <div class="col">
                                   IFSC:
                                </div>
                                <div class="col text-right">
                                    <?=$bank_details_terms->ifsc_code;?>
                                </div>
                            </div>
							<div class="row">
                                <div class="col">
                                    Account Type:
                                </div>
                                <div class="col text-right">
                                    <?=ucfirst($bank_details_terms->account_type);?>
                                </div>
                            </div>
							<div class="row">
                                <div class="col">
                                    Bank Name:
                                </div>
                                <div class="col text-right">
                                    <?=ucfirst($bank_details_terms->bank_name);?>
                                </div>
                            </div>
							<?php if($bank_details_terms->upi_id!=""){ ?>
							<div class="row">
                                <div class="col">
                                   UPI Id:
                                </div>
                                <div class="col text-right">
                                    <?=$bank_details_terms->upi_id;?>
                                </div>
                            </div>
						
						<?php } ?>
						</div>
						<?php } ?>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                        <div class="bank-total-right">
                            <div class="row">
                                <div class="col">
                                    Sub Total
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($view_creditnote['initial_total']);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Discount
                                </div>
                                <div class="col text-right">
                                    (₹ <?=IND_money_format($view_creditnote['total_discount']);?>)
                                </div>
                            </div>
                           
							<?php //if($igst[0]!=""){ ?>
							<?php if($view_creditnote['type']=="Interstate"){ ?>
							<div class="row">
                                <div class="col">
                                    IGST
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($view_creditnote['total_igst']); ?>
                                </div>
                            </div>
							<?php }else if($view_creditnote['type']=="Instate"){?>
                            <div class="row">
                                <div class="col">
                                    SGST
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($view_creditnote['total_sgst']);?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    CGST
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($view_creditnote['total_cgst']);?>
                                </div>
                            </div>
							<?php } ?>
							<?php  if($view_creditnote['extra_charge_value']!=""){ 
							$extraCharge_name=explode("<br>",$view_creditnote['extra_charge_label']);
							$extraCharge_value=explode("<br>",$view_creditnote['extra_charge_value']);
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
                                    ₹ <?=IND_money_format($view_creditnote['sub_total']);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="terms-condition">
                <p><b>Terms and condition :-</b></p>
                <ol>
				<?php if($view_creditnote['terms_condition']!=""){
					$terms_condition=explode("<br>",$view_creditnote['terms_condition']);
					for($in=0; $in<count($terms_condition); $in++){
					?>
                    <li><?=$terms_condition[$in];?></li>
					<?php } } ?>
                </ol>
            </div>
			
			
			<div class="terms-condition">
				<div class="row">
					<div class="col">		
						<p><b>Declaration :-</b></p>
					</div>
					<div class="col">
						<div class="details-switch">
							<label class="switch">
								<input type="checkbox" id="slider_declaration" onchange="enable_declaration('<?=$view_creditnote['id'];?>')" name="slider_declaration" <?php if($view_creditnote['declaration_status']==1){ echo "checked"; } ?> >
								<text class="slider round"></text>
							</label>
						</div>	
					</div>
					<div class="col"> </div>
				</div>
				<div class="row">
					<?php if($view_creditnote['invoice_declaration']!=""){ echo $view_creditnote['invoice_declaration']; } ?>
				</div>
				<div class="row mt-4" style="font-size:11px;">
					* If the declaration is checked, it will show in the invoice PDF otherwise not.
				</div>
				
            </div>
			
			
			<div class="terms-condition">
                <p><b>Note :-</b> </p>
				<?php if($view_creditnote['notes']!=""){ echo $view_creditnote['notes']; } ?>
                </ol>
            </div>
        </div>
    </div>
                    </div>
	
	
	
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                         <ul class="list-group list-group-horizontal">
                            <li class="list-group-item text-center">
							<a href="<?=base_url('credit-note');?>"><div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"></div>Back</a>
                            </li>
							<?php if($this->session->userdata('update_pi')=='1'): ?>
                            <li class="list-group-item text-center"><a href="<?=base_url();?>add-creditnote/<?=$view_creditnote['invoice_id']?>"><div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"></div>Edit Credit Note</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons d-flex justify-content-end">
                        <ul class="list-group list-group-horizontal">
						    <li class="list-group-item text-center"><a href="<?=base_url();?>Accounting/generate-pdf-credit?inv_id=<?=$_GET['inv_id'];?>&cnp=<?=$_GET['cnp'];?>&ceml=<?=$_GET['ceml'];?>" target="_blank"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>
                            </li>
                            <li class="list-group-item text-center"><a href="<?=base_url();?>Accounting/generate-pdf-credit?inv_id=<?=$_GET['inv_id'];?>&cnp=<?=$_GET['cnp'];?>&ceml=<?=$_GET['ceml'];?>&dn=1" target="_blank"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>
                            </li>
                            <li class="list-group-item text-center" onclick="update_billedby(15)" style="cursor:pointer;" ><a><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>
                            </li>
                            <li class="list-group-item text-center" onClick="shareEmail();"><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>Email Credit Note</a>
                            </li>
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

<!-- <div class="modal fade" id="branch_details" data-keyboard="false" data-backdrop="static">
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
</div> -->

<!-- <div class="modal fade" id="emailModel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title">Email Invoice</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
       <input type="hidden" class="form-control" value="<?=$view_creditnote['id'];?>" id="piid">
	   <input type="hidden" class="form-control" value="<?=$view_creditnote['session_comp_email'];?>" id="compeml">
		<input type="hidden" class="form-control" value="<?=$view_creditnote['session_company'];?>" id="compname">
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
			  <input type="text" class="form-control" value="Invoices For <?=$clientDtl->org_name;?> - #<?=$view_creditnote['creditnote_no'];?>" name="subEmail" id="subEmail">
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
				<p>Please find attached invoice #<?=$view_creditnote['creditnote_no'];?>.</p>
				<p>Invoice No: #<?=$view_creditnote['creditnote_no'];?></p>
				<p>Billed To: <?=$clientDtl->org_name;?></p>
				<p>Total Amount: ₹ <?=IND_money_format($view_creditnote['sub_total']);?></p>
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
</div> -->
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



 <!----accept payment modal start-----> 
    <!-- <div class="modal fade" id="modal_form_accept" role="dialog" style="z-index: 2222 !important;" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="so_add_edit">Add Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body form">
                  <form action="#" id="payment_form" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <input type="hidden"  name="sales_id" id="sales_id" value="<?php echo $view_creditnote['saleorder_id'];?>" >
					<input type="hidden"   name="inv_id" id="inv_id" value="<?php echo $view_creditnote['id'];?>" >
                    <div class="form-body form-row">
					<div class="row">
                      <div class="col-md-6">
						<div class="form-group">
							<label for="">Payment Mode<span class="text-danger">*</span>:</label>
							<select class="form-control" name="payment_mode" id="payment_mode">
							  <option value="" data-msg="Optional">Select Payment Mode</option>
							  <option value="cheque" data-msg="Cheque number *">By Cheque</option>
							  <option value="online" data-msg="Refrence number *">Online</option>
							  <option value="UPI" data-msg="Mobile number *">UPI</option>
							  <option value="cash" data-msg="Optional">Cash</option>
							</select>
							<span id="payment_mode_error"></span>
						</div>
                      </div>
					  <div class="col-md-6">
						<div class="form-group">
							<label id="textRef">Cheque No.<span class="text-danger">*</span>:</label>
							<input type="text" class="form-control" name="cheque_no" id="cheque_no" placeholder="Cheque Number">
							<span id="cheque_no_error"></span>
						</div>
                      </div>
					  <div class="col-md-6">
						<div class="form-group">
							<label for="">Remaining Amt<span class="text-danger">*</span>:</label>
							<input type="text" class="form-control" name="adv_payments" id="adv_payments" placeholder="Enter Remaining Amt.">
							<span id="adv_payments_error" style="color:red"></span>
						</div>
                      </div>
                      <div class="col-md-6">
						<div class="form-group">
							<label for="">Payment Date<span class="text-danger">*</span>:</label>  
							<input type="date" class="form-control" name="payment_date" id="payment_date" placeholder="Enter Advanced Payment">
							<span id="adv_payments_error" style="color:red"></span>
						</div>
                      </div>
                      <div class="col-md-12">
						<div class="form-group">
							<label for="">Remarks<span class="text-danger">*</span>:</label>
							<textarea class="form-control" name="remarks" id="remarks" placeholder="Enter remarks"></textarea>
							<span id="adv_payments_error" style="color:red"></span>
						</div>
                      </div>
					  
					</div>  
                     
					 
					<div class="row">
					  
					  <div class="col-md-12 mb-3">
                       <b style="margin: 6px;">Remaining Amt :</b>&nbsp;&nbsp;<text id="pending_amt" style="margin: 15px;">
                      </div>
					  
                    					  
                      <input type="hidden" class="form-control " name="totals_amt" id="totals_amt">
					  <input type="hidden" class="form-control " id="totals_pend">
					  <input type="hidden" class="form-control " name="add_adv_payment" id="totals_adv">
					  <input type="hidden" class="form-control " name="cal_pending_amount" id="cal_pendingAmount">
					  
					  
                      <div class="col-md-12 mb-3">
                        <b style="margin: 6px;">Total Payment :</b>&nbsp;&nbsp;<text id="total_amount" style="margin: 23px;">
					  </div>
					  <div class="col-md-12 mb-3">
					  <b style="margin: 6px;">Paid in Advance :</b>&nbsp;&nbsp;<text id="total_advanced" style="margin: 14px;">
					  </div>
					  <div class="col-md-12 mb-3">
					  <b style="margin: 6px;">Pending Payment :</b>&nbsp;&nbsp;<text id="total_pending" style="margin: 3px;">
						
                      </div>
                      </div>
                 
					</div>
				 </form>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                  <button type="button" id="btnSaveaccept" class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
          </div>
        </div>
  </div> -->
 <!----accept payment modal end----->
 
 
 
 <!----accept payment modal start-----> 
    <!-- <div class="modal fade" id="modal_view_payment" role="dialog" style="z-index: 2222 !important;" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="so_add_edit">Payment History</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body form">
                    <div class="form-body form-row" >
					
					<div class="row ml-2">
						<div class="col-md-6">
							<div class="form-group">
								<label>Payment Mode:</label> 
								<span class="text-secondary font-weight-bold" id="accMode"></span>
							</div>
						</div>
					  <div class="col-md-6">
						<div class="form-group">
							<label>Cheque No./Reference No.</label> 
							<span class="text-secondary font-weight-bold" id="accReference"></span>
						</div>
                      </div>
					  <div class="col-md-6">
						<div class="form-group">
							<label for="">Paid Amount</label> 
							<span class="text-secondary font-weight-bold" id="accPAmount"></span>
						</div>
                      </div>
					  <div class="col-md-6">
						<div class="form-group">
							<label for="">Payment Date</label> 
							<span class="text-secondary font-weight-bold" id="accPayDt"></span>
						</div>
                      </div>
					  <div class="col-md-6">
						<div class="form-group">
							<label for="">Remarks</label> 
							<span class="text-secondary font-weight-bold" id="accRemarks"></span>
						</div>
                      </div>
					  <div class="col-md-6">
						<div class="form-group">
							<label for="">Added Date</label> 
							<span class="text-secondary font-weight-bold"id="accAddedDate"></span>
						</div>
                      </div>
					  
					</div>  
                     
					</div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                 
                </div>
            </div>
          </div>
        </div>
  </div> -->
 <!----accept payment modal end----->

<?php  
$stage=1.5;
$checks=1;
if(isset($bank_details_terms->account_no) && $bank_details_terms->account_no!=""){
	$stage=3;
	$checks=3;
}


?>

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




/*Declaration Enable and disabled code..*/

function enable_declaration(inv_id){ 
	if($("#slider_declaration").is(':checked')){
	    $(".bank-name").show();
	    var declaration_status = 1;	  
	}else{
		$(".bank-name").hide();
		var declaration_status = 0;
	}
	$.ajax({
            url : "<?php echo site_url('invoices/chnage_declaration_status')?>",
            type: "post",
			data:{inv_id:inv_id,declaration_status:declaration_status},
            dataType: "JSON",
            success: function(data)
            {
				if(data.st == 200){
					if($("#slider_declaration").is(':checked')){
					    toastr.success('Declaration status has been enabled successfully.');
					}else{
					    toastr.info('Declaration status has been disabled successfully.');
					}
				}else{
					toastr.error('Something went wrong, Please try later.');
				}
			}
	});	
}



/********Bank upi details*********/
function addBankupi(){      
	$('#addbankmodal').modal('show'); 
    $('.form-group').removeClass('has-error');
    $('.help-block').empty(); 
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
    stage: "<?=$stage?>",
    checks: "<?=$checks?>",
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



//****start accept payment section***//

	function viewPayment(id){
		$('#modal_view_payment').modal('show');
		  $.ajax({
            url : "<?php echo site_url('invoices/getpayment_byid/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
				$('#accMode').html(data.payment_mode);
				$('#accReference').html(data.reference_no);
				$('#accPAmount').html(data.adv_payment);
				$('#accPayDt').html(data.payment_date);
				$('#accRemarks').html(data.remarks);
				$('#accAddedDate').html(data.curentdate);
			}
		  });
	}

	function deletePayment(id){
		
		 $.ajax({
            url : "<?php echo site_url('invoices/deletePayment/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
				alert(data);
			}
		  });
	}

   function updateaccept(id){
        toastr.info('Please wait while we are processing your request');
        save_method = 'update';
        $('#payment_form')[0].reset(); // reset form on modals         
		$('#modal_form_accept').modal('show');
		$("#adv_payments").attr('readonly',false);
		$('#btnSaveaccept').attr('disabled',false); //set button enable
		$("#adv_payments").removeClass('cheques');
		$("#adv_payments").css('background-color','');
		$("#payment_mode_error").html('');
		$("#cheque_no_error").html('');
		$("#adv_payments_error").html('');
		
		$("#payment_mode").change(function()
        {
            var selected = $(this).find('option:selected');
            var extra = selected.data('msg'); 
            $("#cheque_no").attr('placeholder',extra);
            $("#textRef").html(extra);
            
        });
		
		  $.ajax({
            url : "<?php echo site_url('invoices/getpayment/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
				var pending_amount = data.sub_total-data.advanced_payment;
				
				if(pending_amount == 0){
					$("#adv_payments").attr('readonly',true);
					$("#adv_payments").addClass('cheques');
					$("#adv_payments").css('background-color','rgb(229 239 234)');
					$('#btnSaveaccept').attr('disabled',true);
				}
				
				$('#pending_amt').html(numberToIndPrice(pending_amount.toFixed(2)));
				$('#totals_pend').val(pending_amount);
				$('#totals_adv').val(data.advanced_payment);
				$('#totals_amt').val(data.sub_total);
				$('#total_amount').html(numberToIndPrice(data.sub_total));
				$('#total_advanced').html(numberToIndPrice(data.advanced_payment));
				$('#total_pending').html(numberToIndPrice(pending_amount.toFixed(2)));
				
			}
		  });
	}
	
	$("#adv_payments").keyup(function(){
		$('#btnSaveaccept').attr('disabled',false); //set button enable
		$("#adv_payments_error").text('');
		var adv_amount = $("#adv_payments").val().replace(/,/g, '');
		$("#adv_payments").val(numberToIndPrice(adv_amount));
		var adv_amount = $("#adv_payments").val().replace(/,/g, '');
		
		var total_amounts = $("#totals_amt").val();
		var statictotal_adv = $("#totals_adv").val();
		var cal_total_pendings = total_amounts-adv_amount-statictotal_adv;
	    var total_pendings = $("#totals_pend").val();
		
		
		if(parseFloat(adv_amount)>parseFloat(total_pendings))
		{   
			$("#adv_payments").val(numberToIndPrice(total_pendings));
			$("#adv_payments_error").html('<i class="fas fa-info-circle" style="color:red"></i>&nbsp;&nbsp;You can'+"'"+'t entere greater than remaining amount.');
			$('#cal_pendingAmount').val(total_pendings);
		    $('#pending_amt').html(numberToIndPrice(total_pendings.toFixed(2)));
		}else{
			$('#cal_pendingAmount').val(cal_total_pendings);
			$('#pending_amt').html(numberToIndPrice(cal_total_pendings.toFixed(2)));
		}
		
	});
	
	//check validation
function checkValidationfor_accept_payment(){
	var payment_mode = $('#payment_mode').val();
	var cheque_no    = $('#cheque_no').val();
	var adv_payments = $('#adv_payments').val();
    if(payment_mode=="" || payment_mode===undefined){
		changeClr('payment_mode');
		return false;
    }else if((cheque_no=="" || cheque_no===undefined) && (payment_mode=='cheque') ){
		changeClr('cheque_no');
		return false;
    }else if(adv_payments=="" || adv_payments===undefined){
		changeClr('adv_payments');
		return false;
    }else{
		return true;
    } 
}


	//Update Payment Mode	
$("#btnSaveaccept").click(function(e){
		e.preventDefault();
		$('#btnSaveaccept').text('Saving...'); //change button text
		$('#btnSaveaccept').attr('disabled',true); //set button disable
        var url = "<?=base_url('invoices/update_paymentMode')?>";
		
    if(checkValidationfor_accept_payment()==true){
         toastr.info('Please wait while we are processing your request');
      $.ajax({
        url : url,
        type: "POST",
        data: $('#payment_form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
          //console.log(data);  
          if(data.status){
            $('#modal_form_accept').modal('hide');
			toastr.success('Payment status has been updated successfully.');
			location.reload();
          }
          $('#btnSaveaccept').text('Save'); //change button text
          $('#btnSaveaccept').attr('disabled',false); //set button enable
          if(data.st==202){
            $("#payment_mode_error").html(data.payment_mode);
			$("#cheque_no_error").html(data.cheque_no);
			$("#adv_payments_error").html(data.adv_payments);
          }else{
            $("#payment_mode_error").html('');
			$("#cheque_no_error").html('');
			$("#adv_payments_error").html('');
          }
        }
      });
    }else{
          $('#btnSaveaccept').text('Save'); 
          $('#btnSaveaccept').attr('disabled',false);
    }
});


</script>