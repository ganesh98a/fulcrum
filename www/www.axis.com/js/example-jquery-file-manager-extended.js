$(document).ready( function() {
	loadTree();
});

$(document).bind("ajaxStop", function() {
	//$('#messageDiv').hide();
	//$('#divAjaxLoading').hide();
	//alert('ajaxStop');
	$(".selectable").selectable({
		stop: selectionStop
	});

	$(".selectable > li > a").click( selectableClicked);

});

function loadTree(){
	$('#divProjectFiles').fileTree({ root: '/www.axis.com/', script: '/example-jquery-file-manager-ajax.php?method=loadFiles' }, function(file){previewFile(file);} );
}


function selectableClicked(){
	$(this).toggleClass("ui-selected");

}


function selectionStop(event, ui){
	//alert('selectionStopped:  set draggables');
	$(".ui-selected").draggable({
		snap: true,
		axis: "y",
		snap: ".directory",
		start: showDroppables,
		helper: function(){
			var selected = $(".ui-selected").parents('li');
			//alert(selected.length);
			if (selected.length === 0) {
				selected = $(this);
			}
			var container = $('<div/>').attr('id', 'draggingContainer');
			container.append(selected.clone());
			return container;
		}
	});
}

function showDroppables(event,ui){
	$(".directory").addClass("droppable");

	$(".droppable").droppable({
		activeClass: "droppableActive",
		hoverClass: "droppableHover",
		drop: objectDropped
	});
}

function objectDropped(event, ui)
{
	try {

		var newPath = $(this).attr('id');
		var existingPath = ui.draggable.attr('id');
		$(".directory").removeClass("droppable");

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-file-manager-file-browser-ajax.php?method=moveFileToNewLocation';
		var ajaxQueryString =
			'newPath=' + encodeURIComponent(newPath) +
			'&existingPath=' + encodeURIComponent(existingPath);
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
			success: objectDroppedSuccess,
			error: errorHandler
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function objectDroppedSuccess(result, textStatus, jqXHR)
{
	try {

		loadTree();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function previewFile(file)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'example-jquery-file-manager-ajax.php?method=loadPreview';
		var ajaxQueryString =
			'file=' + encodeURIComponent(file);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divPreview").load(ajaxUrl);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
