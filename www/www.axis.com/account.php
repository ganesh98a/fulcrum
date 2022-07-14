<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * Account management.
 */
try {
/**
 * Software header for:
 * 1) Session
 * 		-Standardization
 * 		-Fixation prevention
 * 		-Hijacking prevention
 * 		-Cross site scripting prevention
 * 2) Data input sanitization
 * 3) SQL injection prevention
 * 4) Standard framework variables and includes
 *
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
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

require_once('lib/common/BidSpread.php');
require_once('lib/common/BidSpreadNote.php');
require_once('lib/common/BidSpreadStatus.php');
require_once('lib/common/FileLocation.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/Log.php');
require_once('lib/common/Mail.php');
require_once('lib/common/MessageGateway/Sms.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/SubcontractorBid.php');
require_once('lib/common/SubcontractorBidStatus.php');
require_once('lib/common/UserDetail.php');
require_once('lib/common/UserImage.php');

// Standard variable values that are placed into $_GLOBAL scope by init.php.
$database;

// Standard objects that are placed into $_GLOBAL scope by init.php.
$ajax;
$auth;
$db;
$cache;
$config;
$cookie;
$geo;
$get;
$post;
$request;
$session;
$template;
$timer;
$uri;

// unset left navigation cookies
/* @var $session Session */
$logOutFlag = $session->getLogOut();
if ($logOutFlag) {
	$pastTime = (time() - 3600);
	setcookie('expandable', false, $pastTime, '/');
	setcookie('expandable2', false, $pastTime, '/');
	setcookie('moduleStyle', false, $pastTime, '/');
	$session->setLogOut(false);
}

// Get the company_id and project_id values
if (isset($get)) {
	$company_id = $get->company_id;
	$project_id = $get->project_id;
} else {
	$company_id = '';
	$project_id = '';
}


require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$forcePasswordChangeFlag = $session->getForgotPassword();
if ($forcePasswordChangeFlag) {
	$message->reset('account.php');
	$message->enqueueInfo('Please update your account password to continue.', 'account-management-password-form.php');
	$message->sessionPut();
	$url = 'account-management-password-form.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
} else {
	$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
}


// Load user account information
//$user_id = $_SESSION['user_id'];
$user_id = $session->getUserId();
$u = new User($database);
$key = array('id' => $user_id);
$u->setKey($key);
$u->load();
$u->convertDataToProperties();
$screen_name = $u->screen_name;
$user_image_id = $u->user_image_id;
if ($user_image_id && ($user_image_id > 0)) {
	$ui = UserImage::findById($database, $user_image_id);
	/* @var $ui UserImage */
	$userImageSrc = $ui->src;
} else {
	// Use map pin placeholder image
	$userImageSrc = '/images/map-icons/blue-dot.png';
}

// Authorize user
//require_once('lib/common/Authorization.php');
$acl = Authorization::getInstance();
/* @var $acl Authorization */
$userRole = $acl->getUserRole();          //userRole ------ admin
//$acl->authorizeUser($u, 'account.php');
//$arrAccessControlList = $acl->getArrAccessControlList();
//$globalAdminSection = $arrAccessControlList['global_admin'];
//$adminSection = $arrAccessControlList['admin'];

$ud = new UserDetail($database);
$key = array('user_id' => $user_id);
$ud->setKey($key);
$ud->load();
$ud->convertDataToProperties();
//print_r($ud);
//exit;

// $u
$securityQuestion = $u->security_question;
$securityAnswer = $u->security_answer;
$phone = $u->mobile_phone_number;
$phoneAreaCode = substr($phone, 0, 3);
$phonePrefix = substr($phone, 3, 3);
$phoneNumber = substr($phone, 6, 4);
$phoneExtension = substr($phone, 10, 5);

// $ud
$first_name = $ud->first_name;
$last_name = $ud->last_name;
$fullName = $first_name.' '.$last_name;
$address_line_1 = $ud->address_line_1;
$address_line_2 = $ud->address_line_2;
$address_line_3 = $ud->address_line_3;
$address_city = $ud->address_city;
$address_state = $ud->address_state;
$address_zip = $ud->address_zip;
$address_country = $ud->address_country;
$personal_title = $ud->title;
$company = $ud->company_name;
$website = $ud->website;


// IP Based Location Information
$ipLatitude = $geo->latitude;
$ipLongitude = $geo->longitude;
$ipCity = $geo->city;
$ipState = $geo->region;
$ipZip = $geo->postalCode;
$ipCountry = $geo->country;
$userLocation = "$ipCity $ipState<br>$ipZip<br>$ipCountry<br>Latitude: $ipLatitude, Longitude: $ipLongitude";

$htmlJavaScriptBody = <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/account.js"></script>
END_HTML_JAVASCRIPT_BODY;

// Load account messages
$userRole = $session->getUserRole();
$projectOwnerAdminFlag = (bool) $permissions->getProjectOwnerAdminFlag();
if ($projectOwnerAdminFlag && (($userRole == 'admin') || ($userRole == 'global_admin'))) {

	// Load UserRegistrationLog
	require_once('lib/common/UserRegistrationLog.php');
	$user_company_id = $session->getUserCompanyId();
	$project_id = $session->getCurrentlySelectedProjectId();

	$project = Project::findById($database, $project_id);
	/* @var $project Project */

	$project->htmlEntityEscapeProperties();
	$escaped_project_name = $project->escaped_project_name;

	//$arrUserRegistrationLogRecords = UserRegistrationLog::loadUserRegistrationLogsByUserCompanyIdAndProjectId($database, $user_company_id, $project_id);
	$arrUserRegistrationLogsByUserCompanyIdAndProjectId = UserRegistrationLog::loadUserRegistrationLogsByUserCompanyIdAndProjectIdExtended($database, $user_company_id, $project_id);
	$userRegistrationLogMessageCount = count($arrUserRegistrationLogsByUserCompanyIdAndProjectId);
		$accountMessages = <<<END_ACCOUNT_MESSAGES

<br>
&nbsp;<b>$userRegistrationLogMessageCount Users Registered for $escaped_project_name</b> <small><a href="javascript:showHideAccountMessages('accountMessagesUserRegistration');">(show/hide)</a></small>
<div id="accountMessagesUserRegistration" style="border: 1px dashed #274981; display: none;">
<table>
	<tr>
		<td>
			<div id="userRegistrationLogMessages" class="messageQueueInfoBlockContainer">
END_ACCOUNT_MESSAGES;

	$first = true;

	foreach ($arrUserRegistrationLogsByUserCompanyIdAndProjectId as $user_registration_log_id => $userRegistrationLog) {
		/* @var $userRegistrationLog UserRegistrationLog */

		$tmpContact = $userRegistrationLog->getContact();
		/* @var $tmpContact Contact */

		$tmpContact->htmlEntityEscapeProperties();
		$contactFullNameHtmlEscaped = $tmpContact->getContactFullNameHtmlEscaped();

		$tmpContactCompany = $tmpContact->getContactCompany();
		/* @var $tmpContactCompany ContactCompany */

		$tmpContactCompany->htmlEntityEscapeProperties();
		$escaped_contact_company_name = $tmpContactCompany->escaped_contact_company_name;

		$accountMessages .= <<<END_ACCOUNT_MESSAGES

			<div id="$user_registration_log_id" class="messageQueueInfo">
				$escaped_contact_company_name - $contactFullNameHtmlEscaped successfully registered for {$escaped_project_name}
				<a href="javascript:hideUserRegistrationLogRecord('$user_registration_log_id');"><small>hide</small></a>
				<a href="javascript:deleteUserRegistrationLogRecord('$user_registration_log_id');"><b>X</b></a>
			</div>
END_ACCOUNT_MESSAGES;

	}

	$contact_id = $u->primary_contact_id;
	$projectExecutive = ProjectToContactToRole::findByProjectIdAndContactIdAndRoleId($database, $project_id, $contact_id, 4);
	if ($projectExecutive) {
		// Load any pending bid spread approvals
		$loadBidSpreadsByBidSpreadApproverGcProjectExecutiveContactIdOptions = new Input();
		$loadBidSpreadsByBidSpreadApproverGcProjectExecutiveContactIdOptions->forceLoadFlag = true;
		$arrBidSpreads = BidSpread::loadBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId($database, $contact_id, $loadBidSpreadsByBidSpreadApproverGcProjectExecutiveContactIdOptions);
		foreach ($arrBidSpreads as $bid_spread_id => $bidSpreadTmp) {
			$bidSpread = BidSpread::findBidSpreadByIdExtended($database, $bid_spread_id);
			/* $bidSpread BidSpread */

			// Bid Spread Cloud Filesystem File
			$unsignedBidSpreadPdfFileManagerFile = $bidSpread->getUnsignedBidSpreadPdfFileManagerFile();
			/* @var $unsignedBidSpreadPdfFileManagerFile FileManagerFile */

			// Bid Spread Cloud Filesystem URL & Filename
			$virtual_file_name = $unsignedBidSpreadPdfFileManagerFile->virtual_file_name;
			//'http://beta.axisitonline.com
			$virtual_file_name_url = $uri->cdn . '_' . $unsignedBidSpreadPdfFileManagerFile->file_manager_file_id;

			//http://beta.axisitonline.com
			$bidSpreadUrl =
				$uri->http . 'modules-purchasing-bid-spread.php'.
					'?gc_budget_line_item_id='.$bidSpread->gc_budget_line_item_id .
					'&openModal=1&active_bid_spread_id='.$bidSpread->id;

			$accountMessages .= <<<END_ACCOUNT_MESSAGES

			<div id="$bid_spread_id" class="messageQueueInfo">
				<b>Spread Pending Approval:</b> <a href="$bidSpreadUrl" target="_blank">$virtual_file_name</a>
				PDF: <a href="$virtual_file_name_url" target="_blank">$virtual_file_name</a>
				<a href="javascript:hideUserRegistrationLogRecord('$user_registration_log_id');"><small>hide</small></a>
				<a href="javascript:deleteUserRegistrationLogRecord('$user_registration_log_id');"><b>X</b></a>
			</div>
END_ACCOUNT_MESSAGES;
		}
	}

	$accountMessages .= <<<END_ACCOUNT_MESSAGES

			</div>
			<input id="userRegistrationLogMessageCount" type="hidden" value="$userRegistrationLogMessageCount">
		</td>
	</tr>
</table>
</div>
END_ACCOUNT_MESSAGES;

	// No other source of account messages at this time...
	// Debug

	if ($userRegistrationLogMessageCount < 1) {
		
	}
} else {
	$accountMessages = '';
}
$template->assign('accountMessages', $accountMessages);

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Construction Management - MyFulcrum.com';
$htmlBody = '';


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}
require('template-assignments/main.php');

$template->assign('company_id', $company_id);
$template->assign('project_id', $project_id);
if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
	$htmlContent = $template->fetch('account-mobile.tpl');
} else {
	$htmlContent = $template->fetch('account-web.tpl');
}
$template->assign('htmlContent', $htmlContent);

$template->display('master-web-html5.tpl');

} catch (Exception $e) {
	require('./error/500.php');
}
exit;
