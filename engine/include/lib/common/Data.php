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
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 *
 * Any and all data.
 *
 * Scrub it, report on it, etc.
 *
 * @category   MVC/Model/Data
 * @package    Data
 *
 */

/**
 * Entities
 */
//require_once('lib/common/Data/HTML_Entities.php');

class Data
{
	private static $_arrDummyElementIds = array();

	private static $_arrDummyPrimaryKeys = array();

	/**
	 * HTML Element ID format: AttributeGroupName--AttributeSubgroupName--AttributeName--PrimaryKey
	 * HTML Attribute Group/Record Name -- SQL Table Name -- SQL Attribute Name -- SQL Record Primary Key Value
	 *
	 * E.g. gc_budget_line_items--cost_codes--cost_code--xxx
	 *
	 * @param string $attributeGroupName
	 * @param string $attributeSubgroupName
	 * @param string $attributeName
	 * @param string $primaryKey
	 * @return string
	 */
	public static function generateDummyElementId($attributeGroupName, $attributeSubgroupName, $attributeName, $primaryKey=null)
	{
		if (!isset($primaryKey) || empty($primaryKey)) {
			$dummyPrimaryKey  = self::generateDummyPrimaryKey();
		}

		$dummyElementId = "$attributeGroupName--$attributeSubgroupName--$attributeName--$primaryKey";

		return $dummyElementId;
	}

	/**
	 * HTML Element ID format: AttributeGroupName--AttributeSubgroupName--AttributeName--PrimaryKey
	 *
	 * @return string
	 */
	public static function generateDummyPrimaryKey()
	{
		do {
			$currentMilliseconds = microtime(true);
			$currentMilliseconds *= 10000;
			$randomNumber = mt_rand(0, 10000);
			$dummyIdValue = $randomNumber + $currentMilliseconds;
			$dummyPrimaryKey = 'dummy_id' . '_' . $dummyIdValue;
		} while (isset(self::$_arrDummyElementIds[$dummyPrimaryKey]));

		self::$_arrDummyElementIds[$dummyPrimaryKey] = 1;

		return $dummyPrimaryKey;
	}

	/**
	 * THIS METHOD IS NOT DEBUGGED!
	 *
	 * Take the difference of any two objects inherited from AbstractWebToolkit.
	 *
	 * The $_data arrays will be compared.
	 *
	 */
	public function diff(AbstractWebToolkit $o1, AbstractWebToolkit $o2, $exactFlag=true)
	{
		$identicalFlag = false;

		$data1 = $o1->getData();
		$data2 = $o2->getData();
		$class = get_class($o1);

		//$exactFlag enforces type and value matching
		if ($exactFlag) {
			$arrDiff = array_diff_assoc($data1, $data2);
			if (empty($arrDiff)) {
				$identicalFlag = true;
			}
		} else {
			$identicalFlag = true;
			foreach ($data1 as $k->$v) {
				if (!isset($data2[$k]) || ($data2[$k] != $v)) {
					$identicalFlag = false;
				}
			}
		}

		return $identicalFlag;
	}

	/**
	 * Take the difference of any two objects inherited from AbstractWebToolkit.
	 *
	 * The $_data arrays will be compared.
	 *
	 */
	public static function diffKeys($data1, $data2)
	{
		$keys1 = array_keys($data1);
		$keys2 = array_keys($data2);
		$arrDiff = array_diff($keys1, $keys2);

		if (empty($arrDiff)) {
			$identicalFlag = true;
		} else {
			$identicalFlag = false;
		}

		return $identicalFlag;
	}

	/**
	 * Convert empty strings to null values.
	 * Trim whitespace off of strings.
	 *
	 * 0 is a special case since it represents false in MySQL
	 * Don't want 0's converted to null values.
	 *
	 * For some data feeds a 0 represents a null so want a
	 * flag ($nullifyZerosFlag) to indicate this case.
	 *
	 * @param array $data
	 * @param boolean $nullifyZerosFlag
	 */
	public static function trimOrNullifyValues($data, $nullifyZerosFlag=false)
	{
		foreach ($data as $k => $v) {
			if (isset($v)) {
				if ($nullifyZerosFlag) {
					if (($v === 0) || ($v === '0')) {
						$v = null;
					}
				}
				if (($v !== 0) && ($v !== '0')) {
					$v = trim($v);
					if (empty($v)) {
						$v = null;
					}
				}
			} else {
				$v = null;
			}
			$data[$k] = $v;
		}

		return $data;
	}

	/**
	 * Copy over any difference from $data2 to $data1 and return difference
	 * array only.
	 *
	 * $data1 is the old record
	 * $data2 is the new record
	 * $data2 values override $data1
	 * This way only the fields that are different are UPDATED.
	 */
	public static function deltify($data1, $data2, $strict=false)
	{
		$arrNewData = array();
		foreach ($data2 as $newKey => $newValue) {
			$existsFlag = array_key_exists($newKey, $data1);

			if ($existsFlag) {
				$oldValue = $data1[$newKey];
				if ($strict) {
					if ($oldValue !== $newValue) {
						$arrNewData[$newKey] = $newValue;
					}
				} else {
					if ($oldValue != $newValue) {
						$arrNewData[$newKey] = $newValue;
					}
				}
			} else {
				$arrNewData[$newKey] = $newValue;
			}
		}

		return $arrNewData;
	}

	/**
	 * Take any string and replace all whitespace with single spaces.
	 */
	public static function singleSpace($input)
	{
		// Check for presence of any whitespace before invoking regex
		// I have confirmed that ctype_graph works with Unicode Whitespace {Z}, but not with Unicode Control {C} characters so lo longer viable
		//if (!ctype_graph($input)) {
			// 10,000 calls averages to ~0.5s, but this does not correctly work for Unicode
			// Single space the inner words/tokens
			//$input = preg_replace('/\s+/', ' ', $input, -1);

			// 10,000 calls averages to ~2.9s, but this does not correctly work for Unicode
			// Notice how much the /u slows this down compared to above
			// Having the /u like '/\s+/u' is a mistake...it does not filter Unicode Whitespace and is ~6 times slower than without the /u
			// http://www.fileformat.info/info/unicode/category/Zs/list.htm
			//$input = preg_replace('/\s+/u', ' ', $input, -1);

			// 10,000 calls averages to ~3.8s
			// Convert one or more Unicode Whitespace ({Z}) or Control ({C}) characters
			//   into a standard ANSII space character (Unicode code point U+0020 or 0x20 in UTF-8 hex)
			$input = preg_replace('/[\p{C}\p{Z}]+/u', ' ', $input, -1);
			// Trim begginning and ending whitespace
			// Not calling this may leave a single space at the beginning and at the end
			$input = trim($input);

			// 10,000 calls averages to ~4.2s
			//$arrInput = preg_split('/\s+/u', $input, -1, PREG_SPLIT_NO_EMPTY);
			//$input = join(' ', $arrInput);
			//$arrInput = preg_split('/[\p{C}\p{Z}]+/u', $input, -1, PREG_SPLIT_NO_EMPTY);
			//$input = join(' ', $arrInput);

			// 10,000 calls averages to ~4.2s
			//preg_match_all('/[^\p{C}\p{Z}]+/u', $input, $arrInput);
			//$arrInput = array_pop($arrInput);
			//$input = join(' ', $arrInput);
		//}

		return $input;
	}

	/**
	 * Take any string and any substring and return the string minus the
	 * substring.
	 *
	 * Surgically remove one string from another.
	 */
	public static function excise($string, $substring, $caseSensitive=true, $singleSpace=true)
	{
		if ($caseSensitive) {
			$matchFnc = 'strpos';
			$replaceFnc = 'str_replace';
		} else {
			$matchFnc = 'stripos';
			$replaceFnc = 'str_ireplace';
		}

		if (is_int($matchFnc($string, $substring))) {
			$string = $replaceFnc($substring, '', $string);
			if ($singleSpace) {
				$string = Data::singleSpace($string);
			}
		}

		return $string;
	}

	public static function parseInt($input)
	{
		if (isset($input)) {
			if (!empty($input)) {
				$output = preg_replace('/[^-0-9]+/', '', $input);
				$output = (int) trim($output);
			} elseif ($input == 0) {
				return 0;
			}
		} else {
			return null;
		}

		return $output;
	}

	public static function parseFloat($input)
	{

		if (isset($input) && !empty($input)) {
			$output = trim($input);

			// Replace everything other than 0-9 or - or .
			$output = preg_replace('/[^-0-9\.]+/', '', $output);

			// Replace repeating - with just one -
			$output = preg_replace('/[-]+/', '-', $output);

			// Replace everything at the end (after the ".") of the input with just numbers 0-9
			$output = preg_replace('/[^0-9]+$/', '', $output);

			if (isset($output) && !empty($output)) {
				$output = (float) $output;
			} else {
				$output = 0.00;
			}
		} else {
			$output = 0.00;
		}

		return $output;
	}

	public static function parseCurrency($input)
	{

		if (isset($input) && !empty($input)) {
			$output = trim($input);

			// Replace everything other than 0-9 or - or .
			$output = preg_replace('/[^-0-9\.]+/', '', $output);

			// Replace repeating - with just one -
			$output = preg_replace('/[-]+/', '-', $output);

			// Replace everything at the end (after the ".") of the input with just numbers 0-9
			$output = preg_replace('/[^0-9]+$/', '', $output);

			if (isset($output) && !empty($output)) {
				$output = (float) $output;
			} else {
				$output = 0.00;
			}
		} else {
			$output = 0.00;
		}

		$output = number_format($output, 2, '.', '');

		return $output;
	}

	public static function parseDigits($input)
	{
		if (isset($input)) {
			if (!empty($input)) {
				$output = preg_replace('/[^0-9]+/', '', $input);
			} elseif ($input == 0) {
				return 0;
			}
		} else {
			return null;
		}

		return $output;
	}

	/**
	 * Strip out trailing periods, commas, colons, etc.
	 *
	 */
	public static function removePunctuation()
	{

	}

	public static function removeHtml($input)
	{
		// Convert ALL HTML Entities to character equivalents
		$input = html_entity_decode($input, ENT_QUOTES, 'UTF-8');
		//$input = Data::entity_decode($input);

		// Strip out HTML tags
		// Some HTML leads to concatenated words after the tags are stripped so add spaces to prevent this
		$input = str_replace('<', ' <', $input);
		$input = str_replace('>', '> ', $input);
		$input = strip_tags($input);

		return $input;
	}

	public static function entity_encode($content)
	{
		//$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
		//natsort($trans);
		//$euro = ord('€');

		$content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
		return $content;
	}

	/**
	 * Convert HTML entities into their UTF-8 character equivalents
	 *
	 * @param unknown_type $content
	 * @return unknown
	 * @see http://www.w3schools.com/tags/ref_entities.asp
	 * @see http://www.w3schools.com/tags/ref_symbols.asp
	 */
	public static function entity_decode($content)
	{
		if (is_int(strpos($content, '&'))) {
			$trans = HTML_Entities::$arrHtmlEntities;

			foreach ($trans as $k => $v) {
				$content = str_replace($k, $v, $content);
			}
		}

		return $content;
	}

	public static function parseLatin1StringIntoHexCodes($string) {
		$arrChars = array();
		$stringLength = strlen($string);

		for ($i=0; $i<$stringLength; $i++) {
			$char = substr($string, $i, 1);
			$d = ord($char);

			$hex = Data::convertDecimalCodeToHexCode($d);

			$arrTmp = array(
				'char'	=> $char,
				'hex'	=> $hex
			);
			$arrChars[] = $arrTmp;
		}

		return $arrChars;
	}

	public static function parseUtf8StringIntoHexCodes($string) {
		$arrUnicodeChars = array();
		$mbStringLength = mb_strlen($string, 'UTF-8');

		for ($i=0; $i<$mbStringLength; $i++) {
			$mb_char = mb_substr($string, $i, 1, 'UTF-8');
			$ucs_4be_mb_char = mb_convert_encoding($mb_char, 'UCS-4BE', 'UTF-8');

			$d = unpack('N', $ucs_4be_mb_char);
			$d = $d[1];

			$mb_hex = Data::convertDecimalCodeToHexCode($d);
			$unicodeCodePoint = 'U+'.$mb_hex;
			$formattedHexCode = '0x'.$mb_hex;

			$arrTmp = array(
				'char'			=> $mb_char,
				'hex'			=> $mb_hex,
				'formatted_hex'	=> $formattedHexCode,
				'code_point'	=> $unicodeCodePoint
			);
			$arrUnicodeChars[] = $arrTmp;
		}

		return $arrUnicodeChars;
	}

	public static function convertDecimalCodeToHexCode($d) {
		$h = dechex($d);
		$h = strtoupper($h);

		$len = strlen($h);

		if ($len % 2 == 1) {
			$h = "0$h";
		}

		return $h;
	}

	/**
	 * &#xhex_code;
	 *
	 * E.g. &#x0057;
	 *
	 * @param unknown_type $entity
	 */
	public static function convertUtf8HexCodeToString($hexCode)
	{
		$entityHexCode = '&#x'.$hexCode.';';
		$string = html_entity_decode($entityHexCode, ENT_QUOTES, 'UTF-8');
		return $string;
	}

	public static function escapeRegexPatternString($string)
	{
		//This has to go first
		// \\ actually represents \ here, but need two here for quoting to work.
		$string = str_replace('\\', '\\\\', $string);
		$string = str_replace('/', '\/', $string);
		$string = str_replace('^', '\^', $string);
		$string = str_replace('$', '\$', $string);
		$string = str_replace('.', '\.', $string);
		$string = str_replace('[', '\[', $string);
		$string = str_replace(']', '\]', $string);
		$string = str_replace('|', '\|', $string);
		$string = str_replace('(', '\(', $string);
		$string = str_replace(')', '\)', $string);
		$string = str_replace('?', '\?', $string);
		$string = str_replace('*', '\*', $string);
		$string = str_replace('+', '\+', $string);
		$string = str_replace('{', '\{', $string);
		$string = str_replace('}', '\}', $string);

		return $string;
	}

	/**
	 * Take a string and group it into an array of words an their occurrence.
	 * key = word
	 * value = occurrence
	 *
	 * IMPORTANT: The input to this method should be already filtered
	 * so a simple single space is the word boundary.
	 *
	 * NO ADVANCED WORD BOUNDARIES HERE
	 *
	 * @param unknown_type $input
	 */
	public static function groupWordsByOccurrence($input, $case='unchanged', $minLength=1, $minOccurrence=1)
	{
		if ($case == 'lower') {
			$input = strtolower($input);
		}

		if ($case == 'upper') {
			$input = strtoupper($input);
		}

		//Create array of token keys with occurrence values.
		if (!ctype_graph($input)) {
			$arrTmp = explode(' ', $input);
		} else {
			$arrTmp = array($input);
		}
		unset($input);
		$arrWords = array();
		foreach ($arrTmp as $word) {
			if (!isset($word[$minLength-1])) {
				continue;
			}
			//Count occurrences of words
			if (!isset($arrWords[$word])) {
				$arrWords[$word] = 1;
			} else {
				$arrWords[$word]++;
			}
		}
		unset($arrTmp);
		unset($word);

		//Remove words that occur less frequently than $minOccurrence
		if ($minOccurrence > 1) {
			foreach ($arrWords as $k => $v) {
				//Skip single occuring tokens
				if ($v == 1) {
					unset($arrWords[$k]);
				}
			}
		}

		return $arrWords;
	}

	/**
	 * Crunch down a string to have no duplicate values within it.
	 *
	 * @param string $string
	 */
	public static function eliminateDuplicates($string='')
	{
		if (!empty($string) && is_int(strpos($string, ' '))) {
			$arrString = preg_split('/ /', $string, -1, PREG_SPLIT_NO_EMPTY);
			$arrTmp = array();
			$newString = '';
			foreach ($arrString as $token) {
				if (!in_array($token, $arrTmp)) {
					$arrTmp[] = $token;
					$newString.= ' '.$token;
				}
			}
			$newString = Data::singleSpace($newString);
			$string = $newString;

			//$arrString = array_reverse($arrString);
			/*
			$size = count($arrString);
			for ($i = $size-1; $i > 0; $i--) {
				$token = $arrTmp[$i];
				$arrTmp = $arrString;
				unset($arrTmp[$i]);
				foreach ($arrTmp as $v) {
					if ($token)
				}
			}
			*/
		}

		return $string;
	}

	/**
	 * Parse a string into words.
	 *
	 * The case and occurrence of the words is unchanged.
	 *
	 * @param string $input
	 * @param string - regex pattern $wordBoundary
	 * @param int $minLength
	 * @return array
	 */
	public static function parse($input, $wordBoundary='/\s+/', $minLength=2)
	{
		if (!empty($input)) {
			// Split on delimiter.
			$arrWords = preg_split($wordBoundary, $input, -1, PREG_SPLIT_NO_EMPTY);

			// Remove tokens that are too short in length.
			foreach ($arrWords as $k => $v) {
				$v = trim($v);
				// Enforce the minimum length.
				if (!isset($v[$minLength-1])) {
					unset($arrWords[$k]);
				}
			}
		} else {
			$arrWords = array();
		}

		return $arrWords;
	}

	/**
	 * Be sure to check php.ini for: mbstring.func_overload = 7
	 * String parsing of UTF-8 strings will not work without that setting for this code.
	 *
	 * Data feed data has special issues so need to parse here with
	 * a specific set of word boundaries.
	 *
	 * These steps are only necessary for this data feed due to its unique
	 * nature and not usually required for string parsing.
	 *
	 * @param string $input
	 * @return string
	 */
	public static function parseStringIntoWords($input)
	{
		//check length
		if (!isset($input[0])) {
			return $input;
		}

		//Trim whitespace and single space
		$input = Data::singleSpace($input);

		//check length
		if (!isset($input[0])) {
			return $input;
		}

		//Remove html entities and tags
		if (!ctype_alnum($input)) {
			$input = Data::removeHtml($input);
			$input = trim($input);
		}

		//check length
		if (!isset($input[0])) {
			return $input;
		}

		//Only need to do the following for data that has non alpha-numeric values
		if (!ctype_alnum($input)) {
			//Parse based upon the data feeds issues
			//Tokenize using the appropriate delimiters
			//this means to split on specifically defined word boundaries
			//wait on comma since processing below affects those
			//$wordBoundary = '([)(\s;]+|->)';
			//$wordBoundary = "/[^a-zA-Z0-9_']/";
			$wordBoundary = "/\W/u";
			$minWordLength = 2;
			$arrTmp = Data::parse($input, $wordBoundary, $minWordLength);

			//replace ending punctuation
			$arrAdditionalWords = array();
			foreach ($arrTmp as $k => $word) {
				//Sanity check
				if (!ctype_alnum($word)) {
					$word = preg_replace('/^[^™®©—]+[™®©—]{1}$/u', '$1', $word);
					//Remove trailing punctuation
					$word = preg_replace('/^(.+?)[;?.,:]{1,}$/u', '$1', $word);
				}

				//Skip single character tokens
				//Retest after above manipulation
				if (!isset($word[1])) {
					unset($arrTmp[$k]);
				} else {
					$arrTmp[$k] = $word;
				}

				//Attempt to adjust really long strings (>254 chars)
				//Try to break into smaller pieces
				if (isset($word[253])) {
					if (!ctype_alnum($word)) {
						$arrLongWord = preg_split('/[\W]+/u', $word, -1, PREG_SPLIT_NO_EMPTY);
						$arrAdditionalWords = array_merge($arrAdditionalWords, $arrLongWord);
						unset($arrTmp[$k]);
					} else {
						//Can't break it up so truncate it
						$word = substr($word, 0, 254);
						$arrTmp[$k] = $word;
					}
				}
			}

			if (!empty($arrAdditionalWords)) {
				$arrTmp = array_merge($arrTmp, $arrAdditionalWords);
			}

			if (!empty($arrTmp)) {
				$input = join(' ', $arrTmp);
			} else {
				$input = '';
			}
		}

		return $input;
	}

	public static function parseKeywordsForSearch($input, $preparationType='index')
	{
		// sanity check length
		if (!isset($input[0])) {
			return $input;
		}

		// Validate UTF-8 input
		//$isValid = self::validateUtf8Input($input);

		// Need to confirm a UTF-8 safe detection technique for this
		$whitespace = true;
		//$locale = setlocale(LC_ALL, "0");

		//$arrCodePoints = self::parseUtf8StringIntoHexCodes($input);

		// Single space
		// Replace characters with a single space (Unicode code point U+0020, or 0x20 in UTF-8 hex)
		// Remove all Unicode Control characters \p{C}
		// Remove all Unicode Whitespace characters \p{Z} (Single Space)
		// C, Z
		// Cannot call \p{S} before strip_tags (Data::removeHtml()) becuase the "=" and "<" and ">" will be removed
		$input = preg_replace('/[\p{C}\p{Z}]+/SuX', ' ', $input, -1);

//		$input = trim($input);

		// sanity check length
		if (!isset($input[0])) {
			return $input;
		}

		//Remove html entities and tags
		if (!ctype_alnum($input)) {
			// Strip JavaScript
			if (is_int(strpos($input, '<script'))) {
				$input = preg_replace('/\<script.+?\<\/script\>/SuX', ' ', $input, -1);
//				$input = trim($input);
			}

			$input = Data::removeHtml($input);
//			$input = trim($input);

			// Single space...now that above UTF-8 version was done we will just have standard whitespace to deal with
			// IS THIS OKAY HERE???
			// IS THIS OKAY HERE???
			//$input = preg_replace('/\s+/', ' ', $input, -1);
			//$input = trim($input);

			// sanity check length
			if (!isset($input[0])) {
				return $input;
			}
		}

		// Remove all Unicode Symbol characters \p{S}
		// E.g. ™®©
		$input = preg_replace('/[\p{S}]+/SuX', ' ', $input, -1);
//		$input = trim($input);

		// Remove all Unicode punctuation characters \p{P} except "."
		// Pc, Pd, Pe, Pf, Pi, Po (except "."), Ps
		// First find/replace "." with a control code so it can be added back afterwards
		/*
		$input = preg_replace('/[\x{002E}]+/SuX', '®', $input, -1);
		$input = preg_replace('/[\p{P}]+/SuX', ' ', $input);
		$input = trim($input);
		$input = preg_replace('/®/SuX', '.', $input, -1);
		$input = trim($input);
		*/
		// str_replace() is safe to use with well-formed UTF-8 strings
		$input = str_replace('.', '®', $input);
		$input = preg_replace('/[\p{P}]+/SuX', ' ', $input);
//		$input = trim($input);
		$input = str_replace('®', '.', $input);
//		$input = trim($input);

		// Remove single characters
		//$arrInput = preg_split('/[\p{C}\p{L}\p{M}\p{N}\p{P}\p{S}\p{Z}]+/SuX', $input, -1, PREG_SPLIT_NO_EMPTY);
		//$arrInput = preg_split('/([\p{Z}]+|[\p{Z}]{})/SuX', $input, -1, PREG_SPLIT_NO_EMPTY);

		// Lowercase (UTF-8 safe via mbstring.func_overload)
		$input = mb_strtolower($input);

		//3a) Split on whitespace
		//$arrWords = preg_split('/[\p{Z}]+/SuX', $input, -1, PREG_SPLIT_NO_EMPTY);
		//$arrWords = preg_split('/\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);
//		$input = preg_replace('/[\x{0020}]+/SuX', ' ', $input, -1);
//		$input = trim($input);
		// explode() is safe to use with well-formed UTF-8 strings
		$arrWords = explode(' ', $input);
//		$arrWords = preg_split('/[ ]+/SuX', $input, -1, PREG_SPLIT_NO_EMPTY);
		/*
		if ($whitespace) {
			$arrWords = preg_split('/[\s]+/SuX', $input, -1, PREG_SPLIT_NO_EMPTY);
		} else {
			$arrWords = array($input);
		}
		*/

		//3b) Conditionally array_unique if search query
		//if there was no whitespace to begin with then no need for this
		/*
		if ($whitespace && $preparationType == 'query') {
			$arrWords = array_unique($arrWords);
		}
		*/

		// THESE STEPS ARE NO LONGER RELEVANT NOW THAT WE STRIP UNICODE categories
		//4) Iterate across list of strings and do the following
		//  a) Find word boundaries and replace with empty string ('')
		//  b) Eliminate single character strings
		//  c) Filter stop words
		//  d) Conditionally array_unique after all other operations
		// Move this method call to a parent calling function to avoid it being called per loop iteration
		$arrStopWords = Search::fetchStopWords();
		$arrStoppedWords = array();
		$arrAdditionalWords = array();
		$arrSearchWords = array();
		foreach ($arrWords as $k => $word) {
			// Validate UTF-8 input
			//$isValid = self::validateUtf8Input($input);

			// Trim leading and traling "."
			$word = trim($word, ".");
			// Get length of word
			$length = mb_strlen($word);
//			$length = strlen(utf8_decode($word));
//			$length1 = strlen($word);
			if (($length < 2) || ($length > 255)) {
				unset($arrWords[$k]);
				if (!isset($arrStoppedWords[$word])) {
 					$arrStoppedWords[$word] = 1;
				} else {
					/*
					$count = $arrStoppedWords[$word];
					$count++;
					$arrStoppedWords[$word] = $count;
					*/
					$arrStoppedWords[$word]++;
				}
			} else {
				// filter stop words and get a unique list of words
				if (isset($arrStopWords[$word])) {
					unset($arrWords[$k]);
					if (!isset($arrStoppedWords[$word])) {
	 					$arrStoppedWords[$word] = 1;
					} else {
						/*
						$count = $arrStoppedWords[$word];
						$count++;
						$arrStoppedWords[$word] = $count;
						*/
						$arrStoppedWords[$word]++;
					}
				} elseif (!isset($arrSearchWords[$word])) {
					// include the search keyword
					$arrSearchWords[$word] = 1;
				} elseif (isset($arrSearchWords[$word])) {
					// include the search keyword
					/*
					$count = $arrSearchWords[$word];
					$count++;
					$arrSearchWords[$word] = $count;
					*/
					$arrSearchWords[$word]++;
				}
			}
		}

		/*
		if (!empty($arrStoppedWords)) {
			$arrStoppedWords = array_keys($arrStoppedWords);
		}
		*/

		$arrReturn = array(
			'keywords' => $arrSearchWords,
			'stopwords' => $arrStoppedWords

		);

		return $arrReturn;
	}

	public static function utf8Ord($char)
	{
		$length = mb_strlen($char);
		if (!isset($char) || ($length != 1)) {
			throw new Exception('Invalid character input');
		}
		$ucs_4be_mb_char = mb_convert_encoding($char, 'UCS-4BE', 'UTF-8');
		$d = unpack('N', $ucs_4be_mb_char);
		$ord = $d[1];

		return $ord;
	}

	public static function validateUtf8Input($input)
	{
		$output = iconv("UTF-8", "UTF-8", $input);

		if ($input == $output) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
