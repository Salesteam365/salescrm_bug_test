<footer class="main-footer">
    <strong>Copyright &copy; 2014-<?php echo date('Y'); ?> <a href="http://www.allegientservices.com/" target="_blank">Allegient Services</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 365.2.4
    </div>
  </footer>


<!-- The alert modal -->
<div class="modal fade" id="alert_popup" style="z-index:99999">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
<!--         <h4 class="modal-title">Modal Heading</h4> -->
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p id="common_popupmsg"><i class="fas fa-check-square"></i>Payment Option Is Now Enabled</p>
      </div>
    </div>
  </div>
</div>
<!-- The alert modal -->



<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- jQuery UI 1.11.4 -->
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Bootstrap 4 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()."assets/"; ?>plugins/chart.js/Chart.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url()."assets/"; ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url()."assets/"; ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url()."assets/"; ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url()."assets/"; ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url()."assets/"; ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()."assets/"; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()."assets/"; ?>js/team.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo DASHBOARD_JS; ?>"></script>
<script src="<?php //echo COMMON_PAGE_JS; ?>"></script>
<script src="<?php echo base_url('assets/js/validation.js') ?>"></script>
<!-- datatable js -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<script type="text/javascript"> 
      $(function(){
    setTimeout(function(){
        $("#hideDiv").hide();
		<?php 
		$this->session->unset_userdata("success_msg");
     	$this->session->unset_userdata("error_msg");
         ?>		
        }, 3000);
      });
    </script>
