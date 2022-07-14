<?php
/**
 * File Management.
 *
 */
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
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

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link rel="stylesheet" href="../css/modules-file-manager-file-browser.css">
<link rel="stylesheet" href="../css/rightclick-menu-entypo.css">
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="../js/jquery.hotkeys.js"></script>
<script src="../js/jquery.jscroll.min.js"></script>
<script src="../js/modules-file-manager-file-browser-guest.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'File Management - MyFulcrum.com';
$htmlBody = '';


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}
require('lib/common/Permissions.php');
require('template-assignments/guest_main.php');

/*Validate the requeset method*/
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$params = $_GET;
}else{
	$params = $_POST;	
}
/*get the request values*/
$token = $params['token'];
$pt_token = (int)$params['pt_token'];
$subid = base64_decode($params['subid']);
$conid = base64_decode($params['conid']);
$fid = base64_decode($params['fid']);


if($token == null || $token == ''){
	// $RN_jsonEC['err_message'] = "Token value is Null";
}
else
{	
	$user = User::findUserByPWDGuidAuthentication($database, $token, true);
}
if($user){
	$project = Project::findById($database, $pt_token);
	$user->currentlySelectedProjectId = $project->project_id;
	$user->currentlySelectedProjectUserCompanyId = $project->user_company_id;
	$user->currentlySelectedProjectName = $project->project_name;
	// user_company_id
	// project_id
	// project_name
// echo "<pre>";
// print_r($user);
}else{
	echo "You don't have permission to access";
	exit(0);
}
$user_company_id = $user->user_company_id;
$template->assign('user_company_id', $user_company_id);

$currentlySelectedProjectId = $user->currentlySelectedProjectId;

$template->assign('currentlySelectedProjectId', $currentlySelectedProjectId);

$projectName = $user->currentlySelectedProjectName;

$template->assign('projectName', $projectName);

$softwareModuleFunctionLabel = "File Manager";

$template->assign('softwareModuleFunctionLabel', $softwareModuleFunctionLabel);

$template->assign('token', $token);

$template->assign('pt_token', $pt_token);

$template->assign('conid', $conid);

$template->assign('fid', $fid);

$template->assign('subid', $subid);
$template->assign('guest', '1');
$cur_date=date("m/d/Y | h:i:s");
$template->assign('cur_date', $cur_date);



// Uncomment the rightClickMenu that matches the stylesheet above.

$rightClickMenu = $template->fetch('rightclick-menu-entypo.tpl');

$template->assign('rightClickMenu', $rightClickMenu);

$htmlContent = $template->fetch('modules-file-manager-file-browser.tpl');
$template->assign('htmlContent', $htmlContent);

$template->display('master-web-html5-guest.tpl');
exit;
