<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * Admin contact creation.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');

// Method Call is our switch variable
if (isset($get)) {
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}

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

// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();

// PERMISSION VARIABLES
require_once('app/models/permission_mdl.php');
/* @var $permissions Permissions */

/*

ORDER BY smf.`sort_order` ASC:

admin_contacts_manager_grant_access							Allow View Access To Contacts Manager

admin_contacts_manager_manage								Manage All Contacts Manager Information
admin_contacts_manager_view									View All Contacts Manager Information
admin_contacts_my_contact_company_manage					Manage My Company Information
admin_contacts_third_party_contact_companies_manage			Manage My Third Party Companies' Information
admin_contacts_my_contacts_manage							Manage My Employee Contacts Data
admin_contacts_third_party_contacts_manage					Manage My Third Party Contacts Data
admin_contacts_my_contact_company_offices_manage			Manage My Company's Offices
admin_contacts_my_contact_company_offices_view				View My Company's Offices
admin_contacts_my_contact_roles_manage						Manage My Employee Contact Roles
admin_contacts_my_contacts_view								Grant Access To Contacts Manager
admin_contacts_third_party_contact_company_offices_view		View My Third Party Companies' Offices
admin_contacts_third_party_contact_company_offices_manage	Manage My Third Party Companies' Offices


# contact_companies.*
admin_contacts_my_contact_company_view								View My Company Information
admin_contacts_my_contact_company_manage							Manage My Company Information
admin_contacts_third_party_contact_companies_view					View My Third Party Companies' Information
admin_contacts_third_party_contact_companies_manage					Manage My Third Party Companies' Information

# contact_companies.employer_identification_number
admin_contacts_my_employer_identification_number_view				View My Company's Employer Identification Number
admin_contacts_my_employer_identification_number_manage				Manage My Company's Employer Identification Number
admin_contacts_third_party_employer_identification_number_view		View My Third Party Companies' Employer Identification Number
admin_contacts_third_party_employer_identification_number_manage	Manage My Third Party Companies' Employer Identification Number

# contact_company_offices
admin_contacts_my_contact_company_offices_view						View My Company's Offices
admin_contacts_my_contact_company_offices_manage					Manage My Company's Offices
admin_contacts_third_party_contact_company_offices_view				View My Third Party Companies' Offices
admin_contacts_third_party_contact_company_offices_manage			Manage My Third Party Companies' Offices

# contacts
admin_contacts_my_contacts_view										View My Employee Contacts Data
admin_contacts_my_contacts_manage									Manage My Employee Contacts Data
admin_contacts_third_party_contacts_view							View My Third Party Contacts Data
admin_contacts_third_party_contacts_manage							Manage My Third Party Contacts Data

# subcontractor_trades
admin_contacts_my_company_trades_view								View My Company's Trades
admin_contacts_my_company_trades_manage								Manage My Company's Trades
admin_contacts_third_party_company_trades_view						View My Third Party Companies' Trades
admin_contacts_third_party_company_trades_manage					Manage My Third Party Companies' Trades

# contacts_to_roles, projects_to_contacts_to_roles
admin_contacts_my_contact_roles_view								View My Employee Contact Roles
admin_contacts_my_contact_roles_manage								Manage My Employee Contact Roles
admin_contacts_third_party_contact_roles_view						View My Third Party Employee Contact Roles
admin_contacts_third_party_contact_roles_manage						Manage My Third Party Employee Contact Roles

*/

// Contacts Manager View / Gain initial access
//$userCanViewContactsManager = $permissions->determineAccessToSoftwareModuleFunction('admin_contacts_manager_grant_access');

// Company Data - contact_companies or user_companies (my company record only)
$userCanViewMyContactCompanyData = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contact_company_view');
$userCanManageMyContactCompanyData = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contact_company_manage');
$userCanViewThirdPartyContactCompanyData = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_contact_companies_view');
$userCanManageThirdPartyContactCompanyData = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_contact_companies_manage');

// Fed Tax ID - contact_companies.employer_identification_number
$userCanViewMyContactCompanyEmployerIdentificationNumber = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_employer_identification_number_view');
$userCanManageMyContactCompanyEmployerIdentificationNumber = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_employer_identification_number_manage');
$userCanViewThirdPartyContactCompanyEmployerIdentificationNumbers = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_employer_identification_number_view');
$userCanManageThirdPartyContactCompanyEmployerIdentificationNumbers = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_employer_identification_number_manage');

// Offices - contact_company_offices
$userCanViewMyContactCompanyOffices = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contact_company_offices_view');
$userCanManageMyContactCompanyOffices = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contact_company_offices_manage');
$userCanViewThirdPartyContactCompanyOffices = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_contact_company_offices_view');
$userCanManageThirdPartyContactCompanyOffices = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_contact_company_offices_manage');

// Contacts - contacts
$userCanViewMyContacts = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contacts_view');
$userCanManageMyContacts = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contacts_manage');
$userCanViewThirdPartyContacts = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_contacts_view');
$userCanManageThirdPartyContacts = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_contacts_manage');

// Subcontractor Trades - subcontractor_trades
$userCanViewMyCompanyTrades = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_company_trades_view');
$userCanManageMyCompanyTrades = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_company_trades_manage');
$userCanViewThirdPartyCompanyTrades = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_company_trades_view');
$userCanManageThirdPartyCompanyTrades = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_company_trades_manage');

// Permissions via System/Contact & Project Roles - contacts_to_roles, projects_to_contacts_to_roles
$userCanViewMyContactRoles = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contact_roles_view');
$userCanManageMyContactRoles = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contact_roles_manage');
$userCanViewThirdPartyContactRoles = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_contact_roles_view');
$userCanManageThirdPartyContactRoles = checkPermissionForAllModuleAndRole($database,'admin_contacts_third_party_contact_roles_manage');

if($userRole =="global_admin")
{

	$userCanViewMyContactCompanyData = $userCanManageMyContactCompanyData = 
	$userCanViewThirdPartyContactCompanyData = $userCanManageThirdPartyContactCompanyData = 
	$userCanViewMyContactCompanyEmployerIdentificationNumber = 
	$userCanManageMyContactCompanyEmployerIdentificationNumber = $userCanViewThirdPartyContactCompanyEmployerIdentificationNumbers = $userCanManageThirdPartyContactCompanyEmployerIdentificationNumbers = 	$userCanViewMyContactCompanyOffices = $userCanManageMyContactCompanyOffices = 
	$userCanViewThirdPartyContactCompanyOffices =$userCanManageThirdPartyContactCompanyOffices = 	$userCanViewMyContacts = $userCanManageMyContacts =$userCanViewThirdPartyContacts = 
	$userCanManageThirdPartyContacts = 
	$userCanViewMyCompanyTrades = $userCanManageMyCompanyTrades =$userCanViewThirdPartyCompanyTrades =$userCanManageThirdPartyCompanyTrades =
	$userCanViewMyContactRoles = $userCanManageMyContactRoles = $userCanViewThirdPartyContactRoles = $userCanManageThirdPartyContactRoles= 1;
}

// Start output buffering to prevent output from being echo'd out
ob_start();

switch ($methodCall) {
	/*
	case 'getCompaniesListByUserCompany':

		$arrCompanies = ContactCompany::loadContactCompaniesCountByLetterByUserCompanyId($database, $user_company_id);

		echo '<table cellpadding="3"><tr><td>Letter</br>Count</td>';
		foreach ($arrCompanies AS $key => $value) {
			echo '<td>'.$key.'<br>'.$value.'</td>';
		}
		echo '</tr></table>';

		break;
	*/

	case 'searchForCompanyReturnSuggestions':
		$searchToken = $get->term;
		//$searchToken = str_replace(' (My Company)',	'', $searchToken);
		$arrContactCompaniesList = ContactCompany::loadContactCompaniesListByUserCompanyIdAndSearch($database, $user_company_id, $searchToken);

		// Could pass back serialized objects to the front-end, but would then need to modify the JavaScript
		// Return data in a format that makes JQuery happy
		$arrContactCompanies = array();
		foreach ($arrContactCompaniesList as $contact_company_id => $contactCompany) {
			/* @var $cc ContactCompany */
			$arrTmp['value'] = $contactCompany->contact_company_id;
			if ($contactCompany->user_user_company_id == $contactCompany->contact_user_company_id) {
				$arrTmp['label'] = $contactCompany->contact_company_name . ' (My Company)';
			} else {
				$arrTmp['label'] = $contactCompany->contact_company_name;
			}
			array_push($arrContactCompanies, $arrTmp);
		}

		$jsonOutput = json_encode($arrContactCompanies);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

	case 'checkIfCompanyExists':
		$contact_company_id = $get->contact_company_id;
		$contact_company_name = $get->contact_company_name;
		$contact_company_name = str_replace(' (My Company)', '', $contact_company_name);

		$verifiedContactCompanyId = ContactCompany::verifyContactCompanyExists($database, $contact_company_id, $user_company_id, $contact_company_name);
		echo $verifiedContactCompanyId;

		break;

	case 'loadContactCompany':

		try {

			if (!$userCanViewMyContactCompanyData && !$userCanManageMyContactCompanyData && !$userCanViewThirdPartyContactCompanyData && !$userCanManageThirdPartyContactCompanyData) {
				// Error and exit
				$errorMessage = '<span style="color:red;">Permission denied. for loading Company Information</span>';
				// $errorMessage = 'Error loading: Contact Company.<br>Permission Denied.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}

			$contact_company_id = (int) $get->contact_company_id;
			$companyName = $get->contact_company_name;

			$contactCompany = ContactCompany::findById($database, $contact_company_id);
			/* @var $contactCompany ContactCompany */

			// Permissions check
			if ($user_company_id == $contactCompany->contact_user_company_id) {
				$myCompanyDataCase = true;
				if (!$userCanViewMyContactCompanyData && !$userCanManageMyContactCompanyData) {
					// Error and exit
					$errorMessage = '<span style="color:red;">Permission denied. for loading Company Information</span>';
					// $errorMessage = 'Error loading: Contact Company.<br>Permission Denied.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}
			} else {
				$myCompanyDataCase = false;
				if (!$userCanViewThirdPartyContactCompanyData && !$userCanManageThirdPartyContactCompanyData) {
					// Error and exit
					$errorMessage = '<span style="color:red;">Permission denied. for loading Company Information<span>';
					// $errorMessage = 'Error loading: Contact Company.<br>Permission Denied.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}
			}

			// Get primary key / unique key via get input
			$attributeGroupName = (string) $get->attributeGroupName;
			$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
			$attributeSubgroupName = (string) $get->attributeSubgroupName;
			$formattedAttributeSubgroupName = (string) $get->formattedAttributeSubgroupName;
			$uniqueId = (string) $get->uniqueId;

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Contact Company';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'contact_companies';
			}

			// Primary key attibutes
			//$contact_company_id = (int) $get->uniqueId;
			// Debug
			//$contact_company_id = (int) 1;

			/*
			// Unique index attibutes
			$user_user_company_id = (int) $get->user_user_company_id;
			$company = (string) $get->company;
			$employer_identification_number = (string) $get->employer_identification_number;
			*/

			if ($userCanManageMyContactCompanyData || $userCanManageThirdPartyContactCompanyData) {
				$mode = 'update';
			} else {
				$mode = 'view';
			}

			$arrContactCompanies = array($contact_company_id => $contactCompany);

			require('include/page-components/contact_company_details.php');

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|contact_companies|Contact Company|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();

			// @todo Figure out this section
			// Output red section on form
			$errorNumber = 1;
			$errorMessage = '<span style="color:red;">Permission denied. for loading Company Information</span>';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$primaryKeyAsString = '';

			echo $errorMessage;
		}

		break;

	case 'getOfficesByCompany':

		if (!$userCanViewMyContactCompanyOffices && !$userCanManageMyContactCompanyOffices && !$userCanViewThirdPartyContactCompanyOffices && !$userCanManageThirdPartyContactCompanyOffices) {
			echo '<span style="color:red;">Permission denied. for loading  Office Information</span>';
			exit;
		}

		$contact_company_id = (int) $get->contact_company_id;
		$loadContactCompanyOfficesByContactCompanyIdOptions = new Input();
		$loadContactCompanyOfficesByContactCompanyIdOptions->forceLoadFlag = true;
		$arrContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $contact_company_id, $loadContactCompanyOfficesByContactCompanyIdOptions);
		$contactCompany = ContactCompany::findContactCompanyByIdExtended($database, $contact_company_id);
		/* @var $contactCompany ContactCompany */
		$contact_user_company_id = $contactCompany->contact_user_company_id;

		$myCompanyDataCase = false;
		if ($user_company_id == $contact_user_company_id) {
			$myCompanyDataCase = true;
		}

		$userCanManageOffices = false;
		if ($myCompanyDataCase && $userCanManageMyContactCompanyOffices) {
			$userCanManageOffices = true;
		} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContactCompanyOffices) {
			$userCanManageOffices = true;
		}

//		$mode = $view;
//		foreach ($arrContactCompanyOffices as $key => $contactCompanyOffice) {
//			/* @var $contactCompanyOffice ContactCompanyOffice */
//			require('include/page-components/contact_company_office_details.php');
//		}
//		exit;

		require('include/page-components/contact_company_offices.php');

		break;

	case 'loadContactCompanyOfficeDetails':
		/**
		 * Two modes out of three here (1 & 2):
		 * 3 is acheived via
		 *
		 * 1) Create a new Contact Company Office
		 * 2) Upate Existing Contact Company Office
		 * 3) Display Contact Company Office (not updateable in this mode/view
		 */

		$errorNumber = 0;
		$errorMessage = '';

		// Permissions
		//$userCanViewContactCompanyOffices;
		//$userCanManageContactCompanyOffices;

		try {

			$contact_company_office_id = (int) $get->contact_company_office_id;
			if ($contact_company_office_id == 0) {
				$mode = 'create';
			} elseif ($contact_company_office_id > 0) {
				$mode = 'update';
			} else {
				$mode = 'view';
			}

			if ($userCanViewMyContactCompanyOffices || $userCanViewThirdPartyContactCompanyOffices) {
				$userCanViewContactCompanyOffices = true;
			}

			if ($userCanManageMyContactCompanyOffices || $userCanManageThirdPartyContactCompanyOffices) {
				$userCanManageContactCompanyOffices = true;
			}

			if (!$userCanViewContactCompanyOffices) {
				echo 'Permission denied.';
				exit;
			}

			// Enforce Permissions
			if ($mode == 'view') {
				if (!$userCanViewContactCompanyOffices) {
					echo 'Permission denied.';
					exit;
				}
			}
			if (($mode == 'create') || ($mode == 'update')) {
				if (!$userCanManageContactCompanyOffices) {
					echo '';
					exit;
				}
			}

			if (isset($contact_company_office_id) && !empty($contact_company_office_id)) {
				$contactCompanyOffice = ContactCompanyOffice::findContactCompanyOfficeByIdExtended($database, $contact_company_office_id);
				/* @var $contactCompanyOffice ContactCompanyOffice */
			} else {
				$contactCompanyOffice = false;
				$contact_company_office_id = 0;
			}
			require('include/page-components/contact_company_office_details.php');

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		break;

	case 'checkAddressPostalCode':

		$attributeGroupName = $get->attributeGroupName;
		$uniqueId = $get->uniqueId;
		$address_postal_code = $get->address_postal_code;

		$arrAddresses = Address::loadCityStateCountyGroupingsByPostalCode('location', $address_postal_code);
		$arrCities = array();
		foreach ($arrAddresses as $address) {
			/* @var $address Address */
			$address_city = $address->address_city;
			$address_state_or_region_abbreviation = $address->address_state_or_region_abbreviation;
			if (!empty($address_city) && !empty($address_state_or_region_abbreviation)) {
				$location = $address_city.', '.$address_state_or_region_abbreviation;
				$location = Data::singleSpace($location);
				$arrCities[] = $location;
			}
		}

		$arrOutput = array(
			'attributeGroupName' => $attributeGroupName,
			'uniqueId' => $uniqueId,
			'arrCities' => $arrCities
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

	case 'getEmployeesByCompany':

		$contact_company_id = $get->contact_company_id;
		$contactCompany = ContactCompany::findById($database, $contact_company_id);
		if (!$contactCompany) {
			// @todo use this block
		}

		if ($contactCompany->user_user_company_id == $contactCompany->contact_user_company_id) {
			$companyName = $contactCompany->contact_company_name . ' (My Company)';
		} else {
			$companyName = $contactCompany->contact_company_name;
		}

		$myCompanyDataCase = false;
		if ($user_company_id == $contactCompany->contact_user_company_id) {
			$myCompanyDataCase = true;
		}

		$userCanManageContacts = false;
		if ($myCompanyDataCase && $userCanManageMyContacts) {
			$userCanManageContacts = true;
		} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContacts) {
			$userCanManageContacts = true;
		}

		/* @var $contactCompany ContactCompany */
		$arrContactsByUserCompanyIdAndContactCompanyId = Contact::loadContactsByUserCompanyIdAndContactCompanyId($database, $user_company_id, $contact_company_id, 1);

		$arrContacts = $arrContactsByUserCompanyIdAndContactCompanyId;
		require('include/page-components/contacts.php');

		break;

	case 'getArchivedEmployeesByCompany':

		$contact_company_id = $get->contact_company_id;
		$contactCompany = ContactCompany::findById($database, $contact_company_id);
		if (!$contactCompany) {
			// @todo use this block
		}

		if ($contactCompany->user_user_company_id == $contactCompany->contact_user_company_id) {
			$companyName = $contactCompany->contact_company_name . ' (My Company)';
		} else {
			$companyName = $contactCompany->contact_company_name;
		}

		$myCompanyDataCase = false;
		if ($user_company_id == $contactCompany->contact_user_company_id) {
			$myCompanyDataCase = true;
		}

		$userCanManageContacts = false;
		if ($myCompanyDataCase && $userCanManageMyContacts) {
			$userCanManageContacts = true;
		} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContacts) {
			$userCanManageContacts = true;
		}

		/* @var $contactCompany ContactCompany */
		$arrContactsByUserCompanyIdAndContactCompanyId = Contact::loadContactsByUserCompanyIdAndContactCompanyId($database, $user_company_id, $contact_company_id, 2);

		$arrContacts = $arrContactsByUserCompanyIdAndContactCompanyId;
		require('include/page-components/archived-contacts.php');

		break;

	case 'saveCompany':

		$contact_company_id = $get->contact_company_id;
		$licenseDate = $get->licenseDate;

		$message->enqueueError('|Unable To Save New Company!', $currentPhpScript);

		/**
		 * @todo Add in some error handling stuff =:-)  ...
		 */

		if (!empty($licenseDate)) {
			$licenseDate = strtotime($licenseDate);
			$licenseDate = date('Y-m-d',$licenseDate);
		} else {
			$licenseDate = '';
		}

		$contactCompany = new ContactCompany($database);

		// UPDATE record in the contact_companies table.
		if ($contact_company_id != 0) {
			$key = array('id' => $contact_company_id);
			$contactCompany->setKey($key);

			$updateFlag = true;
		} else {
			$updateFlag = false;
		}

		// INSERT a new record into the contact_companies table
		$contactCompany->contact_company_name = $get->companyName;
		$contactCompany->employer_identification_number = $get->taxID;
		$contactCompany->construction_license_number = $get->license;
		$contactCompany->construction_license_number_expiration_date = $licenseDate;
		$contactCompany->user_user_company_id = $user_company_id;

		$contactCompany->convertPropertiesToData();

		if ($updateFlag) {
			$contactCompany->save();
		} else {
			// INSERT case
			$contact_company_id = $contactCompany->save();
		}

		$contact = Contact::findContactById($database, $primary_contact_id);
		/* $contact Contact */

		$performRefreshOperation = '';
		if ($contact) {
			if ($contact->contact_company_id == $contact_company_id) {
				$performRefreshOperation = 'Y';
			}
		}

		if ($updateFlag) {

			$arrOutput = array(
				'contact_company_id' => $contact_company_id,
				'customSuccessMessage' => 'Company Successfully Updated',
				'displayCustomSuccessMessage' => 'Y',
				'performRefreshOperation' => $performRefreshOperation
			);

		} else {

			$arrOutput = array(
				'contact_company_id' => $contact_company_id,
				'customSuccessMessage' => 'New Company Created Successfully.',
				'displayCustomSuccessMessage' => 'Y',
				'performRefreshOperation' => $performRefreshOperation
			);

		}

		$output = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $output;

		break;

	case 'saveOffice':

		$contact_company_id = $get->contact_company_id;
		$contact_company_office_id = $get->contact_company_office_id;

		// Convert the country to a two character code
		$address_country = $get->address_country;
		$country_code = Address::convertCountryToCountryCode('location', $address_country);

		// TODO:Add in some error handling stuff =:-)  ...

		$contactCompanyOffice = new ContactCompanyOffice($database);

		// UPDATE record in the contact_company_office table
		if ($contact_company_office_id != 0) {
			$key = array('id' => $contact_company_office_id);
			$contactCompanyOffice->setKey($key);

			$message->enqueueError('|Unable To Save Office Changes!', $currentPhpScript);
		}

		$message->enqueueError('|Unable To Create New Office!', $currentPhpScript);


		//$contactCompanyOffice = new ContactCompanyOffice($database);

		/*
		// Retrieve all of the $_GET inputs automatically for the ContactCompanyOffice record
		$httpGetInputData = $get->getData();
		foreach ($httpGetInputData as $k => $v) {
			if (empty($v)) {
				unset($httpGetInputData[$k]);
			}
		}

		$contactCompanyOffice->setData($httpGetInputData);
		$contactCompanyOffice->convertDataToProperties();
		*/

		// INSERT a new record into the contact_company_offices table
		$contactCompanyOffice->contact_company_id = $contact_company_id;
		$contactCompanyOffice->office_nickname = (string) $get->office_nickname;
		$contactCompanyOffice->address_line_1 = (string) $get->address_line_1;
		$contactCompanyOffice->address_line_2 = (string) $get->address_line_2;
		//$contactCompanyOffice->address_line_3 = (string) $get->address_line_3;
		$contactCompanyOffice->address_line_3 = '';
		//$contactCompanyOffice->address_line_4 = (string) $get->address_line_4;
		$contactCompanyOffice->address_line_4 = '';
		//$contactCompanyOffice->address_line_3 = $get->address_line_3;
		//$contactCompanyOffice->address_line_4 = $get->address_line_4;
		$contactCompanyOffice->address_city = (string) $get->address_city;
		//$contactCompanyOffice->address_county = (string) $get->address_county;
		$contactCompanyOffice->address_county = '';
		$contactCompanyOffice->address_state_or_region = (string) $get->address_state_or_region;
		$contactCompanyOffice->address_postal_code = (string) $get->address_postal_code;
		//$contactCompanyOffice->address_postal_code_extension = (string) $get->address_postal_code_extension;
		$contactCompanyOffice->address_postal_code_extension = '';
		//$contactCompanyOffice->address_county = $get->address_county;
		$contactCompanyOffice->address_county = '';
		//$contactCompanyOffice->address_country = (string) $get->address_country;
		$contactCompanyOffice->address_country = $country_code;
		$contactCompanyOffice->head_quarters_flag = (string) $get->headerquarters;
		//$contactCompanyOffice->address_validated_by_user_flag = (string) $get->address_validated_by_user_flag;
		//$contactCompanyOffice->address_validated_by_web_service_flag = (string) $get->address_validated_by_web_service_flag;
		//$contactCompanyOffice->address_validation_by_web_service_error_flag = (string) $get->address_validation_by_web_service_error_flag;

		$contactCompanyOffice->convertPropertiesToData();
		$data = $contactCompanyOffice->getData();

		// Test for existence via standard findByUniqueIndex method
		$contactCompanyOffice->findByUniqueIndex();
		if ($contactCompanyOffice->isDataLoaded()) {
			// Error code here
			$errorMessage = "Office already exists.";
			$message->enqueueError($errorMessage, $currentPhpScript);
			$error->outputErrorMessages();
			exit;
		} else {
			$contactCompanyOffice->setData($data);

			if ($contact_company_office_id == 0) {
				$contactCompanyOffice->setKey(null);
				$new_contact_company_office_id = $contactCompanyOffice->save();
			} else {
				$contactCompanyOffice->setKey($key);
				//unset($data['']);
				$contactCompanyOffice->save();
				/*
				$newData = $data;
				$data = Data::deltify($existingData, $newData);
				if (!empty($data)) {
					$tmpObject->setData($data);
					$save = true;
				}
				*/
			}
		}

		if (isset($new_contact_company_office_id) && !empty($new_contact_company_office_id)) {
			$contactCompanyOffice->contact_company_office_id = $new_contact_company_office_id;
			$contactCompanyOffice->setId($new_contact_company_office_id);
		}

		if ($new_contact_company_office_id) {
			$contact_company_office_id = $new_contact_company_office_id;
			$customSuccessMessage = 'New Office Created Successfully.';
		} else {
			$customSuccessMessage = 'Office Successfully Updated';
		}

		$arrOutput = array(
			'contact_company_id' => $contact_company_id,
			'contact_company_office_id' => $contact_company_office_id,
			'customSuccessMessage' => $customSuccessMessage,
			'displayCustomSuccessMessage' => 'Y'
		);

		$output = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $output;

		break;

	case 'loadContactInfo':

		$contact_id = (int) $get->contact_id;
		$contact_company_id = (int) $get->contact_company_id;

		$contactCompany = ContactCompany::findById($database, $contact_company_id);

		$myCompanyDataCase = false;
		if ($user_company_id == $contactCompany->contact_user_company_id) {
			$myCompanyDataCase = true;
		}

		$userCanManageContacts = false;
		if ($myCompanyDataCase && $userCanManageMyContacts) {
			$userCanManageContacts = true;
		} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContacts) {
			$userCanManageContacts = true;
		}

		$message->enqueueError('|Unable To Load Contact Info', $currentPhpScript);

		// Debug
		//$contact_id = 5;

		if (isset($contact_id) && ($contact_id > 0)) {
			$contact = Contact::findById($database, $contact_id);
			/* @var $contact Contact */
			$contact->loadContactInfo(true, true, true);
		} else {
			// Return error
			$contact = false;
		}

		if ($contact) {
			require('include/page-components/contact_details.php');
		}

		break;

	case 'loadArchivedContactInfo':
		$contact_id = (int) $get->contact_id;
		$contact_company_id = (int) $get->contact_company_id;

		$contactCompany = ContactCompany::findById($database, $contact_company_id);

		$myCompanyDataCase = false;
		if ($user_company_id == $contactCompany->contact_user_company_id) {
			$myCompanyDataCase = true;
		}

		$userCanManageContacts = false;
		if ($myCompanyDataCase && $userCanManageMyContacts) {
			$userCanManageContacts = true;
		} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContacts) {
			$userCanManageContacts = true;
		}

		$message->enqueueError('|Unable To Load Contact Info', $currentPhpScript);

		// Debug
		//$contact_id = 5;

		if (isset($contact_id) && ($contact_id > 0)) {
			$contact = Contact::findById($database, $contact_id);
			/* @var $contact Contact */
			$contact->loadContactInfo(true, true, true);
		} else {
			// Return error
			$contact = false;
		}

		if ($contact) {
			require('include/page-components/archived_contact_details.php');
		}

		break;

	case 'saveNewContact':
		$contact_company_id = (int) $get->contact_company_id;
		$contact_company_office_id = (int) $get->ddlOffices;
		$email = $contact->email = (string) $get->email;
		$first_name = (string) $get->first_name;
		$last_name = (string) $get->last_name;
		$title = (string) $get->title;

		$message->reset($currentPhpScript);

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->throwExceptionOnDbError = true;

		try {
			$contact = Contact::findByUserCompanyIdAndContactCompanyIdAndEmailAndFirstNameAndLastName($database, $user_company_id, $contact_company_id, $email, $first_name, $last_name);

			if ($contact) {
				$errorMessage = 'Contact Already Exists';
				$message->enqueueError('|Contact Already Exists', $currentPhpScript);
				throw new Exception($errorMessage);
			} else {
				$contact = New Contact($database);
				$contact->user_company_id = $user_company_id;
				$contact->contact_company_id = $contact_company_id;
				$contact->email = $get->email;
				$contact->first_name = $get->first_name;
				$contact->last_name = $get->last_name;
				$contact->title = $get->title;

				$contact->convertPropertiesToData();
				$contact_id = $contact->save();
			}

			if ( isset($contact_company_office_id) && !empty($contact_company_office_id) && ($contact_company_office_id > 0)) {
				$contact->contact_id = $contact_id;
				$contact->linkContactToOffice($contact_company_office_id);
			}

			// @todo Save Phone and Fax Number for New Contacts
			$phone_number = $get->phone;
			$fax_number = $get->fax;

			// Phone Number is parsed and non-numeric values are removed
			if (isset($phone_number) && !empty($phone_number)) {
				try {
					$pn = PhoneNumber::parsePhoneNumber($phone_number);
					$area_code = $pn->area_code;
					$prefix = $pn->prefix;
					$number = $pn->number;

					$contactPhoneNumber = New ContactPhoneNumber($database);
					$contactPhoneNumber->contact_id = $contact_id;
					$contactPhoneNumber->area_code = $area_code;
					$contactPhoneNumber->prefix = $prefix;
					$contactPhoneNumber->number = $number;
					$contactPhoneNumber->phone_number_type_id = PhoneNumberType::BUSINESS;
					$contactPhoneNumber->convertPropertiesToData();
					$contactPhoneNumber->save();

				} catch (Exception $e) {
					trigger_error('Invalid Phone Number', E_USER_ERROR);
				}
			}

			// Fax Number is parsed and non-numeric values are removed
			if (isset($fax_number) && !empty($fax_number)) {
				try {
					$pn = PhoneNumber::parsePhoneNumber($fax_number);
					$area_code = $pn->area_code;
					$prefix = $pn->prefix;
					$number = $pn->number;

					$contactPhoneNumber = New ContactPhoneNumber($database);
					$contactPhoneNumber->contact_id = $contact_id;
					$contactPhoneNumber->area_code = $area_code;
					$contactPhoneNumber->prefix = $prefix;
					$contactPhoneNumber->number = $number;
					$contactPhoneNumber->phone_number_type_id = PhoneNumberType::BUSINESS_FAX;
					$contactPhoneNumber->convertPropertiesToData();
					$contactPhoneNumber->save();

				} catch (Exception $e) {
					trigger_error('Invalid Phone Number', E_USER_ERROR);
				}
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
			$error->outputErrorMessages();
			exit;
		}

		$db->throwExceptionOnDbError = false;

		$error = $message->getQueue($currentPhpScript, 'error');
		if (isset($error) && !empty($error)) {
			$errorMessage = join('<br>', $error);
			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			$resetToPreviousValue = 'Y';

			//$error->outputErrorMessages();
			//exit;
		}

		//TODO Get user_id from database if user invite was checked with contact creation.
		$user_id = 1;

		$customSuccessMessage = 'Contact successfully created.';

		$arrOutput = array(
			'user_id' => $user_id,
			'contact_id' => $contact_id,
			'customSuccessMessage' => $customSuccessMessage,
			'displayCustomSuccessMessage' => 'Y'
		);

		$output = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $output;

		break;

	case 'loadContactPermissions':

		$contact_company_id = (int) $get->contact_company_id;
		$contact_id = (int) $get->contact_id;

		// Load all owned projects for the active contact
		// This will be refactored later to avoid multiple iterations over the same result set...
		$arrProjectsByUserCompanyId = Project::loadProjectsByUserCompanyId($database, $user_company_id);
		//$arrProjectsList = Project::loadProjectsList($database, $user_company_id);
		//$arrUserCompanyProjectList = $arrProjectsList['objects_list'];
		//$arrUserCompanyProjectIds = array_keys($arrUserCompanyProjectList);

		// Load all Roles
		$arrAllRoles = Role::loadAllRoles($database);
		$arrAllRoleIds = array_keys($arrAllRoles);

		// Load all Contact Roles
		// Do not use the role_alias values for "Contact Roles"
		// Skip the "User" role
		$loadRolesByRoleGroupOptions = new Input();
		$loadRolesByRoleGroupOptions->role_group = 'contact_roles';
		$loadRolesByRoleGroupOptions->useRoleAliasesFlag = false;
		$loadRolesByRoleGroupOptions->skipUserRoleFlag = true;
		$arrContactRoles = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);
		$arrContactRoleIds = array_keys($arrContactRoles);

		// Load all Transmittal Admin Roles
		// Do not use the role_alias values for "Transmittal Admin Roles"
		// Skip the "User" roles Not In 33-Transmittal Admin,34 Transmittal User
		$loadRolesByRoleGroupOptions1 = new Input();
		$loadRolesByRoleGroupOptions1->role_group = 'transmittal_roles';
		$loadRolesByRoleGroupOptions1->useRoleAliasesFlag = false;
		$loadRolesByRoleGroupOptions1->skipUserRoleFlag = true;
		$whereIN = " AND rg2r.`role_id` IN (33,34)";
		$arrContactRoles1 = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions1, $whereIN);
		$arrContactRoleIds1 = array_keys($arrContactRoles1);
		/*Merge and join the two array contact_roles and transmittal roles*/
		$arrContactRoles = $arrContactRoles+$arrContactRoles1;
		$arrContactRoleIds = array_merge($arrContactRoleIds,$arrContactRoleIds1);
		
		// Load all Project Roles
		// Use the role_alias values for "Project Roles"
		// Skip the "User" role
		$loadRolesByRoleGroupOptions2 = new Input();
		$loadRolesByRoleGroupOptions2->role_group = 'project_roles';
		$loadRolesByRoleGroupOptions2->useRoleAliasesFlag = true;
		$loadRolesByRoleGroupOptions2->skipUserRoleFlag = true;
		$arrProjectRoles = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions2);
		$arrProjectRoleIds = array_keys($arrContactRoles);

		// Get a list of assigned roles by project for the selected Contact (contact_id)
		$arrProjectsToContactsToRolesByContactId = ProjectToContactToRole::loadProjectsToContactsToRolesByContactId($database, $contact_id);

		// Get a list of the assigned projects with role_id(s)
		$arrAssignedRolesByProjectId = array();
		$arrAssignedProjects = array();
		foreach ($arrProjectsToContactsToRolesByContactId as $projectToContactToRole) {
			/* @var $projectToContactToRole ProjectToContactToRole */

			$project_id = $projectToContactToRole->project_id;
			$role_id = $projectToContactToRole->role_id;

			$role = $arrAllRoles[$role_id];
			$arrAssignedRolesByProjectId[$project_id][$role_id] = $role;

			$project = $arrProjectsByUserCompanyId[$project_id];
			$arrAssignedProjects[$project_id] = $project;
		}

		$arrUnassignedProjects = array_diff($arrProjectsByUserCompanyId, $arrAssignedProjects);


		/*
		$contact->loadOwnedProjectRoles();
		$arrContactParentUserCompanyProjectsAndRoles = $contact->getParentUserCompanyProjectsAndRoles();
		$arrContactsProjectListIds = array_keys($arrContactParentUserCompanyProjectsAndRoles);
		*/

		$contact = Contact::findContactByIdExtended($database, $contact_id);
		/* @var $contact Contact */

		//$contact->loadContactCompany();
		$contactCompany = $contact->getContactCompany();
		/* @var $contactCompany ContactCompany */

		$fullName = $contact->getContactFullName();

		if ($user_id == $contact->user_id) {
			$fullName .= ' (My Record)';
		}

		//$arrProjectsToDisplay = array_diff($arrProjectsByUserCompanyId, $arrContactsProjectListIds);

		$myCompanyDataCase = false;
		if ($user_company_id == $contactCompany->contact_user_company_id) {
			$myCompanyDataCase = true;
		}

		// Contact Roles (not project_id specific)
		//if ($myCompanyDataCase) {
			$arrAssignedRolesByContactId = Role::loadAssignedRolesByContactId($database, $contact_id);
			$arrAssignedRoleIdsByContactId = array_keys($arrAssignedRolesByContactId);
			// Display the list of Contact Roles that have yet to be assigned to the given contact_id
			$arrEligibleContactRoles = array_diff($arrContactRoleIds, $arrAssignedRoleIdsByContactId);
			require('include/page-components/contacts_to_roles.php');
			echo $htmlContent;
		//}

		require('include/page-components/projects_to_contacts_to_roles.php');
		echo $htmlContent;

	break;

	case 'loadArchivedContactPermissions':
		$contact_company_id = (int) $get->contact_company_id;
		$contact_id = (int) $get->contact_id;

		// Load all owned projects for the active contact
		// This will be refactored later to avoid multiple iterations over the same result set...
		$arrProjectsByUserCompanyId = Project::loadProjectsByUserCompanyId($database, $user_company_id);

		// Load all Roles
		$arrAllRoles = Role::loadAllRoles($database);
		$arrAllRoleIds = array_keys($arrAllRoles);

		// Load all Contact Roles
		// Do not use the role_alias values for "Contact Roles"
		// Skip the "User" role
		$loadRolesByRoleGroupOptions = new Input();
		$loadRolesByRoleGroupOptions->role_group = 'contact_roles';
		$loadRolesByRoleGroupOptions->useRoleAliasesFlag = false;
		$loadRolesByRoleGroupOptions->skipUserRoleFlag = true;
		$arrContactRoles = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);
		$arrContactRoleIds = array_keys($arrContactRoles);

		// Load all Transmittal Admin Roles
		// Do not use the role_alias values for "Transmittal Admin Roles"
		// Skip the "User" roles Not In 33-Transmittal Admin,34 Transmittal User
		$loadRolesByRoleGroupOptions1 = new Input();
		$loadRolesByRoleGroupOptions1->role_group = 'transmittal_roles';
		$loadRolesByRoleGroupOptions1->useRoleAliasesFlag = false;
		$loadRolesByRoleGroupOptions1->skipUserRoleFlag = true;
		$whereIN = " AND rg2r.`role_id` IN (33,34)";
		$arrContactRoles1 = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions1, $whereIN);
		$arrContactRoleIds1 = array_keys($arrContactRoles1);
		/*Merge and join the two array contact_roles and transmittal roles*/
		$arrContactRoles = $arrContactRoles+$arrContactRoles1;
		$arrContactRoleIds = array_merge($arrContactRoleIds,$arrContactRoleIds1);
		
		// Load all Project Roles
		// Use the role_alias values for "Project Roles"
		// Skip the "User" role
		$loadRolesByRoleGroupOptions2 = new Input();
		$loadRolesByRoleGroupOptions2->role_group = 'project_roles';
		$loadRolesByRoleGroupOptions2->useRoleAliasesFlag = true;
		$loadRolesByRoleGroupOptions2->skipUserRoleFlag = true;
		$arrProjectRoles = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions2);
		$arrProjectRoleIds = array_keys($arrContactRoles);

		// Get a list of assigned roles by project for the selected Contact (contact_id)
		$arrProjectsToContactsToRolesByContactId = ProjectToContactToRole::loadProjectsToContactsToRolesByContactId($database, $contact_id);

		// Get a list of the assigned projects with role_id(s)
		$arrAssignedRolesByProjectId = array();
		$arrAssignedProjects = array();
		foreach ($arrProjectsToContactsToRolesByContactId as $projectToContactToRole) {

			$project_id = $projectToContactToRole->project_id;
			$role_id = $projectToContactToRole->role_id;

			$role = $arrAllRoles[$role_id];
			$arrAssignedRolesByProjectId[$project_id][$role_id] = $role;

			$project = $arrProjectsByUserCompanyId[$project_id];
			$arrAssignedProjects[$project_id] = $project;
		}

		$arrUnassignedProjects = array_diff($arrProjectsByUserCompanyId, $arrAssignedProjects);

		$contact = Contact::findContactByIdExtended($database, $contact_id);

		$contactCompany = $contact->getContactCompany();

		$fullName = $contact->getContactFullName();

		if ($user_id == $contact->user_id) {
			$fullName .= ' (My Record)';
		}

		$myCompanyDataCase = false;
		if ($user_company_id == $contactCompany->contact_user_company_id) {
			$myCompanyDataCase = true;
		}

		$arrAssignedRolesByContactId = Role::loadAssignedRolesByContactId($database, $contact_id);
		$arrAssignedRoleIdsByContactId = array_keys($arrAssignedRolesByContactId);
		// Display the list of Contact Roles that have yet to be assigned to the given contact_id
		$arrEligibleContactRoles = array_diff($arrContactRoleIds, $arrAssignedRoleIdsByContactId);
		require('include/page-components/archived_contacts_to_roles.php');
		echo $htmlContent;

		require('include/page-components/archived_projects_to_contacts_to_roles.php');
		echo $htmlContent;
	break;

	case 'updateOfficeDDL':

		$contact_id = $get->contact_id;
		$contact_company_id = $get->contact_company_id;

		$message->enqueueError('|Unable to update the office drop down list', $currentPhpScript);

		$contact = new Contact($database);
		$contact->contact_id = $contact_id;
		// Load this contacts primary office
		$contact->loadOfficeList(true);

		$arrOffices = $contact->getOfficeList();
		if (count($arrOffices) > 0) {
			$cco = $arrOffices[0];
			$selectedOfficeId = $cco->contact_company_office_id;
		} else {
			$selectedOfficeId = 0;
		}

		$ddlOffices = createOfficeDropDownWithSelection($database, $contact_company_id, $contact_id, $selectedOfficeId, 406, false);

		echo $ddlOffices;

		break;

	case 'deleteOffice':
		$contact_company_office_id = $get->contact_company_office_id;
		$elementId = $get->elementId;

		$message->enqueueError('|Unable to delete office', $currentPhpScript);

		// Delete all phone numbers first
		$loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdOptions = new Input();
		$loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdOptions->forceLoadFlag = true;
		$arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId =
			ContactCompanyOfficePhoneNumber::loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeId($database, $contact_company_office_id, $loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdOptions);
		foreach ($arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId as $contactCompanyOfficePhoneNumber) {
			$contactCompanyOfficePhoneNumber->delete();
		}

		$contactCompanyOffice = new ContactCompanyOffice($database);
		$contactCompanyOffice->contact_company_office_id = $contact_company_office_id;
		$contactCompanyOffice->deleteOffice();
		echo $elementId;

		/*

		// We want to do more than this once the class is built.
		// Like if remove it then change other contacts that were using this to the headquarters
		// Or set to zero if this is the last office being deleted
		// Stuff like that.

		// TODO:Are all the above things done?

		*/
		break;

	case 'updateCompanyField':
		$errorNumber = 1;
		$elementId = $get->elementId;
		$arrParts = explode('_',$elementId);
		$fieldType = $arrParts[0];
		$message->enqueueError($elementId . '|Changes not saved!', $currentPhpScript);
		$newValue = $get->newValue;
		$contact_company_id = $get->contact_company_id;

		$dbField = '';
		$inputCommonName = '';
		$objToUpdate = '';
		switch ($fieldType) {
			case 'companyName':
				$dbField = 'company';
				$inputCommonName = 'Company name';
				$objToUpdate = 'company';
				break;
			case 'taxID':
				$dbField = 'employer_identification_number';
				$inputCommonName = 'Federal identification number';
				$objToUpdate = 'company';
				break;
			case 'license':
				$dbField = 'construction_license_number';
				$inputCommonName = 'License';
				$objToUpdate = 'company';
				break;
			case 'licenseDate':
				$dbField = 'construction_license_number_expiration_date';
				$inputCommonName = 'License expiration date';
				$objToUpdate = 'company';
				//$newValue = convertHTMLStringToDatabaseDate($newValue);
				$newValue = Date::convertDateTimeFormat($newValue, 'database_date');
				break;
			case 'businessPhone':
				$dbField = 'phone';
				$inputCommonName = 'Phone';
				$objToUpdate = 'companyPhone';
				$phone_number_type_id = PhoneNumberType::BUSINESS;
				break;
			case 'businessFax':
				$dbField = 'fax';
				$inputCommonName = 'Fax';
				$objToUpdate = 'companyPhone';
				$phone_number_type_id = PhoneNumberType::BUSINESS_FAX;
				break;
		}

		if ($objToUpdate == 'company') {
			$contactCompany = new ContactCompany($database);
			$key = array('id' => $contact_company_id);
			$contactCompany->setKey($key);
			$contactCompany[$dbField] = $newValue;
			$contactCompany->save();
			$errorNumber = 0;
		} elseif ($objToUpdate == 'companyPhone') {
			// @TODO: Add the ability to save phone/fax numbers for companies.
			//$contact_phone_number_id = $get->contact_phone_number_id;

			// Phone Number is parsed and non-numeric values are removed
/*
			if (isset($newValue) && !empty($newValue)) {
				$arrPhoneNumber = PhoneNumberType::parsePhoneNumber($newValue);
				$area_code = $arrPhoneNumber['area_code'];
				$prefix = $arrPhoneNumber['prefix'];
				$number = $arrPhoneNumber['number'];
			} else {
				$area_code = '';
				$prefix = '';
				$number = '';
			}

			// delete case
			if (!empty($contact_phone_number_id) && empty($area_code) && empty($prefix) && empty($number)) {
				$ormAction = 'delete';
			} else {
				$ormAction = 'save';
			}

			// Sanity check/final validation of phone number values
			if ($ormAction == 'save') {
				// area_code
				if (empty($area_code) || (strlen($area_code) != 3)) {
					trigger_error('Invalid Phone Number Area Code', E_USER_ERROR);
				}

				// prefix
				if (empty($prefix) || (strlen($prefix) != 3)) {
					trigger_error('Invalid Phone Number Prefix', E_USER_ERROR);
				}

				// number
				if (empty($number) || (strlen($number) != 4)) {
					trigger_error('Invalid Phone Number', E_USER_ERROR);
				}
			}

			// contact_phone_numbers table
			// unique index(`contact_id`, `phone_number_type_id`, `country_code`, `area_code`, `prefix`, `number`, `extension`, `itu`),
			$contactPhoneNumber = new ContactPhoneNumber($database);
			if (isset($contact_phone_number_id) && !empty($contact_phone_number_id)) {
				$key = array('id' => $contact_phone_number_id);
				$contactPhoneNumber->setKey($key);
			}

			if ($ormAction == 'save') {
				$data = array(
						'contact_id' => $contact_id,
						'phone_number_type_id' => $phone_number_type_id,
						'country_code' => '', // add this later...
						'area_code' => $area_code,
						'prefix' => $prefix,
						'number' => $number,
						'extension' => '', // add this later...
						'itu' => '',
				);
				$contactPhoneNumber->setData($data);
				$contactPhoneNumber->save();
			} elseif ($ormAction == 'delete') {
				$contactPhoneNumber->delete();
			}
*/
		} else {
/*
			$cpn = new ContactPhoneNumber();
			$cpn->contact_phone_number_id = $contact_id;
			$cpn->phone_number_type_id = $phoneType;
			$cpn->area_code;
			$cpn->prefix;
			$cpn->number;
			//$cpn->extension;

			$key = array('id' => $contact_id);
			$contact->setKey($key);
			$contact[$dbField] = $newValue;
			$contact->save();
*/
		}

		$customSuccessMessage = $inputCommonName . ' successfully updated.';

		$arrOutput = array(
			'errorNumber'=> $errorNumber,
			'attributeName' => $elementId,
			'customSuccessMessage' => $customSuccessMessage,
			'errorMessage'=>$customSuccessMessage,
			'displayCustomSuccessMessage' => 'Y'
		);

		$output = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $output;

		break;

	case 'updateOfficePhoneNumber':
		//$message->enqueueError($elementId . '|Changes not saved!', $currentPhpScript);
		$message->reset($currentPhpScript);
		$errorNumber = 1;

		$elementId = $get->elementId;
		$newValue = $get->newValue;
		$contact_company_office_id = $get->contact_company_office_id;
		$contact_company_office_phone_number_id = $get->contact_company_office_phone_number_id;
		$phone_number_type_id = $get->phone_number_type_id;

		if (isset($newValue) && !empty($newValue)) {
			$arrPhoneNumber = PhoneNumberType::parsePhoneNumber($newValue);
			$area_code = $arrPhoneNumber['area_code'];
			$prefix = $arrPhoneNumber['prefix'];
			$number = $arrPhoneNumber['number'];
		} else {
			$area_code = '';
			$prefix = '';
			$number = '';
		}

		// delete case
		if (!empty($contact_company_office_phone_number_id) && empty($area_code) && empty($prefix) && empty($number)) {
			$ormAction = 'delete';
		} else {
			$ormAction = 'save';
			$data = array(
					'contact_company_office_id' => $contact_company_office_id,
					'phone_number_type_id' => $phone_number_type_id,
					'country_code' => '', // add this later...
					'area_code' => $area_code,
					'prefix' => $prefix,
					'number' => $number,
					'extension' => '', // add this later...
					'itu' => '',
			);
		}

		// @todo FIX ERROR HANDLING HERE
		// Sanity check/final validation of phone number values
		if ($ormAction == 'save') {
			// area_code
			if (empty($area_code) || (strlen($area_code) != 3)) {
				$errorMessage = 'Invalid Phone Number Area Code';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}

			// prefix
			if (empty($prefix) || (strlen($prefix) != 3)) {
				$errorMessage = 'Invalid Phone Number Prefix';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}

			// number
			if (empty($number) || (strlen($number) < 4)) {
				$errorMessage = 'Invalid Phone Number';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}
		}

		// contact_phone_numbers table
		// unique index(`contact_id`, `phone_number_type_id`, `country_code`, `area_code`, `prefix`, `number`, `extension`, `itu`),

		if (isset($contact_company_office_phone_number_id) && !empty($contact_company_office_phone_number_id)) {
			$contactCompanyOfficePhoneNumber = ContactCompanyOfficePhoneNumber::findById($database, $contact_company_office_phone_number_id);
		} else {
			$contactCompanyOfficePhoneNumber = new ContactCompanyOfficePhoneNumber($database);
			$contactCompanyOfficePhoneNumber->setKey($data);
			$contactCompanyOfficePhoneNumber->load();

			if ($contactCompanyOfficePhoneNumber->isDataLoaded()) {
				$errorMessage = 'Phone number already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}
		}

		$error = $message->getQueue($currentPhpScript, 'error');
		if (isset($error) && !empty($error)) {
			$errorMessage = join('<br>', $error);
			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			$resetToPreviousValue = 'Y';
			$message->enqueueError($errorMessage, $currentPhpScript);

		
			exit;
		}

		if ($ormAction == 'save') {
			$contactCompanyOfficePhoneNumber->setData($data);
			if (!isset($contact_company_office_phone_number_id) || empty($contact_company_office_phone_number_id)) {
				$contactCompanyOfficePhoneNumber->setKey(null);
				$contact_company_office_phone_number_id = $contactCompanyOfficePhoneNumber->save();
			} else {
				$contactCompanyOfficePhoneNumber->save();
			}
			$errorNumber = 0;

		} elseif ($ormAction == 'delete') {
			$contactCompanyOfficePhoneNumber->delete();
		}

		$inputCommonName = 'Phone Number';
		$customSuccessMessage= ucwords($elementId) . ' was successfully Updated.';
		$customerrorMessage= ucwords($elementId) . ' was not Updated.';
		$arrOutput = array(
			'errorNumber'=> $errorNumber,
			'attributeName' => $elementId,
			'customSuccessMessage' => $customSuccessMessage,
			'errorMessage'=>$customSuccessMessage,
			'displayCustomSuccessMessage' => 'Y'
		);

		$output = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $output;
		break;

	case 'updateContactField':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		// Update case may check permissions by Attribute so retrieve inputs first
		// Ajax Handler Inputs
		require('code-generator/ajax-get-inputs.php');
		$primaryKeyAsString = $uniqueId;



		$contact_id = Data::parseInt($uniqueId);
		$fieldType = $attributeName;
		$message->reset($currentPhpScript);
		$message->enqueueError($attributeName . ' | Changes not saved!', $currentPhpScript);
		//$newValue = $get->newValue;

		$contact = Contact::findContactById($database, $contact_id);
		$newUserData = array();
		$userExisting = false;

		$dbField = '';
		$inputCommonName = '';
		$objToUpdate = '';

		$db->begin();

		switch ($fieldType) {
			case 'first_name':
				$dbField = 'first_name';
				$inputCommonName = 'First name';
				$objToUpdate = 'contact';
				break;
			case 'last_name':
				$dbField = 'last_name';
				$inputCommonName = 'Last name';
				$objToUpdate = 'contact';
				break;
			case 'title':
				$dbField = 'title';
				$inputCommonName = 'Title';
				$objToUpdate = 'contact';
				break;
			case 'email':
				// Email is required
				if (!empty($newValue)) {
					// Validate the email address
					$validEmailFlag = Validate::email2($newValue);
					if (!$validEmailFlag) {
						$db->rollback();
						/*$message->enqueueError('Invalid Email Address', $currentPhpScript);
						trigger_error('');*/
						$errorNumber = 1;
						$errorMessage = "Invalid Email Address";
						$message->enqueueError($errorMessage, $currentPhpScript);
						break;
						// throw new Exception($errorMessage);
						// exit;
					}
				}
				// UUID uniqueness
				if ($contact->user_id <> $AXIS_NON_EXISTENT_USER_ID) {
					// Check existence - required for registered user case
					if (empty($newValue)) {
						$db->rollback();
						/*$message->enqueueError('Email address is a required field for registered users.', $currentPhpScript);
						trigger_error('');*/
						$errorNumber = 1;
						$errorMessage = "Email address is a required field for registered users.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						break;
						// exit;
					}
				}
				// Check uniqueness against users table if set
				if (!empty($newValue)) {
					if ($contact->user_id <> $AXIS_NON_EXISTENT_USER_ID) {
						$tmpUserId = User::findUserIdByEmail($database, $newValue);
						if ($tmpUserId && ($tmpUserId <> $contact->user_id)) {
							$db->rollback();
							/*$message->enqueueError('Please enter a different email address. This one is already in use.', $currentPhpScript);
							trigger_error('');*/
							$errorNumber = 1;
							$errorMessage = "Please enter a different email address. This one is already in use.";
							$message->enqueueError($errorMessage, $currentPhpScript);
							break;
							// exit;
						}
					}
				}
				$dbField = 'email';
				$inputCommonName = 'Email';
				$objToUpdate = 'contact';
				if ($contact->user_id <> $AXIS_NON_EXISTENT_USER_ID) {
					if (!empty($newValue)) {
						$newUserData['email'] = $newValue;
					} else {
						$newUserData['email'] = null; // this allows our unique index
					}
				}
				break;
			case 'mobilephone':
				// Phone Number is parsed and non-numeric values are removed
				if (isset($newValue) && !empty($newValue)) {
					try {
						// Sanity check/final validation of phone number values
						$pn = PhoneNumber::parsePhoneNumber($newValue);
						$area_code = $pn->area_code;
						$prefix = $pn->prefix;
						$number = $pn->number;
					} catch (Exception $e) {
						$db->rollback();
						/*$message->enqueueError('Invalid Phone Number', $currentPhpScript);
						trigger_error('');*/
						$errorNumber = 1;
						$errorMessage = "Invalid Phone Number";
						$message->enqueueError($errorMessage, $currentPhpScript);
						break;
						// exit;
					}
				} else {
					$area_code = '';
					$prefix = '';
					$number = '';
				}
				$mobile_phone_number = $area_code.$prefix.$number;

				$dbField = 'mobilephone';
				$inputCommonName = 'Mobile Phone';
				$objToUpdate = 'contactPhone';
				$phone_number_type_id = PhoneNumberType::MOBILE;
				$mobile_network_carrier_id = Data::parseInt($get->mobile_network_carrier_id);

				// UUID uniqueness
				if (!empty($mobile_phone_number)) {
					if ($contact->user_id <> $AXIS_NON_EXISTENT_USER_ID) {
						$tmpUserId = User::findUserIdByMobilePhoneNumber($database, $mobile_phone_number);
						if ($tmpUserId && ($tmpUserId <> $contact->user_id)) {
							$db->rollback();
							/*$message->enqueueError('Please enter a different mobile phone number. This one is already in use.', $currentPhpScript);
							trigger_error('');*/
							$errorNumber = 1;
							$errorMessage = "Please enter a different mobile phone number. This one is already in use.";
							$message->enqueueError($errorMessage, $currentPhpScript);
							break;
							// exit;
						}
						if ($contact->user_id <> $AXIS_NON_EXISTENT_USER_ID) {
							$newUserData['mobile_phone_number'] = $mobile_phone_number;
						}
					}
				} else {
					if ($contact->user_id <> $AXIS_NON_EXISTENT_USER_ID) {
						$newUserData['mobile_phone_number'] = null; // this allows our unique index
					}
				}
				break;
			case 'phone':
				// Phone Number is parsed and non-numeric values are removed
				if (isset($newValue) && !empty($newValue)) {
					try {
						// Sanity check/final validation of phone number values
						$pn = PhoneNumber::parsePhoneNumber($newValue);
						$area_code = $pn->area_code;
						$prefix = $pn->prefix;
						$number = $pn->number;
					} catch (Exception $e) {
						$db->rollback();
						/*$message->enqueueError('Invalid Phone Number', $currentPhpScript);
						trigger_error('');*/
						$errorNumber = 1;
						$errorMessage = "Invalid Phone Number";
						$message->enqueueError($errorMessage, $currentPhpScript);
						break;
					}
				} else {
					$area_code = '';
					$prefix = '';
					$number = '';
				}

				$dbField = 'phone';
				$inputCommonName = 'Business Phone';
				$objToUpdate = 'contactPhone';
				$phone_number_type_id = PhoneNumberType::BUSINESS;
				break;
			case 'fax':
				// Phone Number is parsed and non-numeric values are removed
				if (isset($newValue) && !empty($newValue)) {
					try {
						// Sanity check/final validation of phone number values
						$pn = PhoneNumber::parsePhoneNumber($newValue);
						$area_code = $pn->area_code;
						$prefix = $pn->prefix;
						$number = $pn->number;
					} catch (Exception $e) {
						$db->rollback();
						/*$message->enqueueError('Invalid Fax Number', $currentPhpScript);
						trigger_error('');*/
						$errorNumber = 1;
						$errorMessage = "Invalid Fax Number";
						$message->enqueueError($errorMessage, $currentPhpScript);
						break;
					}
				} else {
					$area_code = '';
					$prefix = '';
					$number = '';
				}

				$dbField = 'fax';
				$inputCommonName = 'Business Fax';
				$objToUpdate = 'contactPhone';
				$phone_number_type_id = PhoneNumberType::BUSINESS_FAX;
				/*
				$phone_number_type_id = $get->phone_number_type_id;
				if (!isset($phone_number_type_id) || empty($phone_number_type_id)) {
					$phone_number_type_id = PhoneNumberType::BUSINESS_FAX;
				}
				*/
				break;
		}
		if($errorNumber == 1){
			$attributeGroupName='';
			$displayErrorMessage = 'Y';
			$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
			if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
				$errorNumber = 1;
				$errorMessage = join('<br>', $arrErrorMessages);
			}

			if (isset($responseDataType) && ($responseDataType == 'json')) {
				require('code-generator/json-response.php');
			}
			if ($jsonFlag) {
						// Send HTTP Content-Type header to alert client of JSON output
				header('Content-Type: application/json');
			}
			echo $output;
						// echo $output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlContent";
			exit;
		}
		// Deltify and save user data
		if (!empty($newUserData)) {
			$userExisting = User::findUserById($database, $contact->user_id);
			//$userExisting = User::findUserByPrimaryContactId($database, $contact_id);
			/* @var $userExisting User */

			// Check that a user record exists and that this contact is the "primary contact"
			if ($userExisting && ($userExisting->user_company_id == $user_company_id)) {
				$userNewData = new User($database);
				$userNewData->setData($newUserData);
				/* @var $userNewData User */

				$u = IntegratedMapper::deltifyAndUpdate($userExisting, $userNewData);
				/* @var $u User */
			}
		}

		if ($objToUpdate == "contact") {
			// Update contact information
			// Note: $contact = Contact::findContactById($database, $contact_id); is at the top of this case or "ajax method"
			//$contactExisting = Contact::findContactById($database, $contact_id);
			$contactExisting = $contact;
			$tmpData = array($dbField => $newValue);
			$contactNewData = new Contact($database);
			$contactNewData->setData($tmpData);
			$c = IntegratedMapper::deltifyAndUpdate($contactExisting, $contactNewData);
			/* @var $contactExisting Contact */
			/* @var $contactNewData Contact */
			/* @var $c Contact */

			/*
			$contact = new Contact($database);
			$key = array('id' => $contact_id);
			$contact->setKey($key);
			$contact[$dbField] = $newValue;
			$contact->save();
			*/
		} elseif ($objToUpdate == "contactPhone") {
			$contact_phone_number_id = $get->contact_phone_number_id;

			// delete case
			if (!empty($contact_phone_number_id) && empty($area_code) && empty($prefix) && empty($number)) {
				$ormAction = 'delete';
			} elseif (empty($contact_phone_number_id) && empty($area_code) && empty($prefix) && empty($number)) {
				$ormAction = 'delete';
			} else {
				$ormAction = 'save';
			}

			// contact_phone_numbers table
			// unique index(`contact_id`, `phone_number_type_id`),
			// unique index(`contact_id`, `phone_number_type_id`, `country_code`, `area_code`, `prefix`, `number`, `extension`, `itu`),
			$contactPhoneNumber = new ContactPhoneNumber($database);
			if (isset($contact_phone_number_id) && !empty($contact_phone_number_id)) {
				$key = array('id' => $contact_phone_number_id);
			} else {
				//unique index(`contact_id`, `phone_number_type_id`)
				$key = array(
					'contact_id' => $contact_id,
					'phone_number_type_id' => $phone_number_type_id
				);
			}

			// Check for existing data case
			$contactPhoneNumber->setKey($key);
			$contactPhoneNumber->load();
			$isDataLoaded = $contactPhoneNumber->isDataLoaded();
			if ($isDataLoaded) {
				$contactPhoneNumber->convertDataToProperties();
				$contact_phone_number_id = $contactPhoneNumber->contact_phone_number_id;
			} else {
				$contactPhoneNumber->setKey(null);
			}

			// Update mobile_phone_number in the users table if appropriate
			if ($ormAction == 'save') {
				$data = array(
					'contact_id' => $contact_id,
					'phone_number_type_id' => $phone_number_type_id,
					'country_code' => '', // add this later...
					'area_code' => $area_code,
					'prefix' => $prefix,
					'number' => $number,
					'extension' => '', // add this later...
					'itu' => '',
				);
				$contactPhoneNumber->setData($data);
				if ($isDataLoaded) {
					$contactPhoneNumber->save();
				} else {
					$contact_phone_number_id = $contactPhoneNumber->save();
				}
			} elseif ($ormAction == 'delete') {
				// Sanity check
				$key = $contactPhoneNumber->getKey();
				if (isset($key) && !empty($key) && isset($contact_phone_number_id) && !empty($contact_phone_number_id)) {
					$contactPhoneNumber->delete();
				} else {
					// Derive key
					$key = array(
						'contact_id' => $contact->contact_id,
						'phone_number_type_id' => $phone_number_type_id
					);
					$contactPhoneNumber->setKey($key);
					$contactPhoneNumber->delete();
				}
			}
			if ($phone_number_type_id == PhoneNumberType::MOBILE) {
				// mobile_phone_numbers only exist for registered users???
				//if ($userExisting) {
					if ($ormAction == 'save') {
						// Check if the mobile_phone_number already exists in the users table

						// Insert into mobile_phone_numbers if not already in use
						// UUID check occurred above so okay
						if (
							//isset($contact->user_id) && !empty($contact->user_id) &&
							isset($contact_id) && !empty($contact_id) &&
							isset($contact_phone_number_id) && !empty($contact_phone_number_id) &&
							isset($mobile_network_carrier_id) && !empty($mobile_network_carrier_id)) {

							$mobilePhoneNumber = new MobilePhoneNumber($database);

							// Check for existing data case
							$key = array(
								'contact_id' => $contact_id,
								'contact_phone_number_id' => $contact_phone_number_id
							);
							$mobilePhoneNumber->setKey($key);
							$mobilePhoneNumber->load();
							$isDataLoaded = $mobilePhoneNumber->isDataLoaded();
							if (!$isDataLoaded) {
								$mobilePhoneNumber->setKey(null);
							}

							//$mobilePhoneNumber->user_id = $contact->user_id;
							$mobilePhoneNumber->contact_id = $contact_id;
							$mobilePhoneNumber->contact_phone_number_id = $contact_phone_number_id;
							$mobilePhoneNumber->mobile_network_carrier_id = $mobile_network_carrier_id;
							$mobilePhoneNumber->convertPropertiesToData();
							$mobilePhoneNumber->save();
						}
					} elseif ($ormAction == 'delete') {
						// Delete from mobile_phone_numbers
						$mobilePhoneNumber = new MobilePhoneNumber($database);
						if (isset($contact_phone_number_id) && !empty($contact_phone_number_id)) {
							$key = array(
								//'user_id' => $contact->user_id,
								'contact_id' => $contact_id,
								'contact_phone_number_id' => $contact_phone_number_id
							);
						} else {
							// @todo fix the JavaScript to return the $contact_phone_number_id
							$key = array(
								//'user_id' => $contact->user_id,
								'contact_id' => $contact_id
							);
						}
						$mobilePhoneNumber->setKey($key);
						$mobilePhoneNumber->delete();
					}
				//}
			}
		} else {
			/*
			$cpn = new ContactPhoneNumber();
			$cpn->contact_phone_number_id = $contact_id;
			$cpn->phone_number_type_id = $phoneType;
			$cpn->area_code;
			$cpn->prefix;
			$cpn->number;
			//$cpn->extension;

			$key = array('id' => $contact_id);
			$contact->setKey($key);
			$contact[$dbField] = $newValue;
			$contact->save();
			*/
		}

		$db->commit();

		$errorMessage = 'Contact was successfully updated.';

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = $attributeName . '|' . $inputCommonName . ' was successfully updated.';
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

		break;

	case 'saveContactOffice':
		$contact_company_office_id = $get->contact_company_office_id;
		$contact_id = $get->contact_id;

		$message->enqueueError('|Unable to save office change', $currentPhpScript);

		if ($contact_company_office_id > 0) {
			$contact = new Contact($database);
			$contact->contact_id = $contact_id;
			$contact->linkContactToOffice($contact_company_office_id);
		}

		echo 'Office change was successfully updated.';

		break;

	case 'addContactToProject':

		$project_id = $get->project_id;
		$contact_id = $get->contact_id;

		$message->enqueueError('Contact Could Not Be Added!', $currentPhpScript);

		ProjectToContactToRole::addContactToProject($database, $project_id, $contact_id);

		echo $contact_id;

		break;

	case 'removeContactFromProject':

		$project_id = $get->project_id;
		$contact_id = $get->contact_id;

		$message->enqueueError('Contact Could Not Be Deleted!', $currentPhpScript);

		ProjectToContactToRole::removeContactFromProject($database, $project_id, $contact_id);

		echo $contact_id;

		break;

	case 'addRoleToContactOnProject':

		$project_id = $get->project_id;
		$contact_id = $get->contact_id;
		$role_id = $get->role_id;

		$message->enqueueError('Role Could Not Be Added To Contact!', $currentPhpScript);

		ProjectToContactToRole::addRoleToContactOnProject($database, $project_id, $contact_id, $role_id);

		echo $contact_id;

		break;

	case 'removeRoleFromContactOnProject':

		$project_id = $get->project_id;
		$contact_id = $get->contact_id;
		$role_id = $get->role_id;

		$message->enqueueError('Role Could Not Be Removed!', $currentPhpScript);

		ProjectToContactToRole::removeRoleFromContactOnProject($database, $project_id, $contact_id, $role_id);

		echo $contact_id;

		break;

	case 'addRoleToContact':

		$contact_id = $get->contact_id;
		$role_id = $get->role_id;

		$message->enqueueError('Role Could Not Be Added To Contact!', $currentPhpScript);

		ContactToRole::addRoleToContact($database, $contact_id, $role_id);

		echo $contact_id;

		break;

	case 'removeRoleFromContact':

		$contact_id = $get->contact_id;
		$role_id = $get->role_id;

		$message->enqueueError('Role Could Not Be Removed!', $currentPhpScript);

		ContactToRole::removeRoleFromContact($database, $contact_id, $role_id);

		echo $contact_id;

		break;

	case 'toggleAdministrator':
		$contact_id = (int) $get->contact_id;

		$message->enqueueError('Adminstrator Role Could Not Be Added', $currentPhpScript);

		$contact = Contact::findById($database, $contact_id);
		/* @var $contact Contact */

		$contact->toggleAdmin();

		echo $contact_id;

		break;

	case 'addTradeToContactCompany':

		// @todo Fix for my vs third party data cases and correct permissions
		if ($userCanManageMyContacts || $userCanManageThirdPartyContacts) {
			$userCanManageContacts = true;
		}

		// Default value of empty string
		$content = '';

		if (($userCanManageMyCompanyTrades || $userCanManageThirdPartyCompanyTrades) && $get->contact_company_id && $get->cost_code_id) {
			// Add a trade to a subcontractor

			$contact_company_id = (int) $get->contact_company_id;

			// Multiple select box provides CSV list of cost_code_id values
			$tmpCostCode = $get->cost_code_id;
			$arrCostCodes = explode(',', $tmpCostCode);

			foreach ($arrCostCodes as $cost_code_id) {
				$cost_code_id = (int) $cost_code_id;
				$query =
"
INSERT IGNORE
INTO subcontractor_trades (contact_company_id, cost_code_id)
VALUES(?,?)
";
				$arrValues = array($contact_company_id, $cost_code_id);
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				$db->free_result();
			}

			$content = getContactCompanyTradesTable($database, $user_company_id, $contact_company_id, $userCanManageContacts);
		}

		echo $content;
		break;

	case 'removeTradeFromContactCompany':

		// Default value of empty string
		$content = '';

		//$userCanManageMyContacts;
		//$userCanManageThirdPartyContacts;
		if ($userCanManageThirdPartyContacts) {
			// Remove a trade from a subcontractor
			$contact_company_id = (int) $get->contact_company_id;
			$cost_code_id = (int) $get->cost_code_id;

			$query =
"
DELETE
FROM `subcontractor_trades`
WHERE `contact_company_id` = ?
AND `cost_code_id` = ?
";
			$arrValues = array($contact_company_id, $cost_code_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$content = getContactCompanyTradesTable($database, $user_company_id, $contact_company_id, $userCanManageThirdPartyContacts);
		}

		echo $content;
		break;

	case 'rendorCreateContactForm':

		$contact_company_id = (int) $get->contact_company_id;

		$contactCompany = ContactCompany::findById($database, $contact_company_id);

		$myCompanyDataCase = false;
		if ($user_company_id == $contactCompany->contact_user_company_id) {
			$myCompanyDataCase = true;
		}

		$userCanManageContacts = false;
		if ($myCompanyDataCase && $userCanManageMyContacts) {
			$userCanManageContacts = true;
		} elseif (!$myCompanyDataCase && $userCanManageThirdPartyContacts) {
			$userCanManageContacts = true;
		}

		// @todo error here.
		if (!$userCanManageContacts) {
			echo '';
			break;
		}

		$htmlContent = require('include/page-components/contact_creation_form.php');

		echo $htmlContent;
		break;

	case 'loadCreateContactCompanyDialog':

		$content = buildCreateContactCompanyWidget(false, 'createContactCompanyAndReloadDdlContactCompaniesViaPromiseChain');
		echo $content;

		break;

	case 'loadCreateContactCompanyOfficeDialog':

		$contact_company_id = $get->contact_company_id;
		$small = false;
		$helperFunction = 'Contacts_Manager__createContactCompanyOffice';
		$content = buildCreateContactCompanyOfficeWidget($database, $contact_company_id, $small, $helperFunction);
		echo $content;

		break;

	case 'reloadDllContactCompanies':

		$htmlContent = '';
		$arrContactCompaniesByUserUserCompanyId = ContactCompany::loadContactCompaniesByUserUserCompanyId($database, $user_company_id);
		foreach($arrContactCompaniesByUserUserCompanyId as $contact_company_id => $contactCompany) {
			$company = $contactCompany->company;
			$htmlContent .= '<option value="'.$contact_company_id.'">'.$company.'</option>';
		}
		$arrOutput = array(
			'htmlContent' => $htmlContent
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

}

ob_flush();
exit;
