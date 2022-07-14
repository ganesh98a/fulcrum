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
 * User details class to encapsulate all of the details of a user
 * excluding authentication information.
 *
 * @category   Framework
 * @package    UserDetail
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class UserDetail extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'UserDetail';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'user_details';

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
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_user_detail_via_primary_key' => array(
			'user_detail_id' => 'int'
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
		'id' => 'user_detail_id',

		'user_id' => 'user_id',

		'name_prefix' => 'name_prefix',
		'first_name' => 'first_name',
		'additional_name' => 'additional_name',
		'middle_name' => 'middle_name',
		'last_name' => 'last_name',
		'name_suffix' => 'name_suffix',
		'address_line_1' => 'address_line_1',
		'address_line_2' => 'address_line_2',
		'address_line_3' => 'address_line_3',
		'address_city' => 'address_city',
		'address_state' => 'address_state',
		'address_zip' => 'address_zip',
		'address_country' => 'address_country',
		'website' => 'website',
		'title' => 'title',
		'company_name' => 'company_name',
		'pseudonym' => 'pseudonym',
		'avatar' => 'avatar',
		'image' => 'image',
		'bgimage' => 'bgimage',
		'watermark' => 'watermark'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_detail_id;

	public $user_id;

	public $name_prefix;
	public $first_name;
	public $additional_name;
	public $middle_name;
	public $last_name;
	public $name_suffix;
	public $address_line_1;
	public $address_line_2;
	public $address_line_3;
	public $address_city;
	public $address_state;
	public $address_zip;
	public $address_country;
	public $website;
	public $title;
	public $company_name;
	public $pseudonym;
	public $avatar;
	public $image;
	public $bgimage;
	public $watermark;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_name_prefix;
	public $escaped_first_name;
	public $escaped_additional_name;
	public $escaped_middle_name;
	public $escaped_last_name;
	public $escaped_name_suffix;
	public $escaped_address_line_1;
	public $escaped_address_line_2;
	public $escaped_address_line_3;
	public $escaped_address_city;
	public $escaped_address_state;
	public $escaped_address_zip;
	public $escaped_address_country;
	public $escaped_website;
	public $escaped_title;
	public $escaped_company_name;
	public $escaped_pseudonym;
	public $escaped_avatar;
	public $escaped_image;
	public $escaped_bgimage;
	public $escaped_watermark;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_name_prefix_nl2br;
	public $escaped_first_name_nl2br;
	public $escaped_additional_name_nl2br;
	public $escaped_middle_name_nl2br;
	public $escaped_last_name_nl2br;
	public $escaped_name_suffix_nl2br;
	public $escaped_address_line_1_nl2br;
	public $escaped_address_line_2_nl2br;
	public $escaped_address_line_3_nl2br;
	public $escaped_address_city_nl2br;
	public $escaped_address_state_nl2br;
	public $escaped_address_zip_nl2br;
	public $escaped_address_country_nl2br;
	public $escaped_website_nl2br;
	public $escaped_title_nl2br;
	public $escaped_company_name_nl2br;
	public $escaped_pseudonym_nl2br;
	public $escaped_avatar_nl2br;
	public $escaped_image_nl2br;
	public $escaped_bgimage_nl2br;
	public $escaped_watermark_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrUserDetailsByUserId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrUserDetailsByFirstNameAndMiddleNameAndLastName;
	protected static $_arrUserDetailsByLastName;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrUserDetailsByFirstName;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllUserDetails;

	// Foreign Key Objects
	private $_user;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='user_details')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getUser()
	{
		if (isset($this->_user)) {
			return $this->_user;
		} else {
			return null;
		}
	}

	public function setUser($user)
	{
		$this->_user = $user;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrUserDetailsByUserId()
	{
		if (isset(self::$_arrUserDetailsByUserId)) {
			return self::$_arrUserDetailsByUserId;
		} else {
			return null;
		}
	}

	public static function setArrUserDetailsByUserId($arrUserDetailsByUserId)
	{
		self::$_arrUserDetailsByUserId = $arrUserDetailsByUserId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrUserDetailsByFirstNameAndMiddleNameAndLastName()
	{
		if (isset(self::$_arrUserDetailsByFirstNameAndMiddleNameAndLastName)) {
			return self::$_arrUserDetailsByFirstNameAndMiddleNameAndLastName;
		} else {
			return null;
		}
	}

	public static function setArrUserDetailsByFirstNameAndMiddleNameAndLastName($arrUserDetailsByFirstNameAndMiddleNameAndLastName)
	{
		self::$_arrUserDetailsByFirstNameAndMiddleNameAndLastName = $arrUserDetailsByFirstNameAndMiddleNameAndLastName;
	}

	public static function getArrUserDetailsByLastName()
	{
		if (isset(self::$_arrUserDetailsByLastName)) {
			return self::$_arrUserDetailsByLastName;
		} else {
			return null;
		}
	}

	public static function setArrUserDetailsByLastName($arrUserDetailsByLastName)
	{
		self::$_arrUserDetailsByLastName = $arrUserDetailsByLastName;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrUserDetailsByFirstName()
	{
		if (isset(self::$_arrUserDetailsByFirstName)) {
			return self::$_arrUserDetailsByFirstName;
		} else {
			return null;
		}
	}

	public static function setArrUserDetailsByFirstName($arrUserDetailsByFirstName)
	{
		self::$_arrUserDetailsByFirstName = $arrUserDetailsByFirstName;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllUserDetails()
	{
		if (isset(self::$_arrAllUserDetails)) {
			return self::$_arrAllUserDetails;
		} else {
			return null;
		}
	}

	public static function setArrAllUserDetails($arrAllUserDetails)
	{
		self::$_arrAllUserDetails = $arrAllUserDetails;
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
	 * @param int $user_detail_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $user_detail_id,$table='user_details', $module='UserDetail')
	{
		$userDetail = parent::findById($database, $user_detail_id, $table, $module);

		return $userDetail;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $user_detail_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findUserDetailByIdExtended($database, $user_detail_id)
	{
		$user_detail_id = (int) $user_detail_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	ud_fk_u.`id` AS 'ud_fk_u__user_id',
	ud_fk_u.`user_company_id` AS 'ud_fk_u__user_company_id',
	ud_fk_u.`role_id` AS 'ud_fk_u__role_id',
	ud_fk_u.`default_project_id` AS 'ud_fk_u__default_project_id',
	ud_fk_u.`primary_contact_id` AS 'ud_fk_u__primary_contact_id',
	ud_fk_u.`mobile_network_carrier_id` AS 'ud_fk_u__mobile_network_carrier_id',
	ud_fk_u.`user_image_id` AS 'ud_fk_u__user_image_id',
	ud_fk_u.`security_image_id` AS 'ud_fk_u__security_image_id',
	ud_fk_u.`html_template_theme_id` AS 'ud_fk_u__html_template_theme_id',
	ud_fk_u.`mobile_phone_number` AS 'ud_fk_u__mobile_phone_number',
	ud_fk_u.`screen_name` AS 'ud_fk_u__screen_name',
	ud_fk_u.`email` AS 'ud_fk_u__email',
	ud_fk_u.`password_hash` AS 'ud_fk_u__password_hash',
	ud_fk_u.`password_guid` AS 'ud_fk_u__password_guid',
	ud_fk_u.`security_phrase` AS 'ud_fk_u__security_phrase',
	ud_fk_u.`modified` AS 'ud_fk_u__modified',
	ud_fk_u.`accessed` AS 'ud_fk_u__accessed',
	ud_fk_u.`created` AS 'ud_fk_u__created',
	ud_fk_u.`alerts` AS 'ud_fk_u__alerts',
	ud_fk_u.`tc_accepted_flag` AS 'ud_fk_u__tc_accepted_flag',
	ud_fk_u.`email_subscribe_flag` AS 'ud_fk_u__email_subscribe_flag',
	ud_fk_u.`remember_me_flag` AS 'ud_fk_u__remember_me_flag',
	ud_fk_u.`change_password_flag` AS 'ud_fk_u__change_password_flag',
	ud_fk_u.`disabled_flag` AS 'ud_fk_u__disabled_flag',
	ud_fk_u.`deleted_flag` AS 'ud_fk_u__deleted_flag',

	ud.*

FROM `user_details` ud
	INNER JOIN `users` ud_fk_u ON ud.`user_id` = ud_fk_u.`id`
WHERE ud.`id` = ?
";
		$arrValues = array($user_detail_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$user_detail_id = $row['id'];
			$userDetail = self::instantiateOrm($database, 'UserDetail', $row, null, $user_detail_id);
			/* @var $userDetail UserDetail */
			$userDetail->convertPropertiesToData();

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['ud_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'ud_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$userDetail->setUser($user);

			return $userDetail;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrUserDetailIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserDetailsByArrUserDetailIds($database, $arrUserDetailIds, Input $options=null)
	{
		if (empty($arrUserDetailIds)) {
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
		// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserDetail = new UserDetail($database);
			$sqlOrderByColumns = $tmpUserDetail->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrUserDetailIds as $k => $user_detail_id) {
			$user_detail_id = (int) $user_detail_id;
			$arrUserDetailIds[$k] = $db->escape($user_detail_id);
		}
		$csvUserDetailIds = join(',', $arrUserDetailIds);

		$query =
"
SELECT

	ud.*

FROM `user_details` ud
WHERE ud.`id` IN ($csvUserDetailIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrUserDetailsByCsvUserDetailIds = array();
		while ($row = $db->fetch()) {
			$user_detail_id = $row['id'];
			$userDetail = self::instantiateOrm($database, 'UserDetail', $row, null, $user_detail_id);
			/* @var $userDetail UserDetail */
			$userDetail->convertPropertiesToData();

			$arrUserDetailsByCsvUserDetailIds[$user_detail_id] = $userDetail;
		}

		$db->free_result();

		return $arrUserDetailsByCsvUserDetailIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `user_details_fk_u` foreign key (`user_id`) references `users` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserDetailsByUserId($database, $user_id, Input $options=null)
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
			self::$_arrUserDetailsByUserId = null;
		}

		$arrUserDetailsByUserId = self::$_arrUserDetailsByUserId;
		if (isset($arrUserDetailsByUserId) && !empty($arrUserDetailsByUserId)) {
			return $arrUserDetailsByUserId;
		}

		$user_id = (int) $user_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserDetail = new UserDetail($database);
			$sqlOrderByColumns = $tmpUserDetail->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ud.*

FROM `user_details` ud
WHERE ud.`user_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserDetailsByUserId = array();
		while ($row = $db->fetch()) {
			$user_detail_id = $row['id'];
			$userDetail = self::instantiateOrm($database, 'UserDetail', $row, null, $user_detail_id);
			/* @var $userDetail UserDetail */
			$arrUserDetailsByUserId[$user_detail_id] = $userDetail;
		}

		$db->free_result();

		self::$_arrUserDetailsByUserId = $arrUserDetailsByUserId;

		return $arrUserDetailsByUserId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `full_name` (`first_name`,`middle_name`,`last_name`).
	 *
	 * @param string $database
	 * @param string $first_name
	 * @param string $middle_name
	 * @param string $last_name
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadUserDetailsByFirstNameAndMiddleNameAndLastName($database, $first_name, $middle_name, $last_name, Input $options=null)
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
			self::$_arrUserDetailsByFirstNameAndMiddleNameAndLastName = null;
		}

		$arrUserDetailsByFirstNameAndMiddleNameAndLastName = self::$_arrUserDetailsByFirstNameAndMiddleNameAndLastName;
		if (isset($arrUserDetailsByFirstNameAndMiddleNameAndLastName) && !empty($arrUserDetailsByFirstNameAndMiddleNameAndLastName)) {
			return $arrUserDetailsByFirstNameAndMiddleNameAndLastName;
		}

		$first_name = (string) $first_name;
		$middle_name = (string) $middle_name;
		$last_name = (string) $last_name;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserDetail = new UserDetail($database);
			$sqlOrderByColumns = $tmpUserDetail->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ud.*

FROM `user_details` ud
WHERE ud.`first_name` = ?
AND ud.`middle_name` = ?
AND ud.`last_name` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$arrValues = array($first_name, $middle_name, $last_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserDetailsByFirstNameAndMiddleNameAndLastName = array();
		while ($row = $db->fetch()) {
			$user_detail_id = $row['id'];
			$userDetail = self::instantiateOrm($database, 'UserDetail', $row, null, $user_detail_id);
			/* @var $userDetail UserDetail */
			$arrUserDetailsByFirstNameAndMiddleNameAndLastName[$user_detail_id] = $userDetail;
		}

		$db->free_result();

		self::$_arrUserDetailsByFirstNameAndMiddleNameAndLastName = $arrUserDetailsByFirstNameAndMiddleNameAndLastName;

		return $arrUserDetailsByFirstNameAndMiddleNameAndLastName;
	}

	/**
	 * Load by key `last_name` (`last_name`).
	 *
	 * @param string $database
	 * @param string $last_name
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadUserDetailsByLastName($database, $last_name, Input $options=null)
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
			self::$_arrUserDetailsByLastName = null;
		}

		$arrUserDetailsByLastName = self::$_arrUserDetailsByLastName;
		if (isset($arrUserDetailsByLastName) && !empty($arrUserDetailsByLastName)) {
			return $arrUserDetailsByLastName;
		}

		$last_name = (string) $last_name;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserDetail = new UserDetail($database);
			$sqlOrderByColumns = $tmpUserDetail->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ud.*

FROM `user_details` ud
WHERE ud.`last_name` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$arrValues = array($last_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserDetailsByLastName = array();
		while ($row = $db->fetch()) {
			$user_detail_id = $row['id'];
			$userDetail = self::instantiateOrm($database, 'UserDetail', $row, null, $user_detail_id);
			/* @var $userDetail UserDetail */
			$arrUserDetailsByLastName[$user_detail_id] = $userDetail;
		}

		$db->free_result();

		self::$_arrUserDetailsByLastName = $arrUserDetailsByLastName;

		return $arrUserDetailsByLastName;
	}

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: key `full_name` (`first_name`,`middle_name`,`last_name`).
	 *
	 * @param string $database
	 * @param string $first_name
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserDetailsByFirstName($database, $first_name, Input $options=null)
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
			self::$_arrUserDetailsByFirstName = null;
		}

		$arrUserDetailsByFirstName = self::$_arrUserDetailsByFirstName;
		if (isset($arrUserDetailsByFirstName) && !empty($arrUserDetailsByFirstName)) {
			return $arrUserDetailsByFirstName;
		}

		$first_name = (string) $first_name;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserDetail = new UserDetail($database);
			$sqlOrderByColumns = $tmpUserDetail->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ud.*

FROM `user_details` ud
WHERE ud.`first_name` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$arrValues = array($first_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserDetailsByFirstName = array();
		while ($row = $db->fetch()) {
			$user_detail_id = $row['id'];
			$userDetail = self::instantiateOrm($database, 'UserDetail', $row, null, $user_detail_id);
			/* @var $userDetail UserDetail */
			$arrUserDetailsByFirstName[$user_detail_id] = $userDetail;
		}

		$db->free_result();

		self::$_arrUserDetailsByFirstName = $arrUserDetailsByFirstName;

		return $arrUserDetailsByFirstName;
	}

	// Loaders: Load All Records
	/**
	 * Load all user_details records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllUserDetails($database, Input $options=null)
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
			self::$_arrAllUserDetails = null;
		}

		$arrAllUserDetails = self::$_arrAllUserDetails;
		if (isset($arrAllUserDetails) && !empty($arrAllUserDetails)) {
			return $arrAllUserDetails;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserDetail = new UserDetail($database);
			$sqlOrderByColumns = $tmpUserDetail->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ud.*

FROM `user_details` ud{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_id` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_city` ASC, `address_state` ASC, `address_zip` ASC, `address_country` ASC, `website` ASC, `title` ASC, `company_name` ASC, `pseudonym` ASC, `avatar` ASC, `image` ASC, `bgimage` ASC, `watermark` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllUserDetails = array();
		while ($row = $db->fetch()) {
			$user_detail_id = $row['id'];
			$userDetail = self::instantiateOrm($database, 'UserDetail', $row, null, $user_detail_id);
			/* @var $userDetail UserDetail */
			$arrAllUserDetails[$user_detail_id] = $userDetail;
		}

		$db->free_result();

		self::$_arrAllUserDetails = $arrAllUserDetails;

		return $arrAllUserDetails;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	public static function findUserDetailByUserId($database, $user_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT *
FROM `user_details`
WHERE `user_id` = ?
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && isset($row['id'])) {
			$userDetails = new UserDetail($database);
			$userDetails->setData($row);
			$userDetails->convertDataToProperties();

			return $userDetails;
		} else {
			$userDetails = new UserDetail($database);

			return $userDetails;
		}

		return false;
	}

	/**
	 * Clone a Product object into a Product_Details object.
	 *
	 */
	public static function convertPostToUserDetail($database, Egpcs $post)
	{
		/* @var $post Egpcs */

		$ud = new UserDetail($database);
		$arrAttributes = $ud->getArrAttributesMap();
		// Map the form fields/inputs to Class/Object Properties so flip the $arrAttributesMap
		$arrAttributes = array_flip($arrAttributes);
		$data = $post->getData();

		$newData = array_intersect_key($data, $arrAttributes);

		// Keys need to match the database key names
		$finalData = array();
		foreach ($newData as $k => $v) {
			$databaseAttribute = $arrAttributes[$k];
			$finalData[$databaseAttribute] = $v;
		}

		// Instantiate and initialize UserDetail object
		$ud->setData($finalData);
		$ud->convertDataToProperties();

		return $ud;
	}

	/**
	 * Conditionally invoke the standard save() method after deltification.
	 *
	 */
	public function deltifyAndSave()
	{
		//load existing

		//deltify

		//save (insert, update, or do nothing)

		$newData = $this->getData();
		$row = $newData;

		// GUIDs/ID, etc.
		$user_id = $this->user_id;

		//attempt to load the record from the appropriate table
		$details_table = $this->getTable();
		$class = get_class($this);

		$key = array(
			'user_id' => $user_id
		);

		$database = $this->getDatabase();
		$p = new $class($database, $details_table);
		$p->setKey($key);
		$p->load();

		/**
		 * Conditionally Insert/Update the record.
		 *
		 * $key is conditionally set based on if record exists.
		 */
		$newData = $row;

		//Iterate over latest input from data feed and only set different values.
		//Same values will be key unset to acheive a conditional update.
		$save = false;
		$existsFlag = $p->isDataLoaded();
		if ($existsFlag) {
			//$this->details_table_id = $p->id;

			//Conditionally Update the record
			//Don't compare the key values that loaded the record.
			unset($p->id);
			//Uniquely identified records may wind up having the landing_page_url change
			//unset($p->landing_page_url);
			unset($p->modified);
			unset($p->created);
			//This attribute shouldn't even be in these tables
			unset($p->disabled_flag);
			//This attribute shouldn't even be in these tables
			unset($p->deleted_flag);
			//Uniquely identified records may wind up having the landing_page_url change
			//unset($newData['landing_page_url']);
			//not tracking deleted_flag in the details tables
			//$newData['deleted_flag'] = 0;

			$existingData = $p->getData();

			//debug
			/*
			$keyDiffFlag = Data::diffKeys($existingData, $newData);
			if (!$keyDiffFlag) {
				echo "Key:\n".print_r($key, true)."\n\n\n\n";
				echo 'Existing:'."\n";
				ksort($existingData);
				print_r($existingData);
				echo 'New:'."\n";
				ksort($newData);
				print_r($newData);
				$n = array_keys($newData);
				$e = array_keys($existingData);
				$_1 = array_diff_key($n, $e);
				echo 'New:'."\n";
				print_r($_1);
				$_2 = array_diff_key($e, $n);
				echo 'Old:'."\n";
				print_r($_2);
				throw new Exception('Keys mismatch');
			}
			*/

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$p->setData($data);
				$save = true;
			}
		} else {
			//Insert the record
			$p->setKey(null);
			$p->setData($newData);
			//Add value for created timestamp.
			//$p->created = null;
			$save = true;
		}

		//Save if needed (conditionally Insert/Update)
		if ($save) {
			$id = $p->save();

			if (isset($id)) {
				$this->details_table_id = $id;
			}
		}

		if (isset($id) && !empty($id)) {
			return $id;
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
