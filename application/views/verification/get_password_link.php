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
            
            
        </style>
    </head>

    <body>
      
        <div class="login_page" id="forgot"  >
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login_img">
                            <?php 
                                    $imgArr=array('1.png','2.png','3.png','4.png');
                                    shuffle($imgArr);
                            ?>
                            <img src="<?=base_url();?>assets/login/<?=$imgArr[0];?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login_form">
                            <form method="post" autocomplete="off">
                                <div class="row">
                                    <div class="col-lg-12 login_top">
                                        <img src="<?=base_url();?>assets/img/logo-team_h.png">
                                        <h4>RESET YOUR PASSWORD</h4>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group brdrBtm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <select name="method" id="reset_method" class="form-control">
                                          <option selected disabled value="none">Reset Password Using</option>
                                          <option value="Email">Email</option>
                                          <option value="Phone">Phone</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-lg-12 form-group" id="email" style="display: none">
                                        <div class="input-group brdrBtm" >
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-envelope-open"></i></span>
                                        </div>
                                        <input name="email" type="email" id="emailAddress" autocomplete="off" class="form-control" placeholder="Registered Email Address">
                                      </div>
                                    </div>
                                    <div class="col-lg-12 form-group" id="phone" style="display: none">
                                        <div class="input-group brdrBtm" >
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                                        </div>
                                        <input name="mobile" type="mobile" id="mobilePhone" autocomplete="off" maxlength="10" class="form-control" placeholder="Registered Mobile No">
                                      </div>
                                    </div>
                                    
                                    <div class="col-lg-12 form-group" style="color:#ccc;">
                                     <?php if($this->session->flashdata('msg')){?>
                                        <span style="font-family: serif;" id="msgSpn">
                                            <i class="fa fa-exclamation-triangle" style="color:red; margin-right:10px;"></i>
                                        <?= $this->session->flashdata('msg')?></span> 
                            		<?php } ?>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row" style="color:#ccc;">
                                            <div class="col-lg-6">Back to <a href="<?php echo base_url();?>login">login</a></div>
                                            <div class="col-lg-6 text-right">
                                                    <input type="submit" name="submit" class="btn btn-primary" id="sendOtp" value="Submit">
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?=base_url();?>/assets/js/login.js"></script>
   
 <script>
$(document).ready(function(){
      $("#email").hide();
      $("#phone").hide();
});

setTimeout(function(){ $("#msgSpn").hide(); },4000);

$('#reset_method').on('change',function(){
    if( $(this).val()==="Email"){
    $("#email").show()
    $("#phone").hide()
    }
    else if( $(this).val()==="Phone"){
    $("#email").hide()
    $("#phone").show()
    }

});

$("#sendOtp").click(function(){
	var resetmethod=$("#reset_method").val();
	var emailAddress=$("#emailAddress").val();
	var mobilePhone=$("#mobilePhone").val();
	if(resetmethod==null || resetmethod=="" || resetmethod === undefined){
		$("#reset_method").closest('.brdrBtm').css('border-color', 'red');
		return false;
	}else if(resetmethod=='Email' && emailAddress==""){
		$("#emailAddress").closest('.brdrBtm').css('border-color', 'red');
		return false;
	}else if(resetmethod=='Phone' && mobilePhone==""){
		$("#mobilePhone").closest('.brdrBtm').css('border-color', 'red');
		return false;
	}else{
		return true;
	}
});
$('.form-control').change(function(){
	$(this).closest('.brdrBtm').css('border-color', '');
});
$('.form-control').keypress(function(){
	$(this).closest('.brdrBtm').css('border-color', '');
});
  $("#mobilePhone").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
   });

</script>
    </body>
    </html>