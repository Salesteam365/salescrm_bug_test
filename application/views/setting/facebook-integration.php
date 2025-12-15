<?php $this->load->view('common_navbar');?>
<style>
.timeIc{ color: #18a2b8;
    margin: 2px;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Facebook Integration</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Facebook Integration</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
            <div class="card org_div">
              <div class="card-body" id="countSearch">
               <div class="container">
                   
					<form method="post" class="ajax_form" id="idAddData" action="" onsubmit="return false;" novalidate="novalidate" autocomplete="off">
					

						<input type="hidden" name="TYPE" value="Facebook_ads_lead">
						<textarea style="display: none;" name="FACEBOOK_ACCESS_TOKEN" id="FACEBOOK_ACCESS_TOKEN"></textarea>
						<input type="hidden" name="FACEBOOK_PAGE_ID" id="FACEBOOK_PAGE_ID" value="">
						<input type="hidden" name="FACEBOOK_FORM_ID" id="FACEBOOK_FORM_ID" value="">
						<input type="hidden" name="FACEBOOK_FORM_NAME" id="FACEBOOK_FORM_NAME" value="">
						<input type="hidden" name="FACEBOOK_FORM_STATUS" id="FACEBOOK_FORM_STATUS" value="">

						
						<div class="row">
							<h2 class="title iq-fw-8"> Facebook/Instagram Ads Leads Integration</h2>
						</div>
						<br>

						<!--<div class="row">-->
						<!--	<h4 class="title iq-fw-8">1. Title</h4>-->
						<!--</div>-->
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label>Title<span style="color: #f76c6c;">*</span></label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="TITLE" value="" placeholder="Title" required="">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<h6 class="title iq-fw-1" style="font-size: 17px;"><b>A. Facebook App Details</b></h6>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label>Facebook Api Version<span style="color: #f76c6c;">*</span></label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<select name="FB_API_VERSION" id="FB_API_VERSION" class="form-control no_of_users" style="width: 95px !important;padding-right: 0">
										<option value="v10.0">v10.0</option>
										<option value="v9.0">v9.0</option>
										<option value="v8.0">v8.0</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label>APP Secret<span style="color: #f76c6c;">*</span></label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="FACEBOOK_APP_SECRET" id="FACEBOOK_APP_SECRET" value="" placeholder="Facebook App Secret" required="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<label>APP ID<span style="color: #f76c6c;">*</span></label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="FACEBOOK_APP_ID" id="FACEBOOK_APP_ID" value="" placeholder="Facebook App ID" required="">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<a class="button get-facebook-column" href="javascript:;" style="margin-left: 35%;">
										<div class="first btn-info" style="font-size: 16px;line-height: 35px;width: 15%;text-align: center;">Connect</div>
									</a>
								</div>
							</div>
						</div>
						<div class="row">

							<div class="col-md-3">
								<h6 class="title iq-fw-1" style="font-size: 17px;"><b>B. List of pages in your App</b></h6>
							</div>
							<div class="col-md-4">
								<ul id="lists"></ul>
							</div>

						</div>

						<div class="row div-to-get-form-fields" style=";">
							<div class="col-lg-12">
								<div class="row" style="margin: 17px 0px;">
									<div class="col-md-3">
										<h6 class="title iq-fw-1" style="font-size: 17px;"><b>C. Send test lead from facebook</b></h6>
									</div>
									<div class="col-md-9">
										<a href="https://developers.facebook.com/tools/lead-ads-testing/"><u>https://developers.facebook.com/tools/lead-ads-testing/</u></a>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="row" style="margin: 17px 0px;" >
									<div class="col-md-3">
										<h6 class="title iq-fw-1" style="font-size: 17px;"><b>D. Get lead form fields</b></h6>
									</div>
									<div class="col-md-4">
										<a class="button get-form-fields" href="javascript:;">
											<div class="first btn-info" style="font-size: 14px;line-height: 35px;    width: 35%;text-align: center;">Get Test  Data</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				
              </div>
            </div>
      </div>
    </section>
  </div>
</div>


<div class="modal fade profile_popup" id="newownermodal"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Facebook Lead</h6>
        <button type="button" class="close clsMdl" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row form-group">
          <div class="col-lg-12 text-center" id="putData">
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- common footer include -->
<?php $this->load->view('common_footer');?>



<script>

$(document).on("click", ".get-facebook-column", function (e) {
	var FACEBOOK_APP_ID = $('#FACEBOOK_APP_ID').val();
	//console.log("FACEBOOK_APP_ID" + FACEBOOK_APP_ID);

	// inject sdk.js
	(function (d, script) {
		script = d.createElement("script");
		script.type = "text/javascript";
		script.async = true;
		script.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0&appId=" + FACEBOOK_APP_ID + "&autoLogAppEvents=1";
		d.getElementsByTagName("head")[0].appendChild(script);
	})(document);

	setTimeout(function () {
		myFacebookLogin();
	}, 1000);

	return false;
});

$(document).on("click", ".get-form-fields", function (e) {
	var FACEBOOK_ACCESS_TOKEN = $('#FACEBOOK_ACCESS_TOKEN').val();
	var FACEBOOK_APP_ID = $('#FACEBOOK_APP_ID').val();
	var FACEBOOK_PAGE_ID = $('#FACEBOOK_PAGE_ID').val();
	var FB_API_VERSION = $('#FB_API_VERSION').val();

	if (FACEBOOK_PAGE_ID && FACEBOOK_PAGE_ID != '') {
	    FB.api('/'+ FACEBOOK_PAGE_ID +'/leadgen_forms?access_token='+FACEBOOK_ACCESS_TOKEN,
          'GET',
          {},
          function(response) {
              
            var pages = response.data;
            
            //console.log(pages);
            var len = pages.length;
            var ul = document.getElementById('list');
            for (var i = 0;  i < len; i++) {
              var page = pages[i];
                FB.api('/'+page.id+'/leads',
                  'GET',
                  {},
                  function(result) {
                     // console.log('result-data'+result);
                    var formData=result.data;
                    
                   // console.log('From-id'+formData);
                    for (var j = 0, tm = formData.length; j< tm; j++) {
                        var created_date=formData[j].created_time;
                        var SecodForLoop=formData[j].field_data;
                        //console.log(SecodForLoop);
                       for (var k = 0, fld = SecodForLoop.length; k< fld; k++) {
                           if(SecodForLoop[k].name=='FULL_NAME' || SecodForLoop[k].name=='full_name'){
                               var fullName=SecodForLoop[k].values[0];
                           }
                           
                           if(SecodForLoop[k].name=='PHONE' || SecodForLoop[k].name=="phone_number"){
                               var phone=SecodForLoop[k].values[0];
                           }
                           
                            if(SecodForLoop[k].name=="EMAIL" || SecodForLoop[k].name=='email'){
                               var email=SecodForLoop[k].values[0];
                           }
                           
                            if(SecodForLoop[k].name=="JOB_TITLE" || SecodForLoop[k].name=='job_title'){
                               var jobTitle=SecodForLoop[k].values[0];
                           }
                           
                            if(SecodForLoop[k].name=="COMPANY_NAME" || SecodForLoop[k].name=='company_name'){
                               var company=SecodForLoop[k].values[0];
                           } 
                           
                           if(SecodForLoop[k].name=="CITY" || SecodForLoop[k].name=='city'){
                               var city=SecodForLoop[k].values[0];
                           } 
                          
                     }
                      //console.log('name:'+fullName+', email: '+email+', phone: '+phone+', jobTitle: '+jobTitle+', company: '+company+', City: '+city+', Date: '+created_date)
                        
                     
                     $("#newownermodal").modal('show');
                     $("#putData").html('<table><tr><td>Full Name</td><td>'+fullName+'</td></tr> <tr><td>Email</td><td>'+email+'</td></tr> <tr><td>Phone</td><td>'+phone+'</td></tr> <tr><td>Job Title</td><td>'+jobTitle+'</td></tr> <tr><td>Company</td><td>'+company+'</td></tr> <tr><td>City</td><td>'+city+'</td></tr> <tr><td>Date</td><td>'+created_date+'</td></tr> </table>');
                     
                    }
                    
                  }
                );
            }
          }
        );
	}
	    
});    
	/*	$.ajax({
			type: 'POST',
			//headers: $myheader,
			url: $myurl + 'dashboard/facebook-column',
			data: JSON.stringify({
				FACEBOOK_ACCESS_TOKEN: FACEBOOK_ACCESS_TOKEN,
				FACEBOOK_APP_ID: FACEBOOK_APP_ID,
				FACEBOOK_PAGE_ID: FACEBOOK_PAGE_ID,
				FB_API_VERSION: FB_API_VERSION,
			}),
			contentType: 'application/json',
			beforeSend: function (xhr) {
				// console.log("this.data", this.data);
			},
			success: function (data) {
				// console.log("form data", data);
				if (data.status == "200") {
					$('#FACEBOOK_FORM_ID').val(data.form_id);
					$('.append_body').html(data.fields);
				} else {
					show_notify_toastr("error", "", data.message);
				}
			},
			error: function (data) {
				show_notify_toastr("error", "Server side error.", "Something went wrong.");
			}
		});
	} else {
		show_notify_toastr("error", "", "Please Enter Facebook Page ID");
	}
	return false;
});
*/

function addWebHook() {

    var FACEBOOK_APP_ID         = $('#FACEBOOK_APP_ID').val();
	var FACEBOOK_APP_SECRET     = $('#FACEBOOK_APP_SECRET').val();
	var FACEBOOK_ACCESS_TOKEN   = $('#FACEBOOK_ACCESS_TOKEN').val();
	var FACEBOOK_PAGE_ID        = $('#FACEBOOK_PAGE_ID').val();
	var FB_API_VERSION          = $('#FB_API_VERSION').val();


	// https://graph.facebook.com/oauth/access_token
	// 		?client_id={your-app-id}
	// 	&client_secret={your-app-secret}
	// 	&grant_type=client_credentials

	FB.api('/oauth/access_token?client_id=' + FACEBOOK_APP_ID + '&client_secret=' + FACEBOOK_APP_SECRET + '&grant_type=client_credentials', function (response) {
			// console.log("access_token response", response);

			FB.api('/' + FACEBOOK_APP_ID + '/subscriptions',
				'post',
				{
					access_token: response.access_token,
					object: 'page',
					fields: 'leadgen',
					verify_token: 'abc123',
					// callback_url: MY_SUB_DOMAIN + 'advance/facebook-webhook.php?app_id=' + FACEBOOK_APP_ID,
					callback_url: 'https://allegient.team365.io/webhooks',
				},
				function (response) {
					// console.log("addWebHook response", response);
					if (response.success === true) {
						$('.div-to-get-form-fields').show();

						//show_notify_toastr("success", "", "Now First send test lead from given url.");
					}
				}
			)
		})

	// FB.api('/'+app_id+'/subscriptions?access_token=',

    if (FACEBOOK_PAGE_ID && FACEBOOK_PAGE_ID != '') {
	    FB.api('/'+ FACEBOOK_PAGE_ID +'/leadgen_forms?access_token='+FACEBOOK_ACCESS_TOKEN,
          'GET',
          {},
          function(response) {
              var pages = response.data;
             console.log(pages);
              var len = pages.length;
             for (var i = 0;  i < len; i++) {
              var page = pages[i];
               $("#FACEBOOK_FORM_ID").val(page.id);
               $("#FACEBOOK_FORM_NAME").val(page.name);
               $("#FACEBOOK_FORM_STATUS").val(page.status);
               if(page.status=='ACTIVE'){
                addDeatil();
               }
             }
         
     }
    )}
}


function addDeatil(){
    
    var FACEBOOK_APP_ID         = $('#FACEBOOK_APP_ID').val();
	var FACEBOOK_APP_SECRET     = $('#FACEBOOK_APP_SECRET').val();
	var FACEBOOK_ACCESS_TOKEN   = $('#FACEBOOK_ACCESS_TOKEN').val();
	var FACEBOOK_PAGE_ID        = $('#FACEBOOK_PAGE_ID').val();
	var FB_API_VERSION          = $('#FB_API_VERSION').val();
    var FACEBOOK_FORM_ID        = $("#FACEBOOK_FORM_ID").val();
    var FACEBOOK_FORM_NAME      = $("#FACEBOOK_FORM_NAME").val();
    var FACEBOOK_FORM_STATUS    = $("#FACEBOOK_FORM_STATUS").val();
    var dataString = $("#idAddData").serialize();
    $.ajax({
        url : "<?= site_url('setting/addfbdata')?>",
        type: "POST",
        data: dataString,
        dataType: "JSON",
        success: function(data){
            if(data.status){
                $("#newownermodal").modal('show');
                $("#putData").html('<img src="<?= site_url('assets/img/')?>tick-icon.png" style="margin-bottom: 25px;"><span style="display: block;">Your facebook App has been subscribed successfully. <br> <text style="font-size: 20px;font-weight: 700;">Note:</text>  If you have any problem getting lead contact our support team.</span>');

            }else{
                 $("#newownermodal").modal('show');
                $("#putData").html('<img src="<?= site_url('assets/img/')?>cross-icon.png" style="margin-bottom: 25px;"><span style="display: block;">Something went wrong. <br> <text style="font-size: 20px;font-weight: 700;">Note:</text>  If you have any problem getting lead contact our support team.</span>');
            }
        }
    });
    
}
 

function getLongLivedUsersAccessToken(page_access_token) {

	var FACEBOOK_APP_ID = $('#FACEBOOK_APP_ID').val();
	var FACEBOOK_APP_SECRET = $('#FACEBOOK_APP_SECRET').val();

	FB.api('/oauth/access_token?grant_type=fb_exchange_token&client_id=' + FACEBOOK_APP_ID + '&client_secret=' + FACEBOOK_APP_SECRET + '&fb_exchange_token=' + page_access_token, function (response) {
			// console.log("getLongLivedUsersAccessToken response", response);
			// console.log("getLongLivedUsersAccessToken response.access_token", response.access_token);

			$('#FACEBOOK_ACCESS_TOKEN').val(response.access_token);
console.log("never expire access token", response);
			addWebHook();
			if (response.access_token) {

				FB.api('/me/accounts?access_token=' + response.access_token, function (response) {
						// console.log("never expire access token", response);
					}
				)

			}
		}
	)
}

function subscribeApp(page_id, page_access_token) {
//	console.log("subscribeApp page_id", page_id);
	FB.api('/' + page_id + '/subscribed_apps',
		'post',
		{access_token: page_access_token, subscribed_fields: 'leadgen'},
		function (response) {
			// console.log("subscribeApp response", response);
			if (response.success === true) {
				$('#FACEBOOK_PAGE_ID').val(page_id);
				getLongLivedUsersAccessToken(page_access_token);
			}
		}
	)

}


function myFacebookLogin() {
	FB.login(function (response) {
	//	console.log("login success", response);
		FB.api('/me/accounts', function (response) {
			// console.log("list of pages", response);
			var pages = response.data;
			var ul = document.getElementById('lists');
			for (var i = 0; i < pages.length; i++) {
				var page = pages[i];
				var li = document.createElement('li');
				var span = document.createElement('span');
				var a = document.createElement('a');

				span.innerHTML = page.name + " &nbsp;&nbsp;&nbsp;&nbsp;";
				a.href = "javascript:;";
				a.onclick = subscribeApp.bind(this, page.id, page.access_token);
				a.innerHTML = '<button class="btn btn-info" style="width: 40%;    font-size: 14px;margin: 0 0 10px 0;">Click To Subscribe</button>';
				span.appendChild(a);
				li.appendChild(span);
				ul.appendChild(li);
			}
		});
	}, {scope: 'leads_retrieval'})
}
</script>









