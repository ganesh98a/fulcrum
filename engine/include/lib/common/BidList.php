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
 * BidList.
 *
 * @category   Framework
 * @package    BidList
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class BidList extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'BidList';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'bid_lists';

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
	 * unique index `unique_bid_list` (`user_company_id`,`bid_list_name`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_bid_list' => array(
			'user_company_id' => 'int',
			'bid_list_name' => 'string'
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
		'id' => 'bid_list_id',

		'user_company_id' => 'user_company_id',

		'bid_list_name' => 'bid_list_name',

		'bid_list_description' => 'bid_list_description',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $bid_list_id;

	public $user_company_id;

	public $bid_list_name;

	public $bid_list_description;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_bid_list_name;
	public $escaped_bid_list_description;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_bid_list_name_nl2br;
	public $escaped_bid_list_description_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrBidListsByUserCompanyId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrBidListsByBidListName;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllBidLists;

	// Foreign Key Objects
	private $_userCompany;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='bid_lists')
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
	public static function getArrBidListsByUserCompanyId()
	{
		if (isset(self::$_arrBidListsByUserCompanyId)) {
			return self::$_arrBidListsByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrBidListsByUserCompanyId($arrBidListsByUserCompanyId)
	{
		self::$_arrBidListsByUserCompanyId = $arrBidListsByUserCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrBidListsByBidListName()
	{
		if (isset(self::$_arrBidListsByBidListName)) {
			return self::$_arrBidListsByBidListName;
		} else {
			return null;
		}
	}

	public static function setArrBidListsByBidListName($arrBidListsByBidListName)
	{
		self::$_arrBidListsByBidListName = $arrBidListsByBidListName;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllBidLists()
	{
		if (isset(self::$_arrAllBidLists)) {
			return self::$_arrAllBidLists;
		} else {
			return null;
		}
	}

	public static function setArrAllBidLists($arrAllBidLists)
	{
		self::$_arrAllBidLists = $arrAllBidLists;
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
	 * @param int $bid_list_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $bid_list_id, $table='bid_lists', $module='BidList')
	{
		$bidList = parent::findById($database, $bid_list_id, $table, $module);

		return $bidList;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $bid_list_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBidListByIdExtended($database, $bid_list_id)
	{
		$bid_list_id = (int) $bid_list_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	bl_fk_uc.`id` AS 'bl_fk_uc__user_company_id',
	bl_fk_uc.`company` AS 'bl_fk_uc__company',
	bl_fk_uc.`primary_phone_number` AS 'bl_fk_uc__primary_phone_number',
	bl_fk_uc.`employer_identification_number` AS 'bl_fk_uc__employer_identification_number',
	bl_fk_uc.`construction_license_number` AS 'bl_fk_uc__construction_license_number',
	bl_fk_uc.`construction_license_number_expiration_date` AS 'bl_fk_uc__construction_license_number_expiration_date',
	bl_fk_uc.`paying_customer_flag` AS 'bl_fk_uc__paying_customer_flag',

	bl.*

FROM `bid_lists` bl
	INNER JOIN `user_companies` bl_fk_uc ON bl.`user_company_id` = bl_fk_uc.`id`
WHERE bl.`id` = ?
";
		$arrValues = array($bid_list_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$bid_list_id = $row['id'];
			$bidList = self::instantiateOrm($database, 'BidList', $row, null, $bid_list_id);
			/* @var $bidList BidList */
			$bidList->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['bl_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'bl_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$bidList->setUserCompany($userCompany);

			return $bidList;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_bid_list` (`user_company_id`,`bid_list_name`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $bid_list_name
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndBidListName($database, $user_company_id, $bid_list_name)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	bl.*

FROM `bid_lists` bl
WHERE bl.`user_company_id` = ?
AND bl.`bid_list_name` = ?
";
		$arrValues = array($user_company_id, $bid_list_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$bid_list_id = $row['id'];
			$bidList = self::instantiateOrm($database, 'BidList', $row, null, $bid_list_id);
			/* @var $bidList BidList */
			return $bidList;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrBidListIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidListsByArrBidListIds($database, $arrBidListIds, Input $options=null)
	{
		if (empty($arrBidListIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `bid_list_name` ASC, `bid_list_description` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bl.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidList = new BidList($database);
			$sqlOrderByColumns = $tmpBidList->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrBidListIds as $k => $bid_list_id) {
			$bid_list_id = (int) $bid_list_id;
			$arrBidListIds[$k] = $db->escape($bid_list_id);
		}
		$csvBidListIds = join(',', $arrBidListIds);

		$query =
"
SELECT

	bl.*

FROM `bid_lists` bl
WHERE bl.`id` IN ($csvBidListIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrBidListsByCsvBidListIds = array();
		while ($row = $db->fetch()) {
			$bid_list_id = $row['id'];
			$bidList = self::instantiateOrm($database, 'BidList', $row, null, $bid_list_id);
			/* @var $bidList BidList */
			$bidList->convertPropertiesToData();

			$arrBidListsByCsvBidListIds[$bid_list_id] = $bidList;
		}

		$db->free_result();

		return $arrBidListsByCsvBidListIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `bid_lists_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidListsByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrBidListsByUserCompanyId = null;
		}

		$arrBidListsByUserCompanyId = self::$_arrBidListsByUserCompanyId;
		if (isset($arrBidListsByUserCompanyId) && !empty($arrBidListsByUserCompanyId)) {
			return $arrBidListsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `bid_list_name` ASC, `bid_list_description` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bl.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidList = new BidList($database);
			$sqlOrderByColumns = $tmpBidList->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bl.*

FROM `bid_lists` bl
WHERE bl.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `bid_list_name` ASC, `bid_list_description` ASC, `sort_order` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidListsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$bid_list_id = $row['id'];
			$bidList = self::instantiateOrm($database, 'BidList', $row, null, $bid_list_id);
			/* @var $bidList BidList */
			$arrBidListsByUserCompanyId[$bid_list_id] = $bidList;
		}

		$db->free_result();

		self::$_arrBidListsByUserCompanyId = $arrBidListsByUserCompanyId;

		return $arrBidListsByUserCompanyId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `bid_list_name` (`bid_list_name`).
	 *
	 * @param string $database
	 * @param string $bid_list_name
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadBidListsByBidListName($database, $bid_list_name, Input $options=null)
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
			self::$_arrBidListsByBidListName = null;
		}

		$arrBidListsByBidListName = self::$_arrBidListsByBidListName;
		if (isset($arrBidListsByBidListName) && !empty($arrBidListsByBidListName)) {
			return $arrBidListsByBidListName;
		}

		$bid_list_name = (string) $bid_list_name;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `bid_list_name` ASC, `bid_list_description` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bl.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidList = new BidList($database);
			$sqlOrderByColumns = $tmpBidList->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bl.*

FROM `bid_lists` bl
WHERE bl.`bid_list_name` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `bid_list_name` ASC, `bid_list_description` ASC, `sort_order` ASC
		$arrValues = array($bid_list_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidListsByBidListName = array();
		while ($row = $db->fetch()) {
			$bid_list_id = $row['id'];
			$bidList = self::instantiateOrm($database, 'BidList', $row, null, $bid_list_id);
			/* @var $bidList BidList */
			$arrBidListsByBidListName[$bid_list_id] = $bidList;
		}

		$db->free_result();

		self::$_arrBidListsByBidListName = $arrBidListsByBidListName;

		return $arrBidListsByBidListName;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all bid_lists records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllBidLists($database, Input $options=null)
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
			self::$_arrAllBidLists = null;
		}

		$arrAllBidLists = self::$_arrAllBidLists;
		if (isset($arrAllBidLists) && !empty($arrAllBidLists)) {
			return $arrAllBidLists;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `bid_list_name` ASC, `bid_list_description` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bl.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidList = new BidList($database);
			$sqlOrderByColumns = $tmpBidList->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bl.*

FROM `bid_lists` bl{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `bid_list_name` ASC, `bid_list_description` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllBidLists = array();
		while ($row = $db->fetch()) {
			$bid_list_id = $row['id'];
			$bidList = self::instantiateOrm($database, 'BidList', $row, null, $bid_list_id);
			/* @var $bidList BidList */
			$arrAllBidLists[$bid_list_id] = $bidList;
		}

		$db->free_result();

		self::$_arrAllBidLists = $arrAllBidLists;

		return $arrAllBidLists;
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
INTO `bid_lists`
(`user_company_id`, `bid_list_name`, `bid_list_description`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `bid_list_description` = ?, `sort_order` = ?
";
		$arrValues = array($this->user_company_id, $this->bid_list_name, $this->bid_list_description, $this->sort_order, $this->bid_list_description, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$bid_list_id = $db->insertId;
		$db->free_result();

		return $bid_list_id;
	}

	// Save: insert ignore
	public static function findBidlistByCompanyProjectId($database, $project_id, $user_company_id){
		$db = DBI::getInstance($database);
		$db->free_result();
		$query  = "SELECT * FROM `gc_budget_line_items` INNER JOIN `cost_codes` ON `gc_budget_line_items`.`cost_code_id` = `cost_codes`.id INNER JOIN `cost_code_divisions` ON `cost_codes`.`cost_code_division_id` = `cost_code_divisions`.`id` WHERE `gc_budget_line_items`.`user_company_id` = ? AND `gc_budget_line_items`.`project_id` = ? AND division_number_group_id = 0 LIMIT 1";
	

		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		$groupdivisioncomp = false;
		if(!empty($row['id'])){
			$groupdivisioncomp = true;
		}
		
		return $groupdivisioncomp;

	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
