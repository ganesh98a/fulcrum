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

//Get the session projectid & company id
$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$user_company_id = $session->getUserCompanyId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$db = DBI::getInstance($database);
$db->free_result();
$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectIdReport($database, $project_id);
$gcBudgetLineItemsTbody='';
$loopCounter=1;
$tabindex=0;
$tabindex2=0;
//cost code divider
$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
	/* @var $gcBudgetLineItem GcBudgetLineItem */

		$prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
		if (!$prime_contract_scheduled_value) {
			continue;
		}

	$costCode = $gcBudgetLineItem->getCostCode();
	/* @var $costCode CostCode */

	$costCode->htmlEntityEscapeProperties();

	$costCodeDivision = $costCode->getCostCodeDivision();
	/* @var $costCodeDivision CostCodeDivision */

	$costCodeDivision->htmlEntityEscapeProperties();

	$cost_code_division_id = $costCodeDivision->cost_code_division_id;
	if (isset($cost_code_division_id_filter)) {
		if ($cost_code_division_id_filter != $cost_code_division_id) {
			continue;
		}
	}

	$contactCompany = $gcBudgetLineItem->getContactCompany();
	/* @var $contactCompany ContactCompany */

	$costCodeDivisionAlias = $gcBudgetLineItem->getCostCodeDivisionAlias();
	/* @var $costCodeDivisionAlias CostCodeDivisionAlias */

	$costCodeAlias = $gcBudgetLineItem->getCostCodeAlias();
	/* @var $costCodeAlias CostCodeAlias */

	$subcontractorBid = $gcBudgetLineItem->getSubcontractorBid();
	/* @var $subcontractorBid SubcontractorBid */

	$invitedBiddersCount = 0;
	$activeBiddersCount = 0;
	if (isset($arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id])) {
		$arrBidderStatusCounts = $arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id];

            foreach ($arrBidderStatusCounts as $subcontractor_bid_status_id => $total) {
            	if ($subcontractor_bid_status_id <> 1) {
            		$invitedBiddersCount += $total;
            	}
            }

            // Active Bidders - Actively Bidding
            if (isset($arrBidderStatusCounts[4])) {
            	$activelyBiddingCount = $arrBidderStatusCounts[4];
            	$activeBiddersCount += $activelyBiddingCount;
            }

            // Active Bidders - Bid Received
            if (isset($arrBidderStatusCounts[5])) {
            	$bidReceivedCount = $arrBidderStatusCounts[5];
            	$activeBiddersCount += $bidReceivedCount;
            }
        }

        if ($invitedBiddersCount == 0) {
        	$invitedBiddersCount = '';
        }

        if ($activeBiddersCount == 0) {
        	$activeBiddersCount = '';
        }

        if (isset($subcontractorBid) && ($subcontractorBid instanceof SubcontractorBid)) {
        	/* @var $subcontractorBid SubcontractorBid */
        	$subcontractor_bid_id = $subcontractorBid->subcontractor_bid_id;
        } else {
        	$subcontractor_bid_id = '';
        }

        $cost_code_id = $costCode->cost_code_id;

        $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
        $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
        $arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemIdWithDate($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions,$new_begindate,$enddate);
        
        if (isset($arrSubcontracts) && !empty($arrSubcontracts)) {
        	$subcontractCount = count($arrSubcontracts);
        } else {
        	$subcontractCount = 0;
        }

        $prelimesTbody = '';
        $nxtCountSub = 0;
        $arrSubcontractVendorHtml = array();
        $subcontract_actual_value_raw = 0;
        $subcontract_actual_value =0;
        foreach ($arrSubcontracts as $subcontract) {
        	$prelimesTbodyTD = '';
        	/* @var $subcontract Subcontract */

        	$tmp_subcontract_id = $subcontract->subcontract_id;
        	$tmp_subcontract_sequence_number = $subcontract->subcontract_sequence_number;
        	$tmp_subcontract_template_id = $subcontract->subcontract_template_id;
        	$tmp_vendor_id = $subcontract->vendor_id;
        	$tmp_unsigned_subcontract_file_manager_file_id = $subcontract->unsigned_subcontract_file_manager_file_id;
        	$tmp_signed_subcontract_file_manager_file_id = $subcontract->signed_subcontract_file_manager_file_id;
        	$tmp_subcontract_forecasted_value = $subcontract->subcontract_forecasted_value;
        	$tmp_subcontract_actual_value = $subcontract->subcontract_actual_value;
        	$tmp_subcontract_retention_percentage = $subcontract->subcontract_retention_percentage;
        	$tmp_subcontract_issued_date = $subcontract->subcontract_issued_date;
        	$tmp_subcontract_target_execution_date = $subcontract->subcontract_target_execution_date;
        	$tmp_subcontract_execution_date = $subcontract->subcontract_execution_date;
        	$tmp_active_flag = $subcontract->active_flag;
        	$tmpSubcontractTargetExecutionDateHtmlInput = '';
        	$tmpSubcontractMailedDateHtmlInput = '';
            // Subcontract Actual Value list
        	$subcontract_actual_value_raw += $tmp_subcontract_actual_value;
        	$subcontract_actual_value += $tmp_subcontract_actual_value;
        	$formattedSubcontractActualValue = Format::formatCurrency($tmp_subcontract_actual_value);
            // Vendor list

        	$vendor = $subcontract->getVendor();
        	if ($vendor) {

        		$vendorContactCompany = $vendor->getVendorContactCompany();
        		/* @var $vendorContactCompany ContactCompany */

        		$vendorContactCompany->htmlEntityEscapeProperties();
        		$arrSubcontractVendorHtml[] = $vendorContactCompany->escaped_contact_company_name;
        	} else {
        		continue;
        	}

        	// For the Prelims document
			//To fetch the uploaded prelims document
			$db = DBI::getInstance($database);
			$query1 ="
				SELECT *, pi.id as prelim_id FROM `subcontractor_additional_documents` AS s
				INNER JOIN file_manager_files AS f ON s.attachment_file_manager_file_id = f.id
				LEFT JOIN preliminary_items AS pi ON pi.additional_doc_id =  s.id
				WHERE s.subcontractor_id = $tmp_subcontract_id AND type = '2' ";
			$db->execute($query1);
			$uploadedPrelimFileId=array();
			$uploadedPrelimfileName=array();
			$uploadedPrelimFileIdData = array();
			$i = 0;
			//  loop
			$inTdPr = 0 ;
			while($row1=$db->fetch()){
				$pretdBorderBottomStyle = '';
				if(($db->rowCount-1) != $inTdPr){
					$pretdBorderBottomStyle = 'td';
				}
				$supplier = $row1['supplier'];
				$received_date = date('m/d/Y',strtotime($row1['received_date']));
				$prelimesTbodyTD .= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
				<tr class="subcontractorRow">
	        		<td class="textAlignLeft $pretdBorderBottomStyle">$supplier</td>
		       		<td class="textAlignLeft $pretdBorderBottomStyle" width="42%">$received_date</td>
		       	<tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;
		       	$inTdPr++;
			}
			$db->free_result();
			$tdBorderBottomStyle = '';
			if(($subcontractCount-1) != $nxtCountSub){
				$tdBorderBottomStyle = 'td';
			}
            if($prelimesTbodyTD!="")
            {
	        $prelimesTbody .= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
	        <tr class="subcontractorRow">
	        	<td class="textAlignCenter"></td>
	        	<td class="textAlignLeft $tdBorderBottomStyle">$vendorContactCompany->escaped_contact_company_name</td>
	        	<td class="textAlignLeft $tdBorderBottomStyle" colspan="2">
	        		<table width="100%">
	        		$prelimesTbodyTD
	        		</table>
	        	</td>
	        </tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;
            $nxtCountSub++;
            }
	       
        }

        if ($loopCounter%2) {
        	$rowStyle = 'oddRow';
        } else {
        	$rowStyle = 'evenRow';
        }
        if(empty($arrSubcontractVendorHtml)){
        	continue;
        }
        $costCodeData = $costCodeDivision->escaped_division_number.$costCodeDividerType.$costCode->escaped_cost_code;
        if($prelimesTbody!="")
        {

       $gcBudgetLineItemsTbody .= <<<GC_BUDGET_LINE_ITEMS_TBODY
        <tr class="costCodeTr oddRow">
         	<td class="textAlignCenter costCodeTxt">$costCodeData</td>
       		<td class="textAlignLeft costCodeTxt" colspan="3">$costCode->escaped_cost_code_description</td>
        </tr>
        $prelimesTbody
GC_BUDGET_LINE_ITEMS_TBODY;
        
        $loopCounter++;
        $tabindex++;
        $tabindex2++;
    }
    }
    $gcBudgetLineItemsTbody = mb_convert_encoding($gcBudgetLineItemsTbody, "HTML-ENTITIES", "UTF-8");
    if($gcBudgetLineItemsTbody==''){
    	$gcBudgetLineItemsTbody="<tr><td colspan='6'>No prelims recorded.</td></tr>";
    }
    $htmlContent = <<<END_HTML_CONTENT
    <div class="custom_datatable_style">
    	<table class="content" border="0" cellpadding="5" cellspacing="0" width="100%">
    		<tr class="table-headerinner">
			    <td colspan="6" class="textAlignLeft">PRELIM NOTICE REPORT</td>
			</tr>
    	</table>
	    <table id="delay_list_container--manage-request_for_information-record" class="content cell-border tableborder" border="0" cellpadding="5" cellspacing="0" width="100%">
		    <thead class="borderBottom">
			    <tr class="table-header">
				    <th class="textAlignCenter">CostCode</th>
				    <th class="textAlignLeft" width="40%">Subcontractor</th>
				    <th class="textAlignLeft" width="25%">Supplier</th>
				    <th class="textAlignLeft" width="20%">Received Date</th>       
			    </tr>
		    </thead>
		    <tbody class="">
		    	$gcBudgetLineItemsTbody
		    </tbody>
	    </table>
    </div>
END_HTML_CONTENT;

    $db_add = DBI::getInstance($database);
    $address = "SELECT address_line_1,address_city,address_state_or_region,address_postal_code FROM projects where  id='".$project_id."'  ";
    $db_add->execute($address);
    $row_add = $db_add->fetch();
    $add_val = $row_add['address_line_1'].','.$row_add['address_city'].','.$row_add['address_postal_code'];
    $add_val=trim($add_val,',');

    if($add_val!=''){
    	$addContent = <<<END_HTML_CONTENT
    	<td class="textAlignLeft"> $add_val</td>
END_HTML_CONTENT;
    }


    $dompdf = new DOMPDF(); 
    $basefont = $config->system->file_manager_url .'fonts/calibri/calibri.ttf' ;
    $baseinnerfont = $config->system->file_manager_url .'fonts/calibri/calibri-bold.ttf' ;

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
    .CellBorderTop{
    	border-top:1px solid #CBC8C8;
    }
    .costCodeTxt {
    	color: #2481c3;
    }
    .costCodeTr td{
    	border-top: 1px solid #CBC8C8;
    	border-bottom: 1px solid #CBC8C8;
    }
    .fontSize16{
    	font-size:16pts;
    	/*text-decoration:underline;*/
    	font-family: 'Calibri-bold';
    	text-transform:uppercase;
    	border-bottom:1px solid #3487c7;
    }
    .cellRTNotWback
    {
    	border-top:none !important;
    	background: #fff;
    }
    .comment-table tr .BotBord {
    	border-bottom: 1px solid #CBC8C8;
    }
    .comment-table tr{
    	vertical-align:top;
    }
    .project_name{
    	text-align:center;
    	text-decoration:underline;
    	font-size:18pts;
    	text-weight:Bold;
    	text-transform : uppercase;
    }
    
	/*Bid list css*/
	.oddRow, .oddRowNotClickable {
		background-color: #efefef;
	}
	
    .detailed_week,.tableborder{
			border:1px solid ;
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
	#report_html{
	/*border:1px solid;*/
	font-size:18px;
	}
	.total_bold{
		font-weight:bold;
	}
	.center-align,.textAlignCenter{
		text-align:center;
	}
	.table_header_td{
		font-size:20px !important;
		color:#000;
	}
	.marginTopborderMT
	{
		border-top: 1px solid #cbc8c8;
	}
	.marginrightborderMT
	{
		border-right: 1px solid #cbc8c8;
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

