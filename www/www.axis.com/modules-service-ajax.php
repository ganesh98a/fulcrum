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

require_once('lib/common/Contact.php');
require_once('lib/common/Module.php');
require_once('lib/common/Submittal.php');
require_once('lib/common/RequestForInformation.php');
require_once('lib/common/Service/TableService.php');
require_once('modules-service-function.php');

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
	case 'loadContactForMail':

		$crudOperation = 'load';
		$errorNumber = 0;
		$errorMessage = '';
		$primaryKeyAsString = '';
		$htmlContent = '';

		try {

			require('code-generator/ajax-get-inputs.php');
		} catch(Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

		}
		$moduleName = $get->moduleName;
		$moduleid = $get->moduleid;
		$htmlContent =buildContactForEmail($database, $project_id,$user_company_id,$moduleName,$moduleid);
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

	case 'filterRolesforcontactmail':
			$role_ids = $get->role_ids;
			$moduleName = $get->moduleName;
			$moduleid = $get->moduleid;
			$search = $get->search;
			$emailTo= $get->emailTo;
			$emailCc= $get->emailCc;
			$emailBcc= $get->emailBcc;

			$arremailTo= explode(',', $emailTo);
			$arremailCc= explode(',', $emailCc);
			$arremailBcc= explode(',', $emailBcc);

			foreach ($arremailTo as $key => $value) {
				$tempemailTo[$value] =$value;
			}
			foreach ($arremailCc as $key => $value1) {
				$tempemailCc[$value1] =$value1;
			}
			foreach ($arremailBcc as $key => $value2) {
				$tempemailBcc[$value2] =$value2;
			}

			$emailcontactList = buildContactForEmailmodel($database, $project_id, $user_company_id,$moduleName,$moduleid,$role_ids,$search,$tempemailTo,$tempemailCc,$tempemailBcc);
			echo $emailcontactList;
		
	break;

	case 'loadpreviouslyemailList':
	$moduleName = $get->moduleName;
	$headerType = $get->headerType;
	
	switch ($moduleName) {
		case 'submittals':
			$submittal_id = Submittal::getpreviousrecpientList($database,$project_id);
			$arremailTo = loademailListForheader($database,$moduleName,$submittal_id,$headerType);
		break;
		case 'RFI':
			$rfi_id = RequestForInformation::getpreviousrecpientList($database,$project_id);
			$arremailTo = loademailListForheader($database,$moduleName,$rfi_id,$headerType);
		break;

	}
	$contact_data =  implode($arremailTo, ',');
	
	echo $contact_data;
	break;

	case 'EmailListSet':
	$moduleName = $get->moduleName;
	$header = $get->header;
	$arr_list = $get->arr_list;
	$res = Contact::ContactNameByIdList($database,$arr_list);
	echo $res;

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
