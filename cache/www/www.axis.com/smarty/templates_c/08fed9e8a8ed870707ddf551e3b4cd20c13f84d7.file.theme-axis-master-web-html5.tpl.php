<?php /* Smarty version Smarty-3.0.8, created on 2017-06-19 19:58:29
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/theme-axis-master-web-html5.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18014819155947df8dbb23e5-77274470%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08fed9e8a8ed870707ddf551e3b4cd20c13f84d7' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/theme-axis-master-web-html5.tpl',
      1 => 1455006188,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18014819155947df8dbb23e5-77274470',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/var/www/myfulcrum/engine/include/smarty-3.0.8/plugins/modifier.escape.php';
if (!is_callable('smarty_block_php')) include '/var/www/myfulcrum/engine/include/smarty-3.0.8/plugins/block.php.php';
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

	<div id="wrapper" class="debugBorder">
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<?php if ((isset($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value)&&(($_smarty_tpl->getVariable('actualUserRole')->value=='global_admin')||($_smarty_tpl->getVariable('actualUserRole')->value=='admin')||($_smarty_tpl->getVariable('actualUserRole')->value=='user'))){?>
			<tr>
				<td align="left">
					<div class="spacerBottom">
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td class="bgGray">
<?php if ((isset($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value)&&($_smarty_tpl->getVariable('actualUserRole')->value=='global_admin')){?>
									<?php $_template = new Smarty_Internal_Template("form-user-impersonation.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php }?>
								</td>
								<td align="right" class="bgGray">
<?php if (isset($_smarty_tpl->getVariable('debugMode',null,true,false)->value)&&$_smarty_tpl->getVariable('debugMode')->value){?>
									<span id="dStartAjax"></span>
									<span id="dStopAjax"></span>
<?php }?>
									<div class="authLinks debugBorder">
										<a tabindex="51" href="/account.php<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('queryString')->value);?>
">Account</a>
										<span class="linkSeparator">|</span>
										<a tabindex="52" href="/help.php">Support</a>
										<span class="linkSeparator">|</span>
										<?php echo $_smarty_tpl->getVariable('loginMessage')->value;?>

										<span class="linkSeparator">|</span>
										<?php echo $_smarty_tpl->getVariable('loginImage')->value;?>

										<?php echo $_smarty_tpl->getVariable('consoleWindow')->value;?>

									</div>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
<?php }?>

			<tr>
				<td align="left">
					<table id="contentArea" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>

<?php if (isset($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value)){?>
							<td id="contentAreaLeft">
								<table align="left" border="0" cellpadding="0" cellspacing="0" width="220">
									<tr>
										<td id="logo"><a href="/account.php"><img alt="" src="<?php echo $_smarty_tpl->getVariable('logo')->value;?>
" width="180" height="45"></a></td>
									</tr>
									<tr>
										<td>
											<div id="sidebar">
<?php if (isset($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value)){?>
												<?php $_template = new Smarty_Internal_Template("navigation-left-vertical-projects.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

												<?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

												//$navigationLeftVerticalProjectsList = $template->fetch('navigation-left-vertical-projects.tpl');
												//echo $navigationLeftVerticalProjectsList;
												//$template->assign("navigationLeftVerticalProjectsList", $navigationLeftVerticalProjectsList);

												// Left Navigation Menu is a php script
												$config = Zend_Registry::get('config');
												$baseDirectory = $config->system->base_directory;

												$leftNavigationFilePath = $baseDirectory.'www/www.axis.com/include/page-components/axis/theme-axis-navigation-left-vertical-menu.php';
												include "$leftNavigationFilePath";
												<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


<?php }?>
											</div>
										</td>
									</tr>
								</table>
							</td>
<?php }?>
							<td id="contentAreaRight" align="left">
								<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td align="left">

											<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td>
<?php if (isset($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('actualUserRole',null,true,false)->value)){?>
														<div id="softwareModuleHeadline"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('projectName')->value,'htmlall');?>
: <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('softwareModuleFunctionLabel')->value);?>
</div>
<?php }?>
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
										<?php echo $_smarty_tpl->getVariable('loginMessage')->value;?>

										<span class="linkSeparator">|</span>
										<?php echo $_smarty_tpl->getVariable('loginImage')->value;?>

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

<?php if ((isset($_smarty_tpl->getVariable('htmlJavaScriptBody',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlJavaScriptBody',null,true,false)->value))){?>
	<?php echo $_smarty_tpl->getVariable('htmlJavaScriptBody')->value;?>

<?php }?>

<?php if ((isset($_smarty_tpl->getVariable('htmlAnalyticsBody',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlAnalyticsBody',null,true,false)->value))){?>
	<?php echo $_smarty_tpl->getVariable('htmlAnalyticsBody')->value;?>

<?php }?>

</body>
</html>
