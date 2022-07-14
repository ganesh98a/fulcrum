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
require_once('lib/common/ContractingEntities.php');

class Draws extends IntegratedMapper
{
  /**
  * Class name for use in deltifyAndSave().
  */
  protected $_className = 'Draws';

  /**
  * Table name for this Integrated Mapper.
  *
  * @var string
  */
  protected $_table = 'draws';

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
    'id' => 'draw_id',
    'project_id' => 'project_id',
    'contracting_entity_id' => 'contracting_entity_id',
    'application_number' => 'application_number',
    'through_date' => 'through_date',
    'invoice_date' => 'invoice_date',
    'status' => 'status',
    'posted_at'=>'posted_at',
    'created_by' => 'created_by',
    'updated_by' => 'updated_by',
    'created' => 'created',
    'qb_customer_id' => 'qb_customer_id',
    'is_deleted_flag' => 'is_deleted_flag'
  );

  // ORM properties (instance variables) derived from the Database table attributes (fields)
  public $draw_id;
  public $project_id;
  public $contracting_entity_id;
  public $application_number;
  public $through_date;
  public $invoice_date;
  public $status;
  public $posted_at;
  public $created_by;
  public $updated_by;
  public $created;
  public $qb_customer_id;
  public $is_deleted_flag;

  /**
  * Constructor
  */
  public function __construct($database, $table='draws')
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
  public static function findById($database, $draw_id, $table='draws', $module='Draws')
  { 
    $draw = parent::findById($database, $draw_id, $table, $module);
    
    return $draw;
  }
  /**
  * Get all draw list
  */
  public static function getDrawsList($database, $projectId, $statusId,$corType){
    $projectId = (int) $projectId;
    $statusId = (int) $statusId;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */
    if(empty($statusId)){
      $selectedStatus = "";
      $arrValues = array($corType,$projectId, $is_deleted_flag);
    }else{
      $selectedStatus = " and draw.`status`=?";
      $arrValues = array($corType,$projectId, $is_deleted_flag, $statusId);
    }
    $query ="
    SELECT draw.*,
    t.`total_current_app`,
    t.`total_completion_percentage`,
    t.`total_current_retainer_value`,
    ds.`status` FROM `draws` draw
    LEFT JOIN draw_status ds on ds.`id`=draw.`status`
    LEFT JOIN (SELECT SUM(items.`current_app`) total_current_app,
    SUM(items.`completed_percent`) total_completion_percentage,
    SUM(items.`current_retainer_value`) total_current_retainer_value,
    items.* FROM draw_items items WHERE items.`cor_type` = ? GROUP BY items.`draw_id`)t
    ON t.`draw_id`=draw.`id`
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

  /**
  * get sum of previous draw values
  */
  public static function getSumOfPreviousDrawValue($database,$projectId,$applicationNumber,$corType){
    $projectId = (int) $projectId;
    $applicationNumber = (int) $applicationNumber;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);

    $query ="
    SELECT SUM(`current_app`) AS total_current_app,SUM(`current_retainer_value`) AS total_current_retainer_value
    FROM `draws` draw
    LEFT JOIN `draw_items` di ON draw.`id`=di.`draw_id`
    WHERE draw.`project_id`=? AND di.`cor_type` = ? AND  draw.`application_number` < ? AND draw.`is_deleted_flag` = ? ";
    $arrValues = array($projectId,$corType,$applicationNumber, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $db->free_result();
    return $row;
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
    FROM `draws`
    WHERE `project_id` = ? AND `is_deleted_flag` = ? ORDER BY id DESC LIMIT 1
    ";
    $arrValues = array($project_id, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);

    $row = $db->fetch();
    $db->free_result();

    if ($row) {
      $max_application_number = $row['max_application_number'];
      $throughDate = $row['through_date'];
    }
    $returnArr['max_application_number'] = $max_application_number;
    $returnArr['through_date'] = $throughDate;
    return $returnArr;
  }
  /**
  * create a draw
  */
  public static function createDraw($database, $projectId, $createdBy){
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
    $drawDate = (string) $throughDate;
    $invoiceDate = date("Y-m-d"); 
    /* contract Entity*/
    $contract_entity =  ContractingEntities::getcontractEntityAgainstProject($database,$projectId);
    $db = DBI::getInstance($database);
    $query =
    "
    INSERT INTO `draws` (`project_id`,`contracting_entity_id`,`application_number`,`through_date`, `invoice_date`,`status`,`qb_customer_id`,`created_by`)
    VALUES (?,?,?,?,?,?,?,?)
    ";
    $arrValues = array($projectId,$contract_entity,$applicationNumber,$drawDate,$invoiceDate,1,$qb_customer_id,$createdBy);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $db->free_result();
    $drawId = $db->insertId;
    return $drawId;
  }
  /**
  * get draw data by application number and project id
  */
  public static function getDrawData($database, $projectId, $applicationNumber){
    $projectId = (int) $projectId;
    $applicationNumber = (int) $applicationNumber;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);
    $query ="
    SELECT * FROM `draws` WHERE `project_id`=? AND `application_number`=? AND `is_deleted_flag` = ?
    ";
    $arrValues = array($projectId,$applicationNumber, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $db->free_result();
    return $row;
  }
  /*
  Get Recent count of draw
  */
  public static function getDrawRecentCount($database, $projectId, $applicationNumber){
    $projectId = (int) $projectId;
    $applicationNumber = (int) $applicationNumber;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);
    $query ="
    SELECT * FROM `draws` WHERE `project_id`=? AND `status` = ? AND `is_deleted_flag` = ? ORDER BY id DESC LIMIT 1
    ";
    $arrValues = array($projectId, 2, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $db->free_result();
    return $row['id'];
  }
  /**
  * update draw through date
  */
  public static function updateDrawThroughDate($database,$drawId,$throughDate){
    $drawId = (int) $drawId;
    $drawDate = date('Y-m-d',strtotime($throughDate));
    $draws = self::findById($database, $drawId);
    $draws->convertPropertiesToData();
    $drawData = $draws->getData();
    $drawData['updated_by'] = $throughDate;
    $drawData['through_date'] = $drawDate;
    $draws->setData($drawData);
    $draws->save();
    return $draws;
  }

  public static function updateDrawData($database,$drawId,$currentlyActiveContactId,$drawStatus,$postedAt,$projectId){
    $drawId = (int) $drawId;
    $currentlyActiveContactId = (int) $currentlyActiveContactId;
    $draws = self::findById($database, $drawId);
    $draws->convertPropertiesToData();
    $drawData = $draws->getData();
    $drawData['updated_by'] = $currentlyActiveContactId;
    if(!empty($drawStatus)){
      $drawData['status'] = $drawStatus;
    }
    if(!empty($postedAt)){
      $drawData['posted_at'] = $postedAt;
    }
    $contract_entity =  ContractingEntities::getcontractEntityAgainstProject($database,$projectId);
    $drawData['contracting_entity_id'] = $contract_entity;
    $draws->setData($drawData);
    $draws->save();
  }
  /*
  * Get the project last draw id from now created
  */
  public static function findLastDrawIdUsingProjectId($database, $project_id,$column = '') {
    $lastDrawId = 0;

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */
    $is_deleted_flag = 'N';
    $query =
    "
    SELECT *
    FROM `draws` d
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
        $lastDrawId =$row[$column];
      }else
      {
       $lastDrawId = $row['id'];
      }
    }

    return $lastDrawId;
  }



  /*
  * Get the project draft draw count
  */
  public static function findDraftDrawIdUsingProjectId($database, $project_id) {
    $lastDrawId = 0;

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */
    $is_deleted_flag = 'N';
   $query =
    "
    SELECT *
    FROM `draws` d
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
  * Get the project cur draw id using application Number
  */
  public static function findLastDrawIdUsingAppId($database, $project_id, $app_id) {
    $curDrawId = 0;

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */
    $is_deleted_flag = 'N';
    $query =
    "
    SELECT *
    FROM `draws` d
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
  /*
  * Get the project draw
  */
  public static function findDraftDrawCountUsingDrawId($database, $project_id, $draw_id) {
    $curDrawId = 0;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */

    $query =
    "
    SELECT *
    FROM `draws` d
    WHERE d.`project_id` = ? AND d.`status` = ? AND d.`id` != ? AND d.`is_deleted_flag` = ?
    ORDER BY d.`id` DESC
    ";
    $arrValues = array($project_id, 1, $draw_id, $is_deleted_flag);
    // print_r($arrValues);
    $db->execute($query, $arrValues);
    $row = $db->fetch();
    $rowCount = $db->rowCount;
    $db->free_result();
    if($row){
      $arrvalue = array('currentDraftDrawId' => $row['id'], 'currentDraftDrawAppId' => $row['application_number'],'rowCount' => $rowCount);
    } else {
      $arrvalue = array('currentDraftDrawId' => 0, 'currentDraftDrawAppId' => 0, 'rowCount' => $rowCount);
    }
    return $arrvalue;
  }

  // To get draws details using draw id
  public static function getDrawDataUsingId($database, $project_id, $draw_id){
    $project_id = (int) $project_id;
    $draw_id = (int) $draw_id;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);
    $query ="
    SELECT * FROM `draws` WHERE `project_id`=? AND `id`=? AND `is_deleted_flag` = ?
    ";
    $arrValues = array($project_id,$draw_id, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $db->free_result();
    return $row;
  }

  // To get draws id list which has reallocation value
  public static function getDrawIdsHavingReallocation($database, $project_id){
    $project_id = (int) $project_id;
    $draw_id = (int) $draw_id;
    $is_deleted_flag = 'N';
    $db = DBI::getInstance($database);
    $query ="
    SELECT d.`id`,d.`application_number` FROM `draws` d LEFT JOIN `draw_items` di ON d.`id`= di.`draw_id` WHERE d.`project_id` = ? AND d.`is_deleted_flag` = ? AND di.`realocation` != '0.00' GROUP BY d.`id` ORDER BY d.`id` DESC
    ";
    $arrValues = array($project_id, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $records = array();
    while($row = $db->fetch())
    {
      $records[] = $row;
    }
    $db->free_result();
    return $records;
  }

  // To get draft draw or draft retention invoice date
  public static function getDraftInvoiceDate($database, $project_id){
    $project_id = (int) $project_id;
    $db = DBI::getInstance($database);
    $query ="
    SELECT COALESCE(
      (SELECT CONCAT('draw_',id,'_',invoice_date) AS draw FROM `draws` 
        WHERE `project_id` = ? AND is_deleted_flag = 'N' AND `status` = 1 LIMIT 1),
      (SELECT CONCAT('retention_',id,'_',invoice_date) AS draw FROM `retention_draws` 
        WHERE `project_id` = ? AND is_deleted_flag = 'N' AND `status` = 1 LIMIT 1)
    )  AS draw
    ";
    $arrValues = array($project_id, $project_id);
    $db->execute($query,$arrValues,MYSQLI_USE_RESULT);
    $row = $db->fetch();    
    $db->free_result();
    return $row['draw'];
  }

  // To get very first draw status
  public static function getFirstDrawStatus($database, $project_id){
    $project_id = (int) $project_id;
    $db = DBI::getInstance($database);
    $query ="SELECT * FROM `draws` WHERE `project_id` = ? AND `is_deleted_flag` = 'N' ORDER BY `id` DESC LIMIT 1";
    $arrValues = array($project_id);
    $db->execute($query,$arrValues,MYSQLI_USE_RESULT);
    $row = $db->fetch();   
    $db->free_result();
    $return = false;
    if (($row['application_number'] == 1 && $row['status'] == 1) || $row == '') {
      $return = true;
    }
    return $return;
  }

// to get the customer id from the application number
  public static function getPrevAppQbCutomerId($database, $project_id,$app_id)
  {
    $db = DBI::getInstance($database);
    $query ="SELECT `qb_customer_id`,id FROM `draws` WHERE `project_id` = ? AND `application_number` = ? AND `is_deleted_flag` = 'N' ORDER BY `id` DESC LIMIT 1";
    $arrValues = array($project_id,$app_id);
    $db->execute($query,$arrValues,MYSQLI_USE_RESULT);
    $row = $db->fetch();  
    $qb_customer_id = $row['qb_customer_id']; 
    $db->free_result();
    return $qb_customer_id;
  }

  public static function getQBCustomerIdByProjectId($database, $project_id){

    $db = DBI::getInstance($database);

    $query1 ="SELECT `qb_customer_id`,`id` FROM `draws` WHERE `project_id` = ? AND `is_deleted_flag` = 'N' ORDER BY `id` ASC LIMIT 1";
    $arrValues1 = array($project_id);
    $db->execute($query1,$arrValues1,MYSQLI_USE_RESULT);
    $row1 = $db->fetch(); 
    $qb_customer_id1 = $row1['qb_customer_id']; 
    $db->free_result(); 

    // $query2 ="SELECT `qb_customer_id`,`id` FROM `retention_draws` WHERE `project_id` = ? AND `last_draw_id` = ? AND `is_deleted_flag` = 'N' ORDER BY `id` DESC LIMIT 1";
    // $arrValues2 = array($project_id,$row1['id']);
    // $db->execute($query2,$arrValues2,MYSQLI_USE_RESULT);
    // $row2 = $db->fetch(); 
    // $qb_customer_id2 = $row2['qb_customer_id'];
    // $db->free_result(); 


    // if ($qb_customer_id2 && $qb_customer_id2 != 0) {
    //   return $qb_customer_id2;
    // }else{
    //   return $qb_customer_id1;
    // }  
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
