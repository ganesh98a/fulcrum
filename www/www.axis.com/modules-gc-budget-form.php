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
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (isset($get->div) && ($get->div==1)) {
	require_once('modules-gc-budget-functions-div.php');
} else {
	require_once('modules-gc-budget-functions.php');
}
require_once('modules-change-orders-functions.php');

//Permission
require_once('app/models/permission_mdl.php');
$userCanViewbudget = checkPermissionForAllModuleAndRole($database,'gc_budgets_view');
$userCanManagebudget = checkPermissionForAllModuleAndRole($database,'gc_budgets_manage');
$user_company_id = $session->getUserCompanyId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
// $project_id = $session->getCurrentlySelectedProjectId();
$project_id = base64_decode($_GET['pID']);
$userRole = $session->getUserRole();
if($userRole =="global_admin")
{
	$userCanManagebudget=$userCanViewbudget = 1;
}
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);


// user_company_id and project_id values
// use $_GET value to allow "send screen to" feature

// A user/contact is only allowed to see their companies view of a Project Budget


$project = new Project($database);
$key = array('id' => $project_id);
$project->setKey($key);
$project->load();
$project->convertDataToProperties();

// retrieve any postback data or load data from the database
$arrGcBudgetLineItems = array();
$postBack = Egpcs::sessionGet($applicationLabel, $currentPhpScript, 'post');
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
}


if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<style>
.ui-autocomplete {
	overflow-y: auto;
	max-height: 150px;
	height: 150px;
	width: 300px;
}
.subcontract_vendor {
	padding: 4px 30px !important;
}
.input-subcontracted-value{
	width: 100px !important;
}
</style>
<link rel="stylesheet" href="/css/modules-budget.css">
<link href="/css/fSelect.css" rel="stylesheet">
<link href="/esignature/sign_src/css/jquery.signaturepad.css" rel="stylesheet">
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
	<script src="/js/generated/contact_companies-js.js"></script>
	<script src="/js/generated/contact_company_offices-js.js"></script>
	<script src="/js/generated/contact_company_office_phone_numbers-js.js"></script>
	<script src="/js/generated/contact_phone_numbers-js.js"></script>
	<script src="/js/generated/contacts-js.js"></script>
	<script src="/js/generated/cost_code_divisions-js.js"></script>
	<script src="/js/generated/cost_codes-js.js"></script>
	<script src="/js/generated/gc_budget_line_items-js.js"></script>
	<script src="/js/generated/mobile_phone_numbers-js.js"></script>
	<script src="/js/generated/subcontract_documents-js.js"></script>
	<script src="/js/generated/subcontracts-js.js"></script>

	<script src="/js/modules-contacts-manager-common.js"></script>
	<script src="/js/modules-gc-budget.js"></script>
	<script src="/js/generated/file_manager_files-js.js"></script>
	<script src="/js/modules-purchasing.js"></script>
	<script src="/js/fSelect.js"></script>

	<script src="/esignature/sign_src/js/html2canvas.js"></script>
	<script src="/esignature/sign_src/js/texthtml2canvas.js"></script>
	<script src="/esignature/sign_src/js/numeric-1.2.6.min.js"></script> 
	<script src="/esignature/sign_src/js/bezier.js"></script>
	<script src="/esignature/sign_src/js/json2.min.js"></script>
	<script src="/esignature/sign_src/js/jquery.signaturepad.js"></script> 
	<script src="/app/js/account-management-esign.js"></script>

END_HTML_JAVASCRIPT_BODY;


$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Construction Management - MyFulcrum.com';
$htmlBody = '';


require('template-assignments/main.php');


$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $session->getUserCompanyId());
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;


// Data is loaded earlier in this script (may come from $postBack or the database)
$template->assign('project_id',$project_id);
// $template->assign('projectName',$session->getCurrentlySelectedProjectName());
$template->assign('projectName',$project->project_name);

$template->assign('companyName',$userCompanyName);

// echo $project_id;die();
if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}
if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
	$htmlContent = $template->fetch('project-budget-form-mobile.tpl');
} else {
	
	$htmlContent = renderGcBudgetForm($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName);
}
if($userRole !="global_admin"){
	if (!$userCanViewbudget &&(!$userCanManagebudget) || (!$userCanManagebudget &&(!$userCanViewbudget) ) ) {
	$errorMessage = 'Permission denied.';
	$message->enqueueError($errorMessage, $currentPhpScript);
	$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
	 if ( !empty($htmlMessages) )
  	$htmlContent = "<div>$htmlMessages</div>";
	
	}
}

	$template->assign('htmlContent', $htmlContent);


$template->display('master-web-html5.tpl');
