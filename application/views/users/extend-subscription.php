<?php $this->load->view('common_navbar');?>


  <div class="content-wrapper" style="min-height: 191px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Extend Your Plan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>home">Home</a></li>
              <li class="breadcrumb-item active">Extend Plan</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<?php
$merchant_order_id  = "ORDR-".date("YmdHis");
$description        = $merchant_order_id;
$txnid              = "TRAN".date("YmdHis"); 
$paymentid          = "TEAM|CRM".date("YmdHis");
/****live key id***/
//$key_id             = "rzp_live_ueohvN1q49h0Vj";
/*****test key id****/
$key_id           = "rzp_test_PGtHX7wCTGNzXM";
$currency_code      = 'INR'; 
?>

 <?php $accountType= $this->session->userdata('account_type'); ?>
    <section class="content">
      <div class="container-fluid">
            <div class="card org_div">
              <!-- /.card-header -->
              <div class="card-body">
    <?php
	$expirDate=$this->session->userdata('license_expiration_date');
	$licenseExpirationDate = date_create($expirDate);
    $current_date 	       = date_create(date('Y-m-d'));
    $diff 			       = date_diff($licenseExpirationDate,$current_date);
    $days 				   = $diff->format("%a");
    ?>		
			<input type="hidden" name="licenseExpirationDays" id="licenseExpirationDays" value="<?php echo $days; ?>" >
            <input type="hidden" name="ex_month_price" id="ex_month_price">
				<div class="row">
					<div class="col-md-12 ">
						<form action="<?php echo base_url('checkout'); ?>/plan" method="POST" >
						  <div class="row">
								<div class="col-md-12 text-center pb-3">
								<text style="font-weight: 700;">Selected Plan : </text>
								<text id="ptplane">Monthly</text>
								</div>
								<div class="col-md-12">
								<table class="table table-bordered"> 
									<tr> 
										<td>Plan Name</td>
										<td>Plan Price (Monthly)/User</td>
										<td>Plan Price (Annually)/User</td>
										<td>Total Licence</td>
										<td>Plane Expiration Date</td>
									</tr>
									<?php
									  $planidArr=array();
									  $rowSpn=(count($planlist)+2);
									  for($i=0; $i<count($planlist); $i++){
									?>
										<tr> 
											<td><?=$planlist[$i]['plan_name'];?></td>
											<td><?=IND_money_format($planlist[$i]['month_price']);?>
											<input type="hidden" value="<?=$planlist[$i]['month_price'];?>" name="monthPrice[]">
											</td>
											<td><?=IND_money_format($planlist[$i]['annual_price']);?>
											<input type="hidden" value="<?=$planlist[$i]['annual_price'];?>" name="yearPrice[]">
											</td>
											<td><?=$planlist[$i]['plan_licence'];?>
											<input type="hidden" value="<?=$planlist[$i]['plan_licence'];?>" name="licence[]">
											</td>
											<td><?=$expirDate;?></td>
										</tr>
									<?php $planidArr[]=$planlist[$i]['plan_id'];  } ?>
									
									<?php
									$totalPrice=0;
									for($i=0; $i<count($planlist); $i++){ ?>
									<tr> 
										<?php if($i==0){ ?>
										<td colspan="3" rowspan="<?=$rowSpn;?>" style="vertical-align: inherit;">
										<div class="col-md-12 text-center">
											<span>Monthly</span> 
											<label class="switch" for="billingSwitch"> <input type="checkbox" name="selectPlan" id="billingSwitch" value="1"> <span class="slider round"></span> </label>        <span>Annual</span>
										</div>
										</td>
										<?php } ?>
										<td style="background: #f2f4f4;"><?=$planlist[$i]['plan_name'];?></td>
										<td style="background: #f2f4f4;">
										<?php 
										$price=$planlist[$i]['month_price'];
										$annualPrice=$planlist[$i]['annual_price'];
										$licence=$planlist[$i]['plan_licence'];
										$total=$price*$licence;
										$annuaTotal=$annualPrice*$licence;
										
										$totalPrice=$totalPrice+$total;
										?>₹ 
										<text class="monthPr"><?=IND_money_format($total)?></text>
										<text class="monthAnn" style="display:none;"><?=IND_money_format($annuaTotal)?></text>
										</td>
									</tr>
									<?php } 
									
									$tax = ($totalPrice * 18/100);
									?>
									
									<tr style="background: #f2f4f4;"> 
										<td>GST 18%</td>
										<td>₹ <text id="gstid"><?=IND_money_format($tax);?></text></td>
									</tr>
									<tr style="background: #f2f4f4;"> 
										<td>Toatal Price</td>
										<td>₹ <text id="totalPrice"><?php echo IND_money_format(($totalPrice+$tax));?></text></td>
									</tr>
								</table>
								</div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-outline-dark">Extend Plan</button>
							</div>
							
						  </div>
						</form>
					  </div>
				
				</div>
				  
              </div>
            </div>
        </div>
      </section>
  </div>
 <?php $this->load->view('footer');?>
</div>
<style>
.bgclr{
	background: #066675;
}
</style>

<?php $this->load->view('common_footer');?>
<script>

$("#billingSwitch").change(function(){ 
	var Amount=0;
	$("input[name='licence[]']").each(function (index) {
		var quantity = $("input[name='licence[]']").eq(index).val();
		if($("#billingSwitch").prop('checked') == true){
			var price = $("input[name='yearPrice[]']").eq(index).val();
			$(".monthPr").hide();
			$(".monthAnn").show();
			$("#ptplane").html('Annually');
		}else{
			var price = $("input[name='monthPrice[]']").eq(index).val();
			$(".monthAnn").hide();
			$(".monthPr").show();
			$("#ptplane").html('Monthly');
		}
		var output = parseFloat(quantity) * parseFloat(price);
		if (!isNaN(output)){
			Amount=parseFloat(Amount)+parseFloat(output);	
		}
	});
	var tax = parseFloat(Amount) * 18/100;
	var grandToatl = parseFloat(Amount)+parseFloat(tax.toFixed(2));
	$("#gstid").html(numberToIndPrice(tax.toFixed(2)));
	$("#totalPrice").html(numberToIndPrice(grandToatl));
	
});
</script>

