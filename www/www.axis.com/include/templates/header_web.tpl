{$htmlDoctype}
<html>
<head>
<title>{$htmlTitle}</title>
<meta charset="utf-8">
{literal}
<script>
</script>
{/literal}
<link rel="stylesheet" href="css/library-user_messages.css">
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/styles2.css">
{$htmlJavaScriptHead}
</head>
<body bgcolor="#FFFFFF" text="#000000" style="margin:0px; padding:0px;" {$htmlBody}>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="620">
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
<td align="left" width="207"><img height="57" src="images/1px.gif" width="207"></td>
<td align="left" width="98%">&nbsp;</td>
<td align="right" background="images/hdr3.gif" nowrap valign="top" width="323"><span style="color:#d0dcf8; font-size: .8em; padding-right:5px;">{$loginMessage}</span></td>
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