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
 * Format something.
 *
 * @category	Framework
 * @package		Format
 */

class Format
{
	/**
	 * Input text.
	 *
	 * @var string
	 */
	protected $_input = null;

	/**
	 * Output text.
	 *
	 * @var string
	 */
	protected $_output = null;

	/**
	 * Static Singleton instance variable
	 *
	 * @var Format object
	 */
	protected static $_instance;

	/**
	 * Static factory method to return an instance of the object.
	 *
	 * @param Static object reference
	 * @return Singleton object reference
	 */
	public static function getInstance()
	{
		$instance = self::$_instance;

		if (!isset($instance)) {
			$instance = new Format();
			self::$_instance = $instance;
		}

		return $instance;
	}

	public static function formatCurrency($input)
	{
		$money = trim($input);

		// Replace everything other than 0-9 or - or .
		$money = preg_replace('/[^-0-9\.]+/', '', $money);

		// Replace repeating - with just one -
		$money = preg_replace('/[-]+/', '-', $money);

		// Replace everything at the end (after the ".") of the input with just numbers 0-9
		$money = preg_replace('/[^0-9]+$/', '', $money);

		$money = (float) $money;

		if ($money < 0) {
			$currencySymbol = '-$';
			$money *= -1;
		} else {
			$currencySymbol = '$';
		}

		// Add comma for thousands
		$money = number_format($money, 2, '.', ',');

		$money = "{$currencySymbol}$money";

		return $money;
	}

	public static function convertFloatToWord($floatAmount)
	{
		list($digit,$decimal) = explode('.', $floatAmount);
		if(!isset($decimal)) {
			$decimal = 0;
		}
		$convertedAmount = self::convertNumberToWord($digit) . ' and ' . sprintf("%'.02d", $decimal) . '/100';
		return $convertedAmount;
	}

	public static function convertNumberToWord($number)
	{
		if (($number < 0) || ($number > 999999999))
		{
			throw new Exception("Number is out of range");
		}

		$Gn = floor($number / 1000000);  /* Millions (giga) */
		$number -= $Gn * 1000000;
		$kn = floor($number / 1000);     /* Thousands (kilo) */
		$number -= $kn * 1000;
		$Hn = floor($number / 100);      /* Hundreds (hecto) */
		$number -= $Hn * 100;
		$Dn = floor($number / 10);       /* Tens (deca) */
		$n = $number % 10;               /* Ones */

		$res = "";

		if ($Gn)
		{
			$res .= self::convertNumberToWord($Gn) . " Million";
		}

		if ($kn)
		{
			$res .= (empty($res) ? "" : " ") .
			self::convertNumberToWord($kn) . " Thousand";
		}

		if ($Hn)
		{
			$res .= (empty($res) ? "" : " ") .
			self::convertNumberToWord($Hn) . " Hundred";
		}

		$ones = array(
			'',
			'One',
			'Two',
			'Three',
			'Four',
			'Five',
			'Six',
			'Seven',
			'Eight',
			'Nine',
			'Ten',
			'Eleven',
			'Twelve',
			'Thirteen',
			'Fourteen',
			'Fifteen',
			'Sixteen',
			'Seventeen',
			'Eightteen',
			'Nineteen'
		);

		$tens = array(
			'',
			'Twenty',
			'Thirty',
			'Fourty',
			'Fifty',
			'Sixty',
			'Seventy',
			'Eigthy',
			'Ninety'
		);

		if ($Dn || $n)
		{
			if (!empty($res))
			{
				$res .= " and ";
			}

			if ($Dn < 2)
			{
				$res .= $ones[$Dn * 10 + $n];
			}
			else
			{
				$res .= $tens[$Dn];

				if ($n)
				{
					$res .= " " . $ones[$n];
				}
			}
		}

		if (empty($res))
		{
			$res = "zero";
		}

		return $res;
	}

	/**
	 * Format a filename that is safe
	 *
	 * @param string $input
	 * @return string
	 */
	public static function formatFilename($input)
	{
		if (isset($input) && !empty($input) && (strlen($input) > 0)) {
			$originalInput = $input;

			//lowercase
			$input = strtolower($input);

			// Sanity check for non alphanumeric characters
			if (!ctype_alnum($input)) {
				//women's to womens
				$input = str_replace("'", '', $input);

				//+ to -plus- e.g. c++ to c-plus--plus-
				$input = preg_replace('/[+]/', '-plus-', $input);

				//* to -star- e.g. *ist D to -star-ist d
				$input = preg_replace('/[*]/', '-star-', $input);

				//& to -and- e.g. Clothing & Accessories to clothing -and- accessories
				$input = preg_replace('/[&]+/', '-and-', $input);

				//! to -exclamation-mark-
				$input = preg_replace('/[!]/', '-exclamation-mark-', $input);

				//eliminate non-alphanumeric characters
				$input = preg_replace('/[^-.0-9a-zA-Z]/', '-', $input);

				//shrink empty string
				$input = preg_replace('/-$/', '', $input);

				//change -- to -
				$input = preg_replace('/[-]{2,}/', '-', $input);
			}

			//remove - from beginning or end
			$input = trim($input, '- ');

			if (!empty($input) && (strlen($input) > 0)) {
				return $input;
			} else {
				echo "\nOriginal Input: $originalInput\nInput: $input\n\n";

				//Log bad data.

				return '';
			}
		} else {
			//Log bad data.
		}
	}

	/**
	 * Format an image filename - to match what is stored on disk.
	 *
	 * @param string $input
	 * @return string
	 */
	function formatImageFilename($input)
	{
		if (isset($input) && !empty($input) && (strlen($input) > 0)) {
			$originalInput = $input;
			$input = strtolower($input);
			$input = str_replace('images/', '', $input);
			$input = preg_replace('/[+]/', 'plus', $input);
			$input = preg_replace('/[*]/', 'star', $input);
			$input = preg_replace('/[^\/.0-9a-zA-Z]/', '-', $input);
			if (!empty($input) && (strlen($input) > 0)) {
				return $input;
			} else {
				//Log bad data.
				return '';
			}
		} else {
			//Log bad data.
			return '';
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
