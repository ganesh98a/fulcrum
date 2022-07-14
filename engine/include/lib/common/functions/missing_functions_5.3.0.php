<?php

if (!function_exists('checkdnsrr')) {
	function checkdnsrr($host, $type='mx')
	{
		$res=explode("\n",strstr(shell_exec('nslookup -type='.$type.' '.escapeshellarg($host).' 4.2.2.3'),"\n\n"));
		if ($res[2]) {
			return true;
		} else {
			return false;
		}
	}
}

if (!function_exists('dns_check_record')) {
	function dns_check_record($host, $type='mx')
	{
		$result =  checkdnsrr($host, $type);
		return $result;
	}
}

if (!function_exists('lcfirst')) {
	function lcfirst($str)
	{
		if (empty($str) || (strlen($str) < 1)) {
			return $str;
		}

		$firstChar = substr($str, 0, 1);
		$rest = substr($str, 1);
		$lowerCasedFirstChar = strtolower($firstChar);
		$lcString = $lowerCasedFirstChar.$rest;

		return $lcString;
	}
}
