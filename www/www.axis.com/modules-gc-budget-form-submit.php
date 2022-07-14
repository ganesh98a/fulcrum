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
$init['post_required'] = true;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset('modules-gc-budget-form.php');

$session->setFormSubmitted(true);


// A user/contact is only allowed to see their companies view of a Project Budget
$user_company_id = $session->getUserCompanyId();
$project_id = $session->getCurrentlySelectedProjectId();


// Pull out tabular row data from $post input
$arrPostData = $post->getData();
$arrGcBudgetLineItems = array();
foreach ($arrPostData as $k => $v) {
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

// Check for errors
$errorFlagMissingCostCode = false;
$errorFlagMissingLineItem = false;
foreach ($arrGcBudgetLineItems as $k => $row) {
	$cost_code = $row['cost_code'];
	$cost_code_description = $row['cost_code_description'];
	$prime_contract_scheduled_value = $row['prime_contract_scheduled_value'];
	$forecasted_expenses = $row['forecasted_expenses'];

	// Ignore blank rows
	if (empty($cost_code) && empty($cost_code_description) && empty($prime_contract_scheduled_value) && empty($forecasted_expenses)) {
		unset($arrGcBudgetLineItems[$k]);
		continue;
	}

	if (empty($cost_code) && !$errorFlagMissingCostCode) {
		$message->enqueueError('Please provide a CODE for each line item.', 'modules-gc-budget-form.php');
		$errorFlagMissingCostCode = true;
	}

	if (empty($cost_code_description) && !$errorFlagMissingLineItem) {
		$message->enqueueError('Please provide a NAME for each line item.', 'modules-gc-budget-form.php');
		$errorFlagMissingLineItem = true;
	}
}

// Check error flags
if ($errorFlagMissingCostCode || $errorFlagMissingLineItem) {
	//$message->enqueueError('Please provide a CODE and NAME for each line item.', 'modules-gc-budget-form.php');
	$message->sessionPut();
	$post->sessionPut('modules-gc-budget-form.php');
	$url = 'modules-gc-budget-form.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
}

// Check if there is data to save
if (isset($arrGcBudgetLineItems) && !empty($arrGcBudgetLineItems)) {
	// Save to Database
	require_once('lib/common/GcBudget.php');
	$gcBudget = new GcBudget($database);
	$savedFlag = $gcBudget->saveGcBudgetLineItems($database, $user_company_id, $project_id, $arrGcBudgetLineItems);

	$message->enqueueConfirm('Budget items successfully saved.', 'modules-gc-budget-form.php');
	$message->sessionPut();
	$url = 'modules-gc-budget-form.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
} else {
	$url = 'modules-gc-budget-form.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
}
