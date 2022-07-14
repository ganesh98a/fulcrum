<?php
require_once('lib/common/PageComponents.php');

require_once('page-components/dropDownListWidgets.php');
require_once('lib/common/Role.php');
require_once('lib/common/RequestForInformationNotification.php');
require_once('lib/common/RequestForInformationRecipient.php');
require_once('lib/common/SubmittalNotification.php');
require_once('lib/common/SubmittalRecipient.php');




// Function to list grid
function buildContactForEmail($database, $project_id, $user_company_id,$moduleName,$moduleid){
	// To generate the project roles
	$projectrole= Role::projectspecificroles($database);
	$projectrole = array('' => 'Select a Role') + $projectrole;
	$js = 'class="mul-sel" multiple style="width:160px;" onchange="filteragainstRole()"';
	$prependedOption = '<option value="">Select a Role</option>';
	$projectroleListId = "project_roles";
	$projectroleList = PageComponents::dropDownList($projectroleListId, $projectrole, '', null, $js, null);
	$emailcontactList = buildContactForEmailmodel($database, $project_id, $user_company_id,$moduleName,$moduleid);
	if($moduleid ==""){
	$previous_email ='<div style="padding:5px;text-align:center;"><input type="button" id="previously_emailed" value="Previously Emailed List" onclick="loadpreviouslyemailList(&apos;'.$moduleName.'&apos;,&apos;'.$moduleid.'&apos;)"></div>';
	}
	$contactmailBody = <<<END_OF_CONCTACT_BODY
	<div style="display:block">
	<table style="width:60%;">
	<tr><th>Filter on Roles:<th>
	<td>$projectroleList<td>
	<td><span class="colorMediumGray fakeHref" onclick="filteragainstRole(0);">[Reset Filter]</span><td>
	<th width="25px;"><th>
	<th>Search:<th>
	<td><input type="textbox" id="searchemail" onKeyup="filteragainstRole('','1')" value="" style="width:95%"><td>

	</tr>
	
	</table></div>

	
	<input type="hidden" id="moduleName" value="$moduleName">
	<input type="hidden" id="moduleid" value="$moduleid">
	<input type="hidden" id="emailTo" value="">
	<input type="hidden" id="emailCc" value="">
	<input type="hidden" id="emailBcc" value="">
	$previous_email
	<div id="divemaildata" >$emailcontactList</div>
END_OF_CONCTACT_BODY;
	return $contactmailBody;
}

function buildContactForEmailmodel($database, $project_id, $user_company_id,$moduleName,$moduleid,$role_ids='',$search="",$tempemailTo="",$tempemailCc="",$tempemailBcc="")
{
	//To generate the members
	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($db, $project_id, $moduleName,null,null,null,null,$search);
	$arremailTo = loademailListForheader($database,$moduleName,$moduleid,'To');
	$arremailcc = loademailListForheader($database,$moduleName,$moduleid,'Cc');
	$arremailBcc = loademailListForheader($database,$moduleName,$moduleid,'Bcc');
	
	$emailcontactList = <<<END_OF_CONCTACT_BODY
	<table style="margin-bottom: 150px;" width="100%" cellspacing="0" cellpadding="4" border="0">
	<thead>
	<tr class="permissionTableMainHeader">
	<td colspan="7">Check The Contact That You Would Like To Email</td>
	</tr>
	<tr><th>Company</th><th>To</th><th>Cc</th><th>Bcc</th><th>Name</th><th>Email</th><th>Roles</th></tr>
	</thead><tbody>
END_OF_CONCTACT_BODY;
$filterRoleIds =array();
if($role_ids !=""){
$filterRoleIds = explode(',', $role_ids);
}
$curcompany ="";
$comp_header ='false';
foreach ($arrProjectTeamMembersNew as $key => $team) {

	$company = $team['c_fk_cc__company'];
	$contact_company = $team['c_fk_cc__contact_company_id'];
	$contact_id = $team['id'];
	$contactName = $team['first_name'].' '.$team['last_name'];
	$email =$team['email'];
	// To get the role of the contact
	$rolearr = Role::loadContactRolesAgainstContactId($database,$contact_id,$project_id);
	$role = $rolearr[$contact_id]['roles'];
	$stroleid = $rolearr[$contact_id]['roleids'];
	$arrroles = explode(',', $stroleid);

	if(!empty($filterRoleIds))
	{
		if (count(array_intersect($filterRoleIds, $arrroles)) === 0) {
	  // No values from array1 are in array 2
			continue;
	}}



	if($curcompany != $company)
	{
		$curcompany=$company;
		$comp_header ='true';
	}else
	{
		$comp_header='false';
	}
	if($comp_header =='true')
	{
		$emailcontactList .= <<<END_OF_CONCTACT_BODY
	<tr class="headsle ">
	<td nowrap="">$company</td>
	<td colspan="6">&nbsp;</td>
	</tr>

END_OF_CONCTACT_BODY;
	}
	$toexist =$ccexist =$bccexist = "";
	$emailclass="";
	// To check the to email id of cur record and creently select id
	if(array_key_exists($contact_id, $arremailTo) || array_key_exists($contact_id, $tempemailTo))
	{
		$toexist = "checked=true";
		$emailclass="purStyle";
	}
	// To check the to email id 
	if(array_key_exists($contact_id, $arremailcc) || array_key_exists($contact_id, $tempemailCc))
	{
		$ccexist = "checked=true";
		$emailclass="purStyle";
	}
	// To check the to email id 
	if(array_key_exists($contact_id, $arremailBcc) || array_key_exists($contact_id, $tempemailBcc))
	{
		$bccexist = "checked=true";
		$emailclass="purStyle";
	}


	$emailcontactList .= <<<END_OF_CONCTACT_BODY
	<tr id="emailCon_$contact_id" class="$emailclass">
	<td></td>
		<td class="textAlignCenter"><input id="toindiv_$contact_id" class="chb_$contact_id toindiv group_$contact_company" type="checkbox" $toexist onclick="emailhighlight(this.id,this.value,'$contact_id','To')"> </td>
	<td class="textAlignCenter"><input id="ccindiv_$contact_id" class="chb_$contact_id ccindiv group_$contact_company" type="checkbox"  $ccexist onclick="emailhighlight(this.id,this.value,'$contact_id','Cc')" ></td>
	<td class="textAlignCenter"><input id="bccindiv_$contact_id" class="chb_$contact_id bccindiv group_$contact_company" type="checkbox"  $bccexist onclick="emailhighlight(this.id,this.value,'$contact_id','Bcc')"  ></td>

	<td nowrap="">$contactName</td>
	<td nowrap="">$email</td>
	<td >$role</td>
	</tr>

END_OF_CONCTACT_BODY;

}
		$emailcontactList .= <<<END_OF_CONCTACT_BODY
		</tbody></table>
END_OF_CONCTACT_BODY;

	return $emailcontactList;
}

function loademailListForheader($database,$moduleName,$moduleid,$type)
{
	
	switch ($moduleName) {
		case 'submittals':
	$notification_id = SubmittalNotification::getNotificationIdforSubmittals($database,$moduleid);
	$emailrecid = SubmittalRecipient::getRecipientBasedOnHeader($database,$notification_id,$type);
	return $emailrecid;
	break;
	case 'RFI':
	 $notification_id = RequestForInformationNotification::getNotificationIdforRFI($database,$moduleid);
	 $emailrecid = RequestForInformationRecipient::getRecipientBasedOnHeader($database,$notification_id,$type);
	return $emailrecid;
	break;
	}
}



