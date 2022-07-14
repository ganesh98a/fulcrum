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
 * RequestForInformation.
 *
 * @category   Framework
 * @package    RequestForInformation
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class BidSpreadLog extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'BidSpreadLog';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'bid_spread_log';

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
		'id' => 'bid_spread_log_id',
		'bid_spread_id' => 'bid_spread_id',
		'pdf_content' => 'pdf_content',
		
		);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $bid_spread_log_id;
	public $bid_spread_id;
	public $pdf_content;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='bid_spread_log')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Save: insert on duplicate key update
	public function insertOnDuplicateKeyUpdate()
	{
			$database = $this->getDatabase();
			$db = $this->getDb($database);
			/* @var $db DBI_mysqli */

			$query = "INSERT INTO `bid_spread_log`
			( `bid_spread_id`, `pdf_content`)
			VALUES (?, ?)
			ON DUPLICATE KEY UPDATE `bid_spread_id` = ?, `pdf_content` = ?
			";
			$arrValues = array($this->bid_spread_id,  $this->pdf_content, $this->bid_spread_id,$this->pdf_content);
			$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
			$bid_spread_log_id = $db->insertId;
			$db->free_result();

			return $bid_spread_log_id;
	}

}