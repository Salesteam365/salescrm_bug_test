<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Find_duplicate extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Find_duplicate_modal','Find_duplicate');
  }
  public function index()
  {
    if(!empty($this->session->userdata('email')))
    { 
      $list['table'] = $this->Find_duplicate->getTable();
      $this->load->view('essentials/find-duplicate',$list);
    }
    else
    {
      redirect('login');
    }
  }
  
  public function find_row_data(){
	$tblName	= $this->input->post('tblName');
	
    $clmnName	= explode(":",$this->input->post('clmnName'));  
    $clumvalue  = str_replace("<=>","&",$this->input->post('value'));
    
   
    
    $value		= explode(":",$clumvalue);
   
    $list 		= $this->Find_duplicate->find_data($tblName,$clmnName,$value);
    
	
?>
	<table id="dt-multi-checkbox" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
        <thead>
            <tr>
			<?php for($i=0; $i<count($clmnName); $i++){?>
                <th class="th-sm"><?=$clmnName[$i];?></th>
			<?php } ?>
                <th class="th-sm">Owner</th>
                <th class="th-sm">Created Date</th>
                <th class="th-sm">Action</th>
            </tr>
        </thead>
        <tbody>
		<?php foreach($list as $row){  ?>
            <tr>
			<?php for($i=0; $i<count($clmnName); $i++){?>
                <td><?=$row[$clmnName[$i]];?></td>
			<?php } ?>
			<td>
			<?php if($tblName=="lead"){ echo $row['lead_owner']; }else{ if(isset($row['owner'])){ echo $row['owner']; } } ?></td>
			<td><?php  
			$date=date_create($row['currentdate']);
			echo date_format($date,"d M Y");
			 ?></td>
			<td>
				<button class="btn btn-danger" onClick="delete_entry('<?=$tblName;?>','<?=$row['id'];?>','<?=$this->input->post('clmnName');?>','<?=$this->input->post('value');?>');" >
					<i class="far fa-trash-alt"></i></button>
					<!--<button class="btn btn-success" onClick="view_details('<?=$tblName;?>','<?=$row['id'];?>');" >
					<i class="far fa-eye"></i></button>
					<button class="btn btn-primary" onClick="edit_data('<?=$tblName;?>','<?=$row['id'];?>');" >
					<i class="far fa-edit"></i></button>-->
				</td>
            </tr>
		<?php } ?>
        </tbody>
	  </table>
	  <?php 	
  }
  
  public function delete_entry(){
	$tblName	= $this->input->post('tblName');
    $rowid		= $this->input->post('rowid'); 
	$delArr=array('delete_status'=>2);
      $list = $this->Find_duplicate->delete_data($tblName,$rowid,$delArr);
	  echo $list;
  }
  
  public function find_duplicate_data()
  { $clmnName=array();
    if(!empty($this->session->userdata('email')))
    { 	
  $tblName	= $this->input->post('tblName');
  $clmnName	= $this->input->post('clmnName');
  //echo  $clmnName; exit;
  if($tblName!="" && !empty($clmnName)){
      $list = $this->Find_duplicate->find_duplicate_data($tblName,$clmnName);
	  //print_r($list);
	  ?>
	  <button class="btn btn-info"><?=count($list);?></button>
	  <table id="dt-multi-checkbox" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
        <thead>
            <tr>
			<?php for($i=0; $i<count($clmnName); $i++){?>
                <th class="th-sm"><?=$clmnName[$i];?></th>
			<?php } ?>
                <th class="th-sm">Total Duplicate Row</th>
                <th class="th-sm">Action</th>
            </tr>
        </thead>
        <tbody>
		<?php foreach($list as $row){ ?>
            <tr>
			<?php for($i=0; $i<count($clmnName); $i++){?>
                <td><?=$row[$clmnName[$i]];?></td>
			<?php } 
			$impData=implode(':',$row);
			$impData=str_replace('&',"<=>",$impData);
			?>
                <td><?=$row['COUNT(*)'];?></td>
                <td><a href="#" onClick="getallRow(`<?=implode(':',$clmnName);?>`,`<?=$impData;?>`,`<?=$tblName;?>`);">View All Row</a></td>
            </tr>
		<?php } ?>
        </tbody>
	  </table>
	  <?php 
  }else{ ?>
	  <div style="text-align: center; color: #f95985; font-size: 30px;"><i class="fas fa-exclamation-triangle"></i></div>
	  <div style="text-align: center;">Please Select Module & Field</div>
  <?php }	  
    }
    else
    {
      //redirect('login');
    }
  }
  
  
  
  
  
  
  
  public function getField(){
  $tablename=$this->input->post('tablename');
  $list = $this->Find_duplicate->getField($tablename);
 ?>
 <select class="form-control" multiple name="clmnName[]" id="clmnName" required>
 <?php
  foreach($list as $tablesFL){ 
	if($tablesFL->name!='id' && $tablesFL->name!="session_company" && $tablesFL->name!="session_comp_email" && $tablesFL->name!='ip'){
  ?>
	<option value="<?=$tablesFL->name;?>"><?=ucwords(str_replace("_"," ",$tablesFL->name));?></option>
  <?php }  } ?>
	</select>
<script src="<?= base_url();?>assets/js/filter-multi-select-bundle.min.js"></script>
<script>
      // Use the plugin once the DOM has been loaded.
      $(function () {
        // Apply the plugin 
        var userName = $('#clmnName').filterMultiSelect();
        $('#form').on('keypress keyup', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            return false;
          }
        });
      });
    </script>
 <?php }
  
// Please write code above this  
}
?>
