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
require_once('lib/common/ChangeOrder.php');
class DrawItems extends IntegratedMapper
{
	/**
	* Class name for use in deltifyAndSave().
	*/
	protected $_className = 'DrawItems';

	/**
	* Table name for this Integrated Mapper.
	*
	* @var string
	*/
	protected $_table = 'draw_items';

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
		'id' => 'draw_item_id',
		'draw_id' => 'draw_id',
		'cost_code_id' => 'cost_code_id',
		'gc_budget_line_item_id' => 'gc_budget_line_item_id',
		'change_order_id' => 'change_order_id',
		'current_app' => 'current_app',
		'completed_percent' => 'completed_percent',
		'current_retainer_value' => 'current_retainer_value',
		'narrative' => 'narrative',
		'type' => 'type',
		'cor_type' => 'cor_type'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $draw_item_id;
	public $draw_id;
	public $cost_code_id;
	public $gc_budget_line_item_id;
	public $change_order_id;
	public $current_app;
	public $completed_percent;
	public $current_retainer_value;
	public $narrative;
	public $type;
	public $cor_type;

	/**
	* Constructor
	*/
	public function __construct($database, $table='draw_items')
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
	public static function findById($database, $draw_item_id, $table='draw_items', $module='DrawItems')
	{
		$drawItem = parent::findById($database, $draw_item_id, $table, $module);
		return $drawItem;
	}

	/**
	* get draws
	*/
	public static function getDrawItems($database, $projectId){
		$projectId = (int) $projectId;
		$last_draw_invoice_date = Draws::findLastDrawIdUsingProjectId($database, $projectId,'invoice_date');
		$drawChangeOrderItems = self::getChangeOrderRequestList($database, $projectId,$last_draw_invoice_date);
		$cOrder_cc=array();
		foreach ($drawChangeOrderItems as $key => $value) {
			if($value['cost_code_reference_id']>0){				
			$cOrder_cc[] = $value['cost_code_reference_id'];
			}
		}
		$cOrder_cc_id = "'".implode("','", $cOrder_cc)."'";
		// $drawbudgetItemsww = ChangeOrder::getDrawItemsqqq($database, $projectId);

		$db = DBI::getInstance($database);

		$query ="
		SELECT cc.`cost_code`,cc.`cost_code_description`,gcbli.`prime_contract_scheduled_value`,gcbli.`id`,
		project.`retainer_rate` project_retainer_rate,ccd.`division_number`, gcbli.`cost_code_id`
		FROM `gc_budget_line_items` gcbli
		LEFT JOIN `cost_codes` cc ON cc.`id`= gcbli.`cost_code_id`
		LEFT JOIN `cost_code_divisions` ccd ON ccd.`id`= cc.`cost_code_division_id`
		LEFT JOIN `projects` project on project.`id`=gcbli.`project_id`
		WHERE gcbli.`project_id`=? AND (gcbli.`prime_contract_scheduled_value`!=0 || gcbli.cost_code_id IN($cOrder_cc_id) )";
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
	* get previous draw values
	*/
	public static function getPreviousDrawValue($database, $projectId, $lineItemId, $type,$drawItemId,$applicationNumber = 0,$corType){
		$projectId = (int) $projectId;
		$lineItemId = (int) $lineItemId;
		$drawItemId =(int) $drawItemId;
		$applicationNumber = (int) $applicationNumber;
		$is_deleted_flag = 'N';
		$db = DBI::getInstance($database);
		if($drawItemId){
			$subQuery = " AND di.`id`!=?";
		}
		if($applicationNumber){
			$applicationQuery = " AND draw.`application_number` < ?";
			$arrValues = array($is_deleted_flag, $projectId,$lineItemId,$corType,$drawItemId,$applicationNumber);
		}else{
			$applicationQuery = '';
			$arrValues = array($is_deleted_flag, $projectId,$lineItemId,$corType,$drawItemId);
		}
		$query = "
		SELECT SUM(`current_app`) AS current_app,SUM(`current_retainer_value`) AS current_retainer_value,di.`completed_percent`
		FROM `draws` draw
		LEFT JOIN `draw_items` di ON draw.`id`=di.`draw_id` AND draw.`is_deleted_flag` = ?
		WHERE draw.`project_id`= ? AND $type = ? AND di.`cor_type` = ? $subQuery $applicationQuery
		";
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if($applicationNumber){
			$lastRetDrawId = self::getLastRetDrawIdUsingDrawAppNo($database, $projectId, $applicationNumber);
			$row['lastRetDrawId'] = $lastRetDrawId;

			$query2 = "SELECT previous_retainage,current_retainer_value FROM `retention_draws` redraw LEFT JOIN `retention_items` rei ON redraw.`id`=rei.`retention_id` AND redraw.`is_deleted_flag` = 'N' WHERE redraw.`project_id`= ? AND $type = ? AND rei.`retention_id` = ?";
			$arrValue2 = array($projectId, $lineItemId, $lastRetDrawId);
			$db->execute($query2, $arrValue2, MYSQLI_USE_RESULT);
			$row2 = $db->fetch();
			$db->free_result();

			$row['current_retainer_value'] = $row['current_retainer_value'] - $row2['previous_retainage'] - $row2['current_retainer_value'];
		}

		return $row;
	}

	/**
	* get approved change order requests
	*/

	public static function getLastRetDrawIdUsingDrawAppNo($database, $projectId, $applicationNumber){

		$db = DBI::getInstance($database);
		$query2 = "SELECT id,application_number FROM `retention_draws` WHERE `project_id` = ? AND `last_draw_id` < (SELECT id FROM `draws` WHERE `project_id` = ? AND `application_number` = ? AND `is_deleted_flag` = 'N') AND `is_deleted_flag` = 'N' ORDER BY `id` DESC LIMIT 1";
		$arrValue2 = array($projectId, $projectId, $applicationNumber);
		$db->execute($query2, $arrValue2, MYSQLI_USE_RESULT);
		$lastRetDrawId = $db->fetch();
		$db->free_result();		
		return $lastRetDrawId['id'];
	}
	public static function getChangeOrderRequestList($database, $projectId, $invoice_date,$last_cor_ty=''){
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$groupby='';
		if($last_cor_ty=='A'){
			$groupby='GROUP BY `co_type_prefix`';
		}
		$query ="
		SELECT co.`co_type_prefix`,co.`co_title`,co.`co_total`,co.`id`,
		project.`retainer_rate` project_retainer_rate,`cb`.`cost_code_reference_id`
		FROM `change_orders` co
		LEFT JOIN `projects` project on project.`id`=co.`project_id`
		LEFT JOIN `change_order_cost_break` cb ON `cb`.`change_order_id` = `co`.`id`
		WHERE co.`project_id`=? AND co.`change_order_type_id`=2 AND co.`change_order_status_id`=2
		AND co.`co_total` != 0
		AND `cb`.`cost_code_flag` IN ('1','2')
		AND co.`co_approved_date` <= ?  $groupby ";
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
	/**
	* get project retainer value
	*/
	public static function getProjectRetainerValue($database, $projectId){
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$query ="
		SELECT `retainer_rate`
		FROM `projects`
		WHERE `id`=?";
		$arrValues = array($projectId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		return $row['retainer_rate'];
	}
	/**
	* get budget line item scheduled value
	*/
	public static function getLineItemScheduledValue($database, $drawItemId){
		$drawItemId = (int) $drawItemId;
		$db = DBI::getInstance($database);
		$query ="
		SELECT gcbli.`prime_contract_scheduled_value`
		FROM `draw_items` di
		LEFT JOIN `gc_budget_line_items` gcbli ON gcbli.`id`=di.`gc_budget_line_item_id`
		WHERE  di.`id`=?";
		$arrValues = array($drawItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		return $row['prime_contract_scheduled_value'];
	}
	/**
	* get change order total
	*/
	public static function getChangeOrderTotal($database, $drawItemId){
		$drawItemId = (int) $drawItemId;
		$db = DBI::getInstance($database);
		$query ="
		SELECT co.`co_total`
		FROM `draw_items` di
		LEFT JOIN `change_orders` co ON co.`id`=di.`change_order_id`
		WHERE  di.`id`=?";
		$arrValues = array($drawItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		return $row['co_total'];
	}
	/**
	* Get retainer rate of draw item
	*/
	public static function getDrawRetainerRate($database, $projectId, $drawItemId){
		$projectId = (int) $projectId;
		$drawItemId = (int) $drawItemId;
		$db = DBI::getInstance($database);
		$query = "
		SELECT `retainer_rate` FROM `draw_retainer_rate` WHERE draw_item_id=?";
		$arrValues = array($drawItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		return $row['retainer_rate'];
	}
	/**
	* Save draw items
	*
	* @param string $database
	* @param int $projectId
	* @return mixed (single ORM object | false)
	*/
	public static function updateDrawItem($database, $projectId, $drawItemId,$newValue,$lineItemId,$type,$column,$drawId){
		$projectId = (int) $projectId;
		$drawItemId = (int) $drawItemId;
		$db = DBI::getInstance($database);

		$retainerRate = self::getDrawRetainerRate($database, $projectId, $drawItemId);
		$applicationNumber = self::getDrawApplicationNumber($database,$drawId);
		$corType = self::getLastCorType($database,$projectId,$applicationNumber);
		$previousDrawValues = self::getPreviousDrawValue($database, $projectId, $lineItemId ,$type,$drawItemId,$applicationNumber,$corType);
		if($column == 'current_app'){
			$newValue = str_replace('$','',$newValue); //replace '$' symbol in value
			$newValue = str_replace(',','',$newValue); //replace '-' symbol in value
			$drawData = self::updateCurrentApp($database, $drawItemId, $newValue, $type, $retainerRate, $previousDrawValues, $projectId, $lineItemId);
		}else if($column == 'completed_percent'){
			$drawData = self::updateCompletedPercent($database, $drawItemId, $newValue, $type, $retainerRate, $projectId, $lineItemId, $previousDrawValues);
		}else if($column == 'narrative'){
			$drawData = self::updateNarrative($database, $drawItemId,$newValue);
		}else if($column == 'retainer_rate'){
			self::updateNextDrawsRetainerValue($database,$drawItemId,$type,$projectId, $lineItemId,$newValue);
		}
		else if($column == 'current_retention'){
			self::updateNextDrawsCurrentRetention($database,$drawItemId,$type,$projectId, $lineItemId,$newValue);
		}
		else if($column == 'realocation'){
			$drawData = self::updateDrawColumns($database, $drawItemId,$newValue,'realocation');
		}
		else if($column == 'renotes'){
			$drawData = self::updateDrawColumns($database, $drawItemId,$newValue,'renotes');
		}
		$applicationNumber = self::getDrawApplicationNumber($database,$drawId);
		return $applicationNumber;
	}
	/**
	* calculate current app value for given completed percent
	*/
	public static function calculateCurrentAppValue($database, $drawItemId, $previousDrawValues, $completionPercentage, $type, $projectId, $lineItemId){
		$drawItemId = (int) $drawItemId;
		$db = DBI::getInstance($database);
		if($type == 'gc_budget_line_item_id'){
			$previousCompletionValues = self::getPreviousBudgetValues($database, $projectId, $lineItemId);
		}else{
			$previousCompletionValues = self::getPreviousCOValues($database, $projectId, $lineItemId);
		}
		$previousCompletion = $previousCompletionValues['completed_percent'];
		$sumOfPreviousApp = $previousDrawValues['current_app'];
		$selectedDrawItem = self::findById($database, $drawItemId);
		$scheduledValue = (float) $selectedDrawItem['scheduled_value'];
		// To include the reallocations
     		$realocation = $selectedDrawItem['realocation'];
     		$scheduledValue = $scheduledValue +$realocation;
		$completedPercent = (float) $completionPercentage;
		$currentAppValue = (($completedPercent / 100)*$scheduledValue);
		$currentApp = $currentAppValue - $sumOfPreviousApp;
		return $currentApp;
	}
	/**
	* Update completed percentage
	*/
	public static function updateCompletedPercent($database, $drawItemId,$newValue,$type,$retainerRate,$projectId, $lineItemId, $previousDrawValues){
		$db = DBI::getInstance($database);
		$selectedDrawItem = self::findById($database, $drawItemId);
		$scheduledValue = $selectedDrawItem['scheduled_value'];
		// To include the reallocations
     	 	$realocation = $selectedDrawItem['realocation'];
     	 	$scheduledValue = $scheduledValue +$realocation;
		$completionPercentage = $newValue;

		$currentApp = self::calculateCurrentAppValue($database, $drawItemId, $previousDrawValues, $completionPercentage, $type, $projectId, $lineItemId);
		$currentRetainerValue = self::calculateCurrentRetainerValue($currentApp, $retainerRate);
		$previous_retainage = $previousDrawValues['current_retainer_value'];
		$total_retainage = floatval($currentRetainerValue) + floatval($previous_retainage);
		if ($total_retainage < 0) {
			$currentRetainerValue = -1 * floatval($previous_retainage); 
			self::updateNextDrawsCurrentRetention($database,$drawItemId,$type,$projectId, $lineItemId,$currentRetainerValue);
		}

		$drawDataItem = self::findById($database, $drawItemId);
		$drawDataItem->convertPropertiesToData();
		$drawData = $drawDataItem->getData();
		$drawData['current_app'] = $currentApp;
		$drawData['completed_percent'] = $completionPercentage;
		$drawData['current_retainer_value'] = $currentRetainerValue;
		$drawDataItem->setData($drawData);
		$returnArr['draw_id'] = $drawDataItem->save();
		$returnArr['scheduled_value'] = $scheduledValue;
		return $returnArr;
	}

	/**
	* save or update current app
	*/
	public static function updateCurrentApp($database, $drawItemId,$newValue,$type,$retainerRate,$previousDrawValues,$projectId,$lineItemId){
		$db = DBI::getInstance($database);
		$selectedDrawItem = self::findById($database, $drawItemId);
		$scheduledValue = $selectedDrawItem['scheduled_value'];
		 // To include the reallocations
     	 	$realocation = $selectedDrawItem['realocation'];
     	 	$scheduledValue = $scheduledValue +$realocation;
		$currentApp = $newValue;
		$completionPercentage = self::calculateCompletionPercentage($currentApp,$scheduledValue,$previousDrawValues);
		$currentRetainerValue = self::calculateCurrentRetainerValue($currentApp, $retainerRate);
		$previous_retainage = $previousDrawValues['current_retainer_value'];
		$total_retainage = floatval($currentRetainerValue) + floatval($previous_retainage);
		if ($total_retainage < 0) {
			$currentRetainerValue = -1 * floatval($previous_retainage); 
			self::updateNextDrawsCurrentRetention($database,$drawItemId,$type,$projectId, $lineItemId,$currentRetainerValue);
		}

		$drawDataItem = self::findById($database, $drawItemId);
		$drawDataItem->convertPropertiesToData();
		$drawData = $drawDataItem->getData();
		$drawData['current_app'] = $currentApp;
		$drawData['completed_percent'] = $completionPercentage;
		$drawData['current_retainer_value'] = $currentRetainerValue;
		$drawDataItem->setData($drawData);
		$returnArr['draw_id'] = $drawDataItem->save();
		$returnArr['scheduled_value'] = $scheduledValue;
		return $returnArr;
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
	* save or update the drawItems column
	*/
	public static function updateDrawColumns($database, $drawItemId,$newValue,$column){
		$db = DBI::getInstance($database);

		$drawDataItem = self::findById($database, $drawItemId);
		$drawDataItem->convertPropertiesToData();
		$drawData = $drawDataItem->getData();
		$drawData[$column] = $newValue;
		$drawDataItem->setData($drawData);
		$drawItemId = $drawDataItem->save();

		$returnArr['draw_id'] = $drawItemId;
		return $returnArr;
	}

	/**
	* calculate completed percentage for given current app
	*/
	public static function calculateCompletionPercentage($currentApp,$scheduledValue,$previousDrawValues){
		$previousApp = $previousDrawValues['current_app'] ? $previousDrawValues['current_app'] : 0;
		$currentApp = (float) $currentApp;
		$scheduledValue = (float) $scheduledValue;
		$totalCompletedApp = (float) $previousApp+$currentApp;
		$completionPercentage = ($totalCompletedApp/$scheduledValue)*100;
		$completionPercentage = number_format($completionPercentage, 2, '.', '');
		return $completionPercentage;
	}

	/**
	* calculate retainer value for given current app
	*/
	public static function calculateCurrentRetainerValue($currentApp, $retainerRate){
		$currentRetainerValue = ((float)$currentApp*(float)$retainerRate)/100;
		$currentRetainerValue = number_format($currentRetainerValue, 2, '.', '');
		return $currentRetainerValue;
	}
	/**
	* calculate Current Retention for given current app
	*/
	public static function calculateRetentionRate($currentApp, $currentRetention){
		$RetentionRate = ((float)$currentRetention/$currentApp)*100;
		$RetentionRateValue = number_format($RetentionRate, 2, '.', '');
		return $RetentionRateValue;
	}

	/**
	* get total scheduled value
	*/
	public static function getTotalScheduledValue($database,$projectId,$drawId,$corType){
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$query ="
		SELECT SUM(di.`scheduled_value`) AS scheduled_value
		FROM `draw_items` di
		LEFT JOIN draws d ON d.`id`=di.`draw_id`
		WHERE  d.`project_id`=? AND di.`draw_id`=? AND di.`cor_type` = ? GROUP BY di.`cost_code_id`, di.`change_order_id`";
		$arrValues = array($projectId,$drawId,$corType);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		// $row = $db->fetch();
		$records = array();
		while($row = $db->fetch())
		{
			$records[] = $row;
		}
		$scheduled_value=0;
		foreach ($records as $key => $value) {
			$scheduled_value=$scheduled_value+$value['scheduled_value'];
		}
		$db->free_result();
		// $totalScheduledValue = $row['scheduled_value'];
		return $scheduled_value;
	}
	/**
	* get sum of previous realocation value
	*/
	public static function getsumOfPreviousRealocationValue($database,$projectId,$drawId,$gcBudgetLineItemId){
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$corType = self::getLastCorType($database,$projectId,0);
		$query ="
		SELECT SUM(di.`realocation`) AS realocation_value
		FROM `draw_items` di
		LEFT JOIN draws d ON d.`id`=di.`draw_id`
		WHERE  d.`project_id`=? AND di.`gc_budget_line_item_id` =? AND di.`cor_type` = ? AND di.`draw_id`< ?";
		$arrValues = array($projectId,$gcBudgetLineItemId,$corType,$drawId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		$sumRealocationValue = $row['realocation_value'];
		return $sumRealocationValue;
	}
	/**
	* get previous budget line item draw values
	*/
	public static function getPreviousBudgetValues($database, $projectId, $gcBudgetLineItemId, $drawItemId,$corType){
		$projectId = (int) $projectId;
		$gcBudgetLineItemId = (int) $gcBudgetLineItemId;
		$drawItemId = (int) $drawItemId;
		$db = DBI::getInstance($database);
		$query ="
		SELECT di.`completed_percent` FROM `draw_items` di
		LEFT JOIN `draws` draw ON draw.`id`=di.`draw_id`
		WHERE di.`gc_budget_line_item_id` =? AND draw.`project_id`=?
		AND draw.`is_deleted_flag` = 'N'
		AND di.`cor_type` = ?
		AND di.`completed_percent` IS NOT NULL AND di.`id`< ? ORDER BY di.`draw_id` DESC LIMIT 1";
		$arrValues = array($gcBudgetLineItemId,$projectId,$corType,$drawItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		return $row;
	}
	/**
	* get previous change order item draw values
	*/
	public static function getPreviousCOValues($database, $projectId, $changeOrderId, $drawItemId){
		$projectId = (int) $projectId;
		$changeOrderId = (int) $changeOrderId;
		$drawItemId = (int) $drawItemId;
		$db = DBI::getInstance($database);
		$is_deleted_flag = 'N';
		$query ="
		SELECT di.`completed_percent` FROM `draw_items` di
		LEFT JOIN `draws` draw ON draw.`id`=di.`draw_id` AND draw.`is_deleted_flag` = ?
		WHERE di.`change_order_id` =? AND draw.`project_id`=?
		AND draw.`is_deleted_flag` = 'N'
		AND di.`completed_percent` IS NOT NULL AND di.`id` < ? ORDER BY di.`draw_id` DESC LIMIT 1";
		$arrValues = array($is_deleted_flag, $changeOrderId, $projectId, $drawItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		return $row;
	}
	/**
	* create draws
	*/
	public static function createDrawItems($database, $projectId, $drawId){
		$applicationNumber = self::getDrawApplicationNumber($database,$drawId);
		$last_cor_type = self::getLastCorType($database,$projectId,$applicationNumber);
		$drawbudgetItems = self::getDrawItems($database, $projectId);
		$last_draw_invoice_date = Draws::findLastDrawIdUsingProjectId($database, $projectId,'through_date');
		$drawChangeOrderItems = self::getChangeOrderRequestList($database, $projectId,$last_draw_invoice_date,$last_cor_type);
		
		self::saveBudgetItems($database, $projectId, $drawId, $drawbudgetItems, $last_cor_type);
		self::saveChangeOrderApprovedItems($database, $projectId, $drawId, $drawChangeOrderItems, $last_cor_type);
		if ($applicationNumber == 1) {
			self::saveBudgetItemAboveTheLine($database, $projectId, $drawId, $drawbudgetItems);
			self::saveChangeOrderApprovedItemAboveTheLine($database, $projectId, $drawId, $drawChangeOrderItems);
		}
		return $applicationNumber;
	}
	/**
	* get budget line items for grid
	*/
	public static function getBudgetDrawItems($database, $drawId, $options = '', $cor_type = ''){
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		$wherCond = '';
		if(!empty($options) && ($options =='1' || $options =='3')){
			$wherCond = 'AND di.`narrative` IS NOT NULL AND di.`narrative` !=""';
		}else if(!empty($options) && $options =='4'){
			$wherCond = ' AND ccd.`division_number_group_id` ="0"';
		}

		$cor_type_val = 'B';
		if (!empty($cor_type) && $cor_type == '1') {
			$cor_type_val = 'B';
		}else if(!empty($cor_type) && $cor_type == '2'){
			$cor_type_val = 'A';
		}

		$query=	"
		SELECT di.`id`, di.`draw_id`,cc.`cost_code`,cc.`cost_code_description`,cc.`id` as 'cost_code_id',ccd.`id` as 'cost_code_divison_id',gcbli.`prime_contract_scheduled_value`,di.`gc_budget_line_item_id`,
		ccd.`division_number`, gcbli.`cost_code_id`,
		di.`current_app`,di.`current_retainer_value`,di.`completed_percent`,di.`narrative`,di.`realocation`,di.`renotes`,
		drr.`retainer_rate`,di.`scheduled_value`,cc.`cost_code_division_id`,ccd.`division_number_group_id`, di.`is_realocation`
		FROM `draw_items` di
		LEFT JOIN `gc_budget_line_items` gcbli ON gcbli.`id`=di.`gc_budget_line_item_id`
		LEFT JOIN `cost_codes` cc ON cc.`id`= di.`cost_code_id`
		LEFT JOIN `cost_code_divisions` ccd ON ccd.`id`= cc.`cost_code_division_id`
		LEFT JOIN `draw_retainer_rate` drr ON drr.`draw_item_id`=di.`id`
		WHERE di.`draw_id`=? AND di.`cor_type`=? AND di.`gc_budget_line_item_id` IS NOT NULL ".$wherCond." ORDER BY  `ccd`.`division_number` ASC ,`cc`.`cost_code` ASC ,di.`gc_budget_line_item_id`
		";
		$arrValues = array($drawId, $cor_type_val);
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
	* get budget line items for grid
	*/
	public static function getSingleBudgetDrawItems($database,$drawId,$costCodeId,$gcBudgetLineItemId, $options = '',$corType){
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		$wherCond = '';
		if(!empty($options) && ($options =='1' || $options =='3')){
			$wherCond = 'AND di.`narrative` IS NOT NULL AND di.`narrative` !=""';
		}else if(!empty($options) && $options =='4'){
			$wherCond = ' AND ccd.`division_number_group_id` ="0"';
		}

	 	$query=	"
		SELECT di.`id`, di.`draw_id`,cc.`cost_code`,cc.`cost_code_description`,
		gcbli.`prime_contract_scheduled_value`,di.`gc_budget_line_item_id`,
		ccd.`division_number`, gcbli.`cost_code_id`,
		di.`current_app`,di.`current_retainer_value`,di.`completed_percent`,di.`narrative`,
		drr.`retainer_rate`,di.`scheduled_value`,cc.`cost_code_division_id`,ccd.`division_number_group_id`
		FROM `draw_items` di
		LEFT JOIN `gc_budget_line_items` gcbli ON gcbli.`id`=di.`gc_budget_line_item_id`
		LEFT JOIN `cost_codes` cc ON cc.`id`= di.`cost_code_id`
		LEFT JOIN `cost_code_divisions` ccd ON ccd.`id`= cc.`cost_code_division_id`
		LEFT JOIN `draw_retainer_rate` drr ON drr.`draw_item_id`=di.`id`
		WHERE di.`draw_id`=? AND di.`cor_type` = ? AND di.`gc_budget_line_item_id`=? And di.`cost_code_id` =? And di.`gc_budget_line_item_id` IS NOT NULL ".$wherCond." ORDER BY  `ccd`.`division_number` ASC ,`cc`.`cost_code` ASC ,di.`gc_budget_line_item_id`
		";
		$arrValues = array($drawId,$corType,$gcBudgetLineItemId,$costCodeId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		return $row;
	}
	/**
	* get change order items for grid
	*/
	public static function getChangeOrderDrawItems($database, $drawId, $options = '', $cor_type = ''){
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);

		$wherCond = '';
		if(!empty($options) && ($options =='1' || $options =='3' )){
			$wherCond = ' AND di.`narrative` IS NOT NULL AND di.`narrative` !=""';
		}

		$cor_type_val = 'B';
		if (!empty($cor_type) && $cor_type == '1') {
			$cor_type_val = 'B';
		}else if(!empty($cor_type) && $cor_type == '2'){
			$cor_type_val = 'A';
		}

		$query=	"
		SELECT di.`id`, di.`draw_id`,co.`co_type_prefix`,co.`co_title`,co.`co_total`,di.`change_order_id`,
		di.`current_app`,di.`current_retainer_value`,di.`completed_percent`,di.`narrative`,di.`realocation`,
		drr.`retainer_rate`,di.`scheduled_value`
		FROM `draw_items` di
		LEFT JOIN `change_orders` co ON co.`id`=di.`change_order_id`
		LEFT JOIN `draw_retainer_rate` drr ON drr.`draw_item_id`=di.`id`
		WHERE di.`draw_id`=? AND di.`cor_type`=? AND di.`change_order_id` IS NOT NULL ".$wherCond."
		GROUP BY di.`id`  ORDER BY `co`.`co_type_prefix` ASC 
		";
		$arrValues = array($drawId,$cor_type_val);
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
	* get change order items for grid
	*/
	public static function getSingleChangeOrderDrawItems($database,$drawId,$changeorderId, $options = ''){
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);

		$wherCond = '';
		if(!empty($options) && ($options =='1' || $options =='3' )){
			$wherCond = ' AND di.`narrative` IS NOT NULL AND di.`narrative` !=""';
		}

		$query=	"
		SELECT di.`id`, di.`draw_id`,co.`co_type_prefix`,co.`co_title`,co.`co_total`,di.`change_order_id`,
		di.`current_app`,di.`current_retainer_value`,di.`completed_percent`,di.`narrative`,
		drr.`retainer_rate`,di.`scheduled_value`
		FROM `draw_items` di
		LEFT JOIN `change_orders` co ON co.`id`=di.`change_order_id`
		LEFT JOIN `draw_retainer_rate` drr ON drr.`draw_item_id`=di.`id`
		WHERE di.`draw_id`=? AND di.`change_order_id` = ? AND di.`change_order_id` IS NOT NULL ".$wherCond."
		GROUP BY di.`id`  ORDER BY `co`.`co_type_prefix` ASC 
		";
		$arrValues = array($drawId,$changeorderId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();		
		$db->free_result();
		return $row;
	}
	/**
	* get draw application number
	*/
	public static function getDrawApplicationNumber($database,$drawId){
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		$row = Draws::findById($database, $drawId);
		return $row['application_number'];
	}

	/**
	* update retainer rate and current retainer values for upcoming draws
	*/
	public static function updateNextDrawsRetainerValue($database,$drawItemId,$type,$projectId, $lineItemId,$drawRetainerRate){
		$drawItemId = (int) $drawItemId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$selectedDrawItem = self::findById($database, $drawItemId);

		if($type == 'gc_budget_line_item_id'){
			$lineItemId = $selectedDrawItem['gc_budget_line_item_id'];
			$updateColumn = " drr.`gc_budget_line_item_id`=?";
		}else{
			$lineItemId = $selectedDrawItem['change_order_id'];
			$updateColumn = " drr.`change_order_id`=?";
		}
		$query="
		SELECT di.`id`,drr.`retainer_rate`,di.`current_app`,drr.`id` draw_retainer_id
		FROM `draw_retainer_rate` drr
		LEFT JOIN `draw_items` di ON di.id=drr.draw_item_id
		WHERE drr.`project_id` = ? AND drr.`draw_item_id` >= ? AND $updateColumn";
		$arrValues = array($projectId,$drawItemId,$lineItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$upcomingDraws = array();

		while($row = $db->fetch())
		{
			$upcomingDraws[] = $row;
		}
		$db->free_result();
		foreach ($upcomingDraws as $key => $value) {
			//update draw_retainer_rate and retainer_flag to 'N'
			$retainerFlag = 'N';
			$updateRetainerRateQuery = "
			UPDATE `draw_retainer_rate` SET `retainer_rate`=?,`retainer_flag`=? WHERE `id`=?";
			$retainerRateValues = array($drawRetainerRate,$retainerFlag,$value['draw_retainer_id']);
			$db->execute($updateRetainerRateQuery, $retainerRateValues, MYSQLI_USE_RESULT);
			$db->free_result();

			//update current retainer value
			$currentAppValue = $value['current_app'];
			$currentRetainerValue  = self::calculateCurrentRetainerValue($currentAppValue, $drawRetainerRate);
			$updateCurrentRetainerQuery = "
			UPDATE `draw_items` SET `current_retainer_value`=? WHERE `id`=?";
			$currentRetainerValues = array($currentRetainerValue,$value['id']);
			$db->execute($updateCurrentRetainerQuery, $currentRetainerValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}
	}
	/**
	* update retainer rate based current retainer values for upcoming draws
	*/
	public static function updateNextDrawsCurrentRetention($database,$drawItemId,$type,$projectId, $lineItemId,$drawRetainerRate){
		$drawItemId = (int) $drawItemId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$selectedDrawItem = self::findById($database, $drawItemId);

		if($type == 'gc_budget_line_item_id'){
			$lineItemId = $selectedDrawItem['gc_budget_line_item_id'];
			$updateColumn = " drr.`gc_budget_line_item_id`=?";
		}else{
			$lineItemId = $selectedDrawItem['change_order_id'];
			$updateColumn = " drr.`change_order_id`=?";
		}
		$query="
		SELECT di.`id`,drr.`retainer_rate`,di.`current_app`,drr.`id` draw_retainer_id
		FROM `draw_retainer_rate` drr
		LEFT JOIN `draw_items` di ON di.id=drr.draw_item_id
		WHERE drr.`project_id` = ? AND drr.`draw_item_id` >= ? AND $updateColumn";
		$arrValues = array($projectId,$drawItemId,$lineItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$upcomingDraws = array();

		while($row = $db->fetch())
		{
			$upcomingDraws[] = $row;
		}
		$db->free_result();
		foreach ($upcomingDraws as $key => $value) {
			//update current retainer value
			$currentAppValue = $value['current_app'];
			$RetentionRateValue  = self::calculateRetentionRate($currentAppValue, $drawRetainerRate);
			$updateCurrentRetainerQuery = "
			UPDATE `draw_items` SET `current_retainer_value`=? WHERE `id`=?";
			$currentRetainerValues = array($drawRetainerRate,$value['id']);
			$db->execute($updateCurrentRetainerQuery, $currentRetainerValues, MYSQLI_USE_RESULT);
			$db->free_result();

			//update draw_retainer_rate and retainer_flag to 'N'
			$retainerFlag = 'N';
			$updateRetainerRateQuery = "
			UPDATE `draw_retainer_rate` SET `retainer_rate`=?,`retainer_flag`=? WHERE `id`=?";
			$retainerRateValues = array($RetentionRateValue,$retainerFlag,$value['draw_retainer_id']);
			$db->execute($updateRetainerRateQuery, $retainerRateValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}
	}
	/**
	* save or update scheduled value
	*/
	public static function saveOrUpdateScheduledValues($database,$projectId,$gcBudgetLineItemId,$scheduledValue){
		$gcBudgetLineItemId = (int) $gcBudgetLineItemId;
		$scheduledValue = (float) $scheduledValue;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);

		$query = "
		SELECT di.*,d.`id` drawId FROM `draw_items` di
		LEFT JOIN `draws` d ON d.id=di.draw_id
		WHERE d.project_id=? AND d.status=1 AND di.`gc_budget_line_item_id`=? AND d.`is_deleted_flag`='N'
		";
		$arrValues = array($projectId,$gcBudgetLineItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$records = array();
		while($row = $db->fetch())
		{
			$records[] = $row;
		}
		$db->free_result();
		if(count($records) > 0){
			self::updateScheduledValues($database,$projectId,$gcBudgetLineItemId,$scheduledValue,$records);
		}
		else{
			self::saveScheduledValues($database,$projectId,$gcBudgetLineItemId,$scheduledValue);
		}
	}
	/**
	* update budget scheduled value
	*/
	public static function updateScheduledValues($database,$projectId,$gcBudgetLineItemId,$scheduledValue,$records){
		$gcBudgetLineItemId = (int) $gcBudgetLineItemId;
		$scheduledValue = (float) $scheduledValue;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		foreach ($records as $key => $value) {
			$drawItemId = $value['id'];
			$lineItemId = $gcBudgetLineItemId;
			$drawId = $value['drawId'];
			$currentApp = $value['current_app'];
			$updateBudgetItem = self::findById($database,$drawItemId);
			if($scheduledValue != 0){
				$applicationNumber = self::getDrawApplicationNumber($database,$drawId);
				$corType = self::getLastCorType($database,$projectId,$applicationNumber);
				$previousDrawValues = self::getPreviousDrawValue($database, $projectId, $lineItemId ,'gc_budget_line_item_id',$drawItemId,$applicationNumber,$corType);
				$completionPercentage = self::calculateCompletionPercentage($currentApp,$scheduledValue,$previousDrawValues);
				$updateBudgetItem->convertPropertiesToData();
				$updateBudgetData = $updateBudgetItem->getData();
				$updateBudgetData['completed_percent'] = $completionPercentage;
				$updateBudgetData['scheduled_value'] = $scheduledValue;
				$updateBudgetItem->setData($updateBudgetData);
				$updateBudgetItem->save();
			}else{
				self::deleteGcBudgetLineItem($database,$projectId,$gcBudgetLineItemId);
			}
		}
	}
	/**
	* save budget scheduled value
	*/
	public static function saveScheduledValues($database,$projectId,$gcBudgetLineItemId,$scheduledValue){
		$gcBudgetLineItemId = (int) $gcBudgetLineItemId;
		$scheduledValue = (float) $scheduledValue;
		$projectId = (int) $projectId;
		$applicationNumber = Draws::findLastApplicationNumber($database,$projectId);
		$applicationNumber['max_application_number'];
		$last_cor_type = self::getLastCorType($database,$projectId,$applicationNumber['max_application_number']);
		$db = DBI::getInstance($database);

		$query =  "
		SELECT gcbli.*,d.id drawId FROM `draws` d
		LEFT JOIN `gc_budget_line_items` gcbli ON gcbli.project_id=d.project_id
		WHERE d.`project_id` = ? AND d.`status` = 1 AND gcbli.id=?
		";
		$arrValues = array($projectId,$gcBudgetLineItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$newCostCodes = array();
		while($row = $db->fetch())
		{
			$newCostCodes[] = $row;
		}
		$db->free_result();
		foreach ($newCostCodes as $key => $value) {
			$drawId = $value['drawId'];
			$costCodeId = $value['cost_code_id'];

			$costCodeItem = new DrawItems($database);
			$costCodeItem->convertPropertiesToData();
			$costCodeData = $costCodeItem->getData();
			$costCodeData['draw_id'] = $drawId;
			$costCodeData['cost_code_id'] = $costCodeId;
			$costCodeData['gc_budget_line_item_id'] = $gcBudgetLineItemId;
			$costCodeData['scheduled_value'] = $scheduledValue;
			$costCodeData['cor_type'] = $last_cor_type;
			$costCodeData['type'] = 'Y';
			$costCodeItem->setData($costCodeData);
			$drawItemId = $costCodeItem->save();
			self::saveBudgetRetainerRate($database,$projectId,$gcBudgetLineItemId,$drawItemId,$costCodeId,$last_cor_type);

			if ($applicationNumber['max_application_number'] == 1) {
				$costCodeItem = new DrawItems($database);
				$costCodeItem->convertPropertiesToData();
				$costCodeData = $costCodeItem->getData();
				$costCodeData['draw_id'] = $drawId;
				$costCodeData['cost_code_id'] = $costCodeId;
				$costCodeData['gc_budget_line_item_id'] = $gcBudgetLineItemId;
				$costCodeData['scheduled_value'] = $scheduledValue;
				$costCodeData['cor_type'] = 'A';
				$costCodeData['type'] = 'Y';
				$costCodeItem->setData($costCodeData);
				$drawItemId = $costCodeItem->save();
				self::saveBudgetRetainerRateAboveTheLine($database,$projectId,$gcBudgetLineItemId,$drawItemId,$costCodeId);
			}
		}
	}
	/**
	* budget retainer rate
	*/
	public static function saveBudgetRetainerRate($database,$projectId,$gcBudgetLineItemId,$drawItemId,$costCodeId,$last_cor_type){
		$gcBudgetLineItemId = (int) $gcBudgetLineItemId;
		$drawItemId = (int) $drawItemId;
		$projectId = (int) $projectId;
		$costCodeId = (int) $costCodeId;
		$db = DBI::getInstance($database);
		$retainerRate = DrawRetainerRate::getBudgetRetainerRate($database,$projectId,$gcBudgetLineItemId);
		//flag 'Y' project retainer rate, 'N' cost code retainer rate
		if(empty($retainerRate['retainer_flag']) || ($retainerRate['retainer_flag'] == 'Y')){
			$drawRetainerRate = $retainerRate['project_retainer_rate'];
			$retainerFlag = 'Y';
		}else{
			$drawRetainerRate = $retainerRate['draw_retainer_rate'];
			$retainerFlag = 'N';
		}

		$retainerItem = new DrawRetainerRate($database);
		$retainerItem->convertPropertiesToData();
		$retainerData = $retainerItem->getData();
		$retainerData['draw_item_id'] = $drawItemId;
		$retainerData['cost_code_id'] = $costCodeId;
		$retainerData['project_id'] = $projectId;
		$retainerData['gc_budget_line_item_id'] = $gcBudgetLineItemId;
		$retainerData['retainer_rate'] = $drawRetainerRate;
		$retainerData['retainer_flag'] = $retainerFlag;
		$retainerData['cor_type'] = $last_cor_type;
		$retainerItem->setData($retainerData);
		$retainerItem->save();

	}

	public static function saveBudgetRetainerRateAboveTheLine($database,$projectId,$gcBudgetLineItemId,$drawItemId,$costCodeId){
		$gcBudgetLineItemId = (int) $gcBudgetLineItemId;
		$drawItemId = (int) $drawItemId;
		$projectId = (int) $projectId;
		$costCodeId = (int) $costCodeId;
		$db = DBI::getInstance($database);
		$retainerRate = DrawRetainerRate::getBudgetRetainerRate($database,$projectId,$gcBudgetLineItemId);
		//flag 'Y' project retainer rate, 'N' cost code retainer rate
		if(empty($retainerRate['retainer_flag']) || ($retainerRate['retainer_flag'] == 'Y')){
			$drawRetainerRate = $retainerRate['project_retainer_rate'];
			$retainerFlag = 'Y';
		}else{
			$drawRetainerRate = $retainerRate['draw_retainer_rate'];
			$retainerFlag = 'N';
		}

		$retainerItem = new DrawRetainerRate($database);
		$retainerItem->convertPropertiesToData();
		$retainerData = $retainerItem->getData();
		$retainerData['draw_item_id'] = $drawItemId;
		$retainerData['cost_code_id'] = $costCodeId;
		$retainerData['project_id'] = $projectId;
		$retainerData['gc_budget_line_item_id'] = $gcBudgetLineItemId;
		$retainerData['retainer_rate'] = $drawRetainerRate;
		$retainerData['retainer_flag'] = $retainerFlag;
		$retainerData['cor_type'] = 'A';
		$retainerItem->setData($retainerData);
		$retainerItem->save();
	}

	/**
	* update CO retainer rate
	*/
	public static function saveCORetainerRate($database,$projectId,$changeOrderId,$drawItemId,$last_cor_type){
		$drawItemId = (int) $drawItemId;
		$projectId = (int) $projectId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$retainerRate = DrawRetainerRate::getCORetainerRate($database,$projectId,$changeOrderId);
		//flag 'Y' project retainer rate, 'N' cost code retainer rate
		if(empty($retainerRate['retainer_flag']) || ($retainerRate['retainer_flag'] == 'Y')){
			$drawRetainerRate = $retainerRate['project_retainer_rate'];
			$retainerFlag = 'Y';
		}else{
			$drawRetainerRate = $retainerRate['draw_retainer_rate'];
			$retainerFlag = 'N';
		}


		$retainerItem = new DrawRetainerRate($database);
		$retainerItem->convertPropertiesToData();
		$retainerData = $retainerItem->getData();
		$retainerData['draw_item_id'] = $drawItemId;
		$retainerData['project_id'] = $projectId;
		$retainerData['change_order_id'] = $changeOrderId;
		$retainerData['retainer_rate'] = $drawRetainerRate;
		$retainerData['retainer_flag'] = $retainerFlag;
		$retainerData['cor_type'] = $last_cor_type;
		$retainerItem->setData($retainerData);
		$retainerItem->save();
	}

	public static function saveCORetainerRateAboveTheLine($database,$projectId,$changeOrderId,$drawItemId){
		$drawItemId = (int) $drawItemId;
		$projectId = (int) $projectId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$retainerRate = DrawRetainerRate::getCORetainerRate($database,$projectId,$changeOrderId);
		//flag 'Y' project retainer rate, 'N' cost code retainer rate
		if(empty($retainerRate['retainer_flag']) || ($retainerRate['retainer_flag'] == 'Y')){
			$drawRetainerRate = $retainerRate['project_retainer_rate'];
			$retainerFlag = 'Y';
		}else{
			$drawRetainerRate = $retainerRate['draw_retainer_rate'];
			$retainerFlag = 'N';
		}


		$retainerItem = new DrawRetainerRate($database);
		$retainerItem->convertPropertiesToData();
		$retainerData = $retainerItem->getData();
		$retainerData['draw_item_id'] = $drawItemId;
		$retainerData['project_id'] = $projectId;
		$retainerData['change_order_id'] = $changeOrderId;
		$retainerData['retainer_rate'] = $drawRetainerRate;
		$retainerData['retainer_flag'] = $retainerFlag;
		$retainerData['cor_type'] = 'A';
		$retainerItem->setData($retainerData);
		$retainerItem->save();
	}

	/**
	* delete budget scheduled value
	*/
	public static function deleteGcBudgetLineItem($database,$projectId,$gcBudgetLineItemId){
		$gcBudgetLineItemId = (int) $gcBudgetLineItemId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);

		$query = "
		SELECT di.`id` FROM `draw_items` di
		LEFT JOIN `draws` d ON d.id=di.draw_id
		WHERE d.project_id=? AND d.status=1 AND di.`gc_budget_line_item_id`=?
		";
		$arrValues = array($projectId,$gcBudgetLineItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$drawItemIds = array();
		while($row = $db->fetch())
		{
			$drawItemIds[] = $row['id'];
		}
		$db->free_result();

		$deleteIds = implode(", ",$drawItemIds);
		$deleteQuery = "
		DELETE FROM `draw_items` WHERE `id` IN ($deleteIds)
		";
		$db->execute($deleteQuery);
		$db->free_result();
	}


	/**
	*  update change order
	*/
	public static function updateChangeOrder($database,$projectId,$changeOrderId){
		$changeOrderId = (int) $changeOrderId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);

		$query = "
		SELECT di.*,co.`co_total`,d.id AS drawId FROM draws d
		LEFT JOIN `draw_items` di ON di.draw_id=d.id
		LEFT JOIN `change_orders` co ON co.id=di.change_order_id
		WHERE d.project_id=? AND d.status=1 AND di.change_order_id =?
		AND co.`change_order_status_id`=2 AND co.`change_order_type_id`=2 AND d.`is_deleted_flag`='N'
		";
		$arrValues = array($projectId,$changeOrderId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$records = array();
		while($row = $db->fetch())
		{
			$records[] = $row;
		}

		$db->free_result();
		$drawIdsArr = self::updateChangeOrderScheduledValue($database,$projectId,$changeOrderId,$records);
		return $drawIdsArr;
	}
	/**
	*  update change order scheduled value
	*/
	public static function updateChangeOrderScheduledValue($database,$projectId,$changeOrderId,$changeOrderRequests){
		$changeOrderId = (int) $changeOrderId;
		$projectId = (int) $projectId;
		$db = DBI::getInstance($database);
		$drawIdsArr = array();
		foreach ($changeOrderRequests as $orderKey => $orderValue) {
			$currentApp = $orderValue['current_app'];
			$drawItemId = $orderValue['id'];
			$scheduledValue = $orderValue['co_total'];
			$drawId = $orderValue['drawId'];
			$drawIdsArr[] = $drawId;
			$applicationNumber = self::getDrawApplicationNumber($database,$drawId);
			$corType = self::getLastCorType($database,$projectId,$applicationNumber);
			$previousDrawValues = self::getPreviousDrawValue($database, $projectId, $changeOrderId ,'change_order_id',$drawItemId,$applicationNumber,$corType);
			$completionPercentage = self::calculateCompletionPercentage($currentApp,$scheduledValue,$previousDrawValues);
			$updateCOItem = self::findById($database,$drawItemId);
			$updateCOItem->convertPropertiesToData();
			$updateCOData = $updateCOItem->getData();
			$updateCOData['completed_percent'] = $completionPercentage;
			$updateCOData['scheduled_value'] = $scheduledValue;
			$updateCOItem->setData($updateCOData);
			$updateCOItem->save();
		}
		return $drawIdsArr;
	}

	/**
	*  save change order
	*/
	public static function saveChangeOrder($database,$projectId,$changeOrderId,$drawIds){
		$changeOrderId = (int) $changeOrderId;
		$projectId = (int) $projectId;
		$applicationNumber = Draws::findLastApplicationNumber($database,$projectId);
		$last_cor_type = self::getLastCorType($database,$projectId,$applicationNumber['max_application_number']);
		$db = DBI::getInstance($database);
		if(count($drawIds) > 0){
			$drawIds = implode(', ',$drawIds);
			$subQuery = "AND d.`id` NOT IN ($drawIds)";
		}else{
			$subQuery = '';
		}
		$query = "
		SELECT d.id AS drawId,co.* FROM `change_orders` co
		LEFT JOIN draws d ON d.project_id=co.`project_id`
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
			$drawId = $orderValue['drawId'];

			$changeOrderItem = new DrawItems($database);
			$changeOrderItem->convertPropertiesToData();
			$changeOrderData = $changeOrderItem->getData();
			$changeOrderData['draw_id'] = $drawId;
			$changeOrderData['change_order_id'] = $changeOrderId;
			$changeOrderData['scheduled_value'] = $scheduledValue;
			$changeOrderData['type'] = 'N';
			$changeOrderData['cor_type'] = $last_cor_type;
			$changeOrderItem->setData($changeOrderData);
			$drawItemId = $changeOrderItem->save();
			self::saveCORetainerRate($database,$projectId,$changeOrderId,$drawItemId,$last_cor_type);
			if ($applicationNumber['max_application_number'] == 1) {
				$changeOrderItem = new DrawItems($database);
				$changeOrderItem->convertPropertiesToData();
				$changeOrderData = $changeOrderItem->getData();
				$changeOrderData['draw_id'] = $drawId;
				$changeOrderData['change_order_id'] = $changeOrderId;
				$changeOrderData['scheduled_value'] = $scheduledValue;
				$changeOrderData['type'] = 'N';
				$changeOrderData['cor_type'] = 'A';
				$changeOrderItem->setData($changeOrderData);
				$drawItemId = $changeOrderItem->save();
				self::saveCORetainerRateAboveTheLine($database,$projectId,$changeOrderId,$drawItemId);
			}
			
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
		SELECT di.id FROM `draw_items` di
		LEFT JOIN draws d ON di.draw_id=d.id
		LEFT JOIN change_orders co ON co.id=di.change_order_id
		WHERE co.project_id=?
		AND di.change_order_id =?
		AND (co.`change_order_status_id`!=2
		OR co.`change_order_type_id`!=2 OR co.co_total=0) AND d.status=1
		GROUP BY di.id
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
		DELETE FROM `draw_items` WHERE `id` IN ($deleteIds)
		";
		$db->execute($deleteQuery);
		$db->free_result();
	}
	/**
	* get previous draw values by draw_id
	*/
	public static function getPreviousDrawValueByDrawId($database, $projectId, $drawItemId,$applicationNumber = 0){
		$projectId = (int) $projectId;
		$drawItemId =(int) $drawItemId;
		$applicationNumber = (int) $applicationNumber;
		$db = DBI::getInstance($database);
		// $query = "
		// SELECT di.*
		// FROM  `draw_items` di WHERE
		// di.`draw_id`= (SELECT dis.id FROM draws AS dis WHERE dis.`id` != $drawItemId AND dis.`project_id` = $projectId ORDER BY dis.`id` DESC LIMIT 1 )
		// -- WHERE draw.project_id=? $subQuery $applicationQuery
		// ";
		// $query = "
		// SELECT dis.* FROM draws AS dis WHERE dis.`id` != $drawItemId AND dis.`status` = 2 AND dis.`project_id` = $projectId ORDER BY dis.`id` DESC LIMIT 1
		// ";
		if($applicationNumber){
			$applicationQuery = " AND dis.`application_number` < $applicationNumber";
			
		}else{
			$applicationQuery = '';
		}
		$query = "
		SELECT dis.* FROM draws AS dis WHERE dis.`id` != $drawItemId AND dis.`status` >= 2 AND dis.`project_id` = $projectId AND dis.`is_deleted_flag` = 'N' $applicationQuery ORDER BY dis.`id` DESC LIMIT 1
		";
		$db->query($query, MYSQLI_USE_RESULT);
		$arrayValues = array();
		$totalScheduleValue = 0;
		$totalCurrentApp = 0;
		$totalCompletedApp = 0;
		$totalCurrentRetainer = 0;
		$totalScheduleValue = 0;

		while($row = $db->fetch()) {
			$arrayValues['draw_id'] = $row['id'];
			$arrayValues['project_id'] = $row['project_id'];
			$arrayValues['application_id'] = $row['application_number'];
			// $draw_id = $row['id'];
			// $totalScheduleValue += $row['scheduled_value'];
			// $totalCurrentApp += $row['current_app'];
			// $totalCompletedApp += $row['completed_percent'];
			// $totalCurrentRetainer += $row['current_retainer_value'];
			// $totalCurrentRetainer += $row['current_retainer_value'];


			// $arrayValues['totalScheduleValue'] = $row;
		}
		// $arrayValues['totalScheduleValue'] = $totalScheduleValue;
		// $arrayValues['totalCurrentApp'] = $totalCurrentApp;
		// $arrayValues['totalCompletedApp'] = $totalCompletedApp;
		// $arrayValues['totalCurrentRetainer'] = $totalCurrentRetainer;
		$db->free_result();
		return $arrayValues;
	}
	/**
	* get budget line items for grid
	*/
	public static function getDrawItemsWithOutChangeOrderGeneral($database,$drawId,$options=''){
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		$wherCond = '';
		if(!empty($options) && ($options =='1' || $options =='3')){
			$wherCond = ' AND di.`narrative` IS NOT NULL AND di.`narrative` !=""';
		} else if(!empty($options) && $options =='4'){
			$wherCond = ' AND ccd.`division_number_group_id` ="0"';
		}

		$query=	"
		SELECT di.`id`, di.`draw_id`,cc.`cost_code`,cc.`cost_code_description`,
		di.`scheduled_value` as prime_contract_scheduled_value, di.`gc_budget_line_item_id`,
		ccd.`division_number`, gcbli.`cost_code_id`,
		di.`current_app`,di.`current_retainer_value`,di.`completed_percent`,di.`narrative`,
		drr.`retainer_rate`,ccd.`division_number_group_id`,ccd.`division`,ccd.`division_code_heading`
		FROM `draw_items` di
		LEFT JOIN `gc_budget_line_items` gcbli ON gcbli.`id`=di.`gc_budget_line_item_id`
		LEFT JOIN `cost_codes` cc ON cc.`id`= gcbli.`cost_code_id`
		LEFT JOIN `cost_code_divisions` ccd ON ccd.`id`= cc.`cost_code_division_id`
		LEFT JOIN `draw_retainer_rate` drr ON drr.`draw_item_id`=di.`id`
		WHERE di.`draw_id`=? AND di.`gc_budget_line_item_id` IS NOT NULL AND ccd.`division_number_group_id` ='1' ".$wherCond."  ORDER BY ccd.`division_number` ASC, `cc`.`cost_code` ASC LIMIT 1
		";
		$arrValues = array($drawId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$records = array();
		$row = $db->fetch();
		
		$db->free_result();
		return $row;
	}
	public static function getDrawItemsWithOutChangeOrder($database,$drawId,$options=''){
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		$wherCond = '';
		if(!empty($options) && ($options =='1' || $options =='3')){
			$wherCond = ' AND di.`narrative` IS NOT NULL AND di.`narrative` !=""';
		} else if(!empty($options) && $options =='4'){
			$wherCond = ' AND ccd.`division_number_group_id` ="0"';
		}

		$query=	"
		SELECT di.`id`, di.`draw_id`,cc.`cost_code`,cc.`cost_code_description`,
		di.`scheduled_value` as prime_contract_scheduled_value, di.`gc_budget_line_item_id`,
		ccd.`division_number`, gcbli.`cost_code_id`,
		di.`current_app`,di.`current_retainer_value`,di.`completed_percent`,di.`narrative`,
		drr.`retainer_rate`,ccd.`division_number_group_id`,ccd.`division`
		FROM `draw_items` di
		LEFT JOIN `gc_budget_line_items` gcbli ON gcbli.`id`=di.`gc_budget_line_item_id`
		LEFT JOIN `cost_codes` cc ON cc.`id`= gcbli.`cost_code_id`
		LEFT JOIN `cost_code_divisions` ccd ON ccd.`id`= cc.`cost_code_division_id`
		LEFT JOIN `draw_retainer_rate` drr ON drr.`draw_item_id`=di.`id`
		WHERE di.`draw_id`=? AND di.`gc_budget_line_item_id` IS NOT NULL ".$wherCond."  ORDER BY ccd.`division_number` ASC, `cc`.`cost_code` ASC
		";
		$arrValues = array($drawId);
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
	* get change order items for grid
	*/
	public static function getDrawItemsOnlyChangeOrder($database,$drawId,$options="",$cor_type){
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		$wherCond = '';
		if(!empty($options) && ($options =='1' || $options =='3')){
			$wherCond = ' AND di.`narrative` IS NOT NULL  AND di.`narrative` !=""';
		}

		$query=	"
		SELECT di.`id`, di.`draw_id`,co.`co_type_prefix`,co.`co_title`,di.`scheduled_value` as co_total,di.`change_order_id`,
		di.`current_app`,di.`current_retainer_value`,di.`completed_percent`,di.`narrative`,
		drr.`retainer_rate`
		FROM `draw_items` di
		LEFT JOIN `change_orders` co ON co.`id`=di.`change_order_id`
		LEFT JOIN `draw_retainer_rate` drr ON drr.`draw_item_id`=di.`id`
		WHERE di.`draw_id`=? AND di.`cor_type` = ? AND di.`change_order_id` IS NOT NULL ".$wherCond." GROUP BY di.`id` ORDER BY `co`.`co_type_prefix` ASC
		";
		$arrValues = array($drawId,$cor_type);
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
	* get draws items
	*/
	public static function getDrawItemsByDrawId($database, $drawId, $cor_type = ''){
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);

		$whereCon = '';
		$arrValues = array($drawId);
		if (!empty($cor_type)) {
			$whereCon = ' AND di.`cor_type` = ? ';
			$arrValues = array($drawId,$cor_type);
		}

		$query=	"
		SELECT di.*
		FROM `draw_items` di
		WHERE di.`draw_id`=? $whereCon
		";
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
	* To get the draws items by costcode id and budget id
	*/
	public static function getDrawItemIdbyCostcodeandbudgetId($database, $drawId,$costCodeId,$gcBudgetLineItemId,$column=''){
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);

		$query=	"
		SELECT di.*
		FROM `draw_items` di
		WHERE di.`draw_id`=? AND `cost_code_id` = ? AND `gc_budget_line_item_id` = ?
		";
		$arrValues = array($drawId,$costCodeId,$gcBudgetLineItemId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		if($column)
		{
			$resvalue = $row[$column];
		}else
		{
			$resvalue = $row['id'];
		}
		
		$db->free_result();
		return $resvalue;
	}
	/**
	* To get the draws items by Change order id 
	*/
	public static function getDrawItemIdbyChangeorderId($database, $drawId,$changeorderId,$column=''){
		$drawId = (int) $drawId;
		$changeorderId = (int) $changeorderId;
		$db = DBI::getInstance($database);

		$query=	"
		SELECT di.*
		FROM `draw_items` di
		WHERE di.`draw_id`= ? AND `change_order_id` =  ? ";
		$arrValues = array($drawId,$changeorderId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		if($column)
		{
			$resvalue = $row[$column];
		}else
		{
			$resvalue = $row['id'];
		}
		
		$db->free_result();
		return $resvalue;
	}

	public static function saveBudgetItems($database, $projectId, $drawId, $drawbudgetItems, $last_cor_type){
		$projectId = (int) $projectId;
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		foreach ($drawbudgetItems as $budgetKey => $budgetValue) {
			$costCodeId = $budgetValue['cost_code_id'];
			$gcBudgetLineItemId = $budgetValue['id'];
			$scheduledValue = $budgetValue['prime_contract_scheduled_value'];

			$budgetLineItem = new DrawItems($database);
			$budgetLineItem->convertPropertiesToData();
			$budgetData = $budgetLineItem->getData();
			$budgetData['draw_id'] = $drawId;
			$budgetData['cost_code_id'] = $costCodeId;
			$budgetData['gc_budget_line_item_id'] = $gcBudgetLineItemId;
			// To add the reallocation amount
			if ($last_cor_type == 'A') {
				$ReallocationValue = ChangeOrder::ReallocationInDrawsAndCOByCostCode($database,$costCodeId,$projectId);
				$scheduledValue = $scheduledValue+$ReallocationValue;
			}else{
				$ReallocationValue = DrawItems::costcodeReallocated($database,$costCodeId,$projectId);
				$scheduledValue = $scheduledValue+$ReallocationValue['total'];
			}
			$budgetData['scheduled_value'] = $scheduledValue;
			$budgetData['type'] = 'Y';
			$budgetData['cor_type'] = $last_cor_type;
			$budgetLineItem->setData($budgetData);
			$drawItemId = $budgetLineItem->save();

			self::saveBudgetRetainerRate($database,$projectId,$gcBudgetLineItemId,$drawItemId,$costCodeId,$last_cor_type);
		}
	}

	public static function saveBudgetItemAboveTheLine($database, $projectId, $drawId, $drawbudgetItems){
		$projectId = (int) $projectId;
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		foreach ($drawbudgetItems as $budgetKey => $budgetValue) {
			$costCodeId = $budgetValue['cost_code_id'];
			$gcBudgetLineItemId = $budgetValue['id'];
			$scheduledValue = $budgetValue['prime_contract_scheduled_value'];

			$budgetLineItem = new DrawItems($database);
			$budgetLineItem->convertPropertiesToData();
			$budgetData = $budgetLineItem->getData();
			$budgetData['draw_id'] = $drawId;
			$budgetData['cost_code_id'] = $costCodeId;
			$budgetData['gc_budget_line_item_id'] = $gcBudgetLineItemId;
			// To add the reallocation amount
			$ReallocationValue = ChangeOrder::ReallocationInDrawsAndCOByCostCode($database,$costCodeId,$projectId);
			$scheduledValue = $scheduledValue+$ReallocationValue;
			$budgetData['scheduled_value'] = $scheduledValue;
			$budgetData['type'] = 'Y';
			$budgetData['cor_type'] = 'A';
			$budgetLineItem->setData($budgetData);
			$drawItemId = $budgetLineItem->save();

			self::saveBudgetRetainerRateAboveTheLine($database,$projectId,$gcBudgetLineItemId,$drawItemId,$costCodeId);
		}
	} 

	public static function saveChangeOrderApprovedItems($database, $projectId, $drawId, $drawChangeOrderItems,$last_cor_type){
		$projectId = (int) $projectId;
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		foreach ($drawChangeOrderItems as $orderKey => $orderValue) {
			$changeOrderId = $orderValue['id'];
			$scheduledValue = $orderValue['co_total'];

			$changeOrderItem = new DrawItems($database);
			$changeOrderItem->convertPropertiesToData();
			$changeOrderData = $changeOrderItem->getData();
			$changeOrderData['draw_id'] = $drawId;
			$changeOrderData['change_order_id'] = $changeOrderId;
			$changeOrderData['scheduled_value'] = $scheduledValue;
			$changeOrderData['type'] = 'N';
			$changeOrderData['cor_type'] = $last_cor_type;
			$changeOrderItem->setData($changeOrderData);
			$drawItemId = $changeOrderItem->save();

			self::saveCORetainerRate($database,$projectId,$changeOrderId,$drawItemId,$last_cor_type);
		}
	}

	public static function saveChangeOrderApprovedItemAboveTheLine($database, $projectId, $drawId, $drawChangeOrderItems){
		$projectId = (int) $projectId;
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		foreach ($drawChangeOrderItems as $orderKey => $orderValue) {
			$changeOrderId = $orderValue['id'];
			$scheduledValue = $orderValue['co_total'];

			$changeOrderItem = new DrawItems($database);
			$changeOrderItem->convertPropertiesToData();
			$changeOrderData = $changeOrderItem->getData();
			$changeOrderData['draw_id'] = $drawId;
			$changeOrderData['change_order_id'] = $changeOrderId;
			$changeOrderData['scheduled_value'] = $scheduledValue;
			$changeOrderData['type'] = 'N';
			$changeOrderData['cor_type'] = 'A';
			$changeOrderItem->setData($changeOrderData);
			$drawItemId = $changeOrderItem->save();

			self::saveCORetainerRateAboveTheLine($database,$projectId,$changeOrderId,$drawItemId);
		}
	}

	public static function addGcBudgetLineItems($database, $projectId, $drawId){
		$projectId = (int) $projectId;
		$drawId = (int) $drawId;
		$applicationNumber = self::getDrawApplicationNumber($database,$drawId);
		$last_cor_type = self::getLastCorType($database,$projectId,$applicationNumber);
		$db = DBI::getInstance($database);
		$query=	"
		SELECT * FROM `gc_budget_line_items` gcbli WHERE gcbli.project_id=? AND gcbli.`prime_contract_scheduled_value`!=0
		AND gcbli.id NOT IN
		(SELECT di.`gc_budget_line_item_id` FROM `draws` d
		LEFT JOIN `draw_items` di ON di.`draw_id`=d.`id`
		WHERE d.`project_id`=? AND  di.`draw_id`=? AND di.`gc_budget_line_item_id` IS NOT NULL)
		";
		$arrValues = array($projectId,$projectId,$drawId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$drawbudgetItems = array();
		while($row = $db->fetch())
		{
			$drawbudgetItems[] = $row;
		}
		$db->free_result();
		if ($applicationNumber == 1) {
			self::saveBudgetItemAboveTheLine($database, $projectId, $drawId, $drawbudgetItems);
		}
		self::saveBudgetItems($database, $projectId, $drawId, $drawbudgetItems, $last_cor_type);
	}

	public static function deleteBudgetLineItem($database, $projectId, $drawId){
		$projectId = (int) $projectId;
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		$query=	"
		SELECT * FROM `draws` d LEFT JOIN  `draw_items` di ON di.`draw_id`=d.`id` WHERE d.`project_id`=? AND  di.`draw_id`=? AND
		di.`gc_budget_line_item_id` IS NOT NULL AND di.`gc_budget_line_item_id`
		NOT IN
		(SELECT gcbli.id FROM `gc_budget_line_items` gcbli
		WHERE gcbli.project_id=? AND gcbli.`prime_contract_scheduled_value`!=0)
		";
		$arrValues = array($projectId, $drawId ,$projectId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$drawbudgetItems = array();
		while($row = $db->fetch())
		{
			$drawbudgetItems[] = $row;
		}
		$db->free_result();

		foreach($drawbudgetItems as $drawItemId => $drawItem) {
			$drawItemId = $drawItem['id'];
			$drawItemGet = self::findById($database, $drawItemId);
			$drawItemGet->delete();
		}
	}

	public static function addChangeOrderLineItems($database, $projectId, $drawId){
		$projectId = (int) $projectId;
		$drawId = (int) $drawId;
		$applicationNumber = self::getDrawApplicationNumber($database,$drawId);
		$last_cor_type = self::getLastCorType($database,$projectId,$applicationNumber);
		$db = DBI::getInstance($database);
		$query=	"
		SELECT * FROM `change_orders` co WHERE co.project_id=? AND co.`co_total`!=0 AND co.`change_order_type_id`=2 AND co.`change_order_status_id`=2
		AND co.id NOT IN
		(SELECT di.`change_order_id` FROM `draws` d
		LEFT JOIN `draw_items` di ON di.`draw_id`=d.`id`
		WHERE d.`project_id`=? AND  di.`draw_id`=? AND
		di.`change_order_id` IS NOT NULL)
		";
		$arrValues = array($projectId,$projectId,$drawId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$drawChangeOrderItems = array();
		while($row = $db->fetch())
		{
			$drawChangeOrderItems[] = $row;
		}
		$db->free_result();
		self::saveChangeOrderApprovedItems($database, $projectId, $drawId, $drawChangeOrderItems,$last_cor_type);
	}

	public static function deleteChangeOrderLineItems($database, $projectId, $drawId){
		$projectId = (int) $projectId;
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		$query=	"
		SELECT di.* FROM `draws` d LEFT JOIN  `draw_items` di ON di.`draw_id`=d.`id` WHERE d.`project_id`=? AND  di.`draw_id`=? AND
		di.`change_order_id` IS NOT NULL AND di.`change_order_id` NOT IN
		(SELECT co.id FROM `change_orders` co WHERE co.project_id=? AND co.`change_order_type_id`=2 AND co.`change_order_status_id`=2)
		";
		$arrValues = array($projectId, $drawId ,$projectId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$drawChangeOrderItems = array();
		while($row = $db->fetch())
		{
			$drawChangeOrderItems[] = $row;
		}
		$db->free_result();

		foreach($drawChangeOrderItems as $drawItemId => $drawItem) {
			$drawItemId = $drawItem['id'];
			$drawItemGet = self::findById($database, $drawItemId);
			$drawItemGet->delete();
		}
	}

	public static function updateGcBudgetLineItems($database, $projectId, $drawId){
		$projectId = (int) $projectId;
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		$query=	"
		SELECT di.*,d.`id` drawId,gcbli.`prime_contract_scheduled_value` FROM `draw_items` di
		LEFT JOIN `draws` d ON d.id=di.draw_id
		LEFT JOIN `gc_budget_line_items` gcbli ON gcbli.`id`=di.`gc_budget_line_item_id`
		WHERE d.project_id=? AND di.draw_id=?
		AND di.`scheduled_value`!=gcbli.`prime_contract_scheduled_value` AND di.`gc_budget_line_item_id` IS NOT NULL
		";
		$arrValues = array($projectId,$drawId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$drawbudgetItems = array();
		while($row = $db->fetch())
		{
			$drawbudgetItems[] = $row;
		}
		$db->free_result();
		$applicationNumber = self::getDrawApplicationNumber($database,$drawId);
		foreach ($drawbudgetItems as $key => $value) {
			$drawItemId = $value['id'];
			$gcBudgetLineItemId = $value['gc_budget_line_item_id'];
			$scheduledValue = $value['prime_contract_scheduled_value'];
			$currentApp = $value['current_app'];
			$lineItemId = $gcBudgetLineItemId;
			if($scheduledValue > 0){
				$corType = self::getLastCorType($database,$projectId,$applicationNumber);
				$previousDrawValues = self::getPreviousDrawValue($database, $projectId, $lineItemId ,'gc_budget_line_item_id',$drawItemId,$applicationNumber,$corType);
				$completionPercentage = self::calculateCompletionPercentage($currentApp,$scheduledValue,$previousDrawValues);
				$updateBudgetItem = self::findById($database,$drawItemId);
				$updateBudgetItem->convertPropertiesToData();
				$updateBudgetData = $updateBudgetItem->getData();
				$updateBudgetData['completed_percent'] = $completionPercentage;
				$updateBudgetData['scheduled_value'] = $scheduledValue;
				$updateBudgetItem->setData($updateBudgetData);
				$updateBudgetItem->save();
			}else{
				$updateBudgetItem = self::findById($database,$drawItemId);
				$updateBudgetItem->delete();
			}
		}
	}
	
	public static function updateChangeOrderLineItems($database, $projectId, $drawId){
		$projectId = (int) $projectId;
		$drawId = (int) $drawId;
		$db = DBI::getInstance($database);
		$query=	"
		SELECT di.*,d.`id` drawId,co.`co_total` FROM `draw_items` di
		LEFT JOIN `draws` d ON d.id=di.draw_id LEFT JOIN `change_orders` co ON co.`id`=di.`change_order_id`
		WHERE d.project_id=? AND di.draw_id=? AND di.`scheduled_value`!=co.`co_total` AND di.`change_order_id` IS NOT NULL
		";
		$arrValues = array($projectId,$drawId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$drawChangeOrderItems = array();
		while($row = $db->fetch())
		{
			$drawChangeOrderItems[] = $row;
		}
		$db->free_result();
		$applicationNumber = self::getDrawApplicationNumber($database,$drawId);

		foreach ($drawChangeOrderItems as $key => $orderValue) {
			$currentApp = $orderValue['current_app'];
			$drawItemId = $orderValue['id'];
			$scheduledValue = $orderValue['co_total'];
			$changeOrderId = $value['change_order_id'];
			if($scheduledValue > 0){
				$corType = self::getLastCorType($database,$projectId,$applicationNumber);
				$previousDrawValues = self::getPreviousDrawValue($database, $projectId, $changeOrderId ,'change_order_id',$drawItemId,$applicationNumber,$corType);
				$completionPercentage = self::calculateCompletionPercentage($currentApp,$scheduledValue,$previousDrawValues);
				$updateCOItem = self::findById($database,$drawItemId);
				$updateCOItem->convertPropertiesToData();
				$updateCOData = $updateCOItem->getData();
				$updateCOData['completed_percent'] = $completionPercentage;
				$updateCOData['scheduled_value'] = $scheduledValue;
				$updateCOItem->setData($updateCOData);
				$updateCOItem->save();
			}else{
				$updateCOItem = self::findById($database,$drawItemId);
				$updateCOItem->delete();
			}
		}
	}
	// to get the realocation in the draw items
	public static function checkReallocationExists($database,$drawId)
	{
		$db = DBI::getInstance($database);
		$query=	"SELECT count(realocation) as count from draw_items where draw_id =? and realocation !='0.00' 
		";
		$arrValues = array($drawId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$recount = $row['count'];
		$db->free_result();
		return $recount;
	}

	// To get the reallocation against a costcode 	
	public static function costcodeReallocated($database,$costCodeid,$projectId)
	{
		$db = DBI::getInstance($database);
		$corType = self::getLastCorType($database,$projectId,0);
		$query2 = "SELECT count(*) as count, sum(realocation) as total,d.id FROM `draws` as d inner JOIN draw_items as di on d.id = di.draw_id where d.project_id = ? and di.cost_code_id = ? and di.cor_type = ? and di.is_realocation = ? and d.status= ? ORDER BY d.id DESC LIMIT 1";
		$arrValues2 = array($projectId,$costCodeid,$corType,1,1);
		$db->execute($query2, $arrValues2, MYSQLI_USE_RESULT);
		$row2 = $db->fetch();
		$db->free_result();

		$query=	"SELECT count(*) as count, sum(realocation) as total FROM `draws` as d inner JOIN draw_items as di on d.id = di.draw_id where d.project_id = ? and di.cost_code_id = ? and di.cor_type = ? and realocation !='0.00' and d.status=?";

		$arrValues = array($projectId,$costCodeid,$corType,2);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$costcount =array();
		$costcount['count'] = $row['count']+$row2['count'];
		$costcount['total'] = $row['total']+$row2['total'];
		$db->free_result();
		return $costcount;
	}
	// To get the reallocation against a costcode 	
	public static function ReallocationCostCodeData($database,$costCodeid,$projectId)
	{
		$corType = self::getLastCorType($database,$projectId, 0);
		$db = DBI::getInstance($database);
		$query=	"SELECT * FROM `draws` as d inner JOIN draw_items as di on d.`id` = di.`draw_id` where d.`project_id` = ? AND di.`cost_code_id` = ? AND di.`realocation` !='0.00' AND di.`is_realocation`= 1 AND di.`cor_type` = ? AND d.`status` IN (2,1) AND d.`is_deleted_flag` = 'N'";
		$arrValues = array($projectId,$costCodeid,$corType);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$realocate = array();
		while($row = $db->fetch())
		{
			$realocate[] = $row;
		}
		$db->free_result();
		return $realocate;
	}
	// To update the budget schedule values while a oco is edited and added
	public static function updateScheduledValueAgainstCostcode($database,$project_id){
		$db = DBI::getInstance($database);
		$query=	" 
		SELECT di.`id` as di_id, di.`draw_id` as di_draw_id, di.`cost_code_id` as di_cost_code_id, di.`gc_budget_line_item_id` as di_gc_budget_line_item_id, di. `change_order_id` as di_change_order_id, di.`scheduled_value` as di_scheduled_value, di.`realocation` as di_realocation, di.`current_app` as di_current_app, di.`completed_percent` as di_completed_percent,di.`current_retainer_value` as di_current_retainer_value, di.`narrative` as di_narrative, di.`renotes` as di_renotes, di.`type` as di_type,
		g.*, d.* FROM `draws`  as d
		inner join `draw_items` as di on d.id =  di.draw_id
		inner join `gc_budget_line_items` as g on g.id =  di.gc_budget_line_item_id
		WHERE d.`project_id` = ? AND d.`status` = ? and di.`cor_type` = 'A' AND di.`gc_budget_line_item_id` is not null";
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
			$costCodeid = $revalue['di_cost_code_id'];
			$realocteamt = $revalue['di_realocation'];
			$orgsch = $revalue['prime_contract_scheduled_value'];
			$drawItemId = $revalue['di_id'];
			$lineItemId = $revalue['di_gc_budget_line_item_id'];
			$applicationNumber = $revalue['application_number'];
		    $newValue = $revalue['di_current_app'];
			$reAssignedAmt = ChangeOrder::ReallocationInDrawsAndCOByCostCode($database,$costCodeid,$project_id);
			$revisedAmt = $orgsch  + $reAssignedAmt;


			// To save the schdule value data
			$updateItem = self::findById($database,$drawItemId);
				$updateItem->convertPropertiesToData();
				$updateData = $updateItem->getData();
				$updateData['scheduled_value'] = $revisedAmt;
				$updateItem->setData($updateData);
				$updateItem->save();

				// to calculate and update the % completion
				$retainerRate = self::getDrawRetainerRate($database, $project_id, $drawItemId);
				$corType = self::getLastCorType($database,$project_id,$applicationNumber);
				$previousDrawValues = self::getPreviousDrawValue($database, $project_id, $lineItemId ,'gc_budget_line_item_id',$drawItemId,$applicationNumber,$corType);
				$drawData = self::updateCurrentApp($database, $drawItemId, $newValue, 'gc_budget_line_item_id', $retainerRate, $previousDrawValues,'','');
		}
	}

	}

	public static function postReallocation($database,$drawId,$project_id){

		$applicationNumber = self::getDrawApplicationNumber($database,$drawId);
		$last_cor_type = self::getLastCorType($database,$project_id,0);

		$db = DBI::getInstance($database);
		$query = "UPDATE `draw_items` SET `is_realocation` = 1 WHERE `draw_id`= ? AND `realocation` != '0.00' AND `cor_type` = ? ";
		$arrValues = array($drawId,$last_cor_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$query2 = "SELECT * FROM `draw_items` WHERE `draw_id` = ? AND `is_realocation` = 1 AND `cor_type` = ? ";
		$arrValues2 = array($drawId,$last_cor_type);
		$db->execute($query2, $arrValues2, MYSQLI_USE_RESULT);
		$drawArray = array();
		while($row = $db->fetch())
		{
			$drawArray[] = $row;
		}
		$db->free_result();

		foreach ($drawArray as $key => $value) {
			if ($value['current_app'] > 0) {
				self::updateDrawItem($database, $project_id, $value['id'] ,$value['current_app'],$value['gc_budget_line_item_id'],'gc_budget_line_item_id','current_app',$drawId);
			}			
		}

		$draw_draw = Draws::findLastApplicationNumber($database,$project_id);
		$application_number = $draw_draw['max_application_number'];

		return $application_number;
	}

	public static function getCostCodeAlias($database, $alias_type,$cost_code_id,$cost_code_divison_id){

		$alias_type = (int) $alias_type;
		$cost_code_id = (int) $cost_code_id;
		$cost_code_divison_id = (int) $cost_code_divison_id;
		$alias = '';

		if ($alias_type != 0) {
			$db = DBI::getInstance($database);
			$query = "SELECT * from `cost_code_alias`where  `cost_code_id` =? and  `cost_code_divison_id`=? and  `user_company_id`=? ";
			$arrValues = array($cost_code_id,$cost_code_divison_id,$alias_type);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$row = $db->fetch();
			$db->free_result();
			$alias_code = $row['owner_cost_code'];
			if ($alias_code != '') {
				$alias = '('.$alias_code.')';
			}

		}
		return $alias;
	}

	// To get last cor type of draw
	public static function getLastCorType($database,$projectId,$applicationNumber){

		$projectId = (int) $projectId;
		$applicationNumber = (int) $applicationNumber;
		$db = DBI::getInstance($database);

		if ($applicationNumber == 1) {
			$cor_type = 'B';
		}else{
			$query = "SELECT `cor_type` FROM `projects` WHERE `id` = ?";
			$arrValues = array($projectId);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$row = $db->fetch();
			$db->free_result();
			$cor_type = ($row['cor_type'] == 2) ? 'A' : 'B';
		}
		return $cor_type;
	}

	// To delete ATL or BTL for first draw
	public static function deleteATLOrBTLforFirstDraw($database,$drawId,$cor_type){

		$row = Draws::findById($database, $drawId);

		if ($row['application_number'] == 1 && $row['status'] == 2) {

			$cortype = ($cor_type == 2) ? 'B' : 'A';
			$getArrDrawItems = self::getDrawItemsByDrawId($database, $drawId, $cortype);

			$db = DBI::getInstance($database);

	      	foreach($getArrDrawItems as $drawItemId => $drawItem) {

		        $drawItemId = $drawItem['id'];

		        $deleteQuery = "DELETE FROM `draw_items` WHERE `id` = $drawItemId";
				$db->execute($deleteQuery);
				$db->free_result();

				$deleteQuery1 = "DELETE FROM `draw_retainer_rate` WHERE `draw_item_id` = $drawItemId";
				$db->execute($deleteQuery1);
				$db->free_result();
		        
	      	}
		}	    
	}

	public static function updateReallocationStatus($database,$drawId,$project_id,$cor_type){
		$db = DBI::getInstance($database);
		$query = "UPDATE `draw_items` SET `is_realocation` = 1 WHERE `draw_id`= ? AND `realocation` != '0.00' AND `cor_type` = ? ";
		$arrValues = array($drawId,$cor_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
	}


}
/**
* Framework standard footer comments.
*
* No closing ?> tag to prevent the injection of whitespace.
*/
