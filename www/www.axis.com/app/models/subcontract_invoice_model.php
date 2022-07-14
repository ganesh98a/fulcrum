<?php

function getContractsArrData($database, $user_company_id, $project_id, $contact_company_id,$project_index){

	$db = DBI::getInstance($database);
	$db->free_result();

	if(!empty($project_index) && $project_index == '1'){
		$jointable = 'INNER JOIN `contact_companies` cmp ON cmp.id =  ven.`vendor_contact_company_id`';
		$wherecond = " bd.`project_id`  = ?  AND  cmp.contact_user_company_id = ?";
		$arrValues = array($project_id,$user_company_id);
	}else{
		$jointable = '';
		$wherecond = "bd.`project_id`  = ? AND bd.`user_company_id` = ? AND  ven.`vendor_contact_company_id` =?";
		$arrValues = array($project_id,$user_company_id, $contact_company_id);
	}

	$query = "SELECT 
				ccd.`division_number`,
				codes.`cost_code`,
				codes.`cost_code_description`,
				sub.`subcontract_sequence_number`,
				sub.`id` as subcontract_id,
				sub.`subcontract_actual_value`,
				subt.`subcontract_type`
			FROM `gc_budget_line_items` AS bd 
			INNER JOIN `subcontracts` AS sub ON bd.`id` =  sub.`gc_budget_line_item_id` 
			INNER JOIN `subcontract_templates` subtemp ON sub.`subcontract_template_id` = subtemp.`id`
			INNER JOIN `subcontract_types` subt ON  subtemp.`subcontract_type_id` = subt.`id`
			INNER JOIN `vendors` AS ven ON ven.`id` = sub.`vendor_id`
			INNER JOIN `cost_codes` codes ON codes.`id` = bd.`cost_code_id`
			INNER JOIN `cost_code_divisions` ccd ON ccd.`id` = codes.`cost_code_division_id`
			{$jointable}
			WHERE 	{$wherecond} ";
	
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$contract_arr = array();
	while ($row = $db->fetch()) {
		$SCOAmt = SCOAmountAginstSubcontractor($database,$row['subcontract_id']);
		$contract_amount = $row['subcontract_actual_value'] + $SCOAmt;
		
		$contract_arr[$row['subcontract_id']] = $row['division_number'].'-'.$row['cost_code'].' | '.$row['cost_code_description'].' | ($'.$contract_amount.') | '.$row['subcontract_type'];
	}
	$db->free_result();


	return $contract_arr;
}
function getCostCodeBasedonSubcontract($database, $contract_id){
	$db = DBI::getInstance($database);
	$db->free_result();
	$query = "SELECT 
				`gc_budget_line_items`.`cost_code_id` 
			FROM `subcontracts`
				INNER JOIN `gc_budget_line_items` 
			ON `subcontracts`.`gc_budget_line_item_id` = `gc_budget_line_items`.`id` 
				WHERE `subcontracts`.`id` = ? ";
	$db->execute($query, array($contract_id), MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$cost_code_id = $row['cost_code_id'];

	return $cost_code_id;
}

function getCostCodeData($database, $user_company_id, $project_id, $vendor_id,$contract_id){
	$db = DBI::getInstance($database);
	$db->free_result();

	$query = "SELECT ccd.`division_number`,
				codes.`cost_code`, codes.`cost_code_description` 
			FROM `gc_budget_line_items` AS bd 
			INNER JOIN `subcontracts` AS sub ON bd.`id` =  sub.`gc_budget_line_item_id` 
			INNER JOIN `vendors` AS ven ON ven.`id` = sub.`vendor_id`
			INNER JOIN `cost_codes` codes ON codes.`id` = bd.`cost_code_id`
			INNER JOIN `cost_code_divisions` ccd ON ccd.`id` = codes.`cost_code_division_id`
			WHERE bd.`project_id`  = ? AND bd.`user_company_id` = ?  AND bd.`cost_code_id` = ?";
	$arrValues = array($project_id,$user_company_id,  $contract_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$costcode_data = $row['division_number'].$row['cost_code'].' '.$row['cost_code_description'];
	$db->free_result();

	return $costcode_data;
}

function getGLAccountDetail($database, $user_company_id, $project_id, $vendor_id,$cost_code_id){
	$db = DBI::getInstance($database);
	$db->free_result();

	$query = "SELECT bd.`id`, bd.`project_id`,sub.`gc_budget_line_item_id`,
				sub.`vendor_id`,ven.`id`,ven.`vendor_contact_company_id`, qbacct.* 
			FROM `gc_budget_line_items` AS bd 
			INNER JOIN `subcontracts` AS sub ON bd.`id` =  sub.`gc_budget_line_item_id` 
			INNER JOIN `vendors` AS ven ON ven.`id` = sub.`vendor_id`
			INNER JOIN `subcontract_templates` subtemp ON subtemp.`id` = sub.`subcontract_template_id`
			INNER JOIN `qb_subcontract_accounts` `qbacct` ON `qbacct`.`subcontract_type_id` = `subtemp`.`subcontract_type_id`
			WHERE `bd`.`project_id`  = ? AND `bd`.`user_company_id` = ?  AND `bd`.`cost_code_id` = ? AND ven.`vendor_contact_company_id` = ? AND qbacct.`company_id` = ? ";
	$arrValues = array($project_id, $user_company_id, $cost_code_id, $vendor_id, $user_company_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$qb_account_id = '';
	if(!empty($row['qb_account_id'])){
		$qb_account_id = $row['qb_account_id'];	
	}
	
	$db->free_result();	
	return $qb_account_id;
}
function getVendorsArrData($database,$user_company_id,$project_id,$project_index){

	$db = DBI::getInstance($database);
	$db->free_result();
	if(!empty($project_index) && $project_index == '1'){
		$wherecond = "bd.`project_id` = ?";
		$arrValues = array($project_id);
	}else{
		$wherecond = "bd.`project_id` = ? AND bd.`user_company_id` = ?";
		$arrValues = array($project_id,$user_company_id);
	}

	$query =
	"SELECT bd.`id`, bd.`project_id`,sub.`gc_budget_line_item_id`,sub.`vendor_id`,ven.`id`,ven.`vendor_contact_company_id` ,con.`company` FROM `gc_budget_line_items` AS bd INNER JOIN `subcontracts` AS sub ON bd.`id` = sub.`gc_budget_line_item_id` INNER JOIN `vendors` AS ven ON ven.`id` = sub.`vendor_id` INNER JOIN `contact_companies` AS con ON con.`id` = ven.`vendor_contact_company_id` WHERE ".$wherecond." GROUP BY ven.`vendor_contact_company_id` ORDER BY con.`company` ASC";
	
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$vendorarr = array();
	while ($row = $db->fetch()) {
		$vendorarr[$row['vendor_contact_company_id']] = $row['company'];
	}
	$db->free_result();
	return $vendorarr;

}

function getSubContInvoiceArrDataSecOne($database, $project_id, $vendor_id, $showallinvoice){

	$db = DBI::getInstance($database);
	$db->free_result();

	$wherecond_arr = array();
	if(empty($vendor_id)){
		$arrValues = array($project_id);
		$wherecond_arr = array("si.`project_id` = ?");
	}else{
		$arrValues = array($project_id, $vendor_id);
		$wherecond_arr = array("si.`project_id` = ?", " si.`vendor_id` = ?");
	}
	if($showallinvoice == 'false'){ // Hide the QB with Paid , Overdue, Open
		$wherecond_arr[] = "si.`subcontract_invoice_status_id` NOT IN ('2','7','8','9','10','11','12')";
	}else{
		$wherecond_arr[] = "si.`subcontract_invoice_status_id` NOT IN ('2','10','11','12')";
	}
	
	$wherecond = implode(' AND ', $wherecond_arr);
	

	$query = "SELECT si.*,con.`company`, file.`id` AS file_id, file.`virtual_file_name`, file.`virtual_file_mime_type`,file.`file_manager_folder_id` FROM `subcontract_invoices` AS si INNER JOIN `contact_companies` AS con ON con.`id` = si.`vendor_id` LEFT JOIN `file_manager_files` as file ON file.`id` = si.`invoice_files`  WHERE {$wherecond} ORDER BY si.`id` DESC";
	
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$invoicearr = array();
	while ($row = $db->fetch()) {
		$invoicearr[] = $row;
	}
	$db->free_result();
	return $invoicearr;
}

function getSubContInvoiceArrDataSecTwo($database, $project_id, $vendor_id){

	$db = DBI::getInstance($database);
	$db->free_result();

	$wherecond_arr = array();
	if(empty($vendor_id)){
		$arrValues = array($project_id);
		$wherecond_arr = array("si.`project_id` = ?");
	}else{
		$arrValues = array($project_id, $vendor_id);
		$wherecond_arr = array("si.`project_id` = ?", " si.`vendor_id` = ?");
	}
	
	$wherecond_arr[] = "si.`subcontract_invoice_status_id` IN ('2','10','11','12')";	
	
	$wherecond = implode(' AND ', $wherecond_arr);	

	$query = "SELECT si.*,con.`company`, file.`id` AS file_id, file.`virtual_file_name`, file.`virtual_file_mime_type`,file.`file_manager_folder_id` FROM `subcontract_invoices` AS si INNER JOIN `contact_companies` AS con ON con.`id` = si.`vendor_id` LEFT JOIN `file_manager_files` as file ON file.`id` = si.`invoice_files`  WHERE {$wherecond} ORDER BY si.`id` DESC";
	
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$invoicearr = array();
	while ($row = $db->fetch()) {
		$invoicearr[] = $row;
	}
	$db->free_result();
	return $invoicearr;
}

function createSubContInvoice($database,$insertarr){

	$db = DBI::getInstance($database);
	$db->free_result();

	$query = "INSERT INTO `subcontract_invoices`(`project_id`, `vendor_id`, `subcontract_id`, `cost_code_id`, `recieved_date`, `application_number`, `period_to`, `amount`, `retention`, `total`, `subcontract_invoice_status_id`, `notes`,`pm_approved`, `qb_customer_id`, `created_by`, `modified_by`, `created`, `modified`,`contract_remaining`) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";


	$arrValues = array_values($insertarr);

	$return_arr = array();

	$return_arr['status'] = "N";
	$return_arr['invoice_id'] = '';
	if($db->execute($query, $arrValues, MYSQLI_USE_RESULT)){
		$return_arr['status'] = "Y";
		$return_arr['invoice_id'] = $db->insertId;
	}
	$db->free_result();
	
	return $return_arr;
}

// to crete a supplier 
function createSuppliers($database,$insertarr){

	$db = DBI::getInstance($database);
	$db->free_result();

	 $query = "INSERT INTO `supplier_for_subcontractorlog`(`invoice_id`, `prelim_id`, `Amount`) VALUES (?,?, ?)";
	$arrValues = array_values($insertarr);
	$return_arr = array();
	$return_arr['status'] = "N";
	$return_arr['supplier_id'] = '';
	if($db->execute($query, $arrValues, MYSQLI_USE_RESULT)){
		$return_arr['status'] = "Y";
		$return_arr['supplier_id'] = $db->insertId;
	}
	$db->free_result();
	
	return $return_arr;
}

function getSubcontractInvoiceStatus($database){
	$db = DBI::getInstance($database);
	$db->free_result();
	$SubcontractInvoiceStatus_sql = "SELECT * FROM `subcontract_invoice_status` WHERE is_active_flag = 'Y' ";
	$db->execute($SubcontractInvoiceStatus_sql);
	$SubcontractInvoiceStatus_arr = array();
	while ($SubcontractInvoiceStatus = $db->fetch()) {
		$SubcontractInvoiceStatus_arr[$SubcontractInvoiceStatus['id']] = $SubcontractInvoiceStatus['status'];
	}
	$db->free_result();	
	return $SubcontractInvoiceStatus_arr;

}

function update_subinvoiceid($database, $invoiceId, $fileId){
	$db = DBI::getInstance($database);
	$row = getSubContInvoiceData($database, $invoiceId);
	if(!empty($row['id'])){ // Company is there
		$updateInvoiceData  = "UPDATE `subcontract_invoices` SET `invoice_files`='".$fileId."' WHERE id='".$invoiceId."'";
		$db->execute($updateInvoiceData);
	}
	$db->free_result();	
}

function update_statusid($database, $invoiceId, $statusId){

	$db = DBI::getInstance($database);

	$invoice_row = getSubContInvoiceData($database, $invoiceId);

	$getStatusData = "SELECT * FROM `subcontract_invoice_status` WHERE `id`= ? LIMIT 1 ";
	$db->execute($getStatusData, array($statusId), MYSQLI_USE_RESULT);

	$status_row = $db->fetch();
	$db->free_result();
	$returnval = 'N';
	if(!empty($invoice_row['id'])){ // Company is there
		$updatepmapproved = '';
		$update_arr =  array($statusId);
		if(!empty($status_row['status']) && $status_row['status'] != 'Pending PM Approval' && $invoice_row['pm_approved'] == '0000-00-00' ){
				$updatepmapproved = ",`pm_approved`= ?";
				$update_arr[] = date('Y-m-d');
		}

		$update_arr[] = $invoiceId;
		$updateInvoiceData  = "UPDATE `subcontract_invoices` SET `subcontract_invoice_status_id`=?  ".$updatepmapproved."WHERE id=?";
		$db->execute($updateInvoiceData, $update_arr, MYSQLI_USE_RESULT);
		$returnval = 'Y';
	}
	$db->free_result();	
	return $returnval;

}
function getSubContInvoiceData($database, $invoiceId){
	$db = DBI::getInstance($database);
	$db->free_result();
	$getInvoiceData = "SELECT * FROM `subcontract_invoices` WHERE `id`=?  LIMIT 1 ";
	$db->execute($getInvoiceData, array($invoiceId), MYSQLI_USE_RESULT);

	$invoice_row = $db->fetch();
	$db->free_result();
	return $invoice_row;
}
function deleteSubContInvoice($database, $invoiceId){
	$db = DBI::getInstance($database);
	$db->free_result();

	$query = "DELETE FROM `subcontract_invoices` WHERE `id` = ? ";
	$arrValues = array($invoiceId);
	$returnval = 'N';
	if($db->execute($query, $arrValues, MYSQLI_USE_RESULT)){
		$returnval = 'Y';
	}

	
	$db->free_result();
	return $returnval;
}

function update_notes($database, $update_arr){
	
	$db = DBI::getInstance($database);

	$row = getSubContInvoiceData($database, $update_arr['invoiceId']);
	$returnval = 'N';
	if(!empty($row['id'])){ // Company is there
		$updateInvoiceData  = "UPDATE `subcontract_invoices` SET `notes`=?, `modified_by`= ?,`modified`=? WHERE `id` = ? ";
		$arrValues = array($update_arr['notes'], $update_arr['user_id'],date('Y-m-d H:i:s'), $update_arr['invoiceId']);
		if($db->execute($updateInvoiceData,$arrValues,MYSQLI_USE_RESULT)){
			$returnval = 'Y';
		}
	}
	$db->free_result();	
	return $returnval;
}

function update_invoice_total($database, $update_arr){
	
	$db = DBI::getInstance($database);

	$row = getSubContInvoiceData($database, $update_arr['invoiceId']);
	$returnval = 'N';
	if(!empty($row['id'])){ // Company is there
		$updateInvoiceData  = "UPDATE `subcontract_invoices` SET `total`=?, `modified_by`= ?,`modified`=? WHERE `id` = ? ";
		$arrValues = array($update_arr['value'], $update_arr['user_id'],date('Y-m-d H:i:s'), $update_arr['invoiceId']);
		if($db->execute($updateInvoiceData,$arrValues,MYSQLI_USE_RESULT)){
			$returnval = 'Y';
		}
	}
	$db->free_result();	
	return $returnval;
}

function getVendor($database, $vendor_id){
	$db = DBI::getInstance($database);
	$db->free_result();

	$getVendorData = "SELECT * FROM `contact_companies` WHERE `id`= ?  LIMIT 1 ";
	$db->execute($getVendorData,array($vendor_id),MYSQLI_USE_RESULT);
	$vendor_row = $db->fetch();
	$db->free_result();

	return $vendor_row;
}

function getContract($database, $cost_code_id){
	$db = DBI::getInstance($database);
	$db->free_result();
	
	$getContractData = "SELECT  ccd.`division_number`, ccd.`division_code_heading`, ccd.`division`, codes.`cost_code`, codes.`cost_code_description` FROM `cost_codes` AS codes INNER JOIN `cost_code_divisions`  AS ccd ON `codes`.`cost_code_division_id`  = `ccd`.id  WHERE `codes`.id = ?  LIMIT 1 ";
	$db->execute($getContractData, array($cost_code_id), MYSQLI_USE_RESULT);
	$contract_row = $db->fetch();
	$db->free_result();

	return $contract_row;
}

function update_qb_expenseid($database, $invoiceId, $expnse_id){
	$db = DBI::getInstance($database);
	$row = getSubContInvoiceData($database, $invoiceId);
	$returnval = 'N';
	if(!empty($row['id'])){ // Company is there
		$updateInvoiceData  = "UPDATE `subcontract_invoices` SET `qb_expense_id`='".$expnse_id."' WHERE id='".$invoiceId."'";
		if($db->execute($updateInvoiceData, array())){
			$returnval = 'Y';
		}
	}
	$db->free_result();	
	return $returnval;
}

function update_qb_attachmentid($database, $invoiceId, $attachmentId){
	$db = DBI::getInstance($database);
	$row = getSubContInvoiceData($database, $invoiceId);
	$returnval = 'N';
	if(!empty($row['id'])){ // Company is there
		$updateInvoiceData  = "UPDATE `subcontract_invoices` SET `qb_attachment_id`='".$attachmentId."' WHERE id='".$invoiceId."'";
		if($db->execute($updateInvoiceData)){
			$returnval = 'Y';
		}
	}
	$db->free_result();	
	return $returnval;
}

function checkExistenceInvoice($database, $param_arr){

	$db = DBI::getInstance($database);
	$db->free_result();	
	$getInvoiceData = "SELECT `id` FROM `subcontract_invoices` WHERE `vendor_id`= ? AND `cost_code_id` = ? AND  `period_to` = ? AND `application_number` = ?  LIMIT 1 ";

	$arrValues = array($param_arr[VENDOR_ID], $param_arr[COST_CODE_ID], $param_arr[PERIOD_TO], $param_arr[APPLICATION_NUMBER]);
	$db->execute($getInvoiceData, $arrValues, MYSQLI_USE_RESULT);

	$invoice_row = $db->fetch();
	$db->free_result();

	return $invoice_row;

}

function getSubContractInoiceSummary($database, $param_arr , $paid = ''){
	$db = DBI::getInstance($database);
	$db->free_result();	

	if(!empty($paid)){

		$paid_status_id = '8';

		$wherecond = "`project_id` = ? AND `vendor_id` = ? AND `subcontract_invoice_status_id` = ? ";
		$arrValues = array($param_arr[PROJECT_ID], $param_arr[VENDOR_ID], $paid_status_id);
	}else{
		$wherecond = "`project_id` = ? AND `vendor_id` = ? ";
		$arrValues = array($param_arr[PROJECT_ID], $param_arr[VENDOR_ID]);

	}

	$getContractSummaryData = "SELECT SUM(`amount`) as `total_amount`, SUM(`retention`) as `total_retention` , (SUM(`amount`) - SUM(`retention`)) as `total_summary` FROM `subcontract_invoices` WHERE {$wherecond} ";

	

	$db->execute($getContractSummaryData, $arrValues, MYSQLI_USE_RESULT);

	$summary_data = $db->fetch();
	$db->free_result();

	return $summary_data;
}

function getSubContractSummaryData($database, $param_arr){
	$db = DBI::getInstance($database);
	$db->free_result();	
	$contract_summary_data = "SELECT bd.`id`, bd.`project_id`,sub.`gc_budget_line_item_id`,sub.`vendor_id`,sub.`subcontract_actual_value`,ven.`id`,ven.`vendor_contact_company_id` ,con.`company`, cd.`division_number`,cod.`cost_code`,cod.`cost_code_description`,bd.`cost_code_id`,sub.id as subcontract_id FROM `gc_budget_line_items` AS bd INNER JOIN `subcontracts` AS sub ON bd.`id` = sub.`gc_budget_line_item_id` INNER JOIN `vendors` AS ven ON ven.`id` = sub.`vendor_id` INNER JOIN `contact_companies` AS con ON con.`id` = ven.`vendor_contact_company_id` INNER JOIN `cost_codes` cod ON bd.`cost_code_id` = cod.`id` INNER JOIN `cost_code_divisions` cd ON cod.`cost_code_division_id` = cd.`id` WHERE bd.`project_id` = ? AND ven.`vendor_contact_company_id` = ?";

	$arrValues = array($param_arr[PROJECT_ID], $param_arr[VENDOR_ID]);

	$db->execute($contract_summary_data, $arrValues, MYSQLI_USE_RESULT);

	$summary_data_arr = array();
	while ($summary_data = $db->fetch()) {
		
		$summary_data_arr[] = $summary_data;
	}
	$db->free_result();
	return $summary_data_arr;
}
function getChangeOrderData($database, $cost_code_id,$project_id,$filter='all',$gc_budget_line_item_id=null,$subcontract_id){
	$db = DBI::getInstance($database);
	$query1 = "SELECT sd.*,cc.`company` FROM `subcontract_change_order_data` AS sd INNER JOIN `contact_companies` AS cc ON cc.`id` = sd.`subcontract_vendor_id` WHERE sd.`costcode_id` = '$cost_code_id' AND sd. `project_id`= '$project_id' AND subcontractor_id='$subcontract_id' AND sd.`status` IN ('approved') ORDER BY sd.`status` ASC, CAST(SUBSTR(approve_prefix , 5, LENGTH(approve_prefix)) AS UNSIGNED) ASC";
    $db->execute($query1);
    $scoArr =array();
    while ($row1 = $db->fetch()){
    	
    	$eachscoarr['sequence_number']    =$row1['sequence_number'];
    	$eachscoarr['title'] 				=$row1['title'];
    	$eachscoarr['description'] 		=$row1['description'];
    	$eachscoarr['estimated_amount_raw'] = $row1['estimated_amount'];
    	$eachscoarr['estimated_amount'] 	= $row1['estimated_amount'];
    	$estimated_amount = $row1['estimated_amount'];
    	$eachscoarr['status_notes'] 		=$row1['status_notes'];
       	$eachscoarr['company']			=$row1['company'];
       	$status 			=$row1['status'];
       	$eachscoarr['status'] = $row1['status'];
       	if($status=='approved')
       	{
       		$eachscoarr['sequence_number']    =$row1['approve_prefix'];
       		$eachscoarr['appAmt'] =$estimated_amount;
       		$eachscoarr['otherAmt'] ='';
       	}else
       	{
       		$eachscoarr['otherAmt'] = $estimated_amount;
       		$eachscoarr['appAmt'] = '';
       	}

       	$scoArr[] = $eachscoarr;
    }
    return $scoArr;
}

function getActiveSubContInvoice($database,  $projectids, $limit, $offset){
	$db = DBI::getInstance($database);
	$db->free_result();

	$getactiveinvoice = "SELECT `subcontract_invoices`.id,`subcontract_invoices`.project_id,`subcontract_invoices`.vendor_id,`subcontract_invoices`.cost_code_id,`subcontract_invoices`.qb_expense_id,`subcontract_invoice_status`.`status` FROM `subcontract_invoices` INNER JOIN subcontract_invoice_status on `subcontract_invoices`.`subcontract_invoice_status_id` = `subcontract_invoice_status`.`id` WHERE `subcontract_invoice_status`.`status` != 'Paid' AND `subcontract_invoices`.`qb_expense_id` != 0 AND `subcontract_invoices`.`project_id` IN (".$projectids.")  LIMIT ".$limit." OFFSET ".$offset;

	$db->execute($getactiveinvoice);
	$subcontinvoicearr = array();
	$subcontinvoicidarr = array();
	$subcontinvoice_count = 0;
	$return_arr = array();
	while($row = $db->fetch()){
		
		$subcontinvoicearr[] = $row['qb_expense_id'];
		$subcontinvoicidarr[$row['qb_expense_id']] = array();
		$subcontinvoicidarr[$row['qb_expense_id']]['invoice_id'] =  $row['id'];
		$subcontinvoicidarr[$row['qb_expense_id']]['project_id'] =  $row['project_id'];
		$subcontinvoicidarr[$row['qb_expense_id']]['vendor_id'] =  $row['vendor_id'];
		$subcontinvoicidarr[$row['qb_expense_id']]['contract_id'] =  $row['cost_code_id'];
		$subcontinvoicidarr[$row['qb_expense_id']]['qb_expense_id'] =  $row['qb_expense_id'];
		$subcontinvoicidarr[$row['qb_expense_id']]['status'] =  $row['status'];
		$subcontinvoice_count++;
	}

	$return_arr['subcontinvoice_count'] = $subcontinvoice_count;
	$return_arr['subcontinvoice_arr'] = $subcontinvoicearr;
	$return_arr['subcontinvoiceidarr'] = $subcontinvoicidarr;

	return $return_arr;
}

function overAllSubContInvoiceCount($database, $projectids){
	$db = DBI::getInstance($database);
	$db->free_result();

	$overallinvoice = "SELECT count(*) as total_subcontinvoice FROM `subcontract_invoices` INNER JOIN subcontract_invoice_status on `subcontract_invoices`.`subcontract_invoice_status_id` = `subcontract_invoice_status`.`id` WHERE `subcontract_invoice_status`.`status` != 'Paid' AND `subcontract_invoices`.`qb_expense_id` != 0 AND `subcontract_invoices`.`project_id` IN (".$projectids.") ";
	$db->execute($overallinvoice);
	$row_total = $db->fetch();
	$db->free_result();

	return $row_total;

}

function updatesubcontInvoiceStatus($database, $param_arr){

	$db = DBI::getInstance($database);
	$invoice_row = getSubContInvoiceData($database, $param_arr['invoiceId']);
	
	$paid_status_data = "SELECT id FROM `subcontract_invoice_status` WHERE `status`='Paid' LIMIT 1";
	$db->execute($paid_status_data);

	$paid_status_id = $db->fetch();
	$db->free_result();
	

	if(!empty($invoice_row['id'])){ // Company is there
		$updateInvoiceData  = "UPDATE `subcontract_invoices` SET `subcontract_invoice_status_id`='".$paid_status_id['id']."' WHERE id='".$invoice_row['id']."'";
		$db->execute($updateInvoiceData);
		if(!empty($invoice_row['created_by']) || !empty($invoice_row['modified_by'])){ // There is user data.

			$param_arr = array();
			$param_arr['invoiceId'] = $invoice_row['id'];
			$param_arr['created_by'] =  $invoice_row['created_by'];
			$param_arr['modified_by'] =  $invoice_row['modified_by'];
			$param_arr['statusId'] = $paid_status_id['id'];
			$params_arr['project_id'] =  $params_arr['project_id'];
			subcontract_notification($database, $param_arr); 
		}
	}
	$db->free_result();


}
function updatesubcontInvoiceStatusOverdue($database, $params_arr){

	$db = DBI::getInstance($database);
	
	$invoice_row = getSubContInvoiceData($database, $params_arr['invoiceId']);
 
	$paid_status_data = "SELECT id FROM `subcontract_invoice_status` WHERE `status`='Overdue' LIMIT 1";
	$db->execute($paid_status_data);

	$paid_status_id = $db->fetch();
	$db->free_result();
	

	if(!empty($invoice_row['id'])){ // Company is there
		$updateInvoiceData  = "UPDATE `subcontract_invoices` SET `subcontract_invoice_status_id`=? WHERE id=?";
		$db->execute($updateInvoiceData , array($paid_status_id['id'], $invoice_row['id']), MYSQLI_USE_RESULT);
		
		if(!empty($invoice_row['created_by']) || !empty($invoice_row['modified_by'])){ // There is user data.

			$param_arr = array();
			$param_arr['invoiceId'] = $invoice_row['id'];
			$param_arr['created_by'] =  $invoice_row['created_by'];
			$param_arr['modified_by'] =  $invoice_row['modified_by'];
			$param_arr['statusId'] = $paid_status_id['id'];
			$param_arr['project_id'] = $params_arr['project_id'];
			subcontract_notification($database, $param_arr);
		}
	}


	$db->free_result();


}
function updatesubcontInvoiceStatusOpen($database, $params_arr){
	$db = DBI::getInstance($database);
	$invoice_row = getSubContInvoiceData($database, $params_arr['invoiceId']);
 
	$paid_status_data = "SELECT id FROM `subcontract_invoice_status` WHERE `status`='Open' LIMIT 1";
	$db->execute($paid_status_data);

	$paid_status_id = $db->fetch();
	$db->free_result();
	

	if(!empty($invoice_row['id'])){ // Company is there
		
		$updateInvoiceData  = "UPDATE `subcontract_invoices` SET `subcontract_invoice_status_id`= ?  WHERE id= ?";
		$db->execute($updateInvoiceData, array($paid_status_id['id'], $invoice_row['id']), MYSQLI_USE_RESULT);
		if(!empty($invoice_row['created_by']) || !empty($invoice_row['modified_by'])){ // There is user data.
			$param_arr = array();
			$param_arr['invoiceId'] = $invoice_row['id'];
			$param_arr['created_by'] =  $invoice_row['created_by'];
			$param_arr['modified_by'] =  $invoice_row['modified_by'];
			$param_arr['statusId'] = $paid_status_id['id'];
			$param_arr['project_id'] = $params_arr['project_id'];
			subcontract_notification($database, $param_arr);
		}
	}
	$db->free_result();
}
function getActionType($database, $type='Subcontract Invoice Log'){
	$db = DBI::getInstance($database);
	$db->free_result();

	$item_types_data = "SELECT id FROM `action_item_types` WHERE `action_item_type` = ? LIMIT 1";
	$db->execute($item_types_data, array($type), MYSQLI_USE_RESULT);
	$item_type  = $db->fetch();
	$db->free_result();
	
	return $item_type;

}

function subcontract_notification($database, $param_arr = array()){

	$user_arr = array();
	if(!empty($param_arr['created_by'])){
		$user_arr[] = $param_arr['created_by'];
	}
	if(!empty($param_arr['modified_by'])){
		$user_arr[] = $param_arr['modified_by'];
	}
	$user_arr = array_unique($user_arr);
	if(!empty($user_arr)){
		$db = DBI::getInstance($database);
		$user_notification_type_id = 0;
		$action_type_id = getActionType($database);
		if(!empty($action_type_id['id'])){
			$user_notification_type_id = $action_type_id['id'];
		}


		foreach($user_arr as $eachuser){

			$db->free_result();	
			$insert_query = "INSERT INTO `users_notifications`( `user_id`, `project_id`, `user_notification_type_id`, `user_notification_type_reference_id`,`user_notification_type_status_id`, `is_read`, `created_date`, `modified_date`) VALUES (?,?,?,?,?,?,?,?)";
		
			$db->execute($insert_query , array($eachuser, $param_arr['project_id'], $user_notification_type_id,$param_arr['invoiceId'],$param_arr['statusId'], 'N',date('Y-m-d H:i:s'),date('Y-m-d H:i:s')), MYSQLI_USE_RESULT);
		}
		
	}

}

function checkSubContractTemplateisPO($database, $subcontract_template_id){ // To check the Template is Purchase Order Type

	$db = DBI::getInstance($database);
	$db->free_result();

	$getSubContractTemplate = 	"SELECT * FROM `subcontract_templates` as templ
									INNER JOIN `subcontract_types` as st
								ON `templ`.`subcontract_type_id` = `st`.`id`
								WHERE `st`.`subcontract_type` IN ('Internal Purchase Agreement','External Purchase Agreement','Purchase Order')  AND `st`.`disabled_flag` = 'N' 
								AND templ.`id` = '".$subcontract_template_id."'";
	$returnval = 'N';
	$db->execute($getSubContractTemplate);

	$subContractorPurchaseTemplate = $db->fetch();
	if(!empty($subContractorPurchaseTemplate['id'])){
		$returnval = 'Y';
	}
	$db->free_result();
	return $returnval;
}
function getSubContractTemplateType($database, $subcontract_template_id){
	$db = DBI::getInstance($database);
	$db->free_result();

	$getSubContractTemplate = 	"SELECT * FROM `subcontract_templates` as templ
									INNER JOIN `subcontract_types` as st
								ON `templ`.`subcontract_type_id` = `st`.`id`
								WHERE `st`.`disabled_flag` = 'N' 
								AND templ.`id` = '".$subcontract_template_id."'";
	$db->execute($getSubContractTemplate);

	$subContractorPurchaseTemplate = $db->fetch();

	return $subContractorPurchaseTemplate;
}

function getCostCodeDataById($database, $cost_code_id, $cost_code_division_id){

	$db = DBI::getInstance($database);
	$db->free_result();

	$getCostCodeDataQuery = "SELECT `cost_code_divisions`.`division_number`, 
								`cost_codes`.`cost_code`, `cost_codes`.`cost_code_description` 
							FROM `cost_codes`
								INNER JOIN `cost_code_divisions` 
							ON `cost_codes`.`cost_code_division_id` = `cost_code_divisions`.`id`  
							WHERE `cost_codes`.`id` = '".$cost_code_id."' AND `cost_codes`.`cost_code_division_id` = '".$cost_code_division_id."'";
	$db->execute($getCostCodeDataQuery);

	$costCodeData = $db->fetch();

	return $costCodeData;
}
// to get the prelims record based on subcontrators
function getPrelimsBysubcontractorId($database,$subcontract_id)
{
	 
	$db = DBI::getInstance($database);
	$db->free_result();

	$getSupplierDataQuery = "SELECT *, pi.id as prelim_id From `subcontractor_additional_documents` as s inner join preliminary_items as pi on pi.additional_doc_id = s.id where s.subcontractor_id= ?  and type= ? ";
	$arrValues = array($subcontract_id,'2');
	$db->execute($getSupplierDataQuery,$arrValues);

	$SupplierData = array();
	while($row = $db->fetch())
	{
		$SupplierData[]=$row;
	}
	$db->free_result();
	return $SupplierData;
}
// to get the prlims record by id
function getPrelimsRecordById($database,$supid)
{
	$db = DBI::getInstance($database);
	$db->free_result();

	 $getSupplierDataQuery = "SELECT * FROM `preliminary_items` where id in ($supid)";
	$db->execute($getSupplierDataQuery);

	$SupplierData = array();
	while($row = $db->fetch())
	{
		$SupplierData[]=$row;
	}
	$db->free_result();
	
	return $SupplierData;
}

function getValueFromSupplierSCLog($database,$invoice_id,$prelim_id){
	$db = DBI::getInstance($database);
	$db->free_result();

	$getSupplierDataQuery = "SELECT `Amount`,`is_release` FROM `supplier_for_subcontractorlog` where `invoice_id` = ? AND `prelim_id` = ?";
	$arrValues = array($invoice_id,$prelim_id);
	$db->execute($getSupplierDataQuery,$arrValues);
	$row = $db->fetch();
	$array = array();
	$array['amount'] = $row['Amount'];
	$array['is_release'] = $row['is_release'];
	$db->free_result();
	
	return $array;
}

function deleteSuppliersForInsert($database,$invoice_id,$prelim_id){
	$db = DBI::getInstance($database);
	$db->free_result();

	$query = "DELETE FROM `supplier_for_subcontractorlog` where `invoice_id` = ? AND `prelim_id` = ?";
	$arrValues = array($invoice_id,$prelim_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$db->free_result();
	
	return true;
}

function deleteSuppliersForDeSelect($database,$invoice_id,$prelim_id){
	$db = DBI::getInstance($database);
	$db->free_result();

	$query = "DELETE FROM `supplier_for_subcontractorlog` where `invoice_id` = ? AND `prelim_id`  NOT IN ($prelim_id)";
	$arrValues = array($invoice_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$db->free_result();
	
	return true;
}

function getPrelimsAndSCLogId($database,$invoice_id,$supid){
	$db = DBI::getInstance($database);
	$db->free_result();

	$getSupplierDataQuery = "
	SELECT p.* FROM `supplier_for_subcontractorlog` as s inner join preliminary_items as p on p.id = s.prelim_id where invoice_id = ?
	UNION
	SELECT * FROM `preliminary_items` where id in ($supid)";
	$arrValues = array($invoice_id);
	$db->execute($getSupplierDataQuery,$arrValues);

	$SupplierData = array();
	while($row = $db->fetch())
	{
		$SupplierData[]=$row;
	}
	$db->free_result();
	
	return $SupplierData;
}

function InsertPrelims($database,$supplier_name,$subcontract_id,$project_id,$budget_id)
{

	$db = DBI::getInstance($database);
	$db->free_result();

	$query = "INSERT INTO `subcontractor_additional_documents`(`subcontractor_id`, `gc_budget_line_item_id`, `type`) VALUES (?,?, ?)";	
	$arrValues = array($subcontract_id,$budget_id,'2');
	if($db->execute($query, $arrValues, MYSQLI_USE_RESULT)){
		$sub_doc_id = $db->insertId;

	}
	$db->free_result();

	$query = "INSERT INTO `preliminary_items`(`supplier`, `additional_doc_id` ) VALUES (?,?)";
	$arrValues = array($supplier_name,$sub_doc_id);
	
	if($db->execute($query, $arrValues, MYSQLI_USE_RESULT)){
		$prelim_id = $db->insertId;

	}
	return $prelim_id;
}

//To get total amount
function getTotalSumFromScLog($database, $invoice_id)
{
	$db = DBI::getInstance($database);	

	$getInvoiceData = "SELECT * FROM `subcontract_invoices` WHERE `id`=?  LIMIT 1 ";
	$db->execute($getInvoiceData, array($invoice_id), MYSQLI_USE_RESULT);
	$invoice_row = $db->fetch();
	$scAmt = $invoice_row['amount'];
	$retention = $invoice_row['retention'];
	$invoiceTotal = $invoice_row['total'];
	$db->free_result();

	$getSupplierInvQuery = "SELECT SUM(Amount) as tot_sup_amt FROM `supplier_for_subcontractorlog` where invoice_id =? ";
	$arrValues = array($invoice_id);
	$db->execute($getSupplierInvQuery,$arrValues);
	$row = $db->fetch();	
	$amount = $row['tot_sup_amt'];
	$db->free_result();

	$array = array();
	$array['sum'] = $scAmt - $retention + $amount;
	$array['diff'] = $invoiceTotal - $scAmt + $retention - $amount;

	return $array;
}

// getPrelimsBySCidAndInvoiceId
function getPrelimsBySCidAndInvoiceId($database, $invoice_id, $sc_id){

	$db = DBI::getInstance($database);

	$query1 ="SELECT pi.* FROM `preliminary_items` AS pi
	INNER JOIN `subcontractor_additional_documents` AS s ON s.`id` = pi.`additional_doc_id`
	LEFT JOIN file_manager_files AS f ON s.`attachment_file_manager_file_id` = f.`id`
	WHERE s.`subcontractor_id` = $sc_id AND type='2' AND `pi`.`released_date` = '0000-00-00'";
	$db->execute($query1);
	$SupplierInv = array();
	while($row = $db->fetch())
	{
		$prelim_id = $row['id'];
		$SupplierInv[$prelim_id]['prelim_id'] = $prelim_id;
		$SupplierInv[$prelim_id]['supplier'] = $row['supplier'];
		$data = getValueFromSupplierSCLog($database,$invoice_id,$prelim_id);
		$SupplierInv[$prelim_id]['Amount'] = $data['amount'];
		$SupplierInv[$prelim_id]['is_release'] = $data['is_release'];
	}
	$db->free_result();
	return $SupplierInv;
}

// To get the supplier by invoice
function getPrelimsByInvoiceId($database, $invoice_id)
{
	$db = DBI::getInstance($database);
	$db->free_result();

	$getSupplierInvQuery = "SELECT * FROM `supplier_for_subcontractorlog` as s inner join preliminary_items as p on p.id = s.prelim_id where invoice_id =? ";
	$arrValues = array($invoice_id);
	$db->execute($getSupplierInvQuery,$arrValues);

	$SupplierInv = array();
	while($row = $db->fetch())
	{
		$SupplierInv[]=$row;
	}
	$db->free_result();
	return $SupplierInv;
}

function updatePrelimReleaseDate($database, $prelim_arr){
	$db = DBI::getInstance($database);	
	$date = date('Y-m-d');
	$updatePrelim  = "UPDATE `preliminary_items` SET `released_date`='".$date."' WHERE id IN (".$prelim_arr.")";
	$db->execute($updatePrelim);
	$db->free_result();
	return true;
}

function SCOAmountAginstSubcontractor($database,$contract_id)
{
	$db = DBI::getInstance($database);	
	$amtquery  = "SELECT sum(estimated_amount) as estimated FROM `subcontract_change_order_data` WHERE `subcontractor_id` = ? and `status`=? ";
	$arrValues = array($contract_id,'approved');
	$db->execute($amtquery,$arrValues);
	$row = $db->fetch();
	$amount = $row['estimated'];
	$db->free_result();
	return $amount;
	
}

 function findSubInvByCostId($database,$user_company_id,$cost_code_id)
	{
		$costCodeDividerType =getCostCodeDividerForUserCompanies($database, $user_company_id);
		// To get the cost code
         $db = DBI::getInstance($database);
         $query2="SELECT concat(ccd.`division_number`,'$costCodeDividerType',cs.cost_code,' ',cs.cost_code_description) as cost_code_abb  FROM 
         `cost_codes` as cs inner join `cost_code_divisions` as ccd on ccd.id = cs.cost_code_division_id
         where `user_company_id` = ? and cs.id= ?";
         $arrValues = array($user_company_id,$cost_code_id);
         $db->execute($query2,$arrValues,MYSQLI_USE_RESULT);
         $row2= $db->fetch();
         $cost_code_abb = $row2['cost_code_abb'];
         $db->free_result();
         return $cost_code_abb;
	}

	function getCostCodeDividerForUserCompanies($database, $user_company_id)
	{
		 $db = DBI::getInstance($database);
		$query =
		"
		SELECT * FROM `cost_code_divider_for_user_company` ccduc
		LEFT JOIN `cost_code_divider` ccd ON ccd.`id`= ccduc.`divider_id`
		WHERE ccduc.`user_company_id` = ?
		";
		$arrValues = array($user_company_id);
		
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			return $row['divider'];
		} else {
			return '-';
		}
	}
?>
