/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * Library of file upload functions.
 */

function appendTempFileIds(arrFileManagerFiles, options)
{
	try {

		var options = options || {};
		//options.promiseChain = true;

		$("#file-uploader-container--temp-files").show();

		var htmlAttributeGroup = options.htmlAttributeGroup;
		var tempFileUploaderElementId = options.tempFileUploaderElementId;
		var uploadedTempFilesContainerElementId = options.uploadedTempFilesContainerElementId;

		var tempFileUploadPosition = $("#temp-files-next-position--request_for_information_attachments").val();

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var tempFileName = fileManagerFile.tempFileName;
			var tempFileSha1 = fileManagerFile.tempFileSha1;
			var tempFilePath = fileManagerFile.tempFilePath;
			//var tempFileUploadPosition = fileManagerFile.tempFileUploadPosition;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var rfiAttachmentSourceContactFullName = fileManagerFile.rfiAttachmentSourceContactFullName;

			// Encode for HTML
			var urlEncodedTempFileName = encodeURIComponent(tempFileName);
			var encodedTempFileName = htmlEncode(tempFileName);
			var encoded_virtual_file_mime_type = htmlEncode(virtual_file_mime_type);
			var encodedRfiAttachmentSourceContactFullName = htmlEncode(rfiAttachmentSourceContactFullName);

			/*
			var hiddenLiElement =
			' \
			<li id="' + htmlAttributeGroup + '--position--' + tempFileUploadPosition + '" \
				class="hidden" \
				tempFileName="' + encodedTempFileName + '" \
				tempFileUploadPosition="' + tempFileUploadPosition + '" \
				virtual_file_mime_type="' + encoded_virtual_file_mime_type + '"></li>';

			$("#" + uploadedTempFilesContainerElementId).append(hiddenLiElement);
			*/

			var fileUrl = '/__temp_file__?tempFileSha1=' + tempFileSha1 + '&tempFilePath=' + tempFilePath + '&tempFileName=' + urlEncodedTempFileName + '&tempFileMimeType=' + encoded_virtual_file_mime_type;
			var trElementId = 'record_container--' + htmlAttributeGroup + '--request_for_information_attachments--position--' + tempFileUploadPosition;

			var trElement =
			' \
			<tr id="' + trElementId + '" \
				class="record_container--uploaded-temp-file--temp-files" \
				tempFileName="' + encodedTempFileName + '" \
				tempFileUploadPosition="' + tempFileUploadPosition + '" \
				virtual_file_mime_type="' + encoded_virtual_file_mime_type + '"> \
				<td width="60%"> \
					<a href="javascript:removeDomElement(\'' + trElementId + '\');">X</a> \
					<a href="' + fileUrl + '" target="_blank">' + tempFileName + '</a> \
				</td> \
				<td width="40%">' + encodedRfiAttachmentSourceContactFullName + '</td> \
			</tr>';

			if (tempFileUploadPosition == 1) {
				$("#" + uploadedTempFilesContainerElementId).append(trElement);
			} else {
				$("#" + uploadedTempFilesContainerElementId + ' tr:last').after(trElement);
			}
		}

		// Update position
		var nextTempFileUploadPosition = parseInt(tempFileUploadPosition) + 1;
		$("#temp-files-next-position--request_for_information_attachments").val(nextTempFileUploadPosition);
		//$("#" + tempFileUploaderElementId).attr('file_upload_position', nextTempFileUploadPosition);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function generateTempFileListAsJsonEncodedString(htmlAttributeGroup, options)
{
	try {

		var options = options || {};
		//options.promiseChain = true;

		var arrTempFileLiElements = $("#record_list_container--" + htmlAttributeGroup);

		var arrTempFileObjects = [];
		$(arrTempFileLiElements).each ( function( tmpIndex, tmpElement ) {
			var encodedTempFileName = $(tmpElement).attr('tempFileName');
			var encodedTempFileUploadPosition = $(tmpElement).attr('tempFileUploadPosition');
			var encoded_virtual_file_mime_type = $(tmpElement).attr('virtual_file_mime_type');

			// Decode for HTML
			var tempFileName = htmlDecode(tempFileName);
			var tempFileUploadPosition = htmlDecode(tempFileUploadPosition);
			var virtual_file_mime_type = htmlDecode(virtual_file_mime_type);

			// Create javascript object
			var tempFileObject = { 'tempFileName': tempFileName, 'tempFileUploadPosition': tempFileUploadPosition, 'virtual_file_mime_type': virtual_file_mime_type };

			arrTempFileObjects.push(tempFileObject);
		});

		var tempFileListAsJsonEncodedString = JSON.stringify(arrTempFileObjects);

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(tempFileListAsJsonEncodedString);
			if (continueDebug != true) {
				return;
			}
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
