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
 * Generic project budget class.
 *
 * "Is A":
 * Project Budget
 *
 * "Has A":
 * 1) a
 * 2) b
 * 3) c
 *
 * @category	Framework
 * @package		GcBudget
 */

/**
 * Data
 */
// Already Included...commented out for performance gain
//require_once('lib/common/Data.php');

class GcBudget extends IntegratedMapper
{
	/**
	 * An array of budget items.
	 *
	 * @var array
	 */
	protected $_arrGcBudgetLineItems;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='gc_budget_line_items')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	public static function loadProjectsListForImport($database, $user_id=null)
	{
		$db = DBI::getInstance($database);

		/**
		 * @todo Add in the permissions layer via the user_id or contact_id.
		 */
		// Exclude the Non-existent Project
		// Exclude the Fulcrum Template Project to allow for ab custom naming convention to be used here
		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_TEMPLATE_PROJECT_ID = AXIS_TEMPLATE_PROJECT_ID;
		$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;
		$query =
"
SELECT p.`id` 'project_id', p.`project_name`, uc.`id` 'user_company_id', uc.`company` 'user_company_name'
FROM `gc_budget_line_items` gbli, `projects` p, `user_companies` uc
WHERE gbli.`user_company_id` = uc.`id`
AND gbli.`project_id` = p.`id`
AND gbli.`project_id` NOT IN ($AXIS_NON_EXISTENT_PROJECT_ID, $AXIS_TEMPLATE_PROJECT_ID)
GROUP by gbli.`project_id`, gbli.`user_company_id`
ORDER BY p.`project_name` ASC
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		echo $query;

		/**
		 * @todo Update project_id to 2 for Template Project to match data
		 */
		$templateProjectKey = $AXIS_TEMPLATE_PROJECT_ID.'-'.$AXIS_TEMPLATE_USER_COMPANY_ID;
		$arrProjectOptions = array(
			$templateProjectKey => 'Default System Project (Fulcrum Budget Template)'
		);
		while ($row = $db->fetch()) {
			$project_id = $row['project_id'];
			$project_name = $row['project_name'];
			$user_company_id = $row['user_company_id'];
			$user_company_name = $row['user_company_name'];

			// Drop down list format
			$arrProjectOptions["$project_id-$user_company_id"] = "$project_name ($user_company_name Budget)";
		}
		$db->free_result();

		return $arrProjectOptions;
	}

	/**
	 * Load a standard set of Project Budget Items
	 * project_id of AXIS_TEMPLATE_PROJECT_ID is the "System Default Budget"
	 *
	 * @param string $database
	 */
	public function loadSystemDefaultGcBudgetLineItems($database)
	{
		// Fulcrum Template project_id & user_company_id
		$AXIS_TEMPLATE_PROJECT_ID = AXIS_TEMPLATE_PROJECT_ID;
		$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

		$pb = new GcBudget($database);
		$arrGcBudgetLineItems = $pb->loadGcBudgetLineItems($database, $AXIS_TEMPLATE_USER_COMPANY_ID, $AXIS_TEMPLATE_PROJECT_ID);

		return $arrGcBudgetLineItems;
	}

	public function loadGcBudgetLineItems($database, $user_company_id, $project_id)
	{
		$db = DBI::getInstance($database);

		$query =
"
SELECT gbli.*, cc.company
FROM `gc_budget_line_items` gbli
LEFT JOIN `contact_companies` cc ON gbli.`subcontracted_contact_company_id` = cc.`id`
WHERE gbli.`user_company_id` = ?
AND gbli.`project_id` = ?
ORDER BY if(`cost_code` = '' OR `cost_code` IS NULL,1,0), `cost_code`, `cost_code_description`, `sort_order`,`id` ASC
";
		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItems = array();
		$counter = 0;
		while ($row = $db->fetch()) {
			$gc_budget_line_item_id = $row['id'];
			$cost_code = $row['cost_code'];
			$cost_code_description = $row['cost_code_description'];
			$prime_contract_scheduled_value = $row['prime_contract_scheduled_value'];
			$forecasted_expenses = $row['forecasted_expenses'];
			$subcontract_actual_value = $row['subcontract_actual_value'];
			$subcontracted_contact_company_id = $row['subcontracted_contact_company_id'];
			$contracted_company = $row['company'];
			$sort_order = $row['sort_order'];

			$arrGcBudgetLineItem = array(
				'gc_budget_line_item_id' => $gc_budget_line_item_id,
				'cost_code' => $cost_code,
				'cost_code_description' => $cost_code_description,
				'prime_contract_scheduled_value' => $prime_contract_scheduled_value,
				'forecasted_expenses' => $forecasted_expenses,
				'subcontract_actual_value' => $subcontract_actual_value,
				'subcontracted_contact_company_id' => $subcontracted_contact_company_id,
				'contracted_company' => $contracted_company,
			);

			$arrGcBudgetLineItems[$counter] = $arrGcBudgetLineItem;
			$counter++;
		}
		$db->free_result();

		return $arrGcBudgetLineItems;
	}

	public function saveGcBudgetLineItems($database, $user_company_id, $project_id, $arrGcBudgetLineItems)
	{
		$db = DBI::getInstance($database);

		$arrKeyMap = array(
			//'user_company_id' => 'user_company_id',
			//'project_id' => 'project_id',
			'prime_contract_scheduled_value' => 'prime_contract_scheduled_value',
			'cost_code' => 'cost_code',
			'cost_code_description' => 'cost_code_description',
			'forecasted_expenses' => 'forecasted_expenses',
		);

		foreach ($arrGcBudgetLineItems as $null => $arrTmp) {
			$row = array();
			foreach ($arrTmp as $k => $v) {
				$key = $arrKeyMap[$k];
				if (!empty($v)) {
 					$row[$key] = $v;
				}
			}
			$row['user_company_id'] = $user_company_id;
			$row['project_id'] = $project_id;

			$b = new GcBudget($database);
			$b->setData($row);
			$b->disabled_flag = 'N';
			$b->deltifyAndSave();
		}

		return true;
	}

	public function checkForBlankBudgetLineItemRow($database, $user_company_id, $project_id) {

		// Disable insertion of junk data.
		return;

		$db = DBI::getInstance($database);

		//"AND cost_code_description = '' ".

		$query =
"
SELECT *
FROM `gc_budget_line_items`
WHERE user_company_id = ?
AND project_id = ?
AND cost_code = ''

AND (prime_contract_scheduled_value IS NULL OR prime_contract_scheduled_value = '' OR prime_contract_scheduled_value = 0)
AND (forecasted_expenses IS NULL OR forecasted_expenses = '' OR forecasted_expenses = 0)
AND (subcontract_actual_value IS NULL OR subcontract_actual_value = '' OR subcontract_actual_value = 0)
AND (subcontracted_contact_company_id IS NULL OR subcontracted_contact_company_id = 0)
";
		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if (!$row || empty($row)) {
			// Insert a blank row
			$query =
"
INSERT INTO `gc_budget_line_items` (user_company_id, project_id, disabled_flag)
VALUES(?,?,'N');
";
			$arrValues = array($user_company_id, $project_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
			return 1;
		}
		return 0;
	}


	/**
	 * Take a project_id as input and associate a list of project gc_budget_line_items
	 *
	 * @param unknown_type $database
	 * @param unknown_type $import_into_project_id
	 * @param unknown_type $arrGcBudgetLineItemIds
	 * @return unknown
	 */
	public function importGcBudgetLineItems($database, $user_company_id, $import_into_project_id, $arrGcBudgetLineItemIds)
	{
		$db = DBI::getInstance($database);

		// Associate the list of Budget Items with the project's budget
		foreach ($arrGcBudgetLineItemIds as $imported_gc_budget_line_item_id) {
			$bi = new GcBudget($database);
			$arrKey = array(
				'id' => $imported_gc_budget_line_item_id
			);
			$bi->setKey($arrKey);
			$bi->load();
			$data = $bi->getData();
			$data['user_company_id'] = $user_company_id;
			$data['project_id'] = $import_into_project_id;
			$data['modified'] = null;
			$data['created'] = null;
			$data['disabled_flag'] = 'N';

			// Load a new record to test first
			$cost_code = $data['cost_code'];
			$cost_code_description = $data['cost_code_description'];
			$prime_contract_scheduled_value = $data['prime_contract_scheduled_value'];
			$forecasted_expenses = $data['forecasted_expenses'];
			$query =
"
SELECT *
FROM `gc_budget_line_items`
WHERE user_company_id = ?
AND project_id = ?
AND cost_code = ?
AND cost_code_description = ?
";
				//"AND prime_contract_scheduled_value = ? ".
				//"AND forecasted_expenses = ? ";
			$arrValues = array($user_company_id, $import_into_project_id, $cost_code, $cost_code_description);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$row = $db->fetch();
			$db->free_result();

			if (!$row || empty($row)) {
				$biNew = new GcBudget($database);
				unset($data['id']);
				// Blank out the dollar amounts
				$data['prime_contract_scheduled_value'] = null;
				$data['forecasted_expenses'] = null;
				$biNew->setData($data);
				$biNew->save();
			}
		}

		return true;
		/*Sq fix*/
		/*$arrKeyMap = array(
			'prime_contract_scheduled_value' => 'prime_contract_scheduled_value',
			'cost_code' => 'cost_code',
			'cost_code_description' => 'cost_code_description',
			'forecasted_expenses' => 'forecasted_expenses',
		);

		foreach ($arrGcBudgetLineItems as $null => $arrTmp) {
			$row = array();
			foreach ($arrTmp as $k => $v) {
				$key = $arrKeyMap[$k];
				if (!empty($v)) {
 					$row[$key] = $v;
				}
			}
			$row['project_id'] = $project_id;

			$b = new GcBudget($database);
			$b->setData($row);
			$b->disabled_flag = 'N';
			$b->deltifyAndSave();
		}

		return true;*/
	}

	public function deleteGcBudgetLineItems($database, $user_company_id, $project_id, $arrGcBudgetLineItems)
	{
		$db = DBI::getInstance($database);

		$arrKeyMap = array(
			'prime_contract_scheduled_value' => 'prime_contract_scheduled_value',
			'cost_code' => 'cost_code',
			'cost_code_description' => 'cost_code_description',
			'forecasted_expenses' => 'forecasted_expenses',
		);

		$query =
"
DELETE FROM `gc_budget_line_items`
WHERE `user_company_id` = ?
AND `project_id` = ?
AND `cost_code`=?
AND `cost_code_description`=?
";

		foreach ($arrGcBudgetLineItems as $null => $arrTmp) {
			$row = array();
			foreach ($arrTmp as $k => $v) {
				$key = $arrKeyMap[$k];
				$row[$key] = $v;
			}
			$cost_code = $row['cost_code'];
			$cost_code_description = $row['cost_code_description'];
			$arrValues = array($user_company_id, $project_id, $cost_code, $cost_code_description);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		return true;
	}

	/**
	 * Conditionally invoke the standard save() method after deltification.
	 *
	 */
	public function deltifyAndSave()
	{
		// prevent error messages
		$newRecord = false;

		//load existing

		//deltify

		//save (insert, update, or do nothing)

		$newData = $this->getData();
		$row = $newData;

		// These GUIDs taken as a composite are the primary key of gc_budget_line_items
		// <cost_code, cost_code_description>
		$user_company_id = $this->user_company_id;
		$project_id = $this->project_id;
		$cost_code = $this->cost_code;
		$cost_code_description = $this->cost_code_description;

		$key = array(
			'user_company_id' => $user_company_id,
			'project_id' => $project_id,
			'cost_code' => $cost_code,
			'cost_code_description' => $cost_code_description,
		);

		$database = $this->getDatabase();
		$table = $this->getTable();
		$bi = new GcBudget($database, $table);
		$bi->setKey($key);
		$bi->load();

		/**
		 * Conditionally Insert/Update the record.
		 *
		 * $key is conditionally set based on if record exists.
		 */
		$newData = $row;

		//Iterate over latest input from data feed and only set different values.
		//Same values will be key unset to acheive a conditional update.
		$save = false;
		$existsFlag = $bi->isDataLoaded();
		if ($existsFlag) {
			$record_id = $bi->id;

			//Conditionally Update the record
			//Don't compare the key values that loaded the record.
			unset($bi->id);
			unset($bi->modified);
			//unset($bi->created);
			//unset($bi->deleted_flag);

			$existingData = $bi->getData();

			//debug
			/*
			$keyDiffFlag = Data::diffKeys($existingData, $newData);
			if (!$keyDiffFlag) {
				echo "Key:\n".print_r($key, true)."\n\n\n\n";
				echo 'Existing:'."\n";
				ksort($existingData);
				print_r($existingData);
				echo 'New:'."\n";
				ksort($newData);
				print_r($newData);
				$n = array_keys($newData);
				$e = array_keys($existingData);
				$_1 = array_diff_key($n, $e);
				echo 'New:'."\n";
				print_r($_1);
				$_2 = array_diff_key($e, $n);
				echo 'Old:'."\n";
				print_r($_2);
				throw new Exception('Keys mismatch');
			}
			*/

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$bi->setData($data);
				$save = true;
				//$this->updatedRecords++;
			} else {
				$bi->id = $record_id;
				return $bi;
			}
		} else {
			//normalize since record is just being inserted for the first time
			//$this->setData($newData);
			//$this->normalize();
			//$newData = $this->getData();
			//get only the attributes that will go into the details table
			//$newData = array_intersect_key($newData, $arrAttributes);

			//Insert the record
			$bi->setKey(null);
			$bi->setData($newData);
			// Add value for created timestamp.
			$bi->created = null;
			$save = true;
			//$this->insertedRecords++;
		}

		//Save if needed (conditionally Insert/Update)
		if ($save) {
			$id = $bi->save();

			if (isset($id)) {
				$bi->id = $record_id;
			}
		}

		return $bi;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
