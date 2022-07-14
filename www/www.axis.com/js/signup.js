$(document).ready(function() {


	$(".number").keyup(function(){
		var id =this.id;
		var data = this.value.replace(/[^0-9]+/g, '');
		$("#"+id).val(data);
	});
	$( "#email" ).keyup(function() {
		$("#email_err").css("display","none");
		$("#email").removeClass('redBorderThick');	
			
	});
	$('input#cap_org').blur();

	
});

//validation 
function SignupViaPromiseChain(uniqueId,methodType){
	var element = document.getElementById("signupTrail");
	var formValues = {};

	var first_name    = $("#first_name").val();
	var last_name  = $("#last_name").val();
	var email     = $("#email").val();
	var company   = $("#company").val();
	var zip       = $("#zip").val();
	
	first_name    = first_name.trim();
	last_name  = last_name.trim();
	email     = email.trim();
	company   = company.trim();
	zip       = zip.trim();
	

	var valPair =[];
	var j='0';
	if(first_name == '')
	{
		$("#first_name").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}
	else{
		$("#first_name").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 

	if(last_name == '')
	{
		$("#last_name").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}
	else{
		$("#last_name").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 
	if(email == '')
	{
		$("#email").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}
	else{
		$("#email").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 
	if(company == '')
	{
		$("#company").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}
	else{
		$("#company").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 
	
	if(zip == '')
	{
		$("#zip").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}
	else{
		$("#zip").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 

	var email_check       = $("#email_check").val();
	if(email_check=='1')
	{
		$("#email").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}else{
		$("#email").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	}
	//captcha 
	var cap_org =$("#cap_org").val();
	var cap_match    = $("#cap_match").val();
	if(cap_org==cap_match)
	{
		$("#captch_err").hide();
		// $("#cap_match").removeClass('redBorderThick');
		valPair[j]='1';
		j++;

	}else{
		$("#captch_err").show();
		// $("#cap_match").addClass('redBorderThick');
		valPair[j]='0';
		j++;

	}
	
	$( "#cap_match" ).keyup(function() {
  		// $("#cap_match").removeClass('redBorderThick');		
  		$("#captch_err").hide();
	});
	

	//end of catcha
		
	$( "#first_name" ).keyup(function() {
  		$("#first_name").removeClass('redBorderThick');		
	});
	$( "#last_name" ).keyup(function() {
		$("#last_name").removeClass('redBorderThick');		
	});
	$( "#email" ).keyup(function() {
		$("#email_err").css("display","none");
		$("#email").removeClass('redBorderThick');	
			
	});
	$( "#company" ).keyup(function() {
		$("#company").removeClass('redBorderThick');		
	});
	
	$( "#zip" ).keyup(function() {
		$("#zip").removeClass('redBorderThick');		
	});

	if(valPair.indexOf('0') !='-1'){
		if((/[^0]/).exec(valPair.join(""))){
			messageAlert('Please enter valid data.', 'errorMessage');
			return false;
		}
		else{

			messageAlert('Please fill in the highlighted areas.', 'errorMessage');	
			return false;
		}
	}else if(valPair.indexOf('0')=='-1')
	{
	
		var ajaxHandler = window.ajaxUrlPrefix + 'trailsignup-ajax.php?method=checkEmailExist';
		var ajaxQueryString =
				'email=' + encodeURIComponent(email);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){

			if(data=='1')
			{
				$("#email_err").html("Email Already Exist");
				$("#email_err").css("display","block");

			}else{

		formValues.first_name  = element.first_name.value;
		formValues.last_name   = element.last_name.value;
		formValues.email       = element.email.value;
		formValues.company     = element.company.value;
		formValues.zip         =  element.zip.value;
		

		newspinner();
		var ajaxUrl = window.ajaxUrlPrefix + 'trialsignup-save.php';
		$.ajax({
			url: ajaxUrl,
			data:{formValues:formValues},
			method:'POST',
			success: function(data)
			{
				hidenewspinner();
				window.location.href=data;
			}
		});
		}

			},
			});
		

	}
	
	
}
function validateEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(emailField) == false) 
        {
        	$("#email_check").val("1");
			$("#email_err").html("Invalid Email Address");
			$("#email_err").css("display","block");


           return '0';
        }else{

        	$("#email_check").val("0");
			$("#email_err").css("display","none");

			return '1';

        }


}

function checkemailExists(value)
{
	var check="";
	check=validateEmail(value);
		// Set value of zip after stripping out non-numeric characters
		if(check=="1"){
			var ajaxHandler = window.ajaxUrlPrefix + 'trailsignup-ajax.php?method=checkEmailExist';
			var ajaxQueryString =
				'email=' + encodeURIComponent(value);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: function(data){
					$("#email_check").val(data);

					if(data=='1')
					{
						$("#email_err").html("Email Already Exist");
						$("#email_err").css("display","block");

					}else{
						$("#email_err").css("display","none");
					}

				},
			});
		}
}
//To generate a captcha
function captch() {
    var x = document.getElementById("cap_org")
    x.value = Math.floor((Math.random() * 10000) + 1);
    $('#cap_match').val('');

}
