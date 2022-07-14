{*strip*}

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Description here...">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="imagetoolbar" content="false">
	<link rel="dns-prefetch" href="//ajax.googleapis.com">

	{if (isset($htmlMeta) && !empty($htmlMeta)) }
		{$htmlMeta|strip}
	{/if}

	{if (isset($htmlTitle) && !empty($htmlTitle)) }
		<title>{$htmlTitle|escape}</title>
	{else}
		<title></title>
	{/if}

	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/library-user_messages.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/humanity/jquery-ui.css">

	{if (isset($htmlCss) && !empty($htmlCss)) }
		{$htmlCss}
	{/if}

	{*
	<script src="/js/modernizr-2.6.2.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script>window.jQuery || document.write('<script src="/js/jquery-1.7.1.js"><\/script>')</script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
	<script>window.jQuery.ui || document.write('<script src="/js/jquery-ui-1.8.16.js"><\/script>')</script>
	*}
	{*<script src="/js/jquery.class.animation.js"></script>*}
	{*
	<script src="/js/ddaccordion.js">
		/***********************************************
		* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
		* This notice must stay intact for legal use
		***********************************************/
	</script>
	<script src="/js/library-main.js"></script>
	<script src="/js/permissions.js"></script>
	*}

	{if (isset($htmlJavaScriptHead) && !empty($htmlJavaScriptHead)) }
		{$htmlJavaScriptHead}
	{/if}

	{if (isset($htmlAnalyticsHead) && !empty($htmlAnalyticsHead)) }
		{$htmlAnalyticsHead}
	{/if}

	{if (isset($htmlHead) && !empty($htmlHead)) }
		{$htmlHead}
	{/if}
</head>

<body{$htmlBodyElement}>
{*
<div id="topnav" style="position:absolute; top:0; left:0; width:100%; line-height:35px; background-color:#f0f0f0;">
	<div style="width:1200px; margin:auto;">
		<div style="float:left;">Fulcrum</div>
		<div class="link"><a id="terms-and-conditions" href="/terms-and-conditions.php">Terms And Conditions</a></div>
		<div class="link"><a id="privacy" href="/privacy.php">Privacy</a></div>
		<div class="link"><a href="/sitemap.php">Site Map</a></div>
		<div class="link"><a href="/help.php">Help</a></div>
		<div class="link"><a href="/contact-us.php">Contact Us</a></div>
		<div class="link"><a href="/about-us.php">About Us</a></div>
		<div class="link"><a href="/account.php">Account</a></div>
		<div class="link"><a href="/login-form.php">Login</a></div>
	</div>
</div>
*}
<div id="divAjaxLoading">Loading . . . <img alt="Loading..." src="/images/ajax-loader.gif"></div>

<div id="wrapper2" class="debugBorder">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">

<tr>
<td align="left">
	<table id="contentArea" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>

	<td align="left">
		<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
		<td align="left">

			<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			<td>
				{*
				<ul id="breadcrumb">
					<li><a id="bc1" href="#">A</a></li>
					<li><a id="bcProject" href="#">B</a></li>
					<li><a id="bc2" href="#">C</a></li>
					<li><a id="bc3" href="#">D</a></li>
				</ul>
				*}

				<div id="messageDiv" class="userMessage"></div>

				{*$htmlContent|strip*}
				{$htmlContent}
			</td>
			</tr>
			</table>

		</td>
		</tr>
		</table>

	</td>
	</tr>
	</table>

</td>
</tr>

<tr>
<td>
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
	<td colspan="2" nowrap>
		<div id="footer">
			<a href="/">&copy;{$smarty.now|date_format:'%Y' nocache} MyFulcrum.com&trade;</a>
			<a href="/login-form.php">Login</a>
			<a href="/account.php">Account</a>
			{*<a href="/about-us.php">About Us</a>
			<a href="/contact-us.php">Contact Us</a>
			<a href="/help.php">Help</a>
			<a href="/sitemap.php">Site Map</a>
			<a id="privacy" href="/privacy.php">Privacy</a>
			<a id="terms-and-conditions" href="/terms-and-conditions.php">Terms And Conditions</a>*}
		</div>
	</td>
	</tr>
	</table>
</td>
</tr>

</table>

{*<?php require('page-components/analytics.php'); ?>*}

{*php}
	echo '<div style="clear:both"></div><pre>';
	echo print_r($_SESSION);
	echo '</pre>';
{/php*}
</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
	{*
	<script src="/js/modernizr-2.6.2.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script>window.jQuery || document.write('<script src="/js/jquery-1.7.1.js"><\/script>')</script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
	<script>window.jQuery.ui || document.write('<script src="/js/jquery-ui-1.8.16.js"><\/script>')</script>
	<script src="/js/jquery.class.animation.js"></script>
	<script src="/js/ddaccordion.js">
		/***********************************************
		* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
		* This notice must stay intact for legal use
		***********************************************/
	</script>
	<script src="/js/library-main.js"></script>
	<script src="/js/permissions.js"></script>
	*}

{if (isset($htmlJavaScriptBody) && !empty($htmlJavaScriptBody)) }
	{$htmlJavaScriptBody}
{/if}

{if (isset($htmlAnalyticsBody) && !empty($htmlAnalyticsBody)) }
	{$htmlAnalyticsBody}
{/if}

</body>
</html>
{*/strip*}