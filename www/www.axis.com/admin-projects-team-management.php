<?php
/**
 * Project Team Management.
 *
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');
/* @var $session Session */
$session = Zend_Registry::get('session');
$userRole = $session->getUserRole();

// Permissions
require_once('app/models/permission_mdl.php');
$userCanViewTeamMembers = checkPermissionForAllModuleAndRole($database,'admin_projects_team_members_view');
$userCanManageTeamMembers = checkPermissionForAllModuleAndRole($database,'admin_projects_team_members_manage');
$userCanManageTeamMemberPermissionsView = checkPermissionForAllModuleAndRole($database,'admin_projects_team_members_permissions_view');
$userCanManageTeamMemberPermissionsManage = checkPermissionForAllModuleAndRole($database,'admin_projects_team_members_permissions_manage');

if($userRole =="global_admin")
{
	$userCanViewTeamMembers = $userCanManageTeamMembers = $userCanManageTeamMemberPermissionsView = $userCanManageTeamMemberPermissionsManage= 1;
}

// @todo Remove this hard-coded permission
$userCanUpdateTeamMembersContactInfo = true;



$message = Message::getInstance();
/* @var $message Message */

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

ob_start();
if ($userCanManageTeamMemberPermissionsView || $userCanManageTeamMemberPermissionsManage) {

	$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();

	$tmpHtml = <<<END_HTML_CONTENT

		<table width="100%">
			<tr>
				<td style="text-align: right; padding-right: 10px;">
				<input type="hidden" id="unique_team_mem" value="1">
					<a href="javascript:loadPermissionModal('5_Y', '$currentlySelectedProjectId');">Team Member Permissions</a>
				</td>
			</tr>
		</table>
END_HTML_CONTENT;

	echo $tmpHtml;

}

if ($userCanManageTeamMembers) {

	// @todo Refactor these to come from View objects
	$javaScriptHandler = 'teamManagement';
	include('page-components/contact_search_by_contact_company_name_or_contact_name.php');

	$tab = '1';

	if (isset($get) && !empty($get)) {
		if (!empty($get->tab)) {
			$tab = (string) $get->tab;
		}
	}

	$tabContent = '';
	$teamSelected = '';
	$subcontractorsSelected = '';
	$biddersSelected = '';

	switch ($tab) {
		case '1':		
			$teamSelected = 'activeTabGreen';
			break;
		case '2':		
			$subcontractorsSelected = 'activeTabGreen';
			break;
		case '3':		
			$biddersSelected = 'activeTabGreen';
			break;	
		default:	
			$teamSelected = 'activeTabGreen';
			$tab = '1';
			break;
	}

	$template->assign('activeTab', $tab);
	$template->assign('tabContent', $tabContent);
	$template->assign('teamSelected', $teamSelected);
	$template->assign('subcontractorsSelected', $subcontractorsSelected);

	$tmpHtml = <<<END_HTML_CONTENT

		<table class="permissionTable table-team-members">
			<tr>
				<th class="permissionTableMainHeader">Add New Team Members</th>
			</tr>
			<tr>
				<td>
					<table class="table-contact-roles" width="100%">
						<tr>
							<td id="teamManagement" class="contact-search-parent-container">
								$contact_search_form_by_contact_company_name_or_contact_name_html
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div class="divTabs">
			<ul>
				<li><a id="teamTab" class="tab $teamSelected" onclick="tabClickedteam(this, '1');">Team</a></li>
				<li><a id="subcontractorsTab" class="tab $subcontractorsSelected" onclick="tabClickedteam(this, '2');">Subcontractors</a></li>
				<li><a id="biddersTab" class="tab $biddersSelected" onclick="tabClickedteam(this, '3');">Bidders</a></li>		
			</ul>
		</div>
		<input type="hidden" id="activeTab" value="$tab">
END_HTML_CONTENT;

	echo $tmpHtml;

}


if ($userCanViewTeamMembers || $userRole =="global_admin") {
	echo '<div id="divProjectContactList"></div>';
	echo '<div id="divPermissionModal" title="'.$session->getCurrentlySelectedProjectName() . ' Team Permissions"></div>';
}else
{
	
	$errorMessage = 'Permission denied.';
    $message->enqueueError($errorMessage, $currentPhpScript);
	$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
	 if ( !empty($htmlMessages) )
  	echo "<div>$htmlMessages</div>";
  

}
$htmlContent = ob_get_clean();

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link rel="stylesheet" href="/css/modules-permissions.css">
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}

$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY

	<script src="/js/generated/contacts-js.js"></script>
	<script src="/js/modules-contacts-manager-common.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Project Team Management - MyFulcrum.com';
$htmlBody = '';


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');
exit;
