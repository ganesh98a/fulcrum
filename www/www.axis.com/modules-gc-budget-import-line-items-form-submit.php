<?php
/**
 * Project Budget module.
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
$message->reset('modules-gc-budget-import-line-items-form.php');

$session->setFormSubmitted(true);

// A user/contact is only allowed to see their companies view of a Project Budget
$user_company_id = $session->getUserCompanyId();
$project_id = $session->getCurrentlySelectedProjectId();


// Import from data
$importFromProjectUserCompanyId = $get->importFromProjectUserCompanyId;
$importFromProjectId = $get->importFromProjectId;


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

$arrGcBudgetLineItemIds = array();
foreach ($arrGcBudgetLineItems as $k => $row) {
	// Ignore blank rows
	if (isset($row['checkbox']) && !empty($row['checkbox'])) {
		$gc_budget_line_item_id = $row['checkbox'];
		$arrGcBudgetLineItemIds[] = $gc_budget_line_item_id;
	}
}

// Check if there is data to save
if (isset($arrGcBudgetLineItemIds) && !empty($arrGcBudgetLineItemIds)) {
	// Save to Database
	require_once('lib/common/GcBudget.php');
	$gcBudget = new GcBudget($database);
	$savedFlag = $gcBudget->importGcBudgetLineItems($database, $user_company_id, $project_id, $arrGcBudgetLineItemIds);

	$message->enqueueConfirm('Budget items successfully imported.', 'modules-gc-budget-import-line-items-form.php');
	$message->sessionPut();
	$url = 'modules-gc-budget-import-line-items-form.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
} else {
	$url = 'modules-gc-budget-import-line-items-form.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
}
