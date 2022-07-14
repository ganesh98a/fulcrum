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
* CostCodeDivider.
*
* @category   Framework
* @package    CostCodeDivider
*/

/**
* @see IntegratedMapper
*/
//require_once('lib/common/IntegratedMapper.php');

class CostCodeDividerForUserCompany extends IntegratedMapper
{
	/**
	* Class name for use in deltifyAndSave().
	*/
	protected $_className = 'CostCodeDividerForUserCompany';

	/**
	* Table name for this Integrated Mapper.
	*
	* @var string
	*/
	protected $_table = 'cost_code_divider_for_user_company';

	/**
	* primary key (`id`)
	*
	* 'db_table_attribute' => 'type'
	*
	* @var array
	*/
	protected $_arrPrimaryKey = array(
		'user_company_id' => 'int',
		'divider_id' => 'int'
	);

	/**
	* unique index `unique_cost_code_divider_for_user_company` (`unique_cost_code_divider_for_user_company`)
	*
	* 'db_table_attribute' => 'type'
	*
	* @var array
	*/
	protected $_arrUniqueness = array(
		'unique_cost_code_divider_for_user_company' => array(
			'user_company_id' => 'int',
			'divider_id' => 'int'
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
		'user_company_id' => 'user_company_id',
		'divider_id' => 'divider_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_company_id;

	public $divider_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_user_company_id;

	public $escaped_divider_id;


	// Foreign Key Objects

	/**
	* Constructor
	*/
	public function __construct($database, $table='cost_code_divider_for_user_company')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)


	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	* PHP < 5.3.0
	*
	* @param string $database
	* @param int $cost_code_divider_for_user_company_id
	* @return mixed (single ORM object | false)
	*/
	public static function findById($database, $cost_code_divider_for_user_company_id, $table='cost_code_divider_for_user_company', $module='CostCodeDividerForUserCompany')
	{
		$CostCodeDividerForUserCompany = parent::findById($database, $cost_code_divider_for_user_company_id, $table, $module);

		return $CostCodeDividerForUserCompany;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	* Similar to FindById, but with SQL as starter code for more complex joins.
	*
	* @param string $database
	* @param int $cost_code_divider_id
	* @return mixed (single ORM object | false)
	*/
	public static function findCostCodeDividerForUserCompanyById($database, $user_company_id){
		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT
		ccd.*

		FROM `cost_code_divider_for_user_company` ccd
		WHERE ccd.`user_company_id` = ?
		";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$cost_code_divider_id = $row['id'];
			$CostCodeDividerForUserCompany = self::instantiateOrm($database, 'CostCodeDividerForUserCompany', $row, null, $cost_code_divider_id);
			/* @var $CostCodeDividerForUserCompany CostCodeDividerForUserCompany */
			$CostCodeDividerForUserCompany->convertPropertiesToData();

			return $CostCodeDividerForUserCompany;
		} else {
			return false;
		}
	}

	public static function getCostCodeDividerForUserCompanyById($database, $user_company_id){
		$user_company_id = (int) $user_company_id;
		if(empty($user_company_id)){
			return '-';
		}
		//To get the project company cost code data
			$projectexistCompanyids =$user_company_id;
			$session = Zend_Registry::get('session');
			$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
			if($user_company_id != $currentlySelectedProjectUserCompanyId)
			{
			$projectexistCompanyids = $currentlySelectedProjectUserCompanyId;
			}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT * FROM `cost_code_divider_for_user_company` ccduc
		LEFT JOIN `cost_code_divider` ccd ON ccd.`id`= ccduc.`divider_id`
		WHERE ccduc.`user_company_id` = ?
		";
		$arrValues = array($projectexistCompanyids);
		
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			return $row['divider'];
		} else {
			return '-';
		}
	}
}

/**
* Framework standard footer comments.
*
* No closing ?> tag to prevent the injection of whitespace.
*/
