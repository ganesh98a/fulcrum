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
require_once('lib/common/ContractingEntities.php');
require_once('lib/common/JobsiteDelayCategoryTemplates.php');
require_once('lib/common/PageComponents.php');
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
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/User.php');
require_once('lib/common/Mail.php');
require_once('image-resize-functions.php');
require_once('page-components/dropDownListWidgets.php');
require_once('page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('subcontract-change-order-functions.php');
require_once('lib/common/Module.php');
require_once('lib/common/Service/UniversalService.php');
require_once('lib/common/Date.php');
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

/**
* Display the Transmittal Grid
* @param project id
* @return html
*/
function renderTransmittalListView_AsHtml($projectId,$managePermission,$database){	
	$TransmittalTableTbody = '';
	$incre_id=1;

	$db = DBI::getInstance($database);
	$query = "SELECT td.*,tt.`transmittal_category` FROM `transmittal_data` AS td INNER JOIN transmittal_types AS tt ON td.`transmittal_type_id`=tt.`id` WHERE td.`status` = '0' AND td.`project_id`='".$projectId."' ";
	$db->execute($query);
	$records = array();
	while($row = $db->fetch()){
		$records[] = $row;
	}
	foreach($records as $row){
		$id      = $row['id'];
		$transmittal_type	= $row['transmittal_category'];
		$comment   	= $row['comment'];
		$raised_by 	= $row['raised_by'];
		$raised_on  	= Date::convertDateTimeFormat($row['raised_on'], 'html_form_datetime');
		$sequence_number 	= $row['sequence_number'];
		$mail_to =  $row['mail_to'];
		$raiseduserName = ContactName($database,$raised_by); //sender name
		$receiverName = ContactName($database,$mail_to); //receiver name 
		if(!empty($transmittal_type) && ($transmittal_type == 'Email To Contact')){
			if($transmittal_type == 'Bid Invitation'){
				$receivercompany = ContactCompanyName($database,$mail_to);
			}else{
				$receivercompany = '';
			}
		}else{
			if($transmittal_type == 'Bid Invitation'){
				$receivercompany = ContactCompanyName($database,$mail_to);
			}else{
				$receivercompanyArr =Contact::CompanyNamefromContactID($database,$mail_to); //receiver name 
				$receivercompany = $receivercompanyArr['company'];
			}
		}


				
		if($managePermission){
			$TransmittalTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr id="record_container--manage-transmittal_data-record--" class="row_$id" onclick="showTransmittalitem('$id','$transmittal_type');">
			<td class="textAlignCenter" id="manage-transmittal_data-record--"  >$sequence_number</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >$transmittal_type</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >$comment</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >$raiseduserName</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >$receiverName</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >$receivercompany</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >$raised_on</td>
			</tr>
			
END_DELAYS_TABLE_TBODY;

// if( $transmittal_type=='Bid Invitation')  {

// 	$TransmittalTableTbody .='
// 	<tr>
// 	<td id="hidden_row_$id" colspan="7" style="display:table-cell">xxxx</td>
// 	</tr>';
// }


		}else{
			$TransmittalTableTbody .= <<<END_DELAYS_TABLE_TBODY
		<tr id="record_container--manage-transmittal_data-record--" class="row_$id">
			<td class="textAlignCenter" id="manage-transmittal_data-record--">$incre_id</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >
			$transmittal_type</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >
			$comment</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >
			$raiseduserName</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >
			$receiverName</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >
			$receivercompany</td>
			<td class="textAlignLeft" id="manage-transmittal_data-record--" >
			$raised_on</td>
			</tr>
END_DELAYS_TABLE_TBODY;

		}	
		$incre_id++;
	}

	if($managePermission){
	$htmlContent = <<<END_HTML_CONTENT
<table id="Transmittal_list_container--manage-Transmittal_data-record" class="content cell-border dealy-grid custom_delay_padding custom_table_alignment_delay" border="0" cellpadding="5" cellspacing="0" width="100%">
	<thead class="borderBottom">
		<tr>
		<th class="textAlignCenter">Ref #</th>
		<th class="textAlignLeft">Transmittal Type</th>
		<th class="textAlignLeft">Comment</th>
		<th class="textAlignLeft">Creator</th>
		<th class="textAlignLeft">Receiver</th>
		<th class="textAlignLeft">Contact Company</th>
		<th class="textAlignLeft">Sent</th>
END_HTML_CONTENT;

$htmlContent .= <<<END_HTML_CONTENT
		</tr>
	</thead>
	<tbody class="altColors">
		$TransmittalTableTbody
	</tbody>
</table>
END_HTML_CONTENT;
	}else{
	$htmlContent = <<<END_HTML_CONTENT
	
<table id="Transmittal_list_container--manage-Transmittal_data-record" class="content cell-border dealy-grid custom_delay_padding custom_table_alignment_delay" border="0" cellpadding="5" cellspacing="0" width="100%">
	<thead class="borderBottom">
		<tr>
		<th class="textAlignCenter">#</th>
		<th class="textAlignLeft">Transmittal Type</th>
		<th class="textAlignLeft">Comment</th>
		<th class="textAlignLeft">Creator</th>
		<th class="textAlignLeft">Receiver</th>
		<th class="textAlignLeft">Contact Company</th>
		<th class="textAlignLeft">Sent</th>
		</tr>
	</thead>
	<tbody class="altColors">
		$TransmittalTableTbody
	</tbody>
</table>
END_HTML_CONTENT;
	}
	return $htmlContent;
}
//To show the attachements for transmittal
function showTransmittalAttachmentDialog($database, $user_company_id, $project_id, $currentlyActiveContactId,$trans_id)
{

	//Attachments
	$db = DBI::getInstance($database);
	$attachmentQuery = "SELECT t.attachment_file_manager_file_id, f.virtual_file_name FROM file_manager_files as
	f JOIN transmittal_attachments t  ON f.id = t.attachment_file_manager_file_id  WHERE t.transmittal_data_id='$trans_id'";
	
	$db->query($attachmentQuery);
	$attachmentRecords = array();
	while($attachmentRow = $db->fetch())
	{
		$attachmentRecords[] = $attachmentRow;
	}
	$db->free_result();
	$attachmentIds = array();
	$attachmentHtml = '<ul style="margin:0; padding:0">';
	$attachIds="";
	foreach($attachmentRecords as $attachmentRecord){
		$attachmentId = $attachmentRecord['attachment_file_manager_file_id'];
		$attachIds .= $attachmentId.',';
		$attachmentName = $attachmentRecord['virtual_file_name'];

		require_once('lib/common/FileManagerFile.php');
		$value = $attachmentId;
		$FileManagerFile = FileManagerFile::findById($database, $attachmentId);
		$attachmenturl = $FileManagerFile->generateUrl();
		$attachmentIds[] = $attachmentId;
		$attachmentHtml .= '<li id="record_container--manage-file_manager_file-record--file_manager_files--'.$attachmentId.'" class="uploadedfile"><a target="_blank" href="'.$attachmenturl.'" style="color:#06c;">'.$attachmentName.'</a><input class="upfileid" value="'.$value.'" type="hidden"></li>
		';
	}
	if (!isset($attachmentRecords) || count($attachmentRecords) == 0) {
		$attachmentHtml .= '<li class="placeholder" style="color:#000000;list-style:none;">No Files Attached</li>';
	}
	$attachmentHtml .= "</ul>";

	

	$db = DBI::getInstance($database);
	$query_log = "SELECT td.mail_log,td.raised_on FROM `transmittal_data` AS td  WHERE td.`status` = '0' AND td.`id`='".$trans_id."' ";
	$db->execute($query_log);
	$records_log = array();
	// while($row_log = $db->fetch()){
	// 	$records_log[] = $row_log;
	// }
	$get_rows=$db->fetch();
	if($get_rows['mail_log']!=''){
		$eLog=json_decode($get_rows['mail_log']);
		$attachmentHtml .= '<hr><h4 style="margin: 1em 0 0 0;">Mail Status:</h4>';
		$attachmentHtml .= '<p><table><tbody>'.$get_rows['mail_log'].'</tbody></table></p>';
	}


	//To fetch the file manager file for transmittal
	$attachIds =rtrim($attachIds,',');
	$trans_file_manager_file_id = fetchTransmittalFileId($trans_id,$project_id,$attachIds,$database);
	
	if (isset($trans_file_manager_file_id) && ($trans_file_manager_file_id !='0')) {
		$transFileManagerFile = FileManagerFile::findById($database, $trans_file_manager_file_id);
		$transPdfUrl = $transFileManagerFile->generateUrl();

	}

	if ($transPdfUrl != '') {
		$trasurl = '<input type="button"  class="transpdf" onclick="transmittal__openpdfInNewTab('."'".$transPdfUrl."'".');" value="View Transmittal PDF" style="font-size: 10pt;visibility:hidden;">&nbsp;';
	}


	$htmlContent = <<<END_HTML_CONTENT
	<div id="record_creation_form_container--create-subChange-record--">
	<table width="100%"  border="0">
	<tbody>
	<tr>
	<td id="tdAttachedFilesList" class="" colspan="3">
	$attachmentHtml
	</td>
	</tr>
	</table>
	$trasurl
	</div>
END_HTML_CONTENT;

return $htmlContent;

}

function fetchTransmittalFileId($trans_id,$project_id,$attachIds,$database)
{
	$db = DBI::getInstance($database);
	 $que1="SELECT sequence_number FROM `transmittal_data` WHERE `id` = $trans_id ";
	$db->execute($que1);
	$row1=$db->fetch();
	$sequence_number=$row1['sequence_number'];
	$db->free_result();

	//To get the file manager folder     /Transmittals/Transmittal #349/
	 $que2="SELECT * FROM `file_manager_folders` WHERE `virtual_file_path` LIKE '/Transmittals/Transmittal #".$sequence_number."/'  and project_id='$project_id'";
	$db->execute($que2);
	$row2=$db->fetch();
	$folder_id=$row2['id'];
	$db->free_result();
	
	if($attachIds!='')
	{
		$fil_query ="and  id not in ($attachIds)";
	}else
	{
		$fil_query ="";
	}

	$que3="SELECT * FROM `file_manager_files` WHERE `file_manager_folder_id` =$folder_id  $fil_query order by id desc";
	$db->execute($que3);
	$row3=$db->fetch();
	$file_id=$row3['id'];
	$db->free_result();


	return $file_id;
}


/**
* Dialog for Create Transmittal
* @param $database
* @param $user_company_id
* @param $project_id
* @param $currently_active_contact_id
* @param $dummyId
* @param $requestForInformationDraft
* @return html
*/

function buildCreateTransmittalDialog($database, $user_company_id, $project_id, $currently_active_contact_id, $dummyId=null, $requestForInformationDraft=null)
{
	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}


	if (!isset($arrRequestForInformationDraftAttachments) || count($arrRequestForInformationDraftAttachments) == 0) {
		$liRequestForInformationDraftAttachments = '<li class="placeholder">No Files Attached</li>';
	}
	// FileManagerFolder
	$virtual_file_path = '/Transmittals/Attachments/';
	$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $virtual_file_path);
	/* @var $rfiFileManagerFolder FileManagerFolder */

	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record';
	$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Transmittals/Attachments/';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadRequestForInformationAttachment';
	$input->allowed_extensions = 'pdf,jpg,jpeg,doc,docx,png,gif,xlsx,csv,xls,rtf';
	$input->post_upload_js_callback = "RFIs__rfiDraftAttachmentUploaded(arrFileManagerFiles, 'container--request_for_information_attachments--create-request_for_information-record')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();
	
	$userTypes = loadTransmittalType($database);
	$userTypes = array('' => 'Select') + $userTypes;
	$js = 'id="transmittal_type_select" class="target moduleRFI_dropdown4 required" onchange="change_transmittal(this.value)" ';
	$ddlProjectTeamListId = "transmital_type";
	$ddlProjectTeamList = PageComponents::dropDownList($ddlProjectTeamListId, $userTypes, '', null, $js, null);
	//For email Filter option
	$emailfilter = array('0'=>'All','1'=>'Roles','2'=>'Company');
	$js = 'id="emailfilter" class="target moduleRFI_dropdown4 required" onchange="emailfilters(this.id,this.value)"  ';
	$emailfilterId = "emailfilter";
	$emailfilterList = PageComponents::dropDownList($emailfilterId, $emailfilter, '', null, $js, null,'');
	//For roles 
	$AXIS_USER_ROLE_ID_BIDDER = AXIS_USER_ROLE_ID_BIDDER;
	$projectrole = projectroles($database);
	unset($projectrole[$AXIS_USER_ROLE_ID_BIDDER]);
	$projectrole = array('' => 'Select a Role') + $projectrole;
	$js = 'id="project_role" class="target moduleRFI_dropdown4 required" style="display:none;" onchange="emailroles(this.value)"';
	$projectroleListId = "project_role";
	$projectroleList = PageComponents::dropDownList($projectroleListId, $projectrole, '', null, $js, null);
	//For Company 
	$projectCompany = companyWithoutBidder($project_id, $database);
	$projectCompany = array('' => 'Select a Company') + $projectCompany;
	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_projectrole_id--$dummyId";
	$js = 'id="project_company" class="target moduleRFI_dropdown4 required" style="display:none;" onchange="emailcompany(this.value)" ';
	$projectCompanyId = "projectCompany";
	$projectCompanyList = PageComponents::dropDownList($projectCompanyId, $projectCompany, '', null, $js, null);
	
	

	// To:
	// rfi_recipient_contact_id
	/*load membre by roles*/
	// 10 sub contractor
	// 3 user
	// 5 project manager 
	// 4 project excutive

	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($database, $project_id, 'Transmittal');

	$rfiDraftsHiddenProjectTeamMembersToElementId = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_contact_id--$dummyId";
	$js = ' class="moduleRFI_dropdown4 required emailGroup to_contact" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$rfiDraftsHiddenProjectTeamMembersToElementId.'\');"';
	$ddlProjectTeamMembersToId = "ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--$dummyId";	
	$ddlProjectTeamMembersTo = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersToId);

	// Cc:
	// rfi_additional_recipient_contact_id

	$ddlProjectTeamMembersCcId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Cc-$dummyId";
	$js = ' onchange="Transmittals__addRecipient(this);" class="moduleRFI_dropdown4 emailGroup cc_contact"';
	$ddlProjectTeamMembersCc = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersCcId);

	// Bcc:

	$ddlProjectTeamMembersBccId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Bcc-$dummyId";
	$ddlProjectTeamMembersBcc = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersBccId);

	$rfi_attachment_source_contact_id = $currently_active_contact_id;
	$rfi_creator_contact_id = $currently_active_contact_id;

	$htmlContent = <<<END_HTML_CONTENT

<form name="formCreateTransmittal" id="formCreateTransmittal" >
	<div id="record_creation_form_container--create-transmittal-record--">
		<div class="RFI_table_create">
			<table width="100%" cellspacing="0" cellpadding="4" border="0">
				<tbody>
					<tr>
						<td width="70%" class="RFI_table_header2" colspan="3">Type</td>
					</tr>
					<input type="hidden" id="Transmittal_id" value="" />
					<input type="hidden" id="source_id" value="" />
					<input type="hidden" id="file_attachement_id" value="" />
					<tr>
						<td class="RFI_table2_content font_serif required" colspan="3">
						$ddlProjectTeamList
						</td>
					</tr>
					<tr class="sub_field" style="display:none;">
						<td class="RFI_table_header2 required" colspan="3">Subject</td>
					</tr>
					<tr class="sub_field" style="display:none;">
						<td class="RFI_table2_content" colspan="3">
							<p><input type="text" class="RFI_table2 required target" id="subject"/></p>
						</td>
						</tr>
					<tr>
						<td class="RFI_table_header2 required" colspan="3">Comments</td>
					</tr>
					<tr>
						<td class="RFI_table2_content" colspan="3">
							<p><textarea class="RFI_table2 required target" id="comments"></textarea></p>
						</td>
					</tr>
				</tbody>
		   	</table>
		</div>
		<div class="RFI_table_create margin0px">
			<table width="100%" cellspacing="0" cellpadding="4" border="0">
				<tbody><tr>
					<td width="70%" class="RFI_table_header2" colspan="3">Select A File To Attach:</td>
				</tr>
				<tr>
					<td class="RFI_table2_content" colspan="3">{$fileUploader}{$fileUploaderProgressWindow}
					</td>
				</tr>
				<tr>
					<td class="RFI_table_header2" colspan="3">Attached Files:</td>
				</tr>
				<tr>
					<td id="tdAttachedFilesList" class="RFI_table2_content" colspan="3">
						<ul style="list-style:none; margin:0; padding:0" id="container--request_for_information_attachments--create-request_for_information-record" class="divslides">
							<li class="placeholder">No Files Attached</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td width="70%" class="RFI_table_header2" colspan="3">Filter To Select Email Id(s)</td>
				</tr>
				<tr>
					<td class="RFI_table2_content font_serif required border_right_none">
					$emailfilterList
					</td>
					<td class="RFI_table2_content font_serif required border_right_none" >
					$projectroleList
					</td>
					<td class="RFI_table2_content font_serif required border_right_none" >
					$projectCompanyList
					</td>
				</tr>
				<tr>
					<td style="vertical-align: middle;" class="RFI_table_header2" colspan="3">Email:</td>
				</tr>
				<tr>
					<td class="RFI_table2_content Subsearch" colspan="3">
						<input id="create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--$dummyId" type="hidden" value="">
						<input id="create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_contact_id--$dummyId" type="hidden" value="">
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
							<input type="button" style="font-size: 10pt;" onclick="Transmittals__createTransmittalsViaPromiseChain('$dummyId','1');" value="Save and Email Transmittal">&nbsp;
						
						</p>
						<span class="fakeHref verticalAlignBottom" onclick="showHideDomElement('rfi_draft_help');">(?)</span><span id="rfi_draft_help" class="displayNone verticalAlignBottom"> Note: Saving the Email Transmittal will save your files.</span>
					</td>
				</tr>
			</tbody></table>
		</div>
	</div>
</form>
<input id="create-request_for_information-record--requests_for_information--request_for_information_draft_id--$dummyId" type="hidden" value="">
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
<input id="create-request_for_information_attachment-record--request_for_information_attachments--csvRfiFileManagerFileIds--$dummyId" type="hidden" value="">


END_HTML_CONTENT;


	return $htmlContent;
}
// To generate PDF that initiated in the transmittal Module
function buildTransmittalAsHtmlForPdfConversion($database,$userCompanyId,$jobsitePhotoHtmlContent ,$transmittalId,$projectName,$projectId,$mailText,$pdf_content,$total_count,$headerLogo='',$cont=''){
	
	$projectName = strtoupper(trim($projectName));
	$projectInfo = Project::findById($database,$projectId);
	$ProjectCity = $projectInfo['address_city'];
	/*fetch Data with template content*/
	$db = DBI::getInstance($database);
 	$query = "SELECT td.*, tat.template_content FROM transmittal_data AS td
 	INNER JOIN transmittal_types AS tt ON td.transmittal_type_id = tt.id
 	INNER JOIN transmittal_admin_templates AS tat ON tat.template_type_id = tt.id
 	WHERE td.id='$transmittalId'";
	$db->query($query);
	
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}
	$db->free_result();

	$emailTo   = $records[0]['mail_to'];
	$entity_id = $records[0]['contracting_entity_id'];
	$contact_id = $records[0]['raised_by'];
	$comment = $records[0]['comment'];
	$subject = $records[0]['subject'];
	$template_content = $records[0]['template_content'];
	$emailToInfo = Contact::findContactById($database,$emailTo);
	

	$toName = strtoupper($emailToInfo['first_name'].' '.$emailToInfo['last_name']);
	$toName = strtoupper(trim($toName));
	if($toName == ' ' || $toName == '')
		$toName = $emailToInfo['email'];
	$toCompanyId = $emailToInfo['contact_company_id'];

	$contactCompany = ContactCompany::findById($database, $toCompanyId);
	$toCompanyName = strtoupper($contactCompany->contact_company_name);
	
	// Login User Company Details	
    $main_company = Project::ProjectsMainCompany($database,$projectId);

	$fromuserCompanyInfo = UserCompany::findById($database, $main_company);
	$fromuserCompanyName = strtoupper(trim($fromuserCompanyInfo->user_company_name));

	// Login User Details
	$fromuserInfo = Contact::findContactById($database,$contact_id);
	$fromUsername = $fromuserInfo['first_name'].' '.$fromuserInfo['last_name'];
	$fromEmail = $fromuserInfo['email'];

	$fromUsername = strtoupper(trim($fromUsername));
	$fromEmail = strtoupper(trim($fromEmail));

	if($fromUsername == ' ' || $fromUsername == '')
		$fromUsername = $fromuserInfo['email'];

	$regardsUsername = ucfirst($fromuserInfo['first_name']).' '.ucfirst($fromuserInfo['last_name']);
	$regardsEmail = ucfirst(trim($fromuserInfo['email']));
	
	$fromuserContactId = $fromuserInfo->contact_id;
	
	$contactPhoneInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$fromuserContactId,'1');
	
	if($contactPhoneInfo)
		$contactPhoneNo = '('.$contactPhoneInfo['area_code'].') '.$contactPhoneInfo['prefix'].'-'.$contactPhoneInfo['number'];
	else
		$contactPhoneNo = '&nbsp;';
	
	$contactFaxInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$fromuserContactId,'2');

	if($contactFaxInfo)
		$contactFaxNo = 'Fx: ('.$contactFaxInfo['area_code'].') '.$contactFaxInfo['prefix'].'-'.$contactFaxInfo['number'];
	else
		$contactFaxNo = '&nbsp;';


	$today = strtoupper(date('F d, Y'));
	/*GC logo*/
	$user_company_id = $userCompanyId;
	require_once('lib/common/Logo.php');

	// To include contracting entity
	$EntityName = ContractingEntities::getcontractEntityNameforProject($database,$entity_id);

	
/*string replace with dynamic template content to transmittal admin*/
//CompanyName
$template_content = str_replace('*COMPANY_NAME*', $EntityName, $template_content);
//RecipientCompanyName
$template_content = str_replace('*RECIPIENT_COMPANY_NAME*', $toCompanyName, $template_content);
// ProjectNmae
$template_content = str_replace('*PROJECT_NAME*', $projectName, $template_content);
// To Recipient
$template_content = str_replace('*TO_ADDRESS_OR_TO_NAME*', $toName, $template_content);
// From recipient
$template_content = str_replace('*FROM_ADDRESS_OR_FROM_NAME*', $fromUsername, $template_content);
// DATE_TIME
$template_content = str_replace('*DATE_TIME*', $today, $template_content);
// page count of pdf
$template_content = str_replace('*PAGE_COUNT*', $total_count, $template_content);
// phone no
$template_content = str_replace('*FROM_PHONE_NO*', $contactPhoneNo, $template_content);
// fax no
$template_content = str_replace('*FROM_FAX_NO*', $contactFaxNo, $template_content);
// regards from name
$template_content = str_replace('*FROM_NAME*', $regardsUsername, $template_content);
// regards from mail
$template_content = str_replace('*FROM_ADDRESS*', $regardsEmail, $template_content);
// Comments
$template_content = str_replace('*COMMENTS*', $comment, $template_content);
// Mail Comments
$template_content = str_replace('*MAIL_CONTENT*', $mailText, $template_content);
// subject_title
$template_content = str_replace('*SUBJECT_TITLE*', $subject, $template_content);
// Project City Name
$template_content = str_replace('*PROJECT_CITY_NAME*', $ProjectCity, $template_content);
// Days

$cur_date=date('l');
	if($cur_date=='Friday')
		$next_date=date('l, F d, Y', strtotime(' +3 day'));
	else if($cur_date=='Saturday')
		$next_date=date('l, F d, Y', strtotime(' +2 day'));
	else
		$next_date=date('l, F d, Y', strtotime(' +1 day'));
$template_content = str_replace('*DAY_DATE*', $next_date, $template_content);

if($cont)
{
	$htmlContent = <<<END_HTML_CONTENT
	<style>
	.dcrPreviewTable .dcrPreviewTableHeader {
	color: #000;
	padding: 4px 10px;
	/*font-size: 17px;*/
	font-size: 14px;
	background: #3487c7;
	text-transform: uppercase;
	text-align: center;
	}
	</style>
	<div style="page-break-after: always;">
$headerLogo
$template_content
</div>
$jobsitePhotoHtmlContent
END_HTML_CONTENT;
}else{
	$htmlContent = <<<END_HTML_CONTENT
$template_content
END_HTML_CONTENT;
}
return $htmlContent;
}

//to get the Edit Transmittal Dialog Box
function buildEditTransmittalDialog($database, $user_company_id, $project_id, $currently_active_contact_id, $transId){
	$db = DBI::getInstance($database);
 	$query = "SELECT * FROM transmittal_data WHERE id='$transId'";
	$db->query($query);
	
	$records = array();
	while($row = $db->fetch()){
		$records[] = $row;
	}

	$transId 	= $records[0]['id'];
	$type   	= $records[0]['transmittal_type_id'];
	$comment  	= $records[0]['comment'];

	//Attachments
	
	$attachmentQuery = "SELECT a.`attachment_file_manager_file_id`, f.`virtual_file_name`
							 FROM `file_manager_files` as f 
 						JOIN `transmittal_attachments` a  ON f.`id` = a.`attachment_file_manager_file_id` 
 						WHERE a.`transmittal_data_id` = '$transId'";
	
	$db->query($attachmentQuery);
	
	$attachmentRecords = array();
	while($attachmentRow = $db->fetch()){
		$attachmentRecords[] = $attachmentRow;
	}
		
	$attachmentIds = array();
	$attachmentHtml = '';
	$previous_attachment='';
	foreach($attachmentRecords as $attachmentRecord){
		$attachmentId = $attachmentRecord['attachment_file_manager_file_id'];
		$attachmentName = $attachmentRecord['virtual_file_name'];


		$attachmentIds[] = $attachmentId;
		$attachmentHtml .= '<li id="record_container--manage-file_manager_file-record--file_manager_files--'.$attachmentId.'" class="uploadedfile"><a href="javascript:deleteFileManagerFile(\'record_container--manage-file_manager_file-record--file_manager_files--'.$attachmentId.'\', \'manage-file_manager_file-record\', \''.$attachmentId.'\');update_file_data(\''.$attachmentName.'\',\''.$attachmentId.'\');">X</a>&nbsp;<a target="_blank" href="//beta.myfulcrum.com/_'.$attachmentId.'">'.$attachmentName.'</a></li>';
		$previous_attachment .=$attachmentName.',';
	}
	$previous_attachment=rtrim($previous_attachment,',');

	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}


	if (!isset($arrRequestForInformationDraftAttachments) || count($arrRequestForInformationDraftAttachments) == 0) {
		$liRequestForInformationDraftAttachments = '<li class="placeholder">No Files Attached</li>';
	}

	// FileManagerFolder
	$virtual_file_path = '/Transmittals/Attachments/';
	$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $virtual_file_path);
	/* @var $rfiFileManagerFolder FileManagerFolder */

	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record';
	$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Transmittals/Attachments/';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadRequestForInformationAttachment';
	$input->allowed_extensions = 'pdf,jpg,jpeg,doc,docx,png,gif,xlsx,csv,xls,rtf';
	$input->post_upload_js_callback = "RFIs__rfiDraftAttachmentUploaded(arrFileManagerFiles, 'container--request_for_information_attachments--create-request_for_information-record')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();
	/*load membre by roles*/
	// 10 sub contractor
	// 3 user
	// 5 project manager 
	// 4 project excutive
	$rolesMemID = '10';

	$arrProjectTeamMembers = Contact::loadProjectTeamMembers($database, $project_id);

	
	$userTypes = loadTransmittalType();
	
	$userTypes = array('' => 'Select') + $userTypes;

	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_usertype_id--$dummyId";
	$js = 'id="transmittal_type_select" class="target moduleRFI_dropdown4 required" ';
	$ddlProjectTeamListId = "transmital_type";
	$ddlProjectTeamList = PageComponents::dropDownList($ddlProjectTeamListId, $userTypes, $type, null, $js, null);

	$sourcelist = PageComponents::dropDownList('source_id', $source_arr, $source, null, null, null);
	
	//For email Filter option
	$emailfilter = array('0'=>'All','1'=>'Roles','2'=>'Company');
	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_emailfilter_id--$dummyId";
	$js = 'id="emailfilter" class="target moduleRFI_dropdown4 required" onchange="emailfilters(this.id,this.value)"  ';
	$emailfilterId = "emailfilter";

	$emailfilterList = PageComponents::dropDownList($emailfilterId, $emailfilter, '', null, $js, null);
	//For roles 
	$projectrole = projectroles($database);
	$projectrole = array('' => 'Select a Role') + $projectrole;
	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_projectrole_id--$dummyId";
	$js = 'id="project_role" class="target moduleRFI_dropdown4 required" style="display:none;" onchange="emailroles(this.value)"';
	$projectroleListId = "project_role";
	$projectroleList = PageComponents::dropDownList($projectroleListId, $projectrole, '', null, $js, null);
	//For Company 
	$projectCompany = projectCompany($project_id);
	$projectCompany = array('' => 'Select a Company') + $projectCompany;
	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_projectrole_id--$dummyId";
	$js = 'id="project_company" class="target moduleRFI_dropdown4 required" style="display:none;" onchange="emailcompany(this.value)" ';
	$projectCompanyId = "projectCompany";
	$projectCompanyList = PageComponents::dropDownList($projectCompanyId, $projectCompany, '', null, $js, null);

	// Cc:
	// rfi_additional_recipient_contact_id
	// To:
	// rfi_recipient_contact_id
	$rfiDraftsHiddenProjectTeamMembersToElementId = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_contact_id--$dummyId";
	$js = ' class="moduleRFI_dropdown4 required to_contact" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$rfiDraftsHiddenProjectTeamMembersToElementId.'\');"';
	$prependedOption = '<option value="">Select a contact</option>';
	$ddlProjectTeamMembersToId = "ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--$dummyId";
	$ddlProjectTeamMembersTo = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersToId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', $selectedOption, null, $js, $prependedOption);
	$ddlProjectTeamMembersCcId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Cc-$dummyId";
	$js = ' onchange="Transmittals__addRecipient(this);" class="moduleRFI_dropdown4 cc_contact"';
	$ddlProjectTeamMembersCc = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersCcId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);
	// Bcc:
	$ddlProjectTeamMembersBccId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Bcc-$dummyId";
	$ddlProjectTeamMembersBcc = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersBccId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);

	$rfi_attachment_source_contact_id = $currently_active_contact_id;
	$rfi_creator_contact_id = $currently_active_contact_id;

	$htmlContent = <<<END_HTML_CONTENT

<form name="formCreateTransmittal" id="formCreateTransmittal" >
	<div id="record_creation_form_container--create-request_for_information-record--">
		<div class="RFI_table_create">
			<table width="100%" cellspacing="0" cellpadding="4" border="0">
				<tbody>
					<input type="hidden" id="TransmittalId" value="$transId" />
					<input type="hidden" id="file_attachement_id" value="" />
					<input type="hidden" id="previous_attachment" value="$previous_attachment" />
					<input type="hidden" id="type_id" value="$type" />
					<tr>
						<td width="70%" class="RFI_table_header2" colspan="3">Type</td>
					</tr>
					<tr>
						<td class="RFI_table2_content font_serif required" colspan="3">
						$ddlProjectTeamList
						</td>
					</tr>
					<tr>
						<td class="RFI_table_header2 required" colspan="3">Comments</td>
					</tr>
					<tr>
						<td class="RFI_table2_content" colspan="3">
							<p><textarea class="RFI_table2 required target" id="comments">$comment</textarea></p>
						</td>
					<tr>
				</tbody>
			</table>
		</div>
		<div class="RFI_table_create margin0px">
			<table width="100%" cellspacing="0" cellpadding="4" border="0">
				<tbody>
					<tr>
						<td width="70%" class="RFI_table_header2" colspan="3">Select A File To Attach:</td>
					</tr>
					<tr>
						<td class="RFI_table2_content" colspan="3">{$fileUploader}{$fileUploaderProgressWindow}</td>
					</tr>
					<tr>
						<td class="RFI_table_header2" colspan="3">Attached Files:</td>
					</tr>
					<tr>
						<td id="tdAttachedFilesList" class="RFI_table2_content" colspan="3">
							<ul style="list-style:none; margin:0; padding:0" id="container--request_for_information_attachments--create-request_for_information-record">
								<li class="placeholder">No Files Attached</li>
								$attachmentHtml
							</ul>
						</td>
					</tr>
					<tr>
						<td width="70%" class="RFI_table_header2" colspan="3">Filter To Select Email Id(s)</td>
					</tr>
					<tr>
						<td class="RFI_table2_content font_serif required border_right_none">
						$emailfilterList
						</td>
						<td class="RFI_table2_content font_serif required border_right_none" >
						$projectroleList
						</td>
						<td class="RFI_table2_content font_serif required border_right_none" >
						$projectCompanyList
						</td>
					</tr>
					<tr>
						<td style="vertical-align: middle;" class="RFI_table_header2" colspan="3">Email:</td>
					</tr>
					<tr>
						<td class="RFI_table2_content" colspan="3">
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
								<input type="button" style="font-size: 10pt;" onclick="Transmittal__createTransmittalViaPromiseChain('$dummyId','1');" value="Save and Email Transmittal">&nbsp;
							</p>
							<span class="fakeHref verticalAlignBottom" onclick="showHideDomElement('rfi_draft_help');">(?)</span><span id="rfi_draft_help" class="displayNone verticalAlignBottom"> Note: Saving the Email Transmittal will save your files and the Email To, but not the Email Cc, Bcc, or message..</span>
						</td>
					</tr>
				</tbody>
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

// To get all the types For Transmittal
	function loadTransmittalType($database){
		$db = DBI::getInstance($database);
		$TransmittalTypes = array();
        $query = "SELECT * FROM transmittal_types where disabled_flag='N'";
        $db->execute($query);
		while($row = $db->fetch())
		{
		   	$key = $row['id'];
		   	$val = $row['transmittal_category'];
		   	$TransmittalTypes[$key] = $val;
		}
		return $TransmittalTypes;

	}
	// To get all the types For Transmittal
	function ContactName($database,$raised_by){
		$db = DBI::getInstance($database);
		$first_name = $isMultiple = '';
		$multiplefirstname_arr = array();
		$wherCond = " id='$raised_by'";
		$commaInd = strpos($raised_by, ',');
		$underScoreInd = strpos($raised_by, '_');
		if($commaInd && !$underScoreInd){
			$wherCond = " id IN ($raised_by)";
			$isMultiple = 1;
		}
		if ($commaInd && $underScoreInd) {
			$raised_id = substr($raised_by, 0, $underScoreInd-1);
			$wherCond = " id IN ($raised_id)";
			$isMultiple = 1;
		}
        $query = "SELECT * FROM contacts WHERE ".$wherCond;
        $db->execute($query);
		while($row = $db->fetch()){
			if($row['first_name']!='' || $row['last_name']!='')
		   	$first_name = $row['first_name'].' '.$row['last_name'];
		   else
		   	$first_name = $row['email'];

		   	if ($row['is_archive'] == 'Y') {
		   		$first_name = $first_name." (Archived)";
		   	}

		   	if(!empty($isMultiple)){
		   		$multiplefirstname_arr[] = $first_name;
		   	}
		   	
		}
		$db->free_result();
		$hasUnder = 0;
		if ($underScoreInd === 0) {
			$non_cont_by = $raised_by;
			$hasUnder = 1;
		}
		if ($underScoreInd) {
			$non_cont_by = substr($raised_by, $underScoreInd);
			$hasUnder = 1;
		}		
		if ($hasUnder) {
			
			$non_cont = str_replace('_', '', $non_cont_by);
			$wherCon = " id IN ($non_cont)";
			$isMultiple = 1;			
			$query = "SELECT * FROM non_contact_person WHERE ".$wherCon;
        	$db->execute($query);
        	while($row = $db->fetch()){ 
        		if(!empty($isMultiple)){       		
        			$multiplefirstname_arr[] = $row['email'];
        		}
        	}	
        	$db->free_result();	
		}
		if(!empty($isMultiple)){
			$first_name = implode(', ',$multiplefirstname_arr);
		}
		return $first_name;

	}

	// To get all the types For Transmittal
	function ContactCompanyName($database,$raised_by){
		$db = DBI::getInstance($database);
		$compName = $isMultiple = '';
		$multipleCompName_arr = array();
		$wherCond = " c.id='$raised_by'";
		$commaInd = strpos($raised_by, ',');
		$underScoreInd = strpos($raised_by, '_');
		if($commaInd && !$underScoreInd){
			$wherCond = " c.id IN ($raised_by)";
			$isMultiple = 1;
		}
		if ($commaInd && $underScoreInd) {
			$raised_id = substr($raised_by, 0, $underScoreInd-1);
			$wherCond = " c.id IN ($raised_id)";
			$isMultiple = 1;
		}
        $query = "SELECT cc.`id` as comp_id, cc.`user_user_company_id`, cc.`contact_user_company_id`, cc.`company`, cc.`primary_phone_number`, c.* FROM contacts as c inner join contact_companies as cc on c.contact_company_id = cc.id  where".$wherCond;
        $db->execute($query);
		while($row = $db->fetch()){
			
		   	$compName = $row['company'];

		   	if(!empty($isMultiple)){
		   		$multipleCompName_arr[] = $compName;
		   	}
		   	
		}
		$db->free_result();
		
		if(!empty($isMultiple)){
			$compName = implode(', ',array_unique($multipleCompName_arr));
		}
		return $compName;

	}

	//To convert a PDF to TEXT
	function pdfdata($tempFilePath)
	{
	 $source_pdf=$tempFilePath;
	$output_folder="TransmittalTemp";

	if (!file_exists($output_folder)) { mkdir($output_folder, 0777, true);}
	$a= passthru("pdftohtml $source_pdf $output_folder/new",$b);
	$directory = opendir($output_folder);
 	while(($file = readdir($directory)) != false)
	{
		chmod($file, 0777);
	}
		

	$content= file_get_contents("TransmittalTemp/news.html");
	$content= html_entity_decode($content);
    $content = mb_convert_encoding($content, "HTML-ENTITIES", "UTF-8");
    $content =preg_replace("/(<br\s*\/?>\s*)+/", "<br/>", $content);

	return  $content;
	}
	//To get all Project Roles
	function projectroles($database)
	{
		$db = DBI::getInstance($database);
		$projectroles = array();
        $query = "SELECT rg2r.`role_alias`, r.* FROM `roles` r INNER JOIN `role_groups_to_roles` rg2r ON r.`id` = rg2r.`role_id` INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id` WHERE rg.`role_group` ='project_roles' and r.`id`!='3' ORDER BY r.`sort_order` ASC, r.`role` ASC ";
        $db->execute($query);
		while($row = $db->fetch())
		{
		   	$key = $row['id'];
		   	$val = $row['role'];
		   	$projectroles[$key] = $val;
		}
		return $projectroles;
		

	}
	//To get all the team members Project Company 

	function projectCompany($project_id)
	{

		$db = DBI::getInstance($database);
		$contact_ids = '';
        $query = "SELECT p2c2r.`contact_id`, p2c2r.`role_id` FROM `projects_to_contacts_to_roles` p2c2r INNER JOIN `role_groups_to_roles` rg2r ON p2c2r.`role_id` = rg2r.`role_id` INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id` WHERE p2c2r.`project_id` = $project_id AND p2c2r.`role_id`!='3'  ";

        $db->execute($query);
		while($row = $db->fetch())
		{
		   	$val = $row['contact_id'];
		   	$contact_ids .= $val.',';
		}
		$contact_ids=rtrim($contact_ids,',');
		$company=array();
		$query1 = "SELECT c.*, cc.*, ui.*, c.`id` as 'contact_id', cc.`id` as 'contact_company_id', ui.`id` as 'user_invitation_id', c.`user_id` AS 'contact_user_id', ui.`user_id` as 'user_invitation_user_id', ui.`created` as 'ui_created' FROM `contacts` c INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id` LEFT OUTER JOIN `user_invitations` ui ON c.`id` = ui.`contact_id` WHERE c.`id` IN ($contact_ids) ORDER BY company ASC, first_name ASC, last_name ASC";

        $db->execute($query1);
		while($row1 = $db->fetch())
		{
		   	
		   	$key = $row1['contact_company_id'];
		   	$val = $row1['company'];
		   	$company[$key] = $val;
		   	
		}
		
		 return $company;
		

	}

	//To get all the team members Project Company who are not bidder and has only user role also

	function companyWithoutBidder($project_id, $database)
	{

		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
		$AXIS_USER_ROLE_ID_BIDDER = AXIS_USER_ROLE_ID_BIDDER;

		$arrContactTeamMembers = array();	

		$db = DBI::getInstance($database);
		$contact_ids = '';
        $query = "SELECT p2c2r.`contact_id` FROM `projects_to_contacts_to_roles` p2c2r INNER JOIN `role_groups_to_roles` rg2r ON p2c2r.`role_id` = rg2r.`role_id` INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id` WHERE p2c2r.`project_id` = $project_id";

        $db->execute($query);
		while($row = $db->fetch())
		{
		   	$val = $row['contact_id'];
		   	$arrContactTeamMembers[$val]=$row;
		}

		$db->free_result();

		foreach ($arrContactTeamMembers as  $value) {
			$quer1="SELECT GROUP_CONCAT(`role_id`) as role_id FROM `projects_to_contacts_to_roles` WHERE `project_id` = ? AND `contact_id` = ?";
			$arrMoudle = array($project_id,$value['contact_id']);
			$db->execute($quer1, $arrMoudle);
			$roleIds = $db->fetch();
			$db->free_result();
			$role = explode(',', $roleIds['role_id']);
			if (in_array($AXIS_USER_ROLE_ID_USER, $role) && in_array($AXIS_USER_ROLE_ID_BIDDER, $role) && count($role) == 2) {
				unset($arrContactTeamMembers[$value['contact_id']]);
			}else{
				$contact_ids .= $value['contact_id'].',';
			}
		}

		$contact_ids=rtrim($contact_ids,',');
		$company=array();
		$query1 = "SELECT c.*, cc.*, ui.*, c.`id` as 'contact_id', cc.`id` as 'contact_company_id', ui.`id` as 'user_invitation_id', c.`user_id` AS 'contact_user_id', ui.`user_id` as 'user_invitation_user_id', ui.`created` as 'ui_created' FROM `contacts` c INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id` LEFT OUTER JOIN `user_invitations` ui ON c.`id` = ui.`contact_id` WHERE c.`id` IN ($contact_ids) ORDER BY company ASC, first_name ASC, last_name ASC";

        $db->execute($query1);
		while($row1 = $db->fetch())
		{
		   	
		   	$key = $row1['contact_company_id'];
		   	$val = $row1['company'];
		   	$company[$key] = $val;
		   	
		}		
		return $company;
	}

	//Pdf generation for RFI
	function buildRFIPdfConversion($database,$userCompanyId,$TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$request_for_information_id,$mailFlag = false){ 

	$projectName = strtoupper(trim($projectName));

	$db = DBI::getInstance($database);
	
	$query = "SELECT td.*, tt.transmittal_category, tat.template_content FROM transmittal_data AS td
 	INNER JOIN transmittal_types AS tt ON td.transmittal_type_id = tt.id
 	INNER JOIN transmittal_admin_templates AS tat ON tat.template_type_id = tt.id
 	WHERE td.id='$TransmittalId'";
	$db->query($query);
	
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}

	$emailTo   = $records[0]['mail_to'];
	$entity_id = $records[0]['contracting_entity_id'];

	$template_content = $records[0]['template_content'];
	$emailToInfo = Contact::findContactById($database,$emailTo);
	

	$toName = $emailToInfo['first_name'].' '.$emailToInfo['last_name'];
	$toName = strtoupper(trim($toName));
	if($toName == ' ' || $toName == '')
		$toName = $emailToInfo['email'];
	$toCompanyId = $emailToInfo['contact_company_id'];

	$usercontactCompany = ContactCompany::findById($database, $toCompanyId);
	$touserCompanyName = strtoupper($usercontactCompany->contact_company_name);

	
	// Login User Company Details	

	$fromuserCompanyInfo = UserCompany::findById($database, $userCompanyId);
	$fromuserCompanyName = strtoupper(trim($fromuserCompanyInfo->user_company_name));	

	// Login User Details
	
	$fromuserInfo = Contact::findContactByUserCompanyIdAndUserId($database,$userCompanyId ,$userId);

	$fromUsername = $fromuserInfo['first_name'].' '.$fromuserInfo['last_name'];
	$fromEmail = $fromuserInfo['email'];

	$fromUsername = strtoupper(trim($fromUsername));
	$fromEmail = strtoupper(trim($fromEmail));

	if($fromUsername == ' ' || $fromUsername == '')
		$fromUsername = $fromuserInfo['email'];

	$regardsUsername = ucfirst($fromuserInfo['first_name']).' '.ucfirst($fromuserInfo['last_name']);
	$regardsEmail = ucfirst(trim($fromuserInfo['email']));
	
	$fromuserContactId = $fromuserInfo->contact_id;
	
	$contactPhoneInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$fromuserContactId,'1');
	
	if($contactPhoneInfo)
		$contactPhoneNo = '('.$contactPhoneInfo['area_code'].') '.$contactPhoneInfo['prefix'].'-'.$contactPhoneInfo['number'];
	else
		$contactPhoneNo = '&nbsp;';
	
	$contactFaxInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$fromuserContactId,'2');

	if($contactFaxInfo)
		$contactFaxNo = 'Fx: ('.$contactFaxInfo['area_code'].') '.$contactFaxInfo['prefix'].'-'.$contactFaxInfo['number'];
	else
		$contactFaxNo = '&nbsp;';


	$today = date('F d, Y');
	//$delayDays Day(s) - $delayName - $delayDesc - $delayDate

	//RfI content start here
	$requestForInformation = RequestForInformation::findRequestForInformationByIdExtended($database, $request_for_information_id);
	/* @var $requestForInformation RequestForInformation */

	$rfi_sequence_number = $requestForInformation->rfi_sequence_number;

	$rfi_creator_contact_id = $requestForInformation->rfi_creator_contact_id;
	$rfi_recipient_contact_id = $requestForInformation->rfi_recipient_contact_id;

	$rfi_created = $requestForInformation->created;
	$rfi_due_date = $requestForInformation->rfi_due_date;
	$rfi_closed_date = $requestForInformation->rfi_closed_date;

	// HTML Entity Escaped Data
	$requestForInformation->htmlEntityEscapeProperties();
	$escaped_rfi_plan_page_reference = $requestForInformation->escaped_rfi_plan_page_reference;
	$escaped_rfi_statement_nl2br = $requestForInformation->escaped_rfi_statement_nl2br;
	$escaped_rfi_title = $requestForInformation->escaped_rfi_title;

	if (empty($rfi_closed_date)) {
		$rfi_closed_date = ' - ';
	}
	$rfi_created_date=explode(' ', $rfi_created);
	$rfi_created=$rfi_created_date[0];

	$project = $requestForInformation->getProject();
	/* @var $project Project */
	$project->htmlEntityEscapeProperties();
	$escaped_project_name = $project->escaped_project_name;

	$requestForInformationStatus = $requestForInformation->getRequestForInformationStatus();
	/* @var $requestForInformationStatus RequestForInformationStatus */
	$request_for_information_status = $requestForInformationStatus->request_for_information_status;

	$requestForInformationPriority = $requestForInformation->getRequestForInformationPriority();
	/* @var $requestForInformationPriority RequestForInformationPriority */
	$request_for_information_priority = $requestForInformationPriority->request_for_information_priority;


	$rfiCreatorContact = $requestForInformation->getRfiCreatorContact();
	/* @var $rfiCreatorContact Contact */
	$rfiCreatorContact->htmlEntityEscapeProperties();
	$rfiCreatorContactFullNameHtmlEscaped = $rfiCreatorContact->getContactFullNameHtmlEscaped();

	// Created By address

	$rfiCreatorcontactCompanyid=Contact::getcontactcompanyAddreess($database,$rfi_creator_contact_id);
	
	$rfiCreatorContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $rfiCreatorcontactCompanyid);

	if ($rfiCreatorContactCompanyOffice) {
		$twoLines = true;
		$rfiCreatorContactCompanyOfficeAddressHtmlEscaped = $rfiCreatorContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$rfiCreatorContactCompanyOfficeAddressHtmlEscaped = '';
	}

	$rfiRecipientContact = $requestForInformation->getRfiRecipientContact();
	/* @var $rfiRecipientContact Contact */
	$rfiRecipientContact->htmlEntityEscapeProperties();
	$rfiRecipientContactFullNameHtmlEscaped = $rfiRecipientContact->getContactFullNameHtmlEscaped();

	// To address

	$rfiRecipientcontactCompanyid=Contact::getcontactcompanyAddreess($database,$rfi_recipient_contact_id);
	
	$rfiRecipientContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $rfiRecipientcontactCompanyid);
	if ($rfiRecipientContactCompanyOffice) {
		$twoLines = true;
		$rfiRecipientContactCompanyOfficeAddressHtmlEscaped = $rfiRecipientContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$rfiRecipientContactCompanyOfficeAddressHtmlEscaped = '';
	}

	$loadRequestForInformationResponsesByRequestForInformationIdOptions = new Input();
	$loadRequestForInformationResponsesByRequestForInformationIdOptions->forceLoadFlag = true;
	$arrRequestForInformationResponsesByRequestForInformationId = RequestForInformationResponse::loadRequestForInformationResponsesByRequestForInformationId($database, $request_for_information_id, $loadRequestForInformationResponsesByRequestForInformationIdOptions);
	$tableRfiResponses = '';
	foreach ($arrRequestForInformationResponsesByRequestForInformationId as $request_for_information_response_id => $requestForInformationResponse ) {
		/* @var $requestForInformationResponse RequestForInformationResponse */

		$requestForInformationResponse->htmlEntityEscapeProperties();
		$request_for_information_response_created_timestamp = $requestForInformationResponse->created;
		$escaped_request_for_information_response_nl2br = $requestForInformationResponse->escaped_request_for_information_response_nl2br;

		$rfiResponseCreatedTimestampInt = strtotime($request_for_information_response_created_timestamp);
		$rfiResponseCreatedTimestampDisplayString = date('n/j/Y g:ia', $rfiResponseCreatedTimestampInt);

		$rfiResponderContact = $requestForInformationResponse->getRfiResponderContact();
		/* @var $rfiResponderContact Contact */

		$rfiResponderContact->htmlEntityEscapeProperties();

		$rfiResponderContactFullNameHtmlEscaped = $rfiResponderContact->getContactFullNameHtmlEscaped();
		$rfi_responder_contact_escaped_title = $rfiResponderContact->escaped_title;

		$responseHeaderInfo = "Answered $rfiResponseCreatedTimestampDisplayString by $rfiResponderContactFullNameHtmlEscaped ($rfi_responder_contact_escaped_title)";

		// #d1d1d1
		// #bbb
		$tableRfiResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="RFI_table2_content">
				$responseHeaderInfo
				<div style="border: 1px solid #d1d1d1; font-size: 13px;">$escaped_request_for_information_response_nl2br</div>
				<br>
			</td>
		</tr>
END_HTML_CONTENT;

	}
	if ($tableRfiResponses == '') {

		$tableRfiResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="RFI_table2_content">No answers.</td>
		</tr>
END_HTML_CONTENT;

	}
	
	
//RfI content Ends here
if($mailFlag == true){
	/*GC logo*/
	require_once('lib/common/Logo.php');
	
	$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$userCompanyId, true);
	$fulcrum = Logo::logoByFulcrum();
	$headerLogo=<<<headerLogo
	<table width="100%" class="table-header">
 <tr>
 <td>$gcLogo</td>
 <td align="right"><span style="margin-top:10px;">$fulcrum</span></td>
 </tr>
 </table>
 <hr>
headerLogo;
	/*GC logo end*/
}else{
	$headerLogo='';
}
// To include contracting entity
$EntityName = ContractingEntities::getcontractEntityNameforProject($database,$entity_id);
if(!empty($rfiCreatorContactCompanyOfficeAddressHtmlEscaped)){
	$rfiCreatorContactCompanyOfficeAddressHtmlEscaped = $EntityName."<br/>".$rfiCreatorContactCompanyOfficeAddressHtmlEscaped;
}else{
	$rfiCreatorContactCompanyOfficeAddressHtmlEscaped = $EntityName;
}


/*string replace with dynamic template content to transmittal admin*/
//CompanyName
$template_content = str_replace('*COMPANY_NAME*', $EntityName, $template_content);
// RecipientCompanyName
$template_content = str_replace('*RECIPIENT_COMPANY_NAME*', $touserCompanyName, $template_content);
// To Company name
$template_content = str_replace('*TO_COMPANY_NAME*', $touserCompanyName, $template_content);
// ProjectNmae
$template_content = str_replace('*PROJECT_NAME*', $projectName, $template_content);
// To Recipient
$template_content = str_replace('*TO_ADDRESS_OR_TO_NAME*', $toName, $template_content);
// From recipient
$template_content = str_replace('*FROM_ADDRESS_OR_FROM_NAME*', $fromUsername, $template_content);
// DATE_TIME
$template_content = str_replace('*DATE_TIME*', $today, $template_content);
// page count of pdf
$template_content = str_replace('*PAGE_COUNT*', $pdf_total_num, $template_content);
// phone no
$template_content = str_replace('*FROM_PHONE_NO*', $contactPhoneNo, $template_content);
// fax no
$template_content = str_replace('*FROM_FAX_NO*', $contactFaxNo, $template_content);
// regards from name
$template_content = str_replace('*FROM_NAME*', $regardsUsername, $template_content);
// regards from mail
$template_content = str_replace('*FROM_ADDRESS*', $regardsEmail, $template_content);
// Comments
$template_content = str_replace('*COMMENTS*', $comment, $template_content);
// Mail Comments
$template_content = str_replace('*MAIL_CONTENT*', $mailText, $template_content);
// RFI category
$template_content = str_replace('*RFI_DESCRIPTION*', $escaped_rfi_title, $template_content);
// RFI sequence no
$template_content = str_replace('*RFI_SEQUENCES_ID*', $rfi_sequence_number, $template_content);
// Days
$cur_date=date('l');
	if($cur_date=='Friday')
		$next_date=date('l, F d, Y', strtotime(' +3 day'));
	else if($cur_date=='Saturday')
		$next_date=date('l, F d, Y', strtotime(' +2 day'));
	else
		$next_date=date('l, F d, Y', strtotime(' +1 day'));
$template_content = str_replace('*DAY_DATE*', $next_date, $template_content);

if($mailFlag)
{
	$htmlContent .= <<<END_HTML_CONTENT
$headerLogo
$template_content
END_HTML_CONTENT;
}else{
	$htmlContent .= <<<END_HTML_CONTENT
$template_content
END_HTML_CONTENT;
}
$htmlContent .= <<<END_HTML_CONTENT
				<div class="pb_before" style="page-break-before: always;"></div>
END_HTML_CONTENT;

$htmlContent .= <<<END_HTML_CONTENT
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Untitled Document</title>
	<link href="{$uri->http}css/styles.css" rel="stylesheet" type="text/css">
	<link href="{$uri->http}css/modules-requests-for-information-pdf.css" rel="stylesheet" type="text/css">
	<style>
	@page{
		margin: 20px 50px 80px 50px;
	}
	</style>
</head>
<body>
$headerLogo
	<div id="" style="font-family: Helvetica,sans;">
		<span class="highlight"><b>$escaped_project_name - Request for Information</b></span>
		<table border="0" cellspacing="0" width="100%" cellpadding="4" class="RFIDesc">
			<tr>
				<td class="thhighlight textAlignLeft"  width="10%">Description  </td>
				<td width="2%">:</td>
				<td class="textAlignLeft thhighlight">$escaped_rfi_title</td>
				<td style="" class="thhighlight textAlignLeft" width="15%" >RFI Number</td>
				<td width="2%">:</td>
				<td width="20%" class="textAlignLeft thhighlight">$rfi_sequence_number</td>
			</tr>
			<tr>
				<td class="thhighlight textAlignLeft" >Priority</td>
				<td width="2%">:</td>
				<td class="textAlignLeft thhighlight">$request_for_information_priority</td>
				<td class="thhighlight textAlignLeft"  >Due Date</td>
				<td width="2%">:</td>
				<td class="textAlignLeft thhighlight">$rfi_due_date</td>
			</tr>
			<tr>
				<td class="thhighlight textAlignLeft" >Plan Ref </td>
				<td width="2%">:</td>
				<td class="textAlignLeft thhighlight">$escaped_rfi_plan_page_reference</td>
				<td class="thhighlight textAlignLeft" style="font-size:12px;" >Opened Date </td>
				<td width="2%">:</td>
				<td class="textAlignLeft thhighlight">$rfi_created</td>
			</tr>
			<tr>
				<td class="thhighlight textAlignLeft" >Status</td>
				<td width="2%">:</td>
				<td class="textAlignLeft thhighlight">$request_for_information_status</td>
				<td class="thhighlight textAlignLeft" style="font-size:12px;" >Closed Date </td>
				<td width="2%">:</td>
				<td class="textAlignLeft thhighlight">$rfi_closed_date</td>
			</tr>
		</table>
		<hr>
		<div style="margin: 15px 0;">
			<table border="0" cellpadding="2" cellspacing="0" width="100%">
				<tr>
					<td class="thhightlightColortd" ><span class="thhightlightColor">Created By :</span></td>
					<td class="thhightlightColortd" ><span class="thhightlightColor">To :</span></td>				
				</tr>
				<tr>
					<td style="font-size:12px;" nowrap>$rfiCreatorContactFullNameHtmlEscaped</td>
					<td style="font-size:12px;" nowrap>$rfiRecipientContactFullNameHtmlEscaped</td>	
				</tr>
				<tr>
					<td style="font-size:12px;" nowrap>$rfiCreatorContactCompanyOfficeAddressHtmlEscaped</td>
					<td style="font-size:12px;" nowrap>$rfiRecipientContactCompanyOfficeAddressHtmlEscaped</td>					
				</tr>
			</table>
		</div>
		<div>
			<div class="topicHeader">Question</div>
			<div class="topicHeaderIn"><p class="plinkTag">$escaped_rfi_statement_nl2br</p></div>
		</div>
		<div>
			<div class="topicHeaderanswer">Answer(s)</div>
			<div style="background: #f0f0f0; padding: 0 15px;">
				<table width="100%">
					$tableRfiResponses
				</table>
			</div>
		</div>
	</div>
</body>
</html>



END_HTML_CONTENT;

return $htmlContent;


	}
	//Pdf generation for All
	function buildPdfConversion($database,$userCompanyId,$TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$address_id,$contentType,$emailIds,$mailFlag = false,$headerLogo = ''){

	
	$projectName = strtoupper(trim($projectName));
	$projectInfo = Project::findById($database,$projectId);

	$db = DBI::getInstance($database);
	$mailText = isset($mailText) ? $mailText : '';
	$comment = isset($comment) ? $comment : '';

	
	
	$query = "SELECT td.*, tt.transmittal_category, tat.template_content FROM transmittal_data AS td
 	INNER JOIN transmittal_types AS tt ON td.transmittal_type_id = tt.id
 	INNER JOIN transmittal_admin_templates AS tat ON tat.template_type_id = tt.id
 	WHERE td.id='$TransmittalId'";

 	
	$db->query($query);
	
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}

	$emailTo   = $records[0]['mail_to'];
	$entity_id = $records[0]['contracting_entity_id'];
	
	
	$template_content = $records[0]['template_content'];
	
	$emailToInfo = Contact::findContactById($database,$emailTo);
	

	$toName = $emailToInfo['first_name'].' '.$emailToInfo['last_name'];
	$toName = strtoupper(trim($toName));
	if($toName == ' ' || $toName == '')
		$toName = $emailToInfo['email'];
	if($contentType=='Bid')
    {
    	 $mailToQuery = "SELECT group_concat(email SEPARATOR ', ') as email FROM contacts where id IN ($emailIds)";
    	 $db->execute($mailToQuery);
		while($row1 = $db->fetch())
		{
			$toName = $row1['email'];
		}
    }
	$contactCompany = ContactCompany::findById($database, $userCompanyId);

	
	// Login User Company Details	

	$fromuserCompanyInfo = UserCompany::findById($database, $userCompanyId);
	$fromuserCompanyName = strtoupper(trim($fromuserCompanyInfo->user_company_name));	

	// Login User Details
	
	$fromuserInfo = Contact::findContactByUserCompanyIdAndUserId($database,$userCompanyId ,$userId);

	$fromUsername = $fromuserInfo['first_name'].' '.$fromuserInfo['last_name'];
	$fromEmail = $fromuserInfo['email'];

	$fromUsername = strtoupper(trim($fromUsername));
	$fromEmail = strtoupper(trim($fromEmail));

	if($fromUsername == ' ' || $fromUsername == '')
		$fromUsername = $fromuserInfo['email'];

	$regardsUsername = ucfirst($fromuserInfo['first_name']).' '.ucfirst($fromuserInfo['last_name']);
	$regardsEmail = ucfirst(trim($fromuserInfo['email']));
	
	$fromuserContactId = $fromuserInfo->contact_id;
	
	$contactPhoneInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$fromuserContactId,'1');
	
	if($contactPhoneInfo)
		$contactPhoneNo = '('.$contactPhoneInfo['area_code'].') '.$contactPhoneInfo['prefix'].'-'.$contactPhoneInfo['number'];
	else
		$contactPhoneNo = '&nbsp;';
	
	$contactFaxInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$fromuserContactId,'2');

	if($contactFaxInfo)
		$contactFaxNo = 'Fx: ('.$contactFaxInfo['area_code'].') '.$contactFaxInfo['prefix'].'-'.$contactFaxInfo['number'];
	else
		$contactFaxNo = '&nbsp;';


	$today = date('F d, Y');
	
if($mailFlag == false){
	$headerLogo='';
}

// To include contracting entity
$EntityName = ContractingEntities::getcontractEntityNameforProject($database,$entity_id);

/*string replace with dynamic template content to transmittal admin*/
//CompanyName
$template_content = str_replace('*COMPANY_NAME*', $EntityName, $template_content);
// ProjectNmae
$template_content = str_replace('*PROJECT_NAME*', $projectName, $template_content);
// To Recipient
$template_content = str_replace('*TO_ADDRESS_OR_TO_NAME*', $toName, $template_content);
// From recipient
$template_content = str_replace('*FROM_ADDRESS_OR_FROM_NAME*', $fromUsername, $template_content);
// DATE_TIME
$template_content = str_replace('*DATE_TIME*', $today, $template_content);
// page count of pdf
$template_content = str_replace('*PAGE_COUNT*', $pdf_total_num, $template_content);
// phone no
$template_content = str_replace('*FROM_PHONE_NO*', $contactPhoneNo, $template_content);
// fax no
$template_content = str_replace('*FROM_FAX_NO*', $contactFaxNo, $template_content);
// regards from name
$template_content = str_replace('*FROM_NAME*', $regardsUsername, $template_content);
// regards from mail
$template_content = str_replace('*FROM_ADDRESS*', $regardsEmail, $template_content);
// Comments
$template_content = str_replace('*COMMENTS*', $comment, $template_content);
// Mail Comments
$template_content = str_replace('*MAIL_CONTENT*', $mailText, $template_content);
// RFI category

// Days
$cur_date=date('l');
	if($cur_date=='Friday')
		$next_date=date('l, F d, Y', strtotime(' +3 day'));
	else if($cur_date=='Saturday')
		$next_date=date('l, F d, Y', strtotime(' +2 day'));
	else
		$next_date=date('l, F d, Y', strtotime(' +1 day'));
$template_content = str_replace('*DAY_DATE*', $next_date, $template_content);
$htmlContent = '';
if($mailFlag)
{
	$htmlContent .= <<<END_HTML_CONTENT
$headerLogo
$template_content
END_HTML_CONTENT;
}else{
	$htmlContent .= <<<END_HTML_CONTENT
$template_content
END_HTML_CONTENT;
}

return $htmlContent;
}
//To generate PDF FOR subcontractor CONTRACT EXECUTION
	function buildsubcontractorsignedPdfConversion($database,$userCompanyId,$TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$address_id,$subcontract_id,$mailFlag = false){

	
	$projectName = strtoupper(trim($projectName));
	$projectInfo = Project::findById($database,$projectId);
	$prj_address = $projectInfo['address_line_1'].', '.$projectInfo['address_city'].', '.$projectInfo['address_state_or_region'].', '.$projectInfo['address_postal_code'];
	$prj_address = trim($prj_address,', ');
	$ProjectCity  = $projectInfo['address_city'];

	$db = DBI::getInstance($database);
	$vendorAddress = '';
	$vendorCity= '';

	if($address_id!=''){
		$query_comp = "SELECT * FROM contact_company_offices  WHERE id='$address_id' ";
		$db->query($query_comp);
		
		while($row_comp = $db->fetch()){
			$vendorAddress = $row_comp['address_line_1'].','.$row_comp['address_city'].','.$row_comp['address_state_or_region'].','.$row_comp['address_postal_code'];
			$vendorCity = $row_comp['address_city'];
		}
	}
	
	

 
 	 $query = "SELECT td.*, tt.transmittal_category, tat.template_content FROM transmittal_data AS td
 	INNER JOIN transmittal_types AS tt ON td.transmittal_type_id = tt.id
 	INNER JOIN transmittal_admin_templates AS tat ON tat.template_type_id = tt.id
 	WHERE td.id='$TransmittalId'";

	$db->query($query);
	
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}

	$emailTo   = $records[0]['mail_to'];
	$entity_id = $records[0]['contracting_entity_id'];
	$type = $records[0]['transmittal_category'];
	$template_content = $records[0]['template_content'];

	$emailToInfo = Contact::findContactById($database,$emailTo);
	

	$toName = $emailToInfo['first_name'].' '.$emailToInfo['last_name'];
	$toName = strtoupper(trim($toName));
	if($toName == ' ' || $toName == '')
		$toName = $emailToInfo['email'];
	$toCompanyId = $emailToInfo['contact_company_id'];
	$contactCompany = ContactCompany::findById($database, $toCompanyId);

	$toCompanyName = strtoupper($contactCompany->contact_company_name);
	// Login User Company Details	

	$fromuserCompanyInfo = UserCompany::findById($database, $userCompanyId);
	$fromuserCompanyName = strtoupper(trim($fromuserCompanyInfo->user_company_name));
	// Login User Details
	
	$fromuserInfo = Contact::findContactByUserCompanyIdAndUserId($database,$userCompanyId ,$userId);

	$fromUsername = $fromuserInfo['first_name'].' '.$fromuserInfo['last_name'];
	$fromEmail = $fromuserInfo['email'];

	$fromUsername = strtoupper(trim($fromUsername));
	$fromEmail = strtoupper(trim($fromEmail));

	if($fromUsername == ' ' || $fromUsername == '')
		$fromUsername = $fromuserInfo['email'];

	$regardsUsername = ucfirst($fromuserInfo['first_name']).' '.ucfirst($fromuserInfo['last_name']);
	$regardsEmail = ucfirst(trim($fromuserInfo['email']));
	
	$fromuserContactId = $fromuserInfo->contact_id;
	
	$contactPhoneInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$fromuserContactId,'1');
	
	if($contactPhoneInfo)
		$contactPhoneNo = '('.$contactPhoneInfo['area_code'].') '.$contactPhoneInfo['prefix'].'-'.$contactPhoneInfo['number'];
	else
		$contactPhoneNo = '&nbsp;';
	
	$contactFaxInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$fromuserContactId,'2');

	if($contactFaxInfo)
		$contactFaxNo = 'Fx: ('.$contactFaxInfo['area_code'].') '.$contactFaxInfo['prefix'].'-'.$contactFaxInfo['number'];
	else
		$contactFaxNo = '&nbsp;';


	$today = date('F d, Y');
	//$delayDays Day(s) - $delayName - $delayDesc - $delayDate
	if($mailFlag == true){
	/*GC logo*/
	require_once('lib/common/Logo.php');
	$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$userCompanyId, true);
	$fulcrum = Logo::logoByFulcrum();
	$headerLogo=<<<headerLogo
	<table width="100%" class="table-header">
 <tr>
 <td>$gcLogo</td>
 <td align="right"><span style="margin-top:10px;">$fulcrum</span></td>
 </tr>
 </table>
 <hr>
headerLogo;
	/*GC logo end*/
}else{
	$headerLogo='';
}
//To get the subcontractor 
	$db = DBI::getInstance($database);
    $query ="SELECT  
    cc.company,s.* from subcontracts as s inner join vendors as v on s.vendor_id =v.id inner join contact_companies as cc on v.vendor_contact_company_id = cc.id  where s.id='$subcontract_id' " ;
    $db->execute($query);
    $row = $db->fetch();
    $vendor_company=$row['company'];
    $db->free_result();

	//End to get the subcontractor
	// To include contracting entity
	$EntityName = ContractingEntities::getcontractEntityNameforProject($database,$entity_id);

/*string replace with dynamic template content to transmittal admin*/
//CompanyName
$template_content = str_replace('*COMPANY_NAME*', $EntityName, $template_content);
//RecipientCompanyName
$template_content = str_replace('*RECIPIENT_COMPANY_NAME*', $toCompanyName, $template_content);
// ProjectNmae
$template_content = str_replace('*PROJECT_NAME*', $projectName, $template_content);
// To Recipient
$template_content = str_replace('*TO_ADDRESS_OR_TO_NAME*', $toName, $template_content);
// From recipient
$template_content = str_replace('*FROM_ADDRESS_OR_FROM_NAME*', $fromUsername, $template_content);
// DATE_TIME
$template_content = str_replace('*DATE_TIME*', $today, $template_content);
// page count of pdf
$template_content = str_replace('*PAGE_COUNT*', $pdf_total_num, $template_content);
// phone no
$template_content = str_replace('*FROM_PHONE_NO*', $contactPhoneNo, $template_content);
// fax no
$template_content = str_replace('*FROM_FAX_NO*', $contactFaxNo, $template_content);
// regards from name
$template_content = str_replace('*FROM_NAME*', $regardsUsername, $template_content);
// regards from mail
$template_content = str_replace('*FROM_ADDRESS*', $regardsEmail, $template_content);
// Comments
$template_content = str_replace('*COMMENTS*', $comment, $template_content);
// Mail Comments
$template_content = str_replace('*MAIL_CONTENT*', $mailText, $template_content);
// Vendor Address
$template_content = str_replace('*LOCATION_ADDRESS*', $vendorAddress, $template_content);
// Vendor Address
$template_content = str_replace('*LOCATION_ADDRESS*', $vendorAddress, $template_content);
// Vendor city
$template_content = str_replace('*CITY_NAME*', $vendorCity, $template_content);
// Vendor Company
$template_content = str_replace('*VENDOR_COMPANY*', $vendor_company, $template_content);
// Project Address
$template_content = str_replace('*PROJECT_ADDRESS*', $prj_address, $template_content);
// Project City Name
$template_content = str_replace('*PROJECT_CITY_NAME*', $ProjectCity, $template_content);
// Days
$cur_date=date('l');
if($cur_date=='Friday')
	$next_date=date('l, F d, Y', strtotime(' +3 day'));
else if($cur_date=='Saturday')
	$next_date=date('l, F d, Y', strtotime(' +2 day'));
else
	$next_date=date('l, F d, Y', strtotime(' +1 day'));
$template_content = str_replace('*DAY_DATE*', $next_date, $template_content);


if($mailFlag)
{
	$htmlContent .= <<<END_HTML_CONTENT
$headerLogo
$template_content
END_HTML_CONTENT;
}else{
	$htmlContent .= <<<END_HTML_CONTENT
$template_content
END_HTML_CONTENT;
}

return $htmlContent;
}
//To generate PDF FOR subcontractor CONTRACT Creation

	function buildsubcontractorPdfConversion($database,$userCompanyId,$TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$address_id,$subcontract_id,$mailFlag = false){

	
	$projectName = strtoupper(trim($projectName));
	$projectInfo = Project::findById($database,$projectId);
	$prj_address = $projectInfo['address_line_1'].', '.$projectInfo['address_city'].', '.$projectInfo['address_state_or_region'].', '.$projectInfo['address_postal_code'];
	$prj_address = trim($prj_address,', ');
	$ProjectCity = $projectInfo['address_city'];
	$db = DBI::getInstance($database);
	$vendorAddress = '';
	$vendorCity= '';

	if($address_id!='')
	{
		$query_comp = "SELECT * FROM contact_company_offices  WHERE id='$address_id' ";
		$db->query($query_comp);
		
		while($row_comp = $db->fetch()){
			$vendorAddress = $row_comp['address_line_1'].','.$row_comp['address_city'].','.$row_comp['address_state_or_region'].','.$row_comp['address_postal_code'];
			$vendorCity = $row_comp['address_city'];
		}
	}
	
	$query = "SELECT td.*, tt.transmittal_category, tat.template_content FROM transmittal_data AS td
 	INNER JOIN transmittal_types AS tt ON td.transmittal_type_id = tt.id
 	INNER JOIN transmittal_admin_templates AS tat ON tat.template_type_id = tt.id
 	WHERE td.id='$TransmittalId'";

	$db->query($query);
	
	$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}

	$emailTo   = $records[0]['mail_to'];
	$entity_id = $records[0]['contracting_entity_id'];
	$template_content = $records[0]['template_content'];
	$emailToInfo = Contact::findContactById($database,$emailTo);
	

	$toName = $emailToInfo['first_name'].' '.$emailToInfo['last_name'];
	$toName = strtoupper(trim($toName));
	if($toName == ' ' || $toName == '')
		$toName = $emailToInfo['email'];
	$toCompanyId = $emailToInfo['contact_company_id'];
	$contactCompany = ContactCompany::findById($database, $toCompanyId);
	$toCompanyName = strtoupper($contactCompany->contact_company_name);

	// Login User Company Details	

	$fromuserCompanyInfo = UserCompany::findById($database, $userCompanyId);
	$fromuserCompanyName = strtoupper(trim($fromuserCompanyInfo->user_company_name));

	// Login User Details
	
	$fromuserInfo = Contact::findContactByUserCompanyIdAndUserId($database,$userCompanyId ,$userId);

	$fromUsername = $fromuserInfo['first_name'].' '.$fromuserInfo['last_name'];
	$fromEmail = $fromuserInfo['email'];

	$fromUsername = strtoupper(trim($fromUsername));
	$fromEmail = strtoupper(trim($fromEmail));

	if($fromUsername == ' ' || $fromUsername == '')
		$fromUsername = $fromuserInfo['email'];

	$regardsUsername = ucfirst($fromuserInfo['first_name']).' '.ucfirst($fromuserInfo['last_name']);
	$regardsEmail = ucfirst(trim($fromuserInfo['email']));
	
	$fromuserContactId = $fromuserInfo->contact_id;
	
	$contactPhoneInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$fromuserContactId,'1');
	
	if($contactPhoneInfo)
		$contactPhoneNo = '('.$contactPhoneInfo['area_code'].') '.$contactPhoneInfo['prefix'].'-'.$contactPhoneInfo['number'];
	else
		$contactPhoneNo = '&nbsp;';
	
	$contactFaxInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$fromuserContactId,'2');

	if($contactFaxInfo)
		$contactFaxNo = 'Fx: ('.$contactFaxInfo['area_code'].') '.$contactFaxInfo['prefix'].'-'.$contactFaxInfo['number'];
	else
		$contactFaxNo = '&nbsp;';


	$today = date('F d, Y');
	
if($mailFlag == true){
	/*GC logo*/
	require_once('lib/common/Logo.php');
	
	$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$userCompanyId, true);
	$fulcrum = Logo::logoByFulcrum();
	$headerLogo=<<<headerLogo
	<table width="100%" class="table-header">
 <tr>
 <td>$gcLogo</td>
 <td align="right"><span style="margin-top:10px;">$fulcrum</span></td>
 </tr>
 </table>
 <hr>
headerLogo;
	/*GC logo end*/
}else{
	$headerLogo='';
}

	//To get the subcontractor 
	$db = DBI::getInstance($database);
    $query ="SELECT  
    cc.company,s.* from subcontracts as s inner join vendors as v on s.vendor_id =v.id inner join contact_companies as cc on v.vendor_contact_company_id = cc.id  where s.id='$subcontract_id' " ;
    $db->execute($query);
    $row = $db->fetch();
    $vendor_company=$row['company'];
    $db->free_result();

	//End to get the subcontractor
	// To include contracting entity
$EntityName = ContractingEntities::getcontractEntityNameforProject($database,$entity_id);

/*string replace with dynamic template content to transmittal admin*/
//CompanyName
$template_content = str_replace('*COMPANY_NAME*', $EntityName, $template_content);
//RecipientCompanyName
$template_content = str_replace('*RECIPIENT_COMPANY_NAME*', $toCompanyName, $template_content);
// ProjectNmae
$template_content = str_replace('*PROJECT_NAME*', $projectName, $template_content);
// To Recipient
$template_content = str_replace('*TO_ADDRESS_OR_TO_NAME*', $toName, $template_content);
// From recipient
$template_content = str_replace('*FROM_ADDRESS_OR_FROM_NAME*', $fromUsername, $template_content);
// DATE_TIME
$template_content = str_replace('*DATE_TIME*', $today, $template_content);
// page count of pdf
$template_content = str_replace('*PAGE_COUNT*', $pdf_total_num, $template_content);
// phone no
$template_content = str_replace('*FROM_PHONE_NO*', $contactPhoneNo, $template_content);
// fax no
$template_content = str_replace('*FROM_FAX_NO*', $contactFaxNo, $template_content);
// regards from name
$template_content = str_replace('*FROM_NAME*', $regardsUsername, $template_content);
// regards from mail
$template_content = str_replace('*FROM_ADDRESS*', $regardsEmail, $template_content);
// Comments
$template_content = str_replace('*COMMENTS*', $comment, $template_content);
// Mail Comments
$template_content = str_replace('*MAIL_CONTENT*', $mailText, $template_content);
// Vendor Address
$template_content = str_replace('*LOCATION_ADDRESS*', $vendorAddress, $template_content);
// Vendor city
$template_content = str_replace('*CITY_NAME*', $vendorCity, $template_content);
// Vendor Company
$template_content = str_replace('*VENDOR_COMPANY*', $vendor_company, $template_content);
// Project Address
$template_content = str_replace('*PROJECT_ADDRESS*', $prj_address, $template_content);
// Project City Name
$template_content = str_replace('*PROJECT_CITY_NAME*', $ProjectCity, $template_content);





// Days
$cur_date=date('l');
	if($cur_date=='Friday')
		$next_date=date('l, F d, Y', strtotime(' +3 day'));
	else if($cur_date=='Saturday')
		$next_date=date('l, F d, Y', strtotime(' +2 day'));
	else
		$next_date=date('l, F d, Y', strtotime(' +1 day'));
$template_content = str_replace('*DAY_DATE*', $next_date, $template_content);

if($mailFlag)
{
	$htmlContent .= <<<END_HTML_CONTENT
$headerLogo
$template_content
END_HTML_CONTENT;
}else{
	$htmlContent .= <<<END_HTML_CONTENT
$template_content
END_HTML_CONTENT;
}
return $htmlContent;
}

/* Function to create Transmittal folder in FileManager
	address_id = vendor address Id
	type = Transmittal Type
	category= Transmittal Name
	Status = For sending mail or not
	request_for_information_id = rfi_id
	meet_cont= meeting html content

*/
	function TransmittalSCO($database, $userCompanyId, $TransmittalId,$projectId,$currentlyActiveContactId,$type,$category,$htmlContent)
	{
		$db = DBI::getInstance($database);     	// Db Initialize
		$sequenceNo = getSequenceNumberUsingTransmittalId($database, $TransmittalId);
		$virtual_file_path = 'Transmittals/Transmittal #' . $sequenceNo . '/';
        $arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
        $currentVirtualFilePath = '/';
        foreach ($arrFolders as $folder) {
            $tmpVirtualFilePath = array_shift($arrFolders);
            $currentVirtualFilePath .= $tmpVirtualFilePath.'/';
            // Save the file_manager_folders record (virtual_file_path) to the db and get the id
        }
        $fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $userCompanyId, $currentlyActiveContactId, $projectId, $currentVirtualFilePath);
         /* @var $fileManagerFolder FileManagerFolder */

        // Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
        $file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;
        $config = Zend_Registry::get('config');
        $fileManagerBasePath = $config->system->file_manager_base_path;
        $tempFileName = File::getTempFileName();
        $tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
        $fileObject = new File();
        $fileObject->mkdir($tempDir, 0777);
         // Insert the file attachements and move to virtual file path directory
        $tempFilePath='';
   	
       // make Transmittal directory for pdf upload
        $tempFileName = File::getTempFileName();
        chmod($tempDir, 0777);

        // Naming convention for pdf
        $typeName=$category;
        $cur_date=date('Y-m-d_A');
        $virtual_file_name_tmp = $typeName.$cur_date.'.pdf';

		$pdf_content = $htmlContent;
        $tempPdfFile = '_temp'.round(microtime(true)*1000).'.pdf';
       	$tempFilePath = $tempDir . $tempPdfFile;
        file_put_contents($tempFilePath, $pdf_content);
         
           
        $sha1 = sha1_file($tempFilePath);
        $size = filesize($tempFilePath);
        $fileExtension = 'pdf';
        $virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);
        $tmpFileManagerFile = new FileManagerFile($database);
        
        $tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
        $virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();
      
        $file = new File();
        $file->sha1 = $sha1;
        $file->name = $virtual_file_name;
        $file->size = $size;
        $file->type = $virtual_file_mime_type;
        $file->tempFilePath = $tempFilePath;
        $file->fileExtension = $fileExtension;
        // Save the pdf into cloud
        $query ="SELECT `id` FROM `file_locations`WHERE `file_sha1` = '$sha1'";
		$db->query($query, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && isset($row['id']) && !empty($row['id'])) {
			$file_location_id = $row['id'];
		} else {
			 $query = "INSERT INTO file_locations( `file_sha1`, `cloud_vendor`,  `file_size`,`created`) VALUES ('$sha1','Fulcrum','$size',null)";

        if($db->execute($query)){
            $file_location_id = $db->insertId; 
            
        }
		}
		$successFlag = FileManager::copyUploadedFileToBackendStorageManagerViaLocalFileSystem($file, $tempFilePath, $file_location_id);
        // save the file information to the file_manager_files db table
        $fileManagerFile = FileManagerFile::findByVirtualFileName($database, $userCompanyId, $currentlyActiveContactId, $projectId, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
        //     /* @var $fileManagerFile FileManagerFile */

        $file_manager_file_id = $fileManagerFile->file_manager_file_id;

		// Potentially update file_location_id
        if ($file_location_id <> $fileManagerFile->file_location_id) 
        {
            $fileManagerFile->file_location_id = $file_location_id;
            $data = array('file_location_id' => $file_location_id);
            $fileManagerFile->setData($data);
            $fileManagerFile->save();
        }
        // Set Permissions of the file to match the parent folder.
        $parent_file_manager_folder_id = $fileManagerFolder->getParentFolderId();
        FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
        FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);
        // Delete temp files
        $fileObject->rrmdir($tempDir);
    }


/* Function to create Transmittal folder in FileManager
	address_id = vendor address Id
	type = Transmittal Type
	category= Transmittal Name
	Status = For sending mail or not
	request_for_information_id = rfi_id
	meet_cont= meeting html content

*/
	function TransmittalMeetings($database, $userCompanyId, $TransmittalId,$projectName,$projectId,$userId,$currentlyActiveContactId,$type,$category,$htmlContent)
	{
		$db = DBI::getInstance($database);     	// Db Initialize
		$sequenceNo = getSequenceNumberUsingTransmittalId($database, $TransmittalId);
		$virtual_file_path = 'Transmittals/Transmittal #' . $sequenceNo . '/';
        $arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
        $currentVirtualFilePath = '/';
        foreach ($arrFolders as $folder) {
            $tmpVirtualFilePath = array_shift($arrFolders);
            $currentVirtualFilePath .= $tmpVirtualFilePath.'/';
            // Save the file_manager_folders record (virtual_file_path) to the db and get the id
        }
        $fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $userCompanyId, $currentlyActiveContactId, $projectId, $currentVirtualFilePath);
         /* @var $fileManagerFolder FileManagerFolder */

        // Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
        $file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;
        $config = Zend_Registry::get('config');
        $fileManagerBasePath = $config->system->file_manager_base_path;
        $tempFileName = File::getTempFileName();
        $tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
        $fileObject = new File();
        $fileObject->mkdir($tempDir, 0777);
         // Insert the file attachements and move to virtual file path directory
        $tempFilePath='';
   	
       // make Transmittal directory for pdf upload
        $tempFileName = File::getTempFileName();
        chmod($tempDir, 0777);

        // Naming convention for pdf
        $typeName=$category;
        $cur_date=date('Y-m-d_A');
        $virtual_file_name_tmp = $typeName.$cur_date.'.pdf';
			
			$timedate=date('m/d/Y h:i a', time());
			require_once('module-report-meeting-functions.php');
			/*html content with header*/
			$htmlContentWHeader = meetingDataHeaderfortransmittal($database, $userCompanyId, $projectName, "Meetings", $htmlContent);
			// Build the HTML for the RFI pdf document (html to pdf via DOMPDF)
			$htmlContent = html_entity_decode($htmlContentWHeader);
			$htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");

        // Write RFI to temp folder as a pdf document
			$dompdf = new DOMPDF();
			$dompdf->load_html($htmlContent);
			$dompdf->set_paper('A3','landscape');
			$dompdf->render();
			$canvas = $dompdf->get_canvas();
			$font = Font_Metrics::get_font("helvetica", "6");
			$canvas->page_text(1000, 805, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(.66,.66,.66));
			$canvas->page_text(35, 805, "Printed : ".$timedate, $font, 8, array(.66,.66,.66));
			$pdf_content = $dompdf->output();

			// Filename of temporary rfi pdf file
			// pdf file gets 1 in the list
			$tempPdfFile = '00001' . '.' . $tempFileName . '.pdf';
			$tempFilePath = $tempDir . $tempPdfFile;
			file_put_contents ($tempFilePath, $pdf_content);
			//new
			//to delete a image
			 //To delete the img
			$mail_image = Logo::logoByUserCompanyIDforemail($database,$user_company_id);
            $config = Zend_Registry::get('config');
            $file_manager_back = $config->system->base_directory;
            $file_manager_back =$file_manager_back.'www/www.axis.com/';
            $path=$file_manager_back.$mail_image;
            unlink($path);
            //End to delete image
           
        $sha1 = sha1_file($tempFilePath);
        $size = filesize($tempFilePath);
        $fileExtension = 'pdf';
        $virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);
        $tmpFileManagerFile = new FileManagerFile($database);
        
        $tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
        $virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();
      
        $file = new File();
        $file->sha1 = $sha1;
        $file->name = $virtual_file_name;
        $file->size = $size;
        $file->type = $virtual_file_mime_type;
        $file->tempFilePath = $tempFilePath;
        $file->fileExtension = $fileExtension;
        // Save the pdf into cloud
        $query ="SELECT `id` FROM `file_locations`WHERE `file_sha1` = '$sha1'";
		$db->query($query, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && isset($row['id']) && !empty($row['id'])) {
			$file_location_id = $row['id'];
		} else {
			 $query = "INSERT INTO file_locations( `file_sha1`, `cloud_vendor`,  `file_size`,`created`) VALUES ('$sha1','Fulcrum','$size',null)";

        if($db->execute($query)){
            $file_location_id = $db->insertId; 
            
        }
		}
		$successFlag = FileManager::copyUploadedFileToBackendStorageManagerViaLocalFileSystem($file, $tempFilePath, $file_location_id);
        // save the file information to the file_manager_files db table
        $fileManagerFile = FileManagerFile::findByVirtualFileName($database, $userCompanyId, $currentlyActiveContactId, $projectId, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
        //     /* @var $fileManagerFile FileManagerFile */

        $file_manager_file_id = $fileManagerFile->file_manager_file_id;

            // Potentially update file_location_id
        if ($file_location_id <> $fileManagerFile->file_location_id) 
        {
            $fileManagerFile->file_location_id = $file_location_id;
            $data = array('file_location_id' => $file_location_id);
            $fileManagerFile->setData($data);
            $fileManagerFile->save();
        }
        // Set Permissions of the file to match the parent folder.
        $parent_file_manager_folder_id = $fileManagerFolder->getParentFolderId();
        FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
        FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);
        // Delete temp files
        $fileObject->rrmdir($tempDir);
	}

/* Function to create Transmittal folder in FileManager
	address_id = vendor address Id
	type = Transmittal Type
	category= Transmittal Name
	Status = For sending mail or not
	request_for_information_id = rfi_id
	meet_cont= meeting html content

*/
	function TransmittalAndEmail($database, $userCompanyId, $TransmittalId,$projectName,$projectId,$userId,$fileAttachments,$emailTo,$ccValues,$bccValues,$currentlyActiveContactId,$address_id,$type,$category,$status,$request_for_information_id=null,$meet_cont=null,$subChange_id=null,$subcontract_id=null)
	{
		$db = DBI::getInstance($database);     	// Db Initialize
		$sequenceNo = getSequenceNumberUsingTransmittalId($database, $TransmittalId);
		$virtual_file_path = '/Transmittals/Transmittal #' . $sequenceNo . '/';
        $arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
        $currentVirtualFilePath = '/';
        foreach ($arrFolders as $folder) {
            $tmpVirtualFilePath = array_shift($arrFolders);
            $currentVirtualFilePath .= $tmpVirtualFilePath.'/';
            // Save the file_manager_folders record (virtual_file_path) to the db and get the id
              $fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $userCompanyId, $currentlyActiveContactId, $projectId, $currentVirtualFilePath);

        }
        /* @var $fileManagerFolder FileManagerFolder */

        // Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
    	$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

        $config = Zend_Registry::get('config');
        $file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
        $fileManagerBasePath = $config->system->file_manager_base_path;
        $tempFileName = File::getTempFileName();
        $tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
        $fileObject = new File();
        $fileObject->mkdir($tempDir, 0777);

         // Insert the file attachements and move to virtual file path directory
        $counter = 2;
        $skipOne = false;
        $arrPdfFiles = array();
        $tempFilePath='';
        if($type=="RFI")
        {
        $pdf_total_num=2;
    	}
    	else{
        $pdf_total_num=1;
    	}

        if(!empty($fileAttachments))
        {       
            foreach($fileAttachments as $key => $fileAttachment)
            {

                //newly added 
                if ($skipOne) {
                    $skipOne = false;
                    continue;
                }

                //End of newly added
                $attachmentSql = "INSERT INTO transmittal_attachments(attachment_file_manager_file_id,transmittal_data_id) VALUES('$fileAttachment','$TransmittalId')";
                $db->execute($attachmentSql);
                $db->free_result();
                
                $fileManagefile = FileManagerFile::findById($database, $fileAttachment);
                $data = array(
                    'file_manager_folder_id' => $file_manager_folder_id
                );

                $fileManagefile->setData($data);
                $fileManagefile->save();    // Update the new folder
            

                // Filename extension
                $tempDelayAttachmentFileExtension = $fileManagefile->getFileExtension();
                $tempDelayAttachmentFileExtension = strtolower($tempDelayAttachmentFileExtension);
                // Skip all but pdf for now
                
                $fileNamePrefix = str_pad($counter, 5, '0', STR_PAD_LEFT);
                $tempAttachmentFileName = $fileNamePrefix . '.' . $fileManagefile->file_manager_file_id . '.' . $tempDelayAttachmentFileExtension;
                $tempFilePath = $tempDir.$tempAttachmentFileName;
                $file_location_id = $fileManagefile->file_location_id;

                // @todo Add png / image to pdf functionality
              $tempPdfFile = $tempAttachmentFileName;

             
                $statusFlag = false;
                // move files from temp folder into virtual file path
                if (isset($file_location_id) && !empty($file_location_id)) 
                {
                    if ($file_manager_front_end_node_file_copy_protocol == 'FTP') {
                        $statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaFtp($fileManagefile, $tempFilePath, $file_location_id);
                    } elseif ($file_manager_front_end_node_file_copy_protocol == 'LocalFileSystem') {
                        $statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaLocalFileSystem($fileManagefile, $tempFilePath, $file_location_id);
                    }
                }
                /*attachment name array*/
                $PDFMergeFormatArray = array('0'=>'PDF','1'=>'pdf');
                if(in_array($tempDelayAttachmentFileExtension,$PDFMergeFormatArray))
                if ($statusFlag) {
                    $arrPdfFiles[] = $tempPdfFile;
                    //To get the page Count for pdf
					$pdf_page_file=$tempDir.$tempPdfFile;
					$cc= exec("identify -format %n $pdf_page_file");
					$pdf_total_num=$pdf_total_num+$cc;
                }
                $counter++;
            }
        }
         // make Transmittal directory for pdf upload
        chmod($tempDir, 0777);
       

        // Naming convention for pdf
        $typeName=$category;
        
        $cur_date=date('Y-m-d_A');
        $typeName = str_replace(" ","_",$typeName);
      	$typeName = str_replace("'","",$typeName);
      	if(strpos($typeName, '(')){
        	$typeName_data=explode('(', $typeName);
        	$typeName=$typeName_data[0];
      	}
       	$transFileName = $virtual_file_name_tmp = $typeName.$cur_date.'.pdf';

        $guestURL =$guestsubcontractAccess= "";
        $uri = Zend_Registry::get('uri');
		if ($uri->sslFlag) {
			$cdn = 'https:' . $uri->cdn;
		} else {
			$cdn = 'http:' . $uri->cdn;
		}
        if($type=="unsigned"){
        	$mailContent = buildsubcontractorPdfConversion($database, $userCompanyId, $TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$address_id,$subcontract_id);
		 // Pdf conversion
			$htmlContent = buildsubcontractorPdfConversion($database, $userCompanyId, $TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$address_id,$subcontract_id, true);
			$conid=base64_encode($emailTo);
			$subid=base64_encode($subcontract_id);
			$guestURL = $uri->https.'Guest/budget_subcontract_guest.php?token='.$conid.'&pt_token='.$projectId.'&subid='.$subid.'&conid='.$conid;
			$guestsubcontractAccess ='
						<a href="'.$guestURL.'">
						<input type="button" value="CLICK HERE TO VIEW AND E-SIGN."/>
						</a>';
        }
        if($type=="signed")
        {
			$mailContent = buildsubcontractorsignedPdfConversion($database, $userCompanyId, $TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$address_id,$subcontract_id);
			// Pdf conversion
			$htmlContent = buildsubcontractorsignedPdfConversion($database, $userCompanyId, $TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$address_id,$subcontract_id, true);
			$conid=base64_encode($emailTo);
			$subid=base64_encode($subcontract_id);
			$guestURL = $uri->https.'Guest/budget_subcontract_guest.php?token='.$conid.'&pt_token='.$projectId.'&subid='.$subid.'&conid='.$conid;
			$guestsubcontractAccess ='
						<a href="'.$guestURL.'">
						<input type="button" value="CLICK HERE TO VIEW AND E-SIGN."/>
						</a>';
    	}
    	if($type=="Bid")
        {
        	require_once('lib/common/Logo.php');
	
	        $fulcrum = Logo::logoByFulcrum();
	        /*Fetch ids*/
	        $main_company = Project::ProjectsMainCompany($database,$projectId);
	        $ArrayLogoIDs = Logo::filelocationID($database,$main_company);
	        $file_location_id = $ArrayLogoIDs['file_location_id'];
	        $image_manager_image_id = $ArrayLogoIDs['image_manager_image_id'];
	        /*config path get*/
	        $config = Zend_Registry::get('config');
	        $basedircs = $config->system->file_manager_base_path;
	        $basepathcs = $config->system->file_manager_backend_storage_path ;
	        $file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
	        $baseDirectory = $config->system->base_directory;
	        
	        $fileManagerBackendFolderPath = $basedircs.$basepathcs;
	        $objFileOperation = new File();
	        /*validate dir*/
	        $urlDirectory = 'downloads/'.'temp/';
	        $outputDirectory = $baseDirectory.'www/www.axis.com/'.$urlDirectory;
	        if (!is_dir($outputDirectory)) {
	            $directoryCreatedFlag = $objFileOperation->mkdir($outputDirectory, 0777);
	        }
	        
	        $tempFileNameLogo = '_Logo'.round(microtime(true)*5000);
	        $LogoDestination = $outputDirectory.$tempFileNameLogo;

	        /*uri path*/
	        $uri = Zend_Registry::get('uri');
	        $cdn_origin_node_absolute_url = $uri->cdn_origin_node_absolute_url;
	        if($image_manager_image_id!=''){
	            $imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);            
	            $arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
	            $arrPath = $arrFilePath['file_path'].$arrFilePath['file_name'];
	            $path = $arrPath;
	            $infopath= realpath($path);
	            $info   = getimagesize($infopath);
	            $Logomime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
	            $Logowidth  = $info[0]; // width as integer for ex. 512
	            $Logoheight = $info[1]; // height as integer for ex. 384
	            $Logotype   = $info[2];      // same as exif_imagetype
	            resize($path,$LogoDestination,$Logowidth,$Logoheight);
	            $fileLogoPath = $urlDirectory.$tempFileNameLogo;
	            $base64 = 'data:image;base64,' . base64_encode($filegetcontent);
	            $gcLogo = <<<gcLogo
	            <img src="$fileLogoPath"  alt="Logo" style="margin-left:0px;">
gcLogo;
	        }else{
	            $gcLogo = <<<gcLogo
	           
gcLogo;
	        }
			$fulcrum = Logo::logoByFulcrum();
			$headerLogo=<<<headerLogo
				<table width="100%" class="table-header">
 					<tr>
 						<td>$gcLogo</td>
 						<td align="right"><span style="margin-top:10px;">$fulcrum</span></td>
 					</tr>
 				</table>
 			<hr>
headerLogo;

        	$mailContent = buildPdfConversion($database, $userCompanyId, $TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$address_id,$type,$emailTo,false,$headerLogo);
		 	// Pdf conversion
        	$htmlContent = buildPdfConversion($database, $userCompanyId, $TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$address_id,$type,$emailTo, true,$headerLogo);
    	}
    	if($type=="RFI")
        {
        	$mailContent = buildRFIPdfConversion($database, $userCompanyId, $TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$request_for_information_id);
		 	// Pdf conversion
        	$htmlContent = buildRFIPdfConversion($database, $userCompanyId, $TransmittalId,$projectName,$projectId,$pdf_total_num,$userId,$request_for_information_id, true);
    	}
    	if($type=="Meetings"){
			// Pdf conversion
        	$htmlContent = $meet_cont;
    	}
    	if($type=="SCO"){
            $htmlContent = SCOPDFfortransmittal($database, $userCompanyId,$subChange_id,'',$projectId,$currentlyActiveContactId,$TransmittalId,'','','',true);
    	}

        $htmlContent = html_entity_decode($htmlContent);
        $htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");
        $dompdf = new DOMPDF();
        $dompdf->load_html($htmlContent);
        $dompdf->set_paper("A4", "portrait");
        $dompdf->render();
        $pdf_content = $dompdf->output();
        $tempPdfFile = '_temp'.round(microtime(true)*1000).'.pdf';
        $tempFilePath = $tempDir . $tempPdfFile;
        file_put_contents($tempFilePath, $pdf_content);
        // newly added to merge pdf
        if (!empty($arrPdfFiles)) {
            // Put the cover sheet first in the list
                array_unshift($arrPdfFiles, $tempPdfFile);

                $finalTransmittalTempFileName = $virtual_file_name_tmp ;

               $finalTransmittalTempFilepath = $tempDir.$finalTransmittalTempFileName;

                // Merge the RFI pdf and all RFI attachments into a single RFI pdf document
                Pdf::merge($arrPdfFiles, $tempDir, $finalTransmittalTempFileName);

             $tempFilePath = $finalTransmittalTempFilepath;

            }
        //End of newly added to merge pdf
           
        $sha1 = sha1_file($tempFilePath);
        $size = filesize($tempFilePath);
        $fileExtension = 'pdf';
        $virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);
        $tmpFileManagerFile = new FileManagerFile($database);
        
        $tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
     	$virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();

        // Final RFI pdf document
           

            // Convert file content to File object

        $file = new File();
        $file->sha1 = $sha1;
        $file->name = $virtual_file_name;
        $file->size = $size;
        $file->type = $virtual_file_mime_type;
        $file->tempFilePath = $tempFilePath;
        $file->fileExtension = $fileExtension;

        // Save the pdf into cloud
     	$transmittalFileId =   $file_location_id = FileManager::saveUploadedFileToCloud($database, $file);
 
        // save the file information to the file_manager_files db table
        $fileManagerFile = FileManagerFile::findByVirtualFileName($database, $userCompanyId, $currentlyActiveContactId, $projectId, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
    	/* @var $fileManagerFile FileManagerFile */

        $file_manager_file_id = $fileManagerFile->file_manager_file_id;

            // Potentially update file_location_id
        if ($file_location_id <> $fileManagerFile->file_location_id) 
        {
            $fileManagerFile->file_location_id = $file_location_id;
            $data = array('file_location_id' => $file_location_id);
            $fileManagerFile->setData($data);
            $fileManagerFile->save();
        }
     
        // Set Permissions of the file to match the parent folder.
        FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);
        // Delete temp files
        $fileObject->rrmdir($tempDir);
		$cdnFileUrl = $fileManagerFile->generateUrl(true);
        //mail Functionality
        if($status){
        	 // for file size greater than 17 mb
            $filemaxSize=Module::getfilemanagerfilesize($transmittalFileId, $database);
            if(!$filemaxSize)
            {

            if (strpos($cdnFileUrl,"?"))
            {
                $virtual_file_name_url = $cdnFileUrl."&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
            }else
            {
                $virtual_file_name_url = $cdnFileUrl."?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
            }
            $transPDF ="<br><table style=width:80%;> 
            <tr>
            <td style='padding:2px;'>Please find the Transmittal PDF File Link:</td></tr>
            <tr><td style='padding:2px;'><a href='".$virtual_file_name_url."'>$transFileName</a></td></tr>
            </table><br>";
            }else
            {
               $transPDF="" ;
            }
            //End of file size


	$fromuserInfo = Contact::findContactByUserCompanyIdAndUserId($database,$userCompanyId ,$userId);
    $fromUsername = $fromuserInfo['first_name'].' '.$fromuserInfo['last_name'];
    $fromEmail = $fromuserInfo['email'];

    $mailToQuery = "SELECT email,first_name,last_name FROM contacts where id='$emailTo'  limit 1 ";
    $db->execute($mailToQuery);
    $mailToResult = array();
    while($row = $db->fetch())
    {
        $mailToResult[] = $row;
    }
    $db->free_result();
    $mailToEmail = $mailToResult[0]['email']; 
   	$mailToName = $mailToResult[0]['first_name'].' '.$mailToResult[0]['last_name']; 

   	$mailTextQuery = "SELECT mail_content FROM transmittal_data where id=$TransmittalId  limit 1 ";
   	$db->execute($mailTextQuery);
   	$mailTextFetch = $db->fetch();
   	$mailText = $mailTextFetch['mail_content'];
   	$db->free_result();
    
    if($mailToName == ' ')
        $mailToName = $mailToEmail;
    //Mail Body 
    $greetingLine = 'Hi '.$mailToName.',<br><br>';
      //To generate logo
            $uri = Zend_Registry::get('uri');
            if ($uri->sslFlag) {
                $cdn = 'https:' . $uri->cdn;
            } else {
                $cdn = 'http:' . $uri->cdn;
            }
         
           $main_company = Project::ProjectsMainCompany($database,$projectId);
            require_once('lib/common/Logo.php');
           $mail_image = Logo::logoByUserCompanyIDforemail($database,$main_company);
           if($mail_image !=''){
           	$logodata="<td style=width:55%;>
            <a href='".$uri->https."login-form.php'><img style='border: 0; float: left;'  border=0 src='".$cdn.$mail_image."'></a>
            </td>";
           }
            $companyLogoData="
            <table style=width:100%;>
            <tbody>
            <tr>
            $logodata
            <td style='width:45%;' align='right'>
            <a href='".$uri->https."login-form.php'><img style='border: 0; border: none;float: right;' width='200' height='50' border='0' src='".$cdn."images/logos/fulcrum-blue-icon-silver-text.gif' alt=Fulcrum Construction Management Software></a>
            </td>
            </tr>
            </tbody>
            </table>
            <div style='margin:5px 0 0;float: left;'></div>
<div style='margin: 5px 0 0; text-align: right;'><small style='color: #666666;font-size: 13px;'>Construction Management Software</small></div>
$transPDF";
    $htmlAlertMessageBody = <<<END_HTML_MESSAGE
    $greetingLine$mailText
    $guestsubcontractAccess
    <br><span style="margin:2%"></span>
    $companyLogoData
    $mailContent
END_HTML_MESSAGE;
	$sendEmail = 'Alert@MyFulcrum.com';
    $sendName = ($fromUsername !=" ") ? $fromUsername : "Fulcrum Message";
    $mail = new Mail();
    $mail->setBodyHtml($htmlAlertMessageBody, 'UTF-8', Zend_Mime::MULTIPART_RELATED);
    $mail->setFrom($sendEmail, $sendName);
    $mail->addTo($mailToEmail, $mailToName);
    $mail->addHeader('Reply-To',$fromEmail);

    $mail->setSubject('Transmittal');
    if($filemaxSize){
		if (strpos($cdnFileUrl, '?')) {
			$separator = '&';
		} else {
			$separator = '?';
		}
		$cdnFileUrl = $cdnFileUrl .$separator. 'id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
		if(!empty($fileAttachments)){
			$fileContents = file_get_contents($cdnFileUrl);
		}else{
			$fileContents = $pdf_content;
		}
		$mail->createAttachment($virtual_file_name_tmp, $fileContents);
	}
  
    
    if(!empty($ccValues)){
        foreach($ccValues as $ccValue){
            $mailCcQuery = "SELECT email,first_name,last_name FROM contacts where id='$ccValue'  limit 1 ";
            $db->execute($mailCcQuery);
            $mailCcResult = array();
            while($row = $db->fetch()){
                $mailCcResult[] = $row;
            }
            $db->free_result();
            $mailCcEmail = $mailCcResult[0]['email']; 
            $mailCcName = $mailCcResult[0]['first_name'].' '.$mailCcResult[0]['last_name']; 
            $mail->addCc($mailCcEmail,$mailCcName);
        }
    }
    if(!empty($bccValues)){
        foreach($bccValues as $bccValue){
            $mailBCcQuery = "SELECT email,first_name,last_name FROM contacts where id='$bccValue'  limit 1 ";
            $db->execute($mailBCcQuery);
            $mailBCcResult = array();
            while($row = $db->fetch()){
                $mailBCcResult[] = $row;
            }
            $db->free_result();
            $mailBCcEmail = $mailBCcResult[0]['email']; 
            $mailBCcName = $mailBCcResult[0]['first_name'].' '.$mailBCcResult[0]['last_name']; 
            $mail->addBcc($mailBCcEmail, $mailBCcName);
        }
    }
    $mail->send();	
    echo  "1" ;
 	// Delete temp files
    if(!empty($fileAttachments))
    	$fileObject->rrmdir($tempDir);
    	//To delete the img
		$config = Zend_Registry::get('config');
		$file_manager_back = $config->system->base_directory;
		$file_manager_back =$file_manager_back.'www/www.axis.com/';
		$path=$file_manager_back.$mail_image;
		unlink($path);
	}
    

}
/* Get the sequence no for newly create transmittals*/
function getSequenceNumberForTransmittals($database, $projectId)
{	
	$db = DBI::getInstance($database);
	$sequence_query = "SELECT sequence_number FROM transmittal_data WHERE project_id = $projectId ORDER BY id DESC";
	$db->execute($sequence_query);
	$sequence = $db->fetch();
	$db->free_result();
	if(isset($sequence) && !empty($sequence)){
		$sequenceNo = (intVal($sequence['sequence_number']) + 1);
	} else {
		$sequenceNo = 1;
	}
	return $sequenceNo;
}

/* Get the sequence no using transmittals id*/
function getSequenceNumberUsingTransmittalId($database, $transmittalsId)
{	
	$db = DBI::getInstance($database);
	$sequence_query = "SELECT sequence_number FROM transmittal_data WHERE id = $transmittalsId ORDER BY id DESC";
	$db->execute($sequence_query);
	$sequence = $db->fetch();
	$db->free_result();
	if(isset($sequence) && !empty($sequence)){
		$sequenceNo = (intVal($sequence['sequence_number']));
	} else {
		$sequenceNo = 1;
	}
	return $sequenceNo;
}
