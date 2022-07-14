<?php
/**
 * About Us.
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



$htmlTitle = 'About Us';
$htmlBody = "";

$headline = 'About Us';
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
}
</style>
END_HTML_CSS;


$template->assign('queryString', $uri->queryString);

require('template-assignments/main.php');

$htmlContent = "
<p>
FULCRUM was developed by a team of industry professionals, including developers, project managers, field superintendents and web developers with over 25 years
experience in the construction industry. After researching and testing project management programs and software currently available, the FULCRUM team realized
there was a need in our industry for a product that could sigificantly streamline the construction management process and that it could and should be entirely
web-based.
</p>
<p>
Enter FULCRUM - Comprehensive and efficient online project management software, unlike anything available in the construction industry today. FULCRUM connects
Developers, General Contractors and Subcontractors so they can communicate with ease and manage budgets, plans and project documentation through all phases of
constuction. Each aspect and function of the site has been thoroughly tested, put to work in the trenches, fine tuned and tailored to best serve the needs of
a construction industry professional at every level.
</p>
<p>
Welcome to FULCRUM. Now let's get to work.
</p>
";

$template->assign('htmlContent', $htmlContent);

$template->display('master-web-unauthenticated-html5.tpl');
exit;
