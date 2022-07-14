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
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');
require_once('lib/common/DrawSignatureType.php');
require_once('lib/common/DrawSignatureBlocks.php');
require_once('lib/common/DrawSignatureBlocksConstructionLender.php');
require_once('lib/common/DrawBreakDowns.php');
require_once('lib/common/Project.php');
require_once('lib/common/RetentionSignatureBlocks.php');
require_once('lib/common/RetentionSignatureBlocksConstructionLender.php');

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

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('modules-draw-signature-block-functions.php');
	}
}

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$primary_contact_id = $session->getPrimaryContactId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {
	case 'CreateOrUpdate':
	$crudOperation = 'CreateOrUpdate';
	$errorNumber = 0;
	$errorMessage = 'Please fill in the Highlighted area';
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
			$arrErrorMessages = array(
				'Error creating: Signature Block.<br>Permission Denied.' => 1
			);
			require('code-generator/ajax-permissions.php');
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->throwExceptionOnDbError = true;

		$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the DiscussionItem record
		$httpGetInputData = $get->getData();
		foreach ($httpGetInputData as $k => $v) {
			if (empty($v)) {
				unset($httpGetInputData[$k]);
			}
		}
		$signatureBlockId = $httpGetInputData['signature_block_id'];
		$description = $httpGetInputData['description'];
		if ($signatureBlockId && $signatureBlockId != 'null') {
			$drawSignatureBlock = DrawSignatureBlocks::findById($database, $signatureBlockId);
		} else {
			$drawSignatureBlock = new DrawSignatureBlocks($database);	
		}
		// echo $drawSignatureBlock;
		$drawSignatureBlock->setData($httpGetInputData);
		$drawSignatureBlock->convertDataToProperties();
		$drawSignatureBlock->convertPropertiesToData();
		$data = $drawSignatureBlock->getData();
		/*crack the sort_order*/
			// Test for existence via standard findByUniqueIndex method

		$drawSignatureBlock->findByUniqueIndex();
		$data['description'] = $description;
		if ($description == '' || $description == undefined ) {
			$data['description'] = NULL;
		}
		
		if ($drawSignatureBlock->isDataLoaded()) {
				// Error code here
			$errorMessage = 'Draw Signature Block already exists.';
			$data['updated_by_contact_id'] = $currentlyActiveContactId;
			$data['updated_date'] = date('Y-m-d h:i:s');
			// $message->enqueueError($errorMessage, $currentPhpScript);
			// $primaryKeyAsString = $drawSignatureBlock->getPrimaryKeyAsString();
			// throw new Exception($errorMessage);
			$drawSignatureBlock->setData($data);
		} else {
			$drawSignatureBlock->setKey(null);
			$data['created_by_contact_id'] = $currentlyActiveContactId;
			$drawSignatureBlock->setData($data);
		}
		$draw_signature_id = $drawSignatureBlock->save();
		// echo $description;
		if (($description == '' || $description == 'null') && $httpGetInputData['signature_type_id'] != 4) {
			$errorNumber = 1;
			$errorMessage = 'Draw signature block name should not be empty';
			$message->enqueueError($errorMessage, $currentPhpScript);
			$primaryKeyAsString = $drawSignatureBlock->getPrimaryKeyAsString();
			// throw new Exception($errorMessage);
		}
		if (isset($draw_signature_id) && !empty($draw_signature_id)) {	
			$drawSignatureBlock->draw_signature_id = $draw_signature_id;
			$drawSignatureBlock->setId($draw_signature_id);
			/*crack the sort_order*/
		} else {
			$draw_signature_id = $signatureBlockId;
		}

		$drawSignatureBlock->convertDataToProperties();
		$primaryKeyAsString = $drawSignatureBlock->getPrimaryKeyAsString();
		//  json return value
		$primaryKeyAsString = $draw_signature_id;
		$dummyId = $httpGetInputData['signature_type_id'];
			// Output standard formatted error or success message
		if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
			$errorNumber = 0;
			$errorMessage = '';
			$message->reset($currentPhpScript);
		} else {
			// Error code here
			$errorNumber = 1;
			$errorMessage = 'Error creating: Draw Signature.';
			$message->enqueueError($errorMessage, $currentPhpScript);
			throw new Exception($errorMessage);
		}
	} catch (Exception $e) {
		$db->rollback();
		$db->free_result();
		$errorNumber = 1;
	}

	$db->throwExceptionOnDbError = false;

	$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
	if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
		$errorNumber = 1;
		$errorMessage = join('<br>', $arrErrorMessages);
	}

	if (!isset($primaryKeyAsString)) {
		$primaryKeyAsString = '';
		if (isset($drawSignatureBlock) && $drawSignatureBlock instanceof DrawSignatureBlocks) {
			$drawSignatureBlock = $drawSignatureBlock->getPrimaryKeyAsString();
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
	case 'RetentionCreateOrUpdate':
	$crudOperation = 'RetentionCreateOrUpdate';
	$errorNumber = 0;
	$errorMessage = 'Please fill in the Highlighted area';
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
			$arrErrorMessages = array(
				'Error creating: Signature Block.<br>Permission Denied.' => 1
			);
			require('code-generator/ajax-permissions.php');
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->throwExceptionOnDbError = true;

		$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the DiscussionItem record
		$httpGetInputData = $get->getData();
		foreach ($httpGetInputData as $k => $v) {
			if (empty($v)) {
				unset($httpGetInputData[$k]);
			}
		}
		$signatureBlockId = $httpGetInputData['signature_block_id'];
		$description = $httpGetInputData['description'];
		if ($signatureBlockId && $signatureBlockId != 'null') {
			$drawSignatureBlock = RetentionSignatureBlocks::findById($database, $signatureBlockId);
		} else {
			$drawSignatureBlock = new RetentionSignatureBlocks($database);	
		}
		
		$drawSignatureBlock->setData($httpGetInputData);
		$drawSignatureBlock->convertDataToProperties();
		$drawSignatureBlock->convertPropertiesToData();
		$data = $drawSignatureBlock->getData();
		/*crack the sort_order*/
			// Test for existence via standard findByUniqueIndex method

		$drawSignatureBlock->findByUniqueIndex();
		$data['description'] = $description;
		if ($description == '' || $description == undefined ) {
			$data['description'] = NULL;
		}
		
		if ($drawSignatureBlock->isDataLoaded()) {
				// Error code here
			$errorMessage = 'Retention Signature Block already exists.';
			$data['updated_by_contact_id'] = $currentlyActiveContactId;
			$data['updated_date'] = date('Y-m-d h:i:s');
			$drawSignatureBlock->setData($data);
		} else {
			$drawSignatureBlock->setKey(null);
			$data['created_by_contact_id'] = $currentlyActiveContactId;
			$drawSignatureBlock->setData($data);
		}
	
		$draw_signature_id = $drawSignatureBlock->save();
		// echo $description;
		if (($description == '' || $description == 'null') && $httpGetInputData['signature_type_id'] != 4) {
			$errorNumber = 1;
			$errorMessage = 'Retention signature block name should not be empty';
			$message->enqueueError($errorMessage, $currentPhpScript);
			$primaryKeyAsString = $drawSignatureBlock->getPrimaryKeyAsString();
			// throw new Exception($errorMessage);
		}
		if (isset($draw_signature_id) && !empty($draw_signature_id)) {	
			$drawSignatureBlock->draw_signature_id = $draw_signature_id;
			$drawSignatureBlock->setId($draw_signature_id);
			/*crack the sort_order*/
		} else {
			$draw_signature_id = $signatureBlockId;
		}

		$drawSignatureBlock->convertDataToProperties();
		$primaryKeyAsString = $drawSignatureBlock->getPrimaryKeyAsString();
		//  json return value
		$primaryKeyAsString = $draw_signature_id;
		$dummyId = $httpGetInputData['signature_type_id'];
			// Output standard formatted error or success message
		if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
			$errorNumber = 0;
			$errorMessage = '';
			$message->reset($currentPhpScript);
		} else {
			// Error code here
			$errorNumber = 1;
			$errorMessage = 'Error creating: Retention Signature.';
			$message->enqueueError($errorMessage, $currentPhpScript);
			throw new Exception($errorMessage);
		}
	} catch (Exception $e) {
		$db->rollback();
		$db->free_result();
		$errorNumber = 1;
	}

	$db->throwExceptionOnDbError = false;

	$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
	if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
		$errorNumber = 1;
		$errorMessage = join('<br>', $arrErrorMessages);
	}

	if (!isset($primaryKeyAsString)) {
		$primaryKeyAsString = '';
		if (isset($drawSignatureBlock) && $drawSignatureBlock instanceof DrawSignatureBlocks) {
			$drawSignatureBlock = $drawSignatureBlock->getPrimaryKeyAsString();
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
	// Signature Block Cl
	case 'CreateOrUpdateCL':
	$crudOperation = 'CreateOrUpdateCL';
	$errorNumber = 0;
	$errorMessage = 'Please fill in the Highlighted area';
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
			$arrErrorMessages = array(
				'Error creating: Signature Block cConstruction lender.<br>Permission Denied.' => 1
			);
			require('code-generator/ajax-permissions.php');
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->throwExceptionOnDbError = true;

		$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the DiscussionItem record
		$httpGetInputData = $get->getData();
		foreach ($httpGetInputData as $k => $v) {
			if (empty($v)) {
				unset($httpGetInputData[$k]);
			}
		}
		$signatureBlockCLId = $httpGetInputData['signature_cl_id'];
		$address1 = $httpGetInputData['address_1'];
		$address2 = $httpGetInputData['address_2'];
		$city_state_zip = $httpGetInputData['city_state_zip'];
		
		if ($signatureBlockCLId && $signatureBlockCLId != 'null') {
			$drawSignatureBlockCL = DrawSignatureBlocksConstructionLender::findById($database, $signatureBlockCLId);
		} else {
			$drawSignatureBlockCL = new DrawSignatureBlocksConstructionLender($database);	
		}
		// echo $drawSignatureBlock;
		$drawSignatureBlockCL->setData($httpGetInputData);
		$drawSignatureBlockCL->convertDataToProperties();
		$drawSignatureBlockCL->convertPropertiesToData();
		$data = $drawSignatureBlockCL->getData();
		/*crack the sort_order*/
			// Test for existence via standard findByUniqueIndex method

		$drawSignatureBlockCL->findByUniqueIndex();
		
		if ($address1 == '' || $address1 == undefined ) {
			$data['address_1'] = NULL;
		}

		
		if ($address2 == '' || $address2 == undefined ) {
			$data['address_2'] = NULL;
		}

		
		if ($city_state_zip == '' || $city_state_zip == undefined ) {
			$data['city_state_zip'] = NULL;
		}
		
		if ($drawSignatureBlockCL->isDataLoaded()) {
				// Error code here
			$errorMessage = 'Draw Signature Block Construction already exists.';
			$drawSignatureBlockCL->setData($data);
		} else {
			$drawSignatureBlockCL->setKey(null);
			$drawSignatureBlockCL->setData($data);
		}
		$draw_signature_id = $drawSignatureBlockCL->save();
		
		if (($address1 == '' || $address1 == 'null') || ($address2 == '' || $address2 == 'null') || ($city_state_zip == '' || $city_state_zip == 'null'))  {
			$errorNumber = 1;
			$errorMessage = 'Please fill in the Highlighted area';
			$message->enqueueError($errorMessage, $currentPhpScript);
			$primaryKeyAsString = $drawSignatureBlockCL->getPrimaryKeyAsString();
			// throw new Exception($errorMessage);
		}
		if (isset($draw_signature_id) && !empty($draw_signature_id)) {	
			$drawSignatureBlockCL->draw_signature_id = $draw_signature_id;
			$drawSignatureBlockCL->setId($draw_signature_id);
			/*crack the sort_order*/
		} else {
			$draw_signature_id = $signatureBlockCLId;
		}

		$drawSignatureBlockCL->convertDataToProperties();
		$primaryKeyAsString = $drawSignatureBlockCL->getPrimaryKeyAsString();
		//  json return value
		$primaryKeyAsString = $draw_signature_id;
		$dummyId = $httpGetInputData['signature_type_id'];
			// Output standard formatted error or success message
		if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
			$errorNumber = 0;
			$errorMessage = '';
			$message->reset($currentPhpScript);
		} else {
			// Error code here
			$errorNumber = 1;
			$errorMessage = 'Error creating: Draw Signature.';
			$message->enqueueError($errorMessage, $currentPhpScript);
			throw new Exception($errorMessage);
		}
	} catch (Exception $e) {
		$db->rollback();
		$db->free_result();
		$errorNumber = 1;
	}

	$db->throwExceptionOnDbError = false;

	$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
	if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
		$errorNumber = 1;
		$errorMessage = join('<br>', $arrErrorMessages);
	}

	if (!isset($primaryKeyAsString)) {
		$primaryKeyAsString = '';
		if (isset($drawSignatureBlockCL) && $drawSignatureBlockCL instanceof DrawSignatureBlocksConstructionLender) {
			$drawSignatureBlockCL = $drawSignatureBlockCL->getPrimaryKeyAsString();
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
	// Retention Signature Block Cl
	case 'CreateOrUpdateRetentionCL':
	$crudOperation = 'CreateOrUpdateRetentionCL';
	$errorNumber = 0;
	$errorMessage = 'Please fill in the Highlighted area';
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
			$arrErrorMessages = array(
				'Error creating: Retention Signature Block Construction lender.<br>Permission Denied.' => 1
			);
			require('code-generator/ajax-permissions.php');
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->throwExceptionOnDbError = true;

		$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the DiscussionItem record
		$httpGetInputData = $get->getData();
		foreach ($httpGetInputData as $k => $v) {
			if (empty($v)) {
				unset($httpGetInputData[$k]);
			}
		}
		$signatureBlockCLId = $httpGetInputData['signature_cl_id'];
		$address1 = $httpGetInputData['address_1'];
		$address2 = $httpGetInputData['address_2'];
		$city_state_zip = $httpGetInputData['city_state_zip'];
		
		if ($signatureBlockCLId && $signatureBlockCLId != 'null') {
			$drawSignatureBlockCL = RetentionSignatureBlocksConstructionLender::findById($database, $signatureBlockCLId);
		} else {
			$drawSignatureBlockCL = new RetentionSignatureBlocksConstructionLender($database);	
		}
		// echo $drawSignatureBlock;
		$drawSignatureBlockCL->setData($httpGetInputData);
		$drawSignatureBlockCL->convertDataToProperties();
		$drawSignatureBlockCL->convertPropertiesToData();
		$data = $drawSignatureBlockCL->getData();
		/*crack the sort_order*/
			// Test for existence via standard findByUniqueIndex method

		$drawSignatureBlockCL->findByUniqueIndex();
		
		if ($address1 == '' || $address1 == undefined ) {
			$data['address_1'] = NULL;
		}

		
		if ($address2 == '' || $address2 == undefined ) {
			$data['address_2'] = NULL;
		}

		
		if ($city_state_zip == '' || $city_state_zip == undefined ) {
			$data['city_state_zip'] = NULL;
		}
		
		if ($drawSignatureBlockCL->isDataLoaded()) {
				// Error code here
			$errorMessage = 'Retention Signature Block Construction already exists.';
			$drawSignatureBlockCL->setData($data);
		} else {
			$drawSignatureBlockCL->setKey(null);
			$drawSignatureBlockCL->setData($data);
		}
		$draw_signature_id = $drawSignatureBlockCL->save();
		
		if (($address1 == '' || $address1 == 'null') || ($address2 == '' || $address2 == 'null') || ($city_state_zip == '' || $city_state_zip == 'null'))  {
			$errorNumber = 1;
			$errorMessage = 'Please fill in the Highlighted area';
			$message->enqueueError($errorMessage, $currentPhpScript);
			$primaryKeyAsString = $drawSignatureBlockCL->getPrimaryKeyAsString();
			// throw new Exception($errorMessage);
		}
		if (isset($draw_signature_id) && !empty($draw_signature_id)) {	
			$drawSignatureBlockCL->draw_signature_id = $draw_signature_id;
			$drawSignatureBlockCL->setId($draw_signature_id);
			/*crack the sort_order*/
		} else {
			$draw_signature_id = $signatureBlockCLId;
		}

		$drawSignatureBlockCL->convertDataToProperties();
		$primaryKeyAsString = $drawSignatureBlockCL->getPrimaryKeyAsString();
		//  json return value
		$primaryKeyAsString = $draw_signature_id;
		$dummyId = $httpGetInputData['signature_type_id'];
			// Output standard formatted error or success message
		if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
			$errorNumber = 0;
			$errorMessage = '';
			$message->reset($currentPhpScript);
		} else {
			// Error code here
			$errorNumber = 1;
			$errorMessage = 'Error creating: Retention Signature.';
			$message->enqueueError($errorMessage, $currentPhpScript);
			throw new Exception($errorMessage);
		}
	} catch (Exception $e) {
		$db->rollback();
		$db->free_result();
		$errorNumber = 1;
	}

	$db->throwExceptionOnDbError = false;

	$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
	if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
		$errorNumber = 1;
		$errorMessage = join('<br>', $arrErrorMessages);
	}

	if (!isset($primaryKeyAsString)) {
		$primaryKeyAsString = '';
		if (isset($drawSignatureBlockCL) && $drawSignatureBlockCL instanceof RetentionSignatureBlocksConstructionLender) {
			$drawSignatureBlockCL = $drawSignatureBlockCL->getPrimaryKeyAsString();
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
	case 'DeleteSignatureBlockOtherType':
	try {
		// Ajax Handler Inputs
		require('code-generator/ajax-get-inputs.php');

		$httpGetInputData = $get->getData();
		$signatureBlockId = $httpGetInputData['signature_block_id'];
		$drawSignatureBlock = DrawSignatureBlocks::findById($database, $signatureBlockId);
		$drawSignatureBlock->delete();
	} catch (Exception $e) {
		$db->rollback();
		$db->free_result();
		$errorNumber = 1;
	}
	break;
	//To delete the Retention other items
	case 'DeleteRetentionSignatureBlockOtherType':
	try {
		// Ajax Handler Inputs
		require('code-generator/ajax-get-inputs.php');

		$httpGetInputData = $get->getData();
	echo "check :".	$signatureBlockId = $httpGetInputData['signature_block_id'];
		$drawSignatureBlock = RetentionSignatureBlocks::findById($database, $signatureBlockId);
		$drawSignatureBlock->delete();
	} catch (Exception $e) {
		$db->rollback();
		$db->free_result();
		$errorNumber = 1;
	}
	break;

	case 'CreateOrUpdateBreakdown':
	$crudOperation = 'CreateOrUpdateBreakdown';
	$errorNumber = 0;
	$errorMessage = 'Please fill in the Highlighted area';
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
			$arrErrorMessages = array(
				'Error creating: Signature Block.<br>Permission Denied.' => 1
			);
			require('code-generator/ajax-permissions.php');
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->throwExceptionOnDbError = true;

		$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the DiscussionItem record
		$httpGetInputData = $get->getData();
		foreach ($httpGetInputData as $k => $v) {
			if (empty($v)) {
				unset($httpGetInputData[$k]);
			}
		}
		$drawBreakdownId = $httpGetInputData['draw_breakdown_id'];
		$drawItemId = $httpGetInputData['draw_item_id'];
		$item = $httpGetInputData['item'];
		if ($drawBreakdownId && $drawBreakdownId != 'null' && $drawBreakdownId != undefined) {
			$drawBreakdown = DrawBreakDowns::findById($database, $drawBreakdownId);
		} else {
			$drawBreakdown = new DrawBreakDowns($database);	
		}
		// echo $drawSignatureBlock;
		$drawBreakdown->setData($httpGetInputData);
		$drawBreakdown->convertDataToProperties();
		$drawBreakdown->convertPropertiesToData();
		$data = $drawBreakdown->getData();
		/*crack the sort_order*/
		// Test for existence via standard findByUniqueIndex method

		$drawBreakdown->findByUniqueIndex();
		$data['item'] = $item;
		if ($item == '' || $item == undefined ) {
			$data['item'] = 'NULL';
		}
		
		if ($drawBreakdown->isDataLoaded()) {
				// Error code here
			$errorMessage = 'Draw Breakdown already exists.';
			$data['updated_contact_id'] = $currentlyActiveContactId;
			$data['updated_date'] = date('Y-m-d h:i:s');
			// $message->enqueueError($errorMessage, $currentPhpScript);
			// $primaryKeyAsString = $drawSignatureBlock->getPrimaryKeyAsString();
			// throw new Exception($errorMessage);
			$drawBreakdown->setData($data);
		} else {
			$drawBreakdown->setKey(null);
			$data['created_contact_id'] = $currentlyActiveContactId;
			$drawBreakdown->setData($data);
		}
		$draw_breakdown_id = $drawBreakdown->save();
		// echo $description;
		/*if (($description == '' || $description == 'null') && $httpGetInputData['signature_type_id'] != 4) {
			$errorNumber = 1;
			$errorMessage = 'Draw signature block name should not be empty';
			$message->enqueueError($errorMessage, $currentPhpScript);
			$primaryKeyAsString = $drawBreakdown->getPrimaryKeyAsString();
			// throw new Exception($errorMessage);
		}*/
		if (isset($draw_breakdown_id) && !empty($draw_breakdown_id)) {	
			$drawBreakdown->draw_breakdown_id = $draw_breakdown_id;
			$drawBreakdown->setId($draw_breakdown_id);
			/*crack the sort_order*/
		} else {
			$draw_breakdown_id = $drawBreakdownId;
		}

		$drawBreakdown->convertDataToProperties();
		$primaryKeyAsString = $drawBreakdown->getPrimaryKeyAsString();
		//  json return value
		$primaryKeyAsString = $draw_breakdown_id;
		$dummyId = $drawBreakdownId;
			// Output standard formatted error or success message
		if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
			$errorNumber = 0;
			$errorMessage = '';
			$message->reset($currentPhpScript);
		} else {
			// Error code here
			$errorNumber = 1;
			$errorMessage = 'Error processing: Draw BreakDown.';
			$message->enqueueError($errorMessage, $currentPhpScript);
			throw new Exception($errorMessage);
		}
		// get all signature Types
		  $loadBreakDownsOptions = new Input();
		  $loadBreakDownsOptions->forceLoadFlag = true;
		  $arrBreakDownsArr = DrawBreakDowns::loadAllDrawBreakDowns($database, $drawItemId, $loadBreakDownsOptions);
		  $curr_per_total = 0;
		  $base_per_total = 0;
		  foreach($arrBreakDownsArr as $drawBreakdownId => $breakdown) {
		  	$base_per = $breakdown->base_per;
		  	$item = $breakdown->item;
			$curr_per = $breakdown->current_per;
			$base_per_total += $base_per;
			$curr_per_total += $curr_per;
		  }
		  $base_per_total = number_format($base_per_total, 2);
		  $curr_per_total = number_format($curr_per_total, 2);
		  $htmlRecord = "<td>$base_per_total</td><td></td><td>0.00</td><td>$curr_per_total</td>";
	} catch (Exception $e) {
		$db->rollback();
		$db->free_result();
		$errorNumber = 1;
	}
	
	$db->throwExceptionOnDbError = false;

	$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
	if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
		$errorNumber = 1;
		$errorMessage = join('<br>', $arrErrorMessages);
	}

	if (!isset($primaryKeyAsString)) {
		$primaryKeyAsString = '';
		if (isset($drawBreakdown) && $drawBreakdown instanceof DrawBreakDowns) {
			$drawBreakdown = $drawBreakdown->getPrimaryKeyAsString();
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
	case 'DeleteBreakdownRow':
	try {
		// Ajax Handler Inputs
		require('code-generator/ajax-get-inputs.php');

		$httpGetInputData = $get->getData();
		$breakdownId = $httpGetInputData['draw_breakdown_id'];
		$breakdown = DrawBreakDowns::findById($database, $breakdownId);
		$breakdown->delete();
	} catch (Exception $e) {
		$db->rollback();
		$db->free_result();
		$errorNumber = 1;
	}
	break;
	case 'checkdrawdownload':
				// Ajax Handler Inputs
		//require('code-generator/ajax-get-inputs.php');
		$httpGetInputData = $get->getData();
	
	 	$returnval  = 'N';
	 	$project_id = $session->getCurrentlySelectedProjectId();
		require_once('lib/common/DrawItems.php');
	
	 	if(!empty($httpGetInputData['narrative_flag']) && $httpGetInputData['narrative_flag'] =='true' && !empty($httpGetInputData['draw_id'])){

	 		if(!empty($httpGetInputData['type']) && $httpGetInputData['type'] =='pdf'){
	 			$cor_type = Project::CORAboveOrBelow($database,$project_id);
	 			$corType = ($cor_type == 2) ? 'A' : 'B';
				$draws_items_arr = DrawItems::getDrawItemsWithOutChangeOrder($database,$httpGetInputData['draw_id'],'1');
				$changeOrderRequests = DrawItems::getDrawItemsOnlyChangeOrder($database,$httpGetInputData['draw_id'],'1',$corType);	
				if(!empty($draws_items_arr) || !empty($changeOrderRequests)){
					$returnval = 'Y';
				}		
	 		 }else if(!empty($httpGetInputData['type']) && $httpGetInputData['type'] =='excel'){
	 		 	$cor_type = Project::CORAboveOrBelow($database,$project_id);
				$budgetDrawItems = DrawItems::getBudgetDrawItems($database,$httpGetInputData['draw_id'], '1', $cor_type);
				$changeOrderRequests = DrawItems::getChangeOrderDrawItems($database,$httpGetInputData['draw_id'],'1', $cor_type);
				if(!empty($budgetDrawItems) || !empty($changeOrderRequests)){
					$returnval = 'Y';
				}
			}
		
 		}else if(!empty($httpGetInputData['general_condition_flag']) && $httpGetInputData['general_condition_flag'] =='true' && !empty($httpGetInputData['draw_id'])){
 			if(!empty($httpGetInputData['type']) && $httpGetInputData['type'] =='pdf'){
				$draws_items_arr = DrawItems::getDrawItemsWithOutChangeOrder($database,$httpGetInputData['draw_id'],'4');
	
				if(empty($draws_items_arr) ){
					$returnval = 'Y';
				}		
	 		 }else if(!empty($httpGetInputData['type']) && $httpGetInputData['type'] =='excel'){
	 		 	$cor_type = Project::CORAboveOrBelow($database,$project_id);
				$budgetDrawItems = DrawItems::getBudgetDrawItems($database,$httpGetInputData['draw_id'], '4', $cor_type);

				if(empty($budgetDrawItems)){
					$returnval = 'Y';
				}
			}
	 	}

		echo $returnval;
	break;

	case 'checkretentiondrawdownload':
				
		$httpGetInputData = $get->getData();
	
	 	$returnval  = 'N';
	 	$project_id = $session->getCurrentlySelectedProjectId();
		require_once('lib/common/RetentionItems.php');
	
	 	if(!empty($httpGetInputData['narrative_flag']) && $httpGetInputData['narrative_flag'] =='true' && !empty($httpGetInputData['ret_id'])){
	 		$items_arr = RetentionItems::getRetItemDataForNarAndGCF($database,$httpGetInputData['ret_id'],'narrative');
	 		if(!empty($items_arr) ){
				$returnval = 'Y';
			}		
 		}else if(!empty($httpGetInputData['general_condition_flag']) && $httpGetInputData['general_condition_flag'] =='true' && !empty($httpGetInputData['ret_id'])){
 			$items_arr = RetentionItems::getRetItemDataForNarAndGCF($database,$httpGetInputData['ret_id'],'general_condition');
 			if(empty($items_arr) ){
				$returnval = 'Y';
			}
	 	}

		echo $returnval;
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
