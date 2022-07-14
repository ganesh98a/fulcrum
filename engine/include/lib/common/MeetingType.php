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
 * MeetingType.
 *
 * @category   Framework
 * @package    MeetingType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class MeetingType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'MeetingType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'meeting_types';

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
	 * unique index `unique_meeting_type` (`project_id`,`meeting_type`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_meeting_type' => array(
			'project_id' => 'int',
			'meeting_type' => 'string'
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
		'id' => 'meeting_type_id',

		'project_id' => 'project_id',

		'meeting_type' => 'meeting_type',

		'meeting_type_abbreviation' => 'meeting_type_abbreviation',
		'show_construction_flag' => 'show_construction_flag',
		'show_schedule_flag' => 'show_schedule_flag',
		'show_plans_flag' => 'show_plans_flag',
		'show_delays_flag' => 'show_delays_flag',
		'show_rfis_flag' => 'show_rfis_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $meeting_type_id;

	public $project_id;

	public $meeting_type;

	public $meeting_type_abbreviation;
	public $show_construction_flag;
	public $show_schedule_flag;
	public $show_plans_flag;
	public $show_delays_flag;
	public $show_rfis_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_meeting_type;
	public $escaped_meeting_type_abbreviation;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_meeting_type_nl2br;
	public $escaped_meeting_type_abbreviation_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrMeetingTypesByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllMeetingTypes;

	// Foreign Key Objects
	private $_project;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='meeting_types')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getProject()
	{
		if (isset($this->_project)) {
			return $this->_project;
		} else {
			return null;
		}
	}

	public function setProject($project)
	{
		$this->_project = $project;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrMeetingTypesByProjectId()
	{
		if (isset(self::$_arrMeetingTypesByProjectId)) {
			return self::$_arrMeetingTypesByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrMeetingTypesByProjectId($arrMeetingTypesByProjectId)
	{
		self::$_arrMeetingTypesByProjectId = $arrMeetingTypesByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllMeetingTypes()
	{
		if (isset(self::$_arrAllMeetingTypes)) {
			return self::$_arrAllMeetingTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllMeetingTypes($arrAllMeetingTypes)
	{
		self::$_arrAllMeetingTypes = $arrAllMeetingTypes;
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
	 * @param int $meeting_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $meeting_type_id,$table='meeting_types', $module='MeetingType')
	{
		$meetingType = parent::findById($database, $meeting_type_id,$table, $module);

		return $meetingType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $meeting_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findMeetingTypeByIdExtended($database, $meeting_type_id)
	{
		$meeting_type_id = (int) $meeting_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	mt_fk_p.`id` AS 'mt_fk_p__project_id',
	mt_fk_p.`project_type_id` AS 'mt_fk_p__project_type_id',
	mt_fk_p.`user_company_id` AS 'mt_fk_p__user_company_id',
	mt_fk_p.`user_custom_project_id` AS 'mt_fk_p__user_custom_project_id',
	mt_fk_p.`project_name` AS 'mt_fk_p__project_name',
	mt_fk_p.`project_owner_name` AS 'mt_fk_p__project_owner_name',
	mt_fk_p.`latitude` AS 'mt_fk_p__latitude',
	mt_fk_p.`longitude` AS 'mt_fk_p__longitude',
	mt_fk_p.`address_line_1` AS 'mt_fk_p__address_line_1',
	mt_fk_p.`address_line_2` AS 'mt_fk_p__address_line_2',
	mt_fk_p.`address_line_3` AS 'mt_fk_p__address_line_3',
	mt_fk_p.`address_line_4` AS 'mt_fk_p__address_line_4',
	mt_fk_p.`address_city` AS 'mt_fk_p__address_city',
	mt_fk_p.`address_county` AS 'mt_fk_p__address_county',
	mt_fk_p.`address_state_or_region` AS 'mt_fk_p__address_state_or_region',
	mt_fk_p.`address_postal_code` AS 'mt_fk_p__address_postal_code',
	mt_fk_p.`address_postal_code_extension` AS 'mt_fk_p__address_postal_code_extension',
	mt_fk_p.`address_country` AS 'mt_fk_p__address_country',
	mt_fk_p.`building_count` AS 'mt_fk_p__building_count',
	mt_fk_p.`unit_count` AS 'mt_fk_p__unit_count',
	mt_fk_p.`gross_square_footage` AS 'mt_fk_p__gross_square_footage',
	mt_fk_p.`net_rentable_square_footage` AS 'mt_fk_p__net_rentable_square_footage',
	mt_fk_p.`is_active_flag` AS 'mt_fk_p__is_active_flag',
	mt_fk_p.`public_plans_flag` AS 'mt_fk_p__public_plans_flag',
	mt_fk_p.`prevailing_wage_flag` AS 'mt_fk_p__prevailing_wage_flag',
	mt_fk_p.`city_business_license_required_flag` AS 'mt_fk_p__city_business_license_required_flag',
	mt_fk_p.`is_internal_flag` AS 'mt_fk_p__is_internal_flag',
	mt_fk_p.`project_contract_date` AS 'mt_fk_p__project_contract_date',
	mt_fk_p.`project_start_date` AS 'mt_fk_p__project_start_date',
	mt_fk_p.`project_completed_date` AS 'mt_fk_p__project_completed_date',
	mt_fk_p.`sort_order` AS 'mt_fk_p__sort_order',

	mt.*

FROM `meeting_types` mt
	INNER JOIN `projects` mt_fk_p ON mt.`project_id` = mt_fk_p.`id`
WHERE mt.`id` = ?
";
		$arrValues = array($meeting_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$meeting_type_id = $row['id'];
			$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id);
			/* @var $meetingType MeetingType */
			$meetingType->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['mt_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'mt_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$meetingType->setProject($project);

			return $meetingType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_meeting_type` (`project_id`,`meeting_type`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param string $meeting_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndMeetingType($database, $project_id, $meeting_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	mt.*

FROM `meeting_types` mt
WHERE mt.`project_id` = ?
AND mt.`meeting_type` = ?
";
		$arrValues = array($project_id, $meeting_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$meeting_type_id = $row['id'];
			$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id);
			/* @var $meetingType MeetingType */
			return $meetingType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrMeetingTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingTypesByArrMeetingTypeIds($database, $arrMeetingTypeIds, Input $options=null)
	{
		if (empty($arrMeetingTypeIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `meeting_type` ASC, `meeting_type_abbreviation` ASC, `show_construction_flag` ASC, `show_schedule_flag` ASC, `show_plans_flag` ASC, `show_delays_flag` ASC, `show_rfis_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY mt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingType = new MeetingType($database);
			$sqlOrderByColumns = $tmpMeetingType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrMeetingTypeIds as $k => $meeting_type_id) {
			$meeting_type_id = (int) $meeting_type_id;
			$arrMeetingTypeIds[$k] = $db->escape($meeting_type_id);
		}
		$csvMeetingTypeIds = join(',', $arrMeetingTypeIds);

		$query =
"
SELECT

	mt.*

FROM `meeting_types` mt
WHERE mt.`id` IN ($csvMeetingTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrMeetingTypesByCsvMeetingTypeIds = array();
		while ($row = $db->fetch()) {
			$meeting_type_id = $row['id'];
			$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id);
			/* @var $meetingType MeetingType */
			$meetingType->convertPropertiesToData();

			$arrMeetingTypesByCsvMeetingTypeIds[$meeting_type_id] = $meetingType;
		}

		$db->free_result();

		return $arrMeetingTypesByCsvMeetingTypeIds;
	}
		// To get the software module function id against meeting type 
	public static  function GetSoftwareModuleIdForMeeting($database,$meeting_type_id)
	 {
	 	
		$db = DBI::getInstance($database);
		$query ="SELECT `meeting_type` FROM `meeting_types` WHERE `id` = ? ";
		$arrValues = array($meeting_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$meeting_type =$row['meeting_type'];
		$db->free_result();

		$query1 ="SELECT * FROM `software_module_functions` WHERE `software_module_function_label` LIKE '%".$meeting_type."%'";
		$db->execute($query1);
		$row = $db->fetch();
		if($row)
		{
			$sm_id = $row['id'];
		}else
		{
			$sm_id =0;
		}
		$db->free_result();
		return $sm_id;
	 }

	// To fetch the meeting against a project
	public static  function LoadMeetingType($database,$project_id)
	 {
	 	
		$db = DBI::getInstance($database);
		$query ="SELECT mt.* FROM `meeting_types` mt WHERE mt.`project_id` = ? order by mt.id";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$meetingarr = array();
		while($row = $db->fetch())
		{
			$m_id = $row['id'];
			$meetingarr[$m_id] = $row;
		}
		$db->free_result();
		return $meetingarr;
	 }

	public static function loadMeetingTypesBasedOnPermission($database,$project_id,$userCanViewMeetingsType1="",$userCanViewMeetingsType2="",$userCanViewMeetingsType3="",$userCanViewMeetingsType4=""){
				
		$db = DBI::getInstance($database);
		$query ="SELECT mt.* FROM `meeting_types` mt WHERE mt.`project_id` = ?";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingTypesByProjectId = array();
		while ($row = $db->fetch()) {
			$meeting_type_id = $row['id'];
			$meeting_type = $row['meeting_type'];

			$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id);
			//Based on user access restricting the meeting type 
			if($userCanViewMeetingsType1 && $meeting_type == 'Owner Meeting')
			{
				$arrMeetingTypesByProjectId[$meeting_type_id] = $meetingType;
			}
			else if($userCanViewMeetingsType2 && $meeting_type == 'LEED Meeting')
			{
				$arrMeetingTypesByProjectId[$meeting_type_id] = $meetingType;
			}
			else if($userCanViewMeetingsType3 && $meeting_type == 'Weekly Subcontractor Meeting')
			{
				$arrMeetingTypesByProjectId[$meeting_type_id] = $meetingType;
			}
			else if($userCanViewMeetingsType4 && $meeting_type == 'Internal Meeting')
			{
				$arrMeetingTypesByProjectId[$meeting_type_id] = $meetingType;
			}
			else if($meeting_type != 'Owner Meeting' && $meeting_type != 'LEED Meeting' && $meeting_type != 'Weekly Subcontractor Meeting' && $meeting_type != 'Internal Meeting')
			{
				$permissionforMeeting = self::loadAccessForMeetingAgainstRole($database,$project_id,$meeting_type_id);
				if($permissionforMeeting){
				$arrMeetingTypesByProjectId[$meeting_type_id] = $meetingType;
			}
			}
		}

		$db->free_result();

		self::$_arrMeetingTypesByProjectId = $arrMeetingTypesByProjectId;

		return $arrMeetingTypesByProjectId;

	 }
	 public static function loadAccessForMeetingAgainstRole($database,$project_id,$meeting_type_id)
	 {
	 		$db = DBI::getInstance($database);
	 		// For project specific roles
			$query ="SELECT pcr.* FROM `projects_to_contacts_to_roles` pcr 
				inner join `meeting_access_to_contact` ma on ma.project_id = pcr.project_id and ma.role_id = pcr.role_id
			WHERE pcr.`project_id` = ? and ma.meeting_type_id = ?";
			$arrValues = array($project_id,$meeting_type_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$row = $db->fetch();
			if(!empty($row))
			{
				$pspecret =true;
			}else
			{
				$pspecret =false;
			}
			$db->free_result();

			// For project specific roles
			
			$query ="SELECT cr.* FROM `contacts_to_roles` cr 
				inner join `meeting_access_to_contact` ma on  ma.role_id = cr.role_id
			WHERE ma.meeting_type_id = ?";
			$arrValues = array($meeting_type_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$row = $db->fetch();
			if(!empty($row))
			{
				$npspecret =true;
			}else
			{
				$npspecret =false;
			}

			if($npspecret== true && $pspecret==true)
		{
			return true;
		}else if ($npspecret== false && $pspecret==true)
		{
			return true;
		}else if ($npspecret== true && $pspecret==false)
		{
			return true;
		}else{
			return false;
		}
	 }

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `meeting_types_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingTypesByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrMeetingTypesByProjectId = null;
		}

		$arrMeetingTypesByProjectId = self::$_arrMeetingTypesByProjectId;
		if (isset($arrMeetingTypesByProjectId) && !empty($arrMeetingTypesByProjectId)) {
			return $arrMeetingTypesByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `meeting_type` ASC, `meeting_type_abbreviation` ASC, `show_construction_flag` ASC, `show_schedule_flag` ASC, `show_plans_flag` ASC, `show_delays_flag` ASC, `show_rfis_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY mt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingType = new MeetingType($database);
			$sqlOrderByColumns = $tmpMeetingType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	mt.*

FROM `meeting_types` mt
WHERE mt.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `meeting_type` ASC, `meeting_type_abbreviation` ASC, `show_construction_flag` ASC, `show_schedule_flag` ASC, `show_plans_flag` ASC, `show_delays_flag` ASC, `show_rfis_flag` ASC, `sort_order` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingTypesByProjectId = array();
		while ($row = $db->fetch()) {
			$meeting_type_id = $row['id'];
			$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id);
			/* @var $meetingType MeetingType */
			$arrMeetingTypesByProjectId[$meeting_type_id] = $meetingType;
		}

		$db->free_result();

		self::$_arrMeetingTypesByProjectId = $arrMeetingTypesByProjectId;

		return $arrMeetingTypesByProjectId;
	}
	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `meeting_types_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingTypesByProjectIdApi($database, $project_id, Input $options=null)
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
			self::$_arrMeetingTypesByProjectId = null;
		}

		$arrMeetingTypesByProjectId = self::$_arrMeetingTypesByProjectId;
		if (isset($arrMeetingTypesByProjectId) && !empty($arrMeetingTypesByProjectId)) {
			return $arrMeetingTypesByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `meeting_type` ASC, `meeting_type_abbreviation` ASC, `show_construction_flag` ASC, `show_schedule_flag` ASC, `show_plans_flag` ASC, `show_delays_flag` ASC, `show_rfis_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY mt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingType = new MeetingType($database);
			$sqlOrderByColumns = $tmpMeetingType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	mt.*

FROM `meeting_types` mt
WHERE mt.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `meeting_type` ASC, `meeting_type_abbreviation` ASC, `show_construction_flag` ASC, `show_schedule_flag` ASC, `show_plans_flag` ASC, `show_delays_flag` ASC, `show_rfis_flag` ASC, `sort_order` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMeetingTypesByProjectId = array();
		while ($row = $db->fetch()) {
			$meeting_type_id = $row['id'];
			$meeting_type = $row['meeting_type'];
			// $meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id);
			/* @var $meetingType MeetingType */
			$arrMeetingTypesByProjectId[$meeting_type_id]['meeting_type_id'] = $meeting_type_id;
			$arrMeetingTypesByProjectId[$meeting_type_id]['meeting_type'] = $meeting_type;
		}

		$db->free_result();

		self::$_arrMeetingTypesByProjectId = $arrMeetingTypesByProjectId;

		return $arrMeetingTypesByProjectId;
	}
	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all meeting_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllMeetingTypes($database, Input $options=null)
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
			self::$_arrAllMeetingTypes = null;
		}

		$arrAllMeetingTypes = self::$_arrAllMeetingTypes;
		if (isset($arrAllMeetingTypes) && !empty($arrAllMeetingTypes)) {
			return $arrAllMeetingTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `meeting_type` ASC, `meeting_type_abbreviation` ASC, `show_construction_flag` ASC, `show_schedule_flag` ASC, `show_plans_flag` ASC, `show_delays_flag` ASC, `show_rfis_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY mt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingType = new MeetingType($database);
			$sqlOrderByColumns = $tmpMeetingType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	mt.*

FROM `meeting_types` mt{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `meeting_type` ASC, `meeting_type_abbreviation` ASC, `show_construction_flag` ASC, `show_schedule_flag` ASC, `show_plans_flag` ASC, `show_delays_flag` ASC, `show_rfis_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllMeetingTypes = array();
		while ($row = $db->fetch()) {
			$meeting_type_id = $row['id'];
			$meetingType = self::instantiateOrm($database, 'MeetingType', $row, null, $meeting_type_id);
			/* @var $meetingType MeetingType */
			$arrAllMeetingTypes[$meeting_type_id] = $meetingType;
		}

		$db->free_result();

		self::$_arrAllMeetingTypes = $arrAllMeetingTypes;

		return $arrAllMeetingTypes;
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
INTO `meeting_types`
(`project_id`, `meeting_type`, `meeting_type_abbreviation`, `show_construction_flag`, `show_schedule_flag`, `show_plans_flag`, `show_delays_flag`, `show_rfis_flag`, `sort_order`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `meeting_type_abbreviation` = ?, `show_construction_flag` = ?, `show_schedule_flag` = ?, `show_plans_flag` = ?, `show_delays_flag` = ?, `show_rfis_flag` = ?, `sort_order` = ?
";
		$arrValues = array($this->project_id, $this->meeting_type, $this->meeting_type_abbreviation, $this->show_construction_flag, $this->show_schedule_flag, $this->show_plans_flag, $this->show_delays_flag, $this->show_rfis_flag, $this->sort_order, $this->meeting_type_abbreviation, $this->show_construction_flag, $this->show_schedule_flag, $this->show_plans_flag, $this->show_delays_flag, $this->show_rfis_flag, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$meeting_type_id = $db->insertId;
		$db->free_result();

		return $meeting_type_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
