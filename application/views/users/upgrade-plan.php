<?php $this->load->view('common_navbar');?>


  <div class="content-wrapper" style="min-height: 191px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Upgrade Your Plan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>home">Home</a></li>
              <li class="breadcrumb-item active">Upgrade Plan</li>
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

 <?php $accountType= $this->session->userdata('account_type');
						 
						  ?>
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
				    <?php  if($accountType=='Paid'){ ?>
                  <div class="col-md-4  shadow-lg p-3 mb-5 bg-white rounded">
					<div class="row">
					  <form action="<?php echo base_url('checkout'); ?>" method="POST" >
					      <input type="hidden"  name="slectTab" value="add_licence_in_existing_plan">
					      <input type="hidden" name="remainingDays" id="remainingDays" value="<?php echo $days; ?>" >
						<div class="col-md-12 text-center">
							<button type="button" class="btn btn-outline-dark">Add Licence in Existing Plan</button>
						</div>
						<div class="col-md-12 mt-4 text-center">
							₹&nbsp;<span id="ex_month_price_lbl"></span>/-&nbsp;&nbsp;<span class="text-danger">Per Month Per User/Licence</span>
							
						</div>
						<div class="col-md-12">
						  <label class="">Your Plan<span class="text-danger">*</span></label>
						  
						  <select  class="form-control" name="Ex_plan_id" id="Ex_plan_id">
						  <?php
						  $planidArr=array();
						  for($i=0; $i<count($planlist); $i++){  ?>
						  <option value="<?=$planlist[$i]['plan_id'];?>"><?=$planlist[$i]['plan_name'];?></option>
						  <?php $planidArr[]=$planlist[$i]['plan_id']; } ?>
						  
							</select>
						</div>
						<div class="col-md-12">
						  <label class="">Exist Licence<span class="text-danger">*</span></label>
							<input type="text" class="form-control numeric" placeholder="Total Exist Licence" name="exist_lic" id="exist_lic" readonly>
						</div>
						<div class="col-md-12">
						  <label class="">Used Licence<span class="text-danger">*</span></label>
							<input type="text" class="form-control numeric" placeholder="Total Used Licence" name="ex_used_lic" id="ex_used_lic" readonly>
						</div>
						
						<div class="col-md-12">
						  <label class="">Add More Licence<span class="text-danger">*</span></label>
							<input type="text" class="form-control numeric" placeholder="Enter No. of Licence" name="ex_add_more" id="ex_add_more" value="0">
						</div>
						
						<div class="col-md-12">
						  <label class="">Total Amount till Expiration Date<span class="text-danger">*</span></label>
						    <div class="input-group">
						    <div class="input-group-prepend">
                              <div class="input-group-text">₹</div>
                            </div>
							<input type="text" class="form-control onlyNumbers" placeholder="Enter Name" name="ex_amount_exp_date" id="ex_amount_exp_date" readonly >
							</div>
						</div>
						<div class="col-md-12 mt-2" id="CalculationFormula">
						    <b>Note:-</b>
						    Calculation Formula-<br>
						    PerDayPrice = MonthPrice / 30;<br>
						    TotalPerDayPrice = LicenceQty * PerDayPrice <br>
						   FinalAmount = TotalPerDayPrice * TotalRemainingDay of expirationDate
						</div>
						
						<div class="col-md-12 mt-2 text-center">
						   <button class="btn btn-info" id="add_more_licence">Buy Now</button>
						</div>
						</form>
					</div>
				  </div>
				  
				  
				  <!--####--Change Your Plan into another paln--#####-->
				  
				  <div class="col-md-4  shadow-lg p-3 mb-5 bg-white rounded">
					<div class="row">
					   <form  action="<?php echo base_url('checkout'); ?>" method="POST" >
					       <input type="hidden"  name="slectTab" value="change_existing_plan">
					       <input type="hidden" name="remainingDays" id="remainingDays" value="<?php echo $days; ?>" >
						<div class="col-md-12 text-center">
							<button type="button" class="btn btn-outline-dark">Change Your Plan</button>
						</div>
						
                        <input type="hidden" name="chpl_month_price" id="chpl_month_price">
						
						<input type="hidden" name="chpl_paid_price" id="chpl_paid_price">
						
						<div class="col-md-12 mt-4 text-center">
							₹&nbsp;<span id="chpl_month_price_lbl"></span>
						</div>
						 <div class="col-md-12 mt-1">
						  <label class="">Your Plan<span class="text-danger">*</span></label>
						  
						  <select  class="form-control" name="chpl_plan_id" id="chpl_plan_id">
						  <?php
						  for($i=0; $i<count($planlist); $i++){  ?>
						  <option value="<?=$planlist[$i]['plan_id'];?>"><?=$planlist[$i]['plan_name'];?></option>
						  <?php  } ?>
						  
							</select>
						</div>
						
						<div class="col-md-12 mt-2">
						  <label class="">Select Your Plan into convert<span class="text-danger">*</span></label>
					
						  <select  class="form-control" name="chpl_into_plan_id" id="chpl_into_plan_id">
						      <option value="0">Select Plan</option>
						  <?php 
						  for($i=0; $i<count($allplanlist); $i++){ 
						  if(!in_array($allplanlist[$i]['id'],$planidArr)){
						  ?>
						  <option value="<?=$allplanlist[$i]['id'];?>"><?=$allplanlist[$i]['plan_name'];?></option>
						  <?php } } ?>
							</select>
						</div>
						<div class="col-md-12 mt-2">
						  <label class="">Exist Licence<span class="text-danger">*</span></label>
							<input type="text" class="form-control" placeholder="Enter Name" name="chpl_exist_lic" id="chpl_exist_lic" readonly>
						</div>
						<div class="col-md-12 mt-2">
						  <label class="">Add More Licence<span class="text-danger">*</span></label>
							<input type="text" class="form-control numeric" placeholder="Add more Licence" name="chpl_add_more" id="chpl_add_more" value="0">
						</div>
						
						<div class="col-md-12 mt-2">
						  <label class="">Total Amount till Expiration Date<span class="text-danger">*</span></label>
						    <div class="input-group">
						    <div class="input-group-prepend">
                              <div class="input-group-text">₹</div>
                            </div>
							<input type="text" class="form-control onlyNumbers" placeholder="Enter Name" name="chpl_amount_exp_date" id="chpl_amount_exp_date" readonly >
							</div>
						</div>
						<div class="col-md-12 mt-2" id="CalculationFormula">
						    <b>Note:-</b>Total Amount = Licence Qty * Monthly Price <br>
						   Final Amount = Total Price Ramaining Month * Total Amount
						</div>
						<div class="col-md-12 mt-2 text-center">
						   <button class="btn btn-info" id="chnage_plan_btn">Buy Now</button>
						</div>
						</form>
					</div>
				  </div>
				  <?php } ?>
				  <!--##########--Buy New Plan--###########-->
				  <?php  if($accountType=='Trial'){ ?>
				  <div class="col-md-4"></div>
				  <?php } ?>
				  <div class="col-md-4  shadow-lg p-3 mb-5 bg-white rounded">
					<div class="row">
					  <form action="<?php echo base_url('checkout'); ?>" method="POST" >
					      <input type="hidden"  name="slectTab" value="buy_new_plan">
					       <input type="hidden" name="remainingDays" id="remainingDays" value="<?php echo $days; ?>" >
						<div class="col-md-12 text-center">
							<button type="button" class="btn btn-outline-dark">Buy New Plan</button>
						</div>
                    <input type="hidden" name="buyn_month_price" id="buyn_month_price">
                    <input type="hidden" name="buyn_annual_price" id="buyn_annual_price">
                     <input type="hidden" name="accountTypeAdmin" id="accountTypeAdmin" value="<?=$accountType;?>">
                        <div class="col-md-12 mt-4 text-center">
							₹&nbsp;<span id="buyn_month_price_lbl">0.00</span>
						</div>
                    
						 <div class="col-md-12 mt-1">
						  <label class="">Select Your Plan<span class="text-danger">*</span></label>
						 
						  <select  class="form-control" name="buyn_plan_id" id="buyn_plan_id">
						      <option value="0">Select Plan</option>
						  <?php 
						   if($accountType=='Trial'){
						  for($i=0; $i<count($allplanlist); $i++){ 
						  ?>
						  <option value="<?=$allplanlist[$i]['id'];?>"><?=$allplanlist[$i]['plan_name'];?></option>
						  <?php }  }else{ 
						  for($i=0; $i<count($allplanlist); $i++){ 
						  if(!in_array($allplanlist[$i]['id'],$planidArr)){
						  ?>
						  <option value="<?=$allplanlist[$i]['id'];?>"><?=$allplanlist[$i]['plan_name'];?></option>
						  <?php } } }?>
							</select>
						</div>
						<div class="col-md-12 mt-3">
						  <label class="">Name<span class="text-danger">*</span></label>
						  <select  class="form-control" name="buyn_lic_type" id="buyn_lic_type">
						  <option value="0">Select Plan Type</option>
						  <option value="Monthly" <?php  if($accountType!='Trial'){ ?> selected <?php } ?>>Monthly</option>
						  <?php  if($accountType=='Trial'){ ?>
						  <option value="Annually">Annually</option>
						  <?php } ?>
							</select>
						</div>
						
						<div class="col-md-12 mt-3">
						  <label class="">Add More Licence<span class="text-danger">*</span></label>
							<input type="text" class="form-control numeric" placeholder="Add more licence" name="buyn_add_more" id="buyn_add_more" value="0">
						</div>
						
						<div class="col-md-12 mt-3">
						  <label class="">Total Amount till Expiration Date<span class="text-danger">*</span></label>
						    <div class="input-group">
						    <div class="input-group-prepend">
                              <div class="input-group-text">₹</div>
                            </div>
							<input type="text" class="form-control onlyNumbers" placeholder="Enter Name" name="buyn_amount_exp_date" id="buyn_amount_exp_date" readonly >
							</div>
						</div>
						<div class="col-md-12  mt-3" id="CalculationFormula">
						    <b>Note:-</b>Total Amount = Licence Qty * Monthly Price <br>
						   Final Amount = Total Price Ramaining Month * Total Amount
						</div>
						<div class="col-md-12 mt-2 text-center">
						   <button class="btn btn-info" id="buy_new_plan_btn">Buy Now</button>
						</div>
                     </form>
                    </div>
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

$("#add_more_licence").click(function(){
    var ex_add_more=$("#ex_add_more").val();
    if(ex_add_more==0 || ex_add_more==""){
        $("#ex_add_more").addClass('is-invalid');
        return false;
    }else{
        return true;
    }
});
$("#chnage_plan_btn").click(function(){
    var ex_add_more=$("#chpl_into_plan_id").val();
    if(ex_add_more==0 || ex_add_more=="" || ex_add_more===undefined){
        $("#chpl_into_plan_id").addClass('is-invalid');
        return false;
    }else{
        return true;
    }
});

$("#buy_new_plan_btn").click(function(){
    var ex_add_more=$("#buyn_plan_id").val();
    var buyn_add_more=$("#buyn_add_more").val();
    var buyn_lic_type=$("#buyn_lic_type").val();
    
    if(ex_add_more==0 || ex_add_more=="" || ex_add_more===undefined){
        $("#buyn_plan_id").addClass('is-invalid');
        return false;
    }else if(buyn_lic_type==0 || buyn_lic_type=="" || buyn_lic_type===undefined){
        $("#buyn_lic_type").addClass('is-invalid');
        return false;
    }else if(buyn_add_more==0 || buyn_add_more=="" || buyn_add_more===undefined){
        $("#buyn_add_more").addClass('is-invalid');
        return false;
    }else{
        return true;
    }
});


$(".form-control").keyup(function(){
    $(this).removeClass('is-invalid');
});
$(".form-control").change(function(){
    $(this).removeClass('is-invalid');
});


// Add More Licence.....

$("#chpl_add_more").keyup(function(){
   CalculatePriceChpl();
});
function CalculatePriceChpl(){
    var totalDaysRe = $("#licenseExpirationDays").val();
    var month_price = $("#chpl_month_price").val();
    var user_qty    = $("#chpl_add_more").val();
    var chplExistLic= $("#chpl_exist_lic").val();
    var paidPrice   = $("#chpl_paid_price").val();
    
    var perUserPaidPrice= (parseFloat(paidPrice)/parseFloat(chplExistLic));
    
    var perDayPaidPrice = (parseFloat(paidPrice)/365);
    var totalUsedDay    = 365-parseFloat(totalDaysRe);
   
    var TotalusedPrice  = parseFloat(perDayPaidPrice)*parseFloat(totalUsedDay);
    
    var perDayValue = (parseFloat(month_price)/30);
    perDayValue     = perDayValue.toFixed(2);
    
    var totalUser=parseInt(user_qty) + parseFloat(chplExistLic);
    var allUserPriceDay= parseFloat(perDayValue) * parseFloat(totalUser);
    var totalPriceValue=parseFloat(totalDaysRe) * parseFloat(allUserPriceDay);
    
    var totalPayAblePrice=parseFloat(totalPriceValue)-parseFloat(TotalusedPrice);
    
    $("#chpl_amount_exp_date").val(numberToIndPrice(totalPayAblePrice.toFixed(2)));

}
function getLicenceChpl(){
    var id = $("#chpl_plan_id").val();
 $.ajax({
        url : "<?php echo site_url('upgrade_plan/getLicence/')?>",
        method:"post",
        type: "GET",
        data:{id:id},
        dataType: "JSON",
        success: function(data)
        { 
          $("#chpl_exist_lic").val(data.plan_licence);
          $("#chpl_used_lic").val(data.used_licence);
          //$("#chpl_month_price").val(data.month_price);
          $("#chpl_month_price_lbl").html(data.plan_price+"/-&nbsp;&nbsp;<span class='text-danger'>Paid By You "+data.licence_type+" For "+data.plan_licence+" Licence</span>");
          $("#chpl_paid_price").val(data.plan_price);
          
            //CalculatePriceChpl(); 
        }
 });
}

function getLicenceChplInto(){
    var id = $("#chpl_into_plan_id").val();
 $.ajax({
        url : "<?php echo site_url('upgrade_plan/getLicenceBuy/')?>",
        method:"post",
        type: "GET",
        data:{id:id},
        dataType: "JSON",
        success: function(data)
        { 
          $("#chpl_month_price").val(data[0].month_price);
            CalculatePriceChpl(); 
        }
 });
}

getLicenceChpl();
$("#chpl_plan_id").change(function(){
    var id = $("#chpl_plan_id").val();
    $.ajax({
        url : "<?php echo site_url('upgrade_plan/getLicenceOption/')?>",
        method:"post",
        type: "GET",
        data:{id:id},
        success: function(data)
        { 
            $("#chpl_into_plan_id").html(data);
        }
    });
    getLicenceChpl();
});

$("#chpl_into_plan_id").change(function(){
    getLicenceChplInto();
});



/*######## BUY NEW PLAN #########*/

$("#buyn_add_more").keyup(function(){
   CalculatePricebuyn();
});
$("#buyn_lic_type").change(function(){
    var buyn_lic_type=$("#buyn_lic_type").val();
    if(buyn_lic_type=='Monthly'){
        var month_price= $("#buyn_month_price").val();
    $("#buyn_month_price_lbl").html(month_price+'/-&nbsp;&nbsp;<span class="text-danger">Per Month Per User/Licence</span>');
    }else if(buyn_lic_type=='Annually'){
       var annualPrice=$("#buyn_annual_price").val();
    $("#buyn_month_price_lbl").html(annualPrice+'/-&nbsp;&nbsp;<span class="text-danger">Per Annual Per User/Licence</span>'); 
    }     
   CalculatePricebuyn();
});


function CalculatePricebuyn(){
    var totalPriceValue=0;
    var accountTypeAdmin = $("#accountTypeAdmin").val();
    if(accountTypeAdmin=='Paid'){
        var totalDaysRe = $("#licenseExpirationDays").val();
        var user_qty    = $("#buyn_add_more").val();
        var month_price = $("#buyn_month_price").val();
        var perDayValue = (parseFloat(month_price)/30);
        perDayValue     = perDayValue.toFixed(2);
        var allUserPriceDay    = parseFloat(perDayValue) * parseFloat(user_qty);
        var totalPriceValue=parseFloat(totalDaysRe) * parseFloat(allUserPriceDay);
    }else{
        var user_qty    = $("#buyn_add_more").val();
        var buyn_lic_type=$("#buyn_lic_type").val();
        if(buyn_lic_type=='Monthly'){
            var month_price = $("#buyn_month_price").val();
            var allUserPriceDay    = parseFloat(month_price) * parseFloat(user_qty);
            var totalPriceValue=allUserPriceDay;
        }else if(buyn_lic_type=='Annually'){
            var annualPrice=$("#buyn_annual_price").val();
            var perDayValue = annualPrice;
            var allUserPriceDay    = parseFloat(perDayValue) * parseFloat(user_qty);
            var totalPriceValue=allUserPriceDay;
        }
    }
    
    $("#buyn_amount_exp_date").val(numberToIndPrice(totalPriceValue));
 
}
function getLicencebuyn(){
    var id = $("#buyn_plan_id").val();
 $.ajax({
        url : "<?php echo site_url('upgrade_plan/getLicenceBuy/')?>",
        method:"post",
        type: "GET",
        data:{id:id},
        dataType: "JSON",
        success: function(data)
        { 
          $("#buyn_month_price").val(data[0].month_price);
          $("#buyn_month_price_lbl").html(data[0].month_price+'/-&nbsp;&nbsp;<span class="text-danger">Per Month Per User/Licence</span>');
          $("#buyn_annual_price").val(data[0].annual_price);
            CalculatePricebuyn(); 
        }
 });
}

$("#buyn_plan_id").change(function(){
    getLicencebuyn();
});


// Add More Licence.....

$("#ex_add_more").keyup(function(){
   CalculatePrice();
});
function CalculatePrice(){
    var totalDaysRe = $("#licenseExpirationDays").val();
    var month_price = $("#ex_month_price").val();
    var user_qty    = $("#ex_add_more").val();
    var perDayValue = (parseFloat(month_price)/30);
    perDayValue     = perDayValue.toFixed(2);
    var allUserPriceDay    = parseFloat(perDayValue) * parseFloat(user_qty);
    var totalPriceValue=parseFloat(totalDaysRe) * parseFloat(allUserPriceDay);
    totalPriceValue=totalPriceValue.toFixed(2);
    $("#ex_amount_exp_date").val(numberToIndPrice(totalPriceValue));
}
function getLicence(){
    var id = $("#Ex_plan_id").val();
 $.ajax({
        url : "<?php echo site_url('upgrade_plan/getLicence/')?>",
        method:"post",
        type: "GET",
        data:{id:id},
        dataType: "JSON",
        success: function(data)
        { 
          $("#exist_lic").val(data.plan_licence);
          $("#ex_used_lic").val(data.used_licence);
          $("#ex_month_price").val(data.month_price);
          $("#ex_month_price_lbl").html(data.month_price)
            CalculatePrice(); 
        }
 });
}

getLicence();
$("#Ex_plan_id").change(function(){
    getLicence();
});


</script>

