<div class="modal fade" id="modalOpenForProduct">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Add Product</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form class="business_detail_form" action="" id="productForm">
            <input type="hidden" id="pronameid" >
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Product :</label>
                <input type="text" name="proname" id="proname" class="form-control onlyLetters" placeholder="Enter Product Name">
              </div>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">SKU :</label>
                <input type="text" name="prosku" id="prosku" placeholder="Enter SKU Here" class="form-control">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">HSN Code :</label>
                <input type="text" name="prohsn" id="prohsn" placeholder="Enter HSN Code Here" class="form-control">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">ISBN Code :</label>
                <input type="text" name="proisbn" id="proisbn" placeholder="Enter isbn Code Here" class="form-control" >
              </div>
            </div>
			<div class="col-xl-6 col-lg-16 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Unit Price/rate :</label>
                <input type="text" name="proprice" id="proprice" placeholder="Product Price" value="0" class="form-control numeric">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">GST on product :</label>
                <select name="proGST" id="proGST" class="form-control ">
                    <option value="12">12% GST</option>
                    <option value="18">18% GST</option>
                    <option value="28">28% GST</option>
                    <option value="VAT">VAT</option>
                 </select>
              </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <label for="">About Product :</label>
                <textarea name="prodesc" id="prodesc" placeholder="Write Description" class="form-control"></textarea>
              </div>
            </div>
          </div>
          <button class="btn btn-info" style="float:right;" type="button" id="productSave" onclick="addProduct()">Add Product</button>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
function getproductinfo() {
   $('.productItm').autocomplete({
      source: "<?= base_url('product_manager/autocomplete_product');?>",
      select: function (event, ui) {
         if (ui.item.data == 2) {
            var proid = $(this).attr('id');
            $("#" + proid).val('');
            openMOdal(proid, ui.item.name);
         } else {
            $(this).val(ui.item.label);
            var dataro = $(this).data('cntid');
            var pro_name = $(this).val();
            $.ajax({
               url: "<?= base_url('product_manager/get_pro_details'); ?>",
               method: 'post',
               data: {
                  product_name: pro_name
               },
               dataType: 'json',
               success: function (response) {
                  var len = response.length;
                  if (len > 0) {
                     var quantity = $("#qty" + dataro).val();
                     var price = $("#price" + dataro).val();
                     if (quantity == "" || quantity == 0) {
                        $("#qty" + dataro).val(1);
                     } else {
                        $("#qty" + dataro).val(quantity);
                     }

                     var pro_gstData = response[0].pro_gst;
                     $("#gst" + dataro).val(pro_gstData);

                     var pro_hsn_codeData = response[0].hsn_code;
                     $("#hsn" + dataro).val(pro_hsn_codeData);

                     var pro_skuData = response[0].sku;
                     $("#sku" + dataro).val(pro_skuData);

                     var product_description = response[0].product_description;
                     $("#description" + dataro).val(product_description);
                     if (price == "" || price == 0) {
                        var product_unit_price = response[0].product_unit_price;
                        price = product_unit_price.replace(/,/g, "");
                        var pricetwo = numberToIndPrice(price);
                        $("#price" + dataro).val(pricetwo);
                     }
                     calculate_pro_price();

                  }

               }
            });

            //});
         }
      }
   });

}
function openMOdal(proid, name) {
   $('#proname').val(name);
   $('#pronameid').val(proid);
   setTimeout(function () {
      $("#" + proid).val(name);
   }, 200);
   $("#modalOpenForProduct").modal('show');
}
function checkValidationPRo() {

   var proname = $('#proname').val();
   var proprice = $('#proprice').val();
   var prodesc = $('#prodesc').val();
   var proGST = $('#proGST').val();

   if (proname == "" || proname === undefined) {
      changeClr('proname');
      return false;
   } else if (proprice == "" || proprice === undefined) {
      changeClr('proprice');
      return false;
   }
   /*else if(prodesc=="" || prodesc===undefined){
         changeClr('prodesc');
         return false;
       }*/
   else if (proGST == "" || proGST === undefined) {
      changeClr('proGST');
      return false;
   } else {
      return true;
   }
}
function addProduct() {
   if (checkValidationPRo() == true) {
      $('#productSave').text('saving...'); //change button text
      $('#productSave').attr('disabled', true); //set button disable
      var url;
      url = "<?= base_url('product_manager/createFromInvoice')?>";
      $.ajax({
         url: url,
         type: "POST",
         data: $('#productForm').serialize(),
         dataType: "JSON",
         success: function (data) {
            if (data.status) {
               var ids = $('#pronameid').val();
               var proname = $('#proname').val();
               var proprice = $('#proprice').val();
               var prohsn = $('#prohsn').val();
               var proGST = $('#proGST').val();
               var desc = $('#prodesc').val();
               var sku = $('#prosku').val();
               $('#' + ids).val(proname);
               $('#' + ids + 'hsn').val(prohsn);
               $('#' + ids + 'sku').val(sku);
               $('#' + ids + 'gst').val(proGST);
               $('#' + ids + 'price').val(proprice);
               $('#' + ids + 'desc').val(desc);
               calculate_pro_price();
               toastr.success('Product has been added successfully.');
               $("#modalOpenForProduct").modal('hide');
               $('#productForm')[0].reset();
            }
            $('#productSave').text('Add Product'); //change button text
            $('#productSave').attr('disabled', false); //set button enable
            if (data.st == 202) {
               toastr.error('Something went wrong, Please try later.');
               $('#productSave').text('save');
               $('#productSave').attr('disabled', false);
            }
         },
         error: function (jqXHR, textStatus, errorThrown) {
            toastr.error('Something went wrong, Please try later.');
            $('#productSave').text('save'); //change button text
            $('#productSave').attr('disabled', false); //set button enable
         }
      });
   }
}
function rmrow(firstrow, secondrow) {
   $("#" + firstrow).remove();
   $("#" + secondrow).remove();
   calculate_pro_price();
}
$('.form-control').keypress(function () {
   $(this).css('border-color', '')
});
$('.form-control').change(function () {
   $(this).css('border-color', '')
});
function fetchGSTList() {
  $.ajax({
    url: '<?php echo base_url('Setting/fetch_gst_list')?>',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.error) {
        console.error(response.error);
        // Handle the error if needed
      } else {
        var data = response.data;
        var select = $('#proGST');
        select.empty(); // Clear existing options
        
        if (data && data.length > 0) {
          $.each(data, function(index, item) {
            // Assuming your data has 'value' and 'text' properties
            select.append($('<option>', {
                value: item.gst_percentage,
                text: item.gst_percentage + '% ' + item.tax_name
            }));

          });
        } else {
          // If no data is available, set default options
          select.html(
            '<option value="12">12% GST</option>' +
            '<option value="18">18% GST</option>' +
            '<option value="28">28% GST</option>' +
            '<option value="VAT">VAT</option>'
          );
        }
      }
    },
    error: function(xhr, status, error) {
      console.error(error);
      // Handle the error if needed
    }
  });
}

$(document).ready(function() {
  // Call the fetchGSTList function to initiate the request
  fetchGSTList();
});


</script>