<?php
ob_end_clean();
ob_start();  
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
require_once('lib/common/TransmittalAdminTemplate.php');
require_once('app/models/permission_mdl.php');
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

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('modules-transmittal-admin-functions.php');
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
	case 'loadTransmittalAdminTemplates':

	$crudOperation = 'load';
	$errorNumber = 0;
	$errorMessage = '';
	$save = true;
	try {
		// Ajax Handler Inputs
		require('code-generator/ajax-get-inputs.php');
		$permissions = Zend_Registry::get('permissions');
		$userCanManageTAM = checkPermissionForAllModuleAndRole($database,'transmittal_template_manage');
			// Check permissions - read
		if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
			$formattedAttributeGroupName = 'Transmittal Admin Template';
		}
		if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
			$formattedAttributeSubgroupName = 'Transmittal Admin Template';
		}
		$tam_sequence_id = Data::parseInt($get->tam_sequence_id);
		$transmittal_admin_template_id = Data::parseInt($get->transmittal_admin_template_id);
		$primaryKeyAsString = (string) $transmittal_admin_template_id;
		$htmlContent = loadTransmittalAdminTemplatesDialog($database, $transmittal_admin_template_id,$tam_sequence_id);
		$arrCustomizedJsonOutput = array(
			'transmittal_admin_template_id' => $transmittal_admin_template_id,
			'htmlContent' => $htmlContent
			);

		if ($includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

	} catch (Exception $e) {
		$db->rollback();
		$db->free_result();

		$errorNumber = 1;

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
		if (isset($requestForInformation) && $requestForInformation instanceof RequestForInformation) {
			$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
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
	case 'updateTransmittalAdmin':

	$crudOperation = 'update';
	$errorNumber = 0;
	$errorMessage = '';
	$save = true;
	$primaryKeyAsString = '';
	$htmlRecord = '';
	$tamTable = '';

	try {

			// Ajax Handler Inputs
		require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
		$enforcePermissions = false;

		if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
			$sortOrderFlag = 'N';
		}
		if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
			$formattedAttributeGroupName = 'Transmittal Admin';
		}
		if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
			$formattedAttributeSubgroupName = 'Transmittal Admin Template';
		}
		if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
			$newAttributeGroupName = 'update-transmittal_admin-record';
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->throwExceptionOnDbError = true;

		$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the RequestForInformation record
		$httpGetInputData = $get->getData();
		$httpGetInputData = $_POST;
		foreach ($httpGetInputData as $k => $v) {
			if (empty($v)) {
				unset($httpGetInputData[$k]);
			}
		}
		$transmittalAdminTemplate = new TransmittalAdminTemplate($database);
		$transmittalAdminTemplate->setData($httpGetInputData);
		$transmittalAdminTemplate->convertDataToProperties();
		$transmittalAdminTemplate->convertPropertiesToData();
		$data = $transmittalAdminTemplate->getData();

			// Test for existence via standard findByUniqueIndex method
		$transmittalAdminTemplate->findByUniqueIndex();
		if ($transmittalAdminTemplate->isDataLoaded()) {
				// Error code here
			$errorMessage = 'Transmittal Admin Temaplate already exists.';
			$message->enqueueError($errorMessage, $currentPhpScript);
			$primaryKeyAsString = $transmittalAdminTemplate->getPrimaryKeyAsString();
			throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
		} else {
			$transmittalAdminTemplate->setKey(null);
			$data['created'] = null;
			$transmittalAdminTemplate->setData($data);
		}

		$transmittal_admin_template_id = $transmittalAdminTemplate->updateOnDuplicateKeyUpdate($httpGetInputData);
		if (isset($transmittal_admin_template_id) && !empty($request_for_information_id)) {
			$transmittalAdminTemplate->transmittal_admin_template_id = $transmittal_admin_template_id;
			$transmittalAdminTemplate->setId($transmittal_admin_template_id);
		}
			// $requestForInformation->save();

		$transmittalAdminTemplate->convertDataToProperties();
			// $primaryKeyAsString = $transmittalAdminTemplate->getPrimaryKeyAsString();
		$primaryKeyAsString = $transmittal_admin_template_id;
			// Output standard formatted error or success message
		if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
			$errorNumber = 0;
			$errorMessage = '';
			$message->reset($currentPhpScript);

		} else {
				// Error code here
			$errorNumber = 1;
			$errorMessage = 'Error updating: Transmittal Admin Template.';
			$message->enqueueError($errorMessage, $currentPhpScript);
			throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
		}
	} catch (Exception $e) {
		$db->rollback();
		$db->free_result();

		$errorNumber = 1;
	}

	$db->throwExceptionOnDbError = false;
		$performRefreshOperation = 'Y';
		$refreshOperationType = 'full_screen_refresh';
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
		if (isset($transmittalAdminTemplate) && $transmittalAdminTemplate instanceof TransmittalAdmin) {
			$primaryKeyAsString = $transmittalAdminTemplate->getPrimaryKeyAsString();
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
		$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName||$performRefreshOperation";
	}

	if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
	}		echo $output;

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
?>
