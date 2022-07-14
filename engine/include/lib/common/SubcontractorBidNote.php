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
 * SubcontractorBidNote.
 *
 * @category   Framework
 * @package    SubcontractorBidNote
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractorBidNote extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractorBidNote';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontractor_bid_notes';

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
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontractor_bid_note_via_primary_key' => array(
			'subcontractor_bid_note_id' => 'int'
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
		'id' => 'subcontractor_bid_note_id',

		'subcontractor_bid_id' => 'subcontractor_bid_id',
		'created_by_contact_id' => 'created_by_contact_id',

		'subcontractor_bid_note' => 'subcontractor_bid_note',
		'created' => 'created'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontractor_bid_note_id;

	public $subcontractor_bid_id;
	public $created_by_contact_id;

	public $subcontractor_bid_note;
	public $created;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_subcontractor_bid_note;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_subcontractor_bid_note_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubcontractorBidNotesBySubcontractorBidId;
	protected static $_arrSubcontractorBidNotesByCreatedByContactId;
	protected static $_arrSubcontractorBidNotesByGcBudgetLineItemId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractorBidNotes;

	// Foreign Key Objects
	private $_subcontractorBid;
	private $_createdByContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontractor_bid_notes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSubcontractorBid()
	{
		if (isset($this->_subcontractorBid)) {
			return $this->_subcontractorBid;
		} else {
			return null;
		}
	}

	public function setSubcontractorBid($subcontractorBid)
	{
		$this->_subcontractorBid = $subcontractorBid;
	}

	public function getCreatedByContact()
	{
		if (isset($this->_createdByContact)) {
			return $this->_createdByContact;
		} else {
			return null;
		}
	}

	public function setCreatedByContact($createdByContact)
	{
		$this->_createdByContact = $createdByContact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubcontractorBidNotesBySubcontractorBidId()
	{
		if (isset(self::$_arrSubcontractorBidNotesBySubcontractorBidId)) {
			return self::$_arrSubcontractorBidNotesBySubcontractorBidId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidNotesBySubcontractorBidId($arrSubcontractorBidNotesBySubcontractorBidId)
	{
		self::$_arrSubcontractorBidNotesBySubcontractorBidId = $arrSubcontractorBidNotesBySubcontractorBidId;
	}

	public static function getArrSubcontractorBidNotesByCreatedByContactId()
	{
		if (isset(self::$_arrSubcontractorBidNotesByCreatedByContactId)) {
			return self::$_arrSubcontractorBidNotesByCreatedByContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidNotesByCreatedByContactId($arrSubcontractorBidNotesByCreatedByContactId)
	{
		self::$_arrSubcontractorBidNotesByCreatedByContactId = $arrSubcontractorBidNotesByCreatedByContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractorBidNotes()
	{
		if (isset(self::$_arrAllSubcontractorBidNotes)) {
			return self::$_arrAllSubcontractorBidNotes;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractorBidNotes($arrAllSubcontractorBidNotes)
	{
		self::$_arrAllSubcontractorBidNotes = $arrAllSubcontractorBidNotes;
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
	 * @param int $subcontractor_bid_note_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $subcontractor_bid_note_id,$table='subcontractor_bid_notes', $module='SubcontractorBidNote')
	{
		$subcontractorBidNote = parent::findById($database, $subcontractor_bid_note_id,  $table, $module);

		return $subcontractorBidNote;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_note_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubcontractorBidNoteByIdExtended($database, $subcontractor_bid_note_id)
	{
		$subcontractor_bid_note_id = (int) $subcontractor_bid_note_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sbn_fk_sb.`id` AS 'sbn_fk_sb__subcontractor_bid_id',
	sbn_fk_sb.`gc_budget_line_item_id` AS 'sbn_fk_sb__gc_budget_line_item_id',
	sbn_fk_sb.`subcontractor_contact_id` AS 'sbn_fk_sb__subcontractor_contact_id',
	sbn_fk_sb.`subcontractor_bid_status_id` AS 'sbn_fk_sb__subcontractor_bid_status_id',
	sbn_fk_sb.`sort_order` AS 'sbn_fk_sb__sort_order',

	sbn_fk_c.`id` AS 'sbn_fk_c__contact_id',
	sbn_fk_c.`user_company_id` AS 'sbn_fk_c__user_company_id',
	sbn_fk_c.`user_id` AS 'sbn_fk_c__user_id',
	sbn_fk_c.`contact_company_id` AS 'sbn_fk_c__contact_company_id',
	sbn_fk_c.`email` AS 'sbn_fk_c__email',
	sbn_fk_c.`name_prefix` AS 'sbn_fk_c__name_prefix',
	sbn_fk_c.`first_name` AS 'sbn_fk_c__first_name',
	sbn_fk_c.`additional_name` AS 'sbn_fk_c__additional_name',
	sbn_fk_c.`middle_name` AS 'sbn_fk_c__middle_name',
	sbn_fk_c.`last_name` AS 'sbn_fk_c__last_name',
	sbn_fk_c.`name_suffix` AS 'sbn_fk_c__name_suffix',
	sbn_fk_c.`title` AS 'sbn_fk_c__title',
	sbn_fk_c.`vendor_flag` AS 'sbn_fk_c__vendor_flag',

	sbn.*

FROM `subcontractor_bid_notes` sbn
	INNER JOIN `subcontractor_bids` sbn_fk_sb ON sbn.`subcontractor_bid_id` = sbn_fk_sb.`id`
	LEFT OUTER JOIN `contacts` sbn_fk_c ON sbn.`created_by_contact_id` = sbn_fk_c.`id`
WHERE sbn.`id` = ?
";
		$arrValues = array($subcontractor_bid_note_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$subcontractor_bid_note_id = $row['id'];
			$subcontractorBidNote = self::instantiateOrm($database, 'SubcontractorBidNote', $row, null, $subcontractor_bid_note_id);
			/* @var $subcontractorBidNote SubcontractorBidNote */
			$subcontractorBidNote->convertPropertiesToData();

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['sbn_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'sbn_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontractorBidNote->setSubcontractorBid($subcontractorBid);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['sbn_fk_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'sbn_fk_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$subcontractorBidNote->setCreatedByContact($createdByContact);

			return $subcontractorBidNote;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubcontractorBidNoteIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidNotesByArrSubcontractorBidNoteIds($database, $arrSubcontractorBidNoteIds, Input $options=null)
	{
		if (empty($arrSubcontractorBidNoteIds)) {
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
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `created_by_contact_id` ASC, `subcontractor_bid_note` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidNote = new SubcontractorBidNote($database);
			$sqlOrderByColumns = $tmpSubcontractorBidNote->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubcontractorBidNoteIds as $k => $subcontractor_bid_note_id) {
			$subcontractor_bid_note_id = (int) $subcontractor_bid_note_id;
			$arrSubcontractorBidNoteIds[$k] = $db->escape($subcontractor_bid_note_id);
		}
		$csvSubcontractorBidNoteIds = join(',', $arrSubcontractorBidNoteIds);

		$query =
"
SELECT

	sbn.*

FROM `subcontractor_bid_notes` sbn
WHERE sbn.`id` IN ($csvSubcontractorBidNoteIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubcontractorBidNotesByCsvSubcontractorBidNoteIds = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_note_id = $row['id'];
			$subcontractorBidNote = self::instantiateOrm($database, 'SubcontractorBidNote', $row, null, $subcontractor_bid_note_id);
			/* @var $subcontractorBidNote SubcontractorBidNote */
			$subcontractorBidNote->convertPropertiesToData();

			$arrSubcontractorBidNotesByCsvSubcontractorBidNoteIds[$subcontractor_bid_note_id] = $subcontractorBidNote;
		}

		$db->free_result();

		return $arrSubcontractorBidNotesByCsvSubcontractorBidNoteIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `subcontractor_bid_notes_fk_sb` foreign key (`subcontractor_bid_id`) references `subcontractor_bids` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidNotesBySubcontractorBidId($database, $subcontractor_bid_id, Input $options=null)
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
			self::$_arrSubcontractorBidNotesBySubcontractorBidId = null;
		}

		$arrSubcontractorBidNotesBySubcontractorBidId = self::$_arrSubcontractorBidNotesBySubcontractorBidId;
		if (isset($arrSubcontractorBidNotesBySubcontractorBidId) && !empty($arrSubcontractorBidNotesBySubcontractorBidId)) {
			return $arrSubcontractorBidNotesBySubcontractorBidId;
		}

		$subcontractor_bid_id = (int) $subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `created_by_contact_id` ASC, `subcontractor_bid_note` ASC, `created` ASC
		$sqlOrderBy = "\nORDER BY sbn.`created` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidNote = new SubcontractorBidNote($database);
			$sqlOrderByColumns = $tmpSubcontractorBidNote->constructSqlOrderByColumns($arrOrderByAttributes);

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

	sbn_fk_sb.`id` AS 'sbn_fk_sb__subcontractor_bid_id',
	sbn_fk_sb.`gc_budget_line_item_id` AS 'sbn_fk_sb__gc_budget_line_item_id',
	sbn_fk_sb.`subcontractor_contact_id` AS 'sbn_fk_sb__subcontractor_contact_id',
	sbn_fk_sb.`subcontractor_bid_status_id` AS 'sbn_fk_sb__subcontractor_bid_status_id',
	sbn_fk_sb.`sort_order` AS 'sbn_fk_sb__sort_order',

	sbn_fk_c.`id` AS 'sbn_fk_c__contact_id',
	sbn_fk_c.`user_company_id` AS 'sbn_fk_c__user_company_id',
	sbn_fk_c.`user_id` AS 'sbn_fk_c__user_id',
	sbn_fk_c.`contact_company_id` AS 'sbn_fk_c__contact_company_id',
	sbn_fk_c.`email` AS 'sbn_fk_c__email',
	sbn_fk_c.`name_prefix` AS 'sbn_fk_c__name_prefix',
	sbn_fk_c.`first_name` AS 'sbn_fk_c__first_name',
	sbn_fk_c.`additional_name` AS 'sbn_fk_c__additional_name',
	sbn_fk_c.`middle_name` AS 'sbn_fk_c__middle_name',
	sbn_fk_c.`last_name` AS 'sbn_fk_c__last_name',
	sbn_fk_c.`name_suffix` AS 'sbn_fk_c__name_suffix',
	sbn_fk_c.`title` AS 'sbn_fk_c__title',
	sbn_fk_c.`vendor_flag` AS 'sbn_fk_c__vendor_flag',

	sbn.*

FROM `subcontractor_bid_notes` sbn
	INNER JOIN `subcontractor_bids` sbn_fk_sb ON sbn.`subcontractor_bid_id` = sbn_fk_sb.`id`
	LEFT OUTER JOIN `contacts` sbn_fk_c ON sbn.`created_by_contact_id` = sbn_fk_c.`id`
WHERE sbn.`subcontractor_bid_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `created_by_contact_id` ASC, `subcontractor_bid_note` ASC, `created` ASC
		$arrValues = array($subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidNotesBySubcontractorBidId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_note_id = $row['id'];
			$subcontractorBidNote = self::instantiateOrm($database, 'SubcontractorBidNote', $row, null, $subcontractor_bid_note_id);
			/* @var $subcontractorBidNote SubcontractorBidNote */
			$subcontractorBidNote->convertPropertiesToData();

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['sbn_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'sbn_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontractorBidNote->setSubcontractorBid($subcontractorBid);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['sbn_fk_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'sbn_fk_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$subcontractorBidNote->setCreatedByContact($createdByContact);

			$arrSubcontractorBidNotesBySubcontractorBidId[$subcontractor_bid_note_id] = $subcontractorBidNote;
		}

		$db->free_result();

		self::$_arrSubcontractorBidNotesBySubcontractorBidId = $arrSubcontractorBidNotesBySubcontractorBidId;

		return $arrSubcontractorBidNotesBySubcontractorBidId;
	}

	/**
	 * Load by constraint `subcontractor_bid_notes_fk_c` foreign key (`created_by_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $created_by_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidNotesByCreatedByContactId($database, $created_by_contact_id, Input $options=null)
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
			self::$_arrSubcontractorBidNotesByCreatedByContactId = null;
		}

		$arrSubcontractorBidNotesByCreatedByContactId = self::$_arrSubcontractorBidNotesByCreatedByContactId;
		if (isset($arrSubcontractorBidNotesByCreatedByContactId) && !empty($arrSubcontractorBidNotesByCreatedByContactId)) {
			return $arrSubcontractorBidNotesByCreatedByContactId;
		}

		$created_by_contact_id = (int) $created_by_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `created_by_contact_id` ASC, `subcontractor_bid_note` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidNote = new SubcontractorBidNote($database);
			$sqlOrderByColumns = $tmpSubcontractorBidNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbn.*

FROM `subcontractor_bid_notes` sbn
WHERE sbn.`created_by_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `created_by_contact_id` ASC, `subcontractor_bid_note` ASC, `created` ASC
		$arrValues = array($created_by_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidNotesByCreatedByContactId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_note_id = $row['id'];
			$subcontractorBidNote = self::instantiateOrm($database, 'SubcontractorBidNote', $row, null, $subcontractor_bid_note_id);
			/* @var $subcontractorBidNote SubcontractorBidNote */
			$arrSubcontractorBidNotesByCreatedByContactId[$subcontractor_bid_note_id] = $subcontractorBidNote;
		}

		$db->free_result();

		self::$_arrSubcontractorBidNotesByCreatedByContactId = $arrSubcontractorBidNotesByCreatedByContactId;

		return $arrSubcontractorBidNotesByCreatedByContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all subcontractor_bid_notes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractorBidNotes($database, Input $options=null)
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
			self::$_arrAllSubcontractorBidNotes = null;
		}

		$arrAllSubcontractorBidNotes = self::$_arrAllSubcontractorBidNotes;
		if (isset($arrAllSubcontractorBidNotes) && !empty($arrAllSubcontractorBidNotes)) {
			return $arrAllSubcontractorBidNotes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `created_by_contact_id` ASC, `subcontractor_bid_note` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidNote = new SubcontractorBidNote($database);
			$sqlOrderByColumns = $tmpSubcontractorBidNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbn.*

FROM `subcontractor_bid_notes` sbn{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `created_by_contact_id` ASC, `subcontractor_bid_note` ASC, `created` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractorBidNotes = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_note_id = $row['id'];
			$subcontractorBidNote = self::instantiateOrm($database, 'SubcontractorBidNote', $row, null, $subcontractor_bid_note_id);
			/* @var $subcontractorBidNote SubcontractorBidNote */
			$arrAllSubcontractorBidNotes[$subcontractor_bid_note_id] = $subcontractorBidNote;
		}

		$db->free_result();

		self::$_arrAllSubcontractorBidNotes = $arrAllSubcontractorBidNotes;

		return $arrAllSubcontractorBidNotes;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	/**
	 * Find by constraint `subcontractor_bid_notes_fk_sb` foreign key (`subcontractor_bid_id`) references `subcontractor_bids` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadSubcontractorBidNotesByGcBudgetLineItemId($database, $gc_budget_line_item_id, Input $options=null)
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
			self::$_arrSubcontractorBidNotesByGcBudgetLineItemId = null;
		}

		$arrSubcontractorBidNotesByGcBudgetLineItemId = self::$_arrSubcontractorBidNotesByGcBudgetLineItemId;
		if (isset($arrSubcontractorBidNotesByGcBudgetLineItemId) && !empty($arrSubcontractorBidNotesByGcBudgetLineItemId)) {
			return $arrSubcontractorBidNotesByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `created_by_contact_id` ASC, `subcontractor_bid_note` ASC, `created` ASC
		$sqlOrderBy = "\nORDER BY sbn.`subcontractor_bid_id` ASC, sbn.`created` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidNote = new SubcontractorBidNote($database);
			$sqlOrderByColumns = $tmpSubcontractorBidNote->constructSqlOrderByColumns($arrOrderByAttributes);

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

	sbn_fk_sb.`id` AS 'sbn_fk_sb__subcontractor_bid_id',
	sbn_fk_sb.`gc_budget_line_item_id` AS 'sbn_fk_sb__gc_budget_line_item_id',
	sbn_fk_sb.`subcontractor_contact_id` AS 'sbn_fk_sb__subcontractor_contact_id',
	sbn_fk_sb.`subcontractor_bid_status_id` AS 'sbn_fk_sb__subcontractor_bid_status_id',
	sbn_fk_sb.`sort_order` AS 'sbn_fk_sb__sort_order',

	sbn_fk_c.`id` AS 'sbn_fk_c__contact_id',
	sbn_fk_c.`user_company_id` AS 'sbn_fk_c__user_company_id',
	sbn_fk_c.`user_id` AS 'sbn_fk_c__user_id',
	sbn_fk_c.`contact_company_id` AS 'sbn_fk_c__contact_company_id',
	sbn_fk_c.`email` AS 'sbn_fk_c__email',
	sbn_fk_c.`name_prefix` AS 'sbn_fk_c__name_prefix',
	sbn_fk_c.`first_name` AS 'sbn_fk_c__first_name',
	sbn_fk_c.`additional_name` AS 'sbn_fk_c__additional_name',
	sbn_fk_c.`middle_name` AS 'sbn_fk_c__middle_name',
	sbn_fk_c.`last_name` AS 'sbn_fk_c__last_name',
	sbn_fk_c.`name_suffix` AS 'sbn_fk_c__name_suffix',
	sbn_fk_c.`title` AS 'sbn_fk_c__title',
	sbn_fk_c.`vendor_flag` AS 'sbn_fk_c__vendor_flag',

	sbn.*

FROM `subcontractor_bid_notes` sbn
	INNER JOIN `subcontractor_bids` sbn_fk_sb ON sbn.`subcontractor_bid_id` = sbn_fk_sb.`id`
	LEFT OUTER JOIN `contacts` sbn_fk_c ON sbn.`created_by_contact_id` = sbn_fk_c.`id`

	INNER JOIN `gc_budget_line_items` gbli ON sbn_fk_sb.`gc_budget_line_item_id` = gbli.`id`
WHERE sbn_fk_sb.`gc_budget_line_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `created_by_contact_id` ASC, `subcontractor_bid_note` ASC, `created` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidNotesByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_note_id = $row['id'];

			$subcontractorBidNote = self::instantiateOrm($database, 'SubcontractorBidNote', $row, null, $subcontractor_bid_note_id);
			/* @var $subcontractorBidNote SubcontractorBidNote */
			$subcontractorBidNote->convertPropertiesToData();

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['sbn_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'sbn_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontractorBidNote->setSubcontractorBid($subcontractorBid);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['sbn_fk_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'sbn_fk_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$subcontractorBidNote->setCreatedByContact($createdByContact);

			$arrSubcontractorBidNotesByGcBudgetLineItemId[$subcontractor_bid_id][$subcontractor_bid_note_id] = $subcontractorBidNote;
		}

		$db->free_result();

		self::$_arrSubcontractorBidNotesByGcBudgetLineItemId = $arrSubcontractorBidNotesByGcBudgetLineItemId;

		return $arrSubcontractorBidNotesByGcBudgetLineItemId;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
