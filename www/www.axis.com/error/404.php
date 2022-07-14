<?php
/**
 * 404 Engine.
 *
 * Generate a 404 page or redirect.
 * Log bad request to the database 404 table.
 * Redirect well-known URL mapping (301, 302, etc.).
 */
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = false;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
require_once('lib/common/init.php');

header('HTTP/1.0 404 Not Found');
ob_start();
// Apache 2.2's generic HTML 2.0 404 message.
include('page-components/apache-2.2-404.php');
$contents = ob_get_clean();
ob_end_clean();
echo $contents;
flush();

require_once('lib/common/Log404.php');
Log404::log404('log', $uri);

//$headersFlag = headers_sent($file, $line);
//$arrHeaders = headers_list();
//echo '<pre>'.print_r($arrHeaders, true).'</pre>';
exit;


/**
 * Comment out the following lines to log 404 requests or to redirect
 * well-known broken links (if any exist).
 *
 * Uncomment the following lines to simulate a generic Apache 404 message.
 * Apache 2.2's generic HTML 2.0 404 message.
 */
//header('HTTP/1.0 404 Not Found');
//ob_start();
//include('page-components/example.com/apache-2.2-404.php');
//$contents = ob_get_clean();
//ob_end_clean();
//echo $contents;
//exit;

/**
 * Redirection.
 */
$requestedUri = $uri->current;

/**
 * Page redirection.
 *
 * Dynamically redirect well known broken links.
 */
$arrPageRedirect = array (
	'/default.htm'	=> '/',
	'/index.htm'	=> '/',
	'/about_us/'	=> '/axis/about/',
	'/contact_us/'	=> '/axis/contact/'
);
if (isset($arrPageRedirect[$requestedUri])) {
	$location = $arrPageRedirect[$requestedUri];
	header('Location: '.$location, true, 301);
	exit;
}

/**
 * Directory redirection.
 *
 * Dynamically redirect well known broken links.
 */
$arrDirRedirect = array	(
	'/about_us'	=> '/axis/about/',
	'/contact_us'	=> '/axis/contact/'
);
foreach ($arrDirRedirect as $k => $v) {
	if (is_int(strpos($requestedUri, $k))) {
		header('Location: '.$v, true, 301);
		exit;
	}
}

/**
 * HTTP/1.0 404 Not Found Header
 */
//if (isset($notFound) && $notFound) {
	header('HTTP/1.0 404 Not Found');
//}

/**
 * HTML Output.
 */
//include the standard sitemap
include('page-components/sitemap.php');

$html_title = '404 Error - The Page You Have Requested Is Not Available';
$meta_description = '404 Error Page';
$meta_keywords = '404 Error Page';
$header = '<h1>404 Error - The Page You Have Requested Is Not Available</h1>
<h4 class="normal">Our site map is listed below to assist you.</h4>';

//include the standard master template
include('templates/master.php');


/**
 * 404 logging.
 *
 * Log attempted URL to database.
 * Flush output buffer and then write to log.
 */
while(ob_get_level()) {
	ob_end_flush();
}
flush();
// Test to be sure output buffer is flushed properly before logging occurs.
//$level = ob_get_level();
//$length = ob_get_length();
//sleep(5);
require_once('lib/common/Log_404.php');
//$referrer = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null);
Log_404::logUri($uri->current, $uri->referrer);
exit;
