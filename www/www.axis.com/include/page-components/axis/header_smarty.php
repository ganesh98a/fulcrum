<?php
/**
 * Header include.
 *
 *
 *
 */
$user_company_id = $session->getUserCompanyId();
$template->assign('user_company_id', $user_company_id);

$projectName = $session->getCurrentlySelectedProjectName();
$template->assign('projectName', $projectName);

$permissions = Zend_Registry::get('permissions');
$currentlyRequestedUrl = '/' . $uri->currentPhpScript;
if (isset($permissions) && ($permissions instanceof Permissions)) {
	$softwareModuleFunctionLabel = $permissions->deriveSoftwareModuleFunctionLabelFromUrl($currentlyRequestedUrl);
} else {
	$softwareModuleFunctionLabel = '';
}
$template->assign('softwareModuleFunctionLabel', $softwareModuleFunctionLabel);

/**
 * USER IMPERSONATION SECTION
 */
$actualUserRole = $session->getActualUserRole();
$template->assign('actualUserRole', $actualUserRole);
$userRole = $session->getUserRole();
$template->assign('userRole', $userRole);
if (isset($actualUserRole) && ($actualUserRole == 'global_admin')) {
	// Check if a GET variable exists for user_company_id or use AJAX???
	$dropdownImpersonateUserCompanyListOnChange = "updateChildDropDown(this.form.id, this.id, 'impersonated_user_id', 'impersonate-users-ajax.php', 'loadUserIdHtmlSelectOptionsByUserCompanyId');";
	$template->assign('dropdownImpersonateUserCompanyListOnChange', $dropdownImpersonateUserCompanyListOnChange);

	// These should be set to ""
	$selectedImpersonatedUserCompany = $session->getUserCompanyId();
	$selectedImpersonatedUser = $session->getUserId();
	// Global Admin drop down - Allows "user impersonation"
	// Load a list of User Companies
	$arrTmp = UserCompany::loadUserCompaniesList($database);
	//$arrImpersonatedUserCompanyOptions = array('' => 'Select A Company');
	$arrImpersonatedUserCompanyOptions = $arrTmp['options_list'];
	$template->assign('arrImpersonatedUserCompanyOptions', $arrImpersonatedUserCompanyOptions);
	$template->assign('selectedImpersonatedUserCompany', $selectedImpersonatedUserCompany);

	// Load a list of Users
	$arrTmp = User::loadUsersList($database, $selectedImpersonatedUserCompany);
	//$arrImpersonatedUserOptions = array('' => 'Select A User');
	$arrImpersonatedUserOptions = $arrTmp['options_list'];
	$template->assign('arrImpersonatedUserOptions', $arrImpersonatedUserOptions);
	$template->assign('selectedImpersonatedUser', $selectedImpersonatedUser);
}


// Display logged in message
$loginName = Session::getInstance()->getLoginName();
if (isset($loginName) && !empty($loginName)) {
	$loginImage = '<a tabindex="0" href="/logout.php'.$uri->queryString.'">Logout</a>';
	$loginMessage = $loginName;
	//$loginImage = '<a tabindex="0" href="/logout.php'.$uri->queryString.'" onmouseover="imgOn(\'logout\')" onmouseout="imgOff(\'logout\')"><img name="logout" border="0" src="images/logout_off.gif" width="57" height="72"></a>';
	////$loginMessage = 'You are logged in as <a href="mailto:'.$loginName.'">'.$loginName.'</a>';
	//$loginMessage = 'You are logged in as '.$loginName;
} else {
	//$loginImage = '<a tabindex="0" href="/login-form.php'.$uri->queryString.'" onmouseover="imgOn(\'login\')" onmouseout="imgOff(\'login\')"><img name="login" border="0" src="images/login_off.gif" width="57" height="72"></a>';
	//$loginMessage = 'You are not logged in.';
	$loginImage = '<a tabindex="0" href="/login-form.php'.$uri->queryString.'">Login</a>';
	$loginMessage = 'Not Logged In';
}

if (!isset($htmlDoctype) || empty($htmlDoctype)) {
	$htmlDoctype = '<!DOCTYPE html>';
}
$template->assign('htmlDoctype', $htmlDoctype, true);

if (!isset($htmlLang) || empty($htmlLang)) {
	$htmlLang = 'lang="en"';
}
$template->assign('htmlLang', $htmlLang, true);

if (!isset($htmlTitle) || empty($htmlTitle)) {
	$htmlTitle = 'Axis.com';
}
$template->assign('htmlTitle', $htmlTitle, true);

if (!isset($htmlCss) || empty($htmlCss)) {
	$htmlCss = '';
}
$template->assign('htmlCss', $htmlCss, true);

if (!isset($htmlJavaScriptHead) || empty($htmlJavaScriptHead)) {
	$htmlJavaScriptHead = '';
}
$template->assign('htmlJavaScriptHead', $htmlJavaScriptHead, true);

if (!isset($htmlBody) || empty($htmlBody)) {
	$htmlBody = '';
}
$template->assign('htmlBody', $htmlBody, true);

$template->assign('loginImage', $loginImage, true);

$template->assign('loginMessage', $loginMessage, true);

$template->assign('queryString', $uri->queryString, true);


$config = Zend_Registry::get('config');
$operationalMode = $config->system->operational_mode;
if ($operationalMode == 'debug' && 0) {
	$showDebugLocationInfo = true;
	// IP Based Geo Information
	$ipAdress = $geo->ipAddress;
	$latitude = $geo->latitude;
	$longitude = $geo->longitude;
	$city = $geo->city;
	$state = $geo->region;
	$zip = $geo->postalCode;
	$country = $geo->country;

	$template->assign('ipAdress', $ipAdress, true);
	$template->assign('latitude', $latitude, true);
	$template->assign('longitude', $longitude, true);
	$template->assign('city', $city, true);
	$template->assign('state', $state, true);
	$template->assign('zip', $zip, true);
	$template->assign('country', $country, true);
} else {
	$showDebugLocationInfo = false;
}
$template->assign('showDebugLocationInfo', $showDebugLocationInfo, true);

//if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
//	$template->display('header_mobile.tpl');
//} else {
//	$template->display('header_web.tpl');
//}
