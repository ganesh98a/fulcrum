<?php
class RetentionSignatureBlocks extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RetentionSignatureBlocks';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'retention_signature_blocks';

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
		'id' => 'signature_block_id',
		'project_id' => 'project_id',
		'retention_draw_id' => 'retention_draw_id',
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
	public $retention_draw_id;
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
	public function __construct($database, $table='retention_signature_blocks')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}
		// Foreign Key Object Accessor Methods
	public function getRetSignatureBlockConstructionLender()
	{
		if (isset($this->_signatureBlockConstructionLender)) {
			return $this->_signatureBlockConstructionLender;
		} else {
			return null;
		}
	}

	public function setRetSignatureBlockConstructionLender($signblockcl)
	{
		$this->_signatureBlockConstructionLender = $signblockcl;
	}
	public static function getArrAllRetSignatureBlock()
    {
        if (isset(self::$_arrAllDrawSignatureBlocks)) {
            return self::$_arrAllDrawSignatureBlocks;
        } else {
            return null;
        }
    }
 
    public static function setArrAllRetSignatureBlock($arrAllDrawSignatureBlocks)
    {
        self::$_arrAllDrawSignatureBlocks = $arrAllDrawSignatureBlocks;
    }
	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $signature_block_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $signature_block_id, $table='retention_signature_blocks', $module='RetentionSignatureBlocks')
	{
		$signatureBlock = parent::findById($database, $signature_block_id, $table, $module);

		return $signatureBlock;
	}

	public static function findByRetentionSignatureBlocksById($database, $signature_type_id, $project_id, $draw_id, Input $options=null)
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
		FROM `retention_signature_blocks` dsb
		WHERE dsb.`signature_type_id` = ? AND dsb.`project_id` = ? AND dsb.`retention_draw_id` = ?
		{$sqlOrderBy}{$sqlLimit}
		";
		$arrValues = array($signature_type_id, $project_id, $draw_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllDrawSignatureBlocks = array();
		while ($row = $db->fetch()) {
			$signature_block_id = $row['id'];
			$signatureBlock = self::instantiateOrm($database, 'RetentionSignatureBlocks', $row, null, $signature_block_id);
			/* @var $contact Contact */
			$arrAllDrawSignatureBlocks[$signature_block_id] = $signatureBlock;
		}

		$db->free_result();

		self::$_arrAllDrawSignatureBlocks = $arrAllDrawSignatureBlocks;

		return $arrAllDrawSignatureBlocks;
	}
	public static function findByRetentionSignatureBlockById($database, $signature_type_id, $project_id, $draw_id)
	{
		

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
		"
		SELECT
			dsb.*
		FROM `retention_signature_blocks` dsb
		WHERE dsb.`signature_type_id` = ? AND dsb.`project_id` = ? AND dsb.`retention_draw_id` = ? Limit 1";
		$arrValues = array($signature_type_id, $project_id, $draw_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		
		$row = $db->fetch();
		$signature_block_id = $row['id'];
		$signatureBlock = self::instantiateOrm($database, 'RetentionSignatureBlocks', $row, null, $signature_block_id);

		$db->free_result();


		return $signatureBlock;
	}
	// Loaders: Load All Using Retention id Records
	/**
	 * Load all Retention signature block records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRetentionSignatureBlocks($database, $ret_id, Input $options=null)
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
		rsb.*,
		rscl.`id` AS 'rscl__id',
		rscl.`signature_block_id` AS 'rscl__signature_block_id',
		rscl.`address_1` AS 'rscl__address_1',
		rscl.`address_2` AS 'rscl__address_2',
		rscl.`city_state_zip` AS 'rscl__city_state_zip'

		FROM `retention_signature_blocks` rsb
		LEFT JOIN  `retention_signature_construction_lender` AS rscl ON rscl.`signature_block_id` = rsb.id
		WHERE rsb.`retention_draw_id` = ?
		{$sqlOrderBy}{$sqlLimit}
		";
		$arrValues = array($ret_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllDrawSignatureBlocks = array();
		while ($row = $db->fetch()) {
			$signature_block_id = $row['id'];
			$signatureBlock = self::instantiateOrm($database, 'RetentionSignatureBlocks', $row, null, $signature_block_id);
			/* @var $contact Contact */


			if (isset($row['rscl__id'])) {
				$dsclId = $row['rscl__id'];
				$row['rscl__id'] = $dsclId;
				$signBlockCL = self::instantiateOrm($database, 'RetentionSignatureBlocksConstructionLender', $row, null, $rsclId, 'rscl__');
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


}
/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
