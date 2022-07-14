<?php
/**
 * Password management.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
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
$message->reset();

$session->setFormSubmitted(true);

/* @var $post Egpcs */
$post->sessionClear();

//Verify password
if (!isset($post->auth_pass) || (strlen($post->auth_pass) < 5)) {
	$message->enqueueError('Please enter your current password.', 'account-management-password-form.php');
}

//Verify new password 1
if (!$post->new_pass1 || (strlen($post->new_pass1) < 5)) {
	$message->enqueueError('Please enter a new password of five characters or more.', 'account-management-password-form.php');
}

//Verify new password 2
if (!$post->new_pass2 || (strlen($post->new_pass2) < 5)) {
	$message->enqueueError('Please re-enter your new password of five characters or more.', 'account-management-password-form.php');
}

//Verify password match
if ($post->new_pass1 && $post->new_pass2 && ($post->new_pass1 != $post->new_pass2)) {
	$message->enqueueError('Password and confirm password must match.', 'account-management-password-form.php');
}

$error = $message->getQueue();
if (isset($error) && !empty($error)) {
	if (Session::getInstance()->getForgotPassword()) {
		$message->enqueueInfo('Please update your account password to continue.', 'account-management-password-form.php');
	}
	$message->sessionPut();
	$post->sessionPut('account-management-password-form.php');
	header('Location: account-management-password-form.php');
	exit;
} else {
	// Update user security information
	// Authenticate user
	$username = $session->getLoginName();
	$password = $post->auth_pass;
	$newPassword = $post->new_pass1;

	// Use true authentication here as the user is updating their password as must enter their original password to authenticate.
	$u = User::findUserByEmailAuthentication($database, $username, $password, '');
	/* @var $u User */

	if ($u) {
		// Attempt to update the user's password
		$passwordUpdatedFlag = $u->updatePassword($database, $newPassword);

		$message->resetAll();
		$message->enqueueConfirm('Your password was successfully updated.', 'account-management-password-form.php');
		$message->sessionPut();
		$post->sessionClear();
		$session->setFormSubmitted(false);

		$session->setForgotPassword(false);

		// Send out a confirmation SMS or Email alert message
		// Determine if SMS, Email, or Both
		// Account password changed alert messages
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
		$alertMessageSubject = 'Your MyFulcrum account password was successfully updated!';
		$smsAlertMessageSubject = 'Password Updated';

		// Include the new password in the URL here for the "Password Update Form".
		// It will auto-populate the "Existing Password" field with the auto-generated password value.
		$autoLoginLink	= $uri->https . 'l.php?p='.$u->password_guid;
		$loginLink		= $uri->https . 'login-form.php';
		//$timestamp = date("D, M j g:i A", (time()+86400)); // @todo Eventually make the link have an expiration
		$timestamp = date("D, M j g:i A", time());

		if ($emailFlag) {
			$requestInitiatedBy = "$toName ($u->email)";
		} else {
			// sms version
			$requestInitiatedBy = "$toName ($u->mobile_phone_number)";
		}

		// SMS and Text Email clients
		$smsAlertMessageBody = 'Login: '.$autoLoginLink;
		$alertHeadline = 'Your <a href="'.$loginLink.'">Fulcrum</a> password was successfully updated.';
		$htmlAlertHeadline = $alertHeadline;
		$alertBody =
			"\nPassword Update Occurred: $timestamp\n".
			"Password Update Initiated By: $requestInitiatedBy\n";
		$alertMessageBody = $alertHeadline.$alertBody;
// HTML Email output for Email clients that support HTML
$htmlAlertMessageBody = <<<END_HTML_MESSAGE
<b><a href="$autoLoginLink">Click Here</a> to Auto-Login (does not require entering a password).</b>
<br>
<small>Note: Simply bookmark the above link to have an automated login link from your browser or desktop.</small>
<br>
<br>
<b><a href="$loginLink">Click Here</a> to Manually Login (requires entering a password).</b>
<br>
<small>Note: Bookmark the above link to have a manual login link from your browser or desktop.</small>
<br>
<br>
Password Update Occurred: $timestamp
<br>
Password Update Initiated By: $requestInitiatedBy
<br>
END_HTML_MESSAGE;

		ob_start();
		$headline = 'Password Updated';
		include('templates/mail-template.php');
		$bodyHtml = ob_get_clean();

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
			MessageGateway_Sms::sendSmsMessage($u->mobile_phone_number, $u->mobile_network_carrier_id, $smsToName, $smsFromEmail, $smsFromName, $smsAlertMessageSubject, $smsAlertMessageBody);
		}

		$url = 'account-management-password-form.php?hideForm=1';
		header('Location: '.$url);
		exit;
	} else {
		// error message
		$message->reset();
		$message->enqueueError('Invalid password.', 'account-management-password-form.php');
		$message->enqueueError('Please enter your password for authentication.', 'account-management-password-form.php');
		$message->sessionPut();
		$post->sessionPut('account-management-password-form.php');
		$url = 'account-management-password-form.php'.$uri->queryString;
		header('Location: '.$url);
		exit;
	}
}
