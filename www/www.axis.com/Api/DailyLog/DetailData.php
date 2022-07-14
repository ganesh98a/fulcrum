<?php
$RN_jsonEC['data']['tabs'] = null;
$RN_jsonEC['data']['tabs']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
/*jobsite inspection*/
$RN_loadJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeIdOptions = new Input();
$RN_loadJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeIdOptions->forceLoadFlag = true;
$RN_arrReturn = JobsiteInspection::loadJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeIdOptions);
$RN_arrJobsiteInspections = $RN_arrReturn['objects'];
$RN_arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId = $RN_arrReturn['jobsite_inspections_by_jobsite_inspection_types'];
/*load data*/
foreach($RN_arrJobsiteInspections as $RN_key => $RN_inspecData){
	$RN_inspecDataType = $RN_inspecData->getJobsiteInspectionType();
	/* @var $RN_jobsiteInspectionType JobsiteInspectionType */

	if ($RN_inspecDataType) {
		$RN_inspecDataType->htmlEntityEscapeProperties();

		$RN_jobsite_inspection_type = (string) $RN_inspecDataType->jobsite_inspection_type;
		$RN_escaped_jobsite_inspection_type = (string) $RN_inspecDataType->escaped_jobsite_inspection_type;
	} else {
		$RN_escaped_jobsite_inspection_type = '';
	}
	$RN_jsonEC['data']['tabs'][4]['inspections_data']['data'][$RN_key]['jobsite_inspection_id'] = $RN_inspecData->jobsite_inspection_id;
	$RN_jsonEC['data']['tabs'][4]['inspections_data']['data'][$RN_key]['jobsite_daily_log_id'] = $RN_inspecData->jobsite_daily_log_id;
	$RN_jsonEC['data']['tabs'][4]['inspections_data']['data'][$RN_key]['jobsite_inspection_type_id'] = $RN_inspecData->jobsite_inspection_type_id;
	$RN_jsonEC['data']['tabs'][4]['inspections_data']['data'][$RN_key]['jobsite_inspection_type'] = htmlspecialchars_decode($RN_escaped_jobsite_inspection_type);
	$RN_jsonEC['data']['tabs'][4]['inspections_data']['data'][$RN_key]['jobsite_inspection_passed_flag'] = $RN_inspecData->jobsite_inspection_passed_flag;
	$RN_jsonEC['data']['tabs'][4]['inspections_data']['data'][$RN_key]['jobsite_inspection_note'] = htmlspecialchars_decode($RN_inspecData->jobsite_inspection_note);
}
if (isset($RN_jsonEC['data']['tabs'][4]['inspections_data']['data'])) {
	$RN_jsonEC['data']['tabs'][4]['inspections_data']['data'] = array_values($RN_jsonEC['data']['tabs'][4]['inspections_data']['data']);
} else {
	$RN_jsonEC['data']['tabs'][4]['inspections_data']['data'] = null;
}

// jobsite_inspections create pattern selection
$RN_loadAllJobsiteInspectionTypesOptions = new Input();
$RN_loadAllJobsiteInspectionTypesOptions->forceLoadFlag = true;
$RN_arrAllJobsiteInspectionTypes = JobsiteInspectionType::loadAllJobsiteInspectionTypes($database, $RN_loadAllJobsiteInspectionTypesOptions);
	// echo "<pre>";
	// print_r($RN_arrAllJobsiteInspectionTypes);
foreach($RN_arrAllJobsiteInspectionTypes as $RN_key => $RN_inspecVal){
	$RN_jsonEC['data']['tabs'][4]['inspections_data']['inspection_type'][$RN_key]['jobsite_inspection_type_id'] = $RN_inspecVal->jobsite_inspection_type_id;
	$RN_jsonEC['data']['tabs'][4]['inspections_data']['inspection_type'][$RN_key]['jobsite_inspection_type'] = $RN_inspecVal->jobsite_inspection_type;		
}
$RN_jsonEC['data']['tabs'][4]['inspections_data']['inspection_type'] = array_values($RN_jsonEC['data']['tabs'][4]['inspections_data']['inspection_type']);
/*Jobsite delays*/
$RN_loadJobsiteDelayCategoriesByUserCompanyIdOptions = new Input();
$RN_loadJobsiteDelayCategoriesByUserCompanyIdOptions->forceLoadFlag = true;
$RN_arrJobsiteDelayCategoriesByUserCompanyId = JobsiteDelayCategory::loadJobsiteDelayCategoriesByUserCompanyId($database, $RN_user_company_id, $RN_loadJobsiteDelayCategoriesByUserCompanyIdOptions);

$RN_loadJobsiteDelaySubcategoriesByUserCompanyIdOptions = new Input();
$RN_loadJobsiteDelaySubcategoriesByUserCompanyIdOptions->forceLoadFlag = true;
$RN_arrJobsiteDelaySubcategoriesByUserCompanyIdGroupedByJobsiteDelayCategoryId = JobsiteDelaySubcategory::loadJobsiteDelaySubcategoriesByUserCompanyIdGroupedByJobsiteDelayCategoryId($database, $RN_user_company_id, $RN_loadJobsiteDelaySubcategoriesByUserCompanyIdOptions);

$RN_loadJobsiteDelaySubcategoriesByJobsiteDelayCategoryIdOptions = new Input();
$RN_loadJobsiteDelaySubcategoriesByJobsiteDelayCategoryIdOptions->forceLoadFlag = true;
foreach ($RN_arrJobsiteDelayCategoriesByUserCompanyId as $RN_jobsite_delay_category_id => $RN_jobsiteDelayCategory) {
	/* @var $RN_jobsiteDelayCategory JobsiteDelayCategory */

	$RN_jobsite_delay_category = $RN_jobsiteDelayCategory->jobsite_delay_category;
	$RN_arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId = $RN_arrJobsiteDelaySubcategoriesByUserCompanyIdGroupedByJobsiteDelayCategoryId[$RN_jobsite_delay_category_id];
	$RN_jsonEC['data']['tabs'][4]['delay_data']['category_type'][$RN_jobsite_delay_category_id]['jobsite_delay_category_id'] = $RN_jobsite_delay_category_id;
	$RN_jsonEC['data']['tabs'][4]['delay_data']['category_type'][$RN_jobsite_delay_category_id]['jobsite_delay_category'] = $RN_jobsite_delay_category;
	$RN_arrJobsiteDelaySubcategories = array();
	foreach($RN_arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId as $RN_jobsite_delay_subcategory_id => $RN_jobsiteDelaySubcategory) {
		/* @var $RN_jobsiteDelaySubcategory JobsiteDelaySubcategory */

		$RN_jobsite_delay_subcategory = $RN_jobsiteDelaySubcategory->jobsite_delay_subcategory;
		$RN_arrJobsiteDelaySubcategories[$RN_jobsite_delay_subcategory_id] = $RN_jobsite_delay_subcategory;
		// if($RN_jobsite_delay_subcategory != "Please Describe Delay"){
		$RN_jsonEC['data']['tabs'][4]['delay_data']['subcategory_type'][$RN_jobsite_delay_category_id][$RN_jobsite_delay_subcategory_id]['jobsite_delay_subcategory_id'] = $RN_jobsite_delay_subcategory_id;
		$RN_jsonEC['data']['tabs'][4]['delay_data']['subcategory_type'][$RN_jobsite_delay_category_id][$RN_jobsite_delay_subcategory_id]['jobsite_delay_subcategory'] = $RN_jobsite_delay_subcategory;
		// }
	}
	$RN_jsonEC['data']['tabs'][4]['delay_data']['subcategory_type'][$RN_jobsite_delay_category_id] = array_values($RN_jsonEC['data']['tabs'][4]['delay_data']['subcategory_type'][$RN_jobsite_delay_category_id]);
	$RN_arrJobsiteDelayCategoriesAndSubcategories[$RN_jobsite_delay_category_id] = $RN_arrJobsiteDelaySubcategories;
}
$RN_jsonEC['data']['tabs'][4]['delay_data']['category_type'] = array_values($RN_jsonEC['data']['tabs'][4]['delay_data']['category_type']);
/*load delay data*/
// jobsite_delays
$RN_loadJobsiteDelaysByJobsiteDailyLogIdOptions = new Input();
$RN_loadJobsiteDelaysByJobsiteDailyLogIdOptions->forceLoadFlag = true;
$RN_arrJobsiteDelays = JobsiteDelay::loadJobsiteDelaysByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteDelaysByJobsiteDailyLogIdOptions);
$RN_jobsiteDelayTable = '';
foreach ($RN_arrJobsiteDelays as $RN_ind => $RN_jobsiteDelay) {
	/* @var $RN_jobsiteDelay JobsiteDelay */

	$RN_jobsite_delay_id = $RN_jobsiteDelay->jobsite_delay_id;
	$RN_elementId = "record_container--manage-jobsite_delay-record--jobsite_delays--$RN_jobsite_delay_id";
	$RN_jobsite_delay_category = 'Miscellaneous';
	$RN_jobsite_delay_subcategory = 'Miscellaneous';

	$RN_jobsiteDelayCategory = $RN_jobsiteDelay->getJobsiteDelayCategory();
	/* @var $RN_jobsiteDelayCategory JobsiteDelayCategory */

	if ($RN_jobsiteDelayCategory) {
		$RN_jobsiteDelayCategory->htmlEntityEscapeProperties();
		$RN_escaped_jobsite_delay_category = $RN_jobsiteDelayCategory->escaped_jobsite_delay_category;
	} else {
		$RN_escaped_jobsite_delay_category = '';
	}

	$RN_jobsiteDelaySubcategory = $RN_jobsiteDelay->getJobsiteDelaySubcategory();
	/* @var $RN_jobsiteDelaySubcategory JobsiteDelaySubcategory */

	if ($RN_jobsiteDelaySubcategory) {
		$RN_jobsiteDelaySubcategory->htmlEntityEscapeProperties();
		$RN_escaped_jobsite_delay_subcategory = $RN_jobsiteDelaySubcategory->escaped_jobsite_delay_subcategory;
	} else {
		$RN_escaped_jobsite_delay_subcategory = '';
	}

	$RN_jobsiteDelayNote = $RN_jobsiteDelay->getJobsiteDelayNote();
	/* @var $RN_jobsiteDelayNote JobsiteDelayNote */

	if ($RN_jobsiteDelayNote) {
		$RN_jobsiteDelayNote->htmlEntityEscapeProperties();
		$RN_escaped_jobsite_delay_note = $RN_jobsiteDelayNote->escaped_jobsite_delay_note;
	} else {
		$RN_escaped_jobsite_delay_note = '';
	}

	$RN_jsonEC['data']['tabs'][4]['delay_data']['data'][$RN_ind]['jobsite_delay_category'] = htmlspecialchars_decode($RN_escaped_jobsite_delay_category);
	$RN_jsonEC['data']['tabs'][4]['delay_data']['data'][$RN_ind]['jobsite_delay_subcategory'] = htmlspecialchars_decode($RN_escaped_jobsite_delay_subcategory);
	$RN_jsonEC['data']['tabs'][4]['delay_data']['data'][$RN_ind]['jobsite_delay_note'] = htmlspecialchars_decode($RN_escaped_jobsite_delay_note);
	$RN_jsonEC['data']['tabs'][4]['delay_data']['data'][$RN_ind]['jobsite_delay_id'] = $RN_jobsite_delay_id;
}
if (isset($RN_jsonEC['data']['tabs'][4]['delay_data']['data'])) {
	$RN_jsonEC['data']['tabs'][4]['delay_data']['data'] = array_values($RN_jsonEC['data']['tabs'][4]['delay_data']['data']);
} else {
	$RN_jsonEC['data']['tabs'][4]['delay_data']['data'] = null;
}

// jobsite_note_types
$RN_arrAllJobsiteNoteTypes = JobsiteNoteType::loadAllJobsiteNoteTypes($database);
// jobsite_notes
$RN_loadJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeIdOptions = new Input();
$RN_loadJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeIdOptions->forceLoadFlag = true;
$RN_arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId =
JobsiteNote::loadJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeIdOptions);
/*
1	general_notes	General Notes	20	N
2	safety	Safety	20	N
3	visitors	Visitors	20	N
4	swppp	SWPPP	20	N
5	deliveries	Deliveries	20	N
6	extra_work	Extra Work	20	N
7	delays	Delays	20	N
*/
$RN_general_notes_jobsite_note_type_id = 1;
$RN_safety_jobsite_note_type_id = 2;
$RN_visitors_jobsite_note_type_id = 3;
$RN_swppp_jobsite_note_type_id = 4;
$RN_deliveries_jobsite_note_type_id = 5;
$RN_extra_work_jobsite_note_type_id = 6;
$RN_delays_jobsite_note_type_id = 7;
$RN_notestArray = array(
	1 => 'GENERAL NOTES',
	2 => 'SAFETY',
	3 => 'VISITORS',
	4 => 'SWPPP',
	5 => 'DELIVERIES',
	6 => 'EXTRA WORK',
	7 => 'DELAY NOTES'
);
// jobsite_notes
foreach ($RN_arrAllJobsiteNoteTypes as $RN_jobsite_note_type_id => $RN_jobsiteNoteType)
{
	/* @var $RN_jobsiteNoteType JobsiteNoteType */
	$RN_jobsite_note_type = $RN_jobsiteNoteType->jobsite_note_type;

	if (isset($RN_arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId[$RN_jobsite_note_type_id])) {

			// save (update) case
		$RN_arrJobsiteNotes = $RN_arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId[$RN_jobsite_note_type_id];

		list($RN_jobsite_note_id, $RN_jobsiteNote) = each($RN_arrJobsiteNotes);
		/* @var $RN_jobsiteNote JobsiteNote */

		$RN_jobsite_note_id = $RN_jobsiteNote->jobsite_note_id;
		$RN_uniqueId = $RN_jobsite_note_id;
		$RN_jobsite_note = $RN_jobsiteNote->jobsite_note;

	} else {

			// save (create) case
		$RN_uniqueId = $RN_jobsite_daily_log_id . '-' . $RN_jobsite_note_type_id;
		$RN_jobsite_note = '';

	}
	$RN_jsonEC['data']['tabs'][4]['notes_data'][$RN_jobsite_note_type_id]['jobsite_note_type'] = $RN_notestArray[$RN_jobsite_note_type_id];
	$RN_jsonEC['data']['tabs'][4]['notes_data'][$RN_jobsite_note_type_id]['jobsite_note_type_id'] = $RN_jobsite_note_type_id;
	$RN_jsonEC['data']['tabs'][4]['notes_data'][$RN_jobsite_note_type_id]['jobsite_note'] = $RN_jobsite_note;
}
$RN_jsonEC['data']['tabs'][4]['notes_data'] = array_values($RN_jsonEC['data']['tabs'][4]['notes_data']);
$RN_jsonEC['data']['tabs'][4]['notes_data'] = array_slice($RN_jsonEC['data']['tabs'][4]['notes_data'], 0, 6); 
?>
