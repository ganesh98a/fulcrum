(function($) {
	$(document).ready(function() {
		var search=window.location.search;
		if(search!='')
		{
			var searchParam = search.split('=');
			var searchType=searchParam[1];
			if(searchType=='email_bidder'){
				BiddersModalDialog();
				var uri = window.location.toString();
				if (uri.indexOf("?") > 0) {
					var clean_uri = uri.substring(0, uri.indexOf("?"));
					window.history.replaceState({}, document.title, clean_uri);
				}
			}
		}
		$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
		createUploaders();
		updateBudgetTotalsPurchasing(true);

	});
})(jQuery);

function loadPurchaseLog()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var costCodeDivisionId = $("#ddlCostCodeDivisionId").val();
		var sortBy = $("#ddlOrder").val();
		var sortOrder = $("#ddlDirection").val();
		var scheduledValuesOnly = 0;
		if ($("#chkSchedOnly").is(":checked")) {
			scheduledValuesOnly = 1;
		}
		var needsBuyOutOnly = 0;
		if ($("#chkBuyOut").is(":checked")) {
			needsBuyOutOnly = 1;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadPurchaseLog';
		var ajaxQueryString =
		'ccg=' + encodeURIComponent(costCodeDivisionId) +
		'&sb=' + encodeURIComponent(sortBy) +
		'&so=' + encodeURIComponent(sortOrder) +
		'&svo=' + encodeURIComponent(scheduledValuesOnly) +
		'&nbo=' + encodeURIComponent(needsBuyOutOnly);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadPurchaseLogSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadPurchaseLogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divPurchaseLog").html(data);
		updateBudgetTotalsPurchasing(true);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function fileUploader_uploadCompleted(elementId, file_manager_folder_id)
{
	try {

		//alert('element: ' + elementId + '\n\nfolder: ' + file_manager_folder_id);
		if (elementId.indexOf('_projectBidInvitations_') >= 0) {

			// project_bid_invitations

			// Note: To add a Bootstrap dropdown version simply modify the above file uploader div id for that if/else block

			// Parse the file uploader div id
			// E.g. For project_id=3:
			// E.g. budgetFileUploader_projectBidInvitations_3
			// E.g. budgetModalDialogFileUploader_projectBidInvitations_3
			// E.g. projectBidInvitationModalDialogFileUploader_projectBidInvitations_3
			// Project Level Invitations To Bid - Global Level
			var ary = elementId.split('_');
			var project_id = ary[2];

			// Load the list into each of these Element Container Ids
			// Note: These are different than the droppable file uploader div
			// E.g. budgetFileContainer_projectBidInvitationsContent_3
			// E.g. budgetModalDialogFileContainer_projectBidInvitationsContent_3
			// E.g. projectBidInvitationModalDialogFileContainer_projectBidInvitationsContent_3

			// Primary Budget Page
			var budgetProjectBidInvitationsContainerId = 'budgetFileContainer_projectBidInvitationsContent_' + project_id

			// Budget Modal Dialog
			var budgetModalDialogProjectBidInvitationsContainerId = 'budgetModalDialogFileContainer_projectBidInvitationsContent_' + project_id

			// Project Bid Invitations Modal Dialog
			var projectBidInvitationModalDialogProjectBidInvitationsContainerId = 'projectBidInvitationModalDialogFileContainer_projectBidInvitationsContent_' + project_id

			var arrProjectBidInvitationFilesContainerElementIds = [budgetProjectBidInvitationsContainerId, budgetModalDialogProjectBidInvitationsContainerId, projectBidInvitationModalDialogProjectBidInvitationsContainerId];

			loadProjectBidInvitationFilesAsUrlList(project_id, arrProjectBidInvitationFilesContainerElementIds);

		} else if (elementId.indexOf('_gcBudgetLineItemBidInvitations_') >= 0) {

			// gc_budget_line_item_bid_invitations

			// Parse the file uploader div id
			// E.g. For gc_budget_line_item_id=7:
			// E.g. budgetModalDialogFileUploader_gcBudgetLineItemBidInvitations_7
			// Bid Invitations - Gc Budget Line Item (Cost Code) Level
			var ary = elementId.split('_');
			var gc_budget_line_item_id = ary[2];
			$("#currentlySelectedGcBudgetLineItemId").val(gc_budget_line_item_id);

			// Load the list into each of these Element Container Ids
			// Note: These are different than the droppable file uploader div
			// E.g. budgetModalDialogFileContainer_gcBudgetLineItemBidInvitationsContent_7

			var budgetModalDialogGcBudgetLineItemBidInvitationsContainerId = 'budgetModalDialogFileContainer_gcBudgetLineItemBidInvitationsContent_' + gc_budget_line_item_id
			var arrGcBudgetLineItemBidInvitationFilesContainerElementIds = [budgetModalDialogGcBudgetLineItemBidInvitationsContainerId];

			loadGcBudgetLineItemBidInvitationFilesAsUrlList(gc_budget_line_item_id, arrGcBudgetLineItemBidInvitationFilesContainerElementIds);

		} else if (elementId.indexOf('_gcBudgetLineItemUnsignedScopeOfWorkDocuments_') >= 0) {

			// gc_budget_line_item_unsigned_scope_of_work_documents

			// Parse the file uploader div id
			// E.g. For gc_budget_line_item_id=7:
			// E.g. budgetModalDialogFileUploader_gcBudgetLineItemUnsignedScopeOfWorkDocuments_7
			// Unsigned Scope of Work Documents - Gc Budget Line Item (Cost Code) Level
			var ary = elementId.split('_');
			var gc_budget_line_item_id = ary[2];
			$("#currentlySelectedGcBudgetLineItemId").val(gc_budget_line_item_id);

			// Load the list into each of these Element Container Ids
			// Note: These are different than the droppable file uploader div
			// E.g. budgetModalDialogFileContainer_gcBudgetLineItemUnsignedScopeOfWorkDocumentsContent_7

			var budgetModalDialogGcBudgetLineItemUnsignedScopeOfWorkDocumentsContainerId = 'budgetModalDialogFileContainer_gcBudgetLineItemUnsignedScopeOfWorkDocumentsContent_' + gc_budget_line_item_id
			var arrGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesContainerElementIds = [budgetModalDialogGcBudgetLineItemUnsignedScopeOfWorkDocumentsContainerId];

			loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlList(gc_budget_line_item_id, arrGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesContainerElementIds);

		} else if (elementId.indexOf('_subcontractorBidDocumentsBiddingVersion_') >= 0) {
			// Use eval() for now to go forward with current bidding file upload JavaScript architecture

		} else if (elementId.indexOf('_subcontractorBidDocuments_') >= 0) {

			// subcontractor_bid_documents
			// subcontractor_bid_document_types
			// <subcontractor_bid_document_type_id, subcontractor_bid_document_id>

			// Parse the file uploader div id
			var ary = elementId.split('_');
			var subcontractor_bid_document_type_id = ary[2];
			var subcontractor_bid_id = ary[3];

			// Subcontractor Bid Documents - Bidder Specific
			// "FileUploader" vs "FileContainer"
			// E.g. For subcontractor_bid_id=11:


			// "FileUploader" SECTION
			// E.g. subcontractor_bid_document_type_id=1 (Subcontractor Bid)
			// E.g. subcontractorBidDocumentModalDialogFileUploader_subcontractorBidDocuments_1_11

			// E.g. subcontractor_bid_document_type_id=2 (Signed Scope Of Work)
			// E.g. subcontractorBidDocumentModalDialogFileUploader_subcontractorBidDocuments_2_11

			// E.g. subcontractor_bid_document_type_id=3 (Unsigned Scope Of Work - Bidder Specific)
			// E.g. subcontractorBidDocumentModalDialogFileUploader_subcontractorBidDocuments_3_11

			// E.g. subcontractor_bid_document_type_id=4 (Bid Invitation - Bidder Specific)
			// E.g. subcontractorBidDocumentModalDialogFileUploader_subcontractorBidDocuments_4_11

			// E.g. subcontractor_bid_document_type_id=5 (Submittal)
			// E.g. subcontractorBidDocumentModalDialogFileUploader_subcontractorBidDocuments_5_11


			// "FileContainer" SECTION
			// Load the list into each of these Element Container Ids
			// Note: These are different than the droppable file uploader div
			// Note: The "Content" portion
			// subcontractorBidDocumentModalDialogFileContainer_subcontractorBidDocumentsContent_<subcontractor_bid_document_type_id>_<subcontractor_bid_id>
			// subcontractor_bid_documents

			// Subcontractor Bids
			// E.g. subcontractor_bid_document_type_id=1 (Subcontractor Bid)
			// E.g. subcontractorBidDocumentModalDialogFileContainer_subcontractorBidDocumentsContent_1_11

			// E.g. subcontractor_bid_document_type_id=2 (Signed Scope Of Work)
			// E.g. subcontractorBidDocumentModalDialogFileContainer_subcontractorBidDocumentsContent_2_11

			// E.g. subcontractor_bid_document_type_id=3 (Unsigned Scope Of Work - Bidder Specific)
			// E.g. subcontractorBidDocumentModalDialogFileContainer_subcontractorBidDocumentsContent_3_11

			// E.g. subcontractor_bid_document_type_id=4 (Bid Invitation - Bidder Specific)
			// E.g. subcontractorBidDocumentModalDialogFileContainer_subcontractorBidDocumentsContent_4_11

			// E.g. subcontractor_bid_document_type_id=5 (Submittal)
			// E.g. subcontractorBidDocumentModalDialogFileContainer_subcontractorBidDocumentsContent_5_11

			// Note: "FileContainer" in the id value
			// Hard code list of file containers for now
			// 1) budgetModalDialogFileContainer_subcontractorBidDocumentsContent_<subcontractor_bid_document_type_id>_<subcontractor_bid_id>
			// 2) subcontractorBidDocumentModalDialogFileContainer_subcontractorBidDocumentsContent_<subcontractor_bid_document_type_id>_<subcontractor_bid_id>
			var budgetModalDialogSubcontractorBidDocumentsFileContainerId = 'budgetModalDialogFileContainer_subcontractorBidDocumentsContent_' + subcontractor_bid_document_type_id + '_' + subcontractor_bid_id;
			var subcontractorBidDocumentModalDialogSubcontractorBidDocumentsFileContainerId = 'subcontractorBidDocumentModalDialogFileContainer_subcontractorBidDocumentsContent_' + subcontractor_bid_document_type_id + '_' + subcontractor_bid_id;
			var arrSubcontractorBidDocumentFilesContainerElementIds = [budgetModalDialogSubcontractorBidDocumentsFileContainerId, subcontractorBidDocumentModalDialogSubcontractorBidDocumentsFileContainerId];

			loadSubcontractorBidDocumentFilesAsUrlList(subcontractor_bid_id, subcontractor_bid_document_type_id, arrSubcontractorBidDocumentFilesContainerElementIds);

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function deleteProjectBidInvitation(file,attr,subattr,tabledata)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=deleteProjectBidInvitation';
	var ajaxQueryString =
	'file_id=' + encodeURIComponent(file)+
	'&tabledata=' + encodeURIComponent(tabledata);
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	if (window.ajaxUrlDebugMode) {
		var continueDebug = window.confirm(ajaxUrl);
		if (continueDebug != true) {
			return;
		}
	}
		// For project bid files table reload
		var project_id = $('#currentlySelectedProjectId').val();
		var budgetProjectBidInvitationsContainerId = 'budgetFileContainer_projectBidInvitationsContent_' + project_id;
		var budgetModalDialogProjectBidInvitationsContainerId = 'budgetModalDialogFileContainer_projectBidInvitationsContent_' + project_id;
		var projectBidInvitationModalDialogProjectBidInvitationsContainerId = 'projectBidInvitationModalDialogFileContainer_projectBidInvitationsContent_' + project_id;
		var arrProjectBidInvitationFilesContainerElementIds = [budgetProjectBidInvitationsContainerId, budgetModalDialogProjectBidInvitationsContainerId, projectBidInvitationModalDialogProjectBidInvitationsContainerId];

		// For unsigned costcode files table reload
		var gc_budget_line_item_id = $("#currentlySelectedGcBudgetLineItemId").val();
		var budgetModalDialogGcBudgetLineItemUnsignedScopeOfWorkDocumentsContainerId = 'budgetModalDialogFileContainer_gcBudgetLineItemUnsignedScopeOfWorkDocumentsContent_' + gc_budget_line_item_id
		var arrGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesContainerElementIds = [budgetModalDialogGcBudgetLineItemUnsignedScopeOfWorkDocumentsContainerId];
		
		// For default costcode files table reload
		var budgetModalDialogGcBudgetLineItemBidInvitationsContainerId = 'budgetModalDialogFileContainer_gcBudgetLineItemBidInvitationsContent_' + gc_budget_line_item_id
		var arrGcBudgetLineItemBidInvitationFilesContainerElementIds = [budgetModalDialogGcBudgetLineItemBidInvitationsContainerId];

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				deleteFileManagerFile(attr,subattr,file);
				$('#'+attr).remove();
				var count=$('#'+tabledata).val();
				count=count-1;
				var count_data='['+count+']';
				$('#'+tabledata).val(count);
				$('#'+tabledata+'_data').html(count_data);
				if(tabledata == "project_bid"){
					loadProjectBidInvitationFilesAsUrlList(project_id, arrProjectBidInvitationFilesContainerElementIds);
					$(".project_bid_data").html(count_data);
				}
				else if (tabledata == "unsigned") {
					loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlList(gc_budget_line_item_id, arrGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesContainerElementIds);
				}else{
					loadGcBudgetLineItemBidInvitationFilesAsUrlList(gc_budget_line_item_id, arrGcBudgetLineItemBidInvitationFilesContainerElementIds);
				}
				
				
			},
			error: errorHandler
		});
	}
	function Deletesubcontactorbid(file,SubdocId,attr,subattr,subcontractor_bid_id,subcontractor_bid_document_type_id)
	{
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=deletesubcontractorbid';
		var ajaxQueryString =
		'file_id=' + encodeURIComponent(file) +
		'&SubdocId=' + encodeURIComponent(SubdocId);

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){

				deleteFileManagerFile(attr,subattr,file);
				setTimeout(function(){lastest_bid(subcontractor_bid_id,subcontractor_bid_document_type_id);},2000);
				$('#'+attr).remove();
				$('.'+attr).remove();
				
			},
			error: errorHandler
		});

	}
//to fetch the lastest bid
function lastest_bid(subcontractor_bid_id,subcontractor_bid_document_type_id)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=lastest_bid';
	var ajaxQueryString =
	'subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id) +
	'&subcontractor_bid_document_type_id=' + encodeURIComponent(subcontractor_bid_document_type_id);
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

	if (window.ajaxUrlDebugMode) {
		var continueDebug = window.confirm(ajaxUrl);
		if (continueDebug != true) {
			return;
		}
	}

	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function(res){
			var res_data=	res.split('~');
			$("#bidspread_latest_"+subcontractor_bid_id).empty().append(res_data[0]);
			$("#bid_count_"+subcontractor_bid_id).empty().append(res_data[1]);
			if(res_data[1]=='0')
			{
				$("#all_bidlist_"+subcontractor_bid_id).empty();
			}
		},
		error: errorHandler
	});
}
function performSubcontractorBidOperation(elementId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		//      gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--subcontractor_bids--subcontractor_contact_id--14
		// E.g. gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--performSubcontractorBidOperation
		//alert(elementId);

		var arrParts = elementId.split('--');
		var attributeGroupName = arrParts[0];
		var dummyJunkIdPart = arrParts[1];

		var subcontractorBidOperation = $("#" + elementId).val();
		//return;

		if (subcontractorBidOperation == 'send_bid_invitation_via_email') {

			// Send Bid Invitation Via Email
			Gc_Budget__Bidding_Modal_Dialog__sendBidInvitationViaEmail(attributeGroupName);

		} else if (subcontractorBidOperation == 'send_bid_invitation_via_fax') {
			// Send Bid Invitation Via Fax

		} else if (subcontractorBidOperation == 'send_scope_or_revised_scope') {
			// Send Scope / Revised Scope

		} else if (subcontractorBidOperation == 'send_bid_reminder') {
			// Send Reminder To Bid

		} else if (subcontractorBidOperation == 'update-subcontractor_bid_status_id-5') {
			// Flag As Bid Received

		} else if (subcontractorBidOperation == 'update-subcontractor_bid_status_id-6') {
			// Flag As Declined To Bid

		}

		return;


		var arrSubcontractorBidIds = [];
		$(".inviteCheckBox:checked").each(function() {
			var subcontractor_bid_id = $(this).val();
			arrSubcontractorBidIds.push(subcontractor_bid_id);
		});

		if (arrSubcontractorBidIds.length == 0) {
			var messageText = 'You have not selected any bidders to invite.';
			messageAlert(messageText, 'infoMessage');
			return;
		}

		var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');
		var inviteEmailNote = $("#additionalNotes").val();
		inviteEmailNote=inviteEmailNote.replace(/\n/g, '<br>');
		//var activeProjectId = $("#activeProjectId").val();
		var activeProjectId = $("#currentlySelectedProjectId").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=sendInvitationsToBid';
		var ajaxQueryString =
		'csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds) +
		'&project_id=' + encodeURIComponent(activeProjectId) +
		'&emailNote=' + encodeURIComponent(inviteEmailNote);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divModalWindow").dialog('close');
		$("#divAjaxLoading").html('Processing Bid Invitations . . . Please wait');

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: sendBidInvitationsSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function performSubcontractorBidOperationSuccess(data, textStatus, jqXHR)
{
	messageText = 'All bid invitations were successfully sent';
	messageAlert(messageText, 'successMessage');
}
// To track the cc email to sender
function updateccemailforBid(budget_id)
{
	// To receive the cc email
	var checkCCemail = $("#bidccemail").prop('checked');
	var ccemail ="";
	if(checkCCemail == true)
		{			ccemail ='Y';
}
else
{
	ccemail ='N';
}
var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=UpdateccEmailToBudget';
var ajaxQueryString =
'budget_id=' +budget_id +
'&ccemail=' +ccemail;
var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
var returnedJqXHR = $.ajax({
	url: ajaxHandler,
	data: ajaxQueryString,
	success: function()
	{
	},
	error: errorHandler
});

}

function Gc_Budget__Bidding_Modal_Dialog__sendBidInvitationViaEmail(attributeGroupName, callingInterface)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		if (callingInterface == 'Gc_Budget__Bidding_Modal_Dialog') {
			var closeModalDialogFlag = false;
			var resetForm = true;
		} else {
			var closeModalDialogFlag = true;
			var resetForm = false;
		}

		// E.g.
		//    id="gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--subcontractor_bids--subcontractor_contact_id--$subcontractor_bid_id
		// class="gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--subcontractor_bids--subcontractor_contact_id"

		var arrSubcontractorBidIds = [];
		var arrSubcontractorBidContactIds = [];
		var tmpClass = attributeGroupName + '--subcontractor_bids--subcontractor_contact_id';
		// Debug
		//alert(tmpClass);
		// E.g.
		//$(".gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--subcontractor_bids--subcontractor_contact_id:checked").each(function() {
			$("." + tmpClass + ":checked").each(function() {

			//var arrTmpId = $(this).id;
			var tmpElementId = $(this).attr('id');
			var arrParts = tmpElementId.split('--');
			var tmpAttributeGroupName = arrParts[0];
			var tmpAttributeSubgroupName = arrParts[1];
			var tmpAttributeName = arrParts[2];
			var tmpUniqueId = arrParts[3];

			var subcontractor_bid_id = tmpUniqueId;
			arrSubcontractorBidIds.push(subcontractor_bid_id);

			var subcontractor_contact_id = $(this).val();
			arrSubcontractorBidContactIds.push(subcontractor_contact_id);

		});

			if (arrSubcontractorBidIds.length == 0) {
				var messageText = 'You have not selected any bidders to invite.';
				messageAlert(messageText, 'infoMessage');
				return;
			}

			var checkedPdfIds = [];
			var prjDefaultBid = $('#prjDefaultBid').val();
			if (typeof prjDefaultBid !== 'undefined') {
				checkedPdfIds.push(prjDefaultBid);
			}	
			var costCodeUnsinged = $('#costCodeUnsinged').val();
			if (typeof costCodeUnsinged !== 'undefined') {
				checkedPdfIds.push(costCodeUnsinged);
			}
		// $(".checkPrjDefInvToBid:checked").each(function() {
		// 	var pro_pdf_id = $(this).val();
		// 	checkedPdfIds.push(pro_pdf_id);
		// });
		// $(".checkCostCodeInvToBid:checked").each(function() {
		// 	var cost_cost_pdf_id = $(this).val();
		// 	checkedPdfIds.push(cost_cost_pdf_id);
		// });
		// $(".checkUnsignCostCodeInvToBid:checked").each(function() {
		// 	var unsign_cost_code_pdf_id = $(this).val();
		// 	checkedPdfIds.push(unsign_cost_code_pdf_id);
		// });

		var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');
		var csvSubcontractorBidContactIds = arrSubcontractorBidContactIds.join(',');
		var csvCheckedPdfIds = checkedPdfIds.join(',');

//		alert('csvSubcontractorBidIds:' + csvSubcontractorBidIds + ' ' + 'csvSubcontractorBidContactIds:' + csvSubcontractorBidContactIds);

//		return;



var inviteEmailNote = $("#additionalNotes").val();
inviteEmailNote=inviteEmailNote.replace(/\n/g, '<br>');
		//var activeProjectId = $("#activeProjectId").val();
		var activeProjectId = $("#currentlySelectedProjectId").val();
		// To receive the cc email
		var checkCCemail = $("#bidccemail").prop('checked');
		var ccemail ="";
		if(checkCCemail == true)
		{
			ccemail ='Y';
		}
		else
		{
			ccemail ='N';
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=sendInvitationsToBid';
		var ajaxQueryString =
		'csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds) +
		'&csvCheckedPdfIds=' + encodeURIComponent(csvCheckedPdfIds) +
		'&project_id=' + encodeURIComponent(activeProjectId) +
		'&emailNote=' + encodeURIComponent(inviteEmailNote)+
		'&ccemail=' +ccemail;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		if (closeModalDialogFlag) {
			$("#divModalWindow").dialog('close');
		}

		$("#divAjaxLoading").html('Processing Bid Invitations . . . Please wait');

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: sendBidInvitationsSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

		if (callingInterface == 'Gc_Budget__Bidding_Modal_Dialog') {
			// $(".gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--subcontractor_bids--subcontractor_contact_id").prop('checked', false);
			// $("#gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--subcontractor_bids--subcontractor_contact_id--check_all").prop('checked', false);
			$("#additionalNotes").val('');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function sendBidInvitationViaEmailSuccess(data, textStatus, jqXHR)
{
	messageText = 'All bid invitations were successfully sent';
	messageAlert(messageText, 'successMessage');
}

function loadProjectBidInvitationFilesAsUrlList(currentlySelectedProjectId, arrContainerElementIds)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		// csv list of html dom container element ids
		var csvContainerElementIds = arrContainerElementIds.join();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadProjectBidInvitationFilesAsUrlList';
		var ajaxQueryString =
		'project_id=' + encodeURIComponent(currentlySelectedProjectId) +
		'&csvContainerElementIds=' + encodeURIComponent(csvContainerElementIds);

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadProjectBidInvitationFilesAsUrlListSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadProjectBidInvitationFilesAsUrlListSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var currentlySelectedProjectId = json.project_id;
		var csvContainerElementIds = json.csvContainerElementIds;
		var file_count = json.file_count;
		var htmlContent = json.html;
		var latest_file = json.latest_file;

		// Debug
		//alert(file_count);
		//alert(htmlContent);

		var arrContainerElementIds = csvContainerElementIds.split(',');
		for (i = 0; i < arrContainerElementIds.length; i++) {
			var containerElementId = arrContainerElementIds[i];
			if ($("#" + containerElementId).length > 0) {

				$("#" + containerElementId).html(htmlContent);

				if ($("#" + containerElementId).is(':visible')) {
					// toggle the entypo icon?

					// show the html
					$("#" + containerElementId).show();
				}

				var latestFileElementId = containerElementId.replace('projectBidInvitationsContent', 'projectBidInvitationsLatestFile');
				$("#" + latestFileElementId).html(latest_file);
				// hard code for now
				//var entypoElementId = containerElementId.replace('projectBidInvitationsContent', 'projectBidInvitationsEntypoIcon');

				// budgetFileContainer_projectBidInvitationsFileCount_3
				// budgetModalDialogFileContainer_projectBidInvitationsFileCount_3


				var fileCountElementId = containerElementId.replace('projectBidInvitationsContent', 'projectBidInvitationsFileCount');
				//alert(fileCountElementId);

				$('.'+fileCountElementId).val(file_count);
				if ($("#" + fileCountElementId).length > 0) {
					var fileCountHtml = '<b class="project_bid_data">[' + file_count + ']</b>';
					//alert(fileCountHtml);
					$("#" + fileCountElementId).html(fileCountHtml);
					$("#project_bid").val(file_count);
					//$("#" + entypoElementId).show();
				}
			}
		}

		// Attach tooltips to the newly populated html
		$(".bs-tooltip").tooltip();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadGcBudgetLineItemBidInvitationFilesAsUrlList(gc_budget_line_item_id, arrContainerElementIds)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		// csv list of html dom container element ids
		var csvContainerElementIds = arrContainerElementIds.join();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadGcBudgetLineItemBidInvitationFilesAsUrlList';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&csvContainerElementIds=' + encodeURIComponent(csvContainerElementIds);

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadGcBudgetLineItemBidInvitationFilesAsUrlListSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadGcBudgetLineItemBidInvitationFilesAsUrlListSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var gc_budget_line_item_id = json.gc_budget_line_item_id;
		var csvContainerElementIds = json.csvContainerElementIds;
		var file_count = json.file_count;
		var htmlContent = json.html;
		var latest_file = json.latest_file;

		var arrContainerElementIds = csvContainerElementIds.split(',');
		for (i = 0; i < arrContainerElementIds.length; i++) {

			var containerElementId = arrContainerElementIds[i];
			if ($("#" + containerElementId).length > 0) {

				$("#" + containerElementId).html(htmlContent);

				// if visible (expanded), show the html
				if ($("#" + containerElementId).is(':visible')) {
					$("#" + containerElementId).show();
				}

				var latestFileElementId = containerElementId.replace('gcBudgetLineItemBidInvitationsContent', 'gcBudgetLineItemBidInvitationsLatestFile');
				$("#" + latestFileElementId).html(latest_file);

				// hard code for now
				var fileCountElementId = containerElementId.replace('gcBudgetLineItemBidInvitationsContent', 'gcBudgetLineItemBidInvitationsFileCount');
				$('.'+fileCountElementId).val(file_count);
				if ($("#" + fileCountElementId).length > 0) {
					var fileCountHtml = '<b id="budget_line_data">[' + file_count + ']</b>';
					$("#" + fileCountElementId).html(fileCountHtml);
				}

			}

		}

		// Attach tooltips to the newly populated html
		$(".bs-tooltip").tooltip();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlList(gc_budget_line_item_id, arrContainerElementIds)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		// csv list of html dom container element ids
		var csvContainerElementIds = arrContainerElementIds.join();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlList';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&csvContainerElementIds=' + encodeURIComponent(csvContainerElementIds);

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var gc_budget_line_item_id = json.gc_budget_line_item_id;
		var csvContainerElementIds = json.csvContainerElementIds;
		var file_count = json.file_count;
		var htmlContent = json.html;
		var latest_file = json.latest_file;

		var arrContainerElementIds = csvContainerElementIds.split(',');
		for (i = 0; i < arrContainerElementIds.length; i++) {

			var containerElementId = arrContainerElementIds[i];
			if ($("#" + containerElementId).length > 0) {

				$("#" + containerElementId).html(htmlContent);

				// if visible (expanded), show the html
				if ($("#" + containerElementId).is(':visible')) {
					$("#" + containerElementId).show();
				}

				var latestFileElementId = containerElementId.replace('gcBudgetLineItemUnsignedScopeOfWorkDocumentsContent', 'gcBudgetLineItemUnsignedScopeOfWorkDocumentsLatestFile');
				$("#" + latestFileElementId).html(latest_file);

				// hard code for now
				var fileCountElementId = containerElementId.replace('gcBudgetLineItemUnsignedScopeOfWorkDocumentsContent', 'gcBudgetLineItemUnsignedScopeOfWorkDocumentsFileCount');
				$('.'+fileCountElementId).val(file_count);
				if ($("#" + fileCountElementId).length > 0) {
					var fileCountHtml = '<b id="unsigned_data">[' + file_count + ']</b>';
					$("#" + fileCountElementId).html(fileCountHtml);
				}

			}

		}

		// Attach tooltips to the newly populated html
		$(".bs-tooltip").tooltip();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadSubcontractorBidDocumentFilesAsUrlList(subcontractor_bid_id, subcontractor_bid_document_type_id, arrContainerElementIds)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		// @todo Refactor csvContainerElementIds to be a set of key=value pairs
		//   Key: Dom container element id
		// Value: htmlAttributeGroup for the subcontractor_bid_documents for the given Dom container (Dom Namespace)
		// csv list of html dom container element ids
		var csvContainerElementIds = arrContainerElementIds.join();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadSubcontractorBidDocumentFilesAsUrlList';
		var ajaxQueryString =
		'subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id) +
		'&subcontractor_bid_document_type_id=' + encodeURIComponent(subcontractor_bid_document_type_id) +
		'&csvContainerElementIds=' + encodeURIComponent(csvContainerElementIds);

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadSubcontractorBidDocumentFilesAsUrlListSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadSubcontractorBidDocumentFilesAsUrlListSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var subcontractor_bid_id = json.subcontractor_bid_id;
		var subcontractor_bid_document_type_id = json.subcontractor_bid_document_type_id;
		var csvContainerElementIds = json.csvContainerElementIds;
		var file_count = json.file_count;
		var htmlContent = json.html;

		var arrContainerElementIds = csvContainerElementIds.split(',');
		for (i = 0; i < arrContainerElementIds.length; i++) {

			var containerElementId = arrContainerElementIds[i];
			if ($("#" + containerElementId).length > 0) {

				$("#" + containerElementId).html(htmlContent);

				// if visible (expanded), show the html
				if ($("#" + containerElementId).is(':visible')) {
					$("#" + containerElementId).show();
				}

				// hard code for now
				var fileCountElementId = containerElementId.replace('subcontractorBidDocumentsContent', 'subcontractorBidDocumentsFileCount');
				if ($("#" + fileCountElementId).length > 0) {
					var fileCountHtml = '<b>[' + file_count + ']</b>';
					$("#" + fileCountElementId).html(fileCountHtml);
				}

			}

		}

		// Attach tooltips to the newly populated html
		$(".bs-tooltip").tooltip();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showBidInvite(gc_budget_line_item_id, toggleField, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		$("#currentlySelectedGcBudgetLineItemId").val(gc_budget_line_item_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadBidInviteAndScopeWindow';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: showBidInviteSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showBidInviteSuccess(data, textStatus, jqXHR)
{
	try {

		var dialogContainer = $("#divModalWindow").parent();
		$("#divModalWindow2").html(data);
		$("#divModalWindow2").removeClass('hidden');

		$(".bs-tooltip").tooltip();

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.4;
		var dialogHeight = windowHeight * 0.7;

		$("#divModalWindow2").dialog({
			height: dialogHeight,
			width: dialogWidth,
			title: 'Project Bid Invitation File',
			open: function() {
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.hide();
				}
			},
			close: function() {
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.show();
				}
				refreshModalDialog();
			},
			buttons: {
				'Close': function() {
					$(this).dialog('close');
				}
			}
		});

		createUploaders();

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function refreshModalDialog()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var gc_budget_line_item_id = $("#currentlySelectedGcBudgetLineItemId").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadGcBudgetLineItemSubcontractorBidManagementModalDialog';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (!$("#divModalWindow").dialog('isOpen')) {
			loadPurchaseLog();
			return;
		}

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadGcBudgetLineItemSubcontractorBidManagementModalDialogSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function openPurchasingModalWindow()
{
	$("#divModalWindow").removeClass('hidden');
	$("#divModalWindow").dialog({
		height: 600,
		width: 1250,
		modal: true,
		open: function() {
			$("body").addClass('noscroll');
		},
		close: function() {
			$("body").removeClass('noscroll');
			$("#divModalWindow").dialog('destroy');
			$("#divModalWindow").html('');
			$("#divModalWindow").addClass('hidden');
			loadPurchaseLog();
		}
	});
}
//To load Reallocation data 
function loadReallocationDATA(cost_code_id,project_id,budget_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=ReallocationDatas';
		var ajaxQueryString =
		'cost_code_id=' + encodeURIComponent(cost_code_id)+
		'&project_id=' + encodeURIComponent(project_id)+
		'&budget_id=' + encodeURIComponent(budget_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				$('#realocateitem_'+budget_id).empty().append(data);
				document.getElementById("realocateitem_"+budget_id).classList.toggle("show_cont");

			},
			error: errorHandler
		});
	}catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//To load Submittal  data 
function loadSubmittalDelayDATA(cost_code_id,project_id,budget_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=SubmittaldelayDatas';
		var ajaxQueryString =
		'cost_code_id=' + encodeURIComponent(cost_code_id)+
		'&project_id=' + encodeURIComponent(project_id)+
		'&budget_id=' + encodeURIComponent(budget_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				$('#submittalitem_'+budget_id).empty().append(data);
				document.getElementById("submittalitem_"+budget_id).classList.toggle("show_cont");

			},
			error: errorHandler
		});
	}catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//To load subcontractor change order data
function loadSubcontractCODATA(cost_code_id,project_id,budget_id,subcontract_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=SubcontractChangeOrderDatas';
		var ajaxQueryString =
		'cost_code_id=' + encodeURIComponent(cost_code_id)+
		'&project_id=' + encodeURIComponent(project_id)+
		'&subcontract_id=' + encodeURIComponent(subcontract_id)+
		'&budget_id=' + encodeURIComponent(budget_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				$('#suborderitem_'+subcontract_id).empty().append(data);
				document.getElementById("suborderitem_"+subcontract_id).classList.toggle("show_cont");

			},
			error: errorHandler
		});
	}catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function closePopover(budget_id)
{
	 // Close the dropdown if the user clicks outside of it
	 $('#suborderitem_'+budget_id).removeClass('show_cont');

	}
	// Toclose the reallocation popover
	function closerealocatePopover(budget_id)
	{
	 // Close the dropdown if the user clicks outside of it
	 $('#realocateitem_'+budget_id).removeClass('show_cont');

	}

	// Toclose the reallocation popover
	function closesubmittalPopover(budget_id)
	{
	 // Close the dropdown if the user clicks outside of it
	 $('#submittalitem_'+budget_id).removeClass('show_cont');

	}

	function loadGcBudgetLineItemSubcontractorBidManagementModalDialog(gc_budget_line_item_id)
	{
		try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		$("#currentlySelectedGcBudgetLineItemId").val(gc_budget_line_item_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadGcBudgetLineItemSubcontractorBidManagementModalDialog';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		/*
		// Optional $.ajax callbacks may be passed in via the options object
		var arrSuccessCallbacks = [ loadGcBudgetLineItemSubcontractorBidManagementModalDialogSuccess ];
		var successCallback = options.successCallback;
		if (successCallback) {
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}
		*/

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadGcBudgetLineItemSubcontractorBidManagementModalDialogSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadGcBudgetLineItemSubcontractorBidManagementModalDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divModalWindow").empty().html(data);
		var budgetName = $("#activeBudgetName").val();
		if (typeof budgetName == 'undefined' || budgetName == '') {
			budgetName = $("#divModalWindowTitle").val();
		} else {
			$("#divModalWindowTitle").val(budgetName);
		}
		initializeAutoHintFields();
		createUploaders();

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.99;
		var dialogHeight = windowHeight * 0.98;

		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").dialog({
			height: dialogHeight,
			width: dialogWidth,
			modal: true,
			title: budgetName+' — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				window.location.reload(false);
				// $("body").removeClass('noscroll');
				// $("#divModalWindow").dialog('destroy');
				// $("#divModalWindow").html('');
				// $("#divModalWindow").addClass('hidden');
				// closeBudgetLineItemToContactDetailsModalDialog();
			},
			buttons: {
				'Close': function() {
					$(this).dialog('close');
				}
			}
		});
		$(".bs-tooltip").tooltip();
		$(".phoneNumber").mask('?(999) 999-9999');
		$(".phoneExtension").mask('?(999) 999-9999 ext.9999');
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function closeBudgetLineItemToContactDetailsModalDialog()
{
	var currentSoftwareModule = $("#currentSoftwareModule").val();

		// Debug
		//alert(currentSoftwareModule);

		if (currentSoftwareModule == 'gc_budget') {
			filterGcBudgetLineItems();
		} else if (currentSoftwareModule == 'gc_purchasing') {
			loadPurchaseLog();
		}
	}

	function showUploadByCompany()
	{
		try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadUploadByBiddingCompany';
		var ajaxQueryString =
		'';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: showUploadByCompanySuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showUploadByCompanySuccess(data, textStatus, jqXHR)
{
	try {

		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").html(data);
		$("#divModalWindow").dialog({
			height: 350,
			width: 800,
			modal: true,
			title: 'Upload Purchasing Files By Bidding Company',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divModalWindow").dialog('destroy');
				$("#divModalWindow").html('');
				$("#divModalWindow").addClass('hidden');

				// Refresh tabular data. Different calls for Budget/Purchasing.
				var isPurchasingModule = location.pathname.indexOf('purchasing') > -1;
				if (isPurchasingModule) {
					loadPurchaseLog();
				} else { // isBudgetModule
					filterGcBudgetLineItems();
				}
			}
		});

		updateSubcontractorBidDocumentFileUploaderModalDialog();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showAddBidder(gc_budget_line_item_id)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		$("#currentlySelectedGcBudgetLineItemId").val(gc_budget_line_item_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=renderSubcontractorBidContactSearchForms';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: showAddBidderSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showAddBidderSuccess(data, textStatus, jqXHR)
{
	try {

		var gc_budget_line_item_id = $("#currentlySelectedGcBudgetLineItemId").val();
		var budgetName = $("#divModalWindowTitle").val();

		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").html(data);

		$("#divModalWindow").dialog({
			height: 600,
			width: 1250,
			modal: true,
			title: budgetName,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				loadPurchaseLog();
				$("#divModalWindow").dialog('destroy');
				$("#divModalWindow").html('');
				$("#divModalWindow").addClass('hidden');
			},
			buttons: {
				'Add Selected Bidders': function() {
					addSelectedBiddersToBudget(gc_budget_line_item_id);
				},
				'Cancel': function() {
					loadGcBudgetLineItemSubcontractorBidManagementModalDialog(gc_budget_line_item_id);
				}
			}
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function searchContactSelected_purchasingAddBiddersToBudget(element, id, company, firstName, lastName, email)
{
	$("#rowNoBidders").hide();
	var decodedCompanyName = decodeURIComponent(company);
	var decodedFirstName = decodeURIComponent(firstName);
	var decodedLastName = decodeURIComponent(lastName);
	var decodedEmail = decodeURIComponent(email);
	addItemToSelectedList(id, decodedCompanyName, decodedFirstName, decodedLastName, decodedEmail);
}

function addItemToSelectedList(id, company, firstName, lastName, email)
{
	var listOfContactIds = $("#listOfSelectedIds").val();
	var numbers = listOfContactIds.split(',');
	if ($.inArray(id,numbers) == -1) {
		numbers.push(id);
		$("#tblSelectedItems tr:last").after(
			'<tr id="selItem_'+id+'" name="selItem_'+id+'">'+
			'<td nowrap><a href="javascript:removeItemFromSelectedList(\''+id+'\');">x</a></td>'+
			'<td nowrap>'+firstName+'</td>'+
			'<td nowrap>'+lastName+'</td>'+
			'<td nowrap>('+email+')</td>'+
			'<td nowrap> &mdash; '+company+'</td>'+
			'</tr>');
	}
	listOfContactIds = numbers.join(',');
	$("#listOfSelectedIds").val(listOfContactIds);
}

function removeItemFromSelectedList(id)
{
	var listOfContactIds = $("#listOfSelectedIds").val();
	var numbers = listOfContactIds.split(',');
	if ($.inArray(id,numbers) > -1) {
		numbers.splice($.inArray(id, numbers),1);
		$("#selItem_" + id).remove();
	}
	listOfContactIds = numbers.join(',');
	$("#listOfSelectedIds").val(listOfContactIds);
}

function cancelAddBidderClicked(gc_budget_line_item_id)
{
	//var budgetName = $("#divModalWindow").dialog('option', 'title');
	//loadGcBudgetLineItemSubcontractorBidManagementModalDialog(gc_budget_line_item_id, budgetName);
	loadGcBudgetLineItemSubcontractorBidManagementModalDialog(gc_budget_line_item_id);
}

function addSelectedBiddersToBudget(gc_budget_line_item_id)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var listOfContactIds = $("#listOfSelectedIds").val();

		if ($.trim(listOfContactIds).length == 0) {
			var messageText = 'You have not selected any recipients';
			messageAlert(messageText, 'warningMessage');
			return;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=addSelectedBiddersToBudget';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&recipients=' + encodeURIComponent(listOfContactIds);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: addSelectedBiddersToBudgetSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function addSelectedBiddersToBudgetSuccess(data, textStatus, jqXHR)
{
	try {

		var messageText = 'Bidders successfully added.';
		messageAlert(messageText, 'successMessage');
		loadGcBudgetLineItemSubcontractorBidManagementModalDialogSuccess(data, textStatus, jqXHR);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateBidderContactId(subcontractor_bid_id, gc_budget_line_item_id)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var newContactId = $("#ddlBidderContactId" + subcontractor_bid_id).val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=updateBidderContactId';
		var ajaxQueryString =
		'subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id) +
		'&contact_id=' + encodeURIComponent(newContactId) +
		'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadGcBudgetLineItemSubcontractorBidManagementModalDialogSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateSubcontractorBidStatus(subcontractor_bid_id)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var subcontractor_bid_status_id = $("#ddlSubcontractorBidStatus" + subcontractor_bid_id).val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=updateSubcontractorBidStatus';
		var ajaxQueryString =
		'subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id) +
		'&subcontractor_bid_status_id=' + encodeURIComponent(subcontractor_bid_status_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateSubcontractorBidStatusSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateSubcontractorBidStatusSuccess(data, textStatus, jqXHR)
{
	try {

		var messageText = "Bidder status successfully updated.";
		messageAlert(messageText, 'successMessage');
		loadGcBudgetLineItemSubcontractorBidManagementModalDialogSuccess(data, textStatus, jqXHR);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function saveBidderConversationNote(subcontractor_bid_id)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		$("#activeSubcontractorBidId").val(subcontractor_bid_id);
		var newNote = $("#txtBidderNote_" + subcontractor_bid_id).val();

		if (newNote.length == 0) {
			return;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=addBidderConversationNote';
		var ajaxQueryString =
		'subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id) +
		'&newNote=' + encodeURIComponent(newNote);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: saveBidderConversationNoteSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function saveBidderConversationNoteSuccess(data, textStatus, jqXHR)
{
	try {

		var messageText = "Conversation note successfully added.";
		messageAlert(messageText, 'successMessage');
		var subcontractor_bid_id = $("#activeSubcontractorBidId").val();
		$("#divBidderNotes_" + subcontractor_bid_id).html(data);
		$("#txtBidderNote_" + subcontractor_bid_id).val('');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showAllConversations()
{
	if ($(".conversationRow:visible").length == 0) {
		$(".conversationRow").show();
		$("span.ui-icon").removeClass("ui-icon-triangle-1-e");
		$("span.ui-icon").addClass("ui-icon-triangle-1-s");
	} else {
		$(".conversationRow").hide();
		$("span.ui-icon").removeClass("ui-icon-triangle-1-s");
		$("span.ui-icon").addClass("ui-icon-triangle-1-e");
	}
}

function showConversation(subcontractor_bid_id)
{
	$("#bidderDetails_" + subcontractor_bid_id).toggle();
	if ($("#bidderTriangle_" + subcontractor_bid_id).hasClass("ui-icon-triangle-1-e")) {
		$("#bidderTriangle_" + subcontractor_bid_id).removeClass("ui-icon-triangle-1-e");
		$("#bidderTriangle_" + subcontractor_bid_id).addClass("ui-icon-triangle-1-s");
	} else {
		$("#bidderTriangle_" + subcontractor_bid_id).removeClass("ui-icon-triangle-1-s");
		$("#bidderTriangle_" + subcontractor_bid_id).addClass("ui-icon-triangle-1-e");
	}
}

function updateBudgetTotalsPurchasing(formatValuesInline)
{
	autoSumByClass('autosum-pcsv', 'primeContractScheduledValuesTotal', formatValuesInline);
	autoSumByClass('autosum-fe', 'forecastedExpensesTotal', formatValuesInline);
	// autoSumByClass('autosum-sav', 'subcontractActualValuesTotal', formatValuesInline);
}

function changeBudgetValue(elementId, gc_budget_line_item_id)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var tmpValue = $("#" + elementId).val();

		var newValue = parseInputToCurrency(tmpValue);

		// Validation: min
		if (newValue < -99999999.99) {
			alert('Value must be greater than -99,999,999.99');
			return;
		}

		// Validation: max
		if (newValue > 99999999.99) {
			alert('Value must be less than or equal to 99,999,999.99');
			return;
		}

		if (newValue !== '') {
			if (newValue < 0) {
				$("#" + elementId).addClass('red');
			} else {
				$("#" + elementId).removeClass('red');
			}
			var formattedValue = formatDollar(newValue);
			if (newValue == 0) {
				formattedValue = '$0.00';
			}
			$("#" + elementId).val(formattedValue);
		} else {
			$("#" + elementId).val('');
			$("#" + elementId).removeClass('red');
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=updateBudgetValue';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&newValue=' + encodeURIComponent(newValue) +
		'&elementId' + encodeURIComponent(elementId);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateBudgetValueSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateBudgetValueSuccess(data, textStatus, jqXHR)
{
	try {

		var messageText = 'Budget item successfully updated.';
		var elementId = data;
		messageAlert(messageText, 'successMessage', 'successMessageLabel', elementId);
		updateBudgetTotalsPurchasing(true);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateTargetDate(gc_budget_line_item_id)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var elementId = 'tDate_' + gc_budget_line_item_id;
		var newDate = $("#" + elementId).val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=updateBudgetValue';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&newValue=' + encodeURIComponent(newDate) +
		'&elementId' + encodeURIComponent(elementId);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateBudgetValueSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Purchasing__updateBidderEmailSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			if ($("#activeGcBudgetLineItemId").length > 0) {

				var gc_budget_line_item_id = $("#activeGcBudgetLineItemId").val();
				//var budgetName = $("#divModalWindow").dialog('option', 'title');
				//loadGcBudgetLineItemSubcontractorBidManagementModalDialog(gc_budget_line_item_id, budgetName);
				loadGcBudgetLineItemSubcontractorBidManagementModalDialog(gc_budget_line_item_id);

			} else if ($("#currentDialog").length > 0) {

				var popupWindow = $("#currentDialog").val();
				if (popupWindow == "potentialBidders" ) {

					var emailComment = $("#additionalNotes").val();
					showInviteAllBidders(emailComment);

				} else if (popupWindow == "emailBidders") {

					var subcontractor_bid_status_id = $("#ddl--subcontractor_bid_status_id").val();
					if (subcontractor_bid_status_id) {

					} else {

						renderSimpleEmailBiddersModalDialog();

					}

					// @todo Update other contact email instances inline
				}

			}
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function sendBidInvitations()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var arrSubcontractorBidIds = [];
		var costcodeArr =[];
		var test = '';
		var codeArr = [];
		var events = [];
		var groupedEvents = {};
		var gcItemIdArr = [];
		var GcBudgetLineItemId=$('#activeGcBudgetLineItemId').val();	
		$(".inviteCheckBox:checked").each(function(item,index) {
			var subcontractor_bid_id = $(this).val();
			arrSubcontractorBidIds.push(subcontractor_bid_id);
			// Extracting cost code 
			var arrCostCode = $(this).attr("class").split('~')[1];
			var contactId = $(this).attr("data-origin-id");
			var gc_budjet_line_item_id = $(this).attr("data-id");
			costcodeArr.push(arrCostCode);
			if(typeof gc_budjet_line_item_id != "undefined")
			{
				gcItemIdArr.push(gc_budjet_line_item_id);
			}
			if(arrCostCode != test && typeof arrCostCode != "undefined")
			{
				codeArr = {arrCostCode,contactId}
				events.push(codeArr);
			}else if(typeof arrCostCode != "undefined")
			{
				codeArr = {arrCostCode,contactId}
				events.push(codeArr);
			}
			test = arrCostCode;
		});
		for (let i = 0; i < events.length; i++) {
			const time = events[i].arrCostCode;
			const action = events[i].contactId;
			if (!groupedEvents.hasOwnProperty(time)) {
				groupedEvents[time] = [];
			}
			groupedEvents[time].push(action);
		}
		var groupedEvents = JSON.stringify(groupedEvents);

		// Extracted Costcode var
		var exCostCode = $.unique(costcodeArr);

		if (arrSubcontractorBidIds.length == 0) {
			var messageText = 'You have not selected any bidders to invite.';
			messageAlert(messageText, 'infoMessage');
			return;
		}

		var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');
		var inviteEmailNote = $("#additionalNotes").val();
		inviteEmailNote=inviteEmailNote.replace(/\n/g, '<br>');

		if(inviteEmailNote == 'Email body . . .')
		{
			inviteEmailNote = ''
		}
		//attachments
		var attachArr = [];
		var attachmentsArr = {};
		var i =0;
		$( "#ulEmailAttachments li" ).each(function( index ) {
			var upfileval = $(this).attr('id');
			attachmentsArr[i] =  parseInt(upfileval) ;
			attachArr.push(parseInt(upfileval));
			i++;
		});
		var attachments = JSON.stringify(attachmentsArr);
		
		var uniqueGcItem = gcItemIdArr;
		var gcBudjetItems = {};
		for (let i = 0; i < events.length; i++) {
			const groupCostcode = events[i].arrCostCode;
			const groupGcBudjet = uniqueGcItem[i];
			if (!gcBudjetItems.hasOwnProperty(groupCostcode)) {
				gcBudjetItems[groupCostcode] = [];
			}
			gcBudjetItems[groupCostcode].push(groupGcBudjet);
		}
		
		var gcBudjetItemsGrp = JSON.stringify(gcBudjetItems);
		//var activeProjectId = $("#activeProjectId").val();
		var activeProjectId = $("#currentlySelectedProjectId").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=sendInvitationsToBid';
		var ajaxQueryString =
		'csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds) +
		'&project_id=' + encodeURIComponent(activeProjectId) +
		'&emailNote=' + encodeURIComponent(inviteEmailNote) +
		'&attachments=' + encodeURIComponent(attachments)+
		'&exCostCode=' + encodeURIComponent(groupedEvents)+
		'&gcBudjetItem=' + encodeURIComponent(gcBudjetItemsGrp);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divModalWindow").dialog('close');
		$("#divAjaxLoading").html('Processing Bid Invitations . . . Please wait');

		var returnData = [];
		returnData['extCode'] = groupedEvents;
		returnData['mailIdsText'] = inviteEmailNote;
		returnData['csvSubcontractorBidContactIds'] = csvSubcontractorBidIds;
		returnData['mailAttachments'] = attachArr;
		returnData['gcBudjetItems'] = gcBudjetItemsGrp;
		if(groupedEvents!=''){
			var arrSuccessCallbacks = [ sendBidInvitationsSuccess(returnData) ];

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: arrSuccessCallbacks,
				error: errorHandler
			});

			
			if (promiseChain) {
				return returnedJqXHR;
			}
		}
		

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function sendBidInvitationsSuccess(data, textStatus, jqXHR)
{
	var mailIdsText = data.mailIdsText;
	var exCostCode = encodeURIComponent(data.extCode);
	var mailAttachments = data.mailAttachments;
	var TransmittalId = data.TransmittalId;
	var gcBudjetItems = encodeURIComponent(data.gcBudjetItems);
	var csvSubcontractorBidContactIds = data.csvSubcontractorBidContactIds;
	var activeProjectId = $("#currentlySelectedProjectId").val();
	messageText = 'All bid invitations were successfully sent';
	messageAlert(messageText, 'successMessage');
	var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-operations.php';
	var attachments='';
	var GcBudgetLineItemId=$('#activeGcBudgetLineItemId').val();
	var attributeGroupName='gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record';
	var tmpClass = attributeGroupName + '--subcontractor_bids--subcontractor_contact_id';
	if (exCostCode == 'null') {
		var arrSubcontractorBidContactIds = [];
		$("input:checkbox[class="+tmpClass+"]:checked").each(function () {
			var subcontractor_contact_id = $(this).val();
			arrSubcontractorBidContactIds.push(subcontractor_contact_id);
		});
		var csvSubcontractorBidContactIds = arrSubcontractorBidContactIds.join(',');
	}
	var checkedPdfIds = [];
	var prjDefaultBid = $('#prjDefaultBid').val();
	if (typeof prjDefaultBid !== 'undefined') {
		checkedPdfIds.push(prjDefaultBid);
	}	
	var costCodeUnsinged = $('#costCodeUnsinged').val();
	if (typeof costCodeUnsinged !== 'undefined') {
		checkedPdfIds.push(costCodeUnsinged);
	}
	// $(".checkPrjDefInvToBid:checked").each(function() {
	// 	var pro_pdf_id = $(this).val();
	// 	checkedPdfIds.push(pro_pdf_id);
	// });
	// $(".checkCostCodeInvToBid:checked").each(function() {
	// 	var cost_cost_pdf_id = $(this).val();
	// 	checkedPdfIds.push(cost_cost_pdf_id);
	// });
	// $(".checkUnsignCostCodeInvToBid:checked").each(function() {
	// 	var unsign_cost_code_pdf_id = $(this).val();
	// 	checkedPdfIds.push(unsign_cost_code_pdf_id);
	// });
	// var csvSubcontractorBidContactIds = arrSubcontractorBidContactIds.join(',');
	var csvCheckedPdfIds = checkedPdfIds.join(',');
	// console.log('csvSubcontractorBidContactIds',csvSubcontractorBidContactIds);
	var arrCostcodeIds = [];
	$(".inviteCheckBox:checked").each(function() {
		var costCodeId = $(this).val();
		arrCostcodeIds.push(costCodeId);
	});

	//To uncheck the checkbox
	$(".gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--subcontractor_bids--subcontractor_contact_id").prop('checked', false);
	$("#gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--subcontractor_bids--subcontractor_contact_id--check_all").prop('checked', false);
	$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:"method=Bid Invitation&type=Bid&GcBudgetLineItemId="+GcBudgetLineItemId+"&csvCheckedPdfIds="+csvCheckedPdfIds+"&csvSubcontractorBidContactIds="+csvSubcontractorBidContactIds+"&mailIdTexts="+mailIdsText+"&exCostCode="+exCostCode+"&mailAttachments="+mailAttachments+"&gcBudjetItems="+gcBudjetItems+"&TransmittalId="+TransmittalId,
		success:function(data)
		{
			setTimeout(function(){
				window.location.href="/modules-gc-budget-form.php?pID="+atob(activeProjectId);
			}, 3000);
		}

	});
}

function permissionModalClosed()
{
	// TODO What needs to happen when Permission modal is closed
}

function renderDeleteSubcontractorBidFromGcBudgetLineItemModalDialog(subcontractor_bid_id, gc_budget_line_item_id)
{
	var dialogContainer = $("#divModalWindow").parent();
	$("#divModalWindow2").html('Are you sure you want to delete this bidder?<br><br>Doing so will remove all associated files and data.');
	$("#divModalWindow2").removeClass('hidden');

	var windowWidth = $(window).width();
	var windowHeight = $(window).height();

	var dialogWidth = windowWidth * 0.25;
	var dialogHeight = windowHeight * 0.3;

	$("#divModalWindow2").dialog({
		height: dialogHeight,
		width: dialogWidth,
		title: 'Confirm Delete',
		open: function() {
			if (dialogContainer.hasClass('ui-dialog')) {
				dialogContainer.hide();
			}
		},
		close: function() {
			$(this).dialog('destroy');
			$("#divModalWindow2").html('');
			$("#divModalWindow2").addClass('hidden');
			if (dialogContainer.hasClass('ui-dialog')) {
				dialogContainer.show();
			}
		},
		buttons: {
			'Delete Bidder & Associated Bid Files': function() {
				deleteSubcontractorBidFromGcBudgetLineItem(subcontractor_bid_id, gc_budget_line_item_id);
				$(this).dialog('close');
			},
			'Cancel': function() {
				$(this).dialog('close');
			}
		}
	});
}

function deleteSubcontractorBidFromGcBudgetLineItem(subcontractor_bid_id, gc_budget_line_item_id)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=deleteSubcontractorBidFromGcBudgetLineItem';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: deleteSubcontractorBidFromGcBudgetLineItemSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteSubcontractorBidFromGcBudgetLineItemSuccess(data, textStatus, jqXHR)
{
	try {

		var messageText = 'Bidders successfully removed.';
		messageAlert(messageText, 'successMessage');
		loadGcBudgetLineItemSubcontractorBidManagementModalDialogSuccess(data, textStatus, jqXHR);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function renderSubcontractorBidDocumentFileUploaderModalDialog(subcontractor_bid_id, gc_budget_line_item_id)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		$("#currentlySelectedGcBudgetLineItemId").val(gc_budget_line_item_id);
		//var companyName = $.trim($("#bidderCompany_" + subcontractor_bid_id).html());

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=renderSubcontractorBidDocumentFileUploaderModalDialog';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id);
			//'&companyName=' + encodeURIComponent(companyName);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: renderSubcontractorBidDocumentFileUploaderModalDialogSuccess,
				error: errorHandler
			});

			if (promiseChain) {
				return returnedJqXHR;
			}

		} catch(error) {

			if (window.showJSExceptions) {
				var errorMessage = error.message;
				alert('Exception Thrown: ' + errorMessage);
				return;
			}

		}
	}

	function renderSubcontractorBidDocumentFileUploaderModalDialogSuccess(data, textStatus, jqXHR)
	{
		try {

			var dialogContainer = $("#divModalWindow").parent();
			$("#divModalWindow2").removeClass('hidden');
			$("#divModalWindow2").html(data);
			createUploaders();
			$(".bs-tooltip").tooltip();
			var companyName = $("#titleCompanyName").val();

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

		//var dialogWidth = windowWidth * 0.99;
		//var dialogHeight = windowHeight * 0.99;
		var dialogWidth = windowWidth * 0.7;
		var dialogHeight = windowHeight * 0.7;

		$("#divModalWindow2").dialog({
			height: dialogHeight,
			width: dialogWidth,
			modal: false,
			title: companyName + ' Files',
			open: function() {
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.hide();
				}
			},
			close: function() {
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.show();
				}
				refreshModalDialog();
			},
			buttons: {
				'Close': function() {
					$(this).dialog('close');
				}
			}
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showUploadLoaded()
{
	createUploaders();
	$("#divModalWindow2").removeClass('hidden');
	$("#divModalWindow2").dialog('open');
}

function updateSubcontractorBidDocumentFileUploaderModalDialog()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		if ($("#ddlBiddersByCompany").length == 0) {
			return;
		}

		var selValue = $("#ddlBiddersByCompany").val();
		var arrIds = selValue.split('|');
		var gc_budget_line_item_id = arrIds[0];
		var subcontractor_bid_id = arrIds[1];
		var companyName = arrIds[2];
		var budgetName = arrIds[3];
		$("#divBidderByCompanyName").html(companyName + ' Files');
		$("#divBidderByCompanyBudget").html(budgetName);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=renderSubcontractorBidDocumentFileUploaderModalDialog';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id);
			//'&companyName=' + encodeURIComponent(companyName);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: updateSubcontractorBidDocumentFileUploaderModalDialogSuccess,
				error: errorHandler
			});

			if (promiseChain) {
				return returnedJqXHR;
			}

		} catch(error) {

			if (window.showJSExceptions) {
				var errorMessage = error.message;
				alert('Exception Thrown: ' + errorMessage);
				return;
			}

		}
	}

	function updateSubcontractorBidDocumentFileUploaderModalDialogSuccess(data, textStatus, jqXHR)
	{
		try {

			$("#divUploadFiles").html(data);
			createUploaders();

		} catch (error) {

			if (window.showJSExceptions) {
				var errorMessage = error.message;
				alert('Exception Thrown: ' + errorMessage);
				return;
			}

		}
	}

	function viewSpread(gc_budget_line_item_id, cost_code_division_id, cost_code_id)
	{
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread.php?method=dummy';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
		'&cost_code_id=' + encodeURIComponent(cost_code_id);
	//var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

	if (window.ajaxUrlDebugMode) {
		alert(ajaxUrl);
		return;
	}

	window.open(ajaxUrl);
}

function showImportBidders(options)
{
	try {

		// Origin function so create options inline???
		// var options = { promiseChain: false, responseDataType: 'json' };

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.promiseChain = false;

		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadImportBiddersDropDown';
		var ajaxQueryString = '';
		//	'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		//	'&companyName=' + encodeURIComponent(companyName);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		// options is an object containing values so form a query string of the key/value pairs
		var ajaxQueryStringFromOptions = generateAjaxQueryStringFromOptions(options);
		ajaxQueryString = ajaxQueryString + ajaxQueryStringFromOptions;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: showImportBiddersSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showImportBiddersSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var htmlContent = json.htmlContent;

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			var dialogWidth = windowWidth * 0.8;
			var dialogHeight = windowHeight * 0.9;

			if (dialogWidth < 800) {
				dialogActualWidth = 800;
			} else {
				dialogActualWidth = dialogWidth;
			}

			if (dialogHeight < 600) {
				dialogActualHeight = 600;
			} else {
				dialogActualHeight = dialogHeight;
			}

			$("#divModalWindow").html(htmlContent);
			$("#divModalWindow").removeClass('hidden');
			$("#divModalWindow").dialog({
				width: dialogActualWidth,
				height: dialogActualHeight,
				title: 'Import All Bidders Or A Subset From A Project Or Bid List',
				modal: true,
				open: function() {
					$("body").addClass('noscroll');
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divModalWindow").dialog('destroy');
					$("#divModalWindow").html('');
					$("#divModalWindow").addClass('hidden');
				},
				buttons: {
					'Import Checked Bidders': function() {
						importCheckedBidders();
					},
					'Cancel': function() {
						$(this).dialog('close');
					}
				}
			});

			initializeAutoHintFields();
			createUploaders();

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function divModalWindowOpen()
{
	$("#divModalWindow").removeClass('hidden');
	$("#divModalWindow").dialog('open');
	initializeAutoHintFields();
	createUploaders();
}

function updateImportOptions()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var selectedOption = $("#ddlImportList").val();
		if(selectedOption == 0){
			$("#divImportableBidders").html('');
			return;
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadImportBidders';
		var ajaxQueryString =
		'selItem=' + encodeURIComponent(selectedOption);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateImportOptionsSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateImportOptionsSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divImportableBidders").html(data);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function checkBiddersToImport(chkBox, costCode)
{
	if (($(chkBox).is(':checked'))) {
		if (costCode.toString() == '0') {
			$(".inputCheckbox").prop('checked', true);
		} else {
			$("." + costCode).prop('checked', true);
		}
	} else {
		if (costCode.toString() == '0') {
			$(".inputCheckbox").prop('checked', false);
		} else {
			$("." + costCode).prop('checked', false);
		}
	}
}

function checkBiddersToInvite(chkBox,costCode)
{
	if (($(chkBox).is(":checked"))) {
		if (costCode.toString() == '0') {
			$(".inviteCheckBox").prop('checked', true);
		} else {
			$("." + costCode).prop('checked', true);
		}
	} else {
		if (costCode.toString() == '0') {
			$(".inviteCheckBox").prop('checked', false);
		} else {
			$("." + costCode).prop('checked', false);
		}
	}
}

function checkProjectContactsToInvite(chkBox,costCode)
{
	if (($(chkBox).is(":checked"))) {
		if (costCode.toString() == '0') {
			$(".projectContactCheckBox").prop('checked', true);
		} else {
			$("." + costCode).prop('checked', true);
		}
	} else {
		if (costCode.toString() == '0') {
			$(".projectContactCheckBox").prop('checked', false);
		} else {
			$("." + costCode).prop('checked', false);
		}
	}
}

// Function of check all check box under the list

function checkPrjDefInvToBid(chkBox){
	if (($(chkBox).is(":checked"))) {
		$(".checkPrjDefInvToBid").prop('checked', true);
	}else{
		$(".checkPrjDefInvToBid").prop('checked', false);
	}
}

function checkCostCodeInvToBid(chkBox){
	if (($(chkBox).is(":checked"))) {
		$(".checkCostCodeInvToBid").prop('checked', true);
	}else{
		$(".checkCostCodeInvToBid").prop('checked', false);
	}
}

function checkUnsignCostCodeInvToBid(chkBox){
	if (($(chkBox).is(":checked"))) {
		$(".checkUnsignCostCodeInvToBid").prop('checked', true);
	}else{
		$(".checkUnsignCostCodeInvToBid").prop('checked', false);
	}
}

function checkNonContactToInvite(chkBox){
	if (($(chkBox).is(":checked"))) {
		$(".checkNonContact").prop('checked', true);
	}else{
		$(".checkNonContact").prop('checked', false);
	}
}

function triggerGroupClick(costCode)
{
	$("#group_" + costCode).click();
}

function importCheckedBidders()
{
	try {
		showSpinner();
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var arrCheckedBidders = $('input[id^="chk_"]:checked').map(function () {
			return this.value;
		}).get();

		if (arrCheckedBidders.length == 0) {
			hideSpinner();
			var messageText = 'You have not selected any bidders to import.';
			messageAlert(messageText, 'warningMessage');
			return;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=importSelectedBidders';
		var ajaxQueryString =
		'arrBidders=' + encodeURIComponent(arrCheckedBidders);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			async:true,
			success: importCheckedBiddersSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function importCheckedBiddersSuccess(data, textStatus, jqXHR)
{
	try {

		var messageText = 'Bidders successfully added.';
		messageAlert(messageText, 'successMessage');

		//$(this).dialog('option', 'buttons', {});
		$("#divModalWindow").dialog('option', 'buttons', {});
		$("#divModalWindow").dialog('close');

		//loadPurchaseLog();
		// closeBudgetLineItemToContactDetailsModalDialog()
		window.location.reload();
		hideSpinner();
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showRequestBudgetNumbersFromAllBidders()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=requestBudgetNumbersFromAllBidders';
		var ajaxQueryString = '';
		//	'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		//	'&companyName=' + encodeURIComponent(companyName);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: showRequestBudgetNumbersFromAllBiddersSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showRequestBudgetNumbersFromAllBiddersSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").html(data);
		$("#divModalWindow").dialog({
			height: 500,
			width: 600,
			title: 'Request Budget Numbers',
			modal: true,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divModalWindow").dialog('destroy');
				$("#divModalWindow").html('');
				$("#divModalWindow").addClass('hidden');
			},
			buttons: {
				'Request Budget Numbers From Selected Potentials': function() {
					sendBudgetNumberRequests();
				},
				'Cancel': function() {
					$(this).dialog('close');
				}
			}
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function sendBudgetNumberRequests()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		if ($(".inviteCheckBox:checked").length == 0) {
			var messageText = 'You have not selected any bidders to request Budget Numbers from.';
			messageAlert(messageText, 'infoMessage');
			return;
		}

		var csvSubcontractorBidIds = $(".inviteCheckBox:checked").map(function () {
			if (this.value != "on") {
				return this.value;
			}
		}).get();

		var inviteEmailNote = $("#additionalNotes").val();
		var activeProjectId = $("#activeProjectId").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=sendBudgetNumberRequests';
		var ajaxQueryString =
		'arrBudgetContact=' + encodeURIComponent(csvSubcontractorBidIds) +
		'&project_id=' + encodeURIComponent(activeProjectId) +
		'&emailNote=' + encodeURIComponent(inviteEmailNote);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divModalWindow").dialog('close');
		$("#divAjaxLoading").html('Processing Budget Number Requests . . . Please wait');

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: sendBudgetNumberRequestsSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function sendBudgetNumberRequestsSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var messageText = json.messageText;
		messageAlert(messageText, 'successMessage');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showInviteAllBidders(additionalComment)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadInviteAllPotentialBidders';
		var ajaxQueryString =
		'comment=' + encodeURIComponent(additionalComment);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: showInviteAllBiddersSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showInviteAllBiddersSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.9;
		var dialogHeight = windowHeight * 0.98;

		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").html(data);
		$("#divModalWindow").dialog({
			width: dialogWidth,
			height: dialogHeight,
			title: 'Invite All Potential Bidders',
			modal: true,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divModalWindow").dialog('destroy');
				$("#divModalWindow").html('');
				$("#divModalWindow").addClass('hidden');
			},
			buttons: {
				'Invite Checked Bidders': function() {
					sendBidInvitations();
				},
				'Cancel': function() {
					$(this).dialog('close');
				}
			}
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function renderSimpleEmailBiddersModalDialog()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=renderSimpleEmailBiddersModalDialog';
		var ajaxQueryString = '';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: renderSimpleEmailBiddersModalDialogSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function renderSimpleEmailBiddersModalDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.9;
		var dialogHeight = windowHeight * 0.98;

		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").html(data);
		$("#divModalWindow").dialog({
			height: dialogHeight,
			width: dialogWidth,
			title: 'Invite All Potential Bidders',
			modal: true,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				window.location.reload();
				$("body").removeClass('noscroll');
				$("#divModalWindow").dialog('destroy');
				$("#divModalWindow").html('');
				$("#divModalWindow").addClass('hidden');
			},
			buttons: {
				'Invite Checked Bidders': function() {
					sendBidInvitations();
				},
				'Cancel': function() {
					$("#divModalWindow").dialog('close');
				}
			}
		});

		initializeAutoHintFields();
		createUploaders();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//To create a dialog for email bidders
function BiddersModalDialog()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=BiddersModalDialog';
		var ajaxQueryString = '';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: BiddersModalDialogSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function BiddersModalDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.9;
		var dialogHeight = windowHeight * 0.98;

		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").html(data);
		$("#divModalWindow").dialog({
			height: dialogHeight,
			width: dialogWidth,
			title: 'Email Bidders',
			modal: true,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divModalWindow").dialog('destroy');
				$("#divModalWindow").html('');
				$("#divModalWindow").addClass('hidden');
			},
			buttons: {
				'Email Checked Bidders': function() {
					sendemailBidders();
				},
				'Cancel': function() {
					$("#divModalWindow").dialog('close');
				}
			}
		});

		initializeAutoHintFields();
		createUploaders();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//To create a dialog for email project contacts
function EmailProjectContactsModalDialog()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=EmailProjectContactsModalDialog';
		var ajaxQueryString = '';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: EmailProjectContactsModalDialogSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function EmailProjectContactsModalDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.9;
		var dialogHeight = windowHeight * 0.98;

		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").html(data);
		$("#divModalWindow").dialog({
			height: dialogHeight,
			width: dialogWidth,
			title: 'Email Project Contacts',
			modal: true,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divModalWindow").dialog('destroy');
				$("#divModalWindow").html('');
				$("#divModalWindow").addClass('hidden');
			},
			buttons: {
				'Email Checked Contacts': function() {
					sendemailProjectContacts();
				},
				'Cancel': function() {
					$("#divModalWindow").dialog('close');
				}
			}
		});

		initializeAutoHintFields();
		createUploaders();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function sendemailBidders()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var arrSubcontractorBidIds = [];
		$(".inviteCheckBox:checked").each(function() {
			var subcontractor_bid_id = $(this).val();
			arrSubcontractorBidIds.push(subcontractor_bid_id);
		});

		var arrNonProjectContactIds = [];
		$(".checkNonContact:checked").each(function() {
			var nonContact_id = $(this).val();
			arrNonProjectContactIds.push(nonContact_id);
		});

		if (arrSubcontractorBidIds.length == 0 && arrNonProjectContactIds.length == 0) {
			$("#additionalNotes").removeClass('redBorderThick');
			$("#subjectContent").removeClass('redBorderThick');	
			var messageText = 'You have not selected any bidders to invite.';
			messageAlert(messageText, 'infoMessage');
			return;
		}

		if ($("#add_cc").prop('checked') == true) {
			var cc_id = $('#add_cc').val();
		}else{
			var cc_id = '';
		}

		var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');
		var csvNonContactIds = arrNonProjectContactIds.join(',');
		var inviteEmailNote = $("#additionalNotes").val();
		var subjectContent = $("#subjectContent").val();
		var activeProjectId = $("#currentlySelectedProjectId").val();
		var includePlanDownload = $("#includePlanDownload").prop('checked');
		inviteEmailNote=inviteEmailNote.replace(/\n/g, '<br>');

		//attachments
		var attachmentsArr = {};
		var i =0;
		$( "#ulEmailAttachments li" ).each(function( index ) {
			var upfileval = $(this).attr('id');
			attachmentsArr[i] =  parseInt(upfileval) ;
			i++;
		});
		var attachments = JSON.stringify(attachmentsArr);

		var err=false;
		$( "#subjectContent" ).change(function() {
			$("#subjectContent").removeClass('redBorderThick');		
		});

		$( "#additionalNotes" ).keyup(function() {
			$("#additionalNotes").removeClass('redBorderThick');		
		});
		if(subjectContent == '')
		{

			$("#subjectContent").addClass('redBorderThick');
			err =true;
		}else{
			$("#subjectContent").removeClass('redBorderThick');
			err =false;
		}
		if (inviteEmailNote =='Email body . . .')
		{
			$("#additionalNotes").addClass('redBorderThick');
			err =true;
		}else{
			$("#additionalNotes").removeClass('redBorderThick');
			err =false;
		}
		if(err)
		{
			return;
		}else{
			var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=sendEmailBidder';
			var ajaxQueryString =
			'csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds) +
			'&csvNonContactIds=' + encodeURIComponent(csvNonContactIds) +
			'&project_id=' + encodeURIComponent(activeProjectId) +
			'&send_cc=' + encodeURIComponent(cc_id) +
			'&subjectContent=' + encodeURIComponent(subjectContent) +
			'&attachments=' + encodeURIComponent(attachments) +
			'&emailNote=' + encodeURIComponent(inviteEmailNote) +
			'&includePlanDownload=' + encodeURIComponent(includePlanDownload) +
			'&projectContact=' + encodeURIComponent(false);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			$("#divModalWindow").dialog('close');
			$("#divAjaxLoading").html('Processing Email Bidders . . . Please wait');

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: sendemailBiddersSuccess,
				error: errorHandler
			});

			if (promiseChain) {
				return returnedJqXHR;
			}
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function sendemailProjectContacts()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var arrProjectContactIds = [];
		$(".projectContactCheckBox:checked").each(function() {
			var contact_id = $(this).val();
			arrProjectContactIds.push(contact_id);
		});

		var arrNonProjectContactIds = [];
		$(".checkNonContact:checked").each(function() {
			var nonContact_id = $(this).val();
			arrNonProjectContactIds.push(nonContact_id);
		});

		if (arrProjectContactIds.length == 0 && arrNonProjectContactIds.length == 0) {
			$("#projectContactBody").removeClass('redBorderThick');
			$("#projectContactSubject").removeClass('redBorderThick');	
			var messageText = 'You have not selected any contacts to invite.';
			messageAlert(messageText, 'infoMessage');
			return;
		}

		if ($("#add_cc").prop('checked') == true) {
			var cc_id = $('#add_cc').val();
		}else{
			var cc_id = '';
		}

		var csvContactBidIds = arrProjectContactIds.join(',');
		var csvNonContactIds = arrNonProjectContactIds.join(',');
		var inviteEmailNote = $("#projectContactBody").val();
		var subjectContent = $("#projectContactSubject").val();
		var activeProjectId = $("#currentlySelectedProjectId").val();
		var includePlanDownload = $("#planDownloadProjConatact").prop('checked');
		inviteEmailNote=inviteEmailNote.replace(/\n/g, '<br>');

		//attachments
		var attachmentsArr = {};
		var i =0;
		$( "#ulProjContactEmailAttachments li" ).each(function( index ) {
			var upfileval = $(this).attr('id');
			attachmentsArr[i] =  parseInt(upfileval) ;
			i++;
		});
		var attachments = JSON.stringify(attachmentsArr);

		var err=false;
		$( "#projectContactSubject" ).change(function() {
			$("#projectContactSubject").removeClass('redBorderThick');		
		});

		$( "#projectContactBody" ).keyup(function() {
			$("#projectContactBody").removeClass('redBorderThick');		
		});

		if(subjectContent == '') {
			$("#projectContactSubject").addClass('redBorderThick');
			err =true;
		}else{
			$("#projectContactSubject").removeClass('redBorderThick');
			err =false;
		}

		if (inviteEmailNote =='Email body . . .') {
			$("#projectContactBody").addClass('redBorderThick');
			err =true;
		}else{
			$("#projectContactBody").removeClass('redBorderThick');
			err =false;
		}

		if(err)
		{
			return;
		}else{
			var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=sendEmailBidder';
			var ajaxQueryString =
			'csvSubcontractorBidIds=' + encodeURIComponent(csvContactBidIds) +
			'&csvNonContactIds=' + encodeURIComponent(csvNonContactIds) +
			'&project_id=' + encodeURIComponent(activeProjectId) +
			'&send_cc=' + encodeURIComponent(cc_id) +
			'&subjectContent=' + encodeURIComponent(subjectContent) +
			'&attachments=' + encodeURIComponent(attachments) +
			'&emailNote=' + encodeURIComponent(inviteEmailNote) +
			'&includePlanDownload=' + encodeURIComponent(includePlanDownload) +
			'&projectContact=' + encodeURIComponent(true);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			$("#divModalWindow").dialog('close');
			$("#divAjaxLoading").html('Processing Email Contacts . . . Please wait');

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: sendemailProjectContactSuccess,
				error: errorHandler
			});

			if (promiseChain) {
				return returnedJqXHR;
			}
		}
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function sendemailProjectContactSuccess(data, textStatus, jqXHR)
{
	messageText = 'All Email Contacts were successfully sent';
	messageAlert(messageText, 'successMessage');	
}

function sendemailBiddersSuccess(data, textStatus, jqXHR)
{
	messageText = 'All Email Bidders were successfully sent';
	messageAlert(messageText, 'successMessage');
	//To uncheck the checkbox
	$(".gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--subcontractor_bids--subcontractor_contact_id").prop('checked', false);
	$("#gcBudgetLineItemSubcontractorBidManagementModalDialog-subcontractor_bid-record--subcontractor_bids--subcontractor_contact_id--check_all").prop('checked', false);
	
}


function updateBidderEmailList()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var subcontractor_bid_status_id = $("#ddl--subcontractor_bid_status_id").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=updateEmailBiddersList';
		var ajaxQueryString =
		'subcontractor_bid_status_id=' + encodeURIComponent(subcontractor_bid_status_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateBidderEmailListSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateBidderEmailListSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divBidderLog").html(data);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateProjectContactEmailList(data){
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=updateEmailProjectContactList';
		var ajaxQueryString =
		'role_id=' + encodeURIComponent(data);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateProjectContactListSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateProjectContactListSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divProjectContactLog").html(data);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function emailAttachmentUploaded(arrFileManagerFiles, containerElementId)
{
	try {

		$.each(arrFileManagerFiles, function(i, fileManagerFile) {
			var file_manager_file_id = fileManagerFile.file_manager_file_id;
			var virtual_file_name = fileManagerFile.virtual_file_name;
			var fileUrl = fileManagerFile.fileUrl;

			//recordContainerElementId, attributeGroupName, uniqueId
			var aDelete = '<a href="#" onclick="deleteFileManagerFileHelper(this); return false;">X</a>';
			var aLink = '<a href="'+fileUrl+'" target="_blank">'+virtual_file_name+'</a>';
			var li = '<li id="'+file_manager_file_id+'">'+aDelete+'&nbsp;&nbsp;&nbsp;'+aLink+'</li>';
			$("#"+containerElementId).append(li);
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteFileManagerFileHelper(element)
{
	var recordContainer = $(element).parent();
	var uniqueId = recordContainer.prop('id');
	//To delete the bid document
	var ajaxHandlerScript = 'file_manager_files-ajax.php?method=deleteBidforEmail';
	var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
	var ajaxQueryString =
	'uniqueId=' + encodeURIComponent(uniqueId);
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function()
		{
			messageAlert("File Manager File Successfully Deleted", 'successMessage');
			$("#"+uniqueId).remove();
		},
		error: errorHandler
	});

}
/*update the contact details in bidders*/
function updateMobileNetworkCarrierBidders(contact_id, contact_phone_number_id)
{
	var elem = $("#mobilephone_"+contact_id);
	var mobilephoneValue = elem.val();
	if (mobilephoneValue != '') {
		updateContactPhoneNumberBidders(contact_id, contact_phone_number_id, 'mobilephone', '3');
	}
}
function updateContactPhoneNumberBidders(contact_id, contact_phone_number_id, attributeName, phone_number_type_id)
{
	try {

		if (contact_id != 0) {
			window.savePending = true;

			var uniqueId = contact_id;

			var elem = $("#" + attributeName+"_"+contact_id);
			var newValue = elem.val();
			newValue = $.trim(newValue);

			if (phone_number_type_id == 3) {
				var mobile_network_carrier_id = '';	
				/*var mobile_network_carrier_id = $("#mobile_network_carrier_id_"+contact_id).val();*/
				if (mobile_network_carrier_id == '') {
					/*Mobile Carrier has hide*/
					/*alert('Please select a Mobile Network Carrier from the above list');
					$("#mobile_network_carrier_id_"+contact_id).focus();
					return;*/
				}
			} else {
				var mobile_network_carrier_id = '';
			}

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=updateContactField';
			var ajaxQueryString =
			'attributeName=' + encodeURIComponent(attributeName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newValue=' + encodeURIComponent(newValue) +
			'&contact_phone_number_id=' + encodeURIComponent(contact_phone_number_id) +
			'&phone_number_type_id=' + encodeURIComponent(phone_number_type_id) +
			'&mobile_network_carrier_id=' + encodeURIComponent(mobile_network_carrier_id);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: updateFieldSuccess,
				error: errorHandler
			});
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateFieldSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var json = data;

		var attributeName = json.attributeName;
		var customSuccessMessage = json.customSuccessMessage;
		var errorMessage = json.errorMessage;
		var errorNumber = json.errorNumber;
		var newValue = json.newValue;
		var contact_company_id = $("#contact_company_id").val();
		var companyName = $("#companyName").val();
		var selectedContactId = $("#selectedContactId").val();
		var selectedUserId = $("#selectedUserId").val();
		var fullName = $("#first_name").val() + ' ' + $("#last_name").val();

		//messageAlert(customSuccessMessage, 'successMessage', 'successMessageLabel', attributeName);
		if(errorNumber == 0){
			messageAlert(errorMessage, 'successMessage');
		}
		else{
			if(newValue!='' && newValue!='null')
				messageAlert(errorMessage, 'errorMessage');
		}
		if (attributeName == 'companyName') {
			//getCompanyInfoByCompany('divCompanyInfo', contact_company_id, companyName);
			$('#company').val(companyName);
			checkSelection();
		}
		if (attributeName == 'first_name' || attributeName == 'last_name') {
			getEmployeesByCompany('divEmployees', contact_company_id, companyName);
			//loadContactPermissions(contact_company_id, selectedContactId);
			$("#contactInfoHeaderContactName").html(fullName);
			$("#contactRolesHeaderContactName").html(fullName);
			$("#contactProjectAccessHeaderContactName").html(fullName);
		}
		if (attributeName == 'mobilephone') {
			showContactInfo(selectedContactId, selectedUserId);
		}
		if (attributeName == 'email') {
			getEmployeesByCompany('divEmployees', contact_company_id, companyName);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//To add a new contact through bidder modal
function Addcontact()
{
	var modal = document.getElementById('ContactUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "GET",
		url	  :  window.ajaxUrlPrefix+"modules-purchasing-ajax.php",
		data  : {method:'AddContactInBidder'},
		async : true,
		success:function(res)
		{	
			$('#ContactUser').empty().html(res);
			modal.style.display = "block";

		}
	});
	
}
function OpenContactForm()
{
	var company_id=$('#ddlContactCompanies').val();
	$('#contact_company_id').val(company_id);
	$('#ddlContactCompanies').change(function(){
		$('#ddlContactCompanies').removeClass('redBorderThick');

	});
	if(company_id!='0' )
	{
		$('#ddlContactCompanies').removeClass('redBorderThick');
		rendorCreateContactForm(company_id);
	}else{
		$('#ddlContactCompanies').addClass('redBorderThick');
	}
	
	
}
// When the user clicks on <span> (x), close the modal
function modalClose() {
	var modal = document.getElementById('ContactUser');
	modal.style.display = "none";
}
function rendorCreateContactForm(contact_company_id)
{
	try {

		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=rendorCreateContactForm';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divContactPermissions").hide();
		$("#divContactPermissions").html('');

		$("#divContactInformation").load(ajaxUrl);
		$("#divContactInformation").show();

		

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
//To create a new contact
function Contacts_Manager__createContact(attributeGroupName, uniqueId, options)
{
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Contacts_Manager__createContactSuccess;

		ajaxQueryString = '';
		// mobile_network_carrier_id
		var mobile_network_carrier_id_element_id = 'ddl--' + attributeGroupName + '--mobile_network_carriers--mobile_network_carrier_id--' + uniqueId;
		if ($("#" + mobile_network_carrier_id_element_id).length) {
			var mobile_network_carrier_id = $("#" + mobile_network_carrier_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&mobile_network_carrier_id=' + encodeURIComponent(mobile_network_carrier_id);
		}
		options.adHocQueryParameters = ajaxQueryString;
		createContact(attributeGroupName, uniqueId, options);
		
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function Contacts_Manager__createContactSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;
		if (errorNumber == 0) {
			$("#divContactInformation").hide();
			$("#divContactInformation").html('');
			modalClose();
			postContactCreation();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
//To create a new company dialog

function loadCreateContactCompanyDialog()
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=loadCreateContactCompanyDialog';
		var ajaxQueryString = '';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadCreateContactCompanyDialogSuccess,
			error: errorHandler
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function loadCreateContactCompanyDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divCreateContactCompanyDialog").html(data);
		$("#divCreateContactCompanyDialog").removeClass('hidden');
		$("#divCreateContactCompanyDialog").dialog({
			title: 'Create New Company',
			modal: true,
			height: 450,
			width: 600,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divCreateContactCompanyDialog").addClass('hidden');
				$("#divCreateContactCompanyDialog").html('');
				$("#divCreateContactCompanyDialog").dialog('destroy');
			}
		});
		$(".datepicker").click(function(){
			$('#ui-datepicker-div').css('display','block');
			$('#ui-datepicker-div').css('z-index','999');});
		$(".phoneExtension").mask('?(999) 999-9999 ext.9999');
		
		var dummyId = $("#divCreateContactCompanyDialogDummyId").val();
		$('#create-contact_company-record--contact_companies--construction_license_number_expiration_date--'+dummyId).datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
		$("#create-contact_company-record--contact_companies--company--" + dummyId).autocomplete({
			source: arrCompanies,
			select: function(event, ui) {
				$("#divCreateContactCompanyDialog").dialog('close');
				companySelected(event, ui);
			},
			position: {
				of: $("#divSimilarCompanyNamesContainer")
			}
		});

		ajaxModulesLoaded(data, textStatus, jqXHR);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
//Ajax function
function ajaxModulesLoaded(data, textStatus, XMLHttpRequest)
{
	//$(".listTable tr:odd").addClass('oddRow');
	//$(".listTable tr:even").addClass('evenRow');
	initializeAutoHintFields();
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
	$(".phoneNumber").mask('?(999) 999-9999');
	$(".phoneExtension").mask('?(999) 999-9999 ext.9999');
	//$(".phoneNumber").mask('99/99/9999', {placeholder:' '});
	$("#" + setFocusToElement).focus();

	if ($("#phoneAutocompleteOptions").length) {
		$(function() {
			var autoCompleteList = $("#phoneAutocompleteOptions").val();
			var arrAutoCompleteList = jQuery.parseJSON(autoCompleteList);
			$("#phone").autocomplete({
				source: arrAutoCompleteList
			});

			autoCompleteList = $("#faxAutocompleteOptions").val();
			arrAutoCompleteList = jQuery.parseJSON(autoCompleteList);
			$("#fax").autocomplete({
				source: arrAutoCompleteList
			});
		});

		$("#phone").keyup(function(e) {
			var keyCode = (e.keyCode) ? e.keyCode : e.which;
			if (keyCode == 40 || keyCode == 38) {
				//alert('here');
			} else {
				var currentValue = $("#phone").val();
				currentValue = currentValue.replace(/\D/g, '');
				$("#phone").autocomplete('search', currentValue);
			}
		});

		$("#fax").keyup(function(e) {
			var keyCode = (e.keyCode) ? e.keyCode : e.which;
			if (keyCode == 40 || keyCode == 38) {
				//alert('here');
			} else {
				var currentValue = $("#fax").val();
				currentValue = currentValue.replace(/\D/g, '');
				$("#fax").autocomplete('search', currentValue);
			}
		});
	}

}
//To create a new company
function createContactCompanyAndReloadDdlContactCompaniesViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		showSpinner();
		var contact_company_id = 0;
		var promise1 = createContactCompany(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function(json) {

			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var uniqueId = json.uniqueId;
				contact_company_id = uniqueId;
				hideSpinner();
				setTimeout(function(){
					$("#divCreateContactCompanyDialog").dialog('destroy');	
				},1000);

				
			}

		});
		promise2.then(function() {
			$("#divCreateContactCompanyDialog").dialog('close');
			$("#ddlContactCompanies").val(contact_company_id);
			

			// ddlContactCompanyChanged();
		});
		promise2.always(function() {
			hideSpinner();
		});
		promise2.fail(function() {
			// window.location.reload();
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function cancelNewContact()
{
	modalClose();
}

function load_bids(subcontractor_bid_id){

	document.getElementById("bidddernotes_"+subcontractor_bid_id).classList.toggle("show_cont");
		// Close the dropdown if the user clicks outside of it
		window.onclick = function(event) {
			if (!event.target.matches('.dropbtn'+subcontractor_bid_id)) {

				var dropdowns = document.getElementsByClassName("dropdown-content");
				var i;
				for (i = 0; i < dropdowns.length; i++) {
					var openDropdown = dropdowns[i];
					if (openDropdown.classList.contains('show_cont')) {
						openDropdown.classList.remove('show_cont');
					}
				}
				
			}
		}
	}

// Funciton to add non contact email for the project.
function addNonContactEmail(){
	try {
		var email = $('#nonContactEmail').val();
		if (email == '') {
			var messageText = 'Email is required';
			messageAlert(messageText, 'errorMessage');
		}else{
			var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=addNonContactEmail';
			var ajaxQueryString ='email=' + encodeURIComponent(email);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: nonContactSuccess,
				error: errorHandler
			});
		}
	}catch{
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function nonContactSuccess(data, textStatus, jqXHR){
	try {
		var errorMessage = data.errorMessage;
		var errorNumber = data.errorNumber;
		if(errorNumber == 0){
			messageAlert(errorMessage, 'successMessage');
			$('#nonContactEmail').val('');
			loadNonCotactList();
		}
		else{			
			messageAlert(errorMessage, 'errorMessage');
		}
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

// Funciton to load non contact.
function loadNonCotactList(){
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadNonCotactList';
		var ajaxUrl = ajaxHandler;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			success: loadNonCotactListSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function loadNonCotactListSuccess(data, textStatus, jqXHR)
{
	try {
		$("#divProjectNonContactLog").html(data);
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}
