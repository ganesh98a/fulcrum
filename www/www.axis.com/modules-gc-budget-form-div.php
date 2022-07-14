<?php
/**
 * Project Budget module.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

setlocale(LC_MONETARY, 'en_US');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages('modules-gc-budget-form.php');

if ($get->div=1) {
	require_once('modules-gc-budget-functions-div.php');
} else {
	require_once('modules-gc-budget-functions.php');
}

// user_company_id and project_id values
// use $_GET value to allow "send screen to" feature
/*
if (isset($get) && $get->user_company_id) {
	$user_company_id = $get->user_company_id;
} else {
	$user_company_id = $session->getUserCompanyId();
}
if (isset($get) && $get->project_id) {
	$project_id = $get->project_id;
} else {
	$project_id = $session->getCurrentlySelectedProjectId();
}
// Debug
if (!isset($project_id) || empty($project_id)) {
	$project_id = 1;
}
*/
// A user/contact is only allowed to see their companies view of a Project Budget
/* @var $session Session */
$user_company_id = $session->getUserCompanyId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$project_id = $session->getCurrentlySelectedProjectId();

$project = new Project($database);
$key = array('id' => $project_id);
$project->setKey($key);
$project->load();
$project->convertDataToProperties();

// retrieve any postback data or load data from the database
$arrGcBudgetLineItems = array();
$postBack = Egpcs::sessionGet($applicationLabel, 'modules-gc-budget-form.php', 'post');
/* @var $postBack Egpcs */
// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	$arrPostBackData = $postBack->getData();

	/**
	 * @todo Generate a list of GcBudgetLineItem objects.
	 */
	foreach ($arrPostBackData as $k => $v) {
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
} else {
	//$gcBudget = new GcBudget($database);
	//$gcBudget->checkForBlankBudgetLineItemRow($database, $user_company_id, $project_id);
	//$arrGcBudgetLineItems = $gcBudget->loadGcBudgetLineItems($database, $user_company_id, $project_id);

	/*
	if (empty($arrGcBudgetLineItems)) {
		$arrGcBudgetLineItems = array(
			0 => array(
				'gc_budget_line_item_id' => '',
				'cost_code' => '',
				'cost_code_description' => '',
				'prime_contract_scheduled_value' => '',
				'forecasted_expenses' => '',
			),
			1 => array(
				'gc_budget_line_item_id' => '',
				'cost_code' => '',
				'cost_code_description' => '',
				'prime_contract_scheduled_value' => '',
				'forecasted_expenses' => '',
			),
			2 => array(
				'gc_budget_line_item_id' => '',
				'cost_code' => '',
				'cost_code_description' => '',
				'prime_contract_scheduled_value' => '',
				'forecasted_expenses' => '',
			),
			3 => array(
				'gc_budget_line_item_id' => '',
				'cost_code' => '',
				'cost_code_description' => '',
				'prime_contract_scheduled_value' => '',
				'forecasted_expenses' => '',
			),
			4 => array(
				'gc_budget_line_item_id' => '',
				'cost_code' => '',
				'cost_code_description' => '',
				'prime_contract_scheduled_value' => '',
				'forecasted_expenses' => '',
			),
			/**
			5 => array(
				'gc_budget_line_item_id' => '',
				'cost_code' => '',
				'cost_code_description' => '',
				'prime_contract_scheduled_value' => '',
				'forecasted_expenses' => '',
			),
			/
		);
	}
	*/
}

//$arrContactCompaniesByUserUserCompanyId = ContactCompany::loadContactCompaniesByUserUserCompanyId($database, $user_company_id);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link rel="stylesheet" href="/css/modules-permissions.css">
<link rel="stylesheet" href="/css/modules-budget.css">
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/jquery.numeric.js"></script>
	<script src="/js/modules-gc-budget.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Construction Management - MyFulcrum.com';
$htmlBody = 'onload="updateBudgetValues(\'tblTabularData\');"';


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

//$template->assign('htmlMessages', $htmlMessages);

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $session->getUserCompanyId());
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;


// Data is loaded earlier in this script (may come from $postBack or the database)
$template->assign('project_id',$project_id);
$template->assign('projectName',$session->getCurrentlySelectedProjectName());
$template->assign('companyName',$userCompanyName);
//$template->assign('arrContactCompanies', $arrContactCompanies);

if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
	$htmlContent = $template->fetch('project-budget-form-mobile.tpl');
} else {
	//$template->assign('arrGcBudgetLineItems', $arrGcBudgetLineItems);
	//$template->assign('arrGcBudgetLineItems', '');
	//$gcBudgetLineItemsForm = renderGcBudgetForm($database, $user_company_id, $currentlyActiveContactId, $project_id, $companyName, $projectName);
	//$template->assign('budgetItems', $gcBudgetLineItemsForm);
	$htmlContent = renderGcBudgetForm($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName);
	//$htmlContent = $template->fetch('project-budget-form-web.tpl');
}
$template->assign('htmlContent', $htmlContent);

//require_once('page-components/axis/footer_smarty.php');
$template->display('master-web-html5.tpl');
