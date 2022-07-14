<?php

require_once('lib/common/Date.php');
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
		$su_created_on = $su_created_date->format('d/m/Y');
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

	$suCreatorContactCompanyOffice = false;
	if($suCreatorcontactCompanyid != null) {
		$suCreatorContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $suCreatorcontactCompanyid);
	}

	if ($suCreatorContactCompanyOffice) {
		$twoLines = true;
		$suCreatorContactCompanyOfficeAddressHtmlEscaped = $suCreatorContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$suCreatorContactCompanyOfficeAddressHtmlEscaped = '';
	}

	$suRecipientContact = $submittal->getSuRecipientContact();
	/* @var $suRecipientContact Contact */
	$suRecipientContact->htmlEntityEscapeProperties();
	$suRecipientContactFullNameHtmlEscaped = $suRecipientContact->getContactFullNameHtmlEscaped();

	//To adress
	$suRecipientcontactCompanyid=Contact::getcontactcompanyAddreess($database,$su_recipient_contact_id);
	
	$suRecipientContactCompanyOffice = false;
	if($suRecipientcontactCompanyid != null) {
		$suRecipientContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $suRecipientcontactCompanyid);
	}
	
	if ($suRecipientContactCompanyOffice) {
		$twoLines = true;
		$suRecipientContactCompanyOfficeAddressHtmlEscaped = $suRecipientContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$suRecipientContactCompanyOfficeAddressHtmlEscaped = '';
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

		$suInitiatorContactCompanyOffice = false;
		if($suInitiatorcontactCompanyid != null) {
			$suInitiatorContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $suInitiatorcontactCompanyid);
		}

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
	
	$suUpdatedContactCompanyOffice = false;
	if($suUpdatedcontactCompanyid != null) {
		$suUpdatedContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $suUpdatedcontactCompanyid);
	}	

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
	// $gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$user_company_id, true);
	// $fulcrum = Logo::logoByFulcrumByBasePath();
	$logo = new Logo($database);
	$gcLogo = $logo->logoByUserCompanyIDUsingBasePath($database,$user_company_id, true);
	$fulcrum = $logo->logoByFulcrumByBasePath(true);
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

	$htmlContent = <<<END_HTML_CONTENT
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Untitled Document</title>
	<link href="{$uri->http}css/styles.css" rel="stylesheet" type="text/css">
	<link href="{$uri->http}css/modules-submittals-pdf.css" rel="stylesheet" type="text/css">
</head>
<body>
$headerLogo
	<div id="" style="font-family: Helvetica,sans;">
	<span class="highlight"><b>$escaped_project_name - Submittal</b></span>
		<table border="0" class="submittalDesc" cellspacing="0" cellpadding="4" class="" width="100%">
			<tr>
				<td class="thhighlight textAlignLeft" width="10%">Description  </td>
				<td width="2%">:</td>
				<td class="textAlignLeft thhighlight" align="left">$escaped_su_title</td>
				<td class="thhighlight textAlignLeft" width="15%"  >Submittal Number </td>
				<td width="2%">:</td>
				<td width="20%" class="textAlignLeft thhighlight">$su_sequence_number</td>
			</tr>
			<tr>
				<td class="thhighlight textAlignLeft" >Priority </td>
				<td >:</td>
				<td class="textAlignLeft thhighlight">$submittal_priority</td>
				<td class="thhighlight textAlignLeft" >Due Date</td>
				<td >:</td>
				<td class="textAlignLeft thhighlight" align="left">$su_due_date</td>
			</tr>
			<tr>
				<td class="thhighlight textAlignLeft" >Plan Ref</td>
				<td>:</td>
				<td class="textAlignLeft thhighlight">$escaped_su_plan_page_reference</td>
				<td class="thhighlight textAlignLeft" >Opened Date</td>
				<td>:</td>
				<td class="textAlignLeft thhighlight">$su_created_on</td>
			</tr>
			<tr>
				<td class="thhighlight textAlignLeft">Status</td>
				<td>:</td>
				<td class="thhighlight">$submittal_status</td>
				<td class="thhighlight textAlignLeft" >Closed Date</td>
				<td>:</td>
				<td class="textAlignLeft thhighlight">$su_closed_date</td>
			</tr>
		</table><hr>
		<div style="margin: 15px 0;">
			<table border="0" cellpadding="2" cellspacing="0" width="100%">
				<tr>
					<td class="thhightlightColortd"><span class="thhightlightColor">Created By :</span></td>
END_HTML_CONTENT;
if($updatedsubmittal == "yes" && empty($suInitiatorContact)) {
$htmlContent .= <<<END_HTML_CONTENT
	<td class="thhightlightColortd"><span class="thhightlightColor">Updated By :</span></td>
END_HTML_CONTENT;
}
if($updatedsubmittal != "yes" && !empty($suInitiatorContact)){
$htmlContent .= <<<END_HTML_CONTENT
	<td class="thhightlightColortd"><span class="thhightlightColor">Received from :</span></td>
END_HTML_CONTENT;
}
$htmlContent .= <<<END_HTML_CONTENT
					<td class="thhightlightColortd"><span class="thhightlightColor">To :</span></td>
				</tr>
				<tr>
					<td style="font-size:12px;" nowrap>$suCreatorContactFullNameHtmlEscaped</td>
END_HTML_CONTENT;
if($updatedsubmittal == "yes" && empty($suInitiatorContact)) {
$htmlContent .= <<<END_HTML_CONTENT
	<td style="font-size:12px;" nowrap>$suUpdatedContactName</td>
END_HTML_CONTENT;
}
if($updatedsubmittal != "yes" && !empty($suInitiatorContact)){
$htmlContent .= <<<END_HTML_CONTENT
	<td style="font-size:12px;" nowrap>$suInitiatorContactFullNameHtmlEscaped</td>
END_HTML_CONTENT;
}
$htmlContent .= <<<END_HTML_CONTENT
					<td style="font-size:12px;" nowrap>$suRecipientContactFullNameHtmlEscaped</td>
				</tr>
				<tr>
					<td style="font-size:12px;" nowrap>$suCreatorContactCompanyOfficeAddressHtmlEscaped</td>
END_HTML_CONTENT;
if($updatedsubmittal == "yes" && empty($suInitiatorContact)) {
$htmlContent .= <<<END_HTML_CONTENT
	<td style="font-size:12px;" nowrap>$suUpdatedContactCompanyOfficeAddressHtmlEscaped</td>
END_HTML_CONTENT;
}
if($updatedsubmittal != "yes" && !empty($suInitiatorContact)){
$htmlContent .= <<<END_HTML_CONTENT
	<td style="font-size:12px;" nowrap>$suInitiatorContactCompanyOfficeAddressHtmlEscaped</td>
END_HTML_CONTENT;
}
$htmlContent .= <<<END_HTML_CONTENT
					<td style="font-size:12px;" nowrap>$suRecipientContactCompanyOfficeAddressHtmlEscaped</td>
				</tr>
END_HTML_CONTENT;
if($updatedsubmittal == "yes" && !empty($suInitiatorContact)) {
$htmlContent .= <<<END_HTML_CONTENT
	<tr>
		<td class="thhightlightColortd" style="padding-top:8px;"><span class="thhightlightColor">Received from :</span></td>
		<td class="thhightlightColortd" style="padding-top:8px;"><span class="thhightlightColor">Updated By :</span></td>
	</tr>
	<tr>
		<td style="font-size:12px;" nowrap>$suInitiatorContactFullNameHtmlEscaped</td>
		<td style="font-size:12px;" nowrap>$suUpdatedContactName</td>
	</tr>
	<tr>
		<td style="font-size:12px;" nowrap>$suInitiatorContactCompanyOfficeAddressHtmlEscaped</td>
		<td style="font-size:12px;" nowrap>$suUpdatedContactCompanyOfficeAddressHtmlEscaped</td>
	</tr>
END_HTML_CONTENT;
}
$htmlContent .= <<<END_HTML_CONTENT
			</table>
		</div>
		<div>
			<div class="topicHeader">Topic</div>
			<div class="topicHeaderIn"><p class="plinkTag">$escaped_su_statement_nl2br</p></div>

		</div>
		<div>
			<div class="topicHeadernotes">Note(s)</div>
			<div style="background: #f0f0f0; padding: 0 15px;">
				<table width="100%">
					$tableSuResponses
				</table>
			</div>
		</div>
	</div>
	<div class='stamp--footer' >
	<table id="stamp">
	<tbody>
	<tr>
	<td>
Corrections or comments made on the shop drawings during this review do not relieve subcontractor from compliance with requirements of the Contract Documents. This is only a review of the general conformance with the design concept of the project and general compliance with the information given in the Contract Documents. The subcontractor is responsible for: conforming and correlating all quantities and dimensions; compliance with all code, statutory and regulatory legal requirements; selecting fabrication processes and techniques of construction; and performing all work in a safe and satisfactory manner.<br><br>
</td>
</tr>
</tbody>
</table>
</div>
</body>
</html>

END_HTML_CONTENT;

	return $htmlContent;
}
// rfi content
function buildRfiAsHtmlForPdfConversion($database, $user_company_id, $request_for_information_id,$currentlyActiveContactId,$updatedRfi,$update_company_id, $photoContents)
{
	$requestForInformation = RequestForInformation::findRequestForInformationByIdExtended($database, $request_for_information_id);
	/* @var $requestForInformation RequestForInformation */

	$rfi_sequence_number = $requestForInformation->rfi_sequence_number;
	$request_for_information_type_id = $requestForInformation->request_for_information_type_id;
	$request_for_information_status_id = $requestForInformation->request_for_information_status_id;
	$request_for_information_priority_id = $requestForInformation->request_for_information_priority_id;
	$rfi_file_manager_file_id = $requestForInformation->rfi_file_manager_file_id;
	$rfi_cost_code_id = $requestForInformation->rfi_cost_code_id;
	$rfi_creator_contact_id = $requestForInformation->rfi_creator_contact_id;
	$rfi_creator_contact_company_office_id = $requestForInformation->rfi_creator_contact_company_office_id;
	$rfi_creator_phone_contact_company_office_phone_number_id = $requestForInformation->rfi_creator_phone_contact_company_office_phone_number_id;
	$rfi_creator_fax_contact_company_office_phone_number_id = $requestForInformation->rfi_creator_fax_contact_company_office_phone_number_id;
	$rfi_creator_contact_mobile_phone_number_id = $requestForInformation->rfi_creator_contact_mobile_phone_number_id;
	$rfi_recipient_contact_id = $requestForInformation->rfi_recipient_contact_id;
	$rfi_recipient_contact_company_office_id = $requestForInformation->rfi_recipient_contact_company_office_id;
	$rfi_recipient_phone_contact_company_office_phone_number_id = $requestForInformation->rfi_recipient_phone_contact_company_office_phone_number_id;
	$rfi_recipient_fax_contact_company_office_phone_number_id = $requestForInformation->rfi_recipient_fax_contact_company_office_phone_number_id;
	$rfi_recipient_contact_mobile_phone_number_id = $requestForInformation->rfi_recipient_contact_mobile_phone_number_id;
	$rfi_initiator_contact_id = $requestForInformation->rfi_initiator_contact_id;
	$rfi_initiator_contact_company_office_id = $requestForInformation->rfi_initiator_contact_company_office_id;
	$rfi_initiator_phone_contact_company_office_phone_number_id = $requestForInformation->rfi_initiator_phone_contact_company_office_phone_number_id;
	$rfi_initiator_fax_contact_company_office_phone_number_id = $requestForInformation->rfi_initiator_fax_contact_company_office_phone_number_id;
	$rfi_initiator_contact_mobile_phone_number_id = $requestForInformation->rfi_initiator_contact_mobile_phone_number_id;
	$rfi_title = $requestForInformation->rfi_title;
	$rfi_plan_page_reference = $requestForInformation->rfi_plan_page_reference;
	$rfi_statement = $requestForInformation->rfi_statement;
	$rfi_created = $requestForInformation->created;
	$rfi_due_date = Date::convertDateTimeFormat($requestForInformation->rfi_due_date, 'html_form');
	$rfi_closed_date = Date::convertDateTimeFormat($requestForInformation->rfi_closed_date, 'html_form');

	// HTML Entity Escaped Data
	$requestForInformation->htmlEntityEscapeProperties();
	$escaped_rfi_plan_page_reference = $requestForInformation->escaped_rfi_plan_page_reference;
	$escaped_rfi_statement = $requestForInformation->escaped_rfi_statement;
	$escaped_rfi_statement_nl2br = $requestForInformation->escaped_rfi_statement_nl2br;
	$escaped_rfi_title = $requestForInformation->escaped_rfi_title;

	if (empty($rfi_closed_date)) {
		$rfi_closed_date = '&nbsp;';
	}
	if(empty($rfi_created)){
		$rfi_created_on = '&nbsp;';
	}else{
		$rfi_created_date = new DateTime($rfi_created);
		$rfi_created_on = $rfi_created_date->format('m/d/Y');
	}
	$project = $requestForInformation->getProject();
	/* @var $project Project */
	$project->htmlEntityEscapeProperties();
	$escaped_project_name = $project->escaped_project_name;

	$requestForInformationType = $requestForInformation->getRequestForInformationType();
	/* @var $requestForInformationType RequestForInformationType */

	$requestForInformationStatus = $requestForInformation->getRequestForInformationStatus();
	/* @var $requestForInformationStatus RequestForInformationStatus */
	$request_for_information_status = $requestForInformationStatus->request_for_information_status;

	$requestForInformationPriority = $requestForInformation->getRequestForInformationPriority();
	/* @var $requestForInformationPriority RequestForInformationPriority */
	$request_for_information_priority = $requestForInformationPriority->request_for_information_priority;

	$rfiFileManagerFile = $requestForInformation->getRfiFileManagerFile();
	/* @var $rfiFileManagerFile FileManagerFile */

	$rfiCostCode = $requestForInformation->getRfiCostCode();
	/* @var $rfiCostCode CostCode */

	$rfiCreatorContact = $requestForInformation->getRfiCreatorContact();
	/* @var $rfiCreatorContact Contact */
	$rfiCreatorContact->htmlEntityEscapeProperties();
	$rfiCreatorContactFullNameHtmlEscaped = $rfiCreatorContact->getContactFullNameHtmlEscaped();

	// Created By address

	$rfiCreatorcontactCompanyid=Contact::getcontactcompanyAddreess($database,$rfi_creator_contact_id);
	
	$rfiCreatorContactCompanyOffice = false;
	if($rfiCreatorcontactCompanyid != null) {
		$rfiCreatorContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $rfiCreatorcontactCompanyid);
	}	

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
	
	$rfiRecipientContactCompanyOffice = false;
	if($rfiRecipientcontactCompanyid != null) {
		$rfiRecipientContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $rfiRecipientcontactCompanyid);
	}

	if ($rfiRecipientContactCompanyOffice) {
		$twoLines = true;
		$rfiRecipientContactCompanyOfficeAddressHtmlEscaped = $rfiRecipientContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$rfiRecipientContactCompanyOfficeAddressHtmlEscaped = '';
	}

	//To fetch the updated id NAme
	$RfiUpdatedContactName = Contact::ContactNameById($database, $currentlyActiveContactId);
	// Updated by address

	$rfiUpdatedcontactCompanyid=Contact::getcontactcompanyAddreess($database,$currentlyActiveContactId);
	
	$rfiupdateContactCompanyOffice = false;
	if($rfiUpdatedcontactCompanyid != null) {
		$rfiupdateContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $rfiUpdatedcontactCompanyid);
	}	 
	
	if ($rfiupdateContactCompanyOffice) {
		$twoLines = true;
		$RfiUpdatedContactCompanyOfficeAddressHtmlEscaped = $rfiupdateContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$RfiUpdatedContactCompanyOfficeAddressHtmlEscaped = '';
	}

	$loadRequestForInformationResponsesByRequestForInformationIdOptions = new Input();
	$loadRequestForInformationResponsesByRequestForInformationIdOptions->forceLoadFlag = true;
	$arrRequestForInformationResponsesByRequestForInformationId = RequestForInformationResponse::loadRequestForInformationResponsesByRequestForInformationId($database, $request_for_information_id, $loadRequestForInformationResponsesByRequestForInformationIdOptions);
	$tableRfiResponses = '';
	foreach ($arrRequestForInformationResponsesByRequestForInformationId as $request_for_information_response_id => $requestForInformationResponse ) {
		/* @var $requestForInformationResponse RequestForInformationResponse */

		$requestForInformationResponse->htmlEntityEscapeProperties();

		$request_for_information_response_sequence_number = $requestForInformationResponse->request_for_information_response_sequence_number;
		$request_for_information_response_type_id = $requestForInformationResponse->request_for_information_response_type_id;
		$rfi_responder_contact_id = $requestForInformationResponse->rfi_responder_contact_id;
		$rfi_responder_contact_company_office_id = $requestForInformationResponse->rfi_responder_contact_company_office_id;
		$rfi_responder_phone_contact_company_office_phone_number_id = $requestForInformationResponse->rfi_responder_phone_contact_company_office_phone_number_id;
		$rfi_responder_fax_contact_company_office_phone_number_id = $requestForInformationResponse->rfi_responder_fax_contact_company_office_phone_number_id;
		$rfi_responder_contact_mobile_phone_number_id = $requestForInformationResponse->rfi_responder_contact_mobile_phone_number_id;
		$request_for_information_response_title = $requestForInformationResponse->request_for_information_response_title;
		$request_for_information_response = $requestForInformationResponse->request_for_information_response;
		$request_for_information_response_modified_timestamp = $requestForInformationResponse->modified;
		$request_for_information_response_created_timestamp = $requestForInformationResponse->created;

		$escaped_request_for_information_response_title = $requestForInformationResponse->escaped_request_for_information_response_title;
		$escaped_request_for_information_response_nl2br = $requestForInformationResponse->escaped_request_for_information_response_nl2br;

		$rfiResponseCreatedTimestampInt = strtotime($request_for_information_response_created_timestamp);
		$rfiResponseCreatedTimestampDisplayString = date('n/j/Y g:ia', $rfiResponseCreatedTimestampInt);

		$rfiResponderContact = $requestForInformationResponse->getRfiResponderContact();
		/* @var $rfiResponderContact Contact */

		$rfiResponderContact->htmlEntityEscapeProperties();

		$rfiResponderContactFullNameHtmlEscaped = $rfiResponderContact->getContactFullNameHtmlEscaped();
		$rfi_responder_contact_escaped_title = ($rfiResponderContact->escaped_title !='')?'('.$rfiResponderContact->escaped_title.')':'';

		$responseHeaderInfo = "<div style='font-size: 12px;padding-top:5px;'>Answered $rfiResponseCreatedTimestampDisplayString by $rfiResponderContactFullNameHtmlEscaped $rfi_responder_contact_escaped_title</div>";

		// #d1d1d1
		// #bbb
		$tableRfiResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="RFI_table2_content">
				$responseHeaderInfo
				<div style="padding-top:2px;border-bottom: 1px solid #d1d1d1; font-size: 12px;">$escaped_request_for_information_response_nl2br</div>
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
	/*GC logo*/
	require_once('lib/common/Logo.php');
	// $gcLogo = Logo::logoByUserCompanyIDUsingSoftlinkWidthCustome($database,$user_company_id, true);
	$logo = new Logo($database);
	$gcLogo = $logo->logoByUserCompanyIDUsingBasePath($database,$user_company_id, true);
	$fulcrum = $logo->logoByFulcrumByBasePath(true);
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
	$uri = Zend_Registry::get('uri');

	$htmlContent = <<<END_HTML_CONTENT
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
				<td class="textAlignLeft thhighlight">$rfi_created_on</td>
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
END_HTML_CONTENT;
if($updatedRfi == "yes")
{
	$htmlContent .= <<<END_HTML_CONTENT

					<td class="thhightlightColortd" ><span class="thhightlightColor">Updated By :</span></td>
END_HTML_CONTENT;
}

	$htmlContent .= <<<END_HTML_CONTENT

					<td class="thhightlightColortd" nowrap><span class="thhightlightColor">To :</span></td>
				</tr>
				<tr>
					<td style="font-size:12px;" nowrap>$rfiCreatorContactFullNameHtmlEscaped</td>
END_HTML_CONTENT;
if($updatedRfi == "yes")
{

	$htmlContent .= <<<END_HTML_CONTENT

					<td style="font-size:12px;" nowrap>$RfiUpdatedContactName</td>
END_HTML_CONTENT;
}

	$htmlContent .= <<<END_HTML_CONTENT
					<td style="font-size:12px;" nowrap>$rfiRecipientContactFullNameHtmlEscaped</td>
				</tr>
				<tr>
					<td style="font-size:12px;" nowrap>$rfiCreatorContactCompanyOfficeAddressHtmlEscaped</td>
END_HTML_CONTENT;
if($updatedRfi == "yes")
{
	$htmlContent .= <<<END_HTML_CONTENT
					<td style="font-size:12px;" nowrap>$RfiUpdatedContactCompanyOfficeAddressHtmlEscaped</td>
END_HTML_CONTENT;
}

	$htmlContent .= <<<END_HTML_CONTENT
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
	$photoContents
</body>
</html>

END_HTML_CONTENT;

	return $htmlContent;
}
