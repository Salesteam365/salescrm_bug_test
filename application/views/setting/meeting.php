<?php $this->load->view('common_navbar');?>
<style>
.timeIc{ color: #18a2b8;
    margin: 2px;
}
#ajax_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   padding-top:18px;
  padding-bottom:18px;
  

}

#ajax_datatable tbody tr td {
  background-color: #fff; /* Set background color */
  font-size: 14px; /* Increase font size */
  font-family: system-ui;
  font-weight: 651;
  color:rgba(0,0,0,0.7);
  padding-top:16px;
  padding-bottom:16px;
   /* Change font family */
  /* Add any other styles as needed */
}

#ajax_datatable tbody tr td:nth-child(4) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
}



  
</style>
<link rel="stylesheet" href="<?= base_url();?>assets/css/filter_multi_select.css" />
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Your Meetings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Meetings</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
     
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="container-fliud filterbtncon"  >
			  <form method="post" action="">
        <?php 
                                  //  $fifteen = strtotime("-15 Day"); 
                                  //  $thirty = strtotime("-30 Day"); 
                                  //  $fortyfive = strtotime("-45 Day"); 
                                  //  $sixty = strtotime("-60 Day"); 
                                  //  $ninty = strtotime("-90 Day"); 
                                  //  $six_month = strtotime("-180 Day"); 
                                  //  $one_year = strtotime("-365 Day");
                            ?>
         <div class="row mb-3">
         <div class="col-lg-2">
         <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
    <input type="hidden" id="date_filter" value="" name="date_filter">
    <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
    <li data-value="This Week">This Week</li>
        <?php $week = strtotime("-7 Day"); ?>
        <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','date_filter');">Last Week</li>
        <?php $fifteen = strtotime("-15 Day"); ?>
        <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','date_filter');">Last 15 days</li>
        <?php $thirty = strtotime("-30 Day"); ?>
        <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','date_filter');">Last 30 days</li>
        <?php $fortyfive = strtotime("-45 Day"); ?>
        <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','date_filter');">Last 45 days</li>
        <?php $sixty = strtotime("-60 Day"); ?>
        <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','date_filter');">Last 60 days</li>
        <?php $ninty = strtotime("-90 Day"); ?>
        <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','date_filter');">Last 3 Months</li>
        <?php $six_month = strtotime("-180 Day"); ?>
        <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','date_filter');">Last 6 Months</li>
        <?php $one_year = strtotime("-365 Day"); ?>
        <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','date_filter');">Last 1 Year</li>
    </ul>
</div>
   </div>
   <div class="col-lg-4"></div>
            <div class="col-lg-6">
               <div class="refresh_button float-right">
							<button class="btn btnstopcorner rounded-0" type="button" onclick="reload_table()"><i class="fas fa-redo-alt"></i></button>	
							<?php if(check_permission_status('Meeting','create_u')==true){ ?>
							<button type="button" class="btn btnstop add_button rounded-0" id="AddMeeting" style="color:#fff;">Add Meeting</a></button>
							<?php } ?>	  
						</div>
              </div>
                      
                  </div>
                </form>
              </div>
                <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
                <!-- /.card-header -->
              <div class="card-body" id="countSearch">
				
                <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                    <thead>
                        <tr>                          
                            <th class="th-sm" style="width:13%">Meeting</th>
                            <th class="th-sm" style="width:11%">Host By</th>
                            <th class="th-sm">Location</th>
                            <th class="th-sm">Date</th>
							<th class="th-sm">Status</th>
							<th class="th-sm" style="width:7%">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>         
                    </tbody>
                </table>
              </div>
            </div>
      </div>
    </section>
  </div>
</div>


<style>
.task-form input{
    border:0;
}
.task-form textarea{
    border:0;
}

.task-form select{
    border:0;
}

.task-form span{
    border:0;
    font-weight: 700;
}

.userNm{
    margin: 5px;
    font-size: 14px;
    border: 1px solid #f5efef;
    padding: 3px 6px;
    border-radius: 4px;
    background: #fdfbfb;
    display: none;
}

</style>


<!--meeting click popup-->
<!-- Modal -->
<div class="modal fade" id="meeting_click" tabindex="-1" aria-labelledby="meeting_clickLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">View / Update Meeting Information</h5>
        </button>
      </div>
      <div class="modal-body">
        <form class="task-form" id="meetingForm" method="post">
            <div class="row" id="formDivhd">
                <input type="hidden" value="0"  name="saveDatamtng" id="saveDatamtng">
                <input type="hidden" value="0"  name="saveDatamtngid" id="saveDatamtngid">
                <input type="hidden" value="0"  name="addMeetCheck" id="addMeetCheck">
                 <div class="row col-md-12" id="organizationFld" >
                <div class="col-md-4 form-group">
                    <span class="form-control">Opportunity Name : </span>
                </div>
                <div class="col-md-8 form-group">
                    <span class="form-control" id="oppName"></span>
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Organization Name : </span>
                </div>
                
                <div class="col-md-8 form-group">
                    <span class="form-control" id="orgName"></span>
                </div>
                </div>
                
                 <div class="col-md-4 form-group">
                   <span class="form-control">Meeting Title<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" placeholder="Title" value="New Meeting" name="mtngTitle" id="mtngTitle">
                </div>
                <div class="col-md-4 form-group">
                   <span class="form-control">Meeting Location<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" placeholder="Location" name="mtngLocation" id="mtngLocation">
                </div>
                <div class="col-md-4 form-group">
                   <span class="form-control">Meeting Day Time: </span>
                </div>
                <div class="col-md-8 form-group">
                    <label>All Day <input type="checkbox" name="mtngAllday" id="mtngAllday"></label>
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Meeting From Date/Time<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-5 form-group">
                    <input type="text" class="form-control" name="mtngFromDate" id="mtngFromDate" onfocus="(this.type='date')" placeholder="From (dd-mm-yyyy)">
                </div>
                <div class="col-md-3 form-group">
                    <input type="text" class="form-control" name="mtngFromTime" id="mtngFromTime" onfocus="(this.type='time')" placeholder="From Time (hh-mm)">
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Meeting To Date/Time<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-5 form-group">
                    <input type="text" class="form-control" name="mtngToDate" id="mtngToDate" onfocus="(this.type='date')" placeholder="To (dd-mm-yyyy)">
                </div>
                <div class="col-md-3 form-group">
                    <input type="text" class="form-control" name="mtngToTime" id="mtngToTime" onfocus="(this.type='time')" placeholder="To Time (hh-mm)">
                </div>
                <div class="col-md-4 form-group">
                   <span class="form-control">Meeting Host Name<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="mtngHost" id="mtngHost" placeholder="Host" value="<?= $this->session->userdata('name'); ?>">
                </div>
                <div class="col-md-4 form-group">
                   <span class="form-control">Meeting Particepants: </span>
                </div>
                <div class="col-md-8 form-group" style="display:none;" id="userINput">
                    <select class="form-control selctCl" multiple name="mtngParticepants[]" id="mtngParticepants" >
                        <?php foreach($users_data as $row){ ?>
                            <option value="<?=$row['standard_email'];?>"><?=$row['standard_name'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-8 form-group" id="userList">
                     <?php foreach($users_data as $row){ 
                     $newString=str_replace("@",'',$row['standard_email']);
                     $newString=str_replace(".",'',$newString);
                     ?>
                    <text class="userNm" id="<?=$newString;?>"><?=$row['standard_name'];?></text>
                    <?php } ?>
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Reminder : </span>
                </div>
                <div class="col-md-8 form-group">
                    <select class="form-control selctCl" name="mtngReminder" id="mtngReminder" >
                            <option value="">Select Reminder</option>
                            <option value="At time of event">At time of event</option>
                            <option value="5">5 Minutes before</option>
                            <option value="10">10 Minutes before</option>
                            <option value="15">15 Minutes before</option>
                            <option value="30">30 Minutes before</option>
                            <option value="1">1 Hour before</option>
                            <option value="2">2 Hour before</option>
                       
                    </select>
                </div>
                
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Remarks : </span>
                </div>
                <div class="col-md-8 form-group">
                    <textarea class="form-control" name="taskRemarks" id="taskRemarks"></textarea>
                </div>
                
                 <div class="col-md-4 form-group">
                   <span class="form-control">Task Status : </span>
                </div>
                <div class="col-md-8 form-group">
                    <select class="form-control" name="taskStatus" id="taskStatus">
                        <option value="">Select Status</option>
                        <option value="1">Not Started</option>
                        <option value="2">Completed</option>
                        <option value="3">Progress</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
            </div>
             <div class="row" id="messageDiv" style="display:none;">
                <div class="col-md-2 form-group"></div>
                <div class="col-md-8 form-group text-center" id="putmsg" style="padding: 45px;"></div>
                <div class="col-md-2 form-group"></div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="CloseMeetingForm">Close</button>
        <button type="button" class="btn btn-info"  id="editMeetingView">Edit</button>
        <button type="button" class="btn btn-secondary" id="cancelMeeting" style="display:none;">Cancel</button>
        <button type="button" class="btn btn-info"  id="MeetingFormSave" style="display:none;">Update</button>
      </div>
    </div>
  </div>
</div>
<!--meeting click popup-->


<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<script src="<?= base_url();?>assets/js/filter-multi-select-bundle.min.js"></script>
<script type="text/javascript">


 $(function () { 
     var userName = $('#mtngParticepants').filterMultiSelect(); 
     $('#meetingForm').on('keypress keyup', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            return false;
          }
        });
     
 });



var save_method; //for save method string
var table;
$(document).ready(function() {

    table = $('#dt-multi-checkbox').DataTable({
        "processing": true, 
        "serverSide": true, 
		"searching": true,
        "order": [], 
        "ajax": {
            url: "<?php echo site_url('setting/ajax_list')?>",
            type: "POST",
			dataType : "JSON",
            data : function(data)
			
             {
                data.searchDate = $('#date_filter').val();
				data.searchUser = $('#user_filter').val();
				data.firstDate  = $('#firstDate').val();
				data.secondDate = $('#secondDate').val();
				
             }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ]
    });
	//count_pending_price();
    $('#date_filter').change(function(){
		//alert('date_filter');
		table.ajax.reload();
		
    });
	$('#user_filter').change(function(){
		table.ajax.reload();
		
    });
    
    $('#firstDate,#secondDate').change(function(){
		table.ajax.reload();
		
    });
    
  }); 
  function reload_table()
  {
    table.ajax.reload(null,false); //reload datatable ajax
  }
 //delete proforma invoice
  function delete_meeting(id)
  {
      if(confirm('Are you sure delete this data?'))
      {
          // ajax delete data to database
          $.ajax({
              url : "<?= site_url('setting/delete_meeting')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                if(data.status) 
                {
                    alert('Meeting deleted successfully.')
                    reload_table();
                }else{
                    alert('Something went wrong, Try later.')
                }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
          });
      }
  }
  
  
  function view(id,oppid)
  {   
      $(".userNm").css('display','none');
        $.ajax({
              url : "<?= site_url('setting/getbyid_meeting')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                  forDisableInput(".task-form input",1);
                  forReadOnlyInput(".task-form input",1);
                  forDisableInput(".task-form select",1);
                  forReadOnlyInput(".task-form textarea",1);
                  
                  $("#addMeetCheck").val('update');
                  
                 $('#saveDatamtngid').val(data.id);
                 $('#mtngTitle').val(data.meeting_title);
                 $('#mtngLocation').val(data.location);
                 $('#mtngFromDate').val(data.from_date);
                 $('#mtngFromTime').val(data.from_time);
                 $('#mtngToDate').val(data.to_date);
                 $('#mtngToTime').val(data.to_time);
                 $('#mtngHost').val(data.host_name);
                 $('#mtngParticepants').val(data.particepants);
                 $('#taskRemarks').val(data.remarks);
                 $('#taskStatus').val(data.status);
                 $("#mtngReminder").val(data.reminder);
                 $("#userINput").hide();
                 $("#userList").show();
                var prtcpnt= data.particepants;
                var res = prtcpnt.split("<br>");
                for (var i=0; i < res.length; i++)
                {
                  if(res[i]){
                      var new_string = res[i].replace('@','');
                       new_string = new_string.replace(/[.]/g,'');
                      $("#"+new_string).css('display','inline-block');
                  }
                    
                }
                 
                 if(data.all_day==1){
                    $('#mtngAllday').prop('checked',true);
                 }
                 
                  $("#cancelMeeting").click();
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
        });
        
        if(oppid){
        $.ajax({
              url : "<?= site_url('setting/getbyid_opp')?>/"+oppid,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                 if(data.name){
                    $("#organizationFld").show();
                    $('#oppName').html(data.name);
                    $('#orgName').html(data.org_name);
                 }else{
                    $("#organizationFld").hide();
                 }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
        });
        }else{
            $("#organizationFld").hide();
        }
        
      
      
      $("#meeting_click").modal('show');
    
  }
  
   
  $("#editMeetingView").click(function(){
    $("#saveDatamtng").val('1');
    $("#editMeetingView, #CloseMeetingForm").hide();
    $("#MeetingFormSave, #cancelMeeting").show();
    $(".task-form input").css('border','0px');
    $(".task-form input").css('border-bottom','1px solid #e0e0e0');
    $(".task-form select").css('border-bottom','1px solid #e0e0e0');
    $(".task-form textarea").css('border-bottom','1px solid #e0e0e0');
    forDisableInput(".task-form input",0);
    forReadOnlyInput(".task-form input",0);
    forDisableInput(".task-form select",0);
    forReadOnlyInput(".task-form textarea",0);
    $("#userList").hide();
    $("#userINput").show();
});
  
$("#CloseMeetingForm").click(function(){
    $("#saveDatamtng").val('0');
    $('#meeting_click').modal('hide');
    $('#meetingForm')[0].reset();
    $("#editMeetingView, #CloseMeetingForm").show();
    $("#MeetingFormSave, #cancelMeeting").hide();
    forDisableInput(".task-form input",1);
    forReadOnlyInput(".task-form input",1);
    forDisableInput(".task-form select",1);
    forReadOnlyInput(".task-form textarea",1);
    $("#addMeetCheck").val('');
    $("#userList").show();
    $("#userINput").hide();
   
});

$("#cancelMeeting").click(function(){
    $("#saveDatamtng").val('0');
    $("#editMeetingView, #CloseMeetingForm").show();
    $("#MeetingFormSave, #cancelMeeting").hide();
    $(".task-form input").css('border','0px');
    $(".task-form select").css('border','0px');
    $(".task-form textarea").css('border','0px');
    forDisableInput(".task-form input",1);
    forReadOnlyInput(".task-form input",1);
    forDisableInput(".task-form select",1);
    forReadOnlyInput(".task-form textarea",1);
    $("#userList").show();
    $("#userINput").hide();
});



$("#AddMeeting").click(function(){  
    $("#addMeetCheck").val('add');
    $("#MeetingFormSave").html('Save');
    $("#meeting_click").modal('show');
    $("#editMeetingView").click();
    $("#organizationFld").hide();
 });



$("#MeetingFormSave").click(function(){
   var	mtngTitle    = $("#mtngTitle").val();
	var	mtngLocation = $("#mtngLocation").val();
	var	mtngFromDate = $("#mtngFromDate").val();
	var	mtngFromTime = $("#mtngFromTime").val();
	var	mtngToDate   = $("#mtngToDate").val();
	var	mtngToTime   = $("#mtngToTime").val();
	
	var	mtngHost     = $("#mtngHost").val();
	var	mtngParticepants   = $("#mtngParticepants").val();
	
	if(mtngTitle=="" || mtngTitle===undefined){
	    $("#mtngTitle").css('border-color','red');
	    $('#mtngTitle').focus();
	    return false;
	}else if(mtngLocation=="" || mtngLocation===undefined){
	    $("#mtngLocation").css('border-color','red');
	    $('#mtngLocation').focus();
	    return false;
	}else if(mtngFromDate=="" || mtngFromDate===undefined){
	    $("#mtngFromDate").css('border-color','red');
	    $('#mtngFromDate').focus();
	    return false;
	}else if(mtngFromTime=="" || mtngFromTime===undefined){
	    $("#mtngFromTime").css('border-color','red');
	    $('#mtngFromTime').focus();
	    return false;
	}else if(mtngToDate=="" || mtngToDate===undefined){
	    $("#mtngToDate").css('border-color','red');
	    $('#mtngToDate').focus();
	    return false;
	}else if(mtngToTime=="" || mtngToTime===undefined){
	    $("#mtngToTime").css('border-color','red');
	    $('#mtngToTime').focus();
	    return false;
	}else if(mtngHost=="" || mtngHost===undefined){
	    $("#mtngHost").css('border-color','red');
	    $('#mtngHost').focus();
	    return false;
	}else{
	    $("#MeetingFormSave").html('<i class="fas fa-spinner fa-spin"></i>');
	    forDisableInput("#MeetingFormSave",1);
	    var dataString = $("#meetingForm").serialize();
	    
	    var adddt=$("#addMeetCheck").val();
	    if(adddt=='add'){
            var url = "<?= base_url('setting/addMeeting')?>";
	    }else{
	        var url = "<?= base_url('setting/updateMeeting')?>";   
	    }
	    
        $.ajax({
            url : url,
            type: "POST",
            data: dataString,
           dataType: "JSON",
            success: function(data)
            { 
                console.log(data);
              if(data.status) 
              {
                  
                  $("#formDivhd").hide();
                  $("#messageDiv").show();
                  $("#putmsg").html('<span style="display: block;"><i class="far fa-check-circle" style="font-size: 35px; color: #77bb77f0; margin-bottom: 28px;"></i></span><span>Your meeting information updated successfully.')
                setTimeout(function(){  
                  $('#add_popup').modal('hide');
                  reload_table();
                  $("#MeetingFormSave").html('Update');
	              forDisableInput("#MeetingFormSave",0);
	              $("#CloseMeetingForm").click();
	              $("#formDivhd").show();
                  $("#messageDiv").hide();
                },4000); 
	              
              }else{
                  $("#formDivhd").hide();
                  $("#messageDiv").show();
                  $("#putmsg").html('<span style="display: block;"><i class="fas fa-exclamation-triangle" style="font-size: 35px; color: #e68e88; margin-bottom: 28px;"></i></span><span>Something went wrong, Try later.')
                  $("#MeetingFormSave").html('Update');
	              forDisableInput("#MeetingFormSave",0);
	               setTimeout(function(){ $("#formDivhd").show();
                  $("#messageDiv").hide();  $("#cancelMeeting").click(); },4000)
              }
              
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                   $("#MeetingFormSave").html('Update');
	               forDisableInput("#MeetingFormSave",0);
	               $("#cancelMeeting").click();
            }
        });
	}
    
});
function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

table.ajax.reload();
}
$('.form-control').keypress(function(){
  $(this).css('border-color','')
});
$('.form-control').change(function(){
  $(this).css('border-color','')
});

</script>
<?php
if(isset($_GET['mid']) && $_GET['mid']!=""){
?>
<script>
	view("<?=$_GET['mid'];?>");
	var urlCur      = window.location.href;
	var  myArr 		= urlCur.split("?");
	var url			= myArr[0];
	if (window.history.replaceState) {
	   window.history.replaceState('', '', url);
	}
</script>
<?php } ?>
