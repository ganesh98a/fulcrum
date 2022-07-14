<?php
/**
 * Project Budget module.
 *
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');



require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset('modules-gc-budget-form.php');

$session->setFormSubmitted(true);

// Pull out tabular row data from $post input
$arrTmp = $get->delete;
$arrTmp = explode(',', $arrTmp);
$arrInputData = array();
foreach ($arrTmp as $value) {
	if (empty($value)) {
		continue;
	}
	$arrTemp = explode(':', $value);
//	$arrInputData[] = array(
//		$arrTemp[0] => $arrTemp[1]
//	);
	$k = $arrTemp[0];
	$v = $arrTemp[1];
	$arrInputData[$k] = $v;
}

$arrGcBudgetLineItems = array();
foreach ($arrInputData as $k => $v) {
	if (is_int(strpos($k, 'row_'))) {
		$arrTmp = explode('_', $k);
		$i = $arrTmp[1];
		$key = $arrTmp;
		array_shift($key);
		array_shift($key);
		$key = join('_', $key);
		$arrTemp = array(
			$key => $v
		);
		$arrGcBudgetLineItems[$i][$key] = $v;
	}
}


// A user/contact is only allowed to see their companies view of a Project Budget
$user_company_id = $session->getUserCompanyId();
$project_id = $session->getCurrentlySelectedProjectId();


// Save to Database
require_once('lib/common/GcBudget.php');
$gcBudget = new GcBudget($database);
//$project_id = $get->project_id;
$savedFlag = $gcBudget->deleteGcBudgetLineItems($database, $user_company_id, $project_id, $arrGcBudgetLineItems);
// Debug
//$savedFlag = true;
if ($savedFlag) {
	$xmlOutput = true;
} else {
	$xmlOutput = false;
}

$message = Message::getInstance();
/* @var $message Message */
//$message->enqueueConfirm('Selected budget items were deleted.', 'modules-gc-budget-form.php');
//$message->enqueueConfirm('Updated budget items list successfully saved to the database.', 'modules-gc-budget-form.php');
//$message->sessionPut();

// xml output
if ($xmlOutput) {
	$xml = 	'<?xml version="1.0" ?>'."\n";
	$xml .= '<root>'."\n";
	$xml .= '<info_message_count>2</info_message_count>'."\n";
	$xml .= '<info_messages>'."\n";
	$xml .= '<info_message>Selected budget items were deleted.</info_message>'."\n";
	$xml .= '<info_message>Updated budget items list successfully saved to the database.</info_message>'."\n";
	$xml .= '</info_messages>'."\n";
	$xml .= '</root>';
	header('Content-Type: text/xml');
	echo $xml;
}

exit;
