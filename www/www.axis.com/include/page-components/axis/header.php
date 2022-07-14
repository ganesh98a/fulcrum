<?php
/**
 * Header include.
 */

// Display logged in message
$loginName = Session::getInstance()->getLoginName();
if (isset($loginName) && !empty($loginName)) {
	$loginImage = '<a tabindex="0" href="/logout.php'.$uri->queryString.'" onmouseover="imgOn(\'logout\')" onmouseout="imgOff(\'logout\')"><img name="logout" border="0" src="images/logout_off.gif" width="57" height="72"></a>';
	//$loginMessage = 'You are logged in as <a href="mailto:'.$loginName.'">'.$loginName.'</a>';
	$loginMessage = 'You are logged in as '.$loginName;
} else {
	$loginImage = '<a tabindex="0" href="/login-form.php'.$uri->queryString.'" onmouseover="imgOn(\'login\')" onmouseout="imgOff(\'login\')"><img name="login" border="0" src="images/login_off.gif" width="57" height="72"></a>';
	$loginMessage = 'You are not logged in.';
}

if (!isset($htmlDoctype)) {
	$htmlDoctype = '<!DOCTYPE html>';
}
echo $htmlDoctype."\n";
?>
<html>
<head>
<title><?php echo ((isset($htmlTitle) && !empty($htmlTitle)) ? $htmlTitle : 'Axis.com'); ?></title>
<meta charset="utf-8">
<script>
	var acctOn = new Image();
	acctOn.src = 'images/account_on.gif';

	var acctOff = new Image();
	acctOff.src = 'images/account_off.gif';

	var helpOn = new Image();
	helpOn.src = 'images/help_on.gif';

	var helpOff = new Image();
	helpOff.src = 'images/help_off.gif';

	var loginOn = new Image();
	loginOn.src = 'images/login_on.gif';

	var loginOff = new Image();
	loginOff.src = 'images/login_off.gif';

	var logoutOn = new Image();
	logoutOn.src = 'images/logout_on.gif';

	var logoutOff = new Image();
	logoutOff.src = 'images/logout_off.gif';

	function imgOn(imgName)
	{
		if (document.images) {
			document.images[imgName].src = eval(imgName+'On.src');
		}
	}

	function imgOff(imgName)
	{
		if (document.images) {
			document.images[imgName].src = eval(imgName+'Off.src');
		}
	}

	function setFocus()
	{
		var obj = document.getElementById("first_element");
		if (obj != null) {
			obj.focus();
			if (obj.select) {
				obj.select();
			}
		}
	}
</script>
<link rel="stylesheet" href="/css/library-user_messages.css">
<link rel="stylesheet" href="/css/styles.css">
<link rel="stylesheet" href="/css/styles2.css">
<?php echo ((isset($htmlJavaScriptHead) && !empty($htmlJavaScriptHead)) ? $htmlJavaScriptHead : ''); ?>
</head>
<body bgcolor="#FFFFFF" text="#000000" style="margin: 0px; padding: 0px;" <?php echo ((isset($htmlBody) && !empty($htmlBody)) ? $htmlBody : ''); ?>>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="620">
	<tr>
	<td>
		<table background="images/menu_bg.gif" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="textAlignLeft verticalAlignMiddle" width="85%">
			<a href="/"><img style="padding: 12px 0 0 10px;" src="/images/logos/axis.png" border="0"></a>
			</td>
			<td class="textAlignCenter verticalAlignMiddle" width="5%" height="76" nowrap><a tabindex="0" href="/account.php<?php echo $uri->queryString; ?>" onmouseover="imgOn('acct')" onmouseout="imgOff('acct')"><img name="acct" border="0" src="images/account_off.gif" width="57" height="72"></a>&nbsp;</td>
			<td class="textAlignCenter verticalAlignMiddle" width="5%" height="76" nowrap><a tabindex="0" href="/help.php" onmouseover="imgOn('help')" onmouseout="imgOff('help')" target="_parent"><img name="help" border="0" src="images/help_off.gif" width="57" height="72"></a>&nbsp;</td>
			<td class="textAlignRight verticalAlignMiddle" width="5%" height="76" nowrap><?php echo $loginImage; ?>&nbsp;</td>
		</tr>
		</table>
		<table background="images/hdr2.gif" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="textAlignLeft" width="207"><img height="57" src="images/1px.gif" width="207"></td>
				<td class="textAlignLeft" width="98%">&nbsp;</td>
				<td class="textAlignRight verticalAlignTop" background="images/hdr3.gif" nowrap width="323"><span style="color:#d0dcf8; font-size: .8em; padding-right:5px;"><?php echo $loginMessage; ?></span></td>
			</tr>
		</table>
		<?php
		$config = Zend_Registry::get('config');
		$operationalMode = $config->system->operational_mode;
		if ($operationalMode == 'debug' && 0) {
			// IP Based Geo Information
			$ipAdress = $geo->ipAddress;
			$latitude = $geo->latitude;
			$longitude = $geo->longitude;
			$city = $geo->city;
			$state = $geo->region;
			$zip = $geo->postalCode;
			$country = $geo->country;
		?>
		<table border="0" cellpadding="2" cellspacing="0" style="border: dashed 2px #ccc;" width="100%">
			<tr>
				<td width="100%">
				<div style="color:#999; font-size: .8em; padding-left:5px;">
					[Debug] - IP Based Information
					<br>
					IP Address: <?php echo $ipAdress; ?>
					<br>
					Latitude: <?php echo $latitude; ?>
					<br>
					Longitude: <?php echo $longitude; ?>
					<br>
					City: <?php echo $city; ?>
					<br>
					State: <?php echo $state; ?>
					<br>
					Zip: <?php echo $zip; ?>
					<br>
					Country: <?php echo $country; ?>
				</div>
				</td>
			</tr>
		</table>
		<?php
		}
		?>
