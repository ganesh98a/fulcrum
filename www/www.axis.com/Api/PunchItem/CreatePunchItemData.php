<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');

$RN_jsonEC['status'] = 200;
try{
	// create items requirements
	$RN_arrCreateItemList = array();
	// cost code list
	$RN_costCodeTmp = array();
	$RN_costCodeSubcontractorTmp = array();
	// $RN_costCodeTmp[] = 'Select A Cost Code';
		// subcontractor by project
	$RN_loadContactsByUserCompanyIdOptions = new Input();
	$RN_loadContactsByUserCompanyIdOptions->forceLoadFlag = false;

	$RN_arrContactsByRoles = Contact::loadContactsByRoleForeman($database, $RN_project_id, $RN_loadContactsByUserCompanyIdOptions);
	
	foreach ($RN_arrContactsByRoles as $id => $RN_contact_company) {
		/* @var $contact Contact */

		/* @var $contactCompany ContactCompany */
		$RN_subContractCCId = $RN_contact_company['contact_company_id'];
		$RN_escaped_contact_company_name = $RN_contact_company['company'];
		// $RN_cost_code_id = $RN_contact_company['cost_code_id'];
		$RN_contact_id = $RN_contact_company['contact_id'];
		$RN_cost_code_id = false;

		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['id'] = htmlspecialchars_decode($id).'***'.$RN_subContractCCId;
		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['name'] = htmlspecialchars_decode($RN_escaped_contact_company_name);
		// contact 
		$RN_contact = Contact::findById($database, $RN_contact_id);
		$RN_encodedContactFullNameWithEmail = null;
		if($RN_contact) {
			$RN_contactFullNameWithEmail = $RN_contact->getContactFullNameWithEmail(false, '<', '-');
			$RN_contactFullName = $RN_contact->getContactFullNameHtmlEscaped(false, '<', '-');

			$RN_encodedContactFullNameWithEmail = Data::entity_encode($RN_contactFullNameWithEmail);	
		}		

		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['list'][$RN_contact_id]['id'] = $RN_subContractCCId.'-'.$RN_contact_id;
		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['list'][$RN_contact_id]['name'] = htmlspecialchars_decode($RN_encodedContactFullNameWithEmail);

		/* $RN_loadContactsByUserCompanyIdOptions = new Input();
		$RN_loadContactsByUserCompanyIdOptions->forceLoadFlag = false;
		$RN_arrContactsByCCId = Contact::loadContactsByContactCompanyId($database, $RN_subContractCCId, $RN_loadContactsByUserCompanyIdOptions);
		foreach ($RN_arrContactsByCCId as $RN_contact_id => $RN_contact){
			$RN_contactFullNameWithEmail = $RN_contact->getContactFullNameWithEmail(false, '<', '-');
			$RN_contactFullName = $RN_contact->getContactFullNameHtmlEscaped(false, '<', '-');
			
			$RN_encodedContactFullNameWithEmail = Data::entity_encode($RN_contactFullNameWithEmail);

			$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['list'][$RN_contact_id]['id'] = $RN_subContractCCId.'-'.$RN_contact_id;
			$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['list'][$RN_contact_id]['name'] = htmlspecialchars_decode($RN_encodedContactFullNameWithEmail);
		} */

		//  Cost Code
		if($RN_cost_code_id) {

			$RN_costCode = CostCode::findById($database, $RN_cost_code_id);
			/* @var $costCode CostCode */

				// This below method call will lazy load $costCodeDivision
			$RN_formattedCostCode = $RN_costCode->getFormattedCostCodeApi($database, true, $RN_user_company_id);
			$RN_htmlEntityEscapedFormattedCostCodeLabel = $RN_costCode->getHtmlEntityEscapedFormattedCostCodeApi($database,$RN_user_company_id);

			$RN_costCodeDivision = $RN_costCode->getCostCodeDivision();
			/* @var $costCodeDivision CostCodeDivision */

			$RN_cost_code_division_id = $RN_costCodeDivision->cost_code_division_id;

			$RN_division_number = $RN_costCodeDivision->division_number;
			$RN_cost_code = $RN_costCode->cost_code;
			$RN_cost_code_description =$RN_costCode->cost_code_description;

			$RN_division_code_heading = $RN_costCodeDivision->division_code_heading;
			$RN_division = $RN_costCodeDivision->division;

				// HTML Entity escaped versions
			$RN_escaped_division_number = $RN_costCodeDivision->escaped_division_number;
			$RN_escaped_cost_code = $RN_costCode->escaped_cost_code;
			$RN_escaped_cost_code_description = htmlspecialchars_decode($RN_costCode->escaped_cost_code_description);

			$RN_escaped_division_code_heading = $RN_costCodeDivision->escaped_division_code_heading;
			$RN_escaped_division = $RN_costCodeDivision->escaped_division;

			$RN_costCodeTmp[$RN_subContractCCId][$RN_escaped_division_number]['id'] = htmlspecialchars_decode($RN_escaped_division.'('.$RN_escaped_division_number.'-'.$RN_escaped_division_code_heading.')');
			$RN_costCodeTmp[$RN_subContractCCId][$RN_escaped_division_number]['name'] = htmlspecialchars_decode($RN_escaped_division.'('.$RN_escaped_division_number.'-'.$RN_escaped_division_code_heading.')');
				// cost code name
			$RN_costCodeTmp[$RN_subContractCCId][$RN_escaped_division_number]['list'][$RN_cost_code_id]['id'] = $RN_cost_code_id;
			$RN_costCodeTmp[$RN_subContractCCId][$RN_escaped_division_number]['list'][$RN_cost_code_id]['name'] = $RN_escaped_division_number.'-'.$RN_escaped_cost_code.' '.$RN_escaped_cost_code_description;
		}
	}
	ksort($RN_costCodeTmp);
	$RN_costCodeDefaultId = null;
	$RN_kIn = 0;
	foreach($RN_costCodeTmp as $RN_k => $RN_sortValues){
		foreach($RN_sortValues as $RN_sub_k => $RN_sortValuesKey){
			$RN_costCodeTmp[$RN_k][$RN_sub_k]['list'] = array_values($RN_sortValuesKey['list']);
			if($RN_kIn == 0){
				$RN_costCodeDefaultId = $RN_costCodeTmp[$RN_k][$RN_sub_k]['list'][0]['id'];
			}
			$RN_kIn++;
		}
		$RN_costCodeTmp[$RN_k] = array_values($RN_costCodeTmp[$RN_k]);
	}
	$RN_jsonEC['data']['CreatePunchListData']['cost_code_default_id'] = $RN_costCodeDefaultId;
	$RN_jsonEC['data']['CreatePunchListData']['cost_code'] = ($RN_costCodeTmp);
	// s subcontractor
	$RN_initiatorDefaultId = null;
	$RN_kInc = 0;
	foreach($RN_costCodeSubcontractorTmp as $RN_k => $RN_sortValues){
		$RN_costCodeSubcontractorTmp[$RN_k]['list'] = array_values($RN_sortValues['list']);
		if($RN_kInc == 0){
			$RN_initiatorDefaultId = $RN_costCodeSubcontractorTmp[$RN_k]['list'][0]['id'];
		}
		$RN_kInc++;
	}
	if(empty($RN_costCodeSubcontractorTmp)) {
		$tmpSubConArr = array();
		$tmpSubConArr[0]['id'] = "";
		$tmpSubConArr[0]['name'] = "No contacts with foreman role";
		$nodataArr = array();
		$nodataArr[0]['id'] = '';
		$nodataArr[0]['name'] = '';
		$tmpSubConArr[0]['list'] = $nodataArr;
		$RN_costCodeSubcontractorTmp = $tmpSubConArr;
	}
	$RN_jsonEC['data']['CreatePunchListData']['recipient'] = array_values($RN_costCodeSubcontractorTmp);
	$RN_jsonEC['data']['CreatePunchListData']['recipient_default_id'] = $RN_initiatorDefaultId;
	// Building & Rooms Content

	$RN_arrBuldingTmp = array();

	$RN_arrBuildings = PunchItemBuilding::findPunchItemBuildingByProjectIdExtended($database, $RN_project_id);
	$RN_buildingDefaultId = null;
	$RN_kIncb = 0;
	foreach($RN_arrBuildings as $RN_pibk => $RN_piBuilding){
		$RN_arrBuldingTmp[$RN_pibk]['id'] = $RN_piBuilding->id;
		$RN_arrBuldingTmp[$RN_pibk]['name'] = $RN_piBuilding->building_name;
		$RN_arrBuldingTmp[$RN_pibk]['location'] = $RN_piBuilding->location;
		if($RN_kIncb == 0){
			$RN_buildingDefaultId = $RN_pibk;
		}
		$RN_kIncb++;
	}
	// $RN_jsonEC['data'] = null;
	$RN_jsonEC['data']['CreatePunchListData']['building'] = array_values($RN_arrBuldingTmp);

	$RN_buildingDefaultId = PunchItem::findLastPunchItemBuildingAndRoomByContactId($database, $RN_project_id, $RN_currentlyActiveContactId, 'location_id');

	$RN_jsonEC['data']['CreatePunchListData']['building_default_id'] = $RN_buildingDefaultId;
	// Rooms default
	$RN_arrBuldingRoomTmp = array();
	$RN_buildingRoomDefaultId = null;
	$RN_kIncbr = 0;
	if($RN_buildingDefaultId!=null){
		$RN_arrPiBuildingRooms = PunchItemBuildingRoom::findByPunchItemRoomByBuildingId($database, $RN_buildingDefaultId);
		foreach($RN_arrPiBuildingRooms as $RN_kibr => $RN_buildinRoom){
			$RN_arrBuldingRoomTmp[$RN_kibr]['id'] = $RN_kibr;
			$RN_arrBuldingRoomTmp[$RN_kibr]['name'] = $RN_buildinRoom->room_name;
			if($RN_kIncbr == 0){
				$RN_buildingRoomDefaultId = $RN_kibr;
			}
			$RN_kIncbr++;
		}
	}
	$RN_jsonEC['data']['CreatePunchListData']['room'] = array_values($RN_arrBuldingRoomTmp);

	$RN_buildingRoomDefaultId = PunchItem::findLastPunchItemBuildingAndRoomByContactId($database, $RN_project_id, $RN_currentlyActiveContactId, 'room_id');

	$RN_jsonEC['data']['CreatePunchListData']['room_default_id'] = $RN_buildingRoomDefaultId;
	// due date default 2 days without weekends
	$RN_today = date('Y-m-d');
	$RN_next2WD = date('Y-m-d', strtotime($RN_today.'+3 weekday'));
	$RN_next2WDDate = date('m/d/Y', strtotime($RN_today.'+2 weekday'));
	$RN_jsonEC['data']['CreatePunchListData']['due_date'] = $RN_next2WDDate;
	// Defects
	$RN_arraPiDefect = array();
	$RN_arrPiDefects = PunchItemDefect::loadAllPunchItemDefect($database, $RN_user_company_id);
	$RN_defectDefaultId = null;
	$RN_kInPiD = 0;
	foreach($RN_arrPiDefects as $RN_kPik => $RN_piDefect){
		$RN_arraPiDefect[$RN_kPik]['id'] = $RN_kPik;
		$RN_arraPiDefect[$RN_kPik]['defect_name'] = $RN_piDefect->defect_name;
		if($RN_kInPiD == 0){
			$RN_defectDefaultId = $RN_kPik;
		}
		$RN_kInPiD++;
	}
	$RN_jsonEC['data']['CreatePunchListData']['defect'] = array_values($RN_arraPiDefect);
	$RN_jsonEC['data']['CreatePunchListData']['defect_default_id'] = $RN_defectDefaultId;
	// recipient
	// $RN_jsonEC['data'] = null;
	$RN_arrRecipient = array();
	$RN_arrProjectTeamMembers = Contact::loadProjectTeamMembers($database, $RN_project_id);
	$RN_recipientDefaultId = null;
	$RN_kInPir = 0;
	foreach($RN_arrProjectTeamMembers as $RN_kcri => $RN_recipient){
		$RN_arrRecipient[$RN_kcri]['contact_id'] = $RN_kcri;
		$RN_arrRecipient[$RN_kcri]['name'] = $RN_recipient->getContactFullName();
		$RN_arrRecipient[$RN_kcri]['email'] = $RN_recipient->email;
		$RN_arrRecipient[$RN_kcri]['contact_company_id'] = $RN_recipient->contact_company_id;
		if($RN_kInPir == 0){
			$RN_recipientDefaultId = $RN_kcri;
		}
		$RN_kInPir++;
	}
	$RN_jsonEC['data']['CreatePunchListData']['initiator'] = array_values($RN_arrRecipient);
	$RN_jsonEC['data']['CreatePunchListData']['default_initiator_id'] = $RN_recipientDefaultId;
	//  last selected recipient id 
	$RN_lastRecipientContactId = PunchItem::findLastPunchItemRecipientByContactId($database, $RN_project_id, $RN_currentlyActiveContactId);
	if($RN_lastRecipientContactId){
		$RN_jsonEC['data']['CreatePunchListData']['recipient_default_id'] = $RN_lastRecipientContactId;
	}
	// $RN_jsonEC['data']['CreatePunchListData'] = null;
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;	
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
