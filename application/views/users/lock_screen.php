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
        <div class="login_page" id="login">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login_img text-center"><?php 
                                    $imgArr=array('1.png','2.png','3.png','4.png');
                                    shuffle($imgArr);
                            ?>
                            <img src="<?=base_url();?>assets/login/<?=$imgArr[0];?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login_form">
                            <form class="form" method="post" autocomplete="off" action="<?= base_url('login/auth');?>" >
                                <div class="row">
                                    <div class="col-lg-12 login_top">
                                            <img src="<?=base_url();?>assets/img/logo-team_h.png">
                                            <h4><i class="fas fa-user-lock"></i> SCREEN LOCKED</h4>
                                           
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group brdrBtm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="hidden" name="lock" value="lockscreen" id="lock">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Username" value="<?=$this->session->userdata('email');?>" readonly>
                                        <div class="input-group-append">
                                        <span class="input-group-text" style="color: #cccccc; padding-right: 0; "id="msglog"></span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group brdrBtm">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input  type="password" class="form-control"  name="password" id="pass"  placeholder="Password">
                                        
                                      </div>
                                    </div>
                                    <div class="col-lg-12 form-group" style="color:#ccc;">
                                    <span id="msgDv" ><?= $this->session->flashdata('msg')?></span>
                                    </div>
                                    
                                    <div class="col-lg-12 login_bottom">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label><input type="checkbox" name="">Remember Me</label>
                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <input type="submit" name="log_in" id="log_in" class="btn btn-primary" value="Log In">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-right mt-3">
                                        <div class="row" style="color:#ccc;">
                                            <div class="col-lg-6 text-left">
                                                 <p>Switch Account? <a href="<?=base_url();?>login" id="create"> Click Here</a></p>
                                            </div>
                                            <div class="col-lg-6">
                                              <a href="<?= base_url('login/get_password_link')?>" id="#password">Forgot Password?</a></span>
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

        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?=base_url();?>/assets/js/login.js"></script>

    <script>
       
        
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
		setTimeout(function(){ $('#msgDv').hide(); },5000);
		
    </script>
    <script type="text/javascript">
   
      function check(forthat='',admin_email)
      {
        if(admin_email != '')
        {
          $.ajax({
           url: "<?= site_url(); ?>login/checkemail",
           method: "POST",
           data: {admin_email:admin_email,forthat:forthat},
           success: function(data)
            { if(forthat=='signup'){
              $('#msg').html(data);
			  setTimeout(function(){  $('#msg').html(''); },4000);
              }else{
              $('#msglog').html(data);
			  setTimeout(function(){  $('#msglog').html(''); },4000);
              }
            }
          });
        }
      } 
    
   
    $('#admin_email').change(function(){
        var admin_email = $('#admin_email').val();
        check('signup',admin_email);
    });
    
     $('#email').change(function(){
        var admin_email = $('#email').val();
        check('login',admin_email);
    }); 
      
      
      function check_m()
      {
        var admin_mobile = $('#admin_mobile').val();
        if(admin_mobile != '' &&  admin_mobile.length==10 && admin_mobile!=0000000000)
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
        }else{
            $('#admin_mobile').closest('.brdrBtm').css('border-color', 'red');
			$('#admin_mobile').val('');
			$('#admin_mobile').focus();
			$('#admin_mobile').attr('placeholder','Enter Valid Mobile Number.');
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
      
      function check_url()
      {
        var admin_url = $('#yourUrlname').val();
        if(admin_url != '')
        {
          $.ajax({
           url: "<?= site_url(); ?>login/checkurl",
           method: "POST",
           data: {admin_url:admin_url},
           success: function(data)
            {
              $('#ptIcon').html(data);
			  setTimeout(function(){  $('#ptIcon').html(''); },4000);
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
			$('#first_name').closest('.brdrBtm').css('border-color', 'red');
			$('#first_name').focus();
			return false;
		}else if(admin_email==""){
			$('#admin_email').closest('.brdrBtm').css('border-color', 'red');
			$('#admin_email').focus();
			return false;			
		}else if(admin_mobile=="" || !$.isNumeric(admin_mobile)){
			$('#admin_mobile').closest('.brdrBtm').css('border-color', 'red');
			$('#admin_mobile').val('');
			$('#admin_mobile').focus();
			$('#admin_mobile').attr('placeholder','Only numbers allowed');
			 return false;
		}else if(admin_mobile.length<10){
			$('#admin_mobile').closest('.brdrBtm').css('border-color', 'red');
			$('#admin_mobile').val('');
			$('#admin_mobile').focus();
			$('#admin_mobile').attr('placeholder','Enter Valid Mobile Number.');
			 return false;
		}else if(pass_s==""){
			$('#pass_s').closest('.brdrBtm').css('border-color', 'red');
			$('#pass_s').focus();
			return false;
		}else if(pass_s.length<8){
			$('#pass_s').closest('.brdrBtm').css('border-color', 'red');
			$('#pass_s').attr('Placeholder','Password strength must be greater than 8 character.');
			$('#pass_s').val('');
			$('#pass_s').focus();
			setTimeout(function(){$('#pass_s').closest('.brdrBtm').css('border-color', '');},3000);
			return false;
		}else if(password=="" || pass_s!=password){
			$('#password').closest('.brdrBtm').css('border-color', 'red');
			$('#password').focus();
			$('#password').val('');
			$('#password').attr('Placeholder','Password did not match');
			setTimeout(function(){$('#password').closest('.brdrBtm').css('border-color', '');},3000);
			return false;
		}else{
			return true;
		}
	});  
	
	
	$("#log_in").click(function(){
    		var email  = $('#email').val();
    		var pass   = $('#pass').val();
    	   if(email==""){
    			$('#email').closest('.brdrBtm').css('border-color', 'red');
    			$('#email').focus();
    			return false;
    		}else if(pass==""){
    			$('#pass').closest('.brdrBtm').css('border-color', 'red');
    			$('#pass').focus();
    			return false;			
    		}else{
    			return true;
    		}
	});  
	
	$(".form-control").keypress(function(){
		$(this).closest('.brdrBtm').css('border-color', '');
	});

	  
    </script>
    </body>
    </html>