<?php
/*Manually increase the execution time for pdf generation*/
ini_set('max_execution_time', 300);
ini_set("memory_limit", "1000M");
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$timezone = date_default_timezone_get();
$dates = date('d-m-Y h', time());
$dateWithDay = date('l, M d, Y ');
$i=date('i', time());
$s=date('s a', time());
$a=date('a', time());
$timedate=date('d/m/Y h:i a', time());
$currentdate=date('m/d/Y', time());
require_once('lib/common/init.php');
require_once('lib/common/JobsiteDailyLog.php');
require_once("dompdf/dompdf_config.inc.php");
require_once('lib/common/GcBudgetLineItem.php');
require_once('modules-gc-budget-functions.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/File.php');
require_once('lib/common/Logo.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
require_once('lib/common/Draws.php');
require_once('lib/common/Project.php');
//Get the session projectid & company id
$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$user_company_id = $session->getUserCompanyId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$db = DBI::getInstance($database);
$db->free_result();

// New Rellocation History 
$cor_type = Project::CORAboveOrBelow($database,$project_id);
$budgetList = DrawItems::getBudgetDrawItems($database, $drawId, '', $cor_type);
$newResTable = '';
$prjDetails = '';
$signDetails = '';
$newReallHis = 0;
$newcolspan = 7;
$scheduledValueTotal = $reallocationFromTotal = $reallocationToTotal = $revisedBudjectTotal = 0;
$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

$drawData = Draws::getDrawDataUsingId($database,$project_id,$drawId);
$period_to = $drawData['through_date'] ? date('m/d/Y', strtotime($drawData['through_date'])) : '';
$app_no = $drawData['application_number'] ? '#'.$drawData['application_number'] : '';

$projectData = Project::findProjectById($database,$project_id);
$alias_type = $projectData['alias_type'];

$contract_date = ($projectData['project_contract_date'] && $projectData['project_contract_date'] != '0000-00-00') ? date('m/d/Y', strtotime($projectData['project_contract_date'])) : '';

// Owner details
$owner_name = $projectData['project_owner_name'] ? $projectData['project_owner_name'] : '';
$owner_add1 = $projectData['owner_address'] ? $projectData['owner_address'] : '';
$owner_city = $projectData['owner_city'] ? $projectData['owner_city'].',' : '';
$owner_state = $projectData['owner_state_or_region'] ? ' '.$projectData['owner_state_or_region'] : '';
$owner_zip = $projectData['owner_postal_code'] ? $projectData['owner_postal_code'] : '';
$owner_add2 = $owner_city.$owner_state.' '.$owner_zip;

// Project details
$project_name = $projectData['project_name'] ? $projectData['project_name'] : ''; //Project Name
$project_add1 = $projectData['address_line_1'] ? $projectData['address_line_1'] : '';
$prj_city = $projectData['address_city'] ? $projectData['address_city'].',' : '';
$prj_state = $projectData['address_state_or_region'] ? ' '.$projectData['address_state_or_region'] : '';
$prj_zip = $projectData['address_postal_code'] ? $projectData['address_postal_code'] : '';
$project_add2 = $prj_city.$prj_state.' '.$prj_zip;

// Contractor details
$entityName = ContractingEntities::getcontractEntityNameforProject($database,$projectData['contracting_entity_id']);
$contractor_name = $entityName ? $entityName : ''; //Contractor Name
$arrGCContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $projectData['user_company_id']);
$i = 0;
foreach($arrGCContactCompanyOffices as $officeId => $officeAddress) {
    if($i > 0){
        break;
    }
    $contractor_line_1 = $officeAddress->address_line_1 ? $officeAddress->address_line_1 : '';
    $contractor_line_2 = $officeAddress->address_line_2 ? ', '.$officeAddress->address_line_2 : '';
    $contractor_add1 = $contractor_line_1.$contractor_line_2;

    $contractor_city = $officeAddress->address_city ? $officeAddress->address_city : '';
    $contractor_state = $officeAddress->address_state_or_region ? $officeAddress->address_state_or_region.' ' : '';
    $contractor_postal_code = $officeAddress->address_postal_code ? $officeAddress->address_postal_code : '';
    $contractor_add2 = $contractor_city.', '.$contractor_state.$contractor_postal_code;
    $i++;
}

$prjDetails .="
    <table border='0' cellpadding='5' cellspacing='0' width='100%'>
        <thead>
            <tr>
                <th colspan='4' class='tableHeaderInnerMeeting'>BUDGET REALLOCATION REQUEST</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width='25%'>
                    <table>
                        <tr><td class='paragraphBoldCal'>TO (OWNER):</td></tr>
                        <tr><td>$owner_name</td></tr>
                        <tr><td>$owner_add1</td></tr>
                        <tr><td>$owner_add2</td></tr>
                    </table>
                </td>
                <td width='25%'>
                    <table>
                        <tr><td class='paragraphBoldCal'>PROJECT:</td></tr>
                        <tr><td>$project_name</td></tr>
                        <tr><td>$project_add1</td></tr>
                        <tr><td>$project_add2</td></tr>
                    </table>
                </td>
                <td width='25%'>
                    <table>
                        <tr><td class='paragraphBoldCal'>FROM (CONTRACTOR):</td></tr>
                        <tr><td>$contractor_name</td></tr>
                        <tr><td>$contractor_add1</td></tr>
                        <tr><td>$contractor_add2</td></tr>
                    </table>
                </td>
                <td width='25%'>
                    <table>
                        <tr>
                            <td class='paragraphBoldCal textAlignRight'>PERIOD TO:<td>
                            <td> $period_to<td>
                        </tr>
                        <tr>
                            <td class='paragraphBoldCal textAlignRight'>APPLICATION NO:<td>
                            <td> $app_no<td>
                        </tr>
                        <tr>
                            <td class='paragraphBoldCal textAlignRight'>CONTRACT DATE:<td>
                            <td> $contract_date<td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
";

$signDetails .="
    <br>
    <table align='center' cellpadding='5' cellspacing='0' width='80%'>        
        <tr>
            <th colspan='3' class='textAlignLeft' style='text-transform: uppercase;'>CONTRACTOR: $contractor_name</th>
        </tr>
        <tr>
            <td style='border-bottom:1px solid #bbb !important;'>Sign: </td>
            <td style='border-bottom:1px solid #bbb !important;'>Print: </td>
            <td style='border-bottom:1px solid #bbb !important;'>Date: </td>
        </tr> 
        <tr>
            <th colspan='3' class='textAlignLeft' style='text-transform: uppercase;'>OWNER: $owner_name</th>
        </tr> 
        <tr>
            <td style='border-bottom:1px solid #bbb !important;'>Sign: </td>
            <td style='border-bottom:1px solid #bbb !important;'>Print: </td>
            <td style='border-bottom:1px solid #bbb !important;'>Date: </td>
        </tr>       
    </table>
";

$newResTable .="
    <tr class='oddRow'>
        <th class='textAlignCenter'>COST CODE</th>
        <th class='textAlignCenter'>DESCRIPTION OF WORK</th>
        <th class='textAlignCenter'>SCHEDULED VALUES</th>
        <th class='textAlignCenter'>AMOUNT FROM</th>
        <th class='textAlignCenter'>AMOUNT TO</th>
        <th class='textAlignCenter'>REVISED BUDGET</th>
        <th class='textAlignCenter'>EXPLANATION</th>
    </tr>
";

foreach ($budgetList as $key => $value) {
    $drawItemId = $value['id'];
    $costCode = $value['cost_code'];
    $costCodeDivision = $value['division_number'];
    $costCodeDesc = $value['cost_code_description'];
    $realocationValue = $value['realocation'];
    $scheduledValue = $value['scheduled_value'];
    $revisedBudject = $scheduledValue + $realocationValue;
    $renotes = $value['renotes'];
    $cost_code_id = $value['cost_code_id'];
    $cost_code_divison_id = $value['cost_code_divison_id'];
    $getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$cost_code_id,$cost_code_divison_id);
    $reallocationFrom = 0;
    $reallocationTo = 0;
    if ($realocationValue > 0) {
        $reallocationFrom = 0;
        $reallocationTo = $realocationValue;
    }else if ($realocationValue < 0) {
        $reallocationFrom = $realocationValue;
        $reallocationTo = 0;
    }else{
        $reallocationFrom = 0;
        $reallocationTo = 0;
    }

    $scheduledValueTotal += $scheduledValue;
    $reallocationFromTotal += $reallocationFrom;
    $reallocationToTotal += $reallocationTo;
    $revisedBudjectTotal += $revisedBudject;

    $scheduledValueFormatted = Format::formatCurrency($scheduledValue);
    $revisedBudjectFormatted = Format::formatCurrency($revisedBudject);
    $reallocationFrom = $reallocationFrom ? Format::formatCurrency($reallocationFrom) : '';
    $reallocationTo = $reallocationTo ? Format::formatCurrency($reallocationTo) : '';

    $costCodeData = $costCodeDivision.$costCodeDividerType.$costCode;
    if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAliasStatus == 'true') {
      $costCodeData = $costCodeData.' '.$getCostCodeAlias;
    }
    $wrapStyle = "class='textAlignCenter'";
    if ($costCodeAliasStatus == 'true') {
        $wrapStyle = "style='min-width:120px;max-width:120px;word-wrap: break-word;'";
    }

    $newResTable .="
        <tr>
            <td $wrapStyle>$costCodeData</td>
            <td class='textAlignLeft'>$costCodeDesc</td>
            <td class='textAlignRight'>$scheduledValueFormatted</td>
            <td class='textAlignRight'>$reallocationFrom</td>
            <td class='textAlignRight'>$reallocationTo</td>
            <td class='textAlignRight'>$revisedBudjectFormatted</td>
            <td class='textAlignLeft'>$renotes</td>
        </tr>
    ";

    $newReallHis++;
    
}

if ($newReallHis != 0) {
    $scheduledValueTotal = Format::formatCurrency($scheduledValueTotal);
    $reallocationFromTotal = Format::formatCurrency($reallocationFromTotal);
    $reallocationToTotal = Format::formatCurrency($reallocationToTotal);
    $revisedBudjectTotal = Format::formatCurrency($revisedBudjectTotal);
    $newResTable .="
        <tr class='oddRow'>
            <th class='textAlignRight' colspan='2'>ORIGINAL BUDGET TOTALS</th>
            <th class='textAlignRight'>$scheduledValueTotal</th>
            <th class='textAlignRight'>$reallocationFromTotal</th>
            <th class='textAlignRight'>$reallocationToTotal</th>
            <th class='textAlignRight'>$revisedBudjectTotal</th>
            <th class='textAlignRight'></th>
        </tr>
   ";
}  

if ($newReallHis == 0) {
    $newResTable .="
        <tr>
            <td colspan='$newcolspan' align='left'>Data's Not Available
            </td>
        </tr>
   ";
}  

$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectIdReport($database, $project_id);
$resTable = '';
$coCodeAva = 0;
$colspan = 6;
foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
    $cost_code_id = $gcBudgetLineItem->cost_code_id;
    // draw reallocation 
    $realocationData = DrawItems::ReallocationCostCodeData($database, $cost_code_id, $project_id);
    $coCostCode = $gcBudgetLineItem->getCostCode();
    $formattedCoCostCode = $coCostCode->getFormattedCostCode($database,true, $user_company_id);
    $prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
    $prime_contract_scheduled_value_ff = Format::formatCurrency($prime_contract_scheduled_value);
    $retotal =0;
    $incCount = 0;
    $coCodeInc = 0;

    foreach ($realocationData as $key => $reval) {
        if ($coCodeInc == 0) {
            $resTable .="
                <tr class='oddRow borderBottom'>
                    <th class='textAlignCenter'>CostCode</th>
                    <th class='textAlignCenter'>$formattedCoCostCode</th>
                    <th class='textAlignCenter'>Original PSCV</th>
                    <th class='textAlignRight'>$prime_contract_scheduled_value_ff</th>
                </tr>
             ";
            $coCodeInc++;
        }
        if ($incCount == 0) {
            $resTable .="
                <tr class='oddRow borderBottom'>
                    <td class='textAlignCenter'>Draw Id</td>
                    <td class='textAlignCenter'>Application Number</td>
                    <td class='textAlignCenter'>Through Date</td>
                    <td class='textAlignRight'>Reallocations</td>
                </tr>
             ";
        }
        $drawId = $reval['draw_id'];
        $through_date = $reval['through_date'];
        $application_number = $reval['application_number'];
        $realocation = $reval['realocation'];
        $retotal = $retotal + $realocation;
        $realocationAmt = Format::formatCurrency($realocation);
        

        $resTable .="<tr class='marginleftborderMT marginrightborderMT'>
        <td class='marginleftborderMT textAlignCenter'>$drawId</td>
        <td class='textAlignCenter'>$application_number</td>
        <td class='textAlignCenter'>$through_date</td>
        <td style='marginrightborderMT' align='right'>$realocationAmt</td></tr> ";
        $coCodeAva++;
    }
    $cummulatePSCV = $retotal+$prime_contract_scheduled_value;
    // total anaysis breakdown
    $loadCostCodeBreakDownByProjectIdAndCostCodeId = new Input();
    $loadCostCodeBreakDownByProjectIdAndCostCodeId->forceLoadFlag = true;
    $costCodeAnaysisBreakDown = ChangeOrder::loadCostCodeBreakDownByProjectIdAndCostCodeId($database, $cost_code_id, $project_id, $loadCostCodeBreakDownByProjectIdAndCostCodeId);
    $incCount = 0;
    foreach ($costCodeAnaysisBreakDown as $key => $cocb) {
        if ($coCodeInc == 0) {
            $resTable .="
                <tr class='oddRow borderBottom'>
                    <th class='textAlignCenter'>CostCode</th>
                    <td class='textAlignCenter'>$formattedCoCostCode</td>
                    <th class='textAlignCenter'>Original PSCV</th>
                    <th class='textAlignRight'>$prime_contract_scheduled_value</th>
                </tr>
            ";
            $coCodeInc++;
        }
        if ($incCount == 0) {
            $resTable .="
                <tr class='oddRow borderBottom'>
                    <td class='textAlignCenter'>COR Id</td>
                    <td class='textAlignCenter'>Description</td>
                    <td class='textAlignCenter'>Approved Date</td>
                    <td class='textAlignRight'>Cost in ($)</td>
                </tr>
             ";
        }
        $change_order_id = $cocb['id'];
        $co_type_prefix = $cocb['co_type_prefix'];      
        $cocb_description = $cocb['cocb_description'];
        $co_approved_date = $cocb['co_approved_date'];
        $co_approved_date = date('m/d/Y', strtotime($co_approved_date));
        $co_cost = $cocb['cocb_cost'];
        $co_cost_con = Format::formatCurrency($co_cost);
        $resTable .="
            <tr class=''>
                <td class='textAlignCenter marginleftborderMT'>$co_type_prefix</td>
                <td class='textAlignCenter'>$cocb_description</td>
                <td class='textAlignCenter'>$co_approved_date</td>
                <td class='marginrightborderMT' align='right'>$co_cost_con</td>
            </tr>
        ";
        $retotal = $retotal + intVal($co_cost);
        $cummulatePSCV = $cummulatePSCV + intVal($co_cost);
        $incCount++;
        $coCodeAva++;
    }
    $totalReAmt = Format::formatCurrency($retotal);
    $cummulatePSCV = Format::formatCurrency($cummulatePSCV);
    if ($coCodeInc > 0) {
        $resTable .="
            <tr>
                <td colspan='3' align='right'><b>Total</b></td><td style=''  align='right'>$totalReAmt
                </td>
            </tr>
            <tr class='borderBottom'>
                <td colspan='3' align='right'>
                    <b>Reallocated PSCV</b>
                </td>
                <td align='right'>
                    <b>$cummulatePSCV</b>
                </td>
            </tr>
        ";
    }
}

if ($coCodeAva == 0) {
    $resTable ="
        <tr>
            <td colspan='4' align='left'>Data's Not Available
            </td>
        </tr>
   ";
}   
    

$dompdf = new DOMPDF(); 
$basefont = $config->system->file_manager_url .'fonts/calibri/calibri.ttf' ;
$baseinnerfont = $config->system->file_manager_url .'fonts/calibri/calibri-bold.ttf' ;
$htmlContent = <<<END_HTML_CONTENT
    <div class="custom_datatable_style">
        $prjDetails
        <table id="realcaHistory" cellpadding="5" cellspacing="0" width="100%">
            <tbody class="">
                $newResTable
            </tbody>
        </table>
        $signDetails
    </div>
END_HTML_CONTENT;
    //Store the html data's
    $html = <<<ENDHTML
    <html>
    <head>
    <style>
    @font-face {
    	font-family: 'Calibri';
    	font-style: normal;
    	font-weight: normal;
    	src: url($basefont) format('truetype');
    }
    @font-face {
    	font-family: 'Calibri-bold';
    	font-style: normal;
    	font-weight: normal;
    	src: url($baseinnerfont) format('truetype');
    }
    .textUnderline {
        text-decoration:underline;
    }
    .fontSize16{
    	font-size:16pts;
    	/*text-decoration:underline;*/
    	font-family: 'Calibri-bold';
    	text-transform:uppercase;
    	border-bottom:1px solid #3487c7;
    }
   
	/*Bid list css*/
	.oddRow, .oddRowNotClickable {
		background-color: #efefef;
	}

    .borderLeft{
        border-left: 1px solid #bbb;
    }
    .borderBottom{
        border-bottom: 1px solid #bbb;
    }
    .paragraphBoldCal{
        font-weight: bold;
    }
	
    .tableborder-rh{
			border:1px solid #B0A6A6 ;
	}

	.align-left,.textAlignLeft{
		text-align:left;
	}
	.align-right{
		text-align:right;
	}
	.align-center{
		text-align:center;
	}
	.table-header{
		margin:0;
		padding:0;
	}
    #realcaHistory tr td,#realcaHistory tr th,#realcaHistory{
        border:1px solid #bbb;
        border-collapse: collapse;
    }
	.line-break{
		border:0.5px solid;
	}
	.repot-inform{
		background-color:#2481c3;
		color:#fff;
		padding:5px;
		margin-bottom:5px;
	}
	.table-headerinner{
		background-color:#2481c3;
		color:#fff;
		font-weight:lighter;
	}
		
	.center-align,.textAlignCenter{
		text-align:center;
	}
	.table_header_td{
		font-size:20px !important;
		color:#000;
	}
	.marginleftborderMT
	{
		border-left: 0px solid #cbc8c8 !important;
	}
	.marginrightborderMT
	{
		border-right: 0px solid #cbc8c8 !important;
	}
</style>
</head>
	<body>
		$htmlContent
	</body>
</html>
ENDHTML;
$data=ContactCompany::GenerateFooterData($user_company_id,$database);
$address=$data['address'];
$number=$data['number'];
$footer_cont=$address.' '.$number;
// Place the PDF file in a download directory and output the download link.
if (isset($isHtml) && $isHtml == true) {
    $htmlContent = $html;
    return $htmlContent;
    exit;
}

