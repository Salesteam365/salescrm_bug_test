
<!--common header include -->
<?php $this->load->view('common_navbar');?>
 <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.signature.css">
   <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.betterdropdown.css">
 <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
 
<!-- common header include -->
<style>


.error-popup-msg-for-user ol li {
    margin-bottom: 10px;
    color: red;
}
.error-popup-msg-for-user p {
    color: red;
    margin-bottom: 10px;
}
.error-popup-msg-for-user ol {
    list-style: revert;
    padding: 0 15px;
    margin: 0;
}
.error-popup-msg-for-user {
    border: 1px solid #ff0f0f;
    background: #ff00000d;
    padding: 15px;
}

.pro_descrption{ display:none; } .delIcn{color: #ef8d91; margin-right: 7px;} 
      .addIcn{color: #709870; margin-right: 7px;} #putExtraVl{ width:100%;}
      .inrIcn{padding-top: 6px; text-align: right; height: calc(2.25rem + 2px); }
      .inrRp{padding-top: 6px;   height: calc(2.25rem + 2px); }
      .dropdown-box-wrapper, .result, .filter-box { height: calc(2.25rem + 2px); display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: transparent;
    background-clip: padding-box;
    border:0;
    border-bottom: 1px solid #ced4da;
    border-radius: .25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; }
    .form-proforma .row {
	background: #f8faff;
	padding: 15px;
	margin: 0;
	}
	.form-proforma {
	background: #ffffff;
	padding: 0;
	}
	.form-footer-section .container {
	background: #f8faff;
	padding: 20px;
	}
	.form-footer-section {
	background: #ffffff;
	padding: 0;
	}
	.contact_details .container {
	background: #f8faff;
	padding: 15px;
	}
	.contact_details {
	padding: 0;
	background-color: #ffffff;
	}
  .linkscontainer{
        width:20vw;
        padding:20px;
        padding-top:50px;
        border-radius:10px;
        box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
        margin:20px auto;
        margin-bottom:50px;
        
        }


#btnSave {
  background-color: initial;
  background-image: linear-gradient(#8614f8 0, #760be0 100%);
  border-radius: 5px;
  border-style: none;
  box-shadow: rgba(245, 244, 247, .25) 0 1px 1px inset;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  font-family: Inter, sans-serif;
  font-size: 16px;
  font-weight: 500;
  height: 40px;
  line-height: 20px;
  margin-left: -4px;
  outline: 0;
  text-align: center;
  transition: all .3s cubic-bezier(.05, .03, .35, 1);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: bottom;
  width: 160px;
}

#btnSave:hover {
  opacity: .7;
}

@media screen and (max-width: 1000px) {
  #btnSave {
    font-size: 14px;
    height: 55px;
    line-height: 55px;
    width: 150px;
  }
}
@media screen and (max-width: 576px) {
.linkscontainer {
 width: 100vw;
}
}
</style>


<div class="content-wrapper">

<?php if($this->session->userdata('account_type')=="Trial" && $countLead>=1000){ ?>

<?php }else{ ?>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 offset-sm-1">
          <!--<h1 class="m-0 text-dark text-right" style="-webkit-text-fill-color: unset;">Create Table</h1>-->
        </div>
        <!-- /.col -->
        <div class="col-sm-5">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url()." home "; ?>">Home</a> </li>
             <li class="breadcrumb-item">
                 <a href="<?php echo base_url()."create_list "; ?>">Table</a>
            </li>
            <li class="breadcrumb-item active">Create table</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  
         <a href="<?= base_url('create_tbl') ?>" style="text-decoration: none;">
          <div class="linkscontainer" 
               style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 40vh;">
            
            <!-- Image -->
            <img width="84" height="84" 
                 src="https://img.icons8.com/windows/64/table-1.png" 
                 alt="table icon"
                 style="margin-bottom: 15px;">
            
            <!-- Button -->
            <button style="
              font-size: 24px; 
              padding: 10px 20px; 
              border: none; 
              border-radius: 6px; 
              cursor: pointer;">
              Create Tables In DB
            </button>
        
          </div>
        </a>

<?php } ?>
  <!-- /.content-header -->
</div>
<!-- common footer include -->
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<?php $this->load->view('commonAddorg_modal');?>
<?php $this->load->view('product_onkeyup');?> 



