$(document).on('keypress', '.alpha', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[a-zA-Z\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});

$(document).on('keypress', '.numeric', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[0-9\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});


$(document).on('keypress', '.price_float', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[0-9\.\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});

$(document).on('keypress', '.alpha_space', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[a-zA-Z \b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});

$(document).on('keypress', '.alpha_numeric_space', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[a-zA-Z0-9 \b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});

$(document).on('keypress', '.alpha_numeric', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[a-zA-Z0-9\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});

$(document).on('keypress', '.alpha_numeric_slash', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[a-zA-Z0-9/\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});

$(document).on('keypress', '.numeric_slash', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[0-9/\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});

$(document).on('keypress', '.username', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[a-zA-Z0-9-_\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});

$(document).on('keypress', '.address', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[a-zA-Z0-9-_:, \b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});


$(document).on('keypress', '.email_address', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[a-zA-Z0-9-_@.\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});


$(document).on('keypress', '.alpha_numeric_hyphen', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[a-zA-Z0-9-/\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});


$(document).on('keypress', '.unique_ids', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[a-zA-Z0-9{}/\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});


$(document).on('keypress', '.landline', function (event) {
    var code = event.keyCode || event.which;
    var regex = new RegExp("^[0-9-\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key) && code!=9 && event.which!=0 && event.which!=8) {
        event.preventDefault();
        return false;
    }
});


$(document).on('paste', '.phonePaste, .orgMobile', function (e) {
    e.preventDefault();
	var pastedData  = '';
    pastedData      = e.originalEvent.clipboardData.getData('text');
	var newMobileno = pastedData.replace(/\D/g, '');
	var numbers 	= newMobileno.replace(/[^0-9]/g, "");
    var numbersNe 	= numbers.replace(/\D/g, '').slice(-10);
	$(this).val(numbersNe);  
});



var base_url = window.location.origin;
var sourceUrl=base_url+"/organizations/autocomplete_org";
var orgDetailUrl=base_url+"/contacts/get_org_details";
var conDetailUrl=base_url+"/contacts/getContact";

$('.orgName').autocomplete({
    source: sourceUrl,
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('.orgName').each(function(){
        var org_name = $(this).val();
        setOrgData(org_name);
      });
    }
  });
  
  
  function setOrgData(org_name){

	$.ajax({
          url:orgDetailUrl,
          method: 'post',
          data: {org_name: org_name},
          dataType: 'json',
          success: function(response){
            var len = response.length;
            if(len > 0)
            {
                var orgGst=response[0].gstin;
				var YourStateName=$("#YourStateName").val();				
				if(response[0].billing_state==YourStateName){
					$("#igst_checked").attr('checked', false);
					$("#csgst_checked").attr('checked', true);
					$('#csgst_checked').click();
					$("#csgst_checked").attr('disabled', false);
					$("#igst_checked").attr('disabled', true);
				}else{
					$("#igst_checked").attr('disabled', false);
					$("#csgst_checked").attr('disabled', true);
				}

                
                $(".put_org_id").val(response[0].id);
				$(".orgName").val(response[0].org_name);
                $(".orgEmail").val(response[0].email);
                $(".orgMobile").val(response[0].mobile);
				$(".orgOfficePhone").val(response[0].office_phone);
                $(".orgIndustry").val(response[0].industry);
                $(".orgEmployee").val(response[0].employees);
                $(".orgWebsite").val(response[0].website);
				$(".ordAnnualRevenue").val(response[0].annual_revenue);
				$('.orgContact').html('');
				var ContactHtml='<option value="'+response[0].primary_contact+'">'+response[0].primary_contact+'</option>';
                $('.orgContact').append(ContactHtml);
				 $.ajax({
                    url:conDetailUrl,
                    method: 'post',
                    data: {org_name: response[0].org_name},
                    dataType: 'json',
                    success: function(response)
                    {
                        console.log(response);
                      $.each(response,function(index,data){
                          if(data['name']!=""){
                        $('.orgContact').append( '<option value="'+data['name']+'">'+data['name']+'</option>' ); 
                          }
                      });
					  var optionValues =[];
						$('.orgContact option').each(function(){
						   if($.inArray(this.value, optionValues) >-1){
							  $(this).remove()
						   }else{
							  optionValues.push(this.value);
						   }
						});
						getContactDetails();
                    }
                  });
                
                $(".orgBillingCountry").val(response[0].billing_country);
                $(".orgShippingCountry").val(response[0].shipping_country);
                $(".orgBillingState").val(response[0].billing_state);
                $(".orgShippingState").val(response[0].shipping_state); 
                $(".orgBillingCity").val(response[0].billing_city);
                $(".orgShippingCity").val(response[0].shipping_city); 
                $(".orgBillingZip").val(response[0].billing_zipcode);
                $(".orgShippingZip").val(response[0].shipping_zipcode); 
                $(".orgBillingAddress").val(response[0].billing_address);
                $(".orgShippingAddress").val(response[0].shipping_address);
				var form = $(".orgName").closest('form')[0];
			//	checkValidationWithClass(form.id);
            }
            else
            {
              $('.orgName,.orgEmail,.orgMobile,.orgOfficePhone,.orgIndustry,.orgEmployee,.orgWebsite,.ordAnnualRevenue').val('');
              $('.orgContact,.orgBillingCountry,.orgShippingCountry,.orgBillingState,.orgShippingState,.orgBillingCity,.orgShippingCity,.orgBillingZip,.orgShippingZip,.orgBillingAddress,.orgShippingAddress').val('');
            }
          }
        });

 }	
  
  
$('.orgContact').change(function(){ 
    getContactDetails();
});
  //getContactDetails();
  function getContactDetails(){
	var org_name = $(".orgName").val();
    var cnt_name = $('.orgContact').val();
    if(cnt_name!="" && cnt_name!=""){
       $.ajax({
            url:conDetailUrl,
            method: 'post',
            data: {org_name:org_name,cnt_name:cnt_name},
            dataType: 'json',
            success: function(response){
                    $(".orgEmail").val(response[0].email);
                    $(".put_cnt_id").val(response[0].id);
                    $(".orgMobile").val(response[0].mobile);
    				$(".orgOfficePhone").val(response[0].office_phone); 
    		}
        });
    }
  }
  
  
  
/*********** Search Country State & City *********/ 
  
  $('.orgShippingCountry').autocomplete({
    source: "login/autocomplete_countries",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('.s_country_ids').val(ui.item.values);
      return false;
    }
  });
  
  $('.orgShippingState').autocomplete({
       source: function(request, response) {
           var country_id =$('.s_country_ids').val();
             $.ajax({ 
                url: "login/autocomplete_states",
                data: { terms: request.term, country_id: country_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('.s_state_id').val(ui.item.values);
    }
  });
  
   $('.orgShippingCity').autocomplete({
     source: function(request, response) {
           var state_id =$('.s_state_id').val();
             $.ajax({ 
                url: "login/autocomplete_cities",
                data: { terms: request.term, state_id: state_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });

$('.orgBillingCountry').autocomplete({
    source: "login/autocomplete_countries",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('.country_ids').val(ui.item.values);
      return false;
    }
  });
  
  $('.orgBillingState').autocomplete({
       source: function(request, response) {
           var country_id =$('.country_ids').val();
             $.ajax({ 
                url: "login/autocomplete_states",
                data: { terms: request.term, country_id: country_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('.state_id').val(ui.item.values);
    }
  });
  
   $('.orgBillingCity').autocomplete({
     source: function(request, response) {
           var state_id =$('.state_id').val();
             $.ajax({ 
                url: "login/autocomplete_cities",
                data: { terms: request.term, state_id: state_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });


/*********** Check Validation Function ****/

function checkValidationWithClass(formId)
{    
  var i=1;
	var returnData=1;
	$("#"+formId+' input, #'+formId+' select, #'+formId+' textarea').each(function () {
		if($(this).hasClass("checkvl")===true){
			var dataVl=$(this).val();
			if(dataVl=="" || dataVl==0 || dataVl===undefined || dataVl===null){
				$(this).addClass('is-invalid');
				if(i==1){
					$(this).focus();
				}
				i++;
				returnData=0;
			}else{
				$(this).removeClass('is-invalid');
			}
		}else{
			$(this).removeClass('is-invalid');
		}	
	});
	
	return returnData;
	
}

$(".checkvl").keyup(function(){
	 // var form = $(this).closest('form')[0];
	  //checkValidationWithClass(form.id);
	  $(this).removeClass('is-invalid');
})
$(".checkvl").change(function(){
	$(this).removeClass('is-invalid');
	  //var form = $(this).closest('form')[0];
	 // checkValidationWithClass(form.id);
})




/*********** start calculate invoice****/
function calculate_invoice()
{
	  var Amount=0;
	  var IGST =0;
	  var cal_discount=0;
	  var extraCharge=0;
	  var SCGST = 0;
	$("input[name='quantity[]']").each(function (index) {
		    var quantity = $("input[name='quantity[]']").eq(index).val();
            var price = $("input[name='unit_price[]']").eq(index).val();
			price = price.replace(/,/g, "");
			var pricetwo=numberToIndPrice(price);
			$("input[name='unit_price[]']").eq(index).val(pricetwo);
            var gst = $("input[name='gst[]']").eq(index).val();
            var output = parseInt(quantity) * parseFloat(price);
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
					$("input[name='sub_total[]']").eq(index).val(addgst_subTotal.toFixed(2));
					if($('#igst_checked').is(":checked")){
						
					$("input[name='igst[]']").eq(index).val(tax.toFixed(2));
					
					}else if($('#csgst_checked').is(":checked"))
					{
						
						var taxs = parseFloat(tax)/2;
					   $("input[name='cgst[]']").eq(index).val(taxs.toFixed(2));
					   $("input[name='sgst[]']").eq(index).val(taxs.toFixed(2));
				    }
				}
				
			}
	});
	
	//console.log(Amount);
	var discount = document.getElementById('discounts').value;
	var select_discType = document.getElementById('sel_disc').value;
	if(discount != '' && discount!==undefined)
    {   if(select_discType == 'disc_persent' )
        { 
		   var cal_discount = parseFloat(Amount) * parseFloat(discount)/100;
		}else{
		   var cal_discount = parseFloat(discount);
		}
	}
	
	$('#cal_disc').html(numberToIndPrice(cal_discount.toFixed(2)));
	$('#total_discount').val(numberToIndPrice(cal_discount.toFixed(2)));
	var GrandAmount=parseFloat(Amount)+parseFloat(IGST);
	GrandAmount=parseFloat(GrandAmount)-parseFloat(cal_discount);
	
	$("input[name='extra_chargevalue[]']").each(function (index) {
		var extra_charge = $("input[name='extra_chargevalue[]']").eq(index).val();
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
	$('#final_total').val(numberToIndPrice(GrandAmount.toFixed(2)));
	$('#digittowords').html(digit_to_words(GrandAmount));
}

/********** End calculate performa invoice ****/



/**********start digit to words indian rupees****************/

function price_in_words(price) {
  var sglDigit = ["Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"],
    dblDigit = ["Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"],
    tensPlace = ["", "Ten", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"],
    handle_tens = function(dgt, prevDgt) {
      return 0 == dgt ? "" : " " + (1 == dgt ? dblDigit[prevDgt] : tensPlace[dgt])
    },
    handle_utlc = function(dgt, nxtDgt, denom) {
      return (0 != dgt && 1 != nxtDgt ? " " + sglDigit[dgt] : "") + (0 != nxtDgt || dgt > 0 ? " " + denom : "")
    };

  var str = "",
    digitIdx = 0,
    digit = 0,
    nxtDigit = 0,
    words = [];
  if (price += "", isNaN(parseInt(price))) str = "";
  else if (parseInt(price) > 0 && price.length <= 10) {
    for (digitIdx = price.length - 1; digitIdx >= 0; digitIdx--) switch (digit = price[digitIdx] - 0, nxtDigit = digitIdx > 0 ? price[digitIdx - 1] - 0 : 0, price.length - digitIdx - 1) {
      case 0:
        words.push(handle_utlc(digit, nxtDigit, ""));
        break;
      case 1:
        words.push(handle_tens(digit, price[digitIdx + 1]));
        break;
      case 2:
        words.push(0 != digit ? " " + sglDigit[digit] + " Hundred" + (0 != price[digitIdx + 1] && 0 != price[digitIdx + 2] ? " and" : "") : "");
 break;
      case 3:
        words.push(handle_utlc(digit, nxtDigit, "Thousand"));
        break;
      case 4:
        words.push(handle_tens(digit, price[digitIdx + 1]));
        break;
      case 5:
        words.push(handle_utlc(digit, nxtDigit, "Lakh"));
        break;
      case 6:
        words.push(handle_tens(digit, price[digitIdx + 1]));
        break;
      case 7:
        words.push(handle_utlc(digit, nxtDigit, "Crore"));
        break;
      case 8:
        words.push(handle_tens(digit, price[digitIdx + 1]));
        break;
      case 9:
        words.push(0 != digit ? " " + sglDigit[digit] + " Hundred" + (0 != price[digitIdx + 1] || 0 != price[digitIdx + 2] ? " and" : " Crore") : "")
    }
    str = words.reverse().join("")
  } else str = "";
  return str;

}
function digit_to_words(amount)
{
var splittedNum =amount.toString().split('.')
var nonDecimal=splittedNum[0]
var decimal=splittedNum[1]
var value = price_in_words(Number(nonDecimal))+" Ruppes and "+price_in_words(Number(decimal))+" paise only";
return value;
}


function numberToIndPrice(x){

x=x.toString();
var afterPoint = '';
if(x.indexOf('.') > 0)
   afterPoint = x.substring(x.indexOf('.'),x.length);
x = Math.floor(x);
x=x.toString();
var lastThree = x.substring(x.length-3);
var otherNumbers = x.substring(0,x.length-3);
if(otherNumbers != '')
    lastThree = ',' + lastThree;
var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;

return res;
}


function hideShowOnly(hideId,showid){
	$("#"+hideId).hide();
	$("#"+showid).show();
}

function removeRow(id,pid){
	$("#noid"+id+", #inptdv"+id+", #inpt"+id+", #rm"+id).remove();
	countPtg(pid);
}
function countPtg(pid){
        var arr = $('#'+pid+' p');
        var cnt=1;
        for(i=0;i<arr.length;i++)
        {
          $(arr[i]).html(cnt+".");
          cnt++;
        }
}

function appendLine(appendDataid,no,inputName,value=''){
		var appendData='<div class="col-lg-1 col-1 numberDisp " id="noid'+no+'"><p>'+no+'.</p></div>'+
		'<div class="col-lg-10 col-10" id="inptdv'+no+'"><input type="text" id="inpt'+no+'" class="form-control inputbootomBor" name="'+inputName+'[]" value="'+value+'" placeholder="Customer Terms & Condition" ></div>'+
		'<div class="numberDisp" style="" id="rm'+no+'"><i class="far fa-times-circle" onClick="removeRow('+no+',`'+appendDataid+'`)" ></i></div>';
		$("#"+appendDataid).append(appendData);
		countPtg(appendDataid);
}

function forDisableInput(tgid, whattodo='' ){
    if(whattodo==1){
    $(tgid).prop("disabled",true);
    }else{
     $(tgid).prop("disabled",false);
    }
} 
function forReadOnlyInput(tgid , whattodo=''){
     if(whattodo==1){
        $(tgid).prop("readonly",true);
     }else{
        $(tgid).prop("readonly",false); 
     }
}



const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
	const currentTheme = localStorage.getItem('theme');

if (currentTheme) {
    document.documentElement.setAttribute('data-theme', currentTheme);
  
    if (currentTheme === 'dark') {
        toggleSwitch.checked = true;
    }
}

function switchTheme(e) {
    if (e.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    }
    else {        document.documentElement.setAttribute('data-theme', 'light');
          localStorage.setItem('theme', 'light');
    }    
}

toggleSwitch.addEventListener('change', switchTheme, false);


// PUSH Notification 

$(document).ready(function() {
    var userType = localStorage.getItem("user_type");
    if(userType=='admin'){
	    showNotification();
	    setInterval(function(){ showNotification(); }, 20000);
    }
	setInterval(function(){ showMeetingNotification(); }, 45000);
});
function showNotification() {	
	if (!Notification) {
		$('body').append('<h4 style="color:red">*Browser does not support Web Notification</h4>');
		return;
	}
	if (Notification.permission !== "granted") {		
		Notification.requestPermission();
	} else {	

		var companyName = localStorage.getItem("company_name");
	    var companyEmail = localStorage.getItem("company_email");
	    var userType = localStorage.getItem("user_type");
	    
		var base_url = window.location.origin;
        var notiUrl=base_url+"/Notification/get_push_notification";
		$.ajax({
			url : notiUrl,
			type: "POST",
			data: { company_name: companyName, company_email: companyEmail},
			success: function(data, textStatus, jqXHR) {
				var data = jQuery.parseJSON(data);
				if(data.result == true) {
					var data_notif = data.notif;
					for (var i = data_notif.length - 1; i >= 0; i--) {
						var theurl = data_notif[i]['url'];
						var notifikasi = new Notification(data_notif[i]['title'], {
							icon: data_notif[i]['icon'],
							body: data_notif[i]['msg'],
						});
						notifikasi.onclick = function () {
							window.open(theurl); 
							notifikasi.close();     
						};
						setTimeout(function(){
							notifikasi.close();
						}, 5000);
					};
				} else {
				}
			},
			error: function(jqXHR, textStatus, errorThrown)	{}
		}); 
	}
};


function showMeetingNotification() {	
	if(!Notification) {
		$('body').append('<h4 style="color:red">*Browser does not support Web Notification</h4>');
		return;
	}
	if (Notification.permission !== "granted") {		
		Notification.requestPermission();
	} else {
		var companyName = localStorage.getItem("company_name");
	    var companyEmail= localStorage.getItem("company_email");
	    var userEmail 	= localStorage.getItem("email");
		var base_url = window.location.origin;
		$.ajax({
			url : base_url+"/Notification/get_metting_notification",
			type: "POST",
			data: { company_name: companyName, company_email: companyEmail,userEmail:userEmail},
			success: function(data, textStatus, jqXHR) {
				var data = jQuery.parseJSON(data);
				if(data.result == true) {
					var data_notif = data.notif;
					for (var i = data_notif.length - 1; i >= 0; i--) {
						var theurl = data_notif[i]['url'];
						var notifikasi = new Notification(data_notif[i]['title'], {
							icon: data_notif[i]['icon'],
							body: data_notif[i]['msg'],
						});
						notifikasi.onclick = function () {
							window.open(theurl); 
							notifikasi.close();     
						};
						setTimeout(function(){
							notifikasi.close();
						}, 7000);
					};
				} else {
				}
			},
			error: function(jqXHR, textStatus, errorThrown)	{}
		}); 
	}
};

