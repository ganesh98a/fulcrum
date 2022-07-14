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

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['ajax'] = false;
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Contact.php');
require_once('lib/common/Message.php');
require_once('lib/common/ProjectBidInvitation.php');
require_once('page-components/fileUploader.php');
require_once('page-components/FineUploader.php');

require_once('modules-bidding-functions.php');

$message = Message::getInstance();
/* @var $message Message */
$message->reset();

$db = DBI::getInstance($database);

// Set permission variables
require('app/models/permission_mdl.php');
$userCanViewBidding = checkPermissionForAllModuleAndRole($database,'bidding_view');

// SESSION VARIABLES
/* @var $session Session */
$session = Zend_Registry::get('session');
$userRole = $session->getUserRole();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$project_id = $session->getCurrentlySelectedProjectId();
$user_id = $session->getUserId();
$user_company_id = $session->getUserCompanyId();
$debugMode = $session->getDebugMode();
if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link rel="stylesheet" href="/css/modules-bidding.css">
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/contextMenu.js"></script>

	<script src="/js/generated/gc_budget_line_item_bid_invitations-js.js"></script>
	<script src="/js/generated/gc_budget_line_item_unsigned_scope_of_work_documents-js.js"></script>
	<script src="/js/generated/project_bid_invitations-js.js"></script>
	<script src="/js/generated/subcontractor_bids-js.js"></script>
	<script src="/js/generated/subcontractor_bid_documents-js.js"></script>
	<script src="/js/generated/subcontractor_trades-js.js"></script>

	<script src="/js/modules-bidding.js"></script>
END_HTML_JAVASCRIPT_BODY;

require('template-assignments/main.php');

ob_start();

$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

$biddingHtmlContent = renderBiddingContent($database, $user_company_id, $project_id, $currentlyActiveContactId);


// Project level bid invite file drop down list and file uploader
$projectBidInvitationsByProjectIdBootstrapDropdownContainerElementId = 'bidding-module-files-bootstrap-dropdown--project_bid_invitations--project_id--'.$project_id;
$abbreviatedFilenameFlag = false;
$includeParentSpanTags = true;
$parentOpeningSpanTagElementId = $projectBidInvitationsByProjectIdBootstrapDropdownContainerElementId;
$arrReturn = renderProjectBidInvitationFilesAsUrlListBiddingVersion($database, $project_id, $abbreviatedFilenameFlag, $includeParentSpanTags, $parentOpeningSpanTagElementId);
$projectBidInvitationsByProjectIdCount = $arrReturn['file_count'];
$projectBidInvitationUploadButtonHasRightSibling = $arrReturn['right_sibling'];
$projectBidInvitationDropdown = $arrReturn['html'];


// Configure the project_bid_invitation file uploader.
$virtual_file_path = '/Bidding & Purchasing/Project Bid Invitations/';
$projectBidInvitationsFileManagerFolder =
	FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);

$project_bid_invitation_file_manager_folder_id = $projectBidInvitationsFileManagerFolder->file_manager_folder_id;
//$elementId = 'project_bid_invitation--'.$project_id;
$projectBidInvitationsFileUploaderElementId = "biddingFileUploader_projectBidInvitationsBiddingVersion_{$project_id}";
//$elementId = 'biddingFileContainer_projectBidInvitationsContent_biddingVersion_'.$project_id;
//$options = '{ projectBidInvitationDropdownContainerElement: $(\'#'.$elementId.'\').next() }';
$options = '{ project_id: '.$project_id.', element: this._element }';
$input = new Input();
$input->id = $projectBidInvitationsFileUploaderElementId;
$input->folder_id = $project_bid_invitation_file_manager_folder_id;
$input->project_id = $project_id;
$input->virtual_file_path = $virtual_file_path;
$input->virtual_file_name = '';
$input->append_date_to_filename = true;
//$input->action = '/modules-file-manager-file-uploader-ajax.php';
$input->action = '/modules-purchasing-file-uploader-ajax.php';
//$input->method = 'uploadFiles';
$input->method = 'projectBidInvitations';
$input->allowed_extensions = 'pdf';
//$input->post_upload_js_callback = 'projectBidInvitationUploaded(arrFileManagerFiles, '.$options.')';
//$input->post_upload_js_callback = 'loadProjectBidInvitationFilesAsUrlListBiddingVersion(options)';
$input->post_upload_js_callback = "loadProjectBidInvitationFilesAsUrlListBiddingVersion('$project_id', '$projectBidInvitationsByProjectIdBootstrapDropdownContainerElementId')";
$input->custom_label = 'Drop/Click';
$input->style = 'vertical-align:middle';
$input->static_uploader_options = array(
	'jsFunction' => 'projectBidInvitationSelected',
	'options' => '{}',
	'uploadButtonHasRightSibling' => $projectBidInvitationUploadButtonHasRightSibling
);
$projectBidInvitationsFileUploader = buildFileUploader($input);


$showStaticUploaders = '';
if (isset($get) && isset($get->nodrag)) {
	$showStaticUploaders = $get->nodrag;
}

$toggleOptionsDropdown = <<<END_TOGGLE_OPTIONS_DROPDOWN

<div class="dropdown displayInlineBlock verticalAlignTop" style="margin-left:10px;">
	<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
		Toggle Options
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a href="javascript:expandOuterAccordions();">Expand/Collapse Outer</a></li>
		<li><a href="javascript:expandAllAccordions();">Expand/Collapse All</a></li>
		<li><a href="javascript:toggleAllDynamicUploadersNoEvent(this);">Turn Off All File Uploaders</a></li>
		<li><a href="javascript:uncheckAll_BiddingModuleFiles_Checkboxes();">Uncheck All File Checkboxes</a></li>
	</ul>
</div>

<div class="dropdown displayInlineBlock verticalAlignTop" style="margin-left:15px;">
	<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
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

END_TOGGLE_OPTIONS_DROPDOWN;

$fineUploaderTemplate = FineUploader::renderTemplate();

$html = <<<END_HTML_CONTENT

<table class="biddingHeaderMenu" border="0" width="100%">

<tr>
<td class="mouseCursorPointer borderCurved colorLightGrayHover" onclick="clickCheckboxByElementId(this, event, 'bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id');">
	&nbsp;
	<input id="bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id" class="bidding-module-bidders-select-all-checkbox" onclick="handle_BiddingModuleBidder_GlobalSelectAllCheckbox_ClickEvent(this, event, 'bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id', 'select-all-bidders');" type="checkbox" value=""> Select All Bidders
	&nbsp;
</td>
<td class="mouseCursorPointer borderCurved colorLightGrayHover" onclick="clickCheckboxByElementId(this, event, 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1');">
	&nbsp;
	<input id="bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1" class="bidding-module-bidders-select-all-checkbox" onclick="handle_BiddingModuleBidder_GlobalSelectAllCheckbox_ClickEvent(this, event, 'bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1', 'select-all-bidders-with-potential-bidder-status');" type="checkbox" value=""> Select All Potential Bidders
	&nbsp;
</td>
<td class="mouseCursorPointer borderCurved colorLightGrayHover" onclick="clickCheckboxByElementId(this, event, 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2');">
	&nbsp;
	<input id="bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2" class="bidding-module-bidders-select-all-checkbox" onclick="handle_BiddingModuleBidder_GlobalSelectAllCheckbox_ClickEvent(this, event, 'bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2', 'select-all-bidders-with-bid-received-status');" type="checkbox" value=""> Select All Bids Received
	&nbsp;
</td>
<td class="mouseCursorPointer borderCurved colorLightGrayHover" onclick="clickCheckboxByElementId(this, event, 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3');">
	&nbsp;
	<input id="bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3" class="bidding-module-bidders-select-all-checkbox" onclick="handle_BiddingModuleBidder_GlobalSelectAllCheckbox_ClickEvent(this, event, 'bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3', 'select-all-bidders-with-declined-to-bid-status');" type="checkbox" value=""> Select All Declined To Bid
	&nbsp;
</td>
<td class="mouseCursorPointer borderCurved colorLightGrayHover" onclick="clickCheckboxByElementId(this, event, 'bidding-module-bidders--send-bid-by-costcode');">
	&nbsp;
	<input id="bidding-module-bidders--send-bid-by-costcode" class="" onclick="trapJavaScriptEvent(event);" type="checkbox" value="Y" checked readonly> Send Bid by Cost Code
	&nbsp;
</td>
<td class="mouseCursorPointer borderCurved colorLightGrayHover" onclick="clickCheckboxByElementId(this, event, 'bidding-module-bidders--checkDefaultBidderDocuments');">
	&nbsp;
	<input id="bidding-module-bidders--checkDefaultBidderDocuments" onclick="checkDefaultBidderDocuments(this, event);" class="" type="checkbox" value="Y"> Toggle Default Documents
	&nbsp;
</td>
<td align="right" colspan="1">
	<input onclick="toggleBiddingModuleExpertMode(this, event);" style="margin: 0; padding: 0; position: relative; top: -0px;" type="button" value="Toggle Advanced Mode">
	<input id="biddingExpertModeState" type="hidden" value="hidden">
</td>
</tr>

<tr>
<td rowspan="2" width="1%">
	<input class="verticalAlignTop" type="button" value="Add New Bidder" onclick="loadAddNewBidderDialog(this, event);">
</td>
<td rowspan="2" width="1%">
	{$toggleOptionsDropdown}
</td>
<!--td rowspan="2" width="1%" style="padding: 0 20px;">
	<input onclick="toggleBiddingModuleExpertMode(this, event);" style="margin: 0; padding: 0px;" type="button" value="Toggle Expert Mode">
	<input id="biddingExpertModeState" type="hidden" value="hidden">
</td-->
<td width="1%">
	&nbsp;
</td>
<td>
	<div class="biddingExpertMode biddingCheckboxToggle"><input type="checkbox" id="checkboxToggleOtherCostCodeSections"> Toggle Cost Code Uploaders By Grouping</div>
</td>
<td>
	<div class="biddingExpertMode biddingCheckboxToggle"><input type="checkbox" id="checkboxOneOpenCostCodeSection"> Allow One Open Bidder Grouping</div>
</td>
<td>
	<div class="biddingExpertMode biddingCheckboxToggle"><input type="checkbox" id="checkboxFollowBidder" checked> Auto-open Rows When Bidder Moves</div>
</td>

<td rowspan="2" width="1%">
	Global Bid Invitation:
</td>
<td rowspan="2" width="1%">

	<table cellpadding="0" cellspacing="0">
	<tr>
	<td>
		<div class="fineUploader bidInvitationUploader"></div>
		{$projectBidInvitationsFileUploader}
	</td>
	<td>
		{$projectBidInvitationDropdown}
	</td>
	</tr>
	</table>

</td>
<!--td rowspan="2" width="1%">

</td-->
</tr>

<tr>
<td width="1%">
	&nbsp;
</td>
<td width="1%">
	<div class="biddingExpertMode biddingCheckboxToggle"><input type="checkbox" id="checkboxToggleOtherBidSections"> Allow One Bidder Upload Section</div>
</td>
<td width="1%">
	<div class="biddingExpertMode biddingCheckboxToggle"><input type="checkbox" id="checkboxOneOpenBidSection"> Allow One Open Cost Code Section</div>
</td>
<td>
	<div class="biddingExpertMode biddingCheckboxToggle"><input id="bidding-module-bidders--checkBidderSpecificUnsignedScopeOfWork" onclick="checkBidderSpecificUnsignedScopeOfWork(this, event);" class="" type="checkbox" value="Y"> Select Bidder Unsigned Scope Of Work Documents</div>
</td>
</tr>

</table>

<!--div style1="max-width:1400px">
	<input class="verticalAlignTop" type="button" value="Add New Bidder" onclick="loadAddNewBidderDialog(this, event);">
	{\$toggleOptionsDropdown}
	<div class="displayInlineBlock" style="margin-left:20px">
		<input type="checkbox" id="checkboxToggleOtherCostCodeSections">
		<label for="checkboxToggleOtherCostCodeSections" style="float: none; font-size: 11px;">Toggle Cost Code Uploaders By Status</label><br>
		<input type="checkbox" id="checkboxToggleOtherBidSections">
		<label for="checkboxToggleOtherBidSections" style="float: none; font-size: 11px;">Toggle other bid uploads</label>
	</div>
	<div class="displayInlineBlock" style="margin-left:20px">
		<input type="checkbox" id="checkboxOneOpenCostCodeSection">
		<label for="checkboxOneOpenCostCodeSection" style="float: none; font-size: 11px;">Allow one open bid section</label><br>
		<input type="checkbox" id="checkboxOneOpenBidSection">
		<label for="checkboxOneOpenBidSection" style="float: none; font-size: 11px;">Allow one open cost code section</label>
	</div>
	<div class="displayInlineBlock verticalAlignTop" style="margin-left:20px">
		<input type="checkbox" id="checkboxFollowBidder" checked>
		<label for="checkboxFollowBidder" style="float: none; font-size: 11px;">Auto-open accordions when bidder moves</label><br>
	</div>
	<div class="project-level-uploaders uploader-container">
		<span style="margin-right:10px">Global Bid Invitation:</span>
		<div class="fineUploader bidInvitationUploader"></div>
		{\$projectBidInvitationsFileUploader}{\$projectBidInvitationDropdown}
	</div>
	<div class="clearfix"></div>
</div-->

<div id="divBidding" class="accordion-container" style="opacity:0">
	{$biddingHtmlContent}
</div>
<ul id="accordionContextMenu" class="dropdown-menu" role="menu" style="display:none" >
    <li><a tabindex="-1" data-target="#">Expand/Collapse outer</a></li>
    <li><a tabindex="-1" data-target="#">Expand/Collapse all</a></li>
    <li class="divider"></li>
    <li><a tabindex="-1" data-target="#">Select all bidders by this status</a></li>
    <li><a tabindex="-1" data-target="#">Select all bidders</a></li>
</ul>
<ul id="subaccordionContextMenu" class="dropdown-menu" role="menu" style="display:none" >
    <li><a tabindex="-1" data-target="#">Expand/Collapse this group</a></li>
</ul>
{$fileUploaderProgressWindow}
<input type="hidden" id="showStaticUploaders" value="{$showStaticUploaders}">
<input type="hidden" id="project_bid_invitation_file_manager_folder_id" value="{$project_bid_invitation_file_manager_folder_id}">
<div id="divAddNewBidderDialog" class="hidden"></div>
<div id="divSendBidInvitationDialog" class="hidden" style="font-size:80%"></div>
<div id="divSendEmailDialog" class="hidden" style="font-size:80%"></div>
{$fineUploaderTemplate}

END_HTML_CONTENT;

if ($userCanViewBidding || $userRole =="global_admin") {
	echo $html;
}else
{
	
	$errorMessage = 'Permission denied.';
    $message->enqueueError($errorMessage, $currentPhpScript);
	$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
	 if ( !empty($htmlMessages) )
  	echo "<div>$htmlMessages</div>";


}

$htmlContent = ob_get_clean();

$template->assign('htmlContent', $htmlContent);
//$htmlJavaScriptBody = '<script src="js/geo.js"></script>';
require_once('page-components/axis/footer_smarty.php');

$template->display('master-web-html5.tpl');
