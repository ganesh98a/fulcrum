<?php
/**
 * Link a contact to a user.
 *
 */
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
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

// Verify employer_identification_number
if (!$post->ein) {
	$message->enqueueError('Please enter a valid Company Federal Tax ID.', 'account-registration-form-step2.php');
}

$error = $message->getQueue();
if (isset($error) && !empty($error)) {
	$message->sessionPut();
	$post->sessionPut('account-registration-form-step2.php');
	$baseUrl = 'account-registration-form-step2.php';
	$url = $baseUrl.$uri->queryString;
	header('Location: '.$url);
	exit;
} else {
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
	} else {
		// Verify this page is actually needed for the user_invitations record
		$contact_id = $userInvitation->contact_id;
		require_once('lib/common/Contact.php');
		$contact = new Contact($database);
		$key = array('id' => $contact_id);
		$contact->setKey($key);
		$contact->load();
		$contact->convertDataToProperties();

		$contact_company_id = $contact->contact_company_id;
		require_once('lib/common/ContactCompany.php');
		$contactCompany = new ContactCompany($database);
		$key = array('id' => $contact_company_id);
		$contactCompany->setKey($key);
		$contactCompany->load();
		$contactCompany->convertDataToProperties();

		$contact_user_company_id = $contactCompany->contact_user_company_id;

		if ($contact_user_company_id != 1) {
			// The contact is already linked to a "Registered User Company"
			$url = "/account-registration-form-step3.php?guid=$guid";
			header("Location: $url");
			exit;
		}
	}

	// Core class are already included
	$userCompany = new UserCompany($database);
	$employer_identification_number = $post->ein;
	$key = array('employer_identification_number' => $employer_identification_number);
	$userCompany->setKey($key);
	$userCompany->load();
	$dataLoadedFlag = $userCompany->isDataLoaded();

	// Update the user_invitations table with newly provided employer_identification_number value
	$data = array('employer_identification_number' => $employer_identification_number);
	if ($dataLoadedFlag) {
		$userCompany->convertDataToProperties();
		$user_company_id = $userCompany->user_company_id;

		// Update the user_invitations table with newly provided contact_user_company_id value
		// This value was derived from the lookup to the user_companies table via the "employer_identification_number" attribute
		$data['contact_user_company_id'] = $user_company_id;
	}
	$userInvitation->setData($data);
	$userInvitation->save();

	$url = "/account-registration-form-step3.php?guid=$guid";
	header("Location: $url");
	exit;
}
