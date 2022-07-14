<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/DrawItems.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('../subcontract-change-order-functions.php'); 
require_once('lib/common/ChangeOrder.php');
require_once('lib/common/ChangeOrderAttachment.php');
require_once('lib/common/ChangeOrderDistributionMethod.php');
require_once('lib/common/ChangeOrderDraft.php');
require_once('lib/common/ChangeOrderDraftAttachment.php');
require_once('lib/common/ChangeOrderNotification.php');
require_once('lib/common/ChangeOrderPriority.php');
require_once('lib/common/ChangeOrderRecipient.php');
require_once('lib/common/ChangeOrderResponse.php');
require_once('lib/common/ChangeOrderResponseType.php');
require_once('lib/common/ChangeOrderStatus.php');
require_once('lib/common/ChangeOrderType.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');

$RN_jsonEC['data'] = null;
$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['BudgetData'] = null;
$RN_orderBy = '';
$RN_where = '';
if($RN_sort != '' && $RN_sort != null){
	$RN_orderBy = $RN_sort;	
}

/* sort values avoid */
$RN_loadGcBudgetLineItemsByProjectIdOptions = new Input();
$RN_loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
$RN_arrGcBudgetLineItemsByProjectIdSort = GcBudgetLineItem::loadGcBudgetLineItemsByProjectIdSortApi($database, $RN_project_id, $RN_loadGcBudgetLineItemsByProjectIdOptions, $RN_scheduled_values_only, $RN_needed_buy_out);

$RN_arrGcBudgetLineItemsByProjectIdSort = implode(',', $RN_arrGcBudgetLineItemsByProjectIdSort);

/* Budget Data Fech */
$RN_loadGcBudgetLineItemsByProjectIdOptions = new Input();
$RN_loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
$RN_arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $RN_project_id, $RN_loadGcBudgetLineItemsByProjectIdOptions, $RN_arrGcBudgetLineItemsByProjectIdSort);
$RN_arrGcBudgetLineItemsByProjectId = array_values($RN_arrGcBudgetLineItemsByProjectId);
// change order - approved
$loadChangeOrdersByProjectIdOptions = new Input();
$loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
$loadChangeOrdersByProjectIdOptions->change_order_type_id = 2;
$loadChangeOrdersByProjectIdOptions->change_order_status_id = 2; //For approved 
$arrChangeOrders = ChangeOrder::loadChangeOrdersByProjectId($database, $RN_project_id, $loadChangeOrdersByProjectIdOptions);
if(isset($arrChangeOrders) && !empty($arrChangeOrders)){
	$indexIn = 0;
	foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
		$changeOrder['change_order_index'] = $indexIn;
		array_push($RN_arrGcBudgetLineItemsByProjectId, $changeOrder);
		// print_r($changeOrder);
		$indexIn++;
	}
}
// lazy load calculation
$RN_per_page = $RN_per_page;
$RN_total_rows = count($RN_arrGcBudgetLineItemsByProjectId);
$RN_pages = ceil($RN_total_rows / $RN_per_page);
$RN_current_page = isset($RN_page) ? $RN_page : 1;
$RN_current_page = ($RN_total_rows > 0) ? min($RN_page, $RN_current_page) : 1;
$RN_start = $RN_current_page * $RN_per_page - $RN_per_page;
$RN_prev_page = ($RN_current_page > 1) ? ($RN_current_page-1) : null;
$RN_next_page = ($RN_current_page > ($RN_pages-1)) ? null : ($RN_current_page+1);

$RN_arrGcBudgetLineItemsByProjectId = array_slice($RN_arrGcBudgetLineItemsByProjectId, $RN_start, $RN_per_page); 
$RN_jsonEC['data']['total_row'] = $RN_total_rows;
$RN_jsonEC['data']['total_pages'] = $RN_pages;
$RN_jsonEC['data']['per_pages'] = $RN_per_page;
$RN_jsonEC['data']['from'] = ($RN_start+1);
$RN_jsonEC['data']['to'] = ((($RN_start+$RN_per_page)-1) > $RN_total_rows-1) ? $RN_total_rows : ($RN_start+$RN_per_page);
$RN_jsonEC['data']['prev_page'] = $RN_prev_page;
$RN_jsonEC['data']['current_page'] = $RN_current_page;
$RN_jsonEC['data']['next_page'] = $RN_next_page;

$RN_tmpBudgetArray = array();
foreach ($RN_arrGcBudgetLineItemsByProjectId as $RN_keyIndex => $RN_gcBudgetLineItem) {
	$RN_getClassOfObject = get_class($RN_gcBudgetLineItem);
	if($RN_getClassOfObject == 'ChangeOrder') {
		$RN_change_order_index = $RN_gcBudgetLineItem->change_order_index;
		$RN_change_order_id = $RN_gcBudgetLineItem->change_order_id;
		$RN_co_type_prefix = $RN_gcBudgetLineItem->co_type_prefix;
		$RN_co_delay_days = $RN_gcBudgetLineItem->co_delay_days;
		$RN_co_cost_code_id = $RN_gcBudgetLineItem->co_cost_code_id;
		$RN_co_total = $RN_gcBudgetLineItem->co_total;
		$RN_created = date('m/d/Y', strtotime($RN_gcBudgetLineItem->created));
		$RN_co_title = $RN_gcBudgetLineItem->co_title;
		$RN_changeOrderPriority = $RN_gcBudgetLineItem->getChangeOrderPriority();
		$RN_coCostCode = $RN_gcBudgetLineItem->getCoCostCode();
		if ($RN_coCostCode) {
			// Extra: Change Order Cost Code - Cost Code Division
			$coCostCodeDivision = $RN_coCostCode->getCostCodeDivision();
			/* @var $coCostCodeDivision CostCodeDivision */
			$formattedCoCostCode = $RN_coCostCode->getFormattedCostCodeApi($database, false, $RN_user_company_id);
		} else {
			$formattedCoCostCode = '';
			$escaped_cost_code_description = '';
		}
		if ($RN_changeOrderPriority) {
			$RN_change_order_priority = $RN_changeOrderPriority->change_order_priority;
		} else {
			$RN_change_order_priority = '';
		}
		$RN_tmpBudgetArray[$RN_keyIndex]['change_order_id'] = $RN_change_order_id;
		$RN_tmpBudgetArray[$RN_keyIndex]['co_type_prefix'] = $RN_co_type_prefix;
		$RN_tmpBudgetArray[$RN_keyIndex]['co_delay_days'] = $RN_co_delay_days;
		$RN_tmpBudgetArray[$RN_keyIndex]['co_title'] = $RN_co_title;
		$RN_tmpBudgetArray[$RN_keyIndex]['co_total'] = Format::formatCurrency($RN_co_total);
		$RN_tmpBudgetArray[$RN_keyIndex]['co_created'] = $RN_created;
		$RN_tmpBudgetArray[$RN_keyIndex]['co_cost_code_id'] = $RN_co_cost_code_id;
		$RN_tmpBudgetArray[$RN_keyIndex]['co_cost_code'] = $formattedCoCostCode;
		$RN_tmpBudgetArray[$RN_keyIndex]['co_priority'] = $RN_change_order_priority;
		$RN_tmpBudgetArray[$RN_keyIndex]['expand'] = false;
		$RN_tmpBudgetArray[$RN_keyIndex]['view'] = "COR";
		$RN_tmpBudgetArray[$RN_keyIndex]['change_order_index'] = $RN_change_order_index;		
		continue;
	}
	$RN_gc_budget_line_item_id = $RN_gcBudgetLineItem->gc_budget_line_item_id;

	$RN_costCode = $RN_gcBudgetLineItem->getCostCode();
	/* @var $RN_costCode CostCode */

	$RN_costCode->htmlEntityEscapeProperties();

	$RN_costCodeDivision = $RN_costCode->getCostCodeDivision();
	/* @var $RN_costCodeDivision CostCodeDivision */

	$RN_cost_code_id = $RN_costCode->cost_code_id;

	$RN_costCodeDivision->htmlEntityEscapeProperties();

	$RN_cost_code_division_id = $RN_costCodeDivision->cost_code_division_id;

	$RN_contactCompany = $RN_gcBudgetLineItem->getContactCompany();
	/* @var $RN_contactCompany ContactCompany */

	$RN_costCodeDivisionAlias = $RN_gcBudgetLineItem->getCostCodeDivisionAlias();
	/* @var $RN_costCodeDivisionAlias CostCodeDivisionAlias */

	$RN_costCodeAlias = $RN_gcBudgetLineItem->getCostCodeAlias();
	/* @var $RN_costCodeAlias CostCodeAlias */

	$RN_subcontractorBid = $RN_gcBudgetLineItem->getSubcontractorBid();

	$RN_prime_contract_scheduled_value = $RN_gcBudgetLineItem->prime_contract_scheduled_value;

	$RN_forecasted_expenses = $RN_gcBudgetLineItem->forecasted_expenses;

	$RN_buyout_forecasted_expenses = $RN_gcBudgetLineItem->buyout_forecasted_expenses;
	
	$RN_reallocation = DrawItems::costcodeReallocated($database,$RN_cost_code_id,$RN_project_id);
	$updtedPSCV = $RN_prime_contract_scheduled_value + $RN_reallocation['total'];
	$updtedPSCV_raw = $RN_prime_contract_scheduled_value + $RN_reallocation['total'];
	$updtedPSCV = Data::parseFloat($updtedPSCV);
	$updtedPSCV_raw = Data::parseFloat($updtedPSCV_raw);
	
	/* subcontractor */
	$RN_loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
	$RN_loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
	$RN_arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemId($database, $RN_gc_budget_line_item_id, $RN_loadSubcontractsByGcBudgetLineItemIdOptions, $RN_needed_buy_out);
	$RN_tmpSubcontractor = array();
	$RN_subcontract_actual_value_raw = 0;
	$RN_current_cost = 0;
	$RN_subtable = 0;
	foreach ($RN_arrSubcontracts as $RN_subcontract) {
		$RN_tmp_subcontract_id = $RN_subcontract->subcontract_id;
		$RN_tmp_subcontract_sequence_number = $RN_subcontract->subcontract_sequence_number;
		$RN_tmp_subcontract_template_id = $RN_subcontract->subcontract_template_id;
		$RN_tmp_vendor_id = $RN_subcontract->vendor_id;
		$RN_tmp_subcontract_forecasted_value = $RN_subcontract->subcontract_forecasted_value;
		$RN_tmp_subcontract_actual_value = $RN_subcontract->subcontract_actual_value;

		//To add  SCO approved amt
   		$RN_subtable = GenActualOriginalValueApi($database, $RN_cost_code_id, $RN_project_id, $RN_tmp_subcontract_id);
		$RN_tmp_subcontract_actual_value = $RN_tmp_subcontract_actual_value + floatVal($RN_subtable);

		// Vendor list
		$RN_vendor = $RN_subcontract->getVendor();
		$RN_vendorList = '';

		if ($RN_vendor) {

			$RN_vendorContactCompany = $RN_vendor->getVendorContactCompany();
			/* @var $RN_vendorContactCompany ContactCompany */

			$RN_vendorContactCompany->htmlEntityEscapeProperties();

			$RN_vendorList = htmlspecialchars_decode($RN_vendorContactCompany->escaped_contact_company_name);

		}
		// formatted values
		$RN_formattedSubcontractActualValue = Format::formatCurrency($RN_tmp_subcontract_actual_value);
		// add total values
		$RN_subcontract_actual_value_raw += $RN_tmp_subcontract_actual_value;

		$RN_tmpSubcontractor[$RN_tmp_subcontract_id]['id'] = $RN_tmp_subcontract_id;
		$RN_tmpSubcontractor[$RN_tmp_subcontract_id]['sequence_no'] = $RN_tmp_subcontract_sequence_number;
		$RN_tmpSubcontractor[$RN_tmp_subcontract_id]['name'] = $RN_vendorList;
		$RN_tmpSubcontractor[$RN_tmp_subcontract_id]['actual_value'] = $RN_formattedSubcontractActualValue;
	}
	$RN_current_cost = $RN_subcontract_actual_value_raw + $RN_forecasted_expenses + $RN_buyout_forecasted_expenses;

	// formatted value
	$RN_formattedSubcontractActualValueTot = Format::formatCurrency($RN_subcontract_actual_value_raw);
	$RN_prime_contract_scheduled_value_tot = Format::formatCurrency($RN_prime_contract_scheduled_value);
	$RN_formattedCurrentCostValue = Format::formatCurrency($RN_current_cost);
	$RN_updtedPSCV = Format::formatCurrency($updtedPSCV);	
	// cost code with alias
	// $RN_cost_code = $RN_costCodeDivision->escaped_division_number.'-'.$RN_costCode->escaped_cost_code;
	$RN_CostCode = $RN_gcBudgetLineItem->getCostCode();
	if ($RN_CostCode) {
		// Extra: Change Order Cost Code - Cost Code Division
		$CostCodeDivision = $RN_CostCode->getCostCodeDivision();
		/* @var $coCostCodeDivision CostCodeDivision */
		$formattedCostCode = $RN_CostCode->getFormattedCostCodeApi($database, false, $RN_user_company_id);
	} else {
		$formattedCostCode = '';
		$escaped_cost_code_description = '';
	}
	$RN_cost_code = $formattedCostCode;
	$RN_tmpBudgetArray[$RN_keyIndex]['gc_budget_line_item_id'] = $RN_gc_budget_line_item_id;

	// variance
	$RN_pcsv = Data::parseFloat($RN_prime_contract_scheduled_value);
	$RN_forecast = Data::parseFloat($RN_forecasted_expenses);
	$RN_buyoutForecast = Data::parseFloat($RN_buyout_forecasted_expenses);
	$RN_updtedPSC_Value = $RN_updtedPSCV;
	$RN_sav = Data::parseFloat($RN_subcontract_actual_value_raw);
	$RN_gcBudgetLineItemVarianceRaw = $updtedPSCV_raw - ($RN_forecast + $RN_buyoutForecast + $RN_sav);
	$RN_varianceMinus = $RN_gcBudgetLineItemVarianceRaw < 0 ? true : false;
	$RN_gcBudgetLineItemVariance = Format::formatCurrency($RN_gcBudgetLineItemVarianceRaw);
	// store data to array
	$RN_tmpBudgetArray[$RN_keyIndex]['cost_code'] = $RN_cost_code;
	$RN_tmpBudgetArray[$RN_keyIndex]['cost_code_division'] = htmlspecialchars_decode($RN_costCode->escaped_cost_code_description);
	$RN_tmpBudgetArray[$RN_keyIndex]['cost_code_division'] = html_entity_decode($RN_tmpBudgetArray[$RN_keyIndex]['cost_code_division'], ENT_QUOTES, "UTF-8");
	$RN_tmpBudgetArray[$RN_keyIndex]['schedule_value'] = $RN_prime_contract_scheduled_value_tot;
	$RN_tmpBudgetArray[$RN_keyIndex]['pcsv'] = $RN_updtedPSC_Value;
	$RN_tmpBudgetArray[$RN_keyIndex]['forecasted_expenses'] = $RN_forecasted_expenses;
	$RN_tmpBudgetArray[$RN_keyIndex]['buyout_forecasted_expenses'] = $RN_buyout_forecasted_expenses;
	$RN_tmpBudgetArray[$RN_keyIndex]['current_cost'] = $RN_formattedCurrentCostValue;
	$RN_tmpBudgetArray[$RN_keyIndex]['subcontract_actual_value'] = $RN_formattedSubcontractActualValueTot;
	$RN_tmpBudgetArray[$RN_keyIndex]['subcontractors'] = array_values($RN_tmpSubcontractor);
	$RN_tmpBudgetArray[$RN_keyIndex]['variance'] = $RN_gcBudgetLineItemVariance;
	$RN_tmpBudgetArray[$RN_keyIndex]['variance_minus'] = $RN_varianceMinus;
	$RN_tmpBudgetArray[$RN_keyIndex]['expand'] = false;
	$RN_tmpBudgetArray[$RN_keyIndex]['view'] = "Budget";
}

$RN_jsonEC['data']['BudgetData'] = array_values($RN_tmpBudgetArray);
