<?php
/**
 * Budget Subcontractor.
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
require_once('lib/common/Contact.php');
require_once('../budget_subcontractor_function_guest.php');


$message = Message::getInstance();
/* @var $message Message */

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link rel="stylesheet" href="../css/modules-purchasing-bid-spread.css">
	<link rel="stylesheet" href="../css/modules-permissions.css">
	<link rel="stylesheet" href="../css/fileuploader.css">
	<link rel="stylesheet" href="../css/bootstrap-popover.css">
	<link rel="stylesheet" href="../css/bootstrap-dropdown.css">
	<link rel="stylesheet" href="../css/entypo.css">

	
	<link rel="stylesheet" href="../css/modules-budget.css">
	<link href="../css/fSelect.css" rel="stylesheet">
	<link href="../esignature/sign_src/css/jquery.signaturepad.css" rel="stylesheet">
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
	<script src="../js/library-main.js"></script>

	<script src="../js/permissions.js"></script>
	<script src="../js/admin-projects-team-management.js"></script>

	<!--[if lt IE 8]>
	<script src="../js/json2.js"></script>
	<![endif]-->

	<script src="../js/accounting.js"></script>
	<script src="../js/library-data_types.js"></script>
	<script src="../js/library-tabular_data.js"></script>

	<script src="../js/fileuploader.js"></script>
	<script src="../js/bootstrap-dropdown.js"></script>
	<script src="../js/bootstrap-popover.js"></script>
	<script src="../js/bootstrap-tooltip.js"></script>

	<script src="../js/library-code-generator.js"></script>

	<script src="../js/generated/bid_items-js.js"></script>
	<script src="../js/generated/bid_items_to_subcontractor_bids-js.js"></script>
	<script src="../js/generated/subcontracts-js.js"></script>
	<script src="../js/generated/subcontractor_bids-js.js"></script>

	<script src="../js/modules-gc-budget.js"></script>

	<script src="../js/jquery.maskedinput.js"></script>


	<script src="../js/generated/contact_companies-js.js"></script>
	<script src="../js/generated/contact_company_offices-js.js"></script>
	<script src="../js/generated/contact_company_office_phone_numbers-js.js"></script>
	<script src="../js/generated/contact_phone_numbers-js.js"></script>
	<script src="../js/generated/contacts-js.js"></script>
	<script src="../js/generated/cost_code_divisions-js.js"></script>
	<script src="../js/generated/cost_codes-js.js"></script>
	<script src="../js/generated/gc_budget_line_items-js.js"></script>
	<script src="../js/generated/mobile_phone_numbers-js.js"></script>
	<script src="../js/generated/subcontract_documents-js.js"></script>
	<script src="../js/generated/subcontracts-js.js"></script>

	<script src="../js/modules-contacts-manager-common.js"></script>
	<script src="../js/generated/file_manager_files-js.js"></script>
	<script src="../js/modules-purchasing.js"></script>
	<script src="../js/fSelect.js"></script>

	<script src="../js/budget_subcontract.js"></script>
	<script src="../js/budget_subcontract_guest.js"></script>

	<script src="../esignature/sign_src/js/html2canvas.js"></script>
	<script src="../esignature/sign_src/js/texthtml2canvas.js"></script>
	<script src="../esignature/sign_src/js/numeric-1.2.6.min.js"></script> 
	<script src="../esignature/sign_src/js/bezier.js"></script>
	<script src="../esignature/sign_src/js/json2.min.js"></script>
	<script src="../esignature/sign_src/js/jquery.signaturepad.js"></script> 
	<script src="../app/js/account-management-esign.js"></script>

END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Subcontractor - MyFulcrum.com';
$htmlBody = '';


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}
// require('lib/common/Permissions.php');
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
$subcontract_id = base64_decode($params['subid']);
$conid = base64_decode($params['conid']);
$fid = base64_decode($params['fid']);




if($token == null || $token == ''){
	// $RN_jsonEC['err_message'] = "Token value is Null";
}
else
{	
	$user = Contact::GetContactInfo($database,$conid,$pt_token);
	// $user = User::findUserByPWDGuidAuthentication($database, $token, true);
}

if($user){
	$project = Project::findById($database, $pt_token);
	$user->currentlySelectedProjectId = $project->project_id;
	$user->currentlySelectedProjectUserCompanyId = $project->user_company_id;
	$user->currentlySelectedProjectName = $project->project_name;

}else{
	echo "You don't have permission to access";
	exit(0);
}

$resfinal  = getfinalsubHtml($database,$subcontract_id,$user,$token,$pt_token,$conid);
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

$template->assign('subid', $subcontract_id);
$template->assign('guest', '1');
$cur_date=date("m/d/Y | h:i:s");
$template->assign('cur_date', $cur_date);
$template->assign('resfinal', $resfinal);
$template->assign('secondstyle','display:none;');





$htmlContent = $template->fetch('budget_subcontractor_guest.tpl');
$template->assign('htmlContent', $htmlContent);

$template->display('master-web-html5-guest.tpl');
exit;
