<?php
/**
 * User invitation workflow.
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

/* @var $post Egpcs */
$post->sessionClear();

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset();

$session->setFormSubmitted(true);

$registrationStep = $post->registrationStep;

// Verify access to this page via the GUID passed in on the $_GET query string
$accessDenied = true;
if (isset($get) && $get->guid) {
	$guid = $get->guid;
	require_once('lib/common/UserInvitation.php');
	$userInvitation = UserInvitation::verifyInvitation($database, $guid);
	/* @var $userInvitation UserInvitation */

	if ($userInvitation && ($userInvitation instanceof UserInvitation)) {
		$accessDenied = false;
	}
}

if ($accessDenied) {
	$url = $uri->referrer;
	header("Location: $url");
	exit;
}

// Core class are already included
require_once('lib/common/Contact.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/Date.php');
require_once('lib/common/UserDetail.php');



// wrap everything is a transaction
$db = DBI::getInstance($database);
/* @var $db DBI_mysqli */

//$db->begin();

// An invitation is linked to a project_id, even if project_id = 1
$project_id = $userInvitation->project_id;

/**
 * contact_companies and contacts records will always exist for the user_company_id that initiated the
 * User Invitation process.  The user_company_id may or may not be the same as the new users record.
 *
 */
$currentlyActiveContactId = $userInvitation->contact_id;
$existingContact = new Contact($database);
$existingContact->loadById($currentlyActiveContactId);

$contact_company_id = $existingContact->contact_company_id;
$existingContactCompany = new ContactCompany($database);
$existingContactCompany->loadById($contact_company_id);

// Two cases:
// 1) "Un-registered Company Case" - new user_companies, contact_companies, and users records (contact_user_company_id == 1)
//		update $contactCompany->contact_user_company_id for the existing contact_companies record
//		update $contact->user_id for the existing contacts record
// 2) "Registered Company Case" - new users record only (contact_user_company_id <> 1)
//		update $contact->user_id for the existing contacts record
// Determine if we have a "Registered Company" or not
$contact_user_company_id = $userInvitation->contact_user_company_id;

if ($contact_user_company_id == 1) {
	// account-registration-form-step2.php required the Fed Tax ID to be entered
	// account-registration-form-step2-submit.php checked for a user_companies record based on that Fed Tax ID
	// if contact_user_company_id is 1 then we will be creating a new user_companies record as well as new contact_companies and contacts records
	//		for the newly registered User Company/User
	$companyRegisteredFlag = false;
	// Have to check for existence of records via GUIDs
	$possiblyCreateNewUserCompanyFlag = true;
	$possiblyCreateNewContactCompanyFlag = true;
	$possiblyCreateNewContactFlag = true;
} else {
	$companyRegisteredFlag = true;
	$possiblyCreateNewUserCompanyFlag = false;
	$possiblyCreateNewContactCompanyFlag = false;
	$possiblyCreateNewContactFlag = false;

	if ($existingContactCompany->contact_user_company_id <> $contact_user_company_id) {
		// Update the contact_companies record from the original to have a new contact_user_company_id value
		$data = array(
			'contact_user_company_id' => $contact_user_company_id
		);
		$tmpExistingData = $existingContactCompany->getData();
		$tmpExistingData['contact_user_company_id'] = $contact_user_company_id;
		$existingContactCompany->setData($data);
		// key was set earlier for load() operation
		$existingContactCompany->save();
		$existingContactCompany->setData($tmpExistingData);
		$existingContactCompany->contact_user_company_id = $contact_user_company_id;
	}
}


// Error Handling - user_companies table
if (($existingContactCompany->contact_user_company_id == 1) && ($userInvitation->contact_user_company_id == 1)) {
	// Verify Company Name
	if (!$post->user_company_name) {
		$message->enqueueError('Please enter your Company Name.', 'account-registration-form-step3.php');
	}

	// Verify Employer Identification Number (Fed Tax ID/EIN/SSN)
	if (!$post->employer_identification_number) {
		$message->enqueueError('Please enter your Employer Identification Number (Fed Tax ID/EIN/SSN).', 'account-registration-form-step3.php');
	}

	/*
	// Verify Construction License Number
	if (!$post->construction_license_number) {
		$message->enqueueError('Please enter your Construction License Number.', 'account-registration-form-step3.php');
	}

	// Verify Construction License Number Expiration Date (0000-00-00)
	if (!$post->construction_license_number_expiration_date) {
		$message->enqueueError('Please enter your Construction License Number Expiration Date (0000-00-00).', 'account-registration-form-step3.php');
	}
	*/
}


// Error Handling - users table
// Verify Alerts
if (!$post->alertTypes) {
	$message->enqueueError('Please select a valid alert option.', 'account-registration-form-step3.php');
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
		$message->enqueueError('Please enter a valid mobile phone number.', 'account-registration-form-step3.php');
	}

	// Verify Mobile Network Carrier
	if (!$post->mobile_network_carrier_id || empty($post->mobile_network_carrier_id) || !($post->mobile_network_carrier_id > 1)) {
		$message->enqueueError('Please choose a valid cell phone carrier.', 'account-registration-form-step3.php');
	}
}

// Verify Email
if (!$post->email) {
	$message->enqueueError('Please enter a valid email address.', 'account-registration-form-step3.php');
} else {
	// Validate email
	require_once('lib/common/Validate.php');
	$validEmailFlag = Validate::email2($post->email);
	if (!$validEmailFlag) {
		$message->enqueueError('Please enter a valid email address.', 'account-registration-form-step3.php');
	}
}

//Verify Screen Name
if (!$post->screen_name) {
	$message->enqueueError('Please enter a valid screen name.', 'account-registration-form-step3.php');
}

// Verify password
//Verify new password 1
if (!$post->password || (strlen($post->password) < 5)) {
	$message->enqueueError('Please enter a password of five characters or more.', 'account-registration-form-step3.php');
}

//Verify new password 2
if (!$post->password2 || (strlen($post->password2) < 5)) {
	$message->enqueueError('Please re-enter your password of five characters or more.', 'account-registration-form-step3.php');
}

//Verify password match
if ($post->password && $post->password2 && ($post->password != $post->password2)) {
	$message->enqueueError('&ldquo;Password&rdquo; and &ldquo;Confirm Password&rdquo; must match.', 'account-registration-form-step3.php');
}

// Verify security question
//if (!$post->security_question) {
//	$message->enqueueError('Please choose a valid security question.', 'account-registration-form-step3.php');
//}

// Verify answer to security question
//if (!$post->security_answer) {
//	$message->enqueueError('Please enter an answer to your security question.', 'account-registration-form-step3.php');
//}


// Verify Full Name
//if (!$post->first_name) {
//	$message->enqueueError('Please enter your first name.', 'account-registration-form-step3.php');
//}

// Verify Country
//if (!$post->address_country) {
//	$message->enqueueError('Please select a valid country.', 'account-registration-form-step3.php');
//}

$error = $message->getQueue();
if (isset($error) && !empty($error)) {
	$message->sessionPut();
	/*
	if (isset($_FILES['picture']['name'])) {
		$post->imageFilePath = $_FILES['picture']['name'];
	}
	*/
	$post->sessionPut('account-registration-form-step3.php');

	$url = 'account-registration-form-step3.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
} else {
	// The characteristics of the user
	/**
	 * $_FILES uploaded via forms
	 *
	 * <form enctype="multipart/form-data" name="frm_name" action="form-submit.php" method="post">
	 * <input type="hidden" name="MAX_FILE_SIZE" value="4000000">
	 * <input type="file" name="picture" tabindex="123">
	 */
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


	// user_companies table
	if (($existingContactCompany->contact_user_company_id == 1) && ($userInvitation->contact_user_company_id == 1)) {

		// "Un-registered Company Case"
		$uc = UserCompany::convertPostToStandardUserCompany($database, $post);
		/* @var $uc UserCompany */

		// Insert user_companies record if company info is available
		$arrReturn = $uc->registerUserCompanyAccount($database);
		$user_company_id = $arrReturn['user_company_id'];
		// contact_companies record is created along with the user_companies record
		$contact_company_id = $arrReturn['contact_company_id'];

		// Process errors and redirect back to the registration form
		if (isset($arrReturn['errors']) && !empty($arrReturn['errors'])) {
			$arrErrors = $arrReturn['errors'];

			// Potential company name conflict
			if (isset($arrErrors['user_company_name'])) {
				$companyError = $arrErrors['company'];
				if ($companyError) {
					$message->enqueueError('Please enter a different company name. This one is already in use.', 'account-registration-form-step3.php');
				}
			}

			// Potential employer_identification_number conflict
			if (isset($arrErrors['employer_identification_number'])) {
				$einError = $arrErrors['employer_identification_number'];
				if ($einError) {
					$message->enqueueError('Please enter a different employer identification number. This one is already in use.', 'account-registration-form-step3.php');
				}
			}

			$error = $message->getQueue();
			if (isset($error) && !empty($error)) {
				$message->sessionPut();
				$post->sessionPut('account-registration-form-step3.php');
				$url = '/account-registration-form-step3.php'.$uri->queryString;
				header("Location: $url");
				exit;
			}

		} else {
			// INSERT INTO user_companies_to_software_modules table
			require_once('lib/common/UserCompanyToSoftwareModule.php');
			UserCompanyToSoftwareModule::linkUserCompanyToDefaultSoftwareModules($database, $user_company_id);

			//To inherit the permission set by GA
			require('app/models/permission_mdl.php');
			InheritPermissionForNewCompany($database,$user_company_id);

			// To add admin role
			require_once('lib/common/ContactToRole.php');
			ContactToRole::addRoleToContact($database, $userInvitation->contact_id, '2');

			// Update the contact_companies record from the original to have a new contact_user_company_id value
			$data = array(
				'contact_user_company_id' => $user_company_id
			);
			$existingContactCompany->setData($data);
			// key was set earlier for load() operation
			$existingContactCompany->save();
		}
	} else {
		//"Registered Company Case"
		// User company already exists
		$user_company_id = $existingContactCompany->contact_user_company_id;

		// Load the contact_company_id value to ensure correct data for all cases, most especially the sub emp/user case
		$tmpContactCompany = new ContactCompany($database);
		$key = array(
			'user_user_company_id' => $user_company_id,
			'contact_user_company_id' => $user_company_id,
		);
		$tmpContactCompany->setKey($key);
		$tmpContactCompany->load();
		$tmpContactCompany->convertDataToProperties();
		$contact_company_id = $tmpContactCompany->contact_company_id;
	}


	// User login/account information
	// users table
	$u = User::convertPostToStandardUser($database, $post);
	/* @var $u User */

	// All invited users come in as "User" for now
	if ($companyRegisteredFlag) {
		// contact_to_roles with role_id of "admin" may be set
		require_once('lib/common/ContactToRole.php');
		require_once('lib/common/Role.php');
		$arrAssignedRolesByContactId = ContactToRole::loadAssignedRolesByContactId($database, $currentlyActiveContactId);
		if (isset($arrAssignedRolesByContactId[AXIS_USER_ROLE_ID_ADMIN])) {
			$role_id = AXIS_USER_ROLE_ID_ADMIN;
			$userRole = 'admin';
		} else {
			$role_id = AXIS_USER_ROLE_ID_USER;
			$userRole = 'user';
		}
	} else {
		// default to a role of admin for newly registered accounts
		$role_id = AXIS_USER_ROLE_ID_ADMIN;
		$userRole = 'admin';
	}
	$u->role_id = $role_id;

	$u->user_company_id = $user_company_id;

	$u->default_project_id = $project_id;

	$u->primary_contact_id = 1;

	// INSERT records for:
	// 1) users table
	// 2) contacts table (in the user_company_id context of this users "Registered Company"
	$arrUserReturn = $u->registerUserAccount($database);
	$user_id = $arrUserReturn['user_id'];

	// Process errors and redirect back to the registration form
	if ($user_id == -1) {
		$arrErrors = $arrUserReturn['errors'];

		// Potential mobile_phone_number conflict
		if (isset($arrErrors['mobile_phone_number'])) {
			$mobilePhoneError = $arrErrors['mobile_phone_number'];
			if ($mobilePhoneError) {
				$message->enqueueError('Please enter a different mobile phone number. This one is already in use.', 'account-registration-form-step3.php');
			}
		}

		// Potential email conflict
		if (isset($arrErrors['email'])) {
			$emailError = $arrErrors['email'];
			if ($emailError) {
				$message->enqueueError('Please enter a different email address. This one is already in use.', 'account-registration-form-step3.php');
			}
		}

		// Potential screen_name conflict
		if (isset($arrErrors['screen_name'])) {
			$screenNameError = $arrErrors['screen_name'];
			if ($screenNameError) {
				$message->enqueueError('Please enter a different screen name. This one is already in use.', 'account-registration-form-step3.php');
			}
		}

		$message->sessionPut();
		$post->sessionPut('account-registration-form-step3.php');

		$url = 'account-registration-form-step3.php'.$uri->queryString;

		//$url = $uri->http.$url;
		//header('Location: '.$url, true, 302);
		//$arrHeaders = headers_list();
		header("Location: $url");
		exit;
	} else {
		// Always update the user_id of the existing contacts record
		/**
		 * @todo Update phone number with cell phone
		 */
		$data = array(
			'user_id' => $user_id,
			'email' => $post->email,
			'first_name' => $post->first_name,
			'last_name' => $post->last_name,
			'title' => $post->title,
		);
		$tmpExistingData = $existingContact->getData();
		$existingContact->setData($data);
		// key was set earlier for load() operation
		$existingContact->save();
		$existingContact->setData($tmpExistingData);
		$existingContact->user_id = $user_id;
		$existingContact->email = $post->email;
		$existingContact->first_name = $post->first_name;
		$existingContact->last_name = $post->last_name;
		$existingContact->title = $post->title;

		/**
		 * @todo WORK OUT THE CONTACT TO USER LOGIC WITH TEST CASES FOR:
		 *
		 * 1) GC creates a contact that is:
		 * 		a) a sub
		 * 		b) an employee
		 *
		 * 2) Sub creates a contact that is:
		 * 		a) an employee
		 */
		if ($companyRegisteredFlag) {
			// Do not create a new contact_companies record
			// Create a new contact record if one doesn't exist for this company
			if ($existingContact->user_company_id <> $user_company_id) {
				$newContact = Contact::convertPostToStandardContact($database, $post);
				/* @var $newContact Contact */
				$newContact->user_company_id = $user_company_id;
				$newContact->user_id = $user_id;
				$newContact->contact_company_id = $contact_company_id;
				$newContact->convertPropertiesToData();
				$newContactId = $newContact->save();
				$primary_contact_id = $newContactId;
			} else {
				/**
				 * @todo Test this use case...currently no way for a contact to be created and invited without association to a project first.
				 */
				$primary_contact_id = $existingContact->contact_id;
			}
		} else {
			// Create a new contacts record.  The contact_companies record was created above along with a new user_companies record.
			// create the corresponding contacts record if it does not already exist
			// contacts record creation for the "Registered Company" and "new registered user"
			// contacts (identifiable information) - High Security Risk
			$newContact = Contact::convertPostToStandardContact($database, $post);
			/* @var $newContact Contact */
			$newContact->user_company_id = $user_company_id;
			$newContact->user_id = $user_id;
			$newContact->contact_company_id = $contact_company_id;
			$newContact->convertPropertiesToData();
			$newContactId = $newContact->save();
			$primary_contact_id = $newContactId;
		}

		// to update all the email id to the user id instead of 1
		$ExstingContact =  Contact::updateAllExistingContactUserId($database,$post->email,$user_id);
		
		// This should not be necessary, but do it anyway for good measure until the Contacts Manager gets fixed
		// update contacts_to_roles with <contact_id, 3> and possibly <contact_id, role_id>
		require_once('lib/common/ContactToRole.php');
		ContactToRole::addContact($database, $primary_contact_id);
		ContactToRole::addContact($database, $userInvitation->contact_id);

		// update the users table with the primary_contact_id value being $newContactId
		$tmpUser = new User($database);
		$key = array('id' => $user_id);
		$tmpUser->setKey($key);
		$data = array('primary_contact_id' => $primary_contact_id);
		$tmpUser->setData($data);
		$tmpUser->save();
	}

	//$db->commit();


	// This may become payment/billing information
	// user_details (identifiable information) - High Security Risk
	$ud = UserDetail::convertPostToUserDetail($database, $post);
	/* @var $ud UserDetail */
	$ud->user_id = $user_id;
	$ud->convertPropertiesToData();
	$ud->deltifyAndSave();


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
	if (isset($ud) && ($ud->first_name && $ud->last_name)) {
		$toName = $ud->first_name.' '.$ud->last_name;
		$smsToName = $ud->first_name;
	} else {
		$toName = $u->screen_name;
		$smsToName = $u->screen_name;
	}

	$fromName = 'Fulcrum AutoMessage';
	$fromEmail = 'service@myfulcrum.com';
	$smsFromName = 'Fulcrum';
	$smsFromEmail = 'alert@myfulcrum.com';

	// Subject Line
	$alertMessageSubject = 'Fulcrum Account Registration';
	$smsAlertMessageSubject = 'Account Created';

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
	$alertHeadline = 'Your <a href="'.$loginLink.'">Fulcrum</a> Account was successfully created.';
	$htmlAlertHeadline = $alertHeadline;
	$alertBody =
		"\nAccount Registration Occurred: $timestamp\n".
		"Account Registration Initiated By: $requestInitiatedBy\n";
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
Account Registration Occurred: $timestamp
<br>
Account Registration Initiated By: $requestInitiatedBy
<br>
END_HTML_MESSAGE;

	ob_start();
	$headline = 'Account Registration';
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


	$message->resetAll();
	$message->enqueueConfirm('You have successfully registered your Fulcrum Account!', 'account.php');
	$message->sessionPut();

	// Log user in and forward them into their account management.
	$session->setActualUserCompanyId($user_company_id);
	$session->setUserCompanyId($user_company_id);

	$session->setActualUserId($user_id);
	$session->setUserId($user_id);

	$session->setActualPrimaryContactId($primary_contact_id);
	$session->setPrimaryContactId($primary_contact_id);

	$session->setActualLoginName($u->email);
	$session->setLoginName($u->email);

	$session->setActualRoleId($role_id);
	$session->setRoleId($role_id);

	$session->setActualCurrentlySelectedProjectId($project_id);
	$session->setCurrentlySelectedProjectId($project_id);

	$session->setActualUserRole($userRole);
	$session->setUserRole($userRole);

	$currentlySelectedProjectUserCompanyId = $existingContact->user_company_id;
	$session->setActualCurrentlySelectedProjectUserCompanyId($currentlySelectedProjectUserCompanyId);
	$session->setCurrentlySelectedProjectUserCompanyId($currentlySelectedProjectUserCompanyId);

	$currentlySelectedProjectId = $project_id;
	$session->setActualCurrentlySelectedProjectId($currentlySelectedProjectId);
	$session->setCurrentlySelectedProjectId($currentlySelectedProjectId);

	// Load the project name
	require_once('lib/common/Project.php');
	$key = array('id' => $project_id);
	$p = new Project($database);
	$p->setKey($key);
	$p->load();
	$p->convertDataToProperties();
	$currentlySelectedProjectName = $p->project_name;
	$session->setActualCurrentlySelectedProjectName($currentlySelectedProjectName);
	$session->setCurrentlySelectedProjectName($currentlySelectedProjectName);

	/*
	// Link the contact to the project
	$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
	if ($project_id <> $AXIS_NON_EXISTENT_PROJECT_ID) {
		require_once('lib/common/ProjectToContactToRole.php');
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
		ProjectToContactToRole::addRoleToContactOnProject($database, $project_id, $currentlyActiveContactId, $AXIS_USER_ROLE_ID_USER);
	}
	*/

	// Record the User Registration to the user_registration_log
	require_once('lib/common/UserRegistrationLog.php');
	UserRegistrationLog::logUserRegistration($database, $user_id, $currentlyActiveContactId, $project_id);

	$session->setActualCurrentlyActiveContactId($currentlyActiveContactId);
	$session->setCurrentlyActiveContactId($currentlyActiveContactId);

	$post->sessionClear();
	$session->setFormSubmitted(false);

	// Delete user_invitations record
	$userInvitation->delete();

	//$url = $uri->https.'/account.php'.$uri->queryString;
	$url = '/account.php';
	$header = "Location: $url";
	header($header);
	exit;
}
