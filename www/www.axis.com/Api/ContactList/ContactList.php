<?php
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/Role.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/PhoneNumberType.php');

$db = DBI::getInstance($database);
$db->free_result();
$new_sort_by = 'company ASC, first_name ASC, last_name ASC';

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
$project_id = (int) $RN_project_id;
$orderBy = $new_sort_by;

$arrContactsWithRolesByProjectId = ProjectToContactToRole::loadContactsWithRolesByProjectIdReport($database, $project_id, $orderBy, true);
//$arrProjectTeamMembers = Contact::loadProjectTeamMembers($database, $project_id);

if (count($arrContactsWithRolesByProjectId) > 0) {
    foreach ($arrContactsWithRolesByProjectId AS $contact_id => $contact) {
    	$encodedContactFullName = $email = $mobileno = $formattedFaxNumber = '';
        /* @var $contact Contact */
        // Fax...needs some refactoring all around...quick and dirty for now...
        $arrContactFaxNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $contact_id, PhoneNumberType::BUSINESS_FAX);
        if (isset($arrContactFaxNumbers[0]) && !empty($arrContactFaxNumbers[0])) {
            $contactFaxNumber = $arrContactFaxNumbers[0];
            /* @var $contactFaxNumber ContactPhoneNumber */
            $formattedFaxNumber = $contactFaxNumber->getFormattedNumber();
            $contact_fax_number_id = $contactFaxNumber->contact_phone_number_id;
        } else {
            $formattedFaxNumber = '';
            $contact_fax_number_id = 0;
        }

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
        $arrContactRolesByProject = $arrRoleIdsByProjectId[$RN_project_id];

        $contact_user_id = $contact->user_id;

        $company = $contactCompany->contact_company_name;
        $encodedCompanyName = Data::entity_encode($company);

        $contactFullName = $contact->getContactFullName();
        $encodedContactFullName = Data::entity_encode($contactFullName);

        if(!empty($contact->email)){
        	$email = $contact->email;
        }
        if(!empty($contact->mobile_phone_number)){
        	$mobileno = $contact->mobile_phone_number;
        }
        
        /*$escaped_email = $contact->escaped_email;
        $encodedEmail = Data::entity_encode($email);*/

        $contactListDataMember = array();

        /* $contactListDataMember['Company'] = ; */
        $contactListDataMember['name'] = $encodedContactFullName;
        $contactListDataMember['searchStr'] = $encodedContactFullName;
        $contactListDataMember['vendor_name'] = $encodedCompanyName;
        $contactListDataMember['email'] = $email;
        $contactListDataMember['phone'] = $mobileno;
        $contactListDataMember['fax'] = $formattedFaxNumber;
        $contactListDataMember['expand'] = true;
        $RN_jsonEC['data'][$encodedContactFullName] = $contactListDataMember;
    }
    asort($RN_jsonEC['data']);
    $RN_jsonEC['data'] = array_values($RN_jsonEC['data']);
}

?>
