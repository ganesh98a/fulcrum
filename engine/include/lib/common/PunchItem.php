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
 * PunchItem.
 *
 * @category   Framework
 * @package    PunchItem
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class PunchItem extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'PunchItem';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'punch_item';

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
	 * unique index `unique_su` (`project_id`,`su_sequence_number`) comment 'One Project can have many PunchItems with a sequence number.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_punch_item' => array(
			'id' => 'int',
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
		'id' => 'punch_item_id',
		'project_id' => 'project_id',
		'contracting_entity_id' => 'contracting_entity_id',
		'sequence_number' => 'sequence_number',
		'location_id' => 'location_id',
		'room_id' => 'room_id',
		'description_id' => 'description_id',
		'description' => 'description',
		'description_txt' => 'description_txt',
		'status_id' => 'status_id',
		'file_manager_file_id' => 'file_manager_file_id',
		'cost_code_id' => 'cost_code_id',
		'creator_contact_id' => 'creator_contact_id',
		'creator_contact_company_id' => 'creator_contact_company_id',
		'initiator_contact_id' => 'initiator_contact_id',
		'initiator_contact_company_id' => 'initiator_contact_company_id',
		'recipient_contact_id' => 'recipient_contact_id',
		'recipient_contact_company_id' => 'recipient_contact_company_id',
		'due_date' => 'due_date',
		'draft_flag' => 'draft_flag',
		'created_date' => 'created_date',
		'updated_date' => 'updated_date'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $punch_item_id;
	public $project_id;
	public $contracting_entity_id;
	public $sequence_number;
	public $location_id;
	public $room_id;
	public $description_id;
	public $description;
	public $description_txt;
	public $status_id;
	public $file_manager_file_id;
	public $cost_code_id;
	public $initiator_contact_id;
	public $initiator_contact_company_id;
	public $creator_contact_id;
	public $created_contact_company_id;
	public $recipient_contact_id;
	public $recipient_contact_company_id;
	public $due_date;
	public $draft_flag;
	public $created_date;
	public $updated_date;

	// Other Properties
	//protected $_otherPropertyHere;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllPunchItems;
	protected static $_arrPunchItemByProjectId;

	private $_project;
	private $_piCostCode;
	private $_piFileManagerFile;
	private $_piBuilding;
	private $_piBuildingRoom;
	private $_piCreatorContact;
	private $_piRecipientContact;
	private $_piInitiatorContact;
	private $_piDefect;
	private $_punchItemStatus;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='punch_item')
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

	public function getPiCostCode()
	{
		if (isset($this->_piCostCode)) {
			return $this->_piCostCode;
		} else {
			return null;
		}
	}

	public function setPiCostCode($piCostCode)
	{
		$this->_piCostCode = $piCostCode;
	}

	public function getPiFileManagerFile()
	{
		if (isset($this->_piFileManagerFile)) {
			return $this->_piFileManagerFile;
		} else {
			return null;
		}
	}

	public function setPiFileManagerFile($piFileManagerFile)
	{
		$this->_piFileManagerFile = $piFileManagerFile;
	}

	public function getPiCreatorContact()
	{
		if (isset($this->_piCreatorContact)) {
			return $this->_piCreatorContact;
		} else {
			return null;
		}
	}

	public function setPiCreatorContact($piCreatorContact)
	{
		$this->_piCreatorContact = $piCreatorContact;
	}

	public function getPiRecipientContact()
	{
		if (isset($this->_piRecipientContact)) {
			return $this->_piRecipientContact;
		} else {
			return null;
		}
	}

	public function setPiRecipientContact($piRecipientContact)
	{
		$this->_piRecipientContact = $piRecipientContact;
	}
	
	public function getPiInitiatorContact()
	{
		if (isset($this->_piInitiatorContact)) {
			return $this->_piInitiatorContact;
		} else {
			return null;
		}
	}

	public function setPiInitiatorContact($piInitiatorContact)
	{
		$this->_piInitiatorContact = $piInitiatorContact;
	}

	public function getPiBuilding()
	{
		if (isset($this->_piBuilding)) {
			return $this->_piBuilding;
		} else {
			return null;
		}
	}

	public function setPiBuilding($piBuilding)
	{
		$this->_piBuilding = $piBuilding;
	}

	public function getPiBuildingRoom()
	{
		if (isset($this->_piBuildingRoom)) {
			return $this->_piBuildingRoom;
		} else {
			return null;
		}
	}

	public function setPiBuildingRoom($piBuildingRoom)
	{
		$this->_piBuildingRoom = $piBuildingRoom;
	}

	public function getPiDefect()
	{
		if (isset($this->_piDefect)) {
			return $this->_piDefect;
		} else {
			return null;
		}
	}

	public function setPiDefect($piDefect)
	{
		$this->_piDefect = $piDefect;
	}

	public function getPunchItemStatus()
	{
		if (isset($this->_punchItemStatus)) {
			return $this->_punchItemStatus;
		} else {
			return null;
		}
	}

	public function setPunchItemStatus($punchItemStatus)
	{
		$this->_punchItemStatus = $punchItemStatus;
	}
	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $punch_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $punch_item_id,$table='punch_item', $module='PunchItem')
	{
		$punch_item = parent::findById($database, $punch_item_id,$table, $module);

		return $punch_item;
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_su` (`project_id`,`su_sequence_number`) comment 'One Project can have many PunchItems with a sequence number.'.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $su_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndPiSequenceNumber($database, $project_id, $sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT
		pi.*

		FROM `punch_item` pi
		WHERE pi.`project_id` = ?
		AND pi.`sequence_number` = ?
		AND pi.`draft_flag` = 'N' ORDER BY pi.`id` DESC
		";
		$arrValues = array($project_id, $sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$punch_item_id = $row['id'];
			$punch_item = self::instantiateOrm($database, 'PunchItem', $row, null, $punch_item_id);
			/* @var $PunchItem PunchItem */
			return $punch_item;
		} else {
			return false;
		}
	}

	// Save: insert on duplicate key update
	public function insertOnDuplicateKeyUpdate()
	{
		echo 'test';
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		INSERT
		INTO `punch_item`
		(`project_id`, `sequence_number`, `location_id`, `room_id`, `description_id`, `description`, `status_id`, `file_manager_file_id`, `cost_code_id`, `creator_contact_id`, `creator_contact_company_id`, `initiator_contact_id`, `initiator_contact_company_id`, `recipient_contact_id`, `recipient_contact_company_id`, `description_txt`)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		ON DUPLICATE KEY UPDATE `project_id` = ?, `sequence_number` = ?, `location_id` = ?,` room_id` = ?, `description_id` = ?, `description` = ?, `status_id` = ?, `file_manager_file_id` = ?, `cost_code_id` = ?, `creator_contact_id` = ? `status_id` = ?,  creator_contact_id` = ?,  `creator_contact_company_id` = ?, `initiator_contact_id` = ?, `initiator_contact_company_id` = ?, `recipient_contact_id` = ?, `recipient_contact_company_id` = ?, `description_txt` = ?
		";
		$arrValues = array($this->project_id, $this->sequence_number, $this->location_id, $this->room_id, $this->description_id, $this->description, $this->status_id, $this->file_manager_file_id, $this->cost_code_id,  $this->creator_contact_id, $this->initiator_contact_id, $this->initiator_contact_company_id, $this->recipient_contact_id, $this->recipient_contact_company_id, $this->description_txt);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$punch_item_id = $db->insertId;
		$db->free_result();

		return $punch_item_id;
	}

	// Save: insert ignore

	/**
	 * Find next_su_sequence_number value.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextPunchItemSequenceNumber($database, $project_id)
	{
		$next_su_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT MAX(pi.sequence_number) AS 'max_su_sequence_number'
		FROM `punch_item` pi
		WHERE pi.`project_id` = ?
		AND pi.`draft_flag` = 'N' ORDER BY pi.`id` DESC
		";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_su_sequence_number = $row['max_su_sequence_number'];
			$next_su_sequence_number = $max_su_sequence_number + 1;
		}

		return $next_su_sequence_number;
	}

	// Save: insert ignore

	/**
	 * Find next_su_sequence_number value by suncontract with project.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextPunchItemSequenceNumberWithSubcontractGrouping($database, $project_id, $recipient_contact_id)
	{
		$next_su_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT MAX(pi.sequence_number) AS 'max_su_sequence_number'
		FROM `punch_item` pi
		WHERE pi.`project_id` = ?
		AND pi.`recipient_contact_company_id` = ?
		AND pi.`draft_flag` = 'N' ORDER BY pi.`id` DESC
		";
		$arrValues = array($project_id, $recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_su_sequence_number = $row['max_su_sequence_number'];
			$next_su_sequence_number = $max_su_sequence_number + 1;
		}

		return $next_su_sequence_number;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $punch_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findPunchItemByIdExtended($database, $punch_item_id)
	{
		$punch_item_id = (int) $punch_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT

		pi_fk_p.`id` AS 'pi_fk_p__project_id',
		pi_fk_p.`project_type_id` AS 'pi_fk_p__project_type_id',
		pi_fk_p.`user_company_id` AS 'pi_fk_p__user_company_id',
		pi_fk_p.`user_custom_project_id` AS 'pi_fk_p__user_custom_project_id',
		pi_fk_p.`project_name` AS 'pi_fk_p__project_name',
		pi_fk_p.`project_owner_name` AS 'pi_fk_p__project_owner_name',
		pi_fk_p.`latitude` AS 'pi_fk_p__latitude',
		pi_fk_p.`longitude` AS 'pi_fk_p__longitude',
		pi_fk_p.`address_line_1` AS 'pi_fk_p__address_line_1',
		pi_fk_p.`address_line_2` AS 'pi_fk_p__address_line_2',
		pi_fk_p.`address_line_3` AS 'pi_fk_p__address_line_3',
		pi_fk_p.`address_line_4` AS 'pi_fk_p__address_line_4',
		pi_fk_p.`address_city` AS 'pi_fk_p__address_city',
		pi_fk_p.`address_county` AS 'pi_fk_p__address_county',
		pi_fk_p.`address_state_or_region` AS 'pi_fk_p__address_state_or_region',
		pi_fk_p.`address_postal_code` AS 'pi_fk_p__address_postal_code',
		pi_fk_p.`address_postal_code_extension` AS 'pi_fk_p__address_postal_code_extension',
		pi_fk_p.`address_country` AS 'pi_fk_p__address_country',
		pi_fk_p.`building_count` AS 'pi_fk_p__building_count',
		pi_fk_p.`unit_count` AS 'pi_fk_p__unit_count',
		pi_fk_p.`gross_square_footage` AS 'pi_fk_p__gross_square_footage',
		pi_fk_p.`net_rentable_square_footage` AS 'pi_fk_p__net_rentable_square_footage',
		pi_fk_p.`is_active_flag` AS 'pi_fk_p__is_active_flag',
		pi_fk_p.`public_plans_flag` AS 'pi_fk_p__public_plans_flag',
		pi_fk_p.`prevailing_wage_flag` AS 'pi_fk_p__prevailing_wage_flag',
		pi_fk_p.`city_business_license_required_flag` AS 'pi_fk_p__city_business_license_required_flag',
		pi_fk_p.`is_internal_flag` AS 'pi_fk_p__is_internal_flag',
		pi_fk_p.`project_contract_date` AS 'pi_fk_p__project_contract_date',
		pi_fk_p.`project_start_date` AS 'pi_fk_p__project_start_date',
		pi_fk_p.`project_completed_date` AS 'pi_fk_p__project_completed_date',
		pi_fk_p.`sort_order` AS 'pi_fk_p__sort_order',

		pi_fk_fmfiles.`id` AS 'pi_fk_fmfiles__file_manager_file_id',
		pi_fk_fmfiles.`user_company_id` AS 'pi_fk_fmfiles__user_company_id',
		pi_fk_fmfiles.`contact_id` AS 'pi_fk_fmfiles__contact_id',
		pi_fk_fmfiles.`project_id` AS 'pi_fk_fmfiles__project_id',
		pi_fk_fmfiles.`file_manager_folder_id` AS 'pi_fk_fmfiles__file_manager_folder_id',
		pi_fk_fmfiles.`file_location_id` AS 'pi_fk_fmfiles__file_location_id',
		pi_fk_fmfiles.`virtual_file_name` AS 'pi_fk_fmfiles__virtual_file_name',
		pi_fk_fmfiles.`version_number` AS 'pi_fk_fmfiles__version_number',
		pi_fk_fmfiles.`virtual_file_name_sha1` AS 'pi_fk_fmfiles__virtual_file_name_sha1',
		pi_fk_fmfiles.`virtual_file_mime_type` AS 'pi_fk_fmfiles__virtual_file_mime_type',
		pi_fk_fmfiles.`modified` AS 'pi_fk_fmfiles__modified',
		pi_fk_fmfiles.`created` AS 'pi_fk_fmfiles__created',
		pi_fk_fmfiles.`deleted_flag` AS 'pi_fk_fmfiles__deleted_flag',
		pi_fk_fmfiles.`directly_deleted_flag` AS 'pi_fk_fmfiles__directly_deleted_flag',

		pi_fk_creator_c.`id` AS 'pi_fk_creator_c__contact_id',
		pi_fk_creator_c.`user_company_id` AS 'pi_fk_creator_c__user_company_id',
		pi_fk_creator_c.`user_id` AS 'pi_fk_creator_c__user_id',
		pi_fk_creator_c.`contact_company_id` AS 'pi_fk_creator_c__contact_company_id',
		pi_fk_creator_c.`email` AS 'pi_fk_creator_c__email',
		pi_fk_creator_c.`name_prefix` AS 'pi_fk_creator_c__name_prefix',
		pi_fk_creator_c.`first_name` AS 'pi_fk_creator_c__first_name',
		pi_fk_creator_c.`additional_name` AS 'pi_fk_creator_c__additional_name',
		pi_fk_creator_c.`middle_name` AS 'pi_fk_creator_c__middle_name',
		pi_fk_creator_c.`last_name` AS 'pi_fk_creator_c__last_name',
		pi_fk_creator_c.`name_suffix` AS 'pi_fk_creator_c__name_suffix',
		pi_fk_creator_c.`title` AS 'pi_fk_creator_c__title',
		pi_fk_creator_c.`vendor_flag` AS 'pi_fk_creator_c__vendor_flag',

		pi_fk_pis.`id` AS 'pi_fk_pis__status_id',
		pi_fk_pis.`punch_item_status` AS 'pi_fk_pis__punch_item_status',
		pi_fk_pis.`disabled_flag` AS 'pi_fk_pis__disabled_flag',

		pi_fk_recipient_c.`id` AS 'pi_fk_recipient_c__contact_id',
		pi_fk_recipient_c.`user_company_id` AS 'pi_fk_recipient_c__user_company_id',
		pi_fk_recipient_c.`user_id` AS 'pi_fk_recipient_c__user_id',
		pi_fk_recipient_c.`contact_company_id` AS 'pi_fk_recipient_c__contact_company_id',
		pi_fk_recipient_c.`email` AS 'pi_fk_recipient_c__email',
		pi_fk_recipient_c.`name_prefix` AS 'pi_fk_recipient_c__name_prefix',
		pi_fk_recipient_c.`first_name` AS 'pi_fk_recipient_c__first_name',
		pi_fk_recipient_c.`additional_name` AS 'pi_fk_recipient_c__additional_name',
		pi_fk_recipient_c.`middle_name` AS 'pi_fk_recipient_c__middle_name',
		pi_fk_recipient_c.`last_name` AS 'pi_fk_recipient_c__last_name',
		pi_fk_recipient_c.`name_suffix` AS 'pi_fk_recipient_c__name_suffix',
		pi_fk_recipient_c.`title` AS 'pi_fk_recipient_c__title',
		pi_fk_recipient_c.`vendor_flag` AS 'pi_fk_recipient_c__vendor_flag',
		
		pi_fk_initiator_c.`id` AS 'pi_fk_initiator_c__contact_id',
		pi_fk_initiator_c.`user_company_id` AS 'pi_fk_initiator_c__user_company_id',
		pi_fk_initiator_c.`user_id` AS 'pi_fk_initiator_c__user_id',
		pi_fk_initiator_c.`contact_company_id` AS 'pi_fk_initiator_c__contact_company_id',
		pi_fk_initiator_c.`email` AS 'pi_fk_initiator_c__email',
		pi_fk_initiator_c.`name_prefix` AS 'pi_fk_initiator_c__name_prefix',
		pi_fk_initiator_c.`first_name` AS 'pi_fk_initiator_c__first_name',
		pi_fk_initiator_c.`additional_name` AS 'pi_fk_initiator_c__additional_name',
		pi_fk_initiator_c.`middle_name` AS 'pi_fk_initiator_c__middle_name',
		pi_fk_initiator_c.`last_name` AS 'pi_fk_initiator_c__last_name',
		pi_fk_initiator_c.`name_suffix` AS 'pi_fk_initiator_c__name_suffix',
		pi_fk_initiator_c.`title` AS 'pi_fk_initiator_c__title',
		pi_fk_initiator_c.`vendor_flag` AS 'pi_fk_initiator_c__vendor_flag',
		
		pi_fk_creator_c__fk_cc.`id` AS 'pi_fk_creator_c__fk_cc__contact_company_id',
		pi_fk_creator_c__fk_cc.`user_user_company_id` AS 'pi_fk_creator_c__fk_cc__user_user_company_id',
		pi_fk_creator_c__fk_cc.`contact_user_company_id` AS 'pi_fk_creator_c__fk_cc__contact_user_company_id',
		pi_fk_creator_c__fk_cc.`company` AS 'pi_fk_creator_c__fk_cc__company',
		pi_fk_creator_c__fk_cc.`primary_phone_number` AS 'pi_fk_creator_c__fk_cc__primary_phone_number',
		pi_fk_creator_c__fk_cc.`employer_identification_number` AS 'pi_fk_creator_c__fk_cc__employer_identification_number',
		pi_fk_creator_c__fk_cc.`construction_license_number` AS 'pi_fk_creator_c__fk_cc__construction_license_number',
		pi_fk_creator_c__fk_cc.`construction_license_number_expiration_date` AS 'pi_fk_creator_c__fk_cc__construction_license_number_expiration_date',
		pi_fk_creator_c__fk_cc.`vendor_flag` AS 'pi_fk_creator_c__fk_cc__vendor_flag',

		pi_fk_recipient_c_fk_cc.`id` AS 'pi_fk_recipient_c_fk_cc__contact_company_id',
		pi_fk_recipient_c_fk_cc.`user_user_company_id` AS 'pi_fk_recipient_c_fk_cc__user_user_company_id',
		pi_fk_recipient_c_fk_cc.`contact_user_company_id` AS 'pi_fk_recipient_c_fk_cc__contact_user_company_id',
		pi_fk_recipient_c_fk_cc.`company` AS 'pi_fk_recipient_c_fk_cc__company',
		pi_fk_recipient_c_fk_cc.`primary_phone_number` AS 'pi_fk_recipient_c_fk_cc__primary_phone_number',
		pi_fk_recipient_c_fk_cc.`employer_identification_number` AS 'pi_fk_recipient_c_fk_cc__employer_identification_number',
		pi_fk_recipient_c_fk_cc.`construction_license_number` AS 'pi_fk_recipient_c_fk_cc__construction_license_number',
		pi_fk_recipient_c_fk_cc.`construction_license_number_expiration_date` AS 'pi_fk_recipient_c_fk_cc__construction_license_number_expiration_date',
		pi_fk_recipient_c_fk_cc.`vendor_flag` AS 'pi_fk_recipient_c_fk_cc__vendor_flag',

		pi_fk_initiator_c__fk_cc.`id` AS 'pi_fk_initiator_c__fk_cc__contact_company_id',
		pi_fk_initiator_c__fk_cc.`user_user_company_id` AS 'pi_fk_initiator_c__fk_cc__user_user_company_id',
		pi_fk_initiator_c__fk_cc.`contact_user_company_id` AS 'pi_fk_initiator_c__fk_cc__contact_user_company_id',
		pi_fk_initiator_c__fk_cc.`company` AS 'pi_fk_initiator_c__fk_cc__company',
		pi_fk_initiator_c__fk_cc.`primary_phone_number` AS 'pi_fk_initiator_c__fk_cc__primary_phone_number',
		pi_fk_initiator_c__fk_cc.`employer_identification_number` AS 'pi_fk_initiator_c__fk_cc__employer_identification_number',
		pi_fk_initiator_c__fk_cc.`construction_license_number` AS 'pi_fk_initiator_c__fk_cc__construction_license_number',
		pi_fk_initiator_c__fk_cc.`construction_license_number_expiration_date` AS 'pi_fk_initiator_c__fk_cc__construction_license_number_expiration_date',
		pi_fk_initiator_c__fk_cc.`vendor_flag` AS 'pi_fk_initiator_c__fk_cc__vendor_flag',

		pi_fk_pib.`id` AS 'pi_fk_pib__id',
		pi_fk_pib.`project_id` AS 'pi_fk_pib__project_id',
		pi_fk_pib.`building_name` AS 'pi_fk_pib__building_name',
		pi_fk_pib.`location` AS 'pi_fk_pib__location',

		pi_fk_pibr.`id` AS 'pi_fk_pibr__id',
		pi_fk_pibr.`project_id` AS 'pi_fk_pibr__project_id',
		pi_fk_pibr.`building_id` AS 'pi_fk_pibr__building_id',
		pi_fk_pibr.`room_name` AS 'pi_fk_pibr__room_name',
		pi_fk_pibr.`description` AS 'pi_fk_pibr__description',

		pi_fk_pid.`id` AS 'pi_fk_pid__id',
		pi_fk_pid.`user_company_id` AS 'pi_fk_pid__user_company_id',
		pi_fk_pid.`defect_name` AS 'pi_fk_pid__defect_name',

		pi_fk_codes.`id` AS 'pi_fk_codes__cost_code_id',
		pi_fk_codes.`cost_code_division_id` AS 'pi_fk_codes__cost_code_division_id',
		pi_fk_codes.`cost_code` AS 'pi_fk_codes__cost_code',
		pi_fk_codes.`cost_code_description` AS 'pi_fk_codes__cost_code_description',
		pi_fk_codes.`cost_code_description_abbreviation` AS 'pi_fk_codes__cost_code_description_abbreviation',
		pi_fk_codes.`sort_order` AS 'pi_fk_codes__sort_order',
		pi_fk_codes.`disabled_flag` AS 'pi_fk_codes__disabled_flag',

		CONCAT(pi_fk_code_division.`division_number`,pi_fk_codes.`cost_code`) AS 'concat_costcode',
		pi_fk_code_division.`division_number` AS 'pi_fk_code_division__division_number',

		pi.*

		FROM `punch_item` pi
		INNER JOIN `projects` pi_fk_p ON pi.`project_id` = pi_fk_p.`id`
		INNER JOIN `punch_item_status` pi_fk_pis ON pi.`status_id` = pi_fk_pis.`id`
		INNER JOIN `contacts` pi_fk_creator_c ON pi.`creator_contact_id` = pi_fk_creator_c.`id`
		LEFT OUTER JOIN `file_manager_files` pi_fk_fmfiles ON pi.`file_manager_file_id` = pi_fk_fmfiles.`id`
		LEFT OUTER JOIN `punch_building_data` pi_fk_pib ON pi.`location_id` = pi_fk_pib.`id`
		LEFT OUTER JOIN `punch_room_data` pi_fk_pibr ON pi.`room_id` = pi_fk_pibr.`id`
		LEFT OUTER JOIN `punch_defects` pi_fk_pid ON pi.`description_id` = pi_fk_pid.`id`
		LEFT OUTER JOIN `contacts` pi_fk_recipient_c ON pi.`recipient_contact_id` = pi_fk_recipient_c.`id`		
		LEFT OUTER JOIN `contacts` pi_fk_initiator_c ON pi.`initiator_contact_id` = pi_fk_initiator_c.`id`		
		INNER JOIN `contact_companies` pi_fk_creator_c__fk_cc ON pi_fk_creator_c.`contact_company_id` = pi_fk_creator_c__fk_cc.`id`
		LEFT OUTER JOIN `contact_companies` pi_fk_recipient_c_fk_cc ON pi_fk_recipient_c.`contact_company_id` = pi_fk_recipient_c_fk_cc.`id`
		LEFT OUTER JOIN `contact_companies` pi_fk_initiator_c__fk_cc ON pi_fk_initiator_c.`contact_company_id` = pi_fk_initiator_c__fk_cc.`id`
		LEFT OUTER JOIN `cost_codes` pi_fk_codes ON pi.`cost_code_id` = pi_fk_codes.`id`
		LEFT OUTER JOIN `cost_code_divisions` pi_fk_code_division ON pi_fk_codes.`cost_code_division_id` = pi_fk_code_division.`id`
		WHERE pi.`id` = ?
		";
		$arrValues = array($punch_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			// PunchItem
			$punch_item_id = $row['id'];
			$punchItem = self::instantiateOrm($database, 'PunchItem', $row, null, $punch_item_id);
			/* @var $punchItem PunchItem */
			$punchItem->convertPropertiesToData();
			//  Project
			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['pi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'pi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$punchItem->setProject($project);
			// PunchItemStatus
			if (isset($row['status_id'])) {
				$punch_item_status_id = $row['status_id'];
				$row['pi_fk_pis__id'] = $punch_item_status_id;
				$punchItemStatus = self::instantiateOrm($database, 'PunchItemStatus', $row, null, $punch_item_status_id, 'pi_fk_pis__');
				/* @var $punchItemStatus PunchItemStatus */
				$punchItemStatus->convertPropertiesToData();
			} else {
				$punchItemStatus = false;
			}
			$punchItem->setPunchItemStatus($punchItemStatus);
			// punch item cost code
			if (isset($row['cost_code_id']) && $row['cost_code_id']) {
				$cost_code_id = $row['cost_code_id'];
				$row['pi_fk_codes__id'] = $cost_code_id;
				$piCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'pi_fk_codes__');
				/* @var $suCostCode CostCode */
				$piCostCode->convertPropertiesToData();
			} else {
				$piCostCode = false;
			}
			$punchItem->setPiCostCode($piCostCode);
			// FileManagerFile
			if (isset($row['file_manager_file_id']) && !empty($row['file_manager_file_id'])) {
				$pi_file_manager_file_id = $row['file_manager_file_id'];
				$row['pi_fk_fmfiles__id'] = $pi_file_manager_file_id;
				$piFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $pi_file_manager_file_id, 'pi_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$piFileManagerFile->convertPropertiesToData();
			} else {
				$piFileManagerFile = false;
			}
			$punchItem->setPiFileManagerFile($piFileManagerFile);
			// PunchItemBuilding
			if (isset($row['pi_fk_pib__id']) && !empty($row['pi_fk_pib__id'])) {
				$pi_building_id = $row['pi_fk_pib__id'];
				$row['pi_fk_pib__id'] = $pi_building_id;
				$piBuilding = self::instantiateOrm($database, 'PunchItemBuilding', $row, null, $pi_building_id, 'pi_fk_pib__');
				/* @var $suFileManagerFile FileManagerFile */
				$piBuilding->convertPropertiesToData();
			} else {
				$piBuilding = false;
			}
			$punchItem->setPiBuilding($piBuilding);
			// PunchItemBuildingRoom
			if (isset($row['pi_fk_pib__id']) && !empty($row['pi_fk_pib__id'])) {
				$pi_building_id = $row['pi_fk_pib__id'];
				$row['pi_fk_pib__id'] = $pi_building_id;
				$piBuilding = self::instantiateOrm($database, 'PunchItemBuilding', $row, null, $pi_building_id, 'pi_fk_pib__');
				/* @var $suFileManagerFile FileManagerFile */
				$piBuilding->convertPropertiesToData();
			} else {
				$piBuilding = false;
			}
			$punchItem->setPiBuilding($piBuilding);
			// PunchItemDefect
			if (isset($row['pi_fk_pid__id']) && !empty($row['pi_fk_pid__id'])) {
				$pi_defect_id = $row['pi_fk_pid__id'];
				$row['pi_fk_pid__id'] = $pi_defect_id;
				$piDefect = self::instantiateOrm($database, 'PunchItemDefect', $row, null, $pi_defect_id, 'pi_fk_pid__');
				/* @var $suFileManagerFile FileManagerFile */
				$piDefect->convertPropertiesToData();
			} else {
				$piDefect = false;
			}
			$punchItem->setPiDefect($piDefect);
			// PunchItemBuildingRoom
			if (isset($row['pi_fk_pibr__id']) && !empty($row['pi_fk_pibr__id'])) {
				$pi_building_room_id = $row['pi_fk_pib__id'];
				$row['pi_fk_pibr__id'] = $pi_building_room_id;
				$piBuildingRoom = self::instantiateOrm($database, 'PunchItemBuildingRoom', $row, null, $pi_building_id, 'pi_fk_pibr__');
				/* @var $suFileManagerFile FileManagerFile */
				$piBuildingRoom->convertPropertiesToData();
			} else {
				$piBuildingRoom = false;
			}
			$punchItem->setPiBuildingRoom($piBuildingRoom);
			// creator contacts
			if (isset($row['creator_contact_id'])) {
				$pi_creator_contact_id = $row['creator_contact_id'];
				$row['pi_fk_creator_c__id'] = $pi_creator_contact_id;
				$piCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $pi_creator_contact_id, 'pi_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$piCreatorContact->convertPropertiesToData();
			} else {
				$piCreatorContact = false;
			}
			$punchItem->setPiCreatorContact($piCreatorContact);			
			// recipient cotact
			if (isset($row['recipient_contact_id'])) {
				$pi_recipient_contact_id = $row['recipient_contact_id'];
				$row['pi_fk_recipient_c__id'] = $pi_recipient_contact_id;
				$piRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $pi_recipient_contact_id, 'pi_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$piRecipientContact->convertPropertiesToData();
			} else {
				$piRecipientContact = false;
			}
			$punchItem->setPiRecipientContact($piRecipientContact);
			// initiator contact
			if (isset($row['initiator_contact_id']) && $row['initiator_contact_id']) {
				$pi_initiator_contact_id = $row['initiator_contact_id'];
				$row['pi_fk_initiator_c__id'] = $pi_initiator_contact_id;
				$piInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $pi_initiator_contact_id, 'pi_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$piInitiatorContact->convertPropertiesToData();
			} else {
				$piInitiatorContact = false;
			}
			$punchItem->setPiInitiatorContact($piInitiatorContact);
			// Extra: PunchItem Creator - Contact Company
			if (isset($row['pi_fk_creator_c__fk_cc__contact_company_id'])) {
				$pi_creator_contact_company_id = $row['pi_fk_creator_c__fk_cc__contact_company_id'];
				$row['pi_fk_creator_c__fk_cc__id'] = $pi_creator_contact_company_id;
				$piCreatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $pi_creator_contact_company_id, 'pi_fk_creator_c__fk_cc__');
				/* @var $suCreatorContactCompany ContactCompany */
				$piCreatorContactCompany->convertPropertiesToData();
			} else {
				$piCreatorContactCompany = false;
			}
			if ($piCreatorContact) {
				$piCreatorContact->setContactCompany($piCreatorContactCompany);
			}

			// Extra: PunchItem Recipient - Contact Company
			if (isset($row['pi_fk_recipient_c_fk_cc__contact_company_id'])) {
				$pi_recipient_contact_company_id = $row['pi_fk_recipient_c_fk_cc__contact_company_id'];
				$row['pi_fk_recipient_c_fk_cc__id'] = $pi_recipient_contact_company_id;
				$piRecipientContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $pi_recipient_contact_company_id, 'pi_fk_recipient_c_fk_cc__');
				/* @var $suRecipientContactCompany ContactCompany */
				$piRecipientContactCompany->convertPropertiesToData();
			} else {
				$piRecipientContactCompany = false;
			}
			if ($piRecipientContact) {
				$piRecipientContact->setContactCompany($piRecipientContactCompany);
			}

			// Extra: PunchItem Initiator - Contact Company
			if (isset($row['pi_fk_initiator_c_fk_cc__contact_company_id'])) {
				$pi_initiator_contact_company_id = $row['pi_fk_initiator_c_fk_cc__contact_company_id'];
				$row['pi_fk_initiator_c_fk_cc__id'] = $pi_initiator_contact_company_id;
				$piInitiatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $pi_initiator_contact_company_id, 'pi_fk_initiator_c_fk_cc__');
				/* @var $suInitiatorContactCompany ContactCompany */
				$piInitiatorContactCompany->convertPropertiesToData();
			} else {
				$piInitiatorContactCompany = false;
			}
			if ($piInitiatorContact) {
				$piInitiatorContact->setContactCompany($piInitiatorContactCompany);
			}

			return $punchItem;
		} else {
			return false;
		}
	}


	public static function loadpunchListforWeb($database, $project_id, $currentlyActiveContactId)
	{
		$db = DBI::getInstance($database);
		// $sqlOrderBy = "\nORDER BY pi_fk_recipient_c_fk_cc.`company` IS NULL ASC,pi_fk_recipient_c_fk_cc.`company` ASC, concat_costcode IS NULL ASC, concat_costcode ASC, pi_fk_recipient_c_fk_cc.`company` ASC ";
		// $whereContact = '';
		// $whereContact = 'AND pi.`draft_flag` = \''.$draft_flag.'\'';
		$query =
		"
		select ps.punch_item_status ,
		pb.building_name, pb.location,
		pr.building_id ,pr.room_name,pr.description as build_description ,
		pd.defect_name,

		cc.`id` AS 'cc__cost_code_id',
		cc.`cost_code_division_id` AS 'cc__cost_code_division_id',
		cc.`cost_code` AS 'cc__cost_code',
		cc.`cost_code_description` AS 'cc__cost_code_description',
		cc.`cost_code_description_abbreviation` AS 'cc__cost_code_description_abbreviation',
		cc.`sort_order` AS 'cc__sort_order',
		cc.`disabled_flag` AS 'cc__disabled_flag',

		CONCAT(cd.`division_number`,'-',cc.`cost_code`) AS 'concat_costcode',
		cd.`division_number` AS 'cd__division_number',

		comp.company as subcontractor_company,

		pi.*  from punch_item as pi

		inner join punch_item_status as ps on pi.status_id =ps.id 
		inner join punch_building_data as pb on pi.location_id= pb.id
		inner join punch_room_data as pr on pi.room_id =pr.id
		inner join punch_defects as pd on pi.description_id = pd.id
		inner join contact_companies as comp on pi.recipient_contact_company_id = comp.id
		LEFT OUTER JOIN `cost_codes` cc ON pi.`cost_code_id` = cc.`id`
		LEFT OUTER JOIN `cost_code_divisions` cd ON cc.`cost_code_division_id` = cd.`id`

		where pi.project_id= ? and pi.draft_flag='N' order by subcontractor_company ASC ,pi.sequence_number ASC
		";
		
		$arrValues = array($project_id);
		
		$db->execute($query, $arrValues);
		$arrPunchItemByProjectId = array();
		while ($row = $db->fetch()) {
			$arrPunchItemByProjectId []=$row;
		}
		return $arrPunchItemByProjectId;
	}
	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $punch_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadPunchItemByProjectId($database, $project_id, $draft_flag = 'N', $activeContactId, $whereSuCost = false, $costcode_id, $recipient_contact_id, $whereFilter = null, $orderBy)
	{
		// $punch_item_id = (int) $punch_item_id;

		$db = DBI::getInstance($database);
		$db->begin();
		$db->free_result();
		/* @var $db DBI_mysqli */
		/*$sqlOrderBy = "\nORDER BY pi_fk_recipient_c_fk_cc.`company` IS NULL ASC,pi_fk_recipient_c_fk_cc.`company` ASC, subsquence_order IS NULL ASC, subsquence_order ASC, pi_fk_recipient_c_fk_cc.`company` ASC ";*/
		$sqlOrderBy = "\nORDER BY pi_fk_recipient_c_fk_cc.`company` ASC,  pi.`sequence_number` DESC";
		// sort by building name
		if ($orderBy == 'by_building') {
			$sqlOrderBy = "\nORDER BY pi_fk_pib.`building_name` ASC,  pi.`sequence_number` DESC";
		}
		$whereContact = '';
		if($draft_flag !== 'All') {
			// fetch draft item Y or N
			$whereContact = 'AND pi.`draft_flag` = \''.$draft_flag.'\'';
		} else {
			// fetch items when draft is Y check contact id is currently loggged user is match
			$whereContact = 'AND CASE WHEN pi.`draft_flag` = "Y" THEN pi.`creator_contact_id` = \''.$activeContactId.'\' ELSE TRUE END';
		}
		if($draft_flag == 'Y'){
			// fetch items when draft is Y check contact id is currently loggged user is match
			$whereContact='AND pi.`draft_flag` = \''.$draft_flag.'\' AND pi.`creator_contact_id` = \''.$activeContactId.'\'';
			$sqlOrderBy = "\nORDER BY pi_fk_recipient_c.`email` ASC, pi.`id` ASC";

		}
		if($whereSuCost){
			$whereContact.=' AND pi.`cost_code_id` = \''.$costcode_id.'\' AND pi.`recipient_contact_id` = \''.$recipient_contact_id.'\'';
		}
		if($whereFilter!=null){
			$whereContact.= $whereFilter;
		}
		$query =
		"
		SELECT
		CONCAT(pi_fk_code_division.`division_number`,pi_fk_codes.`cost_code`) AS 'concat_costcode',
		CONCAT(pi.`recipient_contact_company_id`,pi.`sequence_number`) AS 'subsquence_order',
		pi_fk_code_division.`division_number` AS 'su_fk_code_division__division_number',

		pi_fk_p.`id` AS 'pi_fk_p__project_id',
		pi_fk_p.`project_type_id` AS 'pi_fk_p__project_type_id',
		pi_fk_p.`user_company_id` AS 'pi_fk_p__user_company_id',
		pi_fk_p.`user_custom_project_id` AS 'pi_fk_p__user_custom_project_id',
		pi_fk_p.`project_name` AS 'pi_fk_p__project_name',
		pi_fk_p.`project_owner_name` AS 'pi_fk_p__project_owner_name',
		pi_fk_p.`latitude` AS 'pi_fk_p__latitude',
		pi_fk_p.`longitude` AS 'pi_fk_p__longitude',
		pi_fk_p.`address_line_1` AS 'pi_fk_p__address_line_1',
		pi_fk_p.`address_line_2` AS 'pi_fk_p__address_line_2',
		pi_fk_p.`address_line_3` AS 'pi_fk_p__address_line_3',
		pi_fk_p.`address_line_4` AS 'pi_fk_p__address_line_4',
		pi_fk_p.`address_city` AS 'pi_fk_p__address_city',
		pi_fk_p.`address_county` AS 'pi_fk_p__address_county',
		pi_fk_p.`address_state_or_region` AS 'pi_fk_p__address_state_or_region',
		pi_fk_p.`address_postal_code` AS 'pi_fk_p__address_postal_code',
		pi_fk_p.`address_postal_code_extension` AS 'pi_fk_p__address_postal_code_extension',
		pi_fk_p.`address_country` AS 'pi_fk_p__address_country',
		pi_fk_p.`building_count` AS 'pi_fk_p__building_count',
		pi_fk_p.`unit_count` AS 'pi_fk_p__unit_count',
		pi_fk_p.`gross_square_footage` AS 'pi_fk_p__gross_square_footage',
		pi_fk_p.`net_rentable_square_footage` AS 'pi_fk_p__net_rentable_square_footage',
		pi_fk_p.`is_active_flag` AS 'pi_fk_p__is_active_flag',
		pi_fk_p.`public_plans_flag` AS 'pi_fk_p__public_plans_flag',
		pi_fk_p.`prevailing_wage_flag` AS 'pi_fk_p__prevailing_wage_flag',
		pi_fk_p.`city_business_license_required_flag` AS 'pi_fk_p__city_business_license_required_flag',
		pi_fk_p.`is_internal_flag` AS 'pi_fk_p__is_internal_flag',
		pi_fk_p.`project_contract_date` AS 'pi_fk_p__project_contract_date',
		pi_fk_p.`project_start_date` AS 'pi_fk_p__project_start_date',
		pi_fk_p.`project_completed_date` AS 'pi_fk_p__project_completed_date',
		pi_fk_p.`sort_order` AS 'pi_fk_p__sort_order',

		pi_fk_fmfiles.`id` AS 'pi_fk_fmfiles__file_manager_file_id',
		pi_fk_fmfiles.`user_company_id` AS 'pi_fk_fmfiles__user_company_id',
		pi_fk_fmfiles.`contact_id` AS 'pi_fk_fmfiles__contact_id',
		pi_fk_fmfiles.`project_id` AS 'pi_fk_fmfiles__project_id',
		pi_fk_fmfiles.`file_manager_folder_id` AS 'pi_fk_fmfiles__file_manager_folder_id',
		pi_fk_fmfiles.`file_location_id` AS 'pi_fk_fmfiles__file_location_id',
		pi_fk_fmfiles.`virtual_file_name` AS 'pi_fk_fmfiles__virtual_file_name',
		pi_fk_fmfiles.`version_number` AS 'pi_fk_fmfiles__version_number',
		pi_fk_fmfiles.`virtual_file_name_sha1` AS 'pi_fk_fmfiles__virtual_file_name_sha1',
		pi_fk_fmfiles.`virtual_file_mime_type` AS 'pi_fk_fmfiles__virtual_file_mime_type',
		pi_fk_fmfiles.`modified` AS 'pi_fk_fmfiles__modified',
		pi_fk_fmfiles.`created` AS 'pi_fk_fmfiles__created',
		pi_fk_fmfiles.`deleted_flag` AS 'pi_fk_fmfiles__deleted_flag',
		pi_fk_fmfiles.`directly_deleted_flag` AS 'pi_fk_fmfiles__directly_deleted_flag',

		pi_fk_creator_c.`id` AS 'pi_fk_creator_c__contact_id',
		pi_fk_creator_c.`user_company_id` AS 'pi_fk_creator_c__user_company_id',
		pi_fk_creator_c.`user_id` AS 'pi_fk_creator_c__user_id',
		pi_fk_creator_c.`contact_company_id` AS 'pi_fk_creator_c__contact_company_id',
		pi_fk_creator_c.`email` AS 'pi_fk_creator_c__email',
		pi_fk_creator_c.`name_prefix` AS 'pi_fk_creator_c__name_prefix',
		pi_fk_creator_c.`first_name` AS 'pi_fk_creator_c__first_name',
		pi_fk_creator_c.`additional_name` AS 'pi_fk_creator_c__additional_name',
		pi_fk_creator_c.`middle_name` AS 'pi_fk_creator_c__middle_name',
		pi_fk_creator_c.`last_name` AS 'pi_fk_creator_c__last_name',
		pi_fk_creator_c.`name_suffix` AS 'pi_fk_creator_c__name_suffix',
		pi_fk_creator_c.`title` AS 'pi_fk_creator_c__title',
		pi_fk_creator_c.`vendor_flag` AS 'pi_fk_creator_c__vendor_flag',

		pi_fk_pis.`id` AS 'pi_fk_pis__status_id',
		pi_fk_pis.`punch_item_status` AS 'pi_fk_pis__punch_item_status',
		pi_fk_pis.`disabled_flag` AS 'pi_fk_pis__disabled_flag',

		pi_fk_recipient_c.`id` AS 'pi_fk_recipient_c__contact_id',
		pi_fk_recipient_c.`user_company_id` AS 'pi_fk_recipient_c__user_company_id',
		pi_fk_recipient_c.`user_id` AS 'pi_fk_recipient_c__user_id',
		pi_fk_recipient_c.`contact_company_id` AS 'pi_fk_recipient_c__contact_company_id',
		pi_fk_recipient_c.`email` AS 'pi_fk_recipient_c__email',
		pi_fk_recipient_c.`name_prefix` AS 'pi_fk_recipient_c__name_prefix',
		pi_fk_recipient_c.`first_name` AS 'pi_fk_recipient_c__first_name',
		pi_fk_recipient_c.`additional_name` AS 'pi_fk_recipient_c__additional_name',
		pi_fk_recipient_c.`middle_name` AS 'pi_fk_recipient_c__middle_name',
		pi_fk_recipient_c.`last_name` AS 'pi_fk_recipient_c__last_name',
		pi_fk_recipient_c.`name_suffix` AS 'pi_fk_recipient_c__name_suffix',
		pi_fk_recipient_c.`title` AS 'pi_fk_recipient_c__title',
		pi_fk_recipient_c.`vendor_flag` AS 'pi_fk_recipient_c__vendor_flag',
		
		pi_fk_initiator_c.`id` AS 'pi_fk_initiator_c__contact_id',
		pi_fk_initiator_c.`user_company_id` AS 'pi_fk_initiator_c__user_company_id',
		pi_fk_initiator_c.`user_id` AS 'pi_fk_initiator_c__user_id',
		pi_fk_initiator_c.`contact_company_id` AS 'pi_fk_initiator_c__contact_company_id',
		pi_fk_initiator_c.`email` AS 'pi_fk_initiator_c__email',
		pi_fk_initiator_c.`name_prefix` AS 'pi_fk_initiator_c__name_prefix',
		pi_fk_initiator_c.`first_name` AS 'pi_fk_initiator_c__first_name',
		pi_fk_initiator_c.`additional_name` AS 'pi_fk_initiator_c__additional_name',
		pi_fk_initiator_c.`middle_name` AS 'pi_fk_initiator_c__middle_name',
		pi_fk_initiator_c.`last_name` AS 'pi_fk_initiator_c__last_name',
		pi_fk_initiator_c.`name_suffix` AS 'pi_fk_initiator_c__name_suffix',
		pi_fk_initiator_c.`title` AS 'pi_fk_initiator_c__title',
		pi_fk_initiator_c.`vendor_flag` AS 'pi_fk_initiator_c__vendor_flag',
		
		pi_fk_creator_c__fk_cc.`id` AS 'pi_fk_creator_c__fk_cc__contact_company_id',
		pi_fk_creator_c__fk_cc.`user_user_company_id` AS 'pi_fk_creator_c__fk_cc__user_user_company_id',
		pi_fk_creator_c__fk_cc.`contact_user_company_id` AS 'pi_fk_creator_c__fk_cc__contact_user_company_id',
		pi_fk_creator_c__fk_cc.`company` AS 'pi_fk_creator_c__fk_cc__company',
		pi_fk_creator_c__fk_cc.`primary_phone_number` AS 'pi_fk_creator_c__fk_cc__primary_phone_number',
		pi_fk_creator_c__fk_cc.`employer_identification_number` AS 'pi_fk_creator_c__fk_cc__employer_identification_number',
		pi_fk_creator_c__fk_cc.`construction_license_number` AS 'pi_fk_creator_c__fk_cc__construction_license_number',
		pi_fk_creator_c__fk_cc.`construction_license_number_expiration_date` AS 'pi_fk_creator_c__fk_cc__construction_license_number_expiration_date',
		pi_fk_creator_c__fk_cc.`vendor_flag` AS 'pi_fk_creator_c__fk_cc__vendor_flag',

		pi_fk_recipient_c_fk_cc.`id` AS 'pi_fk_recipient_c_fk_cc__contact_company_id',
		pi_fk_recipient_c_fk_cc.`user_user_company_id` AS 'pi_fk_recipient_c_fk_cc__user_user_company_id',
		pi_fk_recipient_c_fk_cc.`contact_user_company_id` AS 'pi_fk_recipient_c_fk_cc__contact_user_company_id',
		pi_fk_recipient_c_fk_cc.`company` AS 'pi_fk_recipient_c_fk_cc__company',
		pi_fk_recipient_c_fk_cc.`primary_phone_number` AS 'pi_fk_recipient_c_fk_cc__primary_phone_number',
		pi_fk_recipient_c_fk_cc.`employer_identification_number` AS 'pi_fk_recipient_c_fk_cc__employer_identification_number',
		pi_fk_recipient_c_fk_cc.`construction_license_number` AS 'pi_fk_recipient_c_fk_cc__construction_license_number',
		pi_fk_recipient_c_fk_cc.`construction_license_number_expiration_date` AS 'pi_fk_recipient_c_fk_cc__construction_license_number_expiration_date',
		pi_fk_recipient_c_fk_cc.`vendor_flag` AS 'pi_fk_recipient_c_fk_cc__vendor_flag',

		pi_fk_initiator_c__fk_cc.`id` AS 'pi_fk_initiator_c__fk_cc__contact_company_id',
		pi_fk_initiator_c__fk_cc.`user_user_company_id` AS 'pi_fk_initiator_c__fk_cc__user_user_company_id',
		pi_fk_initiator_c__fk_cc.`contact_user_company_id` AS 'pi_fk_initiator_c__fk_cc__contact_user_company_id',
		pi_fk_initiator_c__fk_cc.`company` AS 'pi_fk_initiator_c__fk_cc__company',
		pi_fk_initiator_c__fk_cc.`primary_phone_number` AS 'pi_fk_initiator_c__fk_cc__primary_phone_number',
		pi_fk_initiator_c__fk_cc.`employer_identification_number` AS 'pi_fk_initiator_c__fk_cc__employer_identification_number',
		pi_fk_initiator_c__fk_cc.`construction_license_number` AS 'pi_fk_initiator_c__fk_cc__construction_license_number',
		pi_fk_initiator_c__fk_cc.`construction_license_number_expiration_date` AS 'pi_fk_initiator_c__fk_cc__construction_license_number_expiration_date',
		pi_fk_initiator_c__fk_cc.`vendor_flag` AS 'pi_fk_initiator_c__fk_cc__vendor_flag',

		pi_fk_pib.`id` AS 'pi_fk_pib__id',
		pi_fk_pib.`project_id` AS 'pi_fk_pib__project_id',
		pi_fk_pib.`building_name` AS 'pi_fk_pib__building_name',
		pi_fk_pib.`location` AS 'pi_fk_pib__location',

		pi_fk_pibr.`id` AS 'pi_fk_pibr__id',
		pi_fk_pibr.`project_id` AS 'pi_fk_pibr__project_id',
		pi_fk_pibr.`building_id` AS 'pi_fk_pibr__building_id',
		pi_fk_pibr.`room_name` AS 'pi_fk_pibr__room_name',
		pi_fk_pibr.`description` AS 'pi_fk_pibr__description',

		pi_fk_pid.`id` AS 'pi_fk_pid__id',
		pi_fk_pid.`user_company_id` AS 'pi_fk_pid__user_company_id',
		pi_fk_pid.`defect_name` AS 'pi_fk_pid__defect_name',

		pi_fk_codes.`id` AS 'pi_fk_codes__cost_code_id',
		pi_fk_codes.`cost_code_division_id` AS 'pi_fk_codes__cost_code_division_id',
		pi_fk_codes.`cost_code` AS 'pi_fk_codes__cost_code',
		pi_fk_codes.`cost_code_description` AS 'pi_fk_codes__cost_code_description',
		pi_fk_codes.`cost_code_description_abbreviation` AS 'pi_fk_codes__cost_code_description_abbreviation',
		pi_fk_codes.`sort_order` AS 'pi_fk_codes__sort_order',
		pi_fk_codes.`disabled_flag` AS 'pi_fk_codes__disabled_flag',

		CONCAT(pi_fk_code_division.`division_number`,pi_fk_codes.`cost_code`) AS 'concat_costcode',
		pi_fk_code_division.`division_number` AS 'pi_fk_code_division__division_number',

		pi.*

		FROM `punch_item` pi
		INNER JOIN `projects` pi_fk_p ON pi.`project_id` = pi_fk_p.`id`
		INNER JOIN `punch_item_status` pi_fk_pis ON pi.`status_id` = pi_fk_pis.`id`
		INNER JOIN `contacts` pi_fk_creator_c ON pi.`creator_contact_id` = pi_fk_creator_c.`id`
		LEFT OUTER JOIN `file_manager_files` pi_fk_fmfiles ON pi.`file_manager_file_id` = pi_fk_fmfiles.`id`
		LEFT OUTER JOIN `punch_building_data` pi_fk_pib ON pi.`location_id` = pi_fk_pib.`id`
		LEFT OUTER JOIN `punch_room_data` pi_fk_pibr ON pi.`room_id` = pi_fk_pibr.`id`
		LEFT OUTER JOIN `punch_defects` pi_fk_pid ON pi.`description_id` = pi_fk_pid.`id`
		LEFT OUTER JOIN `contacts` pi_fk_recipient_c ON pi.`recipient_contact_id` = pi_fk_recipient_c.`id`		
		LEFT OUTER JOIN `contacts` pi_fk_initiator_c ON pi.`initiator_contact_id` = pi_fk_initiator_c.`id`		
		INNER JOIN `contact_companies` pi_fk_creator_c__fk_cc ON pi_fk_creator_c.`contact_company_id` = pi_fk_creator_c__fk_cc.`id`
		LEFT OUTER JOIN `contact_companies` pi_fk_recipient_c_fk_cc ON pi_fk_recipient_c.`contact_company_id` = pi_fk_recipient_c_fk_cc.`id`
		LEFT OUTER JOIN `contact_companies` pi_fk_initiator_c__fk_cc ON pi_fk_initiator_c.`contact_company_id` = pi_fk_initiator_c__fk_cc.`id`
		LEFT OUTER JOIN `cost_codes` pi_fk_codes ON pi.`cost_code_id` = pi_fk_codes.`id`
		LEFT OUTER JOIN `cost_code_divisions` pi_fk_code_division ON pi_fk_codes.`cost_code_division_id` = pi_fk_code_division.`id`

		WHERE pi.`project_id` = ? {$whereContact} {$sqlOrderBy}
		";
		/*if($draft_flag == 'Y'){
			$arrValues = array($project_id, strVal($draft_flag), strVal($activeContactId));
		} else {*/
			$arrValues = array($project_id);
		/*}*/
		/*print_r($arrValues);*/
		
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrPunchItemByProjectId = array();
		while ($row = $db->fetch()) {
			// PunchItem
			$punch_item_id = $row['id'];
			$punchItem = self::instantiateOrm($database, 'PunchItem', $row, null, $punch_item_id);
			/* @var $punchItem PunchItem */
			$punchItem->convertPropertiesToData();
			//  Project
			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['pi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'pi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$punchItem->setProject($project);
			// PunchItemStatus
			if (isset($row['status_id'])) {
				$punch_item_status_id = $row['status_id'];
				$row['pi_fk_pis__id'] = $punch_item_status_id;
				$punchItemStatus = self::instantiateOrm($database, 'PunchItemStatus', $row, null, $punch_item_status_id, 'pi_fk_pis__');
				/* @var $punchItemStatus PunchItemStatus */
				$punchItemStatus->convertPropertiesToData();
			} else {
				$punchItemStatus = false;
			}
			$punchItem->setPunchItemStatus($punchItemStatus);
			// punch item cost code
			if (isset($row['cost_code_id']) && $row['cost_code_id']) {
				$cost_code_id = $row['cost_code_id'];
				$row['pi_fk_codes__id'] = $cost_code_id;
				$piCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'pi_fk_codes__');
				/* @var $suCostCode CostCode */
				$piCostCode->convertPropertiesToData();
			} else {
				$piCostCode = false;
			}
			$punchItem->setPiCostCode($piCostCode);
			// FileManagerFile
			if (isset($row['file_manager_file_id']) && !empty($row['file_manager_file_id'])) {
				$pi_file_manager_file_id = $row['file_manager_file_id'];
				$row['pi_fk_fmfiles__id'] = $pi_file_manager_file_id;
				$piFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $pi_file_manager_file_id, 'pi_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$piFileManagerFile->convertPropertiesToData();
			} else {
				$piFileManagerFile = false;
			}
			$punchItem->setPiFileManagerFile($piFileManagerFile);
			// PunchItemBuilding
			if (isset($row['pi_fk_pib__id']) && !empty($row['pi_fk_pib__id'])) {
				$pi_building_id = $row['pi_fk_pib__id'];
				$row['pi_fk_pib__id'] = $pi_building_id;
				$piBuilding = self::instantiateOrm($database, 'PunchItemBuilding', $row, null, $pi_building_id, 'pi_fk_pib__');
				/* @var $suFileManagerFile FileManagerFile */
				$piBuilding->convertPropertiesToData();
			} else {
				$piBuilding = false;
			}
			$punchItem->setPiBuilding($piBuilding);
			// PunchItemBuildingRoom
			if (isset($row['pi_fk_pib__id']) && !empty($row['pi_fk_pib__id'])) {
				$pi_building_id = $row['pi_fk_pib__id'];
				$row['pi_fk_pib__id'] = $pi_building_id;
				$piBuilding = self::instantiateOrm($database, 'PunchItemBuilding', $row, null, $pi_building_id, 'pi_fk_pib__');
				/* @var $suFileManagerFile FileManagerFile */
				$piBuilding->convertPropertiesToData();
			} else {
				$piBuilding = false;
			}
			$punchItem->setPiBuilding($piBuilding);
			// PunchItemDefect
			if (isset($row['pi_fk_pid__id']) && !empty($row['pi_fk_pid__id'])) {
				$pi_defect_id = $row['pi_fk_pid__id'];
				$row['pi_fk_pid__id'] = $pi_defect_id;
				$piDefect = self::instantiateOrm($database, 'PunchItemDefect', $row, null, $pi_defect_id, 'pi_fk_pid__');
				/* @var $suFileManagerFile FileManagerFile */
				$piDefect->convertPropertiesToData();
			} else {
				$piDefect = false;
			}
			$punchItem->setPiDefect($piDefect);
			// PunchItemBuildingRoom
			if (isset($row['pi_fk_pibr__id']) && !empty($row['pi_fk_pibr__id'])) {
				$pi_building_room_id = $row['pi_fk_pib__id'];
				$row['pi_fk_pibr__id'] = $pi_building_room_id;
				$piBuildingRoom = self::instantiateOrm($database, 'PunchItemBuildingRoom', $row, null, $pi_building_id, 'pi_fk_pibr__');
				/* @var $suFileManagerFile FileManagerFile */
				$piBuildingRoom->convertPropertiesToData();
			} else {
				$piBuildingRoom = false;
			}
			$punchItem->setPiBuildingRoom($piBuildingRoom);
			// creator contacts
			if (isset($row['creator_contact_id'])) {
				$pi_creator_contact_id = $row['creator_contact_id'];
				$row['pi_fk_creator_c__id'] = $pi_creator_contact_id;
				$piCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $pi_creator_contact_id, 'pi_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$piCreatorContact->convertPropertiesToData();
			} else {
				$piCreatorContact = false;
			}
			$punchItem->setPiCreatorContact($piCreatorContact);			
			// recipient cotact
			if (isset($row['recipient_contact_id'])) {
				$pi_recipient_contact_id = $row['recipient_contact_id'];
				$row['pi_fk_recipient_c__id'] = $pi_recipient_contact_id;
				$piRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $pi_recipient_contact_id, 'pi_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$piRecipientContact->convertPropertiesToData();
			} else {
				$piRecipientContact = false;
			}
			$punchItem->setPiRecipientContact($piRecipientContact);
			// initiator contact
			if (isset($row['initiator_contact_id']) && $row['initiator_contact_id']) {
				$pi_initiator_contact_id = $row['initiator_contact_id'];
				$row['pi_fk_initiator_c__id'] = $pi_initiator_contact_id;
				$piInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $pi_initiator_contact_id, 'pi_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$piInitiatorContact->convertPropertiesToData();
			} else {
				$piInitiatorContact = false;
			}
			$punchItem->setPiInitiatorContact($piInitiatorContact);
			// Extra: PunchItem Creator - Contact Company
			if (isset($row['pi_fk_creator_c__fk_cc__contact_company_id'])) {
				$pi_creator_contact_company_id = $row['pi_fk_creator_c__fk_cc__contact_company_id'];
				$row['pi_fk_creator_c__fk_cc__id'] = $pi_creator_contact_company_id;
				$piCreatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $pi_creator_contact_company_id, 'pi_fk_creator_c__fk_cc__');
				/* @var $suCreatorContactCompany ContactCompany */
				$piCreatorContactCompany->convertPropertiesToData();
			} else {
				$piCreatorContactCompany = false;
			}
			if ($piCreatorContact) {
				$piCreatorContact->setContactCompany($piCreatorContactCompany);
			}

			// Extra: PunchItem Recipient - Contact Company
			if (isset($row['pi_fk_recipient_c_fk_cc__contact_company_id'])) {
				$pi_recipient_contact_company_id = $row['pi_fk_recipient_c_fk_cc__contact_company_id'];
				$row['pi_fk_recipient_c_fk_cc__id'] = $pi_recipient_contact_company_id;
				$piRecipientContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $pi_recipient_contact_company_id, 'pi_fk_recipient_c_fk_cc__');
				/* @var $suRecipientContactCompany ContactCompany */
				$piRecipientContactCompany->convertPropertiesToData();
			} else {
				$piRecipientContactCompany = false;
			}
			if ($piRecipientContact) {
				$piRecipientContact->setContactCompany($piRecipientContactCompany);
			}

			// Extra: PunchItem Initiator - Contact Company
			if (isset($row['pi_fk_initiator_c_fk_cc__contact_company_id'])) {
				$pi_initiator_contact_company_id = $row['pi_fk_initiator_c_fk_cc__contact_company_id'];
				$row['pi_fk_initiator_c_fk_cc__id'] = $pi_initiator_contact_company_id;
				$piInitiatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $pi_initiator_contact_company_id, 'pi_fk_initiator_c_fk_cc__');
				/* @var $suInitiatorContactCompany ContactCompany */
				$piInitiatorContactCompany->convertPropertiesToData();
			} else {
				$piInitiatorContactCompany = false;
			}
			if ($piInitiatorContact) {
				$piInitiatorContact->setContactCompany($piInitiatorContactCompany);
			}
			$arrPunchItemByProjectId[$punch_item_id] = $punchItem;
		}

		$db->free_result();

		self::$_arrPunchItemByProjectId = $arrPunchItemByProjectId;

		return $arrPunchItemByProjectId;

		return $punchItem;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $punch_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadPunchItemByProjectIdForFilter($database, $project_id)
	{
		// $punch_item_id = (int) $punch_item_id;

		$db = DBI::getInstance($database);
		$db->begin();
		$db->free_result();
		/* @var $db DBI_mysqli */
		$sqlOrderBy = "\nORDER BY pi_fk_recipient_c_fk_cc.`company` ASC,  pi.`sequence_number` DESC";
		
		$query =
		"
		SELECT
		CONCAT(pi_fk_code_division.`division_number`,pi_fk_codes.`cost_code`) AS 'concat_costcode',
		CONCAT(pi.`recipient_contact_company_id`,pi.`sequence_number`) AS 'subsquence_order',
		pi_fk_code_division.`division_number` AS 'su_fk_code_division__division_number',

		pi_fk_p.`id` AS 'pi_fk_p__project_id',
		pi_fk_p.`project_type_id` AS 'pi_fk_p__project_type_id',
		pi_fk_p.`user_company_id` AS 'pi_fk_p__user_company_id',
		pi_fk_p.`user_custom_project_id` AS 'pi_fk_p__user_custom_project_id',
		pi_fk_p.`project_name` AS 'pi_fk_p__project_name',
		pi_fk_p.`project_owner_name` AS 'pi_fk_p__project_owner_name',
		pi_fk_p.`latitude` AS 'pi_fk_p__latitude',
		pi_fk_p.`longitude` AS 'pi_fk_p__longitude',
		pi_fk_p.`address_line_1` AS 'pi_fk_p__address_line_1',
		pi_fk_p.`address_line_2` AS 'pi_fk_p__address_line_2',
		pi_fk_p.`address_line_3` AS 'pi_fk_p__address_line_3',
		pi_fk_p.`address_line_4` AS 'pi_fk_p__address_line_4',
		pi_fk_p.`address_city` AS 'pi_fk_p__address_city',
		pi_fk_p.`address_county` AS 'pi_fk_p__address_county',
		pi_fk_p.`address_state_or_region` AS 'pi_fk_p__address_state_or_region',
		pi_fk_p.`address_postal_code` AS 'pi_fk_p__address_postal_code',
		pi_fk_p.`address_postal_code_extension` AS 'pi_fk_p__address_postal_code_extension',
		pi_fk_p.`address_country` AS 'pi_fk_p__address_country',
		pi_fk_p.`building_count` AS 'pi_fk_p__building_count',
		pi_fk_p.`unit_count` AS 'pi_fk_p__unit_count',
		pi_fk_p.`gross_square_footage` AS 'pi_fk_p__gross_square_footage',
		pi_fk_p.`net_rentable_square_footage` AS 'pi_fk_p__net_rentable_square_footage',
		pi_fk_p.`is_active_flag` AS 'pi_fk_p__is_active_flag',
		pi_fk_p.`public_plans_flag` AS 'pi_fk_p__public_plans_flag',
		pi_fk_p.`prevailing_wage_flag` AS 'pi_fk_p__prevailing_wage_flag',
		pi_fk_p.`city_business_license_required_flag` AS 'pi_fk_p__city_business_license_required_flag',
		pi_fk_p.`is_internal_flag` AS 'pi_fk_p__is_internal_flag',
		pi_fk_p.`project_contract_date` AS 'pi_fk_p__project_contract_date',
		pi_fk_p.`project_start_date` AS 'pi_fk_p__project_start_date',
		pi_fk_p.`project_completed_date` AS 'pi_fk_p__project_completed_date',
		pi_fk_p.`sort_order` AS 'pi_fk_p__sort_order',

		pi_fk_fmfiles.`id` AS 'pi_fk_fmfiles__file_manager_file_id',
		pi_fk_fmfiles.`user_company_id` AS 'pi_fk_fmfiles__user_company_id',
		pi_fk_fmfiles.`contact_id` AS 'pi_fk_fmfiles__contact_id',
		pi_fk_fmfiles.`project_id` AS 'pi_fk_fmfiles__project_id',
		pi_fk_fmfiles.`file_manager_folder_id` AS 'pi_fk_fmfiles__file_manager_folder_id',
		pi_fk_fmfiles.`file_location_id` AS 'pi_fk_fmfiles__file_location_id',
		pi_fk_fmfiles.`virtual_file_name` AS 'pi_fk_fmfiles__virtual_file_name',
		pi_fk_fmfiles.`version_number` AS 'pi_fk_fmfiles__version_number',
		pi_fk_fmfiles.`virtual_file_name_sha1` AS 'pi_fk_fmfiles__virtual_file_name_sha1',
		pi_fk_fmfiles.`virtual_file_mime_type` AS 'pi_fk_fmfiles__virtual_file_mime_type',
		pi_fk_fmfiles.`modified` AS 'pi_fk_fmfiles__modified',
		pi_fk_fmfiles.`created` AS 'pi_fk_fmfiles__created',
		pi_fk_fmfiles.`deleted_flag` AS 'pi_fk_fmfiles__deleted_flag',
		pi_fk_fmfiles.`directly_deleted_flag` AS 'pi_fk_fmfiles__directly_deleted_flag',

		pi_fk_creator_c.`id` AS 'pi_fk_creator_c__contact_id',
		pi_fk_creator_c.`user_company_id` AS 'pi_fk_creator_c__user_company_id',
		pi_fk_creator_c.`user_id` AS 'pi_fk_creator_c__user_id',
		pi_fk_creator_c.`contact_company_id` AS 'pi_fk_creator_c__contact_company_id',
		pi_fk_creator_c.`email` AS 'pi_fk_creator_c__email',
		pi_fk_creator_c.`name_prefix` AS 'pi_fk_creator_c__name_prefix',
		pi_fk_creator_c.`first_name` AS 'pi_fk_creator_c__first_name',
		pi_fk_creator_c.`additional_name` AS 'pi_fk_creator_c__additional_name',
		pi_fk_creator_c.`middle_name` AS 'pi_fk_creator_c__middle_name',
		pi_fk_creator_c.`last_name` AS 'pi_fk_creator_c__last_name',
		pi_fk_creator_c.`name_suffix` AS 'pi_fk_creator_c__name_suffix',
		pi_fk_creator_c.`title` AS 'pi_fk_creator_c__title',
		pi_fk_creator_c.`vendor_flag` AS 'pi_fk_creator_c__vendor_flag',

		pi_fk_pis.`id` AS 'pi_fk_pis__status_id',
		pi_fk_pis.`punch_item_status` AS 'pi_fk_pis__punch_item_status',
		pi_fk_pis.`disabled_flag` AS 'pi_fk_pis__disabled_flag',

		pi_fk_recipient_c.`id` AS 'pi_fk_recipient_c__contact_id',
		pi_fk_recipient_c.`user_company_id` AS 'pi_fk_recipient_c__user_company_id',
		pi_fk_recipient_c.`user_id` AS 'pi_fk_recipient_c__user_id',
		pi_fk_recipient_c.`contact_company_id` AS 'pi_fk_recipient_c__contact_company_id',
		pi_fk_recipient_c.`email` AS 'pi_fk_recipient_c__email',
		pi_fk_recipient_c.`name_prefix` AS 'pi_fk_recipient_c__name_prefix',
		pi_fk_recipient_c.`first_name` AS 'pi_fk_recipient_c__first_name',
		pi_fk_recipient_c.`additional_name` AS 'pi_fk_recipient_c__additional_name',
		pi_fk_recipient_c.`middle_name` AS 'pi_fk_recipient_c__middle_name',
		pi_fk_recipient_c.`last_name` AS 'pi_fk_recipient_c__last_name',
		pi_fk_recipient_c.`name_suffix` AS 'pi_fk_recipient_c__name_suffix',
		pi_fk_recipient_c.`title` AS 'pi_fk_recipient_c__title',
		pi_fk_recipient_c.`vendor_flag` AS 'pi_fk_recipient_c__vendor_flag',
		
		pi_fk_initiator_c.`id` AS 'pi_fk_initiator_c__contact_id',
		pi_fk_initiator_c.`user_company_id` AS 'pi_fk_initiator_c__user_company_id',
		pi_fk_initiator_c.`user_id` AS 'pi_fk_initiator_c__user_id',
		pi_fk_initiator_c.`contact_company_id` AS 'pi_fk_initiator_c__contact_company_id',
		pi_fk_initiator_c.`email` AS 'pi_fk_initiator_c__email',
		pi_fk_initiator_c.`name_prefix` AS 'pi_fk_initiator_c__name_prefix',
		pi_fk_initiator_c.`first_name` AS 'pi_fk_initiator_c__first_name',
		pi_fk_initiator_c.`additional_name` AS 'pi_fk_initiator_c__additional_name',
		pi_fk_initiator_c.`middle_name` AS 'pi_fk_initiator_c__middle_name',
		pi_fk_initiator_c.`last_name` AS 'pi_fk_initiator_c__last_name',
		pi_fk_initiator_c.`name_suffix` AS 'pi_fk_initiator_c__name_suffix',
		pi_fk_initiator_c.`title` AS 'pi_fk_initiator_c__title',
		pi_fk_initiator_c.`vendor_flag` AS 'pi_fk_initiator_c__vendor_flag',
		
		pi_fk_creator_c__fk_cc.`id` AS 'pi_fk_creator_c__fk_cc__contact_company_id',
		pi_fk_creator_c__fk_cc.`user_user_company_id` AS 'pi_fk_creator_c__fk_cc__user_user_company_id',
		pi_fk_creator_c__fk_cc.`contact_user_company_id` AS 'pi_fk_creator_c__fk_cc__contact_user_company_id',
		pi_fk_creator_c__fk_cc.`company` AS 'pi_fk_creator_c__fk_cc__company',
		pi_fk_creator_c__fk_cc.`primary_phone_number` AS 'pi_fk_creator_c__fk_cc__primary_phone_number',
		pi_fk_creator_c__fk_cc.`employer_identification_number` AS 'pi_fk_creator_c__fk_cc__employer_identification_number',
		pi_fk_creator_c__fk_cc.`construction_license_number` AS 'pi_fk_creator_c__fk_cc__construction_license_number',
		pi_fk_creator_c__fk_cc.`construction_license_number_expiration_date` AS 'pi_fk_creator_c__fk_cc__construction_license_number_expiration_date',
		pi_fk_creator_c__fk_cc.`vendor_flag` AS 'pi_fk_creator_c__fk_cc__vendor_flag',

		pi_fk_recipient_c_fk_cc.`id` AS 'pi_fk_recipient_c_fk_cc__contact_company_id',
		pi_fk_recipient_c_fk_cc.`user_user_company_id` AS 'pi_fk_recipient_c_fk_cc__user_user_company_id',
		pi_fk_recipient_c_fk_cc.`contact_user_company_id` AS 'pi_fk_recipient_c_fk_cc__contact_user_company_id',
		pi_fk_recipient_c_fk_cc.`company` AS 'pi_fk_recipient_c_fk_cc__company',
		pi_fk_recipient_c_fk_cc.`primary_phone_number` AS 'pi_fk_recipient_c_fk_cc__primary_phone_number',
		pi_fk_recipient_c_fk_cc.`employer_identification_number` AS 'pi_fk_recipient_c_fk_cc__employer_identification_number',
		pi_fk_recipient_c_fk_cc.`construction_license_number` AS 'pi_fk_recipient_c_fk_cc__construction_license_number',
		pi_fk_recipient_c_fk_cc.`construction_license_number_expiration_date` AS 'pi_fk_recipient_c_fk_cc__construction_license_number_expiration_date',
		pi_fk_recipient_c_fk_cc.`vendor_flag` AS 'pi_fk_recipient_c_fk_cc__vendor_flag',

		pi_fk_initiator_c__fk_cc.`id` AS 'pi_fk_initiator_c__fk_cc__contact_company_id',
		pi_fk_initiator_c__fk_cc.`user_user_company_id` AS 'pi_fk_initiator_c__fk_cc__user_user_company_id',
		pi_fk_initiator_c__fk_cc.`contact_user_company_id` AS 'pi_fk_initiator_c__fk_cc__contact_user_company_id',
		pi_fk_initiator_c__fk_cc.`company` AS 'pi_fk_initiator_c__fk_cc__company',
		pi_fk_initiator_c__fk_cc.`primary_phone_number` AS 'pi_fk_initiator_c__fk_cc__primary_phone_number',
		pi_fk_initiator_c__fk_cc.`employer_identification_number` AS 'pi_fk_initiator_c__fk_cc__employer_identification_number',
		pi_fk_initiator_c__fk_cc.`construction_license_number` AS 'pi_fk_initiator_c__fk_cc__construction_license_number',
		pi_fk_initiator_c__fk_cc.`construction_license_number_expiration_date` AS 'pi_fk_initiator_c__fk_cc__construction_license_number_expiration_date',
		pi_fk_initiator_c__fk_cc.`vendor_flag` AS 'pi_fk_initiator_c__fk_cc__vendor_flag',

		pi_fk_pib.`id` AS 'pi_fk_pib__id',
		pi_fk_pib.`project_id` AS 'pi_fk_pib__project_id',
		pi_fk_pib.`building_name` AS 'pi_fk_pib__building_name',
		pi_fk_pib.`location` AS 'pi_fk_pib__location',

		pi_fk_pibr.`id` AS 'pi_fk_pibr__id',
		pi_fk_pibr.`project_id` AS 'pi_fk_pibr__project_id',
		pi_fk_pibr.`building_id` AS 'pi_fk_pibr__building_id',
		pi_fk_pibr.`room_name` AS 'pi_fk_pibr__room_name',
		pi_fk_pibr.`description` AS 'pi_fk_pibr__description',

		pi_fk_pid.`id` AS 'pi_fk_pid__id',
		pi_fk_pid.`user_company_id` AS 'pi_fk_pid__user_company_id',
		pi_fk_pid.`defect_name` AS 'pi_fk_pid__defect_name',

		pi_fk_codes.`id` AS 'pi_fk_codes__cost_code_id',
		pi_fk_codes.`cost_code_division_id` AS 'pi_fk_codes__cost_code_division_id',
		pi_fk_codes.`cost_code` AS 'pi_fk_codes__cost_code',
		pi_fk_codes.`cost_code_description` AS 'pi_fk_codes__cost_code_description',
		pi_fk_codes.`cost_code_description_abbreviation` AS 'pi_fk_codes__cost_code_description_abbreviation',
		pi_fk_codes.`sort_order` AS 'pi_fk_codes__sort_order',
		pi_fk_codes.`disabled_flag` AS 'pi_fk_codes__disabled_flag',

		CONCAT(pi_fk_code_division.`division_number`,pi_fk_codes.`cost_code`) AS 'concat_costcode',
		pi_fk_code_division.`division_number` AS 'pi_fk_code_division__division_number',

		pi.*

		FROM `punch_item` pi
		INNER JOIN `projects` pi_fk_p ON pi.`project_id` = pi_fk_p.`id`
		INNER JOIN `punch_item_status` pi_fk_pis ON pi.`status_id` = pi_fk_pis.`id`
		INNER JOIN `contacts` pi_fk_creator_c ON pi.`creator_contact_id` = pi_fk_creator_c.`id`
		LEFT OUTER JOIN `file_manager_files` pi_fk_fmfiles ON pi.`file_manager_file_id` = pi_fk_fmfiles.`id`
		LEFT OUTER JOIN `punch_building_data` pi_fk_pib ON pi.`location_id` = pi_fk_pib.`id`
		LEFT OUTER JOIN `punch_room_data` pi_fk_pibr ON pi.`room_id` = pi_fk_pibr.`id`
		LEFT OUTER JOIN `punch_defects` pi_fk_pid ON pi.`description_id` = pi_fk_pid.`id`
		LEFT OUTER JOIN `contacts` pi_fk_recipient_c ON pi.`recipient_contact_id` = pi_fk_recipient_c.`id`		
		LEFT OUTER JOIN `contacts` pi_fk_initiator_c ON pi.`initiator_contact_id` = pi_fk_initiator_c.`id`		
		INNER JOIN `contact_companies` pi_fk_creator_c__fk_cc ON pi_fk_creator_c.`contact_company_id` = pi_fk_creator_c__fk_cc.`id`
		LEFT OUTER JOIN `contact_companies` pi_fk_recipient_c_fk_cc ON pi_fk_recipient_c.`contact_company_id` = pi_fk_recipient_c_fk_cc.`id`
		LEFT OUTER JOIN `contact_companies` pi_fk_initiator_c__fk_cc ON pi_fk_initiator_c.`contact_company_id` = pi_fk_initiator_c__fk_cc.`id`
		LEFT OUTER JOIN `cost_codes` pi_fk_codes ON pi.`cost_code_id` = pi_fk_codes.`id`
		LEFT OUTER JOIN `cost_code_divisions` pi_fk_code_division ON pi_fk_codes.`cost_code_division_id` = pi_fk_code_division.`id`

		WHERE pi.`project_id` = ? {$sqlOrderBy}
		";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrPunchItemByProjectId = array();
		while ($row = $db->fetch()) {
			// PunchItem
			$punch_item_id = $row['id'];
			$punchItem = self::instantiateOrm($database, 'PunchItem', $row, null, $punch_item_id);
			/* @var $punchItem PunchItem */
			$punchItem->convertPropertiesToData();
			//  Project
			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['pi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'pi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$punchItem->setProject($project);
			// PunchItemStatus
			if (isset($row['status_id'])) {
				$punch_item_status_id = $row['status_id'];
				$row['pi_fk_pis__id'] = $punch_item_status_id;
				$punchItemStatus = self::instantiateOrm($database, 'PunchItemStatus', $row, null, $punch_item_status_id, 'pi_fk_pis__');
				/* @var $punchItemStatus PunchItemStatus */
				$punchItemStatus->convertPropertiesToData();
			} else {
				$punchItemStatus = false;
			}
			$punchItem->setPunchItemStatus($punchItemStatus);
			// punch item cost code
			if (isset($row['cost_code_id']) && $row['cost_code_id']) {
				$cost_code_id = $row['cost_code_id'];
				$row['pi_fk_codes__id'] = $cost_code_id;
				$piCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'pi_fk_codes__');
				/* @var $suCostCode CostCode */
				$piCostCode->convertPropertiesToData();
			} else {
				$piCostCode = false;
			}
			$punchItem->setPiCostCode($piCostCode);
			// FileManagerFile
			if (isset($row['file_manager_file_id']) && !empty($row['file_manager_file_id'])) {
				$pi_file_manager_file_id = $row['file_manager_file_id'];
				$row['pi_fk_fmfiles__id'] = $pi_file_manager_file_id;
				$piFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $pi_file_manager_file_id, 'pi_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$piFileManagerFile->convertPropertiesToData();
			} else {
				$piFileManagerFile = false;
			}
			$punchItem->setPiFileManagerFile($piFileManagerFile);
			// PunchItemBuilding
			if (isset($row['pi_fk_pib__id']) && !empty($row['pi_fk_pib__id'])) {
				$pi_building_id = $row['pi_fk_pib__id'];
				$row['pi_fk_pib__id'] = $pi_building_id;
				$piBuilding = self::instantiateOrm($database, 'PunchItemBuilding', $row, null, $pi_building_id, 'pi_fk_pib__');
				/* @var $suFileManagerFile FileManagerFile */
				$piBuilding->convertPropertiesToData();
			} else {
				$piBuilding = false;
			}
			$punchItem->setPiBuilding($piBuilding);
			// PunchItemBuildingRoom
			if (isset($row['pi_fk_pib__id']) && !empty($row['pi_fk_pib__id'])) {
				$pi_building_id = $row['pi_fk_pib__id'];
				$row['pi_fk_pib__id'] = $pi_building_id;
				$piBuilding = self::instantiateOrm($database, 'PunchItemBuilding', $row, null, $pi_building_id, 'pi_fk_pib__');
				/* @var $suFileManagerFile FileManagerFile */
				$piBuilding->convertPropertiesToData();
			} else {
				$piBuilding = false;
			}
			$punchItem->setPiBuilding($piBuilding);
			// PunchItemDefect
			if (isset($row['pi_fk_pid__id']) && !empty($row['pi_fk_pid__id'])) {
				$pi_defect_id = $row['pi_fk_pid__id'];
				$row['pi_fk_pid__id'] = $pi_defect_id;
				$piDefect = self::instantiateOrm($database, 'PunchItemDefect', $row, null, $pi_defect_id, 'pi_fk_pid__');
				/* @var $suFileManagerFile FileManagerFile */
				$piDefect->convertPropertiesToData();
			} else {
				$piDefect = false;
			}
			$punchItem->setPiDefect($piDefect);
			// PunchItemBuildingRoom
			if (isset($row['pi_fk_pibr__id']) && !empty($row['pi_fk_pibr__id'])) {
				$pi_building_room_id = $row['pi_fk_pib__id'];
				$row['pi_fk_pibr__id'] = $pi_building_room_id;
				$piBuildingRoom = self::instantiateOrm($database, 'PunchItemBuildingRoom', $row, null, $pi_building_id, 'pi_fk_pibr__');
				/* @var $suFileManagerFile FileManagerFile */
				$piBuildingRoom->convertPropertiesToData();
			} else {
				$piBuildingRoom = false;
			}
			$punchItem->setPiBuildingRoom($piBuildingRoom);
			// creator contacts
			if (isset($row['creator_contact_id'])) {
				$pi_creator_contact_id = $row['creator_contact_id'];
				$row['pi_fk_creator_c__id'] = $pi_creator_contact_id;
				$piCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $pi_creator_contact_id, 'pi_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$piCreatorContact->convertPropertiesToData();
			} else {
				$piCreatorContact = false;
			}
			$punchItem->setPiCreatorContact($piCreatorContact);			
			// recipient cotact
			if (isset($row['recipient_contact_id'])) {
				$pi_recipient_contact_id = $row['recipient_contact_id'];
				$row['pi_fk_recipient_c__id'] = $pi_recipient_contact_id;
				$piRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $pi_recipient_contact_id, 'pi_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$piRecipientContact->convertPropertiesToData();
			} else {
				$piRecipientContact = false;
			}
			$punchItem->setPiRecipientContact($piRecipientContact);
			// initiator contact
			if (isset($row['initiator_contact_id']) && $row['initiator_contact_id']) {
				$pi_initiator_contact_id = $row['initiator_contact_id'];
				$row['pi_fk_initiator_c__id'] = $pi_initiator_contact_id;
				$piInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $pi_initiator_contact_id, 'pi_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$piInitiatorContact->convertPropertiesToData();
			} else {
				$piInitiatorContact = false;
			}
			$punchItem->setPiInitiatorContact($piInitiatorContact);
			// Extra: PunchItem Creator - Contact Company
			if (isset($row['pi_fk_creator_c__fk_cc__contact_company_id'])) {
				$pi_creator_contact_company_id = $row['pi_fk_creator_c__fk_cc__contact_company_id'];
				$row['pi_fk_creator_c__fk_cc__id'] = $pi_creator_contact_company_id;
				$piCreatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $pi_creator_contact_company_id, 'pi_fk_creator_c__fk_cc__');
				/* @var $suCreatorContactCompany ContactCompany */
				$piCreatorContactCompany->convertPropertiesToData();
			} else {
				$piCreatorContactCompany = false;
			}
			if ($piCreatorContact) {
				$piCreatorContact->setContactCompany($piCreatorContactCompany);
			}

			// Extra: PunchItem Recipient - Contact Company
			if (isset($row['pi_fk_recipient_c_fk_cc__contact_company_id'])) {
				$pi_recipient_contact_company_id = $row['pi_fk_recipient_c_fk_cc__contact_company_id'];
				$row['pi_fk_recipient_c_fk_cc__id'] = $pi_recipient_contact_company_id;
				$piRecipientContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $pi_recipient_contact_company_id, 'pi_fk_recipient_c_fk_cc__');
				/* @var $suRecipientContactCompany ContactCompany */
				$piRecipientContactCompany->convertPropertiesToData();
			} else {
				$piRecipientContactCompany = false;
			}
			if ($piRecipientContact) {
				$piRecipientContact->setContactCompany($piRecipientContactCompany);
			}

			// Extra: PunchItem Initiator - Contact Company
			if (isset($row['pi_fk_initiator_c_fk_cc__contact_company_id'])) {
				$pi_initiator_contact_company_id = $row['pi_fk_initiator_c_fk_cc__contact_company_id'];
				$row['pi_fk_initiator_c_fk_cc__id'] = $pi_initiator_contact_company_id;
				$piInitiatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $pi_initiator_contact_company_id, 'pi_fk_initiator_c_fk_cc__');
				/* @var $suInitiatorContactCompany ContactCompany */
				$piInitiatorContactCompany->convertPropertiesToData();
			} else {
				$piInitiatorContactCompany = false;
			}
			if ($piInitiatorContact) {
				$piInitiatorContact->setContactCompany($piInitiatorContactCompany);
			}
			$arrPunchItemByProjectId[$punch_item_id] = $punchItem;
		}

		$db->free_result();

		self::$_arrPunchItemByProjectId = $arrPunchItemByProjectId;

		return $arrPunchItemByProjectId;

		return $punchItem;
	}
	/**
	 * Find recipient_id value.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findLastPunchItemRecipientByContactId($database, $project_id, $contact_id)
	{
		$recipeient_contact_id = null;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT recipient_contact_id AS 'recipient_contact_id'
		FROM `punch_item` pi
		WHERE pi.`project_id` = ? AND pi.`creator_contact_id` = ?  ORDER BY id DESC
		";
		$arrValues = array($project_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$recipeient_contact_id = $row['recipient_contact_id'];
		}

		return $recipeient_contact_id;
	}
	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $punch_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadPunchItemByProjectIdWithCostCodeSubcontractor($database, $project_id, $draft_flag = 'N', $activeContactId, $whereSuCost = false, $costcode_id, $recipient_contact_id)
	{
		// $punch_item_id = (int) $punch_item_id;

		$db = DBI::getInstance($database);
		$db->begin();
		$db->free_result();
		/* @var $db DBI_mysqli */
		$sqlOrderBy = "\nORDER BY pi.`id` DESC ";
		$whereContact = '';
		$whereContact = 'AND pi.`draft_flag` = \''.$draft_flag.'\'';
		if($draft_flag == 'Y'){
			$whereContact='AND pi.`draft_flag` = \''.$draft_flag.'\' AND pi.`creator_contact_id` = \''.$activeContactId.'\'';
		}
		if($whereSuCost){
			$whereContact.=' AND pi.`cost_code_id` = \''.$costcode_id.'\' AND pi.`recipient_contact_id` = \''.$recipient_contact_id.'\'';
		}

		$query =
		"
		SELECT pi.*
		FROM `punch_item` pi
		WHERE pi.`project_id` = ? {$whereContact} {$sqlOrderBy}
		";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrPunchItemByProjectId = array();
		while ($row = $db->fetch()) {
			// PunchItem
			$punch_item_id = $row['id'];
			$arrPunchItemByProjectId[] = $punch_item_id;
		}
		return $arrPunchItemByProjectId;
	}
	/**
	 * Find building and room id value.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findLastPunchItemBuildingAndRoomByContactId($database, $project_id, $contact_id, $field)
	{
		$return_id = null;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT $field AS 'return_id'
		FROM `punch_item` pi
		WHERE pi.`project_id` = ? AND pi.`creator_contact_id` = ?  ORDER BY id DESC
		";
		$arrValues = array($project_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$return_id = $row['return_id'];
		}

		return $return_id;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
