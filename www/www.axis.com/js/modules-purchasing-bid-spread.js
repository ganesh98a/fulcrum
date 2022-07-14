var focusedElementId;

function Subcontractor_Bid_Spreadsheet__reloadWindow()
{
	if (focusedElementId) {
		ClientVars.set('focusedElementId', focusedElementId);
	}
	window.location.reload(false);
}

(function($) {
	$(document).ready(function() {

		Subcontractor_Bid_Spreadsheet__updateAllBidTotalSummarySections();

		// Set the focus to the element that had focus before we refreshed the page
		var focusedElementId = ClientVars.get('focusedElementId');
		if (focusedElementId) {
			$("#" + focusedElementId).focus();
		}
		$(":input").focus(function () {
			focusedElementId = this.id;
		});

		$("#spreadTable tbody").sortable({
			axis: 'y',
			cursor: 'move',
			//helper: Subcontractor_Bid_Spreadsheet__sortHelper,
			helper: sortHelper,
			items: 'tr:not(.notSortable)',
			// "update" fires when the drop or drag stops, but only if the position changed
			update: function(event, ui) {
				var element = $(ui.item)[0];
				var endIndex = $(element).index();
				endIndex=Number(endIndex-3);
				endIndex = endIndex.toString();
				var options = { endIndex: endIndex };
				Subcontractor_Bid_Spreadsheet__updateBidItem(element, options);
			}
		});

		// Hide tooltip when sortable-ing.
		$('img[rel=tooltip]').on('mousedown', function() {
			$(this).tooltip('hide');
		});

		//$(".number-only").numeric({ negative: true }, function() { alert("Positive integers only"); this.value = ''; this.focus(); });
		//$(".number-only").numeric({ negative: true });

		Subcontractor_Bid_Spreadsheet__adjustFormElementSizes();
		Subcontractor_Bid_Spreadsheet__addKeyEventListeners();

		$('[rel=tooltip]').tooltip();

		var bidSpreadDetailsRowHidden = ClientVars.get('bidSpreadDetailsRowHidden');
		if (bidSpreadDetailsRowHidden) {
			$('.detailsRow').addClass('hidden');
		} else {
			$('.detailsRow').removeClass('hidden');
		}

		//Subcontractor_Bid_Spreadsheet__addDataTablesToSpread();
		$(document).keydown(
		function(e)
		{    
		if (e.keyCode == 39) {      
		    $(".keymove:focus").next().focus();
		}
		if (e.keyCode == 37) {      
		    $(".keymove:focus").prev().focus();
		}
		}
		);
	});
})(jQuery);

function Subcontractor_Bid_Spreadsheet__addDataTablesToSpread()
{
	$("#spreadTable").DataTable({
		'language': {
			'decimal': '.',
			'thousands': ','
		},
		'lengthMenu': [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, 'All']],
		'order': [[ 0, 'desc' ]],
		'pageLength': 10,
		'pagingType': 'full_numbers',
		'columns': [
			{ 'orderable': false },
			{ 'orderable': true },
			{ 'orderable': true },
			{ 'orderDataType': 'dom-text', type: 'string' },
			{ 'orderDataType': 'dom-text', type: 'string' },
			{ 'orderable': true },
			{ 'orderable': true },
			{ 'orderable': true },
			{ 'orderable': false },
			{ 'orderable': true },
			{ 'orderable': true },
			{ 'orderDataType': 'dom-text', type: 'string' },
			{ 'orderable': false }
		]
	});

	//$("#tblTabularData tbody tr:odd").css( "background-color", "#efefef" );
}

/*
// Not in use in sortable above
// Each form text input has a style width setting so not really needed.
var Subcontractor_Bid_Spreadsheet__sortHelper = function(e, tr)
{
	var $originals = tr.children();
	var $helper = tr.clone();
	$helper.children().each(function(index)
	{
		$(this).width($originals.eq(index).width());
		$(this).css('border-top', 'solid 1px black');
		if (index == 0) {
			$(this).css('border-left', 'solid 1px black');
		}
	});

	return $helper;
};
*/

function Subcontractor_Bid_Spreadsheet__addKeyEventListeners()
{
	$("#spreadTable td input").keydown(function(e) {
		if (e.keyCode == 13) {
			// Get the attribute name of the element with focus. We want to assign focus
			// to the element with this attribute name in the next row (or previous row
			// if the shift key is held down).
			var elementId = e.target.id;
			var arrTemp = elementId.split('--');
			var attributeName = arrTemp[2];

			// When there are multiple subcontractor bids, there are multiple elements
			// with the same attribute name per row. We need to capture the index of the
			// currently focused element.
			var tr = $(this).closest('tr');
			var index = 0;
			var self = this;
			tr.find('.' + attributeName).each(function() {
				if (this == self) {
					return false;
				}
				index++;
			});

			// Move focus up one row if the shift key is held down. Move focus
			// down one row otherwise.
			var nextTr = e.shiftKey ? tr.prev() : tr.next();

			// Assign focus to the element in the next row with the specified attribute name and index.
			var nextInput = nextTr.find('.' + attributeName)[index];
			// Skip the ones that aren't visible.
			while (nextInput && $(nextInput).hasClass('hidden')) {
				nextTr = e.shiftKey ? nextTr.prev() : nextTr.next();
				nextInput = nextTr.find('.' + attributeName)[index];
			}

			if (nextInput) {
				nextInput.focus();
				nextInput.select();
			}
			return false;
		}

		if ($(this).is(":checkbox").length) {
			var messageText = "keydown";
			messageAlert(messageText, 'successMessage');
		}
		var rowIndex = 0;
		var tdIndex = 0;
		var inputIndex = 0;
		if ((e.keyCode > 36 && e.keyCode < 41) || e.keyCode == 13) {
			rowIndex = $(this).parent().parent().index("#spreadTable tbody tr");
			tdIndex = $(this).parent().index("#spreadTable tbody tr:eq("+rowIndex+") td");
			inputIndex = $(this).index();
		}
		if (e.keyCode == 38) {
			//alert( "up pressed" + this );
			rowIndex = parseInt(rowIndex) - 1;
			for ( var i = rowIndex; i >= 0; i-- ) {
				if ($("#spreadTable tbody tr").eq(i).find('td').eq(tdIndex).find('input:not(:disabled):visible').eq(inputIndex).length != 0 ) {
					rowIndex = i;
					break;
				}
			}
			//if ($('#spreadTable tbody tr').eq(rowIndex).find('td').eq(tdIndex).find('input:not(:disabled)').eq(inputIndex).length == 0 ) {
				// If the row is subtotal try going past it.
				//rowIndex = parseInt(rowIndex) - 1;
			//}
			$("#spreadTable tbody tr").eq(rowIndex).find('td').eq(tdIndex).find('input:not(:disabled)').eq(inputIndex).select();
			return false;
		} else if (e.keyCode == 40 || e.keyCode == 13) {
			//alert( "down pressed" + this );
			rowIndex = parseInt(rowIndex) + 1;
			for ( var i = rowIndex; i < $("#spreadTable tbody tr").length; i++ ) {
				if ($("#spreadTable tbody tr").eq(i).find('td').eq(tdIndex).find('input:not(:disabled):visible').eq(inputIndex).length != 0 ) {
					rowIndex = i;
					break;
				}
			}
			//if ($('#spreadTable tbody tr').eq(rowIndex).find('td').eq(tdIndex).find('input:not(:disabled)').eq(inputIndex).length == 0 ) {
				// If the row is subtotal try going past it.
				//rowIndex = parseInt(rowIndex) + 1;
			//}
			if (e.keyCode == 13) {
				tdIndex = 1;
			}
			$("#spreadTable tbody tr").eq(rowIndex).find('td').eq(tdIndex).find('input:not(:disabled)').eq(inputIndex).select();
			return false;
		} else if (e.keyCode == 37 || e.keyCode == 39) {
			var cPos = doGetCaretPosition(this);
			if ((e.keyCode == 37 && cPos == 0) || (e.keyCode == 39 && cPos == $(this).val().length) ) {
				inputCount = parseInt($(this).parent().parent().find('input:not(:disabled)').length);
				inputIndex = parseInt($(this).parent().parent().find('input:not(:disabled)').index(this));
				if (e.keyCode == 37) {
					if (inputIndex == 0) {
						// It is the first input in the row
						// Set it to the last of the previous row
						rowIndex = parseInt(rowIndex) - 1;
						inputIndex = $("#spreadTable tbody tr").eq(rowIndex).find('input:not(:disabled)').length - 1;
						//inputIndex = parseInt(inputCount) -1; // Count versus zero-based index

						if ($("#spreadTable tbody tr").eq(rowIndex).find('input:not(:disabled)').eq(inputIndex).length == 0 ) {
							// If the row is subtotal try going past it.
							rowIndex = parseInt(rowIndex) - 1;
						}
					} else {
						inputIndex = parseInt(inputIndex) - 1;
					}
				} else if (e.keyCode == 39) {
					if (inputIndex == (inputCount - 1)) {
						// It is the last input in the row
						// Set it to the first of the next row
						inputIndex = 0;
						rowIndex = parseInt(rowIndex) + 1;
						if ($("#spreadTable tbody tr").eq(rowIndex).find('input:not(:disabled)').eq(inputIndex).length == 0 ) {
							// If the row is subtotal try going past it.
							rowIndex = parseInt(rowIndex) + 1;
						}
					} else {
						inputIndex = parseInt(inputIndex) + 1;
					}
				}
				var theInput = $("#spreadTable tbody tr").eq(rowIndex).find('input:not(:disabled)').eq(inputIndex);
				theInput.focus();
				theInput.select();
				//$('#spreadTable tbody tr').eq(rowIndex).find('input:not(:disabled)').eq(inputIndex).select();
				//$(this).parent().parent().find('input').eq(inputIndex).select();
				return false;
			}
		}
	});
}

function Subcontractor_Bid_Spreadsheet__adjustFormElementSizes()
{
	// Debug
	//return;

	// Don't adjust any sizes for the subcontractor's interface.
	var isSubcontractorInterface = $("#isSubcontractorInterface").val();
	if (isSubcontractorInterface == 'true') {
		return;
	}

	// BidItem.bid_item Inputs
	// var newSize = 240;
	// $(".bid_item").each(function() {
	// 	var size = $(this).val().length * 6;
	// 	if (size > newSize) {
	// 		newSize = size;
	// 	}
	// });
	// $(".bid_item").css('max-height', newSize + 20);

	// var newbid = 55;
	$(".bid_item").each(function() {
		// var size = $(this).val().length;
		// if (size > newbid) {
		// 	newbid = 35;
		// 	$("#"+this.id).css('max-height', newbid);
		// }
		$(this).height(0).height(this.scrollHeight);

	});
	//autoexpand textarea on entering content
	$(".bid_item").on('input',function() {
		$(this).height(0).height(this.scrollHeight);
	});
	
	// return and arrow keys should move to next input
	var inputs = $('textarea').keydown(function(e){ 

		if (e.which == 13 || e.which == 40) {
			var nextInput = inputs.get(inputs.index(this) + 1);
			if (nextInput) {
				nextInput.focus();
				return false;
			}
		}
		if(e.which == 38)
		{
			var nextInput = inputs.get(inputs.index(this) - 1);
			if (nextInput) {
				nextInput.focus();
				return false;
			}
		}
	});
	//End of return and arrow keys should move to next input

	// BidItemToSubcontractorBid.item_quantity
	newSize = 20;
	$(".item_quantity").each(function() {
		var size = $(this).val().length * 6;
		if (size > newSize) {
			newSize = size;
		}
	});
	$(".item_quantity").css('width', newSize + 20);

	// Unit Inputs
	newSize = 30;
	$(".unit").each(function() {
		var size = $(this).val().length * 6;
		if (size > newSize) {
			newSize = size;
		}
	});
	$(".unit").css('width', newSize + 20);

	// Amount Inputs
	newSize = 50;
	$(".unit_price").each(function() {
		var size = $(this).val().length * 6;
		if (size > newSize) {
			newSize = size;
		}
	});
	$(".unit_price").css('width', newSize + 20);

	// Total Inputs
	newSize = 70;
	$(".unitTotal").each(function() {
		var size = $(this).val().length * 6;
		if (size > newSize) {
			newSize = size;
		}
	});
	$(".unitTotal").css('width', newSize + 20);
/*
	// SubTotal Inputs
	newSize = 90;
	$('input:text[id*="otal_"]:visible').each(function() {
		var size = $(this).val().length * 6;
		if (size > newSize) {
			newSize = size;
		}
	});
	$('input:text[id*="otal_"]:visible').css('width', newSize + 20);
*/

	$("body").show();
}

// @todo: Check if any change and skip reload unless order actually changed
function Subcontractor_Bid_Spreadsheet__subcontractorBidColumnsReorderedSuccess(data, textStatus, jqXHR)
{
	//alert(data);
	// 1 means blank row was added so we are going to refresh the page.
	// 0 means we just need to show the message that reorder was successful
	//if (data == 1) {
		Subcontractor_Bid_Spreadsheet__reloadWindow();
	//} else {

	//}
}

function Subcontractor_Bid_Spreadsheet__updateBidItem(element, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.successCallback = Subcontractor_Bid_Spreadsheet__updateBidItemSuccess;

		if (options.bid_item_id) {

			var bid_item_id = options.bid_item_id;

		} else {

			// Test for ddl-- prepended to the element id
			var elementId = $(element).attr('id');
			// Get the first five characters of the element id string
			var elementIdSubstring = elementId.substring(0, 5);
			if (elementIdSubstring == 'ddl--') {
				var originalElementId = elementId;
				// Strip off "ddl--" from the element id
				elementId = elementId.substring(5);
			}

			// Test for record_container-- prepended to the element id for sort_order case
			var index = elementId.indexOf('sort_order');
			if (index > -1) {
				var elementIdSubstring = elementId.substring(0, 18);
				if (elementIdSubstring == 'record_container--') {
					elementId = elementId.substring(18);
				}
			}

			var arrParts = elementId.split('--');
			var attributeGroupName = arrParts[0];
			var attributeSubgroupName = arrParts[1];
			var attributeName = arrParts[2];
			var uniqueId = arrParts[3];

			var bid_item_id = uniqueId;

		}
		var elementIdNull = $(element).attr('id');
		var subStringNull = elementIdNull.substring(0,43);
		var elementValueNull = 'test';
		if (subStringNull == 'manage-bid_item-record--bid_items--bid_item') {
			var elementValueNull = $('#'+elementIdNull).val();
			elementValueNull = $.trim(elementValueNull);
		}
		
		options.recordContainerElementId = 'record_container--manage-bid_item-record--bid_items--sort_order--' + bid_item_id;
		if (elementValueNull == '') {
			
		}else{
			updateBidItem(element, options);
		}
		

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__updateBidItemSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		// Debug
		//alert(recordContainerElementId);

		if (errorNumber == 0) {

			var recordContainerElementId = json.recordContainerElementId;
			var attributeGroupName = json.attributeGroupName;
			var attributeSubgroupName = json.attributeSubgroupName;
			var attributeName = json.attributeName;
			var uniqueId = json.uniqueId;
			var newValue = json.newValue;

			var recordContainerElement = $("#" + recordContainerElementId);
			var isSubTotalRow = $(recordContainerElement).hasClass('subtotal-row');

			if (attributeName && (attributeName == 'bid_item')) {
				var testNewValue = newValue.toLowerCase();
				var containsSubtotalText = false;
				if (testNewValue.indexOf('subtotal') >= 0 || testNewValue.indexOf('sub total') >= 0) {
					containsSubtotalText = true;
					if (!isSubTotalRow) {
						$(recordContainerElement).addClass('subtotal-row');
					}
				} else {
					$(recordContainerElement).removeClass('subtotal-row');
				}
			}

			Subcontractor_Bid_Spreadsheet__updateAllBidTotalSummarySections();
			Subcontractor_Bid_Spreadsheet__adjustFormElementSizes();

			// @todo Migrate to no refresh...
			if ((isSubTotalRow && (containsSubtotalText == false) ) || ( (isSubTotalRow == false) && containsSubtotalText)) {
				Subcontractor_Bid_Spreadsheet__reloadWindow();
			}

		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__deleteBidItem(bid_item_id)
{
	try {

		var options = options || {};

		//trapJavaScriptEvent(event);

		options.promiseChain = true;
		options.responseDataType = 'json';
		//options.confirmation = true;
		options.successCallback = Subcontractor_Bid_Spreadsheet__deleteBidItemSuccess;

		var bid_item = $("#manage-bid_item-record--bid_items--bid_item--" + bid_item_id).val();

		var confirmationDialogMessage = '' +
		'<br>Are you sure you want to delete this bid item row?' +
		'<br>Doing so will remove all entries for all bidders for this specific row.' +
		'<br>Bid Spread Item Label: &ldquo;' + bid_item + '&rdquo;' +
		'<br><br><b>[WARNING]<br><center>This will permanently delete the Bid Item, and all Bidder entries for it.</center></b>';
		options.confirmationDialogMessage = confirmationDialogMessage;
		options.confirmationDialogTitle = 'Delete Bid Item Row?';
		options.confirmButtonText = 'Delete Bid Spread Item Row & Bidder Entries For This Row';
		options.cancelButtonText = 'Cancel';
		options.confirmationDialogWidth = 600;
		options.confirmationDialogHeight = 350;
		//options.confirmationDialogNoButtonFocus = true;

		var confirmationDialogPromise = confirmationDialog(options);

		confirmationDialogPromise.done(function() {
			// They pressed Delete
			var recordContainerElementId = 'record_container--manage-bid_item-record--bid_items--sort_order--' + bid_item_id;
			var attributeGroupName = 'manage-bid_item-record';
			var uniqueId = bid_item_id;

			deleteBidItem(recordContainerElementId, attributeGroupName, uniqueId, options);
		});

		confirmationDialogPromise.fail(function() {
			// They pressed Cancel
			return false;
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__deleteBidItemSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;
		var uniqueId = json.uniqueId;
		var bid_item_id = uniqueId;

		if (errorNumber == 0) {

			//$("#record_container--manage-bid_item-record--bid_items--sort_order--" + bid_item_id).remove();
			Subcontractor_Bid_Spreadsheet__updateAllBidTotalSummarySections();
			Subcontractor_Bid_Spreadsheet__adjustFormElementSizes();

		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__calculateBidItemToSubcontractorBidTotal(element, uniqueId)
{
	var row = $(element).closest('tr');
	if (row.hasClass('scBidItem')) {
		var elementIdBidItemUnitPrice = 'manage-sc_bid_item_to_subcontractor_bid-record--sc_bid_items_to_subcontractor_bids--unit_price--' + uniqueId;
		var elementIdBidItemQuantity  = 'manage-sc_bid_item_to_subcontractor_bid-record--sc_bid_items_to_subcontractor_bids--item_quantity--' + uniqueId;
		var elementIdBidItemTotal     = 'manage-sc_bid_item_to_subcontractor_bid-record--sc_bid_items_to_subcontractor_bids--unitTotal--' + uniqueId;
	} else {
		var elementIdBidItemUnitPrice = 'manage-bid_item_to_subcontractor_bid-record--bid_items_to_subcontractor_bids--unit_price--' + uniqueId;
		var elementIdBidItemQuantity  = 'manage-bid_item_to_subcontractor_bid-record--bid_items_to_subcontractor_bids--item_quantity--' + uniqueId;
		var elementIdBidItemTotal     = 'manage-bid_item_to_subcontractor_bid-record--bid_items_to_subcontractor_bids--unitTotal--' + uniqueId;
	}

	var bidItemUnitPrice = $("#" + elementIdBidItemUnitPrice).val();
	var bidItemQuantity = $("#" + elementIdBidItemQuantity).val();
	bidItemUnitPrice = parseInputToCurrency(bidItemUnitPrice);
	bidItemQuantity = parseInputToFloat(bidItemQuantity);

	var bidItemTotal = parseFloat(bidItemUnitPrice) * parseFloat(bidItemQuantity);

	var formattedBidItemUnitPrice = formatDollar(bidItemUnitPrice);
	var formattedBidItemTotal = formatDollar(bidItemTotal);

	if ((bidItemQuantity == '0.00') || (bidItemQuantity == '0')) {
		var bidItemQuantityValue = '';
	} else {
		var bidItemQuantityValue = bidItemQuantity;
	}

	if (formattedBidItemUnitPrice == '$0.00') {
		formattedBidItemUnitPrice = '';
	}

	if (formattedBidItemTotal == '$0.00') {
		formattedBidItemTotal = '';
	}

	$("#" + elementIdBidItemQuantity).val(bidItemQuantityValue);
	$("#" + elementIdBidItemUnitPrice).val(formattedBidItemUnitPrice);
	$("#" + elementIdBidItemTotal).val(formattedBidItemTotal);

	if (bidItemQuantity < 0) {
		$("#" + elementIdBidItemQuantity).addClass('red');
	} else {
		$("#" + elementIdBidItemQuantity).removeClass('red');
	}
	if (bidItemUnitPrice < 0) {
		$("#" + elementIdBidItemUnitPrice).addClass('red');
	} else {
		$("#" + elementIdBidItemUnitPrice).removeClass('red');
	}
	if (bidItemTotal < 0) {
		$("#" + elementIdBidItemTotal).addClass('red');
	} else {
		$("#" + elementIdBidItemTotal).removeClass('red');
	}
}

function Subcontractor_Bid_Spreadsheet__updateSubcontractorBid(element, javaScriptEvent, options)
{
	try {

		// Trap the event
		trapJavaScriptEvent(javaScriptEvent);

		var options = options || {};

		var updateCase = options.updateCase;
		if (updateCase == 'togglePreferredSubcontractorBidStatus') {
			var isChecked = $(element).is(':checked');

			// 5 - "Bid Received"
			var attributeValue = 5;
			if (isChecked) {
				// 12 - "Preferred Subcontractor Bid"
				attributeValue = 12;
			}
			$(element).val(attributeValue);
		}

		options.responseDataType = 'json';
		options.successCallback = Subcontractor_Bid_Spreadsheet__updateSubcontractorBidSuccess;

		updateSubcontractorBid(element, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__updateSubcontractorBidSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;
		var attributeGroupName = json.attributeGroupName;
		var attributeSubgroupName = json.attributeSubgroupName;
		var attributeName = json.attributeName;
		var uniqueId = json.uniqueId;
		var htmlRecord = json.htmlRecord;

		if (errorNumber == 0) {

			// HTML Record Attribute-Specific Pattern
			// Preferred Subcontractor toggle only
			if (attributeName == 'subcontractor_bid_status_id') {
				var subcontractor_bid_id = uniqueId;
				$('.thPreferredSubcontractor--' + subcontractor_bid_id).toggleClass('preferredSub');
				// Show the <a> link to Subcontracts Modal Dialog
				$("#preferredSubcontractorLink--subcontractor_bid_id--" + subcontractor_bid_id).toggleClass('hidden');
				PreferredSubcontractorBidIds.toggle(subcontractor_bid_id);
			}

		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBid(element, javaScriptEvent, attributeGroupName, uniqueId, options)
{
	try {

		// Trap the event
		trapJavaScriptEvent(javaScriptEvent);

		var options = options || {};
		options.responseDataType = 'json';
		//options.successCallback = Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBidSuccess;

		/*
		// This is not needed here and gets undone immediately below when the value is formatted with a dollar sign
		var unit_price_element_id = attributeGroupName + '--bid_items_to_subcontractor_bids--unit_price--' + uniqueId;
		if ($("#" + unit_price_element_id).length) {
			var unit_price = $("#" + unit_price_element_id).val();
			unit_price = $.trim(unit_price);
			if (unit_price != '') {
				unit_price = parseInputToCurrency(unit_price);
				$("#" + unit_price_element_id).val(unit_price);
			}
		}
		*/

		//var element = options.element;
		Subcontractor_Bid_Spreadsheet__calculateBidItemToSubcontractorBidTotal(element, uniqueId);
		var arrTmp = uniqueId.split('-');
		var subcontractor_bid_id = arrTmp[1];
		var isCheckbox = $(element).prop('type') == 'checkbox';
		if (isCheckbox) {
			toggleExcludeClass(element, subcontractor_bid_id);
		}
		Subcontractor_Bid_Spreadsheet__updateBidTotalSummarySection(subcontractor_bid_id);

		saveBidItemToSubcontractorBid(attributeGroupName, uniqueId, options);

		//To make the entire row not editable if exclude check box is selected
		var innerattribute="bid_items_to_subcontractor_bids";
		if($("#manage-bid_item_to_subcontractor_bid-record--"+innerattribute+"--exclude_bid_item_flag--"+uniqueId).prop('checked') == true)
		{
			$("#manage-bid_item_to_subcontractor_bid-record--"+innerattribute+"--item_quantity--"+uniqueId).attr("readonly", true); 
			$("#manage-bid_item_to_subcontractor_bid-record--"+innerattribute+"--unit--"+uniqueId).attr("readonly", true); 
			$("#manage-bid_item_to_subcontractor_bid-record--"+innerattribute+"--unit_price--"+uniqueId).attr("readonly", true); 
			$("#manage-bid_item_to_subcontractor_bid-record--"+innerattribute+"--unitTotal--"+uniqueId).attr("readonly", true);
			$("#manage-bid_item_to_subcontractor_bid-record--"+innerattribute+"--unitTotal--"+uniqueId).val(""); 
			
		}else{
			
			$("#manage-bid_item_to_subcontractor_bid-record--"+innerattribute+"--item_quantity--"+uniqueId).attr("readonly", false); 
			$("#manage-bid_item_to_subcontractor_bid-record--"+innerattribute+"--unit--"+uniqueId).attr("readonly", false);
			$("#manage-bid_item_to_subcontractor_bid-record--"+innerattribute+"--unit_price--"+uniqueId).attr("readonly", false);
			$("#manage-bid_item_to_subcontractor_bid-record--"+innerattribute+"--unitTotal--"+uniqueId).attr("readonly", false);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBidSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		var isCreateCase = json.isCreateCase;

		if (errorNumber == 0) {
			/*
			if (isCreateCase == 1) {
				messageText = messageText + ' successfully created.';
			} else {
				messageText = messageText + ' successfully updated.';
			}
			*/
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__saveScBidItemToSubcontractorBid(element, javaScriptEvent, attributeGroupName, uniqueId, options)
{
	try {

		// Trap the event
		trapJavaScriptEvent(javaScriptEvent);

		var options = options || {};
		options.responseDataType = 'json';
		//options.successCallback = Subcontractor_Bid_Spreadsheet__saveScBidItemToSubcontractorBidSuccess;

		var unit_price_element_id = attributeGroupName + '--sc_bid_items_to_subcontractor_bids--unit_price--' + uniqueId;
		if ($("#" + unit_price_element_id).length) {
			var unit_price = $("#" + unit_price_element_id).val();
			unit_price = parseInputToCurrency(unit_price);
			$("#" + unit_price_element_id).val(unit_price);
		}

		//var element = options.element;
		Subcontractor_Bid_Spreadsheet__calculateBidItemToSubcontractorBidTotal(element, uniqueId);
		var arrTmp = uniqueId.split('-');
		var subcontractor_bid_id = arrTmp[0];
		var isCheckbox = $(element).prop('type') == 'checkbox';
		if (isCheckbox) {
			toggleExcludeClass(element, subcontractor_bid_id);
		}
		Subcontractor_Bid_Spreadsheet__updateBidTotalSummarySection(subcontractor_bid_id);

		saveScBidItemToSubcontractorBid(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__saveScBidItemToSubcontractorBidSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		var isCreateCase = json.isCreateCase;

		if (errorNumber == 0) {
			/*
			if (isCreateCase == 1) {
				messageText = messageText + ' successfully created.';
			} else {
				messageText = messageText + ' successfully updated.';
			}
			*/
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

// Note: this function is not in use
function updateTotals(elementId)
{
	return;

	try {

		if (elementId.indexOf('item_quantity') == 0 || elementId.indexOf('unit_price') == 0 || elementId.indexOf('exclude_bid_item_flag') == 0) {
			var project_id = $("#project_id").val();

			var ary = elementId.split('--');
			var subcontractor_bid_id = ary[1];
			var bid_item_id = ary[2];
			var itemQty = parseInputToInt($("#item_quantity-" + subcontractor_bid_id + '-' + bid_item_id).val().replace(/,/g, ''));
			var itemPrice = parseInputToCurrency($("#unit_price-" + subcontractor_bid_id + '-' + bid_item_id).val().replace(/,/g, ''));
			var itemTotal = parseFloat(itemQty) * parseFloat(itemPrice);
			if (itemTotal == 0 || isNaN(itemTotal)) {
				$("#ttl-" + subcontractor_bid_id + '-' + bid_item_id).val('');
			} else {
				var formattedItemTotal = formatDollar(itemTotal);
				$("#ttl-" + subcontractor_bid_id + '-' + bid_item_id).val(formattedItemTotal);
			}

			// Update Subtotals
			var bidderSubtotal = 0.00;
			var bidderTotal = 0.00;
			$("[id^='ttl-"+subcontractor_bid_id+"']").each(function() {
				bidderSubtotal = parseInputToCurrency(bidderSubtotal);
				bidderTotal = parseInputToCurrency(bidderTotal);

				var iAry = $(this).attr("id").split('--');
				var iBidItemID = iAry[2];
				var isExcluded = $("#exclude_bid_item_flag-" + subcontractor_bid_id + "-" + iBidItemID).is(":checked");
				if (isExcluded == false && $(this).hasClass('bidder-total') == false ) {
					var iTtl = parseFloat($(this).val().replace(/,/g, ''));
					if ($(this).hasClass('subtotal-input')) {
						var formattedBidderSubtotal = formatDollar(bidderSubtotal);
						$(this).val(formattedBidderSubtotal);
						bidderSubtotal = 0.00;
					} else {
						if (isNaN(iTtl) == false) {
							bidderSubtotal = parseFloat(bidderSubtotal) + parseFloat(iTtl);
							bidderTotal = parseFloat(bidderTotal) + parseFloat(iTtl);
						}
					}
				}
			});

			// Update Totals
			var formattedBidderTotal = formatDollar(bidderTotal);
			$("#ttl-" + subcontractor_bid_id).val(formattedBidderTotal);
			var squareFoot = $("#subcontrator_bid_spread_reference_data-project-record--projects--gross_square_footage--" + project_id).val();
			if ((isNaN(squareFoot) == false) && (squareFoot != '') && (squareFoot != '0')) {
				var squareFootTotal = parseFloat(bidderTotal) / parseFloat(squareFoot);
				var formattedSquareFootTotal = formatDollar(squareFootTotal);
				$("#subcontractorBidTotalCostPerGrossSquareFoot--" + subcontractor_bid_id).val(formattedSquareFootTotal);
			} else {
				$("#subcontractorBidTotalCostPerGrossSquareFoot--" + subcontractor_bid_id).val('');
			}
			var unitCount = $("#subcontrator_bid_spread_reference_data-project-record--projects--unit_count--" + project_id).val();
			var unitCount = parseInt(unitCount);
			if (isNaN(unitCount) == false && unitCount != '') {
				var unitTotal = parseFloat(bidderTotal) / parseFloat(unitCount);
				var formattedUnitTotal = formatDollar(unitTotal);
				$("#ttlPerUnit-" + subcontractor_bid_id).val(formattedUnitTotal);
			} else {
				$("#ttlPerUnit-" + subcontractor_bid_id).val('');
			}

			//Update Variance
			var linkedScheduledTotal = $("#linkedScheduledTotal").val();
			if (isNaN(linkedScheduledTotal) == false && linkedScheduledTotal != '') {
				var newVariance = parseFloat(linkedScheduledTotal) - parseFloat(bidderTotal);
				if (newVariance < 0) {
					$("#variance_ttl-" + subcontractor_bid_id).addClass('redNumber');
				} else {
					$("#variance_ttl-" + subcontractor_bid_id).removeClass('redNumber');
				}
				var formattedNewVariance = formatDollar(newVariance);
				$("#variance_ttl-" + subcontractor_bid_id).val(formattedNewVariance);
			} else {
				$("#variance_ttl-" + subcontractor_bid_id).val('');
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

function Subcontractor_Bid_Spreadsheet__moveBidderLeft(gc_budget_line_item_id, current_sort_order)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=Subcontractor_Bid_Spreadsheet__moveBidderLeft';
		var ajaxQueryString =
			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&current_sort_order=' + encodeURIComponent(current_sort_order);
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
			success: Subcontractor_Bid_Spreadsheet__subcontractorBidColumnsReorderedSuccess,
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

function Subcontractor_Bid_Spreadsheet__moveBidderRight(gc_budget_line_item_id, current_sort_order)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=Subcontractor_Bid_Spreadsheet__moveBidderRight';
		var ajaxQueryString =
			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&current_sort_order=' + encodeURIComponent(current_sort_order);
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
			success: Subcontractor_Bid_Spreadsheet__subcontractorBidColumnsReorderedSuccess,
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

function Subcontractor_Bid_Spreadsheet__moveBidderFarLeft(gc_budget_line_item_id, current_sort_order)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=Subcontractor_Bid_Spreadsheet__moveBidderFarLeft';
		var ajaxQueryString =
			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&current_sort_order=' + encodeURIComponent(current_sort_order);
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
			success: Subcontractor_Bid_Spreadsheet__subcontractorBidColumnsReorderedSuccess,
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

function Subcontractor_Bid_Spreadsheet__moveBidderFarRight(gc_budget_line_item_id, current_sort_order)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=Subcontractor_Bid_Spreadsheet__moveBidderFarRight';
		var ajaxQueryString =
			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&current_sort_order=' + encodeURIComponent(current_sort_order);
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
			success: Subcontractor_Bid_Spreadsheet__subcontractorBidColumnsReorderedSuccess,
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

function Subcontractor_Bid_Spreadsheet__sortBiddersByPrice(gc_budget_line_item_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=Subcontractor_Bid_Spreadsheet__sortBiddersByPrice';
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
			success: Subcontractor_Bid_Spreadsheet__subcontractorBidColumnsReorderedSuccess,
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

function Subcontractor_Bid_Spreadsheet__displayHelpModal()
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.85;
		var dialogHeight = windowHeight * 0.85;

		var subcontractorBidSpreadsheetHelpHtml =
			'<h3>[How To Add Bid Items To The Spread]</h3>' +
			'Click the Plus Symbol next to &ldquo;Bid Spread Items&rdquo;.' +
			'<br>' +
			'<br>' +
			'<h3>[How To Add Subtotals To The Bid Spread]</h3>' +
			'You can add subtotals to the spread by entering the word &ldquo;Subtotal&rdquo; as the bid spread item description.' +
			'<br>' +
			'<br>' +
			'<h3>[How To Exclude Bid Items From the Bid Total]</h3>' +
			'You can add exclude bid items by checking the checkbox to the right of the item.' +
			'<br>' +
			'<br>' +
			'<h3>[How To Pick A Bid]</h3>' +
			'You can award one or more (multiple) subcontracts by checking the &ldquo;Preferred Subcontractor&rdquo; checkbox.';

		$("#divModalWindow").html(subcontractorBidSpreadsheetHelpHtml);
		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").dialog({
			autoOpen: false,
			width: dialogWidth,
			height: dialogHeight,
			modal: true,
			title: 'Subcontractor Bid Spreadsheet Help',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$(this).html('');
				$(this).dialog('destroy');
				$("body").removeClass('noscroll');
				$("#divModalWindow").addClass('hidden');
			},
			buttons: {
				'Close': function() {
					$(this).dialog('close');
				}
			}
		});
		$("#divModalWindow").dialog('open');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadLinkedGcBudgetLineItems(gc_budget_line_item_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=loadLinkedGcBudgetLineItems';
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
			success: loadLinkedGcBudgetLineItemsSuccess,
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

function loadLinkedGcBudgetLineItemsSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		//var dialogWidth = windowWidth * 0.85;
		var dialogHeight = windowHeight * 0.85;

		$("#divModalWindow").html(data);
		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").dialog({
			height: dialogHeight,
			width: 500,
			modal: true,
			title: 'Linked Scheduled Values',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$(this).html('');
				$(this).dialog('destroy');
				$("body").removeClass('noscroll');
				showSpinner();
				Subcontractor_Bid_Spreadsheet__reloadWindow();
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

function toggleGcBudgetLineItemsToGcBudgetLineItems(gc_budget_line_item_id, linked_gc_budget_line_item_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-ajax.php?method=toggleGcBudgetLineItemsToGcBudgetLineItems';
		var ajaxQueryString =
			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&linked_gc_budget_line_item_id=' + encodeURIComponent(linked_gc_budget_line_item_id);
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
			success: toggleLinkToBudgetItemSuccess,
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

function toggleLinkToBudgetItemSuccess(data, textStatus, jqXHR)
{
	try {

		var messageText = 'Schedule value link successfully updated';
		messageAlert(messageText, 'successMessage');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleDisplayLinkedCostCodes(bid_spread_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=toggleDisplayLinkedCostCodes';
		var ajaxQueryString =
			'bid_spread_id=' + encodeURIComponent(bid_spread_id);
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
			error: errorHandler
		});
		$(".linkedRow").toggle();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}


/*
** Returns the caret (cursor) position of the specified text field.
** Return value range is 0-oField.value.length.
*/
function doGetCaretPosition (oField)
{
	// Initialize
	var iCaretPos = 0;
	if (oField.type == 'checkbox') {
		return iCaretPos;
	}

	// IE Support
	if (document.selection) {
		// Set focus on the element
		oField.focus ();
		// To get cursor position, get empty selection range
		var oSel = document.selection.createRange ();
		// Move selection start to 0 position
		oSel.moveStart ('character', -oField.value.length);
		// The caret position is selection length
		iCaretPos = oSel.text.length;
	} else if (oField.selectionStart || oField.selectionStart == '0') {
		iCaretPos = oField.selectionStart;
	}

	// Return results
	return (iCaretPos);
}

function submitSubcontractorBidsSpreadsheetForApprovalAndReloadSpreadSummaryDataViaPromiseChain()
{
	try {

		var options = { promiseChain: true };
		var promise = submitSubcontractorBidsSpreadsheetForApproval(options);
		promise.then(function() {
			loadSpreadSummaryData();
		});

	} catch(error) {

	}
}

function submitSubcontractorBidsSpreadsheetForApproval(options)
{
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		Subcontractor_Bid_Spreadsheet__Approval_Modal__createBidSpreadNote();
		gc_budget_line_item_id = $("#gc_budget_line_item_id").val();

		var bid_spread_id = $("#selected_bid_spread_id").val();

		var spreadto_email = $("#spreadto_email").val();
		
		var bid_spread_bid_total = $("#manage-bid_spread-record--bid_spreads--bid_spread_bid_total--" + bid_spread_id).val();
		bid_spread_bid_total = $.trim(bid_spread_bid_total);

		var csvBidSpreadPreferredSubcontractorBidIds = $("#manage-bid_spread-record--bid_spreads--csvBidSpreadPreferredBidders--" + bid_spread_id).val();
		//var bid_spread_preferred_subcontractor_bid_id = $("#manage-bid_spread-record--bid_spreads--bid_spread_preferred_subcontractor_bid_id--" + bid_spread_id).val();
		if (!csvBidSpreadPreferredSubcontractorBidIds) {
			alert('Selected spread does not have a preferred sub. Please choose another.');
			return;
		}

		// Fix this to auto parse via htmlAttributeGroup--htmlAttributeSubgroup--htmlAttribute--uniqueId
		// Debug
		var attributeGroupName = 'manage-subcontractor_bid-record';
		var formattedAttributeGroupName = 'Manage Bid Spread';
		var attributeSubgroupName = 'bid_spreads';
		var uniqueId = bid_spread_id;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=submitSubcontractorBidsSpreadsheetForApproval';
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent('bid_spreads') +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&bid_spread_id=' + encodeURIComponent(bid_spread_id) +
			'&csvBidSpreadPreferredSubcontractorBidIds=' + encodeURIComponent(csvBidSpreadPreferredSubcontractorBidIds) +
			'&email_list=' + encodeURIComponent(spreadto_email) +
			'&bid_spread_bid_total=' + encodeURIComponent(bid_spread_bid_total) +
			'&bid_spread_bid_total';

		var optionsObjectIsEmpty = $.isEmptyObject(options);
		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options){
				// property exists
				// conditionally skip the default success callback function
				var skipDefaultSuccessCallback = options.skipDefaultSuccessCallback;
			} else {
				var skipDefaultSuccessCallback = false;
			}
			// options is an object containing values so form a query string of the key/value pairs
			var ajaxQueryStringFromOptions = generateAjaxQueryStringFromOptions(options);
			ajaxQueryString = ajaxQueryString + ajaxQueryStringFromOptions;
		}

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		// Debug
		//return;

		//lockPurchasingBidSpread(gc_budget_line_item_id);

		showSpinner();

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: submitSubcontractorBidsSpreadsheetForApprovalSuccess,
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
				hideSpinner();
			}
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

function submitSubcontractorBidsSpreadsheetForApprovalSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(data);
			if (continueDebug != true) {
				return;
			}
		}

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var errorMessage = json.errorMessage;
			var attributeGroupName = json.attributeGroupName;
			var attributeSubgroupName = json.attributeSubgroupName;
			var uniqueId = json.uniqueId;
			var formattedAttributeGroupName = json.formattedAttributeGroupName;
			var formattedAttributeSubgroupName = json.formattedAttributeSubgroupName;
		}

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
		var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(recordContainerElementId);
			if (continueDebug != true) {
				return;
			}
		}

		if (errorNumber == 0) {
			var messageText = '';

			if (formattedAttributeGroupName != '') {
				messageText = messageText + ' ' + formattedAttributeGroupName + ' -';
			}

			if (formattedAttributeSubgroupName != '') {
				messageText = messageText + ' ' + formattedAttributeSubgroupName;
			}

			messageText = messageText + ' successfully created.';

			messageText = $.trim(messageText);

			messageAlert(messageText, 'successMessage');

			// Update bid spread status column.
			var bidSpreadStatus = BidSpreadStatus.findByBidSpreadStatus('Submitted for Approval');
			var bid_spread_status_id = bidSpreadStatus.bid_spread_status_id;
			var bid_spread_status = bidSpreadStatus.bid_spread_status;
			$("#manage-bid_spread-record--bid_spreads--bid_spread_status_id--" + uniqueId).val(bid_spread_status_id);
			$("#manage-bid_spread-record--bid_spreads--bid_spread_status--" + uniqueId).html(bid_spread_status);

			//window.location.reload(true);
		} else {
			var errorMessage = json.errorMessage;
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

function loadSpreadSummaryData()
{
	try {

		gc_budget_line_item_id = $("#gc_budget_line_item_id").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=loadSpreadSummaryData';
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
			success: loadSpreadSummaryDataSuccess,
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

function loadSpreadSummaryDataSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var bidSpreadsByAnalysisInProcessStatusText = json.bidSpreadsByAnalysisInProcessStatusText;
		var bidSpreadsByApprovedStatusText = json.bidSpreadsByApprovedStatusText;
		var bidSpreadsByRejectedStatusText = json.bidSpreadsByRejectedStatusText;

		$("#bidSpreadsByAnalysisInProcessStatusText").html(bidSpreadsByAnalysisInProcessStatusText);
		$("#bidSpreadsByApprovedStatusText").html(bidSpreadsByApprovedStatusText);
		$("#bidSpreadsByRejectedStatusText").html(bidSpreadsByRejectedStatusText);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function lockPurchasingBidSpread(gc_budget_line_item_id)
{
	$("#purchasingBidSpreadContainer--" + gc_budget_line_item_id).find('input:enabled').prop('disabled', true );

	var messageText = 'Disabled';
	messageAlert(messageText, 'successMessage');

	//.css('display');

	//$('input:enabled').prop( "disabled", true );

	// gc_budget_line_item_id
}

function togglecheckboxAddNote()
{
	var checkboxAddNote = $("#checkboxAddNote");
	var checked = checkboxAddNote.prop('checked');
	checkboxAddNote.prop('checked', !checked);
	toggleTextareaAddNoteDisplay();
}

function toggleTextareaAddNoteDisplay()
{
	var textareaAddNote = $("#textareaAddNote");
	if (textareaAddNote.css('display') === 'none') {
		textareaAddNote.show();
	} else {
		textareaAddNote.hide();
	}
}
//To view the Excel
function exportbidspread(gc_budget_line_item_id, cost_code_division_id, cost_code_id)
{
	try {

		var csvPreferredSubcontractorBidIds = $("#csvPreferredSubcontractorBidIds").val();
		var arrPreferredSubcontractorBidIds = csvPreferredSubcontractorBidIds.split(',');
		var bid_spread_bid_total = 0.00;
		for (var i = 0; i < arrPreferredSubcontractorBidIds.length; i++) {
			bid_spread_bid_total = parseInputToCurrency(bid_spread_bid_total);

			var preferred_subcontractor_bid_id = arrPreferredSubcontractorBidIds[i];
			var tempTotal = $("#derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--" + preferred_subcontractor_bid_id).val();
			tempTotal = parseInputToCurrency(tempTotal);

			bid_spread_bid_total = parseFloat(bid_spread_bid_total) + parseFloat(tempTotal);
		}
		bid_spread_bid_total = parseInputToCurrency(bid_spread_bid_total);

		var bidSpreadsheetLabel = $("#inputBidSpreadsheetLabel").val();
		bidSpreadsheetLabel = $.trim(bidSpreadsheetLabel);

		gc_budget_line_item_id = $.trim(gc_budget_line_item_id);
		cost_code_division_id = $.trim(cost_code_division_id);
		cost_code_id = $.trim(cost_code_id);

		var pdf = 1;
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=exportbid';
		var ajaxQueryString =
			'attributeGroupName=create-bid_spread-record' +
			'&newAttributeGroupName=manage-bid_spread-record' +
			'&csvPreferredSubcontractorBidIds=' + encodeURIComponent(csvPreferredSubcontractorBidIds) +
			'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
			'&cost_code_id=' + encodeURIComponent(cost_code_id) +
			'&bidSpreadsheetLabel=' + encodeURIComponent(bidSpreadsheetLabel) +
			'&bid_spread_bid_total=' + encodeURIComponent(bid_spread_bid_total) +
			'&pdf=' + encodeURIComponent(pdf) +
			'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var buttonGeneratePdf = $("#buttonGeneratePdf");
		buttonGeneratePdf.prop('disabled', 'true');

		showSpinner();

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data)
			{
				document.location = ajaxUrl;
			},
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
				buttonGeneratePdf.prop('disabled', '');
				hideSpinner();
			}
		});


	} catch (error) {

	}
}
//To view the pdf
function printPdf(gc_budget_line_item_id, cost_code_division_id, cost_code_id, status,pID)
{
	try {

		var csvPreferredSubcontractorBidIds = $("#csvPreferredSubcontractorBidIds").val();
		var arrPreferredSubcontractorBidIds = csvPreferredSubcontractorBidIds.split(',');
		var bid_spread_bid_total = 0.00;
		for (var i = 0; i < arrPreferredSubcontractorBidIds.length; i++) {
			bid_spread_bid_total = parseInputToCurrency(bid_spread_bid_total);

			var preferred_subcontractor_bid_id = arrPreferredSubcontractorBidIds[i];
			var tempTotal = $("#derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--" + preferred_subcontractor_bid_id).val();
			tempTotal = parseInputToCurrency(tempTotal);

			bid_spread_bid_total = parseFloat(bid_spread_bid_total) + parseFloat(tempTotal);
		}
		bid_spread_bid_total = parseInputToCurrency(bid_spread_bid_total);

		var bidSpreadsheetLabel = $("#inputBidSpreadsheetLabel").val();
		bidSpreadsheetLabel = $.trim(bidSpreadsheetLabel);

		gc_budget_line_item_id = $.trim(gc_budget_line_item_id);
		cost_code_division_id = $.trim(cost_code_division_id);
		cost_code_id = $.trim(cost_code_id);

		var pdf = 1;
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=printPdf';
		var ajaxQueryString =
			'attributeGroupName=create-bid_spread-record' +
			'&newAttributeGroupName=manage-bid_spread-record' +
			'&csvPreferredSubcontractorBidIds=' + encodeURIComponent(csvPreferredSubcontractorBidIds) +
			'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
			'&cost_code_id=' + encodeURIComponent(cost_code_id) +
			'&bidSpreadsheetLabel=' + encodeURIComponent(bidSpreadsheetLabel) +
			'&bid_spread_bid_total=' + encodeURIComponent(bid_spread_bid_total) +
			'&pdf=' + encodeURIComponent(pdf) +
			'&pdfStatus=' + encodeURIComponent(status) +
			'&responseDataType=json'+
			'&pID='+pID;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var buttonGeneratePdf = $("#buttonGeneratePdf");
		buttonGeneratePdf.prop('disabled', 'true');

		showSpinner();

		if (status == 1) {
			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: function(data)
				{
					hideSpinner();
					window.location = '/modules-gc-budget-form.php';
				},
				error: errorHandler,
				complete: function(jqXHR, textStatus) {
					buttonGeneratePdf.prop('disabled', '');
				}
			});
		}else{
			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: function(data)
				{
					document.location = ajaxUrl;
				},
				error: errorHandler,
				complete: function(jqXHR, textStatus) {
					buttonGeneratePdf.prop('disabled', '');
					hideSpinner();
				}
			});
		}

	} catch (error) {

	}
}

function saveSubcontractorBidsSpreadsheetAsPdf(gc_budget_line_item_id, cost_code_division_id, cost_code_id)
{
	try {

		var csvPreferredSubcontractorBidIds = $("#csvPreferredSubcontractorBidIds").val();
		var arrPreferredSubcontractorBidIds = csvPreferredSubcontractorBidIds.split(',');
		var bid_spread_bid_total = 0.00;
		for (var i = 0; i < arrPreferredSubcontractorBidIds.length; i++) {
			bid_spread_bid_total = parseInputToCurrency(bid_spread_bid_total);

			var preferred_subcontractor_bid_id = arrPreferredSubcontractorBidIds[i];
			var tempTotal = $("#derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--" + preferred_subcontractor_bid_id).val();
			tempTotal = parseInputToCurrency(tempTotal);

			bid_spread_bid_total = parseFloat(bid_spread_bid_total) + parseFloat(tempTotal);
		}
		bid_spread_bid_total = parseInputToCurrency(bid_spread_bid_total);

		var bidSpreadsheetLabel = $("#inputBidSpreadsheetLabel").val();
		bidSpreadsheetLabel = $.trim(bidSpreadsheetLabel);

		gc_budget_line_item_id = $.trim(gc_budget_line_item_id);
		cost_code_division_id = $.trim(cost_code_division_id);
		cost_code_id = $.trim(cost_code_id);

		var pdf = 1;
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=saveSubcontractorBidsSpreadsheetAsPdf';
		var ajaxQueryString =
			'attributeGroupName=create-bid_spread-record' +
			'&newAttributeGroupName=manage-bid_spread-record' +
			'&csvPreferredSubcontractorBidIds=' + encodeURIComponent(csvPreferredSubcontractorBidIds) +
			'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
			'&cost_code_id=' + encodeURIComponent(cost_code_id) +
			'&bidSpreadsheetLabel=' + encodeURIComponent(bidSpreadsheetLabel) +
			'&bid_spread_bid_total=' + encodeURIComponent(bid_spread_bid_total) +
			'&pdf=' + encodeURIComponent(pdf) +
			'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var buttonGeneratePdf = $("#buttonGeneratePdf");
		buttonGeneratePdf.prop('disabled', 'true');

		showSpinner();

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			//dataType: json,
			success: saveSubcontractorBidsSpreadsheetAsPdfSuccess,
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
				buttonGeneratePdf.prop('disabled', '');
				hideSpinner();
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

function saveSubcontractorBidsSpreadsheetAsPdfSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(data);
			if (continueDebug != true) {
				return;
			}
		}

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var attributeGroupName = json.attributeGroupName;
			var attributeSubgroupName = json.attributeSubgroupName;
			var uniqueId = json.uniqueId;
			var formattedAttributeGroupName = json.formattedAttributeGroupName;
			var formattedAttributeSubgroupName = json.formattedAttributeSubgroupName;
			var previousAttributeGroupName = json.previousAttributeGroupName;
			var dummyId = json.dummyId;

			var virtual_file_name = json.virtual_file_name;
			var virtual_file_name_url_encoded = json.virtual_file_name_url_encoded;
			var bidSpreadPdfHtml = json.bidSpreadPdfHtml;

			virtual_file_name_url_decoded = urldecode(virtual_file_name_url_encoded);
			//bidSpreadPdfHtmlDecoded = urldecode(bidSpreadPdfHtml);

			var messageText = '';
			if (formattedAttributeGroupName != '') {
				messageText = messageText + ' ' + formattedAttributeGroupName + ' -';
			}
			if (formattedAttributeSubgroupName != '') {
				messageText = messageText + ' ' + formattedAttributeSubgroupName;
			}
			messageText = messageText + ' successfully created.';
			messageText = $.trim(messageText);
			messageAlert(messageText, 'successMessage');

			// Just reload it for now due to new complexity
			loadBidSpreadApprovalProcessDialog();

			/*
			//$('#ulGeneratedPdfs').prepend('<li><a href="'+ virtual_file_name_url_decoded +'" target="_blank">'+ virtual_file_name +'</a></li>');
			//$("#tableSavedBidSpreadsheets tr:nth-child(1)").before(bidSpreadPdfHtml);
			// Remove 'No spreadsheets' message.
			$("#tdNoSpreadsheets").parent().remove();
			$("#tableSavedBidSpreadsheets tr:last").after(bidSpreadPdfHtml);
			*/

		} else {
			errorMessage = json.errorMessage;
			messageAlert(errorMessage, 'errorMessage', 'errorMessageLabel');
			//messageAlert(data, 'errorMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function approveBidSpread()
{
	try {

		var gc_budget_line_item_id = $("#gc_budget_line_item_id").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'some-ajax-handler?method=ajaxHandlerMethod';
		var ajaxQueryString =
			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

//		var returnedJqXHR = $.ajax({
//			url: ajaxHandler,
//			data: ajaxQueryString,
//			success: approveBidSpreadSuccess,
//			error: errorHandler
//		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function approveBidSpreadSuccess(data, textStatus, jqXHR)
{
	try {

		// Do something.

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__updateBidTotalSummarySection(subcontractor_bid_id)
{
	try {

		Subcontractor_Bid_Spreadsheet__updateBidDerivedSubtotals(subcontractor_bid_id);

		var gc_budget_line_item_id = $("#gc_budget_line_item_id").val();
		var elementIdDerivedTotal = 'derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--' + subcontractor_bid_id;

		var classNameUnitTotal = 'unitTotal--' + subcontractor_bid_id;
		var arrBidItemTotals = $("." + classNameUnitTotal);
		var derivedTotal = 0.00;

		/*
		$('.' + classNameUnitTotal).not('subtotal-input').not('exclude').each(function() {
			var bidItemTotal = $(this).val();
			bidItemTotal = parseInputToCurrency(bidItemTotal);
			derivedTotal = parseFloat(derivedTotal) + parseFloat(bidItemTotal);
		});
		*/

		for (var i = 0; i < arrBidItemTotals.length; i++) {
			derivedTotal = parseInputToCurrency(derivedTotal);

			if ($(arrBidItemTotals[i]).hasClass('subtotal-input') || $(arrBidItemTotals[i]).hasClass('exclude')) {
				// Exclude the subtotal cells when calculating the overall total.
				continue;
			}

			var bidItemTotal = arrBidItemTotals[i].value;
			bidItemTotal = parseInputToCurrency(bidItemTotal);

			derivedTotal = parseFloat(derivedTotal) + parseFloat(bidItemTotal);
		}

		// Format and display derived total.
		derivedTotal = formatDollar(derivedTotal);

		var isSubcontractorInterface = $("#isSubcontractorInterface").val();
		if (isSubcontractorInterface == 'true') {
			$("#" + elementIdDerivedTotal).html(derivedTotal);
		} else {
			$("#" + elementIdDerivedTotal).val(derivedTotal);
		}

		Subcontractor_Bid_Spreadsheet__updateVariance(subcontractor_bid_id);
		Subcontractor_Bid_Spreadsheet__updateBidTotalCostPerGrossSquareFoot(subcontractor_bid_id);
		Subcontractor_Bid_Spreadsheet__updateBidTotalCostPerNetRentableSquareFoot(subcontractor_bid_id);
		Subcontractor_Bid_Spreadsheet__updateBidTotalCostPerUnit(subcontractor_bid_id);
		Subcontractor_Bid_Spreadsheet__adjustFormElementSizes();

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__Approval_Modal__createBidSpreadNote()
{
	try {

		//var bid_spread_id = $("#bid_spread_id").val();
		var bid_spread_id = $("#selected_bid_spread_id").val();
		var textareaAddNote = $("#textareaAddNote");
		var bid_spread_note = textareaAddNote.val();
		bid_spread_note = $.trim(bid_spread_note);

		if (bid_spread_note !== '') {
			//var bid_spread_sequence_number = $("#bid_spread_sequence_number").val();

			JavaScriptRegistry.set('bid_spread_note', bid_spread_note);

			var options = options || {};
			options.responseDataType = 'json';
			options.successCallback = Subcontractor_Bid_Spreadsheet__Approval_Modal__createBidSpreadNoteSuccess;
			options.adHocQueryParameters =
				'&bid_spread_note=' + encodeURIComponent(bid_spread_note) +
				'&bid_spread_id=' + encodeURIComponent(bid_spread_id);

			var attributeGroupName = '';
			var uniqueId = '';
			createBidSpreadNote(attributeGroupName, uniqueId, options);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__Approval_Modal__createBidSpreadNoteSuccess(data, textStatus, jqXHR, bid_spread_note)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			bid_spread_note = JavaScriptRegistry.get('bid_spread_note');
			JavaScriptRegistry.unset('bid_spread_note');
			var escaped_bid_spread_note = htmlEncode(bid_spread_note);

			// Get note id, add note to list.
			var bid_spread_note_id = json.uniqueId;
			bid_spread_note_id = +bid_spread_note_id;

			$("#trBidSpreadNotes").show();
			$("#tableBidSpreadNotes").show();

			var tr = '<tr><td id="record_container--manage-bid_spread_note-record--bid_spread_notes--' + bid_spread_note_id + '" height="30" colspan="4" align="left" valign="middle" style="vertical-align: middle;">' +
				'<a href="javascript:Subcontractor_Bid_Spreadsheet__Approval_Modal__deleteBidSpreadNote(\'record_container--manage-bid_spread_note-record--bid_spread_notes--'+bid_spread_note_id+'\', \'manage-bid_spread_note-record\', \''+bid_spread_note_id+'\')">X</a> ' +
				'<a href="#" onclick="editBidSpreadNote(this, ' + bid_spread_note_id + '); return false;">' + escaped_bid_spread_note + '</a></td></tr>';
			var tableBidSpreadNotes = $("#tableBidSpreadNotes");
			tableBidSpreadNotes.append(tr);
			var scrollHeight = tableBidSpreadNotes[0].scrollHeight;
			tableBidSpreadNotes.animate({ scrollTop: scrollHeight }, 'slow');
			var textareaAddNote = $("#textareaAddNote");
			textareaAddNote.val('');

		} else {

			errorMessage = json.errorMessage;
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

function editBidSpreadNote(element, bid_spread_note_id)
{
	var jQueryElement = $(element);
	var td = jQueryElement.parent();
	var bid_spread_note = jQueryElement.html();
	var buttonSaveEdit = '<input type="button" style="padding:1px 5px;" onclick="Subcontractor_Bid_Spreadsheet__Approval_Modal__updateBidSpreadNote(' + bid_spread_note_id + ');" value="Save">';
	var editableNote = '<input id="manage-bid_spread_note-record--bid_spread_notes--bid_spread_note--' + bid_spread_note_id + '" type="text" style="width: 90%;" value="' + bid_spread_note + '">';
	var editContent = buttonSaveEdit + editableNote;
	td.html(editContent);
}

function Subcontractor_Bid_Spreadsheet__Approval_Modal__updateBidSpreadNote(bid_spread_note_id)
{
	try {

		var elementId = 'manage-bid_spread_note-record--bid_spread_notes--bid_spread_note--' + bid_spread_note_id;
		var element = $("#" + elementId);
		var newValue = $(element).val();
		var newValue = $.trim(newValue);
		var bid_spread_note = newValue;

		JavaScriptRegistry.set('element', element);
		JavaScriptRegistry.set('bid_spread_note', bid_spread_note);

		var options = options || {};
		options.displayErrorMessage = 'N';
		options.responseDataType = 'json';
		options.successCallback = Subcontractor_Bid_Spreadsheet__Approval_Modal__updateBidSpreadNoteSuccess;

		updateBidSpreadNote(element, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__Approval_Modal__updateBidSpreadNoteSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(data);
			if (continueDebug != true) {
				return;
			}
		}

		var json = data;
		var errorNumber = json.errorNumber;

		// Debug
		//errorNumber = 1;

		if (errorNumber == 0) {

			bid_spread_note = JavaScriptRegistry.get('bid_spread_note');
			JavaScriptRegistry.unset('bid_spread_note');

			var escaped_bid_spread_note = htmlEncode(bid_spread_note);

			// Get note id, add note to list.
			var bid_spread_note_id = json.uniqueId;
			bid_spread_note_id = +bid_spread_note_id;

			//var tr = jQueryElement.closest('tr');
			var tr = $("#record_container--manage-bid_spread_note-record--bid_spread_notes--" + bid_spread_note_id);
			var td = $(tr).children('td');
			var tmpHtml =
				'<a href="javascript:Subcontractor_Bid_Spreadsheet__Approval_Modal__deleteBidSpreadNote(\'record_container--manage-bid_spread_note-record--bid_spread_notes--'+bid_spread_note_id+'\', \'manage-bid_spread_note-record\', \''+bid_spread_note_id+'\');">X</a> ' +
				'<a href="#" onclick="editBidSpreadNote(this, ' + bid_spread_note_id + '); return false;">' + escaped_bid_spread_note + '</a>';
			td.html(tmpHtml);

		} else {

			var errorMessage = json.errorMessage;
			messageAlert(errorMessage, 'errorMessage');

			var element = JavaScriptRegistry.get('element');
			JavaScriptRegistry.unset('element');

			highlightFormElement(element, 1);

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__Approval_Modal__deleteBidSpreadNote(recordContainerElementId, attributeGroupName, uniqueId)
{
	// Debug
	//return;

	try {

		deleteBidSpreadNote(recordContainerElementId, attributeGroupName, uniqueId);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__Approval_Modal__deleteBidSpreadNoteSuccess(data, textStatus, jqXHR)
{
	try {

		//var recordContainerElementId = json.recordContainerElementId;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleReasonForRejectionDisplay(element)
{
	if (element.style.overflow !== 'visible') {
		element.style.overflow = 'visible';
		element.style.whiteSpace = 'normal';
	} else {
		element.style.overflow = 'hidden';
		element.style.whiteSpace = 'nowrap';
	}
}

function rejectClicked()
{
	$("#divBidSpreadApprovalInfo").addClass('hidden');
	$("#divBidSpreadRejectionInfo").removeClass('hidden');
}

function approveClicked()
{
	$("#divBidSpreadRejectionInfo").addClass('hidden');
	$("#divBidSpreadApprovalInfo").removeClass('hidden');
}

function toggleCheckboxAddComment()
{
	var checkboxAddComment = $("#checkboxAddComment");
	var checked = checkboxAddComment.prop('checked');
	checkboxAddComment.prop('checked', !checked);
	toggleTextareaAddCommentDisplay();
}

function toggleTextareaAddCommentDisplay()
{
	$("#textareaAddComment").toggleClass('hidden');
}

function Subcontractor_Bid_Spreadsheet__Approval_Modal__submitBidSpreadDecisionAndReloadSpreadSummaryData()
{
	try {

		var options = { promiseChain: true };
		var promise = Subcontractor_Bid_Spreadsheet__Approval_Modal__submitBidSpreadDecision(options);
		promise.then(function() {
			loadSpreadSummaryData();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__Approval_Modal__submitBidSpreadDecision(options)
{
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		var bid_spread_id = $("#selected_bid_spread_id").val();
		var bid_spread_status_id = $("#selected_bid_spread_status_id").val();

		// bid_spread_approval_modal--bid_spread_approved_value ?
		var bid_spread_approved_value = $("#inputBidSpreadApprovedValue").val();
		bid_spread_approved_value = parseInputToCurrency(bid_spread_approved_value);

		var bid_spread_note = $("#textareaAddComment").val();
		bid_spread_note = $.trim(bid_spread_note);

		var attributeGroupName = 'manage-bid_spread-record';
		var attributeSubgroupName = 'bid_spreads';
		var attributeName = 'bid_spread_status_id';
		var uniqueId = bid_spread_id;

		JavaScriptRegistry.set('bid_spread_id', bid_spread_id);
		JavaScriptRegistry.set('bid_spread_status_id', bid_spread_status_id);
		JavaScriptRegistry.set('bid_spread_approved_value', bid_spread_approved_value);
		JavaScriptRegistry.set('bid_spread_note', bid_spread_note);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=bidSpreadDecisionMade';
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&attributeName=' + encodeURIComponent(attributeName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newValue=' + encodeURIComponent(bid_spread_status_id) +
			'&bid_spread_approved_value=' + encodeURIComponent(bid_spread_approved_value) +
			'&bid_spread_note=' + encodeURIComponent(bid_spread_note) +
			'';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		showSpinner();

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: Subcontractor_Bid_Spreadsheet__Approval_Modal__submitBidSpreadDecisionSuccess,
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
				hideSpinner();
			}
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

function Subcontractor_Bid_Spreadsheet__Approval_Modal__submitBidSpreadDecisionSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var json = data;
		var errorNumber = json.errorNumber;

		// Debug
		//errorNumber = 1;

		if (errorNumber == 0) {

			var bid_spread_id = json.uniqueId;
			bid_spread_id = +bid_spread_id;

			var bid_spread_note_id = json.bid_spread_note_id;

			var bid_spread_status_id = JavaScriptRegistry.get('bid_spread_status_id');
			JavaScriptRegistry.unset('bid_spread_status_id');
			bid_spread_status_id = +bid_spread_status_id;

			var bid_spread_approved_value = JavaScriptRegistry.get('bid_spread_approved_value');
			JavaScriptRegistry.unset('bid_spread_approved_value');
			var escaped_bid_spread_approved_value = htmlEncode(bid_spread_approved_value);

			var bid_spread_note = JavaScriptRegistry.get('bid_spread_note');
			JavaScriptRegistry.unset('bid_spread_note');

			// Reset inputs.
			$("#inputBidSpreadApprovedValue").val('');
			$("#textareaAddComment").toggleClass('hidden');
			$("#checkboxAddComment").prop('checked', false);
			$("#textareaAddComment").val('');
			$('input[type=radio][name=bidSpreadApprovalDecision]').prop('checked', false);

			// Update bid spread status column.
			var bidSpreadStatus = BidSpreadStatus.findById(bid_spread_status_id);
			var bid_spread_status_id = bidSpreadStatus.bid_spread_status_id;
			var bid_spread_status = bidSpreadStatus.bid_spread_status;
			$("#manage-bid_spread-record--bid_spreads--bid_spread_status_id--" + bid_spread_id).val(bid_spread_status_id);
			$("#manage-bid_spread-record--bid_spreads--bid_spread_status--" + bid_spread_id).html(bid_spread_status);

			// Append note, if one was added.
			bid_spread_note = bid_spread_note + '';
			if (bid_spread_note.length > 0) {
				var escaped_bid_spread_note = htmlEncode(bid_spread_note);
				var tr = '<tr><td id="record_container--manage-bid_spread_note-record--bid_spread_notes--' + bid_spread_note_id + '" height="30" colspan="4" align="left" valign="middle" style="vertical-align: middle;">' +
					'<a href="javascript:Subcontractor_Bid_Spreadsheet__Approval_Modal__deleteBidSpreadNote(\'record_container--manage-bid_spread_note-record--bid_spread_notes--'+bid_spread_note_id+'\', \'manage-bid_spread_note-record\', \''+bid_spread_note_id+'\')">X</a> ' +
					'<a href="#" onclick="editBidSpreadNote(this, ' + bid_spread_note_id + '); return false;">' + escaped_bid_spread_note + '</a></td></tr>';
				var tableBidSpreadNotes = $("#tableBidSpreadNotes");
				tableBidSpreadNotes.append(tr);
			}

			//loadBidSpreadNotesWithBidSpreadId(bid_spread_id);

			var messageText = 'Bid Spread Status Successfully Set.';
			messageAlert(messageText, 'successMessage');

		} else {

			var errorMessage = json.errorMessage;
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

// Note: This function is not in use
function Subcontractor_Bid_Spreadsheet__Approval_Modal__bidSpreadRejected()
{
	try {

		var bid_spread_id = $("#bid_spread_id").val();
		var textareaAddComment = $("#textareaAddComment");
		var bid_spread_note = textareaAddComment.val();
		bid_spread_note = $.trim(bid_spread_note);
		// Hardcode 'rejected' status.
		var uniqueId = 6;
		var attributeName = 'bid_spread_status';
		var attributeSubgroupName = 'bid_spread_statuses';

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=bidSpreadDecisionMade';
		var ajaxQueryString =
			'bid_spread_id=' + encodeURIComponent(bid_spread_id) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&attributeName=' + encodeURIComponent(attributeName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&bid_spread_note=' + encodeURIComponent(bid_spread_note);
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
			success: Subcontractor_Bid_Spreadsheet__Approval_Modal__bidSpreadRejectedSuccess,
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

// Note: This function is not in use
function Subcontractor_Bid_Spreadsheet__Approval_Modal__bidSpreadRejectedSuccess(data, textStatus, jqXHR)
{
	try {

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__Approval_Modal__bidSpreadSelected(element)
{
	// Show notes/submit section.
	$(".hiddenUntilSpreadIsSelected").removeClass('hidden');

	// Make selected pdf link bold.
	$('.bold').removeClass('bold');
	$(element).next().addClass('bold');

	var bid_spread_id = $(element).val();
	setSubmitButtonText(bid_spread_id);
	loadBidSpreadNotesWithBidSpreadId(bid_spread_id);
	updateSpreadSummary(bid_spread_id);

}

function setSubmitButtonText(bid_spread_id)
{
	$("#selected_bid_spread_id").val(bid_spread_id);
	var virtual_file_name = $("#manage-bid_spread-record--bid_spreads--virtual_file_name--" + bid_spread_id).html();
	virtual_file_name = $.trim(virtual_file_name);
	var bid_spread_status_id = $("#selected_bid_spread_status_id").val();

	var decision = 'Submit';
	var bidSpreadStatus = BidSpreadStatus.findById(bid_spread_status_id);
	if (bidSpreadStatus) {
		decision = bidSpreadStatus.bid_spread_status_action_label;
	}

	var buttonSubmitDecisionText = decision + ' "' + virtual_file_name + '"';
	$("#buttonSubmitDecision").val(buttonSubmitDecisionText);

	var buttonSubmitForApprovalText = 'Submit "' + virtual_file_name + '" For Approval';
	$("#buttonSubmitForApproval").val(buttonSubmitForApprovalText);
}

function updateSpreadSummary(bid_spread_id)
{
	// Get bid total from saved spreadsheet table.
	var bid_spread_bid_total = $("#manage-bid_spread-record--bid_spreads--bid_spread_bid_total--" + bid_spread_id).html();

	var spanPreferredSubcontractValue = $("#preferredSubcontractBidTotal");
	spanPreferredSubcontractValue.html(bid_spread_bid_total);

	// Update approved total input box.
	$("#inputBidSpreadApprovedValue").val(bid_spread_bid_total);

	// Update variance.
	var scheduledValue = $("#preferredSubcontractScheduledValue").html();
	scheduledValue = parseInputToCurrency(scheduledValue);
	bid_spread_bid_total = parseInputToCurrency(bid_spread_bid_total);
	var difference = parseFloat(scheduledValue) - parseFloat(bid_spread_bid_total);
	var variance = formatDollar(difference);
	$("#preferredSubcontractVariance").html(variance);

	var csvBidSpreadPreferredBidders = $("#manage-bid_spread-record--bid_spreads--csvBidSpreadPreferredBidders--" + bid_spread_id).val();
	$("#preferredSubcontractorName").html(csvBidSpreadPreferredBidders);
}

function loadBidSpreadNotesWithBidSpreadId(bid_spread_id)
{
	try {

		var responseDataType = 'json';

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=loadBidSpreadNotesWithBidSpreadId';
		var ajaxQueryString =
			'bid_spread_id=' + encodeURIComponent(bid_spread_id) +
			'&responseDataType=' + encodeURIComponent(responseDataType);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#trBidSpreadNotes").hide();
		$("#tableBidSpreadNotes").hide();

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadBidSpreadNotesWithBidSpreadIdSuccess,
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

function loadBidSpreadNotesWithBidSpreadIdSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		// HTML Record Container Element id Format: id="record_container--recordContainerName--uniqueId"
		// or
		// another format, but passed in dynamically so does not matter
		//var containerElementId = 'container--' + recordContainerName + '--' + uniqueId;
		//if ($("#" + containerElementId).length) {
		if (errorNumber == 0) {

			//var containerElementId = json.containerElementId;
			var containerElementId = 'tableBidSpreadNotes';
			var uniqueId = json.uniqueId;
			var formattedRecordContainerName = json.formattedRecordContainerName;

			// HTML is escaped on the server side
			var htmlContent = json.htmlContent;

			if (htmlContent != '') {
				$("#trBidSpreadNotes").show();
				$("#tableBidSpreadNotes").show();
			}
			$("#" + containerElementId).html(htmlContent);

		} else {

			var errorMessage = json.errorMessage;
			//messageAlert(errorMessage, 'errorMessage', 'errorMessageLabel', containerElementId);
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

function updateSelectedBidSpreadStatusId(bid_spread_status_id)
{
	$("#selected_bid_spread_status_id").val(bid_spread_status_id);
	var bid_spread_id = $("#selected_bid_spread_id").val();
	setSubmitButtonText(bid_spread_id);

	/*
	var currentText = $("#buttonSubmitDecision").val();
	currentText = currentText.substring(currentText.indexOf('"Bid Spread'));
	if (bid_spread_status_id == 1) {
		var prefix = 'Reset';
	} else {
		var prefix = arrBidSpreadStatus[bid_spread_status_id];
	}
	var buttonText = prefix + ' ' + currentText;
	$("#buttonSubmitDecision").val(buttonText);
	*/

	var bidSpreadStatus = BidSpreadStatus.findById(bid_spread_status_id);
	var bid_spread_status = bidSpreadStatus.bid_spread_status;
	if (bid_spread_status == 'Approved' || bid_spread_status == 'Approved with No Exceptions') {
		$("#divBidSpreadApprovalInfo").removeClass('hidden');
		var approvedValue = $("#preferredSubcontractBidTotal").html();
		$("#inputBidSpreadApprovedValue").val(approvedValue);
	} else {
		$("#divBidSpreadApprovalInfo").addClass('hidden');
	}
}


function isSubtotal(str)
{
	//  To get rid of the read property error
	if (str == undefined || str == 'undefined') {
		return false;
	}

	if (str != 'undefined' || str != undefined) {
		str = str.replace(' ', '');
		return str.toLowerCase().includes("subtotal");
	}
}

function Subcontractor_Bid_Spreadsheet__updateBidDerivedSubtotals(subcontractor_bid_id)
{
	var classNameUnitTotal = 'unitTotal--' + subcontractor_bid_id;
	var subtotalStartIndex = 0;
	var rows = $(".rowBidItems");
	for (var i = 0; i < rows.length; i++) {
		var row = rows[i];
		var isSubcontractorInterface = $("#isSubcontractorInterface").val();
		if (isSubcontractorInterface == 'true') {
			if ($(row).hasClass('scBidItem')) {
				var bidItemDescription = $(row).find('.sc_bid_item').val();
			} else {
				var bidItemDescription = $(row).find('.bid_item').html();
			}
		} else {
			var bidItemDescription = $(row).find('.bid_item').val();
		}

		if (isSubtotal(bidItemDescription)) {

			var subtotal = 0.00;
			for (var j = subtotalStartIndex; j < i; j++) {
				subtotal = parseInputToCurrency(subtotal);

				var tempRow = rows[j];
				var totalCell = $(tempRow).find('.'+classNameUnitTotal);
				if (totalCell.hasClass('exclude')) {
					continue;
				}
				var total = $(totalCell).val();

				if (total != '') {
					total = parseInputToCurrency(total);
					subtotal = parseFloat(subtotal) + parseFloat(total);
				}
			}

			subtotal = formatDollar(subtotal);
			var subtotalInput = $(row).find('.subtotal-input.'+classNameUnitTotal);
			$(subtotalInput).val(subtotal);
			subtotalStartIndex = i + 1;

		}
	}
}

function Subcontractor_Bid_Spreadsheet__updateVariance(subcontractor_bid_id)
{
	if ($("#totalPrimeContractScheduledValue").length) {
		var prime_contract_scheduled_value = $("#totalPrimeContractScheduledValue").html();
	} else {
		var prime_contract_scheduled_value = $("#prime_contract_scheduled_value").html();
	}

	if ($("#totalForecastedExpenses").length) {
		var forecasted_expenses = $("#totalForecastedExpenses").html();
	} else {
		var forecasted_expenses = $("#forecasted_expenses").html();
	}

	var bidTotal = $("#derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--"+subcontractor_bid_id).val();

	prime_contract_scheduled_value = parseInputToCurrency(prime_contract_scheduled_value);
	forecasted_expenses = parseInputToCurrency(forecasted_expenses);
	bidTotal = parseInputToCurrency(bidTotal);

	var invariance =$("#invariance").val();
	if(invariance =='Y')
	{
		var variance = parseFloat(prime_contract_scheduled_value) - (parseFloat(forecasted_expenses) + parseFloat(bidTotal));
	}else{
		var variance = parseFloat(prime_contract_scheduled_value) - parseFloat(bidTotal);
	}
	if (variance < 0) {
		$("#variance_ttl-"+subcontractor_bid_id).addClass('red');
	} else {
		$("#variance_ttl-"+subcontractor_bid_id).removeClass('red');
	}

	var formattedVariance = formatDollar(variance);
	$("#variance_ttl-"+subcontractor_bid_id).val(formattedVariance);

}

function Subcontractor_Bid_Spreadsheet__updateBidTotalCostPerGrossSquareFoot(subcontractor_bid_id)
{
	try {

		var project_id = $("#project_id").val();
		var derived_subcontractor_bid_total = $("#derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--" + subcontractor_bid_id).val();
		var project_gross_square_footage = $("#subcontrator_bid_spread_reference_data-project-record--projects--gross_square_footage--" + project_id).val();

		if ((typeof derived_subcontractor_bid_total != 'undefined') && (derived_subcontractor_bid_total != '')) {
			var subcontractorBidTotalExistsFlag = true;
		} else {
			var subcontractorBidTotalExistsFlag = false;
		}

		if ((typeof project_gross_square_footage != 'undefined') && (project_gross_square_footage != '') && (project_gross_square_footage != '0')) {
			var grossSquareFootageExistsFlag = true;
		} else {
			var grossSquareFootageExistsFlag = false;
		}

		if (subcontractorBidTotalExistsFlag && grossSquareFootageExistsFlag) {

			derived_subcontractor_bid_total = parseInputToCurrency(derived_subcontractor_bid_total);
			project_gross_square_footage = parseInputToCurrency(project_gross_square_footage);

			var subcontractorBidTotalCostPerGrossSquareFoot = parseFloat(derived_subcontractor_bid_total) / parseFloat(project_gross_square_footage);
			subcontractorBidTotalCostPerGrossSquareFoot = formatDollar(subcontractorBidTotalCostPerGrossSquareFoot);

		} else {
			var subcontractorBidTotalCostPerGrossSquareFoot = '';
		}

		$("#subcontractorBidTotalCostPerGrossSquareFoot--" + subcontractor_bid_id).val(subcontractorBidTotalCostPerGrossSquareFoot);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__updateBidTotalCostPerNetRentableSquareFoot(subcontractor_bid_id)
{
	try {

		var project_id = $("#project_id").val();
		var derived_subcontractor_bid_total = $("#derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--" + subcontractor_bid_id).val();
		var project_net_rentable_square_footage = $("#subcontrator_bid_spread_reference_data-project-record--projects--net_rentable_square_footage--" + project_id).val();

		if ((typeof derived_subcontractor_bid_total != 'undefined') && (derived_subcontractor_bid_total != '')) {
			var subcontractorBidTotalExistsFlag = true;
		} else {
			var subcontractorBidTotalExistsFlag = false;
		}

		if ((typeof project_net_rentable_square_footage != 'undefined') && (project_net_rentable_square_footage != '') && (project_net_rentable_square_footage != '0')) {
			var netRentableSquareFootageExistsFlag = true;
		} else {
			var netRentableSquareFootageExistsFlag = false;
		}

		if (subcontractorBidTotalExistsFlag && netRentableSquareFootageExistsFlag) {

			derived_subcontractor_bid_total = parseInputToCurrency(derived_subcontractor_bid_total);
			project_net_rentable_square_footage = parseInputToInt(project_net_rentable_square_footage);

			var subcontractorBidTotalCostPerNetRentableSquareFoot = parseFloat(derived_subcontractor_bid_total) / parseFloat(project_net_rentable_square_footage);
			subcontractorBidTotalCostPerNetRentableSquareFoot = formatDollar(subcontractorBidTotalCostPerNetRentableSquareFoot);

		} else {
			var subcontractorBidTotalCostPerNetRentableSquareFoot = '';
		}

		$("#subcontractorBidTotalCostPerNetRentableSquareFoot--" + subcontractor_bid_id).val(subcontractorBidTotalCostPerNetRentableSquareFoot);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontractor_Bid_Spreadsheet__updateBidTotalCostPerUnit(subcontractor_bid_id)
{
	try {

		var project_id = $("#project_id").val();
		var derived_subcontractor_bid_total = $("#derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--" + subcontractor_bid_id).val();
		var project_unit_count = $("#subcontrator_bid_spread_reference_data-project-record--projects--unit_count--" + project_id).val();

		if ((typeof derived_subcontractor_bid_total != 'undefined') && (derived_subcontractor_bid_total != '')) {
			var subcontractorBidTotalExistsFlag = true;
		} else {
			var subcontractorBidTotalExistsFlag = false;
		}

		if ((typeof project_unit_count != 'undefined') && (project_unit_count != '')) {
			var unitCountExistsFlag = true;
		} else {
			var unitCountExistsFlag = false;
		}

		if (subcontractorBidTotalExistsFlag && unitCountExistsFlag) {

			derived_subcontractor_bid_total = parseInputToCurrency(derived_subcontractor_bid_total);
			project_unit_count = parseInputToInt(project_unit_count);

			var subcontractorBidTotalCostPerUnit = parseFloat(derived_subcontractor_bid_total) / parseFloat(project_unit_count);
			subcontractorBidTotalCostPerUnit = formatDollar(subcontractorBidTotalCostPerUnit);

		} else {
			var subcontractorBidTotalCostPerUnit = '';
		}

		$("#subcontractorBidTotalCostPerUnit--" + subcontractor_bid_id).val(subcontractorBidTotalCostPerUnit);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleAllExcludeCheckboxesInColumn(element, subcontractor_bid_id)
{
	var checked = $(element).prop('checked');
	var className = 'exclude_bid_item_flag--' + subcontractor_bid_id;
	$('input[type=checkbox].'+className).not('.subtotal-input').each(function() {
		if ($(this).prop('checked') != checked) {
			$(this).prop('checked', checked);
			this.onclick();
		}
	});

}

function Subcontractor_Bid_Spreadsheet__updateAllBidTotalSummarySections()
{
	var csvSubcontractorBidIds = $("#csvSubcontractorBidIds").val();
	var arrSubcontractorBidIds = csvSubcontractorBidIds.split(',');
	for (var i = 0; i < arrSubcontractorBidIds.length; i++) {
		var subcontractor_bid_id = arrSubcontractorBidIds[i];
		//Subcontractor_Bid_Spreadsheet__updateBidDerivedSubtotals(subcontractor_bid_id);
		$(".rowBidItems").each(function() {
			var arrTemp = this.id.split('--');
			var sc_bid_item_id = arrTemp[3];
			var uniqueId = subcontractor_bid_id + '-' + sc_bid_item_id;
			Subcontractor_Bid_Spreadsheet__calculateBidItemToSubcontractorBidTotal(this, uniqueId);
		});
		Subcontractor_Bid_Spreadsheet__updateBidTotalSummarySection(subcontractor_bid_id);
	}
}

function reloadBidItemSortOrdersByGcBudgetLineItemId()
{
	try {

		var gc_budget_line_item_id = $("#gc_budget_line_item_id").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=reloadBidItemSortOrdersByGcBudgetLineItemId';
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
			success: reloadBidItemSortOrdersByGcBudgetLineItemIdSuccess,
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

function reloadBidItemSortOrdersByGcBudgetLineItemIdSuccess(data, textStatus, jqXHR)
{
	try {

		var arrBidItems = data;
		for (var i = 0; i < arrBidItems.length; i++) {
			var bidItem = arrBidItems[i];
			var bid_item_id = bidItem.bid_item_id;
			var sort_order = bidItem.sort_order;
			var bidItemSortOrderElementId = 'manage-bid_item-record--bid_items--sort_order--' + bid_item_id;
			$("#" + bidItemSortOrderElementId).val(sort_order);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

var BidSpreadStatus = {
	findById: function(bid_spread_status_id) {
		for (var i = 0; i < arrBidSpreadStatuses.length; i++) {
			var bidSpreadStatus = arrBidSpreadStatuses[i];
			if (bidSpreadStatus.bid_spread_status_id == bid_spread_status_id) {
				return bidSpreadStatus;
			}
		}
		return false;
	},
	findByBidSpreadStatus: function(bid_spread_status) {
		for (var i = 0; i < arrBidSpreadStatuses.length; i++) {
			var bidSpreadStatus = arrBidSpreadStatuses[i];
			if (bidSpreadStatus.bid_spread_status == bid_spread_status) {
				return bidSpreadStatus;
			}
		}
		return false;
	}
};

function toggleExcludeClass(element, subcontractor_bid_id)
{
	var tr = $(element).closest('tr');
	tr.find('.unitTotal--' + subcontractor_bid_id).toggleClass('exclude');
}

function loadBidSpreadApprovalProcessDialog()
{
	try {

		var gc_budget_line_item_id = $("#gc_budget_line_item_id").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=loadBidSpreadApprovalProcessDialog';
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
			success: loadBidSpreadApprovalProcessDialogSuccess,
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

function loadBidSpreadApprovalProcessDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.99;
		var dialogHeight = windowHeight * 0.98;

		$("#divBidSpreadApprovalProcessDialog").html(data);
		$("#divBidSpreadApprovalProcessDialog").removeClass('hidden');
		$("#divBidSpreadApprovalProcessDialog").dialog({
			modal: true,
			title: 'Bid Spread Approval Process',
			width: dialogWidth,
			height: dialogHeight,
			open: function() {
				$("body").addClass('noscroll');
				initializeSpreadSummaryData();
			},
			close: function() {
				$("body").removeClass('noscroll');
			}
		});
		$(".mulselinitial").fSelect();
		$('.fs-label').html('All');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleSpreadDetails()
{
	$('.detailsRow').toggleClass('hidden');
	var hidden = $('.detailsRow').hasClass('hidden');
	ClientVars.set('bidSpreadDetailsRowHidden', hidden);
}

function initializeSpreadSummaryData()
{
//	var preferred_subcontractor_bid_id = $("#preferred_subcontractor_bid_id").val();
//	if (preferred_subcontractor_bid_id) {
//		var spanPreferredSubcontractorName = $("#preferredSubcontractorName");
//		var preferredSubcontractorName = $("#manage-subcontractor_bid-record--subcontractor_bids--company--" + preferred_subcontractor_bid_id).html();
//		spanPreferredSubcontractorName.html(preferredSubcontractorName);
//
//		var preferredSubcontractBidTotal = $("#derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--" + preferred_subcontractor_bid_id).val();
//		$("#preferredSubcontractBidTotal").html(preferredSubcontractBidTotal);
//
//		var preferredSubcontractVariance = $("#variance_ttl-" + preferred_subcontractor_bid_id).val();
//		$("#preferredSubcontractVariance").html(preferredSubcontractVariance);
//	} else {
//		$("#preferredSubcontractorName").html('');
//		$("#preferredSubcontractBidTotal").html('');
//		$("#preferredSubcontractVariance").html('');
//	}

}

function createDummyScBidItem()
{
	try {

		var gc_budget_line_item_id = $("#gc_budget_line_item_id").val();
		var subcontractor_bid_id = $("#subcontractor_bid_id").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=createDummyScBidItem';
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
			success: createDummyScBidItemSuccess,
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

function createDummyScBidItemSuccess(data, textStatus, jqXHR)
{
	try {

		$("#tableBidItems tbody").append(data);
		Subcontractor_Bid_Spreadsheet__adjustFormElementSizes();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function renderEmptyBidItemRowOnBidSpread()
{
	try {

		var gc_budget_line_item_id = $("#gc_budget_line_item_id").val();
		var csvSubcontractorBidIds = $("#csvSubcontractorBidIds").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php?method=renderEmptyBidItemRowOnBidSpread';
		var ajaxQueryString =
			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&csvSubcontractorBidIds=' + encodeURIComponent(csvSubcontractorBidIds);
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
			success: renderEmptyBidItemRowOnBidSpreadSuccess,
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

function renderEmptyBidItemRowOnBidSpreadSuccess(data, textStatus, jqXHR)
{
	try {

		$(".addPrependRow").before(data);
		Subcontractor_Bid_Spreadsheet__adjustFormElementSizes();
		Subcontractor_Bid_Spreadsheet__addKeyEventListeners();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function subcontract__updateViaPromiseChain(element,bid_ids)
{
	var id=element.id;
	var new_val;
	if($("#"+id).prop('checked') == true)
	{
		 new_val='Y';
	}else{
		 new_val='N';
	}
	var id_data=id.split('--');
	var ajaxUrl = window.ajaxUrlPrefix + 'modules-purchasing-bid-spread-ajax.php';
		$.ajax({
		method:'GET',
		url:ajaxUrl,
		data:'method=GCbugetUpdate&table='+id_data[1]+'&column='+id_data[2]+'&primary_id='+id_data[3]+'&new_val='+new_val,
		success:function(data)
		{
			
			$("#invariance").val(new_val);
			if(new_val =='Y')
			{
				$("#varspan").html("Variance [PCSV - (FE + Bid)]");

			}else{
				$("#varspan").html("Variance [PCSV - Bid]");
			}
			var subcontractor_bid_id = bid_ids.split('-');
			// bid_ids.split('-');
			for (var i = 0; i < subcontractor_bid_id.length; i++) {
				Subcontractor_Bid_Spreadsheet__updateVariance(subcontractor_bid_id[i]);
				
			}
			
		}

	});
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

var PreferredSubcontractorBidIds = {
	contains: function(subcontractor_bid_id) {
		var csvPreferredSubcontractorBidIds = $("#csvPreferredSubcontractorBidIds").val();
		var arrPreferredSubcontractorBidIds = csvPreferredSubcontractorBidIds.split(',');
		for (var i = 0; i < arrPreferredSubcontractorBidIds.length; i++) {
			if (arrPreferredSubcontractorBidIds[i] == subcontractor_bid_id) {
				return true;
			}
		}
		return false;
	},
	add: function(subcontractor_bid_id) {
		var csvPreferredSubcontractorBidIds = $("#csvPreferredSubcontractorBidIds").val();
		if (csvPreferredSubcontractorBidIds) {
			var arrPreferredSubcontractorBidIds = csvPreferredSubcontractorBidIds.split(',');
		} else {
			var arrPreferredSubcontractorBidIds = [];
		}
		arrPreferredSubcontractorBidIds.push(subcontractor_bid_id);
		csvPreferredSubcontractorBidIds = arrPreferredSubcontractorBidIds.join(',');
		$("#csvPreferredSubcontractorBidIds").val(csvPreferredSubcontractorBidIds);
	},
	remove: function(subcontractor_bid_id) {
		var csvPreferredSubcontractorBidIds = $("#csvPreferredSubcontractorBidIds").val();
		var arrPreferredSubcontractorBidIds = csvPreferredSubcontractorBidIds.split(',');
		var index = arrPreferredSubcontractorBidIds.indexOf(subcontractor_bid_id);
		arrPreferredSubcontractorBidIds.splice(index, 1);
		csvPreferredSubcontractorBidIds = arrPreferredSubcontractorBidIds.join(',');
		$("#csvPreferredSubcontractorBidIds").val(csvPreferredSubcontractorBidIds);
	},
	toggle: function(subcontractor_bid_id) {
		if (this.contains(subcontractor_bid_id)) {
			this.remove(subcontractor_bid_id);
		} else {
			this.add(subcontractor_bid_id);
		}
	}
};
