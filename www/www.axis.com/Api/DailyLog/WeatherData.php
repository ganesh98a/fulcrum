<?php

// Date logic.
$RN_selectedDateIndex = '0';
$RN_jobsite_daily_log_created_date = date('Y-m-d');
$RN_todayAsMysqlDate = $RN_jobsite_daily_log_created_date;
$RN_today = date('F j, Y');
$RN_rawtoday = date('Y-m-d');
$RN_interval = 60 * 60 * 24;
$RN_yesterday = date('F j, Y', time() - $RN_interval);
$RN_rawyesterday = date('Y-m-d', time() - $RN_interval);
$RN_interval *= 2;
$RN_twoDaysAgo = date('F j, Y', time() - $RN_interval);
$RN_rawtwoDaysAgo = date('Y-m-d', time() - $RN_interval);
$RN_todayPrefix = 'Today, ';
$RN_yesterdayPrefix = 'Yesterday, ';
$RN_twoDaysAgoPrefix = date('l', time() - $RN_interval) . ', ';

// date
// if (!empty($RN_date)) {
	$RN_queryStringDateCreated =  $RN_date;
	$RN_jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $RN_project_id, $RN_queryStringDateCreated);
	/* @var $RN_jobsiteDailyLog JobsiteDailyLog */
	if ($RN_jobsiteDailyLog) {
		$RN_jobsite_daily_log_id = $RN_jobsiteDailyLog->jobsite_daily_log_id;
		$RN_created_by_contact_id = $RN_jobsiteDailyLog->created_by_contact_id;
		if (!isset($RN_created_by_contact_id) || empty($RN_created_by_contact_id)) {
			$RN_data = array(
				'created_by_contact_id' => $RN_currentlyActiveContactId
			);
			$RN_jobsiteDailyLog->setData();
			$RN_jobsiteDailyLog->save();
			$RN_jobsiteDailyLog->created_by_contact_id = $RN_currentlyActiveContactId;
			$RN_jobsiteDailyLog->convertPropertiesToData();
		}
	} else {
		$RN_created_by_contact_id = $RN_currentlyActiveContactId;
		$RN_jobsiteDailyLog = new JobsiteDailyLog($database);
		$RN_jobsiteDailyLog->project_id = $RN_project_id;
		$RN_jobsiteDailyLog->jobsite_daily_log_created_date = $RN_queryStringDateCreated;
		$RN_jobsiteDailyLog->modified_by_contact_id = $RN_currentlyActiveContactId;
		$RN_jobsiteDailyLog->created_by_contact_id = $RN_created_by_contact_id;
		$RN_jobsiteDailyLog->convertPropertiesToData();
		$RN_jobsite_daily_log_id = $RN_jobsiteDailyLog->save();
	}
	// Reformat date to match date dropdown.
	$RN_timestamp = strtotime($RN_queryStringDateCreated);
	$RN_date = date('F j, Y', $RN_timestamp);
	if ($RN_date === $RN_yesterday) {
		$RN_selectedDateIndex = '1';
	} elseif ($RN_date === $RN_twoDaysAgo) {
		$RN_selectedDateIndex = '2';
	}
// }
$RN_today = $RN_todayPrefix . $RN_today;
$RN_yesterday = $RN_yesterdayPrefix . $RN_yesterday;
$RN_twoDaysAgo = $RN_twoDaysAgoPrefix . $RN_twoDaysAgo;

if (!isset($RN_jobsite_daily_log_id)) {
	$RN_jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $RN_project_id, $RN_jobsite_daily_log_created_date);
	/* @var $RN_jobsiteDailyLog JobsiteDailyLog */

	if ($RN_jobsiteDailyLog) {
		$RN_jobsite_daily_log_id = $RN_jobsiteDailyLog->jobsite_daily_log_id;
		$RN_created_by_contact_id = $RN_jobsiteDailyLog->created_by_contact_id;
	} else {
		$RN_created_by_contact_id = $RN_currentlyActiveContactId;
		$RN_jobsiteDailyLog = new JobsiteDailyLog($database);
		$RN_jobsiteDailyLog->project_id = $RN_project_id;
		$RN_jobsiteDailyLog->jobsite_daily_log_created_date = $RN_jobsite_daily_log_created_date;
		$RN_jobsiteDailyLog->created_by_contact_id = $RN_created_by_contact_id;
		$RN_jobsiteDailyLog->convertPropertiesToData();
		$RN_jobsite_daily_log_id = $RN_jobsiteDailyLog->save();
	}
}

$RN_createdByContact = Contact::findById($database, $RN_created_by_contact_id);
/* @var $RN_createdByContact Contact */
$RN_createdByContactFullNameHtmlEscaped = $RN_createdByContact->getContactFullNameHtmlEscaped();

$RN_modified_by_contact_id = $RN_jobsiteDailyLog->modified_by_contact_id;
if (isset($RN_modified_by_contact_id) && !empty($RN_modified_by_contact_id)) {
	$RN_modifiedByContact = Contact::findById($database, $RN_modified_by_contact_id);
	/* @var $RN_modifiedByContact Contact */
	$RN_modifiedBy = $RN_modifiedByContact->getContactFullName();
} else {
	$RN_modifiedBy = '';
}

$RN_jobsite_daily_log_created_date = $RN_jobsiteDailyLog->jobsite_daily_log_created_date;
$RN_createdHumanReadable = strtotime($RN_jobsite_daily_log_created_date);
$RN_createdAt = date('M j, Y', $RN_createdHumanReadable);

$RN_modified = $RN_jobsiteDailyLog->modified;
if ($RN_modified) {
	$RN_modifiedHumanReadable = strtotime($RN_modified);
	$RN_modifiedAt = date('M j, Y g:ia', $RN_modifiedHumanReadable);
} else {
	$RN_modifiedAt = '';
}

$RN_arrReturn = getAmPmWeatherTemperaturesAndConditions($database, $RN_project_id, $RN_jobsite_daily_log_created_date);
$RN_amTemperature = $RN_arrReturn['amTemperature'];
$RN_amCondition   = $RN_arrReturn['amCondition'];
$RN_pmTemperature = $RN_arrReturn['pmTemperature'];
$RN_pmCondition   = $RN_arrReturn['pmCondition'];

// $RN_amTemperature = html_entity_decode($RN_amTemperature);
// $RN_amTemperature = htmlentities($RN_amTemperature, ENT_QUOTES | ENT_IGNORE, "UTF-8");
$RN_amTemperature = str_replace("&deg;", "°", $RN_amTemperature);
$RN_pmTemperature = str_replace("&deg;", "°", $RN_pmTemperature);
// $RN_amTemperature = htmlentities($RN_amTemperature,  ENT_COMPAT | ENT_HTML401, "ISO-8859-15");

$RN_jsonEC['data']['date_details'] = null;
/*date selection option*/
$RN_jsonEC['data']['date_details']['date'][0] = $RN_today;
$RN_jsonEC['data']['date_details']['date'][1] = $RN_yesterday;
$RN_jsonEC['data']['date_details']['date'][2] = $RN_twoDaysAgo;
/*raw content*/
$RN_jsonEC['data']['date_details']['raw_date'][0] = $RN_rawtoday;
$RN_jsonEC['data']['date_details']['raw_date'][1] = $RN_rawyesterday;
$RN_jsonEC['data']['date_details']['raw_date'][2] = $RN_rawtwoDaysAgo;

$RN_jsonEC['data']['date_details']['selected_date'] = $RN_selectedDateIndex;

$RN_jsonEC['data']['date_details']['created_by'] = $RN_createdByContactFullNameHtmlEscaped;
$RN_jsonEC['data']['date_details']['modified_by'] = $RN_modifiedBy;
$RN_jsonEC['data']['date_details']['created_on'] = $RN_createdAt;
$RN_jsonEC['data']['date_details']['modified_on'] = $RN_modifiedAt;
$RN_jsonEC['data']['date_details']['am_temp'] = ($RN_amTemperature);
$RN_jsonEC['data']['date_details']['pm_temp'] = ($RN_pmTemperature);
$RN_jsonEC['data']['date_details']['am_condition'] = $RN_amCondition;
$RN_jsonEC['data']['date_details']['pm_condition'] = $RN_pmCondition;
?>
