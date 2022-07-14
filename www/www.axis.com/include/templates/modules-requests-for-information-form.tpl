<div id="RFI">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
	{if ($userCanManageRFIs) }
	<div>
		<input type="button" onclick="RFIs__loadCreateRfiDialog(null);setTimeout('RFIs__automaticRecipient({$primary_contact_id},\'{$primary_name}\')', 2000);" value="Create A New RFI" style="margin-bottom:15px">
		<span style="padding:0 20px">or</span>
		<span id="rfiDraftDropDown">{$ddlRequestForInformationDrafts}</span>
	</div>
	{/if}
	
	<div id="rfiTable">{$rfiTable}</div>
	<div id="rfiDetails">{$rfiDetails}</div>
	<div id="divCreateRfi" class="hidden"></div>
	<input type="hidden" id="active_request_for_information_id" value="">
	<input type="hidden" id="active_request_for_information_draft_id" value="">
	<input type="hidden" id="active_request_for_information_notification_id" value="">
	<div id="dialog-confirmation"></div>
	{/if}

</div>
