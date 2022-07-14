<?php
$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;

require_once('lib/common/init.php');
require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/Log.php');
require_once('lib/common/Mail.php');
require_once('lib/common/MessageGateway/Sms.php');
require_once('lib/common/MobileNetworkCarrier.php');
require_once('lib/common/MobilePhoneNumber.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/ProjectToWeatherUndergroundReportingStation.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/RequestForInformation.php');
require_once('lib/common/RequestForInformationAttachment.php');
require_once('lib/common/RequestForInformationDraft.php');
require_once('lib/common/RequestForInformationDraftAttachment.php');
require_once('lib/common/RequestForInformationNotification.php');
require_once('lib/common/RequestForInformationPriority.php');
require_once('lib/common/RequestForInformationRecipient.php');
require_once('lib/common/RequestForInformationResponse.php');
require_once('lib/common/RequestForInformationResponseType.php');
require_once('lib/common/RequestForInformationStatus.php');
require_once('lib/common/RequestForInformationType.php');

require_once('page-components/dropDownListWidgets.php');
require_once('page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('lib/common/Service/UniversalService.php');
$project_id = $session->getCurrentlySelectedProjectId();

if(isset($_POST['Method']) && ($_POST['Method']=='loadDelay'))
{
    $userCanManageDelays=$_POST['ManageDelays'];
	$delayTable = renderDelayListView_AsHtml($database,$project_id,$userCanManageDelays);
	echo $delayTable;
}

/**
* Display the Delay Grid
* @param project id
* @return html
*/
function renderDelayListView_AsHtml($database, $projectId,$managePermission)
{	
	$delayTableTbody = '';
	$incre_id=1;
	$db = DBI::getInstance($database);
	$query = "SELECT * FROM jobsite_delay_data where is_deleted = '0' and project_id='".$projectId."'";
	$db->execute($query);
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}
	foreach($records as $row)
	{
		$delid      = $row['id'];
		$source 	= $row['source'];
		$type   	= $row['type'];
		$scategory 	= $row['subcategory'];
		$bdate  	= $row['begindate'];
		$edate 	 	= $row['enddate'];
		$days   	= $row['days'];
		$notes  	= $row['notes'];
		$status 	= $row['status'];
		$notified 	= $row['notified'];
		$action   	= $row['action'];
		$s_no   	= $row['delay_sequence_number'];

		$db1 = DBI::getInstance($database);
		$query1 = "SELECT * FROM jobsite_delay_category_templates WHERE id='$type'";
		$query2 = "SELECT * FROM jobsite_delay_subcategory_templates WHERE id='$scategory'";
		$db1->execute($query1);
		while ($row1 = $db1->fetch()) 
		{
		 	$cattype = $row1['jobsite_delay_category'];
		}
		$db1->execute($query2);
		while ($row1 = $db1->fetch()) 
		{
			$subact = $row1['jobsite_delay_subcategory'];
		}
		if($status == '1'){
			$delayStaus = 'Pending';
		}else if($status == '2'){
			$delayStaus =	'Notify';
		}else if($status == '3'){
			$delayStaus = 'Claim';
		}else{
			$delayStaus = '';
		}

		if($notified == '1'){
			$delayNotify = 'Yes';
		}else if($notified == '2'){
			$delayNotify =	'No';
		}else{
			$delayNotify = '';
		}

		if($days == ''){
			$fromDate = strtotime($bdate);
			$toDate = strtotime($edate);
			$dateDiff = ($toDate - $fromDate) +1;
			$days =  floor($dateDiff / (60 * 60 * 24));
			$days = $days < 0 ? 0 : $days;
		}

		

		if($bdate == '0000-00-00')
			{
				$formattedDelaybdate = '';
			}else{
				$formattedDelaybdate = date("m/d/Y", strtotime($bdate));
			}
			if($edate == '0000-00-00')
			{
				$formattedDelayedate = '';
			}
			else{
				$formattedDelayedate = date("m/d/Y", strtotime($edate));
			}
		
		if($managePermission){
			$delayTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr id="record_container--manage-request_for_information-record--" class="row_$delid">
			<td class="textAlignCenter" id="manage-request_for_information-record--" onclick="Delays__Edit('$delid');">$s_no</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" onclick="Delays__Edit('$delid');">$source</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" onclick="Delays__Edit('$delid');">$cattype</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" onclick="Delays__Edit('$delid');">$subact</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" onclick="Delays__Edit('$delid');">$formattedDelaybdate</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" onclick="Delays__Edit('$delid');">$formattedDelayedate</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" onclick="Delays__Edit('$delid');">$days</td>
			<td class="textAlignLeft" style="padding:0px !important;" id="manage-request_for_information-record--" onclick="Delays__Edit('$delid');">$notes</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" onclick="Delays__Edit('$delid');">$delayStaus</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" onclick="Delays__Edit('$delid');">$delayNotify</td>
			<td class="textAlignCenter"><span class="bs-tooltip colorLightGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant" onclick="Delays__Admin__deleteDelayTemplate($delid);" title="Delete Delays Record">&nbsp;</span>$action</td>
		</tr>

END_DELAYS_TABLE_TBODY;

		}else{
			$delayTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr id="record_container--manage-request_for_information-record--" class="row_$delid">
			<td class="textAlignCenter" id="manage-request_for_information-record--">$incre_id</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" >
			$source</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" >
			$cattype</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" >
			$subact</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" >
			$formattedDelaybdate</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" >
			$formattedDelayedate</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" >
			$days</td>
			<td class="textAlignLeft" style="padding:0px !important;" id="manage-request_for_information-record--" >$notes</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" >
			$delayStaus</td>
			<td class="textAlignLeft" id="manage-request_for_information-record--" >
			$delayNotify</td>
			
		</tr>

END_DELAYS_TABLE_TBODY;

		}	
		
		$incre_id++;
}

if($managePermission){
	
	$htmlContent = <<<END_HTML_CONTENT
	
<table id="delay_list_container--manage-request_for_information-record" class="content cell-border dealy-grid custom_delay_padding custom_table_alignment_delay" border="0" cellpadding="5" cellspacing="0" width="100%">
	<thead class="borderBottom">
		<tr>
		<th class="textAlignCenter">#</th>
		<th class="textAlignLeft">Source</th>
		<th class="textAlignLeft">Type</th>
		<th class="textAlignLeft">Category</th>
		<th class="textAlignLeft setunique">Begin</th>
		<th class="textAlignLeft">End</th>
		<th class="textAlignLeft">Days</th>
		<th class="textAlignLeft">Notes</th>
		<th class="textAlignLeft">Status</th>
		<th class="textAlignLeft">Notified</th>
		<th class="textAlignCenter">Action</th>
		</tr>
	</thead>
	<tbody class="altColors">
		$delayTableTbody
	</tbody>
</table>

END_HTML_CONTENT;
}
else
{
	$htmlContent = <<<END_HTML_CONTENT
	
<table id="delay_list_container--manage-request_for_information-record" class="content cell-border dealy-grid" border="0" cellpadding="5" cellspacing="0" width="100%">
	<thead class="borderBottom">
		<tr>
		<th class="textAlignCenter">#</th>
		<th class="textAlignLeft">Source</th>
		<th class="textAlignLeft">Type</th>
		<th class="textAlignLeft">Category</th>
		<th class="textAlignLeft">Begin</th>
		<th class="textAlignLeft">End</th>
		<th class="textAlignLeft">Days</th>
		<th class="textAlignLeft">Notes</th>
		<th class="textAlignLeft">Status</th>
		<th class="textAlignLeft">Notified</th>
		
		</tr>
	</thead>
	<tbody class="altColors">
		$delayTableTbody
	</tbody>
</table>

END_HTML_CONTENT;
}
	

	return $htmlContent;
}

/**
* Dialog for Create delay
* @param $database
* @param $user_company_id
* @param $project_id
* @param $currently_active_contact_id
* @param $dummyId
* @param $requestForInformationDraft
* @return html
*/


function buildCreateDelayDialog($database, $user_company_id, $project_id, $currently_active_contact_id, $dummyId=null, $requestForInformationDraft=null)
{
	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}
	// Update / Save case
	if ($requestForInformationDraft) {
		/* @var $requestForInformationDraft RequestForInformationDraft */

		$request_for_information_draft_id = (string) $requestForInformationDraft->request_for_information_draft_id;
		$request_for_information_type_id = (string) $requestForInformationDraft->request_for_information_type_id;
		$request_for_information_priority_id = (string) $requestForInformationDraft->request_for_information_priority_id;
		$rfi_cost_code_id = (string) $requestForInformationDraft->rfi_cost_code_id;
		
		$rfi_recipient_contact_id = (string) $requestForInformationDraft->rfi_recipient_contact_id;		
		$rfi_statement = (string) $requestForInformationDraft->rfi_statement;
		$rfi_due_date = (string) $requestForInformationDraft->rfi_due_date;

		// HTML Entity Escaped Data
		$requestForInformationDraft->htmlEntityEscapeProperties();
		$escaped_rfi_plan_page_reference = $requestForInformationDraft->escaped_rfi_plan_page_reference;
		$escaped_rfi_title = $requestForInformationDraft->escaped_rfi_title;

		$buttonDeleteRfiDraft = <<<END_HTML_CONTENT
<input type="button" value="Delete This Draft" onclick="Delays__deleteDelayDraft('manage-request_for_information_draft-record', 'request_for_information_drafts', '$request_for_information_draft_id', { successCallback: Delays__deleteDelayDraftSuccess });" style="font-size: 10pt;">
END_HTML_CONTENT;

		$liRequestForInformationDraftAttachments = '';
		$arrRfiFileManagerFileIds = array();
		$loadRequestForInformationDraftAttachmentsByRequestForInformationDraftIdOptions = new Input();
		$loadRequestForInformationDraftAttachmentsByRequestForInformationDraftIdOptions->forceLoadFlag = true;
		$arrRequestForInformationDraftAttachments = RequestForInformationDraftAttachment::loadRequestForInformationDraftAttachmentsByRequestForInformationDraftId($database, $request_for_information_draft_id, $loadRequestForInformationDraftAttachmentsByRequestForInformationDraftIdOptions);
		foreach ($arrRequestForInformationDraftAttachments as $request_for_information_draft_attachment_id => $requestForInformationDraftAttachment) {
			/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */

			$file_manager_file_id = $requestForInformationDraftAttachment->rfi_attachment_file_manager_file_id;
			$rfi_attachment_source_contact_id = $requestForInformationDraftAttachment->rfi_attachment_source_contact_id;
			$fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$fileManagerFile->htmlEntityEscapeProperties();
			$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
			$fileUrl = $fileManagerFile->generateUrl();

			$arrRfiFileManagerFileIds[] = $file_manager_file_id;

			$dummyRfiDraftAttachmentId = Data::generateDummyPrimaryKey();

			$elementId = "record_container--manage-file_manager_file-record--file_manager_files--$file_manager_file_id";

			$liRequestForInformationDraftAttachments .= <<<END_LI_REQUEST_FOR_INFORMATION_DRAFT_ATTACHMENTS

			<li id="record_container--create-request_for_information_draft_attachment-record--request_for_information_draft_attachments--$dummyRfiDraftAttachmentId" class="hidden">
				<input id="create-request_for_information_attachment-record--request_for_information_attachments--request_for_information_id--$dummyRfiDraftAttachmentId" type="hidden" value="$dummyRfiDraftAttachmentId">
				<input id="create-request_for_information_attachment-record--request_for_information_attachments--request_for_information_draft_id--$dummyRfiDraftAttachmentId" type="hidden" value="$dummyRfiDraftAttachmentId">
				<input id="create-request_for_information_attachment-record--request_for_information_attachments--rfi_attachment_file_manager_file_id--$dummyRfiDraftAttachmentId" type="hidden" value="$file_manager_file_id">
				<input id="create-request_for_information_attachment-record--request_for_information_attachments--rfi_attachment_source_contact_id--$dummyRfiDraftAttachmentId" type="hidden" value="$rfi_attachment_source_contact_id">
			</li>
			<li id="$elementId">
				<a href="javascript:deleteFileManagerFile('$elementId', 'manage-file_manager_file-record', '$file_manager_file_id');">X</a>&nbsp;
				<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
			</li>
END_LI_REQUEST_FOR_INFORMATION_DRAFT_ATTACHMENTS;

		}

		$csvRfiFileManagerFileIds = join(',', $arrRfiFileManagerFileIds);

		//<input type="button" value="Save As A New RFI Draft" onclick="Delays__createDelayDraftViaPromiseChain('create-request_for_information-record', '$dummyId');" style="font-size: 10pt;">

		// Save RFI As Draft Button
		$saveRFIAsDraftButton = <<<END_SAVE_RFI_AS_DRAFT_BUTTON
<input type="button" value="Save Changes To This Draft" onclick="Delays__createDelayDraftViaPromiseChain('create-request_for_information-record', '$dummyId', { crudOperation: 'update', request_for_information_draft_id: $request_for_information_draft_id });" style="font-size: 10pt;">&nbsp;
END_SAVE_RFI_AS_DRAFT_BUTTON;

	} else {
		

		// Create case
		$request_for_information_draft_id = '';
		$request_for_information_type_id = '';
		$request_for_information_priority_id = '1';
		$rfi_cost_code_id = '';
		$rfi_creator_contact_id = '';

		$rfi_recipient_contact_id = '';
		
		$rfi_statement = '';
		$rfi_due_date = '';

		// HTML Entity Escaped Data
		$escaped_rfi_plan_page_reference = '';
		
		$escaped_rfi_title = '';

		$buttonDeleteRfiDraft = '';
		$csvRfiFileManagerFileIds = '';

		// Save RFI As Draft Button
		$saveRFIAsDraftButton = <<<END_SAVE_RFI_AS_DRAFT_BUTTON
<input type="button" value="Save RFI As Draft" onclick="Delays__createDelayDraftViaPromiseChain('create-request_for_information-record', '$dummyId');" style="font-size: 10pt;">
END_SAVE_RFI_AS_DRAFT_BUTTON;

	}

	if (!isset($arrRequestForInformationDraftAttachments) || count($arrRequestForInformationDraftAttachments) == 0) {
		$liRequestForInformationDraftAttachments = '<li class="placeholder">No Files Attached</li>';
	}

	// FileManagerFolder
	$virtual_file_path = '/RFIs/RFI Draft Attachments/';
	$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $virtual_file_path);
	/* @var $rfiFileManagerFolder FileManagerFolder */

	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record';
	$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/RFIs/RFI Draft Attachments/';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadRequestForInformationAttachment';
	$input->allowed_extensions = 'pdf';
	$input->post_upload_js_callback = "RFIs__rfiDraftAttachmentUploaded(arrFileManagerFiles, 'container--request_for_information_attachments--create-request_for_information-record')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

	$rfiCostCodesElementId = "ddl--create-request_for_information-record--requests_for_information--rfi_cost_code_id--$dummyId";

	$costCodesInput = new Input();
	$prependedOption = '';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$selectedOption = $rfi_cost_code_id;
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $rfiCostCodesElementId;
	$costCodesInput->firstOption = '<option value="0">Optionally Select A Cost Code Below For Reference</option>';
	$costCodesInput->selectCssStyle = 'style="font-size: 1.3em; width: 400px;"';
	$costCodesInput->selectedOption = $rfi_cost_code_id;
	$rfiDraftsHiddenCostCodeElementId = "create-request_for_information_draft-record--request_for_information_drafts--rfi_cost_code_id--$dummyId";
	$costCodesInput->additionalOnchange = "ddlOnChange_UpdateHiddenInputValue(this, '$rfiDraftsHiddenCostCodeElementId');";
	$ddlCostCodes = buildCostCodeDropDownList($costCodesInput);

	$loadAllRequestForInformationPrioritiesOptions = new Input();
	$loadAllRequestForInformationPrioritiesOptions->forceLoadFlag = true;
	$arrRequestForInformationPriorities = RequestForInformationPriority::loadAllRequestForInformationPriorities($database, $loadAllRequestForInformationPrioritiesOptions);
	$ddlRfiPrioritiesId = "ddl--create-request_for_information-record--requests_for_information--request_for_information_priority_id--$dummyId";
	$rfiDraftsHiddenRfiPrioritiesElementId = "create-request_for_information_draft-record--request_for_information_drafts--request_for_information_priority_id--$dummyId";
	$js = ' style="width: 150px;" class="moduleRFI_dropdown required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$rfiDraftsHiddenRfiPrioritiesElementId.'\');"';
	$selectedOption = $request_for_information_priority_id;
	$ddlRfiPriorities = PageComponents::dropDownListFromObjects($ddlRfiPrioritiesId, $arrRequestForInformationPriorities, 'request_for_information_priority_id', null, 'request_for_information_priority', null, $selectedOption, null, $js, $prependedOption);

	$loadAllRequestForInformationTypesOptions = new Input();
	$loadAllRequestForInformationTypesOptions->forceLoadFlag = true;
	$arrRequestForInformationTypes = RequestForInformationType::loadAllRequestForInformationTypes($database, $loadAllRequestForInformationTypesOptions);
	$ddlRfiTypesId = "ddl--create-request_for_information-record--requests_for_information--request_for_information_type_id--$dummyId";
	$rfiDraftsHiddenRfiTypesElementId = "create-request_for_information_draft-record--request_for_information_drafts--request_for_information_type_id--$dummyId";
	$js = ' style="width: 150px;" class="moduleRFI_dropdown3 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$rfiDraftsHiddenRfiTypesElementId.'\');"';
	$prependedOption = '<option value="">Select An RFI Type</option>';
	$selectedOption = $request_for_information_type_id;
	$ddlRfiTypes = PageComponents::dropDownListFromObjects($ddlRfiTypesId, $arrRequestForInformationTypes, 'request_for_information_type_id', null, 'request_for_information_type', null, $selectedOption, null, $js, $prependedOption);

	$arrProjectTeamMembers = Contact::loadProjectTeamMembers($database, $project_id);

	// To:
	// rfi_recipient_contact_id
	$rfiDraftsHiddenProjectTeamMembersToElementId = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_contact_id--$dummyId";
	$js = ' class="moduleRFI_dropdown4 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$rfiDraftsHiddenProjectTeamMembersToElementId.'\');"';
	$prependedOption = '<option value="">Select a contact</option>';
	$ddlProjectTeamMembersToId = "ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--$dummyId";
	$selectedOption = $rfi_recipient_contact_id;
	$ddlProjectTeamMembersTo = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersToId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', $selectedOption, null, $js, $prependedOption);

	// Cc:
	// rfi_additional_recipient_contact_id
	$ddlProjectTeamMembersCcId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Cc-$dummyId";
	$js = ' onchange="Delays__addRecipient(this);" class="moduleRFI_dropdown4"';
	$ddlProjectTeamMembersCc = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersCcId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);
	// Bcc:
	$ddlProjectTeamMembersBccId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Bcc-$dummyId";
	$ddlProjectTeamMembersBcc = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersBccId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);

	$rfi_attachment_source_contact_id = $currently_active_contact_id;
	$rfi_creator_contact_id = $currently_active_contact_id;

	$htmlContent = <<<END_HTML_CONTENT

<form id="formCreateRfi">
	<div id="record_creation_form_container--create-request_for_information-record--$dummyId">
		<div class="RFI_table_create">
			<table width="100%" border="0" cellspacing="0" cellpadding="4">
				<tr>
					<td width="70%" class="RFI_table_header2">RFI Title:</td>
				</tr>
				<tr>
					<td class="RFI_table2_content">
						<!--<input type="text" class="RFI_table2" name="rfi_title">-->
						<input id="create-request_for_information-record--requests_for_information--rfi_title--$dummyId" class="RFI_table2 required" type="text" value="$escaped_rfi_title">
					</td>
				</tr>
				<tr>
					<td class="RFI_table_header2">Plan Page Reference:</td>
				</tr>
				<tr>
					<td class="RFI_table2_content">
						<p>
							<!--<input type="text" class="RFI_table2" name="rfi_plan_page_reference">-->
							<input id="create-request_for_information-record--requests_for_information--rfi_plan_page_reference--$dummyId" class="RFI_table2" type="text" value="$escaped_rfi_plan_page_reference">
						</p>
					</td>
				</tr>
				<tr>
					<td class="RFI_table_header2">RFI Due Date:</td>
				</tr>
				<tr>
					<td class="RFI_table2_content">
						<!--<input id="dueDate" type="text" class="RFI_table3" name="rfi_due_date">-->
						<input id="create-request_for_information-record--requests_for_information--rfi_due_date--$dummyId" class="RFI_table3 datepicker" type="text" value="$rfi_due_date">
					</td>
				</tr>
				<tr>
					<td class="RFI_table_header2">Cost Code Reference (optional):</td>
				</tr>
				<tr>
					<td class="RFI_table2_content">
						<input id="create-request_for_information-record--requests_for_information--rfi_cost_code_id--$dummyId" type="hidden" value="$rfi_cost_code_id">
						<input id="create-request_for_information_draft-record--request_for_information_drafts--rfi_cost_code_id--$dummyId" type="hidden" value="$rfi_cost_code_id">
						<span class="moduleRFI">
						$ddlCostCodes
						</span>
					</td>
				</tr>
				<tr>
					<td class="RFI_table_header2">RFI Questions / Comments</td>
				</tr>
				<tr>
					<td class="RFI_table2_content">
						<p><textarea id="create-request_for_information-record--requests_for_information--rfi_statement--$dummyId" class="RFI_table2 required">$rfi_statement</textarea></p>
						<input id="create-request_for_information-record--requests_for_information--request_for_information_priority_id--$dummyId" type="hidden" value="$request_for_information_priority_id">
						<input id="create-request_for_information_draft-record--request_for_information_drafts--request_for_information_priority_id--$dummyId" type="hidden" value="$request_for_information_priority_id">
						<input id="create-request_for_information-record--requests_for_information--request_for_information_type_id--$dummyId" type="hidden" value="$request_for_information_type_id">
						<input id="create-request_for_information_draft-record--request_for_information_drafts--request_for_information_type_id--$dummyId" type="hidden" value="$request_for_information_type_id">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left">RFI Priority:</td>
								<td align="left">RFI Type:</td>
							</tr>
							<tr>
								<td class="paddingRight10">$ddlRfiPriorities</td>
								<td class="paddingRight10">$ddlRfiTypes</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="RFI_table_create margin0px">
			<table width="100%" border="0" cellspacing="0" cellpadding="4">
				<tr>
					<td width="70%" class="RFI_table_header2">Select A File To Attach:</td>
				</tr>
				<tr>
					<td class="RFI_table2_content">{$fileUploader}{$fileUploaderProgressWindow}</td>
				</tr>
				<tr>
					<td class="RFI_table_header2">Attached Files:</td>
				</tr>
				<tr>
					<td class="RFI_table2_content" id="tdAttachedFilesList">
						<ul id="container--request_for_information_attachments--create-request_for_information-record" style="list-style:none; margin:0; padding:0">
							$liRequestForInformationDraftAttachments
						</ul>
					</td>
				</tr>
				<tr>
					<td class="RFI_table_header2" style="vertical-align: middle;">Email:</td>
				</tr>
				<tr>
					<td class="RFI_table2_content">
						<input id="create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--$dummyId" type="hidden" value="$rfi_recipient_contact_id">
						<input id="create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_contact_id--$dummyId" type="hidden" value="$rfi_recipient_contact_id">
						<p>To: &nbsp;$ddlProjectTeamMembersTo</p>
						<div>
							<p>Cc: &nbsp;$ddlProjectTeamMembersCc</p>
							<ul id="record_container--request_for_information_recipients--Cc" style="list-style:none;">
							</ul>
						</div>
						<div>
							<p>Bcc: $ddlProjectTeamMembersBcc</p>
							<ul id="record_container--request_for_information_recipients--Bcc" style="list-style:none;">
							</ul>
						</div>
						<p>Add additional text to the body of the email: </p>
						<p>
							<textarea id="textareaEmailBody" class="RFI_table2"></textarea>
						</p>
						<p>
							<input type="button" value="Save As An RFI And Notify Team" onclick="Delays__createDelayAndSendEmailViaPromiseChain('create-request_for_information-record', '$dummyId');" style="font-size: 10pt;">&nbsp;
							<input type="button" value="Save As An RFI No Email" onclick="Delays__createDelayViaPromiseChain('create-request_for_information-record', '$dummyId');" style="font-size: 10pt;">
						</p>
						<p>
							$saveRFIAsDraftButton&nbsp;&nbsp;<span id="spanDeleteRfiDraft">$buttonDeleteRfiDraft</span>
						</p>
						<span class="fakeHref verticalAlignBottom" onclick="showHideDomElement('rfi_draft_help');">(?)</span><span id="rfi_draft_help" class="displayNone verticalAlignBottom"> Note: Saving the RFI as a Draft will save your files and the Email To, but not the Email Cc, Bcc, or message..</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>
<input id="create-request_for_information-record--requests_for_information--request_for_information_draft_id--$dummyId" type="hidden" value="$request_for_information_draft_id">
<input id="create-request_for_information-record--requests_for_information--request_for_information_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-request_for_information-record--requests_for_information--rfi_attachment_source_contact_id--$dummyId" type="hidden" value="$rfi_attachment_source_contact_id">
<input id="create-request_for_information-record--requests_for_information--rfi_creator_contact_id--$dummyId" type="hidden" value="$rfi_creator_contact_id">
<input id="create-request_for_information-record--requests_for_information--project_id--$dummyId" type="hidden" value="$project_id">
<input id="create-request_for_information-record--requests_for_information--dummy_id" type="hidden" value="$dummyId">
<input id="create-request_for_information-record--requests_for_information--sendNotification--$dummyId" type="hidden" value="false">
<input id="create-request_for_information_notification-record--request_for_information_notifications--request_for_information_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-request_for_information_recipient-record--request_for_information_recipients--request_for_information_notification_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-request_for_information_recipient-record--request_for_information_recipients--smtp_recipient_header_type--$dummyId" type="hidden" value="Cc">
<input id="create-request_for_information_attachment-record--request_for_information_attachments--request_for_information_id--$dummyId" type="hidden" value="">
<input id="create-request_for_information_attachment-record--request_for_information_attachments--request_for_information_draft_id--$dummyId" type="hidden" value="">
<input id="create-request_for_information_attachment-record--request_for_information_attachments--rfi_attachment_source_contact_id--$dummyId" type="hidden" value="$rfi_attachment_source_contact_id">
<input id="create-request_for_information_attachment-record--request_for_information_attachments--csvRfiFileManagerFileIds--$dummyId" type="hidden" value="$csvRfiFileManagerFileIds">

END_HTML_CONTENT;

	return $htmlContent;
}


