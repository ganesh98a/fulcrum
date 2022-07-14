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
 * Permissions class.
 *
 * "Is A":
 * Software Module Function (software_module_functions).
 *
 * "Has A":
 * 1) a
 * 2) b
 * 3) c
 *
 * @category	Framework
 * @package		Permissions
 */

/**
 * Data
 */
//Already Included...commented out for performance gain
//require_once('lib/common/Data.php');










class RN_Permissions extends IntegratedMapper
{
	/**
	 * Static class instance variable for singleton pattern.
	 *
	 * @var Application Object Reference
	 */
	private static $_instance;

	// Core Permissions Variables
	protected $user_company_id;
	protected $user_id;
	protected $user_role_id;
	protected $userRole;
	protected $primary_contact_id;
	protected $currentlySelectedProjectId;
	protected $currentlySelectedProjectUserCompanyId;
	protected $currentlyActiveContactId;

	// The user's company owns the project
	protected $projectOwnerFlag;

	// The user has a userRole of "admin" for his company and his company owns the project
	protected $projectOwnerAdminFlag;

	protected $paying_customer_flag;

	// role_id list from contacts_to_roles using <primary_contact_id>
	protected $contactRoles;

	// role_id list from projects_to_contacts_to_roles using <$currentlySelectedProjectId, $currentlyActiveContactId>
	protected $projectRoles;

	// Permissions Matrix by id values
	private $arrPermissions; // All permissions (show_in_navigation_flag = y/n)
	private $arrMenu; // Menu permissions (show_in_navigation_flag = y only)

	/**
	 * @todo Delete $arrNav.
	 */
	private $arrNav; // Old Menu permissions (show_in_navigation_flag = y only) - will be deleted

	private $arrSoftwareModuleCategorySortOrder;

	public $arrSoftwareModuleCategories;
	public $arrSoftwareModules;
	public $arrSoftwareModuleFunctions;

	public $arrSoftwareModulesByModule;
	public $arrSoftwareModuleFunctionsByFunction;

	public $arrSoftwareModuleUrls;
	public $arrSoftwareModuleFunctionUrls;

	/**
	 * Singleton global application initialization class.  This class could be called Init.
	 *
	 * Only one control object is necessary to initialize a given script for the application
	 * that it belongs to.
	 *
	 * @param string $application
	 * @return Application object reference
	 */
	public static function getInstance()
	{
		$instance = self::$_instance;

		if (!isset($instance)) {
			$instance = new RN_Permissions();
			self::$_instance = $instance;
		}

		return $instance;
	}

	/**
	 * Constructor
	 */
	public function __construct()
	{
	}

	public function getUserCompanyId()
	{
		if (isset($this->user_company_id)) {
			return $this->user_company_id;
		} else {
			return null;
		}
	}

	public function setUserCompanyId($user_company_id)
	{
		$this->user_company_id = $user_company_id;
	}

	public function getUserId()
	{
		if (isset($this->user_id)) {
			return $this->user_id;
		} else {
			return null;
		}
	}

	public function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	public function getUserRoleId()
	{
		if (isset($this->user_role_id)) {
			return $this->user_role_id;
		} else {
			return null;
		}
	}

	public function setUserRoleId($user_role_id)
	{
		$this->user_role_id = $user_role_id;
	}

	public function getUserRole()
	{
		if (isset($this->userRole)) {
			return $this->userRole;
		} else {
			return null;
		}
	}

	public function setUserRole($userRole)
	{
		$this->userRole = $userRole;
	}

	public function getPrimaryContactId()
	{
		if (isset($this->primary_contact_id)) {
			return $this->primary_contact_id;
		} else {
			return null;
		}
	}

	public function setPrimaryContactId($primary_contact_id)
	{
		$this->primary_contact_id = $primary_contact_id;
	}

	public function getCurrentlySelectedProjectId()
	{
		if (isset($this->currentlySelectedProjectId)) {
			return $this->currentlySelectedProjectId;
		} else {
			return null;
		}
	}

	public function setCurrentlySelectedProjectId($currentlySelectedProjectId)
	{
		$this->currentlySelectedProjectId = $currentlySelectedProjectId;
	}

	public function getCurrentlySelectedProjectUserCompanyId()
	{
		if (isset($this->currentlySelectedProjectUserCompanyId)) {
			return $this->currentlySelectedProjectUserCompanyId;
		} else {
			return null;
		}
	}

	public function setCurrentlySelectedProjectUserCompanyId($currentlySelectedProjectUserCompanyId)
	{
		$this->currentlySelectedProjectUserCompanyId = $currentlySelectedProjectUserCompanyId;
	}

	public function getCurrentlyActiveContactId()
	{
		if (isset($this->currentlyActiveContactId)) {
			return $this->currentlyActiveContactId;
		} else {
			return null;
		}
	}

	public function setCurrentlyActiveContactId($currentlyActiveContactId)
	{
		$this->currentlyActiveContactId = $currentlyActiveContactId;
	}

	public function getPayingCustomerFlag()
	{
		if (isset($this->paying_customer_flag)) {
			return $this->paying_customer_flag;
		} else {
			return null;
		}
	}

	public function setPayingCustomerFlag($paying_customer_flag)
	{
		$this->paying_customer_flag = $paying_customer_flag;
	}

	public function getProjectOwnerFlag()
	{
		if (isset($this->projectOwnerFlag)) {
			return $this->projectOwnerFlag;
		} else {
			return null;
		}
	}

	public function setProjectOwnerFlag($projectOwnerFlag)
	{
		$this->projectOwnerFlag = $projectOwnerFlag;
	}

	public function getProjectOwnerAdminFlag()
	{
		if (isset($this->projectOwnerAdminFlag)) {
			return $this->projectOwnerAdminFlag;
		} else {
			return null;
		}
	}

	public function setProjectOwnerAdminFlag($projectOwnerAdminFlag)
	{
		$this->projectOwnerAdminFlag = $projectOwnerAdminFlag;
	}

	public function getContactRoles()
	{
		if (isset($this->contactRoles)) {
			return $this->contactRoles;
		} else {
			return null;
		}
	}

	public function setContactRoles($contactRoles)
	{
		$this->contactRoles = $contactRoles;
	}

	public function getProjectRoles()
	{
		if (isset($this->projectRoles)) {
			return $this->projectRoles;
		} else {
			return null;
		}
	}

	public function setProjectRoles($projectRoles)
	{
		$this->projectRoles = $projectRoles;
	}

	public function getArrPermissions()
	{
		if (isset($this->arrPermissions)) {
			$arrPermissions = $this->arrPermissions;
		} else {
			$arrPermissions = array();
		}

		return $arrPermissions;
	}

	public function setArrPermissions($arrPermissions)
	{
		$this->arrPermissions = $arrPermissions;
	}

	public function getArrMenu()
	{
		if (isset($this->arrMenu)) {
			$arrMenu = $this->arrMenu;
		} else {
			$arrMenu = array();
		}

		return $arrMenu;
	}

	public function setArrMenu($arrMenu)
	{
		$this->arrMenu = $arrMenu;
	}

	public function getArrNav()
	{
		if (isset($this->arrNav)) {
			$arrNav = $this->arrNav;
		} else {
			$arrNav = array();
		}

		return $arrNav;
	}

	public function setArrNav($arrNav)
	{
		$this->arrNav = $arrNav;
	}

	public function setArrSoftwareModuleCategorySortOrder($arrSoftwareModuleCategorySortOrder)
	{
		$this->arrSoftwareModuleCategorySortOrder = $arrSoftwareModuleCategorySortOrder;
	}

	public function getArrSoftwareModuleCategorySortOrder()
	{

		if (isset($this->arrSoftwareModuleCategorySortOrder)) {
			$arrSoftwareModuleCategorySortOrder = $this->arrSoftwareModuleCategorySortOrder;
		} else {
			$arrSoftwareModuleCategorySortOrder = array();
		}

		return $arrSoftwareModuleCategorySortOrder;
	}

	public function getArrSoftwareModuleCategories()
	{
		if (isset($this->arrSoftwareModuleCategories)) {
			$arrSoftwareModuleCategories = $this->arrSoftwareModuleCategories;
		} else {
			$arrSoftwareModuleCategories = array();
		}

		return $arrSoftwareModuleCategories;
	}

	public function setArrSoftwareModuleCategories($arrSoftwareModuleCategories)
	{
		$this->arrSoftwareModuleCategories = $arrSoftwareModuleCategories;
	}

	public function getArrSoftwareModules()
	{
		if (isset($this->arrSoftwareModules)) {
			$arrSoftwareModules = $this->arrSoftwareModules;
		} else {
			$arrSoftwareModules = array();
		}

		return $arrSoftwareModules;
	}

	public function setArrSoftwareModules($arrSoftwareModules)
	{
		$this->arrSoftwareModules = $arrSoftwareModules;
	}

	public function getArrSoftwareModuleFunctions()
	{
		if (isset($this->arrSoftwareModuleFunctions)) {
			$arrSoftwareModuleFunctions = $this->arrSoftwareModuleFunctions;
		} else {
			$arrSoftwareModuleFunctions = array();
		}

		return $arrSoftwareModuleFunctions;
	}

	public function setArrSoftwareModuleFunctions($arrSoftwareModuleFunctions)
	{
		$this->arrSoftwareModuleFunctions = $arrSoftwareModuleFunctions;
	}

	public function getArrSoftwareModulesByModule()
	{
		if (isset($this->arrSoftwareModulesByModule)) {
			$arrSoftwareModulesByModule = $this->arrSoftwareModulesByModule;
		} else {
			$arrSoftwareModulesByModule = array();
		}

		return $arrSoftwareModulesByModule;
	}

	public function setArrSoftwareModulesByModule($arrSoftwareModulesByModule)
	{
		$this->arrSoftwareModulesByModule = $arrSoftwareModulesByModule;
	}

	public function getArrSoftwareModuleFunctionsByFunction()
	{
		if (isset($this->arrSoftwareModuleFunctionsByFunction)) {
			$arrSoftwareModuleFunctionsByFunction = $this->arrSoftwareModuleFunctionsByFunction;
		} else {
			$arrSoftwareModuleFunctionsByFunction = array();
		}

		return $arrSoftwareModuleFunctionsByFunction;
	}

	public function setArrSoftwareModuleFunctionsByFunction($arrSoftwareModuleFunctionsByFunction)
	{
		$this->arrSoftwareModuleFunctionsByFunction = $arrSoftwareModuleFunctionsByFunction;
	}

	public function getArrSoftwareModuleUrls()
	{
		if (isset($this->arrSoftwareModuleUrls)) {
			$arrSoftwareModuleUrls = $this->arrSoftwareModuleUrls;
		} else {
			$arrSoftwareModuleUrls = array();
		}

		return $arrSoftwareModuleUrls;
	}

	public function setArrSoftwareModuleUrls($arrSoftwareModuleUrls)
	{
		$this->arrSoftwareModuleUrls = $arrSoftwareModuleUrls;
	}

	public function getArrSoftwareModuleFunctionUrls()
	{
		if (isset($this->arrSoftwareModuleFunctionUrls)) {
			$arrSoftwareModuleFunctionUrls = $this->arrSoftwareModuleFunctionUrls;
		} else {
			$arrSoftwareModuleFunctionUrls = array();
		}

		return $arrSoftwareModuleFunctionUrls;
	}

	public function setArrSoftwareModuleFunctionUrls($arrSoftwareModuleFunctionUrls)
	{
		$this->arrSoftwareModuleFunctionUrls = $arrSoftwareModuleFunctionUrls;
	}

	public function deriveSoftwareModuleFunctionLabelFromUrl($url)
	{
		$arrSoftwareModuleFunctionUrls = $this->getArrSoftwareModuleFunctionUrls();

		if (isset($arrSoftwareModuleFunctionUrls[$url])) {
			$softwareModuleFunctionLabel = $arrSoftwareModuleFunctionUrls[$url];
		} else {
			$softwareModuleFunctionLabel = '';
		}

		return $softwareModuleFunctionLabel;
	}

	public function determineAccessToSoftwareModule($software_module)
	{
		$arrSoftwareModules = $this->getArrSoftwareModulesByModule();

		if (isset($arrSoftwareModules[$software_module])) {
			$access = true;
		} else {
			$access = false;
		}

		return $access;
	}

	public function determineAccessToSoftwareModuleFunction($software_module_function)
	{
		$arrSoftwareModuleFunctions = $this->getArrSoftwareModuleFunctionsByFunction();

		if (isset($arrSoftwareModuleFunctions[$software_module_function])) {
			$access = true;
		} else {
			$access = false;
		}

		return $access;
	}

	public static function loadContactsForSoftwareModulePermissionsMatrix($database, $user_company_id, $software_module_id, $project_id=null)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Sanity check to ensure that the user_company_id has access to this software_module_id
		$query =
"
SELECT
	sm.`project_specific_flag`
FROM `user_companies_to_software_modules` uc2sm
	INNER JOIN `software_modules` sm ON uc2sm.`software_module_id` = sm.`id`
WHERE uc2sm.`user_company_id` = ?
AND sm.`id` = ?
AND sm.`global_admin_only_flag` = 'N'
AND sm.`customer_configurable_flag` = 'Y'
";
		$arrValues = array($user_company_id, $software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if (!isset($row) || empty($row)) {
			return array();
		} else {
			$project_specific_flag = $row['project_specific_flag'];
		}

		$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		$arrContactCompanyIds = array();
		$arrContactIds = array();

		// Sortable attributes
		$arrSortableContactCompanyNames = array();
		$arrSortableContactEmailAddresses = array();
		$arrSortableContactFullNames = array();
		$arrSortableContactFirstNames = array();
		$arrSortableContactLastNames = array();
		$arrSortableRoleNames = array();

		// Load sortable attributes - roles
		$loadAllRolesOptions = new Input();
		$loadAllRolesOptions->forceLoadFlag = true;
		$arrRoles = Role::loadAllRoles($database, $loadAllRolesOptions);
		foreach ($arrRoles as $role_id => $role) {
			$arrSortableRoleNames[$role->role] = $role_id;
		}


		/*
		$query =
"
SELECT
	r.*
FROM `roles` r
".//"WHERE `id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN,$AXIS_USER_ROLE_ID_ADMIN)
"WHERE `id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN)
";
		$db->query($query, MYSQLI_USE_RESULT);
		$arrRoles = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];
			$role_name = $row['role'];

			$row['id'] = $role_id;
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			$role->convertPropertiesToData();

			$arrRoles[$role_id] = $role;
			$arrSortableRoleNames[$role_name] = $role_id;
		}
		$db->free_result();
		*/
		/* @var $role Role */


		if ($project_specific_flag == 'Y') {
			// Load role-based contact_id values
			// By Project By Role, project-specific
			// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
			$query =
"
SELECT
	smf.`id` 'software_module_function_id',
	p2c2r.`contact_id`,
	p2c2r.`role_id`
FROM
	`contacts` c,
	`projects_to_contacts_to_roles` p2c2r,
	`projects_to_roles_to_software_module_functions` p2r2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = ?
	AND c.`id` = p2c2r.`contact_id`
	AND p2c2r.`project_id` = ?
	AND p2c2r.`role_id` = p2r2smf.`role_id`
	AND p2c2r.`project_id` = p2r2smf.`project_id`
	AND p2r2smf.`software_module_function_id` = smf.`id`
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = ?
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'

			$arrValues = array($user_company_id, $project_id, $software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrRoleBasedContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			$arrContactIdsToRoleIds = array();
			$arrRoleIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$contact_id = $row['contact_id'];
				$role_id = $row['role_id'];

				$arrRoleBasedContactIds[$contact_id] = 1;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = 1;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToRoleIds[$contact_id][$role_id] = 1;
				$arrRoleIdsToContactIds[$role_id][$contact_id] = 1;
			}
			$db->free_result();

			$arrRoleBased = array(
				'contacts_ids' => $arrRoleBasedContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
				'contact_ids_to_role_ids' => $arrContactIdsToRoleIds,
				'role_ids_to_contact_ids' => $arrRoleIdsToContactIds,
			);

			// Load ad-hoc contact_id values
			// By Project By Contact, project-specific
			// projects_to_contacts_to_software_module_functions
			$query =
"
SELECT
	p2c2smf.*
FROM
	`contacts` c,
	`projects_to_contacts_to_software_module_functions` p2c2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = ?
	AND c.`id` = p2c2smf.`contact_id`
	AND p2c2smf.`project_id` = ?
	AND p2c2smf.`software_module_function_id` = smf.`id`
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = ?
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array($user_company_id, $project_id, $software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrAdHocContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$contact_id = $row['contact_id'];

				$arrAdHocContactIds[$contact_id] = 1;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = 1;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = 1;
			}
			$db->free_result();

			$arrAdHoc = array(
				'contacts_ids' => $arrAdHocContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
			);
		} else {
			// Load role-based contact_id values
			// By Role, non-project-specific
			// contacts_to_roles, roles_to_software_module_functions
			$query =
"
SELECT
	smf.`id` 'software_module_function_id',
	c2r.*
FROM
	`contacts` c,
	`contacts_to_roles` c2r,
	`roles_to_software_module_functions` r2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = ?
	AND c.`id` = c2r.`contact_id`
	AND c2r.`role_id` = r2smf.`role_id`
	AND r2smf.`user_company_id` = uc2sm.`user_company_id`
	AND r2smf.`software_module_function_id` = smf.`id`
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = ?
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array($user_company_id, $software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrRoleBasedContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			$arrContactIdsToRoleIds = array();
			$arrRoleIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$contact_id = $row['contact_id'];
				$role_id = $row['role_id'];

				$arrRoleBasedContactIds[$contact_id] = 1;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = 1;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToRoleIds[$contact_id][$role_id] = 1;
				$arrRoleIdsToContactIds[$role_id][$contact_id] = 1;
			}
			$db->free_result();

			$arrRoleBased = array(
				'contacts_ids' => $arrRoleBasedContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
				'contact_ids_to_role_ids' => $arrContactIdsToRoleIds,
				'role_ids_to_contact_ids' => $arrRoleIdsToContactIds,
			);

			// Load ad-hoc contact_id values
			// By Contact, non-project-specific
			// contacts_to_software_module_functions
			$query =
"
SELECT
	c2smf.*
FROM
	`contacts` c,
	`contacts_to_software_module_functions` c2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = ?
	AND c.`id` = c2smf.`contact_id`
	AND c2smf.`software_module_function_id` = smf.`id`
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = ?
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'

			$arrValues = array($user_company_id, $software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrAdHocContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$contact_id = $row['contact_id'];
				$software_module_function_id = $row['software_module_function_id'];

				$arrAdHocContactIds[$contact_id] = 1;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = 1;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = 1;
			}
			$db->free_result();

			$arrAdHoc = array(
				'contacts_ids' => $arrAdHocContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
			);
		}

		// Load Admin contact_id list
		$arrAdminContactIds = Contact::loadAdminContactIdListByUserCompanyId($database, $user_company_id);

		/**
		 * @todo Determine if: do wee need $arrAdminContactCompanyIds? should just be the $user_company_id value that was passed in
		 */
		$arrAdminContactCompanyIds = array();

		// merge contact_id lists together
		$arrContactIds = $arrAdminContactIds + $arrRoleBasedContactIds + $arrAdHocContactIds;

		// Map id values to objects in one place
		// Load details for each contact_id
		$arrContactCompanies = array();
		$arrContacts = array();


		// Load contacts records
		if (!empty($arrContactIds)) {
			$arrContactIds = array_keys($arrContactIds);
			$arrContacts = Contact::loadContactsByArrContactIds($database, $arrContactIds);
			//$arrContacts = Contact::loadContactsByArrContactIds($database, $arrContactIds, $options=null);
		}

		//foreach ($arrContactIds as $contact_id => $null) {
		foreach ($arrContacts as $contact_id => $contact) {
			/* @var $contact Contact */

			/*
			$contact = Contact::findContactById($database, $contact_id, true);
			if (!$contact) {
				continue;
			}
			$arrContacts[$contact_id] = $contact;
			*/

			// contact roles
			$arrRolesForThisContact = array();
			if (isset($arrContactIdsToRoleIds[$contact_id])) {
				$arrTmpRoleIds = $arrContactIdsToRoleIds[$contact_id];
				foreach ($arrTmpRoleIds as $role_id => $null) {
					$role = $arrRoles[$role_id];
					$arrRolesForThisContact[$role_id] = $role;
				}
				$contact->setRoles($arrRolesForThisContact);
			}

			// sortable attributes - contacts
			$email = $contact->email;
			$contactFullName = $contact->getContactFullName();
			$first_name = $contact->first_name;
			$last_name = $contact->last_name;
			// unique index (`user_company_id`, `contact_company_id`, `email`, `first_name`, `last_name`)
			$contactEmailSortKey = $email.'::'.$contactFullName.'::'.$first_name.'::'.$last_name;
			$contactFullNameSortKey = $contactFullName.'::'.$email.'::'.$first_name.'::'.$last_name;
			$contactFirstNameSortKey = $first_name.'::'.$last_name.'::'.$contactFullName.'::'.$email;
			$contactLastNameSortKey = $last_name.'::'.$first_name.'::'.$contactFullName.'::'.$email;
			$arrSortableContactEmailAddresses[$contactEmailSortKey] = $contact_id;
			$arrSortableContactFullNames[$contactFullNameSortKey] = $contact_id;
			$arrSortableContactFirstNames[$contactFirstNameSortKey] = $contact_id;
			$arrSortableContactLastNames[$contactLastNameSortKey] = $contact_id;

			// sortable attributes - contact_companies
			$contactCompany = $contact->getContactCompany();
			$contact_company_id = $contactCompany->contact_company_id;
			$contact_company_name = $contactCompany->contact_company_name;
			$employer_identification_number = $contactCompany->employer_identification_number;
			// unique index (`company`, `employer_identification_number`, `user_user_company_id`)
			$contactCompanySortKey = $contact_company_name.'::'.$employer_identification_number;
			$arrSortableContactCompanyNames[$contactCompanySortKey] = $contact_company_id;

			$arrContactCompanies[$contact_company_id] = $contactCompany;
		}

		$arrReturn = array(
			'roles_objects' => $arrRoles,
			'contact_companies_objects' => $arrContactCompanies,
			'contacts_objects' => $arrContacts,
			'role_based' => $arrRoleBased,
			'ad_hoc' => $arrAdHoc,

			'sortable_roles_by_name' => $arrSortableRoleNames,
			'sortable_contact_companies_by_name' => $arrSortableContactCompanyNames,
			'sortable_contacts_by_email' => $arrSortableContactEmailAddresses,
			'sortable_contacts_by_full_name' => $arrSortableContactFullNames,
			'sortable_contacts_by_first_name' => $arrSortableContactFirstNames,
			'sortable_contacts_by_last_name' => $arrSortableContactLastNames,

			/**
			 * @todo do we need these?
			 */
			'admin_contact_company_ids' => array(),
			'admin_contact_ids' => $arrAdminContactIds,
		);

		return $arrReturn;
	}

	public static function loadContactsForSoftwareModulePermissionsMatrixApi($database, $user_company_id, $software_module_id, $project_id=null)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Sanity check to ensure that the user_company_id has access to this software_module_id
		$query =
"
SELECT
	sm.`project_specific_flag`
FROM `user_companies_to_software_modules` uc2sm
	INNER JOIN `software_modules` sm ON uc2sm.`software_module_id` = sm.`id`
WHERE uc2sm.`user_company_id` = ?
AND sm.`id` = ?
AND sm.`global_admin_only_flag` = 'N'
AND sm.`customer_configurable_flag` = 'Y'
";
		$arrValues = array($user_company_id, $software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if (!isset($row) || empty($row)) {
			return array();
		} else {
			$project_specific_flag = $row['project_specific_flag'];
		}

		$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		$arrContactCompanyIds = array();
		$arrContactIds = array();

		// Sortable attributes
		$arrSortableContactCompanyNames = array();
		$arrSortableContactEmailAddresses = array();
		$arrSortableContactFullNames = array();
		$arrSortableContactFirstNames = array();
		$arrSortableContactLastNames = array();
		$arrSortableRoleNames = array();

		// Load sortable attributes - roles
		$loadAllRolesOptions = new Input();
		$loadAllRolesOptions->forceLoadFlag = true;
		$arrRoles = Role::loadAllRoles($database, $loadAllRolesOptions);
		foreach ($arrRoles as $role_id => $role) {
			$arrSortableRoleNames[$role->role] = $role_id;
		}


		/*
		$query =
"
SELECT
	r.*
FROM `roles` r
".//"WHERE `id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN,$AXIS_USER_ROLE_ID_ADMIN)
"WHERE `id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN)
";
		$db->query($query, MYSQLI_USE_RESULT);
		$arrRoles = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];
			$role_name = $row['role'];

			$row['id'] = $role_id;
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			$role->convertPropertiesToData();

			$arrRoles[$role_id] = $role;
			$arrSortableRoleNames[$role_name] = $role_id;
		}
		$db->free_result();
		*/
		/* @var $role Role */


		if ($project_specific_flag == 'Y') {
			// Load role-based contact_id values
			// By Project By Role, project-specific
			// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
	
	 $query="SELECT smf.`id` 'software_module_function_id', p2c2r.`contact_id`, p2c2r.`role_id` FROM `contacts` as c inner join `projects_to_contacts_to_roles` as p2c2r on c.`id` = p2c2r.`contact_id`
	  inner join `projects_to_roles_to_software_module_functions` as p2r2smf on p2c2r.`project_id` = p2r2smf.`project_id`
	   inner join `software_module_functions` as smf on p2r2smf.`software_module_function_id` = smf.`id`
	    inner join `software_modules` as sm on smf.`software_module_id` = sm.`id`
	     inner join `user_companies_to_software_modules` as uc2sm on uc2sm.`software_module_id` = sm.`id` 
	     WHERE c.`user_company_id` = ? 
	     AND p2c2r.`project_id` = ? 
	     AND sm.`id` = ? 
	     AND c.`user_company_id` = uc2sm.`user_company_id` 
	     AND p2c2r.`role_id` = p2r2smf.`role_id`
	     AND smf.`global_admin_only_flag` = 'N' 
	     AND sm.`project_specific_flag` = 'Y' 
	     AND sm.`disabled_flag` = 'N' 
	     AND smf.`disabled_flag` = 'N' ";
// 		$query =
// "
// SELECT
// 	smf.`id` 'software_module_function_id',
// 	p2c2r.`contact_id`,
// 	p2c2r.`role_id`
// FROM
// 	`contacts` c,
// 	`projects_to_contacts_to_roles` p2c2r,
// 	`projects_to_roles_to_software_module_functions` p2r2smf,
// 	`software_module_functions` smf,
// 	`software_modules` sm,
// 	`user_companies_to_software_modules` uc2sm
// WHERE c.`user_company_id` = ?
// 	AND c.`id` = p2c2r.`contact_id`
// 	AND p2c2r.`project_id` = ?
// 	AND p2c2r.`role_id` = p2r2smf.`role_id`
// 	AND p2c2r.`project_id` = p2r2smf.`project_id`
// 	AND p2r2smf.`software_module_function_id` = smf.`id`
// 	AND smf.`software_module_id` = sm.`id`
// 	AND sm.`id` = ?
// 	AND c.`user_company_id` = uc2sm.`user_company_id`
// 	AND uc2sm.`software_module_id` = sm.`id`
// 	AND smf.`global_admin_only_flag` = 'N'
// 	AND sm.`project_specific_flag` = 'Y'
// 	AND sm.`disabled_flag` = 'N'
// 	AND smf.`disabled_flag` = 'N'
// ";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'

			$arrValues = array($user_company_id, $project_id, $software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrRoleBasedContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			$arrContactIdsToRoleIds = array();
			$arrRoleIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$contact_id = $row['contact_id'];
				$role_id = $row['role_id'];

				$arrRoleBasedContactIds[$contact_id] = 1;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = 1;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToRoleIds[$contact_id][$role_id] = 1;
				$arrRoleIdsToContactIds[$role_id][$contact_id] = 1;
			}
			$db->free_result();

			$arrRoleBased = array(
				'contacts_ids' => $arrRoleBasedContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
				'contact_ids_to_role_ids' => $arrContactIdsToRoleIds,
				'role_ids_to_contact_ids' => $arrRoleIdsToContactIds,
			);

			// Load ad-hoc contact_id values
			// By Project By Contact, project-specific
			// projects_to_contacts_to_software_module_functions
			$query =
"
SELECT
	p2c2smf.*
FROM
	`contacts` c,
	`projects_to_contacts_to_software_module_functions` p2c2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = ?
	AND c.`id` = p2c2smf.`contact_id`
	AND p2c2smf.`project_id` = ?
	AND p2c2smf.`software_module_function_id` = smf.`id`
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = ?
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array($user_company_id, $project_id, $software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrAdHocContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$contact_id = $row['contact_id'];

				$arrAdHocContactIds[$contact_id] = 1;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = 1;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = 1;
			}
			$db->free_result();

			$arrAdHoc = array(
				'contacts_ids' => $arrAdHocContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
			);
		} else {
			// Load role-based contact_id values
			// By Role, non-project-specific
			// contacts_to_roles, roles_to_software_module_functions
			$query =
"
SELECT
	smf.`id` 'software_module_function_id',
	c2r.*
FROM
	`contacts` c,
	`contacts_to_roles` c2r,
	`roles_to_software_module_functions` r2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = ?
	AND c.`id` = c2r.`contact_id`
	AND c2r.`role_id` = r2smf.`role_id`
	AND r2smf.`user_company_id` = uc2sm.`user_company_id`
	AND r2smf.`software_module_function_id` = smf.`id`
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = ?
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array($user_company_id, $software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrRoleBasedContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			$arrContactIdsToRoleIds = array();
			$arrRoleIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$contact_id = $row['contact_id'];
				$role_id = $row['role_id'];

				$arrRoleBasedContactIds[$contact_id] = 1;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = 1;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToRoleIds[$contact_id][$role_id] = 1;
				$arrRoleIdsToContactIds[$role_id][$contact_id] = 1;
			}
			$db->free_result();

			$arrRoleBased = array(
				'contacts_ids' => $arrRoleBasedContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
				'contact_ids_to_role_ids' => $arrContactIdsToRoleIds,
				'role_ids_to_contact_ids' => $arrRoleIdsToContactIds,
			);

			// Load ad-hoc contact_id values
			// By Contact, non-project-specific
			// contacts_to_software_module_functions
			$query =
"
SELECT
	c2smf.*
FROM
	`contacts` c,
	`contacts_to_software_module_functions` c2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = ?
	AND c.`id` = c2smf.`contact_id`
	AND c2smf.`software_module_function_id` = smf.`id`
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = ?
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'

			$arrValues = array($user_company_id, $software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrAdHocContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$contact_id = $row['contact_id'];
				$software_module_function_id = $row['software_module_function_id'];

				$arrAdHocContactIds[$contact_id] = 1;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = 1;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = 1;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = 1;
			}
			$db->free_result();

			$arrAdHoc = array(
				'contacts_ids' => $arrAdHocContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
			);
		}

		// Load Admin contact_id list
		$arrAdminContactIds = Contact::loadAdminContactIdListByUserCompanyId($database, $user_company_id);

		/**
		 * @todo Determine if: do wee need $arrAdminContactCompanyIds? should just be the $user_company_id value that was passed in
		 */
		$arrAdminContactCompanyIds = array();

		// merge contact_id lists together
		$arrContactIds = $arrAdminContactIds + $arrRoleBasedContactIds + $arrAdHocContactIds;

		// Map id values to objects in one place
		// Load details for each contact_id
		$arrContactCompanies = array();
		$arrContacts = array();


		// Load contacts records
		if (!empty($arrContactIds)) {
			$arrContactIds = array_keys($arrContactIds);
			$arrContacts = Contact::loadContactsByArrContactIds($database, $arrContactIds);
			//$arrContacts = Contact::loadContactsByArrContactIds($database, $arrContactIds, $options=null);
		}

		//foreach ($arrContactIds as $contact_id => $null) {
		foreach ($arrContacts as $contact_id => $contact) {
			/* @var $contact Contact */

			/*
			$contact = Contact::findContactById($database, $contact_id, true);
			if (!$contact) {
				continue;
			}
			$arrContacts[$contact_id] = $contact;
			*/

			// contact roles
			$arrRolesForThisContact = array();
			if (isset($arrContactIdsToRoleIds[$contact_id])) {
				$arrTmpRoleIds = $arrContactIdsToRoleIds[$contact_id];
				foreach ($arrTmpRoleIds as $role_id => $null) {
					$role = $arrRoles[$role_id];
					$arrRolesForThisContact[$role_id] = $role;
				}
				$contact->setRoles($arrRolesForThisContact);
			}

			// sortable attributes - contacts
			$email = $contact->email;
			$contactFullName = $contact->getContactFullName();
			$first_name = $contact->first_name;
			$last_name = $contact->last_name;
			// unique index (`user_company_id`, `contact_company_id`, `email`, `first_name`, `last_name`)
			$contactEmailSortKey = $email.'::'.$contactFullName.'::'.$first_name.'::'.$last_name;
			$contactFullNameSortKey = $contactFullName.'::'.$email.'::'.$first_name.'::'.$last_name;
			$contactFirstNameSortKey = $first_name.'::'.$last_name.'::'.$contactFullName.'::'.$email;
			$contactLastNameSortKey = $last_name.'::'.$first_name.'::'.$contactFullName.'::'.$email;
			$arrSortableContactEmailAddresses[$contactEmailSortKey] = $contact_id;
			$arrSortableContactFullNames[$contactFullNameSortKey] = $contact_id;
			$arrSortableContactFirstNames[$contactFirstNameSortKey] = $contact_id;
			$arrSortableContactLastNames[$contactLastNameSortKey] = $contact_id;

			// sortable attributes - contact_companies
			$contactCompany = $contact->getContactCompany();
			$contact_company_id = $contactCompany->contact_company_id;
			$contact_company_name = $contactCompany->contact_company_name;
			$employer_identification_number = $contactCompany->employer_identification_number;
			// unique index (`company`, `employer_identification_number`, `user_user_company_id`)
			$contactCompanySortKey = $contact_company_name.'::'.$employer_identification_number;
			$arrSortableContactCompanyNames[$contactCompanySortKey] = $contact_company_id;

			$arrContactCompanies[$contact_company_id] = $contactCompany;
		}

		$arrReturn = array(
			'roles_objects' => $arrRoles,
			'contact_companies_objects' => $arrContactCompanies,
			'contacts_objects' => $arrContacts,
			'role_based' => $arrRoleBased,
			'ad_hoc' => $arrAdHoc,

			'sortable_roles_by_name' => $arrSortableRoleNames,
			'sortable_contact_companies_by_name' => $arrSortableContactCompanyNames,
			'sortable_contacts_by_email' => $arrSortableContactEmailAddresses,
			'sortable_contacts_by_full_name' => $arrSortableContactFullNames,
			'sortable_contacts_by_first_name' => $arrSortableContactFirstNames,
			'sortable_contacts_by_last_name' => $arrSortableContactLastNames,

			/**
			 * @todo do we need these?
			 */
			'admin_contact_company_ids' => array(),
			'admin_contact_ids' => $arrAdminContactIds,
		);

		return $arrReturn;
	}

	public static function loadContactsForSoftwareModuleFunctionPermissionsMatrixApi($database, $user_company_id, $software_module_id, $software_module_function_id, $project_id=null, $user)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$db->begin();
		// Sanity check to ensure that the user_company_id has access to this software_module_id
		$query =
"
SELECT
	sm.`project_specific_flag`
FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm
WHERE uc2sm.`user_company_id` = ?
AND uc2sm.`software_module_id` = sm.`id`
AND sm.`global_admin_only_flag` = 'N'
AND sm.`customer_configurable_flag` = 'Y'
AND sm.`id` = ?
";
		$arrValues = array($user_company_id, $software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if (!isset($row) || empty($row)) {
			return array();
		} else {
			$project_specific_flag = $row['project_specific_flag'];
		}

		$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		$arrContactCompanyIds = array();
		$arrContactIds = array();

		// Sortable attributes
		$arrSortableContactCompanyNames = array();
		$arrSortableContactEmailAddresses = array();
		$arrSortableContactFullNames = array();
		$arrSortableContactFirstNames = array();
		$arrSortableContactLastNames = array();
		$arrSortableRoleNames = array();

		// Load sortable attributes - roles
		$query =
"
SELECT
	r.*
FROM `roles` r
".//"WHERE `id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN,$AXIS_USER_ROLE_ID_ADMIN)
"WHERE `id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN)
";
		$db->query($query, MYSQLI_USE_RESULT);
		$arrRoles = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];
			$role_name = $row['role'];

			$row['id'] = $role_id;
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			/* @var $role Role */
			$role->convertPropertiesToData();

			$arrRoles[$role_id] = $role;
			$arrSortableRoleNames[$role_name] = $role_id;
		}
		$db->free_result();

		if ($project_specific_flag == 'Y') {
			//to get the project company Id
			$projectexistCompanyids =$user_company_id;
			$currentlySelectedProjectUserCompanyId = $user->currentlySelectedProjectUserCompanyId;
			if(intVal($user_company_id) != intVal($currentlySelectedProjectUserCompanyId))
			{
				$projectexistCompanyids .=",".$currentlySelectedProjectUserCompanyId;
			}
			// Load role-based contacts
			// By Project By Role, project-specific
			// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
			$query =
"
SELECT
	c.*,
	smf.`id` 'software_module_function_id',
	p2c2r.`role_id`,
	c.`id` 'contact_id'
FROM
	`contacts` c,
	`projects_to_contacts_to_roles` p2c2r,
	`projects_to_roles_to_software_module_functions` p2r2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` IN ($projectexistCompanyids)
	AND c.`id` = p2c2r.`contact_id`
	AND p2c2r.`project_id` = $project_id
	AND p2c2r.`role_id` = p2r2smf.`role_id`
	AND p2c2r.`project_id` = p2r2smf.`project_id`
	AND p2r2smf.`software_module_function_id` = smf.`id`
	AND smf.`id` = $software_module_function_id
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = $software_module_id
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrRoleBasedContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			$arrContactIdsToRoleIds = array();
			$arrRoleIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$role_id = $row['role_id'];
				$contact_id = $row['contact_id'];

				$row['id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrRoleBasedContactIds[$contact_id] = $contact;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = $contact;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToRoleIds[$contact_id][$role_id] = $contact;
				$arrRoleIdsToContactIds[$role_id][$contact_id] = $contact;
			}
			$db->free_result();

			$arrRoleBased = array(
				'contacts_ids' => $arrRoleBasedContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
				'contact_ids_to_role_ids' => $arrContactIdsToRoleIds,
				'role_ids_to_contact_ids' => $arrRoleIdsToContactIds,
			);

			// Load ad-hoc contacts
			// By Project By Contact, project-specific
			// projects_to_contacts_to_software_module_functions
			$query =
"
SELECT
	c.*,
	smf.`id` 'software_module_function_id',
	c.`id` 'contact_id'
FROM
	`contacts` c,
	`projects_to_contacts_to_software_module_functions` p2c2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` IN ($projectexistCompanyids)
	AND c.`id` = p2c2smf.`contact_id`
	AND p2c2smf.`project_id` = $project_id
	AND p2c2smf.`software_module_function_id` = smf.`id`
	AND smf.`id` = $software_module_function_id
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = $software_module_id
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrAdHocContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$contact_id = $row['contact_id'];

				$row['id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrAdHocContactIds[$contact_id] = $contact;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = $contact;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = $contact;
			}
			$db->free_result();

			$arrAdHoc = array(
				'contacts_ids' => $arrAdHocContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
			);
		} else {
			// Load role-based contacts
			// By Role, non-project-specific
			// contacts_to_roles, roles_to_software_module_functions
			$query =
"
SELECT
	c.*,
	smf.`id` 'software_module_function_id',
	c2r.`role_id`,
	c.`id` 'contact_id'
FROM
	`contacts` c,
	`contacts_to_roles` c2r,
	`roles_to_software_module_functions` r2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = $user_company_id
	AND c.`id` = c2r.`contact_id`
	AND c2r.`role_id` = r2smf.`role_id`
	AND r2smf.`user_company_id` = uc2sm.`user_company_id`
	AND r2smf.`software_module_function_id` = smf.`id`
	AND smf.`id` = $software_module_function_id
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = $software_module_id
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrRoleBasedContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			$arrContactIdsToRoleIds = array();
			$arrRoleIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$role_id = $row['role_id'];
				$contact_id = $row['contact_id'];

				$row['id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrRoleBasedContactIds[$contact_id] = $contact;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = $contact;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToRoleIds[$contact_id][$role_id] = $contact;
				$arrRoleIdsToContactIds[$role_id][$contact_id] = $contact;
			}
			$db->free_result();

			$arrRoleBased = array(
				'contacts_ids' => $arrRoleBasedContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
				'contact_ids_to_role_ids' => $arrContactIdsToRoleIds,
				'role_ids_to_contact_ids' => $arrRoleIdsToContactIds,
			);

			// Load ad-hoc contacts
			// By Contact, non-project-specific
			// contacts_to_software_module_functions
			$query =
"
SELECT
	c.*,
	smf.`id` 'software_module_function_id',
	c.`id` 'contact_id'
FROM
	`contacts` c,
	`contacts_to_software_module_functions` c2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = $user_company_id
	AND c.`id` = c2smf.`contact_id`
	AND c2smf.`software_module_function_id` = smf.`id`
	AND smf.`id` = $software_module_function_id
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = $software_module_id
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrAdHocContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$contact_id = $row['contact_id'];

				$row['id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrAdHocContactIds[$contact_id] = $contact;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = $contact;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = $contact;
			}
			$db->free_result();

			$arrAdHoc = array(
				'contacts_ids' => $arrAdHocContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
			);
		}

		// Load Admin contact_id list
		$arrAdminContactIds = Contact::loadAdminContactIdListByUserCompanyId($database, $user_company_id);

		/**
		 * @todo Determine if: do wee need $arrAdminContactCompanyIds? should just be the $user_company_id value that was passed in
		 */
		$arrAdminContactCompanyIds = array();

		// merge contact_id lists together
		$arrContactIds = $arrAdminContactIds + $arrRoleBasedContactIds + $arrAdHocContactIds;

		// Map id values to objects in one place
		// Load details for each contact_id
		$arrContactCompanies = array();
		$arrContacts = array();
		foreach ($arrContactIds as $contact_id => $null) {
			$contact = Contact::findContactById($database, $contact_id, true);
			if (!$contact) {
				continue;
			}
			$arrContacts[$contact_id] = $contact;

			// contact roles
			$arrRolesForThisContact = array();
			if (isset($arrContactIdsToRoleIds[$contact_id])) {
				$arrTmpRoleIds = $arrContactIdsToRoleIds[$contact_id];
				foreach ($arrTmpRoleIds as $role_id => $null) {
					$role = $arrRoles[$role_id];
					$arrRolesForThisContact[$role_id] = $role;
				}
				$contact->setRoles($arrRolesForThisContact);
			}

			// sortable attributes - contacts
			$email = $contact->email;
			$contactFullName = $contact->getContactFullName();
			$first_name = $contact->first_name;
			$last_name = $contact->last_name;
			// unique index (`user_company_id`, `contact_company_id`, `email`, `first_name`, `last_name`)
			$contactEmailSortKey = $email.'::'.$contactFullName;
			$contactFullNameSortKey = $contactFullName.'::'.$email;
			$contactFirstNameSortKey = $first_name.'::'.$last_name.'::'.$contactFullName.'::'.$email;
			$contactLastNameSortKey = $last_name.'::'.$first_name.'::'.$contactFullName.'::'.$email;
			$arrSortableContactEmailAddresses[$contactEmailSortKey] = $contact_id;
			$arrSortableContactFullNames[$contactFullNameSortKey] = $contact_id;
			$arrSortableContactFirstNames[$contactFirstNameSortKey] = $contact_id;
			$arrSortableContactLastNames[$contactLastNameSortKey] = $contact_id;

			// sortable attributes - contact_companies
			$contactCompany = $contact->getContactCompany();
			$contact_company_id = $contactCompany->contact_company_id;
			$contact_company_name = $contactCompany->contact_company_name;
			$employer_identification_number = $contactCompany->employer_identification_number;
			// unique index (`company`, `employer_identification_number`, `user_user_company_id`)
			$contactCompanySortKey = $contact_company_name.'::'.$employer_identification_number;
			$arrSortableContactCompanyNames[$contactCompanySortKey] = $contact_company_id;

			$arrContactCompanies[$contact_company_id] = $contactCompany;
		}

		$arrReturn = array(
			'roles_objects' => $arrRoles,
			'contact_companies_objects' => $arrContactCompanies,
			'contacts_objects' => $arrContacts,
			'role_based' => $arrRoleBased,
			'ad_hoc' => $arrAdHoc,

			'sortable_roles_by_name' => $arrSortableRoleNames,
			'sortable_contact_companies_by_name' => $arrSortableContactCompanyNames,
			'sortable_contacts_by_email' => $arrSortableContactEmailAddresses,
			'sortable_contacts_by_full_name' => $arrSortableContactFullNames,
			'sortable_contacts_by_first_name' => $arrSortableContactFirstNames,
			'sortable_contacts_by_last_name' => $arrSortableContactLastNames,

			/**
			 * @todo do we need these?
			 */
			'admin_contact_company_ids' => array(),
			'admin_contact_ids' => $arrAdminContactIds,
		);

		return $arrReturn;
	}

	public static function loadContactsForSoftwareModuleFunctionPermissionsMatrix($database, $user_company_id, $software_module_id, $software_module_function_id, $project_id=null)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$db->begin();
		// Sanity check to ensure that the user_company_id has access to this software_module_id
		$query =
"
SELECT
	sm.`project_specific_flag`
FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm
WHERE uc2sm.`user_company_id` = ?
AND uc2sm.`software_module_id` = sm.`id`
AND sm.`global_admin_only_flag` = 'N'
AND sm.`customer_configurable_flag` = 'Y'
AND sm.`id` = ?
";
		$arrValues = array($user_company_id, $software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if (!isset($row) || empty($row)) {
			return array();
		} else {
			$project_specific_flag = $row['project_specific_flag'];
		}

		$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		$arrContactCompanyIds = array();
		$arrContactIds = array();

		// Sortable attributes
		$arrSortableContactCompanyNames = array();
		$arrSortableContactEmailAddresses = array();
		$arrSortableContactFullNames = array();
		$arrSortableContactFirstNames = array();
		$arrSortableContactLastNames = array();
		$arrSortableRoleNames = array();

		// Load sortable attributes - roles
		$query =
"
SELECT
	r.*
FROM `roles` r
".//"WHERE `id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN,$AXIS_USER_ROLE_ID_ADMIN)
"WHERE `id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN)
";
		$db->query($query, MYSQLI_USE_RESULT);
		$arrRoles = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];
			$role_name = $row['role'];

			$row['id'] = $role_id;
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			/* @var $role Role */
			$role->convertPropertiesToData();

			$arrRoles[$role_id] = $role;
			$arrSortableRoleNames[$role_name] = $role_id;
		}
		$db->free_result();

		if ($project_specific_flag == 'Y') {
			//to get the project company Id
			$projectexistCompanyids =$user_company_id;
			$session = Zend_Registry::get('session');
			$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
			if($user_company_id != $currentlySelectedProjectUserCompanyId)
			{
			$projectexistCompanyids .=",".$currentlySelectedProjectUserCompanyId;
			}
			// Load role-based contacts
			// By Project By Role, project-specific
			// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
			$query =
"
SELECT
	c.*,
	smf.`id` 'software_module_function_id',
	p2c2r.`role_id`,
	c.`id` 'contact_id'
FROM
	`contacts` c,
	`projects_to_contacts_to_roles` p2c2r,
	`projects_to_roles_to_software_module_functions` p2r2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` IN ($projectexistCompanyids)
	AND c.`id` = p2c2r.`contact_id`
	AND p2c2r.`project_id` = $project_id
	AND p2c2r.`role_id` = p2r2smf.`role_id`
	AND p2c2r.`project_id` = p2r2smf.`project_id`
	AND p2r2smf.`software_module_function_id` = smf.`id`
	AND smf.`id` = $software_module_function_id
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = $software_module_id
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrRoleBasedContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			$arrContactIdsToRoleIds = array();
			$arrRoleIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$role_id = $row['role_id'];
				$contact_id = $row['contact_id'];

				$row['id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrRoleBasedContactIds[$contact_id] = $contact;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = $contact;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToRoleIds[$contact_id][$role_id] = $contact;
				$arrRoleIdsToContactIds[$role_id][$contact_id] = $contact;
			}
			$db->free_result();

			$arrRoleBased = array(
				'contacts_ids' => $arrRoleBasedContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
				'contact_ids_to_role_ids' => $arrContactIdsToRoleIds,
				'role_ids_to_contact_ids' => $arrRoleIdsToContactIds,
			);

			// Load ad-hoc contacts
			// By Project By Contact, project-specific
			// projects_to_contacts_to_software_module_functions
			$query =
"
SELECT
	c.*,
	smf.`id` 'software_module_function_id',
	c.`id` 'contact_id'
FROM
	`contacts` c,
	`projects_to_contacts_to_software_module_functions` p2c2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` IN ($projectexistCompanyids)
	AND c.`id` = p2c2smf.`contact_id`
	AND p2c2smf.`project_id` = $project_id
	AND p2c2smf.`software_module_function_id` = smf.`id`
	AND smf.`id` = $software_module_function_id
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = $software_module_id
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'Y'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrAdHocContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$contact_id = $row['contact_id'];

				$row['id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrAdHocContactIds[$contact_id] = $contact;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = $contact;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = $contact;
			}
			$db->free_result();

			$arrAdHoc = array(
				'contacts_ids' => $arrAdHocContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
			);
		} else {
			// Load role-based contacts
			// By Role, non-project-specific
			// contacts_to_roles, roles_to_software_module_functions
			$query =
"
SELECT
	c.*,
	smf.`id` 'software_module_function_id',
	c2r.`role_id`,
	c.`id` 'contact_id'
FROM
	`contacts` c,
	`contacts_to_roles` c2r,
	`roles_to_software_module_functions` r2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = $user_company_id
	AND c.`id` = c2r.`contact_id`
	AND c2r.`role_id` = r2smf.`role_id`
	AND r2smf.`user_company_id` = uc2sm.`user_company_id`
	AND r2smf.`software_module_function_id` = smf.`id`
	AND smf.`id` = $software_module_function_id
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = $software_module_id
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrRoleBasedContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			$arrContactIdsToRoleIds = array();
			$arrRoleIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$role_id = $row['role_id'];
				$contact_id = $row['contact_id'];

				$row['id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrRoleBasedContactIds[$contact_id] = $contact;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = $contact;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToRoleIds[$contact_id][$role_id] = $contact;
				$arrRoleIdsToContactIds[$role_id][$contact_id] = $contact;
			}
			$db->free_result();

			$arrRoleBased = array(
				'contacts_ids' => $arrRoleBasedContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
				'contact_ids_to_role_ids' => $arrContactIdsToRoleIds,
				'role_ids_to_contact_ids' => $arrRoleIdsToContactIds,
			);

			// Load ad-hoc contacts
			// By Contact, non-project-specific
			// contacts_to_software_module_functions
			$query =
"
SELECT
	c.*,
	smf.`id` 'software_module_function_id',
	c.`id` 'contact_id'
FROM
	`contacts` c,
	`contacts_to_software_module_functions` c2smf,
	`software_module_functions` smf,
	`software_modules` sm,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = $user_company_id
	AND c.`id` = c2smf.`contact_id`
	AND c2smf.`software_module_function_id` = smf.`id`
	AND smf.`id` = $software_module_function_id
	AND smf.`software_module_id` = sm.`id`
	AND sm.`id` = $software_module_id
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND uc2sm.`software_module_id` = sm.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND sm.`software_module_category_id` = smc.`id`
//AND smf.`show_in_navigation_flag` = 'Y'
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrAdHocContactIds = array();
			$arrCustomizedPermissionsByContact = array();
			$arrContactIdsToSoftwareModuleFunctionIds = array();
			$arrSoftwareModuleFunctionIdsToContactIds = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];
				$contact_id = $row['contact_id'];

				$row['id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrAdHocContactIds[$contact_id] = $contact;
				$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = $contact;
				$arrContactIdsToSoftwareModuleFunctionIds[$contact_id][$software_module_function_id] = $contact;
				$arrSoftwareModuleFunctionIdsToContactIds[$software_module_function_id][$contact_id] = $contact;
			}
			$db->free_result();

			$arrAdHoc = array(
				'contacts_ids' => $arrAdHocContactIds,
				'ad_hoc_contact_permissions' => $arrCustomizedPermissionsByContact,
				'contact_ids_to_software_module_function_ids' => $arrContactIdsToSoftwareModuleFunctionIds,
				'software_module_function_ids_to_contact_ids' => $arrSoftwareModuleFunctionIdsToContactIds,
			);
		}

		// Load Admin contact_id list
		$arrAdminContactIds = Contact::loadAdminContactIdListByUserCompanyId($database, $user_company_id);

		/**
		 * @todo Determine if: do wee need $arrAdminContactCompanyIds? should just be the $user_company_id value that was passed in
		 */
		$arrAdminContactCompanyIds = array();

		// merge contact_id lists together
		$arrContactIds = $arrAdminContactIds + $arrRoleBasedContactIds + $arrAdHocContactIds;

		// Map id values to objects in one place
		// Load details for each contact_id
		$arrContactCompanies = array();
		$arrContacts = array();
		foreach ($arrContactIds as $contact_id => $null) {
			$contact = Contact::findContactById($database, $contact_id, true);
			if (!$contact) {
				continue;
			}
			$arrContacts[$contact_id] = $contact;

			// contact roles
			$arrRolesForThisContact = array();
			if (isset($arrContactIdsToRoleIds[$contact_id])) {
				$arrTmpRoleIds = $arrContactIdsToRoleIds[$contact_id];
				foreach ($arrTmpRoleIds as $role_id => $null) {
					$role = $arrRoles[$role_id];
					$arrRolesForThisContact[$role_id] = $role;
				}
				$contact->setRoles($arrRolesForThisContact);
			}

			// sortable attributes - contacts
			$email = $contact->email;
			$contactFullName = $contact->getContactFullName();
			$first_name = $contact->first_name;
			$last_name = $contact->last_name;
			// unique index (`user_company_id`, `contact_company_id`, `email`, `first_name`, `last_name`)
			$contactEmailSortKey = $email.'::'.$contactFullName;
			$contactFullNameSortKey = $contactFullName.'::'.$email;
			$contactFirstNameSortKey = $first_name.'::'.$last_name.'::'.$contactFullName.'::'.$email;
			$contactLastNameSortKey = $last_name.'::'.$first_name.'::'.$contactFullName.'::'.$email;
			$arrSortableContactEmailAddresses[$contactEmailSortKey] = $contact_id;
			$arrSortableContactFullNames[$contactFullNameSortKey] = $contact_id;
			$arrSortableContactFirstNames[$contactFirstNameSortKey] = $contact_id;
			$arrSortableContactLastNames[$contactLastNameSortKey] = $contact_id;

			// sortable attributes - contact_companies
			$contactCompany = $contact->getContactCompany();
			$contact_company_id = $contactCompany->contact_company_id;
			$contact_company_name = $contactCompany->contact_company_name;
			$employer_identification_number = $contactCompany->employer_identification_number;
			// unique index (`company`, `employer_identification_number`, `user_user_company_id`)
			$contactCompanySortKey = $contact_company_name.'::'.$employer_identification_number;
			$arrSortableContactCompanyNames[$contactCompanySortKey] = $contact_company_id;

			$arrContactCompanies[$contact_company_id] = $contactCompany;
		}

		$arrReturn = array(
			'roles_objects' => $arrRoles,
			'contact_companies_objects' => $arrContactCompanies,
			'contacts_objects' => $arrContacts,
			'role_based' => $arrRoleBased,
			'ad_hoc' => $arrAdHoc,

			'sortable_roles_by_name' => $arrSortableRoleNames,
			'sortable_contact_companies_by_name' => $arrSortableContactCompanyNames,
			'sortable_contacts_by_email' => $arrSortableContactEmailAddresses,
			'sortable_contacts_by_full_name' => $arrSortableContactFullNames,
			'sortable_contacts_by_first_name' => $arrSortableContactFirstNames,
			'sortable_contacts_by_last_name' => $arrSortableContactLastNames,

			/**
			 * @todo do we need these?
			 */
			'admin_contact_company_ids' => array(),
			'admin_contact_ids' => $arrAdminContactIds,
		);

		return $arrReturn;
	}

	public static function loadPermissions($database, $user, $RN_project_id, $mobile_view = false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$uri = Zend_Registry::get('uri');
		$currentPhpScript = '/' . $uri->currentPhpScript;
		$currentlyRequestedUrl = '/' . $uri->currentPhpScript;
		$userHasAccessToCurrentScript = false;

		// $session = Zend_Registry::get('session');
		/* @var $session Session */

		// "My/My Company Information"
		$user_company_id = $user->user_company_id;
		$user_id = $user->user_id;
		$primary_contact_id = $user->primary_contact_id;
		$userRole = $user->getUserRole();
		$user_role_id = $user->role_id;

		// "Project-driven Information"
		// My Company may or may not own the project
		$currentlySelectedProjectUserCompanyId = (int)$user->currentlySelectedProjectUserCompanyId;
		$currentlySelectedProjectId = (int) $RN_project_id;
		$currentlySelectedProjectName = $user->currentlySelectedProjectName;
		$currentlyActiveContactId = (int)$user->currentlyActiveContactId;

		// System constants
		$AXIS_NON_EXISTENT_CONTACT_ID = AXIS_NON_EXISTENT_CONTACT_ID;
		$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		// Settings for outputting debug output to the screen
		$actualUserRole = $user->getUserRole();

		if ($currentlySelectedProjectUserCompanyId == $user_company_id) {
			$projectOwnerFlag = true;
			if (($userRole == "admin") || ($userRole == "global_admin")) {
				$projectOwnerAdminFlag = true;
			} else {
				$projectOwnerAdminFlag = false;
			}
		} else {
			$projectOwnerFlag = false;
			$projectOwnerAdminFlag = false;
		}

		// Determine if paying customer
		$paying_customer_flag = UserCompany::determineIfPayingCustomer($database, $user_company_id);

		// get all guest contact_id values for convenience
		$arrGuestContactIds = Contact::loadGuestContactIdList($database, $user_company_id, $user_id, $primary_contact_id);
		$arrGuestContactIdsTmp = array_keys($arrGuestContactIds);
		$guestContactIdCSV = join(',', $arrGuestContactIdsTmp);

		$arrSoftwareModuleUrls = array();
		$arrSoftwareModuleFunctionUrls = array();
		$arrNav = array();
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

		if ($userRole == "global_admin") {
			// Global Admin case

			// "Global Admin Nav"
			// Global Admins get to see all menu options
			$arrGlobalAdminSoftwareModuleFunctionIds = RN_Permissions::loadGlobalAdminSoftwareModuleFunctionIds($database, $mobile_view);
		} else {
			// Not a Global Admin case

			// "All Users Nav"
			// Load permissions available to all users based on smf flags
			$arrAllUsersSoftwareModuleFunctionIds = RN_Permissions::loadAvailableToAllUsersSoftwareModuleFunctionIds($database, $mobile_view);

			// "Admin Nav" for their company only
			// if admin, load all functionality that is not project centric
			if ($userRole == 'admin') {
				// Not project-specific
				// sm.`project_specific_flag` = 'N'
				$arrAdminNonProjectSoftwareModuleFunctionIds = RN_Permissions::loadAdminNonProjectSoftwareModuleFunctionIds($database, $user_company_id, $mobile_view);

				// Project-specific
				// sm.`project_specific_flag` = 'Y'
				if ($currentlySelectedProjectUserCompanyId == $user_company_id) {
					$arrAdminProjectOwnerSoftwareModuleFunctionIds =
						RN_Permissions::loadAdminProjectOwnerSoftwareModuleFunctionIds($database, $user_company_id, $currentlySelectedProjectId, $mobile_view);
				}
			}

			// "User Nav" for their company only
			// By Role & By Contact
			// smf.`project_specific_flag` = 'N'
			if ($userRole == 'user') {
				// Load roles list from contacts_to_roles
				$arrAssignedRolesByContactId = ContactToRole::loadAssignedRolesByContactId($database, $primary_contact_id);
				//$arrAssignedRoleIdsByContactId = array_keys($arrAssignedRolesByContactId);

				// By Role
				//$arrUserSoftwareModuleFunctionIds = SoftwareModuleFunction::loadSoftwareModuleFunctionIdListForUsersByRole($database, $user_company_id, $user_id, $primary_contact_id);

				// By Contact


				// Not project-specific
				// sm.`project_specific_flag` = 'N'

				// By Role, non-project-specific
				// contacts_to_roles, roles_to_software_module_functions
				$arrUserNonProjectRoleBasedSoftwareModuleFunctionIds =
					RN_Permissions::loadUserNonProjectRoleBasedSoftwareModuleFunctionIds($database, $primary_contact_id, $user_company_id, $mobile_view);

				// By Contact, non-project-specific
				// contacts_to_software_module_functions
				$arrUserNonProjectContactBasedSoftwareModuleFunctionIds =
					RN_Permissions::loadUserNonProjectContactBasedSoftwareModuleFunctionIds($database, $primary_contact_id, $user_company_id, $mobile_view);

				// By "All Users", non-project-specific
				// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=N
				$arrUserNonProjectAllUsersBasedSoftwareModuleFunctionIds =
					RN_Permissions::loadUserNonProjectAllUsersBasedSoftwareModuleFunctionIds($database, $user_company_id, $mobile_view);

				// Project-specific
				// sm.`project_specific_flag` = 'Y'
				if ($currentlySelectedProjectUserCompanyId == $user_company_id) {
					// By Role, project-specific
					// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
					$arrUserProjectSpecificRoleBasedSoftwareModuleFunctionIds =
						RN_Permissions::loadUserProjectSpecificRoleBasedSoftwareModuleFunctionIds($database, $primary_contact_id, $user_company_id, $currentlySelectedProjectId, $mobile_view);

					// By Contact, project-specific
					// projects_to_contacts_to_software_module_functions
					$arrUserProjectSpecificContactBasedSoftwareModuleFunctionIds =
						RN_Permissions::loadUserProjectSpecificContactBasedSoftwareModuleFunctionIds($database, $primary_contact_id, $user_company_id, $currentlySelectedProjectId, $mobile_view);

					// By "All Users", project-specific
					// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=Y
					$arrUserProjectSpecificAllUsersBasedSoftwareModuleFunctionIds =
						RN_Permissions::loadUserProjectSpecificAllUsersBasedSoftwareModuleFunctionIds($database, $primary_contact_id, $user_company_id, $currentlySelectedProjectId, $mobile_view);
				}
			}

			// Load roles list from projects_to_contacts_to_roles
			$arrProjectRoles = ProjectToContactToRole::loadRolesListByProjectIdAndContactId($database, $currentlySelectedProjectId, $currentlyActiveContactId);
			//$arrProjectRoleIds = array_keys($arrProjectRoles);

			// Third-party "Guest" permissions
			$csvContactIds = RN_Permissions::loadGuestContactIdsCSV($database, $user_company_id, $user_id, $primary_contact_id);

			// By Role, non-project-specific
			// contacts_to_roles, roles_to_software_module_functions
			//$guestNonProjectRoleIdCSV = RN_RN_Permissions::loadGuestNonProjectRoleIdsCSV($database, $csvContactIds);
			$arrGuestNonProjectRoleBasedSoftwareModuleFunctionIds =
				RN_Permissions::loadGuestNonProjectRoleBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $mobile_view);

			// By Contact, non-project-specific
			// contacts_to_software_module_functions
			$arrGuestNonProjectContactBasedSoftwareModuleFunctionIds =
				RN_Permissions::loadGuestNonProjectContactBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $mobile_view);

			// By "All Users", non-project-specific
			// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=N
			$arrGuestNonProjectAllUsersBasedSoftwareModuleFunctionIds =
				RN_Permissions::loadGuestNonProjectAllUsersBasedSoftwareModuleFunctionIds($database, $currentlySelectedProjectUserCompanyId, $mobile_view);

			// By Role, project-specific
			// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
			$arrGuestProjectSpecificRoleBasedSoftwareModuleFunctionIds =
				RN_Permissions::loadGuestProjectSpecificRoleBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId, $mobile_view);

			// By Contact, project-specific
			// projects_to_contacts_to_software_module_functions
			$arrGuestProjectSpecificContactBasedSoftwareModuleFunctionIds =
				RN_Permissions::loadGuestProjectSpecificContactBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId, $mobile_view);

			// By "All Users", project-specific
			// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N', sm.project_specific_flag=Y
			$arrGuestProjectSpecificAllUsersBasedSoftwareModuleFunctionIds =
				RN_Permissions::loadGuestProjectSpecificAllUsersBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId, $mobile_view);
		}

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

		$actualUserRole = $user->getUserRole();

		$arrTmp = array_keys($arrSoftwareModuleFunctionIds);
		$arrReturn = RN_Permissions::loadPermissionsById($database, $arrTmp,$actualUserRole);

		/**
		 * @todo Delete $arrNav
		 */
		$arrNav = $arrReturn['nav'];

		$arrPermissions = $arrReturn['permissions'];
		$arrMenu = $arrReturn['menu'];
		$arrSoftwareModuleCategorySortOrder = $arrReturn['software_module_category_sort_order'];
		$arrSoftwareModuleCategories = $arrReturn['software_module_categories'];
		$arrSoftwareModules = $arrReturn['software_modules'];
		$arrSoftwareModuleFunctions = $arrReturn['software_module_functions'];
		$arrSoftwareModulesByModule = $arrReturn['software_modules_by_module'];
		$arrSoftwareModuleFunctionsByFunction = $arrReturn['software_module_functions_by_function'];
		$arrSoftwareModuleUrls = $arrReturn['software_module_urls'];
		$arrSoftwareModuleFunctionUrls = $arrReturn['software_module_function_urls'];

		$permissions = self::getInstance();
		/* @var $permissions Permissions */

		/**
		 * @todo Delete $this->arrNav
		 */
		$permissions->setArrNav($arrNav);

		$permissions->setArrPermissions($arrPermissions);
		$permissions->setArrMenu($arrMenu);
		$permissions->setArrSoftwareModuleCategorySortOrder($arrSoftwareModuleCategorySortOrder);
		$permissions->setArrSoftwareModuleCategories($arrSoftwareModuleCategories);
		$permissions->setArrSoftwareModules($arrSoftwareModules);
		$permissions->setArrSoftwareModuleFunctions($arrSoftwareModuleFunctions);
		$permissions->setArrSoftwareModuleUrls($arrSoftwareModuleUrls);
		$permissions->setArrSoftwareModuleFunctionUrls($arrSoftwareModuleFunctionUrls);
		$permissions->setArrSoftwareModulesByModule($arrSoftwareModulesByModule);
		$permissions->setArrSoftwareModuleFunctionsByFunction($arrSoftwareModuleFunctionsByFunction);

		$permissions->setUserCompanyId($user_company_id);
		$permissions->setUserId($user_id);
		$permissions->setUserRoleId($user_role_id);
		$permissions->setUserRole($userRole);
		$permissions->setPrimaryContactId($primary_contact_id);
		$permissions->setCurrentlySelectedProjectId($currentlySelectedProjectId);
		$permissions->setCurrentlySelectedProjectUserCompanyId($currentlySelectedProjectUserCompanyId);
		$permissions->setCurrentlyActiveContactId($currentlyActiveContactId);

		$permissions->setProjectOwnerFlag($projectOwnerFlag);
		$permissions->setProjectOwnerAdminFlag($projectOwnerAdminFlag);
		$permissions->setPayingCustomerFlag($paying_customer_flag);

		$permissions->setContactRoles($arrAssignedRolesByContactId);
		$permissions->setProjectRoles($arrProjectRoles);

		return $permissions;
	}

	/**
	 * Load software_module_functions by ids as a formatted permissions list.
	 *
	 * @param string $database
	 * @param array $arrId
	 * @return array
	 */
	public static function loadPermissionsById($database, $arrId,$actualUserRole)
	{
		// The complete list of permissions including hidden software_module_functions that are not in the primary navigation (show_in_navigation_flag = 'N'/'Y')
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

		$db = DBI::getInstance($database);
		$query = "
		SELECT * FROM `software_module_functions` smf 
		RIGHT JOIN `software_modules` sm ON sm.`id` = smf.`software_module_id`
		WHERE sm.`software_module` = 'Dashboard'
		";
		$db->query($query);
		$arrSoftwareModuleFunctionsGroupedByNavigationLabel = array();
		while ($row1 = $db->fetch()) {
			$dash_id = $row1['id'];
			// Global Admins get to see all menu options
			if($actualUserRole=='global_admin')
			{
				if (!in_array($dash_id, $arrId)) {
					array_push($arrId, $dash_id);
				}
				
			}
		}
		$in = join(',', $arrId);

		$query =
		"
		SELECT
		smf.`id` AS software_module_function_id,
		smf.`software_module_function`,
		smf.`software_module_function_label`,
		smf.`software_module_function_navigation_label`,
		smf.`default_software_module_function_url`,
		smf.`show_in_navigation_flag`,
		smf.`global_admin_only_flag`,
		sm.`id` AS software_module_id,
		sm.`software_module`,
		sm.`software_module_label`,
		sm.`default_software_module_url`,
		sm.`mobile_navigation_id` AS sm_mobile_navigation_id,
		smc.`id` AS software_module_category_id,
		smc.`software_module_category`,
		smc.`software_module_category_label`,
		smc.`mobile_navigation_id` AS smc_mobile_navigation_id,
		smc.`sort_order` AS software_module_category_sort_order
		FROM 
		`software_module_functions` smf,
		`software_modules` sm,
		`software_module_categories` smc
		WHERE
		smf.`software_module_id` = sm.`id`
		AND sm.`software_module_category_id` = smc.`id`
		AND smf.`id` IN ($in)
		ORDER BY smc.`sort_order` ASC, sm.`sort_order` ASC, smf.`sort_order` ASC
		";
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
			$smc_mobile_navigation_id = $row['smc_mobile_navigation_id'];
			$software_module_id = $row['software_module_id'];
			// Unique string identifier that would be embedded in code and guaranteed unique
			$software_module = $row['software_module'];
			$software_module_label = $row['software_module_label'];
			$default_software_module_url = $row['default_software_module_url'];
			$sm_mobile_navigation_id = $row['sm_mobile_navigation_id'];

			$software_module_function_id = $row['software_module_function_id'];
			// Unique string identifier that would be embedded in code and guaranteed unique
			$software_module_function = $row['software_module_function'];
			// Label that the admin user would see in the permissions module for a given software_module_function
			$software_module_function_label = $row['software_module_function_label'];
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
					'mobile_navigation_id' => $smc_mobile_navigation_id,
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
					'mobile_navigation_id' => $sm_mobile_navigation_id,
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

			if ($show_in_navigation_flag == 'Y') {
				// filter here instead of SQL GROUP BY to allow non-navigation permissions to work correctly for the below lists
				if (!isset($arrSoftwareModuleFunctionsGroupedByNavigationLabel[$software_module_function_navigation_label])) {

					// Get a matrix of menu permissions (show_in_navigation_flag = 'Y' only)
					$arrMenu[$software_module_category_id][$software_module_id][$software_module_function_id] = $software_module_function;

					$arrSoftwareModuleFunctionsGroupedByNavigationLabel[$software_module_function_navigation_label] = 1;
					$arrNav[$software_module_category_id]['id'] = $software_module_category_id;
					$arrNav[$software_module_category_id]['name'] = $software_module_category_label;
					$arrNav[$software_module_category_id]['software_module_category'] = $software_module_category;
					$arrNav[$software_module_category_id]['mobile_navigation_id'] = $smc_mobile_navigation_id;
					$arrNav[$software_module_category_id]['modules'][$software_module_id]['name'] = $software_module_label;
					$arrNav[$software_module_category_id]['modules'][$software_module_id]['software_module'] = $software_module;
					$arrNav[$software_module_category_id]['modules'][$software_module_id]['path'] = $default_software_module_url;
					$arrNav[$software_module_category_id]['modules'][$software_module_id]['mobile_navigation_id'] = $sm_mobile_navigation_id;
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

		return $arrReturn;
	}

	/**
	 * Load software_module_functions ids as a list.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadGlobalAdminSoftwareModuleFunctionIds($database, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$join_where = '';
		if($mobile_view){
			$join_where =  "INNER JOIN `software_modules` sm on `sm`.id = `smf`.software_module_id AND `sm`.`mobile_view_flag` = 'Y'";
		}
		// Global Admins get to see all menu options
		$query =
"
SELECT
	smf.`id`
FROM `software_module_functions` smf
$join_where
";
		$db->query($query);

		$arrIds = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	public static function loadAvailableToAllUsersSoftwareModuleFunctionIds($database, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
		// Load permissions available to all users based on smf flags
		$query =
"
SELECT
	smf.`id`
FROM `software_modules` sm
	INNER JOIN `software_module_functions` smf ON sm.`id` = smf.`software_module_id`
WHERE sm.`disabled_flag` = 'N'
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load software_module_functions ids as a list.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @return array of integer id values
	 */
	public static function loadAdminNonProjectSoftwareModuleFunctionIds($database, $user_company_id, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
		// Load list for Admins that are not project centric
		$query =
"
SELECT
	smf.`id`
FROM `user_companies_to_software_modules` uc2sm
	INNER JOIN `software_modules` sm ON uc2sm.`software_module_id` = sm.`id`
	INNER JOIN `software_module_functions` smf ON sm.`id` = smf.`software_module_id`
WHERE uc2sm.`user_company_id` = ?
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load software_module_functions ids as a list.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @return array of integer id values
	 */
	public static function loadAdminProjectOwnerSoftwareModuleFunctionIds($database, $user_company_id, $project_id, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadUserNonProjectRoleBasedSoftwareModuleFunctionIds($database, $csvContactIds, $user_company_id, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}

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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadUserNonProjectContactBasedSoftwareModuleFunctionIds($database, $csvContactIds, $user_company_id, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadUserNonProjectAllUsersBasedSoftwareModuleFunctionIds($database, $currentlySelectedProjectUserCompanyId, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadUserProjectSpecificRoleBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId, $mobile_view) {
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadUserProjectSpecificContactBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadUserProjectSpecificAllUsersBasedSoftwareModuleFunctionIds($database, $currentlySelectedProjectUserCompanyId, $user_company_id, $currentlySelectedProjectId, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load software_module_functions ids as a list.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $user_id
	 * @param int $primary_contact_id
	 * @return array of integer id values
	 */
	public static function loadSoftwareModuleFunctionIdListForUsersByRole($database, $user_company_id, $user_id, $primary_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	r2smf.*,
	smf.`id` AS function_id, smf.`software_module_function` AS function_name,
	smf.`software_module_function_label` AS function_label, smf.`default_software_module_function_url`, smf.`show_in_navigation_flag`,
	sm.`id` AS module_id, sm.`software_module_label` AS module_name, sm.`default_software_module_url`,
	smc.`id` AS category_id, smc.`software_module_category_label` AS category_name, smc.`sort_order` AS category_order
FROM `software_modules` sm, `software_module_functions` smf, `software_module_categories` smc, `user_companies_to_software_modules` uc2sm, `roles_to_software_module_functions` r2smf
WHERE uc2sm.`user_company_id` = $user_company_id
AND uc2sm.`software_module_id` = sm.`id`
AND sm.`id` = smf.`software_module_id`
AND sm.`software_module_category_id` = smc.`id`
AND r2smf.`software_module_function_id` = smf.`id`
AND r2smf.`user_company_id` = $user_company_id
AND r2smf.`role_id` = 3
";

		// Load list for Userss that are not project centric
		$query =
"
SELECT
	smf.`id`
FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm, `software_module_functions` smf, `software_module_categories` smc, `roles_to_software_module_functions` r2smf
WHERE uc2sm.`user_company_id` = ?
	AND uc2sm.`software_module_id` = sm.`id`
	AND sm.`id` = smf.`software_module_id`
	AND sm.`software_module_category_id` = smc.`id`
	AND smf.`global_admin_only_flag` = 'N'
	AND sm.`project_specific_flag` = 'N'
	AND sm.`disabled_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
//AND smf.`show_in_navigation_flag` = 'Y'
//AND smf.`project_specific_flag` = 'N'
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrIds = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load contact_id list for your user_id in third party contacts lists.
	 *
	 * @param string $database
	 * @return csv string of integer id values
	 */
	public static function loadGuestContactIdsCSV($database, $user_company_id, $user_id, $primary_contact_id)
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

	/**
	 * Load roles ids as a csv list.
	 *
	 * @param string $database
	 * @return csv string of integer id values
	 */
	public static function loadGuestNonProjectRoleIdsCSV($database, $csvContactIds)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// By Role, non-project-specific
		// contacts_to_roles, roles_to_software_module_functions
		// user_companies_to_all_users_to_software_module_functions w/ employee_only_flag='N'
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

	/**
	 * Load project-driven roles as a list.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadGuestCurrentlySelectedProjectRolesCSV($database, $csvContactIds, $currentlySelectedProjectId)
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

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadGuestNonProjectRoleBasedSoftwareModuleFunctionIds($database, $guestContactIdCSV, $currentlySelectedProjectUserCompanyId, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadGuestNonProjectContactBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadGuestNonProjectAllUsersBasedSoftwareModuleFunctionIds($database, $currentlySelectedProjectUserCompanyId, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadGuestProjectSpecificRoleBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId, $mobile_view) {
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadGuestProjectSpecificContactBasedSoftwareModuleFunctionIds($database, $csvContactIds, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	/**
	 * Load permissions.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadGuestProjectSpecificAllUsersBasedSoftwareModuleFunctionIds($database, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectUserCompanyId, $currentlySelectedProjectId, $mobile_view)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$where = '';
		if($mobile_view){
			$where =  "AND sm.`mobile_view_flag` = 'Y'";
		}
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
	$where
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
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	public static function resetToSystemDefaultPermissions($database, $user_company_id, $project_id, $software_module_id, $project_specific_flag)
	{
		$user_company_id = (int) $user_company_id;
		$software_module_id = (int) $software_module_id;
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$query =
"
SELECT `id` AS 'software_module_function_id'
FROM `software_module_functions`
WHERE `software_module_id` = ?
ORDER BY `id` ASC
";
		$arrValues = array($software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleFunctionIds = array();
		while ($row = $db->fetch()) {
			$software_module_function_id = $row['software_module_function_id'];
			$arrSoftwareModuleFunctionIds[] = $software_module_function_id;
		}
		$db->free_result();

		$csvSoftwareModuleFunctionIds = join(',', $arrSoftwareModuleFunctionIds);
		$query =
"
DELETE
FROM `roles_to_software_module_functions`
WHERE `user_company_id` = ?
AND `software_module_function_id` IN ($csvSoftwareModuleFunctionIds)
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		if ($project_specific_flag == 'N') {
			$query =
"
INSERT INTO `roles_to_software_module_functions`
(`user_company_id`, `role_id`, `software_module_function_id`)
SELECT '$user_company_id' AS 'user_company_id', `role_id`, `software_module_function_id`
FROM `roles_to_software_module_function_templates`
WHERE `user_company_id` = '2'
AND `software_module_function_id` IN ($csvSoftwareModuleFunctionIds)
ORDER BY role_id, software_module_function_id
";
			$arrValues = array($user_company_id);
		} else {
			$query =
"
INSERT INTO `projects_to_roles_to_software_module_functions`
(`user_company_id`, `role_id`, `software_module_function_id`)
SELECT '$project_id' AS 'project_id', `role_id`, `software_module_function_id`
FROM `projects_to_roles_to_software_module_function_templates`
WHERE `project_id` = '2'
AND `software_module_function_id` IN ($csvSoftwareModuleFunctionIds)
ORDER BY role_id, software_module_function_id
";
			$arrValues = array($user_company_id, $project_id);
		}
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
	}


	/**
	* Check Permission for Delay Module
	* @param software_module_function
	* @return boolean
	*/

	public static function checkDelayPermission($database, $software_module_function, $user, $software_module_functionId, $software_module_id, $RN_project_id)
	{

		$db = DBI::getInstance($database);	
		// $session = Zend_Registry::get('session');
		$primary_contact_id = $user->primary_contact_id;
		$currentlyActiveContactId = $user->currentlyActiveContactId;
		$user_company_id = $user->user_company_id;
		$currentlySelectedProjectId = (int) $RN_project_id;
		$currentlySelectedProjectUserCompanyId = (int)$user->currentlySelectedProjectUserCompanyId;
		/*$software_module_functionId  = SoftwareModuleFunction::getIdbyfunctionName($software_module_function);
		$software_module_functionModel = SoftwareModuleFunction::findById($database,$software_module_functionId);
		$software_module_id = $software_module_functionModel->software_module_id;*/ 
		$project_id =(int) $RN_project_id;
		$arrContactPermissionsMatrix = RN_Permissions::loadContactsForSoftwareModuleFunctionPermissionsMatrixApi($database, $user_company_id, $software_module_id, $software_module_functionId, $project_id, $user);
		$contacts = $arrContactPermissionsMatrix['sortable_contacts_by_full_name'];
		$contactIds = array_values($contacts);
		if($user->role_id == '1'){
			return true;
		}
		if(in_array($currentlyActiveContactId, $contactIds)){
			return true;
		}else{
			return false;
		}
	}
//To check whether the module has access based on both the project specific and non specific roles
function checkPermissionForAllModuleAndRole($database,$software_module_function, $user, $software_module_functionId, $software_module_id, $RN_project_id)
{
	$database = DBI::getInstance($database);	

	$primary_contact_id = $user->primary_contact_id;
		$currentlyActiveContactId = $user->currentlyActiveContactId;
		$user_company_id = $user->user_company_id;
		$currentlySelectedProjectId = (int) $RN_project_id;
		$currentlySelectedProjectUserCompanyId = (int)$user->currentlySelectedProjectUserCompanyId;
		$project_id =(int) $RN_project_id;


	/* To get the software module function id */
	$software_module_functionId  = SoftwareModuleFunction::getIdbyfunctionName($software_module_function,$database);
	$project_specific_flag = SoftwareModuleFunction::getprojectspecificflagbyfunctionId($database,$software_module_functionId);
	/* To get the software module  id */
	$software_module_functionModel = SoftwareModuleFunction::findById($database,$software_module_functionId);
	$software_module_id = $software_module_functionModel->software_module_id;
	/*End  To get the software module  id */

	$raredata = rarecaseContactToModuleAccess($database,$software_module_functionId,$project_id,$currentlyActiveContactId,$project_specific_flag);
	if(!$raredata)
	{
		
		$resResonse = checkContactHasAccesstoModules($database,$software_module_id,$software_module_functionId,$user_company_id,$project_id,$currentlyActiveContactId,$project_specific_flag);
	}else
	{
		$resResonse = $raredata;
	}
	return $resResonse;

}
	//To check rare case for modules
function rarecaseContactToModuleAccess($database,$software_module_functionId,$project_id,$primary_contact_id,$project_specific_flag)
{
	$db = DBI::getInstance($database);
	if($project_specific_flag == 'Y')
	{
		$query ="SELECT * FROM `projects_to_contacts_to_software_module_functions` where `contact_id` = ? and `software_module_function_id` =? and `project_id` =?";
		$arrValues = array($primary_contact_id,$software_module_functionId,$project_id);
		
	}else
	{
		$query ="SELECT * FROM `contacts_to_software_module_functions` where `contact_id` = ? and `software_module_function_id` =?";
		$arrValues = array($primary_contact_id,$software_module_functionId);
	}
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();
	if (!isset($row) || empty($row)) {
		$rarespecific= false;
	} else {
		$rarespecific= true;
	}
	return $rarespecific;
}

	//To check whether a contact has access to the module
function checkContactHasAccesstoModules($database,$software_module_id,$software_module_functionId,$user_company_id,$project_id,$primary_contact_id,$project_specific_flag)
{
	$db = DBI::getInstance($database);
	if($project_specific_flag =='Y')
	{

		//For project specific roles  and should not consider user access		
		$query1 ="SELECT * FROM `projects_to_roles_to_software_module_functions` as prsmf INNER join projects_to_contacts_to_roles as ptcr on ptcr.role_id = prsmf.role_id and ptcr.project_id = prsmf.project_id WHERE prsmf.software_module_function_id ='$software_module_functionId' and ptcr.contact_id = '$primary_contact_id' and ptcr.project_id ='$project_id' and prsmf.role_id <> 3 ";
	// $arrValues = array($user_company_id, $software_module_id,$software_module_functionId,$primary_contact_id,$project_id);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->execute($query1);
		$row1 = $db->fetch();
		$db->free_result();
		if (!isset($row1) || empty($row1)) {
			/* Check the Non Project Specific roles in project Specific */
			
			$query3 = 	"SELECT * FROM `projects_to_roles_to_software_module_functions` as prsmf 
			INNER JOIN contacts_to_roles as ctr ON ctr.role_id = prsmf.role_id 
			WHERE prsmf.software_module_function_id ='$software_module_functionId' and ctr.contact_id = '$primary_contact_id' and prsmf.project_id ='$project_id'";

			$db->execute($query3);
			$row3 = $db->fetch();
			$db->free_result();
			if (!isset($row3) || empty($row3)) {
				return false;
			}else{
				return true;

			}
			/* Check the Non Project Specific roles in project Specific */		
			return false;
		} else {
			return true;
		}

	}else
	{
	//For  non specific roles and should not consider user access
		$query ="SELECT * FROM `user_companies_to_software_modules` as ucsm 
		INNER join roles_to_software_module_function_templates as rsmf on rsmf.user_company_id = ucsm.user_company_id 
		INNER join contacts_to_roles as cr on cr.role_id = rsmf.role_id 
		WHERE ucsm.user_company_id = '$user_company_id' and ucsm.software_module_id ='$software_module_id' and rsmf.software_module_function_id ='$software_module_functionId' and cr.contact_id = '$primary_contact_id' and rsmf.role_id <> 3 ";
	// $arrValues = array($user_company_id, $software_module_id,$software_module_functionId,$primary_contact_id);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->execute($query);
		$row = $db->fetch();
		$db->free_result();
		$prjnonspecific = "";
		if (!isset($row) || empty($row)) {
			$prjnonspecific= false;
		} else {
			$prjnonspecific= true;
		}

	//For project specific roles  and should not consider user access		
		$query1 ="SELECT * FROM `user_companies_to_software_modules` as ucsm 
		INNER join roles_to_software_module_function_templates as rsmf on rsmf.user_company_id = ucsm.user_company_id 
		INNER join projects_to_contacts_to_roles as ptcr on ptcr.role_id = rsmf.role_id 
		WHERE ucsm.user_company_id = '$user_company_id' and ucsm.software_module_id ='$software_module_id' and rsmf.software_module_function_id ='$software_module_functionId' and ptcr.contact_id = '$primary_contact_id' and ptcr.project_id ='$project_id' and rsmf.role_id <> 3";
	// $arrValues = array($user_company_id, $software_module_id,$software_module_functionId,$primary_contact_id,$project_id);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->execute($query1);
		$row1 = $db->fetch();
		$db->free_result();
		$prjspecific ="";
		if (!isset($row1) || empty($row1)) {
			$prjspecific = false;
		} else {
			$prjspecific  = true;
		}
	// echo "prjnonspecific : ".$prjnonspecific;
	// echo "prjspecific : ".$prjspecific;
		if($prjnonspecific== true && $prjspecific==true)
		{
			return true;
		}else if ($prjnonspecific== false && $prjspecific==true)
		{
			return true;
		}else if ($prjnonspecific== true && $prjspecific==false)
		{
			return true;
		}else{
			return false;
		}	
	}
	
}


	/**
	 * Load software_module_functions ids as a list.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadSoftwareModuleByIds($database, $softwate_module_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Global Admins get to see all menu options
		$query =
"
SELECT
	*
FROM `software_modules` sm
WHERE sm.`software_module` = '$softwate_module_id'
";
		$db->query($query);

		$arrIds = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$sotware_module = $row['software_module'];
			$sotware_module_label = $row['software_module_label'];
			$arrIds['id'] = $id;
			$arrIds['software_module'] = $sotware_module;
			$arrIds['software_module_label'] = $sotware_module_label;
		}
		$db->free_result();

		return $arrIds;
	}
	/**
	 * Load software_module_functions ids as a list.
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function loadRolesToFilesPermission($database, $user, $project_id, $file_manager_file_id)
	{
		
		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		$permissions = RN_Permissions::loadPermissions($database, $user, $project_id);
		$user_company_id = $permissions->getUserCompanyId();
		$user_id = $permissions->getUserId();
		$user_role_id = $permissions->getUserRoleId();
		$userRole = $permissions->getUserRole();
		$primary_contact_id = $permissions->getPrimaryContactId();
		$currentlySelectedProjectId = $permissions->getCurrentlySelectedProjectId();
		$currentlySelectedProjectUserCompanyId = $permissions->getCurrentlySelectedProjectUserCompanyId();
		$currentlyActiveContactId = $permissions->getCurrentlyActiveContactId();

		$projectOwnerFlag = $permissions->getProjectOwnerFlag();
		$projectOwnerAdminFlag = $permissions->getProjectOwnerAdminFlag();
		$paying_customer_flag = $permissions->getPayingCustomerFlag();

		$arrContactRoles = $permissions->getContactRoles();
		$arrProjectRoles = $permissions->getProjectRoles();

		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company Files case
			if ($userRole == 'user') {
				$arrContactRoleIds = array_keys($arrContactRoles);
				// non-admins must have at least one role
				if (empty($arrContactRoleIds)) {
					return array();
				}
				$in = join(',', $arrContactRoleIds);
				if (isset($arrContactRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$grantAllPermissionsFlag = true;
				} else {
					$grantAllPermissionsFlag = false;
				}
			} else {
				// admin or global_admin case
				$grantAllPermissionsFlag = true;
			}
		} else {
			// Project Files case
			if ($projectOwnerAdminFlag) {
				$grantAllPermissionsFlag = true;
			} elseif (!$projectOwnerFlag || ($projectOwnerFlag && ($userRole == 'user'))) {
				// non-admins must have at least one role
				if (empty($arrProjectRoles)) {
					return array();
				}
				if (isset($arrProjectRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$grantAllPermissionsFlag = true;
				} else {
					$grantAllPermissionsFlag = false;
					$arrProjectRoleIds = array_keys($arrProjectRoles);
					$in = join(',', $arrProjectRoleIds);
				}
			}
		}
		$arryTemp = array();
		if ($grantAllPermissionsFlag) {
			$arryTemp['view_privilege'] = 'Y';
			$arryTemp['grant_privileges_privilege'] = 'Y';
			$arryTemp['rename_privilege'] = 'Y';
			$arryTemp['move_privilege'] = 'Y';
			$arryTemp['delete_privilege'] = 'Y';
			return $arryTemp;
		}

		$arryTemp['view_privilege'] = 'N';
		$arryTemp['grant_privileges_privilege'] = 'N';
		$arryTemp['rename_privilege'] = 'N';
		$arryTemp['move_privilege'] = 'N';
		$arryTemp['delete_privilege'] = 'N';

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();

		$query =
"
SELECT r2f.*
FROM `roles_to_files` r2f
WHERE `file_manager_file_id` = $file_manager_file_id
AND `role_id` IN ($in)
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrRolesToFiles = array();
		while($row = $db->fetch()) {
			$grant_privileges_privilege = $row['grant_privileges_privilege'];
			$rename_privilege = $row['rename_privilege'];
			$move_privilege = $row['move_privilege'];
			$delete_privilege = $row['delete_privilege'];

			if ($grant_privileges_privilege == 'Y') {
				$arryTemp['grant_privileges_privilege'] = 'Y';
			}

			if ($rename_privilege == 'Y') {
				$arryTemp['rename_privilege'] = 'Y';
			}

			if ($move_privilege == 'Y') {
				$arryTemp['move_privilege'] = 'Y';
			}

			if ($delete_privilege == 'Y') {
				$arryTemp['delete_privilege'] = 'Y';
			}

			// set view_privilege
			if (($arryTemp['grant_privileges_privilege'] == 'N') && ($arryTemp['rename_privilege'] == 'N') && ($arryTemp['move_privilege'] == 'N') && ($arryTemp['delete_privilege'] == 'N')) {
				$arryTemp['view_privilege'] = 'Y';
			}

			$role_id = $row['role_id'];
			// $roleToFile = new RoleToFile($database);
			// $key = array(
			// 	'role_id' => $role_id,
			// 	'file_manager_file_id' => $file_manager_file_id
			// );
			// $roleToFile->setKey($key);
			// $roleToFile->setData($row);
			// $roleToFile->convertDataToProperties();

			// $arrRolesToFiles[$role_id] = $roleToFile;
		}

		// set view_privilege
		if (($arryTemp['grant_privileges_privilege'] == 'Y') || ($arryTemp['rename_privilege'] == 'Y') || ($arryTemp['move_privilege'] == 'Y') || ($arryTemp['delete_privilege'] == 'Y')) {
			$arryTemp['view_privilege'] = 'Y';
		}

		return $arryTemp;
		// $this->setRolesToFiles($arrRolesToFiles);

	}
	/**
	 * check the user have role of project manager, bidder or subcontractor
	 *
	 * @param string $database
	 * @return array of integer id values
	 */
	public static function checkProjectManagerORBidder($database, $project_id, $contact_id) {
		// var database instance
		$db = DBI::getInstance($database);
		$db->free_result();
		// query projectManager
		$query = "
		SELECT * 
		FROM `projects_to_contacts_to_roles`
		INNER JOIN `roles` ON `roles`.id =  `projects_to_contacts_to_roles`.role_id 
		WHERE `projects_to_contacts_to_roles`.`project_id` = ? AND `projects_to_contacts_to_roles`.contact_id = ? AND `roles`.role IN (?)";
		$projectManager = 'Project Manager';
		$bidderORSubcontractor = "'Sub Contractor', 'Bidder'";
		$arrValues = array($project_id, $contact_id, $projectManager);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$projectManageRow = $db->fetch();
		$returnArr = array();
		$returnArr['project_manager'] = false;
		if (isset($projectManageRow) && !empty($projectManageRow)) {
			$returnArr['project_manager'] = true;
		}
		$db->free_result();
		
		$query = "
		SELECT * 
		FROM `projects_to_contacts_to_roles`
		INNER JOIN `roles` ON `roles`.id =  `projects_to_contacts_to_roles`.role_id
		WHERE `projects_to_contacts_to_roles`.`project_id` = ? AND `projects_to_contacts_to_roles`.contact_id = ? AND `roles`.role IN ('Sub Contractor', 'Bidder')";

		$bidderORSubcontractor = array('Sub Contractor', 'Bidder');
		$arrValues = array($project_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$borsubRow = $db->fetch();
		$returnArr['bidder_subcontract'] = false;
		if (isset($borsubRow) && !empty($borsubRow)) {
			$returnArr['bidder_subcontract'] = true;
		}
		$db->free_result();
		return $returnArr;
	}	
	//To check whether a contact has access to the module
	public static function checkSoftwareModuleCategoryPermission($database, $user_company_id, $software_module_category, $project_id, $primary_contact_id, $project_specific_flag, $userRole)
	{
		// if user global admin access true
		if ($userRole == 'global_admin') {
			return true;
		}
		$db = DBI::getInstance($database);
		$db->free_result();
		if($project_specific_flag == 'Y')
		{
			$query = "
			SELECT 
			smf.`id` AS software_module_function_id
			FROM `software_module_functions` smf
			RIGHT JOIN `software_modules` sm ON sm.`id` = smf.`software_module_id`
			RIGHT JOIN `software_module_categories` smc 
			ON smc.`id` = sm.`software_module_category_id`
			WHERE smc.`software_module_category` = ?
			";
			$arrValues = array();
			$arrValues = array($software_module_category);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$dataId = array();
			while($row1 = $db->fetch())
			{
				$smcId = $row1['software_module_function_id'];
				array_push($dataId, $smcId);
			}
			if(!isset($dataId) || empty($dataId)) {
				return false;
			}
			$smc_functions =  implode(',', $dataId);
			$db->free_result();
			//For project specific roles  and should not consider user access		
			$query1 ="
			SELECT * FROM `projects_to_roles_to_software_module_functions` AS prsmf 
			INNER JOIN projects_to_contacts_to_roles AS ptcr ON ptcr.`role_id` = prsmf.`role_id` AND ptcr.`project_id` = prsmf.`project_id` 
			WHERE prsmf.`software_module_function_id` IN (?) 
			AND ptcr.`contact_id` = ? 
			AND ptcr.`project_id` = ?
			AND prsmf.`role_id` <> ? ";
			$arrValues = array();
			$arrValues = array($smc_functions, $primary_contact_id, $project_id, 3);
			$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);	
			$row1 = $db->fetch();
			$db->free_result();
			if (!isset($row1) || empty($row1)) {
				/* Check the Non Project Specific roles in project Specific */
				$query3 = "
				SELECT * FROM `projects_to_roles_to_software_module_functions` AS prsmf 
				INNER JOIN contacts_to_roles AS ctr ON ctr.`role_id` = prsmf.`role_id` 
				WHERE prsmf.`software_module_function_id` IN (?)
				AND ctr.`contact_id` = ?
				AND prsmf.`project_id` = ? ";
				$arrValues = array($smc_functions, $primary_contact_id, $project_id);
				$db->execute($query3, $arrValues, MYSQLI_USE_RESULT);
				$row3 = $db->fetch();
				$db->free_result();
				if (!isset($row3) || empty($row3)) {
					return false;
				}else{
					return true;

				}
				/* Check the Non Project Specific roles in project Specific */		
				return false;
			} else {
				return true;
			}

		} else {
			$query2 = "
			SELECT 
			sm.`id` AS software_module_id,
			smf.`id` AS software_module_function_id
			FROM `software_module_functions` smf
			RIGHT JOIN `software_modules` sm ON sm.`id` = smf.`software_module_id`
			RIGHT JOIN `software_module_categories` smc ON smc.`id` = sm.`software_module_category_id`
			WHERE smc.`software_module_category` = ?
			";
			$arrValues = array($software_module_category);
			$db->execute($query2, $arrValues, MYSQLI_USE_RESULT);
			$dataId = array();
			$datafId = array();
			while($row1 = $db->fetch())
			{
				$smcId = $row1['software_module_id'];
				$smcfId = $row1['software_module_function_id'];
				array_push($dataId, $smcId);
				array_push($datafId, $smcfId);
			}
			if(!isset($dataId) || empty($dataId)) {
				return false;
			}
			$smc_modules = implode(',', $dataId);
			$smc_functions = implode(',', $datafId);
			$db->free_result();
		   //For  non specific roles and should not consider user access
			$query4 ="
			SELECT * FROM `user_companies_to_software_modules` AS ucsm 
			INNER JOIN roles_to_software_module_function_templates AS rsmf ON rsmf.`user_company_id` = ucsm.`user_company_id` 
			INNER JOIN contacts_to_roles AS cr ON cr.`role_id` = rsmf.`role_id` 
			WHERE ucsm.`user_company_id` = ?
			AND ucsm.`software_module_id` IN (?)
			AND rsmf.`software_module_function_id` IN (?)
			AND cr.`contact_id` = ?
			AND rsmf.`role_id` <> ?";
			$arrValues = array($user_company_id, $smc_modules, $smc_functions, $primary_contact_id, 3);
			$db->execute($query4, $arrValues, MYSQLI_USE_RESULT);	
			$row = $db->fetch();
			$db->free_result();
			$prjnonspecific = "";
			if (!isset($row) || empty($row)) {
				$prjnonspecific= false;
			} else {
				$prjnonspecific= true;
			}

			//For project specific roles  and should not consider user access		
			$query5 ="SELECT * FROM `user_companies_to_software_modules` AS ucsm 
			INNER JOIN roles_to_software_module_function_templates AS rsmf ON rsmf.`user_company_id` = ucsm.`user_company_id` 
			INNER JOIN projects_to_contacts_to_roles AS ptcr ON ptcr.`role_id` = rsmf.`role_id`
			WHERE ucsm.`user_company_id` = ?
			AND ucsm.`software_module_id` IN (?)
			AND rsmf.`software_module_function_id` IN (?) 
			AND ptcr.`contact_id` = ?
			AND ptcr.`project_id` = ?
			AND rsmf.`role_id` <> ?";
			$arrValues = array($user_company_id, $smc_modules, $smc_functions, $primary_contact_id, $project_id, 3);
			$db->execute($query5, $arrValues, MYSQLI_USE_RESULT);
			$row1 = $db->fetch();
			$db->free_result();
			$prjspecific = "";
			if (!isset($row1) || empty($row1)) {
				$prjspecific = false;
			} else {
				$prjspecific  = true;
			}
			if($prjnonspecific == true && $prjspecific == true)
			{
				return true;
			} else if ($prjnonspecific == false && $prjspecific == true) {
				return true;
			} else if ($prjnonspecific == true && $prjspecific == false) {
				return true;
			} else {
				return false;
			}	
		}		
	}
	//To check whether a contact has access to the module
	public static function checkSoftwareModuleCategoryPrePermission($database, $user_company_id, $software_module_category, $project_id, $primary_contact_id, $project_specific_flag, $userRole)
	{
		// if user global admin access true
		if ($userRole == 'global_admin') {
			return true;
		}
		$db = DBI::getInstance($database);
		$db->free_result();
	
		$query = "
		SELECT 
		sm.`id` AS software_module_id,
		smf.`id` AS software_module_function_id
		FROM `user_companies_to_software_modules` AS uc
		INNER JOIN `software_modules` AS sm ON uc.`software_module_id` = sm.`id`
		INNER JOIN `software_module_functions` AS smf ON sm.`id` = smf.`software_module_id` 
		INNER JOIN software_module_categories AS smc ON smc.`id` = sm.`software_module_category_id`
		WHERE uc.`user_company_id` = ? AND smc.`software_module_category` = ?
		";

		$arrValues = array();
		$arrValues = array($user_company_id, $software_module_category);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$dataId = array();
		$dataSMId = array();
		while($row1 = $db->fetch())
		{
			$smcId = $row1['software_module_function_id'];
			$smId = $row1['software_module_id'];			
			if (!in_array($smcId, $dataId)) {
				array_push($dataId, $smcId);
			}	
			if (!in_array($smId, $dataSMId)) {
				array_push($dataSMId, $smId);
			}			
		}
		if(!isset($dataId) || empty($dataId)) {
			return false;
		}
		$smc_functions =  implode(',', $dataId);
		$smc_modules = implode(',', $dataSMId);
		$db->free_result();
		//For project specific roles  and should not consider user access		
		$query1 ="
		SELECT * FROM `projects_to_roles_to_software_module_functions` AS prsmf 
		INNER JOIN projects_to_contacts_to_roles AS ptcr ON ptcr.`role_id` = prsmf.`role_id` AND ptcr.`project_id` = prsmf.`project_id` 
		WHERE prsmf.`software_module_function_id` IN (?) 
		AND ptcr.`contact_id` = ? 
		AND ptcr.`project_id` = ?
		";
		$arrValues = array();
		$arrValues = array($smc_functions, $primary_contact_id, $project_id);
		$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);	
		$row1 = $db->fetch();
		$db->free_result();
		if(isset($row1) || !empty($row1)) {
			return true;
		}
		/* Check the Non Project Specific roles in project Specific */
		$query3 = "
		SELECT * FROM `projects_to_roles_to_software_module_functions` AS prsmf 
		INNER JOIN contacts_to_roles AS ctr ON ctr.`role_id` = prsmf.`role_id` 
		WHERE prsmf.`software_module_function_id` IN (?)
		AND ctr.`contact_id` = ?
		AND prsmf.`project_id` = ? ";
		$arrValues = array($smc_functions, $primary_contact_id, $project_id);
		$db->execute($query3, $arrValues, MYSQLI_USE_RESULT);
		$row3 = $db->fetch();
		$db->free_result();
		if (isset($row3) || !empty($row3)) {
			return true;
		}

		// check permission based on non project roles
		$query4 ="
		SELECT * FROM `user_companies_to_software_modules` AS ucsm 
		INNER JOIN roles_to_software_module_function_templates AS rsmf ON rsmf.`user_company_id` = ucsm.`user_company_id` 
		INNER JOIN contacts_to_roles AS cr ON cr.`role_id` = rsmf.`role_id` 
		WHERE ucsm.`user_company_id` = ?
		AND ucsm.`software_module_id` IN (?)
		AND rsmf.`software_module_function_id` IN (?)
		AND cr.`contact_id` = ?
		";
		$arrValues = array($user_company_id, $smc_modules, $smc_functions, $primary_contact_id);
		// print_r($arrValues);
		$db->execute($query4, $arrValues, MYSQLI_USE_RESULT);	
		$row = $db->fetch();
		$db->free_result();
		if (isset($row) || !empty($row)) {
			return true;
		}
		$db->free_result();
		//For project specific roles  and should not consider user access		
		$query5 ="SELECT * FROM `user_companies_to_software_modules` AS ucsm 
		INNER JOIN roles_to_software_module_function_templates AS rsmf ON rsmf.`user_company_id` = ucsm.`user_company_id` 
		INNER JOIN projects_to_contacts_to_roles AS ptcr ON ptcr.`role_id` = rsmf.`role_id`
		WHERE ucsm.`user_company_id` = ?
		AND ucsm.`software_module_id` IN (?)
		AND rsmf.`software_module_function_id` IN (?) 
		AND ptcr.`contact_id` = ?
		AND ptcr.`project_id` = ?
		";
		$arrValues = array($user_company_id, $smc_modules, $smc_functions, $primary_contact_id, $project_id);
		$db->execute($query5, $arrValues, MYSQLI_USE_RESULT);
		$row1 = $db->fetch();
		$db->free_result();
		if (isset($row1) || !empty($row1)) {
			return true;
		}

		// rare case scenario
		$query6 ="
		SELECT
		*
		FROM `projects_to_contacts_to_software_module_functions`
		WHERE `contact_id` = ?
		AND `software_module_function_id` IN (?)
		AND `project_id` = ? ";
		$arrValues = array($primary_contact_id, $smc_functions, $project_id);
		$db->execute($query6, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if (isset($row) || !empty($row)) {
			return true;
		}

		$query6 ="
		SELECT
		*
		FROM `contacts_to_software_module_functions`
		WHERE `contact_id` = ?
		AND `software_module_function_id` IN (?)";
		$arrValues = array($primary_contact_id, $smc_functions);
		$db->execute($query6, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if (isset($row) || !empty($row)) {
			return true;
		}
		/* Check the Non Project Specific roles in project Specific */		
		return false;
	}

	//To check whether a contact has access to the module
	public static function checkSoftwareModulePrePermission($database, $user_company_id, $software_module, $project_id, $primary_contact_id, $project_specific_flag, $userRole)
	{
		// if user global admin access true
		if ($userRole == 'global_admin') {
			return true;
		}
		$db = DBI::getInstance($database);
		$db->free_result();
	
		$query = "
		SELECT 
		sm.`id` AS software_module_id,
		smf.`id` AS software_module_function_id
		FROM `user_companies_to_software_modules` AS uc
		INNER JOIN `software_modules` AS sm ON uc.`software_module_id` = sm.`id`
		INNER JOIN `software_module_functions` AS smf ON sm.`id` = smf.`software_module_id` 
		INNER JOIN `software_module_categories` AS smc ON smc.`id` = sm.`software_module_category_id`
		WHERE uc.`user_company_id` = ? AND sm.`software_module` = ?
		";

		$arrValues = array();
		$arrValues = array($user_company_id, $software_module);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$dataId = array();
		$dataSMId = array();
		while($row1 = $db->fetch())
		{
			$smcId = $row1['software_module_function_id'];
			$smId = $row1['software_module_id'];			
			if (!in_array($smcId, $dataId)) {
				array_push($dataId, $smcId);
			}	
			if (!in_array($smId, $dataSMId)) {
				array_push($dataSMId, $smId);
			}			
		}
		if(!isset($dataId) || empty($dataId)) {
			return false;
		}
		$smc_functions =  implode(',', $dataId);
		$smc_modules = implode(',', $dataSMId);
		$db->free_result();
		//For project specific roles  and should not consider user access		
		$query1 ="
		SELECT * FROM `projects_to_roles_to_software_module_functions` AS prsmf 
		INNER JOIN projects_to_contacts_to_roles AS ptcr ON ptcr.`role_id` = prsmf.`role_id` AND ptcr.`project_id` = prsmf.`project_id` 
		WHERE prsmf.`software_module_function_id` IN (?) 
		AND ptcr.`contact_id` = ? 
		AND ptcr.`project_id` = ?
		";
		$arrValues = array();
		$arrValues = array($smc_functions, $primary_contact_id, $project_id);
		$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);	
		$row1 = $db->fetch();
		$db->free_result();
		if(isset($row1) || !empty($row1)) {
			return true;
		}
		/* Check the Non Project Specific roles in project Specific */
		$query3 = "
		SELECT * FROM `projects_to_roles_to_software_module_functions` AS prsmf 
		INNER JOIN contacts_to_roles AS ctr ON ctr.`role_id` = prsmf.`role_id` 
		WHERE prsmf.`software_module_function_id` IN (?)
		AND ctr.`contact_id` = ?
		AND prsmf.`project_id` = ? ";
		$arrValues = array($smc_functions, $primary_contact_id, $project_id);
		$db->execute($query3, $arrValues, MYSQLI_USE_RESULT);
		$row3 = $db->fetch();
		$db->free_result();
		if (isset($row3) || !empty($row3)) {
			return true;
		}

		// check permission based on non project roles
		$query4 ="
		SELECT * FROM `user_companies_to_software_modules` AS ucsm 
		INNER JOIN roles_to_software_module_function_templates AS rsmf ON rsmf.`user_company_id` = ucsm.`user_company_id` 
		INNER JOIN contacts_to_roles AS cr ON cr.`role_id` = rsmf.`role_id` 
		WHERE ucsm.`user_company_id` = ?
		AND ucsm.`software_module_id` IN (?)
		AND rsmf.`software_module_function_id` IN (?)
		AND cr.`contact_id` = ?
		";
		$arrValues = array($user_company_id, $smc_modules, $smc_functions, $primary_contact_id);
		// print_r($arrValues);
		$db->execute($query4, $arrValues, MYSQLI_USE_RESULT);	
		$row = $db->fetch();
		$db->free_result();
		if (isset($row) || !empty($row)) {
			return true;
		}
		$db->free_result();
		//For project specific roles  and should not consider user access		
		$query5 ="SELECT * FROM `user_companies_to_software_modules` AS ucsm 
		INNER JOIN roles_to_software_module_function_templates AS rsmf ON rsmf.`user_company_id` = ucsm.`user_company_id` 
		INNER JOIN projects_to_contacts_to_roles AS ptcr ON ptcr.`role_id` = rsmf.`role_id`
		WHERE ucsm.`user_company_id` = ?
		AND ucsm.`software_module_id` IN (?)
		AND rsmf.`software_module_function_id` IN (?) 
		AND ptcr.`contact_id` = ?
		AND ptcr.`project_id` = ?
		";
		$arrValues = array($user_company_id, $smc_modules, $smc_functions, $primary_contact_id, $project_id);
		$db->execute($query5, $arrValues, MYSQLI_USE_RESULT);
		$row1 = $db->fetch();
		$db->free_result();
		if (isset($row1) || !empty($row1)) {
			return true;
		}

		// rare case scenario
		$query6 ="
		SELECT
		*
		FROM `projects_to_contacts_to_software_module_functions`
		WHERE `contact_id` = ?
		AND `software_module_function_id` IN (?)
		AND `project_id` = ? ";
		$arrValues = array($primary_contact_id, $smc_functions, $project_id);
		$db->execute($query6, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if (isset($row) || !empty($row)) {
			return true;
		}

		$query6 ="
		SELECT
		*
		FROM `contacts_to_software_module_functions`
		WHERE `contact_id` = ?
		AND `software_module_function_id` IN (?)";
		$arrValues = array($primary_contact_id, $smc_functions);
		$db->execute($query6, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if (isset($row) || !empty($row)) {
			return true;
		}
		/* Check the Non Project Specific roles in project Specific */		
		return false;
	}
	//To check whether a contact has access to the software module
	public static function checkSoftwareModulePermission($database, $user_company_id, $software_module, $project_id, $primary_contact_id, $project_specific_flag, $userRole)
	{
		// if user global admin access true
		if ($userRole == 'global_admin') {
			return true;
		}
		$db = DBI::getInstance($database);
		$db->free_result();
		if($project_specific_flag == 'Y')
		{
			$query = "
			SELECT 
			smf.`id` AS software_module_function_id
			FROM `software_module_functions` smf
			RIGHT JOIN `software_modules` sm ON sm.`id` = smf.`software_module_id`
			WHERE sm.`software_module` = ?
			";
			$arrValues = array();
			$arrValues = array($software_module);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$dataId = array();
			while($row1 = $db->fetch())
			{
				$smcId = $row1['software_module_function_id'];
				array_push($dataId, $smcId);
			}
			if(!isset($dataId) || empty($dataId)) {
				return false;
			}
			$smc_functions =  implode(',', $dataId);
			$db->free_result();
			//For project specific roles  and should not consider user access		
			$query1 ="
			SELECT * FROM `projects_to_roles_to_software_module_functions` AS prsmf 
			INNER JOIN projects_to_contacts_to_roles AS ptcr ON ptcr.`role_id` = prsmf.`role_id` AND ptcr.`project_id` = prsmf.`project_id` 
			WHERE prsmf.`software_module_function_id` IN (?) 
			AND ptcr.`contact_id` = ? 
			AND ptcr.`project_id` = ?
			AND prsmf.`role_id` <> ? ";
			$arrValues = array();
			$arrValues = array($smc_functions, $primary_contact_id, $project_id, 3);
			$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);	
			$row1 = $db->fetch();
			$db->free_result();
			if (!isset($row1) || empty($row1)) {
				/* Check the Non Project Specific roles in project Specific */
				$query3 = "
				SELECT * FROM `projects_to_roles_to_software_module_functions` AS prsmf 
				INNER JOIN contacts_to_roles AS ctr ON ctr.`role_id` = prsmf.`role_id` 
				WHERE prsmf.`software_module_function_id` IN (?)
				AND ctr.`contact_id` = ?
				AND prsmf.`project_id` = ? ";
				$arrValues = array($smc_functions, $primary_contact_id, $project_id);
				$db->execute($query3, $arrValues, MYSQLI_USE_RESULT);
				$row3 = $db->fetch();
				$db->free_result();
				if (!isset($row3) || empty($row3)) {
					return false;
				}else{
					return true;

				}
				/* Check the Non Project Specific roles in project Specific */		
				return false;
			} else {
				return true;
			}

		} else {
			$query2 = "
			SELECT 
			sm.`id` AS software_module_id,
			smf.`id` AS software_module_function_id
			FROM `software_module_functions` smf
			RIGHT JOIN `software_modules` sm ON sm.`id` = smf.`software_module_id`
			WHERE sm.`software_module` = ?
			";
			$arrValues = array($software_module);
			$db->execute($query2, $arrValues, MYSQLI_USE_RESULT);
			$dataId = array();
			$datafId = array();
			while($row1 = $db->fetch())
			{
				$smcId = $row1['software_module_id'];
				$smcfId = $row1['software_module_function_id'];
				array_push($dataId, $smcId);
				array_push($datafId, $smcfId);
			}
			if(!isset($dataId) || empty($dataId)) {
				return false;
			}
			$smc_modules = implode(',', $dataId);
			$smc_functions = implode(',', $datafId);
			$db->free_result();
		   //For  non specific roles and should not consider user access
			$query4 ="
			SELECT * FROM `user_companies_to_software_modules` AS ucsm 
			INNER JOIN roles_to_software_module_function_templates AS rsmf ON rsmf.`user_company_id` = ucsm.`user_company_id` 
			INNER JOIN contacts_to_roles AS cr ON cr.`role_id` = rsmf.`role_id` 
			WHERE ucsm.`user_company_id` = ?
			AND ucsm.`software_module_id` IN (?)
			AND rsmf.`software_module_function_id` IN (?)
			AND cr.`contact_id` = ?
			AND rsmf.`role_id` <> ?";
			$arrValues = array($user_company_id, $smc_modules, $smc_functions, $primary_contact_id, 3);
			$db->execute($query4, $arrValues, MYSQLI_USE_RESULT);	
			$row = $db->fetch();
			$db->free_result();
			$prjnonspecific = "";
			if (!isset($row) || empty($row)) {
				$prjnonspecific= false;
			} else {
				$prjnonspecific= true;
			}

			//For project specific roles  and should not consider user access		
			$query5 ="SELECT * FROM `user_companies_to_software_modules` AS ucsm 
			INNER JOIN roles_to_software_module_function_templates AS rsmf ON rsmf.`user_company_id` = ucsm.`user_company_id` 
			INNER JOIN projects_to_contacts_to_roles AS ptcr ON ptcr.`role_id` = rsmf.`role_id`
			WHERE ucsm.`user_company_id` = ?
			AND ucsm.`software_module_id` IN (?)
			AND rsmf.`software_module_function_id` IN (?) 
			AND ptcr.`contact_id` = ?
			AND ptcr.`project_id` = ?
			AND rsmf.`role_id` <> ?";
			$arrValues = array($user_company_id, $smc_modules, $smc_functions, $primary_contact_id, $project_id, 3);
			$db->execute($query5, $arrValues, MYSQLI_USE_RESULT);
			$row1 = $db->fetch();
			$db->free_result();
			$prjspecific = "";
			if (!isset($row1) || empty($row1)) {
				$prjspecific = false;
			} else {
				$prjspecific  = true;
			}
			if($prjnonspecific == true && $prjspecific == true)
			{
				return true;
			} else if ($prjnonspecific == false && $prjspecific == true) {
				return true;
			} else if ($prjnonspecific == true && $prjspecific == false) {
				return true;
			} else {
				return false;
			}	
		}		
	}
	public static function checkSoftwareModuleCount($database, $software_module_category)
	{
		$db = DBI::getInstance($database);
		$db->free_result();
		$query = "
		SELECT 
		COUNT(sm.`id`) AS software_modules_count
		FROM `software_modules` sm
		RIGHT JOIN `software_module_categories` smc 
		ON smc.`id` = sm.`software_module_category_id`
		WHERE smc.`software_module_category` = ?
		";
		$arrValues = array($software_module_category);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$count = 0;
		if ($row) {
			$count = $row['software_modules_count'];
		}
		$db->free_result();
		return $count;
	}

	public static function getSoftwareModuleByCategory($database, $software_module_category)
	{
		$db = DBI::getInstance($database);
		$db->free_result();
		$query = "
		SELECT 
		sm.`mobile_navigation_id` AS sm_mobile_navigation_id
		FROM `software_modules` sm
		RIGHT JOIN `software_module_categories` smc 
		ON smc.`id` = sm.`software_module_category_id`
		WHERE smc.`software_module_category` = ?
		";
		$arrValues = array($software_module_category);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$mobile_navigation_id = null;
		if ($row) {
			$mobile_navigation_id = $row['sm_mobile_navigation_id'];
		}
		$db->free_result();
		return $mobile_navigation_id;
	}
	/*
	check the module have permission against companies
	*/
	public static function checkSoftwareModuleCompanyHavePermission($database, $software_module_id, $user_company_id)
	{
		$db = DBI::getInstance($database);
		$db->free_result();
		$query = "
		SELECT 
		*
		FROM `user_companies_to_software_modules` ucsm
		WHERE ucsm.`software_module_id` = ?
		AND ucsm.`user_company_id` = ?
		";
		$arrValues = array($software_module_id, $user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$access = false;
		if ($row) {
			$access = true;
		}
		$db->free_result();
		return $access;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
