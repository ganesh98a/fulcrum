<table border="1" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td colspan="2" style="text-align:right;">
			<a href="javascript:loadPermissionModal('11_Y', '{$project_id}');" style="margin-right: 10px;">Budget Permissions</a>
		</td>
	</tr>
	<tr>
		{*****<td id="messageList" nowrap>{$htmlMessages|strip}</td>*****}
		<td colspan="2">
			<input onclick="loadImportCostCodesIntoBudgetDialog()" type="button" value="Import Cost Codes Into Current Budget" style="margin-bottom:10px; margin-right: 20px;">
			<input onclick="loadManageGcCostCodesDialog()" type="button" value="Manage Master Cost Code Lists" style="margin-bottom:10px; margin-right: 20px;">
		</td>
	</tr>
</table>
<div id="gcBudgetLineItemsFormContainer">
<input id="companyName" type="hidden" value="{$companyName}">
{*****<form action="/modules-gc-budget-form-submit.php" method="post" name="frmTabularData" onmousemove="updateBudgetValues('tblTabularData');">*****}
<form action="/modules-gc-budget-form-submit.php" method="post" name="frmTabularData">
	<table id="tblTabularData" border="1" cellpadding="3" cellspacing="0">
		<tr class="permissionTableMainHeader">
			<th>&nbsp;</th>
			<th>Cost Code</th>
			<th>Cost Code Description</th>
			<th>Prime Contract<br>Scheduled Value</th>
			<th>Forecasted<br>Expenses</th>
			<th>Subcontract<br>Actual Value</th>
			<th>Subcontractor<br>(Vendor)</th>
			<th>&nbsp;</th>
		</tr>

		{*$budgetItems*}

		{foreach $arrGcBudgetLineItems as $row}
			{assign var='i' {$row.gc_budget_line_item_id}}
			<tr id="row_{$row.gc_budget_line_item_id}">
				<td><a href="javascript:Budget__deleteGcBudgetLineItem('{$row.gc_budget_line_item_id}');">X</a></td>
				{******<td><input type="checkbox" name="checkbox-{$i}" value="{$row.gc_budget_line_item_id}"></td>*****}

				{*********
				<td><input id="cost_code-{$i}" type="text" onblur="updateBudgetValues('tblTabularData');" onkeyup="updateBudgetValues('tblTabularData');" onmousemove="updateBudgetValues('tblTabularData');"></td>
				<td><input id="cost_code_description-{$i}" type="text" value="{$row.cost_code_description}" onblur="updateBudgetValues('tblTabularData');" onkeyup="updateBudgetValues('tblTabularData');" onmousemove="updateBudgetValues('tblTabularData');"></td>
				<td><input id="prime_contract_scheduled_value-{$i}" type="text" value="{$row.prime_contract_scheduled_value}" onblur="updateBudgetValues('tblTabularData');" onkeyup="updateBudgetValues('tblTabularData');" onmousemove="updateBudgetValues('tblTabularData');"></td>
				<td><input id="forecasted_expenses-{$i}" type="text" value="{$row.forecasted_expenses}" onblur="updateBudgetValues('tblTabularData');" onkeyup="updateBudgetValues('tblTabularData');" onmousemove="updateBudgetValues('tblTabularData');"></td>
				*********}

				<td><input id="cost_code-{$i}" type="text" value="{$row.cost_code}" class="input-costCode" onchange="Budget__updateGcBudgetLineItem(this);"></td>
				<td><input id="cost_code_description-{$i}" type="text" value="{$row.cost_code_description}" class="input-lineItem" onchange="Budget__updateGcBudgetLineItem(this);"></td>
				<td><input id="prime_contract_scheduled_value-{$i}" type="text" value="{$row.prime_contract_scheduled_value}" class="input-scheduled" onblur="updateBudgetValues('tblTabularData');" onkeyup="updateBudgetValues('tblTabularData');" onchange="Budget__updateGcBudgetLineItem(this);"></td>
				<td><input id="forecasted_expenses-{$i}" type="text" value="{$row.forecasted_expenses}" class="input-forecasted" onblur="updateBudgetValues('tblTabularData');" onkeyup="updateBudgetValues('tblTabularData');" onchange="Budget__updateGcBudgetLineItem(this);"></td>

				<td style="text-align:right;">{$row.subcontract_actual_value}</td>

				{***** <td><input id="subcontract_actual_value-{$i}" type="text" value="{$row.subcontract_actual_value}" class="input-contracted" onblur="updateBudgetValues('tblTabularData');" onkeyup="updateBudgetValues('tblTabularData');" onchange="Budget__updateGcBudgetLineItem(this);"></td> *****}
				<td>{$row.contracted_company}</td>
				<td><a href="javascript:openSubcontractsDialog('{$i}');">Contract</a></td>

				{*****
				<td><input id="subcontract_actual_value-{$i}" type="text" value="{$row.subcontract_actual_value}" onblur="updateBudgetValues('tblTabularData');" onkeyup="updateBudgetValues('tblTabularData');" onmousemove="updateBudgetValues('tblTabularData');"></td>
				<td><input id="contracted_company-{$i}" type="text"  value="{$row.contracted_company}" onblur="updateBudgetValues('tblTabularData');" onkeyup="updateBudgetValues('tblTabularData');" onmousemove="updateBudgetValues('tblTabularData');"></td>
				*****}
			</tr>
		{/foreach}

		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input id="valueTotal" type="text" class="input-scheduled"></td>
			<td><input id="forecastTotal" type="text" class="input-forecasted"></td>
		</tr>
	</table>
	<input id="lastRowNumber" type="hidden" name="lastRowNumber" value="{{counter}-1}">
{*******
	<br>

	<div>
		<input onclick="addBudgetTabularDataRow('tblTabularData', document.getElementById('lastRowNumber').value)" type="button" value="Add New Row">
		<input onclick="deleteBudgetTabularDataRow('tblTabularData')" type="button" value="Delete Selected Rows">
	</div>

	<div>
		<input type="submit" value="Save All Rows">
		<input class="button" onclick="window.location='modules-gc-budget-form-reset.php'" type="button" value="Reset Form">
	</div>
*******}
</form>
</div>
<div id="divModalWindow"></div>
<div id="divPermissionModal" title="{$projectName} Budget Permissions"></div>