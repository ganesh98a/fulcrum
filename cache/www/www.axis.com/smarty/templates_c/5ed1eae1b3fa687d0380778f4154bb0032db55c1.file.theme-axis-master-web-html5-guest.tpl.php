<?php /* Smarty version Smarty-3.0.8, created on 2021-11-25 13:58:32
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/theme-axis-master-web-html5-guest.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30931619f88782af523-92193157%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ed1eae1b3fa687d0380778f4154bb0032db55c1' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/theme-axis-master-web-html5-guest.tpl',
      1 => 1637843612,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30931619f88782af523-92193157',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\modifier.escape.php';
if (!is_callable('smarty_modifier_date_format')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\modifier.date_format.php';
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
	<?php echo $_smarty_tpl->getVariable('htmlMeta')->value;?>

	<?php }?>

	<?php if ((isset($_smarty_tpl->getVariable('htmlTitle',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlTitle',null,true,false)->value))){?>
	<title><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('htmlTitle')->value);?>
</title>
	<?php }else{ ?>
	<title></title>
	<?php }?>

	<?php if (isset($_smarty_tpl->getVariable('cssDebugMode',null,true,false)->value)&&$_smarty_tpl->getVariable('cssDebugMode')->value){?>
	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/bootstrap-dropdown.css">
	<link rel="stylesheet" href="/css/bootstrap-popover.css">
	<link rel="stylesheet" href="/css/entypo.css">
	<link rel="stylesheet" href="/css/library-icons.css">
	<link rel="stylesheet" href="/css/library-user_messages.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/jquery-ui-1.10.0.custom.css">
	<link rel="stylesheet" href="/css/fileuploader.css">
	<link rel="stylesheet" href="/css/modules-permissions.css">
	<link rel="stylesheet" href="/css/jquery.dataTables.css">
	<?php }else{ ?>
	<link rel="stylesheet" href="/css/styles.css.php">
	<?php }?>

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

<?php if ((isset($_smarty_tpl->getVariable('currentlySelectedProjectId',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('currentlySelectedProjectId',null,true,false)->value))){?>
<input id="currentlySelectedProjectId" name="currentlySelectedProjectId" type="hidden" value="<?php echo $_smarty_tpl->getVariable('currentlySelectedProjectId')->value;?>
">
<?php }?>
<div id="modalDialogContainer" class="hidden"></div>
<div id="divAjaxLoading">Loading . . . <img alt="Loading..." src="/images/ajax-loader.gif"></div>
<div id="progressbarContainer">
	<div id="progressbarMessage"></div>
	<div id="progressbar"></div>
</div>


<?php if ((isset($_smarty_tpl->getVariable('loadershow',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('loadershow',null,true,false)->value))){?>
<div class="pod_loader_img" style="display: block;">
	<div class="loader"></div>
</div>

<?php }?>
<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('token')->value;?>
" id="token" name="token">
<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('pt_token')->value;?>
" id="pt_token" name="pt_token">
<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('subid')->value;?>
" id="subid" name="subid">
<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('conid')->value;?>
" id="conid" name="conid">
<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('fid')->value;?>
" id="fid" name="fid">

<div id="wrapper" class="debugBorder">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td align="left">
				<div class="spacerBottom">
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="bgGray" id="logo" style="padding: 5px 0;width:200px;">
								<img alt="" src="<?php echo $_smarty_tpl->getVariable('logo')->value;?>
" width="150" height="35">
							</td>
							<td align="left" class="bgGray">
								<span>
								<h2 style="margin:5px 0;"><div style="float: left;"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('projectName')->value,'htmlall');?>
: <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('softwareModuleFunctionLabel')->value);?>
</div></h2>
									<div align="right" style="margin-top: 10px;"><?php echo $_smarty_tpl->getVariable('cur_date')->value;?>
</div>
								</span>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td align="left">
				<table id="contentArea" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td style="padding-left:15px;" id="contentAreaRight" align="left">
							<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td align="left">
										<?php echo $_smarty_tpl->getVariable('htmlContent')->value;?>

									</td>
									<td align="left" style="<?php echo $_smarty_tpl->getVariable('secondstyle')->value;?>
">

										<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td>
													<div style="min-height:480px !important">
														<table id="tblFileModule" border="0" width="100%">
															<tr valign="top">
																<td id="tdFileTreeMenu" style="width:350px;">
																	<div id="fileTreeMenu" rel="/"></div>
																</td>
																<td>
																	<div id="infoContainer">
																		<div id="fileDetails" style="display:none;"></div>
																		<div id="filePreview" style="width:100%;"></div>
																	</div>
																</td>
															</tr>
														</table>
													</div>
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

		<?php if ((isset($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value)&&(($_smarty_tpl->getVariable('actualUserRole')->value=='global_admin')||($_smarty_tpl->getVariable('actualUserRole')->value=='admin')||($_smarty_tpl->getVariable('actualUserRole')->value=='user'))){?>
		<tr>
			<td align="left">
				<div class="spacerTop">
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td bgcolor="#E8E8E8">
							</td>
							<td align="right" class="bgGray">
								<div class="authLinks debugBorder">

								</div>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<?php }?>

		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td nowrap>
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

	<?php if (isset($_smarty_tpl->getVariable('javaScriptDebugMode',null,true,false)->value)&&$_smarty_tpl->getVariable('javaScriptDebugMode')->value){?>
	<script src="/js/jquery-1.11.2.js"></script>
	<script src="/js/jquery-ui-1.11.4.js"></script>
	<script src="/js/jquery.dataTables.js"></script>
	<script src="/js/jquery.dataTables.natural.js"></script>
	<script src="/js/jquery.maskedinput.js"></script>

	<script src="/js/ddaccordion.js">
		/***********************************************
		* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
		* This notice must stay intact for legal use
		***********************************************/
	</script>

	<script src="/js/library-main.js"></script>

	<script src="/js/permissions.js"></script>
	<script src="/js/admin-projects-team-management.js"></script>

	<!--[if lt IE 8]>
	<script src="/js/json2.js"></script>
<![endif]-->

<script src="/js/accounting.js"></script>
<script src="/js/library-data_types.js"></script>
<script src="/js/library-tabular_data.js"></script>

<script src="/js/library-file-uploads.js"></script>
<script src="/js/fileuploader.js"></script>

<script src="/js/bootstrap-dropdown.js"></script>
<script src="/js/bootstrap-popover.js"></script>
<script src="/js/bootstrap-tooltip.js"></script>

<script src="/js/ajaxq.js"></script>
<script src="/js/history.js"></script>

<script src="/js/library-code-generator.js"></script>
<?php }else{ ?>
<script src="/js/scripts.js.php"></script>
<?php }?>

<script type="text/javascript">
	$(document).ready(function(){
		$('.pod_loader_img').hide();
	});
</script>

<?php if ((isset($_smarty_tpl->getVariable('htmlJavaScriptBody',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlJavaScriptBody',null,true,false)->value))){?>
<?php echo $_smarty_tpl->getVariable('htmlJavaScriptBody')->value;?>

<?php }?>

<?php if ((isset($_smarty_tpl->getVariable('htmlAnalyticsBody',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlAnalyticsBody',null,true,false)->value))){?>
<?php echo $_smarty_tpl->getVariable('htmlAnalyticsBody')->value;?>

<?php }?>

</body>
</html>
