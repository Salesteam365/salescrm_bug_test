<?php $this->load->view('common_navbar');?>
<style>

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users</h1>
            <p>User can receive or make call or access MyOperator panel as per their role and settings</p>
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
            <div class="row">
              <div class="col-lg-3">
                <form class="form-group has-search">
                  <span class="fa fa-search form-control-feedback"></span>
                  <input type="text" class="form-control" placeholder="Search">
                </form>
              </div>
              <div class="col-lg-9 text-right">
                <button type="button" class="btn bg-info btn-tool" data-toggle="modal" data-target="#userinfo_modal"><i class="fas fa-plus"></i>Add New</button>
                <button class="btn btn-default" type="button"><i class="fas fa-print"></i>Print</button>
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
               <?php if($userList->status='success'){  ?>
              <div class="card-body">
                <table id="dt-multi-checkbox" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                   <thead>
                  <tr>
                    <th>Extension</th>
                    <th>Detail</th>
                    <th>Call availability</th>
                    <th></th>
                  </tr>
                </thead>

                <tbody>
                    
                  <?php 
    			    $userData=$userList->data; 
    			    //print_r($userData);
    			    $i=1;
    			    foreach($userData as $row){
    			    ?>   
                    
                   <tr>
                     <td><?=$row->extension;?></td>
                     <td>
                       <div class="row">
                         <div class="col-lg-6">
                           <b><?=$row->name;?></b>
                           <p class="information" data-toggle="tooltip" data-placement="left" title="Owner is the head of the MyOperator account for your organization.Owner can access the call logs of every user.">
                               <?php if($row->role_id==1){ echo "Owner"; } ?></p>
                         </div>
                         <div class="col-lg-6">
                           <p><?=$row->contact_number;?></p>
                           <p><?=$row->email;?></p>
                         </div>
                       </div>
                     </td>
                     <td>
                         <?php if($row->is_enabled==1){ ?>
                            <i class="fas fa-mobile-alt call-on"></i><p>On</p>
                       <?php }else{ ?>
                            <i class="fas fa-phone-slash"></i><p>Off</p>
                       <?php }  ?>
                     </td>
                     <td>
                       <div class="dropdown">
                          <button class="btn float-right" type="button" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                          <ul class="dropdown-menu">
                            <li><a href="#">Edit</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#setavailability_modal">Set Call Availability</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#roletransfer_modal">Role Transfer</a></li>
                          </ul>
                        </div>
                     </td>
                   </tr>
                      <?php $i++;  } ?>
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


<!-- block number modal -->

<div class="modal fade profile_popup" id="userinfo_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title">User information</h6>
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
        <button id="saveData" type="button" class="btn btn-success" onClick="saveUser();">Save</button>
      </div>

    </div>
  </div>
</div>

<!-- block number modal -->

<!-- call availability modal -->

<div class="modal fade profile_popup" id="setavailability_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title">Set call availability</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table class="table table-responsive-lg table-bordered table-striped">
          <thead>
            <tr>
              <th>Extension</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>10</td>
              <td>
                <div class="row">
                 <div class="col-lg-6">
                   <b>Mahendra Pal</b>
                   <p class="information" data-toggle="tooltip" data-placement="left" title="Owner is the head of the MyOperator account for your organization.Owner can access the call logs of every user.">Owner</p>
                 </div>
                 <div class="col-lg-6">
                   <p>+919873550688</p>
                   <p>sales@team365.io</p>
                 </div>
               </div>
              </td>
            </tr>
          </tbody>
        </table>
          <div class="form-group row pro-license">
            <div class="col-lg-10">
              <p><i class="fa fa-mobile"></i>Make or receive calls from the user's mobile</p>
            </div>
            <div class="col-lg-2">
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider round"></span>
              </label>
            </div>
          </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success">Save</button>
      </div>

    </div>
  </div>
</div>

<!-- call availability modal -->

<!-- transfer ownership modal -->

<div class="modal fade profile_popup" id="roletransfer_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title">Transfer Ownership</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 text-center">
              <div class="transfer-inner">
                <i class="fa fa-random"></i>
                <h6>Transfer ownership</h6>
                <span>This will make the present owner to a call agent</span>
                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#newownermodal">Transfer Now</button>
              </div>
            </div>
            <div class="col-lg-6 text-center">
              <div class="transfer-inner">
                <i class="fas fa-pencil-alt"></i>
                <h6>Edit Number</h6>
                <span>Phone number would be verified via OTP</span>
                <button class="btn btn-info" data-toggle="modal" data-target="#mobilenumberchange_modal">Edit Now</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- transfer ownership modal -->

<!-- new owner modal -->

<div class="modal fade profile_popup" id="newownermodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title">Transfer Ownership</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <div class="col-lg-12">
            <div class="row">
              <label>New Owner</label>
              <select class="form-control">
                <option disabled="" selected="">Select User</option>
                <option>Mahendra Pal</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
        <button type="button" class="btn btn-success">Save</button>
      </div>

    </div>
  </div>
</div>

<!-- new owner modal -->

<!-- mobile number change modal -->

<div class="modal fade profile_popup" id="mobilenumberchange_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title">Transfer Ownership</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form>
          <div class="form-group row">
          <div class="col-lg-12">
            <div class="row">
              <label>New Owner</label>
              <input type="text" name="" class="form-control" placeholder="Enter Mobile Number">
            </div>
          </div>
        </div>
        <div class="form-group row">
          <button type="button" class="btn btn-info">Send OTP</button>
        </div>
        <div class="form-group row">
          <label>Enter OTP</label>
          <input type="text" name="" class="form-control">
        </div>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
        <button type="button" class="btn btn-success">Confirm</button>
      </div>

    </div>
  </div>
</div>



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
<script>

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
        
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [0], //last column
            "orderable": false, //set not orderable
        },
        ],
    });
});
</script>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>