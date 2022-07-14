<?php
/**
 * Left nav.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['ajax'] = true;
$init['get_required'] = true;
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

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

$db = DBI::getInstance($database);

// Start output buffering to prevent output from being echo'd out
ob_start();

switch ($methodCall) {
	case 'updateSessionCurrentlySelectedProjectId':
		if ($get->project_id) {
			$project_id = $get->project_id;
			require_once('lib/common/Project.php');
			$project = new Project($database);
			$key = array('id' => $project_id);
			$project->setKey($key);
			$data = array(
				'user_company_id' => 1,
				'project_name' => 1
			);
			$project->setData($data);
			$project->load();
			$project->convertDataToProperties();

			if ($project->user_company_id && $project->project_name) {
				$currentlySelectedProjectUserCompanyId = $project->user_company_id;
				$session->setCurrentlySelectedProjectUserCompanyId($currentlySelectedProjectUserCompanyId);

				$currentlySelectedProjectId = $project_id;
				$session->setCurrentlySelectedProjectId($currentlySelectedProjectId);

				$currentlySelectedProjectName = $project->project_name;
				$session->setCurrentlySelectedProjectName($currentlySelectedProjectName);

				// Load the "Project Owner" contact data for the user
				require_once('lib/common/Contact.php');
				$user_id = $session->getUserId();
				$contact = Contact::findContactByUserCompanyIdAndUserId($database, $currentlySelectedProjectUserCompanyId, $user_id);

				$currentlyActiveContactId = $contact->contact_id;
				$session->setCurrentlyActiveContactId($currentlyActiveContactId);
			}
		}

		break;
}

ob_flush();
exit;
