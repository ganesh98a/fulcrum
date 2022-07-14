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

class DrawSignatureBlocksConstructionLender extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DrawSignatureBlocksConstructionLender';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'draw_signature_construction_lender';

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
		'id' => 'signature_block_construction_lender_id',
		'signature_block_id' => 'signature_block_id',
		'address_1' => 'signature_block_construction_lender_address_1',
		'address_2' => 'signature_block_construction_lender_address_2',
		'city_state_zip' => 'signature_block_construction_lender_city_state_zip'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $signature_block_construction_lender_id;
	public $signature_block_id;
	public $signature_block_construction_lender_address_1;
	public $signature_block_construction_lender_address_2;
	public $signature_block_construction_lender_city_state_zip;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_signature_block_construction_lender_address_1;
	public $escaped_signature_block_construction_lender_address_2;
	public $escaped_signature_block_construction_lender_city_state_zip;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDrawSignatureBlocksConstructionLender;
	/**
	 * Constructor
	 */
	public function __construct($database, $table='draw_signature_construction_lender')
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
	public static function findById($database, $signature_block_cl_id, $table='draw_signature_construction_lender', $module='DrawSignatureBlocksConstructionLender')
	{
		$signatureBlock = parent::findById($database, $signature_block_cl_id, $table, $module);

		return $signatureBlock;
	}

	public static function getArrAllDrawSignatureBlockCL()
	{
		if (isset(self::$_arrAllDrawSignatureBlocksConstructionLender)) {
			return self::$_arrAllDrawSignatureBlocksConstructionLender;
		} else {
			return null;
		}
	}

	public static function setArrAllDrawSignatureBlockCL($arrAllDrawSignatureBlocksConstructionLender)
	{
		self::$_arrAllDrawSignatureBlocksConstructionLender = $arrAllDrawSignatureBlocksConstructionLender;
	}

	// Loaders: Load All Records
	/**
	 * Load all draw signature block records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDrawSignatureBlocksCLById($database, $signature_block_cl_id, Input $options=null)
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

		$arrAllDrawSignatureBlocksConstructionLender = self::$_arrAllDrawSignatureBlocksConstructionLender;
		if (isset($arrAllDrawSignatureBlocksConstructionLender) && !empty($arrAllDrawSignatureBlocksConstructionLender)) {
			return $arrAllDrawSignatureBlocksConstructionLender;
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
			dscl.*
		FROM `draw_signature_construction_lender` dscl
		WHERE dscl.`id` = ?
		{$sqlOrderBy}{$sqlLimit}
		";
		$arrValues = array($signature_block_cl_id);
		$db->query($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllDrawSignatureBlocksCL = array();
		while ($row = $db->fetch()) {
			$signature_cl_id = $row['id'];
			$signatureBlockCL = self::instantiateOrm($database, 'DrawSignatureBlocksConstructionLender', $row, null, $signature_cl_id);
			/* @var $contact Contact */
			$arrAllDrawSignatureBlocksCL = $signatureBlockCL;
		}

		$db->free_result();

		self::$_arrAllDrawSignatureBlocksConstructionLender = $arrAllDrawSignatureBlocksCL;

		return $arrAllDrawSignatureBlocksCL;
	}

	// Loaders: Load All Records
	/**
	 * Load all draw signature block records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDrawSignatureBlocksCLBySBId($database, $signature_block_id, Input $options=null)
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
			self::$_arrAllDrawSignatureBlocksConstructionLender = null;
		}

		$arrAllDrawSignatureBlocksConstructionLender = self::$_arrAllDrawSignatureBlocksConstructionLender;
		if (isset($arrAllDrawSignatureBlocksConstructionLender) && !empty($arrAllDrawSignatureBlocksConstructionLender)) {
			return $arrAllDrawSignatureBlocksConstructionLender;
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
			dscl.*
		FROM `draw_signature_construction_lender` dscl
		WHERE dscl.`signature_block_id` = ?
		{$sqlOrderBy}{$sqlLimit}
		";
		$arrValues = array($signature_block_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllDrawSignatureBlocksCL = array();
		while ($row = $db->fetch()) {
			$signature_cl_id = $row['id'];
			$signatureBlockCL = self::instantiateOrm($database, 'DrawSignatureBlocksConstructionLender', $row, null, $signature_cl_id);
			/* @var $contact Contact */
			$arrAllDrawSignatureBlocksCL = $signatureBlockCL;
		}

		$db->free_result();

		self::$_arrAllDrawSignatureBlocksConstructionLender = $arrAllDrawSignatureBlocksCL;

		return $arrAllDrawSignatureBlocksCL;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
