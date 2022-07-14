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
 * Global AJAX class - Asynchronous JavaScript And XML.
 *
 * PHP versions 5
 *
 * @category   Ajax
 * @package    Ajax
 */

/**
 * Model
 */
//Already Included...commented out for performance gain
//require_once('lib/common/Model.php');

class Ajax extends Model
{
	protected static $_instance;

	/**
	 * Constructor.
	 *
	 * @return void
	 *
	 */
	public function __construct()
	{
	}

	public static function getInstance($domain = 'global')
	{
		// Check if a Singleton exists for this class
		$instance = self::$_instance;

		if (!isset($instance) || !($instance instanceof Ajax)) {
			$instance = new Ajax($domain);
			self::$_instance = $instance;
		}

		return $instance;
	}

	/**
	 * Generate the HTML for a range slider with two sliding book ends.
	 *
	 */
	public function outputRangeSliderControlHtml()
	{
	}

	/**
	 * Generate the HTML for a range slider with two sliding book ends.
	 *
	 */
	public function outputRangeSliderControlJavaScript()
	{
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
