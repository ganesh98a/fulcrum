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
 * PunchItemAttachment.
 *
 * @category   Framework
 * @package    PunchItemAttachment
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class PunchItemAttachment extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'PunchItemAttachment';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'punch_item_attachments';

	/**
	 * primary key (`punch_item_id`,`pi_attachment_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'punch_item_id' => 'int',
		'pi_attachment_file_manager_file_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_PunchItem_attachment_via_primary_key' => array(
			'punch_item_id' => 'int',
			'pi_attachment_file_manager_file_id' => 'int'
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
		'punch_item_id' => 'punch_item_id',
		'pi_attachment_file_manager_file_id' => 'pi_attachment_file_manager_file_id',
		'pi_attachment_source_contact_id' => 'pi_attachment_source_contact_id',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $punch_item_id;
	public $pi_attachment_file_manager_file_id;

	public $pi_attachment_source_contact_id;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrPunchItemAttachmentsByPunchItemId;
	protected static $_arrPunchItemAttachmentsByPiAttachmentFileManagerFileId;
	protected static $_arrPunchItemAttachmentsByPiAttachmentSourceContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllPunchItemAttachments;
	private $_punchItem;
	private $_piAttachmentFileManagerFile;
	private $_piAttachmentSourceContact;
	/**
	 * Constructor
	 */
	public function __construct($database, $table='punch_item_attachments')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	public function setPunchItem($punchItem)
	{
		$this->_punchItem = $punchItem;
	}

	public function getPiAttachmentFileManagerFile()
	{
		if (isset($this->_piAttachmentFileManagerFile)) {
			return $this->_piAttachmentFileManagerFile;
		} else {
			return null;
		}
	}

	public function setPiAttachmentFileManagerFile($piAttachmentFileManagerFile)
	{
		$this->_piAttachmentFileManagerFile = $piAttachmentFileManagerFile;
	}

	public function setPiAttachmentSourceContact($piAttachmentSourceContact)
	{
		$this->_piAttachmentSourceContact = $piAttachmentSourceContact;
	}

	public static function setArrPunchItemAttachmentsByPunchItemId($arrPunchItemAttachmentsByPunchItemId)
	{
		self::$_arrPunchItemAttachmentsByPunchItemId = $arrPunchItemAttachmentsByPunchItemId;
	}
	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`punch_item_id`,`pi_attachment_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $punch_item_id
	 * @param int $pi_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByPunchItemIdAndPunchItemAttachmentFileManagerFileId($database, $punch_item_id, $pi_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pia.*

FROM `punch_item_attachments` pia
WHERE pia.`punch_item_id` = ?
AND pia.`pi_attachment_file_manager_file_id` = ?
";
		$arrValues = array($punch_item_id, $pi_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$punchItemAttachment = self::instantiateOrm($database, 'PunchItemAttachment', $row);
			/* @var $punchItemAttachment PunchItemAttachment */
			return $punchItemAttachment;
		} else {
			return false;
		}
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`punch_item_id`).
	 *
	 * @param string $database
	 * @param int $punch_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findPunchItemAttachmentByPunchItemId($database, $punch_item_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pia.*
FROM `punch_item_attachments` pia
WHERE pia.`punch_item_id` = ?
";
		$arrValues = array($punch_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrPunchItemAttachment = array();
		while($row = $db->fetch()){
			if ($row && !empty($row)) {
				$arrPunchItemAttachment[] = $row['pi_attachment_file_manager_file_id'];
			}
		}
		$db->free_result();
		return $arrPunchItemAttachment;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `punch_item_attachments_fk_pi` foreign key (`punch_item_id`) references `punch_item` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $punch_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadPunchItemAttachmentsByPunchItemId($database, $punch_item_id, Input $options=null)
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
			self::$_arrPunchItemAttachmentsByPunchItemId = null;
		}

		$arrPunchItemAttachmentsByPunchItemId = self::$_arrPunchItemAttachmentsByPunchItemId;
		if (isset($arrPunchItemAttachmentsByPunchItemId) && !empty($arrPunchItemAttachmentsByPunchItemId)) {
			return $arrPunchItemAttachmentsByPunchItemId;
		}

		$punch_item_id = (int) $punch_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `punch_item_id` ASC, `pi_attachment_file_manager_file_id` ASC, `pi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sua.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpPunchItemAttachment = new PunchItemAttachment($database);
			$sqlOrderByColumns = $tmpPunchItemAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
		$filter="";
		$query =
"
SELECT

	pia_fk_pi.`id` AS 'pia_fk_pi__punch_item_id',
	pia_fk_pi.`project_id` AS 'pia_fk_pi__project_id',
	pia_fk_pi.`sequence_number` AS 'pia_fk_pi__sequence_number',
	pia_fk_pi.`location_id` AS 'pia_fk_pi__location_id',
	pia_fk_pi.`room_id` AS 'pia_fk_pi__room_id',
	pia_fk_pi.`description_id` AS 'pia_fk_pi__description_id',
	pia_fk_pi.`description` AS 'pia_fk_pi__description',
	pia_fk_pi.`status_id` AS 'pia_fk_pi__status_id',
	pia_fk_pi.`file_manager_file_id` AS 'pia_fk_pi__file_manager_file_id',
	pia_fk_pi.`creator_contact_id` AS 'pia_fk_pi__creator_contact_id',
	pia_fk_pi.`creator_contact_company_id` AS 'pia_fk_pi__creator_contact_company_id',
	pia_fk_pi.`initiator_contact_id` AS 'pia_fk_pi__initiator_contact_id',
	pia_fk_pi.`initiator_contact_company_id` AS 'pia_fk_pi__initiator_contact_company_id',
	pia_fk_pi.`recipient_contact_id` AS 'pia_fk_pi__recipient_contact_id',
	pia_fk_pi.`recipient_contact_company_id` AS 'pia_fk_pi__recipient_contact_company_id',
	pia_fk_pi.`description_txt` AS 'pia_fk_pi__description_txt',
	pia_fk_pi.`created_date` AS 'pia_fk_pi__created_date',
	pia_fk_pi.`updated_date` AS 'pia_fk_pi__updated_date',

	pia_fk_fmfiles.`id` AS 'pia_fk_fmfiles__file_manager_file_id',
	pia_fk_fmfiles.`user_company_id` AS 'pia_fk_fmfiles__user_company_id',
	pia_fk_fmfiles.`contact_id` AS 'pia_fk_fmfiles__contact_id',
	pia_fk_fmfiles.`project_id` AS 'pia_fk_fmfiles__project_id',
	pia_fk_fmfiles.`file_manager_folder_id` AS 'pia_fk_fmfiles__file_manager_folder_id',
	pia_fk_fmfiles.`file_location_id` AS 'pia_fk_fmfiles__file_location_id',
	pia_fk_fmfiles.`virtual_file_name` AS 'pia_fk_fmfiles__virtual_file_name',
	pia_fk_fmfiles.`version_number` AS 'pia_fk_fmfiles__version_number',
	pia_fk_fmfiles.`virtual_file_name_sha1` AS 'pia_fk_fmfiles__virtual_file_name_sha1',
	pia_fk_fmfiles.`virtual_file_mime_type` AS 'pia_fk_fmfiles__virtual_file_mime_type',
	pia_fk_fmfiles.`modified` AS 'pia_fk_fmfiles__modified',
	pia_fk_fmfiles.`created` AS 'pia_fk_fmfiles__created',
	pia_fk_fmfiles.`deleted_flag` AS 'pia_fk_fmfiles__deleted_flag',
	pia_fk_fmfiles.`directly_deleted_flag` AS 'pia_fk_fmfiles__directly_deleted_flag',

	pia_fk_pia_source_c.`id` AS 'pia_fk_pia_source_c__contact_id',
	pia_fk_pia_source_c.`user_company_id` AS 'pia_fk_pia_source_c__user_company_id',
	pia_fk_pia_source_c.`user_id` AS 'pia_fk_pia_source_c__user_id',
	pia_fk_pia_source_c.`contact_company_id` AS 'pia_fk_pia_source_c__contact_company_id',
	pia_fk_pia_source_c.`email` AS 'pia_fk_pia_source_c__email',
	pia_fk_pia_source_c.`name_prefix` AS 'pia_fk_pia_source_c__name_prefix',
	pia_fk_pia_source_c.`first_name` AS 'pia_fk_pia_source_c__first_name',
	pia_fk_pia_source_c.`additional_name` AS 'pia_fk_pia_source_c__additional_name',
	pia_fk_pia_source_c.`middle_name` AS 'pia_fk_pia_source_c__middle_name',
	pia_fk_pia_source_c.`last_name` AS 'pia_fk_pia_source_c__last_name',
	pia_fk_pia_source_c.`name_suffix` AS 'pia_fk_pia_source_c__name_suffix',
	pia_fk_pia_source_c.`title` AS 'pia_fk_pia_source_c__title',
	pia_fk_pia_source_c.`vendor_flag` AS 'pia_fk_pia_source_c__vendor_flag',

	sua.*

FROM `punch_item_attachments` sua
	INNER JOIN `punch_item` pia_fk_pi ON sua.`punch_item_id` = pia_fk_pi.`id`
	INNER JOIN `file_manager_files` pia_fk_fmfiles ON sua.`pi_attachment_file_manager_file_id` = pia_fk_fmfiles.`id`
	INNER JOIN `contacts` pia_fk_pia_source_c ON sua.`pi_attachment_source_contact_id` = pia_fk_pia_source_c.`id`
WHERE sua.`punch_item_id` = ? {$filter} {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `punch_item_id` ASC, `pi_attachment_file_manager_file_id` ASC, `pi_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($punch_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrPunchItemAttachmentsByPunchItemId = array();
		while ($row = $db->fetch()) {
			$punchItemAttachment = self::instantiateOrm($database, 'PunchItemAttachment', $row);
			/* @var $punchItemAttachment PunchItemAttachment */
			$punchItemAttachment->convertPropertiesToData();

			if (isset($row['punch_item_id'])) {
				$punch_item_id = $row['punch_item_id'];
				$row['pia_fk_pi__id'] = $punch_item_id;
				$punchItem = self::instantiateOrm($database, 'PunchItem', $row, null, $punch_item_id, 'pia_fk_pi__');
				/* @var $punchItem PunchItem */
				$punchItem->convertPropertiesToData();
			} else {
				$punchItem = false;
			}
			$punchItemAttachment->setPunchItem($punchItem);

			if (isset($row['pi_attachment_file_manager_file_id'])) {
				$pi_attachment_file_manager_file_id = $row['pi_attachment_file_manager_file_id'];
				$row['pia_fk_fmfiles__id'] = $pi_attachment_file_manager_file_id;
				$piAttachmentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $pi_attachment_file_manager_file_id, 'pia_fk_fmfiles__');
				/* @var $piAttachmentFileManagerFile FileManagerFile */
				$piAttachmentFileManagerFile->convertPropertiesToData();
			} else {
				$piAttachmentFileManagerFile = false;
			}
			$punchItemAttachment->setPiAttachmentFileManagerFile($piAttachmentFileManagerFile);

			if (isset($row['pi_attachment_source_contact_id'])) {
				$pi_attachment_source_contact_id = $row['pi_attachment_source_contact_id'];
				$row['pia_fk_pia_source_c__id'] = $pi_attachment_source_contact_id;
				$piAttachmentSourceContact = self::instantiateOrm($database, 'Contact', $row, null, $pi_attachment_source_contact_id, 'pia_fk_pia_source_c__');
				/* @var $piAttachmentSourceContact Contact */
				$piAttachmentSourceContact->convertPropertiesToData();
			} else {
				$piAttachmentSourceContact = false;
			}
			$punchItemAttachment->setPiAttachmentSourceContact($piAttachmentSourceContact);

			$arrPunchItemAttachmentsByPunchItemId[] = $punchItemAttachment;
		}

		$db->free_result();

		self::$_arrPunchItemAttachmentsByPunchItemId = $arrPunchItemAttachmentsByPunchItemId;

		return $arrPunchItemAttachmentsByPunchItemId;
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
INTO `punch_item_attachments`
(`punch_item_id`, `pi_attachment_file_manager_file_id`, `pi_attachment_source_contact_id`, `sort_order`)
VALUES (?, ?, ?, ? ,?)
ON DUPLICATE KEY UPDATE `pi_attachment_source_contact_id` = ?, `sort_order` = ?
";
		$arrValues = array($this->punch_item_id, $this->pi_attachment_file_manager_file_id, $this->pi_attachment_source_contact_id, $this->sort_order, $this->pi_attachment_source_contact_id, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$punchItem_attachment_id = $db->insertId;
		$db->free_result();

		return $punchItem_attachment_id;
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`punch_item_id`,`pi_attachment_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @param int $su_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByPunchItemIdAndPiAttachmentFileManagerFileId($database, $punch_item_id, $pi_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT
		pia.*

		FROM `punch_item_attachments` pia
		WHERE pia.`punch_item_id` = ?
		AND pia.`pi_attachment_file_manager_file_id` = ?
		";
		$arrValues = array($punch_item_id, $pi_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$punchItemAttachment = self::instantiateOrm($database, 'PunchItemAttachment', $row);
			/* @var $punchItemAttachment PunchItemAttachment */
			return $punchItemAttachment;
		} else {
			return false;
		}
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`punch_item_id`,`pi_attachment_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @param int $su_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function deletePunchItemAttachmentByPunchItemId($database, $punch_item_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		DELETE 
		FROM `punch_item_attachments`
		WHERE `punch_item_id` = $punch_item_id
		";
		$arrValues = array($punch_item_id);
		$db->execute($query);
		$db->free_result();
		return true;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
