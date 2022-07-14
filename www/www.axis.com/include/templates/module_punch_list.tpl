<div id="punch_list" class="custom_delay_padding grid_view custom_datatable_style">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
		<div>
	</div>
	<div id="punchlist">{$punchlist}</div>
	<div id="divpunchlist" class="hidden"></div>

	
	<div id="viewpunchlist" class="modal"></div>

	<div id="dialog-confirm"></div>
	{/if}
</div>
	
