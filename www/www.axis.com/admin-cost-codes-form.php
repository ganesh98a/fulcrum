<?php
/**
 * Project Management.
 *
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = false;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = false;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['post_maxlength'] = 100000;
$init['post_required'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');

require_once('./admin-cost-codes-functions.php');

$session = Zend_Registry::get('session');
/* @var $session Session */

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
<script src="/js/generated/cost_code_divisions-js.js"></script>
	<script src="/js/generated/cost_codes-js.js"></script>

	<script src="/js/admin-cost-codes.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Project Management - MyFulcrum.com';
$htmlBody = '';


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

$renderCostCodeDivisionForm = renderCostCodeDivisionForm($database, $user_company_id);
$renderCostCodesForm = renderCostCodeForm($database, $user_company_id, 5);
$htmlContent = $renderCostCodeDivisionForm . '<br><br><br>' . $renderCostCodesForm;
$template->assign('htmlContent', $htmlContent);

$template->display('master-web-html5.tpl');
exit;
