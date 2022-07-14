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
 * GenericEmailMessage.  A simple class with every possible attribute to make up an email message.
 *
 * @category   Framework
 * @package    GenericEmailMessage
 */

class GenericEmailMessage extends AbstractWebToolkit
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'GenericEmailMessage';

    /**
     * Mail character set
     * @var string
     */
    protected $_mailCharacterSet = null;

    /**
     * MIME boundary string
     * @var string
     */
    protected $_mimeBoundary = null;

    /**
     * Content type of the message
     * @var string
     */
    protected $_messageContentType = null;

    /**
     * Date: header
     * @var string
     */
    protected $_date = null;

    /**
     * Mail headers
     * @var array
     */
    protected $_arrHeaders = array();

    /**
     * From: address
     * @var string
     */
    protected $_from = null;

    /**
     * Reply-To header
     * @var string
     */
    protected $_replyTo = null;

    /**
     * Return-Path header
     * @var string
     */
    protected $_returnPath = null;

    /**
     * To: email => name
     * @var array
     */
    protected $_arrTo = array();

    /**
     * Cc: email => name
     * @var array
     */
    protected $_arrCc = array();

    /**
     * Bcc: email => name
     * @var array
     */
    protected $_arrBcc = array();

    /**
     * Array of all recipients
     * @var array
     */
    protected $_arrRecipients = array();

    /**
     * Subject: header
     * @var string
     */
    protected $_subject = null;

    /**
     * text/plain MIME part
     * @var false|Zend_Mime_Part
     */
    protected $_bodyText = false;

    /**
     * text/html MIME part
     * @var false|Zend_Mime_Part
     */
    protected $_bodyHtml = false;

    /**
     * Array of FileManagerFile object references.
     *
     * @var array
     */
	protected $_arrFileManagerFileAttachments = array();

	/**
	 * Array of Binary strings as files.
	 *
	 * @var array
	 */
	protected $_arrRawBinaryFileAttachments = array();

	/**
	 * Constructor
	 */
	public function __construct($database)
	{
		$this->setDatabase($database);
	}

    /**
     * Returns the formatted date of the message
     *
     * @return string
     */
    public function getDate()
    {
    	if (isset($this->_date)) {
        	return $this->_date;
    	} else {
    		$this->setDate(null);
    	}

    	return $this->_date;
    }

    /**
     * Sets Date-header
     *
     * @param  string    $date
     */
    public function setDate($date = null)
    {
    	if (!isset($date)) {
    		$unixTimestamp = time();
    	} else {
			// Normalize to Unix Timestamp first
			$unixTimestamp = strtotime($date);
    	}

		// HTTP Date Header - Date: HTTP-Date (RFC 822 format)
		// RFC 822 format - "D, d M y H:i:s O"
		// Tue, 20 Aug 1996 14:25:27 GMT
		// $rfc822DateFormat = 'Fri, 21 Mar 2008 18:35:00 GMT';
		$dateTime = date('D, d M Y H:i:s O', $unixTimestamp);

       return $this;
    }

	/**
	 * Returns the sender of the mail
	 *
	 * @return string
	 */
	public function getFrom()
	{
		return $this->_from;
	}

	/**
	 * Sets From-header and sender of the message
	 *
	 * @param  string    $email
	 * @param  string    $name
	 */
	public function setFrom($email, $name = null)
	{
		$email = trim($email);
		$name = trim($name);

		if (isset($name) && !empty($name)) {
			$from = "$name <$email>";
		} else {
			$from = $email;
		}

		$this->_from = $from;

		return $this;
	}

	/**
	 * Returns the sender of the mail
	 *
	 * @return string
	 */
	public function getReplyTo()
	{
		return $this->_replyTo;
	}

	public function setReplyTo($email, $name=null)
	{
		if (isset($name) && !empty($name)) {
			$replyTo = "$name <$email>";
		} else {
			$replyTo = $email;
		}

		$this->_replyTo = $replyTo;

		return $this;
	}

	/**
	 * Returns the current Return-Path address for the email
	 *
	 * If no Return-Path header is set, returns the value of {@link $_from}.
	 *
	 * @return string
	 */
	public function getReturnPath()
	{
		if ($this->_returnPath != null) {
			return $this->_returnPath;
		}

		return $this->_from;
	}

	/**
	 * Sets the Return-Path header for an email
	 *
	 * @param  string    $email
	 */
	public function setReturnPath($email)
	{
		$this->_returnPath = $email;

		return $this;
	}

	public function getArrTo()
	{
		if (isset($this->_arrTo) && !empty($this->_arrTo)) {
			return $this->_arrTo;
		} else {
			return array();
		}
	}

    /**
     * Adds To recipient.
     *
     * @param  string $email
     * @param  string $name
     */
    public function addTo($email, $name='')
    {
    	$arrTmp = array($email => $name);

        $this->_arrTo[] = $arrTmp;
    }

	public function getArrCc()
	{
		if (isset($this->_arrCc) && !empty($this->_arrCc)) {
			return $this->_arrCc;
		} else {
			return array();
		}
	}

    /**
     * Adds Cc recipient.
     *
     * @param  string $email
     * @param  string $name
     */
    public function addCc($email, $name='')
    {
    	$arrTmp = array($email => $name);

        $this->_arrCc[] = $arrTmp;
    }

	public function getArrBcc()
	{
		if (isset($this->_arrBcc) && !empty($this->_arrBcc)) {
			return $this->_arrBcc;
		} else {
			return array();
		}
	}

    /**
     * Adds Bcc recipient.
     *
     * @param  string $email
     * @param  string $name
     */
    public function addBcc($email, $name='')
    {
    	$arrTmp = array($email => $name);

        $this->_arrBcc[] = $arrTmp;
    }

    /**
     * Return list of recipient email addresses / name pairs.
     *
     * @return array (of strings)
     */
    public function getArrRecipients()
    {
    	$arrTo = $this->_arrTo;
    	$arrCc = $this->_arrCc;
    	$arrBcc = $this->_arrBcc;

    	$arrRecipients = $arrTo + $arrCc + $arrBcc;

    	$this->_arrRecipients = $arrRecipients;

    	return $this->_arrRecipients;
    }

    /**
     * Returns the subject of the message.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->_subject;
    }

	public function setSubject($subject)
	{
		$this->_subject = $subject;
	}

	public function getBodyText()
	{
		if (isset($this->_bodyText)) {
			return $this->_bodyText;
		} else {
			return null;
		}
	}

	public function setBodyText($bodyText)
	{
		$this->_bodyText = $bodyText;

        return $this;
	}

	public function getBodyHtml()
	{
		if (isset($this->_bodyHtml)) {
			return $this->_bodyHtml;
		} else {
			return null;
		}
	}

	public function setBodyHtml($bodyHtml)
	{
		$this->_bodyHtml = $bodyHtml;

        return $this;
	}

	public function deriveMailAttachmentOriginTable($mail_attachment_origin_table=null)
	{
		if (isset($mail_attachment_origin_table) && !empty($mail_attachment_origin_table)) {
			$mailAttachmentOriginTable = MailAttachmentOriginTable::findByMailAttachmentOriginTable($database, $mail_attachment_origin_table);
			/* @var $mailAttachmentOriginTable MailAttachmentOriginTable */

			return $mailAttachmentOriginTable;
		}
	}

	public function addFileManagerFileAttachment(FileManagerFile $fileManagerFile, MailAttachmentOriginTable $mailAttachmentOriginTable=null)
	{
		$file_manager_file_id = $fileManagerFile->file_manager_file_id;

		if (isset($mailAttachmentOriginTable) && ($mailAttachmentOriginTable instanceof MailAttachmentOriginTable)) {
			$mail_attachment_origin_table_id = $mailAttachmentOriginTable->mail_attachment_origin_table_id;
		} else {

			$database = $fileManagerFile->getDatabase();
			$mailAttachmentOriginTable = new MailAttachmentOriginTable($database);
			$mail_attachment_origin_table_id = 1;
			$mail_attachment_origin_table = 'file_manager_files';
			$key = array('id' => $mail_attachment_origin_table_id);
			$mailAttachmentOriginTable->setKey($key);
			$data = array(
				'id' => $mail_attachment_origin_table_id,
				'mail_attachment_origin_table' => $mail_attachment_origin_table
			);
			$mailAttachmentOriginTable->setData($data);
			$mailAttachmentOriginTable->mail_attachment_origin_table_id = $mail_attachment_origin_table_id;
			$mailAttachmentOriginTable->mail_attachment_origin_table = $mail_attachment_origin_table;

		}

		$arrTmp = array(
			'mail_attachment_file_manager_file' => array(
				$file_manager_file_id => $fileManagerFile
			),
			'mail_attachment_origin_table' => array(
				$mail_attachment_origin_table_id => $mailAttachmentOriginTable
			),
		);

		$this->_arrFileManagerFileAttachments[] = $arrTmp;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
