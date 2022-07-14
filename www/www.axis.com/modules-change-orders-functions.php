<?php

require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/Log.php');
require_once('lib/common/Mail.php');
require_once('lib/common/MessageGateway/Sms.php');
require_once('lib/common/MobileNetworkCarrier.php');
require_once('lib/common/MobilePhoneNumber.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/ProjectToWeatherUndergroundReportingStation.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/ChangeOrder.php');
require_once('lib/common/ChangeOrderAttachment.php');
require_once('lib/common/ChangeOrderDistributionMethod.php');
require_once('lib/common/ChangeOrderDraft.php');
require_once('lib/common/ChangeOrderDraftAttachment.php');
require_once('lib/common/ChangeOrderNotification.php');
require_once('lib/common/ChangeOrderPriority.php');
require_once('lib/common/ChangeOrderRecipient.php');
require_once('lib/common/ChangeOrderResponse.php');
require_once('lib/common/ChangeOrderResponseType.php');
require_once('lib/common/ChangeOrderStatus.php');
require_once('lib/common/ChangeOrderType.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');

require_once('page-components/dropDownListWidgets.php');
require_once('page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('app/models/permission_mdl.php');
require_once('lib/common/ContractingEntities.php');
require_once('lib/common/UserCompanyFileTemplate.php');
require_once('lib/common/DrawSignatureBlocks.php');

function renderCoListView_AsHtml($database, $project_id, $user_company_id, $change_order_type_id=false, $pdfFlag=false,$ajax_view = '1',$showreject = 'false'){
	$totalAmt= 0;
	$textAlign = 'align="center"';
	$session = Zend_Registry::get('session');
	$debugMode = $session->getDebugMode();
	if($debugMode){
		$coChangeOrderIdHead = <<<END_OF_CHANGE_ORDER_ID_HEAD
		<th $textAlign nowrap>CO NO</th>
END_OF_CHANGE_ORDER_ID_HEAD;
	}
	//Potential change order
	if($change_order_type_id == '' || $change_order_type_id == 1){
		$order_type_id = 1;
		$sort_approved = false; //Variable to sort the approved section
		$potentialCoContent = getAllChangeOrders($database, $project_id, $user_company_id, $order_type_id, $pdfFlag,'',$showreject,$sort_approved);
		$statusIds = array(1,2);
		$potentialCORData = changeOrderTypeTotalAndDelay($database,$project_id, $order_type_id, $statusIds);

		$potentialCORTotalAmt = $potentialCORData['total'];
		$potentialCORTotalAmt = Format::formatCurrency($potentialCORTotalAmt);
		$potentialCORDays = $potentialCORData['days'];
		$totalAmt += $potentialCORData['total'];
		$showallbut = '<input type="checkbox" name="showreject" id="showreject">';
		if(!empty($ajax_view) && $ajax_view =='3'){
			$showallbut = '';
		}
		$coSpan = $debugMode ? '6' : '5';
		$coSpan2 = $debugMode ? '5' : '4';
		$potentialCOHeadHtmlContent = <<<END_HTML_CONTENT
		<tr class='purStyle'>
			<td colspan=$coSpan><b>PCO Created</b></td>
			<td $textAlign><b>Est.Amount</b></td>
			<td colspan='5'></td>
		</tr>
END_HTML_CONTENT;

		$potentialCOHtmlContent = <<<END_HTML_CONTENT
		$potentialCoContent
		<tr class='purStyle'><td colspan='4'></td><td align='right'><b>Total Amount</b></td><td align='right'><b>$potentialCORTotalAmt</b></td><td align='center'><b>$potentialCORDays day(s)</b></td><td colspan=$coSpan2></td></tr>
END_HTML_CONTENT;
  }

	if($change_order_type_id == '' || $change_order_type_id == 2){
		//open change order request
		$order_type_id = 2;
		$change_order_status_id = array(1,3);
		$sort_approved = false; //Variable to sort the approved section
		$corCoContent = getAllChangeOrders($database, $project_id, $user_company_id, $order_type_id, $pdfFlag, $change_order_status_id,$showreject,$sort_approved);

		$statusIds = array(1);
		$openCORData = changeOrderTypeTotalAndDelay($database,$project_id, $order_type_id, $statusIds);

		$openCORTotalAmt = $openCORData['total'];
		$openCORTotalAmt = Format::formatCurrency($openCORTotalAmt);
		$openCORDays = $openCORData['days'];
		$totalAmt += $openCORData['total'];

		$openCOHtmlContent = <<<END_HTML_CONTENT
		<tr class='purStyle'>
			<td colspan=$coSpan><b>COR Submitted</b></td>
			<td $textAlign><b>Amount</b></td>
			<td colspan='5'></td>
		</tr>
			$corCoContent
		<tr class='purStyle'>
			<td colspan='4'></td>
			<td align='right'><b>Total Amount</b></td>
			<td align='right'><b>$openCORTotalAmt</b></td>
			<td align='center'><b>$openCORDays day(s)</b></td>
			<td colspan=$coSpan2></td>
		</tr>
END_HTML_CONTENT;

		//approved change order request
		$change_order_status_id = array(2);
		$sort_approved = true; //Variable to sort the approved section
		$approvedCorCoContent = getAllChangeOrders($database, $project_id, $user_company_id, $order_type_id, $pdfFlag, $change_order_status_id,$showreject,$sort_approved);

		$statusIds = array(2);
		$approvedCORData = changeOrderTypeTotalAndDelay($database,$project_id, $order_type_id, $statusIds);

		$approvedCORTotalAmt = $approvedCORData['total'];
		$approvedCORTotalAmt = Format::formatCurrency($approvedCORTotalAmt);
		$approvedCORDays = $approvedCORData['days'];
		$totalAmt += $approvedCORData['total'];

		$approvedCOHtmlContent = <<<END_HTML_CONTENT
		<tr class='purStyle'>
			<td colspan=$coSpan><b>Approved</b></td>
			<td $textAlign><b>Amount</b></td>
			<td colspan='5'></td>
		</tr>
  		$approvedCorCoContent
		<tr class='purStyle'>
			<td colspan='4'></td>
			<td align='right'><b>Total Amount</b></td>
			<td align='right'><b>$approvedCORTotalAmt</b></td>
			<td align='center'><b>$approvedCORDays day(s)</b></td>
			<td colspan=$coSpan2></td>
		</tr>
END_HTML_CONTENT;
 }
	$totalAmt = Format::formatCurrency($totalAmt);
  	if(!empty($ajax_view) && ($ajax_view =='1' || $ajax_view =='3')){

			$pcoHeader = <<<END_OF_PCOHEADER
			<tr class="permissionTableMainHeader">
			$coChangeOrderIdHead
				<th $textAlign nowrap>Custom #</th>
				<th $textAlign nowrap>CO #</th>				
				<th $textAlign nowrap>Type</th>
				<th $textAlign nowrap width="15%">Title</th>
				<th $textAlign nowrap>Reason</th>
				<th $textAlign nowrap>Amount</th>
				<th $textAlign nowrap>Days</th>
				<th $textAlign nowrap>Date Created</th>
				<th $textAlign nowrap>Status</th>
				<th $textAlign nowrap>References</th>
				<th $textAlign nowrap>Executed</th>
				<!--<th $textAlign nowrap>Cost Code</th>-->
			</tr>
END_OF_PCOHEADER;

		$htmlContent = <<<END_HTML_CONTENT

		<table id="SubcontracttblTabularData" class="content c-order" border="0" cellpadding="5" cellspacing="0" width="100%">
		$pcoHeader
		$potentialCOHeadHtmlContent
		<tbody class="co_content">
		  $potentialCOHtmlContent
	    $openCOHtmlContent
			$approvedCOHtmlContent
		</tbody>
		</table>

END_HTML_CONTENT;
	}else{
		$htmlContent = <<<END_HTML_CONTENT
			$potentialCOHtmlContent
			$openCOHtmlContent
			$approvedCOHtmlContent
END_HTML_CONTENT;
	}

  return $htmlContent;
}
function getCOCostcodeFromCostBreakDown($database, $user_company_id,$change_order_id)
{
	

	$arrCostCode = ChangeOrder::getcostBreakCostCodeId($database,$change_order_id);
	$inc =1;
	foreach ($arrCostCode as $key => $costvalue) {
	$OCOcost_code_id = $costvalue['cost_code_reference_id'];
	if($OCOcost_code_id !="")
	{
	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
	$costcodedata = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$OCOcost_code_id,$costCodeDividerType);
	$formattedSuCostCode .= $inc .") ".$costcodedata['short_cost_code']."<br>";
	$inc ++;
	}
	
	}
	return  $formattedSuCostCode;
}

function getAllChangeOrders($database, $project_id, $user_company_id, $change_order_type_id, $pdfFlag=false, $change_order_status_id,$showreject,$sort_approved){
	$loadChangeOrdersByProjectIdOptions = new Input();
	$loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
	$loadChangeOrdersByProjectIdOptions->change_order_type_id = $change_order_type_id;
	$loadChangeOrdersByProjectIdOptions->change_order_status_id = $change_order_status_id;
	if ($sort_approved == true) {
		$loadChangeOrdersByProjectIdOptions->arrOrderByAttributes = " boolnull ASC , boolDash DESC, boolZero DESC, boolNum DESC, (co.`co_custom_sequence_number`+0), co.`co_custom_sequence_number`, CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC";
	}else{
		$loadChangeOrdersByProjectIdOptions->arrOrderByAttributes = "co.`change_order_type_id` ASC,CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC,co.`co_sequence_number` DESC ";
	}
	$loadChangeOrdersByProjectIdOptions->showreject = $showreject;

	$arrChangeOrders = ChangeOrder::loadAllChangeOrdersByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);

	$coTableTbody = '';
	$type_show="";
	$inc='1';
	foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
		/* @var $changeOrder ChangeOrder */

		$project = $changeOrder->getProject();
		/* @var $project Project */

		$changeOrderType = $changeOrder->getChangeOrderType();
		/* @var $changeOrderType ChangeOrderType */
		$change_order_type = $changeOrderType->change_order_type;

		$changeOrderStatus = $changeOrder->getChangeOrderStatus();
		/* @var $changeOrderStatus ChangeOrderStatus */

		$changeOrderPriority = $changeOrder->getChangeOrderPriority();
		/* @var $changeOrderPriority ChangeOrderPriority */

		$changeOrderDistributionMethod = $changeOrder->getChangeOrderDistributionMethod();
		/* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
		//$change_order_distribution_method = $changeOrderDistributionMethod->change_order_distribution_method;
		$change_order_distribution_method = '';

		$coFileManagerFile = $changeOrder->getCoFileManagerFile();
		/* @var $coFileManagerFile FileManagerFile */

		$coCostCode = $changeOrder->getCoCostCode();
		/* @var $coCostCode CostCode */

		$coCreatorContact = $changeOrder->getCoCreatorContact();
		/* @var $coCreatorContact Contact */

		$coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
		/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */

		$coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
		/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
		/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
		/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

		$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
		/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

		$coRecipientContact = $changeOrder->getCoRecipientContact();
		/* @var $coRecipientContact Contact */

		$coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
		/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */

		$coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
		/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
		/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
		/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */

		$coInitiatorContact = $changeOrder->getCoInitiatorContact();
		/* @var $coInitiatorContact Contact */

		$coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
		/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */

		$coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
		/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
		/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();
		/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */
		$changeTypeid = $changeOrder->change_order_type_id;
		$co_type_prefix =$changeOrder->co_type_prefix;
		$co_sequence_number = $changeOrder->co_sequence_number;
		$co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
		$co_scheduled_value = $changeOrder->co_scheduled_value;
		$co_delay_days = $changeOrder->co_delay_days;
		$change_order_type_id = $changeOrder->change_order_type_id;
		$change_order_status_id = $changeOrder->change_order_status_id;
		$change_order_priority_id = $changeOrder->change_order_priority_id;
		$change_order_distribution_method_id = $changeOrder->change_order_distribution_method_id;
		$co_file_manager_file_id = $changeOrder->co_file_manager_file_id;
		$co_cost_code_id = $changeOrder->co_cost_code_id;
		$co_creator_contact_id = $changeOrder->co_creator_contact_id;
		$co_creator_contact_company_office_id = $changeOrder->co_creator_contact_company_office_id;
		$co_creator_phone_contact_company_office_phone_number_id = $changeOrder->co_creator_phone_contact_company_office_phone_number_id;
		$co_creator_fax_contact_company_office_phone_number_id = $changeOrder->co_creator_fax_contact_company_office_phone_number_id;
		$co_creator_contact_mobile_phone_number_id = $changeOrder->co_creator_contact_mobile_phone_number_id;
		$co_recipient_contact_id = $changeOrder->co_recipient_contact_id;
		$co_recipient_contact_company_office_id = $changeOrder->co_recipient_contact_company_office_id;
		$co_recipient_phone_contact_company_office_phone_number_id = $changeOrder->co_recipient_phone_contact_company_office_phone_number_id;
		$co_recipient_fax_contact_company_office_phone_number_id = $changeOrder->co_recipient_fax_contact_company_office_phone_number_id;
		$co_recipient_contact_mobile_phone_number_id = $changeOrder->co_recipient_contact_mobile_phone_number_id;
		$co_initiator_contact_id = $changeOrder->co_initiator_contact_id;
		$co_initiator_contact_company_office_id = $changeOrder->co_initiator_contact_company_office_id;
		$co_initiator_phone_contact_company_office_phone_number_id = $changeOrder->co_initiator_phone_contact_company_office_phone_number_id;
		$co_initiator_fax_contact_company_office_phone_number_id = $changeOrder->co_initiator_fax_contact_company_office_phone_number_id;
		$co_initiator_contact_mobile_phone_number_id = $changeOrder->co_initiator_contact_mobile_phone_number_id;
		$co_title = $changeOrder->co_title;
		$co_plan_page_reference = $changeOrder->co_plan_page_reference;
		$co_statement = $changeOrder->co_statement;
		$co_created = $changeOrder->created;
		$co_revised_project_completion_date = $changeOrder->co_revised_project_completion_date;
		$co_closed_date = $changeOrder->co_closed_date;
		$co_total = $changeOrder->co_total;

		if($co_delay_days==NULL ||$co_delay_days=="")
		{
			$co_delay_days ="TBD";
		}

		// HTML Entity Escaped Data
		$changeOrder->htmlEntityEscapeProperties();
		$escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
		$escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
		$escaped_co_statement = $changeOrder->escaped_co_statement;
		$escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
		$escaped_co_title = $changeOrder->escaped_co_title;

		if (empty($escaped_co_custom_sequence_number)) {
			$escaped_co_custom_sequence_number = '&nbsp;';
		}

		if (empty($co_revised_project_completion_date)) {
			$co_revised_project_completion_date = '&nbsp;';
		}

		if (empty($escaped_co_plan_page_reference)) {
			$escaped_co_plan_page_reference = '&nbsp;';
		}

		if ($changeOrderPriority) {
			$change_order_priority = $changeOrderPriority->change_order_priority;
		} else {
			$change_order_priority = '&nbsp;';
		}

		if ($coCostCode) {
			// Extra: Change Order Cost Code - Cost Code Division
			$coCostCodeDivision = $coCostCode->getCostCodeDivision();
			/* @var $coCostCodeDivision CostCodeDivision */

			$formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false, $user_company_id);


		} else {
			$formattedCoCostCode = '&nbsp;';
		}

		//$recipient = Contact::findContactByIdExtended($database, $co_recipient_contact_id);
		/* @var $recipient Contact */

		if ($coRecipientContact) {
			$coRecipientContactFullName = $coRecipientContact->getContactFullName();
			$coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
		} else {
			$coRecipientContactFullName = '';
			$coRecipientContactFullNameHtmlEscaped = '&nbsp;';
		}

		// Convert co_created to a Unix timestamp
		$openDateUnixTimestamp = strtotime($co_created);
		//$openDateDisplayString = date('n/j/Y g:ma');
		$oneDayInSeconds = 86400;
		$daysOpen = '';

		//$formattedCoCreatedDate = date("m/d/Y g:i a", $openDateUnixTimestamp);
		$formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);

		// change_order_statuses:
		// 1 - Draft
		// 2 - Open
		// 3 - In Progress
		// 4 - Closed

		$change_order_status = $changeOrderStatus->change_order_status;
		// if Change Order status is "closed"
		if (!$co_closed_date) {
			$co_closed_date = '0000-00-00';
		}
		if (($change_order_status == 'Closed') && ($co_closed_date <> '0000-00-00')) {
			$closedDateUnixTimestamp = strtotime($co_closed_date);
			if ($co_closed_date <> '0000-00-00') {

				$daysOpenNumerator = $closedDateUnixTimestamp - $openDateUnixTimestamp;
				$daysOpenDenominator = $oneDayInSeconds;
				$daysOpen = $daysOpenNumerator / $daysOpenDenominator;
				$daysOpen = ceil($daysOpen);

			}
		} else {

			$nowDate = date('Y-m-d');
			$nowDateUnixTimestamp = strtotime($nowDate);
			$daysOpenNumerator = $nowDateUnixTimestamp - $openDateUnixTimestamp;
			$daysOpenDenominator = $oneDayInSeconds;
			$daysOpen = $daysOpenNumerator / $daysOpenDenominator;
			$daysOpen = ceil($daysOpen);

		}

		// There was an instance of $daysOpen showing as "-0"
		if (($daysOpen == 0) || ($daysOpen == '-0')) {
			$daysOpen = 0;
		}

		$co_total = Format::formatCurrency($co_total);

		if ($change_order_type == 'Potential Change Order') {
			$change_order_type_abbreviated = 'PCO';
		} elseif ($change_order_type == 'Change Order Request') {
			$change_order_type_abbreviated = 'COR';
			$co_sequence_number= $co_type_prefix;
		} elseif ($change_order_type == 'Owner Change Order') {
			$change_order_type_abbreviated = 'OCO';
		}

		if(trim($change_order_status) == 'Rejected'){
			 $coTotal = '<s>'.$co_total.'</s>';
			 $coSeqNumber = '<s>'.$co_sequence_number.'</s>';
		}else{
			 $coTotal = $co_total;
			 $coSeqNumber = $co_sequence_number;
		}

		$session = Zend_Registry::get('session');
		$debugMode = $session->getDebugMode();
		$userRole = $session->getUserRole();
		$userCanManageChangeOrders = checkPermissionForAllModuleAndRole($database,'change_orders_manage');
		if($userCanManageChangeOrders || $userRole == "global_admin")
		{
			$changeEdit ="onclick='ChangeOrders__EditCoDialog($change_order_id)'";
			$cursorClass = "";
		}
		else{
			$coPdfUrl="";
			if (isset($co_file_manager_file_id) && !empty($co_file_manager_file_id)) {
				$coFileManagerFile = FileManagerFile::findById($database, $co_file_manager_file_id);
				if($coFileManagerFile)
				{
				$coPdfUrl = $coFileManagerFile->generateUrl();
				}
			}
			$changeEdit ="onclick='ChangeOrders__openCoPdfInNewTab(&apos;$coPdfUrl&apos;)'";
			$cursorClass = "table-default-cursor";
		}

		if ($pdfFlag == true) {
			$stylePdf = "style='display:none;'";
		}

		$subAttach=attachDocumentLink($change_order_id, $database);
		$subAttachCount = $subAttach['count'];
		$subAttachFiles = $subAttach['files'];
		if ($subAttachCount > 0) {
			$linkDocument = "
			<span id='documentLinkShow_$change_order_id' class='changeOrderbtn_$change_order_id hoverLink' style='color:#06c;text-decoration:underline;' >Link</span>
			<div id='fileLinkShow_$change_order_id' class='holdChangeOrder dropdown-content-change-order' $stylePdf>$subAttachFiles</div>
			";
			$tdOnclick = 'onclick="showFileDropdown('.$change_order_id.')"';
		}else{
			$linkDocument = "";
			$tdOnclick = $changeEdit;
		}
		// To get all the cost break down cost codes
		$costdata = getCOCostcodeFromCostBreakDown($database, $user_company_id,$change_order_id);
		
		// Swapping the column CO & Custom #
		if($change_order_status_id==2 && $change_order_type_abbreviated=='COR')
		{
		$swapColumn =<<<END_OF_CO_SWAP
		<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--co_custom_sequence_number--$change_order_id" nowrap>$escaped_co_custom_sequence_number</td>
		<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--co_sequence_number--$change_order_id" nowrap>$coSeqNumber</td>
END_OF_CO_SWAP;
		}else {
			$swapColumn =<<<END_OF_CO_SWAP
			<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--co_sequence_number--$change_order_id" nowrap>$coSeqNumber</td>
			<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--co_custom_sequence_number--$change_order_id" nowrap>$escaped_co_custom_sequence_number</td>
END_OF_CO_SWAP;
		}

		if($debugMode){
			$coTableChangeOrderId = <<<END_OF_CHANGE_ORDER_ID
			<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--co_id--$change_order_id" nowrap>$change_order_id</td>
END_OF_CHANGE_ORDER_ID;
		}
		
		$coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY

		  <tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="table-row-tooltip">	
		  $coTableChangeOrderId
		 	<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--co_custom_sequence_number--$change_order_id" nowrap>$escaped_co_custom_sequence_number</td>
		 	<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--co_sequence_number--$change_order_id" nowrap>$coSeqNumber</td>		
			<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--change_order_type--$change_order_id" nowrap>$change_order_type_abbreviated<input type="hidden" id="manage-change_order-record--change_orders--change_order_type_id--$change_order_id" value="$change_order_type_id"></td>
			<td class="textAlignLeft" $changeEdit  id="manage-change_order-record--change_orders--co_title--$change_order_id">$escaped_co_title</td>
			<td class="textAlignLeft" $changeEdit  id="manage-change_order-record--change_orders--change_order_priority--$change_order_id" nowrap>$change_order_priority<input type="hidden" id="manage-change_order-record--change_orders--change_order_priority_id--$change_order_id" value="$change_order_priority_id"></td>
			<td class="textAlignRight" $changeEdit  id="manage-change_order-record--change_orders--co_total--$change_order_id" nowrap>$coTotal</td>
			<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--co_delay_days--$change_order_id" nowrap>$co_delay_days</td>
			<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--co_created--$change_order_id" nowrap>$formattedCoCreatedDate</td>
			<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--change_order_status--$change_order_id" nowrap>$change_order_status<input type="hidden" id="manage-change_order-record--change_orders--change_order_status_id--$change_order_id" value="$change_order_status_id"></td>
			<td class="textAlignLeft" $changeEdit  id="manage-change_order-record--change_orders--co_plan_page_reference--$change_order_id" nowrap>$escaped_co_plan_page_reference</td>
			<td class="textAlignCenter changeOrderbtn_$change_order_id" $tdOnclick>$linkDocument</td>
			<!--<td class="textAlignCenter" $changeEdit  id="manage-change_order-record--change_orders--co_cost_code_id--$change_order_id" nowrap> $costdata </td>-->
		</tr>

END_CHANGE_ORDER_TABLE_TBODY;
	}

	return $coTableTbody;
}

function attachDocumentLink($changeOrderId, $database)
	{
		
		$db = DBI::getInstance($database);
		$attachmentQuery = "SELECT s.co_attachment_file_manager_file_id, f.virtual_file_name , s.upload_execute FROM file_manager_files as  f JOIN change_order_attachments s  ON f.id = s.co_attachment_file_manager_file_id  WHERE s.change_order_id='$changeOrderId' and s.upload_execute='Y'";
		$db->query($attachmentQuery);
		$attachmentRecords = array();
		while($attachmentRow = $db->fetch())
		{
			$attachmentRecords[] = $attachmentRow;
		}
		$db->free_result();
		$attach = [];
		$count = count($attachmentRecords);
		$attachmentHtml = "<ul id='change_order_$changeOrderId' style='list-style:none; margin:0; padding:0'>";
		foreach($attachmentRecords as $attachmentRecord){
			$attachmentId = $attachmentRecord['co_attachment_file_manager_file_id'];
			$attachmentName = $attachmentRecord['virtual_file_name'];
			$value = $attachmentId;
			$FileManagerFile = FileManagerFile::findById($db, $attachmentId);
			$attachmentId = $FileManagerFile->generateUrl();
			$attachmentHtml .= '<li id="record_container--manage-file_manager_file-record--file_manager_files--'.$attachmentId.'" class="drop-inner"><img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order"><a target="_blank" href="'.$attachmentId.'" style="float: left;padding-left: 5px;padding-top: 5px;">'.$attachmentName.'</a></li>';
		}
		$attachmentHtml .= '</ul>';
		$attach['count'] = $count;
		$attach['files'] = $attachmentHtml;
		return $attach;
	}

function renderCORforBudgetList($database, $project_id,$primeContractScheduledValueTotal,$fillerColumns)
{
	$loadChangeOrdersByProjectIdOptions = new Input();
	$loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
	$loadChangeOrdersByProjectIdOptions->change_order_type_id = 2;
	$loadChangeOrdersByProjectIdOptions->change_order_status_id = 2; //For approved 
	$totalCORs = ChangeOrder::loadChangeOrdersCountByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);

	if ($totalCORs == 0) {
		return '';
	}

	$arrChangeOrders = ChangeOrder::loadChangeOrdersByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);

	$coTableTbody = '<tr class="budgetCR">'.$fillerColumns.
	'<td></td>
	<td align="center" ><b>Custom #</b></td>
	<td align="center" ><b>COR</b></td>
	<td align="center"><b>Title</b></td>
	<td align="center"><b>Amount</b></td>
	<td align="center"><b>Created Date</b></td>
	<td align="center"><b>Days</b></td>
	<td colspan="10"><b>Reason</b></td>
	</tr>';
	$sum_co_total =0;
	foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
		/* @var $changeOrder ChangeOrder */

		$project = $changeOrder->getProject();
		/* @var $project Project */

		$changeOrderType = $changeOrder->getChangeOrderType();
		/* @var $changeOrderType ChangeOrderType */
		$change_order_type = $changeOrderType->change_order_type;

		$changeOrderStatus = $changeOrder->getChangeOrderStatus();
		/* @var $changeOrderStatus ChangeOrderStatus */

		$changeOrderPriority = $changeOrder->getChangeOrderPriority();
		/* @var $changeOrderPriority ChangeOrderPriority */

		$changeOrderDistributionMethod = $changeOrder->getChangeOrderDistributionMethod();
		/* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
		$change_order_distribution_method = '';

		$coFileManagerFile = $changeOrder->getCoFileManagerFile();
		/* @var $coFileManagerFile FileManagerFile */

		$coCostCode = $changeOrder->getCoCostCode();
		/* @var $coCostCode CostCode */

		$coCreatorContact = $changeOrder->getCoCreatorContact();
		/* @var $coCreatorContact Contact */

		$coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
		/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */

		$coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
		/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
		/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
		/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

		$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
		/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

		$coRecipientContact = $changeOrder->getCoRecipientContact();
		/* @var $coRecipientContact Contact */

		$coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
		/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */

		$coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
		/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
		/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
		/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */

		$coInitiatorContact = $changeOrder->getCoInitiatorContact();
		/* @var $coInitiatorContact Contact */

		$coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
		/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */

		$coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
		/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
		/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();
		/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */

		$co_sequence_number = $changeOrder->co_sequence_number;
		$co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
		$co_scheduled_value = $changeOrder->co_scheduled_value;
		$co_delay_days = $changeOrder->co_delay_days;
		$change_order_type_id = $changeOrder->change_order_type_id;
		$change_order_status_id = $changeOrder->change_order_status_id;
		$change_order_priority_id = $changeOrder->change_order_priority_id;
		$change_order_distribution_method_id = $changeOrder->change_order_distribution_method_id;
		$co_file_manager_file_id = $changeOrder->co_file_manager_file_id;
		$co_cost_code_id = $changeOrder->co_cost_code_id;
		$co_creator_contact_id = $changeOrder->co_creator_contact_id;
		$co_creator_contact_company_office_id = $changeOrder->co_creator_contact_company_office_id;
		$co_creator_phone_contact_company_office_phone_number_id = $changeOrder->co_creator_phone_contact_company_office_phone_number_id;
		$co_creator_fax_contact_company_office_phone_number_id = $changeOrder->co_creator_fax_contact_company_office_phone_number_id;
		$co_creator_contact_mobile_phone_number_id = $changeOrder->co_creator_contact_mobile_phone_number_id;
		$co_recipient_contact_id = $changeOrder->co_recipient_contact_id;
		$co_recipient_contact_company_office_id = $changeOrder->co_recipient_contact_company_office_id;
		$co_recipient_phone_contact_company_office_phone_number_id = $changeOrder->co_recipient_phone_contact_company_office_phone_number_id;
		$co_recipient_fax_contact_company_office_phone_number_id = $changeOrder->co_recipient_fax_contact_company_office_phone_number_id;
		$co_recipient_contact_mobile_phone_number_id = $changeOrder->co_recipient_contact_mobile_phone_number_id;
		$co_initiator_contact_id = $changeOrder->co_initiator_contact_id;
		$co_initiator_contact_company_office_id = $changeOrder->co_initiator_contact_company_office_id;
		$co_initiator_phone_contact_company_office_phone_number_id = $changeOrder->co_initiator_phone_contact_company_office_phone_number_id;
		$co_initiator_fax_contact_company_office_phone_number_id = $changeOrder->co_initiator_fax_contact_company_office_phone_number_id;
		$co_initiator_contact_mobile_phone_number_id = $changeOrder->co_initiator_contact_mobile_phone_number_id;
		$co_title = $changeOrder->co_title;
		$co_plan_page_reference = $changeOrder->co_plan_page_reference;
		$co_statement = $changeOrder->co_statement;
		$co_created = $changeOrder->created;
		$co_revised_project_completion_date = $changeOrder->co_revised_project_completion_date;
		$co_closed_date = $changeOrder->co_closed_date;
		$co_total =$changeOrder->co_total;
		$co_type_prefix= $changeOrder->co_type_prefix;
		$coCustomSeq = $changeOrder->co_custom_sequence_number;

		// HTML Entity Escaped Data
		$changeOrder->htmlEntityEscapeProperties();
		$escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
		$escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
		$escaped_co_statement = $changeOrder->escaped_co_statement;
		$escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
		$escaped_co_title = $changeOrder->escaped_co_title;

		if (empty($escaped_co_custom_sequence_number)) {
			$escaped_co_custom_sequence_number = $co_sequence_number;
		}

		if (empty($co_revised_project_completion_date)) {
			$co_revised_project_completion_date = '&nbsp;';
		}

		if (empty($escaped_co_plan_page_reference)) {
			$escaped_co_plan_page_reference = '&nbsp;';
		}

		if ($changeOrderPriority) {
			$change_order_priority = $changeOrderPriority->change_order_priority;
		} else {
			$change_order_priority = '&nbsp;';
		}

		if ($coCostCode) {
			// Extra: Change Order Cost Code - Cost Code Division
			$coCostCodeDivision = $coCostCode->getCostCodeDivision();
			/* @var $coCostCodeDivision CostCodeDivision */

			$formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false);

			$coCostCode->htmlEntityEscapeProperties();
			$escaped_cost_code_description = $coCostCode->escaped_cost_code_description;


		} else {
			$formattedCoCostCode = '&nbsp;';
			$escaped_cost_code_description = '';
		}


		/* @var $recipient Contact */

		if ($coRecipientContact) {
			$coRecipientContactFullName = $coRecipientContact->getContactFullName();
			$coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
		} else {
			$coRecipientContactFullName = '';
			$coRecipientContactFullNameHtmlEscaped = '&nbsp;';
		}

		// Convert co_created to a Unix timestamp
		$openDateUnixTimestamp = strtotime($co_created);
		//$openDateDisplayString = date('n/j/Y g:ma');
		$oneDayInSeconds = 86400;
		$daysOpen = '';

		$formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);

		// change_order_statuses:
		$change_order_status = $changeOrderStatus->change_order_status;
		// if Change Order status is "closed"
		if (!$co_closed_date) {
			$co_closed_date = '0000-00-00';
		}
		if (($change_order_status == 'Approved') && ($co_closed_date <> '0000-00-00')) {
			$closedDateUnixTimestamp = strtotime($co_closed_date);
			if ($co_closed_date <> '0000-00-00') {

				$daysOpenNumerator = $closedDateUnixTimestamp - $openDateUnixTimestamp;
				$daysOpenDenominator = $oneDayInSeconds;
				$daysOpen = $daysOpenNumerator / $daysOpenDenominator;
				$daysOpen = ceil($daysOpen);

			}
		} else {

			$nowDate = date('Y-m-d');
			$nowDateUnixTimestamp = strtotime($nowDate);
			$daysOpenNumerator = $nowDateUnixTimestamp - $openDateUnixTimestamp;
			$daysOpenDenominator = $oneDayInSeconds;
			$daysOpen = $daysOpenNumerator / $daysOpenDenominator;
			$daysOpen = ceil($daysOpen);

		}

		// There was an instance of $daysOpen showing as "-0"
		if (($daysOpen == 0) || ($daysOpen == '-0')) {
			$daysOpen = 0;
		}
		$sum_co_total=$sum_co_total+$co_total;

		$co_total = Format::formatCurrency($co_total);

		$coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY

		<tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="">
			$fillerColumns
			<td>
				&nbsp;
			</td>
			<td align="middle">$coCustomSeq</td>
			<td align="middle">$co_type_prefix</td>
			<td>
				$escaped_co_title
			</td>
			<td class="autosum-cosv" align="right" >
				$co_total
			</td>
			<td align="middle">
				$formattedCoCreatedDate
			</td>
		
			<td align="center" style="padding-right: 22px;">
				$co_delay_days
			</td>
			<td  colspan="10">
				$change_order_priority
			</td>		
		</tr>

END_CHANGE_ORDER_TABLE_TBODY;

	}
	$budget_total =$primeContractScheduledValueTotal+$sum_co_total;
	$sum_co_total =Format::formatCurrency($sum_co_total);
	$budget_total =Format::formatCurrency($budget_total);

	$coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
	<tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="bottom-content subtotal-row" >
		$fillerColumns
		<td colspan='4' align='center'><b>Approved Change Orders Total</b> </td>
		<td  align='right'><b>$sum_co_total</b> </td>
		<td colspan='12' ></td>
	</tr>
	<tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="bottom-content subtotal-row">
		$fillerColumns
		<td colspan='4' align='center'><b>Revised budget Total</b></td>
		<td align='right' ><b>$budget_total</b></td>
		<td colspan='12' > </td>
	</tr>
END_CHANGE_ORDER_TABLE_TBODY;

	

	return $coTableTbody;

}

//function renderCoBudgetListView_AsHtml($database, $project_id, $change_order_type_id)
function renderCoBudgetListView_AsHtml($database, $project_id)
{
	$loadChangeOrdersByProjectIdOptions = new Input();
	$loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
	$loadChangeOrdersByProjectIdOptions->change_order_type_id = 3;
	$totalOCOs = ChangeOrder::loadChangeOrdersCountByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);

	if ($totalOCOs == 0) {
		return '';
	}

	$arrChangeOrders = ChangeOrder::loadChangeOrdersByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);

	$coTableTbody = '';
	foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
		/* @var $changeOrder ChangeOrder */

		$project = $changeOrder->getProject();
		/* @var $project Project */

		$changeOrderType = $changeOrder->getChangeOrderType();
		/* @var $changeOrderType ChangeOrderType */
		$change_order_type = $changeOrderType->change_order_type;

		$changeOrderStatus = $changeOrder->getChangeOrderStatus();
		/* @var $changeOrderStatus ChangeOrderStatus */

		$changeOrderPriority = $changeOrder->getChangeOrderPriority();
		/* @var $changeOrderPriority ChangeOrderPriority */

		$changeOrderDistributionMethod = $changeOrder->getChangeOrderDistributionMethod();
		/* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
		//$change_order_distribution_method = $changeOrderDistributionMethod->change_order_distribution_method;
		$change_order_distribution_method = '';

		$coFileManagerFile = $changeOrder->getCoFileManagerFile();
		/* @var $coFileManagerFile FileManagerFile */

		$coCostCode = $changeOrder->getCoCostCode();
		/* @var $coCostCode CostCode */

		$coCreatorContact = $changeOrder->getCoCreatorContact();
		/* @var $coCreatorContact Contact */

		$coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
		/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */

		$coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
		/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
		/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
		/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

		$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
		/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

		$coRecipientContact = $changeOrder->getCoRecipientContact();
		/* @var $coRecipientContact Contact */

		$coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
		/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */

		$coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
		/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
		/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
		/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */

		$coInitiatorContact = $changeOrder->getCoInitiatorContact();
		/* @var $coInitiatorContact Contact */

		$coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
		/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */

		$coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
		/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
		/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();
		/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */

		$co_sequence_number = $changeOrder->co_sequence_number;
		$co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
		$co_scheduled_value = $changeOrder->co_scheduled_value;
		$co_delay_days = $changeOrder->co_delay_days;
		$change_order_type_id = $changeOrder->change_order_type_id;
		$change_order_status_id = $changeOrder->change_order_status_id;
		$change_order_priority_id = $changeOrder->change_order_priority_id;
		$change_order_distribution_method_id = $changeOrder->change_order_distribution_method_id;
		$co_file_manager_file_id = $changeOrder->co_file_manager_file_id;
		$co_cost_code_id = $changeOrder->co_cost_code_id;
		$co_creator_contact_id = $changeOrder->co_creator_contact_id;
		$co_creator_contact_company_office_id = $changeOrder->co_creator_contact_company_office_id;
		$co_creator_phone_contact_company_office_phone_number_id = $changeOrder->co_creator_phone_contact_company_office_phone_number_id;
		$co_creator_fax_contact_company_office_phone_number_id = $changeOrder->co_creator_fax_contact_company_office_phone_number_id;
		$co_creator_contact_mobile_phone_number_id = $changeOrder->co_creator_contact_mobile_phone_number_id;
		$co_recipient_contact_id = $changeOrder->co_recipient_contact_id;
		$co_recipient_contact_company_office_id = $changeOrder->co_recipient_contact_company_office_id;
		$co_recipient_phone_contact_company_office_phone_number_id = $changeOrder->co_recipient_phone_contact_company_office_phone_number_id;
		$co_recipient_fax_contact_company_office_phone_number_id = $changeOrder->co_recipient_fax_contact_company_office_phone_number_id;
		$co_recipient_contact_mobile_phone_number_id = $changeOrder->co_recipient_contact_mobile_phone_number_id;
		$co_initiator_contact_id = $changeOrder->co_initiator_contact_id;
		$co_initiator_contact_company_office_id = $changeOrder->co_initiator_contact_company_office_id;
		$co_initiator_phone_contact_company_office_phone_number_id = $changeOrder->co_initiator_phone_contact_company_office_phone_number_id;
		$co_initiator_fax_contact_company_office_phone_number_id = $changeOrder->co_initiator_fax_contact_company_office_phone_number_id;
		$co_initiator_contact_mobile_phone_number_id = $changeOrder->co_initiator_contact_mobile_phone_number_id;
		$co_title = $changeOrder->co_title;
		$co_plan_page_reference = $changeOrder->co_plan_page_reference;
		$co_statement = $changeOrder->co_statement;
		$co_created = $changeOrder->created;
		$co_revised_project_completion_date = $changeOrder->co_revised_project_completion_date;
		$co_closed_date = $changeOrder->co_closed_date;

		// HTML Entity Escaped Data
		$changeOrder->htmlEntityEscapeProperties();
		$escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
		$escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
		$escaped_co_statement = $changeOrder->escaped_co_statement;
		$escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
		$escaped_co_title = $changeOrder->escaped_co_title;

		if (empty($escaped_co_custom_sequence_number)) {
			$escaped_co_custom_sequence_number = 'OCO #' . $co_sequence_number;
		}

		if (empty($co_revised_project_completion_date)) {
			$co_revised_project_completion_date = '&nbsp;';
		}

		if (empty($escaped_co_plan_page_reference)) {
			$escaped_co_plan_page_reference = '&nbsp;';
		}

		if ($changeOrderPriority) {
			$change_order_priority = $changeOrderPriority->change_order_priority;
		} else {
			$change_order_priority = '&nbsp;';
		}

		if ($coCostCode) {
			// Extra: Change Order Cost Code - Cost Code Division
			$coCostCodeDivision = $coCostCode->getCostCodeDivision();
			/* @var $coCostCodeDivision CostCodeDivision */

			$formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false);

			$coCostCode->htmlEntityEscapeProperties();
			$escaped_cost_code_description = $coCostCode->escaped_cost_code_description;

			
		} else {
			$formattedCoCostCode = '&nbsp;';
			$escaped_cost_code_description = '';
		}

		//$recipient = Contact::findContactByIdExtended($database, $co_recipient_contact_id);
		/* @var $recipient Contact */

		if ($coRecipientContact) {
			$coRecipientContactFullName = $coRecipientContact->getContactFullName();
			$coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
		} else {
			$coRecipientContactFullName = '';
			$coRecipientContactFullNameHtmlEscaped = '&nbsp;';
		}

		// Convert co_created to a Unix timestamp
		$openDateUnixTimestamp = strtotime($co_created);
		//$openDateDisplayString = date('n/j/Y g:ma');
		$oneDayInSeconds = 86400;
		$daysOpen = '';

		//$formattedCoCreatedDate = date("m/d/Y g:i a", $openDateUnixTimestamp);
		$formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);

		// change_order_statuses:
		// 1 - Draft
		// 2 - Open
		// 3 - In Progress
		// 4 - Closed

		$change_order_status = $changeOrderStatus->change_order_status;
		// if Change Order status is "closed"
		if (!$co_closed_date) {
			$co_closed_date = '0000-00-00';
		}
		if (($change_order_status == 'Closed') && ($co_closed_date <> '0000-00-00')) {
			$closedDateUnixTimestamp = strtotime($co_closed_date);
			if ($co_closed_date <> '0000-00-00') {

				$daysOpenNumerator = $closedDateUnixTimestamp - $openDateUnixTimestamp;
				$daysOpenDenominator = $oneDayInSeconds;
				$daysOpen = $daysOpenNumerator / $daysOpenDenominator;
				$daysOpen = ceil($daysOpen);

			}
		} else {

			$nowDate = date('Y-m-d');
			$nowDateUnixTimestamp = strtotime($nowDate);
			$daysOpenNumerator = $nowDateUnixTimestamp - $openDateUnixTimestamp;
			$daysOpenDenominator = $oneDayInSeconds;
			$daysOpen = $daysOpenNumerator / $daysOpenDenominator;
			$daysOpen = ceil($daysOpen);

		}

		// There was an instance of $daysOpen showing as "-0"
		if (($daysOpen == 0) || ($daysOpen == '-0')) {
			$daysOpen = 0;
		}

		$co_scheduled_value = Format::formatCurrency($co_scheduled_value);

		//	<td class="textAlignLeft" id="manage-change_order-record--change_orders--co_revised_project_completion_date--$change_order_id" nowrap>$co_revised_project_completion_date</td>

		$coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY

		<tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="">
			<td>
				&nbsp;
			</td>
			<td align="middle">
				$escaped_co_custom_sequence_number
			</td>
			<td align="right" style="padding-right: 22px;">
				$co_delay_days
			</td>
			<td class="autosum-cosv" align="right" style="padding-right: 22px;">
				$co_scheduled_value
			</td>
			<td align="right">
				$change_order_priority
			</td>
			<td>
				$escaped_co_title
			</td>
			<!--td>&nbsp;</td>
			<td>OCO #$co_sequence_number &mdash; $escaped_co_title</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td-->
		</tr>

END_CHANGE_ORDER_TABLE_TBODY;

	}

	return $coTableTbody;

/*
		<tr id="record_container--manage-change_order-record--change_orders--$change_order_id" onclick="ChangeOrders__loadChangeOrderModalDialog('$change_order_id');">
			<td class="textAlignCenter" id="manage-change_order-record--change_orders--co_sequence_number--$change_order_id" nowrap>$co_sequence_number</td>
			<td class="textAlignCenter" id="manage-change_order-record--change_orders--change_order_type--$change_order_id" nowrap>$change_order_type<input type="hidden" id="manage-change_order-record--change_orders--change_order_type_id--$change_order_id" value="$change_order_type_id"></td>
			<td class="textAlignCenter" id="manage-change_order-record--change_orders--co_title--$change_order_id">$escaped_co_title</td>
			<td class="textAlignCenter" id="manage-change_order-record--change_orders--change_order_priority--$change_order_id" nowrap>$change_order_priority<input type="hidden" id="manage-change_order-record--change_orders--change_order_priority_id--$change_order_id" value="$change_order_priority_id"></td>
			<td class="textAlignCenter" id="manage-change_order-record--change_orders--co_scheduled_value--$change_order_id" nowrap>$co_scheduled_value</td>
			<td class="textAlignCenter" id="manage-change_order-record--change_orders--co_delay_days--$change_order_id" nowrap>$co_delay_days</td>
			<td class="textAlignCenter" id="manage-change_order-record--change_orders--co_created--$change_order_id" nowrap>$formattedCoCreatedDate</td>
			<td class="textAlignCenter" id="manage-change_order-record--change_orders--change_order_status--$change_order_id" nowrap>$change_order_status<input type="hidden" id="manage-change_order-record--change_orders--change_order_status_id--$change_order_id" value="$change_order_status_id"></td>
			<td class="textAlignCenter" id="manage-change_order-record--change_orders--co_plan_page_reference--$change_order_id" nowrap>$escaped_co_plan_page_reference</td>
			<td class="textAlignCenter" id="manage-change_order-record--change_orders--co_cost_code_id--$change_order_id" nowrap>$formattedCoCostCode</td>
		</tr>
*/

}

function loadChangeOrder($database, $user_company_id, $contact_id, $project_id, $change_order_id)
{
	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$debugMode = $session->getDebugMode();

	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}

	// FileManagerFolder
	$virtual_file_path = '/Change Orders/';
	$coFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $contact_id, $project_id, $virtual_file_path);
	/* @var $coFileManagerFolder FileManagerFolder */

	$changeOrder = ChangeOrder::findChangeOrderByIdExtended($database, $change_order_id);
	/* @var $changeOrder ChangeOrder */

	if (!$changeOrder) {
		return '';
	}

	$change_order_id = $changeOrder->change_order_id;

	$change_order_id = $changeOrder->change_order_id;
	$project_id = $changeOrder->project_id;
	$co_sequence_number = $changeOrder->co_sequence_number;
	$co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
	$co_scheduled_value = $changeOrder->co_scheduled_value;
	$co_delay_days = $changeOrder->co_delay_days;
	$change_order_type_id = $changeOrder->change_order_type_id;
	$change_order_status_id = $changeOrder->change_order_status_id;
	$change_order_priority_id = $changeOrder->change_order_priority_id;
	$change_order_distribution_method_id = $changeOrder->change_order_distribution_method_id;
	$co_file_manager_file_id = $changeOrder->co_file_manager_file_id;
	$co_cost_code_id = $changeOrder->co_cost_code_id;
	$co_creator_contact_id = $changeOrder->co_creator_contact_id;
	$co_creator_contact_company_office_id = $changeOrder->co_creator_contact_company_office_id;
	$co_creator_phone_contact_company_office_phone_number_id = $changeOrder->co_creator_phone_contact_company_office_phone_number_id;
	$co_creator_fax_contact_company_office_phone_number_id = $changeOrder->co_creator_fax_contact_company_office_phone_number_id;
	$co_creator_contact_mobile_phone_number_id = $changeOrder->co_creator_contact_mobile_phone_number_id;
	$co_recipient_contact_id = $changeOrder->co_recipient_contact_id;
	$co_recipient_contact_company_office_id = $changeOrder->co_recipient_contact_company_office_id;
	$co_recipient_phone_contact_company_office_phone_number_id = $changeOrder->co_recipient_phone_contact_company_office_phone_number_id;
	$co_recipient_fax_contact_company_office_phone_number_id = $changeOrder->co_recipient_fax_contact_company_office_phone_number_id;
	$co_recipient_contact_mobile_phone_number_id = $changeOrder->co_recipient_contact_mobile_phone_number_id;
	$co_initiator_contact_id = $changeOrder->co_initiator_contact_id;
	$co_initiator_contact_company_office_id = $changeOrder->co_initiator_contact_company_office_id;
	$co_initiator_phone_contact_company_office_phone_number_id = $changeOrder->co_initiator_phone_contact_company_office_phone_number_id;
	$co_initiator_fax_contact_company_office_phone_number_id = $changeOrder->co_initiator_fax_contact_company_office_phone_number_id;
	$co_initiator_contact_mobile_phone_number_id = $changeOrder->co_initiator_contact_mobile_phone_number_id;
	$co_title = $changeOrder->co_title;
	$co_plan_page_reference = $changeOrder->co_plan_page_reference;
	$co_statement = $changeOrder->co_statement;
	$co_created = $changeOrder->created;
	$co_revised_project_completion_date = $changeOrder->co_revised_project_completion_date;
	$co_closed_date = $changeOrder->co_closed_date;

	// HTML Entity Escaped Data
	$changeOrder->htmlEntityEscapeProperties();
	$escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
	$escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
	$escaped_co_statement = $changeOrder->escaped_co_statement;
	$escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
	$escaped_co_title = $changeOrder->escaped_co_title;

	$co_scheduled_value = Format::formatCurrency($co_scheduled_value);

	$project = $changeOrder->getProject();
	/* @var $project Project */

	$changeOrderType = $changeOrder->getChangeOrderType();
	/* @var $changeOrderType ChangeOrderType */

	$changeOrderStatus = $changeOrder->getChangeOrderStatus();
	/* @var $changeOrderStatus ChangeOrderStatus */

	$changeOrderStatus->htmlEntityEscapeProperties();
	$change_order_status = $changeOrderStatus->change_order_status;
	$escaped_change_order_status = $changeOrderStatus->escaped_change_order_status;

	$changeOrderPriority = $changeOrder->getChangeOrderPriority();
	/* @var $changeOrderPriority ChangeOrderPriority */

	if ($changeOrderPriority) {
		$changeOrderPriority->htmlEntityEscapeProperties();
		$escaped_change_order_priority = $changeOrderPriority->escaped_change_order_priority;
	}

	/* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */

	$coFileManagerFile = $changeOrder->getCoFileManagerFile();
	/* @var $coFileManagerFile FileManagerFile */

	$coCostCode = $changeOrder->getCoCostCode();
	/* @var $coCostCode CostCode */

	if ($coCostCode) {
		// Extra: Change Order Cost Code - Cost Code Division
		$coCostCodeDivision = $coCostCode->getCostCodeDivision();
		/* @var $coCostCodeDivision CostCodeDivision */

		$formattedCoCostCode = $coCostCode->getFormattedCostCode($database);

		$htmlEntityEscapedFormattedCoCostCodeLabel = $coCostCode->getHtmlEntityEscapedFormattedCostCode();
	}

	$coCreatorContact = $changeOrder->getCoCreatorContact();
	/* @var $coCreatorContact Contact */

	$coCreatorDisplayName = '';
	if ($coCreatorContact) {
		// Extra: Change Order Creator - Contact Company
		$coCreatorContactCompany = $coCreatorContact->getContactCompany();
		/* @var $coCreatorContactCompany ContactCompany */

		$coCreatorContact->htmlEntityEscapeProperties();
		$coCreatorContactCompany->htmlEntityEscapeProperties();

		$co_creator_contact_company_name = $coCreatorContactCompany->contact_company_name;
		$co_creator_escaped_contact_company_name = $coCreatorContactCompany->escaped_contact_company_name;

		$coCreatorContactFullNameHtmlEscaped = $coCreatorContact->getContactFullNameHtmlEscaped();
		$co_creator_escaped_email = $coCreatorContact->escaped_email;

		if ($debugMode) {
			$coCreatorDisplayName = $co_creator_escaped_contact_company_name . ' (contact_company_id: ' . $coCreatorContactCompany->contact_company_id . ') &mdash; ' . $coCreatorContactFullNameHtmlEscaped . ' &lt;' . $co_creator_escaped_email . '&gt;' . ' (co_creator_contact_id: ' . $coCreatorContact->contact_id . ')';
		} else {
			$coCreatorDisplayName = $co_creator_escaped_contact_company_name . ' &mdash; ' . $coCreatorContactFullNameHtmlEscaped . ' [' . $co_creator_escaped_email . ']';
		}
	}

	$coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
	/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */

	$coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
	/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
	/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
	/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

	$coRecipientContact = $changeOrder->getCoRecipientContact();
	/* @var $coRecipientContact Contact */

	$coRecipientDisplayName = '';
	if ($coRecipientContact) {
		// Extra: Change Order Recipient - Contact Company
		$coRecipientContactCompany = $coRecipientContact->getContactCompany();
		/* @var $coRecipientContactCompany ContactCompany */

		$coRecipientContact->htmlEntityEscapeProperties();
		$coRecipientContactCompany->htmlEntityEscapeProperties();

		$co_recipient_contact_company_name = $coRecipientContactCompany->contact_company_name;
		$co_recipient_escaped_contact_company_name = $coRecipientContactCompany->escaped_contact_company_name;

		$coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
		$co_recipient_escaped_email = $coRecipientContact->escaped_email;

		if ($debugMode) {
			$coRecipientDisplayName = $co_recipient_escaped_contact_company_name . ' (contact_company_id: ' . $coRecipientContactCompany->contact_company_id . ') &mdash; ' . $coRecipientContactFullNameHtmlEscaped . ' &lt;' . $co_recipient_escaped_email . '&gt;' . ' (co_recipient_contact_id: ' . $coRecipientContact->contact_id . ')';
		} else {
			$coRecipientDisplayName = $co_recipient_escaped_contact_company_name . ' &mdash; ' . $coRecipientContactFullNameHtmlEscaped . ' [' . $co_recipient_escaped_email . ']';
		}
	}

	$coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
	/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */

	$coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
	/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
	/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
	/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */

	$coInitiatorContact = $changeOrder->getCoInitiatorContact();
	/* @var $coInitiatorContact Contact */

	// $coInitiatorDisplayName = '';
	// if ($coInitiatorContact) {
	// 	// Extra: Change Order Initiator - Contact Company
	// 	$coInitiatorContactCompany = $coInitiatorContact->getContactCompany();
	// 	/* @var $coInitiatorContactCompany ContactCompany */

	// 	$coInitiatorContact->htmlEntityEscapeProperties();
	// 	$coInitiatorContactCompany->htmlEntityEscapeProperties();

	// 	$co_initiator_contact_company_name = $coInitiatorContactCompany->contact_company_name;
	// 	$co_initiator_escaped_contact_company_name = $coInitiatorContactCompany->escaped_contact_company_name;

	// 	$coInitiatorContactFullNameHtmlEscaped = $coInitiatorContact->getContactFullNameHtmlEscaped();
	// 	$co_initiator_escaped_email = $coInitiatorContact->escaped_email;

	// 	if ($debugMode) {
	// 		$coInitiatorDisplayName = $co_initiator_escaped_contact_company_name . ' (contact_company_id: ' . $coInitiatorContactCompany->contact_company_id . ') &mdash; ' . $coInitiatorContactFullNameHtmlEscaped . ' &lt;' . $co_initiator_escaped_email . '&gt;' . ' (co_initiator_contact_id: ' . $coInitiatorContact->contact_id . ')';
	// 	} else {
	// 		$coInitiatorDisplayName = $co_initiator_escaped_contact_company_name . ' &mdash; ' . $coInitiatorContactFullNameHtmlEscaped . ' [' . $co_initiator_escaped_email . ']';
	// 	}
	// }

	$coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
	/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */

	$coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
	/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
	/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();
	/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */


	// Timestamps
	$coCreatedTimestampInt = strtotime($co_created);
	$coCreatedTimestampDisplayString = date('m/d/Y', $coCreatedTimestampInt);

	/*
	$coApprovedTimestampDisplayString = '';
	if (($change_order_status_id == 2) || ($change_order_status_id == 3)) {
		$coApprovedTimestampInt = strtotime($co_closed_date);
		$coApprovedTimestampDisplayString = date('n/j/Y', $coApprovedTimestampInt);
	}
	*/

	if ($co_revised_project_completion_date) {
		$coRevisedProjectCompletionDateInt = strtotime($co_revised_project_completion_date);
		$coRevisedProjectCompletionDateDisplayString = date('m/d/Y', $coRevisedProjectCompletionDateInt);
	} else {
		$coRevisedProjectCompletionDateDisplayString = '';
	}
	$js = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);"';
	$coRevisedProjectCompletionDateHtml = <<<END_HTML_CONTENT
<input id="manage-change_order-record--change_orders--co_revised_project_completion_date--$change_order_id" class="datepicker" $js style="padding-left: 5px;" type="text" value="$coRevisedProjectCompletionDateDisplayString">
END_HTML_CONTENT;


	/*
	$coClosedTimestampDisplayString = '';
	$coClosedHtml = '';
	$buttonCloseCoText = 'Close Change Order';
	$changeOrderStatusClosed = ChangeOrderStatus::findByChangeOrderStatus($database, 'Closed');
	$buttonCloseCoStatusId = $changeOrderStatusClosed->change_order_status_id;
	if ($change_order_status == 'Closed') {
		$coClosedTimestampInt = strtotime($co_closed_date);
		$coClosedTimestampDisplayString = date('n/j/Y', $coClosedTimestampInt);

		$coClosedHtml = '<label for="Project ID">Closed Date:</label><span class="coSpan">'.$coClosedTimestampDisplayString.'</span>';
		$buttonCloseCoText = 'Reopen Change Order';
		$changeOrderStatusOpen = ChangeOrderStatus::findByChangeOrderStatus($database, 'Open');
		$buttonCloseCoStatusId = $changeOrderStatusOpen->change_order_status_id;
	}
	*/

	$loadChangeOrderResponsesByChangeOrderIdOptions = new Input();
	$loadChangeOrderResponsesByChangeOrderIdOptions->forceLoadFlag = true;
	$arrChangeOrderResponsesByChangeOrderId = ChangeOrderResponse::loadChangeOrderResponsesByChangeOrderId($database, $change_order_id, $loadChangeOrderResponsesByChangeOrderIdOptions);
	$tableCoResponses = '';
	foreach ($arrChangeOrderResponsesByChangeOrderId as $change_order_response_id => $changeOrderResponse ) {
		/* @var $changeOrderResponse ChangeOrderResponse */

		$changeOrderResponse->htmlEntityEscapeProperties();

		$change_order_response_sequence_number = $changeOrderResponse->change_order_response_sequence_number;
		$change_order_response_type_id = $changeOrderResponse->change_order_response_type_id;
		$co_responder_contact_id = $changeOrderResponse->co_responder_contact_id;
		$co_responder_contact_company_office_id = $changeOrderResponse->co_responder_contact_company_office_id;
		$co_responder_phone_contact_company_office_phone_number_id = $changeOrderResponse->co_responder_phone_contact_company_office_phone_number_id;
		$co_responder_fax_contact_company_office_phone_number_id = $changeOrderResponse->co_responder_fax_contact_company_office_phone_number_id;
		$co_responder_contact_mobile_phone_number_id = $changeOrderResponse->co_responder_contact_mobile_phone_number_id;
		$change_order_response_title = $changeOrderResponse->change_order_response_title;
		$change_order_response = $changeOrderResponse->change_order_response;
		$change_order_response_modified_timestamp = $changeOrderResponse->modified;
		$change_order_response_created_timestamp = $changeOrderResponse->created;

		$escaped_change_order_response_title = $changeOrderResponse->escaped_change_order_response_title;
		$escaped_change_order_response_nl2br = $changeOrderResponse->escaped_change_order_response_nl2br;

		$coResponseCreatedTimestampInt = strtotime($change_order_response_created_timestamp);
		$coResponseCreatedTimestampDisplayString = date('n/j/Y g:ia', $coResponseCreatedTimestampInt);

		$coResponderContact = $changeOrderResponse->getCoResponderContact();
		/* @var $coResponderContact Contact */

		$coResponderContact->htmlEntityEscapeProperties();

		$coResponderContactFullNameHtmlEscaped = $coResponderContact->getContactFullNameHtmlEscaped();
		$co_responder_contact_escaped_title = $coResponderContact->escaped_title;

		$responseHeaderInfo = "Answered $coResponseCreatedTimestampDisplayString by $coResponderContactFullNameHtmlEscaped ($co_responder_contact_escaped_title)";

		$tableCoResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="CO_table2_content">
				$responseHeaderInfo
				<br>
				<p style="font-size: 13px;">$escaped_change_order_response_nl2br</p>
			</td>
		</tr>
END_HTML_CONTENT;

	}
	if ($tableCoResponses == '') {

		$tableCoResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="CO_table2_content">No notes.</td>
		</tr>
END_HTML_CONTENT;

	}

	$js = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);"';
	$coTitleInput = <<<END_HTML_CONTENT
<input id="manage-change_order-record--change_orders--co_title--$change_order_id" $js style="min-width: 600px;" type="text" value="$escaped_co_title">
END_HTML_CONTENT;

	$coCustomSequenceNumberInput = <<<END_HTML_CONTENT
<input id="manage-change_order-record--change_orders--co_custom_sequence_number--$change_order_id" $js style="padding-left: 5px;" type="text" value="$escaped_co_custom_sequence_number">
END_HTML_CONTENT;

	$coScheduldedValueInput = <<<END_HTML_CONTENT
<input id="manage-change_order-record--change_orders--co_scheduled_value--$change_order_id" $js style="padding-left: 5px;" type="text" value="$co_scheduled_value">
END_HTML_CONTENT;

	$coDelayDaysInput = <<<END_HTML_CONTENT
<input id="manage-change_order-record--change_orders--co_delay_days--$change_order_id" $js style="padding-left: 5px;" type="text" value="$co_delay_days">
END_HTML_CONTENT;

	$loadAllChangeOrderTypesOptions = new Input();
	$loadAllChangeOrderTypesOptions->forceLoadFlag = true;
	$arrChangeOrderTypes = ChangeOrderType::loadAllChangeOrderTypes($database, $loadAllChangeOrderTypesOptions);
	$ddlCoTypesId = 'ddl--manage-change_order-record--change_orders--change_order_type_id--' . $change_order_id;
	//$js = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);" class="moduleCO_dropdown"';
	$js = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);"';
	$ddlCoTypes = PageComponents::dropDownListFromObjects($ddlCoTypesId, $arrChangeOrderTypes, 'change_order_type_id', null, 'change_order_type', null, $change_order_type_id, '4', $js, '');

	$loadAllChangeOrderPrioritiesOptions = new Input();
	$loadAllChangeOrderPrioritiesOptions->forceLoadFlag = true;
	$arrChangeOrderPriorities = ChangeOrderPriority::loadAllChangeOrderPriorities($database, $loadAllChangeOrderPrioritiesOptions);
	$ddlCoPrioritiesId = 'ddl--manage-change_order-record--change_orders--change_order_priority_id--' . $change_order_id;
	//$js = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);" class="moduleCO_dropdown"';
	$js = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);"';
	$prependedOption = '<option value="">Optionally Select A Change Order Reason</option>';
	$ddlCoPriorities = PageComponents::dropDownListFromObjects($ddlCoPrioritiesId, $arrChangeOrderPriorities, 'change_order_priority_id', null, 'change_order_priority', null, $change_order_priority_id, '4', $js, $prependedOption);

	$loadAllChangeOrderStatusesOptions = new Input();
	$loadAllChangeOrderStatusesOptions->forceLoadFlag = true;
	$arrChangeOrderStatuses = ChangeOrderStatus::loadAllChangeOrderStatuses($database, $loadAllChangeOrderStatusesOptions);
	$ddlCoStatusesId = 'ddl--manage-change_order-record--change_orders--change_order_status_id--' . $change_order_id;
	//$js = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);" class="moduleCO_dropdown"';
	$js = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);"';
	$ddlCoStatuses = PageComponents::dropDownListFromObjects($ddlCoStatusesId, $arrChangeOrderStatuses, 'change_order_status_id', null, 'change_order_status', null, $change_order_status_id, '4', $js, '');

	$coCostCodesElementId = "ddl--manage-change_order-record--change_orders--co_cost_code_id--$change_order_id";

	$costCodesInput = new Input();
	$prependedOption = '';
	$tabIndex = '';
	//$js = 'style="width:95%"';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$selectedOption = $co_cost_code_id;
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $coCostCodesElementId;
	$costCodesInput->firstOption = '<option value="">Optionally Select A Cost Code Below For Reference</option>';
	//$costCodesInput->selectCssStyle = 'style="font-size: 1.3em; width: 400px;"';
	$costCodesInput->selectedOption = $co_cost_code_id;
	//$costCodesInput->additionalOnchange = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);"';
	$costCodesInput->additionalOnchange = 'ChangeOrders__updateCoViaPromiseChain(this);';
	$ddlCostCodes = buildCostCodeDropDownList($costCodesInput);

	/*
	$loadAllChangeOrderCostCodesOptions = new Input();
	$loadAllChangeOrderCostCodesOptions->forceLoadFlag = true;
	$arrChangeOrderCostCodes = ChangeOrderCostCode::loadAllChangeOrderCostCodes($database, $loadAllChangeOrderCostCodesOptions);
	$ddlCoCostCodesId = 'ddl--manage-change_order-record--change_orders--change_order_cost_code_id--' . $change_order_id;
	//$js = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);" class="moduleCO_dropdown"';
	$js = 'onchange="ChangeOrders__updateCoViaPromiseChain(this);"';
	$ddlCoCostCodes = PageComponents::dropDownListFromObjects($ddlCoCostCodesId, $arrChangeOrderCostCodes, 'change_order_cost_code_id', null, 'change_order_cost_code', null, $change_order_cost_code_id, '4', $js, '');
	*/

	$tableCoAttachments = '';
	$loadChangeOrderAttachmentsByChangeOrderIdOptions = new Input();
	$loadChangeOrderAttachmentsByChangeOrderIdOptions->forceLoadFlag = true;
	$arrChangeOrderAttachments = ChangeOrderAttachment::loadChangeOrderAttachmentsByChangeOrderId($database, $change_order_id, $loadChangeOrderAttachmentsByChangeOrderIdOptions);
	foreach ($arrChangeOrderAttachments as $changeOrderAttachment) {
		/* @var $changeOrderAttachment ChangeOrderAttachment */

		$change_order_attachment_id = $changeOrderAttachment->change_order_id . '-' . $changeOrderAttachment->co_attachment_file_manager_file_id;
		$co_attachment_file_manager_file_id = $changeOrderAttachment->co_attachment_file_manager_file_id;
		$co_attachment_source_contact_id = $changeOrderAttachment->co_attachment_source_contact_id;
		$sort_order = $changeOrderAttachment->sort_order;

		$coAttachmentSourceContact = Contact::findContactByIdExtended($database, $co_attachment_source_contact_id);
		// $coAttachmentSourceContactFullName = $coAttachmentSourceContact->getContactFullName();

		$fileManagerFile = FileManagerFile::findById($database, $co_attachment_file_manager_file_id);
		$file_manager_file_id = $fileManagerFile->file_manager_file_id;
		$user_company_id = $fileManagerFile->user_company_id;
		$user_id = $fileManagerFile->user_id;
		$project_id = $fileManagerFile->project_id;
		$file_manager_folder_id = $fileManagerFile->file_manager_folder_id;
		$file_location_id = $fileManagerFile->file_location_id;
		$virtual_file_name = $fileManagerFile->virtual_file_name;
		$virtual_file_mime_type = $fileManagerFile->virtual_file_mime_type;
		$modified = $fileManagerFile->modified;
		$created = $fileManagerFile->created;
		$deleted_flag = $fileManagerFile->deleted_flag;
		$directly_deleted_flag = $fileManagerFile->directly_deleted_flag;

		$fileManagerFile = FileManagerFile::findById($database, $co_attachment_file_manager_file_id);
		/* @var $fileManagerFile FileManagerFile */
		$virtual_file_name = $fileManagerFile->virtual_file_name;
		$fileUrl = $fileManagerFile->generateUrl();
		$elementId = 'record_container--manage-change_order_attachment-record--change_order_attachments--' . $change_order_attachment_id;
		$tableCoAttachments .= <<<END_HTML_CONTENT

		<tr id="$elementId">
			<td width="60%">
				<a href="javascript:ChangeOrders__deleteChangeOrderAttachmentViaPromiseChain('$elementId', 'manage-change_order_attachment-record', '$change_order_attachment_id');">X</a>
				<a href="$fileUrl" target="_blank">$virtual_file_name</a>
			</td>
			<td width="40%">$coAttachmentSourceContactFullName</td>
		</tr>
END_HTML_CONTENT;
	}

	$attachmentNumber = 1;

	/**/
	$input = new Input();
	$input->id = 'uploader--change_order_attachments--manage-change_order-record';
	$input->folder_id = $coFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Change Orders/';
	//$input->virtual_file_name = "Change Order #$co_sequence_number Attachment #$attachmentNumber.pdf";
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadChangeOrderAttachment';
	$input->allowed_extensions = 'pdf';
	$input->post_upload_js_callback = "ChangeOrders__postProcessCoAttachmentsViaPromiseChain(arrFileManagerFiles, 'container--change_order_attachments--manage-change_order-record')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();
	/**/

	/*
	// @todo Make this a temp file upload
	$input = new Input(); // uploaded-temp-file
	$input->id = 'temp-file-uploader--change_order_attachments';
	$input->folder_id = $coFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Change Orders/';
	//$input->virtual_file_name = "Change Order #$co_sequence_number Attachment #$attachmentNumber.pdf";
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadTempFilesOnly';
	$input->allowed_extensions = 'pdf';
	//$input->post_upload_js_callback = "appendCoTempFileIds(arrFileManagerFiles, { htmlAttributeGroup: 'uploaded-temp-file', uploadedTempFilesContainerElementId: 'record_list_container--uploaded-temp-file' });";
	$input->post_upload_js_callback = "appendCoTempFileIds(arrFileManagerFiles, { htmlAttributeGroup: 'uploaded-temp-file', tempFileUploaderElementId: 'temp-file-uploader--change_order_attachments', uploadedTempFilesContainerElementId: 'record_list_container--uploaded-temp-file--change_order_attachments' });";
	$input->file_upload_position = 1;
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();
	*/

	// Change Order Notifications.
	// @todo Subcontractor notifications.
	//$loadChangeOrderNotificationsByChangeOrderIdOptions = new Input();
	//$loadChangeOrderNotificationsByChangeOrderIdOptions->forceLoadFlag = true;
	//$arrChangeOrderNotificationsByChangeOrderId = ChangeOrderNotification::loadChangeOrderNotificationsByChangeOrderId($database, $change_order_id, $loadChangeOrderNotificationsByChangeOrderIdOptions);
	$arrChangeOrderNotificationsByChangeOrderId = array();

	$tableCoNotificationsTbody = <<<END_HTML_CONTENT

	<tr>
		<td width="46%" class="CO_table_header2">Subcontractor Notifications Sent</td>
		<td width="24%" class="CO_table_header2">Date Sent</td>
	</tr>
END_HTML_CONTENT;

	$coNotificationTitle = "Change Order Notification #$changeOrder->co_sequence_number";

	//$coRecipientContactFullName = $coRecipientContact->getContactFullName();
	$coRecipientContactFullName = 'Subcontractor Name';
	$encodedCoRecipientFullName = Data::entity_encode($coRecipientContactFullName);

	foreach ($arrChangeOrderNotificationsByChangeOrderId as $change_order_notification_id => $changeOrderNotification) {
		/* @var $changeOrderNotification ChangeOrderNotification */
		$change_order_notification_timestamp = $changeOrderNotification->change_order_notification_timestamp;

		$loadChangeOrderRecipientsByChangeOrderNotificationIdOptions = new Input();
		$loadChangeOrderRecipientsByChangeOrderNotificationIdOptions->forceLoadFlag = true;
		$arrChangeOrderRecipientsByChangeOrderNotificationId = ChangeOrderRecipient::loadChangeOrderRecipientsByChangeOrderNotificationId($database, $change_order_notification_id, $loadChangeOrderRecipientsByChangeOrderNotificationIdOptions);

		$tableCoNotificationsTbody .= <<<END_HTML_CONTENT

		<tr>
			<td class="CO_table2_content2">$coNotificationTitle - $coRecipientContactFullNameHtmlEscaped - PDF File.pdf</td>
			<td class="CO_table2_content2">$change_order_notification_timestamp</td>
		</tr>
END_HTML_CONTENT;

	}
	if (count($arrChangeOrderNotificationsByChangeOrderId) == 0) {
		$tableCoNotificationsTbody = '';
	}

	$viewPdfHtml = '';
	$co_file_manager_file_id = $changeOrder->co_file_manager_file_id;
	if (isset($co_file_manager_file_id) && !empty($co_file_manager_file_id)) {
		$coFileManagerFile = FileManagerFile::findById($database, $co_file_manager_file_id);
		$coPdfUrl = $coFileManagerFile->generateUrl();
		/*
		$uri = Zend_Registry::get('uri');
		$coPdfUrl = $uri->cdn . '_' . $co_file_manager_file_id;
		*/
		$viewPdfHtml = <<<END_HTML_CONTENT
		<input type="button" onclick="ChangeOrders__openCoPdfInNewTab('$coPdfUrl');" value="View Change Order PDF" style="font-size: 10pt;">&nbsp;
END_HTML_CONTENT;
	}

	$changeOrderResponseType = ChangeOrderResponseType::findByChangeOrderResponseType($database, 'Answer');
	$change_order_response_type_id = $changeOrderResponseType->change_order_response_type_id;

	//<input id="manage-change_order-record--change_orders--change_order_status_id--$change_order_id" type="button" value="$buttonCloseCoText" onclick="ChangeOrders__updateCoViaPromiseChain(this, { change_order_status_id: '$buttonCloseCoStatusId' });" class="padding8px" style="font-size: 10pt;">

	$htmlContent = <<<END_HTML_CONTENT

<div class="CO_table">
	<div class="CO_table_dark_header">Change Order #$co_sequence_number &mdash; $coTitleInput</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="4">

		<tr>
		<td colspan="2" class="CO_table_header2">Description</td>
		<td width="40%"  class="CO_table_header2">Change Order Details</td>
		</tr>

		<tr>
		<td colspan="2" class="CO_table2_content">
			<div id="divShowCoStatement">
				<p style="font-size: 13px" id="manage-change_order-record--change_orders--co_statement_p--$change_order_id">$escaped_co_statement_nl2br</p>
				<div class="textAlignRight">
					<input type="button" onclick="ChangeOrders__showEditCoStatement(this);" value="Edit">
				</div>
			</div>
			<div id="divEditCoStatement" class="hidden">
				<textarea id="manage-change_order-record--change_orders--co_statement--$change_order_id" class="CO_table2">$escaped_co_statement</textarea>
				<div class="textAlignRight" style="margin-top:10px">
					<input type="button" onclick="ChangeOrders__cancelEditCoStatement();" value="Cancel">
					<input type="button" onclick="ChangeOrders__updateCoViaPromiseChain($(this).parent().prev()[0]);" value="Save">
				</div>
			</div>
		</td>
		<td rowspan="10"  class="CO_table2_content">

			<table border="0" cellpadding="2" cellspacing="0" width="100%">
				<tr>
					<td nowrap align="right" style="width: 200px;"><b>Change Order Creator:</b></td>
					<td nowrap>$coCreatorDisplayName</td>
				</tr>
				<tr>
					<td class="verticalAlignMiddle" nowrap align="right" style="width: 200px;"><b>Creation Date:</b></td>
					<td nowrap>$coCreatedTimestampDisplayString</td>
				</tr>
				<!--tr>
					<td nowrap align="right" style="width: 200px;"><b>Change Order Initiator:</b></td>
					<td nowrap>$coInitiatorDisplayName</td>
				</tr>
				<tr>
					<td nowrap align="right" style="width: 200px;"><b>Change Order Recipient:</b></td>
					<td nowrap>$coRecipientDisplayName</td>
				</tr-->
				<tr>
					<td class="verticalAlignMiddle" nowrap align="right" style="width: 200px;"><b>Change Order Type:</b></td>
					<td nowrap>$ddlCoTypes</td>
				</tr>
				<tr>
					<td class="verticalAlignMiddle" nowrap align="right" style="width: 200px;"><b>Change Order Reason:</b></td>
					<td nowrap>$ddlCoPriorities</td>
				</tr>
				<tr>
					<td class="verticalAlignMiddle" nowrap align="right" style="width: 200px;"><b>Change Order Status:</b></td>
					<td nowrap>$ddlCoStatuses</td>
				</tr>
				<tr>
					<td class="verticalAlignMiddle" nowrap align="right" style="width: 200px;"><b>Change Order Cost Code:</b></td>
					<td nowrap>$ddlCostCodes</td>
				</tr>
				<tr>
					<td class="verticalAlignMiddle" nowrap align="right" style="width: 200px;"><b>Custom Number:</b></td>
					<td nowrap>$coCustomSequenceNumberInput</td>
				</tr>
				<tr>
					<td class="verticalAlignMiddle" nowrap align="right" style="width: 200px;"><b>Change Order Amount:</b></td>
					<td nowrap>$coScheduldedValueInput</td>
				</tr>
				<tr>
					<td class="verticalAlignMiddle" nowrap align="right" style="width: 200px;"><b>Delay Days:</b></td>
					<td nowrap>$coDelayDaysInput</td>
				</tr>
				<tr>
					<td class="verticalAlignMiddle" nowrap align="right" style="width: 200px;"><b>Revision Completion Date:</b></td>
					<td nowrap>$coRevisedProjectCompletionDateHtml</td>
				</tr>
			</table>

			<div class="clearBoth textAlignCenter" style="margin-bottom:4px">
				$viewPdfHtml
			</div>
			<!--div class="CO_table">
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="CO_table_header">
					<tr>
						<td width="65%">Attachment</td>
						<td width="35%">Creator</td>
					</tr>
				</table>
				<div class="CO_table_content_div">
					<table id="container--change_order_attachments--manage-change_order-record" width="100%" border="0" cellspacing="0" cellpadding="4" class="CO_table_content_tbl">

						$tableCoAttachments

					</table>
				</div>
			</div>
			<div class="textAlignCenter" style="width:210px; margin:auto;">
				{$fileUploader}
				{$fileUploaderProgressWindow}
				<br>
				<input onclick="generateCoTempFileListAsQueryString('uploaded-temp-file');" type="button" value="JSON Temp Files">
			</div-->

			<br>

			<!-- Temp Files -->
			<ul id="record_list_container--uploaded-temp-file" style="display: none;">
			</ul>

			<input id="temp-files-next-position--change_order_attachments" type="hidden" value="1">
			<div id="file-uploader-container--temp-files" class="displayNone CO_table">
				<table width="100%" cellspacing="0" cellpadding="4" border="0" class="CO_table_header">
					<tbody>
						<tr>
							<td nowrap width="65%">Pending Attachments</td>
							<td width="35%">Creator</td>
						</tr>
					</tbody>
				</table>
				<div class="CO_table_content_div">
					<table id="record_list_container--uploaded-temp-file--change_order_attachments" class="CO_table_content_tbl" width="100%" cellspacing="0" cellpadding="4" border="0">
					</table>
				</div>
			</div>

		</td>
		</tr>

		<tr>
		<td>
			<div class="textAlignRight" style="margin-top:10px; font-size: 10pt">
				<input id="ChangeOrders__createCoResponseViaPromiseChain" type="button" value="Save Changes To This Change Order" onclick="ChangeOrders__manualSaveButtonClick('create-change_order_response-record', '$dummyId');" style="font-size: 10pt;">
			</div>
		</td>
		</tr>

		$tableCoNotificationsTbody

	</table>
	<input type="hidden" id="change_order_id" value="$change_order_id">
	<input type="hidden" id="create-change_order_response-record--change_order_responses--change_order_id--$dummyId" value="$change_order_id">
	<input type="hidden" id="create-change_order_response-record--change_order_responses--change_order_response_type_id--$dummyId" value="$change_order_response_type_id">
</div>

END_HTML_CONTENT;

	return $htmlContent;

		/*
		<!-- This is the old code moved down from just above this comment. -->

		<tr>
		<td colspan="2" class="CO_table_header2">Note(s)</td>
		</tr>

		$tableCoResponses

		<tr>
		<td colspan="2" class="CO_table_header2">My Notes</td>
		</tr>

		<tr>
		<td id="container--create-change_order_response-record--$dummyId" colspan="2" class="CO_table2_content">
			<textarea id="create-change_order_response-record--change_order_responses--change_order_response--$dummyId" class="CO_table2 required"></textarea><br>
			<div class="textAlignRight" style="margin-top:10px; font-size: 10pt">
				<!--input id="ChangeOrders__createCoResponseAndSendEmailViaPromiseChain" type="button" value="Save Changes To This Change Order And Notify Team" onclick="ChangeOrders__createCoResponseAndSendEmailViaPromiseChain('create-change_order_response-record', '$dummyId');" style="font-size: 10pt;">&nbsp;-->
				<input id="ChangeOrders__createCoResponseViaPromiseChain" type="button" value="Save Changes To This Change Order" onclick="ChangeOrders__createCoResponseViaPromiseChain('create-change_order_response-record', '$dummyId');" style="font-size: 10pt;">
				<!--<input id="buttonGeneratePdf" type="button" value="Notify Subcontractors" onclick="" >-->
			</div>
		</td>
		</tr>

		$tableCoNotificationsTbody
		*/

}

	//For Edit dialog
	function buildEditCoDialog($database, $user_company_id, $project_id, $currently_active_contact_id,$changeOrderDraft)
	{
	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}

	// Update / Save case
	if ($changeOrderDraft) {
		/* @var $changeOrderDraft ChangeOrderDraft */
		$change_order_draft_id = (string) $changeOrderDraft->id;
		$co_custom_sequence_number = $changeOrderDraft->co_custom_sequence_number;
		$co_scheduled_value = (float) $changeOrderDraft->co_scheduled_value;
		$co_delay_days =  $changeOrderDraft->co_delay_days;
		$change_order_type_id = (string) $changeOrderDraft->change_order_type_id;
		$change_order_status_id = (int) $changeOrderDraft->change_order_status_id;
		$change_order_priority_id = (string) $changeOrderDraft->change_order_priority_id;
		$change_order_distribution_method_id = (string) $changeOrderDraft->change_order_distribution_method_id;
		$co_file_manager_file_id = (string) $changeOrderDraft->co_file_manager_file_id;
		$co_cost_code_id = (string) $changeOrderDraft->co_cost_code_id;
		$co_creator_contact_id = (string) $changeOrderDraft->co_creator_contact_id;
		$co_creator_contact_company_office_id = (string) $changeOrderDraft->co_creator_contact_company_office_id;
		$co_creator_phone_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_creator_phone_contact_company_office_phone_number_id;
		$co_creator_fax_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_creator_fax_contact_company_office_phone_number_id;
		$co_creator_contact_mobile_phone_number_id = (string) $changeOrderDraft->co_creator_contact_mobile_phone_number_id;
		$co_recipient_contact_id = (string) $changeOrderDraft->co_recipient_contact_id;
		$co_recipient_contact_company_office_id = (string) $changeOrderDraft->co_recipient_contact_company_office_id;
		$co_recipient_phone_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_recipient_phone_contact_company_office_phone_number_id;
		$co_recipient_fax_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_recipient_fax_contact_company_office_phone_number_id;
		$co_recipient_contact_mobile_phone_number_id = (string) $changeOrderDraft->co_recipient_contact_mobile_phone_number_id;
		$co_initiator_contact_id = (int) $changeOrderDraft->co_initiator_contact_id;
		$co_initiator_contact_company_office_id = (string) $changeOrderDraft->co_initiator_contact_company_office_id;
		$co_initiator_phone_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_initiator_phone_contact_company_office_phone_number_id;
		$co_initiator_fax_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_initiator_fax_contact_company_office_phone_number_id;
		$co_initiator_contact_mobile_phone_number_id = (string) $changeOrderDraft->co_initiator_contact_mobile_phone_number_id;
		$co_title = (string) $changeOrderDraft->co_title;
		$co_plan_page_reference = (string) $changeOrderDraft->co_plan_page_reference;
		$co_statement = (string) $changeOrderDraft->co_statement;
		$co_revised_project_completion_date = (string) $changeOrderDraft->co_revised_project_completion_date;
		$co_submitted_date = (string) $changeOrderDraft->co_submitted_date;
		$co_submitted_date = ($co_submitted_date == '0000-00-00') ? date('Y-m-d') : $co_submitted_date; 
		$co_approved_date = (string) $changeOrderDraft->co_approved_date;
		$co_approved_date = ($co_approved_date == '0000-00-00') ? date('Y-m-d') : $co_approved_date; 

		$co_scheduled_value = Format::formatCurrency($co_scheduled_value);
		$co_signator_contact_id = (int) $changeOrderDraft->co_signator_contact_id;
		// HTML Entity Escaped Data
		$changeOrderDraft->htmlEntityEscapeProperties();
		$escaped_co_custom_sequence_number = $changeOrderDraft->escaped_co_custom_sequence_number;
		$escaped_co_plan_page_reference = $changeOrderDraft->escaped_co_plan_page_reference;
		$escaped_co_statement = $changeOrderDraft->escaped_co_statement;
		$escaped_co_statement_nl2br = $changeOrderDraft->escaped_co_statement_nl2br;
		$escaped_co_title = $changeOrderDraft->escaped_co_title;

		//cost breakdown analysis
		$co_subtotal = $changeOrderDraft->co_subtotal;
		$co_genper = ($changeOrderDraft->co_genper =='0')?'':$changeOrderDraft->co_genper;
		$co_gentotal = ($changeOrderDraft->co_gentotal == '0')?'':$changeOrderDraft->co_gentotal;
		$co_buildper = ($changeOrderDraft->co_buildper =='0')?'':$changeOrderDraft->co_buildper;
		$co_buildtotal = ($changeOrderDraft->co_buildtotal=='0')?'':$changeOrderDraft->co_buildtotal;
		$co_insuranceper = ($changeOrderDraft->co_insuranceper=='0')?'':$changeOrderDraft->co_insuranceper;
		$co_insurancetotal = ($changeOrderDraft->co_insurancetotal=='0')?'':$changeOrderDraft->co_insurancetotal;
		$co_total = ($changeOrderDraft->co_total=='0')?'':$changeOrderDraft->co_total;

		$co_type_prefix=$changeOrderDraft->co_type_prefix;
		$co_sequence_number = $changeOrderDraft->co_sequence_number;
		//End of cost breakdown analysis

		$buttonDeleteCoDraft = <<<END_HTML_CONTENT
<input type="button" value="Delete This Draft" onclick="ChangeOrders__deleteChangeOrderDraft('manage-change_order_draft-record', 'change_order_drafts', '$change_order_draft_id', { successCallback: ChangeOrders__deleteChangeOrderDraftSuccess });" style="font-size: 10pt;">
END_HTML_CONTENT;
		
		//N- for default , Y for Upload executive
		$liChangeOrderDraftAttachments = '';
		$arrCoFileManagerFileIds = array();
		$loadChangeOrderDraftAttachmentsByChangeOrderDraftIdOptions = new Input();
		$loadChangeOrderDraftAttachmentsByChangeOrderDraftIdOptions->forceLoadFlag = true;
		$arrChangeOrderDraftAttachments = ChangeOrderAttachment::loadChangeOrderAttachmentsByChangeOrderId($database, $change_order_draft_id, $loadChangeOrderDraftAttachmentsByChangeOrderDraftIdOptions,'N');
		
		foreach ($arrChangeOrderDraftAttachments as $change_order_draft_attachment_id => $changeOrderDraftAttachment) {
			/* @var $changeOrderDraftAttachment ChangeOrderDraftAttachment */

			$file_manager_file_id = $changeOrderDraftAttachment->co_attachment_file_manager_file_id;
			$co_attachment_source_contact_id = $changeOrderDraftAttachment->co_attachment_source_contact_id;
			$fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$fileManagerFile->htmlEntityEscapeProperties();
			$virtual_file_name = $fileManagerFile->virtual_file_name;
			$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
			$fileUrl = $fileManagerFile->generateUrl();

			$arrCoFileManagerFileIds[] = $file_manager_file_id;

			$dummyCoDraftAttachmentId = Data::generateDummyPrimaryKey();

			$elementId = "record_container--manage-file_manager_file-record--file_manager_files--$file_manager_file_id";

			$liChangeOrderDraftAttachments .= <<<END_LI_CHANGE_ORDER_DRAFT_ATTACHMENTS

			<li id="record_container--create-change_order_draft_attachment-record--change_order_draft_attachments--$dummyCoDraftAttachmentId" class="hidden">
				<input id="create-change_order_attachment-record--change_order_attachments--change_order_id--$dummyCoDraftAttachmentId" type="hidden" value="$dummyCoDraftAttachmentId">
				<input id="create-change_order_attachment-record--change_order_attachments--change_order_draft_id--$dummyCoDraftAttachmentId" type="hidden" value="$dummyCoDraftAttachmentId">
				<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_file_manager_file_id--$dummyCoDraftAttachmentId" type="hidden" value="$file_manager_file_id">
				<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_source_contact_id--$dummyCoDraftAttachmentId" type="hidden" value="$co_attachment_source_contact_id">
			</li>
			<li id="$elementId">
			<input class="upfileid" value="$file_manager_file_id" type="hidden">
			<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">
				<a href="javascript:deleteCOFile('$elementId', 'manage-file_manager_file-record', '$file_manager_file_id');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;
				<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
			</li>
END_LI_CHANGE_ORDER_DRAFT_ATTACHMENTS;

		}


		$csvCoFileManagerFileIds = join(',', $arrCoFileManagerFileIds);

		// <input type="button" value="Save As A New Change Order Draft" onclick="ChangeOrders__createCoDraftViaPromiseChain('create-change_order-record', '$dummyId');" style="font-size: 10pt;">

		// Save Change Order As Draft Button
		$saveChangeOrderAsDraftButton = <<<END_SAVE_CHANGE_ORDER_AS_DRAFT_BUTTON
<input type="button" value="Save Changes To This Draft" onclick="ChangeOrders__createCoDraftViaPromiseChain('create-change_order-record', '$dummyId', { crudOperation: 'update', change_order_draft_id: $change_order_draft_id });" style="font-size: 10pt;">&nbsp;
END_SAVE_CHANGE_ORDER_AS_DRAFT_BUTTON;

	} 
	else {
		// Create case
		$change_order_draft_id = '';
		$co_custom_sequence_number = '';
		$co_scheduled_value = '';
		$co_delay_days = '';
		$change_order_priority_id = ''; // This is being used for "Reason"
		$change_order_type_id = '';
		$change_order_status_id = 1; // Default to "Open"
		$change_order_distribution_method_id = '';
		$co_file_manager_file_id = '';
		$co_cost_code_id = '';
		$co_creator_contact_id = '';
		$co_creator_contact_company_office_id = '';
		$co_creator_phone_contact_company_office_phone_number_id = '';
		$co_creator_fax_contact_company_office_phone_number_id = '';
		$co_creator_contact_mobile_phone_number_id = '';
		$co_recipient_contact_id = '';
		$co_recipient_contact_company_office_id = '';
		$co_recipient_phone_contact_company_office_phone_number_id = '';
		$co_recipient_fax_contact_company_office_phone_number_id = '';
		$co_recipient_contact_mobile_phone_number_id = '';
		$co_initiator_contact_id = '';
		$co_initiator_contact_company_office_id = '';
		$co_initiator_phone_contact_company_office_phone_number_id = '';
		$co_initiator_fax_contact_company_office_phone_number_id = '';
		$co_initiator_contact_mobile_phone_number_id = '';
		$co_title = '';
		$co_plan_page_reference = '';
		$co_statement = '';
		$co_revised_project_completion_date = '';
		$co_submitted_date = date('Y-m-d');
		$co_approved_date = date('Y-m-d');

		// HTML Entity Escaped Data
		$escaped_co_plan_page_reference = '';
		$escaped_co_statement = '';
		$escaped_co_statement_nl2br = '';
		$escaped_co_title = '';

		$buttonDeleteCoDraft = '';
		$csvCoFileManagerFileIds = '';

		// Save Change Order As Draft Button
		$saveChangeOrderAsDraftButton = <<<END_SAVE_CHANGE_ORDER_AS_DRAFT_BUTTON
<input type="button" value="Save Change Order As Draft" onclick="ChangeOrders__createCoDraftViaPromiseChain('create-change_order-record', '$dummyId');" style="font-size: 10pt;">
END_SAVE_CHANGE_ORDER_AS_DRAFT_BUTTON;

	}
	$editable = '';

	if (!isset($arrChangeOrderDraftAttachments) || count($arrChangeOrderDraftAttachments) == 0) {
		$liChangeOrderDraftAttachments = '<li class="placeholder">No Files Attached</li>';
	}
	
	
	if($subOrder)
	{
		$liChangeOrderDraftAttachments=AttachmentforSuborder($database, $subOrder);
	$co_statement=SuborderDataForchangeOrder($database, $subOrder,'description');
	$co_scheduled_value='$'.SuborderDataForchangeOrder($database, $subOrder,'forecast_amount');
	$change_order_type_id='3';
	}
	// FileManagerFolder
	$virtual_file_path = '/Change Orders/Change Order Draft Attachments/';
	$coFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $virtual_file_path);
	/* @var $coFileManagerFolder FileManagerFolder */

	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--change_order_attachments--create-change_order-record';
	$input->folder_id = $coFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Change Orders/Change Order Draft Attachments/';
	//$input->virtual_file_name = 'Attachment #1';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadChangeOrderAttachment';
	$input->allowed_extensions = 'pdf';
	$input->post_upload_js_callback = "ChangeOrders__coDraftAttachmentUploaded(arrFileManagerFiles, 'container--change_order_attachments--create-change_order-record')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

	$coCostCodesElementId = "ddl--create-change_order-record--change_orders--co_cost_code_id--$dummyId";

	$costCodesInput = new Input();
	$prependedOption = '';
	$tabIndex = '';
	$js = 'style="width:95%"';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$costCodesInput->project_id = $project_id;
	$selectedOption = $co_cost_code_id;
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $coCostCodesElementId;
	$costCodesInput->firstOption = '<option value="0">Optionally Select A Cost Code Below For Reference</option>';
	$costCodesInput->selectCssStyle = 'style="font-size: 1.3em; height: 30px; width: 400px;"';
	$costCodesInput->selectedOption = $co_cost_code_id;
	$coDraftsHiddenCostCodeElementId = "create-change_order_draft-record--change_order_drafts--co_cost_code_id--$dummyId";
	$costCodesInput->additionalOnchange = "ddlOnChange_UpdateHiddenInputValue(this, '$coDraftsHiddenCostCodeElementId');updateSubcontractors(this.value,&apos;$dummyId&apos;,&apos;$user_company_id&apos;,&apos;$project_id&apos;);";
	// $ddlCostCodes = buildCostCodeDropDownList($costCodesInput);
	$ddlCostCodes = buildProjectCostCodeDropDownList($costCodesInput);
	//$ddlCostCodes = PageComponents::dropDownListFromObjects($coCostCodesElementId, $arrCostCodes, 'cost_code_id', null, 'cost_code_description', null, $selectedOption, $tabIndex, $js, $prependedOption);

	$loadAllChangeOrderPrioritiesOptions = new Input();
	$loadAllChangeOrderPrioritiesOptions->forceLoadFlag = true;
	$arrChangeOrderPriorities = ChangeOrderPriority::loadAllChangeOrderPriorities($database, $loadAllChangeOrderPrioritiesOptions);
	$ddlCoPrioritiesId = "ddl--create-change_order-record--change_orders--change_order_priority_id--$dummyId";
	$coDraftsHiddenCoPrioritiesElementId = "create-change_order_draft-record--change_order_drafts--change_order_priority_id--$dummyId";
	$js = ' style="width: 350px;" class="moduleCO_dropdown" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenCoPrioritiesElementId.'\');"';
	$prependedOption = '<option value="">Optionally Select A Change Order Reason</option>';
	$selectedOption = $change_order_priority_id;
	$ddlCoPriorities = PageComponents::dropDownListFromObjects($ddlCoPrioritiesId, $arrChangeOrderPriorities, 'change_order_priority_id', null, 'change_order_priority', null, $selectedOption, null, $js, $prependedOption);

	$drawValStatus = '';
	$drawOverValStatus = 0;
	$drawStatusMsg = $drawStatusMsgWithBr = '';
	if($change_order_status_id=='2' && $change_order_type_id=='2'){
		$drawOverValStatus = ChangeOrder::getDrawOverValStatus($database,$project_id,$change_order_draft_id);	
		$drawValStatus = $drawOverValStatus ? 'disabled="true"' : '';
	}	
	if ($drawOverValStatus) {
		$drawStatusMsg = '<span style="font-style: italic;">* OCO can not be edited since its value is submitted for approval in Draw #</span>';
		$drawStatusMsgWithBr = '<br><span style="font-style: italic;">* OCO can not be edited since its value is submitted for approval in Draw #</span>';
	}

	$loadAllChangeOrderTypesOptions = new Input();
	$loadAllChangeOrderTypesOptions->forceLoadFlag = true;
	$arrChangeOrderTypes = ChangeOrderType::loadAllChangeOrderTypes($database, $loadAllChangeOrderTypesOptions);
	$ddlCoTypesId = "ddl--create-change_order-record--change_orders--change_order_type_id--$dummyId";
	$coDraftsHiddenCoTypesElementId = "create-change_order_draft-record--change_order_drafts--change_order_type_id--$dummyId";
	$js = ' style="width: 250px;" class="moduleCO_dropdown3 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenCoTypesElementId.'\');COsubmittedDate(this.value);"'.' '.$drawValStatus;
	$prependedOption = '<option value="">Select Change Order Type</option>';
	$selectedOption = $change_order_type_id;
	$ddlCoTypes = PageComponents::dropDownListFromObjects($ddlCoTypesId, $arrChangeOrderTypes, 'change_order_type_id', null, 'change_order_type', null, $selectedOption, null, $js, $prependedOption);

	$loadAllChangeOrderDistributionMethodsOptions = new Input();
	$loadAllChangeOrderDistributionMethodsOptions->forceLoadFlag = true;
	$arrChangeOrderDistributionMethods = ChangeOrderDistributionMethod::loadAllChangeOrderDistributionMethods($database, $loadAllChangeOrderDistributionMethodsOptions);
	$ddlCoDistributionMethodsId = "ddl--create-change_order-record--change_orders--change_order_distribution_method_id--$dummyId";
	$coDraftsHiddenCoDistributionMethodsElementId = "create-change_order_draft-record--change_order_drafts--change_order_distribution_method_id--$dummyId";
	$js = ' style="width: 250px;" class="moduleCO_dropdown3" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenCoDistributionMethodsElementId.'\');"';
	$prependedOption = '<option value="">Select CO Distribution Method</option>';
	$selectedOption = $change_order_distribution_method_id;
	$ddlCoDistributionMethods = PageComponents::dropDownListFromObjects($ddlCoDistributionMethodsId, $arrChangeOrderDistributionMethods, 'change_order_distribution_method_id', null, 'change_order_distribution_method', null, $selectedOption, null, $js, $prependedOption);

	$arrContactsByUserCompanyId = Contact::loadContactsByUserCompanyId($database, $user_company_id);

	// From: Subcontractor
	// co_initiator_contact_id
	$coDraftsHiddenContactsByUserCompanyIdToElementId = "create-change_order_draft-record--change_order_drafts--co_initiator_contact_id--$dummyId";

	$input = new Input();
	$input->database = $database;
	$input->user_company_id = $user_company_id;
	//$input->csvContactIdExclusionList = $arrCustomizedPermissionsByContact;
	$input->selected_contact_id = $co_initiator_contact_id;
	$input->htmlElementId = "create-change_order-record--change_orders--co_initiator_contact_id--$dummyId";
	$input->js = ' class="emailGroup moduleCO_dropdown4" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenContactsByUserCompanyIdToElementId.'\');"';
	$input->firstOption = 'Optionally Select A CO Initiator Contact';
	if($co_cost_code_id){
		$input->costcode = $co_cost_code_id;
		$input->project_id = $project_id;
		$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildSubmittalsContactsFullNameWithEmailByUserCompanyIdDropDownList($input);
	}else{
		$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildContactsFullNameWithEmailByUserCompanyIdDropDownList($input);
	}

	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($database, $project_id, 'change_orders');

	// To:
	// co_recipient_contact_id
	$coDraftsHiddenProjectTeamMembersToElementId = "create-change_order-record--change_orders--co_recipient_contact_id--$dummyId";
	$selectedOption = $co_recipient_contact_id;
	$js = ' class="moduleSUBMITTAL_dropdown4 required emailGroup" $editdisable onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenProjectTeamMembersToElementId.'\');changeOrder_isMailToError(this);"';
	$prependedOption = '<option value="">Select A Change Order Recipient</option>';
	$ddlProjectTeamMembersToId = "ddl--create-change_order-record--change_orders--co_recipient_contact_id--$dummyId";	
	$ddlProjectTeamMembersTo = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersToId,$selectedOption);		
	
	//To add the signator field

	$arrSignatorMembers = Contact::loadSignatorMembers($database, $user_company_id, $project_id);
	
  	usort($arrSignatorMembers, function ($a,$b)  {
    return ($a["company"] <= $b["company"]) ? -1 : 1;  	 });
	
	
	$prependedOption = '<option value="">Select A Change Order Signator</option>';
	$js ="class='emailGroup moduleCO_dropdown4 required' onchange='changeOrder_isMailFromError(this);'";
	$ddlProjectTeamMembersToId = "create-change_order-record--change_orders--co_signator_contact_id--$dummyId";
	$selectedOption = $co_signator_contact_id;
	$ddlsignator = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersToId,$selectedOption);

	$arrProjectTeamMembers = Contact::loadProjectTeamMembers($database, $project_id,'','','1');
	// Cc:
	// co_additional_recipient_contact_id
	$ddlProjectTeamMembersCcId = "ddl--create-change_order_recipient-record--change_order_recipients--co_additional_recipient_contact_id--Cc-$dummyId";
	$js = ' onchange="ChangeOrders__addRecipient(this);" class="moduleCO_dropdown4"';
	$ddlProjectTeamMembersCc = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersCcId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);
	// Bcc:
	$ddlProjectTeamMembersBccId = "ddl--create-change_order_recipient-record--change_order_recipients--co_additional_recipient_contact_id--Bcc-$dummyId";
	$ddlProjectTeamMembersBcc = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersBccId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);

	$co_attachment_source_contact_id = $currently_active_contact_id;
	$co_creator_contact_id = $currently_active_contact_id;

	//To implement the attachments
	// FileManagerFolder
	$virtual_file_path = '/Change Orders/Change Order Draft Attachments/';
	$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $virtual_file_path);
	/* @var $rfiFileManagerFolder FileManagerFolder */

	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record';
	$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Change Orders/Change Order Draft Attachments/';
	//$input->virtual_file_name = 'Attachment #1';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadRequestForInformationAttachment';
	$input->allowed_extensions = 'pdf,jpg,jpeg,doc,docx,png,gif,xlsx,csv,xls,rtf';
	$input->post_upload_js_callback = "change__orderDraftAttachmentUploaded(arrFileManagerFiles, 'container--request_for_information_attachments--create-request_for_information-record','N')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

	//upload executed files

	$input = new Input();
	$input->id = 'uploader--change_order_attachments--create-change_order_attachments-record';
	$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Change Orders/Change Order Draft Attachments/';
	//$input->virtual_file_name = 'Attachment #1';
	// $input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadRequestForInformationAttachment';
	$input->allowed_extensions = 'pdf';
	$input->post_upload_js_callback = "change__orderDraftAttachmentUploaded(arrFileManagerFiles, 'container--change_order_attachments--edit-change_order_attachments-record','Y')";
	$uploadUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

	//N- for default , Y for Upload executive
		$liChangeOrderupexecuteAttachments = '';
		$arrCoFileManagerFileIds = array();
		$loadChangeOrderupexecuteAttachmentsByChangeOrderDraftIdOptions = new Input();
		$loadChangeOrderupexecuteAttachmentsByChangeOrderDraftIdOptions->forceLoadFlag = true;
		$arrChangeOrderupexecuteAttachments = ChangeOrderAttachment::loadChangeOrderAttachmentsByChangeOrderId($database, $change_order_draft_id, $loadChangeOrderupexecuteAttachmentsByChangeOrderDraftIdOptions,'Y');
		
		foreach ($arrChangeOrderupexecuteAttachments as $change_order_draft_attachment_id => $changeOrderDraftAttachment) {
			/* @var $changeOrderDraftAttachment ChangeOrderDraftAttachment */

			$file_manager_file_id = $changeOrderDraftAttachment->co_attachment_file_manager_file_id;
			$co_attachment_source_contact_id = $changeOrderDraftAttachment->co_attachment_source_contact_id;
			$fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$fileManagerFile->htmlEntityEscapeProperties();
			$virtual_file_name = $fileManagerFile->virtual_file_name;
			$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
			$fileUrl = $fileManagerFile->generateUrl();

			$arrCoFileManagerFileIds[] = $file_manager_file_id;

			$dummyCoDraftAttachmentId = Data::generateDummyPrimaryKey();

			$elementId = "record_container--manage-file_manager_file-record--file_manager_files--$file_manager_file_id";

			$liChangeOrderupexecuteAttachments .= <<<END_LI_CHANGE_ORDER_DRAFT_ATTACHMENTS

			<li id="record_container--create-change_order_draft_attachment-record--change_order_draft_attachments--$dummyCoDraftAttachmentId" class="hidden">
				<input id="create-change_order_attachment-record--change_order_attachments--change_order_id--$dummyCoDraftAttachmentId" type="hidden" value="$dummyCoDraftAttachmentId">
				<input id="create-change_order_attachment-record--change_order_attachments--change_order_draft_id--$dummyCoDraftAttachmentId" type="hidden" value="$dummyCoDraftAttachmentId">
				<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_file_manager_file_id--$dummyCoDraftAttachmentId" type="hidden" value="$file_manager_file_id">
				<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_source_contact_id--$dummyCoDraftAttachmentId" type="hidden" value="$co_attachment_source_contact_id">
			</li>
			<li id="$elementId">
			<input class="exefileid" value="$file_manager_file_id" type="hidden">
			<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">
				<a href="javascript:deleteCOFile('$elementId', 'manage-file_manager_file-record', '$file_manager_file_id');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;
				<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
			</li>
END_LI_CHANGE_ORDER_DRAFT_ATTACHMENTS;

		}

		if (!isset($arrChangeOrderupexecuteAttachments) || count($arrChangeOrderupexecuteAttachments) == 0) {
		$liChangeOrderupexecuteAttachments = '<li class="placeholder">No Files Attached</li>';
	}
	if($change_order_status_id=='2')
	{
		$exestyle="display:block;";
	}else
	{
		$exestyle="display:none;";
	}

	if ($change_order_type_id=='2') {
		$submittstyle ="display:block;";
	}else{
		$submittstyle ="display:none;";
	}

	if($change_order_status_id=='2' && $change_order_type_id=='2')
	{
		$approvestyle="display:block;";
		$editable = 'disabled';
	}else
	{
		$approvestyle="display:none;";
	}

	//End of upload executed files


	$loadAllChangeOrderStatusesOptions = new Input();
	$loadAllChangeOrderStatusesOptions->forceLoadFlag = true;
	$arrChangeOrderStatuses = ChangeOrderStatus::loadAllChangeOrderStatuses($database, $loadAllChangeOrderStatusesOptions);

	$ddlCoStatusesId = 'create-change_order-record--change_orders--change_order_status_id--' . $dummyId;
	$js = 'style="width:100px;font-size:12px;" onchange="COstatusCheck(this.value);"'.' '.$drawValStatus;
	$ddlCoStatuses = PageComponents::dropDownListFromObjects($ddlCoStatusesId, $arrChangeOrderStatuses, 'change_order_status_id', null, 'change_order_status', null, $change_order_status_id, '4', $js, '');


	$costCodesInput = new Input();
	$prependedOption = '';
	$tabIndex = '';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$costCodesInput->project_id = $project_id;
	$selectedOption = $co_cost_code_id;
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $coCostCodesElementId;
	$costCodesInput->firstOption = '<option value="0">Select A Cost Code</option>';
	$coDraftsHiddenCostCodeElementId = "create-co_cost_code_id";
	// $ddlCostCodes = buildCostCodeDropDownList($costCodesInput);
	$ddlCostCodesListOptionDefulats = buildProjectCostCodeDropDownListOptions($costCodesInput);

	//cost breakdown
	$retData=getchangeordercostbreakdownData($database,$change_order_draft_id);
	$countI = count($retData);
	$countI = $countI;
	$costbreak="";
	$i=1;
	if($retData)
	{
	foreach ($retData as $key => $value) {
	
	$costCodesInput = new Input();
	$prependedOption = '';
	$tabIndex = '';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$costCodesInput->project_id = $project_id;
	$selectedOption = $value['cost_code_reference_id'];
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $coCostCodesElementId;
	$costCodesInput->firstOption = '<option value="0">Select A Cost Code</option>';
	$coDraftsHiddenCostCodeElementId = "create-co_cost_code_id";
	// $ddlCostCodes = buildCostCodeDropDownList($costCodesInput);
	$ddlCostCodesListOptions = buildProjectCostCodeDropDownListOptions($costCodesInput);

	$costbreak .='
	<div class="trow cost_div ">';

	if ($drawOverValStatus == 0) {
		$costbreak .='
		<div class="tcol" style="width: 0.5%;">
			<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">
		</div>';
	}else{
		$costbreak .='<div class="tcol" style="width: 0.5%;"></div>';
	}

	$costbreak .='
		<div class="tcol" style="width: 25%;">                                      
            <input class="required" type="hidden" name="costcode-optionslist" id="cost-code-options-list" value=\''.$ddlCostCodesListOptionDefulats.'\'/>
		    <input type="hidden" name="costcode[]" id="costcode'.$i.'" value="'.$selectedOption.'"/>
		    <input type="hidden" id="cocode-inc-value" value="'.$countI.'"/>
		    <select class="costcode-select'.$i.' costcode-select" onchange="updateCostCodeValue(this.value, '.$i.')" style="font-size: 1.3em; height: 25px; width: 95%; margin-top: 5px" '.$drawValStatus.'>'.$ddlCostCodesListOptions.'</select>
		</div>
		<div class="tcol" style="width: 22%;">	
        	<input class="required" type="text" name="descript[]" id=descript[]" value="'.$value["description"].'"/>
        </div>
        <div class="tcol">       
        	<input class="" type="text" name="sub[]" id="sub[]" value="'.$value['Sub'].'"/>
        </div>
        <div class="tcol">
        	<input class="" type="text" name="ref[]" id="ref[]" value="'.$value["reference"].'"/>
        </div>
        <div class="tcol">
        	<input class="Number required" type="text" name="cost[]" id="cost[]"  value="'.$value["cost"].'" '.$drawValStatus.' onkeyup="setTimeout(calcSubtotal(),2000)"/>
        </div>';
        if ($drawOverValStatus == 0) {
	        if($i=='1')
	        {
	        	$costbreak .="
		        	<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;'>
		        		<a href='javascript:void(0);' class='add_button entypo-plus-circled' title='Add field' onclick='addbreakdown()'></a>        
		        	</div>
	        	";
	        }
	        else
	        {
	        	$costbreak .="
	        		<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;'>
	        			<a href='javascript:void(0);' class='remove_button entypo-minus-circled ' title='Remove field' ></a>        
	        		</div>
	        	";
	        }
	    }else{
	    	$costbreak .="<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;'></div>";
	    }
        
        $costbreak .="</div>";
        $i++;
    }
    }else
    {
    $costbreak .='
	<div class="trow cost_div ">
	<div class="tcol" style="width: 0.5%;"><img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order"></div>
		<div class="tcol" style="width: 25%;">                                      
            <input class="required" type="hidden" name="costcode-optionslist" id="cost-code-options-list" value=\''.$ddlCostCodesListOptionDefulats.'\'/>
		    <input type="hidden" name="costcode[]" id="costcode1" value=""/>
		    <input type="hidden" id="cocode-inc-value" value="1"/>
		    <select class="costcode-select1 costcode-select" onchange="updateCostCodeValue(this.value, 1)" >'.$ddlCostCodesListOptionDefulats.'</select>
		</div>
		<div class="tcol" style="width: 22%;">				
        	<input class="required" type="text" name="descript[]" id=descript[]" value=""/>
        </div>
        <div class="tcol">
        	<input class="" type="text" name="sub[]" id="sub[]" value=""/>
        </div>
        <div class="tcol">       
        	<input class="" type="text" name="ref[]" id="ref[]" value=""/>
        </div>
        <div class="tcol">       
        	<input class="Number required" type="text" name="cost[]" id="cost[]"  value="" onkeyup="setTimeout(calcSubtotal(),2000)"/>
        </div>
        <div class="tcol" style="vertical-align: bottom;padding-bottom: 12px;">
        	<a href="javascript:void(0);" class="add_button entypo-plus-circled" title="Add field" onclick="addbreakdown()"></a>        
        </div>
    </div>';
    
    }

    	$costCodesInput = new Input();
		$prependedOption = '';
		$tabIndex = '';
		$costCodesInput->database = $database;
		$costCodesInput->user_company_id = $user_company_id;
		$costCodesInput->project_id = $project_id;
		$costCodesInput->htmlElementId = $coCostCodesElementId;
		$costCodesInput->firstOption = '<option value="0">Select A Cost Code</option>';
		$coDraftsHiddenCostCodeElementId = "create-co_cost_code_id";
		// $ddlCostCodes = buildCostCodeDropDownList($costCodesInput);
		$ddltaxCostCodesListOptionDefulats = buildProjectCostCodeDropDownListOptions($costCodesInput);

    //For description dynamic
    $despData=getchangeordertaxData($database,$change_order_draft_id);
	$countTaxI = count($despData);
	$countTaxI = $countTaxI;
	$dyna_desp="";
	$k=1;
	if($despData)
	{
	foreach ($despData as $key => $value) {
		$costCodesInput = new Input();
		$prependedOption = '';
		$tabIndex = '';
		$costCodesInput->database = $database;
		$costCodesInput->user_company_id = $user_company_id;
		$costCodesInput->project_id = $project_id;
		$selectedOption = $value['cost_code'];
		$costCodesInput->selected_cost_code = $selectedOption;
		$costCodesInput->htmlElementId = $coCostCodesElementId;
		$costCodesInput->firstOption = '<option value="0">Select A Cost Code</option>';
		$coDraftsHiddenCostCodeElementId = "create-co_cost_code_id";
		// $ddlCostCodes = buildCostCodeDropDownList($costCodesInput);
		$ddltaxCostCodesListOption = buildProjectCostCodeDropDownListOptions($costCodesInput);
		$pert=($value['percentage']=='0.00')?'':$value['percentage'];

    $dyna_desp .="<div class='trow cont_div contdrag'>";

    if ($drawOverValStatus == 0) {
	    $dyna_desp .="  
	    	<div class='tcol' style='width: 0.5%;'>		
					<img src='/images/sortbars.png' style='cursor: pointer;' rel='tooltip' title='' data-original-title='Drag bars to change sort order'>
			</div>";
		}else{
			$dyna_desp .="
				<div class='tcol' style='width: 0.5%;'></div>";
		}

		$dyna_desp .="
			<div class='tcol' style='width: 18%;'>
				<input type='hidden' name='taxcode-optionslist' id='tax-code-options-list' value='$ddltaxCostCodesListOptionDefulats'/>
		    <input  type='hidden' name='taxcode[]' id='taxcode$k' value='$selectedOption'/>
		    <input  type='hidden' id='taxcode-inc-value' value='$countTaxI'/>
		    <select class='taxcode-select$k taxcode-select' onchange='updateTaxCostCodeValue(this.value,$k)' style='font-size: 1.3em; height: 25px; width: 95%; margin-top: 5px' ".$drawValStatus.">'.$ddltaxCostCodesListOption.'</select>
			</div>

	    <div class='tcol' style='width: 17%;'>
         <input class='' name='content[]' id='content$k' value='".$value['content']."' type='text'> 
      </div>
      
      <div class='tcol' style='width: 2%;'>%</div>
      
      <div class='tcol' style='width: 10%;'>
          <input class='Number' name='percentage[]' id='percentage[]' value='".$pert."' onkeyup='calcSubtotal()' type='text' ".$drawValStatus.">
      </div>
	    
	    <div class='tcol' style='width: 7%; text-align: center;'><b>OR</b></div>
      
      <div class='tcol' style='width: 1%;'>$</div>
      
      <div class='tcol' style='width: 11%;'>
        <input class='Number ' name='contotal[]' id='contotal[]' value='".$value['cost']."' onkeyup='setTimeout(calcSubtotal(),2000)' type='text' ".$drawValStatus.">
      </div>
    ";
    if ($drawOverValStatus == 0) {
      if($k=='1') {
	      $dyna_desp .="
	        <div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'>
	         	<a href='javascript:void(0);' class='add_button entypo-plus-circled' title='Add field' onclick='addcostbreakdown()'></a>
	        </div>
	      </div>";
	    }else{
        $dyna_desp .="
	        <div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'>
	         	<a href='javascript:void(0);' class='remove_button entypo-minus-circled' title='Remove field'></a>
	        </div>
	      </div>";
      }
    }else{
      $dyna_desp .="<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'></div></div>";
    }
      $k++;
        
  }
 }else
 {
 	$dyna_desp .="
 		<div class='trow cont_div contdrag'>  
 		<div class='tcol' style='width: 0.5%;'>		
			<img src='/images/sortbars.png' style='cursor: pointer;' rel='tooltip' title='' data-original-title='Drag bars to change sort order'></div>
			 <div class='tcol' style='width:14%;'>
			<input  type='hidden' name='taxcode-optionslist' id='tax-code-options-list' value='$ddltaxCostCodesListOptionDefulats'/>
		    <input  type='hidden' name='taxcode[]' id='taxcode1' value=''/>
		    <input  type='hidden' id='taxcode-inc-value' value='1'/>
		    <select class='taxcode-select1 taxcode-select' onchange='updateTaxCostCodeValue(this.value, 1)' style='
			width: 285px;'>'.$ddltaxCostCodesListOptionDefulats.'</select>
			 </div>
         	<div class='tcol' style='width: 9%;'>
        		<input type='text' class='' name='content[]' id='content1' value='' /> 
          	</div>
          	<div class='tcol' style='width: 1%;'>%</div>
          	<div class='tcol' style='width: 8%;'>
         		<input type='text' class='Number' name='percentage[]' id='percentage[]' value='' onkeyup='calcSubtotal()'/> 
          	</div>
         	<div class='tcol' style='width: 8%; text-align: center;'><b>OR</b></div>
          	<div class='tcol' style='width: 1%;'>$</div>
          	<div class='tcol' style='width: 9%;'>
         		<input type='text' class='Number' name='contotal[]' id='contotal[]' value='' onkeyup='setTimeout(calcSubtotal(),2000)'/>
         	</div>
          	<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'>
        		<a href='javascript:void(0);' class='add_button entypo-plus-circled' title='Add field' onclick='addcostbreakdown()'></a>        
        	</div>
         </div>
    ";
 }
    //End of descp dynamic

 	$viewPdfHtml = '';
	if (isset($co_file_manager_file_id) && !empty($co_file_manager_file_id)) {
		$coFileManagerFile = FileManagerFile::findById($database, $co_file_manager_file_id);
		$coPdfUrl = $coFileManagerFile->generateUrl();
		}


	$tableHeader = $co_type_prefix ? $co_type_prefix : $co_sequence_number;
	$htmlContent = <<<END_HTML_CONTENT
<form id="formCreateCo">
	<div id="record_creation_form_container--create-change_order-record--$dummyId">
		<div class="CO_table_dark_header2">$tableHeader — $escaped_co_title</div>
		<div class="CO_table_create">
			<table border="0" cellpadding="4" cellspacing="0" width="100%">
				<tr>
					<td class="CO_table_header2">Change Order Type [PCO / COR / OCO]:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<input id="create-change_order-record--change_orders--change_order_type_id--$dummyId" type="hidden" value="$change_order_type_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_type_id--$dummyId" type="hidden" value="$change_order_type_id">
						<span class="moduleCO">
						$ddlCoTypes
						</span>
						$drawStatusMsgWithBr
					</td>
				</tr>
				<tr>
					<td class="CO_table_header2">Optional Change Order Reason:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<input id="create-change_order-record--change_orders--co_cost_code_id--$dummyId" type="hidden" value="$co_cost_code_id">
						<input id="create-change_order-record--change_orders--change_order_priority_id--$dummyId" type="hidden" value="$change_order_priority_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_priority_id--$dummyId" type="hidden" value="$change_order_priority_id">
						<span class="moduleCO">
						$ddlCoPriorities
						</span>
					</td>
				</tr>
				<!-- <tr>
					<td class="CO_table_header2">Optional Cost Code Reference:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<input id="create-change_order-record--change_orders--co_cost_code_id--$dummyId" type="hidden" value="$co_cost_code_id">
						<input id="create-change_order_draft-record--change_order_drafts--co_cost_code_id--$dummyId" type="hidden" value="$co_cost_code_id">
						<span class="moduleCO">
						$ddlCostCodes
						</span>
					</td>
				</tr> -->
				<tr>
					<td class="CO_table_header2">Optional Change Order Subcontractor:</td>
				</tr>
				<tr>
					<td class="CO_table2_content Subsearch">

						<span id="subCoList">
						$contactsFullNameWithEmailByUserCompanyIdDropDownList
						</span>
					</td>
				</tr>
				<tr>
					<td width="70%" class="CO_table_header2">Change Order Title:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<input id="create-change_order-record--change_orders--co_title--$dummyId" class="CO_table2 required" type="text" value="$escaped_co_title">
					</td>
				</tr>
				<tr>
					<td class="CO_table_header2">Optional Change Order References:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<p>
							<input id="create-change_order-record--change_orders--co_plan_page_reference--$dummyId" class="CO_table2" type="text" value="$escaped_co_plan_page_reference">
						</p>
					</td>
				</tr>
				<tr>
					<td class="CO_table_header2">Change Order Description</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<p><textarea id="create-change_order-record--change_orders--co_statement--$dummyId" class="CO_table2">$co_statement</textarea></p>
						<input id="create-change_order-record--change_orders--change_order_priority_id--$dummyId" type="hidden" value="$change_order_priority_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_priority_id--$dummyId" type="hidden" value="$change_order_priority_id">
						
						<input id="create-change_order_draft-record--change_order_drafts--change_order_status_id--$dummyId" type="hidden" value="$change_order_status_id">
						<input id="create-change_order-record--change_orders--change_order_type_id--$dummyId" type="hidden" value="$change_order_type_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_type_id--$dummyId" type="hidden" value="$change_order_type_id">
						<input id="create-change_order-record--change_orders--change_order_distribution_method_id--$dummyId" type="hidden" value="$change_order_distribution_method_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_distribution_method_id--$dummyId" type="hidden" value="$change_order_distribution_method_id">

						
					</td>
				</tr>

				<tr class="sub_exe" style="$submittstyle" width="100%">
					<td style="display:block;" class="CO_table_header2">Change Order Submitted Date:</td>
				</tr>
				<tr class="sub_exe" style="$submittstyle" width="100%">
					<td class="CO_table2_content" style="display:block;">
						<input id="create-change_order-record--change_orders--co_submitted_date--$dummyId" class="CO_table3 datepicker" type="text" value="$co_submitted_date" $editable>
					</td>
				</tr>

				<tr>
					<td width="70%" class="CO_table_header2">Change Order Status:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
					<span class="moduleCO">
						$ddlCoStatuses
						</span>
						$drawStatusMsg
					</td>
				</tr>
			
				<tr class="app_exe" style="$approvestyle" width="100%">
					<td class="CO_table_header2" style="display:block;">Change Order Approved Date:</td>
				</tr>
				<tr class="app_exe" style="$approvestyle" width="100%">
					<td class="CO_table2_content" style="display:block;">
						<input id="create-change_order-record--change_orders--co_approved_date--$dummyId" class="CO_table3 datepicker" $drawValStatus type="text" value="$co_approved_date">
						$drawStatusMsgWithBr
					</td>
				</tr>

			</table>
		</div>
		<div class="CO_table_create margin0px">
			<table width="100%" border="0" cellspacing="0" cellpadding="4">
				<tr>
					<td class="CO_table_header2" style="vertical-align: middle;">Change Order Recipient: (To)</td>
				</tr>
				<tr>
					<td class="CO_table2_content Subsearch">
						<input id="create-change_order-record--change_orders--co_recipient_contact_id--$dummyId" type="hidden" value="$co_recipient_contact_id">
						<input id="create-change_order_draft-record--change_order_drafts--co_recipient_contact_id--$dummyId" type="hidden" value="$co_recipient_contact_id">
						<p>$ddlProjectTeamMembersTo</p>

						
					</td>
				</tr>
				<tr>
					<td class="CO_table_header2" style="vertical-align: middle;">Change Order Signator: (From)</td>
				</tr>
				<tr>
					<td class="CO_table2_content Subsearch">
						
						<p>$ddlsignator </p>
						</td>
				</tr>
				<tr>
					<td class="CO_table_header2" style="vertical-align: middle;">Custom Owner Change Order Number:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<input id="create-change_order-record--change_orders--co_custom_sequence_number--$dummyId" class="" style="font-size: 15px; height: 25px; padding-left: 5px; width: 198px;" type="text" value="$co_custom_sequence_number">
					</td>
				</tr>
			
				<tr>
					<td class="CO_table_header2">Optional Delay Days:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<input id="create-change_order-record--change_orders--co_delay_days--$dummyId" class="CO_table3 inputNumber" min="0" style="height: 25px;" type="number" placeholder="To be determined" value="$co_delay_days">
					</td>
				</tr>
				<tr>
					<td class="CO_table_header2">Optional Revised Project Completion Date:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						
						<input id="create-change_order-record--change_orders--co_revised_project_completion_date--$dummyId" class="CO_table3 datepicker" type="text" value="$co_revised_project_completion_date">
					</td>
				</tr>
				<tr>
					<td width="70%" class="CO_table_header2">Select A File To Attach:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">{$fileUploader}{$fileUploaderProgressWindow}</td>
</td>
				</tr>
				<tr>
					<td class="CO_table_header2">Attached Files:</td>
				</tr>
				<tr>
					<td id="tdAttachedFilesList" class="CO_table2_content">
						<ul style="list-style:none; margin:0; padding:0" id="container--request_for_information_attachments--create-request_for_information-record" class="divslides">
							$liChangeOrderDraftAttachments
						</ul>
					</td>
				</tr>

				<tr class="up_exe" style="$exestyle" width="100%">
					<td  class="CO_table_header2" style="display:block;">Upload Executed document:</td>
				</tr>
				<tr class="up_exe" style="$exestyle" width="100%">
					<td class="CO_table2_content"  style="display:block;">{$uploadUploader}{$fileUploaderProgressWindow}</td>
</td>
				</tr>
				<tr class="up_exe" style="$exestyle" width="100%">
					<td class="CO_table_header2"  style="display:block;">Upload Executed Files:</td>
				</tr>
				<tr class="up_exe" style="$exestyle" width="100%">
					<td id="tdAttachedFilesList" class="CO_table2_content"  style="display:block;">
						<ul style="list-style:none; margin:0; padding:0" id="container--change_order_attachments--edit-change_order_attachments-record" class="divslides">
							$liChangeOrderupexecuteAttachments
						</ul>
					</td>
				</tr>

				   					
		</table>
	  </div>
	   <table style="width: 99%; border: 3px solid #d4d4d4;">
		   	<tr>
				<td class="CO_table_header2">Cost Analysis Breakdown</td>
			</tr>
			<tr>
				<td class="CO_table2_content">
					$drawStatusMsg
					<br>
					<div class="breakDiv">
						<div class="field_wrapper divtable divslides">
							<div class="trow">
								<div class="tcol"></div>
								<div class="tcol">COSTCODE</div>
								<div class="tcol">DESCRIPTION</div>
					        	<div class="tcol">SUB.</div>
					        	<div class="tcol">REF #</div>
					        	<div class="tcol">COST in ($)</div>
					        	<div class="tcol" style="vertical-align: bottom;padding-bottom: 12px;"></div>
				        	</div>
							$costbreak
			        	</div>
			        	<div class="divtable">
				        	<div class="trow">
						        <div class="tcol" style="width: 18%;"></div>
								<div class="tcol" style="width: 10%;"></div>
								<div class="tcol" style="width: 7%;"></div>
								<div class="tcol" style="width: 8%;text-align: right;"><b>Update Subtotal : </b></div>
								<div class="tcol" style="width: 1%;">$</div>
								<div class="tcol" style="width: 9%;">
				          			<input type="text" class="Number"  name="subtotal" id="subtotal" value="$co_subtotal" disabled/>
				        			<input type="hidden" name="subhidden" id="subhidden" value="$co_subtotal">
				        		</div> 
				         		<div class="tcol" style="width: 2%;" ></div>
				        	</div>
				        </div>
			        	<div class="cont_wrapper divtable contslides">
			        		$dyna_desp
			        	</div>
			          	<div class="divtable">
			          		<div class="trow">
			          			<div class="tcol" style="width: 16%;"></div>
								<div class="tcol" style="width: 13.5%;"></div>
								<div class="tcol" style="text-align: right;width: 8%;"><b>Total : </b></div>
								<div class="tcol" style="width: 1%;" >$</div>
								<div class="tcol" style="width: 8%;">
			          				<input type="text" class="Number" name="total" id="total" value="$co_total" disabled/>
			          				<input type="hidden" class="Number" name="maintotal" id="maintotal" value="$co_total"/> 
			          			</div>
			          			<div class="tcol" style="width: 1.5%;" ></div>
			          		</div>
			        	</div>
			        </div>
		        </td>
	        </tr> 
	   </table>
    </div>
</form>
<input id="create-change_order-record--change_orders--co_type_prefix--$dummyId" type="hidden" value="$co_type_prefix">
<input id="create-change_order-record--change_orders--change_order_draft_id--$dummyId" type="hidden" value="$change_order_draft_id">
<input id="create-change_order-record--change_orders--change_order_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-change_order-record--change_orders--co_attachment_source_contact_id--$dummyId" type="hidden" value="$co_attachment_source_contact_id">
<input id="create-change_order-record--change_orders--co_creator_contact_id--$dummyId" type="hidden" value="$co_creator_contact_id">
<input id="create-change_order-record--change_orders--project_id--$dummyId" type="hidden" value="$project_id">
<input id="create-change_order-record--change_orders--dummy_id" type="hidden" value="$dummyId">
<input id="create-change_order-record--change_orders--sendNotification--$dummyId" type="hidden" value="false">
<input id="create-change_order_notification-record--change_order_notifications--change_order_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-change_order_recipient-record--change_order_recipients--change_order_notification_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-change_order_recipient-record--change_order_recipients--smtp_recipient_header_type--$dummyId" type="hidden" value="Cc">
<input id="create-change_order_attachment-record--change_order_attachments--change_order_id--$dummyId" type="hidden" value="">
<input id="create-change_order_attachment-record--change_order_attachments--change_order_draft_id--$dummyId" type="hidden" value="">
<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_source_contact_id--$dummyId" type="hidden" value="$co_attachment_source_contact_id">
<input id="create-change_order_attachment-record--change_order_attachments--csvCoFileManagerFileIds--$dummyId" type="hidden" value="$csvCoFileManagerFileIds">
	
		<input type="button"  class="viewpdf" onclick="ChangeOrders__openCoPdfInNewTab('$coPdfUrl');" value="View Change Order PDF" style="font-size: 10pt;visibility:hidden;">&nbsp;
	
		<input type="button" value="Save Change Order" class="editsavebtn" onclick="ChangeOrders__EditCoViaPromiseChain('create-change_order-record', '$dummyId','$change_order_draft_id');" style="font-size: 10pt; margin-top: 10px;visibility:hidden;">

END_HTML_CONTENT;

	return $htmlContent;

	}
	//For Edit dialog

function buildCreateCoDialog($database, $user_company_id, $project_id, $currently_active_contact_id,$subOrder=null, $dummyId=null, $changeOrderDraft=null)
{
	if (!isset($dummyId) || empty($dummyId)) {
		$dummyId = Data::generateDummyPrimaryKey();
	}

	// Update / Save case
	if ($changeOrderDraft) {
		/* @var $changeOrderDraft ChangeOrderDraft */

		$change_order_draft_id = (string) $changeOrderDraft->change_order_draft_id;
		$co_custom_sequence_number = $changeOrderDraft->co_custom_sequence_number;
		$co_scheduled_value = (float) $changeOrderDraft->co_scheduled_value;
		$co_delay_days = (int) $changeOrderDraft->co_delay_days;
		$change_order_type_id = (string) $changeOrderDraft->change_order_type_id;
		$change_order_status_id = (int) $changeOrderDraft->change_order_status_id;
		$change_order_priority_id = (string) $changeOrderDraft->change_order_priority_id;
		$change_order_distribution_method_id = (string) $changeOrderDraft->change_order_distribution_method_id;
		$co_file_manager_file_id = (string) $changeOrderDraft->co_file_manager_file_id;
		$co_cost_code_id = (string) $changeOrderDraft->co_cost_code_id;
		$co_creator_contact_id = (string) $changeOrderDraft->co_creator_contact_id;
		$co_creator_contact_company_office_id = (string) $changeOrderDraft->co_creator_contact_company_office_id;
		$co_creator_phone_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_creator_phone_contact_company_office_phone_number_id;
		$co_creator_fax_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_creator_fax_contact_company_office_phone_number_id;
		$co_creator_contact_mobile_phone_number_id = (string) $changeOrderDraft->co_creator_contact_mobile_phone_number_id;
		$co_recipient_contact_id = (string) $changeOrderDraft->co_recipient_contact_id;
		$co_recipient_contact_company_office_id = (string) $changeOrderDraft->co_recipient_contact_company_office_id;
		$co_recipient_phone_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_recipient_phone_contact_company_office_phone_number_id;
		$co_recipient_fax_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_recipient_fax_contact_company_office_phone_number_id;
		$co_recipient_contact_mobile_phone_number_id = (string) $changeOrderDraft->co_recipient_contact_mobile_phone_number_id;
		$co_initiator_contact_id = (string) $changeOrderDraft->co_initiator_contact_id;
		$co_initiator_contact_company_office_id = (string) $changeOrderDraft->co_initiator_contact_company_office_id;
		$co_initiator_phone_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_initiator_phone_contact_company_office_phone_number_id;
		$co_initiator_fax_contact_company_office_phone_number_id = (string) $changeOrderDraft->co_initiator_fax_contact_company_office_phone_number_id;
		$co_initiator_contact_mobile_phone_number_id = (string) $changeOrderDraft->co_initiator_contact_mobile_phone_number_id;
		$co_title = (string) $changeOrderDraft->co_title;
		$co_plan_page_reference = (string) $changeOrderDraft->co_plan_page_reference;
		$co_statement = (string) $changeOrderDraft->co_statement;
		$co_revised_project_completion_date = (string) $changeOrderDraft->co_revised_project_completion_date;

		$co_scheduled_value = Format::formatCurrency($co_scheduled_value);

		// HTML Entity Escaped Data
		$changeOrderDraft->htmlEntityEscapeProperties();
		$escaped_co_custom_sequence_number = $changeOrderDraft->escaped_co_custom_sequence_number;
		$escaped_co_plan_page_reference = $changeOrderDraft->escaped_co_plan_page_reference;
		$escaped_co_statement = $changeOrderDraft->escaped_co_statement;
		$escaped_co_statement_nl2br = $changeOrderDraft->escaped_co_statement_nl2br;
		$escaped_co_title = $changeOrderDraft->escaped_co_title;

		$buttonDeleteCoDraft = <<<END_HTML_CONTENT
<input type="button" value="Delete This Draft" onclick="ChangeOrders__deleteChangeOrderDraft('manage-change_order_draft-record', 'change_order_drafts', '$change_order_draft_id', { successCallback: ChangeOrders__deleteChangeOrderDraftSuccess });" style="font-size: 10pt;">
END_HTML_CONTENT;

		$liChangeOrderDraftAttachments = '';
		$arrCoFileManagerFileIds = array();
		$loadChangeOrderDraftAttachmentsByChangeOrderDraftIdOptions = new Input();
		$loadChangeOrderDraftAttachmentsByChangeOrderDraftIdOptions->forceLoadFlag = true;
		$arrChangeOrderDraftAttachments = ChangeOrderDraftAttachment::loadChangeOrderDraftAttachmentsByChangeOrderDraftId($database, $change_order_draft_id, $loadChangeOrderDraftAttachmentsByChangeOrderDraftIdOptions);
		foreach ($arrChangeOrderDraftAttachments as $change_order_draft_attachment_id => $changeOrderDraftAttachment) {
			/* @var $changeOrderDraftAttachment ChangeOrderDraftAttachment */

			$file_manager_file_id = $changeOrderDraftAttachment->co_attachment_file_manager_file_id;
			$co_attachment_source_contact_id = $changeOrderDraftAttachment->co_attachment_source_contact_id;
			$fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$fileManagerFile->htmlEntityEscapeProperties();
			$virtual_file_name = $fileManagerFile->virtual_file_name;
			$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
			$fileUrl = $fileManagerFile->generateUrl();

			$arrCoFileManagerFileIds[] = $file_manager_file_id;

			$dummyCoDraftAttachmentId = Data::generateDummyPrimaryKey();

			$elementId = "record_container--manage-file_manager_file-record--file_manager_files--$file_manager_file_id";

			$liChangeOrderDraftAttachments .= <<<END_LI_CHANGE_ORDER_DRAFT_ATTACHMENTS

			<li id="record_container--create-change_order_draft_attachment-record--change_order_draft_attachments--$dummyCoDraftAttachmentId" class="hidden">
				<input id="create-change_order_attachment-record--change_order_attachments--change_order_id--$dummyCoDraftAttachmentId" type="hidden" value="$dummyCoDraftAttachmentId">
				<input id="create-change_order_attachment-record--change_order_attachments--change_order_draft_id--$dummyCoDraftAttachmentId" type="hidden" value="$dummyCoDraftAttachmentId">
				<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_file_manager_file_id--$dummyCoDraftAttachmentId" type="hidden" value="$file_manager_file_id">
				<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_source_contact_id--$dummyCoDraftAttachmentId" type="hidden" value="$co_attachment_source_contact_id">
			</li>
			<li id="$elementId">
				<a href="javascript:deleteFileManagerFile('$elementId', 'manage-file_manager_file-record', '$file_manager_file_id');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;
				<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
			</li>
END_LI_CHANGE_ORDER_DRAFT_ATTACHMENTS;

		}

		$csvCoFileManagerFileIds = join(',', $arrCoFileManagerFileIds);

		// <input type="button" value="Save As A New Change Order Draft" onclick="ChangeOrders__createCoDraftViaPromiseChain('create-change_order-record', '$dummyId');" style="font-size: 10pt;">

		// Save Change Order As Draft Button
		$saveChangeOrderAsDraftButton = <<<END_SAVE_CHANGE_ORDER_AS_DRAFT_BUTTON
<input type="button" value="Save Changes To This Draft" onclick="ChangeOrders__createCoDraftViaPromiseChain('create-change_order-record', '$dummyId', { crudOperation: 'update', change_order_draft_id: $change_order_draft_id });" style="font-size: 10pt;">&nbsp;
END_SAVE_CHANGE_ORDER_AS_DRAFT_BUTTON;

	} else {

		// Create case
		$change_order_draft_id = '';
		$co_custom_sequence_number = '';
		$co_scheduled_value = '';
		$co_delay_days = '';
		$change_order_priority_id = ''; // This is being used for "Reason"
		$change_order_type_id = '';
		$change_order_status_id = 1; // Default to "Open"
		$change_order_distribution_method_id = '';
		$co_file_manager_file_id = '';
		$co_cost_code_id = '';
		$co_creator_contact_id = '';
		$co_creator_contact_company_office_id = '';
		$co_creator_phone_contact_company_office_phone_number_id = '';
		$co_creator_fax_contact_company_office_phone_number_id = '';
		$co_creator_contact_mobile_phone_number_id = '';
		$co_recipient_contact_id = '';
		$co_signator_contact_id= '';
		$co_recipient_contact_company_office_id = '';
		$co_recipient_phone_contact_company_office_phone_number_id = '';
		$co_recipient_fax_contact_company_office_phone_number_id = '';
		$co_recipient_contact_mobile_phone_number_id = '';
		$co_initiator_contact_id = '';
		$co_initiator_contact_company_office_id = '';
		$co_initiator_phone_contact_company_office_phone_number_id = '';
		$co_initiator_fax_contact_company_office_phone_number_id = '';
		$co_initiator_contact_mobile_phone_number_id = '';
		$co_title = '';
		$co_plan_page_reference = '';
		$co_statement = '';
		$co_revised_project_completion_date = '';
		$co_submitted_date = date('Y-m-d');;

		// HTML Entity Escaped Data
		$escaped_co_plan_page_reference = '';
		$escaped_co_statement = '';
		$escaped_co_statement_nl2br = '';
		$escaped_co_title = '';

		$buttonDeleteCoDraft = '';
		$csvCoFileManagerFileIds = '';

		// Save Change Order As Draft Button
		$saveChangeOrderAsDraftButton = <<<END_SAVE_CHANGE_ORDER_AS_DRAFT_BUTTON
<input type="button" value="Save Change Order As Draft" onclick="ChangeOrders__createCoDraftViaPromiseChain('create-change_order-record', '$dummyId');" style="font-size: 10pt;">
END_SAVE_CHANGE_ORDER_AS_DRAFT_BUTTON;

	}

	if (!isset($arrChangeOrderDraftAttachments) || count($arrChangeOrderDraftAttachments) == 0) {
		$liChangeOrderDraftAttachments = '<li class="placeholder">No Files Attached</li>';
	}
	if($subOrder)
	{
	$liChangeOrderDraftAttachments=AttachmentforSuborder($database,$subOrder);
	$co_statement=SuborderDataForchangeOrder($database,$subOrder,'description');
	$co_scheduled_value='$'.SuborderDataForchangeOrder($database,$subOrder,'estimated_amount');
	$change_order_type_id='3';
	}
	// FileManagerFolder
	$virtual_file_path = '/Change Orders/Change Order Draft Attachments/';
	$coFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $virtual_file_path);
	/* @var $coFileManagerFolder FileManagerFolder */

	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--change_order_attachments--create-change_order-record';
	$input->folder_id = $coFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Change Orders/Change Order Draft Attachments/';
	//$input->virtual_file_name = 'Attachment #1';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadChangeOrderAttachment';
	$input->allowed_extensions = 'pdf';
	$input->post_upload_js_callback = "ChangeOrders__coDraftAttachmentUploaded(arrFileManagerFiles, 'container--change_order_attachments--create-change_order-record')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

	$coCostCodesElementId = "ddl--create-change_order-record--change_orders--co_cost_code_id--$dummyId";

	$costCodesInput = new Input();
	$prependedOption = '';
	$tabIndex = '';
	$js = 'style="width:95%"';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$costCodesInput->project_id = $project_id;
	$selectedOption = $co_cost_code_id;
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $coCostCodesElementId;
	$costCodesInput->firstOption = '<option value="0">Optionally Select A Cost Code Below For Reference</option>';
	$costCodesInput->selectCssStyle = 'style="font-size: 1.3em; height: 30px; width: 400px;"';
	$costCodesInput->selectedOption = $co_cost_code_id;
	$coDraftsHiddenCostCodeElementId = "create-change_order_draft-record--change_order_drafts--co_cost_code_id--$dummyId";
	$costCodesInput->additionalOnchange = "ddlOnChange_UpdateHiddenInputValue(this, '$coDraftsHiddenCostCodeElementId');updateSubcontractors(this.value,&apos;$dummyId&apos;,&apos;$user_company_id&apos;,&apos;$project_id&apos;);";
	// $ddlCostCodes = buildCostCodeDropDownList($costCodesInput);
	$ddlCostCodes = buildProjectCostCodeDropDownList($costCodesInput);
	//$ddlCostCodes = PageComponents::dropDownListFromObjects($coCostCodesElementId, $arrCostCodes, 'cost_code_id', null, 'cost_code_description', null, $selectedOption, $tabIndex, $js, $prependedOption);

	// cost code dropdown for breakdown analysis
	$costCodesInput = new Input();
	$prependedOption = '';
	$tabIndex = '';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$costCodesInput->project_id = $project_id;
	$selectedOption = $co_cost_code_id;
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $coCostCodesElementId;
	$costCodesInput->firstOption = '<option value="0">Select A Cost Code</option>';
	$costCodesInput->selectedOption = $co_cost_code_id;
	$coDraftsHiddenCostCodeElementId = "create-co_cost_code_id";
	// $ddlCostCodes = buildCostCodeDropDownList($costCodesInput);
	$ddlCostCodesListOptions = buildProjectCostCodeDropDownListOptions($costCodesInput);

	$loadAllChangeOrderPrioritiesOptions = new Input();
	$loadAllChangeOrderPrioritiesOptions->forceLoadFlag = true;
	$arrChangeOrderPriorities = ChangeOrderPriority::loadAllChangeOrderPriorities($database, $loadAllChangeOrderPrioritiesOptions);
	$ddlCoPrioritiesId = "ddl--create-change_order-record--change_orders--change_order_priority_id--$dummyId";
	$coDraftsHiddenCoPrioritiesElementId = "create-change_order_draft-record--change_order_drafts--change_order_priority_id--$dummyId";
	$js = ' style="width: 350px;" class="moduleCO_dropdown" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenCoPrioritiesElementId.'\');"';
	$prependedOption = '<option value="">Optionally Select A Change Order Reason</option>';
	$selectedOption = $change_order_priority_id;
	$ddlCoPriorities = PageComponents::dropDownListFromObjects($ddlCoPrioritiesId, $arrChangeOrderPriorities, 'change_order_priority_id', null, 'change_order_priority', null, $selectedOption, null, $js, $prependedOption);

	$loadAllChangeOrderTypesOptions = new Input();
	$loadAllChangeOrderTypesOptions->forceLoadFlag = true;
	$arrChangeOrderTypes = ChangeOrderType::loadAllChangeOrderTypes($database, $loadAllChangeOrderTypesOptions);
	$ddlCoTypesId = "ddl--create-change_order-record--change_orders--change_order_type_id--$dummyId";
	$coDraftsHiddenCoTypesElementId = "create-change_order_draft-record--change_order_drafts--change_order_type_id--$dummyId";
	$js = ' style="width: 250px;" class="moduleCO_dropdown3 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenCoTypesElementId.'\');COsubmittedDate(this.value);"';
	$prependedOption = '<option value="">Select Change Order Type</option>';
	$selectedOption = $change_order_type_id;
	$ddlCoTypes = PageComponents::dropDownListFromObjects($ddlCoTypesId, $arrChangeOrderTypes, 'change_order_type_id', null, 'change_order_type', null, $selectedOption, null, $js, $prependedOption);

	$loadAllChangeOrderDistributionMethodsOptions = new Input();
	$loadAllChangeOrderDistributionMethodsOptions->forceLoadFlag = true;
	$arrChangeOrderDistributionMethods = ChangeOrderDistributionMethod::loadAllChangeOrderDistributionMethods($database, $loadAllChangeOrderDistributionMethodsOptions);
	$ddlCoDistributionMethodsId = "ddl--create-change_order-record--change_orders--change_order_distribution_method_id--$dummyId";
	$coDraftsHiddenCoDistributionMethodsElementId = "create-change_order_draft-record--change_order_drafts--change_order_distribution_method_id--$dummyId";
	$js = ' style="width: 250px;" class="moduleCO_dropdown3" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenCoDistributionMethodsElementId.'\');"';
	$prependedOption = '<option value="">Select CO Distribution Method</option>';
	$selectedOption = $change_order_distribution_method_id;
	$ddlCoDistributionMethods = PageComponents::dropDownListFromObjects($ddlCoDistributionMethodsId, $arrChangeOrderDistributionMethods, 'change_order_distribution_method_id', null, 'change_order_distribution_method', null, $selectedOption, null, $js, $prependedOption);

	$arrContactsByUserCompanyId = Contact::loadContactsByUserCompanyId($database, $user_company_id);

	// From: Subcontractor
	// co_initiator_contact_id
	$coDraftsHiddenContactsByUserCompanyIdToElementId = "create-change_order_draft-record--change_order_drafts--co_initiator_contact_id--$dummyId";
	/*
	$js = ' class="moduleCO_dropdown4 required" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenContactsByUserCompanyIdToElementId.'\');"';
	$prependedOption = '<option value="">Select a contact</option>';
	$ddlContactsByUserCompanyIdElementId = "ddl--create-change_order-record--change_orders--co_initiator_contact_id--$dummyId";
	$selectedOption = $co_initiator_contact_id;
	$ddlContactsByUserCompanyId = PageComponents::dropDownListFromObjects($ddlContactsByUserCompanyIdElementId, $arrContactsByUserCompanyId, 'contact_id', null, null, 'getContactFullName', $selectedOption, null, $js, $prependedOption);
	*/
	// DDL of contacts
	$input = new Input();
	$input->database = $database;
	$input->user_company_id = $user_company_id;
	//$input->csvContactIdExclusionList = $arrCustomizedPermissionsByContact;
	$input->selected_contact_id = $co_initiator_contact_id;
	$input->htmlElementId = "create-change_order-record--change_orders--co_initiator_contact_id--$dummyId";
	$input->js = ' class="emailGroup moduleCO_dropdown4" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenContactsByUserCompanyIdToElementId.'\');"';
	$input->firstOption = 'Optionally Select A CO Initiator Contact';
	$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildContactsFullNameWithEmailByUserCompanyIdDropDownList($input);

	$arrProjectTeamMembersNew = Contact::loadProjectTeamMembersNew($database, $project_id, 'change_orders');

	// To:
	// co_recipient_contact_id
	$coDraftsHiddenProjectTeamMembersToElementId = "create-change_order-record--change_orders--co_recipient_contact_id--$dummyId";
	$js = ' class="moduleCO_dropdown4 required emailGroup" $editdisable onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenProjectTeamMembersToElementId.'\');changeOrder_isMailToError(this);"';
	$prependedOption = '<option value="">Select A Change Order Recipient</option>';
	$ddlProjectTeamMembersToId = "ddl--create-change_order-record--change_orders--co_recipient_contact_id--$dummyId";	
	$ddlProjectTeamMembersTo = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersToId);	

	//End of new

	//To add the signator field
	$arrSignatorMembers = Contact::loadSignatorMembers($database, $user_company_id, $project_id);
		usort($arrSignatorMembers, function ($a,$b)  {
    return ($a["company"] <= $b["company"]) ? -1 : 1;  	 });

	$coDraftsHiddenProjectTeamMembersToElementId = "create-change_order-record--change_orders--co_signator_contact_id--$dummyId";
	$prependedOption = '<option value="">Select A Change Order Signator</option>';
	$ddlProjectTeamMembersToId = "create-change_order-record--change_orders--co_signator_contact_id--$dummyId";
	$selectedOption = $currently_active_contact_id;
	$js ="class='emailGroup moduleCO_dropdown4 required' onchange='changeOrder_isMailFromError(this);'";
	$ddlsignator = buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembersNew,$js,$ddlProjectTeamMembersToId,$selectedOption);	

	$arrProjectTeamMembers = Contact::loadProjectTeamMembers($database, $project_id,'','','1');

	// Cc:
	// co_additional_recipient_contact_id
	$ddlProjectTeamMembersCcId = "ddl--create-change_order_recipient-record--change_order_recipients--co_additional_recipient_contact_id--Cc-$dummyId";
	$js = ' onchange="ChangeOrders__addRecipient(this);" class="moduleCO_dropdown4"';
	$ddlProjectTeamMembersCc = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersCcId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);
	// Bcc:
	$ddlProjectTeamMembersBccId = "ddl--create-change_order_recipient-record--change_order_recipients--co_additional_recipient_contact_id--Bcc-$dummyId";
	$ddlProjectTeamMembersBcc = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersBccId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);

	$co_attachment_source_contact_id = $currently_active_contact_id;
	$co_creator_contact_id = $currently_active_contact_id;

	//To implement the attachments
	// FileManagerFolder
	$virtual_file_path = '/Change Orders/Change Order Draft Attachments/';
	$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $virtual_file_path);
	/* @var $rfiFileManagerFolder FileManagerFolder */

	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record';
	$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Change Orders/Change Order Draft Attachments/';
	//$input->virtual_file_name = 'Attachment #1';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadRequestForInformationAttachment';
	$input->allowed_extensions = 'pdf,jpg,jpeg,doc,docx,png,gif,xlsx,csv,xls,rtf';
	$input->post_upload_js_callback = "change__orderDraftAttachmentUploaded(arrFileManagerFiles, 'container--request_for_information_attachments--create-request_for_information-record','N')";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();



	$costCodesInput = new Input();
	$prependedOption = '';
	$tabIndex = '';
	$costCodesInput->database = $database;
	$costCodesInput->user_company_id = $user_company_id;
	$costCodesInput->project_id = $project_id;
	$selectedOption = $co_cost_code_id;
	$costCodesInput->selected_cost_code = $selectedOption;
	$costCodesInput->htmlElementId = $coCostCodesElementId;
	$costCodesInput->firstOption = '<option value="0">Select A Cost Code</option>';
	$coDraftsHiddenCostCodeElementId = "create-co_cost_code_id";
	// $ddlCostCodes = buildCostCodeDropDownList($costCodesInput);
	$ddlTaxCodeDefault = buildProjectCostCodeDropDownListOptions($costCodesInput);


	//For tax break down template
	$tax_break ="";
	$i=1;
	$templateData=getCOTemplateData($database,$project_id);
	$countTaxI = count($templateData);
	if($templateData)
	{
		foreach ($templateData as $key => $template) {
			$costCodesInput = new Input();
			$prependedOption = '';
			$tabIndex = '';
			$costCodesInput->database = $database;
			$costCodesInput->user_company_id = $user_company_id;
			$costCodesInput->project_id = $project_id;
			$selectedOption = $template['cost_code'];
			$costCodesInput->selected_cost_code = $selectedOption;
			$costCodesInput->htmlElementId = $coCostCodesElementId;
			$costCodesInput->firstOption = '<option value="0">Select A Cost Code</option>';
			$coDraftsHiddenCostCodeElementId = "create-co_cost_code_id";
			// $ddlCostCodes = buildCostCodeDropDownList($costCodesInput);
			$ddlTaxCode = buildProjectCostCodeDropDownListOptions($costCodesInput);
		$tax_break .="
		<div class='trow cont_div contdrag'>  
		<div class='tcol' style='width: 0.5%;'>		
			<img src='/images/sortbars.png' style='cursor: pointer;' rel='tooltip' title='' data-original-title='Drag bars to change sort order'></div>
			<div class='tcol' style='width: 14%;'>
			<input  type='hidden' name='taxcode-optionslist' id='tax-code-options-list' value='$ddlTaxCodeDefault'/>
		    <input  type='hidden' name='taxcode[]' id='taxcode$i' value='$selectedOption'/>
		    <input  type='hidden' id='taxcode-inc-value' value='$countTaxI'/>
		    <select class='taxcode-select$i taxcode-select' onchange='updateTaxCostCodeValue(this.value, $i)' style='
			width: 285px;'>$ddlTaxCode</select>
			</div>
			<div class='tcol' style='width: 11%;'>
				<input type='text' class='' name='content[]' id='content$i' value='".$template['description']."' /> 
			</div>
			<div class='tcol' style='width: 1%;'>%</div>
			<div class='tcol' style='width: 9%;'>
				<input type='text' class='Number' name='percentage[]' id='percentage[]' value='' onkeyup='calcSubtotal()'/> 
			</div>
			<div class='tcol' style='width: 8%; text-align: center;'><b>OR</b></div>
			<div class='tcol' style='width: 1%;'>$</div>
			<div class='tcol' style='width: 9%;'>
				<input type='text' class='Number' name='contotal[]' id='contotal[]' value='' onkeyup='setTimeout(calcSubtotal(),2000)'/>
			</div>        	
        ";
        if($i=='1')
        {
        	$tax_break .="
        		<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 1.5%;'>
        			<a href='javascript:void(0);' class='add_button entypo-plus-circled' title='Add field' onclick='addcostbreakdown()'></a>        
        		</div>
         	</div>
        	";
     	} else {
     		$tax_break .="
     			<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'>
        			<a href='javascript:void(0);' class='remove_button entypo-minus-circled' title='Remove field' ></a>        
        		</div>
         	</div>
        	";
     	}
        $i++;
     }
	}
	else
	{
		$tax_break .="
			<div class='trow'>  
			<div class='tcol' style='width: 0.5%;'>		
			<img src='/images/sortbars.png' style='cursor: pointer;' rel='tooltip' title='' data-original-title='Drag bars to change sort order'></div>
				<div class='tcol' style='width: 14%;'>
				<input  type='hidden' name='taxcode-optionslist' id='tax-code-options-list' value='$ddlTaxCodeDefault'/>
		    <input  type='hidden' name='taxcode[]' id='taxcode$i' value='$selectedOption'/>
		    <input  type='hidden' id='taxcode-inc-value' value='$countTaxI'/>
		    <select class='taxcode-select$i taxcode-select' onchange='updateTaxCostCodeValue(this.value, $i)' style='
			width: 285px;'>$ddlTaxCodeDefault</select>
				</div>
	         	<div class='tcol' style='width: 9%;'>
	        		<input type='text' class='' name='content[]' id='content[]' value='' /> 
	          	</div>
	          	<div class='tcol' style='width: 1%;'>%</div>
	          	<div class='tcol' style='width: 8%;'>
	         		<input type='text' class='Number' name='percentage[]' id='percentage[]' value='' onkeyup='calcSubtotal()'/> 
	          	</div>
	         	<div class='tcol' style='width: 8%; text-align: center;'><b>OR</b></div>
	          	<div class='tcol' style='width: 1%;'>$</div>
	          	<div class='tcol' style='width: 9%;'>
	         		<input type='text' class='Number' name='contotal[]' id='contotal[]' value='' onkeyup='setTimeout(calcSubtotal(),2000)'/>
	         	</div>
	          	<div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'>
	        		<a href='javascript:void(0);' class='add_button entypo-plus-circled' title='Add field' onclick='addcostbreakdown()'></a>        
	        	</div>
	        </div>
	    ";
     }
	//End of tax break template


	$htmlContent = <<<END_HTML_CONTENT

<form id="formCreateCo">
	<div id="record_creation_form_container--create-change_order-record--$dummyId">
		<div class="CO_table_create">
			<table border="0" cellpadding="4" cellspacing="0" width="100%">
				<tr>
					<td class="CO_table_header2">Change Order Type [PCO / COR / OCO]:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<input id="create-change_order-record--change_orders--change_order_type_id--$dummyId" type="hidden" value="$change_order_type_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_type_id--$dummyId" type="hidden" value="$change_order_type_id">
						<span class="moduleCO">
						$ddlCoTypes
						</span>
					</td>
				</tr>
				<tr>
					<td class="CO_table_header2">Optional Change Order Reason:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<input id="create-change_order-record--change_orders--co_cost_code_id--$dummyId" type="hidden" value="$co_cost_code_id">

						<input id="create-change_order-record--change_orders--change_order_priority_id--$dummyId" type="hidden" value="$change_order_priority_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_priority_id--$dummyId" type="hidden" value="$change_order_priority_id">
						<span class="moduleCO">
						$ddlCoPriorities
						</span>
					</td>
				</tr>
				
				<tr>
					<td class="CO_table_header2">Optional Change Order Subcontractor:</td>
				</tr>
				<tr>
					<td class="CO_table2_content Subsearch">
						<span id="subCoList">
						$contactsFullNameWithEmailByUserCompanyIdDropDownList
						</span>
					</td>
				</tr>
				<tr>
					<td width="70%" class="CO_table_header2">Change Order Title:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<!--<input type="text" class="CO_table2" name="co_title">-->
						<input id="create-change_order-record--change_orders--co_title--$dummyId" class="CO_table2 required" type="text" value="$escaped_co_title">
					</td>
				</tr>
				<tr>
					<td class="CO_table_header2">Optional Change Order References:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<p>
							<!--<input type="text" class="CO_table2" name="co_plan_page_reference">-->
							<input id="create-change_order-record--change_orders--co_plan_page_reference--$dummyId" class="CO_table2" type="text" value="$escaped_co_plan_page_reference">
						</p>
					</td>
				</tr>
				<tr>
					<td class="CO_table_header2">Change Order Description</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<p><textarea id="create-change_order-record--change_orders--co_statement--$dummyId" class="CO_table2">$co_statement</textarea></p>
						<input id="create-change_order-record--change_orders--change_order_priority_id--$dummyId" type="hidden" value="$change_order_priority_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_priority_id--$dummyId" type="hidden" value="$change_order_priority_id">
						<input id="create-change_order-record--change_orders--change_order_status_id--$dummyId" type="hidden" value="$change_order_status_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_status_id--$dummyId" type="hidden" value="$change_order_status_id">
						<input id="create-change_order-record--change_orders--change_order_type_id--$dummyId" type="hidden" value="$change_order_type_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_type_id--$dummyId" type="hidden" value="$change_order_type_id">
						<input id="create-change_order-record--change_orders--change_order_distribution_method_id--$dummyId" type="hidden" value="$change_order_distribution_method_id">
						<input id="create-change_order_draft-record--change_order_drafts--change_order_distribution_method_id--$dummyId" type="hidden" value="$change_order_distribution_method_id">

						<!--
						<table border="1" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left">Change Order Reason:</td>
								<td align="left">Change Order Type:</td>
								<td align="left">Delay Days:</td>
								<td align="left">Amount:</td>
							</tr>
							<tr>
								<td class="paddingRight10">$ddlCoPriorities</td>
								<td class="paddingRight10">$ddlCoTypes</td>
								<td class="paddingRight10"></td>
								<td class="paddingRight10"></td>
							</tr>
						</table>
						-->

					</td>
				</tr>
				<tr class="sub_exe" style="display:none;" width="100%">
					<td style="display:block;" class="CO_table_header2">Change Order Submitted Date:</td>
				</tr>
				<tr class="sub_exe" style="display:none;" width="100%">
					<td style="display:block;" class="CO_table2_content">
						<input id="create-change_order-record--change_orders--co_submitted_date--$dummyId" class="CO_table3 datepicker" type="text" value="$co_submitted_date">
					</td>
				</tr>
			</table>
		</div>
		<div class="CO_table_create margin0px">
			<table width="100%" border="0" cellspacing="0" cellpadding="4">
				<tr>
					<td class="CO_table_header2" style="vertical-align: middle;">Change Order Recipient: (To)</td>
				</tr>
				<tr>
					<td class="CO_table2_content Subsearch">
						<input id="create-change_order-record--change_orders--co_recipient_contact_id--$dummyId" type="hidden" value="$co_recipient_contact_id">
						<input id="create-change_order_draft-record--change_order_drafts--co_recipient_contact_id--$dummyId" type="hidden" value="$co_recipient_contact_id">
						<p>$ddlProjectTeamMembersTo</p>

						<!--
						<div>
							<p>Cc: &nbsp;$ddlProjectTeamMembersCc</p>
							<ul id="record_container--change_order_recipients--Cc" style="list-style:none;">
							</ul>
						</div>
						<div>
							<p>Bcc: $ddlProjectTeamMembersBcc</p>
							<ul id="record_container--change_order_recipients--Bcc" style="list-style:none;">
							</ul>
						</div>
						<p>Add additional text to the body of the email: </p>
						<p><textarea id="textareaEmailBody" class="CO_table2"></textarea></p>
						<p>
							<input type="button" value="Save As A Change Order And Notify Team" onclick="ChangeOrders__createCoAndSendEmailViaPromiseChain('create-change_order-record', '$dummyId');" style="font-size: 10pt;">&nbsp;
							<input type="button" value="Save Change Order" onclick="ChangeOrders__createCoViaPromiseChain('create-change_order-record', '$dummyId');" style="font-size: 10pt;">
						</p>
						<p>
							$saveChangeOrderAsDraftButton&nbsp;&nbsp;<span id="spanDeleteCoDraft">$buttonDeleteCoDraft</span>
						</p>
						<span class="fakeHref verticalAlignBottom" onclick="showHideDomElement('co_draft_help');">(?)</span><span id="co_draft_help" class="displayNone verticalAlignBottom"> Note: Saving the Change Order as a Draft will save your files and the Email To, but not the Email Cc, Bcc, or message.</span>
						-->

					</td>
				</tr>
				<tr>
					<td class="CO_table_header2" style="vertical-align: middle;">Change Order Signator: (From)</td>
				</tr>
				<tr>
					<td class="CO_table2_content Subsearch">
						
						$ddlsignator 
						</td>
				</tr>
				<tr>
					<td class="CO_table_header2" style="vertical-align: middle;">Custom Owner Change Order Number:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<input id="create-change_order-record--change_orders--co_custom_sequence_number--$dummyId" class="" style="font-size: 15px; height: 25px; padding-left: 5px; width: 198px;" type="text" value="$co_custom_sequence_number">
					</td>
				</tr>
			
				<tr>
					<td class="CO_table_header2">Optional Delay Days:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<input id="create-change_order-record--change_orders--co_delay_days--$dummyId" class="CO_table3 inputNumber" min="0" style="height: 25px;" type="number" placeholder="To be determined" value="$co_delay_days">
					</td>
				</tr>
				<tr>
					<td class="CO_table_header2">Optional Revised Project Completion Date:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">
						<!--<input id="dueDate" type="text" class="CO_table3" name="co_revised_project_completion_date">-->
						<input id="create-change_order-record--change_orders--co_revised_project_completion_date--$dummyId" class="CO_table3 datepicker" type="text" value="$co_revised_project_completion_date">
					</td>
				</tr>
				<tr>
					<td width="70%" class="CO_table_header2">Select A File To Attach:</td>
				</tr>
				<tr>
					<td class="CO_table2_content">{$fileUploader}{$fileUploaderProgressWindow}</td>
</td>
				</tr>
				<tr>
					<td class="CO_table_header2">Attached Files:</td>
				</tr>
				<tr>
					<td id="tdAttachedFilesList" class="CO_table2_content">
						<ul style="list-style:none; margin:0; padding:0" id="container--request_for_information_attachments--create-request_for_information-record" class="fileatt divslides">
							$liChangeOrderDraftAttachments
						</ul>
					</td>
				</tr>
				 					
		</table>
	  </div>
	   <table style="width: 99%; border: 3px solid #d4d4d4;">
	   		<tr>
				<td class="CO_table_header2">Cost Analysis Breakdown</td>
			</tr>
			<tr>
				<td class="CO_table2_content">
					<div class="breakDiv">
						<div class="field_wrapper divtable divslides">
							<div class="trow">
								<div class="tcol"></div>
								<div class="tcol">COSTCODE</div>
								<div class="tcol">DESCRIPTION</div>
								<div class="tcol"> SUB.	</div>
								<div class="tcol"> REF #	</div>
								<div class="tcol"> COST in ($)	</div>
								<div class="tcol">	</div>
							</div>
							<div class="trow">
							<div class="tcol" style="width: 0.5%;"><img src="/images/sortbars.png" style='cursor: pointer;' rel="tooltip" title="" data-original-title="Drag bars to change sort order"></div>
								<div class="tcol" style="width: 25%;">					
									<input class="required" type="hidden" name="costcode-optionslist" id="cost-code-options-list" value='$ddlCostCodesListOptions'/>
								    <input type="hidden" name="costcode[]" id="costcode1" value=""/>
								    <input type="hidden" id="cocode-inc-value" value="1"/>
								    <select class='costcode-select1 costcode-select' onchange="updateCostCodeValue(this.value, 1)" >$ddlCostCodesListOptions</select>
	    						</div>
								<div class="tcol" style="width: 22%;">		
									<input class="required" type="text" name="descript[]" id="descript[]" value=""/>
								</div>
								<div class="tcol">
								   <input class="" type="text" name="sub[]" id="sub[]" value=""/>
								</div>
								<div class="tcol">
								   <input class="" type="text" name="ref[]" id="ref[]" value=""/>
								</div>
								<div class="tcol">
								   <input class="Number required " type="text" name="cost[]" id="cost[]"  value="" onkeyup="setTimeout(calcSubtotal(),2000)"/>
								</div>
								<div class="tcol" style="vertical-align: bottom;padding-bottom: 12px;">
									<a href="javascript:void(0);" class="add_button entypo-plus-circled " title="Add field" onclick="addbreakdown()"></a>        
								</div>
							</div>
						</div>
						<div class="divtable">
							<div class="trow">
								<div class="tcol" style="width: 18%;"></div>
								<div class="tcol" style="width: 10%;"></div>
								<div class="tcol" style="width: 7%;"></div>
								<div class="tcol" style="width: 8%;text-align: right;"><b>Update Subtotal : </b></div>
								<div class="tcol" style="width: 1%;">$</div>
								<div class="tcol" style="width: 9%;">
									<input type="text" class="Number"  name="subtotal" id="subtotal" value="" disabled/>
									<input type="hidden" name="subhidden" id="subhidden" value="">
								</div> 
								<div class="tcol" style="width: 2%;" ></div> 
							</div>
						</div>
						<div class="cont_wrapper divtable contslides">
							$tax_break
						</div>
						<div class="divtable">
							<div class="trow"> 
								<div class="tcol" style="width: 16%;"></div>
								<div class="tcol" style="width: 13.5%;"></div>
								<div class="tcol" style="text-align: right;width: 8%;"><b>Total : </b></div>
								<div class="tcol" style="width: 1%;" >$</div>
								<div class="tcol" style="width: 8%;">
									<input type="text" class="Number" name="total" id="total" value="" disabled/>
									<input type="hidden" class="Number" name="maintotal" id="maintotal" value=""/> 
								</div>
								<div class="tcol" style="width: 1.5%;" ></div>
							</div>
						</div>
					</div>
				</td>
			</tr>   
	   </table>
   	</div>
</form>
<input id="create-change_order-record--change_orders--change_order_draft_id--$dummyId" type="hidden" value="$change_order_draft_id">
<input id="create-change_order-record--change_orders--change_order_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-change_order-record--change_orders--co_attachment_source_contact_id--$dummyId" type="hidden" value="$co_attachment_source_contact_id">
<input id="create-change_order-record--change_orders--co_creator_contact_id--$dummyId" type="hidden" value="$co_creator_contact_id">
<input id="create-change_order-record--change_orders--project_id--$dummyId" type="hidden" value="$project_id">
<input id="create-change_order-record--change_orders--dummy_id" type="hidden" value="$dummyId">
<input id="create-change_order-record--change_orders--sendNotification--$dummyId" type="hidden" value="false">
<input id="create-change_order_notification-record--change_order_notifications--change_order_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-change_order_recipient-record--change_order_recipients--change_order_notification_id--$dummyId" type="hidden" value="$dummyId">
<input id="create-change_order_recipient-record--change_order_recipients--smtp_recipient_header_type--$dummyId" type="hidden" value="Cc">
<input id="create-change_order_attachment-record--change_order_attachments--change_order_id--$dummyId" type="hidden" value="">
<input id="create-change_order_attachment-record--change_order_attachments--change_order_draft_id--$dummyId" type="hidden" value="">
<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_source_contact_id--$dummyId" type="hidden" value="$co_attachment_source_contact_id">
<input id="create-change_order_attachment-record--change_order_attachments--csvCoFileManagerFileIds--$dummyId" type="hidden" value="$csvCoFileManagerFileIds">

		<input type="button" value="Save Change Order" class="savebtn" onclick="ChangeOrders__createCoViaPromiseChain('create-change_order-record', '$dummyId');" style="font-size: 10pt; margin-top: 10px;visibility:hidden;">

END_HTML_CONTENT;

	return $htmlContent;
}

function buildCoAsHtmlForPdfConversion($database, $user_company_id, $change_order_id,$jobsitePhotoHtmlContent='')
{
	$changeOrder = ChangeOrder::findChangeOrderByIdExtended($database, $change_order_id);
	/* @var $changeOrder ChangeOrder */
	$co_project_id=$co_sequence_number = $changeOrder->project_id;

	$sequence_data=$co_sequence_number = $changeOrder->co_sequence_number;
	$co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
	$co_scheduled_value = $changeOrder->co_scheduled_value;
	$co_delay_days = $changeOrder->co_delay_days;
	$change_order_type_id = $changeOrder->change_order_type_id;
	$change_order_status_id = $changeOrder->change_order_status_id;
	$change_order_priority_id = $changeOrder->change_order_priority_id;
	$change_order_distribution_method_id = $changeOrder->change_order_distribution_method_id;
	$co_file_manager_file_id = $changeOrder->co_file_manager_file_id;
	$co_cost_code_id = $changeOrder->co_cost_code_id;
	$co_creator_contact_id = $changeOrder->co_creator_contact_id;
	$co_creator_contact_company_office_id = $changeOrder->co_creator_contact_company_office_id;
	$co_creator_phone_contact_company_office_phone_number_id = $changeOrder->co_creator_phone_contact_company_office_phone_number_id;
	$co_creator_fax_contact_company_office_phone_number_id = $changeOrder->co_creator_fax_contact_company_office_phone_number_id;
	$co_creator_contact_mobile_phone_number_id = $changeOrder->co_creator_contact_mobile_phone_number_id;
	$co_recipient_contact_id = $changeOrder->co_recipient_contact_id;
	$co_recipient_contact_company_office_id = $changeOrder->co_recipient_contact_company_office_id;
	$co_recipient_phone_contact_company_office_phone_number_id = $changeOrder->co_recipient_phone_contact_company_office_phone_number_id;
	$co_recipient_fax_contact_company_office_phone_number_id = $changeOrder->co_recipient_fax_contact_company_office_phone_number_id;
	$co_recipient_contact_mobile_phone_number_id = $changeOrder->co_recipient_contact_mobile_phone_number_id;
	$co_initiator_contact_id = $changeOrder->co_initiator_contact_id;
	$co_initiator_contact_company_office_id = $changeOrder->co_initiator_contact_company_office_id;
	$co_initiator_phone_contact_company_office_phone_number_id = $changeOrder->co_initiator_phone_contact_company_office_phone_number_id;
	$co_initiator_fax_contact_company_office_phone_number_id = $changeOrder->co_initiator_fax_contact_company_office_phone_number_id;
	$co_initiator_contact_mobile_phone_number_id = $changeOrder->co_initiator_contact_mobile_phone_number_id;
	$co_title = $changeOrder->co_title;
	$co_plan_page_reference = $changeOrder->co_plan_page_reference;
	$co_statement = $changeOrder->co_statement;
	$co_created = $changeOrder->created;
	$co_revised_project_completion_date = $changeOrder->co_revised_project_completion_date;
	$co_closed_date = $changeOrder->co_closed_date;
	$co_COR_created = $changeOrder->COR_created;
	$co_signator_contact_id =$changeOrder->co_signator_contact_id;

	$co_type_prefix = $changeOrder->co_type_prefix;
	$co_subtotal =$changeOrder->co_subtotal;
	$co_genper = $changeOrder->co_genper;
	$co_gentotal =$changeOrder->co_gentotal;
	$co_buildper = $changeOrder->co_buildper;
	$co_buildtotal =$changeOrder->co_buildtotal;
	$co_insuranceper = $changeOrder->co_insuranceper;
	$co_insurancetotal  =$changeOrder->co_insurancetotal ;

	$co_subtotal = Format::formatCurrency($co_subtotal);
	//Contracting entity id
	$contracting_entity_id =$changeOrder->contracting_entity_id;
	// Getting  Contractor Name for the contracting Id
	$entityName = ContractingEntities::getcontractEntityNameforProject($database,$contracting_entity_id);
	// To get architect name of latest posted draw of the project
	$projectAddress = Project::getProjectAddress($database,$co_project_id);
	$projectDetails = Project::findById($database,$co_project_id);
	if($projectDetails['project_contract_date'] !="0000-00-00")
	{
		$dateObj2 = DateTime::createFromFormat('Y-m-d', $projectDetails['project_contract_date']);
		$proj_contract_date = $dateObj2->format('m/d/Y');
	}

	$architectCompany = ContactCompany::findByContactUserCompanyId($database, $projectDetails['architect_cmpy_id']);
  $contactName = Contact::findById($database, $projectDetails['architect_cont_id']);
	$architechName = ($contactName == '') ? '' : $contactName->getContactFullName();
	$architectAddress = Project::getContactCompanyAddress($database, $projectDetails['architect_cmpy_id']);

	$ownerCompany = ContactCompany::findByContactUserCompanyId($database, $projectDetails['user_company_id']);
	$ownerAddress = Project::getOwnerAddress($database,$co_project_id);

	$cost_item="";
	$costbreakitems="";

	$resdata=getchangeordercostbreakdownData($database,$change_order_id);
	$breakDown = array();
	$i='1';
	$breakDownCnt = 1;
	foreach ($resdata as $key => $ctvalue) { 
		$desc = $ctvalue['description'];
		$desc = str_replace('&comma;', ',', $desc);
		$description = str_replace("&apos;", "'", $desc);
		$costcode_id = $ctvalue['cost_code_reference_id'];
		$costCode = CostCode::findById($database, $costcode_id);
		// $getFormattedCostCode = $costCode-getFormattedCostCode($database);
		$htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCodeApi($database,$user_company_id);
		$costdata = Format::formatCurrency($ctvalue['cost']);
		$sub_value=($ctvalue['Sub']!="")?$ctvalue['Sub']:'&nbsp;';
		$sub_value = str_replace('&comma;', ',', $sub_value);
		$sub_value = str_replace("&apos;", "'", $sub_value); 
		$ref_value=($ctvalue['reference'] !="")?$ctvalue['reference']:'&nbsp;';
		$ref_value = str_replace('&comma;', ',', $ref_value);
		$ref_value = str_replace("&apos;", "'", $ref_value);
		$breakDown[$breakDownCnt]['costcode'] = $htmlEntityEscapedFormattedCostCode;
		$breakDown[$breakDownCnt]['cost'] = $costdata;
		$costbreakitems .="<tr><td style='font-size:12px;padding:3px;' align='center'>$i</td>
		<td style='font-size:12px;padding:3px;'>".$htmlEntityEscapedFormattedCostCode."</td>
		<td style='font-size:12px;padding:3px;'>".$description."</td>
		<td style='font-size:12px;padding:3px;'>".$sub_value."</td>
		<td style='font-size:12px;padding:3px;'>".$ref_value."</td>
		<td style='font-size:12px;padding:3px;' align='right'>".$costdata."</td></tr>";
		$i++;
		$breakDownCnt++;

	}

	 $despData=getchangeordertaxData($database,$change_order_id);
	 if($despData)
	 {
		$j='1';
	 	foreach ($despData as $key => $value) {
			$costcode_tax_id = $value['cost_code'];
			$taxCode = CostCode::findById($database, $costcode_tax_id);
			if(!empty($taxCode))
			{
				$htmlEntityEscapedFormattedTaxCode = $taxCode->getHtmlEntityEscapedFormattedCostCodeApi($database,$user_company_id);
			}else
			{
				$htmlEntityEscapedFormattedTaxCode = "&nbsp;";
			}
			$costdata = Format::formatCurrency($value['cost']);
	 		$contentData= html_entity_decode($value['content'], ENT_QUOTES, "UTF-8");
	 		$contentData =str_replace('&comma;', ',', $contentData);
	 		$contentData =str_replace("&apos;", "'", $contentData);
	 		$contentData = ($contentData =="")?'&nbsp;':$contentData;
	 		$breakDown[$breakDownCnt]['costcode'] = $htmlEntityEscapedFormattedTaxCode;
			$breakDown[$breakDownCnt]['cost'] = $costdata;
			 $cost_item .="<tr><td style='font-size:12px;padding:3px;' align='center'>$j</td>
			 <td style='font-size:12px;padding:3px;'>".$htmlEntityEscapedFormattedTaxCode."</td>
			 <td style='font-size:12px;padding:3px;'>".$contentData."</td>
	 	<td colspan='2' style='font-size:12px;padding:3px;' align='center'>".$value['percentage']." % </td>
		<td align='right' style='font-size:12px;padding:3px;'>".$costdata."</td>
		 </tr>";
		 $j++;
		 $breakDownCnt++;
	 	}
	 }
	
	
	if($co_delay_days == NULL)
	{
		$delayDays="To Be Determined";
	}
	else if($co_delay_days =="0")
	{
		$delayDays=$co_delay_days." day";
	}
	else
	{
		$delayDays=$co_delay_days." day(s)";
	}

	
	$ref_doc=getchangeOrderAttachmentData($database,$change_order_id);
	
	$total=$changeOrder->co_total;
	$co_total =Format::formatCurrency($changeOrder->co_total);
	if($total<0)
	{
		$coAmt="(".$co_total.")";
	}else
	{
		$coAmt=$co_total;

	}

	if ($co_created != "0000-00-00 00:00:00") {
		$dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $co_created);
		$co_created_date = $dateObj->format('m/d/Y');
		$curdate = $dateObj->format("F d, Y ");
	}else{
		$co_created_date = '';
		$curdate = '';
	}
	

	if($co_COR_created !="0000-00-00")
	{
		$dateObj1 = DateTime::createFromFormat('Y-m-d', $co_COR_created);
		$co_COR_created = $dateObj1->format('m/d/Y');
	}



	if($change_order_type_id=="2")
	{
		$sequence_data=$co_type_prefix;
		$co_created_date =  $co_COR_created;
		$curdate = $dateObj1->format("F d, Y ");
	}

	// HTML Entity Escaped Data
	$changeOrder->htmlEntityEscapeProperties();
	$escaped_co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
	$escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
	$escaped_co_statement = $changeOrder->escaped_co_statement;
	$escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
	$escaped_co_title = $changeOrder->escaped_co_title;

	$descData="";
	if($escaped_co_statement != ""){
		$descData="<div class='headsty'><b>DESCRIPTION:</b></div>
		<div style='padding: 0 15px;'>
		<p>
		$escaped_co_statement_nl2br
		</p>
		</div>
		<br>";
	}
	$co_scheduled_value = Format::formatCurrency($co_scheduled_value);

	if (empty($co_closed_date)) {
		$co_closed_date = '&nbsp;';
	}

	$coCreationTimestampInt = strtotime($co_created);
	$coCreationTimestampDisplayString = date('n/j/Y', $coCreationTimestampInt);

	if (isset($co_revised_project_completion_date) && !empty($co_revised_project_completion_date)) {
		$coRevisedProjectCompletionTimestampInt = strtotime($co_revised_project_completion_date);
		$coRevisedProjectCompletionTimestampDisplayString = date('n/j/Y', $coRevisedProjectCompletionTimestampInt);

		$coRevisedProjectCompletionHtml = <<<END_HTML_CONTENT
				<td nowrap class="textAlignRight">REVISED PROJECT COMPLETION DATE:</td>
				<td>$coRevisedProjectCompletionTimestampDisplayString</td>
END_HTML_CONTENT;

	} else {
		$coRevisedProjectCompletionHtml = '<td></td><td></td>';
	}

	$project = $changeOrder->getProject();
	/* @var $project Project */
	$project->htmlEntityEscapeProperties();
	$escaped_project_name = $project->escaped_project_name;

	$changeOrderType = $changeOrder->getChangeOrderType();
	/* @var $changeOrderType ChangeOrderType */
	$change_order_type = $changeOrderType->change_order_type;

	$changeOrderStatus = $changeOrder->getChangeOrderStatus();
	/* @var $changeOrderStatus ChangeOrderStatus */
	$change_order_status = $changeOrderStatus->change_order_status;

	$changeOrderPriority = $changeOrder->getChangeOrderPriority();
	/* @var $changeOrderPriority ChangeOrderPriority */

	if ($changeOrderPriority) {
		$change_order_priority = $changeOrderPriority->change_order_priority;
	} else {
		$change_order_priority = '';
	}

	$coFileManagerFile = $changeOrder->getCoFileManagerFile();
	/* @var $coFileManagerFile FileManagerFile */

	$coCostCode = $changeOrder->getCoCostCode();
	/* @var $coCostCode CostCode */

	if ($coCostCode) {
		// Extra: Change Order Cost Code - Cost Code Division
		$coCostCodeDivision = $coCostCode->getCostCodeDivision();
		/* @var $coCostCodeDivision CostCodeDivision */

		$formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false);


		$coFormattedCostCodeHtml = <<<END_HTML_CONTENT
			<tr>
				<td class="textAlignRight">COST CODE:</td>
				<td>$formattedCoCostCode</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
END_HTML_CONTENT;

	} else {
		$coFormattedCostCodeHtml = '';
	}


	$cocreator=Contact::loadAllcontactDatabycontactId($database,$co_signator_contact_id); 

	$fromName = Contact::findById($database, $co_signator_contact_id);
	$fromFullName = ($fromName == '') ? '' : $fromName->getContactFullName();
	$fromCompany = ContactCompany::findByContactUserCompanyId($database, $cocreator['contact_company_id']);
	$fromAddress = Project::getContactCompanyAddress($database, $cocreator['contact_company_id']);

	if($cocreator['first_name']!="" && $cocreator['last_name']!="")
	{
		$coCreatorContactFullNameHtmlEscaped=$cocreator['first_name'].' '.$cocreator['last_name'];
	$coCreatorContactFullNameHtmlEscaped =ucfirst($coCreatorContactFullNameHtmlEscaped);
}else{
	$coCreatorContactFullNameHtmlEscaped = $cocreator['email'];
}

		
	
	$coCreatorContactCompanyNameHtmlEscaped = $cocreator['company'];

	$co_create_title= $cocreator['title'];
	if($co_create_title=="")
	{
		$co_create_title="&nbsp;";
	}
	$coCreatorContactCompanyOffice = ContactCompanyOffice::loadContactCompanyOfficeHeadquartersByContactCompanyId($database, $cocreator['contact_company_id']);

	if ($coCreatorContactCompanyOffice) {
		$twoLines = true;
		$coCreatorContactCompanyOfficeAddressHtmlEscaped = $coCreatorContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$coCreatorContactCompanyOfficeAddressHtmlEscaped = '';
	}

		// Attempt to load "live" data
	$coRecipient=Contact::loadAllcontactDatabycontactId($database,$co_recipient_contact_id);
	
	// $coRecipientContact = $changeOrder->getCoRecipientContact();
	$co_rep_title= $coRecipient['title'];
	if($co_rep_title=="")
	{
		$co_rep_title="&nbsp;";
	}
	if($coRecipient['first_name']!="" && $coRecipient['last_name']!="")
	{
		$coRecipientContactFullNameHtmlEscaped =$coRecipient['first_name'].' '.$coRecipient['last_name'];
	$coRecipientContactFullNameHtmlEscaped=ucfirst($coRecipientContactFullNameHtmlEscaped);
}else{
	$coRecipientContactFullNameHtmlEscaped = $coRecipient['email'];
}
	$coRecipientContactCompanyNameHtmlEscaped =Project::getProjectOwner($database,$co_project_id);
	if($coRecipientContactCompanyNameHtmlEscaped!='')
	{
	$coRecipientContactCompanyNameHtmlEscaped=$coRecipientContactCompanyNameHtmlEscaped;
	}else
	{
		$coRecipientContactCompanyNameHtmlEscaped='';
	}
	$ownerName = $coRecipientContactCompanyNameHtmlEscaped;
	//To get contact adress
	$coRecipientcontactCompanyid=Contact::getcontactcompanyAddreess($database,$co_recipient_contact_id);
	
	$coRecipientContactCompanyOffice = ContactCompanyOffice::loadCompanyForContact($database, $coRecipientcontactCompanyid);
	
	if ($coRecipientContactCompanyOffice) {
		$twoLines = true;
		$coRecipientContactCompanyOfficeAddressHtmlEscaped = $coRecipientContactCompanyOffice->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$coRecipientContactCompanyOfficeAddressHtmlEscaped = '';
	}

	$loadChangeOrderResponsesByChangeOrderIdOptions = new Input();
	$loadChangeOrderResponsesByChangeOrderIdOptions->forceLoadFlag = true;
	$arrChangeOrderResponsesByChangeOrderId = ChangeOrderResponse::loadChangeOrderResponsesByChangeOrderId($database, $change_order_id, $loadChangeOrderResponsesByChangeOrderIdOptions);
	$tableCoResponses = '';
	foreach ($arrChangeOrderResponsesByChangeOrderId as $change_order_response_id => $changeOrderResponse ) {
		/* @var $changeOrderResponse ChangeOrderResponse */

		$changeOrderResponse->htmlEntityEscapeProperties();

		$change_order_response_sequence_number = $changeOrderResponse->change_order_response_sequence_number;
		$change_order_response_type_id = $changeOrderResponse->change_order_response_type_id;
		$co_responder_contact_id = $changeOrderResponse->co_responder_contact_id;
		$co_responder_contact_company_office_id = $changeOrderResponse->co_responder_contact_company_office_id;
		$co_responder_phone_contact_company_office_phone_number_id = $changeOrderResponse->co_responder_phone_contact_company_office_phone_number_id;
		$co_responder_fax_contact_company_office_phone_number_id = $changeOrderResponse->co_responder_fax_contact_company_office_phone_number_id;
		$co_responder_contact_mobile_phone_number_id = $changeOrderResponse->co_responder_contact_mobile_phone_number_id;
		$change_order_response_title = $changeOrderResponse->change_order_response_title;
		$change_order_response = $changeOrderResponse->change_order_response;
		$change_order_response_modified_timestamp = $changeOrderResponse->modified;
		$change_order_response_created_timestamp = $changeOrderResponse->created;

		$escaped_change_order_response_title = $changeOrderResponse->escaped_change_order_response_title;
		$escaped_change_order_response_nl2br = $changeOrderResponse->escaped_change_order_response_nl2br;

		$coResponseCreatedTimestampInt = strtotime($change_order_response_created_timestamp);
		$coResponseCreatedTimestampDisplayString = date('n/j/Y g:ia', $coResponseCreatedTimestampInt);

		$coResponderContact = $changeOrderResponse->getCoResponderContact();
		/* @var $coResponderContact Contact */

		$coResponderContact->htmlEntityEscapeProperties();

		$coResponderContactFullNameHtmlEscaped = $coResponderContact->getContactFullNameHtmlEscaped();
		$co_responder_contact_escaped_title = $coResponderContact->escaped_title;

		$responseHeaderInfo = "Answered $coResponseCreatedTimestampDisplayString by $coResponderContactFullNameHtmlEscaped ($co_responder_contact_escaped_title)";

		// #d1d1d1
		// #bbb
		$tableCoResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="CO_table2_content">
				$responseHeaderInfo
				<div style="border: 1px solid #d1d1d1; font-size: 13px;">$escaped_change_order_response_nl2br</div>
				<br>
			</td>
		</tr>
END_HTML_CONTENT;

	}
	if ($tableCoResponses == '') {

		$tableCoResponses .= <<<END_HTML_CONTENT

		<tr>
			<td colspan="2" class="CO_table2_content">No notes.</td>
		</tr>
END_HTML_CONTENT;

	}

	$totalOriginalPSCV = GcBudgetLineItem::getTotalOriginalPSCV($database,$co_project_id);
	$totOriPSCVFormatted = Format::formatCurrency($totalOriginalPSCV);

	$order_type_id = 2;
	$statusIds = array(2);
	$approvedCORData = changeOrderTypeTotalAndDelay($database ,$co_project_id, $order_type_id, $statusIds);
	$approvedCORTotalAmt = $approvedCORData['totalAmt'];
	$approvedCORTotalAmtFormatted = Format::formatCurrency($approvedCORTotalAmt);

	$contractPriorToCC = $totalOriginalPSCV + $approvedCORTotalAmt;
	$contractPriorToCCFormatted = Format::formatCurrency($contractPriorToCC);

	$newContractAmt = $total + $totalOriginalPSCV + $approvedCORTotalAmt;
	$newContractAmtFormatted = Format::formatCurrency($newContractAmt);

	$uri = Zend_Registry::get('uri');
	/*GC logo*/
	require_once('lib/common/Logo.php');
	// $gcLogo = Logo::logoByUserCompanyIDUsingSoftlinkWidthCustome($database,$user_company_id, true);logoByUserCompanyIDUsingBasePath
	$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$user_company_id, true);
	$fulcrum = Logo::logoByFulcrumByBasePath(true);
	$headerLogo=<<<headerLogo
	<table width="100%" class="table-header">
 	<tr>
 	<td>$gcLogo</td>
 	<td align="right"><span style="margin-top:10px;"></span></td>
 	</tr>
 	</table>
headerLogo;
 	// <td align="right"><span style="margin-top:10px;">$fulcrum</span></td>

$data=ContactCompany::GenerateFooterData($user_company_id,$database);
$address=$data['address'];
$number=$data['number'];
$footer_cont=$address.' '.$number;

$footerData="<div class='footer'><table width='100%''><tr><td align='left' style='font-size:8px;width:33.33%'></td><td align='center' style='font-size:8px;width:33.33%'>$footer_cont</td><td align='right' style='width:33.33%'><span class='customm--logo' style='margin-top:10px;width:50px;text-align:right;' >$fulcrum</span></td></tr></table></div>";
	/*GC logo end*/


	$htmlContent = '';
$changeOrder_template_path =UserCompanyFileTemplate::getUserTemplatePath($database,$user_company_id,'Change Order');
ob_start();
require_once($changeOrder_template_path);
$htmlContent .= ob_get_clean();

if($jobsitePhotoHtmlContent!='')
{
	$htmlContent .= <<<END_HTML_CONTENT
	<div style="page-break-after: always;">
	</div>
	$jobsitePhotoHtmlContent
END_HTML_CONTENT;
}

		$htmlContent .= <<<END_HTML_CONTENT

</body>
</html>

END_HTML_CONTENT;

	return $htmlContent;


}

//To get the attachments
	function AttachmentforSuborder($database,$subid)
	{
		$db = DBI::getInstance($database);
		$attachmentQuery = "SELECT s.attachment_file_manager_file_id, f.virtual_file_name FROM file_manager_files as  f JOIN subcontract_change_order_attachments s  ON f.id = s.attachment_file_manager_file_id  WHERE s.suborder_id='$subid'";
		$db->query($attachmentQuery);
		$attachmentRecords = array();
		while($attachmentRow = $db->fetch())
		{
			$attachmentRecords[] = $attachmentRow;
		}
		
		$attachmentHtml = "";
		foreach($attachmentRecords as $attachmentRecord){
			$attachmentId = $attachmentRecord['attachment_file_manager_file_id'];
			$attachmentName = $attachmentRecord['virtual_file_name'];
			$value = $attachmentId;
			$FileManagerFile = FileManagerFile::findById($db, $attachmentId);
			$attachmentId = $FileManagerFile->generateUrl();
			$attachmentHtml .= '<li id="record_container--manage-file_manager_file-record--file_manager_files--'.$attachmentId.'" class="uploadedfile cost_div">
			<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">
			<a target="_blank" href="'.$attachmentId.'">'.$attachmentName.'</a></li>';
		}
		return $attachmentHtml;
	}
	//to get the subcontract change order data
	function SuborderDataForchangeOrder($database,$subid,$colname)
	{
		$db = DBI::getInstance($database);
		$Query = "SELECT $colname FROM subcontract_change_order_data   WHERE id='$subid'";
		$db->query($Query);
		$row = $db->fetch();
		$resultdata = $row[$colname];
		return $resultdata;
	}
	//To insert the cost breakdown data for the change orders
	function InsertCOcontent_template($database,$COid,$content,$project_id,$taxcode){
		$db = DBI::getInstance($database);
		$que1= "DELETE FROM `change_order_content_template` WHERE `project_id`=$project_id";
		$db->query($que1);
		$db->free_result();

		$content_data    =  explode(',', $content);
		$taxcode_data  =  explode(',', $taxcode);
		/*for change_order_content_template */
		foreach ($content_data as $key2 => $contvalue) {
			$que1= "INSERT into change_order_content_template (`project_id`, `description`,`cost_code`) VALUES ($project_id,'$contvalue','$taxcode_data[$key2]')";
			$db->query($que1);
			$db->free_result();
		}
		/*END of change_order_content_template */
	}

	//To insert the cost breakdown data for the change orders
	function InsertCOCostBreakDown($database,$COid,$description,$subdata,$Reference,$cost,$content,$percentage,$contotal, $costcode,$taxcode){

		$db = DBI::getInstance($database);
		/*for change_order_cost_break */
		$costcode_data  =  explode(',', $costcode);
		$description_data  =  explode(',', $description);
		$subdata_data      =  explode(',', $subdata);
		$Reference_data    =  explode(',', $Reference);

		$cost_data=explode(',', $cost);
		$costCount=count($cost_data);
		foreach ($cost_data as $key => $costvalue) {
			$que= "INSERT into change_order_cost_break (`change_order_id`, `cost_code_reference_id`, `description`, `Sub`, `reference`, `cost`) VALUES ($COid, $costcode_data[$key],'$description_data[$key]','$subdata_data[$key]','$Reference_data[$key]','$costvalue')";
			$db->query($que);
			$db->free_result();
		}
		/*END of change_order_cost_break */

		/*for change_order_cost_break */
		$content_data  =  explode(',', $content);
		$percentage_data      =  explode(',', $percentage);
		$contotal_data    =  explode(',', $contotal);
		$taxcode_data  =  explode(',', $taxcode);
		foreach ($contotal_data as $key1 => $totvalue) {
			$que1= "INSERT into change_order_tax_break (`change_order_id`, `content`, `percentage`,`cost`,`cost_code`) VALUES ($COid,'$content_data[$key1]','$percentage_data[$key1]','$totvalue','$taxcode_data[$key1]')";
			$que2= "INSERT into change_order_cost_break (`change_order_id`, `cost_code_reference_id`,`description`, `cost_code_flag`, `cost`) VALUES ($COid,'$taxcode_data[$key1]','$content_data[$key1]','2','$totvalue')";
			$db->query($que1);
			$db->query($que2);
			$db->free_result();
		}
		/*END of change_order_cost_break */


	}
	//To delete the cost breakdown Data
	function DeleteCOCostBreakDown($database,$COid){

		$db = DBI::getInstance($database);

		$que= "DELETE FROM `change_order_cost_break` WHERE `change_order_id`=$COid";
		$db->query($que);
		$db->free_result();

		$que1= "DELETE FROM `change_order_tax_break` WHERE `change_order_id`=$COid";
		$db->query($que1);
		$db->free_result();
		return 1;
		

	}

	function findNextChangeOrderPrefix($database,$project_id)
	{
		$next_CO_prefix ='COR-001';
		//SCO-001
       
        $db = DBI::getInstance($database);
        /* @var $db DBI_mysqli */
      
        $query ="SELECT  max(CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED)) as co_type_prefix  FROM `change_orders` WHERE `project_id` = ? ";
        $arrValues = array($project_id);
        
        $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
        $row1 = $db->fetch();
        if ($row1) {
        
        $max_approve_prefix = $row1['co_type_prefix'];
        $new_next = $max_approve_prefix + 1;
        $new_next=str_pad($new_next, 3,'0', STR_PAD_LEFT); 
        $next_CO_prefix = "COR-".$new_next;

        }
        $db->free_result();
        
        return $next_CO_prefix;
	}

	function updateChangeOrderTypePrefix($database,$change_order_id,$project_id,$coType){

		$db = DBI::getInstance($database);
		if($coType=='2')
		{

			$type_approve=findNextChangeOrderPrefix($database,$project_id);
		}else
		{
			$type_approve="";
		}
		
        /* @var $db DBI_mysqli */
      
        $query ="UPDATE  `change_orders` SET `co_type_prefix` = '$type_approve' WHERE `id` = ? ";
        $arrValues = array($change_order_id);
        $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
        $db->free_result();
    	
	}
	function getCOTemplateData($database,$project_id)
	{
		
		$db = DBI::getInstance($database);
		 $Query = "SELECT * FROM change_order_content_template   WHERE project_id='$project_id'";
		$db->query($Query);
		$resultdata=array();
		while($row = $db->fetch())
		{
			$resultdata[] = $row;
		}
		
		return $resultdata;
	}
	function getchangeordertaxData($database,$change_order_id)
	{
		
		$db = DBI::getInstance($database);
		 $Query = "SELECT * FROM change_order_tax_break   WHERE change_order_id='$change_order_id'";
		$db->query($Query);
		$resultdata=array();
		while($row = $db->fetch())
		{
			$resultdata[] = $row;
		}
		$db->free_result();
		return $resultdata;
	}


	function getchangeordercostbreakdownData($database,$change_order_id)
	{
		
		$db = DBI::getInstance($database);
		 $Query = "SELECT * FROM change_order_cost_break   WHERE change_order_id='$change_order_id' AND cost_code_flag='1'";
		$db->query($Query);
		$resultdata=array();
		while($row = $db->fetch())
		{
			$resultdata[] = $row;
		}
		$db->free_result();
		return $resultdata;
	}

	function getchangeOrderAttachmentData($database,$change_order_id)
	{
		$db = DBI::getInstance($database);
		$query = "SELECT GROUP_CONCAT(ff.virtual_file_name,' ') as file_name FROM `change_order_attachments` as co inner join file_manager_files as ff on co.co_attachment_file_manager_file_id =ff.id  WHERE `change_order_id` = '$change_order_id' ";
		$db->execute($query);

		$row = $db->fetch();
		$db->free_result();
		if($row){
			$file_name = $row['file_name'];
		} else {
			$file_name = "";
		}
		return $file_name;
	}

	function DeleteFileManagerRecordforCo($database,$sequence,$project_id,$type){
		 //to get the  file_manager_folders id
        $db = DBI::getInstance($database);
    	$search = "%Change Orders/".$type."/Change Order #".$sequence."%";
      	$query1 ="SELECT * FROM `file_manager_folders` fmf WHERE fmf.`project_id` = $project_id AND fmf.`virtual_file_path` like '$search' " ;
        $db->execute($query1);
        $row1 = $db->fetch();
      	$folder_id=$row1['id'];
        $db->free_result();

        //to delete the  file_manager_file record
        $db = DBI::getInstance($database);
        $query2 ="DELETE  FROM `file_manager_files`  WHERE `file_manager_folder_id` = $folder_id " ;
        $db->execute($query2);
        $db->free_result();

        //to delete the  file_manager_folders record
        $query3 ="DELETE  FROM `file_manager_folders`  WHERE `id` = $folder_id " ;
        $db->execute($query3);
        $db->free_result();
	}

	function changeOrderTypeTotalAndDelay($database,$project_id, $change_order_type_id, $statusIds){
    $db = DBI::getInstance($database);
		if($statusIds){
	    $change_order_status_id = implode(',',$statusIds);
			$whereStatusIn = "and change_order_status_id IN(".$change_order_status_id.")";
	  }else{
	    $whereStatusIn = '';
	  }
  	$query1 ="
		SELECT  count(*) as count,change_order_type_id,sum(co_total) as total,sum(co_delay_days) as days FROM `change_orders`
		 WHERE `project_id` = $project_id and `change_order_type_id` =$change_order_type_id $whereStatusIn group by change_order_type_id  " ;
    $db->execute($query1);
    $row1 = $db->fetch();
  	$change_order_type_id=$row1['change_order_type_id'];
		$totalQuery ="
    SELECT sum(co_total) as total FROM `change_orders`
    WHERE `project_id` = $project_id and `change_order_type_id` =$change_order_type_id
    $whereStatusIn group by change_order_type_id";
    $db->execute($totalQuery);
    $totalRow = $db->fetch();
    $total = $totalRow['total']; //$row1['total'];
    $totalAmt = $total;
  	$days = $row1['days'];
  	$count = $row1['count'];
  	$total = Format::formatCurrency($total);
    $db->free_result();
    $COData = array("count"=> $count,"days"=> $days,"total" =>$total,"type_id"=> $change_order_type_id,"totalAmt"=>$totalAmt);

        return $COData;
	}
