<div id="SUBMITTAL">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
	<div>
		{if ($userCanManageSubmittals) }
		 <input type="button" onclick="Submittals__loadCreateSuDialog(null);setTimeout('Submittals__automaticRecipient({$primary_contact_id},\'{$primary_name}\')', 2000);" value="Create A New Submittal" style="margin-bottom:15px">
		 <span style="padding: 0 20px;">or</span>

		 <span id="subDraftDropDown">{$ddlSubmittalDrafts}</span>
		 <span style="padding: 0 20px;">&nbsp;</span>
		{/if}

		<!--span style="padding: 0 20px;">&nbsp;</span>
		<span class="fakeHref" onclick="Submittals__generateSubmittalsListViewPdf();"><img src="/images/printer.gif" style="vertical-align: top;"> Print Submittal List as PDF</span>
		<span style="padding: 0 20px;">&nbsp;</span-->
		<select onchange="Submittals__performAction(this);">
			<option value="-1">Submittal Actions</option>
			<option value="print_list_view_pdf">Print Submittal List as PDF</option>
		</select>

		<a tabindex="52" href="/modules-submittals-registry-form.php">Submittal Registry</a>

	</div>
	<div id="suTable">{$suTable}</div>
	<div id="suDetails">{$suDetails}</div>
	<div id="divCreateSu" class="hidden"></div>
	<input type="hidden" id="active_submittal_id" value="">
	<input type="hidden" id="active_submittal_draft_id" value="">
	<input type="hidden" id="active_submittal_notification_id" value="">
	<div id="dialog-confirmation"></div>
	{/if}
</div>
