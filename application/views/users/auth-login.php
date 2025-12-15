    <!doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="icon" type="image/png" href="<?= base_url();?>assets/images/favicon.png">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        <title>Team365 | CRM</title>
        <style>
            body{margin: 0;padding: 0;}
            .login_page{height: 100vh;background: #383f4f;display: flex;justify-content: center;align-items: center;}
            .login_page .container .row{justify-content: center;align-items: center;}
            .login_page .login_img img {width: 80%;}
            
            .login_page .login_form {padding: 20px;background: #ffffff0f;height: auto;justify-content: center;align-items: center;display: flex;}
            .login_page .login_form .login_top img {
                width: 35%;
                padding-left: 10px;
                margin-bottom: 15px;
            }
            .login_page .login_form form .login_top h4 {
                /* background: #ccc; */
                padding: 10px;
                border-radius: 5px 5px 0 0;
                font-size: 18px;
                font-weight: 700;
                letter-spacing: .5px;
                margin-bottom: 15px;
               /* border-bottom: 1px solid #ccc;*/
                color: #ccc;
            }

            .login_page .login_form form .form-group .input-group .input-group-prepend .input-group-text {
                background: none;
                border-radius: 0;
                border: 0;
               /* border-bottom: 1px solid #ccc;*/
            }

            .login_page .login_form form .form-group .input-group .input-group-prepend .input-group-text i {
                color: #ccc;
                width: 20px;
            }

            .login_page .login_form form .form-group .input-group .form-control {
                border: 0;
                padding: 0;
                background: none;
                /*border-bottom: 1px solid #ccc;*/
                border-radius: 0;
                color: #cccccc;
            }
            .login_page .login_form form .form-group .input-group .form-control:focus{
                box-shadow: none;
                outline: 0;
            }
            .login_page .login_form form .form-group .input-group .input-group-append .input-group-text {
                background: none;
                border: 0;
                border-radius: 0;
                /*border-bottom: 1px solid #ccc;*/
            }
            .login_page .login_form form .form-group .input-group .input-group-append .input-group-text a {
                color: #ccc;
                text-decoration: none;
            }
            .login_page .login_form form .login_bottom a {
                background: #ccc;
                padding: 5px 20px;
                font-size: 14px;
                font-weight: 600;
                color: #000;
                text-decoration: none;
            }
            .login_page .login_form form .login_bottom label {
                margin: 0;
                color: #ccc;
                font-size: 15px;
            }
            .login_page .login_form form .login_bottom label input[type="checkbox"] {
                vertical-align: unset;
                margin-right: 10px;
            }
            .login_page .login_form form .need-account p {
                margin-bottom: 0;
                color: #fff;
            }
            
            .brdrBtm {
                border-bottom: 1px solid #ccc;
            }
            
            
            .ClrText {
                margin-bottom: 0;
                color: #fff;
            }
            .form-control:-webkit-autofill,
            .form-control:-webkit-autofill:hover,
            .form-control:-webkit-autofill:focus {
              -webkit-text-fill-color: #ccc;
              transition: background-color 5000s ease-in-out 0s;
              background-color: transparent;
            }
        </style>
    </head>
    <body>
	<?php  if(!isset($_GET['ot'])){ ?>
        <div class="login_page" id="login">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login_img text-center">
						<?php 
                                    $imgArr=array('1.png','2.png','3.png','4.png');
                                    shuffle($imgArr);
                            ?>
                            <img src="<?=base_url();?>assets/login/<?=$imgArr[0];?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login_form">
                            <form class="form" method="post" autocomplete="off" action="<?= base_url('login/securLogin');?>" >
                                <div class="row">
                                    <div class="col-lg-12 login_top">
                                            <img src="<?=base_url();?>assets/img/logo-team_h.png">
                                            <h4>LET'S MAKE SURE YOU'R YOU</h4>
                                    </div>
									<div class="col-lg-12 login_top">
                                            <h4 style="font-size: 16px; font-weight: 500;">Choose how you want to verify your identity</h4>
                                    </div>
                                    <div class="col-lg-12 form-group" style="color: #ccc;">
										<div class="input-group">
                                        Text to
										</div>
										<?php
											$mob=substr($this->session->userdata('mobile_secur'),7);
										?>
										<div class="form-check form-check-inline">
											<input class="form-check-input chb" type="checkbox" id="inlineCheckbox1" name="mobilecheck" value="<?=$this->session->userdata('mobile_secur');?>">
											<label class="form-check-label" for="inlineCheckbox1"><?php echo "*******".$mob; ?></label>
										</div>
                                    </div>
									<?php 
										$data = $this->session->userdata('email_secur');    
										$whatIWant = substr($data, strpos($data, "@") + 0);
									?>
									<div class="col-lg-12 form-group" style="color: #ccc;">
										<div class="input-group">
                                        Email a code
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input chb" type="checkbox" id="inlineCheckbox2" name="emailcheck" value="<?=$this->session->userdata('email_secur');?>">
											<label class="form-check-label" for="inlineCheckbox2"><?php echo "*******".$whatIWant; ?></label>
											
											
										</div>
                                    </div>
									
                                    
                                    <div class="col-lg-12 form-group" style="color:#ccc;">
                                    <span id="msgDv" ><?= $this->session->flashdata('msg')?></span>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6 text-left" style="color:#ccc;">
                                                <p>Back to  <a href="<?=base_url();?>login" id="create"> Login</a></p>
                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <input type="submit" name="log_in" id="log_in" class="btn btn-primary" value="Continue">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		 
<?php } if(isset($_GET['ot'])){ ?>



<?php
/*if(isset($_COOKIE['otpcode']))
{
     
	 echo $_COOKIE['otpcode'];
	 var_dump($this->input->cookie('otpcode', false));
}*/
?>
        <div class="login_page" id="logup"   >
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login_img text-center">
                            <?php 
                                    $imgArr=array('1.png','2.png','3.png','4.png');
                                    shuffle($imgArr);
                            ?>
                            <img src="<?=base_url();?>assets/login/<?=$imgArr[0];?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login_form">
                            <form id="submitForm"  method="post" id="form" action="<?= base_url('login/check_secure_login');?>" >
                                <div class="row">
                                    <div class="col-lg-12 login_top">
										<?php
											$mob=substr($this->session->userdata('mobile_secur'),7);
										?>
										<?php 
										$data = $this->session->userdata('email_secur');    
										$whatIWant = substr($data, strpos($data, "@") + 0);
									?>
                                        <img src="<?= base_url('assets/img/logo-team_h.png') ?>">
                                        <h4 style="border: 0;">ENTER CODE</h4>
										<?php if($_GET['u']=='e'){ ?>
										<h4 style="border: 0;">We sent otp on your email <?php echo "xxxxxx".$whatIWant; ?></h4>
										<?php }else{ ?>
                                        <h4 style="border: 0;">We Texted your phone <?php echo "+xx xxxxxxx".$mob; ?></h4>
										<?php } ?>
										<h4 style="border: 0;">Please enter the code to sign in.</h4>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group brdrBtm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="hidden" name="method" id="method" value="<?php if(isset($_GET['u'])){ echo $_GET['u']; } ?>">
                                        <input type="text" name="otpcode" class="form-control numeric" id="otpcode" maxlength="6" placeholder="Enter OTP Code" >
                                      </div>
                                    </div>
									<div class="col-lg-12 form-group" style="color: #ccc;">
										
										<div class="form-check form-check-inline">
											<input class="form-check-input chb" type="checkbox" id="checkboxOtp" name="checkboxOtp" value="1">
											<label class="form-check-label" for="checkboxOtp">Don't ask again for 14 days.</label>
											
											
										</div>
                                    </div>
									
									<div class="col-lg-12 form-group" style="color:#ccc;">
                                    <span id="msgDv2" ><?= $this->session->flashdata('msg')?></span>
                                    </div>
                                    
                                    <div class="col-lg-12 mt-4">
                                        <div class="row">
                                            <div class="col-lg-6 text-left" style="color:#ccc;">
                                                <p>Back to  <a href="<?=base_url();?>login" id="create"> Login</a></p>
                                            </div>
                                            <div class="col-lg-6 text-right"  id="oriButton" >
                                               <button class="btn btn-primary" name="verify_user" value id="verify_user" >Verify</button>
                                            </div>
											<div class="col-lg-6 text-right" id="dummyButton" style="display:none;" >
                                               <button class="btn btn-primary" >
											   <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Verifying...
											   </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php }  ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?=base_url();?>assets/js/login.js"></script>

    <script>
        $(".chb").change(function() {
		$(".chb").prop('checked', false);
		$(this).prop('checked', true);
		});
        
        $("#create").click(function(){
            $("#logup").show();
            $("#login").hide();
        });

      $("#returnn").click(function(){
            $("#login").show();
            $("#logup").hide();
        });
     
     var getData="<?php if(isset($_GET['it'])){ echo $_GET['it']; }else{ echo "0"; } ?>";
				if(getData=='signup'){
				    $("#logup").show();
                    $("#login").hide();
				}
				
				
     
    </script> 
    <script type="text/javascript">
    	    
    	 $('#admin_email').val('');
    	 $('#msg').html('');
		setTimeout(function(){ $('#msgDv,#msgDv2').hide(); },5000);
		
    </script>
    <script type="text/javascript">

    function AllowOnlyNumbers(e) {
        e = (e) ? e : window.event;
        var clipboardData = e.clipboardData ? e.clipboardData : window.clipboardData;
        var key = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
        var str = (e.type && e.type == "paste") ? clipboardData.getData('Text') : String.fromCharCode(key);
    
        return (/^\d+$/.test(str));
    }
      
	
	$("#log_in").click(function(){
			if($("#inlineCheckbox1").prop('checked') == true || $("#inlineCheckbox2").prop('checked') == true){
				return true;
				$("#log_in").attr("disabled",true);
			}else{
				$("#msgDv").html('<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Please select anyone box');
				return false;
			}
    	   
	}); 
	$("#verify_user").click(function(){
		var otpcode = $("#otpcode").val();
		if(otpcode==""){
			$("#logup .brdrBtm").css('border-color','red');
			$("#oriButton").hide();
			$("#dummyButton").show();
			return false;
		}else{
			$('#submitForm').get(0).submit();
			return true;
		}   
	});	
	
	
	
	$(".form-control").keypress(function(){
		$(this).closest('.brdrBtm').css('border-color', '');
	});

	  
    </script>
    </body>
    </html>