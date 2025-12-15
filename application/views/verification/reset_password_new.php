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
       <?php
    $currenttime = date("Y-m-d H:i:s");
	$getvl=$this->session->userdata('tp');
    if(!empty($user1) && $getvl=='sdtr')
    {
      foreach($user1 as $row)
      {
		 
        if($this->uri->segment(3) == $row['id'] && $currenttime <= $row['password_key_valid_untill'])
        {
    ?>
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
                                        <h4>Reset your password</h4>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group brdrBtm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input name="password" type="password"  id="pass" autocomplete="off" class="form-control input" placeholder="Enter password">
                                     
                                      </div>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group brdrBtm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input name="c_password" type="password" id="password" onkeyup="show()" class="form-control input" autocomplete="off"   placeholder="Enter confirm password">
                                     
                                      </div>
                                    </div>
                                    <div class="col-lg-12 form-group" style="color:#ccc;">
                                        <p class="text-danger match" id="match">Password did not match</p>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6"style="color: #ccc; ">
                                                Back to <a href="<?php echo base_url();?>login">login</a></div>
                                            <div class="col-lg-6 text-right">
                                                <input type="submit" id="updatepass" name="update" class="btn btn-primary" value="Submit">
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
         <?php
      }
      else
      {
        ?>
        <div class="login-container">
          <form class="form">
          <img class="verify_img" src="<?= base_url();?>assets/images/error.svg">
          <h2>ERROR!</h2>
          <p>The Page You're Trying To Access Is Currently Unavailable.</p>
          </form>
        </div>
        <?php
      }
    }
    }
    elseif(!empty($user)  && $getvl=='spr')
    {
      foreach($user as $row){
        if($this->uri->segment(3) == $row['id'] && $currenttime <= $row['password_key_valid_untill'])
        {
    ?>
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
                                        <h4>Reset your password</h4>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group brdrBtm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input name="password" type="password"  id="pass" autocomplete="off" class="form-control input" placeholder="Enter password">
                                     
                                      </div>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group brdrBtm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input name="c_password" type="password" id="password" onkeyup="show()" class="form-control input" autocomplete="off"   placeholder="Enter confirm password">
                                     
                                      </div>
                                    </div>
                                    
                                    <div class="col-lg-12 form-group" style="color:#ccc;">
                                        <p id="msgp" class="mt-2 text-danger match"></p>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6"style="color: #ccc; ">
                                                Back to <a href="<?php echo base_url();?>login">login</a></div>
                                            <div class="col-lg-6 text-right">
                                                <input type="submit" id="updatepass" name="update"  class="btn btn-primary" value="Submit">
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
    
    
    <?php
      }
      else
      {
        ?>
        <div class="login-container">
          <form class="form">
          <img class="verify_img" src="<?= base_url();?>assets/images/error.svg">
          <h2>ERROR!</h2>
          <p>The Page You're Trying To Access Is Currently Unavailable.</p>
          </form>
        </div>
        <?php
      }
    }
    }
    ?>
        
        
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?=base_url();?>/assets/js/login.js"></script>
   
	<script>
	setTimeout(function(){ $("#msgp").hide(); },4000);
	$("#updatepass").click(function(){
		var pass=$("#pass").val();
		var password=$("#password").val();
		if(pass==""){
			$("#msgp").show(400);
			$("#pass").css('border-color','red');
			setTimeout(function(){ $("#msgp").hide(); $("#pass").css('border-color',''); },3000);
			return false;
		}else if(password!=pass){
			$("#msgp").show(400);
			$("#password").css('border-color','red');
			$("#msgp").html('<i class="fa fa-times-circle" style="color: red; margin-right: 10px;"></i> Password missmatched');
			setTimeout(function(){ $("#msgp").hide(); $("#password").css('border-color',''); },3000);
			return false;
		}else{
			return true;
		}
	});
	</script>
  </body>
</html>