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
 * HTML file contents gatherer script. May be use in conjunction with PhantomJS.
 */
// Slow connections may take a long time to load the file.
// Allow the script to never timeout.
ini_set('max_execution_time', 0);

// Secret key via url allows access to this script
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = $_GET['id'];
	if ($id == '76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C') {
		$init['access_level'] = 'anon';
	} else {
		$init['access_level'] = 'auth';
	}
} else {
	$init['access_level'] = 'auth';
}

//$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
//$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = false;
// Re-enable geo ip-delivery for production
//$init['geo'] = true;
$init['get_maxlength'] = 2048;
$init['get_required'] = false;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
//$init['output_buffering'] = true;
$init['override_php_ini'] = false;
//$init['post_maxlength'] = 100000;
$init['post_required'] = false;
//$init['sapi'] = 'cli'; // Omit or use "cli"
//$init['skip_always_include'] = true; //Skip include libraries defined in the application ini file.
$init['skip_session'] = false;
$init['skip_templating'] = true;
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');

require_once('lib/common/FileManagerFile.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/Message.php');

$message = Message::getInstance();
/* @var $message Message */

$config = Zend_Registry::get('config');
$tempFileDirectory = $config->system->file_manager_base_path . 'temp/pdf-temp-files/';

$tempFilePath = $tempFileDirectory . $get->tempFileName;

if (is_file($tempFilePath)) {

	ob_start();
	include($tempFilePath);
	$htmlOutput = ob_get_clean();
	echo $htmlOutput;

}
exit;
