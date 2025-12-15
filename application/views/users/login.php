<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="<?= base_url(); ?>assets/img/logo.jpg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Best Software Company in Delhi</title>
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php base_url('') ?>new-crm-assets/img/team365-favicon.png">

    <!-- CSS here -->
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/animate.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/custom-animation.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/slick.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/nice-select.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/flaticon.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/swiper-bundle.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/meanmenu.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/font-awesome-pro.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/spacing.css">
    <link rel="stylesheet" href="<?php base_url('') ?>new-crm-assets/css/style.css">
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $this->config->item('recaptcha_site_key');?>"></script>
</head>
<style>
    .signin-banner-from-wrap {
        width: auto;
        padding: 2rem;
        border: 1px dashed lightgrey;
        border-radius: 0.735rem;
    }

    .input-group-text {
        background-color: transparent;
    }

    .login_page .signup-form {
        padding: 2rem;
        border: 1px dashed lightgrey;
        border-radius: 0.735rem;
    }
    .signinbtnsection{
        display:none;
    }

    @media only screen and (max-width: 540px) {
        .signin-banner-from-wrap {
            /*border: none;*/
            margin-top: 2rem;
        }

        .signin-banner-from {
            padding: 1rem;
        }
        /*.login_page .signup-form {*/
        /*margin-top: 60rem;*/
        /*}*/
    }
    @media only screen and (max-width: 720px) {
        .login_page .signup-form {
        margin-top: 60rem;
        }
    }
    
    
</style>
<!--<body style="height:auto!important" class="h-auto">-->

<body>
    <!-- preloader -->
    <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- preloader end  -->
    <!-- back-to-top-start  -->
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="far fa-angle-double-up"></i>
    </button>
    <!-- back-to-top-end  -->
    <!-- tp-offcanvus-area-start -->

    </div>
    </div>

    <div id="smooth-wrapper">
        <div id="smooth-content">
            <main>
                <!-- tp-banner-area-start -->
                <div class="signin-banner-area signin-banner-main-wrap d-flex align-items-center">
                    <div class="signin-banner-left-box signin-banner-bg p-relative d-none d-md-block d-lg-block"
                        data-background="new-crm-assets/img/login/login-bg-shape.png">
                        <div class="signin-banner-bottom-shape">
                            <img src="<?php base_url('') ?>new-crm-assets/img/login/login-shape-1.png" alt="">
                        </div>
                        <div class="signin-banner-left-wrap">
                            <div class="signin-banner-title-box mb-100">
                                <h4 class="signin-banner-title tp-char-animation">Welcome To <br> Team365 CRM.</h4>
                            </div>
                            <div class="signin-banner-img-box position-relative">
                                <div class="signin-banner-img signin-img-1 d-none d-md-block z-index-3">
                                    <img src="<?php base_url('') ?>assets/new-crm-assets//img/login/login-2.png" alt="">
                                </div>
                                <div class="signin-banner-img signin-img-2 d-none d-md-block">
                                    <img src="<?php base_url('') ?>assets/new-crm-assets//img/login/login-1.png" alt="">
                                </div>
                                <div class="signin-banner-img signin-img-3 d-none d-md-block z-index-5">
                                    <img src="<?php base_url('') ?>assets/new-crm-assets//img/login/login-3.png" alt="">
                                </div>
                                <div class="signin-banner-img signin-img-4 d-none d-sm-block">
                                    <img src="<?php base_url('') ?>assets/new-crm-assets//img/login/login-4.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="signin-banner-from d-flex justify-content-center align-items-center">
                        <div class="login_page " id="login">
                            <div class="">
                                <div class="signin-banner-from-wrap">
                                    <div class="signin-banner-from-box">
                                        <img src="<?php base_url('') ?>new-crm-assets//img/logo/team365_logo.png" alt=""
                                            class="mb-20" style="margin-left:-10px;">
                                        <h4 class="signin-banner-from-title lh-sm">SIGN IN TO START YOUR SESSION</h4>
                                    </div>
                                    <div class="signin-banner-from-box">
                                        <h5 class="signin-banner-from-subtitle">Team365 CRM</h5>
                                        <form class="form" method="post" autocomplete="off"
                                            action="<?= base_url('login/auth'); ?>">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="postbox__comment-input mb-30">
                                                        <input type="email" class="inputText" required name="email"
                                                            id="email" placeholder="Enter Your Email">                                                        
                                                        <div class="col-lg-12 form-group" style="color:#ccc;">
                                                        </div>
                                                        <span class="eye-btn">
                                                            <span class="input-group-text"
                                                                style="color: #cccccc; padding-right: 0; border:none; "
                                                                id="msglog"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="postbox__comment-input mb-30">
                                                        <input class="inputText password" type="password" required
                                                            name="password" id="pass" placeholder="Enter Your Password">                                                        
                                                        <div class="col-lg-12 form-group" style="color:#ccc;">
                                                            <span id="msgDv">
                                                                <?= $this->session->flashdata('msg') ?>
                                                            </span>
                                                        </div>
                                                        <span id="click" class="eye-btn"
                                                            onclick="showPassword(this.parentElement.querySelector('input'))">
                                                            <span class="eye-on">
                                                                <svg width="20" height="17" viewBox="0 0 20 17"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.5"
                                                                        d="M2.1474 11.1661C1.38247 10.1723 1 9.67544 1 8.2C1 6.72456 1.38247 6.22767 2.1474 5.2339C3.67477 3.2496 6.2363 1 10 1C13.7637 1 16.3252 3.2496 17.8526 5.2339C18.6175 6.22767 19 6.72456 19 8.2C19 9.67544 18.6175 10.1723 17.8526 11.1661C16.3252 13.1504 13.7637 15.4 10 15.4C6.2363 15.4 3.67477 13.1504 2.1474 11.1661Z"
                                                                        stroke="#1C274C" stroke-width="1.5" />
                                                                    <path
                                                                        d="M12.6969 8.2C12.6969 9.69117 11.488 10.9 9.99687 10.9C8.50571 10.9 7.29688 9.69117 7.29688 8.2C7.29688 6.70883 8.50571 5.5 9.99687 5.5C11.488 5.5 12.6969 6.70883 12.6969 8.2Z"
                                                                        stroke="#1C274C" stroke-width="1.5" />
                                                                </svg>
                                                            </span>
                                                            <span class="eye-off">
                                                                <svg width="18" height="18" viewBox="0 0 25 25"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <g clip-path="url(#clip0_2547_24206)">
                                                                        <path
                                                                            d="M18.813 18.9113C17.1036 20.2143 15.0222 20.9362 12.873 20.9713C5.87305 20.9713 1.87305 12.9713 1.87305 12.9713C3.11694 10.6532 4.84218 8.62795 6.93305 7.03134M10.773 5.21134C11.4614 5.05022 12.1661 4.96968 12.873 4.97134C19.873 4.97134 23.873 12.9713 23.873 12.9713C23.266 14.1069 22.5421 15.1761 21.713 16.1613M14.993 15.0913C14.7184 15.3861 14.3872 15.6225 14.0192 15.7865C13.6512 15.9504 13.2539 16.0386 12.8511 16.0457C12.4483 16.0528 12.0482 15.9787 11.6747 15.8278C11.3011 15.6769 10.9618 15.4524 10.6769 15.1675C10.392 14.8826 10.1674 14.5433 10.0166 14.1697C9.86567 13.7962 9.79157 13.3961 9.79868 12.9932C9.80579 12.5904 9.89396 12.1932 10.0579 11.8252C10.2219 11.4572 10.4583 11.126 10.753 10.8513"
                                                                            stroke="black" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" />
                                                                        <path d="M1.87305 1.97131L23.873 23.9713"
                                                                            stroke="black" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" />
                                                                    </g>
                                                                    <defs>
                                                                        <clipPath id="clip0_2547_24206">
                                                                            <rect width="24" height="24" fill="white"
                                                                                transform="translate(0.873047 0.971313)" />
                                                                        </clipPath>
                                                                    </defs>
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                      <?php  if(!isset($_COOKIE['captcha'])) { ?>
       
   
                                     <div class="col-lg-12">
                                         <div class="row">
                                               <div class="col-md-6">
                                                   <div class="row catcharow">
                                                       <div class="col-9">
                                                           <canvas class="captchaCanvas" width="150" height="60"></canvas>
                                                       </div>
                                                       <div class="col-3 d-flex align-items-center">
                                                           <i class="fas fa-redo-alt catcharefreshbtn" style="cursor:pointer;" ></i>
                                                       </div>
                                                   </div>
                                               </div>
                                               <div class="col-md-6">
                                                   <div class="row">
                                                       <div class="col-md-8 col-12 ">
                                                           <input type="text" class="form-control captchaInput" placeholder="Enter CAPTCHA">
                                                       </div>
                                                       <!-- Optional: Add an empty column to provide spacing on larger screens -->
                                                       <div class="col-md-4 d-none d-md-block"></div>
                                                   </div>
                                               </div>
                                           </div>
 
                                        </div>
                                               <div class="col-12"><pre class="captchanote"></pre></div>
                                              <button  class="signin-btn btn-block verifycaptchabtn">Verify Captcha</button>
                                   
                                 </div>
                                 <?php }  ?>
                                 <?php  if(isset($_COOKIE['captcha'])) { ?>
                                    <div class="signin-banner-from-btn mb-20 ">
                                                <button class="signin-btn btn-block" type="submit" name="log_in"
                                                    id="log_in" value="Log In">Sign In</button>
                                            </div>
                                    <?php } ?>
                                            <div class="signin-banner-form-remember">
                                                <div class="row">
                                                <?php  if(isset($_COOKIE['captcha'])) { ?>
                                                    <div class="col-6"></div>
                                                    <?php } else{ ?>
                                                        <div class="col-6">
                                                        <div class="postbox__comment-agree">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="1" name="nocaptcha"
                                                                    id="flexCheckDefault">
                                                                <label class="form-check-label"
                                                                    for="flexCheckDefault">Remember me</label>                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                  <?php  }?>
                                                    <div class="col-6">
                                                        <div class="postbox__forget text-end">
                                                            <a href="<?= base_url('login/get_password_link') ?>"
                                                                id="#password">Forgot password ?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="signin-banner-from-btn mb-20 signinbtnsection">
                                                <button class="signin-btn btn-block" type="submit" name="log_in"
                                                    id="log_in" value="Log In">Sign In</button>
                                            </div>
                                        </form>
                                        <div class="signin-banner-from-register">
                                            <a href="JavaScript:void(0);" id="create">Don't have account ?
                                                <span>Register</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- tp-banner-area-end -->
            </main>
        </div>
    </div>

    <!-- Sign Up Page -->
    <div class="signin-banner-from d-flex justify-content-center align-items-center mt-20">
        <div class="login_page " id="logup" style="display: none; ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                    </div>
                    <div class="col-lg-6 signup-form">
                        <div class="login_form  login-area">
                            <form  method="post" id="form" action="<?= base_url('login/register'); ?>">
                                <div class="row">
                                    <div class="col-lg-12 login_top">
                                        <img src="<?php base_url('') ?>new-crm-assets//img/logo/team365_logo.png" alt=""
                                            class="mb-20" style="margin-left:-10px;">
                                        <h4 class="mb-30" style="border: 0;">START WITH YOUR FREE ACCOUNT TODAY</h4>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="postbox__comment-input">
                                            <input type="text" class="inputText" name="promocode" id="promocode"
                                                placeholder="Apply Promocode">
                                            <div class="col-lg-12 form-group" style="color:#ccc;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <div class="postbox__comment-input">
                                            <div class="input-group brdrBtm">
                                                <input type="text" name="first_name" class="inputText onlyLetters"
                                                    id="first_name" placeholder="Full Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <div class="postbox__comment-input">
                                            <input type="email" name="admin_email" id="admin_email" class="inputText"
                                                placeholder="Email Address" autocomplete="off">
                                            <div class="col-lg-12 form-group" style="color:#ccc;">
                                            </div>
                                            <span class="eye-btn">
                                                <span class="input-group-text"
                                                    style="color: #cccccc; padding-right: 0;border:none;"
                                                    id="msg"></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <div class="postbox__comment-input">
                                            <input placeholder="Mobile No" name="admin_mobile" id="admin_mobile"
                                                onChange="check_m()" class="inputText numeric" type="tel" maxlength="10"
                                                onkeypress="return AllowOnlyNumbers(event);"
                                                onpaste="return AllowOnlyNumbers(event);">
                                            <div class="col-lg-12 form-group" style="color:#ccc;">
                                            </div>
                                            <span class="eye-btn">
                                                <span class="input-group-text"
                                                    style="color: #cccccc; padding-right: 0; border:none; "
                                                    id="msg2"></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 form-group">                                      
                                        <div class="postbox__comment-input">
                                            <input type="password" class="inputText" placeholder="Password" id="pass_s"
                                                autocomplete="off">
                                            <div class="col-lg-12 form-group" style="color:#ccc;">
                                            </div>
                                            <span class="eye-btn">
                                                <span id="msg3"></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 form-group">
                                        <div class="postbox__comment-input">
                                            <input type="password" class="inputText" placeholder="Confirm Password"
                                                name="admin_password" id="password">
                                            <div class="col-lg-12 form-group" style="color:#ccc;">
                                            </div>
                                            <span class="eye-btn">
                                                <span id="msg4"></span>
                                            </span>
                                        </div>


                                    </div>

                                    <div class="col-lg-12 form-group mb-30">
                                        <div class="input-group brdrBtm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="color: #cccccc;">www.</span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Ex allegient"
                                                onkeypress="return (event.charCode > 96 && event.charCode < 123)"
                                                id="yourUrlname" name="yourUrlname" onChange="check_url()">

                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                    style="color: #cccccc; padding-right: 0; ">.team365.io <text
                                                        id="ptIcon"></text></span>
                                            </div>

                                        </div>
                                    </div>
                                    <!--     <div class="col-lg-12">-->
                                    <!--     <div class="row">-->
                                    <!--           <div class="col-md-6">-->
                                    <!--               <div class="row catcharow">-->
                                    <!--                   <div class="col-9">-->
                                    <!--                       <canvas class="captchaCanvas" width="150" height="60"></canvas>-->
                                    <!--                   </div>-->
                                    <!--                   <div class="col-3 d-flex align-items-center">-->
                                    <!--                       <i class="fas fa-redo-alt catcharefreshbtn" style="cursor:pointer;" ></i>-->
                                    <!--                   </div>-->
                                    <!--               </div>-->
                                    <!--           </div>-->
                                    <!--           <div class="col-md-6">-->
                                    <!--               <div class="row">-->
                                    <!--                   <div class="col-md-8 col-12 ">-->
                                    <!--                       <input type="text" class="form-control captchaInput" placeholder="Enter CAPTCHA">-->
                                    <!--                   </div>-->
                                                       <!-- Optional: Add an empty column to provide spacing on larger screens -->
                                    <!--                   <div class="col-md-4 d-none d-md-block"></div>-->
                                    <!--               </div>-->
                                    <!--           </div>-->
                                    <!--       </div>-->

                                    <!--    </div>-->
                                    <!--           <div class="col-12"><pre class="captchanote"></pre></div>-->
                                    <!--          <button  class="signin-btn btn-block verifycaptchabtn">Verify Captcha</button>-->
                                   
                                    <!--</div>-->
                                <input type="hidden" name="recaptcha_token" id="recaptcha_token_input">

                                    <div class="signin-banner-form-remember">
                                        <div class="row">
                                            <div class="">
                                                <div class="postbox__comment-agree">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="accept">
                                                        <label class="form-check-label" for="accept">I Accept All The
                                                            Terms & Conditions</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="signin-banner-from-btn mb-20 ">
                                        <input type="hidden" value="Signup" name="register_user">
                                        <button  onclick ="onClick(event);"type="submit" class="signin-btn btn-block" name=""
                                          id="add_user" style="cursor:not-allowed" disabled>Sign Up</button>
                                        <button onclick ="onClick(event);" type="submit" class="signin-btn btn-block" 
                                            id="processing" style="cursor:not-allowed;display:none;" disabled>Processing..</button>
                                    </div>

                                    <div class="signin-banner-from-register">
                                        <a href="JavaScript:void(0);" id="create">Already have an account ? <span
                                                id="returnn">Sign In</span></a>
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
     
    <!-- JS here -->
    

    <script src="<?php base_url('') ?>new-crm-assets//js/jquery.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/waypoints.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/bootstrap.bundle.min.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/slick.min.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/magnific-popup.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/counterup.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/wow.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/nice-select.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/swiper-bundle.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/meanmenu.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/tilt.jquery.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/isotope-pkgd.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/imagesloaded-pkgd.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/ajax-form.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/gsap.min.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/ScrollTrigger.min.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/ScrollSmoother.min.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/parallax-scroll.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/split-text.min.js"></script>
    <script src="<?php base_url('') ?>new-crm-assets//js/main.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/login.js"></script>

    <script>

        function showPassword(tag) {
            tag.type = (tag.type == 'password') ? 'text' : 'password';
        }

        $("#create").click(function () {
            $("#logup").show();
            $("#login").hide();
        });

        $("#returnn").click(function () {
            $("#login").show();
            $("#logup").hide();
        });

        var getData = "<?php if (isset($_GET['it'])) {
            echo $_GET['it'];
        } else {
            echo "0";
        } ?>";
        if (getData == 'signup') {
            $("#logup").show();
            $("#login").hide();
        }



    </script>
    <script type="text/javascript">

        $('#admin_email').val('');
        $('#msg').html('');
        setTimeout(function () { $('#msgDv').hide(); }, 5000);

    </script>
    <script type="text/javascript">

        $('#promo').val('');
        $('#msg1').html('');
        setTimeout(function () { $('').hide(); }, 5000);

    </script>
    <script type="text/javascript">

        function check(forthat = '', admin_email) {
            if (admin_email != '') {
                $.ajax({
                    url: "<?= site_url(); ?>login/checkemail",
                    method: "POST",
                    data: { admin_email: admin_email, forthat: forthat },
                    success: function (data) {
                        if (forthat == 'signup') {
                            $('#msg').html(data);
                            setTimeout(function () { $('#msg').html(''); }, 4000);
                        } else {
                            $('#msglog').html(data);
                            setTimeout(function () { $('#msglog').html(''); }, 4000);
                        }
                    }
                });
            }
        }


        $('#admin_email').change(function () {
            var admin_email = $('#admin_email').val();
            check('signup', admin_email);
        });
        $('#promo').change(function () {
            var admin_email = $('#promo').val();
            check('promocode', admin_email);
        });
        $('#email').change(function () {
            var admin_email = $('#email').val();
            check('login', admin_email);
        });


        function check_m() {
            var admin_mobile = $('#admin_mobile').val();
            if (admin_mobile != '' && admin_mobile.length == 10 && admin_mobile !=0000000000) {
                $.ajax({
                    url: "<?= site_url(); ?>login/checkmobile",
                    method: "POST",
                    data: { admin_mobile: admin_mobile },
                    success: function (data) {
                        $('#msg2').html(data);
                        setTimeout(function () { $('#msg2').html(''); }, 4000);
                    }
                });
            } else {
                $('#admin_mobile').closest('.brdrBtm').css('border-color', 'red');
                $('#admin_mobile').val('');
                $('#admin_mobile').focus();
                $('#admin_mobile').attr('placeholder', 'Enter Valid Mobile Number.');
                return false;
            }
        }




        function AllowOnlyNumbers(e) {
            e = (e) ? e : window.event;
            var clipboardData = e.clipboardData ? e.clipboardData : window.clipboardData;
            var key = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
            var str = (e.type && e.type == "paste") ? clipboardData.getData('Text') : String.fromCharCode(key);
            return (/^\d+$/.test(str));
        }

        function check_url() {
            var admin_url = $('#yourUrlname').val();
            if (admin_url != '') {
                $.ajax({
                    url: "<?= site_url(); ?>login/checkurl",
                    method: "POST",
                    data: { admin_url: admin_url },
                    success: function (data) {
                        $('#ptIcon').html(data);
                        setTimeout(function () { $('#ptIcon').html(''); }, 4000);
                    }
                });
            }
        }

        $("#add_user").click(function () {
            var promocode = $('#promo').val();
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var admin_email = $('#admin_email').val();
            var admin_mobile = $('#admin_mobile').val();
            var pass_s = $('#pass_s').val();
            var password = $('#password').val();
            var yourUrlname = $('#yourUrlname').val();


            if (first_name == "") {
                $('#first_name').closest('.brdrBtm').css('border-color', 'red');
                $('#first_name').focus();
                return false;
            } else if (admin_email == "") {
                $('#admin_email').closest('.brdrBtm').css('border-color', 'red');
                $('#admin_email').focus();
                return false;
            } else if (admin_email == "") {
                $('#promo').closest('.brdrBtm').css('border-color', 'red');
                $('#promo').focus();
                return false;
            } else if (admin_mobile == "" || !$.isNumeric(admin_mobile)) {
                $('#admin_mobile').closest('.brdrBtm').css('border-color', 'red');
                $('#admin_mobile').val('');
                $('#admin_mobile').focus();
                $('#admin_mobile').attr('placeholder', 'Only numbers allowed');
                return false;
            } else if (admin_mobile.length < 10) {
                $('#admin_mobile').closest('.brdrBtm').css('border-color', 'red');
                $('#admin_mobile').val('');
                $('#admin_mobile').focus();
                $('#admin_mobile').attr('placeholder', 'Enter Valid Mobile Number.');
                return false;
            } else if (pass_s == "") {
                $('#pass_s').closest('.brdrBtm').css('border-color', 'red');
                $('#pass_s').focus();
                return false;
            } else if (pass_s.length < 8) {
                $('#pass_s').closest('.brdrBtm').css('border-color', 'red');
                $('#pass_s').attr('Placeholder', 'Password strength must be greater than 8 character.');
                $('#pass_s').val('');
                $('#pass_s').focus();
                setTimeout(function () { $('#pass_s').closest('.brdrBtm').css('border-color', ''); }, 3000);
                return false;
            } else if (password == "" || pass_s != password) {
                $('#password').closest('.brdrBtm').css('border-color', 'red');
                $('#password').focus();
                $('#password').val('');
                $('#password').attr('Placeholder', 'Password did not match');
                setTimeout(function () { $('#password').closest('.brdrBtm').css('border-color', ''); }, 3000);
                return false;
            } else if (yourUrlname == "") {
                $('#yourUrlname').closest('.brdrBtm').css('border-color', 'red');
                $('#yourUrlname').focus();
                $('#yourUrlname').val('');
                $('#yourUrlname').attr('Placeholder', 'Enter URL name');
                setTimeout(function () { $('#yourUrlname').closest('.brdrBtm').css('border-color', ''); }, 3000);
                return false;
            } else {
                $("#add_user").hide();
                $("#processing").show();

                return true;
            }
        });


        $("#log_in").click(function () {
            var email = $('#email').val();
            var pass = $('#pass').val();
            if (email == "") {
                $('#email').closest('.brdrBtm').css('border-color', 'red');
                $('#email').focus();
                return false;
            } else if (pass == "") {
                $('#pass').closest('.brdrBtm').css('border-color', 'red');
                $('#pass').focus();
                return false;
            } else {
                return true;
            }
        });

        $(".form-control").keypress(function () {
            $(this).closest('.brdrBtm').css('border-color', '');
        });
var arrp=[];
function generateCaptcha() {
     arrp=[];
    var canvasElements = document.querySelectorAll(".captchaCanvas");
    
    canvasElements.forEach(function(canvas) {
        var ctx = canvas.getContext("2d");

        // Clear the canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Generate random text for the CAPTCHA (letters and numbers)
        var expectedCaptchaText = generateRandomString(5); // Change 6 to adjust the length of the CAPTCHA text
        if (canvas.hasAttribute("data-expectedtext")) {
            canvas.removeAttribute('data-expectedtext');
        }
        canvas.setAttribute('data-expectedtext', expectedCaptchaText);
       
       arrp.push(expectedCaptchaText);
       
      

        // Draw the background with lines and particles
        drawBackground(ctx, canvas.width, canvas.height);

        // Draw the CAPTCHA text on the canvas with overlapping and randomness
        var fontSize = 28;
        var fontName = "Arial";
        var centerY = canvas.height / 2;
        var textWidth = ctx.measureText(expectedCaptchaText).width;
        var x = (canvas.width - textWidth) /5.5;
        var y = centerY;
        var angle = -0.5;
        ctx.font = "bold " + fontSize + "px " + fontName;
        ctx.textBaseline = "middle";
        ctx.textAlign = "center";
        for (var i = 0; i < expectedCaptchaText.length; i++) {
            var gradient = ctx.createLinearGradient(x + fontSize * i, 0, x + fontSize * (i + 1), 0);
            gradient.addColorStop("0", getRandomColor());
            gradient.addColorStop("0.5", getRandomColor());
            gradient.addColorStop("1.0", getRandomColor());
            ctx.fillStyle = gradient;
            ctx.save();
            ctx.translate(x + fontSize * i, y + Math.sin(angle) * 15);
            ctx.rotate(Math.random() * 0.2 - 0.1);
            ctx.fillText(expectedCaptchaText.charAt(i), 0, 0);
            ctx.restore();
            angle += Math.PI / 8 + Math.random() * 0.2 - 0.1;
        }
    });

    // Callback function to indicate that generateCaptcha() has finished
    
}
function drawBackground(ctx, width, height) {
    // Draw lines
    ctx.beginPath();
    for (var i = 0; i < 3; i++) {
        ctx.moveTo(0, Math.random() * height);
        ctx.lineTo(width, Math.random() * height);
    }
    ctx.strokeStyle = getRandomColor();
    ctx.stroke();

    // Draw particles
    for (var i = 0; i < 150; i++) {
        ctx.beginPath();
        ctx.arc(Math.random() * width, Math.random() * height, Math.random() * 2, 0, Math.PI * 2);
        ctx.fillStyle = getRandomColor();
        ctx.fill();
    }
}

function generateRandomString(length) {
    var result = "";
    var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return result;
}

function getRandomColor() {
    return "rgb(" + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + ")";
}


function verifyCaptcha() {
   
    var userIn = $(".captchaInput");
    var expectedCaptchaTexts=arrp;

    var matchFound = false;
    for (var i = 0; i < expectedCaptchaTexts.length; i++) {
       var userInput = userIn.eq(i).val();
        if (userInput == expectedCaptchaTexts[i]) {
       
            matchFound = true;
       $(".captchanote").eq(i).html('Captcha Verified Successfully');
       $(".captchaInput").eq(i).css('display','none');
       $(".catcharow").eq(i).css('display','none');
        $(".captchanote").eq(i).css('color', 'green');
        $(".signinbtnsection").eq(i).css('display','block');
        $(".verifycaptchabtn").eq(i).css('display', 'none');
            break;
        }
        else{
             $(".captchanote").eq(i).html('Wrong Captcha!! Try again');
            $(".captchanote").eq(i).css('color', 'red');
            
        }
    }

     generateCaptcha();
}

// Generate initial CAPTCHA on page load
$(document).ready(function() {
    generateCaptcha();
});

// Refresh CAPTCHA when refresh button is clicked
$(".catcharefreshbtn").click(function(e) {
    e.preventDefault();
    generateCaptcha();
});

// Verify CAPTCHA when verify button is clicked
$(".verifycaptchabtn").click(function(e) {
    e.preventDefault();
    verifyCaptcha();
});




    </script>
       <script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('<?php echo $this->config->item('recaptcha_site_key');?>', {action: 'submit'}).then(function(token) {
             $("#recaptcha_token_input").val(token);
             
             $("#form").submit();
          });
        });
      }
  </script>
</body>

</html>