<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
	<link rel="stylesheet" type="text/css" href="<?= STYLE_CSS_1; ?>">
    <link rel="stylesheet" type="text/css" href="<?= RESPONSIVE_CSS; ?>">
	<link rel="stylesheet" type="text/css" href="<?= RANDBG_CSS; ?>">

	
    <title>Team365 | Login</title>
    
  </head>
  <style>
    .right-side .fa-eye{
      position: absolute;
      top: 20px;
      right: 0px;
      color: #7b7b7b;
      cursor: pointer;
    }
  </style>
  <body class="randbg">

    <!----------login form--------->
    
      <div class="login-form" id="log">
        <div class="container">
          <div class="inner-form">
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-flex align-items-center justify-content-center">
				<div class="left-side">
					<img src="<?php echo base_url(); ?>assets/img/new-logo-t.png" class="img-fluid">
					<p>Sign in or create an account</p>
				</div>
			  </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="right-side">
                  <h2 style="margin:0px;">Login to your account</h2>
				  <div style="margin: 10px 0px; height: 24px;"  ><span id="msgDv" ><?= $this->session->flashdata('msg')?></span>
				 
				  </div>
				  
                  <form class="form" method="post" autocomplete="off" action="<?= base_url('superadmin/login/auth');?>">
                    <div class="form-group">
                      <label for="email">Email address:</label>
                      <input type="email" name="email" class="form-control" id="email" autocomplete="off">
                    </div>
                    <div class="form-group" style="position : relative;">
                      <label for="pwd">Password:</label>
                      <input type="password" class="form-control"  name="password" id="pass" autocomplete="off">
					  <i class="fa fa-eye" aria-hidden="true" onclick="show_pass()" style="top: 31px;" ></i>
                    </div>
                    <div class="form-group">
                      <!-- <a href="password_reset.html">Forgot Password?</a> -->
                      <a class="a" href="<?= base_url('superadmin/login/get_password_link')?>">Forgot&nbsp;Password&nbsp;?</a>
                    </div>
                    <div class="form-group">
                      <input type="submit" name="log_in" class="btn btn-default" value="Login">
                    </div>
                    <!--<div class="form-group text-center">
                      <p>Don't have a Team365 account? <a href="javascript:void(0);" id="new_create"> Sign up</a></p>
                    </div>-->
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div> 
       </div>    
    <!----------Signup form--------->

    <div class="Signup-form" id="sign" style="display:none;">
      <div class="container">
        <div class="inner-form">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-flex align-items-center justify-content-center">
              <div class="left-side">
                <img src="<?php echo base_url(); ?>assets/img/new-logo-t.png" class="img-fluid">
                <p>Sign in or create an account</p>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
              <div class="right-side">
                <h2>Start with your free account today</h2>
				<?php if($this->session->flashdata('msg_err')){ ?>
				<span id="msgfls"><i class="fa fa-info-circle" style="color: red; margin-right: 7px;"></i><?= $this->session->flashdata('msg_err')?></span>
				<?php } ?>
                <form class="" method="post" id="form" action="<?= base_url('superadmin/login/register');?>">
                  <div class="container">
                    <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="name">First Name:</label>
                          <input type="text" name="first_name" class="form-control" id="first_name">
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="name">Last Name:</label>
                          <input type="text" name="last_name" class="form-control" id="last_name">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="email">Email:</label>
                          <input type="email" name="admin_email" id="admin_email" class="form-control" onblur="check()" autocomplete="off">
                          <span id="msg"></span>
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="mobile number">Mobile No.:</label>
                          <input name="admin_mobile" id="admin_mobile" onblur="check_m()" class="form-control" type="tel">
                           <span id="msg2"></span>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="password">Password:</label>
                          <input type="password" class="form-control" id="pass_s" autocomplete="off">
						  <span id="msg3"></span>
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="password">Confirm Password:</label>
                          <input type="password" class="form-control" name="admin_password" id="password">
						  <span id="msg4"></span>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <input type="checkbox" id="accept"> <span>I Accept All The Terms & Conditions.</span>
                    </div>

                    <div class="form-group">
                      <input type="submit" class="btn btn-default" name="register_user" value="Signup" id="add_user" style="cursor:not-allowed" disabled>
                    </div>

                    <div class="form-group text-center">
                      <a href="#" id="return"><i class="fas fa-long-arrow-alt-left " style="font-size: 20px;  transform: translateX(-5px); vertical-align: middle;"></i>Back</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="<?= LOGIN_JS; ?>"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

    <!-- Optional JavaScript -->
	 <script>
(function($) {

    $.fn.RandBG = function(options) {

        var settings = $.extend({
            ClassPrefix: "bg",
            count: 10
        }, options);
        
        var index = Math.ceil(Math.random() * settings.count * settings.count) % settings.count;
        
        $(this).addClass(settings.ClassPrefix + index);
    };

}(jQuery));
      $(".randbg").RandBG();

    </script>

    <script type="text/javascript">
    	$(document).ready(function(){
        $("#new_create").click(function(){
          $("#log").hide();
          $("#sign").show();
         
          
        });
        $("#return").click(function(){
			$("#sign").hide();
            $("#log").show();
		  
        }); 
		var flshdata="<?=$this->session->flashdata('msg_err');?>";
			if(flshdata){
					$("#log").hide();
					$("#sign").show();
				 setTimeout(function(){ $("#msgfls").hide();},4000);
			}else{
				$("#log").show();
				$("#sign").hide();
			}
		
    	});    	
		
		setTimeout(function(){ $('#msgDv').hide(); },3000);
		
    </script>
    <script type="text/javascript">
      function check()
      {
        var admin_email = $('#admin_email').val();
        if(admin_email != '')
        {
          $.ajax({
           url: "<?= site_url(); ?>login/checkemail",
           method: "POST",
           data: {admin_email:admin_email},
           success: function(data)
            {
              $('#msg').html(data);
			  setTimeout(function(){  $('#msg').html(''); },4000);
            }
          });
        }
      }   
      function check_m()
      {
        var admin_mobile = $('#admin_mobile').val();
        if(admin_mobile != '')
        {
          $.ajax({
           url: "<?= site_url(); ?>login/checkmobile",
           method: "POST",
           data: {admin_mobile:admin_mobile},
           success: function(data)
            {
              $('#msg2').html(data);
			  setTimeout(function(){  $('#msg2').html(''); },4000);
            }
          });
        }
      }
	  
	$("#add_user").click(function(){
		var first_name  = $('#first_name').val();
		var last_name   = $('#last_name').val();
		var admin_email = $('#admin_email').val();
		var admin_mobile= $('#admin_mobile').val();
		var pass_s 		= $('#pass_s').val();
		var password 	= $('#password').val();
		
		if(first_name==""){
			$('#first_name').css('border-color','red');
			$('#first_name').focus();
			return false;
		}else if(last_name==""){
			$('#last_name').css('border-color','red');
			$('#last_name').focus();
			return false;
		}else if(admin_email==""){
			$('#admin_email').css('border-color','red');
			$('#admin_email').focus();
			return false;
		}else if(admin_mobile=="" || !$.isNumeric(admin_mobile)){
			$('#admin_mobile').css('border-color','red');
			$('#admin_mobile').focus();
			 $('#msg2').html('<i class="fa fa-info-circle" style="color: red; margin-right: 7px;"></i>Only numbers allowed');
			 return false;
		}else if(pass_s==""){
			$('#pass_s').css('border-color','red');
			$('#pass_s').focus();
			return false;
		}else if(pass_s.length<8){
			$('#pass_s').css('border-color','red');
			$('#msg3').html('<i class="fa fa-info-circle" style="color: red; margin-right: 7px;"></i>Password strength must be greater than 8 character.');
			$('#pass_s').focus();
			setTimeout(function(){$('#msg3').html('');},3000);
			return false;
		}else if(password=="" || pass_s!=password){
			$('#password').css('border-color','red');
			$('#password').focus();
			$('#msg4').html('<i class="fa fa-info-circle" style="color: red; margin-right: 7px;"></i>Password did not match');
			setTimeout(function(){$('#msg4').html('');},3000);
			return false;
		}else{
			return true;
		}
			
		
		
	});  
	
	$(".form-control").keypress(function(){
		$(this).css('border-color','');
	});
	  
    </script>
  </body>
</html>