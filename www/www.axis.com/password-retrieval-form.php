<?php
/**
 * Forgot password.
 */
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = false;
$init['https_auth'] = false;
$init['https_admin'] = false;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

$htmlTitle = 'Retrieve Your Account Password';
//$htmlBody = "onload='setFocus();'";
$htmlBody = "";

$headline = 'Password Retrieval';
$template->assign('headline', $headline);

//retrieve any html messages
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

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


if (!isset($htmlJavaScriptHead)) {
	$htmlJavaScriptHead = '';
}
$htmlJavaScriptHead .= <<<END_HTML_JAVASCRIPT_HEAD

<script>
window.onload = function () {
	document.getElementById('first_element').focus();
}
function refreshCaptcha()
{
	var email = document.getElementById('first_element').value;
	var tmpLocation = new String(document.location);
	var tmpUrl = tmpLocation.split("?")[0];
	var emailLength = email.length;
	if (emailLength > 0) {
		var url = tmpUrl + '?email=' + email;
	} else {
		var url = tmpUrl;
	}
	document.location = url;
}
</script>
END_HTML_JAVASCRIPT_HEAD;

// retrieve any postback data
$postBack = Egpcs::sessionGet($applicationLabel, 'password-retrieval-form.php', 'post');
/* @var $postBack Egpcs */
$postBackFlag = $postBack->getPostBackFlag();
if (isset($get->email)) {
	$username = $get->email;
	$postBack->sessionClear();
} elseif ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	// set values using $postBack
	$username = $postBack->auth_name;
} else {
	$username = '';
}

$template->assign('queryString', $uri->queryString);
$template->assign('username', $username);
//$template->assign('htmlMessages', $htmlMessages);


// CAPTCHA
// Zend_Figlet
require_once('Zend/View.php');
require_once('Zend/Captcha/Figlet.php');
$view = new Zend_View();
$arrCaptchaInit = array(
	'name' => 'foo',
	'wordLen' => 5,
	'timeout' => 300,
);
$captcha = new Zend_Captcha_Figlet($arrCaptchaInit);
$id = $captcha->generate(array('f'=>1));
$word = $captcha->getWord();
$session->captcha_actual = $word;
$captchaOutput = $captcha->render($view);
$template->assign('captcha', $captchaOutput);
//print_r($captcha);
//exit;


// Potentially hide the form...on successful password reset
if (isset($get->hideForm) && ($get->hideForm == 1)) {
	$template->assign('hideForm', 1);
	$template->assign('startOverUrl', $uri->currentPhpScript);
}


require('template-assignments/main.php');

if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
	$htmlContent = $template->fetch('password-retrieval-form-mobile.tpl');
} else {
	$htmlContent = $template->fetch('password-retrieval-form-web.tpl');
}
$template->assign('htmlContent', $htmlContent);

//require_once('page-components/axis/footer_smarty.php');

$template->display('master-web-unauthenticated-html5.tpl');
exit;


require_once('page-components/axis/header.php');
?>
<div class="headerStyle">Password Retrieval</div>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">

<tr>
<td>
<?php echo $htmlMessages; ?>
</td>
</tr>

<tr>
<td>
<div align="left">If you have forgotten your Password, follow these steps:
<ol type="i">
<li>Enter your login email address below.
<li>Follow the instructions of the e-mail that you receive.</li>
</ol>
</div>
</td>
</tr>

<tr>
<td align="left">

<form action="password-retrieval-form-submit.php<?php echo $uri->queryString; ?>" method="post" name="frm_forgot_password">
<table border="0" cellpadding="0" cellspacing="0">

<tr>
<td nowrap align="left"><b>Enter Your Login E-mail Address:</b></td>
<td align="left"><input id="first_element" maxlength="50" name="auth_name" size="33" type="email" value="<?php echo $username; ?>"></td>
</tr>

<tr>
<td></td>
<td nowrap align="right"><input class="button" type="submit" value="Retrieve Password" name="Submit">
</td>
</tr>

</table>
</form>

</td>
</tr>

</table>
<?php
require_once('page-components/axis/footer.php');
?>