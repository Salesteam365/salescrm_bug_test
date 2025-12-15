<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta Tags -->

    <!-- Style-sheets -->
    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Bootstrap Css -->
    <!-- Fontawesome Css -->
    <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>plugins/fontawesome-free/css/all.min.css">
    <!--// Fontawesome Css -->
    <link href="https://fonts.googleapis.com/css?family=Baloo+2:400,700&display=swap" rel="stylesheet">

  </head>

  <style>
*{
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		font-family: 'Baloo 2', cursive;
}
.head {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-image: url(assets/dist/img/bg-img.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}
.head .login-form {
    background: #f1f8fe9c;
    padding: 50px 30px;
    box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.18);
    border-radius: 10px;
}
    .head .login-form h1 {
      color: #0dbe90;
      font-weight: 700;
      margin-bottom: 20px;
      letter-spacing: .9px;
    }
.head .login-form .form-check {
    margin: 25px 0;
}
    .head .login-form .form-control {
    border: 0;
    background: none;
    border-bottom: 1px solid #9e9e9e;
    border-radius: 0;
    padding: 15px 0;
}

	.head .login-form .form-control:focus {
	    outline: 0;
	    box-shadow: none;
	}
    .head .login-form .form-check .forgot a {
      color: #000;
      font-weight: 500;
      font-size: 14px;
      text-decoration: none;
    }


    .head .login-form .form-check .form-check-label {
      font-size: 14px;
      font-weight: 500;
    }
    .head .login-form button {
    background: rgb(98, 195, 238);
    color: #fff;
    border: 0;
    margin: 10px auto 0;
    display: block;
    padding: 10px 50px;
    border-radius: 0;
    font-weight: 500;
	}

	.head .login-form button:not(:disabled):not(.disabled):active {
    background: #62c3ee;
    border: 0;
    box-shadow: none;
}
    .footer-form p {
      margin: 20px 0 5px;
      font-weight: 400;
      font-size: 14px;
    }
    .footer-form a {
      color: rgb(0, 0, 0);
      font-weight: 600;
      font-size: 14px;
      text-decoration: none;
    }

    .footer-form .back:before {
    content: '\f30a';
    font-family: "Font Awesome 5 Free";
    font-size: 20px;
    color: #000;
    vertical-align: middle;
    margin-right: 5px;
}
  </style>
  <body>
    <div class="head">
      <div class="container">
        <div class="row">
        	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        		<form class="login-form animated slideInDown" action="<?= site_url('home')?>">
                <div class="container">
                  <h1 class="text-center">Welcome To Admin</h1>
                  <div class="form-group">
                    <!-- <label for="exampleInputEmail1">Email address</label> -->
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Your Email Address">
                  </div>
                  <div class="form-group">
                    <!-- <label for="exampleInputPassword1">Password</label> -->
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Your Password">
                  </div>
                  <div class="form-check">
                    <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                        <div class="forgot">
                          <a href="#">Forgot password</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <div class="footer-form text-center">
                    <div class="container">
                      <p>Don't have an account <a href="#">Create an account</a></p>
                      <a href="#" class="back">Back To Home</a>
                    </div>
                  </div>
                </div>
              </form>
          	</div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              
            </div>
        </div>
      </div>
    </div>
    
    <!-- Required common Js -->
    <script src="<?php echo base_url()."assets/"; ?>plugins/jquery/jquery.min.js"></script>
    <!-- //Required common Js -->

    <!-- Js for bootstrap working-->
    <script src="<?php echo base_url()."assets/"; ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- //Js for bootstrap working -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

  </body>
</html>