<?php
if (isset($_SERVER['QUERY_STRING'])) {
	$queryString = $_SERVER['QUERY_STRING'];
	$url = 'login-form-submit.php?'.$queryString;
} else {
	$url = '/error/404.php?'.$queryString;
}

$header = "Location: $url";
header($header, true, 301);
exit;
