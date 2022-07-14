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
 * WorkflowProgressIndicator.
 *
 * @category   Framework
 * @package    WorkflowProgressIndicator
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class WorkflowProgressIndicator extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'WorkflowProgressIndicator';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'workflow_progress_indicators';

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
		'unique_workflow_progress_indicator_via_primary_key' => array(
			'workflow_progress_indicator_id' => 'int'
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
		'id' => 'workflow_progress_indicator_id',

		'progress' => 'progress',
		'total' => 'total',
		'modified' => 'modified',
		'accessed' => 'accessed',
		'created' => 'created'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $workflow_progress_indicator_id;

	public $progress;
	public $total;
	public $modified;
	public $accessed;
	public $created;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllWorkflowProgressIndicators;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='workflow_progress_indicators')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllWorkflowProgressIndicators()
	{
		if (isset(self::$_arrAllWorkflowProgressIndicators)) {
			return self::$_arrAllWorkflowProgressIndicators;
		} else {
			return null;
		}
	}

	public static function setArrAllWorkflowProgressIndicators($arrAllWorkflowProgressIndicators)
	{
		self::$_arrAllWorkflowProgressIndicators = $arrAllWorkflowProgressIndicators;
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
	 * @param int $workflow_progress_indicator_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $workflow_progress_indicator_id,$table='workflow_progress_indicators', $module='WorkflowProgressIndicator')
	{
		$workflowProgressIndicator = parent::findById($database, $workflow_progress_indicator_id, $table,$module);

		return $workflowProgressIndicator;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $workflow_progress_indicator_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findWorkflowProgressIndicatorByIdExtended($database, $workflow_progress_indicator_id)
	{
		$workflow_progress_indicator_id = (int) $workflow_progress_indicator_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	wpi.*

FROM `workflow_progress_indicators` wpi
WHERE wpi.`id` = ?
";
		$arrValues = array($workflow_progress_indicator_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$workflow_progress_indicator_id = $row['id'];
			$workflowProgressIndicator = self::instantiateOrm($database, 'WorkflowProgressIndicator', $row, null, $workflow_progress_indicator_id);
			/* @var $workflowProgressIndicator WorkflowProgressIndicator */
			$workflowProgressIndicator->convertPropertiesToData();

			return $workflowProgressIndicator;
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
	 * @param array $arrWorkflowProgressIndicatorIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadWorkflowProgressIndicatorsByArrWorkflowProgressIndicatorIds($database, $arrWorkflowProgressIndicatorIds, Input $options=null)
	{
		if (empty($arrWorkflowProgressIndicatorIds)) {
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
		// ORDER BY `id` ASC, `progress` ASC, `total` ASC, `modified` ASC, `accessed` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWorkflowProgressIndicator = new WorkflowProgressIndicator($database);
			$sqlOrderByColumns = $tmpWorkflowProgressIndicator->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrWorkflowProgressIndicatorIds as $k => $workflow_progress_indicator_id) {
			$workflow_progress_indicator_id = (int) $workflow_progress_indicator_id;
			$arrWorkflowProgressIndicatorIds[$k] = $db->escape($workflow_progress_indicator_id);
		}
		$csvWorkflowProgressIndicatorIds = join(',', $arrWorkflowProgressIndicatorIds);

		$query =
"
SELECT

	wpi.*

FROM `workflow_progress_indicators` wpi
WHERE wpi.`id` IN ($csvWorkflowProgressIndicatorIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrWorkflowProgressIndicatorsByCsvWorkflowProgressIndicatorIds = array();
		while ($row = $db->fetch()) {
			$workflow_progress_indicator_id = $row['id'];
			$workflowProgressIndicator = self::instantiateOrm($database, 'WorkflowProgressIndicator', $row, null, $workflow_progress_indicator_id);
			/* @var $workflowProgressIndicator WorkflowProgressIndicator */
			$workflowProgressIndicator->convertPropertiesToData();

			$arrWorkflowProgressIndicatorsByCsvWorkflowProgressIndicatorIds[$workflow_progress_indicator_id] = $workflowProgressIndicator;
		}

		$db->free_result();

		return $arrWorkflowProgressIndicatorsByCsvWorkflowProgressIndicatorIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all workflow_progress_indicators records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllWorkflowProgressIndicators($database, Input $options=null)
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
			self::$_arrAllWorkflowProgressIndicators = null;
		}

		$arrAllWorkflowProgressIndicators = self::$_arrAllWorkflowProgressIndicators;
		if (isset($arrAllWorkflowProgressIndicators) && !empty($arrAllWorkflowProgressIndicators)) {
			return $arrAllWorkflowProgressIndicators;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `progress` ASC, `total` ASC, `modified` ASC, `accessed` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWorkflowProgressIndicator = new WorkflowProgressIndicator($database);
			$sqlOrderByColumns = $tmpWorkflowProgressIndicator->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wpi.*

FROM `workflow_progress_indicators` wpi{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `progress` ASC, `total` ASC, `modified` ASC, `accessed` ASC, `created` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllWorkflowProgressIndicators = array();
		while ($row = $db->fetch()) {
			$workflow_progress_indicator_id = $row['id'];
			$workflowProgressIndicator = self::instantiateOrm($database, 'WorkflowProgressIndicator', $row, null, $workflow_progress_indicator_id);
			/* @var $workflowProgressIndicator WorkflowProgressIndicator */
			$arrAllWorkflowProgressIndicators[$workflow_progress_indicator_id] = $workflowProgressIndicator;
		}

		$db->free_result();

		self::$_arrAllWorkflowProgressIndicators = $arrAllWorkflowProgressIndicators;

		return $arrAllWorkflowProgressIndicators;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	public static function createNewWorkflowProgressIndicator($database, $total=100)
	{
		$workflowProgressIndicator = new WorkflowProgressIndicator($database);

		$data = array(
			'progress' => 0,
			'total' => $total,
			'created' => null,
			'modified' => null,
			'accessed' => null,
		);

		$workflowProgressIndicator->setData($data);

		$workflowProgressIndicator->convertDataToProperties();
		$workflow_progress_indicator_id = $workflowProgressIndicator->save();
		$workflowProgressIndicator->workflow_progress_indicator_id = $workflow_progress_indicator_id;
		$key = array(
			'id' => $workflow_progress_indicator_id
		);
		$workflowProgressIndicator->setKey($key);
		$workflowProgressIndicator->setId($workflow_progress_indicator_id);

		return $workflowProgressIndicator;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
