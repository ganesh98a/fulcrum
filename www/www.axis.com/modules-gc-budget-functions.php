<?php
require_once('lib/common/ChangeOrder.php');
require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/DrawItems.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/JobsiteManPower.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/Log.php');
require_once('lib/common/MobileNetworkCarrier.php');
require_once('lib/common/MobilePhoneNumber.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/SubcontractDocument.php');
require_once('lib/common/SubcontractItemTemplate.php');
require_once('lib/common/SubcontractorBid.php');
require_once('lib/common/SubcontractorBidStatus.php');
require_once('lib/common/SubcontractTemplate.php');
require_once('lib/common/SubcontractTemplateToSubcontractItemTemplate.php');
require_once('lib/common/SubcontractType.php');
require_once('lib/common/UserCompanyFileTemplate.php');
require_once('lib/common/Vendor.php');
require_once('lib/common/UserCompany.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('include/page-components/fileUploader.php');

require_once('./modules-contacts-manager-functions.php');
require_once('./modules-purchasing-functions.php');

require_once('subcontract-change-order-functions.php'); 
require_once('lib/common/Project.php');
require_once('lib/common/CostCodeDivider.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
require_once('app/models/accounting_model.php');
require_once('lib/common/Date.php');


function renderGcBudgetForm($database, $user_company_id, $currentlyActiveContactId, $project_id, $companyName, $projectName, $cost_code_division_id_filter=null)
{
	$currentlySelectedUserCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
	/* @var $userCompany UserCompany */
	$currentlySelectedUserCompanyName = $currentlySelectedUserCompany->user_company_name;
	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$debugMode = $session->getDebugMode();

	$project = Project::findProjectByIdExtended($database, $project_id);
	$is_subtotal = (int) $project->is_subtotal;
	/* @var $project Project */
	$order_by_attribute = '-1';
	$order_by_direction = 'ASC';
	$scheduledValuesOnly = false;
	$needsBuyOutOnly = false;
	$needsSubValue = false;
	$order_by_attribute = '';
	$minusValueOption = '';
	$costCodeOption = '';
	$costCodeDescriOption = '';
	$primeContractScheduledValueOption = '';
	$forecastedExpensesOption = '';
	if(isset($_GET['order_by_attribute'])){
		$order_by_attribute = $_GET['order_by_attribute'];
		if($order_by_attribute == '-1'){
			$order_by_attribute = null;
		}
		$minusValueOption = selectedData($order_by_attribute,'-1');
		$costCodeOption = selectedData($order_by_attribute,'cost_code');
		$costCodeDescriOption = selectedData($order_by_attribute,'cost_code_description');
		$primeContractScheduledValueOption = selectedData($order_by_attribute,'prime_contract_scheduled_value');
		$forecastedExpensesOption = selectedData($order_by_attribute,'forecasted_expenses');
	}
	$ASCOption = '';
	$DESCOption = '';
	if(isset($_GET['order_by_direction'])){
		$order_by_direction = $_GET['order_by_direction'];
		$ASCOption = selectedData($order_by_direction, 'ASC');
		$DESCOption = selectedData($order_by_direction, 'DESC');
	}
	if(isset($_GET['scheduledValuesOnly'])){
		$scheduledValuesOnly = filter_var($_GET['scheduledValuesOnly'], FILTER_VALIDATE_BOOLEAN);
	}
	if(isset($_GET['needsBuyOutOnly'])){
		$needsBuyOutOnly = filter_var($_GET['needsBuyOutOnly'], FILTER_VALIDATE_BOOLEAN);
	}
	if(isset($_GET['needsSubValue'])){
	    $needsSubValue = filter_var($_GET['needsSubValue'], FILTER_VALIDATE_BOOLEAN);
	}		
	$scheduledValuesOnlyOption = '';
	if($scheduledValuesOnly){
		$scheduledValuesOnlyOption = 'checked="checked"';
	}
	$needsBuyOutOnlyOption = '';
	if($needsBuyOutOnly){
		$needsBuyOutOnlyOption = 'checked="checked"';
	}
	$needsSubValueOption = '';
	if($needsSubValue){
		$needsSubValueOption = 'checked="checked"';
	}
	
	$project->htmlEntityEscapeProperties();
	$escaped_project_name = $project->escaped_project_name;

	$loadGcBudgetLineItemsByProjectIdOptions = new Input();
	$loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
	$loadGcBudgetLineItemsByProjectIdOptions->arrOrderByAttributes = array(
		'gbli_fk_codes__fk_ccd.`division_number`' => 'ASC',
		'gbli_fk_codes.`cost_code`' => 'ASC'
	);
	
	$gcBudgetForm = '';

	// project_bid_invitations - PDF Urls
	$arrReturn = renderProjectBidInvitationFilesAsUrlList($database, $project_id);
	$projectBidInvitationFilesCount = $arrReturn['file_count'];
	$projectBidInvitationFilesAsUrlList = $arrReturn['html'];

	if ($debugMode) {
		$htmlTdCellOffset = 5;
		$debugHeadline =
'
			<th>GBLI<br>ID</th>
			<th>CCD<br>ID</th>
			<th>CODE<br>ID</th>
';
	} else {
		$htmlTdCellOffset = 0;
		$debugHeadline = '';
	}



	// Configure the project_bid_invitation file uploader.
	$virtual_file_path = '/Bidding & Purchasing/Project Bid Invitations/';
	$projectBidInvitationsFileManagerFolder =
		FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
	/* @var $projectBidInvitationsFileManagerFolder FileManagerFolder */
	$project_bid_invitation_file_manager_folder_id = $projectBidInvitationsFileManagerFolder->file_manager_folder_id;

	$input = new Input();
	$input->id = "budgetFileUploader_projectBidInvitations_{$project_id}";
	$input->folder_id = $project_bid_invitation_file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = $virtual_file_path;
	$input->virtual_file_name = '';
	$input->action = '/modules-purchasing-file-uploader-ajax.php';
	$input->method = 'projectBidInvitations';
	$input->allowed_extensions = 'pdf';
	$input->append_date_to_filename = 1;
	$input->custom_label = 'Drop/Click';
	$input->style = 'vertical-align: middle;';

	$projectBidInvitationsFileUploader = buildFileUploader($input);

	// Table sort/filter section copied from Purchasing.
	$arrCostCodeDivisionsByUserCompanyIdAndProjectId = CostCodeDivision::loadCostCodeDivisionsByUserCompanyIdAndProjectId($database, $user_company_id, $project_id);

	$costCodeDivisionOptions = '';
	foreach ($arrCostCodeDivisionsByUserCompanyIdAndProjectId AS $cost_code_division_id => $costCodeDivision) {
		/* @var $costCodeDivision CostCodeDivision*/

		$costCodeDivision->htmlEntityEscapeProperties();

		$escaped_division_number = $costCodeDivision->escaped_division_number;
		$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
		$escaped_division = $costCodeDivision->escaped_division;
		$divisionHeadline = "$escaped_division_number $escaped_division";
		

		$costCodeDivisionOptions .= <<<END_HTML_CONTENT

									<option value="$cost_code_division_id">$divisionHeadline</option>
END_HTML_CONTENT;

	}
	$scheduledValuesoption= '';
	if(!empty($_SESSION['scheduledValuesOnly'])){
		$scheduledValuesoption=$_SESSION['scheduledValuesOnly'];
	}
	

	$userCanimportcostcodeInbudget = checkPermissionForAllModuleAndRole($database,'gc_budgets_import_line_items');
	$userCanManagebudget = checkPermissionForAllModuleAndRole($database,'gc_budgets_manage');
 	$session = Zend_Registry::get('session');
	$userRole = $session->getUserRole();
	$bidlabel ="";
	if($userCanimportcostcodeInbudget || $userRole =="global_admin")
	{
	$importcostFilters = <<<IMP_COST_TABLE_FILTERS
	<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="loadImportCostCodesIntoBudgetDialog(); return false;">Import Cost Codes Into Current Budget</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="loadManageGcCostCodesDialog(); return false;">Manage Master Cost Code Lists</a></li>
IMP_COST_TABLE_FILTERS;
		$importmastercostFilters = <<<IMP_MASTER_COST_TABLE_FILTERS
<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="loadImportCostCodesFromExcel(); return false;">Import New Cost Codes Into Master List</a></li>
IMP_MASTER_COST_TABLE_FILTERS;

}
	//Manage 
	if($userCanManagebudget || $userRole =="global_admin")
	{
$managecostFilters = <<<MANAGE_COST_TABLE_FILTERS
	<span class="dropdown">
		<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" style="padding: 5px 2px; background: #fff; border: 1px solid #bbb; border-radius: 3px;">
			What are you going to do ?
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			$importcostFilters
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="showImportBidders(); return false;">Import Bidders</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="showRequestBudgetNumbersFromAllBidders(); return false;">Request Budget Numbers from One or More Potentials</a></li>
			<!-- <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="showInviteAllBidders('Add your comments to the bid invitation email . . .'); return false;">Invite One or More Potential Bidders to Bid</a></li> -->
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="showUploadByCompany(); return false;">Upload Files By Company</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="/modules-purchasing-bidder-list-report.php" target="_blank">Bid List Report</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="renderSimpleEmailBiddersModalDialog(); return false;">Send Bid Invite</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="BiddersModalDialog(); return false;">Email Bidders</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="EmailProjectContactsModalDialog(); return false;">Email Project Contacts</a></li>
			$importmastercostFilters
			</ul>
	</span>
MANAGE_COST_TABLE_FILTERS;
		$bidlabel="Actions:";
		}
		

	

$userCanManagebudget = checkPermissionForAllModuleAndRole($database,'gc_budgets_manage');
$session = Zend_Registry::get('session');
$userRole = $session->getUserRole();

$gcBudgetmanage="";
if($userCanManagebudget || $userRole =="global_admin")
{
$gcBudgetmanage = <<<MANAGE_END_FORM

	<a href="javascript:loadPermissionModal('11_Y', '$project_id');" style="margin-right:20px;">Budget Permissions</a>
	<a href="javascript:loadPermissionModal('15_Y', '$project_id');" >Purchasing Permissions</a>
MANAGE_END_FORM;
}
$scheduledValue = $needsBuyValue = '';
if(!empty($_GET['scheduledValuesOnly'])){
	$scheduledValue = $_GET['scheduledValuesOnly'];
}
if(!empty($_GET['needsBuyOutOnly'])){
	$needsBuyValue = $_GET['needsBuyOutOnly'];	
}
if(!empty($_GET['needsSubValue'])){
	$needsSubValue = $_GET['needsSubValue'];	
}

$isAllDcrCount = GcBudgetLineItem::countAllIsDcrFlag($database, $project_id);
if ($isAllDcrCount == 0) {
	$isAllDcrFlag = 'checked=true';
}else{
	$isAllDcrFlag = '';
}

if (($scheduledValue == "false" && $needsBuyValue == "false") || ($scheduledValue == '' && $needsBuyValue == '')) {
$selctAllDcrTrue = <<<MANAGE_END_FORM
	<th style="text-align: center;">DCR<br>
		<span id="entypo-edit-icon-dcr" style="width: 40px;display:block;">
			<input type="checkbox" id="attach_all_copy_text" class="dcr-text" $isAllDcrFlag disabled style="float: left;margin-right: 10px;margin-top: 5px;margin-bottom: 5px;">
			<img src="images/edit-icon.png"  data-toggle="tooltip" title="Edit" class="entypo-click" onclick="allowToUserEditPrimeDcr(true);" style="float: left;margin-top: 2px;"></img>
		</span>
		<span id="entypo-lock-icon-dcr" style="width: 40px;display:none;">
			<input type="checkbox" id="attach_all_copy_lock" onclick="updateAllIsDcrFlag('$project_id')" class="bs-tooltip" data-original-title="Check/Uncheck will affect subcontractors in the cost code from being listed in the Daily Log Manpower list." $isAllDcrFlag style="float: left;margin-right: 3px;margin-top: 5px;margin-bottom: 5px;">						
			<span class="entypo-lock" data-toggle="tooltip" title="Lock"  class="entypo-click" onclick="allowToUserEditPrimeDcr(false);" style="float: left;margin-top: 2px;"></span>
		</span>
	</th>	
MANAGE_END_FORM;
}else{
$selctAllDcrTrue = <<<MANAGE_END_FORM
	<th style="text-align: center;">DCR<br>
		<span id="entypo-edit-icon-dcr" style="width: 40px;display:block;">
			<img src="images/edit-icon.png"  data-toggle="tooltip" title="Edit" class="entypo-click" onclick="allowToUserEditPrimeDcr(true);" style="margin-top: 2px;"></img>
		</span>
		<span id="entypo-lock-icon-dcr" style="width: 40px;display:none;">
			<span class="entypo-lock" data-toggle="tooltip" title="Lock"  class="entypo-click" onclick="allowToUserEditPrimeDcr(false);" style="margin-top: 2px;"></span>
		</span>
	</th>	
MANAGE_END_FORM;
}
$aboveorbelw = Project::CORAboveOrBelow($database,$project_id);
$OCOform ="";
if($aboveorbelw == "2")
{
	$OCOform = <<<OCOform
	<th>Owner Change<br> Order</th>
OCOform;
}
$subtotal_chk = '';
if($is_subtotal == '1') {
	$subtotal_chk = 'checked';
}

$gcBudgetForm = <<<END_FORM

	<div id="gcBudgetLineItemsFormContainer">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 15px;">
			<tr>
				<th align="left" nowrap >$bidlabel</th>
				<th align="left" nowrap >Filter By:</th>
				<th colspan="3" ></th>
			</tr>
			<tr>
				<td nowrap style="width: 15%;">
					$managecostFilters
				</td>
				<td nowrap style="width: 14%;">
					<input type="hidden" id="order_by_attribute" value="-1">
					<input type="hidden" id="order_by_direction" value="ASC">
					<input id="scheduledValuesOnly" type="checkbox" $scheduledValuesoption $scheduledValuesOnlyOption onchange="filterGcBudgetLineItems();">
					<label for="scheduledValuesOnly" style="float:none">Scheduled Values Only?</label>
					<br>
					<input id="needsBuyOutOnly" $needsBuyOutOnlyOption type="checkbox" onchange="filterGcBudgetLineItems();">
					<label for="needsBuyOutOnly" style="float:none">Needing Buy Out Only?</label>
					<br>
					<input id="needsSubValue" $needsSubValueOption type="checkbox" onchange="filterGcBudgetLineItems();">
					<label for="needsSubValue" style="float:none">Subcontract value only</label>
				</td>
				<td nowrap style="width: 7%; vertical-align: bottom;">
					<label style="float:none;padding:0;margin:0px;cursor:pointer;"><input type="checkbox" name="subtotal" id="subtotalview" $subtotal_chk> Sub total</label>
				</td>
				<td colspan="2" style="vertical-align: bottom;">
						$gcBudgetmanage
				</td>
			</tr>
		</table>
		<input id="companyName" type="hidden" value="$companyName">
		<form action="/modules-gc-budget-form-submit.php" method="post" name="frmTabularData">
		<input id="activeGcBudgetLineItem" type="hidden" value="">
		<input id="tdCellOffset" type="hidden" value="$htmlTdCellOffset">
		<input id="current_project_id" type="hidden" value="$project_id">
		<table id="tblTabularData">
			<thead>
				<tr class="permissionTableMainHeader">
					$debugHeadline
					$selctAllDcrTrue
					<th>Cost Code</th>
					<th>Cost Code Description</th>
					<th ><span class="bs-tooltip" data-original-title="Prime Contract Scheduled Value">PCSV</span>
						<br>
						<span id="entypo-edit-icon" data-toggle="tooltip" title="Edit" class="entypo-click" style="display:block;" onclick="allowToUserEditPrimeValue(true);">
						<img src="images/edit-icon.png"></img>
						<!--<span class="btn entypo-click entypo-pencil popoverButton" style="position: relative; top: -5px; left: -22px;"></span>-->
					</span>
					<span data-toggle="tooltip" title="Lock" id="entypo-lock-icon" class="entypo-click" style="display:none;" onclick="allowToUserEditPrimeValue(false);">
					<span class="entypo-lock"></span>
					</span>
					</th>
					$OCOform
					<th>Forecasted<br>Expenses</th>
					<th>Buyout<br>Forecast</th>
					<th>Subcontract<br>Actual Value</th>
					<th>Variance</th>
					<th class="subcontract_vendor">Subcontractor<br>(Vendor)</th>
					<th>Subcontract<br>Details</th>
					<th>Invited<br>Bidders</th>
					<th>Active<br>Bidders</th>
					<th>Notes</th>
					<th>Purchasing Target<br>Date</th>
					<th>Cost Per<br>Sq. Ft</th>
					<th>Cost Per<br>Unit</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
END_FORM;

	$renderGcBudgetLineItemsTbody = renderGcBudgetLineItemsTbody($database, $user_company_id, $project_id, $cost_code_division_id_filter, $order_by_attribute, $order_by_direction,$scheduledValuesOnly, $needsBuyOutOnly,$needsSubValue);
	$gcBudgetForm .= $renderGcBudgetLineItemsTbody;

	// OCO list
	$gcBudgetOwnerChangeOrdersTbody = renderCoBudgetListView_AsHtml($database, $project_id);

$gcBudgetForm .= <<<END_FORM
			</tbody>
		</table>
		</form>
		<input id="currentSoftwareModule" type="hidden" value="gc_budget">
		<input id="divModalWindowTitle" type="hidden" value="">
		<input id="currentlySelectedProjectId" type="hidden" value="'.$project_id.'">
		<input id="currentlySelectedGcBudgetLineItemId" type="hidden" value="-1">
		<div id="divModalWindow" class=""></div>
		
		<div id="divModalWindow2"></div>
		<div id="dialog-confirm"></div>
		<div id="divsignature" class=""></div>
		<div id="divPermissionModal" title="$currentlySelectedUserCompanyName — $projectName — Budget Permissions"></div>
	</div>
END_FORM;

	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();
	$gcBudgetForm .= $fileUploaderProgressWindow;

	return $gcBudgetForm;
}
function selectedData($sesstionData, $data){
	if($sesstionData == $data){
		return 'selected="selected"';
	}else{
		return;
	}
}
function renderGcBudgetLineItemsTbody($database, $user_company_id, $project_id, $cost_code_division_id_filter=null, $order_by_attribute=false, $order_by_direction=false, $scheduledValuesOnly=false, $needsBuyOutOnly=false,$needsSubValue=false)
{
    // To get the COR above or below the line
	$aboveorbelw = Project::CORAboveOrBelow($database,$project_id);

	$loadGcBudgetLineItemsByProjectIdOptions = new Input();
	$loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
	if ($order_by_attribute) {
		if (!$order_by_direction) {
			$order_by_direction = 'ASC';
		}
		if ($order_by_attribute == 'cost_code') {
			$loadGcBudgetLineItemsByProjectIdOptions->arrOrderByAttributes = array(
				'gbli_fk_codes__fk_ccd.`division_number`' => $order_by_direction,
				'gbli_fk_codes.`cost_code`' => $order_by_direction
			);

		} else {
			$loadGcBudgetLineItemsByProjectIdOptions->arrOrderByAttributes = array(
				$order_by_attribute => $order_by_direction
			);
		}
	}

	$costCodeDivider = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

	$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions, '');
	$arrAllSubcontractorBidStatuses = SubcontractorBidStatus::loadAllSubcontractorBidStatuses($database);
   	$main_company = Project::ProjectsMainCompany($database,$project_id);
	$arrSubcontractorBidStatusCountsByProjectId = SubcontractorBid::loadSubcontractorBidStatusCountsByProjectId($database, $main_company, $project_id, $cost_code_division_id_filter);

	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$debugMode = $session->getDebugMode();

	if ($debugMode) {

		$fillerColumns = <<<END_FILLER_COLUMNS
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
END_FILLER_COLUMNS;
		$subTotalColumns = <<<END_FILLER_COLUMNS
				<td colspan="3">&nbsp;</td>
END_FILLER_COLUMNS;

	} else {
		$fillerColumns = $subTotalColumns = '';
	}
	$gcBudgetLineItemsTbody = '';

	$OCO_total = 0.00;
	$OCO_raw =0;
	$primeContractScheduledValueTotal = 0.00;
	$forecastedExpensesTotal = 0.00;
	$buyoutExpensesTotal = 0.00; 
	$subcontractActualValueTotal = 0.00;
	$varianceTotal = 0.00;
	$loopCounter = 1;
	$tabindex = 100;
	$tabindex2 = 200;
	$pcsvcs = 0;
	$fecs = 0;
	$savcs = 0;
	$buyout=0;
	$csfunit = 0;
	$cpsfunit = 0;
	$vcs = 0;
	$ioput = 1;
	$ioputIn = 1;
	$v_raw = 0;
	$countArray = count($arrGcBudgetLineItemsByProjectId);
	$costCodePSFValueTotal = $costCodePerSFValueTotal = 0;
	// Cost per SF/Unit
	$project = Project::findProjectByIdExtended($database, $project_id);
	$is_subtotal = (int) $project->is_subtotal;

	$subtotal_style = 'style="display:none;"';
	if($is_subtotal == '1') {
		$subtotal_style = '';
	}
	/* @var $project Project */
	$unit_count = $project->unit_count;
	$net_rentable_square_footage = $project->net_rentable_square_footage;
	foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
		/* @var $gcBudgetLineItem GcBudgetLineItem */
		$cc_per_sf_unit_value = 0;
		$cc_per_sf_ft_value = 0;
		if ($scheduledValuesOnly) {
			$prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
			if (!$prime_contract_scheduled_value || $prime_contract_scheduled_value == null || $prime_contract_scheduled_value == 0) {
				continue;
			}
		}
		$notes = $gcBudgetLineItem->notes;
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

			// Invited Bidders - Include all
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

		// prime_contract_scheduled_value
		$org_prime_contract_scheduled_value =$prime_contract_scheduled_value_raw = $prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
		$primeContractScheduledValueClass = '';
		if (isset($prime_contract_scheduled_value) && !empty($prime_contract_scheduled_value)) {
			$primeContractScheduledValueTotal += $prime_contract_scheduled_value;
			if ($prime_contract_scheduled_value < 0) {
				$primeContractScheduledValueClass = ' red';
			}
			$prime_contract_scheduled_value = Format::formatCurrency($prime_contract_scheduled_value);
		} else {
			$prime_contract_scheduled_value = '&nbsp;';
		}				

		// forecasted_expenses
		$forecasted_expenses_raw = $forecasted_expenses = $gcBudgetLineItem->forecasted_expenses;
		$forecastedExpensesClass = '';
		if (isset($forecasted_expenses) && !empty($forecasted_expenses)) {
			$forecastedExpensesTotal += $forecasted_expenses;
			if ($forecasted_expenses < 0) {
				$forecastedExpensesClass = ' red';
			}
			$forecasted_expenses = Format::formatCurrency($forecasted_expenses);
		} else {
			$forecasted_expenses = '&nbsp;';
		}

		$buyout_forecasted_expenses_raw = $buyout_forecasted_expenses = $gcBudgetLineItem->buyout_forecasted_expenses;
		if(isset($buyout_forecasted_expenses) && !empty($buyout_forecasted_expenses)){
			$buyoutExpensesTotal +=$buyout_forecasted_expenses;
			if ($buyout_forecasted_expenses < 0) {
				$buyout_forecasted_expensesClass = ' red';
			}
			$buyout_forecasted_expenses =Format::formatCurrency($buyout_forecasted_expenses);
		} else {
			$buyout_forecasted_expenses = Format::formatCurrency($buyout_forecasted_expenses);
		}
		
		$loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
		$loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
		$arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions);
		if (isset($arrSubcontracts) && !empty($arrSubcontracts)) {
			$subcontractCount = count($arrSubcontracts);
		} else {
			$subcontractCount = 0;
		}
		// purchasing_target_date
		$formattedPurchasingTargetDate = $gcBudgetLineItem->purchasing_target_date;
		$formattedPurchasingTargetDateSTime=strtotime($formattedPurchasingTargetDate);
		$today=strtotime(date('m/d/y'));
		if($today >= $formattedPurchasingTargetDateSTime && $subcontractCount < 1){
			$css = "color:red;";
		} else {
			$css = "color:black;";
		}

		if (isset($formattedPurchasingTargetDate) && !empty($formattedPurchasingTargetDate) && ($formattedPurchasingTargetDate != '0000-00-00')) {
			$unixTimestamp = strtotime($formattedPurchasingTargetDate);
			$formattedPurchasingTargetDate = date('m/d/Y', $unixTimestamp);
		} else {
			$formattedPurchasingTargetDate = '';
		}

		$tmpPurchasingTargetDateHtmlInput = <<<END_HTML_CONTENT
		<input id="manage-gc_budget_line_item-record--gc_budget_line_items--purchasing_target_date--$gc_budget_line_item_id" class="datepicker" onchange="Gc_Budget__updateGcBudgetLineItem(this, '', '');" value="$formattedPurchasingTargetDate" style="margin-top: 1px; text-align: center; width:80px; $css">
END_HTML_CONTENT;
		// subcontractCount
		$tmpPurchasingTargetDateHtmlInput .= <<<END_HTML_CONTENT
		<input id="subcontractCount-$gc_budget_line_item_id" type="hidden" value="$subcontractCount">
END_HTML_CONTENT;
		$subcontract_actual_value_raw = $subcontract_actual_value = null;
		$vendorList = '';
		$target_date = '';
		$arrSubcontractActualValueHtml = array();
		$arrCCPSFValueHtml = array();
		$arrCPSFValueHtml = array();
		$arrSubcontractVendorHtml = array();
		$arrSubcontractVendorChekBoxHtml = array();
		$arrPurchasingTargetDateHtmlInputs = array();
		$isBuyoutForecast = 'false';
		foreach ($arrSubcontracts as $subcontract) {
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
			$tmp_is_dcr_flag = $subcontract->is_dcr_flag;

			// checked value
			$manPowerOrNot = JobsiteManPower::checkSubcontractHasManPower($database,$tmp_subcontract_id);
			$isDcrFlag = $DcrDisabled = '';	
			$en_tooltip = "Check/Uncheck will affect subcontractors in the cost code from being listed in the Daily Log Manpower list.";	
			if ($tmp_is_dcr_flag == 'Y') {
				$isDcrFlag='checked=true';
				
			}
			if($manPowerOrNot == 'Y')
			{
				$DcrDisabled = "disabled";
				$en_tooltip = "Manpower is updated against this subcontractor, If you need to uncheck please revert the manpower to zero";
			}

			// Subcontract Actual Value list
			$subcontract_actual_value_raw += $tmp_subcontract_actual_value;
			$subcontract_actual_value += $tmp_subcontract_actual_value;

			//To add  SCO approved amt
	   		$subtable = GenActualOriginalValue($database, $cost_code_id,$project_id,$tmp_subcontract_id);

			$subcontract_actual_value +=$subtable;

			$tmp_subcontract_actual_value =$tmp_subcontract_actual_value +$subtable;
			$formattedSubcontractActualValue = Format::formatCurrency($tmp_subcontract_actual_value);
			if ($subcontractCount == 1) {
				$tmpSubcontractActualValueHtml = $formattedSubcontractActualValue;
			} elseif ($subcontractCount > 1) {
				$tmpSubcontractActualValueHtml = <<<END_HTML_CONTENT
				<tr>
					<td>
						<span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span> <span style="border: 0px solid red; display: inline-block; text-align: right; float: right;">$formattedSubcontractActualValue</span>
					</td>
				</tr>
END_HTML_CONTENT;

			}
			$arrSubcontractActualValueHtml[] = $tmpSubcontractActualValueHtml;

			$CCPSFValue = $tmp_subcontract_actual_value/$unit_count;
			$cc_per_sf_unit_value += $CCPSFValue;
			$formattedCCPSFValue = Format::formatCurrency($CCPSFValue);
			if ($subcontractCount == 1) {
				$tmpCCPSFValueHtml = $formattedCCPSFValue;
			} elseif ($subcontractCount > 1) {
				$tmpCCPSFValueHtml = <<<END_HTML_CONTENT
				<tr>
					<td>
						<span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span> <span style="border: 0px solid red; display: inline-block; text-align: right; float: right;">$formattedCCPSFValue</span>
					</td>
				</tr>
END_HTML_CONTENT;

			}
			$arrCCPSFValueHtml[] = $tmpCCPSFValueHtml;

			$CPSFValue = $tmp_subcontract_actual_value/$net_rentable_square_footage;
			$cc_per_sf_ft_value += $CPSFValue;
			$formattedCPSFValue = Format::formatCurrency($CPSFValue);
			if ($subcontractCount == 1) {
				$tmpCPSFValueHtml = $formattedCPSFValue;
			} elseif ($subcontractCount > 1) {
				$tmpCPSFValueHtml = <<<END_HTML_CONTENT

				<tr>
					<td style="border: 0px solid #fff !important; margin: 0 !important; padding: 0 !important;">
						<span style="border: 0px solid red;  float:left;padding-right: 5px;">#$tmp_subcontract_sequence_number) </span><span style="border: 0px solid red; float: right;">$formattedCPSFValue</span>
					</td>
				</tr>
END_HTML_CONTENT;

			}



			$arrCPSFValueHtml[] = $tmpCPSFValueHtml;

			// Vendor list
			$vendor = $subcontract->getVendor();
			if ($vendor) {

				$vendorContactCompany = $vendor->getVendorContactCompany();
				/* @var $vendorContactCompany ContactCompany */

				$vendorContactCompany->htmlEntityEscapeProperties();

				$vendorList .= $vendorContactCompany->escaped_contact_company_name . ', ';
				
				//To check the SCO Exists for the subcontarctor
				$resdata =SubcontractChangeOrderData($database, $costCode->cost_code_id,$project_id,"count",$gc_budget_line_item_id,$tmp_subcontract_id);
				if($resdata >'0')
				{
					$isBuyoutForecast = "true";
					$subSignal="<span class='dot dropbtn_$tmp_subcontract_id ' onclick='loadSubcontractCODATA($costCode->cost_code_id,$project_id,$gc_budget_line_item_id,$tmp_subcontract_id)'></span><div id='suborderitem_$tmp_subcontract_id' class='dropdown-content subBudgetCont'>
					</div>";
					$subSignal="1";
				}else{
					$subSignal="";

				}

				if ($subcontractCount == 1) {

					if($subSignal=="1") //For SCo records
					{
						$tmpSubcontractVendorHtmlInputs = "<span style='border: 0px solid red; display: inline-block;' class='sco_cont dropbtn_$tmp_subcontract_id ' onclick='loadSubcontractCODATA($costCode->cost_code_id,$project_id,$gc_budget_line_item_id,$tmp_subcontract_id)'>".$vendorContactCompany->escaped_contact_company_name."</span><div id='suborderitem_$tmp_subcontract_id' class='dropdown-content subBudgetCont'>";
					}else
					{

					$tmpSubcontractVendorHtmlInputs = $vendorContactCompany->escaped_contact_company_name;
				}

				} elseif ($subcontractCount > 1) {
					if($subSignal=="1") //For SCo records
					{
						$tmpSubcontractVendorHtmlInputs = <<<END_HTML_CONTENT

				<span style="border: 0px solid red; display: inline-block; " class='sco_cont dropbtn_$tmp_subcontract_id ' onclick='loadSubcontractCODATA($costCode->cost_code_id,$project_id,$gc_budget_line_item_id,$tmp_subcontract_id)'>#$tmp_subcontract_sequence_number)$vendorContactCompany->escaped_contact_company_name </span><div id='suborderitem_$tmp_subcontract_id' class='dropdown-content subBudgetCont'>
					</div>
END_HTML_CONTENT;
					}else
					{

					$tmpSubcontractVendorHtmlInputs = <<<END_HTML_CONTENT

				<span style="border: 0px solid red; display: inline-block; ">#$tmp_subcontract_sequence_number)</span>$vendorContactCompany->escaped_contact_company_name
END_HTML_CONTENT;
					}

				}
				$arrSubcontractVendorHtml[] = $tmpSubcontractVendorHtmlInputs;
				// checkbox
				$tmpSubcontractVendorCheckboxHtmlInputs = <<<END_HTML_CONTENT
				<span class="dcr-text" style="display:block;">
					<input type="checkbox" class="checkAllDcrText" id="attach_copy_$tmp_subcontract_id" $isDcrFlag disabled>
				</span>
				<span class="dcr-edit bs-tooltip" data-original-title="$en_tooltip" style="display:none;">
					<input type="checkbox" class="checkAllDcrEdit " data-original-title="$en_tooltip" id="attach_$tmp_subcontract_id" onclick="updateIsDcrFlag($tmp_subcontract_id)" $isDcrFlag $DcrDisabled> #$tmp_subcontract_sequence_number)
				</span>
END_HTML_CONTENT;
				$arrSubcontractVendorChekBoxHtml[] = $tmpSubcontractVendorCheckboxHtmlInputs;
			}

			// @todo...this parts
			// Foreign key objects
			/* @var $subcontractTemplate SubcontractTemplate */
		}

		// subcontract actual values
		if ($subcontractCount > 1) {
			$subcontractActualValueHtml = join('', $arrSubcontractActualValueHtml);
			$subcontractActualValueHtml = "\n\t\t\t\t\t$subcontractActualValueHtml";

		} else {
			$subcontractActualValueHtml = '';
			$subcontractCheckBoxHtml = '';
		}
		$subcontractCheckBoxHtml = join('', $arrSubcontractVendorChekBoxHtml);
		// vendors
		$vendorList = join('<br>', $arrSubcontractVendorHtml);
		if ($subcontractCount > 1) {
			$vendorListTdClass = ' class="verticalAlignTopImportant"';
		} else {
			$vendorListTdClass = '';
		}

		// cost per unit
		if ($subcontractCount > 1) {
			$CCPSFValueHtml = join('', $arrCCPSFValueHtml);
			$CCPSFValueHtml = "\n\t\t\t\t\t$CCPSFValueHtml";
		} else {
			$CCPSFValueHtml = '';
		}

		// cost per sf
		if ($subcontractCount > 1) {
			$CPSFValueHtml = join('', $arrCPSFValueHtml);
			$CPSFValueHtml = "\n\t\t\t\t\t$CPSFValueHtml";
		} else {
			$CPSFValueHtml = '';
		}

		if ($needsBuyOutOnly) {
			if ($subcontract_actual_value) {
				continue;
			}
		}
		if($needsSubValue =="true")
		{
			if ((!$prime_contract_scheduled_value_raw || $prime_contract_scheduled_value_raw == null || $prime_contract_scheduled_value_raw == 0)
				&& (!$subcontract_actual_value || $subcontract_actual_value == null || $subcontract_actual_value == 0) 
				&& (!$forecasted_expenses_raw || $forecasted_expenses_raw == null || $forecasted_expenses_raw == 0)
				&& (!$buyout_forecasted_expenses_raw || $buyout_forecasted_expenses_raw == null || $buyout_forecasted_expenses_raw == 0)) 
			{
				continue;
			}
			
		}

		// subcontract_actual_value
		$subcontractActualValueClass = '';
		$sav_raw = $subcontract_actual_value;
		if (isset($subcontract_actual_value) && !empty($subcontract_actual_value)) {
			$subcontractActualValueTotal += $subcontract_actual_value;
			if ($subcontract_actual_value < 0) {
				$subcontractActualValueClass = ' red';
			}
			$subcontract_actual_value = Format::formatCurrency($subcontract_actual_value);
		} else {
			$subcontract_actual_value = '&nbsp;';
		}

		// Cost per sf/unit actual values
		$CCPSFClass = '';
		$csfunit_raw = $cc_per_sf_unit_value;
		if (isset($cc_per_sf_unit_value) && !empty($cc_per_sf_unit_value)) {
			$costCodePSFValueTotal += $cc_per_sf_unit_value;
			if ($cc_per_sf_unit_value < 0) {
				$CCPSFClass = ' red';
			}
			$cc_per_sf_unit_value_html = Format::formatCurrency($cc_per_sf_unit_value);
		} else {
			$cc_per_sf_unit_value_html = '&nbsp;';
		}

		$cpsfunit_raw = $cc_per_sf_ft_value;
		if (isset($cc_per_sf_ft_value) && !empty($cc_per_sf_ft_value)) {
			$costCodePerSFValueTotal += $cc_per_sf_ft_value;
			$cc_per_sf_ft_value_html = Format::formatCurrency($cc_per_sf_ft_value);
		} else {
			$cc_per_sf_ft_value_html = '&nbsp;';
		}
		$ocoVarianceTot = ChangeOrder::loadSumOfCostCodeBreakDownByProjectIdAndCostCodeId($database, $costCode->cost_code_id,$project_id);
		$totalBreakdownAmountValue = $ocoVarianceTot['totalBreakdownAmount'];
		
		// variance
		$pcsv = Data::parseFloat($prime_contract_scheduled_value_raw);
		$pscvReallocation = DrawItems::costcodeReallocated($database,$costCode->cost_code_id,$project_id);
		$forecast = Data::parseFloat($forecasted_expenses_raw);
		$buyforecast = Data::parseFloat($buyout_forecasted_expenses_raw);
		$sav = Data::parseFloat($subcontract_actual_value);
		if($aboveorbelw=='2')
		{
			$pcsv = $pcsv + $totalBreakdownAmountValue + $pscvReallocation['total'];
		}else{
			$pcsv = $pcsv + $pscvReallocation['total'];
		}
		if ($subcontractCount >= 1)
		{
			$gcBudgetLineItemVariance = $pcsv - ($forecast + $sav);
		}else{
			$gcBudgetLineItemVariance = $pcsv - ($forecast + $buyforecast + $sav);
		}
		
		$varianceTotal += $gcBudgetLineItemVariance;
		if ($gcBudgetLineItemVariance < 0) {
			$gcBudgetLineItemVarianceClass = ' red';
		} else {
			$gcBudgetLineItemVarianceClass = '';
		}
		$gcBudgetLineItemVariance = Format::formatCurrency($gcBudgetLineItemVariance);

		if ($loopCounter%2) {
			$rowStyle = '';
		} else {
			$rowStyle = '';
		}
		
if($loopCounter==1)
	$valueCheck = $costCodeDivision->escaped_division_number;
if($countArray == $loopCounter-1)
	echo $loopCounter;
	
if(($valueCheck != $costCodeDivision->escaped_division_number)){
	$vcs = number_format($vcs,2);

	if ($vcs < 0) {
		$vcsclass = ' red';
	}else
	$vcsclass='';
	if ($fecs < 0)
		$fecssclass = ' red';
	else
		$fecssclass='';
	$OCO_row ="";
	if($aboveorbelw == "2")
{
	$OCO_row = <<<Table_OCOsubtotal
	<td>
<section class="subtotal input-OCO-subtotal" style="text-align:right;">$formattedOCO_raw</section>
</td>
Table_OCOsubtotal;

}

$pcsvcs = Format::formatCurrency($pcsvcs);
$fecs = Format::formatCurrency($fecs);
$vcs = Format::formatCurrency($vcs);
$savcs = Format::formatCurrency($savcs);
$buyout = format::formatCurrency($buyout);
$csfunit = Format::formatCurrency($csfunit);
$cpsfunit = Format::formatCurrency($cpsfunit);
$tablesub = <<<Table_subtotal
<tr class="bottom-content subtotal-row" $subtotal_style>
$subTotalColumns
<td></td>
<td class="subtotal">$valueCheck</td>
<td>
<section class="subtotal">Sub total</section> 
</td>
<td>
<section class="subtotal input-scheduled-subtotal" id="pcsvSubtotal$ioput">$pcsvcs</section>
</td>
$OCO_row
<td>
<section class="subtotal input-scheduled-subtotal $fecssclass" id="feSubtotal$ioput">$fecs</section>
</td>
<td>
<section class="subtotal input-scheduled-subtotal" id="beSubtotal$ioput">$buyout</section>
</td>
<td>
<section class="subtotal input-scheduled-subtotal">$savcs</section>
</td>
<td>
	<section class="subtotal input-scheduled-subtotal $vcsclass"  id="vSubtotal$ioput">$vcs</section>
</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td>
	<section class="subtotal input-scheduled-subtotal">$cpsfunit</section>
</td>
<td>
	<section class="subtotal input-scheduled-subtotal">$csfunit</section>
</td>
<td></td>
</tr>
Table_subtotal;
 $gcBudgetLineItemsTbody .= $tablesub;
 $tablesub;
 $valueCheck = $costCodeDivision->escaped_division_number;
 $pcsvcs = 0;
 $fecs = 0;
 $vcs = 0;
 $savcs = 0;
 $buyout =0;
 $csfunit = 0;
 $cpsfunit = 0;
 $OCO_raw = 0;
 $ioput++;
 $ioputIn = 1;
 $v_raw=0;
}
		
	// total anaysis breakdown
	$loadCostCodeBreakDownByProjectIdAndCostCodeId = new Input();
	$loadCostCodeBreakDownByProjectIdAndCostCodeId->forceLoadFlag = true;
	$costCodeAnaysisBreakDown = ChangeOrder::loadSumOfCostCodeBreakDownByProjectIdAndCostCodeId($database, $costCode->cost_code_id,$project_id);
	$totalCountBreakDown = $costCodeAnaysisBreakDown['totalCount'];
	$totalBreakdownAmount = $costCodeAnaysisBreakDown['totalBreakdownAmount'];
	$OCO_raw = (($OCO_raw) + ($totalBreakdownAmount));
	$OCO_total  =(($OCO_total) + ($totalBreakdownAmount));
	$formattedOCO_raw = Format::formatCurrency($OCO_raw);
	$formattedOCO_total = Format::formatCurrency($OCO_total);
	$formattedtotalBreakdownAmount =  Format::formatCurrency($totalBreakdownAmount);
	// Add BreakDown cost of subtotal and total
	$prime_contract_scheduled_value_raw = $prime_contract_scheduled_value_raw ;
	// To remove the difference between the vector report and budget
	$primeContractScheduledValueTotal = $primeContractScheduledValueTotal;

	$reallocation = DrawItems::costcodeReallocated($database,$costCode->cost_code_id,$project_id);
	$updtedPSCV = $org_prime_contract_scheduled_value + $reallocation['total'];
	// $updtedPSCV = Format::formatCurrency($updtedPSCV);
	$prime_contract_scheduled_value_raw = $prime_contract_scheduled_value_raw +$reallocation['total'];
	$primeContractScheduledValueTotal = $primeContractScheduledValueTotal +$reallocation['total'];
	
	$csfunit = ($csfunit + $csfunit_raw);
	$cpsfunit = ($cpsfunit + $cpsfunit_raw);
	$pcsvcs = (($pcsvcs) + ($prime_contract_scheduled_value_raw));
	$fecs = (($fecs) + ($forecasted_expenses_raw));
	$savcs = (($savcs) + ($sav_raw));
	$subConVal = Data::parseFloat($sav_raw);
	$buyout = (($buyout) + ($buyout_forecasted_expenses_raw));
	
	

	if ($subcontractCount >= 1){
		if($aboveorbelw=='2')
		{
			$v_raw = ($prime_contract_scheduled_value_raw + $totalBreakdownAmount) - ($forecasted_expenses_raw + $sav_raw);
		}else{
			$v_raw = ($prime_contract_scheduled_value_raw) - ($forecasted_expenses_raw + $sav_raw);
		}
	}else{
		if($aboveorbelw=='2')
		{
			$v_raw = ($prime_contract_scheduled_value_raw + $totalBreakdownAmount) - ($forecasted_expenses_raw +$buyout_forecasted_expenses_raw +$sav_raw);
		}else{
			$v_raw = ($prime_contract_scheduled_value_raw) - ($forecasted_expenses_raw +$buyout_forecasted_expenses_raw +$sav_raw);
		}
	}
	$vcs = (($vcs) + ($v_raw));

		$gcBudgetLineItemsTbody .= <<<GC_BUDGET_LINE_ITEMS_TBODY

				<tr id="record_container--manage-gc_budget_line_item-record--gc_budget_line_items--sort_order--$gc_budget_line_item_id" class="$rowStyle">
GC_BUDGET_LINE_ITEMS_TBODY;

		if ($debugMode) {

			$html_gc_budget_line_item_id = (!empty($gc_budget_line_item_id) ? $gc_budget_line_item_id : '&nbsp;');
			$html_cost_code_division_id = (!empty($costCodeDivision->cost_code_division_id) ? $costCodeDivision->cost_code_division_id : '&nbsp;');
			$html_cost_code_id = (!empty($costCode->cost_code_id) ? $costCode->cost_code_id : '&nbsp;');

			$gcBudgetLineItemsTbody.= <<<GC_BUDGET_LINE_ITEMS_TBODY

					<td>$html_gc_budget_line_item_id</td>
					<td>$html_cost_code_division_id</td>
					<td>$html_cost_code_id</td>
GC_BUDGET_LINE_ITEMS_TBODY;

		}

	
		
		$deleteGcBudgetLineItemDesc = $costCode->escaped_cost_code.' / '.$costCode->escaped_cost_code_description;
		$deleteGcBudgetLineItemDesc = <<<HTMLENTITYMSG
		<span style="color:#3b90ce;">$deleteGcBudgetLineItemDesc</span>
HTMLENTITYMSG;
		$deleteGcBudgetLineItemDesc = htmlspecialchars($deleteGcBudgetLineItemDesc);
		$isDcrFlag='';
		
		if ($gcBudgetLineItem->is_dcr_flag == 'Y') {
			$isDcrFlag='checked=true';
		}
		// Add BreakDown Anaysis Cost
		if($aboveorbelw == "1"){
			// To remove the difference between the vector report and budget
			$updtedPSCV = $updtedPSCV;
		}

		$updtedPSCV = Format::formatCurrency($updtedPSCV);

		if($reallocation['count'] > 0 || $totalCountBreakDown > 0)
		{
			$PCSVData =  <<<PCSVData
			<span id="prime-text-$gc_budget_line_item_id" class="input-scheduled  prime_contract_scheduled_value sco_cont  " style="display:block;" onclick="loadReallocationDATA($costCode->cost_code_id,$project_id,$gc_budget_line_item_id)">$updtedPSCV</span>
			<div id='realocateitem_$gc_budget_line_item_id' class='dropdown-content realocationCont'>
					</div>
					<input id="manage-gc_budget_line_item-record--gc_budget_line_items--prime_contract_scheduled_value--$gc_budget_line_item_id" class="pcsvSubFld$ioput pcsvSubFld$ioput-$ioputIn input-scheduled autosum-pcsv$primeContractScheduledValueClass gc_budget_line_items--$gc_budget_line_item_id prime_contract_scheduled_value-edit" type="hidden" value="$updtedPSCV" onkeyup="moveToNextRowIfEnterKeyWasPressed(event);" onchange="Gc_Budget__ScheduleValueUpdate(this, '', 'pcsv+$ioput');" tabindex="$tabindex" >
			
PCSVData;
		}else
		{
			$PCSVData =  <<<PCSVData
			<span id="prime-text-$gc_budget_line_item_id" class="input-scheduled  prime_contract_scheduled_value-text" style="display:block;">$updtedPSCV</span>
			<input id="manage-gc_budget_line_item-record--gc_budget_line_items--prime_contract_scheduled_value--$gc_budget_line_item_id" class="pcsvSubFld$ioput pcsvSubFld$ioput-$ioputIn input-scheduled autosum-pcsv$primeContractScheduledValueClass gc_budget_line_items--$gc_budget_line_item_id prime_contract_scheduled_value-edit" type="text" value="$prime_contract_scheduled_value" onkeyup="moveToNextRowIfEnterKeyWasPressed(event);" onchange="Gc_Budget__ScheduleValueUpdate(this, '', 'pcsv+$ioput');" tabindex="$tabindex" style="display:none;">
PCSVData;
		}

	$db  = DBI::getInstance($database);
	$submittal_query = "SELECT count(id) as count FROM `submittals`  WHERE  `su_cost_code_id` = '$costCode->cost_code_id' AND project_id='$project_id' ORDER BY `created` ASC LIMIT 1";
	$db->execute($submittal_query);
	$submittal_count = $db->fetch();
	//$db->free_result();
	$SubmittalVData ='';
	if($submittal_count['count']>0){
		$SubmittalVData =  <<<SubmittalVData
			<div id="prime-text-$gc_budget_line_item_id" class="prime_contract_scheduled_value sco_cont  bs-tooltip " data-original-title="View Submittal" style="display:block;" onclick="loadSubmittalDelayDATA($costCode->cost_code_id,$project_id,$gc_budget_line_item_id)"><input type="button" value="i" style="padding:1px 3px"></div>
					</div>
	
SubmittalVData;
}
		// To check whether COR is above the line
		$CORAbovedata="";
		if($aboveorbelw == "2")
		{
			$CORAbovedata= <<<aboveData
			<td class="input-scheduled" data-value="$aboveorbelw" id="manage-gc_budget_line_item-record--gc_budget_line_items--ocoValue--$gc_budget_line_item_id">$formattedtotalBreakdownAmount </td>
aboveData;
	
		}	
		if($notes !="")
		{
			$n_icon ="entypo-doc-text";
		}else
		{
			$n_icon = "entypo-plus-circled";
		}
		$pID=base64_encode($project_id);
		$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY

					<td style="vertical-align: top;">
						<!-- <span class="dcr-text" style="display:block;">
							<input type="checkbox" class="checkAllDcrText" id="attach_copy_$gc_budget_line_item_id" $isDcrFlag disabled>
						</span>
						<span class="dcr-edit" style="display:none;">
							<input type="checkbox" class="checkAllDcrEdit bs-tooltip" data-original-title="Check/Uncheck will affect subcontractors in the cost code from being listed in the Daily Log Manpower list." id="attach_$gc_budget_line_item_id" onclick="updateIsDcrFlag('$gc_budget_line_item_id')" $isDcrFlag> -->
							$subcontractCheckBoxHtml
						</span>
					</td>
					<td class="" >
					<div style="display:flex">
					<div style="width:55px;">
					<span class="fakeHref bs-tooltip" onclick="loadGcBudgetLineItemSubcontractorBidManagementModalDialog('$gc_budget_line_item_id');"  data-original-title="View Bid Invite">
						<span id="gc_budget_line_items--cost_code_divisions--division_number--$cost_code_division_id" data-origin-id="cost_code_divisions--division_number--$cost_code_division_id">$costCodeDivision->escaped_division_number</span>$costCodeDivider<span id="gc_budget_line_items--cost_codes--cost_code--$cost_code_id" data-origin-id="cost_codes--cost_code--$cost_code_id">$costCode->escaped_cost_code</span></span>
						</div> 
						
					$SubmittalVData
					<div id='submittalitem_$gc_budget_line_item_id' class='dropdown-content' style="right:485px"></div>
					</td>
					<td data-origin-id="cost_codes--cost_code_description--$cost_code_id" class="" ><a href="/modules-purchasing-bid-spread.php?gc_budget_line_item_id=$gc_budget_line_item_id&pID=$pID" id="gc_budget_line_items--cost_codes--cost_code_description--$cost_code_id" target="_blank" class="bs-tooltip" data-original-title="View Bid Spread">
						$costCode->escaped_cost_code_description</a> 
					</td>
					<td  style="position:relative;">					
					$PCSVData						
					<input type="hidden" id="prev_schedule_val" value="$prime_contract_scheduled_value_raw">
					</td>
					$CORAbovedata
					<td>
						<input id="manage-gc_budget_line_item-record--gc_budget_line_items--forecasted_expenses--$gc_budget_line_item_id" class="feSubFld$ioput feSubFld$ioput-$ioputIn input-forecasted autosum-fe$forecastedExpensesClass gc_budget_line_items--$gc_budget_line_item_id" type="text" value="$forecasted_expenses" onkeyup="moveToNextRowIfEnterKeyWasPressed(event);" onchange="Gc_Budget__updateGcBudgetLineItem(this, '', 'fe+$ioput');" tabindex="$tabindex2">
					</td>
					<td>
					<input id="manage-gc_budget_line_item-record--gc_budget_line_items--buyout_forecasted_expenses--$gc_budget_line_item_id" class="beSubFld$ioput beSubFld$ioput-$ioputIn input-buyout autosum-be$buyout_forecasted_expensesClass gc_budget_line_items--$gc_budget_line_item_id" type="text" value="$buyout_forecasted_expenses" onkeyup="moveToNextRowIfEnterKeyWasPressed(event);" onkeypress='validateBuyoutForecast(event)' onchange="Gc_Budget__updateGcBudgetLineItem(this, '', 'be+$ioput');" tabindex="$tabindex2">
					</td>
					<td>
						<table class="nestedTable">$subcontractActualValueHtml
							<tr>
								<td>
									<div style="border: 0px solid black; clear: right; float: right;" id="manage-gc_budget_line_item-record--gc_budget_line_items--subcontract_actual_value--$gc_budget_line_item_id" class="input-subcontracted autosum-sav$subcontractActualValueClass gc_budget_line_items--$gc_budget_line_item_id">$subcontract_actual_value</div>
								</td>
							</tr>
						</table>
					</td>
					<td style="text-align:right;" ><span id="manage-gc_budget_line_item-record--gc_budget_line_items--variance--$gc_budget_line_item_id" class="bs-tooltip vSubFld$ioput vSubFld$ioput-$ioputIn alignRight$gcBudgetLineItemVarianceClass gc_budget_line_items--$gc_budget_line_item_id" data-original-title="Prime contract Schedule Value - (Forecast expense + Buyout expense + Subcontract Actual Value)">$gcBudgetLineItemVariance</span></td>
					<td align="left"$vendorListTdClass id="gc_budget_line_items--vendorList--$gc_budget_line_item_id">$vendorList</td>
					<td align="center">
					<a href="/budget_subcontract.php?gc_budget_line_item_id=$gc_budget_line_item_id&cost_code_division_id=$cost_code_division_id&cost_code_id=$cost_code_id&subcontractor_bid_id=$subcontractor_bid_id&pID=$pID">Subcontract</a>
					</td>
					<td align="center">$invitedBiddersCount</td>
					<td align="center">$activeBiddersCount</td>
					<td align="center">
					<span id="btnAddNotesPopover_$gc_budget_line_item_id" class="btnAddNotesPopover btn entypo entypo-click $n_icon popoverButton" data-toggle="popover" style="margin-left:7px"></span>

					<div id="CreateNotesdiv_$gc_budget_line_item_id" class="hidden">
					<div id="record_creation_form--create-prelim-record">
					<div>
					<textarea rows='3' column='150' id="manage-gc_budget_line_item-record--gc_budget_line_items--notes--$gc_budget_line_item_id" onchange="Gc_Budget__updateGcBudgetLineItem(this, '', '');">$notes</textarea>
					<input type="button" value="save Notes" onclick="closenotes($gc_budget_line_item_id);" style="width: 150px; padding: 4px;padding-top:10px;"></div>
					</div>
					</td>
					<td align="center" class="verticalAlignTopImportant">$tmpPurchasingTargetDateHtmlInput
					</td>
					<td>
						<table class="nestedTable">
							$CPSFValueHtml
								<tr>
									<td>
										<div style="border: 0px solid black; clear: right;" id="manage-gc_budget_line_item-record--gc_budget_line_items--cc_per_sf_value--$gc_budget_line_item_id" class="input-subcontracted autosum-sav gc_budget_line_items--$gc_budget_line_item_id">$cc_per_sf_ft_value_html</div>
									</td>
								</tr>
							</table>
						</td>
					<td>
						<table class="nestedTable">
						$CCPSFValueHtml
							<tr>
								<td>
									<div style="border: 0px solid black; clear: right;" id="manage-gc_budget_line_item-record--gc_budget_line_items--cc_per_sf_unit_value--$gc_budget_line_item_id" class="input-subcontracted autosum-sav$CCPSFClass gc_budget_line_items--$gc_budget_line_item_id">$cc_per_sf_unit_value_html</div>
								</td>
							</tr>
						</table>
					</td>
					<td>
						<a class="bs-tooltip" href="javascript:Gc_Budget__deleteGcBudgetLineItem($gc_budget_line_item_id, '', '$deleteGcBudgetLineItemDesc');" title="Delete $costCodeDivision->escaped_division_number-$costCode->escaped_cost_code">x</a>
					</td>					
				</tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;

		$loopCounter++;
		$tabindex++;
		$tabindex2++;
		$ioputIn++;
	}

	if ($primeContractScheduledValueTotal < 0) {
		$primeContractScheduledValueTotalClass = ' red';
	} else {
		$primeContractScheduledValueTotalClass = '';
	}
	$totalPrimeSchedule = $primeContractScheduledValueTotal;
	$primeContractScheduledValueTotal = Format::formatCurrency($primeContractScheduledValueTotal);

	if ($forecastedExpensesTotal < 0) {
		$forecastedExpensesTotalClass = ' red';
	} else {
		$forecastedExpensesTotalClass = '';
	}
	$forecastedExpensesTotal = Format::formatCurrency($forecastedExpensesTotal);

	
	if ($buyoutExpensesTotal < 0) {
		$buyoutExpensesTotalClass = ' red';
	} else {
		$buyoutExpensesTotalClass = '';
	}
	$buyoutExpensesTotal = Format::formatCurrency($buyoutExpensesTotal);

	if ($subcontractActualValueTotal < 0) {
		$subcontractActualValueTotalClass = ' red';
	} else {
		$subcontractActualValueTotalClass = '';
	}
	$subcontractActualValueTotal = Format::formatCurrency($subcontractActualValueTotal);

	if ($costCodePSFValueTotal < 0) {
		$costCodePSFValueTotalClass = ' red';
	} else {
		$costCodePSFValueTotalClass = '';
	}
	$costCodePSFValueTotal = Format::formatCurrency($costCodePSFValueTotal);

	$costCodePerSFValueTotal = Format::formatCurrency($costCodePerSFValueTotal);



	if ($varianceTotal < 0) {
		$varianceTotalClass = ' red';
	} else {
		$varianceTotalClass = '';
	}
	$varianceTotal = Format::formatCurrency($varianceTotal);
	if ($vcs < 0) {
		$vcsclass = ' red';
	}else
	$vcsclass='';
	if ($fecs < 0)
		$fecssclass = ' red';
	else
		$fecssclass='';
$pcsvcs = Format::formatCurrency($pcsvcs);
$fecs = Format::formatCurrency($fecs);
$vcs = Format::formatCurrency($vcs);
$savcs = Format::formatCurrency($savcs);
$buyout = format::formatCurrency($buyout);
$csfunit = Format::formatCurrency($csfunit);
$cpsfunit = Format::formatCurrency($cpsfunit);
$OCO_row ="";
if($aboveorbelw == "2")
{
	$OCO_row = <<<Table_OCOsubtotal
	<td>
<section class="subtotal input-OCO-subtotal" style="text-align:right;">$formattedOCO_raw</section>
</td>
Table_OCOsubtotal;

}
$tablesub = <<<Table_subtotal
<tr class="bottom-content subtotal-row" $subtotal_style>
$subTotalColumns
<td></td>
<td class="subtotal">$valueCheck</td>
<td>
<section class="subtotal">Sub total</section> 
</td>
<td>
<section class="subtotal input-scheduled-subtotal" id="pcsvSubtotal$ioput">$pcsvcs</section>
</td>
$OCO_row 
<td>
<section class="subtotal input-scheduled-subtotal $fecssclass" id="feSubtotal$ioput">$fecs</section>
</td>
<td>
<section class="subtotal input-scheduled-subtotal" id="beSubtotal$ioput">$buyout</section>
</td>
<td>
<section class="subtotal input-scheduled-subtotal">$savcs</section>
</td>
<td>
	<section class="subtotal input-scheduled-subtotal $vcsclass" id="vSubtotal$ioput">$vcs</section>
</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td>
	<section class="subtotal input-scheduled-subtotal">$cpsfunit</section>
</td>
<td>
	<section class="subtotal input-scheduled-subtotal">$csfunit</section>
</td>
<td></td>
</tr>
Table_subtotal;
$gcBudgetLineItemsTbody .= $tablesub;
// To fetch the OCO above the line
$ocoTotalrow= "";
if($aboveorbelw == "2")
{
	$ocoTotalrow = <<<OCOTOTAL
	<td class="input-total alignRight">$formattedOCO_total</td>
OCOTOTAL;
	}

$gcBudgetLineItemsTbody .= <<<END_FORM
				<tr>
					$fillerColumns
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="input-total alignRight">Total</td>
					<td><input id="primeContractScheduledValuesTotal" class="input-scheduled input-total$primeContractScheduledValueTotalClass" type="text" value="$primeContractScheduledValueTotal" readonly></td>
					$ocoTotalrow
					<td><input id="forecastedExpensesTotal" class="input-forecasted input-total$forecastedExpensesTotalClass" type="text" value="$forecastedExpensesTotal" readonly></td>
					<td><input id="buyoutExpensesTotal" class="input-forecasted input-total$buyoutExpensesTotalClass" type="text" value="$buyoutExpensesTotal" readonly></td>
					<td align="right"><input id="subcontractActualValuesTotal" class="input-subcontracted input-total input-subcontracted-value $subcontractActualValueTotalClass" type="text" value="$subcontractActualValueTotal" readonly></td>
					<td><input id="varianceTotal" class="input-variance input-total$varianceTotalClass" type="text" value="$varianceTotal" readonly></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right"><input id="costCodePerSFValueTotal" class="input-subcontracted input-total" type="text" value="$costCodePerSFValueTotal" readonly></td>

					<td align="right"><input id="costCodePSFValueTotal" class="input-subcontracted input-total$costCodePSFValueTotalClass" type="text" value="$costCodePSFValueTotal" readonly></td>
					<td>&nbsp;</td>
				</tr>

END_FORM;
	
	if($aboveorbelw == "1")
	{
	//COR list
	$gcBudgetCORTbody = renderCORforBudgetList($database, $project_id,$totalPrimeSchedule,$fillerColumns);
	$gcBudgetLineItemsTbody .= $gcBudgetCORTbody;
	}

	return $gcBudgetLineItemsTbody;
}

function renderCreateSubcontractForm($database, $user_company_id, Subcontract $subcontract, $cost_code_division_id, $cost_code_id, $subcontractor_bid_id)
{
	
	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$project_id = $session->getCurrentlySelectedProjectId();


	$htmlContent = '';

	$subcontracted_contact_company_id = null;

	$subcontractorBid = $subcontract->getSubcontractorBid();
	/* @var $subcontractorBid SubcontractorBid */
	if ($subcontractorBid) {
		$bid_total = $subcontractorBid->deriveBidTotal();
		$subcontract->subcontract_actual_value = $bid_total;
	} else {
		$bid_total = '';
	}

	// Create Subcontract Form
	$dummyRecordPrimaryKey = 'dummy1-'.uniqid();

	$gc_budget_line_item_id = $subcontract->gc_budget_line_item_id;
	$subcontract_sequence_number = $subcontract->subcontract_sequence_number;
	$subcontract_actual_value = $subcontract->subcontract_actual_value;
	$subcontract_target_execution_date = $subcontract->subcontract_target_execution_date;

	if (!isset($subcontract_target_execution_date)) {
		// Y-m-d
		$futureNowPlusTwoWeeks = (86400 * 14) + time();
		// $subcontract_target_execution_date = date('m/d/Y', $futureNowPlusTwoWeeks);
		$subcontract_target_execution_date = Date::convertDateTimeFormat(date('Y-m-d', $futureNowPlusTwoWeeks), 'html_form');
	}

	// ddl: subcontract_templates
	$arrSubcontractTemplates = SubcontractTemplate::loadSubcontractTemplatesByUserCompanyId($database, $user_company_id);
	// Filtering disabled templates
	$arrSubcontractTemplates = array_filter($arrSubcontractTemplates, function($subtemplateData) {
		return $subtemplateData->disabled_flag != 'Y';
	});
	$ddlElementId = 'create-subcontract-record--subcontracts--subcontract_template_id--'.$dummyRecordPrimaryKey;
	$js = 'class="required subcontract_templates"';
	$prependedOption = '<option value="">Please choose a Subcontract Template</option>';
	$ddlSubcontractTemplates = PageComponents::dropDownListFromObjects($ddlElementId, $arrSubcontractTemplates, 'subcontract_template_id', null, 'subcontract_template_name', null, null, null, $js, $prependedOption);

	$projectCustArr = getProjectCustomers($database,$user_company_id);

	$qb_cust_html = 'No Customer:Project selected. <input type="hidden" id="project_customer_exist" value="0"><input type="hidden" id="project_customer" value="">';
	$project = Project::findById($database, $project_id);
	if(!empty($project->qb_customer_id) && !empty($projectCustArr[$project->qb_customer_id])){
		$qb_cust_html = $projectCustArr[$project->qb_customer_id].'<input type="hidden" id="project_customer_exist" value="1"><input type="hidden" id="project_customer" value="'.$projectCustArr[$project->qb_customer_id].'">';
	}
	$vendor = $subcontract->getVendor();
	/* @var $vendor Vendor */
	if ($vendor) {
		$vendor_id = $vendor->vendor_id;
		$subcontracted_contact_company_id = $vendor->vendor_contact_company_id;
	}

	// ddl: vendor_contact_company_id
	$arrVendorContactCompanies = ContactCompany::loadContactCompaniesByUserUserCompanyId($database, $user_company_id);
	
	$ddlElementId = 'create-subcontract-record--subcontracts--vendor_contact_company_id--'.$dummyRecordPrimaryKey;
	$ddlContactCompanies = PageComponents::dropDownListFromObjects($ddlElementId, $arrVendorContactCompanies, 'contact_company_id', null, 'company', null, $subcontracted_contact_company_id, null, '', '<option value="">Please Select A Vendor</option>');

	$gcBudgetLineItem = GcBudgetLineItem::findGcBudgetLineItemByIdExtended($database, $subcontract->gc_budget_line_item_id);


	$costCode = $gcBudgetLineItem->getCostCode();
	/* @var $costCode CostCode */
	$cost_code_id = $costCode->cost_code_id;
	$cost_code = $costCode->cost_code;
	$cost_code_description = $costCode->cost_code_description;
	$cost_code_description_abbreviation = $costCode->cost_code_description_abbreviation;

	$costCodeDivision = $gcBudgetLineItem->getCostCodeDivision();
	/* @var $costCodeDivision CostCodeDivision */
	$cost_code_division_id = $costCodeDivision->cost_code_division_id;
	$division_number = $costCodeDivision->division_number;
	$division_code_heading = $costCodeDivision->division_code_heading;
	$division = $costCodeDivision->division;
	$division_abbreviation = $costCodeDivision->division_abbreviation;

	$division_number = $costCodeDivision->division_number;
	$cost_code = $costCode->cost_code;
	$cost_code_description = $costCode->cost_code_description;

$fileUploadDirectory = '/Subcontracts/' . $division_number . '-' . $cost_code . ' ' . $cost_code_description . '/';


			/* @var $vendor Vendor */
			$vendor_company_name = '';			
// Signed Subcontract Uploader
			$virtual_file_name =
				$vendor_company_name . ' : ' .
				'Signed Subcontract #'.
				$subcontract->subcontract_sequence_number . '.pdf';
			$encoded_virtual_file_name = urlencode($virtual_file_name);

	$htmlContent .=
'
<div class="widgetContainer" style="width:750px; margin:15px 0 0 0">
	<h3 class="title">Create New Subcontract</h3>
	<table class="content tableCreateSubcontract" width="95%" cellpadding="5px" id="container--create-subcontract-record--'.$dummyRecordPrimaryKey.'">
		<tr>
			<th class="textAlignRight">Subcontract Template:</th>
			<td>
				<input id="formattedAttributeGroupName--create-subcontract-record" type="hidden" value="Subcontract">
				<input id="create-subcontract-record--subcontracts--gc_budget_line_item_id--'.$dummyRecordPrimaryKey.'" type="hidden" value="'.$gc_budget_line_item_id.'">
				<input id="create-subcontract-record--subcontracts--subcontract_sequence_number--'.$dummyRecordPrimaryKey.'" type="hidden" value="'.$subcontract_sequence_number.'">
				<input id="create-subcontract-record--subcontracts--cost_code_division_id--'.$dummyRecordPrimaryKey.'" type="hidden" value="'.$cost_code_division_id.'">
				<input id="create-subcontract-record--subcontracts--cost_code_id--'.$dummyRecordPrimaryKey.'" type="hidden" value="'.$cost_code_id.'">
				<input id="create-subcontract-record--subcontracts--subcontractor_bid_id--'.$dummyRecordPrimaryKey.'" type="hidden" value="'.$subcontractor_bid_id.'">
				'.$ddlSubcontractTemplates.'
			</td>
		</tr>
		<tr>
			<th class="textAlignRight">Subcontract Template Type:</th>
			<td>
				<span id="TemplateType--'.$dummyRecordPrimaryKey.'">No Subcontract Template Selected.</span>
				<input type="hidden" id="is_PO--'.$dummyRecordPrimaryKey.'" value="0">
				<input type="hidden" id="is_gl_account_available--'.$dummyRecordPrimaryKey.'" value="0">
				<input type="hidden" id="gl_account_id--'.$dummyRecordPrimaryKey.'" value="0">
			</td>
		</tr>
		<tr>
			<th class="textAlignRight">Subcontract Actual Value:</th>
			<td>
				<input id="create-subcontract-record--subcontracts--subcontract_actual_value--'.$dummyRecordPrimaryKey.'" class="input-subcontracted" type="text" value="'.$subcontract_actual_value.'">
			</td>
		</tr>
		<tr>
			<th class="textAlignRight">Vendor:</th>
			<td>
				'.$ddlContactCompanies.'
			</td>
		</tr>
		<tr>
			<th class="textAlignRight">Subcontract Target Execution Date:</th>
			<td>
				<input id="create-subcontract-record--subcontracts--subcontract_target_execution_date--'.$dummyRecordPrimaryKey.'" value="'.$subcontract_target_execution_date.'" class="datepicker">
			</td>
		</tr>
		<tr class="" >
			<th><span class="">W9 Form:</div>
			</th>
			<td>
			<div
			id="signed_subcontract_document_upload_"
			class="boxViewUploader"
			folder_id=""
			project_id="'.$project_id.'"
			virtual_file_path="'.$fileUploadDirectory.'Executed/"
			virtual_file_name="'.$virtual_file_name.'"
			action="/modules-gc-budget-file-uploader-ajax.php"
			method="signedSubcontractDocument"
			allowed_extensions="pdf"
			drop_text_prefix=""
			multiple="false"
			post_upload_js_callback="signedSubcontractDocumentUploaded(arrFileManagerFiles, \'tdLinkToSignedDocument\')"
			style=""></div>

			<div id="tdLinkToSignedDocument"></div>
			<input type="hidden" id="tdLinkToSignedDocument_id">

	</td>
		</tr>
		<tr class="" >
			<th></th>
			<td>
				<input type="radio" name="federal_tax_id" id="federal_tax_id" value="ein" class="w9_form_option" checked=""> EIN
				<input type="radio" name="federal_tax_id" id="federal_tax_id" value="ssn" class="w9_form_option" > SSN 
				<input type="radio" name="federal_tax_id" id="federal_tax_id" value="exempt" class="w9_form_option" > W9 exempt
			</td>
		</tr>

		<tr class="reason_class" style="display:none">
			<th class="textAlignRight">Reason:</th>
			<td>
			<textarea id="subcontract_reason" colspan="4" rowspan="4"></textarea>
			</td>
		</tr>

		<tr class="customer_project" style="display:none;">
			<th><span class="red-text current_indicator"><img src="/images/QBOlogo.png" style="height:25px; width:25px;" title="QB" alt="QB">  Customer:Project</span> <img src="/images/buttons/button-info.png" style="height: 12px;width: 16px;vertical-align: top;" class="show_info_txt">
				<div class="dropdown-content-change-order">Customer:Project can be set from the Projects Admin page in Admin menu section.</div>
			</th>
			<td>'.$qb_cust_html.' <a href="javascript:void(0);" onclick="checkprojectcustomerexist();" title="Click to Check Availability of QB" style="margin-left: 10px;"><img src="/images/refresh_icon.png" style="height:25px; width:25px;"></a></td>
		</tr>
		<tr>
			<th colspan="2" class="textAlignRight">
				<input type="button" value="Create New Subcontract" onclick="createSubcontractAndVendorAndSubcontractDocumentsAndReloadSubcontractDetailsDialogViaPromiseChain(\'create-subcontract-record\', \''.$dummyRecordPrimaryKey.'\');">
			</th>
		</tr>
	</table>
</div>

<div id="uploadProgressWindow" class="uploadResult" style="display:none;">
	<h3>FILE UPLOAD PROGRESS: <input type="button" value="Close File Progress Window" onclick="document.getElementById(\'uploadProgressWindow\').style.display=\'none\';"></h3>
	<ul id="UL-FileList" class="qq-upload-list"></ul>
	<span id="uploadProgressErrorMessage"></span>
</div>
';
	return $htmlContent;

}

function generateDynamicSubcontractDocument($database, $user_company_id, $project_id, $user_id, $userCompanyName, $gc_budget_line_item_id, $cost_code_division_id, $cost_code_id, $subcontract_id, $subcontract_item_template_id, $page_count = null,$signatory_check)
{
	$uri = Zend_Registry::get('uri');

	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

	$costCodeDivision = CostCodeDivision::findById($database, $cost_code_division_id);
	/* @var $costCodeDivision CostCodeDivision */

	$costCode = CostCode::findById($database, $cost_code_id);
	/* @var $costCode CostCode */

	$findSubcontractByIdExtendedOptions = new Input();
	$findSubcontractByIdExtendedOptions->forceLoadFlag = true;
	$subcontract = Subcontract::findSubcontractByIdExtended($database, $subcontract_id);
	$subcontract_gc_signatory = $subcontract->gc_signatory;
	$subcontract_vendor_signatory = $subcontract->vendor_signatory;
	
	/* @var $subcontract Subcontract */

	$findSubcontractItemTemplateByIdExtendedOptions = new Input();
	$findSubcontractItemTemplateByIdExtendedOptions->forceLoadFlag = true;
	$subcontractItemTemplate = SubcontractItemTemplate::findSubcontractItemTemplateByIdExtended($database, $subcontract_item_template_id);
	/* @var $subcontractItemTemplate SubcontractItemTemplate */

	$user_company_file_template_id = $subcontractItemTemplate->user_company_file_template_id;
	$userCompanyFileTemplate = UserCompanyFileTemplate::findById($database, $user_company_file_template_id);
	/* @var $userCompanyFileTemplate UserCompanyFileTemplate */
	$user_company_file_template_path = $userCompanyFileTemplate->template_path;
	$user_company_file_template_name = $userCompanyFileTemplate->template_name;

	$subcontractDocument = SubcontractDocument::findBySubcontractIdAndSubcontractItemTemplateId($database, $subcontract_id, $subcontract_item_template_id);
	/* @var $subcontractDocument SubcontractDocument */

	if (!$subcontractDocument) {
		$subcontractDocument = new SubcontractDocument($database);
		$subcontractDocument->subcontract_id = $subcontract_id;
		$subcontractDocument->subcontract_item_template_id = $subcontract_item_template_id;
		$subcontractDocument->convertPropertiesToData();
		$subcontract_document_id = $subcontractDocument->save();
		$subcontractDocument->setId($subcontract_document_id);
		$key = array(
			'subcontract_id' => $subcontract_id,
			'subcontract_item_template_id' => $subcontract_item_template_id
		);
		$subcontractDocument->setKey($key);
	}

	// @todo Add project_addresses table with coresponding code, if needed.
	// @todo Finalize this.
	$project = Project::findById($database, $project_id);
	/* @var $project Project */

	$project_type_id = $project->project_type_id;
	$user_company_id = $project->user_company_id;
	$prime_contract_file_mananager_file_id = $project->prime_contract_file_mananager_file_id;
	$user_custom_project_id = $project->user_custom_project_id;
	$project_name = $project->project_name;
	$project_owner_name = $project->project_owner_name;
	$project_latitude = $project->latitude;
	$project_longitude = $project->longitude;
	$project_address_line_1 = $project->address_line_1;
	$project_address_line_2 = $project->address_line_2;
	$project_address_line_3 = $project->address_line_3;
	$project_address_line_4 = $project->address_line_4;
	$project_address_city = $project->address_city;
	$project_address_county = $project->address_county;
	$project_address_state_or_region = $project->address_state_or_region;
	$project_address_postal_code = $project->address_postal_code;
	$project_address_postal_code_extension = $project->address_postal_code_extension;
	$project_address_country = $project->address_country;
	$building_count = $project->building_count;
	$unit_count = $project->unit_count;
	$gross_square_footage = $project->gross_square_footage;
	$is_active_flag = $project->is_active_flag;
	$public_plans_flag = $project->public_plans_flag;
	$prevailing_wage_flag = $project->prevailing_wage_flag;
	$city_business_license_required_flag = $project->city_business_license_required_flag;
	$is_active_flag = $project->is_active_flag;
	$prime_contract_execution_date = $project->prime_contract_execution_date;
	$prime_contract_notice_to_proceed_date = $project->prime_contract_notice_to_proceed_date;
	$certificate_of_occupancy_date = $project->certificate_of_occupancy_date;

	// Template Variables
	$division_number = $costCodeDivision->division_number;
	$cost_code = $costCode->cost_code;
	$cost_code_description = $costCode->cost_code_description;
	//$costCodeLabel = "{$division_number}-{$cost_code} $cost_code_description";
	$costCodeLabel = $division_number.'-'.$cost_code.' '.$cost_code_description;

	/*
	$division_number = '01';
	$cost_code = '512';
	$cost_code_description = 'Drinking Water';
	$general_contractor_company_name = 'Advent';
	$subcontract_actual_value = '30900.00';
	$vendor_company_name = 'RCI Plumbing';
	$vendor_contact_name = 'RCI Plumbing';
	$vendor_address_line_1 = '100 Circle Square';
	$vendor_address_city = 'Elko';
	$vendor_address_state_or_region = 'NV';
	$vendor_address_postal_code = '89801';
	$vendor_phone_number = '(702) 555-1234';
	$vendor_fax_number = '(702) 555-6789';
	*/

	$general_contractor_company_name = $userCompanyName;

	// Pull data for "Customer" based on currently logged in GC user
	$user = User::findUserByIdExtended($database, $user_id);
	/* @var $user User */

	// GC Contact Data
	$gcContact = $user->getPrimaryContact();
	/* @var $gcContact Contact */
	$general_contractor_contact_name = $gcContact->getContactFullName();
	$general_contractor_contact_email = $gcContact->email;

	// GC Contact Phone Number Data
	$gcContactMobilePhoneNumber = $gcContact->getMobilePhoneNumber();
	/* @var $gcContactMobilePhoneNumber MobilePhoneNumber */

	if ($gcContactMobilePhoneNumber) {
		$gcContactPhoneNumber = $gcContactMobilePhoneNumber->getContactPhoneNumber();
		/* @var $gcContactPhoneNumber ContactPhoneNumber */
		$general_contractor_contact_mobile_phone_number = $gcContactPhoneNumber->getFormattedNumber();
	} else {
		$general_contractor_contact_mobile_phone_number = '';
	}

	// GC Contact Company Data
	$gcContactCompany = $user->getPrimaryContactCompany();
	/* @var $gcContactCompany ContactCompany */
	$general_contractor_company_name = $gcContactCompany->company;

	$entity_id = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);
	$arrEntitydata = ContractingEntities::getAllcontractEntitydata($database,$entity_id);
	$EntityName = $arrEntitydata['entity'];
	$EntityLicense = $arrEntitydata['construction_license_number'];

	// GC Contact Company Office Data
	$gcContactCompanyOffice = $user->getPrimaryContactCompanyOffice();
	/* @var $gcContactCompanyOffice ContactCompanyOffice */
	/*GC logo*/
	require_once('lib/common/Logo.php');
	$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$user_company_id, true);
	$fulcrum = Logo::logoByFulcrum();
	/*GC logo end*/
	//To get contact company Office address
    $db = DBI::getInstance($database);

	$query1="SELECT id FROM `contact_companies` WHERE `user_user_company_id` = $user_company_id AND `contact_user_company_id` = $user_company_id ";
    $db->execute($query1);
    $row1=$db->fetch();
    if($row1['id']!='')
    {
    $ContactCompId=$row1['id'];
	}
	else
	{
		    $ContactCompId='';
		}
    $query2="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId and `head_quarters_flag`='Y'  order by id desc limit 1 ";
    $db->execute($query2);
    $row2=$db->fetch();
    $CompanyOfficeId=$row2['id'];
    $general_contractor_address_state_or_region = '';
    if($row2)
    {
    	if($row2['address_line_1']!='')
    		$general_contractor_address_line_1 = $row2['address_line_1'];
		if($row2['address_line_2']!='')
			$general_contractor_address_line_2 = $row2['address_line_2'];
		if($row2['address_line_3']!='')
			$general_contractor_address_line_3 =$row2['address_line_3'];
		if($row2['address_line_4']!='')
			$general_contractor_address_line_4 = $row2['address_line_4'];
		if($row2['address_city']!='')
			$general_contractor_address_city = $row2['address_city'];
		if($row2['address_county']!='')
			$general_contractor_address_state_or_region = $row2['address_county'];
		if($row2['address_state_or_region']!='')
			$general_contractor_address_postal_code = $row2['address_state_or_region'];
    }else{
        $query4="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId   order by id desc limit 1";
    	$db->execute($query4);
    	$row4 = $db->fetch();
    
    	$CompanyOfficeId=$row4['id'];
    	if($row4['address_line_1']!='')
    		$general_contractor_address_line_1 = $row4['address_line_1'];
		if($row4['address_line_2']!='')
			$general_contractor_address_line_2 = $row4['address_line_2'];
		if($row4['address_line_3']!='')
			$general_contractor_address_line_3 =$row4['address_line_3'];
		if($row4['address_line_4']!='')
			$general_contractor_address_line_4 = $row4['address_line_4'];
		if($row4['address_city']!='')
			$general_contractor_address_city = $row4['address_city'];
		if($row4['address_county']!='')
			$general_contractor_address_state_or_region = $row4['address_county'];
		if($row4['address_state_or_region']!='')
			$general_contractor_address_postal_code = $row4['address_state_or_region'];
	}


    $query3="SELECT * FROM `contact_company_office_phone_numbers` WHERE `contact_company_office_id` = $CompanyOfficeId";
    $db->execute($query3);
    
	if(!empty($row3['phone_number_type_id']) && $row3['phone_number_type_id']=='1'){
		$general_contractor_phone_number = $row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
	}else{
		$general_contractor_phone_number='';
	}
	if(!empty($row3['phone_number_type_id']) && $row3['phone_number_type_id']=='2'){
		$general_contractor_fax_number =  ' (F) '.$row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
	}else{
		$general_contractor_fax_number='';
	}

	// $general_contractor_address_line_1 = '33302 Valle Road Suite 125';
	// $general_contractor_address_line_2 = '';
	// $general_contractor_address_line_3 = '';
	// $general_contractor_address_line_4 = '';
	// $general_contractor_address_city = 'San Juan Capistrano';
	// $general_contractor_address_state_or_region = 'CA';
	// $general_contractor_address_postal_code = '92675';
	// $general_contractor_phone_number = '(949) 582-2044';
	// $general_contractor_fax_number = '(949) 582-2041';

	if ($gcContactCompanyOffice) {
		// $general_contractor_address_line_1 = $gcContactCompanyOffice->address_line_1;
		// $general_contractor_address_line_2 = $gcContactCompanyOffice->address_line_2;
		// $general_contractor_address_line_3 = $gcContactCompanyOffice->address_line_3;
		// $general_contractor_address_line_4 = $gcContactCompanyOffice->address_line_4;
		// $general_contractor_address_city = $gcContactCompanyOffice->address_city;
		// $general_contractor_address_state_or_region = $gcContactCompanyOffice->address_state_or_region;
		// $general_contractor_address_postal_code = $gcContactCompanyOffice->address_postal_code;

		$arrContactCompanyOfficePhoneNumbers = ContactCompanyOfficePhoneNumber::loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeId($database, $gcContactCompanyOffice->contact_company_office_id);
		if (!empty($arrContactCompanyOfficePhoneNumbers)) {
			$contactCompanyOfficePhoneNumber = array_shift($arrContactCompanyOfficePhoneNumbers);
			/* @var $contactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
			// $general_contractor_phone_number = $contactCompanyOfficePhoneNumber->p;
			// $general_contractor_fax_number = '(949) 582-2041';
		}
	}

	// The GC data is the "Customer" data for the subcontract
	$customer_address_line_1 = $general_contractor_address_line_1;
	$customer_address_city = $general_contractor_address_city;
	$customer_address_state_or_region = $general_contractor_address_state_or_region;
	$customer_address_postal_code = $general_contractor_address_postal_code;
	$customer_phone_number = $general_contractor_phone_number;
	$customer_fax_number = $general_contractor_fax_number;
	$customer_contact_name = $general_contractor_contact_name;
	$customer_contact_email = $general_contractor_contact_email;
	//$customer_contact_name = 'customer_contact_name';
	//$customer_contact_email = 'customer_contact_email';
	$customer_contact_phone_number = $general_contractor_phone_number;
	$customer_contact_fax_number = $general_contractor_fax_number;

	$subcontract_actual_value = $subcontract->subcontract_actual_value;
	$subcontract_actual_value = Format::formatCurrency($subcontract_actual_value);
	//signatory fields
	$gc_signatory_contactName = Contact::ContactNameById($database,$subcontract_gc_signatory);
	$vendor_signatory_contactName = Contact::ContactNameById($database,$subcontract_vendor_signatory);
	// We need the Vendor child objects for potential use so load again
	$vendor_id = (int) $subcontract->vendor_id;
	//$vendor = $subcontract->getVendor();
	if ($vendor_id) {
		$vendor = Vendor::findVendorByIdExtended($database, $vendor_id);
		/* @var $vendor Vendor */
	}

	if ($vendor) {

		$vendorContactCompany = $vendor->getVendorContactCompany();
		/* @var $vendorContactCompany ContactCompany */

		$vendorContactCompanyOffice = $vendor->getVendorContactCompanyOffice();
		/* @var $vendorContactCompanyOffice ContactCompanyOffice */

		$vendorContact = $vendor->getVendorContact();
		/* @var $vendorContact Contact */
		$vendor_License = $vendorContactCompany->construction_license_number;

		//$vendorContactAddress = $vendor->getVendorContactAddress();
		/* @var $vendorContactAddress ContactAddress */

		$subcontracted_contact_company_id = $vendor->vendor_contact_company_id;

		$vendor_company_name = '';
		$vendor_contact_name = '';
		$vendor_name = '';
		$vendor_phone_number = '';
		$vendor_mobile_phone_number = '';
		$vendor_fax_number = '';
		$vendor_address_line_1 = '';
		$vendor_address_line_2 = '';
		$vendor_address_city = '';
		$vendor_address_state_or_region = '';
		$vendor_address_postal_code = '';

		if ($vendorContactCompany) {
			$vendor_company_name = $vendorContactCompany->contact_company_name;

			if ($vendorContactCompanyOffice) {
				$vendor_address_line_1 = $vendorContactCompanyOffice->address_line_1;
				$vendor_address_line_2 = $vendorContactCompanyOffice->address_line_2;
				$vendor_address_city = $vendorContactCompanyOffice->address_city;
				$vendor_address_state_or_region = $vendorContactCompanyOffice->address_state_or_region;
				$vendor_address_postal_code = $vendorContactCompanyOffice->address_postal_code;
			} else {
				$vendor_address_line_1 = '';
				$vendor_address_city = '';
				$vendor_address_state_or_region = '';
				$vendor_address_postal_code = '';
			}

			// @todo Fix this
			$vendor_phone_number = '';
			$vendor_fax_number = '';

			$vendor_name = $vendor_company_name;
		}

		if ($vendorContact) {
			$vendor_contact_name = $vendorContact->getContactFullName();

			/*
			if ($contactAddress) {
				$vendor_address_line_1 = '100 Circle Square';
				$vendor_address_city = 'Elko';
				$vendor_address_state_or_region = 'NV';
				$vendor_address_postal_code = '89801';
			} else {
				$vendor_address_line_1 = '';
				$vendor_address_city = '';
				$vendor_address_state_or_region = '';
				$vendor_address_postal_code = '';
			}
			*/

			// @todo Fix this for any type of phone number
			$contactPhoneNumber = $vendorContact->loadMobilePhoneNumber();
			/* @var $contactPhoneNumber MobilePhoneNumber */
			$vendor_phone_number = $contactPhoneNumber->mobile_phone_number;
			$vendor_fax_number = '';

			//$vendor_name = $vendor_contact_name;
		} else {
			// @todo Add an Error message here...
			//exit;
		}
	} else {
		// @todo Add an Error message here...
		//exit;
	}

	// Potentially override all Vendor "default" data with Subcontract specific data
	$subcontractVendorContactCompanyOffice = $subcontract->getSubcontractVendorContactCompanyOffice();
	/* @var $subcontractVendorContactCompanyOffice ContactCompanyOffice */

	$subcontractVendorPhoneContactCompanyOfficePhoneNumber = $subcontract->getSubcontractVendorPhoneContactCompanyOfficePhoneNumber();
	/* @var $subcontractVendorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$subcontractVendorFaxContactCompanyOfficePhoneNumber = $subcontract->getSubcontractVendorFaxContactCompanyOfficePhoneNumber();
	/* @var $subcontractVendorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$subcontractVendorContact = $subcontract->getSubcontractVendorContact();
	/* @var $subcontractVendorContact Contact */

	$subcontractVendorContactMobilePhoneNumber = $subcontract->getSubcontractVendorContactMobilePhoneNumber();
	/* @var $subcontractVendorContactMobilePhoneNumber ContactPhoneNumber */

	if ($subcontractVendorContactCompanyOffice) {
		$vendor_address_line_1 = $subcontractVendorContactCompanyOffice->address_line_1;
		$vendor_address_line_2 = $subcontractVendorContactCompanyOffice->address_line_2;
		$vendor_address_city = $subcontractVendorContactCompanyOffice->address_city;
		$vendor_address_state_or_region = $subcontractVendorContactCompanyOffice->address_state_or_region;
		$vendor_address_postal_code = $subcontractVendorContactCompanyOffice->address_postal_code;
	}

	if ($subcontractVendorPhoneContactCompanyOfficePhoneNumber) {
		$vendor_phone_number = $subcontractVendorPhoneContactCompanyOfficePhoneNumber->getFormattedPhoneNumber();
	}

	if ($subcontractVendorFaxContactCompanyOfficePhoneNumber) {
		$vendor_fax_number = $subcontractVendorFaxContactCompanyOfficePhoneNumber->getFormattedPhoneNumber();
	}

	if ($subcontractVendorContact) {
		$vendor_contact_name = $subcontractVendorContact->getContactFullName();

		$subcontractVendorContactMobilePhoneNumberDerived = $subcontractVendorContact->loadMobilePhoneNumber();
		/* @var $subcontractVendorContactMobilePhoneNumberDerived MobilePhoneNumber */

		if ($subcontractVendorContactMobilePhoneNumberDerived) {
			$subcontractVendorContactPhoneNumberDerived = $subcontractVendorContactMobilePhoneNumberDerived->getContactPhoneNumber();
			/* @var $subcontractVendorContactPhoneNumberDerived ContactPhoneNumber */
			$vendor_mobile_phone_number = $subcontractVendorContactPhoneNumberDerived->getFormattedNumber();
			$vendor_phone_number = $vendor_mobile_phone_number;
		}
	}

	if ($subcontractVendorContactMobilePhoneNumber) {
		$vendor_mobile_phone_number = $subcontractVendorContactMobilePhoneNumber->getFormattedNumber();
		$vendor_phone_number = $vendor_mobile_phone_number;
	}

	// preferred_subcontractor_bid_flag -> subcontractor_bid_status_id <12, 13>
	// subcontractor_bid.contact_id
	// "subcontract_bidder"
	// subcontractor_bid_status: 12 = Preferred Subcontractor Bid
	// subcontractor_bid_status: 13 = Subcontract Awarded
	$subcontractor_bid_status_id = 13;
	$arrSubcontractorBids = SubcontractorBid::loadSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId($database, $gc_budget_line_item_id, $subcontractor_bid_status_id);

	if (!empty($arrSubcontractorBids)) {
		$subcontractorBid = array_shift($arrSubcontractorBids);
		/* @var $subcontractorBid SubcontractorBid */

		$bidder = $subcontractorBid->getSubcontractorContact();
		/* @var $bidder Contact */

		if ($bidder) {
			// ...

		}
	}


	$tempFilePath = File::getTempFilePath();

	// move this line up here
	// copy the file to a temp file just like a standard file upload
	$tempFilePath .= '.pdf';

	$pdf_subcontract_document_filename =  $vendor_name . ' : ' . $user_company_file_template_name . '.pdf';
	//footer content 

 $footercont = <<<END_FOOTER_CONTENT
	
	 $general_contractor_address_line_1
END_FOOTER_CONTENT;

	 if($general_contractor_address_city!='')
	 {
	 	 $footercont .= <<<END_FOOTER_CONTENT
	 	 	| $general_contractor_address_city
END_FOOTER_CONTENT;
	 }

	 if($general_contractor_address_state_or_region!='')
	 {
	 	 $footercont .= <<<END_FOOTER_CONTENT
	 	 , $general_contractor_address_state_or_region
END_FOOTER_CONTENT;
	 }
	 if($general_contractor_address_postal_code!='')
	 {
	 	 $footercont .= <<<END_FOOTER_CONTENT
	 	 $general_contractor_address_postal_code .
	     $general_contractor_phone_number
END_FOOTER_CONTENT;
	}
	 if($general_contractor_fax_number!='')
	 {
	 	 $footercont .= <<<END_FOOTER_CONTENT
	 	 $general_contractor_fax_number
END_FOOTER_CONTENT;
	 }


	ob_start();
	// Debug
	//$user_company_file_template_path = 'include/pdf-templates/uc2-contract-face.php';
	//$user_company_file_template_path = 'include/templates/subcontract-item-template-subcontract-face.php';
	require($user_company_file_template_path);
	$htmlOutput = ob_get_clean();

	// Debug
	//$tempHtmlFilePath = $tempFilePath . '.html';
	//file_put_contents ($tempHtmlFilePath, $htmlOutput);
	$config = Zend_Registry::get('config');
	$pdfSwitch = $config->pdf->document->plain_pdf_generator;

	// $pdfSwitch = 'dompdf';

	if($subcontract_item_template_id == '2')
	{
		$pdfSwitch = 'TCPDF';
	}else
	{
		 $pdfSwitch = 'dompdf';
	}
	
	if ($pdfSwitch == 'phantomJS') {

		$pdfPhantomJS = new PdfPhantomJS();
		//$pdfPhantomJS->setDebugMode(true);
		$pdfPhantomJS->writeTempFileContentsToDisk($htmlOutput);
		$pdfPhantomJS->setMargin('0px', '0px', '0px', '0px');
		// @todo Update PhantomJS library to calculate sha1 hash on new PDF and use that for temp file name
		$pdfPhantomJS->setCompletePdfFilePath($tempFilePath);
		$result = $pdfPhantomJS->execute();
		$pdfPhantomJS->deleteTempFile();

	}else if ($pdfSwitch == 'TCPDF') {
		
		$config = Zend_Registry::get('config');	
		$file_manager_base_path = $config->system->file_manager_base_path;
		$save = $file_manager_base_path.'backend/procedure/';
		//GC signatory
		$gc_filename = md5($subcontract_gc_signatory);
		$signfile_name = $save.$gc_filename.'.png';
		$signgetcontent = file_get_contents($signfile_name);
		$GCsigncheck = SubcontractDocument::checkEsignApply($database,$subcontract_id,$subcontract_item_template_id,'gc_signatory');
		if($signgetcontent !="" && (($subcontract_gc_signatory == $currentlyActiveContactId)||($GCsigncheck=='Y' )))
		{
			SubcontractDocument::UpdatesignatorySubcontractDocument($database,$subcontract_id,$subcontract_item_template_id,'gc_signatory','Y');
		}
		else
		{
			SubcontractDocument::UpdatesignatorySubcontractDocument($database,$subcontract_id,$subcontract_item_template_id,'gc_signatory','N');
		}
		//vendor signatory
		$vendor_filename = md5($subcontract_vendor_signatory);
		$vendorfile_name = $save.$vendor_filename.'.png';
		$vendorgetcontent = file_get_contents($vendorfile_name);
		$vendorsigncheck = SubcontractDocument::checkEsignApply($database,$subcontract_id,$subcontract_item_template_id,'vendor_signatory');
		if($vendorgetcontent !="" && (($subcontract_vendor_signatory == $currentlyActiveContactId) || ($vendorsigncheck =='Y')))
		{
			SubcontractDocument::UpdatesignatorySubcontractDocument($database,$subcontract_id,$subcontract_item_template_id,'vendor_signatory','Y');
		}else
		{
			SubcontractDocument::UpdatesignatorySubcontractDocument($database,$subcontract_id,$subcontract_item_template_id,'vendor_signatory','N');
		}

		if($signatory_check == "N" )
		{
			SubcontractDocument::UpdatesignatorySubcontractDocument($database,$subcontract_id,$subcontract_item_template_id,'gc_signatory','N');
			SubcontractDocument::UpdatesignatorySubcontractDocument($database,$subcontract_id,$subcontract_item_template_id,'vendor_signatory','N');
		}

		//Header Logo
		$gcLogoforTCPDF = Logo::logoByUserCompanyIDForTCPDF($database,$user_company_id);
		ob_start();
		
		// Include the main TCPDF library (search for installation path).

		require_once('esignature/TCPDF-master/examples/tcpdf_include.php');
		require_once('esignature/TCPDF-master/tcpdf.php');
		
		// Extend the TCPDF class to create custom Header and Footer
		class MYPDF extends TCPDF {

			 public $vendorcontent ;//<-- to save your data
			 public $GCFilecontact ;
			 public $footertext ;

			 function setImag($vendorcontent){
			 	$this->vendor = $vendorcontent;
			 }

			 function getImag(){
			 	echo $this->vendor ."<br/>";
			 }
			 function setGCcont($GCFilecontact){
			 	$this->GC = $GCFilecontact;
			 }

			 function getGCcont(){
			 	echo $this->GC ."<br/>";
			 }
			  function setfootercont($footertext){
			 	$this->foottext = $footertext;
			 }

			 function getfootercont(){
			 	echo $this->foottext ."<br/>";
			 }

    		 //Page header
			 public function Header() {
			 	if ($this->page == 1) {

			 		$this->Image('@'.$this->GC, 10, 10, 130, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			 	}
			 }

    		// Page footer
			 public function Footer() {

			 	// $pdf->writeHTMLCell(0, 0, 60, 265, $footertext,  0,0, false, true,  '', 0, false, 'T', 'M');
			 	 $this->Cell(230, 10, $this->foottext, 0, false, 'C', 0, '', 0, false, 'T', 'M');

			 	$logo = $this->Image('@'.$this->vendor,150, 275, 20,20, 'PNG');
			 	// $this->Cell(200,100, $logo, 100, 200, 'C');
			 }
			}

		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// $pdf->setImag($vendorgetcontent);
		// $pdf->getImag();
		$pdf->setGCcont($gcLogoforTCPDF);
		$pdf->getGCcont();
		$pdf->setfootercont($footercont);
		$pdf->getfootercont();
		
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Fulcrum');
		// $pdf->SetTitle('TCPDF Example 052');
		// $pdf->SetSubject('TCPDF Tutorial');
		// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$dirpath  =  __DIR__;
		$dir = str_replace("\\", "/", $dirpath);

		$certificate ="file://".realpath($dir."/esignature/data/cert/Fulcrum.pem");
		$certificate = str_replace("\\", "/", $certificate);
	


	// set margins
	// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		
		// set additional information
		// $info = array(
		// 	'Name' => 'TCPDF',
		// 	'Location' => 'Office',
		// 	'Reason' => 'Testing TCPDF',
		// 	'ContactInfo' => 'http://www.tcpdf.org',
		// 	);

		// set document signature
		$pdf->setSignature($certificate, $certificate, 'tcpdfdemo', '', 2);

		// $pdf->setSignature($certificate, $certificate, 'tcpdfdemo', '', 2, $info);

		// add a page
		$pdf->AddPage();

		$pdf->writeHTML($htmlOutput, true, 0, true, 0);
		//footer
		// $pdf->writeHTMLCell(0, 0, 60, 265, $footertext,  0,0, false, true,  '', 0, false, 'T', 'M');
		// $this->writeHTMLCell(0, 0, '', '', $footertext, 0, 0, false,true, "L", true);
		
		// $pdf->Image('@'.$gcLogoforTCPDF,10, 10, 100, 25, 'PNG');
		// to add the signature
		if($signatory_check == "Y" )
		{
			$date = date('m/d/Y');
			$vendor = '<span style="font-size:10px;">vendor-sign  :'.$vendor_signatory_contactName.'</span>';
			$dategenerated = '<span style="font-size:10px;">'.$date.'</span>';
			$pdf->writeHTMLCell(0, 0, 18, 240, $vendor,  0,0, false, true,  '', 0, false, 'T', 'M');
			if(($subcontract_vendor_signatory == $currentlyActiveContactId) || ($vendorsigncheck =='Y'))
			{
			$pdf->Image('@'.$vendorgetcontent,20, 250, 20, 15, 'PNG');
			$pdf->setSignatureAppearance(20, 250, 20, 15);
			}
			$pdf->writeHTMLCell(0, 0, 20, 265, $dategenerated,  0,0, false, true,  '', 0, false, 'T', 'M');


			//GC
			$GC = '<span style="font-size:10px;" align="right">GC-sign :'.$gc_signatory_contactName.'</span>';
			$pdf->writeHTMLCell(0, 0, 150, 240,$GC,  0,0, false, true,  '', 0, false, 'T', 'M');
			if(($subcontract_gc_signatory == $currentlyActiveContactId)||($GCsigncheck=='Y' ))
			{
			$pdf->Image('@'.$signgetcontent ,175, 250, 20, 15, 'PNG');
			$pdf->setSignatureAppearance(175, 250, 20, 15);
			}
			$pdf->writeHTMLCell(0, 0, 175, 265, $dategenerated,  0,0, false, true,  '', 0, false, 'T', 'M');
			
			
		}

		



		//Close and output PDF document
		ob_end_clean();
		//For saving the file in TCPDF 'F' is used
		$pdf_content =$pdf->Output($tempFilePath, 'F');
	}
	 else {

		// switch to use dompdf for pdf file generation
		$dompdf = new DOMPDF();
		$dompdf->load_html($htmlOutput);
		$dompdf->set_paper("letter", "portrait");
		$dompdf->render();
		$pdf_content = $dompdf->output();
		// so to test which one is being used.
		// for debugging
		// trigger_error('calling dompdf', E_USER_WARNING);
		// Debug
		//$tempPath = 'C:/dev/build/advent-sites/branches/development/www/www.axis.com/test.pdf';
		//$pdf_content = file_get_contents($tempPath);

		// copy the file to a temp file just like a standard file upload
		//$tempFilePath .= '.pdf';
		//$tempFileName = File::getTempFileName();
		//$tempFilePath = $tempFilePath.$tempFileName;
		file_put_contents ($tempFilePath, $pdf_content);

	}

	// Debug
	//exit;

	/*
	// Debug
	ob_flush();
	flush();
	exit;
	*/

	// Debug
	/*
	$tempFilePath = 'C:\dev\build\advent-sites\branches\development\localdev_file_manager\temp/52abb0ae589bc.pdf';
	$pdfFilepath = 'C:\dev\build\advent-sites\branches\development\localdev_file_manager\temp/';
	$pdfFilename = '52abb0ae589bc.pdf';

	$arrPdfMetadata = Pdf::getPdfMetadata($pdfFilepath, $pdfFilename);
	$page_count = $arrPdfMetadata['page_count'];
	exit;
	*/

	// sha1 hash and file size
	$sha1 = sha1_file($tempFilePath);
	$size = filesize($tempFilePath);

	/*
	if (function_exists('mb_strlen')) {
		$size = mb_strlen($pdf_content, '8bit');
	} else {
		$size = strlen($pdf_content);
	}
	*/


	/*
	// Debug
	$putdata = fopen("php://input", "r");

	// Open a file for writing
	$fp = fopen($tempFilePath, "wb");

	// Read the data 1 KB at a time and write to the file
	while ($data = fread($putdata, 1024)) {
		fwrite($fp, $data);
		fflush($fp);
	}

	// Close the streams
	fclose($fp);
	fclose($putdata);
	*/


	$fileExtension = 'pdf';
	$virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);

	// @todo Upload file to cloud / Amazon S3
	//file_put_contents('./test.pdf', $pdf_content);

	// Convert file content to File object
	$error = null;
	$virtual_file_name = $pdf_subcontract_document_filename;

	$file = new File();
	$file->sha1 = $sha1;
	//$file->form_input_name = $formFileInputName;
	//$file->error = $error;
	$file->name = $virtual_file_name;
	$file->size = $size;
	//$file->tmp_name = $tmp_name;
	$file->type = $virtual_file_mime_type;
	$file->tempFilePath = $tempFilePath;
	$file->fileExtension = $fileExtension;

	//$arrFiles = File::parseUploadedFiles();
	$file_location_id = FileManager::saveUploadedFileToCloud($database, $file);

	// Delete temp file if it was not deleted by  FileManager::saveUploadedFileToCloud(...)
	if (is_file($tempFilePath)) {
		unlink($tempFilePath);
	}

	// Folder
	// Save the file_manager_folders record (virtual_file_path) to the db and get the id
	$subcontractDocumentFoldername = "/Subcontracts/$costCodeLabel/Unsigned/";
	if ($subcontractDocumentFoldername != '/') {
		// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
		$arrFolders = preg_split('#/#', $subcontractDocumentFoldername, -1, PREG_SPLIT_NO_EMPTY);
		$currentVirtualFilePath = '/';
		foreach ($arrFolders as $folder) {
			$tmpVirtualFilePath = array_shift($arrFolders);
			$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
			// Save the file_manager_folders record (virtual_file_path) to the db and get the id
			$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, $project_id, $currentVirtualFilePath);
			$newlycreated = $fileManagerFolder->getVirtualFilePathDidNotExist();
			if($newlycreated)
			{
				//To set the permission for all subfolders within daliy log
				$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;
				$parentFol= $fileManagerFolder->getParentFolderId();
				FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parentFol);
			}


		}
			}


	// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
	/* @var $fileManagerFolder FileManagerFolder */
	$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

	// Rename file...for replace case???
	//$virtual_file_name = $file_type_name . " - Old (Uploaded " .$previous_date_added. ").pdf";

	// save the file information to the file_manager_files db table
	$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $user_company_id, $currentlyActiveContactId, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
	/* @var $fileManagerFolder FileManagerFolder */
	$file_manager_file_id = $fileManagerFile->file_manager_file_id;

	// Update $subcontractDocument
	$data = $subcontractDocument->getData();
	$newData = array('unsigned_subcontract_document_file_manager_file_id' => $file_manager_file_id);
	if(($signgetcontent !="") || ($vendorgetcontent !=""))
	{
		$newData['signed_subcontract_document_file_manager_file_id'] = $file_manager_file_id;
	}
	$subcontractDocument->setData($newData);
	$subcontractDocument->save();

	// Set Permissions of the file to match the parent folder.

	FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);

	$subcontractDocument->setUnsignedSubcontractDocumentFileManagerFile($fileManagerFile);

	$subcontractDocument->convertDataToProperties();

	return $subcontractDocument;
}

function buildSubcontractDetailsWidget($database, $user_company_id, $subcontract_id)
{
	$subcontract = Subcontract::findSubcontractByIdExtended($database, $subcontract_id);
	if (!$subcontract) {
		return '';
	}
	$gc_budget_line_item_id = $subcontract->gc_budget_line_item_id;

	// Get the GC Data Options
	$arrSubcontractTemplates = SubcontractTemplate::loadSubcontractTemplatesByUserCompanyId($database, $user_company_id);

	// GC Contact Company
	$gCContactCompany = ContactCompany::findContactCompanyByUserCompanyIdValues($database, $user_company_id, $user_company_id);
	$gc_contact_company_id = $gCContactCompany->contact_company_id;

	// GC Contact Company Offices List
	//$arrGCContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $gc_contact_company_id);
	$loadContactCompanyOfficesByContactCompanyIdOptions = new Input();
	$loadContactCompanyOfficesByContactCompanyIdOptions->forceLoadFlag = true;
	$arrGCContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $gc_contact_company_id, $loadContactCompanyOfficesByContactCompanyIdOptions);

	// GC Contacts List
	$loadContactsByContactCompanyIdOptions = new Input();
	$loadContactsByContactCompanyIdOptions->forceLoadFlag = true;
	$arrGCContacts = Contact::loadContactsByContactCompanyId($database, $gc_contact_company_id, $loadContactsByContactCompanyIdOptions);

	/*
	$tmpContact = new Contact($database);
	$data = array(
		'id' => 0,
		'first_name' => 'Please Choose',
		'last_name' => ' A Contact'
	);
	$tmpContact->setData($data);
	$tmpContact->contact_id = 0;
	$tmpContact->first_name = 'Please Choose';
	$tmpContact->last_name = ' A Contact';
	$arrTmpGCContacts = array(0 => $tmpContact);
	$arrGCContacts = $arrTmpGCContacts + $arrGCContacts;
	*/

	// Vendors List
	$arrVendorContactCompanies = ContactCompany::loadContactCompaniesByUserUserCompanyId($database, $user_company_id);

	// Default to null
	$vendor_contact_company_id = null;

	$subcontract_sequence_number = $subcontract->subcontract_sequence_number;
	$subcontractor_bid_id = $subcontract->subcontractor_bid_id;
	$subcontract_template_id = $subcontract->subcontract_template_id;

	// Subcontract GC Data
	$subcontract_gc_contact_company_office_id = $subcontract->subcontract_gc_contact_company_office_id;
	$subcontract_gc_phone_contact_company_office_phone_number_id = $subcontract->subcontract_gc_phone_contact_company_office_phone_number_id;
	$subcontract_gc_fax_contact_company_office_phone_number_id = $subcontract->subcontract_gc_fax_contact_company_office_phone_number_id;
	$subcontract_gc_contact_id = $subcontract->subcontract_gc_contact_id;
	$subcontract_gc_signatory = $subcontract->gc_signatory;
	$subcontract_gc_contact_mobile_phone_number_id = $subcontract->subcontract_gc_contact_mobile_phone_number_id;

	// Subcontract Vendor Data
	$vendor_id = $subcontract->vendor_id;
	$subcontract_vendor_contact_company_office_id = $subcontract->subcontract_vendor_contact_company_office_id;
	$subcontract_vendor_phone_contact_company_office_phone_number_id = $subcontract->subcontract_vendor_phone_contact_company_office_phone_number_id;
	$subcontract_vendor_fax_contact_company_office_phone_number_id = $subcontract->subcontract_vendor_fax_contact_company_office_phone_number_id;
	$subcontract_vendor_contact_id = $subcontract->subcontract_vendor_contact_id;
	$vendor_signatory = $subcontract->vendor_signatory;
	$subcontract_vendor_contact_mobile_phone_number_id = $subcontract->subcontract_vendor_contact_mobile_phone_number_id;

	$unsigned_subcontract_file_manager_file_id = $subcontract->unsigned_subcontract_file_manager_file_id;
	$signed_subcontract_file_manager_file_id = $subcontract->signed_subcontract_file_manager_file_id;
	$subcontract_forecasted_value = $subcontract->subcontract_forecasted_value;
	$subcontract_actual_value = $subcontract->subcontract_actual_value;
	$subcontract_retention_percentage = $subcontract->subcontract_retention_percentage;
	$subcontract_issued_date = $subcontract->subcontract_issued_date;
	$subcontract_target_execution_date = $subcontract->subcontract_target_execution_date;
	$subcontract_execution_date = $subcontract->subcontract_execution_date;
	$active_flag = $subcontract->active_flag;

	// Foreign key objects
	$subcontractTemplate = $subcontract->getSubcontractTemplate();
	/* @var $subcontractTemplate SubcontractTemplate */
	$subcontract_template_id = $subcontractTemplate->subcontract_template_id;

	// Vendor Foreign Key Objects
	//$vendor = Vendor::findById($database, $vendor_id);
	$vendor = $subcontract->getVendor();
	/* @var $vendor Vendor */

	$vendor_company_name = '';
	if ($vendor) {

		$vendorContactCompany = $vendor->getVendorContactCompany();
		/* @var $vendorContactCompany ContactCompany */

		if ($vendorContactCompany) {
			$vendor_company_name = $vendorContactCompany->contact_company_name;
		}

		$vendorContactCompanyOffice = $vendor->getVendorContactCompanyOffice();
		/* @var $vendorContactCompanyOffice ContactCompanyOffice */

		$vendorContact = $vendor->getVendorContact();
		/* @var $vendorContact Contact */

		//$vendorContactAddress = $vendor->getVendorContactAddress();
		/* @var $vendorContactAddress ContactAddress */

		if (isset($vendorContact) && $vendorContact && ($vendorContact instanceof Contact)) {
			if (!isset($subcontract_vendor_contact_id) || empty($subcontract_vendor_contact_id)) {
				$subcontract_vendor_contact_id = $vendorContact->contact_id;
			} else {
				//$subcontract_vendor_contact_id = false;
			}
		}

		$vendor_contact_company_id = $vendor->vendor_contact_company_id;

	} else {
		$vendor_contact_company_id = null;
	}

	// Potentially override all Vendor "default" data with Subcontract specific data
	$subcontractVendorContactCompanyOffice = $subcontract->getSubcontractVendorContactCompanyOffice();
	/* @var $subcontractVendorContactCompanyOffice ContactCompanyOffice */

	$subcontractVendorPhoneContactCompanyOfficePhoneNumber = $subcontract->getSubcontractVendorPhoneContactCompanyOfficePhoneNumber();
	/* @var $subcontractVendorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$subcontractVendorFaxContactCompanyOfficePhoneNumber = $subcontract->getSubcontractVendorFaxContactCompanyOfficePhoneNumber();
	/* @var $subcontractVendorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

	$subcontractVendorContact = $subcontract->getSubcontractVendorContact();
	/* @var $subcontractVendorContact Contact */

	$subcontractVendorContactMobilePhoneNumber = $subcontract->getSubcontractVendorContactMobilePhoneNumber();
	/* @var $subcontractVendorContactMobilePhoneNumber ContactPhoneNumber */

	// ddl: subcontract_templates
	// attributeGroupName + '--subcontracts--subcontract_template_id--' + uniqueId
	// onclick="loadSubcontractItemTemplatesBySubcontractTemplateId(\'ddl--subcontracts--subcontract_template_id\', \'subcontract_templates_to_subcontract_item_templates--container\');"
	$ddlElementId = 'manage-subcontract-record--subcontracts--subcontract_template_id--'.$subcontract_id;
	$ddlSubcontractTemplates = PageComponents::dropDownListFromObjects($ddlElementId, $arrSubcontractTemplates, 'subcontract_template_id', null, 'subcontract_template_name', null, $subcontract_template_id, null, 'onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);" disabled="true"', '<option value="">Please Select A Subcontract Template</option>');

	//To check the company id already created
	if($subcontract_gc_contact_company_office_id)
	{
		$hascompanyid=true;
	}else
	{
		$hascompanyid=false;
	}
	$subcontractGcOfficeIdSet = true;
	if (!isset($subcontract_gc_contact_company_office_id) || empty($subcontract_gc_contact_company_office_id)) {
		$subcontractGcOfficeIdSet = false;
		if (isset($arrGCContactCompanyOffices) && !empty($arrGCContactCompanyOffices)) {
			$arrGCContactCompanyOfficesTmp = $arrGCContactCompanyOffices;
			$tmp = array_shift($arrGCContactCompanyOfficesTmp);
			// Get this value to load phone numbers
			// $subcontract_gc_contact_company_office_id = $tmp->contact_company_office_id;
		}
	}

	if (!empty($arrGCContactCompanyOffices)) {
		if (isset($arrGCContactCompanyOffices[$subcontract_gc_contact_company_office_id])) {
			$currentlySelectedGCContactCompanyOffice = $arrGCContactCompanyOffices[$subcontract_gc_contact_company_office_id];

			// Phone Numbers
			/* @var $businessPhoneNumber ContactCompanyOfficePhoneNumber */
			/* @var $businessFaxNumber ContactCompanyOfficePhoneNumber */
			/*
			$businessPhoneNumber = $currentlySelectedGCContactCompanyOffice->getBusinessPhoneNumber();
			if ($businessPhoneNumber) {
				$business_phone_id  = $businessPhoneNumber->contact_company_office_phone_number_id;
				$formattedBusinessPhoneNumber = $businessPhoneNumber->getFormattedPhoneNumber();
			} else {
				$ddlGCOfficePhoneNumbers = '<select disabled><option>Please Add An Office Phone Number</option></select>';
			}

			$businessFaxNumber = $currentlySelectedGCContactCompanyOffice->getBusinessFaxNumber();
			if ($businessFaxNumber) {
				$business_fax_id  = $businessFaxNumber->contact_company_office_phone_number_id;
				$formattedBusinessFaxNumber = $businessFaxNumber->getFormattedPhoneNumber();
			}
			*/

		}
	}
	//To make the GC office selectable
	$update_value='0'; $classup="";
	if(!$hascompanyid)
		{ 
			
			$officecount=count($arrGCContactCompanyOffices);
			if($officecount=='1')
			{
				list($first_key) = each($arrGCContactCompanyOffices);
				$subcontract_gc_contact_company_office_id=$first_key;
				$update_value='1';
				$classup = "allfieldupdate";
			}
		}
	// ddl: subcontract_gc_contact_company_office_id
	$ddlElementId = 'manage-subcontract-record--subcontracts--subcontract_gc_contact_company_office_id--'.$subcontract_id;
	$gcOfficeGroupName = 'manage-subcontract-record--subcontracts--subcontract_gc_contact_company_office_id--';
	// getFormattedOfficeAddress()
	if ($subcontractGcOfficeIdSet) {
		$ddlGCContactCompanyOffices = PageComponents::dropDownListFromObjects($ddlElementId, $arrGCContactCompanyOffices, 'contact_company_office_id', null, null, 'getFormattedOfficeAddress', $subcontract_gc_contact_company_office_id, null, 'class="'.$classup.'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select An Office</option>');
	} else {
		$ddlGCContactCompanyOffices = PageComponents::dropDownListFromObjects($ddlElementId, $arrGCContactCompanyOffices, 'contact_company_office_id', null, null, 'getFormattedOfficeAddress', $subcontract_gc_contact_company_office_id, null, 'class="'.$classup.'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select An Office</option>');
	}
	$gcOfficePhoneNumberGroupName = $gcOfficeFaxNumberGroupName ='';
	if ($subcontractGcOfficeIdSet && isset($subcontract_gc_contact_company_office_id) && !empty($subcontract_gc_contact_company_office_id)) {
		// GC Office Phone Numbers
		$loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions = new Input();
		$loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions->forceLoadFlag = true;
		$arrGCContactCompanyOfficePhoneNumbers = ContactCompanyOfficePhoneNumber::loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId($database, $subcontract_gc_contact_company_office_id, PhoneNumberType::BUSINESS, $loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions);

		$ddlGCOfficePhoneNumbersElementId = 'manage-subcontract-record--subcontracts--subcontract_gc_phone_contact_company_office_phone_number_id--'.$subcontract_id;
		$gcOfficePhoneNumberGroupName = 'manage-subcontract-record--subcontracts--subcontract_gc_phone_contact_company_office_phone_number_id--';
		if (!empty($arrGCContactCompanyOfficePhoneNumbers)) {
			$gcPhoneNumberCount = 1;
			if($subcontract_gc_phone_contact_company_office_phone_number_id =="")
			{
			list($first_key) = each($arrGCContactCompanyOfficePhoneNumbers);
			$subcontract_gc_phone_contact_company_office_phone_number_id=$first_key;
			$classgcph ="allfieldupdate";
			}else
			{
				$classgcph ="";
			}

			$ddlGCOfficePhoneNumbers = PageComponents::dropDownListFromObjects($ddlGCOfficePhoneNumbersElementId, $arrGCContactCompanyOfficePhoneNumbers, 'contact_company_office_phone_number_id', null, null, 'getFormattedPhoneNumber', $subcontract_gc_phone_contact_company_office_phone_number_id, null, 'class="'.$classgcph.'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select An Office Phone Number</option>');
		} else {
			$gcPhoneNumberCount = 0;
			$ddlGCOfficePhoneNumbers = '<select id="'.$ddlGCOfficePhoneNumbersElementId.'"><option value="">Please Add An Office Phone Number</option></select>';
		}

		// GC Office Fax Numbers
		$loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions = new Input();
		$loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions->forceLoadFlag = true;
		$arrGCContactCompanyOfficeFaxNumbers = ContactCompanyOfficePhoneNumber::loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId($database, $subcontract_gc_contact_company_office_id, PhoneNumberType::BUSINESS_FAX, $loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions);

		$ddlGCOfficeFaxNumbersElementId = 'manage-subcontract-record--subcontracts--subcontract_gc_fax_contact_company_office_phone_number_id--'.$subcontract_id;
		$gcOfficeFaxNumberGroupName = 'manage-subcontract-record--subcontracts--subcontract_gc_fax_contact_company_office_phone_number_id--';

		if (!empty($arrGCContactCompanyOfficeFaxNumbers)) {
			$gcFaxNumberCount = 1;

			if($subcontract_gc_fax_contact_company_office_phone_number_id =="")
			{
			list($first_key) = each($arrGCContactCompanyOfficeFaxNumbers);
			$subcontract_gc_fax_contact_company_office_phone_number_id=$first_key;
			$classgcfax ="allfieldupdate";
			}else
			{
				$classgcfax ="";
			}

			$ddlGCOfficeFaxNumbers = PageComponents::dropDownListFromObjects($ddlGCOfficeFaxNumbersElementId, $arrGCContactCompanyOfficeFaxNumbers, 'contact_company_office_phone_number_id', null, null, 'getFormattedPhoneNumber', $subcontract_gc_fax_contact_company_office_phone_number_id, null, 'class="'.$classgcfax.'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select An Office Fax Number</option>');
		} else {
			$gcFaxNumberCount = 0;
			$ddlGCOfficeFaxNumbers = '<select id="'.$ddlGCOfficeFaxNumbersElementId.'"><option value="">Please Add An Office Fax Number</option></select>';
		}

		// Disabled attributes for popovers.
		$addGcContactCompanyOfficePhoneNumberPopoverDisabled = '';
		$addGcContactCompanyOfficeFaxNumberPopoverDisabled = '';
	} else {
		if (empty($ddlGCContactCompanyOffices)) {
			$ddlGCContactCompanyOffices = '<select disabled><option>Please Add An Office</option></select>';
			$ddlGCOfficePhoneNumbers = '<select disabled><option>Please Add An Office</option></select>';
			$ddlGCOfficeFaxNumbers = '<select disabled><option>Please Add An Office</option></select>';
		} else {
			$ddlGCOfficePhoneNumbers = '<select disabled><option value="">Please Select An Office Above</option></select>';
			$ddlGCOfficeFaxNumbers = '<select disabled><option value="">Please Select An Office Above</option></select>';
		}
		$gcPhoneNumberCount = 0;
		$gcFaxNumberCount = 0;

		$addGcContactCompanyOfficePhoneNumberPopoverDisabled = 'disabled';
		$addGcContactCompanyOfficeFaxNumberPopoverDisabled = 'disabled';
	}

	// ddl: subcontract_gc_contact_id
	$gcMobileGroupName = '';
	$gcMobileNumberCount = 0;
	if (isset($arrGCContacts) && !empty($arrGCContacts)) {
		// Select the default contact record
		if (isset($subcontract_gc_contact_id) && !empty($subcontract_gc_contact_id)) {
			$ddlElementId = 'manage-subcontract-record--subcontracts--subcontract_gc_contact_id--'.$subcontract_id;
			$ddlGCContacts = PageComponents::dropDownListFromObjects($ddlElementId, $arrGCContacts, 'contact_id', null, null, 'getContactFullName', $subcontract_gc_contact_id, null, 'onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select A Contact</option>');

			// Contact Mobile Phone Numbers
			$loadMobilePhoneNumbersByContactIdOptions = new Input();
			$loadMobilePhoneNumbersByContactIdOptions->forceLoadFlag = true;
			$arrGCContactMobilePhoneNumbers = MobilePhoneNumber::loadMobilePhoneNumbersByContactId($database, $subcontract_gc_contact_id, $loadMobilePhoneNumbersByContactIdOptions);

			//$arrGCContactMobilePhoneNumbersActual = array(0 => 'Please Select A Mobile Phone Number');
			

			// ddl: subcontract_gc_contact_mobile_phone_number_id
			$ddlElementId = 'manage-subcontract-record--subcontracts--subcontract_gc_contact_mobile_phone_number_id--'.$subcontract_id;
			$gcMobileGroupName = 'manage-subcontract-record--subcontracts--subcontract_gc_contact_mobile_phone_number_id--';	
			if (!empty($arrGCContactMobilePhoneNumbers)) {
				$gcMobileNumberCount = 1;

				if($subcontract_gc_contact_mobile_phone_number_id == "" )
				{
					list($first_key) = each($arrGCContactMobilePhoneNumbers);
					$subcontract_gc_contact_mobile_phone_number_id=$first_key;
					$classgcCon ="allfieldupdate";
		
				}else
				{
					$classgcCon ="";
				}
				$ddlGCContactMobilePhoneNumbers = PageComponents::dropDownList($ddlElementId, $arrGCContactMobilePhoneNumbers,$subcontract_gc_contact_mobile_phone_number_id, null, 'class="'.$classgcCon.'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', null,'<option value="">Please Select A Mobile Phone Number</option>');
			} else {
				$gcMobileNumberCount = 0;
				$ddlGCContactMobilePhoneNumbers = '<select id="'.$ddlElementId.'"><option>Please Add A Contact Mobile Phone Number</option></select>';
			}

			$addGcContactMobilePhoneNumberPopoverDisabled = '';
		} else {
			$ddlElementId = 'manage-subcontract-record--subcontracts--subcontract_gc_contact_id--'.$subcontract_id;
			$ddlGCContacts = PageComponents::dropDownListFromObjects($ddlElementId, $arrGCContacts, 'contact_id', null, null, 'getContactFullName', '', null, 'onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select A Contact</option>');
			$ddlGCContactMobilePhoneNumbers = '<select disabled><option>Please Select A Contact Above</option></select>';
			$addGcContactMobilePhoneNumberPopoverDisabled = 'disabled';
		}
	} else {
		$ddlGCContacts = '<select disabled><option>Please Add A Contact</option></select>';
		$ddlGCContactMobilePhoneNumbers = '<select disabled><option>Please Add A Contact Mobile Phone Number</option></select>';
		$addGcContactMobilePhoneNumberPopoverDisabled = 'disabled';
	}

	//GC signatory
	if (isset($arrGCContacts) && !empty($arrGCContacts)) {
		// Select the default contact record
		if (isset($subcontract_gc_signatory) && !empty($subcontract_gc_signatory)) {
			$ddlElementId = 'manage-subcontract-record--subcontracts--gc_signatory--'.$subcontract_id;
			$ddlGCsignatory = PageComponents::dropDownListFromObjects($ddlElementId, $arrGCContacts, 'contact_id', null, null, 'getContactFullName', $subcontract_gc_signatory, null, 'onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select A GC Signatory</option>');
	
		} else {
			$ddlElementId = 'manage-subcontract-record--subcontracts--gc_signatory--'.$subcontract_id;
			$ddlGCsignatory = PageComponents::dropDownListFromObjects($ddlElementId, $arrGCContacts, 'contact_id', null, null, 'getContactFullName', '', null, 'onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select A GC Signatory</option>');
			$ddlGCContactMobilePhoneNumbers = '<select disabled><option>Please Select A Contact Above</option></select>';
			$addGcContactMobilePhoneNumberPopoverDisabled = 'disabled';
		}
	} else {
		$ddlGCsignatory = '<select disabled><option>Please Add A GC Signatory</option></select>';
		$ddlGCContactMobilePhoneNumbers = '<select disabled><option>Please Add A Contact Mobile Phone Number</option></select>';
		$addGcContactMobilePhoneNumberPopoverDisabled = 'disabled';
	}

	//End of GC signatory

	// ddl: vendor_contact_company_id
	$addVendorCompanyOption = 'manage-subcontract-record--subcontracts--vendor_contact_company_id--';
	$ddlElementId = 'manage-subcontract-record--subcontracts--vendor_contact_company_id--'.$subcontract_id;
	$ddlVendorContactCompanies = PageComponents::dropDownListFromObjects($ddlElementId, $arrVendorContactCompanies, 'contact_company_id', null, 'company', null, $vendor_contact_company_id, null, 'onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select A Vendor</option>');

	// ddl: vendor_contact_company_office_id
	//$ddlVendorContactCompanyOffices = '';
	if (isset($vendor_contact_company_id) && !empty($vendor_contact_company_id)) {
		// Load offices list for the given vendor
		$loadContactCompanyOfficesByContactCompanyIdOptions = new Input();
		$loadContactCompanyOfficesByContactCompanyIdOptions->forceLoadFlag = true;
		$arrVendorContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $vendor_contact_company_id, $loadContactCompanyOfficesByContactCompanyIdOptions);

		$subcontractVendorOfficeIdSet = true;
		if (!isset($subcontract_vendor_contact_company_office_id) || empty($subcontract_vendor_contact_company_office_id)) {
			if (isset($vendorContactCompanyOffice) && $vendorContactCompanyOffice && ($vendorContactCompanyOffice instanceof ContactCompanyOffice)) {
				$subcontract_vendor_contact_company_office_id = $vendorContactCompanyOffice->contact_company_office_id;
			} else {
				$subcontractVendorOfficeIdSet = false;
				if (isset($arrVendorContactCompanyOffices) && !empty($arrVendorContactCompanyOffices)) {
					$arrVendorContactCompanyOfficesTmp = $arrVendorContactCompanyOffices;
					$tmp = array_shift($arrVendorContactCompanyOfficesTmp);
					// Get this value to load phone numbers
					$subcontract_vendor_contact_company_office_id = $tmp->contact_company_office_id;
				}
			}
		}

		//To make the vendor office selectable
		$classven="";
		if($subcontract_vendor_contact_company_office_id =="")
		{
		$venofficecount=count($arrVendorContactCompanyOffices);
		if($venofficecount=='1')
		{
			list($first_key) = each($arrVendorContactCompanyOffices);
			$subcontract_vendor_contact_company_office_id=$first_key;
			$classven = "allfieldupdate";
		}
		}
		

		$ddlElementId = 'manage-subcontract-record--subcontracts--subcontract_vendor_contact_company_office_id--'.$subcontract_id;
		$officeAddressGroupName = 'manage-subcontract-record--subcontracts--subcontract_vendor_contact_company_office_id--';
		if ($subcontractVendorOfficeIdSet) {
			$ddlVendorContactCompanyOffices = PageComponents::dropDownListFromObjects($ddlElementId, $arrVendorContactCompanyOffices, 'contact_company_office_id', null, null, 'getFormattedOfficeAddress', $subcontract_vendor_contact_company_office_id, null, 'class="'.$classven.'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select An Office</option>');
		} else if (empty($arrVendorContactCompanyOffices)) {
			$ddlVendorContactCompanyOffices = '<select id="'.$ddlElementId.'"><option value="">Please Add A Vendor Office</option></select>';
		} else {
			$ddlVendorContactCompanyOffices = PageComponents::dropDownListFromObjects($ddlElementId, $arrVendorContactCompanyOffices, 'contact_company_office_id', null, null, 'getFormattedOfficeAddress', null, null, 'onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select A Vendor Office</option>');
		}
		$gcVendorOfficeFaxNumbersGroupName = $gcVendorOfficePhoneNumbersGroupName = '';
		if ($subcontractVendorOfficeIdSet && isset($subcontract_vendor_contact_company_office_id) && !empty($subcontract_vendor_contact_company_office_id)) {
			$loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions = new Input();
			$loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions->forceLoadFlag = true;
			$arrVendorContactCompanyOfficePhoneNumbers = ContactCompanyOfficePhoneNumber::loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId($database, $subcontract_vendor_contact_company_office_id, PhoneNumberType::BUSINESS, $loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions);

			$ddlVendorOfficePhoneNumbersElementId = 'manage-subcontract-record--subcontracts--subcontract_vendor_phone_contact_company_office_phone_number_id--'.$subcontract_id;
			$gcVendorOfficePhoneNumbersGroupName = 'manage-subcontract-record--subcontracts--subcontract_vendor_phone_contact_company_office_phone_number_id--';
			if (!empty($arrVendorContactCompanyOfficePhoneNumbers)) {
				$vendorPhoneNumberCount = 1;				

				if($subcontract_vendor_phone_contact_company_office_phone_number_id == "" )
				{
					list($first_key) = each($arrVendorContactCompanyOfficePhoneNumbers);
					$subcontract_vendor_phone_contact_company_office_phone_number_id=$first_key;
					$classvenph ="allfieldupdate";
		
				}else
				{
					$classvenph ="";
				}

				$ddlVendorOfficePhoneNumbers = PageComponents::dropDownListFromObjects($ddlVendorOfficePhoneNumbersElementId, $arrVendorContactCompanyOfficePhoneNumbers, 'contact_company_office_phone_number_id', null, null, 'getFormattedPhoneNumber', $subcontract_vendor_phone_contact_company_office_phone_number_id, null, 'class="'.$classvenph.'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select An Office Phone Number</option>');
			} else {
				$vendorPhoneNumberCount = 0;
				$ddlVendorOfficePhoneNumbers = '<select id="'.$ddlVendorOfficePhoneNumbersElementId.'"><option value="">Please Add An Office Phone Number</option></select>';
			}

			$loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions = new Input();
			$loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions->forceLoadFlag = true;
			$arrVendorContactCompanyOfficeFaxNumbers = ContactCompanyOfficePhoneNumber::loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId($database, $subcontract_vendor_contact_company_office_id, PhoneNumberType::BUSINESS_FAX, $loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeIdOptions);

			$ddlVendorOfficeFaxNumbersElementId = 'manage-subcontract-record--subcontracts--subcontract_vendor_fax_contact_company_office_phone_number_id--'.$subcontract_id;
			$gcVendorOfficeFaxNumbersGroupName = 'manage-subcontract-record--subcontracts--subcontract_vendor_fax_contact_company_office_phone_number_id--';			
			if (!empty($arrVendorContactCompanyOfficeFaxNumbers)) {
				$vendorFaxNumberCount = 1;

				if($subcontract_vendor_fax_contact_company_office_phone_number_id =="")
				{
					list($first_key) = each($arrVendorContactCompanyOfficeFaxNumbers);
					$subcontract_vendor_fax_contact_company_office_phone_number_id=$first_key;
					$classvenfax ="allfieldupdate";
				}else
				{
					$classvenfax ="";
				}

				$ddlVendorOfficeFaxNumbers = PageComponents::dropDownListFromObjects($ddlVendorOfficeFaxNumbersElementId, $arrVendorContactCompanyOfficeFaxNumbers, 'contact_company_office_phone_number_id', null, null, 'getFormattedPhoneNumber', $subcontract_vendor_fax_contact_company_office_phone_number_id, null, 'class="'.$classvenfax.'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select An Office Fax Number</option>');
			} else {
				$vendorFaxNumberCount = 0;
				$ddlVendorOfficeFaxNumbers = '<select id="'.$ddlVendorOfficeFaxNumbersElementId.'"><option>Please Add An Office Fax Number</option></select>';
			}

			$addVendorContactCompanyOfficePhoneNumberPopoverDisabled = '';
			$addVendorContactCompanyOfficeFaxNumberPopoverDisabled = '';
		} else {
			if (empty($ddlVendorContactCompanyOffices)) {
				$ddlVendorContactCompanyOffices = '<select disabled><option>Please Add An Office For This Vendor</option></select>';
				$ddlVendorOfficePhoneNumbers = '<select disabled><option>Please Select A Vendor Office</option></select>';
				$ddlVendorOfficeFaxNumbers = '<select disabled><option>Please Select A Vendor Office</option></select>';
			} else {
				$ddlVendorOfficePhoneNumbers = '<select disabled><option value="">Please Select A Vendor Office Above</option></select>';
				$ddlVendorOfficeFaxNumbers = '<select disabled><option value="">Please Select A Vendor Office Above</option></select>';
			}
			$vendorPhoneNumberCount = 0;
			$vendorFaxNumberCount = 0;
			$addVendorContactCompanyOfficePhoneNumberPopoverDisabled = 'disabled';
			$addVendorContactCompanyOfficeFaxNumberPopoverDisabled = 'disabled';
		}
	} else {
		$ddlVendorContactCompanyOffices = '<select disabled><option>Please Select A Vendor</option></select>';
		$ddlVendorOfficePhoneNumbers = '<select disabled><option>Please Select A Vendor Office</option></select>';
		$ddlVendorOfficeFaxNumbers = '<select disabled><option>Please Select A Vendor Office</option></select>';
		$vendorPhoneNumberCount = 0;
		$vendorFaxNumberCount = 0;
	}

	// ddl: vendor_contact_id to subcontract_vendor_contact_id
	$vendorContactMobilePhoneNumbersGroupName = '';
	if (isset($vendor_contact_company_id) && !empty($vendor_contact_company_id)) {
		$loadContactsByContactCompanyIdOptions = new Input();
		$loadContactsByContactCompanyIdOptions->forceLoadFlag = true;
		$arrVendorContacts = Contact::loadContactsByContactCompanyId($database, $vendor_contact_company_id, $loadContactsByContactCompanyIdOptions);
		if (!empty($arrVendorContacts)) {
			$ddlElementId = 'manage-subcontract-record--subcontracts--subcontract_vendor_contact_id--'.$subcontract_id;
			$ddlVendorContacts = PageComponents::dropDownListFromObjects($ddlElementId, $arrVendorContacts, 'contact_id', null, null, 'getContactFullName', $subcontract_vendor_contact_id, null, 'onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select A Vendor Contact</option>');
		} else {
			$ddlVendorContacts = '<select disabled><option value="">Please Add A Vendor Contact</option></select>';
		}

		// ddl: subcontract_vendor_contact_mobile_phone_number_id
		if (isset($subcontract_vendor_contact_id) && !empty($subcontract_vendor_contact_id)) {
			$loadMobilePhoneNumbersByContactIdOptions = new Input();
			$loadMobilePhoneNumbersByContactIdOptions->forceLoadFlag = true;
			$arrVendorContactMobilePhoneNumbers = MobilePhoneNumber::loadMobilePhoneNumbersByContactId($database, $subcontract_vendor_contact_id, $loadMobilePhoneNumbersByContactIdOptions);
				
			$ddlVendorContactMobilePhoneNumbersElementId = 'manage-subcontract-record--subcontracts--subcontract_vendor_contact_mobile_phone_number_id--'.$subcontract_id;
			$vendorContactMobilePhoneNumbersGroupName = 'manage-subcontract-record--subcontracts--subcontract_vendor_contact_mobile_phone_number_id--';
			if (!empty($arrVendorContactMobilePhoneNumbers)) {
				$vendorMobileNumberCount = 1;

				if($subcontract_vendor_contact_mobile_phone_number_id =="")
				{
					list($first_key) = each($arrVendorContactMobilePhoneNumbers);
					$subcontract_vendor_contact_mobile_phone_number_id=$first_key;
					$classvencon ="allfieldupdate";
				}else
				{
					$classvencon ="";
				}
				$ddlVendorContactMobilePhoneNumbers = PageComponents::dropDownList($ddlVendorContactMobilePhoneNumbersElementId, $arrVendorContactMobilePhoneNumbers,$subcontract_vendor_contact_mobile_phone_number_id, null, 'class ="'.$classvencon.'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"',null, '<option value="">Please Select A Mobile Phone Number</option>');

			} else {
				$vendorMobileNumberCount = 0;
				$ddlVendorContactMobilePhoneNumbers = '<select id="'.$ddlVendorContactMobilePhoneNumbersElementId.'"><option>Please Add A Vendor Contact Mobile Phone Number</option></select>';
			}

			$addVendorContactMobilePhoneNumberPopoverDisabled = '';
		} else {
			$vendorMobileNumberCount = 0;
			$ddlVendorContactMobilePhoneNumbers = '<select disabled><option>Please Select A Vendor Contact Above</option></select>';
			$addVendorContactMobilePhoneNumberPopoverDisabled = 'disabled';
		}
	} else {
		$vendorMobileNumberCount = 0;
		$ddlVendorContacts = '<select disabled><option>Please Select a Vendor Above</option></select>';
		$ddlVendorContactMobilePhoneNumbers = '<select disabled><option>Please Select A Contact Above</option></select>';
		$addVendorContactMobilePhoneNumberPopoverDisabled = 'disabled';
	}

	//  start of vendor signatory
	if (isset($vendor_contact_company_id) && !empty($vendor_contact_company_id)) {
		$loadContactsByContactCompanyIdOptions = new Input();
		$loadContactsByContactCompanyIdOptions->forceLoadFlag = true;
		$arrVendorContacts = Contact::loadContactsByContactCompanyId($database, $vendor_contact_company_id, $loadContactsByContactCompanyIdOptions);
		if (!empty($arrVendorContacts)) {
			$ddlElementId = 'manage-subcontract-record--subcontracts--vendor_signatory--'.$subcontract_id;
			$ddlVendorsignatory = PageComponents::dropDownListFromObjects($ddlElementId, $arrVendorContacts, 'contact_id', null, null, 'getContactFullName', $vendor_signatory, null, 'onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"', '<option value="">Please Select A Vendor Signatory</option>');
		} else {
			$ddlVendorsignatory = '<select disabled><option value="">Please Add A Vendor Signatory</option></select>';
		}
	}

	//End of vendor signatory

	// subcontract_actual_value
	$subcontract_actual_value = $subcontract->subcontract_actual_value;
	$subcontractActualValueClass = '';
	if (isset($subcontract_actual_value) && !empty($subcontract_actual_value)) {
		if ($subcontract_actual_value < 0) {
			$subcontractActualValueClass = ' red';
		}
		$sub_act_value=$subcontract_actual_value;
		$subcontract_actual_value = Format::formatCurrency($subcontract_actual_value);
	} else {
		$subcontract_actual_value = '&nbsp;';
	}

	// $subcontract_target_execution_date = date('m/d/Y',strtotime($subcontract->subcontract_target_execution_date));
	$subcontract_target_execution_date = Date::convertDateTimeFormat($subcontract->subcontract_target_execution_date, 'html_form');

	$gcBudgetLineItem = GcBudgetLineItem::findGcBudgetLineItemByIdExtended($database, $gc_budget_line_item_id);
	$project_id = $gcBudgetLineItem->project_id;

	$costCode = $gcBudgetLineItem->getCostCode();
	/* @var $costCode CostCode */
	$cost_code_id = $costCode->cost_code_id;
	$costCodeDivision = $gcBudgetLineItem->getCostCodeDivision();
	/* @var $costCodeDivision CostCodeDivision */
	$cost_code_division_id = $costCodeDivision->cost_code_division_id;

	$uri = Zend_Registry::get('uri');
	$subcontractsManagerUrl = $uri->http . 'modules-subcontracts-form.php';
	$contactsManagerUrl = $uri->http . 'modules-contacts-manager-form.php';

		//To get the original SAV without approved from SCO
	$subtable = GenActualOriginalValue($database, $cost_code_id,$project_id,$subcontract_id);
    	$subcontract_actual_value =$sub_act_value ;
    $subcontract_actual_value=Format::formatCurrency($subcontract_actual_value);


	// Popovers.
	$addSubcontractTemplatePopover =
	'
	<span id="btnAddSubcontractTemplatePopover" class="btnAddSubcontractTemplatePopover btn entypo entypo-click entypo-plus-circled" data-toggle="popover" style="margin-left:7px"></span>
	<div id="divAddSubcontractTemplatePopover" class="hidden">
		Create a new subcontract template with the <a href="'.$subcontractsManagerUrl.'" target="_blank" style="color:#0e66c8">Subcontracts Manager</a>.
	</div>
	';

	$addGcContactCompanyOfficePopover = '<span id="btnAddGcContactCompanyOfficePopover" class="btnAddGcContactCompanyOfficePopover btn entypo entypo-click entypo-plus-circled popoverButton" data-toggle="popover" style="margin-left:10px"></span>';
	$small = true;
	$helperFunction = 'createContactCompanyOfficeAndUpdateContactCompanyOfficeDdlViaPromiseChain';
	$options = "{ popoverElementId: 'btnAddGcContactCompanyOfficePopover', subcontractCompanyGroupName: '".$gcOfficeGroupName."'  }";
	$createContactCompanyOfficeWidget = buildCreateContactCompanyOfficeWidget($database, $gc_contact_company_id, $small, $helperFunction, $options);
	$addGcContactCompanyOfficePopover .= '<div id="divAddGcContactCompanyOfficePopover" class="hidden">' . $createContactCompanyOfficeWidget . '</div>';

	$dummyId = Data::generateDummyPrimaryKey();
	$dummyId = $subcontract_id.'-phone-'.$dummyId;
	$class = '';
	$span = '';
	if($gcPhoneNumberCount == 0){
		$class = 'btnAddGcContactCompanyOfficePhoneNumberPopover';
		$span = '<span id="btnAddGcContactCompanyOfficePhoneNumberPopover" class="'.$class.' btn entypo entypo-click entypo-plus-circled popoverButton '.$addGcContactCompanyOfficePhoneNumberPopoverDisabled.'" data-toggle="popover" style="margin-left:7px"></span>';
	}
	$addGcContactCompanyOfficePhoneNumberPopover = <<<END_ADD_GC_CONTACT_COMPANY_OFFICE_PHONE_NUMBER_POPOVER
	$span
	<div id="divAddGcContactCompanyOfficePhoneNumberPopover-$subcontract_id" class="hidden">
		<div id="record_creation_form_container--create-contact_company_office_phone_number-record--$dummyId">
			Phone: <input type="text" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--phone_number--$dummyId" class="required phoneNumber">
			<input type="hidden" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--phone_number_type_id--$dummyId" value="1">
			<input type="hidden" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--contact_company_office_id--$dummyId" value="$subcontract_gc_contact_company_office_id">
			<div class="textAlignRight" style="margin-top:5px"><input type="submit" onclick="createContactCompanyOfficePhoneNumberAndUpdateContactCompanyOfficePhoneNumberDdlViaPromiseChain('create-contact_company_office_phone_number-record', '$dummyId', { popoverElementId: 'btnAddGcContactCompanyOfficePhoneNumberPopover', subcontractCompanyGroupName : '$gcOfficePhoneNumberGroupName' });" value="Create Office Phone Number"></div>
		</div>
	</div>
END_ADD_GC_CONTACT_COMPANY_OFFICE_PHONE_NUMBER_POPOVER;

	$dummyId = Data::generateDummyPrimaryKey();
	$dummyId = $subcontract_id.'-fax-'.$dummyId;
	$class = '';
	$span = '';
	if($gcFaxNumberCount == 0){
		$class='btnAddGcContactCompanyOfficeFaxNumberPopover';
		$span = '<span id="btnAddGcContactCompanyOfficeFaxNumberPopover" class="'.$class.' btn entypo entypo-click entypo-plus-circled popoverButton '.$addGcContactCompanyOfficeFaxNumberPopoverDisabled.'" data-toggle="popover" style="margin-left:7px"></span>';
	}
	$addGcContactCompanyOfficeFaxNumberPopover = <<<END_ADD_GC_CONTACT_COMPANY_OFFICE_FAX_NUMBER_POPOVER

	$span
	<div id="divAddGcContactCompanyOfficeFaxNumberPopover-$subcontract_id" class="hidden">
		<div id="record_creation_form_container--create-contact_company_office_phone_number-record--$dummyId">
			Fax: <input type="text" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--phone_number--$dummyId" class="required phoneNumber">
			<input type="hidden" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--phone_number_type_id--$dummyId" value="2">
			<input type="hidden" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--contact_company_office_id--$dummyId" value="$subcontract_gc_contact_company_office_id">
			<div class="textAlignRight" style="margin-top:5px"><input type="submit" onclick="createContactCompanyOfficePhoneNumberAndUpdateContactCompanyOfficePhoneNumberDdlViaPromiseChain('create-contact_company_office_phone_number-record', '$dummyId', { popoverElementId: 'btnAddGcContactCompanyOfficeFaxNumberPopover', subcontractCompanyGroupName : '$gcOfficeFaxNumberGroupName' });" value="Create Office Fax Number"></div>
		</div>
	</div>
END_ADD_GC_CONTACT_COMPANY_OFFICE_FAX_NUMBER_POPOVER;

	$addContactPopover =
	'
	<span id="btnAddContactPopover" class="btnAddContactPopover btn entypo entypo-click entypo-plus-circled" data-toggle="popover" style="margin-left:7px"></span>
	<div id="divAddContactPopover" class="hidden">
		Add contacts at the <a href="'.$contactsManagerUrl.'" target="_blank" style="color:#0e66c8">Contacts Manager</a>.
	</div>
	';

	$dummyId = Data::generateDummyPrimaryKey();
	$dummyId = $subcontract_id.'-mobile-'.$dummyId;
	$class = '';
	$span = '';
	if($gcMobileNumberCount == 0){
		$class = 'btnAddGcContactMobilePhoneNumberPopover';
		$span = '<span id="btnAddGcContactMobilePhoneNumberPopover" class="'.$class.' btn entypo entypo-click entypo-plus-circled popoverButton '.$addGcContactMobilePhoneNumberPopoverDisabled.'" data-toggle="popover" style="margin-left:7px"></span>';
	}
	$addGcContactMobilePhoneNumberPopover = ' '.$span.
	'
	<div id="divAddGcContactMobilePhoneNumberPopover-'.$subcontract_id.'" class="hidden">
		<div id="record_creation_form_container--create-contact_phone_number-record--'.$dummyId.'">
			Cell: <input type="text" id="create-contact_phone_number-record--contact_phone_numbers--phone_number--'.$dummyId.'" class="required phoneNumber">
			<input type="hidden" id="create-contact_phone_number-record--contact_phone_numbers--phone_number_type_id--'.$dummyId.'" value="3">
			<input type="hidden" id="create-contact_phone_number-record--contact_phone_numbers--contact_id--'.$dummyId.'" value="'.$subcontract_gc_contact_id.'">
			<div class="textAlignRight" style="margin-top:5px"><input type="submit" onclick="createContactPhoneNumberAndUpdateContactPhoneNumberDdlViaPromiseChain(\'create-contact_phone_number-record\', \''.$dummyId.'\', { popoverElementId: \'btnAddGcContactMobilePhoneNumberPopover\', subcontractCompanyGroupName : \''.$gcMobileGroupName.'\' });" value="Create Mobile Phone Number"></div>
		</div>
	</div>
	';

	//buildCreateContactCompanyWidget
	$addVendorPopover = '<span id="btnAddVendorPopover" class="btnAddVendorPopover btn entypo entypo-click entypo-plus-circled popoverButton" data-toggle="popover" style="margin-left:10px"></span>';
	$small = true;
	$helperFunction = 'createContactCompanyAndUpdateVendorDdlViaPromiseChain';
	$options = "{ popoverElementId: 'btnAddVendorPopover', subcontractCompanyGroupName: '".$addVendorCompanyOption."'}";
	$createContactCompanyWidget = buildCreateContactCompanyWidget($small, $helperFunction, $options);
	$addVendorPopover .= '<div id="divAddVendorPopover" class="hidden"><div style="height:350px">' . $createContactCompanyWidget . '</div></div>';

	$addVendorContactCompanyOfficePopover = '<span id="btnAddVendorContactCompanyOfficePopover" class="btnAddVendorContactCompanyOfficePopover btn entypo entypo-click entypo-plus-circled popoverButton" data-toggle="popover" style="margin-left:10px"></span>';
	$small = true;
	$helperFunction = 'createContactCompanyOfficeAndUpdateContactCompanyOfficeDdlViaPromiseChain';
	$options = "{ popoverElementId: 'btnAddVendorContactCompanyOfficePopover', subcontractCompanyGroupName: '".$officeAddressGroupName."'  }";
	$createContactCompanyOfficeWidget = buildCreateContactCompanyOfficeWidget($database, $vendor_contact_company_id, $small, $helperFunction, $options);
	$addVendorContactCompanyOfficePopover .= '<div id="divAddVendorContactCompanyOfficePopover-'.$subcontract_id.'" class="hidden">' . $createContactCompanyOfficeWidget . '</div>';

	$dummyId = Data::generateDummyPrimaryKey();
	$dummyId = $subcontract_id.'-vendor-phone-'.$dummyId;
	$class = '';
	$span = '';
	if($vendorPhoneNumberCount == 0){
		$class = 'btnAddVendorContactCompanyOfficePhoneNumberPopover';
		$span = '<span id="btnAddVendorContactCompanyOfficePhoneNumberPopover" class="'.$class.' btn entypo entypo-click entypo-plus-circled popoverButton '.$addVendorContactCompanyOfficePhoneNumberPopoverDisabled.'" data-toggle="popover" style="margin-left:7px"></span>';
	}
	$addVendorContactCompanyOfficePhoneNumberPopover = <<<END_ADD_VENDOR_CONTACT_COMPANY_OFFICE_PHONE_NUMBER_POPOVER
	$span
	<div id="divAddVendorContactCompanyOfficePhoneNumberPopover-$subcontract_id" class="hidden">
		<div id="record_creation_form_container--create-contact_company_office_phone_number-record--$dummyId">
			Phone: <input type="text" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--phone_number--$dummyId" class="required phoneNumber">
			<input type="hidden" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--phone_number_type_id--$dummyId" value="1">
			<input type="hidden" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--contact_company_office_id--$dummyId" value="$subcontract_vendor_contact_company_office_id">
			<div class="textAlignRight" style="margin-top:5px"><input type="submit" onclick="createContactCompanyOfficePhoneNumberAndUpdateContactCompanyOfficePhoneNumberDdlViaPromiseChain('create-contact_company_office_phone_number-record', '$dummyId', { popoverElementId: 'btnAddVendorContactCompanyOfficePhoneNumberPopover' , subcontractCompanyGroupName: '$gcVendorOfficePhoneNumbersGroupName' });" value="Create Office Phone Number"></div>
		</div>
	</div>
END_ADD_VENDOR_CONTACT_COMPANY_OFFICE_PHONE_NUMBER_POPOVER;

	$dummyId = Data::generateDummyPrimaryKey();
	$dummyId = $subcontract_id.'-vendor-fax-'.$dummyId;
	$class = '';
	$span = '';
	if($vendorFaxNumberCount == 0){
		$class = 'btnAddVendorContactCompanyOfficeFaxNumberPopover';
		$span = '<span id="btnAddVendorContactCompanyOfficeFaxNumberPopover" class="'.$class.' btn entypo entypo-click entypo-plus-circled popoverButton '.$addVendorContactCompanyOfficeFaxNumberPopoverDisabled.'" data-toggle="popover" style="margin-left:7px"></span>';
	}
	$addVendorContactCompanyOfficeFaxNumberPopover = <<<END_ADD_VENDOR_CONTACT_COMPANY_OFFICE_FAX_NUMBER_POPOVER
	$span
	<div id="divAddVendorContactCompanyOfficeFaxNumberPopover-$subcontract_id" class="hidden">
		<div id="record_creation_form_container--create-contact_company_office_phone_number-record--$dummyId">
			Fax: <input type="text" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--phone_number--$dummyId" class="required phoneNumber">
			<input type="hidden" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--phone_number_type_id--$dummyId" value="2">
			<input type="hidden" id="create-contact_company_office_phone_number-record--contact_company_office_phone_numbers--contact_company_office_id--$dummyId" value="$subcontract_vendor_contact_company_office_id">
			<div class="textAlignRight" style="margin-top:5px"><input type="submit" onclick="createContactCompanyOfficePhoneNumberAndUpdateContactCompanyOfficePhoneNumberDdlViaPromiseChain('create-contact_company_office_phone_number-record', '$dummyId', { popoverElementId: 'btnAddVendorContactCompanyOfficeFaxNumberPopover', subcontractCompanyGroupName: '$gcVendorOfficeFaxNumbersGroupName' });" value="Create Office Fax Number"></div>
		</div>
	</div>
END_ADD_VENDOR_CONTACT_COMPANY_OFFICE_FAX_NUMBER_POPOVER;

	$addVendorContactPopover =
	'
	<span id="btnAddVendorContactPopover" class="btnAddVendorContactPopover btn entypo entypo-click entypo-plus-circled" data-toggle="popover" style="margin-left:7px"></span>
	<div id="divAddVendorContactPopover" class="hidden">
		Add contacts at the <a href="'.$contactsManagerUrl.'" target="_blank" style="color:#0e66c8">Contacts Manager</a>.
	</div>
	';

	$dummyId = Data::generateDummyPrimaryKey();
	$dummyId = $subcontract_id.'-vendor-mobile-'.$dummyId;
	$class = '';
	$span  = '';
	if($vendorMobileNumberCount == 0){
		$class = 'btnAddVendorContactMobilePhoneNumberPopover';
		$span = '<span id="btnAddVendorContactMobilePhoneNumberPopover" class="'.$class.' btn entypo entypo-click entypo-plus-circled popoverButton '.$addVendorContactMobilePhoneNumberPopoverDisabled.'" data-toggle="popover" style="margin-left:7px"></span>';
	}
	$addVendorContactMobilePhoneNumberPopover = ' '.$span .
	'<div id="divAddVendorContactMobilePhoneNumberPopover-'.$subcontract_id.'" class="hidden">
		<div id="record_creation_form_container--create-contact_phone_number-record--'.$dummyId.'">
			Cell: <input type="text" id="create-contact_phone_number-record--contact_phone_numbers--phone_number--'.$dummyId.'" class="required phoneNumber">
			<input type="hidden" id="create-contact_phone_number-record--contact_phone_numbers--phone_number_type_id--'.$dummyId.'" value="3">
			<input type="hidden" id="create-contact_phone_number-record--contact_phone_numbers--contact_id--'.$dummyId.'" value="'.$subcontract_vendor_contact_id.'">
			<div class="textAlignRight" style="margin-top:5px"><input type="submit" onclick="createContactPhoneNumberAndUpdateContactPhoneNumberDdlViaPromiseChain(\'create-contact_phone_number-record\', \''.$dummyId.'\', { popoverElementId: \'btnAddVendorContactMobilePhoneNumberPopover\', subcontractCompanyGroupName : \''.$vendorContactMobilePhoneNumbersGroupName.'\' });" value="Create Mobile Phone Number"></div>
		</div>
	</div>
	';


	$subcontractDetailsWidget =
'
<div id="record_container--manage-subcontract-record--subcontracts--'.$subcontract_id.'" class="subcontract-details-blog">
	<input id="manage-subcontract-record--subcontracts--gc_budget_line_item_id--'.$subcontract_id.'" type="hidden" value="'.$gc_budget_line_item_id.'">
	<input id="manage-subcontract-record--subcontracts--cost_code_division_id--'.$subcontract_id.'" type="hidden" value="'.$cost_code_division_id.'">
	<input id="manage-subcontract-record--subcontracts--cost_code_id--'.$subcontract_id.'" type="hidden" value="'.$cost_code_id.'">
	<input id="manage-subcontract-record--subcontracts--subcontract_sequence_number--'.$subcontract_id.'" type="hidden" value="'.$subcontract_sequence_number.'">
	<div style="display: inline-block;">
		<a href="javascript:deleteSubcontractAndReloadSubcontractDetailsDialogViaPromiseChain(\'record_container--manage-subcontract-record--subcontracts--'.$subcontract_id.'\', \'manage-subcontract-record\', \''.$subcontract_id.'\');">
			<img style="border: 0px solid red; float: right; position:relative; right:-15px; top: -17px;" alt="Delete Subcontract" border="0" src="/images/icons/delete-file-red.png" width="32" height="32"
			 title="Delete this subcontract" data-toggle="tooltip" data-placement="bottom" class="bs-tooltip">
		</a>
		<div class="widgetContainer" style="margin:0;">
			<h3 class="title">Subcontract Details</h3>
			<table id="tableSubcontractDetails" class="content" cellpadding="5" width="100%">
				<tr>
					<th>Subcontract Template:</th>
					<td>'.$ddlSubcontractTemplates.$addSubcontractTemplatePopover.'</td>
				</tr>

				<tr>
					<th>Subcontract Actual Value:</th>
					<td><input id="manage-subcontract-record--subcontracts--subcontract_actual_value--'.$subcontract_id.'" type="text" value="'.$subcontract_actual_value.'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this);"></td>
				</tr>

				<tr>
					<th>GC Office (Address):</th>
					<td>'.$ddlGCContactCompanyOffices.$addGcContactCompanyOfficePopover.'</td>
					<input type="hidden" id="updateGCcompany" value="'.$update_value.'">
				</tr>

				<tr>
					<th>GC Office Phone Number:</th>
					<td>'.$ddlGCOfficePhoneNumbers.$addGcContactCompanyOfficePhoneNumberPopover.'</td>
				</tr>

				<tr>
					<th>GC Office Fax Number:</th>
					<td>'.$ddlGCOfficeFaxNumbers.$addGcContactCompanyOfficeFaxNumberPopover.'</td>
				</tr>

				<tr>
					<th>GC Contact (Person):</th>
					<td>'.$ddlGCContacts.$addContactPopover.'</td>
				</tr>

				<tr>
					<th>GC Signatory  (Person):</th>
					<td>'.$ddlGCsignatory.'</td>
				</tr>

				<tr>
					<th>GC Contact Mobile Phone Number:</th>
					<td>'.$ddlGCContactMobilePhoneNumbers.$addGcContactMobilePhoneNumberPopover.'</td>
				</tr>

				<tr>
					<th>Vendor Company:</th>
					<td>'.$ddlVendorContactCompanies.$addVendorPopover.'</td>
				</tr>

				<tr>
					<th>Vendor Office (Address):</th>
					<td>'.$ddlVendorContactCompanyOffices.$addVendorContactCompanyOfficePopover.'</td>
				</tr>

				<tr>
					<th>Vendor Office Phone Number:</th>
					<td>'.$ddlVendorOfficePhoneNumbers.$addVendorContactCompanyOfficePhoneNumberPopover.'</td>
				</tr>

				<tr>
					<th>Vendor Office Fax Number:</th>
					<td>'.$ddlVendorOfficeFaxNumbers.$addVendorContactCompanyOfficeFaxNumberPopover.'</td>
				</tr>

				<tr>
					<th>Vendor Contact (Person):</th>
					<td>'.$ddlVendorContacts.$addVendorContactPopover.'</td>
				</tr>
				<tr>
					<th>Vendor Signatory (Person):</th>
					<td>'.$ddlVendorsignatory.'</td>
				</tr>

				<tr>
					<th>Vendor Contact Mobile Phone Number:</th>
					<td>'.$ddlVendorContactMobilePhoneNumbers.$addVendorContactMobilePhoneNumberPopover.'</td>
				</tr>

				<tr>
					<th>Subcontract Target Execution Date:</th>
					<td>
					<input id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--'.$subcontract_id.'" type="text" value="'.$subcontract_target_execution_date.'" class="datepicker" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, \'\', \'\', \'\', false);">
					</td>
				</tr>

			</table>
		</div>
	</div>
</div>
';

	return $subcontractDetailsWidget;
}

function createSubcontractDocumentsForSubcontract($database, $subcontract_id)
{
	$subcontract = Subcontract::findSubcontractByIdExtended($database, $subcontract_id);
	if (!$subcontract) {
		return '';
	}

	$subcontract_template_id = $subcontract->subcontract_template_id;
	$loadSubcontractItemTemplatesBySubcontractTemplateIdOptions = new Input();
	$loadSubcontractItemTemplatesBySubcontractTemplateIdOptions->forceLoadFlag = true;
	$arrSubcontractItemTemplates = SubcontractItemTemplate::loadSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id, $loadSubcontractItemTemplatesBySubcontractTemplateIdOptions);
	$arrSubcontractDocumentIds = array();
	foreach ($arrSubcontractItemTemplates as $subcontract_item_template_id => $subcontractItemTemplate) {
		/* @var $subcontractItemTemplate SubcontractItemTemplate */
		$tmpSubcontractDocument = new SubcontractDocument($database);
		$tmpSubcontractDocument->subcontract_id = $subcontract_id;
		$tmpSubcontractDocument->subcontract_item_template_id = $subcontract_item_template_id;
		$tmpSubcontractDocument->unsigned_subcontract_document_file_manager_file_id = $subcontractItemTemplate->file_manager_file_id;
		$tmpSubcontractDocument->sort_order = $subcontractItemTemplate->subcontract_document_sort_order;
		$tmpSubcontractDocument->convertPropertiesToData();
		$subcontract_document_id = $tmpSubcontractDocument->save();
		$arrSubcontractDocumentIds[] = $subcontract_document_id;
	}

	$csvSubcontractDocumentIds = join(',', $arrSubcontractDocumentIds);
	return $csvSubcontractDocumentIds;
}
// To Get the SubContract Change Order Data 
function SubcontractChangeOrderDataAjax($database, $cost_code_id,$project_id,$filter='all',$gc_budget_line_item_id=null,$subcontract_id)
 {
 	$db = DBI::getInstance($database);
	$query1 = "SELECT sd.*,cc.company FROM `subcontract_change_order_data` as sd inner join `contact_companies` as cc on cc.`id` = sd.subcontract_vendor_id WHERE sd.`costcode_id` = '$cost_code_id' and sd. `project_id`= '$project_id' and subcontractor_id='$subcontract_id' and sd.status IN ('approved') order by sd.status ASC, CAST(SUBSTR(approve_prefix , 5, LENGTH(approve_prefix)) AS UNSIGNED) ASC";
 
    $db->execute($query1);
    $scoArr =array();
    $totalSCOAmount = 0;
    while ($row1 = $db->fetch()){
    	
    	$eachscoarr['sequence_number'] = $row1['sequence_number'];
    	$eachscoarr['title'] = $row1['title'];
    	$eachscoarr['description'] 	= $row1['description'];
    	// Total amount
    	$totalSCOAmount =$totalSCOAmount+ $row1['estimated_amount'];
    	$eachscoarr['estimated_amount_raw'] = $row1['estimated_amount'];
    	$eachscoarr['estimated_amount'] = Format::formatCurrency($row1['estimated_amount']);
    	$estimated_amount = Format::formatCurrency($row1['estimated_amount']);
    	$eachscoarr['status_notes'] = $row1['status_notes'];
       	$eachscoarr['company']	= $row1['company'];
       	$status = $row1['status'];
       	$eachscoarr['status'] = $row1['status'];
       	if($status == 'approved'){
       		$eachscoarr['sequence_number']    =$row1['approve_prefix'];
       		$eachscoarr['appAmt'] =$estimated_amount;
       		$eachscoarr['otherAmt'] ='';
       	}else{
       		$eachscoarr['otherAmt'] = $estimated_amount;
       		$eachscoarr['appAmt'] = '';
       	}

       	$scoArr[] = $eachscoarr;
    }
    $resSCOarr = array("data"=>$scoArr,"total"=>$totalSCOAmount);
    
	return $resSCOarr;
 }

//To check the subcontract change order data exist for a cost code
 function SubcontractChangeOrderData($database, $cost_code_id,$project_id,$filter='all',$gc_budget_line_item_id=null,$subcontract_id)
 {
 	$db = DBI::getInstance($database);
	$query1 = "SELECT sd.*,cc.company FROM `subcontract_change_order_data` as sd inner join `contact_companies` as cc on cc.`id` = sd.subcontract_vendor_id WHERE sd.`costcode_id` = '$cost_code_id' and sd. `project_id`= '$project_id' and subcontractor_id='$subcontract_id' and sd.status IN ('approved','potential') order by sd.status ASC, CAST(SUBSTR(approve_prefix , 5, LENGTH(approve_prefix)) AS UNSIGNED) ASC";
 
    $db->execute($query1);
    $subOrderData=array();
    $poptitle = '';
    while ($row1 = $db->fetch()){
    	$subOrderData[]=$row1;
    	$poptitle = $row1['costcode_data'];
    }
    $totcount=count($subOrderData);

    //Subcontractor budget module data
    $db = DBI::getInstance($database);
 	$query2 = "SELECT * FROM `gc_budget_line_items` WHERE `project_id` = '$project_id' AND `cost_code_id` = $cost_code_id ";
    $db->execute($query2);
    	$row2 = $db->fetch();
    	$scheduled_value=Format::formatCurrency($row2['prime_contract_scheduled_value']);
    	$foreExp = Format::formatCurrency($row2['forecasted_expenses']);
    	$db->free_result();


    $db = DBI::getInstance($database);
 	$query3 = "SELECT cc.company,s.subcontract_actual_value ,s.* FROM `subcontracts` as s INNER Join vendors as v on s.vendor_id= v.id Inner JOIN contact_companies as cc ON v.vendor_contact_company_id =cc.id WHERE `gc_budget_line_item_id` = '$gc_budget_line_item_id' and s.id='$subcontract_id' ";
    $db->execute($query3);
    $budgetsubData=array();

        while ($row3 = $db->fetch()){
        	$budgetsubData[] = $row3;
 		}
    $db->free_result();
    $subActual = '';
    $subconData='';
    $subActtotal=0;
    $k=1;
    foreach ($budgetsubData as $budgetData) {
    	$subid = $budgetData['id'];
   		$subtable = GenActualOriginalValue($database, $cost_code_id,$project_id,$subid);
    	$subAmt =$budgetData['subcontract_actual_value'] ;
    	$subActtotal +=$subAmt; //Total

    	$subAmt = Format::formatCurrency($subAmt);

		$subActual .= "<p class='textAlignLeft'><span>$k)</span><span style='float:right;'> ".$subAmt."</span></p>";
		$subconData .= "<p>$k) ".$budgetData['company']."</p>";
		$k++;

    }
    // variance
		$pcsv = Data::parseFloat($scheduled_value);
		$forecast = Data::parseFloat($foreExp);
		$sav = Data::parseFloat($subActtotal);
		$gcBudgetLineItemVariance=$v_raw =  $pcsv - ($forecast + $sav);
		if ($gcBudgetLineItemVariance < 0) {
			$VarianceClass = 'color: red;';
		} else {
			$VarianceClass = '';
		}
   $v_raw = Format::formatCurrency($v_raw);
   $subActtotal = Format::formatCurrency($subActtotal);
   // $subActual .="<p>".$subActtotal."</p>";


    $resTable="<div class=''> 
    <div class='modal-header'><b>$poptitle</b><span style='line-height: 17px;' class='close' onclick='closePopover($subcontract_id);'>×</span></div>
    <table width='650' border='0' class='drop-inner'>
    <tr><th colspan='2' width='50%'>Cost Code & Description</th>
    <th>Prime Contract <br>Schedule Value</th>
    <th>Forecasted <br> Expenses</th>
    <th>Subcontractor <br>Actual Value</th>

    <tr><td class='cosmalink_section' colspan='2'>$poptitle</td>
    <td class='textAlignRight'>$scheduled_value</td>
    <td class='textAlignRight'>$foreExp</td>
    <td class='textAlignRight'>$subActual</td>

   
    <tr><th width='10%'>SCO</th>
    <th width='40%'>Title</th>
    <th>Description</th>
    <th>Potential CO</th>
    <th>SCO Approved Value</th>
    
   
    </tr>";
    foreach ($subOrderData as $dataVal) {
    	$sequence_number    =$dataVal['sequence_number'];
    	$title 				=$dataVal['title'];
    	$description 		=$dataVal['description'];
    	$estimated_amount 	= Format::formatCurrency($dataVal['estimated_amount']);
    	$status_notes 		=$dataVal['status_notes'];
       	$company 			=$dataVal['company'];
       	$status 			=$dataVal['status'];
       	if($status=='approved')
       	{
       		$sequence_number    =$dataVal['approve_prefix'];
       		$appAmt=$estimated_amount;
       		$otherAmt='';
       	}else
       	{
       		$otherAmt=$estimated_amount;
       		$appAmt='';
       	}



    	$resTable .="<tr><td class=textAlignCenter>$sequence_number</td>
    			<td>$title</td>
    			<td>$description</td>
    			<td class='textAlignRight' style='color:#009DD9;'>$otherAmt</td>
    			<td class='textAlignRight' style='color:#009DD9;'>$appAmt</td>
    			</tr>";
    }
    //for approved
    	$arrReturn=subcontractTotagainstCostCodePosition($database, $cost_code_id,$project_id,$subcontract_id,"'approved'"); 
		$statePos =$arrReturn['count'];
		$tot_estimate  =$arrReturn['estimated_amount'];
		//for potential
		$arrReturnpot=subcontractTotagainstCostCodePosition($database, $cost_code_id,$project_id,$subcontract_id,"'potential'"); 
		$statePospot =$arrReturnpot['count'];
		$pot_estimate  =$arrReturnpot['estimated_amount'];
     $resTable .="<tr><td colspan='2'></td><td ><b> SCO Total</b> </td><td class='textAlignRight' style='color:#009DD9;'> $pot_estimate </td><td class='textAlignRight' style='color:#009DD9;'> $tot_estimate </td><td></td></tr>";
   $resTable .= "</table></div>";
    if($filter == "count")
    {
    	return $totcount;
    }else
    {

	return $resTable;
	}
 }

 // Function to display the submittal data history
 function SubmittaldelayData($database, $cost_code_id,$project_id,$gc_budget_line_item_id,$user_company_id)
 {
 	
 	$realocationdata = DrawItems::ReallocationCostCodeData($database,$cost_code_id,$project_id);

 	$session = Zend_Registry::get('session');
 	$debugMode = $session->getDebugMode();

 	//Subcontractor budget module data
 	$db = DBI::getInstance($database);
 	$query2 = "SELECT * FROM `gc_budget_line_items` WHERE `project_id` = '$project_id' AND `cost_code_id` = $cost_code_id ";
 	$db->execute($query2);
 	$row2 = $db->fetch();
 	$scheduled_value=Format::formatCurrency($row2['prime_contract_scheduled_value']);
 	$db->free_result();
 	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
 	$costcodeData = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$cost_code_id,$costCodeDividerType);
 	$cost_code_abb  =$costcodeData['cost_code_abb'];
 	
 	$cost_code  =$costcodeData['cost_code'];
 	$db  = DBI::getInstance($database);
 	$db1 = DBI::getInstance($database);
 	$query3 = "SELECT s.id,s.su_title,ss.submittal_status,sp.submittal_priority FROM `submittals` as s inner join `submittal_statuses` as ss on s.submittal_status_id = ss.id inner join `submittal_priorities` as sp on s.submittal_priority_id = sp.id WHERE `project_id` = '$project_id' AND `su_cost_code_id` = '$cost_code_id' ORDER BY `created` ASC";
 	$db->execute($query3);
 	$db1->execute($query3);
    $resTable="
    	<div class='realocationCont-main'> 
    		<div class='modal-header'>
    			<b>Submittal for $cost_code_abb</b>
    			<span style='line-height: 17px;' class='close' onclick='closesubmittalPopover($gc_budget_line_item_id);'>×</span>
    		</div>
    		<table width='400' border='0' class='drop-inner'>
    		<tr><th width='200'>Title</th><th width='100'>priority</th><th width='100'>Status</th></tr>
    ";
    // $row3 = $db->fetch();
    // $db->free_result();
    if($db1->fetch()){
    		while($row3 = $db->fetch())
    	{
    		$resTable .="<tr><td>".$row3['su_title']."</td><td>".$row3['submittal_priority']."</td><td>".$row3['submittal_status']."</td></tr>";

    	}
    }else{
    	$resTable .="<tr><td colspan='3'>No data found</td></tr>"; 
    }
    	
    	
    
     
    // total anaysis breakdown
       $resTable .="</table></div>"; 
    return $resTable;
	
 }

 // Function to display the reallocation history
 function ReallocationData($database, $cost_code_id,$project_id,$gc_budget_line_item_id,$user_company_id)
 {
 	
 	$realocationdata = DrawItems::ReallocationCostCodeData($database,$cost_code_id,$project_id);

 	$session = Zend_Registry::get('session');
 	$debugMode = $session->getDebugMode();

 	//Subcontractor budget module data
 	$db = DBI::getInstance($database);
 	$query2 = "SELECT * FROM `gc_budget_line_items` WHERE `project_id` = '$project_id' AND `cost_code_id` = $cost_code_id ";
 	$db->execute($query2);
 	$row2 = $db->fetch();
 	$scheduled_value=Format::formatCurrency($row2['prime_contract_scheduled_value']);
 	$db->free_result();
 	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
 	$costcodeData = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$cost_code_id,$costCodeDividerType);
 	$cost_code_abb  =$costcodeData['cost_code_abb'];

    $resTable="
    	<div class='realocationCont-main'> 
    		<div class='modal-header'>
    			<b>Reallocations for $cost_code_abb</b>
    			<span style='line-height: 17px;' class='close' onclick='closerealocatePopover($gc_budget_line_item_id);'>×</span>
    		</div>
    		<table width='400' border='0' class='drop-inner'>
    		<tr><th colspan='3'>Original PSCV </th><th>$scheduled_value</th></tr>
    ";
   
    $retotal = 0;
    $incCount = 0;
    foreach ($realocationdata as $key => $reval) {
    	if ($incCount == 0) {
    		if ($debugMode) {
    			$drawTitleCol = "<th>Draw Id</th><th>Application Number</th>";
    		}else{
    			$drawTitleCol = "<th colspan='2'>Application Number</th>";
    		}
    		$resTable .="
		     	<tr>
				    $drawTitleCol
				    <th>Through Date</th>
				    <th>Reallocations</th>
				</tr>
		     ";
    	}
    	$drawId = $reval['draw_id'];
    	$through_date = $reval['through_date'];
    	if($through_date !='0000-00-00')
    	{
    	$through_date = date('m/d/Y', strtotime($through_date));
    	}else
    	{
    		$through_date ='0000/00/00';
    	}
    	$application_number = $reval['application_number'];
    	$realocation = $reval['realocation'];
    	$retotal =$retotal+$realocation;
    	$realocationAmt = Format::formatCurrency($realocation);

    	if ($debugMode) {
			$drawValueCol = "<td>$drawId</td><td>$application_number</td>";
		}else{
			$drawValueCol = "<td colspan='2'>$application_number</td>";
		}
		if ($reval['status'] == 2) {
			$resTable .="<tr>
		    	$drawValueCol
		    	<td>$through_date</td>
		    	<td style='color:#009DD9;' align='right'>$realocationAmt</td></tr> ";
		}
		if ($reval['status'] == 1 && $reval['is_realocation'] == 1) {
			$resTable .="<tr>
		    	$drawValueCol
		    	<td>$through_date</td>
		    	<td style='color:#009DD9;' align='right'>$realocationAmt</td></tr> ";
		}

    	$incCount++;
     }
    
     $cummulatePSCV = $retotal+$row2['prime_contract_scheduled_value'];
     
    // total anaysis breakdown
    
	$loadCostCodeBreakDownByProjectIdAndCostCodeId = new Input();
	$loadCostCodeBreakDownByProjectIdAndCostCodeId->forceLoadFlag = true;
	$costCodeAnaysisBreakDown = ChangeOrder::loadCostCodeBreakDownByProjectIdAndCostCodeId($database, $cost_code_id, $project_id, $loadCostCodeBreakDownByProjectIdAndCostCodeId);
	$incCount = 0;
    foreach ($costCodeAnaysisBreakDown as $key => $cocb) {
    	if ($incCount == 0) {
    		$resTable .="
		     	<tr>
			     	<th>COR</th>
				    <th>Description</th>
				    <th>Approved Date</th>
				    <th>Cost ($)</th>
			    </tr>
		     ";
    	}
    	$change_order_id = $cocb['id'];
    	$co_type_prefix = $cocb['co_type_prefix'];    	
    	$cocb_description = $cocb['cocb_description'];
    	$co_approved_date = $cocb['co_approved_date'];
    	if($co_approved_date !='0000-00-00')
    	{
    	$co_approved_date = date('m/d/Y', strtotime($co_approved_date));
    	}else
    	{
    		$co_approved_date ='0000/00/00';
    	}
    	$co_cost = $cocb['cocb_cost'];
    	$co_cost_con = Format::formatCurrency($co_cost);
    	$resTable .="
	     	<tr>
		     	<td>$co_type_prefix</td>
			    <td>$cocb_description</td>
			    <td>$co_approved_date</td>
			    <td style='color:#009DD9;' align='right'>$co_cost_con</td>
		    </tr>
	    ";
	    $retotal = $retotal + floatVal($co_cost);
	    $cummulatePSCV = $cummulatePSCV + floatVal($co_cost);
	    $incCount++;
    }
    $totalReAmt = Format::formatCurrency($retotal);
    $cummulatePSCV = Format::formatCurrency($cummulatePSCV);
    $resTable .="
    	<tr>
    		<td colspan='3' align='right'><b>Total</b></td><td style='color:#009DD9;'  align='right'>$totalReAmt
    		</td>
    	</tr>
     	<tr>
     		<td colspan='3' align='right'>
     			<b>(PCSV + Reallocations + OCO) Total</b>
     		</td>
     		<td align='right'>
     			<b>$cummulatePSCV</b>
     		</td>
     	</tr>
    ";

    $resTable .="</table></div>"; 
    return $resTable;
	
 }


 //To get the subcontract Document 
 function SubcontractByStaticprjDocument($project_id)
 {
 	$db = DBI::getInstance();
	$doc_query = "SELECT * FROM subcontract_document_to_project WHERE `project_id` = $project_id ";
	$db->execute($doc_query);
	$doc_arr = array();
	while ($docs = $db->fetch())
	{
		$do_id = $docs['subcontract_item_template_id'];
		$doc_arr[$do_id] = $docs['file_manager_file_id'];
	}
	$db->free_result();
	return $doc_arr;
 }

 function insuranceDoclink($subcontract_id,$fieldName)
 	{
 		//To fetch the uploaded other document
	$db = DBI::getInstance($database);
	$query ="SELECT f.`id` as file_id, f.`file_manager_folder_id`, f.`file_location_id`, f.`virtual_file_name`,	s.* From `subcontracts` as s inner join file_manager_files as f on s.$fieldName = f.id where s.id=$subcontract_id  ";
	$db->execute($query);
	$file_id="";
	$uploadedfileName="";
	$row=$db->fetch();
	$file_id=$row[$fieldName];
	$uploadedfileName=$row['virtual_file_name'];
		$db->free_result();
	if($file_id){
		$fileManagerFile = FileManagerFile::findById($database, $file_id);
                $cdnFileUrl = $fileManagerFile->generateUrl();
		$addUploadData = '<a class=" fakeHref"  data-placement="bottom" target="_blank" href="' . $cdnFileUrl . '" title="' . $uploadedfileName . '">'.$uploadedfileName.'</a>';
	}
	return $addUploadData;
 	}

	//buyout report
	function renderBuyoutReportHtml($database, $project_id, $new_begindate, $enddate, $reportType, $user_company_id, $costCodeAlias){

		$loadCommittedContractsByProjectIdOptions = new Input();
		$loadCommittedContractsByProjectIdOptions->forceLoadFlag = true;

		$project = Project::findProjectByIdExtended($database, $project_id);
		$alias_type = $project->alias_type;	

		$arrCommittedContracts = GcBudgetLineItem::loadCommittedContractsByProjectId($database, $project_id, $new_begindate, $enddate ,$loadCommittedContractsByProjectIdOptions);

		$committedTableBody = '';

		if(count($arrCommittedContracts) > 0){

			foreach ($arrCommittedContracts as $gc_budget_line_item_id => $budgetLineItem) {

  		  		$costCode = $budgetLineItem->getCostCode();
  		  		$costCodeId = $budgetLineItem->cost_code_id;
  		  		$costCodeDivision = $costCode->getCostCodeDivision();
				$costCodeDivision->htmlEntityEscapeProperties();
				$cost_code_division_id = $costCodeDivision->cost_code_division_id;
  		 	 	$formattedCostCode = $costCode->getFormattedCostCode($database,false, $user_company_id);
  		  		$costCodeDescription = $costCode->cost_code_description;
  		  		$scheduledValue = Format::formatCurrency($budgetLineItem->prime_contract_scheduled_value);

  		  		$loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
  		  		$loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
  		  		$arrSubcontracts = Subcontract::loadCommittedSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $new_begindate, $enddate, $loadSubcontractsByGcBudgetLineItemIdOptions);
  		  		$subContractCount = count($arrSubcontracts);

  		  		$getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$costCodeId,$cost_code_division_id);
				$cc_class = ($costCodeAlias == 'true') ? '' : 'align-center';
				if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAlias == 'true') {
					$getCostCodeAliasRe = str_replace(',', ',<br />', $getCostCodeAlias);
			      	$formattedCostCode = $formattedCostCode.'<br /> '.$getCostCodeAliasRe;
			    }

				$subcontractIndex = 1;

  				foreach ($arrSubcontracts as $subcontract) {
  		    		// Vendor list
  		    		$vendor = $subcontract->getVendor();
  		    		$vendorContactCompany = $vendor->getVendorContactCompany();
  		    		/* @var $vendorContactCompany ContactCompany */
  		    		$vendorContactCompany->htmlEntityEscapeProperties();
  		    		$vendorCompany = $vendorContactCompany->escaped_contact_company_name;
  		    		$subcontractActualValue = $subcontract->subcontract_actual_value;
					$subcontractActualValueFormatted = Format::formatCurrency($subcontractActualValue);
					if($reportType == 'pdf' && $subcontractActualValue < 0){
						$subcontractActualValueFormatted = Format::formatCurrency(abs($subcontractActualValue));
						$subcontractActualValueFormatted = '('.$subcontractActualValueFormatted.')';
					}
          
					$executionDate = $subcontract->subcontract_execution_date;
					if ($executionDate != '0000-00-00') {
						$execution_date = date("m/d/Y", strtotime($executionDate));
					}else{
						$execution_date = '&nbsp';
					}
					
					if ($subcontractIndex == 1) {
						$committedTableBody .= <<<END_COMMITTED_TABLE_TBODY
   							<tr>
 								<td class="$cc_class" rowspan="$subContractCount" style="vertical-align:top;">$formattedCostCode</td>
  								<td class="align-left" rowspan="$subContractCount" style="vertical-align:top;">$costCodeDescription</td>
   								<td align="center" rowspan="$subContractCount" style="vertical-align:top;">$scheduledValue</td>
		  						<td align="left">$vendorCompany</td>
  								<td align="right">$subcontractActualValueFormatted</td>
  								<td align="center">$execution_date</td>
   							</tr>
END_COMMITTED_TABLE_TBODY;
					}
				

					if ($subcontractIndex != 1) {
						$committedTableBody .= <<<END_COMMITTED_TABLE_TBODY
   							<tr>
		  						<td align="left">$vendorCompany</td>
  								<td align="right">$subcontractActualValueFormatted</td>
  								<td align="center">$execution_date</td>
   							</tr>
END_COMMITTED_TABLE_TBODY;
					}

          			$subcontractIndex++;
  				}
			}
		}else{
			$committedTableBody .= <<<END_COMMITTED_TABLE_TBODY
				<tr>
					<td class="align-center" colspan='6'>No Data Available</td>
				</tr>
END_COMMITTED_TABLE_TBODY;
		}


		//Fetch uncommitted contracts Data
		$loadUncommittedContractsByProjectIdOptions = new Input();
		$loadUncommittedContractsByProjectIdOptions->forceLoadFlag = true;

		$arrUncommittedContracts = GcBudgetLineItem::loadUnCommittedContractsByProjectId($database, $project_id, $loadUncommittedContractsByProjectIdOptions);
		$uncommittedTableBody = '';

		if(count($arrUncommittedContracts) > 0){
		
			foreach ($arrUncommittedContracts as $gc_budget_line_item_id => $budgetLineItem) {
		  		
		  		$costCode = $budgetLineItem->getCostCode();
		  		$costCodeId = $budgetLineItem->cost_code_id;
		  		$formattedCostCode = $costCode->getFormattedCostCode($database,false, $user_company_id);
		  		$costCodeDivision = $costCode->getCostCodeDivision();
				$costCodeDivision->htmlEntityEscapeProperties();
				$cost_code_division_id = $costCodeDivision->cost_code_division_id;
		  		$costCodeDescription = $costCode->cost_code_description;
		  		$scheduledValue = $budgetLineItem->prime_contract_scheduled_value;
				$scheduledValueFormatted = Format::formatCurrency($scheduledValue);
				if($reportType == 'pdf' && $scheduledValue < 0){
					$scheduledValueFormatted = Format::formatCurrency(abs($scheduledValue));
					$scheduledValueFormatted = '('.$scheduledValueFormatted.')';
				}
				$getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$costCodeId,$cost_code_division_id);
				$cc_class = ($costCodeAlias == 'true') ? '' : 'align-center';
				if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAlias == 'true') {
					$getCostCodeAliasRe = str_replace(',', ',<br />', $getCostCodeAlias);
			      	$formattedCostCode = $formattedCostCode.'<br /> '.$getCostCodeAliasRe;
			    }
				$uncommittedTableBody .= <<<END_COMMITTED_TABLE_TBODY
					<tr>
						<td class="$cc_class" style="vertical-align: top;">$formattedCostCode</td>
						<td class="align-left" style="vertical-align: top;">$costCodeDescription</td>
						<td class="align-center" style="vertical-align: top;">$scheduledValueFormatted</td>
	    			</tr>
END_COMMITTED_TABLE_TBODY;
			}
		}else{
			$uncommittedTableBody .= <<<END_COMMITTED_TABLE_TBODY
				<tr>
					<td class="align-center" colspan="3">No Data Available</td>
				</tr>
END_COMMITTED_TABLE_TBODY;
		}

		$htmlContent = <<<END_HTML_CONTENT
			<table id="committed_contracts_table" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="80%">

				<tr class="permissionTableMainHeaderTd">
	        		<td class="align-center" style="width:10%">Cost Code</td>
	        		<td class="align-center" style="width:20%;">Description</td>
	        		<td class="align-center" style="width:10%;">Budget</td>
					<td class="align-center" style="width:20%;">Subcontract Vendor</td>
					<td class="align-center" style="width:20%;">Subcontract Actual Value</td>
					<td class="align-center" style="width:20%;">Execution Date</td>
    			</tr>
				<tr>
					<td colspan="6"><b class="headsle">Committed Contracts</b></td>
				</tr>
				$committedTableBody
			</table>

 			<table id="uncommitted_contracts_table" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="50%">
				<tr class="permissionTableMainHeaderTd">
					<td class="align-center" style="width:10%">Cost Code</td>
					<td class="align-center" style="width:20%;">Description</td>
					<td class="align-center" style="width:20%;">Budget</td>
				</tr>
				<tr>
  					<td colspan="5"><b class="headsle">Uncommitted Contracts</b></td>
				</tr>
				$uncommittedTableBody
			</table>
END_HTML_CONTENT;

return $htmlContent;

}

//Buyout Log report
function renderBuyoutLogReportHtml($database, $project_id, $new_begindate, $enddate, $reportType, $user_company_id, $hasSubContAmt, $costCodeAlias){

	$arrbuyout = GcBudgetLineItem::loadBuyoutLogData($database, $project_id);

	$project = Project::findProjectByIdExtended($database, $project_id);
	$alias_type = $project->alias_type;

	$colSpanCnt = ($hasSubContAmt == 'true') ? 8 : 6 ;

	$buyoutLogBody = $hasSubContAmtTd = $hasSubContAmtTotTd = '';
	$totalPSCV = $overAlltotSubContActVal = $totbuyoutSavingHit = $hasSubContPSCV = $bidRecivedPSCV = 0;

	if(count($arrbuyout) > 0){
		foreach ($arrbuyout as $gc_budget_line_item_id => $budgetLineItem) {		

			$costCode = $budgetLineItem->getCostCode();
			$costCodeId = $budgetLineItem->cost_code_id;
			$costCodeDivision = $costCode->getCostCodeDivision();
			$costCodeDivision->htmlEntityEscapeProperties();
			$cost_code_division_id = $costCodeDivision->cost_code_division_id;
			$formattedCostCode = $costCode->getFormattedCostCode($database,false, $user_company_id);
			$costCodeDescription = $costCode->cost_code_description;
			$pscv = $budgetLineItem->prime_contract_scheduled_value;
			$pscvFormatted = Format::formatCurrency($pscv);
			$totalPSCV = $totalPSCV + $pscv;

			$countBids = SubcontractorBid::loadCountOfBids($database, $gc_budget_line_item_id);

			$uri = Zend_Registry::get('uri');
			$baseCdnUrl = $uri->https;
			$img_url = $baseCdnUrl.'images/buttons/tick-mark.png';

			if (isset($countBids['active']) && $countBids['active'] > 0) {
				$bidRecived = '<img src='.$img_url.' style="padding-top: 5px;width: 15px;">';
				$bidRecivedPSCV = $bidRecivedPSCV + $pscv;
			}else{
				$bidRecived = '';
			}

			$loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
  		  	$loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
			$arrSubcontracts = Subcontract::loadCommittedSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $new_begindate, $enddate, $loadSubcontractsByGcBudgetLineItemIdOptions);

			if (count($arrSubcontracts) > 0) {
				$hasSubcontracts = 'C';
				$hasSubContPSCV = $hasSubContPSCV + $pscv;
				$totSubContActVal = 0;
				$vendorCmy = '';
				$count = 1;
				foreach ($arrSubcontracts as $subcontract){
					$vendor = $subcontract->getVendor();
  		    		$vendorContactCompany = $vendor->getVendorContactCompany();
  		    		$vendorContactCompany->htmlEntityEscapeProperties();
  		    		$vendorCompany = $vendorContactCompany->escaped_contact_company_name;

  		    		if(count($arrSubcontracts) == 1){
  		    			$vendorCmy .= $vendorCompany;
  		    		}else{
  		    			$vendorCmy .= $count.') '.$vendorCompany."<br>";
  		    		}  		    		

					$subContActVal = $subcontract->subcontract_actual_value;
					$totSubContActVal = $totSubContActVal + $subContActVal;

					$count++;
				}
				$totSubContActValFormatted = Format::formatCurrency($totSubContActVal);
				if($reportType == 'pdf' && $totSubContActVal < 0){
					$totSubContActValFormatted = Format::formatCurrency(abs($totSubContActVal));
					$totSubContActValFormatted = '('.$totSubContActValFormatted.')';
				}
				$overAlltotSubContActVal = $overAlltotSubContActVal + $totSubContActVal;

				$buyoutSavingHit = $pscv - $totSubContActVal;
				$buyoutSavingHitFormatted = Format::formatCurrency($buyoutSavingHit);
				if($reportType == 'pdf' && $buyoutSavingHit < 0){
					$buyoutSavingHitFormatted = Format::formatCurrency(abs($buyoutSavingHit));
					$buyoutSavingHitFormatted = '('.$buyoutSavingHitFormatted.')';
				}
				$totbuyoutSavingHit = $totbuyoutSavingHit + $buyoutSavingHit;
			}else{
				$hasSubcontracts = '';
				$totSubContActValFormatted = '';
				$buyoutSavingHitFormatted = '';
				$vendorCmy = '';
			}			

			if($hasSubContAmt == 'true'){
			$hasSubContAmtTd = <<<END_COMMITTED_TABLE_TBODY
			
				<td class="textAlignRight" style="vertical-align: top;">$totSubContActValFormatted</td>
				<td class="textAlignRight" style="vertical-align: top;">$buyoutSavingHitFormatted</td>
			
END_COMMITTED_TABLE_TBODY;
			}

			$getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$costCodeId,$cost_code_division_id);
			$cc_class = ($costCodeAlias == 'true') ? '' : 'align-center';
			if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAlias == 'true') {
				$getCostCodeAliasRe = str_replace(',', ',<br />', $getCostCodeAlias);
		      	$formattedCostCode = $formattedCostCode.'<br /> '.$getCostCodeAliasRe;
		    }

			$buyoutLogBody .= <<<END_COMMITTED_TABLE_TBODY
				<tr>
					<td class="$cc_class" style="vertical-align: top;">$formattedCostCode</td>
					<td class="align-left" style="vertical-align: top;">$costCodeDescription</td>
					<td class="textAlignRight" style="vertical-align: top;">$pscvFormatted</td>
					<td class="align-center" style="vertical-align: top;">$bidRecived</td>
					<td class="align-center" style="vertical-align: top;">$hasSubcontracts</td>
					<td style="vertical-align: top;">$vendorCmy</td>
					$hasSubContAmtTd
				</tr>
END_COMMITTED_TABLE_TBODY;

		}
	}else{
		$buyoutLogBody .= <<<END_COMMITTED_TABLE_TBODY
				<tr>
					<td class="align-center" colspan='$colSpanCnt'>No Data Available</td>
				</tr>
END_COMMITTED_TABLE_TBODY;
	}

	$totalPSCVFormatted = Format::formatCurrency($totalPSCV);
	$overAlltotSubContActValFormatted = Format::formatCurrency($overAlltotSubContActVal);
	$totbuyoutSavingHitFormatted = Format::formatCurrency($totbuyoutSavingHit);

	$contractedPercentage = round((($hasSubContPSCV / $totalPSCV) * 100),2).'%';
	$bidRecivedPercentage = round((($bidRecivedPSCV / $totalPSCV) * 100),2).'%';

	if($hasSubContAmt == 'true'){
		$hasSubContAmtTotTd = <<<END_COMMITTED_TABLE_TBODY
		
			<td class="textAlignRight">$overAlltotSubContActValFormatted</td>
			<td class="textAlignRight">$totbuyoutSavingHitFormatted</td>
			
END_COMMITTED_TABLE_TBODY;

		$percentageTd = <<<END_COMMITTED_TABLE_TBODY
		
			<td></td>
			<td></td>
			
END_COMMITTED_TABLE_TBODY;
	}

	$percentageTr = <<<END_COMMITTED_TABLE_TBODY
			<tr style="font-weight: bold;">
				<td></td>
				<td></td>
				<td></td>
				<td class="align-center">$bidRecivedPercentage</td>
				<td class="align-center">$contractedPercentage</td>
				<td></td>
				$percentageTd
			</tr>
END_COMMITTED_TABLE_TBODY;

	$totalTr = <<<END_COMMITTED_TABLE_TBODY
			<tr style="font-weight: bold;">
				<td colspan='2' class="textAlignRight">TOTAL</td>
				<td class="textAlignRight">$totalPSCVFormatted</td>
				<td></td>
				<td></td>
				<td></td>
				$hasSubContAmtTotTd
			</tr>
END_COMMITTED_TABLE_TBODY;

	$hasSubContAmtTr = '';
	if($hasSubContAmt == 'true'){
		$hasSubContAmtTr .= <<<END_COMMITTED_TABLE_TBODY
			
			<td class="align-center">Subcontract Amount</td>
			<td class="align-center">Buyout Savings/Hit</td>
			
END_COMMITTED_TABLE_TBODY;
	}

	$htmlContent = <<<END_HTML_CONTENT
		<table id="committed_contracts_table" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr class="permissionTableMainHeaderTd">
        		<td class="align-center">Cost Code</td>
        		<td class="align-center">Description</td>
        		<td class="align-center">Contract Value</td>
				<td class="align-center">Bids Received</td>
				<td class="align-center">Contracted</td>
				<td class="align-center">Awarded Subcontracts</td>
				$hasSubContAmtTr
			</tr>
			$percentageTr
			$buyoutLogBody
			$totalTr
		</table>
END_HTML_CONTENT;

return $htmlContent;

}

function getApprovedSubcontractChangeOrder($database, $costCodeId, $projectId, $subContractId){
 $db = DBI::getInstance($database);
 $query =
 "
 SELECT sd.*,cc.company FROM `subcontract_change_order_data` AS sd
 INNER JOIN `contact_companies` AS cc ON cc.`id` = sd.subcontract_vendor_id
 WHERE sd.`costcode_id` = ? AND sd. `project_id`= ? AND subcontractor_id=?
 AND sd.status IN ('approved')
 ";
 $arrValues = array($costCodeId, $projectId, $subContractId);
 // echo '<pre>';print_r($query);print_r($arrValues);exit;
 $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
 $arrApprovedSubcontractChangeOrder = array();
 while ($row = $db->fetch()) {
	 $subcontractChangeOrder = $row['id'];
	 $arrApprovedSubcontractChangeOrder[$subcontractChangeOrder] = $row;
 }
 $db->free_result();
 return $arrApprovedSubcontractChangeOrder;
}

//current budget report
function renderCurrentBudgetReportHtml($database, $project_id, $new_begindate, $enddate, $user_company_id, $reportType, $crntNotes, $crntSubtotal, $crntValOnly, $costCodeAlias){

	$project = Project::findProjectByIdExtended($database, $project_id);
	$OCODisplay = $project->COR_type;
	$alias_type = $project->alias_type;	
	$unitCount = $project->unit_count;
	$netRentableSqFt = $project->net_rentable_square_footage;

	$loadCurrentGcBudgetLineItemIdOptions = new Input();
	$loadCurrentGcBudgetLineItemIdOptions->forceLoadFlag = true;
	$arrGcBudgetLineItems = GcBudgetLineItem::loadCurrentGcBudgetLineItems($database, $project_id, $new_begindate, $enddate, $loadCurrentGcBudgetLineItemIdOptions);
	$costCodeDivisionCnt = GcBudgetLineItem::costCodeDivisionCountByProjectId($database, $project_id);

	$totalPrimeScheduleValue = $totalEstimatedSubcontractValue = $totalVariance = 0;
	$overall_Original_PSCV = $overall_OCO_Val = $overall_Reallocation_Val = $overall_Sco_amount = 0;
	$sub_tot_ori_pscv = $sub_tot_reallocation = $sub_tot_oco = $sub_tot_pscv = $sub_tot_sco = 0;
	$sub_tot_crt_subcon = $sub_tot_variance = $sub_tot_cost_per_unit = $total_buyout_forcast = $total_forcast = $tot_sub_tot_cost_per_unit = 0;

	$gcCurrentBudgetItemBody = '';	
	$loopCounter = 1;

	if ($OCODisplay == 1) {
		$totalspan = '11';
	}		
	if ($OCODisplay == 2) {
		$totalspan = '12';
	}	

	if(count($arrGcBudgetLineItems) == 0){
	 	$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
	  		<tr><td colspan="$totalspan">No Data Available</td></tr>
END_BUDGET_HTML_CONTENT;
	}

	foreach ($arrGcBudgetLineItems as $gc_budget_line_item_id => $budgetLineItem) {
	  
	  	$estimatedSubcontractorAmount = 0;
	  	$costrowcount=3;

	  	$notes = $budgetLineItem->notes;

	  	$costCode = $budgetLineItem->getCostCode();
	 	$costCodeId = $budgetLineItem->cost_code_id;
	  	$formattedCostCode = $costCode->getFormattedCostCode($database,false, $user_company_id);

	  	$costCodeDescription = $costCode->cost_code_description;

	  	$costCodeDivision = $costCode->getCostCodeDivision();
		$costCodeDivision->htmlEntityEscapeProperties();
		$costCodeDivNo = $costCodeDivision->escaped_division_number;
		$cost_code_division_id = $costCodeDivision->cost_code_division_id;

		$getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$costCodeId,$cost_code_division_id);
		$cc_class = ($costCodeAlias == 'true') ? '' : 'align-center';
		if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAlias == 'true') {
			$getCostCodeAliasRe = str_replace(',', ',<br />', $getCostCodeAlias);
	      	$formattedCostCode = $formattedCostCode.'<br /> '.$getCostCodeAliasRe;
	    }

		if($loopCounter==1){
			$costCodeDivisionCount = 1;
		}

		if ($costCodeDivisionCount == $costCodeDivisionCnt[$costCodeDivision->escaped_division_number]['count']) {
			$costCodeDivisionCount = 0;
		}

	  	$reallocated_amt = ChangeOrder::ReallocationInDrawsAndCOByCostCode($database,$costCodeId,$project_id);

	  	// original PSCV value
	  	$originalPSCV = $budgetLineItem->prime_contract_scheduled_value;
	  	$overall_Original_PSCV += $originalPSCV;

	  	// Owner Change order value
	  	$ocoVal = ChangeOrder::loadSumOfCostCodeBreakDownByProjectIdAndCostCodeId($database, $costCodeId,$project_id);
	  	$oco_value = $ocoVal['totalBreakdownAmount'];
	  	$overall_OCO_Val = $overall_OCO_Val + $oco_value;

	  	// Reallocation value
	  	$reallocationVal = DrawItems::costcodeReallocated($database, $costCodeId,$project_id);
	  	$reallocation_Val = round($reallocationVal['total'],2);
	  	$overall_Reallocation_Val = round(($overall_Reallocation_Val + $reallocation_Val),2);

	  	if ($OCODisplay == 1) {
	  		$scheduledValue = $originalPSCV + $reallocation_Val;
	  	}else{
	  		$scheduledValue = $budgetLineItem->prime_contract_scheduled_value + $reallocated_amt;
	  	}
	  	$totalPrimeScheduleValue += $scheduledValue;		 

	  	$scheduledValueFormatted = Format::formatCurrency($scheduledValue);
	  	if($reportType == 'pdf' && $scheduledValue < 0){
	  		$scheduledValueFormatted = '('.Format::formatCurrency(abs($scheduledValue)).')';
	  	}

	  	$originalPSCVFormatted = Format::formatCurrency($originalPSCV);
	  	if($reportType == 'pdf' && $originalPSCV < 0){
	  		$originalPSCVFormatted = '('.Format::formatCurrency(abs($originalPSCV)).')';
	  	}

	  	$reallocationValFormatted = Format::formatCurrency($reallocation_Val);
	  	if($reportType == 'pdf' && $reallocation_Val < 0){
	  		$reallocationValFormatted = '('.Format::formatCurrency(abs($reallocation_Val)).')';
	  	}

	  	$ocoValFormatted = Format::formatCurrency($oco_value);
	  	if($reportType == 'pdf' && $oco_value < 0){
	  		$ocoValFormatted = '('.Format::formatCurrency(abs($oco_value)).')';
	  	}

	    $ocoCostCodeValueTd = '';
		if ($OCODisplay == 2) {
			$ocoCostCodeValueTd = '<td class="textAlignRight" style="border-bottom:none;"></td>';
		}

		$loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
	  	$loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
	  	$arrSubcontracts = Subcontract::loadCurrentSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions);
	  	$isSubcontractValue = 'false';
	  	foreach ($arrSubcontracts as $subcontract) {		  	
      		$subContractId = $subcontract->subcontract_id;
      		$tmp_subcontract_actual_value = $subcontract->subcontract_actual_value;
      		if($tmp_subcontract_actual_value > 0){
				$isSubcontractValue = 'true';
			}
      		$arrSubcontractChangeOrder = getApprovedSubcontractChangeOrder($database, $costCodeId, $project_id, $subContractId);
      		$costrowcount = $costrowcount + count($arrSubcontractChangeOrder);
	    }

		$costrowcount = $costrowcount + count($arrSubcontracts) + 1;
		if ($OCODisplay == 2) {
			$costrowcount = $costrowcount + count($ocoVal) - 2;
		}

		$forecastedExpenses = $budgetLineItem->forecasted_expenses;
        $buyoutForecastExpenses = $budgetLineItem->buyout_forecasted_expenses;

		$isRowVisible = 'true';
		if($isSubcontractValue == 'false' && floatval($originalPSCV) == 0 && floatval($forecastedExpenses) == 0)
		{
			$isRowVisible = 'false';
		}
		if($isSubcontractValue == 'true' && floatval($originalPSCV) != 0 && floatval($forecastedExpenses) != 0 || floatval($buyoutForecastExpenses) != 0)
		{
			$isRowVisible = 'true';
		}

		// Cost code row
		if(($crntValOnly == 'true' && $isRowVisible == 'true') || ($crntValOnly == 'false')){
	    $gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
			<tr style="border-top:1px solid #adadad;">
				<td class="$cc_class" style="border-bottom:none;vertical-align: top;" rowspan="$costrowcount">$formattedCostCode</td>
				<td class="align-left" class="align-center" style="border-bottom:none;">$costCodeDescription</td>
				<td class="textAlignRight" style="border-bottom:none;">$originalPSCVFormatted</td>
				<td class="textAlignRight" style="border-bottom:none;">$reallocationValFormatted</td>
				$ocoCostCodeValueTd
				<td class="textAlignRight" style="border-bottom:none;">$scheduledValueFormatted</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
END_BUDGET_HTML_CONTENT;

		if ($OCODisplay == 2) {
			unset($ocoVal['totalCount']);
			unset($ocoVal['totalBreakdownAmount']);
			foreach ($ocoVal as $key => $value) {
				$coName = $value['co_title'];
				$coCustom = $value['co_custom_sequence_number'];
				if ($coCustom) {
					$ocoName = '<span style="color:#06c !important;">'.$coCustom.'</span> | '.$coName;
				}else{
					$ocoName = $coName;
				}
				$coValue = $value['cocb_cost'];

				$coValueFormatted = Format::formatCurrency($coValue);
				if($reportType == 'pdf' && $coValue < 0){
		     		$coValueFormatted = '('.Format::formatCurrency(abs($coValue)).')';
				}
				// Owner change order row
				$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
					<tr>
						<td style="border-top:1px solid #adadad;" class="textAlignRight">$ocoName</td>
						<td style="border-top:1px solid #adadad;"></td>
						<td style="border-top:1px solid #adadad;"></td>
						<td style="border-top:1px solid #adadad;" class="textAlignRight">$coValueFormatted</td>
						<td style="border-top:1px solid #adadad;"></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
END_BUDGET_HTML_CONTENT;
			}
		}
	}

	  	$totalAmount = 0;

	  	// if(count($arrSubcontracts) > 0){
			$scoTotal = 0;
			$total_Sco_amount = 0;
		if(($crntValOnly == 'true' && $isRowVisible == 'true') || ($crntValOnly == 'false')){
	    	$total_buyout_forcast += $buyoutForecastExpenses;
	    	$total_forcast += $forecastedExpenses;

	    	$scoTotal += $forecastedExpenses;
	    	$totalAmount += $forecastedExpenses;
	    	if (count($arrSubcontracts) == 0) {	    		
	    		$scoTotal += $buyoutForecastExpenses;
	    		$totalAmount += $buyoutForecastExpenses;
	    	}    	

	    	$forecastedExpensesFormatted = Format::formatCurrency($forecastedExpenses);
			if($reportType == 'pdf' && $forecastedExpenses < 0){
	      		$forecastedExpensesFormatted = '('.Format::formatCurrency(abs($forecastedExpenses)).')';
            }
            $buyoutForecastExpensesFormatted = Format::formatCurrency($buyoutForecastExpenses);
			if($reportType == 'pdf' && $buyoutForecastExpenses < 0){
	      		$buyoutForecastExpensesFormatted = '('.Format::formatCurrency(abs($buyoutForecastExpenses)).')';
			}
		}

	    	foreach ($arrSubcontracts as $subcontract) {
				$scHtml = '';
			  	$subcontractAmount = 0;
	      		$subContractId = $subcontract->subcontract_id;
	      		$arrSubcontractChangeOrder = getApprovedSubcontractChangeOrder($database, $costCodeId, $project_id, $subContractId);

	      		// Vendor list
	      		$vendor = $subcontract->getVendor();
	      		$vendorContactCompany = $vendor->getVendorContactCompany();
	      		$vendorContactCompany->htmlEntityEscapeProperties();
	      		$vendorCompany = $vendorContactCompany->escaped_contact_company_name;

	     		$subcontractActualValue = $subcontract->subcontract_actual_value;
	      		$totalAmount += $subcontractActualValue;
	      		$subcontractAmount += $subcontractActualValue;
	      		$estimatedSubcontractorAmount += $subcontractActualValue;
	      		$scoTotal += $subcontractActualValue;

	      		$countOfSCO = count($arrSubcontractChangeOrder);

	      		$costPerSqFtFormatted = '';
	      		if ($countOfSCO == 0) {
	      			$costPerSqFt = $subcontractActualValue/$unitCount;

	      			$costPerSqFtFormatted = Format::formatCurrency($costPerSqFt);
	      			if($reportType == 'pdf' && $costPerSqFt < 0){
						$costPerSqFtFormatted = '('.Format::formatCurrency(abs($costPerSqFt)).')';
					}
	      		}

				$subcontractActualValueFormatted = Format::formatCurrency($subcontractActualValue);
				if($reportType == 'pdf' && $subcontractActualValue < 0){
		     		$subcontractActualValueFormatted = '('.Format::formatCurrency(abs($subcontractActualValue)).')';
				}

				$subcontractIndexValue = 1;
				$ocoSubValueTd = '';
				if ($OCODisplay == 2) {
					$ocoSubValueTd = '<td style="border-bottom:none;"></td>';
				}
				if(($crntValOnly == 'true' && $isRowVisible == 'true') || ($crntValOnly == 'false')){
				// Subcontract vendor row
	    		$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
					<tr>
						<td style="border-bottom:none;"></td>
						<td style="border-bottom:none;"></td>
						<td style="border-bottom:none;"></td>
						$ocoSubValueTd
						<td style="border-bottom:none;"></td>
						<td style="border-top:1px solid #adadad;">$vendorCompany</td>
						<td></td>
						<td></td>
						<td class="textAlignRight">$subcontractActualValueFormatted</td>
						<td></td>
						<td class="textAlignRight">$costPerSqFtFormatted</td>
					</tr>
END_BUDGET_HTML_CONTENT;
				}
		
        		foreach ($arrSubcontractChangeOrder as $subcontractChangeOrder) {
		          	$approvePrefix = $subcontractChangeOrder['approve_prefix'];
		          	$estimatedAmount = $subcontractChangeOrder['estimated_amount'];
		          	$totalAmount += $estimatedAmount;
		          	$subcontractAmount += $estimatedAmount;
		          	$estimatedSubcontractorAmount += $estimatedAmount;
		          	$scoTotal += $estimatedAmount;		          	
		          	$total_Sco_amount += $estimatedAmount;
		          	$overall_Sco_amount += $estimatedAmount;

		          	$estimatedAmountFormatted = Format::formatCurrency($estimatedAmount);
					if($reportType == 'pdf' && $estimatedAmount < 0){
					    $estimatedAmountFormatted = '('.Format::formatCurrency(abs($estimatedAmount)).')';
					}

					$costPerSqFt = $subcontractAmount/$unitCount;

					if ($countOfSCO == $subcontractIndexValue) {
						$costPerSqFtFormatted = Format::formatCurrency($costPerSqFt);
						if($reportType == 'pdf' && $costPerSqFt < 0){
							$costPerSqFtFormatted = '('.Format::formatCurrency(abs($costPerSqFt)).')';
						}
					}

					$ocoScoValueTd = '';
					if ($OCODisplay == 2) {
						$ocoScoValueTd = '<td style="border-bottom:none;"></td>';
					}
					if(($crntValOnly == 'true' && $isRowVisible == 'true') || ($crntValOnly == 'false')){
					// SCO vendor row
			    	$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
						<tr>
							<td style="border-bottom:none;"></td>
							<td style="border-bottom:none;"></td>
							<td style="border-bottom:none;"></td>
							$ocoScoValueTd
							<td style="border-bottom:none;"></td>
							<td style="border-bottom:none;"></td>
							<td>$approvePrefix</td>
							<td class="textAlignRight">$estimatedAmountFormatted</td>
							<td class="textAlignRight">$estimatedAmountFormatted</td>
							<td></td>
							<td class="textAlignRight">$costPerSqFtFormatted</td>
						</tr>
END_BUDGET_HTML_CONTENT;
					}
          			$subcontractIndexValue++;
        		}
	    	}

	    	$ocoForcastValueTd = '';
			if ($OCODisplay == 2) {
				$ocoForcastValueTd = '<td style="border-bottom:none;"></td>';
			}
			if(($crntValOnly == 'true' && $isRowVisible == 'true') || ($crntValOnly == 'false')){
			// Forecasted row
	    	$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
				<tr>
					<td style="border-bottom:none;"></td>
					<td style="border-bottom:none;"></td>
					<td style="border-bottom:none;"></td>
					$ocoForcastValueTd
					<td style="border-bottom:none;"></td>
					<td style="border-top:1px solid #adadad;">Forecasted</td>
					<td></td>
					<td></td>
					<td class="textAlignRight">$forecastedExpensesFormatted</td>
					<td></td>
					<td></td>
				</tr>
END_BUDGET_HTML_CONTENT;
			}

            $ocoBuyoutForcastValueTd = '';
			if ($OCODisplay == 2) {
				$ocoBuyoutForcastValueTd = '<td style="border-bottom:none;"></td>';
			}

			if(($crntValOnly == 'true' && $isRowVisible == 'true') || ($crntValOnly == 'false')){
			// BuyoutForecasted row
	    	$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
				<tr>
					<td style="border-bottom:none;"></td>
					<td style="border-bottom:none;"></td>
					<td style="border-bottom:none;"></td>
					$ocoBuyoutForcastValueTd
					<td style="border-bottom:none;"></td>
					<td style="border-top:1px solid #adadad;">Buyout Forecasted Expenses</td>
					<td></td>
					<td></td>
					<td class="textAlignRight">$buyoutForecastExpensesFormatted</td>
					<td></td>
					<td></td>
				</tr>
END_BUDGET_HTML_CONTENT;
			}

			$totalEstimatedSubcontractValue += $totalAmount;

	    	$totalAmountFormatted = Format::formatCurrency($totalAmount);
			if($reportType == 'pdf' && $totalAmount < 0){
				$totalAmountFormatted = '('.Format::formatCurrency(abs($totalAmount)).')';
			}

			$scoTotalFormatted = Format::formatCurrency($scoTotal);
			if($reportType == 'pdf' && $scoTotal < 0){
				$scoTotalFormatted = '('.Format::formatCurrency(abs($scoTotal)).')';
			}

	    	$variance = $scheduledValue - $totalAmount;
	    	$totalVariance += $variance;

	    	$varianceFormatted = Format::formatCurrency($variance);
			if($reportType == 'pdf' && $variance < 0){
				$varianceFormatted = '('.Format::formatCurrency(abs($variance)).')';
			}

	    	$totalCostPerSqFt = $estimatedSubcontractorAmount/$unitCount;
	    	$totalCostPerSqFtFormatted = Format::formatCurrency($totalCostPerSqFt);
			if($reportType == 'pdf' && $totalCostPerSqFt < 0){
				$totalCostPerSqFtFormatted = '('.Format::formatCurrency(abs($totalCostPerSqFt)).')';
			}

			$totalScoAmountFormatted = Format::formatCurrency($total_Sco_amount);
			if($reportType == 'pdf' && $total_Sco_amount < 0){
				$totalScoAmountFormatted = '('.Format::formatCurrency(abs($total_Sco_amount)).')';
			}

			$ocoTotValueTd = '';
			if ($OCODisplay == 2) {
				$ocoTotValueTd = '<td style="border-bottom:none;"></td>';
			}
			if(($crntValOnly == 'true' && $isRowVisible == 'true') || ($crntValOnly == 'false')){
			// Total row
	    	$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
				<tr style="font-weight: bold;">
					<td style="border-bottom:none;"></td>
					<td style="border-bottom:none;"></td>
					<td style="border-bottom:none;"></td>
					$ocoTotValueTd
					<td style="border-bottom:none;"></td>
					<td class="purStyle" style="border-top:1px solid #adadad;">Total</td>
					<td class="purStyle"></td>
					<td class="textAlignRight purStyle">$totalScoAmountFormatted</td>
					<td class="textAlignRight purStyle">$scoTotalFormatted</td>
					<td class="textAlignRight purStyle">$varianceFormatted</td>
					<td class="textAlignRight purStyle">$totalCostPerSqFtFormatted</td>
				</tr>
END_BUDGET_HTML_CONTENT;
				if ($crntNotes == 'true' && $notes != '') {
					$notes = nl2br($notes);
					$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
					<tr>
						<td style="border-bottom:none;"></td>
						<td style="border-bottom:none;"></td>
						<td style="border-bottom:none;"></td>
						<td style="border-bottom:none;"></td>
						$ocoTotValueTd
						<td style="border-bottom:none;"></td>
						<td class="purStyle" style="border-top:1px solid #adadad;font-weight: bold;">NOTES :</td>
						<td colspan="5">$notes</td>
					</tr>
END_BUDGET_HTML_CONTENT;
				}
			}
	  	// } 
	if(($crntValOnly == 'true' && $isRowVisible == 'true') || ($crntValOnly == 'false')){
		$sub_tot_ori_pscv = $sub_tot_ori_pscv + $originalPSCV;
		$sub_tot_oco = $sub_tot_oco + $oco_value;
		$sub_tot_reallocation = round(($sub_tot_reallocation + $reallocation_Val),2);
		$sub_tot_pscv = $sub_tot_pscv + $scheduledValue;
		$sub_tot_sco = $sub_tot_sco + $total_Sco_amount;
		$sub_tot_crt_subcon = $sub_tot_crt_subcon + $scoTotal;		
		$sub_tot_variance = $sub_tot_variance + $variance;
		$sub_tot_cost_per_unit = $sub_tot_cost_per_unit + $totalCostPerSqFt;
		$tot_sub_tot_cost_per_unit += $totalCostPerSqFt;
	}

		if ($costCodeDivisionCount == 0 && $crntSubtotal == "true") {
	
			$sub_tot_ori_pscv_f = Format::formatCurrency($sub_tot_ori_pscv);
			if ($reportType == 'pdf' && $sub_tot_ori_pscv < 0) {
				$sub_tot_ori_pscv_f = '('.Format::formatCurrency(abs($sub_tot_ori_pscv)).')';
			}

			$sub_tot_reallocation_f = Format::formatCurrency($sub_tot_reallocation);
			if ($reportType == 'pdf' && $sub_tot_reallocation < 0) {
				$sub_tot_reallocation_f = '('.Format::formatCurrency(abs($sub_tot_reallocation)).')';
			}

			$sub_tot_oco_f = Format::formatCurrency($sub_tot_oco);
			if ($reportType == 'pdf' && $sub_tot_oco < 0) {
				$sub_tot_oco_f = '('.Format::formatCurrency(abs($sub_tot_oco)).')';
			}

			$sub_tot_pscv_f = Format::formatCurrency($sub_tot_pscv);
			if ($reportType == 'pdf' && $sub_tot_pscv < 0) {
				$sub_tot_pscv_f = '('.Format::formatCurrency(abs($sub_tot_pscv)).')';
			}

			$sub_tot_sco_f = Format::formatCurrency($sub_tot_sco);
			if ($reportType == 'pdf' && $sub_tot_sco < 0) {
				$sub_tot_sco_f = '('.Format::formatCurrency(abs($sub_tot_sco)).')';
			}

			$sub_tot_crt_subcon_f = Format::formatCurrency($sub_tot_crt_subcon);
			if ($reportType == 'pdf' && $sub_tot_crt_subcon < 0) {
				$sub_tot_crt_subcon_f = '('.Format::formatCurrency(abs($sub_tot_crt_subcon)).')';
			}

			$sub_tot_variance_f = Format::formatCurrency($sub_tot_variance);
			if ($reportType == 'pdf' && $sub_tot_variance < 0) {
				$sub_tot_variance_f = '('.Format::formatCurrency(abs($sub_tot_variance)).')';
			}

			$sub_tot_cost_per_unit_f = Format::formatCurrency($sub_tot_cost_per_unit);
			if ($reportType == 'pdf' && $sub_tot_cost_per_unit < 0) {
				$sub_tot_cost_per_unit_f = '('.Format::formatCurrency(abs($sub_tot_cost_per_unit)).')';
			}

			$ocoSubCostTotValueTd = '';
			if ($OCODisplay == 2) {
				$ocoSubCostTotValueTd = '<td class="textAlignRight">'.$sub_tot_oco_f.'</td>';
			}
			$isSubtotalRowVisible = 'true';
			if($sub_tot_ori_pscv == 0 && $sub_tot_crt_subcon == 0){
				$isSubtotalRowVisible = 'false';
			}
			if(($crntValOnly == 'true' && $isSubtotalRowVisible == 'true') || ($crntValOnly == 'false')){
			$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
				<tr style="background: #9f9e9e;text-transform: uppercase;font-weight:bold;">
					<td class="textAlignCenter">$costCodeDivNo</td>
					<td>Subtotal</td>
					<td class="textAlignRight">$sub_tot_ori_pscv_f</td>
					<td class="textAlignRight">$sub_tot_reallocation_f</td>
					$ocoSubCostTotValueTd
					<td class="textAlignRight">$sub_tot_pscv_f</td>
					<td></td>
					<td></td>
					<td class="textAlignRight">$sub_tot_sco_f</td>
					<td class="textAlignRight">$sub_tot_crt_subcon_f</td>
					<td class="textAlignRight">$sub_tot_variance_f</td>
					<td class="textAlignRight">$sub_tot_cost_per_unit_f</td>
				</tr>
END_BUDGET_HTML_CONTENT;
			}
			$sub_tot_ori_pscv = $sub_tot_reallocation = $sub_tot_oco = $sub_tot_pscv = 0;
			$sub_tot_sco = $sub_tot_crt_subcon = $sub_tot_variance = $sub_tot_cost_per_unit = 0;
		}
		$loopCounter++;
		$costCodeDivisionCount++;
	}

	$totalPrimeScheduleValueFormatted = Format::formatCurrency($totalPrimeScheduleValue);
	if($reportType == 'pdf' && $totalPrimeScheduleValue < 0){
		$totalPrimeScheduleValueFormatted = '('.Format::formatCurrency(abs($totalPrimeScheduleValue)).')';
	}

	$totalEstimatedSubcontractValueFormatted = Format::formatCurrency($totalEstimatedSubcontractValue);
	if($reportType == 'pdf' && $totalEstimatedSubcontractValue < 0){
		$totalEstimatedSubcontractValueFormatted = '('.Format::formatCurrency(abs($totalEstimatedSubcontractValue)).')';
	}

	$totalVarianceFormatted = Format::formatCurrency($totalVariance);
	if($reportType == 'pdf' && $totalVariance < 0){
		$totalVarianceFormatted = '('.Format::formatCurrency(abs($totalVariance)).')';
	}

	$subtotalCostPerSqFtFormatted = Format::formatCurrency($tot_sub_tot_cost_per_unit);
	if($reportType == 'pdf' && $subtotalCostPerSqFt < 0){
		$subtotalCostPerSqFtFormatted = '('.Format::formatCurrency(abs($tot_sub_tot_cost_per_unit)).')';
	}

	$overall_Original_PSCV_f = Format::formatCurrency($overall_Original_PSCV);
	if($reportType == 'pdf' && $overall_Original_PSCV < 0){
		$overall_Original_PSCV_f = '('.Format::formatCurrency(abs($overall_Original_PSCV)).')';
	}

	$overall_OCO_Val_f = Format::formatCurrency($overall_OCO_Val);
	if($reportType == 'pdf' && $overall_OCO_Val < 0){
		$overall_OCO_Val_f = '('.Format::formatCurrency(abs($overall_OCO_Val)).')';
	}

	$overall_Reallocation_Val_f = Format::formatCurrency($overall_Reallocation_Val);
	if($reportType == 'pdf' && $overall_Reallocation_Val < 0){
		$overall_Reallocation_Val_f = '('.Format::formatCurrency(abs($overall_Reallocation_Val)).')';
	}

	$overall_Sco_amount_f = Format::formatCurrency($overall_Sco_amount);
	if($reportType == 'pdf' && $overall_Sco_amount < 0){
		$overall_Sco_amount_f = '('.Format::formatCurrency(abs($overall_Sco_amount)).')';
	}

	$ocoSubTotValueTd = '';
	if ($OCODisplay == 2) {
		$ocoSubTotValueTd = '<td style="border-top:1px solid #adadad;">'.$overall_OCO_Val_f.'</td>';
	}
	// Sub Totals row
	if (count($arrGcBudgetLineItems) > 0) {		
		$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
			<tr class="textAlignRight purStyle" style="font-weight: bold;">
				<td colspan='2' style="border-top:1px solid #adadad;">Sub Totals</td>
				<td style="border-top:1px solid #adadad;">$overall_Original_PSCV_f</td>
				<td style="border-top:1px solid #adadad;">$overall_Reallocation_Val_f</td>
				$ocoSubTotValueTd
				<td style="border-top:1px solid #adadad;">$totalPrimeScheduleValueFormatted</td>
				<td></td>
				<td></td>
				<td>$overall_Sco_amount_f</td>
				<td>$totalEstimatedSubcontractValueFormatted</td>
				<td style="border-top:1px solid #adadad;">$totalVarianceFormatted</td>
				<td>$subtotalCostPerSqFtFormatted</td>
			</tr>
END_BUDGET_HTML_CONTENT;
	}

if ($OCODisplay == 1) {

	//Fetch the change order data
	$loadChangeOrdersByProjectIdOptions = new Input();
	$loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
	$loadChangeOrdersByProjectIdOptions->change_order_type_id = 2;
	$loadChangeOrdersByProjectIdOptions->change_order_status_id = 2; //For approved
	$arrChangeOrders = ChangeOrder::loadChangeOrdersByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);

	$ocoColspan = 6;

	$totalCoTotalValue = 0;
	$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
		<tr class="permissionTableMainHeaderTd">
			<td class="align-center">Custom #</td>
			<td class="align-center">COR</td>
			<td class="align-center" colspan="2">Title</td>
			<td class="align-center">Amount</td>
			<td colspan="$ocoColspan"></td>
		</tr>
END_BUDGET_HTML_CONTENT;

	foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
  		$coCustomSeq = $changeOrder->co_custom_sequence_number;
  		$coTypePrefix = $changeOrder->co_type_prefix;
  		// HTML Entity Escaped Data
  		$changeOrder->htmlEntityEscapeProperties();
  		$escapedCoTitle = $changeOrder->escaped_co_title;

  		$coTotal = $changeOrder->co_total;
  		$totalCoTotalValue += $coTotal;
  		
  		$coTotalFormatted = Format::formatCurrency($coTotal);
		if($reportType == 'pdf' && $coTotal < 0){
			$coTotalFormatted = '('.Format::formatCurrency(abs($coTotal)).')';
		}
		$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
			<tr>
				<td class="align-center">$coCustomSeq</td>
				<td class="align-center">$coTypePrefix</td>
				<td class="align-left" colspan="2">$escapedCoTitle</td>
				<td align="right">$coTotalFormatted</td>
				<td colspan="$ocoColspan"></td>
			</tr>
END_BUDGET_HTML_CONTENT;
	}

	if(count($arrChangeOrders) > 0){
		//change orders total
		$coTotalValueFormatted = Format::formatCurrency($totalCoTotalValue);
		if($reportType == 'pdf' && $totalCoTotalValue < 0){
			$coTotalValueFormatted = '('.Format::formatCurrency(abs($totalCoTotalValue)).')';
		}
		$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
			<tr class="purStyle">
				<td class="textAlignRight" colspan='4'><b>Approved Change Orders Total</b></td>
				<td class="textAlignRight"><b>$coTotalValueFormatted</b></td>
				<td colspan="$ocoColspan"></td>
			</tr>
END_BUDGET_HTML_CONTENT;

		$projectTotal = $totalPrimeScheduleValue + $totalCoTotalValue;
		$projectTotalFormatted = Format::formatCurrency($projectTotal);
		if($reportType == 'pdf' && $projectTotal < 0){
			$projectTotalFormatted = '('.Format::formatCurrency(abs($projectTotal)).')';
		}
		$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
			<tr class="permissionTableMainHeader">
				<td class="textAlignRight" colspan="4"><b>Project Totals</b></td>
				<td class="textAlignRight"><b>$projectTotalFormatted</b></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="textAlignRight"><b>$totalEstimatedSubcontractValueFormatted</b></td>
				<td class="textAlignRight"><b>$totalVarianceFormatted</b></td>
				<td></td>
			</tr>
END_BUDGET_HTML_CONTENT;
	}

	if(count($arrChangeOrders) == 0){
	 	$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
	  		<tr><td colspan="$totalspan">No Data Available</td></tr>
END_BUDGET_HTML_CONTENT;
	}
}

 	$ocoTitle = '';
	if ($OCODisplay == 2) {
		$ocoTitle = '<th style="width:60px">OCO</th>';
	}

	$htmlContent = <<<END_HTML_CONTENT
	<table id="currentBudgetReportUnits" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="15%">
	 <tr>
	  <td class="align-left"><b>Units</b></td>
		<td class="align-left">$unitCount</td>
	 </tr>
	 <tr>
	  <td class="align-left"><b>SF</b></td>
		<td class="align-left">$netRentableSqFt</td>
	 </tr>
	</table>
	<table id="currentBudgetTblTabularData" border="0" cellpadding="5" cellspacing="0" width="100%">
		<tr class="table-headerinner" style="vertical-align: center;">
        	<th style="width:60px">Cost Code</th>
        	<th style="width:60px">Description</th>
        	<th style="width:60px">Original PSCV</th>
        	<th style="width:60px;max-width: 80px !important;">Reallocation</th>
        	$ocoTitle
        	<th style="width:60px;">Prime Contract</th>
			<th style="width:140px">Subcontracted Vendor</th>
			<th style="width:60px;">SCO's</th>
			<th style="width:60px;">SCO Value</th>
        	<th style="width:60px;">Subcontract + SCO's</th>
			<th style="width:60px;">Variance</th>
			<th style="width:60px;">Cost Per Unit</th>
      </tr>
       $gcCurrentBudgetItemBody
 </table>
END_HTML_CONTENT;
	$htmlContent .= buyoutTotalTable($total_buyout_forcast,$total_forcast);

  return $htmlContent;

}
//check if a row is empty in excel
function isEmptyRow($row){
    foreach($row as $cell){
        if (null !== $cell) return false;
    }
    return true;
}
//import cost code headers
function getCostCodeHeaders($rowNumber, $objPHPExcel){
	$row = $objPHPExcel->getActiveSheet()->getRowIterator($rowNumber)->current();

	$cellIterator = $row->getCellIterator();
	$cellIterator->setIterateOnlyExistingCells(false);
  $htmlOptions = '';
	foreach ($cellIterator as $cell) {
			$options = $cell->getCalculatedValue();
			$colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
			if(!empty($options)){
				$htmlOptions .= "<option value='$colIndex'>$options</option>";
			}
	 }
	 return $htmlOptions;
}

function LoadEsignaturecontents($database)
{
	$session = Zend_Registry::get('session');
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
	$project_id = $session->getCurrentlySelectedProjectId();
	$filename = md5($currentlyActiveContactId);
	$config = Zend_Registry::get('config');	
	$file_manager_base_path = $config->system->file_manager_base_path;
	$save = $file_manager_base_path.'backend/procedure/';
	
	$signfile_name = $save.$filename.'.png';


	$filegetcontent = file_get_contents($signfile_name);
	$base64 = 'data:image;base64,' . base64_encode($filegetcontent);
	if($filegetcontent =="")
	{
		$dispcheck ="display:none;";
	}else
	{
		$dispcheck ="";
	}
	$db = DBI::getInstance($database);
	$query ="Select * from  signature_data where `contact_id`= ?";
	$arrValues = array($currentlyActiveContactId);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$updated_date = $row['date']; 
	$type = $row['type'];
	$db->free_result();

	//to check which method user had signed
	$uploadstyle = ($type=='1')?"display:block;":"display:none;";
	$drawstyle = ($type=='2')?"display:block;":"display:none;";
	$imgstyle = ($type=='3')?"display:block;":"display:none;";

	$uploadcheck = ($type=='1')?"checked='true'":"";
	$drawcheck = ($type=='2')?"checked='true'":"";
	$imgcheck = ($type=='3')?"checked='true'":"";
	

	
	if($updated_date !="")
	{
		$dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $updated_date);
		$updated_date = $dateObj->format('m/d/Y');
	}
	// To upload a image
	$input = new Input();
	$input->id = 'uploader--esignature';
	$input->folder_id = '';
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Subcontract Change Order/Attachments/';
	$input->prepend_date_to_filename = true;
	$input->action = '/esignature/sign_src/save_sign.php';
	$input->method = 'uploadimgforesign';
	$input->allowed_extensions = 'gif,jpg,jpeg,png';
	$input->post_upload_js_callback = "loadpreviewAfterimgupload()";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

	$htmlContent = <<<END_HTML_CONTENT
	<table id="signTblTabularData" class="detailed_week content  
	signature-table-head cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
		<tr class="">
        <td colspan='2' class="" style="font-weight: bold;padding-bottom: 15px;padding-top: 10px;">How would you like to create your signature?</td>
         </tr>
         <tr class="">
         <td class="">
         <label class="DCRtext"><input type="radio" value="type_my_signature" name="signset" class="radioLable" onclick="signsetchanges()" $uploadcheck>Type my signature</label></td>
       
          </tr>
         <tr class="">
          <td class="">
         <label class="DCRtext"><input type="radio" value="draw_signimage" name="signset" class="radioLable" onclick="signsetchanges()" $drawcheck>Draw my signature</label></td>
          </tr>
         <tr class="">
          <td class="">
         <label class="DCRtext"><input type="radio" value="upload_signimage" name="signset" class="radioLable" onclick="signsetchanges()" $imgcheck >Use a image</label></td>
       
      	</tr>
      	</table>

 	<div id="upload_signimage" class="upload_signimage uploadimg-sinature textAlignCenter actions" style="margin-top:20px;$imgstyle">
		{$fileUploader}
		{$fileUploaderProgressWindow}
		
		<img src="$base64" class="sign-preview" width="300px" height="100px" style="$dispcheck"/>
		<div id="signdata" style="margin-top: 7px;font-size: 12px;margin-left: 60px;margin-left: -33px;">Last Updated : <div class="eupdatedate" style="display: inline-block;">$updated_date</div>
		</div>
	</div>

	<div id="draw_signimage" class="draw_signimage textAlignCenter actions draw-mysign-section" style="margin-top:20px;$drawstyle">
	
		<div id="signArea" style="width:43%;">
		<h4 class="tag-ingo">Put signature below,</h4>
		<div class="sig sigWrapper" style="height:auto;float:left;">
		<div class="typed"></div>
		<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
		</div>
		</div>

		<div class="sign-container" >
		<img src="$base64" class="sign-preview" width="300px" height="100px" style="$dispcheck"/>
		<div id="signdata" style="margin-top: 7px;font-size: 12px;">Last Updated : <div class="eupdatedate" style="display: inline-block;">$updated_date</div></div>
		</div>
		
		<div class="textAlignCenter actions" style="margin-top:20px;">
		<input type="button" id="btnSaveSign" value="Save Signature" onclick="saveDrawSign(event)">
		<input type="button" id="btnClearSign" value="Clear" onclick="ToclearDrawSign()">
		</div>
		</div>


 <div id="type_my_signature" class="type_my_signature enter-name-signsection" style="$uploadstyle">
 <label style="font-weight: bold;width: 190px;text-align: left;">Enter Your Name:</label>
 <input type="text" class="RFI_table2 required target signtext" id="html-content-holder" onkeyup="showTextPreview(this.value)"> 		
 <div class="" style="width: 100%;overflow: hidden;text-align: center;margin: 25px 0 0;">
    <label style="font-weight: bold;width: 190px;text-align: left;">Review Your Signature:</label>
    <div id="previewImage" style="float:left;">
    </div>
    </div>
    <div style="width: 100%;text-align: center;margin: 25px 0 15px;overflow: hidden;">
    <input type="button" id="btn-Convert-Html2Image" value="Save Signature" onclick="saveTextAsSign()">
    </div>
 </div>

END_HTML_CONTENT;
return $htmlContent;

}
