<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

require_once('lib/common/BidItemToSubcontractorBid.php');
require_once('lib/common/Constants.php');
require_once('lib/common/Contact.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/GcBudgetLineItemBidInvitation.php');
require_once('lib/common/GcBudgetLineItemRelationship.php');
require_once('lib/common/GcBudgetLineItemUnsignedScopeOfWorkDocument.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/FormComponents.php');
require_once('lib/common/SubcontractorBid.php');
require_once('lib/common/SubcontractorBidDocument.php');
require_once('lib/common/SubcontractorBidDocumentType.php');
require_once('lib/common/SubcontractorBidNote.php');
require_once('lib/common/SubcontractorBidStatus.php');
require_once('lib/common/SubcontractorBidStatusGroup.php');
require_once('lib/common/SubcontractorBidStatusGroupToSubcontractorBidStatus.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');

require_once('modules-purchasing-functions.php');
require_once('page-components/fileUploader.php');
require_once('lib/common/ModulesBiddingDocumentHelper.php');

function renderBiddingContent($database, $user_company_id, $project_id, $currentlyActiveContactId, $toggleAdvancedMode = false)
{
	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$debugMode = $session->getDebugMode();

	$loadAllSubcontractorBidStatusesOptions = new Input();
	$loadAllSubcontractorBidStatusesOptions->forceLoadFlag = true;
	$loadAllSubcontractorBidStatusesOptions->arrOrderByAttributes = array(
		'sbs.`id`' => 'ASC'
	);
	$arrSubcontractorBidStatuses = SubcontractorBidStatus::loadAllSubcontractorBidStatuses($database, $loadAllSubcontractorBidStatusesOptions);

	$htmlContent = '';

	/*
	$options = new Input();
	$options->forceLoadFlag = true;
	$options->arrOrderByAttributes = array(
		'sb.`subcontractor_bid_status_id`' => 'ASC'
	);
	*/

	// This method call returns a hierarchy of arrays that mirrors the UI hierarchy: subcontractor_bids
	// grouped by subcontractor_bid_status, subgrouped by cost_code. Hence the 3 nested loops.
	$arrAllSubcontractorBidStatusGroups = SubcontractorBidStatusGroup::loadAllSubcontractorBidStatusGroups($database);

	$arrSubcontractorBidsByProjectIdOrganizedBySubcontractorBidStatusGroupIdByCostCodeId =
		SubcontractorBid::loadSubcontractorBidsByProjectIdOrganizedBySubcontractorBidStatusGroupIdByCostCodeId($database, $project_id);

	foreach ($arrSubcontractorBidsByProjectIdOrganizedBySubcontractorBidStatusGroupIdByCostCodeId as $subcontractor_bid_status_group_id => $cost_code_id) {
		$arrSubcontractorBidsBySubcontractorBidStatusGroupId = $arrSubcontractorBidsByProjectIdOrganizedBySubcontractorBidStatusGroupIdByCostCodeId[$subcontractor_bid_status_group_id];

		//$subcontractorBidStatus = SubcontractorBidStatus::findById($database, $subcontractor_bid_status_id);
		//$subcontractor_bid_status = $subcontractorBidStatus->subcontractor_bid_status;

		$subcontractorBidStatusGroup = $arrAllSubcontractorBidStatusGroups[$subcontractor_bid_status_group_id];
		/* @var $subcontractorBidStatusGroup SubcontractorBidStatusGroup */

		$subcontractor_bid_status_group = $subcontractorBidStatusGroup->subcontractor_bid_status_group;

		if ($debugMode) {
			//$subcontractor_bid_status = '('.$subcontractor_bid_status_id.') '.$subcontractor_bid_status;
			$subcontractor_bid_status_group = '('.$subcontractor_bid_status_group_id.') '.$subcontractor_bid_status_group;
		}

		// Outer accordion header.
		$htmlContent .= <<<END_HTML_CONTENT

		<div class="accordion-header">
			<span class="title">$subcontractor_bid_status_group</span>
			<div style="float:right">
				<span class="accordion-link"><input type="button" onclick="expandInnerAccordions(this, event);" value="Expand/Collapse All Cost Codes"></span>
				<span class="accordion-link enable-uploaders"><input type="button" class="toggle-cost-code-level-uploaders" onclick="toggleDynamicUploadersAtCostCodeLevel(this, event);" value="Toggle All Cost Code Drag &amp; Drop File Uploads"></span>
			</div>
		</div>
		<ul class="accordion-content">
END_HTML_CONTENT;

		foreach ($arrSubcontractorBidsBySubcontractorBidStatusGroupId as $cost_code_id => $subcontractor_bid_id) {
			$cost_code_id = (int) $cost_code_id;

			$arrSubcontractorBidsByCostCodeId = $arrSubcontractorBidsBySubcontractorBidStatusGroupId[$cost_code_id];

			// @todo Potentially refactor this to return the $costCode and $costCodeDivision objects as well
			$gcBudgetLineItem = GcBudgetLineItem::findByUserCompanyIdAndProjectIdAndCostCodeId($database, $user_company_id, $project_id, $cost_code_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */

			$gc_budget_line_item_id = $gcBudgetLineItem->gc_budget_line_item_id;
			$costCode = CostCode::findById($database, $cost_code_id);
			/* @var $costCode CostCode */

			// This below method call will lazy load $costCodeDivision
			$formattedCostCode = $costCode->getFormattedCostCode($database);
			$htmlEntityEscapedFormattedCostCodeLabel = $costCode->getHtmlEntityEscapedFormattedCostCode($user_company_id);

			$costCodeDivision = $costCode->getCostCodeDivision();
			/* @var $costCodeDivision CostCodeDivision */

			$cost_code_division_id = $costCodeDivision->cost_code_division_id;

			$division_number = $costCodeDivision->division_number;
			$cost_code = $costCode->cost_code;
			$cost_code_description =$costCode->cost_code_description;

			$division_code_heading = $costCodeDivision->division_code_heading;
			$division = $costCodeDivision->division;

			// HTML Entity escaped versions
			$escaped_division_number = $costCodeDivision->escaped_division_number;
			$escaped_cost_code = $costCode->escaped_cost_code;
			$escaped_cost_code_description = $costCode->escaped_cost_code_description;

			$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
			$escaped_division = $costCodeDivision->escaped_division;


			// Configure the file uploaders for the bid documents of the current gc_budget_line_item.
			// File Uploader: Cost Code Level Invitations To Bid
			// gc_budget_line_item_bid_invitations (gc_budget_line_items <user_company_id, project_id, cost_code_id>)
			// Configure the gc_budget_line_item_bid_invitations file uploader.
			$gc_budget_line_item_bid_invitation_virtual_file_path = "/Bidding & Purchasing/$formattedCostCode/[{$division_number}-{$cost_code}] Bid Invitations/";
			$gcBudgetLineItemBidInvitationsFileManagerFolder =
				FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $gc_budget_line_item_bid_invitation_virtual_file_path);
			/* @var $gcBudgetLineItemBidInvitationsFileManagerFolder FileManagerFolder */
			$gc_budget_line_item_bid_invitation_file_manager_folder_id = $gcBudgetLineItemBidInvitationsFileManagerFolder->file_manager_folder_id;


			// File Uploader: Cost Code Level Unsigned Scope of Work Documents
			// gc_budget_line_item_unsigned_scope_of_work_documents
			// Configure the gc_budget_line_item_unsigned_scope_of_work_documents file uploader.
			$gc_budget_line_item_unsigned_scope_of_work_document_virtual_file_path = "/Bidding & Purchasing/$formattedCostCode/[{$division_number}-{$cost_code}] Unsigned Scope of Work Documents/";
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileManagerFolder =
				FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $gc_budget_line_item_unsigned_scope_of_work_document_virtual_file_path);
			/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileManagerFolder FileManagerFolder */
			$gc_budget_line_item_unsigned_scope_of_work_document_file_manager_folder_id = $gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileManagerFolder->file_manager_folder_id;


			// Drop Down List of pdf files - gc_budget_line_item_bid_invitations
			// Load the bid invitation documents for the current gc_budget_line_item into a dropdown.
			$gcBudgetLineItemBidInvitationBootstrapDropdownContainerElementId = 'bidding-module-files-bootstrap-dropdown--gc_budget_line_item_bid_invitations--subcontractor_bid_status_group_id-gc_budget_line_item_id--'.$subcontractor_bid_status_group_id.'-'.$gc_budget_line_item_id;
			$abbreviatedFilenameFlag = false;
			$includeParentSpanTags = true;
			$parentOpeningSpanTagElementId = $gcBudgetLineItemBidInvitationBootstrapDropdownContainerElementId;
			$arrReturn = renderGcBudgetLineItemBidInvitationFilesAsUrlListBiddingVersion($database, $subcontractor_bid_status_group_id, $gc_budget_line_item_id, $abbreviatedFilenameFlag, $includeParentSpanTags, $parentOpeningSpanTagElementId);
			$gcBudgetLineItemBidInvitationsCount = $arrReturn['file_count'];
			$gcBudgetLineItemBidInvitationUploadButtonHasRightSibling = $arrReturn['right_sibling'];
			$gcBudgetLineItemBidInvitationHtml = $arrReturn['html'];


			// Drag & Drop File Uploader: gc_budget_line_item_bid_invitations
			// from bid_invitation_by_cost_code_upload--subcontractor_bid_status_group_id_'.$subcontractor_bid_status_group_id.'--gc_budget_line_item_id_'.$gc_budget_line_item_id;
			// to
			// --subcontractor_bid_status_group_id_'.$subcontractor_bid_status_group_id.'--gc_budget_line_item_id_'.$gc_budget_line_item_id;
			// Howard Note: if we fix the naming convention standard, we have to fix this parsed id
			// otherwise it will be broken
			// Check modules-purchasing-file-uploader-ajax.php $methodCall == 'gcBudgetLineItemBidInvitations'
			$gcBudgetLineItemBidInvitationsFileUploaderElementId = "biddingFileUploader_gcBudgetLineItemBidInvitationsBiddingVersion_{$gc_budget_line_item_id}_{$subcontractor_bid_status_group_id}";
			$gcBudgetLineItemBidInvitationsFileUploaderOptions = '{ gc_budget_line_item_id: '.$gc_budget_line_item_id.', element: this._element}';
			$gcBudgetLineItemBidInvitationsFileUploaderInput = new Input();
			$gcBudgetLineItemBidInvitationsFileUploaderInput->id = $gcBudgetLineItemBidInvitationsFileUploaderElementId;
			$gcBudgetLineItemBidInvitationsFileUploaderInput->class = 'notBoxViewUploader';
			$gcBudgetLineItemBidInvitationsFileUploaderInput->folder_id = $gc_budget_line_item_bid_invitation_file_manager_folder_id;
			$gcBudgetLineItemBidInvitationsFileUploaderInput->project_id = $project_id;
			$gcBudgetLineItemBidInvitationsFileUploaderInput->virtual_file_path = $gc_budget_line_item_bid_invitation_virtual_file_path;
			$gcBudgetLineItemBidInvitationsFileUploaderInput->virtual_file_name = $htmlEntityEscapedFormattedCostCodeLabel . ' - Bid Invitation.pdf';
			$gcBudgetLineItemBidInvitationsFileUploaderInput->append_date_to_filename = true;
			//$gcBudgetLineItemBidInvitationsFileUploaderInput->action = '/modules-file-manager-file-uploader-ajax.php';
			$gcBudgetLineItemBidInvitationsFileUploaderInput->action = '/modules-purchasing-file-uploader-ajax.php';
			//$gcBudgetLineItemBidInvitationsFileUploaderInput->method = 'uploadFiles';
			$gcBudgetLineItemBidInvitationsFileUploaderInput->method = 'gcBudgetLineItemBidInvitations';
			$gcBudgetLineItemBidInvitationsFileUploaderInput->allowed_extensions = 'pdf';
			// @todo Update the JS callback to ajax load the file list with checkboxes instead of passing in the variable: arrFileManagerFiles
			//$gcBudgetLineItemBidInvitationsFileUploaderInput->post_upload_js_callback = 'loadGcBudgetLineItemBidInvitationFilesAsUrlListBiddingVersion(arrFileManagerFiles, '.$gcBudgetLineItemBidInvitationsFileUploaderOptions.')';
			//$gcBudgetLineItemBidInvitationsFileUploaderInput->post_upload_js_callback = 'loadGcBudgetLineItemBidInvitationFilesAsUrlListBiddingVersion('.$gcBudgetLineItemBidInvitationsFileUploaderOptions.')';
			$gcBudgetLineItemBidInvitationsFileUploaderInput->post_upload_js_callback = "loadGcBudgetLineItemBidInvitationFilesAsUrlListBiddingVersion('$subcontractor_bid_status_group_id', '$gc_budget_line_item_id', '$gcBudgetLineItemBidInvitationBootstrapDropdownContainerElementId')";
			$gcBudgetLineItemBidInvitationsFileUploaderInput->custom_label = 'Drop/Click';
			$gcBudgetLineItemBidInvitationsFileUploaderInput->hidden = 'hidden';
			// Justin: Do we need subcontractor_bid_status_id or subcontractor_bid_status_group_id below for "options"?
			$gcBudgetLineItemBidInvitationsFileUploaderInput->static_uploader_options = array(
				'jsFunction' => 'gcBudgetLineItemBidInvitationSelected',
				//'options' => '{ subcontractor_bid_status_id: '.$subcontractor_bid_status_group_id.', gc_budget_line_item_id: '.$gc_budget_line_item_id.' }',
				'options' => '{ subcontractor_bid_status_group_id: '.$subcontractor_bid_status_group_id.', gc_budget_line_item_id: '.$gc_budget_line_item_id.' }',
				'uploadButtonHasRightSibling' => $gcBudgetLineItemBidInvitationUploadButtonHasRightSibling,
				'noOverride' => 'noOverride'
			);
			$gcBudgetLineItemBidInvitationsFileUploader = buildFileUploader($gcBudgetLineItemBidInvitationsFileUploaderInput);


			// Drop Down List of pdf files - gc_budget_line_item_unsigned_scope_of_work_documents
			// Load the unsigned scope documents for the current gc_budget_line_item into a dropdown.
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentBootstrapDropdownContainerElementId = 'bidding-module-files-bootstrap-dropdown--gc_budget_line_item_unsigned_scope_of_work_documents--subcontractor_bid_status_group_id-gc_budget_line_item_id--'.$subcontractor_bid_status_group_id.'-'.$gc_budget_line_item_id;
			$abbreviatedFilenameFlag = false;
			$includeParentSpanTags = true;
			$parentOpeningSpanTagElementId = $gcBudgetLineItemUnsignedScopeOfWorkDocumentBootstrapDropdownContainerElementId;
			$arrReturn = renderGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersion($database, $subcontractor_bid_status_group_id, $gc_budget_line_item_id, $abbreviatedFilenameFlag, $includeParentSpanTags, $parentOpeningSpanTagElementId);
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsCount = $arrReturn['file_count'];
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentUploadButtonHasRightSibling = $arrReturn['right_sibling'];
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentHtml = $arrReturn['html'];


			// @Todo: Fix below to use: modules-purchasing-file-uploader-ajax.php
			// Drag & Drop File Uploader: gc_budget_line_item_unsigned_scope_of_work_documents
			//$elementId = 'unsigned_scope_of_work_upload--'.$subcontractor_bid_status_id.'--'.$cost_code_id;
			// Howard Note: if we fix the naming convention standard, we have to fix this parsed id
			// otherwise it will be broken
			// Check modules-purchasing-file-uploader-ajax.php $methodCall == 'gcBudgetLineItemUnsignedScopeOfWorkDocuments'
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderElementId = "biddingFileUploader_gcBudgetLineItemUnsignedScopeOfWorkDocumentsBiddingVersion_{$gc_budget_line_item_id}_{$subcontractor_bid_status_group_id}";
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderOptions = '{ gc_budget_line_item_id: '.$gc_budget_line_item_id.', element: this._element }';
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput = new Input();
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->id = $gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderElementId;
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->class = 'notBoxViewUploader';
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->folder_id = $gc_budget_line_item_unsigned_scope_of_work_document_file_manager_folder_id;
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->project_id = $project_id;
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->virtual_file_path = $gc_budget_line_item_unsigned_scope_of_work_document_virtual_file_path;
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->virtual_file_name = $htmlEntityEscapedFormattedCostCodeLabel . ' - Unsigned Scope Of Work.pdf';
			//$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->action = '/modules-file-manager-file-uploader-ajax.php';
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->action = '/modules-purchasing-file-uploader-ajax.php';
			//$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->method = 'uploadFiles';
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->method = 'gcBudgetLineItemUnsignedScopeOfWorkDocuments';
																				 // loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersion
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->allowed_extensions = 'pdf';
			// @todo Update the JS callback to ajax load the file list with checkboxes instead of passing in the variable: arrFileManagerFiles
			//$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->post_upload_js_callback = 'loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersion(arrFileManagerFiles, '.$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderOptions.')';
			//$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->post_upload_js_callback = 'loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersion('.$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderOptions.')';
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->post_upload_js_callback = "loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersion('$subcontractor_bid_status_group_id', '$gc_budget_line_item_id', '$gcBudgetLineItemUnsignedScopeOfWorkDocumentBootstrapDropdownContainerElementId')";
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->custom_label = 'Drop/Click';
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->hidden = 'hidden';
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput->static_uploader_options = array(
				'jsFunction' => 'gcBudgetLineItemUnsignedScopeOfWorkDocumentSelected',
				//'options' => '{ subcontractor_bid_status_id: '.$subcontractor_bid_status_group_id.', gc_budget_line_item_id: '.$gc_budget_line_item_id.' }',
				'options' => '{ subcontractor_bid_status_group_id: '.$subcontractor_bid_status_group_id.', gc_budget_line_item_id: '.$gc_budget_line_item_id.' }',
				'uploadButtonHasRightSibling' => $gcBudgetLineItemUnsignedScopeOfWorkDocumentUploadButtonHasRightSibling,
				'noOverride' => 'noOverride'
			);
			$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploader = buildFileUploader($gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploaderInput);


			$bidActionsDropdown = <<<END_BID_ACTIONS_DROPDOWN

			<div class="bid-actions bootstrap-dropdown-clone" style="position: relative;">

				<input type="checkbox"
					id="bidding-module-bidders-select-all-checkbox-subcontractor_bid_status_group_id-$subcontractor_bid_status_group_id--subcontractor_bids--gc_budget_line_item_id--$gc_budget_line_item_id"
					class="
						bidding-module-bidders-select-all-checkbox--subcontractor_bids--gc_budget_line_item_id
						bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--$subcontractor_bid_status_group_id
						"
					onclick="handle_BiddingModuleBidder_GcBudgetLineItem_SelectAllCheckbox_ClickEvent(this, '$subcontractor_bid_status_group_id', '$gc_budget_line_item_id');"
					style="margin-left: 5px; position: relative;"
					value="$subcontractor_bid_status_group_id-$gc_budget_line_item_id">
				<button class="btn btn-default dropdown-toggle" style="border: 0px;" type="button" onclick="toggleBidActionsDropdown(this, event);">

					Actions
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a tabindex="-1" href="javascript:loadEmailModalDialog_SendSubcontractorBidCorrespondance({ defaultEmailMessageSubject: '[PROJECT_NAME] &mdash; Invitation To Bid', defaultEmailMessageBody: 'We cordially invite you to submit a bid proposal for the &ldquo;[PROJECT_NAME]&rdquo; project. Please see the attached files for more information regarding the project.' });">Send Bid Invitations</a></li>
					<!--li><a tabindex="-1" href="javascript:loadSendBidInvitationDialog();">Send Bid Invitations - Basic</a></li-->
					<li><a tabindex="-1" href="javascript:alert('Send Plans Link');">Send Plans Link</a></li>
					<li><a tabindex="-1" href="javascript:alert('Send New Unsigned Scope Of Work');">Send New Unsigned Scope Of Work</a></li>
					<li><a tabindex="-1" href="javascript:loadEmailModalDialog_SendSubcontractorBidCorrespondance();">Send Email</a></li>
				</ul>
			</div>
END_BID_ACTIONS_DROPDOWN;

			/*
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
					Dropdown
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
				</ul>
			</div>
			*/

			$bidSpreadLink = '/modules-purchasing-bid-spread.php?gc_budget_line_item_id=' . $gc_budget_line_item_id;

			if ($debugMode) {
				$htmlEntityEscapedFormattedCostCodeLabel = "($gc_budget_line_item_id) $htmlEntityEscapedFormattedCostCodeLabel";
			}
			// Outer accordion content / inner accordion header.
			$htmlContent .= <<<END_HTML_CONTENT

			<li class="subaccordion-container">
				<h3 class="subaccordion-header">
					<table border="0" width="100%">
						<tr>
							<td width="30%">
								<span class="title">$htmlEntityEscapedFormattedCostCodeLabel</span>
							</td>
							<td>
								&nbsp;
							</td>
							<td nowrap width="230">
								<div class="accordion-header-widget">
									<span class="uploader other-uploader">Bid Invitation: </span>
									<div class="fineUploader gcBudgetLineItemBidInvitationUploader" data-subcontractor_bid_status_id="$subcontractor_bid_status_group_id" data-gc_budget_line_item_id="$gc_budget_line_item_id"></div>
									{$gcBudgetLineItemBidInvitationsFileUploader}{$gcBudgetLineItemBidInvitationHtml}
								</div>
							</td>
							<td nowrap width="300">
								<div class="accordion-header-widget">
									<span class="uploader unsigned-scope-uploader">Unsigned Scope Of Work: </span>
									<div class="fineUploader gcBudgetLineItemUnsignedScopeOfWorkDocumentUploader" data-subcontractor_bid_status_id="$subcontractor_bid_status_group_id" data-gc_budget_line_item_id="$gc_budget_line_item_id"></div>
									{$gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileUploader}{$gcBudgetLineItemUnsignedScopeOfWorkDocumentHtml}
								</div>
							</td>
							<td nowrap width="1%">
								<div class="accordion-header-widget accordion-link">
									<a href="$bidSpreadLink" target="_blank" style="color:#06c !important; font-size:12px">View Spread</a>
								</div>
							</td>
							<td width="1%">
								<div class="accordion-header-widget accordion-link" style="opacity: 0; visibility: hidden;">
									<input type="button" class="toggle-bid-level-uploaders" onclick="toggleDynamicUploadersAtBidLevel(this, event);" value="Toggle Bidder Drag &amp; Drop File Uploads">
								</div>
							</td>
						</tr>
					</table>
				</h3>
				<div class="subaccordion-content" style="overflow: visible;">
					<table class="subcontractor-bid-group" border="0">
						<thead>
							<tr>
								<th align="left" style="padding-left: 0;" width="20%" nowrap>
									<table>
										<tr>
											<td>$bidActionsDropdown</td>
											<td style="vertical-align: middle;">Bidder</td>
										</tr>
									</table>
								</th>
								<th width="10%" nowrap>Bid Invite Date</th>
								<th width="9%" nowrap>Plans Downloaded</th>
								<th width="9%" nowrap>Subcontractor Bid</th>
								<th width="9%" nowrap>Signed Scope</th>
								<th class="biddingExpertMode" width="9%" nowrap>Bid Invitation</th>
								<th class="biddingExpertMode" width="9%" nowrap>Unsigned Scope</th>
								<th class="biddingExpertMode" width="15%" nowrap>Bid Status</th>
							</tr>
						</thead>
						<tbody class="altColors">
END_HTML_CONTENT;

			foreach ($arrSubcontractorBidsByCostCodeId as $subcontractor_bid_id => $subcontractorBid) {
				/* @var $subcontractorBid SubcontractorBid */

				$subcontractorContact = $subcontractorBid->getSubcontractorContact();
				/* @var $subcontractorContact Contact */

				$subcontractorContactCompany = $subcontractorBid->getSubcontractorContactCompany();
				/* @var $subcontractorContactCompany ContactCompany */

				$subcontractorContact->htmlEntityEscapeProperties();
				$subcontractorContactCompany->htmlEntityEscapeProperties();

				$subcontractor_contact_company_name = $subcontractorContactCompany->contact_company_name;
				$subcontractor_escaped_contact_company_name = $subcontractorContactCompany->escaped_contact_company_name;

				$subcontractorContactFullNameHtmlEscaped = $subcontractorContact->getContactFullNameHtmlEscaped();
				$escaped_email = $subcontractorContact->escaped_email;

				if ($debugMode) {
					//$subcontractorBidderDisplayName = $subcontractor_escaped_contact_company_name . ' (contact_company_id: ' . $subcontractorContactCompany->contact_company_id . ') &mdash; ' . $subcontractorContactFullNameHtmlEscaped . ' &lt;' . $escaped_email . '&gt;' . ' (sb.subcontractor_contact_id: ' . $subcontractorContact->contact_id . ')';
					$subcontractorBidderDisplayName = "$subcontractor_escaped_contact_company_name (contact_company_id: $subcontractorContactCompany->contact_company_id) &mdash; $subcontractorContactFullNameHtmlEscaped &lt;$escaped_email&gt; (sb.subcontractor_contact_id: $subcontractorContact->contact_id)";
				} else {
					//$subcontractorBidderDisplayName = $subcontractorContactFullNameHtmlEscaped . ' &lt;' . $escaped_email . '&gt;' . ' - ' . $subcontractor_escaped_contact_company_name;
					$subcontractorBidderDisplayName = $subcontractor_escaped_contact_company_name . ' &mdash; ' . $subcontractorContactFullNameHtmlEscaped . ' [' . $escaped_email . ']';
				}

				// Load the subcontractor_bid_documents for the current bid, grouped by subcontractor_bid_document_type.
				$loadSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentTypeOptions = new Input();
				$loadSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentTypeOptions->forceLoadFlag = true;
				$arrSubcontractorBidDocuments = SubcontractorBidDocument::loadSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentType($database, $subcontractor_bid_id, $loadSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentTypeOptions);
				$arrSubcontractorBidDocumentsSubcontractorBid = array();
				if (isset($arrSubcontractorBidDocuments['Subcontractor Bid'])) {
					$arrSubcontractorBidDocumentsSubcontractorBid = $arrSubcontractorBidDocuments['Subcontractor Bid'];
				}
				$arrSubcontractorBidDocumentsSignedScopeOfWork = array();
				if (isset($arrSubcontractorBidDocuments['Signed Scope Of Work'])) {
					$arrSubcontractorBidDocumentsSignedScopeOfWork = $arrSubcontractorBidDocuments['Signed Scope Of Work'];
				}
				$arrSubcontractorBidDocumentsUnsignedScopeOfWork = array();
				if (isset($arrSubcontractorBidDocuments['Unsigned Scope Of Work - Bidder Specific'])) {
					$arrSubcontractorBidDocumentsUnsignedScopeOfWork = $arrSubcontractorBidDocuments['Unsigned Scope Of Work - Bidder Specific'];
				}
				$arrSubcontractorBidDocumentsBidInvitation = array();
				if (isset($arrSubcontractorBidDocuments['Bid Invitation - Bidder Specific'])) {
					$arrSubcontractorBidDocumentsBidInvitation = $arrSubcontractorBidDocuments['Bid Invitation - Bidder Specific'];
				}


				// Bids
				$subcontractor_bid_document_type_id = Constants::SUBCONTRACTOR_BID_DOCUMENT_TYPE_ID;
				$subcontractorBidBootstrapDropdownContainerElementId = 'bidding-module-files-bootstrap-dropdown--subcontractor_bid_documents--subcontractor_bid_id-subcontractor_bid_document_type_id--'.$subcontractor_bid_id.'-'.$subcontractor_bid_document_type_id;
				$abbreviatedFilenameFlag = false;
				$includeParentSpanTags = true;
				$parentOpeningSpanTagElementId = $subcontractorBidBootstrapDropdownContainerElementId;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlListBiddingVersion($database, $subcontractor_bid_status_group_id, $subcontractor_bid_id, $subcontractor_bid_document_type_id, $abbreviatedFilenameFlag, $includeParentSpanTags, $parentOpeningSpanTagElementId);
				$subcontractorBidsCountBiddingVersion = $arrReturn['file_count'];
				$subcontractorBidUploadButtonHasRightSibling = $arrReturn['right_sibling'];
				$subcontractorBidsAsUrlListBiddingVersion = $arrReturn['html'];


				// Signed Scopes Of Work
				$subcontractor_bid_document_type_id = Constants::SIGNED_SCOPE_OF_WORK_DOCUMENT_TYPE_ID;
				$signedScopesOfWorkBootstrapDropdownContainerElementId = 'bidding-module-files-bootstrap-dropdown--subcontractor_bid_documents--subcontractor_bid_id-subcontractor_bid_document_type_id--'.$subcontractor_bid_id.'-'.$subcontractor_bid_document_type_id;
				$abbreviatedFilenameFlag = false;
				$includeParentSpanTags = true;
				$parentOpeningSpanTagElementId = $signedScopesOfWorkBootstrapDropdownContainerElementId;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlListBiddingVersion($database, $subcontractor_bid_status_group_id, $subcontractor_bid_id, $subcontractor_bid_document_type_id, $abbreviatedFilenameFlag, $includeParentSpanTags, $parentOpeningSpanTagElementId);
				$signedScopesOfWorkCountBiddingVersion = $arrReturn['file_count'];
				$signedScopeOfWorkUploadButtonHasRightSibling = $arrReturn['right_sibling'];
				$signedScopesOfWorkAsUrlListBiddingVersion = $arrReturn['html'];


				// Unsigned Scopes Of Work - Bidder Specific
				$subcontractor_bid_document_type_id = Constants::UNSIGNED_SCOPE_OF_WORK_DOCUMENT_TYPE_ID;
				$bidderSpecificUnsignedScopesOfWorkBootstrapDropdownContainerElementId = 'bidding-module-files-bootstrap-dropdown--subcontractor_bid_documents--subcontractor_bid_id-subcontractor_bid_document_type_id--'.$subcontractor_bid_id.'-'.$subcontractor_bid_document_type_id;
				$abbreviatedFilenameFlag = false;
				$includeParentSpanTags = true;
				$parentOpeningSpanTagElementId = $bidderSpecificUnsignedScopesOfWorkBootstrapDropdownContainerElementId;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlListBiddingVersion($database, $subcontractor_bid_status_group_id, $subcontractor_bid_id, $subcontractor_bid_document_type_id, $abbreviatedFilenameFlag, $includeParentSpanTags, $parentOpeningSpanTagElementId);
				$bidderSpecificUnsignedScopesOfWorkCountBiddingVersion = $arrReturn['file_count'];
				$unsignedScopeOfWorkUploadButtonHasRightSibling = $arrReturn['right_sibling'];
				$bidderSpecificUnsignedScopesOfWorkAsUrlListBiddingVersion = $arrReturn['html'];


				// Bid Invites - Bidder Specific
				$subcontractor_bid_document_type_id = Constants::BID_INVITATION_DOCUMENT_TYPE_ID;
				$bidderSpecificBidInvitationBootstrapDropdownContainerElementId = 'bidding-module-files-bootstrap-dropdown--subcontractor_bid_documents--subcontractor_bid_id-subcontractor_bid_document_type_id--'.$subcontractor_bid_id.'-'.$subcontractor_bid_document_type_id;
				$abbreviatedFilenameFlag = false;
				$includeParentSpanTags = true;
				$parentOpeningSpanTagElementId = $bidderSpecificBidInvitationBootstrapDropdownContainerElementId;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlListBiddingVersion($database, $subcontractor_bid_status_group_id, $subcontractor_bid_id, $subcontractor_bid_document_type_id, $abbreviatedFilenameFlag, $includeParentSpanTags, $parentOpeningSpanTagElementId);
				$bidderSpecificBidInvitationsCountBiddingVersion = $arrReturn['file_count'];
				$bidInvitationUploadButtonHasRightSibling = $arrReturn['right_sibling'];
				$bidderSpecificBidInvitationsAsUrlListBiddingVersion = $arrReturn['html'];


				// Submittals
				$subcontractor_bid_document_type_id = Constants::SUBMITTAL_DOCUMENT_TYPE_ID;
				$submittalBootstrapDropdownContainerElementId = 'bidding-module-files-bootstrap-dropdown--subcontractor_bid_documents--subcontractor_bid_id-subcontractor_bid_document_type_id--'.$subcontractor_bid_id.'-'.$subcontractor_bid_document_type_id;
				$abbreviatedFilenameFlag = false;
				$includeParentSpanTags = true;
				$parentOpeningSpanTagElementId = $submittalBootstrapDropdownContainerElementId;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlListBiddingVersion($database, $subcontractor_bid_status_group_id, $subcontractor_bid_id, $subcontractor_bid_document_type_id, $abbreviatedFilenameFlag, $includeParentSpanTags, $parentOpeningSpanTagElementId);
				$submittalsCountBiddingVersion = $arrReturn['file_count'];
				$submittalUploadButtonHasRightSibling = $arrReturn['right_sibling'];
				$submittalsAsUrlListBiddingVersion = $arrReturn['html'];



				/*
				//$arrReturn = renderSubcontractorBidDocumentFilesAsUrlListBiddingVersion($database, $subcontractor_bid_status_group_id, $subcontractor_bid_id, $subcontractor_bid_document_type_id, false, true);
				//$subcontractorBidHtml =	$arrReturn['html'];

				//$subcontractorBidHtml = FormComponents::outputCheckboxDropdownArea($database, $arrSubcontractorBidDocumentsSubcontractorBid);



				//$unsignedScopeOfWorkHtml = FormComponents::outputCheckboxDropdownArea($database, $arrSubcontractorBidDocumentsUnsignedScopeOfWork);
				// Load the unsigned scope documents for the current bid into a dropdown.
				// get common header for dropdown
				$unsignedScopeOfWorkUploadButtonHasRightSibling = true;
				$unsignedScopeOfWorkHtml = FormComponents::outputCheckboxDropdownArea($database, $arrSubcontractorBidDocumentsUnsignedScopeOfWork);

				if (count($arrSubcontractorBidDocumentsUnsignedScopeOfWork) == 0) {
					$unsignedScopeOfWorkUploadButtonHasRightSibling = false;
				}


				// Load the signed scope documents for the current bid into a dropdown.
				// get common header for dropdown

				//$signedScopeOfWorkUploadButtonHasRightSibling = true;
				//$subcontractorBidUploadButtonHasRightSibling = true;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlListBiddingVersion($database, $subcontractor_bid_status_group_id, $subcontractor_bid_id, $subcontractor_bid_document_type_id, false, true);
				$signedScopeOfWorkHtml =	$arrReturn['html'];

				//$signedScopeOfWorkHtml = FormComponents::outputCheckboxDropdownArea($database, $arrSubcontractorBidDocumentsSignedScopeOfWork);
				if (count($arrSubcontractorBidDocumentsSignedScopeOfWork) == 0) {
					//$signedScopeOfWorkUploadButtonHasRightSibling = false;
				}

				// Load bid invitation documents for the current bid into a dropdown.
				// get common header for dropdown
				$bidInvitationUploadButtonHasRightSibling = true;
				$bidInvitationHtml = FormComponents::outputCheckboxDropdownArea($database, $arrSubcontractorBidDocumentsBidInvitation);

				if (count($arrSubcontractorBidDocumentsBidInvitation) == 0) {
					$bidInvitationUploadButtonHasRightSibling = false;
				}
				*/

				// Don't use the html entity version here
//				$subcontractor_bid_document_virtual_file_path = "/Bidding & Purchasing/$formattedCostCode/[{$division_number}-{$cost_code}] Subcontractor Bid Documents/{$subcontractor_contact_company_name}/";
//				$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
//				$masterSubcontractorBidDocumentFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $subcontractor_bid_document_virtual_file_path);
//				/* @var $masterSubcontractorBidDocumentFileManagerFolder FileManagerFolder */
//				$subcontractor_bid_document_file_manager_folder_id = $masterSubcontractorBidDocumentFileManagerFolder->file_manager_folder_id;

				/*
				// Load the following types of subcontractor_bid_documents
				// subcontractor_bid_document_type_id=x values below
				// 1 : Subcontractor Bid
				// 2 : Signed Scope Of Work
				// 3 : Unsigned Scope Of Work - Bidder Specific
				// 4 : Bid Invitation - Bidder Specific
				// 5 : Submittal

				// Bids
				$subcontractor_bid_document_type_id = 1;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlList($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id, true);
				$subcontractorBidsCount = $arrReturn['file_count'];
				$subcontractorBidsAsUrlList = $arrReturn['html'];

				// Signed Scopes Of Work
				$subcontractor_bid_document_type_id = 2;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlList($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id, true);
				$signedScopesOfWorkCount = $arrReturn['file_count'];
				$signedScopesOfWorkAsUrlList = $arrReturn['html'];

				// Unsigned Scopes Of Work - Bidder Specific
				$subcontractor_bid_document_type_id = 3;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlList($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id, true);
				$bidderSpecificUnsignedScopesOfWorkCount = $arrReturn['file_count'];
				$bidderSpecificUnsignedScopesOfWorkAsUrlList = $arrReturn['html'];

				// Bid Invites - Bidder Specific
				$subcontractor_bid_document_type_id = 4;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlList($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id, true);
				$bidderSpecificBidInvitationsCount = $arrReturn['file_count'];
				$bidderSpecificBidInvitationsAsUrlList = $arrReturn['html'];

				// Submittals
				$subcontractor_bid_document_type_id = 5;
				$arrReturn = renderSubcontractorBidDocumentFilesAsUrlList($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id, true);
				$submittalsCount = $arrReturn['file_count'];
				$submittalsAsUrlList = $arrReturn['html'];


				// Subcontractor Bids - Bidder Specific (subcontractor_bid_document_type_id=1)
				$subcontractor_bid_document_type_id = 1;
				$input = new Input();
				$input->id = "subcontractorBidDocumentModalDialogFileUploader_subcontractorBidDocuments_BiddingVersion_1_{$subcontractor_bid_id}";
				$input->folder_id = $subcontractor_bid_document_file_manager_folder_id;
				$input->project_id = $project_id;
				$input->virtual_file_path = $subcontractor_bid_document_virtual_file_path;
				$input->virtual_file_name = "Bid - {$subcontractor_escaped_contact_company_name}.pdf";
				$input->append_date_to_filename = true;
				//$input->action = '/modules-file-manager-file-uploader-ajax.php';
				$input->action = "/modules-purchasing-file-uploader-ajax.php?subcontractor_bid_id=$subcontractor_bid_id&subcontractor_bid_document_type_id=$subcontractor_bid_document_type_id";
				//$input->method = 'uploadFiles';
				$input->method = 'subcontractorBidDocuments';
				$input->allowed_extensions = 'pdf';
				//$input->post_upload_js_callback = '';
				$input->custom_label = 'Drop/Click';
				$input->style = 'width: 200px;';
				$input->static_uploader_options = '';
				$subcontractorBidDocumentSubcontractorBidFileUploader = buildFileUploader($input);


				// Signed Scope of Work Documents - Bidder Specific (subcontractor_bid_document_type_id=2)
				$subcontractor_bid_document_type_id = 2;
				$input = new Input();
				$input->id = "subcontractorBidDocumentModalDialogFileUploader_subcontractorBidDocuments_2_{$subcontractor_bid_id}";
				$input->folder_id = $subcontractor_bid_document_file_manager_folder_id;
				$input->project_id = $project_id;
				$input->virtual_file_path = $subcontractor_bid_document_virtual_file_path;
				$input->virtual_file_name = "Signed Scope Of Work - {$subcontractor_escaped_contact_company_name}.pdf";
				$input->append_date_to_filename = true;
				//$input->action = '/modules-file-manager-file-uploader-ajax.php';
				$input->action = "/modules-purchasing-file-uploader-ajax.php?subcontractor_bid_id=$subcontractor_bid_id&subcontractor_bid_document_type_id=$subcontractor_bid_document_type_id";
				//$input->method = 'uploadFiles';
				$input->method = 'subcontractorBidDocuments';
				$input->allowed_extensions = 'pdf';
				//$input->post_upload_js_callback = '';
				$input->custom_label = 'Drop/Click';
				$input->style = 'width: 200px;';
				$input->static_uploader_options = '';
				$subcontractorBidDocumentSignedScopeOfWorkFileUploader = buildFileUploader($input);


				// Unsigned Scope Of Work - Bidder Specific (subcontractor_bid_document_type_id=3)
				$subcontractor_bid_document_type_id = 3;
				$input = new Input();
				$input->id = "subcontractorBidDocumentModalDialogFileUploader_subcontractorBidDocuments_3_{$subcontractor_bid_id}";
				$input->folder_id = $subcontractor_bid_document_file_manager_folder_id;
				$input->project_id = $project_id;
				$input->virtual_file_path = $subcontractor_bid_document_virtual_file_path;
				$input->virtual_file_name = "Unsigned Scope Of Work - Bidder Specific - {$subcontractor_escaped_contact_company_name}.pdf";
				$input->append_date_to_filename = true;
				$input->action = "/modules-purchasing-file-uploader-ajax.php?subcontractor_bid_id=$subcontractor_bid_id&subcontractor_bid_document_type_id=$subcontractor_bid_document_type_id";
				$input->method = 'subcontractorBidDocuments';
				$input->allowed_extensions = 'pdf';
				//$input->post_upload_js_callback = '';
				$input->custom_label = 'Drop/Click';
				$input->style = 'width: 200px;';
				$input->static_uploader_options = '';
				$subcontractorBidDocumentUnsignedScopeOfWorkFileUploader = buildFileUploader($input);


				// Bid Invitation - Bidder Specific (subcontractor_bid_document_type_id=4)
				$subcontractor_bid_document_type_id = 4;
				$input = new Input();
				$input->id = "subcontractorBidDocumentModalDialogFileUploader_subcontractorBidDocuments_4_{$subcontractor_bid_id}";
				$input->folder_id = $subcontractor_bid_document_file_manager_folder_id;
				$input->project_id = $project_id;
				$input->virtual_file_path = $subcontractor_bid_document_virtual_file_path;
				$input->virtual_file_name = "Bid Invitation - Bidder Specific - {$subcontractor_escaped_contact_company_name}.pdf";
				$input->append_date_to_filename = true;
				$input->action = "/modules-purchasing-file-uploader-ajax.php?subcontractor_bid_id=$subcontractor_bid_id&subcontractor_bid_document_type_id=$subcontractor_bid_document_type_id";
				$input->method = 'subcontractorBidDocuments';
				$input->allowed_extensions = 'pdf';
				//$input->post_upload_js_callback = '';
				$input->custom_label = 'Drop/Click';
				$input->style = 'width: 200px;';
				$input->static_uploader_options = '';
				$subcontractorBidDocumentBidInvitationFileUploader = buildFileUploader($input);


				// Submittals - Bidder Specific (subcontractor_bid_document_type_id=5)
				$subcontractor_bid_document_type_id = 5;
				$input = new Input();
				$input->id = "subcontractorBidDocumentModalDialogFileUploader_subcontractorBidDocuments_5_{$subcontractor_bid_id}";
				$input->folder_id = $subcontractor_bid_document_file_manager_folder_id;
				$input->project_id = $project_id;
				$input->virtual_file_path = $subcontractor_bid_document_virtual_file_path;
				$input->virtual_file_name = "Submittal - {$subcontractor_escaped_contact_company_name}.pdf";
				$input->append_date_to_filename = true;
				//$input->action = '/modules-file-manager-file-uploader-ajax.php';
				$input->action = "/modules-purchasing-file-uploader-ajax.php?subcontractor_bid_id=$subcontractor_bid_id&subcontractor_bid_document_type_id=$subcontractor_bid_document_type_id";
				//$input->method = 'uploadFiles';
				$input->method = 'subcontractorBidDocuments';
				$input->allowed_extensions = 'pdf';
				//$input->post_upload_js_callback = '';
				$input->custom_label = 'Drop/Click';
				$input->style = 'width: 200px;';
				$input->static_uploader_options = '';
				$subcontractorBidDocumentSubmittalFileUploader = buildFileUploader($input);
				*/




				// Configure the file uploaders for the bid documents of the current bid.
				// Subcontractor Bid
				$subcontractor_bid_document_type_id_subcontractor_bid = 1;
				// Signed Scope Of Work
				$subcontractor_bid_document_type_id_signed_scope_of_work = 2;
				// Unsigned Scope Of Work - Bidder Specific
				$subcontractor_bid_document_type_id_unsigned_scope_of_work = 3;
				// Bid Invitation - Bidder Specific
				$subcontractor_bid_document_type_id_bid_invitation = 4;
				// Submittal
				$subcontractor_bid_document_type_id_submittal = 5;


				// File Uploaders parent folder: subcontractor_bid_documents
				// Don't use the html entity version here
				$subcontractor_bid_document_virtual_file_path = "/Bidding & Purchasing/$formattedCostCode/[{$division_number}-{$cost_code}] Subcontractor Bid Documents/{$subcontractor_contact_company_name}/";
				$subcontractorBidDocumentsFileManagerFolder =
					FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $subcontractor_bid_document_virtual_file_path);
				$subcontractor_bid_documents_file_manager_folder_id = $subcontractorBidDocumentsFileManagerFolder->file_manager_folder_id;


				// Drag & Drop File Uploader: subcontractor_bid_documents
				// subcontractor_bid_document_type_id=1 : Subcontractor Bid
				// need to append $subcontractor_bid_status_group_id to elementId for ajax processing
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderElementId = 'subcontractor_bid_document_subcontractor_bid--'.$subcontractor_bid_id . '--' . $subcontractor_bid_status_group_id;
				$tmpJavaScriptFileUploaderOptionsObject = <<<END_JAVASCRIPT_OPTIONS_OBJECT
					{ subcontractor_bid_id: $subcontractor_bid_id, subcontractor_bid_document_type_id: $subcontractor_bid_document_type_id_subcontractor_bid, element: this._element, subcontractorBidDocumentDropdownContainerElement: $('#$subcontractorBidDocuments_SubcontractorBids_FileUploaderElementId').siblings('.dropdown') }
END_JAVASCRIPT_OPTIONS_OBJECT;
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderOptions = $tmpJavaScriptFileUploaderOptionsObject;
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput = new Input();
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->id = $subcontractorBidDocuments_SubcontractorBids_FileUploaderElementId;
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->class = 'notBoxViewUploader';
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->folder_id = $subcontractor_bid_documents_file_manager_folder_id;
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->project_id = $project_id;
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->virtual_file_path = $gc_budget_line_item_unsigned_scope_of_work_document_virtual_file_path;
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->virtual_file_name = "Bid - {$subcontractor_escaped_contact_company_name}.pdf";
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->append_date_to_filename = true;
				//$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->action = '/modules-file-manager-file-uploader-ajax.php';
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->action = "/modules-purchasing-file-uploader-ajax.php?subcontractor_bid_id=$subcontractor_bid_id&subcontractor_bid_document_type_id=$subcontractor_bid_document_type_id_subcontractor_bid";
				//$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->method = 'uploadFiles';
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->method = 'subcontractorBidDocuments';
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->allowed_extensions = 'pdf';
				// @todo Update the JS callback to ajax load the file list with checkboxes instead of passing in the variable: arrFileManagerFiles
				//$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->post_upload_js_callback = 'subcontractorBidDocumentUploaded(arrFileManagerFiles, '.$subcontractorBidDocuments_SubcontractorBids_FileUploaderOptions.')';
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->post_upload_js_callback = "loadSubcontractorBidDocumentFilesAsUrlListBiddingVersion('$subcontractor_bid_status_group_id', '$subcontractor_bid_id', '1', '$subcontractorBidBootstrapDropdownContainerElementId')";
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->custom_label = 'Drop/Click';
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->hidden = 'hidden';
				$subcontractorBidDocuments_SubcontractorBids_FileUploaderInput->static_uploader_options = array(
					'jsFunction' => 'subcontractorBidDocumentSelected',
					'options' => '{ subcontractor_bid_id: '.$subcontractor_bid_id.', subcontractor_bid_document_type_id: '.$subcontractor_bid_document_type_id_subcontractor_bid.' }',
					'uploadButtonHasRightSibling' => $subcontractorBidUploadButtonHasRightSibling,
					'noOverride' => 'noOverride'
				);
				$subcontractorBidDocuments_SubcontractorBids_FileUploader = buildFileUploader($subcontractorBidDocuments_SubcontractorBids_FileUploaderInput);


				// Drag & Drop File Uploader: subcontractor_bid_documents
				// subcontractor_bid_document_type_id=2 : Signed Scope Of Work
				// need to append $subcontractor_bid_status_group_id to elementId for ajax processing
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderElementId = 'subcontractor_bid_document_signed_scope_of_work--'.$subcontractor_bid_id . '--' . $subcontractor_bid_status_group_id;
				$tmpJavaScriptFileUploaderOptionsObject = <<<END_JAVASCRIPT_OPTIONS_OBJECT
					{ subcontractor_bid_id: $subcontractor_bid_id, subcontractor_bid_document_type_id: $subcontractor_bid_document_type_id_signed_scope_of_work, element: this._element, subcontractorBidDocumentDropdownContainerElement: $('#$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderElementId').siblings('.dropdown') }
END_JAVASCRIPT_OPTIONS_OBJECT;
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderOptions = $tmpJavaScriptFileUploaderOptionsObject;
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput = new Input();
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->id = $subcontractorBidDocuments_SignedScopesOfWork_FileUploaderElementId;
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->class = 'notBoxViewUploader';
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->folder_id = $subcontractor_bid_documents_file_manager_folder_id;
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->project_id = $project_id;
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->virtual_file_path = $gc_budget_line_item_unsigned_scope_of_work_document_virtual_file_path;
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->virtual_file_name = "Signed Scope Of Work - {$subcontractor_escaped_contact_company_name}.pdf";
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->append_date_to_filename = true;
				//$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->action = '/modules-file-manager-file-uploader-ajax.php';
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->action = "/modules-purchasing-file-uploader-ajax.php?subcontractor_bid_id=$subcontractor_bid_id&subcontractor_bid_document_type_id=$subcontractor_bid_document_type_id_signed_scope_of_work";
				//$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->method = 'uploadFiles';
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->method = 'subcontractorBidDocuments';
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->allowed_extensions = 'pdf';
				// @todo Update the JS callback to ajax load the file list with checkboxes instead of passing in the variable: arrFileManagerFiles
				//$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->post_upload_js_callback = 'subcontractorBidDocumentUploaded(arrFileManagerFiles, '.$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderOptions.')';
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->post_upload_js_callback = "loadSubcontractorBidDocumentFilesAsUrlListBiddingVersion('$subcontractor_bid_status_group_id', '$subcontractor_bid_id', '2', '$signedScopesOfWorkBootstrapDropdownContainerElementId')";
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->custom_label = 'Drop/Click';
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->hidden = 'hidden';
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput->static_uploader_options = array(
					'jsFunction' => 'subcontractorBidDocumentSelected',
					'options' => '{ subcontractor_bid_id: '.$subcontractor_bid_id.', subcontractor_bid_document_type_id: '.$subcontractor_bid_document_type_id_signed_scope_of_work.' }',
					'uploadButtonHasRightSibling' => $signedScopeOfWorkUploadButtonHasRightSibling,
					'noOverride' => 'noOverride'
				);
				$subcontractorBidDocuments_SignedScopesOfWork_FileUploader = buildFileUploader($subcontractorBidDocuments_SignedScopesOfWork_FileUploaderInput);


				// Drag & Drop File Uploader: subcontractor_bid_documents
				// subcontractor_bid_document_type_id=3 : Unsigned Scope Of Work - Bidder Specific
				// need to append $subcontractor_bid_status_group_id to elementId for ajax processing
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderElementId = 'subcontractor_bid_document_unsigned_scope_of_work--'.$subcontractor_bid_id . '--' . $subcontractor_bid_status_group_id;
				$tmpJavaScriptFileUploaderOptionsObject = <<<END_JAVASCRIPT_OPTIONS_OBJECT
					{ subcontractor_bid_id: $subcontractor_bid_id, subcontractor_bid_document_type_id: $subcontractor_bid_document_type_id_unsigned_scope_of_work, element: this._element, subcontractorBidDocumentDropdownContainerElement: $('#$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderElementId').siblings('.dropdown') }
END_JAVASCRIPT_OPTIONS_OBJECT;
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderOptions = $tmpJavaScriptFileUploaderOptionsObject;
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput = new Input();
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->id = $subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderElementId;
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->class = 'notBoxViewUploader';
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->folder_id = $subcontractor_bid_documents_file_manager_folder_id;
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->project_id = $project_id;
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->virtual_file_path = $gc_budget_line_item_unsigned_scope_of_work_document_virtual_file_path;
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->virtual_file_name = "Unsigned Scope Of Work - Bidder Specific - {$subcontractor_escaped_contact_company_name}.pdf";
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->append_date_to_filename = true;
				//$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->action = '/modules-file-manager-file-uploader-ajax.php';
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->action = "/modules-purchasing-file-uploader-ajax.php?subcontractor_bid_id=$subcontractor_bid_id&subcontractor_bid_document_type_id=$subcontractor_bid_document_type_id_unsigned_scope_of_work";
				//$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->method = 'uploadFiles';
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->method = 'subcontractorBidDocuments';
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->allowed_extensions = 'pdf';
				// @todo Update the JS callback to ajax load the file list with checkboxes instead of passing in the variable: arrFileManagerFiles
				//$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->post_upload_js_callback = 'subcontractorBidDocumentUploaded(arrFileManagerFiles, '.$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderOptions.')';
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->post_upload_js_callback = "loadSubcontractorBidDocumentFilesAsUrlListBiddingVersion('$subcontractor_bid_status_group_id', '$subcontractor_bid_id', '3', '$bidderSpecificUnsignedScopesOfWorkBootstrapDropdownContainerElementId')";
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->custom_label = 'Drop/Click';
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->hidden = 'hidden';
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput->static_uploader_options = array(
					'jsFunction' => 'subcontractorBidDocumentSelected',
					'options' => '{ subcontractor_bid_id: '.$subcontractor_bid_id.', subcontractor_bid_document_type_id: '.$subcontractor_bid_document_type_id_unsigned_scope_of_work.' }',
					'uploadButtonHasRightSibling' => $unsignedScopeOfWorkUploadButtonHasRightSibling,
					'noOverride' => 'noOverride'
				);
				$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploader = buildFileUploader($subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderInput);


				// Drag & Drop File Uploader: subcontractor_bid_documents
				// subcontractor_bid_document_type_id=4 : Bid Invitation - Bidder Specific
				// need to append $subcontractor_bid_status_group_id to elementId for ajax processing
				$subcontractorBidDocuments_BidInvitations_FileUploaderElementId = 'subcontractor_bid_document_bid_invitation--'.$subcontractor_bid_id . '--' . $subcontractor_bid_status_group_id;
				$tmpJavaScriptFileUploaderOptionsObject = <<<END_JAVASCRIPT_OPTIONS_OBJECT
					{ subcontractor_bid_id: $subcontractor_bid_id, subcontractor_bid_document_type_id: $subcontractor_bid_document_type_id_bid_invitation, element: this._element, subcontractorBidDocumentDropdownContainerElement: $('#$subcontractorBidDocuments_BidInvitations_FileUploaderElementId').siblings('.dropdown') }
END_JAVASCRIPT_OPTIONS_OBJECT;
				$subcontractorBidDocuments_BidInvitations_FileUploaderOptions = $tmpJavaScriptFileUploaderOptionsObject;
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput = new Input();
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->id = $subcontractorBidDocuments_BidInvitations_FileUploaderElementId;
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->class = 'notBoxViewUploader';
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->folder_id = $subcontractor_bid_documents_file_manager_folder_id;
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->project_id = $project_id;
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->virtual_file_path = $gc_budget_line_item_unsigned_scope_of_work_document_virtual_file_path;
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->virtual_file_name = "Bid Invitation - Bidder Specific - {$subcontractor_escaped_contact_company_name}.pdf";
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->append_date_to_filename = true;
				//$subcontractorBidDocuments_BidInvitations_FileUploaderInput->action = '/modules-file-manager-file-uploader-ajax.php';
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->action = "/modules-purchasing-file-uploader-ajax.php?subcontractor_bid_id=$subcontractor_bid_id&subcontractor_bid_document_type_id=$subcontractor_bid_document_type_id_bid_invitation";
				//$subcontractorBidDocuments_BidInvitations_FileUploaderInput->method = 'uploadFiles';
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->method = 'subcontractorBidDocuments';
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->allowed_extensions = 'pdf';
				// @todo Update the JS callback to ajax load the file list with checkboxes instead of passing in the variable: arrFileManagerFiles
				//$subcontractorBidDocuments_BidInvitations_FileUploaderInput->post_upload_js_callback = 'subcontractorBidDocumentUploaded(arrFileManagerFiles, '.$subcontractorBidDocuments_BidInvitations_FileUploaderOptions.')';
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->post_upload_js_callback = "loadSubcontractorBidDocumentFilesAsUrlListBiddingVersion('$subcontractor_bid_status_group_id', '$subcontractor_bid_id', '4', '$bidderSpecificBidInvitationBootstrapDropdownContainerElementId')";
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->custom_label = 'Drop/Click';
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->hidden = 'hidden';
				$subcontractorBidDocuments_BidInvitations_FileUploaderInput->static_uploader_options = array(
					'jsFunction' => 'subcontractorBidDocumentSelected',
					'options' => '{ subcontractor_bid_id: '.$subcontractor_bid_id.', subcontractor_bid_document_type_id: '.$subcontractor_bid_document_type_id_bid_invitation.' }',
					'uploadButtonHasRightSibling' => $bidInvitationUploadButtonHasRightSibling,
					'noOverride' => 'noOverride'
				);
				$subcontractorBidDocuments_BidInvitations_FileUploader = buildFileUploader($subcontractorBidDocuments_BidInvitations_FileUploaderInput);



				$ddlSubcontractorBidStatusElementId = 'ddl--manage-subcontractor_bid-record--subcontractor_bids--subcontractor_bid_status_id--' . $subcontractor_bid_id;
				$js = 'onchange="updateSubcontractorBidAndReloadBiddingContentViaPromiseChain(this);"';
				$prependedOption = '';
				$ddlSubcontractorBidStatus = PageComponents::dropDownListFromObjects($ddlSubcontractorBidStatusElementId, $arrSubcontractorBidStatuses, 'subcontractor_bid_status_id', null, 'subcontractor_bid_status', null, $subcontractorBid->subcontractor_bid_status_id, '', $js, $prependedOption);

				// Inner accordion content.
				$htmlContent .= <<<END_HTML_CONTENT

							<tr>
								<td class="checkbox">
									<input type="checkbox"
										class="bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id bidding-module-bidders-checkbox-subcontractor_bid_status_group_id-$subcontractor_bid_status_group_id--subcontractor_bids--gc_budget_line_item_id--$gc_budget_line_item_id bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--$subcontractor_bid_status_group_id"
										onclick="handle_BiddingModuleBidder_SubcontractorBid_Checkbox_ClickEvent(this, '$subcontractor_bid_status_group_id', '$gc_budget_line_item_id');"
										value="$subcontractor_bid_id">
									$subcontractorBidderDisplayName
								</td>
								<!--td>$subcontractorBidderDisplayName</td-->
								<td><!--span>12/12/2012</span--></td>
								<td><!--span>Plans #1</span--></td>
								<td>
									<div class="fineUploader subcontractorBidDocumentSubcontractorBidUploader" data-subcontractor_bid_id="$subcontractor_bid_id" data-subcontractor_bid_document_type_id="$subcontractor_bid_document_type_id_subcontractor_bid"></div>
									$subcontractorBidDocuments_SubcontractorBids_FileUploader
									$subcontractorBidsAsUrlListBiddingVersion
								</td>
								<td>
									<div class="fineUploader subcontractorBidDocumentSignedScopeOfWorkUploader" data-subcontractor_bid_id="$subcontractor_bid_id" data-subcontractor_bid_document_type_id="$subcontractor_bid_document_type_id_signed_scope_of_work"></div>
									$subcontractorBidDocuments_SignedScopesOfWork_FileUploader
									$signedScopesOfWorkAsUrlListBiddingVersion
								</td>
								<td class="biddingExpertMode">
									<div class="fineUploader subcontractorBidDocumentBidInvitationUploader" data-subcontractor_bid_id="$subcontractor_bid_id" data-subcontractor_bid_document_type_id="$subcontractor_bid_document_type_id_bid_invitation"></div>
									$subcontractorBidDocuments_BidInvitations_FileUploader
									$bidderSpecificBidInvitationsAsUrlListBiddingVersion
								</td>
								<td class="biddingExpertMode">
									<div class="fineUploader subcontractorBidDocumentUnsignedScopeOfWorkUploader" data-subcontractor_bid_id="$subcontractor_bid_id" data-subcontractor_bid_document_type_id="$subcontractor_bid_document_type_id_unsigned_scope_of_work"></div>
									$subcontractorBidDocuments_UnsignedScopesOfWork_FileUploader
									$bidderSpecificUnsignedScopesOfWorkAsUrlListBiddingVersion
								</td>
								<td class="biddingExpertMode">$ddlSubcontractorBidStatus</td>
							</tr>
END_HTML_CONTENT;

			}

			$htmlContent .= <<<END_HTML_CONTENT

						</tbody>
					</table>
				</div>
			</li>
END_HTML_CONTENT;

		}

		$htmlContent .= <<<END_HTML_CONTENT

		</ul>
END_HTML_CONTENT;

	}

	$htmlContent .= <<<END_HTML_CONTENT

	<input id="gc_budget_line_item_bid_invitation_file_manager_folder_id" type="hidden" value="$gc_budget_line_item_bid_invitation_file_manager_folder_id">
	<input id="gc_budget_line_item_unsigned_scope_of_work_document_file_manager_folder_id" type="hidden" value="$gc_budget_line_item_unsigned_scope_of_work_document_file_manager_folder_id">
	<input id="subcontractor_bid_documents_file_manager_folder_id" type="hidden" value="$subcontractor_bid_documents_file_manager_folder_id">
END_HTML_CONTENT;

	// add js to set advanced bidding mode
	if ($toggleAdvancedMode === true) {

		$htmlContent .= <<<END_HTML_CONTENT

		<script>
			$(".biddingExpertMode ").css('visibility', 'visible');
		</script>
END_HTML_CONTENT;

	}

	return $htmlContent;

}

function renderEmailModalDialogSendInvitationsToBid($database, $user_company_id, $project_id, $arrSubcontractorBidData)
{
	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$debugMode = $session->getDebugMode();

	// Load all subcontractor_bid_status_groups
	$arrSubcontractorBidStatusGroups = SubcontractorBidStatusGroupToSubcontractorBidStatus::loadAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId($database);

	// this array will be used for bid documents for each bidder group by unique contact
	$arrUniqueBiddersByContactHtmlByGroupDocuments = array();

	// define 4 types of subcontractor bid documents for email
	$arrIncludeEmailSubcontractorBidDocumentsType = array(
		Constants::SUBCONTRACTOR_BID_DOCUMENT_SUBCONTRACTOR_BID,
		Constants::SUBCONTRACTOR_BID_DOCUMENT_SIGNED_SCOPE_OF_WORK,
		Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION,
		Constants::SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK
	);

	// bidPerference byBidContact or by cost code
	// only support costcode
	// $bidPerference = $arrSubcontractorBidData['bidPerference'];
	$bidPerference = Constants::BID_GROUP_BY_COSTCODE ;

	// initialize object to manage bid documents organization
	$objBidDocumentHelper = new ModulesBiddingDocumentHelper($database, $project_id, $arrSubcontractorBidData);

	////////////////// load SubcontractorBids ////////////////

	// handle subcontractor_bids
	$arrSubcontractorBids = array();
	if (isset($arrSubcontractorBidData['csvSubcontractorBidIds']) && !empty($arrSubcontractorBidData['csvSubcontractorBidIds'])) {
		$objBidDocumentHelper->loadSubcontractorBids($arrSubcontractorBidData['csvSubcontractorBidIds']);
		$objBidDocumentHelper->formatSubcontractorBidsContact();
	}
	$arrSubcontractorBids = $objBidDocumentHelper->getArrSubcontractorBids();

	// Iterate over bidders (subcontractor_bids)
	$to = '';

	$arrTo = $objBidDocumentHelper->getArrSubcontractorsEmailSpan();

	$arrUniqueBidders = $objBidDocumentHelper->getArrUniqueBidders();

	////////////////// process SubcontractorBids ////////////////

	// HC: use $arrCostCodeBidderDocumentRelationship to categorize costcode for Bidders for display
	// E.g. cost code 001 bidders 1, 2, 3
	$arrCostCodeBidderDocumentRelationship = $objBidDocumentHelper->getArrCostCodeBidderDocumentRelationship();

	////////////////// process subcontractor bid documents ////////////////

	// subcontractor_bid_documents
	$arrSubcontractorBidDocuments = array();
	if (isset($arrSubcontractorBidData['csvSubcontractorBidDocumentIds']) && !empty($arrSubcontractorBidData['csvSubcontractorBidDocumentIds'])) {
		$objBidDocumentHelper->processCSVSubcontractBidDocument($arrSubcontractorBidData['csvSubcontractorBidDocumentIds']);
		$arrSubcontractorBidDocuments = $objBidDocumentHelper->getarrSubcontractorBidDocuments();
	}

	////////////////// load and parse 1. default project_bid_invitations ////////////////
	////////////////// load and parse 2. gc_budget_line_item_bid_invitations ////////////
	////////////////// load and parse 3. gc_budget_line_item_unsigned_scope_of_work_documents ////////////////

	// $objBidDocumentHelper = new ModulesBiddingDocumentHelper($database);
	// set relation of document with bidders
	$objBidDocumentHelper->setCostCodeBidderDocumentRelationship($arrCostCodeBidderDocumentRelationship);

	// 1. load and format default project_bid_invitations

	if (isset($arrSubcontractorBidData['csvProjectBidInvitationIds']) && !empty($arrSubcontractorBidData['csvProjectBidInvitationIds'])) {

		$objBidDocumentHelper->loadProjectBidInvitationDocuments($arrSubcontractorBidData['csvProjectBidInvitationIds']);
	} else {
		$objBidDocumentHelper->loadDefaultProjectBidInvitationDocument();
	}

	// 2. load and format gc_budget_line_item_bid_invitations

	if (isset($arrSubcontractorBidData['csvGcBudgetLineItemBidInvitationIds']) && !empty($arrSubcontractorBidData['csvGcBudgetLineItemBidInvitationIds'])) {
		$objBidDocumentHelper->loadGcBudgetLineItemBidInvitations($arrSubcontractorBidData['csvGcBudgetLineItemBidInvitationIds']);
	}

	// 3. load and format gc_budget_line_item_unsigned_scope_of_work_documents

	if (isset($arrSubcontractorBidData['csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds']) && !empty($arrSubcontractorBidData['csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds'])) {
		$objBidDocumentHelper->loadGcBudgetLineItemUnsignedScopeOfWorkDocuments($arrSubcontractorBidData['csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds']);
	}

	////////////////// get variable and html code from array  ////////////////
	///////////////// 1. default project_bid_invitations ////////////////
	///////////////// 2. gc_budget_line_item_bid_invitations ////////////
	///////////////// 3. gc_budget_line_item_unsigned_scope_of_work_documents ////////////////

	// Iterate over files
	// 1. project_bid_invitations
	$arrProjectBidInvitationsDocumentEntry = array();
	$projectBidInvitationFilesHtml = '';

	$projectBidInvitationFilesHtml = $objBidDocumentHelper->getProjectBidInvitationFilesHtml();
	$arrProjectBidInvitationsDocumentEntry = $objBidDocumentHelper->getArrProjectBidInvitationsDocumentEntry();

	// $arrHtmlGcBudgetLineItemBidInvitations will be used for group by subcontractor
	// $arrBidderGcBudgetLineItemSelectedBitInvitation will be used for group by subcontractor
	$arrHtmlGcBudgetLineItemBidInvitations = array();
	$arrBidderGcBudgetLineItemSelectedBitInvitation = array();


	// 2. this array contains id of subcontractors has GcBudgetLineItemBidInvitations
	$arrBidderGcBudgetLineItemSelectedBitInvitation = $objBidDocumentHelper->getArrBidderGcBudgetLineItemSelectedBitInvitation();

	// array of html code for subcontractor who has GcBudgetLineItemBidInvitations
	// array key is sub_contractor_id
	$arrHtmlGcBudgetLineItemBidInvitations = $objBidDocumentHelper->getArrHtmlGcBudgetLineItemBidInvitations();

	// genersl header with documents for GcBudgetLineItemBidInvitations
	$gcBudgetLineItemBidInvitationsFilesHtml = '';
	$gcBudgetLineItemBidInvitationsFilesHtml = $objBidDocumentHelper->getGcBudgetLineItemBidInvitationsFilesHtml();


	// 3. gc_budget_line_item_unsigned_scope_of_work_documents

	// $arrCostCodeBidderDocumentRelationship
	// to capture unsigned doc
	$arrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments = array();

	$arrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments = $objBidDocumentHelper->getArrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments();

	$arrHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentByid = $objBidDocumentHelper->getArrHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentById();

	$gcBudgetLineItemUnsignedScopeOfWorkDocumentFilesHtml = $objBidDocumentHelper->getGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesHtml();


	////////////////// get variable and html code from array ////////////////
	//////////////// Subcontractor Bid Documents ////////////////

	$arrHtmlSubcontractorBidDocuments = array();
	$tmpHtmlSubcontractorBidDocument = "";
	if ($arrSubcontractorBidDocuments > 0) {

		// $arrTDHtmlGcBudgetLineItemBidInvitations = array();
		foreach ($arrSubcontractorBidDocuments as $subcontractor_bid_document_id => $subcontractor_bid_document) {
			// need cost code id and gc Budget line item id to assign and find association with sub_contractor_id
			$subcontractorBidDocumentType = $subcontractor_bid_document->getSubcontractorBidDocumentType();
			$subcontractor_bid_id = $subcontractor_bid_document->subcontractor_bid_id;
			$subcontractor_bid_document_type = $subcontractorBidDocumentType->subcontractor_bid_document_type;

			if (in_array($subcontractor_bid_document_type,$arrIncludeEmailSubcontractorBidDocumentsType)) {
				$tmpHtmlSubcontractorBidDocument = generateSubcontractorBidDocumentEntry($subcontractor_bid_document);
				$arrHtmlSubcontractorBidDocuments[$subcontractor_bid_id][$subcontractor_bid_document_type][] = $tmpHtmlSubcontractorBidDocument;
			}
		}
		//echo "<pre>";
		//print_r($arrHtmlSubcontractorBidDocuments); exit;
	}

	$subcontractorBidDiv = <<<END_SUBCONTRACTOR_BID_DIV

		<div align="right">
			<input style="margin: 3px 0pt 0pt; padding: 1px;" type="button" onclick="showHideDomElement('record_list_container--bidding-module-email-modal-dialog--subcontractor_bids--ad-hoc-file-attachments');" value="Toggle View Bidders">
		</div>
		<div id="record_list_container--bidding-module-email-modal-dialog--subcontractor_bids--ad-hoc-file-attachments" class="displayNone" style="width: 100%;">

END_SUBCONTRACTOR_BID_DIV;

	////////////////// merge all the group documents under different document groups ////////////////
	////////////////// 1. ProjectBidInvitations //////////////////
	////////////////// 2. gc_budget_line_item_bid_invitation //////////////////
	////////////////// 3. gc_budget_line_item_unsigned_scope_of_work_documents //////////////////

    ////////////////// generate html for all document groups ////////////////
	////////////////// 1. ProjectBidInvitations //////////////////
	////////////////// 2. gc_budget_line_item_bid_invitation //////////////////
	////////////////// 3. gc_budget_line_item_unsigned_scope_of_work_documents //////////////////

	// display by contact
	// this won't work anymore due to document display requirement

	if ($bidPerference == Constants::BID_GROUP_BY_CONTACT) {
		$objBidDocumentHelper->mergeBidderDocumentsByContact($arrHtmlSubcontractorBidDocuments);

		$arrUniqueBiddersByContactHtml = $objBidDocumentHelper->outputEmailDocumentBlocksByContact();
		$subcontractorBidDiv .= join("\n", $arrUniqueBiddersByContactHtml);

	} else {
		// display by cost code
		$objBidDocumentHelper->mergeBidderDocumentsByCostcode($arrHtmlSubcontractorBidDocuments);
		$arrBiddersByContactHtml = $objBidDocumentHelper->outputEmailDocumentBlocksByCostcode();
		$subcontractorBidDiv .= join("\n", $arrBiddersByContactHtml);

	}


	$subcontractorBidDiv .= '</div>' . "\n";

	// <div><a href="mailto:john@gmail.com"><img src="images/icons/modules-bidding-email-modal-dialogs/icon_x_circle.png">  john@gmail.com</a></div>
	//$to = join(', ', $arrTo);
	//$to = Data::entity_encode($to);

	$subcontractorBidRecipients = join(', ', $arrTo);

	$project = Project::findById($database, $project_id);
	/* @var $project Project */

	$project->htmlEntityEscapeProperties();
	$escaped_project_name = $project->escaped_project_name;

	// Email Subject
	if (isset($arrSubcontractorBidData['defaultEmailMessageSubject'])) {
		$defaultEmailMessageSubject = trim($arrSubcontractorBidData['defaultEmailMessageSubject']);
		$defaultEmailMessageSubject = str_replace('[PROJECT_NAME]', $escaped_project_name, $defaultEmailMessageSubject);
		$defaultEmailMessageSubject = Data::entity_encode($defaultEmailMessageSubject);
	} else {
		$defaultEmailMessageSubject = "Bid Invitation for $escaped_project_name";
	}

	// Email Message
	if (isset($arrSubcontractorBidData['defaultEmailMessageBody'])) {
		$defaultEmailMessageBody = trim($arrSubcontractorBidData['defaultEmailMessageBody']);
		$defaultEmailMessageBody = str_replace('[PROJECT_NAME]', $escaped_project_name, $defaultEmailMessageBody);
		$defaultEmailMessageBody = Data::entity_encode($defaultEmailMessageBody);
	} else {
		$defaultEmailMessageBody = "Please Bid $escaped_project_name";
	}

	//$html = require('include/templates/modules-bidding-email-modal-dialog-send-bid-invitations.php');
	$html = require('include/templates/subcontractor-bidding-email-modal-dialog.php');

	return $html;
}

function submitEmailModalDialog_PerformAction($database, $user_company_id, $project_id, $arrSubcontractorBidData)
{

	// subcontractor_bids
	$arrSubcontractorBids = array();
	if (isset($arrSubcontractorBidData['csvSubcontractorBidIds']) && !empty($arrSubcontractorBidData['csvSubcontractorBidIds'])) {
		$csvSubcontractorBidIds = $arrSubcontractorBidData['csvSubcontractorBidIds'];
		$arrSubcontractorBidIds = explode(',', $csvSubcontractorBidIds);
	}
	if (isset($arrSubcontractorBidIds) && !empty($arrSubcontractorBidIds)) {
		$loadSubcontractorBidsByArrSubcontractorBidIdsInput = new Input();
		$loadSubcontractorBidsByArrSubcontractorBidIdsInput->arrOrderByAttributes = array(
			'sort_order' => 'DESC'
		);
		$arrSubcontractorBids =
			SubcontractorBid::loadSubcontractorBidsByArrSubcontractorBidIds($database, $arrSubcontractorBidIds, $loadSubcontractorBidsByArrSubcontractorBidIdsInput);
		$subcontractorBidsCount = count($arrSubcontractorBids);
	} else {
		$subcontractorBidsCount = 0;
	}

	// subcontractor_bid_documents
	$arrSubcontractorBidDocuments = array();
	if (isset($arrSubcontractorBidData['csvSubcontractorBidDocumentIds']) && !empty($arrSubcontractorBidData['csvSubcontractorBidDocumentIds'])) {
		$csvSubcontractorBidDocumentIds = $arrSubcontractorBidData['csvSubcontractorBidDocumentIds'];
		$arrSubcontractorBidDocumentIds = explode(',', $csvSubcontractorBidDocumentIds);
	}
	if (isset($arrSubcontractorBidDocumentIds) && !empty($arrSubcontractorBidDocumentIds)) {
		$loadSubcontractorBidDocumentsByArrSubcontractorBidDocumentIdsInput = new Input();
		$loadSubcontractorBidDocumentsByArrSubcontractorBidDocumentIdsInput->arrOrderByAttributes = array(
			'subcontractor_bid_document_sequence_number' => 'DESC'
		);
		$arrSubcontractorBidDocuments =
			SubcontractorBidDocument::loadSubcontractorBidDocumentsByArrSubcontractorBidDocumentIds($database, $arrSubcontractorBidDocumentIds, $loadSubcontractorBidDocumentsByArrSubcontractorBidDocumentIdsInput);
		$subcontractorBidDocumentsCount = count($arrSubcontractorBidDocuments);
	} else {
		$subcontractorBidDocumentsCount = 0;
	}

	// project_bid_invitations
	$arrProjectBidInvitations = array();
	if (isset($arrSubcontractorBidData['csvProjectBidInvitationIds']) && !empty($arrSubcontractorBidData['csvProjectBidInvitationIds'])) {
		$csvProjectBidInvitationIds = $arrSubcontractorBidData['csvProjectBidInvitationIds'];
		$arrProjectBidInvitationIds = explode(',', $csvProjectBidInvitationIds);
	}
	if (isset($arrProjectBidInvitationIds) && !empty($arrProjectBidInvitationIds)) {
		$loadProjectBidInvitationsByArrProjectBidInvitationIdsInput = new Input();
		$loadProjectBidInvitationsByArrProjectBidInvitationIdsInput->arrOrderByAttributes = array(
			'project_bid_invitation_sequence_number' => 'DESC'
		);
		$arrProjectBidInvitations =
			ProjectBidInvitation::loadProjectBidInvitationsByArrProjectBidInvitationIds($database, $arrProjectBidInvitationIds, $loadProjectBidInvitationsByArrProjectBidInvitationIdsInput);
		$projectBidInvitationsCount = count($arrProjectBidInvitations);
	} else {
		$projectBidInvitationsCount = 0;
	}

	// gc_budget_line_item_bid_invitations
	$arrGcBudgetLineItemBidInvitations = array();
	if (isset($arrSubcontractorBidData['csvGcBudgetLineItemBidInvitationIds']) && !empty($arrSubcontractorBidData['csvGcBudgetLineItemBidInvitationIds'])) {
		$csvGcBudgetLineItemBidInvitationIds = $arrSubcontractorBidData['csvGcBudgetLineItemBidInvitationIds'];
		$arrGcBudgetLineItemBidInvitationIds = explode(',', $csvGcBudgetLineItemBidInvitationIds);
	}
	if (isset($arrGcBudgetLineItemBidInvitationIds) && !empty($arrGcBudgetLineItemBidInvitationIds)) {
		$loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIdsInput = new Input();
		$loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIdsInput->arrOrderByAttributes = array(
			'gc_budget_line_item_bid_invitation_sequence_number' => 'DESC'
		);
		$arrGcBudgetLineItemBidInvitations =
			GcBudgetLineItemBidInvitation::loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIds($database, $arrGcBudgetLineItemBidInvitationIds, $loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIdsInput);
		$gcBudgetLineItemBidInvitationsCount = count($arrGcBudgetLineItemBidInvitations);
	} else {
		$gcBudgetLineItemBidInvitationsCount = 0;
	}

	// gc_budget_line_item_unsigned_scope_of_work_documents
	$arrGcBudgetLineItemUnsignedScopeOfWorkDocuments = array();
	if (isset($arrSubcontractorBidData['csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds']) && !empty($arrSubcontractorBidData['csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds'])) {
		$csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = $arrSubcontractorBidData['csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds'];
		$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = explode(',', $csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds);
	}
	if (isset($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds) && !empty($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds)) {
		$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByArrGcBudgetLineItemUnsignedScopeOfWorkDocumentIdsInput = new Input();
		$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByArrGcBudgetLineItemUnsignedScopeOfWorkDocumentIdsInput->arrOrderByAttributes = array(
			'unsigned_scope_of_work_document_sequence_number' => 'DESC'
		);
		$arrGcBudgetLineItemUnsignedScopeOfWorkDocuments =
			GcBudgetLineItemUnsignedScopeOfWorkDocument::loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByArrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds($database, $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds, $loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByArrGcBudgetLineItemUnsignedScopeOfWorkDocumentIdsInput);
		$gcBudgetLineItemUnsignedScopeOfWorkDocumentsCount = count($arrGcBudgetLineItemUnsignedScopeOfWorkDocuments);
	} else {
		$gcBudgetLineItemUnsignedScopeOfWorkDocumentsCount = 0;
	}


	// Iterate over files
	// project_bid_invitations
	$trHtml = '';
	foreach ($arrProjectBidInvitations as $project_bid_invitation_id => $projectBidInvitation) {
		/* @var $projectBidInvitation ProjectBidInvitation */

		$project = $projectBidInvitation->getProject();
		/* @var $project Project */

		$projectBidInvitationFileManagerFile = $projectBidInvitation->getProjectBidInvitationFileManagerFile();
		/* @var $projectBidInvitationFileManagerFile FileManagerFile */

		$projectBidInvitationFileManagerFile->htmlEntityEscapeProperties();

		$file_manager_file_id = $projectBidInvitationFileManagerFile->file_manager_file_id;
		$virtual_file_name = $projectBidInvitationFileManagerFile->virtual_file_name;
		$escaped_virtual_file_name = $projectBidInvitationFileManagerFile->escaped_virtual_file_name;
		$cdnFileUrl = $projectBidInvitationFileManagerFile->generateUrl();

		$trHtml .= <<<END_TR_HTML

						<tr id="bidding-module-email-modal-dialog-files--project_bid_invitations--project_bid_invitation_id--$project_bid_invitation_id" class="bidding-module-email-modal-dialog-files--project_bid_invitations--project_bid_invitation_id">
							<td>
								<a class="textAlignLeft verticalAlignMiddle bs-tooltip" style="margin: 0px 0 0px 0px;" href="$cdnFileUrl" target="_blank" title="This file will be an attachment."><img src="/images/icons/icon-file-pdf-gray.gif" width="18" height="18" alt=""> $escaped_virtual_file_name</a>
								<img class="fakeHref" src="/images/icons/icon-delete-x-circle.png" width="12" height="12" alt="" title="Remove this file attachment from the list." onclick="removeDomElement('bidding-module-email-modal-dialog-files--project_bid_invitations--project_bid_invitation_id--$project_bid_invitation_id');">
							</td>
						</tr>

END_TR_HTML;
	}

	if ($projectBidInvitationsCount > 0) {
		$projectBidInvitationFilesHtml = <<<END_FILES_HTML
					<br>
					<b>Default Project Bid Invitation Files</b>
					<table class="" border="0" cellpadding="0" cellspacing="0" width="100%">
$trHtml
					</table>

END_FILES_HTML;
	} else {
		$projectBidInvitationFilesHtml = '';
	}

	// gc_budget_line_item_unsigned_scope_of_work_documents
	$trHtml = '';
	foreach ($arrGcBudgetLineItemUnsignedScopeOfWorkDocuments as $gc_budget_line_item_unsigned_scope_of_work_document_id => $gcBudgetLineItemUnsignedScopeOfWorkDocument) {
		/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */

		$gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getUnsignedScopeOfWorkDocumentFileManagerFile();
		/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile FileManagerFile */

		$gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->htmlEntityEscapeProperties();

		$file_manager_file_id = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->file_manager_file_id;
		$virtual_file_name = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->virtual_file_name;
		$escaped_virtual_file_name = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->escaped_virtual_file_name;
		$cdnFileUrl = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->generateUrl();

		$trHtml .= <<<END_TR_HTML

						<tr id="bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id--$gc_budget_line_item_unsigned_scope_of_work_document_id" class="bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id">
							<td>
								<a class="textAlignLeft verticalAlignMiddle bs-tooltip" style="margin: 0px 0 0px 0px;" href="$cdnFileUrl" target="_blank" title="This file will be an attachment."><img src="/images/icons/icon-file-pdf-gray.gif" width="18" height="18" alt=""> $escaped_virtual_file_name</a>
								<img class="fakeHref" src="/images/icons/icon-delete-x-circle.png" width="12" height="12" alt="" title="Remove this file attachment from the list." onclick="removeDomElement('bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id--$gc_budget_line_item_unsigned_scope_of_work_document_id');">
							</td>
						</tr>

END_TR_HTML;
	}

	if ($gcBudgetLineItemUnsignedScopeOfWorkDocumentsCount > 0) {
		$gcBudgetLineItemUnsignedScopeOfWorkDocumentFilesHtml = <<<END_FILES_HTML
					<br>
					<b>Default Unsigned Scope Of Work Files</b>
					<table class="" border="0" cellpadding="0" cellspacing="0" width="100%">
$trHtml
					</table>

END_FILES_HTML;
	} else {
		$gcBudgetLineItemUnsignedScopeOfWorkDocumentFilesHtml = '';
	}


	// Iterate over bidders (subcontractor_bids)
	$to = '';
	$arrTo = array();
	$arrUniqueBidders = array();
	foreach ($arrSubcontractorBids as $subcontractor_bid_id => $subcontractorBid) {
		/* @var $subcontractorBid SubcontractorBid */

		$subcontractorContact = $subcontractorBid->getSubcontractorContact();
		/* @var $subcontractorContact Contact */

		if ($subcontractorContact) {

			if (!isset($arrUniqueBidders[$subcontractorContact->contact_id])) {

				$subcontractorContact->htmlEntityEscapeProperties();

				$contactFullNameHtmlEscaped = $subcontractorContact->getContactFullNameHtmlEscaped();
				$escaped_email = $subcontractorContact->escaped_email;

				//$formattedEmail = "x $contactFullNameHtmlEscaped <$escaped_email>";
				//$arrTo[] = $formattedEmail;

				$contactFullName = $subcontractorContact->getContactFullName();
				$email = $subcontractorContact->email;
				$subcontractor_contact_id = $subcontractorContact->contact_id;

				$subcontractorBidderEmailHtml = <<<END_SUBCONTRACTOR_BIDDER_EMAIL_HTML

						<div id="record_container--bidding-module-email-modal-dialog-subcontractor-contact-email--subcontractor_bids--subcontractor_bid_id--$subcontractor_bid_id" class="bidding-module-email-modal-dialog-bidders--subcontractor_bids--subcontractor_bid_id">
							<img class="fakeHref" onclick="deleteBidderFrom_BiddingModuleEmailModalDialog('$subcontractor_bid_id', '$contactFullNameHtmlEscaped &lt;$escaped_email&gt;');" src="/images/icons/icon-delete-x-circle.png">
							<a href="mailto:$escaped_email">$contactFullNameHtmlEscaped &lt;$escaped_email&gt;</a>
						</div>

END_SUBCONTRACTOR_BIDDER_EMAIL_HTML;
				//$formattedEmail = "x $contactFullName <$email>";
				$arrTo[] = $subcontractorBidderEmailHtml;

				$arrUniqueBidders[$subcontractorContact->contact_id] = 1;

			}
		}
	}

	// <div><a href="mailto:john@gmail.com"><img src="images/icons/modules-bidding-email-modal-dialogs/icon_x_circle.png">  john@gmail.com</a></div>
	//$to = join(', ', $arrTo);
	//$to = Data::entity_encode($to);

	$subcontractorBidRecipients = join(', ', $arrTo);

	//$html = require('include/templates/modules-bidding-email-modal-dialog-send-bid-invitations.php');
	$html = require('include/templates/subcontractor-bidding-email-modal-dialog.php');

	return $html;
}

/**
 * output html code for
 * ProjectBidInvitationDocumentEntry
 *
 * @param unknown_type $cdnFileUrl
 * @param unknown_type $escaped_virtual_file_name
 * @return unknown
 */
function outputEmailProjectBidInvitationDocumentEntry($cdnFileUrl, $escaped_virtual_file_name) {
	$documentEntry =
	<<<END_TR_HTML
								<a class="textAlignLeft verticalAlignMiddle bs-tooltip" style="margin: 0px 0 0px 0px;" href="$cdnFileUrl" target="_blank" title="This file will be an attachment."><img src="/images/icons/icon-file-pdf-gray.gif" width="18" height="18" alt=""> $escaped_virtual_file_name</a>
								<img class="fakeHref" src="/images/icons/icon-delete-x-circle.png" width="12" height="12" alt="" title="Remove this file attachment from the list." onclick="removeParentElement(this,'tr');">
END_TR_HTML;
	return $documentEntry;
}
/**
 * output html code for
 * GcBudgetLineItemUnsignedScopeOfWorkDocumentByid
 *
 * @param unknown_type $cdnFileUrl
 * @param unknown_type $escaped_virtual_file_name
 * @param unknown_type $gc_budget_line_item_unsigned_scope_of_work_document_id
 * @return unknown
 */
function outputHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentByid($cdnFileUrl, $escaped_virtual_file_name, $gc_budget_line_item_unsigned_scope_of_work_document_id) {
	$tmpHtml = <<<END_TR_HTML

								<a class="textAlignLeft verticalAlignMiddle bs-tooltip" style="margin: 0px 0 0px 0px;" href="$cdnFileUrl" target="_blank" title="This file will be an attachment."><img src="/images/icons/icon-file-pdf-gray.gif" width="18" height="18" alt=""> $escaped_virtual_file_name</a>
								<img class="fakeHref" src="/images/icons/icon-delete-x-circle.png" width="12" height="12" alt="" title="Remove this file attachment from the list." onclick="removeParentElement(this,'tr');">

END_TR_HTML;
	return $tmpHtml;
}
/**
 * output html code for
 * each Subcontractor on
 * ProjectBidInvitationsDocumentEntry
 *
 * @param unknown_type $arrProjectBidInvitationsDocumentEntry
 * @param unknown_type $subcontractor_bid_id
 * @return unknown
 */
function outputSubcontractorProjectBidInvitationsDocumentEntry($arrProjectBidInvitationsDocumentEntry, $subcontractor_bid_id) {

	$tmpHtml = "";
	$arrProjectBidInvitationsDocumentEntryCount = count($arrProjectBidInvitationsDocumentEntry);
	foreach ($arrProjectBidInvitationsDocumentEntry as $project_bid_invitation_id => $htmlProjectBidInvitationsDocumentEntry) {
		$tmpHtml .= <<<END_TR_HTML
						<tr>
							<td>
								<input type="checkbox" onclick="biddingModuleEmailDialogCheckboxState(this);" value="$subcontractor_bid_id" class="bidding-module-email-modal-dialog-files--project_bid_invitations bidding-module-email-modal-dialog-files--project_bid_invitations--project_bid_invitation_id--{$project_bid_invitation_id}">
								$htmlProjectBidInvitationsDocumentEntry
							</td>
						</tr>
END_TR_HTML;
	}
	return $tmpHtml;
}

function getBudgetLineItemBidInvitationVirtualFileName($gcBudgetLineItemBidInvitation) {
	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$debugMode = $session->getDebugMode();

	/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */
	$gc_budget_line_item_bid_invitation_id = $gcBudgetLineItemBidInvitation->gc_budget_line_item_bid_invitation_id;

	$gcBudgetLineItemBidInvitationFileManagerFile = $gcBudgetLineItemBidInvitation->getGcBudgetLineItemBidInvitationFileManagerFile();
	/* @var $gcBudgetLineItemBidInvitationFileManagerFile FileManagerFile */

	$virtual_file_name = '';
	$gc_budget_line_item_bid_invitation_file_manager_file_id = '';
	$cdnFileUrl = '';
	if ($gcBudgetLineItemBidInvitationFileManagerFile) {

		$gcBudgetLineItemBidInvitationFileManagerFile->htmlEntityEscapeProperties();
		$cdnFileUrl = $gcBudgetLineItemBidInvitationFileManagerFile->generateUrl();
		$virtual_file_name = $gcBudgetLineItemBidInvitationFileManagerFile->virtual_file_name;
		$gc_budget_line_item_bid_invitation_file_manager_file_id = $gcBudgetLineItemBidInvitationFileManagerFile->file_manager_file_id;
		$escaped_virtual_file_name = $gcBudgetLineItemBidInvitationFileManagerFile->escaped_virtual_file_name;
	}
	if ($debugMode) {
		$virtual_file_name = "($gc_budget_line_item_bid_invitation_id) $virtual_file_name";
		$virtual_file_name = "(GBLIBI ID: $gc_budget_line_item_bid_invitation_id, GBLIBI FILE ID: $gc_budget_line_item_bid_invitation_file_manager_file_id) $virtual_file_name";
	}
	$tmpHtml = <<<END_TR_HTML

								<a class="textAlignLeft verticalAlignMiddle bs-tooltip" style="margin: 0px 0 0px 0px;" href="$cdnFileUrl" target="_blank" title="This file will be an attachment."><img src="/images/icons/icon-file-pdf-gray.gif" width="18" height="18" alt=""> $escaped_virtual_file_name</a>
								<img class="fakeHref" src="/images/icons/icon-delete-x-circle.png" width="12" height="12" alt="" title="Remove this file attachment from the list." onclick="removeParentElement(this,'tr');">

END_TR_HTML;

	return $tmpHtml;
}

/**
 * function will generate records in tr with whatever columns given
 *
 * @param unknown_type $arrayRowRecords
 * @param unknown_type $td_column_num
 * @param unknown_type $trCSSClass
 * @return unknown
 */
function outputDocumentRowInColumns($arrayRowRecords, $td_column_num) {

	$tmpHtml = '';
	$counter = 0;
	$rowRecordCount = count($arrayRowRecords);

	foreach ($arrayRowRecords as $rowRecord) {

		//if ($counter != 0 && $counter % $td_column_num == 0 && ($counter != ($rowRecordCount -1))) {
		if ($counter != 0 && $counter % $td_column_num == 0) {
			$tmpHtml .= '</tr><tr>';
		}
		$counter++;
		// compensate last td to add colspan
		// chrome does not like it for border
		$colspan = "";
		if ($counter == $rowRecordCount) {
			//echo "eq"; exit;
			$mod_td_span = $td_column_num % $counter;
			if ($mod_td_span != 0) {
				$colspan = ' colspan="' . $mod_td_span . '"';
			}
		}
		$tmpHtml .= '<td' . $colspan . '>' . $rowRecord . '</td>';
	}
	$tmpHtml = '<tr>' . $tmpHtml . '<tr>';

	return $tmpHtml;
}

/**
 * function will generate records in tr
 *
 * @param unknown_type $arrayRowRecords
 * @param unknown_type $td_column_num
 * @param unknown_type $trCSSClass
 * @return unknown
 */
function outputDocumentRow($arrayRowRecords, $tabSpace, $cssClass = '')  {
	$strCssClass = '';
	if (!empty($cssClass)) {
		$strCssClass = ' class="' . $cssClass . '"';
	}
	$tmpHtml = '';
	foreach ($arrayRowRecords as $rowRecord) {
		$rowRecord = $tabSpace . $rowRecord;
		$tmpHtml .= <<<END_FILES_HTML
				<tr>
					<td{$strCssClass}>$rowRecord
					</td>
				</tr>
END_FILES_HTML;
	}
	return $tmpHtml;
}

function generateSubcontractorBidDocumentEntry($subcontractorBidDocument) {

	$subcontractorBidDocumentFileManagerFile = $subcontractorBidDocument->getSubcontractorBidDocumentFileManagerFile();
	/* @var $subcontractorBidDocumentFileManagerFile FileManagerFile */
	$subcontractorBidDocumentType = $subcontractorBidDocument->getSubcontractorBidDocumentType();
	$subcontractor_bid_document_type = $subcontractorBidDocumentType->subcontractor_bid_document_type;

	$subcontractor_bid_id = $subcontractorBidDocument->subcontractor_bid_id;

	$subcontractor_bid_document_id = $subcontractorBidDocument->subcontractor_bid_document_id;


	if ($subcontractor_bid_document_type == Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION) {
		$checkboxCSSClass = "bidding-module-email-modal-dialog-files--subcontractor-bid-invitaion--subcontractor_bid_document_id--{$subcontractor_bid_document_id}";
	}
	else {
		$checkboxCSSClass = "bidding-module-email-modal-dialog-files--subcontractor-unsigned-scope-of-work--subcontractor_bid_document_id--{$subcontractor_bid_document_id}";
	}
	$virtual_file_name = $subcontractorBidDocumentFileManagerFile->virtual_file_name;
	$cdnFileUrl = $subcontractorBidDocumentFileManagerFile->generateUrl();
	//$escaped_virtual_file_name = $subcontractorBidDocumentFileManagerFile->escaped_virtual_file_name;
	$tmpHtml = <<<END_TR_HTML
								<input type="checkbox" value="{$subcontractor_bid_id}" class="{$checkboxCSSClass}" onclick="biddingModuleEmailDialogCheckboxState(this);" checked>
								<a class="textAlignLeft verticalAlignMiddle bs-tooltip" style="margin: 0px 0 0px 0px;" href="{$cdnFileUrl}" target="_blank" title="This file will be an attachment."><img src="/images/icons/icon-file-pdf-gray.gif" width="18" height="18" alt=""> {$virtual_file_name}</a>
								<img class="fakeHref" src="/images/icons/icon-delete-x-circle.png" width="12" height="12" alt="" title="Remove this file attachment from the list." onclick="removeParentElement(this,'tr');">

END_TR_HTML;
	return $tmpHtml;
}

/**
 * Function to generate tab space
 *
 * @param Integer $level
 * @return String
 */
function generateIndentationByLevel($level) {
	$multiplier = 4;
	$spaceCharacter = ' &nbsp; ';
	$tabString = '';
	$level -= 1;
	if ($level > 0) {
		$loopTime = $level * $multiplier;
		while($loopTime != 0) {
			$tabString .= $spaceCharacter;
			$loopTime--;
		}
		return $tabString;
	}
	return '';
}
