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
require_once('lib/common/init.php');
if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS

END_HTML_CSS;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Privacy Policy';
$template->assign('htmlTitle',$htmlTitle);

$template->display('master-privacy-policies.tpl');
exit;
?>
