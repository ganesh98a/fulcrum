<?php

$database = Zend_Registry::get('database');
$db = DBI::getInstance($database);

/**
 *
 * 1. Get user's roles (Global Admin, Admin, User)
 * 2. Do they have any non-project roles? (Accounting, Management Staff, etc)
 * 3. Get all projects from projects_to_contacts_to_roles for all their possible contact records
 * 4. Get all projects from adhoc permission to project assignments for all their possible contact records.
 *
 */

$session = Zend_Registry::get('session');
/* @var $session Session */

$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$primary_contact_id = (int)$session->getPrimaryContactId();
$userRole = $session->getUserRole();
$actualUserRole = $session->getActualUserRole();

// Debug Mode
$debugMode = (bool) $session->getDebugMode();

// The project_id that the user has currently selected from their Projects List of both: 1) "Owned Projects" and 2) "Guest Projects"

// $queries = array();
// parse_str($_SERVER['QUERY_STRING'], $queries);
// //to set the session data for seleting other project
// if(!empty($queries)){
// $session->setCurrentlySelectedProjectId(base64_decode($queries['project_id']));
// $project_name_base = base64_decode($queries['project_name']);
// $project_name = urldecode($project_name_base);
// $session->setCurrentlySelectedProjectName($project_name);
// }
if(isset($_GET['pID']) && $_GET['pID']!=''){
	$currentlySelectedProjectId  = base64_decode($_GET['pID']);
}else{
	$currentlySelectedProjectId = (int)$session->getCurrentlySelectedProjectId();
}

// The contact_id of the user in the companies' contact list that actually owns the $currentlySelectedProjectId, may be the users' company or a different company.
$currentlyActiveContactId = (int)$session->getCurrentlyActiveContactId();

$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;


$arrActiveProjects = array();
$arrBiddingProjects = array();
$arrCompletedProjects = array();
$arrOtherProjects = array();
$currentlySelectedProjectTypeIndex = -1;


// We always attempt to load projects that are "Owned Projects" if the users' company is a paying customer
$userCompany = new UserCompany($database);
$key = array('id' => $user_company_id);
$userCompany->setKey($key);
$userCompany->load();
$userCompany->convertDataToProperties();
$paying_customer_flag = $userCompany->paying_customer_flag;


// Paying customers can have "Owned Projects"
//if ($paying_customer_flag == 'Y') {
	$arrOwnedProjects = Project::loadOwnedProjects($database, $userRole, $user_company_id, $user_id, $primary_contact_id);
//} else {
//	// A non-paying customer never owns any projects
//	$arrOwnedProjects = array();
//}

foreach ($arrOwnedProjects as $arrProjectData) {
	$tmpProjectId = $arrProjectData['id'];
	$project_name = $arrProjectData['project_name'];
	$is_active = $arrProjectData['is_active_flag'];
	$is_internal = $arrProjectData['is_internal_flag'];
	$project_completed_date = $arrProjectData['project_completed_date'];

	if ($debugMode) {
		$project_name = "($tmpProjectId) $project_name";
	}

	if ($is_active == 'Y') {
		$arrActiveProjects[$tmpProjectId] = $project_name;
		$projectTypeIndex = 0;

	} elseif ($is_internal == 'Y') {
		$arrBiddingProjects[$tmpProjectId] = $project_name;
		$projectTypeIndex = 1;

	} elseif ($project_completed_date != '0000-00-00') {
		$arrCompletedProjects[$tmpProjectId] = $project_name;
		$projectTypeIndex = 2;

	} else {
		$arrOtherProjects[$tmpProjectId] = $project_name;
		$projectTypeIndex = 3;
	}

	if ($tmpProjectId == $currentlySelectedProjectId) {
		$currentlySelectedProjectTypeIndex = $projectTypeIndex;
		$currentlySelectedProjectName = $project_name;
	}
}

// Load "Guest Projects" where the user_id is linked to a contact_id in a third-party contacts list
$arrGuestProjects = Project::loadGuestProjects($database, $user_company_id, $user_id, $primary_contact_id);

foreach ($arrGuestProjects as $arrProjectData) {
	$tmpProjectId = $arrProjectData['id'];
	$project_name = $arrProjectData['project_name'];
	$is_active = $arrProjectData['is_active_flag'];
	$is_internal = $arrProjectData['is_internal_flag'];
	$project_completed_date = $arrProjectData['project_completed_date'];

	if ($debugMode) {
		$project_name = "($tmpProjectId) $project_name";
	}

	if ($is_active == 'Y') {
		$arrActiveProjects[$tmpProjectId] = $project_name . " ***";
		$projectTypeIndex = 0;

	} elseif ($is_internal == 'Y') {
		$arrBiddingProjects[$tmpProjectId] = $project_name . " ***";
		$projectTypeIndex = 1;

	} elseif ($project_completed_date != '0000-00-00') {
		$arrCompletedProjects[$tmpProjectId] = $project_name . " ***";
		$projectTypeIndex = 2;

	} else {
		$arrOtherProjects[$tmpProjectId] = $project_name . " ***";
		$projectTypeIndex = 3;
	}

	if ($tmpProjectId == $currentlySelectedProjectId) {
		$currentlySelectedProjectTypeIndex = $projectTypeIndex;
		$currentlySelectedProjectName = $project_name . " ***";
	}
}

// Load "Guest Projects" that the user has been invited to bid through the purchasing module
$arrGuestProjects = Project::loadGuestProjectsWhereContactHasBeenInvitedToBidThroughThePurchasingModule($database, $user_company_id, $user_id, $primary_contact_id);

foreach ($arrGuestProjects as $arrProjectData) {
	$tmpProjectId = $arrProjectData['id'];
	$project_name = $arrProjectData['project_name'];
	$is_active = $arrProjectData['is_active_flag'];
	$is_internal = $arrProjectData['is_internal_flag'];
	$project_completed_date = $arrProjectData['project_completed_date'];
/*
	if ($is_active == 'Y') {
		$arrActiveProjects[$tmpProjectId] = $project_name . " ***";
		$projectTypeIndex = 0;

	} elseif ($is_internal == 'Y') {
		$arrBiddingProjects[$tmpProjectId] = $project_name . " ***";
		$projectTypeIndex = 1;

	} elseif ($project_completed_date != '0000-00-00') {
		$arrCompletedProjects[$tmpProjectId] = $project_name . " ***";
		$projectTypeIndex = 2;

	} else {
		$arrOtherProjects[$tmpProjectId] = $project_name . " ***";
		$projectTypeIndex = 3;
	}
*/

	//if (!isset($arrActiveProjects) || !isset($arrActiveProjects[$tmpProjectId]) ) {
		// If the project has not been added as an "active project", then add it to "bidding project"
		//$arrBiddingProjects[$tmpProjectId] = $project_name . " ***";
		//$projectTypeIndex = 1;
	//} elseif (isset($arrActiveProjects[$tmpProjectId])) {
		// If the project is set as an "Active Project", but the user is bidding it through the Purchasing module then add it to the "Bidding Projects"
		unset($arrActiveProjects[$tmpProjectId]);
		$arrBiddingProjects[$tmpProjectId] = $project_name . " ***";
		$projectTypeIndex = 1;
	//}

	if ($tmpProjectId == $currentlySelectedProjectId) {
		$currentlySelectedProjectTypeIndex = $projectTypeIndex;
		$currentlySelectedProjectName = $project_name . " ***";
	}
}


// If they have a project set in the session then load it.
if (($currentlySelectedProjectId != $AXIS_NON_EXISTENT_PROJECT_ID) || $userRole == "global_admin") {
	$showProjectNavBox = true;
} else {
	// If they don't have a default project then load to the one at the top of the list.
	$showProjectNavBox = false;

	if ($currentlySelectedProjectTypeIndex == -1) {
		if (!empty($arrActiveProjects)) {
			$showProjectNavBox = true;
			$currentlySelectedProjectTypeIndex = 0;
			foreach ($arrActiveProjects AS $project_id => $projectName) {
				$currentlySelectedProjectName = $projectName;
				$currentlySelectedProjectId = $project_id;
				break;
			}
		} elseif (!empty($arrBiddingProjects)) {
			$showProjectNavBox = true;
			$currentlySelectedProjectTypeIndex = 1;
			foreach ($arrBiddingProjects AS $project_id => $projectName) {
				$currentlySelectedProjectName = $projectName;
				$currentlySelectedProjectId = $project_id;
				break;
			}
		} elseif (!empty($arrCompletedProjects)) {
			$showProjectNavBox = true;
			$currentlySelectedProjectTypeIndex = 2;
			foreach ($arrCompletedProjects AS $project_id => $projectName) {
				$currentlySelectedProjectName = $projectName;
				$currentlySelectedProjectId = $project_id;
				break;
			}
		} elseif (!empty($arrOtherProjects)) {
			$showProjectNavBox = true;
			$currentlySelectedProjectTypeIndex = 3;
			foreach ($arrOtherProjects AS $project_id => $projectName) {
				$currentlySelectedProjectName = $projectName;
				$currentlySelectedProjectId = $project_id;
				break;
			}
		}
	}
	// Since we're loading the top project for them.  We need to update the Session $currentlySelectedProjectId;
	if ($showProjectNavBox) {
		$session->setCurrentlySelectedProjectId($currentlySelectedProjectId);
		$session->setCurrentlySelectedProjectName($currentlySelectedProjectName);
	}

}
// Menu Expand or Collapse check the site_setting

$session->setCurrentlySelectedProjectTypeIndex($currentlySelectedProjectTypeIndex);
if ($showProjectNavBox) {
	// Assign the variable to a smarty template and retrieve the output into a variable.
	$template->assign('showProjectNavBox', $showProjectNavBox);
	$template->assign('currentlySelectedProjectTypeIndex', $currentlySelectedProjectTypeIndex);
	if (isset($currentlySelectedProjectName) && !empty($currentlySelectedProjectName)) {
		$displayProjectName = $currentlySelectedProjectName;
	} else {
		$displayProjectName = '';
	}
	$template->assign('currentlySelectedProjectName', $displayProjectName);
	$template->assign('currentlySelectedProjectId', $currentlySelectedProjectId);
	$template->assign('arrActiveProjects', $arrActiveProjects);
	$template->assign('arrBiddingProjects', $arrBiddingProjects);
	$template->assign('arrCompletedProjects', $arrCompletedProjects);
	$template->assign('arrOtherProjects', $arrOtherProjects);
	//  Menu Active
	$menuActiveClass = 'openheader';
	$cssDisplay = 'style="display:block;"';
	$template->assign('menuActiveClass', $menuActiveClass);
	$template->assign('cssDisplay', $cssDisplay);
	return;

echo '
<div id="navBoxProject" class="sidebarBox projectNavBox">
	<div class="arrowlistmenu">
';

if (count($arrActiveProjects) > 0) {
	echo'
			<div class="menuheader expandable">Active Projects</div>
	';
			if ($currentlySelectedProjectTypeIndex == 0) {
				echo '<div id="0_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();">'.$currentlySelectedProjectName.'<img id="projectNavImage" alt="" src="/images/navigation/left-nav-arrow-green.gif"></div>';
			} else {
				echo '<div id="0_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();">'.$currentlySelectedProjectName.'</div>';
			}
	echo '
			<ul class="categoryitems">
	';
			foreach ($arrActiveProjects AS $project_id => $projectName) {
				if ($currentlySelectedProjectId != $project_id) {
					$encodedProjectName = rawurlencode($projectName);
					echo '<li onclick="navigationProjectSelected(0, \''.$project_id.'\', \'' . $encodedProjectName . '\');"><a class="projectLinks" href="javascript:void(0);">'.substr($projectName,0,27).'</a></li>';
				}
			}
	echo '
			</ul>
	';
}

if (count($arrBiddingProjects) > 0) {
	echo '
			<div class="menuheader expandable">Bidding Projects</div>
	';
			if ($currentlySelectedProjectTypeIndex == 1) {
				echo '<div id="1_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();">'.$currentlySelectedProjectName.'</div>';
			} else {
				echo '<div id="1_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();">'.$currentlySelectedProjectName.'</div>';
			}
	echo '
			<ul class="categoryitems">
	';
			foreach ($arrBiddingProjects AS $project_id => $projectName) {
				if ($currentlySelectedProjectId != $project_id) {
					$encodedProjectName = rawurlencode($projectName);
					echo '<li onclick="navigationProjectSelected(1, \''.$project_id.'\', \'' . $encodedProjectName . '\');"><a href="javascript:void(0);">'.substr($projectName,0,27).'</a></li>';
				}
			}
	echo '
			</ul>
	';
}

if (count($arrCompletedProjects) > 0) {
	echo '
			<div class="menuheader expandable">Completed Projects</div>
	';
			if ($currentlySelectedProjectTypeIndex == 2) {
				echo '<div id="2_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();">'.$currentlySelectedProjectName.'<img alt="" src="/images/navigation/left-nav-arrow-green.gif"></div>';
			} else {
				echo '<div id="2_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();">'.$currentlySelectedProjectName.'</div>';
			}
	echo '
			<ul class="categoryitems">
	';
			foreach ($arrCompletedProjects AS $project_id => $projectName) {
				if ($currentlySelectedProjectId != $project_id) {
					$encodedProjectName = rawurlencode($projectName);
					echo '<li onclick="navigationProjectSelected(2, \''.$project_id.'\', \'' . $encodedProjectName . '\');"><a href="javascript:void(0);">'.substr($projectName,0,27).'</a></li>';
				}
			}
	echo '
			</ul>
	';
}

if (count($arrOtherProjects) > 0) {
	echo '
			<div class="menuheader expandable">Other Projects</div>
	';
			if ($currentlySelectedProjectTypeIndex == 3) {
				echo '<div id="3_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();">'.$currentlySelectedProjectName.'</div>';
			} else {
				echo '<div id="3_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();">'.$currentlySelectedProjectName.'</div>';
			}
	echo '
			<ul class="categoryitems">
	';
			foreach ($arrOtherProjects AS $project_id => $projectName) {
				if ($currentlySelectedProjectId != $project_id) {
					$encodedProjectName = rawurlencode($projectName);
					echo '<li onclick="navigationProjectSelected(3, \''.$project_id.'\', \'' . $encodedProjectName . '\');"><a href="javascript:void(0);">'.substr($projectName,0,20).'</a></li>';
				}
			}
	echo '
			</ul>
	';
}
echo'
	</div>
</div>
<div class="leftNavSpacer">&nbsp;</div>
';
}
