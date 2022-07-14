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
 * MeetingLocation.
 *
 * @category   Framework
 * @package    MeetingLocation
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class MeetingLocation extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'MeetingLocation';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'meeting_locations';

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
	 * unique index `unique_meeting_location` (`user_company_id`,`meeting_location`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_meeting_location' => array(
			'user_company_id' => 'int',
			'meeting_location' => 'string'
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
		'id' => 'meeting_location_id',

		'user_company_id' => 'user_company_id',

		'meeting_location' => 'meeting_location',

		'meeting_location_abbreviation' => 'meeting_location_abbreviation',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $meeting_location_id;

	public $user_company_id;

	public $meeting_location;

	public $meeting_location_abbreviation;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_meeting_location;
	public $escaped_meeting_location_abbreviation;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_meeting_location_nl2br;
	public $escaped_meeting_location_abbreviation_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrMeetingLocationsByUserCompanyId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllMeetingLocations;

	// Foreign Key Objects
	private $_userCompany;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='meeting_locations')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getUserCompany()
	{
		if (isset($this->_userCompany)) {
			return $this->_userCompany;
		} else {
			return null;
		}
	}

	public function setUserCompany($userCompany)
	{
		$this->_userCompany = $userCompany;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrMeetingLocationsByUserCompanyId()
	{
		if (isset(self::$_arrMeetingLocationsByUserCompanyId)) {
			return self::$_arrMeetingLocationsByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrMeetingLocationsByUserCompanyId($arrMeetingLocationsByUserCompanyId)
	{
		self::$_arrMeetingLocationsByUserCompanyId = $arrMeetingLocationsByUserCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllMeetingLocations()
	{
		if (isset(self::$_arrAllMeetingLocations)) {
			return self::$_arrAllMeetingLocations;
		} else {
			return null;
		}
	}

	public static function setArrAllMeetingLocations($arrAllMeetingLocations)
	{
		self::$_arrAllMeetingLocations = $arrAllMeetingLocations;
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
	 * @param int $meeting_location_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $meeting_location_id,$table='meeting_locations', $module='MeetingLocation')
	{
		$meetingLocation = parent::findById($database, $meeting_location_id,  $table, $module);

		return $meetingLocation;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $meeting_location_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findMeetingLocationByIdExtended($database, $meeting_location_id)
	{
		$meeting_location_id = (int) $meeting_location_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	ml_fk_uc.`id` AS 'ml_fk_uc__user_company_id',
	ml_fk_uc.`company` AS 'ml_fk_uc__company',
	ml_fk_uc.`primary_phone_number` AS 'ml_fk_uc__primary_phone_number',
	ml_fk_uc.`employer_identification_number` AS 'ml_fk_uc__employer_identification_number',
	ml_fk_uc.`construction_license_number` AS 'ml_fk_uc__construction_license_number',
	ml_fk_uc.`construction_license_number_expiration_date` AS 'ml_fk_uc__construction_license_number_expiration_date',
	ml_fk_uc.`paying_customer_flag` AS 'ml_fk_uc__paying_customer_flag',

	ml.*

FROM `meeting_locations` ml
	INNER JOIN `user_companies` ml_fk_uc ON ml.`user_company_id` = ml_fk_uc.`id`
WHERE ml.`id` = ?
";
		$arrValues = array($meeting_location_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$meeting_location_id = $row['id'];
			$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id);
			/* @var $meetingLocation MeetingLocation */
			$meetingLocation->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['ml_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'ml_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$meetingLocation->setUserCompany($userCompany);

			return $meetingLocation;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_meeting_location` (`user_company_id`,`meeting_location`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $meeting_location
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndMeetingLocation($database, $user_company_id, $meeting_location)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ml.*

FROM `meeting_locations` ml
WHERE ml.`user_company_id` = ?
AND ml.`meeting_location` = ?
";
		$arrValues = array($user_company_id, $meeting_location);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$meeting_location_id = $row['id'];
			$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id);
			/* @var $meetingLocation MeetingLocation */
			return $meetingLocation;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrMeetingLocationIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingLocationsByArrMeetingLocationIds($database, $arrMeetingLocationIds, Input $options=null)
	{
		if (empty($arrMeetingLocationIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `meeting_location` ASC, `meeting_location_abbreviation` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ml.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingLocation = new MeetingLocation($database);
			$sqlOrderByColumns = $tmpMeetingLocation->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrMeetingLocationIds as $k => $meeting_location_id) {
			$meeting_location_id = (int) $meeting_location_id;
			$arrMeetingLocationIds[$k] = $db->escape($meeting_location_id);
		}
		$csvMeetingLocationIds = join(',', $arrMeetingLocationIds);

		$query =
"
SELECT

	ml.*

FROM `meeting_locations` ml
WHERE ml.`id` IN ($csvMeetingLocationIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrMeetingLocationsByCsvMeetingLocationIds = array();
		while ($row = $db->fetch()) {
			$meeting_location_id = $row['id'];
			$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id);
			/* @var $meetingLocation MeetingLocation */
			$meetingLocation->convertPropertiesToData();

			$arrMeetingLocationsByCsvMeetingLocationIds[$meeting_location_id] = $meetingLocation;
		}

		$db->free_result();

		return $arrMeetingLocationsByCsvMeetingLocationIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `meeting_locations_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingLocationsByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrMeetingLocationsByUserCompanyId = null;
		}

		$arrMeetingLocationsByUserCompanyId = self::$_arrMeetingLocationsByUserCompanyId;
		if (isset($arrMeetingLocationsByUserCompanyId) && !empty($arrMeetingLocationsByUserCompanyId)) {
			return $arrMeetingLocationsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `meeting_location` ASC, `meeting_location_abbreviation` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ml.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingLocation = new MeetingLocation($database);
			$sqlOrderByColumns = $tmpMeetingLocation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ml.*

FROM `meeting_locations` ml
WHERE ml.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `meeting_location` ASC, `meeting_location_abbreviation` ASC, `sort_order` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingLocationsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$meeting_location_id = $row['id'];
			$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id);
			/* @var $meetingLocation MeetingLocation */
			$arrMeetingLocationsByUserCompanyId[$meeting_location_id] = $meetingLocation;
		}

		$db->free_result();

		self::$_arrMeetingLocationsByUserCompanyId = $arrMeetingLocationsByUserCompanyId;

		return $arrMeetingLocationsByUserCompanyId;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `meeting_locations_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingLocationsByUserCompanyIdApi($database, $user_company_id, Input $options=null)
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
			self::$_arrMeetingLocationsByUserCompanyId = null;
		}

		$arrMeetingLocationsByUserCompanyId = self::$_arrMeetingLocationsByUserCompanyId;
		if (isset($arrMeetingLocationsByUserCompanyId) && !empty($arrMeetingLocationsByUserCompanyId)) {
			return $arrMeetingLocationsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `meeting_location` ASC, `meeting_location_abbreviation` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ml.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingLocation = new MeetingLocation($database);
			$sqlOrderByColumns = $tmpMeetingLocation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ml.*

FROM `meeting_locations` ml
WHERE ml.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `meeting_location` ASC, `meeting_location_abbreviation` ASC, `sort_order` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingLocationsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$meeting_location_id = $row['id'];
			$meeting_location = $row['meeting_location'];
			/* @var $meetingLocation MeetingLocation */
			$arrMeetingLocationsByUserCompanyId[$meeting_location_id]['meeting_location_id'] = $meeting_location_id;
			$arrMeetingLocationsByUserCompanyId[$meeting_location_id]['meeting_location'] = $meeting_location;
		}

		$db->free_result();

		self::$_arrMeetingLocationsByUserCompanyId = $arrMeetingLocationsByUserCompanyId;

		return $arrMeetingLocationsByUserCompanyId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all meeting_locations records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllMeetingLocations($database, Input $options=null)
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
			self::$_arrAllMeetingLocations = null;
		}

		$arrAllMeetingLocations = self::$_arrAllMeetingLocations;
		if (isset($arrAllMeetingLocations) && !empty($arrAllMeetingLocations)) {
			return $arrAllMeetingLocations;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `meeting_location` ASC, `meeting_location_abbreviation` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ml.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingLocation = new MeetingLocation($database);
			$sqlOrderByColumns = $tmpMeetingLocation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ml.*

FROM `meeting_locations` ml{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `meeting_location` ASC, `meeting_location_abbreviation` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllMeetingLocations = array();
		while ($row = $db->fetch()) {
			$meeting_location_id = $row['id'];
			$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id);
			/* @var $meetingLocation MeetingLocation */
			$arrAllMeetingLocations[$meeting_location_id] = $meetingLocation;
		}

		$db->free_result();

		self::$_arrAllMeetingLocations = $arrAllMeetingLocations;

		return $arrAllMeetingLocations;
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
INTO `meeting_locations`
(`user_company_id`, `meeting_location`, `meeting_location_abbreviation`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `meeting_location_abbreviation` = ?, `sort_order` = ?
";
		$arrValues = array($this->user_company_id, $this->meeting_location, $this->meeting_location_abbreviation, $this->sort_order, $this->meeting_location_abbreviation, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$meeting_location_id = $db->insertId;
		$db->free_result();

		return $meeting_location_id;
	}

	// Finders: Find By Unique Location
	/**
	 * Find by unique index `unique_meeting_location` (`user_company_id`,`meeting_location`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $meeting_location
	 * @return mixed (single ORM object | false)
	 */
	public static function findMeetingLocationByUserCompanyIdAndLocation($database, $user_company_id, $meeting_location)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
"
SELECT
	ml.*

FROM `meeting_locations` ml
WHERE ml.`user_company_id` = ?
AND ml.`meeting_location` = ?
";
		$arrValues = array($user_company_id, $meeting_location);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$meeting_location_id = $row['id'];
			$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id);
			/* @var $meetingLocation MeetingLocation */
			return $meeting_location_id;
		} else {
			return null;
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
