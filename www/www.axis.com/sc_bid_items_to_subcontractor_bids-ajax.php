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

require_once('lib/common/ScBidItemToSubcontractorBid.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('sc_bid_items_to_subcontractor_bids-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewScBidItemsToSubcontractorBids = $permissions->determineAccessToSoftwareModuleFunction('sc_bid_items_to_subcontractor_bids_view');
$userCanManageScBidItemsToSubcontractorBids = $permissions->determineAccessToSoftwareModuleFunction('sc_bid_items_to_subcontractor_bids_manage');
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
	case 'createScBidItemToSubcontractorBid':

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
					'sc_bid_items_to_subcontractor_bids_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Sc Bid Item To Subcontractor Bid data values.';
				$arrErrorMessages = array(
					'Error creating: Sc Bid Item To Subcontractor Bid.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Sc Bid Item To Subcontractor Bid';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Sc Bid Items To Subcontractor Bids';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-sc_bid_item_to_subcontractor_bid-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$sc_bid_item_to_subcontractor_bid_id = (int) $get->sc_bid_item_to_subcontractor_bid_id;
			$sc_bid_item_id = (int) $get->sc_bid_item_id;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;
			$item_quantity = (int) $get->item_quantity;
			$unit = (string) $get->unit;
			$unit_price = (float) $get->unit_price;
			$exclude_bid_item_flag = (string) $get->exclude_bid_item_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the ScBidItemToSubcontractorBid record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$scBidItemToSubcontractorBid = new ScBidItemToSubcontractorBid($database);

			$scBidItemToSubcontractorBid->setData($httpGetInputData);
			$scBidItemToSubcontractorBid->convertDataToProperties();

			/*
			$scBidItemToSubcontractorBid->sc_bid_item_to_subcontractor_bid_id = $sc_bid_item_to_subcontractor_bid_id;
			$scBidItemToSubcontractorBid->sc_bid_item_id = $sc_bid_item_id;
			$scBidItemToSubcontractorBid->subcontractor_bid_id = $subcontractor_bid_id;
			$scBidItemToSubcontractorBid->item_quantity = $item_quantity;
			$scBidItemToSubcontractorBid->unit = $unit;
			$scBidItemToSubcontractorBid->unit_price = $unit_price;
			$scBidItemToSubcontractorBid->exclude_bid_item_flag = $exclude_bid_item_flag;
			*/

			$scBidItemToSubcontractorBid->convertPropertiesToData();
			$data = $scBidItemToSubcontractorBid->getData();

			// Test for existence via standard findByUniqueIndex method
			$scBidItemToSubcontractorBid->findByUniqueIndex();
			if ($scBidItemToSubcontractorBid->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Sc Bid Item To Subcontractor Bid already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$scBidItemToSubcontractorBid->setKey(null);
				$scBidItemToSubcontractorBid->setData($data);
			}

			$sc_bid_item_to_subcontractor_bid_id = $scBidItemToSubcontractorBid->save();
			if (isset($sc_bid_item_to_subcontractor_bid_id) && !empty($sc_bid_item_to_subcontractor_bid_id)) {
				$scBidItemToSubcontractorBid->sc_bid_item_to_subcontractor_bid_id = $sc_bid_item_to_subcontractor_bid_id;
				$scBidItemToSubcontractorBid->setId($sc_bid_item_to_subcontractor_bid_id);
			}
			// $scBidItemToSubcontractorBid->save();

			$scBidItemToSubcontractorBid->convertDataToProperties();
			$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Sc Bid Item To Subcontractor Bid.';
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
			//$errorMessage = 'Error creating: Sc Bid Item To Subcontractor Bid';
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
			if (isset($scBidItemToSubcontractorBid) && $scBidItemToSubcontractorBid instanceof ScBidItemToSubcontractorBid) {
				$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();
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

	case 'loadScBidItemToSubcontractorBid':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'sc_bid_items_to_subcontractor_bids_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Sc Bid Item To Subcontractor Bid.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Sc Bid Item To Subcontractor Bid';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Sc Bid Items To Subcontractor Bids';
			}

			// Primary key attibutes
			//$sc_bid_item_to_subcontractor_bid_id = (int) $get->uniqueId;
			// Debug
			//$sc_bid_item_to_subcontractor_bid_id = (int) 1;

			// Unique index attibutes
			$sc_bid_item_id = (int) $get->sc_bid_item_id;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Sc Bid Item To Subcontractor Bid';
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
			if (isset($scBidItemToSubcontractorBid) && $scBidItemToSubcontractorBid instanceof ScBidItemToSubcontractorBid) {
				$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();
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

	case 'loadAllScBidItemToSubcontractorBidRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'sc_bid_items_to_subcontractor_bids_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Sc Bid Item To Subcontractor Bid.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Sc Bid Item To Subcontractor Bid';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Sc Bid Items To Subcontractor Bids';
			}

			// Primary key attibutes
			//$sc_bid_item_to_subcontractor_bid_id = (int) $get->uniqueId;
			// Debug
			//$sc_bid_item_to_subcontractor_bid_id = (int) 1;

			// Unique index attibutes
			$sc_bid_item_id = (int) $get->sc_bid_item_id;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|sc_bid_items_to_subcontractor_bids|Sc Bid Item To Subcontractor Bid|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Sc Bid Item To Subcontractor Bid';
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

	case 'updateScBidItemToSubcontractorBid':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Sc Bid Item To Subcontractor Bid';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'sc_bid_items_to_subcontractor_bids_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Sc Bid Item To Subcontractor Bid - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Sc Bid Item To Subcontractor Bid';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Sc Bid Items To Subcontractor Bids';
			}

			// Primary key attibutes
			//$sc_bid_item_to_subcontractor_bid_id = (int) $get->uniqueId;
			// Debug
			//$sc_bid_item_to_subcontractor_bid_id = (int) 1;

			// Unique index attibutes
			$sc_bid_item_id = (int) $get->sc_bid_item_id;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'sc_bid_item_to_subcontractor_bid_id' => 'sc bid item to subcontractor bid id',
				'sc_bid_item_id' => 'sc bid item id',
				'subcontractor_bid_id' => 'subcontractor bid id',
				'item_quantity' => 'item quantity',
				'unit' => 'unit',
				'unit_price' => 'unit price',
				'exclude_bid_item_flag' => 'exclude bid item flag',
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

			if ($attributeSubgroupName == 'sc_bid_items_to_subcontractor_bids') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$sc_bid_item_to_subcontractor_bid_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$scBidItemToSubcontractorBid = ScBidItemToSubcontractorBid::findById($database, $sc_bid_item_to_subcontractor_bid_id);
				/* @var $scBidItemToSubcontractorBid ScBidItemToSubcontractorBid */

				if ($scBidItemToSubcontractorBid) {
					// Check if the value actually changed
					$existingValue = $scBidItemToSubcontractorBid->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'sc_bid_item_id' => 1,
						'subcontractor_bid_id' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $scBidItemToSubcontractorBid->$attributeName;
						$scBidItemToSubcontractorBid->$attributeName = $newValue;
						$possibleDuplicateScBidItemToSubcontractorBid = ScBidItemToSubcontractorBid::findByScBidItemIdAndSubcontractorBidId($database, $scBidItemToSubcontractorBid->sc_bid_item_id, $scBidItemToSubcontractorBid->subcontractor_bid_id);
						if ($possibleDuplicateScBidItemToSubcontractorBid) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Sc Bid Item To Subcontractor Bid $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$scBidItemToSubcontractorBid->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$scBidItemToSubcontractorBid->setData($data);
						// $sc_bid_item_to_subcontractor_bid_id = $scBidItemToSubcontractorBid->save();
						$scBidItemToSubcontractorBid->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Sc Bid Item To Subcontractor Bid record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Sc Bid Item To Subcontractor Bid';
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
			if (isset($scBidItemToSubcontractorBid) && $scBidItemToSubcontractorBid instanceof ScBidItemToSubcontractorBid) {
				$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();
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

	case 'updateAllScBidItemToSubcontractorBidAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Sc Bid Item To Subcontractor Bid';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'sc_bid_items_to_subcontractor_bids_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Sc Bid Item To Subcontractor Bid.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Sc Bid Item To Subcontractor Bid';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Sc Bid Items To Subcontractor Bids';
			}

			// Primary key attibutes
			//$sc_bid_item_to_subcontractor_bid_id = (int) $get->uniqueId;
			// Debug
			//$sc_bid_item_to_subcontractor_bid_id = (int) 1;

			// Unique index attibutes
			$sc_bid_item_id = (int) $get->sc_bid_item_id;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$sc_bid_item_to_subcontractor_bid_id = (int) $get->sc_bid_item_to_subcontractor_bid_id;
			$sc_bid_item_id = (int) $get->sc_bid_item_id;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;
			$item_quantity = (int) $get->item_quantity;
			$unit = (string) $get->unit;
			$unit_price = (float) $get->unit_price;
			$exclude_bid_item_flag = (string) $get->exclude_bid_item_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'sc_bid_items_to_subcontractor_bids') {
				$sc_bid_item_to_subcontractor_bid_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$scBidItemToSubcontractorBid = ScBidItemToSubcontractorBid::findById($database, $sc_bid_item_to_subcontractor_bid_id);
				/* @var $scBidItemToSubcontractorBid ScBidItemToSubcontractorBid */

				if ($scBidItemToSubcontractorBid) {
					$existingData = $scBidItemToSubcontractorBid->getData();

					// Retrieve all of the $_GET inputs automatically for the ScBidItemToSubcontractorBid record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$scBidItemToSubcontractorBid->setData($httpGetInputData);
					$scBidItemToSubcontractorBid->convertDataToProperties();
					$scBidItemToSubcontractorBid->convertPropertiesToData();

					$newData = $scBidItemToSubcontractorBid->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$scBidItemToSubcontractorBid->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Sc Bid Item To Subcontractor Bid<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$scBidItemToSubcontractorBid->sc_bid_item_to_subcontractor_bid_id = $sc_bid_item_to_subcontractor_bid_id;
			$scBidItemToSubcontractorBid->sc_bid_item_id = $sc_bid_item_id;
			$scBidItemToSubcontractorBid->subcontractor_bid_id = $subcontractor_bid_id;
			$scBidItemToSubcontractorBid->item_quantity = $item_quantity;
			$scBidItemToSubcontractorBid->unit = $unit;
			$scBidItemToSubcontractorBid->unit_price = $unit_price;
			$scBidItemToSubcontractorBid->exclude_bid_item_flag = $exclude_bid_item_flag;
					*/

					// $sc_bid_item_to_subcontractor_bid_id = $scBidItemToSubcontractorBid->save();
					$scBidItemToSubcontractorBid->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Sc Bid Item To Subcontractor Bid record does not exist.';
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
			//$errorMessage = 'Error updating: Sc Bid Item To Subcontractor Bid';
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
			if (isset($scBidItemToSubcontractorBid) && $scBidItemToSubcontractorBid instanceof ScBidItemToSubcontractorBid) {
				$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();
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

	case 'deleteScBidItemToSubcontractorBid':

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
					'sc_bid_items_to_subcontractor_bids_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Sc Bid Item To Subcontractor Bid.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Sc Bid Item To Subcontractor Bid';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Sc Bid Items To Subcontractor Bids';
			}

			// Primary key attibutes
			//$sc_bid_item_to_subcontractor_bid_id = (int) $get->uniqueId;
			// Debug
			//$sc_bid_item_to_subcontractor_bid_id = (int) 1;

			// Unique index attibutes
			$sc_bid_item_id = (int) $get->sc_bid_item_id;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'sc_bid_items_to_subcontractor_bids') {
				$sc_bid_item_to_subcontractor_bid_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$scBidItemToSubcontractorBid = ScBidItemToSubcontractorBid::findById($database, $sc_bid_item_to_subcontractor_bid_id);
				/* @var $scBidItemToSubcontractorBid ScBidItemToSubcontractorBid */

				if ($scBidItemToSubcontractorBid) {
					$scBidItemToSubcontractorBid->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Sc Bid Item To Subcontractor Bid record does not exist.';
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
			//$errorMessage = 'Error deleting: Sc Bid Item To Subcontractor Bid';
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
			if (isset($scBidItemToSubcontractorBid) && $scBidItemToSubcontractorBid instanceof ScBidItemToSubcontractorBid) {
				$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();
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

	case 'saveScBidItemToSubcontractorBid':

		$crudOperation = 'save';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$isCreateCase = 0;

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'sc_bid_items_to_subcontractor_bids_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Sc Bid Item To Subcontractor Bid data values.';
				$arrErrorMessages = array(
					'Error saving Sc Bid Item To Subcontractor Bid.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Sc Bid Item To Subcontractor Bid';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Sc Bid Items To Subcontractor Bids';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-sc_bid_item_to_subcontractor_bid-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$sc_bid_item_to_subcontractor_bid_id = (int) $get->sc_bid_item_to_subcontractor_bid_id;
			$sc_bid_item_id = (int) $get->sc_bid_item_id;
			$subcontractor_bid_id = (int) $get->subcontractor_bid_id;
			$item_quantity = (int) $get->item_quantity;
			$unit = (string) $get->unit;
			$unit_price = (float) $get->unit_price;
			$exclude_bid_item_flag = (string) $get->exclude_bid_item_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			//$scBidItemToSubcontractorBid = new ScBidItemToSubcontractorBid($database);

			// Retrieve all of the $_GET inputs automatically for the ScBidItemToSubcontractorBid record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$index = strpos($uniqueId, '-');
			if ($index) {
				$arrTmp = explode('-', $uniqueId);
				$subcontractor_bid_id = array_shift($arrTmp);
				$sc_bid_item_id = array_shift($arrTmp);
				$httpGetInputData['subcontractor_bid_id'] = $subcontractor_bid_id;
				$httpGetInputData['sc_bid_item_id'] = $sc_bid_item_id;
				$scBidItemToSubcontractorBid = ScBidItemToSubcontractorBid::findByScBidItemIdAndSubcontractorBidId($database, $sc_bid_item_id, $subcontractor_bid_id);
			} else {
				$sc_bid_item_to_subcontractor_bid_id = (int) $uniqueId;
				$httpGetInputData['sc_bid_item_to_subcontractor_bid_id'] = $sc_bid_item_to_subcontractor_bid_id;
				$scBidItemToSubcontractorBid = ScBidItemToSubcontractorBid::findById($database, $sc_bid_item_to_subcontractor_bid_id);
			}

			if ($scBidItemToSubcontractorBid) {
				$scBidItemToSubcontractorBid->setData($httpGetInputData);
				$scBidItemToSubcontractorBid->convertDataToProperties();
				$scBidItemToSubcontractorBid->convertPropertiesToData();
				$scBidItemToSubcontractorBid->save();
			} else {
				$isCreateCase = 1;
				$scBidItemToSubcontractorBid = new ScBidItemToSubcontractorBid($database);
				$scBidItemToSubcontractorBid->setData($httpGetInputData);
				$scBidItemToSubcontractorBid->convertDataToProperties();
				$scBidItemToSubcontractorBid->convertPropertiesToData();
				$sc_bid_item_to_subcontractor_bid_id = $scBidItemToSubcontractorBid->save();
				$scBidItemToSubcontractorBid->sc_bid_item_to_subcontractor_bid_id = $sc_bid_item_to_subcontractor_bid_id;
				$scBidItemToSubcontractorBid->convertPropertiesToData();
			}

			//$scBidItemToSubcontractorBid->setData($httpGetInputData);
			//$scBidItemToSubcontractorBid->convertDataToProperties();

			/*
			$scBidItemToSubcontractorBid->sc_bid_item_to_subcontractor_bid_id = $sc_bid_item_to_subcontractor_bid_id;
			$scBidItemToSubcontractorBid->sc_bid_item_id = $sc_bid_item_id;
			$scBidItemToSubcontractorBid->subcontractor_bid_id = $subcontractor_bid_id;
			$scBidItemToSubcontractorBid->item_quantity = $item_quantity;
			$scBidItemToSubcontractorBid->unit = $unit;
			$scBidItemToSubcontractorBid->unit_price = $unit_price;
			$scBidItemToSubcontractorBid->exclude_bid_item_flag = $exclude_bid_item_flag;
			*/

			//$scBidItemToSubcontractorBid->convertPropertiesToData();
			//$data = $scBidItemToSubcontractorBid->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			//$sc_bid_item_to_subcontractor_bid_id = $scBidItemToSubcontractorBid->insertOnDuplicateKeyUpdate();
			//if (isset($sc_bid_item_to_subcontractor_bid_id) && !empty($sc_bid_item_to_subcontractor_bid_id)) {
			//	$scBidItemToSubcontractorBid->sc_bid_item_to_subcontractor_bid_id = $sc_bid_item_to_subcontractor_bid_id;
			//	$scBidItemToSubcontractorBid->setId($sc_bid_item_to_subcontractor_bid_id);
			//}
			// $scBidItemToSubcontractorBid->insertOnDuplicateKeyUpdate();
			// $scBidItemToSubcontractorBid->insertIgnore();

			//$scBidItemToSubcontractorBid->convertDataToProperties();
			$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Sc Bid Item To Subcontractor Bid.';
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
			//$errorMessage = 'Error creating: Sc Bid Item To Subcontractor Bid';
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
			if (isset($scBidItemToSubcontractorBid) && $scBidItemToSubcontractorBid instanceof ScBidItemToSubcontractorBid) {
				$primaryKeyAsString = $scBidItemToSubcontractorBid->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$isCreateCase";
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
