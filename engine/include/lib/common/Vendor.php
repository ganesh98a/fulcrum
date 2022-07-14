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
 * Vendor.
 *
 * @category   Framework
 * @package    Vendor
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class Vendor extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'Vendor';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'vendors';

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
	 * unique index `unique_vendor` (`vendor_contact_company_id`,`vendor_contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_vendor' => array(
			'vendor_contact_company_id' => 'int',
			'vendor_contact_id' => 'int'
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
		'id' => 'vendor_id',

		'vendor_contact_company_id' => 'vendor_contact_company_id',
		'vendor_contact_company_office_id' => 'vendor_contact_company_office_id',
		'vendor_contact_id' => 'vendor_contact_id',

		'vendor_contact_address_id' => 'vendor_contact_address_id',
		'w9_file_manager_file_id' => 'w9_file_manager_file_id',
		'taxpayer_identification_number_id' => 'taxpayer_identification_number_id',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $vendor_id;

	public $vendor_contact_company_id;
	public $vendor_contact_company_office_id;
	public $vendor_contact_id;

	public $vendor_contact_address_id;
	public $w9_file_manager_file_id;
	public $taxpayer_identification_number_id;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrVendorsByVendorContactCompanyId;
	protected static $_arrVendorsByVendorContactCompanyOfficeId;
	protected static $_arrVendorsByVendorContactId;
	protected static $_arrVendorsByVendorContactAddressId;
	protected static $_arrVendorsByW9FileManagerFileId;
	protected static $_arrVendorsByTaxpayerIdentificationNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllVendors;

	// Foreign Key Objects
	private $_vendorContactCompany;
	private $_vendorContactCompanyOffice;
	private $_vendorContact;
	private $_vendorContactAddress;
	private $_w9FileManagerFile;
	private $_taxpayerIdentificationNumber;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='vendors')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getVendorContactCompany()
	{
		if (isset($this->_vendorContactCompany)) {
			return $this->_vendorContactCompany;
		} else {
			return null;
		}
	}

	public function setVendorContactCompany($vendorContactCompany)
	{
		$this->_vendorContactCompany = $vendorContactCompany;
	}

	public function getVendorContactCompanyOffice()
	{
		if (isset($this->_vendorContactCompanyOffice)) {
			return $this->_vendorContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setVendorContactCompanyOffice($vendorContactCompanyOffice)
	{
		$this->_vendorContactCompanyOffice = $vendorContactCompanyOffice;
	}

	public function getVendorContact()
	{
		if (isset($this->_vendorContact)) {
			return $this->_vendorContact;
		} else {
			return null;
		}
	}

	public function setVendorContact($vendorContact)
	{
		$this->_vendorContact = $vendorContact;
	}

	public function getVendorContactAddress()
	{
		if (isset($this->_vendorContactAddress)) {
			return $this->_vendorContactAddress;
		} else {
			return null;
		}
	}

	public function setVendorContactAddress($vendorContactAddress)
	{
		$this->_vendorContactAddress = $vendorContactAddress;
	}

	public function getW9FileManagerFile()
	{
		if (isset($this->_w9FileManagerFile)) {
			return $this->_w9FileManagerFile;
		} else {
			return null;
		}
	}

	public function setW9FileManagerFile($w9FileManagerFile)
	{
		$this->_w9FileManagerFile = $w9FileManagerFile;
	}

	public function getTaxpayerIdentificationNumber()
	{
		if (isset($this->_taxpayerIdentificationNumber)) {
			return $this->_taxpayerIdentificationNumber;
		} else {
			return null;
		}
	}

	public function setTaxpayerIdentificationNumber($taxpayerIdentificationNumber)
	{
		$this->_taxpayerIdentificationNumber = $taxpayerIdentificationNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrVendorsByVendorContactCompanyId()
	{
		if (isset(self::$_arrVendorsByVendorContactCompanyId)) {
			return self::$_arrVendorsByVendorContactCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrVendorsByVendorContactCompanyId($arrVendorsByVendorContactCompanyId)
	{
		self::$_arrVendorsByVendorContactCompanyId = $arrVendorsByVendorContactCompanyId;
	}

	public static function getArrVendorsByVendorContactCompanyOfficeId()
	{
		if (isset(self::$_arrVendorsByVendorContactCompanyOfficeId)) {
			return self::$_arrVendorsByVendorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrVendorsByVendorContactCompanyOfficeId($arrVendorsByVendorContactCompanyOfficeId)
	{
		self::$_arrVendorsByVendorContactCompanyOfficeId = $arrVendorsByVendorContactCompanyOfficeId;
	}

	public static function getArrVendorsByVendorContactId()
	{
		if (isset(self::$_arrVendorsByVendorContactId)) {
			return self::$_arrVendorsByVendorContactId;
		} else {
			return null;
		}
	}

	public static function setArrVendorsByVendorContactId($arrVendorsByVendorContactId)
	{
		self::$_arrVendorsByVendorContactId = $arrVendorsByVendorContactId;
	}

	public static function getArrVendorsByVendorContactAddressId()
	{
		if (isset(self::$_arrVendorsByVendorContactAddressId)) {
			return self::$_arrVendorsByVendorContactAddressId;
		} else {
			return null;
		}
	}

	public static function setArrVendorsByVendorContactAddressId($arrVendorsByVendorContactAddressId)
	{
		self::$_arrVendorsByVendorContactAddressId = $arrVendorsByVendorContactAddressId;
	}

	public static function getArrVendorsByW9FileManagerFileId()
	{
		if (isset(self::$_arrVendorsByW9FileManagerFileId)) {
			return self::$_arrVendorsByW9FileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrVendorsByW9FileManagerFileId($arrVendorsByW9FileManagerFileId)
	{
		self::$_arrVendorsByW9FileManagerFileId = $arrVendorsByW9FileManagerFileId;
	}

	public static function getArrVendorsByTaxpayerIdentificationNumberId()
	{
		if (isset(self::$_arrVendorsByTaxpayerIdentificationNumberId)) {
			return self::$_arrVendorsByTaxpayerIdentificationNumberId;
		} else {
			return null;
		}
	}

	public static function setArrVendorsByTaxpayerIdentificationNumberId($arrVendorsByTaxpayerIdentificationNumberId)
	{
		self::$_arrVendorsByTaxpayerIdentificationNumberId = $arrVendorsByTaxpayerIdentificationNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllVendors()
	{
		if (isset(self::$_arrAllVendors)) {
			return self::$_arrAllVendors;
		} else {
			return null;
		}
	}

	public static function setArrAllVendors($arrAllVendors)
	{
		self::$_arrAllVendors = $arrAllVendors;
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
	 * @param int $vendor_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $vendor_id,$table='vendors', $module='Vendor')
	{
		$vendor = parent::findById($database, $vendor_id,$table, $module);

		return $vendor;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $vendor_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findVendorByIdExtended($database, $vendor_id)
	{
		$vendor_id = (int) $vendor_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	v_fk_cc.`id` AS 'v_fk_cc__contact_company_id',
	v_fk_cc.`user_user_company_id` AS 'v_fk_cc__user_user_company_id',
	v_fk_cc.`contact_user_company_id` AS 'v_fk_cc__contact_user_company_id',
	v_fk_cc.`company` AS 'v_fk_cc__company',
	v_fk_cc.`primary_phone_number` AS 'v_fk_cc__primary_phone_number',
	v_fk_cc.`employer_identification_number` AS 'v_fk_cc__employer_identification_number',
	v_fk_cc.`construction_license_number` AS 'v_fk_cc__construction_license_number',
	v_fk_cc.`construction_license_number_expiration_date` AS 'v_fk_cc__construction_license_number_expiration_date',
	v_fk_cc.`vendor_flag` AS 'v_fk_cc__vendor_flag',

	v_fk_cco.`id` AS 'v_fk_cco__contact_company_office_id',
	v_fk_cco.`contact_company_id` AS 'v_fk_cco__contact_company_id',
	v_fk_cco.`office_nickname` AS 'v_fk_cco__office_nickname',
	v_fk_cco.`address_line_1` AS 'v_fk_cco__address_line_1',
	v_fk_cco.`address_line_2` AS 'v_fk_cco__address_line_2',
	v_fk_cco.`address_line_3` AS 'v_fk_cco__address_line_3',
	v_fk_cco.`address_line_4` AS 'v_fk_cco__address_line_4',
	v_fk_cco.`address_city` AS 'v_fk_cco__address_city',
	v_fk_cco.`address_county` AS 'v_fk_cco__address_county',
	v_fk_cco.`address_state_or_region` AS 'v_fk_cco__address_state_or_region',
	v_fk_cco.`address_postal_code` AS 'v_fk_cco__address_postal_code',
	v_fk_cco.`address_postal_code_extension` AS 'v_fk_cco__address_postal_code_extension',
	v_fk_cco.`address_country` AS 'v_fk_cco__address_country',
	v_fk_cco.`head_quarters_flag` AS 'v_fk_cco__head_quarters_flag',
	v_fk_cco.`address_validated_by_user_flag` AS 'v_fk_cco__address_validated_by_user_flag',
	v_fk_cco.`address_validated_by_web_service_flag` AS 'v_fk_cco__address_validated_by_web_service_flag',
	v_fk_cco.`address_validation_by_web_service_error_flag` AS 'v_fk_cco__address_validation_by_web_service_error_flag',

	v_fk_c.`id` AS 'v_fk_c__contact_id',
	v_fk_c.`user_company_id` AS 'v_fk_c__user_company_id',
	v_fk_c.`user_id` AS 'v_fk_c__user_id',
	v_fk_c.`contact_company_id` AS 'v_fk_c__contact_company_id',
	v_fk_c.`email` AS 'v_fk_c__email',
	v_fk_c.`name_prefix` AS 'v_fk_c__name_prefix',
	v_fk_c.`first_name` AS 'v_fk_c__first_name',
	v_fk_c.`additional_name` AS 'v_fk_c__additional_name',
	v_fk_c.`middle_name` AS 'v_fk_c__middle_name',
	v_fk_c.`last_name` AS 'v_fk_c__last_name',
	v_fk_c.`name_suffix` AS 'v_fk_c__name_suffix',
	v_fk_c.`title` AS 'v_fk_c__title',
	v_fk_c.`vendor_flag` AS 'v_fk_c__vendor_flag',

	v_fk_ca.`id` AS 'v_fk_ca__contact_address_id',
	v_fk_ca.`contact_id` AS 'v_fk_ca__contact_id',
	v_fk_ca.`address_nickname` AS 'v_fk_ca__address_nickname',
	v_fk_ca.`address_line_1` AS 'v_fk_ca__address_line_1',
	v_fk_ca.`address_line_2` AS 'v_fk_ca__address_line_2',
	v_fk_ca.`address_line_3` AS 'v_fk_ca__address_line_3',
	v_fk_ca.`address_line_4` AS 'v_fk_ca__address_line_4',
	v_fk_ca.`address_city` AS 'v_fk_ca__address_city',
	v_fk_ca.`address_county` AS 'v_fk_ca__address_county',
	v_fk_ca.`address_state_or_region` AS 'v_fk_ca__address_state_or_region',
	v_fk_ca.`address_postal_code` AS 'v_fk_ca__address_postal_code',
	v_fk_ca.`address_postal_code_extension` AS 'v_fk_ca__address_postal_code_extension',
	v_fk_ca.`address_country` AS 'v_fk_ca__address_country',
	v_fk_ca.`default_address_flag` AS 'v_fk_ca__default_address_flag',
	v_fk_ca.`address_validated_by_user_flag` AS 'v_fk_ca__address_validated_by_user_flag',
	v_fk_ca.`address_validated_by_web_service_flag` AS 'v_fk_ca__address_validated_by_web_service_flag',
	v_fk_ca.`address_validation_by_web_service_error_flag` AS 'v_fk_ca__address_validation_by_web_service_error_flag',

	v_fk_w9_fmfiles.`id` AS 'v_fk_w9_fmfiles__file_manager_file_id',
	v_fk_w9_fmfiles.`user_company_id` AS 'v_fk_w9_fmfiles__user_company_id',
	v_fk_w9_fmfiles.`contact_id` AS 'v_fk_w9_fmfiles__contact_id',
	v_fk_w9_fmfiles.`project_id` AS 'v_fk_w9_fmfiles__project_id',
	v_fk_w9_fmfiles.`file_manager_folder_id` AS 'v_fk_w9_fmfiles__file_manager_folder_id',
	v_fk_w9_fmfiles.`file_location_id` AS 'v_fk_w9_fmfiles__file_location_id',
	v_fk_w9_fmfiles.`virtual_file_name` AS 'v_fk_w9_fmfiles__virtual_file_name',
	v_fk_w9_fmfiles.`version_number` AS 'v_fk_w9_fmfiles__version_number',
	v_fk_w9_fmfiles.`virtual_file_name_sha1` AS 'v_fk_w9_fmfiles__virtual_file_name_sha1',
	v_fk_w9_fmfiles.`virtual_file_mime_type` AS 'v_fk_w9_fmfiles__virtual_file_mime_type',
	v_fk_w9_fmfiles.`modified` AS 'v_fk_w9_fmfiles__modified',
	v_fk_w9_fmfiles.`created` AS 'v_fk_w9_fmfiles__created',
	v_fk_w9_fmfiles.`deleted_flag` AS 'v_fk_w9_fmfiles__deleted_flag',
	v_fk_w9_fmfiles.`directly_deleted_flag` AS 'v_fk_w9_fmfiles__directly_deleted_flag',

	v_fk_tin.`id` AS 'v_fk_tin__taxpayer_identification_number_id',
	v_fk_tin.`taxpayer_identification_number` AS 'v_fk_tin__taxpayer_identification_number',

	v.*

FROM `vendors` v
	INNER JOIN `contact_companies` v_fk_cc ON v.`vendor_contact_company_id` = v_fk_cc.`id`
	LEFT OUTER JOIN `contact_company_offices` v_fk_cco ON v.`vendor_contact_company_office_id` = v_fk_cco.`id`
	LEFT OUTER JOIN `contacts` v_fk_c ON v.`vendor_contact_id` = v_fk_c.`id`
	LEFT OUTER JOIN `contact_addresses` v_fk_ca ON v.`vendor_contact_address_id` = v_fk_ca.`id`
	LEFT OUTER JOIN `file_manager_files` v_fk_w9_fmfiles ON v.`w9_file_manager_file_id` = v_fk_w9_fmfiles.`id`
	LEFT OUTER JOIN `taxpayer_identification_numbers` v_fk_tin ON v.`taxpayer_identification_number_id` = v_fk_tin.`id`
WHERE v.`id` = ?
";
		$arrValues = array($vendor_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$vendor_id = $row['id'];
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id);
			/* @var $vendor Vendor */
			$vendor->convertPropertiesToData();

			if (isset($row['vendor_contact_company_id'])) {
				$vendor_contact_company_id = $row['vendor_contact_company_id'];
				$row['v_fk_cc__id'] = $vendor_contact_company_id;
				$vendorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $vendor_contact_company_id, 'v_fk_cc__');
				/* @var $vendorContactCompany ContactCompany */
				$vendorContactCompany->convertPropertiesToData();
			} else {
				$vendorContactCompany = false;
			}
			$vendor->setVendorContactCompany($vendorContactCompany);

			if (isset($row['vendor_contact_company_office_id'])) {
				$vendor_contact_company_office_id = $row['vendor_contact_company_office_id'];
				$row['v_fk_cco__id'] = $vendor_contact_company_office_id;
				$vendorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $vendor_contact_company_office_id, 'v_fk_cco__');
				/* @var $vendorContactCompanyOffice ContactCompanyOffice */
				$vendorContactCompanyOffice->convertPropertiesToData();
			} else {
				$vendorContactCompanyOffice = false;
			}
			$vendor->setVendorContactCompanyOffice($vendorContactCompanyOffice);

			if (isset($row['vendor_contact_id'])) {
				$vendor_contact_id = $row['vendor_contact_id'];
				$row['v_fk_c__id'] = $vendor_contact_id;
				$vendorContact = self::instantiateOrm($database, 'Contact', $row, null, $vendor_contact_id, 'v_fk_c__');
				/* @var $vendorContact Contact */
				$vendorContact->convertPropertiesToData();
			} else {
				$vendorContact = false;
			}
			$vendor->setVendorContact($vendorContact);

			if (isset($row['vendor_contact_address_id'])) {
				$vendor_contact_address_id = $row['vendor_contact_address_id'];
				$row['v_fk_ca__id'] = $vendor_contact_address_id;
				$vendorContactAddress = self::instantiateOrm($database, 'ContactAddress', $row, null, $vendor_contact_address_id, 'v_fk_ca__');
				/* @var $vendorContactAddress ContactAddress */
				$vendorContactAddress->convertPropertiesToData();
			} else {
				$vendorContactAddress = false;
			}
			$vendor->setVendorContactAddress($vendorContactAddress);

			if (isset($row['w9_file_manager_file_id'])) {
				$w9_file_manager_file_id = $row['w9_file_manager_file_id'];
				$row['v_fk_w9_fmfiles__id'] = $w9_file_manager_file_id;
				$w9FileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $w9_file_manager_file_id, 'v_fk_w9_fmfiles__');
				/* @var $w9FileManagerFile FileManagerFile */
				$w9FileManagerFile->convertPropertiesToData();
			} else {
				$w9FileManagerFile = false;
			}
			$vendor->setW9FileManagerFile($w9FileManagerFile);

			if (isset($row['taxpayer_identification_number_id'])) {
				$taxpayer_identification_number_id = $row['taxpayer_identification_number_id'];
				$row['v_fk_tin__id'] = $taxpayer_identification_number_id;
				$taxpayerIdentificationNumber = self::instantiateOrm($database, 'TaxpayerIdentificationNumber', $row, null, $taxpayer_identification_number_id, 'v_fk_tin__');
				/* @var $taxpayerIdentificationNumber TaxpayerIdentificationNumber */
				$taxpayerIdentificationNumber->convertPropertiesToData();
			} else {
				$taxpayerIdentificationNumber = false;
			}
			$vendor->setTaxpayerIdentificationNumber($taxpayerIdentificationNumber);

			return $vendor;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_vendor` (`vendor_contact_company_id`,`vendor_contact_id`).
	 *
	 * @param string $database
	 * @param int $vendor_contact_company_id
	 * @param int $vendor_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByVendorContactCompanyIdAndVendorContactId($database, $vendor_contact_company_id, $vendor_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if (isset($vendor_contact_company_id) && is_null($vendor_contact_id)) {
			$query =
"
SELECT
	v.*

FROM `vendors` v
WHERE v.`vendor_contact_company_id` = ?
AND v.`vendor_contact_id` IS NULL
";
			$arrValues = array($vendor_contact_company_id);
		} else if (is_null($vendor_contact_company_id) && isset($vendor_contact_id)) {
			$query =
"
SELECT
	v.*
FROM `vendors` v
WHERE v.`vendor_contact_company_id` = IS NULL
AND v.`vendor_contact_id` = ?
";
			$arrValues = array($vendor_contact_id);
		} else {
			$query =
"
SELECT
	v.*

FROM `vendors` v
WHERE v.`vendor_contact_company_id` = ?
AND v.`vendor_contact_id` = ?
";
			$arrValues = array($vendor_contact_company_id, $vendor_contact_id);
		}
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$vendor_id = $row['id'];
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id);
			/* @var $vendor Vendor */
			return $vendor;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrVendorIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadVendorsByArrVendorIds($database, $arrVendorIds, Input $options=null)
	{
		if (empty($arrVendorIds)) {
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
		// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpVendor = new Vendor($database);
			$sqlOrderByColumns = $tmpVendor->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrVendorIds as $k => $vendor_id) {
			$vendor_id = (int) $vendor_id;
			$arrVendorIds[$k] = $db->escape($vendor_id);
		}
		$csvVendorIds = join(',', $arrVendorIds);

		$query =
"
SELECT

	v.*

FROM `vendors` v
WHERE v.`id` IN ($csvVendorIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrVendorsByCsvVendorIds = array();
		while ($row = $db->fetch()) {
			$vendor_id = $row['id'];
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id);
			/* @var $vendor Vendor */
			$vendor->convertPropertiesToData();

			$arrVendorsByCsvVendorIds[$vendor_id] = $vendor;
		}

		$db->free_result();

		return $arrVendorsByCsvVendorIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `vendors_fk_cc` foreign key (`vendor_contact_company_id`) references `contact_companies` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $vendor_contact_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadVendorsByVendorContactCompanyId($database, $vendor_contact_company_id, Input $options=null)
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
			self::$_arrVendorsByVendorContactCompanyId = null;
		}

		$arrVendorsByVendorContactCompanyId = self::$_arrVendorsByVendorContactCompanyId;
		if (isset($arrVendorsByVendorContactCompanyId) && !empty($arrVendorsByVendorContactCompanyId)) {
			return $arrVendorsByVendorContactCompanyId;
		}

		$vendor_contact_company_id = (int) $vendor_contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpVendor = new Vendor($database);
			$sqlOrderByColumns = $tmpVendor->constructSqlOrderByColumns($arrOrderByAttributes);

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
	v.*

FROM `vendors` v
WHERE v.`vendor_contact_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$arrValues = array($vendor_contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrVendorsByVendorContactCompanyId = array();
		while ($row = $db->fetch()) {
			$vendor_id = $row['id'];
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id);
			/* @var $vendor Vendor */
			$arrVendorsByVendorContactCompanyId[$vendor_id] = $vendor;
		}

		$db->free_result();

		self::$_arrVendorsByVendorContactCompanyId = $arrVendorsByVendorContactCompanyId;

		return $arrVendorsByVendorContactCompanyId;
	}

	/**
	 * Load by constraint `vendors_fk_cco` foreign key (`vendor_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $vendor_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadVendorsByVendorContactCompanyOfficeId($database, $vendor_contact_company_office_id, Input $options=null)
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
			self::$_arrVendorsByVendorContactCompanyOfficeId = null;
		}

		$arrVendorsByVendorContactCompanyOfficeId = self::$_arrVendorsByVendorContactCompanyOfficeId;
		if (isset($arrVendorsByVendorContactCompanyOfficeId) && !empty($arrVendorsByVendorContactCompanyOfficeId)) {
			return $arrVendorsByVendorContactCompanyOfficeId;
		}

		$vendor_contact_company_office_id = (int) $vendor_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpVendor = new Vendor($database);
			$sqlOrderByColumns = $tmpVendor->constructSqlOrderByColumns($arrOrderByAttributes);

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
	v.*

FROM `vendors` v
WHERE v.`vendor_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$arrValues = array($vendor_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrVendorsByVendorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$vendor_id = $row['id'];
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id);
			/* @var $vendor Vendor */
			$arrVendorsByVendorContactCompanyOfficeId[$vendor_id] = $vendor;
		}

		$db->free_result();

		self::$_arrVendorsByVendorContactCompanyOfficeId = $arrVendorsByVendorContactCompanyOfficeId;

		return $arrVendorsByVendorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `vendors_fk_c` foreign key (`vendor_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $vendor_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadVendorsByVendorContactId($database, $vendor_contact_id, Input $options=null)
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
			self::$_arrVendorsByVendorContactId = null;
		}

		$arrVendorsByVendorContactId = self::$_arrVendorsByVendorContactId;
		if (isset($arrVendorsByVendorContactId) && !empty($arrVendorsByVendorContactId)) {
			return $arrVendorsByVendorContactId;
		}

		$vendor_contact_id = (int) $vendor_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpVendor = new Vendor($database);
			$sqlOrderByColumns = $tmpVendor->constructSqlOrderByColumns($arrOrderByAttributes);

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
	v.*

FROM `vendors` v
WHERE v.`vendor_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$arrValues = array($vendor_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrVendorsByVendorContactId = array();
		while ($row = $db->fetch()) {
			$vendor_id = $row['id'];
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id);
			/* @var $vendor Vendor */
			$arrVendorsByVendorContactId[$vendor_id] = $vendor;
		}

		$db->free_result();

		self::$_arrVendorsByVendorContactId = $arrVendorsByVendorContactId;

		return $arrVendorsByVendorContactId;
	}

	/**
	 * Load by constraint `vendors_fk_ca` foreign key (`vendor_contact_address_id`) references `contact_addresses` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $vendor_contact_address_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadVendorsByVendorContactAddressId($database, $vendor_contact_address_id, Input $options=null)
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
			self::$_arrVendorsByVendorContactAddressId = null;
		}

		$arrVendorsByVendorContactAddressId = self::$_arrVendorsByVendorContactAddressId;
		if (isset($arrVendorsByVendorContactAddressId) && !empty($arrVendorsByVendorContactAddressId)) {
			return $arrVendorsByVendorContactAddressId;
		}

		$vendor_contact_address_id = (int) $vendor_contact_address_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpVendor = new Vendor($database);
			$sqlOrderByColumns = $tmpVendor->constructSqlOrderByColumns($arrOrderByAttributes);

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
	v.*

FROM `vendors` v
WHERE v.`vendor_contact_address_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$arrValues = array($vendor_contact_address_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrVendorsByVendorContactAddressId = array();
		while ($row = $db->fetch()) {
			$vendor_id = $row['id'];
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id);
			/* @var $vendor Vendor */
			$arrVendorsByVendorContactAddressId[$vendor_id] = $vendor;
		}

		$db->free_result();

		self::$_arrVendorsByVendorContactAddressId = $arrVendorsByVendorContactAddressId;

		return $arrVendorsByVendorContactAddressId;
	}

	/**
	 * Load by constraint `vendors_fk_w9_fmfiles` foreign key (`w9_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $w9_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadVendorsByW9FileManagerFileId($database, $w9_file_manager_file_id, Input $options=null)
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
			self::$_arrVendorsByW9FileManagerFileId = null;
		}

		$arrVendorsByW9FileManagerFileId = self::$_arrVendorsByW9FileManagerFileId;
		if (isset($arrVendorsByW9FileManagerFileId) && !empty($arrVendorsByW9FileManagerFileId)) {
			return $arrVendorsByW9FileManagerFileId;
		}

		$w9_file_manager_file_id = (int) $w9_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpVendor = new Vendor($database);
			$sqlOrderByColumns = $tmpVendor->constructSqlOrderByColumns($arrOrderByAttributes);

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
	v.*

FROM `vendors` v
WHERE v.`w9_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$arrValues = array($w9_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrVendorsByW9FileManagerFileId = array();
		while ($row = $db->fetch()) {
			$vendor_id = $row['id'];
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id);
			/* @var $vendor Vendor */
			$arrVendorsByW9FileManagerFileId[$vendor_id] = $vendor;
		}

		$db->free_result();

		self::$_arrVendorsByW9FileManagerFileId = $arrVendorsByW9FileManagerFileId;

		return $arrVendorsByW9FileManagerFileId;
	}

	/**
	 * Load by constraint `vendors_fk_tin` foreign key (`taxpayer_identification_number_id`) references `taxpayer_identification_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $taxpayer_identification_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadVendorsByTaxpayerIdentificationNumberId($database, $taxpayer_identification_number_id, Input $options=null)
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
			self::$_arrVendorsByTaxpayerIdentificationNumberId = null;
		}

		$arrVendorsByTaxpayerIdentificationNumberId = self::$_arrVendorsByTaxpayerIdentificationNumberId;
		if (isset($arrVendorsByTaxpayerIdentificationNumberId) && !empty($arrVendorsByTaxpayerIdentificationNumberId)) {
			return $arrVendorsByTaxpayerIdentificationNumberId;
		}

		$taxpayer_identification_number_id = (int) $taxpayer_identification_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpVendor = new Vendor($database);
			$sqlOrderByColumns = $tmpVendor->constructSqlOrderByColumns($arrOrderByAttributes);

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
	v.*

FROM `vendors` v
WHERE v.`taxpayer_identification_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$arrValues = array($taxpayer_identification_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrVendorsByTaxpayerIdentificationNumberId = array();
		while ($row = $db->fetch()) {
			$vendor_id = $row['id'];
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id);
			/* @var $vendor Vendor */
			$arrVendorsByTaxpayerIdentificationNumberId[$vendor_id] = $vendor;
		}

		$db->free_result();

		self::$_arrVendorsByTaxpayerIdentificationNumberId = $arrVendorsByTaxpayerIdentificationNumberId;

		return $arrVendorsByTaxpayerIdentificationNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all vendors records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllVendors($database, Input $options=null)
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
			self::$_arrAllVendors = null;
		}

		$arrAllVendors = self::$_arrAllVendors;
		if (isset($arrAllVendors) && !empty($arrAllVendors)) {
			return $arrAllVendors;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpVendor = new Vendor($database);
			$sqlOrderByColumns = $tmpVendor->constructSqlOrderByColumns($arrOrderByAttributes);

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
	v.*

FROM `vendors` v{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `vendor_contact_company_id` ASC, `vendor_contact_company_office_id` ASC, `vendor_contact_id` ASC, `vendor_contact_address_id` ASC, `w9_file_manager_file_id` ASC, `taxpayer_identification_number_id` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllVendors = array();
		while ($row = $db->fetch()) {
			$vendor_id = $row['id'];
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id);
			/* @var $vendor Vendor */
			$arrAllVendors[$vendor_id] = $vendor;
		}

		$db->free_result();

		self::$_arrAllVendors = $arrAllVendors;

		return $arrAllVendors;
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
INTO `vendors`
(`vendor_contact_company_id`, `vendor_contact_company_office_id`, `vendor_contact_id`, `vendor_contact_address_id`, `w9_file_manager_file_id`, `taxpayer_identification_number_id`, `disabled_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `vendor_contact_company_office_id` = ?, `vendor_contact_address_id` = ?, `w9_file_manager_file_id` = ?, `taxpayer_identification_number_id` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->vendor_contact_company_id, $this->vendor_contact_company_office_id, $this->vendor_contact_id, $this->vendor_contact_address_id, $this->w9_file_manager_file_id, $this->taxpayer_identification_number_id, $this->disabled_flag, $this->vendor_contact_company_office_id, $this->vendor_contact_address_id, $this->w9_file_manager_file_id, $this->taxpayer_identification_number_id, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$vendor_id = $db->insertId;
		$db->free_result();

		return $vendor_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
