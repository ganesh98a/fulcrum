<?php

require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/Log.php');
require_once('lib/common/MobileNetworkCarrier.php');
require_once('lib/common/MobilePhoneNumber.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/SubcontractDocument.php');
require_once('lib/common/SubcontractItemTemplate.php');
require_once('lib/common/SubcontractorBid.php');
require_once('lib/common/SubcontractorBidStatus.php');
require_once('lib/common/SubcontractTemplate.php');
require_once('lib/common/SubcontractTemplateToSubcontractItemTemplate.php');
require_once('lib/common/SubcontractType.php');
require_once('lib/common/UserCompanyFileTemplate.php');
require_once('lib/common/Vendor.php');

function renderGcBudgetForm($database, $user_company_id, $currentlyActiveContactId, $project_id, $companyName, $projectName)
{
	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$debugMode = $session->getDebugMode();

	$loadGcBudgetLineItemsByProjectIdOptions = new Input();
	$loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
	$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions);
	$gcBudgetForm = '';

	if ($debugMode) {
		$htmlTdCellOffset = 5;
		$debugHeadline =
'
			<th>GBLI<br>ID</th>
			<th>CCD<br>ID</th>
			<th>CODE<br>ID</th>
			<th>CCDA<br>ID</th>
			<th>CCA<br>ID</th>
';
		$fillerColumns =
'
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
';
	} else {
		$htmlTdCellOffset = 0;
		$debugHeadline = '';
		$fillerColumns = '';
	}

	$htmlTableSectionHeadline =
"
			$debugHeadline
			<th>&nbsp;</th>
			<th>Cost Code</th>
			<th>Cost Code Aliases<br>Division-Code</th>
			<th>Cost Code Description</th>
			<th>Cost Code Description Alias</th>
			<th>Prime Contract<br>Scheduled Value</th>
			<th>Forecasted<br>Expenses</th>
			<th>Subcontract<br>Actual Value</th>
			<th>Subcontractor<br>(Vendor)</th>
			<th>&nbsp;</th>
";

$gcBudgetForm = <<<END_FORM
<div id="gcBudgetLineItemsFormContainer">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td colspan="2" style="text-align: right;">
			<a href="javascript:loadPermissionModal('11_Y', '$project_id');" style="margin-right:10px;">Budget Permissions</a>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input onclick="loadImportCostCodesIntoBudgetDialog()" type="button" value="Import Cost Codes Into Current Budget" style="margin-bottom:10px; margin-right: 20px;">
			<input onclick="loadManageGcCostCodesDialog()" type="button" value="Manage Master Cost Code Lists" style="margin-bottom:10px; margin-right: 20px;">
		</td>
	</tr>
</table>
<input id="companyName" type="hidden" value="$companyName">
<form action="/modules-gc-budget-form-submit.php" method="post" name="frmTabularData">
	<input id="tdCellOffset" name="tdCellOffset" type="hidden" value="$htmlTdCellOffset">
	<table id="tblTabularData" border="1" cellpadding="3" cellspacing="0">
END_FORM;

	$firstDivisionRow = true;
	foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
		$costCodeDivision = $gcBudgetLineItem->getCostCodeDivision();
		$costCode = $gcBudgetLineItem->getCostCode();
		$costCodeDivisionAlias = $gcBudgetLineItem->getCostCodeDivisionAlias();
		$costCodeAlias = $gcBudgetLineItem->getCostCodeAlias();

		$cost_code_division_id = $costCodeDivision->cost_code_division_id;
		$cost_code_division_alias_id = $costCodeDivisionAlias->cost_code_division_alias_id;
		$cost_code_id = $costCode->cost_code_id;
		$cost_code_alias_id = $costCodeAlias->cost_code_alias_id;

		$division_number = $costCodeDivision->division_number;

		$currentDivisionNumber = '';

		if ($currentDivisionNumber <> $division_number) {
			if ($firstDivisionRow) {
				$firstDivisionRow = false;
			} else {
			$gcBudgetForm.=
'
		<tr style="border-left: 1px white; border-right: 1px white;"><td colspan="15" style="border-left: 2px #fff; border-right: 2px #fff;"></td></tr>
';
			}

			$currentDivisionNumber = $division_number;
			$gcBudgetForm.=
'
		<tr id="row_'.$cost_code_division_id.'" class="permissionTableMainHeader">
			<td align="left" colspan="15">'.$currentDivisionNumber.' '.$costCodeDivision->division.'
			<a href="javascript:deleteCostCodeAliasDatum(\'cost_code_division_alias_id\', \''.$cost_code_division_alias_id.'\');">X</a>
			<input id="division_number_alias-'.$gc_budget_line_item_id.'-'.$cost_code_division_id.'" type="text" value="'.$costCodeDivisionAlias->division_number_alias.'" class="input-costCode" onchange="updateCostCodeAliasDatum(this);">
			</td>
		</tr>
		<tr>
		'.$htmlTableSectionHeadline.'
		</tr>
';

		}

		$gcBudgetForm.=
'
		<tr id="row_'.$gc_budget_line_item_id.'">
';

		if ($debugMode) {
			$gcBudgetForm.=
'
			<td>'.(!empty($gc_budget_line_item_id) ? $gc_budget_line_item_id : '&nbsp;') .'</td>
			<td>'.(!empty($costCodeDivision->cost_code_division_id) ? $costCodeDivision->cost_code_division_id : '&nbsp;') .'</td>
			<td>'.(!empty($costCode->cost_code_id) ? $costCode->cost_code_id : '&nbsp;') .'</td>
			<td>'.(!empty($costCodeDivisionAlias->cost_code_division_alias_id) ? $costCodeDivisionAlias->cost_code_division_alias_id : '&nbsp;') .'</td>
			<td>'.(!empty($costCodeAlias->cost_code_alias_id) ? $costCodeAlias->cost_code_alias_id : '&nbsp;') .'</td>
';
		}

		$gcBudgetForm.=
'
			<td><a href="javascript:Gc_Budget__deleteGcBudgetLineItem(\''.$gc_budget_line_item_id.'\');">X</a></td>

			<td>'.$costCodeDivision->division_number.'-'.$costCode->cost_code.'</td>
			<td>
			<a href="javascript:deleteCostCodeAliasDatum(\'cost_code_division_alias_id\', \''.$cost_code_division_alias_id.'\');">X</a>
			<input id="division_number_alias-'.$gc_budget_line_item_id.'-'.$cost_code_division_id.'" type="text" value="'.$costCodeDivisionAlias->division_number_alias.'" class="input-costCode" onchange="updateCostCodeAliasDatum(this);">
			-
			<a href="javascript:deleteCostCodeAliasDatum(\'cost_code_alias_id\', \''.$cost_code_alias_id.'\');">X</a>
			<input id="cost_code_alias-'.$gc_budget_line_item_id.'-'.$cost_code_id.'" type="text" value="'.$costCodeAlias->cost_code_alias.'" class="input-costCode" onchange="updateCostCodeAliasDatum(this);">
			</td>
			<td>'.$costCode->cost_code_description.'</td>
			<td><input id="cost_code_description_alias-'.$gc_budget_line_item_id.'-'.$cost_code_id.'" type="text" value="'.$costCodeAlias->cost_code_description_alias.'" class="input-lineItem" onchange="updateCostCodeAliasDatum(this);"></td>
			<td><input id="manage-gc_budget_line_item-record--gc_budget_line_items--prime_contract_scheduled_value--'.$gc_budget_line_item_id.'" type="text" value="'.$gcBudgetLineItem->prime_contract_scheduled_value.'" class="input-scheduled" onblur="updateBudgetValues(\'tblTabularData\');" onkeyup="updateBudgetValues(\'tblTabularData\');" onchange="Gc_Budget__updateGcBudgetLineItem(this);"></td>
			<td><input id="manage-gc_budget_line_item-record--gc_budget_line_items--forecasted_expenses--'.$gc_budget_line_item_id.'" type="text" value="'.$gcBudgetLineItem->forecasted_expenses.'" class="input-forecasted" onblur="updateBudgetValues(\'tblTabularData\');" onkeyup="updateBudgetValues(\'tblTabularData\');" onchange="Gc_Budget__updateGcBudgetLineItem(this);"></td>

			<td class="textAlignRight"></td>

			<td></td>
			<td><a href="javascript:openSubcontractsDialog(\''.$gc_budget_line_item_id.'\', \''.$cost_code_division_id.'\', \''.$cost_code_id.'\');">Contract</a></td>
		</tr>
		';
	}

$gcBudgetForm .= <<<END_FORM
		<tr>
			$fillerColumns
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input id="valueTotal" type="text" class="input-scheduled"></td>
			<td><input id="forecastTotal" type="text" class="input-forecasted"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<input id="lastRowNumber" type="hidden" name="lastRowNumber" value="{{counter}-1}">
</form>
<div id="divModalWindow"></div>
<div id="divPermissionModal" title="$projectName Budget Permissions"></div>
</div>
END_FORM;

	return $gcBudgetForm;
}