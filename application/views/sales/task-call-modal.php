 <link rel="stylesheet" href="<?= base_url();?>assets/css/filter_multi_select.css" />
    <!--task click popup-->
<!-- Modal -->

<style>  .tskSpan{  border: none;
    font-weight: 700;
    background: no-repeat; }</style>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Create Task</h5>
      
      </div>
      <div class="modal-body">
        <form class="task-form" id="taskForm" method="post">
            <input type="hidden" value="0"  name="saveDatatask" id="saveDatatask">
            <input type="hidden" value="0"  name="updateDatataskid" id="updateDatataskid">
            <input type="hidden" value="0"  name="addtaskCheck" id="addtaskCheck">
            <div class="row" id="formDivhd">
                <div class="col-md-3 form-group">
                    <span class="form-control tskSpan">Task Subject<span style="color: #f76c6c;">*</span></span>
                </div>
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control onlyLetters" placeholder="Subject" name="taskSubject" id="taskSubject" >
                </div>
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Task From Date : </span>
                </div>
                
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control" name="taskFromDate" id="taskFromDate" onfocus="(this.type='date')" placeholder="From Date">
                </div>
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Task Due Date<span style="color: #f76c6c;">*</span> </span>
                </div>
                
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control" name="taskDueDate" id="taskDueDate" onfocus="(this.type='date')" placeholder="Due Date">
                </div>
                
                
                
                 <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Task Priority<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-9 form-group">
                    <select class="form-control" name="taskPriority" id="taskPriority">
                        <option value="">Select Priority</option>
                        <option value="High">High</option>
                        <option value="Highest">Highest</option>
                        <option value="Low">Low</option>
                        <option value="Lowest">Lowest</option>
                        <option value="Normal">Normal</option>
                    </select>
                </div>
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Task Owner<span style="color: #f76c6c;">*</span></span>
                </div>
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control onlyLetters" name="taskOwner"  id="taskOwner" value="<?= $this->session->userdata('name'); ?>">
                </div>
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Task Asigned To : </span>
                </div>
                
                <div class="col-md-9 form-group">
                    <select class="form-control selctCl" multiple name="taskUser[]" id="taskUser" >
                        <?php foreach($users_data as $row){ ?>
                            <option value="<?=$row['standard_email'];?>"><?=$row['standard_name'];?></option>
                        <?php } ?>
                    </select>
                </div>
                
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Task Reminder : </span>
                </div>
                <div class="col-md-9 form-group">
                    <label class="switch ">
                          <input type="checkbox" type="checkbox" value="1"  name="taskReminder" id="taskReminder">
                          <span class="slider round"></span>
                   </label>
                </div>
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Task Repeat : </span>
                </div>
                <div class="col-md-9 form-group">
                   <label class="switch ">
                          <input type="checkbox" value="1"  name="taskRepeat" id="taskRepeat"  >
                          <span class="slider round"></span>
                   </label>
                    
                </div>
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Task Status : </span>
                </div>
                <div class="col-md-9 form-group">
                    <select class="form-control" name="taskStatus" id="taskStatus">
                        <option value="">Select Status</option>
                        <option value="1">Not Started</option>
                        <option value="2">Completed</option>
                        <option value="3">Progress</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Remarks : </span>
                </div>
                <div class="col-md-9 form-group">
                    <textarea class="form-control" name="taskRemarks" id="taskRemarks"></textarea>
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
        <button type="button" class="btn btn-secondary" id="closeTask">Close</button>
        <button type="button" class="btn btn-info"  id="saveTask">Save</button>
      </div>
    </div>
  </div>
</div>
<!--task click popup-->

<!--meeting click popup-->
<!-- Modal -->
<div class="modal fade" id="meeting_click" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Meeting Information</h5>
        </button>
      </div>
      <div class="modal-body">
        <form class="task-form" id="meetingForm" method="post">
            <div class="row" id="formDivhd">
                <input type="hidden" value="0"  name="saveDatamtng" id="saveDatamtng">
                <input type="hidden" value="0"  name="saveDatamtngid" id="saveDatamtngid">
                <input type="hidden" value="0"  name="addMeetCheck" id="addMeetCheck">
               
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Meeting Title<span style="color: #f76c6c;">*</span></span>
                </div>
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control onlyLetters" placeholder="Title" value="New Meeting" name="mtngTitle" id="mtngTitle">
                </div>
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Meeting Location<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control" placeholder="Location" name="mtngLocation" id="mtngLocation">
                </div>
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Meeting Day Time: </span>
                </div>
                <div class="col-md-9 form-group">
                    <label>All Day <input type="checkbox" name="mtngAllday" id="mtngAllday"></label>
                </div>
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Start Date/Time<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-6 form-group">
                    <input type="text" class="form-control" name="mtngFromDate" id="mtngFromDate" onfocus="(this.type='date')" placeholder="From (dd-mm-yyyy)">
                </div>
                <div class="col-md-3 form-group">
                    <input type="text" class="form-control" name="mtngFromTime" id="mtngFromTime" onfocus="(this.type='time')" placeholder="From Time (hh-mm)">
                </div>
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">End Date/Time<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-6 form-group">
                    <input type="text" class="form-control" name="mtngToDate" id="mtngToDate" onfocus="(this.type='date')" placeholder="To (dd-mm-yyyy)">
                </div>
                <div class="col-md-3 form-group">
                    <input type="text" class="form-control" name="mtngToTime" id="mtngToTime" onfocus="(this.type='time')" placeholder="To Time (hh-mm)">
                </div>
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Host Name<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control" name="mtngHost" id="mtngHost" placeholder="Host" value="<?= $this->session->userdata('name'); ?>">
                </div>
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Meeting Participants: </span>
                </div>
                <div class="col-md-9 form-group" id="userINput">
                    <select class="form-control selctCl" multiple name="mtngParticepants[]" id="mtngParticepants"  >
                        <?php foreach($users_data as $row){ ?>
                            <option value="<?=$row['standard_email'];?>"><?=$row['standard_name'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <!--<div class="col-md-9 form-group" id="userList">
                     <?php foreach($users_data as $row){ 
                     $newString=str_replace("@",'',$row['standard_email']);
                     $newString=str_replace(".",'',$newString);
                     ?>
                    <text class="userNm" id="<?=$newString;?>"><?=$row['standard_name'];?></text>
                    <?php } ?>
                </div>-->
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Reminder : </span>
                </div>
                <div class="col-md-9 form-group">
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
                
                
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Remarks : </span>
                </div>
                <div class="col-md-9 form-group">
                    <textarea class="form-control" name="taskRemarks" id="taskRemarks"></textarea>
                </div>
                
                 <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Task Status : </span>
                </div>
                <div class="col-md-9 form-group">
                    <select class="form-control" name="taskStatus" id="taskStatus">
                        <option value="">Select Status</option>
                        <option value="1">Not Started</option>
                        <option value="2">Completed</option>
                        <option value="3">Progress</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="CloseMeetingForm">Close</button>
        <button type="button" class="btn btn-info" id="MeetingFormSave">Save</button>
      </div>
    </div>
  </div>
</div>
<!--meeting click popup-->

<!--call click popup-->
<!-- Modal -->
<div class="modal fade" id="call_click" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Create Call</h5>
        </button>
      </div>
      <div class="modal-body">
        <form class="task-form" id="callForm" method="post">
            <input type="hidden" value="0"  name="saveDataCall" id="saveDataCall">
            <input type="hidden" value="0"  name="saveDataCallid" id="saveDataCallid">
            <div class="row" id="formDivhd" >
                <div class="col-md-3 form-group">
                    <span class="form-control tskSpan">Contact Name<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control onlyLetters" name="callContactName" id="callContactName" placeholder="Contact Name">
                </div>
                
                <div class="col-md-3 form-group">
                    <span class="form-control tskSpan">Subject<span style="color: #f76c6c;">*</span> </span>
                </div>
                 <div class="col-md-9 form-group">
                    <input type="text" class="form-control onlyLetters" name="callSubject" id="callSubject" placeholder="Subject">
                </div>
                <div class="col-md-3 form-group">
                    <span class="form-control tskSpan">Purpose<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-9 form-group">
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
                
                 <div class="col-md-3 form-group">
                    <span class="form-control tskSpan">Related To<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-9 form-group">
                    <select class="form-control" name="callRelated" id="callRelated">
                        <option selected disabled>Related To</option>
                        <option>Accounting</option>
                        <option>Deal</option>
                        <option>Campaign</option>
                    </select>
                </div>
                
                <div class="col-md-3 form-group">
                    <span class="form-control tskSpan">Call Type : </span>
                </div>
                <div class="col-md-9 form-group">
                    <select class="form-control" name="callType" id="callType">
                        <option selected disabled>Call Type</option>
                        <option>Outbound</option>
                        <option>Inbound</option>
                    </select>
                </div>
               
               <div class="col-md-3 form-group">
                    <span class="form-control tskSpan">Call Deatils<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control" name="callDeatils" id="callDeatils" placeholder="Call Details">
                </div>
                
                <div class="col-md-3 form-group">
                    <span class="form-control tskSpan">Call Description<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-9 form-group">
                    <textarea class="form-control" placeholder="Description" name="callDescription" id="callDescription"></textarea>
                </div>
                <div class="col-md-3 form-group">
                   <span class="form-control tskSpan">Call Status : </span>
                </div>
                <div class="col-md-9 form-group">
                    <select class="form-control" name="taskStatus" id="taskStatus">
                        <option value="">Select Status</option>
                        <option value="1">Not Started</option>
                        <option value="2">Completed</option>
                        <option value="3">Progress</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="callClose">Close</button>
        <button type="button" class="btn btn-info"  id="callSave" >Save</button>
      </div>
    </div>
  </div>
</div>
<!--call click popup-->
<script src="<?= base_url();?>assets/js/filter-multi-select-bundle.min.js"></script>
<script>

 $(function () { 
     var userName = $('#taskUser').filterMultiSelect(); 
 });
 $(function () { 
     var userName = $('#mtngParticepants').filterMultiSelect(); 
 });
 

$("#saveTask").click(function(){
    var	taskSubject = $("#taskSubject").val();
	var	taskDueDate = $("#taskDueDate").val();
	var	taskPriority= $("#taskPriority").val();
	var	taskOwner   = $("#taskOwner").val();
	var	taskReminder= $("#taskReminder").val();
	var	taskRepeat  = $("#taskRepeat").val();
	if(taskSubject=="" || taskSubject===undefined){
	    $("#taskSubject").css('border-color','red');
	     $('#taskSubject').focus();
	    return false;
	}else if(taskDueDate=="" || taskDueDate===undefined){
	    $("#taskDueDate").css('border-color','red');
	     $('#taskDueDate').focus();
	    return false;
	}else if(taskPriority=="" || taskPriority===undefined){
	    $("#taskPriority").css('border-color','red');
	     $('#taskPriority').focus();
	    return false;
	}else if(taskOwner=="" || taskOwner===undefined){
	    $("#taskOwner").css('border-color','red');
	     $('#taskOwner').focus();
	    return false;
	}else{
	    $("#saveDatatask").val('1');
	    $('#exampleModal').modal('hide');
	    return true;
	}
});

$("#taskReminder").click(function(){
    if ($(this).prop('checked')==true){ 
        $("#taskReminder").val('1');
    }else{
        $("#taskReminder").val('0');
    }
});


$("#taskRepeat").click(function(){
    if ($(this).prop('checked')==true){ 
        $("#taskRepeat").val('1');
    }else{
        $("#taskRepeat").val('0');
    }
});


$("#mtngAllday").click(function(){
    if ($(this).prop('checked')==true){ 
        $("#mtngAllday").val('1');
    }else{
        $("#mtngAllday").val('0');
    }
});

$("#closeTask").click(function(){
    $("#saveDatatask").val('0');
    $('#exampleModal').modal('hide');
    $('#taskForm')[0].reset();
});


/*---------- Add Meeting Code Validation --------------*/
$("#MeetingFormSave").click(function(){
    
    var	mtngTitle    = $("#mtngTitle").val();
	var	mtngLocation = $("#mtngLocation").val();
	var	mtngFromDate = $("#mtngFromDate").val();
	var	mtngFromTime = $("#mtngFromTime").val();
	var	mtngToDate   = $("#mtngToDate").val();
	var	mtngToTime   = $("#mtngToTime").val();
	var	mtngHost     = $("#mtngHost").val();

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
	    $("#saveDatamtng").val('1');
	    $('#meeting_click').modal('hide');
	    return true;
	}
});
$("#CloseMeetingForm").click(function(){
    $('#meeting_click').modal('hide');
    $("#saveDatamtng").val('0');
    $('#meetingForm')[0].reset();
});




/*---------- Add Meeting Code Validation --------------*/
$("#callSave").click(function(){
    
    var	callContactName    = $("#callContactName").val();
	var	callSubject = $("#callSubject").val();
	var	callPurpose = $("#callPurpose").val();
	var	callRelated = $("#callRelated").val();
	var	callDeatils   = $("#callDeatils").val();
	var	callDescription   = $("#callDescription").val();

	
	if(callContactName=="" || callContactName===undefined){
	    $("#callContactName").css('border-color','red');
	    $('#callContactName').focus();
	    return false;
	}else if(callSubject=="" || callSubject===undefined){
	    $("#callSubject").css('border-color','red');
	    $('#callSubject').focus();
	    return false;
	}else if(callPurpose=="" || callPurpose===undefined){
	    $("#callPurpose").css('border-color','red');
	    $('#callPurpose').focus();
	    return false;
	}else if(callRelated=="" || callRelated===undefined){
	    $("#callRelated").css('border-color','red');
	    $('#callRelated').focus();
	    return false;
	}else if(callDeatils=="" || callDeatils===undefined){
	    $("#callDeatils").css('border-color','red');
	    $('#callDeatils').focus();
	    return false;
	}else if(callDescription=="" || callDescription===undefined){
	    $("#callDescription").css('border-color','red');
	    $('#callDescription').focus();
	    return false;
	}else{
	    $("#saveDataCall").val('1');
	    $('#call_click').modal('hide');
	    return true;
	}
});
$("#callClose").click(function(){
    $('#call_click').modal('hide');
    $("#saveDataCall").val('0');
    $('#callForm')[0].reset();
});
</script>