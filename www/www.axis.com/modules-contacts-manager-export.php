<?php
/*Manually increase the execution time for excel generation*/
ini_set('max_execution_time', 600);
ini_set("memory_limit", "1000M");
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
// date_default_timezone_set('Asian/kolkata');
$timezone = date_default_timezone_get();
$dates = date('d-m-Y:h', time());
$datessheet = date('d-m-Y_h', time());
$i=date('i', time());
$s=date('s:a', time());
$ssheet=date('s_a', time());
$a=date('a', time());
$timedate=date('d/m/Y h:i a', time());
$currentdate=date('m/d/Y', time());

require_once('lib/common/init.php');
/*Image resize function*/
require_once('image-resize-functions.php');
/*PHPExcel files*/
require_once 'PHPClasses/PHPExcel/IOFactory.php';
require_once 'PHPClasses/PHPExcel.php';
require_once 'PHPClasses/PHPExcel/Writer/Excel2007.php';

require_once('lib/common/Address.php');
require_once('lib/common/Contact.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/ContactToContactCompanyOffice.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/Date.php');
require_once('lib/common/MessageGateway/Sms.php');
require_once('lib/common/MobileNetworkCarrier.php');
require_once('lib/common/MobilePhoneNumber.php');
require_once('lib/common/PhoneNumber.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/Project.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/Role.php');
require_once('lib/common/UserInvitation.php');
require_once('lib/common/Validate.php');

require_once('./modules-contacts-manager-functions.php');

/*GC logo*/
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset();

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_NON_EXISTENT_PROJECT_TYPE_ID = AXIS_NON_EXISTENT_PROJECT_TYPE_ID;
$AXIS_NON_EXISTENT_USER_COMPANY_ID = AXIS_NON_EXISTENT_USER_COMPANY_ID;

$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

// DATABASE VARIABLES
$db = DBI::getInstance($database);
/* @var $db DBI_mysqli */

/*Get GC image*/
require_once('lib/common/Logo.php');
$gcLogo = Logo::logoByUserCompanyIDUsingSoftlinkPath($database,$user_company_id, true);
$fulcrumLogo = Logo::logoByFulcrumByBasePathOnly();
$gcLogoReal = Logo::logoByUserCompanyIDUsingSoftlinkPath($database,$user_company_id);
/*get the image property*/
$path= realpath($gcLogoReal);
$info   = getimagesize($path);
$mime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
$width  = $info[0]; // width as integer for ex. 512
$height = $info[1]; // height as integer for ex. 384
$type   = $info[2]; // same as exif_imagetype

$fulcrum = $gcLogo;

//Get the session projectid & company id
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();
$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
/* @var $userCompany UserCompany */
$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $session->getUserCompanyId());
$userCompanyName = $userCompany->user_company_name;
$user_company_id = $session->getUserCompanyId();
$type_mention = $userCompanyName."_Contact_Details";
/*Get request variables*/
$contact_company_id = (int) $get->contact_company_id;
$companyName = $get->contact_company_name;

/*Initialize PHPExcel Class*/
$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica')->setSize(10);
$objPHPExcel->getProperties()->setCreator("A.Ganeshkumar");
$objPHPExcel->getProperties()->setLastModifiedBy("Optisol Business Solution & Services");
$objPHPExcel->getProperties()->setTitle("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 Xlsx, generated using PHP classes.");
/*cell text alignment*/
$styleRight = array(
   'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    )
   ); 
$styleLeft = array(
   'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    )
   );
$BStyle = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN,
      'color' => array('rgb' => '2481c3'),
    )
  )
);
$objPHPExcel->setActiveSheetIndex(0);
$alphas = range('A', 'Z');
$alphaCharIn = 0;
$index=1;
/*Company logo */
// require_once("export-contact-company-logo.php");

/*Company Details */
$contactCompany = ContactCompany::findById($database, $contact_company_id);
$arrContactCompanies = array($contact_company_id => $contactCompany);
if (!isset($arrContactCompanies) || empty($arrContactCompanies)) {
	$arrContactCompanies = array();
}
require_once("export-contact-company-details.php");

/*company address*/
$loadContactCompanyOfficesByContactCompanyIdOptions = new Input();
$loadContactCompanyOfficesByContactCompanyIdOptions->forceLoadFlag = true;
$arrContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $contact_company_id, $loadContactCompanyOfficesByContactCompanyIdOptions);
$contactCompany = ContactCompany::findContactCompanyByIdExtended($database, $contact_company_id);
/* @var $contactCompany ContactCompany */
$contact_user_company_id = $contactCompany->contact_user_company_id;
require_once("export-contact-company-offices.php");

/*Company employee contacts*/
$arrContactsByUserCompanyIdAndContactCompanyId = Contact::loadContactsByUserCompanyIdAndContactCompanyId($database, $user_company_id, $contact_company_id, 0);
$arrContacts = $arrContactsByUserCompanyIdAndContactCompanyId;
require_once("export-contact-company-employees.php");

// exit;
$filename = "Contact details -".$dates.":".$i.":".$s.".xlsx";
$filenameSheet = "Contact details";
$objPHPExcel->getActiveSheet()->setTitle($filenameSheet);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;
