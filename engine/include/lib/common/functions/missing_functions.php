<?php

/**
 * Define sys_get_temp_dir() if it does not exist
 */
if (!function_exists('sys_get_temp_dir')) {
	function sys_get_temp_dir()
	{
		if (isset($_ENV) && !empty($_ENV)) {
			if (!empty($_ENV['TMP'])) {
				$tmp = $_ENV['TMP'];
				$tempPath = realpath($tmp);
				return $tempPath;
			}

			if (!empty($_ENV['TMPDIR'])) {
				$tmp = $_ENV['TMPDIR'];
				$tempPath = realpath($tmp);
				return $tempPath;
			}

			if (!empty($_ENV['TEMP'])) {
				$tmp = $_ENV['TEMP'];
				$tempPath = realpath($tmp);
				return $tempPath;
			}
		}

		$file = __FILE__;
		$tempfile = tempnam($file, '');
		if (file_exists($tempfile)) {
			unlink($tempfile);
			$dirName = dirname($tempfile);
			$tempPath = realpath($dirName);
			return $tempPath;
		}

		return null;
	}
}

/**
 * Define hex2bin() if it does not exist
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
