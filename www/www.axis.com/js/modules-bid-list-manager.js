function ddlBidListChanged() {
	$("#tblTradesByCompany").hide();
	var bid_list_id = $("#ddlBidList").val();
	var bName = $("#ddlBidList option:selected").text();
	if (bid_list_id == 0) {
		$("#txtBidListName").val(' ');
		$("#spanBidListName").html('&nbsp;');
		$("#divBidListDetails").hide();
	} else {
		$("#txtBidListName").val(bName);
		$("#spanBidListName").html(bName);
		$("#divBidListDetails").show();
	}
	reloadListContacts();

	$("#refreshBidListDetails").show();
}

function reloadListContacts()
{
	try {

		var bid_list_id = $("#ddlBidList").val();
		bid_list_id = $.trim(bid_list_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bid-list-manager-ajax.php?method=loadBidListContacts';
		var ajaxQueryString =
			'bid_list_id=' + encodeURIComponent(bid_list_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		//$("#divListContacts").load('modules-bid-list-manager-ajax.php?method=loadBidListContacts&bid_list_id=' + encodeURIComponent(bid_list_id));
		$("#divListContacts").load(ajaxUrl);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function showCreateNewBidList() {
	$("#divNewList").show();
	$("#divBidListDetails").hide();
	$("#ddlBidListDiv").hide();
}

function btnCancelNewBidListClicked() {
	//alert('clicked');
	$("#divNewList").hide();
	$("#ddlBidListDiv").show();

	var bid_list_id = $("#ddlBidList").val();
	if (bid_list_id != 0) {
		$("#divBidListDetails").show();
	}
}

function btnCreateNewBidListClicked()
{
	try {

		var newName = $("#txtNewBidListName").val();
		newName = $.trim(newName);
		if (newName.length > 0) {
			var ajaxHandler = window.ajaxUrlPrefix + 'modules-bid-list-manager-ajax.php?method=createNewBidList';
			var ajaxQueryString =
				'newValue=' + encodeURIComponent(newName);
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
				success: createNewBidListSuccess,
				error: errorHandler
			});
		} else {
			alert('Please enter a name for the new bid list');
			$("#txtNewBidListName").focus();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createNewBidListSuccess(response, textStatus, jqXHR)
{
	try {

		$("#ddlBidListDiv").html(response);
		var messageText = 'Bid list successfully created.';
		messageAlert(messageText, 'successMessage');
		btnCancelNewBidListClicked();
		ddlBidListChanged();
		$("#divBidListDetails").show();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateBidListName()
{
	try {

		var bid_list_id = $("#ddlBidList").val();
		bid_list_id = $.trim(bid_list_id);
		var newName = $("#txtBidListName").val();
		newName = $.trim(newName);
		if (bid_list_id != 0) {
			var ajaxHandler = window.ajaxUrlPrefix + 'modules-bid-list-manager-ajax.php?method=updateBidListName';
			var ajaxQueryString =
				'bid_list_id=' + encodeURIComponent(bid_list_id) +
				'&newValue=' + encodeURIComponent(newName);
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
				success: updateBidListNameSuccess,
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

function updateBidListNameSuccess(response, textStatus, jqXHR)
{
	try {

		$("#ddlBidListDiv").html(response);
		var messageText = 'Bid list name successfully updated.';
		messageAlert(messageText,'successMessage','successMessageLabel','txtBidListName');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteSelectedBidList()
{
	try {

		var bid_list_id = $("#ddlBidList").val();
		bid_list_id = $.trim(bid_list_id);
		var bName = $("#ddlBidList option:selected").text();
		var answer = confirm('Are you sure you want to delete the "'+bName+'" bid list? ('+bid_list_id+')');
		if (answer) {
			var ajaxHandler = window.ajaxUrlPrefix + 'modules-bid-list-manager-ajax.php?method=removeBidList';
			var ajaxQueryString =
				'bid_list_id=' + encodeURIComponent(bid_list_id);
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
				success: removeBidListSuccess,
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

function removeBidListSuccess(response, textStatus, jqXHR)
{
	try {

		$("#ddlBidListDiv").html(response);
		var messageText = 'Bid list successfully removed.';
		messageAlert(messageText, 'successMessage');
		ddlBidListChanged();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function removeCompanyFromBidList(bid_list_id, contact_company_id, company_name)
{
	try {

		var answer = confirm('Are you sure you want to remove all "'+company_name+'" contacts from this bid list?');
		if (answer) {
			bid_list_id = $.trim(bid_list_id);
			contact_company_id = $.trim(contact_company_id);
			var ajaxHandler = window.ajaxUrlPrefix + 'modules-bid-list-manager-ajax.php?method=removeCompanyFromBidList';
			var ajaxQueryString =
				'bid_list_id=' + encodeURIComponent(bid_list_id) +
				'&contact_company_id=' + encodeURIComponent(contact_company_id);
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
				success: contactToBidListChangeSuccess,
				error: errorHandler
			});
			$("#tblTradesByCompany").hide();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function searchContactSelected_divBidListDetails(element, contact_id, name, email)
{
	try {

		contact_id = $.trim(contact_id);
		var bid_list_id = $("#ddlBidList").val();
		bid_list_id = $.trim(bid_list_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bid-list-manager-ajax.php?method=addContactToBidList';
		var ajaxQueryString =
			'bid_list_id=' + encodeURIComponent(bid_list_id) +
			'&contact_id=' + encodeURIComponent(contact_id);
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
			success: contactToBidListChangeSuccess,
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

function removeContactFromBidList(bid_list_id, contact_id, contact_name)
{
	try {

		var answer = confirm('Are you sure you want to remove "'+contact_name+'" from this bid list?');
		if (answer) {
			bid_list_id = $.trim(bid_list_id);
			contact_id = $.trim(contact_id);

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-bid-list-manager-ajax.php?method=removeContactFromBidList';
			var ajaxQueryString =
				'bid_list_id=' + encodeURIComponent(bid_list_id) +
				'&contact_id=' + encodeURIComponent(contact_id);
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
				success: contactToBidListChangeSuccess,
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

function contactToBidListChangeSuccess(response, textStatus, jqXHR)
{
	try {

		var messageText = 'Contact successfully added to bid list.';
		messageAlert(messageText, 'successMessage');
		$("#divListContacts").html(response);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function bidListCompanySelected(contact_company_id, companyName, manageBidListFlag)
{
	try {

		var bid_list_id = $("#ddlBidList").val();
		$("#contact_company_id").val(contact_company_id);
		$("#tblTradesByCompany").show();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-bid-list-manager-ajax.php?method=loadTradesPerformedByCompany';
		var ajaxQueryString =
			'bid_list_id=' + encodeURIComponent(bid_list_id) +
			'&contact_company_id=' + encodeURIComponent(contact_company_id) +
			'&companyName=' + encodeURIComponent(companyName);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#tblTradesByCompany").load(ajaxUrl);
		//$("#tblTradesByCompany").load('modules-bid-list-manager-ajax.php?method=loadTradesPerformedByCompany&bid_list_id=' +
		// encodeURIComponent(bid_list_id) + '&contact_company_id=' + encodeURIComponent(contact_company_id) + '&companyName=' + encodeURIComponent(companyName) );
		//$("#spanSelectedBidListCompany").html(htmlText);
		//$("#divCompanyTrade").load('modules-bid-list-manager-ajax.php?method=loadTradesPerformedByCompany&contact_company_id=' + encodeURIComponent(contact_company_id) + '&company=' + encodeURIComponent(companyName) );

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function addTradeToCompany()
{
	try {

		var contact_company_id = $("#contact_company_id").val();
		var cost_code_id = $("#ddlCompanyTrade").val();

		contact_company_id = $.trim(contact_company_id);
		cost_code_id = $.trim(cost_code_id);

		if (contact_company_id.length == 0) {
			messageText = 'An unknown error has occurred.';
			messageAlert(messageText,'errorMessage');
		} else if ((contact_company_id.length > 0) && (cost_code_id != 0)) {
			var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=addTradeToContactCompany';
			var ajaxQueryString =
				'contact_company_id=' + encodeURIComponent(contact_company_id) +
				'&cost_code_id=' + encodeURIComponent(cost_code_id);
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
				success: changeTradeFromCompanySuccess,
				error: errorHandler
			});
		} else {
			messageText = 'Please select a trade from the drop down list of trades.';
			messageAlert(messageText,'infoMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function removeTradeFromCompany(contact_company_id, cost_code_id)
{
	try {
		contact_company_id = $.trim(contact_company_id);
		cost_code_id = $.trim(cost_code_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=removeTradeFromContactCompany';
		var ajaxQueryString =
			'contact_company_id=' + encodeURIComponent(contact_company_id) +
			'&cost_code_id=' + encodeURIComponent(cost_code_id);
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
			success: changeTradeFromCompanySuccess,
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

function changeTradeFromCompanySuccess(response, textStatus, jqXHR)
{
	try {

		$("#divCompanyTrade").html(response);
		reloadListContacts();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}

}
