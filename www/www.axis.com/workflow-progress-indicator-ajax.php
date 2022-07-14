<?php
/**
 * Create Workflow Indicators and Track Progress with Ajax Calls
 */
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['get_required'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');
/* @var $session Session */

// Method Call is our switch variable
if (isset($get)) {
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '-1';
		exit;
	}
} else {
	echo '-1';
	exit;
}

require_once('lib/common/Log.php');
require_once('lib/common/WorkflowProgressIndicator.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

$db = DBI::getInstance($database);
/* @var $db DBI_mysqli */

$db->throwExceptionOnDbError = true;

// Start output buffering to prevent output from being echo'd out
ob_start();

switch ($methodCall) {
	/**
	 * Creates a workflow object and returns the id
	 *
	 */
	case 'createDownloadWorkflowProgressIndicator':

		// Debug
		//$message->enqueueError('Workflow creation failed.', $currentPhpScript);

		// $get is required for this script via $init['get_required'] = true;
		$total = $get->total;
		if (empty($total)) {
			$total = 100;
		}

		try {

			$workflowProgressIndicator = WorkflowProgressIndicator::createNewWorkflowProgressIndicator($database, $total);
			/* @var $workflowProgressIndicator WorkflowProgressIndicator */

			$workflow_progress_indicator_id = $workflowProgressIndicator->workflow_progress_indicator_id;

		} catch(Exception $e) {

			Log::write("Workflow creation failed.");
			$workflow_progress_indicator_id = '-1';

		}

		echo $workflow_progress_indicator_id;

		break;

	/**
	 * Inputs:
	 * 1) $get->wfid
	 *
	 * Outputs:
	 * wfid and the progress as whatever we store in the database as a | seperated string
	 */
	case 'checkDownloadWorkflowProgress':

		$crudOperation = 'save';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';

		// Debug
		//$message->enqueueError('Unable to get the progress of the current process.', $currentPhpScript);

		//$logMessage = "case 'checkDownloadWorkflowProgress': begin - id: $workflow_progress_indicator_id";
		//Log::write($logMessage);

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// $get is required for this script via $init['get_required'] = true;
			$workflow_progress_indicator_id = $get->wfid;
			if (empty($workflow_progress_indicator_id)) {

				$errorNumber = 1;

			} else {

				$workflowProgressIndicator = WorkflowProgressIndicator::findById($database, $workflow_progress_indicator_id);
				/* @var $workflowProgressIndicator WorkflowProgressIndicator */

				//$logMessage = "case: 'checkDownloadWorkflowProgress': WorkflowProgressIndicator::findById($workflow_progress_indicator_id)";
				//Log::write($logMessage);

				if ($workflowProgressIndicator) {

					$progress = $workflowProgressIndicator->progress;
					$total = $workflowProgressIndicator->total;
					$percentTotal = floor($progress/$total*100);

					//$logMessage = "ID: $workflow_progress_indicator_id, Progress: $progress, Total: $total, Percent Total: $percentTotal%\n";
					//Log::write($logMessage);

					$arrCustomizedJsonOutput = array(
						'workflow_progress_indicator_id' => $workflow_progress_indicator_id,
						'progress' => $progress,
						'total' => $total,
					);

				} else{
					$errorNumber = 1;
				}

			}

		} catch(Exception $e) {

			$errorNumber = 1;
			$errorMessage = "Workflow progress retrieval failed for workflow_progress_indicator_id: $workflow_progress_indicator_id.";
			Log::write($errorMessage);

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
			if (isset($workflowProgressIndicator) && $workflowProgressIndicator instanceof WorkflowProgressIndicator) {
				$primaryKeyAsString = $workflowProgressIndicator->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlRecord";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

		break;

	/**
	 * Creates a workflow object and returns the id
	 *
	 */
	case 'deleteWorkflowProgress':

		// Debug
		//$message->enqueueError('Unable to delete workflow record.', $currentPhpScript);

		// $get is required for this script via $init['get_required'] = true;
		$workflow_progress_indicator_id = $get->wfid;
		$passThroughParameter = $get->passthrough;

		$result = $passThroughParameter;

		if (empty($workflow_progress_indicator_id)) {
			//echo '-1';
			$result = -1;
			break;
		}

		try {

			$workflowProgressIndicator = WorkflowProgressIndicator::findById($database, $workflow_progress_indicator_id);
			/* @var $workflowProgressIndicator WorkflowProgressIndicator */

			if ($workflowProgressIndicator) {
				$errorMessage = '$workflowProgressIndicator->delete()'." for workflow_progress_indicator_id: $workflow_progress_indicator_id.\n";
				// Log::write($errorMessage);
				$workflowProgressIndicator->delete();
			}

		} catch(Exception $e) {

			$errorMessage = "Workflow deletion failed for workflow_progress_indicator_id: $workflow_progress_indicator_id.";
			// Log::write($errorMessage);
			//echo '-1';
			$result = -1;
		}

		// Debug
		//echo 'deleted';

		echo $result;
		break;

	default:
		break;
}

// Flush all content
while(ob_get_level()) {
	ob_end_flush();
}
exit;
