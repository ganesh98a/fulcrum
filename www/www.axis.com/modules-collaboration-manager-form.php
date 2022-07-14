<?php
/**
 * Discussion Management.
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
$message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;
$AXIS_TEMPLATE_PROJECT_ID = AXIS_TEMPLATE_PROJECT_ID;
require_once('app/models/permission_mdl.php');
require_once('./modules-collaboration-manager-functions.php');

// DATABASE VARIABLES
$db = DBI::getInstance($database);

// SESSSION VARIABLES
/* @var $session Session */
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
if(isset($_GET['pID']) && $_GET['pID']!=''){
	$project_id = $currentlySelectedProjectId = base64_decode($_GET['pID']);
}else{
	$project_id = $session->getCurrentlySelectedProjectId();
	$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
}
$primary_contact_id = $session->getPrimaryContactId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
// PERMISSION VARIABLES
$permissions = Zend_Registry::get('permissions');

// Ids for permissions
$primary_contact_id = $session->getPrimaryContactId();
$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

if ( ( $currentlySelectedProjectUserCompanyId == $user_company_id ) && ( $userRole == "admin" ) ) {
	$projectOwnerAdmin = true;
} else {
	$projectOwnerAdmin = false;
}

/*
// MANAGE TEAM MEMBERS
$userCanManageTeamMembers = $permissions->determineAccessToSoftwareModuleFunction('admin_projects_team_members_manage');
*/

// VIEW MEETING
$userCanViewDiscussionItems = checkPermissionForAllModuleAndRole($database,'meetings_view');

// ADD DISCUSSION ITEM
$userCanCreateDiscussionItems = checkPermissionForAllModuleAndRole($database,'meetings_add_discussion_item');

// ADD ACTION ITEM
$userCanCreateActionItems = checkPermissionForAllModuleAndRole($database,'meetings_add_action_item');

// ADD COMMENT
$userCanCreateDiscussionItemComments = checkPermissionForAllModuleAndRole($database,'meetings_add_comment');

//  MANAGE MEETINGS
$userCanManageMeetings = checkPermissionForAllModuleAndRole($database,'meetings_manage');


// SET ACCESS TO MEETING TYPES
$userCanViewMeetingsType1 = checkPermissionForAllModuleAndRole($database,'meetings_type_1');
$userCanViewMeetingsType2 = checkPermissionForAllModuleAndRole($database,'meetings_type_2');
$userCanViewMeetingsType3 = checkPermissionForAllModuleAndRole($database,'meetings_type_3');
$userCanViewMeetingsType4 = checkPermissionForAllModuleAndRole($database,'meetings_type_4');

if($userRole =="global_admin")
{
	$userCanViewDiscussionItems=$userCanCreateDiscussionItems=$userCanCreateActionItems =$userCanCreateDiscussionItemComments=$userCanManageMeetings = $userCanViewMeetingsType1 = $userCanViewMeetingsType2  = $userCanViewMeetingsType3 = $userCanViewMeetingsType4 =1;
}
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

// Meeting Type dropdown.
$arrMeetingTypes = MeetingType::loadMeetingTypesBasedOnPermission($database, $project_id,$userCanViewMeetingsType1,$userCanViewMeetingsType2,$userCanViewMeetingsType3,$userCanViewMeetingsType4);

// @todo Fix Meeting Types and UC Preferences
$default_meeting_type_id = '';
foreach ($arrMeetingTypes as $tmpMeetingType) {
	/* @var $tmpMeetingType MeetingType */
	if ($tmpMeetingType->meeting_type == 'Owner Meeting') {
		$defaultMeetingType = $tmpMeetingType;
		/* @var $defaultMeetingType MeetingType */
		$default_meeting_type_id = $defaultMeetingType->meeting_type_id;
	}
}

$elementId = 'ddl--meeting_types--meeting_type--'.$project_id;
$prependedOption = '<option value="-2">Please Select A Meeting Type</option>';
$ddlMeetingTypes = PageComponents::dropDownListFromObjects('ddl_meeting_type_id', $arrMeetingTypes, 'meeting_type_id', null, 'meeting_type', null, $default_meeting_type_id, '', 'onchange="loadMeetingsByMeetingTypeId();"', $prependedOption);
if (count($arrMeetingTypes) == 0) {
	$ddlMeetingTypes = '<select id="ddl_meeting_type_id"><option value="-2">No Meeting Types Exist</option></select>';
}

$ddlMeetings = '<select id="ddl_meeting_id" disabled="true" onchange="loadMeetingDetails();loadDiscussionItemsByMeetingId();"><option value="">Select A Meeting</option></select>';
$refreshMeetingDetails = '<input id="buttonRefreshMeetingDetails" type="button" value="Refresh Meeting Details" onclick="loadMeetingDetails();loadDiscussionItemsByMeetingId();" disabled="true">';
$createMeetingBtn = '';
if ($userCanManageMeetings) {
	$createMeetingBtn = '<input id="buttonNewMeeting" type="button" value="New Meeting" onclick="loadCreateMeetingDialog();">';
	$manageMeetingTypesBtn = '<input type="button" value="Manage Meeting Types" onclick="loadManageMeetingTypesDialog();">';
} else {
	$manageMeetingTypesBtn = '&nbsp;&nbsp;&nbsp;Administrative permissions are required to create new meeting types.';
}

// Create the "View Permissions" button
$viewModulePermissions = '';
if ($userCanManageMeetings) {
	$viewModulePermissions = '<a href="javascript:loadMeetingPermissionModal( \''.$currentlySelectedProjectId.'\');" style="margin-right: 10px;">Meeting Permissions</a>';
	//$viewModulePermissions .= '<a href="javascript:loadPermissionModal(\'10_Y\', \''.$currentlySelectedProjectId.'\');" style="margin-right: 10px;">old Meeting Permissions</a>';
}

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link rel="stylesheet" href="/css/jquery.timepicker.css">
	<link rel="stylesheet" href="/css/modules-collaboration-manager.css">
	<link rel="stylesheet" href="/css/elastic.css">
	<link rel="stylesheet" href="/css/fSelect.css">
	<link rel="stylesheet" href="/app/css/permission.css">

	<style>
		.ui-datepicker {
			z-index: 1000 !important;
		}
	</style>
END_HTML_CSS;

/*
<script src="/js/ie-fixes.js"></script>
<script src="/js/jtextarea.js"></script>
*/

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/jquery.elastic.source.js"></script>
	<script src="/js/jquery.numeric.js"></script>
	<script src="/js/jquery.timepicker.js"></script>

	<script src="/js/generated/action_item_assignments-js.js"></script>
	<script src="/js/generated/action_items-js.js"></script>
	<script src="/js/generated/discussion_item_comments-js.js"></script>
	<script src="/js/generated/discussion_items-js.js"></script>
	<script src="/js/generated/discussion_items_to_action_items-js.js"></script>
	<script src="/js/generated/meetings-js.js"></script>
	<script src="/js/generated/meeting_locations-js.js"></script>
	<script src="/js/generated/meeting_types-js.js"></script>

	<script src="/js/modules-collaboration-manager.js"></script>
	<script src="/js/fSelect.js"></script>

	<script>
		var default_meeting_type_id = '$default_meeting_type_id';
		$('.demo').fSelect({
			showSelectAll: true
		});
	</script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Discussion Management - MyFulcrum.com';
$htmlBody = '';

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

//$template->assign('htmlMessages', $htmlMessages);

ob_start();
?>

<?php
$toggleOptionsDropdown = <<<END_TOGGLE_OPTIONS_DROPDOWN
<table style="width:100%">
	<tr>
		<td> $ddlMeetingTypes   $ddlMeetings   $refreshMeetingDetails   $createMeetingBtn  $manageMeetingTypesBtn </td>
		<td align="right">
			 $viewModulePermissions 
		</td>
	</tr>
</table>
<div id="divMeetingDetails"></div>
END_TOGGLE_OPTIONS_DROPDOWN;
if ($userCanViewDiscussionItems) {
	echo $toggleOptionsDropdown;
}


$dummyId = Data::generateDummyPrimaryKey();
if ($userCanCreateDiscussionItems || $userCanManageMeetings) {

	$db = DBI::getInstance($database);
	// To get open Submittals Records
    $query = "SELECT su.* FROM `submittals`as su inner join submittal_statuses as s on su.submittal_status_id=s.id where s.submittal_status='Open' and su.project_id = $project_id";
    
    $db->execute($query);
    $submittal_records = '';
    while($row = $db->fetch())
    {
        $submittal_records .="<option value='".$row['id']."'>".$row['su_title']."</option>";
    }
	// To get open RFI Records
    $query1 = "SELECT r.* FROM `requests_for_information`as r inner join request_for_information_statuses as rs on r.request_for_information_status_id=rs.id where rs.request_for_information_status='Open' and r.project_id = $project_id";
    
    $db->execute($query1);
    $rfi_records = '';
    while($row1 = $db->fetch())
    {
        $rfi_records .="<option value='".$row1['id']."'>".$row1['rfi_title']."</option>";
    }
     $rfi_records;
	$html = <<<END_HTML_CONTENT

		<form id="formNewDiscussionItem" class="containerEdit" name="formNewDiscussionItem" style="display:none;">
			<table style="width:100%;">
				<tr>
					<th colspan="4" align="left" class="discussionItemCls">New Discussion Item</th>
				</tr>
				<tr>
					<th align="left">Title:</th>
					<td ><input id="create-discussion_item-record--discussion_items--discussion_item_title--$dummyId" name="newTitle" type="text"></td>
					<td><input type="checkbox" id="create-discussion_item-record--discussion_items--open_rfi--$dummyId" name="create-discussion_item-record--discussion_items--open_rfi--$dummyId" onclick="rfi_data()">
					 <label style="float: none; padding-right: 70px;" for="create-discussion_item-record--discussion_items--open RFI--$dummyId">Include Open RFIs as task</label></td>
					 <td><input type="checkbox" id="create-discussion_item-record--discussion_items--open_submittals--$dummyId" name="create-discussion_item-record--discussion_items--open_submittals--$dummyId" onclick="submittal_data()">
					 <label style="float: none; padding-right: 70px;" for="create-discussion_item-record--discussion_items--open submittals--$dummyId">Include Open Submittals as task</label></td>
				</tr>
				<tr valign="top">
					<th align="left">Description:</th>
					<td colspan="3"><textarea rows="5" id="create-discussion_item-record--discussion_items--discussion_item--$dummyId" name="newDescription" class="autogrow" style="width:98%;"></textarea></td>
				</tr>
				<tr id="rfi_value" style="display:none;">
				<th align="left">Open RFI:</th>
					<td><select class="demo" id="rfi_title" multiple="multiple">
						$rfi_records
					</select></td>
				</tr>
				<tr id="submittal_value" style="display:none;">
				<th align="left">Open Submittals:</th>
					<td><select class="demo" id="submittal_title" multiple="multiple">
						$submittal_records
					</select></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input id="create-discussion_item-record--discussion_items--meeting_id--$dummyId" type="hidden" value="$dummyId">
						<input id="create-discussion_item-record--discussion_items--created_by_contact_id--$dummyId" type="hidden" value="$currentlyActiveContactId">
						
						<button class="button-com-save-mt" id="btnNewDiscussionItemSave" value="Save New Discussion Item" onclick="Collaboration_Manager__Meetings__createDiscussionItem('create-discussion_item-record', '$dummyId');" type="button" >Save New Discussion Item</button>
						<button class="button-com-save-mt" id="btnEditMeetingInformation" onclick="cancelNewDiscussionItem();" type="button" value="Cancel">Cancel</button>
					</td>
				</tr>
			</table>
		</form>
END_HTML_CONTENT;
	echo $html;

}
if ($userCanManageMeetings) {
	$html = <<<END_HTML_CONTENT

		<input id="userCanSort" name="userCanSort" type="hidden" value="1">
END_HTML_CONTENT;
	echo $html;
}

?>

<div id="discussionListContainer"><div id="discussionList"></div></div>

<div id="dialog"></div>
<div id="dialogHelp"></div>
<div id="dialogImport" style="display:none;"></div>

<div id="divPermissionModal" title="<?php echo $session->getCurrentlySelectedProjectName() . ' Meeting Permissions'; ?>"></div>
<div id="divMeetingLocationsDialog" class="hidden"></div>
<div id="divMeetingTypesDialog" class="hidden"></div>
<div id="divCreateMeetingDialog" class="hidden"></div>
<input id="project_id" type="hidden" value="<?= $project_id; ?>">

<?php include "./modules-collaboration-manager-help-hints.php"; ?>

<?php
if($userRole !="global_admin")
{

if (!$userCanViewDiscussionItems) {
	$errorMessage = 'Permission denied.';
    $message->enqueueError($errorMessage, $currentPhpScript);
	$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
	 if ( !empty($htmlMessages) )
  	echo "<div>$htmlMessages</div>";
	
}
}
$htmlContent = ob_get_clean();

$template->assign('htmlContent', $htmlContent);

//require_once('page-components/axis/footer_smarty.php');
$template->display('master-web-html5.tpl');
//exit;
