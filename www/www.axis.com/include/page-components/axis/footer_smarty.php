<?php
/**
 * footer include.
 *
 *
 *
 */

$currentYear = date("Y");
$template->assign('currentYear', $currentYear, true);

if (!isset($htmlJavaScriptBody) || empty($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$template->assign('htmlJavaScriptBody', $htmlJavaScriptBody, true);

//if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
//	$template->display('footer_mobile.tpl');
//} else {
//	$template->display('footer_web.tpl');
//}
