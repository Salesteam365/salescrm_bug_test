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

#dt-multi-checkbox tbody tr td:nth-child(3) {
   
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
            <h1 class="m-0 text-dark">State List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">State</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <div class="card-body" id="countSearch">
			  <form method="post" action="" >
                  <div class="row">
                      
                       
                       
					  
					  <div class="col-sm-8 form-group text-right">
							  
					 </div>
                    <div class="clearfix"></div>
						  
							  
                      
                  </div>
                </form>
                <table id="dt-multi-checkbox" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                    <thead>
                        <tr>                     
                            <th class="th-sm">#</th>
                            <th class="th-sm">State Name</th>
                            <th class="th-sm">Country</th>
                            <th class="th-sm">TIN</th>
                        </tr>
                    </thead>
                    <tbody>         
                    </tbody>
                </table>
              </div>
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
<?php $this->load->view('common_footer');?>
<script type="text/javascript">
var save_method; //for save method string
var table;

    table = $('#dt-multi-checkbox').DataTable({
        "processing": true, 
        "serverSide": true, 
		"searching": true,
        "order": [], 
        "ajax": {
            url: "<?php echo site_url('setting/ajax_list_state')?>",
            type: "POST",
			dataType : "JSON",
            data : function(data)
             {
                data.searchDate = $('#date_filter').val();
				
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
</script>

