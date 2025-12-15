$(".hamburger").click(function(){
   $(".wrapper").toggleClass("collapse1");
});


var dropdown = document.getElementsByClassName("dropdownbtn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}




$('.targetDiv').hide();
$('.show').click(function () {
    $('.targetDiv').hide();
    $('#div' + $(this).attr('target')).show();
});

function calculate()
{
    $(document).ready(function() {
    $(".start").each(function() {
        var grandTotal = 0;
        var igst12 = 0;
        var igst18 = 0;
        var igst28 = 0;
        var gst12 = 0;
        var gst18 = 0;
        var gst28 = 0;
        var output1 = 0;
        var output2 = 0;
        var output3 = 0;
        var igst12_amnt = 0;
        var igst18_amnt = 0;
        var igst28_amnt = 0;
        var cgst6_amnt = 0;
        var sgst6_amnt = 0;
        var cgst9_amnt = 0;
        var sgst9_amnt = 0;
        var cgst14_amnt = 0;
        var sgst14_amnt = 0;
        var total_est_purchase_price = 0;
        var profit_margin = 0;
        //var total_orc = document.getElementById('total_orc').value;
        var type = document.getElementById('type').value;
        $("input[name='quantity[]']").each(function (index) {
            var quantity = $("input[name='quantity[]']").eq(index).val();
            var price = $("input[name='unit_price[]']").eq(index).val();
            var gst = $("input[name='gst[]']").eq(index).val();
            var output = parseInt(quantity) * parseFloat(price);
            var tax = parseFloat(output) * parseFloat(gst)/100;
            // estimate product price
            // var estimate_pro_price = $("input[name='estimate_purchase_price[]']").eq(index).val();
            // var initial_est_purchase_price = parseInt(quantity) * parseFloat(estimate_pro_price);

            // if(!isNaN(initial_est_purchase_price))
            // {
            //     $("input[name='initial_est_purchase_price[]']").eq(index).val(initial_est_purchase_price.toFixed(2));
            //     total_est_purchase_price = parseFloat(total_est_purchase_price) + parseFloat(initial_est_purchase_price);
            //     $('#total_est_purchase_price').val(total_est_purchase_price.toFixed(2));
            //
            // }

            $("input[name='tax[]']").eq(index).val(tax.toFixed(2));
            if (!isNaN(output))
            {
                $("input[name='total[]']").eq(index).val(output.toFixed(2));
                grandTotal = parseFloat(grandTotal) + parseFloat(output);
                $('#initial_total').val(grandTotal.toFixed(2));
                var initial_total = document.getElementById('initial_total').value;
                var discount = document.getElementById('discount').value;
                var after_discount = parseFloat(initial_total) - parseFloat(discount);
                var count = $('#add tr').length;
                var test_val = document.getElementById('test_val').value;
                var percent = test_val/parseFloat(count);
                $("input[name='percent[]']").eq(index).val(percent.toFixed(2));


                // if(total_orc!='')
                // {
                //     profit_margin = parseFloat(after_discount) - parseFloat(total_orc) - parseFloat(total_est_purchase_price);
                //     $("#profit_by_user").val(profit_margin.toFixed(2));
                // }
                // else
                // {
                //     profit_margin = parseFloat(after_discount) - parseFloat(total_est_purchase_price);
                //     $("#profit_by_user").val(profit_margin.toFixed(2));
                // }

                if (!isNaN(after_discount))
                {
                    document.getElementById('after_discount').value = after_discount.toFixed(2);
                    if(type == 'Interstate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#igst12_val').text(igst12.toFixed(2));
                                $('#igst12_val_hidden').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#igst18_val').text(igst18.toFixed(2));
                                $('#igst18_val_hidden').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#igst28_val').text(igst28.toFixed(2));
                              $('#igst28_val_hidden').val(igst28.toFixed(2));
                            }
                        }
                        var igst12_amnt = parseFloat(igst12) * 12/100;
                        var igst18_amnt = parseFloat(igst18) * 18/100;
                        var igst28_amnt = parseFloat(igst28) * 28/100;
                        $("#igst12_amnt").val(igst12_amnt.toFixed(2));
                        $("#igst18_amnt").val(igst18_amnt.toFixed(2));
                        $("#igst28_amnt").val(igst28_amnt.toFixed(2));
                        var igst12_amnt_val = $("#igst12_amnt").val();
                        var igst18_amnt_val = $("#igst18_amnt").val();
                        var igst28_amnt_val = $("#igst28_amnt").val();
                        var igst12_val =  document.getElementById('igst12_val_hidden').value;
                        var igst18_val =  document.getElementById('igst18_val_hidden').value;
                        var igst28_val =  document.getElementById('igst28_val_hidden').value;
                        if(igst12_amnt!=0 && igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/3;
                            igst12_tot_val = igst12 - tax_dics;
                            igst18_tot_val = igst18 - tax_dics;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden').text(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calulation
                            var last_igst12_amnt = $("#igst12_amnt").val();
                            var last_igst18_amnt = $("#igst18_amnt").val();
                            var last_igst28_amnt = $("#igst28_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);

                        }
                        else if(igst12_amnt!=0 && igst18_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst18_tot_val = igst18 - tax_dics;
                            $('#igst12_val').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val').text(igst18_tot_val.toFixed(2));
                            $('#igst12_val_hidden').val(igst12_tot_val.toFixed(2));
                            $('#igst18_val_hidden').val(igst18_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));
                            $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt").val();
                            var last_igst18_amnt = $("#igst18_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst18_tot_val = igst18 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst18_val').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val').text(igst28_tot_val.toFixed(2));
                            $('#igst18_val_hidden').val(igst18_tot_val.toFixed(2));
                            $('#igst28_val_hidden').val(igst28_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));
                            $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst18_amnt = $("#igst18_amnt").val();
                            var last_igst28_amnt = $("#igst28_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(igst12_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val').text(igst12_tot_val.toFixed(2));
                            $('#igst28_val').text(igst28_tot_val.toFixed(2));
                            $('#igst12_val_hidden').val(igst12_tot_val.toFixed(2));
                            $('#igst28_val_hidden').val(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));
                            $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst12_amnt = $("#igst12_amnt").val();
                            var last_igst28_amnt = $("#igst28_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(igst12_amnt!=0)
                        {
                            var tax_dics = discount;
                            var igst12_tot_val = igst12 - tax_dics;
                            $('#igst12_val').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden').val(igst12_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));

                             //subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);

                        }
                        else if(igst18_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst18_tot_val = igst18 - tax_dics;
                            $('#igst18_val').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden').val(igst18_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst18_amnt = $("#igst18_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);

                        }
                        else if(igst28_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst28_val').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden').val(igst28_tot_val.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst28_amnt = $("#igst28_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                    }
                    else if(type == 'Instate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#cgst6_val').text(igst12.toFixed(2));
                                $('#sgst6_val').text(igst12.toFixed(2));
                                $('#cgst6_val_hidden').val(igst12.toFixed(2));
                                $('#sgst6_val_hidden').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#cgst9_val').text(igst18.toFixed(2));
                                $('#sgst9_val').text(igst18.toFixed(2));
                                $('#cgst9_val_hidden').val(igst18.toFixed(2));
                                $('#sgst9_val_hidden').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#cgst14_val').text(igst28.toFixed(2));
                              $('#sgst14_val').text(igst28.toFixed(2));
                              $('#cgst14_val_hidden').val(igst28.toFixed(2));
                              $('#sgst14_val_hidden').val(igst28.toFixed(2));
                            }
                        }
                        var cgst6_amnt = parseFloat(igst12) * 6/100;
                        var sgst6_amnt = parseFloat(igst12) * 6/100;
                        var cgst9_amnt = parseFloat(igst18) * 9/100;
                        var sgst9_amnt = parseFloat(igst18) * 9/100;
                        var cgst14_amnt = parseFloat(igst28) * 14/100;
                        var sgst14_amnt = parseFloat(igst28) * 14/100;
                        $("#cgst6_amnt").val(cgst6_amnt.toFixed(2));
                        $("#sgst6_amnt").val(sgst6_amnt.toFixed(2));
                        $("#cgst9_amnt").val(cgst9_amnt.toFixed(2));
                        $("#sgst9_amnt").val(sgst9_amnt.toFixed(2));
                        $("#cgst14_amnt").val(cgst14_amnt.toFixed(2));
                        $("#sgst14_amnt").val(sgst14_amnt.toFixed(2));
                        if(parseFloat(cgst6_amnt) != 0 && parseFloat(cgst9_amnt) != 0 && parseFloat(cgst14_amnt) != 0)
                        {
                            var tax_dics = discount/3;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden').text(cgst6_tot_val.toFixed(2));
                            $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden').text(cgst9_tot_val.toFixed(2));
                            $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden').text(cgst14_tot_val.toFixed(2));
                            $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden').text(sgst6_tot_val.toFixed(2));
                            $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden').text(sgst9_tot_val.toFixed(2));
                            $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden').text(sgst14_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt").val();
                            var last_sgst6_amnt = $("#sgst6_amnt").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt").val();
                            var last_sgst9_amnt = $("#sgst9_amnt").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt").val();
                            var last_sgst14_amnt = $("#sgst14_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) +  parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst6_amnt!=0 && cgst9_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                            $('#cgst6_val_hidden').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden').val(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val_hidden').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden').val(sgst9_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt").val();
                            var last_sgst6_amnt = $("#sgst6_amnt").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt").val();
                            var last_sgst9_amnt = $("#sgst9_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst9_amnt!=0 && cgst14_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                            $('#cgst9_val_hidden').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden').val(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val_hidden').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden').val(sgst14_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt").val();
                            var last_sgst9_amnt = $("#sgst9_amnt").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt").val();
                            var last_sgst14_amnt = $("#sgst14_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst14_amnt!=0 && cgst6_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                            $('#cgst14_val_hidden').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden').val(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val_hidden').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden').val(sgst6_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                            $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt").val();
                            var last_sgst6_amnt = $("#sgst6_amnt").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt").val();
                            var last_sgst14_amnt = $("#sgst14_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst6_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden').val(sgst6_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt").val();
                            var last_sgst6_amnt = $("#sgst6_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst9_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden').val(sgst9_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt").val();
                            var last_sgst9_amnt = $("#sgst9_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst14_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden').val(sgst14_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst14_amnt =  $("#cgst14_amnt").val();
                            var last_sgst14_amnt = $("#sgst14_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                    }
                }
            }
        });
    });
});
} // calculate function ends here

function calculate_order()
{
    $(document).ready(function() {
    $(".start").each(function() {
        var grandTotal = 0;
        var igst12 = 0;
        var igst18 = 0;
        var igst28 = 0;
        var gst12 = 0;
        var gst18 = 0;
        var gst28 = 0;
        var output1 = 0;
        var output2 = 0;
        var output3 = 0;
        var igst12_amnt = 0;
        var igst18_amnt = 0;
        var igst28_amnt = 0;
        var cgst6_amnt = 0;
        var sgst6_amnt = 0;
        var cgst9_amnt = 0;
        var sgst9_amnt = 0;
        var cgst14_amnt = 0;
        var sgst14_amnt = 0;
        var total_est_purchase_price = 0;
        var profit_margin = 0;
        var total_orc = document.getElementById('total_orc').value;
        var type = document.getElementById('type').value;
        $("input[name='quantity[]']").each(function (index) {
            var quantity = $("input[name='quantity[]']").eq(index).val();
            var price = $("input[name='unit_price[]']").eq(index).val();
            var gst = $("input[name='gst[]']").eq(index).val();
            var output = parseInt(quantity) * parseFloat(price);
            var tax = parseFloat(output) * parseFloat(gst)/100;
            //estimate product price
            var estimate_pro_price = $("input[name='estimate_purchase_price[]']").eq(index).val();
            console.log(estimate_pro_price);
            var initial_est_purchase_price = parseInt(quantity) * parseFloat(estimate_pro_price);

            if(!isNaN(initial_est_purchase_price))
            {
                $("input[name='initial_est_purchase_price[]']").eq(index).val(initial_est_purchase_price.toFixed(2));
                total_est_purchase_price = parseFloat(total_est_purchase_price) + parseFloat(initial_est_purchase_price);
                $('#total_est_purchase_price').val(total_est_purchase_price.toFixed(2));
            
            }

            $("input[name='tax[]']").eq(index).val(tax.toFixed(2));
            if (!isNaN(output))
            {
                $("input[name='total[]']").eq(index).val(output.toFixed(2));
                grandTotal = parseFloat(grandTotal) + parseFloat(output);
                $('#initial_total').val(grandTotal.toFixed(2));
                var initial_total = document.getElementById('initial_total').value;
                var discount = document.getElementById('discount').value;
                var after_discount = parseFloat(initial_total) - parseFloat(discount);
                var count = $('#add tr').length;
                var test_val = document.getElementById('test_val').value;
                var percent = test_val/parseFloat(count);
                $("input[name='percent[]']").eq(index).val(percent.toFixed(2));


                if(total_orc!='')
                {
                    profit_margin = parseFloat(after_discount) - parseFloat(total_orc) - parseFloat(total_est_purchase_price);
                    $("#profit_by_user").val(profit_margin.toFixed(2));
                }
                else
                {
                    profit_margin = parseFloat(after_discount) - parseFloat(total_est_purchase_price);
                    $("#profit_by_user").val(profit_margin.toFixed(2));
                }

                if (!isNaN(after_discount))
                {
                    document.getElementById('after_discount').value = after_discount.toFixed(2);
                    if(type == 'Interstate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#igst12_val').text(igst12.toFixed(2));
                                $('#igst12_val_hidden').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#igst18_val').text(igst18.toFixed(2));
                                $('#igst18_val_hidden').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#igst28_val').text(igst28.toFixed(2));
                              $('#igst28_val_hidden').val(igst28.toFixed(2));
                            }
                        }
                        var igst12_amnt = parseFloat(igst12) * 12/100;
                        var igst18_amnt = parseFloat(igst18) * 18/100;
                        var igst28_amnt = parseFloat(igst28) * 28/100;
                        $("#igst12_amnt").val(igst12_amnt.toFixed(2));
                        $("#igst18_amnt").val(igst18_amnt.toFixed(2));
                        $("#igst28_amnt").val(igst28_amnt.toFixed(2));
                        var igst12_amnt_val = $("#igst12_amnt").val();
                        var igst18_amnt_val = $("#igst18_amnt").val();
                        var igst28_amnt_val = $("#igst28_amnt").val();
                        var igst12_val =  document.getElementById('igst12_val_hidden').value;
                        var igst18_val =  document.getElementById('igst18_val_hidden').value;
                        var igst28_val =  document.getElementById('igst28_val_hidden').value;
                        if(igst12_amnt!=0 && igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/3;
                            igst12_tot_val = igst12 - tax_dics;
                            igst18_tot_val = igst18 - tax_dics;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden').text(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calulation
                            var last_igst12_amnt = $("#igst12_amnt").val();
                            var last_igst18_amnt = $("#igst18_amnt").val();
                            var last_igst28_amnt = $("#igst28_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);

                        }
                        else if(igst12_amnt!=0 && igst18_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst18_tot_val = igst18 - tax_dics;
                            $('#igst12_val').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val').text(igst18_tot_val.toFixed(2));
                            $('#igst12_val_hidden').val(igst12_tot_val.toFixed(2));
                            $('#igst18_val_hidden').val(igst18_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));
                            $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt").val();
                            var last_igst18_amnt = $("#igst18_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst18_tot_val = igst18 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst18_val').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val').text(igst28_tot_val.toFixed(2));
                            $('#igst18_val_hidden').val(igst18_tot_val.toFixed(2));
                            $('#igst28_val_hidden').val(igst28_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));
                            $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst18_amnt = $("#igst18_amnt").val();
                            var last_igst28_amnt = $("#igst28_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(igst12_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val').text(igst12_tot_val.toFixed(2));
                            $('#igst28_val').text(igst28_tot_val.toFixed(2));
                            $('#igst12_val_hidden').val(igst12_tot_val.toFixed(2));
                            $('#igst28_val_hidden').val(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));
                            $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst12_amnt = $("#igst12_amnt").val();
                            var last_igst28_amnt = $("#igst28_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(igst12_amnt!=0)
                        {
                            var tax_dics = discount;
                            var igst12_tot_val = igst12 - tax_dics;
                            $('#igst12_val').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden').val(igst12_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt").val(igst12_aftr_disc.toFixed(2));

                             //subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);

                        }
                        else if(igst18_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst18_tot_val = igst18 - tax_dics;
                            $('#igst18_val').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden').val(igst18_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt").val(igst18_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst18_amnt = $("#igst18_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);

                        }
                        else if(igst28_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst28_val').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden').val(igst28_tot_val.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst28_amnt = $("#igst28_amnt").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                    }
                    else if(type == 'Instate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#cgst6_val').text(igst12.toFixed(2));
                                $('#sgst6_val').text(igst12.toFixed(2));
                                $('#cgst6_val_hidden').val(igst12.toFixed(2));
                                $('#sgst6_val_hidden').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#cgst9_val').text(igst18.toFixed(2));
                                $('#sgst9_val').text(igst18.toFixed(2));
                                $('#cgst9_val_hidden').val(igst18.toFixed(2));
                                $('#sgst9_val_hidden').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#cgst14_val').text(igst28.toFixed(2));
                              $('#sgst14_val').text(igst28.toFixed(2));
                              $('#cgst14_val_hidden').val(igst28.toFixed(2));
                              $('#sgst14_val_hidden').val(igst28.toFixed(2));
                            }
                        }
                        var cgst6_amnt = parseFloat(igst12) * 6/100;
                        var sgst6_amnt = parseFloat(igst12) * 6/100;
                        var cgst9_amnt = parseFloat(igst18) * 9/100;
                        var sgst9_amnt = parseFloat(igst18) * 9/100;
                        var cgst14_amnt = parseFloat(igst28) * 14/100;
                        var sgst14_amnt = parseFloat(igst28) * 14/100;
                        $("#cgst6_amnt").val(cgst6_amnt.toFixed(2));
                        $("#sgst6_amnt").val(sgst6_amnt.toFixed(2));
                        $("#cgst9_amnt").val(cgst9_amnt.toFixed(2));
                        $("#sgst9_amnt").val(sgst9_amnt.toFixed(2));
                        $("#cgst14_amnt").val(cgst14_amnt.toFixed(2));
                        $("#sgst14_amnt").val(sgst14_amnt.toFixed(2));
                        if(parseFloat(cgst6_amnt) != 0 && parseFloat(cgst9_amnt) != 0 && parseFloat(cgst14_amnt) != 0)
                        {
                            var tax_dics = discount/3;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden').text(cgst6_tot_val.toFixed(2));
                            $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden').text(cgst9_tot_val.toFixed(2));
                            $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden').text(cgst14_tot_val.toFixed(2));
                            $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden').text(sgst6_tot_val.toFixed(2));
                            $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden').text(sgst9_tot_val.toFixed(2));
                            $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden').text(sgst14_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt").val();
                            var last_sgst6_amnt = $("#sgst6_amnt").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt").val();
                            var last_sgst9_amnt = $("#sgst9_amnt").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt").val();
                            var last_sgst14_amnt = $("#sgst14_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) +  parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst6_amnt!=0 && cgst9_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                            $('#cgst6_val_hidden').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden').val(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val_hidden').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden').val(sgst9_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt").val();
                            var last_sgst6_amnt = $("#sgst6_amnt").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt").val();
                            var last_sgst9_amnt = $("#sgst9_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst9_amnt!=0 && cgst14_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                            $('#cgst9_val_hidden').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden').val(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val_hidden').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden').val(sgst14_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt").val();
                            var last_sgst9_amnt = $("#sgst9_amnt").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt").val();
                            var last_sgst14_amnt = $("#sgst14_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst14_amnt!=0 && cgst6_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                            $('#cgst14_val_hidden').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden').val(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val_hidden').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden').val(sgst6_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                            $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt").val();
                            var last_sgst6_amnt = $("#sgst6_amnt").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt").val();
                            var last_sgst14_amnt = $("#sgst14_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst6_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst6_val').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val').text(sgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden').val(sgst6_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt").val(cgst6_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt").val();
                            var last_sgst6_amnt = $("#sgst6_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst9_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst9_val').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val').text(sgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden').val(sgst9_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt").val();
                            var last_sgst9_amnt = $("#sgst9_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(cgst14_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst14_val').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val').text(sgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden').val(sgst14_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt").val(cgst14_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst14_amnt =  $("#cgst14_amnt").val();
                            var last_sgst14_amnt = $("#sgst14_amnt").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                    }
                }
            }
        });
    });
});
}


function selectgst() 
{
    $('#igst12').hide();
    $('#igst18').hide();
    $('#igst28').hide();
    $('#cgst6').hide();
    $('#sgst6').hide();
    $('#cgst9').hide();
    $('#sgst9').hide();
    $('#cgst14').hide();
    $('#sgst14').hide();
    $('#type').change(function(){
        if($('#type').val() == 'Instate') {
            $('#igst12').hide();
            $('#igst18').hide();
            $('#igst28').hide();
            $('#cgst6').show();
            $('#sgst6').show();
            $('#cgst9').show();
            $('#sgst9').show();
            $('#cgst14').show();
            $('#sgst14').show();
        } else if($('#type').val() == 'Interstate') {
            $('#igst12').show();
            $('#igst18').show();
            $('#igst28').show();
            $('#cgst6').hide();
            $('#sgst6').hide();
            $('#cgst9').hide();
            $('#sgst9').hide();
            $('#cgst14').hide();
            $('#sgst14').hide();
        } else {
            $('#igst12').hide();
            $('#igst18').hide();
            $('#igst28').hide();
            $('#cgst6').hide();
            $('#sgst6').hide();
            $('#cgst9').hide();
            $('#sgst9').hide();
            $('#cgst14').hide();
            $('#sgst14').hide();
        }
    });
}
function calculate_quote_opp()
{
    $(document).ready(function() {
    $(".start").each(function() {
        var grandTotal = 0;
        var igst12 = 0;
        var igst18 = 0;
        var igst28 = 0;
        var gst12 = 0;
        var gst18 = 0;
        var gst28 = 0;
        var output1 = 0;
        var output2 = 0;
        var output3 = 0;
        var igst12_amnt = 0;
        var igst18_amnt = 0;
        var igst28_amnt = 0;
        var cgst6_amnt = 0;
        var sgst6_amnt = 0;
        var cgst9_amnt = 0;
        var sgst9_amnt = 0;
        var cgst14_amnt = 0;
        var sgst14_amnt = 0;
        var total_est_purchase_price = 0;
        var profit_margin = 0;
        var type = document.getElementById('type_tax').value;
        $("input[name='quantity_q[]']").each(function (index) {
            var quantity = $("input[name='quantity_q[]']").eq(index).val();
            var price = $("input[name='unit_price_q[]']").eq(index).val();
            var gst = $("input[name='gst_q[]']").eq(index).val();
            var output = parseInt(quantity) * parseFloat(price);
            var tax = parseFloat(output) * parseFloat(gst)/100;
    
            $("input[name='tax[]']").eq(index).val(tax.toFixed(2));
            if (!isNaN(output))
            {
                $("input[name='total_q[]']").eq(index).val(output.toFixed(2));
                grandTotal = parseFloat(grandTotal) + parseFloat(output);
                $('#initial_total_q').val(grandTotal.toFixed(2));
                var initial_total = document.getElementById('initial_total_q').value;
                var discount = document.getElementById('discount_q').value;
                var after_discount = parseFloat(initial_total) - parseFloat(discount);
                var count = $('#add_qt tr').length;
                var test_val = document.getElementById('test_val_q').value;
                var percent = test_val/parseFloat(count);
                $("input[name='percen_q[]']").eq(index).val(percent.toFixed(2));
                
                if (!isNaN(after_discount))
                {
                    document.getElementById('after_discount_q').value = after_discount.toFixed(2);
                    if(type == 'Interstate')
                    {
                        if (gst == 12)
                        {

                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#igst12_val_q').text(igst12.toFixed(2));
                                $('#igst12_val_hidden_q').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#igst18_val_q').text(igst18.toFixed(2));
                                $('#igst18_val_hidden_q').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#igst28_val_q').text(igst28.toFixed(2));
                              $('#igst28_val_hidden_q').val(igst28.toFixed(2));
                            }
                        }
                        var igst12_amnt = parseFloat(igst12) * 12/100;
                        var igst18_amnt = parseFloat(igst18) * 18/100;
                        var igst28_amnt = parseFloat(igst28) * 28/100;
                        $("#igst12_amnt_q").val(igst12_amnt.toFixed(2));
                        $("#igst18_amnt_q").val(igst18_amnt.toFixed(2));
                        $("#igst28_amnt_q").val(igst28_amnt.toFixed(2));
                        var igst12_amnt_val = $("#igst12_amnt_q").val();
                        var igst18_amnt_val = $("#igst18_amnt_q").val();
                        var igst28_amnt_val = $("#igst28_amnt_q").val();
                        var igst12_val =  document.getElementById('igst12_val_hidden_q').value;
                        var igst18_val =  document.getElementById('igst18_val_hidden_q').value;
                        var igst28_val =  document.getElementById('igst28_val_hidden_q').value;
                        if(igst12_amnt!=0 && igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/3;
                            igst12_tot_val = igst12 - tax_dics;
                            igst18_tot_val = igst18 - tax_dics;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val_q').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden_q').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val_q').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden_q').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val_q').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden_q').text(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt_q").val(igst12_aftr_disc.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt_q").val(igst18_aftr_disc.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt_q").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calulation
                            var last_igst12_amnt = $("#igst12_amnt_q").val();
                            var last_igst18_amnt = $("#igst18_amnt_q").val();
                            var last_igst28_amnt = $("#igst28_amnt_q").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);

                        }
                        else if(igst12_amnt!=0 && igst18_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst18_tot_val = igst18 - tax_dics;
                            $('#igst12_val_q').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val_q').text(igst18_tot_val.toFixed(2));
                            $('#igst12_val_hidden_q').val(igst12_tot_val.toFixed(2));
                            $('#igst18_val_hidden_q').val(igst18_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst12_amnt_q").val(igst12_aftr_disc.toFixed(2));
                            $("#igst18_amnt_q").val(igst18_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt_q").val();
                            var last_igst18_amnt = $("#igst18_amnt_q").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                        else if(igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst18_tot_val = igst18 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst18_val_q').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val_q').text(igst28_tot_val.toFixed(2));
                            $('#igst18_val_hidden_q').val(igst18_tot_val.toFixed(2));
                            $('#igst28_val_hidden_q').val(igst28_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst18_amnt_q").val(igst18_aftr_disc.toFixed(2));
                            $("#igst28_amnt_q").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst18_amnt = $("#igst18_amnt_q").val();
                            var last_igst28_amnt = $("#igst28_amnt_q").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                        else if(igst12_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val_q').text(igst12_tot_val.toFixed(2));
                            $('#igst28_val_q').text(igst28_tot_val.toFixed(2));
                            $('#igst12_val_hidden_q').val(igst12_tot_val.toFixed(2));
                            $('#igst28_val_hidden_q').val(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst12_amnt_q").val(igst12_aftr_disc.toFixed(2));
                            $("#igst28_amnt_q").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst12_amnt = $("#igst12_amnt_q").val();
                            var last_igst28_amnt = $("#igst28_amnt_q").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                        else if(igst12_amnt!=0)
                        {
                            var tax_dics = discount;
                            var igst12_tot_val = igst12 - tax_dics;
                            $('#igst12_val_q').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden_q').val(igst12_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt_q").val(igst12_aftr_disc.toFixed(2));

                             //subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt_q").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);

                        }
                        else if(igst18_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst18_tot_val = igst18 - tax_dics;
                            $('#igst18_val_q').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden_q').val(igst18_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt_q").val(igst18_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst18_amnt = $("#igst18_amnt_q").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);

                        }
                        else if(igst28_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst28_val_q').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden_q').val(igst28_tot_val.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt_q").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst28_amnt = $("#igst28_amnt_q").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                    }
                    else if(type == 'Instate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#cgst6_val_q').text(igst12.toFixed(2));
                                $('#sgst6_val_q').text(igst12.toFixed(2));
                                $('#cgst6_val_hidden_q').val(igst12.toFixed(2));
                                $('#sgst6_val_hidden_q').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#cgst9_val_q').text(igst18.toFixed(2));
                                $('#sgst9_val_q').text(igst18.toFixed(2));
                                $('#cgst9_val_hidden_q').val(igst18.toFixed(2));
                                $('#sgst9_val_hidden_q').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#cgst14_val_q').text(igst28.toFixed(2));
                              $('#sgst14_val_q').text(igst28.toFixed(2));
                              $('#cgst14_val_hidden_q').val(igst28.toFixed(2));
                              $('#sgst14_val_hidden_q').val(igst28.toFixed(2));
                            }
                        }
                        var cgst6_amnt = parseFloat(igst12) * 6/100;
                        var sgst6_amnt = parseFloat(igst12) * 6/100;
                        var cgst9_amnt = parseFloat(igst18) * 9/100;
                        var sgst9_amnt = parseFloat(igst18) * 9/100;
                        var cgst14_amnt = parseFloat(igst28) * 14/100;
                        var sgst14_amnt = parseFloat(igst28) * 14/100;
                        $("#cgst6_amnt_q").val(cgst6_amnt.toFixed(2));
                        $("#sgst6_amnt_q").val(sgst6_amnt.toFixed(2));
                        $("#cgst9_amnt_q").val(cgst9_amnt.toFixed(2));
                        $("#sgst9_amnt_q").val(sgst9_amnt.toFixed(2));
                        $("#cgst14_amnt_q").val(cgst14_amnt.toFixed(2));
                        $("#sgst14_amnt_q").val(sgst14_amnt.toFixed(2));
                        if(parseFloat(cgst6_amnt) != 0 && parseFloat(cgst9_amnt) != 0 && parseFloat(cgst14_amnt) != 0)
                        {
                            var tax_dics = discount/3;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst6_val_q').text(cgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_q').text(cgst6_tot_val.toFixed(2));
                            $('#cgst9_val_q').text(cgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_q').text(cgst9_tot_val.toFixed(2));
                            $('#cgst14_val_q').text(cgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_q').text(cgst14_tot_val.toFixed(2));
                            $('#sgst6_val_q').text(sgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_q').text(sgst6_tot_val.toFixed(2));
                            $('#sgst9_val_q').text(sgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_q').text(sgst9_tot_val.toFixed(2));
                            $('#sgst14_val_q').text(sgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_q').text(sgst14_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt_q").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_q").val(cgst6_aftr_disc.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt_q").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_q").val(cgst9_aftr_disc.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt_q").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_q").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_q").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_q").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt_q").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_q").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_q").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_q").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) +  parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                        else if(cgst6_amnt!=0 && cgst9_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst6_val_q').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_q').text(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val_q').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_q').text(sgst9_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_q').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_q').val(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_q').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_q').val(sgst9_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst6_amnt_q").val(cgst6_aftr_disc.toFixed(2));
                            $("#cgst9_amnt_q").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_q").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_q").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_q").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_q").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt_q").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_q").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                        else if(cgst9_amnt!=0 && cgst14_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst9_val_q').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_q').text(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val_q').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_q').text(sgst14_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_q').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_q').val(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_q').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_q').val(sgst14_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst9_amnt_q").val(cgst9_aftr_disc.toFixed(2));
                            $("#cgst14_amnt_q").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_q").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_q").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt_q").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_q").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_q").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_q").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                        else if(cgst14_amnt!=0 && cgst6_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst14_val_q').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_q').text(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val_q').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_q').text(sgst6_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_q').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_q').val(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_q').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_q').val(sgst6_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst14_amnt_q").val(cgst14_aftr_disc.toFixed(2));
                            $("#cgst6_amnt_q").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_q").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_q").val(cgst6_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_q").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_q").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_q").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_q").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                        else if(cgst6_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst6_val_q').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_q').text(sgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_q').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_q').val(sgst6_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt_q").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_q").val(cgst6_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_q").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_q").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                        else if(cgst9_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst9_val_q').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_q').text(sgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_q').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_q').val(sgst9_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt_q").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_q").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt_q").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_q").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                        else if(cgst14_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst14_val_q').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_q').text(sgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_q').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_q').val(sgst14_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt_q").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_q").val(cgst14_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst14_amnt =  $("#cgst14_amnt_q").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_q").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt);
                            document.getElementById('sub_total_q').value = sub_total.toFixed(2);
                        }
                    }
                }
            }
        });
    });
});
} // calculate function for opportunity page quotation ends here
// function for quotation saleorder
function calculate_so_quote()
{
    $(document).ready(function() {
    $(".start").each(function() {
        var grandTotal = 0;
        var igst12 = 0;
        var igst18 = 0;
        var igst28 = 0;
        var gst12 = 0;
        var gst18 = 0;
        var gst28 = 0;
        var output1 = 0;
        var output2 = 0;
        var output3 = 0;
        var igst12_amnt = 0;
        var igst18_amnt = 0;
        var igst28_amnt = 0;
        var cgst6_amnt = 0;
        var sgst6_amnt = 0;
        var cgst9_amnt = 0;
        var sgst9_amnt = 0;
        var cgst14_amnt = 0;
        var sgst14_amnt = 0;
        var total_est_purchase_price = 0;
        var profit_margin = 0;
        var total_orc = document.getElementById('total_orc_so').value;
        var type = document.getElementById('type_so').value;
        $("input[name='quantity_so[]']").each(function (index) {
            var quantity = $("input[name='quantity_so[]']").eq(index).val();
            var price = $("input[name='unit_price_so[]']").eq(index).val();
            var gst = $("input[name='gst_so[]']").eq(index).val();
            var output = parseInt(quantity) * parseFloat(price);
            var tax = parseFloat(output) * parseFloat(gst)/100;
            //estimate product price
            var estimate_pro_price = $("input[name='estimate_purchase_price_so[]']").eq(index).val();
            var initial_est_purchase_price = parseInt(quantity) * parseFloat(estimate_pro_price);

            if(!isNaN(initial_est_purchase_price))
            {
                $("input[name='initial_est_purchase_price_so[]']").eq(index).val(initial_est_purchase_price.toFixed(2));
                total_est_purchase_price = parseFloat(total_est_purchase_price) + parseFloat(initial_est_purchase_price);
                $('#total_est_purchase_price_so').val(total_est_purchase_price.toFixed(2));
            
            }

            $("input[name='tax[]']").eq(index).val(tax.toFixed(2));
            if (!isNaN(output))
            {
                $("input[name='total_so[]']").eq(index).val(output.toFixed(2));
                grandTotal = parseFloat(grandTotal) + parseFloat(output);
                $('#initial_total_so').val(grandTotal.toFixed(2));
                var initial_total = document.getElementById('initial_total_so').value;
                var discount = document.getElementById('discount_so').value;
                var after_discount = parseFloat(initial_total) - parseFloat(discount);
                var count = $('#add_so tr').length;
                var test_val = document.getElementById('test_val_so').value;
                var percent = test_val/parseFloat(count);
                $("input[name='percent_so[]']").eq(index).val(percent.toFixed(2));


                if(total_orc!='')
                {
                    profit_margin = parseFloat(after_discount) - parseFloat(total_orc) - parseFloat(total_est_purchase_price);
                    $("#profit_by_user").val(profit_margin.toFixed(2));
                }
                else
                {
                    profit_margin = parseFloat(after_discount) - parseFloat(total_est_purchase_price);
                    $("#profit_by_user").val(profit_margin.toFixed(2));
                }

                if (!isNaN(after_discount))
                {
                    document.getElementById('after_discount_so').value = after_discount.toFixed(2);
                    if(type == 'Interstate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#igst12_val_so').text(igst12.toFixed(2));
                                $('#igst12_val_hidden_so').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#igst18_val_so').text(igst18.toFixed(2));
                                $('#igst18_val_hidden_so').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#igst28_val_so').text(igst28.toFixed(2));
                              $('#igst28_val_hidden_so').val(igst28.toFixed(2));
                            }
                        }
                        var igst12_amnt = parseFloat(igst12) * 12/100;
                        var igst18_amnt = parseFloat(igst18) * 18/100;
                        var igst28_amnt = parseFloat(igst28) * 28/100;
                        $("#igst12_amnt_so").val(igst12_amnt.toFixed(2));
                        $("#igst18_amnt_so").val(igst18_amnt.toFixed(2));
                        $("#igst28_amnt_so").val(igst28_amnt.toFixed(2));
                        var igst12_amnt_val = $("#igst12_amnt_so").val();
                        var igst18_amnt_val = $("#igst18_amnt_so").val();
                        var igst28_amnt_val = $("#igst28_amnt_so").val();
                        var igst12_val =  document.getElementById('igst12_val_hidden_so').value;
                        var igst18_val =  document.getElementById('igst18_val_hidden_so').value;
                        var igst28_val =  document.getElementById('igst28_val_hidden_so').value;
                        if(igst12_amnt!=0 && igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/3;
                            igst12_tot_val = igst12 - tax_dics;
                            igst18_tot_val = igst18 - tax_dics;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val_so').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden_so').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val_so').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden_so').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val_so').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden_so').text(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt_so").val(igst12_aftr_disc.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt_so").val(igst18_aftr_disc.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt_so").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calulation
                            var last_igst12_amnt = $("#igst12_amnt_so").val();
                            var last_igst18_amnt = $("#igst18_amnt_so").val();
                            var last_igst28_amnt = $("#igst28_amnt_so").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);

                        }
                        else if(igst12_amnt!=0 && igst18_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst18_tot_val = igst18 - tax_dics;
                            $('#igst12_val_so').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val_so').text(igst18_tot_val.toFixed(2));
                            $('#igst12_val_hidden_so').val(igst12_tot_val.toFixed(2));
                            $('#igst18_val_hidden_so').val(igst18_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst12_amnt_so").val(igst12_aftr_disc.toFixed(2));
                            $("#igst18_amnt_so").val(igst18_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt_so").val();
                            var last_igst18_amnt = $("#igst18_amnt_so").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst18_tot_val = igst18 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst18_val_so').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val_so').text(igst28_tot_val.toFixed(2));
                            $('#igst18_val_hidden_so').val(igst18_tot_val.toFixed(2));
                            $('#igst28_val_hidden_so').val(igst28_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst18_amnt_so").val(igst18_aftr_disc.toFixed(2));
                            $("#igst28_amnt_so").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst18_amnt = $("#igst18_amnt_so").val();
                            var last_igst28_amnt = $("#igst28_amnt_so").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);
                        }
                        else if(igst12_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val_so').text(igst12_tot_val.toFixed(2));
                            $('#igst28_val_so').text(igst28_tot_val.toFixed(2));
                            $('#igst12_val_hidden_so').val(igst12_tot_val.toFixed(2));
                            $('#igst28_val_hidden_so').val(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst12_amnt_so").val(igst12_aftr_disc.toFixed(2));
                            $("#igst28_amnt_so").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst12_amnt = $("#igst12_amnt_so").val();
                            var last_igst28_amnt = $("#igst28_amnt_so").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);
                        }
                        else if(igst12_amnt!=0)
                        {
                            var tax_dics = discount;
                            var igst12_tot_val = igst12 - tax_dics;
                            $('#igst12_val_so').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden_so').val(igst12_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt_so").val(igst12_aftr_disc.toFixed(2));

                             //subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt_so").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);

                        }
                        else if(igst18_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst18_tot_val = igst18 - tax_dics;
                            $('#igst18_val_so').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden_so').val(igst18_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt_so").val(igst18_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst18_amnt = $("#igst18_amnt_so").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);

                        }
                        else if(igst28_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst28_val_so').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden_so').val(igst28_tot_val.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt_so").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst28_amnt = $("#igst28_amnt_so").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);
                        }
                    }
                    else if(type == 'Instate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#cgst6_val_so').text(igst12.toFixed(2));
                                $('#sgst6_val_so').text(igst12.toFixed(2));
                                $('#cgst6_val_hidden_so').val(igst12.toFixed(2));
                                $('#sgst6_val_hidden_so').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#cgst9_val_so').text(igst18.toFixed(2));
                                $('#sgst9_val_so').text(igst18.toFixed(2));
                                $('#cgst9_val_hidden_so').val(igst18.toFixed(2));
                                $('#sgst9_val_hidden_so').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#cgst14_val_so').text(igst28.toFixed(2));
                              $('#sgst14_val_so').text(igst28.toFixed(2));
                              $('#cgst14_val_hidden_so').val(igst28.toFixed(2));
                              $('#sgst14_val_hidden_so').val(igst28.toFixed(2));
                            }
                        }
                        var cgst6_amnt = parseFloat(igst12) * 6/100;
                        var sgst6_amnt = parseFloat(igst12) * 6/100;
                        var cgst9_amnt = parseFloat(igst18) * 9/100;
                        var sgst9_amnt = parseFloat(igst18) * 9/100;
                        var cgst14_amnt = parseFloat(igst28) * 14/100;
                        var sgst14_amnt = parseFloat(igst28) * 14/100;
                        $("#cgst6_amnt_so").val(cgst6_amnt.toFixed(2));
                        $("#sgst6_amnt_so").val(sgst6_amnt.toFixed(2));
                        $("#cgst9_amnt_so").val(cgst9_amnt.toFixed(2));
                        $("#sgst9_amnt_so").val(sgst9_amnt.toFixed(2));
                        $("#cgst14_amnt_so").val(cgst14_amnt.toFixed(2));
                        $("#sgst14_amnt_so").val(sgst14_amnt.toFixed(2));
                        if(parseFloat(cgst6_amnt) != 0 && parseFloat(cgst9_amnt) != 0 && parseFloat(cgst14_amnt) != 0)
                        {
                            var tax_dics = discount/3;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst6_val_so').text(cgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_so').text(cgst6_tot_val.toFixed(2));
                            $('#cgst9_val_so').text(cgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_so').text(cgst9_tot_val.toFixed(2));
                            $('#cgst14_val_so').text(cgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_so').text(cgst14_tot_val.toFixed(2));
                            $('#sgst6_val_so').text(sgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_so').text(sgst6_tot_val.toFixed(2));
                            $('#sgst9_val_so').text(sgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_so').text(sgst9_tot_val.toFixed(2));
                            $('#sgst14_val_so').text(sgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_so').text(sgst14_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt_so").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_so").val(cgst6_aftr_disc.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt_so").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_so").val(cgst9_aftr_disc.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt_so").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_so").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_so").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_so").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt_so").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_so").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_so").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_so").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) +  parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);
                        }
                        else if(cgst6_amnt!=0 && cgst9_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst6_val_so').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_so').text(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val_so').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_so').text(sgst9_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_so').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_so').val(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_so').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_so').val(sgst9_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst6_amnt_so").val(cgst6_aftr_disc.toFixed(2));
                            $("#cgst9_amnt_so").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_so").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_so").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_so").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_so").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt_so").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_so").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);
                        }
                        else if(cgst9_amnt!=0 && cgst14_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst9_val_so').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_so').text(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val_so').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_so').text(sgst14_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_so').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_so').val(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_so').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_so').val(sgst14_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst9_amnt_so").val(cgst9_aftr_disc.toFixed(2));
                            $("#cgst14_amnt_so").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_so").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_so").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt_so").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_so").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_so").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_so").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);
                        }
                        else if(cgst14_amnt!=0 && cgst6_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst14_val_so').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_so').text(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val_so').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_so').text(sgst6_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_so').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_so').val(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_so').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_so').val(sgst6_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst14_amnt_so").val(cgst14_aftr_disc.toFixed(2));
                            $("#cgst6_amnt_so").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_so").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_so").val(cgst6_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_so").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_so").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_so").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_so").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);
                        }
                        else if(cgst6_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst6_val_so').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_so').text(sgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_so').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_so').val(sgst6_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt_so").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_so").val(cgst6_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_so").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_so").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);
                        }
                        else if(cgst9_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst9_val_so').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_so').text(sgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_so').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_so').val(sgst9_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt_so").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_so").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt_so").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_so").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);
                        }
                        else if(cgst14_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst14_val_so').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_so').text(sgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_so').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_so').val(sgst14_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt_so").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_so").val(cgst14_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst14_amnt =  $("#cgst14_amnt_so").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_so").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt);
                            document.getElementById('sub_total_so').value = sub_total.toFixed(2);
                        }
                    }
                }
            }
        });
    });
});
} // function for quotation salorder ends here
// function for salesorder PO starts here
function calculate_po_salesorder()
{
    console.log('calculate_quote_so');
    $(document).ready(function() {
    $(".start").each(function() {
        var grandTotal = 0;
        var igst12 = 0;
        var igst18 = 0;
        var igst28 = 0;
        var gst12 = 0;
        var gst18 = 0;
        var gst28 = 0;
        var output1 = 0;
        var output2 = 0;
        var output3 = 0;
        var igst12_amnt = 0;
        var igst18_amnt = 0;
        var igst28_amnt = 0;
        var cgst6_amnt = 0;
        var sgst6_amnt = 0;
        var cgst9_amnt = 0;
        var sgst9_amnt = 0;
        var cgst14_amnt = 0;
        var sgst14_amnt = 0;
        var total_est_purchase_price = 0;
        var profit_margin = 0;
        var total_orc = document.getElementById('total_orc_p').value;
        var type = document.getElementById('type_p').value;
        $("input[name='quantity_p[]']").each(function (index) {
            var quantity = $("input[name='quantity_p[]']").eq(index).val();
            var price = $("input[name='unit_price_p[]']").eq(index).val();
            var gst = $("input[name='gst_p[]']").eq(index).val();
            var output = parseInt(quantity) * parseFloat(price);
            var tax = parseFloat(output) * parseFloat(gst)/100;
            //estimate product price
            var estimate_pro_price = $("input[name='estimate_purchase_price_p[]']").eq(index).val();
            var initial_est_purchase_price = parseInt(quantity) * parseFloat(estimate_pro_price);

            if(!isNaN(initial_est_purchase_price))
            {
                $("input[name='initial_est_purchase_price_p[]']").eq(index).val(initial_est_purchase_price.toFixed(2));
                total_est_purchase_price = parseFloat(total_est_purchase_price) + parseFloat(initial_est_purchase_price);
                $('#total_est_purchase_price_p').val(total_est_purchase_price.toFixed(2));
            
            }

            $("input[name='tax[]']").eq(index).val(tax.toFixed(2));
            if (!isNaN(output))
            {
                $("input[name='total_p[]']").eq(index).val(output.toFixed(2));
                grandTotal = parseFloat(grandTotal) + parseFloat(output);
                $('#initial_total_p').val(grandTotal.toFixed(2));
                var initial_total = document.getElementById('initial_total_p').value;
                var discount = document.getElementById('discount_p').value;
                var after_discount = parseFloat(initial_total) - parseFloat(discount);
                var count = $('#add_po tr').length;
                var test_val = document.getElementById('test_val_p').value;
                var percent = test_val/parseFloat(count);
                $("input[name='percent_p[]']").eq(index).val(percent.toFixed(2));


                if(total_orc!='')
                {
                    profit_margin = parseFloat(after_discount) - parseFloat(total_orc) - parseFloat(total_est_purchase_price);
                    $("#profit_by_user_p").val(profit_margin.toFixed(2));
                }
                else
                {
                    profit_margin = parseFloat(after_discount) - parseFloat(total_est_purchase_price);
                    $("#profit_by_user_p").val(profit_margin.toFixed(2));
                }

                if (!isNaN(after_discount))
                {
                    document.getElementById('after_discount_p').value = after_discount.toFixed(2);
                    if(type == 'Interstate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#igst12_val_p').text(igst12.toFixed(2));
                                $('#igst12_val_hidden_p').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#igst18_val_p').text(igst18.toFixed(2));
                                $('#igst18_val_hidden_p').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#igst28_val_p').text(igst28.toFixed(2));
                              $('#igst28_val_hidden_p').val(igst28.toFixed(2));
                            }
                        }
                        var igst12_amnt = parseFloat(igst12) * 12/100;
                        var igst18_amnt = parseFloat(igst18) * 18/100;
                        var igst28_amnt = parseFloat(igst28) * 28/100;
                        $("#igst12_amnt_p").val(igst12_amnt.toFixed(2));
                        $("#igst18_amn_p").val(igst18_amnt.toFixed(2));
                        $("#igst28_amnt_p").val(igst28_amnt.toFixed(2));
                        var igst12_amnt_val = $("#igst12_amnt_p").val();
                        var igst18_amnt_val = $("#igst18_amnt_p").val();
                        var igst28_amnt_val = $("#igst28_amnt_p").val();
                        var igst12_val =  document.getElementById('igst12_val_hidden_p').value;
                        var igst18_val =  document.getElementById('igst18_val_hidden_p').value;
                        var igst28_val =  document.getElementById('igst28_val_hidden_p').value;
                        if(igst12_amnt!=0 && igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/3;
                            igst12_tot_val = igst12 - tax_dics;
                            igst18_tot_val = igst18 - tax_dics;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val_p').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden_p').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val_p').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden_p').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val_p').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden_p').text(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt_p").val(igst12_aftr_disc.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt_p").val(igst18_aftr_disc.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt_p").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calulation
                            var last_igst12_amnt = $("#igst12_amnt_p").val();
                            var last_igst18_amnt = $("#igst18_amnt_p").val();
                            var last_igst28_amnt = $("#igst28_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);

                        }
                        else if(igst12_amnt!=0 && igst18_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst18_tot_val = igst18 - tax_dics;
                            $('#igst12_val_p').text(igst12_tot_val.toFixed(2));
                            $('#igst18_val_p').text(igst18_tot_val.toFixed(2));
                            $('#igst12_val_hidden_p').val(igst12_tot_val.toFixed(2));
                            $('#igst18_val_hidden_p').val(igst18_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst12_amnt_p").val(igst12_aftr_disc.toFixed(2));
                            $("#igst18_amnt_p").val(igst18_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt_p").val();
                            var last_igst18_amnt = $("#igst18_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total').value = sub_total.toFixed(2);
                        }
                        else if(igst18_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst18_tot_val = igst18 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst18_val_p').text(igst18_tot_val.toFixed(2));
                            $('#igst28_val_p').text(igst28_tot_val.toFixed(2));
                            $('#igst18_val_hidden_p').val(igst18_tot_val.toFixed(2));
                            $('#igst28_val_hidden_p').val(igst28_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst18_amnt_p").val(igst18_aftr_disc.toFixed(2));
                            $("#igst28_amnt_p").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst18_amnt = $("#igst18_amnt_p").val();
                            var last_igst28_amnt = $("#igst28_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);
                        }
                        else if(igst12_amnt!=0 && igst28_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var igst12_tot_val = igst12 - tax_dics;
                            var igst28_tot_val = igst28 - tax_dics;
                            $('#igst12_val_p').text(igst12_tot_val.toFixed(2));
                            $('#igst28_val_p').text(igst28_tot_val.toFixed(2));
                            $('#igst12_val_hidden_p').val(igst12_tot_val.toFixed(2));
                            $('#igst28_val_hidden_p').val(igst28_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst12_amnt_p").val(igst12_aftr_disc.toFixed(2));
                            $("#igst28_amnt_p").val(igst28_aftr_disc.toFixed(2));

                            // sub total calculation
                            var last_igst12_amnt = $("#igst12_amnt_p").val();
                            var last_igst28_amnt = $("#igst28_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt) + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);
                        }
                        else if(igst12_amnt!=0)
                        {
                            var tax_dics = discount;
                            var igst12_tot_val = igst12 - tax_dics;
                            $('#igst12_val_p').text(igst12_tot_val.toFixed(2));
                            $('#igst12_val_hidden_p').val(igst12_tot_val.toFixed(2));
                            var igst12_aftr_disc = igst12_tot_val*12/100;
                            $("#igst12_amnt_p").val(igst12_aftr_disc.toFixed(2));

                             //subtotal calculation
                            var last_igst12_amnt = $("#igst12_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst12_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);

                        }
                        else if(igst18_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst18_tot_val = igst18 - tax_dics;
                            $('#igst18_val_p').text(igst18_tot_val.toFixed(2));
                            $('#igst18_val_hidden_p').val(igst18_tot_val.toFixed(2));
                            var igst18_aftr_disc = igst18_tot_val*18/100;
                            $("#igst18_amnt_p").val(igst18_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst18_amnt = $("#igst18_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst18_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);

                        }
                        else if(igst28_amnt!=0)
                        {
                            var tax_dics = discount;
                            igst28_tot_val = igst28 - tax_dics;
                            $('#igst28_val_p').text(igst28_tot_val.toFixed(2));
                            $('#igst28_val_hidden_p').val(igst28_tot_val.toFixed(2));
                            var igst28_aftr_disc = igst28_tot_val*28/100;
                            $("#igst28_amnt_p").val(igst28_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_igst28_amnt = $("#igst28_amnt_p").val();
                            var sub_total = parseFloat(after_discount)  + parseFloat(last_igst28_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);
                        }
                    }
                    else if(type == 'Instate')
                    {
                        if (gst == 12)
                        {
                            if(!isNaN(igst12))
                            {
                                igst12 = parseFloat(igst12) + parseFloat(output);
                                $('#cgst6_val_p').text(igst12.toFixed(2));
                                $('#sgst6_val_p').text(igst12.toFixed(2));
                                $('#cgst6_val_hidden_p').val(igst12.toFixed(2));
                                $('#sgst6_val_hidden_p').val(igst12.toFixed(2));
                            }
                        }
                        if (gst == 18)
                        {
                            if(!isNaN(igst18))
                            {
                                igst18 = parseFloat(igst18) + parseFloat(output);
                                $('#cgst9_val_p').text(igst18.toFixed(2));
                                $('#sgst9_val_p').text(igst18.toFixed(2));
                                $('#cgst9_val_hidden_p').val(igst18.toFixed(2));
                                $('#sgst9_val_hidden_p').val(igst18.toFixed(2));
                            }
                        }
                        if (gst == 28)
                        {
                            if(!isNaN(igst28))
                            {
                              igst28 = parseFloat(igst28) + parseFloat(output);
                              $('#cgst14_val_p').text(igst28.toFixed(2));
                              $('#sgst14_val_p').text(igst28.toFixed(2));
                              $('#cgst14_val_hidden_p').val(igst28.toFixed(2));
                              $('#sgst14_val_hidden_p').val(igst28.toFixed(2));
                            }
                        }
                        var cgst6_amnt = parseFloat(igst12) * 6/100;
                        var sgst6_amnt = parseFloat(igst12) * 6/100;
                        var cgst9_amnt = parseFloat(igst18) * 9/100;
                        var sgst9_amnt = parseFloat(igst18) * 9/100;
                        var cgst14_amnt = parseFloat(igst28) * 14/100;
                        var sgst14_amnt = parseFloat(igst28) * 14/100;
                        $("#cgst6_amnt_p").val(cgst6_amnt.toFixed(2));
                        $("#sgst6_amnt_p").val(sgst6_amnt.toFixed(2));
                        $("#cgst9_amnt_p").val(cgst9_amnt.toFixed(2));
                        $("#sgst9_amnt_p").val(sgst9_amnt.toFixed(2));
                        $("#cgst14_amnt_p").val(cgst14_amnt.toFixed(2));
                        $("#sgst14_amnt_p").val(sgst14_amnt.toFixed(2));
                        if(parseFloat(cgst6_amnt) != 0 && parseFloat(cgst9_amnt) != 0 && parseFloat(cgst14_amnt) != 0)
                        {
                            var tax_dics = discount/3;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst6_val_p').text(cgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_p').text(cgst6_tot_val.toFixed(2));
                            $('#cgst9_val_p').text(cgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_p').text(cgst9_tot_val.toFixed(2));
                            $('#cgst14_val_p').text(cgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_p').text(cgst14_tot_val.toFixed(2));
                            $('#sgst6_val_p').text(sgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_p').text(sgst6_tot_val.toFixed(2));
                            $('#sgst9_val_p').text(sgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_p').text(sgst9_tot_val.toFixed(2));
                            $('#sgst14_val_p').text(sgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_p').text(sgst14_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_p").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_p").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt_p").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_p").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_p").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) +  parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);
                        }
                        else if(cgst6_amnt!=0 && cgst9_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst6_val_p').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_p').text(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val_p').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_p').text(sgst9_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_p').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_p').val(sgst6_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_p').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_p').val(sgst9_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            $("#cgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_p").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_p").val();
                            var last_cgst9_amnt =  $("#cgst9_amnt_p").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);
                        }
                        else if(cgst9_amnt!=0 && cgst14_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst9_val_p').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_p').text(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val_p').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_p').text(sgst14_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_p').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_p').val(sgst9_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_p').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_p').val(sgst14_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            $("#cgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt_p").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_p").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_p").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);
                        }
                        else if(cgst14_amnt!=0 && cgst6_amnt!=0)
                        {
                            var tax_dics = discount/2;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst14_val_p').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_p').text(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val_p').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_p').text(sgst6_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_p').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_p').val(sgst14_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_p').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_p').val(sgst6_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));
                            $("#cgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));

                            //subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_p").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_p").val();
                            var last_cgst14_amnt =  $("#cgst14_amnt_p").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);
                        }
                        else if(cgst6_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst6_tot_val = igst12 - tax_dics;
                            var sgst6_tot_val = igst12 - tax_dics;
                            $('#cgst6_val_p').text(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_p').text(sgst6_tot_val.toFixed(2));
                            $('#cgst6_val_hidden_p').val(cgst6_tot_val.toFixed(2));
                            $('#sgst6_val_hidden_p').val(sgst6_tot_val.toFixed(2));
                            var cgst6_aftr_disc = cgst6_tot_val*6/100;
                            $("#cgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));
                            $("#sgst6_amnt_p").val(cgst6_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst6_amnt =  $("#cgst6_amnt_p").val();
                            var last_sgst6_amnt = $("#sgst6_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst6_amnt) + parseFloat(last_sgst6_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);
                        }
                        else if(cgst9_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst9_tot_val = igst18 - tax_dics;
                            var sgst9_tot_val = igst18 - tax_dics;
                            $('#cgst9_val_p').text(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_p').text(sgst9_tot_val.toFixed(2));
                            $('#cgst9_val_hidden_p').val(cgst9_tot_val.toFixed(2));
                            $('#sgst9_val_hidden_p').val(sgst9_tot_val.toFixed(2));
                            var cgst9_aftr_disc = cgst9_tot_val*9/100;
                            $("#cgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));
                            $("#sgst9_amnt_p").val(cgst9_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst9_amnt =  $("#cgst9_amnt_p").val();
                            var last_sgst9_amnt = $("#sgst9_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst9_amnt) + parseFloat(last_sgst9_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);
                        }
                        else if(cgst14_amnt!=0)
                        {
                            var tax_dics = discount;
                            var cgst14_tot_val = igst28 - tax_dics;
                            var sgst14_tot_val = igst28 - tax_dics;
                            $('#cgst14_val_p').text(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_p').text(sgst14_tot_val.toFixed(2));
                            $('#cgst14_val_hidden_p').val(cgst14_tot_val.toFixed(2));
                            $('#sgst14_val_hidden_p').val(sgst14_tot_val.toFixed(2));
                            var cgst14_aftr_disc = cgst14_tot_val*14/100;
                            $("#cgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));
                            $("#sgst14_amnt_p").val(cgst14_aftr_disc.toFixed(2));

                            // subtotal calculation
                            var last_cgst14_amnt =  $("#cgst14_amnt_p").val();
                            var last_sgst14_amnt = $("#sgst14_amnt_p").val();
                            var sub_total = parseFloat(after_discount) + parseFloat(last_cgst14_amnt) + parseFloat(last_sgst14_amnt);
                            document.getElementById('sub_total_p').value = sub_total.toFixed(2);
                        }
                    }
                }
            }
        });
    });
});
} // function for  salesorder PO ends here
