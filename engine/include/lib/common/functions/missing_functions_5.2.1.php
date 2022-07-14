<?php

/**
 * Define sys_get_temp_dir() if it does not exist.
 * sys_get_temp_dir() was added in PHP 5.2.1
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
