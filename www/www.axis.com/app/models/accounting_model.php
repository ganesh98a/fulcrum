<?php


function getCompanyData($database, $user_company_id, $contractingEntityId = ''){
	$db = DBI::getInstance($database);
	$db->free_result();

	$arrValues = array($user_company_id);
	$subQuery = '';
	if(!empty($contractingEntityId)){
		$arrValues = array($user_company_id, $contractingEntityId);
		$subQuery = ' AND `accounting`.`contracting_entity_id` = ?';
	}

	$companyTokenDetails = "SELECT * FROM `accounting_portal` INNER JOIN `accounting` ON `accounting_portal`.`id` = `accounting`.`accounting_portal_id` WHERE `accounting`.`company_id`=? AND `accounting_portal`.`is_active_flag` = 'Y'
		AND `accounting`.`is_active_flag` = 'Y'  ".$subQuery." LIMIT 1 ";

	$db->execute($companyTokenDetails, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();

	return $row;
}

function getCompanyRealmData($database, $real_mid){
	$db = DBI::getInstance($database);
	$db->free_result();
	$companyTokenDetails = "SELECT * FROM `accounting_portal` INNER JOIN `accounting` ON `accounting_portal`.`id` = `accounting`.`accounting_portal_id` WHERE `accounting`.`realmID`=? AND `accounting_portal`.`is_active_flag` = 'Y'
		AND `accounting`.`is_active_flag` = 'Y'   LIMIT 1 ";

	$arrValues = array($real_mid);
	$db->execute($companyTokenDetails, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();

	$db->free_result();

	return $row;
}
function getAccountingByCompanyId($database, $usercompanyId, $contractingEntityId = ''){
	$db = DBI::getInstance($database);
	$db->free_result();
	$subQuery = '';
	$arrValues = array($usercompanyId);
	if(!empty($contractingEntityId)){
		$subQuery = ' AND contracting_entity_id= ?';
		$arrValues = array($usercompanyId, $contractingEntityId);	
	}

	$getCompanyData = "SELECT * FROM `accounting` WHERE `company_id`=? ".$subQuery." LIMIT 1 ";
	
	$db->execute($getCompanyData, $arrValues, MYSQLI_USE_RESULT);

	$row = $db->fetch();
	$db->free_result();
	return $row;
}

function updateQBTokenDetails($database,$usercompanyId, $accesstoken){
	$db = DBI::getInstance($database);
	
	$row = getAccountingByCompanyId($database, $usercompanyId);
	$db->free_result();
	if(!empty($row['id'])){ // Company is there
		if(!empty($accesstoken['access_token']) && !empty($accesstoken['refresh_token']) && !empty($accesstoken['realmID'])){
			$updateCompanyData  = "UPDATE `accounting` SET `access_token`='".$accesstoken['access_token']."',`refresh_token`='".$accesstoken['refresh_token']."',`realmID`='".$accesstoken['realmID']."',`access_token_expires`='".$accesstoken['expires_in']."',`refresh_token_expires`='".$accesstoken['x_refresh_token_expires_in']."'  WHERE company_id='".$usercompanyId."'";


			$db->execute($updateCompanyData);	
		}
		
	}

	$db->free_result();

}

function updateQuickbooksData($database, $clientId, $clientSecret, $usercompanyId, $webhooktoken){
	$db = DBI::getInstance($database);
	
	$row = getAccountingByCompanyId($database, $usercompanyId);
	$db->free_result();
	
	if(!empty($row['id'])){ // Company is there
		$updateCompanyData  = "UPDATE `accounting` SET `client_id`='".$clientId."',`client_secret`='".$clientSecret."',`webhook_token`='".$webhooktoken."' WHERE company_id='".$usercompanyId."'";
		$db->execute($updateCompanyData);
		
	}else{
		$inserCompanyData = "INSERT INTO `accounting`( `company_id`, `accounting_portal_id`, `client_id`, `client_secret`,`webhook_token`) 
		VALUES ('".$usercompanyId."','1','".$clientId."','".$clientSecret."','".$webhooktoken."')";
		$db->execute($inserCompanyData);
	}
	 
	$db->free_result();

}

function updateAccountingPortal($database,  $accountPortal, $usercompanyId, $contractingEntityId= '0'){
	$db = DBI::getInstance($database);
	
	$row = getAccountingByCompanyId($database, $usercompanyId, $contractingEntityId);
	$db->free_result();
	if(!empty($row['id'])){ // Company is there
		$updateCompanyData  = "UPDATE `accounting` SET `accounting_portal_id`='".$accountPortal."', `contracting_entity_id` ='".$contractingEntityId."' WHERE company_id='".$usercompanyId."'";
		$db->execute($updateCompanyData);
	}else{
		$inserCompanyData = "INSERT INTO `accounting`( `company_id`, `accounting_portal_id`) VALUES ('".$usercompanyId."','".$accountPortal."')";
		$db->execute($inserCompanyData);
	}
	 
	$db->free_result();	
}

function getAccountingPortals($database){
	$db = DBI::getInstance($database);
	$db->free_result();
	$accountingportal_sql = "SELECT * FROM `accounting_portal` ";
	$db->execute($accountingportal_sql);
	$accountingportals = array();
	while ($accountingportal = $db->fetch()) {
		$accountingportals[$accountingportal['id']] = $accountingportal['portal'];
	}
	$db->free_result();	
	return $accountingportals;
}

function update_customerid($database, $signBlockId, $QBCustId){
	$db = DBI::getInstance($database);
	$db->free_result();
	$getCompanyData = "SELECT `id` FROM `draw_signature_blocks` WHERE `id`='$signBlockId'  LIMIT 1 ";
	$db->execute($getCompanyData);

	$row = $db->fetch();
	$db->free_result();
	if(!empty($row['id'])){ // Company is there
		$updateCompanyData  = "UPDATE `draw_signature_blocks` SET `quickbook_cust_id`='".$QBCustId."' WHERE id='".$signBlockId."'";
		$db->execute($updateCompanyData);
	}
	$db->free_result();	
}

function update_invoiceid($database, $drawId, $QBInvoiceId){
	$db = DBI::getInstance($database);
	$db->free_result();
	$getCompanyData = "SELECT `id` FROM `draws` WHERE `id`='$drawId'  LIMIT 1 ";
	$db->execute($getCompanyData);

	$row = $db->fetch();
	$db->free_result();
	if(!empty($row['id'])){ // Company is there
		$updateCompanyData  = "UPDATE `draws` SET `quickbook_invoice_id`='".$QBInvoiceId."', `added_to_qb` = 'Y' WHERE id='".$row['id']."'";
		$db->execute($updateCompanyData);
	}
	$db->free_result();	
}

function update_itemid($database, $drawId, $QBItemId){
	$db = DBI::getInstance($database);
	$db->free_result();
	$getCompanyData = "SELECT `id` FROM `draws` WHERE `id`='$drawId'  LIMIT 1 ";
	$db->execute($getCompanyData);

	$row = $db->fetch();
	$db->free_result();
	if(!empty($row['id'])){ // Company is there
		$updateCompanyData  = "UPDATE `draws` SET `quickbook_item_id`='".$QBItemId."' WHERE id='".$row['id']."'";
		$db->execute($updateCompanyData);
	}
	$db->free_result();

}

/*function get_qb_custidbyname($database,$description){

	
	$db = DBI::getInstance($database);
	$db->free_result();
	$getCustomerData = "SELECT * FROM `draw_signature_blocks` WHERE `description` = ? AND `quickbook_cust_id` != 0  LIMIT 1 ";
	$arrValues = array($description);
	$db->execute($getCustomerData, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();	
	$qbcustid = '';
	if(!empty($row['id'])){ // Company is there
		$qbcustid = $row['quickbook_cust_id'];
	}
	return $qbcustid;
}*/

function getactivedraws($database, $projectid){
	$db = DBI::getInstance($database);
	$db->free_result();
	$getDrawsData = "SELECT `draws`.`id`,`draw_status`.`status`,`draws`.`quickbook_invoice_id`,`draws`.`application_number`,`draws`.`project_id` FROM `draws` INNER JOIN `draw_status` ON `draws`.`status` = `draw_status`.`id` WHERE `draws`.`added_to_qb` = 'Y' AND `draws`.`project_id` IN (".$projectid.") AND  `draw_status`.`id` NOT IN ('1','4') ";
	$db->execute($getDrawsData);

	$draw_arr = array();
	while($draws = $db->fetch()){
		$draw_arr[] = $draws;
	}
	$db->free_result();

	return $draw_arr;
}


function updateqbstatus($database, $drawId, $drawstatus){
	$db = DBI::getInstance($database);
	$db->free_result();
	$getDrawData = "SELECT * FROM `draws` WHERE `id`= ?  LIMIT 1 ";
	$arrValues = array($drawId);
	$db->execute($getDrawData, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();

	if(!empty($row['id'])){ // Company is there
		$getDrawStatus = "SELECT `id` FROM `draw_status` WHERE `status`=?  LIMIT 1 ";
		$arrValues = array($drawstatus);
		$db->execute($getDrawStatus, $arrValues, MYSQLI_USE_RESULT);
		$drawstatus =  $db->fetch();
		$db->free_result();
		//print_r($drawstatus); //die;
		if(!empty($drawstatus['id'])){
			$updateCompanyData  = "UPDATE `draws` SET `status`=? WHERE id=?";
			$arrValues = array($drawstatus['id'],$row['id']);
			$db->execute($updateCompanyData, $arrValues, MYSQLI_USE_RESULT);
		}
		
	}
	$db->free_result();	

}
function getQBCompanies($database){

	$db = DBI::getInstance($database);
	$db->free_result();
	$getDrawsData = "SELECT GROUP_CONCAT(`projects`.id) AS company_project_id , `accounting`.*  FROM `projects` INNER JOIN `accounting` ON `projects`.`user_company_id` = `accounting`.`company_id`  WHERE `projects`.`is_active_flag` ='Y' GROUP BY `accounting`.`company_id`";
	$db->execute($getDrawsData);

	$draw_arr = array();
	while($qb_company = $db->fetch()){
		//print_r($draws);
		$qb_company_arr[] = $qb_company;
	}
	$db->free_result();
	return $qb_company_arr;

}
function getDrawData($database,$QuickBookKeys, $invoiceId){
	$db = DBI::getInstance($database);
	$db->free_result();
	$getDrawData = "SELECT `draws`.`id`,`draw_status`.`status`,`draws`.`quickbook_invoice_id` FROM `draws`   INNER JOIN  `projects` ON `draws`.`project_id` = `projects`.`id`INNER JOIN `draw_status` ON `draws`.`status` = `draw_status`.`id` WHERE `projects`.`user_company_id` = ? AND `draws`.`quickbook_invoice_id`=?  LIMIT 1 ";

/*	$getDrawData = "SELECT `draws`.`id`,`draw_status`.`status`,`draws`.`quickbook_invoice_id` FROM `draws`  INNER JOIN `draw_status` INNER JOIN  ON `draws`.`status` = `draw_status`.`id` WHERE  `draws`.`quickbook_invoice_id`=?  LIMIT 1 ";*/
	$arrValues = array($QuickBookKeys['company_id'], $invoiceId);
	$db->execute($getDrawData, $arrValues, MYSQLI_USE_RESULT);

	$draw = $db->fetch();
	$db->free_result();
	
	return $draw;
}

function addQBerrorLog($database,$errorArr){
	$db = DBI::getInstance($database);
	$db->free_result();

	$getDrawData = "INSERT INTO `accounting_log`( `draw_id`, `application_number`, `project_id`, `user_id`, `quickbook`, `log`, `date`) VALUES (?,?,?,?,?,?,'".date('Y-m-d H:i:s')."')";
	
	$arrValues = array($errorArr['draw_id'], $errorArr['application_number'], $errorArr['project_id'], $errorArr['user_id'], $errorArr['quickbook'], $errorArr['log']);
	$db->execute($getDrawData, $arrValues, MYSQLI_USE_RESULT);

	$db->free_result();
}

function overAllDrawCount($database, $projectids){
	$db = DBI::getInstance($database);
	$db->free_result();
	$overallinvoice = "SELECT count(*) as total_invoice  FROM `draws` INNER JOIN `draw_status` ON `draws`.`status` = `draw_status`.`id` WHERE `draws`.`added_to_qb` = 'Y'  AND `draws`.`quickbook_invoice_id` != 0  AND `draws`.`project_id` IN (".$projectids.") AND  `draw_status`.`id` NOT IN ('1','4') ";
	$db->execute($overallinvoice);
	$row_total = $db->fetch();
	$db->free_result();
	return $row_total;

}
function getInvoicearr($database, $projectids, $limit, $offset){
	$db = DBI::getInstance($database);
	$db->free_result();
	$getactivedraw = "SELECT `draws`.`id`,`draw_status`.`status`,`draws`.`quickbook_invoice_id`,`draws`.`application_number`,`draws`.`project_id` FROM `draws` INNER JOIN `draw_status` ON `draws`.`status` = `draw_status`.`id` WHERE `draws`.`added_to_qb` = 'Y'  AND `draws`.`quickbook_invoice_id` != 0  AND `draws`.`project_id` IN (".$projectids.") AND  `draw_status`.`id` NOT IN ('1','4')  LIMIT ".$limit." OFFSET ".$offset;

	$db->execute($getactivedraw);
	$invoicearr = array();
	$drawidarr = array();
	$draw_count = 0;
	$return_arr = array();
	while($row = $db->fetch()){
		
		$invoicearr[] = $row['quickbook_invoice_id'];
		$drawidarr[$row['quickbook_invoice_id']] = array();
		$drawidarr[$row['quickbook_invoice_id']]['draw_id'] =  $row['id'];
		$drawidarr[$row['quickbook_invoice_id']]['draw_status'] =  $row['status'];
		$drawidarr[$row['quickbook_invoice_id']]['project_id'] =  $row['project_id'];
		$drawidarr[$row['quickbook_invoice_id']]['application_number'] =  $row['application_number'];
		$draw_count++;
	}

	$return_arr['draw_count'] = $draw_count;
	$return_arr['invoice_arr'] = $invoicearr;
	$return_arr['drawidarr'] = $drawidarr;


	$db->free_result();

	return $return_arr;

}

function getAccountingLog($database){
	$db = DBI::getInstance($database);
	$db->free_result();
		
	$db->execute("SELECT `id`, `draw_id`, `application_number`, `project_id`, `user_id`, `quickbook`, `log`, `date` FROM `accounting_log` ORDER BY id DESC");
	$accountinglog_arr = array();

	while($row = $db->fetch()){
		$accountinglog_arr[] = $row;
	} 
	$db->free_result();
	return $accountinglog_arr;
}

function checkAndInsertProjectCustomer($database, $params_arr = array())
{ // Get the Max Project Customer Imported in Fulcrum and Get the latest project mapped Customer

	$db = DBI::getInstance($database);
	$db->free_result();

	
	$getProjectCustomer = "SELECT * FROM `qb_customers` WHERE `company_id` = ? AND `project_customer` = ? AND `realmID` = ?";
	$arrValues = array($params_arr['user_company_id'], $params_arr['project_customer'], $params_arr['realmID']);
	$db->execute($getProjectCustomer, $arrValues, MYSQLI_USE_RESULT);

	$row = $db->fetch();
	$db->free_result();
	if(empty($row)){

		$insertProjectCustomer = "INSERT INTO `qb_customers`( `company_id`, `qb_project_cust_id`, `qb_cust_id`, `realmID`, `customer`, `project`, `project_customer`, `created_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

		$insertValues = array($params_arr['user_company_id'], $params_arr['qb_project_cust_id'], $params_arr['qb_cust_id'], $params_arr['realmID'], $params_arr['customer'], $params_arr['project'], $params_arr['project_customer'], date('Y-m-d H:i:s'));

		$db->execute($insertProjectCustomer, $insertValues, MYSQLI_USE_RESULT);
		$db->free_result();

	}
}
function getProjectCustomers($database,$user_company_id){

	$db = DBI::getInstance($database);
	$db->free_result();
	$company_data = getCompanyData($database, $user_company_id);
	$company_realMid = '';


	if(!empty($company_data['realmID'])){
		$company_realMid = $company_data['realmID'];
	}
	$getProjectCustomer = "SELECT * FROM `qb_customers` WHERE `company_id` = ? AND project_customer != '' AND `realmID` = ?";
	$db->execute($getProjectCustomer, array($user_company_id, $company_realMid), MYSQLI_USE_RESULT);
	$projectCustomerArr = array();
	while($row = $db->fetch()){
		$projectCustomerArr[$row['id']] = $row['project_customer'];
	}

	return $projectCustomerArr;

}

function CheckandUpdateQBCustomer($database, $params_arr = array()){
	$db = DBI::getInstance($database);
	$db->free_result();
	if(!empty($params_arr['customer'])){
		
		$getCustomerDataQuery = "SELECT * FROM qb_customers WHERE customer = ? AND company_id = ? LIMIT 1";
		$arrValues = array($params_arr['customer'],$params_arr['user_company_id']);
		$db->execute($getCustomerDataQuery, $arrValues, MYSQLI_USE_RESULT);
		$getCustomerData = $db->fetch();
		$db->free_result();
		if(!empty($getCustomerData)){
			TableService::UpdateTabularData($database, 'qb_customers', 'qb_cust_id', $getCustomerData['id'], $params_arr['customer_id']);
		}else{
			$insertProjectCustomer = "INSERT INTO `qb_customers`( `company_id`, `project_id`, `qb_cust_id`, `customer`,  `created_date`) VALUES (?, ?, ?, ?, ?)";

			$insertValues = array($params_arr['user_company_id'], $params_arr['project_id'], $params_arr['customer_id'], $params_arr['customer'], date('Y-m-d H:i:s'));
			$db->execute($insertProjectCustomer, $insertValues, MYSQLI_USE_RESULT);
		}
	}
}

function addAccount($database, $params_arr = array()){
	$db = DBI::getInstance($database);
	$db->free_result();

	$insertAccountDetails = "INSERT INTO `qb_accounts`( `company_id`, `realmID`, `qb_account_id`, `name`, `sub_account`, `classification`, `account_type`, `account_sub_type`, `created_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

	$insertValues = array($params_arr['company_id'], $params_arr['realmID'], $params_arr['qb_account_id'], $params_arr['name'], $params_arr['sub_account'], $params_arr['classification'], $params_arr['account_type'], $params_arr['account_sub_type'],  date('Y-m-d H:i:s'));

	$db->execute($insertAccountDetails, $insertValues, MYSQLI_USE_RESULT);
}

function qb_api_error_log($database, $errorlog_arr){ // Common function to store the QB Api Error Log
	$db = DBI::getInstance($database);
	$db->free_result();

	$session = Zend_Registry::get('session');
	$user_company_id = $session->getUserCompanyId();
	$user_id = $session->getUserId();
	$user_company_id = $session->getUserCompanyId();
	$project_id = $session->getCurrentlySelectedProjectId();
	$error_log_arr = array('item_id'=>$errorlog_arr['item_id'], 'company_id'=>$user_company_id, 'project_id'=>$project_id, 'user_id'=>$user_id, 'error_code'=>'', 'error_element'=>'', 'item_type'=>$errorlog_arr['item_type'], 'error_type'=>'', 'error_message'=>'', 'error_detail'=>'', 'error_log'=>$errorlog_arr['errorlog'], 'date_time'=>date('Y-m-d H:i:s'));
	
	$error_xml_arr = simplexml_load_string($errorlog_arr['errorlog']);

	if(!empty($error_xml_arr)){
		$error_array = json_decode(json_encode($error_xml_arr), true);
		if(!empty($error_array['Fault']['@attributes']['type'])){
			$error_log_arr['error_type'] = $error_array['Fault']['@attributes']['type'];
		}
		if(!empty($error_array['Fault']['Error']['@attributes']['code'])){
			$error_log_arr['error_code'] = $error_array['Fault']['Error']['@attributes']['code'];
		}
		if(!empty($error_array['Fault']['Error']['@attributes']['element'])){
			$error_log_arr['error_element'] = $error_array['Fault']['Error']['@attributes']['element'];
		}
		if(!empty($error_array['Fault']['Error']['Message'])){
			$error_log_arr['error_message'] = $error_array['Fault']['Error']['@attributes']['code'];
		}
		if(!empty($error_array['Fault']['Error']['Detail'])){
			$error_log_arr['error_detail'] = $error_array['Fault']['Error']['Detail'];	
		}	
	}

	$error_log_insert_query = "INSERT INTO `qb_api_log`( ".implode(', ',array_keys($error_log_arr))." ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
	$db->execute($error_log_insert_query, array_values($error_log_arr), MYSQLI_USE_RESULT);
	$insert_id = $db->insertId;
	$db->free_result();
	return $insert_id;
}

?>
