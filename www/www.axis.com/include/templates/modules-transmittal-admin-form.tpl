<div id="TAMs">
	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
	{/if}
	<div id="TAMsDetails"></div>
	<div class="TAMTableGrid" id="TAMTableGrid">
	{$TAMTable}
	</div>
</div>
