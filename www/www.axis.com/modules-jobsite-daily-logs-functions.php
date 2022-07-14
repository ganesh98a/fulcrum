<?php
ini_set("memory_limit", "1000M");
require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/DailyConstructionReport.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/JobsiteActivityLabel.php');
require_once('lib/common/JobsiteActivityListTemplate.php');
require_once('lib/common/JobsiteBuilding.php');
require_once('lib/common/JobsiteBuildingActivity.php');
require_once('lib/common/JobsiteBuildingActivityTemplate.php');
require_once('lib/common/JobsiteBuildingActivityTemplateToCostCode.php');
require_once('lib/common/JobsiteBuildingActivityToCostCode.php');
require_once('lib/common/JobsiteDailyBuildingActivityLog.php');
require_once('lib/common/JobsiteDailyLog.php');
require_once('lib/common/JobsiteDailyOffsiteworkActivityLog.php');
require_once('lib/common/JobsiteDailySiteworkActivityLog.php');
require_once('lib/common/JobsiteDelay.php');
require_once('lib/common/JobsiteDelayCategory.php');
require_once('lib/common/JobsiteDelayNote.php');
require_once('lib/common/JobsiteDelaySubcategory.php');
require_once('lib/common/JobsiteFieldReport.php');
require_once('lib/common/JobsiteInspection.php');
require_once('lib/common/JobsiteInspectionNote.php');
require_once('lib/common/JobsiteInspectionType.php');
require_once('lib/common/JobsiteManPower.php');
require_once('lib/common/JobsiteNote.php');
require_once('lib/common/JobsiteNoteType.php');
require_once('lib/common/JobsiteOffsiteworkActivity.php');
require_once('lib/common/JobsiteOffsiteworkActivityTemplate.php');
require_once('lib/common/JobsiteOffsiteworkActivityTemplateToCostCode.php');
require_once('lib/common/JobsiteOffsiteworkActivityToCostCode.php');
require_once('lib/common/JobsiteOffsiteworkRegion.php');
require_once('lib/common/JobsitePhoto.php');
require_once('lib/common/JobsiteSignInSheet.php');
require_once('lib/common/JobsiteSiteworkActivity.php');
require_once('lib/common/JobsiteSiteworkActivityTemplate.php');
require_once('lib/common/JobsiteSiteworkActivityTemplateToCostCode.php');
require_once('lib/common/JobsiteSiteworkActivityToCostCode.php');
require_once('lib/common/JobsiteSiteworkRegion.php');
require_once('lib/common/Log.php');
require_once('lib/common/MobileNetworkCarrier.php');
require_once('lib/common/MobilePhoneNumber.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/PdfTools.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/ProjectToWeatherUndergroundReportingStation.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/RequestForInformation.php');
require_once('lib/common/RequestForInformationPriority.php');
require_once('lib/common/RequestForInformationStatus.php');
require_once('lib/common/RequestForInformationType.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/SubcontractorBid.php');
require_once('lib/common/SubcontractorBidStatus.php');
require_once('lib/common/SubcontractDocument.php');
require_once('lib/common/SubcontractItemTemplate.php');
require_once('lib/common/SubcontractTemplate.php');
require_once('lib/common/SubcontractTemplateToSubcontractItemTemplate.php');
require_once('lib/common/SubcontractType.php');
require_once('lib/common/UserCompanyFileTemplate.php');
require_once('lib/common/Vendor.php');
require_once('lib/common/WeatherUndergroundConditionLabel.php');
require_once('lib/common/WeatherUndergroundMeasurement.php');
require_once('lib/common/WeatherUndergroundReportingStation.php');
require_once('lib/common/OpenWeatherAmPmLogs.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
require_once('lib/common/Service/TableService.php');

require_once('include/page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');

// SESSSION VARIABLES
$projectId = $session->getCurrentlySelectedProjectId();
function buildManpowerSection($database, $user_company_id, $project_id, $jobsite_daily_log_id,$userCanViewJobsiteDailyLog,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin,$userCanDcrReport)
{
	$userCanViewJobsiteDailyLog = $userCanViewJobsiteDailyLog;
	$userCanManageJobsiteDailyLog = $userCanManageJobsiteDailyLog;
	$userCanManageJobsiteDailyLogAdmin = $userCanManageJobsiteDailyLogAdmin;
	$userCanDcrReport = $userCanDcrReport;
	$userCanDcrReport = $userCanManageJobsiteDailyLog || $userCanManageJobsiteDailyLogAdmin ? '' : 'style="display: none;"';
	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

	$arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
	$arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];

	$htmlContent = <<<END_HTML_CONTENT

<table class="tableTabContentSection" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td valign="top" style="vertical-align:top;">
			<table class="tableTabContentManpowerTabSection" border="0" cellpadding="0" cellspacing="0" width="100%" style="border:none;">
				<tr>
					<td class="columnHeader2">COMPANY</td>
					<td class="columnHeader2light"># ON SITE</td>
				</tr>
END_HTML_CONTENT;

	$arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id, null, 1);
	foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
		/* @var $subcontract Subcontract */

		$gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
		/* @var $gcBudgetLineItem GcBudgetLineItem */

		$costCode = $gcBudgetLineItem->getCostCode();
		/* @var $costCode CostCode */

		$htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCode($user_company_id);

		$vendor = $subcontract->getVendor();
		/* @var $vendor Vendor */


		$contactCompany = $vendor->getVendorContactCompany();
		/* @var $contactCompany ContactCompany */

		$contact_company_name = $contactCompany->contact_company_name;

		$number_of_people = 0;
		if (isset($arrJobsiteManPowerBySubcontractId[$subcontract_id])) {
			$jobsiteManPower = $arrJobsiteManPowerBySubcontractId[$subcontract_id];
			/* @var $jobsiteManPower JobsiteManPower */
			$number_of_people = $jobsiteManPower->number_of_people;
			$uniqueId = $jobsiteManPower->jobsite_man_power_id;

			$attributeGroupName = 'manage-jobsite_man_power-record';
			$onchange = 'Daily_Log__ManPower__updateJobsiteManPower(this);';
		} else {
			$jobsiteManPower = JobsiteManPower::findByJobsiteDailyLogIdAndSubcontractId($database, $jobsite_daily_log_id, $subcontract_id);
			/* @var $jobsiteManPower JobsiteManPower */

			if ($jobsiteManPower) {
				$number_of_people = $jobsiteManPower->number_of_people;
				$uniqueId = $jobsiteManPower->jobsite_man_power_id;
			} else {
				$number_of_people = 0;
				$uniqueId = $jobsite_daily_log_id.'-'.$subcontract_id;
			}

			$attributeGroupName = 'create-jobsite_man_power-record';
			$onchange = "Daily_Log__ManPower__createJobsiteManPower('$attributeGroupName', '$uniqueId');";
			if($userCanManageJobsiteDailyLog || $userCanManageJobsiteDailyLogAdmin)
			{
				$is_disabled = '';
			}else
			{
				$is_disabled = "disabled";
			}
			
		}


		$htmlContent .= <<<END_HTML_CONTENT

				<tr>
					<td>$contact_company_name &mdash; $htmlEntityEscapedFormattedCostCode</td>
					<td class="columnLight">
						<input id="$attributeGroupName--jobsite_man_power--number_of_people--$uniqueId" class="jdlTextbox" min="0" onchange="$onchange" type="number" value="$number_of_people" $is_disabled>
						<input id="$attributeGroupName--jobsite_man_power--jobsite_daily_log_id--$jobsite_daily_log_id-$subcontract_id" type="hidden" value="$jobsite_daily_log_id">
						<input id="$attributeGroupName--jobsite_man_power--subcontract_id--$jobsite_daily_log_id-$subcontract_id" type="hidden" value="$subcontract_id">
					</td>
				</tr>
END_HTML_CONTENT;
	}

	// Create FileManagerFolder
	$yearY = date('Y');
	$monthF = date('m F');
	$virtual_file_path = "/Daily Log/Sign In Sheets/$yearY/$monthF/";
	$jobsiteSignInSheetUploadfileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
	/* @var $jobsiteSignInSheetUploadfileManagerFolder FileManagerFolder */

	$jobsite_sign_in_sheet_file_manager_folder_id = $jobsiteSignInSheetUploadfileManagerFolder->file_manager_folder_id;
	// Input for File Uploader HTML Widget
	$input = new Input();
	$input->id = 'sign_in_sheet_upload';
	$input->folder_id = $jobsite_sign_in_sheet_file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = $virtual_file_path;
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadFiles';
	$input->allowed_extensions = 'gif,jpg,jpeg,pdf,png,tif,tiff';
	$input->post_upload_js_callback = 'Daily_Log__ManPower__signInSheetUploaded(arrFileManagerFiles);';

	$uploaderSignInSheets = buildFileUploader($input);

	// Create FileManagerFolder
	$yearY = date('Y');
	$monthF = date('m F');
	$virtual_file_path = "/Daily Log/Field Reports/$yearY/$monthF/";
	$jobsiteFieldReportUploadFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
	/* @var $jobsiteFieldReportUploadFileManagerFolder FileManagerFolder */

	$jobsite_field_report_file_manager_folder_id = $jobsiteFieldReportUploadFileManagerFolder->file_manager_folder_id;
	$input->id = 'field_report_upload';
	$input->folder_id = $jobsite_field_report_file_manager_folder_id;
	$input->virtual_file_path = $virtual_file_path;
	$input->post_upload_js_callback = 'Daily_Log__ManPower__fieldReportUploaded(arrFileManagerFiles);';
	$uploaderFieldReports = buildFileUploader($input);
	$yearY = date('Y');
	$monthF = date('m F');

	// Create FileManagerFolder
	$virtual_file_path = "/Daily Log/Photos/$yearY/$monthF/";
	$jobsitePhotoUploadFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
	/* @var $jobsitePhotoUploadFileManagerFolder FileManagerFolder */

	$jobsite_photo_file_manager_folder_id = $jobsitePhotoUploadFileManagerFolder->file_manager_folder_id;
	$input->id = 'photo_upload';
	$input->allowed_extensions = 'gif,jpg,jpeg,png';
	$input->folder_id = $jobsite_photo_file_manager_folder_id;
	$input->virtual_file_path = $virtual_file_path;
	$input->post_upload_js_callback = "Daily_Log__ManPower__photoUploaded(arrFileManagerFiles,'N');";
	$uploaderPhotos = buildFileUploader($input);

	// Create FileManagerFolder
	$virtual_file_path = "/Daily Log/Internal Photos/$yearY/$monthF/";
	$jobsitePhotoUploadFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
	/* @var $jobsitePhotoUploadFileManagerFolder FileManagerFolder */

	$jobsite_photo_file_manager_folder_id = $jobsitePhotoUploadFileManagerFolder->file_manager_folder_id;
	$input->id = 'internal_upload';
	$input->allowed_extensions = 'gif,jpg,jpeg,png';
	$input->folder_id = $jobsite_photo_file_manager_folder_id;
	$input->virtual_file_path = $virtual_file_path;
	$input->post_upload_js_callback = "Daily_Log__ManPower__photoUploaded(arrFileManagerFiles,'Y');";
	$internalPhotos = buildFileUploader($input);

	$uploadWindow = buildFileUploaderProgressWindow();

	// Sign in sheets.
	$loadJobsiteSignInSheetsByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteSignInSheetsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrJobsiteSignInSheetsByJobsiteDailyLogId = JobsiteSignInSheet::loadJobsiteSignInSheetsByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteSignInSheetsByJobsiteDailyLogIdOptions);
	$liUploadedSigninSheets = '';
	foreach ($arrJobsiteSignInSheetsByJobsiteDailyLogId as $jobsite_sign_in_sheet_id => $jobsiteSignInSheet) {
		/* @var $jobsiteSignInSheet JobsiteSignInSheet */

		$jobsiteSignInSheetFileManagerFile = $jobsiteSignInSheet->getJobsiteSignInSheetFileManagerFile();
		/* @var $jobsiteSignInSheetFileManagerFile FileManagerFile */

		$virtual_file_name = $jobsiteSignInSheetFileManagerFile->virtual_file_name;
		$fileUrl = $jobsiteSignInSheetFileManagerFile->generateUrl();
		$elementId = "record_container--manage-jobsite_sign_in_sheet-record--jobsite_sign_in_sheets--$jobsite_sign_in_sheet_id";
		$liUploadedSigninSheets .= <<<END_LI_UPLOADED_SIGN_IN_SHEETS

		<li id="$elementId">
			<a href="javascript:deleteJobsiteSignInSheet('$elementId', 'manage-jobsite_sign_in_sheet-record', '$jobsite_sign_in_sheet_id');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>
			<a href="$fileUrl" target="_blank">$virtual_file_name</a>
		</li>
END_LI_UPLOADED_SIGN_IN_SHEETS;
	}
	if (count($arrJobsiteSignInSheetsByJobsiteDailyLogId) == 0) {
		$liUploadedSigninSheets = '<li id="liUploadedSigninSheetPlaceholder">No uploads yet.</li>';
	}

	// Field reports.
	$arrJobsiteFieldReportsByJobsiteDailyLogId = JobsiteFieldReport::loadJobsiteFieldReportsByJobsiteDailyLogId($database, $jobsite_daily_log_id);
	$liUploadedFieldReports = '';
	foreach ($arrJobsiteFieldReportsByJobsiteDailyLogId as $jobsite_field_report_id => $jobsiteFieldReport) {
		/* @var $jobsiteFieldReport JobsiteFieldReport */

		$jobsiteFieldReportFileManagerFile = $jobsiteFieldReport->getJobsiteFieldReportFileManagerFile();
		/* @var $jobsiteFieldReportFileManagerFile FileManagerFile */

		$virtual_file_name = $jobsiteFieldReportFileManagerFile->virtual_file_name;
		$fileUrl = $jobsiteFieldReportFileManagerFile->generateUrl();
		$elementId = "record_container--manage-jobsite_field_report-record--jobsite_field_reports--$jobsite_field_report_id";
		$liUploadedFieldReports .= <<<END_LI_UPLOADED_FIELD_REPORTS

		<li id="$elementId">
			<a href="javascript:deleteJobsiteFieldReport('$elementId', 'manage-jobsite_field_report-record', '$jobsite_field_report_id');" class="bs-tooltip  entypo-cancel-circled" data-original-title="Delete this attachment"></a>
			<a href="$fileUrl" target="_blank">$virtual_file_name</a>
		</li>
END_LI_UPLOADED_FIELD_REPORTS;
	}
	if (count($arrJobsiteFieldReportsByJobsiteDailyLogId) == 0) {
		$liUploadedFieldReports = '<li id="liUploadedFieldReportPlaceholder">No uploads yet.</li>';
	}

	// Photos.
	$loadJobsitePhotosByJobsiteDailyLogIdOptions = new Input();
	$loadJobsitePhotosByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrJobsitePhotosByJobsiteDailyLogId = JobsitePhoto::loadJobsitePhotosByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsitePhotosByJobsiteDailyLogIdOptions);
	$liUploadedPhotos = '';
	foreach ($arrJobsitePhotosByJobsiteDailyLogId as $jobsite_photo_id => $jobsitePhoto) {
		/* @var $jobsitePhoto JobsitePhoto */

		$jobsitePhotoFileManagerFile = $jobsitePhoto->getJobsitePhotoFileManagerFile();
		/* @var $jobsitePhotoFileManagerFile FileManagerFile */

		$virtual_file_name = $jobsitePhotoFileManagerFile->virtual_file_name;
		$fileUrl = $jobsitePhotoFileManagerFile->generateUrl();
		$elementId = "record_container--manage-jobsite_photo-record--jobsite_photos--$jobsite_photo_id";
		$attrId='manage-jobsite_photo-record';
		$jobsitePhotoAsLiElement = renderJobsitePhotoAsLiElement($database, $jobsitePhoto,$attrId,$jobsite_daily_log_id);
		$liUploadedPhotos .= $jobsitePhotoAsLiElement;
	}
	if (count($arrJobsitePhotosByJobsiteDailyLogId) == 0) {
		$liUploadedPhotos = '<li id="liUploadedPhotoPlaceholder">No uploads yet.</li>';
	}
	//Internal photos
	$loadJobsitePhotosByJobsiteDailyLogIdOptions = new Input();
	$loadJobsitePhotosByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrJobsitePhotosByJobsiteDailyLogId = JobsitePhoto::loadJobsitePhotosByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsitePhotosByJobsiteDailyLogIdOptions,'Y');
	$liUploadedIntPhotos = '';
	foreach ($arrJobsitePhotosByJobsiteDailyLogId as $jobsite_photo_id => $jobsitePhoto) {
		/* @var $jobsitePhoto JobsitePhoto */

		$jobsitePhotoFileManagerFile = $jobsitePhoto->getJobsitePhotoFileManagerFile();
		/* @var $jobsitePhotoFileManagerFile FileManagerFile */

		$virtual_file_name = $jobsitePhotoFileManagerFile->virtual_file_name;
		$fileUrl = $jobsitePhotoFileManagerFile->generateUrl();
		$elementId = "record_container--manage-jobsite_internal_photo-record--jobsite_photos--$jobsite_photo_id";
		$attrId='manage-jobsite_internal_photo-record';
		$jobsitePhotoAsLiElement = renderJobsitePhotoAsLiElement($database, $jobsitePhoto,$attrId,$jobsite_daily_log_id);
		$liUploadedIntPhotos .= $jobsitePhotoAsLiElement;
	}
	if (count($arrJobsitePhotosByJobsiteDailyLogId) == 0) {
		$liUploadedIntPhotos = '<li id="liUploadedPhotoPlaceholder">No uploads yet.</li>';
	}

	
	$htmlContent .= <<<END_HTML_CONTENT
			</table>
			$uploadWindow
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableTabContentManpowerTabSection" style="border:none;">
				<tr>
					<td class="columnHeader2 textAlignleft" colspan="4">
						MANPOWER TOTAL:
						<span id="manpowerTotal"></span>
					</td>
				</tr>
			
				<tr $userCanDcrReport>
					<td class="columnHeader2 textAlignleft">Upload daily sign-in sheet</td>
					<td class="columnHeader2light  textAlignleft">Upload field reports</td>
					
					<td class="columnHeader2 textAlignleft"> Internal Photos</td>
				</tr>
				<tr class="daliyUpload" $userCanDcrReport>
					<td class="textAlignleft" style="padding-top:10px; vertical-align:top;">
						$uploaderSignInSheets
						<div id="uploaderJobsiteSignInSheets"></div>
						<input id="jobsite_sign_in_sheet_file_manager_folder_id" type="hidden" value="$jobsite_sign_in_sheet_file_manager_folder_id">
						<ul id="record_list_container--manage-jobsite_sign_in_sheet-record" class="ulUploadedFiles">$liUploadedSigninSheets</ul>
					</td>
					<td class="columnLight textAlignleft" style="padding-top:10px; vertical-align:top;">
						$uploaderFieldReports
						<div id="uploaderJobsiteFieldReports"></div>
						<input id="jobsite_field_report_file_manager_folder_id" type="hidden" value="$jobsite_field_report_file_manager_folder_id">
						<ul id="record_list_container--manage-jobsite_field_report-record" class="ulUploadedFiles">$liUploadedFieldReports</ul>
					</td>
					<td class="textAlignleft" style="padding-top:10px; vertical-align:top;">
						$internalPhotos
						<div id="uploaderJobsitePhotos"></div>
						<input id="jobsite_photo_file_manager_folder_id" type="hidden" value="$jobsite_photo_file_manager_folder_id">
						<ul id="record_list_container--manage-jobsite_internal_photo-record" class="ulUploadedFiles">$liUploadedIntPhotos</ul>
					</td>
				</tr>
				<tr $userCanDcrReport>
				<td colspan='3' class="columnHeader2 textAlignleft"> Upload Photos</td>
				</tr>
				<tr>
				<td colspan='3' class="textAlignleft" style="padding-top:10px; vertical-align:top;">
						<div class="upload_btn_Set">$uploaderPhotos</div>
						<div id="uploaderJobsitePhotos"></div>
						<input id="jobsite_photo_file_manager_folder_id" type="hidden" value="$jobsite_photo_file_manager_folder_id">
						<div><button onclick="galleryView($jobsite_daily_log_id)">View Gallery</button></div>
						<ul id="record_list_container--manage-jobsite_photo-record" class="ulUploadedFiles" >$liUploadedPhotos</ul>
					</td>
					</tr>
			</table>
			<p>&nbsp;</p>
		</td>
	</tr>
</table>
END_HTML_CONTENT;

	return $htmlContent;
}

function buildSiteworkSection($database, $project_id, $jobsite_daily_log_id, $filterByManpowerFlag=false,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin)
{
	$userCanManageJobsiteDailyLog = $userCanManageJobsiteDailyLog;
	$userCanManageJobsiteDailyLogAdmin = $userCanManageJobsiteDailyLogAdmin;
	if($userCanManageJobsiteDailyLog || $userCanManageJobsiteDailyLogAdmin)
	{
		$is_disabled = '';
	}else
	{
		$is_disabled = "disabled";
	}
	// Debug
	if ($filterByManpowerFlag) {
		$arrFilterReturn = Subcontract::loadCostCodesBySubcontractsByProjectId($database, $project_id);
		$arrCostCodesBySubcontractsByProjectId = $arrFilterReturn['cost_codes_by_subcontracts_by_project_id'];
	}

	$loadJobsiteSiteworkActivitiesByProjectIdOptions = new Input();
	$loadJobsiteSiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
	$loadJobsiteSiteworkActivitiesByProjectIdOptions->extendedReturn = true;
	$arrTmp = JobsiteSiteworkActivity::loadJobsiteSiteworkActivitiesByProjectId($database, $project_id, $loadJobsiteSiteworkActivitiesByProjectIdOptions);
	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_sitework_activities_by_cost_code_id'];
	

	if (isset($arrCostCodeIds) && !empty($arrCostCodeIds)) {
		$arrCostCodes = CostCode::loadCostCodesByArrCostCodeIds($database, $arrCostCodeIds);
	} else {
		$arrCostCodes = array();
	}

	$loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrReturn = JobsiteDailySiteworkActivityLog::loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions);
	

	$loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrReturn = JobsiteDailySiteworkActivityLog::loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions);
	$arrJobsiteDailySiteworkActivityLogs = $arrReturn['jobsite_sitework_activity_ids'];

	$numColumns = 4;
	$tdWidth = 1 / $numColumns * 100;

	// Apply appropriate permission: probably jobsite_daily_logs_admin_manage or jobsite_daily_logs_manage.
	$userCanManageDailyLog = false;
	$popoverContent = '';
	if ($userCanManageDailyLog) {
		$popoverContent = <<<END_POPOVER_CONTENT

		<span id="btnAddJobsiteSiteworkActivityPopover" class="entypo entypo-click entypo-plus-circled entypoAddActivity" data-toggle="popover" title="Add Sitework Activity"></span>
		<div id="divAddJobsiteSiteworkActivityPopover" class="hidden">
			<form>
				<div style="margin-bottom:5px">
					Label:
					<input type="text" id="create-jobsite_sitework_activity-record--jobsite_sitework_activities--jobsite_sitework_activity_label--dummy">
				</div>
				<div class="textAlignRight">
					<input type="submit" value="Save" onclick="createJobsiteSiteworkActivityAndReloadSiteworkActivitesViaPromiseChain('create-jobsite_sitework_activity-record', 'dummy');">
				</div>
			</form>
		</div>
END_POPOVER_CONTENT;
	}

	$htmlContent =
'
<table width="" border="0" cellpadding="4" cellspacing="0" class="tableTabContentContainer">

<tr>
<td valign="middle" class="columnHeader" colspan="'.$numColumns.'">
<span>SITEWORK ACTIVITIES</span>
<!--<input type="checkbox"> FILTER BY MANPOWER (ACTIVITIES THE SUBS ONSITE CAN PERFORM)-->
<input id="formattedAttributeGroupName--manage-jobsite_daily_sitework_activity_log-record" type="hidden" value="Daily Sitework Log">
<input id="formattedAttributeSubgroupName--manage-jobsite_daily_sitework_activity_log-record" type="hidden" value="Activities">
'.$popoverContent.'
</td>
</tr>
';

	$siteworkActivityCells = array();

	foreach ($arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId as $cost_code_id => $arrJobsiteSiteworkActivities) {

		// Filter By Manpower
		if (isset($cost_code_id)) {
			if ($filterByManpowerFlag) {
				if (!isset($arrCostCodesBySubcontractsByProjectId[$cost_code_id])) {
					continue;
				}
			}
		}


		foreach ($arrJobsiteSiteworkActivities as $jobsite_sitework_activity_id => $jobsiteSiteworkActivity) {
			$jobsite_sitework_activity_label = $jobsiteSiteworkActivity->jobsite_sitework_activity_label;

			if (isset($arrJobsiteDailySiteworkActivityLogs[$jobsite_sitework_activity_id])) {
				$checked = ' checked';
			} else {
				$checked = '';
			}

			$siteworkActivityCell = <<<END_SITEWORK_ACTIVITY_CELL

<td class="columnHeader2" style="padding:0; width: $tdWidth%;">
	<div class="DailyLogJobsiteDiv divBuildingActivity">
		<div class="DailyLogJobsiteDivCheckbox">
			<input id="manage-jobsite_daily_sitework_activity_log-record--jobsite_daily_sitework_activity_logs--jobsite_daily_sitework_activity_log_id--$jobsite_daily_log_id-$jobsite_sitework_activity_id" onclick="toggleJobsiteActivity(this, event);" type="checkbox"$checked $is_disabled>
		</div>
		<div class="DailyLogJobsiteDivDescription">
			<p>$jobsite_sitework_activity_label</p>
		</div>
	</div>
</td>
END_SITEWORK_ACTIVITY_CELL;

			$siteworkActivityCells[] = $siteworkActivityCell;
		}
	}

	// Divvy up the cells into 4 columns.
	$numColumns = 4;
	$htmlContent .= columnifyTableCells($siteworkActivityCells, $numColumns);

	$htmlContent .=
'
</table>
';

	return $htmlContent;
}

function buildBuildingSection($database, $project_id, $jobsite_daily_log_id, $filterByManpowerFlag=false,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin)
{
	$userCanManageJobsiteDailyLog = $userCanManageJobsiteDailyLog;
	$userCanManageJobsiteDailyLogAdmin = $userCanManageJobsiteDailyLogAdmin;
	if($userCanManageJobsiteDailyLog || $userCanManageJobsiteDailyLogAdmin)
	{
		$is_disabled = '';
	}else
	{
		$is_disabled = "disabled";
	}
	// Debug
	if ($filterByManpowerFlag) {
		$arrFilterReturn = Subcontract::loadCostCodesBySubcontractsByProjectId($database, $project_id);
		$arrCostCodesBySubcontractsByProjectId = $arrFilterReturn['cost_codes_by_subcontracts_by_project_id'];
		$filterByManpowerFlagChecked = ' checked';
	} else {
		$filterByManpowerFlagChecked = '';
	}

	$loadJobsiteBuildingActivitiesByProjectIdOptions = new Input();
	$loadJobsiteBuildingActivitiesByProjectIdOptions->extendedReturn	= true;
	$loadJobsiteBuildingActivitiesByProjectIdOptions->filterByCostCode	= false;
	$loadJobsiteBuildingActivitiesByProjectIdOptions->forceLoadFlag		= true;
	$loadJobsiteBuildingActivitiesByProjectIdOptions->arrOrderByAttributes		= array('codes.`cost_code_division_id`' => 'ASC','codes.`cost_code`' => 'ASC','jba.`sort_order`'=>'ASC');

	$arrTmp = JobsiteBuildingActivity::loadJobsiteBuildingActivitiesByProjectId($database, $project_id, $loadJobsiteBuildingActivitiesByProjectIdOptions);
	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteBuildingActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_building_activities_by_cost_code_id'];
	

	$arrCostCodes = $arrCostCodes = CostCode::loadCostCodesByArrCostCodeIds($database, $arrCostCodeIds);

	$loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrReturn = JobsiteDailyBuildingActivityLog::loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions);
	$arrJobsiteBuildingActivityIds = $arrReturn['jobsite_building_activity_ids'];
	$arrJobsiteBuildingcostcodes = $arrReturn['cost_code_id'];


	$numColumns = 4;
	$tdWidth = 1 / $numColumns * 100;
	$arrBuildingActivityCells = array();
	$arrCostCodeOptions = array();

	foreach ($arrJobsiteBuildingActivitiesByProjectIdByCostCodeId as $cost_code_id => $arrJobsiteBuildingActivities) {

		// Filter By Manpower
		if (isset($cost_code_id)) {
			if ($filterByManpowerFlag) {
				if (!isset($arrCostCodesBySubcontractsByProjectId[$cost_code_id])) {
					continue;
				}
			}

			if (isset($arrCostCodes[$cost_code_id])) {
				$costCode = $arrCostCodes[$cost_code_id];
				$formattedCostCode = $costCode->getFormattedCostCode($database);
				$arrCostCodeOptions[] = '<option value="'.$cost_code_id.'">'.$formattedCostCode.'</option>';
			} else {
				$formattedCostCode = 'No Trade Specified';
			}
		} else {
			$formattedCostCode = 'No Trade Specified';
		}

//		$htmlContent .=
//'
//<tr>
//<td class="columnHeader2" style="padding:0;" width="100%">
//<div class="jdlAccordion">
//	<h3>'.$formattedCostCode.'</h3>
//	<div class="divBuildingActivities" style="padding:0;">
//';

		$buildingActivityCell =
'
<td class="columnHeader2" style="padding:0; width:'.$tdWidth.'%">
	<div class="DailyLogJobsiteDiv" style="background:#ccc;">
		<div class="DailyLogJobsiteDivCheckbox"></div>
		<div class="DailyLogJobsiteDivDescription">
			<p>'.$formattedCostCode.'</p>
		</div>
	</div>
</td>
';

		$arrBuildingActivityCells[] = $buildingActivityCell;

		foreach ($arrJobsiteBuildingActivities as $jobsite_building_activity_id => $jobsiteBuildingActivity) {
			/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */

			$jobsiteBuildingActivity->htmlEntityEscapeProperties();

			$escaped_jobsite_building_activity_label = $jobsiteBuildingActivity->escaped_jobsite_building_activity_label;

			if (isset($arrJobsiteBuildingActivityIds[$jobsite_building_activity_id])) {
				//To the activity linked with costcode
				if(in_array($cost_code_id, $arrJobsiteBuildingcostcodes))
				{
				$checked = 'checked';
				} else {
				$checked = '';
				}

			if($cost_code_id == 'null' )
			{ $checked ='checked';}
		
			} else {
				$checked = '';
			}



			$buildingActivityCell = <<<END_BUILDING_ACTIVITY_CELL

<td class="columnHeader2" style="padding: 0; width: $tdWidth%;">
	<div class="DailyLogJobsiteDiv divBuildingActivity">
		<div class="DailyLogJobsiteDivCheckbox">
			<input id="manage-jobsite_daily_building_activity_log-record--jobsite_daily_building_activity_logs--jobsite_daily_building_activity_log_id--$jobsite_daily_log_id-$jobsite_building_activity_id-$cost_code_id" onclick="toggleJobsiteActivity(this, event);" type="checkbox"$checked $is_disabled>
		</div>
		<div class="DailyLogJobsiteDivDescription">
			<p>$escaped_jobsite_building_activity_label</p>
		</div>
	</div>
</td>
END_BUILDING_ACTIVITY_CELL;

			$arrBuildingActivityCells[] = $buildingActivityCell;

		}

	}

	$columnifyTableCells = columnifyTableCells($arrBuildingActivityCells, $numColumns);


	// Apply appropriate permission: probably jobsite_daily_logs_admin_manage or jobsite_daily_logs_manage.
	$userCanManageDailyLog = false;
	$popoverContent = '';
	$ddlJobsiteBuildingActivityCategories = join($arrCostCodeOptions);
	if ($userCanManageDailyLog) {

		$popoverContent = <<<END_POPOVER_HTML

		<span id="btnAddJobsiteBuildingActivityPopover" class="entypo entypo-click entypo-plus-circled entypoAddActivity" data-toggle="popover" title="Add Building Activity"></span>
		<div id="divAddJobsiteBuildingActivityPopover" class="hidden">
			<form id="formCreateJobsiteBuildingActivityViaPopover">
				<table id="record_creation_form_container--create-jobsite_building_activity-record--dummy" cellpadding="2">
					<tr>
						<td class="textAlignRight">Cost Code:</td>
						<td><select id="ddlCostCodes">$ddlJobsiteBuildingActivityCategories</select></td>
					</tr>
					<tr>
						<td class="textAlignRight">Label:</td>
						<td><input type="text" id="create-jobsite_building_activity-record--jobsite_building_activities--jobsite_building_activity_label--dummy" class="required"></td>
					</tr>
					<tr>
						<td class="textAlignRight" colspan="2"><input type="submit" value="Save" onclick="createJobsiteBuildingActivityAndLinkToCostCodeViaPromiseChain('create-jobsite_building_activity-record', 'dummy');"></td>
					</tr>
				</table>
			</form>
		</div>
END_POPOVER_HTML;

	}

	$htmlContent = <<<END_CONTENT

<table class="tableTabContentContainer" border="0" cellpadding="4" cellspacing="0" width="">
	<tr>
		<td valign="middle" class="columnHeader" colspan="$numColumns">
			<span>BUILDING ACTIVITIES</span>
			<input type="checkbox" id="filterByManpower" onchange="filterByManpower(this);"$filterByManpowerFlagChecked $is_disabled>
			<label for="filterByManpower" style="float:none; font-size:15px;">FILTER BY MANPOWER (ACTIVITIES THE SUBS ONSITE CAN PERFORM)</label>
			<!--<a class="whiteLinks" href="javascript:expandAccordions();" style="margin:0px 20px;">Expand All Cost Codes</a>-->
			<!--<a class="whiteLinks" href="javascript:collapseAccordions();">Collapse All Cost Codes</a>-->
			<input id="formattedAttributeGroupName--manage-jobsite_daily_building_activity_log-record" type="hidden" value="Daily Building Log">
			<input id="formattedAttributeSubgroupName--manage-jobsite_daily_building_activity_log-record" type="hidden" value="Activities">
			$popoverContent
		</td>
	</tr>
	$columnifyTableCells
</table>
END_CONTENT;

	return $htmlContent;
}

function buildDetailsSection($database, $project_id, $jobsite_daily_log_id,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin)
{
	$userCanManageJobsiteDailyLog = $userCanManageJobsiteDailyLog;
	$userCanManageJobsiteDailyLogAdmin = $userCanManageJobsiteDailyLogAdmin;
	if($userCanManageJobsiteDailyLog || $userCanManageJobsiteDailyLogAdmin)
	{
		$is_disabled = '';
	}else
	{
		$is_disabled = "disabled";
	}
	// jobsite_inspections
	$loadJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeIdOptions = new Input();
	$loadJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeIdOptions->forceLoadFlag = true;
	$arrReturn = JobsiteInspection::loadJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId($database, $jobsite_daily_log_id, $loadJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeIdOptions);
	$arrJobsiteInspections = $arrReturn['objects'];
	$arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId = $arrReturn['jobsite_inspections_by_jobsite_inspection_types'];

	// jobsite_note_types
	$arrAllJobsiteNoteTypes = JobsiteNoteType::loadAllJobsiteNoteTypes($database);

	// jobsite_notes
	$loadJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeIdOptions = new Input();
	$loadJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeIdOptions->forceLoadFlag = true;
	$arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId =
		JobsiteNote::loadJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId($database, $jobsite_daily_log_id, $loadJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeIdOptions);

	// jobsite_inspections create pattern
	$jobsiteInspectionsCreateUniqueId = Data::generateDummyPrimaryKey();
	$ddlJobsiteInspectionTypeElementId = "ddl--create-jobsite_inspection-record--jobsite_inspections--jobsite_inspection_type_id--$jobsiteInspectionsCreateUniqueId";
	$hiddenJobsiteInspectionTypeElementId =   "create-jobsite_inspection-record--jobsite_inspections--jobsite_inspection_type_id--$jobsiteInspectionsCreateUniqueId";
	$loadAllJobsiteInspectionTypesOptions = new Input();
	$loadAllJobsiteInspectionTypesOptions->forceLoadFlag = true;
	$arrAllJobsiteInspectionTypes = JobsiteInspectionType::loadAllJobsiteInspectionTypes($database, $loadAllJobsiteInspectionTypesOptions);
	$selectedOption = '';
	$tabIndex = '';
	$js = <<<END_JS
 class="required verticalAlignBottom" onchange="ddlOnChange_UpdateHiddenInputValue(this, '$hiddenJobsiteInspectionTypeElementId');"  $is_disabled
END_JS;
	$prependedOption = '<option value="">Please choose an Inspection Type</option>';
	$ddlJobsiteInspectionTypes =
		PageComponents::dropDownListFromObjects($ddlJobsiteInspectionTypeElementId, $arrAllJobsiteInspectionTypes, 'jobsite_inspection_type_id', null, 'jobsite_inspection_type', null, $selectedOption, $tabIndex, $js, $prependedOption);

	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$user_company_id = $session->getUserCompanyId();

	$currentlySelectedInspectorContactId = '';
	$ddlJobsiteInspectionInspectorContactElementId = "ddl--create-jobsite_inspection-record--jobsite_inspections--inspector_contact_id--$jobsiteInspectionsCreateUniqueId";
	$hiddenJobsiteInspectionInspectorContactElementId =   "create-jobsite_inspection-record--jobsite_inspections--inspector_contact_id--$jobsiteInspectionsCreateUniqueId";
	$js = <<<END_JS
 ddlOnChange_UpdateHiddenInputValue(this, '$hiddenJobsiteInspectionInspectorContactElementId');"
END_JS;
	$prependedOption = '<option>Please Select An Inspector</option><option value="1">Inspector Listed In Notes</option>';
	$ddlInspectorContacts = '';

	// jobsite_inspections
	$jobsiteInspectionsTable = '';
	foreach ($arrJobsiteInspections as $jobsiteInspection) {
		/* @var $jobsiteInspection JobsiteInspection */

		$jobsite_inspection_id = $jobsiteInspection->jobsite_inspection_id;
		$jobsite_inspection_passed_flag = (string) $jobsiteInspection->jobsite_inspection_passed_flag;

		$jobsiteInspectionType = $jobsiteInspection->getJobsiteInspectionType();
		/* @var $jobsiteInspectionType JobsiteInspectionType */

		if ($jobsiteInspectionType) {
			$jobsiteInspectionType->htmlEntityEscapeProperties();
			$escaped_jobsite_inspection_type = (string) $jobsiteInspectionType->escaped_jobsite_inspection_type;
		} else {
			$escaped_jobsite_inspection_type = '';
		}

		$jobsiteInspectionNote = $jobsiteInspection->getJobsiteInspectionNote();
		/* @var $jobsiteInspectionNote JobsiteInspectionNote */

		if ($jobsiteInspectionNote) {
			$jobsiteInspectionNote->htmlEntityEscapeProperties();
			$escaped_jobsite_inspection_note = $jobsiteInspectionNote->escaped_jobsite_inspection_note;
		} else {
			$escaped_jobsite_inspection_note = '';
		}

		$elementId = "record_container--manage-jobsite_inspection-record--jobsite_inspections--$jobsite_inspection_id";
		$jobsiteInspectionsTable .= <<<END_JOBSITE_INSPECTIONS_TABLE

	<tr id="$elementId">
		<td>$escaped_jobsite_inspection_type</td>
		<td>$escaped_jobsite_inspection_note</td>
		<td>$jobsite_inspection_passed_flag</td>
		<td><a href="javascript:deleteJobsiteInspection('$elementId', 'manage-jobsite_inspection-record', $jobsite_inspection_id, { responseDataType: 'json' });">x</a></td>
	</tr>
END_JOBSITE_INSPECTIONS_TABLE;

	}

	$jobsiteInspectionTableHidden = '';
	if (count($arrJobsiteInspections) == 0) {
		$jobsiteInspectionTableHidden = 'class="hidden"';
	}


	// jobsite_delays create pattern
	$jobsiteDelaysCreateUniqueId = Data::generateDummyPrimaryKey();
	$jobsiteDelayCategoryElementId = 'ddl--create-jobsite_delay-record--jobsite_delays--jobsite_delay_category_id--' . $jobsiteDelaysCreateUniqueId;
	$loadJobsiteDelayCategoriesByUserCompanyIdOptions = new Input();
	$loadJobsiteDelayCategoriesByUserCompanyIdOptions->forceLoadFlag = true;
	$arrJobsiteDelayCategoriesByUserCompanyId = JobsiteDelayCategory::loadJobsiteDelayCategoriesByUserCompanyId($database, $user_company_id, $loadJobsiteDelayCategoriesByUserCompanyIdOptions);

	$loadJobsiteDelaySubcategoriesByUserCompanyIdOptions = new Input();
	$loadJobsiteDelaySubcategoriesByUserCompanyIdOptions->forceLoadFlag = true;
	$arrJobsiteDelaySubcategoriesByUserCompanyIdGroupedByJobsiteDelayCategoryId = JobsiteDelaySubcategory::loadJobsiteDelaySubcategoriesByUserCompanyIdGroupedByJobsiteDelayCategoryId($database, $user_company_id, $loadJobsiteDelaySubcategoriesByUserCompanyIdOptions);

	$loadJobsiteDelaySubcategoriesByJobsiteDelayCategoryIdOptions = new Input();
	$loadJobsiteDelaySubcategoriesByJobsiteDelayCategoryIdOptions->forceLoadFlag = true;
	$arrJobsiteDelayCategoriesAndSubcategories = array();
	foreach ($arrJobsiteDelayCategoriesByUserCompanyId as $jobsite_delay_category_id => $jobsiteDelayCategory) {
		/* @var $jobsiteDelayCategory JobsiteDelayCategory */

		$jobsite_delay_category = $jobsiteDelayCategory->jobsite_delay_category;
		$arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId = $arrJobsiteDelaySubcategoriesByUserCompanyIdGroupedByJobsiteDelayCategoryId[$jobsite_delay_category_id];

		$arrJobsiteDelaySubcategories = array();
		foreach($arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId as $jobsite_delay_subcategory_id => $jobsiteDelaySubcategory) {
			/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */

			$jobsite_delay_subcategory = $jobsiteDelaySubcategory->jobsite_delay_subcategory;
			$arrJobsiteDelaySubcategories[$jobsite_delay_subcategory_id] = $jobsite_delay_subcategory;
		}
		$arrJobsiteDelayCategoriesAndSubcategories[$jobsite_delay_category] = $arrJobsiteDelaySubcategories;
	}

	// @todo Create a method / query that generates this data structure right out of the box
	$jsonJobsiteDelayCategoriesAndSubcategories = json_encode($arrJobsiteDelayCategoriesAndSubcategories);

	$htmlContent = <<<END_HTML_CONTENT

<script>
	var jsonJobsiteDelayCategoriesAndSubcategories = $jsonJobsiteDelayCategoriesAndSubcategories;
</script>
END_HTML_CONTENT;

	$selectedOption = '';
	$tabIndex = '';
	$js = 'onchange="filterJobsiteDelaySubcategories(this, jsonJobsiteDelayCategoriesAndSubcategories);" class="selectJobsiteDelayCategory verticalAlignBottom"'.$is_disabled;
	$prependedOption = '<option>Please choose a Delay Category Type</option>';
	$ddlJobsiteDelayCategories =
		PageComponents::dropDownListFromObjects($jobsiteDelayCategoryElementId, $arrJobsiteDelayCategoriesByUserCompanyId, 'jobsite_delay_category_id', null, 'jobsite_delay_category', null, $selectedOption, $tabIndex, $js, $prependedOption);

	$jobsiteDelaySubcategoryElementId = 'ddl--create-jobsite_delay-record--jobsite_delays--jobsite_delay_subcategory_id--' . $jobsiteDelaysCreateUniqueId;
	$selectedOption = '';
	$tabIndex = '';
	$js = 'class="selectJobsiteDelaySubcategory required verticalAlignBottom" onchange="ddlOnChange_UpdateHiddenInputValue(this);"'.$is_disabled;
	$prependedOption = '<option value="">Please choose a Delay Subcategory Type</option>';
	$ddlJobsiteDelaySubcategories =
		PageComponents::dropDownListFromObjects($jobsiteDelaySubcategoryElementId, array(), 'jobsite_delay_subcategory_id', null, 'jobsite_delay_subcategory', null, $selectedOption, $tabIndex, $js, $prependedOption);

	// jobsite_delays
	$loadJobsiteDelaysByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteDelaysByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrJobsiteDelays = JobsiteDelay::loadJobsiteDelaysByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteDelaysByJobsiteDailyLogIdOptions);
	$jobsiteDelayTable = '';
	foreach ($arrJobsiteDelays as $jobsiteDelay) {
		/* @var $jobsiteDelay JobsiteDelay */

		$jobsite_delay_id = $jobsiteDelay->jobsite_delay_id;
		$elementId = "record_container--manage-jobsite_delay-record--jobsite_delays--$jobsite_delay_id";

		$jobsiteDelayCategory = $jobsiteDelay->getJobsiteDelayCategory();
		/* @var $jobsiteDelayCategory JobsiteDelayCategory */

		if ($jobsiteDelayCategory) {
			$jobsiteDelayCategory->htmlEntityEscapeProperties();
			$escaped_jobsite_delay_category = $jobsiteDelayCategory->escaped_jobsite_delay_category;
		} else {
			$escaped_jobsite_delay_category = '';
		}

		$jobsiteDelaySubcategory = $jobsiteDelay->getJobsiteDelaySubcategory();
		/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */

		if ($jobsiteDelaySubcategory) {
			$jobsiteDelaySubcategory->htmlEntityEscapeProperties();
			$escaped_jobsite_delay_subcategory = $jobsiteDelaySubcategory->escaped_jobsite_delay_subcategory;
		} else {
			$escaped_jobsite_delay_subcategory = '';
		}

		$jobsiteDelayNote = $jobsiteDelay->getJobsiteDelayNote();
		/* @var $jobsiteDelayNote JobsiteDelayNote */

		if ($jobsiteDelayNote) {
			$jobsiteDelayNote->htmlEntityEscapeProperties();
			$escaped_jobsite_delay_note = $jobsiteDelayNote->escaped_jobsite_delay_note;
		} else {
			$escaped_jobsite_delay_note = '';
		}

		$jobsiteDelayTable .= <<<END_JOBSITE_DELAY_TABLE

	<tr id="$elementId">
		<td>$escaped_jobsite_delay_category</td>
		<td>$escaped_jobsite_delay_subcategory</td>
		<td>$escaped_jobsite_delay_note</td>
		<td><a href="javascript:deleteJobsiteDelay('$elementId', 'manage-jobsite_delay-record', $jobsite_delay_id, { responseDataType: 'json'});">x</a></td>
	</tr>
END_JOBSITE_DELAY_TABLE;

	}

	$jobsiteDelayTableHidden = '';
	if (count($arrJobsiteDelays) == 0) {
		$jobsiteDelayTableHidden = 'class="hidden"';
	}

	/*
	1	general_notes	General Notes	20	N
	2	safety	Safety	20	N
	3	visitors	Visitors	20	N
	4	swppp	SWPPP	20	N
	5	deliveries	Deliveries	20	N
	6	extra_work	Extra Work	20	N
	7	delays	Delays	20	N
	*/
	$general_notes_jobsite_note_type_id = 1;
	$safety_jobsite_note_type_id = 2;
	$visitors_jobsite_note_type_id = 3;
	$swppp_jobsite_note_type_id = 4;
	$deliveries_jobsite_note_type_id = 5;
	$extra_work_jobsite_note_type_id = 6;

	// jobsite_notes
	foreach ($arrAllJobsiteNoteTypes as $jobsite_note_type_id => $jobsiteNoteType)
	{
		
		if (isset($arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId[$jobsite_note_type_id])) {

			// save (update) case
			$arrJobsiteNotes = $arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId[$jobsite_note_type_id];

			list($jobsite_note_id, $jobsiteNote) = each($arrJobsiteNotes);
			/* @var $jobsiteNote JobsiteNote */

			$jobsite_note_id = $jobsiteNote->jobsite_note_id;
			$uniqueId = $jobsite_note_id;
			$jobsite_note = $jobsiteNote->jobsite_note;

		} else {

			// save (create) case
			$uniqueId = $jobsite_daily_log_id . '-' . $jobsite_note_type_id;
			$jobsite_note = '';

		}

		$jobsiteNoteHtmlElementId = "manage-jobsite_note-record--jobsite_notes--jobsite_note--$uniqueId";
		$jobsiteNoteHtmlElementOnChange = "saveJobsiteNote('manage-jobsite_note-record', '$uniqueId', { responseDataType: 'json' });";

		$jobsiteNotes[$jobsite_note_type_id]['jobsiteNoteHtmlElementId'] = $jobsiteNoteHtmlElementId;
		$jobsiteNotes[$jobsite_note_type_id]['jobsiteNoteHtmlElementUniqueId'] = $uniqueId;
		$jobsiteNotes[$jobsite_note_type_id]['jobsiteNoteHtmlElementOnChange'] = $jobsiteNoteHtmlElementOnChange;
		$jobsiteNotes[$jobsite_note_type_id]['jobsite_note'] = $jobsite_note;
	}

	$generalJobsiteNotes_HtmlElementId = $jobsiteNotes[$general_notes_jobsite_note_type_id]['jobsiteNoteHtmlElementId'];
	$generalJobsiteNotes_uniqueId = $jobsiteNotes[$general_notes_jobsite_note_type_id]['jobsiteNoteHtmlElementUniqueId'];
	$generalJobsiteNotes_OnChange = $jobsiteNotes[$general_notes_jobsite_note_type_id]['jobsiteNoteHtmlElementOnChange'];
	$generalJobsiteNotes_jobsite_note = $jobsiteNotes[$general_notes_jobsite_note_type_id]['jobsite_note'];

	$safetyJobsiteNotes_HtmlElementId = $jobsiteNotes[$safety_jobsite_note_type_id]['jobsiteNoteHtmlElementId'];
	$safetyJobsiteNotes_uniqueId = $jobsiteNotes[$safety_jobsite_note_type_id]['jobsiteNoteHtmlElementUniqueId'];
	$safetyJobsiteNotes_OnChange = $jobsiteNotes[$safety_jobsite_note_type_id]['jobsiteNoteHtmlElementOnChange'];
	$safetyJobsiteNotes_jobsite_note = $jobsiteNotes[$safety_jobsite_note_type_id]['jobsite_note'];

	$visitorsJobsiteNotes_HtmlElementId = $jobsiteNotes[$visitors_jobsite_note_type_id]['jobsiteNoteHtmlElementId'];
	$visitorsJobsiteNotes_uniqueId = $jobsiteNotes[$visitors_jobsite_note_type_id]['jobsiteNoteHtmlElementUniqueId'];
	$visitorsJobsiteNotes_OnChange = $jobsiteNotes[$visitors_jobsite_note_type_id]['jobsiteNoteHtmlElementOnChange'];
	$visitorsJobsiteNotes_jobsite_note = $jobsiteNotes[$visitors_jobsite_note_type_id]['jobsite_note'];

	$swpppJobsiteNotes_HtmlElementId = $jobsiteNotes[$swppp_jobsite_note_type_id]['jobsiteNoteHtmlElementId'];
	$swpppJobsiteNotes_uniqueId = $jobsiteNotes[$swppp_jobsite_note_type_id]['jobsiteNoteHtmlElementUniqueId'];
	$swpppJobsiteNotes_OnChange = $jobsiteNotes[$swppp_jobsite_note_type_id]['jobsiteNoteHtmlElementOnChange'];
	$swpppJobsiteNotes_jobsite_note = $jobsiteNotes[$swppp_jobsite_note_type_id]['jobsite_note'];

	$deliveriesJobsiteNotes_HtmlElementId = $jobsiteNotes[$deliveries_jobsite_note_type_id]['jobsiteNoteHtmlElementId'];
	$deliveriesJobsiteNotes_uniqueId = $jobsiteNotes[$deliveries_jobsite_note_type_id]['jobsiteNoteHtmlElementUniqueId'];
	$deliveriesJobsiteNotes_OnChange = $jobsiteNotes[$deliveries_jobsite_note_type_id]['jobsiteNoteHtmlElementOnChange'];
	$deliveriesJobsiteNotes_jobsite_note = $jobsiteNotes[$deliveries_jobsite_note_type_id]['jobsite_note'];

	$extra_workJobsiteNotes_HtmlElementId = $jobsiteNotes[$extra_work_jobsite_note_type_id]['jobsiteNoteHtmlElementId'];
	$extra_workJobsiteNotes_uniqueId = $jobsiteNotes[$extra_work_jobsite_note_type_id]['jobsiteNoteHtmlElementUniqueId'];
	$extra_workJobsiteNotes_OnChange = $jobsiteNotes[$extra_work_jobsite_note_type_id]['jobsiteNoteHtmlElementOnChange'];
	$extra_workJobsiteNotes_jobsite_note = $jobsiteNotes[$extra_work_jobsite_note_type_id]['jobsite_note'];


	// @todo something with these...
	$jobsite_building_id = '';
	$jobsite_sitework_region_id = '';

	$htmlContent .= <<<END_HTML_CONTENT

<table id="tableJobsiteInspections" class="tableTabContentDetailsTabSection tableTabContentSectionNoGradient" border="0" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<td colspan="5" class="columnHeader4">INSPECTIONS</td>
	</tr>
	<tr>
		<td class="columnContent4" colspan="5">
			<form id="formJobsiteInspections">
				<input id="create-jobsite_inspection-record--jobsite_inspections--jobsite_daily_log_id--$jobsiteInspectionsCreateUniqueId" type="hidden" value="$jobsite_daily_log_id">
				<input id="create-jobsite_inspection-record--jobsite_inspections--jobsite_inspection_type_id--$jobsiteInspectionsCreateUniqueId" type="hidden" value="">
				<input id="create-jobsite_inspection-record--jobsite_inspections--inspector_contact_id--$jobsiteInspectionsCreateUniqueId" type="hidden" value="">
				<input id="create-jobsite_inspection-record--jobsite_inspections--jobsite_building_id--$jobsiteInspectionsCreateUniqueId" type="hidden" value="$jobsite_building_id">
				<input id="create-jobsite_inspection-record--jobsite_inspections--jobsite_sitework_region_id--$jobsiteInspectionsCreateUniqueId" type="hidden" value="$jobsite_sitework_region_id">
				<div id="container--create-jobsite_inspection-record--$jobsiteInspectionsCreateUniqueId">
					<div style="display:inline-block; vertical-align:top; margin-left:10px;">
						<div style="font-size: 11px;">Inspection Type</div>
						$ddlJobsiteInspectionTypes $ddlInspectorContacts
					</div>
					<div style="display:inline-block; vertical-align:top; margin-left:10px;">
						<div style="font-size: 11px;">Inspection Notes</div>
						<input id="create-jobsite_inspection-record--jobsite_inspections--jobsite_inspection_note--$jobsiteInspectionsCreateUniqueId" style="height: 18px; width: 400px;" $is_disabled>
					</div>
					<div style="text-align: center; display:inline-block; vertical-align:top; margin: 0px 10px;">
						<div style="font-size: 11px;">Passed</div>
						<input id="create-jobsite_inspection-record--jobsite_inspections--jobsite_inspection_passed_flag--$jobsiteInspectionsCreateUniqueId" type="checkbox" style="margin-top:4px;" $is_disabled>
					</div>
					<input class="verticalAlignBottom" onclick="Daily_Log__Details__createJobsiteInspection('create-jobsite_inspection-record', '$jobsiteInspectionsCreateUniqueId');" type="button" value="Create New Inspection" $is_disabled>
				</div>
			</form>
		</td>
	</tr>
	<tr id="trJobsiteInspectionsHeader" $jobsiteInspectionTableHidden>
		<td width="21%" class="columnSubheader">INSPECTION TYPE</td>
		<td width="47%" class="columnSubheader">INSPECTION NOTES</td>
		<td width="21%" class="columnSubheader">PASSED</td>
		<td width="7%" class="columnSubheader"colspan="2">&nbsp;</td>
	</tr>
	$jobsiteInspectionsTable
</table>
<table id="tableJobsiteDelays" class="tableTabContentDetailsTabSection tableTabContentSectionNoGradient" border="0" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<td class="columnHeader4" colspan="5">DELAYS</td>
	</tr>
	<tr>
		<td class="columnContent4" colspan="5">
			<form id="formJobsiteDelays">
				<input id="create-jobsite_delay-record--jobsite_delays--jobsite_daily_log_id--$jobsiteDelaysCreateUniqueId" type="hidden" value="$jobsite_daily_log_id">
				<input id="create-jobsite_delay-record--jobsite_delays--jobsite_delay_subcategory_id--$jobsiteDelaysCreateUniqueId" type="hidden" value="">
				<input id="create-jobsite_delay-record--jobsite_delays--jobsite_building_id--$jobsiteDelaysCreateUniqueId" type="hidden" value="$jobsite_building_id">
				<input id="create-jobsite_delay-record--jobsite_delays--jobsite_sitework_region_id--$jobsiteDelaysCreateUniqueId" type="hidden" value="$jobsite_sitework_region_id">
				<div id="container--create-jobsite_delay-record--$jobsiteDelaysCreateUniqueId">
					<div style="display:inline-block; vertical-align:top; margin:0px 10px;">
						<div style="font-size: 11px;">Delay Category</div>
						$ddlJobsiteDelayCategories
					</div>
					<div style="display:inline-block; vertical-align:top; margin:0px 10px;">
						<div style="font-size: 11px;">Delay Subcategory</div>
						$ddlJobsiteDelaySubcategories
					</div>
					<div style="display:inline-block; vertical-align:top; margin:0px 10px;">
						<div style="font-size: 11px;">Delay Notes</div>
						<input id="create-jobsite_delay-record--jobsite_delays--jobsite_delay_note--$jobsiteDelaysCreateUniqueId" class="inputJobsiteDelayNote" style="height: 18px; width: 320px;" $is_disabled>
					</div>
					<input class="verticalAlignBottom" onclick="Daily_Log__Details__createJobsiteDelay('create-jobsite_delay-record', '$jobsiteDelaysCreateUniqueId');" type="button" value="Create New Jobsite Delay" $is_disabled>
				</div>
			</form>
		</td>
	</tr>
	<tr id="trJobsiteDelaysHeader" $jobsiteDelayTableHidden>
		<td width="22%" class="columnSubheader">DELAY CATEGORY</td>
		<td width="28%" class="columnSubheader">DELAY SUBCATEGORY</td>
		<td width="41%" class="columnSubheader">DELAY NOTES</td>
		<td width="9%" class="columnSubheader"colspan="2">&nbsp;</td>
	</tr>
	$jobsiteDelayTable

</table>
<table class="tableTabContentDetailsTabSection tableTabContentSectionNoGradient" border="0" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<td colspan="5" class="columnHeader4">GENERAL NOTES</td>
	</tr>
	<tr>
		<td class="columnSubheader jdlTextareaTd" colspan="5">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_daily_log_id--$generalJobsiteNotes_uniqueId" type="hidden" value="$jobsite_daily_log_id">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_note_type_id--$generalJobsiteNotes_uniqueId" type="hidden" value="$general_notes_jobsite_note_type_id">
			<textarea name="textarea" id="$generalJobsiteNotes_HtmlElementId" class="jdlTextarea" onchange="$generalJobsiteNotes_OnChange" placeholder="Type General Notes here..." $is_disabled>$generalJobsiteNotes_jobsite_note</textarea>
		</td>
	</tr>
</table>
<table border="0" cellpadding="4" cellspacing="0" width="100%" class="tableTabContentDetailsTabSection tableTabContentSectionNoGradient">
	<tr>
		<td colspan="5" class="columnHeader4">SAFETY</td>
	</tr>
	<tr>
		<td class="columnSubheader jdlTextareaTd" colspan="5">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_daily_log_id--$safetyJobsiteNotes_uniqueId" type="hidden" value="$jobsite_daily_log_id">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_note_type_id--$safetyJobsiteNotes_uniqueId" type="hidden" value="$safety_jobsite_note_type_id">
			<textarea name="textarea" id="$safetyJobsiteNotes_HtmlElementId" class="jdlTextarea" onchange="$safetyJobsiteNotes_OnChange" placeholder="Type Safety Notes here..." $is_disabled>$safetyJobsiteNotes_jobsite_note</textarea>
		</td>
	</tr>
</table>
<table border="0" cellpadding="4" cellspacing="0" width="100%" class="tableTabContentDetailsTabSection tableTabContentSectionNoGradient">
	<tr>
		<td colspan="5" class="columnHeader4">VISITORS</td>
	</tr>
	<tr>
		<td class="columnSubheader jdlTextareaTd" colspan="5">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_daily_log_id--$visitorsJobsiteNotes_uniqueId" type="hidden" value="$jobsite_daily_log_id">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_note_type_id--$visitorsJobsiteNotes_uniqueId" type="hidden" value="$visitors_jobsite_note_type_id">
			<textarea name="textarea" id="$visitorsJobsiteNotes_HtmlElementId" class="jdlTextarea" onchange="$visitorsJobsiteNotes_OnChange" placeholder="Type Visitors Notes here..." $is_disabled>$visitorsJobsiteNotes_jobsite_note</textarea>
		</td>
	</tr>
</table>
<table border="0" cellpadding="4" cellspacing="0" width="100%" class="tableTabContentDetailsTabSection tableTabContentSectionNoGradient">
	<tr>
		<td colspan="5" class="columnHeader4">SWPPP</td>
	</tr>
	<tr>
		<td class="columnSubheader jdlTextareaTd" colspan="5">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_daily_log_id--$swpppJobsiteNotes_uniqueId" type="hidden" value="$jobsite_daily_log_id">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_note_type_id--$swpppJobsiteNotes_uniqueId" type="hidden" value="$swppp_jobsite_note_type_id">
			<textarea name="textarea" id="$swpppJobsiteNotes_HtmlElementId" class="jdlTextarea" onchange="$swpppJobsiteNotes_OnChange" placeholder="Type SWPPP Notes here..." $is_disabled>$swpppJobsiteNotes_jobsite_note</textarea>
		</td>
	</tr>
</table>
<table class="tableTabContentDetailsTabSection tableTabContentSectionNoGradient" border="0" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<td colspan="5" class="columnHeader4">DELIVERIES</td>
	</tr>
	<tr>
		<td class="columnSubheader jdlTextareaTd" colspan="5">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_daily_log_id--$deliveriesJobsiteNotes_uniqueId" type="hidden" value="$jobsite_daily_log_id">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_note_type_id--$deliveriesJobsiteNotes_uniqueId" type="hidden" value="$deliveries_jobsite_note_type_id">
			<textarea name="textarea" id="$deliveriesJobsiteNotes_HtmlElementId" class="jdlTextarea" onchange="$deliveriesJobsiteNotes_OnChange" placeholder="Type Delivery Notes here..." $is_disabled>$deliveriesJobsiteNotes_jobsite_note</textarea>
		</td>
	</tr>
</table>
<table border="0" cellpadding="4" cellspacing="0" width="100%" class="tableTabContentDetailsTabSection tableTabContentSectionNoGradient">
	<tr>
		<td colspan="5" class="columnHeader4">EXTRA WORK</td>
	</tr>
	<tr>
		<td class="columnSubheader jdlTextareaTd" colspan="5">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_daily_log_id--$extra_workJobsiteNotes_uniqueId" type="hidden" value="$jobsite_daily_log_id">
			<input id="manage-jobsite_note-record--jobsite_notes--jobsite_note_type_id--$extra_workJobsiteNotes_uniqueId" type="hidden" value="$extra_work_jobsite_note_type_id">
			<textarea name="textarea" id="$extra_workJobsiteNotes_HtmlElementId" class="jdlTextarea" onchange="$extra_workJobsiteNotes_OnChange" placeholder="Type Extra Work Notes here..." $is_disabled>$extra_workJobsiteNotes_jobsite_note</textarea>
		</td>
	</tr>
</table>
END_HTML_CONTENT;

	return $htmlContent;
}

function buildDCRPreviewSection($database, JobsiteDailyLog $jobsiteDailyLog, $user_company_id, $PDFOrHTML=null)
{

	$uri = Zend_Registry::get('uri');
	/* @var $uri Uri */

	$jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
	$project_id = $jobsiteDailyLog->project_id;
	$jobsite_daily_log_created_date = $jobsiteDailyLog->jobsite_daily_log_created_date;

	$project = $jobsiteDailyLog->getProject();
	/* @var $project Project */

	$user_company_id = $project->user_company_id;

	// Project info.
	$project_name = $project->project_name;

	$project->htmlEntityEscapeProperties();
	$project_escaped_address_line_1 = $project->escaped_address_line_1;
	$project_escaped_address_city = ($project->escaped_address_city)?$project->escaped_address_city.', ':'';
	$project_escaped_address_state_or_region = $project->escaped_address_state_or_region;
	$project_escaped_address_postal_code = $project->escaped_address_postal_code;

	$max_photos_displayed = $project->max_photos_displayed;
	$numberofphotos = '2';
	// if(!empty($project->photos_displayed_per_page)){
	// 	$numberofphotos = $project->photos_displayed_per_page;	
	// }
	

	//cost code divider
	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

	// Photo.
	$loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput = new Input();
	$loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput->forceLoadFlag = true;
	if(!empty($max_photos_displayed)){
		$loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput->limit = $max_photos_displayed; 	
	}
	
	$jobsitePhotos = JobsitePhoto::loadMostRecentJobsitePhotoByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput);
	/* @var $jobsitePhoto JobsitePhoto */

	// Debug

	$count = count($jobsitePhotos);
	$jobsitePhotoHtmlContents='';
	$checkInx = $counter = 0;
	foreach($jobsitePhotos as $jobsite_photo_id => $jobsitePhoto){
	if ($jobsitePhoto) {

		$jobsitePhotoFileManagerFile = $jobsitePhoto->getJobsitePhotoFileManagerFile();
		/* @var $jobsitePhotoFileManagerFile FileManagerFile */

		$jobsitePhotoCreated = $jobsitePhotoFileManagerFile->created;
		$jobsitePhotoCreatedUnixTimestamp = strtotime($jobsitePhotoCreated);
		$jobsitePhotoCreatedHtml = 'Photo uploaded ' . date('M d, Y g:ia', $jobsitePhotoCreatedUnixTimestamp);
		/*custome url change for imagick*/
		$jobsitePhotoUrl = $jobsitePhotoFileManagerFile->generateUrl();
		// to get the caption
		$jobsitephotoid = $jobsitePhoto->jobsite_photo_id;
		$captiondata  = TableService::getSingleField($database,'jobsite_photos','caption','id',$jobsitephotoid);

	
		$virtual_file_mime_type = $jobsitePhotoFileManagerFile->virtual_file_mime_type;
		if ($virtual_file_mime_type == 'application/pdf') {
			$jobsitePhotoHtml = '<embed src='.$jobsitePhotoUrl.' width="100%" height="100%">';
		} else {
			if($jobsitePhotoUrl !=''){
				list($imageWidth, $imageHeight) = PdfTools::renderDomPDFSaveImageSize($jobsitePhotoUrl);
			}
			$file_name = $jobsitePhotoFileManagerFile->file_location_id;
			$file_location_id = Data::parseInt($jobsitePhotoFileManagerFile->file_location_id);
			$arrPath = str_split($file_location_id, 2);
			$fileName = array_pop($arrPath);
			$shortFilePath = '';
			$path='';
			foreach ($arrPath as $pathChunk) {
				$path .= $pathChunk.'/';
				$shortFilePath .= $pathChunk.'/';
			}
			$config = Zend_Registry::get('config');
			$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
			$basedircs = $config->system->file_manager_base_path;
			$basepathcs = $config->system->file_manager_backend_storage_path ;
			$filename=$basedircs.$basepathcs.$shortFilePath.$file_manager_file_name_prefix.$fileName;
			$pdfPhantomJS = new PdfPhantomJS();
			$target = $pdfPhantomJS->getTempFileBasePath();
			/*Resize image start*/
			$jobsitePhotoUrlsize = $filename;
		    $path= realpath($jobsitePhotoUrlsize);
            $destination = $target.'_temp'.round(microtime(true)*1000);
             // Change the desired "WIDTH" and "HEIGHT"
            $newWidth = 800; // Desired WIDTH
            $newHeight = 800; // Desired HEIGHT
            $info   = getimagesize($path);
        	$mime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
        	$width  = $info[0]; // width as integer for ex. 512
        	$height = $info[1]; // height as integer for ex. 384
        	$type   = $info[2];      // same as exif_imagetype
        	if(intval($width) > 800 || intval($height) > 800){
        		resize($path,$destination,$newWidth,$newHeight);
        		$data = file_get_contents($destination);
        		$base64 = 'data:image;base64,' . base64_encode($data);	
        		$jobsitePhotoHtml = '<img alt="Jobsite Photo" style="max-height: auto; max-width: 100%;" src="'.$base64.'">';
        		unlink($destination);
        	}else{
 				$file_manager_file_id = $jobsitePhotoFileManagerFile->file_manager_file_id;
 			    //To get base path
 				$fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
 				$cdnFileUrl = $fileManagerFile->generateUrlBasePath(true);
 				$jobsitePhotoUrl = $jobsitePhotoFileManagerFile->generateUrlBasePath();
              	//End to get base path

 				$path= realpath($jobsitePhotoUrl);
 				$data = file_get_contents($jobsitePhotoUrl);
 				$base64 = 'data:image;base64,' . base64_encode($data);
 				$jobsitePhotoHtml = '<img alt="Jobsite Photo" style="max-height: 100mm; max-width: 100%;" src="'.$base64.'">';

 			}	
		}
		if($count > 0 && $checkInx == 0){
			$counthead="<h4 style='margin:5px 0;'>Attached Photos($count)</h4>";
		}else{
			$counthead='';
		}
		if(empty($numberofphotos) || $numberofphotos == '1'){
			$jobsitePhotoHtmlContents .= <<<END_HTML_CONTENT
		<div style="page-break-before: always;">
			$counthead
			<table class="dcrPreviewTable" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td style="padding: 0;" class="dcrPreviewImagecenter">
					<section style="margin: 5px 0;" class="dcrPreviewTableHeader">$jobsitePhotoCreatedHtml</section>
					$jobsitePhotoHtml
					<div><b>$captiondata </b> </div></td>
				</tr>
			</table>
		</div>
END_HTML_CONTENT;
		}else if(!empty($numberofphotos) && $numberofphotos == '2'){
			
			if ($counter  == 0) {
   				$jobsitePhotoHtmlContents .= <<<END_HTML_CONTENT
   				
		<div style="page-break-before: always; display: block;">
			$counthead
			<table class="dcrPreviewTable" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-height: 256mm;">
END_HTML_CONTENT;
			}
			$jobsitePhotoHtmlContents .= <<<END_HTML_CONTENT
				<tr>
					<td  class="dcrPreviewImagecenter" style="padding: 0;">
					<section style="margin: 5px 0;" class="dcrPreviewTableHeader">$jobsitePhotoCreatedHtml</section> 
					$jobsitePhotoHtml
					<div><b>$captiondata </b></div> </td>
				</tr>
			
END_HTML_CONTENT;

			if ($counter == 1) {
   				$jobsitePhotoHtmlContents .= <<<END_HTML_CONTENT
   				</table>
		</div>
END_HTML_CONTENT;
			 $counter = 0;
			}else if(($checkInx+1) ==  $count){
				$jobsitePhotoHtmlContents .= <<<END_HTML_CONTENT
   				</table>
		</div>
END_HTML_CONTENT;
			}else{
				$counter++;	
			}

		}
		

	} else {
		$jobsitePhotoUrl = '';
		$jobsitePhotoHtmlContents = '';
	}
	$checkInx++;
	}
	if($jobsitePhotoHtmlContents!='')
	{
		
	$jobsitePhotoHtmlContent = <<<HtmlPhos
		$jobsitePhotoHtmlContents
HtmlPhos;
	}else{
		$jobsitePhotoHtmlContent='';
	}

	// Debug to test performance of Dompdf without image rendering portion
	

	$jdlCreatedUnixTimestamp = strtotime($jobsite_daily_log_created_date);
	$jdlCreatedDate = date('F j, Y', $jdlCreatedUnixTimestamp);
	$dayOfWeek = date('N', $jdlCreatedUnixTimestamp);  // This format returns 1 for Monday, 2 for Tuesday, etc.

	// Weather info.
	$amTemperature = '';
	$amCondition = '';
	$pmTemperature = '';
	$pmCondition = '';


	// Manpower - today.
	// $manpowerActivityToday = 0;
	$loadJobsiteManPowerByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteManPowerByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteManPowerByJobsiteDailyLogIdOptions);
	$arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
	$arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];

	foreach ($arrJobsiteManPowerByJobsiteDailyLogId as $tmpJobsiteManPower) {
		/* @var $tmpJobsiteManPower JobsiteManPower */
		$number_of_people = $tmpJobsiteManPower->number_of_people;
		// $manpowerActivityToday = $manpowerActivityToday + $number_of_people;
	}

	$manpowerActivitySummaryByTrade = '';
	$loadSubcontractsByProjectIdInput = new Input();
	$loadSubcontractsByProjectIdInput->forceLoadFlag = true;
	$arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id, $loadSubcontractsByProjectIdInput, 1);
	$inTr = 0;
	$loopInTr = 0;
	$manpowerActivityToday = 0;
	$manPowerActArray = array();
	$countRfi = RequestForInformation::countOpenRfi($database, $project_id);
	foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
		/* @var $subcontract Subcontract */

		$gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
		/* @var $gcBudgetLineItem GcBudgetLineItem */

		$costCode = $gcBudgetLineItem->getCostCode();
		/* @var $costCode CostCode */

		$costCodeDivision = $costCode->getCostCodeDivision();
		/* @var $costCodeDivision CostCodeDivision */

		$costCode->htmlEntityEscapeProperties();
		$costCodeDivision->htmlEntityEscapeProperties();
		$htmlEntityEscapedFormattedCostCode = $costCodeDivision->escaped_division_number . $costCodeDividerType . $costCode->escaped_cost_code;

		$vendor = $subcontract->getVendor();
		/* @var $vendor Vendor */


		$contactCompany = $vendor->getVendorContactCompany();
		/* @var $contactCompany ContactCompany */

		$contactCompany->htmlEntityEscapeProperties();
		$escaped_contact_company_name = $contactCompany->escaped_contact_company_name;
		
		$number_of_people = 0;
		if (isset($arrJobsiteManPowerBySubcontractId[$subcontract_id])) {

			$tmpJobsiteManPower = $arrJobsiteManPowerBySubcontractId[$subcontract_id];
			/* @var $tmpJobsiteManPower JobsiteManPower */

			$number_of_people = $tmpJobsiteManPower->number_of_people;
			$manpowerActivityToday += $number_of_people;
			if($inTr != 0){
				$trClose="</tr>";
				$trOpen="<tr><td></td>";
			}else{
				$trClose="</tr>";
				$trOpen='<td class="thHeadtd">TODAY&nbsp;</td>';
			}			

			$manPowerActArray[$loopInTr]['col1'] = $escaped_contact_company_name." ".$htmlEntityEscapedFormattedCostCode;
			$manPowerActArray[$loopInTr]['col2'] = $number_of_people;

			$inTr++;
			$manpowerActivitySummaryByTrade .= <<<END_MANPOWER_ACTIVITY_SUMMARY_BY_TRADE
			$trOpen<td class="alignTDMan btBtTr">$escaped_contact_company_name $htmlEntityEscapedFormattedCostCode: </td><td class="valignTd" align="right">
			<span class="tdManspan">$number_of_people</span>
			</td>
			$trClose
END_MANPOWER_ACTIVITY_SUMMARY_BY_TRADE;
		$loopInTr++;
		}
			
	}
	if($manpowerActivitySummaryByTrade == '' || $loopInTr== 0){
		if($inTr != 0){
				$trClose="</tr>";
				$trOpen="<tr><td></td>";
			}else{
				$trClose="</tr>";
				$trOpen='<td class="thHeadtd">TODAY&nbsp;</td>';
			}

			$manPowerActArray[$loopInTr]['col1'] = '';
			$manPowerActArray[$loopInTr]['col2'] = $number_of_people;

			$inTr++;
			$manpowerActivitySummaryByTrade = <<<END_MANPOWER_ACTIVITY_SUMMARY_BY_TRADE
			$trOpen<td class="alignTDMan"></td><td class="valignTd" align="right">
			<span class="tdManspan">$number_of_people</span>
			</td>
			$trClose
END_MANPOWER_ACTIVITY_SUMMARY_BY_TRADE;
	}

	$todayManPowArr = array("col1"=>"TOTAL","col2"=>"");
	array_push($manPowerActArray,$todayManPowArr);

	$totalManPowArr = array("col1"=>"TODAY","col2"=>$manpowerActivityToday);
	array_push($manPowerActArray,$totalManPowArr);

	// Manpower - this week.
	$manpowerActivityThisWeek = 0;
	$format = 'Y-m-d';
	$interval = 0;
	$loadJobsiteManPowerByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteManPowerByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$tmpDayOfWeek = $dayOfWeek;
	while ($tmpDayOfWeek > 0) {
		$tmp_jobsite_daily_log_created_date = date($format, $jdlCreatedUnixTimestamp - $interval);

		$tmpJobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $tmp_jobsite_daily_log_created_date);
		/* @var $tmpJobsiteDailyLog JobsiteDailyLog */

		if ($tmpJobsiteDailyLog) {
			$temp_jobsite_daily_log_id = $tmpJobsiteDailyLog->jobsite_daily_log_id;
			$arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $temp_jobsite_daily_log_id, $loadJobsiteManPowerByJobsiteDailyLogIdOptions);
			$arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
			$arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];

			$arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id, $loadSubcontractsByProjectIdInput, 1);

			foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
				$number_of_people = 0;
				if (isset($arrJobsiteManPowerBySubcontractId[$subcontract_id])) {
					$tmpJobsiteManPower = $arrJobsiteManPowerBySubcontractId[$subcontract_id];	
					$number_of_people = $tmpJobsiteManPower->number_of_people;
					$manpowerActivityThisWeek += $number_of_people;
				}
			}
		}

		// 60 * 60 * 24 = 86400 (1 day in seconds)
		$interval = $interval + 86400;
		$tmpDayOfWeek--;
	}

	$totWeekManPowArr = array("col1"=>"CURRENT WEEK","col2"=>$manpowerActivityThisWeek);
	array_push($manPowerActArray,$totWeekManPowArr);

	// Inspections - today.
	$loadJobsiteInspectionsByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteInspectionsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrJobsiteInspectionsByJobsiteDailyLogId = JobsiteInspection::loadJobsiteInspectionsByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteInspectionsByJobsiteDailyLogIdOptions);
	$numInspectionsToday = count($arrJobsiteInspectionsByJobsiteDailyLogId);
	$inspectiondataArray = array();
	$inspectionCt = 0;
	$inspectiondata="<tr>
	<td class='thHeadtdNr'>INSPECTION TYPE</td>
	<td class='thHeadtdNr'>INSPECTION NOTES</td>
	<td class='thHeadtdNr textAlignCenter'>PASSED </td>
	</tr>";
	foreach ($arrJobsiteInspectionsByJobsiteDailyLogId as $key => $Inspections) {

		$inspectiondataArray[$inspectionCt]['col1'] = $Inspections['jobsite_inspection_type'];
		$inspectiondataArray[$inspectionCt]['col2'] = $Inspections['jobsite_inspection_note'];
		if ($Inspections['jobsite_inspection_passed_flag'] == 'Y') {
			$jobsite_inspection_passed_flag = "Yes";
		}else{
			$jobsite_inspection_passed_flag = "No";
		}
		$inspectiondataArray[$inspectionCt]['col3'] = $jobsite_inspection_passed_flag;

		$inspectiondata .="<tr class=''><td>".$Inspections['jobsite_inspection_type']."</td>
		<td>".$Inspections['jobsite_inspection_note']."</td><td class='textAlignCenter' >".$Inspections['jobsite_inspection_passed_flag']."</td></tr>";
		$inspectionCt++;
	}
	if($numInspectionsToday=='0')
	{
		$inspectiondata .="<tr><td colspan='3' class='textAlignCenter'>No Inspections Recorded</td></tr>" ;
		$inspectionEmptyArr = array("col1"=>"","col2"=>"","col3"=>"");
		array_push($inspectiondataArray,$inspectionEmptyArr);
	}
	
	// Inspections - this week.
	$numInspectionsThisWeek = 0;
	$format = 'Y-m-d';
	$interval = 0;
	$loadJobsiteInspectionsByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteInspectionsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$tmpDayOfWeek = $dayOfWeek;
	while ($tmpDayOfWeek > 0) {
		$tmp_jobsite_daily_log_created_date = date($format, $jdlCreatedUnixTimestamp - $interval);

		$tmpJobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $tmp_jobsite_daily_log_created_date);
		/* @var $tmpJobsiteDailyLog JobsiteDailyLog */

		if ($tmpJobsiteDailyLog) {
			$temp_jobsite_daily_log_id = $tmpJobsiteDailyLog->jobsite_daily_log_id;
			$arrJobsiteInspectionsByJobsiteDailyLogId = JobsiteInspection::loadJobsiteInspectionsByJobsiteDailyLogId($database, $temp_jobsite_daily_log_id, $loadJobsiteInspectionsByJobsiteDailyLogIdOptions);
			$numInspectionsThisWeek = $numInspectionsThisWeek + count($arrJobsiteInspectionsByJobsiteDailyLogId);
		}
		// 60 * 60 * 24 = 86400 (1 day in seconds)
		$interval = $interval + 86400;
		$tmpDayOfWeek--;
	}

	$countManPowerArray = count($manPowerActArray);
	$extraManPower = $countManPowerArray-$countRfi;
	if ($extraManPower < 0) {
		for ($x = 0; $x <= abs($extraManPower); $x++) {
			$emptyWeekManPowArr = array("col1"=>"","col2"=>"");
			array_push($manPowerActArray,$emptyWeekManPowArr);
		}
	}
	if ($extraManPower == 0) {
		$emptyWeekManPowArr = array("col1"=>"","col2"=>"");
		array_push($manPowerActArray,$emptyWeekManPowArr);
	}

	// RFIs.
	$loadRequestsForInformationByProjectIdOptions = new Input();
	$loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
	$arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByProjectId($database, $project_id, $loadRequestsForInformationByProjectIdOptions);
	$tableRequestsForInformationTbody = '';	
	$inRfi = 0;
	$rfiArray = array();
	foreach ($arrRequestsForInformation as $request_for_information_id => $requestForInformation) {
		/* @var $requestForInformation RequestForInformation */

		$requestForInformation->htmlEntityEscapeProperties();

		$requestForInformationStatus = $requestForInformation->getRequestForInformationStatus();
		$request_for_information_status = $requestForInformationStatus->request_for_information_status;
		if ($request_for_information_status == 'Open') {
			$rfi_sequence_number = $requestForInformation->rfi_sequence_number;
			$escaped_rfi_title = $requestForInformation->escaped_rfi_title;
			$rfi_created_timestamp = $requestForInformation->created;

			$rfiCreatedUnixTimestamp = strtotime($rfi_created_timestamp);
			$nowUnixTimestamp = strtotime(date('Y-m-d', $jdlCreatedUnixTimestamp));

			$difference = $nowUnixTimestamp - $rfiCreatedUnixTimestamp;
			$daysOpen = ceil($difference / 86400);

			$rfiArray[$inRfi]['col3'] = $rfi_sequence_number;
			$rfiArray[$inRfi]['col4'] = $escaped_rfi_title;
			$rfiArray[$inRfi]['col5'] = $daysOpen;

			$inRfi++;
			$tableRequestsForInformationTbody .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY

			<tr>
				<td>$rfi_sequence_number</td>
				<td>$escaped_rfi_title</td>
				<td align="center">$daysOpen</td>
			</tr>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;

		}

	}

	$countRfiArray = count($manPowerActArray)-count($rfiArray);
	if ($countRfiArray > 0) {
		for ($x = 0; $x <= abs($extraManPower); $x++) {
			$emptyRfiArr = array("col3"=>"","col4"=>"","col5"=>"");
			array_push($rfiArray,$emptyRfiArr);
		}
	}


	if ($countRfi == 0) {
		$tableRequestsForInformationTbody = '<tr><td colspan="3" class="textAlignCenter">No Data Found.</td></tr>';

		for ($x = 0; $x <= ($countManPowerArray-1); $x++) {
			$emptyRfiArr = array("col3"=>"","col4"=>"","col5"=>"");
			array_push($rfiArray,$emptyRfiArr);
		}
	}

	$combineManPowerRfiArr = array();
	foreach($manPowerActArray as $key=>$val){ 
	    $val2 = $rfiArray[$key]; 
	    $combineManPowerRfiArr[$key] = $val + $val2;
	}
	
	$tableCombineManPowerRfi = '';	
	foreach ($combineManPowerRfiArr as $key => $value) {
		$col1 = $combineManPowerRfiArr[$key]['col1'];
		if ($col1 == '' || $col1 == 'TOTAL' || $col1 == 'CURRENT WEEK' || $col1 == 'TODAY') {
			$col1Class = '';
		}else{
			$col1Class = 'btBtTr';
		}
		$col2 = $combineManPowerRfiArr[$key]['col2'];		
		if ($col1 == 'TOTAL' && $col2 == '') {
			$col1Class = 'thHeadtdNr';
		}
		$col3 = $combineManPowerRfiArr[$key]['col3'];
		$col4 = $combineManPowerRfiArr[$key]['col4'];
		$col5 = $combineManPowerRfiArr[$key]['col5'];
		$col4Class = '';
		if ($col4 == '' && $key == 0) {
			$col4 = "No Data Found.";
			$col4Class = 'alignCenter';
		}
		$tableCombineManPowerRfi .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY
			<tr>
				<td width="42%" class="paddingLeft textTop"><p style="font-size:12px;" class="$col1Class">$col1</p></td>
				<td width="8%" class="alignCenter textTop">$col2</td>
				<td width="8%" class="leftBorder paddingLeft textTop">$col3</td>
				<td width="32%" class="$col4Class textTop">$col4</td>
				<td width="10%" class="alignCenter textTop">$col5</td>
			</tr>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;
	}

	// Notes.
	$loadJobsiteNotesByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteNotesByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrJobsiteNotesByJobsiteDailyLogId = JobsiteNote::loadJobsiteNotesByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteNotesByJobsiteDailyLogIdOptions);
	$tableJobsiteNotesTbody = '';
	foreach ($arrJobsiteNotesByJobsiteDailyLogId as $jobsite_note_id => $jobsiteNote) {
		/* @var $jobsiteNote JobsiteNote */

		$jobsite_note_type_id = $jobsiteNote->jobsite_note_type_id;

		$jobsiteNote->htmlEntityEscapeProperties();
		$escaped_jobsite_note_nl2br = $jobsiteNote->escaped_jobsite_note_nl2br;

		$jobsiteNoteType = JobsiteNoteType::findById($database, $jobsite_note_type_id);
		/* @var $jobsiteNoteType JobsiteNoteType */

		$jobsiteNoteType->htmlEntityEscapeProperties();
		$escaped_jobsite_note_type_label = $jobsiteNoteType->escaped_jobsite_note_type_label;

		$tableJobsiteNotesTbody .= <<<END_TABLE_JOBSITE_NOTES_TBODY

		<tr>
			<td style="vertical-align:top">$escaped_jobsite_note_type_label: </td>
			<td style="vertical-align:top">$escaped_jobsite_note_nl2br</td>
		</tr>
END_TABLE_JOBSITE_NOTES_TBODY;

		$tableJobsiteNotesTbodyNew .= <<<END_TABLE_JOBSITE_NOTES_TBODY
		<tr><td class="thHeadtdNr paddingLeft">$escaped_jobsite_note_type_label</td></tr>
		<tr><td class="paddingLeft textJustify">$escaped_jobsite_note_nl2br</td></tr>
		<tr><td></td></tr>
END_TABLE_JOBSITE_NOTES_TBODY;

	}

	if (count($arrJobsiteNotesByJobsiteDailyLogId) == 0) {

		$tableJobsiteNotesTbody = <<<END_TABLE_JOBSITE_NOTES_TBODY

		<tr>
			<td colspan="2" class="" align="left">No Data Found</td>
		</tr>
END_TABLE_JOBSITE_NOTES_TBODY;

		$tableJobsiteNotesTbodyNew = <<<END_TABLE_JOBSITE_NOTES_TBODY
		<tr><td class="paddingLeft" align="left">No Jobsite Recorded.</td></tr>
END_TABLE_JOBSITE_NOTES_TBODY;

	}



	// SCHEDULE DELAYS.
	// jobsite_delays
	$loadJobsiteDelaysByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteDelaysByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrJobsiteDelays = JobsiteDelay::loadJobsiteDelaysByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteDelaysByJobsiteDailyLogIdOptions);

	$delayCount = count($arrJobsiteDelays);
	$inspectionCount = count($inspectiondataArray);
	$extraDelay = $delayCount - $inspectionCount;
	if ($extraDelay > 0) {
		for ($x = 0; $x < $extraDelay; $x++) {
			$emptyInspecArr = array("col1"=>"","col2"=>"","col3"=>"");
			array_push($inspectiondataArray,$emptyInspecArr);
		}
	}



	$tableJobsiteScheduleDelaysTbody = '';
	$delayCnt = 0;
	$delayArray = array();
	foreach ($arrJobsiteDelays as $jobsiteDelay) {
		/* @var $jobsiteDelay JobsiteDelay */


		$jobsiteDelayCategory = $jobsiteDelay->getJobsiteDelayCategory();
		/* @var $jobsiteDelayCategory JobsiteDelayCategory */

		if ($jobsiteDelayCategory) {
			$jobsiteDelayCategory->htmlEntityEscapeProperties();
			$escaped_jobsite_delay_category = $jobsiteDelayCategory->escaped_jobsite_delay_category;
		}

		$jobsiteDelaySubcategory = $jobsiteDelay->getJobsiteDelaySubcategory();
		/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */

		if ($jobsiteDelaySubcategory) {
			$jobsiteDelaySubcategory->htmlEntityEscapeProperties();
			$escaped_jobsite_delay_subcategory = $jobsiteDelaySubcategory->escaped_jobsite_delay_subcategory;
		}

		$jobsiteDelayNote = $jobsiteDelay->getJobsiteDelayNote();
		/* @var $jobsiteDelayNote JobsiteDelayNote */

		if ($jobsiteDelayNote && ($jobsiteDelayNote instanceof JobsiteDelayNote)) {
			$jobsiteDelayNote->htmlEntityEscapeProperties();

			$escaped_jobsite_delay_note_nl2br = $jobsiteDelayNote->escaped_jobsite_delay_note_nl2br;
		} else {
			$escaped_jobsite_delay_note_nl2br = '';
		}

		$delayArray[$delayCnt]['col4'] = $escaped_jobsite_delay_category;
		$delayArray[$delayCnt]['col5'] = $escaped_jobsite_delay_subcategory;
		$delayArray[$delayCnt]['col6'] = $escaped_jobsite_delay_note_nl2br;

		$tableJobsiteScheduleDelaysTbody .= <<<END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY

		<tr>
			<td style="vertical-align:top">$escaped_jobsite_delay_category &mdash; $escaped_jobsite_delay_subcategory: </td>
			<td style="vertical-align:top">$escaped_jobsite_delay_note_nl2br</td>
		</tr>
END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY;
	$delayCnt++;
	}

	if (count($arrJobsiteDelays) == 0) {

		$delayEmptArr = array("col4"=>"","col5"=>"","col6"=>"");
		array_push($delayArray,$delayEmptArr);

		$tableJobsiteScheduleDelaysTbody = <<<END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY
		<table class="dcrPreviewTable" border="0" cellpadding="4" cellspacing="0" width="100%">
		<tr>
		<td colspan="2" class="dcrPreviewTableHeader">SCHEDULE DELAYS</td>
		</tr>
		<tr>
			<td class="thHeadtdNr" width="25%">DELAY TYPE</td>
			<td class="thHeadtdNr">DELAY</td>
		</tr>
		<tr>
			<td colspan="2" class="" align="left">No Data Found.</td>
		</tr>
		</table>
		
END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY;

	}else{
		$tableJobsiteScheduleDelaysTbody = <<<END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY
		<table class="dcrPreviewTable" border="0" cellpadding="4" cellspacing="0" width="100%">
		<tr>
		<td colspan="2" class="dcrPreviewTableHeader">SCHEDULE DELAYS</td>
		</tr>
		<tr>
			<td class="thHeadtdNr" width="50%">DELAY TYPE</td>
			<td class="thHeadtdNr">DELAY</td>
		</tr>
			$tableJobsiteScheduleDelaysTbody
		</table>		
END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY;
	}

	$totalDelayArrCnt = count($delayArray);
	$extraDelayCnt = $totalDelayArrCnt - $inspectionCount;
	if ($extraDelayCnt < 0) {
		for ($x = 0; $x < abs($extraDelayCnt); $x++) {
			$emptyDelayArr = array("col4"=>"","col5"=>"","col6"=>"");
			array_push($delayArray,$emptyDelayArr);
		}
	}
	

	$combineInspectionDelayArr = array();
	foreach($inspectiondataArray as $key=>$val){ 
	    $val2 = $delayArray[$key]; 
	    $combineInspectionDelayArr[$key] = $val + $val2;
	}

	// echo "<pre>";
	// print_r($inspectiondataArray);
	// print_r($delayArray);
	// print_r($combineInspectionDelayArr);
	// echo "</pre>";


	$tablecombineInspectionDelay = '';	
	foreach ($combineInspectionDelayArr as $key => $value) {
		$col1 = $combineInspectionDelayArr[$key]['col1'];
		$col2 = $combineInspectionDelayArr[$key]['col2'];
		$col3 = $combineInspectionDelayArr[$key]['col3'];
		if ($key == 0 && $col1 == '') {
			$tablecombineInspectionDelay .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY
			<tr class="btBtTr">
				<td width="50%" class="alignCenter" colspan="3">No Inspections Recorded.</td>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;
		}else{
			$tablecombineInspectionDelay .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY
			<tr class="btBtTr">
				<td width="10%" class="textTop paddingLeft">$col1</td>
				<td width="32%" class="textTop textJustify">$col2</td>
				<td width="8%" class="textTop alignCenter">$col3</td>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;
		}		
		$col4 = $combineInspectionDelayArr[$key]['col4'];
		$col5 = $combineInspectionDelayArr[$key]['col5'];
		$col6 = $combineInspectionDelayArr[$key]['col6'];
		if ($key == 0 && $col4 == '') {
			$tablecombineInspectionDelay .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY
				<td width="50%" class="alignCenter leftBorder" colspan="3">No Schedule Delays Recorded.</td>
			</tr>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;
		}else{
		$tablecombineInspectionDelay .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY
				<td width="10%" class="textTop paddingLeft leftBorder">$col4</td>
				<td width="10%" class="textTop">$col5</td>
				<td width="30%" class="textTop textJustify">$col6</td>
			</tr>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;
		}
	}



	// Sitework Activities.
	$loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrReturn = JobsiteDailySiteworkActivityLog::loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions);
	$arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId = $arrReturn['objects'];
	$tableJobsiteSiteworkActivitiesTbody = '';
	$jobsiteSiteWorkData = '';
	foreach ($arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId as $jobsite_daily_sitework_activity_log_id => $jobsiteDailySiteworkActivityLog) {
		/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */

		$jobsite_sitework_region_id = $jobsiteDailySiteworkActivityLog->jobsite_sitework_region_id;
		$jobsiteSiteworkRegion = JobsiteSiteworkRegion::findById($database, $jobsite_sitework_region_id);
		/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */

		$jobsiteSiteworkRegion->htmlEntityEscapeProperties();

		$jobsite_sitework_activity_id = $jobsiteDailySiteworkActivityLog->jobsite_sitework_activity_id;
		$jobsiteSiteworkActivity = JobsiteSiteworkActivity::findById($database, $jobsite_sitework_activity_id);
		/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */

		$jobsiteSiteworkActivity->htmlEntityEscapeProperties();

		$escaped_jobsite_sitework_activity_label = $jobsiteSiteworkActivity->jobsite_sitework_activity_label;

		$tableJobsiteSiteworkActivitiesTbody .= <<<END_TABLE_JOBSITE_SITEWORK_ACTIVITIES_TBODY

		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;$escaped_jobsite_sitework_activity_label</td>
		</tr>
END_TABLE_JOBSITE_SITEWORK_ACTIVITIES_TBODY;

		$jobsiteSiteWorkData .=  $escaped_jobsite_sitework_activity_label." | ";
	}

	$jobsiteSiteWorkData =  rtrim($jobsiteSiteWorkData, " | ");

	if (count($arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId) == 0) {

		$tableJobsiteSiteworkActivitiesTbody = <<<END_TABLE_JOBSITE_SITEWORK_ACTIVITIES_TBODY

		<tr>
			<td class="textAlignCenter">No Sitework Activities Recorded</td>
		</tr>
END_TABLE_JOBSITE_SITEWORK_ACTIVITIES_TBODY;

		$jobsiteSiteWorkData .= "No Sitework Activities Recorded.";
	}

	// Building Activities.
	$loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions = new Input();
	$loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$arrReturn = JobsiteDailyBuildingActivityLog::loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions);
	$arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId = $arrReturn['objects'];
	$tableJobsiteBuildingActivitiesTbody = '';
	$jobsiteBuildingData = '';
	foreach ($arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId as $jobsite_daily_building_activity_log_id => $jobsiteDailyBuildingActivityLog) {
		/* @var $jobsiteDailyBuildingActivityLog JobsiteDailyBuildingActivityLog */

		/* @var $jobsiteBuilding JobsiteBuilding */

		$jobsite_building_activity_id = $jobsiteDailyBuildingActivityLog->jobsite_building_activity_id;
		$jobsiteBuildingActivity = JobsiteBuildingActivity::findById($database, $jobsite_building_activity_id);
		/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */

		$jobsiteBuildingActivity->htmlEntityEscapeProperties();

		$escaped_jobsite_building_activity_label = $jobsiteBuildingActivity->escaped_jobsite_building_activity_label;

		$tableJobsiteBuildingActivitiesTbody .= <<<END_TABLE_JOBSITE_BUILDING_ACTIVITIES_TBODY

		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;$escaped_jobsite_building_activity_label</td>
		</tr>
END_TABLE_JOBSITE_BUILDING_ACTIVITIES_TBODY;

		$jobsiteBuildingData .= $escaped_jobsite_building_activity_label." | ";
	}

	$jobsiteBuildingData =  rtrim($jobsiteBuildingData, " | ");

	if (count($arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId) == 0) {

		$tableJobsiteBuildingActivitiesTbody = <<<END_TABLE_JOBSITE_BUILDING_ACTIVITIES_TBODY

		<tr>
			<td class="textAlignCenter">No Building Activities Recorded</td>
		</tr>
END_TABLE_JOBSITE_BUILDING_ACTIVITIES_TBODY;

		$jobsiteBuildingData .= "No Building Activities Recorded.";
	}

	// Weather.
	/* @var $jobsiteDailyLog JobsiteDailyLog */

	$arrReturn = getAmPmWeatherTemperaturesAndConditions($database, $project_id, $jobsite_daily_log_created_date);
	$amTemperature = $arrReturn['amTemperature'];
	$amCondition   = $arrReturn['amCondition'];
	$pmTemperature = $arrReturn['pmTemperature'];
	$pmCondition   = $arrReturn['pmCondition'];


	/*GC logo*/
	require_once('lib/common/Logo.php');
	$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$user_company_id);
	$fulcrum = Logo::logoByFulcrumByBasePath();
	$headerLogo=<<<headerLogo
	<table width="100%" class="table-header">
 	<tr>
 	<td>$gcLogo</td>
 	<td align="right"><span style="margin-top:10px;">$fulcrum</span></td>
 	</tr>
 	</table>
 	<hr>
headerLogo;
	$projectAddress = '';
	if(!empty($project_escaped_address_line_1)){
		$projectAddress .= $project_escaped_address_line_1."<br>";
	}
	$projectAddress .= $project_escaped_address_city." ".$project_escaped_address_state_or_region." ".$project_escaped_address_postal_code;
	/*GC logo end*/
	$htmlContent = <<<END_HTML_CONTENT

<div id="dcrPreview">
$headerLogo
	<div>
		<center style="font-size: 200%;">JOBSITE DAILY LOG</center>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td width="50%">
					<table cellpadding="3">
						<tr>
							<td class="textAlignRight">PROJECT:</td>
							<td><b>$project_name</b></td>
						</tr>
						<tr>
							<td class="textAlignRight">ADDRESS:</td>
							<td>
								$projectAddress
							</td>
						</tr>
						<tr>
							<td class="textAlignRight">DATE:</td>
							<td>$jdlCreatedDate</td>
						</tr>
					</table>
				</td>
				<td width="50%">
					<table cellpadding="3">
						<tr>
							<td class="textAlignRight" nowrap>AM Temp:</td>
							<td nowrap>$amTemperature</td>
							<td class="textAlignRight" nowrap>AM Condition:</td>
							<td nowrap>$amCondition</td>
						</tr>
						<tr>
							<td class="textAlignRight">PM Temp:</td>
							<td>$pmTemperature</td>
							<td class="textAlignRight">PM Condition:</td>
							<td>$pmCondition</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="4" cellspacing="0" width="100%" class="dcrPreviewTable" style="border:1px solid black;">
			<tr class="bottomBorder">
				<td colspan="2" class="dcrPreviewTableHeader" width="50%">MANPOWER ACTIVITY</td>
				<td colspan="3" class="leftBorder dcrPreviewTableHeader" width="50%">OUTSTANDING RFIs</td>
			</tr>
			<tr>
				<td class="paddingLeft thHeadtdNr">TODAY</td>
				<td class="thHeadtdNr alignCenter">COUNT</td>
				<td class="leftBorder paddingLeft thHeadtdNr">RFI #</td>
				<td class="thHeadtdNr">RFI TITLE</td>
				<td class="thHeadtdNr">DAYS OPEN</td>
			</tr>
			$tableCombineManPowerRfi
		</table>
		<br>
		<table border="0" cellpadding="4" cellspacing="0" width="100%" class="dcrPreviewTable" style="border:1px solid black;">
			<tr class="bottomBorder">
				<td colspan="3" width="50%" class="dcrPreviewTableHeader">INSPECTIONS</td>
				<td colspan="3" class="leftBorder dcrPreviewTableHeader" width="50%">SCHEDULE DELAYS</td>
			</tr>
			<tr class="btBtTr">
				<td class="thHeadtdNr paddingLeft">TYPE</td>
				<td class="thHeadtdNr">INSPECTION NOTES</td>
				<td class="thHeadtdNr alignCenter">PASSED</td>
				<td class="thHeadtdNr leftBorder paddingLeft">CATEGORY</td>
				<td class="thHeadtdNr">SUBCATEGORY</td>
				<td class="thHeadtdNr">DELAY NOTES</td>
			</tr>
			$tablecombineInspectionDelay
			<tr>
				<td class="thHeadtdNr paddingLeft" colspan="3">TOTAL</td>
				<td colspan="3" class="leftBorder"></td>
			</tr>
			<tr>
				<td class="paddingLeft" colspan="2">TODAY</td>
				<td class="alignCenter">$numInspectionsToday</td>
				<td colspan="3" class="leftBorder"></td>
			</tr>
			<tr>
				<td class="paddingLeft" colspan="2">CURRENT WEEK</td>
				<td class="alignCenter">$numInspectionsThisWeek</td>
				<td colspan="3" class="leftBorder"></td>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="4" cellspacing="0" width="100%" class="dcrPreviewTable" style="border:1px solid black;">
			<tr class="bottomBorder">
				<td class="dcrPreviewTableHeader">CONSTRUCTION ACTIVITY</td>
			</tr>
			<tr>
				<td class="thHeadtdNr paddingLeft">SITEWORK ACTIVITY</td>
			</tr>
			<tr>
				<td class="paddingLeft textJustify">$jobsiteSiteWorkData</td>
			</tr>
			<tr><td></td></tr>
			<tr>
				<td class="thHeadtdNr paddingLeft">BUILDING ACTIVITY</td>
			</tr>
			<tr>
				<td class="paddingLeft textJustify">$jobsiteBuildingData</td>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="4" cellspacing="0" width="100%" class="dcrPreviewTable" style="border:1px solid black;">
			<tr class="bottomBorder">
				<td class="dcrPreviewTableHeader">JOBSITE NOTES</td>
			</tr>	
			$tableJobsiteNotesTbodyNew
		</table>
	</div>
	$jobsitePhotoHtmlContent
</div>
END_HTML_CONTENT;

	return $htmlContent;
}

function buildAdminSection($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $subtab='', $subsubtab='', $jobsite_activity_list_template_id=null)
{


	$activeSubtabProject = ' class="activeSubtab"';
	$activeSubtabTemplate = '';
	$showPrependedSubtabContent = false;
	$subsubtabAll = 'manageJobsiteActivities';
	$subsubtabBuilding = 'manageJobsiteBuildingActivities';
	$subsubtabSitework = 'manageJobsiteSiteworkActivities';
	$subsubtabOffsitework = 'manageJobsiteOffsiteworkActivities';
	$subsubtabAllSelected = $subsubtabBuildingSelected = $subsubtabSiteworkSelected = $subsubtabOffsiteworkSelected = '';

	if ($subtab == 'template') {
		$activeSubtabTemplate = ' class="activeSubtab"';
		$activeSubtabProject = '';
		$showPrependedSubtabContent = true;
		$subsubtabAll = 'manageJobsiteActivityTemplates';
		$subsubtabBuilding = 'manageJobsiteBuildingActivityTemplates';
		$subsubtabSitework = 'manageJobsiteSiteworkActivityTemplates';
		$subsubtabOffsitework = 'manageJobsiteOffsiteworkActivityTemplates';
		$subsubtabAllSelected = 'class="hidden"';
	}

	$htmlContent = <<<END_HTML_CONTENT
<div class="divSubtabs" style="padding: 5px 10px;">
<ul>
<li><a href="javascript:subtabClicked('project');" $activeSubtabProject>$currentlySelectedProjectName Project Data</a></li>
<li><a href="javascript:subtabClicked('template');" $activeSubtabTemplate>Template Data</a></li>
</ul>
</div>
END_HTML_CONTENT;

	if ($showPrependedSubtabContent) {
		$js = 'onchange="jobsiteActivityListTemplateSelected(this);"';
		$prependedOption = '<option value="">Please Select a Template</option>';
		$loadJobsiteActivityListTemplatesByUserCompanyIdOptions = new Input();
		$loadJobsiteActivityListTemplatesByUserCompanyIdOptions->forceLoadFlag = true;
		$arrJobsiteActivityListTemplates = JobsiteActivityListTemplate::loadJobsiteActivityListTemplatesByUserCompanyId($database, $user_company_id, $loadJobsiteActivityListTemplatesByUserCompanyIdOptions);
		$ddlJobsiteActivityListTemplates = PageComponents::dropDownListFromObjects('ddlJobsiteActivityListTemplates', $arrJobsiteActivityListTemplates, 'jobsite_activity_list_template_id', null, 'jobsite_activity_list_template', null, $jobsite_activity_list_template_id, '', $js, $prependedOption);
		$prependedSubtabContent =
		'
		<div style="padding:10px;">
			'.$ddlJobsiteActivityListTemplates.'
			<input type="button" value="Manage Jobsite Activity List Templates" onclick="loadManageJobsiteActivityListTemplates();">
		</div>
		<div id="divCreateJobsiteActivityListTemplateDialog" class="hidden"></div>
		<div id="divManageJobsiteActivityListTemplates" class="hidden" style="font-size: 90%;"></div>
		';
		$htmlContent .= $prependedSubtabContent;
	}

	$subsubtabContent = '';
	if ($subsubtab == 'manageJobsiteActivityListTemplates') {
		$subsubtabContent = buildAdminManageJobsiteActivityListTemplates($database, $user_company_id);
		$subsubtabAllSelected = ' class="activeSubtab"';
	} elseif ($subsubtab == 'manageJobsiteActivityLabels') {
		$subsubtabContent = buildAdminManageJobsiteActivityLabels($database, $user_company_id, $project_id, $currentlySelectedProjectName);
		$subsubtabAllSelected = ' class="activeSubtab"';
	} elseif ($subsubtab == 'manageJobsiteBuildingActivities') {
		$subsubtabContent = buildAdminManageJobsiteBuildingActivities($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName);
		$subsubtabBuildingSelected = ' class="activeSubtab"';
	} elseif ($subsubtab == 'manageJobsiteOffsiteworkActivities') {
		$subsubtabContent = buildAdminManageJobsiteOffsiteworkActivities($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName);
		$subsubtabOffsiteworkSelected = ' class="activeSubtab"';
	} elseif ($subsubtab == 'manageJobsiteSiteworkActivities') {
		$subsubtabContent = buildAdminManageJobsiteSiteworkActivities($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName);
		$subsubtabSiteworkSelected = ' class="activeSubtab"';
	} elseif ($subsubtab == 'manageJobsiteBuildingActivityTemplates') {
		$subsubtabContent = buildAdminManageJobsiteBuildingActivityTemplates($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $jobsite_activity_list_template_id);
		$subsubtabBuildingSelected = ' class="activeSubtab"';
	} elseif ($subsubtab == 'manageJobsiteOffsiteworkActivityTemplates') {
		$subsubtabContent = buildAdminManageJobsiteOffsiteworkActivityTemplates($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $jobsite_activity_list_template_id);
		$subsubtabOffsiteworkSelected = ' class="activeSubtab"';
	} elseif ($subsubtab == 'manageJobsiteSiteworkActivityTemplates') {
		$subsubtabContent = buildAdminManageJobsiteSiteworkActivityTemplates($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $jobsite_activity_list_template_id);
		$subsubtabSiteworkSelected = ' class="activeSubtab"';
	} elseif ($subsubtab == 'manageJobsiteActivities') {
		$subsubtabContent = buildAdminManageJobsiteActivities($database, $user_company_id, $project_id, $currentlySelectedProjectName);
		$subsubtabAllSelected = ' class="activeSubtab"';
	} elseif ($subsubtab == 'manageJobsiteActivityTemplates') {
		$subsubtabContent = ''; 
		$subsubtabAllSelected = ' class="activeSubtab"';
	}

	$htmlContent .= <<<END_HTML_CONTENT
<div class="divSubtabs" style="padding:0 10px;">
<ul>
<li><a href="#" onclick="subsubtabClicked(this, '$subsubtabBuilding'); return false;" $subsubtabBuildingSelected>Building Activities</a></li>
<li><a href="#" onclick="subsubtabClicked(this, '$subsubtabSitework'); return false;" $subsubtabSiteworkSelected>Sitework Activities</a></li>
<li><a href="#" onclick="subsubtabClicked(this, '$subsubtabOffsitework'); return false;" $subsubtabOffsiteworkSelected>Offsitework Activities</a></li>
<li><a href="#" onclick="subsubtabClicked(this, '$subsubtabAll'); return false;" $subsubtabAllSelected>All Activities</a></li>
</ul>
</div>
<div id="divContent">
$subsubtabContent
</div>
END_HTML_CONTENT;

	return $htmlContent;
}

function buildAdminManageJobsiteActivityListTemplates($database, $user_company_id)
{
	$dummyRecordPrimaryKey = 'dummy_id-'.uniqid();

	// Project Type Drop Down List (DDL)
	// @todo Add user_company_id and sort_order to the project_types table.
	$loadProjectTypesByUserCompanyIdOptions = new Input();
	$loadProjectTypesByUserCompanyIdOptions->forceLoadFlag = true;
	$arrProjectTypesByUserCompanyId = ProjectType::loadProjectTypesByUserCompanyId($database, $user_company_id, $loadProjectTypesByUserCompanyIdOptions);
	$defaultProjectTypeId = key($arrProjectTypesByUserCompanyId);
	$ddlProjectTypesId = "ddl--create-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--$dummyRecordPrimaryKey";
	$js = <<<END_JS
class="required" onchange="ddlOnChange_UpdateHiddenInputValue(this, 'create-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--$dummyRecordPrimaryKey');"
END_JS;
	$prependedOption = '<option value="">Please Select a Project Type</option>';
	$ddlProjectTypes = PageComponents::dropDownListFromObjects($ddlProjectTypesId, $arrProjectTypesByUserCompanyId, 'project_type_id', null, 'project_type', null, $defaultProjectTypeId, '', $js, $prependedOption);

	$htmlContent = <<<END_HTML_CONTENT

<input id="formattedAttributeGroupName--create-jobsite_activity_list_template-record" type="hidden" value="Jobsite Activity List Template">
<input id="formattedAttributeSubgroupName--create-jobsite_activity_list_template-record" type="hidden" value="Jobsite Activity List Template">
<input id="formattedAttributeGroupName--manage-jobsite_activity_list_template-record" type="hidden" value="Jobsite Activity List Template">
<input id="formattedAttributeSubgroupName--manage-jobsite_activity_list_template-record" type="hidden" value="Jobsite Activity List Template">

<form id="formCreateJobsiteActivityListTemplate" class="content right">
<input id="create-jobsite_activity_list_template-record--jobsite_activity_list_templates--user_company_id--$dummyRecordPrimaryKey" type="hidden" value="$user_company_id">
<input id="create-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--$dummyRecordPrimaryKey" type="hidden" value="1">
<div class="widgetContainer" style="width: 570px;">
	<h3 class="title">Create New Jobsite Activity List Template</h3>
	<table id="container--create-jobsite_activity_list_template-record--$dummyRecordPrimaryKey" class="content" cellpadding="5" width="95%">

		<tr>
			<td class="textAlignRight verticalAlignMiddle">Jobsite Activity List Template:</td>
			<td>
				<input id="create-jobsite_activity_list_template-record--jobsite_activity_list_templates--jobsite_activity_list_template--$dummyRecordPrimaryKey" class="required" style="width: 320px;;" type="text" value="">

			</td>
		</tr>

		<tr>
			<td class="textAlignRight verticalAlignMiddle">Project Type:</td>
			<td class="textAlignLeft">$ddlProjectTypes</td>
		</tr>

		<tr>
			<td></td>
			<td class="textAlignRight">
				<input type="button" value="Reset" onclick="Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__Modal_Dialog__Reset_Form('$dummyRecordPrimaryKey', $defaultProjectTypeId);">
				<input type="button" value="Create Jobsite Activity List Template" onclick="Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__createJobsiteActivityListTemplate('create-jobsite_activity_list_template-record', '$dummyRecordPrimaryKey');">
			</td>
		</tr>

	</table>
</div>

</form>
END_HTML_CONTENT;

	$htmlContent .= <<<END_HTML_CONTENT

<div class="widgetContainer" style="width: 1000px;">
	<h3 class="title">Manage Jobsite Activity List Templates</h3>
	<table id="tableJobsiteActivityListTemplates" class="content" style="width:95%" cellpadding="5">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th class="textAlignLeft">Jobsite Activity List Template</th>
				<th class="textAlignLeft">Project Type</th>
				<th class="textAlignCenter">Disabled</th>
				<th class="textAlignCenter">Delete</th>
			</tr>
		</thead>
		<tbody class="altColors">
END_HTML_CONTENT;

	$loadJobsiteActivityListTemplatesByUserCompanyIdOptions = new Input();
	$loadJobsiteActivityListTemplatesByUserCompanyIdOptions->forceLoadFlag = true;
	$arrJobsiteActivityListTemplates = JobsiteActivityListTemplate::loadJobsiteActivityListTemplatesByUserCompanyId($database, $user_company_id, $loadJobsiteActivityListTemplatesByUserCompanyIdOptions);
	$jobsiteActivityLabelTableTbodyHtml = '';
	foreach ($arrJobsiteActivityListTemplates as $jobsite_activity_list_template_id => $jobsiteActivityListTemplate) {
		/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */

		$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();

		$jobsiteActivityListTemplate->htmlEntityEscapeProperties();

		$jobsite_activity_list_template = $jobsiteActivityListTemplate->jobsite_activity_list_template;
		$escaped_jobsite_activity_list_template = $jobsiteActivityListTemplate->escaped_jobsite_activity_list_template;
		$disabled_flag = $jobsiteActivityListTemplate->disabled_flag;
		$sort_order = $jobsiteActivityListTemplate->sort_order;

		$checked = '';
		if ($disabled_flag == 'Y') {
			$checked = 'checked';
			$checkBoxValue = 'Y';
		} else {
			$checked = '';
			$checkBoxValue = 'N';
		}

		$ddlProjectTypesId = 'manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--'.$jobsite_activity_list_template_id;
		$ddlProjectTypesJs = 'onchange="updateJobsiteActivityListTemplate(this);"';
		$project_type_id = $jobsiteActivityListTemplate->project_type_id;
		$ddlProjectTypes = PageComponents::dropDownListFromObjects($ddlProjectTypesId, $arrProjectTypesByUserCompanyId, 'project_type_id', null, 'project_type', null, $project_type_id, '', $ddlProjectTypesJs, '');

		$htmlContent .= <<<END_HTML_ROW

			<tr id="record_container--manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--sort_order--$jobsite_activity_list_template_id">
				<td class="tdSortBars textAlignCenter"><input type="hidden" value="$sort_order"><img src="/images/sortbars.png"></td>
				<td class="textAlignLeft"><input type="text" style="width:300px" value="$escaped_jobsite_activity_list_template" onchange="updateJobsiteActivityListTemplate(this);" id="manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--jobsite_activity_list_template--$jobsite_activity_list_template_id"></td>
				<td class="textAlignLeft">$ddlProjectTypes</td>
				<td class="textAlignCenter"><input type="checkbox" onchange="updateJobsiteActivityListTemplate(this);" id="manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--disabled_flag--$jobsite_activity_list_template_id" $checked></td>
				<td class="textAlignCenter"><a href="javascript:Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__deleteJobsiteActivityListTemplate('record_container--manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--sort_order--$jobsite_activity_list_template_id', 'manage-jobsite_activity_list_template-record', '$jobsite_activity_list_template_id');">X</a></td>
			</tr>
END_HTML_ROW;

	}

	//$htmlCreateRecordBottom = str_replace('---find_replace_dummy_primary_key---', $dummyRecordPrimaryKeyBottom, $htmlCreateRecord);
	//$htmlContent .= $htmlCreateRecordBottom;
	$htmlContent .= <<<END_HTML_FORM

		</tbody>
	</table>
</div>
END_HTML_FORM;

	return $htmlContent;
}

function buildAdminManageJobsiteActivityLabels($database, $user_company_id, $project_id, $currentlySelectedProjectName)
{
	$loadJobsiteActivityLabelsByUserCompanyIdOptions = new Input();
	$loadJobsiteActivityLabelsByUserCompanyIdOptions->forceLoadFlag = true;
	$arrJobsiteActivityLabelsByUserCompanyId = JobsiteActivityLabel::loadJobsiteActivityLabelsByUserCompanyId($database, $user_company_id, $loadJobsiteActivityLabelsByUserCompanyIdOptions);

	// These load operations should pull from project_id OR jobsite_activity_list_template_id

	$loadJobsiteBuildingActivitiesByProjectIdOptions = new Input();
	$loadJobsiteBuildingActivitiesByProjectIdOptions->extendedReturn	= true;
	$loadJobsiteBuildingActivitiesByProjectIdOptions->filterByCostCode	= false;
	$loadJobsiteBuildingActivitiesByProjectIdOptions->forceLoadFlag		= true;

	// jobsite_building_activities (project_id case)
	// or
	// jobsite_building_activity_templates (jobsite_activity_list_template_id case)
	$arrTmp = JobsiteBuildingActivity::loadJobsiteBuildingActivitiesByProjectId($database, $project_id, $loadJobsiteBuildingActivitiesByProjectIdOptions);
	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteBuildingActivityIds = $arrTmp['jobsite_building_activity_ids'];
	$arrJobsiteBuildingActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_building_activities_by_cost_code_id'];
	$arrJobsiteBuildingActivitiesByProjectIdByJobsiteBuildingActivityLabel = $arrTmp['jobsite_building_activities_by_project_id_by_jobsite_building_activity_label'];
	$arrJobsiteBuildingActivitiesByProjectId = $arrTmp['jobsite_building_activities_by_project_id'];
	$jobsiteBuildingActivityLabelMaxLength = $arrTmp['jobsite_building_activity_label_maxlength'];

	// jobsite_offsitework_activities (project_id case)
	// or
	// jobsite_offsitework_activity_templates (jobsite_activity_list_template_id case)
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions = new Input();
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->extendedReturn = true;
	$arrTmp = JobsiteOffsiteworkActivity::loadJobsiteOffsiteworkActivitiesByProjectId($database, $project_id, $loadJobsiteOffsiteworkActivitiesByProjectIdOptions);

	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteOffsiteworkActivityIds = $arrTmp['jobsite_offsitework_activity_ids'];
	$arrJobsiteOffsiteworkActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_offsitework_activities_by_cost_code_id'];
	$arrJobsiteOffsiteworkActivitiesByProjectIdByJobsiteOffsiteworkActivityLabel = $arrTmp['jobsite_offsitework_activities_by_project_id_by_jobsite_offsitework_activity_label'];
	$arrJobsiteOffsiteworkActivitiesByProjectId = $arrTmp['jobsite_offsitework_activities_by_project_id'];
	$jobsiteOffsiteworkActivityLabelMaxLength = $arrTmp['jobsite_offsitework_activity_label_maxlength'];

	// jobsite_sitework_activities (project_id case)
	// or
	// jobsite_sitework_activity_templates (jobsite_activity_list_template_id case)
	$loadJobsiteSiteworkActivitiesByProjectIdOptions = new Input();
	$loadJobsiteSiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
	$loadJobsiteSiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
	$loadJobsiteSiteworkActivitiesByProjectIdOptions->extendedReturn = true;
	$arrTmp = JobsiteSiteworkActivity::loadJobsiteSiteworkActivitiesByProjectId($database, $project_id, $loadJobsiteSiteworkActivitiesByProjectIdOptions);
	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteSiteworkActivityIds = $arrTmp['jobsite_sitework_activity_ids'];
	$arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_sitework_activities_by_cost_code_id'];
	$arrJobsiteSiteworkActivitiesByProjectIdByJobsiteSiteworkActivityLabel = $arrTmp['jobsite_sitework_activities_by_project_id_by_jobsite_sitework_activity_label'];
	$arrJobsiteSiteworkActivitiesByProjectId = $arrTmp['jobsite_sitework_activities_by_project_id'];
	$jobsiteSiteworkActivityLabelMaxLength = $arrTmp['jobsite_sitework_activity_label_maxlength'];



	$htmlForm = <<<END_HTML_CONTENT

<div style="margin: 15px; margin-top: 30px;"><input type="button" value="Create Jobsite Activity Label" onclick="showCreateJobsiteActivityLabel();"></div>
<div id="divCreateJobsiteActivityLabel" class="widgetContainer hidden" style="width: 500px;">
	<form id="formCreateJobsiteActivityLabel">
	<h3 class="title">
		Create New Jobsite Activity Label
		<div style="float: right;">
			<span class="entypo entypo-click entypo-cancel" onclick="hideCreateJobsiteActivityLabel();" style="margin-right: 0;"></span>
		</div>
	</h3>
	<table class="content" cellpadding="5" width="95%">
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Label:</td>
			<td class="textAlignLeft"><input type="text" id="create-jobsite_activity_label-record--jobsite_activity_labels--jobsite_activity_label--dummy" style="width:370px;"></td>
		</tr>
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Description:</td>
			<td class="textAlignLeft"><input type="text" id="create-jobsite_activity_label-record--jobsite_activity_labels--jobsite_activity_description--dummy" style="width:370px;"></td>
		</tr>
		<tr>
			<td></td>
			<td class="textAlignRight">
				<input type="button" value="Create Jobsite Activity Label" onclick="createJobsiteActivityLabel('create-jobsite_activity_label-record', 'dummy');">
				<input id="create-jobsite_activity_label-record--jobsite_activity_labels--user_company_id--dummy" type="hidden" value="$user_company_id">
			</td>
		</tr>
	</table>
	</form>
</div>
END_HTML_CONTENT;

	$dummyRecordPrimaryKeyTop = 'dummy_id_top-'.uniqid();
	$dummyRecordPrimaryKeyBottom = 'dummy_id_bottom-'.uniqid();
	$htmlForm = str_replace('---find_replace_dummy_primary_key---', $dummyRecordPrimaryKeyTop, $htmlForm);

	$htmlForm .= <<<END_HTML_CONTENT

<div class="widgetContainer" style="width: 1000px;">
	<h3 class="title">Manage Jobsite Activity Labels</h3>
	<table id="record_list_container--manage-jobsite_activity_label-record" class="content" style="width:95%" cellpadding="5">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th class="textAlignLeft">Label</th>
				<th class="textAlignCenter">Building</th>
				<th class="textAlignCenter">Sitework</th>
				<th class="textAlignCenter">Offsitework</th>
				<th class="textAlignCenter">Disabled</th>
				<th class="textAlignCenter">Delete</th>
			</tr>
		</thead>
		<tbody class="altColors">
END_HTML_CONTENT;

	$jobsiteActivityLabelTableTbodyHtml = '';
	// Debug.
	foreach ($arrJobsiteActivityLabelsByUserCompanyId as $jobsite_activity_label_id => $jobsiteActivityLabel) {
		/* @var $jobsiteActivityLabel JobsiteActivityLabel */

		// Debug.

		$primaryKeyAsString = $jobsiteActivityLabel->getPrimaryKeyAsString();

		$jobsiteActivityLabel->htmlEntityEscapeProperties();

		$jobsite_activity_label = $jobsiteActivityLabel->jobsite_activity_label;
		$escaped_jobsite_activity_label = $jobsiteActivityLabel->escaped_jobsite_activity_label;
		$jobsite_activity_description = $jobsiteActivityLabel->jobsite_activity_description;
		$escaped_jobsite_activity_description = $jobsiteActivityLabel->escaped_jobsite_activity_description;
		$disabled_flag = $jobsiteActivityLabel->disabled_flag;
		$sort_order = $jobsiteActivityLabel->sort_order;

		$checked = '';
		if ($disabled_flag == 'Y') {
			$checked = 'checked';
		}
		$data = $jobsiteActivityLabel->getData();

		// Checking a checkbox: INSERT INTO jobsite_building_activities, jobsite_offsitework_activities, jobsite_sitework_activities
		$buildingChecked = '';
		$siteworkChecked = '';
		$offsiteworkChecked = '';

		if (isset($arrJobsiteBuildingActivitiesByProjectIdByJobsiteBuildingActivityLabel[$jobsite_activity_label])) {
			$buildingChecked = 'checked';
			list($jobsite_building_activity_id, $jobsiteBuildingActivity) = each($arrJobsiteBuildingActivitiesByProjectIdByJobsiteBuildingActivityLabel[$jobsite_activity_label]);
		} else {

			// dummy id
			$jobsite_building_activity_id = '';
			// Add button to insert the jobsite_activity_label into jobsite_building_activities

			$buildingHtmlElement = <<<END_HTML_CONTENT
<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteBuildingActivity('create-jobsite_building_activity-record', $jobsite_activity_label_id);"></span>
<input id="create-jobsite_building_activity-record--jobsite_building_activities--jobsite_building_activity_label--$jobsite_activity_label_id" type="hidden" value="$escaped_jobsite_activity_label">
END_HTML_CONTENT;

		}

		if (isset($arrJobsiteSiteworkActivitiesByProjectIdByJobsiteSiteworkActivityLabel[$jobsite_activity_label])) {

			$siteworkChecked = 'checked';
			list($jobsite_sitework_activity_id, $jobsiteSiteworkActivity) = each($arrJobsiteSiteworkActivitiesByProjectIdByJobsiteSiteworkActivityLabel[$jobsite_activity_label]);

			$siteworkHtmlElement = <<<END_SITEWORK_HTML_ELEMENT
<span class="entypo entypo-click entypo-check" onclick="deleteJobsiteSiteworkActivity('', 'delete-jobsite_sitework_activity-record', $jobsite_sitework_activity_id, { responseDataType: 'json' });"></span>
END_SITEWORK_HTML_ELEMENT;

		} else {

			$jobsite_sitework_activity_id = '';
			// <input id="manage-jobsite_sitework_activity-record--jobsite_sitework_activities--jobsite_sitework_activity_id--{$jobsite_sitework_activity_id}-2" type="checkbox" name="jobsite_sitework_activity_id--$jobsite_sitework_activity_id" $siteworkChecked>
			$siteworkHtmlElement = '';

			$siteworkHtmlElement = <<<END_SITEWORK_HTML_ELEMENT
<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteSiteworkActivity('create-jobsite_sitework_activity-record', $jobsite_activity_label_id);"></span>
<input type="hidden" id="create-jobsite_sitework_activity-record--jobsite_sitework_activities--jobsite_sitework_activity_label--$jobsite_activity_label_id" value="$escaped_jobsite_activity_label">
END_SITEWORK_HTML_ELEMENT;

		}

		if (isset($arrJobsiteOffsiteworkActivitiesByProjectIdByJobsiteOffsiteworkActivityLabel[$jobsite_activity_label])) {

			$offsiteworkChecked = 'checked';
			list($jobsite_offsitework_activity_id, $jobsiteOffsiteworkActivity) = each($arrJobsiteOffsiteworkActivitiesByProjectIdByJobsiteOffsiteworkActivityLabel[$jobsite_activity_label]);

			$offsiteworkHtmlElement = <<<END_OFFSITEWORK_HTML_ELEMENT
<span class="entypo entypo-click entypo-check" onclick="deleteJobsiteOffsiteworkActivity('', 'delete-jobsite_offsitework_activity-record', $jobsite_offsitework_activity_id);"></span>
END_OFFSITEWORK_HTML_ELEMENT;

		} else {
			$jobsite_offsitework_activity_id = '';
			// <input id="manage-jobsite_offsitework_activity-record--jobsite_offsitework_activities--jobsite_offsitework_activity_id--$jobsite_offsitework_activity_id-3" type="checkbox" name="jobsite_offsitework_activity_id--$jobsite_offsitework_activity_id" $offsiteworkChecked>
			$offsiteworkHtmlElement = '';

			$offsiteworkHtmlElement = <<<END_OFFSITEWORK_HTML_ELEMENT
<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteOffsiteworkActivity('create-jobsite_offsitework_activity-record', $jobsite_activity_label_id, { responseDataType: 'json' });"></span>
<input type="hidden" id="create-jobsite_offsitework_activity-record--jobsite_offsitework_activities--jobsite_offsitework_activity_label--$jobsite_activity_label_id" value="$jobsite_activity_label">
END_OFFSITEWORK_HTML_ELEMENT;
		}

		$htmlForm .= <<<END_HTML_ROW

				<tr id="record_container--manage-jobsite_activity_label-record--jobsite_activity_labels--sort_order--$jobsite_activity_label_id">
					<td class="tdSortBars textAlignCenter"><input type="hidden" value="$sort_order"><img src="/images/sortbars.png"></td>
					<td class="textAlignLeft"><input type="text" style="width:300px" value="$jobsite_activity_label" onchange="updateJobsiteActivityLabel(this);" id="manage-jobsite_activity_label-record--jobsite_activity_labels--jobsite_activity_label--$jobsite_activity_label_id"></td>
					<td class="textAlignCenter hoverColorChange">$buildingHtmlElement</td>
					<td class="textAlignCenter hoverColorChange">$siteworkHtmlElement</td>
					<td class="textAlignCenter hoverColorChange">$offsiteworkHtmlElement</td>
					<td class="textAlignCenter"><input type="checkbox" onchange="updateJobsiteActivityLabel(this);" id="manage-jobsite_activity_label-record--jobsite_activity_labels--disabled_flag--$jobsite_activity_label_id" $checked></td>
					<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="deleteJobsiteActivityLabel('record_container--manage-jobsite_activity_label-record--jobsite_activity_labels--sort_order--$jobsite_activity_label_id', 'manage-jobsite_activity_label-record', '$jobsite_activity_label_id', { responseDataType: 'json' });"></span></td>
				</tr>
END_HTML_ROW;

	}


	$htmlForm .= <<<END_HTML_FORM

		</tbody>
	</table>
</div>
END_HTML_FORM;

	return $htmlForm;
}

function buildAdminManageJobsiteActivities($database, $user_company_id, $project_id, $currentlySelectedProjectName)
{
	$loadJobsiteActivityLabelsByUserCompanyIdOptions = new Input();
	$loadJobsiteActivityLabelsByUserCompanyIdOptions->forceLoadFlag = true;
	$arrJobsiteActivityLabelsByUserCompanyId = JobsiteActivityLabel::loadJobsiteActivityLabelsByUserCompanyId($database, $user_company_id, $loadJobsiteActivityLabelsByUserCompanyIdOptions);

	// These load operations should pull from project_id OR jobsite_activity_list_template_id

	$loadJobsiteBuildingActivitiesByProjectIdOptions = new Input();
	$loadJobsiteBuildingActivitiesByProjectIdOptions->extendedReturn	= true;
	$loadJobsiteBuildingActivitiesByProjectIdOptions->filterByCostCode	= false;
	$loadJobsiteBuildingActivitiesByProjectIdOptions->forceLoadFlag		= true;

	// jobsite_building_activities (project_id case)
	// or
	// jobsite_building_activity_templates (jobsite_activity_list_template_id case)
	$arrTmp = JobsiteBuildingActivity::loadJobsiteBuildingActivitiesByProjectId($database, $project_id, $loadJobsiteBuildingActivitiesByProjectIdOptions);
	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteBuildingActivityIds = $arrTmp['jobsite_building_activity_ids'];
	$arrJobsiteBuildingActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_building_activities_by_cost_code_id'];
	$arrJobsiteBuildingActivitiesByProjectIdByJobsiteBuildingActivityLabel = $arrTmp['jobsite_building_activities_by_project_id_by_jobsite_building_activity_label'];
	$arrJobsiteBuildingActivitiesByProjectId = $arrTmp['jobsite_building_activities_by_project_id'];
	$jobsiteBuildingActivityLabelMaxLength = $arrTmp['jobsite_building_activity_label_maxlength'];

	// jobsite_offsitework_activities (project_id case)
	// or
	// jobsite_offsitework_activity_templates (jobsite_activity_list_template_id case)
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions = new Input();
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->extendedReturn = true;
	$arrTmp = JobsiteOffsiteworkActivity::loadJobsiteOffsiteworkActivitiesByProjectId($database, $project_id, $loadJobsiteOffsiteworkActivitiesByProjectIdOptions);

	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteOffsiteworkActivityIds = $arrTmp['jobsite_offsitework_activity_ids'];
	$arrJobsiteOffsiteworkActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_offsitework_activities_by_cost_code_id'];
	$arrJobsiteOffsiteworkActivitiesByProjectIdByJobsiteOffsiteworkActivityLabel = $arrTmp['jobsite_offsitework_activities_by_project_id_by_jobsite_offsitework_activity_label'];
	$arrJobsiteOffsiteworkActivitiesByProjectId = $arrTmp['jobsite_offsitework_activities_by_project_id'];
	$jobsiteOffsiteworkActivityLabelMaxLength = $arrTmp['jobsite_offsitework_activity_label_maxlength'];

	// jobsite_sitework_activities (project_id case)
	// or
	// jobsite_sitework_activity_templates (jobsite_activity_list_template_id case)
	$loadJobsiteSiteworkActivitiesByProjectIdOptions = new Input();
	$loadJobsiteSiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
	$loadJobsiteSiteworkActivitiesByProjectIdOptions->extendedReturn = true;
	$arrTmp = JobsiteSiteworkActivity::loadJobsiteSiteworkActivitiesByProjectId($database, $project_id, $loadJobsiteSiteworkActivitiesByProjectIdOptions);
	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteSiteworkActivityIds = $arrTmp['jobsite_sitework_activity_ids'];
	$arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_sitework_activities_by_cost_code_id'];
	$arrJobsiteSiteworkActivitiesByProjectIdByJobsiteSiteworkActivityLabel = $arrTmp['jobsite_sitework_activities_by_project_id_by_jobsite_sitework_activity_label'];
	$arrJobsiteSiteworkActivitiesByProjectId = $arrTmp['jobsite_sitework_activities_by_project_id'];
	$jobsiteSiteworkActivityLabelMaxLength = $arrTmp['jobsite_sitework_activity_label_maxlength'];

	$htmlForm = <<<END_HTML_CONTENT
<div style="margin: 15px; margin-top: 30px;"><input type="button" value="Create Jobsite Activity Label" onclick="showCreateJobsiteActivityLabel();"></div>
<div id="divCreateJobsiteActivityLabel" class="widgetContainer hidden" style="width: 500px;">
	<form id="formCreateJobsiteActivityLabel">
	<h3 class="title">
		Create New Jobsite Activity Label
		<div style="float: right;">
			<span class="entypo entypo-click entypo-cancel" onclick="hideCreateJobsiteActivityLabel();" style="margin-right: 0;"></span>
		</div>
	</h3>
	<table class="content" cellpadding="5" width="95%">

		<tr>
			<td class="textAlignRight verticalAlignMiddle">Label:</td>
			<td class="textAlignLeft"><input type="text" id="create-jobsite_activity_label-record--jobsite_activity_labels--jobsite_activity_label--dummy" style="width:370px;" class="required"></td>
		</tr>

		<tr>
			<td class="textAlignRight verticalAlignMiddle">Description:</td>
			<td class="textAlignLeft"><input type="text" id="create-jobsite_activity_label-record--jobsite_activity_labels--jobsite_activity_description--dummy" style="width:370px;" placeholder="(Optional)"></td>
		</tr>

		<tr>
			<td></td>
			<td class="textAlignRight">
				<input type="button" value="Create Jobsite Activity Label" onclick="Daily_Log__Admin__Manage_Jobsite_Activity_Labels__createJobsiteActivityLabel('create-jobsite_activity_label-record', 'dummy');">
				<input id="create-jobsite_activity_label-record--jobsite_activity_labels--user_company_id--dummy" type="hidden" value="$user_company_id">
			</td>
		</tr>

	</table>
	</form>
</div>
END_HTML_CONTENT;

	$dummyRecordPrimaryKeyTop = 'dummy_id_top-'.uniqid();
	$dummyRecordPrimaryKeyBottom = 'dummy_id_bottom-'.uniqid();
	$htmlForm = str_replace('---find_replace_dummy_primary_key---', $dummyRecordPrimaryKeyTop, $htmlForm);

	$htmlForm .= <<<END_HTML_CONTENT
<div class="widgetContainer" style="width: 1000px;">
	<h3 class="title">Manage Jobsite Activity Labels</h3>
	<table id="record_list_container--manage-jobsite_activity_label-record" class="content" style="width:95%" cellpadding="5">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th class="textAlignLeft">Label</th>
				<th class="textAlignCenter">Building</th>
				<th class="textAlignCenter">Sitework</th>
				<th class="textAlignCenter">Offsitework</th>
				<th class="textAlignCenter">Disabled</th>
				<th class="textAlignCenter">Delete</th>
			</tr>
		</thead>
		<tbody class="altColors">
END_HTML_CONTENT;


	$arrJobsiteBuildingActivityLabelsInUseByJobsiteDailyBuildingActivityLogsByProjectId = loadJobsiteBuildingActivityLabelsInUseByJobsiteDailyBuildingActivityLogsByProjectId($database, $project_id);
	$arrJobsiteOffsiteworkActivityLabelsInUseByJobsiteDailyOffsiteworkActivityLogsByProjectId = loadJobsiteOffsiteworkActivityLabelsInUseByJobsiteDailyOffsiteworkActivityLogsByProjectId($database, $project_id);
	$arrJobsiteSiteworkActivityLabelsInUseByJobsiteDailySiteworkActivityLogsByProjectId = loadJobsiteSiteworkActivityLabelsInUseByJobsiteDailySiteworkActivityLogsByProjectId($database, $project_id);

	$jobsiteActivityLabelTableTbodyHtml = '';
	// Debug.
	foreach ($arrJobsiteActivityLabelsByUserCompanyId as $jobsite_activity_label_id => $jobsiteActivityLabel) {
		/* @var $jobsiteActivityLabel JobsiteActivityLabel */

		// Debug.

		$primaryKeyAsString = $jobsiteActivityLabel->getPrimaryKeyAsString();

		$jobsiteActivityLabel->htmlEntityEscapeProperties();

		$jobsite_activity_label = $jobsiteActivityLabel->jobsite_activity_label;
		$escaped_jobsite_activity_label = $jobsiteActivityLabel->escaped_jobsite_activity_label;
		$jobsite_activity_description = $jobsiteActivityLabel->jobsite_activity_description;
		$escaped_jobsite_activity_description = $jobsiteActivityLabel->escaped_jobsite_activity_description;
		$disabled_flag = $jobsiteActivityLabel->disabled_flag;
		$sort_order = $jobsiteActivityLabel->sort_order;

		$checked = '';
		if ($disabled_flag == 'Y') {
			$checked = 'checked';
		}
		$data = $jobsiteActivityLabel->getData();

		// Checking a checkbox: INSERT INTO jobsite_building_activities, jobsite_offsitework_activities, jobsite_sitework_activities
		$buildingChecked = '';
		$siteworkChecked = '';
		$offsiteworkChecked = '';

		if (isset($arrJobsiteBuildingActivitiesByProjectIdByJobsiteBuildingActivityLabel[$jobsite_activity_label])) {

			$buildingChecked = 'checked';
			list($jobsite_building_activity_id, $jobsiteBuildingActivity) = each($arrJobsiteBuildingActivitiesByProjectIdByJobsiteBuildingActivityLabel[$jobsite_activity_label]);

			if (isset($arrJobsiteBuildingActivityLabelsInUseByJobsiteDailyBuildingActivityLogsByProjectId[$jobsite_activity_label])) {

				$buildingHtmlElement = <<<END_BUILDING_HTML_ELEMENT

					<span class="entypo entypo-check inUse" rel="tooltip" title="This activity is in use by Daily Log records."></span>
					<input type="hidden" id="create-jobsite_building_activity-record--jobsite_building_activities--jobsite_building_activity_label--$jobsite_activity_label_id" value="$escaped_jobsite_activity_label">
END_BUILDING_HTML_ELEMENT;

			} else {

				$buildingHtmlElement = <<<END_BUILDING_HTML_ELEMENT

					<span class="entypo entypo-click entypo-check" onclick="deleteJobsiteBuildingActivityFromMasterJobsiteActivityList(this, '', 'delete-jobsite_building_activity-record', $jobsite_building_activity_id);" rel="tooltip" title="Remove from Building Activites"></span>
					<input type="hidden" id="create-jobsite_building_activity-record--jobsite_building_activities--jobsite_building_activity_label--$jobsite_activity_label_id" value="$escaped_jobsite_activity_label">
END_BUILDING_HTML_ELEMENT;

			}

		} else {
			// dummy id
			$jobsite_building_activity_id = '';
			// Add button to insert the jobsite_activity_label into jobsite_building_activities

			$buildingHtmlElement = <<<END_BUILDING_HTML_ELEMENT
				<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteBuildingActivityFromMasterJobsiteActivityList(this, 'create-jobsite_building_activity-record', $jobsite_activity_label_id);" rel="tooltip" title="Add to Building Activites"></span>
				<input type="hidden" id="create-jobsite_building_activity-record--jobsite_building_activities--jobsite_building_activity_label--$jobsite_activity_label_id" value="$escaped_jobsite_activity_label">
END_BUILDING_HTML_ELEMENT;
		}

		if (isset($arrJobsiteSiteworkActivitiesByProjectIdByJobsiteSiteworkActivityLabel[$jobsite_activity_label])) {
			$siteworkChecked = 'checked';
			list($jobsite_sitework_activity_id, $jobsiteSiteworkActivity) = each($arrJobsiteSiteworkActivitiesByProjectIdByJobsiteSiteworkActivityLabel[$jobsite_activity_label]);

			if (isset($arrJobsiteSiteworkActivityLabelsInUseByJobsiteDailySiteworkActivityLogsByProjectId[$jobsite_activity_label])) {

				$siteworkHtmlElement = <<<END_SITEWORK_HTML_ELEMENT

					<span class="entypo entypo-check inUse" rel="tooltip" title="This activity is in use by Daily Log records."></span>
					<input type="hidden" id="create-jobsite_sitework_activity-record--jobsite_sitework_activities--jobsite_sitework_activity_label--$jobsite_activity_label_id" value="$escaped_jobsite_activity_label">
END_SITEWORK_HTML_ELEMENT;

			} else {

				$siteworkHtmlElement = <<<END_SITEWORK_HTML_ELEMENT

					<span class="entypo entypo-click entypo-check" onclick="deleteJobsiteSiteworkActivityFromMasterJobsiteActivityList(this, '', 'delete-jobsite_sitework_activity-record', $jobsite_sitework_activity_id);" rel="tooltip" title="Remove from Sitework Activites"></span>
					<input type="hidden" id="create-jobsite_sitework_activity-record--jobsite_sitework_activities--jobsite_sitework_activity_label--$jobsite_activity_label_id" value="$escaped_jobsite_activity_label">
END_SITEWORK_HTML_ELEMENT;

			}

		} else {

			$jobsite_sitework_activity_id = '';
			// <input id="manage-jobsite_sitework_activity-record--jobsite_sitework_activities--jobsite_sitework_activity_id--{$jobsite_sitework_activity_id}-2" type="checkbox" name="jobsite_sitework_activity_id--$jobsite_sitework_activity_id" $siteworkChecked>
			$siteworkHtmlElement = '';

			$siteworkHtmlElement = <<<END_SITEWORK_HTML_ELEMENT

				<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteSiteworkActivityFromMasterJobsiteActivityList(this, 'create-jobsite_sitework_activity-record', $jobsite_activity_label_id);" rel="tooltip" title="Add to Sitework Activites"></span>
				<input type="hidden" id="create-jobsite_sitework_activity-record--jobsite_sitework_activities--jobsite_sitework_activity_label--$jobsite_activity_label_id" value="$escaped_jobsite_activity_label">
END_SITEWORK_HTML_ELEMENT;

		}

		if (isset($arrJobsiteOffsiteworkActivitiesByProjectIdByJobsiteOffsiteworkActivityLabel[$jobsite_activity_label])) {
			$offsiteworkChecked = 'checked';
			list($jobsite_offsitework_activity_id, $jobsiteOffsiteworkActivity) = each($arrJobsiteOffsiteworkActivitiesByProjectIdByJobsiteOffsiteworkActivityLabel[$jobsite_activity_label]);

			if (isset($arrJobsiteOffsiteworkActivityLabelsInUseByJobsiteDailyOffsiteworkActivityLogsByProjectId[$jobsite_activity_label])) {

				$offsiteworkHtmlElement = <<<END_OFFSITEWORK_HTML_ELEMENT

					<span class="entypo entypo-check inUse" rel="tooltip" title="This activity is in use by Daily Log records."></span>
					<input type="hidden" id="create-jobsite_offsitework_activity-record--jobsite_offsitework_activities--jobsite_offsitework_activity_label--$jobsite_activity_label_id" value="$escaped_jobsite_activity_label">
END_OFFSITEWORK_HTML_ELEMENT;

			} else {

				$offsiteworkHtmlElement = <<<END_OFFSITEWORK_HTML_ELEMENT

					<span class="entypo entypo-click entypo-check" onclick="deleteJobsiteOffsiteworkActivityFromMasterJobsiteActivityList(this, '', 'delete-jobsite_offsitework_activity-record', $jobsite_offsitework_activity_id);" rel="tooltip" title="Remove from Offsitework Activites"></span>
					<input type="hidden" id="create-jobsite_offsitework_activity-record--jobsite_offsitework_activities--jobsite_offsitework_activity_label--$jobsite_activity_label_id" value="$escaped_jobsite_activity_label">
END_OFFSITEWORK_HTML_ELEMENT;

			}

		} else {

			$jobsite_offsitework_activity_id = '';
			// <input id="manage-jobsite_offsitework_activity-record--jobsite_offsitework_activities--jobsite_offsitework_activity_id--$jobsite_offsitework_activity_id-3" type="checkbox" name="jobsite_offsitework_activity_id--$jobsite_offsitework_activity_id" $offsiteworkChecked>
			$offsiteworkHtmlElement = '';

			$offsiteworkHtmlElement = <<<END_OFFSITEWORK_HTML_ELEMENT

				<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteOffsiteworkActivityFromMasterJobsiteActivityList(this, 'create-jobsite_offsitework_activity-record', $jobsite_activity_label_id);" rel="tooltip" title="Add to Offsitework Activites"></span>
				<input type="hidden" id="create-jobsite_offsitework_activity-record--jobsite_offsitework_activities--jobsite_offsitework_activity_label--$jobsite_activity_label_id" value="$escaped_jobsite_activity_label">
END_OFFSITEWORK_HTML_ELEMENT;

		}


		$htmlForm .= <<<END_HTML_ROW

	<tr id="record_container--manage-jobsite_activity_label-record--jobsite_activity_labels--sort_order--$jobsite_activity_label_id">
		<td class="tdSortBars textAlignCenter"><input type="hidden" value="$sort_order"><img src="/images/sortbars.png"></td>
		<td class="textAlignLeft"><input type="text" style="width:300px" value="$escaped_jobsite_activity_label" onchange="updateJobsiteActivityLabel(this);" id="manage-jobsite_activity_label-record--jobsite_activity_labels--jobsite_activity_label--$jobsite_activity_label_id"></td>
		<td class="textAlignCenter hoverColorChange">$buildingHtmlElement</td>
		<td class="textAlignCenter hoverColorChange">$siteworkHtmlElement</td>
		<td class="textAlignCenter hoverColorChange">$offsiteworkHtmlElement</td>
		<td class="textAlignCenter"><input type="checkbox" onchange="updateJobsiteActivityLabel(this);" id="manage-jobsite_activity_label-record--jobsite_activity_labels--disabled_flag--$jobsite_activity_label_id" $checked></td>
		<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="deleteJobsiteActivityLabel('record_container--manage-jobsite_activity_label-record--jobsite_activity_labels--sort_order--$jobsite_activity_label_id', 'manage-jobsite_activity_label-record', '$jobsite_activity_label_id', { responseDataType: 'json' });"></span></td>
	</tr>
END_HTML_ROW;

	}


	$htmlForm .= <<<END_HTML_FORM

		</table>
	</div>
</div>
END_HTML_FORM;

	return $htmlForm;
}

function buildAdminManageJobsiteBuildingActivities($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName)
{
	$importJobsiteActivitiesDialogTitle = 'Import Jobsite Building Activities';
	$jobsiteActivitiesTableElementId = 'record_list_container--manage-jobsite_building_activity-record';

	$loadJobsiteBuildingActivitiesByProjectIdOptions = new Input();
	$loadJobsiteBuildingActivitiesByProjectIdOptions->extendedReturn	= true;
	$loadJobsiteBuildingActivitiesByProjectIdOptions->filterByCostCode	= false;
	$loadJobsiteBuildingActivitiesByProjectIdOptions->forceLoadFlag		= true;

	$arrTmp = JobsiteBuildingActivity::loadJobsiteBuildingActivitiesByProjectId($database, $project_id, $loadJobsiteBuildingActivitiesByProjectIdOptions);
	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteBuildingActivityIds = $arrTmp['jobsite_building_activity_ids'];
	$arrJobsiteBuildingActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_building_activities_by_cost_code_id'];
	$arrJobsiteBuildingActivitiesByProjectId = $arrTmp['jobsite_building_activities_by_project_id'];
	$jobsiteBuildingActivityLabelMaxLength = $arrTmp['jobsite_building_activity_label_maxlength'];

	$jobsiteBuildingActivityTableTbodyHtml = '';
	foreach ($arrJobsiteBuildingActivitiesByProjectId as $jobsite_building_activity_id => $jobsiteBuildingActivity) {
		/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */

		$jobsiteBuildingActivity->htmlEntityEscapeProperties();

		$jobsite_building_activity_label = $jobsiteBuildingActivity->jobsite_building_activity_label;
		$escaped_jobsite_building_activity_label = $jobsiteBuildingActivity->escaped_jobsite_building_activity_label;
		$sort_order = $jobsiteBuildingActivity->sort_order;

		$buildingChecked = '';
		$siteworkChecked = '';
		$otherChecked = '';
		/*
		if ($jobsite_activity_type_id == 1) {
			$buildingChecked = 'checked';
		} elseif ($jobsite_activity_type_id == 2) {
			$siteworkChecked = 'checked';
		} elseif ($jobsite_activity_type_id == 3) {
			$otherChecked = 'checked';
		}
			<td class="textAlignCenter hoverColorChange"><input id="manage-jobsite_building_activity-record--jobsite_building_activities--jobsite_activity_type_id--$jobsite_activity_id-1" type="checkbox" name="jobsite_activity_type_id--$jobsite_activity_id" $buildingChecked></td>
			<td class="textAlignCenter hoverColorChange"><input id="manage-jobsite_building_activity-record--jobsite_building_activities--jobsite_activity_type_id--$jobsite_activity_id-2" type="checkbox" name="jobsite_activity_type_id--$jobsite_activity_id" $siteworkChecked></td>
			<td class="textAlignCenter hoverColorChange"><input id="manage-jobsite_building_activity-record--jobsite_building_activities--jobsite_activity_type_id--$jobsite_activity_id-3" type="checkbox" name="jobsite_activity_type_id--$jobsite_activity_id" $otherChecked></td>

		*/
		$elementId = 'manage-jobsite_building_activity-record--jobsite_building_activities--sort_order--' . $jobsite_building_activity_id;
		$jobsiteBuildingActivityTableTbodyHtml .= <<<END_JOBSITE_BUILDING_ACTIVITY_TABLE_TBODY_HTML

		<tr id="$elementId">
			<td class="tdSortBars textAlignCenter"><input type="hidden" value="$sort_order"><img src="/images/sortbars.png"></td>
			<td class="textAlignLeft">$escaped_jobsite_building_activity_label</td>
			<td class="textAlignLeft"><a href="javascript:loadJobsiteActivitiesToCostCodesDialog('jobsite_building_activities', '$jobsite_building_activity_id', '$escaped_jobsite_building_activity_label');">View Cost Code Links</a></td>
			<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="deleteJobsiteBuildingActivityAndDependentDataAndReloadDataTableViaPromiseChain('$elementId', 'manage-jobsite_building_activity-record', '$jobsite_building_activity_id');"></span></td>
		</tr>
END_JOBSITE_BUILDING_ACTIVITY_TABLE_TBODY_HTML;

	}

	$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = CostCode::loadCostCodesByUserCompanyIdOrganizedByCostCodeTypeId($database, $user_company_id);
	$ddlCostCodeOptions = '';
	foreach ($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId as $cost_code_type_id => $arrCostCodes) {
		foreach ($arrCostCodes as $cost_code_id => $costCode) {
			/* @var $costCode CostCode */

			$formattedCostCode = $costCode->getFormattedCostCode($database);
			$ddlCostCodeOptions .= '<option value="'.$cost_code_id.'">'.$formattedCostCode.'</option>';
		}
	}

/*
				<th>Building</th>
				<th>Sitework</th>
				<th>Offsitework</th>
*/


	$htmlContent = <<<END_HTML_CONTENT

<div style="margin: 15px; margin-top: 30px;">
	<input type="button" value="Import Jobsite Building Activities" onclick="loadImportJobsiteActivitiesDialog('jobsite_building_activities');">
	<input type="button" value="Create Jobsite Building Activity" onclick="showCreateJobsiteBuildingActivity();">
</div>
<div id="divCreateJobsiteBuildingActivity" class="widgetContainer hidden" style="width:500px;">
	<h3 class="title">
		Create New Jobsite Building Activity
		<div style="float: right;">
			<span class="entypo entypo-click entypo-cancel" onclick="hideCreateJobsiteBuildingActivity();" style="margin-right: 0;"></span>
		</div>
	</h3>
	<form id="formCreateJobsiteBuildingActivity">
	<table id="record_creation_form_container--create-jobsite_building_activity-record--dummy" class="content" cellpadding="15px" width="95%">
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Label:</td>
			<td class="textAlignLeft"><input type="text" id="create-jobsite_building_activity-record--jobsite_building_activities--jobsite_building_activity_label--dummy" class="required" style="width:404px;"></td>
		</tr>
		<tr>
			<td></td>
			<td class="textAlignRight">
				<input type="button" value="Create Jobsite Building Activity" onclick="createJobsiteBuildingActivityAndReloadDataTableViaPromiseChain('create-jobsite_building_activity-record', 'dummy');">
				<input id="create-jobsite_building_activity-record--jobsite_building_activities--project_id--dummy" type="hidden" value="$project_id">
			</td>
		</tr>
	</table>
	</form>
</div>
<input type="hidden" id="importJobsiteActivitiesDialogTitle" value="$importJobsiteActivitiesDialogTitle">
<input type="hidden" id="jobsiteActivitiesTableElementId" value="$jobsiteActivitiesTableElementId">
<div id="divImportJobsiteActivities" class="hidden"></div>
<div id="divLinkJobsiteActivitiesToCostCodes" class="hidden"></div>
<div class="widgetContainer" style="width:850px">
	<h3 class="title">Manage Jobsite Building Activities</h3>
	<table id="$jobsiteActivitiesTableElementId" class="content" width="95%" cellpadding="5">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th class="textAlignLeft">Activity</th>
				<th class="textAlignLeft">Link To Cost Code <span class="entypo entypo-info-circled" style="font-weight: normal;" rel="tooltip" title="Link each activity to one or more cost codes. That way, the activities can be organized by trade in the Daily Log Building tab."></span></th>
				<th class="textAlignCenter">Delete</th>
			</tr>
		</thead>
		<tbody class="altColors">
			$jobsiteBuildingActivityTableTbodyHtml
		</tbody>
	</table>
</div>
END_HTML_CONTENT;

	return $htmlContent;
}

function buildAdminManageJobsiteOffsiteworkActivities($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName)
{
	$importJobsiteActivitiesDialogTitle = 'Import Jobsite Offsitework Activities';
	$jobsiteActivitiesTableElementId = 'record_list_container--manage-jobsite_offsitework_activity-record';

	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions = new Input();
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
	$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->extendedReturn = true;
	$arrTmp = JobsiteOffsiteworkActivity::loadJobsiteOffsiteworkActivitiesByProjectId($database, $project_id, $loadJobsiteOffsiteworkActivitiesByProjectIdOptions);

	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteOffsiteworkActivityIds = $arrTmp['jobsite_offsitework_activity_ids'];
	$arrJobsiteOffsiteworkActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_offsitework_activities_by_cost_code_id'];
	$arrJobsiteOffsiteworkActivitiesByProjectId = $arrTmp['jobsite_offsitework_activities_by_project_id'];
	$jobsiteOffsiteworkActivityLabelMaxLength = $arrTmp['jobsite_offsitework_activity_label_maxlength'];

	$jobsiteOffsiteworkActivityTableTbodyHtml = '';
	foreach ($arrJobsiteOffsiteworkActivitiesByProjectId as $jobsite_offsitework_activity_id => $jobsiteOffsiteworkActivity) {
		/* @var $jobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */

		$jobsiteOffsiteworkActivity->htmlEntityEscapeProperties();

		$jobsite_offsitework_activity_label = $jobsiteOffsiteworkActivity->jobsite_offsitework_activity_label;
		$escaped_jobsite_offsitework_activity_label = $jobsiteOffsiteworkActivity->escaped_jobsite_offsitework_activity_label;
		$sort_order = $jobsiteOffsiteworkActivity->sort_order;

		$offsiteworkChecked = '';
		$siteworkChecked = '';
		$otherChecked = '';
		
		$elementId = "record_container--manage-jobsite_offsitework_activity-record--jobsite_offsitework_activities--sort_order--$jobsite_offsitework_activity_id";
		$jobsiteOffsiteworkActivityTableTbodyHtml .= <<<END_JOBSITE_OFFSITEWORK_ACTIVITY_TABLE_TBODY_HTML

		<tr id="$elementId">
			<td class="tdSortBars textAlignCenter"><input type="hidden" value="$sort_order"><img src="/images/sortbars.png"></td>
			<td class="textAlignLeft">$escaped_jobsite_offsitework_activity_label</td>
			<td class="textAlignLeft"><a href="javascript:loadJobsiteActivitiesToCostCodesDialog('jobsite_offsitework_activities', '$jobsite_offsitework_activity_id', '$escaped_jobsite_offsitework_activity_label');">View Cost Code Links</a></td>
			<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="deleteJobsiteOffsiteworkActivityAndDependentDataAndReloadDataTableViaPromiseChain('$elementId', 'manage-jobsite_offsitework_activity-record', '$jobsite_offsitework_activity_id');"></span></td>
		</tr>
END_JOBSITE_OFFSITEWORK_ACTIVITY_TABLE_TBODY_HTML;

	}

	$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = CostCode::loadCostCodesByUserCompanyIdOrganizedByCostCodeTypeId($database, $user_company_id);
	$ddlCostCodeOptions = '';
	foreach ($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId as $cost_code_type_id => $arrCostCodes) {
		foreach ($arrCostCodes as $cost_code_id => $costCode) {
			/* @var $costCode CostCode */

			$formattedCostCode = $costCode->getFormattedCostCode($database);
			$ddlCostCodeOptions .= '<option value="'.$cost_code_id.'">'.$formattedCostCode.'</option>';
		}
	}

/*
				<th>Offsitework</th>
				<th>Sitework</th>
				<th>Offsitework</th>
*/


	$htmlContent = <<<END_HTML_CONTENT

<div style="margin: 15px; margin-top: 30px;">
	<input type="button" value="Import Jobsite Offsitework Activities" onclick="loadImportJobsiteActivitiesDialog('jobsite_offsitework_activities');">
	<input type="button" value="Create Jobsite Offsitework Activity" onclick="showCreateJobsiteOffsiteworkActivity();">
</div>
<div id="divCreateJobsiteOffsiteworkActivity" class="widgetContainer hidden" style="width:500px;">
	<h3 class="title">
		Create New Jobsite Offsitework Activity
		<div style="float: right;">
			<span class="entypo entypo-click entypo-cancel" onclick="hideCreateJobsiteOffsiteworkActivity();" style="margin-right: 0;"></span>
		</div>
	</h3>
	<form id="formCreateJobsiteOffsiteworkActivity">
	<table id="record_creation_form_container--create-jobsite_offsitework_activity-record--dummy" class="content" cellpadding="15px" width="95%">
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Label:</td>
			<td class="textAlignLeft"><input type="text" id="create-jobsite_offsitework_activity-record--jobsite_offsitework_activities--jobsite_offsitework_activity_label--dummy" class="required" style="width:404px;"></td>
		</tr>
		<tr>
			<td></td>
			<td class="textAlignRight">
				<input type="button" value="Create Jobsite Offsitework Activity" onclick="createJobsiteOffsiteworkActivityAndReloadDataTableViaPromiseChain('create-jobsite_offsitework_activity-record', 'dummy');">
				<input id="create-jobsite_offsitework_activity-record--jobsite_offsitework_activities--project_id--dummy" type="hidden" value="$project_id">
			</td>
		</tr>
	</table>
	</form>
</div>
<input type="hidden" id="importJobsiteActivitiesDialogTitle" value="$importJobsiteActivitiesDialogTitle">
<input type="hidden" id="jobsiteActivitiesTableElementId" value="$jobsiteActivitiesTableElementId">
<div id="divImportJobsiteActivities" class="hidden"></div>
<div id="divLinkJobsiteActivitiesToCostCodes" class="hidden"></div>
<div class="widgetContainer" style="width:850px">
	<h3 class="title">Manage Jobsite Offsitework Activities</h3>
	<table id="$jobsiteActivitiesTableElementId" class="content" cellpadding="5" width="95%">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th class="textAlignLeft">Activity</th>
				<th class="textAlignLeft">Link To Cost Code <span class="entypo entypo-info-circled" style="font-weight: normal;" rel="tooltip" title="Link each activity to one or more cost codes. That way, the activities can be organized by trade in the Daily Log Offsitework tab."></span></th>
				<th class="textAlignCenter">Delete</th>
			</tr>
		</thead>
		<tbody class="altColors ui-sortable">
			$jobsiteOffsiteworkActivityTableTbodyHtml
		</tbody>
	</table>
	</div>
</div>

END_HTML_CONTENT;

	return $htmlContent;
}

function buildAdminManageJobsiteSiteworkActivities($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName)
{
	$importJobsiteActivitiesDialogTitle = 'Import Jobsite Sitework Activities';
	$jobsiteActivitiesTableElementId = 'record_list_container--manage-jobsite_sitework_activity-record';

	$loadJobsiteSiteworkActivitiesByProjectIdOptions = new Input();
	$loadJobsiteSiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
	$loadJobsiteSiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
	$loadJobsiteSiteworkActivitiesByProjectIdOptions->extendedReturn = true;
	$arrTmp = JobsiteSiteworkActivity::loadJobsiteSiteworkActivitiesByProjectId($database, $project_id, $loadJobsiteSiteworkActivitiesByProjectIdOptions);
	$arrCostCodeIds = $arrTmp['cost_code_ids'];
	$arrJobsiteSiteworkActivityIds = $arrTmp['jobsite_sitework_activity_ids'];
	$arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId = $arrTmp['jobsite_sitework_activities_by_cost_code_id'];
	$arrJobsiteSiteworkActivitiesByProjectId = $arrTmp['jobsite_sitework_activities_by_project_id'];
	$jobsiteSiteworkActivityLabelMaxLength = $arrTmp['jobsite_sitework_activity_label_maxlength'];

	$jobsiteSiteworkActivityTableTbodyHtml = '';
	foreach ($arrJobsiteSiteworkActivitiesByProjectId as $jobsite_sitework_activity_id => $jobsiteSiteworkActivity) {
		/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */

		$jobsiteSiteworkActivity->htmlEntityEscapeProperties();

		$jobsite_sitework_activity_label = $jobsiteSiteworkActivity->jobsite_sitework_activity_label;
		$escaped_jobsite_sitework_activity_label = $jobsiteSiteworkActivity->escaped_jobsite_sitework_activity_label;
		$sort_order = $jobsiteSiteworkActivity->sort_order;

		$siteworkChecked = '';
		$siteworkChecked = '';
		$otherChecked = '';
		

		$elementId = "manage-jobsite_sitework_activity-record--jobsite_sitework_activities--sort_order--$jobsite_sitework_activity_id";
		$jobsiteSiteworkActivityTableTbodyHtml .= <<<END_JOBSITE_SITEWORK_ACTIVITY_TABLE_TBODY_HTML

		<tr id="$elementId">
			<td class="tdSortBars textAlignCenter"><input type="hidden" value="$sort_order"><img src="/images/sortbars.png"></td>
			<td class="textAlignLeft">$escaped_jobsite_sitework_activity_label</td>
			<td class="textAlignLeft"><a href="javascript:loadJobsiteActivitiesToCostCodesDialog('jobsite_sitework_activities', '$jobsite_sitework_activity_id', '$jobsite_sitework_activity_label');">View Cost Code Links</a></td>
			<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="deleteJobsiteSiteworkActivityAndDependentDataAndReloadDataTableViaPromiseChain('$elementId', 'manage-jobsite_sitework_activity-record', '$jobsite_sitework_activity_id');"></span></td>
		</tr>
END_JOBSITE_SITEWORK_ACTIVITY_TABLE_TBODY_HTML;

	}

	$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = CostCode::loadCostCodesByUserCompanyIdOrganizedByCostCodeTypeId($database, $user_company_id);
	$ddlCostCodeOptions = '';
	foreach ($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId as $cost_code_type_id => $arrCostCodes) {
		foreach ($arrCostCodes as $cost_code_id => $costCode) {
			/* @var $costCode CostCode */

			$formattedCostCode = $costCode->getFormattedCostCode($database);
			$ddlCostCodeOptions .= '<option value="'.$cost_code_id.'">'.$formattedCostCode.'</option>';
		}
	}

/*
				<th>Sitework</th>
				<th>Sitework</th>
				<th>Sitework</th>
*/


	$htmlContent = <<<END_HTML_CONTENT
<div style="margin: 15px; margin-top: 30px;">
	<input type="button" value="Import Jobsite Sitework Activities" onclick="loadImportJobsiteActivitiesDialog('jobsite_sitework_activities');">
	<input type="button" value="Create Jobsite Sitework Activity" onclick="showCreateJobsiteSiteworkActivity();">
</div>
<div id="divCreateJobsiteSiteworkActivity" class="widgetContainer hidden" style="width:500px;">
	<h3 class="title">
		Create New Jobsite Sitework Activity
		<div style="float: right;">
			<span class="entypo entypo-click entypo-cancel" onclick="hideCreateJobsiteSiteworkActivity();" style="margin-right: 0;"></span>
		</div>
	</h3>
	<form id="formCreateJobsiteSiteworkActivity">
	<table id="record_creation_form_container--create-jobsite_sitework_activity-record--dummy" class="content" cellpadding="15px" width="95%">
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Label:</td>
			<td class="textAlignLeft"><input type="text" id="create-jobsite_sitework_activity-record--jobsite_sitework_activities--jobsite_sitework_activity_label--dummy" class="required" style="width:404px;"></td>
		</tr>
		<tr>
			<td></td>
			<td class="textAlignRight">
				<input type="button" value="Create Jobsite Sitework Activity" onclick="createJobsiteSiteworkActivityAndReloadDataTableViaPromiseChain('create-jobsite_sitework_activity-record', 'dummy');">
				<input id="create-jobsite_sitework_activity-record--jobsite_sitework_activities--project_id--dummy" type="hidden" value="$project_id">
			</td>
		</tr>
	</table>
	</form>
</div>
<input type="hidden" id="importJobsiteActivitiesDialogTitle" value="$importJobsiteActivitiesDialogTitle">
<input type="hidden" id="jobsiteActivitiesTableElementId" value="$jobsiteActivitiesTableElementId">
<div id="divImportJobsiteActivities" class="hidden"></div>
<div id="divLinkJobsiteActivitiesToCostCodes" class="hidden"></div>
<div class="widgetContainer" style="width:850px">
	<h3 class="title">Manage Jobsite Sitework Activities</h3>
	<table id="$jobsiteActivitiesTableElementId" class="content" width="95%" cellpadding="5">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th class="textAlignLeft">Activity</th>
				<th class="textAlignLeft">Link To Cost Code <span class="entypo entypo-info-circled" style="font-weight: normal;" rel="tooltip" title="Link each activity to one or more cost codes. That way, the activities can be organized by trade in the Daily Log Sitework tab."></span></th>
				<th class="textAlignCenter">Delete</th>
			</tr>
		</thead>
		<tbody class="altColors">
			$jobsiteSiteworkActivityTableTbodyHtml
		</tbody>
	</table>
	</div>
</div>

END_HTML_CONTENT;

	return $htmlContent;
}

/**
 * Note: This function is not currently in use.
 */
function buildAdminManageJobsiteActivityTemplates($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName)
{
	$dummyRecordPrimaryKey = 'dummy_id-'.uniqid();

	// Project Type Drop Down List (DDL)
	// @todo Add user_company_id and sort_order to the project_types table.
	$loadProjectTypesByUserCompanyIdOptions = new Input();
	$loadProjectTypesByUserCompanyIdOptions->forceLoadFlag = true;
	$arrProjectTypesByUserCompanyId = ProjectType::loadProjectTypesByUserCompanyId($database, $user_company_id, $loadProjectTypesByUserCompanyIdOptions);
	$ddlProjectTypesId = 'ddl--create-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--'.$dummyRecordPrimaryKey;
	$ddlProjectTypes = PageComponents::dropDownListFromObjects($ddlProjectTypesId, $arrProjectTypesByUserCompanyId, 'project_type_id', null, 'project_type', null, '3', '', '', '');
	//<input id="create-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--$dummyRecordPrimaryKey" type="hidden" value="3">

	$htmlContent = <<<END_HTML_CONTENT

<div class="divSubtabs" style="padding: 0 0 5px 30px;">
	<ul>
		<li><a href="javascript:subtabClicked('manageJobsiteActivities');">$currentlySelectedProjectName Jobsite Activities</a></li>
		<li><a class="activeSubtab" href="javascript:subtabClicked('manageJobsiteActivityTemplates');">Jobsite Activity Templates</a></li>
	</ul>
</div>

<input id="formattedAttributeGroupName--create-jobsite_activity_list_template-record" type="hidden" value="Jobsite Activity List Template">
<input id="formattedAttributeSubgroupName--create-jobsite_activity_list_template-record" type="hidden" value="Jobsite Activity List Template">
<input id="formattedAttributeGroupName--manage-jobsite_activity_list_template-record" type="hidden" value="Jobsite Activity List Template">
<input id="formattedAttributeSubgroupName--manage-jobsite_activity_list_template-record" type="hidden" value="Jobsite Activity List Template">

<form id="formCreateJobsiteActivityListTemplate" class="content right">
<input id="create-jobsite_activity_list_template-record--jobsite_activity_list_templates--user_company_id--$dummyRecordPrimaryKey" type="hidden" value="$user_company_id">

<div class="widgetContainer" style="width: 570px;">
	<h3 class="title">Create New Jobsite Activity List Template</h3>
	<table class="content" cellpadding="15px" width="95%">

		<tr>
			<td class="textAlignRight verticalAlignMiddle">Jobsite Activity List Template:</td>
			<td><input id="create-jobsite_activity_list_template-record--jobsite_activity_list_templates--jobsite_activity_list_template--$dummyRecordPrimaryKey" type="text" value="" style="width: 320px;;"></td>
		</tr>

		<tr>
			<td class="textAlignRight verticalAlignMiddle">Project Type:</td>
			<td class="textAlignLeft">$ddlProjectTypes</td>
		</tr>

		<tr>
			<td></td>
			<td class="textAlignRight">
				<input type="button" value="Create Jobsite Activity List Template" onclick="Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__createJobsiteActivityListTemplate('create-jobsite_activity_list_template-record', '$dummyRecordPrimaryKey');">
			</td>
		</tr>

	</table>
</div>

</form>
END_HTML_CONTENT;

	$htmlContent .= <<<END_HTML_CONTENT
<div class="widgetContainer" style="width: 1000px;">
	<h3 class="title">Manage Jobsite Activity List Template</h3>
	<table id="tableJobsiteActivityListTemplates" class="content" style="width:95%" cellpadding="5">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th class="textAlignLeft">Jobsite Activity List Template</th>
				<th class="textAlignLeft">Project Type</th>
				<th class="textAlignCenter">Disabled</th>
				<th class="textAlignCenter">Delete</th>
			</tr>
		</thead>
		<tbody class="altColors">
END_HTML_CONTENT;

	$loadJobsiteActivityListTemplatesByUserCompanyIdOptions = new Input();
	$loadJobsiteActivityListTemplatesByUserCompanyIdOptions->forceLoadFlag = true;
	$arrJobsiteActivityListTemplates = JobsiteActivityListTemplate::loadJobsiteActivityListTemplatesByUserCompanyId($database, $user_company_id, $loadJobsiteActivityListTemplatesByUserCompanyIdOptions);
	$jobsiteActivityLabelTableTbodyHtml = '';
	foreach ($arrJobsiteActivityListTemplates as $jobsite_activity_list_template_id => $jobsiteActivityListTemplate) {
		/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */

		$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();

		$jobsiteActivityListTemplate->htmlEntityEscapeProperties();

		$escaped_jobsite_activity_list_template = $jobsiteActivityListTemplate->escaped_jobsite_activity_list_template;
		$disabled_flag = $jobsiteActivityListTemplate->disabled_flag;
		$sort_order = $jobsiteActivityListTemplate->sort_order;

		$checked = '';
		if ($disabled_flag == 'Y') {
			$checked = 'checked';
			$checkBoxValue = 'Y';
		} else {
			$checked = '';
			$checkBoxValue = 'N';
		}

		$ddlProjectTypesId = 'manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--'.$jobsite_activity_list_template_id;
		$ddlProjectTypesJs = 'onchange="updateJobsiteActivityListTemplate(this);"';
		$project_type_id = $jobsiteActivityListTemplate->project_type_id;
		$ddlProjectTypes = PageComponents::dropDownListFromObjects($ddlProjectTypesId, $arrProjectTypesByUserCompanyId, 'project_type_id', null, 'project_type', null, $project_type_id, '', $ddlProjectTypesJs, '');

		$htmlContent .= <<<END_HTML_ROW
	<tr id="record_container--manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--sort_order--$jobsite_activity_list_template_id">
		<td class="tdSortBars textAlignCenter"><input type="hidden" value="$sort_order"><img src="/images/sortbars.png"></td>
		<td class="textAlignLeft"><input type="text" style="width:300px" value="$escaped_jobsite_activity_list_template" onchange="updateJobsiteActivityListTemplate(this);" id="manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--jobsite_activity_list_template--$jobsite_activity_list_template_id"></td>
		<td class="textAlignLeft">$ddlProjectTypes</td>
		<td class="textAlignCenter"><input type="checkbox" onchange="updateJobsiteActivityListTemplate(this);" id="manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--disabled_flag--$jobsite_activity_list_template_id" $checked></td>
		<td class="textAlignCenter"><a href="javascript:Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__deleteJobsiteActivityListTemplate('record_container--manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--sort_order--$jobsite_activity_list_template_id', 'manage-jobsite_activity_list_template-record', '$jobsite_activity_list_template_id');">X</a></td>
	</tr>
END_HTML_ROW;

	}

	//$htmlCreateRecordBottom = str_replace('---find_replace_dummy_primary_key---', $dummyRecordPrimaryKeyBottom, $htmlCreateRecord);
	//$htmlContent .= $htmlCreateRecordBottom;
	$htmlContent .= <<<END_HTML_FORM

		</tbody>
	</table>
</div>
END_HTML_FORM;

	return $htmlContent;
}

function buildAdminManageJobsiteBuildingActivityTemplates($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $jobsite_activity_list_template_id)
{
	try {

		$importJobsiteActivitiesDialogTitle = 'Import Jobsite Building Activity Template Data';
		$jobsiteActivitiesTableElementId = 'record_list_container--manage-jobsite_building_activity_template-record';

		$tableJobsiteBuildingActivityTemplatesTbody = buildJobsiteBuildingActivityTemplatesTbody($database, $jobsite_activity_list_template_id);

		$htmlContent = <<<END_HTML_CONTENT

	<div style="padding:15px 0 0 15px">
		<input type="button" onclick="showCreateJobsiteBuildingActivityTemplate();" value="Create Jobsite Building Activity Template">
	</div>
	<div id="divCreateJobsiteBuildingActivityTemplate" class="widgetContainer hidden" style="width:500px;">
		<h3 class="title">
			Create New Jobsite Building Activity Template
			<div style="float: right;">
				<span class="entypo entypo-click entypo-cancel" onclick="hideCreateJobsiteBuildingActivityTemplate();" style="margin-right: 0;"></span>
			</div>
		</h3>
		<form id="formCreateJobsiteBuildingActivityTemplate">
		<table id="record_creation_form_container--create-jobsite_building_activity_template-record--dummy" class="content" cellpadding="15px" width="95%">

			<tr id="record_creation_form_error_message_container--create-jobsite_building_activity_template-record--dummy" class="displayNone">
				<td class="textAlignLeft" colspan="2">
					<span id="create-jobsite_building_activity_template-record--jobsite_building_activity_templates--errorMessage--dummy" class="pageBlurbErrorClass"></span>
				</td>
			</tr>

			<tr>
				<td class="textAlignRight verticalAlignMiddle">Label:</td>
				<td class="textAlignLeft">
					<input type="text" id="create-jobsite_building_activity_template-record--jobsite_building_activity_templates--jobsite_building_activity_label--dummy" class="required" style="width:375px;">
				</td>
			</tr>

			<tr>
				<td></td>
				<td class="textAlignRight">
					<input type="button" value="Create Jobsite Building Activity Template" onclick="createJobsiteBuildingActivityTemplateAndReloadDataTableViaPromiseChain('create-jobsite_building_activity_template-record', 'dummy');">
					<input id="create-jobsite_building_activity_template-record--jobsite_building_activity_templates--project_id--dummy" type="hidden" value="$project_id">
					<input id="create-jobsite_building_activity_template-record--jobsite_building_activity_templates--jobsite_activity_list_template_id--dummy" type="hidden" value="$jobsite_activity_list_template_id">
				</td>
			</tr>

		</table>
		</form>
	</div>
	<input type="hidden" id="importJobsiteActivitiesDialogTitle" value="$importJobsiteActivitiesDialogTitle">
	<input type="hidden" id="jobsiteActivitiesTableElementId" value="$jobsiteActivitiesTableElementId">
	<div id="divImportJobsiteActivities" class="hidden"></div>
	<div id="divJobsiteBuildingActivityTemplateDetails" class="hidden"></div>
	<div class="widgetContainer" style="width:850px">
		<h3 class="title">Manage Jobsite Building Activity Templates</h3>
		<table id="$jobsiteActivitiesTableElementId" class="content" width="95%" cellpadding="5">
			<thead class="borderBottom">
				<tr>
					<th class="textAlignLeft">Jobsite Building Activity Template</th>
					<th class="textAlignLeft">Link To Cost Code <span class="entypo entypo-info-circled" style="font-weight: normal;" rel="tooltip" title="Link each activity to one or more cost codes. That way, the activities can be organized by trade in the Daily Log Building tab."></span></th>
					<th class="textAlignCenter">Delete</th>
				</tr>
			</thead>
			<tbody class="altColors">
				$tableJobsiteBuildingActivityTemplatesTbody
			</tbody>
		</table>
	</div>
	<div id="divLinkJobsiteActivitiesToCostCodes" class="hidden"></div>
END_HTML_CONTENT;

		return $htmlContent;

	} catch (Exception $e) {
		$x=1;
	}
}

function buildAdminManageJobsiteSiteworkActivityTemplates($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $jobsite_activity_list_template_id)
{
	try {

		$importJobsiteActivitiesDialogTitle = 'Import Jobsite Sitework Activity Template Data';
		$jobsiteActivitiesTableElementId = 'record_list_container--manage-jobsite_sitework_activity_template-record';

		$tableJobsiteSiteworkActivityTemplatesTbody = buildJobsiteSiteworkActivityTemplatesTbody($database, $jobsite_activity_list_template_id);

		$htmlContent = <<<END_HTML_CONTENT

	<div style="padding:15px 0 0 15px">
		<input type="button" onclick="showCreateJobsiteSiteworkActivityTemplate();" value="Create Jobsite Sitework Activity Template">
	</div>
	<div id="divCreateJobsiteSiteworkActivityTemplate" class="widgetContainer hidden" style="width:500px;">
		<h3 class="title">
			Create New Jobsite Sitework Activity Template
			<div style="float: right;">
				<span class="entypo entypo-click entypo-cancel" onclick="hideCreateJobsiteSiteworkActivityTemplate();" style="margin-right: 0;"></span>
			</div>
		</h3>
		<form id="formCreateJobsiteSiteworkActivityTemplate">
		<table id="record_creation_form_container--create-jobsite_sitework_activity_template-record--dummy" class="content" cellpadding="15px" width="95%">

			<tr id="record_creation_form_error_message_container--create-jobsite_sitework_activity_template-record--dummy" class="displayNone">
				<td class="textAlignLeft" colspan="2">
					<span id="create-jobsite_sitework_activity_template-record--jobsite_sitework_activity_templates--errorMessage--dummy" class="pageBlurbErrorClass"></span>
				</td>
			</tr>

			<tr>
				<td class="textAlignRight verticalAlignMiddle">Label:</td>
				<td class="textAlignLeft">
					<input type="text" id="create-jobsite_sitework_activity_template-record--jobsite_sitework_activity_templates--jobsite_sitework_activity_label--dummy" class="required" style="width:375px;">
				</td>
			</tr>

			<tr>
				<td></td>
				<td class="textAlignRight">
					<input type="button" value="Create Jobsite Sitework Activity Template" onclick="createJobsiteSiteworkActivityTemplateAndReloadDataTableViaPromiseChain('create-jobsite_sitework_activity_template-record', 'dummy');">
					<input id="create-jobsite_sitework_activity_template-record--jobsite_sitework_activity_templates--project_id--dummy" type="hidden" value="$project_id">
					<input id="create-jobsite_sitework_activity_template-record--jobsite_sitework_activity_templates--jobsite_activity_list_template_id--dummy" type="hidden" value="$jobsite_activity_list_template_id">
				</td>
			</tr>

		</table>
		</form>
	</div>
	<input type="hidden" id="importJobsiteActivitiesDialogTitle" value="$importJobsiteActivitiesDialogTitle">
	<input type="hidden" id="jobsiteActivitiesTableElementId" value="$jobsiteActivitiesTableElementId">
	<div id="divImportJobsiteActivities" class="hidden"></div>
	<div id="divJobsiteSiteworkActivityTemplateDetails" class="hidden"></div>
	<div class="widgetContainer" style="width:850px">
		<h3 class="title">Manage Jobsite Sitework Activity Templates</h3>
		<table id="$jobsiteActivitiesTableElementId" class="content" width="95%" cellpadding="5">
			<thead class="borderBottom">

				<tr>
				<th class="textAlignLeft">Jobsite Sitework Activity Template</th>
				<th class="textAlignLeft">Link To Cost Code <span class="entypo entypo-info-circled" style="font-weight: normal;" rel="tooltip" title="Link each activity to one or more cost codes. That way, the activities can be organized by trade in the Daily Log Sitework tab."></span></th>
				<th class="textAlignCenter">Delete</th>
				</tr>

			</thead>
			<tbody class="altColors">
				$tableJobsiteSiteworkActivityTemplatesTbody
			</tbody>
		</table>
	</div>
	<div id="divLinkJobsiteActivitiesToCostCodes" class="hidden"></div>
END_HTML_CONTENT;

		return $htmlContent;

	} catch (Exception $e) {
		$x=1;
	}
}

function buildAdminManageJobsiteOffsiteworkActivityTemplates($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $jobsite_activity_list_template_id)
{
	try {

		$importJobsiteActivitiesDialogTitle = 'Import Jobsite Offsitework Activity Template Data';
		$jobsiteActivitiesTableElementId = 'record_list_container--manage-jobsite_offsitework_activity_template-record';

		$tableJobsiteOffsiteworkActivityTemplatesTbody = buildJobsiteOffsiteworkActivityTemplatesTbody($database, $jobsite_activity_list_template_id);

		$htmlContent = <<<END_HTML_CONTENT

	<div style="padding:15px 0 0 15px">
		<input type="button" onclick="showCreateJobsiteOffsiteworkActivityTemplate();" value="Create Jobsite Offsitework Activity Template">
	</div>
	<div id="divCreateJobsiteOffsiteworkActivityTemplate" class="widgetContainer hidden" style="width:500px;">
		<h3 class="title">
			Create New Jobsite Offsitework Activity Template
			<div style="float: right;">
				<span class="entypo entypo-click entypo-cancel" onclick="hideCreateJobsiteOffsiteworkActivityTemplate();" style="margin-right: 0;"></span>
			</div>
		</h3>
		<form id="formCreateJobsiteOffsiteworkActivityTemplate">
		<table id="record_creation_form_container--create-jobsite_offsitework_activity_template-record--dummy" class="content" cellpadding="15px" width="95%">

			<tr id="record_creation_form_error_message_container--create-jobsite_offsitework_activity_template-record--dummy" class="displayNone">
				<td class="textAlignLeft" colspan="2">
					<span id="create-jobsite_offsitework_activity_template-record--jobsite_offsitework_activity_templates--errorMessage--dummy" class="pageBlurbErrorClass"></span>
				</td>
			</tr>

			<tr>
				<td class="textAlignRight verticalAlignMiddle">Label:</td>
				<td class="textAlignLeft">
					<input type="text" id="create-jobsite_offsitework_activity_template-record--jobsite_offsitework_activity_templates--jobsite_offsitework_activity_label--dummy" class="required" style="width:375px;">
				</td>
			</tr>

			<tr>
				<td></td>
				<td class="textAlignRight">
					<input type="button" value="Create Jobsite Offsitework Activity Template" onclick="createJobsiteOffsiteworkActivityTemplateAndReloadDataTableViaPromiseChain('create-jobsite_offsitework_activity_template-record', 'dummy');">
					<input id="create-jobsite_offsitework_activity_template-record--jobsite_offsitework_activity_templates--project_id--dummy" type="hidden" value="$project_id">
					<input id="create-jobsite_offsitework_activity_template-record--jobsite_offsitework_activity_templates--jobsite_activity_list_template_id--dummy" type="hidden" value="$jobsite_activity_list_template_id">
				</td>
			</tr>

		</table>
		</form>
	</div>
	<input type="hidden" id="importJobsiteActivitiesDialogTitle" value="$importJobsiteActivitiesDialogTitle">
	<input type="hidden" id="jobsiteActivitiesTableElementId" value="$jobsiteActivitiesTableElementId">
	<div id="divImportJobsiteActivities" class="hidden"></div>
	<div id="divJobsiteOffsiteworkActivityTemplateDetails" class="hidden"></div>
	<div class="widgetContainer" style="width:850px">
		<h3 class="title">Manage Jobsite Offsitework Activity Templates</h3>
		<table id="$jobsiteActivitiesTableElementId" class="content" width="95%" cellpadding="5">
			<thead class="borderBottom">
				<tr>
					<th class="textAlignLeft">Jobsite Offsitework Activity Template</th>
					<th class="textAlignLeft">Link To Cost Code <span class="entypo entypo-info-circled" style="font-weight: normal;" rel="tooltip" title="Link each activity to one or more cost codes. That way, the activities can be organized by trade in the Daily Log Offsitework tab."></span></th>
					<th class="textAlignCenter">Delete</th>
				</tr>
			</thead>
			<tbody class="altColors">
				$tableJobsiteOffsiteworkActivityTemplatesTbody
			</tbody>
		</table>
	</div>
	<div id="divLinkJobsiteActivitiesToCostCodes" class="hidden"></div>
END_HTML_CONTENT;

		return $htmlContent;

	} catch (Exception $e) {
		$x=1;
	}
}

function buildJobsiteBuildingActivityTemplatesTbody($database, $jobsite_activity_list_template_id)
{
	$tableJobsiteBuildingActivityTemplatesTbody = '';
	$loadJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateIdOptions = new Input();
	$loadJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateIdOptions->forceLoadFlag = true;
	$arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId = JobsiteBuildingActivityTemplate::loadJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId($database, $jobsite_activity_list_template_id, $loadJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateIdOptions);
	foreach ($arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId as $jobsite_building_activity_template_id => $jobsiteBuildingActivityTemplate) {
		/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */

		$jobsiteBuildingActivityTemplate->htmlEntityEscapeProperties();

		$jobsite_building_activity_label = $jobsiteBuildingActivityTemplate->jobsite_building_activity_label;
		$escaped_jobsite_building_activity_label = $jobsiteBuildingActivityTemplate->escaped_jobsite_building_activity_label;

		//<td class="textAlignLeft"><label for="$checkboxElementId" style="float:none; margin:0; padding: 0;">$escaped_jobsite_building_activity_label</label></td>

		$checkboxElementId = "manage-jobsite_building_activity_template-record--jobsite_building_activity_templates--jobsite_building_activity_template_id--$jobsite_building_activity_template_id";
		$containerElementId = "record_container--manage-jobsite_building_activity_template-record--jobsite_building_activity_templates--sort_order--$jobsite_building_activity_template_id";
		$tableJobsiteBuildingActivityTemplatesTbody .= <<<END_JOBSITE_BUILDING_ACTIVITY_TABLE_TBODY_HTML

		<tr id="$containerElementId">
			<td class="textAlignLeft">$escaped_jobsite_building_activity_label</td>
			<td class="textAlignLeft"><a href="javascript:loadJobsiteActivitiesToCostCodesDialog('jobsite_building_activity_templates', '$jobsite_building_activity_template_id', '$escaped_jobsite_building_activity_label');">View Cost Code Links</a></td>
			<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="deleteJobsiteBuildingActivityTemplateAndDependentDataAndReloadDataTableViaPromiseChain('$containerElementId', 'manage-jobsite_building_activity_template-record', '$jobsite_building_activity_template_id');"></span></td>
		</tr>
END_JOBSITE_BUILDING_ACTIVITY_TABLE_TBODY_HTML;

	}

	return $tableJobsiteBuildingActivityTemplatesTbody;
}

function buildJobsiteSiteworkActivityTemplatesTbody($database, $jobsite_activity_list_template_id)
{
	$tableJobsiteSiteworkActivityTemplatesTbody = '';
	$loadJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions = new Input();
	$loadJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions->forceLoadFlag = true;
	$arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId = JobsiteSiteworkActivityTemplate::loadJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId($database, $jobsite_activity_list_template_id, $loadJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions);
	foreach ($arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId as $jobsite_sitework_activity_template_id => $jobsiteSiteworkActivityTemplate) {
		/* @var $jobsiteSiteworkActivityTemplate JobsiteSiteworkActivityTemplate */

		$jobsite_sitework_activity_label = $jobsiteSiteworkActivityTemplate->jobsite_sitework_activity_label;

		//<td class="textAlignLeft"><label for="$checkboxElementId" style="float:none; margin:0; padding: 0;">$jobsite_sitework_activity_label</label></td>

		$checkboxElementId =                    "manage-jobsite_sitework_activity_template-record--jobsite_sitework_activity_templates--jobsite_sitework_activity_template_id--$jobsite_sitework_activity_template_id";
		$containerElementId = "record_container--manage-jobsite_sitework_activity_template-record--jobsite_sitework_activity_templates--sort_order--$jobsite_sitework_activity_template_id";
		$tableJobsiteSiteworkActivityTemplatesTbody .= <<<END_JOBSITE_SITEWORK_ACTIVITY_TABLE_TBODY_HTML

		<tr id="$containerElementId">
			<td class="textAlignLeft">$jobsite_sitework_activity_label</td>
			<td class="textAlignLeft"><a href="javascript:loadJobsiteActivitiesToCostCodesDialog('jobsite_sitework_activity_templates', '$jobsite_sitework_activity_template_id', '$jobsite_sitework_activity_label');">View Cost Code Links</a></td>
			<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="deleteJobsiteSiteworkActivityTemplateAndDependentDataAndReloadDataTableViaPromiseChain('$containerElementId', 'manage-jobsite_sitework_activity_template-record', '$jobsite_sitework_activity_template_id');"></span></td>
		</tr>
END_JOBSITE_SITEWORK_ACTIVITY_TABLE_TBODY_HTML;

	}

	return $tableJobsiteSiteworkActivityTemplatesTbody;
}

function buildJobsiteOffsiteworkActivityTemplatesTbody($database, $jobsite_activity_list_template_id)
{
	$tableJobsiteOffsiteworkActivityTemplatesTbody = '';
	$loadJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions = new Input();
	$loadJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions->forceLoadFlag = true;
	$arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId = JobsiteOffsiteworkActivityTemplate::loadJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId($database, $jobsite_activity_list_template_id, $loadJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions);
	foreach ($arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId as $jobsite_offsitework_activity_template_id => $jobsiteOffsiteworkActivityTemplate) {
		/* @var $jobsiteOffsiteworkActivityTemplate JobsiteOffsiteworkActivityTemplate */

		$jobsite_offsitework_activity_label = $jobsiteOffsiteworkActivityTemplate->jobsite_offsitework_activity_label;
		$jobsiteOffsiteworkActivityTemplate->htmlEntityEscapeProperties();
		$escaped_jobsite_offsitework_activity_label = $jobsiteOffsiteworkActivityTemplate->escaped_jobsite_offsitework_activity_label;

		$checkboxElementId = "manage-jobsite_offsitework_activity_template-record--jobsite_offsitework_activity_templates--jobsite_offsitework_activity_template_id--$jobsite_offsitework_activity_template_id";
		$containerElementId = "record_container--manage-jobsite_offsitework_activity_template-record--jobsite_offsitework_activity_templates--$jobsite_offsitework_activity_template_id";
		$tableJobsiteOffsiteworkActivityTemplatesTbody .= <<<END_JOBSITE_OFFSITEWORK_ACTIVITY_TABLE_TBODY_HTML

		<tr id="$containerElementId">
			<td class="textAlignLeft"><label for="$checkboxElementId" style="float:none; margin:0; padding: 0;">$escaped_jobsite_offsitework_activity_label</label></td>
			<td class="textAlignLeft"><a href="javascript:loadJobsiteActivitiesToCostCodesDialog('jobsite_offsitework_activity_templates', '$jobsite_offsitework_activity_template_id', '$escaped_jobsite_offsitework_activity_label');">View Cost Code Links</a></td>
			<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="deleteJobsiteOffsiteworkActivityTemplateAndDependentDataAndReloadDataTableViaPromiseChain('$containerElementId', 'manage-jobsite_offsitework_activity_template-record', '$jobsite_offsitework_activity_template_id');"></span></td>
		</tr>
END_JOBSITE_OFFSITEWORK_ACTIVITY_TABLE_TBODY_HTML;

	}

	return $tableJobsiteOffsiteworkActivityTemplatesTbody;
}

/**
 * Takes an array of <td> tags as input and returns a string of <tr> tags,
 * each filled with $numColumns <td> tags.
 *
 * @param array $cells an array of strings, each containing <td> tags.
 * @param int $numColumns the desired number of columns
 * @return string $htmlContent a string of <tr> tags each filled with $numColumns <td> tags.
 */
function columnifyTableCells($cells, $numColumns=4)
{
	$count = count($cells);
	$interval = ceil($count / $numColumns);
	$htmlContent = '';
	for ($i = 0; $i < $interval; $i++) {
		$index = $i;
		$column = 1;
		$htmlContent .= '<tr>';
		while ($index < $count) {
			$cell = $cells[$index];
			$htmlContent .= $cell;
			$index = $index + $interval;
			$column++;
		}
		$htmlContent .= '</tr>';
	}

	return $htmlContent;
}

/**
 * This is a convenience helper function that updates the following:
 *
 * 1) jobsite_daily_logs.modified_by_contact_id
 * 2) jobsite_daily_logs.modified
 *
 * @param string $database
 * @param int $jobsite_daily_log_id
 * @param int $modified_by_contact_id
 */
function updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $modified_by_contact_id)
{
	try {
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->throwExceptionOnDbError = true;

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;
		$modified_by_contact_id = (int) $modified_by_contact_id;

		$jobsiteDailyLog = new JobsiteDailyLog($database);
		$key = array(
			'id' => $jobsite_daily_log_id
		);
		$jobsiteDailyLogDate = JobsiteDailyLog::findJobsiteDailyLogByIdExtended($database, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
		$created_by_contact_id = $jobsiteDailyLogDate->created_by_contact_id;
		$jobsiteDailyLog->setKey($key);
			if (!isset($created_by_contact_id) || empty($created_by_contact_id)) {
			$data = array(
				'created_by_contact_id' => $modified_by_contact_id
			);
		}else {
			$modified = date('Y-m-d H:i:s');
			$data = array(
			'modified' => $modified,
			'modified_by_contact_id' => $modified_by_contact_id
			);
		}
		$jobsiteDailyLog->setData($data);
		$jobsiteDailyLog->save();

	} catch (Exception $e) {

		// Darn it =:(
		$x = 1;

	}
}

function importJobsiteBuildingActivitiesByCsvJobsiteBuildingActivityIds($database, $csvJobsiteBuildingActivityIds, $project_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$db->throwExceptionOnDbError = true;

	$arrJobsiteBuildingActivityIds = explode(',', $csvJobsiteBuildingActivityIds);
	$arrJobsiteBuildingActivitiesByCsvJobsiteActivityIds = JobsiteBuildingActivity::loadJobsiteBuildingActivitiesByArrJobsiteBuildingActivityIds($database, $arrJobsiteBuildingActivityIds);
	$arrNewJobsiteBuildingActivities = array();
	$numDuplicates = 0;
	foreach ($arrJobsiteBuildingActivitiesByCsvJobsiteActivityIds as $jobsite_building_activity_id => $jobsiteBuildingActivity) {
		/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */
		$newJobsiteBuildingActivity = new JobsiteBuildingActivity($database);
		/* @var $newJobsiteBuildingActivity JobsiteBuildingActivity */
		$jobsite_building_activity_label = $jobsiteBuildingActivity->jobsite_building_activity_label;
		$disabled_flag = $jobsiteBuildingActivity->disabled_flag;
		$newJobsiteBuildingActivity->jobsite_building_activity_label = $jobsite_building_activity_label;
		$newJobsiteBuildingActivity->project_id = $project_id;
		$newJobsiteBuildingActivity->disabled_flag = $disabled_flag;
		$newJobsiteSiteworkActivity->sort_order = $sort_data;
		$newJobsiteBuildingActivity->convertPropertiesToData();
		$data = $newJobsiteBuildingActivity->getData();
		//To Set the sort order
		$sort_data=JobsiteDailyLog::NextsortOrderDaliylog('jobsite_building_activities',$project_id);
		$data['sort_order'] = $sort_data; 
		$newJobsiteBuildingActivity->setData($data);
		$newJobsiteBuildingActivity->setKey(null);
		try {
			$new_jobsite_building_activity_id = $newJobsiteBuildingActivity->save();
			$arrNewJobsiteBuildingActivities[$new_jobsite_building_activity_id] = $newJobsiteBuildingActivity;
			// Copy over the cost code links.
			$loadJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityIdOptions = new Input();
			$loadJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityIdOptions->forceLoadFlag = true;
			$arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId =
				JobsiteBuildingActivityToCostCode::loadJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId($database, $jobsite_building_activity_template_id, $loadJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityIdOptions);
			$arrJobsiteBuildingActivitiesToCostCodes = $arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId[$jobsite_building_activity_id];
			foreach ($arrJobsiteBuildingActivitiesToCostCodes as $cost_code_id => $jobsiteBuildingActivityToCostCode) {
				$jobsiteBuildingActivityToCostCode = new JobsiteBuildingActivityToCostCode($database);
				$jobsiteBuildingActivityToCostCode->cost_code_id = $cost_code_id;
				$jobsiteBuildingActivityToCostCode->jobsite_building_activity_id = $jobsite_building_activity_id;
				$jobsiteBuildingActivityToCostCode->convertPropertiesToData();
				try {
					$jobsiteBuildingActivityToCostCode->save();
				} catch (Exception $e) { }
			}
		} catch (Exception $e) {
			$message = $e->getMessage();
			$index = strpos($message, 'Duplicate');
			if ($index > -1) {
				$numDuplicates++;
			}
		}
	}

	$db->throwExceptionOnDbError = false;

	$arrReturn = array(
		'arrJobsiteBuildingActivities' => $arrNewJobsiteBuildingActivities,
		'numDuplicates' => $numDuplicates
	);
	return $arrReturn;
}

function importJobsiteBuildingActivitiesByCsvJobsiteBuildingActivityTemplateIds($database, $csvJobsiteBuildingActivityTemplateIds, $project_id)
{
	$arrJobsiteBuildingActivityTemplateIds = explode(',', $csvJobsiteBuildingActivityTemplateIds);
	JobsiteBuildingActivity::insertIgnore_JobsiteBuildingActivities_from_JobsiteBuildingActivityTemplateIds($database, $project_id, $arrJobsiteBuildingActivityTemplateIds);
	return array();


	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$db->throwExceptionOnDbError = true;
	$arrJobsiteBuildingActivityTemplateIds = explode(',', $csvJobsiteBuildingActivityTemplateIds);

	$arrJobsiteBuildingActivityTemplatesByArrJobsiteActivityTemplateIds =
		JobsiteBuildingActivityTemplate::loadJobsiteBuildingActivityTemplatesByArrJobsiteBuildingActivityTemplateIds($database, $arrJobsiteBuildingActivityTemplateIds);

	$arrJobsiteBuildingActivities = array();
	$numDuplicates = 0;
	foreach ($arrJobsiteBuildingActivityTemplatesByArrJobsiteActivityTemplateIds as $jobsite_building_activity_template_id => $jobsiteBuildingActivityTemplate) {
		/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */
		$jobsiteBuildingActivity = new JobsiteBuildingActivity($database);
		/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */
		$jobsite_building_activity_label = $jobsiteBuildingActivityTemplate->jobsite_building_activity_label;
		$disabled_flag = $jobsiteBuildingActivityTemplate->disabled_flag;
		$jobsiteBuildingActivity->jobsite_building_activity_label = $jobsite_building_activity_label;
		$jobsiteBuildingActivity->project_id = $project_id;
		$jobsiteBuildingActivity->disabled_flag = $disabled_flag;
		$jobsiteBuildingActivity->convertPropertiesToData();
		$data = $jobsiteBuildingActivity->getData();
		$jobsiteBuildingActivity->setData($data);
		$jobsiteBuildingActivity->setKey(null);
		try {
			$jobsite_building_activity_id = $jobsiteBuildingActivity->save();
			$arrJobsiteBuildingActivities[$jobsite_building_activity_id] = $jobsiteBuildingActivity;
			// Copy over the cost code links.
			$loadJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateIdOptions = new Input();
			$loadJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateIdOptions->forceLoadFlag = true;
			$arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId =
				JobsiteBuildingActivityTemplateToCostCode::loadJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId($database, $jobsite_building_activity_template_id, $loadJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateIdOptions);
			$arrJobsiteBuildingActivityTemplatesToCostCodes = $arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId[$jobsite_building_activity_template_id];
			foreach ($arrJobsiteBuildingActivityTemplatesToCostCodes as $cost_code_id => $jobsiteBuildingActivityTemplateToCostCode) {
				$jobsiteBuildingActivityToCostCode = new JobsiteBuildingActivityToCostCode($database);
				$jobsiteBuildingActivityToCostCode->cost_code_id = $cost_code_id;
				$jobsiteBuildingActivityToCostCode->jobsite_building_activity_id = $jobsite_building_activity_id;
				$jobsiteBuildingActivityToCostCode->convertPropertiesToData();
				try {
					$jobsiteBuildingActivityToCostCode->save();
				} catch (Exception $e) { }
			}
		} catch (Exception $e) {
			$message = $e->getMessage();
			$index = strpos($message, 'Duplicate');
			if ($index > -1) {
				$numDuplicates++;
			}
		}
	}

	$db->throwExceptionOnDbError = false;

	$arrReturn = array(
		'arrJobsiteBuildingActivities' => $arrJobsiteBuildingActivities,
		'numDuplicates' => $numDuplicates
	);
	return $arrReturn;
}

function importJobsiteOffsiteworkActivitiesByCsvJobsiteOffsiteworkActivityIds($database, $csvJobsiteOffsiteworkActivityIds, $project_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$db->throwExceptionOnDbError = true;

	$arrJobsiteOffsiteworkActivityIds = explode(',', $csvJobsiteOffsiteworkActivityIds);
	$arrJobsiteOffsiteworkActivitiesByCsvJobsiteActivityIds = JobsiteOffsiteworkActivity::loadJobsiteOffsiteworkActivitiesByArrJobsiteOffsiteworkActivityIds($database, $arrJobsiteOffsiteworkActivityIds);
	$arrNewJobsiteOffsiteworkActivities = array();
	$numDuplicates = 0;
	foreach ($arrJobsiteOffsiteworkActivitiesByCsvJobsiteActivityIds as $jobsite_offsitework_activity_id => $jobsiteOffsiteworkActivity) {
		/* @var $jobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */

		$newJobsiteOffsiteworkActivity = new JobsiteOffsiteworkActivity($database);
		/* @var $newJobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */

		$jobsite_offsitework_activity_label = $jobsiteOffsiteworkActivity->jobsite_offsitework_activity_label;
		$disabled_flag = $jobsiteOffsiteworkActivity->disabled_flag;
		$newJobsiteOffsiteworkActivity->jobsite_offsitework_activity_label = $jobsite_offsitework_activity_label;
		$newJobsiteOffsiteworkActivity->project_id = $project_id;
		$newJobsiteOffsiteworkActivity->disabled_flag = $disabled_flag;
		$newJobsiteOffsiteworkActivity->convertPropertiesToData();
		$data = $newJobsiteOffsiteworkActivity->getData();
		$newJobsiteOffsiteworkActivity->setData($data);
		$newJobsiteOffsiteworkActivity->setKey(null);

		try {
			$new_jobsite_offsitework_activity_id = $newJobsiteOffsiteworkActivity->save();
			$arrNewJobsiteOffsiteworkActivities[$new_jobsite_offsitework_activity_id] = $newJobsiteOffsiteworkActivity;
			// Copy over the cost code links.
			$loadJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityIdOptions = new Input();
			$loadJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityIdOptions->forceLoadFlag = true;
			$arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId =
				JobsiteOffsiteworkActivityToCostCode::loadJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId($database, $jobsite_offsitework_activity_template_id, $loadJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityIdOptions);
			$arrJobsiteOffsiteworkActivitiesToCostCodes = $arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId[$jobsite_offsitework_activity_id];
			foreach ($arrJobsiteOffsiteworkActivitiesToCostCodes as $cost_code_id => $jobsiteOffsiteworkActivityToCostCode) {
				$jobsiteOffsiteworkActivityToCostCode = new JobsiteOffsiteworkActivityToCostCode($database);
				$jobsiteOffsiteworkActivityToCostCode->cost_code_id = $cost_code_id;
				$jobsiteOffsiteworkActivityToCostCode->jobsite_offsitework_activity_id = $jobsite_offsitework_activity_id;
				$jobsiteOffsiteworkActivityToCostCode->convertPropertiesToData();
				try {
					$jobsiteOffsiteworkActivityToCostCode->save();
				} catch (Exception $e) { }
			}
		} catch (Exception $e) {
			$message = $e->getMessage();
			$index = strpos($message, 'Duplicate');
			if ($index > -1) {
				$numDuplicates++;
			}
		}
	}

	$db->throwExceptionOnDbError = false;

	$arrReturn = array(
		'arrJobsiteOffsiteworkActivities' => $arrNewJobsiteOffsiteworkActivities,
		'numDuplicates' => $numDuplicates
	);
	return $arrReturn;
}

function importJobsiteOffsiteworkActivitiesByCsvJobsiteOffsiteworkActivityTemplateIds($database, $csvJobsiteOffsiteworkActivityTemplateIds, $project_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$db->throwExceptionOnDbError = true;

	$arrJobsiteOffsiteworkActivityTemplatesByCsvJobsiteActivityTemplateIds =
		JobsiteOffsiteworkActivityTemplate::loadJobsiteOffsiteworkActivityTemplatesByCsvJobsiteOffsiteworkActivityTemplateIds($database, $csvJobsiteOffsiteworkActivityTemplateIds);

	$arrJobsiteOffsiteworkActivities = array();
	$numDuplicates = 0;
	foreach ($arrJobsiteOffsiteworkActivityTemplatesByCsvJobsiteActivityTemplateIds as $jobsite_offsitework_activity_template_id => $jobsiteOffsiteworkActivityTemplate) {
		/* @var $jobsiteOffsiteworkActivityTemplate JobsiteOffsiteworkActivityTemplate */

		$jobsiteOffsiteworkActivity = new JobsiteOffsiteworkActivity($database);
		/* @var $jobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */

		$jobsite_offsitework_activity_label = $jobsiteOffsiteworkActivityTemplate->jobsite_offsitework_activity_label;
		$disabled_flag = $jobsiteOffsiteworkActivityTemplate->disabled_flag;
		$jobsiteOffsiteworkActivity->jobsite_offsitework_activity_label = $jobsite_offsitework_activity_label;
		$jobsiteOffsiteworkActivity->project_id = $project_id;
		$jobsiteOffsiteworkActivity->disabled_flag = $disabled_flag;
		$jobsiteOffsiteworkActivity->convertPropertiesToData();
		$data = $jobsiteOffsiteworkActivity->getData();
		$jobsiteOffsiteworkActivity->setData($data);
		$jobsiteOffsiteworkActivity->setKey(null);
		try {
			$jobsite_offsitework_activity_id = $jobsiteOffsiteworkActivity->save();
			$arrJobsiteOffsiteworkActivities[$jobsite_offsitework_activity_id] = $jobsiteOffsiteworkActivity;
			// Copy over the cost code links.
			$loadJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateIdOptions = new Input();
			$loadJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateIdOptions->forceLoadFlag = true;
			$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId =
				JobsiteOffsiteworkActivityTemplateToCostCode::loadJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId($database, $jobsite_offsitework_activity_template_id, $loadJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateIdOptions);
			$arrJobsiteOffsiteworkActivityTemplatesToCostCodes = $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId[$jobsite_offsitework_activity_template_id];
			foreach ($arrJobsiteOffsiteworkActivityTemplatesToCostCodes as $cost_code_id => $jobsiteOffsiteworkActivityTemplateToCostCode) {
				$jobsiteOffsiteworkActivityToCostCode = new JobsiteOffsiteworkActivityToCostCode($database);
				$jobsiteOffsiteworkActivityToCostCode->cost_code_id = $cost_code_id;
				$jobsiteOffsiteworkActivityToCostCode->jobsite_offsitework_activity_id = $jobsite_offsitework_activity_id;
				$jobsiteOffsiteworkActivityToCostCode->convertPropertiesToData();
				try {
					$jobsiteOffsiteworkActivityToCostCode->save();
				} catch (Exception $e) { }
			}
		} catch (Exception $e) {
			$message = $e->getMessage();
			$index = strpos($message, 'Duplicate');
			if ($index > -1) {
				$numDuplicates++;
			}
		}
	}

	$db->throwExceptionOnDbError = false;

	$arrReturn = array(
		'arrJobsiteOffsiteworkActivities' => $arrJobsiteOffsiteworkActivities,
		'numDuplicates' => $numDuplicates
	);
	return $arrReturn;
}

function importJobsiteSiteworkActivitiesByCsvJobsiteSiteworkActivityIds($database, $csvJobsiteSiteworkActivityIds, $project_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$db->throwExceptionOnDbError = true;
	$arrJobsiteSiteworkActivityIds = explode(',', $csvJobsiteSiteworkActivityIds);

	$arrJobsiteSiteworkActivitiesByCsvJobsiteActivityIds = JobsiteSiteworkActivity::loadJobsiteSiteworkActivitiesByArrJobsiteSiteworkActivityIds($database, $arrJobsiteSiteworkActivityIds);
	$arrNewJobsiteSiteworkActivities = array();
	$numDuplicates = 0;
	foreach ($arrJobsiteSiteworkActivitiesByCsvJobsiteActivityIds as $jobsite_sitework_activity_id => $jobsiteSiteworkActivity) {
		/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */
		$newJobsiteSiteworkActivity = new JobsiteSiteworkActivity($database);
		/* @var $newJobsiteSiteworkActivity JobsiteSiteworkActivity */
		$jobsite_sitework_activity_label = $jobsiteSiteworkActivity->jobsite_sitework_activity_label;
		$disabled_flag = $jobsiteSiteworkActivity->disabled_flag;
		$newJobsiteSiteworkActivity->jobsite_sitework_activity_label = $jobsite_sitework_activity_label;
		$newJobsiteSiteworkActivity->project_id = $project_id;
		$newJobsiteSiteworkActivity->disabled_flag = $disabled_flag;
		$newJobsiteSiteworkActivity->convertPropertiesToData();
		$data = $newJobsiteSiteworkActivity->getData();
		//To Set the sort order
		$sort_data=JobsiteDailyLog::NextsortOrderDaliylog('jobsite_sitework_activities',$project_id);
		$data['sort_order'] = $sort_data; 
		$newJobsiteSiteworkActivity->setData($data);
		$newJobsiteSiteworkActivity->setKey(null);
		try {
			$new_jobsite_sitework_activity_id = $newJobsiteSiteworkActivity->save();
			$arrNewJobsiteSiteworkActivities[$new_jobsite_sitework_activity_id] = $newJobsiteSiteworkActivity;
			// Copy over the cost code links.
			$loadJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityIdOptions = new Input();
			$loadJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityIdOptions->forceLoadFlag = true;
			$arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId =
				JobsiteSiteworkActivityToCostCode::loadJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId($database, $jobsite_sitework_activity_template_id, $loadJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityIdOptions);
			$arrJobsiteSiteworkActivitiesToCostCodes = $arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId[$jobsite_sitework_activity_id];
			foreach ($arrJobsiteSiteworkActivitiesToCostCodes as $cost_code_id => $jobsiteSiteworkActivityToCostCode) {
				$jobsiteSiteworkActivityToCostCode = new JobsiteSiteworkActivityToCostCode($database);
				$jobsiteSiteworkActivityToCostCode->cost_code_id = $cost_code_id;
				$jobsiteSiteworkActivityToCostCode->jobsite_sitework_activity_id = $jobsite_sitework_activity_id;
				$jobsiteSiteworkActivityToCostCode->convertPropertiesToData();
				try {
					$jobsiteSiteworkActivityToCostCode->save();
				} catch (Exception $e) { }
			}
		} catch (Exception $e) {
			$message = $e->getMessage();
			$index = strpos($message, 'Duplicate');
			if ($index > -1) {
				$numDuplicates++;
			}
		}
	}

	$db->throwExceptionOnDbError = false;

	$arrReturn = array(
		'arrJobsiteSiteworkActivities' => $arrNewJobsiteSiteworkActivities,
		'numDuplicates' => $numDuplicates
	);
	return $arrReturn;
}

function importJobsiteSiteworkActivitiesByCsvJobsiteSiteworkActivityTemplateIds($database, $csvJobsiteSiteworkActivityTemplateIds, $project_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$db->throwExceptionOnDbError = true;

	$arrJobsiteSiteworkActivityTemplateIds = explode(',', $csvJobsiteSiteworkActivityTemplateIds);
	$arrJobsiteSiteworkActivityTemplatesByCsvJobsiteActivityTemplateIds =
		JobsiteSiteworkActivityTemplate::loadJobsiteSiteworkActivityTemplatesByArrJobsiteSiteworkActivityTemplateIds($database, $arrJobsiteSiteworkActivityTemplateIds);

	$arrJobsiteSiteworkActivities = array();
	$numDuplicates = 0;
	foreach ($arrJobsiteSiteworkActivityTemplatesByCsvJobsiteActivityTemplateIds as $jobsite_sitework_activity_template_id => $jobsiteSiteworkActivityTemplate) {
		/* @var $jobsiteSiteworkActivityTemplate JobsiteSiteworkActivityTemplate */

		$jobsiteSiteworkActivity = new JobsiteSiteworkActivity($database);
		/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */

		$jobsite_sitework_activity_label = $jobsiteSiteworkActivityTemplate->jobsite_sitework_activity_label;
		$disabled_flag = $jobsiteSiteworkActivityTemplate->disabled_flag;
		$jobsiteSiteworkActivity->jobsite_sitework_activity_label = $jobsite_sitework_activity_label;
		$jobsiteSiteworkActivity->project_id = $project_id;
		$jobsiteSiteworkActivity->disabled_flag = $disabled_flag;
		$jobsiteSiteworkActivity->convertPropertiesToData();
		$data = $jobsiteSiteworkActivity->getData();
		$sort_data=JobsiteDailyLog::NextsortOrderDaliylog('jobsite_sitework_activities',$project_id);
		$data['sort_order'] = $sort_data; 
		$jobsiteSiteworkActivity->setData($data);
		$jobsiteSiteworkActivity->setKey(null);

		try {
			$jobsite_sitework_activity_id = $jobsiteSiteworkActivity->save();
			$arrJobsiteSiteworkActivities[$jobsite_sitework_activity_id] = $jobsiteSiteworkActivity;
			// Copy over the cost code links.
			$loadJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateIdOptions = new Input();
			$loadJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateIdOptions->forceLoadFlag = true;
			$arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId =
				JobsiteSiteworkActivityTemplateToCostCode::loadJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId($database, $jobsite_sitework_activity_template_id, $loadJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateIdOptions);
			$arrJobsiteSiteworkActivityTemplatesToCostCodes = $arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId[$jobsite_sitework_activity_template_id];
			foreach ($arrJobsiteSiteworkActivityTemplatesToCostCodes as $cost_code_id => $jobsiteSiteworkActivityTemplateToCostCode) {
				$jobsiteSiteworkActivityToCostCode = new JobsiteSiteworkActivityToCostCode($database);
				$jobsiteSiteworkActivityToCostCode->cost_code_id = $cost_code_id;
				$jobsiteSiteworkActivityToCostCode->jobsite_sitework_activity_id = $jobsite_sitework_activity_id;
				$jobsiteSiteworkActivityToCostCode->convertPropertiesToData();
				try {
					$jobsiteSiteworkActivityToCostCode->save();
				} catch (Exception $e) { }
			}
		} catch (Exception $e) {
			$message = $e->getMessage();
			$index = strpos($message, 'Duplicate');
			if ($index > -1) {
				$numDuplicates++;
			}
		}
	}

	$db->throwExceptionOnDbError = false;

	$arrReturn = array(
		'arrJobsiteSiteworkActivities' => $arrJobsiteSiteworkActivities,
		'numDuplicates' => $numDuplicates
	);

	return $arrReturn;
}

function getAmPmWeatherTemperaturesAndConditions($database, $project_id, $created)
{
	$arrOpenWeatherMeasurements = OpenWeatherAmPmLogs::loadAmPmOpenWeatherByProjectId($database, $project_id, $created);
	$amWeatherUndergroundMeasurement = $arrOpenWeatherMeasurements['am'];
	$pmWeatherUndergroundMeasurement = $arrOpenWeatherMeasurements['pm'];

	// Sanity check to see if this report is for the present or a past date
	$todayAsMysqlDate = date('Y-m-d');
	$createdAsUnixTimestamp = strtotime($created);
	$createdAsMysqlDate = date('Y-m-d', $createdAsUnixTimestamp);

	if ($todayAsMysqlDate == $createdAsMysqlDate) {
		$reportIsForToday = true;
	} else {
		$reportIsForToday = false;
	}

	if ($amWeatherUndergroundMeasurement) {
		/* @var $amWeatherUndergroundMeasurement WeatherUndergroundMeasurement */
		$amTemperature = $amWeatherUndergroundMeasurement['temperature'] . '&deg; F';
		$amCondition = $amWeatherUndergroundMeasurement['condition'];
	} else {
		if ($reportIsForToday) {

			$nowAsUnixTimestamp = time();
			$eightAm = $createdAsUnixTimestamp + 28800;
			// Past and Present Weather Measurements
			if ($createdAsUnixTimestamp <= $nowAsUnixTimestamp) {
				// Today, but earlier than 5:00am when the first measurement is recorded
				if ($nowAsUnixTimestamp < $eightAm) {
					$amTemperature = 'TBD';
					$amCondition = 'TBD';
				} else {
					// Past Date: either no measurement was recorded, or weather data is unavailable
					$amTemperature = 'Unavailable';
					$amCondition = 'Unavailable';
				}
			} else {
				// Future Weather Measurements
				$amTemperature = 'TBD';
				$amCondition = 'TBD';
			}

		} else {
			// Past Date: either no measurement was recorded, or weather data is unavailable
			$amTemperature = 'Unavailable';
			$amCondition = 'Unavailable';
		}
	}

	if ($pmWeatherUndergroundMeasurement) {
		/* @var $pmWeatherUndergroundMeasurement WeatherUndergroundMeasurement */
		$pmTemperature = $pmWeatherUndergroundMeasurement['temperature'] . '&deg; F';
		$pmCondition = $pmWeatherUndergroundMeasurement['condition'];
	} else {
		if ($reportIsForToday) {

			$todayAsMysqlDate = date('Y-m-d');
			if ($created == $todayAsMysqlDate) {
				$pmTemperature = 'TBD';
				$pmCondition = 'TBD';
			} else {
				$createdAsUnixTimestamp = strtotime($created);
				$todayAsUnixTimestamp = strtotime($todayAsMysqlDate);
				if ($createdAsUnixTimestamp < $todayAsUnixTimestamp) {
					$pmTemperature = 'Unavailable';
					$pmCondition = 'Unavailable';
				} else {
					$pmTemperature = 'TBD';
					$pmCondition = 'TBD';
				}
			}

		} else {
			// Past Date: either no measurement was recorded, or weather data is unavailable
			$pmTemperature = 'Unavailable';
			$pmCondition = 'Unavailable';
		}
	}

	$arrReturn = array(
		'amTemperature' => $amTemperature,
		'amCondition'   => $amCondition,
		'pmTemperature' => $pmTemperature,
		'pmCondition'   => $pmCondition
	);
	return $arrReturn;
}

function generateDailyConstructionReport($database, JobsiteDailyLog $jobsiteDailyLog, $PDFOrHTML = false, $apiTimer = true){
	/* @var $jobsiteDailyLog JobsiteDailyLog */

	$uri = Zend_Registry::get('uri');
	/* @var $uri Uri */

	$jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
	$project_id = $jobsiteDailyLog->project_id;
	$modified_by_contact_id = $jobsiteDailyLog->modified_by_contact_id;
	$created_by_contact_id = $jobsiteDailyLog->created_by_contact_id;
	$jobsite_daily_log_created_date = $jobsiteDailyLog->jobsite_daily_log_created_date;

	$project = $jobsiteDailyLog->getProject();
	/* @var $project Project */

	$user_company_id = $project->user_company_id;
	$project_name = $project->project_name;

	$project->htmlEntityEscapeProperties();
	$escaped_project_name = $project->escaped_project_name;

	$userCompany = $project->getUserCompany();
	/* @var $userCompany UserCompany */

	$userCompany->htmlEntityEscapeProperties();
	$escaped_user_company_name = $userCompany->escaped_user_company_name;

	$jobsiteDailyLogModifiedByContact = $jobsiteDailyLog->getModifiedByContact();
	/* @var $jobsiteDailyLogModifiedByContact Contact */

	$jobsiteDailyLogCreatedByContact = $jobsiteDailyLog->getCreatedByContact();
	/* @var $jobsiteDailyLogModifiedByContact Contact */

	$header = $escaped_user_company_name . ' | Daily Construction Report';
	// @todo Have a footer that's different than the header?
	$footer = $header;

	$DCRPreviewSectionHtmlContent = buildDCRPreviewSection($database, $jobsiteDailyLog, $user_company_id, $PDFOrHTML);

	$http = $uri->http;



	$htmlContent = <<<END_HTML_CONTENT

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{$http}css/styles.css">
	<link rel="stylesheet" type="text/css" href="{$http}css/modules-jobsite-daily-logs.css">
	<link rel="stylesheet" type="text/css" href="{$http}css/modules-daily-construction-report.css">
</head>
<body style="font-size: 90%;">
		$DCRPreviewSectionHtmlContent				
</body>
</html>

END_HTML_CONTENT;
	


	$pdfPhantomJS = new PdfPhantomJS();
  	$pdfPhantomJS->setPdffooter($footer, null, 'DailyLog');
  	$pdfPhantomJS->setPdfPaperSize('8.5in', '11in');
  	$pdfPhantomJS->setMargin('50px', '50px', '50px', '0px');
  	
	$pdfPhantomJS->writeTempFileContentsToDisk($htmlContent);

	// generate url with query_string for phontomJS to read the file with contents from $htmlOutput
	$pdfTempFileUrl = $pdfPhantomJS->getTempFileUrl();

	$pdfPhantomJS->setTempFileUrl($pdfTempFileUrl);
	$htmlTempFileBasePath = $pdfPhantomJS->getTempFileBasePath();
	$htmlTempFileSha1 = $pdfPhantomJS->getTempFileSha1();
	$pdfTempFileFullPath = $htmlTempFileBasePath . $htmlTempFileSha1 . '.pdf';
	
	$pdfPhantomJS->setCompletePdfFilePath($pdfTempFileFullPath);

	$result = $pdfPhantomJS->execute();


	// delete the html temp file
	$pdfPhantomJS->deleteTempFile();

	// LOGGING UPLOAD TIME TO THE BACKEND FILE DATABASE\
	if($apiTimer) {
		$timer = Zend_Registry::get('timer');
		$timer->startTimer();
		$_SESSION['timer'] = $timer;
	}	

	$dailyConstructionReportName = 'Daily Construction Report - '.$project_name.' - '.$jobsite_daily_log_created_date.'.pdf';
	$sha1 = sha1_file($pdfTempFileFullPath);
	$size = filesize($pdfTempFileFullPath);
	$tempFilePath = $pdfTempFileFullPath;

	$fileExtension = 'pdf';
	$virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);

	// Convert file content to File object
	$error = null;
	$virtual_file_name = $dailyConstructionReportName;

	$file = new File();
	/*Custom Changed  For Generate PDF*/
	 $file->sha1 = $sha1;
	/*Custom Changed  For Generate PDF*/
	

	$file->name = $virtual_file_name;
	$file->size = $size;
	$file->type = $virtual_file_mime_type;
	$file->tempFilePath = $tempFilePath;
	$file->fileExtension = $fileExtension;

	$file_location_id = FileManager::saveUploadedFileToCloud($database, $file, $apiTimer);

	// Delete temp file if it was not deleted by FileManager::saveUploadedFileToCloud(...)
	if (is_file($tempFilePath)) {
		unlink($tempFilePath);
	}

	// Folder
	// Save the file_manager_folders record (virtual_file_path) to the db and get the id
	$yearY = date('Y');
	$monthF = date('m F');
	$virtual_file_path = "/Daily Log/DCRs/$yearY/$monthF/";

	// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
	$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
	$currentVirtualFilePath = '/';

	foreach ($arrFolders as $folder) {
		$tmpVirtualFilePath = array_shift($arrFolders);
		$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
		// Save the file_manager_folders record (virtual_file_path) to the db and get the id
		$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $created_by_contact_id, $project_id, $currentVirtualFilePath);
		$newlycreated = $fileManagerFolder->getVirtualFilePathDidNotExist();

		if($newlycreated){
		//To set the permission for all subfolders within daliy log
		$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;
		$parentFol= $fileManagerFolder->getParentFolderId();
		FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parentFol);
		}
		
	}
	/* @var $fileManagerFolder FileManagerFolder */

	// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
	/* @var $fileManagerFolder FileManagerFolder */
	$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

	// save the file information to the file_manager_files db table
	$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $user_company_id, $created_by_contact_id, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
	/* @var $fileManagerFile FileManagerFile */
	$file_manager_file_id = $fileManagerFile->file_manager_file_id;

	// Set Permissions of the file to match the parent folder.
	 $parent_file_manager_folder_id= $fileManagerFolder->getParentFolderId();
   	 FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
	FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);

	$daily_construction_report_type_id = 2;
	$daily_construction_report_file_manager_file_id = $file_manager_file_id;
	$daily_construction_report_sequence_number = 1;

	// create daily_construction_report record
	$dailyConstructionReport = new DailyConstructionReport($database);
	$dailyConstructionReport->jobsite_daily_log_id = (int) $jobsite_daily_log_id;
	$dailyConstructionReport->daily_construction_report_type_id = (int) $daily_construction_report_type_id;
	$dailyConstructionReport->daily_construction_report_file_manager_file_id = (int) $daily_construction_report_file_manager_file_id;
	$dailyConstructionReport->daily_construction_report_sequence_number = (int) $daily_construction_report_sequence_number;
	$dailyConstructionReport->convertPropertiesToData();

	$data = $dailyConstructionReport->getData();

	// Test for existence via standard findByUniqueIndex method
	$dailyConstructionReport->findByUniqueIndex();
	if (!$dailyConstructionReport->isDataLoaded()) {
		$dailyConstructionReport->convertPropertiesToData();
		$dailyConstructionReport->setKey(null);
		$dailyConstructionReport->save();
	}

	// PDF Link
	if ($fileManagerFile) {
		$fileManagerFile->setProject($project);
		return $fileManagerFile;
	}
}

// Function to get the dcr file details 
function getDcrFileDetails($database, $date, $project_id){
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$query =	"SELECT * FROM `dcr_file` WHERE `project_id` = ? AND DATE(`date`)= ?";
	$arrValues = array($project_id,$date);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();	
	return $row;
}

function loadJobsiteBuildingActivityLabelsInUseByJobsiteDailyBuildingActivityLogsByProjectId($database, $project_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$query =	"SELECT
					jba.`jobsite_building_activity_label`
				FROM `jobsite_building_activities` jba
					INNER JOIN `jobsite_daily_building_activity_logs` jdbal
				WHERE jba.`project_id` = ?
					AND jba.`id` = jdbal.`jobsite_building_activity_id`";
	$arrValues = array($project_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrJobsiteBuildingActivityLabelsInUseByJobsiteDailyBuildingActivityLogsByProjectId = array();
	while ($row = $db->fetch()) {
		$jobsite_building_activity_label = $row['jobsite_building_activity_label'];
		$arrJobsiteBuildingActivityLabelsInUseByJobsiteDailyBuildingActivityLogsByProjectId[$jobsite_building_activity_label] = 1;
	}
	$db->free_result();

	return $arrJobsiteBuildingActivityLabelsInUseByJobsiteDailyBuildingActivityLogsByProjectId;
}

function loadJobsiteOffsiteworkActivityLabelsInUseByJobsiteDailyOffsiteworkActivityLogsByProjectId($database, $project_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$query =	"SELECT
					jba.`jobsite_offsitework_activity_label`
				FROM `jobsite_offsitework_activities` jba
					INNER JOIN `jobsite_daily_offsitework_activity_logs` jdbal
				WHERE jba.`project_id` = ?
					AND jba.`id` = jdbal.`jobsite_offsitework_activity_id`";
	$arrValues = array($project_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrJobsiteOffsiteworkActivityLabelsInUseByJobsiteDailyOffsiteworkActivityLogsByProjectId = array();
	while ($row = $db->fetch()) {
		$jobsite_offsitework_activity_label = $row['jobsite_offsitework_activity_label'];
		$arrJobsiteOffsiteworkActivityLabelsInUseByJobsiteDailyOffsiteworkActivityLogsByProjectId[$jobsite_offsitework_activity_label] = 1;
	}
	$db->free_result();

	return $arrJobsiteOffsiteworkActivityLabelsInUseByJobsiteDailyOffsiteworkActivityLogsByProjectId;
}

function loadJobsiteSiteworkActivityLabelsInUseByJobsiteDailySiteworkActivityLogsByProjectId($database, $project_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$query =	"SELECT
					jba.`jobsite_sitework_activity_label`
				FROM `jobsite_sitework_activities` jba
					INNER JOIN `jobsite_daily_sitework_activity_logs` jdbal
				WHERE jba.`project_id` = ?
					AND jba.`id` = jdbal.`jobsite_sitework_activity_id`";
	$arrValues = array($project_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrJobsiteSiteworkActivityLabelsInUseByJobsiteDailySiteworkActivityLogsByProjectId = array();
	while ($row = $db->fetch()) {
		$jobsite_sitework_activity_label = $row['jobsite_sitework_activity_label'];
		$arrJobsiteSiteworkActivityLabelsInUseByJobsiteDailySiteworkActivityLogsByProjectId[$jobsite_sitework_activity_label] = 1;
	}
	$db->free_result();

	return $arrJobsiteSiteworkActivityLabelsInUseByJobsiteDailySiteworkActivityLogsByProjectId;
}

function renderJobsitePhotoAsLiElement($database, $jobsitePhoto,$attrId,$jobsite_daily_log_id)
{
	$jobsite_photo_id = $jobsitePhoto->jobsite_photo_id;
	$jobsite_photo_file_manager_file_id = $jobsitePhoto->jobsite_photo_file_manager_file_id;
	$primaryKeyAsString = $jobsitePhoto->getPrimaryKeyAsString();

	$fileManagerFile = FileManagerFile::findById($database, $jobsite_photo_file_manager_file_id);
	/* @var $fileManagerFile FileManagerFile */

	$htmlRecord = '';
	if ($fileManagerFile) {
		$virtual_file_name = $fileManagerFile->virtual_file_name;
		$fileUrl = $fileManagerFile->generateUrl();
		$elementId = "record_container--$attrId--jobsite_photos--" . $primaryKeyAsString;
		
 				$cdnFileUrl = $fileManagerFile->generateUrlBasePath(true);
 				$jobsitePhotoUrl = $fileManagerFile->generateUrlBasePath();
              	//End to get base path

 				$path= realpath($jobsitePhotoUrl);
 				$data = file_get_contents($jobsitePhotoUrl);
 				$base64 = 'data:image;base64,' . base64_encode($data);
 				$jobsitePhotoHtml = '<img alt="Jobsite Photo" style="max-height: 100mm; max-width: 100%;" src="'.$base64.'">';
 				 $captiondata  = TableService::getSingleField($database,'jobsite_photos','caption','id',$jobsite_photo_id);
 				if($jobsitePhoto->internal_use_only_flag =='N')
 				{

		$htmlRecord = <<<END_HTML_CONTENT

			<li id="$elementId" class="dcrupload">
			<div class="col"><a href="javascript:deleteJobsitePhoto('$elementId', '$attrId', '$jobsite_photo_id');" class="bs-tooltip  entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;&nbsp;&nbsp;
			<a href="$fileUrl" target="_blank"><img src="$base64" class="DCR-image-height" width='300' ></a></div>
			<div class="col"><div><a href="$fileUrl" target="_blank">$virtual_file_name</a></div>
			<div><textarea cols="80" rows='3' onblur="updatecaptionforimage(this.id,'$jobsite_photo_file_manager_file_id','$jobsite_photo_id')" id="jobimg_$jobsite_photo_file_manager_file_id-$jobsite_photo_id">$captiondata</textarea></div></div>
		</li>

END_HTML_CONTENT;
		}
		else
		{
			$htmlRecord = <<<END_HTML_CONTENT
			<li id="$elementId">
			<a href="javascript:deleteJobsitePhoto('$elementId', '$attrId', '$jobsite_photo_id');" class="bs-tooltip  entypo-cancel-circled" data-original-title="Delete this attachment"></a>
			<a href="$fileUrl" target="_blank">$virtual_file_name</a>
			</li>

END_HTML_CONTENT;
		}

	}

	return $htmlRecord;
}
function resizeImage($SrcImage,$DestImage, $thumb_width,$thumb_height,$Quality)
{
    list($width,$height,$type) = getimagesize($SrcImage);
    switch(strtolower(image_type_to_mime_type($type)))
    {
        case 'image/gif':
            $NewImage = imagecreatefromgif($SrcImage);
            break;
        case 'image/png':
            $NewImage = imagecreatefrompng($SrcImage);
            break;
        case 'image/jpeg':
            $NewImage = imagecreatefromjpeg($SrcImage);
            break;
        default:
            return false;
            break;
    }
    $original_aspect = $width / $height;
    $positionwidth = 0;
    $positionheight = 0;
    if($original_aspect > 1)    {
        $new_width = $thumb_width;
        $new_height = $new_width/$original_aspect;
        while($new_height > $thumb_height) {
            $new_height = $new_height - 0.001111;
            $new_width  = $new_height * $original_aspect;
            while($new_width > $thumb_width) {
                $new_width = $new_width - 0.001111;
                $new_height = $new_width/$original_aspect;
            }

        }
    } else {
        $new_height = $thumb_height;
        $new_width = $new_height/$original_aspect;
        while($new_width > $thumb_width) {
            $new_width = $new_width - 0.001111;
            $new_height = $new_width/$original_aspect;
            while($new_height > $thumb_height) {
                $new_height = $new_height - 0.001111;
                $new_width  = $new_height * $original_aspect;
            }
        }
    }
    if($width < $new_width && $height < $new_height){
        $new_width = $width;
        $new_height = $height;
        $positionwidth = ($thumb_width - $new_width) / 2;
        $positionheight = ($thumb_height - $new_height) / 2;
    }elseif($width < $new_width && $height > $new_height){
        $new_width = $width;
        $positionwidth = ($thumb_width - $new_width) / 2;
        $positionheight = 0;
    }elseif($width > $new_width && $height < $new_height){
        $new_height = $height;
        $positionwidth = 0;
        $positionheight = ($thumb_height - $new_height) / 2;
    } elseif($width > $new_width && $height > $new_height){
        if($new_width < $thumb_width) {
            $positionwidth = ($thumb_width - $new_width) / 2;
        } elseif($new_height < $thumb_height) {
            $positionheight = ($thumb_height - $new_height) / 2;
        }
    }
    /*custome change for remove the back black */
    $thumb = imagecreatetruecolor( $new_width, $new_height );

    /********************* FOR WHITE BACKGROUND  *************************/
        
    if(imagecopyresampled($thumb, $NewImage, 0, 0,0, 0, $new_width, $new_height, $width, $height)) {
        if(imagejpeg($thumb,$DestImage,$Quality)) {
            imagedestroy($thumb);
            return true;
        }
    }
}
function resize($source,$destination,$newWidth,$newHeight)
{
    ini_set('max_execution_time', 0);
    $ImagesDirectory = $source;
    $DestImagesDirectory = $destination;
    $NewImageWidth = $newWidth;
    $NewImageHeight = $newHeight;
    $Quality = 100;
    $imagePath = $ImagesDirectory;
    $destPath = $DestImagesDirectory;
    $checkValidImage = getimagesize($imagePath);
    if(file_exists($imagePath) && $checkValidImage)
    {
        if(resizeImage($imagePath,$destPath,$NewImageWidth,$NewImageHeight,$Quality))
            return 'resize success';
        else
            return 'resize failes';
    }
}

//To get the updated contact and person
function UpdateModifiedContentsData($database, $project_id,$jobsite_daily_log_id,$calc_date)
{
	
	$jobsite_daily_log_created_date = $calc_date;

	$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $jobsite_daily_log_created_date);
			/* @var $jobsiteDailyLog JobsiteDailyLog */

	if ($jobsiteDailyLog) {
		$jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
		$created_by_contact_id = $jobsiteDailyLog->created_by_contact_id;
	} else {
		if($currentlyActiveContactId && $project_id && $jobsite_daily_log_created_date){
			$created_by_contact_id = $currentlyActiveContactId;
			$jobsiteDailyLog = new JobsiteDailyLog($database);
			$jobsiteDailyLog->project_id = $project_id;
			$jobsiteDailyLog->jobsite_daily_log_created_date = $jobsite_daily_log_created_date;
			$jobsiteDailyLog->created_by_contact_id = $created_by_contact_id;
			$jobsiteDailyLog->convertPropertiesToData();
			$jobsite_daily_log_id = $jobsiteDailyLog->save();
	 	}
	}
	if($created_by_contact_id){
		$createdByContact = Contact::findById($database, $created_by_contact_id);
		/* @var $createdByContact Contact */
		$createdByContactFullNameHtmlEscaped = $createdByContact->getContactFullNameHtmlEscaped();
	}

	$modified_by_contact_id = $jobsiteDailyLog->modified_by_contact_id;
	if (isset($modified_by_contact_id) && !empty($modified_by_contact_id)) {
		$modifiedByContact = Contact::findById($database, $modified_by_contact_id);
		/* @var $modifiedByContact Contact */
		$modifiedBy = $modifiedByContact->getContactFullName();
	} else {
		$modifiedBy = '';
	}

	$jobsite_daily_log_created_date = $jobsiteDailyLog->jobsite_daily_log_created_date;
	$createdHumanReadable = strtotime($jobsite_daily_log_created_date);
	$createdAt = date('F j, Y', $createdHumanReadable);

	$modified = $jobsiteDailyLog->modified;
	if ($modified) {
		$modifiedHumanReadable = strtotime($modified);
		$modifiedAt = date('F j, Y g:ia', $modifiedHumanReadable);
	} else {
		$modifiedAt = '';
	}
	$modifiedAt = $modifiedBy ? $modifiedAt : '';
	$resData=array("created_by"=>$createdByContactFullNameHtmlEscaped,"created_on"=>$createdAt,"modified_by"=>$modifiedBy,"modified_on"=>$modifiedAt);
	return $resData;
}
