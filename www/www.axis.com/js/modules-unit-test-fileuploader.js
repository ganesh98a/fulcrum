(function($) {
	$(document).ready(function() {
		createUploaders();
	});
})(jQuery);




function fileUploader_uploadCompleted(elementId, file_manager_folder_id)
{
	try {
		//alert(elementId);
		$('#ajax_success').html(elementId);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function fileUploader_DragEnter()
{
	$(".boxViewUploader").find(".qq-upload-drop-area").show();
}

function fileUploader_DragLeave()
{
	//$(".boxViewUploader").hide();
	//showDrag = true;
	$(".boxViewUploader").find(".qq-upload-drop-area").hide();
}



