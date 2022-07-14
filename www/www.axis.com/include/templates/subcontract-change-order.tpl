<div id="sub_change_order" class="custom_delay_padding grid_view custom_datatable_style">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
		<div>

		{if ($userCanManageSubOrder) }
		<input type="button" onclick="CreateSubChangeOrderDialog(null);" value="Create Subcontract Change Order" style="margin-bottom:15px">		
		{/if}

		<select id="view_status" onchange="gridViewChange()" style="margin-bottom:15px">
			<option value="costcode" selected="">costcode view</option>
			<option value="subcontractor">subcontractor view</option>
		</select>

		<select id="sco_filter" onchange="gridViewChange()" style="margin-bottom:15px">
			<option value="all">All</option>
			<option value="potential">Potential</option>
			<option value="approved">Approved</option>
		</select>

		{if ($userCanManageSubOrder) }
		<input type="button" onclick="downloadSubcontractPDF();" value="Print SCO Lists as PDF" style="margin-bottom:15px">
		{/if}

		<input type="checkbox" name="in_potential" id="in_potential" onclick="gridViewChange()" checked> Total Potential

	
	</div>
	<div id="OrderTable">{$OrderTable}</div>
	<div id="divCreateOrder" class="hidden"></div>
	<div id="divCreateCo" class="hidden"></div>
	<input type="hidden" id="active_change_order_id" value="">
	<input type="hidden" id="active_change_order_draft_id" value="">
	<input type="hidden" id="active_change_order_notification_id" value="">
	
	<div id="viewsubchange" class="modal"></div>

	<div id="dialog-confirm"></div>
	{/if}
</div>
	
