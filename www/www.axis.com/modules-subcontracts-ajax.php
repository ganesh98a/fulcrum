<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
//$init['post_maxlength'] = 100000;
//$init['post_required'] = true;
//$init['sapi'] = 'cli';
//$init['skip_always_include'] = true;
//$init['skip_session'] = true;
//$init['skip_templating'] = true;
$init['timer'] = false;
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

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

$db = DBI::getInstance($database);

require_once('lib/common/Contact.php');

require_once('lib/common/Subcontract.php');
require_once('lib/common/SubcontractTemplate.php');
require_once('lib/common/Vendor.php');
require_once('lib/common/SubcontractType.php');
require_once('lib/common/SubcontractTemplateToSubcontractItemTemplate.php');
require_once('lib/common/SubcontractItemTemplate.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/UserCompanyFileTemplate.php');
require_once('lib/common/SubcontractDocument.php');
require_once('lib/common/FileManagerFile.php');

require_once('modules-contacts-manager-functions.php');
require_once('modules-subcontracts-functions.php');

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewSubcontracts = $permissions->determineAccessToSoftwareModuleFunction('subcontracts_view');
$userCanManageSubcontracts = $permissions->determineAccessToSoftwareModuleFunction('subcontracts_manage');
$userCanManageSubcontractTemplates = $permissions->determineAccessToSoftwareModuleFunction('subcontract_templates_manage');
*/

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();

$arrBidStatus = array();
$arrBidderNotes = array();
$arrBidInvitationFiles = array();

ob_start();

switch ($methodCall) {
	case 'Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Template':

		$content = buildCreateSubcontractTemplateDialog($database,$currentlyActiveContactId);
		echo $content;

	break;

	case 'Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template':

		$subcontract_template_id = $get->subcontract_template_id;

		$subcontractTemplateDetails = loadSubcontractTemplateDetails($database, $subcontract_template_id, $user_company_id);

		// @todo Finish this method...
		//$subcontractTemplateDetails = loadSubcontractTemplateDetails($database, $subcontract_template_id);

		$arrOutput = array(
			'subcontract_template_id' => $subcontract_template_id,
			'html' => $subcontractTemplateDetails,
		);
		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

		case 'trackItemTemplate':
				$subcontract_template_id = $get->subcontract_template_id;
				$subcontract_item_template_id = $get->subcontract_item_template_id;
				$track = $get->track;
				$db = DBI::getInstance($database);
				$query1 = "UPDATE subcontract_templates_to_subcontract_item_templates set `contract_track` ='$track' where `subcontract_template_id` = $subcontract_template_id and `subcontract_item_template_id`=$subcontract_item_template_id";
				$db->execute($query1);
				$db->free_result();
		break;

		case 'cloneDefaultTemplateItem':

		$subcontract_template_id = $get->subcontract_template_id;
		$db = DBI::getInstance($database);
    	$query1 = "SELECT * from  subcontract_templates where id = $subcontract_template_id";
        $db->execute($query1);
		$row=$db->fetch();
		$type_id=$row['subcontract_type_id'];
		$templateSamName=$row['subcontract_template_name'];
		// To make a count
		$db = DBI::getInstance($database);
    	$query2 = "SELECT * from  subcontract_templates where subcontract_template_name LIKE '%$templateSamName%' ORDER BY `id` desc limit 1";
        $db->execute($query2);
		$row2=$db->fetch();
		if($row2)
		{
		$tempData=$row2['subcontract_template_name'];
		$tempName=explode('_', $tempData);
		$incot=$tempName[1]+1;;
		$template_name=$row['subcontract_template_name'].'-clone_'.$incot;
	}else
	{
		$template_name=$row['subcontract_template_name'].'-clone_1';
	}
		//end
		// $template_name=$row['subcontract_template_name'].'-clone';
		$db->free_result();
		$query2="INSERT into subcontract_templates (`user_company_id`, `subcontract_type_id`, `subcontract_template_name`, `sort_order`) values($user_company_id,$type_id,'$template_name','1000')";
		$db->execute($query2);
		$primaryid=$db->insertId;
		$db->free_result();
		$query3="SELECT * from subcontract_templates_to_subcontract_item_templates where subcontract_template_id = $subcontract_template_id";
		$db->execute($query3);
		$itemresult=array();
		while($row1 = $db->fetch())
		{
			$item_id=$row1['subcontract_item_template_id'];
			$itemresult[] = $item_id;
		}
		$db->free_result();
		foreach ($itemresult as $key => $value) {
		$db = DBI::getInstance($database);
		$query4="INSERT into subcontract_templates_to_subcontract_item_templates (`subcontract_template_id`,`subcontract_item_template_id`,`updated_by`) values($primaryid,$value,$currentlyActiveContactId)";
		$db->execute($query4);
		$db->free_result();

		}
		$subcontractTemplateDetails = clonedSubcontractTemplateDetails($database, $primaryid, $user_company_id);

		// @todo Finish this method...
		//$subcontractTemplateDetails = loadSubcontractTemplateDetails($database, $subcontract_template_id);

		$arrOutput = array(
			'subcontract_template_id' => $primaryid,
			'html' => $subcontractTemplateDetails,
		);
		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

		case 'MakeDefaultTemplate':

		$templateid = $get->templateid;
		$value = $get->value;
		$contact_id = $get->contact_id;

		$db = DBI::getInstance($database);
		$que1= "SELECT subcontract_type_id from subcontract_templates  where id = '$templateid'";
        $db->execute($que1);
        $rows1=$db->fetch();
        $tempTypeid=$rows1['subcontract_type_id'];
        $db->free_result();
        //For purchase order template
        if(($value=='Y') &&($tempTypeid == "4"))
		{
		$q1= "SELECT id from subcontract_templates  where is_trackable = 'Y' and `is_purchased` = 'Y'";
        $db->execute($q1);
        $r1=$db->fetch();
        $subpurid=$r1['id'];
        $db->free_result();

        $q2= "UPDATE  subcontract_templates  set is_trackable = 'N',`is_purchased` = 'N' where id='$subpurid'";
        $db->execute($q2);
        $db->free_result();
    	
              
    	$q3 = "UPDATE subcontract_templates set `is_trackable`= '$value', `is_purchased` = 'Y'  where id = $templateid";
               if( $db->execute($q3))
               {
     		 $jsonOutput = json_encode(array('status'=>'success','errorMessage'=>'1'));
     		 
     	}else
     	{
     		 $jsonOutput = json_encode(array('status'=>'error'));
     	}
    	}else if(($value=='N') &&($tempTypeid == "4"))
		{
			$q5 = "UPDATE subcontract_templates set `is_trackable`= '$value', `is_purchased` = 'N'  where id = $templateid";
               if( $db->execute($q5))
               {
     		 $jsonOutput = json_encode(array('status'=>'success','errorMessage'=>'1'));
     		 
     	}
    	}
    	//For Default template
		if(($value=='Y') &&($tempTypeid != "4"))
		{
		$db = DBI::getInstance($database);
		$query1= "SELECT id from subcontract_templates  where is_trackable = 'Y' and `is_purchased` = 'N'";
        $db->execute($query1);
        $row=$db->fetch();
        $subid=$row['id'];
        $db->free_result();
        $query2= "UPDATE  subcontract_templates  set is_trackable = 'N' where id='$subid'";
        $db->execute($query2);
        $db->free_result();
    	
              
    	$query_res = "UPDATE subcontract_templates set `is_trackable`= '$value'  where id = $templateid";
               if( $db->execute($query_res))
               {
     		 $jsonOutput = json_encode(array('status'=>'success','errorMessage'=>'1'));
     		 
     	}else
     	{
     		 $jsonOutput = json_encode(array('status'=>'error'));
     	}
     }else if(($value=='N') &&($tempTypeid != "4"))
		{
			$query_res1 = "UPDATE subcontract_templates set `is_trackable`= '$value'  where id = $templateid";
               if( $db->execute($query_res1))
               {
     		 $jsonOutput = json_encode(array('status'=>'success','errorMessage'=>'1'));
     		 
     	}
		}
     

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

		case 'DefaultTemplateItem':

		$itemtemplate = $get->itemtemplate;
		$value = $get->value;
		$contact_id = $get->contact_id;

		$db = DBI::getInstance($database);
    	$query_res = "UPDATE   subcontract_item_templates set `is_trackable`= '$value' ,updated_by='$contact_id' where id = $itemtemplate";
        if( $db->execute($query_res))
        {
        		$db = DBI::getInstance($database);
        		$defque = "SELECT user_company_id FROM `subcontract_item_templates` WHERE `id` = $itemtemplate ";
       			$db->execute($defque);
       			$fetdef=$db->fetch();
       			$fetchCompany=$fetdef['user_company_id'];
       			$db->free_result();
        		if($fetchCompany=='1'){
        		//To get the default subcontract template record
        	 	$query1 = "SELECT id FROM `subcontract_templates` WHERE `is_trackable` = 'Y' and `is_purchased` ='N' and user_company_id ='1'";
       			$db->execute($query1);
       			$row=$db->fetch();
       			if($row)
       			{
       			$DefaultTemplateId=$row['id'];
       			$db->free_result();
       			if($value=='Y')
        		{
       		 	$query2 = "INSERT into `subcontract_templates_to_subcontract_item_templates` (`subcontract_template_id` ,`subcontract_item_template_id`,`sort_order`,`updated_by`) values ($DefaultTemplateId,$itemtemplate,'1000',$contact_id)";
       			$db->execute($query2);
       			$db->free_result();
       			}else
       			{
       			 $query3 = "DELETE from `subcontract_templates_to_subcontract_item_templates` where `subcontract_template_id`=$DefaultTemplateId and `subcontract_item_template_id` =$itemtemplate";
       			$db->execute($query3);
       			$db->free_result();
       			}
        		 
        	}
        }
     		 $jsonOutput = json_encode(array('status'=>'success','errorMessage'=>'1'));
     		 
     	}else
     	{
     		 $jsonOutput = json_encode(array('status'=>'error'));
     	}

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

	case 'Subcontracts__Admin__loadSubcontractTemplateRecords':

		$crudOperation = 'load';
		$errorNumber = 0;
		$errorMessage = '';
		$primaryKeyAsString = '';
		$htmlRecordList = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			//$subcontractTemplates = loadSubcontractTemplates($database, $user_company_id);
			//Fulcrum global admin
		$config = Zend_Registry::get('config');
   		$fulcrum_user = $config->system->fulcrum_user;
			$db = DBI::getInstance($database);
			$companyQuery = "SELECT email FROM users where primary_contact_id='$currentlyActiveContactId'  limit 1 ";
   			$db->execute($companyQuery);
   	 		$row = $db->fetch();
   	 		$user_email=$row['email'];
     		$db->free_result();
     		if($user_email == $fulcrum_user)
     		{
     			$globalAccess="1";
     			
     		}else
     		{
     			$globalAccess="0";
	   		}
			$subcontractTemplatesTbody = buildSubcontractTemplates__AsTableRows($database, $user_company_id,$currentlyActiveContactId,$globalAccess);
			$htmlRecordList = $subcontractTemplatesTbody;

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = $htmlRecordList;
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadSubcontractTemplateSummary':

		// Note: This is not in active use
		// If used, just append html to the json response array
		// Originally called from (which is itself not in use):
		// function toggleSubcontractTemplateToSubcontractItemTemplateSuccess(data, textStatus, jqXHR)
		$subcontract_template_id = $get->subcontract_template_id;

		$subcontractTemplates = loadSubcontractTemplateSummary($database, $subcontract_template_id);
		echo $subcontractTemplates;

	break;

	case 'Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Item_Template':

		$arrOutput = buildSubcontractItemTemplateDetailsDialogVersion2($database, $user_company_id, $project_id, $currentlyActiveContactId);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;

	case 'Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Item_Template':

		$subcontract_item_template_id = Data::parseInt($get->subcontract_item_template_id);

		$arrOutput = buildSubcontractItemTemplateDetailsDialogVersion2($database, $user_company_id, $project_id, $currentlyActiveContactId, $subcontract_item_template_id);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;

	case 'Subcontracts__Admin__loadSubcontractItemTemplateRecords':

		$crudOperation = 'load';
		$errorNumber = 0;
		$errorMessage = '';
		$primaryKeyAsString = '';
		$htmlRecordList = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			//Fulcrum global admin
			$config = Zend_Registry::get('config');
			$fulcrum_user = $config->system->fulcrum_user;
			$companyQuery = "SELECT email FROM users where primary_contact_id='$currentlyActiveContactId'  limit 1 ";
			$db->execute($companyQuery);
			$row = $db->fetch();
			$user_email=$row['email'];
			$db->free_result();
			if($user_email == $fulcrum_user)
			{
				$globalAccess="1";
			}else
			{
				$globalAccess="0";
			}
			if($globalAccess =="1")
			{
			$GlobalFulcrumItemTemplatesTable = loadSubcontractItemTemplates($database, 1, $currentlySelectedProjectId,$currentlyActiveContactId,$globalAccess);
			$htmlRecordList = $GlobalFulcrumItemTemplatesTable;
			}

			$subcontractItemTemplates = loadSubcontractItemTemplates($database, $user_company_id, $currentlySelectedProjectId);
			$htmlRecordList .= $subcontractItemTemplates;

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = $htmlRecordList;
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'toggleSubcontractTemplateToSubcontractItemTemplate':

		// Note: This case is not in active use.
		// Upgraded to support JSON anyway
		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$primaryKeyAsString = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			$subcontract_template_id = Data::parseInt($get->subcontract_template_id);
			$subcontract_item_template_id = Data::parseInt($get->subcontract_item_template_id);

			$subcontractTemplateToSubcontractItemTemplate =
				SubcontractTemplateToSubcontractItemTemplate::findBySubcontractTemplateIdAndSubcontractItemTemplateId($database, $subcontract_template_id, $subcontract_item_template_id);

			if ($subcontractTemplateToSubcontractItemTemplate) {
				$subcontractTemplateToSubcontractItemTemplate->delete();
			} else {
				$next_sort_order = SubcontractTemplateToSubcontractItemTemplate::findNextSortOrder($database, $user_company_id);
				$subcontractTemplateToSubcontractItemTemplate = new SubcontractTemplateToSubcontractItemTemplate($database);
				$subcontractTemplateToSubcontractItemTemplate->subcontract_template_id = $subcontract_template_id;
				$subcontractTemplateToSubcontractItemTemplate->subcontract_item_template_id = $subcontract_item_template_id;
				$subcontractTemplateToSubcontractItemTemplate->sort_order = $next_sort_order;
				$subcontractTemplateToSubcontractItemTemplate->convertPropertiesToData();
				$subcontractTemplateToSubcontractItemTemplate->save();
			}

			$arrCustomizedJsonOutput = array('subcontract_template_id' => $subcontract_template_id);

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} else {
			$output = $htmlContent;
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

		break;

	case 'emailWidget':

		require_once('page-components/email.php');
		$ajaxHandler = '/modules-subcontracts-ajax.php?method=sendEmail';
		$sender_contact_id = $session->getCurrentlyActiveContactId();
		$recipient_role_group_id = '';
		$subject = '';
		$body = '';
		$widget = buildEmailWidget($ajaxHandler, $sender_contact_id, $recipient_role_group_id, $subject, $body, $database, $user_company_id);
		echo $widget;

	break;

	case 'sendEmail':

		$from = $get->from;
		$to = $get->to;
		$cc = $get->cc;
		$bcc = $get->bcc;
		$subject = $get->subject;
		$body = $get->body;

		$toRecipients = explode(',', $to);
		$ccRecipients = explode(',', $cc);
		$bccRecipients = explode(',', $bcc);

		echo 'success';

	break;

}

$htmlOutput = ob_get_clean();
echo $htmlOutput;

while (@ob_end_flush());

exit; // End of PHP Ajax Handler Code

} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}
