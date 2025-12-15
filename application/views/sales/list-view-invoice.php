<?php $this->load->view('common_navbar');?>
<style>
  #btnshowhide{
    color:grey; 
    border-color:lightgrey;
    cursor:pointer;
    float:right;
    height:30px;
    
    line-height:10px;
}
#btnshowhide:hover{
  background:rgba(230,242,255,0.4);
}
#dt-multi-checkbox thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   padding-top:18px;
  padding-bottom:18px;
  

}


#dt-multi-checkbox tbody tr td {
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
div.refresh_button button.btnstopcorner {
    border: 1px solid #ccc; /* Light grey border on hover */
    border-radius: 4px;
    background: white;
    color: rgba(30, 0, 75);
  }

  div.refresh_button button.btnstopcorner:hover {
    background:lightgrey;
    border: 1px solid #ccc; /* Light grey border on hover */
  }
 
  

 
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);overflow-x:clip;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Invoices</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Invoices</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->


        <div class="container-fliud filterbtncon"  >

            <div class="row mb-3">

                    <div class="col-lg-2">
                      <div class="first-one custom-dropdown dropdown">
                          <button class="custom-select bt dropdown" type="button" id="dropdownMenuButtondate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Select Option
                          </button>
                          <input type="hidden" id="date_filter" value="" name="date_filter">
                          <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtondate">
                              <li data-value="This Week">This Week</li>
                              <?php $week = strtotime("-7 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $week); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$week); ?>');">Last Week</li>
                              <?php $fifteen = strtotime("-15 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $fifteen); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$fifteen); ?>');">Last 15 days</li>
                              <?php $thirty = strtotime("-30 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $thirty); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$thirty); ?>');">Last 30 days</li>
                              <?php $fortyfive = strtotime("-45 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $fortyfive); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$fortyfive); ?>');">Last 45 days</li>
                              <?php $sixty = strtotime("-60 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $sixty); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$sixty); ?>');">Last 60 days</li>
                              <?php $ninty = strtotime("-90 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $ninty); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$ninty); ?>');">Last 3 Months</li>
                              <?php $six_month = strtotime("-180 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $six_month); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$six_month); ?>');">Last 6 Months</li>
                              <?php $one_year = strtotime("-365 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $one_year); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$one_year); ?>');">Last 1 Year</li>
                          </ul>
                      </div>
                    </div>

                      <div class="col-lg-3">
                        <?php if($this->session->userdata('type')==='admin'): ?>
                            <div class="first-one custom-dropdown dropdown">
                                <button class="custom-select bt dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Option
                                </button>
                                <input type="hidden" id="user_filter" value="" name="user_filter">
                                <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <option selected value="">Select User</option>
                                    <?php foreach($admin as $adminDtl): ?>
                                        <li data-value="<?= $adminDtl['admin_email']; ?>" onclick="setSelectedOption(this);"><?php echo $adminDtl['admin_name']; ?></li>
                                    <?php endforeach; ?>
                                    <?php foreach($user as $userDtl): ?>
                                        <li data-value="<?= $userDtl['standard_email']; ?>" onclick="setSelectedOption(this);"><?php echo $userDtl['standard_name']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                      </div>


                        <div class="col-lg-1"></div>

                        <div class="col-lg-6">
                          <div class="refresh_button float-right">
                            <!-- <button class="btnstopcorner" onclick="listgrdvw('listview','gridview')"><i class="fas fa-list-ul"></i></button>
                            <button class="btnstopcorner" onclick="listgrdvw('gridview','listview','grid')"><i class="fas fa-th"></i></button> -->
                            <button class="btn btnstopcorner" type="button" onclick="reload_table()"><i class="fas fa-redo-alt"></i></button>

                            <?php if($this->session->userdata('type')=='admin'){ ?>
                            <a href='Export_data/export_invoice' class="p-0" ><button class="btn btncorner">Export Data</button></a>
                            <?php } ?>

                            <?php if(check_permission_status('Invoice','create_u')==true){ ?>
                            <button class="btn btnstopcorner add_button check_invoice"><a href="javascript:void(0);" style="color:black;">Create New Invoice</a></button>
                            <?php } ?>
                          </div>
                        </div>


            </div><!-- /.container-fluid -->
        </div>
        
                
           

                <div class="container-fluid pr-0">
                  <div class="row">
                      <div class="col-12">
                        <!-- <button type="button" id="btnshowhide" class="btn btn-outline-secondary mb-2" data-toggle="modal" data-target="#exampleModal" style="">
                        <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                          Show/Hide Columns</button> -->
                      </div>
                    </div>
                </div>


          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Column visibility</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                              <div class="modal-body">
                                  <table class="table table-striped">
                                      <thead style="background:rgba(60,60,170)">
                                        <tr>
                                          <th>Columns</th>
                                          <th>Visibility</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                          
                                          <tr>
                                            <td>Invoice</td>
                                            <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                          </tr>
                                          <tr>
                                          <td>Customer Name</td>
                                            <td align="center"><input class="inputbox" type="checkbox" checked  ></td>
                                          </tr>
                                          <tr>
                                          <td>Total Amount</td>
                                            <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                          </tr>
                                          <tr>
                                          <td>Status</td>
                                            <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                          </tr>
                                          <tr>
                                          <td>Date</td>
                                            <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                          </tr>
                                          <tr>
                                          <td>Action</td>
                                            <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                          </tr>
                                        
                                      </tbody>
                                  </table>
                                </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="savecolvis">Save changes</button>
                      </div>
                  </div>
              </div>
          </div>
          
          <div class="wrapper card p-4" style="border-radius:12px;border:none;box-shadow:0px;">
            <div class="card-header mb-2"><b style="font-size:21px;">Invoices</b> <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button></div>
                <table id="dt-multi-checkbox" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                    <thead>
                        <tr>                     
                            <th class="th-sm">Invoice#</th>
                            <th class="th-sm">Customer Name</th>
                            <th class="th-sm">Total Amount</th>
                            <th class="th-sm">Status</th>
                            <th class="th-sm">Date</th>
                            <th class="th-sm">Action</th>
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
</div>
<!-- ./wrapper -->
<?php $this->load->view('footer');?>
<!-- common footer include -->
<?php $this->load->view('common_footer');?>

<script type="text/javascript">
var save_method; //for save method string
var table;
    $(document).ready(function() {

        table = $('#dt-multi-checkbox').DataTable({
          "processing": true, 
          "serverSide": true, 
          "searching": true,
          "order": [], 
          "ajax": {
              url: "<?php echo site_url('invoices/ajax_list')?>",
              type: "POST",
              dataType : "JSON",
              data : function(data)
        
              {
                  data.searchDate = $('#date_filter').val();
                  data.searchUser = $('#user_filter').val();
                  data.firstDate  = $('#stage_filter').val();
                  // data.secondDate = $('#secondDate').val();
          
              }
          },
          //Set column definition initialisation properties.
          "columnDefs": [
          {
              "targets": [ 0 ], //last column
              "orderable": false, //set not orderable
          },
          ]
       });
      
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


    function setSelectedOptiondate(dateValue) {
      var button = document.getElementById("dropdownMenuButtondate");
      var selectedText = ""; 
      switch (dateValue) {
          case "<?= date('Y-m-d', $week); ?>":
              selectedText = "Last Week";
              break;
          case "<?= date('Y-m-d', $fifteen); ?>":
              selectedText = "Last 15 days";
              break;
          case "<?= date('Y-m-d', $thirty); ?>":
              selectedText = "Last 30 days";
              break;
          case "<?= date('Y-m-d', $fortyfive); ?>":
              selectedText = "Last 45 days";
              break;

          case "<?= date('Y-m-d', $sixty); ?>":
              selectedText = "Last 60 days";
              break;

          case "<?= date('Y-m-d', $ninty); ?>":
              selectedText = "Last 3 Months";
              break;

          case "<?= date('Y-m-d', $six_month); ?>":
              selectedText = "Last 6 Months";
              break;
              
          case "<?= date('Y-m-d', $one_year); ?>":
              selectedText = "Last 1 year";
              break;
          // Add cases for other date options as needed
          default:
              selectedText = dateValue; 
              break;
          }
      button.textContent = selectedText; 
      document.getElementById("date_filter").value = dateValue;

      // Reload table data
      getfilterdData(dateValue, 'getsovalue', 'date_filter');
    }

    function setSelectedOption(option) {
        var selectedText = option.textContent;
        var button = document.getElementById("dropdownMenuButton");
        button.textContent = selectedText;

        var selectedValue = option.getAttribute("data-value");
        document.getElementById("user_filter").value = selectedValue;

        // Close the dropdown
        var dropdownMenu = document.querySelector('.dropdown-menu');
        dropdownMenu.classList.remove('show');

        // Reload table data
        getfilterdData(selectedValue, 'user_filter');
    }

    function getfilterdData(e, f, g) {
      
      var id = "#" + g;
      $(id).val(e);
      if (typeof window[f] === "function") {
          window[f]();
      }
      table.ajax.reload();
   }
  
     function disableClick(e) {
          e.stopPropagation();
          e.preventDefault();
      }


      $('#date_filter').change(function(){
        var search    = $("#searchRecord").val();
      var date_filter = $("#date_filter").val();
      getDataGrid(date_filter,search,1);
      load_country_data(1,date_filter);
      table.ajax.reload();
    });
  
  $('#user_filter,#stage_filter').change(function(){
      table.ajax.reload();
    });


    function listgrdvw(dispid,idhide,grid=''){
  if(grid=='grid'){
    $("#user_filter").hide();
    $("#stage_filter").hide();
  }else{
    $("#user_filter").show();
    $("#stage_filter").show();
  }
  $('#'+idhide).hide();
  $('#'+dispid).show();
}

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax
    }
    //delete proforma invoice
    function delete_invoice(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?= site_url('invoices/delete_pi')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
          $("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Invoice information has been deleted.');				
          $("#alert_popup").modal('show');
          setTimeout(function(){ $("#alert_popup").modal('hide'); reload_table();  },2000);
                    //if success reload ajax table
                  //alert('PI delete sucessfully');
                    //reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
          $("#common_popupmsg").html('<i class="fa fa-exclamation-triangle" style="color: red;"></i><br>Error deleting data!');				
          $("#alert_popup").modal('show');
          setTimeout(function(){ $("#alert_popup").modal('hide'); },2000);
                    //alert('Error deleting data');
                }
            });
        }
    }

    $('.check_invoice').click(function(){
      $.ajax({
        url : "<?= base_url('invoices/checkInvoicetotal'); ?>",
        type: "POST",
        data: "",
        dataType: "JSON",
        success: function(data){
        //	alert(data);
          //console.log(data);
          if(data.status == 200){
              $('.check_invoice').attr('disabled',false); 
            window.location.href = "<?=base_url('invoices/new-invoice'); ?>";
            
          }else if(data.status == 201){
              
            $(".putappend_msg").html('You can generate only '+data.totalinvoices+' invoices in a month .To generate more invoices upgrade now');
            $("#addModal").modal('show');
            //setTimeout(function(){ $("#alert_popup").modal('hide');  },2000);
            //$("#show_msgs").html(data.show_msg);
            $('.check_invoice').attr('disabled',true);
          }
          
          
          }
        });
        
        });	

</script>
