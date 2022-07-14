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
 * CostCode.
 *
 * @category   Framework
 * @package    CostCode
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class CostCode extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'CostCode';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'cost_codes';

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
	 * unique index `unique_cost_code` (`cost_code_division_id`,`cost_code`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_cost_code' => array(
			'cost_code_division_id' => 'int',
			'cost_code' => 'string'
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
		'id' => 'cost_code_id',

		'cost_code_division_id' => 'cost_code_division_id',

		'cost_code' => 'cost_code',

		'cost_code_description' => 'cost_code_description',
		'cost_code_description_abbreviation' => 'cost_code_description_abbreviation',
		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $cost_code_id;

	public $cost_code_division_id;

	public $cost_code;

	public $cost_code_description;
	public $cost_code_description_abbreviation;
	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;
	private $_formattedCostCodeLabelNoDescription;
	private $_formattedCostCodeLabel;
	private $_htmlEntityEscapedFormattedCostCodeLabel;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_cost_code;
	public $escaped_cost_code_description;
	public $escaped_cost_code_description_abbreviation;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_cost_code_nl2br;
	public $escaped_cost_code_description_nl2br;
	public $escaped_cost_code_description_abbreviation_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrCostCodesByCostCodeDivisionId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrCostCodesByCostCode;
	protected static $_arrCostCodesByCostCodeDescription;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllCostCodes;
	protected static $_arrCostCodesBySortOrder;

	protected static $_arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId;

	// Foreign Key Objects
	private $_costCodeDivision;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='cost_codes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	public function getFormattedCostCode($database,$includeDescriptionFlag=true, $user_company_id = null)
	{
		if ($includeDescriptionFlag && isset($this->_formattedCostCodeLabel) && !empty($this->_formattedCostCodeLabel)) {
			return $this->_formattedCostCodeLabel;
		} elseif (isset($this->_formattedCostCodeLabelNoDescription) && !empty($this->_formattedCostCodeLabelNoDescription)) {
			return $this->_formattedCostCodeLabelNoDescription;
		}

		if (!$this->isDataLoaded()) {
			return '';
		}

		$costCodeDivision = $this->getCostCodeDivision();
		if (!$costCodeDivision) {
			$cost_code_division_id = $this->cost_code_division_id;
			if (isset($cost_code_division_id)) {
				$database = $this->getDatabase();
				$costCodeDivision = CostCodeDivision::findById($database, $cost_code_division_id);
				$this->_costCodeDivision = $costCodeDivision;
			}
		}
		/* @var $costCodeDivision CostCodeDivision */

		if ($costCodeDivision) {
			$division_number = $costCodeDivision->division_number;
		} else {
			$division_number = '';
		}

		$cost_code = $this->cost_code;
		$cost_code_description = $this->cost_code_description;
		if($user_company_id){
			$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
		}else{
			$costCodeDividerType = '-';
		}

		$formattedCostCodeLabel = $division_number.$costCodeDividerType.$cost_code.' '.$cost_code_description;
		$this->_formattedCostCodeLabel = $formattedCostCodeLabel;

		$formattedCostCodeLabelNoDescription = $division_number.$costCodeDividerType.$cost_code;
		$this->_formattedCostCodeLabelNoDescription = $formattedCostCodeLabelNoDescription;

		if ($includeDescriptionFlag) {
			return $formattedCostCodeLabel;
		} else {
			return $formattedCostCodeLabelNoDescription;
		}
	}
	// Api
	public function getFormattedCostCodeApi($database, $includeDescriptionFlag=true, $user_company_id = null)
	{
		if ($includeDescriptionFlag && isset($this->_formattedCostCodeLabel) && !empty($this->_formattedCostCodeLabel)) {
			return $this->_formattedCostCodeLabel;
		} elseif (isset($this->_formattedCostCodeLabelNoDescription) && !empty($this->_formattedCostCodeLabelNoDescription)) {
			return $this->_formattedCostCodeLabelNoDescription;
		}

		if (!$this->isDataLoaded()) {
			return '';
		}

		$costCodeDivision = $this->getCostCodeDivision();
		if (!$costCodeDivision) {
			$cost_code_division_id = $this->cost_code_division_id;
			if (isset($cost_code_division_id)) {
				$database = $this->getDatabase();
				$costCodeDivision = CostCodeDivision::findById($database, $cost_code_division_id);
				$this->_costCodeDivision = $costCodeDivision;
			}
		}
		/* @var $costCodeDivision CostCodeDivision */

		if ($costCodeDivision) {
			$division_number = $costCodeDivision->division_number;
		} else {
			$division_number = '';
		}

		$cost_code = $this->cost_code;
		$cost_code_description = $this->cost_code_description;
		if($user_company_id){
			$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
		}else{
			$costCodeDividerType = '-';
		}

		$formattedCostCodeLabel = $division_number.$costCodeDividerType.$cost_code.' '.$cost_code_description;
		$this->_formattedCostCodeLabel = $formattedCostCodeLabel;

		$formattedCostCodeLabelNoDescription = $division_number.$costCodeDividerType.$cost_code;
		$this->_formattedCostCodeLabelNoDescription = $formattedCostCodeLabelNoDescription;

		if ($includeDescriptionFlag) {
			return $formattedCostCodeLabel;
		} else {
			return $formattedCostCodeLabelNoDescription;
		}
	}

	public function getHtmlEntityEscapedFormattedCostCode($user_company_id=null)
	{
		if (isset($this->_htmlEntityEscapedFormattedCostCodeLabel) && !empty($this->_htmlEntityEscapedFormattedCostCodeLabel)) {
			return $this->_htmlEntityEscapedFormattedCostCodeLabel;
		}

		if (!$this->isDataLoaded()) {
			return '';
		}
		$database = $this->getDatabase();
		$this->htmlEntityEscapeProperties();

		$costCodeDivision = $this->getCostCodeDivision();
		if (!$costCodeDivision) {
			$cost_code_division_id = $this->cost_code_division_id;
			if (isset($cost_code_division_id)) {
				
				$costCodeDivision = CostCodeDivision::findById($database, $cost_code_division_id);
				$this->_costCodeDivision = $costCodeDivision;
			}
		}
		/* @var $costCodeDivision CostCodeDivision */

		if ($costCodeDivision) {
			$costCodeDivision->htmlEntityEscapeProperties();
			$escaped_division_number = $costCodeDivision->escaped_division_number;
		} else {
			$escaped_division_number = '';
		}

		$escaped_cost_code = $this->escaped_cost_code;
		$cost_code_description = $this->cost_code_description;
		if($user_company_id){
			$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
		}else {
			$costCodeDividerType = '-';
		}

		$htmlEntityEscapedFormattedCostCodeLabel = $escaped_division_number.$costCodeDividerType.$escaped_cost_code.' '.$cost_code_description;
		$this->htmlEntityEscapedFormattedCostCodeLabel = $htmlEntityEscapedFormattedCostCodeLabel;

		return $htmlEntityEscapedFormattedCostCodeLabel;
	}
	// Api
	public function getHtmlEntityEscapedFormattedCostCodeApi($database, $user_company_id=null)
	{
		if (isset($this->_htmlEntityEscapedFormattedCostCodeLabel) && !empty($this->_htmlEntityEscapedFormattedCostCodeLabel)) {
			return $this->_htmlEntityEscapedFormattedCostCodeLabel;
		}

		if (!$this->isDataLoaded()) {
			return '';
		}

		$this->htmlEntityEscapeProperties();

		$costCodeDivision = $this->getCostCodeDivision();
		if (!$costCodeDivision) {
			$cost_code_division_id = $this->cost_code_division_id;
			if (isset($cost_code_division_id)) {
				$database = $this->getDatabase();
				$costCodeDivision = CostCodeDivision::findById($database, $cost_code_division_id);
				$this->_costCodeDivision = $costCodeDivision;
			}
		}
		/* @var $costCodeDivision CostCodeDivision */

		if ($costCodeDivision) {
			$costCodeDivision->htmlEntityEscapeProperties();
			$escaped_division_number = $costCodeDivision->escaped_division_number;
		} else {
			$escaped_division_number = '';
		}

		$escaped_cost_code = $this->escaped_cost_code;
		$escaped_cost_code_description = $this->escaped_cost_code_description;
		if($user_company_id){
			$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
		}else {
			$costCodeDividerType = '-';
		}

		$htmlEntityEscapedFormattedCostCodeLabel = $escaped_division_number.$costCodeDividerType.$escaped_cost_code.' '.$escaped_cost_code_description;
		$this->htmlEntityEscapedFormattedCostCodeLabel = $htmlEntityEscapedFormattedCostCodeLabel;

		return $htmlEntityEscapedFormattedCostCodeLabel;
	}

	// Foreign Key Object Accessor Methods
	public function getCostCodeDivision()
	{
		if (isset($this->_costCodeDivision)) {
			return $this->_costCodeDivision;
		} else {
			return null;
		}
	}

	public function setCostCodeDivision($costCodeDivision)
	{
		$this->_costCodeDivision = $costCodeDivision;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrCostCodesByCostCodeDivisionId()
	{
		if (isset(self::$_arrCostCodesByCostCodeDivisionId)) {
			return self::$_arrCostCodesByCostCodeDivisionId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodesByCostCodeDivisionId($arrCostCodesByCostCodeDivisionId)
	{
		self::$_arrCostCodesByCostCodeDivisionId = $arrCostCodesByCostCodeDivisionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrCostCodesByCostCode()
	{
		if (isset(self::$_arrCostCodesByCostCode)) {
			return self::$_arrCostCodesByCostCode;
		} else {
			return null;
		}
	}

	public static function setArrCostCodesByCostCode($arrCostCodesByCostCode)
	{
		self::$_arrCostCodesByCostCode = $arrCostCodesByCostCode;
	}

	public static function getArrCostCodesByCostCodeDescription()
	{
		if (isset(self::$_arrCostCodesByCostCodeDescription)) {
			return self::$_arrCostCodesByCostCodeDescription;
		} else {
			return null;
		}
	}

	public static function setArrCostCodesByCostCodeDescription($arrCostCodesByCostCodeDescription)
	{
		self::$_arrCostCodesByCostCodeDescription = $arrCostCodesByCostCodeDescription;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllCostCodes()
	{
		if (isset(self::$_arrAllCostCodes)) {
			return self::$_arrAllCostCodes;
		} else {
			return null;
		}
	}

	public static function setArrAllCostCodes($arrAllCostCodes)
	{
		self::$_arrAllCostCodes = $arrAllCostCodes;
	}

	public static function getArrCostCodesBySortOrder()
	{
		if (isset(self::$_arrCostCodesBySortOrder)) {
			return self::$_arrCostCodesBySortOrder;
		} else {
			return null;
		}
	}

	public static function setArrCostCodesBySortOrder($arrCostCodesBySortOrder)
	{
		self::$_arrCostCodesBySortOrder = $arrCostCodesBySortOrder;
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
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $cost_code_id, $table='cost_codes', $module='CostCode')
	{
		$costCode = parent::findById($database, $cost_code_id, $table, $module);

		return $costCode;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findCostCodeByIdExtended($database, $cost_code_id)
	{
		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	codes.*

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`
WHERE codes.`id` = ?
";
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$cost_code_id = $row['id'];
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id);
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();

			if (isset($row['cost_code_division_id'])) {
				$cost_code_division_id = $row['cost_code_division_id'];
				$row['codes_fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			return $costCode;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_cost_code` (`cost_code_division_id`,`cost_code`).
	 *
	 * @param string $database
	 * @param int $cost_code_division_id
	 * @param string $cost_code
	 * @return mixed (single ORM object | false)
	 */
	public static function findByCostCodeDivisionIdAndCostCode($database, $cost_code_division_id, $cost_code)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	codes.*

FROM `cost_codes` codes
WHERE codes.`cost_code_division_id` = ?
AND codes.`cost_code` = ?
";
		$arrValues = array($cost_code_division_id, $cost_code);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$cost_code_id = $row['id'];
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id);
			/* @var $costCode CostCode */
			return $costCode;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrCostCodeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodesByArrCostCodeIds($database, $arrCostCodeIds, Input $options=null)
	{
		if (empty($arrCostCodeIds)) {
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
		// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		//$sqlOrderBy = "\nORDER BY codes.`sort_order` ASC";
		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrCostCodeIds as $k => $cost_code_id) {
			$cost_code_id = (int) $cost_code_id;
			$arrCostCodeIds[$k] = $db->escape($cost_code_id);
		}
		$csvCostCodeIds = join(',', $arrCostCodeIds);

		$query =
"
SELECT

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	codes.*

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`
WHERE codes.`id` IN ($csvCostCodeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodesByCsvCostCodeIds = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id);
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();

			if (isset($row['cost_code_division_id'])) {
				$cost_code_division_id = $row['cost_code_division_id'];
				$row['codes_fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			$arrCostCodesByCsvCostCodeIds[$cost_code_id] = $costCode;
		}

		$db->free_result();

		return $arrCostCodesByCsvCostCodeIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `cost_codes_fk_ccd` foreign key (`cost_code_division_id`) references `cost_code_divisions` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_division_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodesByCostCodeDivisionId($database, $cost_code_division_id, Input $options=null)
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
			self::$_arrCostCodesByCostCodeDivisionId = null;
		}

		$arrCostCodesByCostCodeDivisionId = self::$_arrCostCodesByCostCodeDivisionId;
		if (isset($arrCostCodesByCostCodeDivisionId) && !empty($arrCostCodesByCostCodeDivisionId)) {
			return $arrCostCodesByCostCodeDivisionId;
		}

		$cost_code_division_id = (int) $cost_code_division_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		//$sqlOrderBy = "\nORDER BY codes.`sort_order` ASC";
		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	codes.*

FROM `cost_codes` codes
WHERE codes.`cost_code_division_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($cost_code_division_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodesByCostCodeDivisionId = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id);
			/* @var $costCode CostCode */
			$arrCostCodesByCostCodeDivisionId[$cost_code_id] = $costCode;
		}

		$db->free_result();

		self::$_arrCostCodesByCostCodeDivisionId = $arrCostCodesByCostCodeDivisionId;

		return $arrCostCodesByCostCodeDivisionId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `cost_code` (`cost_code`).
	 *
	 * @param string $database
	 * @param string $cost_code
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadCostCodesByCostCode($database, $cost_code, Input $options=null)
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
			self::$_arrCostCodesByCostCode = null;
		}

		$arrCostCodesByCostCode = self::$_arrCostCodesByCostCode;
		if (isset($arrCostCodesByCostCode) && !empty($arrCostCodesByCostCode)) {
			return $arrCostCodesByCostCode;
		}

		$cost_code = (string) $cost_code;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		//$sqlOrderBy = "\nORDER BY codes.`sort_order` ASC";
		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	codes.*

FROM `cost_codes` codes
WHERE codes.`cost_code` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($cost_code);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodesByCostCode = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id);
			/* @var $costCode CostCode */
			$arrCostCodesByCostCode[$cost_code_id] = $costCode;
		}

		$db->free_result();

		self::$_arrCostCodesByCostCode = $arrCostCodesByCostCode;

		return $arrCostCodesByCostCode;
	}

	/**
	 * Load by key `cost_code_description` (`cost_code_description`).
	 *
	 * @param string $database
	 * @param string $cost_code_description
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadCostCodesByCostCodeDescription($database, $cost_code_description, Input $options=null)
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
			self::$_arrCostCodesByCostCodeDescription = null;
		}

		$arrCostCodesByCostCodeDescription = self::$_arrCostCodesByCostCodeDescription;
		if (isset($arrCostCodesByCostCodeDescription) && !empty($arrCostCodesByCostCodeDescription)) {
			return $arrCostCodesByCostCodeDescription;
		}

		$cost_code_description = (string) $cost_code_description;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		//$sqlOrderBy = "\nORDER BY codes.`sort_order` ASC";
		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	codes.*

FROM `cost_codes` codes
WHERE codes.`cost_code_description` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($cost_code_description);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodesByCostCodeDescription = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id);
			/* @var $costCode CostCode */
			$arrCostCodesByCostCodeDescription[$cost_code_id] = $costCode;
		}

		$db->free_result();

		self::$_arrCostCodesByCostCodeDescription = $arrCostCodesByCostCodeDescription;

		return $arrCostCodesByCostCodeDescription;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all cost_codes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllCostCodes($database, Input $options=null)
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
			self::$_arrAllCostCodes = null;
		}

		$arrAllCostCodes = self::$_arrAllCostCodes;
		if (isset($arrAllCostCodes) && !empty($arrAllCostCodes)) {
			return $arrAllCostCodes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		//$sqlOrderBy = "\nORDER BY codes.`sort_order` ASC";
		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	codes.*

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`
{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllCostCodes = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id);
			/* @var $costCode CostCode */
			$arrAllCostCodes[$cost_code_id] = $costCode;
		}

		$db->free_result();

		self::$_arrAllCostCodes = $arrAllCostCodes;

		return $arrAllCostCodes;
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
INTO `cost_codes`
(`cost_code_division_id`, `cost_code`, `cost_code_description`, `cost_code_description_abbreviation`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `cost_code_description` = ?, `cost_code_description_abbreviation` = ?, `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->cost_code_division_id, $this->cost_code, $this->cost_code_description, $this->cost_code_description_abbreviation, $this->sort_order, $this->disabled_flag, $this->cost_code_description, $this->cost_code_description_abbreviation, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$cost_code_id = $db->insertId;
		$db->free_result();

		return $cost_code_id;
	}

	// Save: insert ignore

	/**
	 * Find sort_order value.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextCostCodeSortOrder($database, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(codes.`sort_order`) AS 'next_sort_order'
FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` ccd on codes.`cost_code_division_id` = ccd.`id`
WHERE ccd.`user_company_id` = ?
";
// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$next_sort_order = $row['next_sort_order'] + 1;
		} else {
			$next_sort_order = 0;
		}

		return $next_sort_order;
	}

	//To list the cost codes that has subcontracts
	public static function loadCostCodesByUserCompanyIdHasSubcontract($database, $user_company_id,$project_id, Input $options=null)
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
			self::$_arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = null;
		}

		$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = self::$_arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId;
		if (isset($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId) && !empty($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId)) {
			return $arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`sort_order`, codes.`sort_order`, codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	cct.`id` AS 'cct__cost_code_type_id',
	cct.`cost_code_type` AS 'cct__cost_code_type',

	codes.*

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`
	INNER JOIN `cost_code_types` cct ON codes_fk_ccd.`cost_code_type_id` = cct.`id`
	INNER JOIN `gc_budget_line_items` g on g.`cost_code_id` = codes.`id`
	INNER JOIN `subcontracts` s on s.`gc_budget_line_item_id` = g.`id`
WHERE codes_fk_ccd.user_company_id = ? and g.`project_id` =?
{$sqlOrderBy}{$sqlLimit}
";
// #AND codes_fk_ccd.cost_code_type_id = ?

		$arrValues = array($user_company_id,$project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];

			$costCode = self::instantiateOrm($database, 'CostCode', $row);
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();

			if (isset($row['codes_fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['codes_fk_ccd__cost_code_division_id'];
				$row['id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			if (isset($row['cct__cost_code_type_id'])) {
				$cost_code_type_id = $row['cct__cost_code_type_id'];
				$row['id'] = $cost_code_type_id;
				$costCodeType = self::instantiateOrm($database, 'CostCodeType', $row, null, $cost_code_type_id, 'cct__');
				/* @var $costCodeType CostCodeType */
				$costCodeType->convertPropertiesToData();
			} else {
				$costCodeType = false;
			}
			$costCode->setCostCodeType($costCodeType);

			$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId[$cost_code_type_id][$cost_code_id] = $costCode;
		}
		$db->free_result();

		return $arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId;
	}

	/**
	 * Load a GC Master Cost Codes list by cost_code_type_id.
	 *
	 * One GC can have many cost code lists grouped by cost_code_type
	 *
	 * @param string $database
	 * @param array $arrCostCodeIds
	 * @return mixed (single ORM object | false)
	 */
	//public static function loadCostCodesByUserCompanyIdOrganizedByCostCodeTypeId($database, $user_company_id, $cost_code_type_id)
	public static function loadCostCodesByUserCompanyIdOrganizedByCostCodeTypeId($database, $user_company_id, Input $options=null)
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
			self::$_arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = null;
		}

		$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = self::$_arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId;
		if (isset($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId) && !empty($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId)) {
			return $arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`sort_order`, codes.`sort_order`, codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	cct.`id` AS 'cct__cost_code_type_id',
	cct.`cost_code_type` AS 'cct__cost_code_type',

	codes.*

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`
	INNER JOIN `cost_code_types` cct ON codes_fk_ccd.`cost_code_type_id` = cct.`id`
WHERE codes_fk_ccd.user_company_id = ?
AND codes.`disabled_flag` = 'N'{$sqlOrderBy}{$sqlLimit}
";
// #AND codes_fk_ccd.cost_code_type_id = ?

		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];

			$costCode = self::instantiateOrm($database, 'CostCode', $row);
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();

			if (isset($row['codes_fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['codes_fk_ccd__cost_code_division_id'];
				$row['id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			if (isset($row['cct__cost_code_type_id'])) {
				$cost_code_type_id = $row['cct__cost_code_type_id'];
				$row['id'] = $cost_code_type_id;
				$costCodeType = self::instantiateOrm($database, 'CostCodeType', $row, null, $cost_code_type_id, 'cct__');
				/* @var $costCodeType CostCodeType */
				$costCodeType->convertPropertiesToData();
			} else {
				$costCodeType = false;
			}
			$costCode->setCostCodeType($costCodeType);

			$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId[$cost_code_type_id][$cost_code_id] = $costCode;
		}
		$db->free_result();

		return $arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId;
	}

	public static function loadCostCodesByContactIdAndContactCompanyId($database, $contact_id, $contact_company_id)
	{
		$contact_company_id = (int) $contact_company_id;
		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		//$sqlOrderBy = '';
		$sqlOrderBy = "\nORDER BY codes_fk_ccd__cost_code_division_id ASC, cost_code ASC";
		$sqlLimit = '';

		$query =
"
(SELECT

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	codes.*

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`

	INNER JOIN `subcontractor_trades` st ON codes.`id` = st.`cost_code_id`
WHERE st.contact_company_id = ?)

UNION

(SELECT

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	codes.*

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`

	INNER JOIN `gc_budget_line_items` gbli ON codes.`id` = gbli.`cost_code_id`
	INNER JOIN `subcontractor_bids` sb ON gbli.`id` = sb.`gc_budget_line_item_id`
WHERE sb.subcontractor_contact_id = ?){$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($contact_company_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodesByContactCompanyId = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];

			$costCode = self::instantiateOrm($database, 'CostCode', $row);
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();

			if (isset($row['codes_fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['codes_fk_ccd__cost_code_division_id'];
				$row['id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			$arrCostCodesByContactCompanyId[$cost_code_id] = $costCode;
		}
		$db->free_result();

		return $arrCostCodesByContactCompanyId;
	}

	public static function loadCostCodesByProjectId($database, $project_id, Input $options=null)
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
			//self::$_arrCostCodesByProjectId = null;
		}

		//$arrCostCodesByProjectId = self::$_arrCostCodesByProjectId;
		if (isset($arrCostCodesByProjectId) && !empty($arrCostCodesByProjectId)) {
			return $arrCostCodesByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	codes.*

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`

	INNER JOIN `gc_budget_line_items` gbli ON codes.`id` = gbli.`cost_code_id`
WHERE gbli.project_id = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodesByProjectId = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];

			$costCode = self::instantiateOrm($database, 'CostCode', $row);
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();

			if (isset($row['codes_fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['codes_fk_ccd__cost_code_division_id'];
				$row['id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			$arrCostCodesByProjectId[$cost_code_id] = $costCode;
		}

		$db->free_result();

		return $arrCostCodesByProjectId;
	}

	public static function loadCostCodesByUserCompanyIdAndCostCodeTypeId($database, $user_company_id, $cost_code_type_id, Input $options=null)
	{
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`sort_order`, codes.`sort_order`, codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		//$sqlLimit = "\nLIMIT 40";
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

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	cct.`id` AS 'cct__cost_code_type_id',
	cct.`cost_code_type` AS 'cct__cost_code_type',

	codes.*

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`
	INNER JOIN `cost_code_types` cct ON codes_fk_ccd.`cost_code_type_id` = cct.`id`
WHERE codes_fk_ccd.user_company_id = ?
AND codes_fk_ccd.`cost_code_type_id` = ?
AND codes.`disabled_flag` = 'N'{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($user_company_id, $cost_code_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodesByUserCompanyIdAndCostCodeTypeId = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];

			$costCode = self::instantiateOrm($database, 'CostCode', $row);
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();

			if (isset($row['codes_fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['codes_fk_ccd__cost_code_division_id'];
				$row['codes_fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			if (isset($row['cct__cost_code_type_id'])) {
				$cost_code_type_id = $row['cct__cost_code_type_id'];
				$row['cct__id'] = $cost_code_type_id;
				$costCodeType = self::instantiateOrm($database, 'CostCodeType', $row, null, $cost_code_type_id, 'cct__');
				/* @var $costCodeType CostCodeType */
				$costCodeType->convertPropertiesToData();
			} else {
				$costCodeType = false;
			}
			$costCode->setCostCodeType($costCodeType);

			$arrCostCodesByUserCompanyIdAndCostCodeTypeId[$cost_code_id] = $costCode;
		}
		$db->free_result();

		return $arrCostCodesByUserCompanyIdAndCostCodeTypeId;
	}

	public static function loadCostCodesByUserCompanyIdAndCostCodeTypeIdCustomize($database, $user_company_id, $cost_code_type_id, Input $options=null)
	{
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		// $sqlOrderBy = "\nORDER BY codes_fk_ccd.`sort_order`, codes.`sort_order`, codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		//$sqlLimit = "\nLIMIT 40";
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

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_number_group_id` AS 'codes_fk_ccd__division_number_group_id',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	cct.`id` AS 'cct__cost_code_type_id',
	cct.`cost_code_type` AS 'cct__cost_code_type',

	codes.*

FROM `cost_code_divisions` codes_fk_ccd
LEFT JOIN `cost_codes` codes ON codes.`cost_code_division_id` = codes_fk_ccd.`id` AND codes.`disabled_flag` = 'N'
INNER JOIN `cost_code_types` cct ON codes_fk_ccd.`cost_code_type_id` = cct.`id`
WHERE codes_fk_ccd.`user_company_id` = ?
AND codes_fk_ccd.`cost_code_type_id` = ?
{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($user_company_id, $cost_code_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodesByUserCompanyIdAndCostCodeTypeId = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];

			$costCode = self::instantiateOrm($database, 'CostCode', $row);
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();

			if (isset($row['codes_fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['codes_fk_ccd__cost_code_division_id'];
				$row['codes_fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			if (isset($row['cct__cost_code_type_id'])) {
				$cost_code_type_id = $row['cct__cost_code_type_id'];
				$row['cct__id'] = $cost_code_type_id;
				$costCodeType = self::instantiateOrm($database, 'CostCodeType', $row, null, $cost_code_type_id, 'cct__');
				/* @var $costCodeType CostCodeType */
				$costCodeType->convertPropertiesToData();
			} else {
				$costCodeType = false;
			}
			$costCode->setCostCodeType($costCodeType);

			$arrCostCodesByUserCompanyIdAndCostCodeTypeId[] = $costCode;
		}
		$db->free_result();

		return $arrCostCodesByUserCompanyIdAndCostCodeTypeId;
	}

//To list the project cost codes
public static function loadProjectCostCodes($database, $user_company_id,$project_id, Input $options=null)
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
			self::$_arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = null;
		}

		$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = self::$_arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId;
		if (isset($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId) && !empty($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId)) {
			return $arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		//$sqlOrderBy = "\nORDER BY codes_fk_ccd.`sort_order`, codes.`sort_order`, codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC ";

		$sqlOrderBy = "\nORDER BY codes_fk_ccd.`division_number` ASC, CAST(codes.`cost_code` AS UNSIGNED) ASC";
		
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCode = new CostCode($database);
			$sqlOrderByColumns = $tmpCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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

		//To get the project company cost code data
			$projectexistCompanyids =$user_company_id;
			$session = Zend_Registry::get('session');
			$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
			// if($user_company_id != $currentlySelectedProjectUserCompanyId)
			// {
			// $projectexistCompanyids = $currentlySelectedProjectUserCompanyId;
			// }

		 $query =
"
SELECT

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	cct.`id` AS 'cct__cost_code_type_id',
	cct.`cost_code_type` AS 'cct__cost_code_type',

	codes.*

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`
	INNER JOIN `cost_code_types` cct ON codes_fk_ccd.`cost_code_type_id` = cct.`id`
	INNER JOIN `gc_budget_line_items` g on g.`cost_code_id` = codes.`id`
	-- INNER JOIN `subcontracts` s on s.`gc_budget_line_item_id` = g.`id`
WHERE codes_fk_ccd.`user_company_id` = ? and g.`project_id` =?
{$sqlOrderBy}{$sqlLimit}
";
// #AND codes_fk_ccd.cost_code_type_id = ?

		$arrValues = array($projectexistCompanyids,$project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];

			$costCode = self::instantiateOrm($database, 'CostCode', $row);
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();

			if (isset($row['codes_fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['codes_fk_ccd__cost_code_division_id'];
				$row['id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			if (isset($row['cct__cost_code_type_id'])) {
				$cost_code_type_id = $row['cct__cost_code_type_id'];
				$row['id'] = $cost_code_type_id;
				$costCodeType = self::instantiateOrm($database, 'CostCodeType', $row, null, $cost_code_type_id, 'cct__');
				/* @var $costCodeType CostCodeType */
				$costCodeType->convertPropertiesToData();
			} else {
				$costCodeType = false;
			}
			$costCode->setCostCodeType($costCodeType);

			$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId[$cost_code_type_id][$cost_code_id] = $costCode;
		}
		$db->free_result();

		return $arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId;
	}
	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_cost_code` (`cost_code_division_id`,`cost_code`).
	 *
	 * @param string $database
	 * @param int $cost_code_division_id
	 * @param string $cost_code
	 * @return mixed (single ORM object | false)
	 */
	public static function checkDuplicateCostCode($database, $cost_code_division_id, $cost_code)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT
			codes.*

		FROM `cost_codes` codes
		WHERE codes.`cost_code_division_id` = $cost_code_division_id
		AND codes.`cost_code` = '".$cost_code."'
		";
		$db->execute($query);
		$row = $db->fetch();
		$db->free_result();
		return $row;
	}
	public static function checkDuplicateCostCodeSR($database, $cost_code)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT
			codes.*

		FROM `submittal_registry` codes
		WHERE codes.`su_cost_code_id` = '$cost_code'
		";
		$db->execute($query);
		$row = $db->fetch();
		$db->free_result();
		return $row;
	}
	public static function addCostCode($database, $user_company_id, $costCodeDivisionId, $costCodeNumber, $costCodeDescription, $costCodeAbbreviation){
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
    $nextCostCodeSortOrder = CostCode::findNextCostCodeSortOrder($database, $user_company_id);
		$query =
		"
		INSERT INTO `cost_codes`(`cost_code_division_id`, `cost_code`, `cost_code_description`, `cost_code_description_abbreviation`, `sort_order`, `disabled_flag`) VALUES
		('".$costCodeDivisionId."','".$costCodeNumber."','".$costCodeDescription."','".$costCodeAbbreviation."',
			'".$nextCostCodeSortOrder."','N')
		";
		$db->execute($query);
		$costCodeId = $db->insertId;
		$db->free_result();
		return $costCodeId;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
