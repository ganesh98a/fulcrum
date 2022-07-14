<div id="CHANGE_ORDER">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
	<div>
	{if ($userCanManageChangeOrders) }
		<input type="button" onclick="project_ownerCheck();" value="Create A New Change Order" style="margin-bottom:15px">
		<span style="padding: 0 20px;">or</span>
		{$ddlChangeOrderDrafts}
		<span style="padding: 0 0px;">&nbsp;</span>
		{/if}	
		<!--ChangeOrders__loadCreateCoDialog(null); span style="padding: 0 20px;">&nbsp;</span>
		<span class="fakeHref" onclick="ChangeOrders__generateChangeOrdersListViewPdf();"><img src="/images/printer.gif" style="vertical-align: top;"> Print Change Order List as PDF</span>
		<span style="padding: 0 20px;">&nbsp;</span-->
		<select onchange="ChangeOrders__performAction(this);" style="margin-bottom:15px">
			<option value="-1">Change Order Actions</option>
			<option value="all">Print All Change Orders (PCOs/CORs) As List View PDF</option>
			<option value="cor">Print Change Order Requests (CORs) As List View PDF</option>
			<option value="pco">Print Potential Change Orders (PCOs) As List View PDF</option>
		</select>
		<span style="padding: 0 20px;"><input type="checkbox" name="showreject" id="showreject"> Show Rejected</span>
	</div>
	<div id="dialog-confirm"></div>
	<div id="coTable">{$coTable}</div>
	<div id="coDetails">{$coDetails}</div>
	<div id="divCreateCo" class="hidden">{$createCoDialog}</div>
	<input type="hidden" id="active_change_order_id" value="">
	<input type="hidden" id="active_change_order_draft_id" value="">
	<input type="hidden" id="active_change_order_notification_id" value="">
	{/if}
</div>
