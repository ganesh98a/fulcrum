<?php

/* @var $jobsiteDelayCategory JobsiteDelayCategory */
/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */
/* @var $jobsiteDelay JobsiteDelay */
/* @var $jobsiteDelayNote JobsiteDelayNote */

$jobsite_delay_category_id = (int) $get->jobsite_delay_category_id;
$jobsite_delay_subcategory_id = (int) $get->jobsite_delay_subcategory_id;

$jobsiteDelayCategory = JobsiteDelayCategory::findById($database, $jobsite_delay_category_id);
/* @var $jobsiteDelayCategory JobsiteDelayCategory */

$jobsiteDelaySubcategory = JobsiteDelaySubcategory::findById($database, $jobsite_delay_subcategory_id);
/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */

$jobsiteDelayCategory->htmlEntityEscapeProperties();
$jobsiteDelaySubcategory->htmlEntityEscapeProperties();

$jobsite_delay_category = $jobsiteDelayCategory->jobsite_delay_category;
$escaped_jobsite_delay_category = $jobsiteDelayCategory->escaped_jobsite_delay_category;

$jobsite_delay_subcategory = $jobsiteDelaySubcategory->jobsite_delay_subcategory;
$escaped_jobsite_delay_subcategory = $jobsiteDelaySubcategory->escaped_jobsite_delay_subcategory;

if ($jobsiteDelayNote && ($jobsiteDelayNote instanceof JobsiteDelayNote)) {
	$jobsiteDelayNote->htmlEntityEscapeProperties();
	$jobsite_delay_note = $jobsiteDelayNote->jobsite_delay_note;
	$escaped_jobsite_delay_note = $jobsiteDelayNote->escaped_jobsite_delay_note;
} else {
	$jobsite_delay_note = '';
	$escaped_jobsite_delay_note = '';
}

$recordContainerElementId = "record_container--manage-jobsite_delay-record--jobsite_delays--$primaryKeyAsString";
$htmlRecordTr = <<<END_HTML_RECORD

	<tr id="$recordContainerElementId">
		<td>$escaped_jobsite_delay_category</td>
		<td>$escaped_jobsite_delay_subcategory</td>
		<td>$escaped_jobsite_delay_note</td>
		<td><a href="javascript:deleteJobsiteDelay('$recordContainerElementId', '$attributeGroupName', '$primaryKeyAsString', { responseDataType: 'json'});">x</a></td>
	</tr>
END_HTML_RECORD;

$arrCustomizedJsonOutput = array(
	/*
	'jobsite_delay_category' => $jobsite_delay_category,
	'escaped_jobsite_delay_category' => $escaped_jobsite_delay_category,

	'jobsite_delay_subcategory' => $jobsite_delay_subcategory,
	'escaped_jobsite_delay_subcategory' => $escaped_jobsite_delay_subcategory,

	'jobsite_delay_note' => $jobsite_delay_note,
	'escaped_jobsite_delay_note' => $escaped_jobsite_delay_note,
	*/

	'htmlRecordTr' => $htmlRecordTr
);
