<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

// Debug
//$datasource = 'jobsite_building_activities';
$ddlTertiaryDatasource = '';

$attributeSubgroupName = $datasource;

// Load list of projects into dropdown.
$js = 'onchange="loadImportJobsiteActivitiesTbody(this);"';
$prependedOption = '';
$loadProjectsByUserCompanyIdOptions = new Input();
$loadProjectsByUserCompanyIdOptions->forceLoadFlag = true;
$arrProjectsByUserCompanyId = Project::loadProjectsByUserCompanyId($database, $user_company_id, $loadProjectsByUserCompanyIdOptions);
// Exclude currently selected project.
unset($arrProjectsByUserCompanyId[$project_id]);
$ddlProjectsByUserCompanyId = PageComponents::dropDownListFromObjects('ddlProjects', $arrProjectsByUserCompanyId, 'project_id', null, 'project_name', null, null, '', $js, $prependedOption);
if (count($arrProjectsByUserCompanyId) == 0) {
	$ddlProjectsByUserCompanyId = '<select id="ddlProjects"><option value="">No other projects available</option></select>';
}
$divProjectsDropdown = 'Project: ' . $ddlProjectsByUserCompanyId;

// Load list of jobsite_activity_list_templates into dropdown.
$loadJobsiteActivityListTemplatesByUserCompanyIdOptions = new Input();
$loadJobsiteActivityListTemplatesByUserCompanyIdOptions->forceLoadFlag = true;
$arrJobsiteActivityListTemplatesByUserCompanyId = JobsiteActivityListTemplate::loadJobsiteActivityListTemplatesByUserCompanyId($database, $user_company_id, $loadJobsiteActivityListTemplatesByUserCompanyIdOptions);
$ddlJobsiteActivityListTemplatesByUserCompanyId = PageComponents::dropDownListFromObjects('ddlTemplates', $arrJobsiteActivityListTemplatesByUserCompanyId, 'jobsite_activity_list_template_id', null, 'jobsite_activity_list_template', null, null, '', $js, $prependedOption);
if (count($arrJobsiteActivityListTemplatesByUserCompanyId) == 0) {
	$ddlJobsiteActivityListTemplatesByUserCompanyId = '<select id="ddlTemplates"><option value="">No templates available</option></select>';
}
$divTemplatesDropdown = 'Template: ' . $ddlJobsiteActivityListTemplatesByUserCompanyId;

if ($datasource == 'jobsite_building_activities') {

	// Load template data of an arbitrarily selected project.
	$arrJobsiteBuildingActivitiesByProjectId = array();
	if (count($arrProjectsByUserCompanyId) > 0) {
		$defaultProject = reset($arrProjectsByUserCompanyId);
		$default_project_id = $defaultProject->project_id;

		$loadJobsiteBuildingActivitiesByProjectIdOptions = new Input();
		$loadJobsiteBuildingActivitiesByProjectIdOptions->filterByCostCode = null;
		$loadJobsiteBuildingActivitiesByProjectIdOptions->forceLoadFlag = true;
		$loadJobsiteBuildingActivitiesByProjectIdOptions->extendedReturn = true;
		$arrTmp = JobsiteBuildingActivity::loadJobsiteBuildingActivitiesByProjectId($database, $default_project_id, $loadJobsiteBuildingActivitiesByProjectIdOptions);

		$arrJobsiteBuildingActivitiesByProjectId = $arrTmp['jobsite_building_activities_by_project_id'];
	}

	$arrJobsiteActivities = $arrJobsiteBuildingActivitiesByProjectId;
	$attributeName = 'jobsite_building_activity_label';
	$primaryDatasource = 'building';

} elseif ($datasource == 'jobsite_offsitework_activities') {

	// Load template data of an arbitrarily selected project.
	$arrJobsiteOffsiteworkActivitiesByProjectId = array();
	if (count($arrProjectsByUserCompanyId) > 0) {
		$defaultProject = reset($arrProjectsByUserCompanyId);
		$default_project_id = $defaultProject->project_id;

		$loadJobsiteOffsiteworkActivitiesByProjectIdOptions = new Input();
		$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
		$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
		$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->extendedReturn = true;
		$arrTmp = JobsiteOffsiteworkActivity::loadJobsiteOffsiteworkActivitiesByProjectId($database, $default_project_id, $loadJobsiteOffsiteworkActivitiesByProjectIdOptions);

		$arrJobsiteOffsiteworkActivitiesByProjectId = $arrTmp['jobsite_offsitework_activities_by_project_id'];
	}

	$arrJobsiteActivities = $arrJobsiteOffsiteworkActivitiesByProjectId;
	$attributeName = 'jobsite_offsitework_activity_label';
	$primaryDatasource = 'offsitework';

} elseif ($datasource == 'jobsite_sitework_activities') {

	// Load template data of an arbitrarily selected project.
	$arrJobsiteSiteworkActivitiesByProjectId = array();
	if (count($arrProjectsByUserCompanyId) > 0) {
		$defaultProject = reset($arrProjectsByUserCompanyId);
		$default_project_id = $defaultProject->project_id;

		$loadJobsiteSiteworkActivitiesByProjectIdOptions = new Input();
		$loadJobsiteSiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
		$loadJobsiteSiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
		$loadJobsiteSiteworkActivitiesByProjectIdOptions->extendedReturn = true;
		$arrTmp = JobsiteSiteworkActivity::loadJobsiteSiteworkActivitiesByProjectId($database, $default_project_id, $loadJobsiteSiteworkActivitiesByProjectIdOptions);

		$arrJobsiteSiteworkActivitiesByProjectId = $arrTmp['jobsite_sitework_activities_by_project_id'];
	}

	$arrJobsiteActivities = $arrJobsiteSiteworkActivitiesByProjectId;
	$attributeName = 'jobsite_sitework_activity_label';
	$primaryDatasource = 'sitework';

}

$jobsiteActivitiesTableTbody = '';
foreach ($arrJobsiteActivities as $jobsite_activity_id => $jobsiteActivity) {
	$jobsite_activity_label = $jobsiteActivity->$attributeName;
	$containerElementId = 'record_container--'.$attributeSubgroupName.'--'.$attributeName.'--'.$jobsite_activity_id;
	$checkboxElementId = 'checkbox--'.$jobsite_activity_id;
	$jobsiteActivitiesTableTbody .= <<<END_HTML_ROW
<tr id="$containerElementId">
	<td class="textAlignCenter"><input id="$checkboxElementId" type="checkbox" value="$jobsite_activity_id"></td>
	<td><label for="$checkboxElementId" style="float:none; text-align: left; padding-top:0">$jobsite_activity_label</label></td>
</tr>
END_HTML_ROW;
}

if (count($arrJobsiteActivities) == 0) {
	$jobsiteActivitiesTableTbody = '<tr><td colspan="2">No data.</td></tr>';
}

$htmlContent = <<<END_HTML_CONTENT
<div style="font-size: 0.9em;">
	<div style="margin-top:15px">
		Source:
		<input type="radio" id="rbProject" name="rbDatasource" value="projects" style="margin-left:20px" onchange="rbDatasourceClicked(this);" checked>
		<label for="rbProject" style="float:none; padding:2px 25px 2px 2px;">Project</label>
		<input type="radio" id="rbTemplate" name="rbDatasource" value="templates" onchange="rbDatasourceClicked(this);">
		<label for="rbTemplate" style="float:none; padding:2px 25px 2px 2px;">Template</label>
	</div>
	<div id="divProjectsDropdown" style="margin:15px 0px">
		$divProjectsDropdown
	</div>
	<div id="divTemplatesDropdown" style="margin:15px 0px" class="hidden">
		$divTemplatesDropdown
	</div>
	<table id="tableImportJobsiteActivities" width="100%" cellpadding="5">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter"><input type="checkbox" onclick="toggleAllJobsiteActivities(this);"></th>
				<th class="textAlignLeft" style="width: 90%;">Jobsite Activity Label</th>
			</tr>
		</thead>
		<tbody class="altColors">
			$jobsiteActivitiesTableTbody
		</tbody>
	</table>
	<input type="hidden" id="primaryDatasource" value="$primaryDatasource">
	<input type="hidden" id="secondaryDatasource" value="project">
</div>
END_HTML_CONTENT;

echo $htmlContent;
