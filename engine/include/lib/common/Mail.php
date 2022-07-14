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
 * Send/receive/process email.
 *
 * Processing email may mean listening as a daemon for incoming emails and then
 * taking appropriate action.
 *
 * @category   Mail
 * @package    Mail
 *
 */

/**
 * Zend_Loader
 */
require_once('Zend/Loader.php');

/**
 * Zend_Http_Client
 */
require_once('Zend/Http/Client.php');

/**
 * Zend_Mail
 */
require_once('Zend/Mail.php');

/**
 * Zend_Mail_InlineImages
 */
require_once('lib/common/Mail/Zend_Mail_InlineImages.php');

/**
 * Zend_Mail_Transport_Smtp
 */
require_once('Zend/Mail/Transport/Smtp.php');

//class Mail extends Zend_Mail
class Mail extends Zend_Mail_InlineImages
{
	private $_arrFileManagerFiles;

	public function getArrFileManagerFiles()
	{
		return $this->_arrFileManagerFiles;
	}

	public function appendFileManagerFile(FileManagerFile $fileManagerFile)
	{
		/* @var $fileManagerFile FileManagerFile */
		if ($fileManagerFile->isDataLoaded()) {
			$file_manager_file_id = $fileManagerFile->file_manager_file_id;
			$this->_arrFileManagerFiles[$file_manager_file_id] = $fileManagerFile;
		}
	}

	public static $transportInitializedFlag = false;

	public static function initializeTransport()
	{
		// Send Multiple Mails per SMTP Connection
		$transportInitializedFlag = self::$transportInitializedFlag;
		if (!$transportInitializedFlag) {
			$config = Zend_Registry::get('config');

			// Pull config from Application class based on global configuration file
			$smtp_host = $config->mail->smtp_host;
			$smtp_port = $config->mail->smtp_port;
			$smtp_auth = $config->mail->smtp_auth;
			$smtp_ssl = $config->mail->smtp_ssl;

			// SMTP PORT - typically 25, 465, or 587
			$arrConfig = array(
				'port' => $smtp_port
			);

			// SMTP Authentication - typically "login" or "crammd5"
			if (isset($smtp_auth) && !empty($smtp_auth)) {
				$smtp_username = $config->mail->smtp_username;
				$smtp_password = $config->mail->smtp_password;

				$arrConfig['auth'] = $smtp_auth;
				$arrConfig['username'] = $smtp_username;
				$arrConfig['password'] = $smtp_password;
			}

			// SMTP SSL - typically "ssl" or "tls"
			if (isset($smtp_ssl) && !empty($smtp_ssl)) {
				$arrConfig['ssl'] = $smtp_ssl;
			}

			$transport = new Zend_Mail_Transport_Smtp($smtp_host, $arrConfig);
			Zend_Mail::setDefaultTransport($transport);

			// Send Multiple Mails per SMTP Connection
			self::$transportInitializedFlag = true;
		}
	}

	/**
	 * Public constructor
	 *
	 * @param string $charset
	 */
	public function __construct($charset = 'UTF-8')
	{
		$this->_charset = $charset;
		parent::__construct($charset);
	}

	/*
	public function setBodyText($text)
	{
		parent::setBodyText($text, 'UTF-8');
	}

	public function setBodyHtml($html)
	{
		parent::setBodyHtml($html, 'UTF-8');
	}
	*/

	public function setReplyTo($email, $name=null)
	{
		if (isset($name) && !empty($name)) {
			$replyTo = "$name <$email>";
		} else {
			$replyTo = $email;
		}

		$this->addHeader('Reply-To', $replyTo);
	}

	public function createAttachment($name, $content, $type='application/pdf')
	{
		$attachment = parent::createAttachments($content);
		$attachment->filename = $name;
	}

	public function send($transport = null)
	{
		// Send Multiple Mails per SMTP Connection
		$transportInitializedFlag = self::$transportInitializedFlag;
		if (!$transportInitializedFlag) {
			self::initializeTransport();
		}

		// @todo Undo the below bcc operation
		// Copy our internal developers for now
		// Debug
		//$this->addBcc('bhbruschke@adventcompanies.com');

		//$this->addBcc('justin@justinquick.com');
		//$this->addBcc('mbuhrley@adventcompanies.com');

		parent::send();
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
