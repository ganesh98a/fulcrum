{*strip*}

{if (isset($htmlDoctype) && !empty($htmlDoctype)) }
	{$htmlDoctype}
{else}
	<!DOCTYPE html>
{/if}

{if (isset($htmlLang) && !empty($htmlLang)) }
	<html {$htmlLang}>
{else}
	<html>
{/if}

<head>
	<title>{$htmlTitle}</title>
	<meta charset="utf-8">

	{if (isset($htmlMeta) && !empty($htmlMeta)) }
		{$htmlMeta|strip}
	{/if}

	<link rel="stylesheet" href="/css/library-user_messages.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/humanity/jquery-ui.css">
	{* <link rel="stylesheet" href="/css/styles2.css"> *}

	{*<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>*}
	{*<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>*}
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	{*<script src="/js/jquery.class.animation.js"></script>*}

	{* The following accordion script needs to be moved somewhere else *}
	<script src="/js/ddaccordion.js">

		/***********************************************
		* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
		* This notice must stay intact for legal use
		***********************************************/

	</script>


	{if (isset($htmlCss) && !empty($htmlCss)) }
		{$htmlCss}
	{/if}

	<script src="/js/library-main.js"></script>
	<script src="/js/permissions.js"></script>
	<script src="/js/admin-projects-team-management.js"></script>
	{if (isset($htmlJavaScriptHead) && !empty($htmlJavaScriptHead)) }
		{$htmlJavaScriptHead}
	{else}
		{*<script src="/js/library-main.js"></script>*}
	{/if}

	{if (isset($htmlAnalyticsHead) && !empty($htmlAnalyticsHead)) }
		{$htmlAnalyticsHead}
	{/if}

	{if (isset($htmlHead) && !empty($htmlHead)) }
		{$htmlHead}
	{/if}
</head>

<body bgcolor="#FFFFFF" text="#000000" style="margin:0px; padding:0px;" {$htmlBody}>

	<div id="uploadProgressWindow" class="uploadResult" style="display:none;">
		<h3>FILE UPLOAD PROGRESS: <input type="button" value="Close File Progress Window" onclick="document.getElementById('uploadProgressWindow').style.display='none';"></h3>
		<ul id="UL-FileList" class="qq-upload-list"></ul>
		<span id="uploadProgressErrorMessage"></span>
	</div>

	<div id="masterHeader">
		<div id="boxTest">
		{if (isset($actualUserRole)) && !empty($actualUserRole) && ($actualUserRole == 'global_admin') }
		{include file="form-user-impersonation.tpl"}
		{/if}
		</div>
		<div id="boxTest2"></div>
		<div id="masterHeaderLinks">
			<a tabindex="0" href="/account.php{$queryString}">Home</a>
			<span class="linkSeparator">|</span>
			<a tabindex="1" href="/help.php">Support</a>
			<span class="linkSeparator">|</span>
			{$loginMessage}
			<span class="linkSeparator">|</span>
			{$loginImage}
		</div>
		<hr>
	</div>

	<div id="messageDiv" class="userMessage"></div>
	<div id="divAjaxLoading">Loading . . . <img src="/images/ajax-loader.gif"></div>

	<div id="sidebar">
		{php}
		// Left Navigation Menu is a php script
		$config = Zend_Registry::get('config');
		$baseDirectory = $config->system->base_directory;
		//$leftNavigationFilePath = $baseDirectory.'www/www.axis.com/current.php';
		//include "$leftNavigationFilePath";
		//include "./current.php";

		$leftNavigationFilePath = $baseDirectory.'www/www.axis.com/navigation-projects-list.php';
		include "$leftNavigationFilePath";

		$leftNavigationFilePath = $baseDirectory.'www/www.axis.com/navigation-left-menu.php';
		include "$leftNavigationFilePath";

		{/php}
	</div>

	<ul id="breadcrumb">
		<li><a id="bc1" href="#"></a></li>
		<li><a id="bcProject" href="#"></a></li>
		<li><a id="bc2" href="#"></a></li>
		<li><a id="bc3" href="#"></a></li>
	</ul>

	<div id="content">
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>
					{*
						<table background="/images/menu_bg.gif" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td align="left" valign="middle" width="85%">
									<a href="/"><img style="padding: 12px 0 0 10px;" src="/images/logos/axis.png" border="0"></a>
								</td>
								<td valign="middle" align="center" width="5%" height="76" nowrap style="vertical-align:middle;"><a tabindex="0" href="/account.php{$queryString}" onmouseover="imgOn('acct')" onmouseout="imgOff('acct')"><img name="acct" border="0" src="/images/account_off.gif" width="57" height="72"></a>&nbsp;</td>
								<td valign="middle" align="center" width="5%" height="76" nowrap style="vertical-align:middle;"><a tabindex="0" href="/help.php" onmouseover="imgOn('help')" onmouseout="imgOff('help')" target="_parent"><img name="help" border="0" src="/images/help_off.gif" width="57" height="72"></a>&nbsp;</td>
								<td valign="middle" align="right" width="5%" height="76" nowrap style="vertical-align:middle;">{$loginImage}&nbsp;</td>
							</tr>
						</table>
					*}

					{*
						<table background="/images/hdr2.gif" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td align="left" width="207"><img height="57" src="/images/1px.gif" width="207"></td>
								<td align="left" width="98%">&nbsp;</td>
								<td align="right" background="/images/hdr3.gif" nowrap valign="top" width="323"><span style="color:#d0dcf8; font-size: .8em; padding-right:5px;">{$loginMessage}</span></td>
							</tr>
						</table>
					*}

					{if $showDebugLocationInfo }
						<table border="0" cellpadding="2" cellspacing="0" style="border: dashed 2px #ccc;" width="100%">
							<tr>
								<td width="100%">
									<div style="color:#999; font-size: .8em; padding-left:5px;">
										[Debug] - IP Based Information
										<br>
										IP Address: {$ipAdress}
										<br>
										Latitude: {$latitude}
										<br>
										Longitude: {$longitude}
										<br>
										City: {$city}
										<br>
										State: {$state}
										<br>
										Zip: {$zip}
										<br>
										Country: {$country}
									</div>
								</td>
							</tr>
						</table>
					{/if}

					{*$htmlContent|strip*}
					{$htmlContent}

					{** Get Rid of these when we put a footer back in **}
					<br><br><br><br><br><br><br><br>

					{*
						<br>
						<table border="0" width="100%" cellspacing="0" cellpadding="0" height="1">
							<tr>
								<td style="background-image: url('images/footerSubBCK.gif')" colSpan="2"><img alt="" src="/images/footerSub.gif" width="769" height="28"></td>
							</tr>
							<tr>
								<td><img height="1" alt="" src="/images/1px.gif" width="23"></td>
								<td><img height="1" alt="" src="/images/1px.gif" width="769"></td>
							</tr>
							<tr>
								<td colspan="2"><div class="sshareFooter">&nbsp;&nbsp;<a class="sshareFooter" tabindex="0" href="/">Home</a> | <a class="sshareFooter" tabindex="0" href="/login-form.php">Login</a> | <a class="sshareFooter" tabindex="0" href="/account.php">Account</a> | <a class="sshareFooter" tabindex="0" href="/smartphone-apps.php">SmartPhone Apps</a> | <a class="sshareFooter" tabindex="0" href="/account-registration-form.php">Sign Up</a> | <a class="sshareFooter" target="_parent" tabindex="0" href="/help.php">Help</a> | <a class="sshareFooter" target="_parent" tabindex="0" href="/terms-and-conditions.php">Terms &amp; Conditions</a></div></td>
							</tr>
							<tr>
								<td colspan="2" nowrap>
									<div id="footer">
										<div id="footerLinks">
											<a href="/login-form.php">Login</a>
											<a href="/about-us.php">About Us</a>
											<a href="/contact-us.php">Contact Us</a>
											<a href="/help.php">Help</a>
											<a href="/sitemap.php">Site Map</a>
										</div>
										&copy;{$smarty.now|date_format:'%Y' nocache} MyFulcrum.com&trade;
										<a id="privacy" href="/privacy.php">Privacy</a>
										<a id="terms-and-conditions" href="/terms-and-conditions.php">Terms And Conditions</a>
									</div>
								</td>
							</tr>
						</table>
					*}
				</td>
			</tr>
		</table>

		{if (isset($htmlJavaScriptBody) && !empty($htmlJavaScriptBody)) }
			{$htmlJavaScriptBody}
		{/if}

		{if (isset($htmlAnalyticsBody) && !empty($htmlAnalyticsBody)) }
			{$htmlAnalyticsBody}
		{/if}
	</div>

	{*php}
		echo '<div style="clear:both"></div><pre>';
		echo print_r($_SESSION);
		echo '</pre>';
	{/php*}
</body>
</html>
{*/strip*}