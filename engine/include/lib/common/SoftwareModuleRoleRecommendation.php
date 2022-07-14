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
 * SoftwareModuleRoleRecommendation.
 *
 * @category   Framework
 * @package    SoftwareModuleRoleRecommendation
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SoftwareModuleRoleRecommendation extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SoftwareModuleRoleRecommendation';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'software_module_role_recommendations';

	/**
	 * primary key (`software_module_id`,`recommended_role_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'software_module_id' => 'int',
		'recommended_role_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_software_module_role_recommendation_via_primary_key' => array(
			'software_module_id' => 'int',
			'recommended_role_id' => 'int'
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
		'software_module_id' => 'software_module_id',
		'recommended_role_id' => 'recommended_role_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $software_module_id;
	public $recommended_role_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSoftwareModuleRoleRecommendationsBySoftwareModuleId;
	protected static $_arrSoftwareModuleRoleRecommendationsByRecommendedRoleId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSoftwareModuleRoleRecommendations;

	// Foreign Key Objects
	private $_softwareModule;
	private $_recommendedRole;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='software_module_role_recommendations')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSoftwareModule()
	{
		if (isset($this->_softwareModule)) {
			return $this->_softwareModule;
		} else {
			return null;
		}
	}

	public function setSoftwareModule($softwareModule)
	{
		$this->_softwareModule = $softwareModule;
	}

	public function getRecommendedRole()
	{
		if (isset($this->_recommendedRole)) {
			return $this->_recommendedRole;
		} else {
			return null;
		}
	}

	public function setRecommendedRole($recommendedRole)
	{
		$this->_recommendedRole = $recommendedRole;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSoftwareModuleRoleRecommendationsBySoftwareModuleId()
	{
		if (isset(self::$_arrSoftwareModuleRoleRecommendationsBySoftwareModuleId)) {
			return self::$_arrSoftwareModuleRoleRecommendationsBySoftwareModuleId;
		} else {
			return null;
		}
	}

	public static function setArrSoftwareModuleRoleRecommendationsBySoftwareModuleId($arrSoftwareModuleRoleRecommendationsBySoftwareModuleId)
	{
		self::$_arrSoftwareModuleRoleRecommendationsBySoftwareModuleId = $arrSoftwareModuleRoleRecommendationsBySoftwareModuleId;
	}

	public static function getArrSoftwareModuleRoleRecommendationsByRecommendedRoleId()
	{
		if (isset(self::$_arrSoftwareModuleRoleRecommendationsByRecommendedRoleId)) {
			return self::$_arrSoftwareModuleRoleRecommendationsByRecommendedRoleId;
		} else {
			return null;
		}
	}

	public static function setArrSoftwareModuleRoleRecommendationsByRecommendedRoleId($arrSoftwareModuleRoleRecommendationsByRecommendedRoleId)
	{
		self::$_arrSoftwareModuleRoleRecommendationsByRecommendedRoleId = $arrSoftwareModuleRoleRecommendationsByRecommendedRoleId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSoftwareModuleRoleRecommendations()
	{
		if (isset(self::$_arrAllSoftwareModuleRoleRecommendations)) {
			return self::$_arrAllSoftwareModuleRoleRecommendations;
		} else {
			return null;
		}
	}

	public static function setArrAllSoftwareModuleRoleRecommendations($arrAllSoftwareModuleRoleRecommendations)
	{
		self::$_arrAllSoftwareModuleRoleRecommendations = $arrAllSoftwareModuleRoleRecommendations;
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
	 * Find by primary key (`software_module_id`,`recommended_role_id`).
	 *
	 * @param string $database
	 * @param int $software_module_id
	 * @param int $recommended_role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySoftwareModuleIdAndRecommendedRoleId($database, $software_module_id, $recommended_role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	smrr.*

FROM `software_module_role_recommendations` smrr
WHERE smrr.`software_module_id` = ?
AND smrr.`recommended_role_id` = ?
";
		$arrValues = array($software_module_id, $recommended_role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$softwareModuleRoleRecommendation = self::instantiateOrm($database, 'SoftwareModuleRoleRecommendation', $row);
			/* @var $softwareModuleRoleRecommendation SoftwareModuleRoleRecommendation */
			return $softwareModuleRoleRecommendation;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`software_module_id`,`recommended_role_id`) Extended.
	 *
	 * @param string $database
	 * @param int $software_module_id
	 * @param int $recommended_role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySoftwareModuleIdAndRecommendedRoleIdExtended($database, $software_module_id, $recommended_role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	smrr_fk_sm.`id` AS 'smrr_fk_sm__software_module_id',
	smrr_fk_sm.`software_module_category_id` AS 'smrr_fk_sm__software_module_category_id',
	smrr_fk_sm.`software_module` AS 'smrr_fk_sm__software_module',
	smrr_fk_sm.`software_module_label` AS 'smrr_fk_sm__software_module_label',
	smrr_fk_sm.`software_module_description` AS 'smrr_fk_sm__software_module_description',
	smrr_fk_sm.`default_software_module_url` AS 'smrr_fk_sm__default_software_module_url',
	smrr_fk_sm.`hard_coded_flag` AS 'smrr_fk_sm__hard_coded_flag',
	smrr_fk_sm.`global_admin_only_flag` AS 'smrr_fk_sm__global_admin_only_flag',
	smrr_fk_sm.`purchased_module_flag` AS 'smrr_fk_sm__purchased_module_flag',
	smrr_fk_sm.`customer_configurable_flag` AS 'smrr_fk_sm__customer_configurable_flag',
	smrr_fk_sm.`allow_ad_hoc_contact_permissions_flag` AS 'smrr_fk_sm__allow_ad_hoc_contact_permissions_flag',
	smrr_fk_sm.`project_specific_flag` AS 'smrr_fk_sm__project_specific_flag',
	smrr_fk_sm.`disabled_flag` AS 'smrr_fk_sm__disabled_flag',
	smrr_fk_sm.`sort_order` AS 'smrr_fk_sm__sort_order',

	smrr_fk_r.`id` AS 'smrr_fk_r__role_id',
	smrr_fk_r.`role` AS 'smrr_fk_r__role',
	smrr_fk_r.`role_description` AS 'smrr_fk_r__role_description',
	smrr_fk_r.`project_specific_flag` AS 'smrr_fk_r__project_specific_flag',
	smrr_fk_r.`sort_order` AS 'smrr_fk_r__sort_order',

	smrr.*

FROM `software_module_role_recommendations` smrr
	INNER JOIN `software_modules` smrr_fk_sm ON smrr.`software_module_id` = smrr_fk_sm.`id`
	INNER JOIN `roles` smrr_fk_r ON smrr.`recommended_role_id` = smrr_fk_r.`id`
WHERE smrr.`software_module_id` = ?
AND smrr.`recommended_role_id` = ?
";
		$arrValues = array($software_module_id, $recommended_role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$softwareModuleRoleRecommendation = self::instantiateOrm($database, 'SoftwareModuleRoleRecommendation', $row);
			/* @var $softwareModuleRoleRecommendation SoftwareModuleRoleRecommendation */
			$softwareModuleRoleRecommendation->convertPropertiesToData();

			if (isset($row['software_module_id'])) {
				$software_module_id = $row['software_module_id'];
				$row['smrr_fk_sm__id'] = $software_module_id;
				$softwareModule = self::instantiateOrm($database, 'SoftwareModule', $row, null, $software_module_id, 'smrr_fk_sm__');
				/* @var $softwareModule SoftwareModule */
				$softwareModule->convertPropertiesToData();
			} else {
				$softwareModule = false;
			}
			$softwareModuleRoleRecommendation->setSoftwareModule($softwareModule);

			if (isset($row['recommended_role_id'])) {
				$recommended_role_id = $row['recommended_role_id'];
				$row['smrr_fk_r__id'] = $recommended_role_id;
				$recommendedRole = self::instantiateOrm($database, 'Role', $row, null, $recommended_role_id, 'smrr_fk_r__');
				/* @var $recommendedRole Role */
				$recommendedRole->convertPropertiesToData();
			} else {
				$recommendedRole = false;
			}
			$softwareModuleRoleRecommendation->setRecommendedRole($recommendedRole);

			return $softwareModuleRoleRecommendation;
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
	 * @param array $arrSoftwareModuleIdAndRecommendedRoleIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModuleRoleRecommendationsByArrSoftwareModuleIdAndRecommendedRoleIdList($database, $arrSoftwareModuleIdAndRecommendedRoleIdList, Input $options=null)
	{
		if (empty($arrSoftwareModuleIdAndRecommendedRoleIdList)) {
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
		// ORDER BY `software_module_id` ASC, `recommended_role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleRoleRecommendation = new SoftwareModuleRoleRecommendation($database);
			$sqlOrderByColumns = $tmpSoftwareModuleRoleRecommendation->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrSoftwareModuleIdAndRecommendedRoleIdList as $k => $arrTmp) {
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
		if (count($arrSoftwareModuleIdAndRecommendedRoleIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	smrr.*

FROM `software_module_role_recommendations` smrr
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleRoleRecommendationsByArrSoftwareModuleIdAndRecommendedRoleIdList = array();
		while ($row = $db->fetch()) {
			$softwareModuleRoleRecommendation = self::instantiateOrm($database, 'SoftwareModuleRoleRecommendation', $row);
			/* @var $softwareModuleRoleRecommendation SoftwareModuleRoleRecommendation */
			$arrSoftwareModuleRoleRecommendationsByArrSoftwareModuleIdAndRecommendedRoleIdList[] = $softwareModuleRoleRecommendation;
		}

		$db->free_result();

		return $arrSoftwareModuleRoleRecommendationsByArrSoftwareModuleIdAndRecommendedRoleIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `software_module_role_recommendations_fk_sm` foreign key (`software_module_id`) references `software_modules` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $software_module_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModuleRoleRecommendationsBySoftwareModuleId($database, $software_module_id, Input $options=null)
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
			self::$_arrSoftwareModuleRoleRecommendationsBySoftwareModuleId = null;
		}

		$arrSoftwareModuleRoleRecommendationsBySoftwareModuleId = self::$_arrSoftwareModuleRoleRecommendationsBySoftwareModuleId;
		if (isset($arrSoftwareModuleRoleRecommendationsBySoftwareModuleId) && !empty($arrSoftwareModuleRoleRecommendationsBySoftwareModuleId)) {
			return $arrSoftwareModuleRoleRecommendationsBySoftwareModuleId;
		}

		$software_module_id = (int) $software_module_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `software_module_id` ASC, `recommended_role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleRoleRecommendation = new SoftwareModuleRoleRecommendation($database);
			$sqlOrderByColumns = $tmpSoftwareModuleRoleRecommendation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	smrr.*

FROM `software_module_role_recommendations` smrr
WHERE smrr.`software_module_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `software_module_id` ASC, `recommended_role_id` ASC
		$arrValues = array($software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleRoleRecommendationsBySoftwareModuleId = array();
		while ($row = $db->fetch()) {
			$softwareModuleRoleRecommendation = self::instantiateOrm($database, 'SoftwareModuleRoleRecommendation', $row);
			/* @var $softwareModuleRoleRecommendation SoftwareModuleRoleRecommendation */
			$arrSoftwareModuleRoleRecommendationsBySoftwareModuleId[] = $softwareModuleRoleRecommendation;
		}

		$db->free_result();

		self::$_arrSoftwareModuleRoleRecommendationsBySoftwareModuleId = $arrSoftwareModuleRoleRecommendationsBySoftwareModuleId;

		return $arrSoftwareModuleRoleRecommendationsBySoftwareModuleId;
	}

	/**
	 * Load by constraint `software_module_role_recommendations_fk_r` foreign key (`recommended_role_id`) references `roles` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $recommended_role_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModuleRoleRecommendationsByRecommendedRoleId($database, $recommended_role_id, Input $options=null)
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
			self::$_arrSoftwareModuleRoleRecommendationsByRecommendedRoleId = null;
		}

		$arrSoftwareModuleRoleRecommendationsByRecommendedRoleId = self::$_arrSoftwareModuleRoleRecommendationsByRecommendedRoleId;
		if (isset($arrSoftwareModuleRoleRecommendationsByRecommendedRoleId) && !empty($arrSoftwareModuleRoleRecommendationsByRecommendedRoleId)) {
			return $arrSoftwareModuleRoleRecommendationsByRecommendedRoleId;
		}

		$recommended_role_id = (int) $recommended_role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `software_module_id` ASC, `recommended_role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleRoleRecommendation = new SoftwareModuleRoleRecommendation($database);
			$sqlOrderByColumns = $tmpSoftwareModuleRoleRecommendation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	smrr.*

FROM `software_module_role_recommendations` smrr
WHERE smrr.`recommended_role_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `software_module_id` ASC, `recommended_role_id` ASC
		$arrValues = array($recommended_role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleRoleRecommendationsByRecommendedRoleId = array();
		while ($row = $db->fetch()) {
			$softwareModuleRoleRecommendation = self::instantiateOrm($database, 'SoftwareModuleRoleRecommendation', $row);
			/* @var $softwareModuleRoleRecommendation SoftwareModuleRoleRecommendation */
			$arrSoftwareModuleRoleRecommendationsByRecommendedRoleId[] = $softwareModuleRoleRecommendation;
		}

		$db->free_result();

		self::$_arrSoftwareModuleRoleRecommendationsByRecommendedRoleId = $arrSoftwareModuleRoleRecommendationsByRecommendedRoleId;

		return $arrSoftwareModuleRoleRecommendationsByRecommendedRoleId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all software_module_role_recommendations records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSoftwareModuleRoleRecommendations($database, Input $options=null)
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
			self::$_arrAllSoftwareModuleRoleRecommendations = null;
		}

		$arrAllSoftwareModuleRoleRecommendations = self::$_arrAllSoftwareModuleRoleRecommendations;
		if (isset($arrAllSoftwareModuleRoleRecommendations) && !empty($arrAllSoftwareModuleRoleRecommendations)) {
			return $arrAllSoftwareModuleRoleRecommendations;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `software_module_id` ASC, `recommended_role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleRoleRecommendation = new SoftwareModuleRoleRecommendation($database);
			$sqlOrderByColumns = $tmpSoftwareModuleRoleRecommendation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	smrr.*

FROM `software_module_role_recommendations` smrr{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `software_module_id` ASC, `recommended_role_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSoftwareModuleRoleRecommendations = array();
		while ($row = $db->fetch()) {
			$softwareModuleRoleRecommendation = self::instantiateOrm($database, 'SoftwareModuleRoleRecommendation', $row);
			/* @var $softwareModuleRoleRecommendation SoftwareModuleRoleRecommendation */
			$arrAllSoftwareModuleRoleRecommendations[] = $softwareModuleRoleRecommendation;
		}

		$db->free_result();

		self::$_arrAllSoftwareModuleRoleRecommendations = $arrAllSoftwareModuleRoleRecommendations;

		return $arrAllSoftwareModuleRoleRecommendations;
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
INTO `software_module_role_recommendations`
(`software_module_id`, `recommended_role_id`)
VALUES (?, ?)
";
		$arrValues = array($this->software_module_id, $this->recommended_role_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
