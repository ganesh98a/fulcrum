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
	require_once('lib/common/UserInvitation.php');
	$userInvitation = UserInvitation::verifyInvitation($database, $guid);
	/* @var $userInvitation UserInvitation */

	if ($userInvitation && ($userInvitation instanceof UserInvitation)) {
		$accessDenied = false;
	}
}

if ($accessDenied) {
	$url = $uri->referrer;
	header("Location: $url");
	exit;
} else {
	// Verify this page is actually needed for the user_invitations record
	$contact_id = $userInvitation->contact_id;
	require_once('lib/common/Contact.php');
	$contact = new Contact($database);
	$key = array('id' => $contact_id);
	$contact->setKey($key);
	$contact->load();
	$contact->convertDataToProperties();

	$contact_company_id = $contact->contact_company_id;
	require_once('lib/common/ContactCompany.php');
	$contactCompany = new ContactCompany($database);
	$key = array('id' => $contact_company_id);
	$contactCompany->setKey($key);
	$contactCompany->load();
	$contactCompany->convertDataToProperties();

	$contact_user_company_id = $contactCompany->contact_user_company_id;

	if ($contact_user_company_id != 1) {
		// The contact is already linked to a "Registered User Company"
		$url = "/account-registration-form-step3.php?guid=$guid";
		header("Location: $url");
		exit;
	}
}

// Reset the form inputs from account-registration-form-step1.php
Egpcs::sessionClearKey($applicationLabel, 'account-registration-form-step1.php', 'post');

// retrieve any postback data from the session store.
$postBack = Egpcs::sessionGet($applicationLabel, 'account-registration-form-step2.php', 'post');
/* @var $postBack Egpcs */

// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	// set values using $postBack
	$ein = $postBack->ein;
} else {
	// set default from field values as empty strings
	// Initialize form values to blank
	$ein = '';
}


$htmlTitle = 'Account Registration';
$htmlBody = "onload='setFocus();'";

$headline = 'Register Your Fulcrum Account';
$template->assign('headline', $headline);

require('template-assignments/main.php');

$template->assign('queryString', $uri->queryString);
//$template->assign('htmlMessages', $htmlMessages);
$template->assign('loginName', $loginName);

$template->assign('user_invitation_guid', $guid);

$template->assign('ein', $ein);

$htmlContent = $template->fetch('account-registration-form-step2.tpl');
$template->assign('htmlContent', $htmlContent);

//require_once('page-components/axis/footer_smarty.php');

$template->display('master-web-unauthenticated-html5.tpl');
exit;
