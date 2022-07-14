<?php
/**
 * Account management - update email address (users table).
 *
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

/* @var $post Egpcs */
$post->sessionClear();

$messageScope = 'account-management-email-form.php';
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset();

/* @var $session Session */
$session->setFormSubmitted(true);

// Verify new email 1
if (!$post->new_email1) {
	$message->enqueueError('Please enter a new email address.', $messageScope);
}

// Verify new email 2
if (!$post->new_email2) {
	$message->enqueueError('Please re-enter your new email address.', $messageScope);
}

// Verify email match
if ($post->new_email1 && $post->new_email2 && ($post->new_email1 != $post->new_email2)) {
	$message->enqueueError('Email and confirm email must match.', $messageScope);
}

// Verify email not the same as current
if ($post->currentEmail && $post->new_email1 && $post->new_email2 && ($post->new_email1 == $post->new_email2) && ($post->new_email1 == $post->currentEmail)) {
	$message->enqueueError('Please choose a new email address.', $messageScope);
}

// Verify email 1 via regex
if ($post->new_email1) {
	require_once('lib/common/Validate.php');
	$emailValidFlag = Validate::email2($post->new_email1);
	if (!$emailValidFlag) {
		$message->enqueueError('Please enter a valid email address.', $messageScope);
	}
}

// Verify currentPassword
$passwordLength = strlen($post->currentPassword);
if (!$post->currentPassword || ($passwordLength < 5)) {
	$message->enqueueError('Please enter a valid password.', $messageScope);
}

$arrErrorMessages = $message->getQueue($messageScope, 'error');
if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
	$message->sessionPut();
	$post->sessionPut('account-management-email-form.php');
	$url = 'account-management-email-form.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
} else {
	// Authenticate user
	$username = $session->getLoginName();
	$password = $post->currentPassword;
	if (is_int(strpos($username, '@'))) {
		$u = User::findUserByEmailAuthentication($database, $username, $password, '');
	} elseif (ctype_digit($username)) {
		$u = User::findUserByMobilePhoneNumberAuthentication($database, $username, $password, '');
	} else {
		$u = false;
	}

	if ($u) {
		// Update email address (users table)
		// High Security Risk
		$key = array('id' => $u->id);
		$u->setKey($key);
		$data = $u->getData();
		$data['email'] = $post->new_email1;
		$updatedData = array('email' => $post->new_email1);
		$u->setData($updatedData);
		unset($u->created);
		unset($u->accessed);
		unset($u->modified);
		$u->save();
		// Set full data values for email/sms alerts below
		$u->setData($data);
		$session->setLoginName($post->new_email1);

		$message->resetAll();
		$message->enqueueConfirm('Your email address has been successfully updated.', $messageScope);
		$message->sessionPut();
		$post->sessionClear();
		$session->setFormSubmitted(false);

		// Send out a confirmation SMS or Email alert message
		// Determine if SMS, Email, or Both
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
		// Name
		if ($u->first_name && $u->last_name) {
			$toName = $u->first_name.' '.$u->last_name;
		} else {
			$toName = $u->screen_name;
		}
		$fromEmail = 'Alert@MyFulcrum.com';
		$fromName = 'Fulcrum Alert';
		$alertMessageSubject = 'Account Email Address Updated!';
		$alertMessageBody = "Old Email Address: $post->currentEmail\nNew Email Address:  $post->new_email1";
		$htmlAlertMessageBody = nl2br($alertMessageBody);

		require_once('lib/common/Mail.php');

		if ($emailFlag) {
			// Send an email to the old and the new email address

			// old email address
			$toEmail = $post->currentEmail;
			$mail = new Mail();
			$mail->setBodyText($alertMessageBody);
			$mail->setBodyHtml('<h2>'.$htmlAlertMessageBody.'</h2>');
			$mail->setFrom($fromEmail, $fromName);
			$mail->addTo($toEmail, $toName);
			$mail->setSubject($alertMessageSubject);
			$mail->send();

			// new email address
			$toEmail = $post->new_email1;
			$mail = new Mail();
			$mail->setBodyText($alertMessageBody);
			$mail->setBodyHtml('<h2>'.$htmlAlertMessageBody.'</h2>');
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
			MessageGateway_Sms::sendSmsMessage($u->mobile_phone_number, $u->mobile_network_carrier_id, $toName, $fromEmail, $fromName, $alertMessageSubject, $alertMessageBody);
		}

		$url = 'account-management-email-form.php?hideForm=1';
		header('Location: '.$url);
		exit;
	} else {
		// error message
		$message->reset();
		$message->enqueueError('Invalid password.', $messageScope);
		$message->enqueueError('Please enter your password for authentication.', $messageScope);
		$message->sessionPut();
		$post->sessionPut('account-management-email-form.php');
		$url = 'account-management-email-form.php'.$uri->queryString;
		header('Location: '.$url);
		exit;
	}
}
