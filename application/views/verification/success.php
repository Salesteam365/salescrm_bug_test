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
.thank-you-pop h3.cupon-pop {
    font-size: 16px;
    margin-bottom: 0;
    color: #383f4e;
    display: inline-block;
    text-align: left;
    padding: 14px 20px;
    border: 1px dashed #222;
    clear: both;
    letter-spacing: .5px;
}
.thank-you-pop h3.cupon-pop table tbody tr {
    vertical-align: sub;
}
.thank-you-pop h3.cupon-pop span {
    color: #383f4e;
    font-size: 16px;
    margin-bottom: 10px;
    display: block;
    margin-left: 10px;
}
.thank-you-pop a{
	display: inline-block;
    margin: 0 auto;
    padding: 9px 20px;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    background-color: #8BC34A;
    border-radius: 17px;
}
.thank-you-pop a i{
	margin-right:5px;
	color:#fff;
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
						    <i class="far fa-check-circle" style="font-size: 115px; color: #4caf50;"></i>
							<h1 style="color: #4caf50; margin-top: 2%;">Thank You!</h1>
							<p>Your payment has been completed successfully.</p>
							
							<h3 class="cupon-pop">
							    <?php foreach($successDt as $row){ ?>
							    <table>
                                <tr>
                                    <td>Order ID</td>
                                    <td>:&nbsp;</td>
                                    <td><span><?=$row->order_id;?></span></td>
                                </tr>
                           
                                <tr>
                                    <td>Amount</td>
                                    <td>:&nbsp;</td>
                                    <td><span>INR <?=$row->final_price;?>/-</span></td>
                                </tr>
                                <tr>
                                    <td>Paymnet Type</td>
                                    <td>:&nbsp;</td>
                                    <td><span><?=$row->payment_method;?></span></td>
                                </tr>
                                <tr>
                                    <td>Total License</td>
                                    <td>:&nbsp;</td>
                                    <td><span><?=$row->total_licence;?></span></td>
                                </tr>
                                <tr>
                                    <td>License Type</td>
                                    <td>:&nbsp;</td>
                                    <td><span><?=$planlist['plan_name'];?></span></td>
                                </tr>
                                <tr>
                                    <td>Subscription</td>
                                    <td>:&nbsp;</td>
                                    <td><span><?=$row->licence_duration;?></span></td>
                                </tr>
                                <tr>
                                    <td>Transaction Date</td>
                                    <td>:&nbsp;</td>
                                    <td><span><?=$row->currentdate;?></span></td>
                                </tr>
                        </table>
							        
							    <?php } ?>
							</h3>
							
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