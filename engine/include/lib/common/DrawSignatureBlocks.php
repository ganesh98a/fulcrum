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

class DrawSignatureBlocks extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DrawSignatureBlocks';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'draw_signature_blocks';

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
		'id' => 'signature_block_id',
		'project_id' => 'project_id',
		'draw_id' => 'draw_id',
		'signature_type_id' => 'signature_type_id',
		'enable_flag' => 'enable_flag',
		'description' => 'signature_block_description',
		'created_by_contact_id' => 'signature_block_created_by_contact_id',
		'updated_by_contact_id' => 'signature_block_updated_by_contact_id',
		'created_date' => 'signature_block_created_date',
		'updated_date' => 'signature_block_updated_date',
		'desc_update_flag' => 'signature_block_desc_update_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $signature_block_id;
	public $project_id;
	public $draw_id;
	public $signature_type_id;
	public $enable_flag;
	public $signature_block_description;
	public $signature_block_created_by_contact_id;
	public $signature_block_updated_by_contact_id;
	public $signature_block_created_date;
	public $signature_block_updated_date;
	public $signature_block_desc_update_flag;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_signature_block_description;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDrawSignatureBlocks;
	protected static $_signatureBlockConstructionLender;
	/**
	 * Constructor
	 */
	public function __construct($database, $table='draw_signature_blocks')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}
	// Foreign Key Object Accessor Methods
	public function getSignatureBlockConstructionLender()
	{
		if (isset($this->_signatureBlockConstructionLender)) {
			return $this->_signatureBlockConstructionLender;
		} else {
			return null;
		}
	}

	public function setSignatureBlockConstructionLender($signblockcl)
	{
		$this->_signatureBlockConstructionLender = $signblockcl;
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $signature_block_id, $table='draw_signature_blocks', $module='DrawSignatureBlocks')
	{
		$signatureBlock = parent::findById($database, $signature_block_id, $table, $module);

		return $signatureBlock;
	}

	public static function getArrAllDrawSignatureBlock()
	{
		if (isset(self::$_arrAllDrawSignatureBlocks)) {
			return self::$_arrAllDrawSignatureBlocks;
		} else {
			return null;
		}
	}

	public static function setArrAllDrawSignatureBlock($arrAllDrawSignatureBlocks)
	{
		self::$_arrAllDrawSignatureBlocks = $arrAllDrawSignatureBlocks;
	}

	// Loaders: Load All Records
	/**
	 * Load all draw signature block records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDrawSignatureBlocksById($database, $signature_type_id, $project_id, $draw_id, Input $options=null)
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
			self::$_arrAllDrawSignatureBlocks = null;
		}

		$arrAllDrawSignatureBlocks = self::$_arrAllDrawSignatureBlocks;
		if (isset($arrAllDrawSignatureBlocks) && !empty($arrAllDrawSignatureBlocks)) {
			return $arrAllDrawSignatureBlocks;
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
			dsb.*
		FROM `draw_signature_blocks` dsb
		WHERE dsb.`signature_type_id` = ? AND dsb.`project_id` = ? AND dsb.`draw_id` = ?
		{$sqlOrderBy}{$sqlLimit}
		";
		$arrValues = array($signature_type_id, $project_id, $draw_id);
		$db->query($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllDrawSignatureBlocks = array();
		while ($row = $db->fetch()) {
			$signature_block_id = $row['id'];
			$signatureBlock = self::instantiateOrm($database, 'DrawSignatureBlocks', $row, null, $signature_block_id);
			/* @var $contact Contact */
			$arrAllDrawSignatureBlocks = $signatureBlock;
		}

		$db->free_result();

		self::$_arrAllDrawSignatureBlocks = $arrAllDrawSignatureBlocks;

		return $arrAllDrawSignatureBlocks;
	}

	// Loaders: Load All Using Draw id Records
	/**
	 * Load all draw signature block records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDrawSignatureBlocks($database, $draw_id, Input $options=null)
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
			self::$_arrAllDrawSignatureBlocks = null;
		}

		$arrAllDrawSignatureBlocks = self::$_arrAllDrawSignatureBlocks;
		if (isset($arrAllDrawSignatureBlocks) && !empty($arrAllDrawSignatureBlocks)) {
			return $arrAllDrawSignatureBlocks;
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
		-- dsb.`id` AS 'dsb__id',
		-- dsb.`project_id` AS 'dsb__project_id',
		-- dsb.`draw_id` AS 'dsb__draw_id',
		-- dsb.`signature_type_id` AS 'dsb__signature_type_id',
		-- dsb.`enable_flag` AS 'dsb__enable_flag',
		-- dsb.`description` AS 'dsb__description',
		-- dsb.`created_by_contact_id` AS 'dsb__created_by_contact_id',
		-- dsb.`updated_by_contact_id` AS 'dsb__updated_by_contact_id',
		-- dsb.`updated_date` AS 'dsb__updated_date',
		-- dsb.`updated_date` AS 'dsb__updated_date',
		-- dsb.`desc_update_flag` AS 'dsb__desc_update_flag',
		dsb.*,
		dscl.`id` AS 'dscl__id',
		dscl.`signature_block_id` AS 'dscl__signature_block_id',
		dscl.`address_1` AS 'dscl__address_1',
		dscl.`address_2` AS 'dscl__address_2',
		dscl.`city_state_zip` AS 'dscl__city_state_zip'

		FROM `draw_signature_blocks` dsb
		LEFT JOIN  `draw_signature_construction_lender` AS dscl ON dscl.`signature_block_id` = dsb.id
		WHERE dsb.`draw_id` = ?
		{$sqlOrderBy}{$sqlLimit}
		";
		$arrValues = array($draw_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllDrawSignatureBlocks = array();
		while ($row = $db->fetch()) {
			$signature_block_id = $row['id'];
			$signatureBlock = self::instantiateOrm($database, 'DrawSignatureBlocks', $row, null, $signature_block_id);
			/* @var $contact Contact */


			if (isset($row['dscl__id'])) {
				$dsclId = $row['dscl__id'];
				$row['dscl__id'] = $dsclId;
				$signBlockCL = self::instantiateOrm($database, 'DrawSignatureBlocksConstructionLender', $row, null, $dsclId, 'dscl__');
				/* @var $meeting Meeting */
				$signBlockCL->convertPropertiesToData();
			} else {
				$signBlockCL = false;
			}

			$signatureBlock->setSignatureBlockConstructionLender($signBlockCL);
			// print_r($signatureBlock->getSignatureBlockConstructionLender());
			$arrAllDrawSignatureBlocks[$signature_block_id] = $signatureBlock;
		}

		$db->free_result();

		self::$_arrAllDrawSignatureBlocks = $arrAllDrawSignatureBlocks;

		return $arrAllDrawSignatureBlocks;
	}

	// Loaders: Load All Records
	/**
	 * Load all draw signature block records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function findByDrawSignatureBlocksById($database, $signature_type_id, $project_id, $draw_id, Input $options=null)
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
			self::$_arrAllDrawSignatureBlocks = null;
		}

		$arrAllDrawSignatureBlocks = self::$_arrAllDrawSignatureBlocks;
		if (isset($arrAllDrawSignatureBlocks) && !empty($arrAllDrawSignatureBlocks)) {
			return $arrAllDrawSignatureBlocks;
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
			dsb.*
		FROM `draw_signature_blocks` dsb
		WHERE dsb.`signature_type_id` = ? AND dsb.`project_id` = ? AND dsb.`draw_id` = ?
		{$sqlOrderBy}{$sqlLimit}
		";
		$arrValues = array($signature_type_id, $project_id, $draw_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllDrawSignatureBlocks = array();
		while ($row = $db->fetch()) {
			$signature_block_id = $row['id'];
			$signatureBlock = self::instantiateOrm($database, 'DrawSignatureBlocks', $row, null, $signature_block_id);
			/* @var $contact Contact */
			$arrAllDrawSignatureBlocks[$signature_block_id] = $signatureBlock;
		}

		$db->free_result();

		self::$_arrAllDrawSignatureBlocks = $arrAllDrawSignatureBlocks;

		return $arrAllDrawSignatureBlocks;
	}
	public static function findByDrawSignatureBlockById($database, $signature_type_id, $project_id, $draw_id)
	{
		

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
		"
		SELECT
			dsb.*
		FROM `draw_signature_blocks` dsb
		WHERE dsb.`signature_type_id` = ? AND dsb.`project_id` = ? AND dsb.`draw_id` = ? Limit 1";
		$arrValues = array($signature_type_id, $project_id, $draw_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		
		// $arrAllDrawSignatureBlock = $db->fetch();
		$row = $db->fetch();
		$signature_block_id = $row['id'];
		$signatureBlock = self::instantiateOrm($database, 'DrawSignatureBlocks', $row, null, $signature_block_id);

		$db->free_result();


		return $signatureBlock;
	}

	// To get architect name of latest posted draw of the project
	public static function getArchitectNameForProject($database, $project_id){

		$db = DBI::getInstance($database);

		$query1 = "SELECT id FROM `draw_signature_type` WHERE `signature_type_entity` = 'Architect' ";
		$db->execute($query1);
		$row = $db->fetch();
		$signature_type_id = $row['id'];
		$db->free_result();

		$query =
		"SELECT * FROM `draw_signature_blocks` WHERE `draw_id` = (SELECT id FROM `draws` WHERE `project_id` = ? AND `status` = ? ORDER BY `id` DESC Limit 1) AND `signature_type_id` = ?";
		$arrValues = array($project_id,'2',$signature_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$architectName = $row['description'];
		$db->free_result();

		return $architectName;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
