<div id="div_permission" class="custom_delay_padding grid_view custom_datatable_style">
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{else}
	

	<div style="float:left;width:100%;margin-bottom:5px;">
		<input type="hidden" id="lastroleid" value={$roleCount}>	
	</div>
	
	<div id="perTable" class="perlist" style="float:left;display:block;margin-right: 10px;" width="100%">
	<!-- <span><img class="datepicker datedivseccal_icon_gk" alt="" src="../../images/filter.png" id="dp1557294692941" width="20"></span> -->
	{$perTable}</div>
	<div id="alpah" class="perlist" style="font-weight: bold;color: #3b90ce;float:left;font-size:12px;"> {$alphabetarrange} </div>
	<div style="float:left;display:block;margin-left:10px;" width="100%">
		<input id="btnResetPermissions" type="button" value="Reset To System Default Permissions" onclick="projectNonSpecificResetDefaultPermissions();">
	</div>
	<!-- <option value='Y' style="color:#3b90ce;">Project Specific</option>
	<option value='N' style="color:#999999;">Not Project Specific</option> -->

	<div id="mainlist" style="margin-top:20px;float:left;" class="perlist">
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
	<p class="subhead">Select module </p>
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
	<br>
	<!-- for grid -->
	<div id="PermissionsBasedonContact"></div>
	
	<!--For team member adding -->
	<div id="divAddTeamMembers" style="width:1000px;clear: both;">
	<br>
	<table class="permissionTable table-team-members" >
	<tr>
	<th class="permissionTableMainHeader">Add New Team Members</th>
	</tr>
	<tr>
	<td>
	<table class="table-contact-roles" width="100%">
	<tr>
	<td id="teamManagement" class="contact-search-parent-container">
	{$permissionsSearchForm}
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	</div>
	
	<!--For team member listing -->
	<!--<div class="divTabs">
		<ul>
			<li><a id="teamTab" class="tab {$teamSelected}" onclick="tabClicked(this, '1');">Team</a></li>
			<li><a id="subcontractorsTab" class="tab {$subcontractorsSelected}" onclick="tabClicked(this, '2');">Subcontractors</a></li>
			<li><a id="biddersTab" class="tab {$biddersSelected}" onclick="tabClicked(this, '3');">Bidders</a></li>		
		</ul>
	</div>-->

	<!--For team member adding -->
	<!--<div id="divProjectContactList" style="width: 1000px;"></div>-->

<input type="hidden" id="activeTab" value="{$activeTab}">
<input type="hidden" id="userRole" value="{$userRole}">
	{/if}
</div>
	
