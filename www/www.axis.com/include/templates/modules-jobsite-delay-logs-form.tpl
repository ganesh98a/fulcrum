<div id="Delays" class="custom_delay_padding grid_view custom_datatable_style">
	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}

	<div>

		{if ($userCanManageDelays) }
		<input type="button" onclick="Delays__loadCreateDelayDialog(null);" value="Create Delay" style="margin-bottom:15px">		
		{/if}
		<input type="hidden" id="ManageDelays" name="ManageDelays" value="{$userCanManageDelays}">
		<img src="./images/pdfprint.png" width="40px" height="40px" style="float:right; cursor: pointer;" onclick="pdf_generationdelay();">
	</div>
	<div id="rfiTable" style="display:none;">{$delayTable}</div>
	<div id="divCreateRfi" class="hidden">{$createDelayDialog}</div>
	
	<input type="hidden" id="active_request_for_information_id" value="">
	<input type="hidden" id="active_request_for_information_draft_id" value="">
	<input type="hidden" id="active_request_for_information_notification_id" value="">
	<div id="dialog-confirm"></div>
	{/if}
</div>
