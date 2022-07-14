
function Purchasing_Subcontractor_Bid_List_Report__updateBidderListReport(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		//options.responseDataType = 'json';

		var theStatus = $("#ddlStatus").val();
		if (theStatus == null) {
			theStatus = '';
		}

		var theSortBy = $("#ddlSortBy").val();
		if (theSortBy == null) {
			theSortBy = '';
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadPurchasingBidderListReport';
		var ajaxQueryString =
			'responseDataType=json' +
			'&sbs=' + encodeURIComponent(theStatus) +
			'&sbo=' + encodeURIComponent(theSortBy);
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
			success: Purchasing_Subcontractor_Bid_List_Report__updateBidderListReportSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Purchasing_Subcontractor_Bid_List_Report__updateBidderListReportSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var htmlContent = json.htmlContent;
			$("#divBidderLog").html(htmlContent);

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
