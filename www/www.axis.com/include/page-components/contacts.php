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
 * The following objects / variable drive this template:
 *
 * $AXIS_NON_EXISTENT_USER_ID
 * $companyName
 * $userCanManageContacts
 * $arrContacts (List of Contact Objects)
 *
 */
?>

<?php

$encodedCompanyName = Data::entity_encode($companyName);

echo '
	<table width="100%">
		<tr>
			<td nowrap class="contactSectionHeader">' . $encodedCompanyName . ' Employees</td>
		 	<td align="right">
';
if ($userCanManageContacts) {
	//echo '<input name="btnNewContact" id="btnNewContact" onclick="showContactInfo(0,1);" value="New Contact" type="button">';
	echo '<input name="refreshContactsList" id="refreshContactsList" onclick="getEmployeesByCompany(\'divEmployees\', \''.$contact_company_id.'\', \''.$companyName.'\');" value="Refresh Contacts" type="button">';
	echo '<input name="btnNewContact" id="btnNewContact" onclick="rendorCreateContactForm(\''.$contact_company_id.'\');" value="New Contact" type="button">';
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

$showInviteButton = false;
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

	echo '<tr id="contact_'.$contact_id.'" '.$rowStyle.' onclick="showContactInfo(\''.$contact_id.'\', \''.$contact_user_id.'\');">';

	echo '<td>'.$encodedContactFullName.'</td>';
	echo '<td class="textAlignCenter">';

	if (($contact_user_id > 0) && ($contact_user_id <> $AXIS_NON_EXISTENT_USER_ID)) {
		echo 'Registered';
	} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) < 2) {
		echo '<span title="Email Required To Send Invitation To Use The Fulcrum Website!">&nbsp;No Email</span>';
	} elseif ($contact_user_id == $AXIS_NON_EXISTENT_USER_ID && strlen($email) > 1) {
		if ($userCanManageContacts) {
			$showInviteButton = true;
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

/*
	if ($contact_user_id == 1) {
		echo '<td>'.$encodedContactFullName.'</td>';
		//echo '<td align="right"><a class="smallerFont">Update</a></td>';
		echo '<td align="right">&nbsp;</td>';
	} else {
		echo '<td>'.$encodedContactFullName.'</td>';
		echo '<td align="right">**Registered User - ?Project Access? <a class="smallerFont">Update</a></td>';
	}
*/
	echo '</tr>';
	$loopCounter++;
}
if ($showInviteButton) {
	echo '<tr><td>&nbsp;</td><td align="right"><input id="btnSendInvites" name="btnSendInvites" type="button" value="Send Invitation(s)" onclick="processUserInvitations();"></td></tr>';
}
echo '</table>';
