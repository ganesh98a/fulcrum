<?php

/**
 * Permissions Management.
 *
 *
 *
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

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();


$db = DBI::getInstance($database);
// Get the list of software modules.  Could modify this in the future to only get modules that the user has purchased.
if ($userRole == "global_admin") {
	$query =
"
SELECT sm.*
FROM `software_modules` sm
ORDER BY `software_module`
";
	$btnResetStyleParam = 'style="display:none;"';
} else {
	$query =
"
SELECT sm.*
FROM `software_modules` sm
WHERE `global_admin_only_flag` = 'N'
AND `customer_configurable_flag` = 'Y'
ORDER BY `software_module`
";
	$btnResetStyleParam = '';
}
$db->query($query);

$arrSoftwareModuleList = array();
$counter = 0;
$dropdownProjectListStyle = 'display:none;';
while ($row = $db->fetch()) {
	$software_module_id = $row['id'];
	$software_module = $row['software_module'];
	$project_specific_flag = $row['project_specific_flag'];

	if (($counter == 0) && ($project_specific_flag == 'Y')) {
		$dropdownProjectListStyle = 'display:block;';
	}

	$arrSoftwareModuleTmp = array(
			'software_module_id' => $software_module_id . "_" . $project_specific_flag,
			'software_module' => $software_module
	);

	$arrSoftwareModuleList[$counter] = $arrSoftwareModuleTmp;
	$counter++;
}

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/global-admin-permissions-form.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Permissions Management - MyFulcrum.com';
$htmlBody = '';


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}


// Get the user's projects list
// Project drop-down list template values
require_once('lib/common/Project.php');
$arrProjectsList = Project::loadProjectsList($database, $user_company_id);
// Drop down list format
$arrProjectOptions = $arrProjectsList['options_list'];
$selectedProject = $project_id;
$dropdownProjectListOnChange = "projectChanged();";

$template->assign('selectedProject', $selectedProject);
$template->assign('dropdownProjectListOnChange', $dropdownProjectListOnChange);
$template->assign('dropdownProjectListStyle', $dropdownProjectListStyle);
$template->assign('arrProjectOptions', $arrProjectOptions);


// Software Modules drop-down list template values
require_once('lib/common/SoftwareModule.php');
$arrSoftwareModulesList = SoftwareModule::loadSoftwareModulesList($database);
// Drop down list format
$arrSoftwareModuleOptions = $arrSoftwareModulesList['options_list'];
$arrSoftwareModuleObjects = $arrSoftwareModulesList['objects_list'];
$arrUpdatedSoftwareModuleOptions = array();
foreach ($arrSoftwareModuleOptions as $software_module_id => $software_module) {
	$tmpObject = $arrSoftwareModuleObjects[$software_module_id];
	$project_specific_flag = $tmpObject->project_specific_flag;
	$software_module_label = $tmpObject->software_module_label;
	$newKey = $software_module_id . "_" . $project_specific_flag;
	if ($project_specific_flag == 'Y') {
		$newValue = $software_module_label . " &mdash; Project Specific";
	} else {
		$newValue = $software_module_label . " &mdash; Not Project Specific";
	}
	$arrUpdatedSoftwareModuleOptions[$newKey] = $newValue;
}
$selectedSoftwareModule = '';
$dropdownSoftwareModuleListOnChange = "softwareModuleChanged();";
$dropdownSoftwareModuleListStyle = '';

$template->assign('selectedSoftwareModule', $selectedSoftwareModule);
$template->assign('dropdownSoftwareModuleListOnChange', $dropdownSoftwareModuleListOnChange);
$template->assign('dropdownSoftwareModuleListStyle', $dropdownSoftwareModuleListStyle);
$template->assign('arrSoftwareModuleOptions', $arrUpdatedSoftwareModuleOptions);


require('template-assignments/main.php');

// Data is loaded earlier in this script (may come from $postBack or the database)
$template->assign('arrSoftwareModuleList', $arrSoftwareModuleList);
$template->assign('btnResetStyleParam', $btnResetStyleParam);

if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
	$htmlContent = $template->fetch('global-admin-permissions-form-mobile.tpl');
} else {
	$htmlContent = $template->fetch('global-admin-permissions-form.tpl');
}
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');
exit;
