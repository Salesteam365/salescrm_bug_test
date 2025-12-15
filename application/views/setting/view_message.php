<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Mail Message</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>home">Home</a></li>
              <li class="breadcrumb-item active">Mail Message</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row mb-3">
          <div class="col-lg-2">
            <div class="first-one">
              <!-- <select class="form-control">
              <option selected disabled>Select Date</option>
              <option>Last 15 days</option>
              <option>Last 30 days</option>
              <option>Last 45 days</option>
              <option>Last 60 days</option>
              <option>Last 75 days</option>
              <option>Last 100 days</option>
            </select> -->
            </div>
          </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-6">
              <!--<div class="refresh_button float-right">
                  <button class="btn btn-info btn-sm" onclick="reload_table()"><i class="fas fa-redo-alt"></i></button>
                  <!-- <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#quotation_newpopup">Assign </button> 
                  <button class="btn btn-info btn-sm check_user" data-toggle="modal" data-target="#add_user_popup">Add User</button>
              </div>-->
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
                <?php 	$id = $this->uri->segment(3); ?>
                 <iframe src="https://allegient.team365.io/mail_details/mail_message_iframe/<?=$id;?>?inbx=<?=$_GET['inbx'];?>" style="width:100%; height:500px; border: none;"></iframe>
                
              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<div style="text-align:center" id="show_msgs"></div>
  
  
</div>
<!-- ./wrapper -->
<?php $this->load->view('footer');?>
<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<script>
  var table;
$(document).ready(function () {
  table = $('#ajax_datatable').DataTable({
       /* "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?= base_url('mail_details/ajax_label_table')?>",
            "type": "POST",
            "data" : function(data)
             {
                data.searchDate = $('#date_filter').val();
             }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [-1], //last column
            "orderable": false, //set not orderable
        },
        ],*/
    });
    
    $('#date_filter').change(function(){
      table.ajax.reload();
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
    $('#delete_all').click(function(){
      var checkbox = $('.delete_checkbox:checked');
      if(checkbox.length > 0)
      {
        var checkbox_value = [];
       $(checkbox).each(function(){
        checkbox_value.push($(this).val());
       });
       $.ajax({
        url:"<?= base_url('home/delete_bulk')?>",
        method:"POST",
        data:{checkbox_value:checkbox_value},
        success:function()
        {
          $('.removeRow').fadeOut();
          reload_table();
        }
       })
      }
      else
      {
       alert('Select atleast one records');
      }
   });
});
     function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax
    }
</script>