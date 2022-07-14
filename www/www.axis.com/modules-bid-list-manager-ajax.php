<?php
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

require_once('lib/common/BidList.php');
require_once('modules-contacts-manager-functions.php');
require_once('modules-bid-list-manager-functions.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

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
$permissions = Zend_Registry::get('permissions');
$userCanManageContacts = $permissions->determineAccessToSoftwareModuleFunction('admin_contacts_my_contacts_manage');
$userCanManageMyContactRoles = $permissions->determineAccessToSoftwareModuleFunction('admin_contacts_my_contact_roles_manage');
$userCanViewBidLists = $permissions->determineAccessToSoftwareModuleFunction('bid_list_view');
$userCanManageBidLists = $permissions->determineAccessToSoftwareModuleFunction('bid_list_manage_lists');
// @todo Use admin_contacts_my_contact_company_manage and admin_contacts_third_party_contact_companies_manage here
$userCanManageBidListCompanies = $permissions->determineAccessToSoftwareModuleFunction('bid_list_manage_companies');

ob_start();

switch ($methodCall) {
	case 'updateBidListName':
		$content = "";
		if ($userCanManageBidLists) {
			$bid_list_id = $get->bid_list_id;
			$newName = $get->newValue;

			$query =
"
UPDATE bid_lists
SET bid_list_name = ?
WHERE id = ?
AND user_company_id = ?
";
			$arrValues = array($newName,$bid_list_id,$user_company_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
			$content = createBidListDropDownForUserCompany($database, $user_company_id, $bid_list_id);
		}
		echo $content;
	break;

	case 'createNewBidList':
		$content = '';
		if ($userCanManageBidLists) {
			$newName = $get->newValue;

			$query =
"
INSERT
INTO bid_lists (user_company_id,bid_list_name)
VALUES(?,?)
";
			$arrValues = array($user_company_id,$newName);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$bid_list_id = $db->insertId;
			$db->free_result();
			$content = createBidListDropDownForUserCompany($database, $user_company_id, $bid_list_id);
		}
		echo $content;
	break;

	case 'removeBidList':
		$content = '';
		if ($userCanManageBidLists) {
			$bid_list_id = $get->bid_list_id;

			$query =
"
DELETE FROM bid_lists_to_contacts
WHERE bid_list_id = ?
";
			$arrValues = array($bid_list_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$query =
"
DELETE FROM bid_lists
WHERE id = ?
";
			$arrValues = array($bid_list_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$content = createBidListDropDownForUserCompany($database, $user_company_id, 0);
		}
		echo $content;
	break;

	case 'loadBidListContacts':
		$content = '';
		if ($userCanViewBidLists || $userCanManageBidLists || $userCanManageBidListCompanies) {
			$bid_list_id = $get->bid_list_id;
			$content = buildContactListForBidList($database, $user_company_id, $bid_list_id, $userCanManageBidListCompanies);
		}
		echo $content;
	break;

	case 'addContactToBidList':
		$content = '';
		if ($userCanManageBidLists || $userCanManageBidListCompanies) {
			$bid_list_id = $get->bid_list_id;
			$contact_id = $get->contact_id;

			$query =
"
INSERT IGNORE
INTO bid_lists_to_contacts (bid_list_id,contact_id)
VALUES(?,?)
";
			$arrValues = array($bid_list_id,$contact_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$content = buildContactListForBidList($database, $user_company_id, $bid_list_id, $userCanManageBidListCompanies);
		}
		echo $content;
	break;

	case 'removeContactFromBidList':
		$content = '';
		if ($userCanManageBidLists || $userCanManageBidListCompanies) {
			$bid_list_id = $get->bid_list_id;
			$contact_id = $get->contact_id;

			$query =
"
DELETE FROM bid_lists_to_contacts
WHERE bid_list_id = ?
AND contact_id = ?
";
			$arrValues = array($bid_list_id, $contact_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$content = buildContactListForBidList($database, $user_company_id, $bid_list_id, $userCanManageBidListCompanies);
		}
		echo $content;
		break;

	case 'removeCompanyFromBidList':
		$content = '';
		if ($userCanManageBidLists || $userCanManageBidListCompanies) {
			$bid_list_id = $get->bid_list_id;
			$contact_company_id = $get->contact_company_id;
			// $user_company_id comes from the session

			require_once('lib/common/Contact.php');
			$arrContactIds = Contact::loadContactIdsListByUserCompanyIdAndContactCompanyId($database, $user_company_id, $contact_company_id);
			$in = join(',', $arrContactIds);

			$query =
"
DELETE
FROM `bid_lists_to_contacts`
WHERE `bid_list_id` = ?
AND `contact_id` IN($in)
";
			$arrValues = array($bid_list_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$content = buildContactListForBidList($database, $user_company_id, $bid_list_id, $userCanManageBidListCompanies);
			echo $content;
		} else {
			trigger_error('scope:modules-bid-list-manager-ajax.php:removeCompanyFromBidList:Access Denied', E_USER_ERROR);
		}
		break;

	case 'loadTradesPerformedByCompany':
		$bid_list_id = $get->bid_list_id;
		$contact_company_id = $get->contact_company_id;
		$contact_company_name = $get->companyName;
		$contactCompanyTradesTable = getContactCompanyTradesTable($database, $user_company_id, $contact_company_id, $userCanManageBidListCompanies);

		if ($userCanManageBidListCompanies) {
			$companyNameHtml = "$contact_company_name <a href=\"javascript:removeCompanyFromBidList('$bid_list_id', '$contact_company_id', '$contact_company_name');\">X</a>";
		} else {
			$companyNameHtml = $contact_company_name;
		}

		//<tr><td>Trades Peformed By <span id="spanSelectedBidListCompany">&nbsp;</span></td></tr>
		$html = '
					<table>
						<tr><td>Trades Peformed By '.$companyNameHtml.'</td></tr>
	';
	if ($userCanManageBidListCompanies) {
		$createTradeDropDownForUserCompanyId = createTradeDropDownForUserCompanyId($database, $user_company_id, $userRole);
		$html .= '
						<tr>
							<td><input id="contact_company_id" name="contact_company_id" type="hidden" value="'.$contact_company_id.'">'
								.$createTradeDropDownForUserCompanyId.'
								<input id="btnAddTradeToCompany" name="btnAddTradeToCompany" type="button" value="Add Selected Trade(s)" onclick="addTradeToCompany()">
							</td>
						</tr>
		';
	}
	$html .= '
						<tr>
							<td>
								<div id="divCompanyTrade">'.$contactCompanyTradesTable.'</div>
							</td>
						</tr>
					</table>
		';
		echo $html;
	break;
}

ob_flush();
exit;
