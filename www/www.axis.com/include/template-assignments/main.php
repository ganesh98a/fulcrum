<?php
/**
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 */

/**
 * Main template assignments include.
 */

$template = Zend_Registry::get('template');
/* @var $template Template */

// @todo Comment out this logo testing section
// Logo - Testing
// Default
$logo = '/images/logos/white-transparent-background3.gif';//'/images/logos/fulcrum-green-icon-silver-text.gif';
$application = Zend_Registry::get('application');
if (isset($application->get)) {
	$get = $application->get;
	if (isset($get->logo) && !empty($get->logo)) {
		$logoOption = $get->logo;
		$arrLogoOptions = array(
			1 => 'fulcrum-blue-icon-silver-text.gif',
			2 => 'fulcrum-blue-icon-silver-text-v2.gif',
			3 => 'fulcrum-green-icon-green-text.gif',
			4 => 'fulcrum-green-icon-green-text-v2.gif',
			5 => 'fulcrum-green-icon-silver-text.gif',
			6 => 'fulcrum-green-icon-silver-text-v2.gif',
		);
		switch ($logoOption) {
			case 1:
				$logo = $arrLogoOptions[1];
				$logo = "/images/logos/$logo";
				break;
			case 2:
				$logo = $arrLogoOptions[2];
				$logo = "/images/logos/$logo";
				break;
			case 3:
				$logo = $arrLogoOptions[3];
				$logo = "/images/logos/$logo";
				break;
			case 4:
				$logo = $arrLogoOptions[4];
				$logo = "/images/logos/$logo";
				break;
			case 5:
				$logo = $arrLogoOptions[5];
				$logo = "/images/logos/$logo";
				break;
			case 6:
				$logo = $arrLogoOptions[6];
				$logo = "/images/logos/$logo";
				break;
		}
	}
}
$template->assign('logo', $logo);

/* @var $session Session */
if(isset($_GET['pID']) && $_GET['pID']!=''){
	$project_id = $currentlySelectedProjectId = base64_decode($_GET['pID']);
}else{
	$project_id = $currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
}
$user_company_id = $session->getUserCompanyId();
// $currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
$project = Project::findById($database, $currentlySelectedProjectId);
$projectName = $project->project_name;
// $projectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedUserCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$currentlySelectedUserCompanyName = $currentlySelectedUserCompany->user_company_name;
$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
$logged_user_id= $session->getUserId(); 
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$primary_contact_id = $session->getPrimaryContactId();
$primary_contact_name = $session->getLoginName();

/*
if (!isset($projectName)) {
	$project_id = $session->getCurrentlySelectedProjectId();
	if ($project_id == AXIS_NON_EXISTENT_PROJECT_ID) {
		$projectName = "";
	}
}
*/
$template->assign('projectName', $projectName);
$template->assign('user_company_id', $user_company_id);
$template->assign('currentlySelectedProjectId', $currentlySelectedProjectId);
$template->assign('currentlySelectedUserCompanyName', $currentlySelectedUserCompanyName);
$template->assign('currentlySelectedProjectUserCompanyId', $currentlySelectedProjectUserCompanyId);
$template->assign('currentlySelectedProjectName', $projectName);
$template->assign('currentlyActiveContactId', $currentlyActiveContactId);
$template->assign('logged_user_id', $logged_user_id);
$template->assign('primary_contact_id', $primary_contact_id);
$template->assign('primary_contact_name', $primary_contact_name);
// Toggle Debug section
$debugMode = (string) $session->getDebugMode();
$template->assign('debugMode', $debugMode);

if ($debugMode) {
	// set window.debugMode=true in the JavaScript
	if (isset($htmlJavaScriptBody)) {
		$htmlJavaScriptBody .= "\n\t<script>window.debugMode=true;</script>";
	} else {
		$htmlJavaScriptBody = "\n\t<script>window.debugMode=true;</script>";
	}
}

// Toggle CSS Debug Mode section
$cssDebugMode = (string) $session->getCssDebugMode();
$template->assign('cssDebugMode', $cssDebugMode);

if ($cssDebugMode) {
	// set window.cssDebugMode=true in the JavaScript
	if (isset($htmlJavaScriptBody)) {
		$htmlJavaScriptBody .= "\n\t<script>window.cssDebugMode=true;</script>";
	} else {
		$htmlJavaScriptBody = "\n\t<script>window.cssDebugMode=true;</script>";
	}
}

// Toggle JavaScript Debug Mode section
$javaScriptDebugMode = (string) $session->getJavaScriptDebugMode();
$template->assign('javaScriptDebugMode', $javaScriptDebugMode);

if ($javaScriptDebugMode) {
	// set window.javaScriptDebugMode=true in the JavaScript
	if (isset($htmlJavaScriptBody)) {
		$htmlJavaScriptBody .= "\n\t<script>window.javaScriptDebugMode=true;</script>";
	} else {
		$htmlJavaScriptBody = "\n\t<script>window.javaScriptDebugMode=true;</script>";
	}
}

// Toggle Show JS Exceptions section
$showJSExceptions = (string) $session->getShowJSExceptions();
$template->assign('showJSExceptions', $showJSExceptions);

if ($showJSExceptions) {
	// set window.showJSExceptions=true in the JavaScript
	if (isset($htmlJavaScriptBody)) {
		$htmlJavaScriptBody .= "\n\t<script>window.showJSExceptions=true;</script>";
	} else {
		$htmlJavaScriptBody = "\n\t<script>window.showJSExceptions=true;</script>";
	}
}

// Toggle Ajax URL Debug section
$ajaxUrlDebugMode = (string) $session->getAjaxUrlDebugMode();
$template->assign('ajaxUrlDebugMode', $ajaxUrlDebugMode);

if ($ajaxUrlDebugMode) {
	// set window.debugMode=true in the JavaScript
	if (isset($htmlJavaScriptBody)) {
		$htmlJavaScriptBody .= "\n\t<script>window.ajaxUrlDebugMode=true;</script>";
	} else {
		$htmlJavaScriptBody = "\n\t<script>window.ajaxUrlDebugMode=true;</script>";
	}
}

// Toggle Console Logging section
$consoleLoggingMode = (string) $session->getConsoleLoggingMode();
$template->assign('consoleLoggingMode', $consoleLoggingMode);

if ($consoleLoggingMode) {
	// set window.consoleLoggingMode=true in the JavaScript
	if (isset($htmlJavaScriptBody)) {
		$htmlJavaScriptBody .= "\n\t<script>window.consoleLoggingMode=true;</script>";
	} else {
		$htmlJavaScriptBody = "\n\t<script>window.consoleLoggingMode=true;</script>";
	}
}

$permissions = Zend_Registry::get('permissions');
// $currentlyRequestedUrl = '/' . $uri->currentPhpScript;
$currentlyRequestedUrl = $uri->path;
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

	if ($debugMode) {
		$debugModeLabel = 'Off';
	} else {
		$debugModeLabel = 'On';
	}
	$template->assign('debugModeLabel', $debugModeLabel);

	if ($cssDebugMode) {
		$cssDebugModeLabel = 'Off';
	} else {
		$cssDebugModeLabel = 'On';
	}
	$template->assign('cssDebugModeLabel', $cssDebugModeLabel);

	if ($javaScriptDebugMode) {
		$javaScriptDebugModeLabel = 'Off';
	} else {
		$javaScriptDebugModeLabel = 'On';
	}
	$template->assign('javaScriptDebugModeLabel', $javaScriptDebugModeLabel);

	if ($showJSExceptions) {
		$showJSExceptionsLabel = 'Off';
	} else {
		$showJSExceptionsLabel = 'On';
	}
	$template->assign('showJSExceptionsLabel', $showJSExceptionsLabel);

	if ($ajaxUrlDebugMode) {
		$ajaxUrlDebugModeLabel = 'Off';
	} else {
		$ajaxUrlDebugModeLabel = 'On';
	}
	$template->assign('ajaxUrlDebugModeLabel', $ajaxUrlDebugModeLabel);

	if (isset($consoleLoggingMode) && $consoleLoggingMode) {
		$consoleLoggingModeLabel = 'Off';
		$consoleWindow = '<span class="linkSeparator">|</span>
			<a href="javascript:Console.toggle();">Console</a>
			<div id="containerConsoleWindow" class="hidden">
				<div id="titleConsoleWindow" ondblclick="Console.clear();">Console
					<a href="javascript:Console.toggle();">x</a>
				</div>
				<div id="bodyConsoleWindow">
					<ul id="ulConsoleWindow"></ul>
				</div>
				<div id="footerConsoleWindow">
					<input type="text" onkeydown="if (event.keyCode == 13) Console.logPrompt();">
				</div>
			</div>';
	} else {
		$consoleLoggingModeLabel = 'On';
		$consoleWindow = '';
	}
	$template->assign('consoleWindow', $consoleWindow, true);
	$template->assign('consoleLoggingModeLabel', $consoleLoggingModeLabel);


	// IE7/IE8 does not populate the HTTP REFERER header
	$encodedRequestedUrl = urlencode($uri->requestedUrl);
	$encodedCurrentPhpScript = urlencode($uri->currentPhpScript);
	$referrerUrl = '?referrerUrl=' . $encodedRequestedUrl . '&amp;phpScript=' . $encodedCurrentPhpScript;
	$template->assign('referrerUrl', $referrerUrl);
} else {
	$consoleWindow = '';
	$template->assign('consoleWindow', $consoleWindow, true);
}


// Display logged in message
$loginName = Session::getInstance()->getLoginName();
if (isset($loginName) && !empty($loginName)) {
	$loginImage = '<a tabindex="10001" href="/logout.php'.$uri->queryString.'">Logout</a>';
	$loginMessage = $loginName;
	//$loginImage = '<a tabindex="10001" href="/logout.php'.$uri->queryString.'" onmouseover="imgOn(\'logout\')" onmouseout="imgOff(\'logout\')"><img name="logout" border="0" src="images/logout_off.gif" width="57" height="72"></a>';
	//$loginMessage = 'You are logged in as <a href="mailto:'.$loginName.'">'.$loginName.'</a>';
	//$loginMessage = 'You are logged in as '.$loginName;
} else {
	//$loginImage = '<a tabindex="10001" href="/login-form.php'.$uri->queryString.'" onmouseover="imgOn(\'login\')" onmouseout="imgOff(\'login\')"><img name="login" border="0" src="images/login_off.gif" width="57" height="72"></a>';
	//$loginMessage = 'You are not logged in.';
	$loginImage = '<a tabindex="10001" href="/login-form.php'.$uri->queryString.'">Login</a>';
	$loginMessage = 'Not Logged In';
}
$template->assign('loginImage', $loginImage, true);
$template->assign('loginMessage', $loginMessage, true);


/**
 * Standard HTML Widgets
 */
$queryString = $uri->queryString;
if (!isset($queryString)) {
	$queryString = '';
}
$template->queryString = $queryString;

if (!isset($htmlDoctype) || empty($htmlDoctype)) {
	$htmlDoctype = '<!DOCTYPE html>';
}
$template->htmlDoctype = $htmlDoctype;

if (!isset($htmlLang) || empty($htmlLang)) {
	$htmlLang = 'lang="en"';
}
$template->htmlLang = $htmlLang;

/**
 * @todo Meta Tags and charset customization.
 */
/*
if (!isset($htmlCharset) || empty($htmlCharset)) {
	$htmlCharset = 'utf-8';
}
$template->htmlCharset = $htmlCharset;

if (!isset($htmlMeta) || empty($htmlMeta)) {
	$htmlMeta = '';
}
$template->htmlMeta = $htmlMeta;
*/

if (!isset($htmlTitle) || empty($htmlTitle)) {
	$htmlTitle = 'MyFulcrum.com';
}
$template->htmlTitle = $htmlTitle;

if (!isset($htmlCss) || empty($htmlCss)) {
	$htmlCss = null;
}
$template->htmlCss = $htmlCss;

if (!isset($htmlJavaScriptHead) || empty($htmlJavaScriptHead)) {
	$htmlJavaScriptHead = null;
}
$template->htmlJavaScriptHead = $htmlJavaScriptHead;

if (!isset($htmlHead) || empty($htmlHead)) {
	$htmlHead = null;
}
$template->htmlHead = $htmlHead;

if (isset($htmlBody) && !empty($htmlBody)) {
	$htmlBody = trim($htmlBody);
	$htmlBody = " $htmlBody";
} else {
	$htmlBody = '';
}
$template->htmlBodyElement = $htmlBody;

if (!isset($htmlMessages) || empty($htmlMessages)) {
	$htmlMessages = null;
}
$template->htmlMessages = $htmlMessages;

//if (!isset($htmlContent) || empty($htmlContent)) {
//	$htmlContent = '';
//}
//$template->htmlContent = $htmlContent;

if (!isset($htmlJavaScriptBody) || empty($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = null;
}
$template->htmlJavaScriptBody = $htmlJavaScriptBody;

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

// Web Analytics (Google Analytics for now)
if ($operationalMode == 'production') {
	//require_once('page-components/analytics.php');
}
if ($uri->domain == 'www.myfulcrum.com') {
	require_once('page-components/analytics.php');
}

if (!isset($htmlAnalyticsHead) || empty($htmlAnalyticsHead)) {
	$htmlAnalyticsHead = null;
}

require_once('page-components/googleAnalytics.php');

if (!isset($googleAnalystical) || empty($googleAnalystical)) {
	$googleAnalystical = null;
}else{
	$htmlAnalyticsHead .= $googleAnalystical;
}

require_once('page-components/InspectletTracking.php');

if (!isset($inspecletTracking) || empty($inspecletTracking)) {
	$inspecletTracking = null;
}else{
	$htmlAnalyticsHead .= $inspecletTracking;
}

$template->htmlAnalyticsHead = $htmlAnalyticsHead;

if (!isset($htmlAnalyticsBody) || empty($htmlAnalyticsBody)) {
	$htmlAnalyticsBody = null;
}
$template->htmlAnalyticsBody = $htmlAnalyticsBody;

/**
 * @todo Should this be conditional based on $init['display'] = true; ???
 */
$template->assignStandardHtmlWidgets();

if (isset($template)) {
	$loadMenuFlag = $template->getLoadMenuFlag();
} else {
	$loadMenuFlag = false;
}

if ($loadMenuFlag && isset($actualUserRole) && !empty($actualUserRole)) {
	if(isset($innerStructure) && ($innerStructure))
	{
		require('../../navigation-projects-list.php');
	}else
	{
		require('./navigation-projects-list.php');
	// require('page-components/axis/navigation-left-vertical-menu.php');
	}
}
/**
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */