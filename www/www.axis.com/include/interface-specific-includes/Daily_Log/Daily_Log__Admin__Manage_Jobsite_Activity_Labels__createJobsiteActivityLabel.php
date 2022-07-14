<?php

$jobsite_activity_label = $jobsiteActivityLabel->jobsite_activity_label;

$htmlRecordTr = <<<END_HTML_RECORD

	<tr id="record_container--manage-jobsite_activity_label-record--jobsite_activity_labels--sort_order--$primaryKeyAsString" class="ui-sortable-handle">
		<td class="tdSortBars textAlignCenter"><input type="hidden" value="10000"><img src="/images/sortbars.png"></td>

		<td class="textAlignLeft"><input type="text" style="width:300px" value="$jobsite_activity_label" onchange="updateJobsiteActivityLabel(this);" id="manage-jobsite_activity_label-record--jobsite_activity_labels--jobsite_activity_label--$primaryKeyAsString"></td>
		<td class="textAlignCenter hoverColorChange">
				<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteBuildingActivityFromMasterJobsiteActivityList(this, 'create-jobsite_building_activity-record', $primaryKeyAsString);" rel="tooltip" title="" data-original-title="Add to Building Activites"></span>
				<input type="hidden" id="create-jobsite_building_activity-record--jobsite_building_activities--jobsite_building_activity_label--$primaryKeyAsString" value="$jobsite_activity_label"></td>
		<td class="textAlignCenter hoverColorChange">
				<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteSiteworkActivityFromMasterJobsiteActivityList(this, 'create-jobsite_sitework_activity-record', $primaryKeyAsString);" rel="tooltip" title="" data-original-title="Add to Sitework Activites"></span>
				<input type="hidden" id="create-jobsite_sitework_activity-record--jobsite_sitework_activities--jobsite_sitework_activity_label--$primaryKeyAsString" value="$jobsite_activity_label"></td>
		<td class="textAlignCenter hoverColorChange">
				<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteOffsiteworkActivityFromMasterJobsiteActivityList(this, 'create-jobsite_offsitework_activity-record', $primaryKeyAsString);" rel="tooltip" title="" data-original-title="Add to Offsitework Activites"></span>
				<input type="hidden" id="create-jobsite_offsitework_activity-record--jobsite_offsitework_activities--jobsite_offsitework_activity_label--$primaryKeyAsString" value="$jobsite_activity_label"></td>
		<td class="textAlignCenter"><input type="checkbox" onchange="updateJobsiteActivityLabel(this, { responseDataType: 'json' });" id="manage-jobsite_activity_label-record--jobsite_activity_labels--disabled_flag--$primaryKeyAsString"></td>
		<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="deleteJobsiteActivityLabel('record_container--manage-jobsite_activity_label-record--jobsite_activity_labels--sort_order--$primaryKeyAsString', 'manage-jobsite_activity_label-record', '$primaryKeyAsString', { responseDataType: 'json' });"></span></td>
	</tr>
END_HTML_RECORD;
