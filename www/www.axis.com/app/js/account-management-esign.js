$(document).ready(function() {
	
	createUploaders();
	setTimeout(function(){
		$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90},1000);
	});
	

});

//type signature start
function showTextPreview(val)
{
	var element = $("#html-content-holder"); 
	var getCanvas; 
	// html2canvas(element, {
	// 	onrendered: function (canvas) {
			$("#previewImage").empty().append(val);
	// 		getCanvas = canvas;
	// 	}
	// });

}

function saveTextAsSign()
{
		var element = $("#html-content-holder"); 
		var getCanvas; 
		html2canvas(element, {
			onrendered: function (canvas) {
				var imgageData = canvas.toDataURL("image/png");
				var img_data = imgageData.replace(/^data:image\/(png|jpg);base64,/, "");
		//ajax call to save image inside folder
		$.ajax({
			url: window.ajaxUrlPrefix +'esignature/sign_src/save_sign.php',
			data: { img_data:img_data,type:'1' },
			type: 'post',
			success: function (response) {
				resarr = response.split('~');
				messageAlert('Successfully saved the E-signature', 'successMessage');

			}
		});
	}
});
}
//type signature End

function loadpreviewAfterimgupload()
{
$.ajax({
		url: window.ajaxUrlPrefix +'esignature/sign_src/esigncontent.php',
		data: { method:"esigncontent",type:"3" },
		type: 'get',
		success: function (response) {

			messageAlert('Successfully saved the E-signature', 'successMessage');
			resarr = response.split('~');
			$(".sign-preview").css("display","");
			$('.sign-preview').attr("src",resarr[0]);
			$('.eupdatedate').html(resarr[1]);
		}
	});
}

function saveDrawSign(event)
{
	
	if($('.ui-dialog').length)
	{
		$('.ui-dialog').css("top", '100px');
	}
	html2canvas([document.getElementById('sign-pad')], {
		onrendered: function (canvas) {
			var canvas_img_data = canvas.toDataURL('image/png');
			var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
						//ajax call to save image inside folder
						$.ajax({
							url: window.ajaxUrlPrefix +'esignature/sign_src/save_sign.php',
							data: { img_data:img_data,type:'2' },
							type: 'post',
							success: function (response) {
								$('.ui-dialog').css("top", '100px');
								resarr = response.split('~');
								$("#signArea").signaturePad().clearCanvas ();  //clear the signature place
								$(".sign-preview").css("display","");
								$('.sign-preview').attr("src",resarr[0]);
								$('.eupdatedate').html(resarr[1]);
								messageAlert('Successfully saved the E-signature', 'successMessage');
							}
						});
					}
				});
}
function ToclearDrawSign()
{
	$("#signArea").signaturePad().clearCanvas ();
}




//For global_admin separating the KPI
function signsetchanges()
{
	var signupvalue = $('input[name=signset]:checked').val();
	if(signupvalue=='type_my_signature')
	{
		$('.type_my_signature').show();
		$('.draw_signimage').hide();
		$('.upload_signimage').hide();
	}
	else if(signupvalue=='draw_signimage')
	{
		$('.type_my_signature').hide();
		$('.draw_signimage').show();
		$('.upload_signimage').hide();	
	}
	else if(signupvalue=='upload_signimage')
	{
		$('.type_my_signature').hide();
		$('.draw_signimage').hide();
		$('.upload_signimage').show();		
	}
}
