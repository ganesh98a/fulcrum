<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = false;
$init['display'] = true;
$init['https'] = false;
$init['https_auth'] = false;
$init['https_admin'] = false;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

require_once('./homepage.php');
exit;