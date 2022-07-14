<?php
/**
 * User Company.
 *
 */
$init['access_level'] = 'global_admin';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['post_required'] = true;
require_once('lib/common/init.php');



$db = DBI::getInstance($database);
/* @var $db DBI_mysqli */

/* @var $post Egpcs */
$post->sessionClear();

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset();

$session->setFormSubmitted(true);


// Error Handling - user_companies
// Verify User Company
if (!$post->user_company_name) {
	$message->enqueueError('Please enter a valid user company.', 'admin-user-company-creation-form.php');
}

// Verify Employer Identification Number
if (!$post->employer_identification_number) {
	$message->enqueueError('Please enter a valid employer identification number.', 'admin-user-company-creation-form.php');
}
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$error = $message->getQueue();
if (isset($error) && !empty($error)) {
	$message->sessionPut();
	$post->sessionPut('admin-user-company-creation-form.php');
	$baseUrl = 'admin-user-company-creation-form.php';
	$url = $baseUrl.$uri->queryString;
	header('Location: '.$url);
	exit;
} else {

	require_once('lib/common/Date.php');

	// user_companies table
	if (isset($get) && $get->mode && ($get->mode == 'update')) {
		// leave $post->ddl_user_company_id intact for the "update" case
		// Only Global Admin's can use this page at this time so unset $post->user_company_id
		unset($post->user_company_id);
	} else {
		// Only Global Admin's can use this page at this time so unset $post->user_company_id
		// no $post->user_company_id value since creating a new company
		// no $post->ddl_user_company_id value since creating a new company
		unset($post->user_company_id);
		unset($post->ddl_user_company_id);
	}

	// Paying Customer Flag
	if ($post->paying_customer_flag == 'on') {
		$post->paying_customer_flag = 'Y';
	} else {
		$post->paying_customer_flag = 'N';
	}

	// Construction License Number Expiration Date
	if ($post->construction_license_number_expiration_date) {
		$tmpDate = $post->construction_license_number_expiration_date;
		$post->construction_license_number_expiration_date = $tmpDate;
	}

	// Convert the POST input to a standard UserCompany object
	// Core class are already included
	$uc = UserCompany::convertPostToStandardUserCompany($database, $post);
	/* @var $uc UserCompany */

	// Insert or delete
	if (isset($get) && $get->mode && ($get->mode == 'update')) {
		// Update existing user_company case
		$user_company_id = $get->managed_user_company_id;
		$uc->user_company_id = $user_company_id;
		$arrReturn = $uc->updateUserCompanyAccount($database);
		$contact_company_id = $arrReturn['contact_company_id'];
		$logo = $post->gc_logo;
		//logo insert
		if($logo=='')
		{
			$logo = Null;
		}
		$db = DBI::getInstance($database);

		$db->begin();
		$query = "select ctl.*,imi.* ".
		"FROM `contacts_to_logo` ctl ".
		"INNER JOIN `image_manager_images` imi ON imi.id = ctl.image_manager_image_id ".
		"WHERE ctl.`user_company_id` = $user_company_id ";
		$db->execute($query);
		$row = $db->fetch();
		if($row['id'] != ''){
		$query =
		"
		UPDATE IGNORE  `contacts_to_logo`
		SET `image_manager_image_id` = '$logo'
		Where user_company_id = $user_company_id
		";
		$db->execute($query);
		$db->free_result();
		$db->commit();
	}else{
		if($logo!='')
		{
		$query =
		"
		INSERT INTO `contacts_to_logo`
		(`user_company_id`, `contact_id`, `image_manager_image_id`)
		values ($user_company_id, $currentlyActiveContactId, $logo)
		";
		$db->execute($query);
		$db->free_result();
		$db->commit();
		}
	}
		// update user_companies_to_software_modules ... remember the deleted case also
		if ($post->software_modules) {
			$arrTmp = $post->software_modules;
			$arrNewSoftwareModuleIds = array();
			foreach ($arrTmp as $software_module_id) {
				$arrNewSoftwareModuleIds[$software_module_id] = 1;
			}
		} else {
			$arrNewSoftwareModuleIds = array();
		}

		// 1) get the current list
		require_once('lib/common/UserCompanyToSoftwareModule.php');
		$userCompanyToSoftwareModule = new UserCompanyToSoftwareModule($database);
		$key = array(
			'user_company_id' => $user_company_id
		);
		$data = array('software_module_id' => 1);
		$userCompanyToSoftwareModule->setKey($key);
		$userCompanyToSoftwareModule->setData($data);
		$userCompanyToSoftwareModule->load();
		$arrTemp = $userCompanyToSoftwareModule->getData();
		$arrExistingSoftwareModuleIds = array();
		foreach ($arrTemp as $arrTmp) {
			if (is_array($arrTmp) && !empty($arrTmp)) {
				list($attribute, $existing_software_module_id) = each($arrTmp);
				$arrExistingSoftwareModuleIds[] = $existing_software_module_id;
			}
		}
		$arrSoftwareModuleIdsToBeDeleted = array();
		foreach ($arrExistingSoftwareModuleIds as $existing_software_module_id) {
			if (isset($arrNewSoftwareModuleIds[$existing_software_module_id])) {
				unset($arrNewSoftwareModuleIds[$existing_software_module_id]);
			} elseif (!isset($arrNewSoftwareModuleIds[$existing_software_module_id])) {
				$arrSoftwareModuleIdsToBeDeleted[$existing_software_module_id] = 1;
			}
		}

		// delete the records that are no longer joined
		if (!empty($arrSoftwareModuleIdsToBeDeleted)) {
			$arrSoftwareModuleIdsToBeDeleted = array_keys($arrSoftwareModuleIdsToBeDeleted);
			UserCompanyToSoftwareModule::deleteUserCompanyToSoftwareModuleRecords($database, $user_company_id, $arrSoftwareModuleIdsToBeDeleted);
		}

		// insert the new records
		if (!empty($arrNewSoftwareModuleIds)) {
			$arrNewSoftwareModuleIds = array_keys($arrNewSoftwareModuleIds);
			UserCompanyToSoftwareModule::insertUserCompanyToSoftwareModuleRecords($database, $user_company_id, $arrNewSoftwareModuleIds);
		}
	} else {
		// Create new user_company case

		// Insert user_companies record if company info is available
		// Simultaneously mirror changes over to the contact_companies table with the new user_company_id for user_user_company_id and contact_user_company_id
		$arrReturn = $uc->registerUserCompanyAccount($database);
		$user_company_id = $arrReturn['user_company_id'];
		$contact_company_id = $arrReturn['contact_company_id'];
		$logo = $post->gc_logo;
		//logo insert
		if($logo!='')
		{
		$query =
			"
			INSERT INTO `contacts_to_logo`
			(`user_company_id`, `contact_id`, `image_manager_image_id`)
			values ($user_company_id, $currentlyActiveContactId, $logo)
			";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();
		}



		// exit;
		// Application constants
		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_NON_EXISTENT_PROJECT_TYPE_ID = AXIS_NON_EXISTENT_PROJECT_TYPE_ID;
		$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;
		$AXIS_TEMPLATE_PROJECT_ID = AXIS_TEMPLATE_PROJECT_ID;
		$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;


		// Copy Permissions from system template : non-project specific
		$query =
"
INSERT
INTO `roles_to_software_module_functions` (`user_company_id`, `role_id`, `software_module_function_id`)
SELECT ?, `role_id`, `software_module_function_id`
FROM `roles_to_software_module_function_templates` r2smft
WHERE r2smft.`role_id` <> $AXIS_USER_ROLE_ID_GLOBAL_ADMIN
AND r2smft.`role_id` <> $AXIS_USER_ROLE_ID_ADMIN
";
		$userCompanyIdString = (string) $user_company_id;
		$arrValues = array($userCompanyIdString);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		if ($post->software_modules) {
			$arrNewSoftwareModuleIds = $post->software_modules;
			// insert the new records
			if (!empty($arrNewSoftwareModuleIds)) {
				require_once('lib/common/UserCompanyToSoftwareModule.php');
				UserCompanyToSoftwareModule::insertUserCompanyToSoftwareModuleRecords($database, $user_company_id, $arrNewSoftwareModuleIds);
			}
		}


		// Create "Default Bid List" for this new company
		// `bid_lists`
		$query =
"
INSERT INTO `bid_lists`
(`user_company_id`, `bid_list_name`, `bid_list_description`)
SELECT
	'$userCompanyIdString' AS 'user_company_id',
	'Default Bid List' AS 'bid_list_name',
	'Default Bid List' AS 'bid_list_description'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();


		// `project_types`
		// Copy `project_type_templates` into `project_types`
		// Ommitting Commercial types for now -> will depend on Construction types checkbox on Global Admin interface
		// WHERE ptt.`id` < 29
		$query =
"
INSERT INTO `project_types`
(`user_company_id`, `construction_type`, `project_type`)
SELECT
	'$userCompanyIdString' AS 'user_company_id',
	ptt.`construction_type`,
	ptt.`project_type`
FROM `project_type_templates` ptt
ORDER BY ptt.`id`
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();


		// Create a set of Meeting Locations for this new company
		// `meeting_locations`
		$query =
"
INSERT INTO `meeting_locations`
(`user_company_id`, `meeting_location`, `meeting_location_abbreviation`)
SELECT
	'$userCompanyIdString' AS 'user_company_id',
	mlt.`meeting_location`,
	mlt.`meeting_location_abbreviation`
FROM `meeting_location_templates` mlt
ORDER BY mlt.`id`
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();


		// Create DCR Types for this new company
		// `daily_construction_report_types`
		// Internal Daily Construction Report
		$query =
"
INSERT INTO `daily_construction_report_types`
(`user_company_id`, `daily_construction_report_type`, `disabled_flag`, `sort_order`)
SELECT
	'$userCompanyIdString' AS 'user_company_id',
	'Internal Daily Construction Report' AS 'daily_construction_report_type',
	'N' AS 'disabled_flag',
	'1' AS 'sort_order'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();

		// `daily_construction_report_types`
		// Public Daily Construction Report
		$query =
"
INSERT INTO `daily_construction_report_types`
(`user_company_id`, `daily_construction_report_type`, `disabled_flag`, `sort_order`)
SELECT
	'$userCompanyIdString' AS 'user_company_id',
	'Public Daily Construction Report' AS 'daily_construction_report_type',
	'N' AS 'disabled_flag',
	'2' AS 'sort_order'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();


		// Create "Default Jobsite Activities List" for this new company
		// `jobsite_activity_list_templates` -> depends on `project_type_id`
		// Harcoding `project_type_id` to "1" for now
		// @Finish Daily Log project_types and templatized jobsite activities
		// ??? `construction_categories` (Residential, Residential Over Commercial, Commercial)
		// ??? `construction_categories_to_jobsite_activity_list_templates`


		// "Default Jobsite Activities List"
		$query =
"
INSERT INTO `jobsite_activity_list_templates`
(`user_company_id`, `project_type_id`, `jobsite_activity_list_template`, `disabled_flag`, `sort_order`)
SELECT
	'$userCompanyIdString' AS 'user_company_id',
	'1' AS 'project_type_id',
	'Default Jobsite Activities List' AS 'jobsite_activity_list_template',
	'N' AS 'disabled_flag',
	'1' AS 'sort_order'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();

		// "Default Residential Jobsite Activities List"

		$project_type_id = 1;
		$query =
"
INSERT INTO `jobsite_activity_list_templates`
(`user_company_id`, `project_type_id`, `jobsite_activity_list_template`, `disabled_flag`, `sort_order`)
SELECT
	'$userCompanyIdString' AS 'user_company_id',
	'$project_type_id' AS 'project_type_id',
	'Default Residential Jobsite Activities List' AS 'jobsite_activity_list_template',
	'N' AS 'disabled_flag',
	'2' AS 'sort_order'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();

		// "Default Residential Jobsite Activities List"

		$project_type_id = 1;
		$query =
"
INSERT INTO `jobsite_activity_list_templates`
(`user_company_id`, `project_type_id`, `jobsite_activity_list_template`, `disabled_flag`, `sort_order`)
SELECT
	'$userCompanyIdString' AS 'user_company_id',
	'$project_type_id' AS 'project_type_id',
	'Default Residential Over Commercial Jobsite Activities List' AS 'jobsite_activity_list_template',
	'N' AS 'disabled_flag',
	'3' AS 'sort_order'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();

		// "Default Residential Jobsite Activities List"
		$project_type_id = 1;
		$query =
"
INSERT INTO `jobsite_activity_list_templates`
(`user_company_id`, `project_type_id`, `jobsite_activity_list_template`, `disabled_flag`, `sort_order`)
SELECT
	'$userCompanyIdString' AS 'user_company_id',
	'$project_type_id' AS 'project_type_id',
	'Default Commercial Jobsite Activities List' AS 'jobsite_activity_list_template',
	'N' AS 'disabled_flag',
	'4' AS 'sort_order'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();


		// `jobsite_delay_categories`
		$query =
"
INSERT INTO `jobsite_delay_categories`
(`user_company_id`, `jobsite_delay_category`, `disabled_flag`, `sort_order`)
SELECT
	'$userCompanyIdString' AS 'user_company_id',
	jdct.`jobsite_delay_category` AS 'jobsite_delay_category',
	'N' AS 'disabled_flag',
	jdct.`sort_order` AS 'sort_order'
FROM `jobsite_delay_category_templates` jdct
ORDER BY jdct.`id` ASC
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();

		// `jobsite_delay_subcategories`
		$query =
"
INSERT INTO `jobsite_delay_subcategories`
(`jobsite_delay_category_id`, `jobsite_delay_subcategory`, `disabled_flag`, `sort_order`)
SELECT
	jdc.`id` AS 'jobsite_delay_category_id',
	jdst.`jobsite_delay_subcategory` AS 'jobsite_delay_subcategory',
	'N' AS 'disabled_flag',
	jdst.`sort_order` AS 'sort_order'
FROM `jobsite_delay_categories` jdc
	INNER JOIN `jobsite_delay_category_templates` jdct USING (`jobsite_delay_category`)
	INNER JOIN `jobsite_delay_subcategory_templates` jdst ON jdct.`id` = jdst.`jobsite_delay_category_template_id`
WHERE jdc.`user_company_id` = '$userCompanyIdString'
ORDER BY jdst.`id` ASC
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();

		//To inherit the permission set by GA
		require('app/models/permission_mdl.php');
		InheritPermissionForNewCompany($database,$userCompanyIdString);

	}

	// Process errors and redirect back to the registration form
	if (isset($arrReturn['errors']) && !empty($arrReturn['errors'])) {
		$arrErrors = $arrReturn['errors'];

		// Potential company name conflict
		if (isset($arrErrors['user_company_name'])) {
			$companyError = $arrErrors['company'];
			if ($companyError) {
				$message->enqueueError('Please enter a different company name. This one is already in use.', 'admin-user-company-creation-form.php');
			}
		}

		// Potential employer_identification_number conflict
		if (isset($arrErrors['employer_identification_number'])) {
			$einError = $arrErrors['employer_identification_number'];
			if ($einError) {
				$message->enqueueError('Please enter a different employer identification number. This one is already in use.', 'admin-user-company-creation-form.php');
			}
		}

		$message->sessionPut();
		$post->sessionPut('admin-user-company-creation-form.php');

		$url = 'admin-user-company-creation-form.php'.$uri->queryString;

		header("Location: $url");
		exit;
	}

	// confirmation messages
	if (isset($get) && $get->mode && ($get->mode == 'update')) {
		$message->resetAll();
		$message->enqueueConfirm('You have successfully updated the Fulcrum User Company!', 'admin-user-company-creation-form.php');
		$message->sessionPut();
		$url = 'admin-user-company-creation-form.php'.$uri->queryString;
	} else {
		$message->resetAll();
		$message->enqueueConfirm('You have successfully created a Fulcrum User Company!', 'admin-user-company-creation-form.php');
		$message->sessionPut();
		$url = 'admin-user-company-creation-form.php';
	}

	$post->sessionClear();
	$session->setFormSubmitted(false);

	header('Location: '.$url);
	exit;
}
