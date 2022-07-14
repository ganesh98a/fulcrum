<div id="Tranmittals" class="custom_delay_padding grid_view custom_datatable_style">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
		<div>

		{if ($userCanManageTransmittal) }
		<input type="button" onclick="CreateTransmittalsDialog(null);" value="Create Transmittal" style="margin-bottom:15px">		
		{/if}

		<!-- <img src="./images/pdfprint.png" width="40px" height="40px" style="float:right; cursor: pointer;" onclick="pdf_generationdelay();"> -->
	</div>
	<div id="TransmittalTable">{$TransmittalTable}</div>
	<div id="divCreateTransmittal" class="hidden"></div>
	
	
	<div id="dialog-confirm"></div>
	{/if}
</div>
	
