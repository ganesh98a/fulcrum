{$htmlDoctype}
<html>
<head>
<title>{$htmlTitle}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
{literal}
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
{/literal}
<link rel="stylesheet" href="css/library-user_messages.css">
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/styles2.css">
{$htmlJavaScriptHead}
</head>
<body bgcolor="#FFFFFF" text="#000000" style="margin:0px; padding:0px;" {$htmlBody}>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
<tr>
<td>
<table background="images/menu_bg.gif" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="left" valign="middle" width="85%">
<a href="/"><img style="padding: 12px 0 0 10px;" src="/images/logos/axis.png" border="0" /></a>
</td>
<td valign="middle" align="center" width="5%" height="76" nowrap style="vertical-align:middle;"><a tabindex="0" href="account.php{$queryString}" onmouseover="imgOn('acct')" onmouseout="imgOff('acct')"><img name="acct" border="0" src="images/account_off.gif" width="57" height="72"></a>&nbsp;</td>
<td valign="middle" align="center" width="5%" height="76" nowrap style="vertical-align:middle;"><a tabindex="0" href="/help.php" onmouseover="imgOn('help')" onmouseout="imgOff('help')" target="_parent"><img name="help" border="0" src="images/help_off.gif" width="57" height="72"></a>&nbsp;</td>
<td valign="middle" align="right" width="5%" height="76" nowrap style="vertical-align:middle;">{$loginImage}&nbsp;</td>
</tr>
</table>
<table background="images/hdr2.gif" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="right" height="30" nowrap><div style="color:#d0dcf8; font-size: 1.3em; padding-right:5px; padding-top: 5px;">{$loginMessage}</div></td>
</tr>
</table>
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