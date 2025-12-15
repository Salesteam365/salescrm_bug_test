<?php $this->load->view('common_navbar');?>

<div class="content-wrapper" style="min-height: 191px;">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Renewal Subscription</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()."home"; ?>">Home</a></li>
              <li class="breadcrumb-item active">Subscription</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
<?php
$merchant_order_id  = "ORDR-".date("YmdHis");
$description        = $merchant_order_id;
$txnid              = "TRAN".date("YmdHis"); 
$paymentid          = "TEAM|CRM".date("YmdHis");
/****live key id***/
$key_id             = "rzp_live_ueohvN1q49h0Vj";
/*****test key id****/
//$key_id           = "rzp_test_PGtHX7wCTGNzXM";
$currency_code      = 'INR';

//print_r($planlist);
$expirDate	= $this->session->userdata('license_expiration_date');
$accountType= $this->session->userdata('account_type');
$licenseExpirationDate = date_create($expirDate);
$current_date 	       = date_create(date('Y-m-d'));
$diff 			       = date_diff($licenseExpirationDate,$current_date);

if($input['selectPlan']==1){
	$planName='Annually';
}else{
	$planName='Monthly';
}

if($accountType=='Paid'){
	$totalPrice=0;
	$totalLice=0;
	$planId=array();
	$plan_Name=array();
	for($i=0; $i<count($planlist); $i++){
		if($input['selectPlan']==1){
			$price=$planlist[$i]['annual_price'];
		}else{
			$price=$planlist[$i]['month_price'];
		}
		$planId[]	= $planlist[$i]['plan_id'];
		$plan_Name[]	= $planlist[$i]['plan_name'];
		
		$licence=$planlist[$i]['plan_licence'];
		$total=$price*$licence;
		$totalPrice=$totalPrice+$total;
		
		$totalLice=$totalLice+$planlist[$i]['plan_licence'];
	}
	$GstTotalPrice=$totalPrice*18; 
	$GstTotalPrice=$GstTotalPrice/100;
	$finalAmountTopay=round($GstTotalPrice+$totalPrice,2);
	$merchant_total=($finalAmountTopay*100);
	
	$plan_NameL=implode(",",$plan_Name);
}

if($input['selectPlan']==1){
	$date2 	 = strtotime($expirDate);
	$newdate = date('d-M-Y',strtotime("+1 year",$date2));
}else{
	$date2 	 = strtotime($expirDate);
	$newdate = date('d-M-Y',strtotime("+1 month",$date2));
}

$dateFuture=date_create($newdate);
$dateFuturetil= date_format($dateFuture,"Y-m-d");

?>
   <section class="content">
      <div class="container-fluid">
            <div class="card org_div">
              <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#home">
                        Buy plan for  <?php echo $planName;?>
                      </a>
                    </li>
                  </ul>

                    <!-- Tab panes -->
                  <div class="tab-content" style="width:90%; margin: 0 auto;">
                    <form class="horizontal-form py-2" id="contact-form" action="<?php echo base_url('checkout/callback_rozarpay'); ?>" method="POST" >
    <input type="hidden"  name="razorpay_payment_id" id="razorpay_payment_id" value="<?= $paymentid; ?>" />
	<input type="hidden"  name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
	<input type="hidden"  name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
	<input type="hidden"  name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $description; ?>"/>
	<input type="hidden"  name="product_id" id="product_id" value="<?=implode(",",$planId);?>"/>
	<input type="hidden"  name="merchant_total" id="merchant_total" value="<?php echo $merchant_total; ?>"/> 
	<input type="hidden"  name="merchant_amount" id="merchant_amount" value="<?=$finalAmountTopay;?>"/>
	<input type="hidden"  name="gstPrice" id="gstPrice" value="18"/>
	 <input type="hidden"  name="total_price" id="total_price" value="<?=$finalAmountTopay;?>"/>
    <input type="hidden"  name="total_incgst" id="total_incgst" value="<?=$GstTotalPrice;?>"/>
    <input type="hidden"  name="comp_user_name" id="comp_user_name"/>
    <input type="hidden"  name="till_date" id="till_date" value="<?=$dateFuturetil?>" />
    <div class="checkout_page"> 
     <input type="hidden"  name="CrmTime" id="CrmTime" value="<?=$planName;?>"  />
     <input type="hidden"  name="unit_price" id="unit_price" value="<?=$finalAmountTopay;?>"  />
     <input type="hidden"  name="licenceQty" id="licenceQty" value="<?=$totalLice;?>"  />
     <input type="hidden"  name="slectTab" id="slectTab" value="extend_plan"  />
     <input type="hidden"  name="exi_product_id" id="exi_product_id" value="Planid"  />
     
    <div class="checkout_page"> 
                    <div id="home" class="container-fluid tab-pane active"><br>
                      <section class="content staff-profile">
                        <div class="container-fluid">
                          <div class="card org_div">
                            <div class="card-body lower">
                              <div id="home" class="tab-pane active">
                                <div class="monthly_value">
                                  <div class="row">
                                      
                                    <input type="hidden" name="crmusername" id="crmusername" value="<?=$this->session->userdata('email'); ?>">
                                    <input type="hidden" name="compname" id="compname" value="<?=$this->session->userdata('session_company'); ?>" >
                                    <input type="hidden" name="commobile" id="commobile" value="<?=$this->session->userdata('mobile'); ?>" >
                                    <div class="col">
                                        
                                      <h4>Selected Plan</h4>
									  ( <span><?=$plan_NameL;?> </span> )
									  <br>
                                      <span>For <?=$planName;?></span>
                                      
                                    </div>
                                    <div class="col text-right">
                                        <h4><b>₹ <?=IND_money_format($finalAmountTopay);?></b></h4><span>From 
                                            <?php 
                                            $date=date_create($expirDate);
                                            echo date_format($date,"d M Y");
                                            ?> <b>to</b>  
                                            <?php 
											if($input['selectPlan']==1){
												$date2 	 = strtotime($expirDate);
												$newdate = date('d-M-Y',strtotime("+1 year",$date2));
											}else{
												$date2 	 = strtotime($expirDate);
												$newdate = date('d-M-Y',strtotime("+1 month",$date2));
											}
											    
											echo $newdate;
											/*$futureDate=date($expirDate, strtotime('+1 year'));
											
                                            $dateFuture=date_create($futureDate);
                                            echo date_format($dateFuture,"d M Y");*/
                                            ?></span>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col">
                                      <h4 style="display: inline-block;">GST Charge</h4>
                                    </div>
                                  
                                    <div class="col text-right">
                    
                                        <h4><b>₹ <?=IND_money_format(round($GstTotalPrice, 2));?></b></h4><span>18 % gst charge on total amount</span>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col">
                                      <h4>Total</h4>
                                      <p><b>Till the renewal date</b></p>
                                    </div>
                                    <div class="col text-right">
                                        <?php $totalAmount=($finalAmountTopay); ?>
                                        <h4><b>₹ <?=IND_money_format(round($totalAmount,2));?></b></h4><span>Inclusive of All Taxes</span>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col">
                                      <button style="width: 100%;padding: 10px;border: 0;background: #284255;color: #fff;    font-weight: 500;" type="button" id="pay-btn" onclick="razorpaySubmit(this);" >Make Payment</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>
                    </div>
                    </form>
                  </div>
              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    
  </div>
  
 <?php $this->load->view('footer');?>


<?php $this->load->view('common_footer');?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

var razorpay_pay_btn, instance;
        function razorpaySubmit(el) {
			//if(checkVal()==true){
			var options = {
            key:            "<?php echo $key_id; ?>",
            amount:         $("#merchant_total").val(),
            description:    "Order # <?php echo $description; ?>",
            netbanking:     true,
            currency:       "<?php echo $currency_code; ?>", // INR
            prefill: {
                name:       $("#compname").val(),
                email:      $("#crmusername").val(),
                contact:    $("#commobile").val(),
            },
            notes: {
                soolegal_order_id: "<?php echo $merchant_order_id; ?>",
            },
            handler: function (transaction) {
                document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
                document.getElementById('contact-form').submit();
            },
            "modal": {
                "ondismiss": function(){
                    location.reload()
                }
            }
        };
        
				
            if(typeof Razorpay == 'undefined') {
                setTimeout(razorpaySubmit, 200000);
                if(!razorpay_pay_btn && el) {
                    razorpay_pay_btn    = el;
                    el.disabled         = true;
                    el.value            = 'Please wait...';  
                }
            } else {
                if(!instance) {
                    instance = new Razorpay(options);
                    if(razorpay_pay_btn) {
                    razorpay_pay_btn.disabled   = false;
                    razorpay_pay_btn.value      = "Pay Now";
                    }
                }
                instance.open();
            }
			
		//	}
		
        }


</script>

