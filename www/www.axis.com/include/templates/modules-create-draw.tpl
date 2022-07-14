<div id="draws_list" class="custom_delay_padding grid_view custom_datatable_style">
  {if (isset($htmlMessages)) && !empty($htmlMessages) }
  <div>{$htmlMessages}</div>
  {else}
   <!-- Application Number:
   Through Date: -->
   <div class="paymentapp-detail">
      <input type="hidden" value="{$drawId}" id="manage_draw--draw_id">
      <input type="hidden" value="{$applicationId}" id="manage_draw--draw_app_id">
      <div class="gridview">
        <div id="createDrawForm" class="appdetail">
        {$createDrawForm}
      </div>
  <div id="completion-percentage-confirm"></div>
      </div>
      <div class="signblock">
       {if (isset($type)) && !empty($type) }
       <h3>Retention Signature Blocks</h3>
       {else}
        <h3>Draw Signature Blocks</h3>
        {/if}
        {$signatureDrawContent}
      </div>
   </div>
  {/if}
</div>
<div id="dialog-confirmation"></div>

