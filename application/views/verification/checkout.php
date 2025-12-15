<?php $this->load->view('common_navbar');?>

<div class="content-wrapper" style="min-height: 191px;">
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Customize Your Desktop Subscription</h1>
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
$expirDate=$this->session->userdata('license_expiration_date');
$accountType= $this->session->userdata('account_type');
$licenseExpirationDate = date_create($expirDate);
$current_date 	       = date_create(date('Y-m-d'));
$diff 			       = date_diff($licenseExpirationDate,$current_date);
if($accountType=='Paid'){
$days 				   = $diff->format("%a"); 
}else{
    $days = $input['plan_type'];
    if($days=='Monthly'){
        $licence_exp = date('Y-m-d',strtotime("+1 month"));
        $expirDate = $licence_exp;
    }else{
        $licence_exp = date('Y-m-d',strtotime("+1 Year"));
        $expirDate = $licence_exp;
    }
}

$checkPrice='Not Matched';

if($input['slectTab']=='add_licence_in_existing_plan'){
    $planId=$input['plan_id'];
    $exiPlanPrice= $input['plan_id'];
    $totalDaysRe = $days;
    $month_price = $newplanlist[0]['month_price'];
    $user_qty    = $input['add_extra_lic'];
    $totalLice=$user_qty;
    $perDayValue = round($month_price/30, 2);
    $allUserPriceDay    = $perDayValue*$user_qty;
    $totalPriceValue=$totalDaysRe*$allUserPriceDay;
    if($input['payable_amount']==round($totalPriceValue, 2) ){
        $checkPrice='Matched';
    }

}else if($input['slectTab']=='change_existing_plan'){
    $planId      =$input['plan_id_into'];
    $exiPlanPrice= $input['plan_id'];
    $totalDaysRe = $days;
    $month_price = $planlistChangeInto[0]['month_price'];
    $user_qty    = $input['add_extra_lic'];
    $chplExistLic= $input['exist_licence'];
    $paidPrice   = $planlist['plan_price'];
    $perUserPaidPrice= $paidPrice/$chplExistLic;
    $perDayPaidPrice = $paidPrice/365;
    $totalUsedDay    = 365-$totalDaysRe;
    $TotalusedPrice  = $perDayPaidPrice*$totalUsedDay;
    $perDayValue     = round($month_price/30, 2);
    $totalUser       = $user_qty + $chplExistLic;
    $totalLice       = $totalUser;
    $allUserPriceDay = $perDayValue * $totalUser;
    $totalPriceValue = $totalDaysRe * $allUserPriceDay;
    $totalPayAblePrice = round($totalPriceValue-$TotalusedPrice, 2);
    if($input['payable_amount']==$totalPayAblePrice ){
        $checkPrice='Matched';
    }
}else if($input['slectTab']=='buy_new_plan'){
    
    if($accountType=='Paid'){
    $planId=$input['plan_id'];
    $exiPlanPrice= $input['plan_id'];
    $totalDaysRe = $days;
    $month_price = $newplanlist[0]['month_price'];
    $user_qty    = $input['add_extra_lic'];
    $totalLice   = $user_qty;
    $perDayValue = round($month_price/30, 2);
    $allUserPriceDay    = $perDayValue * $user_qty;
    $totalPriceValue=round($totalDaysRe * $allUserPriceDay,2);
    }else{
    $planId=$input['plan_id'];
    $exiPlanPrice= $input['plan_id'];
    $month_price = $newplanlist[0]['month_price'];
    $annua_price = $newplanlist[0]['annual_price'];
    $user_qty    = $input['add_extra_lic'];
    $totalLice   = $user_qty;
    if($days=='Monthly'){
        $totalPriceValue=$user_qty*$month_price;
    }else{
        $totalPriceValue=$user_qty*$annua_price;
    }
    
    }
    
    if($input['payable_amount']!=$totalPriceValue ){
        $checkPrice='Matched';
    }
   
}

$payableAmount=str_replace(',','',$input['payable_amount']);
$GstTotalPrice=$payableAmount*18; 
$GstTotalPrice=$GstTotalPrice/100;
$finalAmountTopay=round($GstTotalPrice+$input['payable_amount'],2);

$merchant_total=($finalAmountTopay*100);
?>
   <section class="content">
      <div class="container-fluid">
            <div class="card org_div">
              <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#home">
                      <?php if($accountType=='Paid'){ ?> 
                      Till renewal date. Your renewal Date is <?=$expirDate;?> & total remaining days are <?=$days;?>
                      <?php }else{ ?>
                        Buy plan for  <?php echo $input['plan_type'];?>
                      <?php } ?>
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
	<input type="hidden"  name="product_id" id="product_id" value="<?=$planId;?>"/>
	<input type="hidden"  name="merchant_total" id="merchant_total" value="<?php echo $merchant_total; ?>"/> 
	<input type="hidden"  name="merchant_amount" id="merchant_amount" value="<?=$finalAmountTopay;?>"/>
	<input type="hidden"  name="gstPrice" id="gstPrice" value="18"/>
	 <input type="hidden"  name="total_price" id="total_price" value="<?=$input['payable_amount'];?>"/>
    <input type="hidden"  name="total_incgst" id="total_incgst" value="<?=$GstTotalPrice;?>"/>
    <input type="hidden"  name="comp_user_name" id="comp_user_name"/>
    <div class="checkout_page"> 
     <input type="hidden"  name="CrmTime" id="CrmTime" value="<?=$days;?>"  />
     <input type="hidden"  name="unit_price" id="unit_price" value="<?=$month_price;?>"  />
     <input type="hidden"  name="licenceQty" id="licenceQty" value="<?=$totalLice;?>"  />
     <input type="hidden"  name="slectTab" id="slectTab" value="<?=$input['slectTab'];?>"  />
     <input type="hidden"  name="exi_product_id" id="exi_product_id" value="<?=$exiPlanPrice;?>"  />
     
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
                                        <?php
                                        if($input['slectTab']=='add_licence_in_existing_plan'){
                                        ?>
                                      <h4>Add More Licence in your <?=$planlist['plan_name'];?></h4>
                                      <span>For <?=$input['add_extra_lic'];?>  Licence</span>
                                      <?php }else if($input['slectTab']=='change_existing_plan'){ ?>
                                      <h4><?=$planlist['plan_name'];?> Chnage into  <?=$planlistChangeInto[0]['plan_name'];?></h4>
                                      <span>For <?=$totalUser;?>  Licence</span>
                                      <?php }else if($input['slectTab']=='buy_new_plan'){ ?>
                                        <h4><?=$planlistChangeInto[0]['plan_name'];?> </h4>
                                      <span>For <?=$input['add_extra_lic'];?>  Licence</span>
                                      <?php } ?>
                                    </div>
                                    <div class="col text-right">
                                        <h4><b>₹ <?=IND_money_format($input['payable_amount']);?></b></h4><span>From 
                                            <?php 
                                            $date=date_create(date('d-M-Y'));
                                            echo date_format($date,"d M Y");
                                            ?> to  
                                            <?php 
                                            $date=date_create($expirDate);
                                            echo date_format($date,"d M Y");
                                            ?></span>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col">
                                      <h4 style="display: inline-block;">GST Charge</h4>
                                    </div>
                                  
                                    <div class="col text-right">
                     <?php  
                     $payableAmount=str_replace(',','',$input['payable_amount']);
                     $GstTotalPrice=$payableAmount*18; 
                            $GstTotalPrice=$GstTotalPrice/100;
                     ?>
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
                                        <?php $totalAmount=($payableAmount+$GstTotalPrice);
                                        
                                        ?>
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

