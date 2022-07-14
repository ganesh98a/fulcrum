<?php
/**
 * Purpose:
 * to read html template content file
 * to for PhantomJS PDF generation
 */
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = true;

//$tempDir = 'C:/dev/build/advent-sites/branches/development/www/www.axis.com/downloads/temp/';
require_once('lib/common/init.php');
$config = Zend_Registry::get('config');

$tempDir = $config->system->file_manager_base_path.'temp/';

$tempFile = $tempDir . $get->templateFileName;

ob_start();

require($tempFile);
$htmlOutput = ob_get_clean();
echo $htmlOutput;
exit;