<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Followup Setting</h1>
          </div>
          <div class="col-sm-6"></div>
        </div>
      </div>
    </div>
  <!-- /.content-header -->

  <!-- Main content -->

  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Rules</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Settings</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="container-fluid tab-pane active"><br>
      <section class="content staff-profile">
        <div class="container-fluid">
          <div class="card org_div">
            <div class="card-body lower">
              <div id="home" class="tab-pane active">
                <div class="row">
                  <div class="col-lg-6">
                    <h4>Rules list</h4>
                    <p>List of rules to auto create followup from the calls</p>
                  </div>
                  <div class="col-lg-6">
                      <div class="add_button text-right">
                          <button class="btn btn-info" data-toggle="modal" data-target="#add_new_modal"><i class="far fa-plus-square"></i>Add New</button>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="content staff-profile">
        <div class="container-fluid">
          <div class="card org_div">
            <div class="card-body lower">
              <div id="home" class="tab-pane active">
                <table class="table table-responsive-lg">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Criteria</th>
                      <th>Assign to</th>
                      <th class="text-right">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Default</td>
                      <td>Myoperator IVR, Missed</td>
                      <td>
                        <span>Mahendar Pal</span>
                        <span class="float-right"><i>Disabled</i></span>
                      </td>
                      <td>
                        <!-- <button class="btn float-right"><i class="fa fa-ellipsis-v"></i></button> -->
                        <div class="dropdown">
                          <button class="btn float-right" type="button" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                          <ul class="dropdown-menu">
                            <li><a href="#">Edit</a></li>
                            <li><a href="#">Delete</a></li>
                            <li><a href="#">Enable</a></li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>


    <div id="menu1" class="container-fluid tab-pane fade"><br>
      <section class="content staff-profile attendance">
        <div class="container-fluid">
          <div class="card org_div">
            <div class="card-body lower">
              <div id="home" class="tab-pane active">
                <div class="row">
                  <div class="col-lg-6">
                    <h4>Settings</h4>
                    <p>Additional settings for followup</p>
                  </div>
                  <div class="col-lg-6"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="content staff-profile attendance">
        <div class="container-fluid">
          <div class="card org_div">
            <div class="card-body lower">
              <div id="home" class="tab-pane active">
                <form class="staff_addition_form">
                  <h5>Followup settings <a href="#">Edit</a></h5>
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <label>Lapse time (days)</label><br>
                      <span>Number of days after which your pending followup would be lapsed and removed</span>
                      <input type="text" name="" class="form-control">
                    </div>
                    <div class="col-lg-6">
                      <label>Duplicate followup</label><br>
                      <span>Multiple followup can be created for same caller based on followup rules</span>
                      <select class="form-control">
                        <option>Disable</option>
                        <option>Enable</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <label>Lapse time (days)</label><br>
                      <span>Number of days after which your pending followup would be lapsed and removed</span>
                      <select class="form-control">
                        <option disabled="" selected="">Choose Users</option>
                        <option>Mahendra</option>
                        <option>Sanoj</option>
                      </select>
                    </div>
                    <div class="col-lg-6">
                      <label>Duplicate followup</label><br>
                      <span>Multiple followup can be created for same caller based on followup rules</span>
                      <input type="time" name="" class="form-control">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-6">
                      <label>Assignee</label><br>
                      <span>Followup assignment priority when multiple users are attempted on the same call</span>
                      <select class="form-control">
                        <option>First User On Call</option>
                        <option>Last User On Call</option>
                      </select>
                    </div>
                    <div class="col-lg-6">
                      
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6 text-right">
                      <button type="button" class="btn btn-info">Save</button>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="http://www.allegientservices.com/" target="_blank">Allegient Services</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 365.2.4
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- The add paymnet modal -->

<div class="modal fade profile_popup" id="add_new_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Rule</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="form-horizontal staff_addition_form">
          <div class="row">
            <div class="col-sm-12 form-group">
              <label>Title <span>*</span></label>
              <input type="text" name="" class="form-control">
            </div>
            <div class="col-sm-12 form-group">
              <label>Criteria <span>*</span></label>
              <select class="form-control">
                <option disabled="" selected="">Select call attributes for creating followup</option>
                <option>IVR</option>
                <option>Outgoing</option>
                <option>Incoming</option>
                <option>Call</option>
                <option>Voicemail</option>
                <option>Missed</option>
                <option>Connected</option>
                <option></option>
              </select>
            </div>
            <div class="col-sm-12 form-group">
             <label>Assign To*</label> <br>
             <input type="radio" name="">Related Department
             <p>This works for departments criteria only and makes the rules fail to match when the call does not go to any department</p>
            </div>
            <div class="col-sm-12 form-group">
             <input type="radio" name="">Related user
             <p>This works for user criteria only and makes the rules fail to match when the call does not go to any user. In the case of multiple users, first or last may be considered depending on the selection in the setting</p>
            </div>
            <div class="col-sm-12 form-group">
             <input type="radio" name="">Choose user or department
             <select class="form-control">
              <option disabled="" selected="">Department</option>
               <option>Extension Directory</option>
               <option>Sales</option>
               <option>Support</option>
             </select>
            </div>
          </div>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-info form-control">Save and Publish</button>
        <!-- <button type="button" class="btn form-control">Add Paymnet</button> -->
      </div>

    </div>
  </div>
</div>

<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<script>
