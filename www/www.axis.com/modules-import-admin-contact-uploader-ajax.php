<?php
/**
 * Ajax file uploader.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');
// LOGGING UPLOAD TIME TO THE BACKEND FILE DATABASE
$timer->startTimer();
$_SESSION['timer'] = $timer;

require_once 'PHPClasses/PHPExcel/IOFactory.php';

// MESSAGING VARIABLES
require_once('lib/common/Message.php');
require_once('lib/common/File.php');
require_once('modules-contacts-manager-functions.php');
require_once('lib/common/Validate.php');
require_once('lib/common/Address.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/PhoneNumber.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/Contact.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactToContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/Role.php');

$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);
/* @var $get Egpcs */
$get->sessionClear();
ob_start();
// SESSION VARIABLES
/* @var $session Session */
$session->setFormSubmitted(true);
$ajaxBasedFileUpload = false;
$formBasedFileUpload = false;
$methodCall = $get->method;

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);


// Temp files directive to allow the upload of temp files, but not inject them into the cloud
// $get->method=uploadTempFilesOnly
switch($methodCall) {

	case 'uploadFiles':

	$uploadTempFilesOnly = true;
	// Temp directory prefix to help have a balanced filesystem on the server
	$tempDirectoryPrefix = "$user_company_id/$user_id/$currentlyActiveContactId/";

	$arrFiles = array();

	$arrFiles = File::parseUploadedFiles($tempDirectoryPrefix);

// print_r($arrFiles);
	$arrayFileImport = array();
// $arrUploadedFiles = $arrFiles;
	foreach ($arrFiles as $file) {
		$fileSizePath = $file->tempFilePath;
		$virtual_file_name = urldecode($file->name);
	/*$valid = is_uploaded_file($fileSizePath);
	$objPHPExcel = PHPExcel_IOFactory::load($fileSizePath);
	$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
	$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	$arrayCount = count($allDataInSheet); 
	print_r($allDataInSheet);
	$objWorksheet = $objPHPExcel->setActiveSheetIndex(1);
	$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	$arrayCount = count($allDataInSheet); 
	print_r($allDataInSheet);
	$objWorksheet = $objPHPExcel->setActiveSheetIndex(2);
	$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	$arrayCount = count($allDataInSheet); 
	print_r($allDataInSheet);*/
		// Here get total count of row in that Excel sheet
}
$liUploadedFieldReports .= <<<END_LI_UPLOADED_FIELD_REPORTS
<li>
<a onclick="deleteFile('defaultTemplate');" class="ExcelLiRemove">X</a>
$virtual_file_name
</li>
END_LI_UPLOADED_FIELD_REPORTS;
$arrayFileImport = array(
	'virtualFileName' => $virtual_file_name,
	'virtualFilePath' => $fileSizePath,
	'liData' => $liUploadedFieldReports
);
$errorMessage = 'File upload successfully';
$message->enqueueError($errorMessage, $currentPhpScript);
$arrJsonOutput = array(
	'success' => $errorMessage,
	'fileMetadata' => $arrayFileImport
);
echo $arrJsonOutput = json_encode($arrJsonOutput);
exit(0);
break;

case 'deleteFile':
try{
	$deletePath = $get->filePath;
	unlink($deletePath);
}
catch(Exception $e){
	// Be sure to get the exception error message when Global Admin debug mode.
	$message->outputErrorMessages();
	exit;
}
break;

case 'checkDataAnyExist':
$errorNumber = 0;
$errorMessage = '';
$contactCompanyId = '';
$filePath = $get->filePath;
$JsonValid = 0;
try{
	$valid = file_exists($filePath);
	if($valid){
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->throwExceptionOnDbError = true;
		$message->reset($currentPhpScript);
		$contactCompany = new ContactCompany($database);

		$objPHPExcel = PHPExcel_IOFactory::load($filePath);
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
		$companyAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($companyAllDataInSheet); 
		$companyArray = array();
		$companyTableData ="<table cellpadding='5' class='content cell-border tableborder companyImport' width='100%'>";
		$companyTableDataIn = 1;
		/*Company information*/
		for($companyi = 3; $companyi <= $arrayCount; $companyi++){
			$tableYes = 0;
			$company = $primary_phone_number = $identify_no = $license_no = $date = '' ;
			$implode_data = implode('',$companyAllDataInSheet[$companyi]);
			if($implode_data==''){
				continue;
			}
			if(trim($companyAllDataInSheet[$companyi]["A"])!=''){
				$indexCom = $companyAllDataInSheet[$companyi]["A"];
				$company = $companyArray[$indexCom]['company'] = $companyAllDataInSheet[$companyi]["A"];
			}
			if(trim($companyAllDataInSheet[$companyi]["B"])!=''){
				$primary_phone_number = $companyAllDataInSheet[$companyi]["B"];
					// $primary_phone_number = Data::parseDigits($primary_phone_number);
				$companyArray[$indexCom]['primary_phone_number'] = $primary_phone_number;
			}
			if(trim($companyAllDataInSheet[$companyi]["C"])!=''){
				$identify_no = $companyArray[$indexCom]['employer_identification_number'] = $companyAllDataInSheet[$companyi]["C"];
			}
			if(trim($companyAllDataInSheet[$companyi]["D"])!=''){
				$license_no = $companyArray[$indexCom]['construction_license_number'] = $companyAllDataInSheet[$companyi]["D"];
			}
			if(trim($companyAllDataInSheet[$companyi]["E"])!=''){
				$date = $companyArray[$indexCom]['construction_license_number_expiration_date'] = $companyAllDataInSheet[$companyi]["E"];
			}
			$contactCompany->setData($companyArray[$indexCom]);
			$contactCompany->convertDataToProperties();
			$contactCompany->user_user_company_id = $user_company_id;
			$contactCompany->convertPropertiesToData();
			$data = $contactCompany->getData();
				// Test for existence via standard findByUniqueIndex method
			$contactCompany->findByUniqueIndex();
			$cc = contactCompany::verifyContactCompanyExists($databse, '', $user_company_id, $indexCom);
				// var_dump($cc);

			if ($cc!='') {
				$tableYes = 1;
				$errorMessage = 'Contact Company already exists.';
					// $message->enqueueError($errorMessage, $currentPhpScript);
					// $primaryKeyAsString = $contactCompany->getPrimaryKeyAsString();
				$companyArray[$indexCom]['exists'] = 1;
				$companyArray[$indexCom]['contact_company_id'] = $cc;
					// throw new Exception($errorMessage);
			}else{
				$tableYes = 1;
				$companyArray[$indexCom]['exists'] = 0;
				$companyArray[$indexCom]['contact_company_id'] = '';
			}
			if($tableYes == 1){
				if($companyTableDataIn == 1)
				{
					$companyTableData.="<thead class='borderBottom'><tr class='table-headerinner'><th colspan='5' class='textAlignLeft'>Company Information</th></tr><tr align='left'><th>Company</th><th>Primary Phone Number</th><th>Federal Tax Id</th><th>License Number</th><th>License Expiration Date</th></tr></thead>";
				}
				$companyTableDataIn++;
				$span = "<span class='circleBlack floadCircle'></span>";
				if($company == ''){
					$JsonValid = 1;
					$span = "<span class='circleRed floadCircle'></span>";
				}
				$companyTableData.="<tr><td>$company $span</span></td><td>$primary_phone_number</td><td>$identify_no</td><td>$license_no</td><td>$date</td></tr>";
			}
		}
		$companyTableData .="</table>";
		// print_r($companyArray);
		/*Office Information*/
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(1);
		$officeAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($officeAllDataInSheet); 
		$officeArray = array();
		$inVal = 0;
		$officeTableData ="<table cellpadding='5' class='content cell-border tableborder companyImport' width='100%'>";
		$officeTableDataIn = 1;
		$contactCompanyOffice = new ContactCompanyOffice($database);
		for($officei = 3; $officei <= $arrayCount; $officei++){
			$company = $head_quarters = $nick_name = $address_line_1 = $address_city = $region = $postal_code = $bussines_phone = $bussines_fax = "";

			$tableYes = 0;
			$implode_data = implode('',$officeAllDataInSheet[$officei]);
			if($implode_data==''){
				continue;
			}
				// $indexOff = $officeAllDataInSheet[$officei]["A"];
			$company = $officeAllDataInSheet[$officei]["A"];
			$indexOff = $officeAllDataInSheet[$officei]["D"].' '.$company;
			if(trim($officeAllDataInSheet[$officei]["A"])!=''){
				$company = $officeArray[$indexOff]['company'] = $officeAllDataInSheet[$officei]["A"];
			}
			if(trim($officeAllDataInSheet[$officei]["B"])!=''){
				$head_quarters = $officeArray[$indexOff]['head_quarters_flag'] = $officeAllDataInSheet[$officei]["B"];
			}
			if(trim($officeAllDataInSheet[$officei]["C"])!=''){
				$nick_name = $officeArray[$indexOff]['office_nickname'] = $officeAllDataInSheet[$officei]["C"];
			}
			if(trim($officeAllDataInSheet[$officei]["D"])!=''){
				$address_line_1 = $officeArray[$indexOff]['address_line_1'] = $officeAllDataInSheet[$officei]["D"];
			}
			if(trim($officeAllDataInSheet[$officei]["E"])!=''){
				$address_city = $officeArray[$indexOff]['address_city'] = $officeAllDataInSheet[$officei]["E"];
			}
			if(trim($officeAllDataInSheet[$officei]["F"])!=''){
				$region = $officeArray[$indexOff]['address_state_or_region'] = $officeAllDataInSheet[$officei]["F"];
			}
			if(trim($officeAllDataInSheet[$officei]["G"])!=''){
				$postal_code = $officeArray[$indexOff]['address_postal_code'] = $officeAllDataInSheet[$officei]["G"];
			}
			if(trim($officeAllDataInSheet[$officei]["H"])!=''){					
				$bussines_phone = $officeAllDataInSheet[$officei]["H"];
					// $bussines_phone = Data::parseDigits($bussines_phone);
				$officeArray[$indexOff]['bussines_phone'] = $bussines_phone;
					// $officeArray[$indexOff]['business_phone'] = $officeAllDataInSheet[$officei]["H"];
			}
			if(trim($officeAllDataInSheet[$officei]["I"])!=''){
				$bussines_fax = $officeAllDataInSheet[$officei]["I"];
					// $bussines_fax = Data::parseDigits($bussines_fax);
				$officeArray[$indexOff]['business_fax'] = $bussines_fax;
					// $officeArray[$indexOff]['business_fax'] = $officeAllDataInSheet[$officei]["I"];
			}
			$officeArray[$indexOff]['contact_company_id'] = $companyArray[$company]['contact_company_id'];
			$contactCompanyId = $companyArray[$company]['contact_company_id'];

			$contactCompanyOffice->setData($officeArray[$indexOff]);
			$contactCompanyOffice->convertDataToProperties();
			$contactCompanyOffice->convertPropertiesToData();
			$data = $contactCompanyOffice->getData();
				// print_r($data);
				// Test for existence via standard findByUniqueIndex method
			$contactCompanyOffice->findByUniqueIndex();
			$cco = contactCompanyOffice::verifyContactCompanyOfficeUsingContactCompanyId($database, $contactCompanyId, $address_city, $address_line_1);
				// var_dump($cco);
			if ($cco!='') {
				$tableYes = 1;
				// Error code here
				$errorMessage = 'Contact Company Office already exists.';
				$officeArray[$indexOff]['exists'] = 1;
				$officeArray[$indexOff]['contact_company_office_id'] = $cco;
					// $message->enqueueError($errorMessage, $currentPhpScript);
					// $primaryKeyAsString = $contactCompanyOffice->getPrimaryKeyAsString();
					// throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				if($company == ''){
					$tableYes = 1;
					$JsonValid .= 1;
				}
				$officeArray[$indexOff]['exists'] = 0;
				$officeArray[$indexOff]['contact_company_office_id'] = '';
			}
			if($tableYes == 1){
				$span = '';
				$spanAD = '';
				$spanCity = '';
				if($officeTableDataIn == 1)
				{
					$officeTableData.="<thead class='borderBottom'><tr class='table-headerinner'><th colspan='9' class='textAlignLeft'>Office</th></tr><tr align='left'><th>Company</th><th>Head Quaters</th><th>Office Nickname</th><th>Address</th><th>City</th><th>State</th><th>Zipcode</th><th>Business Phone</td><td>Business Fax</td></tr></thead>";	
				}
				$officeTableDataIn++;
						// $span = "<span class='circleBlack floadCircle'></span>";
				if($company == ''){
					$span = "<span class='circleRed floadCircle'></span>";
				}
				if($address_line_1==''){
					$JsonValid .= 1;
					$spanAD = "<span class='circleRed floadCircle'></span>";
				}
				if($address_city==''){
					$JsonValid .= 1;
					$spanCity = "<span class='circleRed floadCircle'></span>";
				}
				if($cco!=''){
					$spanAD = $spanCity = "<span class='circleBlack floadCircle'></span>";
				}
				$officeTableData .="<tr><td>$company $span</td><td>$head_quarters</td><td>$nick_name</td><td>$address_line_1 $spanAD</td><td>$address_city $spanCity</td><td>$region</td><td>$postal_code</td><td>$bussines_phone</td><td>$bussines_fax</td></tr>";
			}
			$inVal++;
			// }
		}
		$officeTableData .="</table>";
		// print_r($officeArray);
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(2);
		$contactAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($contactAllDataInSheet); 
		$contactArray = array();
		$inCon = 0;
		$contactTableData ="<table cellpadding='5' class='content cell-border tableborder companyImport' width='100%'>";
		$contactTableDataIn = 1;
		$contact = new Contact($database);
		for($contacti = 3; $contacti <= $arrayCount; $contacti++){
			$company = $first_name = $last_name = $email = $span = $title = $primary_office = $mobilephone = $phone = $fax = '';
			$company = $contactAllDataInSheet[$contacti]["A"];
			// $company = $contactAllDataInSheet[$contacti]["A"];
			if(trim($contactAllDataInSheet[$contacti]["F"])!=''){
				$indexCon = $contactAllDataInSheet[$contacti]["F"].' '.$company;
			}
			else{
				$indexCon = $company;	
			}
			$implode_data = implode('',$contactAllDataInSheet[$contacti]);
			if($implode_data==''){
				continue;
			}
			if(trim($contactAllDataInSheet[$contacti]["A"])!=''){
				$company = $contactArray[$indexCon][$inCon]['company'] = $contactAllDataInSheet[$contacti]["A"];
			}
			if(trim($contactAllDataInSheet[$contacti]["B"])!=''){
				$first_name = $contactArray[$indexCon][$inCon]['first_name'] = $contactAllDataInSheet[$contacti]["B"];
			}
			if(trim($contactAllDataInSheet[$contacti]["C"])!=''){
				$last_name = $contactArray[$indexCon][$inCon]['last_name'] = $contactAllDataInSheet[$contacti]["C"];
			}
			if(trim($contactAllDataInSheet[$contacti]["D"])!=''){
				$email = $contactArray[$indexCon][$inCon]['email'] = $contactAllDataInSheet[$contacti]["D"];
			}
			if(trim($contactAllDataInSheet[$contacti]["E"])!=''){
				$title = $contactArray[$indexCon][$inCon]['title'] = $contactAllDataInSheet[$contacti]["E"];
			}
			if(trim($contactAllDataInSheet[$contacti]["F"])!=''){
				$primary_office = $contactArray[$indexCon][$inCon]['primary_office'] = $contactAllDataInSheet[$contacti]["F"];
			}
			if(trim($contactAllDataInSheet[$contacti]["G"])!=''){
				$mobilephone = $contactArray[$indexCon][$inCon]['mobilephone'] = $contactAllDataInSheet[$contacti]["G"];
			}
			if(trim($contactAllDataInSheet[$contacti]["H"])!=''){
				$phone = $contactArray[$indexCon][$inCon]['phone'] = $contactAllDataInSheet[$contacti]["H"];
			}
			if(trim($contactAllDataInSheet[$contacti]["I"])!=''){
				$fax = $contactArray[$indexCon][$inCon]['fax'] = $contactAllDataInSheet[$contacti]["I"];
			}
			if($company != $indexCon){
				$contactCompanyId = $contactArray[$indexCon][$inCon]['contact_company_id'] =$officeArray[$indexCon]['contact_company_id'];
				$contactArray[$indexCon][$inCon]['contact_company_office_id'] = $officeArray[$indexCon]['contact_company_office_id'];
			}else{
				$contactCompanyId = $contactArray[$indexCon][$inCon]['contact_company_id'] =$companyArray[$indexCon]['contact_company_id'];
				$contactArray[$indexCon][$inCon]['contact_company_office_id'] = '';
			}

			$contact->setData($contactArray[$indexCon][$inCon]);
			$contact->convertDataToProperties();
			$newValue = $contactArray[$indexCon][$inCon]['email'];
			$validEmailFlag = Validate::email2($newValue);
			if(!$validEmailFlag)
			{
				$JsonValid .= 1;
				$errorNumber = 1;
				$errorMessage = "Invalid Email Address";
				$contactArray[$indexCon][$inCon]['invalid_email'] = 1;
				// $message->enqueueError($errorMessage, $currentPhpScript);
				// throw new Exception($errorMessage);
			}else
			{
				$errorNumber = 0;
				$errorMessage = "";
				$contactArray[$indexCon][$inCon]['invalid_email'] = 0;
			}
			$contact->convertPropertiesToData();
			$data = $contact->getData();
			$contact->findByUniqueIndex();
			$span='';
			$ce = contact::verifyEmailUsingEnteredEmail($database, $contactCompanyId, $newValue);
			$tableYes = 0;
			if ($ce!='' || $contactArray[$indexCon][$inCon]['invalid_email'] == 1) {
				$tableYes = 1;
				$contactArray[$indexCon][$inCon]['contact_id'] = $ce;
			}else{
				if($company == ''){
					$JsonValid .= 1;
					$tableYes = 1;
				}
				$contactArray[$indexCon][$inCon]['contact_id'] = '';
			}
			if($tableYes == 1){
				$span = '';
				$spanCom = '';
				$spanCity = '';
				if($contactTableDataIn == 1)
				{
					$contactTableData.="<thead class='borderBottom'><tr class='table-headerinner'><th colspan='9' class='textAlignLeft'>Contact</th></tr><tr align='left'><th>Company</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Title</th><th>Primary Office</th><th>Mobilephone </th><th>Business Phone</td><td>Business Fax</td></tr></thead>";	
				}
						// $span = "<span class='circleBlack floadCircle'></span>";
				if($company == ''){
					$spanCom = "<span class='circleRed floadCircle'></span>";
				}
				if($ce != ''){
					$span = "<span class='circleBlack floadCircle'></span>";
				}
				if($contactArray[$indexCon][$inCon]['invalid_email'] == 1){
					$span .= "<span class='circleRed floadCircle'></span><span class='circleRed floadCircle'></span>";
				}
				if($email == '')
				{
					$span = "<span class='circleRed floadCircle'></span>";
				}
				$contactTableDataIn++;
				$contactTableData .="<tr><td>$company $spanCom</td><td>$first_name</td><td>$last_name</td><td>$email $span</td><td>$title</td><td>$primary_office</td><td>$mobilephone</td><td>$phone</td><td>$fax</td></tr>";
			}
			$inCon++;
		}
		$contactTableData .="</table>";
		// $table = "<div class='errorCode'><span class='alreadyExist'>( <div class='circleBlack'></div> ) - Data Already Exist.</span><span class='alreadyExist'>( <div class='circleRed'></div> ) - Data is Mandatory.</span><span class='alreadyExist'>( <div class='circleRed'></div>&nbsp;<div class='circleRed'></div> ) - Invalid Data.</span> </div>";
		$table .= $companyTableData.$officeTableData.$contactTableData;
		$table;
		$json_encode = array(
			'data' => $table,
			'invalid' => $JsonValid
		);
		echo json_encode($json_encode);
		// print_r($contactArray);
	}else{
		$errorNumber = 1;
		$errorMessage = 'File not exists';
		$message->enqueueError($errorMessage, $currentPhpScript);
	}
} catch(Exception $e){
	$errorNumber = 1;
}
break;
case 'confirmDefaultTemplate':
$errorNumber = 0;
$errorMessage = '';
$contactCompanyId = '';
$filePath = $get->filePath;
try{
	$valid = file_exists($filePath);
	if($valid){
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->throwExceptionOnDbError = true;
		$message->reset($currentPhpScript);

		$objPHPExcel = PHPExcel_IOFactory::load($filePath);
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
		$companyAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($companyAllDataInSheet); 
		$companyArray = array();
		$companyTableData ="<table cellpadding='5' class='content cell-border tableborder companyImport' width='100%'>";
		$companyTableDataIn = 1;
		/*Company information*/
		// echo '<pre>';
		for($companyi = 3; $companyi <= $arrayCount; $companyi++){
			$contactCompany = new ContactCompany($database);
			$company = $primary_phone_number = $identify_no = $license_no = $date = '' ;
			$implode_data = implode('',$companyAllDataInSheet[$companyi]);
			if($implode_data==''){
				continue;
			}
			if(trim($companyAllDataInSheet[$companyi]["A"])!=''){
				$indexCom = $companyAllDataInSheet[$companyi]["A"];
				$company = $companyArray[$indexCom]['company'] = $companyAllDataInSheet[$companyi]["A"];
			}
			if(trim($companyAllDataInSheet[$companyi]["B"])!=''){
				$primary_phone_number = $companyAllDataInSheet[$companyi]["B"];
				$primary_phone_number = Data::parseDigits($primary_phone_number);
				$companyArray[$indexCom]['primary_phone_number'] = $primary_phone_number;
			}
			if(trim($companyAllDataInSheet[$companyi]["C"])!=''){
				$identify_no = $companyArray[$indexCom]['employer_identification_number'] = $companyAllDataInSheet[$companyi]["C"];
			}
			if(trim($companyAllDataInSheet[$companyi]["D"])!=''){
				$license_no = $companyArray[$indexCom]['construction_license_number'] = $companyAllDataInSheet[$companyi]["D"];
			}
			if(trim($companyAllDataInSheet[$companyi]["E"])!=''){
				$date = $companyArray[$indexCom]['construction_license_number_expiration_date'] = $companyAllDataInSheet[$companyi]["E"];
				$begindate = DateTime::createFromFormat('m/d/Y', $date);
				$companyArray[$indexCom]['construction_license_number_expiration_date'] = $begindate->format('Y-m-d');
			}
			$contactCompany->setData($companyArray[$indexCom]);
			$contactCompany->convertDataToProperties();
			$contactCompany->user_user_company_id = $user_company_id;
			$contactCompany->convertPropertiesToData();
			$data = $contactCompany->getData();
				// Test for existence via standard findByUniqueIndex method
			$contactCompany->findByUniqueIndex();
			$cc = contactCompany::verifyContactCompanyExists($databse, '', $user_company_id, $indexCom);
				// var_dump($cc);

			if ($cc!='') {
				if($companyTableDataIn == 1)
				{
					$companyTableData.="<thead class='borderBottom'><tr class='table-headerinner'><th colspan='5' class='textAlignLeft'>Company Information</th></tr><tr align='left'><th>Company</th><th>Primary Phone Number</th><th>Federal Tax Id</th><th>License Number</th><th>License Expiration Date</th></tr></thead>";
				}
				$companyTableDataIn++;
				$span = "<span class='circleBlack floadCircle'></span>";
				if($company == ''){
					$span = "<span class='circleRed floadCircle'></span>";
				}
				$companyTableData.="<tr><td>$company $span</span></td><td>$primary_phone_number</td><td>$identify_no</td><td>$license_no</td><td>$date</td></tr>";

				$errorMessage = 'Contact Company already exists.';
					// $message->enqueueError($errorMessage, $currentPhpScript);
					// $primaryKeyAsString = $contactCompany->getPrimaryKeyAsString();
				$companyArray[$indexCom]['exists'] = 1;
				$companyArray[$indexCom]['contact_company_id'] = $cc;
				$contactCompany = ContactCompany::findById($database, $cc);
				if ($contactCompany) {
					$existingData = $contactCompany->getData();
					$httpGetInputData = $data;
					// print_r($existingData);
					// print_r($httpGetInputData);
					// Check if unique attribute
					$arrUniqueness = array(
							//'user_user_company_id' => 'int',
						'company' => 'Company Name',
						'employer_identification_number' => 'Fed Tax ID',
					);
					$arrLabels = $arrUniqueness;
					$key = array();
					foreach($data as $k => $v) {
						if (isset($arrUniqueness[$k])) {
							$key[$k] = $v;
							unset($arrUniqueness[$k]);
						}
					}

					if (!empty($key)) {
						$potentialDuplicateData = $key;
							// Lookup by unique attributes
						foreach ($arrUniqueness as $k => $v) {
							$existingValue = $existingData[$k];
							$key[$k] = $existingValue;
						}

						$httpGetInputData['contact_user_company_id'] = $existingData['contact_user_company_id'];
					}
					$contactCompany->setData($httpGetInputData);
					$contactCompany->convertDataToProperties();
					$contactCompany->convertPropertiesToData();

					$newData = $contactCompany->getData();
					$data = Data::deltify($existingData, $newData);
					if(!empty($data)){
						$contactCompany->setData($data);
						$save = true;
						$contactCompany->save();
						if ($contactCompany->user_user_company_id == $contactCompany->contact_user_company_id) {
							$userCompany = UserCompany::findById($database, $contactCompany->user_user_company_id);
							/* @var $userCompany UserCompany */
							$existingUserCompanyData = $userCompany->getData();
							$changedContactCompanyData = $data;
							$changedUserCompanyData = Data::deltify($existingUserCompanyData, $changedContactCompanyData);
							$userCompany->setData($changedUserCompanyData);
							$userCompany->save();
						}
						$db->commit();
					}
					// throw new Exception($errorMessage);
				}
			}else{
				$contactCompany->setKey(null);
				$contactCompany->setData($data);
				// print_r($data);
				$contact_company_office_id = $contactCompany->save();
				// if (isset($contact_company_office_id) && !empty($contact_company_office_id)) {
				// 	$contactCompanyOffice->contact_company_office_id = $contact_company_office_id;
				// 	$contactCompanyOffice->setId($contact_company_office_id);
				// }

				$companyArray[$indexCom]['exists'] = 0;
				$companyArray[$indexCom]['contact_company_id'] = $contact_company_office_id;
			}
		}
		$companyTableData .="</table>";
		// print_r($companyArray);
		/*Office Information*/
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(1);
		$officeAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($officeAllDataInSheet); 
		$officeArray = array();
		$inVal = 0;
		$officeTableData ="<table cellpadding='5' class='content cell-border tableborder companyImport' width='100%'>";
		$officeTableDataIn = 1;
		for($officei = 3; $officei <= $arrayCount; $officei++){
			$company = $head_quarters = $nick_name = $address_line_1 = $address_city = $region = $postal_code = $bussines_phone = $bussines_fax = "";
			$contactCompanyOffice = new ContactCompanyOffice($database);
			$implode_data = implode('',$officeAllDataInSheet[$officei]);
			if($implode_data==''){
				continue;
			}
			if(trim($officeAllDataInSheet[$officei]["A"])!=''){
				// $indexOff = $officeAllDataInSheet[$officei]["A"];
				$company = $officeAllDataInSheet[$officei]["A"];
				$indexOff = $officeAllDataInSheet[$officei]["D"].' '.$company;
				if(trim($officeAllDataInSheet[$officei]["B"])!=''){
					$head_quarters = $officeArray[$indexOff]['head_quarters_flag'] = $officeAllDataInSheet[$officei]["B"];
				}
				if(trim($officeAllDataInSheet[$officei]["C"])!=''){
					$nick_name = $officeArray[$indexOff]['office_nickname'] = $officeAllDataInSheet[$officei]["C"];
				}
				if(trim($officeAllDataInSheet[$officei]["D"])!=''){
					$address_line_1 = $officeArray[$indexOff]['address_line_1'] = $officeAllDataInSheet[$officei]["D"];
				}
				if(trim($officeAllDataInSheet[$officei]["E"])!=''){
					$address_city = $officeArray[$indexOff]['address_city'] = $officeAllDataInSheet[$officei]["E"];
				}
				if(trim($officeAllDataInSheet[$officei]["F"])!=''){
					$region = $officeArray[$indexOff]['address_state_or_region'] = $officeAllDataInSheet[$officei]["F"];
				}
				if(trim($officeAllDataInSheet[$officei]["G"])!=''){
					$postal_code = $officeArray[$indexOff]['address_postal_code'] = $officeAllDataInSheet[$officei]["G"];
				}
				if(trim($officeAllDataInSheet[$officei]["H"])!=''){					
					$bussines_phone = $officeAllDataInSheet[$officei]["H"];
					// $bussines_phone = Data::parseDigits($bussines_phone);
					$officeArray[$indexOff]['bussines_phone'] = $bussines_phone;
					// $officeArray[$indexOff]['business_phone'] = $officeAllDataInSheet[$officei]["H"];
				}
				if(trim($officeAllDataInSheet[$officei]["I"])!=''){
					$bussines_fax = $officeAllDataInSheet[$officei]["I"];
					// $bussines_fax = Data::parseDigits($bussines_fax);
					$officeArray[$indexOff]['business_fax'] = $bussines_fax;
					// $officeArray[$indexOff]['business_fax'] = $officeAllDataInSheet[$officei]["I"];
				}
				$officeArray[$indexOff]['contact_company_id'] = $companyArray[$company]['contact_company_id'];
				$contactCompanyId = $companyArray[$company]['contact_company_id'];

				$contactCompanyOffice->setData($officeArray[$indexOff]);
				$contactCompanyOffice->convertDataToProperties();
				$contactCompanyOffice->convertPropertiesToData();
				$data = $contactCompanyOffice->getData();
				// print_r($data);
				// Test for existence via standard findByUniqueIndex method
				$contactCompanyOffice->findByUniqueIndex();
				$cco = contactCompanyOffice::verifyContactCompanyOfficeUsingContactCompanyId($database, $contactCompanyId, $address_city, $address_line_1);
				// var_dump($cco);
				if ($cco!='') {
					if($officeTableDataIn == 1)
					{
						$officeTableData.="<thead class='borderBottom'><tr class='table-headerinner'><th colspan='9' class='textAlignLeft'>Office</th></tr><tr align='left'><th>Company</th><th>Head Quaters</th><th>Office Nickname</th><th>Address</th><th>City</th><th>State</th><th>Zipcode</th><th>Business Phone</td><td>Business Fax</td></tr></thead>";	
					}
					$officeTableDataIn++;
					$officeTableData .="<tr><td>$company</td><td>$head_quarters</td><td>$nick_name</td><td>$address_line_1<span class='circleBlack floadCircle'></span></td><td>$address_city<span class='circleBlack floadCircle'></span></td><td>$region</td><td>$postal_code</td><td>$bussines_phone</td><td>$bussines_fax</td></tr>";
				// Error code here
					$errorMessage = 'Contact Company Office already exists.';
					$officeArray[$indexOff]['exists'] = 1;
					$officeArray[$indexOff]['contact_company_office_id'] = $cco;
					/*update contact office*/
					$contactCompanyOffice = ContactCompanyOffice::findById($database, $cco);
					$existingData = $contactCompanyOffice->getData();
					// Retrieve all of the $_GET inputs automatically for the ContactCompanyOffice record
					$httpGetInputData = $data;
					$contactCompanyOffice->setData($httpGetInputData);
					$contactCompanyOffice->convertDataToProperties();
					$contactCompanyOffice->convertPropertiesToData();

					$newData = $contactCompanyOffice->getData();
					$data = Data::deltify($existingData, $newData);
					// print_r($existingData);
					// print_r($httpGetInputData);
					// print_r($data);
					if (!empty($data)) {
						$contactCompanyOffice->setData($data);
						$save = true;
						$contactCompanyOffice->save();
					}
					/*business mobile import*/
					mobilePhoneImportByContactIdOffice($database, $cco, $data, $bussines_phone, 'business');
					/*business fax import*/
					mobilePhoneImportByContactIdOffice($database, $cco, $data, $bussines_fax, 'fax');
				//exit;
				} else {
					$contactCompanyOffice->setKey(null);
					$contactCompanyOffice->setData($data);
					$contact_company_office_id = $contactCompanyOffice->save();
					$officeArray[$indexOff]['exists'] = 0;
					$officeArray[$indexOff]['contact_company_office_id'] = $contact_company_office_id;
				}
				$inVal++;
			}
		}
		$officeTableData .="</table>";
		// print_r($officeArray);
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(2);
		$contactAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$arrayCount = count($contactAllDataInSheet); 
		$contactArray = array();
		$inCon = 0;
		$contactTableData ="<table cellpadding='5' class='content cell-border tableborder companyImport' width='100%'>";
		$contactTableDataIn = 1;
		for($contacti = 3; $contacti <= $arrayCount; $contacti++){
			$company = $first_name = $last_name = $email = $span = $title = $primary_office = $mobilephone = $phone = $fax = '';
			$contact = new Contact($database);
			$implode_data = implode('',$contactAllDataInSheet[$contacti]);
			if($implode_data==''){
				continue;
			}
			$company = $contactAllDataInSheet[$contacti]["A"];
			if(trim($contactAllDataInSheet[$contacti]["F"])!=''){
				$indexCon = $contactAllDataInSheet[$contacti]["F"].' '.$company;
			}
			else{
				$indexCon = $company;	
			}
			// $indexCon = $contactAllDataInSheet[$contacti]["F"].' '.$company;
			if(trim($contactAllDataInSheet[$contacti]["A"])!=''){
				$company = $contactArray[$indexCon][$inCon]['company'] = $contactAllDataInSheet[$contacti]["A"];
			}
			if(trim($contactAllDataInSheet[$contacti]["B"])!=''){
				$first_name = $contactArray[$indexCon][$inCon]['first_name'] = $contactAllDataInSheet[$contacti]["B"];
			}
			if(trim($contactAllDataInSheet[$contacti]["C"])!=''){
				$last_name = $contactArray[$indexCon][$inCon]['last_name'] = $contactAllDataInSheet[$contacti]["C"];
			}
			if(trim($contactAllDataInSheet[$contacti]["D"])!=''){
				$email = $contactArray[$indexCon][$inCon]['email'] = $contactAllDataInSheet[$contacti]["D"];
			}
			if(trim($contactAllDataInSheet[$contacti]["E"])!=''){
				$title = $contactArray[$indexCon][$inCon]['title'] = $contactAllDataInSheet[$contacti]["E"];
			}
			if(trim($contactAllDataInSheet[$contacti]["F"])!=''){
				$primary_office = $contactArray[$indexCon][$inCon]['primary_office'] = $contactAllDataInSheet[$contacti]["F"];
			}
			if(trim($contactAllDataInSheet[$contacti]["G"])!=''){
				$mobilephone = $contactArray[$indexCon][$inCon]['mobilephone'] = $contactAllDataInSheet[$contacti]["G"];
			}
			if(trim($contactAllDataInSheet[$contacti]["H"])!=''){
				$phone = $contactArray[$indexCon][$inCon]['phone'] = $contactAllDataInSheet[$contacti]["H"];
			}
			if(trim($contactAllDataInSheet[$contacti]["I"])!=''){
				$fax = $contactArray[$indexCon][$inCon]['fax'] = $contactAllDataInSheet[$contacti]["I"];
			}
			
			if($company != $indexCon){
				$contactCompanyId = $contactArray[$indexCon][$inCon]['contact_company_id'] =$officeArray[$indexCon]['contact_company_id'];
				$contactArray[$indexCon][$inCon]['contact_company_office_id'] = $officeArray[$indexCon]['contact_company_office_id'];
			}else{
				$contactCompanyId = $contactArray[$indexCon][$inCon]['contact_company_id'] =$companyArray[$indexCon]['contact_company_id'];
				$contactArray[$indexCon][$inCon]['contact_company_office_id'] = '';
			}
			$contactArray[$indexCon][$inCon]['user_id'] = 1;
			$contactArray[$indexCon][$inCon]['user_company_id'] = $user_company_id;

			$contact->setData($contactArray[$indexCon][$inCon]);
			$contact->convertDataToProperties();
			$newValue = $contactArray[$indexCon][$inCon]['email'];
			$validEmailFlag = Validate::email2($newValue);
			if(!$validEmailFlag)
			{
				$errorNumber = 1;
				$errorMessage = "Invalid Email Address";
				$contactArray[$indexCon][$inCon]['invalid_email'] = 1;
				// $message->enqueueError($errorMessage, $currentPhpScript);
				// throw new Exception($errorMessage);
			}else
			{
				$errorNumber = 0;
				$errorMessage = "";
				$contactArray[$indexCon][$inCon]['invalid_email'] = 0;
			}
			$contact->convertPropertiesToData();
			$data = $contact->getData();
			$contact->findByUniqueIndex();
			$span='';
			$ce = contact::verifyEmailUsingEnteredEmail($database, $contactCompanyId, $newValue);
			if ($ce!='' || $contactArray[$indexCon][$inCon]['invalid_email'] == 1) {
				if($contactTableDataIn == 1)
				{
					$contactTableData.="<thead class='borderBottom'><tr class='table-headerinner'><th colspan='9' class='textAlignLeft'>Contact</th></tr><tr align='left'><th>Company</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Title</th><th>Primary Office</th><th>Mobilephone </th><th>Business Phone</td><td>Business Fax</td></tr></thead>";	
				}
				if($ce!=''){
					$span .= "<span class='circleBlack floadCircle'></span>";
				}
				if($contactArray[$indexCon][$inCon]['invalid_email'] == 1){
					$span .= "<span class='circleRed floadCircle'></span><span class='circleRed floadCircle'></span>";
				}
				$contactTableDataIn++;
				$contactTableData .="<tr><td>$company</td><td>$first_name</td><td>$last_name</td><td>$email $span</td><td>$title</td><td>$primary_office</td><td>$mobilephone</td><td>$phone</td><td>$fax</td></tr>";
				$contact_id = $contactArray[$indexCon][$inCon]['contact_id'] = $ce;
				// $contact = Contact::findContactById($database, $ce);
				/*mobileno import*/
				mobilePhoneImportByContactId($database, $ce, $data, $mobilephone, 'mobile');
				/*business mobile import*/
				mobilePhoneImportByContactId($database, $ce, $data, $phone, 'business');
				/*business fax import*/
				mobilePhoneImportByContactId($database, $ce, $data, $fax, 'fax');
			}else{
				$contact->setKey(null);
				$contact->setData($data);
				// print_r($data);
				$contact_id = $contact->save();
				$contactArray[$indexCon][$inCon]['contact_id'] = $contact_id;
				/*mobileno import*/
				mobilePhoneImportByContactId($database, $contact_id, $data, $mobilephone, 'mobile');
				/*business mobile import*/
				mobilePhoneImportByContactId($database, $contact_id, $data, $phone, 'business');
				/*business fax import*/
				mobilePhoneImportByContactId($database, $contact_id, $data, $fax, 'fax');
			}
			$inCon++;
		}
		$contactTableData .="</table>";
		// $table = "<div class='errorCode'><span class='alreadyExist'>( <div class='circleBlack'></div> ) - Data Already Exist.</span><span class='alreadyExist'>( <div class='circleRed'></div> ) - Data is Mandatory.</span><span class='alreadyExist'>( <div class='circleRed'></div>&nbsp;<div class='circleRed'></div> ) - Invalid Data.</span> </div>";
		$table .= $companyTableData.$officeTableData.$contactTableData;
		unlink($filePath);
		// echo '<pre>';
		// print_r($contactArray);
	}else{
		echo $errorNumber = 1;
		$errorMessage = 'File not exists';
		$message->enqueueError($errorMessage, $currentPhpScript);
	}
} catch(Exception $e){
	echo $errorNumber = 1;
}
break;

default :
break;
}
