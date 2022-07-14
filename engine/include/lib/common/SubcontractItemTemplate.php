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
 * SubcontractItemTemplate.
 *
 * @category   Framework
 * @package    SubcontractItemTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractItemTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractItemTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontract_item_templates';

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
	 * unique index `unique_subcontract_item_template` (`user_company_id`,`subcontract_item`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontract_item_template' => array(
			'user_company_id' => 'int',
			'subcontract_item' => 'string',
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
		'id' => 'subcontract_item_template_id',

		'user_company_id' => 'user_company_id',
		'file_manager_file_id' => 'file_manager_file_id',
		'user_company_file_template_id' => 'user_company_file_template_id',

		'subcontract_item' => 'subcontract_item',

		'subcontract_item_abbreviation' => 'subcontract_item_abbreviation',
		'subcontract_item_template_type' => 'subcontract_item_template_type',
		'sort_order' => 'sort_order',
		'is_trackable' =>'is_trackable',
		'updated_by' =>'updated_by',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontract_item_template_id;

	public $user_company_id;
	public $file_manager_file_id;
	public $user_company_file_template_id;

	public $subcontract_item;

	public $subcontract_item_abbreviation;
	public $subcontract_item_template_type;
	public $sort_order;
	public $is_trackable;
	public $updated_by;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;
	public $subcontract_document_sort_order;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_subcontract_item;
	public $escaped_subcontract_item_abbreviation;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_subcontract_item_nl2br;
	public $escaped_subcontract_item_abbreviation_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubcontractItemTemplatesByUserCompanyId;
	protected static $_arrSubcontractItemTemplatesByFileManagerFileId;
	protected static $_arrSubcontractItemTemplatesByUserCompanyFileTemplateId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractItemTemplates;
	protected static $_arrSubcontractItemTemplatesBySubcontractTemplateId;

	protected static $_arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId;

	// Foreign Key Objects
	private $_userCompany;
	private $_fileManagerFile;
	private $_userCompanyFileTemplate;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontract_item_templates')
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

	public function getFileManagerFile()
	{
		if (isset($this->_fileManagerFile)) {
			return $this->_fileManagerFile;
		} else {
			return null;
		}
	}

	public function setFileManagerFile($fileManagerFile)
	{
		$this->_fileManagerFile = $fileManagerFile;
	}

	public function getUserCompanyFileTemplate()
	{
		if (isset($this->_userCompanyFileTemplate)) {
			return $this->_userCompanyFileTemplate;
		} else {
			return null;
		}
	}

	public function setUserCompanyFileTemplate($userCompanyFileTemplate)
	{
		$this->_userCompanyFileTemplate = $userCompanyFileTemplate;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubcontractItemTemplatesByUserCompanyId()
	{
		if (isset(self::$_arrSubcontractItemTemplatesByUserCompanyId)) {
			return self::$_arrSubcontractItemTemplatesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractItemTemplatesByUserCompanyId($arrSubcontractItemTemplatesByUserCompanyId)
	{
		self::$_arrSubcontractItemTemplatesByUserCompanyId = $arrSubcontractItemTemplatesByUserCompanyId;
	}

	public static function getArrSubcontractItemTemplatesByFileManagerFileId()
	{
		if (isset(self::$_arrSubcontractItemTemplatesByFileManagerFileId)) {
			return self::$_arrSubcontractItemTemplatesByFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractItemTemplatesByFileManagerFileId($arrSubcontractItemTemplatesByFileManagerFileId)
	{
		self::$_arrSubcontractItemTemplatesByFileManagerFileId = $arrSubcontractItemTemplatesByFileManagerFileId;
	}

	public static function getArrSubcontractItemTemplatesByUserCompanyFileTemplateId()
	{
		if (isset(self::$_arrSubcontractItemTemplatesByUserCompanyFileTemplateId)) {
			return self::$_arrSubcontractItemTemplatesByUserCompanyFileTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractItemTemplatesByUserCompanyFileTemplateId($arrSubcontractItemTemplatesByUserCompanyFileTemplateId)
	{
		self::$_arrSubcontractItemTemplatesByUserCompanyFileTemplateId = $arrSubcontractItemTemplatesByUserCompanyFileTemplateId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractItemTemplates()
	{
		if (isset(self::$_arrAllSubcontractItemTemplates)) {
			return self::$_arrAllSubcontractItemTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractItemTemplates($arrAllSubcontractItemTemplates)
	{
		self::$_arrAllSubcontractItemTemplates = $arrAllSubcontractItemTemplates;
	}

	public static function getArrSubcontractItemTemplatesBySubcontractTemplateId()
	{
		if (isset(self::$_arrSubcontractItemTemplatesBySubcontractTemplateId)) {
			return self::$_arrSubcontractItemTemplatesBySubcontractTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractItemTemplatesBySubcontractTemplateId($arrSubcontractItemTemplatesBySubcontractTemplateId)
	{
		self::$_arrSubcontractItemTemplatesBySubcontractTemplateId = $arrSubcontractItemTemplatesBySubcontractTemplateId;
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
	 * @param int $subcontract_item_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $subcontract_item_template_id,$table='subcontract_item_templates', $module='SubcontractItemTemplate')
	{
		$subcontractItemTemplate = parent::findById($database, $subcontract_item_template_id,$table, $module);

		return $subcontractItemTemplate;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $subcontract_item_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubcontractItemTemplateByIdExtended($database, $subcontract_item_template_id)
	{
		$subcontract_item_template_id = (int) $subcontract_item_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sit_fk_uc.`id` AS 'sit_fk_uc__user_company_id',
	sit_fk_uc.`company` AS 'sit_fk_uc__company',
	sit_fk_uc.`primary_phone_number` AS 'sit_fk_uc__primary_phone_number',
	sit_fk_uc.`employer_identification_number` AS 'sit_fk_uc__employer_identification_number',
	sit_fk_uc.`construction_license_number` AS 'sit_fk_uc__construction_license_number',
	sit_fk_uc.`construction_license_number_expiration_date` AS 'sit_fk_uc__construction_license_number_expiration_date',
	sit_fk_uc.`paying_customer_flag` AS 'sit_fk_uc__paying_customer_flag',

	sit_fk_fmfiles.`id` AS 'sit_fk_fmfiles__file_manager_file_id',
	sit_fk_fmfiles.`user_company_id` AS 'sit_fk_fmfiles__user_company_id',
	sit_fk_fmfiles.`contact_id` AS 'sit_fk_fmfiles__contact_id',
	sit_fk_fmfiles.`project_id` AS 'sit_fk_fmfiles__project_id',
	sit_fk_fmfiles.`file_manager_folder_id` AS 'sit_fk_fmfiles__file_manager_folder_id',
	sit_fk_fmfiles.`file_location_id` AS 'sit_fk_fmfiles__file_location_id',
	sit_fk_fmfiles.`virtual_file_name` AS 'sit_fk_fmfiles__virtual_file_name',
	sit_fk_fmfiles.`version_number` AS 'sit_fk_fmfiles__version_number',
	sit_fk_fmfiles.`virtual_file_name_sha1` AS 'sit_fk_fmfiles__virtual_file_name_sha1',
	sit_fk_fmfiles.`virtual_file_mime_type` AS 'sit_fk_fmfiles__virtual_file_mime_type',
	sit_fk_fmfiles.`modified` AS 'sit_fk_fmfiles__modified',
	sit_fk_fmfiles.`created` AS 'sit_fk_fmfiles__created',
	sit_fk_fmfiles.`deleted_flag` AS 'sit_fk_fmfiles__deleted_flag',
	sit_fk_fmfiles.`directly_deleted_flag` AS 'sit_fk_fmfiles__directly_deleted_flag',

	sit_fk_ucft.`id` AS 'sit_fk_ucft__user_company_file_template_id',
	sit_fk_ucft.`user_company_id` AS 'sit_fk_ucft__user_company_id',
	sit_fk_ucft.`template_name` AS 'sit_fk_ucft__template_name',
	sit_fk_ucft.`template_path` AS 'sit_fk_ucft__template_path',
	sit_fk_ucft.`file_template_type` AS 'sit_fk_ucft__file_template_type',

	sit.*

FROM `subcontract_item_templates` sit
	INNER JOIN `user_companies` sit_fk_uc ON sit.`user_company_id` = sit_fk_uc.`id`
	LEFT OUTER JOIN `file_manager_files` sit_fk_fmfiles ON sit.`file_manager_file_id` = sit_fk_fmfiles.`id`
	LEFT OUTER JOIN `user_company_file_templates` sit_fk_ucft ON sit.`user_company_file_template_id` = sit_fk_ucft.`id`
WHERE sit.`id` = ?
";
		$arrValues = array($subcontract_item_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$subcontract_item_template_id = $row['id'];
			$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id);
			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			$subcontractItemTemplate->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['sit_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'sit_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$subcontractItemTemplate->setUserCompany($userCompany);

			if (isset($row['file_manager_file_id'])) {
				$file_manager_file_id = $row['file_manager_file_id'];
				$row['sit_fk_fmfiles__id'] = $file_manager_file_id;
				$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id, 'sit_fk_fmfiles__');
				/* @var $fileManagerFile FileManagerFile */
				$fileManagerFile->convertPropertiesToData();
			} else {
				$fileManagerFile = false;
			}
			$subcontractItemTemplate->setFileManagerFile($fileManagerFile);

			if (isset($row['user_company_file_template_id'])) {
				$user_company_file_template_id = $row['user_company_file_template_id'];
				$row['sit_fk_ucft__id'] = $user_company_file_template_id;
				$userCompanyFileTemplate = self::instantiateOrm($database, 'UserCompanyFileTemplate', $row, null, $user_company_file_template_id, 'sit_fk_ucft__');
				/* @var $userCompanyFileTemplate UserCompanyFileTemplate */
				$userCompanyFileTemplate->convertPropertiesToData();
			} else {
				$userCompanyFileTemplate = false;
			}
			$subcontractItemTemplate->setUserCompanyFileTemplate($userCompanyFileTemplate);

			return $subcontractItemTemplate;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_subcontract_item_template` (`user_company_id`,`subcontract_item`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $subcontract_item
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndSubcontractItem($database, $user_company_id, $subcontract_item)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sit.*

FROM `subcontract_item_templates` sit
WHERE sit.`user_company_id` = ?
AND sit.`subcontract_item` = ?
";
		$arrValues = array($user_company_id, $subcontract_item);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$subcontract_item_template_id = $row['id'];
			$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id);
			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			return $subcontractItemTemplate;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubcontractItemTemplateIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractItemTemplatesByArrSubcontractItemTemplateIds($database, $arrSubcontractItemTemplateIds, Input $options=null)
	{
		if (empty($arrSubcontractItemTemplateIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY sit.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractItemTemplate = new SubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubcontractItemTemplateIds as $k => $subcontract_item_template_id) {
			$subcontract_item_template_id = (int) $subcontract_item_template_id;
			$arrSubcontractItemTemplateIds[$k] = $db->escape($subcontract_item_template_id);
		}
		$csvSubcontractItemTemplateIds = join(',', $arrSubcontractItemTemplateIds);

		$query =
"
SELECT

	sit.*

FROM `subcontract_item_templates` sit
WHERE sit.`id` IN ($csvSubcontractItemTemplateIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubcontractItemTemplatesByCsvSubcontractItemTemplateIds = array();
		while ($row = $db->fetch()) {
			$subcontract_item_template_id = $row['id'];
			$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id);
			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			$subcontractItemTemplate->convertPropertiesToData();

			$arrSubcontractItemTemplatesByCsvSubcontractItemTemplateIds[$subcontract_item_template_id] = $subcontractItemTemplate;
		}

		$db->free_result();

		return $arrSubcontractItemTemplatesByCsvSubcontractItemTemplateIds;
	}

	// For contracking dynamic headers
	public static function loadSubcontractItemTemplatesDefault($database, $user_company_id, Input $options=null)
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
			self::$_arrSubcontractItemTemplatesByUserCompanyId = null;
		}

		$arrSubcontractItemTemplatesByUserCompanyId = self::$_arrSubcontractItemTemplatesByUserCompanyId;
		if (isset($arrSubcontractItemTemplatesByUserCompanyId) && !empty($arrSubcontractItemTemplatesByUserCompanyId)) {
			return $arrSubcontractItemTemplatesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY sit.`sort_order`+0 ASC, ISNULL(st2sit.sort_order) ASC, st2sit.sort_order+0 ASC, subcontract_item ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractItemTemplate = new SubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

 // $query =
	// "
	// SELECT
	// sit.*
 //
	// FROM `subcontract_item_templates` sit
	// LEFT OUTER JOIN subcontract_templates_to_subcontract_item_templates st2sit ON sit.`id` = st2sit.subcontract_item_template_id
	// WHERE st2sit.`contract_track`='Y' and sit.`user_company_id` =?  ORDER BY `sit`.`sort_order` ASC";
	$query ="
			SELECT sit.* FROM `subcontract_templates_to_subcontract_item_templates` ss
		INNER JOIN `subcontract_templates` st ON st.id = ss.`subcontract_template_id`
		INNER JOIN `subcontract_item_templates` sit ON sit.id = ss.`subcontract_item_template_id`
		WHERE ss.`contract_track`='Y'
		AND st.`user_company_id`=?  ORDER BY `ss`.`sort_order` ASC";
	/*
	ORDER BY
	CASE
		WHEN st2sit.sort_order is not null then sit.sort_order
		WHEN st2sit.sort_order is null then sit.subcontract_item
		ELSE sit.`id` END
*/
// ORDER BY ISNULL(st2sit.sort_order) ASC, st2sit.sort_order+0 ASC, subcontract_item ASC

// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query,$arrValues);

		$arrSubcontractItemTemplatesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$subcontract_item_template_id = $row['id'];
			$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id);
			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			$arrSubcontractItemTemplatesByUserCompanyId[$subcontract_item_template_id] = $subcontractItemTemplate;
		}

		$db->free_result();

		// self::$_arrSubcontractItemTemplatesByUserCompanyId = $arrSubcontractItemTemplatesByUserCompanyId;

		return $arrSubcontractItemTemplatesByUserCompanyId;
	
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `subcontract_item_templates_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractItemTemplatesByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrSubcontractItemTemplatesByUserCompanyId = null;
		}

		$arrSubcontractItemTemplatesByUserCompanyId = self::$_arrSubcontractItemTemplatesByUserCompanyId;
		if (isset($arrSubcontractItemTemplatesByUserCompanyId) && !empty($arrSubcontractItemTemplatesByUserCompanyId)) {
			// return $arrSubcontractItemTemplatesByUserCompanyId; //also to display usercompany with 1
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY sit.`sort_order`+0 ASC, ISNULL(st2sit.sort_order) ASC, st2sit.sort_order+0 ASC, subcontract_item ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractItemTemplate = new SubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sit.*

FROM `subcontract_item_templates` sit
	LEFT OUTER JOIN subcontract_templates_to_subcontract_item_templates st2sit ON sit.`id` = st2sit.subcontract_item_template_id
WHERE (sit.`user_company_id` = ? ) and sit.`is_purchased` ='N' {$sqlOrderBy}{$sqlLimit}
";

/*
ORDER BY
	CASE
		WHEN st2sit.sort_order is not null then sit.sort_order
		WHEN st2sit.sort_order is null then sit.subcontract_item
		ELSE sit.`id` END
*/
// ORDER BY ISNULL(st2sit.sort_order) ASC, st2sit.sort_order+0 ASC, subcontract_item ASC

// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractItemTemplatesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$subcontract_item_template_id = $row['id'];
			$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id);
			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			$arrSubcontractItemTemplatesByUserCompanyId[$subcontract_item_template_id] = $subcontractItemTemplate;
		}

		$db->free_result();

		self::$_arrSubcontractItemTemplatesByUserCompanyId = $arrSubcontractItemTemplatesByUserCompanyId;

		return $arrSubcontractItemTemplatesByUserCompanyId;
	}

	/**
	 * Load by constraint `subcontract_item_templates_fk_fmfiles` foreign key (`file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractItemTemplatesByFileManagerFileId($database, $file_manager_file_id, Input $options=null)
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
			self::$_arrSubcontractItemTemplatesByFileManagerFileId = null;
		}

		$arrSubcontractItemTemplatesByFileManagerFileId = self::$_arrSubcontractItemTemplatesByFileManagerFileId;
		if (isset($arrSubcontractItemTemplatesByFileManagerFileId) && !empty($arrSubcontractItemTemplatesByFileManagerFileId)) {
			return $arrSubcontractItemTemplatesByFileManagerFileId;
		}

		$file_manager_file_id = (int) $file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY sit.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractItemTemplate = new SubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sit.*

FROM `subcontract_item_templates` sit
WHERE sit.`file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractItemTemplatesByFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$subcontract_item_template_id = $row['id'];
			$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id);
			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			$arrSubcontractItemTemplatesByFileManagerFileId[$subcontract_item_template_id] = $subcontractItemTemplate;
		}

		$db->free_result();

		self::$_arrSubcontractItemTemplatesByFileManagerFileId = $arrSubcontractItemTemplatesByFileManagerFileId;

		return $arrSubcontractItemTemplatesByFileManagerFileId;
	}

	/**
	 * Load by constraint `subcontract_item_templates_fk_ucft` foreign key (`user_company_file_template_id`) references `user_company_file_templates` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_file_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractItemTemplatesByUserCompanyFileTemplateId($database, $user_company_file_template_id, Input $options=null)
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
			self::$_arrSubcontractItemTemplatesByUserCompanyFileTemplateId = null;
		}

		$arrSubcontractItemTemplatesByUserCompanyFileTemplateId = self::$_arrSubcontractItemTemplatesByUserCompanyFileTemplateId;
		if (isset($arrSubcontractItemTemplatesByUserCompanyFileTemplateId) && !empty($arrSubcontractItemTemplatesByUserCompanyFileTemplateId)) {
			return $arrSubcontractItemTemplatesByUserCompanyFileTemplateId;
		}

		$user_company_file_template_id = (int) $user_company_file_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY sit.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractItemTemplate = new SubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sit.*

FROM `subcontract_item_templates` sit
WHERE sit.`user_company_file_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_file_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractItemTemplatesByUserCompanyFileTemplateId = array();
		while ($row = $db->fetch()) {
			$subcontract_item_template_id = $row['id'];
			$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id);
			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			$arrSubcontractItemTemplatesByUserCompanyFileTemplateId[$subcontract_item_template_id] = $subcontractItemTemplate;
		}

		$db->free_result();

		self::$_arrSubcontractItemTemplatesByUserCompanyFileTemplateId = $arrSubcontractItemTemplatesByUserCompanyFileTemplateId;

		return $arrSubcontractItemTemplatesByUserCompanyFileTemplateId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all subcontract_item_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractItemTemplates($database, Input $options=null)
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
			self::$_arrAllSubcontractItemTemplates = null;
		}

		$arrAllSubcontractItemTemplates = self::$_arrAllSubcontractItemTemplates;
		if (isset($arrAllSubcontractItemTemplates) && !empty($arrAllSubcontractItemTemplates)) {
			return $arrAllSubcontractItemTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY sit.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractItemTemplate = new SubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sit.*

FROM `subcontract_item_templates` sit{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractItemTemplates = array();
		while ($row = $db->fetch()) {
			$subcontract_item_template_id = $row['id'];
			$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id);
			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			$arrAllSubcontractItemTemplates[$subcontract_item_template_id] = $subcontractItemTemplate;
		}

		$db->free_result();

		self::$_arrAllSubcontractItemTemplates = $arrAllSubcontractItemTemplates;

		return $arrAllSubcontractItemTemplates;
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
INTO `subcontract_item_templates`
(`user_company_id`, `file_manager_file_id`, `user_company_file_template_id`, `subcontract_item`, `subcontract_item_abbreviation`, `subcontract_item_template_type`, `sort_order`,`is_trackable`,`updated_by`, `disabled_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ? ,?)
ON DUPLICATE KEY UPDATE `file_manager_file_id` = ?, `user_company_file_template_id` = ?, `subcontract_item_abbreviation` = ?, `subcontract_item_template_type` = ?, `sort_order` = ?, `is_trackable` =?,`updated_by`=?, `disabled_flag` = ?
";
		$arrValues = array($this->user_company_id, $this->file_manager_file_id, $this->user_company_file_template_id, $this->subcontract_item, $this->subcontract_item_abbreviation, $this->subcontract_item_template_type, $this->sort_order, $this->disabled_flag, $this->file_manager_file_id, $this->user_company_file_template_id, $this->subcontract_item_abbreviation, $this->subcontract_item_template_type, $this->sort_order,$this->is_trackable,$this->updated_by, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$subcontract_item_template_id = $db->insertId;
		$db->free_result();

		return $subcontract_item_template_id;
	}

	// Save: insert ignore

	/**
	 * Load by `subcontract_template_id` via `subcontract_templates_to_subcontract_item_templates` relationship table.
	 *
	 * @param string $database
	 * @param int $subcontract_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id, Input $options=null)
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
			self::$_arrSubcontractItemTemplatesBySubcontractTemplateId = null;
		}

		$arrSubcontractItemTemplatesBySubcontractTemplateId = self::$_arrSubcontractItemTemplatesBySubcontractTemplateId;
		if (isset($arrSubcontractItemTemplatesBySubcontractTemplateId) && !empty($arrSubcontractItemTemplatesBySubcontractTemplateId)) {
			return $arrSubcontractItemTemplatesBySubcontractTemplateId;
		}

		$subcontract_template_id = (int) $subcontract_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY st2sit.`sort_order`";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractItemTemplate = new SubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

	sit_fk_uc.`id` AS 'sit_fk_uc__user_company_id',
	sit_fk_uc.`company` AS 'sit_fk_uc__company',
	sit_fk_uc.`primary_phone_number` AS 'sit_fk_uc__primary_phone_number',
	sit_fk_uc.`employer_identification_number` AS 'sit_fk_uc__employer_identification_number',
	sit_fk_uc.`construction_license_number` AS 'sit_fk_uc__construction_license_number',
	sit_fk_uc.`construction_license_number_expiration_date` AS 'sit_fk_uc__construction_license_number_expiration_date',
	sit_fk_uc.`paying_customer_flag` AS 'sit_fk_uc__paying_customer_flag',

	sit_fk_fmfiles.`id` AS 'sit_fk_fmfiles__file_manager_file_id',
	sit_fk_fmfiles.`user_company_id` AS 'sit_fk_fmfiles__user_company_id',
	sit_fk_fmfiles.`contact_id` AS 'sit_fk_fmfiles__contact_id',
	sit_fk_fmfiles.`project_id` AS 'sit_fk_fmfiles__project_id',
	sit_fk_fmfiles.`file_manager_folder_id` AS 'sit_fk_fmfiles__file_manager_folder_id',
	sit_fk_fmfiles.`file_location_id` AS 'sit_fk_fmfiles__file_location_id',
	sit_fk_fmfiles.`virtual_file_name` AS 'sit_fk_fmfiles__virtual_file_name',
	sit_fk_fmfiles.`version_number` AS 'sit_fk_fmfiles__version_number',
	sit_fk_fmfiles.`virtual_file_name_sha1` AS 'sit_fk_fmfiles__virtual_file_name_sha1',
	sit_fk_fmfiles.`virtual_file_mime_type` AS 'sit_fk_fmfiles__virtual_file_mime_type',
	sit_fk_fmfiles.`modified` AS 'sit_fk_fmfiles__modified',
	sit_fk_fmfiles.`created` AS 'sit_fk_fmfiles__created',
	sit_fk_fmfiles.`deleted_flag` AS 'sit_fk_fmfiles__deleted_flag',
	sit_fk_fmfiles.`directly_deleted_flag` AS 'sit_fk_fmfiles__directly_deleted_flag',

	sit_fk_ucft.`id` AS 'sit_fk_ucft__user_company_file_template_id',
	sit_fk_ucft.`user_company_id` AS 'sit_fk_ucft__user_company_id',
	sit_fk_ucft.`template_name` AS 'sit_fk_ucft__template_name',
	sit_fk_ucft.`template_path` AS 'sit_fk_ucft__template_path',
	sit_fk_ucft.`file_template_type` AS 'sit_fk_ucft__file_template_type',

	sit.*,

	st2sit.`sort_order` AS 'subcontract_document_sort_order'

FROM `subcontract_item_templates` sit
	INNER JOIN `user_companies` sit_fk_uc ON sit.`user_company_id` = sit_fk_uc.`id`
	LEFT OUTER JOIN `file_manager_files` sit_fk_fmfiles ON sit.`file_manager_file_id` = sit_fk_fmfiles.`id`
	LEFT OUTER JOIN `user_company_file_templates` sit_fk_ucft ON sit.`user_company_file_template_id` = sit_fk_ucft.`id`

	INNER JOIN `subcontract_templates_to_subcontract_item_templates` st2sit ON sit.`id` = st2sit.`subcontract_item_template_id`
WHERE st2sit.`subcontract_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($subcontract_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractItemTemplatesBySubcontractTemplateId = array();
		while ($row = $db->fetch()) {
			$subcontract_item_template_id = $row['id'];
			$subcontract_document_sort_order = $row['subcontract_document_sort_order'];
			$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id);
			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			$subcontractItemTemplate->convertPropertiesToData();
			$subcontractItemTemplate->subcontract_document_sort_order = $subcontract_document_sort_order;

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['sit_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'sit_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$subcontractItemTemplate->setUserCompany($userCompany);

			if (isset($row['file_manager_file_id'])) {
				$file_manager_file_id = $row['file_manager_file_id'];
				$row['sit_fk_fmfiles__id'] = $file_manager_file_id;
				$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id, 'sit_fk_fmfiles__');
				/* @var $fileManagerFile FileManagerFile */
				$fileManagerFile->convertPropertiesToData();
			} else {
				$fileManagerFile = false;
			}
			$subcontractItemTemplate->setFileManagerFile($fileManagerFile);

			if (isset($row['user_company_file_template_id'])) {
				$user_company_file_template_id = $row['user_company_file_template_id'];
				$row['sit_fk_ucft__id'] = $user_company_file_template_id;
				$userCompanyFileTemplate = self::instantiateOrm($database, 'UserCompanyFileTemplate', $row, null, $user_company_file_template_id, 'sit_fk_ucft__');
				/* @var $userCompanyFileTemplate UserCompanyFileTemplate */
				$userCompanyFileTemplate->convertPropertiesToData();
			} else {
				$userCompanyFileTemplate = false;
			}
			$subcontractItemTemplate->setUserCompanyFileTemplate($userCompanyFileTemplate);

			$arrSubcontractItemTemplatesBySubcontractTemplateId[$subcontract_item_template_id] = $subcontractItemTemplate;
		}

		$db->free_result();

		self::$_arrSubcontractItemTemplatesBySubcontractTemplateId = $arrSubcontractItemTemplatesBySubcontractTemplateId;

		return $arrSubcontractItemTemplatesBySubcontractTemplateId;
	}

	/**
	 * Load by `subcontract_template_id`,
	 * (`subcontract_item_template_type`= 'Immutable Static Subcontract Document'
	 *	OR
	 * `subcontract_item_template_type`= 'By Project Static Subcontract Document')
	 *
	 * @param string $database
	 * @param int $subcontract_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId($database, $subcontract_template_id, Input $options=null)
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
			self::$_arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId = null;
		}

		$arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId = self::$_arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId;
		if (isset($arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId) && !empty($arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId)) {
			return $arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId;
		}

		$subcontract_template_id = (int) $subcontract_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY ISNULL(st2sit.`sort_order`) ASC, st2sit.`sort_order`+0 ASC, `subcontract_item` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractItemTemplate = new SubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

	sit_fk_uc.`id` AS 'sit_fk_uc__user_company_id',
	sit_fk_uc.`company` AS 'sit_fk_uc__company',
	sit_fk_uc.`primary_phone_number` AS 'sit_fk_uc__primary_phone_number',
	sit_fk_uc.`employer_identification_number` AS 'sit_fk_uc__employer_identification_number',
	sit_fk_uc.`construction_license_number` AS 'sit_fk_uc__construction_license_number',
	sit_fk_uc.`construction_license_number_expiration_date` AS 'sit_fk_uc__construction_license_number_expiration_date',
	sit_fk_uc.`paying_customer_flag` AS 'sit_fk_uc__paying_customer_flag',

	sit_fk_fmfiles.`id` AS 'sit_fk_fmfiles__file_manager_file_id',
	sit_fk_fmfiles.`user_company_id` AS 'sit_fk_fmfiles__user_company_id',
	sit_fk_fmfiles.`contact_id` AS 'sit_fk_fmfiles__contact_id',
	sit_fk_fmfiles.`project_id` AS 'sit_fk_fmfiles__project_id',
	sit_fk_fmfiles.`file_manager_folder_id` AS 'sit_fk_fmfiles__file_manager_folder_id',
	sit_fk_fmfiles.`file_location_id` AS 'sit_fk_fmfiles__file_location_id',
	sit_fk_fmfiles.`virtual_file_name` AS 'sit_fk_fmfiles__virtual_file_name',
	sit_fk_fmfiles.`version_number` AS 'sit_fk_fmfiles__version_number',
	sit_fk_fmfiles.`virtual_file_name_sha1` AS 'sit_fk_fmfiles__virtual_file_name_sha1',
	sit_fk_fmfiles.`virtual_file_mime_type` AS 'sit_fk_fmfiles__virtual_file_mime_type',
	sit_fk_fmfiles.`modified` AS 'sit_fk_fmfiles__modified',
	sit_fk_fmfiles.`created` AS 'sit_fk_fmfiles__created',
	sit_fk_fmfiles.`deleted_flag` AS 'sit_fk_fmfiles__deleted_flag',
	sit_fk_fmfiles.`directly_deleted_flag` AS 'sit_fk_fmfiles__directly_deleted_flag',

	sit_fk_ucft.`id` AS 'sit_fk_ucft__user_company_file_template_id',
	sit_fk_ucft.`user_company_id` AS 'sit_fk_ucft__user_company_id',
	sit_fk_ucft.`template_name` AS 'sit_fk_ucft__template_name',
	sit_fk_ucft.`template_path` AS 'sit_fk_ucft__template_path',
	sit_fk_ucft.`file_template_type` AS 'sit_fk_ucft__file_template_type',

	sit.*,

	st2sit.`sort_order` AS 'subcontract_document_sort_order'

FROM `subcontract_item_templates` sit
	INNER JOIN `user_companies` sit_fk_uc ON sit.`user_company_id` = sit_fk_uc.`id`
	LEFT OUTER JOIN `file_manager_files` sit_fk_fmfiles ON sit.`file_manager_file_id` = sit_fk_fmfiles.`id`
	LEFT OUTER JOIN `user_company_file_templates` sit_fk_ucft ON sit.`user_company_file_template_id` = sit_fk_ucft.`id`

	INNER JOIN `subcontract_templates_to_subcontract_item_templates` st2sit ON sit.`id` = st2sit.`subcontract_item_template_id`
WHERE st2sit.`subcontract_template_id` = ?
AND sit.`subcontract_item_template_type` IN ('Immutable Static Subcontract Document', 'By Project Static Subcontract Document'){$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC

/*
ORDER BY
	CASE
		WHEN st2sit.sort_order is not null then sit.sort_order
		WHEN st2sit.sort_order is null then sit.subcontract_item
		ELSE sit.`id` END
*/
// ORDER BY ISNULL(st2sit.sort_order) ASC, st2sit.sort_order+0 ASC, subcontract_item ASC

// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `disabled_flag` ASC
		$arrValues = array($subcontract_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId = array();
		while ($row = $db->fetch()) {
			$subcontract_item_template_id = $row['id'];
			$subcontract_document_sort_order = $row['subcontract_document_sort_order'];
			$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id);
			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			$subcontractItemTemplate->convertPropertiesToData();
			$subcontractItemTemplate->subcontract_document_sort_order = $subcontract_document_sort_order;

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['sit_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'sit_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$subcontractItemTemplate->setUserCompany($userCompany);

			if (isset($row['file_manager_file_id'])) {
				$file_manager_file_id = $row['file_manager_file_id'];
				$row['sit_fk_fmfiles__id'] = $file_manager_file_id;
				$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id, 'sit_fk_fmfiles__');
				/* @var $fileManagerFile FileManagerFile */
				$fileManagerFile->convertPropertiesToData();
			} else {
				$fileManagerFile = false;
			}
			$subcontractItemTemplate->setFileManagerFile($fileManagerFile);

			if (isset($row['user_company_file_template_id'])) {
				$user_company_file_template_id = $row['user_company_file_template_id'];
				$row['sit_fk_ucft__id'] = $user_company_file_template_id;
				$userCompanyFileTemplate = self::instantiateOrm($database, 'UserCompanyFileTemplate', $row, null, $user_company_file_template_id, 'sit_fk_ucft__');
				/* @var $userCompanyFileTemplate UserCompanyFileTemplate */
				$userCompanyFileTemplate->convertPropertiesToData();
			} else {
				$userCompanyFileTemplate = false;
			}
			$subcontractItemTemplate->setUserCompanyFileTemplate($userCompanyFileTemplate);

			$arrSubcontractItemTemplatesByUserCompanyId[$id] = $subcontractItemTemplate;
		}

		$db->free_result();

		self::$_arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId = $arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId;

		return $arrSubcontractItemTemplateStaticDocumentsBySubcontractTemplateId;
	}

	public static function loadSubcontractItemTemplateTypes()
	{
		$arrSubcontractItemTemplateTypes = array(
			'Immutable Static Subcontract Document' => 'Immutable Static Subcontract Document',
			'By Project Static Subcontract Document' => 'By Project Static Subcontract Document',
			'File Uploaded During Subcontract Creation' => 'File Uploaded During Subcontract Creation',
			'Dynamic Template File' => 'Dynamic Template File'
		);

		return $arrSubcontractItemTemplateTypes;


		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$query =
"
SHOW COLUMNS
FROM subcontract_item_templates
WHERE FIELD = 'subcontract_item_template_type'
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$type = $row['Type'];

		$replace1 = preg_replace("/enum/", '', $type);
		$replace2 = preg_replace("/\(/", '', $replace1);
		$replace3 = preg_replace("/\)/", '', $replace2);
		$replace4 = preg_replace("/\'/", '', $replace3);
		$arrTmp = explode(',', $replace4);

		$arrSubcontractItemTemplateTypes = array();
		$i = 1;
		foreach ($arrTmp as $subcontract_item_template_type) {
			$arrSubcontractItemTemplateTypes[$i] = $subcontract_item_template_type;
			$i++;
		}

		$db->free_result();
		$db->commit();

		return $arrSubcontractItemTemplateTypes;
	}

	public static function setNaturalSortOrderOnSubcontractItemTemplatesByUserCompanyId($database, $user_company_id, $original_subcontract_item_template_id)
	{
		$user_company_id = (int) $user_company_id;
		$original_subcontract_item_template_id = (int) $original_subcontract_item_template_id;

		$loadSubcontractItemTemplatesByUserCompanyIdOptions = new Input();
		$loadSubcontractItemTemplatesByUserCompanyIdOptions->forceLoadFlag = true;

		$arrSubcontractItemTemplatesByUserCompanyId = SubcontractItemTemplate::loadSubcontractItemTemplatesByUserCompanyId($database, $user_company_id, $loadSubcontractItemTemplatesByUserCompanyIdOptions);
		$i = 0;
		foreach ($arrSubcontractItemTemplatesByUserCompanyId as $subcontract_item_template_id => $subcontractItemTemplate) {
			/* @var $subcontractItemTemplate SubcontractItemTemplate */

			if ($subcontractItemTemplate->sort_order != $i) {
				$data = array('sort_order' => $i);
				$subcontractItemTemplate->setData($data);
				$subcontractItemTemplate->save();
			}

			// Get the original sort_order value after updating to sane values
			if ($subcontractItemTemplate->subcontract_item_template_id == $original_subcontract_item_template_id) {
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
		$original_sort_order = SubcontractItemTemplate::setNaturalSortOrderOnSubcontractItemTemplatesByUserCompanyId($database, $user_company_id, $this->subcontract_item_template_id);

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
UPDATE `subcontract_item_templates`
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
UPDATE `subcontract_item_templates`
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
public static function loadSubcontractItemTrackTemplates($database, $user_company_id, $tmp_subcontract_template_id, $subcontract_item_template_id, Input $options=null)
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
		self::$_arrSubcontractItemTemplatesByUserCompanyId = null;
	}

	$arrSubcontractItemTemplatesByUserCompanyId = self::$_arrSubcontractItemTemplatesByUserCompanyId;
	if (isset($arrSubcontractItemTemplatesByUserCompanyId) && !empty($arrSubcontractItemTemplatesByUserCompanyId)) {
		return $arrSubcontractItemTemplatesByUserCompanyId;
	}

	$user_company_id = (int) $user_company_id;
	$tmp_subcontract_template_id = (int) $tmp_subcontract_template_id;
	$subcontract_item_template_id = (int) $subcontract_item_template_id;
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_company_id` ASC, `file_manager_file_id` ASC, `user_company_file_template_id` ASC, `subcontract_item` ASC, `subcontract_item_abbreviation` ASC, `subcontract_item_template_type` ASC, `sort_order` ASC, `disabled_flag` ASC
	$sqlOrderBy = "\nORDER BY sit.`sort_order`+0 ASC, ISNULL(st2sit.sort_order) ASC, st2sit.sort_order+0 ASC, subcontract_item ASC";
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpSubcontractItemTemplate = new SubcontractItemTemplate($database);
		$sqlOrderByColumns = $tmpSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

	$query = "
	SELECT * FROM `subcontract_templates_to_subcontract_item_templates` ss
	WHERE ss.`subcontract_template_id`=? AND `ss`.`subcontract_item_template_id`=?
	ORDER BY `ss`.`sort_order` ASC
	";

	$arrValues = array($tmp_subcontract_template_id, $subcontract_item_template_id);
	$db->execute($query,$arrValues);
	$row = $db->fetch();
	$db->free_result();
	return $row;

}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
