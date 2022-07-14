<?php

require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/ContractingEntities.php');
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
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/ProjectToWeatherUndergroundReportingStation.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/Submittal.php');
require_once('lib/common/SubmittalAttachment.php');
require_once('lib/common/SubmittalDistributionMethod.php');
require_once('lib/common/SubmittalDraft.php');
require_once('lib/common/SubmittalDraftRecipient.php');
require_once('lib/common/SubmittalDraftAttachment.php');
require_once('lib/common/SubmittalNotification.php');
require_once('lib/common/SubmittalPriority.php');
require_once('lib/common/SubmittalRecipient.php');
require_once('lib/common/SubmittalResponse.php');
require_once('lib/common/SubmittalResponseType.php');
require_once('lib/common/SubmittalStatus.php');
require_once('lib/common/SubmittalType.php');
require_once('lib/common/Tagging.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
require_once('lib/common/UserCompanyFileTemplate.php');

require_once('page-components/dropDownListWidgets.php');
require_once('page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('app/models/permission_mdl.php');
require_once('lib/common/Date.php');

// Function to list grid
function renderSuListView_AsHtml($database, $project_id, $user_company_id){
	$session = Zend_Registry::get('session');
	$debugMode = $session->getDebugMode();
	$userCanViewSubmittals = checkPermissionForAllModuleAndRole($database,'submittals_view');
	$userCanManageSubmittals = checkPermissionForAllModuleAndRole($database,'submittals_manage');
	$userCanAnswerSubmittals = checkPermissionForAllModuleAndRole($database,'submittals_respond');
	$userRole = $session->getUserRole();

	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
	$arrSubmittals = Submittal::loadSubmittalsDatasforProjectId($database,$project_id);

	$suTableTbody = '';
	foreach ($arrSubmittals as $submittal_id => $submittal) {
		$submittal_id = $submittal['id'];
		$su_title = $submittal['su_title'];
		$su_sequence_number = $submittal['su_sequence_number'];
		$su_plan_page_reference = $submittal['su_plan_page_reference'];
		$su_created = $submittal['created'];
		$su_due_date = $submittal['su_due_date'];
		$su_closed_date = $submittal['su_closed_date'];
		$submittal_status = $submittal['submittal_status'];
		$submittalstatusId = $submittal['submittal_status_id'];
		$submittal_priority_id = $submittal['submittal_priority_id'];
		$submittal_priority = $submittal['submittal_priority'];
		$su_cost_code_id = $submittal['su_cost_code_id'];
		$su_spec_no =$submittal['su_spec_no'];

		$su_recipient_contact_id = $submittal['su_recipient_contact_id'];
		$su_recipient_first_name = $submittal['con_first_name'];
		$su_recipient_lastname = $submittal['con_last_name'];
		$su_recipient_email = $submittal['con_email'];
		$su_tag_ids = $submittal['tag_ids'];
		$su_recipient_is_archive = $submittal['con_is_archive'];

			// to get the Submittal tag id
		$su_tag_name = Tagging::getTagName($database,$su_tag_ids);

		if($su_cost_code_id !="")
		{
			$costcodedata = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$su_cost_code_id,$costCodeDividerType);
			$formattedSuCostCode =$costcodedata['short_cost_code'];
		}else
		{
			$formattedSuCostCode ="";
		}
		// Convert su_created to a Unix timestamp
		$openDateUnixTimestamp = strtotime($su_created);
		$oneDayInSeconds = 86400;
		$daysOpen = '';

		$multipleTo = SubmittalRecipient::getListOfToRecipient($database,$submittal_id,'To');
		if ($multipleTo['to_email']) {
			$suRecipientContactFullName = $multipleTo['to_email'];
		}

		$formattedSuCreatedDate = date("m/d/Y g:i a", $openDateUnixTimestamp);
		if($su_due_date !="")
		{
			$dueDateUnixTimestamp = strtotime($su_due_date);
			$formattedSuDueDate = date("m/d/Y", $dueDateUnixTimestamp);
		}


		$formattedSuClosedDate ="";
		if($su_closed_date !="")
		{
			$closeDateUnixTimestamp = strtotime($su_closed_date);
			$formattedSuClosedDate = date("m/d/Y", $closeDateUnixTimestamp);
		}

		

		// if Submittal status is "closed"
		if (!$su_closed_date) {
			$su_closed_date = '0000-00-00';
		}
		// if (($submittalstatusId == 2) && ($su_closed_date <> '0000-00-00') || ($submittalstatusId == 3) && ($su_closed_date <> '0000-00-00')) {
		// 	$closedDateUnixTimestamp = strtotime($su_closed_date);
		// 	if ($su_closed_date <> '0000-00-00') {

		// 		$daysOpenNumerator = $closedDateUnixTimestamp - $openDateUnixTimestamp;
		// 		$daysOpenDenominator = $oneDayInSeconds;
		// 		$daysOpen = $daysOpenNumerator / $daysOpenDenominator;
		// 		$daysOpen = ceil($daysOpen);

		// 	}
		// } else {

		// 	$nowDate = date('Y-m-d');
		// 	$nowDateUnixTimestamp = strtotime($nowDate);
		// 	$daysOpenNumerator = $nowDateUnixTimestamp - $openDateUnixTimestamp;
		// 	$daysOpenDenominator = $oneDayInSeconds;
		// 	$daysOpen = $daysOpenNumerator / $daysOpenDenominator;
		// 	$daysOpen = ceil($daysOpen);

		// }

		// start of days calculation

		$subclosedLog = SubmittalStatus::getClosedDateDetails($database,$submittal_id);
		$subopenarr = $subclosedLog['open'];
		$subclosedarr = $subclosedLog['closed'];

		$openingdate = explode(' ', $su_created);
		// adding the open date
		array_unshift($subopenarr , $openingdate[0]);

		// if the submittal is not closed then push the current date for calculation
		if($su_closed_date !="")
		{
			$assumingAs = date('Y-m-d');
			array_push($subclosedarr , $assumingAs);
		}

		$dayopencalc =0;
		if(!empty($subclosedLog))
		{

		foreach ($subopenarr as $key => $cdate) {
			$date1=date_create($cdate);
			// if the status has changed to open continuously to avoid adding as many time breaking the loop
			if($subclosedarr[$key] == ''){
				break;
			}
			$date2=date_create($subclosedarr[$key]);
			$diff=date_diff($date1,$date2);
 			$diff3= $diff->format("%a");
			$dayopencalc =$dayopencalc + intval($diff3);
		}
		}
		// End of days calculation

		// There was an instance of $daysOpen showing as "-0"
		if (($dayopencalc == 0) || ($dayopencalc == '-0')) {
			$dayopencalc = 0;
		}
	
		if($debugMode){
			$submittalIdBody = <<<END_OF_SUBMITTAL_ID_BODY
		<td class="textAlignCenter" id="manage-submittal-record--submittals--su_id--$submittal_id" nowrap>$submittal_id</td>
END_OF_SUBMITTAL_ID_BODY;
		}
	  $editClick = "onclick='Submittals__loadSubmittalModalDialog($submittal_id)'";
			$cursorClass = "";
		$suTableTbody .= <<<END_SUBMITTAL_TABLE_TBODY

		<tr id="record_container--manage-submittal-record--submittals--$submittal_id" $editClick>
		$submittalIdBody
			<td class="textAlignCenter" id="manage-submittal-record--submittals--su_sequence_number--$submittal_id" nowrap>$su_sequence_number</td>
			<td class="textAlignCenter" id="manage-submittal-record--submittals--su_cost_code_id--$submittal_id" nowrap>$formattedSuCostCode</td>
			<td class="textAlignCenter" id="manage-submittal-record--submittals--su_spec_no--$submittal_id" nowrap>$su_spec_no</td>
			<td class="textAlignLeft" id="manage-submittal-record--submittals--su_title--$submittal_id">$su_title</td>
			<td class="textAlignLeft" id="manage-submittal-record--submittals--su_plan_page_reference--$submittal_id" nowrap>$su_plan_page_reference</td>
			<td class="textAlignLeft" id="manage-submittal-record--submittals--su_created--$submittal_id" nowrap>$formattedSuCreatedDate</td>
			<td class="textAlignLeft" id="manage-submittal-record--submittals--su_due_date--$submittal_id" nowrap>$formattedSuDueDate</td>
			<td class="textAlignLeft break_content" data-toggle="tooltip" title="$suRecipientContactFullName" id="manage-submittal-record--submittals--recipientFullName--$submittal_id" nowrap>$suRecipientContactFullName<input type="hidden" id="manage-submittal-record--submittals--su_recipient_contact_id--$submittal_id" value="$su_recipient_contact_id"></td>
			<td class="textAlignLeft break_content" data-toggle="tooltip" title="$su_tag_name" id="manage-submittal-record--submittals--tag_ids--$submittal_id" nowrap>$su_tag_name<input type="hidden" id="manage-submittal-record--submittals--tag_ids--$submittal_id" value="$su_tag_ids"></td>
			<td class="textAlignLeft" id="manage-submittal-record--submittals--submittal_priority--$submittal_id" nowrap>$submittal_priority<input type="hidden" id="manage-submittal-record--submittals--submittal_priority_id--$submittal_id" value="$submittal_priority_id"></td>
			<td class="textAlignLeft" id="manage-submittal-record--submittals--su_closed_date--$submittal_id" nowrap>$formattedSuClosedDate<input type="hidden" id="manage-submittal-record--submittals--su_closed_date--$submittal_id" value="$formattedSuClosedDate"></td>
			<td class="textAlignLeft" id="manage-submittal-record--submittals--submittal_status--$submittal_id" nowrap>$submittal_status<input type="hidden" id="manage-submittal-record--submittals--submittal_status_id--$submittal_id" value="$submittalstatusId"></td>
			<td class="textAlignCenter" id="manage-submittal-record--submittals--daysOpen--$submittal_id" nowrap>$dayopencalc</td>
		</tr>

END_SUBMITTAL_TABLE_TBODY;
}
		if($debugMode){
			$submittalIdHeader = <<<END_OF_SUBMITTAL_ID_HEAD
		<th class="textAlignCenter" nowrap>Submittal No</th>
END_OF_SUBMITTAL_ID_HEAD;
		}
		$htmlContent = <<<END_HTML_CONTENT

<table id="record_list_container--manage-submittal-record" class="content $cursorClass" border="0" cellpadding="5" cellspacing="0" width="100%">
	<thead class="borderBottom">
		<tr>
		$submittalIdHeader
		<th class="textAlignCenter" nowrap>Submittal #</th>
		<th class="textAlignCenter" nowrap>Cost Code</th>
		<th class="textAlignCenter" nowrap>Spec no</th>
		<th class="textAlignLeft" nowrap>Submittal Title</th>
		<th class="textAlignLeft" nowrap>Plans Reference</th>
		<th class="textAlignLeft" nowrap>Date Issued</th>
		<th class="textAlignLeft" nowrap>Due Date</th>
		<th class="textAlignLeft" nowrap>Submittal Recipient</th>
		<th class="textAlignLeft" nowrap>Tags</th>
		<th class="textAlignLeft" nowrap>Priority</th>
		<th class="textAlignLeft" nowrap>Approved Date</th>
		<th class="textAlignLeft" nowrap>Status</th>
		<th class="textAlignCenter" nowrap>Days Open</th>
		</tr>
	</thead>
	<tbody class="altColors">
		$suTableTbody
	</tbody>
</table>

END_HTML_CONTENT;

	return $htmlContent;
}

function loadSubmittal($database, $user_company_id, $contact_id, $project_id, $submittal_id, $subproject_id)
{
	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$debugMode = $session->getDebugMode();


	//Check the permisson for view delay
	$userRole = $session->getUserRole();

	$userCanViewSubmittals = checkPermissionForAllModuleAndRole($database,'submittals_view', $subproject_id);
	$userCanAnswerSubmittals = checkPermissionForAllModuleAndRole($database,'submittals_respond', $subproject_id);
	// to check whether the user has the project permission
	$checkprojectAccess = projectAccessForUser($database,$subproject_id,$contact_id);
	if(!$checkprojectAccess)
	{
		return;
	}

// if($userCanViewSubmittals =="" && $userRole!="global_admin")
// 	{
// 		return ;
// 	}
	$userCanManageSubmtlsRT = true;
	if($userRole != 'global_admin'){
		$userCanManageSubmtlsRT = checkPermissionForAllModuleAndRole($database,'submittals_manage', $subproject_id);
	}
	$editdisable = $editdisable_my_notes = "disabled='true'";
	if($userCanManageSubmtlsRT){
		$editdisable ="";
	}
	if ($userCanAnswerSubmittals) {
		$editdisable_my_notes ="";
	}

 	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}

	$tempNotes = $_COOKIE['tempNotes'];
	$tempEmailBody = $_COOKIE['tempEmailBody'];

	// FileManagerFolder
	$virtual_file_path = '/Submittals/';
	$suFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $contact_id, $project_id, $virtual_file_path);
	/* @var $suFileManagerFolder FileManagerFolder */

	$submittal = Submittal::findSubmittalByIdExtended($database, $submittal_id);
	/* @var $submittal Submittal */

	if (!$submittal) {
		return '';
	}

	$submittal_id = $submittal->submittal_id;

	$project_id = $submittal->project_id;
	$su_sequence_number = $submittal->su_sequence_number;
	$submittal_type_id = $submittal->submittal_type_id;
	$submittal_status_id = $submittal->submittal_status_id;
	$submittal_priority_id = $submittal->submittal_priority_id;
	$submittal_distribution_method_id = $submittal->submittal_distribution_method_id;
	$su_file_manager_file_id = $submittal->su_file_manager_file_id;
	$su_cost_code_id = $submittal->su_cost_code_id;
	$su_creator_contact_id = $submittal->su_creator_contact_id;
	$su_creator_contact_company_office_id = $submittal->su_creator_contact_company_office_id;
	$su_creator_phone_contact_company_office_phone_number_id = $submittal->su_creator_phone_contact_company_office_phone_number_id;
	$su_creator_fax_contact_company_office_phone_number_id = $submittal->su_creator_fax_contact_company_office_phone_number_id;
	$su_creator_contact_mobile_phone_number_id = $submittal->su_creator_contact_mobile_phone_number_id;
	$su_recipient_contact_id = $submittal->su_recipient_contact_id;
	$su_recipient_contact_company_office_id = $submittal->su_recipient_contact_company_office_id;
	$su_recipient_phone_contact_company_office_phone_number_id = $submittal->su_recipient_phone_contact_company_office_phone_number_id;
	$su_recipient_fax_contact_company_office_phone_number_id = $submittal->su_recipient_fax_contact_company_office_phone_number_id;
	$su_recipient_contact_mobile_phone_number_id = $submittal->su_recipient_contact_mobile_phone_number_id;
	$su_initiator_contact_id = $submittal->su_initiator_contact_id;
	$su_initiator_contact_company_office_id = $submittal->su_initiator_contact_company_office_id;
	$su_initiator_phone_contact_company_office_phone_number_id = $submittal->su_initiator_phone_contact_company_office_phone_number_id;
	$su_initiator_fax_contact_company_office_phone_number_id = $submittal->su_initiator_fax_contact_company_office_phone_number_id;
	$su_initiator_contact_mobile_phone_number_id = $submittal->su_initiator_contact_mobile_phone_number_id;
	$su_title = $submittal->su_title;
	$su_plan_page_reference = $submittal->su_plan_page_reference;
	$su_statement = $submittal->su_statement;
	$su_created = $submittal->created;
	$su_due_date = $submittal->su_due_date;
	$su_closed_date = $submittal->su_closed_date;
	$su_tag_ids = $submittal->tag_ids;
	$su_tag_name = Tagging::getTagName($database,$su_tag_ids);

	// HTML Entity Escaped Data
	$submittal->htmlEntityEscapeProperties();
	$escaped_su_plan_page_reference = $submittal->escaped_su_plan_page_reference;
	$escaped_su_statement = $submittal->escaped_su_statement;
	$escaped_su_statement_nl2br = $submittal->escaped_su_statement_nl2br;
	$escaped_su_title = $submittal->escaped_su_title;

	$project = $submittal->getProject();
	/* @var $project Project */

	$submittalType = $submittal->getSubmittalType();
	/* @var $submittalType SubmittalType */

	$submittalStatus = $submittal->getSubmittalStatus();
	/* @var $submittalStatus SubmittalStatus */

	$submittalStatus->htmlEntityEscapeProperties();
	$submittal_status = $submittalStatus->submittal_status;
	$escaped_submittal_status = $submittalStatus->escaped_submittal_status;

	$submittalPriority = $submittal->getSubmittalPriority();
	/* @var $submittalPriority SubmittalPriority */

	$submittalPriority->htmlEntityEscapeProperties();
	$escaped_submittal_priority = $submittalPriority->escaped_submittal_priority;

	/* @var $submittalDistributionMethod SubmittalDistributionMethod */

	$suFileManagerFile = $submittal->getSuFileManagerFile();
	/* @var $suFileManagerFile FileManagerFile */

	$suCostCode = $submittal->getSuCostCode();
	/* @var $suCostCode CostCode */

	if ($suCostCode) {
		// Extra: Submittal Cost Code - Cost Code Division
		$suCostCodeDivision = $suCostCode->getCostCodeDivision();
		/* @var $suCostCodeDivision CostCodeDivision */

		$formattedSuCostCode = $suCostCode->getFormattedCostCode($database);

		$htmlEntityEscapedFormattedSuCostCodeLabel = $suCostCode->getHtmlEntityEscapedFormattedCostCode();
	}

	$suCreatorContact = $submittal->getSuCreatorContact();
	/* @var $suCreatorContact Contact */

	

	$loadSubmittalRecipientsBySubmittalIdOptions = new Input();
	$loadSubmittalRecipientsBySubmittalIdOptions->forceLoadFlag = true;
	
	$additionalRecipients = SubmittalNotification::loadRequestForSubmittalRecipientsBySubmittalId($database, $submittal_id, $loadSubmittalRecipientsBySubmittalIdOptions); 
	// To get a list of additional recipients of To users
	$suRecipientsTo = SubmittalNotification::loadRequestForSubmittalRecipientsForTo($database, $submittal_id); 
	// To get a list of 'To' recipients from the submittal recipient log
	$suToRecipientsFromLog = SubmittalNotification::getListOfToRecipientFromSuLog($database, $submittal_id);	

	$ccRecipientList = '';
	$bccRecipientList = '';
	$toRecipientsList = '';

	$contactName = Contact::ContactNameById($database,$su_recipient_contact_id);
	

    $toRecipientsList .= 
			'<li id="'.$su_recipient_contact_id.'">
	          
	          <span id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id_span--'.$dummyId.'">
	              '.$contactName.'
	          </span>
	        </li>';

    $toSelectId = '';
    $suToRecipientsList='';
   
    $EmailToId = $EmailCcId =$EmailBccId ="";

	foreach ($additionalRecipients as $key => $value) {

		if($value['first_name']!='' || $value['last_name']!='')
		   	$contactName = $value['first_name'].' '.$value['last_name'];
	   	else
		   	$contactName=$value['email'];

		$emailContact = ($additionalRecipients[$key]['is_archive'] == 'Y') ? $additionalRecipients[$key]['email'].' (Archived)' : $additionalRecipients[$key]['email'];
		$emailContact_next = ($additionalRecipients[$key+1]['is_archive'] == 'Y') ? $additionalRecipients[$key+1]['email'].' (Archived)' : $additionalRecipients[$key+1]['email'];
		$contactName = ($value['is_archive'] == 'Y') ? $contactName.' (Archived)' : $contactName;
		if($value['smtp_recipient_header_type'] == 'To')
		{
			$EmailToId .= $value['su_additional_recipient_contact_id'].",";
		}
		if($value['smtp_recipient_header_type'] == 'Cc'){
			$ccRecipientList .= 
			'<li class="submittal--cc" id="'.$value['su_additional_recipient_contact_id'].'" >
	          <a href="#" onclick="Submittals__removeRecipient(this,\'Cc\'); return false;" id="'.$value['su_additional_recipient_contact_id'].'">X</a>&nbsp;
	          <span id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id_span--'.$dummyId.'">
	              '.$contactName.'
	          </span>
	          <input id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--'.$dummyId.'" class="cc_recipients" type="hidden" value="'.$value['su_additional_recipient_contact_id'].'">
			</li>';
			$EmailCcId .= $value['su_additional_recipient_contact_id'].",";
		}else if($value['smtp_recipient_header_type'] == 'Bcc'){
			$bccRecipientList .= 
			'<li class="submittal--bcc" id="'.$value['su_additional_recipient_contact_id'].'" >
	          <a href="#" onclick="Submittals__removeRecipient(this,\'Bcc\'); return false;" id="'.$value['su_additional_recipient_contact_id'].'">X</a>&nbsp;
	          <span id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id_span--'.$dummyId.'">
	              '.$contactName.'
	          </span>
	          <input id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--'.$dummyId.'" class="bcc_recipients" type="hidden" value="'.$value['su_additional_recipient_contact_id'].'">
			</li>';
			$EmailBccId .= $value['su_additional_recipient_contact_id'].",";
		}
	}
	$EmailToId = rtrim($EmailToId,',');
	$EmailCcId = rtrim($EmailCcId,',');
	$EmailBccId = rtrim($EmailBccId,',');
	$toemailist  =Contact::ContactNameByIdList($database,$EmailToId);
	$ccemailist  =Contact::ContactNameByIdList($database,$EmailCcId);
	$bccemailist  =Contact::ContactNameByIdList($database,$EmailBccId);

    if(!empty($suToRecipientsFromLog) && count($suToRecipientsFromLog) > 1){
    	$suToRecipientsList = '<tr>
			<td colspan="2" class="SUBMITTAL_table_header2">Recipient Modification History:</td></tr>';
		foreach ($suToRecipientsFromLog as $value) {
			$creater_name = Contact::ContactNameById($database,$value['su_to_recipient_creator_contact_id']);
			if ($value['status']) {
				$suToRecipientsList .='<tr>
					<td class="SUBMITTAL_table2_content" style="padding: 3px;">
						<p>'.$creater_name.' added the recipient '.$value['to_email'].' on '.date('n/j/Y g:i a',strtotime($value['created_date'])).'</p>
					</td></tr>';
			}else{
				$suToRecipientsList .='<tr>
					<td class="SUBMITTAL_table2_content" style="padding: 3px;">
						<p>'.$creater_name.' removed the recipient '.$value['to_email'].' on '.date('n/j/Y g:i a',strtotime($value['created_date'])).'</p>
					</td></tr>';
			}
		}
    }

	/* Recieptant - Start */
	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($database, $project_id, 'submittals');

	// email contact popup
	$ddlsuTofield = "<input type='button' id='create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--To' class='suTofiled' onclick='openProjectContactsMailing(&apos;submittals&apos;,&apos;$submittal_id&apos;)' value='Select Recipient'/> ";
	$ddlsuccfield = "<input type='button' id='create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--cc' class='suTofiled' onclick='openProjectContactsMailing(&apos;submittals&apos;,&apos;$submittal_id&apos;)' value='Select Cc'/> ";
	$ddlsubccfield = "<input type='button' id='create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--bcc' class='suTofiled' onclick='openProjectContactsMailing(&apos;submittals&apos;,&apos;$submittal_id&apos;)' value='Select Bcc'/> ";

  	// Tosubmittalupdate - class used to update the To field
  	$js = " class='moduleSUBMITTAL_dropdown4 required emailGroup Tosubmittalupdate' $editdisable ";
  	$prependedOption = '<option value="">Select a contact</option>';
	

	$ddlProjectTeamMembersToId = "ddl--create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--To";
  	$ddlProjectTeamMembersTo = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersToId,$su_recipient_contact_id);

	// Cc:
	// su_additional_recipient_contact_id

	$ddlProjectTeamMembersCcId = "ddl--create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--Cc-$dummyId";
	$js = ' onchange="Submittals__addRecipient(this,&apos;cc&apos;);" class="moduleSUBMITTAL_dropdown4 emailGroup "';
	$ddlProjectTeamMembersCc = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersCcId);

  // Bcc:
	$js = ' onchange="Submittals__addRecipient(this,&apos;bcc&apos;);" class="moduleSUBMITTAL_dropdown4 emailGroup "';
  	$ddlProjectTeamMembersBccId = "ddl--create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--Bcc-$dummyId";
	$ddlProjectTeamMembersBcc = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersBccId);



	/* Recieptant - End */

	$suCreatorDisplayName = '';
	if ($suCreatorContact) {
		// Extra: Submittal Creator - Contact Company
		$suCreatorContactCompany = $suCreatorContact->getContactCompany();
		/* @var $suCreatorContactCompany ContactCompany */

		$suCreatorContact->htmlEntityEscapeProperties();
		$suCreatorContactCompany->htmlEntityEscapeProperties();

		$su_creator_contact_company_name = $suCreatorContactCompany->contact_company_name;
		$su_creator_escaped_contact_company_name = $suCreatorContactCompany->escaped_contact_company_name;

		$suCreatorContactFullNameHtmlEscaped = $suCreatorContact->getContactFullNameHtmlEscaped();
		$su_creator_escaped_email = $suCreatorContact->escaped_email;

		if ($debugMode) {
			$suCreatorDisplayName = $su_creator_escaped_contact_company_name . ' (contact_company_id: ' . $suCreatorContactCompany->contact_company_id . ') &mdash; ' . $suCreatorContactFullNameHtmlEscaped . ' &lt;' . $su_creator_escaped_email . '&gt;' . ' (su_creator_contact_id: ' . $suCreatorContact->contact_id . ')';
		} else {
			$suCreatorDisplayName = $su_creator_escaped_contact_company_name . ' &mdash; ' . $suCreatorContactFullNameHtmlEscaped . ' [' . $su_creator_escaped_email . ']';
		}
	}

	$suCreatorContactCompanyOffice = $submittal->getSuCreatorContactCompanyOffice();
	/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */

	$suCreatorPhoneContactCompanyOfficePhoneNumber = $submittal->getSuCreatorPhoneContactCompanyOfficePhoneNumber();
	/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$suCreatorFaxContactCompanyOfficePhoneNumber = $submittal->getSuCreatorFaxContactCompanyOfficePhoneNumber();
	/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$suCreatorContactMobilePhoneNumber = $submittal->getSuCreatorContactMobilePhoneNumber();
	/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */

	$suRecipientContact = $submittal->getSuRecipientContact();
	/* @var $suRecipientContact Contact */

	if ($suRecipientContact) {
		// Extra: Submittal Recipient - Contact Company
		$suRecipientContactCompany = $suRecipientContact->getContactCompany();
		/* @var $suRecipientContactCompany ContactCompany */

		$suRecipientContact->htmlEntityEscapeProperties();
		$suRecipientContactCompany->htmlEntityEscapeProperties();

		$su_recipient_contact_company_name = $suRecipientContactCompany->contact_company_name;
		$su_recipient_escaped_contact_company_name = $suRecipientContactCompany->escaped_contact_company_name;

		$suRecipientContactFullNameHtmlEscaped = $suRecipientContact->getContactFullNameHtmlEscaped();
		$su_recipient_escaped_email = $suRecipientContact->escaped_email;
	}

	$suRecipientMultiple = SubmittalRecipient::getRecipientCompanyData($database,$submittal_id,'To');
	$suRecipientMultipleCount = count($suRecipientMultiple);
	if ($suRecipientMultiple) {
		$suRecipientDisplayName = '';
		foreach ($suRecipientMultiple as $key => $value) {
			if ($debugMode) {
				$suRecipientDisplayName .= $value['comany_name'] . ' (contact_company_id: ' . $value['contact_company_id'] . ') &mdash; ' . $value['name'] . ' &lt;' . $value['email'] . '&gt;' . ' (su_recipient_contact_id: ' . $value['contact_id'] . ')';
			} else {
				$suRecipientDisplayName .= $value['comany_name'] . ' &mdash; ' . $value['name'] . ' [' . $value['email'] . ']';
			}
			$suRecipientDisplayName .= (($suRecipientMultipleCount - 1) != $key) ? ', <br>' : '';
		}
	}

	$suRecipientContactCompanyOffice = $submittal->getSuRecipientContactCompanyOffice();
	/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */

	$suRecipientPhoneContactCompanyOfficePhoneNumber = $submittal->getSuRecipientPhoneContactCompanyOfficePhoneNumber();
	/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$suRecipientFaxContactCompanyOfficePhoneNumber = $submittal->getSuRecipientFaxContactCompanyOfficePhoneNumber();
	/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$suRecipientContactMobilePhoneNumber = $submittal->getSuRecipientContactMobilePhoneNumber();
	/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */

	$suInitiatorContact = $submittal->getSuInitiatorContact();
	/* @var $suInitiatorContact Contact */

	$suInitiatorDisplayName = '';
	if ($suInitiatorContact) {
		// Extra: Submittal Initiator - Contact Company
		$suInitiatorContactCompany = $suInitiatorContact->getContactCompany();
		/* @var $suInitiatorContactCompany ContactCompany */

		$suInitiatorContact->htmlEntityEscapeProperties();
		if($suInitiatorContactCompany)
		{
		$su_initiator_contact_company_name = $suInitiatorContactCompany->contact_company_name;
		$su_initiator_escaped_contact_company_name = $suInitiatorContactCompany->escaped_contact_company_name;

		$suInitiatorContactFullNameHtmlEscaped = $suInitiatorContact->getContactFullNameHtmlEscaped();
		$su_initiator_escaped_email = $suInitiatorContact->escaped_email;

		if ($debugMode) {
			$suInitiatorDisplayName = $su_initiator_escaped_contact_company_name . ' (contact_company_id: ' . $suInitiatorContactCompany->contact_company_id . ') &mdash; ' . $suInitiatorContactFullNameHtmlEscaped . ' &lt;' . $su_initiator_escaped_email . '&gt;' . ' (su_initiator_contact_id: ' . $suInitiatorContact->contact_id . ')';
		} else {
			$suInitiatorDisplayName = $su_initiator_escaped_contact_company_name . ' &mdash; ' . $suInitiatorContactFullNameHtmlEscaped . ' [' . $su_initiator_escaped_email . ']';
		}
	}
	}

	$suInitiatorContactCompanyOffice = $submittal->getSuInitiatorContactCompanyOffice();
	/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */

	$suInitiatorPhoneContactCompanyOfficePhoneNumber = $submittal->getSuInitiatorPhoneContactCompanyOfficePhoneNumber();
	/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$suInitiatorFaxContactCompanyOfficePhoneNumber = $submittal->getSuInitiatorFaxContactCompanyOfficePhoneNumber();
	/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$suInitiatorContactMobilePhoneNumber = $submittal->getSuInitiatorContactMobilePhoneNumber();
	/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */


	// Timestamps
	$suCreatedTimestampInt = strtotime($su_created);
	$suCreatedTimestampDisplayString = date('n/j/Y', $suCreatedTimestampInt);

	$suApprovedTimestampDisplayString = '';
	if (($submittal_status_id == 2) || ($submittal_status_id == 3)) {
		$suApprovedTimestampInt = strtotime($su_closed_date);
		$suApprovedTimestampDisplayString = date('n/j/Y', $suApprovedTimestampInt);
	}


	

	$loadSubmittalResponsesBySubmittalIdOptions = new Input();
	$loadSubmittalResponsesBySubmittalIdOptions->forceLoadFlag = true;
	$arrSubmittalResponsesBySubmittalId = SubmittalResponse::loadSubmittalResponsesBySubmittalId($database, $submittal_id, $loadSubmittalResponsesBySubmittalIdOptions);
	$tableSuResponses = '';
	//to check the user has manage permission
	$permissions = Zend_Registry::get('permissions');
	$userCanManageSubmittals = checkPermissionForAllModuleAndRole($database,'submittals_manage');
	$res=CheckcontactRolemanager($database,$contact_id,$project_id);

	foreach ($arrSubmittalResponsesBySubmittalId as $submittal_response_id => $submittalResponse ) {
		/* @var $submittalResponse SubmittalResponse */

		$submittalResponse->htmlEntityEscapeProperties();
		$submittal_response_id=$submittalResponse->submittal_response_id;

		$submittal_response_sequence_number = $submittalResponse->submittal_response_sequence_number;
		$submittal_response_type_id = $submittalResponse->submittal_response_type_id;
		$su_responder_contact_id = $submittalResponse->su_responder_contact_id;
		$su_responder_contact_company_office_id = $submittalResponse->su_responder_contact_company_office_id;
		$su_responder_phone_contact_company_office_phone_number_id = $submittalResponse->su_responder_phone_contact_company_office_phone_number_id;
		$su_responder_fax_contact_company_office_phone_number_id = $submittalResponse->su_responder_fax_contact_company_office_phone_number_id;
		$su_responder_contact_mobile_phone_number_id = $submittalResponse->su_responder_contact_mobile_phone_number_id;
		$submittal_response_title = $submittalResponse->submittal_response_title;
		$submittal_response = $submittalResponse->submittal_response;
		$submittal_response_modified_timestamp = $submittalResponse->modified;
		$submittal_response_created_timestamp = $submittalResponse->created;

		$escaped_submittal_response_title = $submittalResponse->escaped_submittal_response_title;
		$escaped_submittal_response_nl2br = $submittalResponse->escaped_submittal_response_nl2br;

		$suResponseCreatedTimestampInt = strtotime($submittal_response_created_timestamp);
		$suResponseCreatedTimestampDisplayString = date('n/j/Y g:ia', $suResponseCreatedTimestampInt);

		$suResponderContact = $submittalResponse->getSuResponderContact();
		/* @var $suResponderContact Contact */

		$suResponderContact->htmlEntityEscapeProperties();

		$suResponderContactFullNameHtmlEscaped = $suResponderContact->getContactFullNameHtmlEscaped();
		$su_responder_contact_escaped_title =($suResponderContact->escaped_title !='')?'('.$suResponderContact->escaped_title.')':'';

		$responseHeaderInfo = "Answered $suResponseCreatedTimestampDisplayString by $suResponderContactFullNameHtmlEscaped $su_responder_contact_escaped_title";

		$tableSuResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="SUBMITTAL_table2_content">
				$responseHeaderInfo
				<br>
				<p style="font-size: 13px;">$escaped_submittal_response_nl2br</p>
			
END_HTML_CONTENT;
// if($su_responder_contact_id == $contact_id || $userCanManageSubmittals  || $res)
if($userCanManageSubmtlsRT || $userCanAnswerSubmittals){
if($su_responder_contact_id == $contact_id  || $res)
{
		$tableSuResponses .= <<<END_HTML_CONTENT

<p style="font-size: 13px;" align="right"><input onclick="Submittals__DeleteAnswer($submittal_response_id,$submittal_id);" value="Delete" type="button"></p>
END_HTML_CONTENT;
}
}
		$tableSuResponses .= <<<END_HTML_CONTENT
		</td>
		</tr>
END_HTML_CONTENT;

	}
	if ($tableSuResponses == '') {

		$tableSuResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="SUBMITTAL_table2_content">No answers.</td>
		</tr>
END_HTML_CONTENT;

	}

	$loadAllSubmittalPrioritiesOptions = new Input();
	$loadAllSubmittalPrioritiesOptions->forceLoadFlag = true;
	$arrSubmittalPriorities = SubmittalPriority::loadAllSubmittalPriorities($database, $loadAllSubmittalPrioritiesOptions);
	$ddlSuPrioritiesId = 'ddl--manage-submittal-record--submittals--submittal_priority_id--' . $submittal_id;
	$js = "onchange='Submittals__updateSuViaPromiseChain(this);' $editdisable";
	$ddlSuPriorities = PageComponents::dropDownListFromObjects($ddlSuPrioritiesId, $arrSubmittalPriorities, 'submittal_priority_id', null, 'submittal_priority', null, $submittal_priority_id, '4', $js, '');
	//subcontractor
	$suDraftsHiddenContactsByUserCompanyIdToElementId = "create-submittal_draft-record--submittal_drafts--su_initiator_contact_id--$submittal_id";
	$input = new Input();
	$input->database = $database;
	$input->user_company_id = $user_company_id;
	$input->costcode = $su_cost_code_id;
	$input->project_id = $project_id;
	$input->selected_contact_id = $su_initiator_contact_id;
	$input->htmlElementId = "ddl--manage-submittal-record--submittals--su_initiator_contact_id--$submittal_id";
	//to make disabled whenit has view alone #subcont will initialze search select
	$selectsearch =($userCanManageSubmtlsRT)?"subcont":"";
	
	$input->js = " class='moduleSUBMITTAL_dropdown4 $selectsearch '  style='width:300px;' $editdisable";
	// onchange="Submittals__updateSuViaPromiseChain(this);"
	$input->firstOption = 'Select a contact';
	$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildSubmittalsContactsFullNameWithEmailByUserCompanyIdDropDownList($input);

	//End of subcontractor

	$loadAllSubmittalStatusesOptions = new Input();
	$loadAllSubmittalStatusesOptions->forceLoadFlag = true;
	$arrSubmittalStatuses = SubmittalStatus::loadAllSubmittalStatuses($database, $loadAllSubmittalStatusesOptions);
	$ddlSuStatusesId = 'ddl--manage-submittal-record--submittals--submittal_status_id--' . $submittal_id;
	$js = "onchange='Submittals__updateSuViaPromiseChain(this);' $editdisable";
	$ddlSuStatuses = PageComponents::dropDownListFromObjects($ddlSuStatusesId, $arrSubmittalStatuses, 'submittal_status_id', null, 'submittal_status', null, $submittal_status_id, '4', $js, '');

	$tableSuAttachments = '';
	$loadSubmittalAttachmentsBySubmittalIdOptions = new Input();
	$loadSubmittalAttachmentsBySubmittalIdOptions->forceLoadFlag = true;
	$arrSubmittalAttachments = SubmittalAttachment::loadSubmittalAttachmentsBySubmittalId($database, $submittal_id, $loadSubmittalAttachmentsBySubmittalIdOptions);
	$countArrayChecked = count($arrSubmittalAttachments);
	$countchecked = 0;
	foreach ($arrSubmittalAttachments as $submittalAttachment) {
		/* @var $submittalAttachment SubmittalAttachment */

		$submittal_attachment_id = $submittalAttachment->submittal_id . '-' . $submittalAttachment->su_attachment_file_manager_file_id;
		$su_attachment_file_manager_file_id = $submittalAttachment->su_attachment_file_manager_file_id;
		$su_attachment_source_contact_id = $submittalAttachment->su_attachment_source_contact_id;
		$is_added = $submittalAttachment->is_added;
		$sort_order = $submittalAttachment->sort_order;

		$suAttachmentSourceContact = Contact::findContactByIdExtended($database, $su_attachment_source_contact_id);
		$suAttachmentSourceContactFullName = $suAttachmentSourceContact->getContactFullName();

		$fileManagerFile = FileManagerFile::findById($database, $su_attachment_file_manager_file_id);
		$file_manager_file_id = $fileManagerFile->file_manager_file_id;
		$user_company_id = $fileManagerFile->user_company_id;
		$user_id = $fileManagerFile->user_id;
		$project_id = $fileManagerFile->project_id;
		$file_manager_folder_id = $fileManagerFile->file_manager_folder_id;
		$file_location_id = $fileManagerFile->file_location_id;
		$virtual_file_name = $fileManagerFile->virtual_file_name;
		$virtual_file_mime_type = $fileManagerFile->virtual_file_mime_type;
		$modified = $fileManagerFile->modified;
		$created = $fileManagerFile->created;
		$deleted_flag = $fileManagerFile->deleted_flag;
		$directly_deleted_flag = $fileManagerFile->directly_deleted_flag;

		$fileManagerFile = FileManagerFile::findById($database, $su_attachment_file_manager_file_id);
		/* @var $fileManagerFile FileManagerFile */
		$virtual_file_name = $fileManagerFile->virtual_file_name;
		$fileUrl = $fileManagerFile->generateUrl();
		$elementId = 'record_container--manage-submittal_attachment-record--submittal_attachments--' . $submittal_attachment_id;

		$addedAttachement=($is_added =='y')?'checked=true':'';

		if ($is_added =='y') {
			$countchecked++;
		}

		$tableSuAttachments .= <<<END_HTML_CONTENT

		<tr id="$elementId">
		<td width="1%"><input type="checkbox" class="actselect bs-tooltip" data-original-title="Selected attachments will be compiled into single PDF" id="attach_$submittal_attachment_id" onclick="updateSubmittalAttachment('$submittal_attachment_id')" value="$submittal_attachment_id" $addedAttachement $editdisable_my_notes/></td>
			<td width="60%">
END_HTML_CONTENT;

if($userCanManageSubmtlsRT){
$tableSuAttachments .= <<<END_HTML_CONTENT
				<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">
				<a href="javascript:Submittals__deleteSubmittalAttachmentViaPromiseChain('$elementId', 'manage-submittal_attachment-record', '$submittal_attachment_id');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>
END_HTML_CONTENT;
}

$tableSuAttachments .= <<<END_HTML_CONTENT
				<input type="hidden" id="att_$submittalAttachment->su_attachment_file_manager_file_id" class="attachdrag">
				<a href="$fileUrl" class="bs-tooltip " data-original-title="Selected attachments will be compiled into single PDF" target="_blank">$virtual_file_name</a>
			</td>
			<td width="40%">$suAttachmentSourceContactFullName </td>
		</tr>
END_HTML_CONTENT;
	}

	if ($countArrayChecked == 0) {
		$tableSuAttachments .= <<<END_HTML_CONTENT
			<tr><td colspan="3">No Files Attached</td></tr>
END_HTML_CONTENT;
	}

	$attachmentNumber = 1;

	if($userCanManageSubmtlsRT || $userCanAnswerSubmittals){
	/* file uploader*/
	$input = new Input();
	$input->id = 'uploader--submittal_attachments--manage-submittal-record';
	$input->folder_id = $suFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Submittals/';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadSubmittalAttachment';
	$input->allowed_extensions = 'pdf';
	$input->post_upload_js_callback = "Submittals__postProcessSuAttachmentsViaPromiseChain(arrFileManagerFiles, 'container--submittal_attachments--manage-submittal-record')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();
}

	
	$arrSubmittalNotificationsBySubmittalId = array();

	$tableSuNotificationsTbody = <<<END_HTML_CONTENT

	<tr>
		<td width="46%" class="SUBMITTAL_table_header2">Subcontractor Notifications Sent</td>
		<td width="24%" class="SUBMITTAL_table_header2">Date Sent</td>
	</tr>
END_HTML_CONTENT;

	$suNotificationTitle = "Submittal Notification #$submittal->su_sequence_number";

	$suRecipientContactFullName = 'Subcontractor Name';
	$encodedSuRecipientFullName = Data::entity_encode($suRecipientContactFullName);

	foreach ($arrSubmittalNotificationsBySubmittalId as $submittal_notification_id => $submittalNotification) {
		/* @var $submittalNotification SubmittalNotification */
		$submittal_notification_timestamp = $submittalNotification->submittal_notification_timestamp;

		$loadSubmittalRecipientsBySubmittalNotificationIdOptions = new Input();
		$loadSubmittalRecipientsBySubmittalNotificationIdOptions->forceLoadFlag = true;
		$arrSubmittalRecipientsBySubmittalNotificationId = SubmittalRecipient::loadSubmittalRecipientsBySubmittalNotificationId($database, $submittal_notification_id, $loadSubmittalRecipientsBySubmittalNotificationIdOptions);

		$tableSuNotificationsTbody .= <<<END_HTML_CONTENT

		<tr>
			<td class="SUBMITTAL_table2_content2">$suNotificationTitle - $suRecipientContactFullNameHtmlEscaped - PDF File.pdf</td>
			<td class="SUBMITTAL_table2_content2">$submittal_notification_timestamp</td>
		</tr>
END_HTML_CONTENT;

	}
	if (count($arrSubmittalNotificationsBySubmittalId) == 0) {
		$tableSuNotificationsTbody = '';
	}

	$viewPdfHtml = '';
	$su_file_manager_file_id = $submittal->su_file_manager_file_id;
	if (isset($su_file_manager_file_id) && !empty($su_file_manager_file_id)) {
		$suFileManagerFile = FileManagerFile::findById($database, $su_file_manager_file_id);
		$suPdfUrl = $suFileManagerFile->generateUrl();
		$suclick="Submittals__openSuPdfInNewTab('$suPdfUrl');";
	}else
	{
		$suPdfUrl = "";
		$suclick="";
	}
	//To make the view pdf button visible
		$viewPdfHtml = <<<END_HTML_CONTENT
		<input type="button" onclick="$suclick" value="View Submittal PDF" style="font-size: 10pt;">&nbsp;
END_HTML_CONTENT;
	

	$submittalResponseType = SubmittalResponseType::findBySubmittalResponseType($database, 'Answer');
	$submittal_response_type_id = $submittalResponseType->submittal_response_type_id;
	$addedTotalAttachement="";
	if (($countArrayChecked == $countchecked) && $countArrayChecked != 0) {
		$addedTotalAttachement='checked=true';
	}

	
	$saveNoEmailBtn = '';
	if($userCanManageSubmtlsRT) {
		$saveNoEmailBtn = <<<SAVE_NO_EMAIL_BTN
		<input id="Submittals__createSuResponseViaPromiseChain" type="button" value="Save Changes To This Submittal No Email" onclick="Submittals__createSuResponseViaPromiseChain('create-submittal_response-record', '$dummyId');" style="font-size: 10pt;">
SAVE_NO_EMAIL_BTN;
	}
	$emailmessage = '';

	if($userCanManageSubmtlsRT || $userCanAnswerSubmittals){
		$saveNotifyEmail = <<<SAVE_NOTIFY_EMAIL_BTN
		<input id="Submittals__createSuResponseAndSendEmailViaPromiseChain" type="button" value="Save Changes To This Submittal And Notify Team" onclick="Submittals__createSuResponseAndSendEmailViaPromiseChain('create-submittal_response-record', '$dummyId');" style="font-size: 10pt;">
SAVE_NOTIFY_EMAIL_BTN;
	}
	if ($userCanManageSubmtlsRT) {
		$emailmessage = <<<END_EMAIL_CONTENT
		<table border="0" cellpadding="4" cellspacing="0" style="width: 100%;margin-top: 5px;">
				<tbody>
					<tr>
						<td class="SUBMITTAL_table_header2" style="vertical-align: middle;">Email:
						<span style="float: right;">$ddlsuTofield</span></td>
					</tr>
					<tr>
						<td class="SUBMITTAL_table2_content Subsearch">
							<input id="create-submittal-record--submittals--su_recipient_contact_id--$dummyId" type="hidden" value="$su_recipient_contact_id">
							<input id="create-submittal_draft-record--submittal_drafts--su_recipient_contact_id--$dummyId" type="hidden" value="$su_recipient_contact_id">
							<div>
								<p><span><b>To : </b></span><span id="toemailist">$toemailist</span></p>
								
							</div>
							<div>
								<p><span><b>Cc : </b></span><span id="ccemailist">$ccemailist</span></p>
								<ul id="record_container--submittal_recipients--Cc" style="list-style:none;display:none;">
								  $ccRecipientList
								</ul>
							</div>
							<div>
								<p><span><b>Bcc : </b></span><span id="bccemailist">$bccemailist</span></p>
								<ul id="record_container--submittal_recipients--Bcc" style="list-style:none;display:none;" >
								  $bccRecipientList
								</ul>
							</div>
							<p>Add additional text to the body of the email: </p>
							<p><textarea id="edit_textareaEmailBody--$dummyId" class="SUBMITTAL_table2" onblur="setTempEmailBody(document.getElementById('edit_textareaEmailBody--$dummyId').value)">$tempEmailBody</textarea></p>
						</td>
					</tr>
					</tbody>
				</table>
END_EMAIL_CONTENT;

		$editTitle = <<<END_EDIT_CONTENT
		<span class="mouseCursorMove" onclick="Submittals__showEditSuTitle(this);"><img src="images/edit-icon.png"></span>
END_EDIT_CONTENT;
	
		$topicEdit = <<<EDIT_TOPIC_BTN
		<input type="button" onclick="Submittals__showEditSuStatement(this);" value="Edit">
EDIT_TOPIC_BTN;
	}
	$table_class_manage = '';
	$drop_box_class_manage = ' style="width: 210px; margin: auto;"';
	if ($userCanManageSubmtlsRT) {
		$table_class_manage = ' style="width:70%; float: left;" ';
		$drop_box_class_manage = ' style="width: 27%; float: left; margin-top: 8px; padding-left: 10px;" ';
	}

	if($su_due_date)
	{
		$dateObj = DateTime::createFromFormat('Y-m-d', $su_due_date);
		$su_due_date = $dateObj->format('m/d/Y');
	}
	if($su_closed_date){
		 $duedatestatus="disabled";
	}else{
		 $duedatestatus="";
	}
	$su_attachment_source_contact_id =$su_creator_contact_id=$contact_id;

	$htmlContent = <<<END_HTML_CONTENT
	<style>
		.boxViewUploader .qq-upload-button {
		    width: 125px;
		}
	</style>
<div class="SUBMITTAL_table">
	<div class="SUBMITTAL_table_dark_header">Submittal #$su_sequence_number &mdash; 
		<span id="divShowSuTitle">
			$escaped_su_title
			<span style="padding-left:10px;">$editTitle</span>
		</span>
		<span id="divEditSuTitle" class="hidden">
			<input id="manage-submittal-record--submittals--su_title--$submittal_id" type="text" onkeyup="su_isTitleError($submittal_id)" class="su_title_$submittal_id required" value="$escaped_su_title" $editdisable>
			<span class="mouseCursorMove" onclick="Submittals__updateSuViaPromiseChain($(this).prev());"><img src="images/buttons/button-checkmark-green.png"></span>
			<span class="mouseCursorMove" onclick="Submittals__cancelEditSuTitle(this);"><img src="images/buttons/button-cancel.png"></span>
		</span>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="4">

		<tr>
		<td colspan="2" class="SUBMITTAL_table_header2">Topic</td>
		<td width="50%"  class="SUBMITTAL_table_header2">Submittal Status</td>
		</tr>

		<tr>
		<td colspan="2" class="SUBMITTAL_table2_content">
			<div id="divShowSuStatement">
				<p style="font-size: 13px" id="manage-submittal-record--submittals--su_statement_p--$submittal_id">$escaped_su_statement_nl2br</p>
				<div class="textAlignRight">
					$topicEdit
				</div>
			</div>
			<div id="divEditSuStatement" class="hidden">
				<textarea id="manage-submittal-record--submittals--su_statement--$submittal_id" class="SUBMITTAL_table2 required">$escaped_su_statement</textarea>
				<div class="textAlignRight" style="margin-top:10px">
					<input type="button" onclick="Submittals__cancelEditSuStatement();" value="Cancel">
					<input type="button" onclick="Submittals__updateSuViaPromiseChain($(this).parent().prev()[0]);" value="Save">
				</div>
			</div>
		</td>
		<td rowspan="10"  class="SUBMITTAL_table2_content" style="padding:0px;">

			<table border="0" cellpadding="2" cellspacing="0" width="100%">
				<tr>
					<td nowrap align="right" style="width: 200px;"><b>Submittal Creator:</b></td>
					<td nowrap>$suCreatorDisplayName</td>
				</tr>
				<!--tr>
					<td nowrap align="right" style="width: 200px;"><b>Submittal Initiator:</b></td>
					<td nowrap>$suInitiatorDisplayName</td>
				</tr-->
				<tr>
					<td nowrap align="right" style="width: 200px;"><b>Submittal Recipient:</b></td>
					<td nowrap style="width: 500px;">$suRecipientDisplayName</td>
				</tr>
				<tr>
					<td nowrap align="right" style="width: 200px;"><b>Submittal (Subcontractor):</b></td>
					<td nowrap>$contactsFullNameWithEmailByUserCompanyIdDropDownList</td>
				</tr>
				<tr>
					<td nowrap align="right" style="width: 200px;"><b>Submittal Priority:</b></td>
					<td nowrap>$ddlSuPriorities</td>
				</tr>
				<tr>
					<td nowrap align="right" style="width: 200px;"><b>Submittal Status:</b></td>
					<td nowrap>$ddlSuStatuses</td>
				</tr>
				<tr>
					<td nowrap align="right" style="width: 200px;"><b>Submittal Open Date:</b></td>
					<td nowrap>$suCreatedTimestampDisplayString</td>
				</tr>
				<tr>
					<td nowrap align="right" style="width: 200px;"><b>Submittal Approved Date:</b></td>
					<td nowrap>$suApprovedTimestampDisplayString</td>
				</tr>
			</table>

			<div class="clearBoth textAlignCenter" style="margin-bottom:4px">
				$viewPdfHtml
			</div>
			<div>
				<div class="SUBMITTAL_table" {$table_class_manage}>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="SUBMITTAL_table_header">
						<tr>
						<td width=""><input type="checkbox" id="allAttach_$submittal_id" onclick=selectAllSubmittal('$submittal_id') $addedTotalAttachement $editdisable_my_notes></td>
							<td width="65%">Attachment</td>
							<td width="35%">Creator</td>
						</tr>
					</table>
					<div class="RIF_table_content_div">
						<table id="container--submittal_attachments--manage-submittal-record" width="100%" border="0" cellspacing="0" cellpadding="4" class="RIF_table_content_tbl">
						<tbody id="attachsort">
							$tableSuAttachments
							</tbody>
						</table>
					</div>
				</div>
				<div class="textAlignCenter" {$drop_box_class_manage}>
					{$fileUploader}
					{$fileUploaderProgressWindow}
					<!--br>
					<input onclick="generateSuTempFileListAsQueryString('uploaded-temp-file');" type="button" value="JSON Temp Files"-->
				</div>
			</div>
			<br>

			<!-- Temp Files -->
			<ul id="record_list_container--uploaded-temp-file" style="display: none;">
			</ul>

			<input id="temp-files-next-position--submittal_attachments" type="hidden" value="1">
			<div id="file-uploader-container--temp-files" class="displayNone SUBMITTAL_table">
				<table width="100%" cellspacing="0" cellpadding="4" border="0" class="SUBMITTAL_table_header">
					<tbody>
						<tr>
							<td nowrap width="65%">Pending Attachments</td>
							<td width="35%">Creator</td>
						</tr>
					</tbody>
				</table>
				<div class="RIF_table_content_div">
					<table id="record_list_container--uploaded-temp-file--submittal_attachments" class="RIF_table_content_tbl" width="100%" cellspacing="0" cellpadding="4" border="0">
					</table>
				</div>
			</div>
			$emailmessage
		</td>
		</tr>

		<tr>
		<td colspan="2" class="SUBMITTAL_table_header2">Note(s)</td>
		</tr>

		$tableSuResponses
		$suToRecipientsList

		<tr>
		<td colspan="2" class="SUBMITTAL_table_header2">Submittal Due Date:</td>
		</tr>

		<tr>
			<td colspan="2" class="SUBMITTAL_table2_content">
				<input id="create-submittal-record--submittals--su_due_date--$submittal_id" class="SUBMITTAL_table3 datepicker" type="text" onchange="Submittals__updateSuViaPromiseChain(this)" value="$su_due_date" $duedatestatus $editdisable>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="SUBMITTAL_table_header2">Tag:</td>
		</tr>
		<tr>
		<td class="SUBMITTAL_table2_content">
		<div class="form-group">
		<div class="input-group" style="display:flex">
		<input type="text" id="search_data" placeholder="" autocomplete="off" class="form-control input-lg" width="500px !important" value="$su_tag_name"/>
		<span class="mouseCursorMove"  onclick="Submittal__updateTag('$submittal_id');" style="padding-left:5px;"><img src="images/buttons/button-checkmark-green.png" style="padding-top: 5px;width: 25px;"></span>
		</div><div id="search_null" style="margin-top:5px;display:none;">No Search Result </div>
		</div>
		
		</td>
		</tr>

		<tr>
		<td colspan="2" class="SUBMITTAL_table_header2">My Notes</td>
		</tr>

		<tr>
		<td id="container--create-submittal_response-record--$dummyId" colspan="2" class="SUBMITTAL_table2_content">
			<textarea id="create-submittal_response-record--submittal_responses--submittal_response--$dummyId" class="SUBMITTAL_table2 required" onblur="setTempNotes(document.getElementById('create-submittal_response-record--submittal_responses--submittal_response--$dummyId').value)" $editdisable_my_notes >$tempNotes</textarea><br>
			<div class="textAlignRight" style="margin-top:10px; font-size: 10pt">
				$saveNotifyEmail
				&nbsp;
				$saveNoEmailBtn
				<!--<input id="buttonGeneratePdf" type="button" value="Notify Subcontractors" onclick="" >-->
			</div>
		</td>
		</tr>

		$tableSuNotificationsTbody

	</table>
	<input type="hidden" id="submittalToId" value="$EmailToId">
	<input type="hidden" id="submittalccId" value="$EmailCcId">
	<input type="hidden" id="submittalbccId" value="$EmailBccId">
	<input type="hidden" id="submittal_id" value="$submittal_id">
	<input type="hidden" id="su-edit" value="yes">

	<input type="hidden" id="create-submittal_response-record--submittal_responses--submittal_id--$dummyId" value="$submittal_id">
	<input type="hidden" id="create-submittal_response-record--submittal_responses--submittal_response_type_id--$dummyId" value="$submittal_response_type_id">
	<input id="create-submittal-record--submittals--dummy_id" type="hidden" value="$dummyId">
	<input id="create-submittal_notification-record--submittal_notifications--submittal_id--$dummyId" type="hidden" value="$dummyId">
        <input id="create-submittal_recipient-record--submittal_recipients--submittal_notification_id--$dummyId" type="hidden" value="$dummyId">


<input id="create-submittal-record--submittals--submittal_draft_id--$dummyId" type="hidden" value="$submittal_draft_id">
<input id="create-submittal-record--submittals--submittal_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-submittal-record--submittals--su_attachment_source_contact_id--$dummyId" type="hidden" value="$su_attachment_source_contact_id">
<input id="create-submittal-record--submittals--su_creator_contact_id--$dummyId" type="hidden" value="$su_creator_contact_id">
<input id="create-submittal-record--submittals--project_id--$dummyId" type="hidden" value="$project_id">
<input id="create-submittal-record--submittals--sendNotification--$dummyId" type="hidden" value="false">
<input id="create-submittal_recipient-record--submittal_recipients--smtp_recipient_header_type--$dummyId" type="hidden" value="Cc">
<input id="create-submittal_attachment-record--submittal_attachments--submittal_id--$dummyId" type="hidden" value="">
<input id="create-submittal_attachment-record--submittal_attachments--submittal_draft_id--$dummyId" type="hidden" value="">
<input id="create-submittal_attachment-record--submittal_attachments--su_attachment_source_contact_id--$dummyId" type="hidden" value="$su_attachment_source_contact_id">
<input id="create-submittal_attachment-record--submittal_attachments--csvSuFileManagerFileIds--$dummyId" type="hidden" value="$csvSuFileManagerFileIds">
</div>
END_HTML_CONTENT;

	return $htmlContent;

}
function buildCreateSuDialog($database, $user_company_id, $project_id, $currently_active_contact_id, $dummyId=null, $submittalDraft=null)
{
	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}

	$session = Zend_Registry::get('session');
	$login_name=$session->getLoginName();
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
	// PERMISSION VARIABLES
	$permissions = Zend_Registry::get('permissions');

	//Check the permisson for view delay
	$userRole = $session->getUserRole();
	$userCanManageSubmtlsRT = true;
	if($userRole != 'global_admin'){
		$userCanManageSubmtlsRT = checkPermissionForAllModuleAndRole($database,'submittals_manage');
	}
	$toid = $bccid= $toemailist = $bccemailist = "";
	$ccid = $currentlyActiveContactId.",";
	$ccemailist =$login_name.",";
	// Update / Save case
	if ($submittalDraft) {
		/* @var $submittalDraft SubmittalDraft */

		$submittal_draft_id = (string) $submittalDraft->submittal_draft_id;
		$submittal_type_id = (string) $submittalDraft->submittal_type_id;
		$submittal_status_id = (int) $submittalDraft->submittal_status_id;
		$submittal_priority_id = (string) $submittalDraft->submittal_priority_id;
		$submittal_distribution_method_id = (string) $submittalDraft->submittal_distribution_method_id;
		$su_file_manager_file_id = (string) $submittalDraft->su_file_manager_file_id;
		$su_cost_code_id = (string) $submittalDraft->su_cost_code_id;
		$su_creator_contact_id = (string) $submittalDraft->su_creator_contact_id;
		$su_creator_contact_company_office_id = (string) $submittalDraft->su_creator_contact_company_office_id;
		$su_creator_phone_contact_company_office_phone_number_id = (string) $submittalDraft->su_creator_phone_contact_company_office_phone_number_id;
		$su_creator_fax_contact_company_office_phone_number_id = (string) $submittalDraft->su_creator_fax_contact_company_office_phone_number_id;
		$su_creator_contact_mobile_phone_number_id = (string) $submittalDraft->su_creator_contact_mobile_phone_number_id;
		$su_recipient_contact_id = (string) $submittalDraft->su_recipient_contact_id;
		$su_recipient_contact_company_office_id = (string) $submittalDraft->su_recipient_contact_company_office_id;
		$su_recipient_phone_contact_company_office_phone_number_id = (string) $submittalDraft->su_recipient_phone_contact_company_office_phone_number_id;
		$su_recipient_fax_contact_company_office_phone_number_id = (string) $submittalDraft->su_recipient_fax_contact_company_office_phone_number_id;
		$su_recipient_contact_mobile_phone_number_id = (string) $submittalDraft->su_recipient_contact_mobile_phone_number_id;
		$su_initiator_contact_id = (string) $submittalDraft->su_initiator_contact_id;
		$su_initiator_contact_company_office_id = (string) $submittalDraft->su_initiator_contact_company_office_id;
		$su_initiator_phone_contact_company_office_phone_number_id = (string) $submittalDraft->su_initiator_phone_contact_company_office_phone_number_id;
		$su_initiator_fax_contact_company_office_phone_number_id = (string) $submittalDraft->su_initiator_fax_contact_company_office_phone_number_id;
		$su_initiator_contact_mobile_phone_number_id = (string) $submittalDraft->su_initiator_contact_mobile_phone_number_id;
		$su_title = (string) $submittalDraft->su_title;
		$su_plan_page_reference = (string) $submittalDraft->su_plan_page_reference;
		$su_statement = (string) $submittalDraft->su_statement;
		$su_due_date = (string) $submittalDraft->su_due_date;
		$su_spec_no = (string) $submittalDraft->su_spec_no;
		$su_tag_ids =  $submittalDraft->tag_ids;
		// to get the RFI tag id
		$su_tag_name = Tagging::getTagName($database,$su_tag_ids);
        
        $loadSubmittalDraftRecipientsBySubmittalDraftIdOptions = new Input();
		$loadSubmittalDraftRecipientsBySubmittalDraftIdOptions->forceLoadFlag = true;

		// $additionalRecipients = SubmittalDraftRecipient::loadSubmittalDraftRecipientsBySubmittalDraftId($database, $submittal_draft_id, $loadSubmittalDraftRecipientsBySubmittalDraftIdOptions);		// HTML Entity Escaped Data
		$submittalDraft->htmlEntityEscapeProperties();
		$escaped_su_plan_page_reference = $submittalDraft->escaped_su_plan_page_reference;
		$escaped_su_statement = $submittalDraft->escaped_su_statement;
		$escaped_su_statement_nl2br = $submittalDraft->escaped_su_statement_nl2br;
		$escaped_su_title = $submittalDraft->escaped_su_title;

		$additionalRecipients = SubmittalDraftRecipient::loadDraftRecipients($database, $submittal_draft_id, $loadSubmittalDraftRecipientsBySubmittalDraftIdOptions);
		// echo "<pre>";
		// print_r($additionalRecipients);exit;
		$ccid = "";
		$ccemailist ="";
		foreach ($additionalRecipients as $key => $rvalue) {
			$htype = $rvalue['smtp_recipient_header_type'];
			if($rvalue['sur_fk_c__first_name'] !="" || $rvalue['sur_fk_c__last_name']!="")
			{
				$cname =$rvalue['sur_fk_c__first_name'] ." ".$rvalue['sur_fk_c__last_name'];
			}else
			{
				$cname=$rvalue['sur_fk_c__email'];
			}
			if($htype =="To")
			{
				$toid .= $rvalue['su_additional_recipient_contact_id'].",";
				$toemailist .= $cname.",";
			}else if($htype =="Cc")
			{
				$ccid .= $rvalue['su_additional_recipient_contact_id'].",";
				$ccemailist .= $cname.",";
			}else
			{
				$bccid .= $rvalue['su_additional_recipient_contact_id'].",";
				$bccemailist .= $cname.",";
			}
		}
		$toemailist = rtrim($toemailist,',');
		$ccemailist = rtrim($ccemailist,',');
		$bccemailist = rtrim($bccemailist,',');

		

		$buttonDeleteSuDraft = <<<END_HTML_CONTENT
<input type="button" value="Delete This Draft" onclick="Submittals__deleteSubmittalDraft('manage-submittal_draft-record', 'submittal_drafts', '$submittal_draft_id', { successCallback: Submittals__deleteSubmittalDraftSuccess });" style="font-size: 10pt;">
END_HTML_CONTENT;

		$liSubmittalDraftAttachments = '';
		$arrSuFileManagerFileIds = array();
		$loadSubmittalDraftAttachmentsBySubmittalDraftIdOptions = new Input();
		$loadSubmittalDraftAttachmentsBySubmittalDraftIdOptions->forceLoadFlag = true;
		$arrSubmittalDraftAttachments = SubmittalDraftAttachment::loadSubmittalDraftAttachmentsBySubmittalDraftId($database, $submittal_draft_id, $loadSubmittalDraftAttachmentsBySubmittalDraftIdOptions);
		foreach ($arrSubmittalDraftAttachments as $submittal_draft_attachment_id => $submittalDraftAttachment) {
			/* @var $submittalDraftAttachment SubmittalDraftAttachment */

			$file_manager_file_id = $submittalDraftAttachment->su_attachment_file_manager_file_id;
			$file_manager_file_id_draft = $submittalDraftAttachment->submittal_draft_id.'-'.$submittalDraftAttachment->su_attachment_file_manager_file_id;
			$su_attachment_source_contact_id = $submittalDraftAttachment->su_attachment_source_contact_id;
			$fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$fileManagerFile->htmlEntityEscapeProperties();
			$virtual_file_name = $fileManagerFile->virtual_file_name;
			$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
			$fileUrl = $fileManagerFile->generateUrl();

			$arrSuFileManagerFileIds[] = $file_manager_file_id;

			$dummySuDraftAttachmentId = Data::generateDummyPrimaryKey();

			$elementId = "record_container--manage-file_manager_file-record--file_manager_files--$file_manager_file_id";

			$liSubmittalDraftAttachments .= <<<END_LI_SUBMITTAL_DRAFT_ATTACHMENTS

			<li id="record_container--create-submittal_draft_attachment-record--submittal_draft_attachments--$dummySuDraftAttachmentId" class="hidden">
				<input id="create-submittal_attachment-record--submittal_attachments--submittal_id--$dummySuDraftAttachmentId" type="hidden" value="$dummySuDraftAttachmentId">
				<input id="create-submittal_attachment-record--submittal_attachments--submittal_draft_id--$dummySuDraftAttachmentId" type="hidden" value="$dummySuDraftAttachmentId">
				<input id="create-submittal_attachment-record--submittal_attachments--su_attachment_file_manager_file_id--$dummySuDraftAttachmentId" type="hidden" value="$file_manager_file_id">
				<input id="create-submittal_attachment-record--submittal_attachments--su_attachment_source_contact_id--$dummySuDraftAttachmentId" type="hidden" value="$su_attachment_source_contact_id">
			</li>
			<li id="$elementId">
				<a href="javascript:deleteFileManagerFileDraftAttachSubmittal('$elementId', 'manage-file_manager_file-record', '$file_manager_file_id_draft');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;
				<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
			</li>
END_LI_SUBMITTAL_DRAFT_ATTACHMENTS;

		}

		$csvSuFileManagerFileIds = join(',', $arrSuFileManagerFileIds);

		// <input type="button" value="Save As A New Submittal Draft" onclick="Submittals__createSuDraftViaPromiseChain('create-submittal-record', '$dummyId');" style="font-size: 10pt;">

		// Save Submittal As Draft Button
		$saveSubmittalAsDraftButton = <<<END_SAVE_SUBMITTAL_AS_DRAFT_BUTTON
<span id="submittalDraftSaveBefore"><input type="button" id="createSubmittaldraft" value="Save Changes To This Draft" onclick="Submittals__createSuDraftViaPromiseChain('create-submittal-record', '$dummyId', { crudOperation: 'update', submittal_draft_id: $submittal_draft_id });" style="font-size: 10pt;">&nbsp;</span>
<span id="submittalDraftSaveAfter" style="display:none;"><input type="button" id=" id="createSubmittaldraft"" value="Save Submittal As Draft" onclick="Submittals__createSuDraftViaPromiseChain('create-submittal-record', '$dummyId');" style="font-size: 10pt;"></span>
END_SAVE_SUBMITTAL_AS_DRAFT_BUTTON;

	} else {

		// Create case
		$submittal_draft_id = '';
		$submittal_type_id = '1';//Default to 'Product Information'
		$submittal_status_id = 5; // Default to "Open"
		$submittal_priority_id = '1';//Default to 'Normal'
		$submittal_distribution_method_id = '1'; //Default to 'Email'
		$su_file_manager_file_id = '';
		$su_cost_code_id = '0';
		$su_creator_contact_id = '';
		$su_creator_contact_company_office_id = '';
		$su_creator_phone_contact_company_office_phone_number_id = '';
		$su_creator_fax_contact_company_office_phone_number_id = '';
		$su_creator_contact_mobile_phone_number_id = '';
		$su_recipient_contact_id = '';
		$su_recipient_contact_company_office_id = '';
		$su_recipient_phone_contact_company_office_phone_number_id = '';
		$su_recipient_fax_contact_company_office_phone_number_id = '';
		$su_recipient_contact_mobile_phone_number_id = '';
		$su_initiator_contact_id = '';
		$su_initiator_contact_company_office_id = '';
		$su_initiator_phone_contact_company_office_phone_number_id = '';
		$su_initiator_fax_contact_company_office_phone_number_id = '';
		$su_initiator_contact_mobile_phone_number_id = '';
		$su_title = '';
		$su_plan_page_reference = '';
		$su_statement = '';
		$su_due_date = '';
		$su_tag_name ='';

        $additionalRecipients = array();
		// HTML Entity Escaped Data
		$escaped_su_plan_page_reference = '';
		$escaped_su_statement = '';
		$escaped_su_statement_nl2br = '';
		$escaped_su_title = '';

		$buttonDeleteSuDraft = '';
		$csvSuFileManagerFileIds = '';

		// Save Submittal As Draft Button
		$saveSubmittalAsDraftButton = <<<END_SAVE_SUBMITTAL_AS_DRAFT_BUTTON
<input type="button" value="Save Submittal As Draft" id="createSubmittaldraft" onclick="Submittals__createSuDraftViaPromiseChain('create-submittal-record', '$dummyId');" style="font-size: 10pt;">
END_SAVE_SUBMITTAL_AS_DRAFT_BUTTON;

	}

	if (!isset($arrSubmittalDraftAttachments) || count($arrSubmittalDraftAttachments) == 0) {
		$liSubmittalDraftAttachments = '<li class="placeholder">No Files Attached</li>';
	}

    $ccRecipientList = '';
    $bccRecipientList = '';
    foreach ($additionalRecipients as $key => $value) {
    	$contactData = Contact::findById($database, $value['su_additional_recipient_contact_id']);
    	$contactName = Contact::ContactNameById($database,$value['su_additional_recipient_contact_id']);
    	if($value['smtp_recipient_header_type'] == 'Cc'){
    		$ccRecipientList .= 
    		'<li id="'.$value['su_additional_recipient_contact_id'].'">
              <a href="#" onclick="Submittals__removeRecipient(this); return false;">X</a>&nbsp;
              <span id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id_span--'.$dummyId.'">
                  '.$contactName.'
              </span>
              <input id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--'.$dummyId.'" class="cc_recipients" type="hidden" value="'.$value['su_additional_recipient_contact_id'].'">
    		</li>';
    	}else if($value['smtp_recipient_header_type'] == 'Bcc'){
    		$bccRecipientList .= 
    		'<li id="'.$value['su_additional_recipient_contact_id'].'">
              <a href="#" onclick="Submittals__removeRecipient(this); return false;">X</a>&nbsp;
              <span id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id_span--'.$dummyId.'">
                  '.$contactName.'
              </span>
              <input id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--'.$dummyId.'" class="bcc_recipients" type="hidden" value="'.$value['su_additional_recipient_contact_id'].'">
    		</li>';
    	}
    }
    

	// FileManagerFolder
	$virtual_file_path = '/Submittals/Submittal Draft Attachments/';
	$suFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $virtual_file_path);
	/* @var $suFileManagerFolder FileManagerFolder */

	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--submittal_attachments--create-submittal-record';
	$input->folder_id = $suFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Submittals/Submittal Draft Attachments/';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadSubmittalAttachment';
	$input->allowed_extensions = 'pdf';
	$input->post_upload_js_callback = "Submittals__suDraftAttachmentUploaded(arrFileManagerFiles, 'container--submittal_attachments--create-submittal-record')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

	$suCostCodesElementId = "ddl--create-submittal-record--submittals--su_cost_code_id--$dummyId";

	$costCodesInput = new Input();
	$prependedOption = '';
	$tabIndex = '';
	$js = 'style="width:95%"';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$costCodesInput->project_id = $project_id;
	$selectedOption = $su_cost_code_id;
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $suCostCodesElementId;
	$costCodesInput->firstOption = '<option value="0">Optionally Select A Cost Code Below For Reference</option>';
	$costCodesInput->selectCssStyle = 'style="font-size: 1.3em; width: 400px;"';
	$costCodesInput->selectedOption = $su_cost_code_id;
	$suDraftsHiddenCostCodeElementId = "create-submittal_draft-record--submittal_drafts--su_cost_code_id--$dummyId";
	$costCodesInput->additionalOnchange = "ddlOnChange_UpdateHiddenInputValue(this, '$suDraftsHiddenCostCodeElementId');updatecostcodeusers(this.value,&apos;$dummyId&apos;,&apos;$user_company_id&apos;,&apos;$project_id&apos;);";
	$ddlCostCodes = buildProjectCostCodeDropDownList($costCodesInput);

	$loadAllSubmittalPrioritiesOptions = new Input();
	$loadAllSubmittalPrioritiesOptions->forceLoadFlag = true;
	$arrSubmittalPriorities = SubmittalPriority::loadAllSubmittalPriorities($database, $loadAllSubmittalPrioritiesOptions);
	$ddlSuPrioritiesId = "ddl--create-submittal-record--submittals--submittal_priority_id--$dummyId";
	$suDraftsHiddenSuPrioritiesElementId = "create-submittal_draft-record--submittal_drafts--submittal_priority_id--$dummyId";
	$js = ' style="width: 70%;" class="moduleSUBMITTAL_dropdown required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$suDraftsHiddenSuPrioritiesElementId.'\');"';
	$selectedOption = $submittal_priority_id;
	$ddlSuPriorities = PageComponents::dropDownListFromObjects($ddlSuPrioritiesId, $arrSubmittalPriorities, 'submittal_priority_id', null, 'submittal_priority', null, $selectedOption, null, $js, $prependedOption);

	$loadAllSubmittalTypesOptions = new Input();
	$loadAllSubmittalTypesOptions->forceLoadFlag = true;
	$arrSubmittalTypes = SubmittalType::loadAllSubmittalTypes($database, $loadAllSubmittalTypesOptions);
	$ddlSuTypesId = "ddl--create-submittal-record--submittals--submittal_type_id--$dummyId";
	$suDraftsHiddenSuTypesElementId = "create-submittal_draft-record--submittal_drafts--submittal_type_id--$dummyId";
	$js = ' style="width: 70%;" class="moduleSUBMITTAL_dropdown3 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$suDraftsHiddenSuTypesElementId.'\');"';
	$selectedOption = $submittal_type_id;
	$ddlSuTypes = PageComponents::dropDownListFromObjects($ddlSuTypesId, $arrSubmittalTypes, 'submittal_type_id', null, 'submittal_type', null, $selectedOption, null, $js, $prependedOption);

	$loadAllSubmittalDistributionMethodsOptions = new Input();
	$loadAllSubmittalDistributionMethodsOptions->forceLoadFlag = true;
	$arrSubmittalDistributionMethods = SubmittalDistributionMethod::loadAllSubmittalDistributionMethods($database, $loadAllSubmittalDistributionMethodsOptions);
	$ddlSuDistributionMethodsId = "ddl--create-submittal-record--submittals--submittal_distribution_method_id--$dummyId";
	$suDraftsHiddenSuDistributionMethodsElementId = "create-submittal_draft-record--submittal_drafts--submittal_distribution_method_id--$dummyId";
	$js = ' style="width: 70%;" class="moduleSUBMITTAL_dropdown3 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$suDraftsHiddenSuDistributionMethodsElementId.'\');"';
	$selectedOption = $submittal_distribution_method_id;
	$ddlSuDistributionMethods = PageComponents::dropDownListFromObjects($ddlSuDistributionMethodsId, $arrSubmittalDistributionMethods, 'submittal_distribution_method_id', null, 'submittal_distribution_method', null, $selectedOption, null, $js, $prependedOption);

	$arrContactsByUserCompanyId = Contact::loadContactsByUserCompanyId($database, $user_company_id);

	// From: Subcontractor
	// su_initiator_contact_id
	$suDraftsHiddenContactsByUserCompanyIdToElementId = "create-submittal_draft-record--submittal_drafts--su_initiator_contact_id--$dummyId";
	
	// DDL of contacts
	$input = new Input();
	$input->database = $database;
	$input->user_company_id = $user_company_id;
	$input->costcode = $su_cost_code_id;
	$input->project_id = $project_id;
	$input->selected_contact_id = $su_initiator_contact_id;
	$input->htmlElementId = "ddl--create-submittal-record--submittals--su_initiator_contact_id--$dummyId";
	$input->js = ' class="moduleSUBMITTAL_dropdown4 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$suDraftsHiddenContactsByUserCompanyIdToElementId.'\');"';
	$input->firstOption = 'Select a contact';
	$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildSubmittalsContactsFullNameWithEmailByUserCompanyIdDropDownList($input);

	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($database, $project_id, 'submittals');

	// To:
	// su_recipient_contact_id
	$ddlsuTofield = "<input type='button' id='create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--To' class='suTofiled' onclick='openProjectContactsMailing(&apos;submittals&apos;,&apos;$submittal_id&apos;)' value='Select Recipient'/> ";
	$ddlsuccfield = "<input type='button' id='create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--cc' class='suTofiled' onclick='openProjectContactsMailing(&apos;submittals&apos;,&apos;$submittal_id&apos;)' value='Select Cc'/> ";
	$ddlsubccfield = "<input type='button' id='create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--bcc' class='suTofiled' onclick='openProjectContactsMailing(&apos;submittals&apos;,&apos;$submittal_id&apos;)' value='Select Bcc'/> ";

	$suDraftsHiddenProjectTeamMembersToElementId = "create-submittal_draft-record--submittal_drafts--su_recipient_contact_id--$dummyId";
	$selectedOption = $su_recipient_contact_id;
	$js = ' class="moduleSUBMITTAL_dropdown4 required emailGroup" $editdisable onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$suDraftsHiddenProjectTeamMembersToElementId.'\');submittals_isMailToError(this);"';
	$prependedOption = '<option value="">Select a contact</option>';
	$ddlProjectTeamMembersToId = "ddl--create-submittal-record--submittals--su_recipient_contact_id--$dummyId";	
	$ddlProjectTeamMembersTo = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersToId,$selectedOption);

	// Cc:
	// su_additional_recipient_contact_id

	$ddlProjectTeamMembersCcId = "ddl--create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--Cc-$dummyId";
	$js = ' onchange="Submittals__addRecipient(this);" class="moduleSUBMITTAL_dropdown4 emailGroup"';
	$ddlProjectTeamMembersCc = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersCcId);

	// Bcc:

	$ddlProjectTeamMembersBccId = "ddl--create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--Bcc-$dummyId";
	$ddlProjectTeamMembersBcc = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersBccId);

	$su_attachment_source_contact_id = $currently_active_contact_id;
	$su_creator_contact_id = $currently_active_contact_id;
	$saveNoEmailBtn = '';
	if($userCanManageSubmtlsRT) {
		$saveNoEmailBtn = <<<SAVE_NO_EMAIL_BTN
		<input type="button" id="SuResponseViaPromiseChain" value="Save As A Submittal No Email" onclick="Submittals__createSuViaPromiseChain('create-submittal-record', '$dummyId');" style="font-size: 10pt;">
SAVE_NO_EMAIL_BTN;
	}
	$htmlContent = <<<END_HTML_CONTENT

<form id="formCreateSu">
	<div id="record_creation_form_container--create-submittal-record--$dummyId">
		<div class="SUBMITTAL_table_create">
			<table width="100%" border="0" cellpadding="4" cellspacing="0">
			<tr><td>
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td class="SUBMITTAL_table_header2 border_right_none  ">Cost Code Reference:</td>
								<td class="SUBMITTAL_table_header2 border_right_none  ">Specification Number:</td>
								
							</tr>
							<tr>
						<td class="SUBMITTAL_table2_content">
						<input id="create-submittal-record--submittals--su_cost_code_id--$dummyId" type="hidden" value="$su_cost_code_id">
						<input id="create-submittal_draft-record--submittal_drafts--su_cost_code_id--$dummyId" type="hidden" value="$su_cost_code_id">
						<span class="moduleSUBMITTAL">
						$ddlCostCodes
						</span>
					</td>
					<td class="SUBMITTAL_table2_content "><input id="create-submittal-record--submittals--su_spec_no--$dummyId" class="SUBMITTAL_table2" type="text" value="$su_spec_no"></td>
					</tr>
					</table>
			</td></tr>
				
				<tr>
					<td class="SUBMITTAL_table_header2">From (Subcontractor):</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content Subsearch">
						<input id="create-submittal-record--submittals--su_initiator_contact_id--$dummyId" type="hidden" value="$su_initiator_contact_id">
						<input id="create-submittal_draft-record--submittal_drafts--su_initiator_contact_id--$dummyId" type="hidden" value="$su_initiator_contact_id">
						<span class="" id="emailarea">
						$contactsFullNameWithEmailByUserCompanyIdDropDownList
						</span>
					</td>
				</tr>
				<tr>
					<td width="70%" class="SUBMITTAL_table_header2">Submittal Title:</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content">
						
						<input id="create-submittal-record--submittals--su_title--$dummyId" class="SUBMITTAL_table2 required" type="text" value="$escaped_su_title">
					</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table_header2">Plan Page Reference:</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content">
						<p>
							<!--<input type="text" class="SUBMITTAL_table2" name="su_plan_page_reference">-->
							<input id="create-submittal-record--submittals--su_plan_page_reference--$dummyId" class="SUBMITTAL_table2" type="text" value="$escaped_su_plan_page_reference">
						</p>
					</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table_header2">Submittal Due Date:</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content">
						<!--<input id="dueDate" type="text" class="SUBMITTAL_table3" name="su_due_date">-->
						<input id="create-submittal-record--submittals--su_due_date--$dummyId" class="SUBMITTAL_table3 datepicker" type="text" value="$su_due_date">
					</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table_header2">Submittal Notes</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content">
						<p><textarea id="create-submittal-record--submittals--su_statement--$dummyId" class="SUBMITTAL_table2 required">$su_statement</textarea></p>
						<input id="create-submittal-record--submittals--submittal_priority_id--$dummyId" type="hidden" value="$submittal_priority_id">
						<input id="create-submittal_draft-record--submittal_drafts--submittal_priority_id--$dummyId" type="hidden" value="$submittal_priority_id">
						<input id="create-submittal-record--submittals--submittal_status_id--$dummyId" type="hidden" value="$submittal_status_id">
						<input id="create-submittal_draft-record--submittal_drafts--submittal_status_id--$dummyId" type="hidden" value="$submittal_status_id">
						<input id="create-submittal-record--submittals--submittal_type_id--$dummyId" type="hidden" value="$submittal_type_id">
						<input id="create-submittal_draft-record--submittal_drafts--submittal_type_id--$dummyId" type="hidden" value="$submittal_type_id">
						<input id="create-submittal-record--submittals--submittal_distribution_method_id--$dummyId" type="hidden" value="$submittal_distribution_method_id">
						<input id="create-submittal_draft-record--submittal_drafts--submittal_distribution_method_id--$dummyId" type="hidden" value="$submittal_distribution_method_id">
						</td></tr>

						<tr>
						<td>
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td class="SUBMITTAL_table_header2 border_right_none  ">Submittal Priority:</td>
								<td class="SUBMITTAL_table_header2 border_right_none  ">Submittal Type:</td>
								<td class="SUBMITTAL_table_header2 border_right_none  ">Submittal Distribution Method:</td>
							</tr>
							<tr>
								<td class="SUBMITTAL_table2_content " >$ddlSuPriorities</td>
								<td class="SUBMITTAL_table2_content ">$ddlSuTypes</td>
								<td class="SUBMITTAL_table2_content " >$ddlSuDistributionMethods</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="SUBMITTAL_table_create margin0px">
			<table width="100%" border="0" cellspacing="0" cellpadding="4">
				<tr>
					<td width="70%" class="SUBMITTAL_table_header2">Tag:</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content">
					 <div class="form-group">
                        <div class="input-group">
                            <input type="text" id="search_data" placeholder="" autocomplete="off" class="form-control input-lg" width="500px !important" value="$su_tag_name" />
                            <div id="search_null" style="display:none;">No Search Result </div>
                            
                        </div></div>
					</td>
				</tr>
				<tr>
					<td width="70%" class="SUBMITTAL_table_header2">Select A File To Attach:</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content">{$fileUploader}{$fileUploaderProgressWindow}</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table_header2">Attached Files:</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content" id="tdAttachedFilesList">
						<ul id="container--submittal_attachments--create-submittal-record" style="list-style:none; margin:0; padding:0" class="divslides">
							$liSubmittalDraftAttachments
						</ul>
					</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table_header2" style="vertical-align: middle;">Email:
					<span style="float: right;">$ddlsuTofield</span></td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content Subsearch">
						<input id="create-submittal-record--submittals--su_recipient_contact_id--$dummyId" type="hidden" value="$su_recipient_contact_id">
						<input id="create-submittal_draft-record--submittal_drafts--su_recipient_contact_id--$dummyId" type="hidden" value="$su_recipient_contact_id">
						<p><span><b>To : </b></span><span id="toemailist">$toemailist</span></p>
						<div>
							<p><span><b>Cc : </b></span><span id="ccemailist">$ccemailist</span></p>
							<ul id="record_container--submittal_recipients--Cc" style="list-style:none;display:none;">
							  $ccRecipientList
							</ul>
						</div>
						<div>
							<p><span><b>Bcc : </b></span><span id="bccemailist">$bccemailist</span></p>
							<ul id="record_container--submittal_recipients--Bcc" style="list-style:none;display:none;">
							  $bccRecipientList
							</ul>
						</div>
						<p>Add additional text to the body of the email: </p>
						<p><textarea id="textareaEmailBody--$dummyId" class="SUBMITTAL_table2"></textarea></p>
						<p>
							<input type="button" id="SuResponseAndSendEmailViaPromiseChain" value="Save As A Submittal And Notify Team" onclick="Submittals__createSuAndSendEmailViaPromiseChain('create-submittal-record', '$dummyId');" style="font-size: 10pt;">&nbsp;
							$saveNoEmailBtn
						</p>
						<p>
							$saveSubmittalAsDraftButton&nbsp;&nbsp;<span id="spanDeleteSuDraft">$buttonDeleteSuDraft</span>
						</p>
						<span class="fakeHref verticalAlignBottom" onclick="showHideDomElement('su_draft_help');">(?)</span><span id="su_draft_help" class="displayNone verticalAlignBottom"> Note: Saving the Submittal as a Draft will save your files and the Email To, but not the message..</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>
<input type="hidden" id="submittalToId" value="$toid">
	<input type="hidden" id="submittalccId" value="$ccid">
	<input type="hidden" id="submittalbccId" value="$bccid">
<input id="create-submittal-record--submittals--submittal_draft_id--$dummyId" type="hidden" value="$submittal_draft_id">
<input id="create-submittal-record--submittals--submittal_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-submittal-record--submittals--su_attachment_source_contact_id--$dummyId" type="hidden" value="$su_attachment_source_contact_id">
<input id="create-submittal-record--submittals--su_creator_contact_id--$dummyId" type="hidden" value="$su_creator_contact_id">
<input id="create-submittal-record--submittals--project_id--$dummyId" type="hidden" value="$project_id">
<input id="create-submittal-record--submittals--dummy_id" type="hidden" value="$dummyId">
<input id="create-submittal-record--submittals--sendNotification--$dummyId" type="hidden" value="false">
<input id="create-submittal_notification-record--submittal_notifications--submittal_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-submittal_recipient-record--submittal_recipients--submittal_notification_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-submittal_recipient-record--submittal_recipients--smtp_recipient_header_type--$dummyId" type="hidden" value="Cc">
<input id="create-submittal_attachment-record--submittal_attachments--submittal_id--$dummyId" type="hidden" value="">
<input id="create-submittal_attachment-record--submittal_attachments--submittal_draft_id--$dummyId" type="hidden" value="">
<input id="create-submittal_attachment-record--submittal_attachments--su_attachment_source_contact_id--$dummyId" type="hidden" value="$su_attachment_source_contact_id">
<input id="create-submittal_attachment-record--submittal_attachments--csvSuFileManagerFileIds--$dummyId" type="hidden" value="$csvSuFileManagerFileIds">

END_HTML_CONTENT;

	return $htmlContent;
}
function buildCreateSuReDialog($database, $user_company_id, $project_id, $currently_active_contact_id, $dummyId=null, $submittalDraft=null)
{
	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}

	$session = Zend_Registry::get('session');
	$login_name=$session->getLoginName();
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
	// PERMISSION VARIABLES
	$permissions = Zend_Registry::get('permissions');

	//Check the permisson for view delay
	$userRole = $session->getUserRole();
	$userCanManageSubmtlsRT = true;
	if($userRole != 'global_admin'){
		$userCanManageSubmtlsRT = checkPermissionForAllModuleAndRole($database,'submittals_manage');
	}
	$toid = $bccid= $toemailist = $bccemailist = "";
	$ccid = $currentlyActiveContactId.",";
	$ccemailist =$login_name.",";
	// Update / Save case

		// Create case
		$submittal_draft_id = '';
		$submittal_type_id = '1';//Default to 'Product Information'
		$submittal_status_id = 5; // Default to "Open"
		$submittal_priority_id = '1';//Default to 'Normal'
		$su_file_manager_file_id = '';
		$su_cost_code_id = '0';
		$su_creator_contact_id = '';
		$su_title = '';
		$su_plan_page_reference = '';
		$su_statement = '';

        $additionalRecipients = array();
		// HTML Entity Escaped Data
		$escaped_su_plan_page_reference = '';
		$escaped_su_statement = '';
		$escaped_su_statement_nl2br = '';
		$escaped_su_title = '';

		$buttonDeleteSuDraft = '';
		$csvSuFileManagerFileIds = '';

		// Save Submittal As Draft Button
		$saveSubmittalAsDraftButton = <<<END_SAVE_SUBMITTAL_AS_DRAFT_BUTTON
<input type="button" value="Save Submittal As Draft" id="createSubmittaldraft" onclick="Submittals__createSuDraftViaPromiseChain('create-submittal-record', '$dummyId');" style="font-size: 10pt;">
END_SAVE_SUBMITTAL_AS_DRAFT_BUTTON;

	if($submittalDraft){
		$submittal_draft_id = $submittalDraft['id'];
		$escaped_su_title = $submittalDraft['su_title'];
		$su_plan_page_reference = '';
		$su_statement = $submittalDraft['su_statement'];
		$su_spec_no = $submittalDraft['su_spec_no'];
		$su_cost_code_id = $submittalDraft['su_cost_code_id'];
		$su_tag_name ='';
	}else{
		$su_spec_no='1-23-1';
	}
   

	// FileManagerFolder
	$virtual_file_path = '/Submittals/Submittal Draft Attachments/';
	$suFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $virtual_file_path);
	/* @var $suFileManagerFolder FileManagerFolder */

	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--submittal_attachments--create-submittal-record';
	$input->folder_id = $suFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Submittals/Submittal Draft Attachments/';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadSubmittalAttachment';
	$input->allowed_extensions = 'pdf';
	$input->post_upload_js_callback = "Submittals__suDraftAttachmentUploaded(arrFileManagerFiles, 'container--submittal_attachments--create-submittal-record')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

	$suCostCodesElementId = "ddl--create-submittal-record--submittals--su_cost_code_id--$dummyId";

	$costCodesInput = new Input();
	$prependedOption = '';
	$tabIndex = '';
	$js = 'style="width:95%"';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$costCodesInput->project_id = $project_id;
	$selectedOption = $su_cost_code_id;
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $suCostCodesElementId;
	$costCodesInput->firstOption = '<option value="0">Optionally Select A Cost Code Below For Reference</option>';
	$costCodesInput->selectCssStyle = 'style="font-size: 1.3em; width: 400px;"';
	$costCodesInput->selectedOption = $su_cost_code_id;
	$suDraftsHiddenCostCodeElementId = "create-submittal_draft-record--submittal_drafts--su_cost_code_id--$dummyId";
	$costCodesInput->additionalOnchange = "ddlOnChange_UpdateHiddenInputValue(this, '$suDraftsHiddenCostCodeElementId');updatecostcodeusers(this.value,&apos;$dummyId&apos;,&apos;$user_company_id&apos;,&apos;$project_id&apos;);";
	$ddlCostCodes = buildProjectCostCodeDropDownList($costCodesInput);

	$loadAllSubmittalPrioritiesOptions = new Input();
	$loadAllSubmittalPrioritiesOptions->forceLoadFlag = true;
	$arrSubmittalPriorities = SubmittalPriority::loadAllSubmittalPriorities($database, $loadAllSubmittalPrioritiesOptions);
	$ddlSuPrioritiesId = "ddl--create-submittal-record--submittals--submittal_priority_id--$dummyId";
	$suDraftsHiddenSuPrioritiesElementId = "create-submittal_draft-record--submittal_drafts--submittal_priority_id--$dummyId";
	$js = ' style="width: 70%;" class="moduleSUBMITTAL_dropdown required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$suDraftsHiddenSuPrioritiesElementId.'\');"';
	$selectedOption = $submittal_priority_id;
	$ddlSuPriorities = PageComponents::dropDownListFromObjects($ddlSuPrioritiesId, $arrSubmittalPriorities, 'submittal_priority_id', null, 'submittal_priority', null, $selectedOption, null, $js, $prependedOption);

	$loadAllSubmittalTypesOptions = new Input();
	$loadAllSubmittalTypesOptions->forceLoadFlag = true;
	$arrSubmittalTypes = SubmittalType::loadAllSubmittalTypes($database, $loadAllSubmittalTypesOptions);
	$ddlSuTypesId = "ddl--create-submittal-record--submittals--submittal_type_id--$dummyId";
	$suDraftsHiddenSuTypesElementId = "create-submittal_draft-record--submittal_drafts--submittal_type_id--$dummyId";
	$js = ' style="width: 70%;" class="moduleSUBMITTAL_dropdown3 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$suDraftsHiddenSuTypesElementId.'\');"';
	$selectedOption = $submittal_type_id;
	$ddlSuTypes = PageComponents::dropDownListFromObjects($ddlSuTypesId, $arrSubmittalTypes, 'submittal_type_id', null, 'submittal_type', null, $selectedOption, null, $js, $prependedOption);

	$loadAllSubmittalDistributionMethodsOptions = new Input();
	$loadAllSubmittalDistributionMethodsOptions->forceLoadFlag = true;
	$arrSubmittalDistributionMethods = SubmittalDistributionMethod::loadAllSubmittalDistributionMethods($database, $loadAllSubmittalDistributionMethodsOptions);
	$ddlSuDistributionMethodsId = "ddl--create-submittal-record--submittals--submittal_distribution_method_id--$dummyId";
	$suDraftsHiddenSuDistributionMethodsElementId = "create-submittal_draft-record--submittal_drafts--submittal_distribution_method_id--$dummyId";
	$js = ' style="width: 70%;" class="moduleSUBMITTAL_dropdown3 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$suDraftsHiddenSuDistributionMethodsElementId.'\');"';
	$selectedOption = $submittal_distribution_method_id;
	$ddlSuDistributionMethods = PageComponents::dropDownListFromObjects($ddlSuDistributionMethodsId, $arrSubmittalDistributionMethods, 'submittal_distribution_method_id', null, 'submittal_distribution_method', null, $selectedOption, null, $js, $prependedOption);

	$arrContactsByUserCompanyId = Contact::loadContactsByUserCompanyId($database, $user_company_id);

	// From: Subcontractor
	// su_initiator_contact_id
	$suDraftsHiddenContactsByUserCompanyIdToElementId = "create-submittal_draft-record--submittal_drafts--su_initiator_contact_id--$dummyId";
	
	// DDL of contacts
	$input = new Input();
	$input->database = $database;
	$input->user_company_id = $user_company_id;
	$input->costcode = $su_cost_code_id;
	$input->project_id = $project_id;
	$input->selected_contact_id = $su_initiator_contact_id;
	$input->htmlElementId = "ddl--create-submittal-record--submittals--su_initiator_contact_id--$dummyId";
	$input->js = ' class="moduleSUBMITTAL_dropdown4 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$suDraftsHiddenContactsByUserCompanyIdToElementId.'\');"';
	$input->firstOption = 'Select a contact';
	$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildSubmittalsContactsFullNameWithEmailByUserCompanyIdDropDownList($input);

	$htmlContent = <<<END_HTML_CONTENT
<form id="formCreateSu">
	<div id="record_creation_form_container--create-submittal-record--$dummyId">
		<div class="SUBMITTAL_table_create" style="width:100%!important;">
			<table width="100%" border="0" cellpadding="4" cellspacing="0">
			<tr><td>
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td class="SUBMITTAL_table_header2 border_right_none  ">Cost Code Reference:</td>
								<td class="SUBMITTAL_table_header2 border_right_none  ">Specification Number:</td>
								
							</tr>
							<tr>
						<td class="SUBMITTAL_table2_content" >
						<input id="create-submittal-record--submittals--su_cost_code_id--$dummyId" type="hidden" value="$su_cost_code_id">
						<input id="create-submittal_draft-record--submittal_drafts--su_cost_code_id--$dummyId" type="hidden" value="$su_cost_code_id">
						<span class="moduleSUBMITTAL">
						$ddlCostCodes
						</span>
					</td>
					<td class="SUBMITTAL_table2_content "><input id="create-submittal-record--submittals--su_spec_no--$dummyId" class="SUBMITTAL_table2" type="text" value="$su_spec_no"></td>
					</tr>
					</table>
				</td>
				</tr>				
				<tr style="display:none">
					<td class="SUBMITTAL_table_header2">From (Subcontractor):</td>
				</tr>
				<tr style="display:none">
					<td class="SUBMITTAL_table2_content Subsearch">
						<input id="create-submittal-record--submittals--su_initiator_contact_id1--$dummyId" type="hidden" value="$su_initiator_contact_id">
						<input id="create-submittal_draft-record--submittal_drafts--su_initiator_contact_id1--$dummyId" type="hidden" value="$su_initiator_contact_id">
						<span class="" id="emailarea">
						$contactsFullNameWithEmailByUserCompanyIdDropDownList
						</span>
					</td>
				</tr>
				<tr>
					<td width="70%" class="SUBMITTAL_table_header2">Submittal Title:</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content">
						
						<input id="create-submittal-record--submittals--su_title--$dummyId" class="SUBMITTAL_table2 required" type="text" value="$escaped_su_title">
					</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table_header2">Submittal Notes</td>
				</tr>
				<tr>
					<td class="SUBMITTAL_table2_content">
						<p><textarea id="create-submittal-record--submittals--su_statement--$dummyId" class="SUBMITTAL_table2 required">$su_statement</textarea></p>
						<input id="create-submittal-record--submittals--submittal_priority_id--$dummyId" type="hidden" value="$submittal_priority_id">
						<input id="create-submittal_draft-record--submittal_drafts--submittal_priority_id--$dummyId" type="hidden" value="$submittal_priority_id">
						<input id="create-submittal-record--submittals--submittal_status_id--$dummyId" type="hidden" value="$submittal_status_id">
						<input id="create-submittal_draft-record--submittal_drafts--submittal_status_id--$dummyId" type="hidden" value="$submittal_status_id">
						<input id="create-submittal-record--submittals--submittal_type_id--$dummyId" type="hidden" value="$submittal_type_id">
						<input id="create-submittal_draft-record--submittal_drafts--submittal_type_id--$dummyId" type="hidden" value="$submittal_type_id">
						<input id="create-submittal-record--submittals--submittal_distribution_method_id--$dummyId" type="hidden" value="$submittal_distribution_method_id">
						<input id="create-submittal_draft-record--submittal_drafts--submittal_distribution_method_id--$dummyId" type="hidden" value="$submittal_distribution_method_id">
						</td></tr>
			</table>
		</div>
	</div>

		<input type="button" id="SuResponseViaPromiseChain" value="Save As A Submittal Registry" onclick="Submittals__createSuReViaPromiseChain('create-submittal-record', '$dummyId');" style="font-size: 10pt;float:right">

		<input id="create-submittal-record--submittals--submittal_draft_id--$dummyId" type="hidden" value="$submittal_draft_id">
<input id="create-submittal-record--submittals--submittal_id--$dummyId" type="hidden" value="$submittal_draft_id">
<input id="create-submittal-record--submittals--su_initiator_contact_id--$dummyId" type="hidden" value="0">
<input id="submittalToId" type="hidden" value="0"><input id="search_data" type="hidden" value="0">
<input id="create-submittal-record--submittals--project_id--$dummyId" type="hidden" value="$project_id">
<input id="create-submittal-record--submittals--dummy_id" type="hidden" value="$dummyId">

</form>


END_HTML_CONTENT;

	return $htmlContent;
}

function buildSuAsHtmlForPdfConversion($database, $user_company_id, $submittal_id,$currentlyActiveContactId,$updatedsubmittal,$update_company_id)
{
	$submittal = Submittal::findSubmittalByIdExtended($database, $submittal_id);
	/* @var $submittal Submittal */

	$su_sequence_number = $submittal->su_sequence_number;
	$submittal_type_id = $submittal->submittal_type_id;
	$submittal_status_id = $submittal->submittal_status_id;
	$submittal_priority_id = $submittal->submittal_priority_id;
	$submittal_distribution_method_id = $submittal->submittal_distribution_method_id;
	$su_file_manager_file_id = $submittal->su_file_manager_file_id;
	$su_cost_code_id = $submittal->su_cost_code_id;
	$su_creator_contact_id = $submittal->su_creator_contact_id;
	$su_creator_contact_company_office_id = $submittal->su_creator_contact_company_office_id;
	$su_creator_phone_contact_company_office_phone_number_id = $submittal->su_creator_phone_contact_company_office_phone_number_id;
	$su_creator_fax_contact_company_office_phone_number_id = $submittal->su_creator_fax_contact_company_office_phone_number_id;
	$su_creator_contact_mobile_phone_number_id = $submittal->su_creator_contact_mobile_phone_number_id;
	$su_recipient_contact_id = $submittal->su_recipient_contact_id;
	$su_recipient_contact_company_office_id = $submittal->su_recipient_contact_company_office_id;
	$su_recipient_phone_contact_company_office_phone_number_id = $submittal->su_recipient_phone_contact_company_office_phone_number_id;
	$su_recipient_fax_contact_company_office_phone_number_id = $submittal->su_recipient_fax_contact_company_office_phone_number_id;
	$su_recipient_contact_mobile_phone_number_id = $submittal->su_recipient_contact_mobile_phone_number_id;
	$su_initiator_contact_id = $submittal->su_initiator_contact_id;
	$su_initiator_contact_company_office_id = $submittal->su_initiator_contact_company_office_id;
	$su_initiator_phone_contact_company_office_phone_number_id = $submittal->su_initiator_phone_contact_company_office_phone_number_id;
	$su_initiator_fax_contact_company_office_phone_number_id = $submittal->su_initiator_fax_contact_company_office_phone_number_id;
	$su_initiator_contact_mobile_phone_number_id = $submittal->su_initiator_contact_mobile_phone_number_id;
	$su_title = $submittal->su_title;
	$su_plan_page_reference = $submittal->su_plan_page_reference;
	$su_statement = $submittal->su_statement;
	$su_created = $submittal->created;
	$su_due_date = Date::convertDateTimeFormat($submittal->su_due_date, 'html_form');
	$su_closed_date = Date::convertDateTimeFormat($submittal->su_closed_date, 'html_form');
	// To Get the Contracting entity id
	$su_contracting_entity_id = $submittal->contracting_entity_id;
	$entityName = ContractingEntities::getcontractEntityNameforProject($database,$su_contracting_entity_id);


	// HTML Entity Escaped Data
	$submittal->htmlEntityEscapeProperties();
	$escaped_su_plan_page_reference = $submittal->escaped_su_plan_page_reference;
	$escaped_su_statement = $submittal->escaped_su_statement;
	$escaped_su_statement_nl2br = $submittal->escaped_su_statement_nl2br;
	$escaped_su_title = $submittal->escaped_su_title;

	if (empty($su_closed_date)) {
		$su_closed_date = '&nbsp;';
	}
	if(empty($su_created)){
		$su_created_on = '&nbsp;';
	}else{
		$su_created_date = new DateTime($su_created);
		$su_created_on = $su_created_date->format('m/d/Y');
	}
	$project = $submittal->getProject();
	/* @var $project Project */
	$project->htmlEntityEscapeProperties();
	$escaped_project_name = $project->escaped_project_name;

	$submittalType = $submittal->getSubmittalType();
	/* @var $submittalType SubmittalType */

	$submittalStatus = $submittal->getSubmittalStatus();
	/* @var $submittalStatus SubmittalStatus */
	$submittal_status = $submittalStatus->submittal_status;

	$submittalPriority = $submittal->getSubmittalPriority();
	/* @var $submittalPriority SubmittalPriority */
	$submittal_priority = $submittalPriority->submittal_priority;

	$suFileManagerFile = $submittal->getSuFileManagerFile();
	/* @var $suFileManagerFile FileManagerFile */

	$suCostCode = $submittal->getSuCostCode();
	/* @var $suCostCode CostCode */

	$suCreatorContact = $submittal->getSuCreatorContact();
	

	$sucreatorCompanyName=ContactCompany::contactCompanyName($database,$suCreatorContact->user_company_id,'company');
	/* @var $suCreatorContact Contact */
	$suCreatorContact->htmlEntityEscapeProperties();
	$suCreatorContactFullNameHtmlEscaped = $suCreatorContact->getContactFullNameHtmlEscaped();

	// Created By address
	$suCreatorcontactCompanyid=Contact::getcontactcompanyAddreess($database,$su_creator_contact_id);
	
	$suCreatorContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $suCreatorcontactCompanyid);
	$suCreatorContactCompanyOfficeAddressHtmlEscaped = $entityName."<br>";
	if ($suCreatorContactCompanyOffice) {
		$twoLines = true;
		$suCreatorContactCompanyOfficeAddressHtmlEscaped .= $suCreatorContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} 

	$suRecipientContact = $submittal->getSuRecipientContact();
	/* @var $suRecipientContact Contact */
	$suRecipientContact->htmlEntityEscapeProperties();
	$suRecipientContactFullNameHtmlEscaped = $suRecipientContact->getContactFullNameHtmlEscaped();

	//To adress
	$suRecipientcontactCompanyid=Contact::getcontactcompanyAddreess($database,$su_recipient_contact_id);
	
	$suRecipientContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $suRecipientcontactCompanyid);
	
	if ($suRecipientContactCompanyOffice) {
		$twoLines = true;
		$suRecipientContactCompanyOfficeAddressHtmlEscaped = $suRecipientContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$suRecipientContactCompanyOfficeAddressHtmlEscaped = '';
	}
	

	$recipient_arr = SubmittalRecipient::getAdditionalRecipient($database, $submittal_id);
	$recipient_name_arr = array();
	$additional_to_name = '';
	foreach($recipient_arr as $eachrecipient){
		$temp_additionalName = '';
		if(!empty($eachrecipient['su_additional_recipient_contact_id']) ){
			$temp_additionalName = Contact::ContactNameById($database,$eachrecipient['su_additional_recipient_contact_id']);
		}
		if(!empty($temp_additionalName) && $eachrecipient['smtp_recipient_header_type'] != 'To'){
			$recipient_name_arr[] = $temp_additionalName;
		}else{
			$additional_to_name .= $temp_additionalName.", ";
		}
		

	}
	$additional_to_name =rtrim($additional_to_name,', ');

	if(!empty($additional_to_name)){
		$suRecipientContactFullNameHtmlEscaped =  $additional_to_name;
	}


	//To get the initiator  id 

	$suInitiatorContact = $submittal->getSuInitiatorContact();
	//to get the initaiator details only it has initiator id
	if(!empty($suInitiatorContact))
	{
	$sucreatorCompanyName=ContactCompany::contactCompanyName($database,$suInitiatorContact->user_company_id,'company');
	/* @var $suCreatorContact Contact */
	$suInitiatorContact->htmlEntityEscapeProperties();
	$suInitiatorContactFullNameHtmlEscaped = $suInitiatorContact->getContactFullNameHtmlEscaped();

	$suInitiatorcontactCompanyid=Contact::getcontactcompanyAddreess($database,$su_initiator_contact_id);
	
	$suInitiatorContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $suInitiatorcontactCompanyid);	
	
	if ($suInitiatorContactCompanyOffice) {
		$twoLines = true;
		$suInitiatorContactCompanyOfficeAddressHtmlEscaped = $suInitiatorContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$suInitiatorContactCompanyOfficeAddressHtmlEscaped = '';
	}
	$suInitiatorContactCompanyOfficeAddressHtmlEscaped;
	//End of initiator
	}

	//To fetch the updated id NAme
	$suUpdatedContactName = Contact::ContactNameById($database, $currentlyActiveContactId);
	// Updated by address

	$suUpdatedcontactCompanyid=Contact::getcontactcompanyAddreess($database,$currentlyActiveContactId);
	
	$suUpdatedContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $suUpdatedcontactCompanyid);

	if ($suUpdatedContactCompanyOffice) {
		$twoLines = true;
		$suUpdatedContactCompanyOfficeAddressHtmlEscaped = $suUpdatedContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$suUpdatedContactCompanyOfficeAddressHtmlEscaped = '';
	}


	$loadSubmittalResponsesBySubmittalIdOptions = new Input();
	$loadSubmittalResponsesBySubmittalIdOptions->forceLoadFlag = true;
	$arrSubmittalResponsesBySubmittalId = SubmittalResponse::loadSubmittalResponsesBySubmittalId($database, $submittal_id, $loadSubmittalResponsesBySubmittalIdOptions);
	$tableSuResponses = '';
	foreach ($arrSubmittalResponsesBySubmittalId as $submittal_response_id => $submittalResponse ) {
		/* @var $submittalResponse SubmittalResponse */

		$submittalResponse->htmlEntityEscapeProperties();

		$submittal_response_sequence_number = $submittalResponse->submittal_response_sequence_number;
		$submittal_response_type_id = $submittalResponse->submittal_response_type_id;
		$su_responder_contact_id = $submittalResponse->su_responder_contact_id;
		$su_responder_contact_company_office_id = $submittalResponse->su_responder_contact_company_office_id;
		$su_responder_phone_contact_company_office_phone_number_id = $submittalResponse->su_responder_phone_contact_company_office_phone_number_id;
		$su_responder_fax_contact_company_office_phone_number_id = $submittalResponse->su_responder_fax_contact_company_office_phone_number_id;
		$su_responder_contact_mobile_phone_number_id = $submittalResponse->su_responder_contact_mobile_phone_number_id;
		$submittal_response_title = $submittalResponse->submittal_response_title;
		$submittal_response = $submittalResponse->submittal_response;
		$submittal_response_modified_timestamp = $submittalResponse->modified;
		$submittal_response_created_timestamp = $submittalResponse->created;

		$escaped_submittal_response_title = $submittalResponse->escaped_submittal_response_title;
		$escaped_submittal_response_nl2br = $submittalResponse->escaped_submittal_response_nl2br;

		$suResponseCreatedTimestampInt = strtotime($submittal_response_created_timestamp);
		$suResponseCreatedTimestampDisplayString = date('M j,Y g:i a', $suResponseCreatedTimestampInt);

		$suResponderContact = $submittalResponse->getSuResponderContact();
		/* @var $suResponderContact Contact */

		$suResponderContact->htmlEntityEscapeProperties();

		$suResponderContactFullNameHtmlEscaped = $suResponderContact->getContactFullNameHtmlEscaped();
		$su_responder_contact_escaped_title =($suResponderContact->escaped_title !='')?'('.$suResponderContact->escaped_title.')':'';

		$responseHeaderInfo = "<div style='font-size: 12px;padding-top:5px;'>Answered $suResponseCreatedTimestampDisplayString by $suResponderContactFullNameHtmlEscaped $su_responder_contact_escaped_title</div>";

		// #d1d1d1
		// #bbb
		$tableSuResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="SUBMITTAL_table2_content">
				$responseHeaderInfo
				<div style="padding-top:2px;border-bottom: 1px solid #d1d1d1; font-size: 12px;">$escaped_submittal_response_nl2br</div>
				<br>
			</td>
		</tr>
END_HTML_CONTENT;

	}
	if ($tableSuResponses == '') {

		$tableSuResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="SUBMITTAL_table2_content">No notes.</td>
		</tr>
END_HTML_CONTENT;

	}

	$uri = Zend_Registry::get('uri');
	/*GC logo*/
	require_once('lib/common/Logo.php');
	// $gcLogo = Logo::logoByUserCompanyIDUsingSoftlinkWidthCustome($database,$user_company_id, true);
	$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$user_company_id, true);
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

	$submittal_template_path =UserCompanyFileTemplate::getUserTemplatePath($database,$user_company_id,'Submittal');

	ob_start();
	require_once($submittal_template_path);
	$htmlContent = ob_get_clean();
	return $htmlContent;
}
function CheckcontactRolemanager($database,$contact_id,$project_id)
{
		$db = DBI::getInstance($database);
		//role_id 4 and 5 for project manager and project executive
		$query = "SELECT *  FROM `projects_to_contacts_to_roles` WHERE `contact_id` = $contact_id and project_id=$project_id and role_id IN ('4','5')";
		$db->execute($query);
		$row = $db->fetch();
		if($row)
			return true;
		else
			return false;
}
function submittalDraftDropDown($database, $project_id){

	$ddlSubmittalDraftsId = 'ddl--manage-submittal_draft-record--submittal_drafts--submittal_draft_id--dummy';
	$js = ' onchange="Submittals__loadCreateSuDialog(this);"';
	$prependedOption = '<option value="-1">Select a Submittal Draft<options>';
	$loadSubmittalDraftsByProjectIdOptions = new Input();
	$loadSubmittalDraftsByProjectIdOptions->forceLoadFlag = true;
	$arrSubmittalDrafts = SubmittalDraft::loadSubmittalDraftsByProjectId($database, $project_id, $loadSubmittalDraftsByProjectIdOptions);
	$ddlSubmittalDrafts = PageComponents::dropDownListFromObjects($ddlSubmittalDraftsId, $arrSubmittalDrafts, 'submittal_draft_id', null, 'su_title', null, null, null, $js, $prependedOption);

	return $ddlSubmittalDrafts;
}
