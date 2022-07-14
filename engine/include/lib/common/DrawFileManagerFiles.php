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
 * Contact.
 *
 * @category   Framework
 * @package    Contact
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class DrawFileManagerFiles extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DrawFileManagerFiles';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'draw_file_manager_files';

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
	 * unique index `unique_contact` (`user_company_id`,`contact_company_id`,`email`,`first_name`,`last_name`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	/*protected $_arrUniqueness = array(
		'unique_contact' => array(
			'project_id' => 'int',
			'draw_id' => 'int',
			'signature_type_id' => 'string',
		)
	);*/

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
		'id' => 'draw_file_manager_file_id',
		'draw_id' => 'draw_id',
		'draw_action_type_id' => 'draw_action_type_id',
		'draw_action_type_option_id' => 'draw_action_type_option_id',
		'file_manager_file_id' => 'file_manager_file_id',
		'file_manager_folder_id' => 'file_manager_folder_id',
		'created_date' => 'created_date',
		'updated_date' => 'updated_date',
		'created_contact_id' => 'created_contact_id',
		'updated_contact_id' => 'updated_contact_id',
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $draw_file_manager_file_id;
	public $draw_id;
	public $draw_action_type_id;
	public $draw_action_type_option_id;
	public $file_manager_file_id;
	public $file_manager_folder_id;
	public $created_date;
	public $updated_date;
	public $created_contact_id;
	public $updated_contact_id;
	
	// HTML ENTITY ENCODED ORM string properties
	public $escaped_action_name;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDrawFileManagerFiles;
	/**
	 * Constructor
	 */
	public function __construct($database, $table='draw_file_manager_files')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}
	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $draw_file_manager_file_id, $table='draw_file_manager_files', $module='DrawFileManageFiles')
	{
		$drawFileManageFile = parent::findById($database, $draw_file_manager_file_id, $table, $module);

		return $drawFileManageFile;
	}

	public static function getArrAllDrawFileManagerFile()
	{
		if (isset(self::$_arrAllDrawFileManagerFiles)) {
			return self::$_arrAllDrawFileManagerFiles;
		} else {
			return null;
		}
	}

	public static function setArrAllDrawFileManagerFile($arrAllDrawFileManagerFiles)
	{
		self::$_arrAllDrawFileManagerFiles = $arrAllDrawFileManagerFiles;
	}
	/*
	-* find dfmf using id's if exists
	*/
	public static function findByIdsDrawFileManagerFile($database, $draw_id, $draw_action_type_id, $draw_action_type_option_id, Input $options=null)
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
			self::$_arrAllDrawFileManagerFiles = null;
		}

		$arrAllDrawFileManagerFiles = self::$_arrAllDrawFileManagerFiles;
		if (isset($arrAllDrawFileManagerFiles) && !empty($arrAllDrawFileManagerFiles)) {
			return $arrAllDrawFileManagerFiles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new DrawSignatureType($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
		$where = 'AND dfmf.`draw_action_type_option_id` = ?';
		$arrValues = array($draw_id, $draw_action_type_id, $draw_action_type_option_id);
		// if($draw_action_type_option_id == '' || $draw_action_type_option_id == NULL){
		// 	$where = 'AND dfmf.`draw_action_type_option_id` IS NULL ';
		// 	// $where = '';
		// 	$arrValues = array($draw_id, $draw_action_type_id);
		// }
		$query =
		"
		SELECT
		dfmf.*
		FROM `draw_file_manager_files` dfmf
		WHERE dfmf.`draw_id` = ? AND dfmf.`draw_action_type_id` = ? $where
		{$sqlOrderBy} LIMIT 1
		";
		
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllDrawFileManagerFiles = array();
		while ($row = $db->fetch()) {
			$draw_file_manage_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'DrawFileManagerFiles', $row, null, $draw_file_manage_file_id);
			/* @var $contact Contact */
			// print_r($signatureBlock->getSignatureBlockConstructionLender());
			$arrAllDrawFileManagerFiles = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrAllDrawFileManagerFiles = $arrAllDrawFileManagerFiles;

		return $arrAllDrawFileManagerFiles;
	}
	// Loaders: Load All Draw Action Type Records
	/**
	 * Load all draw signature block records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDrawFilesByDrawId($database, $draw_id, Input $options=null)
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
			self::$_arrAllDrawFileManagerFiles = null;
		}

		$arrAllDrawFileManagerFiles = self::$_arrAllDrawFileManagerFiles;
		if (isset($arrAllDrawFileManagerFiles) && !empty($arrAllDrawFileManagerFiles)) {
			return $arrAllDrawFileManagerFiles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new DrawSignatureType($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
		dfmf.*
		FROM `draw_file_manager_files` dfmf
		WHERE dfmf.`draw_id` = ?
		{$sqlOrderBy} LIMIT 1
		";
		$arrValues = array($draw_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllDrawFileManagerFiles = array();
		while ($row = $db->fetch()) {
			$draw_file_manage_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'DrawFileManagerFiles', $row, null, $draw_file_manage_file_id);
			/* @var $contact Contact */
			// print_r($signatureBlock->getSignatureBlockConstructionLender());
			$arrAllDrawFileManagerFiles = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrAllDrawFileManagerFiles = $arrAllDrawFileManagerFiles;

		return $arrAllDrawFileManagerFiles;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
