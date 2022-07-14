<?php

// @todo Fix cdn to have a scheme url version available instead of: //cdn1.axisitonline.com/
$uri = Zend_Registry::get('uri');
if ($uri->sslFlag) {
	$cdn = 'https:' . $uri->cdn;
} else {
	$cdn = 'http:' . $uri->cdn;
}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Fulcrum Email Message</title>

<link rel="stylesheet" href="<?php echo $cdn; ?>css/normalize.css">
<link rel="stylesheet" href="<?php echo $cdn; ?>css/main.css">
<link rel="stylesheet" href="<?php echo $cdn; ?>css/styles.css">

<style>
a {
	vertical-align: baseline;
}

h2 {
	margin: 0;
	padding: 0;
}

img {
	border: 0;
	border: none;
}

img.placeHolderImg {
	vertical-align: baseline;
}

table {
	border-collapse: separate !important;
	border-spacing: 0;
}

td {
	margin: 0;
	padding: 0;
}

.va_top {
	vertical-align: top;
}

.va_bottom {
	vertical-align: bottom;
}

.va_top_container {
	font-size: 8px;
	height: 9px;
	line-height: 8px;
	padding: 0;

	width: 10px;
}

.va_middle_container {
	font-size: 8px;
	height: 9px;
	line-height: 8px;
	padding: 0;
}

.va_bottom_container {
	font-size: 8px;
	height: 9px;
	line-height: 8px;
	padding: 0;

	width: 10px;
}

.subcontentHeadline {
	color: #666699;
	font-size: 15px;
	font-weight: bold;
	margin-top: 5px;
	margin-bottom: 0;
	padding: 2px 10px;
}

.subcontentHeadline a {
	color: #666699 !important;
	font-size: 15px !important;
	font-weight: bold !important;
	text-decoration: none !important;
}

.subcontent {
	border: 0px solid #ccc;
	padding: 10px 15px;
}

input[type=button], input[type=submit], input[type=reset], input[type=file] {
	/* Non-css3 browsers */
	background: #95b42e;

	/* IE */
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#95b42e', endColorstr='#afd137') !important;

	/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#95b42e), to(#afd137));

	/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #95b42e, #afd137);

	/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #95b42e, #afd137);

	/* IE 10 */
	background: -ms-linear-gradient(top, #95b42e, #afd137);

	/* Opera 11.10+ */
	background: -o-linear-gradient(top, #95b42e, #afd137);

	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px; /* future proofing */
	-khtml-border-radius: 5px;

	color: white;
	cursor: hand;
	cursor: pointer;
	border: 1px solid #b8d47a;
	padding: 8px 10px;
	width: 300px;
	text-align: center;
}
</style>
</head>
<body style="padding: 0 10px;">
<div style="background-color: #fff; padding: 20px 0;">
<?php
/*
<img style="border: 0; border: none;" width="186" height="31" border="0" src="file://C:/dev/build/advent-sites/branches/development/www/www.axis.com/images/logos/axis-green.gif" alt="">
<img style="border: 0; border: none;" width="186" height="31" border="0" src="<?php echo $cdn; ?>images/logos/axis-green.gif" alt="Fulcrum Construction Management Software">
*/
?>
<table style="width:800px; border-collapse:separate!important; border-spacing:0">

<tbody>
<tr>

<?php if($mail_image!='')
{
	?>	
<td style="width:55%;">
 <a href="<?php echo $uri->https . 'login-form.php'; ?>"><img style="border: 0;float: left;"  border="0" src="<?php echo $cdn.$mail_image; ?>" ></a>
</a>
</td>
 <?php } ?>
<td style="width:45%;" align='right'>
<a href="<?php echo $uri->https . 'login-form.php'; ?>"><img style="border: 0; border: none;float: right;" width="200" height="50" border="0" src="<?php echo $cdn; ?>images/logos/fulcrum-blue-icon-silver-text.gif" alt="Fulcrum Construction Management Software"></a>
</td>
</tr>
</tbody>
</table>
<div style="margin: 5px 0 0;float: left;"></div>
<div style="margin: 5px 0 0; text-align: right;width: 800px"><small style="color: #666666;font-size: 13px;">Construction Management Software</small></div>

<?php
	//echo $htmlAlertMessageBody;
	$subcontent = $htmlAlertMessageBody;
	include('templates/square-corners-bid-invitations.php');
?>
</div>
<div style="clear:both;">&nbsp;</div>
</body>
</html>
