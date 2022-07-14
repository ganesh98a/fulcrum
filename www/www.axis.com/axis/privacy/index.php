<?php
/**
 * Privacy Policy.
 */
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = false;
$init['https_admin'] = false;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');


$htmlTitle = 'Privacy Policy';
$htmlBody = "";

$headline = 'Privacy Policy';
$template->assign('headline', $headline);

//retrieve any html messages
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages('privacy.php');

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

p {
	color: #8B8E90;
	margin-top: 0px;
}

.header {
	color: black;
}
</style>
END_HTML_CSS;


$template->assign('queryString', $uri->queryString);

require('template-assignments/main.php');

$htmlContent = '
<p class="header">
What information do we collect?
</p>
<p>
We collect information from you when you register on our site, respond to a survey or fill out a form.  When ordering or registering on our site, as appropriate, you may be asked to enter your: name, e-mail address, business information, and/or contact lists. You may, however, visit our site anonymously.
</p>
<p class="header">
What do we use your information for?
</p>
<p>
Any of the information we collect from you may be used in one of the following ways: To personalize your experience (your information helps us to better respond to your individual needs); To improve our website (we continually strive to improve our website offerings based on the information and feedback we receive from you); To improve customer service (your information helps us to more effectively respond to your customer service requests and support needs); To administer a contest, promotion, survey or other site feature; To send periodic emails.  The email address you provide may be used to send you information, respond to inquiries, and/or other requests or questions.
</p>
<p class="header">
How do we protect your information?
</p>
<p>
We implement a variety of security measures to maintain the safety of your personal information when you enter, submit, or access your personal information.
</p>
<p class="header">
Do we use cookies?
</p>
<p>
Yes (Cookies are small files that a site or its service provider transfers to your computers hard drive through your Web browser (if you allow) that enables the sites or service providers systems to recognize your browser and capture and remember certain information.  We use cookies to keep track of your user session and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future. We may contract with third-party service providers to assist us in better understanding our site visitors. These service providers are not permitted to use the information collected on our behalf except to help us conduct and improve our business.
</p>
<p class="header">
Do we disclose any information to outside parties?
</p>
<p>
We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.
</p>
<p class="header">
Third party links
</p>
<p>
Occasionally, at our discretion, we may include or offer third party products or services on our website. These third party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.
</p>
<p class="header">
California Online Privacy Protection Act Compliance
</p>
<p>
Because we value your privacy we have taken the necessary precautions to be in compliance with the California Online Privacy Protection Act. We therefore will not distribute your personal information to outside parties without your consent.
</p>
<p class="header">
Childrens Online Privacy Protection Act Compliance
</p>
<p>
We are in compliance with the requirements of COPPA (Childrens Online Privacy Protection Act), we do not collect any information from anyone under 13 years of age. Our website, products and services are all directed to people who are at least 13 years old or older.
</p>
<p class="header">
Online Privacy Policy Only
</p>
<p>
This online privacy policy applies only to information collected through our website and not to information collected offline.
</p>
<p class="header">
Your Consent
</p>
<p>
By using our site, you consent to our websites privacy policy
</p>
<p class="header">
Changes to our Privacy Policy
</p>
<p>
If we decide to change our privacy policy, we will post those changes on this page, and/or update the Privacy Policy modification date below.
</p>
<p>
Modified 4/18/2013
</p>
';

$template->assign('htmlContent', $htmlContent);
$template->display('master-web-unauthenticated-html5.tpl');
exit;