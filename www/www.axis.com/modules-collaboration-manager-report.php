<?php
/**
 * Discussion manager.
 */
ini_set('max_execution_time', 300);
ini_set("memory_limit", "1000M");
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');
require_once('lib/common/FileManager.php');
/*RFI Functions*/
require_once('lib/common/RequestForInformationPriority.php');
require_once('lib/common/RequestForInformationRecipient.php');
require_once('lib/common/RequestForInformationResponse.php');
require_once('lib/common/RequestForInformationResponseType.php');
require_once('lib/common/RequestForInformationStatus.php');
require_once('lib/common/RequestForInformationType.php');
require_once('lib/common/RequestForInformation.php');
/*Submittal Functions*/
require_once('lib/common/Submittal.php');
require_once('lib/common/SubmittalDistributionMethod.php');
require_once('lib/common/SubmittalDraftAttachment.php');
require_once('lib/common/SubmittalPriority.php');
require_once('lib/common/SubmittalRecipient.php');
require_once('lib/common/SubmittalStatus.php');
require_once('lib/common/SubmittalType.php');
/*Open track function*/
require_once('module-report-meeting-functions.php');

require_once('transmittal-functions.php');

// date_default_timezone_set('Asian/kolkata');
$timezone = date_default_timezone_get();
$dates = date('d-m-Y h', time());
$i=date('i', time());
$s=date('s a', time());
$a=date('a', time());
$timedate=date('m/d/Y h:i a', time());

$message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;
$AXIS_TEMPLATE_PROJECT_ID = AXIS_TEMPLATE_PROJECT_ID;

require_once('./modules-collaboration-manager-functions.php');
require_once('dompdf/dompdf_config.inc.php');

// DATABASE VARIABLES
$db = DBI::getInstance($database);

// SESSSION VARIABLES
/* @var $session Session */
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$primary_contact_id = $session->getPrimaryContactId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$project_id = $session->getCurrentlySelectedProjectId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$project_name = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
$userRole = $session->getUserRole();
$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
$userCompany = UserCompany::findById($database, $currentlySelectedProjectUserCompanyId);
$user_company_name = $userCompany->user_company_name;

$arrContactOptions = array();

// Set permission variables
require_once('app/models/permission_mdl.php');

$userCanViewDiscussionItems = checkPermissionForAllModuleAndRole($database,'meetings_view');
$userCanCreateDiscussionItems = checkPermissionForAllModuleAndRole($database,'meetings_add_discussion_item');
$userCanCreateActionItems = checkPermissionForAllModuleAndRole($database,'meetings_add_action_item');
$userCanCreateDiscussionItemComments = checkPermissionForAllModuleAndRole($database,'meetings_add_comment');
$userCanManageMeetings = checkPermissionForAllModuleAndRole($database,'meetings_manage');

if (($currentlySelectedProjectUserCompanyId == $user_company_id) && ($userRole == 'admin')) {
	$projectOwnerAdmin = true;
} else {
	$projectOwnerAdmin = false;
}
$arrContactOptions = array ();
$meeting_id = $get->meeting_id;
$show_all_flag = $get->sAll;
$actionToPerform = $get->theAction;
$timedate = date("m/d/Y h:i A", time());

$meetingData = meetingDataPreview($database, $project_id, '', $meeting_id, $currentlySelectedProjectName, $show_all_flag);

$htmlContent = $meetingData;
$type_mention="";
/*html content with header*/
$htmlContentWHeader = meetingDataPreviewWithHeader($database, $user_company_id, $project_name, $type_mention, $htmlContent);

$htmlContent = $htmlContentWHeader;
if (!$htmlContent) {
	exit;
}
$htmlContent = html_entity_decode($htmlContent);
$htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");
//load the data into pdf
$dompdf = new DOMPDF();
$dompdf->load_html($htmlContent);
$dompdf->set_paper("letter","landscape");
// $dompdf->set_paper('ledger');

$dompdf->render();
$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font("helvetica", "6");
// $canvas->page_text(750, 560, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));                  
$canvas->page_text(1000, 805, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(.66,.66,.66));
// $canvas->page_text(270, 550, "33302 VALLE ROAD, SUITE 125 | SAN JUAN CAPISTRANO, CA 92675", $font, 8, array(0,0,0) );
// $canvas->page_text(250, 565, "949.582.2044 | (F)949.582.2041 | WWW.ADVENTCOMPANIES.COM | LIC# 922928", $font, 8, array(0,0,0) );
$canvas->page_text(35, 1190, "Printed : ".$timedate, $font, 8, array(.66,.66,.66));
// $canvas->page_text(35, 560, "Printed : ".$timedate, $font, 8, array(0,0,0));
// $dompdf->stream($type_mention."-".$dates.":".$i.":".$s.".pdf", array("Attachment" => false));


$meeting = Meeting::findMeetingByIdExtended($database, $meeting_id);
/* @var $meeting Meeting */
$project_id = $meeting->project_id;
$meeting_type_id = $meeting->meeting_type_id;
$previous_meeting_id = $meeting->previous_meeting_id;
$meeting_location_id = $meeting->meeting_location_id;
$meeting_chair_contact_id = $meeting->meeting_chair_contact_id;
$modified_by_contact_id = $meeting->modified_by_contact_id;
$meeting_sequence_number = $meeting->meeting_sequence_number;
$meeting_start_date = $meeting->meeting_start_date;
$meeting_start_time = $meeting->meeting_start_time;
$meeting_end_date = $meeting->meeting_end_date;
$meeting_end_time = $meeting->meeting_end_time;
$modified = $meeting->modified;
$created = $meeting->created;

$project = $meeting->getProject();
/* @var $project Project */

$meetingType = $meeting->getMeetingType();
/* @var $meetingType MeetingType */

$meetingLocation = $meeting->getMeetingLocation();
/* @var $meetingLocation MeetingLocation */

$meetingChairContact = $meeting->getMeetingChairContact();
/* @var $meetingChairContact Contact */

$modifiedByContact = $meeting->getModifiedByContact();
/* @var $modifiedByContact Contact */

$loadMeetingsByPreviousMeetingIdOptions = new Input();
$loadMeetingsByPreviousMeetingIdOptions->forceLoadFlag = true;
$arrMeetings = Meeting::loadMeetingsByPreviousMeetingId($database, $meeting_id, $loadMeetingsByPreviousMeetingIdOptions);
if (count($arrMeetings) == 0) {
	$nextMeeting = false;
} else {
	$nextMeeting = array_shift($arrMeetings);
}
/* @var $nextMeeting Meeting */

$all_day_event_flag = $meeting->all_day_event_flag;
$isAllDayEvent = 'No';
if ($all_day_event_flag == 'Y') {
	$isAllDayEvent = 'Yes';
}

$meeting_start_date = $meeting->meeting_start_date;
if (isset($meeting_start_date) && ($meeting_start_date != '0000-00-00')) {
	$meetingStartDateAsUnixTimestamp = strtotime($meeting_start_date);
	$meetingStartDateDisplay = date('m/d/Y', $meetingStartDateAsUnixTimestamp);
} else {
	$meetingStartDateDisplay = '';
	$meeting_start_date = '';
}

$meeting_start_time = $meeting->meeting_start_time;
if (isset($meeting_start_time) && ($meeting_start_time != '00:00:00')) {
	$meetingStartTimeDisplay = date('g:ia', strtotime($meeting_start_time));
} else {
	$meeting_start_time = '';
	$meetingStartTimeDisplay = '';
}

$meeting_end_date = $meeting->meeting_end_date;
if (isset($meeting_end_date) && ($meeting_end_date != '0000-00-00')) {
	$meetingEndDateAsUnixTimestamp = strtotime($meeting_end_date);
	$meetingEndDateDisplay = date('m/d/Y', $meetingEndDateAsUnixTimestamp);
} else {
	$meetingEndDateDisplay = '';
	$meeting_end_date = '';
}

$meeting_end_time = $meeting->meeting_end_time;
if (isset($meeting_end_time) && ($meeting_end_time != '00:00:00')) {
	$meetingEndTimeDisplay = date('g:ia', strtotime($meeting_end_time));
} else {
	$meeting_end_time = '';
	$meetingEndTimeDisplay = '';
}
$meeting_type = $meetingType->meeting_type;

$meeting_location = $meetingLocation->meeting_location;

$meetingHeaderText = $meeting_type . ' ' . $meeting_sequence_number;

if ($actionToPerform == 'print') {

	$domPdfFilename = $project_name . ' - ' . $meetingHeaderText . '.pdf';
	$arrDomPdfPrintOptions = array(
		'Attachment' => false
	);
	$dompdf->stream($domPdfFilename, $arrDomPdfPrintOptions);

} else if($actionToPerform == 'renderPDF'){
	$pdf_content = $dompdf->output();
}
elseif ($actionToPerform == 'email') {

	$adHocEmailMessageText = $mailText =$get->adHocEmailMessageText;
	if (strlen($adHocEmailMessageText) > 3) {
		$adHocEmailMessageText = $adHocEmailMessageText . '<br><br>';
	}

	$meetingMinutesSendorContactId = $session->getPrimaryContactId();

	$meetingMinutesSendorContact = Contact::findContactByIdExtended($database, $primary_contact_id);
	/* @var $meetingMinutesSendorContact Contact */

	$meetingMinutesSendorContactCompany = $meetingMinutesSendorContact->getContactCompany();
	/* @var $meetingMinutesSendorContactCompany ContactCompany */

	$meetingMinutesSendorContact->htmlEntityEscapeProperties();
	$meetingMinutesSendorContactCompany->htmlEntityEscapeProperties();

	// Invitation Initiator/Sender/Inviter's Information
	$meetingMinutesSendorContactFullNameHtmlEscaped = $meetingMinutesSendorContact->getContactFullNameHtmlEscaped();

	$fromSignature = $meetingMinutesSendorContactFullNameHtmlEscaped;

	// First Name
	if ($meetingMinutesSendorContact->first_name) {
		//$fromSignature .= $meetingMinutesSendorContact->first_name;
		$fromName = $meetingMinutesSendorContact->first_name;
		$smsFromName = $meetingMinutesSendorContact->first_name;
	}

	// Last Name
	if ($meetingMinutesSendorContact->last_name) {
		//$fromSignature .= ' '.$meetingMinutesSendorContact->last_name;
		if ($fromName != 'FULCRUM AutoMessage') {
			$fromName .= ' '.$meetingMinutesSendorContact->last_name;
		}
	}

	// Title
	if ($meetingMinutesSendorContact->title) {
		$fromSignature .= '<br>'.$meetingMinutesSendorContact->title;
	}

	// Company
	if ($meetingMinutesSendorContactCompany->company) {
		$fromSignature .= '<br>' .$meetingMinutesSendorContactCompany->company;
	}

	// Address
	/**
	 * @todo Load Address info into signature if they have a primary office set
	 */

	 // Phone Numbers
	 /**
	 * @todo Load Phone info into signature if they have any
	 */

	 // Email
	 $fromSignature .= '<br>' . $meetingMinutesSendorContact->email;

	$pdf_content = $dompdf->output();

	$alertMessageSubject = $project_name . ' - ' . $meetingHeaderText;
	$main_company = Project::ProjectsMainCompany($database,$project_id);
	require_once('lib/common/Logo.php');
	$mail_image = Logo::logoByUserCompanyIDforemail($database,$main_company);



// HTML Email output for Email clients that support HTML
$greetingLine = isset($greetingLine)?$greetingLine:"";
$emailBody = isset($emailBody)?$emailBody:"";
$headline = 'Meetings ';
$htmlAlertMessageBody = <<<END_HTML_MESSAGE

<table style="border-collapse: separate !important; border-spacing: 0;width:100%;padding-top: 15px;" align="left" border="0" cellpadding="0" cellspacing="0">
<tr>
<td style=""><h2 style="color: #3b90ce; font-size: 15px; margin: 5px 0 10px; padding: 0;">$headline</h2>
<div style="">
<table style="width:100%;">
<tbody>
 <td style="width:100%;">
	<h2 style="margin: 0 0 10px 0; padding: 0; white-space: nowrap;"></h2>
	<h4 style="text-transform:capitalize;">$greetingLine$emailBody
</h4>
	Please see attached meeting report for:
 </td>
</tbody>
</table>
<br>
<table style="width:100%;">
<tbody>
<tr>
<td style="padding:7px;border: 1px solid #333333;"><b>$project_name </b> </td>
<td style="padding:7px;border: 1px solid #333333;"><b>$meetingHeaderText</b></td>
</tr>
<tr>
<td style="padding:7px;border: 1px solid #333333;">Start:</td>
<td style="padding:7px;border: 1px solid #333333;">$meetingStartDateDisplay $meetingStartTimeDisplay</td>
</tr>
<tr>
<td style="padding:7px;border: 1px solid #333333;">End:</td>
<td style="padding:7px;border: 1px solid #333333;">$meetingEndDateDisplay $meetingEndTimeDisplay</td>
</tr>
<tr>
<td style="padding:7px;border: 1px solid #333333;">Location:</td>
<td style="padding:7px;border: 1px solid #333333;">$meeting_location</td>
</tr>
</tbody>
</table>
<br>
$adHocEmailMessageText
Thank you,
<br>
$fromSignature
<br><br>
</div>
</td></tr></table>
END_HTML_MESSAGE;

	//$htmlAlertMessageBody = nl2br($alertMessageBody);
	// $htmlAlertMessageBody = $htmlAlertMessageBody;
	ob_start();
			//$formattedType = ucfirst($type);
			
			$mail_image=$mail_image;
			//include('templates/mail-template-bid-spread-approval-request.php');
			include('templates/mail-template.php');
			$bodyHtml = ob_get_clean();

	// @todo Update this to use the new mail api

	require_once('lib/common/Mail.php');
	$sendEmail = 'Alert@MyFulcrum.com';
   	
	$mail = new Mail();
	$mail->setSubject($alertMessageSubject);
	$mail->setBodyText($htmlAlertMessageBody);
	$mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED);

	$fromEmail = $meetingMinutesSendorContact->email;
	$fromName = $meetingMinutesSendorContact->getContactFullName();
	$sendName = ($fromName !=" ") ? $fromName : "Fulcrum Message";
	$mail->setFrom($sendEmail, $sendName);
	$mail->addHeader('Reply-To',$fromEmail);


	$sendStatus = 'successMessage';
	$sendStatusMessage = 'Email Successfully Sent.';
	$senderIncluded = false;
	$csvRecipientContactIds = $get->recipients;
	$arrRecipientContactIds = explode(',', $csvRecipientContactIds);

	if (isset($arrRecipientContactIds) && !empty($arrRecipientContactIds)) {
		$arrRecipientContactsByArrContactIds = Contact::loadContactsByArrContactIds($database, $arrRecipientContactIds);
	} else {
		$arrRecipientContactsByArrContactIds = array();
	}
	
	foreach ($arrRecipientContactsByArrContactIds AS $contact_id => $recipientContact) {
		/* @var $recipientContact Contact */
		// $toEmail = $contact->email;
		// $toName = $contact->getContactFullName();
		$toEmail = $recipientContact->email;
		$toName = $recipientContact->getContactFullName();

		if (strlen($toEmail) > 2) {
			$mail->addTo($toEmail, $toName);
		} else {
			$sendStatus = 'warningMessage';
			if ($sendStatusMessage == 'Email Successfully Sent.') {
				$sendStatusMessage .= '  Except these individuals did not have email addresses: ' . $toName;
			} else {
				$sendStatusMessage .= ', ' . $toName;
			}
		}

		if ($contact_id == $meetingMinutesSendorContactId) {
			$senderIncluded = true;
		}
	}

	if ($senderIncluded == false) {
		$mail->addTo($fromEmail, $fromName);
	}

	$attachmentFileName = $project_name . ' - ' . $meetingHeaderText . '.pdf';
	$fileContents = $pdf_content;

	$mail->createAttachment($attachmentFileName, $fileContents);

	/*
	$at = $mail->createAttachment($pdf_content);
	$at->type        = 'application/pdf';
	$at->disposition = Zend_Mime::DISPOSITION_INLINE;
	$at->encoding    = Zend_Mime::ENCODING_BASE64;
	$at->filename    = $project_name . " - " . $meetingHeaderText . '.pdf';
	*/

	$mail->send();

	echo $sendStatus . "|" . $sendStatusMessage;
	//To delete the img
    $config = Zend_Registry::get('config');
    $file_manager_back = $config->system->base_directory;
    $file_manager_back =$file_manager_back.'www/www.axis.com/';
    $path=$file_manager_back.$mail_image;
    unlink($path);
	// To create a Transmittal Notice
	$query1 = "SELECT * FROM transmittal_types where transmittal_category='Meetings'";
	
        $db->execute($query1);
        while($row1 = $db->fetch())
        {
           
            $val = $row1['id'];
            $category = $row1['transmittal_category'];
           
        }
        $metting_notice=$val; // Refer to Transmittal_types table
        $category =str_replace(' ', '', $category);
        $sequence_no = getSequenceNumberForTransmittals($database, $project_id);       
        $query = "INSERT INTO transmittal_data(sequence_number,transmittal_type_id,project_id,comment,raised_by,mail_to,mail_content) VALUES($sequence_no,'$metting_notice','$project_id','$meetingHeaderText','$currentlyActiveContactId','','$mailText')";

        if($db->execute($query)){
            $TransmittalId = $db->insertId; 
            $status = '0';
        }
        // $db->free_result();
        //function For creating transmittal and sending email
        $pdf_content = $dompdf->output();
       $Tran_result= TransmittalMeetings($database, $user_company_id, $TransmittalId,$project_name,$project_id,$user_id,$currentlyActiveContactId,'Meetings',$category,$meetingData);
	//End to create transmittal Notice
}

ob_flush ();
exit();
