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
 * A "Logo" is a unique way to identify a given Companies.
 *
 * GUIDS:
 * 	email
 * 	mobile_phone_number
 *
 * @category   Framework
 * @package    User
 */

/**
 * @see IntegratedMapper
 */

class Module extends IntegratedMapper
{
	public static function getfilemanagerfilesize($fileid, $database)
	{

		$db = DBI::getInstance($database);
		$db->begin();
		$query = "SELECT `file_size` from `file_locations` WHERE `id` = $fileid";
		$db->execute($query);
		$row = $db->fetch();
		$file_size = $row['file_size'];
		$db->free_result();

		$resfilesize=Module::isa_convert_bytes_to_specified($file_size, 'M');
		if($resfilesize <= '17')
		{
			return true;
		}else
		{
			return false;
		}
	}

	/* To convert bytes to the required unit
		k - > kilo bytes
		M - > Mega bytes
		G - > Giga bytes
	*/

	public static function  isa_convert_bytes_to_specified($bytes, $to, $decimal_places = 1) {
    $formulas = array(
        'K' => number_format($bytes / 1024, $decimal_places),
        'M' => number_format($bytes / 1048576, $decimal_places),
        'G' => number_format($bytes / 1073741824, $decimal_places)
    );
    return isset($formulas[$to]) ? $formulas[$to] : 0;
	}	

	

}
?>
