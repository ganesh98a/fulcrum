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
	{*$htmlMeta|strip*}
	{$htmlMeta}
{/if}

{if (isset($htmlTitle) && !empty($htmlTitle)) }
	<title>{$htmlTitle|escape}</title>
{else}
	<title></title>
{/if}

{if isset($cssDebugMode) && $cssDebugMode }
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
{else}
	<link rel="stylesheet" href="/css/styles.css.php">
{/if}

	{*
	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/library-user_messages.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/jquery-ui-1.10.0.custom.css">
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/humanity/jquery-ui.css">
	*}

{if (isset($htmlCss) && !empty($htmlCss)) }
	{$htmlCss}
{/if}

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
	<script src="/js/admin-projects-team-management.js"></script>
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

{if (isset($currentlySelectedProjectId) && !empty($currentlySelectedProjectId)) }
	<input id="currentlySelectedProjectId" name="currentlySelectedProjectId" type="hidden" value="{$currentlySelectedProjectId}">
{/if}
{if (isset($currentlySelectedProjectName) && !empty($currentlySelectedProjectName)) }
	<input id="currentlySelectedProjectName" name="currentlySelectedProjectName" type="hidden" value="{$currentlySelectedProjectName}">
{/if}
{if (isset($currentlySelectedUserCompanyName) && !empty($currentlySelectedUserCompanyName)) }
	<input id="currentlySelectedUserCompanyName" name="currentlySelectedUserCompanyName" type="hidden" value="{$currentlySelectedUserCompanyName}">
{/if}
{if (isset($user_company_id) && !empty($user_company_id)) }
	<input id="user_company_id" name="user_company_id" type="hidden" value="{$user_company_id}">
{/if}
{if (isset($currentlySelectedProjectUserCompanyId) && !empty($currentlySelectedProjectUserCompanyId)) }
	<input id="currentlySelectedProjectUserCompanyId" name="currentlySelectedProjectUserCompanyId" type="hidden" value="{$currentlySelectedProjectUserCompanyId}">
{/if}
{if (isset($currentlyActiveContactId) && !empty($currentlyActiveContactId)) }
	<input id="currentlyActiveContactId" name="currentlyActiveContactId" type="hidden" value="{$currentlyActiveContactId}">
{/if}
{if (isset($logged_user_id ) && !empty($logged_user_id )) }
	<input id="logged_user_id" name="logged_user_id" type="hidden" value="{$logged_user_id}">
{/if}
{if (isset($primary_contact_id ) && !empty($primary_contact_id )) }
	<input id="primary_contact_id" name="primary_contact_id" type="hidden" value="{$primary_contact_id}">
{/if}
{if (isset($primary_contact_name ) && !empty($primary_contact_name )) }
	<input id="primary_contact_name" name="primary_contact_name" type="hidden" value="{$primary_contact_name}">
{/if}
	<div id="modalDialogContainer" class="hidden"></div>
	<div id="dialog-confirm"></div>

<div id="divAjaxLoading">Loading . . . <img alt="Loading..." src="/images/ajax-loader.gif"></div>
<div id="progressbarContainer">
	<div id="progressbarMessage"></div>
	<div id="progressbar"></div>
</div>
<div id="divContactMail" class="hidden"></div>
{if (isset($loadershow) && !empty($loadershow)) }
	<div class="pod_loader_img" style="display: block;">
		<!-- <div class="loader"></div> -->
		<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
	</div>
{/if}

	<div id="wrapper" class="debugBorder">
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">

{*if (isset($actualUserRole)) && !empty($actualUserRole) && ($actualUserRole == 'global_admin') *}
{if (isset($actualUserRole)) && !empty($actualUserRole) && (($actualUserRole == 'global_admin') || ($actualUserRole == 'admin') || ($actualUserRole == 'user')) }
			<tr>
				<td align="left">
					<div class="spacerBottom">
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td class="bgGray">
{if (isset($actualUserRole)) && !empty($actualUserRole) && ($actualUserRole == 'global_admin') }
									{include file="form-user-impersonation.tpl"}
{/if}
								</td>
								<td align="right" class="bgGray">
{if isset($debugMode) && $debugMode }
									<span id="dStartAjax"></span>
									<span id="dStopAjax"></span>
{/if}
									<div class="authLinks debugBorder">
										<a tabindex="51" href="/account.php{$queryString|escape}">Account</a>
										<span class="linkSeparator">|</span>
										<a tabindex="52" href="/help.php">Support</a>
										<span class="linkSeparator">|</span>
										{$loginMessage}
										<span class="linkSeparator">|</span>
										{$loginImage}
										{$consoleWindow}
									</div>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
{/if}

			<tr>
				<td align="left">
					<table id="contentArea" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>

{if isset($actualUserRole) && !empty($actualUserRole)}
							<td id="contentAreaLeft">
								<table align="left" border="0" cellpadding="0" cellspacing="0" width="220">
									<tr>
										<td id="logo"><a href="/account.php"><img alt="" src="{$logo}" width="180" height="45"></a></td>
									</tr>
									<tr>
										<td>
											<div id="sidebar">
{if isset($actualUserRole) && !empty($actualUserRole)}
												{include file="navigation-left-vertical-projects.tpl"}
												{*$navigationLeftVerticalMenu*}

												{php}
												//$navigationLeftVerticalProjectsList = $template->fetch('navigation-left-vertical-projects.tpl');
												//echo $navigationLeftVerticalProjectsList;
												//$template->assign("navigationLeftVerticalProjectsList", $navigationLeftVerticalProjectsList);

												// Left Navigation Menu is a php script
												$config = Zend_Registry::get('config');
												$baseDirectory = $config->system->base_directory;

												$leftNavigationFilePath = $baseDirectory.'www/www.axis.com/include/page-components/axis/theme-axis-navigation-left-vertical-menu.php';
												include "$leftNavigationFilePath";

												{*
												$leftNavigationFilePath = $baseDirectory.'www/www.axis.com/navigation-projects-list.php';
												include "$leftNavigationFilePath";
												*}

												{*
												$leftNavigationFilePath = $baseDirectory.'www/www.axis.com/navigation-left-menu.php';
												include "$leftNavigationFilePath";
												*}
												{/php}

{/if}
											</div>
										</td>
									</tr>
								</table>
							</td>
{/if}
							<td id="contentAreaRight" align="left">
								<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td align="left">

											<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td>
{if isset($actualUserRole) && !empty($actualUserRole)}
														<div id="softwareModuleHeadline">{$projectName|escape:'htmlall'}: {$softwareModuleFunctionLabel|escape}</div>
														{*
														<ul id="breadcrumb">
															<li><a id="bc1" href="#">A</a></li>
															<li><a id="bcProject" href="#">B</a></li>
															<li><a id="bc2" href="#">C</a></li>
															<li><a id="bc3" href="#">D</a></li>
														</ul>
														*}
{/if}
														<div id="messageDiv" class="userMessage"></div>

														{*$htmlContent|strip*}
														{*$htmlContent|indent:13:"\t"*}
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

{if (isset($actualUserRole)) && !empty($actualUserRole) && (($actualUserRole == 'global_admin') || ($actualUserRole == 'admin') || ($actualUserRole == 'user')) }
			<tr>
				<td align="left">
					<div class="spacerTop">
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td bgcolor="#E8E8E8">
									{*if (isset($actualUserRole)) && !empty($actualUserRole) && ($actualUserRole == 'global_admin') }
									{include file="form-user-impersonation.tpl"}
									{/if*}
								</td>
								<td align="right" class="bgGray">
									<div class="authLinks debugBorder">
										{*
										<!--
										<a tabindex="51" href="/account.php{$queryString|escape}">2Home</a>
										<span class="linkSeparator">|</span>
										<a tabindex="52" href="/help.php">Support</a>
										<span class="linkSeparator">|</span>
										-->
										*}
										{$loginMessage}
										<span class="linkSeparator">|</span>
										{$loginImage}
									</div>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
{/if}

			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td nowrap>
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

	</div>

	{*
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	*}

{if isset($javaScriptDebugMode) && $javaScriptDebugMode }
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
{else}
	<script src="/js/scripts.js.php"></script>
{/if}

	{*
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script src="/js/modernizr-2.6.2.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script>window.jQuery || document.write('<script src="/js/jquery-1.7.1.js"><\/script>')</script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
	<!--[if lt IE 7]><![endif]-->
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
	<script src="/js/admin-projects-team-management.js"></script>

	<!--[if lt IE 8]>
	<script src="/js/json2.js"></script>
	<![endif]-->

	*}

	<script type="text/javascript">
		$(document).ready(function(){
			$('.pod_loader_img').hide();
		});
	</script>

{if (isset($htmlJavaScriptBody) && !empty($htmlJavaScriptBody)) }
	{$htmlJavaScriptBody}
{/if}

{if (isset($htmlAnalyticsBody) && !empty($htmlAnalyticsBody)) }
	{$htmlAnalyticsBody}
{/if}
</body>
</html>
{*/strip*}
