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
 * Log things for the backend storage manager.
 *
 * E.g. the time it takes to copy files to the backend storage manager from the application server nodes.
 *
 * @category	Log
 * @package		Log_FileManagerBackend
 *
 */

/**
 * Log
 */
require_once('lib/common/Log.php');

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class Log_FileManagerBackend extends Log
{
	public static function recordTimeForFileManagerSaveFileToCloudOperation($database, $file_location_id, $protocol, $startTime, $endTime)
	{
		$file_copy_time = (float) ($endTime - $startTime);
		$file_copy_time = sprintf("%01.3f", $file_copy_time);

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT IGNORE
INTO `file_manager_backend_timer_logs` (`file_location_id`, `file_manager_backend_storage_protocol`, `file_copy_time`, `modified`)
VALUES (?, ?, ?, null)
";
		$arrValues = array($file_location_id, $protocol, $file_copy_time);

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */