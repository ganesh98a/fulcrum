<?php
/**
 * Contact Us.
 */
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = false;
$init['https_auth'] = false;
$init['https_admin'] = false;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');


$htmlTitle = 'Support';
$htmlBody = "";

$headline = 'Support';
$template->assign('headline', $headline);

//retrieve any html messages
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

p {
	color: #8B8E90;
	margin-top: 0px;
	vertical-align:middle;
}
</style>

END_HTML_CSS;


$template->assign('queryString', $uri->queryString);

require('template-assignments/main.php');

$htmlContent = '
<p>If you have any queries, please contact us:</p>
<ul style="padding: 0;list-style: none;">
<li>By email: info@myfulcrum.com</li>
</ul> 
';

$template->assign('htmlContent', $htmlContent);
$template->display('master-web-unauthenticated-html5.tpl');
exit;
