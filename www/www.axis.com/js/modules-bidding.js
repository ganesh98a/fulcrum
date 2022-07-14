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

if (!jQuery) {
	alert('JQuery is either not loaded or unavailable.');
}

var active_subcontractor_bid_status = null;

var SUBCONTRACTOR_BID_DOCUMENT_TYPE_ID 		= 1;
var SIGNED_SCOPE_OF_WORK_DOCUMENT_TYPE_ID	= 2;
var UNSIGNED_SCOPE_OF_WORK_DOCUMENT_TYPE_ID	= 3;
var BID_INVITATION_DOCUMENT_TYPE_ID			= 4;
var SUBMITTAL_DOCUMENT_TYPE_ID				= 5;

// Document.ready
(function($) {
	$(document).ready(function() {

		addWidgets();

		$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });

		// added for prevent dropdown from collapse when click
		$('ul.dropdown-menu-cancel-collapse li label input').click(function(event) {
			uploadFileDropdownUpcheckState($(this));
			event.stopPropagation();

		});
		// howard

		$('ul.dropdown-menu-cancel-collapse li').click(function(event) {
			event.stopPropagation();
		});

	});
})(jQuery);

function addWidgets(options)
{
	var options = options || {};
	var animationCallback = options.animationCallback;

	if (!$("#showStaticUploaders").val()) {

		/**
		 * To use the new uploaders, you have to do 3 things.
		 *   1) Look at the rest of this if-block and comment/uncomment where specified.
		 *   2) Change the style/script includes from the old fileuploader.css/fileuploader.js to the new.
		 *   3) Change these function calls:
		 *        toggleDynamicUploadersAtCostCodeLevel() to toggleDynamicUploadersAtCostCodeLevel1()
		 *        toggleDynamicUploadersAtBidLevel() to toggleDynamicUploadersAtBidLevel1()
		 *        toggleAllDynamicUploaders() to toggleAllDynamicUploaders1()
		 */

		// Initialize file uploaders for the project_bid_invitation.
		// Comment out these lines to use the new uploaders.
		$(".button-static-uploader:not(.no-override)").addClass('hidden');
		$(".boxViewUploader").removeClass('hidden');
		createUploaders();
		if ($(".boxViewUploader").parent().find('.dropdown-placeholder').length == 0) {
			$('.boxViewUploader .qq-upload-button, .boxViewUploader .qq-upload-drop-area').addClass('has-right-sibling');
		}

		// Initialize fineUploader file uploader for the project_bid_invitation.
		// Uncomment the rest of this if-block to use the new uploaders.
//		var project_bid_invitation_file_manager_folder_id = $("#project_bid_invitation_file_manager_folder_id").val();
//		var endpoint = '/modules-purchasing-file-uploader-ajax.php?folder_id=' + project_bid_invitation_file_manager_folder_id;
//		var uploaderElement, dropdownElement, dropdownElementHtml;
//		var uploaderOptions = {
//			request: {
//				endpoint: endpoint
//			},
//			callbacks: {
//				onSubmit: function(id, name) {
//					// 'this' is a reference to a qq.FineUploader object.
//					uploaderElement = this._options.element;
//					dropdownElement = $(uploaderElement).siblings('.dropdown');
//					dropdownElementHtml = dropdownElement.html();
//					dropdownElement.html('<img src="/images/ajax-loader.gif">');
//				},
//				onError: function(id, name, errorReason, xhr) {
//					dropdownElement.html(dropdownElementHtml);
//					fileManagerFileUploadError(id, name, errorReason, xhr);
//				},
//				onComplete: function(id, name, responseJSON, xhr) {
//					if (!responseJSON.success) {
//						return;
//					}
//					var options = {
//						element: uploaderElement,
//						projectBidInvitationDropdownContainerElement: dropdownElement
//					};
//					var arrFileManagerFiles = responseJSON.fileMetadata;
//					projectBidInvitationUploaded(arrFileManagerFiles, options);
//				}
//			},
//			validation: {
//				allowedExtensions: [ 'pdf' ]
//			},
//			customLabel: 'Drop/Click'
//		};
//		$(".bidInvitationUploader").fineUploader(uploaderOptions);
//		$('.project-level-uploaders .button-static-uploader').addClass('hidden');
//		if ($('.project-level-uploaders .dropdown-placeholder').length == 0) {
//			$(".bidInvitationUploader").find('.qq-upload-button, .qq-upload-drop-area').addClass('has-right-sibling');
//		}
	}

	// Add accordion widgets. They have a lot of custom functionality on this page.
	var accordionOptions = {
		collapsible: true,
		heightStyle: 'content',
		event: false,
		beforeActivate: function(event, ui) {
			// This function allows multiple accordions to be open at once.
			if (ui.newHeader[0]) {
				// The accordion believes a panel is being opened.
				var accordionHeaderElement = ui.newHeader;
				var accordionContentElement = accordionHeaderElement.next('.ui-accordion-content');
			} else {
				// The accordion believes a panel is being closed.
				var accordionHeaderElement = ui.oldHeader;
				var accordionContentElement = accordionHeaderElement.next('.ui-accordion-content');
			}

			toggleIndividualAccordion(accordionHeaderElement, accordionContentElement);

			return false; // Cancels the default action.
		}
	};
	$('.accordion-container, .subaccordion-container').accordion(accordionOptions);

	// We need to have custom click event handlers because of the
	// widgets/buttons/links that are inside the accordions' header element.
	$(".accordion-container").on('click', accordionCustomClickHandler);
	$(".subaccordion-container").on('click', subaccordionCustomClickHandler);


	$(".accordion-header").contextMenu({
	    menuSelector: '#accordionContextMenu',
	    menuSelected: contextMenuItemSelected
	});
	$(".subaccordion-header").contextMenu({
	    menuSelector: '#subaccordionContextMenu',
	    menuSelected: contextMenuItemSelected
	});

	$(".accordion-container").accordion('option', 'active', false);
	$(".subaccordion-container").accordion('option', 'active', false);

	// Fade in the page content.
	$("#divBidding").animate({ opacity: 1 }, 'slow', 'easeInExpo', animationCallback);

	// Only show the bid level upload toggle buttons when their accordion is open.
	$(".toggle-bid-level-uploaders").on('subaccordionOpened', function() {
		$(this).parent().css('visibility', '');
		$(this).parent().animate({ opacity: 1 });
	});
	$(".toggle-bid-level-uploaders").on('subaccordionClosed', function() {
		$(this).parent().animate({ opacity: 0 }, function() {
			$(this).css('visibility', 'hidden');
		});
	});

}

function contextMenuItemSelected(invokedOn, selectedMenu)
{
	var accordionElement = invokedOn;
	if (!accordionElement.hasClass('accordion-header subaccordion-header')) {
		accordionElement = accordionElement.closest('.accordion-header, .subaccordion-header');
	}
	var collapse = accordionElement.hasClass('ui-state-active');
	switch (selectedMenu.text()) {
    	case 'Expand/Collapse outer':
			expandOuterAccordions();
    		break;
    	case 'Expand/Collapse this group':
    		var arrAccordionElements = accordionElement.closest('.accordion-content').find('.subaccordion-header');
			expandAccordionGroup(arrAccordionElements, collapse);
    		break;
    	case 'Expand/Collapse all':
			expandAllAccordions();
    		break;
    	case 'Select all bidders by this status':
    		var checked = $(accordionElement).next().find('.bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id:first').is(':checked') || false;
    		$(accordionElement).next().find('.bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id').prop('checked', !checked);
    		break;
    	case 'Select all bidders':
    		var checked = $(".bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id:first").is(':checked') || false;
    		$(".bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id").prop('checked', !checked);
    		break;
	}
}

function expandAllAccordions()
{
	var collapse = $(".accordion-header:first").hasClass('ui-state-active');
	var arrAccordionElements = $('.accordion-header, .subaccordion-header');
	expandAccordionGroup(arrAccordionElements, collapse);
}

function expandOuterAccordions()
{
	var collapse = $(".accordion-header:first").hasClass('ui-state-active');
	var arrAccordionElements = $(".accordion-header");
	expandAccordionGroup(arrAccordionElements, collapse);
}

function expandInnerAccordions(element, javaScriptEvent)
{
	var accordionContainer = $(element).closest('.accordion-header');
	expandAccordionGroup(accordionContainer, false);

	trapJavaScriptEvent(javaScriptEvent);

	var arrAccordionElements = accordionContainer.next().find('.subaccordion-header');
	var collapse = $(arrAccordionElements[0]).hasClass('ui-state-active');
	expandAccordionGroup(arrAccordionElements, collapse);
}

function expandAccordionGroup(arrAccordionElements, collapse)
{
	arrAccordionElements.each(function() {
		if ($(this).hasClass('ui-state-active')) {
			if (collapse) {
				// If the accordion is open and we want to close it, click.
				$(this).click();
			}
		} else {
			if (!collapse) {
				// If the accordion is closed and we want to open it, click.
				$(this).click();
			}
		}
	});
}

function selectAllSubcontractorBidsInBidGroup(element, javaScriptEvent)
{
	trapJavaScriptEvent(javaScriptEvent);
	var checked = $(element).is(':checked');
	$(element).closest('table').find('input[type=checkbox]').prop('checked', checked);
}

/**
 * The Bid Actions dropdowns have a checkbox in the header element, so not every click
 * in the header element should trigger the dropdown.
 */
function toggleBidActionsDropdown(element, javaScriptEvent)
{
	// If the Select All checkbox was clicked, ignore.
	if ($(javaScriptEvent.target).hasClass('select-all')) {
		return;
	}

	// If the dropdown is open, hide it and remove the hideDropdown click listener, then return.
	if ($(element).parent().hasClass('dropdown open')) {
		$(element).parent().removeClass('dropdown open');
		$(document).off('click', hideDropdown);
		return;
	} else {
		// Otherwise, show the dropdown.
		$(element).parent().addClass('dropdown open');
	}

	// Have the next click (anywhere on the page) hide the dropdown.
	$(document).on('click', hideDropdown);
	var first = true;
	function hideDropdown() {
		// Ignore the first click because that's the click that
		// called toggleDropdown() in the first place.
		if (first) {
			first = false;
		} else {
			$(element).parent().removeClass('dropdown open');
			$(document).off('click', hideDropdown);
		}
	}

}

/**
 * Not every click event in the accordion header element should trigger
 * the accordion because of all the widget child elements.
 */
function accordionCustomClickHandler(javaScriptEvent)
{
	// The below line definitely causes breakage.
	// Cost code level file ddl's break
	//trapJavaScriptEvent(javaScriptEvent);

	var element = javaScriptEvent.target;

	if (shouldIgnoreThisElement(element)) {
		return;
	}

	var accordionHeaderElement = $(element).closest('.accordion-header');
	var accordionContentElement = accordionHeaderElement.next();
	toggleIndividualAccordion(accordionHeaderElement, accordionContentElement);

	var collapseOtherAccordions = $(accordionHeaderElement).hasClass('ui-state-active');
	var checked = $("#checkboxOneOpenCostCodeSection").is(':checked');
	if (collapseOtherAccordions && checked) {

		$(".accordion-header").each(function() {
			if (this == accordionHeaderElement[0]) {
				return;
			}
			if ($(this).hasClass('ui-state-active')) {
				toggleIndividualAccordion($(this), $(this).next());
			}
		});

	}
}

/**
 * Not every click event in the subaccordion header element should trigger
 * the accordion because of all the widget child elements.
 */
function subaccordionCustomClickHandler(javaScriptEvent)
{
	// The below line definitely causes breakage.
	// Cost code level file ddl's break
	//trapJavaScriptEvent(javaScriptEvent);

	var element = javaScriptEvent.target;

	// Ignore the event if the uploader widget or dropdown was clicked.
	if (shouldIgnoreThisElement(element)) {
		return;
	}

	var accordionHeaderElement = $(element).closest('.subaccordion-header');
	var accordionContentElement = accordionHeaderElement.next();
	toggleIndividualAccordion(accordionHeaderElement, accordionContentElement);

	var accordionIsOpen = $(accordionHeaderElement).hasClass('ui-state-active');
	var checked = $("#checkboxOneOpenBidSection").is(':checked');
	if (accordionIsOpen && checked) {

		$(".subaccordion-header").each(function() {
			if (this == accordionHeaderElement[0]) {
				return;
			}
			if ($(this).hasClass('ui-state-active')) {
				toggleIndividualAccordion($(this), $(this).next());
			}
		});

	}

	var toggleBidLevelUploaderButton = accordionHeaderElement.find('.toggle-bid-level-uploaders');
	if (accordionIsOpen) {
		toggleBidLevelUploaderButton.trigger('subaccordionOpened');
	} else {
		toggleBidLevelUploaderButton.trigger('subaccordionClosed');
	}

}

/*
 * Helper function for accordionCustomClickHandler() and subaccordionCustomClickHandler().
 */
function shouldIgnoreThisElement(element)
{
	var arrClassesToIgnore = [ 'qq-upload-button', 'dropdown', 'dropdown-toggle',
							   'dropdown-menu', 'button-static-uploader', 'qq-upload-button',
							   'qq-upload-drop-area', 'accordion-link' ];

	try {

		var currentElementClassList = $(element).attr('class');
		if (currentElementClassList) {
			var arrCurrentElementClasses = currentElementClassList.split(/\s+/);
		} else {
			var arrCurrentElementClasses = [];
		}

		var previousElementClassList = $(element.prevObject).attr('class');
		if (previousElementClassList) {
			var arrPreviousElementClasses = previousElementClassList.split(/\s+/);
		} else {
			var arrPreviousElementClasses = [];
		}

		var parentElementClassList = $(element).parent().attr('class');
		if (parentElementClassList) {
			var arrParentElementClasses = parentElementClassList.split(/\s+/);
		} else {
			var arrParentElementClasses = [];
		}

		var arrCssClasses = arrCurrentElementClasses.concat(arrPreviousElementClasses);
		arrCssClasses = arrCssClasses.concat(arrParentElementClasses);

		for (var i = 0; i < arrCssClasses.length; i++) {
			var cssClass = arrCssClasses[i];
			if (arrClassesToIgnore.indexOf(cssClass) > -1) {
				return true;
			}
		}

	} catch (error) {

	}

	return false;
}

function toggleIndividualAccordion(accordionHeaderElement, accordionContentElement)
{
	var isPanelSelected = accordionHeaderElement.attr('aria-selected') == 'true';
	// Toggle the panel's header
	accordionHeaderElement.toggleClass('ui-corner-all', isPanelSelected).toggleClass('accordion-header-active ui-state-active ui-corner-top', !isPanelSelected).attr('aria-selected', ((!isPanelSelected).toString()));
	// Toggle the panel's icon
	accordionHeaderElement.children('.ui-icon').toggleClass('ui-icon-triangle-1-e', isPanelSelected).toggleClass('ui-icon-triangle-1-s', !isPanelSelected);
	// Toggle the panel's content
	accordionContentElement.toggleClass('accordion-content-active', !isPanelSelected);
	if (isPanelSelected) {
		accordionContentElement.slideUp();
		accordionContentElement.fadeOut(100);
	} else {
		accordionContentElement.slideDown();
		accordionContentElement.fadeIn(100);
	}
}

function gcBudgetLineItemUnsignedScopeOfWorkDocumentSelected(element, options)
{
	try {

		var options = options || {};

		var file = element.files[0];

		//var subcontractor_bid_status_id = options.subcontractor_bid_status_id;
		var subcontractor_bid_status_group_id = options.subcontractor_bid_status_group_id;
		var gc_budget_line_item_id = options.gc_budget_line_item_id;

		var uploaderElement = $(element).prev()[0];
		var urlString = generateUrlStringFromAttributesOfElement(uploaderElement);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-file-uploader-ajax.php?dummyGetKey=uploadFiles';
		var ajaxQueryString =
			'subcontractor_bid_status_group_id=' + encodeURIComponent(subcontractor_bid_status_group_id) +
			'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&' + urlString;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var gcBudgetLineItemUnsignedScopeOfWorkDocumentDropdownContainerElement = $(element).parent().find('.dropdown');
		gcBudgetLineItemUnsignedScopeOfWorkDocumentDropdownContainerElement.html('<img src="/images/ajax-loader.gif">');

		options.element = element;
		options.gcBudgetLineItemUnsignedScopeOfWorkDocumentDropdownContainerElement = gcBudgetLineItemUnsignedScopeOfWorkDocumentDropdownContainerElement;

		uploadFile(file, ajaxUrl, gcBudgetLineItemUnsignedScopeOfWorkDocumentUploaded, options);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function gcBudgetLineItemUnsignedScopeOfWorkDocumentUploaded(arrFileManagerFiles, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.htmlRecordType = 'dropdown';
		options.promiseChain = true;
		options.responseDataType = 'json';

		//var subcontractor_bid_status_id = options.subcontractor_bid_status_id;
		var subcontractor_bid_status_group_id = options.subcontractor_bid_status_group_id;
		var gc_budget_line_item_id = options.gc_budget_line_item_id;
		var element = options.element;
		var gcBudgetLineItemUnsignedScopeOfWorkDocumentDropdownContainerElement = options.gcBudgetLineItemUnsignedScopeOfWorkDocumentDropdownContainerElement;

		var staticUploadButton = $(element).parent().find('.button-static-uploader');
		var dynamicUploadButton = $(element).parent().find('.qq-upload-button, qq-upload-drop-area');

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var fileUrl                = fileManagerFile.fileUrl;

			var attributeGroupName = 'create-gc_budget_line_item_unsigned_scope_of_work_document-record';
			var uniqueId = generateDummyElementId();

			var hiddenElements =
			' \
			<div class="hidden"> \
				<input type="hidden" id="'+attributeGroupName+'--gc_budget_line_item_unsigned_scope_of_work_documents--unsigned_scope_of_work_document_file_manager_file_id--'+uniqueId+'" value="'+file_manager_file_id+'"> \
				<input type="hidden" id="'+attributeGroupName+'--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_id--'+uniqueId+'" value="'+gc_budget_line_item_id+'"> \
			</div> \
			';

			gcBudgetLineItemUnsignedScopeOfWorkDocumentDropdownContainerElement.append(hiddenElements);

			var promise = createGcBudgetLineItemUnsignedScopeOfWorkDocument(attributeGroupName, uniqueId, options);
			promise.then(function(json) {

				/*
				// THIS IS OLD CODE AND IS NOT NEEDED AS THE FILE LIST AUTO REFRESHES BELOW
				var previousAttributeGroupName = json.previousAttributeGroupName;
				var attributeSubgroupName = json.attributeSubgroupName;
				var dummyId = json.dummyId;
				var recordContainerElementIdOld = 'record_container--' + previousAttributeGroupName + '--' + attributeSubgroupName + '--' + dummyId;

				// @todo Implement DOM swap out code for id and onchange...
				$("#" + recordContainerElementIdOld).remove();
				*/

				var htmlRecord = json.htmlRecord;
				gcBudgetLineItemUnsignedScopeOfWorkDocumentDropdownContainerElement.html(htmlRecord);
				staticUploadButton.addClass('has-right-sibling');
				dynamicUploadButton.addClass('has-right-sibling');

			});
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function gcBudgetLineItemBidInvitationSelected(element, options)
{
	try {

		var options = options || {};

		var file = element.files[0];

		//var subcontractor_bid_status_id = options.subcontractor_bid_status_id;
		var subcontractor_bid_status_group_id = options.subcontractor_bid_status_group_id;
		var gc_budget_line_item_id = options.gc_budget_line_item_id;

		var uploaderElement = $(element).prev()[0];
		var urlString = generateUrlStringFromAttributesOfElement(uploaderElement);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-file-uploader-ajax.php?dummyGetKey=uploadFiles';
		var ajaxQueryString =
			'subcontractor_bid_status_group_id=' + encodeURIComponent(subcontractor_bid_status_group_id) +
			'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&' + urlString;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var gcBudgetLineItemBidInvitationDropdownContainerElement = $(element).parent().find('.dropdown');
		gcBudgetLineItemBidInvitationDropdownContainerElement.html('<img src="/images/ajax-loader.gif">');

		options.element = element;
		options.gcBudgetLineItemBidInvitationDropdownContainerElement = gcBudgetLineItemBidInvitationDropdownContainerElement;

		uploadFile(file, ajaxUrl, gcBudgetLineItemBidInvitationUploaded, options);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function gcBudgetLineItemBidInvitationUploaded(arrFileManagerFiles, options)
{
	try {

		var options = options || {};
		options.promiseChain = true;
		options.htmlRecordType = 'dropdown';

		//var subcontractor_bid_status_id = options.subcontractor_bid_status_id;
		var subcontractor_bid_status_group_id = options.subcontractor_bid_status_group_id;
		var gc_budget_line_item_id = options.gc_budget_line_item_id;
		var element = options.element;
		var gcBudgetLineItemBidInvitationDropdownContainerElement = options.gcBudgetLineItemBidInvitationDropdownContainerElement;

		var staticUploadButton = $(element).parent().find('.button-static-uploader');
		var dynamicUploadButton = $(element).parent().find('.qq-upload-button, qq-upload-drop-area');


		// Ajax load the files list for a reliable list:
		// Hard code list of file containers for now
		// Currently missing submittals
		// @todo Transition to below schema
		// bidding-module-files-container--subcontractor_bid_documents--<subcontractor_bid_document_type_id>_<subcontractor_bid_id>

		var subcontractorBidDocuments_SubcontractorBids_FileUploaderElementId = 'subcontractor_bid_document_subcontractor_bid--' + subcontractor_bid_id;
		var subcontractorBidDocuments_SignedScopesOfWork_FileUploaderElementId = 'subcontractor_bid_document_signed_scope_of_work--' + subcontractor_bid_id;
		var subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderElementId = 'subcontractor_bid_document_unsigned_scope_of_work--' + subcontractor_bid_id;
		var subcontractorBidDocuments_BidInvitations_FileUploaderElementId = 'subcontractor_bid_document_bid_invitation--' + subcontractor_bid_id;

		var arrSubcontractorBidDocumentFilesContainerElementIds = [subcontractorBidDocuments_SubcontractorBids_FileUploaderElementId, subcontractorBidDocuments_SignedScopesOfWork_FileUploaderElementId, subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderElementId, subcontractorBidDocuments_BidInvitations_FileUploaderElementId];

		// @todo Finish / refactor this perhaps to work with the below code that is now commented out
		loadSubcontractorBidDocumentFilesAsUrlListBiddingVersion(subcontractor_bid_id, subcontractor_bid_document_type_id, arrSubcontractorBidDocumentFilesContainerElementIds);


		/*
		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var fileUrl                = fileManagerFile.fileUrl;

			var attributeGroupName = 'create-gc_budget_line_item_bid_invitation-record';
			var uniqueId = generateDummyElementId();

			var hiddenElements =
			' \
			<div class="hidden"> \
				<input type="hidden" id="'+attributeGroupName+'--gc_budget_line_item_bid_invitations--gc_budget_line_item_bid_invitation_file_manager_file_id--'+uniqueId+'" value="'+file_manager_file_id+'"> \
				<input type="hidden" id="'+attributeGroupName+'--gc_budget_line_item_bid_invitations--gc_budget_line_item_id--'+uniqueId+'" value="'+gc_budget_line_item_id+'"> \
			</div> \
			';

			gcBudgetLineItemBidInvitationDropdownContainerElement.append(hiddenElements);

			var promise = Bidding__createGcBudgetLineItemBidInvitation(attributeGroupName, uniqueId, options);
			promise.then(function(json) {
				var htmlRecord = json.htmlRecord;
				gcBudgetLineItemBidInvitationDropdownContainerElement.html(htmlRecord);
				staticUploadButton.addClass('has-right-sibling');
				dynamicUploadButton.addClass('has-right-sibling');
			});
		}
		*/

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function subcontractorBidDocumentSelected(element, options)
{
	try {

		var options = options || {};

		var file = element.files[0];

		var subcontractor_bid_id = options.subcontractor_bid_id;
		var subcontractor_bid_document_type_id = options.subcontractor_bid_document_type_id;

		var uploaderElement = $(element).prev()[0];
		var urlString = generateUrlStringFromAttributesOfElement(uploaderElement);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-file-uploader-ajax.php?dummyGetKey=uploadFiles';
		var ajaxQueryString =
			'subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id) +
			'&subcontractor_bid_document_type_id=' + encodeURIComponent(subcontractor_bid_document_type_id) +
			'&' + urlString;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var subcontractorBidDocumentDropdownContainerElement = $(element).closest('td').find('.dropdown');
		subcontractorBidDocumentDropdownContainerElement.html('<img src="/images/ajax-loader.gif">');

		options.element = element;
		options.subcontractorBidDocumentDropdownContainerElement = subcontractorBidDocumentDropdownContainerElement;

		uploadFile(file, ajaxUrl, subcontractorBidDocumentUploaded, options);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

// @todo Finish this for Bidding Module
function subcontractorBidDocumentUploaded(arrFileManagerFiles, options)
{
	try {

		var options = options || {};
		var sourceElementId = options.element.id;
		options.promiseChain = true;
		options.htmlRecordType = 'dropdown';

		var subcontractor_bid_id = options.subcontractor_bid_id;
		var subcontractor_bid_document_type_id = options.subcontractor_bid_document_type_id;
		var element = options.element;
		var subcontractorBidDocumentDropdownContainerElement = options.subcontractorBidDocumentDropdownContainerElement;

		// Ajax load the files list for a reliable list:
		// Hard code list of file containers for now
		// Currently missing submittals
		// @todo Transition to below schema
		// bidding-module-files-container--subcontractor_bid_documents--<subcontractor_bid_document_type_id>_<subcontractor_bid_id>

		var subcontractorBidDocuments_SubcontractorBids_FileUploaderElementId = 'subcontractor_bid_document_subcontractor_bid--' + subcontractor_bid_id;
		var subcontractorBidDocuments_SignedScopesOfWork_FileUploaderElementId = 'subcontractor_bid_document_signed_scope_of_work--' + subcontractor_bid_id;
		var subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderElementId = 'subcontractor_bid_document_unsigned_scope_of_work--' + subcontractor_bid_id;
		var subcontractorBidDocuments_BidInvitations_FileUploaderElementId = 'subcontractor_bid_document_bid_invitation--' + subcontractor_bid_id;

		var arrSubcontractorBidDocumentFilesContainerElementIds = [subcontractorBidDocuments_SubcontractorBids_FileUploaderElementId, subcontractorBidDocuments_SignedScopesOfWork_FileUploaderElementId, subcontractorBidDocuments_UnsignedScopesOfWork_FileUploaderElementId, subcontractorBidDocuments_BidInvitations_FileUploaderElementId];

		// @todo Finish / refactor this perhaps to work with the below code that is now commented out
		loadSubcontractorBidDocumentFilesAsUrlListBiddingVersion(sourceElementId, subcontractor_bid_id, subcontractor_bid_document_type_id, arrSubcontractorBidDocumentFilesContainerElementIds);


		/*
		var staticUploadButton = $(element).parent().find('.button-static-uploader');
		var dynamicUploadButton = $(element).parent().find('.qq-upload-button, qq-upload-drop-area');

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var fileUrl                = fileManagerFile.fileUrl;

			var attributeGroupName = 'create-subcontractor_bid_document-record';
			var uniqueId = generateDummyElementId();

			var hiddenElements =
			' \
			<div class="hidden"> \
				<input type="hidden" id="'+attributeGroupName+'--subcontractor_bid_documents--subcontractor_bid_id--'+uniqueId+'" value="'+subcontractor_bid_id+'"> \
				<input type="hidden" id="'+attributeGroupName+'--subcontractor_bid_documents--subcontractor_bid_document_type_id--'+uniqueId+'" value="'+subcontractor_bid_document_type_id+'"> \
				<input type="hidden" id="'+attributeGroupName+'--subcontractor_bid_documents--subcontractor_bid_document_file_manager_file_id--'+uniqueId+'" value="'+file_manager_file_id+'"> \
			</div> \
			';

			subcontractorBidDocumentDropdownContainerElement.append(hiddenElements);

			var options = { promiseChain: true, responseDataType: 'json' };
			var promise = createSubcontractorBidDocument(attributeGroupName, uniqueId, options);
			promise.then(function(json) {
				var htmlRecord = json.htmlRecord;
				subcontractorBidDocumentDropdownContainerElement.html(htmlRecord);
				staticUploadButton.addClass('has-right-sibling');
				dynamicUploadButton.addClass('has-right-sibling');
			});
		}
		*/

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//function loadProjectBidInvitationFilesAsUrlListBiddingVersion(currentlySelectedProjectId, arrContainerElementIds)
//function loadProjectBidInvitationFilesAsUrlListBiddingVersion(options)
function loadProjectBidInvitationFilesAsUrlListBiddingVersion(project_id, containerElementId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadProjectBidInvitationFilesAsUrlListBiddingVersion';
		var ajaxQueryString =
			'project_id=' + encodeURIComponent(project_id) +
			'&containerElementId=' + encodeURIComponent(containerElementId);

			//'&sourceElementId=' + sourceElementId;
			//'&csvContainerElementIds=' + encodeURIComponent(csvContainerElementIds);

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
			success: loadProjectBidInvitationFilesAsUrlListBiddingVersionSuccess,
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

function loadProjectBidInvitationFilesAsUrlListBiddingVersionSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		//var project_id = json.project_id;
		//var csvContainerElementIds = json.csvContainerElementIds;
		//var sourceElementId = json.sourceElementId;

		var file_count = json.file_count;
		var containerElementId = json.containerElementId;
		var htmlContent = json.html;

		//alert(htmlContent);
		//alert(containerElementId);

		//var arrContainerElementIds = csvContainerElementIds.split(',');

		if (file_count > 0) {

			$("#" + containerElementId).html(htmlContent);

			$("#" + containerElementId).find("input[type='checkbox']").click(function(tmpJavaScriptEvent) {
				uploadFileDropdownUpcheckState($(this));
				trapJavaScriptEvent(tmpJavaScriptEvent);
			});

			$("#" + containerElementId).find("li").click(function(tmpJavaScriptEvent) {
				trapJavaScriptEvent(tmpJavaScriptEvent);
			});
			//var children = $("#" + containerElementId).find('ul.dropdown-menu');
			//var children = $("#" + containerElementId).find('ul');
			//var children = $("#" + containerElementId).find("input[type='checkbox']");
			//$("#" + containerElementId).find("input[type='checkbox']").each(function() {
			//	checkboxDropdownAllState($(this));
			//	trapJavaScriptEvent(tmpJavaScriptEvent);
			//});
			//if (children.length > 0) {

//				$("#" + containerElementId).find("input[type='checkbox']").each(function() {
//					trapJavaScriptEvent(tmpJavaScriptEvent);
//				});

				// we need to parse the existing checkbox checked item
				// and reassign to the new list
				// skip for now
				/*
				var aryOriginalCheckboxInput = $(children[0]).find("input");
				var aryOriginalCheck
				for (var i = 0; i < aryOriginalCheckboxInput.length; i++ ) {

				}
				*/



				/*
				// find all the checkbox and re-attach the stopPropagation event
				// we don't want the dropdown to collapse when user click upon it
				var aryCheckboxInput = $(children[0]).find("input");
				for (var i = 0; i < aryCheckboxInput.length; i++ ) {
					$(aryCheckboxInput[i]).click(function(tmpJavaScriptEvent) {
						trapJavaScriptEvent(tmpJavaScriptEvent);
					});
				}
				*/
			//}
		}
		// Attach tooltips to the newly populated html


	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//function loadGcBudgetLineItemBidInvitationFilesAsUrlListBiddingVersion(subcontractor_bid_status_group_id, gc_budget_line_item_id, options)
//function loadGcBudgetLineItemBidInvitationFilesAsUrlListBiddingVersion(options)
function loadGcBudgetLineItemBidInvitationFilesAsUrlListBiddingVersion(subcontractor_bid_status_group_id, gc_budget_line_item_id, containerElementId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadGcBudgetLineItemBidInvitationFilesAsUrlListBiddingVersion';
		var ajaxQueryString =
			'subcontractor_bid_status_group_id=' + encodeURIComponent(subcontractor_bid_status_group_id) +
			'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&containerElementId=' + encodeURIComponent(containerElementId);

			//'&sourceElementId=' + sourceElementId;
			//'&csvContainerElementIds=' + encodeURIComponent(csvContainerElementIds);

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
			success: loadGcBudgetLineItemBidInvitationFilesAsUrlListBiddingVersionSuccess,
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

function loadGcBudgetLineItemBidInvitationFilesAsUrlListBiddingVersionSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var file_count = json.file_count;
		var containerElementId = json.containerElementId;
		var htmlContent = json.html;

		if (file_count > 0) {

			$("#" + containerElementId).html(htmlContent);

			$("#" + containerElementId).find("input[type='checkbox']").click(function(tmpJavaScriptEvent) {
				uploadFileDropdownUpcheckState($(this));
				trapJavaScriptEvent(tmpJavaScriptEvent);
			});

			$("#" + containerElementId).find("li").click(function(tmpJavaScriptEvent) {
				trapJavaScriptEvent(tmpJavaScriptEvent);
			});

		}
		// Attach tooltips to the newly populated html

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//function loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersion(subcontractor_bid_status_group_id, gc_budget_line_item_id, options)
//function loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersion(options)
function loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersion(subcontractor_bid_status_group_id, gc_budget_line_item_id, containerElementId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersion';
		var ajaxQueryString =
			'subcontractor_bid_status_group_id=' + encodeURIComponent(subcontractor_bid_status_group_id) +
			'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&containerElementId=' + encodeURIComponent(containerElementId);

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
			success: loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersionSuccess,
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

function loadGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesAsUrlListBiddingVersionSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var file_count = json.file_count;
		var containerElementId = json.containerElementId;
		var htmlContent = json.html;

		if (file_count > 0) {

			$("#" + containerElementId).html(htmlContent);

			$("#" + containerElementId).find("input[type='checkbox']").click(function(tmpJavaScriptEvent) {
				uploadFileDropdownUpcheckState($(this));
				trapJavaScriptEvent(tmpJavaScriptEvent);
			});

			$("#" + containerElementId).find("li").click(function(tmpJavaScriptEvent) {
				trapJavaScriptEvent(tmpJavaScriptEvent);
			});

		}
		// Attach tooltips to the newly populated html

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//function loadSubcontractorBidDocumentFilesAsUrlListBiddingVersion(sourceElementId, subcontractor_bid_id, subcontractor_bid_document_type_id, arrContainerElementIds)
function loadSubcontractorBidDocumentFilesAsUrlListBiddingVersion(subcontractor_bid_status_group_id, subcontractor_bid_id, subcontractor_bid_document_type_id, containerElementId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadSubcontractorBidDocumentFilesAsUrlListBiddingVersion';
		var ajaxQueryString =
			'subcontractor_bid_status_group_id=' + encodeURIComponent(subcontractor_bid_status_group_id) +
			'&subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id) +
			'&subcontractor_bid_document_type_id=' + encodeURIComponent(subcontractor_bid_document_type_id) +
			'&containerElementId=' + encodeURIComponent(containerElementId);

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
			success: loadSubcontractorBidDocumentFilesAsUrlListBiddingVersionSuccess,
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

function loadSubcontractorBidDocumentFilesAsUrlListBiddingVersionSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var file_count = json.file_count;
		var containerElementId = json.containerElementId;
		var htmlContent = json.html;

		if (file_count > 0) {

			$("#" + containerElementId).html(htmlContent);

			$("#" + containerElementId).find("input[type='checkbox']").click(function(tmpJavaScriptEvent) {
				uploadFileDropdownUpcheckState($(this));
				trapJavaScriptEvent(tmpJavaScriptEvent);
			});

			$("#" + containerElementId).find("li").click(function(tmpJavaScriptEvent) {
				trapJavaScriptEvent(tmpJavaScriptEvent);
			});

		}
		// Attach tooltips to the newly populated html

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function projectBidInvitationSelected(element, options)
{
	try {

		var options = options || {};

		var file = element.files[0];

		var uploaderElement = $(element).prev()[0];
		var urlString = generateUrlStringFromAttributesOfElement(uploaderElement);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-file-uploader-ajax.php?dummyGetKey=uploadFiles';
		var ajaxQueryString = urlString;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var projectBidInvitationDropdownContainerElement = $(element).closest('td').find('.dropdown');
		projectBidInvitationDropdownContainerElement.html('<img src="/images/ajax-loader.gif">');

		options.element = element;
		options.projectBidInvitationDropdownContainerElement = projectBidInvitationDropdownContainerElement;

		uploadFile(file, ajaxUrl, projectBidInvitationUploaded, options);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function projectBidInvitationUploaded(arrFileManagerFiles, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.htmlRecordType = 'dropdown';
		options.promiseChain = true;
		options.responseDataType = 'json';

		var element = options.element;
		var projectBidInvitationDropdownContainerElement = options.projectBidInvitationDropdownContainerElement;

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var fileUrl                = fileManagerFile.fileUrl;

			var attributeGroupName = 'create-project_bid_invitation-record';
			var uniqueId = generateDummyElementId();

			var hiddenElements =
			' \
			<div class="hidden"> \
				<input type="hidden" id="'+attributeGroupName+'--project_bid_invitations--project_bid_invitation_file_manager_file_id--'+uniqueId+'" value="'+file_manager_file_id+'"> \
			</div> \
			';

			projectBidInvitationDropdownContainerElement.append(hiddenElements);

			var promise = createProjectBidInvitation(attributeGroupName, uniqueId, options);
			promise.then(function(json) {
				var htmlRecord = json.htmlRecord;
				projectBidInvitationDropdownContainerElement.html(htmlRecord);
				var uploadButton = $(element).next();
				uploadButton.addClass('has-right-sibling');
			});
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function uploadFile(file, ajaxUrl, callback, options)
{
	var filename = file.name;
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
        	var responseText = xhr.responseText;
        	AjaxUrls.ajaxComplete(ajaxUrl, responseText);
        	var json = $.parseJSON(responseText);
        	if (!json.success || json.error) {
        		Console.log(json.error);
        		return;
        	}
        	var arrFileManagerFiles = json.fileMetadata;
            callback(arrFileManagerFiles, options);
        }
    };

	xhr.open('POST', ajaxUrl, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('X-File-Name', encodeURIComponent(filename));
    xhr.setRequestHeader('Content-Type', 'application/octet-stream');
    xhr.send(file);
    AjaxUrls.push(ajaxUrl);
}

function loadAddNewBidderDialog(element, javaScriptEvent, options)
{
	try {

		// Trap the event to prevent double click problems
		trapJavaScriptEvent(javaScriptEvent);

		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bidding-ajax.php?method=loadAddNewBidderDialog';
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
			success: loadAddNewBidderDialogSuccess,
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

function loadAddNewBidderDialogSuccess(data, textStatus, jqXHR)
{
	try {

		// We should probably start using this elsewhere since many laptop
		// screens are just under 800px.
		var height = $(window).height() > 800 ? 800 : $(window).height() * .98;

		$("#divAddNewBidderDialog").removeClass('hidden');
		$("#divAddNewBidderDialog").html(data);
		$("#divAddNewBidderDialog").dialog({
			modal: true,
			title: 'Add New Bidder — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
			width: 1000,
			height: height,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).html('');
				$(this).dialog('destroy');
				$(this).addClass('hidden');
				SelectedBidders.clear();
			},
			buttons: {
				'Close': function() {
					$(this).dialog('close');
				},
				'Add Selected Bidders': function() {
					var promise = SelectedBidders.save();
					promise.then(function() {
						$("#divAddNewBidderDialog").dialog('close');
					});
				}
			}
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function bidderSelected(bidder)
{
	try {

		SelectedBidders.add(bidder);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/*
 * This is Javascript's module pattern. A nice way to contain code and
 * avoid the global scope. Makes for nice method calls also, e.g. SelectedBidders.add()
 */
var SelectedBidders = (function() {

	var arrSelectedBidders = [];

	function add(bidder)
	{
		for (var i = 0; i < arrSelectedBidders.length; i++) {
			var selectedBidder = arrSelectedBidders[i];
			var temp_contact_id = selectedBidder.contact_id;
			var temp_cost_code_id = selectedBidder.cost_code_id;
			var contact_id = bidder.contact_id;
			var cost_code_id = bidder.cost_code_id;
			if (contact_id == temp_contact_id && cost_code_id == temp_cost_code_id) {
				return;
			}
		}

		arrSelectedBidders.unshift(bidder);
		updateUi();
	}

	function remove(contact_id, cost_code_id)
	{
		for (var i = 0; i < arrSelectedBidders.length; i++) {
			var selectedBidder = arrSelectedBidders[i];
			var temp_contact_id = selectedBidder.contact_id;
			var temp_cost_code_id = selectedBidder.cost_code_id;
			if (contact_id == temp_contact_id && cost_code_id == temp_cost_code_id) {
				arrSelectedBidders.splice(i, 1);
				break;
			}
		}
		updateUi();
	}

	function clear()
	{
		arrSelectedBidders = [];
		updateUi();
	}

	function save()
	{
		var arrContactIdsAndCostCodeIds = [];
		var arrFormattedCostCodes = [];
		for (var i = 0; i < arrSelectedBidders.length; i++) {
			var selectedBidder = arrSelectedBidders[i];
			var contact_id = selectedBidder.contact_id;
			var cost_code_id = selectedBidder.cost_code_id;
			var formattedCostCode = selectedBidder.formattedCostCode;
			var id = contact_id + '-' + cost_code_id;
			arrContactIdsAndCostCodeIds.push(id);
			arrFormattedCostCodes.push(formattedCostCode);
		}

		if (arrContactIdsAndCostCodeIds.length == 0) {
			var messageText = 'You have not selected any bidders.';
			messageAlert(messageText, 'infoMessage');
			var dummyRejectedPromise = getDummyRejectedPromise();
			return dummyRejectedPromise;
		}

		var csvContactIdsAndCostCodeIds = arrContactIdsAndCostCodeIds.join(',');

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bidding-ajax.php?method=addBiddersByCsvContactIdsAndCostCodeIds';
		var ajaxQueryString =
			'csvContactIdsAndCostCodeIds=' + encodeURIComponent(csvContactIdsAndCostCodeIds);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var promise1 = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString
		});

		var promise2 = promise1.then(function(data) {
			try {
				var json = $.parseJSON(data);
				var messageText = json.messageText;
				if (json.error) {
					messageAlert(messageText, 'errorMessage');
					return getDummyRejectedPromise();
				} else {
					// We just added potential bidders. Rebuild accordions
					// and open the Potential Bidder section.
					var htmlContent = json.htmlContent;
					messageAlert(messageText, 'successMessage');

					// Capture the current state of the accordions before we
					// replace the content of the page.
					var arrOpenAccordionTitles = getOpenAccordionTitles();
					var arrOpenSubaccordionTitles = getOpenSubaccordionTitles();

					var subcontractor_bid_status = 'Potential Bidder';
					if (arrOpenAccordionTitles.indexOf(subcontractor_bid_status) == -1) {
						arrOpenAccordionTitles.push(subcontractor_bid_status);
					}

					for (var i = 0; i < arrFormattedCostCodes.length; i++) {
						var formattedCostCode = arrFormattedCostCodes[i];
						if (arrOpenSubaccordionTitles.indexOf(formattedCostCode) == -1) {
							arrOpenSubaccordionTitles.push(formattedCostCode);
						}
					}

					$("#divBidding").html(htmlContent);

					reinitializeWidgetsAndOpenSpecifiedAccordions(arrOpenAccordionTitles, arrOpenSubaccordionTitles);

				}
			} catch(error) {
				Console.log('SelectedBidders.save.promise.then error: ' + error);
			}
		});

		return promise2;
	}

	function updateUi()
	{
		var listItems = '';
		for (var i = 0; i < arrSelectedBidders.length; i++) {
			var selectedBidder = arrSelectedBidders[i];
			var contact_id = selectedBidder.contact_id;
			var first_name = selectedBidder.first_name;
			var last_name = selectedBidder.last_name;
			var email = selectedBidder.email;
			var cost_code_id = selectedBidder.cost_code_id;
			var formattedCostCode = selectedBidder.formattedCostCode;
			listItems += ' \
			<li> \
				<a class="fakeHref" href="javascript:SelectedBidders.remove(\''+contact_id+'\', \''+cost_code_id+'\');">X</a> \
				<span>'+formattedCostCode+'</span> \
				<span>'+first_name+' '+last_name+'</span> \
				<span><a class="fakeHref" href="mailto:'+email+'">'+email+'</a></span> \
			</li>';
		}

		$("#ulSelectedBidders").html(listItems);

		if (arrSelectedBidders.length > 0) {
			$("#ulSelectedBidders").parent().removeClass('hidden');
		} else {
			$("#ulSelectedBidders").parent().addClass('hidden');
		}
	}

	return {
		add: add,
		remove: remove,
		clear: clear,
		save: save
	};

}());

function fileUploader_DragEnter()
{
	//$(".boxViewUploader").show();
	//showDrag = false;
	$(".boxViewUploader").find('.qq-upload-drop-area').show();
}

function fileUploader_DragLeave()
{
	//$(".boxViewUploader").hide();
	//showDrag = true;
	$(".boxViewUploader").find('.qq-upload-drop-area').hide();
}

function contactSearchResultsReceived()
{
	try {

		$(".popover").remove();

		$(".popoverButton").popover({
			html: true,
			title: 'Assign Trade To Subcontractor',
			container: 'body',
			content: function() {
				var contentElement = $(this).next();
				var html = contentElement.html();
				contentElement.html('');
				$(this).on('hidden.bs.popover', function() {
					contentElement.html(html);
				});
				return html;
			}
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function searchContactSelected_biddingAddBiddersToBudget(element, contact_id, company, contactFirstName, contactLastName, email)
{
	var contact_id = $(element).find('.contact_id').val();
	var cost_code_id = $(element).find('.cost_code_id').val();
	var first_name = $(element).find('.first_name').html();
	var last_name = $(element).find('.last_name').html();
	var email = $(element).find('.email').html();
	var division_number = $(element).find('.division_number').html();
	var cost_code = $(element).find('.cost_code').html();
	var cost_code_description = $(element).find('.cost_code_description').html();
	var formattedCostCode = division_number + '-' + cost_code + ' ' + cost_code_description;

	var bidder = {
		contact_id: contact_id,
		cost_code_id: cost_code_id,
		first_name: first_name,
		last_name: last_name,
		email: email,
		formattedCostCode: formattedCostCode
	};

	SelectedBidders.add(bidder);
}

function createSubcontractorTradeFromPopover(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createSubcontractorTrade(attributeGroupName, uniqueId, options);
		promise.then(function(json) {
			try {

				var cost_code_id = $("#" + attributeGroupName + "--subcontractor_trades--cost_code_id--" + uniqueId).val();
				var formattedCostCode = $("#" + attributeGroupName + "--subcontractor_trades--cost_code_id--" + uniqueId + " option:selected").html();
				var popoverElement = $("#" + options.popoverElementId);
				var tr = popoverElement.closest('tr');

				var newTr = tr.clone();
				// set the first TD with costcode
				var td = newTr.find('td:first');
				td.html(formattedCostCode);

				var onclick = newTr.attr('data-onclick');

				// add costcode as an element to the array
				// inside the method of SelectedBidders.add
				// E.g SelectedBidders.add( { contact_id: '36'
				// by replacing the string

				onclick = onclick.replace('( {', '( {cost_code_id: \'' + cost_code_id + '\', formattedCostCode: \'' + formattedCostCode + '\', ');

				newTr.attr('onclick', onclick);
				newTr.removeAttr('data-onclick');
				newTr.removeClass('no-click');
				tr.after(newTr);
				newTr.click();
				// hide the control
				popoverElement.popover('hide');

			} catch (error) {

				Console.log('createSubcontractorTradeFromPopover.promise.then error: ' + error);

			}
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function displayPopoverAtLocationOfMouseClick(element, javaScriptEvent)
{
	$(element).on('shown.bs.popover', function() {
		var popoverElementId = $(this).attr('aria-describedby');
		var popoverElement = $("#" + popoverElementId);

		var left = javaScriptEvent.clientX + 5;
		var top = javaScriptEvent.clientY - popoverElement.height() / 2;

		// Macs need extra help with positioning.
		var isMac = checkUserAgentForMacintosh();
		if (isMac) {
			top += 10;
			var notFirstClick = $(this).data('notFirstClick');
			if (!notFirstClick) {
				top += 10;
				$(this).data('notFirstClick', true);
			}
		}

		var styles = {
			left: left,
			top: top
		};
		popoverElement.css(styles);
	});
}

// @todo Pass in subject and message
/**
 * @param {object.property} options.defaultEmailMessageSubject
 * @param {object.property} options.defaultEmailMessageBody
 *
 * @return void | promise object
 */
function loadEmailModalDialog_SendSubcontractorBidCorrespondance(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		// bid preference
		// 1. group by costcode 2. group by contact

		var bidPerference = $("#bidding-module-bidders--send-bid-by-costcode:checked").val();

		if (typeof bidPerference !== "undefined" && bidPerference == 'Y') {
			bidPerference = 'bidByCostcode';
		}
		else {
			bidPerference = 'bidByContact';
		}

		// Subcontractor Bids
		// subcontractor_bids: list of subcontractor_bid_id values
		var arrSubcontractorBidIds = [];
		$(".bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id:checked").each(function() {
			var subcontractor_bid_id = $(this).val();
			arrSubcontractorBidIds.push(subcontractor_bid_id);
		});
		var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');

		if (arrSubcontractorBidIds.length == 0) {
			var messageText = 'You have not selected any bidders.';
			messageAlert(messageText, 'infoMessage');
			return;
		}


		// Subcontractor Bid Files
		// project_bid_invitations
		// gc_budget_line_item_bid_invitations
		// gc_budget_line_item_unsigned_scope_of_work_documents
		// subcontractor_bid_documents by: <subcontractor_bid_id, subcontractor_bid_document_type_id>


		// project_bid_invitations
		var arrProjectBidInvitationIds = [];
		$(".bidding-module-files--project_bid_invitations--project_bid_invitation_id:checked").each(function() {
			var project_bid_invitation_id = $(this).val();
			arrProjectBidInvitationIds.push(project_bid_invitation_id);
		});
		var csvProjectBidInvitationIds = arrProjectBidInvitationIds.join(',');

		// gc_budget_line_item_bid_invitations
		var arrGcBudgetLineItemBidInvitationIds = [];
		$(".bidding-module-files--gc_budget_line_item_bid_invitations--gc_budget_line_item_bid_invitation_id:checked").each(function() {
			var gc_budget_line_item_bid_invitation_id = $(this).val();
			arrGcBudgetLineItemBidInvitationIds.push(gc_budget_line_item_bid_invitation_id);
		});
		var csvGcBudgetLineItemBidInvitationIds = arrGcBudgetLineItemBidInvitationIds.join(',');


		// gc_budget_line_item_unsigned_scope_of_work_documents
		var arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = [];
		$(".bidding-module-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id:checked").each(function() {
			// parse subcontractor_bid_status_group_id from
			/*
			var subcontractor_bid_status_group_id = parseSubcontractorBidStatusGroupIdFromCheckboxClassForGcBudgetLineItem(
				$(this).attr("class")
			);
			*/
			var gc_budget_line_item_unsigned_scope_of_work_document_id = $(this).val();
			arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds.push(gc_budget_line_item_unsigned_scope_of_work_document_id);
		});
		var csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds.join(',');

		// subcontractor_bid_documents by: <subcontractor_bid_id, subcontractor_bid_document_type_id>
		var arrSubcontractorBidDocumentIds = [];
		$(".bidding-module-files--subcontractor_bid_documents--subcontractor_bid_document_id:checked").each(function() {
			var subcontractor_bid_document_id = $(this).val();
			arrSubcontractorBidDocumentIds.push(subcontractor_bid_document_id);
		});
		var csvSubcontractorBidDocumentIds = arrSubcontractorBidDocumentIds.join(',');

		// Default Email Subject
		var defaultEmailMessageSubject = options.defaultEmailMessageSubject;
		// Debug
		//alert(defaultEmailMessageSubject);
		if (!defaultEmailMessageSubject) {
			defaultEmailMessageSubject = '';
		}

		// Default Email Message Body
		var defaultEmailMessageBody = options.defaultEmailMessageBody;
		// Debug
		//alert(defaultEmailMessageBody);
		if (!defaultEmailMessageBody) {
			defaultEmailMessageBody = '';
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bidding-ajax.php?method=loadEmailModalDialog_SendSubcontractorBidCorrespondance';
		var ajaxQueryString =
			'csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds) +
			'&csvProjectBidInvitationIds=' + encodeURIComponent(csvProjectBidInvitationIds) +
			'&csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds=' + encodeURIComponent(csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds) +
			'&csvGcBudgetLineItemBidInvitationIds=' + encodeURIComponent(csvGcBudgetLineItemBidInvitationIds) +
			'&csvSubcontractorBidDocumentIds=' + encodeURIComponent(csvSubcontractorBidDocumentIds) +
			'&defaultEmailMessageSubject=' + encodeURIComponent(defaultEmailMessageSubject) +
			'&defaultEmailMessageBody=' + encodeURIComponent(defaultEmailMessageBody) +
			'&bidPerference=' + bidPerference;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		// Optional $.ajax callbacks may be passed in via the options object
		var arrSuccessCallbacks = [ loadEmailModalDialog_SendSubcontractorBidCorrespondanceSuccess ];
		var successCallback = options.successCallback;
		if (successCallback) {
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: arrSuccessCallbacks,
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

function loadEmailModalDialog_SendSubcontractorBidCorrespondanceSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.98;
		var dialogHeight = windowHeight * 0.98

		$("#divSendBidInvitationDialog").removeClass('hidden');
		$("#divSendBidInvitationDialog").html(data);
		$("#divSendBidInvitationDialog").dialog({
			width: dialogWidth,
			height: dialogHeight,
			title: 'Send Bid Invitations',
			modal: true,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).dialog('destroy');
				$(this).html('');
				$(this).addClass('hidden');
			},
			buttons: {
				'Send Bid Invitations': function() {
					submitEmailModalDialog_PerformAction();

					/*
					var options = { promiseChain: true };
					var promise = submitEmailModalDialog_PerformAction(options);
					promise.then(function() {
						$("#divSendBidInvitationDialog").dialog('close');
						//active_subcontractor_bid_status = 'Invited to Bid';
						//loadBiddingContent();
					});
					*/
				},
				/*
				'Send Bid Invitations': function() {
					var options = { promiseChain: true };
					var promise = sendBidInvitations(options);
					promise.then(function() {
						$("#divSendBidInvitationDialog").dialog('close');
						active_subcontractor_bid_status = 'Invited to Bid';
						loadBiddingContent();
					});
				},
				*/
				'Cancel': function() {
					$(this).dialog('close');
				}
			}
		});

		$('.bs-tooltip').tooltip();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
 function to parse subcontractor_bid_status_group_id
 for gc_budget_line_item doc checkbox
 example of css:
 bidding-module-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id bidding-module-files-subcontractor_bid_status_group_id-1--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_id--1 bidding-module-files--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1

 we need to return 1 in this case from element subcontractor_bid_status_group_id--1
*/
function parseSubcontractorBidStatusGroupIdFromCheckboxClassForGcBudgetLineItem(elementCssClass) {
	try {

		var arrElementCssClass = elementCssClass.split(' ');
		var arrSplitsubcontractorBidStatusGroupId = arrElementCssClass[2].split("--");

		return arrSplitsubcontractorBidStatusGroupId[3];

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function submitEmailModalDialog_PerformAction(options)
{
	try {

		// get email body message from textarea box
		var emailBodyMessage = $("#bidding-module-email-modal-dialog-files-subcontractor-bid-documents-textarea").val();

		// get email body subject from subjectLine
		var emailSubjectTitle = $("#bidding-module-email-modal-dialog-form--subject-line").val();

		// Subcontractor Bids
		// subcontractor_bids: list of subcontractor_bid_id values

		var arrSubcontractorBidIds = [];
		$(".bidding-module-email-modal-dialog-bidders--subcontractor_bids--subcontractor_bid_id").each(function() {
			var tmpElementId = this.id;

			// E.g. id="record_container--bidding-module-email-modal-dialog-subcontractor-contact-email--subcontractor_bids--subcontractor_bid_id--7"
			var arrParts = tmpElementId.split('--');
			var attributeGroupContainerName = arrParts[0];
			var attributeGroupName = arrParts[1];
			var attributeSubgroupName = arrParts[2];
			var attributeName = arrParts[3];
			var uniqueId = arrParts[4];

			var subcontractor_bid_id = uniqueId;
			arrSubcontractorBidIds.push(subcontractor_bid_id);
		});
		var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');

		if (arrSubcontractorBidIds.length == 0) {
			var messageText = 'You have not selected any bidders.';
			messageAlert(messageText, 'infoMessage');
			return;
		}


		// Subcontractor Bid Files
		// project_bid_invitations
		// gc_budget_line_item_bid_invitations
		// gc_budget_line_item_unsigned_scope_of_work_documents
		// subcontractor_bid_documents by: <subcontractor_bid_id, subcontractor_bid_document_type_id>


		// project_bid_invitations
		var arrProjectBidInvitationIds = [];

		$("input:checked[class*='bidding-module-email-modal-dialog-files--project_bid_invitations--project_bid_invitation_id']").each(function() {
		//$(".bidding-module-email-modal-dialog-files--project_bid_invitations--project_bid_invitation_id").each(function() {

			var tmpClassName = this.className;
			var bidDocumentSubcontracterBidder = this.value;

			var arrParts = tmpClassName.split('--');

			var uniqueId = arrParts[4];
			if (typeof uniqueId != 'undefined') {
				var project_bid_invitation_id = uniqueId;
				var linkedSubcontractorBidderIdProjectBidInvitationId = bidDocumentSubcontracterBidder + '--' + project_bid_invitation_id;
				arrProjectBidInvitationIds.push(linkedSubcontractorBidderIdProjectBidInvitationId);
			}

		});
		var csvProjectBidInvitationIds = arrProjectBidInvitationIds.join(',');

		// gc_budget_line_item_bid_invitations
		var arrGcBudgetLineItemBidInvitationIds = [];
		$("input:checked[class^='bidding-module-email-modal-dialog-files--gc_budget_line_item_bid_invitations--gc_budget_line_item_bid_invitation_id']").each(function() {

			var tmpClassName = this.className;
			var bidDocumentSubcontracterBidder = this.value;
			var arrParts = tmpClassName.split('--');
			var attributeGroupName = arrParts[0];
			var attributeSubgroupName = arrParts[1];
			var attributeName = arrParts[2];
			var uniqueId = arrParts[3];
			if (typeof uniqueId != 'undefined') {
				var gc_budget_line_item_bid_invitation_id = uniqueId;
				var linkedSubcontractorBidderIdGcBudgetLineItemBidInvitationId = bidDocumentSubcontracterBidder + '--' + gc_budget_line_item_bid_invitation_id;
				arrGcBudgetLineItemBidInvitationIds.push(linkedSubcontractorBidderIdGcBudgetLineItemBidInvitationId);
			}
		});
		var csvGcBudgetLineItemBidInvitationIds = arrGcBudgetLineItemBidInvitationIds.join(',');

		// gc_budget_line_item_unsigned_scope_of_work_documents
		var arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = [];
		$("input:checked[class^='bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id']").each(function() {

			//	   'bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id--76'
			var tmpClassName = this.className;
			var bidDocumentSubcontracterBidder = this.value;
			var arrParts = tmpClassName.split('--');
			var attributeGroupName = arrParts[0];
			var attributeSubgroupName = arrParts[1];
			var attributeName = arrParts[2];
			var uniqueId = arrParts[3];
			if (typeof uniqueId != 'undefined') {
				var gc_budget_line_item_unsigned_scope_of_work_document_id = uniqueId;
				var linkedSubcontractorBidderIdGcBudgetLineItemUnsignedScopeOfWorkDocumentId = bidDocumentSubcontracterBidder + '--' + gc_budget_line_item_unsigned_scope_of_work_document_id;
				arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds.push(linkedSubcontractorBidderIdGcBudgetLineItemUnsignedScopeOfWorkDocumentId);
			}
		});
		var csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds.join(',');

		// subcontractor_bid_documents by: <subcontractor_bid_id, subcontractor_bid_document_type_id>
		// need to check subcontract bid invitation
		// bidding-module-email-modal-dialog-files--subcontractor-bid-invitaion--subcontractor_bid_document_id--169

		var arrSubcontractorBidDocumentIds = [];
		$("input:checked[class^='bidding-module-email-modal-dialog-files--subcontractor-unsigned-scope-of-work--subcontractor_bid_document_id']").each(function() {
			var tmpClassName = this.className;


			var arrParts = tmpClassName.split('--');
			var attributeSubgroupName = arrParts[1];
			var attributeName = arrParts[2];
			var uniqueId = arrParts[3];
			if (typeof uniqueId != 'undefined') {
				var subcontractor_bid_document_id = uniqueId;
				// although relationship in db, more convenience to pass in the association
				var bidDocumentSubcontracterBidder = this.value;
				var linkedSubcontractorBidDocumentId = bidDocumentSubcontracterBidder + '--' + subcontractor_bid_document_id;
				arrSubcontractorBidDocumentIds.push(linkedSubcontractorBidDocumentId);
				//arrSubcontractorBidDocumentIds.push(subcontractor_bid_document_id);
			}
		});
		// collect subcontract bid invitation into array arrSubcontractorBidDocumentIds
		// bidding-module-email-modal-dialog-files--subcontractor-bid-invitaion--subcontractor_bid_document_id--169
		$("input:checked[class^='bidding-module-email-modal-dialog-files--subcontractor-bid-invitaion--subcontractor_bid_document_id']").each(function() {
			var tmpClassName = this.className;


			var arrParts = tmpClassName.split('--');
			var attributeGroupName = arrParts[0];
			var attributeSubgroupName = arrParts[1];
			var attributeName = arrParts[2];
			var uniqueId = arrParts[3];
			if (typeof uniqueId != 'undefined') {
				var subcontractor_bid_document_id = uniqueId;
				// although relationship in db, more convenience to pass in the association
				var bidDocumentSubcontracterBidder = this.value;
				var linkedSubcontractorBidDocumentId = bidDocumentSubcontracterBidder + '--' + subcontractor_bid_document_id;
				arrSubcontractorBidDocumentIds.push(linkedSubcontractorBidDocumentId);
			}
		});
		var csvSubcontractorBidDocumentIds = arrSubcontractorBidDocumentIds.join(',');


		// Email - Invitations to Bid
		// Hard coded for now
		actionToPerform = 'invitationToBid';

		if (actionToPerform == 'invitationToBid') {
			//var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');
			//var inviteEmailNote = $("#additionalNotes").val();
			//var activeProjectId = $("#activeProjectId").val();
			//var activeProjectId = $("#currentlySelectedProjectId").val();

			var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=sendInvitationsToBid';
			var ajaxQueryString =
				'csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds) +
				'&actionToPerform=' + encodeURIComponent(actionToPerform) +

				//'&project_id=' + encodeURIComponent(activeProjectId) +
				//'&emailNote=' + encodeURIComponent(inviteEmailNote) +

				'&csvProjectBidInvitationIds=' + encodeURIComponent(csvProjectBidInvitationIds) +
				'&csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds=' + encodeURIComponent(csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds) +
				'&csvGcBudgetLineItemBidInvitationIds=' + encodeURIComponent(csvGcBudgetLineItemBidInvitationIds) +
				'&csvSubcontractorBidDocumentIds=' + encodeURIComponent(csvSubcontractorBidDocumentIds) +
				'&emailBodyMessage=' + encodeURIComponent(emailBodyMessage) +
				'&emailSubjectTitle=' + encodeURIComponent(emailSubjectTitle);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
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
			success: submitEmailModalDialog_PerformActionSuccess,
			error: errorHandler
		});

		/*
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bidding-ajax.php?method=submitEmailModalDialog_PerformAction';
		var ajaxQueryString =
			'actionToPerform=' + encodeURIComponent(actionToPerform) +
			'&csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds) +
			'&csvProjectBidInvitationIds=' + encodeURIComponent(csvProjectBidInvitationIds) +
			'&csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds=' + encodeURIComponent(csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds) +
			'&csvGcBudgetLineItemBidInvitationIds=' + encodeURIComponent(csvGcBudgetLineItemBidInvitationIds) +
			'&csvSubcontractorBidDocumentIds=' + encodeURIComponent(csvSubcontractorBidDocumentIds);
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
			success: submitEmailModalDialog_PerformActionSuccess,
			error: errorHandler
		});
		*/

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

// @todo Refactor this to do what it needs to do - it is a clone of: loadEmailModalDialog_SendSubcontractorBidCorrespondanceSuccess
function submitEmailModalDialog_PerformActionSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.85;
		var dialogHeight = windowHeight * 0.85;

		$("#divSendBidInvitationDialog").removeClass('hidden');
		$("#divSendBidInvitationDialog").html(data);
		$("#divSendBidInvitationDialog").dialog({
			width: dialogWidth,
			height: dialogHeight,
			title: 'Send Bid Invitations',
			modal: true,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).dialog('destroy');
				$(this).html('');
				$(this).addClass('hidden');
			},
			buttons: {
				/*'Send Bid Invitations': function() {
					var options = { promiseChain: true };
					var promise = sendBidInvitations(options);
					promise.then(function() {
						$("#divSendBidInvitationDialog").dialog('close');
						active_subcontractor_bid_status = 'Invited to Bid';
						loadBiddingContent();
					});
				},
				*/
				'Close': function() {
					$(this).dialog('close');
				}
			}
		});

		$('.bs-tooltip').tooltip();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/*
reusable function to parse parameters for
1. gc_budget_line_item_id
2. subcontractor_bid_status_group_id
*/
function parseBidDocumentsParamStr(bidDocumentClassList) {
	var returnStr = "";
	var bidDocumentStrArray;
	var params = ["gc_budget_line_item_id", "subcontractor_bid_status_group_id"];
	for (var i = 0; i < bidDocumentClassList.length; i++) {
		for (var j = 0; j < params.length; j++) {
			if (bidDocumentClassList.item(i).indexOf(params[j]) >= 0) {
				bidDocumentStrArray = bidDocumentClassList.item(i).split('--');
				returnStr += params[j] + ":" + bidDocumentStrArray[bidDocumentStrArray.length - 1] + "|";
			}
		}
	}
	return(returnStr);
}

function loadSendBidInvitationDialog()
{
	try {

		var arrSubcontractorBidIds = [];
		var subcontractor_bid_document_id = "subcontractor_bid_document_id";
		var gc_budget_line_item_bid_invitation_id = "gc_budget_line_item_bid_invitation_id";
		var gc_budget_line_item_unsigned_scope_of_work_document_id = "gc_budget_line_item_unsigned_scope_of_work_document_id";

		$(".bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id:checked").each(function() {
			var subcontractor_bid_id = $(this).val();
			arrSubcontractorBidIds.push(subcontractor_bid_id);
		});

		if (arrSubcontractorBidIds.length == 0) {
			var messageText = 'You have not selected any bidders.';
			messageAlert(messageText, 'infoMessage');
			return;
		}

		/* get bidding-module-files subcontractor_bid_documents */

		// to capture pair value of subcontractor_bid_document_id + gc_budget_line_item_id + subcontractor_bid_status_group_id
		var bidDocumentParamStr = "";

		$(".bidding-module-files--subcontractor_bid_documents--subcontractor_bid_document_id:checked").each(function() {
			bidDocumentParamStr += subcontractor_bid_document_id + ":" + this.value + "|" +
				parseBidDocumentsParamStr(this.classList) + "," ;
		});

		var bidInvitationsParamStr = "";
		/* get gc_budget_line_item_bid_invitations */
		$(".bidding-module-files--gc_budget_line_item_bid_invitations--gc_budget_line_item_bid_invitation_id:checked").each(function() {
			bidInvitationsParamStr += gc_budget_line_item_bid_invitation_id + ":" + this.value + "|" +
				parseBidDocumentsParamStr(this.classList) + "," ;
		});

		var unsignedScopeOfWorkPamarStr = "";

		/* get gc_budget_line_item_unsigned_scope_of_work_document_id */
		$(".bidding-module-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id:checked").each(function() {
			unsignedScopeOfWorkPamarStr += gc_budget_line_item_unsigned_scope_of_work_document_id + ":" + this.value + "|" +
				parseBidDocumentsParamStr(this.classList) + "," ;
		});


		// bidding-module-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id

		var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bidding-ajax.php?method=loadSendBidInvitationDialog';
		var ajaxQueryString =
			'csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds) +
			'&csvGcBudgetLineItemBidInvitations=' + encodeURIComponent(bidInvitationsParamStr) +
			'&csvGcBudgetLineItemUnsignedScopeOfWork=' + encodeURIComponent(unsignedScopeOfWorkPamarStr) +
			'&csvSubContractorBidDocumentParams=' + encodeURIComponent(bidDocumentParamStr);
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
			success: loadSendBidInvitationDialogSuccess,
			error: errorHandler
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadSendBidInvitationDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divSendBidInvitationDialog").removeClass('hidden');
		$("#divSendBidInvitationDialog").html(data);
		$("#divSendBidInvitationDialog").dialog({
			height: 500,
			width: 900,
			title: 'Send Bid Invitation',
			modal: true,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).dialog('destroy');
				$(this).html('');
				$(this).addClass('hidden');
			},
			buttons: {
				'Send Bid Invitation': function() {
					var options = { promiseChain: true };
					var promise = sendBidInvitations(options);
					promise.then(function() {
						$("#divSendBidInvitationDialog").dialog('close');
						active_subcontractor_bid_status = 'Invited to Bid';
						loadBiddingContent();
					});
				},
				'Cancel': function() {
					$(this).dialog('close');
				}
			}
		});

		$('.bs-tooltip').tooltip();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function sendBidInvitations(options)
{
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		var arrSubcontractorBidIds = [];
		$("#subcontractorBidInvitationEmailRecipients li").each(function() {
			var arrTemp = this.id.split('--');
			var subcontractor_bid_id = arrTemp[1];
			arrSubcontractorBidIds.push(subcontractor_bid_id);
		});

		if (arrSubcontractorBidIds.length == 0) {
			var messageText = 'You have not selected any bidders.';
			messageAlert(messageText, 'infoMessage');
			return getDummyRejectedPromise();
		}

		var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');
		var emailBody = $("#emailBody").val();
		var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=sendInvitationsToBid';
		var ajaxQueryString =
			'csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds) +
			'&emailNote=' + encodeURIComponent(emailBody);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
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
	messageText = 'All bid invitations were successfully sent';
	messageAlert(messageText, 'successMessage');
}

function removeContactFromEmail(element)
{
	$(element).parent().remove();
}

function loadSendEmailDialog()
{
	try {

		var arrSubcontractorBidIds = [];
		$(".bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id:checked").each(function() {
			var subcontractor_bid_id = $(this).val();
			arrSubcontractorBidIds.push(subcontractor_bid_id);
		});

		if (arrSubcontractorBidIds.length == 0) {
			var messageText = 'You have not selected any bidders.';
			messageAlert(messageText, 'infoMessage');
			return;
		}

		var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bidding-ajax.php?method=loadSendEmailDialog';
		var ajaxQueryString =
			'csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds);
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
			success: loadSendEmailDialogSuccess,
			error: errorHandler
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadSendEmailDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divSendEmailDialog").removeClass('hidden');
		$("#divSendEmailDialog").html(data);
		$("#divSendEmailDialog").dialog({
			height: 500,
			width: 900,
			title: 'Send Email',
			modal: true,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).dialog('destroy');
				$(this).html('');
				$(this).addClass('hidden');
			},
			buttons: {
				'Send': function() {
					var options = { promiseChain: true };
					var promise = sendEmail(options);
					promise.then(function() {
						$("#divSendEmailDialog").dialog('close');
					});
				},
				'Cancel': function() {
					$(this).dialog('close');
				}
			}
		});

		$('.bs-tooltip').tooltip();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function sendEmail(options)
{
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		var arrSubcontractorBidIds = [];
		$("#emailRecipients li").each(function() {
			var arrTemp = this.id.split('--');
			var subcontractor_bid_id = arrTemp[1];
			arrSubcontractorBidIds.push(subcontractor_bid_id);
		});

		if (arrSubcontractorBidIds.length == 0) {
			var messageText = 'You have not selected any bidders.';
			messageAlert(messageText, 'infoMessage');
			return getDummyRejectedPromise();
		}

		var csvSubcontractorBidIds = arrSubcontractorBidIds.join(',');
		var emailBody = $("#emailBody").val();

		if (emailBody == '') {
			var confirmed = window.confirm('Send email with empty body?');
			if (!confirmed) {
				return;
			}
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bidding-ajax.php?method=sendEmail';
		var ajaxQueryString =
			'csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds) +
			'&emailBody=' + encodeURIComponent(emailBody);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divAjaxLoading").html('Processing Emails . . . Please wait');

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: sendEmailSuccess,
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

function sendEmailSuccess(data, textStatus, jqXHR)
{
	messageText = 'All emails were successfully sent';
	messageAlert(messageText, 'successMessage');
}

function toggleDynamicUploadersAtCostCodeLevel(element, javaScriptEvent, options)
{
	var options = options || {};
	var initialize = options.initialize;
	var doNotCheckToggleOtherSections = options.doNotCheckToggleOtherSections;

	var accordionHeader = $(element).closest('.accordion-header');
	var accordionContent = accordionHeader.next();
	var dynamicUploaders = accordionContent.find('h3 .boxViewUploader');
	var staticUploaders = accordionContent.find('h3 button.button-static-uploader');

	if (initialize == undefined) {
		if (dynamicUploaders.length == 0) {
			initialize = true;
		} else {
			initialize = false;
		}
	}

	// Don't trigger the accordion.
	trapJavaScriptEvent(javaScriptEvent);

	if (initialize) {
		dynamicUploaders = accordionContent.find('h3 .notBoxViewUploader');
		dynamicUploaders.addClass('boxViewUploader');
		dynamicUploaders.removeClass('notBoxViewUploader hidden');
		staticUploaders.addClass('hidden');
		createUploaders();

		dynamicUploaders.each(function() {
			if ($(this).parent().find('.dropdown-placeholder').length == 0) {
				$(this).find('.qq-upload-button, .qq-upload-drop-area').addClass('has-right-sibling');
			}
		});

	} else {
		var arrUploaders = accordionContent.find('h3 .boxViewUploader');
		qq.removeEventListenersOfFileUploadersInJQueryArray(arrUploaders);
		arrUploaders.removeClass('uploaderInitialized');
		accordionContent.find('h3 .qq-uploader').remove();
		dynamicUploaders.addClass('notBoxViewUploader hidden');
		dynamicUploaders.removeClass('boxViewUploader');
		staticUploaders.removeClass('hidden');
	}

	if (!doNotCheckToggleOtherSections) {

		if ($("#checkboxToggleOtherCostCodeSections").is(':checked')) {
			$('.toggle-cost-code-level-uploaders').each(function() {
				if (this == element) {
					return;
				}
				options.doNotCheckToggleOtherSections = true;
				options.initialize = false;
				toggleDynamicUploadersAtCostCodeLevel(this, javaScriptEvent, options);
			});
		}

	}
}

function toggleDynamicUploadersAtCostCodeLevel1(element, javaScriptEvent, options)
{
	var options = options || {};
	var initialize = options.initialize;
	var doNotCheckToggleOtherSections = options.doNotCheckToggleOtherSections;

	var accordionHeader = $(element).closest('.accordion-header');
	var accordionContent = accordionHeader.next();
	var gcBudgetLineItemUnsignedScopeOfWorkDocumentUploaders = accordionContent.find('h3 .gcBudgetLineItemUnsignedScopeOfWorkDocumentUploader');
	var gcBudgetLineItemBidInvitationUploaders = accordionContent.find('h3 .gcBudgetLineItemBidInvitationUploader');
	var staticUploaders = accordionContent.find('h3 button.button-static-uploader');

	if (initialize == undefined) {
		if (gcBudgetLineItemUnsignedScopeOfWorkDocumentUploaders.children().length == 0) {
			initialize = true;
		} else {
			initialize = false;
		}
	}

	if (initialize) {

		var gc_budget_line_item_unsigned_scope_of_work_document_file_manager_folder_id = $("#gc_budget_line_item_unsigned_scope_of_work_document_file_manager_folder_id").val();
		var endpoint = '/modules-purchasing-file-uploader-ajax.php?folder_id=' + gc_budget_line_item_unsigned_scope_of_work_document_file_manager_folder_id;
		var uploaderElement, dropdownElement, dropdownElementHtml;
		var uploaderOptions = {
			request: {
				endpoint: endpoint
			},
			callbacks: {
				onSubmit: function(id, name) {
					// 'this' is a reference to a qq.FineUploader object.
					uploaderElement = this._options.element;
					dropdownElement = $(uploaderElement).siblings('.dropdown');
					dropdownElementHtml = dropdownElement.html();
					dropdownElement.html('<img src="/images/ajax-loader.gif">');
				},
				onError: function(id, name, errorReason, xhr) {
					dropdownElement.html(dropdownElementHtml);
					fileManagerFileUploadError(id, name, errorReason, xhr);
				},
				onComplete: function(id, name, responseJSON, xhr) {
					if (!responseJSON.success) {
						dropdownElement.html(dropdownElementHtml);
						return;
					}
					var subcontractor_bid_status_id = $(uploaderElement).attr('data-subcontractor_bid_status_id');
					var gc_budget_line_item_id = $(uploaderElement).attr('data-gc_budget_line_item_id');
					var options = {
						subcontractor_bid_status_id: subcontractor_bid_status_id,
						gc_budget_line_item_id: gc_budget_line_item_id,
						element: uploaderElement,
						gcBudgetLineItemUnsignedScopeOfWorkDocumentDropdownContainerElement: dropdownElement
					};
					var arrFileManagerFiles = responseJSON.fileMetadata;
					gcBudgetLineItemUnsignedScopeOfWorkDocumentUploaded(arrFileManagerFiles, options);
				}
			},
			validation: {
				allowedExtensions: [ 'pdf' ]
			},
			customLabel: 'Drop/Click'
		};
		gcBudgetLineItemUnsignedScopeOfWorkDocumentUploaders.fineUploader(uploaderOptions);

		var gc_budget_line_item_bid_invitation_file_manager_folder_id = $("#gc_budget_line_item_bid_invitation_file_manager_folder_id").val();
		uploaderOptions.request.endpoint = '/modules-purchasing-file-uploader-ajax.php?folder_id=' + gc_budget_line_item_bid_invitation_file_manager_folder_id;
		uploaderOptions.callbacks.onComplete = function(id, name, responseJSON, xhr) {
			if (!responseJSON.success) {
				dropdownElement.html(dropdownElementHtml);
				return;
			}
			var subcontractor_bid_status_id = $(uploaderElement).attr('data-subcontractor_bid_status_id');
			var gc_budget_line_item_id = $(uploaderElement).attr('data-gc_budget_line_item_id');
			var options = {
				subcontractor_bid_status_id: subcontractor_bid_status_id,
				gc_budget_line_item_id: gc_budget_line_item_id,
				element: uploaderElement,
				gcBudgetLineItemBidInvitationDropdownContainerElement: dropdownElement
			};
			var arrFileManagerFiles = responseJSON.fileMetadata;
			gcBudgetLineItemBidInvitationUploaded(arrFileManagerFiles, options);
		};
		gcBudgetLineItemBidInvitationUploaders.fineUploader(uploaderOptions);

		gcBudgetLineItemUnsignedScopeOfWorkDocumentUploaders.each(function() {
			if ($(this).parent().find('.dropdown-placeholder').length == 0) {
				$(this).find('.qq-upload-button, .qq-upload-drop-area').addClass('has-right-sibling');
			}
		});
		gcBudgetLineItemBidInvitationUploaders.each(function() {
			if ($(this).parent().find('.dropdown-placeholder').length == 0) {
				$(this).find('.qq-upload-button, .qq-upload-drop-area').addClass('has-right-sibling');
			}
		});

		staticUploaders.addClass('hidden');

	} else {

		gcBudgetLineItemUnsignedScopeOfWorkDocumentUploaders.fineUploader('destroy');
		gcBudgetLineItemBidInvitationUploaders.fineUploader('destroy');
		staticUploaders.removeClass('hidden');

	}

	// Don't trigger the accordion.
	trapJavaScriptEvent(javaScriptEvent);

	if (!doNotCheckToggleOtherSections) {

		if ($("#checkboxToggleOtherCostCodeSections").is(':checked')) {
			$('.toggle-cost-code-level-uploaders').each(function() {
				if (this == element) {
					return;
				}
				options.doNotCheckToggleOtherSections = true;
				options.initialize = false;
				toggleDynamicUploadersAtCostCodeLevel1(this, javaScriptEvent, options);
			});
		}

	}
}

function toggleDynamicUploadersAtBidLevel(element, javaScriptEvent, options)
{
	// Trap the event to prevent double click problems
	trapJavaScriptEvent(javaScriptEvent);

	var options = options || {};
	var initialize = options.initialize;
	var doNotCheckToggleOtherSections = options.doNotCheckToggleOtherSections;

	var accordionContent = $(element).closest('.subaccordion-container').find('.subaccordion-content');
	var dynamicUploaders = accordionContent.find('.boxViewUploader');
	var staticUploaders = accordionContent.find('button.button-static-uploader');

	if (initialize == undefined) {
		if (dynamicUploaders.length == 0) {
			initialize = true;
		} else {
			initialize = false;
		}
	}

	if (initialize) {
		dynamicUploaders = accordionContent.find('.notBoxViewUploader');
		dynamicUploaders.addClass('boxViewUploader');
		dynamicUploaders.removeClass('notBoxViewUploader hidden');
		staticUploaders.addClass('hidden');
		createUploaders();

		dynamicUploaders.each(function() {
			if ($(this).siblings('.dropdown').children().length > 0) {
				$(this).find('.qq-upload-button, .qq-upload-drop-area').addClass('has-right-sibling');
			}
		});

	} else {
		var arrUploaders = accordionContent.find('.boxViewUploader');
		qq.removeEventListenersOfFileUploadersInJQueryArray(arrUploaders);
		arrUploaders.removeClass('uploaderInitialized');
		accordionContent.find('.qq-uploader').remove();
		dynamicUploaders.addClass('notBoxViewUploader hidden');
		dynamicUploaders.removeClass('boxViewUploader');
		staticUploaders.removeClass('hidden');
	}

	if (!doNotCheckToggleOtherSections) {

		if ($("#checkboxToggleOtherBidSections").is(':checked')) {
			$(".toggle-bid-level-uploaders").each(function() {
				if (this == element) {
					return;
				}
				options.doNotCheckToggleOtherSections = true;
				options.initialize = false;
				toggleDynamicUploadersAtBidLevel(this, javaScriptEvent, options);
			});
		}

	}
}

function toggleDynamicUploadersAtBidLevel1(element, javaScriptEvent, options)
{
	// Trap the event to prevent double click problems
	trapJavaScriptEvent(javaScriptEvent);

	var options = options || {};
	var initialize = options.initialize;
	var doNotCheckToggleOtherSections = options.doNotCheckToggleOtherSections;

	var accordionContent = $(element).closest('.subaccordion-container').find('.subaccordion-content');
	var dynamicUploaders = accordionContent.find('.fineUploader');
	var staticUploaders = accordionContent.find('button.button-static-uploader');

	if (initialize == undefined) {
		if (dynamicUploaders.children().length == 0) {
			initialize = true;
		} else {
			initialize = false;
		}
	}

	if (initialize) {

		var subcontractor_bid_documents_file_manager_folder_id = $("#subcontractor_bid_documents_file_manager_folder_id").val();
		var endpoint = '/modules-purchasing-file-uploader-ajax.php?folder_id=' + subcontractor_bid_documents_file_manager_folder_id;
		var uploaderElement, dropdownElement, dropdownElementHtml;
		var uploaderOptions = {
			request: {
				endpoint: endpoint
			},
			callbacks: {
				onSubmit: function(id, name) {
					// 'this' is a reference to a qq.FineUploader object.
					uploaderElement = this._options.element;
					dropdownElement = $(uploaderElement).siblings('.dropdown');
					dropdownElementHtml = dropdownElement.html();
					dropdownElement.html('<img src="/images/ajax-loader.gif">');
				},
				onError: function(id, name, errorReason, xhr) {
					dropdownElement.html(dropdownElementHtml);
					fileManagerFileUploadError(id, name, errorReason, xhr);
				},
				onComplete: function(id, name, responseJSON, xhr) {
					if (!responseJSON.success) {
						dropdownElement.html(dropdownElementHtml);
						return;
					}
					var subcontractor_bid_document_type_id = $(uploaderElement).attr('data-subcontractor_bid_document_type_id');
					var subcontractor_bid_id = $(uploaderElement).attr('data-subcontractor_bid_id');
					var options = {
						subcontractor_bid_document_type_id: subcontractor_bid_document_type_id,
						subcontractor_bid_id: subcontractor_bid_id,
						element: uploaderElement,
						subcontractorBidDocumentDropdownContainerElement: dropdownElement
					};
					var arrFileManagerFiles = responseJSON.fileMetadata;
					subcontractorBidDocumentUploaded(arrFileManagerFiles, options);
				}
			},
			validation: {
				allowedExtensions: [ 'pdf' ]
			},
			customLabel: 'Drop/Click'
		};

		dynamicUploaders.fineUploader(uploaderOptions);
		staticUploaders.addClass('hidden');

		dynamicUploaders.each(function() {
			if ($(this).siblings('.dropdown').children().length > 0) {
				$(this).find('.qq-upload-button, .qq-upload-drop-area').addClass('has-right-sibling');
			}
		});

	} else {

		dynamicUploaders.fineUploader('destroy');
		staticUploaders.removeClass('hidden');

	}

	if (!doNotCheckToggleOtherSections) {

		if ($("#checkboxToggleOtherBidSections").is(':checked')) {
			$(".toggle-bid-level-uploaders").each(function() {
				if (this == element) {
					return;
				}
				options.doNotCheckToggleOtherSections = true;
				options.initialize = false;
				toggleDynamicUploadersAtBidLevel1(this, javaScriptEvent, options);
			});
		}

	}
}

function toggleAllDynamicUploaders(element, javaScriptEvent)
{
	var dynamicUploaders = $(".boxViewUploader");
	var staticUploaders = $("button.button-static-uploader");

	qq.removeEventListenersOfFileUploadersInJQueryArray(dynamicUploaders);
	$(".qq-uploader").remove();

	dynamicUploaders.removeClass('boxViewUploader uploaderInitialized');
	dynamicUploaders.addClass('notBoxViewUploader hidden');
	staticUploaders.removeClass('hidden');

}

function toggleAllDynamicUploadersNoEvent(element)
{
	var dynamicUploaders = $(".boxViewUploader");
	var staticUploaders = $("button.button-static-uploader");

	qq.removeEventListenersOfFileUploadersInJQueryArray(dynamicUploaders);
	$(".qq-uploader").remove();

	dynamicUploaders.removeClass('boxViewUploader uploaderInitialized');
	dynamicUploaders.addClass('notBoxViewUploader hidden');
	staticUploaders.removeClass('hidden');

}

function toggleAllDynamicUploaders1(element, javaScriptEvent)
{
	$(".fineUploader").fineUploader('destroy');
	$("button.button-static-uploader").removeClass('hidden');
}

function updateSubcontractorBidAndReloadBiddingContentViaPromiseChain(element, options)
{
	try {

		var options = options || {};
		options.promiseChain = true;

		var subcontractor_bid_status = $(element).find('option:selected').html();
		active_subcontractor_bid_status = subcontractor_bid_status;

		var promise = updateSubcontractorBid(element, options);
		promise.then(function() {
			var loadOptions = {};
			loadOptions.toggleAdvancedMode = true;
			loadBiddingContent(loadOptions);
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadBiddingContent(options)
{
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		var addition_param = '';
		if (typeof (options.toggleAdvancedMode) != 'undefine') {
			addition_param += '&toggleAdvancedMode=1';
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bidding-ajax.php?method=loadBiddingContent' + addition_param;
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
			success: loadBiddingContentSuccess,
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

function loadBiddingContentSuccess(data, textStatus, jqXHR)
{
	try {

		// Capture the current state of the accordions before we replace the
		// content of the page.
		var arrOpenAccordionTitles = getOpenAccordionTitles();
		var arrOpenSubaccordionTitles = getOpenSubaccordionTitles();

		// Check to see if we want to open the accordion that the bidder moves to.
		if ($("#checkboxFollowBidder").is(':checked')) {
			if (arrOpenAccordionTitles.indexOf(active_subcontractor_bid_status) == -1) {
				arrOpenAccordionTitles.push(active_subcontractor_bid_status);
			}
		}

		$("#divBidding").html(data);

		reinitializeWidgetsAndOpenSpecifiedAccordions(arrOpenAccordionTitles, arrOpenSubaccordionTitles);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function getOpenAccordionTitles()
{
	var arrOpenAccordionTitles = [];
	$('.accordion-header.ui-state-active span.title').each(function() {
		var openAccordionTitle = $(this).html();
		arrOpenAccordionTitles.push(openAccordionTitle);
	});

	return arrOpenAccordionTitles;
}

function getOpenSubaccordionTitles()
{
	var arrOpenSubaccordionTitles = [];
	$('.subaccordion-header.ui-state-active span.title').each(function() {
		var openSubaccordionTitle = $(this).html();
		arrOpenSubaccordionTitles.push(openSubaccordionTitle);
	});

	return arrOpenSubaccordionTitles;
}

function getAccordionElementsFromAccordionTitles(arrAccordionTitles)
{
	var arrAccordionElements = [];
	for (var i = 0; i < arrAccordionTitles.length; i++) {
		var accordionTitle = arrAccordionTitles[i];
		$(".accordion-header").each(function() {
			var tempAccordionTitle = $(this).find('span.title').html();
			if (accordionTitle == tempAccordionTitle) {
				arrAccordionElements.push(this);
			}
		});
	}

	return $(arrAccordionElements);
}

function getSubaccordionElementsFromSubaccordionTitles(arrSubaccordionTitles)
{
	var arrSubaccordionElements = [];
	for (var i = 0; i < arrSubaccordionTitles.length; i++) {
		var subaccordionTitle = arrSubaccordionTitles[i];
		$(".subaccordion-header").each(function() {
			var tempSubaccordionTitle = $(this).find('span.title').html();
			if (subaccordionTitle == tempSubaccordionTitle) {
				arrSubaccordionElements.push(this);
			}
		});
	}

	return $(arrSubaccordionElements);
}

function fileManagerFileUploadError(id, name, errorReason, xhr) {
	Console.log('fileManagerFileUploadError: ' + errorReason);
}

function reinitializeWidgetsAndOpenSpecifiedAccordions(arrOpenAccordionTitles, arrOpenSubaccordionTitles)
{
	// Hide html, remove click handlers, and destroy accordions so
	// everything can be re-initialized properly.
	$("#divBidding").css('opacity', 0);
	$("#divBidding").css('visibility', 'hidden');
	$(".accordion-container").accordion('destroy');
	$(".accordion-container").off('click', accordionCustomClickHandler);
	$(".subaccordion-container").off('click', subaccordionCustomClickHandler);

	// To avoid the flash of accordions expanding/collapsing during initialization,
	// have a callback function to take care of nice presentation.
	addWidgets({ animationCallback: animationCallback });

	// We need this function in nested scope because we captured the state of
	// the accordions in the closure variables.
	function animationCallback() {
		var arrAccordionElements = getAccordionElementsFromAccordionTitles(arrOpenAccordionTitles);
		var arrSubaccordionElements = getSubaccordionElementsFromSubaccordionTitles(arrOpenSubaccordionTitles);
		var collapse = false;
		expandAccordionGroup(arrAccordionElements, collapse);
		expandAccordionGroup(arrSubaccordionElements, collapse);
		$("#divBidding").css('opacity', 0);
		$("#divBidding").css('visibility', '');
		$("#divBidding").animate({ opacity: 1 }, 'slow', 'easeInExpo');
	}

}

function toggleBiddingModuleExpertMode(element, javaScriptEvent)
{
	// Trap the event to prevent double click problems
	trapJavaScriptEvent(javaScriptEvent);

	//var currentVisibility = $("#biddingExpertModeState").css('visibility');
	var currentVisibility = $("#biddingExpertModeState").val();

	// Debug
	/*
	if (window.ajaxUrlDebugMode) {
		alert(currentVisibility);
	}
	*/

	if (currentVisibility == 'hidden') {
		$(".biddingExpertMode ").css('visibility', 'visible');
		$("#biddingExpertModeState").val('visible');
	} else if (currentVisibility == 'visible') {
		$(".biddingExpertMode ").css('visibility', 'hidden');
		$("#biddingExpertModeState").val('hidden');
	}
}

function uncheckAll_BiddingModuleFiles_Checkboxes()
{

	try {

		// Uncheck all bidder file checkboxes
		assignCheckboxStatesByCssClassSelectorPrefix('bidding-module-files-', false);

		// Uncheck "Toggle Default Documents" Checkbox
		$("#bidding-module-bidders--checkDefaultBidderDocuments").prop('checked', false);

		/*
		// Uncheck checkboxes with the following classes:
		// All select-all-files checkboxes
		//bidding-module-files-select-all-checkbox
		$(".bidding-module-files-select-all-checkbox").prop('checked', false);

		// Global Project Bid Invites
		//bidding-module-files--project_bid_invitations--project_bid_invitation_id
		$(".bidding-module-files--project_bid_invitations--project_bid_invitation_id").prop('checked', false);

		// Cost-code level Unsigned Scopes Of Work
		//bidding-module-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id
		$(".bidding-module-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id").prop('checked', false);

		// Cost-code level Bid Invites
		//bidding-module-files--gc_budget_line_item_bid_invitations--gc_budget_line_item_bid_invitation_id
		$(".bidding-module-files--gc_budget_line_item_bid_invitations--gc_budget_line_item_bid_invitation_id").prop('checked', false);

		// Bidder specific files (subcontractor_bid_documents)
		//bidding-module-files--subcontractor_bid_documents--subcontractor_bid_document_id
		$(".bidding-module-files--subcontractor_bid_documents--subcontractor_bid_document_id").prop('checked', false);
		*/

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/*
//function handle_BiddingModuleBidder_GlobalSelectAllCheckboxContainer_ClickEvent(checkboxElementId, checkboxClass, checkboxGrouping)
function handle_BiddingModuleBidder_GlobalSelectAllCheckboxContainer_ClickEvent(checkboxElementId)
{
	// Debug
	//alert(containerElement);

	//var checkboxElement = $(checkboxElementId);

	$("#" + checkboxElementId).click();

	//var checkboxElement = $(containerElement).find('input[type=checkbox]');
	//alert(checkboxElement);

	// Debug
	//var tmpId = $(checkboxElement).attr('id');
	//alert(tmpId);

	//var checked = $(checkboxElement).is(':checked') || false;
	//$(checkboxElement).prop('checked', !checked);

	//handle_BiddingModuleBidder_GlobalSelectAllCheckbox_ClickEvent(checkboxElement, checkboxClass, checkboxGrouping);
}
*/

/**
 * Toggle all bidding module "Bidder" checkboxes in the list to be checked or unchecked.
 *
 * @param {object} element - Reference to the checkbox being checked or unchecked
 * @param {event} originalJavaScriptEvent - JavaScript native event
 * @param {string} checkboxClass - CSS selector class to toggle
 * @param {string} checkboxGrouping - Grouping label of checkboxes to manipulate
 * @return void
 */
function handle_BiddingModuleBidder_GlobalSelectAllCheckbox_ClickEvent(element, originalJavaScriptEvent, checkboxClass, checkboxGrouping)
{
	// Trap the event
	trapJavaScriptEvent(originalJavaScriptEvent);

	var checked = $(element).is(':checked') || false;
	var arrCheckboxIdsToUncheck = [];
	var arrCheckboxClassesToUncheck = [];
	var arrCheckboxIdsToCheck = [];
	var arrCheckboxClassesToCheck = [];

	if (checkboxGrouping == 'select-all-bidders') {

		// bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id
		if (checked) {
			var arrCheckboxIdsToCheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1', 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2', 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3'];
			var arrCheckboxClassesToUncheck = [];
		} else {
			var arrCheckboxIdsToUncheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1', 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2', 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3'];
		}

	} else if (checkboxGrouping == 'select-all-bidders-with-potential-bidder-status') {

		// bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1
		if (checked) {
			//var arrCheckboxIdsToUncheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id', 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2', 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3'];
			//var arrCheckboxClassesToUncheck = ['bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2', 'bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3'];
			var arrCheckboxIdsToUncheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id'];
		} else {
			var arrCheckboxIdsToUncheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id'];
		}

	} else if (checkboxGrouping == 'select-all-bidders-with-bid-received-status') {

		// bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2
		if (checked) {
			//var arrCheckboxIdsToUncheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id', 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1', 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3'];
			//var arrCheckboxClassesToUncheck = ['bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1', 'bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3'];
			var arrCheckboxIdsToUncheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id'];
		} else {
			var arrCheckboxIdsToUncheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id'];
		}

	} else if (checkboxGrouping == 'select-all-bidders-with-declined-to-bid-status') {

		// bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3
		if (checked) {
			//var arrCheckboxIdsToUncheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id', 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1', 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2'];
			//var arrCheckboxClassesToUncheck = ['bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1', 'bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2'];
			var arrCheckboxIdsToUncheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id'];
		} else {
			var arrCheckboxIdsToUncheck = ['bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id'];
		}

	}

	//arrCheckboxClassesToUncheck.push('bidding-module-bidders-select-all-checkbox');

	toggleCheckboxes(element, checkboxClass, arrCheckboxIdsToUncheck, arrCheckboxClassesToUncheck, arrCheckboxIdsToCheck, arrCheckboxClassesToCheck);

	// Toggle gc_budget_line_items (cost code) level checkboxes on or off
	if (checkboxGrouping == 'select-all-bidders') {

		$(".bidding-module-bidders-select-all-checkbox--subcontractor_bids--gc_budget_line_item_id").prop('checked', checked);

	} else {

		// Test if "Select All" should be checked
		var subcontractor_bid_status_groups_1 = 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1';
		var subcontractor_bid_status_groups_2 = 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--2';
		var subcontractor_bid_status_groups_3 = 'bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--3';

		var subcontractor_bid_status_groups_1_checked = $("#" + subcontractor_bid_status_groups_1).is(':checked') || false;
		var subcontractor_bid_status_groups_2_checked = $("#" + subcontractor_bid_status_groups_2).is(':checked') || false;
		var subcontractor_bid_status_groups_3_checked = $("#" + subcontractor_bid_status_groups_3).is(':checked') || false;

		// Check the global select all checkbox
		if ( subcontractor_bid_status_groups_1_checked && subcontractor_bid_status_groups_2_checked && subcontractor_bid_status_groups_3_checked ) {
			$("#bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id").prop('checked', true);
		}
	}

}

function handle_BiddingModuleBidder_GcBudgetLineItem_SelectAllCheckbox_ClickEvent(element, subcontractor_bid_status_group_id, gc_budget_line_item_id)
{

	// Uncheck the corresponding groups of checkboxes when the bidder checkbox is unchecked
	var checked = $(element).is(':checked') || false;

	// Toggle the local bidder checkboxes in this group to match
	$(".bidding-module-bidders-checkbox-subcontractor_bid_status_group_id-" + subcontractor_bid_status_group_id + "--subcontractor_bids--gc_budget_line_item_id--" + gc_budget_line_item_id).prop('checked', checked);

	// Unchecked state
	if (checked ==  false) {

		// Uncheck some of the global "select all" checkboxes
		// 1) Always uncheck the global select all checkbox
		$("#bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id").prop('checked', false);

		// 2) Uncheck the global select all checkbox of the same grouping
		$("#bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--" + subcontractor_bid_status_group_id).prop('checked', false);

	} else {

		check_BiddingModuleBidder_SelectAllCheckboxes_IfAllCheckboxesInGroupAreChecked(element, subcontractor_bid_status_group_id, gc_budget_line_item_id);

	}

}

function handle_BiddingModuleBidder_SubcontractorBid_Checkbox_ClickEvent(element, subcontractor_bid_status_group_id, gc_budget_line_item_id)
{

	// Uncheck the corresponding groups of checkboxes when the bidder checkbox is unchecked
	var checked = $(element).is(':checked') || false;

	if (checked) {

		check_BiddingModuleBidder_SelectAllCheckboxes_IfAllCheckboxesInGroupAreChecked(element, subcontractor_bid_status_group_id, gc_budget_line_item_id);

	} else {

		// Uncheck some of the global "select all" checkboxes
		// 1) Always uncheck the global select all checkbox
		$("#bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id").prop('checked', false);

		// 2) Uncheck the global select all checkbox of the same grouping
		$("#bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--" + subcontractor_bid_status_group_id).prop('checked', false);

		// 3) Uncheck the local gc_budget_line_item_id (cost code) level <subcontractor_bid_status_group_id, gc_budget_line_item_id> "select all" checkbox
		$("#bidding-module-bidders-select-all-checkbox-subcontractor_bid_status_group_id-" + subcontractor_bid_status_group_id + "--subcontractor_bids--gc_budget_line_item_id--" + gc_budget_line_item_id).prop('checked', false);

	}

}

function check_BiddingModuleBidder_SelectAllCheckboxes_IfAllCheckboxesInGroupAreChecked(element, subcontractor_bid_status_group_id, gc_budget_line_item_id)
{
	// Sanity check
	var checked = $(element).is(':checked') || false;

	if (checked == false) {
		return;
	}

	// Check for "All Checkboxes Checked" case at all three levels - can progressively check for efficiency
	// Local gc_budget_line_items level
	// bidding-module-bidders-checkbox-subcontractor_bid_status_group_id-$subcontractor_bid_status_group_id--subcontractor_bids--gc_budget_line_item_id--$gc_budget_line_item_id
	var gcBudgetLineItemCheckboxClass = 'bidding-module-bidders-checkbox-subcontractor_bid_status_group_id-' + subcontractor_bid_status_group_id + '--subcontractor_bids--gc_budget_line_item_id--' + gc_budget_line_item_id;

	// subcontractor_bid_status_groups level
	// bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--$subcontractor_bid_status_group_id
	var subcontractorBidStatusGroupCheckboxClass = 'bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--' + subcontractor_bid_status_group_id;

	// All bidders global level
	// bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id
	var allSubcontractorBidsCheckboxClass = 'bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id';

	// Local gc_budget_line_items level
	// Check if all checkboxes in local gc_budget_line_items group are checked and then check the local "Select All" checkbox
	var loopExecuted = false;
	var allGcBudgetLineItemCheckboxesAreChecked = true;
	$("." + gcBudgetLineItemCheckboxClass).each(function () {
		if (!loopExecuted) {
			loopExecuted = true;
		}

		if ($(this).is(':checked') == false) {
			allGcBudgetLineItemCheckboxesAreChecked = false;

			// "break" out the each loop
			return false;
		}
	});

	if (!loopExecuted) {
		allGcBudgetLineItemCheckboxesAreChecked = false;
	}

	// Local gc_budget_line_items level
	// All checkboxes in the local group are checked so check the "Select All" box
	if (allGcBudgetLineItemCheckboxesAreChecked) {

		// Check the "Select All" box
		$("#bidding-module-bidders-select-all-checkbox-subcontractor_bid_status_group_id-" + subcontractor_bid_status_group_id + "--subcontractor_bids--gc_budget_line_item_id--" + gc_budget_line_item_id).prop('checked', true);

		// Now check a larger group
		loopExecuted = false;
		var allSubcontractorBidStatusGroupCheckboxesAreChecked = true;
		$("." + subcontractorBidStatusGroupCheckboxClass).each(function () {
			if (!loopExecuted) {
				loopExecuted = true;
			}

			if ($(this).is(':checked') == false) {
				allSubcontractorBidStatusGroupCheckboxesAreChecked = false;

				// "break" out the each loop
				return false;
			}
		});

		if (!loopExecuted) {
			allSubcontractorBidStatusGroupCheckboxesAreChecked = false;
		}

		// subcontractor_bid_status_groups level
		if (allSubcontractorBidStatusGroupCheckboxesAreChecked) {

			// Check the "Select All" box
			$("#bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--" + subcontractor_bid_status_group_id).prop('checked', true);

			/// All bidders global level
			// Check if all checkboxes in local gc_budget_line_items group are checked and then check the local "Select All" checkbox
			var loopExecuted = false;
			var allSubcontractorBidCheckboxesAreChecked = true;
			$("." + allSubcontractorBidsCheckboxClass).each(function () {
				if (!loopExecuted) {
					loopExecuted = true;
				}

				if ($(this).is(':checked') == false) {
					allSubcontractorBidCheckboxesAreChecked = false;

					// "break" out the each loop
					return false;
				}
			});

			if (!loopExecuted) {
				allSubcontractorBidCheckboxesAreChecked = false;
			}

			if (allSubcontractorBidCheckboxesAreChecked) {
				// Check the "Select All" box
				$("#bidding-module-bidders-select-all-checkbox--subcontractor_bids--subcontractor_bid_id").prop('checked', true);

				// We decided to allow multiple subcontractor_bid_status_groups sections to be checked so below is commented out
				// Uncheck the other global select all checkboxes (only one checked at a time)
				//$("#bidding-module-bidders-select-all-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--" + subcontractor_bid_status_group_id).prop('checked', false);
			}

		}

	}

}

/**
 * Toggle all bidding file checkboxes in the list to be checked or unchecked.
 *
 * @param {object} element
 * @return void
 */
function toggleAllChildBidDocuments(element, javaScriptEvent)
{

	// Trap the event to prevent double click problems
	trapJavaScriptEvent(javaScriptEvent);

	// we only want to get the ul.dropdown-menu
	//var directParentUl = $(element).parents('ul.dropdown-menu');
	var directParentUl = $(element).closest('ul');

	// find all the checkboxes
	children = $(directParentUl).find('input');

	for (var i = 0; i < children.length; i++) {
		// Set the checkbox state to match the parent "Select All" checkbox
		$(children[i]).prop('checked', element.checked);
	}
}

function uncheckSelectAllBidderFileCheckboxes(element)
{
	toggleCheckboxes(element, 'bidding-module-files-select-all-checkbox');
}

function deleteBidderFrom_BiddingModuleEmailModalDialog(subcontractor_bid_id, bidderDisplayEmail)
{
	var continueDelete = window.confirm('Are you sure you want to remove: ' + bidderDisplayEmail + '?');
	if (continueDelete === true) {
		//    To section: record_container--bidding-module-email-modal-dialog-subcontractor-contact-email--subcontractor_bids--subcontractor_bid_id--{subcontractor_bid_id}
		// Files Section: record_container--bidding-module-email-modal-dialog-subcontractor-bid-details--subcontractor_bids--subcontractor_bid_id--{subcontractor_bid_id}
		var bidderEmailContainerElementId = 'record_container--bidding-module-email-modal-dialog-subcontractor-contact-email--subcontractor_bids--subcontractor_bid_id--' + subcontractor_bid_id;
		var bidderDetailsContainerElementId = 'record_container--bidding-module-email-modal-dialog-subcontractor-bid-details--subcontractor_bids--subcontractor_bid_id--' + subcontractor_bid_id;
		var arrDomElementIds = [bidderEmailContainerElementId, bidderDetailsContainerElementId];

		removeDomElementList(arrDomElementIds);
	}
}

/**
 this function will help to add or remove strike-through class for td
*/
function biddingModuleEmailDialogCheckboxState(elementCheckbox)
{
	// elementCheckbox.checked;
	var parentTDContainer = $(elementCheckbox).closest('td');
	if (elementCheckbox.checked) {
		$(parentTDContainer).removeClass("strike-through");
	}
	else {
		$(parentTDContainer).addClass("strike-through");
	}
}
/**
 * function to check/uncheck project level one latest
 * 1. bid invitation 2. GcBudgetLineItemBidInvitation 3. unsigned scope of work documents
 *
 *
 */
function checkDefaultBidderDocuments(element, javaScriptEvent)
{

	// Trap the event to prevent double click problems
	trapJavaScriptEvent(javaScriptEvent);

	// project level bid invitation
	// project_bid_invitations
	$(".bidding-module-files--project_bid_invitations--project_bid_invitation_id:first").prop('checked', element.checked);

	// iterate over checked subcontractor bidders
	$(".bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id:checked").each( function(key, value) {

		// Parse the css classes
		// E.g.
		// bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id
		// bidding-module-bidders-checkbox-subcontractor_bid_status_group_id-1--subcontractor_bids--gc_budget_line_item_id--260
		// bidding-module-bidders-checkbox--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--1

		//var checkbox = $(this);
		//var classNames = $(checkbox).attr('class').split(/\s+/);
		var cssClassNames = $(this).attr('class').split(/\s+/);

		// The second and third css class names contain id values that we need
		var secondClassName = cssClassNames[1];
		var thirdClassName = cssClassNames[2];

		// Derive the gc_budget_line_item_id value
		var arrParts = secondClassName.split('--');
		var gc_budget_line_item_id = arrParts[3];

		// Derive the subcontractor_bid_status_group_id value
		var arrParts = thirdClassName.split('--');
		var subcontractor_bid_status_group_id = arrParts[3];

		// GcBudgetLineItemBidInvitation

		// Cost code level bid invite
		// gc_budget_line_item_bid_invitations
		$('.bidding-module-files-subcontractor_bid_status_group_id-' + subcontractor_bid_status_group_id
			+ '--gc_budget_line_item_bid_invitations--gc_budget_line_item_id--' + gc_budget_line_item_id + ':first').prop('checked', element.checked);

		// Cost code level unsigned scope of work document
		// gc_budget_line_item_unsigned_scope_of_work_documents
 		$('.bidding-module-files-subcontractor_bid_status_group_id-' + subcontractor_bid_status_group_id
			+ '--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_id--' + gc_budget_line_item_id + ':first').prop('checked', element.checked);

	});
}

/**
 * function to check/uncheck bidder level unsigned scope of work documents
 *
 *
 */
function checkBidderSpecificUnsignedScopeOfWork(element, javaScriptEvent)
{

	// Trap the event to prevent double click problems
	trapJavaScriptEvent(javaScriptEvent);

	$(".bidding-module-bidders-checkbox--subcontractor_bids--subcontractor_bid_id:checked").each(function() {

		var cssClassNames = $(this).attr('class').split(/\s+/);

		// The second and third css class names contain id values that we need
		var secondClassName = cssClassNames[1];
		var thirdClassName = cssClassNames[2];

		// Derive the gc_budget_line_item_id value
		var arrParts = secondClassName.split('--');
		var gc_budget_line_item_id = arrParts[3];

		// Derive the subcontractor_bid_status_group_id value
		var arrParts = thirdClassName.split('--');
		var subcontractor_bid_status_group_id = arrParts[3];

		var subcontractor_bid_id = this.value;

		var subcontractorBidDivId = '#bidding-module-files-bootstrap-dropdown--subcontractor_bid_documents--subcontractor_bid_id-subcontractor_bid_document_type_id--'
			+ subcontractor_bid_id + '-' + UNSIGNED_SCOPE_OF_WORK_DOCUMENT_TYPE_ID;

		var unsignedScopeOfWorkCssClass = 'bidding-module-files--subcontractor_bid_status_groups--subcontractor_bid_status_group_id--' + subcontractor_bid_status_group_id;

		$(subcontractorBidDivId).find('input:checkbox.' + unsignedScopeOfWorkCssClass + ':first').prop('checked', element.checked);

	});
}

function Bidding__createGcBudgetLineItemBidInvitation(attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Bidding__createGcBudgetLineItemBidInvitationSuccess;

		createGcBudgetLineItemBidInvitation(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Bidding__createGcBudgetLineItemBidInvitationSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var previousAttributeGroupName = json.previousAttributeGroupName;
			var dummyId = json.dummyId;
			var refreshWindow = json.refreshWindow;
			var refreshWindowDomContainer = json.refreshWindowDomContainer;
			var refreshWindowAjaxUrl = json.refreshWindowAjaxUrl;

			var recordContainerElementIdOld = 'record_container--' + previousAttributeGroupName + '--' + attributeSubgroupName + '--' + dummyId;

			if (refreshWindow) {
				window.location.reload(true);
			}

			if (refreshWindowDomContainer) {
				$(refreshWindowDomContainer).load(refreshWindowAjaxUrl);
			}

			// @todo Implement DOM swap out code for id and onchange...
			$("#" + recordContainerElementIdOld).remove();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
this function is to set checkall dropdown to select or unselected
depended on if all sublings are checked or one is unchecked.
**/
function uploadFileDropdownUpcheckState(element)
{

	var directParentUl = $(element).closest('ul.dropdown-menu-cancel-collapse');

	// find all the checkboxes
	if ($(element).hasClass('bidding-module-files-select-all-checkbox') === true) {
		// this is check all box, no need to evaluate
		return;
	}

	children = $(directParentUl).find('input');

	if (children.length > 0) {

		var checkboxCounter = 0;
		// there is no check all checkbox : return
		if ($(children[0]).hasClass('bidding-module-files-select-all-checkbox') === false) {
			return;
		} else {

			// now deal with the sublings
			for (var i = 1; i < children.length; i++) {
				if (children[i].checked === true) {
					checkboxCounter++;
				} else {
					// at least one is uncheck. uncheck the checkallbox
					$(children[0]).prop('checked', false);
				}
			}

			// if number of check equal the length - checkall
			if (checkboxCounter === (children.length - 1)) {
				$(children[0]).prop('checked', true);
			} else {
				$(children[0]).prop('checked', false);
			}

		}

	}
}
