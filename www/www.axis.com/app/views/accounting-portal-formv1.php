<?php
/**
 * Accounting  Module.
 */

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = true;
$init['get_maxlength'] = 2048;
$init['get_required'] = false;
$init['https'] = false;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['skip_always_include'] = false;
$init['skip_session'] = false;
$init['skip_templating'] = false;
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Message.php');
require_once('lib/common/ContractingEntities.php');
require_once('../controllers/accounting_cntrl.php');
require_once('../models/accounting_model.php');


$message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();

/*print_r($session);*/
$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
// /* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;
// PERMISSION VARIABLES
require_once('../models/permission_mdl.php');
/*Custom Permission call return value*/

$selectedEntity = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);

$entity_name = ContractingEntities::getcontractEntityNameforProject($database,$selectedEntity);

$row = getCompanyData($database, $user_company_id, $selectedEntity);


$clientId = '';
$clientSecret = '';
$webhooktoken = '';

if(!empty($row['client_id'])){
	$clientId = $row['client_id'];
}
if(!empty($row['client_secret'])){
	$clientSecret = $row['client_secret'];
}
if(!empty($row['webhook_token'])){
	$webhooktoken = $row['webhook_token'];
}


//The modules Should be visible For Global Admin 
if($userRole =="global_admin" || $userRole =="admin")
{
	$userCanManagePermission=1;
}

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '<link href="../css/accounting-portal.css" rel="stylesheet">';
}
$htmlCss .= <<<END_HTML_CSS

END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$url = '';
	if(!empty($clientId) && !empty($clientSecret)){
		$url = getAuthorizationUrl($clientId, $clientSecret,$config);
	}
	
	$htmlJavaScriptBody = 	'<script>
								var  url= "'.$url.'"
							</script>
							<script src="../js/accounting_portal.js"></script>';
}

$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY

END_HTML_JAVASCRIPT_BODY;
$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Accounting Portal - '.$userCompanyName;
$htmlBody = '';

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
} 
//Check the permisson for view delay
$userCanViewAccount = checkPermissionForAllModuleAndRole($database,'view_accounting_portal');
$userCanManageAccount = checkPermissionForAllModuleAndRole($database,'manage_accounting_portal');

// If No Access
if($userRole !="global_admin"){
	if (!$userCanViewAccount &&(!$userCanManageAccount) || (!$userCanManageAccount &&(!$userCanViewAccount) ) ) {
		$errorMessage = 'Permission denied.';
		$message->enqueueError($errorMessage, $currentPhpScript);
	}
}
if($userRole =="global_admin"){
	$userCanManageAccount=1;
}
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
$readonly = '';
if($userCanViewAccount && !$userCanManageAccount){
	$readonly = 1;
}

$innerStructure = 1;
require("../../include/template-assignments/main.php");
/*$quickbook_status = '<p style="color: #8a6d3b;margin: 5px;">Disconnected</p>';
if(!empty($row['refresh_token_expires']) &&  strtotime("now") < strtotime($row['refresh_token_expires'])){
	$quickbook_status = '<p style="color: #3c763d;margin: 5px;">Connected</p>';	
}*/

$quickbook_status = checkaccountingportal($database,$user_company_id,$config);

$accountingTable = getAccountingPortal($clientId, $clientSecret, $user_company_id,$quickbook_status ,$webhooktoken, $readonly);
$selectedaccountportal = '';
if (!empty($row['accounting_portal_id'])) {
	$selectedaccountportal = $row['accounting_portal_id'];	
}
$accountingportals = accountingportals($database,$selectedaccountportal,$readonly);
$quickbooksclass = 'displayNone';
if(!empty($row['portal']) && $row['portal'] =='Quickbooks'){
	$quickbooksclass = '';
}

//$ContractingEntitiesArr = ContractingEntities::getContractEntityByUserCompanyId($database,$user_company_id);



// $contractingEntities = getContractingEntities($database, $ContractingEntitiesArr, $selectedEntity,$readonly);

$stepstoconnectqb = qb_stepstoconnect($clientId, $clientSecret,$config);

$stepsactive = qb_stepsactive($clientId, $clientSecret);

$template->assign('accountingportals',$accountingportals);
//$template->assign('contractingEntities',$contractingEntities);
$template->assign('selectedEntity',$selectedEntity);
$template->assign('quickbooksclass',$quickbooksclass);
$template->assign('htmlMessages',$htmlMessages);

$template->assign('stepsactive',$stepsactive);
$template->assign('stepstoconnectqb',$stepstoconnectqb);
$template->assign('accountingTable',$accountingTable);
$projectName = $userCompanyName.'('.$entity_name.')';
$template->assign('projectName',$projectName); // To display Company name in header

$htmlContent = $template->fetch('accounting-portal.tpl');
$template->assign('htmlContent', $htmlContent); 
$template->display('master-web-html5.tpl');

exit;
