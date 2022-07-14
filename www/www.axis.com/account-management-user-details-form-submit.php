<?php
/**
 * Account management - update Optional Personal Information (user_details table).
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

/* @var $session Session */
$session->setFormSubmitted(true);

// Verify currentPassword
$passwordLength = strlen($post->currentPassword);
if (!$post->currentPassword || ($passwordLength < 5)) {
	$message->enqueueError('Please enter a valid password.', 'account-management-user-details-form.php');
}

$error = $message->getQueue();
if (isset($error) && !empty($error)) {
	$message->sessionPut();
	$post->sessionPut('account-management-user-details-form.php');
	$url = 'account-management-user-details-form.php'.$uri->queryString;
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
		/**
		 * $_FILES uploaded via forms
		 *
		 * <form enctype="multipart/form-data" name="frm_name" action="form-submit.php" method="post">
		 * <input type="hidden" name="MAX_FILE_SIZE" value="4000000">
		 * <input type="file" name="picture" tabindex="123">
		 */
		if (isset($_FILES) && !empty($_FILES)) {
			require_once('lib/common/File.php');
			$arrFiles = File::parseUploadedFiles();
			$file = $arrFiles[0];
			$config = Zend_Registry::get('config');
			$fileUploadDirectory = $config->system->image_photo_upload_path;
			$filePath = $file->moveUploadedFile($fileUploadDirectory);

			// crop file and add a border/dropshadow
			$file->cropImage(70, 70);

			// user_images
			require_once('lib/common/UserImage.php');
			$croppedImage = $file->croppedImage;
			$ui = UserImage::convertFileToUserImage($database, $croppedImage);
			$user_image_id = $ui->getId();

			// update users table
			$u->user_image_id = $user_image_id;
			$u->updateUserImage();
		}

		// Update User Details (user_details table)
		// User details (identifiable information) - High Security Risk
		require_once('lib/common/UserDetail.php');
		$ud = UserDetail::convertPostToUserDetail($database, $post);
		/* @var $ud UserDetail */
		$ud->user_id = $u->id;
		$ud->deltifyAndSave();

		// Confirmation message
		$message->resetAll();
		$message->enqueueConfirm('Your optional account information was successfully updated.', 'account.php');
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
		$fromEmail = 'Alert@myfulcrum.com';
		$fromName = 'Fulcrum Alert';
		$alertMessageSubject = 'Optional Personal Account Information Updated!';
		$alertMessageBody = 'Your Optional Personal Account Information was successfully updated.';
		$htmlAlertMessageBody = nl2br($alertMessageBody);

		require_once('lib/common/Mail.php');
		if ($emailFlag) {
			$toEmail = $u->email;

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

		$url = 'account.php'.$uri->queryString;
		header('Location: '.$url);
		exit;
	} else {
		// error message
		$message->reset();
		$message->enqueueError('Invalid password.', 'account-management-user-details-form.php');
		$message->enqueueError('Please enter your password for authentication.', 'account-management-user-details-form.php');
		$message->sessionPut();
		$post->sessionPut('account-management-user-details-form.php');
		$url = 'account-management-user-details-form.php'.$uri->queryString;
		header('Location: '.$url);
		exit;
	}
}
