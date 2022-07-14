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
 * MeetingAttendee.
 *
 * @category   Framework
 * @package    MeetingAttendee
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class MeetingAttendee extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'MeetingAttendee';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'meeting_attendees';

	/**
	 * primary key (`meeting_id`,`contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'meeting_id' => 'int',
		'contact_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_meeting_attendee_via_primary_key' => array(
			'meeting_id' => 'int',
			'contact_id' => 'int'
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
		'meeting_id' => 'meeting_id',
		'contact_id' => 'contact_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $meeting_id;
	public $contact_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrMeetingAttendeesByMeetingId;
	protected static $_arrMeetingAttendeesByContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllMeetingAttendees;

	// Foreign Key Objects
	private $_meeting;
	private $_contact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='meeting_attendees')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getMeeting()
	{
		if (isset($this->_meeting)) {
			return $this->_meeting;
		} else {
			return null;
		}
	}

	public function setMeeting($meeting)
	{
		$this->_meeting = $meeting;
	}

	public function getContact()
	{
		if (isset($this->_contact)) {
			return $this->_contact;
		} else {
			return null;
		}
	}

	public function setContact($contact)
	{
		$this->_contact = $contact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrMeetingAttendeesByMeetingId()
	{
		if (isset(self::$_arrMeetingAttendeesByMeetingId)) {
			return self::$_arrMeetingAttendeesByMeetingId;
		} else {
			return null;
		}
	}

	public static function setArrMeetingAttendeesByMeetingId($arrMeetingAttendeesByMeetingId)
	{
		self::$_arrMeetingAttendeesByMeetingId = $arrMeetingAttendeesByMeetingId;
	}

	public static function getArrMeetingAttendeesByContactId()
	{
		if (isset(self::$_arrMeetingAttendeesByContactId)) {
			return self::$_arrMeetingAttendeesByContactId;
		} else {
			return null;
		}
	}

	public static function setArrMeetingAttendeesByContactId($arrMeetingAttendeesByContactId)
	{
		self::$_arrMeetingAttendeesByContactId = $arrMeetingAttendeesByContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllMeetingAttendees()
	{
		if (isset(self::$_arrAllMeetingAttendees)) {
			return self::$_arrAllMeetingAttendees;
		} else {
			return null;
		}
	}

	public static function setArrAllMeetingAttendees($arrAllMeetingAttendees)
	{
		self::$_arrAllMeetingAttendees = $arrAllMeetingAttendees;
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
	 * Find by primary key (`meeting_id`,`contact_id`).
	 *
	 * @param string $database
	 * @param int $meeting_id
	 * @param int $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByMeetingIdAndContactId($database, $meeting_id, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	attendees.*

FROM `meeting_attendees` attendees
WHERE attendees.`meeting_id` = ?
AND attendees.`contact_id` = ?
";
		$arrValues = array($meeting_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$meetingAttendee = self::instantiateOrm($database, 'MeetingAttendee', $row);
			/* @var $meetingAttendee MeetingAttendee */
			return $meetingAttendee;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`meeting_id`,`contact_id`) Extended.
	 *
	 * @param string $database
	 * @param int $meeting_id
	 * @param int $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByMeetingIdAndContactIdExtended($database, $meeting_id, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	attendees_fk_m.`id` AS 'attendees_fk_m__meeting_id',
	attendees_fk_m.`previous_meeting_id` AS 'attendees_fk_m__previous_meeting_id',
	attendees_fk_m.`project_id` AS 'attendees_fk_m__project_id',
	attendees_fk_m.`meeting_type_id` AS 'attendees_fk_m__meeting_type_id',
	attendees_fk_m.`meeting_location_id` AS 'attendees_fk_m__meeting_location_id',
	attendees_fk_m.`meeting_chair_contact_id` AS 'attendees_fk_m__meeting_chair_contact_id',
	attendees_fk_m.`modified_by_contact_id` AS 'attendees_fk_m__modified_by_contact_id',
	attendees_fk_m.`meeting_sequence_number` AS 'attendees_fk_m__meeting_sequence_number',
	attendees_fk_m.`meeting_start_date` AS 'attendees_fk_m__meeting_start_date',
	attendees_fk_m.`meeting_start_time` AS 'attendees_fk_m__meeting_start_time',
	attendees_fk_m.`meeting_end_date` AS 'attendees_fk_m__meeting_end_date',
	attendees_fk_m.`meeting_end_time` AS 'attendees_fk_m__meeting_end_time',
	attendees_fk_m.`modified` AS 'attendees_fk_m__modified',
	attendees_fk_m.`created` AS 'attendees_fk_m__created',
	attendees_fk_m.`all_day_event_flag` AS 'attendees_fk_m__all_day_event_flag',

	attendees_fk_c.`id` AS 'attendees_fk_c__contact_id',
	attendees_fk_c.`user_company_id` AS 'attendees_fk_c__user_company_id',
	attendees_fk_c.`user_id` AS 'attendees_fk_c__user_id',
	attendees_fk_c.`contact_company_id` AS 'attendees_fk_c__contact_company_id',
	attendees_fk_c.`email` AS 'attendees_fk_c__email',
	attendees_fk_c.`name_prefix` AS 'attendees_fk_c__name_prefix',
	attendees_fk_c.`first_name` AS 'attendees_fk_c__first_name',
	attendees_fk_c.`additional_name` AS 'attendees_fk_c__additional_name',
	attendees_fk_c.`middle_name` AS 'attendees_fk_c__middle_name',
	attendees_fk_c.`last_name` AS 'attendees_fk_c__last_name',
	attendees_fk_c.`name_suffix` AS 'attendees_fk_c__name_suffix',
	attendees_fk_c.`title` AS 'attendees_fk_c__title',
	attendees_fk_c.`vendor_flag` AS 'attendees_fk_c__vendor_flag',

	attendees.*

FROM `meeting_attendees` attendees
	INNER JOIN `meetings` attendees_fk_m ON attendees.`meeting_id` = attendees_fk_m.`id`
	INNER JOIN `contacts` attendees_fk_c ON attendees.`contact_id` = attendees_fk_c.`id`
WHERE attendees.`meeting_id` = ?
AND attendees.`contact_id` = ?
";
		$arrValues = array($meeting_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$meetingAttendee = self::instantiateOrm($database, 'MeetingAttendee', $row);
			/* @var $meetingAttendee MeetingAttendee */
			$meetingAttendee->convertPropertiesToData();

			if (isset($row['meeting_id'])) {
				$meeting_id = $row['meeting_id'];
				$row['attendees_fk_m__id'] = $meeting_id;
				$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id, 'attendees_fk_m__');
				/* @var $meeting Meeting */
				$meeting->convertPropertiesToData();
			} else {
				$meeting = false;
			}
			$meetingAttendee->setMeeting($meeting);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['attendees_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'attendees_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$meetingAttendee->setContact($contact);

			return $meetingAttendee;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by a list of non auto int primary keys (array of primary keys).
	 *
	 * @param string $database
	 * @param array $arrMeetingIdAndContactIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingAttendeesByArrMeetingIdAndContactIdList($database, $arrMeetingIdAndContactIdList, Input $options=null)
	{
		if (empty($arrMeetingIdAndContactIdList)) {
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
		// ORDER BY `meeting_id` ASC, `contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingAttendee = new MeetingAttendee($database);
			$sqlOrderByColumns = $tmpMeetingAttendee->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$arrSqlWhere = array();
		foreach ($arrMeetingIdAndContactIdList as $k => $arrTmp) {
			$tmpInnerAnd = '';
			$first = true;
			foreach ($arrTmp as $tmpPrimaryKeyAttribute => $tmpPrimaryKeyValue) {
				$tmpPrimaryKeyAttributeEscaped = $db->escape($tmpPrimaryKeyAttribute);
				$tmpPrimaryKeyValueEscaped = $db->escape($tmpPrimaryKeyValue);
				if ($first) {
					$first = false;
					$tmpInnerAnd = "`$tmpPrimaryKeyAttribute` = '$tmpPrimaryKeyValueEscaped'";
				} else {
					$tmpInnerAnd .= " AND `$tmpPrimaryKeyAttribute` = '$tmpPrimaryKeyValueEscaped'";
				}
			}
			$tmpInnerAnd = "($tmpInnerAnd)";
			$arrSqlWhere[] = $tmpInnerAnd;
		}
		if (count($arrMeetingIdAndContactIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	attendees.*

FROM `meeting_attendees` attendees
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingAttendeesByArrMeetingIdAndContactIdList = array();
		while ($row = $db->fetch()) {
			$meetingAttendee = self::instantiateOrm($database, 'MeetingAttendee', $row);
			/* @var $meetingAttendee MeetingAttendee */
			$arrMeetingAttendeesByArrMeetingIdAndContactIdList[] = $meetingAttendee;
		}

		$db->free_result();

		return $arrMeetingAttendeesByArrMeetingIdAndContactIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `meeting_attendees_fk_m` foreign key (`meeting_id`) references `meetings` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $meeting_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingAttendeesByMeetingId($database, $meeting_id, Input $options=null)
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
			self::$_arrMeetingAttendeesByMeetingId = null;
		}

		$arrMeetingAttendeesByMeetingId = self::$_arrMeetingAttendeesByMeetingId;
		if (isset($arrMeetingAttendeesByMeetingId) && !empty($arrMeetingAttendeesByMeetingId)) {
			return $arrMeetingAttendeesByMeetingId;
		}

		$meeting_id = (int) $meeting_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `meeting_id` ASC, `contact_id` ASC
		$sqlOrderBy = "\nORDER BY attendees_fk_c.`first_name` ASC, attendees_fk_c.`last_name` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingAttendee = new MeetingAttendee($database);
			$sqlOrderByColumns = $tmpMeetingAttendee->constructSqlOrderByColumns($arrOrderByAttributes);

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

	attendees_fk_m.`id` AS 'attendees_fk_m__meeting_id',
	attendees_fk_m.`previous_meeting_id` AS 'attendees_fk_m__previous_meeting_id',
	attendees_fk_m.`project_id` AS 'attendees_fk_m__project_id',
	attendees_fk_m.`meeting_type_id` AS 'attendees_fk_m__meeting_type_id',
	attendees_fk_m.`meeting_location_id` AS 'attendees_fk_m__meeting_location_id',
	attendees_fk_m.`meeting_chair_contact_id` AS 'attendees_fk_m__meeting_chair_contact_id',
	attendees_fk_m.`modified_by_contact_id` AS 'attendees_fk_m__modified_by_contact_id',
	attendees_fk_m.`meeting_sequence_number` AS 'attendees_fk_m__meeting_sequence_number',
	attendees_fk_m.`meeting_start_date` AS 'attendees_fk_m__meeting_start_date',
	attendees_fk_m.`meeting_start_time` AS 'attendees_fk_m__meeting_start_time',
	attendees_fk_m.`meeting_end_date` AS 'attendees_fk_m__meeting_end_date',
	attendees_fk_m.`meeting_end_time` AS 'attendees_fk_m__meeting_end_time',
	attendees_fk_m.`modified` AS 'attendees_fk_m__modified',
	attendees_fk_m.`created` AS 'attendees_fk_m__created',
	attendees_fk_m.`all_day_event_flag` AS 'attendees_fk_m__all_day_event_flag',

	attendees_fk_c.`id` AS 'attendees_fk_c__contact_id',
	attendees_fk_c.`user_company_id` AS 'attendees_fk_c__user_company_id',
	attendees_fk_c.`user_id` AS 'attendees_fk_c__user_id',
	attendees_fk_c.`contact_company_id` AS 'attendees_fk_c__contact_company_id',
	attendees_fk_c.`email` AS 'attendees_fk_c__email',
	attendees_fk_c.`name_prefix` AS 'attendees_fk_c__name_prefix',
	attendees_fk_c.`first_name` AS 'attendees_fk_c__first_name',
	attendees_fk_c.`additional_name` AS 'attendees_fk_c__additional_name',
	attendees_fk_c.`middle_name` AS 'attendees_fk_c__middle_name',
	attendees_fk_c.`last_name` AS 'attendees_fk_c__last_name',
	attendees_fk_c.`name_suffix` AS 'attendees_fk_c__name_suffix',
	attendees_fk_c.`title` AS 'attendees_fk_c__title',
	attendees_fk_c.`vendor_flag` AS 'attendees_fk_c__vendor_flag',
	attendees_fk_c.`is_archive` AS 'attendees_fk_c__is_archive',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	attendees.*

FROM `meeting_attendees` attendees
	INNER JOIN `meetings` attendees_fk_m ON attendees.`meeting_id` = attendees_fk_m.`id`
	INNER JOIN `contacts` attendees_fk_c ON attendees.`contact_id` = attendees_fk_c.`id`
	INNER JOIN `contact_companies` c_fk_cc ON attendees_fk_c.`contact_company_id` = c_fk_cc.`id`
WHERE attendees.`meeting_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `meeting_id` ASC, `contact_id` ASC
		$arrValues = array($meeting_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingAttendeesByMeetingId = array();
		while ($row = $db->fetch()) {
			$meetingAttendee = self::instantiateOrm($database, 'MeetingAttendee', $row);
			/* @var $meetingAttendee MeetingAttendee */
			$meetingAttendee->convertPropertiesToData();

			if (isset($row['meeting_id'])) {
				$meeting_id = $row['meeting_id'];
				$row['attendees_fk_m__id'] = $meeting_id;
				$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id, 'attendees_fk_m__');
				/* @var $meeting Meeting */
				$meeting->convertPropertiesToData();
			} else {
				$meeting = false;
			}
			$meetingAttendee->setMeeting($meeting);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['attendees_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'attendees_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$meetingAttendee->setContact($contact);

			if (isset($row['c_fk_cc__contact_company_id'])) {
				$contact_company_id = $row['c_fk_cc__contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrMeetingAttendeesByMeetingId[$contact_id] = $meetingAttendee;
		}

		$db->free_result();

		self::$_arrMeetingAttendeesByMeetingId = $arrMeetingAttendeesByMeetingId;

		return $arrMeetingAttendeesByMeetingId;
	}

	public static function loadMeetingAttendeesByMeetingIdAndProjectId($database, $meeting_id, $project_id) {

		$meeting_id = (int) $meeting_id;
		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);

		$query =
"
SELECT

	attendees_fk_m.`id` AS 'attendees_fk_m__meeting_id',
	attendees_fk_m.`previous_meeting_id` AS 'attendees_fk_m__previous_meeting_id',
	attendees_fk_m.`project_id` AS 'attendees_fk_m__project_id',
	attendees_fk_m.`meeting_type_id` AS 'attendees_fk_m__meeting_type_id',
	attendees_fk_m.`meeting_location_id` AS 'attendees_fk_m__meeting_location_id',
	attendees_fk_m.`meeting_chair_contact_id` AS 'attendees_fk_m__meeting_chair_contact_id',
	attendees_fk_m.`modified_by_contact_id` AS 'attendees_fk_m__modified_by_contact_id',
	attendees_fk_m.`meeting_sequence_number` AS 'attendees_fk_m__meeting_sequence_number',
	attendees_fk_m.`meeting_start_date` AS 'attendees_fk_m__meeting_start_date',
	attendees_fk_m.`meeting_start_time` AS 'attendees_fk_m__meeting_start_time',
	attendees_fk_m.`meeting_end_date` AS 'attendees_fk_m__meeting_end_date',
	attendees_fk_m.`meeting_end_time` AS 'attendees_fk_m__meeting_end_time',
	attendees_fk_m.`modified` AS 'attendees_fk_m__modified',
	attendees_fk_m.`created` AS 'attendees_fk_m__created',
	attendees_fk_m.`all_day_event_flag` AS 'attendees_fk_m__all_day_event_flag',

	attendees_fk_c.`id` AS 'attendees_fk_c__contact_id',
	attendees_fk_c.`user_company_id` AS 'attendees_fk_c__user_company_id',
	attendees_fk_c.`user_id` AS 'attendees_fk_c__user_id',
	attendees_fk_c.`contact_company_id` AS 'attendees_fk_c__contact_company_id',
	attendees_fk_c.`email` AS 'attendees_fk_c__email',
	attendees_fk_c.`name_prefix` AS 'attendees_fk_c__name_prefix',
	attendees_fk_c.`first_name` AS 'attendees_fk_c__first_name',
	attendees_fk_c.`additional_name` AS 'attendees_fk_c__additional_name',
	attendees_fk_c.`middle_name` AS 'attendees_fk_c__middle_name',
	attendees_fk_c.`last_name` AS 'attendees_fk_c__last_name',
	attendees_fk_c.`name_suffix` AS 'attendees_fk_c__name_suffix',
	attendees_fk_c.`title` AS 'attendees_fk_c__title',
	attendees_fk_c.`vendor_flag` AS 'attendees_fk_c__vendor_flag',
	attendees_fk_c.`is_archive` AS 'attendees_fk_c__is_archive',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	attendees.*

FROM `meeting_attendees` attendees
	INNER JOIN `meetings` attendees_fk_m ON attendees.`meeting_id` = attendees_fk_m.`id`
	INNER JOIN `contacts` attendees_fk_c ON attendees.`contact_id` = attendees_fk_c.`id`
	INNER JOIN `contact_companies` c_fk_cc ON attendees_fk_c.`contact_company_id` = c_fk_cc.`id`
	INNER JOIN `projects_to_contacts_to_roles` pcr ON attendees_fk_c.`id` = pcr.`contact_id`
	INNER JOIN `meeting_access_to_contact` mtc ON (pcr.`project_id` = mtc.`project_id` AND pcr.`role_id` = mtc.`role_id` AND attendees_fk_m.`meeting_type_id` = mtc.`meeting_type_id`)
WHERE attendees.`meeting_id` = ? AND mtc.`project_id` = ? ORDER BY attendees_fk_c.`first_name` ASC, attendees_fk_c.`last_name` ASC
";

		$arrValues = array($meeting_id,$project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingAttendeesByMeetingId = array();
		while ($row = $db->fetch()) {
			$meetingAttendee = self::instantiateOrm($database, 'MeetingAttendee', $row);
			/* @var $meetingAttendee MeetingAttendee */
			$meetingAttendee->convertPropertiesToData();

			if (isset($row['meeting_id'])) {
				$meeting_id = $row['meeting_id'];
				$row['attendees_fk_m__id'] = $meeting_id;
				$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id, 'attendees_fk_m__');
				/* @var $meeting Meeting */
				$meeting->convertPropertiesToData();
			} else {
				$meeting = false;
			}
			$meetingAttendee->setMeeting($meeting);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['attendees_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'attendees_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$meetingAttendee->setContact($contact);

			if (isset($row['c_fk_cc__contact_company_id'])) {
				$contact_company_id = $row['c_fk_cc__contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrMeetingAttendeesByMeetingId[$contact_id] = $meetingAttendee;
		}

		$db->free_result();

		self::$_arrMeetingAttendeesByMeetingId = $arrMeetingAttendeesByMeetingId;

		return $arrMeetingAttendeesByMeetingId;
	}

	/**
	 * Load by constraint `meeting_attendees_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingAttendeesByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrMeetingAttendeesByContactId = null;
		}

		$arrMeetingAttendeesByContactId = self::$_arrMeetingAttendeesByContactId;
		if (isset($arrMeetingAttendeesByContactId) && !empty($arrMeetingAttendeesByContactId)) {
			return $arrMeetingAttendeesByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `meeting_id` ASC, `contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingAttendee = new MeetingAttendee($database);
			$sqlOrderByColumns = $tmpMeetingAttendee->constructSqlOrderByColumns($arrOrderByAttributes);

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
	attendees.*

FROM `meeting_attendees` attendees
WHERE attendees.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `meeting_id` ASC, `contact_id` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingAttendeesByContactId = array();
		while ($row = $db->fetch()) {
			$meetingAttendee = self::instantiateOrm($database, 'MeetingAttendee', $row);
			/* @var $meetingAttendee MeetingAttendee */
			$arrMeetingAttendeesByContactId[] = $meetingAttendee;
		}

		$db->free_result();

		self::$_arrMeetingAttendeesByContactId = $arrMeetingAttendeesByContactId;

		return $arrMeetingAttendeesByContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all meeting_attendees records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllMeetingAttendees($database, Input $options=null)
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
			self::$_arrAllMeetingAttendees = null;
		}

		$arrAllMeetingAttendees = self::$_arrAllMeetingAttendees;
		if (isset($arrAllMeetingAttendees) && !empty($arrAllMeetingAttendees)) {
			return $arrAllMeetingAttendees;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `meeting_id` ASC, `contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingAttendee = new MeetingAttendee($database);
			$sqlOrderByColumns = $tmpMeetingAttendee->constructSqlOrderByColumns($arrOrderByAttributes);

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
	attendees.*

FROM `meeting_attendees` attendees{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `meeting_id` ASC, `contact_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllMeetingAttendees = array();
		while ($row = $db->fetch()) {
			$meetingAttendee = self::instantiateOrm($database, 'MeetingAttendee', $row);
			/* @var $meetingAttendee MeetingAttendee */
			$arrAllMeetingAttendees[] = $meetingAttendee;
		}

		$db->free_result();

		self::$_arrAllMeetingAttendees = $arrAllMeetingAttendees;

		return $arrAllMeetingAttendees;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all meeting_attendees records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function deleteAttendeesByMeetingId($database, $meeting_id)
	{
		

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
DELETE 
FROM `meeting_attendees`
WHERE `meeting_id` = ?
";
// LIMIT 10
// ORDER BY `meeting_id` ASC, `contact_id` ASC
		$arrValues = array($meeting_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$db->free_result();

		return true;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
	public function insertIgnore()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT IGNORE
INTO `meeting_attendees`
(`meeting_id`, `contact_id`)
VALUES (?, ?)
";
		$arrValues = array($this->meeting_id, $this->contact_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}
	public static function loadAllMeetingRolesForProject($database,$project_id)
	{
		$db = DBI::getInstance($database);
		$query = "SELECT * from `meeting_access_to_contact` where `project_id`=? ";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues);
		$meetingRoleArr = array();
		While($row =$db->fetch())
		{
			$meeting_type_id = $row['meeting_type_id'];
			$role_id = $row['role_id'];
			$meetingRoleArr[$role_id][$meeting_type_id] = $row;
		}
		$db->free_result();
		return $meetingRoleArr;

	}

	// To delete meeting_access_to_contact table by project_id and meeting_type_id
	public static function deleteMeetingAccessToContactByProIdAndMeetingId($database,$project_id,$meeting_type_id){
		$db = DBI::getInstance($database);
		$query = "DELETE from `meeting_access_to_contact` where `project_id`=? and `meeting_type_id` IN $meeting_type_id";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues);
		$db->free_result();
		return true;
	}

	// To get role_id form projects_to_roles_to_software_module_functions table
	public static function getRoleFromPermissionTable($database,$project_id,$meeting_moudle_id){
		$db = DBI::getInstance($database);
		$query = "SELECT * FROM `projects_to_roles_to_software_module_functions` where `project_id`=? and `software_module_function_id` IN $meeting_moudle_id";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues);
		$meetingRoleArr = array();
		While($row =$db->fetch())
		{
			$meeting_type_id = $row['software_module_function_id'];
            $role_id = $row['role_id'];
            $meetingRoleArr[$meeting_type_id][$role_id] = $row;       
		}
		$db->free_result();
		return $meetingRoleArr;
	}

	// To insert the Meeting Attendes to contact
	public static function InsertMeetingAttendeesToContact($database,$meeting_type_id,$role_id,$project_id,$is_check)
	{
		$db = DBI::getInstance($database);
		if($is_check == 'Y')
		{
		$query = "INSERT INTO `meeting_access_to_contact`(`project_id`, `meeting_type_id`, `role_id`) VALUES (?, ?, ?)";
		$arrValues = array($project_id, $meeting_type_id,$role_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		}else
		{
			$query = "DELETE from `meeting_access_to_contact` where `project_id`=? and `meeting_type_id` =? and  `role_id` = ?";
		$arrValues = array($project_id, $meeting_type_id,$role_id);
		$db->execute($query, $arrValues);
		}
		$db->free_result();
		return true;
	}


	public static function loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id, Input $options=null)
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
			self::$_arrAllMeetingAttendees = null;
		}

		$arrAllMeetingAttendees = self::$_arrAllMeetingAttendees;
		if (isset($arrAllMeetingAttendees) && !empty($arrAllMeetingAttendees)) {
			return $arrAllMeetingAttendees;
		}

		$project_id = (int) $project_id;
		$meeting_type_id = (int) $meeting_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `meeting_id` ASC, `contact_id` ASC
		// $sqlOrderBy = "\nORDER BY attendees_fk_c.`last_name` ASC, attendees_fk_c.`first_name` ASC, attendees_fk_c.`additional_name` ASC, attendees_fk_c.`middle_name` ASC, attendees_fk_c.`email` ASC";
		$sqlOrderBy = "\nORDER BY attendees_fk_c.`email` ASC";

		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingAttendee = new MeetingAttendee($database);
			$sqlOrderByColumns = $tmpMeetingAttendee->constructSqlOrderByColumns($arrOrderByAttributes);

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

		// @todo Figure out meeting_types for custom types by user_company_id
		// @ToDo: Remove this hack asap
		// meeting_types_to_smf_ids ???
		$meetingType = MeetingType::findById($database, $meeting_type_id);
		/* @var $meetingType MeetingType*/
		$software_module_function = '';
		if ($meetingType->meeting_type == 'Owner Meeting') {
			$software_module_function = "meetings_type_1";
		} elseif ($meetingType->meeting_type == 'LEED Meeting') {
			$software_module_function = "meetings_type_2";
		} elseif ($meetingType->meeting_type == 'Weekly Subcontractor Meeting') {
			$software_module_function = "meetings_type_3";
		} elseif ($meetingType->meeting_type == 'Internal Meeting') {
			$software_module_function = "meetings_type_4";
		}

		//$software_module_function = "meetings_type_$meeting_type_id";


		//$escaped_software_module_function = $db->escape($software_module_function);

		// Query partially pulled from Contacts.php
		$query =
"
SELECT

	attendees_fk_c.`id` AS 'attendees_fk_c__contact_id',
	attendees_fk_c.`user_company_id` AS 'attendees_fk_c__user_company_id',
	attendees_fk_c.`user_id` AS 'attendees_fk_c__user_id',
	attendees_fk_c.`contact_company_id` AS 'attendees_fk_c__contact_company_id',
	attendees_fk_c.`email` AS 'attendees_fk_c__email',
	attendees_fk_c.`name_prefix` AS 'attendees_fk_c__name_prefix',
	attendees_fk_c.`first_name` AS 'attendees_fk_c__first_name',
	attendees_fk_c.`additional_name` AS 'attendees_fk_c__additional_name',
	attendees_fk_c.`middle_name` AS 'attendees_fk_c__middle_name',
	attendees_fk_c.`last_name` AS 'attendees_fk_c__last_name',
	attendees_fk_c.`name_suffix` AS 'attendees_fk_c__name_suffix',
	attendees_fk_c.`title` AS 'attendees_fk_c__title',
	attendees_fk_c.`vendor_flag` AS 'attendees_fk_c__vendor_flag',
	attendees_fk_c.`is_archive` AS 'attendees_fk_c__is_archive',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag'

FROM `contacts` attendees_fk_c
	INNER JOIN `contact_companies` c_fk_cc ON attendees_fk_c.`contact_company_id` = c_fk_cc.`id`
	INNER JOIN `projects_to_contacts_to_roles` pcr ON attendees_fk_c.`id` = pcr.`contact_id`
	INNER JOIN `meeting_access_to_contact` mtc ON (pcr.`project_id` = mtc.`project_id` AND pcr.`role_id` = mtc.`role_id`)
WHERE mtc.`project_id` = ?
AND mtc.`meeting_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// ORDER BY `name_prefix`, `first_name`, `additional_name`, `middle_name`, `last_name`, `name_suffix`, `email`
		$arrValues = array($project_id, $meeting_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = array();
		while ($row = $db->fetch()) {
			if (isset($row['attendees_fk_c__contact_id'])) {
				$contact_id = $row['attendees_fk_c__contact_id'];
				$row['attendees_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'attendees_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}

			if (isset($row['c_fk_cc__contact_company_id'])) {
				$contact_company_id = $row['c_fk_cc__contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId[$contact_id] = $contact;
		}
		$db->free_result();

		return $arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
