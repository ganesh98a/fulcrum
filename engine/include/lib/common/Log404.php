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
 * Log 404 errors.
 *
 * @category	LOG
 * @package		Log404
 *
 */

/**
 * @see IntegratedMapper
 */
require_once('lib/common/IntegratedMapper.php');

/**
 * @see Log404Error
 */
require_once('lib/common/Log404Error.php');

/**
 * @see Log404Referer
 */
require_once('lib/common/Log404Referer.php');

/**
 * @see Log404ErrorToLog404Referer
 */
require_once('lib/common/Log404ErrorToLog404Referer.php');

class Log404 extends IntegratedMapper
{
	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var unknown_type
	 */
	protected $_table = 'log_404';

	protected $attempted_uri;
	protected $referrer;
	protected $log_404_id;
	protected $referrer_id;
	protected $attemptedUriTotal;
	protected $attemptedUriReferrerTotal;
	protected $referrerTotal;

	/**
	 * Constructor.
	 *
	 */
	public function __construct()
	{
		parent::__construct($this->_table);
	}

	public function __destruct()
	{
		$this->_db = null;
	}

	public static function log404($database, Uri $uri)
	{
		/*
		// Future Analytics Section
		$server_ip_address = (float) $uri->server_ip_address;
		$domain = $uri->domain;
		$remote_ip_address = (float) $uri->remote_ip_address;
		$remote_host = $uri->remote_host;
		$remote_port = $uri->remote_port;
		$remote_user = $uri->remote_user;

		$remoteIpLong = ip2long($remote_ip_address);
		$serverIpLong = ip2long($remote_ip_address);
		*/

		// Pipe to dev null for mongodb to scale
		if ($uri->sslFlag) {
			$log_404_url = $uri->full_https_uri;
		} else {
			$log_404_url = $uri->full_http_uri;
		}

		$log_404_referer_url = $uri->referrer;

		$log_404_url_sha1 = sha1($log_404_url);
		$log_404_referer_url_sha1 = sha1($log_404_referer_url);

		$log404Error = Log404Error::findByLog404UrlSha1($database, $log_404_url_sha1);
		/* @var $log404Error Log404Error */

		if ($log404Error) {
			$log_404_error_id = $log404Error->log_404_error_id;
		} else {
			$log404Error = new Log404Error($database);
			$log404Error->log_404_url_sha1 = $log_404_url_sha1;
			$log404Error->log_404_url = $log_404_url;
			$log404Error->created = null;
			$log404Error->convertPropertiesToData();
			$log_404_error_id = $log404Error->save();
		}

		$log404Referer = Log404Referer::findByLog404RefererUrlSha1($database, $log_404_referer_url_sha1);
		/* @var $log404Referer Log404Referer */

		if ($log404Referer) {
			$log_404_referer_id = $log404Referer->log_404_referer_id;
		} else {
			$log404Referer = new Log404Referer($database);
			$log404Referer->log_404_referer_url_sha1 = $log_404_referer_url_sha1;
			$log404Referer->log_404_referer_url = $log_404_referer_url;
			$log404Referer->created = null;
			$log404Referer->convertPropertiesToData();
			$log_404_referer_id = $log404Referer->save();
		}

		$log404ErrorToLog404Referer = Log404ErrorToLog404Referer::findByLog404ErrorIdAndLog404RefererId($database, $log_404_error_id, $log_404_referer_id);
		/* @var $log404ErrorToLog404Referer Log404ErrorToLog404Referer */

		if ($log404ErrorToLog404Referer) {
			$occurrences = $log404ErrorToLog404Referer->occurrences;
			$occurrences++;
			$log404ErrorToLog404Referer->occurrences = $occurrences;
			$data = array('occurrences' => $occurrences);
			$log404ErrorToLog404Referer->setData($data);
			$log404ErrorToLog404Referer->save();
		} else {
			$log404ErrorToLog404Referer = new Log404ErrorToLog404Referer($database);
			$log404ErrorToLog404Referer->log_404_error_id = $log_404_error_id;
			$log404ErrorToLog404Referer->log_404_referer_id = $log_404_referer_id;
			$log404ErrorToLog404Referer->occurrences = 1;
			$log404ErrorToLog404Referer->convertPropertiesToData();
			$log404ErrorToLog404Referer->save();
		}
	}

	public static function findByUri($uri='')
	{
		$l = new Log404();
		$db = $l->getDb();

		$query =
'
SELECT l.*, lr.*, r.*
FROM log_404 l LEFT OUTER JOIN log_404_to_referrers lr
ON l.log_404_id = lr.log_404_id
LEFT OUTER JOIN referrers r
ON lr.referrer_id = r.referrer_id
WHERE l.attempted_uri = ?
';
		$arrValues = array($uri);
		$db->execute($query, $arrValues);
		unset($query);
		unset($arrValues);
		$row = $db->fetch();
		$db->free_result();
		$db->reset();
		unset($db);

		if (isset($row) && !empty($row)) {
			$l->setData($row);
		} else {
			$l->total = 0;
		}
		unset($row);

		$l->attempted_uri = $uri;
		unset($uri);

		return $l;
	}

	/**
	 * Log a missing page request (HTTP 404).
	 *
	 * @param unknown_type $attempted_uri
	 * @param unknown_type $referrer
	 */
	public static function logUri($attempted_uri, $referrer)
	{
		$l = new Log404();
		$db = $l->getDb();
		/* @var $db DBI_mysqli */
		$db->begin();
		$query =
'
INSERT INTO log_404 (attempted_uri, total, modified, created)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE log_404_id=LAST_INSERT_ID(log_404_id), total=total+1, modified=?
';
		$arrValues = array($attempted_uri, 1, null, null, null);
		$db->execute($query, $arrValues);
		$log_404_id = $db->insertId;

		$query =
'
INSERT INTO referrers (referrer, total, modified, created)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE referrer_id=LAST_INSERT_ID(referrer_id), total=total+1, modified=?
';
		$arrValues = array($referrer, 1, null, null, null);
		$db->execute($query, $arrValues);
		$referrer_id = $db->insertId;

		$query =
'
INSERT INTO log_404_to_referrers (log_404_id, referrer_id, total, modified, created)
VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE total=total+1, modified=?
';
		$arrValues = array($log_404_id, $referrer_id, 1, null, null, null);
		$db->execute($query, $arrValues);
		$db->commit();
		$db->free_result();
		$db->reset();

		unset($query);
		unset($arrValues);
		unset($db);

		$l->log_404_id = $log_404_id;
		$l->referrer_id = $referrer_id;
		$l->attempted_uri = $attempted_uri;
		$l->referrer = $referrer;

		return $l;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
