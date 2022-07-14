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
 * MobileNetworkCarrier.
 *
 * @category   Framework
 * @package    MobileNetworkCarrier
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class MobileNetworkCarrier extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'MobileNetworkCarrier';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'mobile_network_carriers';

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
	 * unique index `unique_mobile_network_carrier` (`carrier`,`sms_email_gateway`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_mobile_network_carrier' => array(
			'carrier' => 'string',
			'sms_email_gateway' => 'string'
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
		'id' => 'mobile_network_carrier_id',

		'carrier' => 'carrier',
		'carrier_display_name' => 'carrier_display_name',
		'sms_email_gateway' => 'sms_email_gateway',

		'country' => 'country'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $mobile_network_carrier_id;

	public $carrier;
	public $carrier_display_name;
	public $sms_email_gateway;

	public $country;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_carrier;
	public $escaped_carrier_display_name;
	public $escaped_sms_email_gateway;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_carrier_nl2br;
	public $escaped_carrier_display_name_nl2br;
	public $escaped_sms_email_gateway_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrMobileNetworkCarriersByCarrier;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllMobileNetworkCarriers;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='mobile_network_carriers')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrMobileNetworkCarriersByCarrier()
	{
		if (isset(self::$_arrMobileNetworkCarriersByCarrier)) {
			return self::$_arrMobileNetworkCarriersByCarrier;
		} else {
			return null;
		}
	}

	public static function setArrMobileNetworkCarriersByCarrier($arrMobileNetworkCarriersByCarrier)
	{
		self::$_arrMobileNetworkCarriersByCarrier = $arrMobileNetworkCarriersByCarrier;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllMobileNetworkCarriers()
	{
		if (isset(self::$_arrAllMobileNetworkCarriers)) {
			return self::$_arrAllMobileNetworkCarriers;
		} else {
			return null;
		}
	}

	public static function setArrAllMobileNetworkCarriers($arrAllMobileNetworkCarriers)
	{
		self::$_arrAllMobileNetworkCarriers = $arrAllMobileNetworkCarriers;
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
	 * @param int $mobile_network_carrier_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $mobile_network_carrier_id,$table='mobile_network_carriers', $module='MobileNetworkCarrier')
	{
		$mobileNetworkCarrier = parent::findById($database, $mobile_network_carrier_id, $table, $module);

		return $mobileNetworkCarrier;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $mobile_network_carrier_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findMobileNetworkCarrierByIdExtended($database, $mobile_network_carrier_id)
	{
		$mobile_network_carrier_id = (int) $mobile_network_carrier_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	mnc.*

FROM `mobile_network_carriers` mnc
WHERE mnc.`id` = ?
";
		$arrValues = array($mobile_network_carrier_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$mobile_network_carrier_id = $row['id'];
			$mobileNetworkCarrier = self::instantiateOrm($database, 'MobileNetworkCarrier', $row, null, $mobile_network_carrier_id);
			/* @var $mobileNetworkCarrier MobileNetworkCarrier */
			$mobileNetworkCarrier->convertPropertiesToData();

			return $mobileNetworkCarrier;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_mobile_network_carrier` (`carrier`,`sms_email_gateway`).
	 *
	 * @param string $database
	 * @param string $carrier
	 * @param string $sms_email_gateway
	 * @return mixed (single ORM object | false)
	 */
	public static function findByCarrierAndSmsEmailGateway($database, $carrier, $sms_email_gateway)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	mnc.*

FROM `mobile_network_carriers` mnc
WHERE mnc.`carrier` = ?
AND mnc.`sms_email_gateway` = ?
";
		$arrValues = array($carrier, $sms_email_gateway);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$mobile_network_carrier_id = $row['id'];
			$mobileNetworkCarrier = self::instantiateOrm($database, 'MobileNetworkCarrier', $row, null, $mobile_network_carrier_id);
			/* @var $mobileNetworkCarrier MobileNetworkCarrier */
			return $mobileNetworkCarrier;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrMobileNetworkCarrierIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMobileNetworkCarriersByArrMobileNetworkCarrierIds($database, $arrMobileNetworkCarrierIds, Input $options=null)
	{
		if (empty($arrMobileNetworkCarrierIds)) {
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
		// ORDER BY `id` ASC, `carrier` ASC, `carrier_display_name` ASC, `sms_email_gateway` ASC, `country` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMobileNetworkCarrier = new MobileNetworkCarrier($database);
			$sqlOrderByColumns = $tmpMobileNetworkCarrier->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrMobileNetworkCarrierIds as $k => $mobile_network_carrier_id) {
			$mobile_network_carrier_id = (int) $mobile_network_carrier_id;
			$arrMobileNetworkCarrierIds[$k] = $db->escape($mobile_network_carrier_id);
		}
		$csvMobileNetworkCarrierIds = join(',', $arrMobileNetworkCarrierIds);

		$query =
"
SELECT

	mnc.*

FROM `mobile_network_carriers` mnc
WHERE mnc.`id` IN ($csvMobileNetworkCarrierIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrMobileNetworkCarriersByCsvMobileNetworkCarrierIds = array();
		while ($row = $db->fetch()) {
			$mobile_network_carrier_id = $row['id'];
			$mobileNetworkCarrier = self::instantiateOrm($database, 'MobileNetworkCarrier', $row, null, $mobile_network_carrier_id);
			/* @var $mobileNetworkCarrier MobileNetworkCarrier */
			$mobileNetworkCarrier->convertPropertiesToData();

			$arrMobileNetworkCarriersByCsvMobileNetworkCarrierIds[$mobile_network_carrier_id] = $mobileNetworkCarrier;
		}

		$db->free_result();

		return $arrMobileNetworkCarriersByCsvMobileNetworkCarrierIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: unique index `unique_mobile_network_carrier` (`carrier`,`sms_email_gateway`).
	 *
	 * @param string $database
	 * @param string $carrier
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMobileNetworkCarriersByCarrier($database, $carrier, Input $options=null)
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
			self::$_arrMobileNetworkCarriersByCarrier = null;
		}

		$arrMobileNetworkCarriersByCarrier = self::$_arrMobileNetworkCarriersByCarrier;
		if (isset($arrMobileNetworkCarriersByCarrier) && !empty($arrMobileNetworkCarriersByCarrier)) {
			return $arrMobileNetworkCarriersByCarrier;
		}

		$carrier = (string) $carrier;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `carrier` ASC, `carrier_display_name` ASC, `sms_email_gateway` ASC, `country` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMobileNetworkCarrier = new MobileNetworkCarrier($database);
			$sqlOrderByColumns = $tmpMobileNetworkCarrier->constructSqlOrderByColumns($arrOrderByAttributes);

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
	mnc.*

FROM `mobile_network_carriers` mnc
WHERE mnc.`carrier` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `carrier` ASC, `carrier_display_name` ASC, `sms_email_gateway` ASC, `country` ASC
		$arrValues = array($carrier);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMobileNetworkCarriersByCarrier = array();
		while ($row = $db->fetch()) {
			$mobile_network_carrier_id = $row['id'];
			$mobileNetworkCarrier = self::instantiateOrm($database, 'MobileNetworkCarrier', $row, null, $mobile_network_carrier_id);
			/* @var $mobileNetworkCarrier MobileNetworkCarrier */
			$arrMobileNetworkCarriersByCarrier[$mobile_network_carrier_id] = $mobileNetworkCarrier;
		}

		$db->free_result();

		self::$_arrMobileNetworkCarriersByCarrier = $arrMobileNetworkCarriersByCarrier;

		return $arrMobileNetworkCarriersByCarrier;
	}

	// Loaders: Load All Records
	/**
	 * Load all mobile_network_carriers records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllMobileNetworkCarriers($database, Input $options=null)
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
			self::$_arrAllMobileNetworkCarriers = null;
		}

		$arrAllMobileNetworkCarriers = self::$_arrAllMobileNetworkCarriers;
		if (isset($arrAllMobileNetworkCarriers) && !empty($arrAllMobileNetworkCarriers)) {
			return $arrAllMobileNetworkCarriers;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `carrier` ASC, `carrier_display_name` ASC, `sms_email_gateway` ASC, `country` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMobileNetworkCarrier = new MobileNetworkCarrier($database);
			$sqlOrderByColumns = $tmpMobileNetworkCarrier->constructSqlOrderByColumns($arrOrderByAttributes);

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
	mnc.*

FROM `mobile_network_carriers` mnc{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `carrier` ASC, `carrier_display_name` ASC, `sms_email_gateway` ASC, `country` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllMobileNetworkCarriers = array();
		while ($row = $db->fetch()) {
			$mobile_network_carrier_id = $row['id'];
			$mobileNetworkCarrier = self::instantiateOrm($database, 'MobileNetworkCarrier', $row, null, $mobile_network_carrier_id);
			/* @var $mobileNetworkCarrier MobileNetworkCarrier */
			$arrAllMobileNetworkCarriers[$mobile_network_carrier_id] = $mobileNetworkCarrier;
		}

		$db->free_result();

		self::$_arrAllMobileNetworkCarriers = $arrAllMobileNetworkCarriers;

		return $arrAllMobileNetworkCarriers;
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
INTO `mobile_network_carriers`
(`carrier`, `carrier_display_name`, `sms_email_gateway`, `country`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `carrier_display_name` = ?, `country` = ?
";
		$arrValues = array($this->carrier, $this->carrier_display_name, $this->sms_email_gateway, $this->country, $this->carrier_display_name, $this->country);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$mobile_network_carrier_id = $db->insertId;
		$db->free_result();

		return $mobile_network_carrier_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
