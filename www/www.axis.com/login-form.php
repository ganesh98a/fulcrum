<?php
/**
 * Login form.
 */
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

// retrieve any html messages
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */

if (isset($get->sessionExpired) && !empty($get->sessionExpired)) {
	$sessionExpiredErrorMessage = "Your login session expired.  Please login to continue.";
	$message->enqueueError($sessionExpiredErrorMessage, $currentPhpScript);
	$showJavaScriptError = true;
} else {
	$showJavaScriptError = false;
}
/*error msg format changes for login design*/
 // $htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
 // print_r($htmlMessages);
 $htmlMessages = $message->getFormattedHtmlMessagesForLogin($currentPhpScript);
 /*username msg*/
 if(isset($htmlMessages['username']))
 	$htmlMessagesUsername = $htmlMessages['username'];
 else
 	$htmlMessagesUsername = '';
/*password error msg*/
 if(isset($htmlMessages['password']))
 	$htmlMessagesPassword = $htmlMessages['password'];
 else
	$htmlMessagesPassword ='';
/*invalid || session expired msg*/
 if(isset($htmlMessages['generic']))
 	$htmlMessagesGeneraic = $htmlMessages['generic'];
 else
	$htmlMessagesGeneraic = '';
/*log out msg*/
 if(isset($htmlMessages['genericSuccess']))
 	$htmlMessagesGeneraicSuccess = $htmlMessages['genericSuccess'];
 else
	$htmlMessagesGeneraicSuccess = '';

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS

<style>
#wrapper {
	border: 0px solid #f0f0f0;
	margin-left: auto;
	margin-right: auto;
	width: 800px;
}
</style>
END_HTML_CSS;

// Avoid the login form being framed by the CDN file preview iframe
if ($showJavaScriptError) {

	if (!isset($htmlJavaScriptBody)) {
		$htmlJavaScriptBody = '';
	}
	$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY

<script>
(function($) {
	$(document).ready(function() {

	function messageAlert(text, messageStyle, labelStyle, elementId) {
		clearTimeout(window["labelStyleTimeout_" + elementId]);
		clearTimeout(window["messageStyleTimeout_" + elementId]);

	    $("#messageDiv").removeClass();
	    $("#messageDiv").html('');

	    $("#messageDiv").addClass(messageStyle);
	    $("#messageDiv").html(text);
	    $("#messageDiv").fadeIn("slow");

	    window["messageStyleTimeout_" + elementId] = setTimeout(function() {
	    	$("#messageDiv").fadeOut("slow",function() {
	        	$("#messageDiv").removeClass();
	        	$("#messageDiv").html('');
	    	});
	    },3000);

	    if (elementId != "none") {
	    	var classesToRemove = "infoMessageLabel successMessageLabel warningMessageLabel errorMessageLabel";
	    	$("#" + elementId).removeClass(classesToRemove);
	    	$("#" + elementId).addClass(labelStyle);

	    	window["labelStyleTimeout_" + elementId] = setTimeout(function() {
	    		$("#" + elementId).removeClass(classesToRemove);
	    	},3000);
	    }
	}

	messageAlert('$sessionExpiredErrorMessage','errorMessage');

	});
})(jQuery);
</script>
END_HTML_JAVASCRIPT_BODY;

}

// retrieve any postback data
$postBack = Egpcs::sessionGet($applicationLabel, 'login-form.php', 'post');
/* @var $postBack Egpcs */
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	// set values using $postBack
	$username = $postBack->auth_name;
	$password = $postBack->auth_pass;
} else {
	$username = '';
	$password = '';
}

$template->assign('queryString', $uri->queryString);
$template->assign('username', $username);
$template->assign('password', $password);
$template->assign('htmlMessagesUsername', $htmlMessagesUsername);
$template->assign('htmlMessagesPassword', $htmlMessagesPassword);
$template->assign('htmlMessagesGeneraic', $htmlMessagesGeneraic);
$template->assign('htmlMessagesGeneraicSuccess', $htmlMessagesGeneraicSuccess);
//$template->assign('htmlMessages', $htmlMessages);

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Myfulcrum.com Construction Project Management Software';
//$htmlBody = "onload='setFocus();'";
$htmlBody = "onload='document.getElementById(\"first_element\").focus();'";

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
	$htmlContent = $template->fetch('login-form-mobile.tpl');
} else {
	$htmlContent = $template->fetch('login-form-web.tpl');
}
$template->assign('htmlContent', $htmlContent);

//require_once('page-components/axis/footer_smarty.php');

$template->display('master-web-unauthenticated-home-html5.tpl');
exit;

?>


<table border="0" width="100%" cellspacing="0" cellpadding="1">
<tr>
<td height="20"><div class="headerStyle">Axis.com Portal</div></td>
</tr>
<tr>
<td>
	<table border="0">
	<tr>
	<td valign="top" width="45%"><img src="images/login.gif" width="272" height="18"><br>
	<?php
	if (isset($htmlMessages) && !empty($htmlMessages)) {
		echo '<div>'.$htmlMessages.'</div>';
	}
	?>
	<form name="frm_auth" action="login-form-submit.php<?php echo $uri->queryString; ?>" method="post">
	Username:<br>
	<input id="first_element" tabindex="101" type="email" size="30" maxlength="50" name="auth_name" value="<?php echo $username ?>" style="width:220px; margin:2px;"><br>
	Password:<br>
	<input tabindex="102" type="password" size="30" maxlength="20" name="auth_pass" value="<?php echo $password ?>" style="width:220px; margin:2px;">
	<br><a href="password-retrieval-form.php" style="font-size:70%;" tabindex="104">Forgot Password?</a><br><input tabindex="103" type="submit" value="LOGIN" name="auth_login" style="width:100px; margin-top:5px;"></form></td>
	<td valign="top" width="40%"><img src="images/newlogin.gif" width="272"><br>Click below to register your MyFulcrum.com account.&nbsp;After registering you can manage your account information, update your projects, and download apps.<br><button tabindex="105" onclick="location='account-registration-form.php<?php echo $uri->queryString; ?>'" name="register" style="margin-top:5px;">REGISTER</button></td>
	<td width="15%">&nbsp;</td>
	</tr>
	<tr>
	<td valign="top">
		<table border="0">
		<tr>
		<td valign="top" width="21"><img height="13" src="images/secureicon.gif" width="14"></td>
		<td class="bts3">Your information will be sent using our secure server.</td>
		</tr>
		<tr>
		<td valign="top" width="21"><img src="images/check.gif" width="15" height="14"></td>
		<td class="bts3">View and Edit Account Information</td>
		</tr>
		<tr>
		<td valign="top" width="21" nowrap><img src="images/check.gif" width="15" height="14"></td>
		<td class="bts3" nowrap><a tabindex="106" href="smartphone-apps.php">Download SmartPhone Apps</a></td>
		</tr>
		</table>
	</td>
	<td valign="top"><img src="images/forgotpwd.gif" width="272" height="18"><br>If you forgotten your password, click on the link below to retrieve it.<br><button tabindex="107" onclick="window.location='password-retrieval-form.php<?php echo $uri->queryString; ?>'" name=retrieve value="Retrieve Password" style="margin-top:5px;">RETRIEVE</button></td>
	<td>&nbsp;</td>
	</tr>
	</table>
</td>
</tr>
</table>
<?php
require_once('page-components/axis/footer.php');
?>
