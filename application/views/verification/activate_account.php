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
            .login_page .login_img img {width: 60%;}
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
        <div class="login_page" id="login">
    <?php
      $id = $this->uri->segment(3);
      if(!empty($id))
      {
      ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login_img text-center">
                            <img src="https://allegient.team365.io/assets/images/success.svg" >
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login_form">
                            <form class="form" method="post" autocomplete="off">
                                <div class="row">
                                    <div class="col-lg-12 login_top" >
                                    <img src="<?=base_url();?>assets/img/logo-team_h.png">
                                    </div>
                                    <div class="col-lg-12 form-group">
                                    <p style="color:#ccc;">To activate your account please enter the code sent to
                                    your registered email and registered mobile number in the given box</p>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group brdrBtm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="mobile_activation_code" id="mobile_activation_code" maxlength="6" required  placeholder="Enter Mobile OTP">
                                      </div>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group brdrBtm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input  type="text" class="form-control"  name="activation_code" id="activation_code"  maxlength="6" required  placeholder="Enter Email OTP">
                                        
                                      </div>
                                    </div>
                                    
                                    <div class="col-lg-12 form-group" id="ptMsg" style="color: #ccc;">
                                        <?= $this->session->flashdata('msg')?>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <div class="row" style="color:#ccc;">
                                            <div class="col-lg-6">
                                                <p>Back to  <a href="<?=base_url();?>login" id="create"> Log In</a></p>
                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Verify">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
            <?php } ?>
        </div>

        
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="<?=base_url();?>/assets/js/login.js"></script>

   <script>
   $("#activation_code,#mobile_activation_code").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
    $("#ptMsg").html('');
   });
</script>
    
    </body>
    </html>