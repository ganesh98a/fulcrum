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
 * UUID generator.
 *
 * @category	Framework
 * @package		UUID
 *
 */

class UniversallyUniqueIdentifier
{
	/**
	 * There are two different ways of generating a UUID.
	 *
	 * If you just need a unique ID, you want a version 1 or version 4.
	 * If you need to always generate the same UUID from a given name, you want a version 3 or version 5.
	 *
	 * Version 3:
	 * This generates a unique ID from an MD5 hash of a namespace and name.
	 * If you need backwards compatibility (with another system that generates UUIDs from names), use this.
	 *
	 * @param string $namespace
	 * @param string $name
	 * @return string
	 */
	public static function version3($namespace, $name)
	{
		$uuidIsValidFlag = self::uuidIsValid($namespace);
		if (!$uuidIsValidFlag) {
			return false;
		}

		// Get hexadecimal components of namespace
		$nhex = str_replace(array('-','{','}'), '', $namespace);

		// Binary Value
		$nstr = '';

		// Convert Namespace UUID to bits
		for($i = 0; $i < strlen($nhex); $i+=2) {
			$nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
		}

		// Calculate hash value
		$hash = md5($nstr . $name);

		$version3_uuid = sprintf('%08s-%04s-%04x-%04x-%12s',

			// 32 bits for "time_low"
			substr($hash, 0, 8),

			// 16 bits for "time_mid"
			substr($hash, 8, 4),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 3
			(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

			// 48 bits for "node"
			substr($hash, 20, 12)
		);

		return $version3_uuid;
	}

	/**
	 * There are two different ways of generating a UUID.
	 *
	 * If you just need a unique ID, you want a version 1 or version 4.
	 * If you need to always generate the same UUID from a given name, you want a version 3 or version 5.
	 *
	 * Version 1:
	 * This generates a unique ID based on a network card MAC address and a timer.
	 * These IDs are easy to predict (given one, I might be able to guess another one) and can be traced back to your network card.
	 * It's not recommended to create these.
	 *
	 * Version 4:
	 * These are generated from random (or pseudo-random) numbers.
	 * If you just need to generate a UUID, this is probably what you want.
	 *
	 * Version 4 UUIDs use a scheme relying only on random numbers.
	 *
	 * @return string
	 */
	public static function version4()
	{
		$version4_uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

			// 32 bits for "time_low"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),

			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,

			// 48 bits for "node"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);

		return $version4_uuid;
	}

	/**
	 * There are two different ways of generating a UUID.
	 *
	 * If you just need a unique ID, you want a version 1 or version 4.
	 * If you need to always generate the same UUID from a given name, you want a version 3 or version 5.
	 *
	 * Version 5:
	 * This generates a unique ID from an SHA-1 hash of a namespace and name.
	 * This is the preferred version.
	 *
	 * @param string $namespace
	 * @param string $name
	 * @return string
	 */
	public static function version5($namespace, $name)
	{
		$uuidIsValidFlag = self::uuidIsValid($namespace);
		if (!$uuidIsValidFlag) {
			return false;
		}

		// Get hexadecimal components of namespace
		$nhex = str_replace(array('-','{','}'), '', $namespace);

		// Binary Value
		$nstr = '';

		// Convert Namespace UUID to bits
		for($i = 0; $i < strlen($nhex); $i+=2) {
			$nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
		}

		// Calculate hash value
		$hash = sha1($nstr . $name);

		$version5_uuid = sprintf('%08s-%04s-%04x-%04x-%12s',

			// 32 bits for "time_low"
			substr($hash, 0, 8),

			// 16 bits for "time_mid"
			substr($hash, 8, 4),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 5
			(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

			// 48 bits for "node"
			substr($hash, 20, 12)
		);

		return $version5_uuid;
	}

	/**
	 * Validate a UUID
	 *
	 * @param string $uuid
	 * @return boolean
	 */
	public static function uuidIsValid($uuid)
	{
		$uuidIsValidFlag = preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid);

		if ($uuidIsValidFlag === 1) {
			return true;
		} else {
			return false;
		}
	}
}
