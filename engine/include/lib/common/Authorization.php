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
 * Authorization based upon an Acess Control List (ACL).
 *
 * @category	Authorization
 * @package		Authorization
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

/**
 * Access_Control_List
 */
//require_once('lib/common/Access_Control_List.php');

/**
 * Zend_Acl
 */
//require_once('Zend/Acl.php');

class Authorization extends IntegratedMapper
{
	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var unknown_type
	 */
	protected $_table = 'access_control_lists';

	private $userRole;

	private $accessControlList = array();

	/**
	 * Static Singleton instance variable
	 *
	 * @var Authorization
	 */
	private static $_instance;

	/**
	 * Static factory method to return an instance of the object.
	 *
	 * @param Static object reference
	 * @return Singleton object reference
	 */
	public static function getInstance() {
		// Check if a Singleton exists for the Authorization class
		$instance = self::$_instance;

		if (!isset($instance) || !($instance instanceof Authorization)) {
			// Check if session has the object
			$session = Session::getInstance();
			$auth = $session->get('auth');

			if (!isset($auth) || !($auth instanceof Authorization)) {
				$auth = new Authorization();
				/* @var $auth Authorization */
				$session->set('auth', $auth);
			}

			$instance = $auth;
			self::$_instance = $instance;
		}

		return $instance;
	}

	/**
	 * Constructor
	 * Input: None
	 * Output: None
	 * Action: Grab instance of object
	 * Please use singleton where possible
	 *
	 */
	public function __construct() {
		//$accessControlList = $auth->getAccessControlList();
	}

	public function getUserRole()
	{
		if (isset($this->userRole) && !empty($this->userRole)) {
			return $this->userRole;
		} else {
			return null;
		}
	}

	public function setUserRole($userRole)
	{
		// auth (authenticated user), admin (account admin), global_admin (root user)
		$this->userRole = $userRole;
	}

	public function debug()
	{
		$instance = self::getInstance();
		$session = Session::getInstance();
		$auth = $session->get('auth');

		echo "<pre>\n[Session Var]\n";
		var_dump($session);
		echo "\n\n\n\n\n\n\n\n[Auth Var]\n";
		var_dump($auth);
		exit;
	}

	public function getAccessControlList()
	{
		return $this->accessControlList;
	}

	public function setAccessControlList($acl)
	{
		$this->accessControlList = $acl;
	}

	//public static function authorizeUser(User $u, $resource)
	public static function authorizeUser($database, $user_id, $user_company_id)
	{
		//$database = $u->getDatabase();
		//$user_id = $u->id;
		// Possibly find roles by account
		//$user_company_id = $u->user_company_id;

		if (!isset($user_id)) {
			return;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		/*
		$query =
"
SELECT r.*
FROM `users_to_roles` u2r INNER JOIN `roles` r ON u2r.role_id = r.`id`
WHERE u2r.`user_id` = $user_id
";
		*/

		$query =
"
SELECT r.role
FROM `roles` r INNER JOIN `users` u ON r.`id` = u.role_id
WHERE u.`id` = $user_id
";
		//$arrValues = array($user_id);
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRoles = array();
		while ($row = $db->fetch()) {
			$role = $row['role'];
			$arrRoles[$role] = 1;
		}
		$db->free_result();

		$userRole = 'anon';
		$accessControlList = array();
		if (isset($arrRoles['Global Admin'])) {
			$userRole = 'global_admin';
			$accessControlList['user_role'] = 'global_admin';
		} elseif (isset($arrRoles['Admin'])) {
			$userRole = 'admin';
			$accessControlList['user_role'] = 'admin';
		} else {
			$userRole = 'user';
			$accessControlList['user_role'] = 'user';
		}

		$auth = self::getInstance();
		/* @var $auth Authorization */

		$auth->setDatabase($database);
		$auth->setUserRole($userRole);
		$auth->setAccessControlList($accessControlList);

		return $auth;
	}

	public function zendAuthorize($userId)
	{
		$arrAcl = Access_Control_List::determineRoles($userId);

		$arrRoles = array_keys($arrAcl);

		$acl = new Zend_Acl();
		foreach ($arrRoles as $role) {
			$acl->addRole(new Zend_Acl_Role($role));
		}

		$acl->addRole(new Zend_Acl_Role('guest'))
		    ->addRole(new Zend_Acl_Role('member'))
		    ->addRole(new Zend_Acl_Role('admin'));
		$parents = array('guest', 'member', 'admin');
		$acl->addRole(new Zend_Acl_Role('someUser'), $parents);
		$acl->add(new Zend_Acl_Resource('someResource'));
		$acl->deny('guest', 'someResource');
		$acl->allow('member', 'someResource');

		return $acl;
	}

	public static function buildPrimaryNavigation($database, $user_company_id, $user_id, $project_id=null, $contact_id=null, $user_role_id=null, $contact_role_id=null)
	{
		// Build modules list for the company (based on their subscription

		//

		//
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
