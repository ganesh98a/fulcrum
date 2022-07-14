<div id="draws_list" class="custom_delay_padding grid_view custom_datatable_style">
  {if (isset($htmlMessages)) && !empty($htmlMessages) }
  <div>{$htmlMessages}</div>
  {else}
  {if ($userCanViewDraws) || ($userCanEditDraws) }
  <div id="drawStatusDropdown">{$drawStatus}</div>
  {/if}
  {if ($userCanEditDraws)}
  <input type="button" onclick="checkProjectRetainerRate()" value="Create Draws" style="margin-bottom:15px;margin-left:10px">
   <input type="button" onclick="createRetentionDraw()" value="Create Retention Draw" style="margin-bottom:15px;margin-left:10px">
  {/if}
  {if ($userCanViewDraws) || ($userCanEditDraws) }
  <input type="button" onclick="printDrawList()" value="Print List View" style="margin-bottom:15px">
  {/if}
  <input id="drawDraftCount" value="{$drawDraftCount}" type="hidden">
  <input id="drawRetentionCount" value="" type="hidden">
  <div id="drawListTable" style="max-width: 1080px !important;">{$drawListTable}</div>
  <div id="retainer-rate-confirm"></div>
  {/if}
</div>
<div id="dialog-confirmation"></div>
