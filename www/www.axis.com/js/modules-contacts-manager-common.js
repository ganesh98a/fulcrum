
function Contacts_Manager__Common__updateContact(element, options)
{
	try {

		// If the options object was not passed as an argument, update it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.ajaxHandlerScript = 'modules-contacts-manager-ajax.php?method=updateContactField';

		// Pass this in for Contacts Manager Module
		//options.successCallback = updateFieldSuccess;

		updateContact(element, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
