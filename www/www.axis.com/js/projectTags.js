$(document).ready(function() {
	
	//Active the selected Rows
	var punchTableTrActive;
	$("#punchTable tbody tr").click(function() {
		$("#punchTable tbody tr").each(function(i) {
			$(this).removeClass('trActive');
		});
		$(this).addClass('trActive');
		punchTableTrActive = this;
	});

	if (punchTableTrActive) {
		$("#"+punchTableTrActive.id).addClass('trActive');
	}
	$('[data-toggle="tooltip"]').tooltip(); 
});

// Method to generate url for uploading files
function convertFileToDataURLviaFileReader(url,callback) {
	
	var xhr = new XMLHttpRequest();
	xhr.onload = function() {
		var reader = new FileReader();
		reader.onloadend = function() {

			callback(reader.result);
		}
		reader.readAsDataURL(xhr.response);
	};
	xhr.open('GET', url);
	xhr.responseType = 'blob';
	xhr.send();
}

//warning message to Tag cannot be deleted
function existTagwarn(id)
{
	
	$("#dialog-confirm").html("Tags that are in use cannot be deleted.");

    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
    	resizable: false,
    	modal: true,
    	title: "Warning",
    	open: function() {
    		$("#dialog-confirm").parent().addClass("jqueryPopupHead");
    		$("body").addClass('noscroll');

    	},
    	close: function() {
    		$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    		$("body").removeClass('noscroll');

    	},
    	buttons: {

    		"close": function () {
    			$(this).dialog('close');
    			$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    			$("body").removeClass('noscroll');

    		}
    	}
    });
}

//Method will show confirm alert box for delete
function DelTagconfirm(id) {
	
	$("#dialog-confirm").html("Are you sure to delete the Tag ?");

    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
    	resizable: false,
    	modal: true,
    	title: "Confirmation",
    	open: function() {
    		$("#dialog-confirm").parent().addClass("jqueryPopupHead");
    		$("body").addClass('noscroll');

    	},
    	close: function() {
    		$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    		$("body").removeClass('noscroll');

    	},
    	buttons: {

    		"No": function () {
    			$(this).dialog('close');
    			$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    			$("body").removeClass('noscroll');

    		},
    		"Yes": function () {
    			$(this).dialog('close');
    			$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    			$("body").removeClass('noscroll');
    			deleteTag(true,id);
    		}
    	}
    });
}
// Common Callback Method
function deleteTag(value,id) {

	if (value) {

		var ajaxHandler = window.ajaxUrlPrefix + 'projectTags-ajax.php?method=DeleteTags';
		var ajaxQueryString =
		'responseDataType=json&id='+id;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				if (data == 1) { 
					messageAlert('Tag Deleted successfully', 'successMessage');	
					// Listviewupdate();
					$('#record_container--manage-tagging-record--'+id).remove();

				}	
			},
			error: errorHandler
		});

	} 
}
// unit name value allow or restrict
function allowToUserEditTags(allow){
	if(allow){
		$('#entypo-edit-icon').css('display','none');
		$('#entypo-lock-icon').css('display','block');
		$('.unit-text').css('display','none');
		$('.unit-edit').css('display','block');
	}else{
		$('#entypo-edit-icon').css('display','block');
		$('#entypo-lock-icon').css('display','none');
		$('.unit-text').css('display','block');
		$('.unit-edit').css('display','none');
	}
}

//to update a unit name 
function Tag_update(id,value,tag_id){
	if(value =="")
	{
		$("#"+id).addClass('redborder');
		return false;
	}else
	{
		$("#"+id).removeClass('redborder');
	}
	var ajaxHandler = window.ajaxUrlPrefix + 'projectTags-ajax.php?method=updateTagName';
	var ajaxQueryString =
	'responseDataType=json&tag_id='+tag_id+'&tag_name='+encodeURIComponent(value);
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
			if(data=='1')
			{
				$(".tag_name--"+tag_id).empty().html(value);
				messageAlert('Tag Updated successfully', 'successMessage');	

			}
			
		},
		error: errorHandler
	});

}

