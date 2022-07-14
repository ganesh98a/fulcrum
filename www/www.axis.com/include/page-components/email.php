<?php
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
 * Builds a widget for composing email.
 *
 * @param string $from sender's email address
 * @param string $to comma-separated list of recipient email addresses
 * @param string $subject message subject
 * @param string $body message body
 * @return string containing widget html
 */
function buildEmailWidget($ajaxHandler, $sender_contact_id=null, $recipient_role_group_id=null, $subject=null, $body=null, $database=null, $user_company_id=null)
{
	$contact = Contact::findContactByIdExtended($database, $sender_contact_id);
	$from = $contact->email;
	$to = '';
	$recipients = Contact::loadContactsByUserCompanyIdAndRoleGroupId($database, $user_company_id, $recipient_role_group_id);
	if ($recipients) {
		foreach ($recipients as $contact_id => $contact) {
			$to .= $contact->email . ', ';
		}
		if (strlen($to) > 1) {
			$to = rtrim($to, ', ');
		}
	}

	$emailWidgetHtml = <<<END_EMAIL_WIDGET_HTML
<div class="widgetContainer">
	<div class="title">Compose Email Message</div>
	<div class="content">
		<form id="formEmailMessage">
			<table cellpadding="5" style="width:100%">
				<tr><td style="width:50px">From:</td><td><input type="text" id="" name="from" value="'.$from.'" style="width:100%"></td></tr>
				<tr><td style="width:50px">To:</td><td><input type="text" id="" name="to" value="'.$to.'" style="width:100%"></td></tr>
				<tr><td style="width:50px">Cc:</td><td><input type="text" id="" name="cc" value="" style="width:100%"></td></tr>
				<tr><td style="width:50px">Bcc:</td><td><input type="text" id="" name="bcc" value="" style="width:100%"></td></tr>
				<tr><td style="width:50px">Subject:</td><td><input type="text" id="" name="subject" value="'.$subject.'" style="width:100%"></td></tr>
			</table>
			&nbsp;Body:<br>
			<div><textarea name="body" style="width:100%; height:150px; ">'.$body.'</textarea></div>
			<div id="test"
				class="boxViewUploader"
				folder_id="test"
				project_id="test"
				virtual_file_path="test"
				virtual_file_name="test"
				action="test"
				method="test"
				allowed_extensions="test"
				drop_text_prefix=""
				style="margin-top:15px">
			</div>
			<div class="textAlignRight">
				<input type="button" value="Cancel">
				<input type="button" value="Send" onclick="sendEmail();">
			</div>
		</form>
	</div>

	<div id="uploadProgressWindow" class="uploadResult" style="display: none;">
		<h3>FILE UPLOAD PROGRESS: <input type="button" value="Close File Progress Window" onclick="document.getElementById('uploadProgressWindow').style.display='none';"></h3>
		<ul id="UL-FileList" class="qq-upload-list"></ul>
		<span id="uploadProgressErrorMessage"></span>
	</div>
</div>
<script>
function sendEmail()
{
	try {

		var form = $("#formEmailMessage");
		var ajaxHandler = '$ajaxHandler';
		var ajaxQueryString = form.serialize();
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: sendEmailSuccess,
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

function sendEmailSuccess(data, textStatus, jqXHR)
{
	try {

		alert(data);
		var form = $("#formEmailMessage")[0];
		form.reset();

	} catch (error) {

	}
}
</script>
END_EMAIL_WIDGET_HTML;

	return $emailWidgetHtml;
}
