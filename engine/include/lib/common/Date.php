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
 * Date class for date and calendar math.
 *
 * The "category" php
 *
 * @category   Framework
 * @package    Date
 */

/**
 * @see Example_Interface
 */
//require_once('lib/common/Date/Interface.php');

//class Date implements Date_Interface
class Date
{
	/**
	 * Convert a dateTime stamp from one format to another.
	 *
	 * Formats include database_datetime, database_date, html_form, html_meta, unix_timestamp, and microtime.
	 *
	 * @param string $input
	 * @param string $outputFormat
	 *
	 * @return string
	 */
	public static function convertDateTimeFormat($input, $outputFormat)
	{
		// Sanity check
		if (empty($input) || $input == '0000-00-00') {
			return '';
		}

		// Sanity check
		if (($outputFormat <> 'database_datetime') && ($outputFormat <> 'database_date') && ($outputFormat <> 'html_form') && ($outputFormat <> 'html_meta') && ($outputFormat <> 'unix_timestamp') && ($outputFormat <> 'html_form_datetime')) {
			return '';
		}

		// Normalize to Unix Timestamp first
		$unixTimestamp = strtotime($input);

		switch ($outputFormat) {

			case 'database_datetime':
				$dateTime = date('Y-m-d H:i:s', $unixTimestamp);
				break;

			case 'database_date':
				$dateTime = date('Y-m-d', $unixTimestamp);
				break;

			case 'html_form':
				$dateTime = date('m/d/Y', $unixTimestamp);
				break;

			case 'html_form_datetime':
				$dateTime = date('m/d/Y H:i:s', $unixTimestamp);
				break;

			case 'html_meta':
				// HTTP Date Header - Date: HTTP-Date (RFC 822 format)
				// RFC 822 format - "D, d M y H:i:s O"
				// Tue, 20 Aug 1996 14:25:27 GMT
				// $rfc822DateFormat = 'Fri, 21 Mar 2008 18:35:00 GMT';
				$dateTime = date('D, d M Y H:i:s O', $unixTimestamp);
				break;

			default:
			case 'unix_timestamp':
				$dateTime = $unixTimestamp;
				break;

		}

		return $dateTime;
	}

	/**
	 * Get a dateTime stamp back in an exact format.
	 *
	 * Formats include database, html_meta, unix, and microtime.
	 *
	 * @param string $format
	 * @param mixed $offset
	 * @return mixed
	 */
	public static function dateTime($format = 'database', $offset = 0)
	{
		$offset = (int) $offset;
		switch ($format) {
			case 'database':
				$dateTime = date('Y-m-d H:i:s', time() + $offset);
				break;
			case 'html_meta':
				$dateTime = date('D, d M Y H:i:s', time() + $offset);
				break;
			case 'unix':
				$dateTime = time() + $offset;
				break;
			case 'microtime':
				$offset = (float) $offset;
				$dateTime = microtime(true) + $offset;
				break;
		}

		return $dateTime;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
