<?php
/**
 * Projects admin - team members.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['get_required'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
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

require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/Role.php');
//require_once('lib/common/UserInvitation.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// INSERT FUNCTION PERMISSIONS HERE
require_once('app/models/permission_mdl.php');
$userCanManageTeamMembers = checkPermissionForAllModuleAndRole($database,'admin_projects_team_members_manage');
$userCanUpdateTeamMembersContactInfo = true;

$session = Zend_Registry::get('session');
$userRole = $session->getUserRole();
if($userRole =="global_admin")
{
	$userCanManageTeamMembers = 1;
}

$db = DBI::getInstance($database);

/* @var $session Session */
// Set some variables
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();

if (isset($get->project_id) && !empty($get->project_id)) {
	$currentlySelectedProjectId = $get->project_id;
}

$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_USER_ROLE_ID_SUBCONTRACTOR = AXIS_USER_ROLE_ID_SUBCONTRACTOR;
$AXIS_USER_ROLE_ID_BIDDER = AXIS_USER_ROLE_ID_BIDDER;

if ($currentlySelectedProjectId == $AXIS_NON_EXISTENT_PROJECT_ID) {
	echo "You Have No Projects To Manage";
	exit;
}

// Start output buffering to prevent output from being echo'd out
ob_start();

switch ($methodCall) {
	case 'loadProjectTeamMembers':

		$new_sort_by = $get->newSort;
		$previous_sort_by = $get->prevSort;

		if ($new_sort_by == $previous_sort_by) {
			$temp = explode(',', $new_sort_by);
			$firstSortParts = explode(' ', $temp[0]);
			if ($firstSortParts[1] == 'ASC') {
				$newDirection = 'DESC';
			} else {
				$newDirection = 'ASC';
			}
			$newSortValue = $firstSortParts[0] . ' ' . $newDirection;
			$new_sort_by = str_replace($temp[0], $newSortValue, $new_sort_by);
		}

		$message->enqueueError('|Project Contact List Could Not Be Loaded!', $currentPhpScript);

		// Contact Roles (role_id > 3)
		// Get list of roles that can be modified (role_id > 3)
		// WHERE r.`id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN, $AXIS_USER_ROLE_ID_ADMIN, $AXIS_USER_ROLE_ID_USER)
		$arrAllRoles = Role::loadAllRoles($database);

		// Load all Project Roles (less User)
		// Use the role_alias values for "Project Roles"
		// Skip the "User" role
		$loadRolesByRoleGroupOptions = new Input();
		$loadRolesByRoleGroupOptions->role_group = 'project_roles';
		$loadRolesByRoleGroupOptions->useRoleAliasesFlag = true;
		$loadRolesByRoleGroupOptions->skipUserRoleFlag = true;
		$arrProjectRoles = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);

		// Get a list of contacts associated with this project by role via projects_to_contacts_to_roles
		$project_id = (int) $currentlySelectedProjectId;
		$orderBy = $new_sort_by;

		$arrContactsWithRolesByProjectId = ProjectToContactToRole::loadContactsWithRolesByProjectId($database, $project_id, $orderBy, true);


		$colspanCount = 4;
		if ($userCanManageTeamMembers) {
			$colspanCount = 6;
		}

		if (count($arrContactsWithRolesByProjectId) > 0) {
			echo '
				<input id="hiddenSortBy" type="hidden" value="'.$new_sort_by.'">
				<table class="permissionTable table-team-members">
					<tr>
						<th class="permissionTableMainHeader" colspan="'.$colspanCount.'">'.$currentlySelectedProjectName.' Team Members</th>
					</tr>
					<tr>
			';

			if ($userCanManageTeamMembers) {
				echo '
						<th>&nbsp;</th>
				';
			}

			echo '
						<th class="clickable" onclick="loadProjectContactList(\'`company` ASC, `first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Company</th>
						<th class="clickable" onclick="loadProjectContactList(\'`first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Team Member</th>
						<th class="clickable" onclick="loadProjectContactList(\'`email` ASC\', \''.$new_sort_by.'\');">Email</th>
						<th class="clickable" onclick="loadProjectContactList(\'`role_id` ASC, `company`, `first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Project Roles</th>
			';

			if ($userCanManageTeamMembers) {
				echo '
						<th class="clickable" onclick="loadProjectContactList(\'`user_id` DESC, `company`, `first_name`, `last_name`\', \''.$new_sort_by.'\');">User Status</th>
				';
			}
			echo '
					</tr>
			';

			foreach ($arrContactsWithRolesByProjectId AS $contact_id => $contact) {
				/* @var $contact Contact */

				$contact->htmlEntityEscapeProperties();

				$contactCompany = $contact->getContactCompany();
				/* @var $contactCompany ContactCompany */

				$userInvitation = $contact->getUserInvitation();
				/* @var $userInvitation UserInvitation */

				if ($userInvitation) {
					$invitationDate = $userInvitation->created;
				} else {
					$invitationDate = '';
				}

				$arrRoleIdsByProjectId = $contact->getArrRoleIdsByProjectId();
				$arrContactRolesByProject = $arrRoleIdsByProjectId[$currentlySelectedProjectId];

				$contact_user_id = $contact->user_id;

				$company = $contactCompany->contact_company_name;
				$encodedCompanyName = Data::entity_encode($company);

				$contactFullName = $contact->getContactFullName();
				$encodedContactFullName = Data::entity_encode($contactFullName);

				$email = $contact->email;
				$escaped_email = $contact->escaped_email;
				$encodedEmail = Data::entity_encode($email);

				echo '
					<tr id="projectListRow_'.$contact_id.'" valign="top">
				';

				if ($userCanManageTeamMembers) {
					echo '
						<td nowrap><a class="smallerFont" href="javascript:removeContactFromProject(\''.$contact_id.'\');" rel="tooltip" title="Remove contact from project">X</a></td>
					';
				}

				echo '
						<td nowrap>'.$encodedCompanyName.'</td>
						<td nowrap>'.$encodedContactFullName.'</td>
						<td nowrap>
				';

				if ($userCanManageTeamMembers) {

					$htmlContent = <<<END_HTML_CONTENT
<input id="manage-contact-record--contacts--email--$contact_id" onchange="Contacts_Manager__Common__updateContact(this);" style="width: 200px;" value="$escaped_email">
END_HTML_CONTENT;
					echo $htmlContent;

				} else {
					echo $email;
				}
				echo '
						</td>
						<td nowrap>
				';
				if ($userCanManageTeamMembers) {
					echo'
							<select id="ddlRole_'.$contact_id.'">
								<option value="0">Select Role To Add To Contact</option>
					';
						foreach ($arrProjectRoles AS $role_id => $role) {
							/* @var $role Role */
							$encodedRoleName = Data::entity_encode($role->role);
							echo '
								<option value="'.$role_id.'">'.$encodedRoleName.'</option>
							';
						}
					echo '
							</select>
							<input id="btnAdd_'.$contact_id.'" type="button" value="Add" onclick="addRoleToContact(\''.$contact_id.'\');">
							<br>
					';
				}

				echo '
							<table id="tblContactRoles_'.$contact_id.'" width="100%" border="0" class="table-contact-roles">
				';
				$roleCounter = 0;
				foreach ($arrContactRolesByProject AS $role_id => $contact_role_id) {
					$role = $arrAllRoles[$role_id];
					$encodedRoleName = Data::entity_encode($role->role);
					echo '
							<tr id="contactRoleRow_'.$contact_id.'">
					';

								if ($role_id == $AXIS_USER_ROLE_ID_USER) {
									if ($userCanManageTeamMembers) {
										echo '
											<td width="20">&nbsp;</td>
										';
									}
									echo '
										<td>User</td>
									';
								} else {
									if ($userCanManageTeamMembers) {
										echo '
											<td id="td_'.$contact_id.'_'.$role_id.'" nowrap style="text-align: center;" width="35">
												<a class="smallerFont" href="javascript:removeRoleFromContactOnProject(\''.$contact_id.'\', \''.$role_id.'\');" rel="tooltip" title="Remove role from contact">X</a>
											</td>
										';
									}
									echo '
										<td>'.$encodedRoleName.'</td>
									';
								}
					echo '
							</tr>
					';
					$roleCounter ++;
				}
				echo '
							</table>
						</td>
				';

				if ($userCanManageTeamMembers) {
					echo '
						<td>
					';
					if (($contact_user_id > 0) && ($contact_user_id <> $AXIS_NON_EXISTENT_USER_ID)) {
						echo 'Registered';
					} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) < 2) {
						echo '<span title="Email Required To Send Invitation To Use The Fulcrum Website!">&nbsp;No Email</span>';
					} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) > 1) {
						if (strlen($invitationDate) > 1) {
							echo '<input id="contactInvite_'.$contact_id.'" name="inviteCheckbox" type="checkbox" value="'.$contact_id.'" title="Invitation Previously Sent: '.$invitationDate.'">&nbsp;Invited';
						} else {
							echo '<input id="contactInvite_'.$contact_id.'" name="inviteCheckbox" type="checkbox" value="'.$contact_id.'">';
						}
					} else {
						echo '&nbsp;';
					}

					echo '
						</td>
					';
				}

				echo '
					</tr>
				';
			}

			if ($userCanManageTeamMembers) {
				echo '
						<tr>
							<td colspan="5">&nbsp;</td>
							<td>
								<input id="btnSendInvites" type="button" value="Send Invitation(s)" onclick="processUserInvitations();">
							</td>
						</tr>
				';
			}

			echo '
				</table>
			';
		} else {
			echo '<input id="hiddenSortBy" type="hidden" value="'.$new_sort_by.'">';
			echo "No Contacts Exist For This Project";
		}

		break;

	case 'loadProjectContactList':

		$new_sort_by = $get->newSort;
		$previous_sort_by = $get->prevSort;

		if ($new_sort_by == $previous_sort_by) {
			$temp = explode(',', $new_sort_by);
			$firstSortParts = explode(' ', $temp[0]);
			if ($firstSortParts[1] == 'ASC') {
				$newDirection = 'DESC';
			} else {
				$newDirection = 'ASC';
			}
			$newSortValue = $firstSortParts[0] . ' ' . $newDirection;
			$new_sort_by = str_replace($temp[0], $newSortValue, $new_sort_by);
		}

		$message->enqueueError('|Project Contact List Could Not Be Loaded!', $currentPhpScript);

		// Contact Roles (role_id > 3)
		// Get list of roles that can be modified (role_id > 3)
		// WHERE r.`id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN, $AXIS_USER_ROLE_ID_ADMIN, $AXIS_USER_ROLE_ID_USER)
		$arrAllRoles = Role::loadAllRoles($database);

		// Load all Project Roles (less User)
		// Use the role_alias values for "Project Roles"
		// Skip the "User" role
		$loadRolesByRoleGroupOptions = new Input();
		$loadRolesByRoleGroupOptions->role_group = 'project_roles';
		$loadRolesByRoleGroupOptions->useRoleAliasesFlag = true;
		$loadRolesByRoleGroupOptions->skipUserRoleFlag = true;
		$arrProjectRoles = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);

		// Get a list of contacts associated with this project by role via projects_to_contacts_to_roles
		$project_id = (int) $currentlySelectedProjectId;
		$orderBy = $new_sort_by;

		$arrContactsWithRolesByProjectId = ProjectToContactToRole::loadContactsWithRolesByProjectId($database, $project_id, $orderBy);

		$colspanCount = 4;
		if ($userCanManageTeamMembers) {
			$colspanCount = 6;
		}

		if (count($arrContactsWithRolesByProjectId) > 0) {
			echo '
				<input id="hiddenSortBy" type="hidden" value="'.$new_sort_by.'">
				<table class="permissionTable table-team-members">
					<tr>
						<th class="permissionTableMainHeader" colspan="'.$colspanCount.'">'.$currentlySelectedProjectName.' Team Members</th>
					</tr>
					<tr>
			';

			if ($userCanManageTeamMembers) {
				echo '
						<th>&nbsp;</th>
				';
			}

			echo '
						<th class="clickable" onclick="loadProjectContactList(\'`company` ASC, `first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Company</th>
						<th class="clickable" onclick="loadProjectContactList(\'`first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Name</th>
						<th class="clickable" onclick="loadProjectContactList(\'`email` ASC\', \''.$new_sort_by.'\');">Email</th>
						<th class="clickable" onclick="loadProjectContactList(\'`role_id` ASC, `company`, `first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Roles</th>
			';

			if ($userCanManageTeamMembers) {
				echo '
						<th class="clickable" onclick="loadProjectContactList(\'`user_id` DESC, `company`, `first_name`, `last_name`\', \''.$new_sort_by.'\');">User Status</th>
				';
			}
			echo '
					</tr>
			';

			foreach ($arrContactsWithRolesByProjectId AS $contact_id => $contact) {
				/* @var $contact Contact */

				$contact->htmlEntityEscapeProperties();

				$contactCompany = $contact->getContactCompany();
				/* @var $contactCompany ContactCompany */

				$userInvitation = $contact->getUserInvitation();
				/* @var $userInvitation UserInvitation */

				if ($userInvitation) {
					$invitationDate = $userInvitation->created;
				} else {
					$invitationDate = '';
				}

				$arrRoleIdsByProjectId = $contact->getArrRoleIdsByProjectId();
				$arrContactRolesByProject = $arrRoleIdsByProjectId[$currentlySelectedProjectId];

				$contact_user_id = $contact->user_id;

				$company = $contactCompany->contact_company_name;
				$encodedCompanyName = Data::entity_encode($company);

				$contactFullName = $contact->getContactFullName();
				$encodedContactFullName = Data::entity_encode($contactFullName);

				$email = $contact->email;
				$escaped_email = $contact->escaped_email;
				$encodedEmail = Data::entity_encode($email);

				echo '
					<tr id="projectListRow_'.$contact_id.'" valign="top">
				';

				if ($userCanManageTeamMembers) {
					echo '
						<td nowrap><a class="smallerFont" href="javascript:removeContactFromProject(\''.$contact_id.'\');" rel="tooltip" title="Remove contact from project">X</a></td>
					';
				}

				echo '
						<td nowrap>'.$company.'</td>
						<td nowrap>'.$contactFullName.'</td>
						<td nowrap>
				';

				if ($userCanManageTeamMembers) {

					$htmlContent = <<<END_HTML_CONTENT
<input id="manage-contact-record--contacts--email--$contact_id" onchange="Contacts_Manager__Common__updateContact(this);" style="width: 200px;" value="$escaped_email">
END_HTML_CONTENT;
					echo $htmlContent;

				} else {
					echo $email;
				}
				echo '
						</td>
						<td nowrap>
				';
				if ($userCanManageTeamMembers) {
					echo'
							<select id="ddlRole_'.$contact_id.'">
								<option value="0">Select Role To Add To Contact</option>
					';
						foreach ($arrProjectRoles AS $role_id => $role) {
							/* @var $role Role */
							$encodedRoleName = Data::entity_encode($role->role);
							echo '
								<option value="'.$role_id.'">'.$encodedRoleName.'</option>
							';
						}
					echo '
							</select>
							<input id="btnAdd_'.$contact_id.'" type="button" value="Add" onclick="addRoleToContact(\''.$contact_id.'\');">
							<br>
					';
				}

				echo '
							<table id="tblContactRoles_'.$contact_id.'" width="100%" border="0" class="table-contact-roles">
				';
				$roleCounter = 0;
				foreach ($arrContactRolesByProject AS $role_id => $contact_role_id) {
					if ($role_id == 3) {
						continue;
					}
					$role = $arrAllRoles[$role_id];
					$encodedRoleName = Data::entity_encode($role->role);
					echo '
							<tr id="contactRoleRow_'.$contact_id.'">
					';

								if ($role_id == $AXIS_USER_ROLE_ID_USER) {
									if ($userCanManageTeamMembers) {
										echo '
											<td width="20">&nbsp;</td>
										';
									}
									echo '
										<td>User</td>
									';
								} else {
									if ($userCanManageTeamMembers) {
										echo '
											<td id="td_'.$contact_id.'_'.$role_id.'" nowrap style="text-align: center;" width="35">
												<a class="smallerFont" href="javascript:removeRoleFromContactOnProject(\''.$contact_id.'\', \''.$role_id.'\');" rel="tooltip" title="Remove role from contact">X</a>
											</td>
										';
									}
									echo '
										<td>'.$encodedRoleName.'</td>
									';
								}
					echo '
							</tr>
					';
					$roleCounter ++;
				}
				echo '
							</table>
						</td>
				';

				if ($userCanManageTeamMembers) {
					echo '
						<td>
					';
					if (($contact_user_id > 0) && ($contact_user_id <> $AXIS_NON_EXISTENT_USER_ID)) {
						echo 'Registered User';
					} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) < 2) {
						echo '<span title="Email Required To Send Invitation To Use The Fulcrum Website!">&nbsp;No Email</span>';
					} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) > 1) {
						if (strlen($invitationDate) > 1) {
							echo '<input id="contactInvite_'.$contact_id.'" name="inviteCheckbox" type="checkbox" value="'.$contact_id.'" title="Invitation Previously Sent: '.$invitationDate.'"> Invited To Join';
						} else {
							echo '<input id="contactInvite_'.$contact_id.'" name="inviteCheckbox" type="checkbox" value="'.$contact_id.'"> Send Invitation To Join';
						}
					} else {
						echo '&nbsp;';
					}

					echo '
						</td>
					';
				}

				echo '
					</tr>
				';
			}

			if ($userCanManageTeamMembers) {
				echo '
						<tr>
							<td colspan="5">&nbsp;</td>
							<td>
								<input id="btnSendInvites" type="button" value="Send Invitation(s)" onclick="processUserInvitations();">
							</td>
						</tr>
				';
			}

			echo '
				</table>
			';
		} else {
			echo '<input id="hiddenSortBy" type="hidden" value="'.$new_sort_by.'">';
			echo "No Contacts Exist For This Project";
		}

		break;

	case 'loadProjectContactListforteam':

		$new_sort_by = $get->newSort;
		$previous_sort_by = $get->prevSort;

		if ($new_sort_by == $previous_sort_by) {
			$temp = explode(',', $new_sort_by);
			$firstSortParts = explode(' ', $temp[0]);
			if ($firstSortParts[1] == 'ASC') {
				$newDirection = 'DESC';
			} else {
				$newDirection = 'ASC';
			}
			$newSortValue = $firstSortParts[0] . ' ' . $newDirection;
			$new_sort_by = str_replace($temp[0], $newSortValue, $new_sort_by);
		}

		$message->enqueueError('|Project Contact List Could Not Be Loaded!', $currentPhpScript);

		// Contact Roles (role_id > 3)
		// Get list of roles that can be modified (role_id > 3)
		// WHERE r.`id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN, $AXIS_USER_ROLE_ID_ADMIN, $AXIS_USER_ROLE_ID_USER)
		$arrAllRoles = Role::loadAllRoles($database);

		// Load all Project Roles (less User)
		// Use the role_alias values for "Project Roles"
		// Skip the "User" role
		$loadRolesByRoleGroupOptions = new Input();
		$loadRolesByRoleGroupOptions->role_group = 'project_roles';
		$loadRolesByRoleGroupOptions->useRoleAliasesFlag = true;
		$loadRolesByRoleGroupOptions->skipUserRoleFlag = true;
		$arrProjectRoles = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);
		unset($arrProjectRoles[$AXIS_USER_ROLE_ID_SUBCONTRACTOR]);
		unset($arrProjectRoles[$AXIS_USER_ROLE_ID_BIDDER]);

		// Get a list of contacts associated with this project by role via projects_to_contacts_to_roles
		$project_id = (int) $currentlySelectedProjectId;
		$orderBy = $new_sort_by;

		$arrContactsWithRolesByProjectId = ProjectToContactToRole::loadContactsWithRolesByProjectIdforteam($database, $project_id, $orderBy);

		$colspanCount = 4;
		if ($userCanManageTeamMembers) {
			$colspanCount = 6;
		}

		if (count($arrContactsWithRolesByProjectId) > 0 || count($arrContactsWithRolesByProjectId) == 0) {
			echo '
				<input id="hiddenSortBy" type="hidden" value="'.$new_sort_by.'">
				<table class="permissionTable table-team-members">
					<tr>
						<th class="permissionTableMainHeader" colspan="'.$colspanCount.'">'.$currentlySelectedProjectName.' Team Members</th>
					</tr>
					<tr>
			';

			if ($userCanManageTeamMembers) {
				echo '
						<th>&nbsp;</th>
				';
			}

			echo '
						<th class="clickable" onclick="loadProjectContactList(\'`company` ASC, `first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Company</th>
						<th class="clickable" onclick="loadProjectContactList(\'`first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Name</th>
						<th class="clickable" onclick="loadProjectContactList(\'`email` ASC\', \''.$new_sort_by.'\');">Email</th>
						<th class="clickable" onclick="loadProjectContactList(\'`role_id` ASC, `company`, `first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Roles</th>
			';

			if ($userCanManageTeamMembers) {
				echo '
						<th class="clickable" onclick="loadProjectContactList(\'`user_id` DESC, `company`, `first_name`, `last_name`\', \''.$new_sort_by.'\');">User Status</th>
				';
			}
			echo '
					</tr>
			';

			$notInListArray = array();
			$notInListArrayIf = array();
			$notInList="";

			foreach ($arrContactsWithRolesByProjectId AS $contact_id => $contact) {
				/* @var $contact Contact */

				$contact->htmlEntityEscapeProperties();

				$contactCompany = $contact->getContactCompany();
				/* @var $contactCompany ContactCompany */

				$userInvitation = $contact->getUserInvitation();
				/* @var $userInvitation UserInvitation */

				if ($userInvitation) {
					$invitationDate = $userInvitation->created;
				} else {
					$invitationDate = '';
				}

				$arrRoleIdsByProjectId = $contact->getArrRoleIdsByProjectId();
				$arrContactRolesByProject = $arrRoleIdsByProjectId[$currentlySelectedProjectId];

				if ( (in_array($AXIS_USER_ROLE_ID_BIDDER, $arrContactRolesByProject) && in_array($AXIS_USER_ROLE_ID_USER, $arrContactRolesByProject) && count($arrContactRolesByProject) == 2) || (in_array($AXIS_USER_ROLE_ID_SUBCONTRACTOR, $arrContactRolesByProject) && in_array($AXIS_USER_ROLE_ID_USER, $arrContactRolesByProject) && count($arrContactRolesByProject) == 2) || (in_array($AXIS_USER_ROLE_ID_SUBCONTRACTOR, $arrContactRolesByProject) && in_array($AXIS_USER_ROLE_ID_USER, $arrContactRolesByProject) && in_array($AXIS_USER_ROLE_ID_BIDDER, $arrContactRolesByProject)  && count($arrContactRolesByProject) == 3)) {
				    $notInList = $contact_id;
				}

				$contact_user_id = $contact->user_id;

				$company = $contactCompany->contact_company_name;
				$encodedCompanyName = Data::entity_encode($company);

				$contactFullName = $contact->getContactFullName();
				$encodedContactFullName = Data::entity_encode($contactFullName);

				$email = $contact->email;
				$escaped_email = $contact->escaped_email;
				$encodedEmail = Data::entity_encode($email);
				if ($notInList != $contact_id) {	

					$notInListArrayIf = array_push($notInListArray,'Y');

				echo '
					<tr id="projectListRow_'.$contact_id.'" valign="top">
				';


				if ($userCanManageTeamMembers) {
					echo '
						<td nowrap><a class="smallerFont" href="javascript:removeContactFromProject(\''.$contact_id.'\');" rel="tooltip" title="Remove contact from project">X</a></td>
					';
				}

				echo '
						<td nowrap>'.$company.'</td>
						<td nowrap>'.$contactFullName.'</td>
						<td nowrap>
				';
				

				if ($userCanManageTeamMembers) {

					$htmlContent = <<<END_HTML_CONTENT
<input id="manage-contact-record--contacts--email--$contact_id" onchange="Contacts_Manager__Common__updateContact(this);" style="width: 200px;" value="$escaped_email">
END_HTML_CONTENT;
					echo $htmlContent;

				} else {
					echo $email;
				}
				echo '
						</td>
						<td nowrap>
				';

				if ($userCanManageTeamMembers) {
					echo'
							<select id="ddlRole_'.$contact_id.'">
								<option value="0">Select Role To Add To Contact</option>
					';					
						foreach ($arrProjectRoles AS $role_id => $role) {
							
							/* @var $role Role */
							$encodedRoleName = Data::entity_encode($role->role);
							echo '
								<option value="'.$role_id.'">'.$encodedRoleName.'</option>
							';
						}
					echo '
							</select>
							<input id="btnAdd_'.$contact_id.'" type="button" value="Add" onclick="addRoleToContact(\''.$contact_id.'\');">
							<br>
					';
				}

				echo '
							<table id="tblContactRoles_'.$contact_id.'" width="100%" border="0" class="table-contact-roles">
				';
				$roleCounter = 0;
				unset($arrContactRolesByProject[$AXIS_USER_ROLE_ID_SUBCONTRACTOR]);
				unset($arrContactRolesByProject[$AXIS_USER_ROLE_ID_BIDDER]);
				foreach ($arrContactRolesByProject AS $role_id => $contact_role_id) {					
					if ($role_id == 3) {
						continue;
					}
					$role = $arrAllRoles[$role_id];
					$encodedRoleName = Data::entity_encode($role->role);
					echo '
							<tr id="contactRoleRow_'.$contact_id.'">
					';

								if ($role_id == $AXIS_USER_ROLE_ID_USER) {
									if ($userCanManageTeamMembers) {
										echo '
											<td width="20">&nbsp;</td>
										';
									}
									echo '
										<td>User</td>
									';
								} else {
									if ($userCanManageTeamMembers) {
										echo '
											<td id="td_'.$contact_id.'_'.$role_id.'" nowrap style="text-align: center;" width="35">
												<a class="smallerFont" href="javascript:removeRoleFromContactOnProject(\''.$contact_id.'\', \''.$role_id.'\');" rel="tooltip" title="Remove role from contact">X</a>
											</td>
										';
									}
									echo '
										<td>'.$encodedRoleName.'</td>
									';
								}
					echo '
							</tr>
					';
					$roleCounter ++;
				}
				echo '
							</table>
						</td>
				';

				if ($userCanManageTeamMembers) {
					echo '
						<td>
					';
					if (($contact_user_id > 0) && ($contact_user_id <> $AXIS_NON_EXISTENT_USER_ID)) {
						echo 'Registered User';
					} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) < 2) {
						echo '<span title="Email Required To Send Invitation To Use The Fulcrum Website!">&nbsp;No Email</span>';
					} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) > 1) {
						if (strlen($invitationDate) > 1) {
							echo '<input id="contactInvite_'.$contact_id.'" name="inviteCheckbox" type="checkbox" value="'.$contact_id.'" title="Invitation Previously Sent: '.$invitationDate.'"> Invited To Join';
						} else {
							echo '<input id="contactInvite_'.$contact_id.'" name="inviteCheckbox" type="checkbox" value="'.$contact_id.'"> Send Invitation To Join';
						}
					} else {
						echo '&nbsp;';
					}

					echo '
						</td>
					';
				}

				echo '
					</tr>
				';
			}else{
				$notInListArrayIf = array_push($notInListArray, 'N');
			}
			}

			$arrayCount = array_count_values($notInListArray);

			$arrayCountYes = $arrayCount['Y'];
			$arrayCountNo = $arrayCount['N'];

			if ($arrayCountYes == '' || $arrayCountYes == 0) {
				echo "<tr><td colspan='6' style='text-align:center'>No Contacts Exist For This Project</td></tr>";
			}else{
				if ($userCanManageTeamMembers) {
					echo '
							<tr>
								<td colspan="5">&nbsp;</td>
								<td>
									<input id="btnSendInvites" type="button" value="Send Invitation(s)" onclick="processUserInvitations();">
								</td>
							</tr>
					';
				}
			}			

			
		} else {
			echo '<input id="hiddenSortBy" type="hidden" value="'.$new_sort_by.'">';
			echo "<tr><td colspan='6' style='text-align:center'>No Contacts Exist For This Project</td></tr>";
		}
		echo '
			</table>
		';

		break;

	case 'loadProjectContactListforsubcontractor':

		$new_sort_by = $get->newSort;
		$previous_sort_by = $get->prevSort;

		if ($new_sort_by == $previous_sort_by) {
			$temp = explode(',', $new_sort_by);
			$firstSortParts = explode(' ', $temp[0]);
			if ($firstSortParts[1] == 'ASC') {
				$newDirection = 'DESC';
			} else {
				$newDirection = 'ASC';
			}
			$newSortValue = $firstSortParts[0] . ' ' . $newDirection;
			$new_sort_by = str_replace($temp[0], $newSortValue, $new_sort_by);
		}

		$message->enqueueError('|Project Contact List Could Not Be Loaded!', $currentPhpScript);

		// Contact Roles (role_id > 3)
		// Get list of roles that can be modified (role_id > 3)
		// WHERE r.`id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN, $AXIS_USER_ROLE_ID_ADMIN, $AXIS_USER_ROLE_ID_USER)
		$arrAllRoles = Role::loadAllRoles($database);

		// Load all Project Roles (less User)
		// Use the role_alias values for "Project Roles"
		// Skip the "User" role
		$loadRolesByRoleGroupOptions = new Input();
		$loadRolesByRoleGroupOptions->role_group = 'project_roles';
		$loadRolesByRoleGroupOptions->useRoleAliasesFlag = true;
		$loadRolesByRoleGroupOptions->skipUserRoleFlag = true;
		$arrProjectRoles = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);

		// Get a list of contacts associated with this project by role via projects_to_contacts_to_roles
		$project_id = (int) $currentlySelectedProjectId;
		$orderBy = $new_sort_by;

		$arrContactsWithRolesByProjectId = ProjectToContactToRole::loadContactsWithRolesByProjectIdforsubcontractor($database, $project_id, $orderBy);

		$colspanCount = 4;
		if ($userCanManageTeamMembers) {
			$colspanCount = 6;
		}

		
			echo '
				<input id="hiddenSortBy" type="hidden" value="'.$new_sort_by.'">
				<table class="permissionTable table-team-members">
					<tr>
						<th class="permissionTableMainHeader" colspan="'.$colspanCount.'">'.$currentlySelectedProjectName.' Team Members</th>
					</tr>
					<tr>
			';

			if ($userCanManageTeamMembers) {
				echo '
						<th>&nbsp;</th>
				';
			}

			echo '
						<th class="clickable" onclick="loadProjectContactList(\'`company` ASC, `first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Company</th>
						<th class="clickable" onclick="loadProjectContactList(\'`first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Name</th>
						<th class="clickable" onclick="loadProjectContactList(\'`email` ASC\', \''.$new_sort_by.'\');">Email</th>
						<th class="clickable" onclick="loadProjectContactList(\'`role_id` ASC, `company`, `first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Role</th>
			';

			if ($userCanManageTeamMembers) {
				echo '
						<th class="clickable" onclick="loadProjectContactList(\'`user_id` DESC, `company`, `first_name`, `last_name`\', \''.$new_sort_by.'\');">User Status</th>
				';
			}
			echo '
					</tr>
			';
		if (count($arrContactsWithRolesByProjectId) > 0) {

			foreach ($arrContactsWithRolesByProjectId AS $contact_id => $contact) {
				/* @var $contact Contact */

				$contact->htmlEntityEscapeProperties();

				$contactCompany = $contact->getContactCompany();
				/* @var $contactCompany ContactCompany */

				$userInvitation = $contact->getUserInvitation();
				/* @var $userInvitation UserInvitation */

				if ($userInvitation) {
					$invitationDate = $userInvitation->created;
				} else {
					$invitationDate = '';
				}

				$arrRoleIdsByProjectId = $contact->getArrRoleIdsByProjectId();
				$arrContactRolesByProject = $arrRoleIdsByProjectId[$currentlySelectedProjectId];

				$contact_user_id = $contact->user_id;

				$company = $contactCompany->contact_company_name;
				$encodedCompanyName = Data::entity_encode($company);

				$contactFullName = $contact->getContactFullName();
				$encodedContactFullName = Data::entity_encode($contactFullName);

				$email = $contact->email;
				$escaped_email = $contact->escaped_email;
				$encodedEmail = Data::entity_encode($email);

				echo '
					<tr id="projectListRow_'.$contact_id.'" valign="top">
				';

				if ($userCanManageTeamMembers) {
					echo '
						<td nowrap><a class="smallerFont" href="javascript:removeRoleFromContactOnProject(\''.$contact_id.'\', \''.$AXIS_USER_ROLE_ID_SUBCONTRACTOR.'\');" rel="tooltip" title="Remove role from contact">X</a></td>
					';
				}

				echo '
						<td nowrap>'.$company.'</td>
						<td nowrap>'.$contactFullName.'</td>
						<td nowrap>
				';

				if ($userCanManageTeamMembers) {

					$htmlContent = <<<END_HTML_CONTENT
<input id="manage-contact-record--contacts--email--$contact_id" onchange="Contacts_Manager__Common__updateContact(this);" style="width: 200px;" value="$escaped_email">
END_HTML_CONTENT;
					echo $htmlContent;

				} else {
					echo $email;
				}
				echo '
						</td>
						<td nowrap>
				';

				echo '
							<table id="tblContactRoles_'.$contact_id.'" width="100%" border="0" class="table-contact-roles">
				';
				$roleCounter = 0;
				foreach ($arrContactRolesByProject AS $role_id => $contact_role_id) {
					if ($role_id == 3) {
						continue;
					}
					$role = $arrAllRoles[$role_id];
					$encodedRoleName = Data::entity_encode($role->role);
					echo '
							<tr id="contactRoleRow_'.$contact_id.'">
					';

								if ($role_id == $AXIS_USER_ROLE_ID_USER) {
									if ($userCanManageTeamMembers) {
										echo '
											<td width="20">&nbsp;</td>
										';
									}
									echo '
										<td>User</td>
									';
								} else {
									echo '
										<td>'.$encodedRoleName.'</td>
									';
								}
					echo '
							</tr>
					';
					$roleCounter ++;
				}
				echo '
							</table>
						</td>
				';

				if ($userCanManageTeamMembers) {
					echo '
						<td>
					';
					if (($contact_user_id > 0) && ($contact_user_id <> $AXIS_NON_EXISTENT_USER_ID)) {
						echo 'Registered User';
					} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) < 2) {
						echo '<span title="Email Required To Send Invitation To Use The Fulcrum Website!">&nbsp;No Email</span>';
					} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) > 1) {
						if (strlen($invitationDate) > 1) {
							echo '<input id="contactInvite_'.$contact_id.'" name="inviteCheckbox" type="checkbox" value="'.$contact_id.'" title="Invitation Previously Sent: '.$invitationDate.'"> Invited To Join';
						} else {
							echo '<input id="contactInvite_'.$contact_id.'" name="inviteCheckbox" type="checkbox" value="'.$contact_id.'"> Send Invitation To Join';
						}
					} else {
						echo '&nbsp;';
					}

					echo '
						</td>
					';
				}

				echo '
					</tr>
				';
			}

			if ($userCanManageTeamMembers) {
				echo '
						<tr>
							<td colspan="5">&nbsp;</td>
							<td>
								<input id="btnSendInvites" type="button" value="Send Invitation(s)" onclick="processUserInvitations();">
							</td>
						</tr>
				';
			}

			
		} else {
			echo '<input id="hiddenSortBy" type="hidden" value="'.$new_sort_by.'">';
			echo "<tr><td colspan='6' style='text-align:center'>No Contacts Exist For This Project</td></tr>";
		}
		echo '
			</table>
		';

		break;

	case 'loadProjectContactListforbidder':

		$new_sort_by = $get->newSort;
		$previous_sort_by = $get->prevSort;

		if ($new_sort_by == $previous_sort_by) {
			$temp = explode(',', $new_sort_by);
			$firstSortParts = explode(' ', $temp[0]);
			if ($firstSortParts[1] == 'ASC') {
				$newDirection = 'DESC';
			} else {
				$newDirection = 'ASC';
			}
			$newSortValue = $firstSortParts[0] . ' ' . $newDirection;
			$new_sort_by = str_replace($temp[0], $newSortValue, $new_sort_by);
		}

		$message->enqueueError('|Project Contact List Could Not Be Loaded!', $currentPhpScript);

		// Contact Roles (role_id > 3)
		// Get list of roles that can be modified (role_id > 3)
		// WHERE r.`id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN, $AXIS_USER_ROLE_ID_ADMIN, $AXIS_USER_ROLE_ID_USER)
		$arrAllRoles = Role::loadAllRoles($database);

		// Load all Project Roles (less User)
		// Use the role_alias values for "Project Roles"
		// Skip the "User" role
		$loadRolesByRoleGroupOptions = new Input();
		$loadRolesByRoleGroupOptions->role_group = 'project_roles';
		$loadRolesByRoleGroupOptions->useRoleAliasesFlag = true;
		$loadRolesByRoleGroupOptions->skipUserRoleFlag = true;
		$arrProjectRoles = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);

		// Get a list of contacts associated with this project by role via projects_to_contacts_to_roles
		$project_id = (int) $currentlySelectedProjectId;
		$orderBy = $new_sort_by;

		$arrContactsWithRolesByProjectId = ProjectToContactToRole::loadContactsWithRolesByProjectIdforbidder($database, $project_id, $orderBy);

		$colspanCount = 4;
		if ($userCanManageTeamMembers) {
			$colspanCount = 6;
		}

		
			echo '
				<input id="hiddenSortBy" type="hidden" value="'.$new_sort_by.'">
				<table class="permissionTable table-team-members">
					<tr>
						<th class="permissionTableMainHeader" colspan="'.$colspanCount.'">'.$currentlySelectedProjectName.' Team Members</th>
					</tr>
					<tr>
			';

			if ($userCanManageTeamMembers) {
				echo '
						<th>&nbsp;</th>
				';
			}

			echo '
						<th class="clickable" onclick="loadProjectContactList(\'`company` ASC, `first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Company</th>
						<th class="clickable" onclick="loadProjectContactList(\'`first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Name</th>
						<th class="clickable" onclick="loadProjectContactList(\'`email` ASC\', \''.$new_sort_by.'\');">Email</th>
						<th class="clickable" onclick="loadProjectContactList(\'`role_id` ASC, `company`, `first_name` ASC, `last_name` ASC\', \''.$new_sort_by.'\');">Role</th>
			';

			if ($userCanManageTeamMembers) {
				echo '
						<th class="clickable" onclick="loadProjectContactList(\'`user_id` DESC, `company`, `first_name`, `last_name`\', \''.$new_sort_by.'\');">User Status</th>
				';
			}
			echo '
					</tr>
			';
		if (count($arrContactsWithRolesByProjectId) > 0) {
			foreach ($arrContactsWithRolesByProjectId AS $contact_id => $contact) {
				/* @var $contact Contact */

				$contact->htmlEntityEscapeProperties();

				$contactCompany = $contact->getContactCompany();
				/* @var $contactCompany ContactCompany */

				$userInvitation = $contact->getUserInvitation();
				/* @var $userInvitation UserInvitation */

				if ($userInvitation) {
					$invitationDate = $userInvitation->created;
				} else {
					$invitationDate = '';
				}

				$arrRoleIdsByProjectId = $contact->getArrRoleIdsByProjectId();
				$arrContactRolesByProject = $arrRoleIdsByProjectId[$currentlySelectedProjectId];

				$contact_user_id = $contact->user_id;

				$company = $contactCompany->contact_company_name;
				$encodedCompanyName = Data::entity_encode($company);

				$contactFullName = $contact->getContactFullName();
				$encodedContactFullName = Data::entity_encode($contactFullName);

				$email = $contact->email;
				$escaped_email = $contact->escaped_email;
				$encodedEmail = Data::entity_encode($email);

				echo '
					<tr id="projectListRow_'.$contact_id.'" valign="top">
				';

				if ($userCanManageTeamMembers) {
					echo '
						<td nowrap><a class="smallerFont" href="javascript:removeRoleFromContactOnProject(\''.$contact_id.'\', \''.$AXIS_USER_ROLE_ID_BIDDER.'\');" rel="tooltip" title="Remove role from contact">X</a>
						</td>
					';
				}

				echo '
						<td nowrap>'.$company.'</td>
						<td nowrap>'.$contactFullName.'</td>
						<td nowrap>
				';

				if ($userCanManageTeamMembers) {

					$htmlContent = <<<END_HTML_CONTENT
<input id="manage-contact-record--contacts--email--$contact_id" onchange="Contacts_Manager__Common__updateContact(this);" style="width: 200px;" value="$escaped_email">
END_HTML_CONTENT;
					echo $htmlContent;

				} else {
					echo $email;
				}
				echo '
						</td>
						<td nowrap>
				';				

				echo '
							<table id="tblContactRoles_'.$contact_id.'" width="100%" border="0" class="table-contact-roles">
				';
				$roleCounter = 0;
				foreach ($arrContactRolesByProject AS $role_id => $contact_role_id) {
					if ($role_id == 3) {
						continue;
					}
					$role = $arrAllRoles[$role_id];
					$encodedRoleName = Data::entity_encode($role->role);
					echo '
							<tr id="contactRoleRow_'.$contact_id.'">
					';

								if ($role_id == $AXIS_USER_ROLE_ID_USER) {
									if ($userCanManageTeamMembers) {
										echo '
											<td width="20">&nbsp;</td>
										';
									}
									echo '
										<td>User</td>
									';
								} else {									
									echo '
										<td>'.$encodedRoleName.'</td>
									';
								}
					echo '
							</tr>
					';
					$roleCounter ++;
				}
				echo '
							</table>
						</td>
				';

				if ($userCanManageTeamMembers) {
					echo '
						<td>
					';
					if (($contact_user_id > 0) && ($contact_user_id <> $AXIS_NON_EXISTENT_USER_ID)) {
						echo 'Registered User';
					} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) < 2) {
						echo '<span title="Email Required To Send Invitation To Use The Fulcrum Website!">&nbsp;No Email</span>';
					} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) > 1) {
						if (strlen($invitationDate) > 1) {
							echo '<input id="contactInvite_'.$contact_id.'" name="inviteCheckbox" type="checkbox" value="'.$contact_id.'" title="Invitation Previously Sent: '.$invitationDate.'"> Invited To Join';
						} else {
							echo '<input id="contactInvite_'.$contact_id.'" name="inviteCheckbox" type="checkbox" value="'.$contact_id.'"> Send Invitation To Join';
						}
					} else {
						echo '&nbsp;';
					}

					echo '
						</td>
					';
				}

				echo '
					</tr>
				';
			}

			if ($userCanManageTeamMembers) {
				echo '
						<tr>
							<td colspan="5">&nbsp;</td>
							<td>
								<input id="btnSendInvites" type="button" value="Send Invitation(s)" onclick="processUserInvitations();">
							</td>
						</tr>
				';
			}
			
		} else {
			echo '<input id="hiddenSortBy" type="hidden" value="'.$new_sort_by.'">';
			echo "<tr><td colspan='6' style='text-align:center'>No Contacts Exist For This Project</td></tr>";
		}
		echo '
			</table>
		';

		break;

	case 'addContactToProject':

		$contact_id = $get->contact_id;
		$tabName = $get->tabName;

		$message->enqueueError('searchContactRow_'.$contact_id.'|Contact Could Not Be Added!', $currentPhpScript);		

		if ($tabName == 'subcontractor') {
			ProjectToContactToRole::addRoleToContactOnProjectExceptTeam($database, $currentlySelectedProjectId, $contact_id, $AXIS_USER_ROLE_ID_SUBCONTRACTOR);
		}else if ($tabName == 'bidder') {
			ProjectToContactToRole::addRoleToContactOnProjectExceptTeam($database, $currentlySelectedProjectId, $contact_id, $AXIS_USER_ROLE_ID_BIDDER);
		}else{
			ProjectToContactToRole::addContactToProject($database, $currentlySelectedProjectId, $contact_id);
		}

		break;

	case 'removeContactFromProject':

		$contact_id = $get->contact_id;

		$message->enqueueError('projectListRow_'.$contact_id.'|Contact Could Not Be Deleted!', $currentPhpScript);

		ProjectToContactToRole::removeContactFromProject($database, $currentlySelectedProjectId, $contact_id);

		break;

	case 'removeRoleFromContactOnProject':

		$contact_id = (int) $get->contact_id;
		$role_id = (int) $get->role_id;

		$message->enqueueError('contactRoleRow_'.$contact_id.'|Role Could Not Be Removed!', $currentPhpScript);
		
		ProjectToContactToRole::removeRoleFromContactOnProject($database, $currentlySelectedProjectId, $contact_id, $role_id);	

		break;

	case 'addRoleToContactOnProject':

		$contact_id = $get->contact_id;
		$role_id = $get->role_id;

		$message->enqueueError('projectListRow_'.$contact_id.'|Role Could Not Be Added To Contact!', $currentPhpScript);

		ProjectToContactToRole::addRoleToContactOnProject($database, $currentlySelectedProjectId, $contact_id, $role_id);

		break;
}

ob_flush();
exit;
