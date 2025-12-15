<?php $this->load->view('common_navbar');?>
<style>
.timeIc{ color: #18a2b8;
    margin: 2px;
}

  #calendar {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 10px;
  }
  
   #top {
    background: #eee;
    border-bottom: 1px solid #ddd;
    padding: 0 10px;
    line-height: 40px;
    font-size: 12px;
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
<link href='<?= base_url();?>assets/css/main.css' rel='stylesheet' />
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Your Task</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Task</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
      
    <!-- /.content-header -->
    <div class="container-fliud filterbtncon"  >

			  <form method="post" action="" >
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

   
   <div class="col-lg-2">
          <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button> 
      <input  type="hidden" id="tast_status" name="tast_status">
      <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <!-- <select class="custom-select" name="user_filter" id="user_filter"> -->
                
                  <li onclick="getfilterdData('1','tast_status');">Not Started</li>
                  <li onclick="getfilterdData('2','tast_status');">Completed</li>
                  <li onclick="getfilterdData('3','tast_status');">Progress</li>
                  <li onclick="getfilterdData('4','tast_status');">Pending</li>
                  <li onclick="getfilterdData('deactive','tast_status');">Deactive</li>
                  
                
                
            </ul>
            </div>
		  </div>


                       
                       
      <div class="col-lg-2"></div>
            <div class="col-lg-6">
               <div class="refresh_button float-right">
						<button class="btnstopcorner"  onclick="reload_table()"><i class="fas fa-redo-alt"></i></button>
						<?php if(check_permission_status('Task','create_u')==true){ ?>
						<button type="button" class="btn btnstop add_button rounded-0" id="AddTask"  style="color:fff;">Add Task</a></button>
						<?php } ?>
						<button class="btn btnstopcorn rounded-0" type="button" onclick="reload_table()" id="listView" >List View</button>								 
						<button type="button" class="btn btncorner add_button rounded-0" id="calenderView">Calender View</a></button>
								  
					 </div>
                    <div class="clearfix"></div>
						  
            </div>
            </div>  
                  </div>
                </form>
            </div> 
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <div class="card-body" id="countSearch">
                <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                    <thead>
                        <tr>                     
                            <th class="th-sm">Task</th>
                            <th class="th-sm">Task Owner</th>
                            <th class="th-sm">Priority</th>
                            <th class="th-sm">Due Date</th>
							<th class="th-sm">Status</th>
							<th class="th-sm" style="width:9%">Action</th>
                        </tr>
                    </thead>
                    <tbody>         
                    </tbody>
                </table>
				
              </div>
              <div class="" id="calendarDiv" > 
				        <div id='calendar'></div>
			  </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->




<link rel="stylesheet" href="<?= base_url();?>assets/css/filter_multi_select.css" />
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
.lbl{
	padding-top: 12px;
}


</style>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edittask">View/Update Task</h5>
        </button>
      </div>
      <div class="modal-body">
        <form class="task-form" id="taskForm" method="post">
            <input type="hidden" value="0"  name="saveDatatask" id="saveDatatask">
            <input type="hidden" value="0"  name="updateDatataskid" id="updateDatataskid">
            <input type="hidden" value="0"  name="addtaskCheck" id="addtaskCheck">
            
            <div class="row" id="formDivhd">
                
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
                    <span class="form-control">Task Subject<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" placeholder="Subject" name="taskSubject" id="taskSubject" >
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Task From Date : </span>
                </div>
                
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="taskFromDate" id="taskFromDate" onfocus="(this.type='date')" placeholder="From Date">
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Task Due Date<span style="color: #f76c6c;">*</span> </span>
                </div>
                
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="taskDueDate" id="taskDueDate" onfocus="(this.type='date')" placeholder="Due Date">
                </div>
                 <div class="col-md-4 form-group">
                   <span class="form-control">Task Priority<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <select class="form-control" name="taskPriority" id="taskPriority">
                        <option value="">Select Priority</option>
                        <option value="High">High</option>
                        <option value="Highest">Highest</option>
                        <option value="Low">Low</option>
                        <option value="Lowest">Lowest</option>
                        <option value="Normal">Normal</option>
                    </select>
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Task Owner<span style="color: #f76c6c;">*</span> </span>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="taskOwner" id="taskOwner" value="<?= $this->session->userdata('name'); ?>">
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Task Asigned To : </span>
                </div>
                
                <div class="col-md-8 form-group" style="display:none;" id="userINput">
                    <select class="form-control selctCl" multiple name="taskUser[]" id="taskUser" >
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
                   <span class="form-control">Task Reminder : </span>
                </div>
                <div class="col-md-8 form-group">
                    <label class="switch ">
                          <input type="checkbox" type="checkbox" value="1"  name="taskReminder" id="taskReminder" style="margin-left:13px;">
                          <span class="slider round" style="background-color:#efe9e9;"></span>
                   </label>
                    <!--<input type="checkbox" value="1"  name="taskReminder" id="taskReminder"  style="margin-left:13px;" >--> 
                </div>
                
                <div class="col-md-4 form-group">
                   <span class="form-control">Task Repeat : </span>
                </div>
                <div class="col-md-8 form-group">
                    <label class="switch ">
                          <input type="checkbox" value="1"  name="taskRepeat" id="taskRepeat"  style="margin-left:13px;">
                          <span class="slider round" style="background-color:#efe9e9;"></span>
                   </label>
                    <!--<input type="checkbox" value="1"  name="taskRepeat" id="taskRepeat" style="margin-left:13px;" >-->
                    
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
                        <option value="4">Pending</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                   <span class="form-control">Remarks : </span>
                </div>
                <div class="col-md-8 form-group">
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
        <button type="button" class="btn btn-info"  id="edittaskView">Edit</button>
        <button type="button" class="btn btn-secondary" id="cancelTask" style="display:none;">Cancel</button>
        <button type="button" class="btn btn-info"  id="saveTask" style="display:none;">Update</button>
      </div>
    </div>
  </div>
</div>
<!--task click popup-->


<div class="modal fade" id="emailModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title">Task Email</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding: 5%;">
          <div class="row" id="formDiv">
           
			<div class="col-md-2 lbl">
				<label for="">User Email:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="orgEmail" id="orgEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">CC:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$this->session->userdata('company_email');?>" name="ccEmail" id="ccEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Subject:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="Task Subject" name="subEmail" id="subEmail">
            </div>
			<div class="col-md-12 lbl">
				<label for="">Message*:</label>
			</div>
			
			<div class="col-md-12">
			  <textarea class="form-control" id="descriptionTxt"   name="descriptionTxt"></textarea>
            </div>
          </div>
			<div class="row text-center"   id="messageDivMl" style="display:none; padding: 5%; " >
					
			</div>
				
			<div class="row" id="footerDiv">
				<div class="col-md-12 text-center" style="padding-top: 5%;">
					<button class="btn btn-info" id="sendEmail">Send Email</button>
				</div>
			</div>	
      </div>
    </div>
  </div>
</div>
<?php // echo  json_encode($task); ?>
<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<script src="<?= base_url();?>assets/js/filter-multi-select-bundle.min.js"></script>
<script src='<?= base_url();?>assets/js/main.js'></script>
<script src='<?= base_url();?>assets/js/locales-all.js'></script>

<script>
$("#calenderView").click(function(){
    $("#countSearch").hide();
    $("#calendarDiv").show();
});

$("#listView").click(function(){
    $("#calendarDiv").hide();
    $("#countSearch").show();
});

  document.addEventListener('DOMContentLoaded', function() {
    var initialLocaleCode = 'en';
    var calendarEl = document.getElementById('calendar');
    var d = new Date();
    Date.prototype.yyyymmdd = function() {
          var yyyy = this.getFullYear().toString();
          var mm = (this.getMonth()+1).toString(); 
          var dd  = this.getDate().toString();
          return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
    };

var date = new Date();
var jsonData=<?php echo  json_encode($task); ?>;
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      
      initialDate: date.yyyymmdd(),
      locale: initialLocaleCode,
      buttonIcons: false, // show the prev/next text
      weekNumbers: true,
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: jsonData
    });
    calendar.render();
    $("#calendarDiv, .usetwentyfour").hide();
  });
setTimeout(function(){
    $(".usetwentyfour").hide();
 },1000);

</script>

<script>
var editor = CKEDITOR.replace( 'descriptionTxt' );
CKEDITOR.config.height='150px';
</script>

<script type="text/javascript">
 $(function () { 
     var userName = $('#taskUser').filterMultiSelect(); 
     $('#taskForm').on('keypress keyup', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            return false;
          }
        });
     
 });
 

 function sendmail(id){ 
     
     $.ajax({
              url : "<?= site_url('setting/getbyid_task')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                  var str=data.asign_to;
                  str = str.replace(/\s+/g, '');
                  var res = str.split("<br>");
                  var ressut= res.join(', ');
                  $('#orgEmail').val(ressut);
                  
                 var msg=''; 
                 msg+="<p>Task : "+data.task_subject+"</p>";
                 msg+="<p>Task Due Date : "+data.task_due_date+"</p>";
                 msg+="<p>Task Start Date : "+data.task_from_date+"</p>";
                 msg+="<p>Task Priority : "+data.task_priority+"</p>";
                 msg+="<p>Task Owner : "+data.task_owner+"</p>";
                 msg+="<p>"+data.remarks+"</p>";
                 CKEDITOR.instances['descriptionTxt'].setData(msg);
                  forDisableInput("#sendEmail",0);
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
        });
        
	$('#emailModel').modal('show'); 
}


$("#sendEmail").click(function(){
    
	var orgEmail=$("#orgEmail").val();
	var ccEmail=$("#ccEmail").val();
	var subEmail=$("#subEmail").val();
	var invoiceurl="<?php echo base_url();?>task";
	var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
	if(orgEmail!=""){
	forDisableInput("#sendEmail",1);
	$.ajax({
     url: "<?= site_url(); ?>setting/checkTaskforMail",
     method: "POST",
     data: {orgEmail:orgEmail,ccEmail:ccEmail,subEmail:subEmail,descriptionTxt:descriptionTxt,invoiceurl:invoiceurl},
     success: function(dataSucc){
      if(dataSucc=='1'){
		    $("#formDiv, #footerDiv").hide();
			$("#messageDivMl").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your message has been sent successfully.');
			$("#messageDivMl").css('display','block');
			setTimeout(function(){ $("#messageDivMl").hide(); $("#formDiv, #footerDiv").show(); $('#emailModel').modal('hide'); },4000)
	  }else{
		  $("#formDiv, #footerDiv").hide();
		  $("#messageDivMl").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Something went wrong, Please try later.');
		  $("#messageDivMl").css('display','block');
		  setTimeout(function(){ $("#messageDivMl").hide(); $("#formDiv, #footerDiv").show(); },4000)
	  }
     }
    });
	}
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
            url: "<?php echo site_url('setting/ajax_list_task')?>",
            type: "POST",
			dataType : "JSON",
            data : function(data)
             {
                data.searchDate = $('#date_filter').val();
				data.searchUser = $('#user_filter').val();
				data.tstStatus  = $("#tast_status").val(); 
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
    $('#date_filter, #tast_status').change(function(){
		table.ajax.reload();
		
    });
    
 
    
	$('#user_filter').change(function(){
		table.ajax.reload();
		
    });
    
    $('#firstDate,#secondDate').change(function(){
		table.ajax.reload();
		
    });
    
  }); 

  function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

table.ajax.reload();
}
  function reload_table()
  {
    table.ajax.reload(null,false); //reload datatable ajax
  }
  //delete proforma invoice
  function delete_entry(id)
  {
      if(confirm('Are you sure delete this data?'))
      {
          // ajax delete data to database
          $.ajax({
              url : "<?= site_url('setting/delete_task')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                if(data.status) 
                {
                    alert('Task deleted successfully.')
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
              url : "<?= site_url('setting/getbyid_task')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                  
                  
                  
                 $('#updateDatataskid').val(data.id);
                 $('#taskSubject').val(data.task_subject);
                 $('#taskDueDate').val(data.task_due_date);
                 $('#taskFromDate').val(data.task_from_date);
                 $('#taskPriority').val(data.task_priority);
                 $('#taskOwner').val(data.task_owner);
                 $('#taskStatus').val(data.status);
                 $('#taskRemarks').val(data.remarks);
                 $("#userINput").hide();
                 $("#userList").show();
                
               
                var prtcpnt= data.asign_to;
                var res = prtcpnt.split("<br>");
                 //alert(res.length);
                for (var i=0; i < res.length; i++)
                {
                  if(res[i]){
                      var new_string = res[i].replace('@','');
                      new_string = new_string.replace(/[.]/g,'');
                     $("#"+new_string).css('display','inline-block');
                  }
                    
                }
                 
                 
                 $("#addtaskCheck").val('update');
                 if(data.task_reminder==1){
                    $('#taskReminder').prop('checked',true);
                 }
                 if(data.task_repeat==1){
                    $('#taskRepeat').prop('checked',true);
                 }
                  $("#cancelTask").click();
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
        });
        
        if(oppid!=""){
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
      
      
      $("#exampleModal").modal('show');
    
  }
  
   
  $("#edittaskView").click(function(){
    $("#saveDatatask").val('1');
    $("#edittaskView, #closeTask, #userList").hide();
    $("#saveTask, #cancelTask, #userINput").show();
    $(".task-form input").css('border','0px');
    $(".task-form input").css('border-bottom','1px solid #e0e0e0');
    $(".task-form select").css('border-bottom','1px solid #e0e0e0');
    $(".task-form textarea").css('border-bottom','1px solid #e0e0e0');
    forDisableInput(".task-form input",0);
    forReadOnlyInput(".task-form input",0);
    forDisableInput(".task-form select",0);
    forReadOnlyInput(".task-form textarea",0);
    $("#edittask").text('View/Update Task');
    
});
  
$("#closeTask").click(function(){
    $("#saveDatatask").val('0');
    $('#exampleModal').modal('hide');
    $('#taskForm')[0].reset();
    $("#edittaskView, #closeTask, #userList").show();
    $("#saveTask, #cancelTask, #userINput").hide();
    forDisableInput(".task-form input",1);
    forReadOnlyInput(".task-form input",1);
    forDisableInput(".task-form select",1);
    forReadOnlyInput(".task-form textarea",1);
   
});

$("#cancelTask").click(function(){
   // $('#taskForm')[0].reset();
    $("#saveDatatask").val('0');
    $("#edittaskView, #closeTask, #userList").show();
    $("#saveTask, #cancelTask, #userINput").hide();
    $(".task-form input").css('border','0px');
    $(".task-form select").css('border','0px');
    $(".task-form textarea").css('border','0px');
    forDisableInput(".task-form input",1);
    forReadOnlyInput(".task-form input",1);
    forDisableInput(".task-form select",1);
    forReadOnlyInput(".task-form textarea",1);
});



$("#AddTask").click(function(){ 
    $('#taskForm')[0].reset();
    $("#saveTask").html('Save');
    $("#exampleModal").modal('show');
    $("#edittaskView").click();
    $("#organizationFld").hide();
    $("#addtaskCheck").val('add');
    $("#edittask").text('Add Task');
 });

	 
/****** VALIDATION FUNCTION*********/
function changeClr(idinpt){
  $('#'+idinpt).css('border-color','red');
  $('#'+idinpt).focus();
  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
}

$("#saveTask").click(function(){
    var	taskSubject = $("#taskSubject").val();
	var	taskDueDate = $("#taskDueDate").val();
	var	taskPriority= $("#taskPriority").val();
	var	taskOwner   = $("#taskOwner").val();
	var	taskReminder= $("#taskReminder").val();
	var	taskRepeat  = $("#taskRepeat").val();
	if(taskSubject=="" || taskSubject===undefined){
	    changeClr('taskSubject');
	    return false;
	}else if(taskDueDate=="" || taskDueDate===undefined){
	    changeClr('taskDueDate');
	    return false;
	}else if(taskPriority=="" || taskPriority===undefined){
	   changeClr('taskPriority');
	    return false;
	}else if(taskOwner=="" || taskOwner===undefined){
	    changeClr('taskOwner');
	    return false;
	}else{
	    $("#saveTask").html('<i class="fas fa-spinner fa-spin"></i>');
	    forDisableInput("#saveTask",1);
	    var dataString = $("#taskForm").serialize();
	    var adddt=$("#addtaskCheck").val();
	    if(adddt=='add'){
            var url = "<?= base_url('setting/addTask')?>";
	    }else{
	        var url = "<?= base_url('setting/updateTask')?>";   
	    }
       
        $.ajax({
            url : url,
            type: "POST",
            data: dataString,
            dataType: "JSON",
            success: function(data)
            { 
                console.log(data)
              if(data.status) 
              {
                  
                  $("#formDivhd").hide();
                  $("#messageDiv").show();
                  if(adddt=='add'){
                    $("#putmsg").html('<span style="display: block;"><i class="far fa-check-circle" style="font-size: 35px; color: #77bb77f0; margin-bottom: 28px;"></i></span><span>Your task successfully created.');
                  }else{
                    $("#putmsg").html('<span style="display: block;"><i class="far fa-check-circle" style="font-size: 35px; color: #77bb77f0; margin-bottom: 28px;"></i></span><span>Your task successfully updated.');  
                  }
                  setTimeout(function(){  
                  console.log("A");
                  $('#add_popup').modal('hide');
                  reload_table();
                  $("#saveTask").html('Update');
	              forDisableInput("#saveTask",0);
	              $("#closeTask").click();
	              $("#formDivhd").show();
                  $("#messageDiv").hide();
                },3000); 
	              
              }else{
                  $("#formDivhd").hide();
                  $("#messageDiv").show();
                  $("#putmsg").html('<span style="display: block;"><i class="fas fa-exclamation-triangle" style="font-size: 35px; color: #e68e88; margin-bottom: 28px;"></i></span><span>Something went wrong, Try later.')
                  $("#saveTask").html('Update');
	              forDisableInput("#saveTask",0);
	               setTimeout(function(){ $("#formDivhd").show();
                  $("#messageDiv").hide();  $("#cancelTask").click(); },4000)
              }
              
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                   $("#saveTask").html('Update');
	               forDisableInput("#saveTask",0);
	               $("#cancelTask").click();
            }
        });
	}
    
});

$('.form-control').keypress(function(){
  $(this).css('border-color','')
});
$('.form-control').change(function(){
  $(this).css('border-color','')
});
</script>
<?php
if(isset($_GET['tid']) && $_GET['tid']!=""){
?>
<script>
	view("<?=$_GET['tid'];?>");
	var urlCur      = window.location.href;
	var  myArr 		= urlCur.split("?");
	var url			= myArr[0];
	if (window.history.replaceState) {
	   window.history.replaceState('', '', url);
	}
</script>
<?php } ?>
