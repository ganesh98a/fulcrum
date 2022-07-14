<?php /* Smarty version Smarty-3.0.8, created on 2017-06-12 13:32:59
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/theme-axis-master-web-unauthenticated-html5.tpl" */ ?>
<?php /*%%SmartyHeaderCode:639232834593e4ab3c2f3b4-69664166%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2568f08dd6a4b9d81f9d54442ac24c6dd9da759d' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/theme-axis-master-web-unauthenticated-html5.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '639232834593e4ab3c2f3b4-69664166',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/var/www/myfulcrum/engine/include/smarty-3.0.8/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_date_format')) include '/var/www/myfulcrum/engine/include/smarty-3.0.8/plugins/modifier.date_format.php';
?>

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

	<?php if ((isset($_smarty_tpl->getVariable('htmlMeta',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlMeta',null,true,false)->value))){?>
		<?php echo preg_replace('!\s+!u', ' ',$_smarty_tpl->getVariable('htmlMeta')->value);?>

	<?php }?>

	<?php if ((isset($_smarty_tpl->getVariable('htmlTitle',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlTitle',null,true,false)->value))){?>
		<title><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('htmlTitle')->value);?>
</title>
	<?php }else{ ?>
		<title></title>
	<?php }?>

	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/library-user_messages.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/humanity/jquery-ui.css">

	<?php if ((isset($_smarty_tpl->getVariable('htmlCss',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlCss',null,true,false)->value))){?>
		<?php echo $_smarty_tpl->getVariable('htmlCss')->value;?>

	<?php }?>

	<?php if ((isset($_smarty_tpl->getVariable('htmlJavaScriptHead',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlJavaScriptHead',null,true,false)->value))){?>
		<?php echo $_smarty_tpl->getVariable('htmlJavaScriptHead')->value;?>

	<?php }?>

	<?php if ((isset($_smarty_tpl->getVariable('htmlAnalyticsHead',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlAnalyticsHead',null,true,false)->value))){?>
		<?php echo $_smarty_tpl->getVariable('htmlAnalyticsHead')->value;?>

	<?php }?>

	<?php if ((isset($_smarty_tpl->getVariable('htmlHead',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlHead',null,true,false)->value))){?>
		<?php echo $_smarty_tpl->getVariable('htmlHead')->value;?>

	<?php }?>
</head>

<body<?php echo $_smarty_tpl->getVariable('htmlBodyElement')->value;?>
>

<div id="divAjaxLoading">Loading . . . <img alt="Loading..." src="/images/ajax-loader.gif"></div>

<div id="wrapper2" class="debugBorder">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">

<tr>
<td id="header" align="right">
<img src="/images/logos/axis-green-white-background.gif">
</td>
</tr>

<tr>
<td height="35">
</td>
</tr>

<tr>
<td align="left">
	<table id="contentArea" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>

	<td style="width: 25px;">
	<img id="verticalGradient" height="250" src="/images/gradients/green-single-column-boxes.gif" width="25">
	</td>

	<td align="left" id="contentAreaRight2">
		<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">

		<?php if ((isset($_smarty_tpl->getVariable('headline',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('headline',null,true,false)->value))){?>
		<tr>
		<td id="headline" height="45"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('headline')->value);?>
</td>
		</tr>
		<?php }?>

		<tr>
		<td align="left">

			<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			<td>

				<div id="messageDiv" class="userMessage"></div>
				<?php echo $_smarty_tpl->getVariable('htmlContent')->value;?>

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
			<a href="/">&copy;<?php echo smarty_modifier_date_format(time(),'%Y');?>
 MyFulcrum.com&trade;</a>
			<a href="/login-form.php">Login</a>
			<a href="/account.php">Account</a>
		</div>
	</td>
	</tr>
	</table>
</td>
</tr>

</table>
</div>

<?php if ((isset($_smarty_tpl->getVariable('htmlJavaScriptBody',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlJavaScriptBody',null,true,false)->value))){?>
	<?php echo $_smarty_tpl->getVariable('htmlJavaScriptBody')->value;?>

<?php }?>

<?php if ((isset($_smarty_tpl->getVariable('htmlAnalyticsBody',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlAnalyticsBody',null,true,false)->value))){?>
	<?php echo $_smarty_tpl->getVariable('htmlAnalyticsBody')->value;?>

<?php }?>

</body>
</html>
