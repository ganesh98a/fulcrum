<div id="sub_change_order" class="custom_delay_padding grid_view custom_datatable_style">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
		<div style="text-align: right;">
	
		<span>		
		<a tabindex="52" href="/modules-submittals-registry-form.php">Export registry items</a> |
		<a tabindex="52" href="javascript:void(0)" onclick="loadImportCostCodesIntoBudgetDialog('submittal_regitry'); return false;">Import registry items</a> | 
		<a tabindex="52" href="javascript:void(0)" onclick="Submittalsregistry__loadCreateSuDialog(null);setTimeout('Submittals__automaticRecipient({$primary_contact_id},\'{$primary_name}\')', 2000);" >Add registry item +</a>
		</span>
	</div><br />
	<div id="OrderTable">{$OrderTable}</div>
	<div id="divCreateOrder" class="hidden"></div>
	<div id="divCreateSuRe" class="hidden"></div>
	<div id="divModalWindow" class="hidden" style=""></div>
	<input type="hidden" id="active_change_order_id" value="">
	<input type="hidden" id="active_change_order_draft_id" value="">
	<input type="hidden" id="active_change_order_notification_id" value="">
	
	<div id="viewsubchange" class="modal"></div>

	<div id="dialog-confirm"></div>
	{/if}
</div>
	
