<?php

$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Service/TableService.php');
require_once('lib/common/RequestForInformationRecipient.php');
require_once('lib/common/SubmittalRecipient.php');

function Discussion_AddAction($database,$rfi_element,$submittal_element,$discussion_id,$contact_id,$project_id)
{
	$db = DBI::getInstance($database);

	$rfiaction_item_type_id = 5; // RFI action type id
	$submittalaction_item_type_id = 7; // Submittal action type id

	$rfi_element_data=explode(',', $rfi_element); // convert elements into array

	if(isset($rfi_element_data)) {

		foreach ($rfi_element_data as $key => $rfi_value) {

			// To fetch details from requests_for_information 
			$options = array();
			$options['table'] = 'requests_for_information';
		 	$options['filter'] = array('id = ?'=> $rfi_value);
		 	$options['fields'] = array('id,rfi_recipient_contact_id,rfi_title,rfi_due_date');
		 	$referenceOutput = TableService::GetTabularData($database,$options);

		 	$rfi_contact_id_details = RequestForInformationRecipient::getListOfToRecipient($database,$rfi_value,'To');
		 	$rfi_contact_ids = $rfi_contact_id_details['contact_id'];
		 	$rfi_contact_array = explode(",",$rfi_contact_ids);
		
		 	if ($rfi_contact_ids == '') {
		 		$rfi_contact_array = array($referenceOutput['rfi_recipient_contact_id']);
		 	}

		 	// To insert data into action items for rfi in meetings
		 	$queryRfi="Insert into action_items (project_id, action_item_type_id, action_item_type_reference_id, created_by_contact_id, action_item, action_item_due_date) values (?,?,?,?,?,?)";
		 	$arrayRfi = array($project_id, $rfiaction_item_type_id, $referenceOutput['id'], $contact_id, $referenceOutput['rfi_title'], $referenceOutput['rfi_due_date']);
		 	$db->execute($queryRfi, $arrayRfi, MYSQLI_STORE_RESULT);
			$actionId = $db->insertId; // action_id
			$db->free_result();

			// To map above action_id to discussion_item_id in discussion_items_to_action_items
			$queryActItem="Insert into discussion_items_to_action_items (`discussion_item_id`, `action_item_id`) VALUES (?,?)";
			$arrayActItem = array($discussion_id, $actionId);
			$db->execute($queryActItem, $arrayActItem, MYSQLI_STORE_RESULT);
			$db->free_result();

			foreach ($rfi_contact_array as $rfi_contact_id) {
				// To insert the contacts into action_item_assignments
				$actionActAss="Insert into action_item_assignments (`action_item_id`, `action_item_assignee_contact_id`) VALUES (?,?)";
				$arrayActAss = array($actionId, $rfi_contact_id);
				$db->execute($actionActAss, $arrayActAss, MYSQLI_STORE_RESULT);
				$db->free_result();
		
		 	}
		}
	}

	$submittal_element_data=explode(',', $submittal_element); // convert elements into array

	if(isset($submittal_element_data)) {

		foreach ($submittal_element_data as $key => $submittal_value) {

			// To fetch details from submittals
			$options = array();
			$options['table'] = 'submittals';
		 	$options['filter'] = array('id = ?'=> $submittal_value);
		 	$options['fields'] = array('id,su_recipient_contact_id,su_title,su_due_date');
		 	$referenceOutput = TableService::GetTabularData($database,$options);

		 	$su_contact_id_details = SubmittalRecipient::getListOfToRecipient($database,$submittal_value,'To');
		 	$su_contact_ids = $su_contact_id_details['contact_id'];
		 	$su_contact_array = explode(",",$su_contact_ids);

		 	if ($su_contact_ids == '') {
		 		$su_contact_array = array($referenceOutput['su_recipient_contact_id']);
		 	}

		 	// To insert data into action items for submittal in meetings
		 	$querySU="Insert into action_items (project_id, action_item_type_id, action_item_type_reference_id, created_by_contact_id, action_item, action_item_due_date) values (?,?,?,?,?,?)";
		 	$arraySU = array($project_id, $submittalaction_item_type_id, $referenceOutput['id'], $contact_id, $referenceOutput['su_title'], $referenceOutput['su_due_date']);
		 	$db->execute($querySU, $arraySU, MYSQLI_STORE_RESULT);
			$actionId = $db->insertId; // action_id
			$db->free_result();

			// To map above action_id to discussion_item_id in discussion_items_to_action_items
			$queryActItem="Insert into discussion_items_to_action_items (`discussion_item_id`, `action_item_id`) VALUES (?,?)";
			$arrayActItem = array($discussion_id, $actionId);
			$db->execute($queryActItem, $arrayActItem, MYSQLI_STORE_RESULT);
			$db->free_result();

			foreach ($su_contact_array as $su_contact_id) {
				// To insert the contacts into action_item_assignments
				$actionActAss="Insert into action_item_assignments (`action_item_id`, `action_item_assignee_contact_id`) VALUES (?,?)";
				$arrayActAss = array($actionId, $su_contact_id);
				$db->execute($actionActAss, $arrayActAss, MYSQLI_STORE_RESULT);
				$db->free_result();
			}
		}
	}
}
