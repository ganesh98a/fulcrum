{*strip*}
{if isset($showProjectNavBox) && $showProjectNavBox}
	<div id="navBoxProject" class="sidebarBox projectNavBox">
		<div class="arrowlistmenu">
			{if count($arrActiveProjects) > 0}
				<input type="hidden" id="actcurprj" value="{$currentlySelectedProjectName}">
				{if $currentlySelectedProjectTypeIndex == 0}
					<div class="menuheader expandable {$menuActiveClass}">Active Projects</div>
					<div id="0_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();">{$currentlySelectedProjectName|escape|truncate:27}<span style="margin-left:5%;"/></div>
					<ul class="categoryitems" {$cssDisplay}>
				{else}
					<div class="menuheader expandable">Active Projects</div>
					<div id="0_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();">{$currentlySelectedProjectName|escape|truncate:27}</div>
					<ul class="categoryitems">
				{/if}
					{foreach from=$arrActiveProjects key=project_id item=projectName}
						{if $currentlySelectedProjectId != $project_id}
							<li onclick="navigationProjectSelected(0, '{$project_id}', '{$projectName|escape:'url'}');"><a class="projectLinks" href="javascript:void(0);" data-groupIndex = "0" data-project_id ='{$project_id}' data-encodedProjectName = '{$projectName|escape:'url'}'>{$projectName|truncate:27}</a></li>
						{/if}
					{/foreach}
				</ul>
			{/if}
			{if count($arrBiddingProjects) > 0}
				{if $currentlySelectedProjectTypeIndex == 1}
					<div class="menuheader expandable {$menuActiveClass}">Bidding Projects</div>
					<div id="1_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();">{$currentlySelectedProjectName|escape|truncate:27}<span style="margin-left:5%;"/></div><!-- <img alt="" src="/images/navigation/left-nav-arrow-green.gif"> -->
					<ul class="categoryitems" {$cssDisplay}>
				{else}
					<div class="menuheader expandable">Bidding Projects</div>
					<div id="1_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();">{$currentlySelectedProjectName|escape|truncate:27}</div>
					<ul class="categoryitems" >
				{/if}
				
					{foreach from=$arrBiddingProjects key=project_id item=projectName}
						{if $currentlySelectedProjectId != $project_id}
							<li onclick="navigationProjectSelected(1, '{$project_id}', '{$projectName|escape:'url'}');"><a class="projectLinks" href="javascript:void(0);" data-groupIndex = "1" data-project_id ='{$project_id}' data-encodedProjectName = '{$projectName|escape:'url'}'>{$projectName|truncate:27}</a></li>
						{/if}
					{/foreach}
				</ul>
			{/if}
			{if count($arrCompletedProjects) > 0}
				{if $currentlySelectedProjectTypeIndex == 2}
					<div class="menuheader expandable {$menuActiveClass}">Completed Projects</div>
					<div id="2_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();">{$currentlySelectedProjectName|escape|truncate:27}<span style="margin-left:5%;"/></div>
					<ul class="categoryitems" {$cssDisplay}>
				{else}
					<div class="menuheader expandable">Completed Projects</div>
					<div id="2_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();">{$currentlySelectedProjectName|escape|truncate:27}</div>
					<ul class="categoryitems" >
				{/if}
				
					{foreach from=$arrCompletedProjects key=project_id item=projectName}
						{if $currentlySelectedProjectId != $project_id}
							<li onclick="navigationProjectSelected(2, '{$project_id}', '{$projectName|escape:'url'}');"><a class="projectLinks" href="javascript:void(0);" data-groupIndex = "2" data-project_id ='{$project_id}' data-encodedProjectName = '{$projectName|escape:'url'}'>{$projectName|truncate:27}</a></li>
						{/if}
					{/foreach}
				</ul>
			{/if}
			{if count($arrOtherProjects) > 0 }
				{if $currentlySelectedProjectTypeIndex == 3}
					<div class="menuheader expandable {$menuActiveClass}">Other Projects</div>
					<div id="3_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();">{$currentlySelectedProjectName}<span style="margin-left:5%;"/></div>
				<ul class="categoryitems" {$cssDisplay}>
				{else}
					<div class="menuheader expandable">Other Projects</div>
					<div id="3_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();">{$currentlySelectedProjectName}</div>
				<ul class="categoryitems" >
				{/if}				
					{foreach from=$arrOtherProjects key=project_id item=projectName}
						{if $currentlySelectedProjectId != $project_id}
							<li onclick="navigationProjectSelected(3, '{$project_id}', '{$projectName|escape:'url'}');"><a class="projectLinks" href="javascript:void(0);" data-groupIndex = "3" data-project_id ='{$project_id}' data-encodedProjectName = '{$projectName|escape:'url'}'>{$projectName|truncate:27}</a></li>
						{/if}
					{/foreach}
				</ul>
			{/if}
		</div>
	</div>
	<div class="leftNavSpacer">&nbsp;</div>
{/if}
{*/strip*}
