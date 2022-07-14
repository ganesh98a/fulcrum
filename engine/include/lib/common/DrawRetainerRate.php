<?php
/**
* Framework standard header comments.
*
* ?UTF-8? Encoding Check - Smart quotes instead of three bogus characters.
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
* DrawRetainerRate.
*
* @category   Framework
* @package    DrawRetainerRate
*/

/**
* @see IntegratedMapper
*/
//require_once('lib/common/IntegratedMapper.php');

class DrawRetainerRate extends IntegratedMapper
{
  /**
  * Class name for use in deltifyAndSave().
  */
  protected $_className = 'DrawRetainerRate';

  /**
  * Table name for this Integrated Mapper.
  *
  * @var string
  */
  protected $_table = 'draw_retainer_rate';

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
    'id' => 'draw_retainer_rate_id',
    'draw_item_id' => 'draw_item_id',
    'project_id' => 'project_id',
    'cost_code_id' => 'cost_code_id',
    'gc_budget_line_item_id' => 'gc_budget_line_item_id',
    'change_order_id' => 'change_order_id',
    'retainer_rate' => 'retainer_rate',
    'created' => 'created'
  );

  // ORM properties (instance variables) derived from the Database table attributes (fields)
  public $draw_retainer_rate_id;
  public $draw_item_id;
  public $project_id;
  public $cost_code_id;
  public $gc_budget_line_item_id;
  public $change_order_id;
  public $retainer_rate;
  public $created;

  /**
  * Constructor
  */
  public function __construct($database, $table='draw_retainer_rate')
  {
    parent::__construct($table);
    $this->setDatabase($database);
  }
  /**
   * Get project's cost code retainer rate
   */
  public static function getBudgetRetainerRate($database,$projectId,$budgetLineItemId){
    $projectId = (int) $projectId;
    $budgetLineItemId = (int) $budgetLineItemId;
    $db = DBI::getInstance($database);
    $query ="
    SELECT gcbli.`id`,p.`retainer_rate` project_retainer_rate,drr.`retainer_rate` draw_retainer_rate,
    drr.`id`,drr.`retainer_flag`
    FROM `gc_budget_line_items` gcbli
    LEFT JOIN `projects` p ON p.`id` = gcbli.`project_id`
    LEFT JOIN `draw_retainer_rate` drr ON drr.`project_id` = gcbli.`project_id` AND gcbli.`id`=drr.`gc_budget_line_item_id`
    WHERE gcbli.`project_id`=? AND gcbli.`id`=? ORDER BY drr.`id` DESC LIMIT 1
    ";
    $arrValues = array($projectId,$budgetLineItemId);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $db->free_result();
    return $row;
  }

  /**
   * Get project's change order retainer rate
   */
  public static function getCORetainerRate($database,$projectId,$changeOrderId){
    $projectId = (int) $projectId;
    $changeOrderId = (int) $changeOrderId;
    $db = DBI::getInstance($database);
    $query ="
    SELECT co.`id`,p.`retainer_rate` project_retainer_rate,drr.`retainer_rate` draw_retainer_rate,
    drr.`id`,drr.`retainer_flag`
    FROM `change_orders` co
    LEFT JOIN `projects` p ON p.`id` = co.`project_id`
    LEFT JOIN `draw_retainer_rate` drr ON drr.`project_id` = co.`project_id` AND co.`id`=drr.`change_order_id`
    WHERE co.`project_id`=? AND co.`id`=? ORDER BY drr.`id` DESC LIMIT 1
    ";
    $arrValues = array($projectId,$changeOrderId);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $db->free_result();
    return $row;
  }
}
/**
* Framework standard footer comments.
*
* No closing ?> tag to prevent the injection of whitespace.
*/
