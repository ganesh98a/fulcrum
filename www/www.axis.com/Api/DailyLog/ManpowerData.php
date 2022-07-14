<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
/*Manpower Details*/
$RN_jsonEC['data']['tabs'] = null;
$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['tabs'][1]['list'] = null;
$RN_jsonEC['data']['tabs']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
$RN_arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id);
$RN_arrJobsiteManPowerIds = $RN_arrReturn['jobsite_man_power_ids'];
$RN_arrJobsiteManPowerByJobsiteDailyLogId = $RN_arrReturn['objects'];
$RN_arrJobsiteManPowerBySubcontractId = $RN_arrReturn['jobsite_man_power_by_subcontract_id'];

$RN_arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $RN_project_id, null, true);
$RN_index = 0;
$RN_Total = 0;
$RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
foreach ($RN_arrSubcontractsByProjectId as $RN_subcontract_id => $RN_subcontract) {
	/* @var $RN_subcontract Subcontract */

	$RN_gcBudgetLineItem = $RN_subcontract->getGcBudgetLineItem();
	/* @var $RN_gcBudgetLineItem GcBudgetLineItem */

	$RN_costCode = $RN_gcBudgetLineItem->getCostCode();
	/* @var $RN_costCode CostCode */

	$RN_htmlEntityEscapedFormattedCostCode = $RN_costCode->getHtmlEntityEscapedFormattedCostCodeApi($database,$RN_user_company_id);

	$RN_vendor = $RN_subcontract->getVendor();
	/* @var $RN_vendor Vendor */

	$RN_vendor_id = $RN_vendor->vendor_id;

	$RN_contactCompany = $RN_vendor->getVendorContactCompany();
	/* @var $RN_contactCompany ContactCompany */

	$RN_contact_company_name = $RN_contactCompany->contact_company_name;

	$RN_number_of_people = 0;
	if (isset($RN_arrJobsiteManPowerBySubcontractId[$RN_subcontract_id])) {
		$RN_jobsiteManPower = $RN_arrJobsiteManPowerBySubcontractId[$RN_subcontract_id];
		/* @var $RN_jobsiteManPower JobsiteManPower */
		$RN_number_of_people = $RN_jobsiteManPower->number_of_people;
		$RN_uniqueId = $RN_jobsiteManPower->jobsite_man_power_id;
	} else {
		$RN_jobsiteManPower = JobsiteManPower::findByJobsiteDailyLogIdAndSubcontractId($database, $RN_jobsite_daily_log_id, $RN_subcontract_id);
		/* @var $RN_jobsiteManPower JobsiteManPower */
		if ($RN_jobsiteManPower) {
			$RN_number_of_people = $RN_jobsiteManPower->number_of_people;
			$RN_uniqueId = $RN_jobsiteManPower->jobsite_man_power_id;
		} else {
			$RN_number_of_people = 0;
			$RN_uniqueId = $RN_jobsite_daily_log_id.'-'.$RN_subcontract_id;
		}
	}
	$RN_Total = $RN_Total + $RN_number_of_people;
	$RN_jsonEC['data']['tabs'][1]['list'][$RN_index]['company'] = htmlspecialchars_decode($RN_htmlEntityEscapedFormattedCostCode);
	$RN_jsonEC['data']['tabs'][1]['list'][$RN_index]['company'] = html_entity_decode($RN_jsonEC['data']['tabs'][1]['list'][$RN_index]['company'], ENT_QUOTES, "UTF-8");
	$RN_jsonEC['data']['tabs'][1]['list'][$RN_index]['company_name'] = $RN_contact_company_name;
	$RN_jsonEC['data']['tabs'][1]['list'][$RN_index]['on_site'] = $RN_number_of_people;
	$RN_jsonEC['data']['tabs'][1]['list'][$RN_index]['subcontract_id'] = $RN_subcontract_id;
	$RN_index++;
}
$RN_per_page = 20;
$RN_total_rows = ($RN_index);
$RN_pages = ceil($RN_total_rows / $RN_per_page);
$RN_current_page = isset($RN_page) ? $RN_page : 1;
$RN_current_page = ($RN_total_rows > 0) ? min($RN_page, $RN_current_page) : 1;
$RN_start = $RN_current_page * $RN_per_page - $RN_per_page;
$RN_prev_page = ($RN_current_page > 1) ? ($RN_current_page-1) : null;
$RN_next_page = ($RN_current_page > ($RN_pages-1)) ? null : ($RN_current_page+1);

// $RN_jsonEC['data']['tabs'][1]['list'] = array_slice($RN_jsonEC['data']['tabs'][1]['list'], $RN_start, $RN_per_page); 
$RN_jsonEC['data']['tabs'][1]['total_onsite'] = $RN_Total;
$RN_jsonEC['data']['tabs'][1]['total_pages'] = $RN_pages;
$RN_jsonEC['data']['tabs'][1]['total_row'] = $RN_total_rows;
$RN_jsonEC['data']['tabs'][1]['per_pages'] = $RN_per_page;
$RN_jsonEC['data']['tabs'][1]['from'] = ($RN_start+1);
$RN_jsonEC['data']['tabs'][1]['to'] = ((($RN_start+$RN_per_page)-1) > $RN_total_rows-1) ? $RN_total_rows : ($RN_start+$RN_per_page);
$RN_jsonEC['data']['tabs'][1]['prev_page'] = $RN_prev_page;
$RN_jsonEC['data']['tabs'][1]['current_page'] = $RN_current_page;
$RN_jsonEC['data']['tabs'][1]['next_page'] = $RN_next_page;

// Sign in sheets.
$RN_loadJobsiteSignInSheetsByJobsiteDailyLogIdOptions = new Input();
$RN_loadJobsiteSignInSheetsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
$RN_arrJobsiteSignInSheetsByJobsiteDailyLogId = JobsiteSignInSheet::loadJobsiteSignInSheetsByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteSignInSheetsByJobsiteDailyLogIdOptions);
$RN_liUploadedSigninSheets = '';
$RN_jsonEC['data']['tabs'][1]['sign_in_sheet'] = null;
// Create FileManagerFolder
$RN_yearY = date('Y');
$RN_monthF = date('m F');
$RN_virtual_file_path = "/Daily Log/Sign In Sheets/$RN_yearY/$RN_monthF/";
$RN_jobsiteSignInSheetUploadfileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_virtual_file_path);
/* @var $jobsiteSignInSheetUploadfileManagerFolder FileManagerFolder */
$RN_jobsite_sign_in_sheet_file_manager_folder_id = $RN_jobsiteSignInSheetUploadfileManagerFolder->file_manager_folder_id;

$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['detail']['virtual_file_path'] = $RN_virtual_file_path;
$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['detail']['file_manager_folder_id'] = $RN_jobsite_sign_in_sheet_file_manager_folder_id;
$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['detail']['allowed_extensions'] = 'gif,jpg,jpeg,pdf,png,tif,tiff';
$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['detail']['id'] = 'sign_in_sheet_upload';
$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['detail']['method'] = 'uploadFiles';
$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['detail']['method_save'] = 'jobsite_sign_in_sheets';
$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['detail']['internal_use_only_flag'] = 'N';
$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images'] = null;
$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images_view'] = null;
foreach ($RN_arrJobsiteSignInSheetsByJobsiteDailyLogId as $RN_jobsite_sign_in_sheet_id => $RN_jobsiteSignInSheet) {
	/* @var $RN_jobsiteSignInSheet JobsiteSignInSheet */
	$RN_jobsiteSignInSheetFileManagerFile = $RN_jobsiteSignInSheet->getJobsiteSignInSheetFileManagerFile();
	/* @var $RN_jobsiteSignInSheetFileManagerFile FileManagerFile */

	$RN_virtual_file_name = $RN_jobsiteSignInSheetFileManagerFile->virtual_file_name;
	$RN_fileUrl = $RN_jobsiteSignInSheetFileManagerFile->generateUrl(true);
	$RN_fileBaseUrl = $RN_jobsiteSignInSheetFileManagerFile->generateUrlBasePath(true);
	$RN_fileSize = fileSize($RN_fileBaseUrl);
	$RN_virtual_file_mime_type = $RN_jobsiteSignInSheetFileManagerFile->virtual_file_mime_type;
	$RN_explode = explode('/', $RN_virtual_file_mime_type);
	$RN_virtual_file_mime_type = $RN_explode[1];
	/* file permissions */
	$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_jobsiteSignInSheetFileManagerFile->file_manager_file_id);
	$accessFiles = false;
	if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
		if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
			$accessFiles = false;
		} else {
			$accessFiles = true;
		}
	}
	$RN_virtual_file_type = $RN_explode[0];
	if($RN_virtual_file_type == 'image' && $accessFiles){
		$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images_view'][$RN_jobsite_sign_in_sheet_id]['url'] = $RN_fileUrl.$RN_id;
	}
	$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images'][$RN_jobsite_sign_in_sheet_id]['file_access'] = $accessFiles;

	$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images'][$RN_jobsite_sign_in_sheet_id]['virtual_file_type'] = $RN_virtual_file_mime_type;
	$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images'][$RN_jobsite_sign_in_sheet_id]['virtual_file_name'] = $RN_virtual_file_name;
	$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images'][$RN_jobsite_sign_in_sheet_id]['virtual_file_path'] = $RN_fileUrl;
	$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images'][$RN_jobsite_sign_in_sheet_id]['id'] = $RN_jobsite_sign_in_sheet_id;
	$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images'][$RN_jobsite_sign_in_sheet_id]['file_size'] = $RN_fileSize;

}
if (isset($RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images'])) {
	$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images'] = array_values($RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images']);
}
if (isset($RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images_view'])) {
	$RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images_view'] = array_values($RN_jsonEC['data']['tabs'][1]['sign_in_sheet']['images_view']);
}
// Field reports.
$RN_jsonEC['data']['tabs'][1]['field_report'] = null;
// Create FileManagerFolder
$RN_virtual_file_path = "/Daily Log/Field Reports/$RN_yearY/$RN_monthF/";
$RN_jobsiteFieldReportUploadFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_virtual_file_path);
/* @var $jobsiteSignInSheetUploadfileManagerFolder FileManagerFolder */
$RN_jobsite_field_report_file_manager_folder_id = $RN_jobsiteFieldReportUploadFileManagerFolder->file_manager_folder_id;

$RN_jsonEC['data']['tabs'][1]['field_report']['detail']['virtual_file_path'] = $RN_virtual_file_path;
$RN_jsonEC['data']['tabs'][1]['field_report']['detail']['file_manager_folder_id'] = $RN_jobsite_field_report_file_manager_folder_id;
$RN_jsonEC['data']['tabs'][1]['field_report']['detail']['allowed_extensions'] = 'gif,jpg,jpeg,pdf,png,tif,tiff';
$RN_jsonEC['data']['tabs'][1]['field_report']['detail']['id'] = 'field_report_upload';
$RN_jsonEC['data']['tabs'][1]['field_report']['detail']['method'] = 'uploadFiles';
$RN_jsonEC['data']['tabs'][1]['field_report']['detail']['method_save'] = 'jobsite_field_reports';
$RN_jsonEC['data']['tabs'][1]['field_report']['detail']['internal_use_only_flag'] = 'N';
$RN_jsonEC['data']['tabs'][1]['field_report']['images'] = null;
$RN_jsonEC['data']['tabs'][1]['field_report']['images_view'] = null;
$RN_arrJobsiteFieldReportsByJobsiteDailyLogId = JobsiteFieldReport::loadJobsiteFieldReportsByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id);

foreach ($RN_arrJobsiteFieldReportsByJobsiteDailyLogId as $RN_jobsite_field_report_id => $RN_jobsiteFieldReport) {
	/* @var $RN_jobsiteFieldReport JobsiteFieldReport */

	$RN_jobsiteFieldReportFileManagerFile = $RN_jobsiteFieldReport->getJobsiteFieldReportFileManagerFile();
	/* @var $RN_jobsiteFieldReportFileManagerFile FileManagerFile */

	$RN_virtual_file_name = $RN_jobsiteFieldReportFileManagerFile->virtual_file_name;
	$RN_fileUrl = $RN_jobsiteFieldReportFileManagerFile->generateUrl(true);
	$RN_fileBaseUrl = $RN_jobsiteFieldReportFileManagerFile->generateUrlBasePath(true);
	$RN_fileSize = fileSize($RN_fileBaseUrl);
	$RN_virtual_file_mime_type = $RN_jobsiteFieldReportFileManagerFile->virtual_file_mime_type;
	$RN_explode = explode('/', $RN_virtual_file_mime_type);
	$RN_virtual_file_mime_type = $RN_explode[1];
	/* file permissions */
	$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_jobsiteFieldReportFileManagerFile->file_manager_file_id);
	$accessFiles = false;
	if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
		if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
			$accessFiles = false;
		} else {
			$accessFiles = true;
		}
	}
	$RN_virtual_file_type = $RN_explode[0];
	if($RN_virtual_file_type == 'image' && $accessFiles){
		$RN_jsonEC['data']['tabs'][1]['field_report']['images_view'][$RN_jobsite_field_report_id]['url'] = $RN_fileUrl.$RN_id;
	}
	$RN_jsonEC['data']['tabs'][1]['field_report']['images'][$RN_jobsite_field_report_id]['file_access'] = $accessFiles;

	$RN_jsonEC['data']['tabs'][1]['field_report']['images'][$RN_jobsite_field_report_id]['virtual_file_type'] = $RN_virtual_file_mime_type;
	$RN_jsonEC['data']['tabs'][1]['field_report']['images'][$RN_jobsite_field_report_id]['virtual_file_name'] = $RN_virtual_file_name;
	$RN_jsonEC['data']['tabs'][1]['field_report']['images'][$RN_jobsite_field_report_id]['virtual_file_path'] = $RN_fileUrl;
	$RN_jsonEC['data']['tabs'][1]['field_report']['images'][$RN_jobsite_field_report_id]['id'] = $RN_jobsite_field_report_id;
	$RN_jsonEC['data']['tabs'][1]['field_report']['images'][$RN_jobsite_field_report_id]['file_size'] = $RN_fileSize;
}
if (isset($RN_jsonEC['data']['tabs'][1]['field_report']['images'])) {
	$RN_jsonEC['data']['tabs'][1]['field_report']['images'] = array_values($RN_jsonEC['data']['tabs'][1]['field_report']['images']);
}
if (isset($RN_jsonEC['data']['tabs'][1]['field_report']['images_view'])) {
	$RN_jsonEC['data']['tabs'][1]['field_report']['images_view'] = array_values($RN_jsonEC['data']['tabs'][1]['field_report']['images_view']);
}
// Photos.
$RN_jsonEC['data']['tabs'][1]['jobsite_photo'] = null;
// Create FileManagerFolder
$RN_yearY = date('Y');
$RN_monthF = date('m F');
$RN_virtual_file_path = "/Daily Log/Photos/$RN_yearY/$RN_monthF/";
$RN_jobsitePhotoUploadFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_virtual_file_path);
/* @var $jobsiteSignInSheetUploadfileManagerFolder FileManagerFolder */
$RN_jobsite_photo_file_manager_folder_id = $RN_jobsitePhotoUploadFileManagerFolder->file_manager_folder_id;

$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['detail']['virtual_file_path'] = $RN_virtual_file_path;
$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['detail']['file_manager_folder_id'] = $RN_jobsite_photo_file_manager_folder_id;
$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['detail']['allowed_extensions'] = 'gif,jpg,jpeg,png,heic';
$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['detail']['id'] = 'photo_upload';
$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['detail']['method'] = 'uploadFiles';
$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['detail']['method_save'] = 'jobsite_photos';
$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['detail']['internal_use_only_flag'] = 'N';
$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'] = null;
$NR_jsonEC['data']['tabs'][1]['jobsite_photo']['images_view'] = null;
$RN_loadJobsitePhotosByJobsiteDailyLogIdOptions = new Input();
$RN_loadJobsitePhotosByJobsiteDailyLogIdOptions->forceLoadFlag = true;
$RN_arrJobsitePhotosByJobsiteDailyLogId = JobsitePhoto::loadJobsitePhotosByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsitePhotosByJobsiteDailyLogIdOptions);
$RN_liUploadedPhotos = '';
foreach ($RN_arrJobsitePhotosByJobsiteDailyLogId as $RN_jobsite_photo_id => $RN_jobsitePhoto) {
	/* @var $RN_jobsitePhoto JobsitePhoto */

	$RN_jobsitePhotoFileManagerFile = $RN_jobsitePhoto->getJobsitePhotoFileManagerFile();
	/* @var $RN_jobsitePhotoFileManagerFile FileManagerFile */
	$RN_caption = $RN_jobsitePhoto->caption;
	/* @var $RN_jobsitePhoto Caption */
	$RN_fileManageFileId = $RN_jobsitePhoto->jobsite_photo_file_manager_file_id;
	/* @var $RN_jobsitePhoto Caption */
	$RN_virtual_file_name = $RN_jobsitePhotoFileManagerFile->virtual_file_name;
	$RN_fileUrl = $RN_jobsitePhotoFileManagerFile->generateUrl(true);
	$RN_fileBaseUrl = $RN_jobsitePhotoFileManagerFile->generateUrlBasePath(true);
	$RN_fileSize = fileSize($RN_fileBaseUrl);
	$RN_virtual_file_mime_type = $RN_jobsitePhotoFileManagerFile->virtual_file_mime_type;
	$RN_explode = explode('/', $RN_virtual_file_mime_type);
	$RN_virtual_file_mime_type = $RN_explode[1];
	/* file permissions */
	$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_jobsitePhotoFileManagerFile->file_manager_file_id);
	$accessFiles = false;
	if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
		if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
			$accessFiles = false;
		} else {
			$accessFiles = true;
		}
	}
	$RN_virtual_file_type = $RN_explode[0];
	
	if($RN_virtual_file_type == 'image' && $accessFiles){
		$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images_view'][$RN_jobsite_photo_id]['url'] = $RN_fileUrl.$RN_id;
	}
	$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'][$RN_jobsite_photo_id]['file_access'] = $accessFiles;

	$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'][$RN_jobsite_photo_id]['virtual_file_type'] = $RN_virtual_file_mime_type;
	$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'][$RN_jobsite_photo_id]['virtual_file_name'] = $RN_virtual_file_name;
	$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'][$RN_jobsite_photo_id]['virtual_file_path'] = $RN_fileUrl;
	$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'][$RN_jobsite_photo_id]['id'] = $RN_jobsite_photo_id;
	$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'][$RN_jobsite_photo_id]['file_size'] = $RN_fileSize;
	$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'][$RN_jobsite_photo_id]['caption'] = $RN_caption;
	$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'][$RN_jobsite_photo_id]['jobsite_photo_file_manager_file_id'] = $RN_fileManageFileId;
}
if (isset($RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'])) {
	$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images'] = array_values($RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images']);
}
if (isset($RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images_view'])) {
	$RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images_view'] = array_values($RN_jsonEC['data']['tabs'][1]['jobsite_photo']['images_view']);	
}
// Internel Photos.
$RN_jsonEC['data']['tabs'][1]['internal_photo'] = null;
// Create FileManagerFolder
$RN_yearY = date('Y');
$RN_monthF = date('m F');
$RN_virtual_file_path = "/Daily Log/Internal Photos/$RN_yearY/$RN_monthF/";
$RN_jobsitePhotoUploadFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_virtual_file_path);
/* @var $jobsiteSignInSheetUploadfileManagerFolder FileManagerFolder */
$RN_jobsite_photo_file_manager_folder_id = $RN_jobsitePhotoUploadFileManagerFolder->file_manager_folder_id;

$RN_jsonEC['data']['tabs'][1]['internal_photo']['detail']['virtual_file_path'] = $RN_virtual_file_path;
$RN_jsonEC['data']['tabs'][1]['internal_photo']['detail']['file_manager_folder_id'] = $RN_jobsite_photo_file_manager_folder_id;
$RN_jsonEC['data']['tabs'][1]['internal_photo']['detail']['allowed_extensions'] = 'gif,jpg,jpeg,png,heic';
$RN_jsonEC['data']['tabs'][1]['internal_photo']['detail']['id'] = 'internal_photo';
$RN_jsonEC['data']['tabs'][1]['internal_photo']['detail']['method'] = 'uploadFiles';
$RN_jsonEC['data']['tabs'][1]['internal_photo']['detail']['method_save'] = 'jobsite_photos';
$RN_jsonEC['data']['tabs'][1]['internal_photo']['detail']['internal_use_only_flag'] = 'Y';
$RN_jsonEC['data']['tabs'][1]['internal_photo']['images'] = null;
$RN_jsonEC['data']['tabs'][1]['internal_photo']['images_view'] = null;
$RN_loadJobsitePhotosByJobsiteDailyLogIdOptions = new Input();
$RN_loadJobsitePhotosByJobsiteDailyLogIdOptions->forceLoadFlag = true;
$RN_arrJobsitePhotosByJobsiteDailyLogId = JobsitePhoto::loadJobsitePhotosByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsitePhotosByJobsiteDailyLogIdOptions, 'Y');
$RN_liUploadedPhotos = '';
foreach ($RN_arrJobsitePhotosByJobsiteDailyLogId as $RN_jobsite_photo_id => $RN_jobsitePhoto) {
	/* @var $RN_jobsitePhoto JobsitePhoto */

	$RN_jobsitePhotoFileManagerFile = $RN_jobsitePhoto->getJobsitePhotoFileManagerFile();
	/* @var $RN_jobsitePhotoFileManagerFile FileManagerFile */

	$RN_virtual_file_name = $RN_jobsitePhotoFileManagerFile->virtual_file_name;
	$RN_fileUrl = $RN_jobsitePhotoFileManagerFile->generateUrl(true);
	$RN_fileBaseUrl = $RN_jobsitePhotoFileManagerFile->generateUrlBasePath(true);
	$RN_fileSize = fileSize($RN_fileBaseUrl);
	$RN_virtual_file_mime_type = $RN_jobsitePhotoFileManagerFile->virtual_file_mime_type;
	$RN_explode = explode('/', $RN_virtual_file_mime_type);
	$RN_virtual_file_mime_type = $RN_explode[1];
	/* file permissions */
	$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_jobsitePhotoFileManagerFile->file_manager_file_id);
	$accessFiles = false;
	if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
		if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
			$accessFiles = false;
		} else {
			$accessFiles = true;
		}
	}
	$RN_virtual_file_type = $RN_explode[0];
	$NR_jsonEC['data']['tabs'][1]['internal_photo']['images_view'] = null;
	if($RN_virtual_file_type == 'image' && $accessFiles){
		$RN_jsonEC['data']['tabs'][1]['internal_photo']['images_view'][$RN_jobsite_photo_id]['url'] = $RN_fileUrl.$RN_id;
	}
	$RN_jsonEC['data']['tabs'][1]['internal_photo']['images'][$RN_jobsite_photo_id]['file_access'] = $accessFiles;
	
	$RN_jsonEC['data']['tabs'][1]['internal_photo']['images'][$RN_jobsite_photo_id]['virtual_file_type'] = $RN_virtual_file_mime_type;
	$RN_jsonEC['data']['tabs'][1]['internal_photo']['images'][$RN_jobsite_photo_id]['virtual_file_name'] = $RN_virtual_file_name;	
	$RN_jsonEC['data']['tabs'][1]['internal_photo']['images'][$RN_jobsite_photo_id]['virtual_file_path'] = $RN_fileUrl;
	$RN_jsonEC['data']['tabs'][1]['internal_photo']['images'][$RN_jobsite_photo_id]['id'] = $RN_jobsite_photo_id;
	$RN_jsonEC['data']['tabs'][1]['internal_photo']['images'][$RN_jobsite_photo_id]['file_size'] = $RN_fileSize;
}
if (isset($RN_jsonEC['data']['tabs'][1]['internal_photo']['images'])) {
	$RN_jsonEC['data']['tabs'][1]['internal_photo']['images'] = array_values($RN_jsonEC['data']['tabs'][1]['internal_photo']['images']);
}
if (isset($RN_jsonEC['data']['tabs'][1]['internal_photo']['images_view'])) {
	$RN_jsonEC['data']['tabs'][1]['internal_photo']['images_view'] = array_values($RN_jsonEC['data']['tabs'][1]['internal_photo']['images_view']);	
}
?>
