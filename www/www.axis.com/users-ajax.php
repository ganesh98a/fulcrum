<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
//$init['post_maxlength'] = 100000;
//$init['post_required'] = true;
//$init['sapi'] = 'cli';
//$init['skip_always_include'] = true;
//$init['skip_session'] = true;
//$init['skip_templating'] = true;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

// Method Call is our switch variable
if (isset($get)) {
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}

require_once('lib/common/PageComponents.php');

require_once('lib/common/User.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('users-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewUsers = $permissions->determineAccessToSoftwareModuleFunction('users_view');
$userCanManageUsers = $permissions->determineAccessToSoftwareModuleFunction('users_manage');
*/

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {
	case 'createUser':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'users_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new User data values.';
				$arrErrorMessages = array(
					'Error creating: User.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'User';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Users';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-user-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$user_id = (int) $get->user_id;
			$user_company_id = (int) $get->user_company_id;
			$role_id = (int) $get->role_id;
			$default_project_id = (int) $get->default_project_id;
			$primary_contact_id = (int) $get->primary_contact_id;
			$mobile_network_carrier_id = (int) $get->mobile_network_carrier_id;
			$user_image_id = (int) $get->user_image_id;
			$security_image_id = (int) $get->security_image_id;
			$html_template_theme_id = (int) $get->html_template_theme_id;
			$mobile_phone_number = (string) $get->mobile_phone_number;
			$screen_name = (string) $get->screen_name;
			$email = (string) $get->email;
			$password_hash = (string) $get->password_hash;
			$password_guid = (string) $get->password_guid;
			$security_phrase = (string) $get->security_phrase;
			$modified = (string) $get->modified;
			$accessed = (string) $get->accessed;
			$created = (string) $get->created;
			$alerts = (string) $get->alerts;
			$tc_accepted_flag = (string) $get->tc_accepted_flag;
			$email_subscribe_flag = (string) $get->email_subscribe_flag;
			$remember_me_flag = (string) $get->remember_me_flag;
			$change_password_flag = (string) $get->change_password_flag;
			$disabled_flag = (string) $get->disabled_flag;
			$deleted_flag = (string) $get->deleted_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the User record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$user = new User($database);

			$user->setData($httpGetInputData);
			$user->convertDataToProperties();

			/*
			$user->user_id = $user_id;
			$user->user_company_id = $user_company_id;
			$user->role_id = $role_id;
			$user->default_project_id = $default_project_id;
			$user->primary_contact_id = $primary_contact_id;
			$user->mobile_network_carrier_id = $mobile_network_carrier_id;
			$user->user_image_id = $user_image_id;
			$user->security_image_id = $security_image_id;
			$user->html_template_theme_id = $html_template_theme_id;
			$user->mobile_phone_number = $mobile_phone_number;
			$user->screen_name = $screen_name;
			$user->email = $email;
			$user->password_hash = $password_hash;
			$user->password_guid = $password_guid;
			$user->security_phrase = $security_phrase;
			$user->modified = $modified;
			$user->accessed = $accessed;
			$user->created = $created;
			$user->alerts = $alerts;
			$user->tc_accepted_flag = $tc_accepted_flag;
			$user->email_subscribe_flag = $email_subscribe_flag;
			$user->remember_me_flag = $remember_me_flag;
			$user->change_password_flag = $change_password_flag;
			$user->disabled_flag = $disabled_flag;
			$user->deleted_flag = $deleted_flag;
			*/

			$user->convertPropertiesToData();
			$data = $user->getData();

			// Test for existence via standard findByUniqueIndex method
			$user->findByUniqueIndex();
			if ($user->isDataLoaded()) {
				// Error code here
				$errorMessage = 'User already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $user->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$user->setKey(null);
				$data['created'] = null;
				$user->setData($data);
			}

			$user_id = $user->save();
			if (isset($user_id) && !empty($user_id)) {
				$user->user_id = $user_id;
				$user->setId($user_id);
			}
			// $user->save();

			$user->convertDataToProperties();
			$primaryKeyAsString = $user->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: User.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: User';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($user) && $user instanceof User) {
				$primaryKeyAsString = $user->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadUser':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'users_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: User.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'User';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Users';
			}

			// Primary key attibutes
			//$user_id = (int) $get->uniqueId;
			// Debug
			//$user_id = (int) 1;

			// Unique index attibutes
			$password_guid = (string) $get->password_guid;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: User';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($user) && $user instanceof User) {
				$primaryKeyAsString = $user->getPrimaryKeyAsString();
			}
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlContent";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadAllUserRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'users_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: User.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'User';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Users';
			}

			// Primary key attibutes
			//$user_id = (int) $get->uniqueId;
			// Debug
			//$user_id = (int) 1;

			// Unique index attibutes
			$password_guid = (string) $get->password_guid;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|users|User|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: User';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$containerElementId|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlContent";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'updateUser':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: User';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'users_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating User - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'User';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Users';
			}

			// Primary key attibutes
			//$user_id = (int) $get->uniqueId;
			// Debug
			//$user_id = (int) 1;

			// Unique index attibutes
			$password_guid = (string) $get->password_guid;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'user_id' => 'user id',
				'user_company_id' => 'user company id',
				'role_id' => 'role id',
				'default_project_id' => 'default project id',
				'primary_contact_id' => 'primary contact id',
				'mobile_network_carrier_id' => 'mobile network carrier id',
				'user_image_id' => 'user image id',
				'security_image_id' => 'security image id',
				'html_template_theme_id' => 'html template theme id',
				'mobile_phone_number' => 'mobile phone number',
				'screen_name' => 'screen name',
				'email' => 'email',
				'password_hash' => 'password hash',
				'password_guid' => 'password guid',
				'security_phrase' => 'security phrase',
				'modified' => 'modified',
				'accessed' => 'accessed',
				'created' => 'created',
				'alerts' => 'alerts',
				'tc_accepted_flag' => 'tc accepted flag',
				'email_subscribe_flag' => 'email subscribe flag',
				'remember_me_flag' => 'remember me flag',
				'change_password_flag' => 'change password flag',
				'disabled_flag' => 'disabled flag',
				'deleted_flag' => 'deleted flag',
			);

			if (isset($arrAllowableAttributes[$attributeName])) {
				// Allow formatted attribute name to be passed in
				if (!isset($formattedAttributeName) || empty($formattedAttributeName)) {
					$formattedAttributeName = $arrAllowableAttributes[$attributeName];
					$arrTmp = explode(' ', $formattedAttributeName);
					$arrFormattedAttributeName = array_map('ucfirst', $arrTmp);
					$formattedAttributeName = join(' ', $arrFormattedAttributeName);
				}
			} else {
				$errorMessage = 'Invalid attribute.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			if ($attributeSubgroupName == 'users') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$user_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$user = User::findById($database, $user_id);
				/* @var $user User */

				if ($user) {
					// Check if the value actually changed
					$existingValue = $user->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $user->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'password_guid' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $user->$attributeName;
						$user->$attributeName = $newValue;
						$possibleDuplicateUser = User::findByPasswordGuid($database, $user->password_guid);
						if ($possibleDuplicateUser) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "User $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$user->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$user->setData($data);
						// $user_id = $user->save();
						$user->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'User record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $user->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: User';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($user) && $user instanceof User) {
				$primaryKeyAsString = $user->getPrimaryKeyAsString();
			}
		}

		// Dummy placeholder for now
		$previousId = '';

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$attributeName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$formattedAttributeName|$resetToPreviousValue|$performRefreshOperation|$previousId";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'updateAllUserAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: User';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'users_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating User.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'User';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Users';
			}

			// Primary key attibutes
			//$user_id = (int) $get->uniqueId;
			// Debug
			//$user_id = (int) 1;

			// Unique index attibutes
			$password_guid = (string) $get->password_guid;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$user_id = (int) $get->user_id;
			$user_company_id = (int) $get->user_company_id;
			$role_id = (int) $get->role_id;
			$default_project_id = (int) $get->default_project_id;
			$primary_contact_id = (int) $get->primary_contact_id;
			$mobile_network_carrier_id = (int) $get->mobile_network_carrier_id;
			$user_image_id = (int) $get->user_image_id;
			$security_image_id = (int) $get->security_image_id;
			$html_template_theme_id = (int) $get->html_template_theme_id;
			$mobile_phone_number = (string) $get->mobile_phone_number;
			$screen_name = (string) $get->screen_name;
			$email = (string) $get->email;
			$password_hash = (string) $get->password_hash;
			$password_guid = (string) $get->password_guid;
			$security_phrase = (string) $get->security_phrase;
			$modified = (string) $get->modified;
			$accessed = (string) $get->accessed;
			$created = (string) $get->created;
			$alerts = (string) $get->alerts;
			$tc_accepted_flag = (string) $get->tc_accepted_flag;
			$email_subscribe_flag = (string) $get->email_subscribe_flag;
			$remember_me_flag = (string) $get->remember_me_flag;
			$change_password_flag = (string) $get->change_password_flag;
			$disabled_flag = (string) $get->disabled_flag;
			$deleted_flag = (string) $get->deleted_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'users') {
				$user_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$user = User::findById($database, $user_id);
				/* @var $user User */

				if ($user) {
					$existingData = $user->getData();

					// Retrieve all of the $_GET inputs automatically for the User record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$user->setData($httpGetInputData);
					$user->convertDataToProperties();
					$user->convertPropertiesToData();

					$newData = $user->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$user->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: User<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $user->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$user->user_id = $user_id;
			$user->user_company_id = $user_company_id;
			$user->role_id = $role_id;
			$user->default_project_id = $default_project_id;
			$user->primary_contact_id = $primary_contact_id;
			$user->mobile_network_carrier_id = $mobile_network_carrier_id;
			$user->user_image_id = $user_image_id;
			$user->security_image_id = $security_image_id;
			$user->html_template_theme_id = $html_template_theme_id;
			$user->mobile_phone_number = $mobile_phone_number;
			$user->screen_name = $screen_name;
			$user->email = $email;
			$user->password_hash = $password_hash;
			$user->password_guid = $password_guid;
			$user->security_phrase = $security_phrase;
			$user->modified = $modified;
			$user->accessed = $accessed;
			$user->created = $created;
			$user->alerts = $alerts;
			$user->tc_accepted_flag = $tc_accepted_flag;
			$user->email_subscribe_flag = $email_subscribe_flag;
			$user->remember_me_flag = $remember_me_flag;
			$user->change_password_flag = $change_password_flag;
			$user->disabled_flag = $disabled_flag;
			$user->deleted_flag = $deleted_flag;
					*/

					// $user_id = $user->save();
					$user->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'User record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: User';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($user) && $user instanceof User) {
				$primaryKeyAsString = $user->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$resetToPreviousValue";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'deleteUser':

		$crudOperation = 'delete';
		$errorNumber = 0;
		$errorMessage = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'users_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting User.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'User';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Users';
			}

			// Primary key attibutes
			//$user_id = (int) $get->uniqueId;
			// Debug
			//$user_id = (int) 1;

			// Unique index attibutes
			$password_guid = (string) $get->password_guid;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'users') {
				$user_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$user = User::findById($database, $user_id);
				/* @var $user User */

				if ($user) {
					$user->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'User record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error deleting: User';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($user) && $user instanceof User) {
				$primaryKeyAsString = $user->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$recordContainerElementId|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$performDomDeleteOperation";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'saveUser':

		$crudOperation = 'save';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'users_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new User data values.';
				$arrErrorMessages = array(
					'Error saving User.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'User';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Users';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-user-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$user_id = (int) $get->user_id;
			$user_company_id = (int) $get->user_company_id;
			$role_id = (int) $get->role_id;
			$default_project_id = (int) $get->default_project_id;
			$primary_contact_id = (int) $get->primary_contact_id;
			$mobile_network_carrier_id = (int) $get->mobile_network_carrier_id;
			$user_image_id = (int) $get->user_image_id;
			$security_image_id = (int) $get->security_image_id;
			$html_template_theme_id = (int) $get->html_template_theme_id;
			$mobile_phone_number = (string) $get->mobile_phone_number;
			$screen_name = (string) $get->screen_name;
			$email = (string) $get->email;
			$password_hash = (string) $get->password_hash;
			$password_guid = (string) $get->password_guid;
			$security_phrase = (string) $get->security_phrase;
			$modified = (string) $get->modified;
			$accessed = (string) $get->accessed;
			$created = (string) $get->created;
			$alerts = (string) $get->alerts;
			$tc_accepted_flag = (string) $get->tc_accepted_flag;
			$email_subscribe_flag = (string) $get->email_subscribe_flag;
			$remember_me_flag = (string) $get->remember_me_flag;
			$change_password_flag = (string) $get->change_password_flag;
			$disabled_flag = (string) $get->disabled_flag;
			$deleted_flag = (string) $get->deleted_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$user = new User($database);

			// Retrieve all of the $_GET inputs automatically for the User record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$user->setData($httpGetInputData);
			$user->convertDataToProperties();

			/*
			$user->user_id = $user_id;
			$user->user_company_id = $user_company_id;
			$user->role_id = $role_id;
			$user->default_project_id = $default_project_id;
			$user->primary_contact_id = $primary_contact_id;
			$user->mobile_network_carrier_id = $mobile_network_carrier_id;
			$user->user_image_id = $user_image_id;
			$user->security_image_id = $security_image_id;
			$user->html_template_theme_id = $html_template_theme_id;
			$user->mobile_phone_number = $mobile_phone_number;
			$user->screen_name = $screen_name;
			$user->email = $email;
			$user->password_hash = $password_hash;
			$user->password_guid = $password_guid;
			$user->security_phrase = $security_phrase;
			$user->modified = $modified;
			$user->accessed = $accessed;
			$user->created = $created;
			$user->alerts = $alerts;
			$user->tc_accepted_flag = $tc_accepted_flag;
			$user->email_subscribe_flag = $email_subscribe_flag;
			$user->remember_me_flag = $remember_me_flag;
			$user->change_password_flag = $change_password_flag;
			$user->disabled_flag = $disabled_flag;
			$user->deleted_flag = $deleted_flag;
			*/

			$user->convertPropertiesToData();
			$data = $user->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$user_id = $user->insertOnDuplicateKeyUpdate();
			if (isset($user_id) && !empty($user_id)) {
				$user->user_id = $user_id;
				$user->setId($user_id);
			}
			// $user->insertOnDuplicateKeyUpdate();
			// $user->insertIgnore();

			$user->convertDataToProperties();
			$primaryKeyAsString = $user->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: User.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: User';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($user) && $user instanceof User) {
				$primaryKeyAsString = $user->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;
}

$htmlOutput = ob_get_clean();
echo $htmlOutput;

while (@ob_end_flush());

exit; // End of PHP Ajax Handler Code

} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}
