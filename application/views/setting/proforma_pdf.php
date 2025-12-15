 <html>
      <head>
        <title>Team365 | Quotation</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
  
   <link rel="shortcut icon" type="image/png" href="<?= base_url();?>assets/images/favicon.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>css/team.min.css">
  <!-- navbar css -->
  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="<?php echo STYLE_CSS; ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo RESPONSIVE_CSS; ?>">
 


  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Baloo+2:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
  <!-- datatable -->


  <style type="text/css">
    .active_nav { color: red; }
  </style>
<style>
    .content-header {background: #f2f2f2;}
</style>
 </head>
<body>
<div class="content-wrapper">
    <div class="invoice-type">
        <div class="container">
            <h1>Proforma Invoice</h1><span>Part Paid</span>
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
                        <div class="billed-by">
                            <h3>Billed By</h3>
                            <b><?=$branch['company_name'];?></b>
                            <p><?=$branch['address'];?></p>
                            <p><?=$branch['city'];?></p>
                            <p><?=$branch['state'];?>-<?=$branch['zipcode'];?>, <?=$branch['country'];?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="billed-to billed-by">
                            <h3>Billed To</h3>
                            <b><?=$record['billedto_orgname'];?></b>
                            <p><?=$clientDtl['city'];?>, <?=$clientDtl['country'];?></p>
                            <p><b>Email:</b> <?=$clientDtl['email'];?></p>
                            <p><b>Phone:</b> +91-<?=$clientDtl['mobile'];?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="invoice-table mt-3 text-center">
                <div class="row">
                    <div class="col">
                        <p><b>Country of Supply :</b> <?=$branch['country'];?></p>
                    </div>
                    <div class="col">
                        <p><b>Place of Supply :</b> <?=$branch['city'];?> (<?=$branch['zipcode'];?>)</p>
                    </div>
                </div>
                <table class="table table-responsive-lg">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>GST</th>
                            <th>Quantity</th>
                            <th>Rate</th>
							<th>Amount</th>
							<?php if($record['igst']!=""){?>
                            <th>IGST</th>
							<?php } if($record['cgst']!=""){ ?>
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
							<?php $totaliGst=$totaliGst+$igst[$rw]; } 
							if($cgst[$rw]!=""){  ?>
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
							<?php if($record['sgst']!=""){?>
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
							<?php } if($record['igst']!=""){ ?>
							<div class="row">
                                <div class="col">
                                    IGST
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($totaliGst); ?>
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
                    <li><?=$terms_condition[$in];?></li>
					<?php } } ?>
                </ol>
            </div>
			
        </div>
    </div>
   
</div>
</body>
</html>



