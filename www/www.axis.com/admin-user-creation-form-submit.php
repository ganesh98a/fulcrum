<?php
/**
 * User profile.
 *
 */
$init['access_level'] = 'global_admin';
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

$db = DBI::getInstance($database);
/* @var $db DBI_mysqli */

/* @var $post Egpcs */
$post->sessionClear();

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset();

$session->setFormSubmitted(true);

// Check if update mode
if (isset($get) && $get->mode && ($get->mode == 'update')) {
	$checkPasswordFields = false;

	// Convert ddl_user_id to user_id
	if ($post->ddl_user_id) {
		$post->user_id = $post->ddl_user_id;
	}

	// Verify User (user_id)
	if (!$post->user_id) {
		$message->enqueueError('Please select a valid user.', 'admin-user-creation-form.php');
	}
} else {
	$checkPasswordFields = true;
}

// Convert ddl_user_company_id to user_company_id
if ($post->ddl_user_company_id) {
	$post->user_company_id = $post->ddl_user_company_id;
}

// Convert ddl_user_role_id to role_id
if ($post->ddl_user_role_id) {
	$post->role_id = $post->ddl_user_role_id;
}

// Error Handling - users

// Verify Alerts
if (!$post->alertTypes) {
	$message->enqueueError('Please select a valid alert option.', 'admin-user-creation-form.php');
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
		$message->enqueueError('Please enter a valid mobile phone number.', 'admin-user-creation-form.php');
	} else {
		// Phone Number is parsed and non-numeric values are removed
		$mobile_phone_number = $post->mobile_phone_area_code.$post->mobile_phone_prefix.$post->mobile_phone_number;
		if (isset($mobile_phone_number) && !empty($mobile_phone_number)) {
			try {
				// Sanity check/final validation of phone number values
				require_once('lib/common/PhoneNumber.php');
				$pn = PhoneNumber::parsePhoneNumber($mobile_phone_number);
				$area_code = $pn->area_code;
				$prefix = $pn->prefix;
				$number = $pn->number;
			} catch (Exception $e) {
				$db->rollback();
				$message->enqueueError('Invalid mobile phone number.', 'admin-user-creation-form.php');
				trigger_error('');
				break;
			}
		} else {
			$area_code = '';
			$prefix = '';
			$number = '';
		}
		$mobile_phone_number = $area_code.$prefix.$number;
	}

	// Verify Mobile Network Carrier
	if (!$post->mobile_network_carrier_id) {
		$message->enqueueError('Please choose a valid cell phone carrier.', 'admin-user-creation-form.php');
	}
}

// Verify Company (user_company_id)
if (!$post->user_company_id) {
	$message->enqueueError('Please select a valid company.', 'admin-user-creation-form.php');
}

// Verify role (role_id)
if (!$post->role_id) {
	$message->enqueueError('Please select an access level.', 'admin-user-creation-form.php');
}

// Verify Email
if (!$post->email) {
	$message->enqueueError('Please enter a valid email address.', 'admin-user-creation-form.php');
}


// Verify Valid Email address
$validContactEmailFlag = Validate::email2($post->email);
if (!$validContactEmailFlag) {
	$message->enqueueError('Please enter a valid email address.', 'admin-user-creation-form.php');
}

// Verify Screen Name
if (!$post->screen_name) {
	$message->enqueueError('Please enter a valid screen name.', 'admin-user-creation-form.php');
}

if ($checkPasswordFields) {
	// Verify password
	$passwordLength = strlen($post->password);
	if (!$post->password || ($passwordLength < 5) || ($post->password != $post->password2)) {
		$message->enqueueError('Please enter a valid password of five characters or more.', 'admin-user-creation-form.php');
	}

}

$error = $message->getQueue();
if (isset($error) && !empty($error)) {
	$message->sessionPut();
	$post->sessionPut('admin-user-creation-form.php');
	$baseUrl = 'admin-user-creation-form.php';
	$url = $baseUrl.$uri->queryString;
	header('Location: '.$url);
	exit;
} else {
	require_once('lib/common/UserDetail.php');
	require_once('lib/common/ContactCompany.php');
	require_once('lib/common/Contact.php');
	require_once('lib/common/ContactToRole.php');

	// The characteristics of the user
	if (isset($_FILES['picture']['name']) && !empty($_FILES['picture']['name'])) {
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
		$post->user_image_id =$user_image_id;
	} else {
		$user_image_id = 0;
	}


	// User login/account information
	// users table
	$u = User::convertPostToStandardUser($database, $post);
	/* @var $u User */

	// Insert or delete
	if (isset($get) && $get->mode && ($get->mode == 'update')) {
		$user_id = $get->user_id;
		// users table
		$userExisting = User::findUserById($database, $user_id);
		/* @var $userExisting User */
		$userNewData = $u;

		$db->begin();

		// Check for uniqueness of new values (UUIDs)
		// email
		if ($userExisting->email <> $userNewData->email) {
			$tmpUserId = User::findUserIdByEmail($database, $userNewData->email);

			if ($tmpUserId && $tmpUserId <> $user_id) {
				$message->enqueueError('Please enter a valid email address that is not already in use.', 'admin-user-creation-form.php');
			}
		}
		// mobile_phone_number
		if (isset($requireMobilePhoneFlag) && $requireMobilePhoneFlag) {
			$tmpUserId = User::findUserIdByMobilePhoneNumber($database, $userNewData->mobile_phone_number);

			if ($tmpUserId && $tmpUserId <> $user_id) {
				$message->enqueueError('Please enter a valid mobile phone number that is not already in use.', 'admin-user-creation-form.php');
			}
		}
		// screen_name
		if ($userExisting->screen_name <> $userNewData->screen_name) {
			$tmpUserId = User::findUserIdByScreenName($database, $userNewData->screen_name);

			if ($tmpUserId && $tmpUserId <> $user_id) {
				$message->enqueueError('Please enter a valid screen name that is not already in use.', 'admin-user-creation-form.php');
			}
		}
		$error = $message->getQueue();
		if (!empty($error)) {
			$db->rollback();
			$message->sessionPut();
			$post->sessionPut('admin-user-creation-form.php');
			$url = 'admin-user-creation-form.php'.$uri->queryString;
			header('Location: '.$url);
			exit;
		}

		$u = IntegratedMapper::deltifyAndUpdate($userExisting, $userNewData);
		/* @var $u User */

		$db->commit();
	} else {
		// INSERT records for:
		// 1) users table
		// 2) contacts table (done at later step to allow for error handling at this step)
		$arrUserReturn = $u->registerUserAccount($database);
		$user_company_id = $post->user_company_id;
		$user_user_company_id = $user_company_id;
		$isUserExitsOnContact = contact::checkUserEmailOnContacts($database,$u->email,$user_user_company_id);
		$user_id = $arrUserReturn['user_id'];
	}

	// Process errors and redirect back to the registration form
	if ($user_id == -1) {
		$arrErrors = $arrUserReturn['errors'];

		// Potential mobile_phone_number conflict
		if (isset($arrErrors['mobile_phone_number'])) {
			$mobilePhoneError = $arrErrors['mobile_phone_number'];
			if ($mobilePhoneError) {
				$message->enqueueError('Please enter a different mobile phone number. This one is already in use.', 'admin-user-creation-form.php');
			}
		}

		// Potential email conflict
		if (isset($arrErrors['email']) || $isUserExitsOnContact) {
			$emailError = $arrErrors['email'];
			if ($emailError) {
				$message->enqueueError('Please enter a different email address. This one is already in use.', 'admin-user-creation-form.php');
			}
		}

		// Potential screen_name conflict
		if (isset($arrErrors['screen_name'])) {
			$screenNameError = $arrErrors['screen_name'];
			if ($screenNameError) {
				$message->enqueueError('Please enter a different screen name. This one is already in use.', 'admin-user-creation-form.php');
			}
		}

		$message->sessionPut();
		$post->sessionPut('admin-user-creation-form.php');
		$url = '/admin-user-creation-form.php'.$uri->queryString;
		header("Location: $url");
		exit;
	}


	// This may become payment/billing information
	// user_details (identifiable information) - High Security Risk
	$ud = UserDetail::convertPostToUserDetail($database, $post);
	/* @var $ud UserDetail */
	$ud->user_id = $user_id;
	$ud->convertPropertiesToData();
	$ud->deltifyAndSave();


	// Update contacts table with user_details values
	// contacts record creation
	// contacts (identifiable information) - High Security Risk
	// This is the User creation for a given User Company so the user_user_company_id and contact_user_company_id values will be the same.
	$user_company_id = $post->user_company_id;
	$user_user_company_id = $user_company_id;
	$contact_user_company_id = $user_company_id;
	$contactCompany = ContactCompany::findContactCompanyByUserCompanyIdValues($database, $user_user_company_id, $contact_user_company_id);
	$contact_company_id = $contactCompany->contact_company_id;

	$contact = Contact::convertPostToStandardContact($database, $post);
	/* @var $c Contact */
	$contact->user_company_id = $user_company_id;
	$contact->user_id = $user_id;
	$contact->contact_company_id = $contact_company_id;

	// This should allow for the following cases:
	// 1) contact already exists from contact creation
	// 2) user already exists from user creation without an existing contact record
	$c = Contact::findContactByUserCompanyIdAndUserId($database, $user_company_id, $user_id);
	if ($c) {
		// contact already exists from previous contact creation
		$contact_id = $c->contact_id;
		$contact->convertPropertiesToData();
		$newData = $contact->getData();
		$existingData = $c->getData();
		$data = Data::deltify($existingData, $newData);
		if (!empty($data)) {
			$c->setData($data);
			$key = array('id' => $contact_id);
			$c->setKey($key);
			$c->save();
		}
	} else {
		// user already exists from user creation without an existing contact record
		$contact_id = $contact->deltifyAndSave();
	}

	// @todo Update case
	// mobile_phone_number
	if ($requireMobilePhoneFlag) {
		// Insert into contact_phone_numbers
		// unique index(`contact_id`, `phone_number_type_id`),
		// unique index(`contact_id`, `phone_number_type_id`, `country_code`, `area_code`, `prefix`, `number`, `extension`, `itu`),
		require_once('lib/common/PhoneNumberType.php');
		require_once('lib/common/ContactPhoneNumber.php');
		$contactPhoneNumber = new ContactPhoneNumber($database);
		$data = array(
			'contact_id' => $contact_id,
			'phone_number_type_id' => PhoneNumberType::MOBILE,
			'country_code' => '', // add this later...
			'area_code' => $area_code,
			'prefix' => $prefix,
			'number' => $number,
			'extension' => '', // add this later...
			'itu' => '',
		);
		$contactPhoneNumber->setData($data);
		$contact_phone_number_id = $contactPhoneNumber->save();

		$mobile_network_carrier_id = $post->mobile_network_carrier_id;

		// Insert into mobile_phone_numbers
		// Check if the mobile_phone_number already exists in the users table
		// Insert into mobile_phone_numbers if not already in use
		// UUID check occurred above so okay
		if (
			isset($contact_phone_number_id) && !empty($contact_phone_number_id) &&
			isset($mobile_network_carrier_id) && !empty($mobile_network_carrier_id)) {
			require_once('lib/common/MobilePhoneNumber.php');
			$mobilePhoneNumber = new MobilePhoneNumber($database);
			$mobilePhoneNumber->user_id = $contact->user_id;
			$mobilePhoneNumber->contact_id = $contact_id;
			$mobilePhoneNumber->contact_phone_number_id = $contact_phone_number_id;
			$mobilePhoneNumber->mobile_network_carrier_id = $mobile_network_carrier_id;
			$mobilePhoneNumber->convertPropertiesToData();
			$mobilePhoneNumber->save();

			require_once('lib/common/MessageGateway/Sms.php');
			$smsAlertMessageSubject="Hi $post->screen_name ,
			A New Account has been created";
			MessageGateway_Sms::TwilioSmsMessage($mobile_phone_number, $smsAlertMessageSubject, $smsAlertMessageBody);
		}
	}

	// update contacts_to_roles with <contact_id, 3> and possibly <contact_id, role_id>
	$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
	$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
	ContactToRole::addContact($database, $contact_id);
	if ($u->role_id <> $AXIS_USER_ROLE_ID_ADMIN)
	{
		ContactToRole::RemoveAdminToContact($contact_id, $AXIS_USER_ROLE_ID_ADMIN);
	}
	if ($u->role_id <> $AXIS_USER_ROLE_ID_USER) {
		ContactToRole::addRoleToContact($database, $contact_id, $u->role_id);
	}

	// update the users table with the primary_contact_id value being $contact_id
	$tmpUser = new User($database);
	$key = array('id' => $user_id);
	$tmpUser->setKey($key);
	$data = array('primary_contact_id' => $contact_id);
	$tmpUser->setData($data);
	$tmpUser->save();

	if (isset($get) && $get->mode && ($get->mode == 'update')) {
		$successMessage = 'User successfully updated.';
	} else {
		$successMessage = 'User successfully created.';
	}

	$message->resetAll();
	$message->enqueueConfirm($successMessage, 'admin-user-creation-form.php');
	$message->sessionPut();

	$post->sessionClear();
	$session->setFormSubmitted(false);

	$url = '/admin-user-creation-form.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
}
