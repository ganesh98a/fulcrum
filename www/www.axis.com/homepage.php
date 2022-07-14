<?php
/**
 * Home page form.
 */
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS

END_HTML_CSS;


require_once('page-components/googleAnalytics.php');

if (!isset($googleAnalystical) || empty($googleAnalystical)) {
	$googleAnalystical = null;
}else{
	$htmlJavaScriptBody = $googleAnalystical;
}

require_once('page-components/InspectletTracking.php');

if (!isset($inspecletTracking) || empty($inspecletTracking)) {
	$inspecletTracking = null;
}else{
	$htmlJavaScriptBody .= $inspecletTracking;
}

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Myfulcrum.com Construction Project Management Software';
$template->assign('htmlTitle',$htmlTitle);
$template->assign('htmlJavaScriptBody',$htmlJavaScriptBody);

$template->display('master-web-home-html5.tpl');
exit;
?>
