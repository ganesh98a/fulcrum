<?php
/**
 * User account management.
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

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset();

$session->setFormSubmitted(true);

// Verify Alerts
if (!$post->alertTypes) {
	$message->enqueueError('Please select a valid alert option.', 'account-management-security-information-form.php');
	$requireMobilePhoneFlag = false;
} else {
	if (in_array('smsAlert', $post->alertTypes)) {
		$requireMobilePhoneFlag = true;
	} else {
		$requireMobilePhoneFlag = false;
	}
}

// Verify Mobile Phone Number
if (isset($requireMobilePhoneFlag) && $requireMobilePhoneFlag) {
	if (!$post->mobile_phone_area_code || !$post->mobile_phone_prefix || !$post->mobile_phone_number) {
		$message->enqueueError('Please enter a valid mobile phone number.', 'account-management-security-information-form.php');
	}

	// Verify Mobile Network Carrier
	if (!$post->mobile_network_carrier_id) {
		$message->enqueueError('Please choose a valid cell phone carrier.', 'account-management-security-information-form.php');
	}
}

// Verify Email
if (!$post->email) {
	$message->enqueueError('Please enter a valid email address.', 'account-management-security-information-form.php');
}

// Verify Screen Name
if (!$post->screen_name) {
	$message->enqueueError('Please enter a valid screen name.', 'account-management-security-information-form.php');
}

$error = $message->getQueue();
if (isset($error) && !empty($error)) {
	$message->sessionPut();
	$post->sessionPut('account-management-security-information-form.php');
	$url = 'account-management-security-information-form.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
} else {
	// Authenticate user

	$user_id = $session->getUserId();
	if ($user_id > 0) {

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// User login/account information
		// users table
		$userExisting = User::findUserById($database, $user_id);
		/* @var $userExisting User */
		$userNewData = User::convertPostToStandardUser($database, $post);
		/* @var $userNewData User */

		$db->begin();

		// Check for uniqueness of new values (UUIDs)
		// email
		if ($userExisting->email <> $userNewData->email) {
			$tmpUserId = User::findUserIdByEmail($database, $userNewData->email);

			if ($tmpUserId && $tmpUserId <> $user_id) {
				$message->enqueueError('Please enter a valid email address that is not already in use.', 'account-management-security-information-form.php');
			}
		}
		// mobile_phone_number
		if (isset($requireMobilePhoneFlag) && $requireMobilePhoneFlag) {
			$tmpUserId = User::findUserIdByMobilePhoneNumber($database, $userNewData->mobile_phone_number);

			if ($tmpUserId && $tmpUserId <> $user_id) {
				$message->enqueueError('Please enter a valid mobile phone number that is not already in use.', 'account-management-security-information-form.php');
			}
		}
		// screen_name
		if ($userExisting->screen_name <> $userNewData->screen_name) {
			$tmpUserId = User::findUserIdByScreenName($database, $userNewData->screen_name);

			if ($tmpUserId && $tmpUserId <> $user_id) {
				$message->enqueueError('Please enter a valid screen name that is not already in use.', 'account-management-security-information-form.php');
			}
		}
		$error = $message->getQueue();
		if (!empty($error)) {
			$db->rollback();
			$message->sessionPut();
			$post->sessionPut('account-management-security-information-form.php');
			$url = 'account-management-security-information-form.php'.$uri->queryString;
			header('Location: '.$url);
			exit;
		}

		$u = IntegratedMapper::deltifyAndUpdate($userExisting, $userNewData);
		/* @var $u User */

		// Update session values
		$username = $session->getLoginName();
		if ($username <> $u->email) {
			$session->setLoginName($u->email);
		}

		// Update contact information
		require_once('lib/common/Contact.php');
		$primary_contact_id = $session->getPrimaryContactId();
		$contactExisting = Contact::findContactById($database, $primary_contact_id);
		$contactNewData = Contact::convertPostToStandardContact($database, $post);
		$c = IntegratedMapper::deltifyAndUpdate($contactExisting, $contactNewData);
		/* @var $contactExisting Contact */
		/* @var $contactNewData Contact */
		/* @var $c Contact */

		$db->commit();

		$message->resetAll();
		$message->enqueueConfirm('You have successfully updated your account login, security information, and settings.', 'account-management-security-information-form.php');
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
		// To Name
		if ($c->first_name && $c->last_name) {
			$toName = $c->first_name.' '.$c->last_name;
			$smsToName = $c->first_name;
		} else {
			$toName = $u->screen_name;
			$smsToName = $u->screen_name;
		}

		$fromName = 'Fulcrum Alert';
		$fromEmail = 'service@myfulcrum.com';
		$smsFromName = 'Fulcrum';
		$smsFromEmail = 'alert@myfulcrum.com';

		// Subject Line
		$alertMessageSubject = 'Account Login Information Updated';
		$smsAlertMessageSubject = 'Account Updated ';

		// Include the new password in the URL here for the "Password Update Form".
		// It will auto-populate the "Existing Password" field with the auto-generated password value.
		$autoLoginLink	= $uri->https . 'l.php?p='.$u->password_guid;
		$loginLink		= $uri->https . 'login-form.php';
		$timestamp = date("D, M j g:i A", time());

		if ($emailFlag) {
			$requestInitiatedBy = "$toName ($u->email)";
		} else {
			// sms version
			$requestInitiatedBy = "$toName ($u->mobile_phone_number)";
		}

		// SMS and Text Email clients
		$smsAlertMessageBody = 'Login: '.$autoLoginLink;
		$alertHeadline = 'Your <a href="'.$loginLink.'">Fulcrum</a> Account Login Information was successfully updated.';
		$htmlAlertHeadline = $alertHeadline;
		$alertBody =
			"\nAccount Login Information Update Occurred: $timestamp\n".
			"Account Login Information Update Initiated By: $requestInitiatedBy\n";
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
Account Login Information Update Occurred: $timestamp
<br>
Account Login Information Update Initiated By: $requestInitiatedBy
<br>
END_HTML_MESSAGE;

		ob_start();
		$headline = 'Account Login Information Updated';
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
			MessageGateway_Sms::TwilioSmsMessage($u->mobile_phone_number, $smsAlertMessageSubject, $smsAlertMessageBody);
			// MessageGateway_Sms::sendSmsMessage($u->mobile_phone_number, $u->mobile_network_carrier_id, $smsToName, $smsFromEmail, $smsFromName, $smsAlertMessageSubject, $smsAlertMessageBody);
		}

		$url = '/account-management-security-information-form.php?hideForm=1';
		header('Location: '.$url);
		exit;
	} else {
		$message->reset();
		$message->enqueueError('Invalid password.', 'account-management-security-information-form.php');
		$message->enqueueError('Please enter your password for authentication.', 'account-management-security-information-form.php');
		$message->sessionPut();
		$post->sessionPut('account-management-security-information-form.php');
		$url = 'account-management-security-information-form.php'.$uri->queryString;
		header('Location: '.$url);
		exit;
	}
}
