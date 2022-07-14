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
* Draws.
*
* @category   Framework
* @package    Draws
*/

/**
* @see IntegratedMapper
*/
//require_once('lib/common/IntegratedMapper.php');

class RetentionDraws extends IntegratedMapper
{
  /**
  * Class name for use in deltifyAndSave().
  */
  protected $_className = 'RetentionDraws';

  /**
  * Table name for this Integrated Mapper.
  *
  * @var string
  */
  protected $_table = 'retention_draws';

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
  * unique index `unique_draw` (`project_id`,`application_number`) comment 'One Project can have many Draws with an application number.'
  *
  * 'db_table_attribute' => 'type'
  *
  * @var array
  */
  protected $_arrUniqueness = array(
    'unique_draw' => array(
      'project_id' => 'int',
      'application_number' => 'int'
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
    'id' => 'retention_id',
    'project_id' => 'project_id',
    'contracting_entity_id' => 'contracting_entity_id',
    'last_draw_id' => 'last_draw_id ',
    'application_number' => 'application_number',
    'through_date' => 'through_date',
    'invoice_date' => 'invoice_date',
    'status' => 'status',
    'posted_at'=>'posted_at',
    'created_by' => 'created_by',
    'updated_by' => 'updated_by',
    'created' => 'created',
    'is_deleted_flag' => 'is_deleted_flag'
  );

  // ORM properties (instance variables) derived from the Database table attributes (fields)
  public $retention_id;
  public $project_id;
  public $contracting_entity_id;
  public $last_draw_id;
  public $application_number;
  public $through_date;
  public $invoice_date;
  public $status;
  public $posted_at;
  public $created_by;
  public $updated_by;
  public $created;
  public $is_deleted_flag;

  /**
  * Constructor
  */
  public function __construct($database, $table='retention_draws')
  {
    parent::__construct($table);
    $this->setDatabase($database);
  }
  // Finder: Find By pk (a single auto int id or a single non auto int pk)
  /**
   * PHP < 5.3.0
   *
   * @param string $database
   * @param int $contact_id
   * @return mixed (single ORM object | false)
   */
  public static function findById($database, $retention_id, $table='retention_draws', $module='RetentionDraws')
  { 
    $retention = parent::findById($database, $retention_id, $table, $module);
    
    return $retention;
  }

   /*
  * Get the project draft draw count
  */
  public static function findDraftRetentionIdUsingProjectId($database, $project_id) {
    $lastDrawId = 0;

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */
    $is_deleted_flag = 'N';
   $query =
    "
    SELECT *
    FROM `retention_draws` d
    WHERE d.`project_id` = ? AND d.`status` = ? AND d.`is_deleted_flag` = ?
    ORDER BY d.`id` DESC
    ";
    $arrValues = array($project_id, 1, $is_deleted_flag);
    $db->execute($query, $arrValues);
    $row = $db->fetch();
    $rowCount =  $db->rowCount;
    $db->free_result();
    return $rowCount;
  }

   /*
  * Get the project last Retention id from now created
  */
  public function findLastRetentionIdUsingProjectId($database, $project_id,$column = '') {
    $lastDrawId = 0;

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */
    $is_deleted_flag = 'N';
    $query =
    "
    SELECT *
    FROM `retention_draws` d
    WHERE d.`project_id` = ? AND d.`is_deleted_flag` = ?
    ORDER BY d.`id` DESC
    ";
    $arrValues = array($project_id, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);

    $row = $db->fetch();
    $db->free_result();

    if ($row) {
      if($column!="")
      {
        $lastDrawId = $row[$column];
      }else
      {
        $lastDrawId = $row['id'];
      }      
    }

    return $lastDrawId;
  }
   /**
  * Find next application value.
  *
  * @param string $database
  * @param int $project_id
  * @return mixed (single ORM object | false)
  */
  public static function findLastApplicationNumber($database, $project_id){

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */
    $is_deleted_flag = 'N';
    $query =
    "
    SELECT application_number AS 'max_application_number',`through_date`
    FROM `retention_draws`
    WHERE `project_id` = ? AND `is_deleted_flag` = ? ORDER BY id DESC LIMIT 1
    ";
    $arrValues = array($project_id, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);

    $row = $db->fetch();
    $db->free_result();
    $max_application_number = 0;
    $throughDate = '';
    if ($row) {
      $max_application_number = $row['max_application_number'];
      $throughDate = $row['through_date'];
    }
    $returnArr['max_application_number'] = $max_application_number;
    $returnArr['through_date'] = $throughDate;
    return $returnArr;
  }
    /*
  * Get the project cur draw id using application Number
  */
  public static function findLastRetentionIdUsingAppId($database, $project_id, $app_id) {
    $curDrawId = 0;

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */
    $is_deleted_flag = 'N';
    $query =
    "
    SELECT *
    FROM `retention_draws` d
    WHERE d.`project_id` = ? AND d.`application_number` = ? AND d.`is_deleted_flag` = ?
    ORDER BY d.`id` DESC
    ";
    $arrValues = array($project_id, $app_id, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);

    $row = $db->fetch();
    $db->free_result();

    if ($row) {
      $curDrawId = $row['id'];
    }

    return $curDrawId;
  }
  
  /**
  * create a Retention
  */
  public static function createRetention($database, $projectId, $createdBy,$getLastDrawItemId){
    $projectId = (int) $projectId;
    $createdBy = (int) $createdBy;
    $lastApplication = self::findLastApplicationNumber($database, $projectId);
    $lastApplicationNumber = $lastApplication['max_application_number'];
    $lastThroughDate = $lastApplication['through_date'];
    $applicationNumber = $lastApplicationNumber+1;
    if($applicationNumber > 1){
      $throughDate = date('Y-m-d', strtotime("+1 month", strtotime($lastThroughDate)));
      $qb_customer_idID = self::getQBCustomerIdByProjectId($database,$projectId);
      if($qb_customer_idID>0){
        $qb_customer_id= $qb_customer_idID;
      }else{
        $qb_customer_id = self::getQBCustomerIdByProjectTable($database,$projectId);
      }
    }else{
      $throughDate = date("Y-m-d");
      $qb_customer_id = self::getQBCustomerIdByProjectTable($database,$projectId);
    }
    $RetentionDate = (string) $throughDate;
    $invoiceDate = date("Y-m-d"); 
    
    $db = DBI::getInstance($database);
    $query =
    "
    INSERT INTO `retention_draws` (`project_id`,`last_draw_id`,`application_number`,`through_date`, `invoice_date`,`status`,`qb_customer_id`,`created_by`)
    VALUES (?,?,?,?,?,?,?,?)
    ";
    $arrValues = array($projectId,$getLastDrawItemId,$applicationNumber,$RetentionDate,$invoiceDate,1,$qb_customer_id,$createdBy);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $db->free_result();
    $RetentionId = $db->insertId;
    return $RetentionId;
  } 
  /*
  Get Recent count of Retention draw
  */
  public static function getRetentionRecentCount($database, $projectId, $applicationNumber){
    $projectId = (int) $projectId;
    $applicationNumber = (int) $applicationNumber;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);
    $query ="
    SELECT * FROM `retention_draws` WHERE `project_id`=? AND `status` = ? AND `is_deleted_flag` = ? ORDER BY id DESC LIMIT 1
    ";
    $arrValues = array($projectId, 2, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $db->free_result();
    return $row['id'];
  }

  /**
  * get Retention draw data by application number and project id
  */
  public static function getRetentionData($database, $projectId, $applicationNumber){
    $projectId = (int) $projectId;
    $applicationNumber = (int) $applicationNumber;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);
    $query ="
    SELECT * FROM `retention_draws` WHERE `project_id`=? AND `application_number`=? AND `is_deleted_flag` = ?
    ";
    $arrValues = array($projectId,$applicationNumber, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $db->free_result();
    return $row;
  }
   /*
  * To Get the Current project Retention draw count and Draft Id
  */
  public static function findDraftDrawCountUsingRetentionId($database, $project_id, $RetentionId) {
    $curDrawId = 0;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */

    $query =
    "
    SELECT *
    FROM `retention_draws` d
    WHERE d.`project_id` = ? AND d.`status` = ? AND d.`id` != ? AND d.`is_deleted_flag` = ?
    ORDER BY d.`id` DESC
    ";
    $arrValues = array($project_id, 1, $RetentionId, $is_deleted_flag);
    // print_r($arrValues);
    $db->execute($query, $arrValues);
    $row = $db->fetch();
    $rowCount = $db->rowCount;
    $db->free_result();
    if($row){
      $arrvalue = array('currentDraftRetentionId' => $row['id'], 'currentDraftRetentionAppId' => $row['application_number'],'rowCount' => $rowCount);
    } else {
      $arrvalue = array('currentDraftRetentionId' => 0, 'currentDraftRetentionAppId' => 0, 'rowCount' => $rowCount);
    }
    return $arrvalue;
  }
  public static function updateRetentionData($database,$retId,$currentlyActiveContactId,$retStatus,$postedAt,$projectId){
    $retId = (int) $retId;
    $currentlyActiveContactId = (int) $currentlyActiveContactId;
    $retention = self::findById($database, $retId);
    $retention->convertPropertiesToData();
    $retData = $retention->getData();
    $retData['updated_by'] = $currentlyActiveContactId;
    if(!empty($retStatus)){
      $retData['status'] = $retStatus;
    }
    if(!empty($postedAt)){
      $retData['posted_at'] = $postedAt;
    }
   
    $retention->setData($retData);
    $retention->save();
  }

  /**
  * Get all Retention draw list
  */
  public static function getRetentionList($database, $projectId, $statusId){
    $projectId = (int) $projectId;
    $statusId = (int) $statusId;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */
    if(empty($statusId)){
      $selectedStatus = "";
      $arrValues = array($projectId, $is_deleted_flag);
    }else{
      $selectedStatus = " and draw.`status`=?";
      $arrValues = array($projectId, $is_deleted_flag, $statusId);
    }
    $query ="
    SELECT draw.*,
    t.`total_scheduled_retention_value`,
    t.`total_current_retainage`,
    t.`total_previous_retainage`,
    t.`total_current_retainer_value`,
    t.`total_percentage_completed`,
    ds.`status` FROM `retention_draws` draw
    LEFT JOIN draw_status ds on ds.`id`=draw.`status`
    LEFT JOIN (SELECT SUM(items.`current_retainage`) total_current_retainage,
    SUM(items.`previous_retainage`) total_previous_retainage,
    SUM(items.`current_retainer_value`) total_current_retainer_value,
    SUM(items.`percentage_completed`) total_percentage_completed,  SUM(items.`scheduled_retention_value`) total_scheduled_retention_value,   
    items.* FROM retention_items items GROUP BY items.retention_id)t
    ON t.`retention_id`=draw.`id`
    WHERE draw.`project_id`=? AND draw.`is_deleted_flag` = ? $selectedStatus ORDER BY draw.`id` DESC";
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
   

    $records = array();
    while($row = $db->fetch())
    {
      $records[] = $row;
    }
    $db->free_result();
    return $records;
  }

  // to get the customaer id from the application number
  public static function getPrevAppQbCutomerId($database, $project_id,$app_id)
  {
    $db = DBI::getInstance($database);
    $query ="SELECT `qb_customer_id`,id FROM `retention_draws` WHERE `project_id` = ? AND `application_number` = ? AND `is_deleted_flag` = 'N' ORDER BY `id` DESC LIMIT 1";
    $arrValues = array($project_id,$app_id);
    $db->execute($query,$arrValues,MYSQLI_USE_RESULT);
    $row = $db->fetch();  
    $qb_customer_id = $row['qb_customer_id']; 
    $db->free_result();
    return $qb_customer_id;
  }

  // to get the customaer id from the application number
  public static function getFirstAppQbCutomerId($database, $project_id,$app_id)
  {
    $db = DBI::getInstance($database);
    $query ="SELECT `qb_customer_id`,id FROM `retention_draws` WHERE `project_id` = ? AND `application_number` = ? AND `is_deleted_flag` = 'N' ORDER BY `id` ASC LIMIT 1";
    $arrValues = array($project_id,$app_id);
    $db->execute($query,$arrValues,MYSQLI_USE_RESULT);
    $row = $db->fetch();  
    $qb_customer_id = $row['qb_customer_id']; 
    $db->free_result();
    return $qb_customer_id;
  }

  // to find the retention id
  public static function findLastDrawIdforRetention($database, $retid)
  {
    $db = DBI::getInstance($database);
    $query ="SELECT `last_draw_id`,id FROM `retention_draws` WHERE `id` = ? ";
    $arrValues = array($retid);
    $db->execute($query,$arrValues,MYSQLI_USE_RESULT);
    $row = $db->fetch();  
    $last_draw_id = $row['last_draw_id']; 
    $db->free_result();
    return $last_draw_id;
  }

  public static function getQBCustomerIdByProjectId($database, $project_id){

    $db = DBI::getInstance($database);

    $query1 ="SELECT `qb_customer_id`,`id` FROM `draws` WHERE `project_id` = ? AND `is_deleted_flag` = 'N' ORDER BY `id` DESC LIMIT 1";
    $arrValues1 = array($project_id);
    $db->execute($query1,$arrValues1,MYSQLI_USE_RESULT);
    $row1 = $db->fetch(); 
    $qb_customer_id1 = $row1['qb_customer_id']; 
    $db->free_result();    
    return $qb_customer_id1;    
  }

  public static function getQBCustomerIdByProjectTable($database, $project_id){

    $db = DBI::getInstance($database);
 

    $query3 ="SELECT `qb_customer_id`,`id` FROM `projects` WHERE `id` = ?  ORDER BY `id` DESC LIMIT 1";
    $arrValues3 = array($project_id);
    $db->execute($query3,$arrValues3,MYSQLI_USE_RESULT);
    $row3 = $db->fetch(); 
    $qb_customer_id3 = $row3['qb_customer_id'];
    $db->free_result(); 

     return $qb_customer_id3;  
  }
  
}
/**
* Framework standard footer comments.
*
* No closing ?> tag to prevent the injection of whitespace.
*/
