<div id="dcr" style="width: 1150px;">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableDateSelection">

		<tr>
		<td width="16%" rowspan="2">
			<select id="ddlDate" onchange="ddlDateChanged();" style="margin-right:15px">
				<option value="0">{$today}</option>
				<option value="1">{$yesterday}</option>
				<option value="2">{$twoDaysAgo}</option>
			</select>
		</td>
		<td width="25%" align="left"><span class="daliyStat">CREATED BY:</span><span id="created_by" class="dalmod"> {$createdBy}</span></td>
		<td width="24%" align="left"><span class="daliyStat">CREATED ON:</span><span id="createdAt" class="dalmod"> {$createdAt}</span></td>
		<td width="15%" align="left"><span>AM TEMP:</span> {$amTemperature}</td>
		<td width="25%" align="left"><span>AM CONDITION:</span> {$amCondition}</td>
		</tr>

		<tr>
		<td align="left"><span class="daliyStat">MODIFIED BY:</span> <span id="modified_by" class="dalmod">{$modifiedBy}</span></td>
		<td align="left" nowrap><span class="daliyStat">MODIFIED ON:</span><span id="modified_on" class="dalmod"> {$modifiedAt}</span>&nbsp;&nbsp;</td>
		<td align="left"><span>PM TEMP:</span> {$pmTemperature}</td>
		<td align="left"><span>PM CONDITION:</span> {$pmCondition}</td>
		</tr>

	</table>
	<div class="divTabs">
		<ul>
			<li><a id="manpowerTab" class="tab {$manpowerSelected}" onclick="tabClicked(this, '1');">Manpower</a></li>
			<li><a id="siteworkTab" class="tab {$siteworkSelected}" onclick="tabClicked(this, '2');">Sitework</a></li>
			<li><a id="buildingTab" class="tab {$buildingSelected}" onclick="tabClicked(this, '3');">Building</a></li>
			<li><a id="detailsTab" class="tab {$detailsSelected}"  onclick="tabClicked(this, '4');">Details</a></li>
			{if (isset($userCanDcrReport) && $userCanDcrReport) }
			<li><a id="dcrPreviewTab" class="tab {$previewSelected}"  onclick="tabClicked(this, '5');">DCR Preview</a></li>
			{/if}
{if (isset($displayJobsiteDailyLogAdminTab) && $displayJobsiteDailyLogAdminTab) }
			<li><a id="adminTab" class="tab {$adminSelected}" onclick="tabClicked(this, '6');">Admin</a></li>
{/if}
			{*<li class="tabRightSide"><a class="tab {$adminSelected}" onclick="tabClicked(this, '6');">Admin</a></li>*}
		</ul>
	</div>
	<div id="tabContent">
		{$tabContent}
	</div>
	<input type="hidden" id="selectedDateIndex" value="{$selectedDateIndex}">
	<input type="hidden" id="jobsite_daily_log_id" value="{$jobsite_daily_log_id}">
	<input type="hidden" id="activeTab" value="{$activeTab}">

	{$fineUploaderTemplate}
{/if}
</div>
