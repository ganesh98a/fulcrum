<?php
if (isset($uri) && $uri instanceof Uri) {
	$uri = Application::getInstance()->getUri();
	$url = $uri->current;
} elseif (isset($notFoundUrl)) {
	$url = $notFoundUrl;
} else {
	$url = '';
}
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL <?php echo $url; ?> was not found on this server.</p>
</body></html>
