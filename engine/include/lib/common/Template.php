<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * Template class.
 *
 * @category   Framework
 * @package    Template
 */

class Template
{
	private static $_instance;

	public static function getInstance($templateTheme = 'default')
	{
		$instance = self::$_instance;

		if (!isset($instance[$templateTheme])) {
			$template = new Template($templateTheme);
			self::$_instance[$templateTheme] = $template;
			return $template;
		}

		return $instance[$templateTheme];
	}

	private $_templateTheme;

	public function getTemplateTheme()
	{
		if (isset($this->_templateTheme)) {
			return $this->_templateTheme;
		} else {
			return 'default';
		}
	}

	public function setTemplateTheme($templateTheme)
	{
		$this->_templateTheme = $templateTheme;
	}

	private $_engine;

	public function getEngine()
	{
		if (isset($this->_engine)) {
			return $this->_engine;
		} else {
			return null;
		}
	}

	public function setEngine($engine)
	{
		if (isset($engine)) {
			$this->_engine = $engine;
		}
	}

	private $_outputBuffering;

	public function getOutputBuffering()
	{
		if (isset($this->_outputBuffering)) {
			return $this->_outputBuffering;
		} else {
			return null;
		}
	}

	public function setOutputBuffering($outputBuffering)
	{
		if (isset($outputBuffering)) {
			$this->_outputBuffering = $outputBuffering;
		} else {
			$this->_outputBuffering = null;
		}
	}

	// Standard HMTL Widget variables
	public $queryString;
	public $htmlDoctype = '<!DOCTYPE html>';
	public $htmlLang = 'en';
	public $htmlCharset = 'utf-8';
	public $htmlMeta;
	public $htmlTitle;
	public $htmlCss;
	public $htmlJavaScriptHead;
	public $htmlAnalyticsHead;
	public $htmlHead;
	public $htmlBodyElement;
	public $htmlMessages;
	public $htmlContent;
	public $htmlJavaScriptBody;
	public $htmlAnalyticsBody;

	// Geo Location variables
	public $ipAdress;
	public $latitude;
	public $longitude;
	public $city;
	public $state;
	public $zip;
	public $country;

	// Whether to load the primary user's navigation
	private $loadMenuFlag = false;

	private function __construct($templateTheme)
	{
		$this->setTemplateTheme($templateTheme);
	}

	public function __destruct()
	{
		$this->_engine = null;
	}

	public function init()
	{
		$outputBufferingFlag = $this->_outputBuffering;
		if (isset($outputBufferingFlag) && $outputBufferingFlag) {
			$this->startOutputBuffering();
		}
	}

	public function getLoadMenuFlag()
	{
		return $this->loadMenuFlag;
	}

	public function setLoadMenuFlag($loadMenuFlag)
	{
		$this->loadMenuFlag = $loadMenuFlag;
	}

	public function startOutputBuffering()
	{
		ob_start();
	}

	public function flush()
	{
		$outputBufferingFlag = $this->_outputBuffering;
		if (isset($outputBufferingFlag) && $outputBufferingFlag) {
			while(ob_get_level()) {
				ob_end_flush();
			}
			flush();
		}
	}

	private $_cacheFlag = false;

	public function getCaching()
	{
		if (isset($this->_cacheFlag)) {
			return $this->_cacheFlag;
		} else {
			return false;
		}
	}

	public function setCaching($cacheFlag)
	{
		if (($cacheFlag == true) || ($cacheFlag == false)) {
			$this->_cacheFlag = $cacheFlag;
		} else {
			throw new Exception('Invalid input');
		}
	}

	public function assign($tpl_var, $value = null, $nocache = false)
	{
		$return = $this->_engine->assign($tpl_var, $value, $nocache);
		//return $return;
	}

	public function fetch($template, $cache_id = null, $compile_id = null, $parent = null, $display = false)
	{
		/*
		$templateTheme = $this->_templateTheme;
		if (isset($templateTheme)) {
			$template = $templateTheme.'-'.$template;
		}
		*/
		$return = $this->_engine->fetch($template, $cache_id, $compile_id, $parent, $display);
		return $return;
	}

	public function display($template, $cache_id = null, $compile_id = null, $parent = null)
	{
		$templateTheme = $this->_templateTheme;
		if (isset($templateTheme)) {
			$template = 'theme-'.$templateTheme.'-'.$template;
		}

		$return = $this->_engine->display($template, $cache_id, $compile_id, $parent);
		//return $return;

		$this->flush();
	}

	public function assignStandardHtmlWidgets()
	{
		if (isset($this->queryString)) {
			$this->assign('queryString', $this->queryString);
		}

		if (isset($this->htmlDoctype)) {
			$this->assign('htmlDoctype', $this->htmlDoctype);
		}

		if (isset($this->htmlLang)) {
			$this->assign('htmlLang', $this->htmlLang);
		}

		if (isset($this->htmlCharset)) {
			$this->assign('htmlCharset', $this->htmlCharset);
		}

		if (isset($this->htmlMeta)) {
			$this->assign('htmlMeta', $this->htmlMeta);
		}

		if (isset($this->htmlTitle)) {
			$this->assign('htmlTitle', $this->htmlTitle);
		}

		if (isset($this->htmlCss)) {
			$this->assign('htmlCss', $this->htmlCss);
		}

		if (isset($this->htmlJavaScriptHead)) {
			$this->assign('htmlJavaScriptHead', $this->htmlJavaScriptHead);
		}

		if (isset($this->htmlAnalyticsHead)) {
			$this->assign('htmlAnalyticsHead', $this->htmlAnalyticsHead);
		}

		if (isset($this->htmlHead)) {
			$this->assign('htmlHead', $this->htmlHead);
		}

		if (isset($this->htmlBodyElement)) {
			$this->assign('htmlBodyElement', $this->htmlBodyElement);
		}

		if (isset($this->htmlMessages)) {
			$htmlMessages = $this->htmlMessages;
		} else {
			$htmlMessages = '';
		}
		$this->assign('htmlMessages', $htmlMessages);

//		if (isset($this->htmlContent)) {
//			$this->assign('htmlContent', $this->htmlContent);
//		}

		if (isset($this->htmlJavaScriptBody)) {
			$this->assign('htmlJavaScriptBody', $this->htmlJavaScriptBody);
		}

		if (isset($this->htmlAnalyticsBody)) {
			$this->assign('htmlAnalyticsBody', $this->htmlAnalyticsBody);
		}
	}

	public function assignGeoLocationValues()
	{
		if (isset($this->ipAdress)) {
			$this->assign('ipAdress', $this->ipAdress);
		}

		if (isset($this->latitude)) {
			$this->assign('latitude', $this->latitude);
		}

		if (isset($this->longitude)) {
			$this->assign('longitude', $this->longitude);
		}

		if (isset($this->city)) {
			$this->assign('city', $this->city);
		}

		if (isset($this->state)) {
			$this->assign('state', $this->state);
		}

		if (isset($this->zip)) {
			$this->assign('zip', $this->zip);
		}

		if (isset($this->country)) {
			$this->assign('country', $this->country);
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
