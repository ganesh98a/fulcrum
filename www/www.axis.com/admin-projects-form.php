<?php
/**
 * Account management.
 *
 */
$init['access_level'] = 'admin';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

require_once('lib/common/PageComponents.php');



// Retrieve any html messages
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

$loginName = $session->getLoginName();

// Get the company_id and project_id values
$user_company_id = $session->getUserCompanyId();

// retrieve any postback data
$postBack = Egpcs::sessionGet($applicationLabel, 'admin-projects-form.php', 'post');
/* @var $postBack Egpcs */
// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	// set values using $postBack
	// Password/security section
	$currentPassword = $postBack['currentPassword'];

	$arrPostBackData = $postBack->getData();

	// THIS IS NOT COMPLETED
	$arrProjectList = array();
	foreach ($arrPostBackData as $k => $v) {
		$arrProjectList[] = $v;
	}

	$project_id = $postBack->project_id;
} else {
	$project_id = '';

	$user_id = $session->getUserId();

	$currentPassword = '';

	// Load User information from the database
	// users table ($u)
	$u = new User($database);
	$key = array('id' => $user_id);
	$u->setKey($key);
	$u->load();
}

// Project List Options
$dropdownProjectListOnChange = '';
require_once('lib/common/Project.php');
$arrProjectsList = Project::loadProjectsList($database, $user_company_id);
$arrOptions = $arrProjectsList['options_list'];
$arrProjectOptions = array('' => 'Select A Project');
$arrProjectOptions = $arrProjectOptions + $arrOptions;
$selectedProject = $project_id;
$template->assign('selectedProject', $selectedProject);
$template->assign('arrProjectOptions', $arrProjectOptions);
$template->assign('dropdownProjectListOnChange', $dropdownProjectListOnChange);

$htmlTitle = 'Projects';
$htmlBody = "onload='setFocus();'";

require('template-assignments/main.php');

$template->assign('queryString', $uri->queryString);
$template->assign('loginName', $loginName);
$template->assign('currentPassword', $currentPassword);
$htmlContent = $template->fetch('admin-projects-form.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');
