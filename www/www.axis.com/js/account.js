
function showHideAccountMessages(elementId)
{
	$("#" + elementId).toggle();
	//$("#accountMessages").hide();
}

function deleteUserRegistrationLogRecord(user_registration_log_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		user_registration_log_id = $.trim(user_registration_log_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'account-ajax.php?method=deleteUserRegistrationLogRecord';
		var ajaxQueryString =
			'user_registration_log_id=' + encodeURIComponent(user_registration_log_id);
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
			success: deleteUserRegistrationLogRecordSuccess,
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

function deleteUserRegistrationLogRecordSuccess(response, textStatus, jqXHR)
{
	try {

		//alert(response);
		var messageText = 'User Registration Log record successfully deleted.';
		messageAlert(messageText, 'successMessage');

		$("#" + response).hide();
		var userRegistrationLogMessageCount = $("#userRegistrationLogMessageCount").val();
		//alert(userRegistrationLogMessageCount);
		userRegistrationLogMessageCount--;
		$("#userRegistrationLogMessageCount").val(userRegistrationLogMessageCount);
		//alert(userRegistrationLogMessageCount);
		if (userRegistrationLogMessageCount < 1) {
			$("#userRegistrationLogMessages").hide();
			$("#accountMessages").hide();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function hideUserRegistrationLogRecord(user_registration_log_id)
{
	$("#" + user_registration_log_id).hide();
	var userRegistrationLogMessageCount = $("#userRegistrationLogMessageCount").val();
	//alert(userRegistrationLogMessageCount);
	userRegistrationLogMessageCount--;
	$("#userRegistrationLogMessageCount").val(userRegistrationLogMessageCount);
	//alert(userRegistrationLogMessageCount);
	if (userRegistrationLogMessageCount < 1) {
		$("#userRegistrationLogMessages").hide();
		$("#accountMessages").hide();
	}
}
