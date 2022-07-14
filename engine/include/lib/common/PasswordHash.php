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
 * PasswordHash class.
 *
 * PBKDF2 algorithm partially derived from - havoc AT defuse.ca - https://defuse.ca/php-pbkdf2.htm
 *
 * Password-Based Key Derivation Function 2 (PBKDF2) Test Vectors:
 * https://www.ietf.org/rfc/rfc6070.txt
 * Salt input as raw.
 * Hash output as hex.
 * Salt input format as raw.
 *
 * Stanford Javascript Crypto Library:
 * http://bitwiseshiftleft.github.com/sjcl/demo/
 * Salt input as hex.
 * Hash output as hex.
 * Salt input format as raw.
 *
 * @category	Framework
 * @package		PasswordHash
 */

class PasswordHash
{
	// These constants may be changed without breaking existing hashes.
	const PBKDF2_HASH_ALGORITHM = 'sha256';
	const PBKDF2_ITERATIONS = 100;
	const PBKDF2_HASH_BYTES = 32;
	const PBKDF2_SALT_BYTES = 32;

	// These constants should not be changed unless all passwords are reset or refactored.
	const HASH_SECTIONS = 4;
	const HASH_ALGORITHM_INDEX = 0;
	const HASH_ITERATION_INDEX = 1;
	const HASH_SALT_INDEX = 2;
	const HASH_PBKDF2_INDEX = 3;

	const PBKDF2_HASH_ENCODING = 'base64';
	//const PBKDF2_HASH_ENCODING = 'hex';
	//const PBKDF2_HASH_ENCODING = 'raw';

	const PBKDF2_SALT_ENCODING = 'base64';
	//const PBKDF2_SALT_ENCODING = 'hex';
	//const PBKDF2_SALT_ENCODING = 'raw';

	const PBKDF2_SALT_INPUT_ENCODING = 'raw';

	private static $classInitialized = false;
	private static $saltFunction;
	private static $randSource;

	private $plaintextPassword;

	private $passwordHashingAlgorithm;
	private $iterations;
	private $passwordHashSizeInBytes;
	private $saltSizeInBytes;
	private $passwordHashEncoding;
	private $saltEncoding;
	private $saltInputEncoding;

	private $saltBase64;
	private $saltHex;
	private $saltRaw;

	private $passwordHashRaw;
	private $passwordHashBase64;
	private $passwordHashHex;

	private $formattedPasswordHash;

	private $hashTime;

	/**
	 * Passing in a salt allows a pre-known salt to be used to verify a password with it. The outputted hash should be deterministic with a fixed salt.
	 *
	 * Output format: algorithm:iterations:salt:hash
	 *
	 * @param string $password
	 * @param string $salt
	 * @return string
	 */
	public static function create_hash($password)
	{
		$passwordHash = new PasswordHash();
		$passwordHash->setPlaintextPassword($password);
		$passwordHash->createSalt();
		$passwordHash->hashPassword();

		return $passwordHash;
	}

	public function hashPassword($password=null, $salt=null, $saltFormat=null)
	{
		if (isset($password)) {
			$this->plaintextPassword = $password;
		}

		if (isset($salt) && !empty($salt) && isset($saltFormat) && !empty($saltFormat)) {
			if ($saltFormat == 'base64') {

				$saltBase64 = $salt;
				// convert salt
				$saltRaw = base64_decode($saltBase64);
				$saltHex = bin2hex($saltRaw);

			} elseif ($saltFormat == 'hex') {

				$saltHex = $salt;
				// convert salt
				//$saltRaw = hex2bin($salt);
				$saltRaw = pack("H*" , $saltHex);
				$saltBase64 = base64_encode($saltRaw);

			} elseif ($saltFormat = 'raw') {

				$saltRaw = $salt;
				// convert salt
				$saltHex = bin2hex($saltRaw);
				$saltBase64 = base64_encode($saltRaw);

			}

			$this->saltBase64 = $saltBase64;
			$this->saltRaw = $saltRaw;
			$this->saltHex = $saltHex;
		}

		$algorithm = $this->passwordHashingAlgorithm;
		$password = $this->plaintextPassword;
		$salt = $this->getSalt();
		$count = $this->iterations;
		$derivedKeyLength = $this->passwordHashSizeInBytes;
		$rawFormat = true;

		$timeStart = microtime(true);
		$passwordHashRaw = self::pbkdf2($algorithm, $password, $salt, $count, $derivedKeyLength, $rawFormat);
		$timeStop = microtime(true);
		$timeTotal = $timeStop - $timeStart;
		$this->setHashTime($timeTotal);

		$this->setPasswordHashRaw($passwordHashRaw, true);
	}

	public static function validate_password($password, $good_hash)
	{
		$passwordHash = self::findPasswordHashByFormattedPasswordHash($good_hash);
		/* @var $passwordHash PasswordHash */

		$knownHash = $passwordHash->getPasswordHashRaw();

		$algorithm = $passwordHash->getPasswordHashingAlgorithm();
		$salt = $passwordHash->getSalt();
		$count = $passwordHash->getIterations();
		$derivedKeyLength = $passwordHash->getPasswordHashSizeInBytes();

		$newHash = self::pbkdf2($algorithm, $password, $salt, $count, $derivedKeyLength, true);

		$passwordValidFlag = self::slow_equals($knownHash, $newHash);

		return $passwordValidFlag;
	}

	public static function findPasswordHashByFormattedPasswordHash($formattedPasswordHash)
	{
		$formattedPasswordHashSectionCount = self::HASH_SECTIONS;

		$arrHashComponents = explode(":", $formattedPasswordHash);
		if (count($arrHashComponents) <> $formattedPasswordHashSectionCount) {
			throw new Exception('Invalid formatted password hash.');
		}

		$algorithmIndex = self::HASH_ALGORITHM_INDEX;
		$iterationsIndex = self::HASH_ITERATION_INDEX;
		$saltIndex = self::HASH_SALT_INDEX;
		$hashIndex = self::HASH_PBKDF2_INDEX;

		$passwordHashingAlgorithm = $arrHashComponents[$algorithmIndex];
		$iterations = $arrHashComponents[$iterationsIndex];
		$salt = $arrHashComponents[$saltIndex];
		$hash = $arrHashComponents[$hashIndex];

		$passwordHashEncoding = self::PBKDF2_HASH_ENCODING;
		$saltEncoding = self::PBKDF2_SALT_ENCODING;

		$passwordHash = new PasswordHash($passwordHashingAlgorithm, $iterations);

		if ($passwordHashEncoding == 'base64') {
			$passwordHash->setPasswordHashBase64($hash, true);
		} elseif ($passwordHashEncoding == 'hex') {
			$passwordHash->setPasswordHashHex($hash, true);
		} elseif ($passwordHashEncoding == 'raw') {
			$passwordHash->setPasswordHashRaw($hash, true);
		} else {
			$passwordHash->setPasswordHashBase64($hash, true);
		}

		if ($saltEncoding == 'base64') {
			$passwordHash->setSaltBase64($salt, true);
		} elseif ($saltEncoding == 'hex') {
			$passwordHash->setSaltHex($salt, true);
		} elseif ($saltEncoding == 'raw') {
			$passwordHash->setSaltRaw($salt, true);
		} else {
			$passwordHash->setSaltBase64($salt, true);
		}

		return $passwordHash;
	}

	// Compares two strings $a and $b in length-constant time.
	public static function slow_equals($a, $b)
	{
		$diff = strlen($a) ^ strlen($b);
		for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
		{
			$diff |= ord($a[$i]) ^ ord($b[$i]);
		}
		return $diff === 0;
	}

	private static function initClass()
	{
		$classInitialized = self::$classInitialized;

		if (!$classInitialized) {
			$systemVerifiedFlag = self::testSystem();
			if (!$systemVerifiedFlag) {
				throw new Exception('PBKDF2 ERROR: Invalid hash algorithm.');
			}

			if (function_exists('mcrypt_create_iv')) {
				$saltFunction = 'csprngViaMcryptCreateIv';
				$operatingSystem = PHP_OS;
				if ($operatingSystem == 'WINNT') {
					$randSource = MCRYPT_RAND;
				} else {
					$randSource = MCRYPT_DEV_URANDOM;
				}
				self::$randSource = $randSource;
			} elseif (function_exists('openssl_random_pseudo_bytes')) {
				$saltFunction = 'csprngViaOpensslRandomPseudoBytes';
			} else {
				$saltFunction = 'csprngViaInsecureHack';
			}

			self::$saltFunction = $saltFunction;
			self::$classInitialized = true;
		}
	}

	public function getHashTime($significantDigits = 5)
	{
		$time = $this->hashTime;
		$time = round($time, $significantDigits);

		return $time;
	}

	public function setHashTime($time)
	{
		$this->hashTime = $time;
	}

	public function getPhpSaltFunction()
	{
		$saltFunction = self::$saltFunction;


		switch ($saltFunction) {
			case 'csprngViaMcryptCreateIv':
				$phpSaltFunction = 'mcrypt_create_iv()';
				break;

			case 'csprngViaOpensslRandomPseudoBytes':
				$phpSaltFunction = 'openssl_random_pseudo_bytes()';
				break;

			case 'csprngViaInsecureHack':
				$phpSaltFunction = 'mt_rand()';
				break;

			default:
				$phpSaltFunction = '';
				break;
		}

		return $phpSaltFunction;
	}

	public function getPasswordHashingAlgorithm()
	{
		if (!isset($this->passwordHashingAlgorithm)) {
			$this->passwordHashingAlgorithm = self::PBKDF2_HASH_ALGORITHM;
		}

		return $this->passwordHashingAlgorithm;
	}

	public function setPasswordHashingAlgorithm($passwordHashingAlgorithm)
	{
		$this->passwordHashingAlgorithm = $passwordHashingAlgorithm;
	}

	public function getPlaintextPassword()
	{
		return $this->plaintextPassword;
	}

	public function setPlaintextPassword($plaintextPassword)
	{
		$this->plaintextPassword = $plaintextPassword;
	}

	public function getIterations()
	{
		return $this->iterations;
	}

	public function setIterations($iterations)
	{
		$this->iterations = $iterations;
	}

	public function getPasswordHashSizeInBytes()
	{
		return $this->passwordHashSizeInBytes;
	}

	public function setPasswordHashSizeInBytes($passwordHashSizeInBytes)
	{
		$this->passwordHashSizeInBytes = $passwordHashSizeInBytes;
	}

	public function getSaltSizeInBytes()
	{
		return $this->saltSizeInBytes;
	}

	public function setSaltSizeInBytes($saltSizeInBytes)
	{
		$this->saltSizeInBytes = $saltSizeInBytes;
	}

	public function getPasswordHashEncoding()
	{
		return $this->passwordHashEncoding;
	}

	public function setPasswordHashEncoding($passwordHashEncoding)
	{
		$this->passwordHashEncoding = $passwordHashEncoding;
	}

	public function getSaltEncoding()
	{
		return $this->saltEncoding;
	}

	public function setSaltEncoding($saltEncoding)
	{
		$this->saltEncoding = $saltEncoding;
	}

	public function getSalt()
	{
		$saltInputEncoding = $this->getSaltInputEncoding();
		if ($saltInputEncoding == 'base64') {
			$salt = $this->getSaltBase64();
		} elseif ($saltInputEncoding == 'hex') {
			$salt = $this->getSaltHex();
		} elseif ($saltInputEncoding == 'raw') {
			$salt = $this->getSaltRaw();
		} else {
			$salt = $this->getSaltRaw();
		}

		return $salt;
	}

	public function getSaltInputEncoding()
	{
		return $this->saltInputEncoding;
	}

	public function setSaltInputEncoding($saltInputEncoding)
	{
		$this->saltInputEncoding = $saltInputEncoding;
	}

	public function getSaltBase64()
	{
		if (!isset($this->saltRaw)) {
			$this->createSalt();
		}

		if (!isset($this->saltBase64)) {
			$this->saltBase64 = base64_encode($this->saltRaw);
		}

		return $this->saltBase64;
	}

	public function setSaltBase64($saltBase64, $deriveOtherSaltFormats=false)
	{
		$this->saltBase64 = $saltBase64;

		if ($deriveOtherSaltFormats) {
			$saltRaw = base64_decode($saltBase64);
			$saltHex = bin2hex($saltRaw);
			$this->saltRaw = $saltRaw;
			$this->saltHex = $saltHex;
			$saltSizeInBytes = (strlen($saltHex) / 2);
			$this->saltSizeInBytes = $saltSizeInBytes;
		}
	}

	public function getSaltHex()
	{
		if (!isset($this->saltRaw)) {
			$this->createSalt();
		}

		if (!isset($this->saltHex)) {
			$this->saltHex = bin2hex($this->saltRaw);
		}

		return $this->saltHex;
	}

	public function setSaltHex($saltHex, $deriveOtherSaltFormats=false)
	{
		$saltHex = strtolower($saltHex);
		// E.g. "78 57 8E 5A 5D 63 CB 06" to "78578e5a5d63cb06"
		$saltHex = preg_replace('/[^0-9a-z]+/', '', $saltHex);
		$this->saltHex = $saltHex;
		$saltSizeInBytes = (strlen($saltHex) / 2);
		$this->saltSizeInBytes = $saltSizeInBytes;

		if ($deriveOtherSaltFormats) {
			$saltRaw = hex2bin($saltHex);
			$saltBase64 = base64_encode($saltRaw);
			$this->saltRaw = $saltRaw;
			$this->saltBase64 = $saltBase64;
		}
	}

	public function getSaltRaw()
	{
		if (!isset($this->saltRaw)) {
			$this->createSalt();
		}

		return $this->saltRaw;
	}

	public function setSaltRaw($saltRaw, $deriveOtherSaltFormats=false)
	{
		$this->saltRaw = $saltRaw;

		if ($deriveOtherSaltFormats) {
			$saltBase64 = base64_encode($saltRaw);
			$saltHex = bin2hex($saltRaw);
			$this->saltBase64 = $saltBase64;
			$this->saltHex = $saltHex;
			$saltSizeInBytes = (strlen($saltHex) / 2);
			$this->saltSizeInBytes = $saltSizeInBytes;
		}
	}

	public function getPasswordHashBase64($derivedKeyLength=null)
	{
		if (!isset($this->passwordHashBase64)) {
			$this->passwordHashBase64 = base64_encode($this->passwordHashRaw);
		}

		return $this->passwordHashBase64;
	}

	public function setPasswordHashBase64($passwordHashBase64, $deriveOtherPasswordHashFormats=false)
	{
		$this->passwordHashBase64 = $passwordHashBase64;

		if ($deriveOtherPasswordHashFormats) {
			$passwordHashRaw = base64_decode($passwordHashBase64);
			$passwordHashHex = bin2hex($passwordHashRaw);
			$this->passwordHashRaw = $passwordHashRaw;
			$this->passwordHashHex = $passwordHashHex;
			$passwordHashSizeInBytes = (strlen($passwordHashHex) / 2);
			$this->passwordHashSizeInBytes = $passwordHashSizeInBytes;
		}
	}

	public function getPasswordHashHex($derivedKeyLength=null, $fancyFormattingFlag = false)
	{
		if (!isset($this->passwordHashHex)) {
			$this->passwordHashHex = bin2hex($this->passwordHashRaw);
		}

		if ($fancyFormattingFlag) {
			$formattedHex = $this->passwordHashHex;
			$formattedHex = strtoupper($formattedHex);
			$arrTmp = str_split($formattedHex, 2);
			$formattedHex = join(' ', $arrTmp);

			return $formattedHex;
		}

		return $this->passwordHashHex;
	}

	public function setPasswordHashHex($passwordHashHex, $deriveOtherPasswordHashFormats=false)
	{
		$passwordHashHex = strtolower($passwordHashHex);
		// E.g. "78 57 8E 5A 5D 63 CB 06" to "78578e5a5d63cb06"
		$passwordHashHex = preg_replace('/[^0-9a-z]+/', '', $passwordHashHex);
		$this->passwordHashHex = $passwordHashHex;
		$passwordHashSizeInBytes = (strlen($passwordHashHex) / 2);
		$this->passwordHashSizeInBytes = $passwordHashSizeInBytes;

		if ($deriveOtherPasswordHashFormats) {
			$passwordHashRaw = hex2bin($passwordHashHex);
			$passwordHashBase64 = base64_encode($passwordHashRaw);
			$this->passwordHashRaw = $passwordHashRaw;
			$this->passwordHashBase64 = $passwordHashBase64;
		}
	}

	/**
	 * The $derivedKeyLength is the desired length in bytes of the password hash aka "Derived Key Length"
	 *
	 * @param int $derivedKeyLength	Length of the Derived Key (password hash) in bytes.
	 * @return raw password hash
	 */
	public function getPasswordHashRaw($derivedKeyLength=null)
	{
		if (!isset($this->passwordHashRaw)) {
			return '';
		}

		if (!isset($derivedKeyLength) || empty($derivedKeyLength)) {
			// $this->passwordHashRaw should be the default length (max) of the hash algorithm used
			// sha256 generates a 256 bit hash or 32 bytes so the derived key (hash) would be 32 bytes by default
			return $this->passwordHashRaw;
		}

		$derivedKeyLength = (int) $derivedKeyLength;
		// Class constant should be the maximum for a given hash algorithm.
		$defaultDerivedKeyLength = self::PBKDF2_HASH_BYTES;

		if ($derivedKeyLength <> $defaultDerivedKeyLength) {
			$tmpPasswordHashHexFullLength = bin2hex($this->passwordHashRaw);
			// Two hexits per byte so mulitply by two.
			$tmpPasswordHashHexTruncated = substr($tmpPasswordHashHexFullLength, 0, ($derivedKeyLength*2));
			// Convert hex back to binary/raw format.
			$passwordHashRawTruncated = pack("H*" , $tmpPasswordHashHexTruncated);

			// Return the derived key for the desired length.
			return $passwordHashRawTruncated;
		}

		return $this->passwordHashRaw;
	}

	public function setPasswordHashRaw($passwordHashRaw, $deriveOtherPasswordHashFormats=false)
	{
		$this->passwordHashRaw = $passwordHashRaw;

		if ($deriveOtherPasswordHashFormats) {
			$passwordHashBase64 = base64_encode($passwordHashRaw);
			$passwordHashHex = bin2hex($passwordHashRaw);
			$this->passwordHashBase64 = $passwordHashBase64;
			$this->passwordHashHex = $passwordHashHex;
			$passwordHashSizeInBytes = (strlen($passwordHashHex) / 2);
			$this->passwordHashSizeInBytes = $passwordHashSizeInBytes;
		}
	}

	public function getFormattedPasswordHashOutput()
	{
		$passwordHashEncoding = $this->getPasswordHashEncoding();
		$saltEncoding = $this->getSaltEncoding();

		$algorithm = $this->getPasswordHashingAlgorithm();
		$iterations = $this->getIterations();

		if ($passwordHashEncoding == 'base64') {
			$passwordHash = $this->getPasswordHashBase64();
		} elseif ($passwordHashEncoding == 'hex') {
			$passwordHash = $this->getPasswordHashHex();
		} elseif ($passwordHashEncoding == 'raw') {
			$passwordHash = $this->getPasswordHashRaw();
		} else {
			$passwordHash = $this->getPasswordHashBase64();
		}

		if ($saltEncoding == 'base64') {
			$salt = $this->getSaltBase64();
		} elseif ($saltEncoding == 'hex') {
			$salt = $this->getSaltHex();
		} elseif ($saltEncoding == 'raw') {
			$salt = $this->getSaltRaw();
		} else {
			$salt = $this->getSaltBase64();
		}

		$formattedPasswordHashOutput = $algorithm . ":" . $iterations . ":" . $salt . ":" . $passwordHash;

		return $formattedPasswordHashOutput;
	}

	public function __toString()
	{
		$formattedPasswordHashOutput = $this->getFormattedPasswordHashOutput();
		return $formattedPasswordHashOutput;
	}

	public function __construct($passwordHashingAlgorithm=null, $iterations=null, $passwordHashSizeInBytes=null, $saltSizeInBytes=null)
	{
		$classInitialized = self::$classInitialized;
		if (!$classInitialized) {
			self::initClass();
		}

		$this->init();

		if (isset($passwordHashingAlgorithm)) {
			$this->passwordHashingAlgorithm = $passwordHashingAlgorithm;
		}

		if (isset($iterations)) {
			$this->iterations = $iterations;
		}

		if (isset($passwordHashSizeInBytes)) {
			$this->passwordHashSizeInBytes = $passwordHashSizeInBytes;
		}

		if (isset($saltSizeInBytes)) {
			$this->saltSizeInBytes = $saltSizeInBytes;
		}
	}

	private function init()
	{
		$this->passwordHashingAlgorithm = self::PBKDF2_HASH_ALGORITHM;
		$this->iterations = self::PBKDF2_ITERATIONS;
		$this->passwordHashSizeInBytes = self::PBKDF2_HASH_BYTES;
		$this->saltSizeInBytes = self::PBKDF2_SALT_BYTES;
		$this->passwordHashEncoding = self::PBKDF2_HASH_ENCODING;
		$this->saltEncoding = self::PBKDF2_SALT_ENCODING;
		$this->saltInputEncoding = self::PBKDF2_SALT_INPUT_ENCODING;

		$this->saltRaw = null;
		$this->saltBase64 = null;
		$this->saltHex = null;

		$this->passwordHashBase64 = null;
		$this->passwordHashHex = null;
		$this->passwordHashRaw = null;
	}

	/**
	 * Create a salt using a CSPRNG (cryptographically secure pseudo-random number generator).
	 *
	 * @param int $saltSizeInBytes
	 * @return string
	 */
	public function createSalt($saltSizeInBytes=null)
	{
		if (isset($saltSizeInBytes) && !empty($saltSizeInBytes)) {
			$this->saltSizeInBytes = $saltSizeInBytes;
		} else {
			$saltSizeInBytes = $this->saltSizeInBytes;
		}

		$saltFunction = self::$saltFunction;
		$saltRaw = $this->$saltFunction($saltSizeInBytes);

		$this->saltRaw = $saltRaw;
	}

	private function csprngViaMcryptCreateIv($sizeInBytes)
	{
		$randSource = self::$randSource;
		$saltRaw = mcrypt_create_iv($sizeInBytes, $randSource);

		return $saltRaw;
	}

	private function csprngViaOpensslRandomPseudoBytes($sizeInBytes)
	{
		$saltRaw = openssl_random_pseudo_bytes($sizeInBytes);

		return $saltRaw;
	}

	private function csprngViaInsecureHack($sizeInBytes)
	{
		$rand = mt_rand();
		$sha1 = sha1($rand);
		$saltRaw = substr($sha1, 0, $sizeInBytes);

		return $saltRaw;
	}

	/*
	 * PBKDF2 key derivation public static function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
	 * $algorithm - The hash algorithm to use. Recommended: SHA256
	 * $password - The password.
	 * $salt - A salt that is unique to the password.
	 * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
	 * $derivedKeyLength - The desired length of the derived key in bytes.
	 * $rawFormat - If true, the key is returned in raw binary format. Hex encoded otherwise.
	 * Returns: A $derivedKeyLength-byte key derived from the password and salt.
	 *
	 * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
	 *
	 * This implementation of PBKDF2 was originally created by https://defuse.ca
	 * With improvements by http://www.variations-of-shadow.com
	 */
	public static function pbkdf2($algorithm, $password, $salt, $count, $derivedKeyLength, $rawFormat = false)
	//public function pbkdf2($rawFormat = false)
	//public function pbkdf2($algorithm, $password, $salt, $count, $derivedKeyLength, $rawFormat = false)
	{
		/*
		$algorithm = $this->passwordHashingAlgorithm;
		$password = $this->plaintextPassword;
		$salt = $this->saltBase64;
		//$salt = $this->saltRaw;
		$count = $this->iterations;
		$derivedKeyLength = $this->passwordHashSizeInBytes;
		*/

		if ($count <= 0 || $derivedKeyLength <= 0) {
			throw new Exception('PBKDF2 ERROR: Invalid parameters.');
		}

		// Pass in false to get the hash() output in hex format
		// Divide the hex digit count by two to get the byte count (2 hexits = 1 byte)
		$tmpPasswordHashHex = hash($algorithm, '', false);
		$defaultHashLengthInBytes = (strlen($tmpPasswordHashHex) / 2);

		if ($derivedKeyLength <> $defaultHashLengthInBytes) {
			$blockCount = ceil($derivedKeyLength / $defaultHashLengthInBytes);
		} else {
			$blockCount = 1;
		}

		$passwordHashRaw = '';
		for ($i = 1; $i <= $blockCount; $i++) {
			// $i encoded as 4 bytes, big endian.
			$pack = pack("N", $i);
			$last = $salt . $pack;

			// first iteration
			$last = $xorsum = hash_hmac($algorithm, $last, $password, true);

			// perform the other $count - 1 iterations
			for ($j = 1; $j < $count; $j++) {
				$last = hash_hmac($algorithm, $last, $password, true);
				$xorsum ^= $last;
			}
			$passwordHashRaw .= $xorsum;
		}

		if ($rawFormat) {
			if ($derivedKeyLength <> $defaultHashLengthInBytes) {
				// Convert to hex to avoid mb_substr() problems if php.ini has mbstring.func_overload set.
				$passwordHashHex = bin2hex($passwordHashRaw);
				$passwordHashHexTruncated = substr($passwordHashHex, 0, ($derivedKeyLength*2));
				$passwordHashRawTruncated = pack("H*" , $passwordHashHexTruncated);
				return $passwordHashRawTruncated;
			}

			return $passwordHashRaw;
		} else {
			// Return password hash as hex encoded
			$passwordHashHex = bin2hex($passwordHashRaw);
			if ($derivedKeyLength <> $defaultHashLengthInBytes) {
				// Already converted to hex don't worry about mb_substr() problems if php.ini has mbstring.func_overload set.
				$passwordHashHexTruncated = substr($passwordHashHex, 0, ($derivedKeyLength*2));
				return $passwordHashHexTruncated;
			}

			return $passwordHashHex;
		}
	}

	private static function testSystem()
	{
		$algorithm = PasswordHash::PBKDF2_HASH_ALGORITHM;
		$algorithm = strtolower($algorithm);
		$arrSystemHashAlgorithms = hash_algos();

		if (in_array($algorithm, $arrSystemHashAlgorithms)) {
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
