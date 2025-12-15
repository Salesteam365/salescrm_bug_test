<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Team365 | Add Company Details</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" type="image/png" href="<?= base_url();?>assets/images/favicon.png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/navbar_0.css">
  <link rel="stylesheet" href="<?= DASHBOARD_CSS;?>">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.theme.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery-ui.min.css">
</head>
<body style="background:#0070d2">
  <div class="wrapper">
    <a href="#"><img width="7%" style="margin:60px;" src="<?= base_url();?>assets/images/logo.png"></a>
    <div class="main_container">
      <div class="item row">
        <div style="width:80%;background:#fff;padding:2%;margin-top:-100px;margin-left:50px;box-shadow: 4px 6px 8px #dae7f2;">
        <form class="row" action="<?php echo base_url('superadmin/login/add_company_details'); ?>" method="post">
          <h2 class="col-12">ADD COMPANY DETAILS</h2>
          <div class="input-group input-group-sm col-12 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-city"></i></span>
            </div>
            <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name">
          </div>
          <div class="input-group input-group-sm col-6 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-globe"></i></span>
            </div>
            <input type="text" class="form-control" name="company_website" id="company_website" placeholder="Company Website">
          </div>
          <div class="input-group input-group-sm col-6 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-at"></i></span>
            </div>
            <input type="email" class="form-control" name="company_email" id="company_email" placeholder="Company Email">
          </div>
          <div class="input-group input-group-sm col-6 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-mobile-alt"></i></span>
            </div>
            <input type="text" class="form-control" name="company_mobile" id="company_mobile" placeholder="Company Mobile" >
          </div>
          <div class="input-group input-group-sm col-6 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-id-card-alt"></i></span>
            </div>
            <input type="text" class="form-control" name="pan_number" placeholder="PAN">
          </div>
          <div class="input-group input-group-sm col-6 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-id-card"></i></span>
            </div>
            <input type="text" class="form-control" name="cin" placeholder="CIN">
          </div>
          <div class="input-group input-group-sm col-6 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="far fa-address-card"></i></span>
            </div>
            <input type="text" class="form-control" name="company_gstin" placeholder="GSTIN">
          </div>
          <div class="input-group input-group-sm col-6 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-map-marked-alt"></i></span>
            </div>
            <input type="text" class="form-control" name="country" id="country" placeholder="Country">
            <input type="hidden" class="form-control form-control-sm" id="country_ids" >
          </div>
          <div class="input-group input-group-sm col-6 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-map-marker-alt"></i></span>
            </div>
            <input type="text" class="form-control" name="state" id="states" placeholder="State">
            <input type="hidden" class="form-control form-control-sm" id="state_id" >
          </div>
          <div class="input-group input-group-sm col-6 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-location-arrow"></i></span>
            </div>
            <input type="text" class="form-control" name="city" id="cities" placeholder="City">
          </div>
          <div class="input-group input-group-sm col-6 mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-mail-bulk"></i></span>
            </div>
            <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Zipcode">
          </div>
          <div class="col-md-12 mb-3">
              <textarea type="text" class="form-control form-control-sm" name="address" id="address" placeholder="Address" required></textarea>
          </div>
          <div class="col-md-12 mb-3">
              <textarea type="text" class="form-control form-control-sm" name="terms_condition_customer"  id="terms_condition_customer" placeholder="Customer Terms & Condition" required></textarea>
          </div>
          <div class="col-md-12 mb-3">
              <textarea type="text" class="form-control form-control-sm" name="terms_condition_seller" id="terms_condition_seller" placeholder="Seller Terms & Condition" required></textarea>
          </div>
          <div class="col-md-9 mb-3">
          </div>
          <div class="col-md-3 mb-3">
              <input type="submit" class="btn btn-primary btn-sm float-right" name="add_details" id="add_details" value="Submit">
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
    <span class="float-right" style="position:fixed;bottom:15px;right:15px;font-size:12px;color:#fff;"><b> All Rights Reserved. © <?= date('Y');?>, Allegient Unified Technology Pvt. Ltd.</b></span>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="<?= base_url();?>assets/js/common_pages.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- AUTOCOMPLETE QUERY -->
<script type="text/javascript">

 $('#add_details').click(function(){
	 var company_name=$("#company_name").val();
	 var company_website=$("#company_website").val();
	 var company_email=$("#company_email").val();
	 var company_mobile=$("#company_mobile").val();
	 var country=$("#country").val();
	 var states=$("#states").val();
	 var cities=$("#cities").val();
	 var zipcode=$("#zipcode").val();
	 var address=$("#address").val();
	 var terms_condition_customer=$("#terms_condition_customer").val();
	 var terms_condition_seller=$("#terms_condition_seller").val();
	 
	 if(company_name==""){
		 $("#company_name").css('border-color','red');
		 $("#company_name").focus();
		 return false
	 }else if(company_website==""){
		 $("#company_website").css('border-color','red');
		 $("#company_website").focus();
		 return false
	 }else if(company_email==""){
		 $("#company_email").css('border-color','red');
		 $("#company_email").focus();
		 return false
	 }else if(IsEmail(company_email)==false){
		 $("#company_email").css('border-color','red');
		 $("#company_email").val('');
		 $("#company_email").attr('placeholder','Enter Valid Email Address');
		 $("#company_email").focus();
		 return false
	 }else if(company_mobile==""){
		 $("#company_mobile").css('border-color','red');
		 $("#company_mobile").focus();
		 return false
	 }else if(country==""){
		 $("#country").css('border-color','red');
		 $("#country").focus();
		 return false
	 }else if(states==""){
		 $("#states").css('border-color','red');
		 $("#states").focus();
		 return false
	 }else if(cities==""){
		 $("#cities").css('border-color','red');
		 $("#cities").focus();
		 return false
	 }else if(zipcode==""){
		 $("#zipcode").css('border-color','red');
		 $("#zipcode").focus();
		 return false
	 }else if(address==""){
		 $("#address").css('border-color','red');
		 $("#address").focus();
		 return false
	 }else if(terms_condition_customer==""){
		 $("#terms_condition_customer").css('border-color','red');
		 $("#terms_condition_customer").focus();
		 return false
	 }else if(terms_condition_seller==""){
		 $("#terms_condition_seller").css('border-color','red');
		 $("#terms_condition_seller").focus();
		 return false
	 }else{
		 return true;
	 }
	 
 });
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}
$(".form-control").keypress(function(){
	$(this).css('border-color','');
});


/*#########
validation to checkvebsite

//alert(isValidURL('http://appvela.com/')); 

function isValidURL(str) {
   var a  = document.createElement('a');
   a.href = str;
   return (a.host && a.host != window.location.host);
}
###########*/

 $("#company_mobile").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});

$(document).ready(function(){
  $('#country').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#country_ids').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#states').autocomplete({
    source: function(request, response) {
           var country_id =$('#country_ids').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_states');?>",
                data: { terms: request.term, country_id: country_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },  
   // source: "<?= site_url('login/autocomplete_states');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#state_id').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#cities').autocomplete({
    source: function(request, response) {
           var state_id =$('#state_id').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_cities');?>",
                data: { terms: request.term, state_id: state_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },  
    //source: "<?= site_url('login/autocomplete_cities');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
</html>