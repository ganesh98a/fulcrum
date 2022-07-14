<?php

$encodedCompanyName = Data::entity_encode($companyName);

echo '
	<table width="100%">
		<tr>
			<td nowrap class="contactSectionHeader">' . $encodedCompanyName . ' Employees</td>
		 	<td align="right">
';
if ($userCanManageContacts) {
	echo '<input name="refreshContactsList" id="refreshContactsList" onclick="getArchivedEmployeesByCompany(\'divArchivedEmployees\', \''.$contact_company_id.'\', \''.$companyName.'\');" value="Refresh Contacts" type="button">';
} else {
	echo '&nbsp;';
}
echo '
			</td>
	</table>
';
echo '<table id="tblContacts" class="listTable contactSectionTable" width="100%">';
if (count($arrContacts) > 0) {
	echo '<tr><th class="textAlignLeft">Name</th><th>User Status</th>';
} else {
	echo '<tr><td colspan="2">No Employees Have Been Entered</td></tr>';
}

$loopCounter = 0;
foreach ($arrContacts as $contact_id => $contact) {
	/* @var $contact Contact */

	$contact_user_id = $contact->user_id;

	$contactFullName = $contact->getContactFullName();
	if ($user_id == $contact->user_id) {
		$contactFullName .= ' (My Record)';
	}
	$encodedContactFullName = Data::entity_encode($contactFullName);

	$email = $contact->email;
	$encodedEmail = Data::entity_encode($email);

	// Get invite date from the contact record
	$contact->loadUserInvitation();
	$userInvitation = $contact->getUserInvitation();
	/* @var $userInvitation UserInvitation */

	if (isset($userInvitation->created) && !empty($userInvitation->created)) {
		$inviteDate = $userInvitation->created;
	} else {
		$inviteDate = '';
	}

	$rowStyle = 'class="evenRow"';
	if ($loopCounter%2) {
		$rowStyle = 'class="oddRow"';
	}

	//to check the contact already has a user account
	require_once('lib/common/Contact.php');
	$userAccess=Contact::emailContactsAsUserOrNot($database, $contact_id);
	if($userAccess=="1")
	{
		$userdisable="disabled='true'";
		$userexist="Already in Fulcrum";

	}else
	{
		$userdisable="";
		$userexist="";
	}

	echo '<tr id="contact_'.$contact_id.'" '.$rowStyle.' onclick="showArchivedContactInfo(\''.$contact_id.'\', \''.$contact_user_id.'\');">';

	echo '<td>'.$encodedContactFullName.'</td>';
	echo '<td class="textAlignCenter">';

	if (($contact_user_id > 0) && ($contact_user_id <> $AXIS_NON_EXISTENT_USER_ID)) {
		echo 'Registered';
	} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) < 2) {
		echo '<span title="Email Required To Send Invitation To Use The Fulcrum Website!">&nbsp;No Email</span>';
	} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) > 1) {
		if ($userCanManageContacts) {
			if (strlen($inviteDate) > 1) {
				echo '<input id="contactInvite_'.$contact_id.'" '.$userdisable.' name="inviteCheckbox" type="checkbox"   value="'.$contact_id.'" title="Invitation Previously Sent: '.$inviteDate.'">&nbsp;Invited';
			} else {
				echo '<input id="contactInvite_'.$contact_id.'" '.$userdisable.' name="inviteCheckbox" type="checkbox"  value="'.$contact_id.'">&nbsp;'.$userexist;
			}
		} else {
			echo 'Not Registered';
		}
	} else {
		echo '&nbsp;';
	}

	echo '</td>';
	echo '</tr>';
	$loopCounter++;
}
echo '</table>';
