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
 * Validation Class for uniform server-side form validation.
 *
 * Validate email, form fields, credit cards, etc.
 *
 * PHP version 5
 *
 * @category	Data
 * @package		Validate
 * @uses		PEAR/Net/SMTP.php
 *
 */

/**
 * Zend_Validate
 *
 */

class Validate
{
	const CC_VISA = 'VISA';
	const CC_MC = 'MASTERCARD';
	const CC_AMEX = 'AMEX';
	const CC_DISCOVER = 'DISCOVER';
	const CC_DINERS_CLUB = 'DINERS';
	const CC_CARTBLANCHE = 'CARTBLANCHE';
	const CC_ENROUTE = 'ENROUTE';
	const CC_JCB = 'JCB';

	protected $validEmailRegex = '^[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*@[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*$';
	private static $_instance;

	/*
	public function __construct()
	{
		$this->validEmailRegex = '^[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*@[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*$';
	}
	*/

	static function getInstance()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new Validation();
		}
		return self::$_instance;
	}

	public function getValidEmailRegex() { return $this->validEmailRegex; }

	public function setValidEmailRegex($input = null) { $this->validEmailRegex = null; }

	/**
	 * Confirm that a DNS domain name is valid and actually exists as an Internet Domain.
	 * Input: dns name as a string
	 * Output: Returns true on success and false on failure
	 * Action: None, returns boolean only
	 *
	 * @param string $domain
	 * @return bool
	 */
	public function validateDomain($domain)
	{
		if (!isset($domain)) {
			return false;
		}
		if (checkdnsrr($domain, 'ANY')) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Confirm that two form text/textarea, etc. input fields are indentical.
	 *
	 * Input: two field values
	 * Output: Returns true on success and false on failure
	 * Action: None, returns boolean only
	 *
	 * @param string $field1
	 * @param string $field2
	 * @return bool
	 */
	public function equivalentFields($field1, $field2)
	{
		if (!isset($field1) || !isset($field2)) {
			throw new Exception('');
		} elseif ($field1 == $field2) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Confirm that two form text/textarea, etc. input fields are exactly indentical.
	 *
	 * Input: two paramaters
	 * Output: Returns true on success and false on failure
	 * Action: None, returns boolean only
	 *
	 * @param string $field1
	 * @param string $field2
	 * @return bool
	 */
	public function exactlyEquivalentFields($field1, $field2)
	{
		if (!isset($field1) || !isset($field2)) {
			throw new Exception('');
		} elseif ($field1 === $field2) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Confirm that a group of form text/textarea, etc. input fields are identical.
	 *
	 * Input: array of form fields that should be equivalent
	 * Output: Returns true on success and false on failure
	 * Action: None, returns boolean only
	 *
	 * @param array $arrFields
	 * @return bool
	 */
	public function equivalentBulkFields($arrFields)
	{
		if (!is_array($arrFields)) {
			throw new Exception('');
		}

		$start = true;

		foreach ($arrFields as $value) {
			if ($start) {
				$field = $value;
				$start = false;
			}
			if ($field != $value) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Confirm that a group of form text/textarea, etc. input fields are exactly identical.
	 *
	 * Input: array of form fields that should be equivalent
	 * Output: Returns true on success and false on failure
	 * Action: None, returns boolean only
	 *
	 * @param array $arrFields
	 * @return bool
	 */
	public function exactlyEquivalentBulkFields($arrFields = array())
	{
		if (!is_array($arrFields)) {
			throw new Exception('');
		}

		$start = true;

		foreach ($arrFields as $value) {
			if ($start) {
				$field = $value;
				$start = false;
			}
			if (!($field === $value)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Confirm that an email address is RFC 2822 compliant.
	 *
	 * Input: email address
	 * Output: Returns true on success and false on failure
	 * Action: None, returns boolean only
	 *
	 * @param string $emailAddress
	 * @return bool
	 */
	public function emailValidate($emailAddress)
	{
		if (!isset($emailAddress)) {
			throw new Exception('');
		}

		//E-Mail Address --> not empty and RFC 2822 valid
		$validEmailRegex = '/'.$this->getValidEmailRegex().'/i';

		if (preg_match($validEmailRegex, $emailAddress)) {
			return true;
		} else {
			return false;
		}
	}

	public static function email($emailAddress)
	{
		$matchedFlag = preg_match('/^[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*@[0-9a-z~!#$%&_-]([.]?[0-9a-z~!#$%&_-])*$/i', $emailAddress);

		if ($matchedFlag) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Validate an email address.
	 *
	 * Provide email address (raw input).
	 * Returns true if the email address has the email	address format and the domain exists.
	 *
	 * @param string $email
	 * @return boolean
	 */
	public static function email2($email)
	{
		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex) {
			$isValid = false;
		} else {
			$domain = substr($email, $atIndex+1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64) {
				// local part length exceeded
				$isValid = false;
			} elseif ($domainLen < 1 || $domainLen > 255) {
				// domain part length exceeded
				$isValid = false;
			} elseif ($local[0] == '.' || $local[$localLen-1] == '.') {
				// local part starts or ends with '.'
				$isValid = false;
			} elseif (preg_match('/\\.\\./', $local)) {
				// local part has two consecutive dots
				$isValid = false;
			} elseif (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				// character not valid in domain part
				$isValid = false;
			} elseif (preg_match('/\\.\\./', $domain)) {
				// domain part has two consecutive dots
				$isValid = false;
			} elseif (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
				// character not valid in local part unless
				// local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
				// domain not found in DNS
				$isValid = false;
			}
		}

		return $isValid;
	}

 	/**
 	 * Confirm that an email address can be reached via response code from SMTP server.
 	 *
	 * Input: email address
	 * Output: Returns true on success and false on failure
	 * Action: Mail deliverability check via socket connection to SMTP server for given email address.
 	 *
	 * @access public
 	 * @param string $emailAddress
 	 * @return bool
 	 */
	public function emailDnsValidate($emailAddress)
	{
		if (!isset($emailAddress) || empty($emailAddress)) {
			throw new Exception("Invalid argument $emailAddress to Validate::emailDnsValidate()");
		}

		require_once('Net/SMTP.php');
		$netSmtp = new Net_SMTP();

        if (PEAR::isError($res = $netSmtp->rcptTo($emailAddress))) {
            return false;
        } else {
			return true;
		}

//		if (!checkdnsrr($emailAddress)) {
//			throw new Exception('Invalid email address');
//		}
	}

	/**
	 * Confirm that two passwords are indentical valid according to established business rules.
	 *
	 * A valid password has the following properties:
	 * 1) A length between an established min and max length.
	 * 2) A combination of chars such as caps, letters, and numbers.
	 * 3) Not a dictionary word.
	 *
	 * Input: two password fields
	 * Output: Returns true on success and false on failure
	 * Action: None, returns boolean only
	 *
	 * @param string $p1
	 * @param string $p2
	 * @param int $maxlength
	 * @return bool
	 */
	public function passwordValidate($p1, $p2, $maxlength = 12)
	{
		if (!isset($p1) || !isset($p2)) {
			throw new Exception('');
		}

		//Password Blank or < 6 chars or > 12 chars or not matching
		if (	(strlen($p1) >= 6) &&
				(strlen($p1) <= $maxlength) &&
				(strlen($p2) >= 6) &&
				(strlen($p2) <= $maxlength) &&
				($p1 === $p2)
			) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Confirm that a credit card number is mathematically valid using mod 10 (luhn checksum).
	 *
	 * Validation against a web service does not occur here.
	 * No type check is performed here.
	 *
	 * Input: number only
	 * Output: Returns true on success and false on failure
	 * Action: None
	 *
	 * @param int $card_number
	 * @return bool
	 */
	public function ccNumberSanityCheck($card_number)
	{
		if (!isset($card_number)) {
			throw new Exception('');
		} elseif (empty($card_number)) {
			return false;
		} elseif (!preg_match('/^[0-9]{13,16}$/', $card_number)) {
			return false;
		}

		// Is the number valid?
		// Run Mod 10 check a.k.a. luhn checksum
		$reversed_card_number = strrev($card_number);
		$num_sum = 0;

		for ($i = 0; $i < strlen($reversed_card_number); $i++) {
			$digit = substr($reversed_card_number, $i, 1);

			// Double every second digit
			if ($i % 2 == 1) {
				$digit *= 2;
			}

			// Add digits of 2-digit numbers together
			if ($digit > 9) {
				$digit_a = $digit % 10;
				$digit_b = ($digit - $digit_a) / 10;
				$digit = $digit_a + $digit_b;
			}

			$num_sum += $digit;
		}

		// If the total has no remainder it's OK
		$pass_check = ($num_sum % 10 == 0);

		if ($pass_check) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Confirm that a credit card number is a valid type that a given site's system accepts.
	 *
	 * Validation against a web service does not occur here.
	 * The type must be one that is accepted by a given site's system.
	 *
	 * Input: number only
	 * Output: Returns true on success and false on failure
	 * Action: None
	 *
	 * @param int $card_number
	 * @return bool
	 */
	public function ccTypeSanityCheck($card_number)
	{
		if (!isset($card_number)) {
			throw new Exception('');
		} elseif (empty($card_number)) {
			return false;
		} elseif (!preg_match('/^[0-9]{13,16}$/', $card_number)) {
			return false;
		}

		$type_found = null;
		$valid_format = false;

		if (ereg("^4[0-9]{12}([0-9]{3})?$", $card_number)) {
			// VISA
			$type_found = Validate::CC_VISA;
			$valid_format = true;
		} elseif (ereg("^5[1-5][0-9]{14}$", $card_number)) {
			// Master Card
			$type_found = Validate::CC_MC;
			$valid_format = true;
		}
		elseif (ereg("^3[47][0-9]{13}$", $card_number)) {
			// American Express
			$type_found = Validate::CC_AMEX;
			$valid_format = true;
		} elseif (ereg("^6011[0-9]{12}$", $card_number)) {
			// Discover
			$type_found = Validate::CC_DISCOVER;
			$valid_format = true;
		} elseif (ereg("^3(0[0-5]|[68][0-9])[0-9]{11}$", $card_number)) {
			// Diner's Card
			$type_found = Validate::CC_DINERS;
			$valid_format = true;
		}

		// Is the number valid?
		// Run Mod 10 a.k.a. luhn checksum
		$reversed_card_number = strrev($card_number);
		$num_sum = 0;

		for ($i = 0; $i < strlen($reversed_card_number); $i++) {
			$digit = substr($reversed_card_number, $i, 1);

			// Double every second digit
			if ($i % 2 == 1) {
				$digit *= 2;
			}

			// Add digits of 2-digit numbers together
			if ($digit > 9) {
				$digit_a = $digit % 10;
				$digit_b = ($digit - $digit_a) / 10;
				$digit = $digit_a + $digit_b;
			}

			$num_sum += $digit;
		}

		// If the total has no remainder it's OK
		$pass_check = ($num_sum % 10 == 0);

		/**
		 * Card must be a valid type that we accept and card number must pass a mod 10 check.
		 */
		if ($valid_format && $pass_check) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Confirm that a credit card's card security code is valid.
	 *
	 * Validation against a web service does not occur here.
	 *
	 * Input: number only
	 * Output: Returns true on success and false on failure
	 * Action: None
	 *
	 * @param int $csc_number
	 * @return bool
	 */
	public function ccCscSanityCheck($csc_number)
	{
		if (!isset($csc_number)) {
			throw new Exception('');
		} elseif (empty($csc_number)) {
			return false;
		} elseif (!preg_match('/^[0-9]{3,4}$/', $csc_number)) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Confirm that a credit card number is mathematically valid using mod 10 (luhn checksum).
	 *
	 * Then validate against a web service such as PayFlowPro.
	 *
	 * Input: array of inputs (number, csc, month, year, name)
	 * Output: Returns true on success and false on failure
	 * Action: Possibly verify using external service
	 *
	 * Returns: boolean or Type if $card_type == null
	 *
	 * @param int $card_number
	 * @param string $card_type
	 * @param int $csc
	 * @param string $date
	 * @return bool
	 */
	public function creditCardValidate($card_number, $card_type = null, $csc = null, $date = null, $combine_type_check = false)
	{
		/**
		 * implement month/year check at later date
		 *
		 * Also card may have expired but still be working
		 */

		if (isset($csc)) {
			// validate csc later
		}
		if (isset($date)) {
			// validate date
		}

		// Make sure the card number isnt empty and all digits
		if (empty($card_number)) {
			return false;
		} elseif (!preg_match('/^[0-9]{13,16}$/', $card_number)) {
			// string has non-numeric chars
			return false;
		}

		$type_found = false;
		$valid_format = false;

		if (ereg("^4[0-9]{12}([0-9]{3})?$", $card_number)) {
			// VISA
			$type_found = Validate::CC_VISA;
			$valid_format = true;
		} elseif (ereg("^5[1-5][0-9]{14}$", $card_number)) {
			// Master Card
			$type_found = Validate::CC_MC;
			$valid_format = true;
		}
		elseif (ereg("^3[47][0-9]{13}$", $card_number)) {
			// American Express
			$type_found = Validate::CC_AMEX;
			$valid_format = true;
		} elseif (ereg("^6011[0-9]{12}$", $card_number)) {
			// Discover
			$type_found = Validate::CC_DISCOVER;
			$valid_format = true;
		} elseif (ereg("^3(0[0-5]|[68][0-9])[0-9]{11}$", $card_number)) {
			// Diner's Card
			$type_found = Validate::CC_DINERS;
			$valid_format = true;
		}

		// Is the number valid?
		// Run Mod 10 a.k.a. luhn checksum
		$reversed_card_number = strrev($card_number);
		$num_sum = 0;

		for ($i = 0; $i < strlen($reversed_card_number); $i++) {
			$digit = substr($reversed_card_number, $i, 1);

			// Double every second digit
			if ($i % 2 == 1) {
				$digit *= 2;
			}

			// Add digits of 2-digit numbers together
			if ($digit > 9) {
				$digit_a = $digit % 10;
				$digit_b = ($digit - $digit_a) / 10;
				$digit = $digit_a + $digit_b;
			}

			$num_sum += $digit;
		}

		// If the total has no remainder it's OK
		$pass_check = ($num_sum % 10 == 0);

		/**
		 * This is really botched up as it decides to force a type input as
		 * a hard coded int arbitrarily set in a drop-down menu.
		 */
//		if ($valid_format && $pass_check) {
//		// credit card number is okay
//			if ($card_type) {
//				if ($type_found == $card_type) {
//					return $type_found;
//				} else {
//					return false;
//				}
//			} else return $type_found;
//		} else {
//			return false;
//		}
		/**
		 * Should have separate check or way to pass back all errors
		 */
		if ($valid_format && $pass_check) {
			if ($combine_type_check) {
				// credit card number is okay so now validate type
				if (isset($card_type)) {
					if ($type_found == strtoupper($card_type)) {
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

    public static function gtin($value)
    {
        $barcode = substr($value, 0, -1);
        $sum     = 0;
        $length  = strlen($barcode) - 1;

        for ($i = 0; $i <= $length; $i++) {
            if (($i % 2) === 0) {
                $sum += $barcode[$length - $i] * 3;
            } else {
                $sum += $barcode[$length - $i];
            }
        }

        $calc     = $sum % 10;
        $checksum = ($calc === 0) ? 0 : (10 - $calc);
        if ($value[$length + 1] != $checksum) {
            return false;
        }

        return true;
    }
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
