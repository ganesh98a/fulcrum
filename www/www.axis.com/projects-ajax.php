<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;

$init['timer'] = false;
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

require_once('lib/common/JobsiteBuilding.php');
require_once('lib/common/JobsiteOffsiteworkRegion.php');
require_once('lib/common/JobsiteSiteworkRegion.php');
require_once('lib/common/MeetingTypeTemplate.php');
require_once('lib/common/MeetingType.php');
require_once('lib/common/PageComponents.php');

require_once('lib/common/Project.php');
require_once('lib/common/Service/TableService.php');
require_once('lib/common/ContractingEntities.php');
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('projects-functions.php');
	}
}


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

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {
	case 'createProject':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';

		try {

			// Application constants
			$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
			$AXIS_NON_EXISTENT_PROJECT_TYPE_ID = AXIS_NON_EXISTENT_PROJECT_TYPE_ID;
			$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;
			$AXIS_TEMPLATE_PROJECT_ID = AXIS_TEMPLATE_PROJECT_ID;
			$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
			$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

			// Disallow Global Admin Account from creating projects to enforce a single project template.
			$user_company_id = $session->getUserCompanyId();
			if ($user_company_id == $AXIS_TEMPLATE_USER_COMPANY_ID) {
				$message->enqueueError('|Global Admin Account is only allowed to have one single Template Project.', $currentPhpScript);
				trigger_error('Global Admin Account is only allowed to have one single Template Project.');
				break;
			}

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_manage' => 1
				);

				$arrErrorMessages = array(
					'Error creating: Project.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-project-record';
			}


			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the Project record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$project = new Project($database);

			$project->setData($httpGetInputData);
			$project->convertDataToProperties();

			$project->project_id =  $get->project_id;
			$project->project_type_id =  $get->project_type;
			

			// Customized Error Checking for:
			// project_name <> ''
			// project_type_id <> -1
			$validDataFlag = true;
			// Project Name
			if (!isset($project->project_name) || empty($project->project_name)) {
				// Error code here
				$errorMessage = 'Missing Project Name';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$validDataFlag = false;
			}
			// Project Type
			if (!isset($project->project_type_id) || empty($project->project_type_id) || ($project->project_type_id < 1)) {
				// Error code here
				$errorMessage = 'Invalid Project Type';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$validDataFlag = false;
			}
			//
			if (!isset($project->contracting_entity_id) || empty($project->contracting_entity_id) || ($project->contracting_entity_id < 1)) {
				// Error code here
				$errorMessage = 'Missing Contracting Entity';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$validDataFlag = false;
			}
			if (!$validDataFlag) {
				$primaryKeyAsString = $project->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			}

			// @todo Decide if a third party can create projects for a User Company (i.e. users' user_company_id would be different)
			$project->user_company_id = $user_company_id;

			$project->convertPropertiesToData();
			$data = $project->getData();

			// Test for existence via standard findByUniqueIndex method
			$project->findByUniqueIndex();
			if ($project->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Project already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $project->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				
			} else {
				$project->setKey(null);
				$project->setData($data);
			}

			$project_id = $project->save();
			if (isset($project_id) && !empty($project_id)) {
				$project->project_id = $project_id;
				$project->setId($project_id);
			}

			$project->convertDataToProperties();
			$primaryKeyAsString = $project->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
			// creation of a plans folder
				$db = DBI::getInstance();
			$query = "INSERT INTO file_manager_folders(user_company_id,contact_id,project_id,virtual_file_path) VALUES('$user_company_id','$currentlyActiveContactId','$primaryKeyAsString','/Plans/')";
        		if($db->execute($query)){
           		 $folder_id = $db->insertId; 
           		 $query1 = "INSERT INTO `roles_to_folders`(`role_id`, `file_manager_folder_id`, `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`) VALUES ('3', '$folder_id', 'Y', 'N', 'N', 'N', 'N')";
        		 $db->execute($query1);
        		 $db->free_result();
	      		  }
	      		
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

				// Set default_project_id if necessary.
				$default_project_id = (string) $get->default_project_id;
				if ($default_project_id == 'Y') {
					$user = User::findById($database, $user_id);
					if ($user) {
						$userData = array(
							'default_project_id' => $project_id
						);
						$user->setData($userData);
						$user->save();
					}
				}

				// @todo Decide if a third party can create projects for a User Company (i.e. users' user_company_id would be different)
				
				$session->setCurrentlySelectedProjectUserCompanyId($project->user_company_id);
				$session->setCurrentlySelectedProjectId($project->project_id);
				$session->setCurrentlySelectedProjectName($project->project_name);

				// Inject Project Dependency Data Here:
				// Daily Log dependencies
				// "Dummy" Placeholder for the lack of defined "Buildings"
				// An image map of the site with buildings would invalidate the need for this dummy placeholder record
				$jobsiteBuilding = new JobsiteBuilding($database);
				$jobsiteBuilding->project_id = $project_id;
				$jobsiteBuilding->jobsite_building = 1;
				$jobsiteBuilding->jobsite_building_description = 'Dummy';
				$jobsiteBuilding->sort_order = 1;
				$jobsiteBuilding->convertPropertiesToData();
				$jobsiteBuilding->save();

				// "Dummy" Placeholder for the lack of defined "Offsitework Regions"
				// An image map of the offsite regions (if it would ever exist) would invalidate the need for this dummy placeholder record
				$jobsiteOffsiteworkRegion = new JobsiteOffsiteworkRegion($database);
				$jobsiteOffsiteworkRegion->project_id = $project_id;
				$jobsiteOffsiteworkRegion->jobsite_offsitework_region = 1;
				$jobsiteOffsiteworkRegion->jobsite_offsitework_region_description = 'Dummy';
				$jobsiteOffsiteworkRegion->sort_order = 1;
				$jobsiteOffsiteworkRegion->convertPropertiesToData();
				$jobsiteOffsiteworkRegion->save();

				// "Dummy" Placeholder for the lack of defined "Sitework Regions" or "Phases"
				// An image map of the site with sitework regions or phases would invalidate the need for this dummy placeholder record
				$jobsiteSiteworkRegion = new JobsiteSiteworkRegion($database);
				$jobsiteSiteworkRegion->project_id = $project_id;
				$jobsiteSiteworkRegion->jobsite_sitework_region = 1;
				$jobsiteSiteworkRegion->jobsite_sitework_region_description = 'Dummy';
				$jobsiteSiteworkRegion->sort_order = 1;
				$jobsiteSiteworkRegion->convertPropertiesToData();
				$jobsiteSiteworkRegion->save();

				// Inject Project Dependency Data Here:
				// meeting_types for the project_id copied over from: meeting_type_templates
				// @todo Provide a wizard for new Project Creation with this step
				$arrMeetingTypeTemplates = MeetingTypeTemplate::loadAllMeetingTypeTemplates($database);
				foreach ($arrMeetingTypeTemplates as $meeting_type_template_id => $meetingTypeTemplate) {
					/* @var $meetingTypeTemplate MeetingTypeTemplate */

					$meetingType = new MeetingType($database);
					$meetingType->project_id = (int) $project->project_id;
					$meetingType->meeting_type = (string) $meetingTypeTemplate->meeting_type;
					$meetingType->meeting_type_abbreviation = (string) $meetingTypeTemplate->meeting_type_abbreviation;
					
					$meetingType->sort_order = (int) $meetingTypeTemplate->sort_order;
					$meetingType->convertPropertiesToData();
					$meetingType->save();

				}

				// Copy Permissions from system template : project specific
				$query =
"
INSERT
INTO `projects_to_roles_to_software_module_functions` (`project_id`, `role_id`, `software_module_function_id`)
SELECT ?, `role_id`, `software_module_function_id`
FROM `roles_to_software_module_function_templates` p2r2smft
WHERE p2r2smft.`role_id` <> $AXIS_USER_ROLE_ID_GLOBAL_ADMIN
AND p2r2smft.`role_id` <> $AXIS_USER_ROLE_ID_ADMIN GROUP BY `role_id`, `software_module_function_id`
";
				$projectIdString = (string) $project_id;
				$arrValues = array($projectIdString);
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				$db->free_result();


			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Project.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($project) && $project instanceof Project) {
				$primaryKeyAsString = $project->getPrimaryKeyAsString();
			}
		}

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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadProject':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Project.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects';
			}
			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$project_name = (string) $get->project_name;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($project) && $project instanceof Project) {
				$primaryKeyAsString = $project->getPrimaryKeyAsString();
			}
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlContent";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadAllProjectRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Project.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects';
			}



			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$project_name = (string) $get->project_name;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$containerElementId|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlContent";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;
	case 'updatecontractEntity':
		try {
			$errorNumber = 0;
			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			$entity_id = (int) $get->entity_id;
			$newValue =$get->newValue;
			$attributeName =$get->attributeName;
			$table = $get->table;
			$result = TableService::UpdateTabularData($database,$table,$attributeName,$entity_id,$newValue);

			if($result) {
				$errorNumber = 0;
			}

		} catch (Exception $e) {
			$errorNumber = 1;
		}
	break;
	case 'updateProjectEntity':

		try {
			$errorNumber = 0;
			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			$company_entity_id = (int) $get->company_entity_id;
			$project_id = (int) $get->project_id;

			// Put in findById() or findByUniqueKey() as appropriate
			$project = Project::findById($database, $project_id);
			if(!empty($project) && !empty($company_entity_id) && $project->contracting_entity_id != $company_entity_id)
			{
				$project->contracting_entity_id = $company_entity_id;
				$project->save();
				$errorNumber = 0;
				$arrResult = ContractingEntities::getAllcontractEntitydata($database,$company_entity_id);
				$license  =$arrResult['construction_license_number'];
				$output = "$errorNumber|$license";
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
			$license ="";
			$output = "$errorNumber|$license";
		}
		
		echo $output;
	break;

	case 'updateProject':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Project';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Project - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects';
			}

			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$project_name = (string) $get->project_name;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'project_id' => 'project id',
				'project_type_id' => 'project type id',
				'user_company_id' => 'user company id',
				'user_custom_project_id' => 'user custom project id',
				'project_name' => 'project name',
				'project_owner_name' => 'project owner name',
				'latitude' => 'latitude',
				'longitude' => 'longitude',
				'address_line_1' => 'address line 1',
				'address_line_2' => 'address line 2',
				'address_line_3' => 'address line 3',
				'address_line_4' => 'address line 4',
				'address_city' => 'address city',
				'address_county' => 'address county',
				'address_state_or_region' => 'address state or region',
				'address_postal_code' => 'address postal code',
				'address_postal_code_extension' => 'address postal code extension',
				'address_country' => 'address country',
				'building_count' => 'building count',
				'unit_count' => 'unit count',
				'gross_square_footage' => 'gross square footage',
				'net_rentable_square_footage' => 'net rentable square footage',
				'is_active_flag' => 'is active flag',
				'public_plans_flag' => 'public plans flag',
				'prevailing_wage_flag' => 'prevailing wage flag',
				'city_business_license_required_flag' => 'city business license required flag',
				'is_internal_flag' => 'is internal flag',
				'project_contract_date' => 'project contract date',
				'project_start_date' => 'project start date',
				'project_completed_date' => 'project completed date',
				'sort_order' => 'sort order',
				'default_project_id' => 'default project',
				'retainer_rate' => 'retainer rate',
				'draw_template_id' => 'draw template',
				'time_zone_id' => 'time zone',
				'delivery_time_id' => 'delivery time',
				'delivery_time' => 'delivery time',
				'qb_customer_id'=> 'QB Customer ID',
				'max_photos_displayed'=> 'max photos displayed',
				'photos_displayed_per_page'=> 'photos displayed per page',
				'owner_address'=>'project owner address',
				'owner_city'=>'project owner city',
				'owner_state_or_region'=>'project owner state or region',
				'owner_postal_code'=>'project owner postal code',
				'COR_type'=>'COR display',
				'alias_type'=>'Alias type',
				'architect_cmpy_id' => 'Architect Company' ,
				'architect_cont_id' => 'Architect Contact'
			);

			if (isset($arrAllowableAttributes[$attributeName])) {
				// Allow formatted attribute name to be passed in
				if (!isset($formattedAttributeName) || empty($formattedAttributeName)) {
					$formattedAttributeName = $arrAllowableAttributes[$attributeName];
					$arrTmp = explode(' ', $formattedAttributeName);
					$arrFormattedAttributeName = array_map('ucfirst', $arrTmp);
					$formattedAttributeName = join(' ', $arrFormattedAttributeName);
				}
			} else {
				$errorMessage = 'Invalid attribute.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			if ($attributeSubgroupName == 'projects') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$project_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$project = Project::findById($database, $project_id);
				/* @var $project Project */

				if ($project) {
					// Check if the value actually changed
					$existingValue = $project->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $project->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'user_company_id' => 1,
						'project_name' => 1,
					);
					
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $project->$attributeName;
						$project->$attributeName = $newValue;
						$possibleDuplicateProject = Project::findByUserCompanyIdAndProjectName($database, $project->user_company_id, $project->project_name);
						if ($possibleDuplicateProject) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Project $newValue already exists.";

						} else {
							$project->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$project->setData($data);
						$project->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);

						if ($attributeName == 'project_name') {
							$session->setCurrentlySelectedProjectName($newValue);
						}
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Project record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					
				}

				$primaryKeyAsString = $project->getPrimaryKeyAsString();
			} elseif ($attributeSubgroupName == 'users') {

				// Put in findById() or findByUniqueKey() as appropriate
				$user = User::findById($database, $user_id);

				if ($user) {
					// Check if the value actually changed
					if (($attributeName == 'default_project_id') && ($newValue == 'Y')) {
						$newValueToCheck = (int) $project_id;
						$existingValue = (int) $user->$attributeName;
					} else {
						// Do not think any cases exist other than default_project_id for now.
						$newValueToCheck = $newValue;
						$existingValue = $user->$attributeName;
					}
					if ($existingValue === $newValueToCheck) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						throw new Exception($errorMessage);
					}

					if ($save) {
						if ($attributeName == 'default_project_id') {

							if ($newValue == 'Y') {
								$default_project_id = (int) $project_id;
							} elseif ($newValue == 'N') {
								$default_project_id = 1;
							}

							$data = array($attributeName => $default_project_id);
							$user->setData($data);
							$user->save();
						}

						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'User record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $user->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();
			$errorNumber = 1;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($project) && $project instanceof Project) {
				$primaryKeyAsString = $project->getPrimaryKeyAsString();
			}
		}

		// Dummy placeholder for now
		$previousId = '';

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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$attributeName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$formattedAttributeName|$resetToPreviousValue";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'updateAllProjectAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Project';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Project.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects';
			}

			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$project_name = (string) $get->project_name;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'projects') {
				$project_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$project = Project::findById($database, $project_id);
				/* @var $project Project */

				if ($project) {
					$existingData = $project->getData();

					// Retrieve all of the $_GET inputs automatically for the Project record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null

					$project->setData($httpGetInputData);
					$project->convertDataToProperties();
					$project->convertPropertiesToData();

					$newData = $project->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$project->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Project<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $project->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					$project->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);

					if (isset($data['project_name']) && !empty($data['project_name'])) {
						$session->setCurrentlySelectedProjectName($data['project_name']);
					}

				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Project record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($project) && $project instanceof Project) {
				$primaryKeyAsString = $project->getPrimaryKeyAsString();
			}
		}

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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$resetToPreviousValue";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'deleteProject':

		$crudOperation = 'delete';
		$errorNumber = 0;
		$errorMessage = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Project.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects';
			}



			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$project_name = (string) $get->project_name;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'projects') {
				$project_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$project = Project::findById($database, $project_id);
				/* @var $project Project */

				if ($project) {
					$project->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Project record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					
				}
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';


		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($project) && $project instanceof Project) {
				$primaryKeyAsString = $project->getPrimaryKeyAsString();
			}
		}

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
			$output = "$errorNumber|$errorMessage|$recordContainerElementId|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$performDomDeleteOperation";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'saveProject':

		$crudOperation = 'save';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_manage' => 1
				);

				$arrErrorMessages = array(
					'Error saving Project.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-project-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$project = new Project($database);

			// Retrieve all of the $_GET inputs automatically for the Project record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$project->setData($httpGetInputData);
			$project->convertDataToProperties();

			$project->convertPropertiesToData();
			$data = $project->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$project_id = $project->insertOnDuplicateKeyUpdate();
			if (isset($project_id) && !empty($project_id)) {
				$project->project_id = $project_id;
				$project->setId($project_id);
			}


			$project->convertDataToProperties();
			$primaryKeyAsString = $project->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Project.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;


		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);


		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($project) && $project instanceof Project) {
				$primaryKeyAsString = $project->getPrimaryKeyAsString();
			}
		}

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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;
}

$htmlOutput = ob_get_clean();
echo $htmlOutput;

while (@ob_end_flush());

exit; // End of PHP Ajax Handler Code

} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}
