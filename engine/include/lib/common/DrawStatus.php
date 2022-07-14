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
* DrawStatus.
*
* @category   Framework
* @package    DrawStatus
*/

/**
* @see IntegratedMapper
*/
//require_once('lib/common/IntegratedMapper.php');

class DrawStatus extends IntegratedMapper
{
  /**
  * Class name for use in deltifyAndSave().
  */
  protected $_className = 'DrawStatus';

  /**
  * Table name for this Integrated Mapper.
  *
  * @var string
  */
  protected $_table = 'draw_status';

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
    'id' => 'draw_id',
    'status' => 'status',
  );

  // ORM properties (instance variables) derived from the Database table attributes (fields)
  public $id;
  public $status;

  /**
  * Constructor
  */
  public function __construct($database, $table='draw_status')
  {
    parent::__construct($table);
    $this->setDatabase($database);
  }
  /**
  * Get draw's status
  */
  public static function getDrawsStatus($database){

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */

    $query ="
    SELECT * FROM draw_status";
    $db->execute($query);
    $records = array();
    while($row = $db->fetch())
    {
      $records[] = $row;
    }
    $db->free_result();
    return $records;
  }

}
/**
* Framework standard footer comments.
*
* No closing ?> tag to prevent the injection of whitespace.
*/
