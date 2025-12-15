<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">SalesOrder</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">SalesOrder</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row mb-3">
          <div class="col-lg-2">
            <div class="first-one">
              <select class="form-control" name="date_filter" id="date_filter">
                <option selected disabled>Select Option</option>
                <option value="This Week">This Week</option>
                <?php $week = strtotime("-7 Day"); ?>
                <option value="<?= date('y.m.d', $week); ?>">Last Week</option>
                <?php $fifteen = strtotime("-15 Day"); ?>
                <option value="<?= date('y.m.d', $fifteen); ?>">Last 15 days</option>
                <?php $thirty = strtotime("-30 Day"); ?>
                <option value="<?= date('y.m.d', $thirty); ?>">Last 30 days</option>
                <?php $fortyfive = strtotime("-45 Day"); ?>
                <option value="<?= date('y.m.d', $fortyfive); ?>">Last 45 days</option>
                <?php $sixty = strtotime("-60 Day"); ?>
                <option value="<?= date('y.m.d', $sixty); ?>">Last 60 days</option>
                <?php $ninty = strtotime("-90 Day"); ?>
                <option value="<?= date('y.m.d', $ninty); ?>">Last 3 Months</option>
                <?php $six_month = strtotime("-180 Day"); ?>
                <option value="<?= date('y.m.d', $six_month); ?>">Last 6 Months</option>
                <?php $one_year = strtotime("-365 Day"); ?>
                <option value="<?= date('y.m.d', $one_year); ?>">Last 1 Year</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-6">
              <div class="refresh_button float-right">
                  <button class="btn btn-info btn-sm" onClick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
                  <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#notify_salespopup"><i class="fas fa-bell"></i></button>
                  <button class="btn btn-info btn-sm" onClick="add_form();">Add New</button>
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                        <?php if($this->session->userdata('delete_so')=='1') : ?>
                          <th><button class="btn" type="button" name="delete_all" id="delete_all2"><i class="fa fa-trash text-light"></i></button></th>
                        <?php endif; ?>
                        <th class="th-sm">Subject</th>
                        <th class="th-sm">Organization Name</th>
                        <th class="th-sm">Salesorder ID</th>
                        <th class="th-sm">Owner</th>
                        <th class="th-sm">Status</th>						
						<th class="th-sm">SO Approved By</th>
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
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

<!-- notify popup -->

<div class="modal fade show" id="notify_salespopup" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="organization_add_edit">Salesorder Notification</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body form">
            <div class="row mb-3">
          <div class="col-lg-2">
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
          <div class="col-lg-4"></div>
          <div class="col-lg-6">
              <div class="refresh_button float-right">
                  <button class="btn btn-info btn-sm"><i class="fas fa-redo-alt"></i></button>
              </div>
          </div>
        </div>
        
        <table class="table table-striped table-bordered table-responsive-lg">
          <thead>
            <tr>
              <th>SO ID</th>
              <th>Subject</th>
              <th>Organization Name</th>
              <th>SO Owner</th>
              <th>Total Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="notify_table">
                               
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- notify popup -->
  <?php if($this->session->userdata('create_so') == 1) : ?>
    <!-- Add new modal -->
    <div class="modal fade show" id="sales_popup" role="dialog" aria-modal="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="sales_title">Add Salesorder</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body form">
                      <form action="#" id="form" class="form-horizontal" method="post">
                        <input type="hidden" value="" name="id" id="id">
                        <input type="hidden" value="" name="saleorderId" id="saleorderId">
                        <div class="form-body form-row">
                          <div class="col-md-6 mb-3">
                            <label>Quotation ID</label>
                            <input type="text" class="form-control ui-autocomplete-input" name="quote_id" id="quote_id" placeholder="Quotation ID" required="" autocomplete="off">
                            <span id="quote_id_error"></span>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Sales Order Owner</label>
                            <input type="text" class="form-control" name="owner" id="owner" placeholder="Sales Order Owner" value="<?=$this->session->userdata('name'); ?>" readonly="">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Organization Name<span style="color: #f76c6c;">*</span></label>
							 <div class="input-group-append">
                            <input type="text" class="form-control" name="org_name" id="org_name" placeholder="Organization Name">
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="add_formOrg('Customer')" ><i class="fa fa-plus"></i></button>
                           </div>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Date</label>
                            <input type="text" class="form-control" name="date" id="date" placeholder="Date" readonly="">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Subject<span style="color: #f76c6c;">*</span></label>
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                            <span id="subject_error"></span>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Contact Name<span style="color: #f76c6c;">*</span></label>
                            <select class="form-control" name="contact_name" id="contact_name">
                              <option value="">Contact Name</option>
                            </select>
                            <input type="hidden" name="contact_name_hidden" id="contact_name_hidden" value="">
                            <span id="contact_name_error"></span>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Opportunity Name<span style="color: #f76c6c;">*</span></label>
                            <input type="text" class="form-control" name="opp_name" id="opp_name" placeholder="Opportunity Name">
                            <span id="opportunity_name_error"></span>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Pending</label>
                            <input type="text" class="form-control" name="pending" id="pending" placeholder="Pending">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Excise Duty</label>
                            <input type="text" class="form-control onlyLetters" name="excise_duty" id="excise_duty" placeholder="Excise Duty">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Due Date<span style="color: #f76c6c;">*</span></label>
                            <input type="text" onfocus="(this.type='date')" class="form-control" name="due_date" id="due_date" placeholder="Due Date">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Carrier<span style="color: #f76c6c;">*</span></label>
                            <select class="form-control" name="carrier" id="carrier">
                              <option selected="" disabled=""></option>
                              <option value="FedEx">FedEx</option>
                              <option value="UPS">UPS</option>
                              <option value="USPS">USPS</option>
                              <option value="DHL">DHL</option>
                              <option value="BlueDart">BlueDart</option>
                            </select>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <input type="text" class="form-control" name="status" id="status" placeholder="Status" readonly="">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Sales Commission</label>
                            <input type="text" class="form-control" name="sales_commission" id="sales_commission" placeholder="Sales Commission">
                          </div>
                          <div class="col-md-6 mb-3">
                          </div>
                          
                        <?php if($this->session->userdata('type') == 'admin'){ ?>
                      <div class="col-md-6 mb-3">
                        <h6>Payment Terms Status</h6>
                        <label class="switch">
                          <input type="checkbox" name="is_status" id="is_status" value="1">
                          <span class="slider round" style="background-color:#efe9e9;"></span>
                        </label>
                      </div>
                      <div class="col-md-6 mb-3" style="padding-top: 30px;"> <label id="textMsg"></label></div>
                    <?php } else if($this->session->userdata('so_approval')=='1' && $workflow_details['status'] == 1) { ?>
                       <div class="col-md-6 mb-3">
                        <h6>Payment Terms Status</h6>
                        <label class="switch">
                          <input type="checkbox" name="is_status" id="is_status" value="1">
                          <span class="slider round" style="background-color:#efe9e9;"></span>
                        </label>
                      </div>
                      <div class="col-md-6 mb-3" style="padding-top: 30px;"> <label id="textMsg"></label></div>
                    <?php } ?>
                          
                          <div class="col-md-6 mb-3">
                            <h6>Billing Address</h6>
                          </div>
                          <div class="col-md-5 mb-2">
                            <h6>Shipping Address</h6>
                          </div>
                          <div class="col-md-1 mb-1">
                            <button type="button" class="btn btn-info btn-sm" onclick="copy(this.form)">Copy</button>
                          </div>
                          <div class="col-md-3 mb-3">
                            <label>Country<span style="color: #f76c6c;">*</span></label>
                            <input type="text" class="form-control" name="billing_country" placeholder="Country" id="billing_country" value="" required="">
                            <span id="billing_country_error"></span>
							<input type="hidden" id="billing_country_id">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label>State<span style="color: #f76c6c;">*</span></label>
                            <input type="text" class="form-control" name="billing_state" placeholder="State" id="billing_state" value="" required="">
                            <span id="billing_state_error"></span>
							<input type="hidden" id="billing_state_id">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label>Country<span style="color: #f76c6c;">*</span></label>
                            <input type="text" class="form-control" name="shipping_country" placeholder="Country" id="shipping_country" value="" required="">
                            <span id="shipping_country_error"></span>
							<input type="hidden" id="shipping_country_id">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label>State<span style="color: #f76c6c;">*</span></label>
                            <input type="text" class="form-control" name="shipping_state" placeholder="State" id="shipping_state" value="" required="">
                            <span id="shipping_state_error"></span>
							<input type="hidden" id="shipping_state_id">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label>City<span style="color: #f76c6c;">*</span></label>
                            <input type="text" class="form-control" name="billing_city" placeholder="City" id="billing_city" value="" required="">
                            <span id="billing_city_error"></span>
                          </div>
                          <div class="col-md-3 mb-3">
                            <label>Zipcode<span style="color: #f76c6c;">*</span></label>
                            <input type="text" class="form-control" name="billing_zipcode" placeholder="Zipcode" id="billing_zipcode" value="" required="">
                            <span id="billing_zipcode_error"></span>
                          </div>
                          <div class="col-md-3 mb-3">
                            <label>City<span style="color: #f76c6c;">*</span></label>
                            <input type="text" class="form-control" name="shipping_city" placeholder="City" id="shipping_city" value="" required="">
                            <span id="shipping_city_error"></span>
                          </div>
                          <div class="col-md-3 mb-3">
                            <label>Zipcode<span style="color: #f76c6c;">*</span></label>
                            <input type="text" class="form-control" name="shipping_zipcode" placeholder="Zipcode" id="shipping_zipcode" value="" required="">
                            <span id="shipping_zipcode_error"></span>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Address<span style="color: #f76c6c;">*</span></label>
                            <textarea type="text" class="form-control" name="billing_address" placeholder="Enter Address" id="billing_address" value="" required=""></textarea>
                             <span id="billing_address_error"></span>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Address<span style="color: #f76c6c;">*</span></label>
                            <textarea type="text" class="form-control" name="shipping_address" placeholder="Enter Address" id="shipping_address" value="" required=""></textarea>
                            <span id="shipping_address_error"></span>
                          </div>
                          <div class="col-md-12 mb-6">
                            <h6>Add&nbsp;Product&nbsp;Details<span style="color: #f76c6c;">*</span></h6>
                          </div>
                          <div class="col-md-2 mb-1">
                            <select class="form-control" name="type" id="type" onchange="show_table();">
                              <option value="" disabled="" selected="">Type</option>
                              <option value="Instate">Instate</option>
                              <option value="Interstate">Interstate</option>
                            </select>
                            <input type="hidden" name="type_hidden" id="type_hidden" value="">
                            <span id="type_error"></span>
                          </div>
                          <div class="col-md-10 mb-4">
                          </div>

                          <div class="col-md-12 mb-6">
                            <table style="margin-bottom:5px; overflow-y:auto;" class="table table-bordered table-responsive-lg">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Product Name</th>
                                  <th>HSN/SAC</th>
                                  <th>SKU</th>
                                  <th>GST in %</th>
                                  <th>Quantity</th>
                                  <th>Unit Price</th>
                                  <th>Est. PO Price</th>
                                  <th>Tot. Est. PO</th>
                                  <th>Total</th>
                                </tr>
                              </thead>
                              <tbody id="add">
                                <tr>
                                  <td width="3%">
                                    <input id="checkbox" type="checkbox">
                                  </td>
                                  <td width="30%">
                                    <input type="text" name="product_name[]" class="form-control" placeholder="Product Name">
                                  </td>
                                  <td width="7%">
                                    <input type="text" name="hsn_sac[]" class="form-control" placeholder="HSN/SAC">
                                  </td>
                                  <td width="7%">
                                    <input type="text" name="sku[]" class="form-control" placeholder="SKU">
                                  </td>
                                  <td width="8%">
                                    <input type="text" class="form-control" list="gst" name="gst[]" placeholder="GST in %">
                                    <datalist id="gst">  
                                      <option selected="" disabled="">Select GST</option>
                                      <option value="12">GST@12%</option>
                                      <option value="18">GST@18%</option>
                                      <option value="28">GST@28%</option>
                                    </datalist>
                                  </td>
                                  <td width="8%">
                                    <input type="text" name="quantity[]" onkeyup="calculate_order()" class="form-control start" placeholder="Quantity">
                                  </td>
                                  <td width="10%">
                                    <input type="text" name="unit_price[]" onkeyup="calculate_order()" class="form-control start" placeholder="Unit Price">
                                  </td>
                                  <td width="8%">
                                    <input id="estimate_purchase_price" name="estimate_purchase_price[]" onkeyup="calculate_order()" class="form-control" type="text" placeholder="Estimate Purchase Price">
                                  </td>
                                  <td width="8%">
                                    <input id="initial_est_purchase_price" name="initial_est_purchase_price[]" class="form-control" type="text" placeholder="Initial Estimated Purchase Price" readonly="">
                                  </td>
                                  <td width="11%">
                                    <input type="text" name="total[]" class="form-control" placeholder="Total">
                                  </td>
                                  <input id="percent" name="percent[]" type="hidden">
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-md-2">
                            <input type="button" class="add_row btn btn-outline-info btn-sm" value="Add Row" id="add_row">
                          </div>
                          <div class="col-md-2">
                            <button type="button" class="delete_row btn btn-outline-danger btn-sm" id="delete_row">Delete Row</button>
                          </div>
                          <div class="col-md-8">
                          </div>
                          <div class="col-md-6">
                          </div>
                          <div class="col-md-6">
                            <table class="float-right" id="calculate_table">
                              <tbody><tr>
                                <th>Initial&nbsp;Total:</th>
                                <td><input id="initial_total" name="initial_total" class="form-control mt-1" type="text"></td>
                              </tr>
                              <tr>
                                <th>Overall&nbsp;Discount:</th>
                                <td><input id="discount" name="discount" onkeyup="calculate_order()" class="form-control mt-1" type="text"></td>
                              </tr>
                              <tr>
                                <th>After&nbsp;Discount:</th>
                                <td><input name="after_discount" id="after_discount" class="form-control mt-1" type="text"></td>
                              </tr>
                              <tr>
                                <th>Total&nbsp;ORC:</th>
                                <td><input name="total_orc" id="total_orc" onkeyup="calculate_order()" class="form-control mt-1" type="text"></td>
                              </tr>
                              <tr id="igst12">
                                <th>GST@&nbsp;12%&nbsp;<span id="igst12_val"></span></th>
                                <td><input id="igst12_amnt" name="igst12" class="form-control mt-1" type="text"></td>
                                <input id="igst12_val_hidden" name="igst12_val_hidden" type="hidden" value="">
                              </tr>
                              <tr id="igst18">
                                <th>GST@&nbsp;18%&nbsp;<span id="igst18_val"></span></th>
                                <td><input id="igst18_amnt" name="igst18" class="form-control mt-1" type="text"></td>
                                <input id="igst18_val_hidden" name="igst18_val_hidden" type="hidden">
                              </tr>
                              <tr id="igst28">
                                <th>GST@&nbsp;28%&nbsp;<span id="igst28_val"></span></th>
                                <td><input id="igst28_amnt" name="igst28" class="form-control mt-1" type="text"></td>
                                <input id="igst28_val_hidden" name="igst28_val_hidden" type="hidden">
                              </tr>
                              <tr id="cgst6">
                                <th>CGST@&nbsp;6%&nbsp;<span id="cgst6_val"></span></th>
                                <td><input id="cgst6_amnt" name="cgst6" class="form-control mt-1" type="text"></td>
                                <input id="cgst6_val_hidden" name="cgst6_val_hidden" type="hidden">
                              </tr>
                              <tr id="sgst6">
                                <th>SGST@&nbsp;6%&nbsp;<span id="sgst6_val"></span></th>
                                <td><input id="sgst6_amnt" name="sgst6" class="form-control mt-1" type="text"></td>
                                <input id="sgst6_val_hidden" name="sgst6_val_hidden" type="hidden">
                              </tr>
                              <tr id="cgst9">
                                <th>CGST@&nbsp;9%&nbsp;<span id="cgst9_val"></span></th>
                                <td><input id="cgst9_amnt" name="cgst9" class="form-control mt-1" type="text"></td>
                                <input id="cgst9_val_hidden" name="cgst9_val_hidden" type="hidden">
                              </tr>
                              <tr id="sgst9">
                                <th>SGST@&nbsp;9%&nbsp;<span id="sgst9_val"></span></th>
                                <td><input id="sgst9_amnt" name="sgst9" class="form-control mt-1" type="text"></td>
                                <input id="sgst9_val_hidden" name="sgst9_val_hidden" type="hidden">
                              </tr>
                              <tr id="cgst14">
                                <th>CGST@&nbsp;14%&nbsp;<span id="cgst14_val"></span></th>
                                <td><input id="cgst14_amnt" name="cgst14" class="form-control mt-1" type="text"></td>
                                <input id="cgst14_val_hidden" name="cgst14_val_hidden" type="hidden">
                              </tr>
                              <tr id="sgst14">
                                <th>SGST@&nbsp;14%&nbsp;<span id="sgst14_val"></span></th>
                                <td><input id="sgst14_amnt" name="sgst14" class="form-control mt-1" type="text"></td>
                                <input id="sgst14_val_hidden" name="sgst14_val_hidden" type="hidden">
                              </tr>
                              <tr>
                                <th>Sub&nbsp;Total:</th>
                                <td><input id="sub_total" name="sub_total" class="form-control mt-1" type="text"></td>
                              </tr>
                              <tr>
                                <th>Total&nbsp;Estimate&nbsp;<br>Purchase&nbsp;Price:</th>
                                <td><input id="total_est_purchase_price" name="total_est_purchase_price" class="form-control mt-1" type="text"></td>
                              </tr>
                              <tr>
                                <input id="test_val" name="total_percent" type="hidden" value="100">
                              </tr> 
                            </tbody>
                            <span></span>
                          </table>
                          <span id="discount_note" style="color : red;display: block;text-align: center;">*&nbsp;Discount&nbsp;field&nbsp;is&nbsp;mandatory</span>
                          </div>
                          <div class="col-md-6 mb-6 mt-3">
                            <input type="text" class="form-control" name="profit_by_user" placeholder="Profit Margin" id="profit_by_user" readonly="">
                          </div>
						  
                         <!-- <div class="col-md-12 mb-6 mt-3">
                            <textarea class="form-control" name="terms_condition" placeholder="Terms &amp; Condition"><?=$this->session->userdata('terms_condition_customer');?></textarea>
                          </div>-->
						  
						  <div class="col-md-12 mb-3 text-left" id="termLblSalesorder">
							  <a id="termLblSalesorder" style="cursor: pointer;" > <i class="fas fa-plus-circle"></i> Add Terms & Conditions</a>
						  </div>
				    <div class="col-md-12 mb-3" id="termConAppSalesorder" style="display:none;">
              
						<div class="row mt-3">
							<div class="col-lg-12 col-12 text-left">
							Customer Terms & Conditions  
							</div>
						</div>
						<div class="row mt-3" id="putlineSalesorder">
							<?php $custTerm=explode("<br>",$this->session->userdata('terms_condition_customer')); $no=1; $id=15; ?>
							<?php for($i=0; $i<count($custTerm); $i++){ ?>
								<div class="col-lg-1 col-1 numberDisp " id="noid<?=$id;?>">
									<p><?=$no;?></p>
								</div>
								<div class="col-lg-10 col-10" id="inptdv<?=$id;?>">
									<input type="text" id="inpt<?=$id;?>" class="form-control inputbootomBor" name="terms_condition[]"  value="<?php echo $custTerm[$i];?>" placeholder="Customer Terms & Condition" >
								</div>
								<div class="numberDisp" style="" id="rm<?=$id;?>">
								<i class="far fa-times-circle" onClick="removeRow(<?=$id;?>,'putlineSalesorder')" ></i>
								</div>
							<?php $no++; $id++;} ?>
						</div>
						<div class="row mt-3">
							  <div class="col-lg-4 col-6">
								<div class="inner_details text-left" >
								  <a id="addLineSalesorder" style="cursor: pointer;" > <i class="fas fa-plus-circle"></i> Add line</a>
								</div>
							  </div>
						</div>
					</div>
						  
						  
                          <div class="col-md-12 mb-6 mt-3">
                            <input onchange="ValidateSize(this)" type="file" name="attached_file" id="attached_file">
                          </div>
                          <div class="col-md-12 mb-12 mt-3">
                            <h6>End&nbsp;Customer&nbsp;Details</h6>
                          </div>
                          <div class="col-md-6 mb-6 mt-3">
                            <label>Company Name</label>
                            <input type="text" class="form-control onlyLetters" name="customer_company_name" placeholder="Company Name" id="company_name" required="">
                            <span id="company_name_error"></span>
                          </div>
                          <div class="col-md-6 mb-6 mt-3">
                            <label>Customer Name</label>
                            <input type="text" class="form-control" name="customer_name" placeholder="Customer Name" id="customer_name" required="">
                            <span id="customer_name_error"></span>
                          </div>
                          <div class="col-md-6 mb-6 mt-3">
                            <label>Customer Email</label>
                            <input type="email" class="form-control" name="customer_email" placeholder="Customer Email" id="customer_email" required="">
                            <span id="customer_email_error"></span>
                          </div>
                          <div class="col-md-6 mb-6 mt-3">
                            <label>Customer Mobile Number</label>
                            <input type="text" class="form-control" name="customer_mobile" placeholder="Enter Customer Mobile Number" id="customer_mobile" required="">
                            <span id="customer_mobile_error"></span>
                          </div>
                          <div class="col-md-6 mb-6 mt-3">
                            <label>Microsoft LAN No.</label>
                            <input type="text" class="form-control" name="microsoft_lan_no" placeholder="Microsoft LAN Number" id="microsoft_lan_no">
                          </div>
                          <div class="col-md-6 mb-6 mt-3">
                            <label>Promo Id</label>
                            <input type="text" class="form-control" name="promo_id" placeholder="Promo Id" id="promo_id">
                          </div>
                          <div class="col-md-12 mb-12 mt-3">
                            <label>Customer Address</label>
                            <textarea class="form-control" name="customer_address" placeholder="Enter Customer Address" id="customer_address"></textarea>
                            <span id="customer_address_error"></span>
                          </div>
                        </div>
                        <input type="hidden" name="form_type" id="form_type" value="add">
                        <input type="hidden" name="opportunity_id" id="opportunity_id" value="">
                        <input type="hidden" name="page_source" id="page_source" value="salesorder">
                      </form>
                    </div>
            <div class="modal-footer">
              <button type="button" id="btnSave" onclick="" class="btn btn-info btn-sm">Save</button>
            </div>
        </div>
      </div>
    </div>
    <!-- Add new modal -->
  <?php endif; ?>
  <?php if($this->session->userdata('create_po') == 1) : ?>
    <!-- Add Purchaseorder modal -->
    <div class="modal fade show" id="add_popup" role="dialog" aria-modal="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="purchaseorder_title">Add 
                Purchaseorder</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body form">
              <form action="javascript:void(0);" id="po_f" class="form-horizontal" enctype="multipart/form-data" method="post">
                <input type="hidden" value="" name="id" id="id">
                <input type="hidden" name="val" id="val">
                <input type="hidden" name="val2" id="val2">
                 <input type="hidden" name="so_owner" id="so_owner">
                 <input type="hidden" name="so_owner_email" id="so_owner_email">
                 <input type="hidden" name="productLine" id="productLine">
                <div class="form-body form-row">
                  <div class="col-md-6 mb-3">
                    <label>Salesorder ID<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control ui-autocomplete-input" name="saleorder_id" id="saleorder_id" placeholder="Salesorder ID" required="" autocomplete="off">
                    <span id="saleorder_id_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>PO Owner</label>
                      <input type="text" class="form-control" name="owner" id="owner_p" placeholder="Purchase Order Owner" value="<?=$this->session->userdata('name');?>" readonly="">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Organization Name<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="org_name" id="org_name_p" placeholder="Organization Name" readonly="">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Date</label>
                    <input type="text" class="form-control" name="date" id="date_p" placeholder="Date" readonly="">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Subject<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="subject" id="subject_p" placeholder="Subject">
                    <span id="subject_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                     <label>Contact Name</label>
                     <input type="text" class="form-control" name="contact_name" id="contact_name_p" placeholder="Contact Name">
                    <span id="contact_name_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6>Renewal</h6>
                    <label class="switch">
                      <input type="checkbox" name="is_newed" id="is_newed" value="">
                      <span class="slider round"></span>
                    </label>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Renewal Date</label>
                    <select class="form-control" name="renewal_date" id="renewal_date">
                      <option selected="" disabled="">Select Renewal Month</option>
                      <?php $thirty = strtotime("30 Day"); ?>
                      <option value="<?= date('Y-m-d', $thirty); ?>">1 Month</option>
                      <?php $sixty = strtotime("60 Day"); ?>
                      <option value="<?= date('Y-m-d', $sixty); ?>">2 Month</option>
                      <?php $ninty = strtotime("90 Day"); ?>
                      <option value="<?= date('Y-m-d', $ninty); ?>">3 Months</option>
                      <?php $one_twenty = strtotime("120 Day"); ?>
                      <option value="<?= date('Y-m-d', $one_twenty); ?>">4 Months</option>
                      <?php $one_fifty = strtotime("150 Day"); ?>
                      <option value="<?= date('Y-m-d', $one_fifty); ?>">5 Months</option>
                      <?php $six_month = strtotime("180 Day"); ?>
                      <option value="<?= date('Y-m-d', $six_month); ?>">6 Months</option>
                      <?php $two_ten = strtotime("210 Day"); ?>
                      <option value="<?= date('Y-m-d', $two_ten); ?>">7 Months</option>
                       <?php $two_forty = strtotime("240 Day"); ?>
                      <option value="<?= date('Y-m-d', $two_forty); ?>">8 Months</option>
                      <?php $two_seventy = strtotime("270 Day"); ?>
                      <option value="<?= date('Y-m-d', $two_seventy); ?>">9 Months</option>
                      <?php $three_hundred = strtotime("300 Day"); ?>
                      <option value="<?= date('Y-m-d', $three_hundred); ?>">10 Months</option>
                      <?php $three_thirty = strtotime("330 Day"); ?>
                      <option value="<?= date('Y-m-d', $three_thirty); ?>">11 Months</option>
                      <?php $one_year = strtotime("365 Day"); ?>
                      <option value="<?= date('Y-m-d', $one_year); ?>">1 Year</option>
                      <?php $two_year = strtotime("730 Day"); ?>
                      <option value="<?= date('Y-m-d', $two_year); ?>">2 Year</option>
                      <?php $three_year = strtotime("1195 Day"); ?>
                      <option value="<?= date('Y-m-d', $three_year); ?>">3 Year</option>
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <input type="text" class="form-control form-control-sm" name="payTStatus" id="payTStatus" readonly >   
                </div>
                  <div class="col-md-6 mb-3"></div>
                  <div class="col-md-3 mb-2">
                    <h6><b>Billing Address</b></h6>
                  </div>
                  <div class="col-md-3 mb-1">
                    <label>Branch Name<span style="color: #f76c6c;">*</span></label>
                    <select id="branch" name="branch_name" class="form-control">
                      <option value="">Branch Name</option>
                      <?php if(!empty($branch)) {
                        foreach($branch as $bname) { ?>
                          <option value="<?= $bname['branch_name']; ?>"><?= $bname['branch_name'];?></option>
                      <?php } } ?>
                </select>
                  </div>
                  <div class="col-md-3 mb-2">
                    <h6><b>Shipping Address</b></h6>
                  </div>
                  <div class="col-md-3 mb-1">
                    <label>Branch Name<span style="color: #f76c6c;">*</span></label>
                    <select id="branch_s" name="branch_name" class="form-control">
                      <option value="">Branch Name</option>
                      <?php if(!empty($branch)) {
                        foreach($branch as $bname) { ?>
                          <option value="<?= $bname['branch_name']; ?>"><?= $bname['branch_name'];?></option>
                      <?php } } ?>
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Billing GSTIN</label>
                    <input type="text" class="form-control" name="billing_gstin" placeholder="GSTIN" id="gstin_p" required="">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Shipping GSTIN</label>
                    <input type="text" class="form-control" name="shipping_gstin" placeholder="GSTIN" id="s_gstin_p" required="">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label>Billing Country<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="billing_country" placeholder="Country" id="billing_country_p" required="">
                    <span id="billing_country_error_p"></span>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label>Billing State<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="billing_state" placeholder="State" id="billing_state_p" required="">
                    <span id="billing_state_error_p"></span>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label>Shipping Country<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="shipping_country" placeholder="Country" id="shipping_country_p" required="">
                    <span id="shipping_country_error_p"></span>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label>Shipping State<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="shipping_state" placeholder="State" id="shipping_state_p" required="">
                    <span id="shipping_state_error_p"></span>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label>Billing City<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="billing_city" placeholder="City" id="billing_city_p" required="">
                    <span id="billing_city_error_p"></span>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label>Billing Zipcode<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="billing_zipcode" placeholder="Zipcode" id="billing_zipcode_p" required="">
                    <span id="billing_zipcode_error_p"></span>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label>Shipping City<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="shipping_city" placeholder="City" id="shipping_city_p" required="">
                    <span id="shipping_city_error_p"></span>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label>Shipping Zipcode<span style="color: #f76c6c;">*</span><span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="shipping_zipcode" placeholder="Zipcode" id="shipping_zipcode_p" required="">
                    <span id="shipping_zipcode_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Billing Address<span style="color: #f76c6c;">*</span></label>
                    <textarea type="text" class="form-control" name="billing_address" placeholder="Address" id="billing_address_p" required=""></textarea>
                    <span id="billing_address_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Shipping Address<span style="color: #f76c6c;">*</span></label>
                    <textarea type="text" class="form-control" name="shipping_address" placeholder="Address" id="shipping_address_p" required=""></textarea>
                    <span id="shipping_address_error_p"></span>
                  </div>
                  <div class="col-md-12 mb-3">
                    <h6><b>Supplier Details</b></h6>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Supplier Company Name<span style="color: #f76c6c;">*</span></label>
                    <div class="input-group-append">
                    <input type="text" class="form-control ui-autocomplete-input" name="supplier_comp_name" id="supplier_comp_name" placeholder="Supplier Company Name" autocomplete="off">
                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="add_formOrg('Vendor')" ><i class="fa fa-plus"></i></button>
                           </div>
                    <span id="supplier_comp_name_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Supplier Contact No.<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="supplier_contact" id="supplier_contact" placeholder="Supplier Contact No.">
                    <span id="supplier_contact_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Supplier Name<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier Name">
                    <span id="supplier_name_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Supplier Email<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control" name="supplier_email" id="supplier_email" placeholder="Supplier Email">
                    <span id="supplier_email_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Supplier GSTIN</label>
                    <input type="text" class="form-control" name="supplier_gstin" id="supplier_gstin" placeholder="Supplier GSTIN">
                  </div>
                  <div class="col-md-6 mb-3">
                  </div>
                  <div class="col-md-6 mb-3">
                    <h6><b>Supplier Address</b></h6>
                  </div>
                  <div class="col-md-6 mb-3">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Supplier Country</label>
                    <input type="text" class="form-control" name="supplier_country" id="supplier_country" placeholder="Country">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Supplier State</label>
                    <input type="text" class="form-control" name="supplier_state" id="supplier_state" placeholder="State">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Supplier City</label>
                    <input type="text" class="form-control" name="supplier_city" id="supplier_city" placeholder="City">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label>Supplier Zipcode</label>
                    <input type="text" class="form-control" name="supplier_zipcode" id="supplier_zipcode" placeholder="Zipcode">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label>Supplier Address</label>
                    <textarea type="text" class="form-control" name="supplier_address" placeholder="Address" id="supplier_address" required=""></textarea>
                  </div>
                  <div class="col-md-12 mb-6">
                    <h6><b>Add&nbsp;Product&nbsp;Details<span style="color: #f76c6c;">*</span></b></h6>
                  </div>
                  <div class="col-md-2 mb-1">
                    <select class="form-control" name="type" id="type_tax" onchange="show_table();">
                      <option selected="" disabled="">Type</option>
                      <option value="Instate">Instate</option>
                      <option value="Interstate">Interstate</option>
                    </select>
                    <input type="hidden" name="type_hidden" id="type_hidden_p" value="">
                    <span id="type_error_p"></span>
                  </div>
                  <div class="col-md-10 mb-4">
                  </div>

                  <div class="col-md-12 mb-6">
                    <table style="margin-bottom:5px; overflow-y:auto;"  class="table table-responsive-lg table-bordered">
                        <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Product Name</th>
                                  <th>HSN/SAC</th>
                                  <th>SKU</th>
                                  <th>GST in %</th>
                                  <th>Quantity</th>
                                  <th>Unit Price</th>
                                  <th>Est. PO Price</th>
                                  <th>Tot. Est. PO</th>
                                  <th>Total</th>
                                </tr>
                              </thead>
                      <tbody id="add_po" >
                        <tr>
                          <td width="3%">
                            <input id="checkbox_p" type="checkbox">
                          </td>
                          <td width="30%">
                            <input type="text" name="product_name_p[]" class="form-control" placeholder="Product Name">
                          </td>
                          <td width="7%">
                            <input type="text" name="hsn_sac_p[]" class="form-control" placeholder="HSN/SAC">
                          </td>
                          <td width="7%">
                            <input type="text" name="sku_p[]" class="form-control" placeholder="SKU">
                          </td>
                          <td width="8%">
                            <input type="text" class="form-control" list="gst" name="gst_p[]" placeholder="GST in %">
                            <datalist id="gst">  
                              <option value="">Select GST</option>
                              <option value="12">GST@12%</option>
                              <option value="18">GST@18%</option>
                              <option value="28">GST@28%</option>
                            </datalist>
                          </td>
                          <td width="8%">
                            <input type="text" name="quantity_p[]" onkeyup="calculate_po_salesorder()" class="form-control" placeholder="Quantity">
                          </td>
                          <td width="10%">
                            <input type="text" name="unit_price_p[]" onkeyup="calculate_po_salesorder()" class="form-control start" placeholder="Unit Price">
                          </td>
                          <td width="8%">
                            <input id="estimate_purchase_price_p" name="estimate_purchase_price_p[]" onkeyup="calculate_po_salesorder()" class="form-control" type="text" placeholder="Estimate Purchase Price">
                          </td>
                          <td width="8%">
                            <input id="initial_est_purchase_price_p" name="initial_est_purchase_price_p[]" class="form-control" type="text" placeholder="Initial Estimated Purchase Price" readonly="">
                          </td>
                          <td width="11%">
                            <input type="text" name="total_p[]" class="form-control" placeholder="Total">
                          </td>
                          <input id="percent_p" name="percent_p[]" type="hidden">
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!--<div class="col-md-2">
                    <input type="button" class="add_row_p btn btn-outline-info btn-sm" value="Add Row" id="add_row_p">
                  </div>-->
                  <div class="col-md-2">
                    <button type="button" class="delete_row_p btn btn-outline-danger btn-sm" id="delete_row_p">Delete Row</button>
                  </div>
                  <div class="col-md-8">
                  </div>
                  <div class="col-md-6">
                  </div>
                  <div class="col-md-6">
                    <table class="float-right" id="calculate_table">
                      <tbody><tr>
                        <th>Initial&nbsp;Total:</th>
                        <td><input id="initial_total_p" name="initial_total" class="form-control mt-1" type="text"></td>
                      </tr>
                      <tr>
                        <th>Overall&nbsp;Discount:</th>
                        <td><input id="discount_p" name="discount" onkeyup="calculate_po_salesorder()" class="form-control mt-1" type="text"></td>
                      </tr>
                      <tr>
                        <th>After&nbsp;Discount:</th>
                        <td><input name="after_discount" id="after_discount_p" class="form-control mt-1" type="text"></td>
                      </tr>
                     
                      <tr id="igst12_p">
                        <th>GST@&nbsp;12%&nbsp;<span id="igst12_val_p"></span></th>
                        <td><input id="igst12_amnt_p" name="igst12" class="form-control mt-1" type="text"></td>
                        <input id="igst12_val_hidden_p" name="igst12_val_hidden" type="hidden" value="">
                      </tr>
                      <tr id="igst18_p">
                        <th>GST@&nbsp;18%&nbsp;<span id="igst18_val_p"></span></th>
                        <td><input id="igst18_amnt_p" name="igst18" class="form-control mt-1" type="text"></td>
                        <input id="igst18_val_hidden_p" name="igst18_val_hidden" type="hidden">
                      </tr>
                      <tr id="igst28_p">
                        <th>GST@&nbsp;28%&nbsp;<span id="igst28_val_p"></span></th>
                        <td><input id="igst28_amnt_p" name="igst28" class="form-control mt-1" type="text"></td>
                        <input id="igst28_val_hidden_p" name="igst28_val_hidden" type="hidden">
                      </tr>
                      <tr id="cgst6_p">
                        <th>CGST@&nbsp;6%&nbsp;<span id="cgst6_val_p"></span></th>
                        <td><input id="cgst6_amnt_p" name="cgst6" class="form-control mt-1" type="text"></td>
                        <input id="cgst6_val_hidden_p" name="cgst6_val_hidden" type="hidden">
                      </tr>
                      <tr id="sgst6_p">
                        <th>SGST@&nbsp;6%&nbsp;<span id="sgst6_val_p"></span></th>
                        <td><input id="sgst6_amnt_p" name="sgst6" class="form-control mt-1" type="text"></td>
                        <input id="sgst6_val_hidden_p" name="sgst6_val_hidden" type="hidden">
                      </tr>
                      <tr id="cgst9_p">
                        <th>CGST@&nbsp;9%&nbsp;<span id="cgst9_val_p"></span></th>
                        <td><input id="cgst9_amnt_p" name="cgst9" class="form-control mt-1" type="text"></td>
                        <input id="cgst9_val_hidden_p" name="cgst9_val_hidden" type="hidden">
                      </tr>
                      <tr id="sgst9_p">
                        <th>SGST@&nbsp;9%&nbsp;<span id="sgst9_val_p"></span></th>
                        <td><input id="sgst9_amnt_p" name="sgst9" class="form-control mt-1" type="text"></td>
                        <input id="sgst9_val_hidden_p" name="sgst9_val_hidden" type="hidden">
                      </tr>
                      <tr id="cgst14_p">
                        <th>CGST@&nbsp;14%&nbsp;<span id="cgst14_val_p"></span></th>
                        <td><input id="cgst14_amnt_p" name="cgst14" class="form-control mt-1" type="text"></td>
                        <input id="cgst14_val_hidden_p" name="cgst14_val_hidden" type="hidden">
                      </tr>
                      <tr id="sgst14_p">
                        <th>SGST@&nbsp;14%&nbsp;<span id="sgst14_val_p"></span></th>
                        <td><input id="sgst14_amnt_p" name="sgst14" class="form-control mt-1" type="text"></td>
                        <input id="sgst14_val_hidden_p" name="sgst14_val_hidden" type="hidden">
                      </tr>
                      <tr>
                        <th>Sub&nbsp;Total:</th>
                        <td><input id="sub_total_p" name="sub_total" class="form-control mt-1" type="text"></td>
                      </tr>
                      <tr>
                        <th>Total&nbsp;Estimate&nbsp;Purchase&nbsp;Price:</th>
                        <td><input id="total_est_purchase_price_p" name="total_est_purchase_price" class="form-control mt-1" type="text"></td>
                      </tr>
                      <tr>
                        <input id="test_val_p" name="total_percent" type="hidden" value="100">
                      </tr>
                      <tr>
                        <input id="progress_p" name="progress" type="hidden" value="0" readonly="">
                      </tr>
                      <tr>
                        <input id="progress_remain_p" name="progress_remain" type="hidden" readonly="">
                      </tr>
                       <input id="total_orc_p" name="total_orc" class="input1 start" type="hidden" onkeyup="" value="">
                    </tbody></table>
                    <span id="discount_note" style="color : red;">*&nbsp;Discount&nbsp;field&nbsp;is&nbsp;mandatory</span>
                  </div>
                  <div class="col-md-6 mt-3">
                    <input type="text" class="form-control" name="profit_by_user" id="profit_by_user_p" placeholder="Total Profit" readonly="">
                  </div>
                  <div class="col-md-6 mb-3">
                  </div>
                  <!--<div class="col-md-12 mb-12 mt-3">
                    <textarea class="form-control" name="terms_condition" placeholder="Terms &amp; Condition"><?=$this->session->userdata('terms_condition_customer')?></textarea>
                  </div>-->
				  
				    <div class="col-md-12 mb-3 text-left" id="termLblPO">
							  <a id="termLblPO" style="cursor: pointer;" > <i class="fas fa-plus-circle"></i> Add Terms & Conditions</a>
					</div>
				    <div class="col-md-12 mb-3" id="termConAppPO" style="display:none;">
              
						<div class="row mt-3">
							<div class="col-lg-12 col-12 text-left">
							Customer Terms & Conditions  
							</div>
						</div>
						<div class="row mt-3" id="putlinePO">
							<?php $custTerm=explode("<br>",$this->session->userdata('terms_condition_customer')); $no=1; $id=30; ?>
							<?php for($i=0; $i<count($custTerm); $i++){ ?>
								<div class="col-lg-1 col-1 numberDisp " id="noid<?=$id;?>">
									<p><?=$no;?></p>
								</div>
								<div class="col-lg-10 col-10" id="inptdv<?=$id;?>">
									<input type="text" id="inpt<?=$id;?>" class="form-control inputbootomBor" name="terms_condition[]"  value="<?php echo $custTerm[$i];?>" placeholder="Customer Terms & Condition" >
								</div>
								<div class="numberDisp" style="" id="rm<?=$id;?>">
								<i class="far fa-times-circle" onClick="removeRow(<?=$id;?>,'putlinePO')" ></i>
								</div>
							<?php $no++; $id++;} ?>
						</div>
						<div class="row mt-3">
							  <div class="col-lg-4 col-6">
								<div class="inner_details text-left" >
								  <a id="addLinePO" style="cursor: pointer;" > <i class="fas fa-plus-circle"></i> Add line</a>
								</div>
							  </div>
						</div>
					</div>
				  
				  
                  <div class="col-md-12 mb-12 mt-3">
                    <b>End&nbsp;Customer&nbsp;Details</b>
                  </div>
                  <div class="col-md-6 mb-6 mt-3">
                    <label>Company Name</label>
                    <input type="text" class="form-control" name="company_name" placeholder="Company Name" id="company_name" required="">
                    <span id="company_name_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-6 mt-3">
                    <label>Customer Name</label>
                    <input type="text" class="form-control onlyLetters" name="customer_name" placeholder="Customer Name" id="customer_name" required="">
                    <span id="customer_name_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-6 mt-3">
                    <label>Customer Email</label>
                    <input type="email" class="form-control" name="customer_email" placeholder="Customer Email" id="customer_email" required="">
                    <span id="customer_email_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-6 mt-3">
                    <label>Customer Mobile</label>
                    <input type="text" class="form-control" name="customer_mobile" placeholder="Customer Mobile" id="customer_mobile" required="">
                    <span id="customer_mobile_error_p"></span>
                  </div>
                  <div class="col-md-6 mb-6 mt-3">
                    <label>Microsoft LAN No.</label>
                    <input type="text" class="form-control" name="microsoft_lan_no" placeholder="Microsoft LAN No." id="microsoft_lan_no_p">
                  </div>
                  <div class="col-md-6 mb-6 mt-3">
                    <label>Promo Id</label>
                    <input type="text" class="form-control" name="promo_id" placeholder="Promo Id" id="promo_id_p">
                  </div>
                  <div class="col-md-12 mb-12 mt-3">
                    <label>Customer Address</label>
                    <textarea class="form-control" name="customer_address" placeholder="Customer Address" id="customer_address_p"></textarea>
                    <span id="customer_address_error_p"></span>
                  </div>
                </div>
                 <input type="hidden" name="opportunity_id" id="opportunity_id" value="">
                  <input type="hidden" name="page_source" id="page_source" value="salesorder">
              </form>
            </div>
            <div class="modal-footer">
                <div id="paymsg" style="margin-right:10px; display:none;"><i class="fas fa-exclamation-triangle" style="color:red; margin-right:7px;"></i>You can create PO after approving SO payment terms</div>
              <button type="button" id="btnSave1" onclick="save_po();return false;" class="btn btn-info btn-sm">Save</button>
            </div>
        </div>
      </div>
    </div>
    <!-- Add Purchaseorder modal -->
  <?php endif; ?>

 <?php $this->load->view('footer');?>
 
</div>
<!-- ./wrapper -->

<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<?php $this->load->view('commonAddorg_modal');?>

<?php if(isset($_GET['soid'])){
	$soid=$_GET['soid'];
	$ntid=$_GET['ntid'];
}else{
	$soid='';
	$ntid='';
}	?>


<script>
  function copy(form)
  {
    form.shipping_country.value=form.billing_country.value;
    form.shipping_state.value=form.billing_state.value;
    form.shipping_city.value=form.billing_city.value;
    form.shipping_zipcode.value=form.billing_zipcode.value;
    form.shipping_address.value=form.billing_address.value;
  }
  function copy2(form)
  {
    form.shipping_country.value=form.billing_country.value;
    form.shipping_state.value=form.billing_state.value;
    form.shipping_city.value=form.billing_city.value;
    form.shipping_zipcode.value=form.billing_zipcode.value;
    form.shipping_address.value=form.billing_address.value;
  }
  
 <?php if($this->session->userdata('terms_condition_customer')){ ?> 
		hideShowOnly('termLblSalesorder','termConAppSalesorder');
		hideShowOnly('termLblPO','termConAppPO');
 <?php } ?>
 $("#termLblSalesorder").click(function(){
  hideShowOnly('termLblSalesorder','termConAppSalesorder');
 });
 $("#termLblPO").click(function(){
  hideShowOnly('termLblPO','termConAppPO');
 }); 

var no=300;
$("#addLineSalesorder").click(function(){
	no++;
	appendLine('putlineSalesorder',no,'terms_condition','');
});

var no=370;
$("#addLinePO").click(function(){
	no++;
	appendLine('putlinePO',no,'terms_condition','');
});



  
</script>
<script>
  var save_method; //for save method string
  
  var table;
  $(document).ready(function () {
    <?php if($this->session->userdata('retrieve_so')=='1'):?>

      table = $('#ajax_datatable').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?= base_url('salesorders/ajax_list'); ?>",
          "type": "POST",
          "data" : function(data)
           {
              data.searchDate = $('#date_filter').val();
           }
        },
		"createdRow": function( row, data, dataIndex){
            if( data[3] == "<?=$soid;?>"  ){
                $(row).css('background-color', 'rgb(84 81 81 / 44%)');
				changeNotiStatus();
            }
        },
        "columnDefs": [
        {
            "targets": [ 0 ], //last column
            "orderable": false, //set not orderable
        },
        ],
      });

      $('#date_filter').change(function(){
        table.ajax.reload();
      });
      function reload_table()
      {
          table.ajax.reload(null,false); //reload datatable ajax
      }
    <?php endif; ?>
    
    
    function changeNotiStatus(){
	var noti_id="<?=$ntid;?>";
	url = "<?= site_url('notification/update_notification');?>";
    	$.ajax({
    		url : url,
    		type: "POST",
    		data: "noti_id="+noti_id+"&notifor=salesorders",
    		success: function(data)
    		{ }
    	});
    }
    
    
  });
  <?php if($this->session->userdata('create_so')=='1'):?>
    function show_table()
    {
      $("#add").show();
      $("#calculate_table").show()
      $("#add_row").show();
      $("#delete_row").show();
	  
	  var type_val = $("#type").val();
                if(type_val == 'Instate') 
                {
                  $('#igst12').hide();
                  $('#igst18').hide();
                  $('#igst28').hide();
                  $('#cgst6').show();
                  $('#sgst6').show();
                  $('#cgst9').show();
                  $('#sgst9').show();
                  $('#cgst14').show();
                  $('#sgst14').show();
                } 
                else if(type_val == 'Interstate') 
                {
                  $('#igst12').show();
                  $('#igst18').show();
                  $('#igst28').show();
                  $('#cgst6').hide();
                  $('#sgst6').hide();
                  $('#cgst9').hide();
                  $('#sgst9').hide();
                  $('#cgst14').hide();
                  $('#sgst14').hide();
                } 
                else 
                {
                  $('#igst12').hide();
                  $('#igst18').hide();
                  $('#igst28').hide();
                  $('#cgst6').hide();
                  $('#sgst6').hide();
                  $('#cgst9').hide();
                  $('#sgst9').hide();
                  $('#cgst14').hide();
                  $('#sgst14').hide();
                }
	  calculate_order();
    }
    function ValidateSize(file)
    {
      var FileSize = file.files[0].size / 1024 / 1024; // in MB
      if (FileSize > 2)
      {
        alert('File is larger than 2MB');
        $(file).val(''); //for clearing with Jquery
      }
      else
      {

      }
    }
    function add_form()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#sales_popup').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add Salesorder'); // Set Title to Bootstrap modal title
      $("#quote_id").attr('readonly',false);// Unset readonly for quotation Id in Add modal
      $("#add").find("tr").remove();
      
     // $("#type").html('');
      $("#type").attr('disabled',false); // disable type for add
      $("#form_type").val('add'); //To set form type for validation
      $("#contact_name").attr('disabled',false); //To unset contact name option disabled
      $("#attached_file").show();
      $("#status").val('pending');

      $('#igst12').hide();
      $('#igst18').hide();
      $('#igst28').hide();
      $('#cgst6').hide();
      $('#sgst6').hide();
      $('#cgst9').hide();
      $('#sgst9').hide();
      $('#cgst14').hide();
      $('#sgst14').hide();
        
      var markup = "<tr><td width='3%'><input id='checkbox' type='checkbox'></td>"+
      "<td width='30%'><input type='text' name='product_name[]' class='form-control' placeholder='Product Name' ></td>"+
      "<td width='7%'><input type='text' name='hsn_sac[]' class='form-control' placeholder='HSN/SAC'></td>"+
      "<td width='7%'><input type='text' name='sku[]' class='form-control' placeholder='SKU'></td>"+
      "<td width='8%'>"+
        "<input type='text' class='form-control' list='gst' name='gst[]' placeholder='GST in %'>"+
        "<datalist id='gst'>"+
        "  <option value=''>Select GST</option>"+
          "<option value='12'>GST@12%</option>"+
          "<option value='18'>GST@18%</option>"+
          "<option value='28'>GST@28%</option>"+
        "</datalist>"+
      "</td>"+
      "<td width='8%'><input type='text' name='quantity[]' onkeyup='calculate_order()' class='form-control' placeholder='Quantity'></td>"+
      "<td width='10%'><input type='text' name='unit_price[]' onkeyup='calculate_order()' class='form-control start' placeholder='Unit Price'></td>"+
      "<td width='8%'><input id='estimate_purchase_price' name='estimate_purchase_price[]' onkeyup='calculate_order()' class='form-control' type='text' placeholder='Estimate Purchase Price'></td>"+
      "<td width='8%'><input id='initial_est_purchase_price' name='initial_est_purchase_price[]' class='form-control' type='text' placeholder='Initial Estimated Purchase Price' readonly></td>"+
      "<td width='11%'><input type='text' name='total[]' class='form-control' placeholder='Total'></td>"+
      "<input id='percent' name='percent[]' type='hidden'></tr>";
      $("#add").append(markup);

      //Reset error fields
      $("#quote_id_error").html('');
      $("#subject_error").html('');
      $("#contact_name_error").html('');
      $("#quote_stage_error").html('');
      $("#billing_country_error").html('');
      $("#billing_state_error").html('');
      $("#shipping_country_error").html('');
      $("#shipping_state_error").html('');
      $("#billing_city_error").html('');
      $("#billing_zipcode_error").html('');
      $("#shipping_city_error").html('');
      $("#shipping_zipcode_error").html('');
      $("#billing_address_error").html('');
      $("#shipping_address_error").html('');

      $("#btnSave").attr('disabled', true);
    }
  <?php endif; ?>
  
  
  
/****** VALIDATION FUNCTION*********/
function changeClr(idinpt){
  $('#'+idinpt).css('border-color','red');
  $('#'+idinpt).focus();
  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
}

  function checkValidationSO(){

  var quote_id=$('#quote_id').val();
  var org_name=$('#org_name').val();
  var subject=$('#subject').val();
  var opp_name=$('#opp_name').val();
  var due_date=$('#due_date').val();
  var carrier=$('#carrier').val();
  var contact_name=$('#contact_name').val();

  var billing_country=$('#billing_country').val();
  var billing_state=$('#billing_state').val();
  var billing_city=$('#billing_city').val();
  var billing_zipcode=$('#billing_zipcode').val();
  var billing_address=$('#billing_address').val();
  var shipping_country=$('#shipping_country').val();
  var shipping_state=$('#shipping_state').val();
  var shipping_city=$('#shipping_city').val();
  var shipping_zipcode=$('#shipping_zipcode').val();
  var shipping_address=$('#shipping_address').val();
  var discount=$('#discount').val();
  var total_orc=$('#total_orc').val();
  var initial_total=$('#initial_total').val();
  var after_discount_so=$('#after_discount_so').val();

    /*if(quote_id=="" || quote_id===undefined){
      changeClr('quote_id');
      return false;
    }else*/ if(org_name=="" || org_name===undefined){
      changeClr('org_name');
      return false;
    }else if(subject=="" || subject===undefined){
      changeClr('subject');
      return false;
	}else if(contact_name=="" || contact_name===undefined){
      changeClr('contact_name');
      return false;
    }else if(opp_name=="" || opp_name===undefined){
      changeClr('opp_name');
      return false;
    }else if(due_date=="" || due_date===undefined){
      changeClr('due_date');
      return false;
    }else if(carrier=="" || carrier===undefined || carrier==null){
      changeClr('carrier');
      return false;
    }else if(billing_country=="" || billing_country===undefined){
      changeClr('billing_country');
      return false;
    }else if(billing_state=="" || billing_state===undefined){
      changeClr('billing_state');
      return false;
    }else if(billing_city=="" || billing_city===undefined){
      changeClr('billing_city');
      return false;
    }else if(billing_zipcode=="" || billing_zipcode===undefined){
      changeClr('billing_zipcode');
      return false;
    }else if(billing_address=="" || billing_address===undefined){
      changeClr('billing_address');
      return false;
    }else if(shipping_country=="" || shipping_country===undefined){
      changeClr('shipping_country');
      return false;
    }else if(shipping_state=="" || shipping_state===undefined){
      changeClr('shipping_state');
      return false;
    }else if(shipping_city=="" || shipping_city===undefined){
      changeClr('shipping_city');
      return false;
    }else if(shipping_zipcode=="" || shipping_zipcode===undefined){
      changeClr('shipping_zipcode');
      return false;
    }else if(shipping_address=="" || shipping_address===undefined){
      changeClr('shipping_address');
      return false;
    }else if(discount=="" || discount=='0.00'){
      changeClr('discount');
      return false;
    }else if(total_orc=="" || total_orc==null){
      changeClr('total_orc');
      return false;
    }else if(initial_total=="" || initial_total==null){
      changeClr('initial_total');
      return false;
    }else if(after_discount=="" || after_discount==null){
      changeClr('after_discount');
      return false;
    }else{
      return true;
    } 
}


$('.form-control').keypress(function(){
  $(this).css('border-color','')
});
$('.form-control').change(function(){
  $(this).css('border-color','')
});
  
  
  <?php if($this->session->userdata('create_so')=='1' || $this->session->userdata('update_so')=='1'):?>
    $("#btnSave").click(function(e)
    {
	 if(checkValidationSO()==true){
      e.preventDefault();
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable
      var url;
      if(save_method == 'add') {
          url = "<?= base_url('salesorders/create')?>";
      } else {
          url = "<?= base_url('salesorders/update')?>";
      }
	  //alert(url);
      // ajax adding data to database
      var form=$("#form").get(0);
      var formData = new FormData(form);
      //FormData = $('#form').serialize();
	  console.log(formData);
      $.ajax({
        url : url,
        type: "POST",
        data: formData,
        dataType: "JSON",
        processData:false,
        contentType:false,
        cache:false,
       // async:false,
        success: function(data)
        {
			console.log(data);
          if(data.status) //if success close modal and reload ajax table
          {
            $('#sales_popup').modal('hide');
			$('#btnSave').text('Save'); //change button text
			$('#btnSave').attr('disabled',false); //set button disable
            table.ajax.reload();
          }
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
          if(data.st==202)
          {
            $("#quote_id_error").html(data.quote_id);
            $("#subject_error").html(data.subject);
            $("#contact_name_error").html(data.contact_name);
            $("#quote_stage_error").html(data.quote_stage);
            $("#billing_country_error").html(data.billing_country);
            $("#billing_state_error").html(data.billing_state);
            $("#shipping_country_error").html(data.shipping_country);
            $("#shipping_state_error").html(data.shipping_state);
            $("#billing_city_error").html(data.billing_city);
            $("#billing_zipcode_error").html(data.billing_zipcode);
            $("#shipping_city_error").html(data.shipping_city);
            $("#shipping_zipcode_error").html(data.shipping_zipcode);
            $("#billing_address_error").html(data.billing_address);
            $("#shipping_address_error").html(data.shipping_address);
          }
          else if(data.st==200)
          {
            $("#quote_id_error").html('');
            $("#subject_error").html('');
            $("#contact_name_error").html('');
            $("#quote_stage_error").html('');
            $("#billing_country_error").html('');
            $("#billing_state_error").html('');
            $("#shipping_country_error").html('');
            $("#shipping_state_error").html('');
            $("#billing_city_error").html('');
            $("#billing_zipcode_error").html('');
            $("#shipping_city_error").html('');
            $("#shipping_zipcode_error").html('');
            $("#billing_address_error").html('');
            $("#shipping_address_error").html('');
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error adding / update data');
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
        }
      });
	 }
    });
  <?php endif; ?>
  <?php if($this->session->userdata('update_so')=='1'):?>
    function update(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $("#quote_id").attr('readonly',true);

        $("#contact_name").attr('disabled',true);
        $("#type").attr('disabled',true);
        $("#attached_file").hide();
        $("#status").val('');

        $('#igst12').hide();
        $('#igst18').hide();
        $('#igst28').hide();
        $('#cgst6').hide();
        $('#sgst6').hide();
        $('#cgst9').hide();
        $('#sgst9').hide();
        $('#cgst14').hide();
        $('#sgst14').hide();

        // Reset error fields
        $("#quote_id_error").html('');
        $("#subject_error").html('');
        $("#contact_name_error").html('');
        $("#quote_stage_error").html('');
        $("#billing_country_error").html('');
        $("#billing_state_error").html('');
        $("#shipping_country_error").html('');
        $("#shipping_state_error").html('');
        $("#billing_city_error").html('');
        $("#billing_zipcode_error").html('');
        $("#shipping_city_error").html('');
        $("#shipping_zipcode_error").html('');
        $("#billing_address_error").html('');
        $("#shipping_address_error").html('');

        $("#form_type").val('update'); //To set form type for validation

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url('salesorders/getbyId/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {  
                var payTerms_status=data.pay_terms_status;
                if(payTerms_status==0){
                  //$("#So_paymentTerms").css('border-color','red');
                  $('#textMsg').html('<text style="color:red;"><i class="fas fa-exclamation-triangle"></i></i> &nbsp;&nbsp;Disapproved</text>');
                }else if(payTerms_status==1){
                 // $("#So_paymentTerms").css('border-color','');
                  $("#is_status").prop('checked',true);
                  $('#textMsg').html('<text style="color:green;"><i class="fas fa-check" style="color:green"></i> &nbsp;&nbsp;Approved</text>');
                }
                
              $("#add").find("tr").remove();
              $("#contact_name").find("option").not(':first').remove();
              $('[name="id"]').val(data.id);
              $('[name="quote_id"]').val(data.quote_id);
              $('[name="saleorderId"]').val(data.saleorder_id);
              $('[name="owner"]').val(data.owner);
              $('[name="org_name"]').val(data.org_name);
              $('[name="date"]').val(data.currentdate);
              $('[name="subject"]').val(data.subject);
              var cnm = data.contact_name;
              var contact_nm = "<option>"+cnm+"</option>";
              $("#contact_name").append(contact_nm);
              $('[name="contact_name"]').val(data.contact_name);
              $('#contact_name_hidden').val(cnm);
              $('[name="opp_name"]').val(data.opp_name);
              $('[name="pending"]').val(data.pending);
              $('[name="excise_duty"]').val(data.excise_duty);
              $('[name="due_date"]').val(data.due_date);
              $('[name="carrier"]').val(data.carrier);
              $('[name="status"]').val(data.status);
              $('[name="sales_commission"]').val(data.sales_commision);
              $('[name="billing_country"]').val(data.billing_country);
              $('[name="billing_state"]').val(data.billing_state);
              $('[name="shipping_country"]').val(data.shipping_country);
              $('[name="shipping_state"]').val(data.shipping_state);
              $('[name="billing_city"]').val(data.billing_city);
              $('[name="billing_zipcode"]').val(data.billing_zipcode);
              $('[name="shipping_city"]').val(data.shipping_city);
              $('[name="shipping_zipcode"]').val(data.shipping_zipcode);
              $('[name="billing_address"]').val(data.billing_address);
              $('[name="shipping_address"]').val(data.shipping_address);
              //$("#type").find("option").not(':first').remove();
              var type = data.type;
              var tax_type = "<option>"+type+"</option>";
              //$("#type").append(tax_type);
              $('[name="type"]').val(data.type);
              $('#type_hidden').val(type);
              $('#type').val(type);
              
			  
			  var termsCondition = data.terms_condition.split('<br>');
			  if(termsCondition.length>0){
				$("#putlineSalesorder").html('');  
			  }
			  var no=202;
			  for (var i=0; i < termsCondition.length; i++)
              { 
				no++;
				appendLine('putlineSalesorder',no,'terms_condition',termsCondition[i]);
			  }
			  hideShowOnly('termLblSalesorder','termConAppSalesorder');
			  
              var product_name = data.product_name;
              var quantity = data.quantity;
              var unit_price = data.unit_price;
              var total = data.total;
              var percent = data.percent;
              var tot_hsn_sac = data.hsn_sac;
              var tot_sku = data.sku;
              var tot_gst = data.gst;
              var initial_est_purchase_price = data.initial_estimate_purchase_price;
              var estimate_purchase_price = data.estimate_purchase_price;
              var p_name = product_name.split('<br>');
              var qty = quantity.split('<br>');
              var u_prc = unit_price.split('<br>');
              var ttl = total.split('<br>');
              var prcnt = percent.split('<br>');
              var hsn_sac = tot_hsn_sac.split('<br>');
              var sku = tot_sku.split('<br>');
              var gst = tot_gst.split('<br>');
              var per = percent.split('<br>');
              var ini_est_price = initial_est_purchase_price.split('<br>');
              var est_pur_price = estimate_purchase_price.split('<br>');
              for (var i=0; i < p_name.length; i++)
              {
                var markup = "<tr><td width='3%'><input id='checkbox' type='checkbox'></td>"+
                "<td width='30%'><input name='product_name[]' class='form-control' data-toggle='tooltip'  title='"+p_name[i]+"' value='"+p_name[i]+"' type='text' placeholder='Product Name'></td>"+
                "<td width='7%''><input type='text' name='hsn_sac[]' class='form-control' data-toggle='tooltip' title='"+hsn_sac[i]+"' placeholder='HSN/SAC' value='"+hsn_sac[i]+"'></td>"+
                "<td width='7%'><input type='text' name='sku[]' class='form-control' data-toggle='tooltip' title='"+sku[i]+"' placeholder='SKU' value='"+sku[i]+"'></td>"+
                "<td width='8%'>"+
                  "<input type='text' class='form-control' data-toggle='tooltip' title='"+gst[i]+"' list='gst' name='gst[]' placeholder='GST in %' value='"+gst[i]+"'>"+
                  "<datalist id='gst'>"+
                  "  <option value=''>Select GST</option>"+
                    "<option value='12'>GST@12%</option>"+
                    "<option value='18'>GST@18%</option>"+
                    "<option value='28'>GST@28%</option>"+
                  "</datalist>"+
                "</td>"+
                "<td width='8%'><input type='text' name='quantity[]' onkeyup='calculate_order()' class='form-control' data-toggle='tooltip' title='"+qty[i]+"' value='"+qty[i]+"' placeholder='Quantity'></td>"+
                "<td width='10%'><input type='text' name='unit_price[]' onkeyup='calculate_order()' class='form-control start' title='"+numberToIndPrice(u_prc[i])+"' data-toggle='popover' data-trigger='hover' data-content='' value='"+numberToIndPrice(u_prc[i])+"' placeholder='Unit Price'></td>"+
                "<td width='8%'><input id='estimate_purchase_price' name='estimate_purchase_price[]' onkeyup='calculate_order()' class='form-control' data-toggle='tooltip' title='"+numberToIndPrice(est_pur_price[i])+"' type='text' value='"+numberToIndPrice(est_pur_price[i])+"' placeholder='Estimate Purchase Price'></td>"+
                "<td width='8%'><input id='initial_est_purchase_price' name='initial_est_purchase_price[]' class='form-control' data-toggle='tooltip' title='"+numberToIndPrice(ini_est_price[i])+"' type='text' value='"+numberToIndPrice(ini_est_price[i])+"' placeholder='Initial Estimated Purchase Price' readonly></td>"+
                "<td width='11%'><input type='text' name='total[]' class='form-control' data-toggle='tooltip' title='"+numberToIndPrice(ttl[i])+"' value='"+numberToIndPrice(ttl[i])+"' placeholder='Total'></td>"+
                "<input id='percent' name='percent[]' type='hidden' value='"+per[i]+"'></tr>";
                $("#add").append(markup);
              }
              $('[name="initial_total"]').val(numberToIndPrice(data.initial_total));
              $('[name="discount"]').val(data.discount);
              $('[name="after_discount"]').val(numberToIndPrice(data.after_discount));
              $('[name="total_orc"]').val(data.total_orc);
              $('[name="igst12"]').val(data.igst12);
              $('[name="igst18"]').val(data.igst18);
              $('[name="igst28"]').val(data.igst28);
              $('[name="cgst6"]').val(data.cgst6);
              $('[name="sgst6"]').val(data.sgst6);
              $('[name="cgst9"]').val(data.cgst9);
              $('[name="sgst9"]').val(data.sgst9);
              $('[name="cgst14"]').val(data.cgst14);
              $('[name="sgst14"]').val(data.sgst14);
              $('[name="sub_total"]').val(numberToIndPrice(data.sub_totals));
              $('[name="total_est_purchase_price"]').val(numberToIndPrice(data.total_estimate_purchase_price));
              $('[name="profit_by_user"]').val(numberToIndPrice(data.profit_by_user));
              $('[name="customer_company_name"]').val(data.customer_company_name);
              $('[name="customer_name"]').val(data.customer_name);
              $('[name="customer_email"]').val(data.customer_email);
              $('[name="microsoft_lan_no"]').val(data.microsoft_lan_no);
              $('[name="promo_id"]').val(data.promo_id);
              $('[name="customer_address"]').val(data.customer_address);
              $('#sales_popup').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Update Salesorder'); // Set title to Bootstrap modal title
              $('.salesorders').text('Salesorder Notification');
              var type_val = $("#type").val();
              if(type_val == 'Instate') 
              {
                $('#igst12').hide();
                $('#igst18').hide();
                $('#igst28').hide();
                $('#cgst6').show();
                $('#sgst6').show();
                $('#cgst9').show();
                $('#sgst9').show();
                $('#cgst14').show();
                $('#sgst14').show();
              } 
              else if(type_val == 'Interstate') 
              {
                $('#igst12').show();
                $('#igst18').show();
                $('#igst28').show();
                $('#cgst6').hide();
                $('#sgst6').hide();
                $('#cgst9').hide();
                $('#sgst9').hide();
                $('#cgst14').hide();
                $('#sgst14').hide();
              } 
              else 
              {
                $('#igst12').hide();
                $('#igst18').hide();
                $('#igst28').hide();
                $('#cgst6').hide();
                $('#sgst6').hide();
                $('#cgst9').hide();
                $('#sgst9').hide();
                $('#cgst14').hide();
                $('#sgst14').hide();
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Retrieving Data From Database');
            }
        });
    }
  <?php endif; ?>
  <?php if($this->session->userdata('create_po')=='1'):?>
    function purchaseorder(id)
    {
      $("#btnSave1").attr('disabled',true);
        save_method = 'add_po';
        $('#po_f')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $("#saleorder_id").attr('readonly', true);
        $("#type").attr('disabled', true);

        // Reset error fields
        $("#saleorder_id_error").html('');
        $("#subject_error").html('');
        $("#contact_name_error").html('');
        $("#billing_country_error").html('');
        $("#billing_state_error").html('');
        $("#shipping_country_error").html('');
        $("#shipping_state_error").html('');
        $("#billing_city_error").html('');
        $("#billing_zipcode_error").html('');
        $("#shipping_city_error").html('');
        $("#shipping_zipcode_error").html('');
        $("#billing_address_error").html('');
        $("#shipping_address_error").html('');
        $("#supplier_comp_name_error").html('');
        $("#supplier_contact_error").html('');
        $("#supplier_name_error").html('');
        $("#supplier_email_error").html('');

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url('salesorders/getbyId_for_po/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
				//console.log(data);
				
              $("#add_po").find("tr").remove();
              //$("#type_p").find("option").not(':first').remove();
              $('#id_p').val(id);
              $('[name="saleorder_id"').val(data.saleorder_id);
              $('#org_name_p').val(data.org_name);
              $('#date_p').val(data.currentdate);
              $('#subject_p').val(data.subject);
              $('#contact_name_p').val(data.contact_name);
              $('#opportunity_id_p').val(data.opportunity_id);
              $('#so_owner').val(data.owner);
              $('#so_owner_email').val(data.sess_eml);
              $('#productLine').val(data.product_line);
              var type = data.type;
              var tax_type = "<option>"+type+"</option>";
             // $("#type_p").append(tax_type);
              $('#type_tax').val(type);
              $('#type_hidden_p').val(type);
              var product_name = data.product_name;
              var quantity = data.quantity;
              var unit_price = data.unit_price;
              var total = data.total;
              var percent = data.percent;
              var tot_hsn_sac = data.hsn_sac;
              var tot_sku = data.sku;
              var tot_gst = data.gst;
              var initial_est_purchase_price = data.initial_estimate_purchase_price_po;
              var estimate_purchase_price = data.estimate_purchase_price_po;
              var percent = data.percent;
              var total_estimate_purchase_price = data.total_estimate_purchase_price;
              var total_percent = data.total_percent;

              var p_name = product_name.split('<br>');
              var qty = quantity.split('<br>');
              var u_prc = unit_price.split('<br>');
              var ttl = total.split('<br>');
              var hsn_sac = tot_hsn_sac.split('<br>');
              var sku = tot_sku.split('<br>');
              var gst = tot_gst.split('<br>');
              // var ini_est_price = initial_est_purchase_price.split('<br>');
              // var est_pur_price = estimate_purchase_price.split('<br>');
              
              if(data.pay_terms_status==0){
                $('#payTStatus').css('border-color','red');
                $('#payTStatus').val('Disapprove');
                $("#paymsg").show();
            }else{
                $('#payTStatus').css('border-color','');
                $('#payTStatus').val('Approve');
                $("#paymsg").hide();
            }
              
              var per = percent.split('<br>');
              for (var i=0; i < p_name.length; i++)
              {
                var markup = "<tr><td width='3%'><input id='checkbox_p' type='checkbox'></td>"+
                "<td width='30%'><input name='product_name_p[]' class='form-control' value='"+
                p_name[i]+"' type='text' placeholder='Product Name'></td>"+
                "<td width='7%''><input type='text' name='hsn_sac_p[]' class='form-control' placeholder='HSN/SAC' value='"+hsn_sac[i]+"'></td>"+
                "<td width='7%'><input type='text' name='sku_p[]' class='form-control' placeholder='SKU' value='"+sku[i]+"'></td>"+
                "<td width='8%'>"+
                  "<input type='text' class='form-control' list='gst' name='gst_p[]' placeholder='GST in %' value='"+gst[i]+"'>"+
                  "<datalist id='gst'>"+
                  "  <option value=''>Select GST</option>"+
                    "<option value='12'>GST@12%</option>"+
                    "<option value='18'>GST@18%</option>"+
                    "<option value='28'>GST@28%</option>"+
                  "</datalist>"+
                "</td>"+
                "<td width='8%'><input type='text' name='quantity_p[]' onkeyup='calculate_po_salesorder()' class='form-control' value='"+qty[i]+"' placeholder='Quantity'></td>"+
                "<td width='10%'><input type='text' name='unit_price_p[]' onkeyup='calculate_po_salesorder()' class='form-control start' value='"+numberToIndPrice(u_prc[i])+"' placeholder='Unit Price'></td>"+
                "<td width='8%'><input id='estimate_purchase_price_p' name='estimate_purchase_price_p[]' onkeyup='calculate_po_salesorder()' class='form-control' type='text' placeholder='Estimate Purchase Price'></td>"+
                "<td width='8%'><input id='initial_est_purchase_price_p' name='initial_est_purchase_price_p[]' class='form-control' type='text' placeholder='Initial Estimated Purchase Price' readonly></td>"+
                "<td width='11%'><input type='text' name='total_p[]' class='form-control' value='"+numberToIndPrice(ttl[i])+"' placeholder='Total'></td>"+
                "<input id='percent_p' name='percent_p[]' type='hidden' value='"+per[i]+"'></tr>";
                $("#add_po").append(markup);
              }

              $('[name="initial_total"]').val(numberToIndPrice(data.initial_total));
              //$('[name="discount"]').val(data.discount);
              $('[id="after_discount_p"]').val(numberToIndPrice(data.after_discount));
              $('[name="sub_total"]').val(numberToIndPrice(data.sub_totals));
              $('[name="igst12"]').val(data.igst12);
              $('[name="igst18"]').val(data.igst18);
              $('[name="igst28"]').val(data.igst28);
              $('[name="cgst6"]').val(data.cgst6);
              $('[name="sgst6"]').val(data.sgst6);
              $('[name="cgst9"]').val(data.cgst9);
              $('[name="sgst9"]').val(data.sgst9);
              $('[name="cgst14"]').val(data.cgst14);
              $('[name="sgst14"]').val(data.sgst14);

              // $('[name="total_est_purchase_price"]').val(data.total_estimate_purchase_price);
              $('[name="total_percent"]').val(data.total_percent);

              $('[name="company_name"]').val(data.customer_company_name);
              $('[name="customer_name"]').val(data.customer_name);
              $('[name="customer_email"]').val(data.customer_email);
              $('[name="customer_mobile"]').val(data.customer_mobile);
              $('[name="microsoft_lan_no"]').val(data.microsoft_lan_no);
              $('[name="promo_id"]').val(data.promo_id);
              $('[name="customer_address"]').val(data.customer_address);
              var type_val = $("#type_hidden_p").val();
              if(type_val == 'Instate') 
              {
                $('#igst12_p').hide();
                $('#igst18_p').hide();
                $('#igst28_p').hide();
                $('#cgst6_p').show();
                $('#sgst6_p').show();
                $('#cgst9_p').show();
                $('#sgst9_p').show();
                $('#cgst14_p').show();
                $('#sgst14_p').show();
              } 
              else if(type_val == 'Interstate') 
              {
                $('#igst12_p').show();
                $('#igst18_p').show();
                $('#igst28_p').show();
                $('#cgst6_p').hide();
                $('#sgst6_p').hide();
                $('#cgst9_p').hide();
                $('#sgst9_p').hide();
                $('#cgst14_p').hide();
                $('#sgst14_p').hide();
              } 
              else 
              {
                $('#igst12_p').hide();
                $('#igst18_p').hide();
                $('#igst28_p').hide();
                $('#cgst6_p').hide();
                $('#sgst6_p').hide();
                $('#cgst9_p').hide();
                $('#sgst9_p').hide();
                $('#cgst14_p').hide();
                $('#sgst14_p').hide();
              }
              $('#add_popup').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Add Purchaseorder'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Retrieving Data From Database');
            }
        });
    }
  <?php endif; ?>
  
  function checkValidationPO(){

  var saleorder_id=$('#saleorder_id').val();
  var org_name_p=$('#org_name_p').val();
  var subject_p=$('#subject_p').val();
  var branch=$('#branch').val();
  var branch_s=$('#branch_s').val();
 
  var billing_country_p=$('#billing_country_p').val();
  var billing_state_p=$('#billing_state_p').val();
  var billing_city_p=$('#billing_city_p').val();
  var billing_zipcode_p=$('#billing_zipcode_p').val();
  var billing_address_p=$('#billing_address_p').val();
  var shipping_country_p=$('#shipping_country_p').val();
  var shipping_state_p=$('#shipping_state_p').val();
  var shipping_city_p=$('#shipping_city_p').val();
  var shipping_zipcode_p=$('#shipping_zipcode_p').val();
  var shipping_address_p=$('#shipping_address_p').val();
  
  var supplier_comp_name=$('#supplier_comp_name').val();
  var supplier_contact=$('#supplier_contact').val();
  var supplier_name=$('#supplier_name').val();
  var supplier_email=$('#supplier_email').val();
  
  var discount_p=$('#discount_p').val();
  var sub_total_p=$('#sub_total_p').val();
  //var initial_total=$('#initial_total').val();
  var after_discount_p=$('#after_discount_p').val();

    if(saleorder_id=="" || saleorder_id===undefined){
      changeClr('saleorder_id');
      return false;
    }else if(org_name_p=="" || org_name_p===undefined){
      changeClr('org_name_p');
      return false;
    }else if(subject_p=="" || subject_p===undefined){
      changeClr('subject_p');
      return false;
    }else if(branch=="" || branch===undefined || branch==null){
      changeClr('branch');
      return false;
    }else if(branch_s=="" || branch_s===undefined){
      changeClr('branch_s');
      return false;
    }/*else if(carrier=="" || carrier===undefined || carrier==null){
      changeClr('carrier');
      return false;
    }*/else if(billing_country_p=="" || billing_country_p===undefined){
      changeClr('billing_country_p');
      return false;
    }else if(billing_state_p=="" || billing_state_p===undefined){
      changeClr('billing_state_p');
      return false;
    }else if(billing_city_p=="" || billing_city_p===undefined){
      changeClr('billing_city_p');
      return false;
    }else if(billing_zipcode_p=="" || billing_zipcode_p===undefined){
      changeClr('billing_zipcode_p');
      return false;
    }else if(billing_address_p=="" || billing_address_p===undefined){
      changeClr('billing_address_p');
      return false;
    }else if(shipping_country_p=="" || shipping_country_p===undefined){
      changeClr('shipping_country_p');
      return false;
    }else if(shipping_state_p=="" || shipping_state_p===undefined){
      changeClr('shipping_state_p');
      return false;
    }else if(shipping_city_p=="" || shipping_city_p===undefined){
      changeClr('shipping_city_p');
      return false;
    }else if(shipping_zipcode_p=="" || shipping_zipcode_p===undefined){
      changeClr('shipping_zipcode_p');
      return false;
    }else if(shipping_address_p=="" || shipping_address_p===undefined){
      changeClr('shipping_address_p');
      return false;
    }else if(supplier_comp_name=="" || supplier_comp_name===undefined){
      changeClr('supplier_comp_name');
      return false;
    }else if(supplier_name=="" || supplier_name===undefined){
      changeClr('supplier_name');
      return false;
    }else if(supplier_email=="" || supplier_email===undefined){
      changeClr('supplier_email');
      return false;
    }else if(shipping_address_p=="" || shipping_address_p===undefined){
      changeClr('shipping_address_p');
      return false;
    }else if(discount_p=="" || discount_p=='0.00'){
      changeClr('discount_p');
      return false;
    }else if(sub_total_p=="" || sub_total_p==null){
      changeClr('sub_total_p');
      return false;
    }/*else if(initial_total=="" || initial_total==null){
      changeClr('initial_total');
      return false;
    }*/else if(after_discount_p=="" || after_discount_p==null){
      changeClr('after_discount_p');
      return false;
    }else{
      return true;
    } 
}
  
  
  
  <?php if($this->session->userdata('create_po')=='1'):?>
    function save_po()
    {
		
		var payTStatus=$("#payTStatus").val();
    
        if(payTStatus=='Approve'){
		
		if(checkValidationPO()==true){
			
			$('#btnSave1').text('saving...'); //change button text
			$('#btnSave1').attr('disabled',true); //set button disable
			var url;
			if(save_method == 'add_po') {
				url = "<?= base_url('purchaseorders/create')?>";
			}
			  // ajax adding data to database
			$.ajax({
				url : url,
				type: "POST",
				data: $('#po_f').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if(data.status) //if success close modal and reload ajax table
					{
						$('#add_popup').modal('hide');
						reload_table();
						refreshPage();
					}
					$('#btnSave1').text('save'); //change button text
					$('#btnSave1').attr('disabled',false); //set button enable
					if(data.st==202)
					{
					  $("#saleorder_id_error_p").html(data.saleorder_id);
					  $("#subject_error_p").html(data.subject);
					  $("#contact_name_error_p").html(data.contact_name);
					  $("#billing_country_error_p").html(data.billing_country);
					  $("#billing_state_error_p").html(data.billing_state);
					  $("#shipping_country_error_p").html(data.shipping_country);
					  $("#shipping_state_error_p").html(data.shipping_state);
					  $("#billing_city_error_p").html(data.billing_city);
					  $("#billing_zipcode_error_p").html(data.billing_zipcode);
					  $("#shipping_city_error_p").html(data.shipping_city);
					  $("#shipping_zipcode_error_p").html(data.shipping_zipcode);
					  $("#billing_address_error_p").html(data.billing_address);
					  $("#shipping_address_error_p").html(data.shipping_address);
					  $("#supplier_comp_name_error_p").html(data.supplier_comp_name);
					  $("#supplier_contact_error_p").html(data.supplier_contact);
					  $("#supplier_name_error_p").html(data.supplier_name);
					  $("#supplier_email_error_p").html(data.supplier_email); 
					}
					else if(data.st==200)
					{
					  $("#saleorder_id_error_p").html('');
					  $("#subject_error_p").html('');
					  $("#contact_name_error_p").html('');
					  $("#billing_country_error_p").html('');
					  $("#billing_state_error_p").html('');
					  $("#shipping_country_error_p").html('');
					  $("#shipping_state_error_p").html('');
					  $("#billing_city_error_p").html('');
					  $("#billing_zipcode_error_p").html('');
					  $("#shipping_city_error_p").html('');
					  $("#shipping_zipcode_error_p").html('');
					  $("#billing_address_error_p").html('');
					  $("#shipping_address_error_p").html('');
					  $("#supplier_comp_name_error_p").html('');
					  $("#supplier_contact_error_p").html('');
					  $("#supplier_name_error_p").html('');
					  $("#supplier_email_error_p").html('');
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data');
					$('#btnSave1').text('save'); //change button text
					$('#btnSave1').attr('disabled',false); //set button enable
				}
			});
		}
		
        }else{
           $("#paymsg").show();
        }
    }
  <?php endif; ?>
</script>
<?php if($this->session->userdata('create_so') == 1) : ?>
  <script>
  $(document).ready(function()
  {
    $('#quote_id').autocomplete({
      source: "<?= base_url('Salesorders/autocomplete_quoteid');?>",
      select: function (event, ui) {
        $(this).val(ui.item.label);
        $('#quote_id').each(function()
        {
          var quote_id = $(this).val();
          // AJAX request
          $.ajax({
            url:'<?=base_url("Salesorders/get_quote_details")?>',
            method: 'post',
            data: {quote_id: quote_id},
            dataType: 'json',
            success: function(response)
            {
              $("#add").find("tr").remove();
              var len = response.length;
			  if(response[0].error_msg){
				$("#quote_id_error").html(response[0].error_msg);
				$('#id').val('');
                $('#org_name').val('');
                $('#owner').val('');
                $('#date').val('');
                $('#subject').val('');
                $("#contact_name").append('');
                $('#opp_name').val('');
                $('#due_date').val('');
                $('#quote_id').val('');
                $('#carrier').val('');
				    setTimeout(function(){ $("#quote_id_error").html('');},3000);
			  }else if(len > 0)
              {
                $("#contact_name").find("option").not(':first').remove();
                var cnm = response[0].contact_name;
                var contact_nm = "<option value='"+cnm+"'>"+cnm+"</option>";
                $("#contact_name").append(contact_nm);
                $('[name="contact_name"]').val(cnm);
                $('#contact_name_hidden').val(cnm);
                var opp_id = response[0].opportunity_id;
                var id = response[0].id;
                var org_name = response[0].org_name;
                var currentdate = response[0].currentdate;
                var subject = response[0].subject;
                var opp_name = response[0].opp_name;
                var due_date = response[0].valid_until;
                var quote_id = response[0].quote_id;
                var carrier = response[0].carrier;
                var product_name = response[0].product_name;
                var quantity = response[0].quantity;
                var unit_price = response[0].unit_price;
                var total = response[0].total;
                var percent = response[0].percent;
                var tot_hsn_sac = response[0].hsn_sac;
                var tot_sku = response[0].sku;
                var tot_gst = response[0].gst;
                var p_name = product_name.split('<br>');
                var qty = quantity.split('<br>');
                var u_prc = unit_price.split('<br>');
                var ttl = total.split('<br>');
                var prcnt = percent.split('<br>');
                var hsn_sac = tot_hsn_sac.split('<br>');
                var sku = tot_sku.split('<br>');
                var gst = tot_gst.split('<br>');
                var per = percent.split('<br>');
                var initial_total = response[0].initial_total;
                var discount = response[0].discount;
                var after_discount = response[0].after_discount;
                var igst12 = response[0].igst12;
                var igst18 = response[0].igst18;
                var igst28 = response[0].igst28;
                var cgst6 = response[0].cgst6;
                var sgst6 = response[0].sgst6;
                var cgst9 = response[0].cgst9;
                var sgst9 = response[0].sgst9;
                var cgst14 = response[0].cgst14;
                var sgst14 = response[0].sgst14;
                var sub_total = response[0].sub_totalq;
                var billing_country = response[0].billing_country;
                var billing_state = response[0].billing_state;
                var shipping_country = response[0].shipping_country;
                var shipping_state = response[0].shipping_state;
                var billing_city  = response[0].billing_city;
                var billing_zipcode = response[0].billing_zipcode
                var shipping_city = response[0].shipping_city;
                var shipping_zipcode = response[0].shipping_zipcode;
                var billing_address = response[0].billing_address;
                var shipping_address = response[0].shipping_address;
                for (var i=0; i < p_name.length; i++)
                {
                  var markup = "<tr><td width='3%'><input id='checkbox' type='checkbox'></td>"+
                  "<td width='30%'><input name='product_name[]' class='form-control' value='"+
                  p_name[i]+"' data-toggle='tooltip' title='"+p_name[i]+"' type='text' placeholder='Product Name'></td>"+
                  "<td width='7%''><input type='text' name='hsn_sac[]' class='form-control' placeholder='HSN/SAC' value='"+hsn_sac[i]+"' data-toggle='tooltip' title='"+hsn_sac[i]+"'></td>"+
                  "<td width='7%'><input type='text' name='sku[]' class='form-control' placeholder='SKU' value='"+sku[i]+"' data-toggle='tooltip' title='"+sku[i]+"'></td>"+
                  "<td width='8%'>"+
                    "<input type='text' class='form-control' list='gst' name='gst[]' placeholder='GST in %' value='"+gst[i]+"' data-toggle='tooltip' title='"+gst[i]+"'>"+
                    "<datalist id='gst'>"+
                    "  <option value=''>Select GST</option>"+
                      "<option value='12'>GST@12%</option>"+
                      "<option value='18'>GST@18%</option>"+
                      "<option value='28'>GST@28%</option>"+
                    "</datalist>"+
                  "</td>"+
                  "<td width='8%'><input type='text' name='quantity[]' onkeyup='calculate_order()' class='form-control' value='"+qty[i]+"' data-toggle='tooltip' title='"+qty[i]+"' placeholder='Quantity'></td>"+
                  "<td width='10%'><input type='text' name='unit_price[]' onkeyup='calculate_order()' class='form-control start' value='"+u_prc[i]+"' data-toggle='tooltip' title='"+u_prc[i]+"' placeholder='Unit Price'></td>"+
                  "<td width='8%'><input id='estimate_purchase_price' name='estimate_purchase_price[]' onkeyup='calculate_order()' class='form-control' type='text' value='' placeholder='Estimate Purchase Price'></td>"+
                  "<td width='8%'><input id='initial_est_purchase_price' name='initial_est_purchase_price[]' class='form-control' type='text' value='' placeholder='Initial Estimated Purchase Price' readonly></td>"+
                  "<td width='11%'><input type='text' name='total[]' class='form-control' value='"+ttl[i]+"' data-toggle='tooltip' title='"+ttl[i]+"' placeholder='Total'></td>"+
                  "<input id='percent' name='percent[]' type='hidden' value='"+per[i]+"'></tr>";
                  $("#add").append(markup);
                }

                $("#type").find("option").not(':first').remove();
                var type = response[0].type;
                var tax_type = "<option>"+type+"</option>";
                $("#type").append(tax_type);
                $('[name="type"]').val(type);
                $('#type_hidden').val(type);
                $('#id').val(id);
                $('#opportunity_id').val(opp_id);
                $('#org_name').val(org_name);
                $('#date').val(currentdate);
                $('#subject').val(subject);
                $("#contact_name").append(contact_nm);
                $('#opp_name').val(opp_name);
                $('#due_date').val(due_date);
                $('#quote_id').val(quote_id);
                $('#carrier').val(carrier);
                $('[name="initial_total"]').val(initial_total);
                //$('[name="discount"]').val(discount);
                $('[name="after_discount"]').val(after_discount);
                $('[name="sub_total"]').val(sub_total);
                //$('[name="total_percent"]').val(total_percent);
                $('[name="billing_country"]').val(billing_country);
                $('[name="billing_state"]').val(billing_state);
                $('[name="shipping_country"]').val(shipping_country);
                $('[name="shipping_state"]').val(shipping_state);
                $('[name="billing_city"]').val(billing_city);
                $('[name="billing_zipcode"]').val(billing_zipcode);
                $('[name="shipping_city"]').val(shipping_city);
                $('[name="shipping_zipcode"]').val(shipping_zipcode);
                $('[name="billing_address"]').val(billing_address);
                $('[name="shipping_address"]').val(shipping_address);

                $('[name="igst12"]').val(igst12);
                $('[name="igst18"]').val(igst18);
                $('[name="igst28"]').val(igst28);
                $('[name="cgst6"]').val(cgst6);
                $('[name="sgst6"]').val(sgst6);
                $('[name="cgst9"]').val(cgst9);
                $('[name="sgst9"]').val(sgst9);
                $('[name="cgst14"]').val(cgst14);
                $('[name="sgst14"]').val(sgst14);
                
                var type_val = $("#type").val();
                if(type_val == 'Instate') 
                {
                  $('#igst12').hide();
                  $('#igst18').hide();
                  $('#igst28').hide();
                  $('#cgst6').show();
                  $('#sgst6').show();
                  $('#cgst9').show();
                  $('#sgst9').show();
                  $('#cgst14').show();
                  $('#sgst14').show();
                } 
                else if(type_val == 'Interstate') 
                {
                  $('#igst12').show();
                  $('#igst18').show();
                  $('#igst28').show();
                  $('#cgst6').hide();
                  $('#sgst6').hide();
                  $('#cgst9').hide();
                  $('#sgst9').hide();
                  $('#cgst14').hide();
                  $('#sgst14').hide();
                } 
                else 
                {
                  $('#igst12').hide();
                  $('#igst18').hide();
                  $('#igst28').hide();
                  $('#cgst6').hide();
                  $('#sgst6').hide();
                  $('#cgst9').hide();
                  $('#sgst9').hide();
                  $('#cgst14').hide();
                  $('#sgst14').hide();
                }
              }
              else
              {
                $('#id').val('');
                $('#org_name').val('');
                $('#owner').val('');
                $('#date').val('');
                $('#subject').val('');
                $("#contact_name").append('');
                $('#opp_name').val('');
                $('#due_date').val('');
                $('#quote_id').val('');
                $('#carrier').val('');
              }
            }
          });
        });
      }
    });

    });


$('#is_status').change(function() {
        var urlst = "<?= site_url('salesorders/changeStatus'); ?>";

        if ($(this).prop('checked')) {
          var stts=1;
        }else {
          var stts=0;
        }
          var soid=$('#id').val();
         //alert(stts)
           $.ajax({
                url : urlst,
                type: "POST",
                data: "soid="+soid+'&sovalue='+stts,
                success: function(data)
                { 
                  console.log(data);
                  if(data==1){
                    $('#textMsg').html('<text style="color:green;"><i class="fas fa-check" style="color:green"></i> &nbsp;&nbsp;Approved</text>');
                   // $('#So_paymentTerms').css('border-color','');
                  }else if(data==0){
                    $('#textMsg').html('<text style="color:red;"><i class="fas fa-exclamation-triangle"></i></i> &nbsp;&nbsp;Disapproved</text>');
                    $('#So_paymentTerms').css('border-color','red');
                  }else{
                    $('#textMsg').html('Status Changed');
                   // $('#So_paymentTerms').css('border-color','');
                  }
                  
                }
          });

    });

  </script>
<?php endif; ?>
<script>
  jQuery(function(){
        jQuery('.show_div').click(function(){
              jQuery('.targetDiv').hide();
              jQuery('#div'+$(this).attr('target')).show();
        });
});
</script>

<script>
$(document).ready(function(){
  $(".add_row").click(function()
    {
      var markup = "<tr><td width='3%'><input id='checkbox' type='checkbox'></td>"+
      "<td width='30%'><input type='text' name='product_name[]' class='form-control' placeholder='Product Name'></td>"+
      "<td width='7%'><input type='text' name='hsn_sac[]' class='form-control' placeholder='HSN/SAC'></td>"+
      "<td width='7%'><input type='text' name='sku[]' class='form-control' placeholder='SKU'></td>"+
      "<td width='8%'>"+
        "<input type='text' class='form-control' list='gst' name='gst[]' placeholder='GST in %'>"+
        "<datalist id='gst'>"+
        "  <option value=''>Select GST</option>"+
          "<option value='12'>GST@12%</option>"+
          "<option value='18'>GST@18%</option>"+
          "<option value='28'>GST@28%</option>"+
        "</datalist>"+
      "</td>"+
      "<td width='8%'><input type='text' name='quantity[]' onkeyup='calculate_order()' class='form-control' placeholder='Quantity'></td>"+
     "<td width='10%'><input type='text' name='unit_price[]' onkeyup='calculate_order()' class='form-control start' placeholder='Unit Price'></td>"+
      "<td width='8%'><input id='estimate_purchase_price' name='estimate_purchase_price[]' onkeyup='calculate_order()' class='form-control' type='text' placeholder='Estimate Purchase Price'></td>"+
      "<td width='8%'><input id='initial_est_purchase_price' name='initial_est_purchase_price[]' class='form-control' type='text' placeholder='Initial Estimated Purchase Price' readonly></td>"+
      "<td width='11%'><input type='text' name='total[]' class='form-control' placeholder='Total'></td>"+
      "<input id='percent' name='percent[]' type='hidden'></tr>";
      $("#add").append(markup);
  });
  // Find and remove selected table rows
  $(".delete_row").click(function()
  {
    $("#add").find('input[id="checkbox"]').each(function()
    {
      if($(this).is(":checked"))
      {
        $(this).parents("tr").remove();
      }
    });
  });
  
  
    $(".add_row_p").click(function()
    {
      var markup = "<tr><td width='3%'><input id='checkbox_p' type='checkbox'></td>"+
      "<td width='30%'><input type='text' name='product_name_p[]' class='form-control' placeholder='Product Name'></td>"+
      "<td width='7%'><input type='text' name='hsn_sac_p[]' class='form-control' placeholder='HSN/SAC'></td>"+
      "<td width='7%'><input type='text' name='sku_p[]' class='form-control' placeholder='SKU'></td>"+
      "<td width='8%'>"+
        "<input type='text' class='form-control' list='gst' name='gst_p[]' placeholder='GST in %'>"+
        "<datalist id='gst'>"+
        "  <option value=''>Select GST</option>"+
          "<option value='12'>GST@12%</option>"+
          "<option value='18'>GST@18%</option>"+
          "<option value='28'>GST@28%</option>"+
        "</datalist>"+
      "</td>"+
      "<td width='8%'><input type='text' name='quantity_p[]' onkeyup='calculate_po_salesorder()' class='form-control' placeholder='Quantity'></td>"+
      "<td width='10%'><input type='text' name='unit_price_p[]' onkeyup='calculate_po_salesorder()' class='form-control start' placeholder='Unit Price'></td>"+
      "<td width='8%'><input id='estimate_purchase_price_p' name='estimate_purchase_price_p[]' onkeyup='calculate_po_salesorder()' class='form-control' type='text' placeholder='Estimate Purchase Price'></td>"+
      "<td width='8%'><input id='initial_est_purchase_price_p' name='initial_est_purchase_price_p[]' class='form-control' type='text' placeholder='Initial Estimated Purchase Price' readonly></td>"+
      "<td width='11%'><input type='text' name='total_p[]' class='form-control' placeholder='Total'></td>"+
      "<input id='percent' name='percent_p[]' type='hidden'></tr>";
      $("#add_po").append(markup);
  });
  // Find and remove selected table rows
  $(".delete_row_p ").click(function()
  {
    $("#add_po").find('input[id="checkbox_p"]').each(function()
    {
      if($(this).is(":checked"))
      {
        $(this).parents("tr").remove();
        $('#igst12_val_hidden_p').val('');
        $('#igst18_val_hidden_p').val('');
        $('#igst28_val_hidden_p').val('');
        $('#igst12_val_p').text('');
        $('#igst18_val_p').text('');
        $('#igst28_val_p').text('');
        $('#cgst6_val_hidden_p').val('');
        $('#sgst6_val_hidden_p').val('');
        $('#cgst6_val_p').text('');
        $('#sgst6_val_p').text('');
        $('#cgst9_val_hidden_p').val('');
        $('#sgst9_val_hidden_p').val('');
        $('#cgst9_val_p').text('');
        $('#sgst9_val_p').text('');
        $('#cgst14_val_hidden_p').val('');
        $('#sgst14_val_hidden_p').val('');
        $('#cgst14_val_p').text('');
        $('#sgst14_val_p').text('');
        calculate_po_salesorder();
      }
    });
  });



  
 $('.delete_checkbox').click(function(){
  if($(this).is(':checked'))
  {
   $(this).closest('tr').addClass('removeRow');
  }
  else
  {
   $(this).closest('tr').removeClass('removeRow');
  }
});
$('#delete_all2').click(function(){
  var checkbox = $('.delete_checkbox:checked');
  if(checkbox.length > 0)
  {
   $("#delete_confirmation").modal('show');
  }
  else
  {
   alert('Select atleast one records');
  }
});
});

$("#confirmed").click(function(){
  deleteBulkItem('salesorders/delete_bulk'); 
});
</script>


<script>
$(document).ready(function()
{
  $('input[type="checkbox"]').click(function()
  {
    if($(this).is(":checked"))
    {
        $("#is_newed").val(1);
    }
    else if($(this).is(":not(:checked)"))
    {
      $("#is_newed").val(0);
    }
  });
});
</script>
<script>
    $("#discount").keyup(function(){
    var discount = $("#discount").val();
    if(discount != '')
    {
      $("#btnSave").attr('disabled', false);
    }
    else
    {
      $("#btnSave").attr('disabled', true);
    }
  });
  $("#discount_p").keyup(function(){
    var discount = $("#discount_p").val();
    if(discount != '')
    {
      $("#btnSave1").attr('disabled', false);
    }
    else
    {
      $("#btnSave1").attr('disabled', true);
    }
  });
  <?php if($this->session->userdata('delete_so')=='1'):?>
    function delete_entry(id,soid)
    {
		
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
        $.ajax({
          url : "<?= base_url('salesorders/delete'); ?>/"+id+"/"+soid,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
              console.log(data);
            if(data.status){
            //if success reload ajax table
            $('#sales_popup').modal('hide');
            //reload_table();
            refreshPage();
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error deleting data');
          }
        });
      }
    }
  <?php endif; ?>
  </script>
<?php if($this->session->userdata('create_po') == 1) : ?>
  <script type='text/javascript'>
    $(document).ready(function(){
      $('#branch').change(function(){
        var branch_name = $(this).val();
        // AJAX request
        $.ajax({
          url:'<?=base_url('purchaseorders/getbranchVal')?>',
          method: 'post',
          data: {branch_name: branch_name},
          dataType: 'json',
          success: function(response){
            var len = response.length;
            if(len > 0)
            {
              var country = response[0].country;
              var state = response[0].state;
              var city = response[0].city;
              var zipcode = response[0].zipcode;
              var address = response[0].address;
              var gstin = response[0].gstin;
              $('#billing_country_p').val(country);
              $('#billing_state_p').val(state);
              $('#billing_city_p').val(city);
              $('#billing_zipcode_p').val(zipcode);
              $('#billing_address_p').val(address);
              $('#gstin_p').val(gstin);
            }
            else
            {
              $('#billing_country_p').val('');
              $('#billing_state_p').val('');
              $('#billing_city_p').val('');
              $('#billing_zipcode_p').val('');
              $('#billing_address_p').val('');
              $('#gstin_p').val('');
            }
          }
        });
      });
    });
  </script>
  <script type='text/javascript'>
    $(document).ready(function(){
      $('#branch_s').change(function(){
        var branch_name = $(this).val();
        // AJAX request
        $.ajax({
          url:'<?=base_url('purchaseorders/getbranchVal')?>',
          method: 'post',
          data: {branch_name: branch_name},
          dataType: 'json',
          success: function(response){
            var len = response.length;
            if(len > 0)
            {
              var country = response[0].country;
              var state = response[0].state;
              var city = response[0].city;
              var zipcode = response[0].zipcode;
              var address = response[0].address;
              var gstin = response[0].gstin;
              $('#shipping_country_p').val(country);
              $('#shipping_state_p').val(state);
              $('#shipping_city_p').val(city);
              $('#shipping_zipcode_p').val(zipcode);
              $('#shipping_address_p').val(address);
              $('#s_gstin_p').val(gstin);
            }
            else
            {
              $('#shipping_country_p').val('');
              $('#shipping_state_p').val('');
              $('#shipping_city_p').val('');
              $('#shipping_zipcode_p').val('');
              $('#shipping_address_p').val('');
              $('#s_gstin_p').val('');
            }
          }
        });
      });
    });
  </script>
  <script>
    $(document).ready(function(){
      $('#supplier_comp_name').autocomplete({
        source: "<?= base_url('purchaseorders/autocomplete_vendor');?>",
        select: function (event, ui) {
          $(this).val(ui.item.label);
          $('#supplier_comp_name').each(function(){
            var supplier_name = $(this).val();
            // AJAX request
            var v_name='';
            $.ajax({
              url:'<?=base_url('purchaseorders/get_vendor_details')?>',
              method: 'post',
              data: {supplier_name: supplier_name},
              dataType: 'json',
              success: function(response){
                var len = response.length;
                if(len > 0)
                {
                    console.log(response);
                  var id = response[0].id;
                  var supplier_contact = response[0].mobile;
                  var suppiler_name = response[0].primary_contact;
                  var supplier_gstin = response[0].gstin;
                  var supplier_email = response[0].email;
                  var supplier_country = response[0].shipping_country;
                  var supplier_state = response[0].shipping_state;
                  var supplier_city = response[0].shipping_city;
                  var supplier_zipcode = response[0].shipping_zipcode;
                  var supplier_address = response[0].shipping_address;
                  $('#id').val(id);
                  $('#supplier_contact').val(supplier_contact);
                  $('#supplier_gstin').val(supplier_gstin);
                  $('#supplier_name').val(suppiler_name);
                  $('#supplier_email').val(supplier_email);
                  $('#supplier_country').val(supplier_country);
                  $('#supplier_state').val(supplier_state);
                  $('#supplier_city').val(supplier_city);
                  $('#supplier_zipcode').val(supplier_zipcode);
                  $('#supplier_address').val(supplier_address);
                }
                else
                {
                  $('#id').val('');
                  $('#supplier_contact').val('');
                  $('#supplier_name').val('');
                  $('#supplier_email').val('');
                  $('#supplier_country').val('');
                  $('#supplier_state').val('');
                  $('#supplier_city').val('');
                  $('#supplier_zipcode').val('');
                  $('#supplier_address').val('');
                }
              }
            });
          });
        }
      });
    });
  </script>
<?php endif; ?>
<?php if($this->session->userdata('create_so') == 1 || $this->session->userdata('update_so') == 1) :  ?>
  <script>
  function calculate_order()
  {
      $(document).ready(function() {
      $(".start").each(function() {
          var grandTotal = 0;
          var igst12 = 0;
          var igst18 = 0;
          var igst28 = 0;
          var gst12 = 0;
          var gst18 = 0;
          var gst28 = 0;
          var output1 = 0;
          var output2 = 0;
          var output3 = 0;
          var igst12_amnt = 0;
          var igst18_amnt = 0;
          var igst28_amnt = 0;
          var cgst6_amnt = 0;
          var sgst6_amnt = 0;
          var cgst9_amnt = 0;
          var sgst9_amnt = 0;
          var cgst14_amnt = 0;
          var sgst14_amnt = 0;
          var total_est_purchase_price = 0;
          var profit_margin = 0;
		  
           var total_orc2 = document.getElementById('total_orc').value;
		   total_orc2 = total_orc2.replace(/,/g, "");
		   var orctwo=numberToIndPrice(total_orc2);
		   $('#total_orc').val(orctwo);
		 
		    var total_orc = document.getElementById('total_orc').value;
		   total_orc = total_orc.replace(/,/g, "");
		   
          var type = document.getElementById('type').value;
          $("input[name='quantity[]']").each(function (index) {
              var quantity = $("input[name='quantity[]']").eq(index).val();
            
             var price = $("input[name='unit_price[]']").eq(index).val();
			 price = price.replace(/,/g, "");
			 var pricetwo=numberToIndPrice(price);
			
		     $("input[name='unit_price[]']").eq(index).val(pricetwo);
             price = price.replace(/,/g, "");
              var gst = $("input[name='gst[]']").eq(index).val();
              var output = parseInt(quantity) * parseFloat(price);
              var tax = parseFloat(output) * parseFloat(gst)/100;
              //estimate product price
              var estimate_pro_price = $("input[name='estimate_purchase_price[]']").eq(index).val();
            //  alert(estimate_pro_price);
			estimate_pro_price = estimate_pro_price.replace(/,/g, "");
			 var estimate_pro_pricetwo=numberToIndPrice(estimate_pro_price);
		     $("input[name='estimate_purchase_price[]']").eq(index).val(estimate_pro_pricetwo);
             estimate_pro_price = estimate_pro_price.replace(/,/g, "");
			
              var initial_est_purchase_price = parseInt(quantity) * parseFloat(estimate_pro_price);
            //  alert(initial_est_purchase_price);

              if(!isNaN(initial_est_purchase_price))
              {
                  $("input[name='initial_est_purchase_price[]']").eq(index).val(numberToIndPrice(initial_est_purchase_price.toFixed(2)));
                  total_est_purchase_price = parseFloat(total_est_purchase_price) + parseFloat(initial_est_purchase_price);
                  $('#total_est_purchase_price').val(numberToIndPrice(total_est_purchase_price.toFixed(2)));
              
              }

              $("input[name='tax[]']").eq(index).val(tax.toFixed(2));
              if (!isNaN(output))
              {
                  $("input[name='total[]']").eq(index).val(numberToIndPrice(output.toFixed(2)));
                  grandTotal = parseFloat(grandTotal) + parseFloat(output);
                  $('#initial_total').val(numberToIndPrice(grandTotal.toFixed(2)));
                  var initial_total = document.getElementById('initial_total').value;
				  initial_total = initial_total.replace(/,/g, "");
                  var discount = document.getElementById('discount').value;
                  var after_discount = parseFloat(initial_total) - parseFloat(discount);
                  var count = $('#add tr').length;
                  var test_val = document.getElementById('test_val').value;
                  var percent = test_val/parseFloat(count);
                  $("input[name='percent[]']").eq(index).val(percent.toFixed(2));
                  if(total_orc!='')
                  {
                    profit_margin = parseFloat(after_discount) - parseFloat(total_orc) - parseFloat(total_est_purchase_price);
                      $("#profit_by_user").val(numberToIndPrice(profit_margin.toFixed(2)));
                  }
                  else
                  {
                      profit_margin = parseFloat(after_discount) - parseFloat(total_est_purchase_price);
                      $("#profit_by_user").val(numberToIndPrice(profit_margin.toFixed(2)));
                  }

                  if (!isNaN(after_discount))
                  {
                      document.getElementById('after_discount').value = numberToIndPrice(after_discount.toFixed(2));
                      if(type == 'Interstate')
                      {
                          if (gst == 12)
                          {
                              if(!isNaN(igst12))
                              {
                                  igst12 = parseFloat(igst12) + parseFloat(output);
                                  $('#igst12_val').text(igst12.toFixed(2));
                                  $('#igst12_val_hidden').val(igst12.toFixed(2));
                              }
                          }
                          if (gst == 18)
                          {
                              if(!isNaN(igst18))
                              {
                                  igst18 = parseFloat(igst18) + parseFloat(output);
                                  $('#igst18_val').text(igst18.toFixed(2));
                                  $('#igst18_val_hidden').val(igst18.toFixed(2));
                              }
                          }
                          if (gst == 28)
                          {
                              if(!isNaN(igst28))
                              {
                                igst28 = parseFloat(igst28) + parseFloat(output);
                                $('#igst28_val').text(igst28.toFixed(2));
                                $('#igst28_val_hidden').val(igst28.toFixed(2));
                              }
                          }
                          var igst12_amnt = parseFloat(igst12) * 12/100;
                          var igst18_amnt = parseFloat(igst18) * 18/100;
                          var igst28_amnt = parseFloat(igst28) * 28/100;
                          $("#igst12_amnt").val(igst12_amnt.toFixed(2));
                          $("#igst18_amnt").val(igst18_amnt.toFixed(2));
                          $("#igst28_amnt").val(igst28_amnt.toFixed(2));
                          var igst12_amnt_val = $("#igst12_amnt").val();
                          var igst18_amnt_val = $("#igst18_amnt").val();
                          var igst28_amnt_val = $("#igst28_amnt").val();
                          var igst12_val =  document.getElementById('igst12_val_hidden').value;
                          var igst18_val =  document.getElementById('igst18_val_hidden').value;
                          var igst28_val =  document.getElementById('igst28_val_hidden').value;
                          if(igst12_amnt!=0 && igst18_amnt!=0 && igst28_amnt!=0)
                          {
                              var tax_dics = discount/3;
                              igst12_tot_val = igst12 - tax_dics;
                              igst18_tot_val = igst18 - tax_dics;
                              igst28_tot_val = igst28 - tax_dics;
                              $('#igst12_val').text(igst12_tot_val.toFixed(2));
                              $('#igst12_val_hidden').text(igst12_tot_val.toFixed(2));
                              $('#igst18_val').text(igst18_tot_val.toFixed(2));
                              $('#igst18_val_hidden').text(igst18_tot_val.toFixed(2));
                              $('#igst28_val').text(igst28_tot_val.toFixed(2));
                              $('#igst28_val_hidden').text(igst28_tot_val.toFixed(2));
                              var igst12_aftr_disc = igst12_tot_val*12/100;
                              $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));
                              var igst18_aftr_disc = igst18_tot_val*18/100;
                              $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));
                              var igst28_aftr_disc = igst28_tot_val*28/100;
                              $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                              //subtotal calulation
                              var last_igst12_amnt = $("#igst12_amnt").val();
                              var last_igst18_amnt = $("#igst18_amnt").val();
                              var last_igst28_amnt = $("#igst28_amnt").val();
                              var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));

                          }
                          else if(igst12_amnt!=0 && igst18_amnt!=0)
                          {
                              var tax_dics = discount/2;
                              var igst12_tot_val = igst12 - tax_dics;
                              var igst18_tot_val = igst18 - tax_dics;
                              $('#igst12_val').text(igst12_tot_val.toFixed(2));
                              $('#igst18_val').text(igst18_tot_val.toFixed(2));
                              $('#igst12_val_hidden').val(igst12_tot_val.toFixed(2));
                              $('#igst18_val_hidden').val(igst18_tot_val.toFixed(2));
                              var igst12_aftr_disc = igst12_tot_val*12/100;
                              var igst18_aftr_disc = igst18_tot_val*18/100;
                              $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));
                              $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));

                              // subtotal calculation
                              var last_igst12_amnt = $("#igst12_amnt").val();
                              var last_igst18_amnt = $("#igst18_amnt").val();
                              var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                          else if(igst18_amnt!=0 && igst28_amnt!=0)
                          {
                              var tax_dics = discount/2;
                              var igst18_tot_val = igst18 - tax_dics;
                              var igst28_tot_val = igst28 - tax_dics;
                              $('#igst18_val').text(igst18_tot_val.toFixed(2));
                              $('#igst28_val').text(igst28_tot_val.toFixed(2));
                              $('#igst18_val_hidden').val(igst18_tot_val.toFixed(2));
                              $('#igst28_val_hidden').val(igst28_tot_val.toFixed(2));
                              var igst18_aftr_disc = igst18_tot_val*18/100;
                              var igst28_aftr_disc = igst28_tot_val*28/100;
                              $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));
                              $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                              // sub total calculation
                              var last_igst18_amnt = $("#igst18_amnt").val();
                              var last_igst28_amnt = $("#igst28_amnt").val();
                              var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                          else if(igst12_amnt!=0 && igst28_amnt!=0)
                          {
                              var tax_dics = discount/2;
                              var igst12_tot_val = igst12 - tax_dics;
                              var igst28_tot_val = igst28 - tax_dics;
                              $('#igst12_val').text(igst12_tot_val.toFixed(2));
                              $('#igst28_val').text(igst28_tot_val.toFixed(2));
                              $('#igst12_val_hidden').val(igst12_tot_val.toFixed(2));
                              $('#igst28_val_hidden').val(igst28_tot_val.toFixed(2));
                              var igst12_aftr_disc = igst12_tot_val*12/100;
                              var igst28_aftr_disc = igst28_tot_val*28/100;
                              $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));
                              $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                              // sub total calculation
                              var last_igst12_amnt = $("#igst12_amnt").val();
                              var last_igst28_amnt = $("#igst28_amnt").val();
                              var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst28_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                          else if(igst12_amnt!=0)
                          {
                              var tax_dics = discount;
                              var igst12_tot_val = igst12 - tax_dics;
                              $('#igst12_val').text(igst12_tot_val.toFixed(2));
                              $('#igst12_val_hidden').val(igst12_tot_val.toFixed(2));
                              var igst12_aftr_disc = igst12_tot_val*12/100;
                              $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));

                               //subtotal calculation
                              var last_igst12_amnt = $("#igst12_amnt").val();
                              var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));

                          }
                          else if(igst18_amnt!=0)
                          {
                              var tax_dics = discount;
                              igst18_tot_val = igst18 - tax_dics;
                              $('#igst18_val').text(igst18_tot_val.toFixed(2));
                              $('#igst18_val_hidden').val(igst18_tot_val.toFixed(2));
                              var igst18_aftr_disc = igst18_tot_val*18/100;
                              $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));

                              //subtotal calculation
                              var last_igst18_amnt = $("#igst18_amnt").val();
                              var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));

                          }
                          else if(igst28_amnt!=0)
                          {
                              var tax_dics = discount;
                              igst28_tot_val = igst28 - tax_dics;
                              $('#igst28_val').text(igst28_tot_val.toFixed(2));
                              $('#igst28_val_hidden').val(igst28_tot_val.toFixed(2));
                              var igst28_aftr_disc = igst28_tot_val*28/100;
                              $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                              //subtotal calculation
                              var last_igst28_amnt = $("#igst28_amnt").val();
                              var sub_total = parseFloat(after_discount)  + parseFloat(last_igst28_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                      }
                      else if(type == 'Instate')
                      {
                          if (gst == 12)
                          {
                              if(!isNaN(igst12))
                              {
                                  igst12 = parseFloat(igst12) + parseFloat(output);
                                  $('#cgst6_val').text(igst12.toFixed(2));
                                  $('#sgst6_val').text(igst12.toFixed(2));
                                  $('#cgst6_val_hidden').val(igst12.toFixed(2));
                                  $('#sgst6_val_hidden').val(igst12.toFixed(2));
                              }
                          }
                          if (gst == 18)
                          {
                              if(!isNaN(igst18))
                              {
                                  igst18 = parseFloat(igst18) + parseFloat(output);
                                  $('#cgst9_val').text(igst18.toFixed(2));
                                  $('#sgst9_val').text(igst18.toFixed(2));
                                  $('#cgst9_val_hidden').val(igst18.toFixed(2));
                                  $('#sgst9_val_hidden').val(igst18.toFixed(2));
                              }
                          }
                          if (gst == 28)
                          {
                              if(!isNaN(igst28))
                              {
                                igst28 = parseFloat(igst28) + parseFloat(output);
                                $('#cgst14_val').text(igst28.toFixed(2));
                                $('#sgst14_val').text(igst28.toFixed(2));
                                $('#cgst14_val_hidden').val(igst28.toFixed(2));
                                $('#sgst14_val_hidden').val(igst28.toFixed(2));
                              }
                          }
                          var cgst6_amnt = parseFloat(igst12) * 6/100;
                          var sgst6_amnt = parseFloat(igst12) * 6/100;
                          var cgst9_amnt = parseFloat(igst18) * 9/100;
                          var sgst9_amnt = parseFloat(igst18) * 9/100;
                          var cgst14_amnt = parseFloat(igst28) * 14/100;
                          var sgst14_amnt = parseFloat(igst28) * 14/100;
                          $("#cgst6_amnt").val(cgst6_amnt.toFixed(2));
                          $("#sgst6_amnt").val(sgst6_amnt.toFixed(2));
                          $("#cgst9_amnt").val(cgst9_amnt.toFixed(2));
                          $("#sgst9_amnt").val(sgst9_amnt.toFixed(2));
                          $("#cgst14_amnt").val(cgst14_amnt.toFixed(2));
                          $("#sgst14_amnt").val(sgst14_amnt.toFixed(2));
                          if(parseFloat(cgst6_amnt) != 0 && parseFloat(cgst9_amnt) != 0 && parseFloat(cgst14_amnt) != 0)
                          {
                              var tax_dics = discount/3;
                              var cgst6_tot_val = igst12 - tax_dics;
                              var sgst6_tot_val = igst12 - tax_dics;
                              var cgst9_tot_val = igst18 - tax_dics;
                              var sgst9_tot_val = igst18 - tax_dics;
                              var cgst14_tot_val = igst28 - tax_dics;
                              var sgst14_tot_val = igst28 - tax_dics;
                              $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                              $('#cgst6_val_hidden').text(cgst6_tot_val.toFixed(2));
                              $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                              $('#cgst9_val_hidden').text(cgst9_tot_val.toFixed(2));
                              $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                              $('#cgst14_val_hidden').text(cgst14_tot_val.toFixed(2));
                              $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                              $('#sgst6_val_hidden').text(sgst6_tot_val.toFixed(2));
                              $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                              $('#sgst9_val_hidden').text(sgst9_tot_val.toFixed(2));
                              $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                              $('#sgst14_val_hidden').text(sgst14_tot_val.toFixed(2));
                              var cgst6_aftr_disc = cgst6_tot_val*6/100;
                              $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                              $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                              var cgst9_aftr_disc = cgst9_tot_val*9/100;
                              $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                              $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                              var cgst14_aftr_disc = cgst14_tot_val*14/100;
                              $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                              $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));

                              //subtotal calculation
                              var last_cgst6_amnt =  $("#cgst6_amnt").val();
                              var last_sgst6_amnt = $("#sgst6_amnt").val();
                              var last_cgst9_amnt =  $("#cgst9_amnt").val();
                              var last_sgst9_amnt = $("#sgst9_amnt").val();
                              var last_cgst14_amnt =  $("#cgst14_amnt").val();
                              var last_sgst14_amnt = $("#sgst14_amnt").val();
                              var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) +  parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                          else if(cgst6_amnt!=0 && cgst9_amnt!=0)
                          {
                              var tax_dics = discount/2;
                              var cgst6_tot_val = igst12 - tax_dics;
                              var sgst6_tot_val = igst12 - tax_dics;
                              var cgst9_tot_val = igst18 - tax_dics;
                              var sgst9_tot_val = igst18 - tax_dics;
                              $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                              $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                              $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                              $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                              $('#cgst6_val_hidden').val(cgst6_tot_val.toFixed(2));
                              $('#sgst6_val_hidden').val(sgst6_tot_val.toFixed(2));
                              $('#cgst9_val_hidden').val(cgst9_tot_val.toFixed(2));
                              $('#sgst9_val_hidden').val(sgst9_tot_val.toFixed(2));
                              var cgst6_aftr_disc = cgst6_tot_val*6/100;
                              var cgst9_aftr_disc = cgst9_tot_val*9/100;
                              $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                              $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                              $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                              $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));

                              // subtotal calculation
                              var last_cgst6_amnt =  $("#cgst6_amnt").val();
                              var last_sgst6_amnt = $("#sgst6_amnt").val();
                              var last_cgst9_amnt =  $("#cgst9_amnt").val();
                              var last_sgst9_amnt = $("#sgst9_amnt").val();
                              var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                          else if(cgst9_amnt!=0 && cgst14_amnt!=0)
                          {
                              var tax_dics = discount/2;
                              var cgst9_tot_val = igst18 - tax_dics;
                              var sgst9_tot_val = igst18 - tax_dics;
                              var cgst14_tot_val = igst28 - tax_dics;
                              var sgst14_tot_val = igst28 - tax_dics;
                              $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                              $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                              $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                              $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                              $('#cgst9_val_hidden').val(cgst9_tot_val.toFixed(2));
                              $('#sgst9_val_hidden').val(sgst9_tot_val.toFixed(2));
                              $('#cgst14_val_hidden').val(cgst14_tot_val.toFixed(2));
                              $('#sgst14_val_hidden').val(sgst14_tot_val.toFixed(2));
                              var cgst9_aftr_disc = cgst9_tot_val*9/100;
                              var cgst14_aftr_disc = cgst14_tot_val*14/100;
                              $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                              $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                              $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                              $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));

                              //subtotal calculation
                              var last_cgst9_amnt =  $("#cgst9_amnt").val();
                              var last_sgst9_amnt = $("#sgst9_amnt").val();
                              var last_cgst14_amnt =  $("#cgst14_amnt").val();
                              var last_sgst14_amnt = $("#sgst14_amnt").val();
                              var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                          else if(cgst14_amnt!=0 && cgst6_amnt!=0)
                          {
                              var tax_dics = discount/2;
                              var cgst14_tot_val = igst28 - tax_dics;
                              var sgst14_tot_val = igst28 - tax_dics;
                              var cgst6_tot_val = igst12 - tax_dics;
                              var sgst6_tot_val = igst12 - tax_dics;
                              $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                              $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                              $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                              $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                              $('#cgst14_val_hidden').val(cgst14_tot_val.toFixed(2));
                              $('#sgst14_val_hidden').val(sgst14_tot_val.toFixed(2));
                              $('#cgst6_val_hidden').val(cgst6_tot_val.toFixed(2));
                              $('#sgst6_val_hidden').val(sgst6_tot_val.toFixed(2));
                              var cgst14_aftr_disc = cgst14_tot_val*14/100;
                              var cgst6_aftr_disc = cgst6_tot_val*6/100;
                              $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                              $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                              $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                              $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));

                              //subtotal calculation
                              var last_cgst6_amnt =  $("#cgst6_amnt").val();
                              var last_sgst6_amnt = $("#sgst6_amnt").val();
                              var last_cgst14_amnt =  $("#cgst14_amnt").val();
                              var last_sgst14_amnt = $("#sgst14_amnt").val();
                              var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                          else if(cgst6_amnt!=0)
                          {
                              var tax_dics = discount;
                              var cgst6_tot_val = igst12 - tax_dics;
                              var sgst6_tot_val = igst12 - tax_dics;
                              $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                              $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                              $('#cgst6_val_hidden').val(cgst6_tot_val.toFixed(2));
                              $('#sgst6_val_hidden').val(sgst6_tot_val.toFixed(2));
                              var cgst6_aftr_disc = cgst6_tot_val*6/100;
                              $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                              $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));

                              // subtotal calculation
                              var last_cgst6_amnt =  $("#cgst6_amnt").val();
                              var last_sgst6_amnt = $("#sgst6_amnt").val();
                              var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                          else if(cgst9_amnt!=0)
                          {
                              var tax_dics = discount;
                              var cgst9_tot_val = igst18 - tax_dics;
                              var sgst9_tot_val = igst18 - tax_dics;
                              $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                              $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                              $('#cgst9_val_hidden').val(cgst9_tot_val.toFixed(2));
                              $('#sgst9_val_hidden').val(sgst9_tot_val.toFixed(2));
                              var cgst9_aftr_disc = cgst9_tot_val*9/100;
                              $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                              $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));

                              // subtotal calculation
                              var last_cgst9_amnt =  $("#cgst9_amnt").val();
                              var last_sgst9_amnt = $("#sgst9_amnt").val();
                              var sub_total = parseFloat(after_discount) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                          else if(cgst14_amnt!=0)
                          {
                              var tax_dics = discount;
                              var cgst14_tot_val = igst28 - tax_dics;
                              var sgst14_tot_val = igst28 - tax_dics;
                              $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                              $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                              $('#cgst14_val_hidden').val(cgst14_tot_val.toFixed(2));
                              $('#sgst14_val_hidden').val(sgst14_tot_val.toFixed(2));
                              var cgst14_aftr_disc = cgst14_tot_val*14/100;
                              $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                              $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));

                              // subtotal calculation
                              var last_cgst14_amnt =  $("#cgst14_amnt").val();
                              var last_sgst14_amnt = $("#sgst14_amnt").val();
                              var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt);
                              document.getElementById('sub_total').value = numberToIndPrice(sub_total.toFixed(2));
                          }
                      }
                  }
              }
          });
      });
  });
  }
  </script>
<?php endif; ?>
<?php if($this->session->userdata('create_po') == 1) : ?>
<script>
function calculate_po_salesorder()
{  // alert(2);
    $(document).ready(function() {
    $(".start").each(function() {
        var grandTotal = 0;
        var igst12 = 0;
        var igst18 = 0;
        var igst28 = 0;
        var gst12 = 0;
        var gst18 = 0;
        var gst28 = 0;
        var output1 = 0;
        var output2 = 0;
        var output3 = 0;
        var igst12_amnt = 0;
        var igst18_amnt = 0;
        var igst28_amnt = 0;
        var cgst6_amnt = 0;
        var sgst6_amnt = 0;
        var cgst9_amnt = 0;
        var sgst9_amnt = 0;
        var cgst14_amnt = 0;
        var sgst14_amnt = 0;
        var total_est_purchase_price = 0;
        var profit_margin = 0;
        var total_orc2 = document.getElementById('total_orc_p').value;
       
	         total_orc2 = total_orc2.replace(/,/g, "");
			 var total_orctwo=numberToIndPrice(total_orc2);
		     $("#total_orc_p").val(total_orctwo);
			 var total_orc = document.getElementById('total_orc_p').value;
             total_orc = total_orc.replace(/,/g, "");
	   
        $("input[name='quantity_p[]']").each(function (index) {
            var quantity = $("input[name='quantity_p[]']").eq(index).val();
          
             var price = $("input[name='unit_price_p[]']").eq(index).val();
             price = price.replace(/,/g, "");
			 var pricetwo=numberToIndPrice(price);
		     $("input[name='unit_price_p[]']").eq(index).val(pricetwo);
             price = price.replace(/,/g, "");
			 
            var gst = $("input[name='gst_p[]']").eq(index).val();
            var output = parseInt(quantity) * parseFloat(price);
            var tax = parseFloat(output) * parseFloat(gst)/100;
            //estimate product price
            var estimate_pro_price = $("input[name='estimate_purchase_price_p[]']").eq(index).val();
			 estimate_pro_price = estimate_pro_price.replace(/,/g, "");
			 var estimate_pro_pricewo=numberToIndPrice(estimate_pro_price);
			 $("input[name='estimate_purchase_price_p[]']").eq(index).val(estimate_pro_pricewo);
             estimate_pro_price = estimate_pro_price.replace(/,/g, "");
			
            var initial_est_purchase_price = parseInt(quantity) * parseFloat(estimate_pro_price);

            if(!isNaN(initial_est_purchase_price))
            {
                $("input[name='initial_est_purchase_price_p[]']").eq(index).val(numberToIndPrice(initial_est_purchase_price.toFixed(2)));
                total_est_purchase_price = parseFloat(total_est_purchase_price) + parseFloat(initial_est_purchase_price);
                $('#total_est_purchase_price_p').val(numberToIndPrice(total_est_purchase_price.toFixed(2)));
            
            }

            $("input[name='tax[]']").eq(index).val(tax.toFixed(2));
            if (!isNaN(output))
            {
                $("input[name='total_p[]']").eq(index).val(numberToIndPrice(output.toFixed(2)));
                grandTotal = parseFloat(grandTotal) + parseFloat(output);
                $('#initial_total_p').val(numberToIndPrice(grandTotal.toFixed(2)));
                var initial_total = document.getElementById('initial_total_p').value;
				initial_total = initial_total.replace(/,/g, "");
                var discount = document.getElementById('discount_p').value;
                var after_discount = parseFloat(initial_total) - parseFloat(discount);
                var count = $('#add_po tr').length;
                var test_val = document.getElementById('test_val_p').value;
                var percent = test_val/parseFloat(count);
                $("input[name='percent_p[]']").eq(index).val(percent.toFixed(2));


                if(total_orc!='')
                {
                    profit_margin = parseFloat(after_discount) - parseFloat(total_orc) - parseFloat(total_est_purchase_price);
                    $("#profit_by_user_p").val(numberToIndPrice(profit_margin.toFixed(2)));
                }
                else
                {
                    profit_margin = parseFloat(after_discount) - parseFloat(total_est_purchase_price);
                    $("#profit_by_user_p").val(numberToIndPrice(profit_margin.toFixed(2)));
                }

                if (!isNaN(after_discount))
                {
                    document.getElementById('after_discount_p').value = numberToIndPrice(after_discount.toFixed(2));
                    if(type == 'Interstate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#igst12_val_p').text(igst12.toFixed(2));
                                $('#igst12_val_hidden_p').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#igst18_val_p').text(igst18.toFixed(2));
                                $('#igst18_val_hidden_p').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#igst28_val_p').text(igst28.toFixed(2));
                              $('#igst28_val_hidden_p').val(igst28.toFixed(2));
                            }
                        }
                        var igst12_amnt = parseFloat(igst12) * 12/100;
                        var igst18_amnt = parseFloat(igst18) * 18/100;
                        var igst28_amnt = parseFloat(igst28) * 28/100;
                        $("#igst12_amnt_p").val(igst12_amnt.toFixed(2));
                        $("#igst18_amn_p").val(igst18_amnt.toFixed(2));
                        $("#igst28_amnt_p").val(igst28_amnt.toFixed(2));
                        var igst12_amnt_val = $("#igst12_amnt_p").val();
                        var igst18_amnt_val = $("#igst18_amnt_p").val();
                        var igst28_amnt_val = $("#igst28_amnt_p").val();
                        var igst12_val =  document.getElementById('igst12_val_hidden_p').value;
                        var igst18_val =  document.getElementById('igst18_val_hidden_p').value;
                        var igst28_val =  document.getElementById('igst28_val_hidden_p').value;
                        if(igst12_amnt!=0 && igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/3;
                            igst12_tot_val = igst12 - tax_dics;
                            igst18_tot_val = igst18 - tax_dics;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val_p').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden_p').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val_p').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden_p').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val_p').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden_p').text(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt_p").val(igst12_aftr_disc.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt_p").val(igst18_aftr_disc.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt_p").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calulation
                            var last_igst12_amnt = $("#igst12_amnt_p").val();
                            var last_igst18_amnt = $("#igst18_amnt_p").val();
                            var last_igst28_amnt = $("#igst28_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));

                        }
                        else if(igst12_amnt!=0 && igst18_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst18_tot_val = igst18 - tax_dics;
                            $('#igst12_val_p').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val_p').text(igst18_tot_val.toFixed(2));
                            $('#igst12_val_hidden_p').val(igst12_tot_val.toFixed(2));
                            $('#igst18_val_hidden_p').val(igst18_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst12_amnt_p").val(igst12_aftr_disc.toFixed(2));
                            $("#igst18_amnt_p").val(igst18_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt_p").val();
                            var last_igst18_amnt = $("#igst18_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                        else if(igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst18_tot_val = igst18 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst18_val_p').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val_p').text(igst28_tot_val.toFixed(2));
                            $('#igst18_val_hidden_p').val(igst18_tot_val.toFixed(2));
                            $('#igst28_val_hidden_p').val(igst28_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst18_amnt_p").val(igst18_aftr_disc.toFixed(2));
                            $("#igst28_amnt_p").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst18_amnt = $("#igst18_amnt_p").val();
                            var last_igst28_amnt = $("#igst28_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                        else if(igst12_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val_p').text(igst12_tot_val.toFixed(2));
                            $('#igst28_val_p').text(igst28_tot_val.toFixed(2));
                            $('#igst12_val_hidden_p').val(igst12_tot_val.toFixed(2));
                            $('#igst28_val_hidden_p').val(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst12_amnt_p").val(igst12_aftr_disc.toFixed(2));
                            $("#igst28_amnt_p").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst12_amnt = $("#igst12_amnt_p").val();
                            var last_igst28_amnt = $("#igst28_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                        else if(igst12_amnt!=0)
                        {
                            var tax_dics = discount;
                            var igst12_tot_val = igst12 - tax_dics;
                            $('#igst12_val_p').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden_p').val(igst12_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt_p").val(igst12_aftr_disc.toFixed(2));

                             //subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));

                        }
                        else if(igst18_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst18_tot_val = igst18 - tax_dics;
                            $('#igst18_val_p').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden_p').val(igst18_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt_p").val(igst18_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst18_amnt = $("#igst18_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));

                        }
                        else if(igst28_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst28_val_p').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden_p').val(igst28_tot_val.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt_p").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst28_amnt = $("#igst28_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                    }
                    else if(type == 'Instate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#cgst6_val_p').text(igst12.toFixed(2));
                                $('#sgst6_val_p').text(igst12.toFixed(2));
                                $('#cgst6_val_hidden_p').val(igst12.toFixed(2));
                                $('#sgst6_val_hidden_p').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#cgst9_val_p').text(igst18.toFixed(2));
                                $('#sgst9_val_p').text(igst18.toFixed(2));
                                $('#cgst9_val_hidden_p').val(igst18.toFixed(2));
                                $('#sgst9_val_hidden_p').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#cgst14_val_p').text(igst28.toFixed(2));
                              $('#sgst14_val_p').text(igst28.toFixed(2));
                              $('#cgst14_val_hidden_p').val(igst28.toFixed(2));
                              $('#sgst14_val_hidden_p').val(igst28.toFixed(2));
                            }
                        }
                        var cgst6_amnt = parseFloat(igst12) * 6/100;
                        var sgst6_amnt = parseFloat(igst12) * 6/100;
                        var cgst9_amnt = parseFloat(igst18) * 9/100;
                        var sgst9_amnt = parseFloat(igst18) * 9/100;
                        var cgst14_amnt = parseFloat(igst28) * 14/100;
                        var sgst14_amnt = parseFloat(igst28) * 14/100;
                        $("#cgst6_amnt_p").val(cgst6_amnt.toFixed(2));
                        $("#sgst6_amnt_p").val(sgst6_amnt.toFixed(2));
                        $("#cgst9_amnt_p").val(cgst9_amnt.toFixed(2));
                        $("#sgst9_amnt_p").val(sgst9_amnt.toFixed(2));
                        $("#cgst14_amnt_p").val(cgst14_amnt.toFixed(2));
                        $("#sgst14_amnt_p").val(sgst14_amnt.toFixed(2));
                        if(parseFloat(cgst6_amnt) != 0 && parseFloat(cgst9_amnt) != 0 && parseFloat(cgst14_amnt) != 0)
                        {
                            var tax_dics = discount/3;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst6_val_p').text(cgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_p').text(cgst6_tot_val.toFixed(2));
                            $('#cgst9_val_p').text(cgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_p').text(cgst9_tot_val.toFixed(2));
                            $('#cgst14_val_p').text(cgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_p').text(cgst14_tot_val.toFixed(2));
                            $('#sgst6_val_p').text(sgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_p').text(sgst6_tot_val.toFixed(2));
                            $('#sgst9_val_p').text(sgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_p').text(sgst9_tot_val.toFixed(2));
                            $('#sgst14_val_p').text(sgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_p').text(sgst14_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_p").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_p").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt_p").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_p").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_p").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) +  parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                        else if(cgst6_amnt!=0 && cgst9_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst6_val_p').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_p').text(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val_p').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_p').text(sgst9_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_p').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_p').val(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_p').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_p').val(sgst9_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            $("#cgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_p").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_p").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt_p").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                        else if(cgst9_amnt!=0 && cgst14_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst9_val_p').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_p').text(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val_p').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_p').text(sgst14_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_p').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_p').val(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_p').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_p').val(sgst14_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            $("#cgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt_p").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_p").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_p").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                        else if(cgst14_amnt!=0 && cgst6_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst14_val_p').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_p').text(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val_p').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_p').text(sgst6_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_p').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_p').val(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_p').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_p').val(sgst6_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));
                            $("#cgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_p").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_p").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_p").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                        else if(cgst6_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst6_val_p').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_p').text(sgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_p').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_p').val(sgst6_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_p").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                        else if(cgst9_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst9_val_p').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_p').text(sgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_p').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_p').val(sgst9_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt_p").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                        else if(cgst14_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst14_val_p').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_p').text(sgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_p').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_p').val(sgst14_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst14_amnt =  $("#cgst14_amnt_p").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt);
                            document.getElementById('sub_total_p').value = numberToIndPrice(sub_total.toFixed(2));
                        }
                    }
                }
            }
        });
    });
});
}
</script>
<?php endif; ?>
<script>
function refreshPage(){
    window.location.reload();
} 
//function selectgst() 
//{
//alert('hello');
    // $('#igst12').hide();
    // $('#igst18').hide();
    // $('#igst28').hide();
    // $('#cgst6').hide();
    // $('#sgst6').hide();
    // $('#cgst9').hide();
    // $('#sgst9').hide();
    // $('#cgst14').hide();
    // $('#sgst14').hide();
     $('#type_tax').change(function(){
       
        if($('#type_tax').val() == 'Instate') {
            $('#igst12_p').hide();
            $('#igst18_p').hide();
            $('#igst28_p').hide();
            $('#cgst6_p').show();
            $('#sgst6_p').show();
            $('#cgst9_p').show();
            $('#sgst9_p').show();
            $('#cgst14_p').show();
            $('#sgst14_p').show();
        } else if($('#type_tax').val() == 'Interstate') {
            
            $('#igst12_p').show();
            $('#igst18_p').show();
            $('#igst28_p').show();
            $('#cgst6_p').hide();
            $('#sgst6_p').hide();
            $('#cgst9_p').hide();
            $('#sgst9_p').hide();
            $('#cgst14_p').hide();
            $('#sgst14_p').hide();
        } else {
            $('#igst12_p').hide();
            $('#igst18_p').hide();
            $('#igst28_p').hide();
            $('#cgst6_p').hide();
            $('#sgst6_p').hide();
            $('#cgst9_p').hide();
            $('#sgst9_p').hide();
            $('#cgst14_p').hide();
            $('#sgst14_p').hide();
       }
     });
//}
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('#org_name').autocomplete({
    source: "<?= base_url('organizations/autocomplete_org');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#org_name').each(function(){
        var org_name = $(this).val();
        // AJAX request
        $.ajax({
          url:'<?=base_url('contacts/get_org_details')?>',
          method: 'post',
          data: {org_name: org_name},
          dataType: 'json',
          success: function(response)
          {
            var len = response.length;
            if(len > 0)
            {
              var email = response[0].email;
              var mobile = response[0].mobile;
              $('#email').val(email);
              $('#mobile').val(mobile);
            }
            else
            {
              $('#email').val('');
              $('#mobile').val('');
            }
          }
        });
        $('#contact_name_hidden').val('');
        $.ajax({
        url:'<?=base_url("contacts/getContact")?>',
        method: 'post',
        data: {org_name: org_name},
        dataType: 'json',
        success: function(response)
        {
			 // console.log(response);
          // Remove options
          $('#contact_name').find('option').not(':first').remove();
          // Add options
          $.each(response,function(index,data){
			
            $('#contact_name').append('<option value="'+data['name']+'">'+data['name']+'</option>');
          });
        }
      });
      });
    }
  });
});
</script>
<script type="text/javascript">

$(document).ready(function(){
  $('#contact_name').change(function(){
    var name = $(this).val();
	//alert(name);
    // AJAX request
    $.ajax({
      url:'<?=base_url("opportunities/getContactVal")?>',
      method: 'post',
      data: {name: name},
      dataType: 'json',
      success: function(response){
		  console.log(response);
        var len = response.length;
        if(len > 0)
        {
          var email = response[0].email;
          var billing_country = response[0].billing_country;
          var billing_state = response[0].billing_state;
          var shipping_country = response[0].shipping_country;
          var shipping_state = response[0].shipping_state;
          var billing_city = response[0].billing_city;
          var billing_zipcode = response[0].billing_zipcode;
          var shipping_city = response[0].shipping_city;
          var shipping_zipcode = response[0].shipping_zipcode;
          var billing_address = response[0].billing_address;
          var shipping_address = response[0].shipping_address;
          $('#email').val(email);
          $('#billing_country').val(billing_country);
          $('#billing_state').val(billing_state);
          $('#shipping_country').val(shipping_country);
          $('#shipping_state').val(shipping_state);
          $('#billing_city').val(billing_city);
          $('#billing_zipcode').val(billing_zipcode);
          $('#shipping_city').val(shipping_city);
          $('#shipping_zipcode').val(shipping_zipcode);
          $('#billing_address').val(billing_address);
          $('#shipping_address').val(shipping_address);
        }
        else
        {
          $('#email').val('');
          $('#billing_country').val('');
          $('#billing_state').val('');
          $('#shipping_country').val('');
          $('#shipping_state').val('');
          $('#billing_city').val('');
          $('#billing_zipcode').val('');
          $('#shipping_city').val('');
          $('#shipping_zipcode').val('');
          $('#billing_address').val('');
          $('#shipping_address').val('');
        }
      }
    });
  });
});

  $(document).ready(function(){
    $('#billing_country').autocomplete({
      source: "<?= site_url('login/autocomplete_countries');?>",
      select: function (event, ui) {
        $(this).val(ui.item.label);
        $('#billing_country_id').val(ui.item.values);
      }
    });
  });
  </script>
  <script>
  $(document).ready(function(){
    $('#billing_state').autocomplete({
        source: function(request, response) {
           var country_id =$('#billing_country_id').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_states');?>",
                data: { terms: request.term, country_id: country_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
      //source: "<?= site_url('login/autocomplete_states');?>",
      select: function (event, ui) {
        $(this).val(ui.item.label);
        $('#billing_state_id').val(ui.item.values);
      }
    });
  });
  </script>
  <script>
  $(document).ready(function(){
    $('#billing_city').autocomplete({
        source: function(request, response) {
           var state_id =$('#billing_state_id').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_cities');?>",
                data: { terms: request.term, state_id: state_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
      //source: "<?= site_url('login/autocomplete_cities');?>",
      select: function (event, ui) {
        $(this).val(ui.item.label);
      }
    });
  });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
    $('#shipping_country').autocomplete({
      source: "<?= site_url('login/autocomplete_countries');?>",
      select: function (event, ui) {
        $(this).val(ui.item.label);
        $('#shipping_country_id').val(ui.item.values);
      }
    });
  });
  </script>
  <script>
  $(document).ready(function(){
    $('#shipping_state').autocomplete({
       source: function(request, response) {
           var country_id =$('#shipping_country_id').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_states');?>",
                data: { terms: request.term, country_id: country_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            }, 
      //source: "<?= site_url('login/autocomplete_states');?>",
      select: function (event, ui) {
        $(this).val(ui.item.label);
        $('#shipping_state_id').val(ui.item.values);
      }
    });
  });
  </script>
  <script>
  $(document).ready(function(){
    $('#shipping_city').autocomplete({
     source: function(request, response) {
           var state_id =$('#shipping_state_id').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_cities');?>",
                data: { terms: request.term, state_id: state_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },   
      //source: "<?= site_url('login/autocomplete_cities');?>",
      select: function (event, ui) {
        $(this).val(ui.item.label);
      }
    });
  });
  </script>