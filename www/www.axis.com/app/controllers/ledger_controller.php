<?php

	$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
	$init['ajax'] = false;
	$init['application'] = 'www.axis.com';
	$init['cache_control'] = 'nocache';
	$init['debugging_mode'] = true;
	$init['display'] = true;
	$init['geo'] = true;
	$init['get_maxlength'] = 2048;
	$init['get_required'] = false;
	$init['https'] = false;
	$init['https_admin'] = true;
	$init['https_auth'] = true;
	$init['no_db_init'] = false;
	$init['output_buffering'] = true;
	$init['override_php_ini'] = false;
	$init['skip_always_include'] = false;
	$init['skip_session'] = false;
	$init['skip_templating'] = false;
	$init['timer'] = false;
	$init['timer_start'] = false;

	require_once('lib/common/init.php');
	require_once('../constants/constants_qb.php');
	require_once('lib/common/SubcontractType.php');
	require_once('lib/common/Service/TableService.php');

	require_once('../functions/accounting-quickbook.php');
	require_once('../functions/subcontract_invoice_quickbook.php');
	require_once('../functions/ledger_quickbook.php');
	require_once('../models/accounting_model.php');
	require_once('../templates/dropdown_tmp.php');

	$session = Zend_Registry::get('session');

	/* Common Variables - Start */
	$user_company_id = $session->getUserCompanyId();
	$project_id = $session->getCurrentlySelectedProjectId();
	$user_id = $session->getUserId();
	/* Common Variables - End */

	if(!empty($_GET[ACTION]) && $_GET[ACTION] =='GetAllAccounts'){ // To get all the Accounts of OtherAssets which are not SubType
		$accounts = getAccountDetailsFromQB($database, $config, $user_company_id);
		foreach($accounts['accounts'] as $eachAccounts){
			$params_arr = array('company_id'=> '',REALMID=> '','qb_account_id'=> '','name'=> '', 'sub_account'=> '', 'classification'=> '', 'account_type'=> '','account_sub_type'=> '');
			$table_options_arr = array();
			$table_options_arr['table'] = 'qb_accounts';
			$table_options_arr['filter'] = array('company_id = ?'=>$user_company_id, 'realmID = ?'=>$accounts[REALMID],'name = ?'=>$eachAccounts->Name);
			$getAccount = TableService::GetTabularData($database, $table_options_arr);

			if(empty($getAccount)){
				if(!empty($eachAccounts->SubAccount) && $eachAccounts->SubAccount =='true'){
					$subAccountType = 'T';
				}else{
					$subAccountType = 'F';
				}
				$params_arr['company_id'] = $user_company_id;
				$params_arr[REALMID] = $accounts[REALMID];
				$params_arr['qb_account_id'] = $eachAccounts->Id;
				$params_arr['name'] = $eachAccounts->Name;
				$params_arr['sub_account'] = $subAccountType;
				$params_arr['classification'] = $eachAccounts->Classification; 
				$params_arr['account_type'] = $eachAccounts->AccountType;
				$params_arr['account_sub_type'] = $eachAccounts->AccountSubType;

				addAccount($database, $params_arr);
			}
		}

	}else if(!empty($_GET[ACTION]) && $_GET[ACTION] =='getGeneralLedgerForm'){

		$loadAllSubcontractTypesOptions = new Input();
		$loadAllSubcontractTypesOptions->forceLoadFlag = true;
		$arrSubcontractTypes = SubcontractType::loadAllSubcontractTypes($database, $loadAllSubcontractTypesOptions);

		$ddlSubcontractTypeElementId = '';

		$ledgerForm =  "";
		if(!empty($arrSubcontractTypes)){
			$table_options_arr = array();
			$table_options_arr['table'] = 'qb_accounts';
			$table_options_arr['filter'] = array('company_id = ?'=>$user_company_id,' sub_account = ?'=>'F');
			$table_options_arr['multiple'] = 'true';
			$table_options_arr['fields'] = array('id','name');
			$accountsArr =  TableService::GetTabularData($database, $table_options_arr);
			$dropdown_accounts_arr = array();
			foreach($accountsArr as $dropdown_accounts){
				$dropdown_accounts_arr[$dropdown_accounts['id']] = $dropdown_accounts['name'];
			}

			foreach ($arrSubcontractTypes as $eacharrSubcontractTypes) {
				
				$liststyle =  $listClass = $listjs = $liststyle = $selectedAccount = "";
				$subcontract_type_id = $eacharrSubcontractTypes->subcontract_type_id;
				$default_account = 'Please select an account';
				$listId = 'subcontract_type-'.$subcontract_type_id;
				$listClass = "gl_account_update";
				$table_options_arr = array();
				$table_options_arr['table'] = 'qb_subcontract_accounts';
				$table_options_arr['filter'] = array('company_id = ?'=>$user_company_id, 'project_id = ?'=>$project_id,'subcontract_type_id = ?'=>$subcontract_type_id);
				$getSubContractAccount = TableService::GetTabularData($database, $table_options_arr);
				if(!empty($getSubContractAccount['qb_account_id'])){
					$selectedAccount = $getSubContractAccount['qb_account_id'];
				}

				$res_drop=selectDropDown($database, $listId, $listClass, $listjs, $liststyle, $default_account, $dropdown_accounts_arr, $selectedAccount);
				$ledgerForm .=  <<<END_LEDGER_FORM
									<tr>
										<td>$eacharrSubcontractTypes->subcontract_type</td>
										<td>$res_drop</td>
									</tr>
END_LEDGER_FORM;
			}
		}else{
			$ledgerForm .=  <<<END_LEDGER_FORM
									<tr>
										<td style="text-align:center;color:red;">No subcontract template type available.</td>
									</tr>
END_LEDGER_FORM;
			
		}

		echo $ledgerForm;
	}else if(!empty($_GET[ACTION]) && $_GET[ACTION] =='update_template'){
		$returnval = '';
		if(!empty($_GET['subcontract_type'])){
			$subcontract_type_id = $_GET['subcontract_type'];
			if(!empty($_GET['gl_account_id'])){
				$qb_account_id = $_GET['gl_account_id'];
				$table_options_arr = array();
				$table_options_arr['table'] = 'qb_subcontract_accounts';
				$table_options_arr['filter'] = array('company_id = ?'=>$user_company_id, 'project_id = ?'=>$project_id,'subcontract_type_id = ?'=>$subcontract_type_id);
				$getSubContractAccount = TableService::GetTabularData($database, $table_options_arr);

				$db = DBI::getInstance($database);
				$db->free_result();

				if(!empty($getSubContractAccount['id'])){

					$subcontract_query = "UPDATE `qb_subcontract_accounts` SET `qb_account_id`=?,`user_id`=?, `created_date`=? WHERE `id`=?";

					$db->execute($subcontract_query, array($qb_account_id, $user_id, date('Y-m-d H:i:s'), $getSubContractAccount['id']), MYSQLI_USE_RESULT);
				}else{
					$subcontract_query = "INSERT INTO `qb_subcontract_accounts`( `company_id`, `project_id`, `subcontract_type_id`, `qb_account_id`, `user_id`, `created_date`) VALUES (?,?,?,?,?,?)";

					$db->execute($subcontract_query, array($user_company_id, $project_id, $subcontract_type_id, $qb_account_id, $user_id, date('Y-m-d H:i:s')), MYSQLI_USE_RESULT);

				}
				$db->free_result();
				$returnval = 'statusupdated';
			
			}else{
				$returnval = 'QB Account is missing';
			}
		}else{
			$returnval = 'SubContract Type ID is missing';
		}
		echo $returnval;
		die;
	}

?>