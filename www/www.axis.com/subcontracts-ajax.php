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

require_once('lib/common/ContactCompany.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/Vendor.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('subcontracts-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewSubcontracts = $permissions->determineAccessToSoftwareModuleFunction('subcontracts_view');
$userCanManageSubcontracts = $permissions->determineAccessToSoftwareModuleFunction('subcontracts_manage');
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
	case 'createSubcontract':

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
					'subcontracts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Subcontract data values.';
				$arrErrorMessages = array(
					'Error creating: Subcontract.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontracts';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-subcontract-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$subcontract_id = (int) $get->subcontract_id;
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$subcontract_sequence_number = (int) $get->subcontract_sequence_number;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;
			$subcontract_template_id = (int) $get->subcontract_template_id;
			$subcontract_gc_contact_company_office_id = (int) $get->subcontract_gc_contact_company_office_id;
			$subcontract_gc_phone_contact_company_office_phone_number_id = (int) $get->subcontract_gc_phone_contact_company_office_phone_number_id;
			$subcontract_gc_fax_contact_company_office_phone_number_id = (int) $get->subcontract_gc_fax_contact_company_office_phone_number_id;
			$subcontract_gc_contact_id = (int) $get->subcontract_gc_contact_id;
			$subcontract_gc_contact_mobile_phone_number_id = (int) $get->subcontract_gc_contact_mobile_phone_number_id;
			$vendor_id = (int) $get->vendor_id;
			$subcontract_vendor_contact_company_office_id = (int) $get->subcontract_vendor_contact_company_office_id;
			$subcontract_vendor_phone_contact_company_office_phone_number_id = (int) $get->subcontract_vendor_phone_contact_company_office_phone_number_id;
			$subcontract_vendor_fax_contact_company_office_phone_number_id = (int) $get->subcontract_vendor_fax_contact_company_office_phone_number_id;
			$subcontract_vendor_contact_id = (int) $get->subcontract_vendor_contact_id;
			$subcontract_vendor_contact_mobile_phone_number_id = (int) $get->subcontract_vendor_contact_mobile_phone_number_id;
			$unsigned_subcontract_file_manager_file_id = (int) $get->unsigned_subcontract_file_manager_file_id;
			$signed_subcontract_file_manager_file_id = (int) $get->signed_subcontract_file_manager_file_id;
			$subcontract_forecasted_value = (float) $get->subcontract_forecasted_value;
			$subcontract_actual_value = (float) $get->subcontract_actual_value;
			$subcontract_retention_percentage = (float) $get->subcontract_retention_percentage;
			$subcontract_issued_date = (string) $get->subcontract_issued_date;
			$subcontract_target_execution_date = (string) $get->subcontract_target_execution_date;
			$subcontract_execution_date = (string) $get->subcontract_execution_date;
			$active_flag = (string) $get->active_flag;
			*/

			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the Subcontract record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$subcontract = new Subcontract($database);

			$subcontract->setData($httpGetInputData);
			$subcontract->convertDataToProperties();

			/*
			$subcontract->subcontract_id = $subcontract_id;
			$subcontract->gc_budget_line_item_id = $gc_budget_line_item_id;
			$subcontract->subcontract_sequence_number = $subcontract_sequence_number;
			$subcontract->subcontractor_bid_id = $subcontractor_bid_id;
			$subcontract->subcontract_template_id = $subcontract_template_id;
			$subcontract->subcontract_gc_contact_company_office_id = $subcontract_gc_contact_company_office_id;
			$subcontract->subcontract_gc_phone_contact_company_office_phone_number_id = $subcontract_gc_phone_contact_company_office_phone_number_id;
			$subcontract->subcontract_gc_fax_contact_company_office_phone_number_id = $subcontract_gc_fax_contact_company_office_phone_number_id;
			$subcontract->subcontract_gc_contact_id = $subcontract_gc_contact_id;
			$subcontract->subcontract_gc_contact_mobile_phone_number_id = $subcontract_gc_contact_mobile_phone_number_id;
			$subcontract->vendor_id = $vendor_id;
			$subcontract->subcontract_vendor_contact_company_office_id = $subcontract_vendor_contact_company_office_id;
			$subcontract->subcontract_vendor_phone_contact_company_office_phone_number_id = $subcontract_vendor_phone_contact_company_office_phone_number_id;
			$subcontract->subcontract_vendor_fax_contact_company_office_phone_number_id = $subcontract_vendor_fax_contact_company_office_phone_number_id;
			$subcontract->subcontract_vendor_contact_id = $subcontract_vendor_contact_id;
			$subcontract->subcontract_vendor_contact_mobile_phone_number_id = $subcontract_vendor_contact_mobile_phone_number_id;
			$subcontract->unsigned_subcontract_file_manager_file_id = $unsigned_subcontract_file_manager_file_id;
			$subcontract->signed_subcontract_file_manager_file_id = $signed_subcontract_file_manager_file_id;
			$subcontract->subcontract_forecasted_value = $subcontract_forecasted_value;
			$subcontract->subcontract_actual_value = $subcontract_actual_value;
			$subcontract->subcontract_retention_percentage = $subcontract_retention_percentage;
			$subcontract->subcontract_issued_date = $subcontract_issued_date;
			$subcontract->subcontract_target_execution_date = $subcontract_target_execution_date;
			$subcontract->subcontract_execution_date = $subcontract_execution_date;
			$subcontract->active_flag = $active_flag;
			*/

			$subcontract->convertPropertiesToData();
			$data = $subcontract->getData();

			// Test for existence via standard findByUniqueIndex method
			$subcontract->findByUniqueIndex();
			if ($subcontract->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Subcontract already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$subcontract->setKey(null);
				$subcontract->setData($data);
			}

			$subcontract_id = $subcontract->save();
			if (isset($subcontract_id) && !empty($subcontract_id)) {
				$subcontract->subcontract_id = $subcontract_id;
				$subcontract->setId($subcontract_id);
			}
			// $subcontract->save();

			$subcontract->convertDataToProperties();
			$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Subcontract.';
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
			//$errorMessage = 'Error creating: Subcontract';
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
			if (isset($subcontract) && $subcontract instanceof Subcontract) {
				$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$gc_budget_line_item_id";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadSubcontract':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'subcontracts_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Subcontract.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontracts';
			}

			// Primary key attibutes
			//$subcontract_id = (int) $get->uniqueId;
			// Debug
			//$subcontract_id = (int) 1;

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$subcontract_sequence_number = (int) $get->subcontract_sequence_number;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Subcontract';
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
			if (isset($subcontract) && $subcontract instanceof Subcontract) {
				$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
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

	case 'loadAllSubcontractRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'subcontracts_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Subcontract.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontracts';
			}

			// Primary key attibutes
			//$subcontract_id = (int) $get->uniqueId;
			// Debug
			//$subcontract_id = (int) 1;

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$subcontract_sequence_number = (int) $get->subcontract_sequence_number;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|subcontracts|Subcontract|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Subcontract';
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

	case 'updateSubcontract':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Subcontract';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'subcontracts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Subcontract - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontracts';
			}

			// Primary key attibutes
			//$subcontract_id = (int) $get->uniqueId;
			// Debug
			//$subcontract_id = (int) 1;

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$subcontract_sequence_number = (int) $get->subcontract_sequence_number;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'subcontract_id' => 'subcontract id',
				'gc_budget_line_item_id' => 'gc budget line item id',
				'subcontract_sequence_number' => 'subcontract sequence number',
				'subcontractor_bid_id' => 'subcontractor bid id',
				'subcontract_template_id' => 'subcontract template id',
				'subcontract_gc_contact_company_office_id' => 'subcontract gc contact company office id',
				'subcontract_gc_phone_contact_company_office_phone_number_id' => 'subcontract gc phone contact company office phone number id',
				'subcontract_gc_fax_contact_company_office_phone_number_id' => 'subcontract gc fax contact company office phone number id',
				'subcontract_gc_contact_id' => 'subcontract gc contact id',
				'gc_signatory' => 'gc signatory',
				'subcontract_gc_contact_mobile_phone_number_id' => 'subcontract gc contact mobile phone number id',
				'vendor_id' => 'vendor id',
				'subcontract_vendor_contact_company_office_id' => 'subcontract vendor contact company office id',
				'subcontract_vendor_phone_contact_company_office_phone_number_id' => 'subcontract vendor phone contact company office phone number id',
				'subcontract_vendor_fax_contact_company_office_phone_number_id' => 'subcontract vendor fax contact company office phone number id',
				'subcontract_vendor_contact_id' => 'subcontract vendor contact id',
				'vendor_signatory' => 'vendor signatory',
				'subcontract_vendor_contact_mobile_phone_number_id' => 'subcontract vendor contact mobile phone number id',
				'unsigned_subcontract_file_manager_file_id' => 'unsigned subcontract file manager file id',
				'signed_subcontract_file_manager_file_id' => 'signed subcontract file manager file id',
				'subcontract_forecasted_value' => 'subcontract forecasted value',
				'subcontract_actual_value' => 'subcontract actual value',
				'subcontract_retention_percentage' => 'subcontract retention percentage',
				'subcontract_issued_date' => 'subcontract issued date',
				'subcontract_target_execution_date' => 'subcontract target execution date',
				'subcontract_execution_date' => 'subcontract execution date',
				'subcontract_mailed_date' => 'subcontract mailed date',
				'general_insurance_date' => 'general insurance date',
				'worker_date'=>'worker date',
				'car_insurance_date'=>'car insurance date',
				'city_license_date' => 'city license date',
				'active_flag' => 'active flag',
				'general_insurance_date_expiry' => 'general insurance date expiry',
				'worker_date_expiry'=>'worker date expiry',
				'car_insurance_date_expiry' => 'car insurance date expiry',
				'city_license_date_expiry' => 'city license date expiry',
				// Derived Attributes
				'vendor_contact_company_id' => 'vendor contact company id',
				'contact_phone_number_id' => 'contact phone number id'
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

			// Vendor
			if (($attributeSubgroupName == 'subcontracts') && ($attributeName == 'vendor_contact_company_id')) {
				// Convert 'vendor_contact_company_id' to 'vendor_id'

				// @todo Figure out Vendor implementation
				$vendor = false;
				$vendor_contact_company_id = (int) $newValue;
				$vendor_contact_id = null;

				if (isset($vendor_id) && !empty($vendor_id)) {
					$vendor = Vendor::findById($database, $vendor_id);
				} elseif ((isset($vendor_contact_company_id) && !empty($vendor_contact_company_id)) || (isset($vendor_contact_id) && !empty($vendor_contact_id))) {
					$vendor = Vendor::findByVendorContactCompanyIdAndVendorContactId($database, $vendor_contact_company_id, $vendor_contact_id);
				} else {
					$vendor_id = null;
				}

				if ($vendor) {
					/* @var vendor Vendor */
					$vendor_id = $vendor->vendor_id;

					// Set dependent data points here...
					$vendor_contact_company_id = $vendor->vendor_contact_company_id;
					$vendor_contact_company_office_id = $vendor->vendor_contact_company_office_id;
					$vendor_contact_id = $vendor->vendor_contact_id;

					if ($vendor_contact_company_id) {
						$vendorContactCompany = ContactCompany::findContactCompanyByIdExtended($database, $vendor_contact_company_id);
					}

				} elseif ($vendor_contact_company_id <> 0) {

					$vendor = new Vendor($database);

					if (isset($vendor_contact_company_id) && !isset($vendor_contact_id)) {
						$vendor->vendor_contact_company_id = $vendor_contact_company_id;
						$vendor->vendor_contact_id = null;
					} elseif (!isset($vendor_contact_company_id) && isset($vendor_contact_id)) {
						$vendor->vendor_contact_company_id = null;
						$vendor->vendor_contact_id = $vendor_contact_id;
					} else {
						$vendor->vendor_contact_company_id = $vendor_contact_company_id;
						$vendor->vendor_contact_id = $vendor_contact_id;
					}

					$vendor->convertPropertiesToData();

					$vendor_id = $vendor->save();

				}

				if ($vendor_contact_company_id == 0) {
					$attributeName = 'vendor_id';
					$vendor_id = null;

					$errorMessage = "Subcontracts Must Have a Vendor";
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception('Do not proceed with the save operation.');
				} else {
					if ($vendor_id) {
						$attributeName = 'vendor_id';
						$newValue = $vendor_id;
					} else {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$error->outputErrorMessages();
						exit;
					}
				}
			}

			if ($attributeSubgroupName == 'subcontracts') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$subcontract_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$subcontract = Subcontract::findById($database, $subcontract_id);
				/* @var $subcontract Subcontract */

				if ($subcontract) {
					// Check if the value actually changed
					$existingValue = $subcontract->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'gc_budget_line_item_id' => 1,
						'subcontract_sequence_number' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $subcontract->$attributeName;
						$subcontract->$attributeName = $newValue;
						$possibleDuplicateSubcontract = Subcontract::findByGcBudgetLineItemIdAndSubcontractSequenceNumber($database, $subcontract->gc_budget_line_item_id, $subcontract->subcontract_sequence_number);
						if ($possibleDuplicateSubcontract) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Subcontract $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$subcontract->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);

						// Reset dependent data points
						// GC Office
						if ($attributeName == 'subcontract_gc_contact_company_office_id') {
							$data['subcontract_gc_phone_contact_company_office_phone_number_id'] = null;
							$data['subcontract_gc_fax_contact_company_office_phone_number_id'] = null;
						}
						// GC Contact
						if ($attributeName == 'subcontract_gc_contact_id') {
							$data['subcontract_gc_contact_mobile_phone_number_id'] = null;
						}
						// Vendor
						if ($attributeName == 'vendor_id') {
							if ($newValue == '') {
								$data['vendor_id'] = null;
							}
							$data['subcontract_vendor_contact_company_office_id'] = null;
							$data['subcontract_vendor_phone_contact_company_office_phone_number_id'] = null;
							$data['subcontract_vendor_fax_contact_company_office_phone_number_id'] = null;
							$data['subcontract_vendor_contact_id'] = null;
							$data['subcontract_vendor_contact_mobile_phone_number_id'] = null;
						}
						// Vendor Office
						if ($attributeName == 'subcontract_vendor_contact_company_office_id') {
							$data['subcontract_vendor_phone_contact_company_office_phone_number_id'] = null;
							$data['subcontract_vendor_fax_contact_company_office_phone_number_id'] = null;
						}
						// Vendor
						if ($attributeName == 'subcontract_vendor_contact_id') {
							$data['subcontract_vendor_contact_mobile_phone_number_id'] = null;
						}

						$subcontract->setData($data);
						// Data resets cause convertDataToProperties() to be needed here.
						$subcontract->convertDataToProperties();
						// $subcontract_id = $subcontract->save();
						$subcontract->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Subcontract record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Subcontract';
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
			if (isset($subcontract) && $subcontract instanceof Subcontract) {
				$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
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

	case 'updateAllSubcontractAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Subcontract';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'subcontracts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Subcontract.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontracts';
			}

			// Primary key attibutes
			//$subcontract_id = (int) $get->uniqueId;
			// Debug
			//$subcontract_id = (int) 1;

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$subcontract_sequence_number = (int) $get->subcontract_sequence_number;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$subcontract_id = (int) $get->subcontract_id;
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$subcontract_sequence_number = (int) $get->subcontract_sequence_number;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;
			$subcontract_template_id = (int) $get->subcontract_template_id;
			$subcontract_gc_contact_company_office_id = (int) $get->subcontract_gc_contact_company_office_id;
			$subcontract_gc_phone_contact_company_office_phone_number_id = (int) $get->subcontract_gc_phone_contact_company_office_phone_number_id;
			$subcontract_gc_fax_contact_company_office_phone_number_id = (int) $get->subcontract_gc_fax_contact_company_office_phone_number_id;
			$subcontract_gc_contact_id = (int) $get->subcontract_gc_contact_id;
			$subcontract_gc_contact_mobile_phone_number_id = (int) $get->subcontract_gc_contact_mobile_phone_number_id;
			$vendor_id = (int) $get->vendor_id;
			$subcontract_vendor_contact_company_office_id = (int) $get->subcontract_vendor_contact_company_office_id;
			$subcontract_vendor_phone_contact_company_office_phone_number_id = (int) $get->subcontract_vendor_phone_contact_company_office_phone_number_id;
			$subcontract_vendor_fax_contact_company_office_phone_number_id = (int) $get->subcontract_vendor_fax_contact_company_office_phone_number_id;
			$subcontract_vendor_contact_id = (int) $get->subcontract_vendor_contact_id;
			$subcontract_vendor_contact_mobile_phone_number_id = (int) $get->subcontract_vendor_contact_mobile_phone_number_id;
			$unsigned_subcontract_file_manager_file_id = (int) $get->unsigned_subcontract_file_manager_file_id;
			$signed_subcontract_file_manager_file_id = (int) $get->signed_subcontract_file_manager_file_id;
			$subcontract_forecasted_value = (float) $get->subcontract_forecasted_value;
			$subcontract_actual_value = (float) $get->subcontract_actual_value;
			$subcontract_retention_percentage = (float) $get->subcontract_retention_percentage;
			$subcontract_issued_date = (string) $get->subcontract_issued_date;
			$subcontract_target_execution_date = (string) $get->subcontract_target_execution_date;
			$subcontract_execution_date = (string) $get->subcontract_execution_date;
			$active_flag = (string) $get->active_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'subcontracts') {
				$subcontract_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$subcontract = Subcontract::findById($database, $subcontract_id);
				/* @var $subcontract Subcontract */

				if ($subcontract) {
					$existingData = $subcontract->getData();

					// Retrieve all of the $_GET inputs automatically for the Subcontract record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$subcontract->setData($httpGetInputData);
					$subcontract->convertDataToProperties();
					$subcontract->convertPropertiesToData();

					$newData = $subcontract->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$subcontract->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Subcontract<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$subcontract->subcontract_id = $subcontract_id;
			$subcontract->gc_budget_line_item_id = $gc_budget_line_item_id;
			$subcontract->subcontract_sequence_number = $subcontract_sequence_number;
			$subcontract->subcontractor_bid_id = $subcontractor_bid_id;
			$subcontract->subcontract_template_id = $subcontract_template_id;
			$subcontract->subcontract_gc_contact_company_office_id = $subcontract_gc_contact_company_office_id;
			$subcontract->subcontract_gc_phone_contact_company_office_phone_number_id = $subcontract_gc_phone_contact_company_office_phone_number_id;
			$subcontract->subcontract_gc_fax_contact_company_office_phone_number_id = $subcontract_gc_fax_contact_company_office_phone_number_id;
			$subcontract->subcontract_gc_contact_id = $subcontract_gc_contact_id;
			$subcontract->subcontract_gc_contact_mobile_phone_number_id = $subcontract_gc_contact_mobile_phone_number_id;
			$subcontract->vendor_id = $vendor_id;
			$subcontract->subcontract_vendor_contact_company_office_id = $subcontract_vendor_contact_company_office_id;
			$subcontract->subcontract_vendor_phone_contact_company_office_phone_number_id = $subcontract_vendor_phone_contact_company_office_phone_number_id;
			$subcontract->subcontract_vendor_fax_contact_company_office_phone_number_id = $subcontract_vendor_fax_contact_company_office_phone_number_id;
			$subcontract->subcontract_vendor_contact_id = $subcontract_vendor_contact_id;
			$subcontract->subcontract_vendor_contact_mobile_phone_number_id = $subcontract_vendor_contact_mobile_phone_number_id;
			$subcontract->unsigned_subcontract_file_manager_file_id = $unsigned_subcontract_file_manager_file_id;
			$subcontract->signed_subcontract_file_manager_file_id = $signed_subcontract_file_manager_file_id;
			$subcontract->subcontract_forecasted_value = $subcontract_forecasted_value;
			$subcontract->subcontract_actual_value = $subcontract_actual_value;
			$subcontract->subcontract_retention_percentage = $subcontract_retention_percentage;
			$subcontract->subcontract_issued_date = $subcontract_issued_date;
			$subcontract->subcontract_target_execution_date = $subcontract_target_execution_date;
			$subcontract->subcontract_execution_date = $subcontract_execution_date;
			$subcontract->active_flag = $active_flag;
					*/

					// $subcontract_id = $subcontract->save();
					$subcontract->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Subcontract record does not exist.';
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
			//$errorMessage = 'Error updating: Subcontract';
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
			if (isset($subcontract) && $subcontract instanceof Subcontract) {
				$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
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

	case 'deleteSubcontract':

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
					'subcontracts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Subcontract.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontracts';
			}

			// Primary key attibutes
			//$subcontract_id = (int) $get->uniqueId;
			// Debug
			//$subcontract_id = (int) 1;

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$subcontract_sequence_number = (int) $get->subcontract_sequence_number;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'subcontracts') {
				$subcontract_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$subcontract = Subcontract::findById($database, $subcontract_id);
				/* @var $subcontract Subcontract */

				if ($subcontract) {
					$subcontract->delete();
					$sub_check_deleted = Subcontract::findById($database, $subcontract_id);
					if ($sub_check_deleted) {
						$errorNumber = 1;
						$errorMessage = 'Cannot delete subcontract. It is mapped to man power.';
					}else{
						$errorNumber = 0;
						$errorMessage = '';
					}
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Subcontract record does not exist.';
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
			//$errorMessage = 'Error deleting: Subcontract';
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
			if (isset($subcontract) && $subcontract instanceof Subcontract) {
				$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
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

	case 'saveSubcontract':

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
					'subcontracts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Subcontract data values.';
				$arrErrorMessages = array(
					'Error saving Subcontract.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontracts';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-subcontract-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$subcontract_id = (int) $get->subcontract_id;
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$subcontract_sequence_number = (int) $get->subcontract_sequence_number;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;
			$subcontract_template_id = (int) $get->subcontract_template_id;
			$subcontract_gc_contact_company_office_id = (int) $get->subcontract_gc_contact_company_office_id;
			$subcontract_gc_phone_contact_company_office_phone_number_id = (int) $get->subcontract_gc_phone_contact_company_office_phone_number_id;
			$subcontract_gc_fax_contact_company_office_phone_number_id = (int) $get->subcontract_gc_fax_contact_company_office_phone_number_id;
			$subcontract_gc_contact_id = (int) $get->subcontract_gc_contact_id;
			$subcontract_gc_contact_mobile_phone_number_id = (int) $get->subcontract_gc_contact_mobile_phone_number_id;
			$vendor_id = (int) $get->vendor_id;
			$subcontract_vendor_contact_company_office_id = (int) $get->subcontract_vendor_contact_company_office_id;
			$subcontract_vendor_phone_contact_company_office_phone_number_id = (int) $get->subcontract_vendor_phone_contact_company_office_phone_number_id;
			$subcontract_vendor_fax_contact_company_office_phone_number_id = (int) $get->subcontract_vendor_fax_contact_company_office_phone_number_id;
			$subcontract_vendor_contact_id = (int) $get->subcontract_vendor_contact_id;
			$subcontract_vendor_contact_mobile_phone_number_id = (int) $get->subcontract_vendor_contact_mobile_phone_number_id;
			$unsigned_subcontract_file_manager_file_id = (int) $get->unsigned_subcontract_file_manager_file_id;
			$signed_subcontract_file_manager_file_id = (int) $get->signed_subcontract_file_manager_file_id;
			$subcontract_forecasted_value = (float) $get->subcontract_forecasted_value;
			$subcontract_actual_value = (float) $get->subcontract_actual_value;
			$subcontract_retention_percentage = (float) $get->subcontract_retention_percentage;
			$subcontract_issued_date = (string) $get->subcontract_issued_date;
			$subcontract_target_execution_date = (string) $get->subcontract_target_execution_date;
			$subcontract_execution_date = (string) $get->subcontract_execution_date;
			$active_flag = (string) $get->active_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$subcontract = new Subcontract($database);

			// Retrieve all of the $_GET inputs automatically for the Subcontract record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$subcontract->setData($httpGetInputData);
			$subcontract->convertDataToProperties();

			/*
			$subcontract->subcontract_id = $subcontract_id;
			$subcontract->gc_budget_line_item_id = $gc_budget_line_item_id;
			$subcontract->subcontract_sequence_number = $subcontract_sequence_number;
			$subcontract->subcontractor_bid_id = $subcontractor_bid_id;
			$subcontract->subcontract_template_id = $subcontract_template_id;
			$subcontract->subcontract_gc_contact_company_office_id = $subcontract_gc_contact_company_office_id;
			$subcontract->subcontract_gc_phone_contact_company_office_phone_number_id = $subcontract_gc_phone_contact_company_office_phone_number_id;
			$subcontract->subcontract_gc_fax_contact_company_office_phone_number_id = $subcontract_gc_fax_contact_company_office_phone_number_id;
			$subcontract->subcontract_gc_contact_id = $subcontract_gc_contact_id;
			$subcontract->subcontract_gc_contact_mobile_phone_number_id = $subcontract_gc_contact_mobile_phone_number_id;
			$subcontract->vendor_id = $vendor_id;
			$subcontract->subcontract_vendor_contact_company_office_id = $subcontract_vendor_contact_company_office_id;
			$subcontract->subcontract_vendor_phone_contact_company_office_phone_number_id = $subcontract_vendor_phone_contact_company_office_phone_number_id;
			$subcontract->subcontract_vendor_fax_contact_company_office_phone_number_id = $subcontract_vendor_fax_contact_company_office_phone_number_id;
			$subcontract->subcontract_vendor_contact_id = $subcontract_vendor_contact_id;
			$subcontract->subcontract_vendor_contact_mobile_phone_number_id = $subcontract_vendor_contact_mobile_phone_number_id;
			$subcontract->unsigned_subcontract_file_manager_file_id = $unsigned_subcontract_file_manager_file_id;
			$subcontract->signed_subcontract_file_manager_file_id = $signed_subcontract_file_manager_file_id;
			$subcontract->subcontract_forecasted_value = $subcontract_forecasted_value;
			$subcontract->subcontract_actual_value = $subcontract_actual_value;
			$subcontract->subcontract_retention_percentage = $subcontract_retention_percentage;
			$subcontract->subcontract_issued_date = $subcontract_issued_date;
			$subcontract->subcontract_target_execution_date = $subcontract_target_execution_date;
			$subcontract->subcontract_execution_date = $subcontract_execution_date;
			$subcontract->active_flag = $active_flag;
			*/

			$subcontract->convertPropertiesToData();
			$data = $subcontract->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$subcontract_id = $subcontract->insertOnDuplicateKeyUpdate();
			if (isset($subcontract_id) && !empty($subcontract_id)) {
				$subcontract->subcontract_id = $subcontract_id;
				$subcontract->setId($subcontract_id);
			}
			// $subcontract->insertOnDuplicateKeyUpdate();
			// $subcontract->insertIgnore();

			$subcontract->convertDataToProperties();
			$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Subcontract.';
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
			//$errorMessage = 'Error creating: Subcontract';
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
			if (isset($subcontract) && $subcontract instanceof Subcontract) {
				$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
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
