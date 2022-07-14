<?php
$RN_jsonEC['message'] = null;
// $RN_jsonEC['data'] = null;
$RN_jobsite_daily_log_id = $RN_params['jobsite_daily_log_id'];
if($RN_jobsite_daily_log_id == null && $RN_jobsite_daily_log_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite daily log id is Required";
}
else{
	$RN_jobsiteDailyLog = JobsiteDailyLog::findJobsiteDailyLogByIdExtended($database, $RN_jobsite_daily_log_id);

	$RN_uri = Zend_Registry::get('uri');
	/* @var $RN_uri Uri */

	$RN_jobsite_daily_log_id = $RN_jobsiteDailyLog->jobsite_daily_log_id;
	$RN_project_id = $RN_jobsiteDailyLog->project_id;
	$RN_modified_by_contact_id = $RN_jobsiteDailyLog->modified_by_contact_id;
	$RN_created_by_contact_id = $RN_jobsiteDailyLog->created_by_contact_id;
	$RN_jobsite_daily_log_created_date = $RN_jobsiteDailyLog->jobsite_daily_log_created_date;

	$RN_project = $RN_jobsiteDailyLog->getProject();
	/* @var $RN_project Project */

	$RN_user_company_id = $RN_project->user_company_id;

	// Project info.
	$RN_project_name = $RN_project->project_name;

	$RN_project->htmlEntityEscapeProperties();
	$RN_escaped_project_name = $RN_project->escaped_project_name;
	$RN_project_escaped_address_line_1 = $RN_project->escaped_address_line_1;
	$RN_project_escaped_address_city = ($RN_project->escaped_address_city)?$RN_project->escaped_address_city.', ':'';
	$RN_project_escaped_address_state_or_region = $RN_project->escaped_address_state_or_region;
	$RN_project_escaped_address_postal_code = $RN_project->escaped_address_postal_code;

	// Photo.
	$RN_loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput = new Input();
	$RN_loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput->forceLoadFlag = true;
	$RN_jobsitePhotos = JobsitePhoto::loadMostRecentJobsitePhotoByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput);
	/* @var $RN_jobsitePhoto JobsitePhoto */

	$RN_count = count($RN_jobsitePhotos);
	$RN_attain = 0;
	$RN_jsonEC['data']['tabs'][5]['attachments'] = null;
	foreach($RN_jobsitePhotos as $RN_jobsite_photo_id => $RN_jobsitePhoto){
		if ($RN_jobsitePhoto) {

			$RN_jobsitePhotoFileManagerFile = $RN_jobsitePhoto->getJobsitePhotoFileManagerFile();
			/* @var $RN_jobsitePhotoFileManagerFile FileManagerFile */

			$RN_jobsitePhotoCreated = $RN_jobsitePhotoFileManagerFile->created;
			$RN_jobsitePhotoCreatedUnixTimestamp = strtotime($RN_jobsitePhotoCreated);
			$RN_jobsitePhotoCreatedHtml = 'Photo uploaded ' . date('M d, Y g:ia', $RN_jobsitePhotoCreatedUnixTimestamp);
			/*custome url change for imagick*/
			$RN_jobsitePhotoUrl = $RN_jobsitePhotoFileManagerFile->generateUrl();
			if ($RN_PDFOrHTML) {
			// @todo Put key into a config directive
			}
			$RN_virtual_file_mime_type = $RN_jobsitePhotoFileManagerFile->virtual_file_mime_type;
			if ($RN_virtual_file_mime_type == 'application/pdf') {
				$RN_jobsitePhotoHtml = '<embed src='.$RN_jobsitePhotoUrl.' width="100%" height="100%">';
			} else {
				list($RN_imageWidth, $RN_imageHeight) = PdfTools::renderDomPDFSaveImageSize($RN_jobsitePhotoUrl);
				$RN_file_name = $RN_jobsitePhotoFileManagerFile->file_location_id;
				$RN_file_location_id = Data::parseInt($RN_jobsitePhotoFileManagerFile->file_location_id);
				$RN_arrPath = str_split($RN_file_location_id, 2);
				$RN_fileName = array_pop($RN_arrPath);
				$RN_shortFilePath = '';
				foreach ($RN_arrPath as $RN_pathChunk) {
					$RN_path .= $RN_pathChunk.'/';
					$RN_shortFilePath .= $RN_pathChunk.'/';
				}
				$RN_config = Zend_Registry::get('config');
				$RN_file_manager_file_name_prefix = $RN_config->system->file_manager_file_name_prefix;
				$RN_basedircs = $RN_config->system->file_manager_base_path;
				$RN_basepathcs = $RN_config->system->file_manager_backend_storage_path ;
				$RN_filename=$RN_basedircs.$RN_basepathcs.$RN_shortFilePath.$RN_file_manager_file_name_prefix.$RN_fileName;
				$RN_pdfPhantomJS = new PdfPhantomJS();
				$RN_target = $RN_pdfTempFileUrl = $RN_pdfPhantomJS->getTempFileBasePath();
				$RN_file = $RN_jobsitePhotoUrl;
				/*Resize image start*/
				$RN_jobsitePhotoUrlsize = $RN_filename;
				$RN_path= realpath($RN_jobsitePhotoUrlsize);
				$RN_destination = $RN_target.'_temp'.round(microtime(true)*1000);
             // Change the desired "WIDTH" and "HEIGHT"
            $RN_newWidth = 800; // Desired WIDTH
            $RN_newHeight = 800; // Desired HEIGHT
            $RN_info   = getimagesize($RN_path);
        	$RN_mime   = $RN_info['mime']; // mime-type as string for ex. "image/jpeg" etc.
        	$RN_width  = $RN_info[0]; // width as integer for ex. 512
        	$RN_height = $RN_info[1]; // height as integer for ex. 384
        	$RN_type   = $RN_info[2];      // same as exif_imagetype
        	// if(intval($RN_width) > 800 || intval($RN_height) > 800){
        	resize($RN_path,$RN_destination,$RN_newWidth,$RN_newHeight);
        	$RN_data = file_get_contents($RN_destination);
        	$RN_base64 = 'data:image;base64,' . base64_encode($RN_data);	
        	$RN_jobsitePhotoHtml = '<img alt="Jobsite Photo" src="'.$RN_base64.'">';
        	unlink($RN_destination);
        // 	}else{
        // 		$RN_file_manager_file_id = $RN_jobsitePhotoFileManagerFile->file_manager_file_id;
 			    // //To get base path
        // 		$RN_fileManagerFile = FileManagerFile::findById($database, $RN_file_manager_file_id);
        // 		$RN_cdnFileUrl = $RN_fileManagerFile->generateUrlBasePath(true);
        // 		$RN_jobsitePhotoUrl = $RN_jobsitePhotoFileManagerFile->generateUrlBasePath();
        //       	//End to get base path
        // 		$RN_path= realpath($RN_jobsitePhotoUrl);
        // 		$RN_data = file_get_contents($RN_jobsitePhotoUrl);
        // 		$RN_base64 = 'data:image;base64,' . base64_encode($RN_data);
        // 		$RN_jobsitePhotoHtml = '<img alt="Jobsite Photo" src="'.$RN_base64.'">';

        // 	}	
        }
        $RN_jsonEC['data']['tabs'][5]['attachments'][$RN_attain]['image'] = $RN_base64;
        $RN_jsonEC['data']['tabs'][5]['attachments'][$RN_attain]['name'] = $RN_jobsitePhotoCreatedHtml;
        
        $RN_attain++;
        $RN_jobsitePhotoHtmlContents.= <<<END_HTML_CONTENT
        <tr style="margin-bottom:10px 0;">
        <td style="padding: 0;" class="dcrPreviewImagecenter">
        <section style="margin: 10px 0;" class="dcrPreviewTableHeader">$RN_jobsitePhotoCreatedHtml</section>
        $RN_jobsitePhotoHtml</td>
        </tr>
END_HTML_CONTENT;

    } else {
    	$RN_jobsitePhotoCreatedHtml = 'PHOTO';
    	$RN_jobsitePhotoUrl = '';

    	$RN_jobsitePhotoHtmlContents = '';
    }
}
if($RN_jobsitePhotoHtmlContents!='')
{
	if($RN_count > 0){
		$RN_counthead="<h4>Attached Photos($RN_count)</h4>";
		$RN_jsonEC['data']['tabs'][5]['attachments']['header'] = 'Attached Photos '.($RN_count);
	}else{
		$RN_counthead='';
		$RN_jsonEC['data']['tabs'][5]['attachments']['header'] = null;
	}
}else{
	$RN_jobsitePhotoHtmlContent='';
}

	// Debug to test performance of Dompdf without image rendering portion
$RN_jdlCreatedUnixTimestamp = strtotime($RN_jobsite_daily_log_created_date);
$RN_jdlCreatedDate = date('F j, Y', $RN_jdlCreatedUnixTimestamp);
	$RN_dayOfWeek = date('N', $RN_jdlCreatedUnixTimestamp);  // This format returns 1 for Monday, 2 for Tuesday, etc.

	// Weather info.
	$RN_amTemperature = '';
	$RN_amCondition = '';
	$RN_pmTemperature = '';
	$RN_pmCondition = '';


	// Manpower - today.
	$RN_manpowerActivityToday = 0;
	$RN_loadJobsiteManPowerByJobsiteDailyLogIdOptions = new Input();
	$RN_loadJobsiteManPowerByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$RN_arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteManPowerByJobsiteDailyLogIdOptions);
	$RN_arrJobsiteManPowerByJobsiteDailyLogId = $RN_arrReturn['objects'];
	$RN_arrJobsiteManPowerBySubcontractId = $RN_arrReturn['jobsite_man_power_by_subcontract_id'];

	foreach ($RN_arrJobsiteManPowerByJobsiteDailyLogId as $RN_tmpJobsiteManPower) {
		/* @var $RN_tmpJobsiteManPower JobsiteManPower */
		$RN_number_of_people = $RN_tmpJobsiteManPower->number_of_people;
		$RN_manpowerActivityToday = $RN_manpowerActivityToday + $RN_number_of_people;
	}

	$RN_manpowerActivitySummaryByTrade = '';
	$RN_loadSubcontractsByProjectIdInput = new Input();
	$RN_loadSubcontractsByProjectIdInput->forceLoadFlag = true;
	$RN_arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $RN_project_id, $RN_loadSubcontractsByProjectIdInput);
	$RN_inTr = 0;
	$RN_loopInTr = 0;
	$RN_jsonEC['data']['tabs'][5]['manpower_data'] = null;
	foreach ($RN_arrSubcontractsByProjectId as $RN_subcontract_id => $RN_subcontract) {
		/* @var $RN_subcontract Subcontract */

		$RN_gcBudgetLineItem = $RN_subcontract->getGcBudgetLineItem();
		/* @var $RN_gcBudgetLineItem GcBudgetLineItem */

		$RN_costCode = $RN_gcBudgetLineItem->getCostCode();
		/* @var $RN_costCode CostCode */

		$RN_costCodeDivision = $RN_costCode->getCostCodeDivision();
		/* @var $RN_costCodeDivision CostCodeDivision */

		$RN_costCode->htmlEntityEscapeProperties();
		$RN_costCodeDivision->htmlEntityEscapeProperties();
		$RN_htmlEntityEscapedFormattedCostCode = $RN_costCodeDivision->escaped_division_number . '-' . $RN_costCode->escaped_cost_code;

		$RN_vendor = $RN_subcontract->getVendor();
		/* @var $RN_vendor Vendor */

		$RN_vendor_id = $RN_vendor->vendor_id;

		$RN_contactCompany = $RN_vendor->getVendorContactCompany();
		/* @var $RN_contactCompany ContactCompany */

		$RN_contactCompany->htmlEntityEscapeProperties();
		$RN_escaped_contact_company_name = $RN_contactCompany->escaped_contact_company_name;

		$RN_number_of_people = 0;
		if (isset($RN_arrJobsiteManPowerBySubcontractId[$RN_subcontract_id])) {

			$RN_tmpJobsiteManPower = $RN_arrJobsiteManPowerBySubcontractId[$RN_subcontract_id];
			/* @var $RN_tmpJobsiteManPower JobsiteManPower */

			$RN_number_of_people = $RN_tmpJobsiteManPower->number_of_people;
			if($RN_inTr != 0){
				$RN_trClose="</tr>";
				$RN_trOpen="<tr><td></td>";
			}else{
				$RN_trClose="</tr>";
				$RN_trOpen='<td class="thHeadtd">TODAY&nbsp;</td>';
			}
			
			$RN_jsonEC['data']['tabs'][5]['manpower_data']['today'][$RN_inTr]['company'] = $RN_escaped_contact_company_name.' '.$RN_htmlEntityEscapedFormattedCostCode;
			$RN_jsonEC['data']['tabs'][5]['manpower_data']['today'][$RN_inTr]['on_site'] = $RN_number_of_people;
			$RN_inTr++;
		}
		$RN_loopInTr++;	
	}
	if($RN_manpowerActivitySummaryByTrade == '' || $RN_loopInTr== 0){
		if($RN_inTr != 0){
			$RN_trClose="</tr>";
			$RN_trOpen="<tr><td></td>";
		}else{
			$RN_trClose="</tr>";
			$RN_trOpen='<td class="thHeadtd">TODAY&nbsp;</td>';
		}
		$RN_inTr++;
	}

	// Manpower - this week.
	$RN_manpowerActivityThisWeek = 0;
	$RN_format = 'Y-m-d';
	$RN_interval = 0;
	$RN_loadJobsiteManPowerByJobsiteDailyLogIdOptions = new Input();
	$RN_loadJobsiteManPowerByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$RN_tmpDayOfWeek = $RN_dayOfWeek;
	while ($RN_tmpDayOfWeek > 0) {
		$RN_tmp_jobsite_daily_log_created_date = date($RN_format, $RN_jdlCreatedUnixTimestamp - $RN_interval);

		$RN_tmpJobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $RN_project_id, $RN_tmp_jobsite_daily_log_created_date);
		/* @var $RN_tmpJobsiteDailyLog JobsiteDailyLog */

		if ($RN_tmpJobsiteDailyLog) {
			$RN_temp_jobsite_daily_log_id = $RN_tmpJobsiteDailyLog->jobsite_daily_log_id;
			$RN_arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $RN_temp_jobsite_daily_log_id, $RN_loadJobsiteManPowerByJobsiteDailyLogIdOptions);
			$RN_arrJobsiteManPowerByJobsiteDailyLogId = $RN_arrReturn['objects'];
			foreach ($RN_arrJobsiteManPowerByJobsiteDailyLogId as $RN_tmpJobsiteManPower) {
				/* @var $RN_tmpJobsiteManPower JobsiteManPower */
				$RN_number_of_people = $RN_tmpJobsiteManPower->number_of_people;
				$RN_manpowerActivityThisWeek = $RN_manpowerActivityThisWeek + $RN_number_of_people;
			}
		}

		$RN_interval = $RN_interval + 86400;
		$RN_tmpDayOfWeek--;
	}
	$RN_jsonEC['data']['tabs'][5]['manpower_data']['today'] = $RN_manpowerActivityToday;
	$RN_jsonEC['data']['tabs'][5]['manpower_data']['this_week'] = $RN_manpowerActivityThisWeek;
	
	// Inspections - today.
	$RN_loadJobsiteInspectionsByJobsiteDailyLogIdOptions = new Input();
	$RN_loadJobsiteInspectionsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$RN_arrJobsiteInspectionsByJobsiteDailyLogId = JobsiteInspection::loadJobsiteInspectionsByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteInspectionsByJobsiteDailyLogIdOptions);
	$RN_numInspectionsToday = count($RN_arrJobsiteInspectionsByJobsiteDailyLogId);

	// Inspections - this week.
	$RN_numInspectionsThisWeek = 0;
	$RN_format = 'Y-m-d';
	$RN_interval = 0;
	$RN_loadJobsiteInspectionsByJobsiteDailyLogIdOptions = new Input();
	$RN_loadJobsiteInspectionsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$RN_tmpDayOfWeek = $RN_dayOfWeek;
	while ($RN_tmpDayOfWeek > 0) {
		$RN_tmp_jobsite_daily_log_created_date = date($RN_format, $RN_jdlCreatedUnixTimestamp - $RN_interval);

		$RN_tmpJobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $RN_project_id, $RN_tmp_jobsite_daily_log_created_date);
		/* @var $RN_tmpJobsiteDailyLog JobsiteDailyLog */

		if ($RN_tmpJobsiteDailyLog) {
			$RN_temp_jobsite_daily_log_id = $RN_tmpJobsiteDailyLog->jobsite_daily_log_id;
			$RN_arrJobsiteInspectionsByJobsiteDailyLogId = JobsiteInspection::loadJobsiteInspectionsByJobsiteDailyLogId($database, $RN_temp_jobsite_daily_log_id, $RN_loadJobsiteInspectionsByJobsiteDailyLogIdOptions);
			$RN_numInspectionsThisWeek = $RN_numInspectionsThisWeek + count($RN_arrJobsiteInspectionsByJobsiteDailyLogId);
		}
		$RN_interval = $RN_interval + 86400;
		$RN_tmpDayOfWeek--;
	}
	$RN_jsonEC['data']['tabs'][5]['inspection_data']['title'] = 'Inspections';
	$RN_jsonEC['data']['tabs'][5]['inspection_data']['today'] = $RN_numInspectionsToday;
	$RN_jsonEC['data']['tabs'][5]['inspection_data']['this_week'] = $RN_numInspectionsThisWeek;
	// RFIs.
	$RN_loadRequestsForInformationByProjectIdOptions = new Input();
	$RN_loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
	$RN_arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByProjectId($database, $RN_project_id, $RN_loadRequestsForInformationByProjectIdOptions);
	$RN_tableRequestsForInformationTbody = '';
	$RN_jsonEC['data']['tabs'][5]['rfi_data'] = null;
	foreach ($RN_arrRequestsForInformation as $RN_request_for_information_id => $RN_requestForInformation) {
		/* @var $RN_requestForInformation RequestForInformation */

		$RN_requestForInformation->htmlEntityEscapeProperties();

		$RN_requestForInformationStatus = $RN_requestForInformation->getRequestForInformationStatus();
		$RN_request_for_information_status = $RN_requestForInformationStatus->request_for_information_status;
		if ($RN_request_for_information_status == 'Open') {
			$RN_rfi_sequence_number = $RN_requestForInformation->rfi_sequence_number;
			$RN_escaped_rfi_title = $RN_requestForInformation->escaped_rfi_title;
			$RN_rfi_created_timestamp = $RN_requestForInformation->created;

			$RN_rfiCreatedUnixTimestamp = strtotime($RN_rfi_created_timestamp);
			$RN_nowUnixTimestamp = strtotime(date('Y-m-d', $RN_jdlCreatedUnixTimestamp));

			$RN_difference = $RN_nowUnixTimestamp - $RN_rfiCreatedUnixTimestamp;
			$RN_daysOpen = ceil($RN_difference / 86400);

			$RN_jsonEC['data']['tabs'][5]['rfi_data']['sequence_number'] = $RN_rfi_sequence_number;
			$RN_jsonEC['data']['tabs'][5]['rfi_data']['rfi_title'] = $RN_escaped_rfi_title;
			$RN_jsonEC['data']['tabs'][5]['rfi_data']['days_open'] = $RN_daysOpen;
		}

	}
	if (count($RN_arrRequestsForInformation) == 0) {
		$RN_tableRequestsForInformationTbody = '<tr><td colspan="3" class="textAlignCenter">No Data Found.</td></tr>';
	}

	// Notes.
	$RN_loadJobsiteNotesByJobsiteDailyLogIdOptions = new Input();
	$RN_loadJobsiteNotesByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$RN_arrJobsiteNotesByJobsiteDailyLogId = JobsiteNote::loadJobsiteNotesByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteNotesByJobsiteDailyLogIdOptions);
	$RN_tableJobsiteNotesTbody = '';
	$RN_jsonEC['data']['tabs'][5]['notes_data'] = null;
	$RN_notesin = 0;
	foreach ($RN_arrJobsiteNotesByJobsiteDailyLogId as $RN_jobsite_note_id => $RN_jobsiteNote) {
		/* @var $RN_jobsiteNote JobsiteNote */

		$RN_jobsite_note_type_id = $RN_jobsiteNote->jobsite_note_type_id;
		$RN_jobsite_note = $RN_jobsiteNote->jobsite_note;

		$RN_jobsiteNote->htmlEntityEscapeProperties();
		$RN_escaped_jobsite_note = $RN_jobsiteNote->escaped_jobsite_note;
		$RN_escaped_jobsite_note_nl2br = $RN_jobsiteNote->escaped_jobsite_note_nl2br;

		$RN_jobsiteNoteType = JobsiteNoteType::findById($database, $RN_jobsite_note_type_id);
		/* @var $RN_jobsiteNoteType JobsiteNoteType */

		$RN_jobsite_note_type_label = $RN_jobsiteNoteType->jobsite_note_type_label;

		$RN_jobsiteNoteType->htmlEntityEscapeProperties();
		$RN_escaped_jobsite_note_type_label = $RN_jobsiteNoteType->escaped_jobsite_note_type_label;

		$RN_jsonEC['data']['tabs'][5]['notes_data'][$RN_notesin]['jobsite_note_type_label'] = $RN_escaped_jobsite_note_type_label;
		$RN_jsonEC['data']['tabs'][5]['notes_data'][$RN_notesin]['jobsite_note'] = $RN_escaped_jobsite_note_nl2br;
		$RN_notesin++;
	}

	// SCHEDULE DELAYS.
	// jobsite_delays
	$RN_loadJobsiteDelaysByJobsiteDailyLogIdOptions = new Input();
	$RN_loadJobsiteDelaysByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$RN_arrJobsiteDelays = JobsiteDelay::loadJobsiteDelaysByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteDelaysByJobsiteDailyLogIdOptions);
	$RN_tableJobsiteScheduleDelaysTbody = '';
	$RN_jsonEC['data']['tabs'][5]['delay_data'] = null;
	$RN_delayin = 0;
	foreach ($RN_arrJobsiteDelays as $RN_jobsiteDelay) {
		/* @var $RN_jobsiteDelay JobsiteDelay */

		$RN_jobsite_delay_id = $RN_jobsiteDelay->jobsite_delay_id;

		$RN_elementId = "record_container--manage-jobsite_delay-record--jobsite_delays--$RN_jobsite_delay_id";

		$RN_jobsite_delay_category = 'Miscellaneous';
		$RN_jobsite_delay_subcategory = 'Miscellaneous';

		$RN_jobsiteDelayCategory = $RN_jobsiteDelay->getJobsiteDelayCategory();
		/* @var $RN_jobsiteDelayCategory JobsiteDelayCategory */

		if ($RN_jobsiteDelayCategory) {
			$RN_jobsiteDelayCategory->htmlEntityEscapeProperties();
			$RN_jobsite_delay_category = $RN_jobsiteDelayCategory->jobsite_delay_category;
			$RN_escaped_jobsite_delay_category = $RN_jobsiteDelayCategory->escaped_jobsite_delay_category;
		}

		$RN_jobsiteDelaySubcategory = $RN_jobsiteDelay->getJobsiteDelaySubcategory();
		/* @var $RN_jobsiteDelaySubcategory JobsiteDelaySubcategory */

		if ($RN_jobsiteDelaySubcategory) {
			$RN_jobsiteDelaySubcategory->htmlEntityEscapeProperties();

			$RN_jobsite_delay_subcategory = $RN_jobsiteDelaySubcategory->jobsite_delay_subcategory;
			$RN_escaped_jobsite_delay_subcategory = $RN_jobsiteDelaySubcategory->escaped_jobsite_delay_subcategory;
		}

		$RN_jobsiteDelayNote = $RN_jobsiteDelay->getJobsiteDelayNote();
		/* @var $RN_jobsiteDelayNote JobsiteDelayNote */

		if ($RN_jobsiteDelayNote && ($RN_jobsiteDelayNote instanceof JobsiteDelayNote)) {
			$RN_jobsiteDelayNote->htmlEntityEscapeProperties();

			$RN_escaped_jobsite_delay_note_nl2br = $RN_jobsiteDelayNote->escaped_jobsite_delay_note_nl2br;
		} else {
			$RN_escaped_jobsite_delay_note_nl2br = '';
		}

		$RN_jsonEC['data']['tabs'][5]['delay_data'][$RN_delayin]['jobsite_delay_category'] = $RN_escaped_jobsite_delay_category.' - '.$RN_escaped_jobsite_delay_subcategory;
		$RN_jsonEC['data']['tabs'][5]['delay_data'][$RN_delayin]['jobsite_delay_note'] = $RN_escaped_jobsite_delay_note_nl2br;
		$RN_delayin++;
	}

	// Sitework Activities.
	$RN_loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions = new Input();
	$RN_loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$RN_arrReturn = JobsiteDailySiteworkActivityLog::loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions);
	$RN_arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId = $RN_arrReturn['objects'];
	$RN_tableJobsiteSiteworkActivitiesTbody = '';
	$RN_jsonEC['data']['tabs'][5]['sitework_data'] = null;
	$RN_stin = 0;
	foreach ($RN_arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId as $RN_jobsite_daily_sitework_activity_log_id => $RN_jobsiteDailySiteworkActivityLog) {
		/* @var $RN_jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */

		$RN_jobsite_sitework_region_id = $RN_jobsiteDailySiteworkActivityLog->jobsite_sitework_region_id;
		$RN_jobsiteSiteworkRegion = JobsiteSiteworkRegion::findById($database, $RN_jobsite_sitework_region_id);
		/* @var $RN_jobsiteSiteworkRegion JobsiteSiteworkRegion */

		$RN_jobsiteSiteworkRegion->htmlEntityEscapeProperties();

		$RN_jobsite_sitework_region = $RN_jobsiteSiteworkRegion->jobsite_sitework_region;
		$RN_escaped_jobsite_sitework_region = $RN_jobsiteSiteworkRegion->escaped_jobsite_sitework_region;

		$RN_jobsite_sitework_activity_id = $RN_jobsiteDailySiteworkActivityLog->jobsite_sitework_activity_id;
		$RN_jobsiteSiteworkActivity = JobsiteSiteworkActivity::findById($database, $RN_jobsite_sitework_activity_id);
		/* @var $RN_jobsiteSiteworkActivity JobsiteSiteworkActivity */

		$RN_jobsiteSiteworkActivity->htmlEntityEscapeProperties();

		$RN_jobsite_sitework_activity_label = $RN_jobsiteSiteworkActivity->jobsite_sitework_activity_label;
		$RN_escaped_jobsite_sitework_activity_label = $RN_jobsiteSiteworkActivity->jobsite_sitework_activity_label;

		$RN_jsonEC['data']['tabs'][5]['sitework_data'][$RN_stin] = $RN_escaped_jobsite_sitework_activity_label;
		$RN_stin++;

	}

	// Building Activities.
	$RN_loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions = new Input();
	$RN_loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
	$RN_arrReturn = JobsiteDailyBuildingActivityLog::loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions);
	$RN_arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId = $RN_arrReturn['objects'];
	$RN_tableJobsiteBuildingActivitiesTbody = '';
	$RN_jsonEC['data']['tabs'][5]['building_data'] = null;
	$RN_btin = 0;
	foreach ($RN_arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId as $RN_jobsite_daily_building_activity_log_id => $RN_jobsiteDailyBuildingActivityLog) {
		/* @var $RN_jobsiteDailyBuildingActivityLog JobsiteDailyBuildingActivityLog */

		$RN_jobsite_building_id = $RN_jobsiteDailyBuildingActivityLog->jobsite_building_id;
		$RN_jobsiteBuilding = JobsiteBuilding::findById($database, $RN_jobsite_building_id);
		/* @var $RN_jobsiteBuilding JobsiteBuilding */

		// $RN_jobsiteBuilding->htmlEntityEscapeProperties();

		$RN_jobsite_building = $RN_jobsiteBuilding->jobsite_building;
		$RN_escaped_jobsite_building = $RN_jobsiteBuilding->escaped_jobsite_building;

		$RN_jobsite_building_activity_id = $RN_jobsiteDailyBuildingActivityLog->jobsite_building_activity_id;
		$RN_jobsiteBuildingActivity = JobsiteBuildingActivity::findById($database, $RN_jobsite_building_activity_id);
		/* @var $RN_jobsiteBuildingActivity JobsiteBuildingActivity */

		$RN_jobsiteBuildingActivity->htmlEntityEscapeProperties();

		$RN_jobsite_building_activity_label = $RN_jobsiteBuildingActivity->jobsite_building_activity_label;
		$RN_escaped_jobsite_building_activity_label = $RN_jobsiteBuildingActivity->escaped_jobsite_building_activity_label;

		$RN_jsonEC['data']['tabs'][5]['building_data'][$RN_btin] = $RN_escaped_jobsite_building_activity_label;
		$RN_btin++;

	}

	// Weather.
	/* @var $RN_jobsiteDailyLog JobsiteDailyLog */
	$RN_jsonEC['data']['tabs'][5]['project_detail'] = null;
	$RN_arrReturn = getAmPmWeatherTemperaturesAndConditions($database, $RN_project_id, $RN_jobsite_daily_log_created_date);
	$RN_amTemperature = $RN_arrReturn['amTemperature'];
	$RN_amCondition   = $RN_arrReturn['amCondition'];
	$RN_pmTemperature = $RN_arrReturn['pmTemperature'];
	$RN_pmCondition   = $RN_arrReturn['pmCondition'];

	$RN_jsonEC['data']['tabs'][5]['project_detail']['am_temp'] = null;
	$RN_jsonEC['data']['tabs'][5]['project_detail']['pm_temp'] = null;
	$RN_jsonEC['data']['tabs'][5]['project_detail']['am_temp'] = null;
	$RN_jsonEC['data']['tabs'][5]['project_detail']['pm_temp'] = null;
	

	// <!--td width="35%">SITEWORK REGION</td-->
	// <!--td>BUILDING</td-->
	/*GC logo*/
	require_once('lib/common/Logo.php');
	$RN_gcLogo = Logo::logoByUserCompanyIDUsingSoftlink($database,$RN_user_company_id);
	$RN_fulcrum = Logo::logoByFulcrumByBasePathOnlyLink(true);

	$RN_jsonEC['data']['tabs'][5]['project_detail']['fulcrum_image'] = $RN_fulcrum;
	$RN_jsonEC['data']['tabs'][5]['project_detail']['gc_image'] = $RN_gcLogo;
	$RN_jsonEC['data']['tabs'][5]['project_detail']['date'] = $RN_jdlCreatedDate;
	$RN_jsonEC['data']['tabs'][5]['project_detail']['address'] = $RN_project_escaped_address_line_1.' '.$RN_project_escaped_address_city.' '.$RN_project_escaped_address_state_or_region.' '.$RN_project_escaped_address_postal_code;

}
?>
