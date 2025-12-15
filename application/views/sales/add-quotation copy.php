<!--common header include -->
<?php $this->load->view('common_navbar'); ?>
<!-- common header include -->
<style>
   .pro_descrption {
      display: none;
   }

   .delIcn {
      color: #ef8d91;
      margin-right: 7px;
   }

   .addIcn {
      color: #709870;
      margin-right: 7px;
   }

   #putExtraVl {
      width: 100%;
   }

   .inrIcn {
      padding-top: 6px;
      text-align: right;
      height: calc(2.25rem + 2px);
   }

   .inrRp {
      padding-top: 6px;
      height: calc(2.25rem + 2px);
   }

   .dropdown-box-wrapper,
   .result,
   .filter-box {
      height: calc(2.25rem + 2px);
      display: block;
      width: 100%;
      height: calc(2.25rem + 2px);
      padding: .375rem .75rem;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #495057;
      background-color: transparent;
      background-clip: padding-box;
      border: 0;
      border-bottom: 1px solid #ced4da;
      border-radius: .25rem;
      box-shadow: inset 0 0 0 transparent;
      transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
   }

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
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <?php
   if ($this->session->userdata('account_type') == "Trial" && $countQuote >= 1000) {
   ?>
      <div class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-md-12 mb-3 mt-5 text-center">
                  <i class="fas fa-exclamation-triangle" style="color: #f59393; font-size: 28px;"></i>
               </div>
               <div class="col-md-12 mb-3 text-center">
                  You are now using trial account.<br>
                  <text>You are exceeded your quotation limit - 500</text>
                  <br>
                  <text>You can add only 500 quotation on trial account</text>
                  <br>
                  Please upgrade your plan to click bellow button.
               </div>
               <div class="col-md-12 mb-3 text-center">
                  <a href="https://team365.io/pricing"><button class="btn btn-info">Buy Now</button></a>
               </div>
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container-fluid -->
      </div>
   <?php } else { ?>
      <!-- Content Header (Page header) -->
      <div class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-sm-6">
                  <h1 class="m-0 text-dark text-right" style="-webkit-text-fill-color: unset;"><?php if (isset($action['data']) && $action['data'] == 'update') {
                                                                                                   echo "Update";
                                                                                                } else {
                                                                                                   echo "Add";
                                                                                                } ?> Quote Form</h1>
               </div>
               <!-- /.col -->
               <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item">
                        <a href="<?php echo base_url() . " home "; ?>">Home</a>
                     </li>
                     <li class="breadcrumb-item">
                        <a href="<?php echo base_url() . "quotation "; ?>">Quotation</a>
                     </li>
                     <li class="breadcrumb-item active"><?php if (isset($action['data']) && $action['data'] == 'update') {
                                                            echo "Update";
                                                         } else {
                                                            echo "Add";
                                                         } ?> Quotation</li>
                  </ol>
               </div>
               <!-- /.col -->
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container-fluid -->
      </div>
      <form class="form-horizontal" id="form" method="post" enctype="multipart/form-data">
         <div class="form-proforma">
            <div class="container">
               <div class="row">
                  <input type="hidden" name="save_method" id="save_method" value="<?php if (isset($action['data']) && $action['data'] == 'update') {
                                                                                       echo 'Update';
                                                                                    } else {
                                                                                       echo "add";
                                                                                    }  ?>">
                  <input type="hidden" name="id" id="id" value="<?php if (isset($record['id']) &&  $action['from'] == 'quotation') {
                                                                     echo $record['id'];
                                                                  }  ?>">
                  <input type="hidden" name="lead_id" id="lead_id" value="<?php if (isset($record['id']) && $action['from'] == 'opportunity') {
                                                                              echo $record['id'];
                                                                           }  ?>">
                  <input type="hidden" name="lead_id_uri" id="lead_id_uri" value="<?php if (!empty($this->uri->segment(2))) {
                                                                                       echo $this->uri->segment(2);
                                                                                    } ?>">
                  <input id="lead_test_val" name="total_percent" type="hidden" value="<?php if (isset($record['total_percent'])) {
                                                                                          echo $record['total_percent'];
                                                                                       } else {
                                                                                          echo "100.00";
                                                                                       }  ?>">
                  <input type="hidden" class="put_org_id" name="org_id_act" id="org_id_act" value="<?php if (isset($record['org_id'])) {
                                                                                                      echo $record['org_id'];
                                                                                                   }  ?>">
                  <input type="hidden" class="put_cnt_id" name="cnt_id_act" id="cnt_id_act" value="<?php if (isset($record['cont_id'])) {
                                                                                                      echo $record['cont_id'];
                                                                                                   }  ?>">
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label for="">Opportuntiy ID #:</label>
                        <input type="text" class="form-control " name="opportunity_id" id="opportunity_id" value="<?php if (isset($record['opportunity_id'])) {
                                                                                                                     echo $record['opportunity_id'];
                                                                                                                  }  ?>" placeholder="Opportuntiy ID">
                        <span id="name_error"></span>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label for="">Quote Owner<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" name="owner" placeholder="Quote Owner" value="<?php if (isset($record['owner'])) {
                                                                                                                  echo $record['owner'];
                                                                                                               } else {
                                                                                                                  echo $this->session->userdata('name');
                                                                                                               } ?>" readonly>
                        <span id="invoice_no_error"></span>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <?php
                     if (isset($record['name'])) {
                        $oppName = $record['name'];
                     } else if (isset($record['opp_name'])) {
                        $oppName = $record['opp_name'];
                     } else {
                        $oppName = '';
                     }
                     ?>
                     <div class="form-group">
                        <label for="">Opportuntiy Name<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control checkvl" name="opp_name" id="opp_name" value="<?php echo $oppName;  ?>" placeholder="Opportuntiy Name">
                        <span id="name_error"></span>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label for="">Quote Subject<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control checkvl" name="subject" id="subject" value="<?php if (isset($record['subject'])) {
                                                                                                               echo $record['subject'];
                                                                                                            }  ?>" placeholder="Quote Subject">
                        <span id="name_error"></span>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label for="">Customer Name<span class="text-danger">*</span>:</label>
                        <div class="input-group">
                           <input type="text" class="form-control orgName checkvl" name="org_name" placeholder="Organization Name" id="org_name" required autocomplete="off" value="<?php if (isset($record['org_name'])) {
                                                                                                                                                                                       echo $record['org_name'];
                                                                                                                                                                                    }  ?>">
                           <div class="input-group-append" style="cursor:pointer" onclick="add_formOrg('Customer','form')">
                              <span class="input-group-text" style="border-radius: 0px;"><i class="fas fa-plus-circle"></i></span>
                           </div>
                        </div>
                        <span id="org_name_error"></span>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label for="">Contact Name<span class="text-danger">*</span>:</label>
                        <select class="form-control orgContact checkvl" name="contact_name" id="contact_name" style="width: 496.5px;">
                           <?php if (!isset($record['contact_name'])) {  ?>
                              <option value="" selected="" disabled="">Select Contact Name</option>
                           <?php } ?>
                           <option value="<?php if (isset($record['contact_name'])) {
                                             echo $record['contact_name'];
                                          }  ?>" selected=""><?php if (isset($record['contact_name'])) {
                                                                                                                                          echo $record['contact_name'];
                                                                                                                                       }  ?></option>
                        </select>
                        <span id="invoice_no_error"></span>
                        <div class="input-group-append" style="cursor:pointer" onclick="add_formcontact();">
                           <span class="input-group-text" style="border-radius: 0px;margin-left: 93%;margin-top: -38px;"><i class="fas fa-plus-circle"></i></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label for="">Email Address<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control orgEmail checkvl" name="email" placeholder="Enter Customer Email." id="email" value="<?php if (isset($record['email'])) {
                                                                                                                                                         echo $record['email'];
                                                                                                                                                      }  ?>">
                        <span id="email_error"></span>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <?php
                     if (isset($record['stage'])) {
                        $dataSts = $record['stage'];
                     } else if (isset($record['quote_stage'])) {
                        $dataSts = $record['quote_stage'];
                     } else {
                        $dataSts = '';
                     }  ?>
                     <div class="form-group">
                        <label for="">Quote Stage<span class="text-danger">*</span>:</label>
                        <select class="form-control checkvl" name="quote_stage" id="quote_stage">
                           <option selected value="">Select Quote Stage</option>
                           <option value="Draft" <?php if ($dataSts == 'Draft') {
                                                      echo "selected";
                                                   } ?>>Draft</option>
                           <option value="Negotiation" <?php if ($dataSts == 'Negotiation') {
                                                            echo "selected";
                                                         } ?>>Negotiation</option>
                           <option value="Delivered" <?php if ($dataSts == 'Delivered') {
                                                         echo "selected";
                                                      } ?>>Delivered</option>
                           <option value="On Hold" <?php if ($dataSts == 'On Hold') {
                                                      echo "selected";
                                                   } ?>>On Hold</option>
                           <option value="Confirmed" <?php if ($dataSts == 'Confirmed') {
                                                         echo "selected";
                                                      } ?>>Confirmed</option>
                           <option value="Closed Won" <?php if ($dataSts == 'Closed Won') {
                                                         echo "selected";
                                                      } ?>>Closed Won</option>
                           <option value="Closed Lost" <?php if ($dataSts == 'Closed Lost') {
                                                            echo "selected";
                                                         } ?>>Closed Lost</option>
                        </select>
                        <span id="lead_status_error"></span>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <?php
                     if (isset($record['currentdate'])) {
                        $oppDate = $record['currentdate'];
                     } else {
                        $oppDate = date('Y-m-d');
                     }
                     ?>
                     <div class="form-group">
                        <label for="">Quote Creation Date <span class="text-danger">*</span> :</label>
                        <input type="text" onfocus="(this.type='date')" class="form-control checkvl" id="quotationDate" name="quotationDate" placeholder="Valid Until Date (DD-MM-YYYY)" value="<?php echo $oppDate;  ?>">
                        <span id="invoice_no_error"></span>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <?php
                     if (isset($record['expclose_date'])) {
                        $oppDate = $record['expclose_date'];
                     } else if (isset($record['valid_until'])) {
                        $oppDate = $record['valid_until'];
                     } else {
                        $oppDate = '';
                     }
                     ?>
                     <div class="form-group">
                        <label for="">Valid Until Date <span class="text-danger">*</span> :</label>
                        <input type="text" onfocus="(this.type='date')" class="form-control checkvl" id="valid_until" name="valid_until" placeholder="Valid Until Date (DD-MM-YYYY)" value="<?php echo $oppDate;  ?>">
                        <span id="invoice_no_error"></span>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <?php
                     if (isset($record['carrier'])) {
                        $dataCr = $record['carrier'];
                     } else {
                        $dataCr = '';
                     }
                     $crrArr = array('FedEx', 'UPS', 'USPS', 'DHL', 'BlueDart');
                     ?>
                     <div class="form-group">
                        <label for="">Courier:</label>
                        <select class="form-control" name="carrier" id="carrier">
                           <option value="NA" selected="">Select Courier</option>
                           <?php for ($i = 0; $i < count($crrArr); $i++) { ?>
                              <option value="<?= $crrArr[$i]; ?>" <?php if ($dataCr == $crrArr[$i]) {
                                                                     echo "selected";
                                                                  } ?>><?= $crrArr[$i]; ?></option>
                           <?php } ?>
                           <option value="other" <?php if (!in_array($dataCr, $crrArr) && $action['data'] == 'update') {
                                                      echo "selected";
                                                   } ?>>other</option>
                        </select>
                        <span id="invoice_no_error"></span>
                     </div>
                  </div>
                  <div class="col-lg-6" style="<?php if (!in_array($dataCr, $crrArr) && $action['data'] == 'update') {
                                                } else {
                                                   echo "display:none;";
                                                } ?>" id="dispCourier">
                     <?php
                     if (isset($record['carrier'])) {
                        $dataCr = $record['carrier'];
                     } else {
                        $dataCr = '';
                     }  ?>
                     <div class="form-group">
                        <label for="">Courier Name:</label>
                        <input type="text" class="form-control" name="other_courier_name" id="other_courier_name" value="<?= $dataCr; ?>" placeholder="Enter Courier Name">
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <?php
                     if (isset($record['courier_docket_no'])) {
                        $datadoc = $record['courier_docket_no'];
                     } else {
                        $datadoc = '';
                     }  ?>
                     <div class="form-group">
                        <label for="">Courier Docket Number:</label>
                        <input type="text" class="form-control" name="courier_docket_no" id="courier_docket_no" value="<?= $datadoc; ?>" placeholder="Enter Courier Name">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="billing-section">
            <div class="container">
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <h6>Billing Address</h6>
                  </div>
                  <div class="col-md-5 mb-2">
                     <h6>Shipping Address</h6>
                  </div>
                  <div class="col-md-1 mb-1">
                     <button type="button" class="btn btn-info btn-sm" onclick="copy(this.form)">Copy</button>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                     <?php
                     //print_r($org_dtls);
                     if (isset($record['billing_country']) && $record['billing_country'] != "") {
                        $bCountry = $record['billing_country'];
                     } else if (isset($org_dtls['billing_country']) && $org_dtls['billing_country'] != "") {
                        $bCountry = $org_dtls['billing_country'];
                     } else {
                        $bCountry = '';
                     }
                     if (isset($record['billing_state']) && $record['billing_state'] != "") {
                        $bState = $record['billing_state'];
                     } else if (isset($org_dtls['billing_state']) && $org_dtls['billing_state'] != "") {
                        $bState = $org_dtls['billing_state'];
                     } else {
                        $bState = '';
                     }
                     if (isset($record['billing_city']) && $record['billing_city'] != "") {
                        $bCity = $record['billing_city'];
                     } else if (isset($org_dtls['billing_city']) && $org_dtls['billing_city'] != "") {
                        $bCity = $org_dtls['billing_city'];
                     } else {
                        $bCity = '';
                     }
                     if (isset($record['billing_zipcode']) && $record['billing_zipcode'] != "") {
                        $bZip = $record['billing_zipcode'];
                     } else if (isset($org_dtls['billing_zipcode']) && $org_dtls['billing_zipcode'] != "") {
                        $bZip = $org_dtls['billing_zipcode'];
                     } else {
                        $bZip = '';
                     }
                     if (isset($record['billing_address']) && $record['billing_address'] != "") {
                        $bAddress = $record['billing_address'];
                     } else if (isset($org_dtls['billing_address']) && $org_dtls['billing_address'] != "") {
                        $bAddress = $org_dtls['billing_address'];
                     } else {
                        $bAddress = '';
                     }
                     ?>
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Country<span class="text-danger">*</span>:</label>
                              <input type="text" class="form-control ui-autocomplete-input orgBillingCountry checkvl" name="billing_country" placeholder="Country" id="country" required value="<?= $bCountry; ?>">
                              <input type="hidden" class="form-control country_ids" id="country_ids">
                              <span id="billing_country_error"></span>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">State<span class="text-danger">*</span>:</label>
                              <input type="text" class="form-control ui-autocomplete-input orgBillingState checkvl" name="billing_state" placeholder="State" id="states" autocomplete="off" required value="<?= $bState; ?>">
                              <input type="hidden" class="form-control state_id" id="state_id">
                              <span id="billing_state_error"></span>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">City<span class="text-danger">*</span>:</label>
                              <input type="text" class="form-control ui-autocomplete-input orgBillingCity checkvl" name="billing_city" placeholder="City" id="cities" required="" autocomplete="off" value="<?= $bCity; ?>">
                              <span id="billing_city_error"></span>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Zipcode<span class="text-danger">*</span>:</label>
                              <input type="text" class="form-control orgBillingZip checkvl" name="billing_zipcode" placeholder="Zipcode" id="zipcode" required="" value="<?= $bZip; ?>">
                              <span id="billing_zipcode_error"></span>
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="form-group">
                              <label for="">Address<span class="text-danger">*</span>:</label>
                              <textarea type="text" class="form-control orgBillingAddress checkvl" name="billing_address" placeholder="Enter Address" id="address" required=""><?= $bAddress; ?></textarea>
                              <span id="billing_address_error"></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                     <?php
                     //print_r($org_dtls);
                     if (isset($record['shipping_country']) && $record['shipping_country'] != "") {
                        $sCountry = $record['shipping_country'];
                     } else if (isset($org_dtls['shipping_country']) && $org_dtls['shipping_country'] != "") {
                        $sCountry = $org_dtls['shipping_country'];
                     } else {
                        $sCountry = '';
                     }
                     if (isset($record['shipping_state']) && $record['shipping_state'] != "") {
                        $sState = $record['shipping_state'];
                     } else if (isset($org_dtls['shipping_state']) && $org_dtls['shipping_state'] != "") {
                        $sState = $org_dtls['shipping_state'];
                     } else {
                        $sState = '';
                     }
                     if (isset($record['shipping_city']) && $record['shipping_city'] != "") {
                        $sCity = $record['shipping_city'];
                     } else if (isset($org_dtls['shipping_city']) && $org_dtls['shipping_city'] != "") {
                        $sCity = $org_dtls['shipping_city'];
                     } else {
                        $sCity = '';
                     }
                     if (isset($record['shipping_zipcode']) && $record['shipping_zipcode'] != "") {
                        $sZip = $record['shipping_zipcode'];
                     } else if (isset($org_dtls['shipping_zipcode']) && $org_dtls['shipping_zipcode'] != "") {
                        $sZip = $org_dtls['shipping_zipcode'];
                     } else {
                        $sZip = '';
                     }
                     if (isset($record['shipping_address']) && $record['shipping_address'] != "") {
                        $sAddress = $record['shipping_address'];
                     } else if (isset($org_dtls['shipping_address']) && $org_dtls['shipping_address'] != "") {
                        $sAddress = $org_dtls['shipping_address'];
                     } else {
                        $sAddress = '';
                     }
                     ?>
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Country<span class="text-danger">*</span>:</label>
                              <input type="text" class="form-control ui-autocomplete-input orgShippingCountry checkvl" name="shipping_country" placeholder="Country" id="s_country" required value="<?= $sCountry; ?>">
                              <input type="hidden" class="form-control s_country_ids" id="s_country_ids">
                              <span id="shipping_country_error"></span>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">State<span class="text-danger">*</span>:</label>
                              <input type="text" class="form-control ui-autocomplete-input orgShippingState checkvl" name="shipping_state" placeholder="State" id="s_states" required="" autocomplete="off" value="<?= $sState; ?>">
                              <input type="hidden" class="form-control s_state_id" id="s_state_id">
                              <span id="shipping_state_error"></span>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">City<span class="text-danger">*</span>:</label>
                              <input type="text" class="form-control ui-autocomplete-input orgShippingCity checkvl" name="shipping_city" placeholder="City" id="s_cities" required="" autocomplete="off" value="<?= $sCity; ?>">
                              <span id="shipping_city_error"></span>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Zipcode<span class="text-danger">*</span>:</label>
                              <input type="text" class="form-control orgShippingZip checkvl" name="shipping_zipcode" placeholder="Zipcode" id="s_zipcode" required="" value="<?= $sZip; ?>">
                              <span id="shipping_zipcode_error"></span>
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="form-group">
                              <label for="">Address<span class="text-danger">*</span>:</label>
                              <textarea type="text" class="form-control orgShippingAddress checkvl" name="shipping_address" placeholder="Enter Address" id="s_address" required=""><?= $sAddress; ?></textarea>
                              <span id="shipping_address_error"></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="proforma-table-main">
                  <div class="row">
                     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <ul class="list-inline">
                           <li class="list-inline-item">
                              <label> <input type="checkbox" checked id="add_gst"> Add GST
                           </li>
                           </label>
                        </ul>
                        <?php
                        if (isset($record['igst'])) {
                           $igst = explode("<br>", $record['igst']);
                        } else {
                           $igst = array();
                        }
                        if (isset($record['cgst'])) {
                           $cgst = explode("<br>", $record['cgst']);
                        } else {
                           $cgst = array();
                        }

                        ?>
                        <ul class="list-inline hide_gst_checkbox">
                           <li class="list-inline-item">
                              <label><input type="radio" name="type" value="Interstate" id="igst_checked" checked <?php if (isset($record['type']) && $record['type'] == 'Interstate') {
                                                                                                                     echo "checked";
                                                                                                                  } ?>> IGST</label>
                           </li>
                           <li class="list-inline-item">
                              <label><input type="radio" name="type" value="Instate" id="csgst_checked" <?php if (isset($record['Instate']) && $record['Instate'] == 'Interstate') {
                                                                                                            echo "checked";
                                                                                                         } ?>> CGST & SGST</label>
                           </li>
                        </ul>
                     </div>
                     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="proforma-table">
                           <table class="table table-responsive-lg" width="100%" id="add_new_line">
                              <thead>
                                 <tr>
                                    <th>Items</th>
                                    <th>Type</th>
                                    <th>HSN/SAC</th>
                                    <th>SKU</th>
                                    <th class="gst">GST(%)</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>Discount</th>
                                    <th>Amount</th>
                                 </tr>
                              </thead>
                              <?php

                              $dataList = '';
                              $dataList .= '<datalist id="taxName">';
                              foreach ($gstPer as $gstrow) {
                                 $dataList .= '<option value="' . $gstrow['gst_percentage'] . '">' . $gstrow['tax_name'] . '@</option>';
                              }
                              $dataList .= '</datalist>';

                              $rw = 45;
                              if (isset($record['product_name'])) {
                                 $proName   = explode("<br>", $record['product_name']);
                                 if (isset($record['hsn_sac'])) {
                                    $hsn_sac   = explode("<br>", $record['hsn_sac']);
                                 } else {
                                    $hsn_sac = array();
                                 }
                                 if (isset($record['quote_item_type'])) {
                                    $quote_item_type   = explode("<br>", $record['quote_item_type']);
                                 } else {
                                    $quote_item_type = array();
                                 }
                                 $quantity   = explode("<br>", $record['quantity']);
                                 $unit_price   = explode("<br>", $record['unit_price']);
                                 $total      = explode("<br>", $record['total']);
                                 if (isset($record['gst'])) {
                                    $gst      = explode("<br>", $record['gst']);
                                 } else {
                                    $gst      = array();
                                 }

                                 $sgst = array();
                                 $cgst = array();
                                 $igst = array();
                                 $proDiscount = array();
                                 $proDescription = array();
                                 if (isset($record['sgst'])) {
                                    $sgst = explode("<br>", $record['sgst']);
                                 }
                                 if (isset($record['cgst'])) {
                                    $cgst = explode("<br>", $record['cgst']);
                                 }
                                 if (isset($record['igst'])) {
                                    $igst = explode("<br>", $record['igst']);
                                 }
                                 if (isset($record['pro_description'])) {
                                    $proDescription = explode("<br>", $record['pro_description']);
                                 }
                                 if (isset($record['pro_discount'])) {
                                    $proDiscount = explode("<br>", $record['pro_discount']);
                                 }

                                 for ($pr = 0; $pr < count($proName); $pr++) {
                              pr($record);
                              ?>
                                    <tr class="removCL<?= $rw; ?>">   
                                    <td>
                                          <select name="quote_item_type[]" id="quote_item_type" class="form-control">
                                             <option value="0" <?php echo (htmlspecialchars($quote_item_type[$pr]) === "0") ? 'selected' : ''; ?>>New</option>
                                             <option value="1" <?php echo (htmlspecialchars($quote_item_type[$pr]) === "1") ? 'selected' : ''; ?>>Renew</option>
                                          </select>


                                       </td>
                                       <td>
                                          <input type="text" name="product_name[]" class="form-control productItm checkvl" id="proName<?= $rw; ?>" data-cntid="<?= $rw; ?>" onkeyup="getproductinfo();" placeholder="Items name(required)" value="<?= htmlspecialchars($proName[$pr]); ?>"><span id="items_error"></span>
                                       </td>
                                       <td><input type="text" name="hsn_sac[]" class="form-control" id="hsn<?= $rw; ?>" placeholder="HSN/SAC" value="<?php if (isset($hsn_sac[$pr])) {
                                                                                                                                                      echo $hsn_sac[$pr];
                                                                                                                                                   } ?>"></td>
                                       <td>
                                          <input type="text" name="sku[]" class="form-control" id="sku<?= $rw; ?>" placeholder="SKU" value="<?php if (isset($hsn_sac[$pr])) {
                                                                                                                                             echo $hsn_sac[$pr];
                                                                                                                                          } ?>">
                                       </td>
                                       <td class="gst">
                                          <input type="text" name="gst[]" class="form-control checkvl" onkeyup="calculate_pro_price()" id="gst<?= $rw; ?>" placeholder="GST in %" value="<?php if (isset($gst[$pr])) {
                                                                                                                                                                                          echo $gst[$pr];
                                                                                                                                                                                       } ?>" list="taxName">
                                          <?php echo $dataList; ?>
                                       </td>
                                       </td>
                                       <td><input type="text" onkeyup="calculate_pro_price()" name="quantity[]" id="qty<?= $rw; ?>" class="form-control checkvl numeric" placeholder="qty" value="<?= $quantity[$pr]; ?>"><span id="quantity_error"></span></td>
                                       <td><input type="text" onkeyup="calculate_pro_price()" name="unit_price[]" id="price<?= $rw; ?>" class="form-control start checkvl parseFloat" placeholder="rate" value="<?= $unit_price[$pr]; ?>"><span id="unit_price_error"></span></td>
                                       <td><input type="text" onkeyup="calculate_pro_price()" name="discount_price[]" id="disc<?= $rw; ?>" class="form-control parseFloat" placeholder="Discount Price" value="<?php if (isset($proDiscount[$pr])) {
                                                                                                                                                                                                                  echo $proDiscount[$pr];
                                                                                                                                                                                                               } else {
                                                                                                                                                                                                                  echo "0";
                                                                                                                                                                                                               } ?>"></td>
                                       <td><input type="text" name="total[]" class="form-control" class="" readonly value="<?= $total[$pr]; ?>">
                                          <input type="hidden" name="cgst[]" value="<?php if (isset($cgst[$pr])) {
                                                                                       echo $cgst[$pr];
                                                                                    } ?>" class="" readonly>
                                          <input type="hidden" name="sgst[]" value="<?php if (isset($sgst[$pr])) {
                                                                                       echo  $sgst[$pr];
                                                                                    } ?>" class="" readonly>
                                          <input type="hidden" name="igst[]" value="<?php if (isset($igst[$pr])) {
                                                                                       echo  $igst[$pr];
                                                                                    } ?>" class="" readonly>
                                          <input type="hidden" name="sub_total_with_gst[]" class="" readonly>
                                       </td>
                                    </tr>
                                    <tr class=" <?php if (empty($proDescription[$pr])) { ?> pro_descrption <?php } ?>  removCL<?= $rw; ?> addCL<?= $rw; ?>" <?php if (empty($proDescription[$pr])) { ?> style="display:none;" <?php } ?>>
                                       <td colspan="8">
                                          <input type="text" name="pro_description[]" value="<?php if (isset($proDescription[$pr])) {
                                                                                                echo htmlspecialchars($proDescription[$pr]);
                                                                                             } ?>" placeholder="Description">
                                       </td>
                                    </tr>
                                    <tr class="removCL<?= $rw; ?>">
                                       <td class="delete_new_line" colspan="2">
                                          <a href="javascript:void(0);" onClick="removeRow('removCL<?= $rw; ?>');"><i class="far fa-trash-alt delIcn"></i> Delete Row</a>
                                       </td>
                                       <td colspan="8">
                                          <a href="javascript:void(0);" class="add_desc deschd<?= $rw; ?>" onClick="addDesc('addCL<?= $rw; ?>','deschd<?= $rw; ?>')" <?php if (!empty($proDescription[$pr])) { ?> style="display:none;" <?php } ?>><i class="far fa-plus-square addIcn"></i> Add Description</a>
                                       </td>
                                    </tr>
                                 <?php $rw++;
                                 }
                              } else {  ?>
                                 <tr class="removCL<?= $rw; ?>">
                                    <td>
                                       <select name="quote_item_type[]" id="quote_item_type" class="form-control">
                                          <option value="0">New</option>
                                          <option value="1">Renew</option>
                                       </select>

                                    </td>
                                    <td>
                                       <input type="text" name="product_name[]" class="form-control productItm checkvl" id="proName<?= $rw; ?>" data-cntid="<?= $rw; ?>" onkeyup="getproductinfo();" placeholder="Items name(required)" value="">
                                       <span id="items_error"></span>
                                    </td>
                                    <td><input type="text" name="hsn_sac[]" class="form-control" id="hsn<?= $rw; ?>" placeholder="HSN/SAC" value=""></td>
                                    <td>
                                       <input type="text" name="sku[]" class="form-control" id="sku<?= $rw; ?>" placeholder="SKU" value="">
                                    </td>
                                    <td class="gst">
                                       <input type="text" name="gst[]" id="gst<?= $rw; ?>" class="form-control" onkeyup="calculate_pro_price()" placeholder="GST in %" value="" list="taxName">
                                       <?php echo $dataList; ?>
                                    </td>
                                    <td><input type="text" onkeyup="calculate_pro_price()" name="quantity[]" id="qty<?= $rw; ?>" class="form-control checkvl numeric" placeholder="qty" value=""><span id="quantity_error"></span></td>
                                    <td><input type="text" class="start form-control" onkeyup="calculate_pro_price()" name="unit_price[]" id="price<?= $rw; ?>" class="form-control start checkvl parseFloat" id="unit_price" placeholder="rate" value=""><span id="unit_price_error"></span></td>
                                    <td><input type="text" onkeyup="calculate_pro_price()" name="discount_price[]" id="disc<?= $rw; ?>" class="form-control parseFloat" placeholder="Discount Price" value="0"></td>
                                    <td><input type="text" name="total[]" class="form-control" class="" readonly value="">
                                       <input type="hidden" name="cgst[]" value="" class="" readonly>
                                       <input type="hidden" name="sgst[]" value="" class="" readonly>
                                       <input type="hidden" name="igst[]" value="" class="" readonly>
                                       <input type="hidden" name="sub_total_with_gst[]" class="" readonly>
                                    </td>
                                 </tr>
                                 <tr class="pro_descrption removCL<?= $rw; ?> addCL<?= $rw; ?>" style="display:none;">
                                    <td colspan="8">
                                       <input type="text" name="pro_description[]" value="" placeholder="Description">
                                    </td>
                                 </tr>
                                 <tr class="removCL<?= $rw; ?>">
                                    <td class="delete_new_line" colspan="2">
                                       <a href="javascript:void(0);" onClick="removeRow('removCL<?= $rw; ?>');"><i class="far fa-trash-alt delIcn"></i> Delete Row</a>
                                    </td>
                                    <td colspan="8">
                                       <a href="javascript:void(0);" class="add_desc deschd<?= $rw; ?>" onClick="addDesc('addCL<?= $rw; ?>','deschd<?= $rw; ?>')"><i class="far fa-plus-square addIcn"></i> Add Description</a>
                                    </td>
                                 </tr>
                              <?php } ?>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="row">
                     <div class="add_line"> <a href="javascript:void(0);"><i class="far fa-plus-square"></i> Add New Line</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="price-breakup">
            <div class="container">
               <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"></div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                     <div class="price-breakup-right">
                        <div class="row">
                           <input type="hidden" name="initial_total" id="initial_total">
                           <input type="hidden" name="total_discount" id="total_discount">
                           <input type="hidden" name="after_discount" id="after_discount">
                           <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5">
                              <p class="sub_amount">Overall Discount :</p>
                           </div>
                           <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 text-right">
                              <?php
                              if (isset($record['discount_type'])) {
                                 $discountType = $record['discount_type'];
                              } else {
                                 $discountType = '';
                              }
                              ?>
                              <select name="discountType" id="discountType" onChange="calculate_pro_price()" class="form-control">
                                 <option value="0" <?php if ($discountType == 0) {
                                                      echo "selected";
                                                   } ?>>Select Type</option>
                                 <option value="in_rupee" <?php if ($discountType == 'in_rupee') {
                                                               echo "selected";
                                                            } ?>>In Rupee</option>
                                 <option value="in_percentage" <?php if ($discountType == 'in_percentage') {
                                                                  echo "selected";
                                                               } ?>>In %</option>
                              </select>
                           </div>
                           <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                              <input id="overallDiscount" name="overallDiscount" onkeyup="calculate_pro_price()" class="form-control" type="text" value="<?php if (isset($record['overall_discount'])) {
                                                                                                                                                            echo $record['overall_discount'];
                                                                                                                                                         }  ?>" placeholder="Enter Discount">
                           </div>
                           <!---Discount Field--->
                           <!--
                           <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5">
                              <p class="discount">Overall Discount:<br>
                              ₹ <b id="cal_disc"></b>
                              </p>
                                 </div>
                                 <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 text-right">
                                     
                                 </div>
                                 <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                                    <p class="discount">
                                        <input type="text" id="discounts" name="discount" onkeyup="calculate_pro_price()" value="<?php if (isset($record['discount']) && $record['discount'] != "") {
                                                                                                                                    echo $record['discount'];
                                                                                                                                 } ?>" class="form-control">
                                    </p>
                                 </div>
                                 
                                 <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right">
                                    <p class="discount"><a href="javascript:void(0);" id="remove_discount"><i class="fas fa-times"></i></a></p>
                                 </div>-->
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                              <p class="sub_amount">Amount :</p>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                              <p class="sub_amount" id="show_subAmount">₹0.00</p>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                              <p class="sgst">SGST :</p>
                              <p class="cgst">CGST :</p>
                              <p class="igst">IGST :</p>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                              <p class="sgst" id="show_sgst">₹0.00</p>
                              <p class="cgst" id="show_cgst">₹0.00</p>
                              <p class="igst" id="show_igst">₹0.00</p>
                              <input type="hidden" name="total_igst" id="total_igst" value="0">
                              <input type="hidden" name="total_cgst" id="total_cgst" value="0">
                              <input type="hidden" name="total_sgst" id="total_sgst" value="0">
                           </div>
                           <div class="row" id="putExtraVl">
                              <?php
                              if (isset($record['extra_charge_label']) && $record['extra_charge_label'] != "") {
                                 $extraChargeName = explode("<br>", $record['extra_charge_label']);
                                 $extraChargeValue = explode("<br>", $record['extra_charge_value']);
                                 $td = 30;
                                 for ($ex = 0; $ex < count($extraChargeName); $ex++) {
                              ?>
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5" id="ext<?= $td; ?>" style="margin-bottom: 3%;">
                                       <input type="text" name="extra_charge[]" value="<?php echo $extraChargeName[$ex]; ?>" placeholder="Extra Charges Label" class="form-control">
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="extVl<?= $td; ?>" style="margin-bottom: 3%;">
                                       <input type="text" onkeyup="calculate_pro_price()" placeholder="Extra Charges Value" name="extra_chargevalue[]" id="floatvald<?= $td; ?>" value="<?php echo $extraChargeValue[$ex]; ?>" class="form-control inptvl">
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1" id="rows<?= $td; ?>" style="margin-bottom: 3%;">
                                       <a href="javascript:void(0);" class="remove_additionalchg" id="<?= $td; ?>">X</a>
                                    </div>
                              <?php $td++;
                                 }
                              } ?>
                           </div>
                           <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                              <!-- <p class="add_discount"><a href="javascript:void(0);"><i class="fas fa-tag"></i> Add Discount</a>
                              </p>  -->
                              <p><a href="javascript:void(0);" class="add_additionalchg"><i class="far fa-plus-square"></i> Add Additional Charges</a>
                              </p>
                              <hr>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                              <div class="total-price">
                                 <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 inrRp">
                                       <h4>Total (INR)</h4>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 inrIcn">
                                       <h4>₹</h4>
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                                       <input id="final_total" name="sub_total" class="form-control" type="text" readonly>
                                    </div>
                                 </div>
                              </div>
                              <hr>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                              <div class="price_in_words text-right">
                                 <h6><b>Total (in words)</b></h6>
                                 <h6 id="digittowords">Zero Ruppes Only</h6>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-footer-section py-5">
            <?php
            if (isset($record['terms_condition']) && $record['terms_condition'] != "") {
               $terms_condition = $record['terms_condition'];
            } else {
               $terms_condition = $this->session->userdata('terms_condition_customer');
            }

            ?>
            <div class="container">
               <?php if (empty($terms_condition)) { ?>
                  <a href="javascript:void(0);" class="add_terms"><i class="far fa-plus-square addIcn"></i> Add Terms</a>
               <?php } ?>
               <div id="show_terms" <?php if (empty($terms_condition)) { ?> style="display:none;" <?php } ?>>
                  <p>Terms and Condition :</p>
                  <span id="terms_condition">
                     <?php if (!empty($terms_condition)) {
                        $termsCondition = explode("<br>", $terms_condition);
                        $p = 1;
                        $dm = 14;
                        for ($tm = 0; $tm < count($termsCondition); $tm++) {
                     ?>
                           <div class="row" id="addterms<?= $dm; ?>">
                              <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right">
                                 <p><?= $p; ?></p>
                              </div>
                              <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
                                 <input type="text" name="terms_condition[]" value="<?= $termsCondition[$tm]; ?>" placeholder="Write Your Conditions">
                              </div>
                              <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1">
                                 <a href="javascript:void(0);" class="remove_terms" id="<?= $dm; ?>">X</a>
                              </div>
                           </div>
                     <?php $p++;
                           $dm++;
                        }
                     } ?>
                  </span>
                  <div class="row m-0" id="add_terms_condition"> <a href="javascript:void(0);"><i class="far fa-plus-square"></i> Add New Term & Condition</a>
                  </div>
               </div>
            </div>
         </div>
         <!--
         <div class="notes">
           <div class="container">
             <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                 <a href="javascript:void(0);" class="add_notes"><i class="fas fa-calendar-minus addIcn"></i> Add Notes</a>
                 <div class="notes_left" <?php if (empty($record['notes'])) {
                                             echo "style='display:none;'";
                                          } ?> >
                   <textarea class="form-control" name="notes" rows="8" placeholder="Notes"><?php if (isset($record['notes'])) {
                                                                                                echo $record['notes'];
                                                                                             } ?></textarea>
                   <button class="remove_notes" type="button">X</button>
                 </div>
               </div>
             </div>
           </div>
         </div>-->
         <div class="contact_details">
            <div class="container">
               <p>Your contact details :</p>
               <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                     <p>For any enquiry, reach out via email at</p>
                     <input type="email" name="enquiry_email" value="<?= $this->session->userdata('company_email'); ?>">
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                     <p>Or you can call on</p>
                     <label style="display: inline; border: 0; border-bottom: 1px solid #ccc;  background-color: transparent; ">+91-</label>
                     <input type="text" style="width:90%;" name="enquiry_mobile" value="<?= $this->session->userdata('company_mobile'); ?>">
                  </div>
               </div>
               <div class="row mt-5" id="errorMsgbox">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                     <div class="error-popup-msg-for-user">
                        <p><i class="fas fa-exclamation-circle"></i>
                           Please fill the following details:
                        </p>
                        <ol id="ErrorMsg">
                        </ol>
                     </div>
                  </div>
                  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"></div>
               </div>
               <div class="row mt-5">
                  <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                     <!--<div class="draft-btn text-right">
                     <button>Save As Draft</button>
                     </div>-->
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                     <div class="save-btn text-left">
                        <button type="button" id="btnSave" onclick="save();">Save & Continue</button>
                        <button type="button" id="btnSaveCls" style="display:none;">Validating Data...</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   <?php } ?>
   <!-- /.content-header -->
</div>
<!-- common footer include -->
<?php $this->load->view('footer'); ?>
<?php $this->load->view('common_footer'); ?>
<?php $this->load->view('commonAddorg_modal'); ?>
<?php $this->load->view('commonAddcontact_modal'); ?>
<?php $this->load->view('product_onkeyup'); ?>
<?php if (isset($_GET['org']) && $_GET['org'] != "") { ?>
   <script>
      setOrgData("<?= $_GET['org']; ?>");
   </script>
<?php } ?>
<script>
   $('#carrier').change(function() {
      var carrirName = $(this).val();
      if (carrirName == 'other') {
         $("#dispCourier").show();
      } else {
         $("#dispCourier").hide();
      }
   });

   $(document).ready(function() {
      $("#contact_name").select2({
         placeholder: " ",
         class: "form-control"
      });
   });


   function save() {
      if (checkValidationWithClass('form') == 1) {
         toastr.info('Please wait while we are processing your request');
         $('#btnSave').hide();
         $('#btnSaveCls').show();
         var url;
         var save_method = $("#save_method").val();
         if (save_method == 'add') {
            url = "<?= site_url('quotation/create') ?>";
         } else {
            url = "<?= site_url('quotation/update') ?>";
         }

         $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {
               if (data.status) {
                  toastr.success('Quotation has been added successfully.');
                  window.location.href = '<?= base_url() ?>quotation/view_pi_qt/' + data.id;
               }
               $('#btnSaveCls').hide();
               $('#btnSave').show();
               if (data.st == 202) {
                  toastr.error('Validation Error, Please fill all star marks fields');
                  $("#opportunity_id_error").html(data.opportunity_id);
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
                  checkValidationWithClass('form');
               } else if (data.st == 200) {
                  toastr.error('Something went wrong, Please try later.');
                  $("#opportunity_id_error").html('');
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
            error: function(jqXHR, textStatus, errorThrown) {
               toastr.error('Something went wrong, Please try later.');
               $('#btnSaveCls').hide();
               $('#btnSave').show();
            }
         });
      }
   }

   /*********** start calculate invoice****/
   function calculate_pro_price() {
      var Amount = 0;
      var IGST = 0;
      var DiscpriceT = 0;
      var cal_discount = 0;
      var extraCharge = 0;
      var SCGST = 0;
      var discountType = 0;
      var overallDiscount = 0;
      var totalCnt = 0;
      var NewOutput = 0;
      var Discprice = 0;

      //console.log(Amount);
      var discountType = $("#discountType").val();
      var overallDiscount = $("#overallDiscount").val();

      $("input[name='quantity[]']").each(function(index) {
         var quantity = $("input[name='quantity[]']").eq(index).val();
         var price = $("input[name='unit_price[]']").eq(index).val();
         price = price.replace(/,/g, "");
         var pricetwo = numberToIndPrice(price);
         $("input[name='unit_price[]']").eq(index).val(pricetwo);

         //Dicount Price
         var Discprice = $("input[name='discount_price[]']").eq(index).val();
         Discprice = Discprice.replace(/,/g, "");
         DiscpriceT = parseFloat(DiscpriceT) + parseFloat(Discprice);
         var Discpricetwo = numberToIndPrice(Discprice);
         $("input[name='discount_price[]']").eq(index).val(Discpricetwo);

         var gst = $("input[name='gst[]']").eq(index).val();
         if (gst == "") {
            gst = 0;
         }
         var output = parseInt(quantity) * parseFloat(price);
         output = parseInt(output) - parseInt(Discprice);

         $("input[name='total[]']").eq(index).val(numberToIndPrice(output.toFixed(2)));

         var tax = parseFloat(output) * parseFloat(gst) / 100;

         var overallDiscount = $("#overallDiscount").val();

         if (overallDiscount < 1) {
            if (!isNaN(output)) {
               Amount = parseFloat(Amount) + parseFloat(output);
               if ($('#add_gst').is(":checked")) {
                  IGST = parseFloat(IGST) + parseFloat(tax);
                  SCGST = parseFloat(IGST) / 2;
                  var addgst_subTotal = parseFloat(tax) + parseFloat(output);
                  $("input[name='sub_total_with_gst[]']").eq(index).val(addgst_subTotal.toFixed(2));
                  if ($('#igst_checked').is(":checked")) {
                     $("input[name='igst[]']").eq(index).val(tax.toFixed(2));
                     $("input[name='cgst[]']").eq(index).val('');
                     $("input[name='sgst[]']").eq(index).val('');
                  } else if ($('#csgst_checked').is(":checked")) {
                     $("input[name='igst[]']").eq(index).val('');
                     var taxs = parseFloat(tax) / 2;
                     $("input[name='cgst[]']").eq(index).val(taxs.toFixed(2));
                     $("input[name='sgst[]']").eq(index).val(taxs.toFixed(2));
                  }
               }

            }
         }
      });

      const gstArr = [];
      $("input[name='quantity[]']").each(function(index) {
         var gst = $("input[name='gst[]']").eq(index).val();
         gstArr.push(gst);
      });




      if (myFunc(gstArr) === true) {
         $("#overallDiscount").prop('readonly', false);
      } else {
         if (DiscpriceT < 1) {
            $("#overallDiscount").prop('readonly', false);
         } else {
            console.log(DiscpriceT);
            $("#overallDiscount").prop('readonly', true);
         }
      }

      if (DiscpriceT < 1) {
         $("#overallDiscount").prop('readonly', false);
      } else {
         console.log(DiscpriceT);
         $("#overallDiscount").prop('readonly', true);
      }

      var overallDiscount = $("#overallDiscount").val();
      var NewOutputTtl = 0;
      if (overallDiscount > 1) {
         $("input[name='quantity[]']").each(function(index) {
            var quantity = $("input[name='quantity[]']").eq(index).val();
            var price = $("input[name='unit_price[]']").eq(index).val();
            price = price.replace(/,/g, "");
            var NewOutput = parseInt(quantity) * parseFloat(price);
            NewOutputTtl = parseInt(NewOutputTtl) + parseInt(NewOutput);
            $("input[name='discount_price[]']").eq(index).prop('readonly', true);
         });

         var discountType = $("#discountType").val();
         if (discountType == 'in_percentage') {
            var tax = parseFloat(NewOutputTtl) * parseFloat(overallDiscount) / 100;
            NewOutputTtl = parseInt(NewOutputTtl) - parseInt(tax);
         } else {
            NewOutputTtl = parseInt(NewOutputTtl) - parseInt(overallDiscount);
         }
         var gst = gstArr[0];
         var tax = parseFloat(NewOutputTtl) * parseFloat(gst);

         tax = parseFloat(tax) / 100;
         //console.log(tax);
         if ($('#add_gst').is(":checked")) {
            IGST = parseFloat(IGST) + parseFloat(tax);
            SCGST = parseFloat(IGST) / 2;
            var addgst_subTotal = parseFloat(tax) + parseFloat(NewOutputTtl);
            if ($('#igst_checked').is(":checked")) {} else if ($('#csgst_checked').is(":checked")) {
               var taxs = parseFloat(tax) / 2;
            }
         }

         Amount = NewOutputTtl;

      } else {
         $("input[name='quantity[]']").each(function(index) {
            $("input[name='discount_price[]']").eq(index).prop('readonly', false);
         });
      }


      var discount = 0; //document.getElementById('discounts').value;
      if (discount != "" && discount != 0) {
         discount = discount.replace(/,/g, "");
         var cal_discount = parseFloat(discount);
      } else {
         var cal_discount = 0;
      }
      $('#discounts').val(numberToIndPrice(discount));

      $('#cal_disc').html(numberToIndPrice(cal_discount.toFixed(2)));
      $('#total_discount').val(numberToIndPrice(cal_discount.toFixed(2)));

      var GrandAmount = parseFloat(Amount) + parseFloat(IGST);
      GrandAmount = parseFloat(GrandAmount) - parseFloat(cal_discount);
      $('#after_discount').val(GrandAmount);
      $("input[name='extra_chargevalue[]']").each(function(index) {
         var extra_charge = $("input[name='extra_chargevalue[]']").eq(index).val();
         extra_charge = extra_charge.replace(/,/g, "");
         $("input[name='extra_chargevalue[]']").eq(index).val(numberToIndPrice(extra_charge));
         if (extra_charge !== undefined && extra_charge != "") {
            extraCharge = parseFloat(extraCharge) + parseFloat(extra_charge);
         }
      });

      GrandAmount = parseFloat(GrandAmount) + parseFloat(extraCharge);

      $("#show_subAmount").html(numberToIndPrice(Amount.toFixed(2)));
      $('#initial_total').val(numberToIndPrice(Amount.toFixed(2)));
      $("#show_igst").html(numberToIndPrice(IGST.toFixed(2)));
      $("#show_cgst").html(numberToIndPrice(SCGST.toFixed(2)));
      $("#show_sgst").html(numberToIndPrice(SCGST.toFixed(2)));
      if ($('#igst_checked').is(":checked")) {
         $("#total_igst").val(IGST.toFixed(2));
         $("#total_cgst").val('');
         $("#total_sgst").val('');
      } else {
         $("#total_cgst").val(SCGST.toFixed(2));
         $("#total_sgst").val(SCGST.toFixed(2));
         $("#total_igst").val('');
      }

      $('#final_total').val(numberToIndPrice(GrandAmount.toFixed(2)));
      $('#digittowords').html(digit_to_words(GrandAmount));
   }

   function myFunc(arr) {
      var x = arr[0];
      return arr.every(function(item) {
         return item === x;
      });
   }





   /*********** start calculate invoice****/


   /*


   BACKUP FUNCTION Befor OVERAll Discount....

   function calculate_pro_price()
   {
   	  var Amount=0;
   	  var IGST =0;
   	  var DiscpriceT =0;
   	  var cal_discount=0;
   	  var extraCharge=0;
   	  var SCGST = 0;
   	$("input[name='quantity[]']").each(function (index) {
   		    var quantity = $("input[name='quantity[]']").eq(index).val();
               var price = $("input[name='unit_price[]']").eq(index).val();
   			price = price.replace(/,/g, "");
   			var pricetwo=numberToIndPrice(price);
   			$("input[name='unit_price[]']").eq(index).val(pricetwo);
   			
   			//Dicount Price
               var Discprice = $("input[name='discount_price[]']").eq(index).val();
   			Discprice = Discprice.replace(/,/g, "");
   			DiscpriceT=parseFloat(DiscpriceT)+parseFloat(Discprice);
   			var Discpricetwo=numberToIndPrice(Discprice);
   			$("input[name='discount_price[]']").eq(index).val(Discpricetwo);
   			

               var gst = $("input[name='gst[]']").eq(index).val();
   			if(gst==""){
   				gst=0;
   			}
               var output = parseInt(quantity) * parseFloat(price);
   			output=parseInt(output)-parseInt(Discprice);
               var tax = parseFloat(output) * parseFloat(gst)/100;
   			if (!isNaN(output))
               {
   				Amount=parseFloat(Amount)+parseFloat(output);
                   $("input[name='total[]']").eq(index).val(numberToIndPrice(output.toFixed(2)));
   				if($('#add_gst').is(":checked"))
                   {    
   					
   					IGST = parseFloat(IGST)+parseFloat(tax);
   					SCGST = parseFloat(IGST)/2;
   					var addgst_subTotal = parseFloat(tax) + parseFloat(output);
   					$("input[name='sub_total_with_gst[]']").eq(index).val(addgst_subTotal.toFixed(2));
   					if($('#igst_checked').is(":checked")){
   						
   					$("input[name='igst[]']").eq(index).val(tax.toFixed(2));
   					   $("input[name='cgst[]']").eq(index).val('');
   					   $("input[name='sgst[]']").eq(index).val('');
   					}else if($('#csgst_checked').is(":checked"))
   					{
   						$("input[name='igst[]']").eq(index).val('');
   						var taxs = parseFloat(tax)/2;
   					   $("input[name='cgst[]']").eq(index).val(taxs.toFixed(2));
   					   $("input[name='sgst[]']").eq(index).val(taxs.toFixed(2));
   				    }
   				}
   				
   			}
   	});
   	
   	//console.log(Amount);
   	var discount = 0; //document.getElementById('discounts').value;
   	if(discount!="" && discount!=0){
   	discount = discount.replace(/,/g, "");
   	var cal_discount = parseFloat(discount);
   	}else{
   	var cal_discount=0;	
   	}
   	$('#discounts').val(numberToIndPrice(discount));
   	
   	$('#cal_disc').html(numberToIndPrice(cal_discount.toFixed(2)));
   	$('#total_discount').val(numberToIndPrice(cal_discount.toFixed(2)));

   	var GrandAmount=parseFloat(Amount)+parseFloat(IGST);
   	GrandAmount=parseFloat(GrandAmount)-parseFloat(cal_discount);
   	$('#after_discount').val(GrandAmount);
   	$("input[name='extra_chargevalue[]']").each(function (index) {
   		var extra_charge = $("input[name='extra_chargevalue[]']").eq(index).val();
   		extra_charge = extra_charge.replace(/,/g, "");
   		$("input[name='extra_chargevalue[]']").eq(index).val(numberToIndPrice(extra_charge));
   		if(extra_charge!== undefined && extra_charge!="")
   		{
   			extraCharge=parseFloat(extraCharge)+parseFloat(extra_charge);		    
   		}
   	});
   	
   	GrandAmount=parseFloat(GrandAmount)+parseFloat(extraCharge);
   	
   	$("#show_subAmount").html(Amount.toFixed(2));
   	$('#initial_total').val(numberToIndPrice(Amount.toFixed(2)));
   	$("#show_igst").html(IGST.toFixed(2));
   	$("#show_cgst").html(SCGST.toFixed(2));
   	$("#show_sgst").html(SCGST.toFixed(2));
   	if($('#igst_checked').is(":checked")){
   		$("#total_igst").val(IGST.toFixed(2));
   		$("#total_cgst").val('');
   		$("#total_sgst").val('');
   	}else{
   		$("#total_cgst").val(SCGST.toFixed(2));
   		$("#total_sgst").val(SCGST.toFixed(2));
   		$("#total_igst").val('');
   	}
   	
   	
   	$('#final_total').val(numberToIndPrice(GrandAmount.toFixed(2)));
   	$('#digittowords').html(digit_to_words(GrandAmount));
   }
   	
   */




   calculate_pro_price();
   i = 1;
   var rowid = 400;
   $(".add_line").click(function() {
      i++;
      rowid++;
      var markup = '<tr class="removCL' + i + '">' +
         '<td><select name="quote_item_type[]" class="form-control">' +
         '<option value="0">New</option>' +
         '<option value="1">Renew</option>' +
         '</select></td>' +
         '<td><input type="text" name="product_name[]" class="form-control productItm checkvl" id="proName' + rowid + '" data-cntid="' + rowid + '" onkeyup="getproductinfo();" placeholder="Items name(required)"><span id="items_error"></span></td>' +
         '<td><input type="text" name="hsn_sac[]" class="form-control" id="hsn' + rowid + '" placeholder="HSN/SAC"></td>' +
         '<td><input type="text" name="sku[]" class="form-control" id="sku' + rowid + '"  placeholder="SKU"></td>' +
         '<td class="gst"><input type="text" name="gst[]" class="form-control"  onkeyup="calculate_pro_price()" id="gst' + rowid + '" value="" placeholder="GST in %" list="taxName" > </td>' +
         '<td><input type="text" onkeyup="calculate_pro_price()" id="qty' + rowid + '" class="form-control integer_validqty' + i + '" name="quantity[]" placeholder="qty"><span id="quantity_error"></span></td>' +
         '<td><input type="text" name="unit_price[]"  id="price' + rowid + '" class="form-control start checkvl parseFloat" onkeyup="calculate_pro_price()" placeholder="rate"><span id="unit_price_error"></span></td>' +
         '<td><input type="text" onkeyup="calculate_pro_price()" name="discount_price[]" id="disc' + rowid + '" class="form-control parseFloat"  placeholder="Discount Price" value="0"></td>' +
         '<td><input type="text" name="total[]" class="form-control" readonly>' +
         '<input type="hidden" name="cgst[]"  readonly>' +
         '<input type="hidden" name="sgst[]" readonly>' +
         '<input type="hidden" name="igst[]"  readonly>' +
         '<input type="hidden" name="sub_total_with_gst[]" readonly></td> </tr>' +
         '<tr class="pro_descrption removCL' + i + ' addCL' + i + '"><td colspan="8">' +
         '<input type="text" name="pro_description[]" id="" placeholder="Description"></td></tr>' +
         '<tr class="removCL' + i + '"><td class="delete_new_line" colspan="2" onClick="removeRow(`removCL' + i + '`);" >' +
         '<a href="javascript:void(0);"><i class="far fa-trash-alt delIcn"></i> Delete Row</a></td>' +
         '<td colspan="8"><a href="javascript:void(0);" class="add_desc deschd' + i + '" onClick="addDesc(`addCL' + i + '`,`deschd' + i + '`);"><i class="far fa-plus-square addIcn"></i> Add Description</a></td></tr>';
      $("#add_new_line").append(markup);

      $('.igst,.gst,.sub_total,.cgst,.sgst').hide();

      if ($('#add_gst').is(":checked")) {
         if ($('#igst_checked').is(":checked")) {
            $('.sub_amount,.sub_total,.gst,.igst').show();
            $('.cgst,.sgst').hide();

            calculate_pro_price();
         } else if ($('#csgst_checked').is(":checked")) {
            $('.sub_amount,.gst,.sub_total').show();
            $('.cgst,.sgst').show();
            $('.igst').hide();

            calculate_pro_price();
         }
      }
      //only integer validation on quantity        
   });


   function removeRow(removCL) {
      $("." + removCL).remove();
      calculate_pro_price();
   }

   function addDesc(addCL, deschd) {
      $("." + addCL).show();
      $("." + deschd).hide();

   }
</script>

<script>
   $(document).ready(function() {
      $('#add_gst').click(function() {
         if ($('#add_gst').is(":checked")) {
            $('.hide_gst_checkbox').toggle("show");
            $('.gst,.igst,.sub_amount,.sub_total').show();
            $('.cgst,.sgs').hide();
            calculate_pro_price();
         } else {
            $('.hide_gst_checkbox').toggle("hide");
            $('').hide();
            $('.gst,.igst,.cgst,.sgst,.sub_amount,.sub_total').hide();
            calculate_pro_price();
         }

      });

      /******by default show and hide start**********/

      //$('.hide_gst_checkbox').toggle("hide");
      $('.cgst,.sgst,.discount').hide();
      $('#errorMsgbox').hide();
      $('.add_discount').show();
      /*<?php if (isset($record['gst']) && $record['gst'] != "") { ?> $('#add_gst').click(); <?php } ?>*/

      /******by default show and hide end**********/


      $('#igst_checked').click(function() {
         gstShow();
      });
      $('#csgst_checked').click(function() {
         gstShow();
      });

      gstShow();

      function gstShow() {
         $('.sub_amount').show();
         $('.gst').show();
         $('.sub_total').show();
         if ($('#igst_checked').is(":checked")) {
            $('.igst').show();
            $('.cgst').hide();
            $('.sgst').hide();
         } else if ($('#csgst_checked').is(":checked")) {
            $('.igst').hide();
            $('.cgst').show();
            $('.sgst').show();
         }
         calculate_pro_price();
      }


      //add product description 
      $('.add_desc').click(function() {
         $(this).hide();
      });



      //add discount
      $('.add_discount').click(function() {
         $('.add_discount').hide();
         $('.discount').show();
      });
      $('#remove_discount').click(function() {
         $('.add_discount').show();
         $('.discount').hide();
         $('#discounts').val("");
         $('#cal_disc').html("");
         calculate_pro_price();
      });
      <?php if (isset($record['discount']) && $record['discount'] != "") { ?>
         $('.add_discount').click();
      <?php } ?>



      //add notes
      $('.add_notes').click(function() {
         $('.add_notes').hide();
         $('.notes_left').show();
      });
      $('.remove_notes').click(function() {
         $('.add_notes').show();
         $('.notes_left').hide();
         $('[name="notes"]').val(function() {
            return this.defaultValue;
         });
      });



      //add more extra charge and value 
      var i = 1;
      $('.add_additionalchg').click(function() {
         i++;
         var markup = '<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5" id="ext' + i + '" style="margin-bottom: 3%;"> <input type="text" name="extra_charge[]" value="" placeholder="Extra Charges Label" class="form-control" ></div>' +
            '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="extVl' + i + '" style="margin-bottom: 3%;"><input type="text" onkeyup="calculate_pro_price()" name="extra_chargevalue[]"  placeholder="Extra Charges Value" id="floatvald' + i + '"  value="" class="form-control inptvl"></div>' +
            '<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1" id="rows' + i + '" style="margin-bottom: 3%;"><a href="javascript:void(0);" class="remove_additionalchg" id="' + i + '">X</a></div>';

         $("#putExtraVl").append(markup);
         $("#floatvald" + i + "").inputFilter(function(value) {
            return /^-?\d*[.,]?\d{0,2}$/.test(value);
         });

      });

      $(document).on('click', '.remove_additionalchg', function() {
         var button_id = $(this).attr("id");
         $("#ext" + button_id + ", #extVl" + button_id + ", #rows" + button_id).remove();
         $("#floatvald" + button_id).val("");
         calculate_pro_price()
      });
   });
</script>
<script>
   $(document).ready(function() {
      var i = 0;
      $("#add_terms_condition").click(function() {
         i++;
         var markup = '<div class="row" id="addterms' + i + '"> <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right">' +
            '<p>' + i + '.</p></div> <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10"> <input type="text" name="terms_condition[]" placeholder="Write Your Conditions">' +
            '</div><div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1"> <a href="javascript:void(0);" class="remove_terms" id="' + i + '">X</a></div> </div>';

         $("#terms_condition").append(markup);
         countPtg();
      });

      // Find and remove selected table rows
      $("#terms_condition").on('click', '.remove_terms', function() {
         var button_id = $(this).attr("id");
         $("#addterms" + button_id + "").remove();
         countPtg();

      });

      function countPtg() {
         var arr = $('#terms_condition p');
         var cnt = 1;
         for (i = 0; i < arr.length; i++) {
            $(arr[i]).html(cnt + ".");
            cnt++;
         }
      }



   });
</script>
<script>
   $('.add_terms').click(function() {
      $('#show_terms').show();
      $('.add_terms').hide();
   });
   <?php if (isset($record['terms_condition'])) { ?>
      $('#show_terms').show();
      $('.add_terms').hide();
   <?php } ?>
</script>