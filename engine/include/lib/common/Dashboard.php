<?php
require_once('lib/common/Role.php');

function loadPermissionsById($database, $arrId,$actualUserRole)
{
	$session = Zend_Registry::get('session');

	$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();
	$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
	$user_company_id = $session->getUserCompanyId();
	$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
	$arrSoftwareModuleUrls = array();
	$arrSoftwareModuleFunctionUrls = array();
	$arrNav = array();
	$primary_contact_id = $session->getPrimaryContactId();
		$arrGlobalAdminNav = array(); // all possible permissions, even those that are disabled
		$arrAllUsersNav = array(); // defined by Global Admins for everyone
		$arrAdminNav = array(); // "admin" for their company permissions
		$arrUserPermissionsByRoleNav = array(); // "user" for their company permissions by role
		$arrUserPermissionsByContactNav = array(); // "user" for their company permissions by contact
		$arrGuestPermissionsByRoleNav = array(); // "admin or user" for third party company permissions by role
		$arrGuestPermissionsByContactNav = array(); // "admin or user" for third party company permissions by contact

		$arrGlobalAdminSoftwareModuleFunctionIds = array();
		$arrAllUsersSoftwareModuleFunctionIds = array();
		$arrAdminNonProjectSoftwareModuleFunctionIds = array();
		$arrAdminProjectOwnerSoftwareModuleFunctionIds = array();

		$arrUserNonProjectRoleBasedSoftwareModuleFunctionIds = array();
		$arrUserNonProjectContactBasedSoftwareModuleFunctionIds = array();
		$arrUserNonProjectAllUsersBasedSoftwareModuleFunctionIds = array();
		$arrUserProjectSpecificRoleBasedSoftwareModuleFunctionIds = array();
		$arrUserProjectSpecificContactBasedSoftwareModuleFunctionIds = array();
		$arrUserProjectSpecificAllUsersBasedSoftwareModuleFunctionIds = array();

		$arrGuestNonProjectRoleBasedSoftwareModuleFunctionIds = array();
		$arrGuestNonProjectContactBasedSoftwareModuleFunctionIds = array();
		$arrGuestNonProjectAllUsersBasedSoftwareModuleFunctionIds = array();
		$arrGuestProjectSpecificRoleBasedSoftwareModuleFunctionIds = array();
		$arrGuestProjectSpecificContactBasedSoftwareModuleFunctionIds = array();
		$arrGuestProjectSpecificAllUsersBasedSoftwareModuleFunctionIds = array();

		// Assigned roles derived from role_id values in contacts_to_roles
		$arrAssignedRolesByContactId = array();
		$arrProjectRoles = array();

		// Assigned role_id values in contacts_to_roles
		$arrAssignedRoleIdsByContactId = array();
		$arrProjectRoleIds = array();
		$userRole = $actualUserRole;
		if ($userRole == "global_admin") {
			// Global Admin case

			// "Global Admin Nav"
			// Global Admins get to see all menu options
			$arrGlobalAdminSoftwareModuleFunctionIds = loadGlobalAdminSoftwareModuleFunctionIds($database);
		} else {
			// Not a Global Admin case
			// Load permissions available to all users based on smf flags
			$arrAllUsersSoftwareModuleFunctionIds = loadAvailableToAllUsersSoftwareModuleFunctionIds($database);

			// "Admin Nav" for their company only
			// if admin, load all functionality that is not project centric
			if ($userRole == 'admin') {
				// Not project-specific
				// sm.`project_specific_flag` = 'N'
				$arrAdminNonProjectSoftwareModuleFunctionIds = loadAdminNonProjectSoftwareModuleFunctionIds($database, $user_company_id);

				// Project-specific
				// sm.`project_specific_flag` = 'Y'
				if ($currentlySelectedProjectUserCompanyId == $user_company_id) {
					$arrAdminProjectOwnerSoftwareModuleFunctionIds =
					loadAdminProjectOwnerSoftwareModuleFunctionIds($database, $user_company_id, $currentlySelectedProjectId);
				}
			}
		// "User Nav" for their company only
			// By Role & By Contact
			// smf.`project_specific_flag` = 'N'
			if ($userRole == 'user') {
				// Load roles list from contacts_to_roles
				$arrAssignedRolesByContactId = loadContactsToRolesByContactId($database, $primary_contact_id);
				//$arrAssignedRoleIdsByContactId = array_keys($arrAssignedRolesByContactId);

				// By Role
				//$arrUserSoftwareModuleFunctionIds = SoftwareModuleFunction::loadSoftwareModuleFunctionIdListForUsersByRole($database, $user_company_id, $user_id, $primary_contact_id);

				// By Contact


				// Not project-specific
				// sm.`project_specific_flag` = 'N'

				// By Role, non-project-specific
				// contacts_to_roles, roles_to_software_module_functions
				$arrUserNonProjectRoleBasedSoftwareModuleFunctionIds =
				loadUserNonProjectRoleBasedSoftwareModuleFunctionIds($database, $primary_contact_id, $user_company_id);

				// By Contact, non-project-specific
				// contacts_to_software_module_functions
				$arrUserNonProjectContactBasedSoftwareModuleFunctionIds =
				loadUserNonProjectContactBasedSoftwareModuleFunctionIds($database, $primary_contact_id, $user_company_id);

				// By "All Users", non-project-specific
				// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=N
				$arrUserNonProjectAllUsersBasedSoftwareModuleFunctionIds =
				loadUserNonProjectAllUsersBasedSoftwareModuleFunctionIds($database, $user_company_id);

				// Project-specific
				// sm.`project_specific_flag` = 'Y'
				if ($currentlySelectedProjectUserCompanyId == $user_company_id) {
					// By Role, project-specific
					// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
					$arrUserProjectSpecificRoleBasedSoftwareModuleFunctionIds =
					loadUserProjectSpecificRoleBasedSoftwareModuleFunctionIds($database, $primary_contact_id, $user_company_id, $currentlySelectedProjectId);

					// By Contact, project-specific
					// projects_to_contacts_to_software_module_functions
					$arrUserProjectSpecificContactBasedSoftwareModuleFunctionIds =
					loadUserProjectSpecificContactBasedSoftwareModuleFunctionIds($database, $primary_contact_id, $user_company_id, $currentlySelectedProjectId);

					// By "All Users", project-specific
					// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=Y
					$arrUserProjectSpecificAllUsersBasedSoftwareModuleFunctionIds =
					loadUserProjectSpecificAllUsersBasedSoftwareModuleFunctionIds($database, $primary_contact_id, $user_company_id, $currentlySelectedProjectId);
				}
			}

			// Load roles list from projects_to_contacts_to_roles
			$arrProjectRoles = loadRolesListByProjectIdAndContactId($database, $currentlySelectedProjectId, $currentlyActiveContactId);
			//$arrProjectRoleIds = array_keys($arrProjectRoles);

			// Third-party "Guest" permissions
			$csvContactIds = loadGuestContactIdsCSV($database, $user_company_id, $user_id, $primary_contact_id);

			// By Role, non-project-specific
			// contacts_to_roles, roles_to_software_module_functions
			//$guestNonProjectRoleIdCSV = loadGuestNonProjectRoleIdsCSV($database, $csvContactIds);
			$arrGuestNonProjectRoleBasedSoftwareModuleFunctionIds =
			loadGuestNonProjectRoleBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId);

			// By Contact, non-project-specific
			// contacts_to_software_module_functions
			$arrGuestNonProjectContactBasedSoftwareModuleFunctionIds =
			loadGuestNonProjectContactBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId);

			// By "All Users", non-project-specific
			// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=N
			$arrGuestNonProjectAllUsersBasedSoftwareModuleFunctionIds =
			loadGuestNonProjectAllUsersBasedSoftwareModuleFunctionIds($database, $currentlySelectedProjectUserCompanyId);

			// By Role, project-specific
			// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
			$arrGuestProjectSpecificRoleBasedSoftwareModuleFunctionIds =
			loadGuestProjectSpecificRoleBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId);

			// By Contact, project-specific
			// projects_to_contacts_to_software_module_functions
			$arrGuestProjectSpecificContactBasedSoftwareModuleFunctionIds =
			loadGuestProjectSpecificContactBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId);

			// By "All Users", project-specific
			// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=Y
			$arrGuestProjectSpecificAllUsersBasedSoftwareModuleFunctionIds =
			loadGuestProjectSpecificAllUsersBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId);

		}

		//print_r($arrId);
		// The complete list of permissions including hidden software_module_functions that are not in the primary navigation (show_in_navigation_flag = 'N'/'Y')
		$arrSoftwareModuleFunctionIds =
		$arrGlobalAdminSoftwareModuleFunctionIds +

		$arrAllUsersSoftwareModuleFunctionIds +

		$arrAdminNonProjectSoftwareModuleFunctionIds +
		$arrAdminProjectOwnerSoftwareModuleFunctionIds +

		$arrUserNonProjectRoleBasedSoftwareModuleFunctionIds +
		$arrUserNonProjectContactBasedSoftwareModuleFunctionIds +
		$arrUserNonProjectAllUsersBasedSoftwareModuleFunctionIds +
		$arrUserProjectSpecificRoleBasedSoftwareModuleFunctionIds +
		$arrUserProjectSpecificContactBasedSoftwareModuleFunctionIds +
		$arrUserProjectSpecificAllUsersBasedSoftwareModuleFunctionIds +

		$arrGuestNonProjectRoleBasedSoftwareModuleFunctionIds +
		$arrGuestNonProjectContactBasedSoftwareModuleFunctionIds +
		$arrGuestNonProjectAllUsersBasedSoftwareModuleFunctionIds +
		$arrGuestProjectSpecificRoleBasedSoftwareModuleFunctionIds +
		$arrGuestProjectSpecificContactBasedSoftwareModuleFunctionIds +
		$arrGuestProjectSpecificAllUsersBasedSoftwareModuleFunctionIds;

		// print_r($arrSoftwareModuleFunctionIds);
		$arrPermissions = array();

		// The primary navigation menu for the user
		$arrMenu = array();

		// Old version...will be deleted
		$arrNav = array();

		$arrSoftwareModuleCategorySortOrder = array();

		$arrSoftwareModuleCategories = array();
		$arrSoftwareModules = array();
		$arrSoftwareModuleFunctions = array();

		$arrSoftwareModulesByModule = array();
		$arrSoftwareModuleFunctionsByFunction = array();

		$arrSoftwareModuleUrls = array();
		$arrSoftwareModuleFunctionUrls = array();

		$in = join(',', $arrSoftwareModuleFunctionIds);
		//echo $in;
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Global Admins get to see all menu options
		if($actualUserRole=='global_admin')
		{
			if (in_array("97", $arrId)) {
			}else
			{
				array_push($arrId, '97');
			}
			
		}
		$query =
		"
		SELECT smf.`id` AS software_module_function_id, smf.`software_module_function`, smf.`software_module_function_label`,
		smf.`software_module_function_navigation_label`, smf.`default_software_module_function_url`,
		smf.`show_in_navigation_flag`, smf.`global_admin_only_flag`,
		sm.`id` AS software_module_id, sm.`software_module`, sm.`software_module_label`, sm.`default_software_module_url`,
		smc.`id` AS software_module_category_id, smc.`software_module_category`, smc.`software_module_category_label`, smc.`sort_order` AS software_module_category_sort_order
		FROM `software_module_functions` smf, `software_modules` sm, `software_module_categories` smc
		WHERE smf.`software_module_id` = sm.`id`
		AND sm.`software_module_category_id` = smc.`id`
		AND smf.`id` IN ($in)
		ORDER BY smc.`sort_order` ASC, sm.`sort_order` ASC, smf.`sort_order` ASC
		";
//echo $query;
			//"GROUP BY smf.`software_module_function_navigation_label`";
		$db->query($query);
		$arrSoftwareModuleFunctionsGroupedByNavigationLabel = array();
		while ($row = $db->fetch()) {
			$software_module_category_id = $row['software_module_category_id'];
			// Unique string identifier that would be embedded in code and guaranteed unique
			$software_module_category = $row['software_module_category'];
			// Label that the user would see in the site navigation
			$software_module_category_label = $row['software_module_category_label'];
			$software_module_category_sort_order = $row['software_module_category_sort_order'];

			$software_module_id = $row['software_module_id'];
			// Unique string identifier that would be embedded in code and guaranteed unique
			$software_module = $row['software_module'];
			$software_module_label = $row['software_module_label'];
			$default_software_module_url = $row['default_software_module_url'];

			$software_module_function_id = $row['software_module_function_id'];
			// Unique string identifier that would be embedded in code and guaranteed unique
			$software_module_function = $row['software_module_function'];
			// Label that the admin user would see in the permissions module for a given software_module_function
			$software_module_function_label = $row['software_module_function_label'];
			//echo $software_module_function_label;

			// Label that the user would see in the site navigation which allows grouping of multiple software_module_function's together
			$software_module_function_navigation_label = $row['software_module_function_navigation_label'];
			$default_software_module_function_url = $row['default_software_module_function_url'];
			$show_in_navigation_flag = $row['show_in_navigation_flag'];
			//$global_admin_only_flag = $row['global_admin_only_flag'];

			// Permissions matrix
			// Get a matrix of all permissions, regardless of whether they show up in the site navigation (menus).
			$arrPermissions[$software_module_category_id][$software_module_id][$software_module_function_id] = $software_module_function;

			// software_module_categories with sort_order (sort_order may not be unique so can't use as the key)
			// Get a list of software_module_categories and their sort_order
			$arrSoftwareModuleCategorySortOrder[$software_module_category_id] = $software_module_category_sort_order;

			// software_module_categories records
			// Flat array list of software_module_categories with attributes
			if (!isset($arrSoftwareModuleCategories[$software_module_category_id])) {
				$arrSoftwareModuleCategories[$software_module_category_id] = array(
					'software_module_category_id' => $software_module_category_id,
					'software_module_category' => $software_module_category,
					'software_module_category_label' => $software_module_category_label,
					'sort_order' => $software_module_category_sort_order
					);
			}

			// software_modules records
			// Flat array list of software_modules with attributes
			if (!isset($arrSoftwareModules[$software_module_id])) {
				$arrSoftwareModules[$software_module_id] = array(
					'software_module_category_id' => $software_module_category_id, // FK
					'software_module_id' => $software_module_id,
					'software_module' => $software_module,
					'software_module_label' => $software_module_label,
					'default_software_module_url' => $default_software_module_url,
					);
			}

			// software_module_functions records
			// Flat array list of software_module_functions with attributes
			if (!isset($arrSoftwareModuleFunctions[$software_module_function_id])) {
				$arrSoftwareModuleFunctions[$software_module_function_id] = array(
					'software_module_id' => $software_module_id, // FK
					'software_module_function_id' => $software_module_function_id,
					'software_module_function' => $software_module_function, // Embedded in code for permissions checks, Unique by software_module_id
					'software_module_function_label' => $software_module_function_label, // Admin Permissions Module label
					'software_module_function_navigation_label' => $software_module_function_navigation_label, // Navigation end-user label (supports grouping)
					'default_software_module_function_url' => $default_software_module_function_url,
					'show_in_navigation_flag' => $show_in_navigation_flag,
					);
			}
			$show_in_navigation_flag;
			if ($show_in_navigation_flag ) {
				// filter here instead of SQL GROUP BY to allow non-navigation permissions to work correctly for the below lists
				if (!isset($arrSoftwareModuleFunctionsGroupedByNavigationLabel[$software_module_function_navigation_label])) {

					// Get a matrix of menu permissions (show_in_navigation_flag = 'Y' only)
					$arrMenu[$software_module_category_id][$software_module_id][$software_module_function_id] = $software_module_function;

					$arrSoftwareModuleFunctionsGroupedByNavigationLabel[$software_module_function_navigation_label] = 1;
					$arrNav[$software_module_category_id]['id'] = $software_module_category_id;
					$arrNav[$software_module_category_id]['name'] = $software_module_category_label;
					$arrNav[$software_module_category_id]['modules'][$software_module_id]['name'] = $software_module_label;
					$arrNav[$software_module_category_id]['modules'][$software_module_id]['path'] = $default_software_module_url;
					$arrNav[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['name'] = $software_module_function;
					$arrNav[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['label'] = $software_module_function_navigation_label;
					$arrNav[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['path'] = $default_software_module_function_url;
					$arrNav[$software_module_category_id]['modules'][$software_module_id]['functions'][$software_module_function_id]['show'] = $show_in_navigation_flag;
				}
			}

			if (!empty($default_software_module_url)) {
				if (!empty($software_module_label)) {
					$arrSoftwareModuleUrls[$default_software_module_url] = $software_module_label;
				} else {
					$arrSoftwareModuleUrls[$default_software_module_url] = $software_module_id;
				}
			}
			if (!empty($default_software_module_function_url)) {
				if (!empty($software_module_function_navigation_label)) {
					$arrSoftwareModuleFunctionUrls[$default_software_module_function_url] = $software_module_function_navigation_label;
				} else {
					$arrSoftwareModuleFunctionUrls[$default_software_module_function_url] = $software_module_id;
				}
			}

			if (!empty($software_module)) {
				$arrSoftwareModulesByModule[$software_module] = 1;
			}
			if (!empty($software_module_function)) {
				$arrSoftwareModuleFunctionsByFunction[$software_module_function] = 1;
			}
		}
		$db->free_result();

		$arrReturn = array(
			'nav' => $arrNav,
			'menu' => $arrMenu,
			'permissions' => $arrPermissions,

			'software_module_category_sort_order' => $arrSoftwareModuleCategorySortOrder,

			'software_module_categories' => $arrSoftwareModuleCategories,
			'software_modules' => $arrSoftwareModules,
			'software_module_functions' => $arrSoftwareModuleFunctions,

			'software_modules_by_module' => $arrSoftwareModulesByModule,
			'software_module_functions_by_function' => $arrSoftwareModuleFunctionsByFunction,

			'software_module_urls' => $arrSoftwareModuleUrls,
			'software_module_function_urls' => $arrSoftwareModuleFunctionUrls,
			);
		// print_r($arrReturn);
		return $arrReturn;
	}
	function loadAvailableToAllUsersSoftwareModuleFunctionIds($database)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Load permissions available to all users based on smf flags
		$query =
		"
		SELECT
		smf.`id`
		FROM `software_modules` sm
		INNER JOIN `software_module_functions` smf ON sm.`id` = smf.`software_module_id`
		WHERE sm.`disabled_flag` = 'N'
		AND smf.`available_to_all_users_flag` = 'Y'
		AND smf.`global_admin_only_flag` = 'N'
		AND smf.`disabled_flag` = 'N'
		";
//AND sm.`project_specific_flag` = 'N'
//AND smf.`show_in_navigation_flag` = 'Y'
		$db->query($query);

		$arrIds = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$arrIds[] = $id;
		}
		$db->free_result();

		return $arrIds;
	}
	function loadAdminNonProjectSoftwareModuleFunctionIds($database, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Load list for Admins that are not project centric
		$query =
		"
		SELECT
		smf.`id`
		FROM `user_companies_to_software_modules` uc2sm
		INNER JOIN `software_modules` sm ON uc2sm.`software_module_id` = sm.`id`
		INNER JOIN `software_module_functions` smf ON sm.`id` = smf.`software_module_id`
		WHERE uc2sm.`user_company_id` = ?
		AND sm.`project_specific_flag` = 'N'
		AND sm.`disabled_flag` = 'N'
		AND smf.`global_admin_only_flag` = 'N'
		AND smf.`disabled_flag` = 'N'
		";
//AND smf.`show_in_navigation_flag` = 'Y'
//INNER JOIN `software_module_categories` smc ON sm.`software_module_category_id` = smc.`id`
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrIds = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$arrIds[] = $id;		
		}
		$db->free_result();

		return $arrIds;
	}
	function loadAdminProjectOwnerSoftwareModuleFunctionIds($database, $user_company_id, $project_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Verify that the company owns the project
		$query =
		"
		SELECT
		count(*)
		FROM `projects` p
		WHERE p.`id` = ?
		AND `user_company_id` = ?
		";
		$arrValues = array($project_id, $user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		$total = $row['count(*)'];
		if ($total <> 1) {
			return array();
		}

		// Load list for Admins that are project centric
		$query =
		"
		SELECT
		smf.`id`
		FROM `user_companies_to_software_modules` uc2sm
		INNER JOIN `software_modules` sm ON uc2sm.`software_module_id` = sm.`id`
		INNER JOIN `software_module_functions` smf ON sm.`id` = smf.`software_module_id`
		WHERE uc2sm.`user_company_id` = ?
		AND sm.`project_specific_flag` = 'Y'
		AND sm.`disabled_flag` = 'N'
		AND smf.`global_admin_only_flag` = 'N'
		AND smf.`disabled_flag` = 'N'
		";
//AND smf.`show_in_navigation_flag` = 'Y'
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrIds = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$arrIds[] = $id;
		}
		$db->free_result();

		return $arrIds;
	}
	function loadUserNonProjectRoleBasedSoftwareModuleFunctionIds($database, $csvContactIds, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if (empty($csvContactIds)) {
			return array();
		}

		$arrIds = array();

		// By Role, non-project-specific
		// contacts_to_roles, roles_to_software_module_functions
		$query =
		"
		SELECT
		smf.`id`
		FROM `user_companies_to_software_modules` uc2sm
		INNER JOIN `software_modules` sm ON uc2sm.`software_module_id` = sm.`id`
		INNER JOIN `software_module_functions` smf ON sm.`id` = smf.`software_module_id`
		INNER JOIN `roles_to_software_module_functions` r2smf ON (uc2sm.`user_company_id` = r2smf.`user_company_id` AND smf.`id` = r2smf.`software_module_function_id`)
		INNER JOIN `contacts_to_roles` c2r ON r2smf.`role_id` = c2r.`role_id`
		WHERE uc2sm.`user_company_id` = ?
		AND c2r.`contact_id` IN ($csvContactIds)
		AND sm.`project_specific_flag` = 'N'
		AND sm.`disabled_flag` = 'N'
		AND smf.`global_admin_only_flag` = 'N'
		AND smf.`disabled_flag` = 'N'
		";
//WHERE uc2sm.`user_company_id` = $currentlySelectedProjectUserCompanyId
//AND uc2sm.`user_company_id` = r2smf.`user_company_id`
//AND smf.`show_in_navigation_flag` = 'Y'
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		while ($row = $db->fetch()) {
			$id = $row['id'];
			$arrIds[] = $id;
		}
		$db->free_result();

		return $arrIds;
	}
	function loadUserNonProjectContactBasedSoftwareModuleFunctionIds($database, $csvContactIds)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if (empty($csvContactIds)) {
			return array();
		}

		$arrIds = array();

		// By Contact, non-project-specific
		// contacts_to_software_module_functions
		$query =
		"
		SELECT
		smf.`id`
		FROM `user_companies_to_software_modules` uc2sm
		INNER JOIN `contacts` c ON uc2sm.`user_company_id` = c.`user_company_id`
		INNER JOIN `software_modules` sm ON uc2sm.`software_module_id` = sm.`id`
		INNER JOIN `software_module_functions` smf ON sm.`id` = smf.`software_module_id`
		INNER JOIN `contacts_to_software_module_functions` c2smf ON (smf.`id` = c2smf.`software_module_function_id` AND c.`id` = c2smf.`contact_id`	)
		WHERE c2smf.`contact_id` IN ($csvContactIds)
		AND sm.`project_specific_flag` = 'N'
		AND sm.`disabled_flag` = 'N'
		AND smf.`global_admin_only_flag` = 'N'
		AND smf.`disabled_flag` = 'N'
		";
//AND smf.`show_in_navigation_flag` = 'Y'
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		while ($row = $db->fetch()) {
			$id = $row['id'];
			$arrIds[] = $id;
		}
		$db->free_result();

		return $arrIds;
	}
	function loadUserNonProjectAllUsersBasedSoftwareModuleFunctionIds($database, $currentlySelectedProjectUserCompanyId)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$arrIds = array();

		// By All Users, non-project-specific
		// Use the $currentlySelectedProjectUserCompanyId for non-project-specific permissions they have set
		// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=N
		$query =
		"
		SELECT
		smf.`id`
		FROM `user_companies_to_software_modules` uc2sm
		INNER JOIN `software_modules` sm ON uc2sm.`software_module_id` = sm.`id`
		INNER JOIN `software_module_functions` smf ON sm.`id` = smf.`software_module_id`
		INNER JOIN `user_companies_to_all_users_to_software_module_functions` uc2au2smf ON smf.`id` = uc2au2smf.`software_module_function_id`
		WHERE uc2sm.`user_company_id` = ?
		AND uc2au2smf.`user_company_id` = ?
		AND sm.`project_specific_flag` = 'N'
		AND sm.`disabled_flag` = 'N'
		AND smf.`global_admin_only_flag` = 'N'
		AND smf.`disabled_flag` = 'N'
		AND uc2au2smf.`employee_only_flag` = 'N'
		";
//AND smf.`show_in_navigation_flag` = 'Y'
		$arrValues = array($currentlySelectedProjectUserCompanyId, $currentlySelectedProjectUserCompanyId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		while ($row = $db->fetch()) {
			$id = $row['id'];
			$arrIds[] = $id;
		}
		$db->free_result();

		return $arrIds;
	}
	function loadUserProjectSpecificRoleBasedSoftwareModuleFunctionIds($database,$csvContactIds,$currentlySelectedProjectUserCompanyId,					$currentlySelectedProjectId				) {
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if (empty($csvContactIds)) {
			return array();
		}

		$arrIds = array();

		// By Role, project-specific
		// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
		$query =
		"
		SELECT
		smf.`id`
FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm, `software_module_functions` smf, `software_module_categories` smc, `projects_to_contacts_to_roles` p2c2r, `projects_to_roles_to_software_module_functions` p2r2smf ". #, `projects` p
"WHERE uc2sm.`user_company_id` = ?
AND uc2sm.`software_module_id` = sm.`id`
AND sm.`id` = smf.`software_module_id`
AND sm.`software_module_category_id` = smc.`id`
AND smf.`global_admin_only_flag` = 'N'
AND sm.`project_specific_flag` = 'Y'
AND sm.`disabled_flag` = 'N'
AND smf.`disabled_flag` = 'N'
AND p2c2r.`project_id` = ?
AND p2c2r.`project_id` = p2r2smf.`project_id`
AND p2c2r.`contact_id` IN ($csvContactIds)
AND p2c2r.`role_id` = p2r2smf.`role_id`
AND p2r2smf.`software_module_function_id` = smf.`id`
";
//AND smf.`show_in_navigation_flag` = 'Y'
$arrValues = array($currentlySelectedProjectUserCompanyId,$currentlySelectedProjectId);
$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

while ($row = $db->fetch()) {
	$id = $row['id'];
	$arrIds[] = $id;
}
$db->free_result();

return $arrIds;
}
function loadUserProjectSpecificContactBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	if (empty($csvContactIds)) {
		return array();
	}

	$arrIds = array();

		// By Contact, project-specific
		// projects_to_contacts_to_software_module_functions
	$query =
	"
	SELECT
	smf.`id`
	FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm, `software_module_functions` smf, `software_module_categories` smc, `projects_to_contacts_to_software_module_functions` p2c2smf
	WHERE uc2sm.`user_company_id` = ?
	AND uc2sm.`software_module_id` = sm.`id`
	AND sm.`id` = smf.`software_module_id`
	AND sm.`software_module_category_id` = smc.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
	AND p2c2smf.`project_id` = ?
	AND p2c2smf.`contact_id` IN ($csvContactIds)
	AND p2c2smf.`software_module_function_id` = smf.`id`
	";
//AND smf.`show_in_navigation_flag` = 'Y'
	$arrValues = array($currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	while ($row = $db->fetch()) {
		$id = $row['id'];
		$arrIds[] = $id;
	}
	$db->free_result();

	return $arrIds;
}
function loadUserProjectSpecificAllUsersBasedSoftwareModuleFunctionIds($database, $currentlySelectedProjectUserCompanyId)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$arrIds = array();

		// By All Users, project-specific
		// Use the $currentlySelectedProjectUserCompanyId for project-specific permissions they have set
		// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=Y
	$query =
	"
	SELECT
	smf.`id`
	FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm, `software_module_functions` smf, `software_module_categories` smc, `user_companies_to_all_users_to_software_module_functions` uc2au2smf
	WHERE uc2sm.`user_company_id` = ?
	AND uc2sm.`software_module_id` = sm.`id`
	AND sm.`id` = smf.`software_module_id`
	AND sm.`software_module_category_id` = smc.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
	AND uc2au2smf.`user_company_id` = ?
	AND uc2au2smf.`software_module_function_id` = smf.`id`
	AND uc2au2smf.`employee_only_flag` = 'N'
	";
//AND smf.`show_in_navigation_flag` = 'Y'
	$arrValues = array($currentlySelectedProjectUserCompanyId, $currentlySelectedProjectUserCompanyId);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	while ($row = $db->fetch()) {
		$id = $row['id'];
		$arrIds[] = $id;
	}
	$db->free_result();

	return $arrIds;
}
function loadGuestContactIdsCSV($database, $user_company_id, $user_id, $primary_contact_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

		// get all guest contact_id values for convenience
	$AXIS_NON_EXISTENT_CONTACT_ID = AXIS_NON_EXISTENT_CONTACT_ID;
	$query =
	"
	SELECT c.`id` 'contact_id'
	FROM contacts c
	WHERE c.user_id = $user_id
	AND c.user_company_id <> $user_company_id
	AND c.`id` NOT IN ($AXIS_NON_EXISTENT_CONTACT_ID, $primary_contact_id)
	";
	$db->query($query);

	$arrContactIds = array();
	while($row = $db->fetch()) {
		$contact_id = $row['contact_id'];
		$arrContactIds[$contact_id] = 1;
	}
	$db->free_result();
	$arrContactIds = array_keys($arrContactIds);
	$csvContactIds = join(',', $arrContactIds);

	return $csvContactIds;
}
function loadGuestNonProjectRoleBasedSoftwareModuleFunctionIds($database, $guestContactIdCSV, $currentlySelectedProjectUserCompanyId)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	if (empty($guestContactIdCSV)) {
		return array();
	}

	$arrIds = array();

		// By Role, non-project-specific
		// contacts_to_roles, roles_to_software_module_functions
	$query =
	"
	SELECT
	smf.`id`
	FROM
	`user_companies_to_software_modules` uc2sm,
	`software_modules` sm,
	`software_module_functions` smf,
	`software_module_categories` smc,
	`contacts_to_roles` c2r,
	`roles_to_software_module_functions` r2smf,
	`contacts` c
	WHERE uc2sm.`user_company_id` = r2smf.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND sm.`id` = smf.`software_module_id`
	AND sm.`software_module_category_id` = smc.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
	AND c2r.`contact_id` IN ($guestContactIdCSV)
	AND c2r.`contact_id` = c.`id`
	AND c.`user_company_id` = r2smf.`user_company_id`
	AND c2r.`role_id` = r2smf.`role_id`
	AND r2smf.`software_module_function_id` = smf.`id`
	";
//WHERE uc2sm.`user_company_id` = $currentlySelectedProjectUserCompanyId
//AND smf.`show_in_navigation_flag` = 'Y'
	$arrValues = array();
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	while ($row = $db->fetch()) {
		$id = $row['id'];
		$arrIds[] = $id;
	}
	$db->free_result();

	return $arrIds;
}
function loadGuestNonProjectContactBasedSoftwareModuleFunctionIds($database, $csvContactIds)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	if (empty($csvContactIds)) {
		return array();
	}

	$arrIds = array();

		// By Contact, non-project-specific
		// contacts_to_software_module_functions
	$query =
	"
	SELECT
	smf.`id`
	FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm, `software_module_functions` smf, `software_module_categories` smc, `contacts_to_software_module_functions` c2smf, `contacts` c
	WHERE uc2sm.`user_company_id` = c.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND sm.`id` = smf.`software_module_id`
	AND sm.`software_module_category_id` = smc.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
	AND c.`id` = c2smf.`contact_id`
	AND c2smf.`contact_id` IN ($csvContactIds)
	AND c2smf.`software_module_function_id` = smf.`id`
	";
//AND smf.`show_in_navigation_flag` = 'Y'
	$arrValues = array();
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	while ($row = $db->fetch()) {
		$id = $row['id'];
		$arrIds[] = $id;
	}
	$db->free_result();

	return $arrIds;
}
function loadGuestNonProjectAllUsersBasedSoftwareModuleFunctionIds($database, $currentlySelectedProjectUserCompanyId)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$arrIds = array();

		// By All Users, non-project-specific
		// Use the $currentlySelectedProjectUserCompanyId for non-project-specific permissions they have set
		// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=N
	$query =
	"
	SELECT
	smf.`id`
	FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm, `software_module_functions` smf, `software_module_categories` smc, `user_companies_to_all_users_to_software_module_functions` uc2au2smf
	WHERE uc2sm.`user_company_id` = ?
	AND uc2sm.`software_module_id` = sm.`id`
	AND sm.`id` = smf.`software_module_id`
	AND sm.`software_module_category_id` = smc.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
	AND uc2au2smf.`user_company_id` = ?
	AND uc2au2smf.`software_module_function_id` = smf.`id`
	AND uc2au2smf.`employee_only_flag` = 'N'
	";
//AND smf.`show_in_navigation_flag` = 'Y'
	$arrValues = array($currentlySelectedProjectUserCompanyId, $currentlySelectedProjectUserCompanyId);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	while ($row = $db->fetch()) {
		$id = $row['id'];
		$arrIds[] = $id;
	}
	$db->free_result();

	return $arrIds;
}
function loadGuestProjectSpecificRoleBasedSoftwareModuleFunctionIds($database,$csvContactIds,$currentlySelectedProjectUserCompanyId,$currentlySelectedProjectId) {
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	if (empty($csvContactIds)) {
		return array();
	}

	$arrIds = array();

		// By Role, project-specific
		// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
	$query =
	"
	SELECT
	smf.`id`
FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm, `software_module_functions` smf, `software_module_categories` smc, `projects_to_contacts_to_roles` p2c2r, `projects_to_roles_to_software_module_functions` p2r2smf ". #, `projects` p
"WHERE uc2sm.`user_company_id` = ?
AND uc2sm.`software_module_id` = sm.`id`
AND sm.`id` = smf.`software_module_id`
AND sm.`software_module_category_id` = smc.`id`
AND smf.`global_admin_only_flag` = 'N'
AND sm.`project_specific_flag` = 'Y'
AND sm.`disabled_flag` = 'N'
AND smf.`disabled_flag` = 'N'
AND p2c2r.`project_id` = ?
AND p2c2r.`project_id` = p2r2smf.`project_id`
AND p2c2r.`contact_id` IN ($csvContactIds)
AND p2c2r.`role_id` = p2r2smf.`role_id`
AND p2r2smf.`software_module_function_id` = smf.`id`
";
//AND smf.`show_in_navigation_flag` = 'Y'
$arrValues = array($currentlySelectedProjectUserCompanyId,$currentlySelectedProjectId);
$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

while ($row = $db->fetch()) {
	$id = $row['id'];
	$arrIds[] = $id;
}
$db->free_result();

return $arrIds;
}
function loadGuestProjectSpecificContactBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	if (empty($csvContactIds)) {
		return array();
	}

	$arrIds = array();

		// By Contact, project-specific
		// projects_to_contacts_to_software_module_functions
	$query =
	"
	SELECT
	smf.`id`
	FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm, `software_module_functions` smf, `software_module_categories` smc, `projects_to_contacts_to_software_module_functions` p2c2smf
	WHERE uc2sm.`user_company_id` = ?
	AND uc2sm.`software_module_id` = sm.`id`
	AND sm.`id` = smf.`software_module_id`
	AND sm.`software_module_category_id` = smc.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
	AND p2c2smf.`project_id` = ?
	AND p2c2smf.`contact_id` IN ($csvContactIds)
	AND p2c2smf.`software_module_function_id` = smf.`id`
	";
//AND smf.`show_in_navigation_flag` = 'Y'
	$arrValues = array($currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	while ($row = $db->fetch()) {
		$id = $row['id'];
		$arrIds[] = $id;
	}
	$db->free_result();

	return $arrIds;
}
function loadGuestProjectSpecificAllUsersBasedSoftwareModuleFunctionIds($database, $currentlySelectedProjectUserCompanyId)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$arrIds = array();

		// By All Users, project-specific
		// Use the $currentlySelectedProjectUserCompanyId for project-specific permissions they have set
		// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=Y
	$query =
	"
	SELECT
	smf.`id`
	FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm, `software_module_functions` smf, `software_module_categories` smc, `user_companies_to_all_users_to_software_module_functions` uc2au2smf
	WHERE uc2sm.`user_company_id` = ?
	AND uc2sm.`software_module_id` = sm.`id`
	AND sm.`id` = smf.`software_module_id`
	AND sm.`software_module_category_id` = smc.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
	AND uc2au2smf.`user_company_id` = ?
	AND uc2au2smf.`software_module_function_id` = smf.`id`
	AND uc2au2smf.`employee_only_flag` = 'N'
	";
//AND smf.`show_in_navigation_flag` = 'Y'
	$arrValues = array($currentlySelectedProjectUserCompanyId, $currentlySelectedProjectUserCompanyId);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	while ($row = $db->fetch()) {
		$id = $row['id'];
		$arrIds[] = $id;
	}
	$db->free_result();

	return $arrIds;
}
function loadRolesListByProjectIdAndContactId($database, $project_id, $contact_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$query =
	"
	SELECT r.*
	FROM `projects_to_contacts_to_roles` p2c2r, `roles` r
	WHERE p2c2r.`project_id` = ?
	AND p2c2r.`contact_id` = ?
	AND p2c2r.`role_id` = r.`id`
	";
	$arrValues = array($project_id, $contact_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrRolesList = array();
	while ($row = $db->fetch()) {
		$role_id = $row['id'];

		$r = new Role($database);
		$key = array('id' => $role_id);
		$r->setKey($key);
		$r->setData($row);
		$r->convertDataToProperties();

		$arrRolesList[$role_id] = $r;
	}
	$db->free_result();

	return $arrRolesList;
}
function loadContactsToRolesByContactId($database, $contact_id, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrContactsToRolesByContactId = null;
		}

		$arrContactsToRolesByContactId = array();

		if (isset($arrContactsToRolesByContactId) && !empty($arrContactsToRolesByContactId)) {
			return $arrContactsToRolesByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToRole = new ContactToRole($database);
			$sqlOrderByColumns = $tmpContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		 $query =
"
SELECT
	c2r.*

FROM `contacts_to_roles` c2r
WHERE c2r.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `role_id` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToRolesByContactId = array();
		while ($row = $db->fetch()) {
			// $contactToRole = self::instantiateOrm($database, 'ContactToRole', $row);
			/* @var $contactToRole ContactToRole */
			$arrContactsToRolesByContactId[] = $row;
		}

		$db->free_result();

		// self::$_arrContactsToRolesByContactId = $arrContactsToRolesByContactId;
		return $arrContactsToRolesByContactId;
	}
	function loadGlobalAdminSoftwareModuleFunctionIds($database)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Global Admins get to see all menu options
		$query =
"
SELECT
	smf.`id`
FROM `software_module_functions` smf
";
		$db->query($query);

		$arrIds = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$arrIds[] = $id;
		}
		$db->free_result();

		return $arrIds;
	}