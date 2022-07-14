<div id="purchasingBidSpreadContainer--{$gc_budget_line_item_id}">
	<input id="bid_spread_sequence_number" type="hidden" value="{$bid_spread_sequence_number}">
	<div id="divSpreadButtons">
		<input id="btnImportBidItems" type="hidden" value="Import Bid Items" onclick="importBidItems('{$gc_budget_line_item_id}');">
		<input id="btnSortBiddersByPrice" type="button" value="Sort Bidders By Price" onclick="Subcontractor_Bid_Spreadsheet__sortBiddersByPrice('{$gc_budget_line_item_id}');">
		<input type="button" value="Bid Spread Approval Process" onclick="loadBidSpreadApprovalProcessDialog();">
		<!--<input type="button" value="Budget" onclick="navigateToBudget();">-->
	</div>
	<table id="spreadTable" cellspacing="0" border="1">
		<tr class="notSortable">
			<th colspan="3" class="rightBorder textAlignLeft"><a class="smallLink" href="javascript:toggleSpreadDetails();">Show/Hide Details</a></th>

			{foreach $arrSubcontractorBidsByGcBudgetLineItemId as $subcontractor_bid_id => $subcontractorBid}

				<th colspan="5" class="rightBorder">
					<a href="javascript:Subcontractor_Bid_Spreadsheet__moveBidderFarLeft('{$gc_budget_line_item_id}', '{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['sort_order']}');" style="margin-right:15px;" rel="tooltip" title="Shift bidder to the far left column"><<<</a>
					<a href="javascript:Subcontractor_Bid_Spreadsheet__moveBidderLeft('{$gc_budget_line_item_id}', '{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['sort_order']}');" style="margin-right:5px;" rel="tooltip" title="Shift bidder to the left 1 column"><</a>
					<span id="manage-subcontractor_bid-record--subcontractor_bids--company--{$subcontractor_bid_id}">{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['contact_company_name']}</span>
					<a href="javascript:Subcontractor_Bid_Spreadsheet__moveBidderRight('{$gc_budget_line_item_id}', '{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['sort_order']}');" style="margin-left:5px;" rel="tooltip" title="Shift bidder to the right 1 column">></a>
					<a href="javascript:Subcontractor_Bid_Spreadsheet__moveBidderFarRight('{$gc_budget_line_item_id}', '{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['sort_order']}');" style="margin-left:15px;" rel="tooltip" title="Shift bidder to the far right column">>>></a>
				</th>

			{/foreach}

		</tr>

		<tr class="notSortable detailsRow">
			<td colspan="3" rowspan="2" class="rightBorder" style="vertical-align:top;">
				<table id="tblBudgetAmounts">
					<tr class="notSortable">
						<td colspan="2" class="budgetName"><span id="gc_budget_line_items--cost_code_divisions--division_number--{$cost_code_division_id}">{$division_number}</span>-<span id="gc_budget_line_items--cost_codes--cost_code--{$cost_code_id}">{$cost_code}</span> <span id="gc_budget_line_items--cost_codes--cost_code_description--{$cost_code_id}">{$cost_code_description}</span></td>
					</tr>
					<tr class="notSortable">
						<td>Prime Contract Scheduled Value:</td>
						<td align="right"><span id="prime_contract_scheduled_value">{$formattedPrimeContractScheduledValue}</span></td>
					</tr>
					<tr class="notSortable">
						<td>Forecasted Expenses:</td>
						<td align="right"><span id="forecasted_expenses">{$formattedForecastedExpenses}</span></td>
					</tr>

					<tr class="notSortable">
						<td colspan="2" style="text-align:right;">
							<input id="btnLinkScheduledValues" type="button" value="Link Multiple Cost Codes" rel="tooltip" title="Click to manage linked scheduled values" onclick="loadLinkedScheduledValues('{$gc_budget_line_item_id}');">
						</td>
					</tr>

					{if count($arrLinkedGcBudgetLineItems) > 0}

						<tr class="notSortable">
							<td colspan="2" class="linkedHeader" onclick1="toggleDisplayLinkedCostCodes('{$bid_spread_id}');">Linked Scheduled Values<a class="showHideLink hidden" href="#">(show/hide)</a></td>
						</tr>

						{foreach $arrLinkedGcBudgetLineItems as $linked_gc_budget_line_item_id => $gcBudgetLineItem}

							<tr class="notSortable linkedRow" {*$showLinkedScheduledValuesStyle*}>
								<td colspan="2" class="budgetName">
									{$arrLinkedGcBudgetLineItemsTemplateVars[$linked_gc_budget_line_item_id]['budgetName']}
								</td>
							</tr>
							<tr class="notSortable linkedRow" {*$showLinkedScheduledValuesStyle*}>
								<td>Prime Contract Scheduled Value:</td>
								<td align="right">
									{$arrLinkedGcBudgetLineItemsTemplateVars[$linked_gc_budget_line_item_id]['formattedScheduledAmount']}
								</td>
							</tr>
							<tr class="notSortable linkedRow"{*$showLinkedScheduledValuesStyle*}>
								<td>Forecasted Expenses:</td>
								<td align="right">
									{$arrLinkedGcBudgetLineItemsTemplateVars[$linked_gc_budget_line_item_id]['formattedForecastedAmount']}
								</td>
							</tr>

						{/foreach}

						<tr class="notSortable linkedRow"{*$showLinkedScheduledValuesStyle*}>
							<td colspan="2" class="linkedHeader">Totals</td>
						</tr>
						<tr class="notSortable">
							<td>Prime Contract Scheduled Value:</td>
							<td id="totalPrimeContractScheduledValue" align="right" style="font-weight:bold;">{$formattedLinkedScheduledTotal}</td>
						</tr>
						<tr class="notSortable">
							<td>Forecasted Expenses:</td>
							<td id="totalForecastedExpenses" align="right" style="font-weight:bold;">{$formattedLinkedForecastedTotal}</td>
						</tr>

					{/if}

				</table>
				<input id="linkedScheduledTotal" type="hidden" value="{$linkedScheduledTotal}">
			</td>

			{foreach $arrSubcontractorBidsByGcBudgetLineItemId as $subcontractor_bid_id => $subcontractorBid}

				<td id="manage-subcontractor_bid-record--subcontractor_bids--contactfullName--{$subcontractor_bid_id}" colspan="5" class="rightBorder bidderHeaderDetails">
					{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['contactFullName']}
				</td>

			{/foreach}

		</tr>
		<tr class="notSortable detailsRow">

		{foreach $arrSubcontractorBidsByGcBudgetLineItemId as $subcontractor_bid_id => $subcontractorBid}

			<td colspan="5" class="rightBorder bidderHeaderDetails" style="text-align:center; padding:0; vertical-align:top;">
				<table border="0" style="margin: 0 auto;">

				{foreach $arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['contactPhoneNumbers'] as $contact_phone_number_id => $contactPhoneNumber}

					<tr class="notSortable">
						<td id="manage-subcontractor_bid-record--subcontractor_bids--contactPhoneNumberType--{$subcontractor_bid_id}">
							{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['contactPhoneNumbers'][$contact_phone_number_id]['phone_number_type']}
						</td>
						<td id="manage-subcontractor_bid-record--subcontractor_bids--contactFormattedPhoneNumber--{$subcontractor_bid_id}">
							{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['contactPhoneNumbers'][$contact_phone_number_id]['formattedNumber']}
						</td>
					<tr>

				{/foreach}

					<tr class="notSortable">
						<td>Email</td>
						<td><a id="manage-subcontractor_bid-record--subcontractor_bids--contact_email--{$subcontractor_bid_id}" href="mailto:{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['contact_email']}">
							{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['contact_email']}
						</a></td>
					</tr>
				</table>
			</td>

		{/foreach}

		</tr>
		<tr class="notSortable">
			<th colspan="3" class="rightBorder permissionTableMainHeader" style="text-align:left;">Bid Spread Items</th>

			{foreach $arrSubcontractorBidsByGcBudgetLineItemId as $subcontractor_bid_id => $subcontractorBid}

				<th class="permissionTableMainHeader">Qty</th>
				<th class="permissionTableMainHeader">Unit</th>
				<th class="permissionTableMainHeader">Unit Price</th>
				<th class="permissionTableMainHeader">Total</th>
				<th class="rightBorder permissionTableMainHeader"><input type="checkbox" rel="tooltip" title="Toggle all" onclick="toggleAllExcludeCheckboxesInColumn(this, '{$subcontractor_bid_id}');"></th>

			{/foreach}

		</tr>

		{foreach $arrBidItemsByProjectBudLineItemId as $bid_item_id => $bidItem}

			<tr id="{$arrBidItemsTemplateVars[$bid_item_id]['bidItemElementId']}" class="rowBidItems {$arrBidItemsTemplateVars[$bid_item_id]['subtotalRow']}">
			<td class="spread-td tdSortBars textAlignCenter">
				<img src="/images/sortbars.png" rel="tooltip" title="Drag bars to change sort order">
				<input type="hidden" id="manage-bid_item-record--bid_items--sort_order--{$bid_item_id}" value="{$arrBidItemsTemplateVars[$bid_item_id]['sort_order']}">
			</td>
			<td class="spread-td">
				<input id="manage-bid_item-record--bid_items--bid_item--{$bid_item_id}" type="text" tabIndex="{$arrBidItemsTemplateVars[$bid_item_id]['tabIndex']}"
				class="bid_item" value="{$arrBidItemsTemplateVars[$bid_item_id]['bid_item']}" onchange="Subcontractor_Bid_Spreadsheet__updateBidItem(this, \{ bid_item_id : {$bid_item_id} \});">
			</td>
			<td class="spread-td rightBorder textAlignCenter">
				<a href="javascript:confirmDeleteBidItem('{$arrBidItemsTemplateVars[$bid_item_id]['bidItemElementId']}', 'manage-bid_item-record', '{$bid_item_id}');" rel="tooltip" title="Delete This Bid Item Row">X</a>
			</td>

			{foreach $arrSubcontractorBidIds as $subcontractor_bid_id}

				<td class="spread-td">
					<input
						id="{$attributeGroupName}--bid_items_to_subcontractor_bids--item_quantity--{$subcontractor_bid_id}-{$bid_item_id}"
						type="text"
						tabIndex="{$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['tabIndex']}"
						class="item_quantity number-only {$arrBidItemsTemplateVars[$bid_item_id]['hidden']}"
						value="{$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['item_quantity']}"
						onchange="Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBid('{$attributeGroupName}', '{$subcontractor_bid_id}-{$bid_item_id}', { element: this });">
				</td>
				<td class="spread-td">
					<input
						id="{$attributeGroupName}--bid_items_to_subcontractor_bids--unit--{$subcontractor_bid_id}-{$bid_item_id}"
						type="text"
						tabIndex="{$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['tabIndex']}"
						class="unit {$arrBidItemsTemplateVars[$bid_item_id]['hidden']}"
						value="{$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['unit']}"
						onchange="Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBid('{$attributeGroupName}', '{$subcontractor_bid_id}-{$bid_item_id}', { element: this });">
				</td>
				<td class="spread-td">
					<input
						id="{$attributeGroupName}--bid_items_to_subcontractor_bids--unit_price--{$subcontractor_bid_id}-{$bid_item_id}"
						type="text"
						tabIndex="{$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['tabIndex']}"
						class="unit_price number-only {$arrBidItemsTemplateVars[$bid_item_id]['hidden']}"
						value="{$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['unit_price']}"
						onchange="Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBid('{$attributeGroupName}', '{$subcontractor_bid_id}-{$bid_item_id}', { element: this });">
				</td>
				<td class="spread-td">
					<input
						id="{$attributeGroupName}--bid_items_to_subcontractor_bids--unitTotal--{$subcontractor_bid_id}-{$bid_item_id}"
						type="text"
						class="unitTotal unitTotal--{$subcontractor_bid_id} {$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['exclude']} {$arrBidItemsTemplateVars[$bid_item_id]['subtotalInput']}"
						value="{$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['unitTotal']}"
						onchange="Subcontractor_Bid_Spreadsheet__updateBidTotalSummarySection('{$subcontractor_bid_id}')"
						readonly>
				</td>
				<td class="spread-td rightBorder">
					<input
						id="{$attributeGroupName}--bid_items_to_subcontractor_bids--exclude_bid_item_flag--{$subcontractor_bid_id}-{$bid_item_id}"
						type="checkbox"
						tabIndex="{$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['tabIndex']}"
						class="exclude_bid_item_flag exclude_bid_item_flag--{$subcontractor_bid_id} {$arrBidItemsTemplateVars[$bid_item_id]['subtotalInput']}"
						value="{$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['exclude_bid_item_flag']}"
						onclick="Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBid('{$attributeGroupName}', '{$subcontractor_bid_id}-{$bid_item_id}', { element: this });"
						rel="tooltip"
						title="Exclude This Item From Totals"
						{$arrBidItemsTemplateVars[$bid_item_id][$subcontractor_bid_id]['excludeBidItemFlagChecked']}>
				</td>

			{/foreach}

			</tr>

		{/foreach}

		<tr class="notSortable">
			<th colspan="3" class="rightBorder" style="text-align:left;">Total</th>

			{foreach $arrSubcontractorBidIds as $subcontractor_bid_id}

				<th class="thPreferredSubcontractor--{$subcontractor_bid_id} {$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['preferredSubTdClass']} textAlignLeft" colspan="3">
					<input
						id="{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['radioButtonElementId']}"
						type="radio"
						name="preferredSubcontractor"
						class="input-preferred-sub{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['checkboxClass']}"
						onchange="updateSubcontractorBid(this);"
						{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['checked']}>
					<label for="{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['radioButtonElementId']}" class="labelPreferedSubcontractor">Preferred Subcontractor</label>
					<a
						class="preferred-sub-link {$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['hidden']}"
						href="javascript:openSubcontractsDialog('{$gc_budget_line_item_id}', '{$cost_code_division_id}', '{$cost_code_id}', '{$subcontractor_bid_id}');">Subcontract</a>
				</th>
				<th class="thPreferredSubcontractor--{$subcontractor_bid_id} {$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['preferredSubTdClass']}">
					<input
						id="derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--{$subcontractor_bid_id}"
						type="text"
						class="input-unit-total bidder-total"
						value="{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['formattedTotal']}"
						readonly>
				</th>
				<th class="thPreferredSubcontractor--{$subcontractor_bid_id} rightBorder {$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['preferredSubTdClass']}">&nbsp;</th>

			{/foreach}

		</tr>
		<tr class="notSortable">
			<th colspan="3" class="rightBorder" style="text-align:left;">Variance [PCSV - (FE + Bid)]</th>

			{foreach $arrSubcontractorBidIds as $subcontractor_bid_id}

				<th colspan="3" style="text-align:right;">&nbsp;</th>
				<th>
					<input
						id="variance_ttl-{$subcontractor_bid_id}"
						type="text"
						class="input-unit-total bidder-total {$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['totalStyle']}"
						value="{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['formattedVariance']}"
						readonly>
				</th>
				<th class="rightBorder">&nbsp;</th>

			{/foreach}

		</tr>
		<tr class="notSortable">
			<th colspan="3" class="rightBorder" style="text-align:left;" nowrap>Cost Per Sq. Ft ({number_format($project_square_footage,0)})</th>

			{foreach $arrSubcontractorBidIds as $subcontractor_bid_id}

				<td colspan="4" align="right">
					<input
						id="subcontractorBidTotalCostPerGrossSquareFoot--{$subcontractor_bid_id}"
						type="text"
						class="input-unit-total bidder-total"
						value="{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['totalPerSquareFoot']}"
						readonly>
				</td>
				<td class="rightBorder">&nbsp;</td>

			{/foreach}

		</tr>
		<tr class="notSortable">
			<th colspan="3" class="rightBorder" style="text-align:left;" nowrap>Net Rentable Sq. Ft</th>

			{foreach $arrSubcontractorBidIds as $subcontractor_bid_id}

				<td colspan="4" align="right"><input type="text" class="totals" readonly></td>
				<td class="rightBorder">&nbsp;</td>

			{/foreach}

		</tr>
		<tr class="notSortable">
			<th colspan="3" class="rightBorder" style="text-align:left;" nowrap>Cost Per Unit ({number_format($project_unit_count,0)})</th>

			{foreach $arrSubcontractorBidIds as $subcontractor_bid_id}

				<td colspan="4" align="right">
					<input id="ttlPerUnit-{$subcontractor_bid_id}"
						type="text"
						class="input-unit-total bidder-total"
						value="{$arrSubcontractorBidsTemplateVars[$subcontractor_bid_id]['totalPerUnit']}"
						readonly>
				</td>
				<td class="rightBorder">&nbsp;</td>

			{/foreach}

		</tr>
	</table>
</div>


<input id="gc_budget_line_item_id" type="hidden" value="{$gc_budget_line_item_id}">
<input id="project_id" type="hidden" value="{$currentlySelectedProjectId}">
<input id="cost_code_division_id" type="hidden" value="{$cost_code_division_id}">
<input id="cost_code_id" type="hidden" value="{$cost_code_id}">
<input id="subcontrator_bid_spread_reference_data-project-record--projects--gross_square_footage--{$currentlySelectedProjectId}" type="hidden" value="{$project_gross_square_footage}">
<input id="subcontrator_bid_spread_reference_data-project-record--projects--net_rentable_square_footage--{$currentlySelectedProjectId}" type="hidden" value="{$project_net_rentable_square_footage}">
<input id="subcontrator_bid_spread_reference_data-project-record--projects--unit_count--{$currentlySelectedProjectId}" type="hidden" value="{$project_unit_count}">
<input id="csvPreferredSubcontractorBidIds" type="hidden" value="{$csvPreferredSubcontractorBidIds}">

<input id="openModal" type="hidden" value="{$openModal}">
<input id="bid_spread_id" type="hidden" value="{$bid_spread_id}">
<input id="active_bid_spread_id" type="hidden" value="{$active_bid_spread_id}">
<input id="selected_bid_spread_id" type="hidden" value="-1">
<input id="selected_bid_spread_status_id" type="hidden" value="-1">
<input id="modal_bid_spread_sequence_number" type="hidden" value="{$bid_spread_sequence_number}">
<input id="csvSubcontractorBidIds" type="hidden" value="{$csvSubcontractorBidIds}">

<div id="messageDiv" class="userMessage"></div>
<div id="divModalWindow" rel="tooltip" title="">&nbsp;</div>
<div id="divBidSpreadApprovalProcessDialog" class="hidden"></div>

<script>
	var arrBidSpreadStatuses = {$jsonBidSpreadStatuses};
</script>