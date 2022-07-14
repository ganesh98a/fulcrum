<?php
/**
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 */

/**
 * Main template assignments include.
 */

$template = Zend_Registry::get('template');
/* @var $template Template */

// @todo Comment out this logo testing section
// Logo - Testing
// Default
$logo = '/images/logos/white-transparent-background3.gif';//'/images/logos/fulcrum-green-icon-silver-text.gif';
$application = Zend_Registry::get('application');
if (isset($application->get)) {
	$get = $application->get;
	if (isset($get->logo) && !empty($get->logo)) {
		$logoOption = $get->logo;
		$arrLogoOptions = array(
			1 => 'fulcrum-blue-icon-silver-text.gif',
			2 => 'fulcrum-blue-icon-silver-text-v2.gif',
			3 => 'fulcrum-green-icon-green-text.gif',
			4 => 'fulcrum-green-icon-green-text-v2.gif',
			5 => 'fulcrum-green-icon-silver-text.gif',
			6 => 'fulcrum-green-icon-silver-text-v2.gif',
		);
		switch ($logoOption) {
			case 1:
				$logo = $arrLogoOptions[1];
				$logo = "/images/logos/$logo";
				break;
			case 2:
				$logo = $arrLogoOptions[2];
				$logo = "/images/logos/$logo";
				break;
			case 3:
				$logo = $arrLogoOptions[3];
				$logo = "/images/logos/$logo";
				break;
			case 4:
				$logo = $arrLogoOptions[4];
				$logo = "/images/logos/$logo";
				break;
			case 5:
				$logo = $arrLogoOptions[5];
				$logo = "/images/logos/$logo";
				break;
			case 6:
				$logo = $arrLogoOptions[6];
				$logo = "/images/logos/$logo";
				break;
		}
	}
}
$template->assign('logo', $logo);

/**
 * Standard HTML Widgets
 */
$queryString = $uri->queryString;
if (!isset($queryString)) {
	$queryString = '';
}
$template->queryString = $queryString;

if (!isset($htmlDoctype) || empty($htmlDoctype)) {
	$htmlDoctype = '<!DOCTYPE html>';
}
$template->htmlDoctype = $htmlDoctype;

if (!isset($htmlLang) || empty($htmlLang)) {
	$htmlLang = 'lang="en"';
}
$template->htmlLang = $htmlLang;

/**
 * @todo Meta Tags and charset customization.
 */
/*
if (!isset($htmlCharset) || empty($htmlCharset)) {
	$htmlCharset = 'utf-8';
}
$template->htmlCharset = $htmlCharset;

if (!isset($htmlMeta) || empty($htmlMeta)) {
	$htmlMeta = '';
}
$template->htmlMeta = $htmlMeta;
*/

if (!isset($htmlTitle) || empty($htmlTitle)) {
	$htmlTitle = 'MyFulcrum.com';
}
$template->htmlTitle = $htmlTitle;

if (!isset($htmlCss) || empty($htmlCss)) {
	$htmlCss = null;
}
$template->htmlCss = $htmlCss;

if (!isset($htmlJavaScriptHead) || empty($htmlJavaScriptHead)) {
	$htmlJavaScriptHead = null;
}
$template->htmlJavaScriptHead = $htmlJavaScriptHead;

if (!isset($htmlHead) || empty($htmlHead)) {
	$htmlHead = null;
}
$template->htmlHead = $htmlHead;

if (isset($htmlBody) && !empty($htmlBody)) {
	$htmlBody = trim($htmlBody);
	$htmlBody = " $htmlBody";
} else {
	$htmlBody = '';
}
$template->htmlBodyElement = $htmlBody;

if (!isset($htmlMessages) || empty($htmlMessages)) {
	$htmlMessages = null;
}
$template->htmlMessages = $htmlMessages;

//if (!isset($htmlContent) || empty($htmlContent)) {
//	$htmlContent = '';
//}
//$template->htmlContent = $htmlContent;

if (!isset($htmlJavaScriptBody) || empty($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = null;
}
$template->htmlJavaScriptBody = $htmlJavaScriptBody;

$config = Zend_Registry::get('config');
$operationalMode = $config->system->operational_mode;
if ($operationalMode == 'debug' && 0) {
	$showDebugLocationInfo = true;
	// IP Based Geo Information
	$ipAdress = $geo->ipAddress;
	$latitude = $geo->latitude;
	$longitude = $geo->longitude;
	$city = $geo->city;
	$state = $geo->region;
	$zip = $geo->postalCode;
	$country = $geo->country;

	$template->assign('ipAdress', $ipAdress, true);
	$template->assign('latitude', $latitude, true);
	$template->assign('longitude', $longitude, true);
	$template->assign('city', $city, true);
	$template->assign('state', $state, true);
	$template->assign('zip', $zip, true);
	$template->assign('country', $country, true);
} else {
	$showDebugLocationInfo = false;
}
$template->assign('showDebugLocationInfo', $showDebugLocationInfo, true);

// Web Analytics (Google Analytics for now)
if ($operationalMode == 'production') {
	//require_once('page-components/analytics.php');
}
if ($uri->domain == 'www.myfulcrum.com') {
	require_once('page-components/analytics.php');
}

if (!isset($htmlAnalyticsHead) || empty($htmlAnalyticsHead)) {
	$htmlAnalyticsHead = null;
}

require_once('page-components/googleAnalytics.php');

if (!isset($googleAnalystical) || empty($googleAnalystical)) {
	$googleAnalystical = null;
}else{
	$htmlAnalyticsHead .= $googleAnalystical;
}

require_once('page-components/InspectletTracking.php');

if (!isset($inspecletTracking) || empty($inspecletTracking)) {
	$inspecletTracking = null;
}else{
	$htmlAnalyticsHead .= $inspecletTracking;
}

$template->htmlAnalyticsHead = $htmlAnalyticsHead;

if (!isset($htmlAnalyticsBody) || empty($htmlAnalyticsBody)) {
	$htmlAnalyticsBody = null;
}
$template->htmlAnalyticsBody = $htmlAnalyticsBody;

/**
 * @todo Should this be conditional based on $init['display'] = true; ???
 */
$template->assignStandardHtmlWidgets();

if (isset($template)) {
	$loadMenuFlag = $template->getLoadMenuFlag();
} else {
	$loadMenuFlag = false;
}

if ($loadMenuFlag && isset($actualUserRole) && !empty($actualUserRole)) {
	require('./navigation-projects-list.php');
	//require('page-components/axis/navigation-left-vertical-menu.php');
}

/**
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */
