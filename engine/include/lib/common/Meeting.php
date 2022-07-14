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
 * Meeting.
 *
 * @category   Framework
 * @package    Meeting
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class Meeting extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'Meeting';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'meetings';

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
	 * unique index `unique_meeting` (`project_id`,`meeting_location_id`,`meeting_start_date`,`meeting_start_time`)
	 * unique index `unique_meeting_by_sequence_number` (`project_id`,`meeting_type_id`,`meeting_sequence_number`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_meeting' => array(
			'project_id' => 'int',
			'meeting_location_id' => 'int',
			'meeting_start_date' => 'string',
			'meeting_start_time' => 'string'
		),
		'unique_meeting_by_sequence_number' => array(
			'project_id' => 'int',
			'meeting_type_id' => 'int',
			'meeting_sequence_number' => 'string'
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
		'id' => 'meeting_id',

		'previous_meeting_id' => 'previous_meeting_id',
		'project_id' => 'project_id',
		'meeting_type_id' => 'meeting_type_id',
		'meeting_location_id' => 'meeting_location_id',
		'meeting_chair_contact_id' => 'meeting_chair_contact_id',
		'modified_by_contact_id' => 'modified_by_contact_id',

		'meeting_sequence_number' => 'meeting_sequence_number',

		'meeting_start_date' => 'meeting_start_date',
		'meeting_start_time' => 'meeting_start_time',
		'meeting_end_date' => 'meeting_end_date',
		'meeting_end_time' => 'meeting_end_time',
		'modified' => 'modified',
		'created' => 'created',
		'all_day_event_flag' => 'all_day_event_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $meeting_id;

	public $previous_meeting_id;
	public $project_id;
	public $meeting_type_id;
	public $meeting_location_id;
	public $meeting_chair_contact_id;
	public $modified_by_contact_id;

	public $meeting_sequence_number;

	public $meeting_start_date;
	public $meeting_start_time;
	public $meeting_end_date;
	public $meeting_end_time;
	public $modified;
	public $created;
	public $all_day_event_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_meeting_sequence_number;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_meeting_sequence_number_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrMeetingsByPreviousMeetingId;
	protected static $_arrMeetingsByProjectId;
	protected static $_arrMeetingsByMeetingTypeId;
	protected static $_arrMeetingsByMeetingLocationId;
	protected static $_arrMeetingsByMeetingChairContactId;
	protected static $_arrMeetingsByModifiedByContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllMeetings;

	// Foreign Key Objects
	private $_previousMeeting;
	private $_project;
	private $_meetingType;
	private $_meetingLocation;
	private $_meetingChairContact;
	private $_modifiedByContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='meetings')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getPreviousMeeting()
	{
		if (isset($this->_previousMeeting)) {
			return $this->_previousMeeting;
		} else {
			return false;
		}
	}

	public function setPreviousMeeting($previousMeeting)
	{
		$this->_previousMeeting = $previousMeeting;
	}

	public function getProject()
	{
		if (isset($this->_project)) {
			return $this->_project;
		} else {
			return false;
		}
	}

	public function setProject($project)
	{
		$this->_project = $project;
	}

	public function getMeetingType()
	{
		if (isset($this->_meetingType)) {
			return $this->_meetingType;
		} else {
			return false;
		}
	}

	public function setMeetingType($meetingType)
	{
		$this->_meetingType = $meetingType;
	}

	public function getMeetingLocation()
	{
		if (isset($this->_meetingLocation)) {
			return $this->_meetingLocation;
		} else {
			return false;
		}
	}

	public function setMeetingLocation($meetingLocation)
	{
		$this->_meetingLocation = $meetingLocation;
	}

	public function getMeetingChairContact()
	{
		if (isset($this->_meetingChairContact)) {
			return $this->_meetingChairContact;
		} else {
			return false;
		}
	}

	public function setMeetingChairContact($meetingChairContact)
	{
		$this->_meetingChairContact = $meetingChairContact;
	}

	public function getModifiedByContact()
	{
		if (isset($this->_modifiedByContact)) {
			return $this->_modifiedByContact;
		} else {
			return false;
		}
	}

	public function setModifiedByContact($modifiedByContact)
	{
		$this->_modifiedByContact = $modifiedByContact;
	}

	public function getNextMeeting()
	{
		if (isset($this->_nextMeeting)) {
			return $this->_nextMeeting;
		} else {
			return false;
		}
	}

	public function setNextMeeting($nextMeeting)
	{
		$this->_nextMeeting = $nextMeeting;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrMeetingsByPreviousMeetingId()
	{
		if (isset(self::$_arrMeetingsByPreviousMeetingId)) {
			return self::$_arrMeetingsByPreviousMeetingId;
		} else {
			return false;
		}
	}

	public static function setArrMeetingsByPreviousMeetingId($arrMeetingsByPreviousMeetingId)
	{
		self::$_arrMeetingsByPreviousMeetingId = $arrMeetingsByPreviousMeetingId;
	}

	public static function getArrMeetingsByProjectId()
	{
		if (isset(self::$_arrMeetingsByProjectId)) {
			return self::$_arrMeetingsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrMeetingsByProjectId($arrMeetingsByProjectId)
	{
		self::$_arrMeetingsByProjectId = $arrMeetingsByProjectId;
	}

	public static function getArrMeetingsByMeetingTypeId()
	{
		if (isset(self::$_arrMeetingsByMeetingTypeId)) {
			return self::$_arrMeetingsByMeetingTypeId;
		} else {
			return null;
		}
	}

	public static function setArrMeetingsByMeetingTypeId($arrMeetingsByMeetingTypeId)
	{
		self::$_arrMeetingsByMeetingTypeId = $arrMeetingsByMeetingTypeId;
	}

	public static function getArrMeetingsByMeetingLocationId()
	{
		if (isset(self::$_arrMeetingsByMeetingLocationId)) {
			return self::$_arrMeetingsByMeetingLocationId;
		} else {
			return null;
		}
	}

	public static function setArrMeetingsByMeetingLocationId($arrMeetingsByMeetingLocationId)
	{
		self::$_arrMeetingsByMeetingLocationId = $arrMeetingsByMeetingLocationId;
	}

	public static function getArrMeetingsByMeetingChairContactId()
	{
		if (isset(self::$_arrMeetingsByMeetingChairContactId)) {
			return self::$_arrMeetingsByMeetingChairContactId;
		} else {
			return null;
		}
	}

	public static function setArrMeetingsByMeetingChairContactId($arrMeetingsByMeetingChairContactId)
	{
		self::$_arrMeetingsByMeetingChairContactId = $arrMeetingsByMeetingChairContactId;
	}

	public static function getArrMeetingsByModifiedByContactId()
	{
		if (isset(self::$_arrMeetingsByModifiedByContactId)) {
			return self::$_arrMeetingsByModifiedByContactId;
		} else {
			return null;
		}
	}

	public static function setArrMeetingsByModifiedByContactId($arrMeetingsByModifiedByContactId)
	{
		self::$_arrMeetingsByModifiedByContactId = $arrMeetingsByModifiedByContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllMeetings()
	{
		if (isset(self::$_arrAllMeetings)) {
			return self::$_arrAllMeetings;
		} else {
			return null;
		}
	}

	public static function setArrAllMeetings($arrAllMeetings)
	{
		self::$_arrAllMeetings = $arrAllMeetings;
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
	 * @param int $meeting_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $meeting_id,$table='meetings', $module='Meeting')
	{
		$meeting = parent::findById($database, $meeting_id, $table, $module);

		return $meeting;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $meeting_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findMeetingByIdExtended($database, $meeting_id)
	{
		$meeting_id = (int) $meeting_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	m_fk_previous_m.`id` AS 'm_fk_previous_m__meeting_id',
	m_fk_previous_m.`previous_meeting_id` AS 'm_fk_previous_m__previous_meeting_id',
	m_fk_previous_m.`project_id` AS 'm_fk_previous_m__project_id',
	m_fk_previous_m.`meeting_type_id` AS 'm_fk_previous_m__meeting_type_id',
	m_fk_previous_m.`meeting_location_id` AS 'm_fk_previous_m__meeting_location_id',
	m_fk_previous_m.`meeting_chair_contact_id` AS 'm_fk_previous_m__meeting_chair_contact_id',
	m_fk_previous_m.`modified_by_contact_id` AS 'm_fk_previous_m__modified_by_contact_id',
	m_fk_previous_m.`meeting_sequence_number` AS 'm_fk_previous_m__meeting_sequence_number',
	m_fk_previous_m.`meeting_start_date` AS 'm_fk_previous_m__meeting_start_date',
	m_fk_previous_m.`meeting_start_time` AS 'm_fk_previous_m__meeting_start_time',
	m_fk_previous_m.`meeting_end_date` AS 'm_fk_previous_m__meeting_end_date',
	m_fk_previous_m.`meeting_end_time` AS 'm_fk_previous_m__meeting_end_time',
	m_fk_previous_m.`modified` AS 'm_fk_previous_m__modified',
	m_fk_previous_m.`created` AS 'm_fk_previous_m__created',
	m_fk_previous_m.`all_day_event_flag` AS 'm_fk_previous_m__all_day_event_flag',

	m_fk_p.`id` AS 'm_fk_p__project_id',
	m_fk_p.`project_type_id` AS 'm_fk_p__project_type_id',
	m_fk_p.`user_company_id` AS 'm_fk_p__user_company_id',
	m_fk_p.`user_custom_project_id` AS 'm_fk_p__user_custom_project_id',
	m_fk_p.`project_name` AS 'm_fk_p__project_name',
	m_fk_p.`project_owner_name` AS 'm_fk_p__project_owner_name',
	m_fk_p.`latitude` AS 'm_fk_p__latitude',
	m_fk_p.`longitude` AS 'm_fk_p__longitude',
	m_fk_p.`address_line_1` AS 'm_fk_p__address_line_1',
	m_fk_p.`address_line_2` AS 'm_fk_p__address_line_2',
	m_fk_p.`address_line_3` AS 'm_fk_p__address_line_3',
	m_fk_p.`address_line_4` AS 'm_fk_p__address_line_4',
	m_fk_p.`address_city` AS 'm_fk_p__address_city',
	m_fk_p.`address_county` AS 'm_fk_p__address_county',
	m_fk_p.`address_state_or_region` AS 'm_fk_p__address_state_or_region',
	m_fk_p.`address_postal_code` AS 'm_fk_p__address_postal_code',
	m_fk_p.`address_postal_code_extension` AS 'm_fk_p__address_postal_code_extension',
	m_fk_p.`address_country` AS 'm_fk_p__address_country',
	m_fk_p.`building_count` AS 'm_fk_p__building_count',
	m_fk_p.`unit_count` AS 'm_fk_p__unit_count',
	m_fk_p.`gross_square_footage` AS 'm_fk_p__gross_square_footage',
	m_fk_p.`net_rentable_square_footage` AS 'm_fk_p__net_rentable_square_footage',
	m_fk_p.`is_active_flag` AS 'm_fk_p__is_active_flag',
	m_fk_p.`public_plans_flag` AS 'm_fk_p__public_plans_flag',
	m_fk_p.`prevailing_wage_flag` AS 'm_fk_p__prevailing_wage_flag',
	m_fk_p.`city_business_license_required_flag` AS 'm_fk_p__city_business_license_required_flag',
	m_fk_p.`is_internal_flag` AS 'm_fk_p__is_internal_flag',
	m_fk_p.`project_contract_date` AS 'm_fk_p__project_contract_date',
	m_fk_p.`project_start_date` AS 'm_fk_p__project_start_date',
	m_fk_p.`project_completed_date` AS 'm_fk_p__project_completed_date',
	m_fk_p.`sort_order` AS 'm_fk_p__sort_order',

	m_fk_mt.`id` AS 'm_fk_mt__meeting_type_id',
	m_fk_mt.`project_id` AS 'm_fk_mt__project_id',
	m_fk_mt.`meeting_type` AS 'm_fk_mt__meeting_type',
	m_fk_mt.`meeting_type_abbreviation` AS 'm_fk_mt__meeting_type_abbreviation',
	m_fk_mt.`show_construction_flag` AS 'm_fk_mt__show_construction_flag',
	m_fk_mt.`show_schedule_flag` AS 'm_fk_mt__show_schedule_flag',
	m_fk_mt.`show_plans_flag` AS 'm_fk_mt__show_plans_flag',
	m_fk_mt.`show_delays_flag` AS 'm_fk_mt__show_delays_flag',
	m_fk_mt.`show_rfis_flag` AS 'm_fk_mt__show_rfis_flag',
	m_fk_mt.`sort_order` AS 'm_fk_mt__sort_order',

	m_fk_ml.`id` AS 'm_fk_ml__meeting_location_id',
	m_fk_ml.`user_company_id` AS 'm_fk_ml__user_company_id',
	m_fk_ml.`meeting_location` AS 'm_fk_ml__meeting_location',
	m_fk_ml.`meeting_location_abbreviation` AS 'm_fk_ml__meeting_location_abbreviation',
	m_fk_ml.`sort_order` AS 'm_fk_ml__sort_order',

	m_fk_chair_c.`id` AS 'm_fk_chair_c__contact_id',
	m_fk_chair_c.`user_company_id` AS 'm_fk_chair_c__user_company_id',
	m_fk_chair_c.`user_id` AS 'm_fk_chair_c__user_id',
	m_fk_chair_c.`contact_company_id` AS 'm_fk_chair_c__contact_company_id',
	m_fk_chair_c.`email` AS 'm_fk_chair_c__email',
	m_fk_chair_c.`name_prefix` AS 'm_fk_chair_c__name_prefix',
	m_fk_chair_c.`first_name` AS 'm_fk_chair_c__first_name',
	m_fk_chair_c.`additional_name` AS 'm_fk_chair_c__additional_name',
	m_fk_chair_c.`middle_name` AS 'm_fk_chair_c__middle_name',
	m_fk_chair_c.`last_name` AS 'm_fk_chair_c__last_name',
	m_fk_chair_c.`name_suffix` AS 'm_fk_chair_c__name_suffix',
	m_fk_chair_c.`title` AS 'm_fk_chair_c__title',
	m_fk_chair_c.`vendor_flag` AS 'm_fk_chair_c__vendor_flag',

	m_fk_modified_by_c.`id` AS 'm_fk_modified_by_c__contact_id',
	m_fk_modified_by_c.`user_company_id` AS 'm_fk_modified_by_c__user_company_id',
	m_fk_modified_by_c.`user_id` AS 'm_fk_modified_by_c__user_id',
	m_fk_modified_by_c.`contact_company_id` AS 'm_fk_modified_by_c__contact_company_id',
	m_fk_modified_by_c.`email` AS 'm_fk_modified_by_c__email',
	m_fk_modified_by_c.`name_prefix` AS 'm_fk_modified_by_c__name_prefix',
	m_fk_modified_by_c.`first_name` AS 'm_fk_modified_by_c__first_name',
	m_fk_modified_by_c.`additional_name` AS 'm_fk_modified_by_c__additional_name',
	m_fk_modified_by_c.`middle_name` AS 'm_fk_modified_by_c__middle_name',
	m_fk_modified_by_c.`last_name` AS 'm_fk_modified_by_c__last_name',
	m_fk_modified_by_c.`name_suffix` AS 'm_fk_modified_by_c__name_suffix',
	m_fk_modified_by_c.`title` AS 'm_fk_modified_by_c__title',
	m_fk_modified_by_c.`vendor_flag` AS 'm_fk_modified_by_c__vendor_flag',

	m.*

FROM `meetings` m
	LEFT OUTER JOIN `meetings` m_fk_previous_m ON m.`previous_meeting_id` = m_fk_previous_m.`id`
	INNER JOIN `projects` m_fk_p ON m.`project_id` = m_fk_p.`id`
	INNER JOIN `meeting_types` m_fk_mt ON m.`meeting_type_id` = m_fk_mt.`id`
	INNER JOIN `meeting_locations` m_fk_ml ON m.`meeting_location_id` = m_fk_ml.`id`
	INNER JOIN `contacts` m_fk_chair_c ON m.`meeting_chair_contact_id` = m_fk_chair_c.`id`
	INNER JOIN `contacts` m_fk_modified_by_c ON m.`modified_by_contact_id` = m_fk_modified_by_c.`id`
WHERE m.`id` = ?
";
		$arrValues = array($meeting_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$meeting->convertPropertiesToData();

			if (isset($row['previous_meeting_id'])) {
				$previous_meeting_id = $row['previous_meeting_id'];
				$row['m_fk_previous_m__id'] = $previous_meeting_id;
				$previousMeeting = self::instantiateOrm($database, 'Meeting', $row, null, $previous_meeting_id, 'm_fk_previous_m__');
				/* @var $previousMeeting Meeting */
				$previousMeeting->convertPropertiesToData();
			} else {
				$previousMeeting = false;
			}
			$meeting->setPreviousMeeting($previousMeeting);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['m_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'm_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$meeting->setProject($project);

			if (isset($row['meeting_type_id'])) {
				$meeting_type_id = $row['meeting_type_id'];
				$row['m_fk_mt__id'] = $meeting_type_id;
				$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id, 'm_fk_mt__');
				/* @var $meetingType MeetingType */
				$meetingType->convertPropertiesToData();
			} else {
				$meetingType = false;
			}
			$meeting->setMeetingType($meetingType);

			if (isset($row['meeting_location_id'])) {
				$meeting_location_id = $row['meeting_location_id'];
				$row['m_fk_ml__id'] = $meeting_location_id;
				$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id, 'm_fk_ml__');
				/* @var $meetingLocation MeetingLocation */
				$meetingLocation->convertPropertiesToData();
			} else {
				$meetingLocation = false;
			}
			$meeting->setMeetingLocation($meetingLocation);

			if (isset($row['meeting_chair_contact_id'])) {
				$meeting_chair_contact_id = $row['meeting_chair_contact_id'];
				$row['m_fk_chair_c__id'] = $meeting_chair_contact_id;
				$meetingChairContact = self::instantiateOrm($database, 'Contact', $row, null, $meeting_chair_contact_id, 'm_fk_chair_c__');
				/* @var $meetingChairContact Contact */
				$meetingChairContact->convertPropertiesToData();
			} else {
				$meetingChairContact = false;
			}
			$meeting->setMeetingChairContact($meetingChairContact);

			if (isset($row['modified_by_contact_id'])) {
				$modified_by_contact_id = $row['modified_by_contact_id'];
				$row['m_fk_modified_by_c__id'] = $modified_by_contact_id;
				$modifiedByContact = self::instantiateOrm($database, 'Contact', $row, null, $modified_by_contact_id, 'm_fk_modified_by_c__');
				/* @var $modifiedByContact Contact */
				$modifiedByContact->convertPropertiesToData();
			} else {
				$modifiedByContact = false;
			}
			$meeting->setModifiedByContact($modifiedByContact);

			return $meeting;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_meeting` (`project_id`,`meeting_location_id`,`meeting_start_date`,`meeting_start_time`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $meeting_location_id
	 * @param string $meeting_start_date
	 * @param string $meeting_start_time
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndMeetingLocationIdAndMeetingStartDateAndMeetingStartTime($database, $project_id, $meeting_location_id, $meeting_start_date, $meeting_start_time)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	m.*

FROM `meetings` m
WHERE m.`project_id` = ?
AND m.`meeting_location_id` = ?
AND m.`meeting_start_date` = ?
AND m.`meeting_start_time` = ?
";
		$arrValues = array($project_id, $meeting_location_id, $meeting_start_date, $meeting_start_time);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			return $meeting;
		} else {
			return false;
		}
	}

	/**
	 * Find by unique index `unique_meeting_by_sequence_number` (`project_id`,`meeting_type_id`,`meeting_sequence_number`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $meeting_type_id
	 * @param string $meeting_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndMeetingTypeIdAndMeetingSequenceNumber($database, $project_id, $meeting_type_id, $meeting_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	m.*

FROM `meetings` m
WHERE m.`project_id` = ?
AND m.`meeting_type_id` = ?
AND m.`meeting_sequence_number` = ?
";
		$arrValues = array($project_id, $meeting_type_id, $meeting_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			return $meeting;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrMeetingIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingsByArrMeetingIds($database, $arrMeetingIds, Input $options=null)
	{
		if (empty($arrMeetingIds)) {
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
		// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeeting = new Meeting($database);
			$sqlOrderByColumns = $tmpMeeting->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrMeetingIds as $k => $meeting_id) {
			$meeting_id = (int) $meeting_id;
			$arrMeetingIds[$k] = $db->escape($meeting_id);
		}
		$csvMeetingIds = join(',', $arrMeetingIds);

		$query =
"
SELECT

	m.*

FROM `meetings` m
WHERE m.`id` IN ($csvMeetingIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrMeetingsByCsvMeetingIds = array();
		while ($row = $db->fetch()) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$meeting->convertPropertiesToData();

			$arrMeetingsByCsvMeetingIds[$meeting_id] = $meeting;
		}

		$db->free_result();

		return $arrMeetingsByCsvMeetingIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `meetings_fk_previous_m` foreign key (`previous_meeting_id`) references `meetings` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $previous_meeting_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingsByPreviousMeetingId($database, $previous_meeting_id, Input $options=null)
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
			self::$_arrMeetingsByPreviousMeetingId = null;
		}

		$arrMeetingsByPreviousMeetingId = self::$_arrMeetingsByPreviousMeetingId;
		if (isset($arrMeetingsByPreviousMeetingId) && !empty($arrMeetingsByPreviousMeetingId)) {
			return $arrMeetingsByPreviousMeetingId;
		}

		$previous_meeting_id = (int) $previous_meeting_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeeting = new Meeting($database);
			$sqlOrderByColumns = $tmpMeeting->constructSqlOrderByColumns($arrOrderByAttributes);

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
	m.*

FROM `meetings` m
WHERE m.`previous_meeting_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$arrValues = array($previous_meeting_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingsByPreviousMeetingId = array();
		while ($row = $db->fetch()) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$arrMeetingsByPreviousMeetingId[$meeting_id] = $meeting;
		}

		$db->free_result();

		self::$_arrMeetingsByPreviousMeetingId = $arrMeetingsByPreviousMeetingId;

		return $arrMeetingsByPreviousMeetingId;
	}

	/**
	 * Load by constraint `meetings_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrMeetingsByProjectId = null;
		}

		$arrMeetingsByProjectId = self::$_arrMeetingsByProjectId;
		if (isset($arrMeetingsByProjectId) && !empty($arrMeetingsByProjectId)) {
			return $arrMeetingsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeeting = new Meeting($database);
			$sqlOrderByColumns = $tmpMeeting->constructSqlOrderByColumns($arrOrderByAttributes);

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
	m.*

FROM `meetings` m
WHERE m.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingsByProjectId = array();
		while ($row = $db->fetch()) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$arrMeetingsByProjectId[$meeting_id] = $meeting;
		}

		$db->free_result();

		self::$_arrMeetingsByProjectId = $arrMeetingsByProjectId;

		return $arrMeetingsByProjectId;
	}

	/**
	 * Load by constraint `meetings_fk_mt` foreign key (`meeting_type_id`) references `meeting_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $meeting_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingsByMeetingTypeId($database, $meeting_type_id, Input $options=null)
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
			self::$_arrMeetingsByMeetingTypeId = null;
		}

		$arrMeetingsByMeetingTypeId = self::$_arrMeetingsByMeetingTypeId;
		if (isset($arrMeetingsByMeetingTypeId) && !empty($arrMeetingsByMeetingTypeId)) {
			return $arrMeetingsByMeetingTypeId;
		}

		$meeting_type_id = (int) $meeting_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$sqlOrderBy = "\nORDER BY m.`meeting_start_date` DESC, m.`meeting_start_time` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeeting = new Meeting($database);
			$sqlOrderByColumns = $tmpMeeting->constructSqlOrderByColumns($arrOrderByAttributes);

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

	m_fk_previous_m.`id` AS 'm_fk_previous_m__meeting_id',
	m_fk_previous_m.`previous_meeting_id` AS 'm_fk_previous_m__previous_meeting_id',
	m_fk_previous_m.`project_id` AS 'm_fk_previous_m__project_id',
	m_fk_previous_m.`meeting_type_id` AS 'm_fk_previous_m__meeting_type_id',
	m_fk_previous_m.`meeting_location_id` AS 'm_fk_previous_m__meeting_location_id',
	m_fk_previous_m.`meeting_chair_contact_id` AS 'm_fk_previous_m__meeting_chair_contact_id',
	m_fk_previous_m.`modified_by_contact_id` AS 'm_fk_previous_m__modified_by_contact_id',
	m_fk_previous_m.`meeting_sequence_number` AS 'm_fk_previous_m__meeting_sequence_number',
	m_fk_previous_m.`meeting_start_date` AS 'm_fk_previous_m__meeting_start_date',
	m_fk_previous_m.`meeting_start_time` AS 'm_fk_previous_m__meeting_start_time',
	m_fk_previous_m.`meeting_end_date` AS 'm_fk_previous_m__meeting_end_date',
	m_fk_previous_m.`meeting_end_time` AS 'm_fk_previous_m__meeting_end_time',
	m_fk_previous_m.`modified` AS 'm_fk_previous_m__modified',
	m_fk_previous_m.`created` AS 'm_fk_previous_m__created',
	m_fk_previous_m.`all_day_event_flag` AS 'm_fk_previous_m__all_day_event_flag',

	m_fk_p.`id` AS 'm_fk_p__project_id',
	m_fk_p.`project_type_id` AS 'm_fk_p__project_type_id',
	m_fk_p.`user_company_id` AS 'm_fk_p__user_company_id',
	m_fk_p.`user_custom_project_id` AS 'm_fk_p__user_custom_project_id',
	m_fk_p.`project_name` AS 'm_fk_p__project_name',
	m_fk_p.`project_owner_name` AS 'm_fk_p__project_owner_name',
	m_fk_p.`latitude` AS 'm_fk_p__latitude',
	m_fk_p.`longitude` AS 'm_fk_p__longitude',
	m_fk_p.`address_line_1` AS 'm_fk_p__address_line_1',
	m_fk_p.`address_line_2` AS 'm_fk_p__address_line_2',
	m_fk_p.`address_line_3` AS 'm_fk_p__address_line_3',
	m_fk_p.`address_line_4` AS 'm_fk_p__address_line_4',
	m_fk_p.`address_city` AS 'm_fk_p__address_city',
	m_fk_p.`address_county` AS 'm_fk_p__address_county',
	m_fk_p.`address_state_or_region` AS 'm_fk_p__address_state_or_region',
	m_fk_p.`address_postal_code` AS 'm_fk_p__address_postal_code',
	m_fk_p.`address_postal_code_extension` AS 'm_fk_p__address_postal_code_extension',
	m_fk_p.`address_country` AS 'm_fk_p__address_country',
	m_fk_p.`building_count` AS 'm_fk_p__building_count',
	m_fk_p.`unit_count` AS 'm_fk_p__unit_count',
	m_fk_p.`gross_square_footage` AS 'm_fk_p__gross_square_footage',
	m_fk_p.`net_rentable_square_footage` AS 'm_fk_p__net_rentable_square_footage',
	m_fk_p.`is_active_flag` AS 'm_fk_p__is_active_flag',
	m_fk_p.`public_plans_flag` AS 'm_fk_p__public_plans_flag',
	m_fk_p.`prevailing_wage_flag` AS 'm_fk_p__prevailing_wage_flag',
	m_fk_p.`city_business_license_required_flag` AS 'm_fk_p__city_business_license_required_flag',
	m_fk_p.`is_internal_flag` AS 'm_fk_p__is_internal_flag',
	m_fk_p.`project_contract_date` AS 'm_fk_p__project_contract_date',
	m_fk_p.`project_start_date` AS 'm_fk_p__project_start_date',
	m_fk_p.`project_completed_date` AS 'm_fk_p__project_completed_date',
	m_fk_p.`sort_order` AS 'm_fk_p__sort_order',

	m_fk_mt.`id` AS 'm_fk_mt__meeting_type_id',
	m_fk_mt.`project_id` AS 'm_fk_mt__project_id',
	m_fk_mt.`meeting_type` AS 'm_fk_mt__meeting_type',
	m_fk_mt.`meeting_type_abbreviation` AS 'm_fk_mt__meeting_type_abbreviation',
	m_fk_mt.`show_construction_flag` AS 'm_fk_mt__show_construction_flag',
	m_fk_mt.`show_schedule_flag` AS 'm_fk_mt__show_schedule_flag',
	m_fk_mt.`show_plans_flag` AS 'm_fk_mt__show_plans_flag',
	m_fk_mt.`show_delays_flag` AS 'm_fk_mt__show_delays_flag',
	m_fk_mt.`show_rfis_flag` AS 'm_fk_mt__show_rfis_flag',
	m_fk_mt.`sort_order` AS 'm_fk_mt__sort_order',

	m_fk_ml.`id` AS 'm_fk_ml__meeting_location_id',
	m_fk_ml.`user_company_id` AS 'm_fk_ml__user_company_id',
	m_fk_ml.`meeting_location` AS 'm_fk_ml__meeting_location',
	m_fk_ml.`meeting_location_abbreviation` AS 'm_fk_ml__meeting_location_abbreviation',
	m_fk_ml.`sort_order` AS 'm_fk_ml__sort_order',

	m_fk_chair_c.`id` AS 'm_fk_chair_c__contact_id',
	m_fk_chair_c.`user_company_id` AS 'm_fk_chair_c__user_company_id',
	m_fk_chair_c.`user_id` AS 'm_fk_chair_c__user_id',
	m_fk_chair_c.`contact_company_id` AS 'm_fk_chair_c__contact_company_id',
	m_fk_chair_c.`email` AS 'm_fk_chair_c__email',
	m_fk_chair_c.`name_prefix` AS 'm_fk_chair_c__name_prefix',
	m_fk_chair_c.`first_name` AS 'm_fk_chair_c__first_name',
	m_fk_chair_c.`additional_name` AS 'm_fk_chair_c__additional_name',
	m_fk_chair_c.`middle_name` AS 'm_fk_chair_c__middle_name',
	m_fk_chair_c.`last_name` AS 'm_fk_chair_c__last_name',
	m_fk_chair_c.`name_suffix` AS 'm_fk_chair_c__name_suffix',
	m_fk_chair_c.`title` AS 'm_fk_chair_c__title',
	m_fk_chair_c.`vendor_flag` AS 'm_fk_chair_c__vendor_flag',

	m_fk_modified_by_c.`id` AS 'm_fk_modified_by_c__contact_id',
	m_fk_modified_by_c.`user_company_id` AS 'm_fk_modified_by_c__user_company_id',
	m_fk_modified_by_c.`user_id` AS 'm_fk_modified_by_c__user_id',
	m_fk_modified_by_c.`contact_company_id` AS 'm_fk_modified_by_c__contact_company_id',
	m_fk_modified_by_c.`email` AS 'm_fk_modified_by_c__email',
	m_fk_modified_by_c.`name_prefix` AS 'm_fk_modified_by_c__name_prefix',
	m_fk_modified_by_c.`first_name` AS 'm_fk_modified_by_c__first_name',
	m_fk_modified_by_c.`additional_name` AS 'm_fk_modified_by_c__additional_name',
	m_fk_modified_by_c.`middle_name` AS 'm_fk_modified_by_c__middle_name',
	m_fk_modified_by_c.`last_name` AS 'm_fk_modified_by_c__last_name',
	m_fk_modified_by_c.`name_suffix` AS 'm_fk_modified_by_c__name_suffix',
	m_fk_modified_by_c.`title` AS 'm_fk_modified_by_c__title',
	m_fk_modified_by_c.`vendor_flag` AS 'm_fk_modified_by_c__vendor_flag',

	m.*

FROM `meetings` m
	LEFT OUTER JOIN `meetings` m_fk_previous_m ON m.`previous_meeting_id` = m_fk_previous_m.`id`
	INNER JOIN `projects` m_fk_p ON m.`project_id` = m_fk_p.`id`
	INNER JOIN `meeting_types` m_fk_mt ON m.`meeting_type_id` = m_fk_mt.`id`
	INNER JOIN `meeting_locations` m_fk_ml ON m.`meeting_location_id` = m_fk_ml.`id`
	INNER JOIN `contacts` m_fk_chair_c ON m.`meeting_chair_contact_id` = m_fk_chair_c.`id`
	INNER JOIN `contacts` m_fk_modified_by_c ON m.`modified_by_contact_id` = m_fk_modified_by_c.`id`
WHERE m.`meeting_type_id` = ?
AND m.`meeting_sequence_number` <> ''{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$arrValues = array($meeting_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingsByMeetingTypeId = array();
		while ($row = $db->fetch()) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$meeting->convertPropertiesToData();

			if (isset($row['previous_meeting_id'])) {
				$previous_meeting_id = $row['previous_meeting_id'];
				$row['m_fk_previous_m__id'] = $previous_meeting_id;
				$previousMeeting = self::instantiateOrm($database, 'Meeting', $row, null, $previous_meeting_id, 'm_fk_previous_m__');
				/* @var $previousMeeting Meeting */
				$previousMeeting->convertPropertiesToData();
			} else {
				$previousMeeting = false;
			}
			$meeting->setPreviousMeeting($previousMeeting);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['m_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'm_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$meeting->setProject($project);

			if (isset($row['meeting_type_id'])) {
				$meeting_type_id = $row['meeting_type_id'];
				$row['m_fk_mt__id'] = $meeting_type_id;
				$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id, 'm_fk_mt__');
				/* @var $meetingType MeetingType */
				$meetingType->convertPropertiesToData();
			} else {
				$meetingType = false;
			}
			$meeting->setMeetingType($meetingType);

			if (isset($row['meeting_location_id'])) {
				$meeting_location_id = $row['meeting_location_id'];
				$row['m_fk_ml__id'] = $meeting_location_id;
				$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id, 'm_fk_ml__');
				/* @var $meetingLocation MeetingLocation */
				$meetingLocation->convertPropertiesToData();
			} else {
				$meetingLocation = false;
			}
			$meeting->setMeetingLocation($meetingLocation);

			if (isset($row['meeting_chair_contact_id'])) {
				$meeting_chair_contact_id = $row['meeting_chair_contact_id'];
				$row['m_fk_chair_c__id'] = $meeting_chair_contact_id;
				$meetingChairContact = self::instantiateOrm($database, 'Contact', $row, null, $meeting_chair_contact_id, 'm_fk_chair_c__');
				/* @var $meetingChairContact Contact */
				$meetingChairContact->convertPropertiesToData();
			} else {
				$meetingChairContact = false;
			}
			$meeting->setMeetingChairContact($meetingChairContact);

			if (isset($row['modified_by_contact_id'])) {
				$modified_by_contact_id = $row['modified_by_contact_id'];
				$row['m_fk_modified_by_c__id'] = $modified_by_contact_id;
				$modifiedByContact = self::instantiateOrm($database, 'Contact', $row, null, $modified_by_contact_id, 'm_fk_modified_by_c__');
				/* @var $modifiedByContact Contact */
				$modifiedByContact->convertPropertiesToData();
			} else {
				$modifiedByContact = false;
			}
			$meeting->setModifiedByContact($modifiedByContact);

			$arrMeetingsByMeetingTypeId[$meeting_id] = $meeting;
		}

		$db->free_result();

		self::$_arrMeetingsByMeetingTypeId = $arrMeetingsByMeetingTypeId;

		return $arrMeetingsByMeetingTypeId;
	}

	/**
	 * Load by constraint `meetings_fk_ml` foreign key (`meeting_location_id`) references `meeting_locations` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $meeting_location_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingsByMeetingLocationId($database, $meeting_location_id, Input $options=null)
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
			self::$_arrMeetingsByMeetingLocationId = null;
		}

		$arrMeetingsByMeetingLocationId = self::$_arrMeetingsByMeetingLocationId;
		if (isset($arrMeetingsByMeetingLocationId) && !empty($arrMeetingsByMeetingLocationId)) {
			return $arrMeetingsByMeetingLocationId;
		}

		$meeting_location_id = (int) $meeting_location_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeeting = new Meeting($database);
			$sqlOrderByColumns = $tmpMeeting->constructSqlOrderByColumns($arrOrderByAttributes);

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
	m.*

FROM `meetings` m
WHERE m.`meeting_location_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$arrValues = array($meeting_location_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingsByMeetingLocationId = array();
		while ($row = $db->fetch()) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$arrMeetingsByMeetingLocationId[$meeting_id] = $meeting;
		}

		$db->free_result();

		self::$_arrMeetingsByMeetingLocationId = $arrMeetingsByMeetingLocationId;

		return $arrMeetingsByMeetingLocationId;
	}

	/**
	 * Load by constraint `meetings_fk_chair_c` foreign key (`meeting_chair_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $meeting_chair_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingsByMeetingChairContactId($database, $meeting_chair_contact_id, Input $options=null)
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
			self::$_arrMeetingsByMeetingChairContactId = null;
		}

		$arrMeetingsByMeetingChairContactId = self::$_arrMeetingsByMeetingChairContactId;
		if (isset($arrMeetingsByMeetingChairContactId) && !empty($arrMeetingsByMeetingChairContactId)) {
			return $arrMeetingsByMeetingChairContactId;
		}

		$meeting_chair_contact_id = (int) $meeting_chair_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeeting = new Meeting($database);
			$sqlOrderByColumns = $tmpMeeting->constructSqlOrderByColumns($arrOrderByAttributes);

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
	m.*

FROM `meetings` m
WHERE m.`meeting_chair_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$arrValues = array($meeting_chair_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingsByMeetingChairContactId = array();
		while ($row = $db->fetch()) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$arrMeetingsByMeetingChairContactId[$meeting_id] = $meeting;
		}

		$db->free_result();

		self::$_arrMeetingsByMeetingChairContactId = $arrMeetingsByMeetingChairContactId;

		return $arrMeetingsByMeetingChairContactId;
	}

	/**
	 * Load by constraint `meetings_fk_modified_by_c` foreign key (`modified_by_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $modified_by_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingsByModifiedByContactId($database, $modified_by_contact_id, Input $options=null)
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
			self::$_arrMeetingsByModifiedByContactId = null;
		}

		$arrMeetingsByModifiedByContactId = self::$_arrMeetingsByModifiedByContactId;
		if (isset($arrMeetingsByModifiedByContactId) && !empty($arrMeetingsByModifiedByContactId)) {
			return $arrMeetingsByModifiedByContactId;
		}

		$modified_by_contact_id = (int) $modified_by_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeeting = new Meeting($database);
			$sqlOrderByColumns = $tmpMeeting->constructSqlOrderByColumns($arrOrderByAttributes);

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
	m.*

FROM `meetings` m
WHERE m.`modified_by_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$arrValues = array($modified_by_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingsByModifiedByContactId = array();
		while ($row = $db->fetch()) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$arrMeetingsByModifiedByContactId[$meeting_id] = $meeting;
		}

		$db->free_result();

		self::$_arrMeetingsByModifiedByContactId = $arrMeetingsByModifiedByContactId;

		return $arrMeetingsByModifiedByContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all meetings records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllMeetings($database, Input $options=null)
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
			self::$_arrAllMeetings = null;
		}

		$arrAllMeetings = self::$_arrAllMeetings;
		if (isset($arrAllMeetings) && !empty($arrAllMeetings)) {
			return $arrAllMeetings;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeeting = new Meeting($database);
			$sqlOrderByColumns = $tmpMeeting->constructSqlOrderByColumns($arrOrderByAttributes);

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
	m.*

FROM `meetings` m{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllMeetings = array();
		while ($row = $db->fetch()) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$arrAllMeetings[$meeting_id] = $meeting;
		}

		$db->free_result();

		self::$_arrAllMeetings = $arrAllMeetings;

		return $arrAllMeetings;
	}

	// Loaders: Load All Records By Project id
	/**
	 * Load all meetings records.
	 *
	 * @param string $database
	 * @param integer $peoject_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllMeetingsByProjectId($database, $project_id, Input $options=null)
	{
		$forceLoadFlag = false;
		$whereCause = "";
		$whereCauseValues = null;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$whereCause = $options->whereCause;
			$whereCauseValues = $options->whereCauseValues;			
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
			self::$_arrAllMeetings = null;
		}

		$arrAllMeetings = self::$_arrAllMeetings;
		if (isset($arrAllMeetings) && !empty($arrAllMeetings)) {
			return $arrAllMeetings;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeeting = new Meeting($database);
			$sqlOrderByColumns = $tmpMeeting->constructSqlOrderByColumns($arrOrderByAttributes);

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
	m.*
FROM `meetings` m
WHERE m.`project_id` = ? AND m.`meeting_sequence_number` <> ''
{$whereCause}
{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$arrValues = array($project_id);
		if(isset($whereCauseValues) && !empty($whereCauseValues)) {
			$arrValues = array_merge($arrValues, $whereCauseValues);
		}
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllMeetings = array();
		while ($row = $db->fetch()) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$arrAllMeetings[$meeting_id] = $meeting;
		}

		$db->free_result();

		self::$_arrAllMeetings = $arrAllMeetings;

		return $arrAllMeetings;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	public static function loadMeetingsByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id, Input $options=null)
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
			self::$_arrMeetingsByModifiedByContactId = null;
		}

		$arrMeetingsByModifiedByContactId = self::$_arrMeetingsByModifiedByContactId;
		if (isset($arrMeetingsByModifiedByContactId) && !empty($arrMeetingsByModifiedByContactId)) {
			return $arrMeetingsByModifiedByContactId;
		}

		$project_id = (int) $project_id;
		$meeting_type_id = (int) $meeting_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `meeting_start_date` DESC, `meeting_start_time` DESC
		// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$sqlOrderBy = 'ORDER BY m.`meeting_sequence_number`+0 DESC';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeeting = new Meeting($database);
			$sqlOrderByColumns = $tmpMeeting->constructSqlOrderByColumns($arrOrderByAttributes);

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

	m_fk_previous_m.`id` AS 'm_fk_previous_m__meeting_id',
	m_fk_previous_m.`previous_meeting_id` AS 'm_fk_previous_m__previous_meeting_id',
	m_fk_previous_m.`project_id` AS 'm_fk_previous_m__project_id',
	m_fk_previous_m.`meeting_type_id` AS 'm_fk_previous_m__meeting_type_id',
	m_fk_previous_m.`meeting_location_id` AS 'm_fk_previous_m__meeting_location_id',
	m_fk_previous_m.`meeting_chair_contact_id` AS 'm_fk_previous_m__meeting_chair_contact_id',
	m_fk_previous_m.`modified_by_contact_id` AS 'm_fk_previous_m__modified_by_contact_id',
	m_fk_previous_m.`meeting_sequence_number` AS 'm_fk_previous_m__meeting_sequence_number',
	m_fk_previous_m.`meeting_start_date` AS 'm_fk_previous_m__meeting_start_date',
	m_fk_previous_m.`meeting_start_time` AS 'm_fk_previous_m__meeting_start_time',
	m_fk_previous_m.`meeting_end_date` AS 'm_fk_previous_m__meeting_end_date',
	m_fk_previous_m.`meeting_end_time` AS 'm_fk_previous_m__meeting_end_time',
	m_fk_previous_m.`modified` AS 'm_fk_previous_m__modified',
	m_fk_previous_m.`created` AS 'm_fk_previous_m__created',
	m_fk_previous_m.`all_day_event_flag` AS 'm_fk_previous_m__all_day_event_flag',

	m_fk_p.`id` AS 'm_fk_p__project_id',
	m_fk_p.`project_type_id` AS 'm_fk_p__project_type_id',
	m_fk_p.`user_company_id` AS 'm_fk_p__user_company_id',
	m_fk_p.`user_custom_project_id` AS 'm_fk_p__user_custom_project_id',
	m_fk_p.`project_name` AS 'm_fk_p__project_name',
	m_fk_p.`project_owner_name` AS 'm_fk_p__project_owner_name',
	m_fk_p.`latitude` AS 'm_fk_p__latitude',
	m_fk_p.`longitude` AS 'm_fk_p__longitude',
	m_fk_p.`address_line_1` AS 'm_fk_p__address_line_1',
	m_fk_p.`address_line_2` AS 'm_fk_p__address_line_2',
	m_fk_p.`address_line_3` AS 'm_fk_p__address_line_3',
	m_fk_p.`address_line_4` AS 'm_fk_p__address_line_4',
	m_fk_p.`address_city` AS 'm_fk_p__address_city',
	m_fk_p.`address_county` AS 'm_fk_p__address_county',
	m_fk_p.`address_state_or_region` AS 'm_fk_p__address_state_or_region',
	m_fk_p.`address_postal_code` AS 'm_fk_p__address_postal_code',
	m_fk_p.`address_postal_code_extension` AS 'm_fk_p__address_postal_code_extension',
	m_fk_p.`address_country` AS 'm_fk_p__address_country',
	m_fk_p.`building_count` AS 'm_fk_p__building_count',
	m_fk_p.`unit_count` AS 'm_fk_p__unit_count',
	m_fk_p.`gross_square_footage` AS 'm_fk_p__gross_square_footage',
	m_fk_p.`net_rentable_square_footage` AS 'm_fk_p__net_rentable_square_footage',
	m_fk_p.`is_active_flag` AS 'm_fk_p__is_active_flag',
	m_fk_p.`public_plans_flag` AS 'm_fk_p__public_plans_flag',
	m_fk_p.`prevailing_wage_flag` AS 'm_fk_p__prevailing_wage_flag',
	m_fk_p.`city_business_license_required_flag` AS 'm_fk_p__city_business_license_required_flag',
	m_fk_p.`is_internal_flag` AS 'm_fk_p__is_internal_flag',
	m_fk_p.`project_contract_date` AS 'm_fk_p__project_contract_date',
	m_fk_p.`project_start_date` AS 'm_fk_p__project_start_date',
	m_fk_p.`project_completed_date` AS 'm_fk_p__project_completed_date',
	m_fk_p.`sort_order` AS 'm_fk_p__sort_order',

	m_fk_mt.`id` AS 'm_fk_mt__meeting_type_id',
	m_fk_mt.`project_id` AS 'm_fk_mt__project_id',
	m_fk_mt.`meeting_type` AS 'm_fk_mt__meeting_type',
	m_fk_mt.`meeting_type_abbreviation` AS 'm_fk_mt__meeting_type_abbreviation',
	m_fk_mt.`show_construction_flag` AS 'm_fk_mt__show_construction_flag',
	m_fk_mt.`show_schedule_flag` AS 'm_fk_mt__show_schedule_flag',
	m_fk_mt.`show_plans_flag` AS 'm_fk_mt__show_plans_flag',
	m_fk_mt.`show_delays_flag` AS 'm_fk_mt__show_delays_flag',
	m_fk_mt.`show_rfis_flag` AS 'm_fk_mt__show_rfis_flag',
	m_fk_mt.`sort_order` AS 'm_fk_mt__sort_order',

	m_fk_ml.`id` AS 'm_fk_ml__meeting_location_id',
	m_fk_ml.`user_company_id` AS 'm_fk_ml__user_company_id',
	m_fk_ml.`meeting_location` AS 'm_fk_ml__meeting_location',
	m_fk_ml.`meeting_location_abbreviation` AS 'm_fk_ml__meeting_location_abbreviation',
	m_fk_ml.`sort_order` AS 'm_fk_ml__sort_order',

	m_fk_chair_c.`id` AS 'm_fk_chair_c__contact_id',
	m_fk_chair_c.`user_company_id` AS 'm_fk_chair_c__user_company_id',
	m_fk_chair_c.`user_id` AS 'm_fk_chair_c__user_id',
	m_fk_chair_c.`contact_company_id` AS 'm_fk_chair_c__contact_company_id',
	m_fk_chair_c.`email` AS 'm_fk_chair_c__email',
	m_fk_chair_c.`name_prefix` AS 'm_fk_chair_c__name_prefix',
	m_fk_chair_c.`first_name` AS 'm_fk_chair_c__first_name',
	m_fk_chair_c.`additional_name` AS 'm_fk_chair_c__additional_name',
	m_fk_chair_c.`middle_name` AS 'm_fk_chair_c__middle_name',
	m_fk_chair_c.`last_name` AS 'm_fk_chair_c__last_name',
	m_fk_chair_c.`name_suffix` AS 'm_fk_chair_c__name_suffix',
	m_fk_chair_c.`title` AS 'm_fk_chair_c__title',
	m_fk_chair_c.`vendor_flag` AS 'm_fk_chair_c__vendor_flag',

	m_fk_modified_by_c.`id` AS 'm_fk_modified_by_c__contact_id',
	m_fk_modified_by_c.`user_company_id` AS 'm_fk_modified_by_c__user_company_id',
	m_fk_modified_by_c.`user_id` AS 'm_fk_modified_by_c__user_id',
	m_fk_modified_by_c.`contact_company_id` AS 'm_fk_modified_by_c__contact_company_id',
	m_fk_modified_by_c.`email` AS 'm_fk_modified_by_c__email',
	m_fk_modified_by_c.`name_prefix` AS 'm_fk_modified_by_c__name_prefix',
	m_fk_modified_by_c.`first_name` AS 'm_fk_modified_by_c__first_name',
	m_fk_modified_by_c.`additional_name` AS 'm_fk_modified_by_c__additional_name',
	m_fk_modified_by_c.`middle_name` AS 'm_fk_modified_by_c__middle_name',
	m_fk_modified_by_c.`last_name` AS 'm_fk_modified_by_c__last_name',
	m_fk_modified_by_c.`name_suffix` AS 'm_fk_modified_by_c__name_suffix',
	m_fk_modified_by_c.`title` AS 'm_fk_modified_by_c__title',
	m_fk_modified_by_c.`vendor_flag` AS 'm_fk_modified_by_c__vendor_flag',

	m.*

FROM `meetings` m
	LEFT OUTER JOIN `meetings` m_fk_previous_m ON m.`previous_meeting_id` = m_fk_previous_m.`id`
	INNER JOIN `projects` m_fk_p ON m.`project_id` = m_fk_p.`id`
	INNER JOIN `meeting_types` m_fk_mt ON m.`meeting_type_id` = m_fk_mt.`id`
	INNER JOIN `meeting_locations` m_fk_ml ON m.`meeting_location_id` = m_fk_ml.`id`
	INNER JOIN `contacts` m_fk_chair_c ON m.`meeting_chair_contact_id` = m_fk_chair_c.`id`
	INNER JOIN `contacts` m_fk_modified_by_c ON m.`modified_by_contact_id` = m_fk_modified_by_c.`id`
WHERE m.`project_id` = ?
AND m.`meeting_type_id` = ?
AND m.`meeting_sequence_number` <> ''{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `previous_meeting_id` ASC, `project_id` ASC, `meeting_type_id` ASC, `meeting_location_id` ASC, `meeting_chair_contact_id` ASC, `modified_by_contact_id` ASC, `meeting_sequence_number` ASC, `meeting_start_date` ASC, `meeting_start_time` ASC, `meeting_end_date` ASC, `meeting_end_time` ASC, `modified` ASC, `created` ASC, `all_day_event_flag` ASC
		$arrValues = array($project_id, $meeting_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingsByProjectIdAndMeetingTypeId = array();
		while ($row = $db->fetch()) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$meeting->convertPropertiesToData();

			if (isset($row['previous_meeting_id'])) {
				$previous_meeting_id = $row['previous_meeting_id'];
				$row['m_fk_previous_m__id'] = $previous_meeting_id;
				$previousMeeting = self::instantiateOrm($database, 'Meeting', $row, null, $previous_meeting_id, 'm_fk_previous_m__');
				/* @var $previousMeeting Meeting */
				$previousMeeting->convertPropertiesToData();
			} else {
				$previousMeeting = false;
			}
			$meeting->setPreviousMeeting($previousMeeting);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['m_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'm_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$meeting->setProject($project);

			if (isset($row['meeting_type_id'])) {
				$meeting_type_id = $row['meeting_type_id'];
				$row['m_fk_mt__id'] = $meeting_type_id;
				$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id, 'm_fk_mt__');
				/* @var $meetingType MeetingType */
				$meetingType->convertPropertiesToData();
			} else {
				$meetingType = false;
			}
			$meeting->setMeetingType($meetingType);

			if (isset($row['meeting_location_id'])) {
				$meeting_location_id = $row['meeting_location_id'];
				$row['m_fk_ml__id'] = $meeting_location_id;
				$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id, 'm_fk_ml__');
				/* @var $meetingLocation MeetingLocation */
				$meetingLocation->convertPropertiesToData();
			} else {
				$meetingLocation = false;
			}
			$meeting->setMeetingLocation($meetingLocation);

			if (isset($row['meeting_chair_contact_id'])) {
				$meeting_chair_contact_id = $row['meeting_chair_contact_id'];
				$row['m_fk_chair_c__id'] = $meeting_chair_contact_id;
				$meetingChairContact = self::instantiateOrm($database, 'Contact', $row, null, $meeting_chair_contact_id, 'm_fk_chair_c__');
				/* @var $meetingChairContact Contact */
				$meetingChairContact->convertPropertiesToData();
			} else {
				$meetingChairContact = false;
			}
			$meeting->setMeetingChairContact($meetingChairContact);

			if (isset($row['modified_by_contact_id'])) {
				$modified_by_contact_id = $row['modified_by_contact_id'];
				$row['m_fk_modified_by_c__id'] = $modified_by_contact_id;
				$modifiedByContact = self::instantiateOrm($database, 'Contact', $row, null, $modified_by_contact_id, 'm_fk_modified_by_c__');
				/* @var $modifiedByContact Contact */
				$modifiedByContact->convertPropertiesToData();
			} else {
				$modifiedByContact = false;
			}
			$meeting->setModifiedByContact($modifiedByContact);

			$arrMeetingsByProjectIdAndMeetingTypeId[$meeting_id] = $meeting;
		}

		$db->free_result();

		return $arrMeetingsByProjectIdAndMeetingTypeId;
	}

	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $meeting_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadMeetingPlusNextMeetingById($database, $meeting_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	m_fk_previous_m.`id` AS 'm_fk_previous_m__meeting_id',
	m_fk_previous_m.`previous_meeting_id` AS 'm_fk_previous_m__previous_meeting_id',
	m_fk_previous_m.`project_id` AS 'm_fk_previous_m__project_id',
	m_fk_previous_m.`meeting_type_id` AS 'm_fk_previous_m__meeting_type_id',
	m_fk_previous_m.`meeting_location_id` AS 'm_fk_previous_m__meeting_location_id',
	m_fk_previous_m.`meeting_chair_contact_id` AS 'm_fk_previous_m__meeting_chair_contact_id',
	m_fk_previous_m.`modified_by_contact_id` AS 'm_fk_previous_m__modified_by_contact_id',
	m_fk_previous_m.`meeting_sequence_number` AS 'm_fk_previous_m__meeting_sequence_number',
	m_fk_previous_m.`meeting_start_date` AS 'm_fk_previous_m__meeting_start_date',
	m_fk_previous_m.`meeting_start_time` AS 'm_fk_previous_m__meeting_start_time',
	m_fk_previous_m.`meeting_end_date` AS 'm_fk_previous_m__meeting_end_date',
	m_fk_previous_m.`meeting_end_time` AS 'm_fk_previous_m__meeting_end_time',
	m_fk_previous_m.`modified` AS 'm_fk_previous_m__modified',
	m_fk_previous_m.`created` AS 'm_fk_previous_m__created',
	m_fk_previous_m.`all_day_event_flag` AS 'm_fk_previous_m__all_day_event_flag',

	next_m_fk_ml.`id` AS 'next_m_fk_ml__meeting_location_id',
	next_m_fk_ml.`user_company_id` AS 'next_m_fk_ml__user_company_id',
	next_m_fk_ml.`meeting_location` AS 'next_m_fk_ml__meeting_location',
	next_m_fk_ml.`meeting_location_abbreviation` AS 'next_m_fk_ml__meeting_location_abbreviation',
	next_m_fk_ml.`sort_order` AS 'next_m_fk_ml__sort_order',

	m_fk_p.`id` AS 'm_fk_p__project_id',
	m_fk_p.`project_type_id` AS 'm_fk_p__project_type_id',
	m_fk_p.`user_company_id` AS 'm_fk_p__user_company_id',
	m_fk_p.`user_custom_project_id` AS 'm_fk_p__user_custom_project_id',
	m_fk_p.`project_name` AS 'm_fk_p__project_name',
	m_fk_p.`project_owner_name` AS 'm_fk_p__project_owner_name',
	m_fk_p.`latitude` AS 'm_fk_p__latitude',
	m_fk_p.`longitude` AS 'm_fk_p__longitude',
	m_fk_p.`address_line_1` AS 'm_fk_p__address_line_1',
	m_fk_p.`address_line_2` AS 'm_fk_p__address_line_2',
	m_fk_p.`address_line_3` AS 'm_fk_p__address_line_3',
	m_fk_p.`address_line_4` AS 'm_fk_p__address_line_4',
	m_fk_p.`address_city` AS 'm_fk_p__address_city',
	m_fk_p.`address_county` AS 'm_fk_p__address_county',
	m_fk_p.`address_state_or_region` AS 'm_fk_p__address_state_or_region',
	m_fk_p.`address_postal_code` AS 'm_fk_p__address_postal_code',
	m_fk_p.`address_postal_code_extension` AS 'm_fk_p__address_postal_code_extension',
	m_fk_p.`address_country` AS 'm_fk_p__address_country',
	m_fk_p.`building_count` AS 'm_fk_p__building_count',
	m_fk_p.`unit_count` AS 'm_fk_p__unit_count',
	m_fk_p.`gross_square_footage` AS 'm_fk_p__gross_square_footage',
	m_fk_p.`is_active_flag` AS 'm_fk_p__is_active_flag',
	m_fk_p.`public_plans_flag` AS 'm_fk_p__public_plans_flag',
	m_fk_p.`prevailing_wage_flag` AS 'm_fk_p__prevailing_wage_flag',
	m_fk_p.`city_business_license_required_flag` AS 'm_fk_p__city_business_license_required_flag',
	m_fk_p.`is_internal_flag` AS 'm_fk_p__is_internal_flag',
	m_fk_p.`project_contract_date` AS 'm_fk_p__project_contract_date',
	m_fk_p.`project_start_date` AS 'm_fk_p__project_start_date',
	m_fk_p.`project_completed_date` AS 'm_fk_p__project_completed_date',
	m_fk_p.`sort_order` AS 'm_fk_p__sort_order',

	m_fk_mt.`id` AS 'm_fk_mt__meeting_type_id',
	m_fk_mt.`project_id` AS 'm_fk_mt__project_id',
	m_fk_mt.`meeting_type` AS 'm_fk_mt__meeting_type',
	m_fk_mt.`meeting_type_abbreviation` AS 'm_fk_mt__meeting_type_abbreviation',
	m_fk_mt.`show_construction_flag` AS 'm_fk_mt__show_construction_flag',
	m_fk_mt.`show_schedule_flag` AS 'm_fk_mt__show_schedule_flag',
	m_fk_mt.`show_plans_flag` AS 'm_fk_mt__show_plans_flag',
	m_fk_mt.`show_delays_flag` AS 'm_fk_mt__show_delays_flag',
	m_fk_mt.`show_rfis_flag` AS 'm_fk_mt__show_rfis_flag',
	m_fk_mt.`sort_order` AS 'm_fk_mt__sort_order',

	m_fk_ml.`id` AS 'm_fk_ml__meeting_location_id',
	m_fk_ml.`user_company_id` AS 'm_fk_ml__user_company_id',
	m_fk_ml.`meeting_location` AS 'm_fk_ml__meeting_location',
	m_fk_ml.`meeting_location_abbreviation` AS 'm_fk_ml__meeting_location_abbreviation',
	m_fk_ml.`sort_order` AS 'm_fk_ml__sort_order',

	m_fk_chair_c.`id` AS 'm_fk_chair_c__contact_id',
	m_fk_chair_c.`user_company_id` AS 'm_fk_chair_c__user_company_id',
	m_fk_chair_c.`user_id` AS 'm_fk_chair_c__user_id',
	m_fk_chair_c.`contact_company_id` AS 'm_fk_chair_c__contact_company_id',
	m_fk_chair_c.`email` AS 'm_fk_chair_c__email',
	m_fk_chair_c.`name_prefix` AS 'm_fk_chair_c__name_prefix',
	m_fk_chair_c.`first_name` AS 'm_fk_chair_c__first_name',
	m_fk_chair_c.`additional_name` AS 'm_fk_chair_c__additional_name',
	m_fk_chair_c.`middle_name` AS 'm_fk_chair_c__middle_name',
	m_fk_chair_c.`last_name` AS 'm_fk_chair_c__last_name',
	m_fk_chair_c.`name_suffix` AS 'm_fk_chair_c__name_suffix',
	m_fk_chair_c.`title` AS 'm_fk_chair_c__title',
	m_fk_chair_c.`vendor_flag` AS 'm_fk_chair_c__vendor_flag',

	m_fk_modified_by_c.`id` AS 'm_fk_modified_by_c__contact_id',
	m_fk_modified_by_c.`user_company_id` AS 'm_fk_modified_by_c__user_company_id',
	m_fk_modified_by_c.`user_id` AS 'm_fk_modified_by_c__user_id',
	m_fk_modified_by_c.`contact_company_id` AS 'm_fk_modified_by_c__contact_company_id',
	m_fk_modified_by_c.`email` AS 'm_fk_modified_by_c__email',
	m_fk_modified_by_c.`name_prefix` AS 'm_fk_modified_by_c__name_prefix',
	m_fk_modified_by_c.`first_name` AS 'm_fk_modified_by_c__first_name',
	m_fk_modified_by_c.`additional_name` AS 'm_fk_modified_by_c__additional_name',
	m_fk_modified_by_c.`middle_name` AS 'm_fk_modified_by_c__middle_name',
	m_fk_modified_by_c.`last_name` AS 'm_fk_modified_by_c__last_name',
	m_fk_modified_by_c.`name_suffix` AS 'm_fk_modified_by_c__name_suffix',
	m_fk_modified_by_c.`title` AS 'm_fk_modified_by_c__title',
	m_fk_modified_by_c.`vendor_flag` AS 'm_fk_modified_by_c__vendor_flag',

	m.*

FROM `meetings` m
	LEFT OUTER JOIN `meetings` m_fk_previous_m ON m_fk_previous_m.`previous_meeting_id` = m.`id`
	LEFT OUTER JOIN `meeting_locations` next_m_fk_ml ON m_fk_previous_m.`meeting_location_id` = next_m_fk_ml.`id`
	INNER JOIN `projects` m_fk_p ON m.`project_id` = m_fk_p.`id`
	INNER JOIN `meeting_types` m_fk_mt ON m.`meeting_type_id` = m_fk_mt.`id`
	INNER JOIN `meeting_locations` m_fk_ml ON m.`meeting_location_id` = m_fk_ml.`id`
	INNER JOIN `contacts` m_fk_chair_c ON m.`meeting_chair_contact_id` = m_fk_chair_c.`id`
	INNER JOIN `contacts` m_fk_modified_by_c ON m.`modified_by_contact_id` = m_fk_modified_by_c.`id`
WHERE m.`id` = ?
";
#LEFT OUTER JOIN `meetings` m_fk_previous_m ON m.`previous_meeting_id` = m_fk_previous_m.`id`
#WHERE m.`previous_meeting_id` = ?
		$arrValues = array($meeting_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$meeting->convertPropertiesToData();

			if (isset($row['m_fk_previous_m__meeting_id'])) {
				$next_meeting_id = $row['m_fk_previous_m__meeting_id'];
				$row['m_fk_previous_m__id'] = $next_meeting_id;
				$nextMeeting = self::instantiateOrm($database, 'Meeting', $row, null, $next_meeting_id, 'm_fk_previous_m__');
				/* @var $nextMeeting Meeting */
				$nextMeeting->convertPropertiesToData();

				if (isset($row['next_m_fk_ml__meeting_location_id'])) {
					$next_meeting_location_id = $row['next_m_fk_ml__meeting_location_id'];
					$row['next_m_fk_ml__id'] = $next_meeting_location_id;
					$nextMeetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $next_meeting_location_id, 'next_m_fk_ml__');
					/* @var $nextMeetingLocation MeetingLocation */
					$nextMeetingLocation->convertPropertiesToData();
				} else {
					$nextMeetingLocation = false;
				}

				$nextMeeting->setMeetingLocation($nextMeetingLocation);
			} else {
				$nextMeeting = false;
			}
			$meeting->setNextMeeting($nextMeeting);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['m_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'm_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$meeting->setProject($project);

			if (isset($row['meeting_type_id'])) {
				$meeting_type_id = $row['meeting_type_id'];
				$row['m_fk_mt__id'] = $meeting_type_id;
				$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id, 'm_fk_mt__');
				/* @var $meetingType MeetingType */
				$meetingType->convertPropertiesToData();
			} else {
				$meetingType = false;
			}
			$meeting->setMeetingType($meetingType);

			if (isset($row['meeting_location_id'])) {
				$meeting_location_id = $row['meeting_location_id'];
				$row['m_fk_ml__id'] = $meeting_location_id;
				$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id, 'm_fk_ml__');
				/* @var $meetingLocation MeetingLocation */
				$meetingLocation->convertPropertiesToData();
			} else {
				$meetingLocation = false;
			}
			$meeting->setMeetingLocation($meetingLocation);

			if (isset($row['meeting_chair_contact_id'])) {
				$meeting_chair_contact_id = $row['meeting_chair_contact_id'];
				$row['m_fk_chair_c__id'] = $meeting_chair_contact_id;
				$meetingChairContact = self::instantiateOrm($database, 'Contact', $row, null, $meeting_chair_contact_id, 'm_fk_chair_c__');
				/* @var $meetingChairContact Contact */
				$meetingChairContact->convertPropertiesToData();
			} else {
				$meetingChairContact = false;
			}
			$meeting->setMeetingChairContact($meetingChairContact);

			if (isset($row['modified_by_contact_id'])) {
				$modified_by_contact_id = $row['modified_by_contact_id'];
				$row['m_fk_modified_by_c__id'] = $modified_by_contact_id;
				$modifiedByContact = self::instantiateOrm($database, 'Contact', $row, null, $modified_by_contact_id, 'm_fk_modified_by_c__');
				/* @var $modifiedByContact Contact */
				$modifiedByContact->convertPropertiesToData();
			} else {
				$modifiedByContact = false;
			}
			$meeting->setModifiedByContact($modifiedByContact);

			return $meeting;
		} else {
			return false;
		}
	}

	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $meeting_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadHiddenNextMeetingByMeetingTypeId($database, $meeting_type_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	m_fk_previous_m.`id` AS 'm_fk_previous_m__meeting_id',
	m_fk_previous_m.`previous_meeting_id` AS 'm_fk_previous_m__previous_meeting_id',
	m_fk_previous_m.`project_id` AS 'm_fk_previous_m__project_id',
	m_fk_previous_m.`meeting_type_id` AS 'm_fk_previous_m__meeting_type_id',
	m_fk_previous_m.`meeting_location_id` AS 'm_fk_previous_m__meeting_location_id',
	m_fk_previous_m.`meeting_chair_contact_id` AS 'm_fk_previous_m__meeting_chair_contact_id',
	m_fk_previous_m.`modified_by_contact_id` AS 'm_fk_previous_m__modified_by_contact_id',
	m_fk_previous_m.`meeting_sequence_number` AS 'm_fk_previous_m__meeting_sequence_number',
	m_fk_previous_m.`meeting_start_date` AS 'm_fk_previous_m__meeting_start_date',
	m_fk_previous_m.`meeting_start_time` AS 'm_fk_previous_m__meeting_start_time',
	m_fk_previous_m.`meeting_end_date` AS 'm_fk_previous_m__meeting_end_date',
	m_fk_previous_m.`meeting_end_time` AS 'm_fk_previous_m__meeting_end_time',
	m_fk_previous_m.`modified` AS 'm_fk_previous_m__modified',
	m_fk_previous_m.`created` AS 'm_fk_previous_m__created',
	m_fk_previous_m.`all_day_event_flag` AS 'm_fk_previous_m__all_day_event_flag',

	previous_m_fk_ml.`id` AS 'previous_m_fk_ml__meeting_location_id',
	previous_m_fk_ml.`user_company_id` AS 'previous_m_fk_ml__user_company_id',
	previous_m_fk_ml.`meeting_location` AS 'previous_m_fk_ml__meeting_location',
	previous_m_fk_ml.`meeting_location_abbreviation` AS 'previous_m_fk_ml__meeting_location_abbreviation',
	previous_m_fk_ml.`sort_order` AS 'previous_m_fk_ml__sort_order',

	m_fk_p.`id` AS 'm_fk_p__project_id',
	m_fk_p.`project_type_id` AS 'm_fk_p__project_type_id',
	m_fk_p.`user_company_id` AS 'm_fk_p__user_company_id',
	m_fk_p.`user_custom_project_id` AS 'm_fk_p__user_custom_project_id',
	m_fk_p.`project_name` AS 'm_fk_p__project_name',
	m_fk_p.`project_owner_name` AS 'm_fk_p__project_owner_name',
	m_fk_p.`latitude` AS 'm_fk_p__latitude',
	m_fk_p.`longitude` AS 'm_fk_p__longitude',
	m_fk_p.`address_line_1` AS 'm_fk_p__address_line_1',
	m_fk_p.`address_line_2` AS 'm_fk_p__address_line_2',
	m_fk_p.`address_line_3` AS 'm_fk_p__address_line_3',
	m_fk_p.`address_line_4` AS 'm_fk_p__address_line_4',
	m_fk_p.`address_city` AS 'm_fk_p__address_city',
	m_fk_p.`address_county` AS 'm_fk_p__address_county',
	m_fk_p.`address_state_or_region` AS 'm_fk_p__address_state_or_region',
	m_fk_p.`address_postal_code` AS 'm_fk_p__address_postal_code',
	m_fk_p.`address_postal_code_extension` AS 'm_fk_p__address_postal_code_extension',
	m_fk_p.`address_country` AS 'm_fk_p__address_country',
	m_fk_p.`building_count` AS 'm_fk_p__building_count',
	m_fk_p.`unit_count` AS 'm_fk_p__unit_count',
	m_fk_p.`gross_square_footage` AS 'm_fk_p__gross_square_footage',
	m_fk_p.`is_active_flag` AS 'm_fk_p__is_active_flag',
	m_fk_p.`public_plans_flag` AS 'm_fk_p__public_plans_flag',
	m_fk_p.`prevailing_wage_flag` AS 'm_fk_p__prevailing_wage_flag',
	m_fk_p.`city_business_license_required_flag` AS 'm_fk_p__city_business_license_required_flag',
	m_fk_p.`is_internal_flag` AS 'm_fk_p__is_internal_flag',
	m_fk_p.`project_contract_date` AS 'm_fk_p__project_contract_date',
	m_fk_p.`project_start_date` AS 'm_fk_p__project_start_date',
	m_fk_p.`project_completed_date` AS 'm_fk_p__project_completed_date',
	m_fk_p.`sort_order` AS 'm_fk_p__sort_order',

	m_fk_mt.`id` AS 'm_fk_mt__meeting_type_id',
	m_fk_mt.`project_id` AS 'm_fk_mt__project_id',
	m_fk_mt.`meeting_type` AS 'm_fk_mt__meeting_type',
	m_fk_mt.`meeting_type_abbreviation` AS 'm_fk_mt__meeting_type_abbreviation',
	m_fk_mt.`show_construction_flag` AS 'm_fk_mt__show_construction_flag',
	m_fk_mt.`show_schedule_flag` AS 'm_fk_mt__show_schedule_flag',
	m_fk_mt.`show_plans_flag` AS 'm_fk_mt__show_plans_flag',
	m_fk_mt.`show_delays_flag` AS 'm_fk_mt__show_delays_flag',
	m_fk_mt.`show_rfis_flag` AS 'm_fk_mt__show_rfis_flag',
	m_fk_mt.`sort_order` AS 'm_fk_mt__sort_order',

	m_fk_ml.`id` AS 'm_fk_ml__meeting_location_id',
	m_fk_ml.`user_company_id` AS 'm_fk_ml__user_company_id',
	m_fk_ml.`meeting_location` AS 'm_fk_ml__meeting_location',
	m_fk_ml.`meeting_location_abbreviation` AS 'm_fk_ml__meeting_location_abbreviation',
	m_fk_ml.`sort_order` AS 'm_fk_ml__sort_order',

	m_fk_chair_c.`id` AS 'm_fk_chair_c__contact_id',
	m_fk_chair_c.`user_company_id` AS 'm_fk_chair_c__user_company_id',
	m_fk_chair_c.`user_id` AS 'm_fk_chair_c__user_id',
	m_fk_chair_c.`contact_company_id` AS 'm_fk_chair_c__contact_company_id',
	m_fk_chair_c.`email` AS 'm_fk_chair_c__email',
	m_fk_chair_c.`name_prefix` AS 'm_fk_chair_c__name_prefix',
	m_fk_chair_c.`first_name` AS 'm_fk_chair_c__first_name',
	m_fk_chair_c.`additional_name` AS 'm_fk_chair_c__additional_name',
	m_fk_chair_c.`middle_name` AS 'm_fk_chair_c__middle_name',
	m_fk_chair_c.`last_name` AS 'm_fk_chair_c__last_name',
	m_fk_chair_c.`name_suffix` AS 'm_fk_chair_c__name_suffix',
	m_fk_chair_c.`title` AS 'm_fk_chair_c__title',
	m_fk_chair_c.`vendor_flag` AS 'm_fk_chair_c__vendor_flag',

	m_fk_modified_by_c.`id` AS 'm_fk_modified_by_c__contact_id',
	m_fk_modified_by_c.`user_company_id` AS 'm_fk_modified_by_c__user_company_id',
	m_fk_modified_by_c.`user_id` AS 'm_fk_modified_by_c__user_id',
	m_fk_modified_by_c.`contact_company_id` AS 'm_fk_modified_by_c__contact_company_id',
	m_fk_modified_by_c.`email` AS 'm_fk_modified_by_c__email',
	m_fk_modified_by_c.`name_prefix` AS 'm_fk_modified_by_c__name_prefix',
	m_fk_modified_by_c.`first_name` AS 'm_fk_modified_by_c__first_name',
	m_fk_modified_by_c.`additional_name` AS 'm_fk_modified_by_c__additional_name',
	m_fk_modified_by_c.`middle_name` AS 'm_fk_modified_by_c__middle_name',
	m_fk_modified_by_c.`last_name` AS 'm_fk_modified_by_c__last_name',
	m_fk_modified_by_c.`name_suffix` AS 'm_fk_modified_by_c__name_suffix',
	m_fk_modified_by_c.`title` AS 'm_fk_modified_by_c__title',
	m_fk_modified_by_c.`vendor_flag` AS 'm_fk_modified_by_c__vendor_flag',

	m.*

FROM `meetings` m
	LEFT OUTER JOIN `meetings` m_fk_previous_m ON m.`previous_meeting_id` = m_fk_previous_m.`id`
	LEFT OUTER JOIN `meeting_locations` previous_m_fk_ml ON m_fk_previous_m.`meeting_location_id` = previous_m_fk_ml.`id`
	INNER JOIN `projects` m_fk_p ON m.`project_id` = m_fk_p.`id`
	INNER JOIN `meeting_types` m_fk_mt ON m.`meeting_type_id` = m_fk_mt.`id`
	INNER JOIN `meeting_locations` m_fk_ml ON m.`meeting_location_id` = m_fk_ml.`id`
	INNER JOIN `contacts` m_fk_chair_c ON m.`meeting_chair_contact_id` = m_fk_chair_c.`id`
	INNER JOIN `contacts` m_fk_modified_by_c ON m.`modified_by_contact_id` = m_fk_modified_by_c.`id`
WHERE m_fk_mt.`id` = ?
AND m.`meeting_sequence_number` = ''
";
		$arrValues = array($meeting_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			$meeting->convertPropertiesToData();

			if (isset($row['previous_meeting_id'])) {
				$previous_meeting_id = $row['previous_meeting_id'];
				$row['m_fk_previous_m__id'] = $previous_meeting_id;
				$previousMeeting = self::instantiateOrm($database, 'Meeting', $row, null, $previous_meeting_id, 'm_fk_previous_m__');
				/* @var $previousMeeting Meeting */
				$previousMeeting->convertPropertiesToData();

				if (isset($row['previous_m_fk_ml__meeting_location_id'])) {
					$previous_meeting_location_id = $row['previous_m_fk_ml__meeting_location_id'];
					$row['next_m_fk_ml__id'] = $previous_meeting_location_id;
					$previousMeetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $previous_meeting_location_id, 'previous_m_fk_ml__');
					/* @var $previousMeetingLocation MeetingLocation */
					$previousMeetingLocation->convertPropertiesToData();
				} else {
					$previousMeetingLocation = false;
				}

				$previousMeeting->setMeetingLocation($previousMeetingLocation);
			} else {
				$previousMeeting = false;
			}
			$meeting->setPreviousMeeting($previousMeeting);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['m_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'm_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$meeting->setProject($project);

			if (isset($row['meeting_type_id'])) {
				$meeting_type_id = $row['meeting_type_id'];
				$row['m_fk_mt__id'] = $meeting_type_id;
				$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id, 'm_fk_mt__');
				/* @var $meetingType MeetingType */
				$meetingType->convertPropertiesToData();
			} else {
				$meetingType = false;
			}
			$meeting->setMeetingType($meetingType);

			if (isset($row['meeting_location_id'])) {
				$meeting_location_id = $row['meeting_location_id'];
				$row['m_fk_ml__id'] = $meeting_location_id;
				$meetingLocation = self::instantiateOrm($database, 'MeetingLocation', $row, null, $meeting_location_id, 'm_fk_ml__');
				/* @var $meetingLocation MeetingLocation */
				$meetingLocation->convertPropertiesToData();
			} else {
				$meetingLocation = false;
			}
			$meeting->setMeetingLocation($meetingLocation);

			if (isset($row['meeting_chair_contact_id'])) {
				$meeting_chair_contact_id = $row['meeting_chair_contact_id'];
				$row['m_fk_chair_c__id'] = $meeting_chair_contact_id;
				$meetingChairContact = self::instantiateOrm($database, 'Contact', $row, null, $meeting_chair_contact_id, 'm_fk_chair_c__');
				/* @var $meetingChairContact Contact */
				$meetingChairContact->convertPropertiesToData();
			} else {
				$meetingChairContact = false;
			}
			$meeting->setMeetingChairContact($meetingChairContact);

			if (isset($row['modified_by_contact_id'])) {
				$modified_by_contact_id = $row['modified_by_contact_id'];
				$row['m_fk_modified_by_c__id'] = $modified_by_contact_id;
				$modifiedByContact = self::instantiateOrm($database, 'Contact', $row, null, $modified_by_contact_id, 'm_fk_modified_by_c__');
				/* @var $modifiedByContact Contact */
				$modifiedByContact->convertPropertiesToData();
			} else {
				$modifiedByContact = false;
			}
			$meeting->setModifiedByContact($modifiedByContact);

			return $meeting;
		} else {
			return false;
		}
	}

	/**
	 * Find next_subcontract_sequence_number value.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextMeetingSequenceNumberByMeetingTypeId($database, $meeting_type_id)
	{
		$next_meeting_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(CAST(m.`meeting_sequence_number` AS UNSIGNED)) AS 'max_meeting_sequence_number'
FROM `meetings` m
WHERE m.`meeting_type_id` = ?
";
		$arrValues = array($meeting_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_meeting_sequence_number = (int) $row['max_meeting_sequence_number'];
			$next_meeting_sequence_number = $max_meeting_sequence_number + 1;
		}

		return $next_meeting_sequence_number;
	}

	/**
	 * Find previous meeting id value.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findPreviousMeetingIdByMeetingTypeIdAndProjectId($database, $meeting_type_id, $project_id)
	{
		$previous_meeting_id = null;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT m.`id` 
FROM `meetings` m
WHERE m.`meeting_type_id` = ?
AND m.`project_id` = ?
AND m.`meeting_sequence_number` = ''
ORDER BY m.`id` DESC
";
		$arrValues = array($meeting_type_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$previous_meeting_id = (int) $row['id'];
		}

		return $previous_meeting_id;
	}

	/**
	 * Get The Meeting notify flag using meeting id
	 *
	 * @param string $database
	 * @param int $meeting_id, $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNotifyFlagUsingMeetingIdApi($database, $meeting_id, $contact_id)
	{
		$next_meeting_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT aia.*,ai.id as act_id, ai.action_item_due_date FROM action_item_assignments as aia 
LEFT JOIN discussion_items_to_action_items AS ditai ON ditai.`action_item_id` = aia.`action_item_id`
LEFT JOIN discussion_items AS di ON di.`id` = ditai.`discussion_item_id`
LEFT JOIN `action_items` as ai ON ai.id = aia.action_item_id
WHERE di.`meeting_id` = ? AND aia.`action_item_assignee_contact_id` = ? ";
		$arrValues = array($meeting_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$RN_red_notify_flag = false;
		$RN_notify_flag = false;
		while($row = $db->fetch()){
			// $RN_red_notify_flag = false;
			// $RN_notify_flag = false;
			$RN_action_item_due_date = $row['action_item_due_date'];
			// due date red alert
			if ($RN_action_item_due_date == '') {
				$RN_dueDateUneditable = 'N/A';
			} else {
				$RN_dueDateUneditable = date('M j, Y', strtotime($RN_action_item_due_date));
				$current_date = date('M j, Y');
				if(strtotime($RN_dueDateUneditable) == strtotime($current_date)){
					$RN_red_notify_flag = true;
				}
			}
			// assign shown flag
			$RN_notify_flag_raw = $row['notify_flag'];
			if($RN_notify_flag_raw == 'Y'){
				$RN_notify_flag = true;
			}
		}
		$RN_arrayTmp = array();
		$RN_arrayTmp['red_notify'] = $RN_red_notify_flag;
		$RN_arrayTmp['notify'] = $RN_notify_flag;
		$db->free_result();
		return $RN_arrayTmp;
	}

	/**
	 * Get The Meeting notify flag using meeting id
	 *
	 * @param string $database
	 * @param int $meeting_id, $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNotifyFlagUsingMeetingTypeIdApi($database, $meeting_type_id, $contact_id)
	{
		$next_meeting_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT aia.*,ai.id as act_id, ai.action_item_due_date FROM action_item_assignments as aia 
LEFT JOIN discussion_items_to_action_items AS ditai ON ditai.`action_item_id` = aia.`action_item_id`
LEFT JOIN discussion_items AS di ON di.`id` = ditai.`discussion_item_id`
LEFT JOIN meetings AS m ON m.`id` = di.`meeting_id`
LEFT JOIN `action_items` as ai ON ai.id = aia.action_item_id
WHERE m.`meeting_type_id` = ? AND aia.`action_item_assignee_contact_id` = ?";
		$arrValues = array($meeting_type_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$RN_red_notify_flag = false;
		$RN_notify_flag = false;
		while($row = $db->fetch()){
			// $RN_red_notify_flag = false;
			// $RN_notify_flag = false;
			$RN_action_item_due_date = $row['action_item_due_date'];
			// due date red alert
			if ($RN_action_item_due_date == '') {
				$RN_dueDateUneditable = 'N/A';
			} else {
				$RN_dueDateUneditable = date('M j, Y', strtotime($RN_action_item_due_date));
				$current_date = date('M j, Y');
				if(strtotime($RN_dueDateUneditable) == strtotime($current_date)){
					$RN_red_notify_flag = true;
				}
			}
			// assign shown flag
			$RN_notify_flag_raw = $row['notify_flag'];
			if($RN_notify_flag_raw == 'Y'){
				$RN_notify_flag = true;
			}
		}
		$RN_arrayTmp = array();
		$RN_arrayTmp['red_notify'] = $RN_red_notify_flag;
		$RN_arrayTmp['notify'] = $RN_notify_flag;
		$db->free_result();
		return $RN_arrayTmp;
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_meeting` (`project_id`,`meeting_location_id`,`meeting_start_date`,`meeting_start_time`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $meeting_location_id
	 * @param string $meeting_start_date
	 * @param string $meeting_start_time
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextMeetingByProjectIdAndMeetingId($database, $project_id, $meeting_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	m.*

FROM `meetings` m
WHERE m.`project_id` = ?
AND m.`previous_meeting_id` = ?
";
		$arrValues = array($project_id, $meeting_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$meeting_id = $row['id'];
			$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id);
			/* @var $meeting Meeting */
			return $meeting;
		} else {
			return false;
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
