<div id="punch_card" class="custom_delay_padding grid_view custom_datatable_style">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
		<div>

		{if ($userCanManagePunch) }
		<input type="button" onclick="CreateDefectsDialog(null);" value="Create Defects" style="margin-bottom:15px">	
		
			
		{/if}

		
	</div>
	<div style="margin:20px;" ></div>
	<div id="defectTable">{$buildDefectTable}</div>
	<div id="divCreatepunch" class="modal hidden"></div>
	<div id="divdefect" class="modal"></div>
	<div id="dataTable"></div>
	<div id="myconsole"></div>
	
	
	{/if}
</div>
