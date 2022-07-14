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
require_once('lib/common/User.php');
require_once('lib/common/UserCompany.php');
require_once('lib/common/Project.php');
require_once('lib/common/JobsiteDelayCategoryTemplates.php');

require_once('page-components/dropDownListWidgets.php');
require_once('page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');



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
if((isset($_POST['method'])) && ($_POST['method']=='costcodeusers'))
{

$costcode=$_POST['costcode_id'];
$dummyId=$_POST['dummy'];
$user_company_id=$_POST['company_id'];
$project_id=$_POST['project_id'];


// $arrProjectTeamMembers = projectAlluserwithgroupselectsubmittal($database, $project_id,$rolesMemID,$costcode);
// DDL of contacts
$su_initiator_contact_id= "";
$suDraftsHiddenContactsByUserCompanyIdToElementId = "create-submittal_draft-record--submittal_drafts--su_initiator_contact_id--$dummyId";
	$input = new Input();
	$input->database = $database;
	$input->user_company_id = $user_company_id;
	$input->costcode = $costcode;
	$input->project_id = $project_id;
	//$input->csvContactIdExclusionList = $arrCustomizedPermissionsByContact;
	$input->selected_contact_id = $su_initiator_contact_id;
	$input->htmlElementId = "ddl--create-submittal-record--submittals--su_initiator_contact_id--$dummyId";
	$input->js = ' class="moduleSUBMITTAL_dropdown4 NotifySub required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$suDraftsHiddenContactsByUserCompanyIdToElementId.'\');"';
	$input->firstOption = 'Select a contact';
	$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildSubmittalsContactsFullNameWithEmailByUserCompanyIdDropDownList($input);
echo $contactsFullNameWithEmailByUserCompanyIdDropDownList;

}

