<?php /* Smarty version Smarty-3.0.8, created on 2017-05-28 23:29:45
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/form-user-impersonation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:70775786592bbfd9c5f9e4-53291802%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '274edbd3f9f2f9e32bfb9af16619b086b5230259' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/form-user-impersonation.tpl',
      1 => 1454678838,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '70775786592bbfd9c5f9e4-53291802',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

									<form id="impersonateForm" action="/impersonate-users-form-submit.php" method="post">
									<?php $_template = new Smarty_Internal_Template("dropdown-impersonate-user-company-list.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
									<br>
									<?php $_template = new Smarty_Internal_Template("dropdown-impersonate-user-list.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
									<input tabindex="3" type="submit" value="Impersonate"> <input tabindex="4" type="button" value="Reset" onclick="window.location='/impersonate-users-logout.php<?php echo $_smarty_tpl->getVariable('referrerUrl')->value;?>
'">

									<input id="debugMode" name="debugMode" type="hidden" value="<?php echo $_smarty_tpl->getVariable('debugMode')->value;?>
">
									<input tabindex="5" type="button" value="Debug Mode <?php echo $_smarty_tpl->getVariable('debugModeLabel')->value;?>
" onclick="toggleDebugMode();">

									<input id="cssDebugMode" name="cssDebugMode" type="hidden" value="<?php echo $_smarty_tpl->getVariable('cssDebugMode')->value;?>
">
									<input tabindex="6" type="button" value="CSS Debug Mode <?php echo $_smarty_tpl->getVariable('cssDebugModeLabel')->value;?>
" onclick="toggleCssDebugMode();">

									<input id="javaScriptDebugMode" name="javaScriptDebugMode" type="hidden" value="<?php echo $_smarty_tpl->getVariable('javaScriptDebugMode')->value;?>
">
									<input tabindex="7" type="button" value="JS Debug Mode <?php echo $_smarty_tpl->getVariable('javaScriptDebugModeLabel')->value;?>
" onclick="toggleJavaScriptDebugMode();">

									<input id="showJSExceptions" name="showJSExceptions" type="hidden" value="<?php echo $_smarty_tpl->getVariable('showJSExceptions')->value;?>
">
									<input tabindex="8" type="button" value="Show JS Exceptions <?php echo $_smarty_tpl->getVariable('showJSExceptionsLabel')->value;?>
" onclick="toggleShowJSExceptions();">

									<input id="ajaxUrlDebugMode" name="ajaxUrlDebugMode" type="hidden" value="<?php echo $_smarty_tpl->getVariable('ajaxUrlDebugMode')->value;?>
">
									<input tabindex="9" type="button" value="Ajax URLs Debug Mode <?php echo $_smarty_tpl->getVariable('ajaxUrlDebugModeLabel')->value;?>
" onclick="toggleAjaxUrlDebugMode();">

									<input id="consoleLoggingMode" name="consoleLoggingMode" type="hidden" value="<?php echo $_smarty_tpl->getVariable('consoleLoggingMode')->value;?>
">
									<input tabindex="10" type="button" value="Console Logging <?php echo $_smarty_tpl->getVariable('consoleLoggingModeLabel')->value;?>
" onclick="toggleConsoleLoggingMode();">
									</form>
