<?php $this->load->view('common_navbar');?>
<style>
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

 <!-- modal Mass Product start-->
    <div class="modal fade" id="mass_product_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Mass Update </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="massForm" method="post" action="">


              <div class="col-lg-12">
                <div class="form-row d-flex align-items-end">
                    <input type="hidden" id ="mass_id" name = "mass_id">
                    
                    <!-- Type Field -->
                    <div class="col pr-1">
                        <div class="form-group">
                            <label> </label>
                            <select class="form-control type-select" name="mass_name" id ="mass_name" required>
                                <option value="" selected disabled>Select a Field </option>

                                <!-- Numeric -->
                                <option value="product_name">Product Name</option>
                                <option value="sku">SKU</option>
                                <option value="hsn_code">HSN/SAC</option>
                                <option value="product_category">Product Category</option>
                                <option value="income_account"> Income Account </option>
                                <option value="product_description">Sales Description</option>
                                <option value="product_unit_price">Cost</option>
                                <option value="product_quantity">QTY on Hand</option>
                                <option value="stock_alert">Low Stock Alert</option>
                               
                            </select>
                        </div>
                    </div>

                      <div class="col pr-1 dummytext" >
                        <div class ="form-group">
                            <input type="text" id ="dummytext" placeholder="Enter Value" class="form-control" readonly>
                        </div>
                      </div> 

                    <!-- Length Field -->
                    <div class="col pl-1 length-wrapper" style="display: none;">
                        <div class="form-group">
                          <input type="text" class="form-control length-input" name="mass_value" id ="mass_value" placeholder="Enter value">

                          <select class="form-control product_category-select" id ="product_category_select" style="display: none;">
                            <option value="">Select Category</option>
                            <option value="Product">Product</option>
                            <option value="Service">Service</option>
                      
                            <!-- Add more options as needed -->
                          </select>

                          <select class="form-control income_account-select" id ="income_account_select" style="display: none;">
                            <option value="">Select Income Account</option>
                            <option value="Sales">Sales</option>
                            <option value="Product Sales">Product Sales</option>
                            <option value="Sales Software">Sales Software</option>
                            <option value="Sales Support and Management">Sales Support and Management</option>
                      
                            <!-- Add more options as needed -->
                          </select>
                         </div>
                    </div>

                   

                </div>
              </div>
                    <!-- Hidden field that carries final value -->
                    <input type="hidden" name="mass_value" id="final_value_input">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="massUpdateBtn">Update</button>
          </div>
        </div>
      </div>
    </div>

  <!-- modal Mass Product end-->







  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);overflow-x:clip;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Product & Services</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home">Home</a></li>
              <li class="breadcrumb-item active">Product & Services</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="container-fliud filterbtncon"  >
        <div class="row mb-3">
          
            <?php if(check_permission_status('Product','retrieve_u')==true): ?>
              <?php 
                                        //  $fifteen = strtotime("-15 Day"); 
                                        //  $thirty = strtotime("-30 Day"); 
                                        //  $fortyfive = strtotime("-45 Day"); 
                                        //  $sixty = strtotime("-60 Day"); 
                                        //  $ninty = strtotime("-90 Day"); 
                                        //  $six_month = strtotime("-180 Day"); 
                                        //  $one_year = strtotime("-365 Day");
                                  ?>
         
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

          <?php endif; ?>
          <div class="col-lg-4">
              <a id="product_Link" href="#" style="text-decoration:none;">
                <button type="button" id="pro_update" class="btn" style="display:none; border-radius: 2rem; margin-bottom: 1rem; background: #845ADF; color:#fff; font-weight: 500;">
                    Update Product
                </button>
            </a>

             <a id="mass_model" href="#" style="text-decoration:none;">
                <button type="button" id="mass_product" class="btn" style="display:none; border-radius: 2rem; margin-bottom: 1rem; background: #845ADF; color:#fff; font-weight: 500;">
                    Mass Update
                </button>
            </a>
          </div>
          <div class="col-md-6">
			      <div class="refresh_button float-right">

              <button class="btncorner" onclick="import_excel()">Import&nbsp;Product</button>
              <button class="btnstop" ><a href="<?=base_url();?>inventory-form"  target="_blank" style="color:#fff; padding: 0px;">New Inventory</a></button>
              <!--<a href="<?=base_url();?>service-form" type="button" class="btn btn-info btn-sm rounded-0" target="_blank">New Service</a>-->

            
            </div>

          </div>
        </div>


      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php if(check_permission_status('Product','retrieve_u')==true): ?>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Main row -->
           <!-- Map card -->
              <div class="card org_div">
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                      <thead >
                        <tr>
                          <?php if($this->session->userdata('delete_product')=='1'):?>
                              <th><button class="btn" type="button" name="delete_all" id="delete_all"><i class="fa fa-trash text-light"></i></button></th>
                          <?php endif; ?>
                          <th class="th-sm">Name</th>
                          <th class="th-sm">SKU</th>
                          <th class="th-sm">HSN/SAC</th>
                          <th class="th-sm">Type</th>
                          <th class="th-sm">Sales Description</th>
                          <th class="th-sm">Cost</th>
                          <th class="th-sm">QTY on Hand</th>
                          <th class="th-sm">Low Stock Alert</th>
                          <th class="th-sm" style="width:8%;" >Action</th>
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
    <?php endif; ?>

  </div>
  <!-- /.content-wrapper -->
  
  <!-- View data modal -->
<div class="modal fade show" id="view_popup" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="organization_add_edit">Organization</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body form">
          <form id="view" class="row" action="#">
            <div class="col-sm-12">
              <h5 class="text-primary" id="org_name"></h5>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Product&nbsp;Name:</span>
			  <h6 class="text-primary" id="product_name"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Product&nbsp;ID:</span>
			  <h6 class="text-primary" id="product_id"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">SKU:</span>
			  <h6 class="text-primary" id="skupro"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">isbn:</span>
			  <h6 class="text-primary" id="isbnpro"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">HSN&nbsp;Code:</span>
			  <h6 class="text-primary" id="hsn_code"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Product Unit:</span>
			  <h6 class="text-primary" id="unitpro"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Product Quantity:</span>
			  <h6 class="text-primary" id="product_quantity"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Unit Price:</span>
			  <h6 class="text-primary" id="product_unit_price"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Stock&nbsp;Alert:</span>
			  <h6 class="text-primary" id="stock_alert"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Reverse&nbsp;Charge:</span>
			  <h6 class="text-primary" id="reverse_charge"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Preferred Supplier:</span>
			  <h6 class="text-primary" id="preferred_supplier"></h6>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary">Product Description:</span>
			  <h6 class="text-primary" id="product_description"></h6>
            </div>
           
          </form>
        </div>
    </div>
  </div>
</div>
<!-- View modal -->

	<div class="modal fade" id="modal_import_org" role="dialog">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">CSV File&nbsp;Import for Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                  <form method="post" id="import_form" enctype="multipart/form-data">
                   <p><label>Select CSV File</label>
                   <input type="file" name="file" id="file" required accept=".csv" />
                   <br><a href="<?php echo SAMPLE_EXCEL;?>product_sample.csv">View CSV File sample</a>
                  </p>

                   <br />
                   <div id="excel_table">
                    <b>**Note : These Entries Already Existed</b>
                      <table id="duplicate_entry" style="width: 100%;">
                        <tr>
                          <th>Product Name</th>
                          <th>SKU</th>
                          <th>Price</th>
                        </tr>
                      </table>
                    </div>
                    <br>
                   
                   <button type="submit" name="import" value="Import" class="btn btn-info" id="import_button">Import</button>
                  <label style="padding-top: 7px;float: right;"><i class="fas fa-info-circle" style="color:red"></i> Only csv file accepted.</label>
                  </form>
                </div>
              </div>
            </div>
        </div>

                          </div>
 <?php $this->load->view('footer');?>

<!-- ./wrapper -->

<style>
.bgclr{
	background: #066675;
}
</style>

<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<script>
$(document).ready(function(){
  $("#excel_table").hide();
 $('#import_form').on('submit', function(event){
    
  event.preventDefault();
  $.ajax({
   url:"<?php echo base_url(); ?>Product_manager/import",
   method:"POST",
   data:new FormData(this),
   dataType : 'JSON',
   contentType:false,
   cache:false,
   processData:false,
   success:function(response)
   {
        //alert('hii check');
      //console.log(response);
    if(response.st == 202)
    {
      $('#file').val('');
      alert(response.msg);
    }
    else if(response.st == 200)
    {
      $('#file').val('');
      alert(response.msg);
      $('#modal_import_org').modal('hide');
      window.location.reload();//reload datatable ajax
    }
    else 
    {
      // To append the Excel data
      $.each(response, function() 
      {
        $("#excel_table").show();
        var message = "<tr><td>"+this.product_name+"</td><td>"+this.sku+"</td><td>"+this.product_unit_price+"</td></tr>";
       $("#duplicate_entry").append(message);
     });
      $("#import_button").attr('disabled',true);
    }
    
   }
  })
 });

});
</script>
<script>
 function import_excel()
  {
    $('#modal_import_org').modal('show'); // show bootstrap modal
    $('#file').val('');
    $("#excel_table").hide();
    $("#duplicate_entry").empty();
    $("#import_button").attr('disabled',false);
  }


  var save_method; //for save method string
  var table;
$(document).ready(function () {
  
   <?php if(check_permission_status('Product','retrieve_u')==true): ?>
    //datatables
    table = $('#ajax_datatable').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('product_manager/ajax_list')?>",
            "type": "POST",
             "data" : function(data)
             {
                data.searchDate = $('#date_filter').val();
             }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ 0 ], //last column
            "orderable": false, //set not orderable
        }
        ],"language": {
				"infoEmpty": "No records available - Got it?",
			}
    });
    $('#date_filter').change(function(){
      table.ajax.reload();
    });
  <?php endif; ?>
});
  

 
  <?php if(check_permission_status('Product','retrieve_u')==true): ?>
    function view(id)
    {
      $('#view')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $("#view_add").find("tr").not(':first').remove();
      $.ajax({
        url : "<?php echo site_url('product_manager/getbyId/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('[id="product_name"]').text(data.product_name);
          $('[id="product_id"]').text(data.product_id);
          $('[id="skupro"]').text(data.sku);
          $('[id="isbnpro"]').text(data.isbn);
          $('[id="hsn_code"]').text(data.hsn_code);
          $('[id="unitpro"]').text(data.unit);
          $('[id="product_quantity"]').text(data.product_quantity);
          $('[id="product_unit_price"]').text(data.product_unit_price);
          $('[id="stock_alert"]').text(data.stock_alert);
          $('[id="reverse_charge"]').text(data.reverse_charge);
          $('[id="preferred_supplier"]').text(data.preferred_supplier);
          $('[id="product_description"]').text(data.product_description);
         /* $('[id="as_of"]').text(data.as_of);
          $('[id="tax_registration_no"]').text(data.tax_registration_no);
          $('[id="effective_date"]').text(data.effective_date);
          $('[id="country"]').text(data.country);
          $('[id="state"]').text(data.state);
          $('[id="city"]').text(data.city);
          $('[id="zipcode"]').text(data.zipcode);
          $('[id="address"]').text(data.address);
          $('[id="description"]').text(data.description);*/
          $('#view_popup').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Product'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error Retrieving Data From Database');
        }
      });
    }
  <?php endif; ?>
  <?php if(check_permission_status('Product','delete_u')==true): ?>
    function delete_entry(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?= site_url('product_manager/delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    table.ajax.reload();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }
  <?php endif; ?>
  function getfilterdData(e,g){

      var id = "#" + g;
      $(id).val(e);

      table.ajax.reload();
  }
  </script>


  <script>
  $(document).ready(function(){
  <?php if(check_permission_status('Product','delete_u')==true): ?>
    $('#delete_all').click(function(){
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
  <?php endif; ?>
  });
  
  $("#confirmed").click(function(){
    deleteBulkItem('product_manager/delete_bulk'); 
  });
  function refreshPage(){
        window.location.reload();
  } 

  </script>




  <script>
  function showAction(id) {
      var checkbox = $('input[value="' + id + '"].delete_checkbox');
  
      if (checkbox.is(':checked')) {
          // Update the href dynamically with the selected product ID
          var newUrl = '<?php echo base_url(); ?>inventory-form/' + id;
          $('#mass_id').val(id);
          // Set the new link
          $('#product_Link').attr('href', newUrl);
  
          // Show the button
        
          $('#pro_update').show();
          $('#mass_product').show();
      } else {
          // Hide the button if unchecked
          $('#pro_update').hide();
          $('#mass_product').hide();
          
      }
  }

  $("#mass_model").click(function(){
        $('#mass_product_model').modal('show')
  });
  </script>






<script>
  const typesRequiringLength = ['product_name','sku','hsn_code','product_category','income_account',
   'product_description', 'product_unit_price', 'product_quantity', 'stock_alert'];

  document.addEventListener('change', function (e) {
    if (e.target.matches('.type-select')) {
      
      
      const selectedType = e.target.value.trim().toLowerCase();
      const wrapper = e.target.closest('.form-row');

      const lengthWrapper = wrapper.querySelector('.length-wrapper');
      const dummytextWrapper = wrapper.querySelector('.dummytext');

      const input = wrapper.querySelector('.length-input');

      const income_accountSelect = wrapper.querySelector('.income_account-select'); 
      const product_categorySelect = wrapper.querySelector('.product_category-select'); 


      if (typesRequiringLength.includes(selectedType)) {
        lengthWrapper.style.display = 'block';
        dummytextWrapper.style.display = 'none';

        // Hide all first
        input.style.display = 'none';
        product_categorySelect.style.display = 'none';
        income_accountSelect.style.display = 'none';

        // Show appropriate one 
        if (selectedType === 'product_category') {
          product_categorySelect.style.display = 'block';
        }else if (selectedType === 'income_account') {
          income_accountSelect.style.display = 'block';
        }else {
          input.style.display = 'block';
          input.placeholder = 'Enter value';
        }
      } else {
        lengthWrapper.style.display = 'none';
        input.value = '';
      }
    }
  });

  $('#massUpdateBtn').click(function (event) {
    event.preventDefault();

    // Get selected type
    var selectedType = $('#mass_name').val();
    var finalValue = '';

    // Decide which input to pick from 
    if (selectedType === 'product_category') {
      finalValue = $('#product_category_select').val();
    }else if (selectedType === 'income_account') {
      finalValue = $('#income_account_select').val();
    }else {
      finalValue = $('#value_input').val();
    }

    // Set hidden field
    $('#final_value_input').val(finalValue);

    // Submit via AJAX
    var formData = $('#massForm').serialize();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('product_manager/add_mass'); ?>",
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          alert(response.message);
          $('#mass_product_model').modal('hide');
           window.location.reload();
        } else {
          alert(response.message);
          window.location.reload();
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        alert('An error occurred while processing your request.');
      }
    });
  });
</script>



