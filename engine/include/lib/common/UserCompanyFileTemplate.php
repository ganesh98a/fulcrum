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
 * UserCompanyFileTemplate.
 *
 * @category   Framework
 * @package    UserCompanyFileTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class UserCompanyFileTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'UserCompanyFileTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'user_company_file_templates';

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
	 * unique index `unique_user_company_file_template` (`user_company_id`,`template_name`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_user_company_file_template' => array(
			'user_company_id' => 'int',
			'template_name' => 'string'
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
		'id' => 'user_company_file_template_id',

		'user_company_id' => 'user_company_id',

		'template_name' => 'template_name',

		'template_path' => 'template_path',
		'file_template_type' => 'file_template_type'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_company_file_template_id;

	public $user_company_id;

	public $template_name;

	public $template_path;
	public $file_template_type;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_template_name;
	public $escaped_template_path;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_template_name_nl2br;
	public $escaped_template_path_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrUserCompanyFileTemplatesByUserCompanyId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllUserCompanyFileTemplates;

	// Foreign Key Objects
	private $_userCompany;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='user_company_file_templates')
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
	public static function getArrUserCompanyFileTemplatesByUserCompanyId()
	{
		if (isset(self::$_arrUserCompanyFileTemplatesByUserCompanyId)) {
			return self::$_arrUserCompanyFileTemplatesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrUserCompanyFileTemplatesByUserCompanyId($arrUserCompanyFileTemplatesByUserCompanyId)
	{
		self::$_arrUserCompanyFileTemplatesByUserCompanyId = $arrUserCompanyFileTemplatesByUserCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllUserCompanyFileTemplates()
	{
		if (isset(self::$_arrAllUserCompanyFileTemplates)) {
			return self::$_arrAllUserCompanyFileTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllUserCompanyFileTemplates($arrAllUserCompanyFileTemplates)
	{
		self::$_arrAllUserCompanyFileTemplates = $arrAllUserCompanyFileTemplates;
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
	 * @param int $user_company_file_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $user_company_file_template_id,$table='user_company_file_templates', $module='UserCompanyFileTemplate')
	{
		$userCompanyFileTemplate = parent::findById($database, $user_company_file_template_id, $table, $module);

		return $userCompanyFileTemplate;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $user_company_file_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findUserCompanyFileTemplateByIdExtended($database, $user_company_file_template_id)
	{
		$user_company_file_template_id = (int) $user_company_file_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	ucft_fk_uc.`id` AS 'ucft_fk_uc__user_company_id',
	ucft_fk_uc.`company` AS 'ucft_fk_uc__company',
	ucft_fk_uc.`primary_phone_number` AS 'ucft_fk_uc__primary_phone_number',
	ucft_fk_uc.`employer_identification_number` AS 'ucft_fk_uc__employer_identification_number',
	ucft_fk_uc.`construction_license_number` AS 'ucft_fk_uc__construction_license_number',
	ucft_fk_uc.`construction_license_number_expiration_date` AS 'ucft_fk_uc__construction_license_number_expiration_date',
	ucft_fk_uc.`paying_customer_flag` AS 'ucft_fk_uc__paying_customer_flag',

	ucft.*

FROM `user_company_file_templates` ucft
	INNER JOIN `user_companies` ucft_fk_uc ON ucft.`user_company_id` = ucft_fk_uc.`id`
WHERE ucft.`id` = ?
";
		$arrValues = array($user_company_file_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$user_company_file_template_id = $row['id'];
			$userCompanyFileTemplate = self::instantiateOrm($database, 'UserCompanyFileTemplate', $row, null, $user_company_file_template_id);
			/* @var $userCompanyFileTemplate UserCompanyFileTemplate */
			$userCompanyFileTemplate->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['ucft_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'ucft_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$userCompanyFileTemplate->setUserCompany($userCompany);

			return $userCompanyFileTemplate;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_user_company_file_template` (`user_company_id`,`template_name`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $template_name
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndTemplateName($database, $user_company_id, $template_name)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ucft.*

FROM `user_company_file_templates` ucft
WHERE ucft.`user_company_id` = ?
AND ucft.`template_name` = ?
";
		$arrValues = array($user_company_id, $template_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$user_company_file_template_id = $row['id'];
			$userCompanyFileTemplate = self::instantiateOrm($database, 'UserCompanyFileTemplate', $row, null, $user_company_file_template_id);
			/* @var $userCompanyFileTemplate UserCompanyFileTemplate */
			return $userCompanyFileTemplate;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrUserCompanyFileTemplateIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserCompanyFileTemplatesByArrUserCompanyFileTemplateIds($database, $arrUserCompanyFileTemplateIds, Input $options=null)
	{
		if (empty($arrUserCompanyFileTemplateIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `template_name` ASC, `template_path` ASC, `file_template_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompanyFileTemplate = new UserCompanyFileTemplate($database);
			$sqlOrderByColumns = $tmpUserCompanyFileTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrUserCompanyFileTemplateIds as $k => $user_company_file_template_id) {
			$user_company_file_template_id = (int) $user_company_file_template_id;
			$arrUserCompanyFileTemplateIds[$k] = $db->escape($user_company_file_template_id);
		}
		$csvUserCompanyFileTemplateIds = join(',', $arrUserCompanyFileTemplateIds);

		$query =
"
SELECT

	ucft.*

FROM `user_company_file_templates` ucft
WHERE ucft.`id` IN ($csvUserCompanyFileTemplateIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrUserCompanyFileTemplatesByCsvUserCompanyFileTemplateIds = array();
		while ($row = $db->fetch()) {
			$user_company_file_template_id = $row['id'];
			$userCompanyFileTemplate = self::instantiateOrm($database, 'UserCompanyFileTemplate', $row, null, $user_company_file_template_id);
			/* @var $userCompanyFileTemplate UserCompanyFileTemplate */
			$userCompanyFileTemplate->convertPropertiesToData();

			$arrUserCompanyFileTemplatesByCsvUserCompanyFileTemplateIds[$user_company_file_template_id] = $userCompanyFileTemplate;
		}

		$db->free_result();

		return $arrUserCompanyFileTemplatesByCsvUserCompanyFileTemplateIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `user_company_file_templates_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserCompanyFileTemplatesByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrUserCompanyFileTemplatesByUserCompanyId = null;
		}

		$arrUserCompanyFileTemplatesByUserCompanyId = self::$_arrUserCompanyFileTemplatesByUserCompanyId;
		if (isset($arrUserCompanyFileTemplatesByUserCompanyId) && !empty($arrUserCompanyFileTemplatesByUserCompanyId)) {
			return $arrUserCompanyFileTemplatesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `template_name` ASC, `template_path` ASC, `file_template_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompanyFileTemplate = new UserCompanyFileTemplate($database);
			$sqlOrderByColumns = $tmpUserCompanyFileTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

		//To check whether current company has Subcontractor templates if not load  default template
		$query = "SELECT count(*) as count FROM `user_company_file_templates` ucft WHERE ucft.`user_company_id` = ? and file_template_type= ?";
		$arrValues = array($user_company_id,'Subcontract Item');
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$rowcount = $db->fetch();
		$companycount = $rowcount['count'];
		if($companycount == 0)
		{
			$user_company_id=1; //For fetching Default template
		}
		$db->free_result();


		$query =
"
SELECT
	ucft.*

FROM `user_company_file_templates` ucft
WHERE ucft.`user_company_id` = ? and file_template_type= ? {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `template_name` ASC, `template_path` ASC, `file_template_type` ASC
		$arrValues = array($user_company_id,'Subcontract Item');
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserCompanyFileTemplatesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$user_company_file_template_id = $row['id'];
			$userCompanyFileTemplate = self::instantiateOrm($database, 'UserCompanyFileTemplate', $row, null, $user_company_file_template_id);
			/* @var $userCompanyFileTemplate UserCompanyFileTemplate */
			$arrUserCompanyFileTemplatesByUserCompanyId[$user_company_file_template_id] = $userCompanyFileTemplate;
		}

		$db->free_result();

		self::$_arrUserCompanyFileTemplatesByUserCompanyId = $arrUserCompanyFileTemplatesByUserCompanyId;

		return $arrUserCompanyFileTemplatesByUserCompanyId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all user_company_file_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllUserCompanyFileTemplates($database, Input $options=null)
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
			self::$_arrAllUserCompanyFileTemplates = null;
		}

		$arrAllUserCompanyFileTemplates = self::$_arrAllUserCompanyFileTemplates;
		if (isset($arrAllUserCompanyFileTemplates) && !empty($arrAllUserCompanyFileTemplates)) {
			return $arrAllUserCompanyFileTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `template_name` ASC, `template_path` ASC, `file_template_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompanyFileTemplate = new UserCompanyFileTemplate($database);
			$sqlOrderByColumns = $tmpUserCompanyFileTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ucft.*

FROM `user_company_file_templates` ucft{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `template_name` ASC, `template_path` ASC, `file_template_type` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllUserCompanyFileTemplates = array();
		while ($row = $db->fetch()) {
			$user_company_file_template_id = $row['id'];
			$userCompanyFileTemplate = self::instantiateOrm($database, 'UserCompanyFileTemplate', $row, null, $user_company_file_template_id);
			/* @var $userCompanyFileTemplate UserCompanyFileTemplate */
			$arrAllUserCompanyFileTemplates[$user_company_file_template_id] = $userCompanyFileTemplate;
		}

		$db->free_result();

		self::$_arrAllUserCompanyFileTemplates = $arrAllUserCompanyFileTemplates;

		return $arrAllUserCompanyFileTemplates;
	}

	public static function getUserTemplatePath($database,$user_company_id,$type)
	{
		$db = DBI::getInstance($database);
		$query = " SELECT template_path FROM `user_company_file_templates` where user_company_id= ? and file_template_type= ?";
		$arrValues = array($user_company_id,$type);
		$db->execute($query,$arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		if($row)
		{
			$template_path = $row['template_path'];
			
		}else
		{
			$db->free_result();
			$query1 = " SELECT template_path FROM `user_company_file_templates` where user_company_id= ? and file_template_type= ?";
			$arrValues = array('1',$type);
			$db->execute($query1,$arrValues, MYSQLI_USE_RESULT);
			$row1 = $db->fetch();
			$template_path = $row1['template_path'];
			$db->free_result();
		}
		return $template_path;

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
INTO `user_company_file_templates`
(`user_company_id`, `template_name`, `template_path`, `file_template_type`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `template_path` = ?, `file_template_type` = ?
";
		$arrValues = array($this->user_company_id, $this->template_name, $this->template_path, $this->file_template_type, $this->template_path, $this->file_template_type);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$user_company_file_template_id = $db->insertId;
		$db->free_result();

		return $user_company_file_template_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
