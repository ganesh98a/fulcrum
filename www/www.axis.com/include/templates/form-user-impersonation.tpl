
									<form id="impersonateForm" action="/impersonate-users-form-submit.php" method="post">
									{include file="dropdown-impersonate-user-company-list.tpl"}
									<br>
									{include file="dropdown-impersonate-user-list.tpl"}
									<input tabindex="3" type="submit" value="Impersonate"> <input tabindex="4" type="button" value="Reset" onclick="window.location='/impersonate-users-logout.php{$referrerUrl}'">

									<input id="debugMode" name="debugMode" type="hidden" value="{$debugMode}">
									<input tabindex="5" type="button" value="Debug Mode {$debugModeLabel}" onclick="toggleDebugMode();">

									<input id="cssDebugMode" name="cssDebugMode" type="hidden" value="{$cssDebugMode}">
									<input tabindex="6" type="button" value="CSS Debug Mode {$cssDebugModeLabel}" onclick="toggleCssDebugMode();">

									<input id="javaScriptDebugMode" name="javaScriptDebugMode" type="hidden" value="{$javaScriptDebugMode}">
									<input tabindex="7" type="button" value="JS Debug Mode {$javaScriptDebugModeLabel}" onclick="toggleJavaScriptDebugMode();">

									<input id="showJSExceptions" name="showJSExceptions" type="hidden" value="{$showJSExceptions}">
									<input tabindex="8" type="button" value="Show JS Exceptions {$showJSExceptionsLabel}" onclick="toggleShowJSExceptions();">

									<input id="ajaxUrlDebugMode" name="ajaxUrlDebugMode" type="hidden" value="{$ajaxUrlDebugMode}">
									<input tabindex="9" type="button" value="Ajax URLs Debug Mode {$ajaxUrlDebugModeLabel}" onclick="toggleAjaxUrlDebugMode();">

									<input id="consoleLoggingMode" name="consoleLoggingMode" type="hidden" value="{$consoleLoggingMode}">
									<input tabindex="10" type="button" value="Console Logging {$consoleLoggingModeLabel}" onclick="toggleConsoleLoggingMode();">
									</form>
