<?php

/**
 * Define hex2bin() if it does not exist.
 * hex2bin() was added in PHP 5.4.0
 */
if (!function_exists('hex2bin')) {
	function hex2bin($hexData)
	{
		$strlen = strlen($hexData);
		$evenNumberOfHexDigits = $strlen % 2;
		if ($evenNumberOfHexDigits > 0) {
			$hexData = "0$hexData";
		}

		$binaryData = pack("H*" , $hexData);

		return $binaryData;
	}
}
