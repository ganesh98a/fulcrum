function toggleTempFileFormUrl(element, javaScriptEvent)
{
	var formElement = element.form;
	var formActionUrl = $(formElement).attr('action');

	// Debug
	//alert(formActionUrl);

	if (element.checked) {

		// Add url directive
		// addURLParameter(uri, key, value)
		var updatedFormActionUrl = addURLParameter(formActionUrl, 'uploadTempFilesOnly', '1');

		element.form.method = 'uploadTempFilesOnly';

	} else {

		// Remove url directive
		// function removeURLParameter(url, parameter)
		var updatedFormActionUrl = removeURLParameter(formActionUrl, 'uploadTempFilesOnly')

	}

	// Debug
	//alert(updatedFormActionUrl);

	$(formElement).attr('action', updatedFormActionUrl);

}

function toggleFileUploaderMethodValue(element, javaScriptEvent, htmlAttributeGroup, value)
{
	alert(value);

	var checked = $(element).is(':checked') || false;
	if (checked) {
		// E.g. temp-file-uploader--method
		$("#" + htmlAttributeGroup + '--method').val(value);
	}

}

function submitUnitTestFileUploadForm(formElement, javaScriptEvent)
{
	// Convert some form elements to a query string
	var formQueryString = $(formElement).serialize();
	//alert('formQueryString: ' + formQueryString);

	// Grab the current form submit url
	var formActionUrl = $(formElement).attr('action');
	//alert('formActionUrl: ' + formActionUrl);

	// Combine the form submit url and the form query string
	var updatedFormActionUrl = appendQueryStringToURL(formActionUrl, formQueryString)
	//alert('updatedFormActionUrl: ' + updatedFormActionUrl);

	// Update the form submit url to include the form query string
	$(formElement).attr('action', updatedFormActionUrl);

	//alert($(formElement).attr('action'));

	if (window.ajaxUrlDebugMode) {
		var continueDebug = window.confirm(updatedFormActionUrl);
		if (continueDebug != true) {
			return false;
		}
	}

	return true;

	/*
	$input = new Input();
	$input->id = 'uploader--request_for_information_attachments--manage-request_for_information-record';
	$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/RFIs/';
	$input->virtual_file_name = "RFI #$rfi_sequence_number Attachment #$attachmentNumber.pdf";
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadRequestForInformationAttachment';
	$input->allowed_extensions = 'pdf';
	$input->post_upload_js_callback = "RFIs__postProcessRfiAttachmentsViaPromiseChain(arrFileManagerFiles, 'container--request_for_information_attachments--manage-request_for_information-record')";
	*/

}

function ajaxFormSubmit(element, javaScriptEvent)
{
	$(element.form).submit();
}

function appendTempFileIds(arrFileManagerFiles, options)
{
	try {

		var options = options || {};
		options.promiseChain = true;
		//options.htmlRecordType = 'dropdown';

		var htmlAttributeGroup = options.htmlAttributeGroup;
		var uploadedTempFilesContainerElementId = options.uploadedTempFilesContainerElementId;

		// This was for storing all file names in a single csv list
		// We are going to use individual <input type="hidden"> elements for each uploaded temp file instead
		//var csvTempFileNameList = $(hiddenCsvTempFileNameListInputElementId).val();
		//var arrExistingTempFileNameList = csvTempFileNameList.split(',');

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var tempFileName = fileManagerFile.tempFileName;
			var tempFileUploadPosition = fileManagerFile.tempFileUploadPosition;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;

			// Encode for HTML
			var encodedTempFileName = htmlEncode(tempFileName);
			var encodedTempFileUploadPosition = htmlEncode(tempFileUploadPosition);
			var encoded_virtual_file_mime_type = htmlEncode(virtual_file_mime_type);

			var hiddenInputElement = '<li id="' + htmlAttributeGroup + '--position--' + tempFileUploadPosition + '" class="hidden" tempFileName="' + encodedTempFileName + '" tempFileUploadPosition="' + encodedTempFileUploadPosition + '" value="" virtual_file_mime_type="' + encoded_virtual_file_mime_type + '"></li>';
			uploadedTempFilesContainerElementId.append(hiddenInputElement);


			//arrExistingTempFileNameList.push(encodedTempFilePath);
		}

		//var newCsvTempFileNameList = arrExistingTempFileNameList.join(',');
		//$(hiddenCsvTempFileNameListInputElementId).val(newCsvTempFileNameList);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
