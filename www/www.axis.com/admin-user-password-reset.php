<?php
/**
 * Reset a user's password and email/sms it to them.
 */
if (isset($_GET['ajax']) && $_GET['ajax']) {
	$init['ajax'] = true;
}
$init['access_level'] = 'admin';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['get_required'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

// Determine is ajax is calling
if ($get->ajax) {
	$ajaxFlag = true;
	// The ajax error handler derives the file name automatically
	$messageScope = 'admin-user-password-reset.php';
} else {
	$ajaxFlag = false;
	$messageScope = 'admin-user-creation-form.php';
}

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($messageScope);

// Verify user_id
if (!$get->user_id) {
	$message->enqueueError('Please select a user for password reset.', $messageScope);
}

// Verify email
if (!$get->email) {
	$message->enqueueError('Please select a user with a valid email address for password reset.', $messageScope);
}

if (!$message->queueEmpty($messageScope)) {
	if ($ajaxFlag) {
		trigger_error('Invalid input.', E_USER_ERROR);
	} else {
		$message->sessionPut();
		$post->sessionPut('admin-user-creation-form.php');
		$url = 'admin-user-creation-form.php' . $uri->queryString;
		header('Location: '.$url);
	}
	exit;
} else {
	$email = $get->email;
	// eventually allow email and/or mobile phone number for password retrieval
	$mobile_phone_number = false;

	$arrReturn = User::resetUserPassword($database, $email, $mobile_phone_number);

	$u = $arrReturn['user'];
	$arrErrors = $arrReturn['errors'];

	if (!empty($arrErrors) || (!$u instanceof User)) {
		$message->enqueueError('Please enter a valid email address.', 'admin-user-creation-form.php');

		if ($ajaxFlag) {
			trigger_error('Invalid input.', E_USER_ERROR);
		} else {
			$message->sessionPut();
			$post->sessionPut('admin-user-creation-form.php');
			$url = 'admin-user-creation-form.php' . $uri->queryString;
			header('Location: '.$url);
		}
		exit;
	}

	$newPassword = $u->newPassword;

	// Send out a confirmation SMS or Email
	// Account creation email
	// determine if SMS, Email, or both
	$alerts = $u->alerts;

	if ($alerts == 'Both') {
		$emailFlag = true;
		$smsFlag = true;
	} elseif ($alerts == 'Email') {
		$emailFlag = true;
		$smsFlag = false;
	} elseif ($alerts == 'SMS') {
		$emailFlag = false;
		$smsFlag = true;
	} else {
		$emailFlag = true;
		$smsFlag = true;
	}

	// Email/SMS Details
	// To Name
	require_once('lib/common/Contact.php');
	$contact = Contact::findContactByUserCompanyIdAndUserId($database, $u->user_company_id, $u->user_id);
	if ($contact->first_name && $contact->last_name) {
		$toName = $contact->first_name.' '.$contact->last_name;
		$smsToName = $contact->first_name;
	} else {
		$toName = $u->screen_name;
		$smsToName = $u->screen_name;
	}

	// Load the Account Admin's Information
	$accountAdminUserCompanyId = $session->getUserCompanyId();
	$accountAdminUserId = $session->getUserId();
	$accountAdminUserCompany = UserCompany::findUserCompanyByUserCompanyId($database, $accountAdminUserCompanyId);
	$accountAdminName = '';
	if ($accountAdminUserCompany->company) {
		$closeParen = true;
		$accountAdminName = $accountAdminUserCompany->company .' (';
	} else {
		$closeParen = false;
	}
	$accountAdminContact = Contact::findContactByUserCompanyIdAndUserId($database, $accountAdminUserCompanyId, $accountAdminUserId);
	if ($accountAdminContact->first_name && $accountAdminContact->last_name) {
		if (!empty($accountAdminName)) {
			$accountAdminName .= $accountAdminContact->first_name.' '.$accountAdminContact->last_name;
		}
	} else {
		$accountAdminName .= $session->getLoginName();
	}
	if ($closeParen) {
		$accountAdminName .= ')';
	}

	$fromName = 'Fulcrum Alert';
	$fromEmail = 'service@myfulcrum.com';
	$smsFromName = 'Fulcrum';
	$smsFromEmail = 'alert@myfulcrum.com';

	// Subject Line
	$alertMessageSubject = 'Your Fulcrum account password has been reset!';
	$smsAlertMessageSubject = 'Password Reset';

	// Include the new password in the URL here for the "Password Update Form".
	// It will auto-populate the "Existing Password" field with the auto-generated password value.
	$autoLoginLinkHtml	= $uri->https . 'l.php?p='.$u->password_guid.'&amp;n='.$newPassword;
	$autoLoginLinkSms	= $uri->https . 'l.php?p='.$u->password_guid.'&n='.$newPassword;
	$loginLink			= $uri->https . 'login-form.php';
	$timestamp = date("D, M j g:i A", time());
	$requestInitiatedBy = "$accountAdminName";
	// SMS and Text Email clients
	$smsAlertMessageBody = " New Password: $newPassword $autoLoginLinkSms";
	$alertHeadline =
		"Temporary Password: $newPassword\n".
		"Please copy and paste your temporary password to <a href=\"$loginLink\">Manually Login</a> or use this &ldquo;<a href=\"$autoLoginLinkHtml\">Auto-Login</a>&rdquo; link.\n";
	$htmlAlertHeadline = nl2br($alertHeadline);
	$alertBody =
		"\nPassword Reset Occurred: $timestamp\n".
		"Password Reset Initiated By: $requestInitiatedBy\n";
	$alertMessageBody = $alertHeadline.$alertBody;
// HTML Email output for Email clients that support HTML
$htmlAlertMessageBody = <<<END_HTML_MESSAGE
<b><a href="$autoLoginLinkHtml">Click Here</a> to Auto-Login (does not require entering a password).</b>
<br>
<small>Note: Simply bookmark the above link to have an automated login link from your browser or desktop.</small>
<br>
<br>
<b><a href="$loginLink">Click Here</a> to Manually Login (requires entering a password).</b>
<br>
<small>Note: Bookmark the above link to have a manual login link from your browser or desktop.</small>
<br>
<br>
Password Reset Occurred: $timestamp
<br>
Password Reset Initiated By: $requestInitiatedBy
<br>
END_HTML_MESSAGE;
$bodyHtml =(isset($bodyHtml))?$bodyHtml:"";

	ob_start();
	$headline = 'Password Reset';
	$useSquareCorners = true;
	include('templates/mail-template.php');

	require_once('lib/common/Mail.php');

	if ($emailFlag) {
		$toEmail = $u->email;

		$mail = new Mail();
		$mail->setBodyText($alertMessageBody);
		$mail->setBodyHtml($bodyHtml);
		$mail->setFrom($fromEmail, $fromName);
		$mail->addTo($toEmail, $toName);
		$mail->setSubject($alertMessageSubject);
		$mail->send();
	}

	if ($smsFlag) {
		/**
		 * MessageGateway_Sms
		 */
		require_once('lib/common/MessageGateway/Sms.php');
		$sucess=MessageGateway_Sms::TwilioSmsMessage($u->mobile_phone_number, $smsAlertMessageSubject, $smsAlertMessageBody);
	}

	if ($ajaxFlag) {

		$escapedEmail = htmlentities($email, ENT_QUOTES);
		$customSuccessMessage = "Password successfully reset for: $escapedEmail";

		$arrOutput = array(
			'customSuccessMessage' => $customSuccessMessage
		);
		$output = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		// echo $output;

	} else {
		$confirmationMessage = $u->email . ' should should receive a temporary password soon.';
		$message->resetAll();
		$message->enqueueConfirm($confirmationMessage, 'admin-user-creation-form.php');
		$message->sessionPut();
		$get->sessionClear();
		$url = 'admin-user-creation-form.php'.$uri->queryString;
		header('Location: '.$url);
	}
	exit;
}

//default is to redirect to portal entrance
header('Location: login-form.php' . $uri->queryString);
exit;
