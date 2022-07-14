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
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');
$timer->startTimer();
$_SESSION['timer'] = $timer;

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

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);
require_once('transmittal-functions.php');
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

	case 'Transmittal__editDialog':		// Dialog popup for edit dialog	
		$crudOperation = 'load';
		$errorNumber = 0;
		$errorMessage = '';
		$primaryKeyAsString = '';
		$htmlContent = '';
		$id = (string) $get->transId;

		try {
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			$htmlContent = buildEditTransmittalDialog($database, $user_company_id, $project_id, $currentlyActiveContactId,$id);

		} catch(Exception $e) {
			$db->rollback();
			$db->free_result();
			$errorNumber = 1;
		}

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) 
		{
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
		
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($requestForInformationDraft) && $requestForInformationDraft instanceof RequestForInformationDraft) {
				$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
			}
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'CreateTransmittalsDialog':		// Dialog popup for create dialog

		$crudOperation = 'load';
		$errorNumber = 0;
		$errorMessage = '';
		$primaryKeyAsString = '';
		$htmlContent = '';
		try {
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
				$htmlContent = buildCreateTransmittalDialog($database, $user_company_id, $project_id, $currentlyActiveContactId);

		} catch(Exception $e) {
			$db->rollback();
			$db->free_result();
			$errorNumber = 1;
		}

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($requestForInformationDraft) && $requestForInformationDraft instanceof RequestForInformationDraft) {
				$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
			}
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;
	break;

	case 'showTransmittalAttach':    // Dialog popup for create dialog

        $trans_id = $get->trans_id;
        $crudOperation = 'load';
        $errorNumber = 0;
        $errorMessage = '';
        $primaryKeyAsString = '';
        $htmlContent = '';
        try {
            // Ajax Handler Inputs
            require('code-generator/ajax-get-inputs.php');
            $htmlContent = showTransmittalAttachmentDialog($database, $user_company_id, $project_id, $currentlyActiveContactId,$trans_id);

        } catch(Exception $e) {
            $db->rollback();
            $db->free_result();
            $errorNumber = 1;
        }

        $arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
        if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
            $errorNumber = 1;
            $errorMessage = join('<br>', $arrErrorMessages);
        }

        $jsonFlag = false;
        if (isset($responseDataType) && ($responseDataType == 'json')) {
            require('code-generator/json-response.php');
        } elseif (isset($responseDataType) && ($responseDataType == 'html')) {
            $output = $htmlContent;
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
