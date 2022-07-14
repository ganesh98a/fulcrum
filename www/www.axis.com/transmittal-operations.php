<?php
/**
*  Transmittal operations
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
require_once('lib/common/ContractingEntities.php');
require_once('lib/common/PageComponents.php');
require_once('page-components/dropDownListWidgets.php');
require_once('page-components/fileUploader.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/Subcontract.php');

require_once('modules-gc-budget-functions.php');
require_once('transmittal-functions.php');
require_once('lib/common/Service/TableService.php');
require_once('lib/common/CostCodeDivision.php');


$db = DBI::getInstance($database);     	// Db Initialize
// Get session Values
$project_id = $session->getCurrentlySelectedProjectId();
$projectName = $session->getCurrentlySelectedProjectName();
$userCompanyId = $session->getUserCompanyId();
$userId = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
	// Function to get email Id based on Roles
	if(isset($_POST['method']) && ($_POST['method']=='rolesemail'))
	{
	$rolesMemID = $_POST['val'];
	$softwareModule = $_POST['software_module'];
	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($database, $project_id, $softwareModule, $rolesMemID);
	$arrProjectTeamMembers = ProjectTeamMembersNew($arrProjectTeamMembersNew);
	echo $arrProjectTeamMembers;
	}
	// Function to get email Id based on Projects
	if(isset($_POST['method']) && ($_POST['method']=='projectsemail'))
	{
	$company = $_POST['val'];
	$softwareModule = $_POST['software_module'];
	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($database, $project_id, $softwareModule, '', $company);
	$arrProjectTeamMembers = ProjectTeamMembersNew($arrProjectTeamMembersNew);
	echo $arrProjectTeamMembers;
	}
	// Function to get All email For a projects
	if(isset($_POST['method']) && ($_POST['method']=='allemail'))
	{
	$company = $_POST['val'];
	$softwareModule = $_POST['software_module'];
	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($database, $project_id, $softwareModule);
	$arrProjectTeamMembers = ProjectTeamMembersNew($arrProjectTeamMembersNew);
	echo $arrProjectTeamMembers;
	}

	if(isset($_POST['method']) && ($_POST['method']=='deletefile'))
	{
	$file_id = $_POST['val'];
	$transmittalid = $_POST['transmittalid'];

	$db = DBI::getInstance($database);
	$projectroles = array();
	// To get all attachment id
    $query = "Delete  FROM transmittal_attachments WHERE attachment_file_manager_file_id =$file_id and transmittal_data_id=$transmittalid";
    $db->execute($query);
	
		
	}

	//Transmittal for subcontractor
	if(isset($_POST['method']) && ($_POST['method']=='email_subcontractor'))
	{
		$address_id = $_POST['address_id'];
		$subcontract_id = $_POST['subcontract_id'];
		$type = $_POST['type'];
		$emailTo=$_POST['emailTo'];
		$bcc = $_POST['emailBCc'];
   		$bccValues = json_decode($bcc);
   		$cc  = $_POST['emailCc'];
  		$ccValues = json_decode($cc);
		$attachments        =   $_POST['attachments'];
    $fileAttachments    =   json_decode($attachments);
    if($type=='unsigned')
    {
		$query1 = "SELECT * FROM transmittal_types where transmittal_category='Subcontracts - contract creation'";
	}
	if($type=='signed')
    {
		$query1 = "SELECT * FROM transmittal_types where transmittal_category='Subcontracts - contract execution'";
	}
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
   		$notes=$mailText="";
   		$db->free_result();
        $db = DBI::getInstance($database); 
        $query = "INSERT INTO transmittal_data(sequence_number,transmittal_type_id,project_id,contracting_entity_id,comment,raised_by,mail_to,mail_content) VALUES(?,?,?,?,?,?,?,?)";
         $arrValues = array($sequence_no,$delay_notice,$project_id,$contract_entity_id,$notes,$currentlyActiveContactId,$emailTo,$mailText);
     
        if($db->execute($query,$arrValues)){
            $TransmittalId = $db->insertId; 
            $status = '1';
        }
        $db->free_result();
        //function For creating transmittal and sending email
       $Tran_result= TransmittalAndEmail($database, $userCompanyId, $TransmittalId,$projectName,$project_id,$userId,$fileAttachments,$emailTo,$bccValues ,$ccValues,$currentlyActiveContactId,$address_id,$type,$category,$status,'','','',$subcontract_id);
		 
	}

	//Transmittal For bid Invitation
	if(isset($_POST['method']) && ($_POST['method']=='Bid Invitation')){
		$type = $_POST['type'];
		$GcBudgetLineItemId = $_POST['GcBudgetLineItemId'];
		$SubcontractorContactIds = $_POST['csvSubcontractorBidContactIds'];
		$CheckedPdfIds = $_POST['csvCheckedPdfIds'];
		$mail_content = $_POST['mailIdTexts'];
		$exCostCode =$_POST['exCostCode'];
		$costContactData = json_decode($exCostCode,TRUE);

		$mailAttachment = $_POST['mailAttachments'];
		if ($mailAttachment != '' || $mailAttachment != null) {
			$mailAttachment = explode(",",$mailAttachment);
		}		

		$gcBudjetItems = $_POST['gcBudjetItems'];
		$TransmittalId = $_POST['TransmittalId'];
		$gcBudjetItems = json_decode($gcBudjetItems,TRUE);


		
		if(strpos($SubcontractorContactIds, ',')){
			$SubContactId=explode(',', $SubcontractorContactIds);
			foreach ($SubContactId as $key => $value) {
				$emailTo.="'".$value."',";
			}
		}else{
			$emailTo=$SubcontractorContactIds;
		}

		//To get the checked pdf attachement ids for Bid
		if($CheckedPdfIds != ''){
			$checkedPdfId = explode(',', $CheckedPdfIds);
		}else{
			$checkedPdfId = '';
		}
		$emailTo = rtrim($emailTo,',');
		//To get the attachement ids for Bid
		$fileAttachments = array();
		$key='0';
        $query1 = "SELECT * FROM `project_bid_invitations` WHERE `project_id` =$project_id ORDER BY `id` DESC";
		$db->execute($query1);
		while($row1 = $db->fetch()){
			$fileAttachments[$key] = $row1['project_bid_invitation_file_manager_file_id'];
			$key++;
		}
		$query2 = "SELECT * FROM `gc_budget_line_item_bid_invitations` WHERE `gc_budget_line_item_id` =$GcBudgetLineItemId ORDER BY `id` DESC";
        $db->execute($query2);
		while($row2 = $db->fetch()){
		   	$fileAttachments[$key] = $row2['gc_budget_line_item_bid_invitation_file_manager_file_id'];
		   	$key++;
		}
		$query3 = "SELECT * FROM `gc_budget_line_item_unsigned_scope_of_work_documents` WHERE `gc_budget_line_item_id` =$GcBudgetLineItemId ORDER BY `id` DESC";
        $db->execute($query3);
		while($row3 = $db->fetch()){
		   	$fileAttachments[$key] = $row3['unsigned_scope_of_work_document_file_manager_file_id'];
		   	$key++;
		}
		
		
  
       
        $sequence_no = getSequenceNumberForTransmittals($database, $project_id);

         // To include contracting Entity
		$contract_entity_id = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);
   		$db->free_result();
        $db = DBI::getInstance($database); 

        if ($exCostCode != 'null') {
			foreach ($costContactData as $key => $value) {
				foreach ($gcBudjetItems as $budjetKey => $budjetItems) {
					if($key == $budjetKey){
						$budjetItemId = $budjetItems[0];
					}
				}	
				$bidFileAttachments = array();
				$bidInviteKey ='0';
				$query1 = "SELECT * FROM `project_bid_invitations` WHERE `project_id` =$project_id ORDER BY `id` DESC";
				$db->execute($query1);
				$row1 = $db->fetch();
				$row1Pdfid = $row1['project_bid_invitation_file_manager_file_id'];
				if ($row1Pdfid != '') {
					$bidFileAttachments[$bidInviteKey] = $row1Pdfid;
					$bidInviteKey++;
				}

				/** bid invitations are not going on mail */
				
				// $query2 = "SELECT * FROM `gc_budget_line_item_bid_invitations` WHERE `gc_budget_line_item_id` =$budjetItemId ORDER BY `id` DESC";
				// $db->execute($query2);
				// $row2 = $db->fetch();
				// $bidFileAttachments[$bidInviteKey] = $row2['gc_budget_line_item_bid_invitation_file_manager_file_id'];
				// $bidInviteKey++;
			
				$query3 = "SELECT * FROM `gc_budget_line_item_unsigned_scope_of_work_documents` WHERE `gc_budget_line_item_id` =$budjetItemId ORDER BY `id` DESC";
				$db->execute($query3);
				// while($row1 = $db->fetch()){
					$row3 = $db->fetch();
					$row3Pdfid = $row3['unsigned_scope_of_work_document_file_manager_file_id'];
				if ($row3Pdfid != '') {
					$bidFileAttachments[$bidInviteKey] = $row3Pdfid;
					$bidInviteKey++;
				}
				
				// }
			
				if($type=='Bid'){
					$query1 = "SELECT * FROM transmittal_types where transmittal_category='Bid Invitation'";
					if ($mailAttachment != '' || $mailAttachment != null) {
						foreach ($mailAttachment as $attach) {
							$bidFileAttachments[$bidInviteKey] = $attach;
							$bidInviteKey++;
						}
					}
				}

		
				$costCodeIdUsingGCBudLineItemId = TableService::getSingleField($database,'gc_budget_line_items','cost_code_id','id',$budjetItemId);
				$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $userCompanyId);
				$costcodedata = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$costCodeIdUsingGCBudLineItemId,$costCodeDividerType);
				$costCodeLabel = $costcodedata['ccd_division_number'].$costCodeDividerType.$costcodedata['cost_code'].' '.$costcodedata['cost_code_description'];	
		
				$db->execute($query1);
				while($row1 = $db->fetch()){
				   
					$val = $row1['id'];
					$category = $row1['transmittal_category'];
				   
				}
				$db->free_result();
				$delay_notice=$val; // Refer to Transmittal_types table
				$test = implode(',',$value);
				$emailTo = $test;
				if($type=='Bid'){
					$sequence_no = getSequenceNumberForTransmittals($database, $project_id);
					$db = DBI::getInstance($database);  // Db Initialize
					// $queryArr = "INSERT INTO transmittal_data(sequence_number,transmittal_type_id,project_id,contracting_entity_id,comment,raised_by,mail_to,mail_content) VALUES('$sequence_no','$delay_notice','$project_id','$contract_entity_id','$costCodeLabel','$currentlyActiveContactId','$test','$mail_content')";
				
					// if($db->execute($queryArr, MYSQLI_STORE_RESULT)){
					// 	$TransmittalId = $db->insertId; 
					// 	$status = '0';
					// }

					$query ="UPDATE transmittal_data SET `sequence_number`=?,`transmittal_type_id`=?,`project_id`=?,`contracting_entity_id`=?,`comment`=?,`raised_by`=?,`mail_to`=?,`mail_content`=?   WHERE `id` = '".$TransmittalId."'
					";
					$arrValues = array($sequence_no,$delay_notice,$project_id,$contract_entity_id,$costCodeLabel,$currentlyActiveContactId,$SubcontractorContactIds,$mail_content);
					$db->execute($queryArr, MYSQLI_STORE_RESULT);
					$db->free_result();
					$TransmittalId = $TransmittalId; 
						$status = '0';

					$checkedPdfId = $bidFileAttachments;
				}else{
					// $query = "INSERT INTO transmittal_data(sequence_number,transmittal_type_id,project_id,contracting_entity_id,comment,raised_by,mail_to,mail_content) VALUES(?,?,?,?,?,?,?,?)";
					// $arrValues = array($sequence_no,$delay_notice,$project_id,$contract_entity_id,$costCodeLabel,$currentlyActiveContactId,$SubcontractorContactIds,$mail_content);
					// if($db->execute($query,$arrValues)){
					// 	$TransmittalId = $db->insertId; 
					// 	$status = '0';
					// }
					// $db->free_result();


		$query ="UPDATE transmittal_data SET `sequence_number`=?,`transmittal_type_id`=?,`project_id`=?,`contracting_entity_id`=?,`comment`=?,`raised_by`=?,`mail_to`=?,`mail_content`=?   WHERE `id` = ?
					";
					$arrValues = array($sequence_no,$delay_notice,$project_id,$contract_entity_id,$costCodeLabel,$currentlyActiveContactId,$SubcontractorContactIds,$mail_content,$TransmittalId);
					$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
					$db->free_result();
					$TransmittalId = $TransmittalId; 
						$status = '0';
				}
				//function For creating transmittal and sending email
       			$Tran_result= TransmittalAndEmail($database, $userCompanyId, $TransmittalId,$projectName,$project_id,$userId,$checkedPdfId,$emailTo,'','',$currentlyActiveContactId,'',$type,$category,$status); //roja
			}
		}else{
			if($type=='Bid'){
				$query1 = "SELECT * FROM transmittal_types where transmittal_category='Bid Invitation'";
			}
		
	        $db->execute($query1);
	        while($row1 = $db->fetch()){
	           
	            $val = $row1['id'];
	            $category = $row1['transmittal_category'];
	           
	        }
	        $db->free_result();
	        $delay_notice=$val; // Refer to Transmittal_types table	

	        $costCodeIdUsingGCBudLineItemId = TableService::getSingleField($database,'gc_budget_line_items','cost_code_id','id',$GcBudgetLineItemId);
			$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $userCompanyId);
			$costcodedata = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$costCodeIdUsingGCBudLineItemId,$costCodeDividerType);
			$costCodeLabel = $costcodedata['ccd_division_number'].$costCodeDividerType.$costcodedata['cost_code'].' '.$costcodedata['cost_code_description'];

			// $query = "INSERT INTO transmittal_data(sequence_number,transmittal_type_id,project_id,contracting_entity_id,comment,raised_by,mail_to,mail_content) VALUES(?,?,?,?,?,?,?,?)";
			$query ="UPDATE transmittal_data SET `sequence_number`=?,`transmittal_type_id`=?,`project_id`=?,`contracting_entity_id`=?,`comment`=?,`raised_by`=?,`mail_to`=?,`mail_content`=?   WHERE `id` = ?
					";
	        $arrValues = array($sequence_no,$delay_notice,$project_id,$contract_entity_id,$costCodeLabel,$currentlyActiveContactId,$SubcontractorContactIds,$mail_content,$TransmittalId);
	        $db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
					$db->free_result();
					$TransmittalId = $TransmittalId; 
						$status = '0';
	        //function For creating transmittal and sending email
       		$Tran_result= TransmittalAndEmail($database, $userCompanyId, $TransmittalId,$projectName,$project_id,$userId,$checkedPdfId,$emailTo,'','',$currentlyActiveContactId,'',$type,$category,$status);
		}      
	}
	//Method to create Subcontractor Notice
	if(isset($_POST['method']) && ($_POST['method']=='subcontractorNotice'))
	{
	if (!isset($dummyId) || empty($dummyId)) {
	$dummyId = Data::generateDummyPrimaryKey();
	}
	$gc_budget_line_item_id=$_POST['budget_id'];
	$type=$_POST['type'];
	$address_id=$_POST['address_id'];
	$subcontractOrg_id=$_POST['subcontract_id'];

	//For email Filter option
	$emailfilter = array('0'=>'All','1'=>'Roles','2'=>'Company');
	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_emailfilter_id--$dummyId";
	$js = 'id="emailfilter" class="target moduleRFI_dropdown4 required" onchange="emailfilters(this.id,this.value)"  ';
	$prependedOption = '<option value="">Select a Type</option>';
	$selectedOption = $request_for_information_type_id;
	$emailfilterId = "emailfilter";
	$emailfilterList = PageComponents::dropDownList($emailfilterId, $emailfilter, '', null, $js, null,$selectedOption);
	//For roles 
	$AXIS_USER_ROLE_ID_BIDDER = AXIS_USER_ROLE_ID_BIDDER;
	$projectrole = projectroles($database);
	unset($projectrole[$AXIS_USER_ROLE_ID_BIDDER]);
	$projectrole = array('' => 'Select a Role') + $projectrole;
	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_projectrole_id--$dummyId";
	$js = 'id="project_role" class="target moduleRFI_dropdown4 required" style="display:none;" onchange="emailroles(this.value)"';
	$prependedOption = '<option value="">Select a Role</option>';
	$projectroleListId = "project_role";
	$projectroleList = PageComponents::dropDownList($projectroleListId, $projectrole, '', null, $js, null);
	//For Company 
	$projectCompany = companyWithoutBidder($project_id, $database);
	$projectCompany = array('' => 'Select a Company') + $projectCompany;
	$delayUserTypes = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_projectrole_id--$dummyId";
	$js = 'id="project_company" class="target moduleRFI_dropdown4 required" style="display:none;" onchange="emailcompany(this.value)" ';
	$prependedOption = '<option value="">Select Company</option>';
	$projectCompanyId = "projectCompany";
	$projectCompanyList = PageComponents::dropDownList($projectCompanyId, $projectCompany, '', null, $js, null);
	
	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($database, $project_id, 'subcontracts');

	$arrsubcontractorlist = Subcontract::loadSubcontractorContact($database,$subcontractOrg_id);

	//to merge two arrays
	$arrProjectTeamMembersNew=array_merge($arrProjectTeamMembersNew,$arrsubcontractorlist);
	//to remove duplicate arrays
	$arrProjectTeamMembersNew = array_unique($arrProjectTeamMembersNew,SORT_REGULAR);
	//to sort the arrays
	$arrProjectTeamMembersNew[]=usort($arrProjectTeamMembersNew, function ($a, $b) { return $b['contact_company_id'] - $a['contact_company_id']; });
	//to make the arrays as acending order
	$arrProjectTeamMembersNew = array_reverse($arrProjectTeamMembersNew);

	
	$default_gc_signatory =Subcontract::getsignatoryId($database,$subcontractOrg_id,'vendor_signatory');
// To:
// rfi_recipient_contact_id
$rfiDraftsHiddenProjectTeamMembersToElementId = "create-request_for_information_draft-record--request_for_information_drafts--rfi_recipient_contact_id--$dummyId";
$selectedOption = $rfi_recipient_contact_id;

$js = ' class="moduleRFI_dropdown4 required emailGroup to_contact" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$rfiDraftsHiddenProjectTeamMembersToElementId.'\');"';
$prependedOption = '<option value="">Select a contact</option>';
$ddlProjectTeamMembersToId = "ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--$dummyId";
$ddlProjectTeamMembersTo = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersToId,$default_gc_signatory);

// Cc:
// rfi_additional_recipient_contact_id

$ddlProjectTeamMembersCcId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Cc-$dummyId";
$js = ' onchange="addRecipient(this);" class="moduleRFI_dropdown4 emailGroup cc_contact"';
$ddlProjectTeamMembersCc = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersCcId);

// Bcc:

$ddlProjectTeamMembersBccId = "ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Bcc-$dummyId";
$ddlProjectTeamMembersBcc = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersBccId);

$rfi_attachment_source_contact_id = $currently_active_contact_id;
$rfi_creator_contact_id = $currently_active_contact_id;
//To get the attachement for signed and unsigned
$arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id);
foreach ($arrSubcontracts as $subcontract) {

			$subcontract_id = $subcontract->subcontract_id;
			if($subcontractOrg_id == $subcontract_id){

			$subcontractDetailsWidget = buildSubcontractDetailsWidget($database, $user_company_id, $subcontract_id);
			$unsignedSubcontractFileManagerFile = $subcontract->getUnsignedSubcontractFileManagerFile();
			$signedSubcontractFileManagerFile = $subcontract->getSignedSubcontractFileManagerFile();
		
			if ($unsignedSubcontractFileManagerFile) {
				$unsigned_version_number = $unsignedSubcontractFileManagerFile->version_number;
				$unsignfile_id=$unsignedSubcontractFileManagerFile->file_manager_file_id;
				$fileManagerFile = FileManagerFile::findById($database, $unsignedSubcontractFileManagerFile->file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$fileManagerFile->htmlEntityEscapeProperties();
			$virtual_file_name = $fileManagerFile->virtual_file_name;
			$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
			$fileUrl = $fileManagerFile->generateUrl();
				$unsignedSubcontractFilename = $unsignedSubcontractFileManagerFile->virtual_file_name;
				$unsignedSubcontractFileManagerFileLink =
					'<a class="underline" target="_blank" href="'.$fileUrl.'">'.$unsignedSubcontractFilename.'</a>';
			} 

			if ($signedSubcontractFileManagerFile) {
				$signed_version_number = $signedSubcontractFileManagerFile->version_number;
			$signfile_id=$signedSubcontractFileManagerFile->file_manager_file_id;	
		$fileManagerFile = FileManagerFile::findById($database, $signedSubcontractFileManagerFile->file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$fileManagerFile->htmlEntityEscapeProperties();
			$virtual_file_name = $fileManagerFile->virtual_file_name;
			$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
			$fileUrl = $fileManagerFile->generateUrl();
			$signedSubcontractFilename = $signedSubcontractFileManagerFile->virtual_file_name;
				$signedSubcontractFileManagerFileLink =
					'<a class="underline" target="_blank" href="'.$fileUrl.'">'.$signedSubcontractFilename.'</a>';
			} 
		}
		}
		if($type=='signed')
		{
			 $attachement=$signedSubcontractFileManagerFileLink;
			 $upfile_id=$signfile_id;
		}if($type=='unsigned')
		{
			 $attachement=$unsignedSubcontractFileManagerFileLink;
			 $upfile_id=$unsignfile_id;
		}
		
//End Of Signed and Unsigned
$modalContent=<<<modalContent
<div class="modal-content">
<div class="modal-header">
  <span class="close" onclick="modal_Close('$subcontractOrg_id');">&times;</span>
  <h3>Email Subcontractor</h3>
</div>
<div class="modal-body">
<form id="formCreateRfinotification">
<div id="record_creation_form_container--create-request_for_information-record--$dummyId">
	
		<table width="100%" border="0" cellspacing="0" cellpadding="4">
		<tr>
					<td class="RFI_table_header2" colspan="3">Attached Files:</td>
				</tr>
				<tr>
					<td id="tdAttachedFilesList" class="RFI_table2_content" colspan="3">
						<ul style="list-style:none; margin:0; padding:0" id="container--request_for_information_attachments--create-request_for_information-record">
							
							$attachement
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
				<td class="RFI_table_header2" style="vertical-align: middle;" colspan="3">Email:</td>
			</tr>
			<tr>
				<td class="RFI_table2_content Subsearch" colspan="3">
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
modalContent;

					// <p>Add additional text to the body of the email: </p>
					// <p>
					// 	<textarea id="textareaBody" class="RFI_table2"></textarea>
					// </p>
$modalContent.=<<<modalContent

					<p>
						<input type="button" value="Email subcontractor" onclick="email_subcontractor('$dummyId','$subcontractOrg_id');" style="font-size: 10pt;align:right;">&nbsp;
						
					</p>
					
					</td>
			</tr>
		</table>
	
</div>
</form>
<input id="upfile" type="hidden" value="$upfile_id">
<input id="type" type="hidden" value="$type">

<input id="address_id" type="hidden" value="$address_id">
<input id="create-request_for_information-record--requests_for_information--dummy_id" type="hidden" value="$dummyId">

</div>
<div class="myPopover hidden" id="pop_data"></div>
<div class="modal-footer">
	   <button class="buttonClose" onclick="modal_Close('$subcontractOrg_id');">Close</button>
</div>
</div>
modalContent;

echo $modalContent;
	}
	//To get the All the Email Ids of the team Members
	function ProjectTeamMembers($project_id,$rolesMemID,$company)
	{

		$db = DBI::getInstance($database);
		if($rolesMemID)
		{
			$roles="and p2c2r.role_id IN ($rolesMemID)";
		}
		if($company)
		{
			
		$company_filter="and c_fk_cc.`id`=$company";
		}
      	 $query = "SELECT Distinct c.*,c_fk_cc.`company` AS 'companyName' FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`

	INNER JOIN `projects_to_contacts_to_roles` p2c2r ON p2c2r.`contact_id` = c.`id`
	INNER JOIN `roles` r ON p2c2r.`role_id` = r.`id`
	
WHERE p2c2r.`project_id` = $project_id and p2c2r.role_id not IN ('3') $roles $company_filter
ORDER BY r.`sort_order` ASC, c_fk_cc.`company` ASC, c.`first_name` ASC, c.`last_name` ASC, c.`email` ASC";

        $db->execute($query);
       	$teamOption='<optgroup label=""><option value="0">Select a contact</option></optgroup>';
       	$currentCompany = '';
		$first = true;
		while($row = $db->fetch())
		{
		   	$val = $row['id'];
		   	$first_name = $row['first_name'];
		   	$last_name = $row['last_name'];
		   	$email = $row['email'];
		   	$company = $row['companyName'];
		   	if ($currentCompany <> $company) {
		   		$currentCompany = $company;
		   		if ($first) {
					$first = false;
					$teamOption .="<optgroup label='$company'>";
				}else{
					$teamOption .="</optgroup><optgroup label='$company'>";
				}
			}
		   	if($first_name!='' || $last_name !='')
		   	{
		   		$teamOption .="<option value=$val>$first_name $last_name &lt;$email&gt;</option>";
		   	}
		   	else
		   	{
		   		$teamOption .="<option value=$val>$email</option>";
		   	}
		   
		}
		$teamOption .="</optgroup>";
		
		return $teamOption;
		
	}

function ProjectTeamMembersNew($arrProjectTeamMembers)
	{
$dropDownList = <<<END_DROP_DOWN_LIST
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
return $dropDownList;
		
	}
	
	
