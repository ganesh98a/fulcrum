$(document).ready(function() {
	
	
	$('[data-toggle="tooltip"]').tooltip(); 
});
// Method for Create building Dialog box ajax
function showPunchitem(punch_id,element, options)
{
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		
		var ajaxHandler = window.ajaxUrlPrefix + 'modules_punch_list_ajax.php?method=showpunchitemAttach';
		var ajaxQueryString =
		'punch_id=' + encodeURIComponent(punch_id) +
		'&attributeGroupName=show-punch-record' +
		'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}
		var arrSuccessCallbacks = [ showPunchitemSuccessCallbacks ];
		var successCallback = options.successCallback;
		if (successCallback) {
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: arrSuccessCallbacks,
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


// Method for open Create buildings Dialog
function showPunchitemSuccessCallbacks(data, textStatus, jqXHR)
{
	try {
		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var htmlContent = json.htmlContent;

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			// var dialogWidth = windowWidth * 0.99;
			// var dialogHeight = windowHeight * 0.98;
			var dialogWidth ='500';
			var dialogHeight = '250';

			$("#divpunchlist").html(htmlContent);
			$("#divpunchlist").removeClass('hidden');
			$("#divpunchlist").dialog({
				modal: true,
				title: 'Attachements',
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divpunchlist").addClass('hidden');
					$("#divpunchlist").dialog('destroy');

				},
				buttons: {
					'View Punch List PDF':function()
					{
						$(".punchpdf").click();
					},
					'Close': function() {
						$("#divpunchlist").dialog('close');
					}
					
					
				}
			});
			createUploaders();
	
		}
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			console.log('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function punch__openpdfInNewTab(url)
{
	window.open(url, '_blank');
}
