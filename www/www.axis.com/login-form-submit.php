<?php
/**
 * Account management login.
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
//$init['post_required'] = true;
require_once('lib/common/init.php');

// Check if the login attempt came from a user registration page
$referrerPhpScript = $uri->referrerPhpScript;
if ($referrerPhpScript == 'account-registration-form-bid-response-step1.php') {
	$activeScope = $referrerPhpScript;
	// Will redirect error messages back to the registration URL instead of the standard login form.
	$url = 'account-registration-form-bid-response-step1.php?guid=' . $post->user_invitation_guid . '&pblids=' . $get->pblids. '&answer=' . $get->answer . '&loginErrors=1';
} elseif (is_int(strpos($referrerPhpScript, 'account-registration'))) {
	$activeScope = $referrerPhpScript;
	// Will redirect error messages back to the registration URL instead of the standard login form.
	//$url = $uri->referrer;
	$url = 'account-registration-form-step1.php?guid=' . $post->user_invitation_guid . '&loginErrors=1';
} else {
	$activeScope = 'login-form.php';
	$url = 'login-form.php'.$uri->queryString;
}

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($activeScope);

/* @var $session Session */
$session->setFormSubmitted(true);

// Check for password_guid style login
if (isset($get->p)) {
	// Verify password_guid
	if (!$get->p || (strlen($get->p) <> 32)) {
		$message->enqueueError('Invalid login information.', $activeScope);
		$passwordGuidLogin = false;
	} else {
		$passwordGuidLogin = true;
	}
} else {
	$passwordGuidLogin = false;

	// Verify username
	if (!$post->auth_name || (strlen($post->auth_name) < 5)) {
		$message->enqueueError('Please enter a valid username.', $activeScope);
	}
	// Verify password
	if (!$post->auth_pass || (strlen($post->auth_pass) < 5)) {
		$message->enqueueError('Please enter a valid password.', $activeScope);
	}
}

if (!$message->queueEmpty($activeScope)) {
	$message->sessionPut();
	if (isset($post)) {
		$post->sessionPut($activeScope);
	} elseif (isset($get)) {
		$get->sessionPut($activeScope);
	}
	header('Location: '.$url);
	exit;
} else {
	// Authenticate and authorize
	if ($passwordGuidLogin) {
		$password_guid = $get->p;

		$u = User::findUserByPasswordGuidAuthentication($database, $password_guid, true);
		$username = $u->email;
	} else {
		$username = $post->auth_name;
		$password = $post->auth_pass;

		if (is_int(strpos($username, '@'))) {
			$u = User::findUserByEmailAuthentication($database, $username, $password, '', true);
		} elseif (is_int(ctype_digit($username))) {
			$u = User::findUserByMobilePhoneNumberAuthentication($database, $username, $password, '', true);
		} else {
			$u = User::findUserByScreenNameAuthentication($database, $username, $password, '', true);
		}
	}

	if ($u) {
		$user_company_id = $u->user_company_id;
		$user_id = $u->user_id;
		$role_id = $u->role_id;
		$primary_contact_id = (int) $u->primary_contact_id;

		$isArchive = User::findUserIsArchive($database, $user_id);

		if ($isArchive) {
			// To check the user is archived are not
			$uri = Zend_Registry::get('uri');
			// Error message
			$message->reset();
			$message->enqueueError("Please contact admin for Login...", $activeScope);
			$message->sessionPut();
			if (isset($post)) {
				$post->sessionPut($activeScope);
			} elseif (isset($get)) {
				$get->sessionPut($activeScope);
			}
			$uri->currentPhpScript = $url;
			header('Location: '.$url);
			exit;
		}else{
			// Log user in and forward them into their account management.
			// Check if login is coming from a User Invitation to Join a Project
			// I.e. link the contact to the user
			if (isset($post) && $post->user_invitation_guid) {
				$user_invitation_guid = $post->user_invitation_guid;
				require_once('lib/common/UserInvitation.php');
				$userInvitation = UserInvitation::verifyInvitation($database, $user_invitation_guid);
				/* @var $userInvitation UserInvitation */

				if ($userInvitation && ($userInvitation instanceof UserInvitation)) {
					$contact = new Contact($database);
					$key = array('id' => $userInvitation->contact_id);
					$contact->setKey($key);
					$contact->load();
					$contact->convertDataToProperties();

					$contactCompany = new ContactCompany($database);
					$key = array('id' => $contact->contact_company_id);
					$contactCompany->setKey($key);
					$contactCompany->load();
					$contactCompany->convertDataToProperties();

					// Check if duplicate
					if ($contactCompany->user_user_company_id == $user_company_id) {
						// Error message
						$message->reset();
						$message->enqueueError('Already registered', $activeScope);
						$message->sessionPut();
						if (isset($post)) {
							$post->sessionPut($activeScope);
						} elseif (isset($get)) {
							$get->sessionPut($activeScope);
						}
						header('Location: '.$url);
						exit;
					}

					// Save change to contacts record
					//$contact->user_id = $user_id;
					$data = array(
						'user_id' => $user_id
					);
					$contact->setData($data);
					$contact->save();

					// update contacts_to_roles with <contact_id, 3> and possibly <contact_id, role_id>
					require_once('lib/common/ContactToRole.php');
					ContactToRole::addContact($database, $userInvitation->contact_id);
					// Any additional roles besides "user" that are non-project-specific will be added to contacts_to_roles via the Contacts Manager

					// Update the contact_user_company_id value in contact_companies
					// Save change to contact_companies record
					$data = array(
						'contact_user_company_id' => $user_company_id
					);
					$contactCompany->setData($data);
					$contactCompany->save();

					$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
					if (($u->default_project_id == $AXIS_NON_EXISTENT_PROJECT_ID) && ($userInvitation->project_id <> $AXIS_NON_EXISTENT_PROJECT_ID)) {
						// update default_project_id if it was "1" and the $userInvitation->project_id <> "1"
						$userData = $u->getData();
						$data = array('default_project_id' => $userInvitation->project_id);
						$u->setData($data);
						$u->save();
						$userData['default_project_id'] = $userInvitation->project_id;
						$u->setData($userData);
						$u->default_project_id = $userInvitation->project_id;
					}

					if ($u->currentlySelectedProjectId == $AXIS_NON_EXISTENT_PROJECT_ID) {
						$u->setArrGuestProjects(null);
						$u->loadUserInfo();
					}

					/*
					if (($u->currentlySelectedProjectId == $AXIS_NON_EXISTENT_PROJECT_ID) && ($userInvitation->project_id <> $AXIS_NON_EXISTENT_PROJECT_ID)) {
						$project = Project::findProjectById($database, $userInvitation->project_id);
						if ($project) {
							$currentlySelectedProjectUserCompanyId = $project->user_company_id;
							$currentlySelectedProjectId = $project->project_id;
							$currentlySelectedProjectName = $project->project_name;
							$currentlyActiveContactId = $userInvitation->contact_id;
						}
					}
					*/

					$AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BID = AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BID;
					$user_invitation_type_id = $userInvitation->user_invitation_type_id;
					if ( $user_invitation_type_id == $AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BID) {
						$requestedUri = "/modules-file-manager-file-browser.php";
						$session->setRequestedUri($requestedUri);
					}

					$userInvitation->delete();
				}
			}

			$currentlyActiveTemplateTheme = $u->currentlyActiveTemplateTheme;

			$currentlySelectedProjectUserCompanyId = $u->currentlySelectedProjectUserCompanyId;
			$currentlySelectedProjectId = $u->currentlySelectedProjectId;
			$currentlySelectedProjectName = $u->currentlySelectedProjectName;
			$currentlyActiveContactId = $u->currentlyActiveContactId;

			$session->setActualCurrentlyActiveTemplateTheme($currentlyActiveTemplateTheme);
			$session->setCurrentlyActiveTemplateTheme($currentlyActiveTemplateTheme);

			$session->setActualUserCompanyId($user_company_id);
			$session->setUserCompanyId($user_company_id);

			$session->setActualUserId($user_id);
			$session->setUserId($user_id);

			$session->setActualPrimaryContactId($primary_contact_id);
			$session->setPrimaryContactId($primary_contact_id);

			$session->setActualLoginName($username);
			$session->setLoginName($username);

			$session->setActualRoleId($role_id);
			$session->setRoleId($role_id);

			$session->setActualCurrentlySelectedProjectUserCompanyId($currentlySelectedProjectUserCompanyId);
			$session->setCurrentlySelectedProjectUserCompanyId($currentlySelectedProjectUserCompanyId);

			$session->setActualCurrentlySelectedProjectId($currentlySelectedProjectId);
			$session->setCurrentlySelectedProjectId($currentlySelectedProjectId);

			$session->setActualCurrentlySelectedProjectName($currentlySelectedProjectName);
			$session->setCurrentlySelectedProjectName($currentlySelectedProjectName);

			$session->setActualCurrentlyActiveContactId($currentlyActiveContactId);
			$session->setCurrentlyActiveContactId($currentlyActiveContactId);

			// Do I need this here at all???
			// Maybe put this in Application
			// Authorize user
			require_once('lib/common/Authorization.php');
			$auth = Authorization::authorizeUser($database, $user_id, $user_company_id);
			/* @var $auth Authorization */
			//$acl->sessionPut();
			$userRole = $auth->getUserRole();

			$session->setActualUserRole($userRole);
			$session->setUserRole($userRole);

			$message->resetAll();
			$message->sessionPut();
			if (isset($post)) {
				$post->sessionClear();
			} elseif (isset($get)) {
				$get->sessionClear();
			}
			$session->setFormSubmitted(false);

			if (isset($u) && $u->change_password_flag == 'Y') {
				$session->setForgotPassword(true);
				$message = Message::getInstance();
				/* @var $message Message */
				$message->reset('account-management-password-form.php');
				$message->enqueueInfo('Please update your account password to continue.', 'account-management-password-form.php');
				$message->sessionPut();
				$url = 'account-management-password-form.php'.$uri->queryString;
				header('Location: '.$url);
				exit;
			}

			// Check if redirect should occur
			$previouslyRequestedUri = $session->getRequestedUri();
			if (isset($previouslyRequestedUri) && !empty($previouslyRequestedUri)) {
				$url = $previouslyRequestedUri;
				$uri = Zend_Registry::get('uri');
				$uri->currentPhpScript = $previouslyRequestedUri;
				// exit;
				$session->setRequestedUri(null);
			} else {
				if (isset($uri->queryString) && !empty($uri->queryString)) {
					$queryString = $uri->queryString;
					if (is_int(strpos($queryString, 'p='))) {
						$queryString = '';
					}
				} else {
					$queryString = '';
				}
				$database = Zend_Registry::get('database');			
				$uri = Zend_Registry::get('uri');
				$currentPhpScript = '/' . $uri->currentPhpScript;
				$session = Zend_Registry::get('session');
				$actualUserRole = $session->getActualUserRole();
				require_once('lib/common/Dashboard.php');
				
				if($u['role_id']=='1')
				{
					$db = DBI::getInstance($database);
					$query = "SELECT * FROM `software_module_functions` WHERE software_module_function = 'manage_dashboard' AND `show_in_navigation_flag` = 'Y' ";
					$db->execute($query);
					$row = $db->fetch();
					if($row)
					{
						$url = 'dashboard.php?pID='.base64_encode($currentlySelectedProjectId).$queryString;

					}else
					{

						$url = 'account.php?pID='.base64_encode($currentlySelectedProjectId).$queryString;

					}
					
					
				}
				else
				{
				$arrSoftwareModuleCategorySortOrder = loadPermissionsById($database, '',$actualUserRole);
	 			// print_r($arrSoftwareModuleCategorySortOrder);
	 			$dashboard = 0;
				foreach ($arrSoftwareModuleCategorySortOrder as $software_module_category_ids => $software_module_category_sort_order) {
		
				foreach ($software_module_category_sort_order as $software_module_category_id => $software_module_category_sort_orders) {
			 	 $software_module_category_label = $software_module_category_sort_order[$software_module_category_id]['name'];
			 	if($software_module_category_label == 'Dashboard')
			 	$dashboard = 1;
					}
				}
				// exit;
				if($dashboard == 0){
					$url = 'account.php?pID='.base64_encode($currentlySelectedProjectId).$queryString;
				}
				else{
					$url = 'dashboard.php?pID='.base64_encode($currentlySelectedProjectId).$queryString;
				}

			}
			}
			$uri->currentPhpScript = $url;
			header('Location: '.$url, true);
			exit;
		}
	} else {
		// Invalid login
		$uri = Zend_Registry::get('uri');
		// Error message
		$message->reset();
		$message->enqueueError('Invalid security information', $activeScope);
		$message->sessionPut();
		if (isset($post)) {
			$post->sessionPut($activeScope);
		} elseif (isset($get)) {
			$get->sessionPut($activeScope);
		}
		$uri->currentPhpScript = $url;
		header('Location: '.$url);
		exit;
	}
}

// default is to redirect to portal entrance
$url = 'login-form.php'.$uri->queryString;
header('Location: '.$url);
exit;
