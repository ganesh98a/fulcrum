<?php
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
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

// DATABASE VARIABLES
$db = DBI::getInstance($database);

// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();
// PERMISSION VARIABLES
require_once('app/models/permission_mdl.php');
$userCanManageContacts = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contacts_manage');
$userCanManageMyContactRoles = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contact_roles_manage');
$userCanViewBidLists = checkPermissionForAllModuleAndRole($database,'bid_list_view');
$userCanManageBidLists = checkPermissionForAllModuleAndRole($database,'bid_list_manage_lists');
$userCanManageBidListCompanies = checkPermissionForAllModuleAndRole($database,'bid_list_manage_companies');

if($userRole =="global_admin")
{
	$userCanViewBidLists = $userCanManageBidLists = $userCanManageBidListCompanies = 1;
}


$selected_bid_list_id = 0; // THIS COULD GET STORED IN THE SESSION
$selected_bid_list_name = '&nbsp;';

if (isset($get) && $get->bid_list_id) {
	$bid_list_id = $get->bid_list_id;
} else {
	$bid_list_id = 0;
}

require_once('lib/common/BidList.php');
include_once('modules-contacts-manager-functions.php');
include_once('modules-bid-list-manager-functions.php');


ob_start();
if($userCanViewBidLists)
{
if ($userCanManageBidLists) {
	echo '<input id="userCanManageLists" name="userCanManageLists" type="hidden" value="1">';
} else {
	echo '<input id="userCanManageLists" name="userCanManageLists" type="hidden" value="0">';
}

$createBidListDropDownForUserCompany = createBidListDropDownForUserCompany($database, $user_company_id, $bid_list_id);
echo '
	<table border="0" cellspacing="0">
	';
if ($userCanManageBidLists) {
	echo '
		<tr>
			<td>
				<input id="btnCreateNewList" name="btnCreateNewList" type="button" value="Create A New Bid List (Customized List Of Contacts)" onclick="showCreateNewBidList();">
				<br>
				<br>
				<div id="divNewList" style="display:none;">
					<table cellspacing="0">
						<tr>
							<td>New Bid List Name</td>
							<td><input id="txtNewBidListName" name="txtNewBidListName" type="text"></td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td colspan="2">
								<input id="btnCancelNewBidList" name="btnCancelNewBidList" type="button" value="Cancel" onclick="btnCancelNewBidListClicked();">
								<input id="btnCreateNewBidList" name="btnCreateNewBidList" type="button" value="Save New Bid List" onclick="btnCreateNewBidListClicked();">
							</td>
						</tr>
					</table>
					<br>
				</div>
			</td>
		</tr>
	';
}
echo '
		<tr>
			<td>
				<div id="ddlBidListDiv">
				'.$createBidListDropDownForUserCompany.'
				</div>
			</td>
		</tr>
';
echo '
	</table>
	<br>
';

/*
echo '
	<div id="divNewList" style="display:none;">
		<table cellspacing="0">
			<tr>
				<td>New Bid List Name</td>
				<td><input id="txtNewBidListName" name="txtNewBidListName" type="text"></td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td colspan="2">
					<input id="btnCancelNewBidList" name="btnCancelNewBidList" type="button" value="Cancel" onclick="btnCancelNewBidListClicked()">
					<input id="btnCreateNewBidList" name="btnCreateNewBidList" type="button" value="Save New Bid List" onclick="btnCreateNewBidListClicked()">
				</td>
			</tr>
		</table>
	</div>
';
*/

if ($selected_bid_list_id == 0) {
	echo '<div id="divBidListDetails" style="display:none;" class="contact-search-parent-container">';
} else {
	echo '<div id="divBidListDetails" class="contact-search-parent-container">';
}

	echo '<table cellspacing="0">';

	if ($userCanManageBidLists) {
		echo '
			<tr>
				<td><a id="aDeleteBidList" href="javascript:deleteSelectedBidList()" title="Delete This Bid List">X</a></td>
				<td><input id="txtBidListName" name="txtBidListName" type="text" value="'.$selected_bid_list_name.'" onchange="updateBidListName()"><span id="spanBidListName" style="display:none;">'.$selected_bid_list_name.'</span></td>
			</tr>
		';
	} else {
		echo '
			<tr>
				<td><input id="txtBidListName" name="txtBidListName" type="text" value="'.$selected_bid_list_name.'" onchange="updateBidListName()" style="display:none;"><span id="spanBidListName">'.$selected_bid_list_name.'</span></td>
			</tr>
		';
	}
	echo'
		</table>
		<br>
	';

	if ($userCanManageBidListCompanies) {

		$javaScriptHandler = 'divBidListDetails';
		include('page-components/contact_search_by_contact_company_name_or_contact_name.php');
		include('page-components/contact_search_by_cost_code_association.php');

		echo '<b>Search for Subcontractors by:</b>';
		echo $contact_search_form_by_contact_company_name_or_contact_name_html;
		//$contact_search_form_by_contact_company_name_or_contact_name_javascript
		echo $contact_search_form_by_cost_code_html;
		//$contact_search_form_by_cost_code_javascript

		echo '<br>';

		/*
		echo '
			<table>
				<tr>
					<td>Cost Code:</td>
					<td><input type="text"></td>
					<td>Cost Code Description:</td>
					<td><input type="text"</td>
				</tr>
			</table>
			<br>
		';
		*/

	}

	$buildContactListForBidList = buildContactListForBidList($database, $user_company_id, $bid_list_id, $userCanManageBidListCompanies);
	echo'
		<table cellspacing="0" cellpadding="5">
			<tr valign="top">
				<td>
					<div id="divListContacts">
						'.$buildContactListForBidList.'
					</div>
				</td>
				<td>
					<div id="tblTradesByCompany" style="display:none;">
					</div>
				</td>
			</tr>
		</table>
	';
//}

echo '</div>';
}else
{
	$errorMessage = 'Permission denied.';
    $message->enqueueError($errorMessage, $currentPhpScript);
	$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
	 if ( !empty($htmlMessages) )
  	echo "<div>$htmlMessages</div>";
	
}

$htmlContent = ob_get_clean();

$template->assign('htmlContent', $htmlContent);


if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY

	<script src="/js/modules-bid-list-manager.js"></script>
END_HTML_JAVASCRIPT_BODY;

require('template-assignments/main.php');

//require_once('page-components/axis/footer_smarty.php');

$template->display('master-web-html5.tpl');
