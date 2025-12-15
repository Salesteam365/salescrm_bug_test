
<!-- The alert modal -->
<div class="modal fade" id="alert_popup" style="z-index:99999">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
<!--         <h4 class="modal-title">Modal Heading</h4> -->
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p id="common_popupmsg"><i class="fas fa-check-square"></i>Payment Option Is Now Enabled</p>
      </div>
    </div>
  </div>
</div>
<!-- The alert modal -->


<!-- The alert modal -->
<div class="modal fade" id="delete_confirmation" style="z-index:99999">
  <div class="modal-dialog">
    <div class="modal-content">
      <div style="padding-right: 10px; padding-top: 5px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div id="itmDiv">
      <div class="modal-body text-center">
        <p><i class="far fa-question-circle" style="font-size: 30px; color: #d88ba7c4;" ></i></p>
        <p>Are you sure, You want to delete this item?</p>
      </div>
      <div class="modal-body text-center">
        <button class="btn btn-secondary" data-dismiss="modal" style="margin-right: 20%;">No</button>
        <button class="btn btn-danger" id="confirmed" >Yes</button>
      </div>
      </div>
      <div id="itmDivMsg" style="display:none;">
          
        <div class="modal-body text-center">
            <p><i class="far fa-check-circle" style="font-size: 30px; color: #d88ba7c4;" ></i></p>
            <p>Your item has been deleted successfully.</p>
        </div>
          
      </div>   
      
    </div>
  </div>
</div>
<!-- The alert modal -->


<!-- modal -->

<div class="modal fade" id="opportunity-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0">Opportunity Notification</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-lg-4 col-md-4 col-6">
            <div class="first-one">
              <select class="form-control">
              <option selected disabled>Select Option</option>
              <option>Last 15 days</option>
              <option>Last 30 days</option>
              <option>Last 45 days</option>
              <option>Last 60 days</option>
              <option>Last 75 days</option>
              <option>Last 100 days</option>
            </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-3"></div>
          <div class="col-lg-4 col-md-4 col-3">
             <div class="refresh-button float-right">
               <button class="btn btn-info btn-sm">
                 <i class="fas fa-redo"></i>
               </button>
             </div>
          </div>
        </div>

        <table class="table table-bordered table-responsive-lg">
        <thead>
          <tr>
            <th>Serial No</th>
            <th>Product Name</th>
            <th>Company Name</th>
            <th>Vendor</th>
            <th>Price</th>
            <th>---</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>OPP/2020/957</td>
            <td>Proposal for Adobe renewal</td>
            <td>Morphogenesis</td>
            <td>Aarti</td>
            <td>1061100.00</td>
            <td><button class="btn btn-info btn-sm">Update</button></td>
          </tr>
          
        </tbody>
      </table>
      </div>
      <!--Footer-->
      <!-- <div class="modal-footer flex-center">
        <a href="#" class="btn btn-info">Yes</a>
        <a type="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">No</a>
      </div> -->
    </div>
    <!--/.Content-->
  </div>
</div>

<!-- modal -->


<!-- modal 2 -->
  <div class="modal fade" id="salesorder-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0">Opportunity Notification</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-lg-4 col-md-4 col-6">
            <div class="first-one">
              <select class="form-control">
              <option selected disabled>Select Option</option>
              <option>Last 15 days</option>
              <option>Last 30 days</option>
              <option>Last 45 days</option>
              <option>Last 60 days</option>
              <option>Last 75 days</option>
              <option>Last 100 days</option>
            </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-3"></div>
          <div class="col-lg-4 col-md-4 col-3">
             <div class="refresh-button float-right">
               <button class="btn btn-info btn-sm">
                 <i class="fas fa-redo"></i>
               </button>
             </div>
          </div>
        </div>

        <table class="table table-bordered table-responsive-lg">
        <thead>
          <tr>
            <th>SO ID</th>
            <th>Subject</th>
            <th>Organization Name </th>
            <th>SO Owner</th>
            <th>Total Amount</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
         <tr>
           <td>--</td>
           <td>--</td>
           <td>--</td>
           <td>--</td>
           <td>--</td>
           <td>--</td>
         </tr>
        </tbody>
      </table>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- modal 2 -->

<!-- modal 3 -->
  <div class="modal fade" id="renewal-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0">Opportunity Notification</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <table class="table table-bordered table-responsive-lg">
        <thead>
          <tr>
            <th>PO ID</th>
            <th>Subject</th>
            <th>Customer Name </th>
            <th>Renewal Date</th>
            <th>Action</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
         <tr>
           <td>PO/2020/641</td>
           <td>SO of Easeus Todo</td>
           <td>Suzlon –One Earth</td>
           <td>2020-07-17</td>
           <td><button class="btn btn-info btn-sm">View</button></td>
           <td><button class="btn btn-danger btn-sm">End</button></td>
         </tr>
        </tbody>
      </table>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- modal 3 -->

<!-- modal 4 -->
  <div class="modal fade" id="dailyreport-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0">Daily Report</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!--Body-->
      <div class="modal-body">
        
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- modal 4 -->

<!-- modal 5 -->
  <div class="modal fade" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0">Edit Profile</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <form action="#" id="" class="form-horizontal" enctype="" method="">
          <div class="form-body form-row">
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Name" value="">
            </div>
            <div class="col-md-6 mb-3">
              <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Email" value="">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control form-control-sm" name="company_contact" id="company_contact" placeholder="Company Contact" value="">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control form-control-sm" name="country" id="country" placeholder="Country" value="">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control form-control-sm" name="state" id="state" placeholder="State" value="">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control form-control-sm" name="city" id="city" placeholder="City" value="">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control form-control-sm" name="address" id="address" placeholder="Address" value="">
            </div>
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control form-control-sm" name="zipcode" id="zipcode" placeholder="Zipcode" value="">
            </div>
            <div class="col-md-7 mb-3">
              <label>Upload Company logo
              <input type="file" name=""></label>
            </div>
            <div class="col-md-5 mb-3">
              <button class="btn btn-info">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- modal 5 -->

<!-- modal 6 -->
  <div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0">Add User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <form action="#" id="form" class="form-horizontal" enctype="" method="">
          <div class="form-body form-row">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="first_name" id="" placeholder="First Name">
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="last_name" id="" placeholder="Last Name">
            </div>
            <div class="col-md-6 mb-3">
                <input type="email" class="form-control form-control-sm" name="standard_email" id="" placeholder="Email">
            </div>
            <div class="col-md-6 mb-3">
                <input type="tel" class="form-control form-control-sm" name="standard_mobile" id="" placeholder="Mobile">
            </div>
            <div class="col-md-6 mb-3">
                <input type="password" class="form-control form-control-sm" id="" placeholder="Password">
            </div>
            <div class="col-md-6 mb-3">
                <input type="password" class="form-control form-control-sm" name="standard_password" id="" placeholder="Confirm Password">
            </div>
            <div class="col-md-6 mb-3">
                <select class="form-control form-control-sm" name="license_type">
                    <option>License Type</option>
                    <option>Basic</option>
                    <option>Business</option>
                    <option>Enterprise</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
              <button class="btn btn-info btn">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- modal 6 -->



<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content text-center">
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0">Buy CRM Now</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="form-body form-row">
              <div class="col-md-12 mb-3 text-center">
              <i class="fas fa-exclamation-triangle" style="color: #f59393; font-size: 28px;"></i>
              </div>
            <div class="col-md-12 mb-3 text-center">
              You are not paid user yet.&nbsp;&nbsp;To buy CRM click bellow button.
            </div>
            <div class="col-md-12 mb-3 text-center">
              <a href="https://team365.io/pricing"><button class="btn btn-info">Buy Now</button></a>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="informationModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content text-center">
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0">Buy CRM Now</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="form-body form-row">
              <div class="col-md-12 mb-3 text-center">
              <i class="fas fa-exclamation-triangle" style="color: #f59393; font-size: 28px;"></i>
              </div>
            <div class="col-md-12 mb-3 text-center">
              You are now using trial account.<br>
			  <text id="putinfoForCust"></text><br>
			  Please upgrade your plan to click bellow button.
            </div>
            <div class="col-md-12 mb-3 text-center">
              <a href="https://team365.io/pricing"><button class="btn btn-info">Buy Now</button></a>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- jQuery UI 1.11.4 -->
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Bootstrap 4 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()."assets/"; ?>plugins/chart.js/Chart.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url()."assets/"; ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url()."assets/"; ?>plugins/moment/moment.min.js"></script>
<!-- apex  chart-->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Canvas  chart-->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="<?php echo base_url()."assets/"; ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url()."assets/"; ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url()."assets/"; ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()."assets/"; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()."assets/"; ?>js/team.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo DASHBOARD_JS; ?>"></script>
<script>
localStorage.setItem("company_name", "<?=$this->session->userdata('company_name');?>");
localStorage.setItem("company_email", "<?=$this->session->userdata('company_email');?>");
localStorage.setItem("email", "<?=$this->session->userdata('email');?>");
</script>
<script src="<?php echo base_url('assets/js/validation.js') ?>"></script>
<!-- datatable js -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script src="<?php echo base_url()."assets/"; ?>js/milestones.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>


<button type="button" data-toggle="tooltip" title="Enter your feedback" class="btn btn-default btn-circle ripple open-button" onclick="openForm()" ><i class="far fa-comment-alt"></i></button>

<div class="chat-popup" id="myForm">
	<form action="#" class="form-container">
		<h1>Feedback Form</h1>
		<label for="msg"><b>Feedback</b></label>
		<textarea placeholder="Enter your feedback" name="feedbackMessage" id="feedbackMessage" required></textarea>
		<button type="button" class="btn" id="sendFeedback">Send</button>
		<button type="button" class="btn cancel" onclick="closeForm()">Close</button>
	</form>
</div>

<script>

$(document).ready(function(){
            var submitIcon = $('.searchbox-icon');
            var inputBox = $('.searchbox-input');
            var searchBox = $('.searchbox');
            var isOpen = false;
            submitIcon.click(function(){
                if(isOpen == false){
                    searchBox.addClass('searchbox-open');
                    inputBox.focus();
                    isOpen = true;
                } else {
                    searchBox.removeClass('searchbox-open');
                    inputBox.focusout();
                    isOpen = false;
                }
            });  
             submitIcon.mouseup(function(){
                    return false;
                });
            searchBox.mouseup(function(){
                    return false;
                });
            $(document).mouseup(function(){
                    if(isOpen == true){
                        $('.searchbox-icon').css('display','block');
                        submitIcon.click();
                    }
                });
});
		
            function buttonUp(){
                var inputVal = $('.searchbox-input').val();
                inputVal = $.trim(inputVal).length;
                if( inputVal !== 0){
                    $('.searchbox-icon').css('display','none');
                } else {
                    $('.searchbox-input').val('');
                    $('.searchbox-icon').css('display','block');
                }
            }
			
			

$("#searchBtn").click(function(){
	var search=$("#searchbox").val();
	if(search!=""){
		window.location.href = '<?=base_url();?>search?q='+search;
	}else{
		toastr.error('Please enter keyword');
	}
});
$('#searchbox').keypress(function (e) {
  if (e.which == 13) {
    var search=$("#searchbox").val();
	if(search!=""){
		window.location.href = '<?=base_url();?>search?q='+search;
	}else{
		toastr.error('Please enter keyword');
	}
  }
});

function infoModal(mesg) {
  $("#putinfoForCust").html(mesg);
  $("#informationModel").modal('show');
  
}
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}

$("#sendFeedback").click(function(){
	var url = "<?= base_url('notification/send_notification')?>";
	toastr.info('Please wait...');
	var feedbackMessage = $("#feedbackMessage").val();
	if(feedbackMessage!=""){
		$("#sendFeedback").hide();
		document.getElementById("myForm").style.display = "none";
		$.ajax({
			url : url,
			type: "POST",
			data: "feedback=data&feedbackMessage="+feedbackMessage,
			success: function(response)
			{ 
				toastr.success('Feedback sent successfully.');	  
				document.getElementById("myForm").style.display = "none";
				$("#sendFeedback").show();
			}
		});
	}else{
		toastr.warning('Please enter feedback');
	}
});
</script>

<script>
$(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
});
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<script>

function add_modal(){
    $("#addModal").modal('show');
}

function deleteBulkItem(hiturl){
     var checkbox = $('.delete_checkbox:checked');
        if(checkbox.length > 0)
        { 
           var checkbox_value = [];
           $(checkbox).each(function(){
            checkbox_value.push($(this).val());
           });
           $.ajax({
            url:"<?= base_url(); ?>"+hiturl,
            method:"POST",
            data:{checkbox_value:checkbox_value},
            success:function(dataResult)
            {
                 console.log(dataResult);
               $("#itmDiv").hide();
               $("#itmDivMsg").show();
               table.ajax.reload();
			   $("#delete_confirmation").modal('hide');
              // setTimeout(function(){ $('.removeRow').fadeOut();
              // window.location.reload(); },3000); 
            }
           })
        }else{
           toastr.warning('Please select at least one row');
        }
}


function notificationDisp(){
 url = "<?= base_url('notification/getNoti')?>";
	$.ajax({
        url : url,
        type: "POST",
        data: "notidata=data",
        dataType: 'json',
        success: function(response)
        { 
			var k=0;
			var fullData=response.notidata;		
			var countData=response.noticount;
			$("#putCountNoti").html(countData);	
			$("#putCountNotiLbl").val(countData);	
			
			$.each(fullData,function(index,data){
				if(k==0){
					var notiId=data['id'];
					$("#notiicationLbl").val(notiId);
				}
				
				var text = '<li class="nav-item" style="width:100%;" >'+
					'<a href="'+data['url']+'" class="nav-link" style="padding: 0px 0px 0px 5px;">'+
						'<div style="padding:0px; font-size:13px;">'+data['subject']+'<div class="row"><div class="col-md-6"><label style="padding:0px; font-size:11px;">'+data['owner']+'</label></div><div class="col-md-6"><label style="padding:0px;font-size:11px;float: right;margin-right: 7px;">'+data['created_date']+'</label></div></div></div></a></li>'+
					'<li style="width:100%;" ><div class="dropdown-divider"></div></li>';
					
                if(data['id']!=""){
                        $('#putNotiFication').append(text); 
                }
				k++;
            });	  
			
        }
	});
}


function notificationDispInter(){
 url = "<?= base_url('notification/getNoti')?>";
 var notiId = $("#notiicationLbl").val();
	$.ajax({
        url : url,
        type: "POST",
        data: "notidata=data&notiId="+notiId,
        dataType: 'json',
        success: function(response)
        {   
			var k=0;
			var fullData	= response.notidata;	
			var notipt		= $("#putCountNotiLbl").val();			
			var countData	= response.noticount;
			$("#putCountNoti").html(parseInt(countData)+parseInt(notipt));
			
			
			$.each(fullData,function(index,data){
				if(data['id']!=""){
					if(k==0){
						var notiId=data['id'];
						$("#notiicationLbl").val(notiId);
					}
				var text = '<li class="nav-item" style="width:100%;" >'+
					'<a href="'+data['url']+'" class="nav-link" style="padding: 0px 0px 0px 5px;">'+
						'<div style="padding:0px; font-size:13px;">'+data['subject']+'<div class="row"><div class="col-md-6"><label style="padding:0px; font-size:11px;">'+data['owner']+'</label></div><div class="col-md-6"><label style="padding:0px;font-size:11px;float: right;margin-right: 7px;">'+data['created_date']+'</label></div></div></div></a></li>'+
					'<li style="width:100%;" ><div class="dropdown-divider"></div></li>';
					$('#putNotiFication').prepend(text); 
                }
				k++;
            });	  
        }
	});
}
notificationDisp();

setInterval(notificationDispInter,10000);
</script>


<script >
  <?php //$url = $this->uri->segment(1); ?>
  $(document).ready(function()
  {
    var url = $(location).attr('href');
    var parts = url.split("/");
    var last_part = parts[parts.length-1];
    $('.nav-icon').each(function(){
      $('.nav-icon').removeClass('active_nav');
      if(last_part == 'organizations')
      {
        $('#org_nav').addClass('active_nav');
      }
      else if(last_part == 'contacts')
      {
        $('#con_nav').addClass('active_nav');
      }
      else if(last_part == 'leads')
      {
        $('#leads_nav').addClass('active_nav');
      }
      else if(last_part == 'opportunities')
      {
        $('#opp_nav').addClass('active_nav');
      }
      else if(last_part == 'quotation')
      {
        $('#quote_nav').addClass('active_nav');
      }
      else if(last_part == 'salesorders')
      {
        $('#so_nav').addClass('active_nav');
      }
      else if(last_part == 'vendors')
      {
        $('#ven_nav').addClass('active_nav');
      }
      else if(last_part == 'purchaseorders')
      {
        $('#po_nav').addClass('active_nav');
      } 
    });   
  });
</script>

<!--only alphabets letters-->
 <script>
       $(document).ready(function() {
            $(".onlyLetters").lettersOnly();
        });
 /* function only_letters(inputid){
      $("#"+inputid).lettersOnly();
  }*/
 

         $.fn.lettersOnly = function() {
         $(this).keydown(function(e) {
         var key = e.which || e.keyCode;

 

        if(!e.altKey && !e.ctrlKey && key >=48 && key<=57 || key>=96 && key<=105 ||key==188||key==109||key==110||key==13||key==35|| key==36|| key==46||key==45||key==107||key==219||key==221||key==220||key==186||key==222|| key==191||key==187||key==192) {
            return false;
        }
        else {
          return true;  
        }
      });
    }
</script>