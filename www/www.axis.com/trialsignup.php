<?php

/**
 * trial sign up  Module.
 */
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
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

require_once('trailsignup-function.php');

$message = Message::getInstance();
/* @var $message Message */

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS

END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/signup.js"></script>
END_HTML_JAVASCRIPT_BODY;

require_once('page-components/googleAnalytics.php');

if (!isset($googleAnalystical) || empty($googleAnalystical)) {
	$googleAnalystical = null;
}else{
	$htmlJavaScriptBody .= $googleAnalystical;
}

require_once('page-components/InspectletTracking.php');

if (!isset($inspecletTracking) || empty($inspecletTracking)) {
	$inspecletTracking = null;
}else{
	$htmlJavaScriptBody .= $inspecletTracking;
}

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'SIGN UP FOR FREE- MyFulcrum.com';
$htmlBody = '';

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}
require('template-assignments/guest_main.php');

/*Validate the requeset method*/
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$params = $_GET;
}else{
	$params = $_POST;	
}



$softwareModuleFunctionLabel = "";

$template->assign('softwareModuleFunctionLabel', $softwareModuleFunctionLabel);

$cur_date=date("m/d/Y | h:i:s");
$template->assign('cur_date', $cur_date);

// Generate a signup form
$signform = renderTrailSignForm();

$template->assign('signform', $signform);
$htmlContent = $template->fetch('trialsignup.tpl');

$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5-signup.tpl');
exit;

