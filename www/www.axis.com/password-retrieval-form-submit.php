<?php
/**
 * Automated password retreival.
 */
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['post_required'] = true;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset('password-retrieval-form.php');

// Verify username
if (!$post->auth_name || (strlen($post->auth_name) < 5)) {
	$message->enqueueError('Please enter a valid email address.', 'password-retrieval-form.php');
}

// Verify CAPTCHA
$captchaInput = $post->captcha_input;
$captchaInput = strtolower($captchaInput);
$captchaActual = $session->captcha_actual;
if (!$post->captcha_input) {
	$message->enqueueError('Please enter the visible characters below.', 'password-retrieval-form.php');
} elseif ($captchaInput != $captchaActual) {
	$message->enqueueError('The characters entered do not match what was pictured.', 'password-retrieval-form.php');
}

if (!$message->queueEmpty('password-retrieval-form.php')) {
	$message->sessionPut();
	$post->sessionPut('password-retrieval-form.php');
	$url = 'password-retrieval-form.php' . $uri->queryString;
	header('Location: '.$url);
	exit;
} else {
	$email = $post->auth_name;
	// eventually allow email and/or mobile phone number for password retrieval
	$mobile_phone_number = false;

	$arrReturn = User::resetUserPassword($database, $email, $mobile_phone_number);

	$u = $arrReturn['user'];
	$arrErrors = $arrReturn['errors'];

	if (!empty($arrErrors) || (!$u instanceof User)) {
		$message->enqueueError('Please enter a valid email address.', 'password-retrieval-form.php');
		$message->sessionPut();
		$post->sessionPut('password-retrieval-form.php');
		$url = 'password-retrieval-form.php' . $uri->queryString;
		header('Location: '.$url);
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
	$contact = new Contact($database);
	$key = array('user_company_id' => $u->user_company_id, 'user_id' => $u->user_id);
	$contact->setKey($key);
	$contact->load();
	$contact->convertDataToProperties();
	if ($contact->first_name && $contact->last_name) {
		$toName = $contact->first_name.' '.$contact->last_name;
		$smsToName = $contact->first_name;
	} else {
		$toName = $u->screen_name;
		$smsToName = $u->screen_name;
	}

	$fromName = 'Fulcrum Alert';
	$fromEmail = 'service@myfulcrum.com';
	$smsFromName = 'Fulcrum';
	$smsFromEmail = 'alert@myfulcrum.com';

	// Subject Line
	$alertMessageSubject = 'Your Fulcrum account password was successfully reset!';
	$smsAlertMessageSubject = 'Password Reset';

	// Include the new password in the URL here for the "Password Update Form".
	// It will auto-populate the "Existing Password" field with the auto-generated password value.
	$autoLoginLinkHtml	= $uri->https . 'l.php?p='.$u->password_guid.'&amp;n='.$newPassword;
	$autoLoginLinkSms	= $uri->https . 'l.php?p='.$u->password_guid.'&n='.$newPassword;
	$loginLink			= $uri->https . 'login-form.php';
	//$timestamp = date("D, M j g:i A", (time()+86400)); // @todo Eventually make the link have an expiration
	$timestamp = date("D, M j g:i A", time());

	if ($emailFlag) {
		$requestInitiatedBy = "$toName ($u->email)";
	} else {
		// sms version
		$requestInitiatedBy = "$toName ($u->mobile_phone_number)";
	}

	// SMS and Text Email clients
	$smsAlertMessageBody = "New Password: $newPassword $autoLoginLinkSms";
//	$alertHeadline =
//		"Temporary Password: $newPassword\n".
//		"Please copy and paste your temporary password to <a href=\"$loginLink\">Manually Login</a> or use this &ldquo;<a href=\"$autoLoginLinkHtml\">Auto-Login</a>&rdquo; link.\n";
//	$htmlAlertHeadline = nl2br($alertHeadline);
//	$alertBody =
//		"\nPassword Reset Occurred: $timestamp\n".
//		"Password Reset Initiated By: $requestInitiatedBy\n";
//	$alertMessageBody = $alertHeadline.$alertBody;
// HTML Email output for Email clients that support HTML
/*
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
*/
$htmlAlertHeadline = "";
$htmlAlertMessageBody = <<<END_HTML_MESSAGE
A request was received to reset your password.  <b><a href="$autoLoginLinkHtml">Please click here to set a new password.</a></b>
If the above link does not work, try entering the following temporary password:  $newPassword
<br><br>
If you did not initiate this request to reset your password, please contact <a href="mailto:support@myfulcrum.com">support@myfulcrum.com</a>.
<br><br>
END_HTML_MESSAGE;

	ob_start();
	$headline = 'Password Reset';
	$useSquareCorners = true;
	include('templates/mail-template.php');
	$bodyHtml = ob_get_clean();

	require_once('lib/common/Mail.php');

	if ($emailFlag) {
		$toEmail = $u->email;

		$mail = new Mail();

		$mail->addHeader("X-Priority", "1");
		$mail->addHeader("X-MSMail-Priority", "High");
		$mail->addHeader("Importance", "High");

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
		MessageGateway_Sms::sendSmsMessage($u->mobile_phone_number, $u->mobile_network_carrier_id, $smsToName, $smsFromEmail, $smsFromName, $smsAlertMessageSubject, $smsAlertMessageBody);
	}

	$message->resetAll();
	$message->enqueueConfirm('Your password has been reset.', 'password-retrieval-form.php');
	$message->enqueueConfirm('You should receive your temporary password soon via Email, SMS, or both depending on your settings.', 'password-retrieval-form.php');
	$message->sessionPut();

	//Log user in and forward them into their account management.
//	$session->setUserId($user_id);
//	$session->setLoginName($u->email);
	$post->sessionClear();

	unset($session->captcha_actual);

	$url = 'password-retrieval-form.php?hideForm=1';
	header('Location: '.$url);
	exit;
}

//default is to redirect to portal entrance
header('Location: login-form.php' . $uri->queryString);
exit;
