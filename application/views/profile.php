<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()."assets/"; ?>#">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-4 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->

            <!-- /.card -->  
        
         <!-- tables -->
            <div class="card direct-chat direct-chat-primary updated_info">
              <div class="card-tools ml-auto">
                  <button type="button" class="btn bg-info btn-tool" data-card-widget="" data-toggle="modal" data-target="#edit_profile">
                    <i class="far fa-edit"></i>
                  </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img src="<?php echo base_url().""; ?>assets/img/pic1.jpg" class="img-circle img-fluid" alt="User Image">
                <div class="direct-chat-messages">
                  <h2>Manish Rawat</h2>
                  <p><i class="fas fa-map-marker-alt"></i> Delhi, India</p>
                  <h5>Allegient Unified Technology Pvt. Ltd.</h5>
                  <h6>@mpallegientservices.com</h6>
                </div>
              </div>
            </div>      
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-8 connectedSortable">

            <!-- Map card -->
            <div class="card bg-gradient-primary detail_section">
              <div class="card-tools ml-auto">
                  <button type="button" class="btn bg-info btn-tool" data-card-widget="" data-toggle="modal" data-target="#edit_user">
                    <i class="fas fa-user-plus"></i>
                  </button>
              </div>
              <h3 class="card-title">
               <i class="fas fa-info-circle"></i>
                Details
              </h3>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                    <div class="row">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Name</label>
                          <h4>Manish Rawat</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Company Name</label>
                          <h4>Allegient Unified Technology Pvt. Ltd.</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Company Contact</label>
                          <h4>9873550688</h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Email</label>
                          <h4>mp@allegientservices.com</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Website</label>
                          <h4>https://www.allegientservices.com</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Company GSTIN</label>
                          <h4>07AAMCA0717H1ZU</h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Country</label>
                          <h4>India</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">State</label>
                          <h4>Delhi</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">City</label>
                          <h4>New Delhi</h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Address</label>
                          <h4>DSM – 412,4th Floor, DLF Tower, Shivaji Marg Motinagar</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Zip Code</label>
                          <h4>110015</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">PAN</label>
                          <h4>AAMCA0717H</h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">CIN</label>
                          <h4>U72900DL2013PTC258753</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">License Activation Date</label>
                          <h4>2020-05-21</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">License Expiration Date</label>
                          <h4>2025-05-21</h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Basic License Amount</label>
                          <h4>5</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Business License Amount</label>
                          <h4>10</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Enterprise License Amount</label>
                          <h4>10</h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Active Basic License</label>
                          <h4>0</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Active Business License</label>
                          <h4>0</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Active Enterprise License</label>
                          <h4>7</h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Available Basic License</label>
                          <h4>5</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Available Business License</label>
                          <h4>5</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Available Enterprise License</label>
                          <h4>-2</h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">License Type</label>
                          <h4>Enterprise</h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">

                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">

                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
        <div class="row">
          <section class="col-lg-12 connectedSortable licence_table">
            <div class="card">
              <div class="card-body">
                <table class="table table-striped table-bordered table-responsive-lg">
                  <thead class="thead">
                    <tr>
                      <th>License Type</th>
                      <th>User Name</th>
                      <th>Email ID</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Basic</td>
                      <td>John</td>
                      <td>john@example.com</td>
                    </tr>
                    <tr>
                      <td>Enterprise</td>
                      <td>Mary</td>
                      <td>mary@example.com</td>
                    </tr>
                    <tr>
                      <td>Business</td>
                      <td>July</td>
                      <td>july@example.com</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
      </div><!-- /.container-fluid -->
    </section>
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

<!-- common footer include -->
<?php $this->load->view('common_footer');?>