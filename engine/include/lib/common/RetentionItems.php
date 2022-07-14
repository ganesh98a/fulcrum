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
* DrawItems.
*
* @category   Framework
* @package    Draws
*/

/**
* @see IntegratedMapper
*/
//require_once('lib/common/IntegratedMapper.php');
require_once('lib/common/DrawItems.php');



class RetentionItems extends IntegratedMapper
{
	/**
	* Class name for use in deltifyAndSave().
	*/
	protected $_className = 'RetentionItems';

	/**
	* Table name for this Integrated Mapper.
	*
	* @var string
	*/
	protected $_table = 'retention_items';

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
		'id' => 'retention_item_id',
		'retention_id' => 'retention_id',
		'cost_code_id' => 'cost_code_id',
		'gc_budget_line_item_id' => 'gc_budget_line_item_id',
		'change_order_id' => 'change_order_id',
		'current_app' => 'current_app',
		'completed_percent' => 'completed_percent',
		'current_retainer_value' => 'current_retainer_value',
		'narrative' => 'narrative',
		'type' => 'type'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $retention_item_id;
	public $retention_id;
	public $cost_code_id;
	public $gc_budget_line_item_id;
	public $change_order_id;
	public $current_app;
	public $completed_percent;
	public $current_retainer_value;
	public $narrative;
	public $type;

	/**
	* Constructor
	*/
	public function __construct($database, $table='retention_items')
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
	public static function findById($database, $retention_item_id, $table='retention_items', $module='RetentionItems')
	{
		$retentionItem = parent::findById($database, $retention_item_id, $table, $module);
		return $retentionItem;
	}
	
	/**
	* get Previous Retention application number
	*/
	public static function getPreviousRetentionNumber($database,$applicationNumber,$projectId){
		$is_deleted_flag = 'N';
		$db = DBI::getInstance($database);
		  $query ="SELECT * FROM `retention_draws` WHERE `project_id`=? AND `application_number` <? AND `is_deleted_flag` = ? order by application_number desc limit 1
    ";
    $arrValues = array($projectId,$applicationNumber, $is_deleted_flag);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    $row = $db->fetch();
    $previousret = $row['id'];
    $db->free_result();
    return $previousret;
	}
	/**
	* get Retention application number
	*/
	public static function getRetentionApplicationNumber($database,$RetentionId){
		$RetentionId = (int) $RetentionId;
		$db = DBI::getInstance($database);
		$row = RetentionDraws::findById($database, $RetentionId);
		return $row['application_number'];
	}
	/**
	* create Retention Items
	*/
	public static function createRetentionItems($database, $projectId, $RetentionId,$LastDrawItemId,$LastDrawApplicationo){
		$drawbudgetItems = self::getBudgetRetentionItems($database, $projectId);
		$last_draw_invoice_date = RetentionDraws::findLastRetentionIdUsingProjectId($database, $projectId,'invoice_date');		
		$drawChangeOrderItems = self::getChangeOrderRequestList($database, $projectId,$last_draw_invoice_date);
		$applicationNumber = self::getRetentionApplicationNumber($database,$RetentionId);
		$previousRetentionNumber = self::getPreviousRetentionNumber($database,$applicationNumber,$projectId);
		self::saveBudgetItems($database, $projectId, $RetentionId, $drawbudgetItems,$LastDrawItemId,$applicationNumber,$previousRetentionNumber,$LastDrawApplicationo);
		self::saveChangeOrderApprovedItems($database, $projectId, $RetentionId, $drawChangeOrderItems,$LastDrawItemId,$applicationNumber,$previousRetentionNumber,$LastDrawApplicationo);
		
		return $applicationNumber;
	}

	/**
	* get Budget items
	*/
	public static function getBudgetRetentionItems($database, $projectId){
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);

		$query ="
		SELECT cc.`cost_code`,cc.`cost_code_description`,gcbli.`prime_contract_scheduled_value`,gcbli.`id`,
		project.`retainer_rate` project_retainer_rate,ccd.`division_number`, gcbli.`cost_code_id`
		FROM `gc_budget_line_items` gcbli
		LEFT JOIN `cost_codes` cc ON cc.`id`= gcbli.`cost_code_id`
		LEFT JOIN `cost_code_divisions` ccd ON ccd.`id`= cc.`cost_code_division_id`
		LEFT JOIN `projects` project on project.`id`=gcbli.`project_id`
		WHERE gcbli.`project_id`=? AND gcbli.`prime_contract_scheduled_value`!=0";
		$arrValues = array($projectId);

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
	* get approved change order requests
	*/
	public static function getChangeOrderRequestList($database, $projectId, $invoice_date){
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);

		$query ="
		SELECT co.`co_type_prefix`,co.`co_title`,co.`co_total`,co.`id`,
		project.`retainer_rate` project_retainer_rate
		FROM `change_orders` co
		LEFT JOIN `projects` project on project.`id`=co.`project_id`
		WHERE co.`project_id`=? AND co.`change_order_type_id`=2 AND co.`change_order_status_id`=2
		AND co.`co_total` != 0
		AND co.`co_approved_date` <= ?";
		$arrValues = array($projectId,$invoice_date);

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$records = array();
		while($row = $db->fetch())
		{
			$records[] = $row;
		}
		$db->free_result();
		return $records;
	}
	/*
	* To save the Budgert records to retention
	*/
	public static function saveBudgetItems($database, $projectId, $RetentionId, $drawbudgetItems,$LastDrawItemId,$applicationNumber,$prevretNumber,$LastDrawApplicationo){
		$projectId = (int) $projectId;
		$corType = DrawItems::getLastCorType($database,$projectId,$LastDrawApplicationo);
		$RetentionId = (int) $RetentionId;
		$db = DBI::getInstance($database);
		foreach ($drawbudgetItems as $budgetKey => $budgetValue) {
			$costCodeId = $budgetValue['cost_code_id'];
			$gcBudgetLineItemId = $budgetValue['id'];

			$scheduledretentionValue = $budgetValue['prime_contract_scheduled_value']; 
			// To add the reallocation amount
			if ($corType == 'A') {
				$ReallocationValue = ChangeOrder::ReallocationInDrawsAndCOByCostCode($database,$costCodeId,$projectId);
				$scheduledretentionValue = $scheduledretentionValue+$ReallocationValue;
			}else{
				$ReallocationValue = DrawItems::costcodeReallocated($database,$costCodeId,$projectId);
				$scheduledretentionValue = $scheduledretentionValue+$ReallocationValue['total'];
			}
			
			//To caluculate Previous retainage and current retention
			$current_retainage = self::getDrawvalueToRetention($database,$LastDrawItemId,$costCodeId,$gcBudgetLineItemId,$projectId,$LastDrawApplicationo);
			// $current_retainage = $budgetValue['prime_contract_scheduled_value'];
			if($applicationNumber > 1){
				
				$PreviouscurrentRetention = self::getpreviouscurRetentionvalue($database, $prevretNumber,'current_retainer_value',$costCodeId,$gcBudgetLineItemId);
				$prevRetention = $PreviouscurrentRetention;
			}else{
				$prevRetention = 0;
			}
			if(!empty($current_retainage)){
				$percentage_completed =($prevRetention/$current_retainage)*100;
			}else{
				$percentage_completed = 0;
			}
			

			$budgetLineItem = new RetentionItems($database);
			$budgetLineItem->convertPropertiesToData();
			$budgetData = $budgetLineItem->getData();
			$budgetData['retention_id'] = $RetentionId;
			$budgetData['cost_code_id'] = $costCodeId;
			$budgetData['gc_budget_line_item_id'] = $gcBudgetLineItemId;
			$budgetData['scheduled_retention_value'] = $scheduledretentionValue;
			$budgetData['current_retainage'] = $current_retainage;
			$budgetData['previous_retainage'] = $prevRetention;
			$budgetData['percentage_completed'] = $percentage_completed;
			$budgetData['type'] = 'Y';
			$budgetLineItem->setData($budgetData);
			$drawItemId = $budgetLineItem->save();

			// self::saveBudgetRetainerRate($database,$projectId,$gcBudgetLineItemId,$drawItemId,$costCodeId);
		}
	}

	public static function saveChangeOrderApprovedItems($database, $projectId, $RetentionId, $drawChangeOrderItems,$LastDrawItemId,$applicationNumber,$previousRetentionNumber,$LastDrawApplicationo){
		$projectId = (int) $projectId;
		$RetentionId = (int) $RetentionId;
		$db = DBI::getInstance($database);
		foreach ($drawChangeOrderItems as $orderKey => $orderValue) {
			$changeOrderId = $orderValue['id'];
			$scheduledretentionValue = $orderValue['co_total'];
			//To caluculate Previous retainage and current retention
			$current_retainage = self::getDrawvalueForRetentionCOR($database,$LastDrawItemId,$changeOrderId,$projectId,$LastDrawApplicationo);

			if($applicationNumber > 1){
				$PreviouscurrentRetention = self::getpreviouscurRetentionvalueForCOR($database, $previousRetentionNumber,'current_retainer_value',$changeOrderId);
				$prevRetention = $PreviouscurrentRetention;
			}else{
				$prevRetention = 0;
			}
			$percentage_completed =($prevRetention/$current_retainage)*100;

			$changeOrderItem = new RetentionItems($database);
			$changeOrderItem->convertPropertiesToData();
			$changeOrderData = $changeOrderItem->getData();
			$changeOrderData['retention_id'] = $RetentionId;
			$changeOrderData['change_order_id'] = $changeOrderId;
			$changeOrderData['scheduled_retention_value'] = $scheduledretentionValue;
			$changeOrderData['current_retainage'] = $current_retainage;
			$changeOrderData['previous_retainage'] = $prevRetention;
			$changeOrderData['percentage_completed'] = $percentage_completed;
			$changeOrderData['type'] = 'N';
			$changeOrderItem->setData($changeOrderData);
			$drawItemId = $changeOrderItem->save();

			// self::saveCORetainerRate($database,$projectId,$changeOrderId,$drawItemId);
		}
	}
	/*
	*To get the Previous Draw Total Retention value
	*/
	public static function getDrawvalueToRetention($database,$LastDrawItemId,$costCodeId,$gcBudgetLineItemId,$projectId,$LastDrawApplicationo){
		$db = DBI::getInstance($database);
		$corType = DrawItems::getLastCorType($database,$projectId,$LastDrawApplicationo);
		$arrDrawitem = DrawItems::getSingleBudgetDrawItems($database,$LastDrawItemId,$costCodeId,$gcBudgetLineItemId,'',$corType);
		$retainerRate = $arrDrawitem['retainer_rate'];
		$currentApp = $arrDrawitem['current_app'];
		 //To get the item_id of the draw based on costcode_id and budget
		$drawItemId = DrawItems::getDrawItemIdbyCostcodeandbudgetId($database,$LastDrawItemId,$costCodeId,$gcBudgetLineItemId);
			
		 $previousDrawValue =DrawItems::getPreviousDrawValue($database, $projectId,$gcBudgetLineItemId,'gc_budget_line_item_id',$drawItemId,$LastDrawApplicationo,$corType);
		
		 $totalRetainage = (float)$previousDrawValue['current_retainer_value']+(float)$arrDrawitem['current_retainer_value'];
		return $totalRetainage;

	}
	/*
	*To get the Previous Draw Total Retention value for COR
	*/
	public static function getDrawvalueForRetentionCOR($database,$LastDrawItemId,$changeorderId,$projectId,$LastDrawApplicationo){
		$db = DBI::getInstance($database);
		$arrDrawitem = DrawItems::getSingleChangeOrderDrawItems($database,$LastDrawItemId,$changeorderId);
		$retainerRate = $arrDrawitem['retainer_rate'];
		$currentApp = $arrDrawitem['current_app'];

		 //To get the item_id of the draw based on change order
		$drawItemId = DrawItems::getDrawItemIdbyChangeorderId($database,$LastDrawItemId,$changeorderId);
		$corType = DrawItems::getLastCorType($database,$projectId,$LastDrawApplicationo);
		 $previousDrawValue =DrawItems::getPreviousDrawValue($database, $projectId,$changeorderId,'change_order_id',$drawItemId,$LastDrawApplicationo,$corType);

		$totalRetainage = (float)$previousDrawValue['current_retainer_value']+(float)$arrDrawitem['current_retainer_value'];
		return $totalRetainage;

	}
	/*
	*To get the Previous Retention value
	*/
	public static function getpreviouscurRetentionvalue($database, $prevretNumber,$field,$cost_code_id,$budget_id)
	{
		$db = DBI::getInstance($database);

		$query ="SELECT sum($field) as $field from retention_items WHERE cost_code_id = ? and gc_budget_line_item_id =? ";
		$arrValues = array($cost_code_id,$budget_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$currentvalue = $row[$field];
		$db->free_result();
		return $currentvalue;
	}
	/*
	*To get the Previous Retention value for COR
	*/
	public static function getpreviouscurRetentionvalueForCOR($database, $prevretNumber,$field,$changeorder)
	{
		$db = DBI::getInstance($database);

		$query ="SELECT  sum($field) as $field from retention_items WHERE change_order_id = ? ";
		$arrValues = array($changeorder);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$currentvalue = $row[$field];
		$db->free_result();
		return $currentvalue;
	}
	/** 
	* get budget line items for Retention grid
	*/
	public static function getBudgetGridRetentionItems($database,$RetentionId, $options = ''){
		$RetentionId = (int) $RetentionId;
		$db = DBI::getInstance($database);
		$wherCond = '';
		if(!empty($options) && ($options =='1' || $options =='3')){
			$wherCond = 'AND di.`narrative` IS NOT NULL AND di.`narrative` !=""';
		}else if(!empty($options) && $options =='4'){
			$wherCond = ' AND ccd.`division_number_group_id` ="0"';
		}
//		-- LEFT JOIN `draw_retainer_rate` drr ON drr.`draw_item_id`=di.`id`

		$query=	"
		SELECT di.`id`, di.`retention_id`,cc.`cost_code`,cc.`cost_code_description`,
		gcbli.`prime_contract_scheduled_value`,di.`gc_budget_line_item_id`,
		ccd.`division_number`, gcbli.`cost_code_id`,
		di.`scheduled_retention_value`,di.`current_retainage`,di.`previous_retainage`,di.`current_retainer_value`,di.`percentage_completed`,di.`balance_retainage_value`,di.`narrative`,
		di.`scheduled_retention_value`,cc.`cost_code_division_id`,ccd.`division_number_group_id`
		FROM `retention_items` di
		LEFT JOIN `gc_budget_line_items` gcbli ON gcbli.`id`=di.`gc_budget_line_item_id`
		LEFT JOIN `cost_codes` cc ON cc.`id`= di.`cost_code_id`
		LEFT JOIN `cost_code_divisions` ccd ON ccd.`id`= cc.`cost_code_division_id`

		WHERE di.`retention_id`=? AND di.`gc_budget_line_item_id` IS NOT NULL ".$wherCond." ORDER BY  `ccd`.`division_number` ASC ,`cc`.`cost_code` ASC ,di.`gc_budget_line_item_id`
		";
		$arrValues = array($RetentionId);
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
	* Save Retention items
	*
	* @param string $database
	* @param int $projectId
	* @return mixed (single ORM object | false)
	*/
	public static function updateRetentionItem($database, $projectId, $retentionItemId ,$newValue,$lineItemId,$type,$column,$RetentionId,$curRetainage){
		$projectId = (int) $projectId;
		$retentionItemId = (int) $retentionItemId;
		$db = DBI::getInstance($database);

		// $retainerRate = self::getDrawRetainerRate($database, $projectId, $retentionItemId);
		$applicationNumber = self::getRetentionApplicationNumber($database,$RetentionId);
		$row = RetentionItems::findById($database, $retentionItemId);
		$previousRetentionValues  = $row['previous_retainage'];
		// $previousRetentionValues = self::getPreviousRetentionValue($database, $projectId, $lineItemId ,$type,$retentionItemId,$applicationNumber);
		$newValue = str_replace('$','',$newValue); //replace '$' symbol in value
		$newValue = str_replace(',','',$newValue); //replace '-' symbol in value
		$curRetainage = str_replace('$','',$curRetainage); //replace '$' symbol in value
		$curRetainage = str_replace(',','',$curRetainage); //replace '-' symbol in value
		if($column == 'current_retainer_value'){
			$drawData = self::updateCurrentRetentionValue($database, $retentionItemId, $newValue, $type, $previousRetentionValues,$curRetainage);
		}else if($column == 'percentage_completed'){
			$drawData = self::updateCompletedPercent($database, $retentionItemId, $newValue, $type, $projectId, $lineItemId, $curRetainage);
		}else if($column == 'narrative'){
			$drawData = self::updateNarrative($database, $retentionItemId,$newValue);
		}else if($column == 'retainer_rate'){
			self::updateNextDrawsRetainerValue($database,$retentionItemId,$type,$projectId, $lineItemId,$newValue);
		}
		$applicationNumber = self::getRetentionApplicationNumber($database,$RetentionId);
		return $applicationNumber;
	}

	/**
	* save or update current app
	*/
	public static function updateCurrentRetentionValue($database, $retentionItemId,$newValue,$type,$previousRetentionValues,$curRetainage){
		$db = DBI::getInstance($database);
		$selectedDrawItem = self::findById($database, $retentionItemId);
		$currentRetainage = $selectedDrawItem['current_retainage'];
		$currentRetentionvalue = $newValue;
		$completionPercentage = self::calculateCompletionPercentage($currentRetentionvalue,$currentRetainage,$previousRetentionValues);
		// $currentRetainerValue = self::calculateCurrentRetainerValue($currentRetentionvalue, $retainerRate);

		$RetDataItem = self::findById($database, $retentionItemId);
		$RetDataItem->convertPropertiesToData();
		$RetData = $RetDataItem->getData();
		// $RetData['current_app'] = $currentApp;
		$RetData['percentage_completed'] = $completionPercentage;
		$RetData['current_retainer_value'] = $newValue;
		$RetDataItem->setData($RetData);
		$returnArr['retention_id'] = $RetDataItem->save();
		$returnArr['scheduled_retention_value'] = $scheduledValue;
		return $returnArr;
	}

	/**
	* calculate completed percentage for given current app
	*/
	public static function calculateCompletionPercentage($currentRetentionvalue,$currentRetainage,$previousRetentionValues){
		// Formula : Current retainer value  = (( Previous Ret. Value + cur retainer value)/Current Ret. Value )*100
		$previousApp = $previousDrawValues['current_app'] ? $previousDrawValues['current_app'] : 0;
		$currentApp = (float) $currentApp;
		$currentRetainage = (float) $currentRetainage;
		$totalretentionvalue = (float) $previousRetentionValues+$currentRetentionvalue;
		$completionPercentage = ($totalretentionvalue/$currentRetainage)*100;
		$completionPercentage = number_format($completionPercentage, 2, '.', '');
		return $completionPercentage;
	}
	
	/** 
	* calculate retainer value for given current app
	*/
	// public static function calculateCurrentRetainerValue($currentRetentionvalue, $retainerRate){
	// 	$currentRetainerValue = ((float)$currentApp*(float)$retainerRate)/100;
	// 	$currentRetainerValue = number_format($currentRetainerValue, 2, '.', '');
	// 	return $currentRetainerValue;
	// }
	/**
	* Update completed percentage
	*/
	public static function updateCompletedPercent($database, $retentionItemId,$newValue,$type,$projectId, $lineItemId, $previousRetentionValues){
		$db = DBI::getInstance($database);
		$selectedretItem = self::findById($database, $retentionItemId);
		$scheduledValue = $selectedretItem['scheduled_value'];
		$current_retainage = $selectedretItem['current_retainage'];
		$previous_retainage = $selectedretItem['previous_retainage'];
		$completionPercentage = $newValue;

		// $currentApp = self::calculateCurrentAppValue($database, $retentionItemId, $previousRetentionValues, $completionPercentage, $type, $projectId, $lineItemId);
	
		$currentRetainerValue = self::calculateCurrentRetainerValue($current_retainage, $completionPercentage,$previous_retainage);
		$retDataItem = self::findById($database, $retentionItemId);
		$retDataItem->convertPropertiesToData();
		$retData = $retDataItem->getData();
		$retData['current_retainer_value'] = $currentRetainerValue;
		$retData['percentage_completed'] = $completionPercentage;
		$retDataItem->setData($retData);
		$returnArr['retention_id'] = $retDataItem->save();
		$returnArr['scheduled_retention_value'] = $scheduledValue;
		return $returnArr;
	}
	/**
	* calculate retainer value for given current app
	*/
	public static function calculateCurrentRetainerValue($previousRetentionValues, $completionPercentage,$previousretvalue){
		// formula Ret Amt to bill = (Current Ret. withheld *(%completion/100)) - Previous Ret. billed
		$currentRetainer = ((float)$previousRetentionValues*((float)$completionPercentage)/100);
		$currentRetainerValue = $currentRetainer-$previousretvalue;
		$currentRetainerValue = number_format($currentRetainerValue, 2, '.', '');
		return $currentRetainerValue;
	}
	/**
	* save or update narrative
	*/
	public static function updateNarrative($database, $drawItemId,$newValue){
		$db = DBI::getInstance($database);
		$narrative = $newValue;

		$drawDataItem = self::findById($database, $drawItemId);
		$drawDataItem->convertPropertiesToData();
		$drawData = $drawDataItem->getData();
		$drawData['narrative'] = $narrative;
		$drawDataItem->setData($drawData);
		$drawItemId = $drawDataItem->save();

		$returnArr['draw_id'] = $drawItemId;
		return $returnArr;
	}

	/**
	* get change order items for grid
	*/
	public static function getChangeOrderRetentionItems($database,$RetentionId, $options = ''){
		$RetentionId = (int) $RetentionId;
		$db = DBI::getInstance($database);

		$wherCond = '';
		if(!empty($options) && ($options =='1' || $options =='3' )){
			$wherCond = ' AND di.`narrative` IS NOT NULL AND di.`narrative` !=""';
		}
		// drr.`retainer_rate` LEFT JOIN `draw_retainer_rate` drr ON drr.`draw_item_id`=di.`id`

		$query=	"
		SELECT di.`id`, di.`retention_id`,co.`co_type_prefix`,co.`co_title`,co.`co_total`,di.`change_order_id`,
		di.`current_retainage`,di.`previous_retainage`,di.`current_retainer_value`,di.`percentage_completed`,di.`narrative`,di.`scheduled_retention_value`
		FROM `retention_items` di
		LEFT JOIN `change_orders` co ON co.`id`=di.`change_order_id`
		
		WHERE di.`retention_id`=? AND di.`change_order_id` IS NOT NULL ".$wherCond."
		GROUP BY di.`id`  ORDER BY `co`.`co_type_prefix` ASC 
		";
		$arrValues = array($RetentionId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$records = array();
		while($row = $db->fetch())
		{
			$records[] = $row;
		}
		$db->free_result();
		return $records;
	}
	/*To get total retention value */
	public static function sumofRetentionItems($database,$project_id,$lastdrawId){
		$lastdrawId = (int) $lastdrawId;

		$db = DBI::getInstance($database);
		$query=	"SELECT sum(current_retainer_value) as curr_App FROM `retention_draws` as rd INNER join retention_items as ri on rd.id = ri.retention_id where rd.project_id = ? and rd.`last_draw_id` <=?";
		$arrValues = array($project_id,$lastdrawId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$currentApp = $row['curr_App'];
		$db->free_result();
		return $currentApp;
	}

	/*To get total retention value */
	public static function sumOfColRetItem($database,$project_id,$lastdrawId,$col){

		$lastdrawId = (int) $lastdrawId;
		$db = DBI::getInstance($database);

		$query=	"SELECT sum($col) as curr_App FROM `retention_draws` as rd INNER join retention_items as ri on rd.`id` = ri.`retention_id` where rd.`project_id` = ? and rd.`last_draw_id` = ?";
		$arrValues = array($project_id,$lastdrawId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$currentApp = $row['curr_App'];
		$db->free_result();
		return $currentApp;
	}

	// To update the budget schedule values while a oco is edited and added
	public static function updateScheduledValueAgainstCostcode($database,$project_id){
		$db = DBI::getInstance($database);
		$query=	" 
		SELECT ri.`id` as ri_id, ri.`retention_id` as ri_retention_id, ri.`cost_code_id` as ri_cost_code_id, ri.`gc_budget_line_item_id` as ri_gc_budget_line_item_id, ri.`change_order_id` as ri_change_order_id, ri.`scheduled_retention_value` as  ri_scheduled_retention_value, ri.`current_retainage` as ri_current_retainage, ri.`previous_retainage` as ri_previous_retainage, ri.`current_retainer_value` as ri_current_retainer_value, ri.`percentage_completed` as ri_percentage_completed, ri.`balance_retainage_value` as ri_balance_retainage_value, ri.`narrative` as ri_narrative, ri.`type` as ri_type,
		g.*, r.* FROM `retention_draws`  as r
		inner join `retention_items` as ri on r.id =  ri.retention_id
		inner join `gc_budget_line_items` as g on g.id =  ri.gc_budget_line_item_id
		WHERE r.`project_id` = ? AND r.`status` = ? and ri.`gc_budget_line_item_id` is not null";
		$arrValues = array($project_id,1);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$reschedule = array();
		while($row = $db->fetch())
		{
			$reschedule[] = $row;
		}
		$db->free_result();
		if(!empty($reschedule)){
		foreach ($reschedule as $key => $revalue) {
			$revisedAmt =0;
			$costCodeid = $revalue['ri_cost_code_id'];
			$orgsch = $revalue['prime_contract_scheduled_value'];
			$retentionItemId = $revalue['ri_id'];
			$lineItemId = $revalue['ri_gc_budget_line_item_id'];
			$applicationNumber = $revalue['application_number'];
		    $newValue = $revalue['ri_current_retainer_value'];
		    $curRetainage = $revalue['ri_previous_retainage'];
			$reAssignedAmt = ChangeOrder::ReallocationInDrawsAndCOByCostCode($database,$costCodeid,$project_id);
		    $revisedAmt = $orgsch  + $reAssignedAmt;


			// To save the schdule value data
			$updateItem = self::findById($database,$retentionItemId);
				$updateItem->convertPropertiesToData();
				$updateData = $updateItem->getData();
				$updateData['scheduled_retention_value'] = $revisedAmt;
				$updateItem->setData($updateData);
				$updateItem->save();

				// to calculate and update the % completion
				$row = RetentionItems::findById($database, $retentionItemId);
		$previousRetentionValues  = $row['previous_retainage'];
		$drawData = self::updateCurrentRetentionValue($database, $retentionItemId, $newValue, 'gc_budget_line_item_id', $previousRetentionValues,$curRetainage);

		}
	}
	

	}

	/**
	* get Retention items by retention id
	*/
	public static function getRetentionItemsByRetentionId($database, $retentionId){
		$retentionId = (int) $retentionId;
		$db = DBI::getInstance($database);

		$query=	"
		SELECT ri.*
		FROM `retention_items` ri
		WHERE ri.`retention_id`=?
		";
		$arrValues = array($retentionId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$records = array();
		while($row = $db->fetch())
		{
			$records[] = $row;
			/*$drawItemId = $row['id'];
			$drawItemGet = self::findById($database, $drawItemId);
			$drawItemGet->delete();*/
		}
		$db->free_result();
		return $records;
	}

	/**
	*  update change order
	*/
	public static function updateChangeOrder($database,$projectId,$changeOrderId){
		$changeOrderId = (int) $changeOrderId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);

		$query = "
		SELECT reti.*,co.`co_total`,rd.`id` AS retentionId FROM retention_draws rd
		LEFT JOIN `retention_items` reti ON reti.`retention_id`=rd.`id`
		LEFT JOIN `change_orders` co ON co.`id`=reti.`change_order_id`
		WHERE rd.`project_id`=? AND rd.`status`=1 AND reti.`change_order_id` =?
		AND co.`change_order_status_id`=2 AND co.`change_order_type_id`=2 AND rd.`is_deleted_flag`='N'
		";
		$arrValues = array($projectId,$changeOrderId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$records = array();
		while($row = $db->fetch())
		{
			$records[] = $row;
		}

		$db->free_result();
		$retentionIdsArr = self::updateChangeOrderScheduledValue($database,$projectId,$changeOrderId,$records);
		return $retentionIdsArr;
	}

	/**
	*  update change order scheduled value
	*/
	public static function updateChangeOrderScheduledValue($database,$projectId,$changeOrderId,$changeOrderRequests){
		$changeOrderId = (int) $changeOrderId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$retentionIdsArr = array();
		foreach ($changeOrderRequests as $orderKey => $orderValue) {
			$drawItemId = $orderValue['id'];
			$scheduledValue = $orderValue['co_total'];
			$retentionId = $orderValue['retentionId'];
			$retentionIdsArr[] = $retentionId;
		
			$updateCOItem = self::findById($database,$drawItemId);
			$updateCOItem->convertPropertiesToData();
			$updateCOData = $updateCOItem->getData();
			$updateCOData['scheduled_retention_value'] = $scheduledValue;
			$updateCOItem->setData($updateCOData);
			$updateCOItem->save();
		}
		return $retentionIdsArr;
	}

	/**
	*  save change order
	*/
	public static function saveChangeOrder($database,$projectId,$changeOrderId,$retentionIds){
		$changeOrderId = (int) $changeOrderId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		if(count($retentionIds) > 0){
			$retentionIds = implode(', ',$retentionIdds);
			$subQuery = "AND d.`id` NOT IN ($retentionIds)";
		}else{
			$subQuery = '';
		}
		$query = "
		SELECT d.id AS retentionId,co.* FROM `change_orders` co
		LEFT JOIN retention_draws d ON d.project_id=co.`project_id`
		WHERE co.project_id=?
		AND co.id = ?
		AND co.`change_order_status_id`=2 AND co.`change_order_type_id`=2 AND co.co_total!=0 AND d.status=1 $subQuery
		AND d.`is_deleted_flag`='N'
		";
		$arrValues = array($projectId,$changeOrderId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$drawChangeOrderItems = array();
		while($row = $db->fetch())
		{
			$drawChangeOrderItems[] = $row;
		}
		$db->free_result();
		
		foreach ($drawChangeOrderItems as $orderKey => $orderValue) {
			$scheduledValue = $orderValue['co_total'];
			$retentionId = $orderValue['retentionId'];

			$changeOrderItem = new RetentionItems($database);
			$changeOrderItem->convertPropertiesToData();
			$changeOrderData = $changeOrderItem->getData();
			$changeOrderData['retention_id'] = $retentionId;
			$changeOrderData['change_order_id'] = $changeOrderId;
			$changeOrderData['scheduled_retention_value'] = $scheduledValue;
			$changeOrderData['type'] = 'N';
			$changeOrderItem->setData($changeOrderData);
			$drawItemId = $changeOrderItem->save();

			// self::saveCORetainerRate($database,$projectId,$changeOrderId,$drawItemId);
		}
	}

	/**
	*  delete change order
	*/
	public static function deleteChangeOrder($database,$projectId,$changeOrderId){
		$changeOrderId = (int) $changeOrderId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$query = "
		SELECT di.`id` FROM `retention_items` di
		LEFT JOIN retention_draws d ON di.`retention_id`=d.`id`
		LEFT JOIN change_orders co ON co.`id`=di.`change_order_id`
		WHERE co.`project_id`=?
		AND di.`change_order_id` =?
		AND (co.`change_order_status_id`!=2
		OR co.`change_order_type_id`!=2 OR co.`co_total`=0) AND d.`status`=1
		GROUP BY di.`id`
		";
		$arrValues = array($projectId,$changeOrderId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$drawItemIds = array();
		while($row = $db->fetch())
		{
			$drawItemIds[] = $row['id'];
		}
		$db->free_result();
		$deleteIds = implode(", ",$drawItemIds);
		$deleteQuery = "
		DELETE FROM `retention_items` WHERE `id` IN ($deleteIds)
		";
		$db->execute($deleteQuery);
		$db->free_result();
	}

	public static function getRetBillingAmtByRetIdAndLineItemId($database,$ret_id,$budgetLineItemId,$type){
		$ret_id = (int) $ret_id;
		$budgetLineItemId = (int) $budgetLineItemId;
		$db = DBI::getInstance($database);
		$query = "
		SELECT * FROM `retention_items` WHERE `retention_id` = ? AND $type = ?
		";
		$arrValues = array($ret_id,$budgetLineItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		return $row;
	}

	public static function getRetItemDataForNarAndGCF($database, $ret_id, $type){

		$db = DBI::getInstance($database);

		$wherCond = '';
		if ($type == 'narrative') {
			$wherCond = 'AND ri.`narrative` IS NOT NULL AND ri.`narrative` !=""';
		}else if ($type == 'general_condition') {
			$wherCond = 'AND ri.`gc_budget_line_item_id` IS NOT NULL AND ccd.`division_number_group_id` ="0"';
		}

		$query = "
			SELECT * FROM `retention_items` ri
			LEFT JOIN `gc_budget_line_items` gcbli ON gcbli.`id` = ri.`gc_budget_line_item_id`
			LEFT JOIN `cost_codes` cc ON cc.`id`= gcbli.`cost_code_id`
			LEFT JOIN `cost_code_divisions` ccd ON ccd.`id`= cc.`cost_code_division_id`
			WHERE ri.`retention_id` = ? ".$wherCond ;

		$arrValues = array($ret_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

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
