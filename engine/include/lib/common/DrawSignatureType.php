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

class DrawSignatureType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DrawSignatureType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'draw_signature_type';

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
		'id' => 'signature_type_id',
		'signature_type_entity' => 'signature_type_entity',
		'disable_flag' => 'signature_type_disable_flag',
		'default_editable_flag' => 'signature_type_default_editable_flag',
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $signature_type_id;

	public $signature_type_entity;
	public $signature_type_disable_flag;
	public $signature_type_default_editable_flag;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_signature_type_entity;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDrawSignatureTypes;
	/**
	 * Constructor
	 */
	public function __construct($database, $table='draw_signature_type')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}


	public static function getArrAllDrawSignatureType()
	{
		if (isset(self::$_arrAllDrawSignatureTypes)) {
			return self::$_arrAllDrawSignatureTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllDrawSignatureType($arrAllDrawSignatureTypes)
	{
		self::$_arrAllDrawSignatureTypes = $arrAllDrawSignatureTypes;
	}

	// Loaders: Load All Records
	/**
	 * Load all draw signature type records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDrawSignatureType($database, Input $options=null)
	{
		$forceLoadFlag = false;
		$filterWhere = "";
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
			$filter = $options->filter;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrAllDrawSignatureTypes = null;
		}

		$arrAllDrawSignatureTypes = self::$_arrAllDrawSignatureTypes;
		if (isset($arrAllDrawSignatureTypes) && !empty($arrAllDrawSignatureTypes)) {
			return $arrAllDrawSignatureTypes;
		}
		// For retention we need to remove notary block
		if($filter =="Retention")
		{
				$filterWhere = "AND dst.id != 4"; 	
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
			dst.*

		FROM `draw_signature_type` dst
		WHERE dst.`disable_flag` = 'N' $filterWhere
		{$sqlOrderBy}{$sqlLimit}
		";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDrawSignatureTypes = array();
		while ($row = $db->fetch()) {
			$signature_type_id = $row['id'];
			$signatureType = self::instantiateOrm($database, 'DrawSignatureType', $row, null, $signature_type_id);
			/* @var $contact Contact */
			$arrAllDrawSignatureTypes[$signature_type_id] = $signatureType;
		}

		$db->free_result();

		self::$_arrAllDrawSignatureTypes = $arrAllDrawSignatureTypes;

		return $arrAllDrawSignatureTypes;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
