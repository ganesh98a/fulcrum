<div id="div_permission" class="custom_delay_padding grid_view custom_datatable_style">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
			<div style="float:left;width:100%;margin-bottom:5px;">
	<!--<input type="button" class="addpermission" onclick="ManageRoles();"  value="Add Role and Permission" style="margin-bottom:15px"> -->
	<input type="button" class="addpermission" onclick="showcreateRoleDialog();" value="Create Role" style="margin-bottom:15px">
	<input type="hidden" id="lastroleid" value={$roleCount}>

	

	
	</div>
	<div id="perTable" class="perlist" style="float:left;display:block;margin-right: 10px;" width="100%">
	<!-- <span><img class="datepicker datedivseccal_icon_gk" alt="" src="../../images/filter.png" id="dp1557294692941" width="20"></span> -->
	{$perTable}</div>
	<div id="alpah" class="perlist" style="font-weight: bold;color: #3b90ce;float:left;font-size:12px;"> {$alphabetarrange} </div>

	<div id="mainlist" style="margin-top:20px;float:left;" class="perlist">
	<!--{$permissiongrid}-->
	</div> 
	

	<div id="wholemanage">
	<div id="manageRole" class="select-role manageRole" style="display:none;">
	{if (isset($globalAccess)) && ($globalAccess=='1') }
	<!--{$allCompany}-->
	{/if}
	<div class="" style="float:left;width: 13%;">
	<p class="subhead">Select role</p>
	</div>
	<div class="" style="float:left;width: 87%;">
	<div class="topselect">
	{$roleListTable}
	</div>
	</div>
	<div class="block-section roleSet" style="display:none;">
	<p class="main-head">Selected role(s)</p>
	<div id="role_items" class="block-section m-t-10 m-b-0"></div>
	</div>

	<div class="block-section">	
	<div class="" style="float:left;width: 13%;">
	<p class="subhead">Select module</p>
	</div>
	<div class="" style="float:left;width: 87%;">
	<div id="soft_role" class="topselect">
	{$roleWithModule}
	</div>
	</div>
	<div id="mod_role" class="block-section"></div>
	</div>

	<div class="block-section" style="text-align:right;">
	<input type="button" onclick="showback();" id="backrol" value="Cancel" style="margin-bottom:15px;margin-right:10px;background:#8e979e;">
	<input type="button" class="persave" onclick="saveRoleAndPermission('{$globalAccess}');" value="Save" style="margin-bottom:15px;"> </div>

	</div></div>   <!-- manage role div -->

	<div id="divCreateRole" class="modal"></div>

	
	<div id="viewsubchange" class="modal"></div>

	<div id="dialog-confirm"></div>
	{/if}
</div>
	
