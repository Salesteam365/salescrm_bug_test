<?php $this->load->view('common_navbar');?>
<style>
.timeline-one .events ul li a {
    font-size: 12px;
    top: -30px;
    font-weight: 600;
}
.timeline-one .events ul li {
    width: 24%;
}
.timeline-one .events ul li .selected_gray:after {
    background: #606060;
}
.timeline-one .events{
  margin: 16px 0;
  height: 2px;
}
.timeline-one{
  height: auto;
}

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Log Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            
          </div><!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="card org_div">
          <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home"><i class="far fa-newspaper"></i>Filter List</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu1"><i class="fas fa-filter"></i>Advance</a>
              </li>
            </ul>
            <div class="tab-content">
              <div id="home" class="container-fluid tab-pane active"><br>
                <div class="call-history">
                  <ul class="list-inline">
                    <li class="list-inline-item"><a href="#"><i class="fas fa-phone-square-alt red"></i>Missed Calls</a></li>
                    <li class="list-inline-item"><a href="#"><i class="fas fa-phone-square-alt orange"></i>Connected Calls</a></li>
                    <li class="list-inline-item"><a href="#">Voicemails</a></li>
                  </ul>
                </div>
              </div>



              <div id="menu1" class="container-fluid tab-pane fade"><br>
                <form class="form-horizontal">
                  <div class="form-group row">
                    <div class="col-lg-12">
                      <label>Criteria's</label>
                      <input type="text" name="" placeholder="Select Criteria" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <label>Date (From)</label>
                      <input type="date" name="" placeholder="Enter Date" class="form-control">
                    </div>
                    <div class="col-lg-6">
                      <label>Date (To)</label>
                      <input type="date" name="" placeholder="Enter Date" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <label>Time (Start)</label>
                      <input type="time" name="" placeholder="Enter Time" class="form-control">
                    </div>
                    <div class="col-lg-6">
                      <label>Date (End)</label>
                      <input type="time" name="" placeholder="Enter Time" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-12">
                      <label>Duration filter</label>
                      <select class="form-control">
                        <option disabled="" selected="">Choose a duration</option>
                        <option>Less than 1 Min</option>
                        <option>More than 1 Min</option>
                        <option>1 Min to 2 Min</option>
                        <option>2 Min to 5 Min</option>
                        <option>More than  5 Min</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-4">
                      <button class="btn btn-info" type="button">Save To List</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="card org_div">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <form class="form-group has-search">
                  <span class="fa fa-search form-control-feedback"></span>
                  <input type="text" class="form-control" placeholder="Search Number, User, Department">
                </form>
              </div>
              <div class="col-lg-6">
                <div class="print-icon text-right">
                  <a href="#"><i class="fa fa-archive"></i></a>
                  <a href="#"><i class="fa fa-download"></i></a>
                  <a href="#"><i class="fas fa-file-audio"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- /.content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <!-- /.card-header -->
              <?php if($loglist->status='success'){   ?>
              <div class="card-body">
                  
                <table id="dt-multi-checkbox" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                  <thead>
                  <tr>
                    <th><i class="fa fa-trash text-dark"></i></th>
                    <th class="th-sm">Who</th>
                    <th class="th-sm">What</th>
                    <th class="th-sm">When</th>
                    <th></th>
                  </tr>
                </thead>

                <tbody>
                 
                 <?php 
    			    $logData=$loglist->data; 
    			    $sourc=$logData->hits;
    			    $id=545;
    			    for($i=0; $i<count( $sourc); $i++){
    			    $data=$sourc[$i]->_source;  
    			    $uid=$data->additional_parameters; 
    			         $comment=$data->log_details; 
    			         $rvv='';
    			         foreach($comment as $dat){
    			             $recivedBy=$dat->received_by;
    			             $action=$dat->action;
    			             $datime=$dat->_rst;
    			             
    			             $duration=$dat->duration;
    			             if(count($recivedBy)>0){
    			             $rvv=$recivedBy[0]->name;
    			             }
    			         }
    			     date_default_timezone_set('Asia/Kolkata');
                     $newDateTime = date('h:i A   d M', strtotime($datime));
    			    ?>   
                    
                    <tr >
                        <td><input type="checkbox" name="" ></td>
                        <td data-toggle="collapse" data-target="#accordion<?=$id;?>" class="clickable" >
                            
                            <?php  if($rvv==""){ ?>
                            <i class="fas fa-phone-square-alt red"></i>
                             <?php  }else if($action=="received"){ ?>
                            <i class="fas fa-phone-square-alt cyan"></i>
                            <?php }else{ ?>
                            <i class="fas fa-phone-square-alt orange"></i>
                            <?php } ?>
                            <?php if($data->_cm!=""){
                                    echo $data->_cm;
                                }else{
                                    echo $data->caller_number;
                                }
                            ?>
                            
                        </td>
                        <td data-toggle="collapse" data-target="#accordion<?=$id;?>" class="clickable">
                            <?php if($rvv==""){ ?>
                            Missed Call
                            <?php }else{ ?>
                            Outgoing call. <?=$action;?> by <span style=""><?=$rvv;?></span>
                            <?php } ?>
                            <?php if($data->department_name!=""){?>
                            At <?=$data->department_name;?>
                            <?php } ?>
                            
                        </td>
                        <td data-toggle="collapse" data-target="#accordion<?=$id;?>" class="clickable"><?=$newDateTime;?></td>
                        <td><i class="far fa-star"></i></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="padding: 0;">
                            <div id="accordion<?=$id;?>" class="collapse accordion" >
                              <div class="row py-3 m-0">
                                <div class="col-lg-3">
                                  <div class="row">
                                    <div class="col-lg-2">
                                      <i class="fas fa-barcode"></i>
                                    </div>
                                    <div class="col-lg-10">
                                      <h5>UID</h5>
                                      <p><?=$uid[0]->vl;?></p>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="row">
                                    <div class="col-lg-2">
                                      <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="col-lg-10">
                                      <h5>Region</h5>
                                      <p><?=$data->state;?></p>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="row">
                                    <div class="col-lg-2">
                                      <i class="far fa-clock"></i>
                                    </div>
                                    <div class="col-lg-10">
                                      <h5>Duration</h5>
                                      <p><?=$data->duration;?></p>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-3">
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <h5>Recording</h5>
                                      
                                      <?php 
                                      if($data->filename){
                                      
                                      $cURLConnection = curl_init();
                                            curl_setopt($cURLConnection, CURLOPT_URL, 'https://developers.myoperator.co/recordings/link?token=3db54ae2405076bfc0784021b9c07500&file='.$data->filename);
                                            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                                            $phoneList = curl_exec($cURLConnection);
                                            curl_close($cURLConnection);
                                            $jsonArrayResponse= json_decode($phoneList);
                                     
                                      ?>
                                       <audio controls="controls"><source src="<?=$jsonArrayResponse->url;?>" type="audio/mpeg"></audio>
                                    <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row p-3">
                                <div class="col-lg-2">
                                  <a href="#" data-toggle="modal" data-target="#notes_modal">Notes</a>
                                </div>
                                <div class="col-lg-2">
                                  <a href="#" data-toggle="modal" data-target="#addcontact_modal">Add Contact</a>
                                </div>
                                <div class="col-lg-2">
                                  <a href="#" data-toggle="modal" data-target="#blocknumber_modal">Block Caller</a>
                                </div>
                                <div class="col-lg-2">
                                  <a href="#" data-toggle="modal" data-target="#clickcall_modal">Call</a>
                                </div>
                                <div class="col-lg-2">
                                  <a href="#" data-toggle="modal" data-target="#detaillog_modal">Detail Log</a>
                                </div>
                                <div class="col-lg-2"></div>
                              </div>
                            </div>
                        </td>
                    </tr>
                    <?php $id++; } ?>
                </tbody>
                </table>
              </div>
              <?php } ?>
              <!-- /.card-body -->
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
<!-- /.content-wrapper -->

<!-- Notes Modal -->
<div class="modal fade profile_popup" id="notes_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title">Notes</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <h6>+918448283045</h6>
        <hr>
        <div class="row notes-overview">
          <div class="col-lg-1">
            <i class="fa fa-user"></i>
          </div>
          <div class="col-lg-9">
            <p>Mahendar Pal</p>
            <span>wdwdwd</span>
          </div>
          <div class="col-lg-2">
            <span>09:46am</span>
          </div>
        </div>
        <form>
          <div class="form-group">
            <textarea class="form-control" rows="4" placeholder="Type comment here and press Enter Key to save"></textarea>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Notes Modal -->

<!-- add contact Modal -->
<div class="modal fade profile_popup" id="addcontact_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title"><i class="fa fa-user"></i>Add Contact</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" name="userinfo" id="userinfo" action="">
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Full Name*</label>
              <input type="text" name="userName" id="userName" placeholder="Enter Name" class="form-control">
            </div>
            <div class="col-lg-6">
              <label>Email</label>
              <input type="email" name="userEmail" id="userEmail" placeholder="Enter Mail Id" class="form-control">
            </div>
          </div>
          
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Extension* <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="Short code that can be entered by callers for extension dialing"></i></label>
              <input type="text" name="userExt" id="userExt" placeholder="Enter Extension Number" class="form-control">
            </div>
            
            <div class="col-lg-6">
              <label>Phone number*</label>
              
                  <select class="form-control" name="phoneType" id="phoneType">
                    <option value="Mobile ">Mobile</option>
                    <option value="SIP">Wireline</option>
                    <option value="Landline">Virtual</option>
                  </select>
                
            </div>
            
          </div>
          
          
          <div class="form-group row">
            <div class="col-lg-6">
              <label>Country Code*</label>
              <input type="text" name="cod_cntry" id="cod_cntry" placeholder="Enter Country Code +91" class="form-control">
            </div>
            
            <div class="col-lg-6">
              <label>Phone number*</label>
                  <input type="text" name="userMobile" id="userMobile" class="form-control" placeholder="Enter Mobile Number">
            </div>
          </div>
        
          
          <div class="form-group row">
            <div class="col-lg-12">
             <a href="#" data-toggle="collapse" data-target="#accordion" >
                 <i class="fa fa-plus-square"></i>Add Alternate Number</a>
            </div>
          </div>
          
          <div class="form-group collapse" id="accordion">
              <div class="row">
                <div class="col-lg-6">
                   <label>Alternate Number</label>
                  <input type="text" name="alt_num" id="alt_num" placeholder="Enter Alternate Number" class="form-control">
                 </div>
                <div class="col-lg-6">
                  <label>Country Code (If Alternate No.) </label>
                  <input type="text" name="alt_cntry" id="alt_cntry" placeholder="Enter Country Code" class="form-control">
                </div>
              </div>
          </div>
          

          <a class="" data-toggle="collapse" href="#collapseExample" role="button" style="display:none;" aria-expanded="false" aria-controls="collapseExample">Advance Setting</a>
          <div class="collapse" id="collapseExample" style="display:none;">
            <div class="card card-body">
              <div class="form-group row">
                <div class="col-lg-12">
                  <label>Time schedule to receive call</label>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4">
                  <select class="form-control">
                    <option selected="" disabled="">Days</option>
                    <option>All Days</option>
                    <option>Mon-Sat</option>
                    <option>Mon-Fri</option>
                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                  </select>
                </div>
                <div class="col-lg-4">
                  <select class="form-control">
                    <option disabled="" selected="">Start Time</option>
                    <option>12:00am</option>
                    <option>12:30am</option>
                    <option>01:00am</option>
                    <option>01:30am</option>
                    <option>02:00am</option>
                  </select>
                </div>
                <div class="col-lg-4">
                  <select class="form-control">
                    <option disabled="" selected="">Start Time</option>
                    <option>12:00am</option>
                    <option>12:30am</option>
                    <option>01:00am</option>
                    <option>01:30am</option>
                    <option>02:00am</option>
                  </select>
                </div>
                <div class="col-lg-12 my-2">
                  <a href="#"><i class="fa fa-plus-square"></i>Add Row</a>
                </div>
              </div>
              <div class="row pro-license">
                <div class="col-lg-10">
                  <span class="activate">Pro License</span>
                  <p>Panel access and mobile sync for users only if enabled</p>
                </div>
                <div class="col-lg-2">
                  <label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider round"></span>
                  </label>
                </div>
                <div class="row m-0">
                <div class="col-lg-12">
                  <label>License/Role</label>
                  <select class="form-control">
                    <option>Administrator</option>
                    <option>Manager</option>
                    <option>Call Agent</option>
                  </select>
                  <p>Administrator is the head of the MyOperator account for your organization. Administrators or owner can access the call logs of every user.</p>
                </div>
              </div>
              </div>
            </div>
          </div>
        </form>
        
        <div class="form-group row" style="display:none;" id="msgDiv">
            <div class="col-lg-12 text-center" id="putMsg">
              <span style="display:block;">
                  <i class="far fa-check-circle" style="font-size: 30px; color: #28a7458c; margin-bottom: 20px;" ></i></span>
              <span>User information added successfully.</span>
            </div>
        </div>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="saveData" class="btn btn-success" onClick="saveUser();">Save</button>
      </div>

    </div>
  </div>
</div>
<!-- add contact Modal -->

<!-- block number modal -->

<div class="modal fade profile_popup" id="blocknumber_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title"><i class="fa fa-ban"></i>Block Number</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form>
          <div class="form-group row">
            <div class="col-lg-12">
              <label>Number to block</label>
              <input type="text" name="" placeholder="Enter Mobile Number" class="form-control">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-12">
              <label>Name (Optional)</label>
              <input type="text" name="" placeholder="Enter Name" class="form-control">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-12">
              <label>Reason </label>
              <textarea class="form-control" rows="3" placeholder="Type Reason Here"></textarea>
            </div>
          </div>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success">Save</button>
      </div>

    </div>
  </div>
</div>

<!-- block number modal -->

<!-- click to call modal -->

<div class="modal fade profile_popup" id="clickcall_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title"><i class="fas fa-phone-alt"></i>ClickOCall</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="callForm">
          <div class="form-group row">
            <div class="col-lg-12">
              <label>Number</label>
              <input type="text" name="PhoneNumber" id="PhoneNumber" placeholder="Enter Mobile Number" class="form-control">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-lg-12">
              <label>Select User</label>
              <select class="form-control" name="userId" id="userId">
                  <?php 
    			    $userData=$userList->data; 
    			    foreach($userData as $row){
    			    ?>  
    			    <?php if($row->is_enabled==1){ ?>
    			    <option value="<?=$row->uuid;?>" ><?=$row->name;?></option>
                <?php } } ?>
              </select>
            </div>
          </div>
        </form>
        
        <div class="row mt-3">
            <div class="col-lg-12">
                The call will connect you first before connecting to the customer.
            </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" name="callBtn" id="callBtn" >Call</button>
      </div>

    </div>
  </div>
</div>

<!-- click to call modal -->


<!-- calldetail modal -->

<div class="modal fade profile_popup" id="detaillog_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title">Detail log for uid: d3.1615455933.515275</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table class="table table-bordered table-striped table-responsive-lg">
          <thead>
            <tr>
              <th>Time</th>
              <th>Logs Message</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>03:15:33 pm</td>
              <td>Agent first case is requested</td>
            </tr>

            <tr>
              <td>03:15:33 pm</td>
              <td>OBD V2 Initiated</td>
            </tr>

            <tr>
              <td>03:15:33 pm</td>
              <td>Agent is available</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- calldetail modal -->


<!-- ./footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="http://www.allegientservices.com/" target="_blank">Allegient Services</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 365.2.4
    </div>
  </footer>
</div>
<!-- ./footer -->

<!-- common footer include -->
<?php $this->load->view('common_footer');?>

<script src="<?=base_url();?>assets/js/audio.min.js"></script>
<script>
    $('audio').initAudioPlayer();
</script>

<script>

$("#callBtn").click(function(){  
    var PhoneNumber=$("#PhoneNumber").val();
    var userId=$("#userId").val();
    if(PhoneNumber==""){
        $("#PhoneNumber").css('border-color','red');
        setTimeout(function(){ $("#PhoneNumber").css('border-color',''); },3000);
    }else if(userId=="" || userId===null){
        $("#userId").css('border-color','red');
        setTimeout(function(){ $("#userId").css('border-color',''); },3000);
    }else{ 
        
    $("#callBtn").html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calling...');
  
    url = "<?= site_url('users/call')?>";
    $.ajax({
          url : url,
          type: "POST",
          data: $('#callForm').serialize(),
         // dataType: "JSON",
          success: function(data)
          {
            console.log(data);
            if(data.status==200) 
            {
                $("#putMsg").html('<span style="display:block;"> <i class="far fa-check-circle" style="font-size: 30px; color: #28a7458c; margin-bottom: 20px;" ></i></span> <span>User information added successfully.</span>');
                $('#userinfo')[0].reset();
            }else{
                $("#putMsg").html('<span style="display:block;"> <i class="fas fa-exclamation-triangle" style="font-size: 30px; color: #ff57228c; margin-bottom: 20px;" ></i></span> <span>Something went wrong please try later.</span>');
            }
             $("#callBtn").html('Call');
            $("#userinfo").hide();
            $("#msgDiv").show();
            setTimeout(function(){
               $("#userinfo_modal").modal('hide');
            },4000);
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error adding / update data');
              $('#callBtn').text('save'); //change button text
              $('#callBtn').attr('disabled',false); //set button enable
          }
      });
    }
    
});



function saveUser(){
    
    var userName=$("#userName").val();
    var userExt=$("#userExt").val();
    var cod_cntry=$("#cod_cntry").val();
    var userMobile=$("#userMobile").val();
    
    if(userName==""){
        $("#userName").css('border-color','red');
        setTimeout(function(){ $("#userName").css('border-color',''); },3000);
    }else if(userExt==""){
        $("#userExt").css('border-color','red');
        setTimeout(function(){ $("#userExt").css('border-color',''); },3000);
    }else if(cod_cntry==""){
        $("#cod_cntry").css('border-color','red');
        setTimeout(function(){ $("#cod_cntry").css('border-color',''); },3000);
    }else if(userMobile==""){
        $("#userMobile").css('border-color','red');
        setTimeout(function(){ $("#userMobile").css('border-color',''); },3000);
    }else{ 
        
    $("#saveData").html(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
  
    url = "<?= site_url('users/adduser')?>";
    $.ajax({
          url : url,
          type: "POST",
          data: $('#userinfo').serialize(),
          dataType: "JSON",
          success: function(data)
          {
              console.log(data);
            if(data.status==200) 
            {
                $("#putMsg").html('<span style="display:block;"> <i class="far fa-check-circle" style="font-size: 30px; color: #28a7458c; margin-bottom: 20px;" ></i></span> <span>User information added successfully.</span>');
                $('#userinfo')[0].reset();
            }else{
                $("#putMsg").html('<span style="display:block;"> <i class="fas fa-exclamation-triangle" style="font-size: 30px; color: #ff57228c; margin-bottom: 20px;" ></i></span> <span>Something went wrong please try later.</span>');
            }
             $("#saveData").html('Save');
            $("#userinfo").hide();
            $("#msgDiv").show();
            setTimeout(function(){
               $("#userinfo_modal").modal('hide');
               
            },4000);
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error adding / update data');
              $('#btnSave').text('save'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable
          }
      });
    }
}





$(document).ready(function () {
   var table = $('#dt-multi-checkbox').DataTable({
        "order": [], 
        "columnDefs": [
        {
            "targets": [0], //last column
            "orderable": false, //set not orderable
        },
        ],
    });
});
</script>
