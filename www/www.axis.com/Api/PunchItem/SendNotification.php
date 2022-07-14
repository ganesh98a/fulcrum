<?php
$RN_jsonEC['status'] = 200;
try{
	
	// Get primary key / unique key via get input
	if(isset($RN_params['punch_item_id']) && $RN_params['punch_item_id']!=null){
		$RN_punch_item_id = intVal($RN_params['punch_item_id']);
	}

	// Use the active contact_id from the session as the current Submittal "Sendor" or SMTP "From"
	$RN_sendor_contact_id = $RN_currentlyActiveContactId;

	$RN_db = DBI::getInstance($database);
	/* @var $RN_db DBI_mysqli */

	$RN_punchItem = PunchItem::findPunchItemByIdExtended($database, $RN_punch_item_id);
	/* @var $RN_punchItem PunchItem */
	$RN_punchItem->htmlEntityEscapeProperties();
	$RN_main_project_id=$RN_punchItem->project_id;
	$RN_project = $RN_punchItem->getProject();
	/* @var $RN_project Project */
	$RN_project->htmlEntityEscapeProperties();
	$RN_formattedProjectName = $RN_project->project_name . ' (' . $RN_project->user_custom_project_id . ')';
	$RN_formattedProjectNameHtmlEscaped = $RN_project->escaped_project_name . ' (' . $RN_project->escaped_user_custom_project_id . ')';

	$RN_punchItemStatus = $RN_punchItem->getPunchItemStatus();
	/* @var $RN_PunchItemStatus PunchItemStatus */

	// Cloud Filesystem File
	$RN_piFileManagerFile = $RN_punchItem->getPiFileManagerFile();
	/* @var $RN_suFileManagerFile FileManagerFile */
	$RN_piFileManagerFile->htmlEntityEscapeProperties();

	$RN_piCostCode = $RN_punchItem->getPiCostCode();
	/* @var $RN_suCostCode CostCode */

	// Cost Code
	if ($RN_piCostCode) {
		$RN_formattedPiCostCode = $RN_piCostCode->getFormattedCostCodeApi($database, true, $RN_user_company_id);
	} else {
		$RN_formattedPiCostCode = '';
	}

	// Toggles back and forth
	// From:
	// To:
	$RN_piCreatorContact = $RN_punchItem->getPiCreatorContact();
	/* @var $RN_suCreatorContact Contact */

	// Toggles back and forth
	// From:
	// To:
	$RN_piRecipientContact = $RN_punchItem->getPiRecipientContact();
	/* @var $RN_piRecipientContact Contact */

	$RN_piInitiatorContact = $RN_punchItem->getPiInitiatorContact();
	/* @var $RN_piInitiatorContact Contact */

	// PunchItem Attachments
	$RN_loadPunchItemAttachmentsByPunchItemIdOptions = new Input();
	$RN_loadPunchItemAttachmentsByPunchItemIdOptions->forceLoadFlag = true;
	$RN_arrPunchItemAttachmentsByPunchItemId = PunchItemAttachment::loadPunchItemAttachmentsByPunchItemId($database, $RN_punch_item_id, $RN_loadPunchItemAttachmentsByPunchItemIdOptions);

	// Timestamp
	$RN_timestamp = date("D, M j g:i A", time());

	$RN_uri = Zend_Registry::get('uri');
	//$RN_url = $RN_uri->https.'account-registration-form-step1.php?guid='.$RN_guid;
	//$RN_smsUrl = $RN_uri->https.'r.php?guid='.$RN_guid;

	// Cloud Filesystem URL & Filename
	$RN_virtual_file_name = $RN_piFileManagerFile->virtual_file_name;
	$RN_escaped_virtual_file_name = $RN_piFileManagerFile->escaped_virtual_file_name;
			//$RN_virtual_file_name_url = $RN_uri->cdn . '_' . $RN_suFileManagerFile->file_manager_file_id;
	$RN_virtual_file_name_url = $RN_piFileManagerFile->generateUrl(true);
	if (strpos($RN_virtual_file_name_url,"?"))
	{
		$RN_virtual_file_name_url = $RN_virtual_file_name_url."&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
	}else
	{
		$RN_virtual_file_name_url = $RN_virtual_file_name_url."?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
	}

	$RN_piUrl = $RN_uri->http . 'modules-punch-list-form.php' .
	'?punch_item_id='.$RN_punch_item_id;

	// Send out a SMS or Email
	// Determine if SMS, Email, or Both
	$RN_emailFlag = true;
	$RN_smsFlag = false;

	// Invitation Initiator/Sender/Inviter's Information
	$RN_inviteFromName = '';

	// @todo Refactor this to inlcude the below HTML template section and SMS
	// Derived above - first in Project Executive list
	// Toggles back and forth
	// From:
	// To:
	if ($RN_sendor_contact_id == $RN_piCreatorContact->contact_id) {
		$RN_toContact = $RN_piRecipientContact;
		$RN_fromContact = $RN_piCreatorContact;
	} else {
		$RN_toContact = $RN_piRecipientContact;
		$RN_fromContact = $RN_piCreatorContact ;
	}
	// $RN_toContact->htmlEntityEscapeProperties();
	// $RN_fromContact->htmlEntityEscapeProperties();

	$RN_senderName = Contact::ContactNameById($database, $RN_sendor_contact_id);

	// From:
	$RN_fromName = $RN_fromContact->getContactFullName();
	$RN_fromEmail = $RN_fromContact->email;
	$RN_fromNameHtmlEscaped = $RN_fromContact->getContactFullNameHtmlEscaped();
	$RN_fromEmailHtmlEscaped = $RN_fromContact->escaped_email;

	$RN_smsFromName = $RN_fromContact->getContactFullName();
	$RN_smsFromEmail = $RN_fromContact->email;
	$RN_fromContactTitle = $RN_fromContact->title;
	$RN_fromContactTitleHtmlEscaped = $RN_fromContact->escaped_title;

			// To:
	$RN_toName = $RN_toContact->getContactFullName();
	$RN_toEmail = $RN_toContact->email;
	$RN_toNameHtmlEscaped = $RN_toContact->getContactFullNameHtmlEscaped();
	$RN_toEmailHtmlEscaped = $RN_toContact->escaped_email;

	$RN_smsToName = $RN_toContact->getContactFullName();
	$RN_smsToEmail = $RN_toContact->email;
	$RN_toContactTitle = $RN_toContact->title;
	$RN_toContactTitleHtmlEscaped = $RN_toContact->escaped_title;

			// Return-To
	$RN_returnName = $RN_fromName;
	$RN_returnEmail = $RN_fromEmail;
	$RN_smsReturnName = $RN_fromName;
	$RN_smsReturnEmail = $RN_fromEmail;
	$RN_returnContactTitle = $RN_fromContactTitle;

	$RN_alertMessageSubject =$RN_project->project_name." Punch List #$RN_punchItem->sequence_number";
	$RN_smsAlertMessageSubject = "Punch List #$RN_punchItem->sequence_number";

	$RN_systemMessage = '';
	$RN_systemMessage2 = '';
	$RN_alertHeadline = '';
	$RN_alertBody = '';

			//$RN_smsAlertMessageBody = "Register: $RN_smsUrl";
	$RN_alertHeadline = $RN_project->project_name.' Punch List #' . $RN_punchItem->sequence_number . '.';
	$RN_systemMessage = $RN_project->project_name.' Punch List #' . $RN_punchItem->sequence_number . '.';
	$RN_bodyHtml = 'Punch List #' . $RN_punchItem->sequence_number ;

			// Subject line has the project name in it
			//$RN_smsAlertMessageBody = "Submittal #$RN_submittal->su_sequence_number: $RN_smsUrl";
			//$RN_alertHeadline = 'Please <a href="'.$RN_url.'">Register or Sign In</a> to Bid on '.$RN_inviterUserCompany->company.'&#39;s '.$RN_project->project_name.' project.';
	$RN_systemMessage =
	'Please review this Punch List: <br>';
				//'Project Name: ' . $RN_project->project_name . '<br>' .$RN_costCode
				//' <a href="'.$RN_virtual_file_name_url.'">' . $RN_virtual_file_name . '</a><br>' .
				//'PDF: (<a href="'.$RN_virtual_file_name_url.'">' . $RN_virtual_file_name . '</a>)<br><br>';


	$RN_systemMessage2 = '';

			// Invitation Initiator/Sender/Inviter's Information
	$RN_submitFromSignature = '<div style="font-weight:bold; text-decoration: underline;">Punch List Created  By</div>';
			// Full Name
	if (isset($RN_fromName) && !empty($RN_fromName)) {
		$RN_submitFromSignature .= $RN_fromNameHtmlEscaped . '<br>';
	}
			// Title
	if (isset($RN_fromContactTitle)) {
		$RN_submitFromSignature .= $RN_fromContactTitleHtmlEscaped . '<br>';
	}
			// Company
	if ($RN_fromContact->contact_company_id) {
		$RN_fromContactCompany = ContactCompany::findById($database, $RN_fromContact->contact_company_id);
		/* @var $RN_fromContactCompany ContactCompany */
		if ($RN_fromContactCompany) {
			$RN_fromContactCompany->htmlEntityEscapeProperties();
			$RN_submitFromSignature .= $RN_fromContactCompany->escaped_contact_company_name . '<br>';
		}
	}

			// Email
	$RN_submitFromSignature .= $RN_fromContact->escaped_email . '<br>';
	$RN_submitFromSignature .='<br><div style="font-weight:bold; text-decoration: underline;">Punch List Message Updated By<br></div>'.$RN_senderName.'<br><br>';
	$RN_submitFromSignature .= "Punch List Message Sent: $RN_timestamp" . '<br>';

	$RN_includeAttachment = true;

	$RN_customEmailMessageFromSubmitter = '';
	$RN_htmlAlertHeadline = '';

			// Send email to primary To:
	$RN_toName = trim($RN_toName);
	$RN_greetingLine = '';
	if (isset($RN_toName) && !empty($RN_toName)) {
		$RN_greetingLine = $RN_toNameHtmlEscaped.',<br>';
	}

			// Optional Email Body
	if (!isset($RN_emailBody) || empty($RN_emailBody)) {
		$RN_emailBody = '';
	} else {
		$RN_emailBody = Data::entity_encode($RN_emailBody);
		$RN_emailBody = nl2br($RN_emailBody);
		$RN_emailBody .= '<br><br>';
	}

	$RN_piPageLinkText = "Punch List #$RN_punchItem->sequence_number";
	$RN_headline = 'Punch List ';
				//To get the project Company Id
	$RN_main_company = Project::ProjectsMainCompanyApi($database,$RN_main_project_id);
	require_once('lib/common/Logo.php');
	$RN_mail_image = Logo::logoByUserCompanyIDforemail($database,$RN_main_company);

	$RN_pifilelocationId=$RN_piFileManagerFile->file_location_id;
	$RN_filemaxSize = Module::getfilemanagerfilesize($RN_pifilelocationId, $database);
	if($RN_filemaxSize)
	{
		$RN_subPDF="<tr>
		<td style='padding:7px;border: 1px solid #333333;'>Punch List PDF File:</td>
		<td style='padding:7px;border: 1px solid #333333;'><a href='".$RN_virtual_file_name_url."'>$RN_escaped_virtual_file_name</a></td>
		</tr>";
	}else
	{
		$RN_subPDF="";
	}


// HTML Email output for Email clients that support HTML
	$htmlAlertMessageBody = <<<END_HTML_MESSAGE

	<table style="border-collapse: separate !important; border-spacing: 0;width:100%;padding-top: 15px;" align="left" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td style=""><h2 style="color: #3b90ce; font-size: 15px; margin: 5px 0 10px; padding: 0;">$RN_headline</h2>
	<div style="">
	<table style="width:100%;">
	<tbody>
	<td style="width:100%;">
	<h2 style="margin: 0 0 10px 0; padding: 0; white-space: nowrap;"></h2>
	<h4 style="text-transform:capitalize;">$RN_greetingLine$RN_emailBody
	</h4>
	$RN_systemMessage 
	</td>
	</tbody>
	</table>
	<table style="width:100%;">
	<thead>
	<tr>
	<th align="left" colspan="2" style="font-weight:bold; text-decoration: underline;padding: 15px 0;">PunchList Summary</th>
	</tr>
	</thead>

	<tbody>
	<tr>
	<td style="padding:7px;border: 1px solid #333333;">Project:</td>
	<td style="padding:7px;border: 1px solid #333333;">$RN_formattedProjectNameHtmlEscaped</td>
	</tr>
	<tr>
	<td style="padding:7px;border: 1px solid #333333;">Cost Code:</td>
	<td style="padding:7px;border: 1px solid #333333;">$RN_formattedPiCostCode</td>
	</tr>
	<tr>
	<td style="padding:7px;border: 1px solid #333333;">Punch List Web Page URL:</td>
	<td style="padding:7px;border: 1px solid #333333;"><a href="$RN_piUrl">$RN_piPageLinkText</a></td>
	</tr>
	$RN_subPDF

	</tbody>
	</table>
	<br>
	$RN_submitFromSignature
	<br>
	<br>
	</div>
	</td></tr></table>
END_HTML_MESSAGE;

	ob_start();
			//$RN_formattedType = ucfirst($RN_type);
	$RN_headline = 'Punch List ';
	$mail_image=$RN_mail_image;
			//include('templates/mail-template-bid-spread-approval-request.php');
	include('templates/mail-template.php');
	$bodyHtml = ob_get_clean();
	$RN_rlpEmail = Contact::ContactEmailById($database,$RN_currentlyActiveContactId,'email'); 
	$RN_rlpName = Contact::ContactEmailById($database,$RN_currentlyActiveContactId,'name');

	try {
				
			if ($RN_emailFlag) {
				//$RN_toEmail = $RN_email;
				$RN_sendEmail = 'Alert@MyFulcrum.com';
				$RN_sendName = ($RN_rlpName !=" ") ? $RN_rlpName : "Fulcrum Message";

				$RN_mail = new Mail();
				$RN_mail->setReturnPath($RN_returnEmail);
				//$RN_mail->setBodyText($RN_alertMessageBody);
				//$RN_mail->setBodyText($RN_bodyHtml);
				// $RN_mail->setBodyHtml($RN_htmlAlertMessageBody);
				$RN_mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED);
				$RN_mail->setFrom($RN_sendEmail, $RN_sendName);
				$RN_mail->addTo($RN_toEmail, $RN_toName);
				$RN_mail->addHeader('Reply-To',$RN_rlpEmail);

				$RN_mail->setSubject($RN_alertMessageSubject);
				if($RN_filemaxSize){
					if ($RN_includeAttachment && isset($RN_piFileManagerFile) && $RN_piFileManagerFile) {
					// Attach Submittal itself
						$RN_cdnFileUrl = $RN_piFileManagerFile->generateUrl();
						$RN_attachmentFileName = $RN_piFileManagerFile->virtual_file_name;

						$RN_cdnFileUrl = str_replace("http:", '', $RN_cdnFileUrl);
						if (strpos($RN_cdnFileUrl, '?')) {
							$RN_separator = '&';
						} else {
							$RN_separator = '?';
						}
						$RN_finalCdnFileUrl = 'http:' . $RN_cdnFileUrl . $RN_separator . 'id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
						$RN_fileContents = file_get_contents($RN_finalCdnFileUrl);
						$RN_mail->createAttachment($RN_attachmentFileName, $RN_fileContents);
					}
				}

				$RN_mail->send();
				//To delete the img
				$RN_config = Zend_Registry::get('config');
				$RN_file_manager_back = $RN_config->system->base_directory;
				$RN_file_manager_back =$RN_file_manager_back.'www/www.axis.com/';
				$RN_path=$RN_file_manager_back.$mail_image;
				unlink($RN_path);
			}

			if ($RN_smsFlag) {
				// MessageGateway_Sms
				MessageGateway_Sms::sendSmsMessage($RN_mobile_phone_number, $RN_mobile_network_carrier_id, $RN_smsToName, $RN_smsFromEmail, $RN_smsFromName, $RN_smsAlertMessageSubject, $RN_smsAlertMessageBody);
			}
		} catch(Exception $RN_e) {
			// Mail/SMS failed to send
			$RN_errorMessage = $RN_e->getMessage();
			throw new Exception($RN_errorMessage);
		}

		// Debug
		//exit;

		$RN_customEmailMessageFromSubmitter = '';

		$RN_emailSent = true;


	// Output standard formatted error or success message
	if ($RN_emailSent) {
		// Success
		$RN_errorNumber = 0;
		$RN_errorMessage = '';
	} else {
		// Error code here
		$RN_errorNumber = 1;
		$RN_errorMessage = 'Error sending email: Submittal.';
	}
}catch(Exception $RN_e) {

}
