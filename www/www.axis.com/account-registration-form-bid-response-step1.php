<?php
/**
 * User account registration.
 */
$init['access_level'] = 'anon';
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
require_once('lib/common/UserInvitation.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);


if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS

<style>
#wrapper {
	border: 0px solid #f0f0f0;
	margin-left: auto;
	margin-right: auto;
	width: 800px;
}
</style>
END_HTML_CSS;


if (!isset($htmlJavaScriptHead)) {
	$htmlJavaScriptHead = '';
}
$htmlJavaScriptHead .= <<<END_HTML_JAVASCRIPT_HEAD

<script>
function setFocus()
{
	var obj = document.getElementById("first_element");
	if (obj != null) {
		obj.focus();
		if (obj.select) {
			obj.select();
		}
	}
}
</script>
END_HTML_JAVASCRIPT_HEAD;


// Verify access to this page via the GUID passed in on the $_GET query string
$accessDenied = true;
if (isset($get) && $get->guid) {
	$guid = $get->guid;
	$userInvitation = UserInvitation::verifyInvitation($database, $guid);
	/* @var $userInvitation UserInvitation */

	if ($userInvitation && ($userInvitation instanceof UserInvitation)) {
		$accessDenied = false;
	}
}

if ($accessDenied) {
	$referrerUrl = $uri->referrer;
	if (!isset($referrerUrl) || empty($referrerUrl)) {
		$url = '/login-form.php';
	}

	header("Location: $url");
	exit;
}

$csvGcBudgetLineItemIds = $get->pblids;
$arrGcBudgetLineItemIds = explode(',', $csvGcBudgetLineItemIds);
$bidResponse = $get->answer;

switch ($bidResponse) {
	case '1': // Desires to bid
		$newStatus = 4; // subcontractor_bid_status: "Actively Bidding"
		$bidResponseMessage = 'Thank you for bidding our project.<br><br>In order to view the plans you need to login or register.';
		$showTwoButtons = true;
		$formType = 'bid';

	break;

	case '0': // Not Interested in bidding
		$newStatus = 6; // subcontractor_bid_status: "Declined to Bid"
		$bidResponseMessage = 'Thank you for letting us know that you do not want to bid. We look forward to working with you in the future.';
		$showTwoButtons = false;
		$formType = 'bid';

	break;

	case '2': // Not sure yet, wants to see the plans
		$newStatus = 3; // subcontractor_bid_status: "Bidder Has Plans"
		$bidResponseMessage = 'Thank you for considering to submit a bid. In order to view the plans you need to login or register.';
		$showTwoButtons = true;
		$formType = 'bid';

	break;


	// BUDGET NUMBER REQUEST
	case '10': // WILL NOT PROVIDE BUDGET NUMBER
		$newStatus = 9; // subcontractor_bid_status: "Declined Budget Number Request"
		$bidResponseMessage = 'Thank you for letting us know that you do not submit a budget number. We look forward to working with you in the future.';
		$showTwoButtons = false;
		$formType = 'budget_number';

	break;

	case '11': // WILL PROVIDE BUDGET NUMBER
		$newStatus = 10; // subcontractor_bid_status: "Accepted Budget Number Request"
		$bidResponseMessage = 'Thank you for submitting a budget number.<br><br>In order to view the plans you need to login or register.';
		$showTwoButtons = true;
		$formType = 'budget_number';

	break;

	case '12':  // Not sure yet, wants to see the plans
		$newStatus = 3; // subcontractor_bid_status: "Bidder Has Plans"
		$bidResponseMessage = 'Thank you for considering to submit a budget number. In order to view the plans you need to login or register.';
		$showTwoButtons = true;
		$formType = 'budget_number';

	break;
	default:
	break;
}

$db = DBI::getInstance($database);
/* @var $db DBI_mysqli */

foreach ($arrGcBudgetLineItemIds AS $gc_budget_line_item_id) {
	$gc_budget_line_item_id = Data::parseInt($gc_budget_line_item_id);
	$query =
"
UPDATE `subcontractor_bids`
SET `subcontractor_bid_status_id` = ?
WHERE `gc_budget_line_item_id` = ?
AND `subcontractor_contact_id` = ?
";
	$arrValues = array($newStatus, $gc_budget_line_item_id, $userInvitation->contact_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$db->free_result();
}

// Determine is the contact_companies record for the given contact is linked to a user_company_id other than 1
// i.e. is contact_companies contact_user_company_id <> 1 ?
$contact_id = $userInvitation->contact_id;
$contact = new Contact($database);
$key = array('id' => $contact_id);
$contact->setKey($key);
$contact->load();
$contact->convertDataToProperties();

$contact_company_id = $contact->contact_company_id;
$contactCompany = new ContactCompany($database);
$key = array('id' => $contact_company_id);
$contactCompany->setKey($key);
$contactCompany->load();
$contactCompany->convertDataToProperties();

$contact_user_company_id = $contactCompany->contact_user_company_id;

if ($contact_user_company_id == 1) {
	// The Company Fed Tax Id must be entered as part of the workflow
	$accountRegistrationStep = "account-registration-form-step2.php?guid=$guid";
} else {
	// The contact is already linked to a "Registered User Company"
	$accountRegistrationStep = "account-registration-form-step3.php?guid=$guid&contact_user_company_id=$contact_user_company_id";
}
$template->assign('accountRegistrationStep', $accountRegistrationStep);

// Potentially hide the form...on successful password reset
if (isset($get->loginErrors) && ($get->loginErrors == 1)) {
	$template->assign('loginErrors', 1);
}

// retrieve any postback data from the session store.
$postBack = Egpcs::sessionGet($applicationLabel, 'account-registration-form-bid-response-step1.php', 'post');
/* @var $postBack Egpcs */
// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	// set values using $postBack
	$email = $postBack->auth_name;
	$password = $postBack->auth_pass;
} else {
	// set default from field values as empty strings
	// Initialize form values to blank
	if (isset($contact->email)) {
		$email = $contact->email;
	} else {
		$email = '';
	}
	$password = '';
}

$htmlTitle = 'Account Registration';
$htmlBody = "onload='setFocus();'";

if ($formType == 'bid') {
	$headline = 'You have been invited to bid a project in Fulcrum!';
} elseif ($formType == 'budget_number') {
	$headline = 'You have been invited to provide a budget number.';
}
$template->assign('headline', $headline);

require('template-assignments/main.php');
$template->assign('queryString', $uri->queryString);
$template->assign('loginName', $loginName);

$template->assign('email', $email);
$template->assign('password', $password);

$template->assign('user_invitation_guid', $guid);

$htmlContent = $bidResponseMessage;
if ($showTwoButtons) {
	$htmlContent .= $template->fetch('account-registration-form-step1.tpl');
}
$template->assign('htmlContent', $htmlContent);

$template->display('master-web-unauthenticated-html5.tpl');
exit;
