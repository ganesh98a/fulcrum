<div id="div_permission" class="custom_delay_padding grid_view custom_datatable_style">
	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
		<b>Accounting Portal:</b>
		{$accountingportals}
		<div class="quickbooks {$quickbooksclass}">
			<div class="process-step">
				<div class="line"></div>
				{$stepsactive}
			</div>
			{$stepstoconnectqb}
			{$accountingTable}
		</div>
		<div class="panel panel-default">
			<div class="panel-heading ledger-header">
				General ledger mapping
				<span style="margin-left:50px;">
					<a href="javascript:void(0);" id="getAccounts" title="Click to Get the Accounts" style="display: inline-block; margin-bottom: 0; -ms-touch-action: manipulation; touch-action: manipulation; cursor: pointer; border: 1px solid transparent; border-radius: 4px; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;"><img src="/images/refresh_icon.png" style="height:25px; width:25px;"></a> Get Accounts from <img src="/images/QBOlogo.png" style="height: 25px;width:25px;vertical-align: top;" title="QB" alt="QB"> <img src="/images/buttons/button-info.png" style="height: 12px;width: 16px;vertical-align: top;" class="show_info_txt">
						<div class="dropdown-content-change-order">Sync Accounts of type Other Current Assets from QuickBooks to fulcrum.</div>
				</span>
			</div>
			<div class="panel-body" >
				<table class="ledger-table">
					<thead class="borderBottom">
						<tr>
							<th class="textAlignLeft" style="width:65%">Subcontract Template</th>
							<th class="textAlignLeft">GL Account</th>
						</tr>
					</thead>
					<tbody id="general_ledger">
						<tr>
							<td style="text-align:center;" colspan="2">Loading GL Account Details</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>   <!-- manage role div -->
	{/if}
</div> 