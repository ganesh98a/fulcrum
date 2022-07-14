
if (jQuery) {
	$(function() {
		$(".tbodySortable").sortable({ stop: sortCompleted });
		//$(".divSortable").sortable({ stop: sortCompleted });
	});
} else {
	alert('No jQuery.');
}

function sortCompleted(event, ui)
{

	try {

		var item = $(ui.item);
		var row = item[0];
		var id = row.getAttribute('id');
		var re = /\d+/;
		// Remove any non-digit characters from id.
		id = id.match(re);
		var index = ($(ui.item).index());
		//alert('row id: ' + id + '\nrow index: ' + index);

		// Fill this in with a real url.
		var ajaxHandler = window.ajaxUrlPrefix + 'path/to/ajax/hander?method=someMethod';
		var ajaxQueryString =
			'id=' + id +
			'&index=' + index;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug !== true) {
				return;
			}
		}

		// Uncomment after we set up a handler.
		/*
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: sortCompletedSuccess,
			error: errorHandler
		});
		*/

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function sortCompletedSuccess(data, textStatus, jqXHR)
{
	try {

		// Do something.

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
