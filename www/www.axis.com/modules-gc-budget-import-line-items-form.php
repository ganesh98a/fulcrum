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

require_once('lib/common/Format.php');
require_once('lib/common/GcBudget.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/PageComponents.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
// user_company_id and project_id values
// use $_GET value to allow "send screen to" feature
if (isset($get) && $get->importFromProjectUserCompanyId) {
	$importFromProjectUserCompanyId = $get->importFromProjectUserCompanyId;
} else {
	$importFromProjectUserCompanyId = '';
}
if (isset($get) && $get->importFromProjectId) {
	$importFromProjectId = $get->importFromProjectId;
} else {
	$importFromProjectId = '';
}
// A user/contact is only allowed to see their companies view of a Project Budget
$user_company_id = $session->getUserCompanyId();
$project_id = $session->getCurrentlySelectedProjectId();
// Permissions based view
$user_id = $session->getUserId();


$project = new Project($database);
$key = array('id' => $project_id);
$project->setKey($key);
$project->load();
$project->convertDataToProperties();


$gcBudget = new GcBudget($database);
$arrCurrentlySelectedGcBudgetLineItems = $gcBudget->loadGcBudgetLineItems($database, $user_company_id, $project_id);
//$arrSystemDefaultBudgetItems = $gcBudget->loadSystemDefaultGcBudgetLineItems($database);


// retrieve any postback data or load data from the database
$arrImportFromGcBudgetLineItems = array();
$postBack = Egpcs::sessionGet($applicationLabel, 'modules-gc-budget-import-line-items-form.php', 'post');
/* @var $postBack Egpcs */
// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	$arrPostBackData = $postBack->getData();

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
			$arrImportFromGcBudgetLineItems[$i][$key] = $v;
		}
	}
} else {
	/**
	 * @todo Decide how permission allow the sharing of project budgets.
	 */
	/*
	if ($importFromProjectId == 1) {
		$importFromProjectUserCompanyId = 2;
	} else {
		$importFromProjectUserCompanyId = $user_company_id;
	}
	*/
	$arrImportFromGcBudgetLineItems = $gcBudget->loadGcBudgetLineItems($database, $importFromProjectUserCompanyId, $importFromProjectId);
}


/**
 * @todo Possibly add permissions for "project budget sharing" which would allow the manipulation of other companies' budgets
 */
// project list
//$arrProjectsList = Project::loadProjectsList($database, $user_company_id);
//$arrProjectOptions = $arrProjectsList['options_list'];
$arrProjectOptions = GcBudget::loadProjectsListForImport($database, $user_id);
$arrProjectOptionsTmp = array(
	'' => 'Select A Project',
	//AXIS_TEMPLATE_PROJECT_ID => 'Default System Project'
);
$arrProjectOptions = $arrProjectOptionsTmp + $arrProjectOptions;
$dropdownProjectListOnChange = "loadBudgetByProjectId('modules-gc-budget-import-line-items-form.php', $user_company_id)";
$selectedProject = "$importFromProjectId-$importFromProjectUserCompanyId";
$template->assign('dropdownProjectListStyle', '');
$template->assign('selectedProject', $selectedProject);
$template->assign('arrProjectOptions', $arrProjectOptions);
$template->assign('dropdownProjectListOnChange', $dropdownProjectListOnChange);
$template->assign('importFromProjectUserCompanyId', $importFromProjectUserCompanyId);
$template->assign('importFromProjectId', $importFromProjectId);


$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Construction Management - MyFulcrum.com';
$htmlBody = '';


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

//$template->assign('htmlMessages', $htmlMessages);

$template->assign('currentlySelectedProjectName', $project->project_name);

// Data is loaded earlier in this script (may come from $postBack or the database)
$template->assign('arrCurrentlySelectedGcBudgetLineItems', $arrCurrentlySelectedGcBudgetLineItems);
$template->assign('arrImportFromGcBudgetLineItems', $arrImportFromGcBudgetLineItems);
//$template->assign('arrSystemDefaultBudgetItems', $arrSystemDefaultBudgetItems);

if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
	$htmlContent = $template->fetch('project-budget-import-items-form-mobile.tpl');
} else {
	$htmlContent = $template->fetch('project-budget-import-items-form-web.tpl');
}
$template->assign('htmlContent', $htmlContent);

//require_once('page-components/axis/footer_smarty.php');
$template->display('master-web-html5.tpl');
