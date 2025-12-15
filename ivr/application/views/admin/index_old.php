<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="<?= base_url();?>assets/images/favicon.png">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
   
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/responsive.css">
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/rand.bg.css">
    
    <title>Team365 | Login</title>
  </head>

  <body class="randbg" >

    <!----------login form--------->
    <div class="login-form" id="log">
      <div class="container">
        <div class="inner-form">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
              <div class="left-side">
                <img src="<?php echo base_url();?>assets/images/new.png" class="img-fluid">
                <p>© 2020, Allegient Unified Technology Pvt. Ltd. All Rights Reserved.</p>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
              <div class="right-side">
                <h2>Login to your account</h2>
                <form class="" method="post" action="<?php echo base_url('home');?>">
                  <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email" data-toggle="tooltip" title="Email">
                  </div>
                  <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" data-toggle="tooltip" title="Password">
                  </div>
                  <div class="form-group">
                    <a href="password_reset.html">Forgot Password?</a>
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-default" value="Login">
                  </div>
                  <div class="form-group text-center">
                    <p>Don't have a Team365 account? <a href="javascript:void(0);" id="new-create"> Sign up</a></p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>    

    <!----------Signup form--------->

    <div class="Signup-form" id="sign">
      <div class="container">
        <div class="inner-form">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
              <div class="left-side">
                <img src="<?php echo base_url();?>assets/images/new.png" class="img-fluid">
                <p>© 2020, Allegient Unified Technology Pvt. Ltd. All Rights Reserved.</p>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
              <div class="right-side">
                <h2>Start with your free account today</h2>
                <form class="" method="post">
                  <div class="container">
                    <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="name">First Name:</label>
                          <input type="text" class="form-control" id="">
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="name">Last Name:</label>
                          <input type="text" class="form-control" id="">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="email">Email:</label>
                          <input type="email" class="form-control" id="">
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="mobile number">Mobile No.:</label>
                          <input type="text" class="form-control" id="">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="password">Password:</label>
                          <input type="password" class="form-control" id="">
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="password">Confirm Password:</label>
                          <input type="password" class="form-control" id="">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <input type="checkbox"> <span>I Accept All The Terms & Conditions.</span>
                    </div>

                    <div class="form-group">
                      <input type="button" class="btn btn-default" value="Signup">
                    </div>

                    <div class="form-group text-center">
                      <a href="javascript:void(0);" id="return"><-- Back</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> 


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/rand.bg.js"></script>
    <!-- Optional JavaScript -->
    <script>
      $(".randbg").RandBG();
    </script>
    <script type="text/javascript">
   
    	$(document).ready(function(){
    		$("#log").show();
    		$("#sign").hide();
    	});
    	
    	$("#new-create").click(function(){
    		$("#sign").show();
    		$("#log").hide();
    	});

      $("#return").click(function(){
        $("#log").show();
      });		
    </script>

    <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>
  </body>
</html>