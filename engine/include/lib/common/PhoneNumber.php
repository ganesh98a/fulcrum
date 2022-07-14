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
 * PhoneNumber.
 *
 * @category   Framework
 * @package    PhoneNumber
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class PhoneNumber extends IntegratedMapper
{
	public $phone_number_type_id;
	public $country_code;
	public $area_code;
	public $prefix;
	public $number;
	public $extension;
	public $itu;

	// Other properties
	public $phone_number_type;

	/**
	 * Constructor
	 */
	public function __construct()
	{
	}

	public static function parsePhoneNumber($rawPhoneNumber='')
	{
		// Check for empty string
		if (empty($rawPhoneNumber)) {
			throw new Exception('Invalid Phone Number Input');
		}

		// Remove non-numeric value, e.g. convert "(949) 555-1234" to "9495551234"
		$rawPhoneNumber = trim($rawPhoneNumber);
		$phoneNumber = preg_replace('/[^0-9]+/', '', $rawPhoneNumber, -1);
		$phoneNumber = trim($phoneNumber);
		$area_code = substr($phoneNumber, 0, 3);
		$prefix = substr($phoneNumber, 3, 3);
		$number = substr($phoneNumber, 6, 8);

		if (empty($area_code) || (strlen($area_code) <> 3)) {
			throw new Exception('Invalid Phone Area Code');
		}

		if (empty($prefix) || (strlen($prefix) <> 3)) {
			throw new Exception('Invalid Phone Prefix');
		}

		if (empty($number) || (strlen($number) < 4)) {
			throw new Exception('Invalid Phone Number');
		}

		$pn = new PhoneNumber();
		$pn->area_code = $area_code;
		$pn->prefix = $prefix;
		$pn->number = $number;

		return $pn;
	}

	public function getFormattedNumber()
	{
		$formattedPhoneNumber = '('.$this->area_code.') '.$this->prefix.'-'.$this->number;

		return $formattedPhoneNumber;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
