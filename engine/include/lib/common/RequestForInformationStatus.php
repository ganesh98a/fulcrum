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
 * RequestForInformationStatus.
 *
 * @category   Framework
 * @package    RequestForInformationStatus
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RequestForInformationStatus extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RequestForInformationStatus';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'request_for_information_statuses';

	/**
	 * primary key (`id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'id' => 'int'
	);

	/**
	 * unique index `unique_request_for_information_status` (`request_for_information_status`) comment 'RFI Statuses transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_request_for_information_status' => array(
			'request_for_information_status' => 'string'
		)
	);

	/**
	 * Standard attributes list.
	 *
	 * Metadata mapper pattern maps db attributes to object properties.
	 *
	 * Key - database attribute/field
	 * Value - object property
	 *
	 * @var array
	 */
	protected $arrAttributesMap = array(
		'id' => 'request_for_information_status_id',

		'request_for_information_status' => 'request_for_information_status',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $request_for_information_status_id;

	public $request_for_information_status;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_request_for_information_status;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_request_for_information_status_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRequestForInformationStatuses;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='request_for_information_statuses')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRequestForInformationStatuses()
	{
		if (isset(self::$_arrAllRequestForInformationStatuses)) {
			return self::$_arrAllRequestForInformationStatuses;
		} else {
			return null;
		}
	}

	public static function setArrAllRequestForInformationStatuses($arrAllRequestForInformationStatuses)
	{
		self::$_arrAllRequestForInformationStatuses = $arrAllRequestForInformationStatuses;
	}

	/*
	public function getOtherProperty()
	{
		if (isset($this->_otherPropertyHere)) {
			return $this->_otherPropertyHere;
		} else {
			return null;
		}
	}
	*/

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $request_for_information_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $request_for_information_status_id,$table='request_for_information_statuses', $module='RequestForInformationStatus')
	{
		$requestForInformationStatus = parent::findById($database, $request_for_information_status_id, $table, $module);

		return $requestForInformationStatus;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $request_for_information_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findRequestForInformationStatusByIdExtended($database, $request_for_information_status_id)
	{
		$request_for_information_status_id = (int) $request_for_information_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfis.*

FROM `request_for_information_statuses` rfis
WHERE rfis.`id` = ?
";
		$arrValues = array($request_for_information_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$request_for_information_status_id = $row['id'];
			$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id);
			/* @var $requestForInformationStatus RequestForInformationStatus */
			$requestForInformationStatus->convertPropertiesToData();

			return $requestForInformationStatus;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_request_for_information_status` (`request_for_information_status`) comment 'RFI Statuses transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $request_for_information_status
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRequestForInformationStatus($database, $request_for_information_status)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfis.*

FROM `request_for_information_statuses` rfis
WHERE rfis.`request_for_information_status` = ?
";
		$arrValues = array($request_for_information_status);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$request_for_information_status_id = $row['id'];
			$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id);
			/* @var $requestForInformationStatus RequestForInformationStatus */
			return $requestForInformationStatus;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrRequestForInformationStatusIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationStatusesByArrRequestForInformationStatusIds($database, $arrRequestForInformationStatusIds, Input $options=null)
	{
		if (empty($arrRequestForInformationStatusIds)) {
			return array();
		}

		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_status` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationStatus = new RequestForInformationStatus($database);
			$sqlOrderByColumns = $tmpRequestForInformationStatus->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		foreach ($arrRequestForInformationStatusIds as $k => $request_for_information_status_id) {
			$request_for_information_status_id = (int) $request_for_information_status_id;
			$arrRequestForInformationStatusIds[$k] = $db->escape($request_for_information_status_id);
		}
		$csvRequestForInformationStatusIds = join(',', $arrRequestForInformationStatusIds);

		$query =
"
SELECT

	rfis.*

FROM `request_for_information_statuses` rfis
WHERE rfis.`id` IN ($csvRequestForInformationStatusIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrRequestForInformationStatusesByCsvRequestForInformationStatusIds = array();
		while ($row = $db->fetch()) {
			$request_for_information_status_id = $row['id'];
			$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id);
			/* @var $requestForInformationStatus RequestForInformationStatus */
			$requestForInformationStatus->convertPropertiesToData();

			$arrRequestForInformationStatusesByCsvRequestForInformationStatusIds[$request_for_information_status_id] = $requestForInformationStatus;
		}

		$db->free_result();

		return $arrRequestForInformationStatusesByCsvRequestForInformationStatusIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all request_for_information_statuses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRequestForInformationStatuses($database, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrAllRequestForInformationStatuses = null;
		}

		$arrAllRequestForInformationStatuses = self::$_arrAllRequestForInformationStatuses;
		if (isset($arrAllRequestForInformationStatuses) && !empty($arrAllRequestForInformationStatuses)) {
			return $arrAllRequestForInformationStatuses;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_status` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationStatus = new RequestForInformationStatus($database);
			$sqlOrderByColumns = $tmpRequestForInformationStatus->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$query =
"
SELECT
	rfis.*

FROM `request_for_information_statuses` rfis{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_status` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRequestForInformationStatuses = array();
		while ($row = $db->fetch()) {
			$request_for_information_status_id = $row['id'];
			$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id);
			/* @var $requestForInformationStatus RequestForInformationStatus */
			$arrAllRequestForInformationStatuses[$request_for_information_status_id] = $requestForInformationStatus;
		}

		$db->free_result();

		self::$_arrAllRequestForInformationStatuses = $arrAllRequestForInformationStatuses;

		return $arrAllRequestForInformationStatuses;
	}

	// Save: insert on duplicate key update
	public function insertOnDuplicateKeyUpdate()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT
INTO `request_for_information_statuses`
(`request_for_information_status`, `disabled_flag`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?
";
		$arrValues = array($this->request_for_information_status, $this->disabled_flag, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$request_for_information_status_id = $db->insertId;
		$db->free_result();

		return $request_for_information_status_id;
	}

	public function insertClosedDate($database,$request_for_information_id,$rfi_closed_date,$status )
	{
		$db = DBI::getInstance($database);
		$query ="INSERT INTO `request_for_information_closed_date_log`(`rfi_id`, `closed_date`,`status`) VALUES (?, ?,?)";
		$arrValues = array($request_for_information_id, $rfi_closed_date,$status);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$request_for_information_status_id = $db->insertId;
		$db->free_result();

		return $request_for_information_status_id;

	}

	public function getClosedDateDetails($database,$request_for_information_id )
	{
		$db = DBI::getInstance($database);
		$query ="SELECT * from `request_for_information_closed_date_log` where rfi_id =? order by id ";
		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$closedArr = $openarr =array();
		while($row = $db->fetch())
		{
			if($row['status']=='open')
			{
				$openarr[]=$row['closed_date'];
			}else
			{
			$closedArr[]=$row['closed_date'];
		}
		}
		$db->free_result();
		$retArray['open']=$openarr;
		$retArray['closed'] =$closedArr;

		return $retArray;

	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
