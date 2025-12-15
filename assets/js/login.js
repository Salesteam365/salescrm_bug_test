function show_pass() {
  var x = document.getElementById("pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function show_pass1(){
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function show(){
  document.querySelector(".match").style.visibility = "hidden";
	var pass = document.getElementById("pass").value;
	var cpass = document.getElementById("password").value;
	if(pass != cpass)
	{
		document.querySelector(".match").style.visibility = "visible";
	}
	else
	{
		document.querySelector(".match").style.visibility = "hidden";
	}
}





$(function(){
      const button = $('#add_user'); // The submit input id
      button.attr('disabled', 'disabled');
      $('#accept').change(function() { // The checkbox id
          if (this.checked){
            button.removeAttr('disabled')
            .css("cursor", "pointer");
          } else {
            button.attr('disabled', 'disabled')
            .css( "cursor", "not-allowed" );
          }
      });
});



var check_pass = function() {
      if (document.getElementById('password').value ==
          document.getElementById('pass').value) {
          document.getElementById('output').style.color = 'green';
      } else {
      		document.getElementById('output').style.color = 'red';
      }
  }
