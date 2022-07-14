<?php
/**
*  RFI
*/

$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;


require_once('lib/common/init.php');
$timer->startTimer();
$_SESSION['timer'] = $timer;

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
require_once('lib/common/User.php');
require_once('lib/common/UserCompany.php');
require_once('lib/common/Project.php');
require_once('lib/common/JobsiteDelayCategoryTemplates.php');

require_once('page-components/dropDownListWidgets.php');
require_once('page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('transmittal-functions.php');
require_once('lib/common/Module.php');
require_once('lib/common/Service/TableService.php');




$database = DBI::getInstance($database);     	// Db Initialize
// SESSSION VARIABLES
$userCompanyId = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();
$currently_active_contact_id = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
if((isset($_POST['method'])) && 
($_POST['method']=='NotifySubcontractor'))
{

$request_for_information_draft_id=$_POST['request_id'];
if (!isset($dummyId) || empty($dummyId)) {
	$dummyId = Data::generateDummyPrimaryKey();
}
	
// $rolesMemID = '10'; // To load subcontractors
// $arrProjectTeamMembers = projectAlluserwithgroupselect($database, $project_id, $request_for_information_draft_id, $rolesMemID);
$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($database, $project_id, 'rfis');

// To:
// rfi_recipient_contact_id
$rfiDraftsHiddenProjectTeamMembersToElementId = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_contact_id--$dummyId";
$js = ' class="moduleRFI_dropdown4 required NotifySub" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$rfiDraftsHiddenProjectTeamMembersToElementId.'\');"';
$prependedOption = '<option value="">Select a contact</option>';
$ddlProjectTeamMembersToId = "ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--$dummyId";
$selectedOption = $rfi_recipient_contact_id;
$ddlProjectTeamMembersTo =buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersToId);



// Cc:
// rfi_additional_recipient_contact_id
	
	$ddlProjectTeamMembersCcId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Cc-$dummyId";
$js = ' onchange="RFIs__addRecipient(this,&apos;cc&apos;);" class="moduleRFI_dropdown4 NotifySub"';
	$ddlProjectTeamMembersCc =buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersCcId);
	
$js = ' onchange="RFIs__addRecipient(this,&apos;bcc&apos;);" class="moduleRFI_dropdown4 NotifySub"';

// Bcc:
	

$ddlProjectTeamMembersBccId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Bcc-$dummyId";
$ddlProjectTeamMembersBcc =buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersBccId);


$rfi_attachment_source_contact_id = $currently_active_contact_id;
$rfi_creator_contact_id = $currently_active_contact_id;
$modalContent=<<<modalContent
<div class="modal-content">
<div class="modal-header">
  <span class="close" onclick="modalClose();">&times;</span>
  <h3>Notify Subcontractor</h3>
</div>
<div class="modal-body">
<form id="formCreateRfinotification">
<div id="record_creation_form_container--create-request_for_information-record--$dummyId">
	
		<table width="100%" border="0" cellspacing="0" cellpadding="4">
			<tr>
				<td class="RFI_table_header2" style="vertical-align: middle;">Email:</td>
			</tr>
			<tr>
				<td class="RFI_table2_content">
					<input id="create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--$dummyId" type="hidden" value="$rfi_recipient_contact_id">
					<input id="create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_contact_id--$dummyId" type="hidden" value="$rfi_recipient_contact_id">
					<p class="Subsearch">To: &nbsp;$ddlProjectTeamMembersTo</p>
					<div class="Subsearch" id="cc">
						<p>Cc: &nbsp;$ddlProjectTeamMembersCc</p>
						<ul id="record_container--request_for_information_recipients--Cc" style="list-style:none;">
						</ul>
					</div>
					<div class="Subsearch" id="bcc">
						<p>Bcc: $ddlProjectTeamMembersBcc</p>
						<ul id="record_container--request_for_information_recipients--Bcc" style="list-style:none;">
						</ul>
					</div>
					<p>Add additional text to the body of the email: </p>
					<p>
						<textarea id="textareaBody" class="RFI_table2"></textarea>
					</p>
					<p>
						<input type="button" value="Notify subcontractor" onclick="Email_notififysubcontractor('$dummyId');" style="font-size: 10pt;">&nbsp;
						
					</p>
					
					</td>
			</tr>
		</table>
	
</div>
</form>

<input id="create-request_for_information-record--requests_for_information--dummy_id" type="hidden" value="$dummyId">

</div>
<div class="myPopover hidden" id="pop_data"></div>
<div class="modal-footer">
	   <button class="buttonClose" onclick="modalClose();">Close</button>
</div>
</div>
modalContent;

echo $modalContent;

}	
if((isset($_POST['formValues'])) && 
($_POST['formValues']['method']=='EmailSubcontractorandTransmittal'))
{
	$db = DBI::getInstance($database);     	// Db Initialize

$formValues = $_POST['formValues'];   
$mailText           =   addslashes($formValues['mailText']);
// $fileAttachments    =   json_decode($attachments);
$fileAttachments    ='';
$emailTo            =   $formValues['emailTo'];
$rfiId=					$formValues['rfiId'];
$bcc = $formValues['emailBCc'];
$bccValues = json_decode($bcc);
$cc  = $formValues['emailCc'];
$ccValues = json_decode($cc);

//To get RFI Attachments
// RFI Attachments
	$loadRequestForInformationAttachmentsByRequestForInformationIdOptions = new Input();
	$loadRequestForInformationAttachmentsByRequestForInformationIdOptions->forceLoadFlag = true;
	$arrRequestForInformationAttachmentsByRequestForInformationId = RequestForInformationAttachment::loadRequestForInformationAttachmentsByRequestForInformationId($database, $rfiId, $loadRequestForInformationAttachmentsByRequestForInformationIdOptions);
	$i='0';
	foreach ($arrRequestForInformationAttachmentsByRequestForInformationId as $requestForInformationAttachment) {
				

				$rfiAttachmentFileManagerFile = $requestForInformationAttachment->getRfiAttachmentFileManagerFile();
			
			$fileAttachments[$i]=	$rfiAttachmentFileManagerFile->file_manager_file_id;
			$i++;
			}
//End of RFI attachments

		$query1 = "SELECT * FROM transmittal_types where transmittal_category='RFI'";
	
        $db->execute($query1);
        while($row1 = $db->fetch())
        {
           
            $val = $row1['id'];
            $category = $row1['transmittal_category'];
           
        }
        $delay_notice=$val; // Refer to Transmittal_types table
        $category =str_replace(' ', '', $category);
        $sequence_no = getSequenceNumberForTransmittals($database, $project_id);
           // To include contracting Entity
        $contract_entity_id = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);
        $db->free_result();

        $options = array();
        $options['fields'] = array('rfi_sequence_number','rfi_title');
        $condition_arr = array();
        $condition_arr['id = ?'] = $rfiId;
        $options['filter'] = $condition_arr;
        $options['table'] = 'requests_for_information';
        $rfiDetails = TableService::GetTabularData($database, $options);

        $notes= '#'.$rfiDetails['rfi_sequence_number'].' - '.$rfiDetails['rfi_title'];
        $db = DBI::getInstance($database); 
        $query = "INSERT INTO transmittal_data(sequence_number, transmittal_type_id,project_id,contracting_entity_id,comment,raised_by,mail_to,mail_content) VALUES(?,?,?,?,?,?,?,?)";   
        $arrValues = array($sequence_no,$delay_notice,$project_id,$contract_entity_id,$notes,$currently_active_contact_id,$emailTo,$mailText);     
        if($db->execute($query,$arrValues)){
            $TransmittalId = $db->insertId; 
            $status = '1';
        }
        $db->free_result();
        //function For creating transmittal and sending email
       $Tran_result= TransmittalAndEmail($database, $userCompanyId, $TransmittalId,$currentlySelectedProjectName,$project_id,$user_id,$fileAttachments,$emailTo,$bccValues ,$ccValues,$currently_active_contact_id,'','RFI',$category,$status,$rfiId);

	}

if((isset($_POST['formValues'])) && 
($_POST['formValues']['method']=='EmailSubcontractor'))
{
$db = DBI::getInstance($database);     	// Db Initialize

$formValues = $_POST['formValues'];   
$mailText           =   $formValues['mailText'];
$attachments        =   $formValues['attachments'];
$fileAttachments    =   json_decode($attachments);
$emailTo            =   $formValues['emailTo'];
$rfiId=					$formValues['rfiId'];
$bcc = $formValues['emailBCc'];
$bccValues = json_decode($bcc);
$cc  = $formValues['emailCc'];
$ccValues = json_decode($cc);
 // Get company name
$companyQuery = "SELECT company FROM user_companies where id='$userCompanyId'  limit 1 ";
$db->execute($companyQuery);
$companyResult = array();
while($row = $db->fetch())
{
    $companyResult[] = $row;
}
$companyName = $companyResult[0]['company']; 
$db->free_result();

  

    //To get the RFI File attachements
    $requestForInformation = RequestForInformation::findRequestForInformationByIdExtended($database, $rfiId);
   $requestForInformation->htmlEntityEscapeProperties();

		$project = $requestForInformation->getProject();
		/* @var $project Project */
		$project->htmlEntityEscapeProperties();
		$formattedProjectName = $project->project_name . ' (' . $project->user_custom_project_id . ')';
		$formattedProjectNameHtmlEscaped = $project->escaped_project_name . ' (' . $project->escaped_user_custom_project_id . ')';

		$requestForInformationType = $requestForInformation->getRequestForInformationType();
		
		$requestForInformationStatus = $requestForInformation->getRequestForInformationStatus();
		/* @var $requestForInformationStatus RequestForInformationStatus */

		$requestForInformationPriority = $requestForInformation->getRequestForInformationPriority();
        	$rfiFileId = $requestForInformation->rfi_file_manager_file_id;
		/* @var $requestForInformationPriority RequestForInformationPriority */

		// Cloud Filesystem File
		$rfiFileManagerFile = $requestForInformation->getRfiFileManagerFile();
		/* @var $rfiFileManagerFile FileManagerFile */
		$rfiFileManagerFile->htmlEntityEscapeProperties();
		$includeAttachment = true;
   //Ends here
   
              

        $fromuserInfo = Contact::findContactByUserCompanyIdAndUserId($database,$userCompanyId ,$user_id);
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

        if($mailToName == ' '){
            $mailToName = $mailToEmail;
        }

        $cdnFileUrl = $rfiFileManagerFile->generateUrl();
        $attachmentFileName = $rfiFileManagerFile->virtual_file_name;
         // for file size greater than 17 mb
            $filemaxSize=Module::getfilemanagerfilesize($rfiFileId,$database);
            if(!$filemaxSize)
            {

            if (strpos($cdnFileUrl,"?"))
            {
                $virtual_file_name_url = $cdnFileUrl."&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
            }else
            {
                $virtual_file_name_url = $cdnFileUrl."?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
            }
            $RfiPDF="<br><table style=width:80%;> 
            <tr>
            <td style='padding:2px;'>Please find the RFI PDF File Link:</td>
            <td style='padding:2px;'><a href='".$virtual_file_name_url."'>$attachmentFileName</a></td></tr>
            </table><br>";
            }else
            {
               $RfiPDF="" ;
            }
            //End of file size
        //Mail Body 
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
$RfiPDF";
        $greetingLine = 'Hi '.$mailToName.',<br><br>';
        $htmlAlertMessageBody = <<<END_HTML_MESSAGE
        $companyLogoData
        $greetingLine$mailText
        <br><span style="margin:2%"></span>
        
END_HTML_MESSAGE;

	$sendEmail = 'Alert@MyFulcrum.com';
    	$sendName = ($fromUsername !=" ") ? $fromUsername : "Fulcrum Message";
        $mail = new Mail();
        $mail->setBodyHtml($htmlAlertMessageBody, 'UTF-8', Zend_Mime::MULTIPART_RELATED);
        $mail->setFrom($sendEmail, $sendName);
        $mail->addTo($mailToEmail, $mailToName);
        $mail->addHeader('Reply-To',$fromEmail);

        $mail->setSubject('RFI NOTIFY SUBCONTRACTOR');
        if($filemaxSize)
            {
        	if ($includeAttachment && isset($rfiFileManagerFile) && $rfiFileManagerFile) {
					// Attach RFI itself
					

					$cdnFileUrl = str_replace("http:", '', $cdnFileUrl);
					if (strpos($cdnFileUrl, '?')) {
						$separator = '&';
					} else {
						$separator = '?';
					}
					$finalCdnFileUrl = 'http:' . $cdnFileUrl . $separator . 'id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
					$fileContents = file_get_contents($finalCdnFileUrl);
					$mail->createAttachment($attachmentFileName, $fileContents);
				}
            }
      
        if(!empty($ccValues)){
            foreach($ccValues as $ccValue){
                $mailCcQuery = "SELECT email,first_name,last_name FROM contacts where id='$ccValue'  limit 1 ";
                $db->execute($mailCcQuery);
                $mailCcResult = array();
                while($row = $db->fetch())
                {
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
                while($row = $db->fetch())
                {
                    $mailBCcResult[] = $row;
                }
                $db->free_result();
                $mailBCcEmail = $mailBCcResult[0]['email']; 
                $mailBCcName = $mailBCcResult[0]['first_name'].' '.$mailBCcResult[0]['last_name']; 
                $mail->addBcc($mailBCcEmail, $mailBCcName);
            }
        }
     echo "sent".$mail->send();
    //To delete the img
    $config = Zend_Registry::get('config');
    $file_manager_back = $config->system->base_directory;
    $file_manager_back =$file_manager_back.'www/www.axis.com/';
    $path=$file_manager_back.$mail_image;
    unlink($path);

}
// To get the contacts associated with costcode
function GetcostcodevendorId($project_id,$rfi_id)
{
		$db = DBI::getInstance($database);

	 $query1 = "SELECT group_concat(subcontract_vendor_contact_id ) as vendor_id FROM `subcontracts` WHERE `gc_budget_line_item_id` = (SELECT id FROM `gc_budget_line_items` WHERE `project_id` = $project_id AND `cost_code_id` = (SELECT rfi_cost_code_id FROM `requests_for_information` WHERE `id` = $rfi_id ORDER BY `id` DESC ) ORDER BY `id` DESC ) ORDER BY `id` DESC ";
	
	$db->execute($query1);
	$row1 = $db->fetch();
	return $row1['vendor_id'];
}

/* contact loadProjectTeamMembers */
function projectAlluserwithgroupselect($database, $project_id, $rfi_id, $rolesMemID=null)
{
	$db = DBI::getInstance($database);
	$arrContactTeamMembers = array();

	//To get the contact assigned in the costcode
	$costvendorID=GetcostcodevendorId($project_id,$rfi_id);
	if($costvendorID)
	{
		$filter = "FIELD (c.id, $costvendorID ) DESC ,";
		//To split costvendor
		$data=explode(',',$costvendorID);
		$vendorvalue='';
		foreach($data as $eachval)
		{
	   	 $vendorvalue .="'".$eachval."',";
		}
		$vendorvalue=trim($vendorvalue,',');


	}else{
			$filter = '';
		}
		
		if($rolesMemID != '' || $rolesMemID != null){
		$whereIn = 'and p2c2r.role_id IN ('.$rolesMemID.')';
		}else{
			$whereIn = '';
		}
		//To get the cost code contacts
		if($costvendorID)
		{
		 $query1 =
"
SELECT
	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`
WHERE c.id IN ($vendorvalue)";

		$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);

		while($row1 = $db->fetch())
		{
			$val=$row1['id'];
			$arrContactTeamMembers[$val]=$row1;
		}
	$db->free_result();	
}

		 $query =
"
SELECT
	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`

	INNER JOIN `projects_to_contacts_to_roles` p2c2r ON p2c2r.`contact_id` = c.`id`
	INNER JOIN `roles` r ON p2c2r.`role_id` = r.`id`
	
WHERE p2c2r.`project_id` = ? and p2c2r.role_id not IN ('14') $whereIn
ORDER BY $filter r.`sort_order` ASC, c_fk_cc.`company` ASC, r.`role` ASC, c.`first_name` ASC ,
c.`last_name` ASC
";

		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		while($row = $db->fetch())
		{
			$val=$row['id'];
			$exist= array_key_exists($val,$arrContactTeamMembers);
			if(!$exist){
				$arrContactTeamMembers[$val]=$row;
			}
		}
		return $arrContactTeamMembers;

}

/**
 * Build a fancy <select> with <optgroups>
 *
 * @param Input $input
 * @return HTML String
 */

function buildProjectFullNameWithEmailDropDownList($arrProjectTeamMembers,$js,$name,$tabIndexHtml){
	$dropDownList = <<<END_DROP_DOWN_LIST
<select id="$name" name="$name" $tabIndexHtml $js>
	<optgroup label="">
		<option value="">Select A Contact</option>
	</optgroup>
END_DROP_DOWN_LIST;
$curcompany='';
$first='';
foreach ($arrProjectTeamMembers as $value) {
	$company  =$value['c_fk_cc__company'];
	if($value['first_name']!='' && $value['last_name']!='')
	{
		$username=$value['first_name'].' '.$value['last_name'].' - ';

	}else
	{
		$username='';

	}
	$email=$value['email'];
	$contact_id=$value['id'];
if($curcompany <> $company)
{
	$curcompany=$company;
	if ($first) {

	$first = false;
	$dropDownList .= <<<END_DROP_DOWN_LIST
	<optgroup label="$company">
END_DROP_DOWN_LIST;

}else {

				$dropDownList .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$company">
END_HTML_CONTENT;

			}
		}

	$dropDownList .= <<<END_DROP_DOWN_LIST

<option value="$contact_id">$username $email</option>
END_DROP_DOWN_LIST;

}
return $dropDownList .= <<<END_DROP_DOWN_LIST
	</select>
END_DROP_DOWN_LIST;

}


