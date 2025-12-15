<?php $this->load->view('common_navbar');?>
<style>
.timeIc{ color: #18a2b8;
    margin: 2px;
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
            <h1 class="m-0 text-dark">Your Calls</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Calls</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
      
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="container-fliud filterbtncon"  >
			  <form method="post" action="">
              
                  <?php 
                                //    $fifteen = strtotime("-15 Day"); 
                                //    $thirty = strtotime("-30 Day"); 
                                //    $fortyfive = strtotime("-45 Day"); 
                                //    $sixty = strtotime("-60 Day"); 
                                //    $ninty = strtotime("-90 Day"); 
                                //    $six_month = strtotime("-180 Day"); 
                                //    $one_year = strtotime("-365 Day");
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
							<button type="button" class="btn btnstop add_button rounded-0" id="AddCall">Add Call</a></button>
						</div>
                  </div>
                </form>
</div>
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
                            <th class="th-sm">Call</th>
                            <th class="th-sm">Contact Name</th>
                            <th class="th-sm">Call Purpose</th>
                            <th class="th-sm">Releted To</th>
							<th class="th-sm">Status</th>
							<th class="th-sm" style="width:8%">Action</th>
                        </tr>
                    </thead>
                    <tbody>         
                    </tbody>
                </table>
				
              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
</div>





<style>/*
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
}*/

</style>

<!--call click popup-->
<!-- Modal -->
<div class="modal fade" id="call_click" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="call_title">Create Call</h5>
        </button>
      </div>
      <div class="modal-body">
        <form class="task-form" id="callForm" method="post">
            <input type="hidden" value="0"  name="saveDataCall" id="saveDataCall">
            <input type="hidden" value="0"  name="saveDataCallid" id="saveDataCallid">
             <input type="hidden" value="update"  name="addCallCheck" id="addCallCheck">
            <div class="row" id="formDivhd" >
                <div class="col-md-12 row form-group" id="organizationFld" >
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
                    <span class="form-control">Contact Name<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="callContactName" id="callContactName" placeholder="Contact Name">
                </div>
                
                <div class="col-md-4 form-group">
                    <span class="form-control">Subject<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="callSubject" id="callSubject" placeholder="Subject">
                </div>
                <div class="col-md-4 form-group">
                    <span class="form-control">Contact Number </span>
                </div>
                 <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="contactNumber" id="contactNumber" placeholder="Contact Number(Optional)" maxlength="10">
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Call From Date/Time<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-5 form-group">
                    <input type="text" class="form-control" name="mtngFromDate" id="mtngFromDate" onfocus="(this.type='date')" placeholder="From (dd-mm-yyyy)">
                </div>
                <div class="col-md-3 form-group">
                    <input type="text" class="form-control" name="mtngFromTime" id="mtngFromTime" onfocus="(this.type='time')" placeholder="From Time (hh-mm)">
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Call To Date/Time<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-5 form-group">
                    <input type="text" class="form-control" name="mtngToDate" id="mtngToDate" onfocus="(this.type='date')" placeholder="To (dd-mm-yyyy)">
                </div>
                <div class="col-md-3 form-group">
                    <input type="text" class="form-control" name="mtngToTime" id="mtngToTime" onfocus="(this.type='time')" placeholder="To Time (hh-mm)">
                </div>
                <div class="col-md-4 form-group">
                   <span class="form-control">Call Host Name<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="mtngHost" id="mtngHost" placeholder="Host" value="<?= $this->session->userdata('name'); ?>">
                </div>
                <div class="col-md-4 form-group">
                   <span class="form-control">Call Particepants: </span>
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
                    <span class="form-control">Purpose<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <select class="form-control" name="callPurpose" id="callPurpose">
                        <option selected disabled>Call Purpose</option>
                        <option>Prospecting</option>
                        <option>Administrative</option>
                        <option>Negotiation</option>
                        <option>Demo</option>
                        <option>Project</option>
                        <option>Desk</option>
                    </select>
                </div>
                
                 <div class="col-md-4 form-group">
                    <span class="form-control">Related To <span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <select class="form-control" name="callRelated" id="callRelated">
                        <option selected disabled>Related To</option>
                        <option>Accounting</option>
                        <option>Deal</option>
                        <option>Campaign</option>
                    </select>
                </div>
                
                <div class="col-md-4 form-group">
                    <span class="form-control">Call Type : </span>
                </div>
                <div class="col-md-8 form-group">
                    <select class="form-control" name="callType" id="callType">
                        <option selected disabled>Call Type</option>
                        <option>Outbound</option>
                        <option>Inbound</option>
                    </select>
                </div>
               
               <div class="col-md-4 form-group">
                    <span class="form-control">Call Deatils<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="callDeatils" id="callDeatils" placeholder="Call Details">
                </div>
                
                <div class="col-md-4 form-group">
                    <span class="form-control">Call Description<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <textarea class="form-control" placeholder="Description" name="callDescription" id="callDescription"></textarea>
                </div>
                <div class="col-md-4 form-group">
                   <span class="form-control">Call Status : </span>
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
        <button type="button" class="btn btn-secondary" id="callClose">Close</button>
        <button type="button" class="btn btn-info"  id="editCallView">Edit</button>
        <button type="button" class="btn btn-secondary" id="cancelCallView" style="display:none;">Cancel</button>
        <button type="button" class="btn btn-info"  id="callSave" style="display:none;">Update</button>
      </div>
    </div>
  </div>
</div>






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
            url: "<?php echo site_url('setting/ajax_list_call')?>",
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
  function delete_call(id)
  {
      if(confirm('Are you sure delete this data?'))
      {
          // ajax delete data to database
          $.ajax({
              url : "<?= site_url('setting/delete_call')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                if(data.status==true){
					toastr.success('Data deleted successfully.');
                    reload_table();
				}else{
					toastr.success('Something went wrong, Please try again later.');
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
              url : "<?= site_url('setting/getbyid_call')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                  forDisableInput(".task-form input",1);
                  forReadOnlyInput(".task-form input",1);
                  forDisableInput(".task-form select",1);
                  forReadOnlyInput(".task-form textarea",1);
                  $('#addCallCheck').val('update');
                  
                 $('#saveDataCallid').val(data.id);
                 $('#callContactName').val(data.contact_name);
                 $('#callSubject').val(data.call_subject);
                 $('#contactNumber').val(data.contact_number);
                 $('#callPurpose').val(data.call_purpose);
                 $('#callRelated').val(data.related_to);
                 $('#callType').val(data.call_type);
                 $('#callDeatils').val(data.call_detail);
                 $('#callDescription').val(data.call_description);
                 $('#mtngFromDate').val(data.from_date);
                 $('#mtngFromTime').val(data.from_time);
                 $('#mtngToDate').val(data.to_date);
                 $('#mtngToTime').val(data.to_time);
                 $('#mtngHost').val(data.owner);
                /* $('#mtngParticepants').val(data.particepants);
                 $('#taskRemarks').val(data.remarks);*/
                 $('#taskStatus').val(data.status);
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
                 
                  $("#cancelCallView").click();
              }
        });
        if(oppid!=""){
        $.ajax({
              url : "<?= site_url('setting/getbyid_opp')?>/"+oppid,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                //  console.log(data);
                 if(data.name){
                    $("#organizationFld").show();
                    $('#oppName').html(data.name);
                    $('#orgName').html(data.org_name);
                 }else{
                    $("#organizationFld").hide();
                 }
                 
                 
              }
        });
        }else{
            $("#organizationFld").hide();
        }
        
      
      
      $("#call_click").modal('show');
      $("#call_title").text('View/Update Call');
    
  }
  
   
  $("#editCallView").click(function(){
    $("#saveDataCall").val('1');
     $("#editCallView, #callClose").hide();
    $("#callSave, #cancelCallView").show();
    forDisableInput(".task-form input",0);
    forReadOnlyInput(".task-form input",0);
    forDisableInput(".task-form select",0);
    forReadOnlyInput(".task-form textarea",0);
    $("#userList").hide();
    $("#userINput").show();
    
});
  
$("#callClose").click(function(){
    $("#saveDataCall").val('0');
    $('#call_click').modal('hide');
    $('#callForm')[0].reset();
    $("#editCallView, #callClose").show();
    $("#callSave, #cancelCallView").hide();
    forDisableInput(".task-form input",1);
    forReadOnlyInput(".task-form input",1);
    forDisableInput(".task-form select",1);
    forReadOnlyInput(".task-form textarea",1);
    $("#userList").show();
    $("#userINput").hide();
   
});

$("#cancelCallView").click(function(){
    $("#saveDataCall").val('0');
    $("#editCallView, #callClose").show();
    $("#callSave, #cancelCallView").hide();
    forDisableInput(".task-form input",1);
    forReadOnlyInput(".task-form input",1);
    forDisableInput(".task-form select",1);
    forReadOnlyInput(".task-form textarea",1);
    $("#userList").show();
    $("#userINput").hide();
});


 $("#AddCall").click(function(){  
     $("#callSave").html('Save');
     $('#callForm')[0].reset();
     $("#call_title").text('Create Call');
     $("#call_click").modal('show');
     $('#addCallCheck').val('save')
     $("#editCallView").click();
     $("#organizationFld").hide();
 }); 
  
	 
/****** VALIDATION FUNCTION*********/
function changeClr(idinpt){
  $('#'+idinpt).css('border-color','red');
  $('#'+idinpt).focus();
  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
}


$("#callSave").click(function(){
    var	callContactName  = $("#callContactName").val();
	var	callSubject      = $("#callSubject").val();
	var	callPurpose      = $("#callPurpose").val();
	var	callRelated      = $("#callRelated").val();
	var	callDeatils      = $("#callDeatils").val();
	var	callDescription  = $("#callDescription").val();
	var	mtngFromDate     = $("#mtngFromDate").val();
	var	mtngFromTime     = $("#mtngFromTime").val();
	var	mtngToDate       = $("#mtngToDate").val();
	var	mtngToTime       = $("#mtngToTime").val();
	var	mtngHost         = $("#mtngHost").val();
	var	mtngParticepants = $("#mtngParticepants").val();

	
	if(callContactName=="" || callContactName===undefined){
	   changeClr('callContactName');
	    return false;
	}else if(callSubject=="" || callSubject===undefined){
	   changeClr('callSubject');
	    return false;
	}else if(mtngFromDate=="" || mtngFromDate===undefined){
	     changeClr('mtngFromDate');
	    return false;
	}else if(mtngFromTime=="" || mtngFromTime===undefined){
	     changeClr('mtngFromTime');
	    return false;
	}else if(mtngToDate=="" || mtngToDate===undefined){
	     changeClr('mtngToDate');
	    return false;
	}else if(mtngToTime=="" || mtngToTime===undefined){
	     changeClr('mtngToTime');
	    return false;
	}else if(mtngHost=="" || mtngHost===undefined){
	     changeClr('mtngHost');
	    return false;
	}else if(callPurpose=="" || callPurpose===undefined){
	    changeClr('callPurpose');
	    return false;
	}else if(callRelated=="" || callRelated===undefined){
	    changeClr('callRelated');
	    return false;
	}else if(callDeatils=="" || callDeatils===undefined){
	    changeClr('callDeatils');
	    return false;
	}else if(callDescription=="" || callDescription===undefined){
	   changeClr('callDescription');
	    return false;
	    
	}else{
	    
	    $("#callSave").html('<i class="fas fa-spinner fa-spin"></i>');
	    forDisableInput("#callSave",1);
	    var dataString = $("#callForm").serialize();
	    var perform=$("#addCallCheck").val();
	    if(perform=='save'){
	    var url = "<?= base_url('setting/addCall')?>";    
	    }else{
        var url = "<?= base_url('setting/updateCall')?>";
	    }
        $.ajax({
            url : url,
            type: "POST",
            data: dataString,
           dataType: "JSON",
            success: function(data)
            { 
              if(data.status) 
              {
                  
                  $("#formDivhd").hide();
                  $("#messageDiv").show();
                  $("#putmsg").html('<span style="display: block;"><i class="far fa-check-circle" style="font-size: 35px; color: #77bb77f0; margin-bottom: 28px;"></i></span><span>Your call information updated successfully.')
                setTimeout(function(){  
                  $('#add_popup').modal('hide');
                  reload_table();
                  $("#callSave").html('Update');
	              forDisableInput("#callSave",0);
	              $("#callClose").click();
	              $("#formDivhd").show();
                  $("#messageDiv").hide();
                },4000); 
	              
              }else{
                  $("#formDivhd").hide();
                  $("#messageDiv").show();
                  $("#putmsg").html('<span style="display: block;"><i class="fas fa-exclamation-triangle" style="font-size: 35px; color: #e68e88; margin-bottom: 28px;"></i></span><span>Something went wrong, Try later.')
                  $("#callSave").html('Update');
	              forDisableInput("#callSave",0);
	               setTimeout(function(){ $("#formDivhd").show();
                  $("#messageDiv").hide();  $("#cancelCallView").click(); },4000)
              }
              
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                   $("#callSave").html('Update');
	               forDisableInput("#callSave",0);
	               $("#cancelCallView").click();
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
if(isset($_GET['cid']) && $_GET['cid']!=""){
?>
<script>
	view("<?=$_GET['cid'];?>");
	var urlCur      = window.location.href;
	var  myArr 		= urlCur.split("?");
	var url			= myArr[0];
	if (window.history.replaceState) {
	   window.history.replaceState('', '', url);
	}
</script>
<?php } ?>
