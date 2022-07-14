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
 * SubcontractTemplate.
 *
 * @category   Framework
 * @package    SubcontractTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontract_templates';

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
	 * unique index `unique_subcontract_template` (`subcontract_template_name`,`user_company_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontract_template' => array(
			'subcontract_template_name' => 'string',
			'user_company_id' => 'int'
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
		'id' => 'subcontract_template_id',

		'user_company_id' => 'user_company_id',

		'subcontract_type_id' => 'subcontract_type_id',

		'subcontract_template_name' => 'subcontract_template_name',
		'sort_order' => 'sort_order',
		'is_trackable' =>'is_trackable',
		'is_purchased' =>'is_purchased',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontract_template_id;

	public $user_company_id;

	public $subcontract_type_id;

	public $subcontract_template_name;
	public $sort_order;
	public $is_trackable;
	public $is_purchased;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_subcontract_template_name;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_subcontract_template_name_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubcontractTemplatesByUserCompanyId;
	protected static $_arrSubcontractTemplatesBySubcontractTypeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrSubcontractTemplatesBySubcontractTemplateName;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractTemplates;

	// Foreign Key Objects
	private $_userCompany;
	private $_subcontractType;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontract_templates')
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

	public function getSubcontractType()
	{
		if (isset($this->_subcontractType)) {
			return $this->_subcontractType;
		} else {
			return null;
		}
	}

	public function setSubcontractType($subcontractType)
	{
		$this->_subcontractType = $subcontractType;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubcontractTemplatesByUserCompanyId()
	{
		if (isset(self::$_arrSubcontractTemplatesByUserCompanyId)) {
			return self::$_arrSubcontractTemplatesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractTemplatesByUserCompanyId($arrSubcontractTemplatesByUserCompanyId)
	{
		self::$_arrSubcontractTemplatesByUserCompanyId = $arrSubcontractTemplatesByUserCompanyId;
	}

	public static function getArrSubcontractTemplatesBySubcontractTypeId()
	{
		if (isset(self::$_arrSubcontractTemplatesBySubcontractTypeId)) {
			return self::$_arrSubcontractTemplatesBySubcontractTypeId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractTemplatesBySubcontractTypeId($arrSubcontractTemplatesBySubcontractTypeId)
	{
		self::$_arrSubcontractTemplatesBySubcontractTypeId = $arrSubcontractTemplatesBySubcontractTypeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrSubcontractTemplatesBySubcontractTemplateName()
	{
		if (isset(self::$_arrSubcontractTemplatesBySubcontractTemplateName)) {
			return self::$_arrSubcontractTemplatesBySubcontractTemplateName;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractTemplatesBySubcontractTemplateName($arrSubcontractTemplatesBySubcontractTemplateName)
	{
		self::$_arrSubcontractTemplatesBySubcontractTemplateName = $arrSubcontractTemplatesBySubcontractTemplateName;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractTemplates()
	{
		if (isset(self::$_arrAllSubcontractTemplates)) {
			return self::$_arrAllSubcontractTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractTemplates($arrAllSubcontractTemplates)
	{
		self::$_arrAllSubcontractTemplates = $arrAllSubcontractTemplates;
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
	 * @param int $subcontract_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $subcontract_template_id,$table='subcontract_templates', $module='SubcontractTemplate')
	{
		$subcontractTemplate = parent::findById($database, $subcontract_template_id, $table, $module);

		return $subcontractTemplate;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $subcontract_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubcontractTemplateByIdExtended($database, $subcontract_template_id)
	{
		$subcontract_template_id = (int) $subcontract_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	st_fk_uc.`id` AS 'st_fk_uc__user_company_id',
	st_fk_uc.`company` AS 'st_fk_uc__company',
	st_fk_uc.`primary_phone_number` AS 'st_fk_uc__primary_phone_number',
	st_fk_uc.`employer_identification_number` AS 'st_fk_uc__employer_identification_number',
	st_fk_uc.`construction_license_number` AS 'st_fk_uc__construction_license_number',
	st_fk_uc.`construction_license_number_expiration_date` AS 'st_fk_uc__construction_license_number_expiration_date',
	st_fk_uc.`paying_customer_flag` AS 'st_fk_uc__paying_customer_flag',

	st_fk_stypes.`id` AS 'st_fk_stypes__subcontract_type_id',
	st_fk_stypes.`subcontract_type` AS 'st_fk_stypes__subcontract_type',
	st_fk_stypes.`disabled_flag` AS 'st_fk_stypes__disabled_flag',

	st.*

FROM `subcontract_templates` st
	INNER JOIN `user_companies` st_fk_uc ON st.`user_company_id` = st_fk_uc.`id`
	INNER JOIN `subcontract_types` st_fk_stypes ON st.`subcontract_type_id` = st_fk_stypes.`id`
WHERE st.`id` = ?
";
		$arrValues = array($subcontract_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$subcontract_template_id = $row['id'];
			$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id);
			/* @var $subcontractTemplate SubcontractTemplate */
			$subcontractTemplate->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['st_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'st_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$subcontractTemplate->setUserCompany($userCompany);

			if (isset($row['subcontract_type_id'])) {
				$subcontract_type_id = $row['subcontract_type_id'];
				$row['st_fk_stypes__id'] = $subcontract_type_id;
				$subcontractType = self::instantiateOrm($database, 'SubcontractType', $row, null, $subcontract_type_id, 'st_fk_stypes__');
				/* @var $subcontractType SubcontractType */
				$subcontractType->convertPropertiesToData();
			} else {
				$subcontractType = false;
			}
			$subcontractTemplate->setSubcontractType($subcontractType);

			return $subcontractTemplate;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_subcontract_template` (`subcontract_template_name`,`user_company_id`).
	 *
	 * @param string $database
	 * @param string $subcontract_template_name
	 * @param int $user_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubcontractTemplateNameAndUserCompanyId($database, $subcontract_template_name, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	st.*

FROM `subcontract_templates` st
WHERE st.`subcontract_template_name` = ?
AND st.`user_company_id` = ?
";
		$arrValues = array($subcontract_template_name, $user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$subcontract_template_id = $row['id'];
			$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id);
			/* @var $subcontractTemplate SubcontractTemplate */
			return $subcontractTemplate;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubcontractTemplateIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractTemplatesByArrSubcontractTemplateIds($database, $arrSubcontractTemplateIds, Input $options=null)
	{
		if (empty($arrSubcontractTemplateIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `subcontract_type_id` ASC, `subcontract_template_name` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY st.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractTemplate = new SubcontractTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubcontractTemplateIds as $k => $subcontract_template_id) {
			$subcontract_template_id = (int) $subcontract_template_id;
			$arrSubcontractTemplateIds[$k] = $db->escape($subcontract_template_id);
		}
		$csvSubcontractTemplateIds = join(',', $arrSubcontractTemplateIds);

		$query =
"
SELECT

	st.*

FROM `subcontract_templates` st
WHERE st.`id` IN ($csvSubcontractTemplateIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubcontractTemplatesByCsvSubcontractTemplateIds = array();
		while ($row = $db->fetch()) {
			$subcontract_template_id = $row['id'];
			$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id);
			/* @var $subcontractTemplate SubcontractTemplate */
			$subcontractTemplate->convertPropertiesToData();

			$arrSubcontractTemplatesByCsvSubcontractTemplateIds[$subcontract_template_id] = $subcontractTemplate;
		}

		$db->free_result();

		return $arrSubcontractTemplatesByCsvSubcontractTemplateIds;
	}

	//To check whether subcontract template is linked to any subcontracts

	public static function checkforSubcontractTemplateLinkwithSubcontacts($database, $subcontract_template_id)
	{
			
		$db = DBI::getInstance($database);	
		$query ="SELECT * FROM `subcontract_templates` as st inner join subcontracts as s on s.subcontract_template_id = st.id where st.id= ? ";
		$arrValues = array($subcontract_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		if($row)
		{
			$retval='0';
		}else
		{
			$retval='1';
		}
		$db->free_result();
		return $retval;
		
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `subcontract_templates_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractTemplatesByUserCompanyId($database, $user_company_id,$currentlyActiveContactId=null, Input $options=null)
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
			self::$_arrSubcontractTemplatesByUserCompanyId = null;
		}

		$arrSubcontractTemplatesByUserCompanyId = self::$_arrSubcontractTemplatesByUserCompanyId;
		if (isset($arrSubcontractTemplatesByUserCompanyId) && !empty($arrSubcontractTemplatesByUserCompanyId)) {
			return $arrSubcontractTemplatesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `subcontract_type_id` ASC, `subcontract_template_name` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY st.`sort_order` + 1 ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractTemplate = new SubcontractTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
		//Fulcrum global admin
		$config = Zend_Registry::get('config');
   		$fulcrum_user = $config->system->fulcrum_user;
   		//End of fulcrum global admin
			$companyQuery = "SELECT email FROM users where primary_contact_id='$currentlyActiveContactId'  limit 1 ";
   			$db->execute($companyQuery);
   	 		$row = $db->fetch();
   	 		$user_email=$row['email'];
     		$db->free_result();
     		if($user_email == $fulcrum_user)
     		{
     			$globalAccess="OR (st.`user_company_id` = '1')";
     		}else
     		{
     			$globalAccess="";
     		}
		$query =
"
SELECT
	st.*,
	sctype.subcontract_type
FROM `subcontract_templates` st
	INNER JOIN subcontract_types sctype ON st.subcontract_type_id = sctype.`id`
WHERE st.`user_company_id` = ? $globalAccess {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `subcontract_type_id` ASC, `subcontract_template_name` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractTemplatesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$subcontract_template_id = $row['id'];
			$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id);
			/* @var $subcontractTemplate SubcontractTemplate */
			$arrSubcontractTemplatesByUserCompanyId[$subcontract_template_id] = $subcontractTemplate;
		}

		$db->free_result();

		self::$_arrSubcontractTemplatesByUserCompanyId = $arrSubcontractTemplatesByUserCompanyId;

		return $arrSubcontractTemplatesByUserCompanyId;
	}

	/**
	 * Load by constraint `subcontract_templates_fk_stypes` foreign key (`subcontract_type_id`) references `subcontract_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractTemplatesBySubcontractTypeId($database, $subcontract_type_id, Input $options=null)
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
			self::$_arrSubcontractTemplatesBySubcontractTypeId = null;
		}

		$arrSubcontractTemplatesBySubcontractTypeId = self::$_arrSubcontractTemplatesBySubcontractTypeId;
		if (isset($arrSubcontractTemplatesBySubcontractTypeId) && !empty($arrSubcontractTemplatesBySubcontractTypeId)) {
			return $arrSubcontractTemplatesBySubcontractTypeId;
		}

		$subcontract_type_id = (int) $subcontract_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `subcontract_type_id` ASC, `subcontract_template_name` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY st.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractTemplate = new SubcontractTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	st.*

FROM `subcontract_templates` st
WHERE st.`subcontract_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `subcontract_type_id` ASC, `subcontract_template_name` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($subcontract_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractTemplatesBySubcontractTypeId = array();
		while ($row = $db->fetch()) {
			$subcontract_template_id = $row['id'];
			$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id);
			/* @var $subcontractTemplate SubcontractTemplate */
			$arrSubcontractTemplatesBySubcontractTypeId[$subcontract_template_id] = $subcontractTemplate;
		}

		$db->free_result();

		self::$_arrSubcontractTemplatesBySubcontractTypeId = $arrSubcontractTemplatesBySubcontractTypeId;

		return $arrSubcontractTemplatesBySubcontractTypeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: unique index `unique_subcontract_template` (`subcontract_template_name`,`user_company_id`).
	 *
	 * @param string $database
	 * @param string $subcontract_template_name
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractTemplatesBySubcontractTemplateName($database, $subcontract_template_name, Input $options=null)
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
			self::$_arrSubcontractTemplatesBySubcontractTemplateName = null;
		}

		$arrSubcontractTemplatesBySubcontractTemplateName = self::$_arrSubcontractTemplatesBySubcontractTemplateName;
		if (isset($arrSubcontractTemplatesBySubcontractTemplateName) && !empty($arrSubcontractTemplatesBySubcontractTemplateName)) {
			return $arrSubcontractTemplatesBySubcontractTemplateName;
		}

		$subcontract_template_name = (string) $subcontract_template_name;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `subcontract_type_id` ASC, `subcontract_template_name` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY st.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractTemplate = new SubcontractTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	st.*

FROM `subcontract_templates` st
WHERE st.`subcontract_template_name` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `subcontract_type_id` ASC, `subcontract_template_name` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($subcontract_template_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractTemplatesBySubcontractTemplateName = array();
		while ($row = $db->fetch()) {
			$subcontract_template_id = $row['id'];
			$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id);
			/* @var $subcontractTemplate SubcontractTemplate */
			$arrSubcontractTemplatesBySubcontractTemplateName[$subcontract_template_id] = $subcontractTemplate;
		}

		$db->free_result();

		self::$_arrSubcontractTemplatesBySubcontractTemplateName = $arrSubcontractTemplatesBySubcontractTemplateName;

		return $arrSubcontractTemplatesBySubcontractTemplateName;
	}

	// Loaders: Load All Records
	/**
	 * Load all subcontract_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractTemplates($database, Input $options=null)
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
			self::$_arrAllSubcontractTemplates = null;
		}

		$arrAllSubcontractTemplates = self::$_arrAllSubcontractTemplates;
		if (isset($arrAllSubcontractTemplates) && !empty($arrAllSubcontractTemplates)) {
			return $arrAllSubcontractTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `subcontract_type_id` ASC, `subcontract_template_name` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY st.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractTemplate = new SubcontractTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	st.*

FROM `subcontract_templates` st{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `subcontract_type_id` ASC, `subcontract_template_name` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractTemplates = array();
		while ($row = $db->fetch()) {
			$subcontract_template_id = $row['id'];
			$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id);
			/* @var $subcontractTemplate SubcontractTemplate */
			$arrAllSubcontractTemplates[$subcontract_template_id] = $subcontractTemplate;
		}

		$db->free_result();

		self::$_arrAllSubcontractTemplates = $arrAllSubcontractTemplates;

		return $arrAllSubcontractTemplates;
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
INTO `subcontract_templates`
(`user_company_id`, `subcontract_type_id`, `subcontract_template_name`, `sort_order`,`is_trackable`,`is_purchased`, `disabled_flag`)
VALUES (?, ?, ?, ?, ?, ? ,?)
ON DUPLICATE KEY UPDATE `subcontract_type_id` = ?, `sort_order` = ?,`is_trackable`=?,`is_purchased`=?, `disabled_flag` = ?
";
		$arrValues = array($this->user_company_id, $this->subcontract_type_id, $this->subcontract_template_name, $this->sort_order,$this->is_trackable,$this->is_purchased, $this->disabled_flag, $this->subcontract_type_id, $this->sort_order,$this->is_trackable,$this->is_purchased, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$subcontract_template_id = $db->insertId;
		$db->free_result();

		return $subcontract_template_id;
	}

	// Save: insert ignore

	public static function setNaturalSortOrderOnSubcontractTemplatesByUserCompanyId($database, $user_company_id, $original_subcontract_template_id)
	{
		$user_company_id = (int) $user_company_id;
		$original_subcontract_template_id = (int) $original_subcontract_template_id;

		$loadSubcontractTemplatesByUserCompanyIdOptions = new Input();
		$loadSubcontractTemplatesByUserCompanyIdOptions->forceLoadFlag = true;

		$arrSubcontractTemplatesByUserCompanyId = SubcontractTemplate::loadSubcontractTemplatesByUserCompanyId($database, $user_company_id, $loadSubcontractTemplatesByUserCompanyIdOptions);
		$i = 0;
		foreach ($arrSubcontractTemplatesByUserCompanyId as $subcontract_template_id => $subcontractItemTemplate) {
			/* @var $subcontractItemTemplate SubcontractTemplate */

			if ($subcontractItemTemplate->sort_order != $i) {
				$data = array('sort_order' => $i);
				$subcontractItemTemplate->setData($data);
				$subcontractItemTemplate->save();
			}

			// Get the original sort_order value after updating to sane values
			if ($subcontractItemTemplate->subcontract_template_id == $original_subcontract_template_id) {
				$original_sort_order = $i;
			}

			$i++;
		}

		return $original_sort_order;
	}

	public function updateSortOrder($database, $new_sort_order)
	{
		$user_company_id = $this->user_company_id;
		$new_sort_order = (int) $new_sort_order;

		// @todo Conditionally update sort_order based on table meta-data
		$original_sort_order = SubcontractTemplate::setNaturalSortOrderOnSubcontractTemplatesByUserCompanyId($database, $user_company_id, $this->subcontract_template_id);

		if ($new_sort_order > $original_sort_order) {
			$movedDown = true;
			$movedUp = false;
		} elseif ($new_sort_order < $original_sort_order) {
			$movedDown = false;
			$movedUp = true;
		} else {
			// Same sort_order
			// Default to Moved Down
			$movedDown = true;
			$movedUp = false;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		if ($movedDown) {
			$query =
"
UPDATE `subcontract_templates`
SET `sort_order` = (`sort_order`-1)
WHERE `user_company_id` = ?
AND `sort_order` > ?
AND `sort_order` <= ?
";
			$arrValues = array($this->user_company_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		} elseif ($movedUp) {
			$query =
"
UPDATE `subcontract_templates`
SET `sort_order` = (`sort_order`+1)
WHERE `user_company_id` = ?
AND `sort_order` < ?
AND `sort_order` >= ?
";
			$arrValues = array($this->user_company_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		$db->commit();
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
