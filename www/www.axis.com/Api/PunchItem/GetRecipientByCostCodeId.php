<?php

$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['CreatePunchListData'] = null;
if(!isset($RN_params['cost_code_id']) || $RN_params['cost_code_id'] == null ){
	$RN_status = '400';
	$RN_errorMessage = 'CostCode Id is required';
}
if($RN_status == 400){
	$RN_jsonEC['status'] = $RN_status;
	$RN_jsonEC['data'] = null;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = $RN_errorMessage;
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
$RN_costCodeId = $RN_params['cost_code_id'];
try {

// Cost Code Subcontractor
		// subcontractor by costCode
	$RN_loadContactsByUserCompanyIdOptions = new Input();
	$RN_loadContactsByUserCompanyIdOptions->forceLoadFlag = false;

	$RN_arrContactsByUserCompanyId = Contact::loadContactsBycostcodeandUserCompanyId($database, $RN_user_company_id, $RN_costCodeId, $RN_project_id, $RN_loadContactsByUserCompanyIdOptions);

	foreach ($RN_arrContactsByUserCompanyId as $RN_contact_id => $RN_contact) {
		/* @var $contact Contact */

		$RN_contactFullNameWithEmail = $RN_contact->getContactFullNameWithEmail(false, '<', '-');
		$RN_encodedContactFullNameWithEmail = Data::entity_encode($RN_contactFullNameWithEmail);

		$RN_contactCompany = $RN_contact->getContactCompany();
		/* @var $contactCompany ContactCompany */
		$RN_contactCompany->htmlEntityEscapeProperties();
		$RN_subContractCCId = $RN_contactCompany->contact_company_id;
		$RN_escaped_contact_company_name = $RN_contactCompany->escaped_contact_company_name;

		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['id'] = htmlspecialchars_decode($RN_escaped_contact_company_name);
		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['name'] = htmlspecialchars_decode($RN_escaped_contact_company_name);
		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['list'][$RN_contact_id]['id'] = $RN_contact_id;
		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['list'][$RN_contact_id]['name'] = htmlspecialchars_decode($RN_encodedContactFullNameWithEmail);
	}
	$RN_initiatorDefaultId = null;
	$RN_kInc = 0;
	foreach($RN_costCodeSubcontractorTmp as $RN_k => $RN_sortValues){
		$RN_costCodeSubcontractorTmp[$RN_k]['list'] = array_values($RN_sortValues['list']);
		if($RN_kInc == 0){
			$RN_initiatorDefaultId = $RN_costCodeSubcontractorTmp[$RN_k]['list'][0]['id'];
		}
		$RN_kInc++;
	}
	
	$RN_jsonEC['data']['CreatePunchListData']['recipient'] = array_values($RN_costCodeSubcontractorTmp);
}
catch(Exception $e){
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
