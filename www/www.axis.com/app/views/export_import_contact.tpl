<div id="div_permission" class="custom_delay_padding grid_view custom_datatable_style">
	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
		<div class="row">
			<div class="col-md-12">
				{$importHtmlContent}
			</div>
		</div
		
	</div>   <!-- manage role div -->
    {/if}
</div>