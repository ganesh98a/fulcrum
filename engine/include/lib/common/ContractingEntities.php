<?php
/**
* ContractingEntities.
*
* @category   Framework
* @package    ContractingEntities
*/

/**
* @see IntegratedMapper
*/
//require_once('lib/common/IntegratedMapper.php');

class ContractingEntities extends IntegratedMapper
{
  /**
  * Class name for use in deltifyAndSave().
  */
  protected $_className = 'ContractingEntities';

  /**
  * Table name for this Integrated Mapper.
  *
  * @var string
  */
  protected $_table = 'contracting_entities';

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
    'id' => 'entity_id',
    'user_company_id' => 'user_company_id',
    'entity' =>'entity',
    'status' =>'status',
  );

  // ORM properties (instance variables) derived from the Database table attributes (fields)
  public $id;
  public $user_company_id;
  public $entity;
  public $status;

  /**
  * Constructor
  */
  public function __construct($database, $table='contracting_entities')
  {
    parent::__construct($table);
    $this->setDatabase($database);
  }

   public static function findById($database, $entity_id, $table='contracting_entities', $module='ContractingEntities')
  {
    $entity = parent::findById($database, $entity_id, $table, $module);

    return $entity;
  }
  /**
  * Get Contracting entity id for a project
  */
  public static function getcontractEntityAgainstProject($database,$project_id){

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */

    $query ="SELECT `contracting_entity_id` FROM projects Where id=?";
    $arrValues = array($project_id);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $contracting_entity_id = null;
    if (isset($row) && !empty($row)) {
      $contracting_entity_id = $row['contracting_entity_id'];
    }    
    $db->free_result();
    return $contracting_entity_id;
  }


/**
  * Get Contracting entity Name for a project
  */
  public static function getcontractEntityNameforProject($database,$entity_id){

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */

    $query ="SELECT `entity` FROM contracting_entities Where id=?";
    $arrValues = array($entity_id);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $entity = null;
    if (isset($row) && !empty($row)) {
      $entity = $row['entity'];
    }
    $db->free_result();
    return $entity;
  }
  /**
  * Get Contracting entity data for a project
  */
  public static function getAllcontractEntitydata($database,$entity_id){

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */

    $query ="SELECT * FROM contracting_entities Where id=?";
    $arrValues = array($entity_id);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $db->free_result();
    return $row;
  }
  /*
    Get Contracting Entitiy Mapped to User Company
  */
  public static function getContractEntityByUserCompanyId($database, $user_company_id){

    $db = DBI::getInstance($database);
    /* @var $db DBI_mysqli */
    $db->free_result();

    $get_entity_sql = "SELECT id,entity,construction_license_number,state FROM `contracting_entities` WHERE `user_company_id` = ?";

    $arrValues = array($user_company_id);
    $db->execute($get_entity_sql, $arrValues, MYSQLI_USE_RESULT);
    $entity_arr = array();
    while($row = $db->fetch()){
      $entity_arr[$row['id']] =  $row['entity'].', '.$row['state'].', '.$row['construction_license_number'];

    }

    $db->free_result();


    return $entity_arr; 

  }
  /*
    Get the Contract Entity By Entity Name
  */
  public static function getContractEntityByName($database, $contractEntityName, $user_company_id,$state){ //Check Contract Entity Exist

    $db = DBI::getInstance($database);
    $db->free_result();
    $get_entity_sql = "SELECT id,entity FROM `contracting_entities` WHERE `entity` = ? AND `user_company_id` = ? AND `state` = ? LIMIT 1";
    $arrValues = array($contractEntityName, $user_company_id,$state);
    $db->execute($get_entity_sql, $arrValues, MYSQLI_USE_RESULT);
    $enitity = $db->fetch();
    $db->free_result();

    return $enitity;
  }
  /*
    Create the Contracting Entity for the Company
  */

  public static function createEntity($database, $params_arr = array()){ // creating Contract Entity
    $db = DBI::getInstance($database);
    $db->free_result();

    $returnval = '1';

    if(!empty($params_arr['contractEntityName']) && !empty($params_arr['user_company_id']) && !empty($params_arr['construction_license_number'])){
      $create_entity_sql = "INSERT INTO `contracting_entities`(`user_company_id`, `entity`, `construction_license_number`,`state`) VALUES (?, ?, ?, ?)";

      $arrValues = array($params_arr['user_company_id'], $params_arr['contractEntityName'], $params_arr['construction_license_number'],$params_arr['state']);

    
      if($db->execute($create_entity_sql, $arrValues, MYSQLI_USE_RESULT)){
        $entityId = $db->insertId;
        $returnval = $entityId; //return alone with entity Id
      }

      $db->free_result();
    }
    return $returnval;

  }

}
/**
* Framework standard footer comments.
*
* No closing ?> tag to prevent the injection of whitespace.
*/
