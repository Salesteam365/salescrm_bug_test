<?php $this->load->view('common_navbar');?>

<style>
.thank-you-pop{
	width:100%;
 	padding:20px;
	text-align:center;
}


.thank-you-pop h1{
	font-size: 42px;
    margin-bottom: 25px;
	color:#5C5C5C;
}
.thank-you-pop p{
	font-size: 20px;
    margin-bottom: 27px;
 	color:#5C5C5C;
}
.thank-you-pop h3.cupon-pop{
	font-size: 25px;
    margin-bottom: 40px;
	color:#222;
	display:inline-block;
	text-align:left;
	padding:10px 20px;
	border:2px dashed #222;
	clear:both;
	font-weight:normal;
}
.thank-you-pop h3.cupon-pop span{
	color:#03A9F4;
}

</style>
  <div class="content-wrapper" style="min-height: 191px;">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Upgrade Your Plan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>home">Home</a></li>
              <li class="breadcrumb-item active">Upgrade Plan</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
            <div class="card org_div">
              <div class="card-body">
				<div class="row">
                  <div class="col-md-12">
                      
						<div class="thank-you-pop">
						    <i class="far fa-times-circle" style="font-size: 115px; color: #ffaf95;"></i>
							<h1 style="color: #ffaf95; margin-top: 2%;">Oh no, Your payment failed</h1>
							<p><a href="<?=base_url();?>upgrade-plan">Click here </a> to try again.</p>
							
 						</div>
 					
				  </div>
				  
				</div>
				  
              </div>
            </div>
        </div>
      </section>
  </div>
 <?php $this->load->view('footer');?>
</div>
<?php $this->load->view('common_footer');?>