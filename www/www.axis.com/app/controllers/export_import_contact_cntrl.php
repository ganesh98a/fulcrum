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
	require_once('lib/common/Address.php');
	require_once('lib/common/Contact.php');

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
	/*GC logo*/
	require_once('lib/common/Message.php');
	require_once('lib/common/ContactCompany.php');
	/*Image resize function*/
	require_once('../../image-resize-functions.php');
	/*PHPExcel files*/
	require_once('../../PHPClasses/PHPExcel/IOFactory.php');
	require_once('../../PHPClasses/PHPExcel.php');
	require_once('../../PHPClasses/PHPExcel/Writer/Excel2007.php');


	require_once('../templates/dropdown_tmp.php');
	require_once('../functions/export_import_contact_func.php');

	require_once('../../modules-contacts-manager-functions.php');

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


	//Get the session projectid & company id
	$user_company_id = $session->getUserCompanyId();
	$user_id = $session->getUserId();
	$userRole = $session->getUserRole();
	$project_id = $session->getCurrentlySelectedProjectId();
	$primary_contact_id = $session->getPrimaryContactId();
	$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();
	$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();


if(!empty($_GET['action']) && $_GET['action'] == 'export_contact'){
	/*Manually increase the execution time for excel generation*/

	ini_set('max_execution_time', 600);
	ini_set("memory_limit", "1000M");

	$timezone = date_default_timezone_get();
	$dates = date('d-m-Y:h', time());
	$datessheet = date('d-m-Y_h', time());
	$i=date('i', time());
	$s=date('s:a', time());
	$ssheet=date('s_a', time());
	$a=date('a', time());
	$timedate=date('d/m/Y h:i a', time());
	$currentdate=date('m/d/Y', time());

	require_once('../../modules-contacts-manager-functions.php');
	
	
	/* @var $userCompany UserCompany */
	$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $session->getUserCompanyId());
	$userCompanyName = $userCompany->user_company_name;
	$type_mention = $userCompanyName."_Contact_Details";
	/*Get request variables*/

	/*Initialize PHPExcel Class*/
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica')->setSize(10);
	$objPHPExcel->getProperties()->setCreator("Raja Manickam S");
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

		

	$contact_company =  $get->selected_companies;
	$export_type = $get->type;
	$contact_company_arr = explode(',',$contact_company);
	$active_index = 0;
	foreach($contact_company_arr as $each_contact_company){
		$contact_company_id = (int) $each_contact_company;

		$objPHPExcel->setActiveSheetIndex($active_index);
		$alphas = range('A', 'Z');
		$alphaCharIn = 0;
		$index=1;

		/*Company Details */
		$contactCompany = ContactCompany::findById($database, $contact_company_id);
		
		$arrContactCompanies = array($contact_company_id => $contactCompany);
		if (!isset($arrContactCompanies) || empty($arrContactCompanies)) {
			$arrContactCompanies = array();
		}else{
			$company_name = $contactCompany->contact_company_name;
			$contact_company_id = $contactCompany->contact_company_id;
		}
		
		if(!empty($export_type) &&  $export_type == 'import_template'){
			$arrContactCompanies_arr = new  ContactCompany($database); 
			$arrContactCompanies_arr->contact_company_id = '';
			$arrContactCompanies_arr->user_user_company_id = '';
			$arrContactCompanies_arr->contact_user_company_id = '';
			$arrContactCompanies_arr->contact_company_name = $company_name;
			$arrContactCompanies_arr->employer_identification_number = 'TC12';
			$arrContactCompanies_arr->construction_license_number = '12EDF';
			$arrContactCompanies_arr->construction_license_number_expiration_date = '12/12/2015';
			$arrContactCompanies_arr->vendor_flag = '';
			$arrContactCompanies_arr->primary_phone_number = '654-897-5648-9612';
			$arrContactCompanies = array($contact_company_id=>$arrContactCompanies_arr);
		}
				
		require("../../export-contact-company-details.php");


		if(!empty($export_type) &&  $export_type == 'import_template'){
			$arrContactCompanyOffices_arr = new  ContactCompanyOffice($database); 
			$arrContactCompanyOffices_arr->contact_company_office_id = '';
			$arrContactCompanyOffices_arr->contact_company_id = '';
			$arrContactCompanyOffices_arr->office_nickname = 'Angeles';
			$arrContactCompanyOffices_arr->address_line_1 = '416 W 8th St';
			$arrContactCompanyOffices_arr->address_city = 'CA';
			$arrContactCompanyOffices_arr->address_state_or_region = 'CA';
			$arrContactCompanyOffices_arr->address_postal_code = '90014';
			$arrContactCompanyOffices_arr->head_quarters_flag = 'Y';
			$arrContactCompanyOffices = array($contact_company_id=>$arrContactCompanyOffices_arr);

		// 				998-798-7987-6547	987-897-9879
		}else{
			/*company address*/
			$loadContactCompanyOfficesByContactCompanyIdOptions = new Input();
			$loadContactCompanyOfficesByContactCompanyIdOptions->forceLoadFlag = true;
			$arrContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $contact_company_id, $loadContactCompanyOfficesByContactCompanyIdOptions);
			$contactCompany = ContactCompany::findContactCompanyByIdExtended($database, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$contact_user_company_id = $contactCompany->contact_user_company_id;
			
		}

		require("../../export-contact-company-offices.php");

		if(!empty($export_type) &&  $export_type == 'import_template'){
			$arrContacts_arr = new  Contact($database); 

			$arrContacts_arr->first_name = 'Test';
			$arrContacts_arr->last_name = 'Test';
			$arrContacts_arr->title = 'Project Manager';
			$arrContacts_arr->email = 'test@gmail.com';

			$arrContacts = array($contact_company_id=>$arrContacts_arr);

		}else{
			/*Company employee contacts*/
			$arrContactsByUserCompanyIdAndContactCompanyId = Contact::loadContactsByUserCompanyIdAndContactCompanyId($database, $user_company_id, $contact_company_id, 0);
			$arrContacts = $arrContactsByUserCompanyIdAndContactCompanyId;
		}


		require("../../export-contact-company-employees.php");
		
		
		$filenameSheet = "Company - ".$contact_company_id;

		if(!empty($company_name)){
			$filenameSheet = $company_name;	
		}
		$filenameSheet = preg_replace("/[^a-zA-Z0-9]+/", "", $filenameSheet);

		$objPHPExcel->getActiveSheet()->setTitle($filenameSheet);
		// Create a new worksheet, after the default sheet
		$active_index++;
		if(count($contact_company_arr) > $active_index){
			$objPHPExcel->createSheet();
		}

	}

	$filename = "Contact details -".$dates.":".$i.":".$s.".xlsx";
	if(!empty($export_type) &&  $export_type == 'import_template'){
		$filename = "My Template.xlsx";
	}
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename='.$filename);
	header('Cache-Control: max-age=0');
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel,'Excel5');
	$objWriter->save('php://output');
	exit;
}else if(!empty($_GET['action']) && $_GET['action'] == 'checkDataAnyExist'){
	$errorNumber = 0;
	$errorMessage = '';
	$contactCompanyId = '';
	$filePath = $get->filePath;
	$JsonValid = 0;
	try{

		$valid = file_exists($filePath);
		
		if($valid){
			// DATABASE VARIABLES
	 		$db = DBI::getInstance($database);
	 		/* @var $db DBI_mysqli */
	 		$db->throwExceptionOnDbError = true;
	 		$message->reset($currentPhpScript);

	 		$contactCompany = new ContactCompany($database);
			$objPHPExcel = PHPExcel_IOFactory::load($filePath);

			$sheetCount = $objPHPExcel->getSheetCount();
			$sheetNames = $objPHPExcel->getSheetNames();

				
			$tempcompanyTableData = $tempofficeTableData = $tempcontactTableData = '';


			foreach(range(1,$sheetCount) as $index) {
				$sheetnum = $index-1;
				$objWorksheet = $objPHPExcel->setActiveSheetIndex($sheetnum);
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$total_data_count = count($allDataInSheet);
				$company_str = $office_str = $contacts_str = 0;
				foreach($allDataInSheet as $eachKey => $eachDataInSheet){
					if($eachDataInSheet['A'] == 'Company Name'){
						$company_str = $eachKey;
					}else if($eachDataInSheet['A'] == 'Headquarters'){
						$office_str = $eachKey;
					}else if($eachDataInSheet['A'] == 'Contact List'){
						$contacts_str = $eachKey;
						$contacts_str += 1;
				        break;
					}
				}
				$company_length = $office_str - $company_str;
				$company_arr = array_slice($allDataInSheet, $company_str, $company_length);
				$companyArray = array();
				$companyTableDataIn = $officeTableDataIn = 0;
				foreach($company_arr as $eachCompany){
					$skip_arr = array("Office List", "Headquarters");
					if (!empty($eachCompany['A']) && !in_array($eachCompany['A'], $skip_arr)) {
						$tableYes = 0;
						$company = $primary_phone_number = $identify_no = $license_no = $date = '' ;

						if(trim($eachCompany["A"]) != ''){
							$indexCom = $eachCompany["A"];
							$company = $companyArray[$indexCom]['company'] = $eachCompany["A"];
						}
						if(trim($eachCompany["B"]) != ''){
							$primary_phone_number = $eachCompany["B"];
							$companyArray[$indexCom]['primary_phone_number'] = $primary_phone_number;
						}
						if(trim($eachCompany["C"]) != ''){
							$identify_no = $companyArray[$indexCom]['employer_identification_number'] = $eachCompany["C"];
						}
						if(trim($eachCompany["D"]) != ''){
							$license_no = $companyArray[$indexCom]['construction_license_number'] = $eachCompany["D"];
						}
						if(trim($eachCompany["E"]) != ''){
							$date = $companyArray[$indexCom]['construction_license_number_expiration_date'] = $eachCompany["E"];
						}

						$contactCompany->setData($companyArray[$indexCom]);
						$contactCompany->convertDataToProperties();
						$contactCompany->user_user_company_id = $user_company_id;
						$contactCompany->convertPropertiesToData();
						$data = $contactCompany->getData();
							// Test for existence via standard findByUniqueIndex method
						$contactCompany->findByUniqueIndex();
						$cc = contactCompany::verifyContactCompanyExists($database, '', $user_company_id, $indexCom);
						if (!empty($cc)) {
							$errorMessage = 'Contact Company already exists.';
							$companyArray[$indexCom]['exists'] = 1;
							$companyArray[$indexCom]['contact_company_id'] = $cc;
						}else{
							$tableYes = 1;
							$companyArray[$indexCom]['exists'] = 0;
							$companyArray[$indexCom]['contact_company_id'] = '';
						}

						$companyTableDataIn++;
						$span = "";
						if($company == ''){
							$JsonValid = 1;
							$span = "<span class='circleRed floadCircle'></span>";
						}
						$tempcompanyTableData.="<tr><td>$company $span</span></td><td>$primary_phone_number</td><td>$identify_no</td><td>$license_no</td><td>$date</td></tr>";

					}
				}
				$office_length = $contacts_str - $office_str;
				$office_arr = array_slice($allDataInSheet, $office_str, $office_length);
				$officeArray = array();

				$contactCompanyOffice = new ContactCompanyOffice($database);
				foreach($office_arr as $eachofficearr){
					$company = $head_quarters = $nick_name = $address_line_1 = $address_city = $region = $postal_code = $bussines_phone = $bussines_fax = "";

					$tableYes = 0;


					$company = $allDataInSheet['1']['A'];
					$indexOff = $eachofficearr["C"].' '.$company;
					$skip_arr = array("Contact List", "First Name");
					if (!empty($eachofficearr['A']) && !in_array($eachofficearr['A'], $skip_arr)) {
						if(trim($eachofficearr["A"])!=''){
							$head_quarters = $officeArray[$indexOff]['head_quarters_flag'] = $eachofficearr["A"];
						}
						if(trim($eachofficearr["B"])!=''){
							$nick_name = $officeArray[$indexOff]['office_nickname'] = $eachofficearr["B"];
						}
						if(trim($eachofficearr["C"])!=''){
							$address_line_1 = $officeArray[$indexOff]['address_line_1'] = $eachofficearr["C"];
						}
						if(trim($eachofficearr["D"])!=''){
							$address_city = $officeArray[$indexOff]['address_city'] = $eachofficearr["D"];
						}
						if(trim($eachofficearr["E"])!=''){
							$region = $officeArray[$indexOff]['address_state_or_region'] = $eachofficearr["E"];
						}
						if(trim($eachofficearr["F"])!=''){
							$postal_code = $officeArray[$indexOff]['address_postal_code'] = $eachofficearr["F"];
						}
						if(trim($eachofficearr["G"])!=''){					
							$bussines_phone = $eachofficearr["G"];
							$officeArray[$indexOff]['bussines_phone'] = $bussines_phone;
						}
						if(trim($eachofficearr["H"]) != ''){
							$bussines_fax = $eachofficearr["H"];
							$officeArray[$indexOff]['business_fax'] = $bussines_fax;
						}
						$officeArray[$indexOff]['contact_company_id'] = $companyArray[$company]['contact_company_id'];
						$contactCompanyId = $companyArray[$company]['contact_company_id'];

						$contactCompanyOffice->setData($officeArray[$indexOff]);
						$contactCompanyOffice->convertDataToProperties();
						$contactCompanyOffice->convertPropertiesToData();
						$data = $contactCompanyOffice->getData();
						// Test for existence via standard findByUniqueIndex method
						$contactCompanyOffice->findByUniqueIndex();
						$cco = contactCompanyOffice::verifyContactCompanyOfficeUsingContactCompanyId($database, $contactCompanyId, $address_city, $address_line_1);
						if ($cco!='') {
							$tableYes = 1;
							// Error code here
							$errorMessage = 'Contact Company Office already exists.';
							$officeArray[$indexOff]['exists'] = 1;
							$officeArray[$indexOff]['contact_company_office_id'] = $cco;
						} else {
							if($company == ''){
								$tableYes = 1;
								$JsonValid .= 1;
							}
							$officeArray[$indexOff]['exists'] = 0;
							$officeArray[$indexOff]['contact_company_office_id'] = '';
						}

					//
						$span = '';
						$spanAD = '';
						$spanCity = '';
						$spanNck = '';
						$spanStat = '';

						if(empty($nick_name) || empty($address_line_1) || empty($address_city) || empty($region)){
							$tableYes = 1;
						}
						
						$officeTableDataIn++;
						if($tableYes == 1){
							 $span = "<span class='circleBlack floadCircle'></span>";
							if($company == ''){
								$span = "<span class='circleRed floadCircle'></span>";
							}
							if(empty($nick_name)){
								$JsonValid .= 1;
								$spanNck = "<span class='circleRed floadCircle'></span>";
							}
							if(empty($address_line_1)){
								$JsonValid .= 1;
								$spanAD = "<span class='circleRed floadCircle'></span>";
							}
							if(empty($address_city)){
								$JsonValid .= 1;
								$spanCity = "<span class='circleRed floadCircle'></span>";
							}
							if(empty($region)){
								$JsonValid .= 1;
								$spanStat = "<span class='circleRed floadCircle'></span>";
							}
							if($cco!=''){
								$spanAD = $spanCity = "<span class='circleBlack floadCircle'></span>";
							}
						}
						$tempofficeTableData .="<tr><td>$company $span</td><td>$head_quarters</td><td>$nick_name $spanNck</td><td>$address_line_1 $spanAD</td><td>$address_city $spanCity</td><td>$region $spanStat</td><td>$postal_code</td><td>$bussines_phone</td><td>$bussines_fax</td></tr>";

					}

				}
				$contact_length = $total_data_count - $contacts_str;
				$contact_arr = array_slice($allDataInSheet, $contacts_str, $contact_length);
				$contactArray = array();
				$contact = new Contact($database);
				$inCon = 0;
				$contactTableDataIn = 1;
				foreach($contact_arr as $eachcontact_arr){
					$company = $first_name = $last_name = $email = $span = $title = $primary_office = $mobilephone = $phone = $fax = $user_status = '';
					$company = $company = $allDataInSheet['1']['A'];
					$indexCon = $company;	
					
					if(trim($eachcontact_arr["A"])!=''){
						$first_name = $contactArray[$indexCon][$inCon]['first_name'] = $eachcontact_arr["A"];
					}
					if(trim($eachcontact_arr["B"])!=''){
						$last_name = $contactArray[$indexCon][$inCon]['last_name'] = $eachcontact_arr["B"];
					}
					if(trim($eachcontact_arr["C"])!=''){
						$email = $contactArray[$indexCon][$inCon]['email'] = $eachcontact_arr["C"];
					}
					if(trim($eachcontact_arr["D"])!=''){
						$title = $contactArray[$indexCon][$inCon]['title'] = $eachcontact_arr["D"];
					}

					if(trim($eachcontact_arr["E"])!=''){
						$user_status = $contactArray[$indexCon][$inCon]['status'] = $eachcontact_arr["E"];
					}

					if(trim($eachcontact_arr["F"])!=''){
						$primary_office = $contactArray[$indexCon][$inCon]['primary_office'] = $eachcontact_arr["F"];
					}
					if(trim($eachcontact_arr["G"])!=''){
						$mobilephone = $contactArray[$indexCon][$inCon]['mobilephone'] = $eachcontact_arr["G"];
					}
					if(trim($eachcontact_arr["H"])!=''){
						$phone = $contactArray[$indexCon][$inCon]['phone'] = $eachcontact_arr["H"];
					}
					if(trim($eachcontact_arr["I"])!=''){
						$fax = $contactArray[$indexCon][$inCon]['fax'] = $eachcontact_arr["I"];
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
					}else{
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
					
						$span = '';
						$spanCom = '';
						$spanCity = '';
						if($tableYes == 1){	
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
						}
						$contactTableDataIn++;
						$tempcontactTableData .="<tr><td>$company $spanCom</td><td>$first_name</td><td>$last_name</td><td>$email $span</td><td>$title</td><td>$primary_office</td><td>$mobilephone</td><td>$phone</td><td>$fax</td></tr>";
					$inCon++;
				}

				
			}

			$companyTableData = $officeTableData = $contactTableData = '';

			if(!empty($companyTableDataIn))
			{
				$companyTableData ="
									<table cellpadding='5' class='content cell-border tableborder companyImport' width='100%'>
										<thead class='borderBottom'><tr class='table-headerinner'><th colspan='5' class='textAlignLeft'>Company Information</th></tr><tr align='left'><th>Company</th><th>Primary Phone Number</th><th>Federal Tax Id</th><th>License Number</th><th>License Expiration Date</th></tr></thead>";
				$companyTableData  .= $tempcompanyTableData;

				$companyTableData .="</table>";
			}

			if(!empty($officeTableDataIn)){
				$officeTableData ="<table cellpadding='5' class='content cell-border tableborder companyImport' width='100%'>
					<thead class='borderBottom'><tr class='table-headerinner'><th colspan='9' class='textAlignLeft'>Office</th></tr><tr align='left'><th>Company</th><th>Head Quaters</th><th>Office Nickname</th><th>Address</th><th>City</th><th>State</th><th>Zipcode</th><th>Business Phone</td><td>Business Fax</td></tr></thead>";

				$officeTableData .= $tempofficeTableData;
				$officeTableData .="</table>";
			}

			if(!empty($contactTableDataIn))
			{

				$contactTableData ="<table cellpadding='5' class='content cell-border tableborder companyImport' width='100%'><thead class='borderBottom'><tr class='table-headerinner'><th colspan='9' class='textAlignLeft'>Contact</th></tr><tr align='left'><th>Company</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Title</th><th>Primary Office</th><th>Mobilephone </th><th>Business Phone</td><td>Business Fax</td></tr></thead>";	
				$contactTableData .= $tempcontactTableData;
				$contactTableData .="</table>";
			}

			
			$table = 	"
			<div class='row' style='float: left; margin-left: auto;'>
				<div class='errorCode' style='width:100%'>
							<span class='alreadyExist'>( <div class='circleBlack' style='vertical-align: bottom;'></div> ) - Data Already Exist.</span>
							<span class='alreadyExist'>( <div class='circleRed' style='vertical-align: bottom;'></div> ) - Data is Mandatory.</span>
							<span class='alreadyExist'>( <div class='circleRed' style='vertical-align: bottom;'></div>&nbsp;<div class='circleRed' style='vertical-align: bottom;'></div> ) - Invalid Data.</span> 
						</div>
			</div>
						";


			$table .= $companyTableData.$officeTableData.$contactTableData;
			$json_encode = array(
				'data' => $table,
				'invalid' => $JsonValid
			);
			echo json_encode($json_encode);
		
	 	}


	} catch(Exception $e){
		$errorNumber = 1;
	}
}else if(!empty($_GET['action']) && $_GET['action'] == 'confirmDefaultTemplate'){
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
			$sheetCount = $objPHPExcel->getSheetCount();
			$sheetNames = $objPHPExcel->getSheetNames();
			$tempcompanyTableData = $tempofficeTableData = $tempcontactTableData = '';

			foreach(range(1,$sheetCount) as $index) {

				$sheetnum = $index-1;
				$objWorksheet = $objPHPExcel->setActiveSheetIndex($sheetnum);
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);


				$total_data_count = count($allDataInSheet);
				$company_str = $office_str = $contacts_str = 0;
				foreach($allDataInSheet as $eachKey => $eachDataInSheet){
					if($eachDataInSheet['A'] == 'Company Name'){
						$company_str = $eachKey;
					}else if($eachDataInSheet['A'] == 'Headquarters'){
						$office_str = $eachKey;
					}else if($eachDataInSheet['A'] == 'Contact List'){
						$contacts_str = $eachKey;
						$contacts_str += 1;
				        break;
					}
				}

				$company_length = $office_str - $company_str;
				$company_arr = array_slice($allDataInSheet, $company_str, $company_length);

				$companyArray = array();
				foreach($company_arr as $eachCompany){

					$contactCompany = new ContactCompany($database);

					$skip_arr = array("Office List", "Headquarters");
					if (!empty($eachCompany['A']) && !in_array($eachCompany['A'], $skip_arr)) {
						$company = $primary_phone_number = $identify_no = $license_no = $date = '' ;

						if(trim($eachCompany["A"]) != ''){
							$indexCom = $eachCompany["A"];
							$company = $companyArray[$indexCom]['company'] = $eachCompany["A"];
						}
						if(trim($eachCompany["B"]) != ''){
							$primary_phone_number = $eachCompany["B"];
							$primary_phone_number = Data::parseDigits($primary_phone_number);
							$companyArray[$indexCom]['primary_phone_number'] = $primary_phone_number;
						}
						if(trim($eachCompany["C"]) != ''){
							$identify_no = $companyArray[$indexCom]['employer_identification_number'] = $eachCompany["C"];
						}
						if(trim($eachCompany["D"]) != ''){
							$license_no = $companyArray[$indexCom]['construction_license_number'] = $eachCompany["D"];
						}
						if(trim($eachCompany["E"]) != ''){
							$date = $companyArray[$indexCom]['construction_license_number_expiration_date'] = $eachCompany["E"];
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
						$cc = contactCompany::verifyContactCompanyExists($database, '', $user_company_id, $indexCom);

						if ($cc!='') {
							$companyArray[$indexCom]['exists'] = 1;
							$companyArray[$indexCom]['contact_company_id'] = $cc;
							$contactCompany = ContactCompany::findById($database, $cc);
							if ($contactCompany) {
								$existingData = $contactCompany->getData();
								$httpGetInputData = $data;
								
								// Check if unique attribute
								$arrUniqueness = array(
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
							}
						}else{
							$contactCompany->setKey(null);
							$contactCompany->setData($data);
							$contact_company_office_id = $contactCompany->save();
							

							$companyArray[$indexCom]['exists'] = 0;
							$companyArray[$indexCom]['contact_company_id'] = $contact_company_office_id;
						}
					}
				}

				$office_length = $contacts_str - $office_str;
				$office_arr = array_slice($allDataInSheet, $office_str, $office_length);
				foreach($office_arr as $eachofficearr){
					$company = $head_quarters = $nick_name = $address_line_1 = $address_city = $region = $postal_code = $bussines_phone = $bussines_fax = "";
					$officeArray = array();
					$tableYes = 0;
					$skip_arr = array("Contact List", "First Name");
					if (!empty($eachofficearr['A']) && !in_array($eachofficearr['A'], $skip_arr)) {
						$contactCompanyOffice = new ContactCompanyOffice($database);

						$company = $allDataInSheet['1']['A'];
						$indexOff = $company;
			
						if(trim($eachofficearr["A"])!=''){

							if(trim($eachofficearr["A"]) == 'Yes'){
								$eachofficearr["A"] = 'Y';
							}else if(trim($eachofficearr["A"]) == 'No'){
								$eachofficearr["A"] = 'N';
							}

							$head_quarters = $officeArray[$indexOff]['head_quarters_flag'] = $eachofficearr["A"];
						}
						if(trim($eachofficearr["B"])!=''){
							$nick_name = $officeArray[$indexOff]['office_nickname'] = $eachofficearr["B"];
						}
						if(trim($eachofficearr["C"])!=''){
							$address_line_1 = $officeArray[$indexOff]['address_line_1'] = $eachofficearr["C"];
						}
						if(trim($eachofficearr["D"])!=''){
							$address_city = $officeArray[$indexOff]['address_city'] = $eachofficearr["D"];
						}
						if(trim($eachofficearr["E"])!=''){
							$region = $officeArray[$indexOff]['address_state_or_region'] = $eachofficearr["E"];
						}
						if(trim($eachofficearr["F"])!=''){
							$postal_code = $officeArray[$indexOff]['address_postal_code'] = $eachofficearr["F"];
						}
						if(trim($eachofficearr["G"])!=''){					
							$bussines_phone = $eachofficearr["G"];
							$officeArray[$indexOff]['bussines_phone'] = $bussines_phone;
						}
						if(trim($eachofficearr["H"]) != ''){
							$bussines_fax = $eachofficearr["H"];
							$officeArray[$indexOff]['business_fax'] = $bussines_fax;
						}
						$officeArray[$indexOff]['contact_company_id'] = $companyArray[$company]['contact_company_id'];
						$contactCompanyId = $companyArray[$company]['contact_company_id'];

						$contactCompanyOffice->setData($officeArray[$indexOff]);
						$contactCompanyOffice->convertDataToProperties();
						$contactCompanyOffice->convertPropertiesToData();
						$data = $contactCompanyOffice->getData();
						// Test for existence via standard findByUniqueIndex method
						$contactCompanyOffice->findByUniqueIndex();
						$cco = contactCompanyOffice::verifyContactCompanyOfficeUsingContactCompanyId($database, $contactCompanyId, $address_city, $address_line_1);
						if ($cco!='') {
						
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
							
							if (!empty($data)) {
								$contactCompanyOffice->setData($data);
								$save = true;
								$contactCompanyOffice->save();
								if(!empty($bussines_phone)){
								/*business mobile import*/
									mobilePhoneImportByContactIdOffice($database, $cco, $data, $bussines_phone, 'business');
								}
								if(!empty($bussines_fax)){
								/*business fax import*/
									mobilePhoneImportByContactIdOffice($database, $cco, $data, $bussines_fax, 'fax');	
								}
							}							
						} else {
							$contactCompanyOffice->setKey(null);
							$contactCompanyOffice->setData($data);
							$contact_company_office_id = $contactCompanyOffice->save();
							$officeArray[$indexOff]['exists'] = 0;
							$officeArray[$indexOff]['contact_company_office_id'] = $contact_company_office_id;

							if(!empty($bussines_phone)){
								/*business mobile import*/
								mobilePhoneImportByContactIdOffice($database, $contact_company_office_id, $data, $bussines_phone, 'business');
							}
							if(!empty($bussines_fax)){
								/*business fax import*/
								mobilePhoneImportByContactIdOffice($database, $contact_company_office_id, $data, $bussines_fax, 'fax');
							}
							
						}
					}

				}
				$contact_length = $total_data_count - $contacts_str;
				$contact_arr = array_slice($allDataInSheet, $contacts_str, $contact_length);

				$inCon = 0;
				$contactTableDataIn = 1;
				
				
				foreach($contact_arr as $eachcontact_arr){
					$contact = new Contact($database);
					$contactArray = array();
					$company = $first_name = $last_name = $email = $span = $title = $primary_office = $mobilephone = $phone = $fax = $user_status = '';
					$company = $company = $allDataInSheet['1']['A'];
					$indexCon = $company;	
					
					if(trim($eachcontact_arr["A"])!=''){
						$first_name = $contactArray[$indexCon][$inCon]['first_name'] = $eachcontact_arr["A"];
					}
					if(trim($eachcontact_arr["B"])!=''){
						$last_name = $contactArray[$indexCon][$inCon]['last_name'] = $eachcontact_arr["B"];
					}
					if(trim($eachcontact_arr["C"])!=''){
						$email = $contactArray[$indexCon][$inCon]['email'] = $eachcontact_arr["C"];
					}
					if(trim($eachcontact_arr["D"])!=''){
						$title = $contactArray[$indexCon][$inCon]['title'] = $eachcontact_arr["D"];
					}

					if(trim($eachcontact_arr["E"])!=''){
						$user_status = $contactArray[$indexCon][$inCon]['status'] = $eachcontact_arr["E"];
					}

					if(trim($eachcontact_arr["F"])!=''){
						$primary_office = $contactArray[$indexCon][$inCon]['primary_office'] = $eachcontact_arr["F"];
					}
					if(trim($eachcontact_arr["G"])!=''){
						$mobilephone = $contactArray[$indexCon][$inCon]['mobilephone'] = $eachcontact_arr["G"];
					}
					if(trim($eachcontact_arr["H"])!=''){
						$phone = $contactArray[$indexCon][$inCon]['phone'] = $eachcontact_arr["H"];
					}
					if(trim($eachcontact_arr["I"])!=''){
						$fax = $contactArray[$indexCon][$inCon]['fax'] = $eachcontact_arr["I"];
					}
					if(!empty($officeArray[$indexCon]['contact_company_id'])){
						$contactCompanyId = $contactArray[$indexCon][$inCon]['contact_company_id'] =$officeArray[$indexCon]['contact_company_id'];
						$contactArray[$indexCon][$inCon]['contact_company_office_id'] = $officeArray[$company]['contact_company_office_id'];
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
					}else{
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
						
						
						$contactTableDataIn++;
						
						$contact_id = $contactArray[$indexCon][$inCon]['contact_id'] = $ce;
						if(!empty($mobilephone)){
							 /*mobileno import*/
						 mobilePhoneImportByContactId($database, $ce, $data, $mobilephone, 'mobile');
						}
						if(!empty($phone)){
							/*business mobile import*/
						 	mobilePhoneImportByContactId($database, $ce, $data, $phone, 'business');
						}
						if(!empty($fax)){
						 	/*business fax import*/
						 mobilePhoneImportByContactId($database, $ce, $data, $fax,'fax');
						}
					}else{
						$contact->setKey(null);
						$contact->setData($data);
						$contact_id = $contact->save();
						$contactArray[$indexCon][$inCon]['contact_id'] = $contact_id;
						
						if(!empty($mobilephone)){
							/*mobileno import*/
							mobilePhoneImportByContactId($database, $contact_id, $data, $mobilephone, 'mobile');
						}
						if(!empty($phone)){
							/*business mobile import*/
							mobilePhoneImportByContactId($database, $contact_id, $data, $phone, 'business');
						}
						if(!empty($fax)){
							/*business fax import*/
							mobilePhoneImportByContactId($database, $contact_id, $data, $fax, 'fax');
						}
					}
					$inCon++;
				}


			}

			unlink($filePath);


		}else{
			echo $errorNumber = 1;
			$errorMessage = 'File not exists';
			$message->enqueueError($errorMessage, $currentPhpScript);
		}
	} catch(Exception $e){
		echo $errorNumber = 1;
	}

}else if(!empty($_GET['action']) && $_GET['action'] == 'hintContent'){


	$type = $get->type;
	$hint_title  = $hint_body = "";
	
	if(!empty($type) && $type =='rfi_draft_help3'){
		$hint_title  = "Instructions";
		$hint_body = "<ul>
			            <li>Downloading and using the Default Excel Template will make the process easier since all the required information you may need to provide is mentioned here along with the format that the system will accept. Drag down the sample data to copy the cell format and enter your details.</li>
		        	</ul>";	
	}else if(!empty($type) && $type =='rfi_draft_help'){
		$hint_title  = "Rules";
		$hint_body = "<ul  style='list-style: none;'>
			<li>1.Upload a Excel file (XLSX). </li>
	<li>2. All the mandatory fields within corresponding sheets should be available with data. Provide the Headings in 2nd row of the excel.</li>
	<li>a. Mandatory fields for sheet- Company:Company</li>
	<li>b. Mandatory Fields for sheet- Office :Company (should carry the same data you created in sheet 'company')</li>
	<li>c. Mandatory fields for sheet- Contacts:Company(should carry the same data you created in sheet 'company'), Email</li>
	<li>3. After uploading, we have shown the Redundant and Wrong data For Default Template.</li>
	</ul>";
	}else if(!empty($type) && $type =='rfi_draft_help2'){
		$hint_title  = "Rules (USE MY TEMPLATE)";
		$hint_body = "Any excel file you create can be uploaded provided it must meet the mentioned rules.
					<ul style='list-style: none;'>
						<li>1. Excel file (XLSX) you create should have 3 sheets - Company, Office, Contacts(in same order)</li>
						<li>2. All the mandatory fields within corresponding sheets should be available with data. Provide the Headings in 2nd row of the excel.</li>
						<li>a. Mandatory fields for sheet- Company:Company</li>
						<li>b. Mandatory Fields for sheet- Office :Company (should carry the same data you created in sheet 'company')</li>
						<li>c. Mandatory fields for sheet- Contacts:Company(should carry the same data you created in sheet 'company'), Email</li>
						<li>d. Email want to be unique for the Contact.</li>
					</ul>";

	}
	

   
	$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="instructionmodalClose();">&times;</span>
      <h3>$hint_title</h3>
    </div>
    <div class="modal-body">
		$hint_body
    </div>
    <div class="modal-footer">
    	   <button class="buttonClose" onclick="instructionmodalClose();">Close</button>
    </div>
  </div>
modalContent;
echo $modalContent;
}

?>
