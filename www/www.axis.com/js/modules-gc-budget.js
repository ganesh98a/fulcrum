
if (!jQuery) {
	alert('JQuery is either not loaded or unavailable.');
}
function checkprojectcustomerexist(){
	var owner_name = $("#project_customer").val();
	$.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
		{'action':'checkprojectcustomerexist','owner_name':owner_name}, function(data){
		if($.trim(data) =='exists'){
			$('.current_indicator').addClass('green-text');
			$('.current_indicator').removeClass('red-text');
		}else{
			$('.current_indicator').addClass('red-text');
			$('.current_indicator').removeClass('green-text');
		}
	});
}
// Document.ready
(function($) {
	$(document).ready(function() {
	jQuery('#subtotalview').change(function() {
		var welcomeForm = $("#subtotalview").is(':checked');
		if (welcomeForm) {
			jQuery('.bottom-content').show();
			var is_subtotal = '1';
		} else {
			jQuery('.bottom-content').hide();
			var is_subtotal = '0';
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=updateIsSubtotal';
		var ajaxQueryString =
			'is_subtotal=' +is_subtotal;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function()
			{
			},
			error: errorHandler
		});
	});
	$(".bs-tooltip").tooltip();
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });

	
	Gc_Budget__updateBudgetTotals(true);
	checkprojectcustomerexist();

	// to initiate the Notes popover
	$(".btnAddNotesPopover").popover({
		html: true,
		title: 'Add/Edit Notes',
		content: function() {
			var b_id = this.id.split('_');
			var bud_id = b_id[1];
			var content = $("#CreateNotesdiv_"+bud_id).html();
			$("#CreateNotesdiv_"+bud_id).html('');
			$(this).on('hide.bs.popover', function() {
				$("#CreateNotesdiv_"+bud_id).html(content);
			});
			retrieveNotesData(bud_id);

			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});

	

	$(document).on('change','.subcontract_templates',function(){ // To get the Type of Template
		var subcontract_template_id = this.id;
		var subcontract_template_id_arr = subcontract_template_id.split('--');
		var subcontract_template = this.value;
		$('.customer_project').hide();
		if(subcontract_template){
			$.get('/app/controllers/subcontract_invoice_cntrl.php',
				{'action': 'checkSubContractTemplateType','subcontract_template_id':subcontract_template},
				function(data){
				if(data.error ==''){
					$('#TemplateType--'+subcontract_template_id_arr[3]).html(data.template_type);
					$('#is_PO--'+subcontract_template_id_arr[3]).val(data.is_po);
					$('#is_gl_account_available--'+subcontract_template_id_arr[3]).val(data.is_gl_account_available);
					$('#gl_account_id--'+subcontract_template_id_arr[3]).val(data.gl_account_id);
					if(data.is_po =='1'){
						$('.customer_project').show();
					}
				}else{
					messageAlert(data.error, 'errorMessage');
					$('#is_PO--'+subcontract_template_id_arr[3]).val('0');
					$('#is_gl_account_available--'+subcontract_template_id_arr[3]).val('0');
					$('#gl_account_id--'+subcontract_template_id_arr[3]).val('0');
				}
			});
				
		}else if(subcontract_template_id_arr[3]){
			$('#TemplateType--'+subcontract_template_id_arr[3]).html('No Subcontract Template Selected.');
			$('#is_PO--'+subcontract_template_id_arr[3]).val('0');
			$('#is_gl_account_available--'+subcontract_template_id_arr[3]).val('0');
			$('#gl_account_id--'+subcontract_template_id_arr[3]).val('0');
		}
	});
});
})(jQuery);
$('body').on('click', function (e) {
	
	if (typeof $(e.target).data('original-title') == 'undefined' &&
	!$(e.target).parents().is('.popover.in')) {
		$('[data-original-title]').popover('hide');
	}
});
function closenotes(budget_id)
{
	$("#btnAddNotesPopover_"+budget_id).next( "div" ).css('display',"none");
	$("#btnAddNotesPopover_"+budget_id).removeClass('entypo-plus-circled');
	$("#btnAddNotesPopover_"+budget_id).addClass('entypo-doc-text');

}
function retrieveNotesData(bud_id)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=NotesData';
	var ajaxQueryString =
	'Budget_id=' + bud_id;
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function(data){
			$('#manage-gc_budget_line_item-record--gc_budget_line_items--notes--'+bud_id).val(data);
		},
		error: errorHandler
	});
}


function changeFormatValue(value,id,element){
	var valuejs = filterAndFormatMonetaryValueInPlace(element);
	value = valuejs.newValue;
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=cashValueFormat';
	var ajaxQueryString =
	'valueCost=' + value;
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function(data){
			$('#'+id).val(data);
		},
		error: errorHandler
	});
}
function adjustInputSizes(tblName)
{
	var colCount = 0;
	$("#" + tblName + " tr:nth-child(1) th").each(function () {
		colCount ++;
		var newSize = 10;
		$("#" + tblName + " tr > :nth-child("+colCount+") input:text:visible").each(function() {
			var size = $(this).val().length * 6;
			if (size > newSize) {
				newSize = size;
			}
		});
		$("#" + tblName + " tr > :nth-child("+colCount+") input:text:visible").css('width', newSize + 30);
	});
}

function loadBudgetByProjectId(url, company_id)
{
	var elem = document.getElementById('project_id');
	var projectIdAndUserCompanyId = elem.options[elem.selectedIndex].value;

	if (projectIdAndUserCompanyId == '') {
		var finalUrl = url;
	} else {
		var arrTmp = projectIdAndUserCompanyId.split('--');
		var project_id = arrTmp[0];
		var user_company_id = arrTmp[1];
		var finalUrl = url+'?importFromProjectUserCompanyId='+user_company_id+'&importFromProjectId='+project_id;
	}

	document.location=finalUrl;
}

function Gc_Budget__updateBudgetTotals(formatValuesInline)
{
	var primeContractScheduledValuesTotal = autoSumByClass('autosum-pcsv', 'primeContractScheduledValuesTotal', formatValuesInline);
	var forecastedExpensesTotal = autoSumByClass('autosum-fe', 'forecastedExpensesTotal', formatValuesInline);
	// var subcontractActualValuesTotal = autoSumByClass('autosum-sav', 'subcontractActualValuesTotal', formatValuesInline);

	Gc_Budget__updateVariance();

	Gc_Budget__finalBudgetTotal();


}

function Gc_Budget__updateVariance()
{
	try {

		var total = 0.00;

		// 'autosum-pcsv'
		// 'autosum-fe'
		// 'autosum-sav'
		// manage-gc_budget_line_item-record--gc_budget_line_items--prime_contract_scheduled_value--2209
		// manage-gc_budget_line_item-record--gc_budget_line_items--forecasted_expenses--2209

		// gc_budget_line_items--subcontracts--subcontract_actual_value--subcontract_id
		// or
		// since this is a read-only value here...
		// manage-gc_budget_line_item-record--gc_budget_line_items--subcontract_actual_value--2209

		// manage-gc_budget_line_item-record--gc_budget_line_items--variance--2209

		var arrValues = $(".autosum-pcsv");

		arrValues.each(function(index, element) {

			if ($(this).is('input')) {
				var elementType = 'htmlInput';
			} else {
				var elementType = 'htmlTd';
			}

			if (elementType == 'htmlInput') {
				var tmpValue = $(this).val();
			} else {
				var tmpValue = $(this).html();
			}

			var value = parseInputToCurrency(tmpValue);

			var primeContractScheduledValue = value;

			var primeContractScheduledValueId = $(this).attr('id');
			var arrIdValues = primeContractScheduledValueId.split('--');
			var attributeGroup = arrIdValues[0];
			var attributeSubgroup = arrIdValues[1];
			var attributeName = arrIdValues[2];
			var gc_budget_line_item_id = arrIdValues[3];

			var forecastedExpensesId = attributeGroup + '--' + attributeSubgroup + '--' + 'forecasted_expenses' + '--' + gc_budget_line_item_id;
			var forecastedExpenses = parseInputToCurrency($("#" + forecastedExpensesId).val());
			var buyoutForecastedExpensesId = attributeGroup + '--' + attributeSubgroup + '--' + 'buyout_forecasted_expenses' + '--' + gc_budget_line_item_id;
			var buyoutForecastedExpenses = parseInputToCurrency($("#" + buyoutForecastedExpensesId).val());
			var subcontractActualValueId = attributeGroup + '--' + attributeSubgroup + '--' + 'subcontract_actual_value' + '--' + gc_budget_line_item_id;
			var subcontractActualValue = parseInputToCurrency($("#" + subcontractActualValueId).html());
			var varianceId = attributeGroup + '--' + attributeSubgroup + '--' + 'variance' + '--' + gc_budget_line_item_id;
			var ocoId = attributeGroup + '--' + attributeSubgroup + '--' + 'ocoValue' + '--' + gc_budget_line_item_id;
			var ocoValue = parseInputToCurrency($("#" + ocoId).html());
			var aboveOrBelow = $("#" + ocoId).attr("data-value");
			var vendorList = attributeSubgroup + '--' + 'vendorList' + '--' + gc_budget_line_item_id;
			var vendorData = $("#" + vendorList).html();
			if(vendorData){
				var variance = parseFloat(primeContractScheduledValue) - (parseFloat(forecastedExpenses) + parseFloat(subcontractActualValue));
			}else{
				var variance = parseFloat(primeContractScheduledValue) - (parseFloat(forecastedExpenses) + parseFloat(buyoutForecastedExpenses) + parseFloat(subcontractActualValue));
			}
			if(aboveOrBelow == 2)
			{
				variance = variance + parseFloat(ocoValue);
			}
			var variance = parseInputToCurrency(variance);

			if (variance !== '0.00') {


				total = parseInputToCurrency(total);

				// tabulate total value
				total = parseFloat(total) + parseFloat(variance);

				if (variance < 0) {
					$("#" + varianceId).addClass('red');
				} else {
					$("#" + varianceId).removeClass('red');
				}

				var formattedVariance = formatDollar(variance);
				$("#" + varianceId).html(formattedVariance);
			} else {
				$("#" + varianceId).html('');
			}

		});

		if (total < 0) {
			$("#varianceTotal").addClass('red');
		} else {
			$("#varianceTotal").removeClass('red');
		}


		formattedTotal = formatDollar(total);

		$("#varianceTotal").val(formattedTotal);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updatePrimeContractScheduledValuesTotal(moneyFormat)
{
	if ((typeof moneyFormat == 'string') && (moneyFormat == 'currency')) {
		moneyFormat = true;
	} else {
		moneyFormat = false;
	}

	autoSumByClass('autosum-pcsv', 'primeContractScheduledValuesTotal', moneyFormat);
}

function updateForcastedExpensesTotal(moneyFormat)
{
	if ((typeof moneyFormat == 'string') && (moneyFormat == 'currency')) {
		moneyFormat = true;
	} else {
		moneyFormat = false;
	}

	autoSumByClass('autosum-fe', 'forecastedExpensesTotal', moneyFormat);
}
//to autosum buyout forecast
function updateBuyoutForcastedTotal(moneyFormat)
{
	if ((typeof moneyFormat == 'string') && (moneyFormat == 'currency')) {
		moneyFormat = true;
	} else {
		moneyFormat = false;
	}

	autoSumByClass('autosum-be', 'buyoutExpensesTotal', moneyFormat);
}

function Gc_Budget__finalBudgetTotal()
{
	var total = 0.00;

	try {

		var arrValues = $(".autosum-cosv");

		arrValues.each(function(index, element) {

			if ($(this).is('input')) {
				var elementType = 'htmlInput';
			} else {
				var elementType = 'htmlTd';
			}

			if (elementType == 'htmlInput') {
				var tmpValue = $(this).val();
			} else {
				var tmpValue = $(this).html();
			}

			var value = parseInputToCurrency(tmpValue);

			if (value !== '0.00') {

				total = parseInputToCurrency(total);

				// tabulate total value
				
				total = parseFloat(total) + parseFloat(value);

			}

		});

		var formattedTotal = formatDollar(total);
		$("#changeOrdersScheduledValuesTotal").val(formattedTotal);

		var primeContractScheduledValuesTotal = $("#primeContractScheduledValuesTotal").val();
		primeContractScheduledValuesTotal = parseInputToCurrency(primeContractScheduledValuesTotal);
		var grandTotal = parseFloat(primeContractScheduledValuesTotal) + parseFloat(total);
		var formattedGrandTotal = formatDollar(grandTotal);
		$("#scheduledValuesGrandTotal").val(formattedGrandTotal);

	} catch(e) {
		alert(e);
	}

}

function loadImportCostCodesIntoBudgetDialog(options)
{
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var importFromProjectId = -1;
		if ($("#ddlImportProjectList").length) {
			importFromProjectId = $("#ddlImportProjectList").val();
		}
		var activeProjectId = $("#currentlySelectedProjectId").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadImportCostCodesIntoBudgetDialog';
		var ajaxQueryString =
		'importFromProjectId=' + encodeURIComponent(importFromProjectId) + '&pID='+btoa(encodeURIComponent(activeProjectId));
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
			success: loadImportCostCodesIntoBudgetDialogSuccess,
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

function loadImportCostCodesIntoBudgetDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divModalWindow").html(data);
		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").dialog({
			height: $(window).height() * 0.95,
			width: 600,
			modal: true,
			title: 'Import Cost Codes Into Current Budget',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).html('');
				$(this).addClass('hidden');
				$(this).dialog('destroy');
			},
			buttons: {
				'Import Selected Items': function() {
					importCostCodesIntoBudget();
					$("#divModalWindow").dialog('close');
				},
				'Cancel': function() {
					$("#divModalWindow").dialog('close');
				}
			}
		});

		$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function importWindowLoaded()
{
	$("#divModalWindow").removeClass('hidden');
	$("#divModalWindow").dialog('open');
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
}

function checkAllImportItems()
{
	var checked = $("#chkImportDefault").is(':checked');
	$(".input-import-checkbox").prop('checked', checked);
}

function importCostCodesIntoBudget(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var arrCostCodeIds = [];
		$(".input-import-checkbox:checkbox:checked").each(function(i) {
			var cost_code_id = $(this).val();
			arrCostCodeIds.push(cost_code_id);
		});
		var csvCostCodeIds = arrCostCodeIds.join(',');
		var selectedCostCodeType = $("#ddlImportProjectList").val();
		selectedCostCodeType = selectedCostCodeType.split(':')[0];
		var ajaxHandler = '';
		if(selectedCostCodeType == 't_cct_id'){
			ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=importCostCodesTemplatesIntoBudget';
		}else{
			ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=importCostCodesIntoBudget';
		}
		var activeProjectId = $("#currentlySelectedProjectId").val();

		var ajaxQueryString =
		'csvCostCodeIds=' + encodeURIComponent(csvCostCodeIds)+'&pID='+btoa(encodeURIComponent(activeProjectId));
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
			success: importCostCodesIntoBudgetSuccess,
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

function importCostCodesIntoBudgetSuccess(data, textStatus, jqXHR)
{
	messageText = 'Items successfully imported';
	messageAlert(messageText, 'successMessage');
	window.location.reload(false);
}

function loadManageGcCostCodesDialog(options, createItemToggle)
{
	try {
		var createStyleBlock = 'display: none';
		if (createItemToggle == true) {
			createStyleBlock = 'display: block'	;
		}
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		var activeProjectId = $("#currentlySelectedProjectId").val();
		var cost_code_type_id = -1;
		if ($("#ddlCostCodeTypeId").length) {
			cost_code_type_id = $("#ddlCostCodeTypeId").val();
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadManageGcCostCodesDialog';
		var ajaxQueryString =
		'cost_code_type_id=' + encodeURIComponent(cost_code_type_id)+
		'&create_item_style=' + encodeURIComponent(createStyleBlock)+
		'&pID='+btoa(encodeURIComponent(activeProjectId));
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
			success: loadManageGcCostCodesDialogSuccess,
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

function loadManageGcCostCodesDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.90;
		var dialogHeight = windowHeight * 0.99;

		if (windowWidth <= 1024) {
			dialogWidth = 1000;
		}

		var companyName = $("#companyName").val();
		$("#divModalWindow").html(data);
		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").dialog({
			width: dialogWidth,
			height: dialogHeight,
			modal: true,
			title: companyName + ' - Master Cost Codes List',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$(this).dialog('destroy');
				$(this).html('');
				$("body").removeClass('noscroll');
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

function loadGcBudgetLineItems(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadGcBudgetLineItems';

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxHandler);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			success: loadGcBudgetLineItemsSuccess,
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

function loadGcBudgetLineItemsSuccess(data, textStatus, jqXHR)
{
	try {

		$("#gcBudgetLineItemsFormContainer").html(data);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadCostCodeListForImport(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var cost_code_type_id = -1;
		if ($("#ddlCostCodeTypeId").length) {
			cost_code_type_id = $("#ddlCostCodeTypeId").val();
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadManageGcCostCodesDialog';
		var ajaxQueryString =
		'cost_code_type_id=' + encodeURIComponent(cost_code_type_id);
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
			success: loadCostCodeListForImportSuccess,
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

function loadCostCodeListForImportSuccess(data, textStatus, jqXHR)
{
	try {

		$("#tblImportCostCodes").html(data);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadManageGcCostCodeAliasesDialog(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var cost_code_type_id = -1;
		if ($("#ddlCostCodeTypeId").length) {
			cost_code_type_id = $("#ddlCostCodeTypeId").val();
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadManageGcCostCodeAliasesDialog';
		var ajaxQueryString =
		'cost_code_type_id=' + encodeURIComponent(cost_code_type_id);
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
			success: loadManageGcCostCodeAliasesDialogSuccess,
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

function loadManageGcCostCodeAliasesDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var companyName = $("#companyName").val();

		$("#divModalWindow").html(data);
		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").dialog({
			autoOpen: false,
			height: 600,
			width: 950,
			modal: true,
			title: companyName + ' - Master Cost Code Aliases',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$(this).dialog('destroy');
				$(this).html('');
				$("body").removeClass('noscroll');
			},
			buttons: {
				'Close': function() {
					$( this ).dialog('close');
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

function showCostCodeDivisionAliases(user_company_id, project_id)
{
	try {

		var cost_code_type_id = -1;
		if ($("#ddlCostCodeTypeId").length) {
			cost_code_type_id = $("#ddlCostCodeTypeId").val();
		}
		
		var contact_company_id = $("#ddlContactCompanyId").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadCostCodeDivisionAliases';
		var ajaxQueryString =
		'user_company_id=' + encodeURIComponent(user_company_id) +
		'project_id=' + encodeURIComponent(project_id) +
		'cost_code_type_id=' + encodeURIComponent(cost_code_type_id) +
		'contact_company_id=' + encodeURIComponent(contact_company_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divModalWindow2").load(ajaxUrl, importWindowLoaded);
		$("#divModalWindow2").dialog({
			autoOpen: false,
			height: 600,
			width: 800,
			modal: true,
			title: 'Select Division Alias',
			close: function() {
				$(this).html('');
				$(this).dialog('destroy');
			},
			buttons: {
				'Select Alias': function() {
					updateCostCodeDivisionAliasId();	
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

function loadCostCodes(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var cost_code_type_id = -1;
		if ($("#ddlCostCodeTypeId").length) {
			cost_code_type_id = $("#ddlCostCodeTypeId").val();
		}
		var ajaxHandler = '/modules-gc-budget-ajax.php?method=loadManageGcCostCodeAliasesDialog';
		var ajaxQueryString =
		'cost_code_type_id=' + encodeURIComponent(cost_code_type_id);
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
			success: loadCostCodesSuccess,
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

function loadCostCodesSuccess(data, textStatus, jqXHR)
{
	try {

		$("#costCodesContainer").html(data);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Gc_Budget__ScheduleValueUpdate(element, options, calVal){
	var currentScheduleVal = $(element).val();
	var previousScheduleVal = $("#prev_schedule_val").val();
	var sheduleVal = Number(previousScheduleVal).toFixed(2);

	currentScheduleVal = currentScheduleVal.replace(/\$/g, ''); // To Remove the $ symbol

	
	if(!currentScheduleVal || currentScheduleVal =='0'){
		messageAlert('Please Check the Schedule Value', 'errorMessage');
	}else if(currentScheduleVal < previousScheduleVal){
		var formatter = new Intl.NumberFormat('en-US', {
					style: 'currency',
					currency: 'USD',
					minimumFractionDigits: 2,
				});
		sheduleVal = sheduleVal.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
		sheduleVal = formatter.format(sheduleVal);
		$("#dialog-confirm").html("Are you sure you want to update?");
	    $("#dialog-confirm").dialog({
	      resizable: false,
	      modal: true,
	      title: "Confirmation",
	      width: "500",
	      height: "160",
	      buttons: {
	        "No": function () {
	          $(this).dialog('close');
	        },
	        "Yes": function () {
	          sheduleVal = element.value;
	          $(this).dialog('close');
	          Gc_Budget__updateGcBudgetLineItem(element, options, calVal);
	        }
	      },
	      close : function(){
	        $('#'+element.id).val(sheduleVal);
	      }
	    });
	}else{
		Gc_Budget__updateGcBudgetLineItem(element, options, calVal);
	}
	
}

function Gc_Budget__updateGcBudgetLineItem(element, options, calVal)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Gc_Budget__updateGcBudgetLineItemSuccess;

		// @todo Confirm that no other patters (record_container-- with sort_order or ddl--) are needed here
		var arrParts = $(element).attr('id').split('--');
		var attributeGroupName = arrParts[0];
		var attributeSubgroupName = arrParts[1];
		var attributeName = arrParts[2];
		var uniqueId = arrParts[3];

		var confirmationDialogPromiseFlag = false;
		if (attributeSubgroupName == 'gc_budget_line_items') {
			// Set updated value of prime cost value
			if(attributeName == 'prime_contract_scheduled_value'){
				var pcsv_val = $(element).val();
				var formatter = new Intl.NumberFormat('en-US', {
					style: 'currency',
					currency: 'USD',
					minimumFractionDigits: 2,
				});
				pcsv = pcsv_val.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
				var htmlPCSV = $('#prime-text-'+uniqueId).html();
				if(htmlPCSV == null || htmlPCSV == '&nbsp;'){
					pcsv = formatter.format(pcsv);
				}
				$('#prime-text-'+uniqueId).empty().html(pcsv);
				pcsv_val = pcsv_val.replace(/\$/g, '');
				$("#prev_schedule_val").val(pcsv_val);
			}
			// Filter Input - attributes of type: decimal(10,2)
			if ((attributeName == 'prime_contract_scheduled_value') || (attributeName == 'forecasted_expenses') || (attributeName == 'subcontract_actual_value') || (attributeName == 'buyout_forecasted_expenses')) {

				objElementValue = filterAndFormatMonetaryValueInPlace(element);

			}else{
				var subcontractCount = $('#subcontractCount-'+uniqueId).val();
				var newValueText = $(element).val();
				var newValueText = $(element).val();

				var checkDateMinimze = new Date();
				var dateObj = new Date();
				var month = dateObj.getUTCMonth() + 1; //months from 1-12
				var day = dateObj.getUTCDate();
				var year = dateObj.getUTCFullYear();

				var currentDate = month + "/" + day + "/" + year;
				currentDate = new Date(currentDate);
				newValueText = new Date(newValueText);
				if(newValueText <= currentDate && subcontractCount < 1)
				{
					$(element).css('color','red');
				}else{
					$(element).css('color','');
				}
			}
		}

	// @todo Finish above promises so this is called in the correct order
	updateGcBudgetLineItem(element, options, calVal);

} catch(error) {

	if (window.showJSExceptions) {
		var errorMessage = error.message;
		alert('Exception Thrown: ' + errorMessage);
		return;
	}

}
}

function Gc_Budget__updateGcBudgetLineItemSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var attributeName = json.attributeName;

			if (attributeName == 'prime_contract_scheduled_value') {
				updatePrimeContractScheduledValuesTotal();
				updateScheduledValueInDraws(data);
			} else if (attributeName == 'forecasted_expenses') {
				updateForcastedExpensesTotal();
			} else if(attributeName == 'buyout_forecasted_expenses'){
				updateBuyoutForcastedTotal();
			}

			Gc_Budget__updateVariance();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Gc_Budget__deleteGcBudgetLineItem(gc_budget_line_item_id, options, gcBudgetLineItemDesc)
{
	var sub_check = $("#gc_budget_line_items--vendorList--"+gc_budget_line_item_id).html();
	if(sub_check !="")
	{

		var htmltext = gcBudgetLineItemDesc +" contains a subcontractor so it cannot be deleted from this budget ";
		$("#dialog-confirm").html(htmltext);
		$("#dialog-confirm").dialog({
		resizable: false,
		modal: true,
		title: "Warning",
		buttons: {
			"OK": function () {
				$(this).dialog('close');
			}
		}
	});
		
	}
	else
	{
	try {

		var options = options || {};

		//trapJavaScriptEvent(event);

		options.promiseChain = true;
		options.responseDataType = 'json';
		//options.confirmation = true;
		options.successCallback = Gc_Budget__deleteGcBudgetLineItemSuccess;

		options.confirmationDialogMessage = 'Are you sure you want to delete '+gcBudgetLineItemDesc+' from this budget ? It would delete the bidspread, bidItems and  subcontracts Associated with this costcode ';
		options.confirmationDialogTitle = 'Confirm Delete';
		options.confirmButtonText = 'Delete';
		options.cancelButtonText = 'Cancel';
		options.confirmationDialogWidth = 400;
		options.confirmationDialogHeight = 250;

		var confirmationDialogPromise = confirmationDialog(options);

		confirmationDialogPromise.done(function() {
			// They pressed Delete
			var recordContainerElementId = 'record_container--manage-gc_budget_line_item-record--gc_budget_line_items--sort_order--' + gc_budget_line_item_id;
			var attributeGroupName = 'manage-gc_budget_line_item-record';
			var uniqueId = gc_budget_line_item_id;

			deleteGcBudgetLineItem(recordContainerElementId, attributeGroupName, uniqueId, options);
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
}

function updateIsDcrFlag(id){
	if (id) {

		var updateData='';
		if($("#attach_"+id).prop('checked') == true){
			updateData='Y';
			$("#attach_copy_"+id).prop('checked', true);
			$("#attach_"+id).prop('checked', true);			
		}else{
			updateData='N';
			$("#attach_copy_"+id).prop('checked', false);
			$("#attach_"+id).prop('checked', false);			
		}

    	var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=updateIsDcrFlag';
		var ajaxQueryString =
			'attributeId=' + encodeURIComponent(id) +
			'&updateData=' + encodeURIComponent(updateData);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var current_project_id = $("#current_project_id").val();

		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(){
				countAllIsDcrFlag(current_project_id);
				messageAlert('Updated Successfully', 'successMessage');
			},
			error: errorHandler
		});
	}	
}

function updateAllIsDcrFlag(project_id){

	var updateData='';
	if($("#attach_all_copy_lock").prop('checked') == true){
		updateData='Y';	
		$("#attach_all_copy_text").prop('checked', true);
		$("#attach_all_copy_lock").prop('checked', true);
		$(".checkAllDcrText").prop('checked', true);
		$(".checkAllDcrEdit").prop('checked', true);
	}else{
		updateData='N';
		$("#attach_all_copy_text").prop('checked', false);
		$("#attach_all_copy_lock").prop('checked', false);
		$(".checkAllDcrText").prop('checked', false);
		$(".checkAllDcrEdit").prop('checked', false);
	}

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=updateAllIsDcrFlag';
	var ajaxQueryString =
		'attributeId=' + encodeURIComponent(project_id) +
		'&updateData=' + encodeURIComponent(updateData);
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

	$.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function(){
			messageAlert('Updated Successfully', 'successMessage');
		},
		error: errorHandler
	});
}

function countAllIsDcrFlag(project_id){
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=countAllIsDcrFlag';
	var ajaxQueryString =
		'attributeId=' + encodeURIComponent(project_id);
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

	$.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function(data){
			if(data == 0){
				$("#attach_all_copy_text").prop('checked', true);
				$("#attach_all_copy_lock").prop('checked', true);
			}else{
				$("#attach_all_copy_text").prop('checked', false);
				$("#attach_all_copy_lock").prop('checked', false);
			}
		},
		error: errorHandler
	});
}

function allowToUserEditPrimeDcr(allow){
	if(allow){
		$('#entypo-edit-icon-dcr').css('display','none');
		$('#entypo-lock-icon-dcr').css('display','block');
		$('.dcr-text').css('display','none');
		$('.dcr-edit').css('display','block');
	}else{
		$('#entypo-edit-icon-dcr').css('display','block');
		$('#entypo-lock-icon-dcr').css('display','none');
		$('.dcr-text').css('display','block');
		$('.dcr-edit').css('display','none');
	}
}

function Gc_Budget__deleteGcBudgetLineItemSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			Gc_Budget__updateBudgetTotals(true);
			deleteGcBudgetFromDraws(data);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function openSubcontractsDialog(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontractor_bid_id)
{
	try {

		// Pattern: HTML attribute_name_element_id
		var cost_code_division_number_element_id = 'gc_budget_line_items--cost_code_divisions--division_number--' + cost_code_division_id;
		if ($("#" + cost_code_division_number_element_id).length) {
			var division_number = $("#" + cost_code_division_number_element_id).html();
		} else {
			var division_number = '';
		}

		var cost_code_element_id = 'gc_budget_line_items--cost_codes--cost_code--' + cost_code_id;
		if ($("#" + cost_code_element_id).length) {
			var cost_code = $("#" + cost_code_element_id).html();
		} else {
			var cost_code = '';
		}

		var cost_code_description_element_id = 'gc_budget_line_items--cost_codes--cost_code_description--' + cost_code_id;
		if ($("#" + cost_code_description_element_id).length) {
			var cost_code_description = $("#" + cost_code_description_element_id).html();
		} else {
			var cost_code_description = '';
		}

		// set activeGcBudgetLineItem for reference
		$('#activeGcBudgetLineItem').val(gc_budget_line_item_id + '-' + cost_code_division_id + '-' + cost_code_id);

		var activeGcBudgetLineWidget = $('#activeGcBudgetLineWidget').val();
		var activeDataParam = '';
		if(activeGcBudgetLineWidget != undefined){
			activeDataParam = '&active_widget_number=' + encodeURIComponent(activeGcBudgetLineWidget);
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadSubcontractDetails';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
		'&cost_code_id=' + encodeURIComponent(cost_code_id) +
		'&subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id) +
		activeDataParam;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		if (window.debugMode == true) {
			var modalWindowTitle = '[PBLI ID: ' + gc_budget_line_item_id + '] ' + division_number + '-' + cost_code + ' (' + cost_code_description + ') ' + ' - Subcontract Details';
		} else {
			var modalWindowTitle = division_number + '-' + cost_code + ' (' + cost_code_description + ') ' + ' - Subcontract Details';
		}

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.99;
		var dialogHeight = windowHeight * 0.98;
		$('#divModalWindow').load(ajaxUrl);
		openSubcontractsDialogLoaded();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function openSubcontractsDialogLoaded()
{
	try {
		
		// Sortable
		$(".tbodySortable").sortable({
			axis: 'y',
			distance: 10,
			helper: sortHelper,
			update: function(event, ui) {
				var trElement = $(ui.item)[0];
				var endIndex = $(ui.item).index();
				endIndex = endIndex.toString();
				var options = { endIndex: endIndex };
				updateSubcontractDocument(trElement, options);
			}
		});
		
		// File Uploaders
		setTimeout(function(){
		createUploaders();
		$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd', numberOfMonths: 1 });
		initializePopovers();
		},3000);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//To get the signature
function showsetSignature(gc_budget_line_item_id,cost_code_division_id,cost_code_id,subcontract_id,subcontract_execution_date,subcontract_mailed_date,GCsign,Vendorsign,cancomplie)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=setSignaturedata';
	var ajaxQueryString ="";
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	$.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function(data){
			var json = data;
			var htmlContent = json.htmlContent;


			$("#divsignature").empty().append(htmlContent);	
			$("#divsignature").removeClass('hidden');

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			var dialogWidth = windowWidth * 0.59;
			var dialogHeight = windowHeight * 0.88;


			$("#divsignature").dialog({
				height: dialogHeight,
				width: dialogWidth,
				top: '100px',
				title: 'place signature',
				modal: true,
				open: function() {
					$("body").addClass('noscroll');
					//start
					$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90},3000);
				},
				close: function() {
					$("body").removeClass('noscroll');
					$(this).dialog('destroy');
					$("#divsignature").html('');
					$("#divsignature").addClass('hidden');
				},
				buttons: {
					'Compile Without E-sign': function() {
						generateFinalSubcontract(gc_budget_line_item_id,cost_code_division_id,cost_code_id,subcontract_id,subcontract_execution_date,subcontract_mailed_date,GCsign,Vendorsign,cancomplie,'N');
						// $(".Compile_"+subcontract_id).click();
						$(this).dialog('close');
					},
					'Compile Final subcontract': function() {
						$(".Compile_"+subcontract_id).click();
						$(this).dialog('close');
					},
					'close': function() {
						$(this).dialog('close');
					}
				}
			});
			createUploaders();
		},
		error: errorHandler
	});
}
function showsetSignaturewithdialog(gc_budget_line_item_id,cost_code_division_id,cost_code_id,subcontract_id,subcontract_execution_date,subcontract_mailed_date,GCsign,Vendorsign,cancomplie)
{
	var htmltext = "E-Sign is applied successfully. TO update your e-sign, click 'Modify'.  ";
	$("#dialog-confirm").html(htmltext);
	$("#dialog-confirm").dialog({
		resizable: false,
		modal: true,
		title: "Confirmation",
		buttons: {
			"Modify": function () {
				$(this).dialog('close');
			showsetSignature(gc_budget_line_item_id,cost_code_division_id,cost_code_id,subcontract_id,subcontract_execution_date,subcontract_mailed_date,GCsign,Vendorsign,cancomplie)	

			}
		}
	});
	if($('.ui-dialog').length)
	{
		$('.ui-dialog').css("top", '100px');
	}


}
function getDialogButton( dialog_selector, button_name )
{
  var buttons = $( dialog_selector + ' .ui-dialog-buttonpane button' );
  for ( var i = 0; i < buttons.length; ++i )
  {
     var jButton = $( buttons[i] );
     if ( jButton.text() == button_name )
     {
         return jButton;
     }
  }

  return null;
}

function verifyFinalSubcontract(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie)
{

	if(GCsign == 'Y' || Vendorsign == 'Y' )
	{
	    var	htmltext = "Already you have a signature! click Proceed to E-sign or modify to change the signature ";
		$("#dialog-confirm").html(htmltext);
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			height: '180',
			width: '515',
			title: "Confirmation",
			dialogClass : 'dialog1',
			buttons: {

				"  Modify  ": function () {
					$(this).dialog('close');
					$("body").removeClass('noscroll');
					showsetSignature(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie);

				},
				"Proceed with E-sign": function () {
					$(this).dialog('close');
					$("body").removeClass('noscroll');
					generateFinalSubcontract(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie);
				},
				"Proceed without E-sign": function () {
					$(this).dialog('close');
					$("body").removeClass('noscroll');
					generateFinalSubcontract(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie,'N');
				}

			}
		});
			if(cancomplie =='N')
			{
			var button = getDialogButton( '.dialog1', 'Modify' );
			if ( button )
			{
			button.attr('style', 'display:none;' ).addClass( 'ui-state-disabled' );
			}
		}
		}else{
			showsetSignature(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie);

		}
	
}

function generateFinalSubcontract(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie,esign)
{
	if(esign == undefined || esign =="")
	{
		esign ='Y';
	}
	try {

		window.savePending = true;
		var vendor_contact=$('#manage-subcontract-record--subcontracts--vendor_contact_company_id--'+subcontract_id).val();
		var vendor_contact=$('#manage-subcontract-record--subcontracts--subcontract_vendor_contact_id--'+subcontract_id).val();
		var updateGC =$('#updateGCcompany').val();
		if(updateGC=='1')
		{
			document.getElementById('manage-subcontract-record--subcontracts--subcontract_gc_contact_company_office_id--'+subcontract_id).onchange();
			$('#updateGCcompany').val('0');
		}

		var valPair =[];
		var j='0';
		if(vendor_contact =='')
		{
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');
			$('#manage-subcontract-record--subcontracts--subcontract_vendor_contact_id--'+subcontract_id).addClass('redBorderThick');
			valPair[j]='0';
			j++;

		}else{
			$('#manage-subcontract-record--subcontracts--subcontract_vendor_contact_id--'+subcontract_id).removeClass('redBorderThick');
			valPair[j]='1';
			j++;
		}

		//GC signatory and vendor signatory make mandatory
		var gc_signatory=$('#manage-subcontract-record--subcontracts--gc_signatory--'+subcontract_id).val();
		if(gc_signatory =='')
		{
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');
			$('#manage-subcontract-record--subcontracts--gc_signatory--'+subcontract_id).addClass('redBorderThick');
			valPair[j]='0';
			j++;

		}else{
			$('#manage-subcontract-record--subcontracts--gc_signatory--'+subcontract_id).removeClass('redBorderThick');
			valPair[j]='1';
			j++;
		}
		var vendor_signatory=$('#manage-subcontract-record--subcontracts--vendor_signatory--'+subcontract_id).val();
		if(vendor_signatory =='')
		{
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');
			$('#manage-subcontract-record--subcontracts--vendor_signatory--'+subcontract_id).addClass('redBorderThick');
			valPair[j]='0';
			j++;

		}else{
			$('#manage-subcontract-record--subcontracts--vendor_signatory--'+subcontract_id).removeClass('redBorderThick');
			valPair[j]='1';
			j++;
		}

		if(valPair.indexOf('0') !='-1'){
			return false;
		}

		var signatory_check = $('#signatory_'+subcontract_id).is(':checked');

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=generateFinalSubcontract';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
		'&cost_code_id=' + encodeURIComponent(cost_code_id) +
		'&subcontract_id=' + encodeURIComponent(subcontract_id) +
		'&execution_date=' + encodeURIComponent(execution_date) +
		'&signatory_check=' + encodeURIComponent(signatory_check) +
		'&esign=' + encodeURIComponent(esign) +
		'&mailed_date=' + encodeURIComponent(mailed_date) ;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		showSpinner();

		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: generateFinalSubcontractSuccess,
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
				hideSpinner();
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

function generateFinalSubcontractSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var activeGcBudgetLineItem = $('#activeGcBudgetLineItem').val();
		var ary = activeGcBudgetLineItem.split("-");
		var gc_budget_line_item_id = ary[0];
		var cost_code_division_id = ary[1];
		var cost_code_id = ary[2];
		// Debug
		openSubcontractsDialog(gc_budget_line_item_id, cost_code_division_id, cost_code_id);
		$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd', numberOfMonths: 1 });
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

var numDocumentsGenerating = 0;
function generateDynamicSubcontractDocument(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, subcontract_item_template_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		window.savePending = true;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=generateDynamicSubcontractDocument';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
		'&cost_code_id=' + encodeURIComponent(cost_code_id) +
		'&subcontract_id=' + encodeURIComponent(subcontract_id) +
		'&subcontract_item_template_id=' + encodeURIComponent(subcontract_item_template_id) +
		'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		numDocumentsGenerating++;
		if (numDocumentsGenerating == 1) {
			showSpinner();
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: generateDynamicSubcontractDocumentSuccess,
			error: errorHandler,
			complete: function() {
				numDocumentsGenerating--;
				if (numDocumentsGenerating == 0) {
					hideSpinner();
				}
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

function generateDynamicSubcontractDocumentSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var uniqueId = json.uniqueId;
			var htmlContent = json.htmlContent;
			var errorNumber = json.errorNumber;

			var tr = $("#buttonGenerateDynamicSubcontractDocument--" + uniqueId).closest('tr');
			var td = tr.find('.tdLinkToUnsignedDocument');
			td.html(htmlContent);
			$(".bs-tooltip").tooltip();

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showHideCreateAdditionalSubcontractForm()
{
	$('#createAdditionalSubcontractForm').toggle();
}


/**
* attributeGroupName or htmlRecordName is the name of the attributes group
* uniqueId is a dummy id placeholder to allow auto-sniffing the attributes out of the HTML form code
* options is an object with a collection of optional directives
*/
function createSubcontractAndVendorAndSubcontractDocuments(attributeGroupName, uniqueId, options)
{

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var fileId = $("#tdLinkToSignedDocument_id").val();
		var fileType = $("#federal_tax_id").val();
		var fileReason = $("#subcontract_reason").val();

		window.savePending = true;

		var formattedAttributeGroupNameSpecificElementId = 'formattedAttributeGroupName--' + uniqueId;
		var formattedAttributeGroupNameGeneralElementId = 'formattedAttributeGroupName--' + attributeGroupName;
		if ($("#" + formattedAttributeGroupNameSpecificElementId).val()) {
			var formattedAttributeGroupName = $("#" + formattedAttributeGroupNameSpecificElementId).val();
		} else if ($("#" + formattedAttributeGroupNameGeneralElementId).length && $("#" + formattedAttributeGroupNameGeneralElementId).val() != '') {
			var formattedAttributeGroupName = $("#" + formattedAttributeGroupNameGeneralElementId).val();
		} else {
			var formattedAttributeGroupName = '';
		}
		var execution_date='';
		var subcontract_execution_date='';
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=createSubcontractAndVendorAndSubcontractDocuments';
		var ajaxQueryString =
		'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
		'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
		'&attributeSubgroupName=' + encodeURIComponent('subcontracts') +
		'&uniqueId=' + encodeURIComponent(uniqueId) +
		'&fileId=' + encodeURIComponent(fileId) +
		'&fileType=' + encodeURIComponent(fileType) +
		'&fileReason=' + encodeURIComponent(fileReason) +
		'&responseDataType=json';


		// Extra data for follup reload of pop-up
		if ($("#subcontract_execution_date").length) {
			var execution_date=$('#subcontract_execution_date').val();
			var edate=execution_date.split('/');
			var subcontract_execution_date=edate[2]+'-'+edate[0]+'-'+edate[1];
			ajaxQueryString = ajaxQueryString + '&subcontract_execution_date=' + encodeURIComponent(subcontract_execution_date);
		}
		if ($("#subcontract_mailed_date").length) {
			var mailed_date=$('#subcontract_mailed_date').val();
			var mdate=mailed_date.split('/');
			var subcontract_mailed_date=mdate[2]+'-'+mdate[0]+'-'+mdate[1];
			ajaxQueryString = ajaxQueryString + '&subcontract_mailed_date=' + encodeURIComponent(subcontract_mailed_date);
		}


		var cost_code_division_id_element_id = attributeGroupName + '--subcontracts--cost_code_division_id--' + uniqueId;
		if ($("#" + cost_code_division_id_element_id).length) {
			var cost_code_division_id = $("#" + cost_code_division_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&cost_code_division_id=' + encodeURIComponent(cost_code_division_id);
		}
		var cost_code_id_element_id = attributeGroupName + '--subcontracts--cost_code_id--' + uniqueId;
		if ($("#" + cost_code_id_element_id).length) {
			var cost_code_id = $("#" + cost_code_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&cost_code_id=' + encodeURIComponent(cost_code_id);
		}

		var gc_budget_line_item_id_element_id = attributeGroupName + '--subcontracts--gc_budget_line_item_id--' + uniqueId;
		if ($("#" + gc_budget_line_item_id_element_id).length) {
			var gc_budget_line_item_id = $("#" + gc_budget_line_item_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id);
		}

		var subcontract_sequence_number_element_id = attributeGroupName + '--subcontracts--subcontract_sequence_number--' + uniqueId;
		if ($("#" + subcontract_sequence_number_element_id).length) {
			var subcontract_sequence_number = $("#" + subcontract_sequence_number_element_id).val();
			ajaxQueryString = ajaxQueryString + '&subcontract_sequence_number=' + encodeURIComponent(subcontract_sequence_number);
		}

		var subcontract_template_id_element_id = attributeGroupName + '--subcontracts--subcontract_template_id--' + uniqueId;
		if ($("#" + subcontract_template_id_element_id).length) {
			var subcontract_template_id = $("#" + subcontract_template_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&subcontract_template_id=' + encodeURIComponent(subcontract_template_id);
		}

		var subcontractor_bid_id_element_id = attributeGroupName + '--subcontracts--subcontractor_bid_id--' + uniqueId;
		if ($("#" + subcontractor_bid_id_element_id).length) {
			var subcontractor_bid_id = $("#" + subcontractor_bid_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id);
		}

		var vendor_id_element_id = attributeGroupName + '--subcontracts--vendor_id--' + uniqueId;
		if ($("#" + vendor_id_element_id).length) {
			var vendor_id = $("#" + vendor_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&vendor_id=' + encodeURIComponent(vendor_id);
		}

		var vendor_contact_company_id_element_id = attributeGroupName + '--subcontracts--vendor_contact_company_id--' + uniqueId;
		if ($("#" + vendor_contact_company_id_element_id).length) {
			var vendor_contact_company_id = $("#" + vendor_contact_company_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&vendor_contact_company_id=' + encodeURIComponent(vendor_contact_company_id);
		}

		var unsigned_subcontract_file_manager_file_id_element_id = attributeGroupName + '--subcontracts--unsigned_subcontract_file_manager_file_id--' + uniqueId;
		if ($("#" + unsigned_subcontract_file_manager_file_id_element_id).length) {
			var unsigned_subcontract_file_manager_file_id = $("#" + unsigned_subcontract_file_manager_file_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&unsigned_subcontract_file_manager_file_id=' + encodeURIComponent(unsigned_subcontract_file_manager_file_id);
		}

		var signed_subcontract_file_manager_file_id_element_id = attributeGroupName + '--subcontracts--signed_subcontract_file_manager_file_id--' + uniqueId;
		if ($("#" + signed_subcontract_file_manager_file_id_element_id).length) {
			var signed_subcontract_file_manager_file_id = $("#" + signed_subcontract_file_manager_file_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&signed_subcontract_file_manager_file_id=' + encodeURIComponent(signed_subcontract_file_manager_file_id);
		}

		var subcontract_forecasted_value_element_id = attributeGroupName + '--subcontracts--subcontract_forecasted_value--' + uniqueId;
		if ($("#" + subcontract_forecasted_value_element_id).length) {
			var subcontract_forecasted_value = $("#" + subcontract_forecasted_value_element_id).val();
			ajaxQueryString = ajaxQueryString + '&subcontract_forecasted_value=' + encodeURIComponent(subcontract_forecasted_value);
		}
		var subcontract_actual_value_element_id = attributeGroupName + '--subcontracts--subcontract_actual_value--' + uniqueId;
		if ($("#" + subcontract_actual_value_element_id).length) {
			var subcontract_actual_value = $("#" + subcontract_actual_value_element_id).val();
			ajaxQueryString = ajaxQueryString + '&subcontract_actual_value=' + encodeURIComponent(subcontract_actual_value);
		}
		var subcontract_retention_percentage_element_id = attributeGroupName + '--subcontracts--subcontract_retention_percentage--' + uniqueId;
		if ($("#" + subcontract_retention_percentage_element_id).length) {
			var subcontract_retention_percentage = $("#" + subcontract_retention_percentage_element_id).val();
			ajaxQueryString = ajaxQueryString + '&subcontract_retention_percentage=' + encodeURIComponent(subcontract_retention_percentage);
		}
		var subcontract_issued_date_element_id = attributeGroupName + '--subcontracts--subcontract_issued_date--' + uniqueId;
		if ($("#" + subcontract_issued_date_element_id).length) {
			var subcontract_issued_date = $("#" + subcontract_issued_date_element_id).val();
			ajaxQueryString = ajaxQueryString + '&subcontract_issued_date=' + encodeURIComponent(subcontract_issued_date);
		}
		var subcontract_target_execution_date_element_id = attributeGroupName + '--subcontracts--subcontract_target_execution_date--' + uniqueId;
		if ($("#" + subcontract_target_execution_date_element_id).length) {
			var target_execution = $("#" + subcontract_target_execution_date_element_id).val();
			if (target_execution.indexOf('/') > -1)
			{
				var tdate=target_execution.split('/');
				var subcontract_target_execution_date=tdate[2]+'-'+tdate[0]+'-'+tdate[1];
			}else{
				var subcontract_target_execution_date=target_execution;
			}

			ajaxQueryString = ajaxQueryString + '&subcontract_target_execution_date=' + encodeURIComponent(subcontract_target_execution_date);
		}
		var subcontract_execution_date_element_id = attributeGroupName + '--subcontracts--subcontract_execution_date--' + uniqueId;
		if ($("#" + subcontract_execution_date_element_id).length) {
			var subcontract_execution_date = $("#" + subcontract_execution_date_element_id).val();
			ajaxQueryString = ajaxQueryString + '&subcontract_execution_date=' + encodeURIComponent(subcontract_execution_date);
		}
		var active_flag_element_id = attributeGroupName + '--subcontracts--active_flag--' + uniqueId;
		if ($("#" + active_flag_element_id).length) {
			var active_flag = $("#" + active_flag_element_id).val();
			ajaxQueryString = ajaxQueryString + '&active_flag=' + encodeURIComponent(active_flag);
		}

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		// QB Intergeration Start
		if(vendor_contact_company_id){
			var project_customer = $('#project_customer').val();
			var gl_account_id = $('#gl_account_id--'+uniqueId).val();
			$.get('/app/controllers/accounting_cntrl.php',
				{'action': 'checkAccountingPortal'}, function(data){
				if($.trim(data) === 'Y' ){
					$.get(
						'/app/controllers/subcontract_invoice_cntrl.php',
						{'action':'checkVendorExist','vendor_contact_company_id':vendor_contact_company_id},
						function(JsonData){ // Check that Vendor Exist in QB
						if($.trim(JsonData.message) == 'VendorNotExists' && JsonData.vendor_name){
								
			            	$.get('/app/controllers/subcontract_invoice_cntrl.php',
			            		{'action':'create_vendor','vendor_name':JsonData.vendor_name},function(data){
		            			if($.trim(data) == 'vendorcreated'){
		            				messageAlert('Vendor Created Successfully.', 'successMessage');
			            				
		            				$.get('/app/controllers/subcontract_invoice_cntrl.php',
		            						{'action':'createPurchaseOrder','subcontract_template_id':subcontract_template_id, 'vendor_contact_company_id':vendor_contact_company_id, 'cost_code_division_id': cost_code_division_id, 'cost_code_id': cost_code_id, 'target_execution':target_execution, 'subcontract_actual_value':subcontract_actual_value,'project_customer':project_customer,'gl_account_id':gl_account_id}, function(JsonData){
		            					if($.trim(JsonData.qb_error_id) != ''){
		                  					messageAlert('Error Code :'+JsonData.qb_error_id+' .<br/> Please share error code with developer for resolution.', 'errorMessage');
		                  				}else if($.trim(JsonData.return_val) =='Y'){
											messageAlert('Purchase Order created in QB successfully.', 'successMessage');
		                  				}else{
											var error_data = '';
											if($.trim(JsonData.return_val) != 'N'){
												error_data = JsonData.return_val;
											}
											messageAlert('Purchase Order QB creation error. <br/>'+error_data, 'errorMessage');
										}

	    							});
								}else{
		            				messageAlert(data, 'errorMessage');
		            			}
			            	});
						}else{
							$.get('/app/controllers/subcontract_invoice_cntrl.php',
	    						{'action':'createPurchaseOrder','subcontract_template_id':subcontract_template_id,
	    						'vendor_contact_company_id':vendor_contact_company_id,
	    						'cost_code_division_id': cost_code_division_id,
	    						'cost_code_id': cost_code_id,'target_execution':target_execution,
	    						'subcontract_actual_value':subcontract_actual_value,'project_customer':project_customer,'gl_account_id':gl_account_id}, function(JsonData){
	    							if($.trim(JsonData.qb_error_id) != ''){
	    									messageAlert('Error Code :'+JsonData.qb_error_id+'<br/> Please share error code with developer for resolution.', 'errorMessage');
		                  				}else if($.trim(JsonData.return_val) =='Y'){
											messageAlert('QB Purchase Order created successfully.', 'successMessage');
		                  				}else{
											var error_data = '';
											if($.trim(JsonData.return_val) != 'N'){
												error_data = JsonData.return_val;
											}
											messageAlert('QB Purchase Order creation error.'+error_data, 'errorMessage');
										}

	    					});
						}
					});
				}
			});
		}
		var returnedJqXHR = $.ajax({
										url: ajaxHandler,
										data: ajaxQueryString,
										success: createSubcontractAndVendorAndSubcontractDocumentsSuccess,
										error: errorHandler
									});
		// QB Integeration End

		if (promiseChain) {
			return returnedJqXHR;
		}
	} catch(error) {
		if (window.debugMode) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function createSubcontractAndVendorAndSubcontractDocumentsSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var json = data;
		var errorNumber = json.errorNumber;
		var errorMessage = json.errorMessage;

		if (errorNumber == 0) {

			var formattedAttributeGroupName = json.formattedAttributeGroupName;
			var messageText = formattedAttributeGroupName + ' successfully created.';
			messageAlert(messageText, 'successMessage');

			var gc_budget_line_item_id = json.gc_budget_line_item_id;
			var cost_code_division_id = json.cost_code_division_id;
			var cost_code_id = json.cost_code_id;

		
			openSubcontractsDialog(gc_budget_line_item_id, cost_code_division_id, cost_code_id);
		}else if(errorMessage){
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

function loadSubcontractItemTemplatesBySubcontractTemplateId(ddl_subcontract_template_id, recordListContainerElementId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var subcontract_template_id = $("#" + ddl_subcontract_template_id).val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadSubcontractItemTemplatesBySubcontractTemplateId';
		var ajaxQueryString =
		'subcontract_template_id=' + encodeURIComponent(subcontract_template_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#" + recordListContainerElementId).load(ajaxUrl);

} catch(error) {

	if (window.showJSExceptions) {
		var errorMessage = error.message;
		alert('Exception Thrown: ' + errorMessage);
		return;
	}

}
}

function formatSubcontractAcualValueToCurrency(elementId)
{
	var tmpValue = $("#" + elementId).val();
	tmpValue = formatDollar(tmpValue);
	$("#" + elementId).val(tmpValue);

	var tmpValueAsFloat = parseInputToFloat(tmpValue);
	if (tmpValueAsFloat < 0) {
		$("#" + elementId).addClass('red');
	}
}

function Gc_Budget__Cost_Codes_Admin_Modal__createCostCode(element, javaScriptEvent, attributeGroupName, uniqueId)
{
	try {

		// Trap the event
		trapJavaScriptEvent(javaScriptEvent);

		// If the options object was not passed as an argument, create it here.
		var options = options || {};

		options.promiseChain = true;
		options.responseDataType = 'json';
		options.includeHtmlContent = 'Y';
		options.htmlRecordType = 'tr';
		options.moduleName = 'Gc_Budget';
		options.scenarioName = 'Gc_Budget__Cost_Codes_Admin_Modal__createCostCode';
		options.successCallback = Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeSuccess;

		createCostCode(attributeGroupName, uniqueId, options);
		loadManageGcCostCodesDialog(null, true);
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			resetFormElements('record_creation_form_container--cost_codes');

			var htmlRecordTr = json.htmlRecordTr;

			var tblImportCostCodes = $("#tblImportCostCodes");
			tblImportCostCodes.append(htmlRecordTr);

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

function updateownerdata()
{
	var user_company_id=$('#ddlCompanylist').val();
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=UpdateOwnerCostCode';
		var ajaxQueryString =
		'user_company_id=' + encodeURIComponent(user_company_id) ;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(result){

   			  $(".owner_ccode").val('');
			ownerarray = result.split('~~');
			for (var i = 0; i < ownerarray.length; i++) {
				var tempCompany = ownerarray[i];
				ownerdata = tempCompany.split('~');	
				$('#manage-cost_code-record--cost_code_alias--owner_cost_code--'+ownerdata[0]).val(ownerdata[1]);

			}

			},
			error: errorHandler
		});
}

function Gc_Budget__updateOwnerCostCode(cost_id,division_id,value)
{
	var user_company_id=$('#ddlCompanylist').val();
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=createOwnerCostCode';
		var ajaxQueryString =
		'user_company_id=' + encodeURIComponent(user_company_id) +
		'&cost_id=' + encodeURIComponent(cost_id) +
		'&division_id=' + encodeURIComponent(division_id) +
		'&newValue=' + encodeURIComponent(value);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				if(data =='1')
				{
					messageAlert('Owner cost code Successfully Updated','successMessage');
				}

			},
			error: errorHandler
		});
}

function Gc_Budget__Cost_Codes_Admin_Modal__updateCostCode(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.successCallback = Gc_Budget__Cost_Codes_Admin_Modal__updateCostCodeSuccess;

		updateCostCode(element, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}

}

function Gc_Budget__Cost_Codes_Admin_Modal__updateCostCodeSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		// Debug
		
		if (errorNumber == 0) {

			updateIndenticalOriginDataOnPage(data, textStatus, jqXHR, 'both');


		} else {

			resetToPreviousValue = json.resetToPreviousValue;
			if (resetToPreviousValue == 1) {
				var previousValue = $("#" + previousValueElementId).val();
				$("#" + elementId).val(previousValue);
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

function Gc_Budget__Cost_Codes_Admin_Modal__deleteCostCode(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};

		deleteCostCode(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Gc_Budget__Cost_Codes_Admin_Modal__deleteCostCodeSuccess(data, textStatus, jqXHR)
{
	try {

		// DOM Delete cost code from parent screen, ddl, etc.

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDivision(element, javaScriptEvent, attributeGroupName, uniqueId)
{
	try {

		// Trap the event
		trapJavaScriptEvent(javaScriptEvent);

		// Test for valid division_number
		var division_number_element = $("#create-cost_code_division-record--cost_code_divisions--division_number--" + uniqueId);
		var division_number = $("#create-cost_code_division-record--cost_code_divisions--division_number--" + uniqueId).val();
		if (division_number.length > 2) {
			var errorMessage = 'Division Number can only be two characters';
			messageAlert(errorMessage, 'errorMessage');
			highlightFormElement(division_number_element, 1);
			return;
		}

		// If the options object was not passed as an argument, create it here.
		var options = options || {};

		options.promiseChain = true;
		options.responseDataType = 'json';
		options.includeHtmlContent = 'Y';
		options.htmlRecordType = 'tr';
		options.moduleName = 'Gc_Budget';
		options.scenarioName = 'Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDivision';
		options.successCallback = Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDivisionSuccess;

		createCostCodeDivision(attributeGroupName, uniqueId, options);
		loadManageGcCostCodesDialog(null, true);
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDivisionSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			resetFormElements('record_creation_form_container--cost_code_divisions');

			var dummyId = json.dummyId;
			var htmlRecordOption = json.htmlRecordOption;
			var htmlRecordTr = json.htmlRecordTr;

			var ddlCostCodeDivisions = $("#ddl--create-cost_code-record--cost_codes--cost_code_division_id--" + dummyId);
			ddlCostCodeDivisions.append(htmlRecordOption);

			var tblImportCostCodes = $("#tblImportCostCodes");
			tblImportCostCodes.append(htmlRecordTr);

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

function Gc_Budget__Cost_Codes_Admin_Modal__updateCostCodeDivision(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Gc_Budget__Cost_Codes_Admin_Modal__updateCostCodeDivisionSuccess;

		// @todo Do we need this???
		var cost_code_type_id = $("#ddlCostCodeTypeId").val();

		updateCostCodeDivision(element, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Gc_Budget__Cost_Codes_Admin_Modal__updateCostCodeDivisionSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			updateIndenticalOriginDataOnPage(data, textStatus, jqXHR, 'both');

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Gc_Budget__Cost_Codes_Admin_Modal__deleteCostCodeDivision(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Gc_Budget__Cost_Codes_Admin_Modal__deleteCostCodeDivisionSuccess;

		var dummy_id = options.dummy_id;
		JavaScriptRegistry.set('dummy_id', dummy_id);

		deleteCostCodeDivision(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Gc_Budget__Cost_Codes_Admin_Modal__deleteCostCodeDivisionSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var cost_code_division_id = json.uniqueId;
			var dummy_id = JavaScriptRegistry.get('dummy_id');
			$("#ddl--delete_or_disable-cost_code_division-record--cost_code_divisions--cost_code_division_id--" + dummy_id + " option[value="+cost_code_division_id+"]").remove();

			var messageText = 'Cost code division and all of its cost codes were successfully deleted.';
			messageAlert(messageText, 'successMessage');

			// No need to refresh parent window since divisions "in use" cannot be deleted

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

function Gc_Budget__Cost_Codes_Admin_Modal__deleteOrDisableCostCodeDivision(element, javaScriptEvent, dummy_id, options)
{
	try {

		// Trap the event
		trapJavaScriptEvent(javaScriptEvent);

		crudOperation = options.crudOperation;

		options.responseDataType = 'json';
		options.successCallback = Gc_Budget__Cost_Codes_Admin_Modal__deleteOrDisableCostCodeDivisionSuccess;

		var element = $("#ddl--delete_or_disable-cost_code_division-record--cost_code_divisions--cost_code_division_id--" + dummy_id);
		var uniqueId = $(element).val();

		if (crudOperation == 'update') {

			var attributeGroupName = 'delete_or_disable-cost_code_division-record';
			var attributeSubgroupName = 'cost_code_divisions';
			var attributeName = 'disabled_flag';
			var formattedAttributeGroupName = 'Cost Code Division';
			var formattedAttributeSubgroupName = 'Cost Code Divisions';
			var formattedAttributeName = 'Disabled Flag';

			var htmlRecordMetaAttributes = {};
			htmlRecordMetaAttributes.attributeGroupName = attributeGroupName;
			htmlRecordMetaAttributes.attributeSubgroupName = attributeSubgroupName;
			htmlRecordMetaAttributes.attributeName = attributeName;
			htmlRecordMetaAttributes.uniqueId = uniqueId;
			htmlRecordMetaAttributes.formattedAttributeGroupName = formattedAttributeGroupName;
			htmlRecordMetaAttributes.formattedAttributeSubgroupName = formattedAttributeSubgroupName;
			htmlRecordMetaAttributes.formattedAttributeName = formattedAttributeName;

			options.htmlRecordMetaAttributes = htmlRecordMetaAttributes;

			// Toggle the value
			var divisionStatus = $("#ddl--delete_or_disable-cost_code_division-record--cost_code_divisions--cost_code_division_id--" + dummy_id + ' option:selected').text();
			var divisionStatusIndex = divisionStatus.indexOf('Enabled');
			if (divisionStatusIndex > -1) {
				options.newValue = 'Y';
			} else {
				options.newValue = 'N';
			}

			JavaScriptRegistry.set('dummy_id', dummy_id);

			updateCostCodeDivision(element, options);

		} else {

			// this, event, 'record_container--manage-cost_code_division-record--cost_code_divisions--sort_order--$uniqueId', 'delete-cost_code_division-record', '$uniqueId'
			// 'record_container--manage-cost_code_division-record--cost_code_divisions--sort_order--$uniqueId'
			// 'delete-cost_code_division-record'
			var recordContainerElementId = 'record_container--manage-cost_code_division-record--cost_code_divisions--sort_order--' + uniqueId;
			var attributeGroupName = 'manage-cost_code_division-record';

			deleteCostCodeDivision(recordContainerElementId, attributeGroupName, uniqueId, options);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Gc_Budget__Cost_Codes_Admin_Modal__deleteOrDisableCostCodeDivisionSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var crudOperation = json.crudOperation;
			var cost_code_division_id = json.uniqueId;
			var dummy_id = JavaScriptRegistry.get('dummy_id');

			if (crudOperation == 'update') {

				// Toggle the value
				var divisionStatus = $("#ddl--delete_or_disable-cost_code_division-record--cost_code_divisions--cost_code_division_id--" + dummy_id + ' option:selected').text();
				var divisionStatusIndex = divisionStatus.indexOf('Enabled');
				if (divisionStatusIndex > -1) {
					// Switch to Disabled
					var updateDivisionStatus = divisionStatus.replace('Enabled', 'Disabled');
				} else {
					// Switch to Enabled
					var updateDivisionStatus = divisionStatus.replace('Disabled', 'Enabled');
				}
				$("#ddl--delete_or_disable-cost_code_division-record--cost_code_divisions--cost_code_division_id--" + dummy_id + ' option:selected').text(updateDivisionStatus);

			} else {

				$("#ddl--delete_or_disable-cost_code_division-record--cost_code_divisions--cost_code_division_id--" + dummy_id + " option[value="+cost_code_division_id+"]").remove();

				//var messageText = 'Cost code division and all of its cost codes were successfully deleted.';
				var messageText = 'Cost Code Division has been successfully deleted.';
				messageAlert(messageText, 'successMessage');

			}

			// No need to refresh parent window since divisions "in use" cannot be deleted

		} else if (errorNumber == 4) {

			// Cannot delete Division as it has Cost Codes
			// @todo Prompt user to disable instead

			errorMessage = json.errorMessage;
			messageAlert(errorMessage, 'errorMessage');

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

function updateCostCodeAliasData(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		window.savePending = true;

		var arrParts = $(element).attr('id').split('--');
		var attributeName = arrParts[0];
		var attributeId = arrParts[1];
		var newValue = $(element).val();
		var contact_company_id = $("#ddlContactCompanyId").val();
		var user_company_id = $("#aliases_user_company_id").val();
		var project_id = $("#aliases_project_id").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=updateCostCodeAliasData';
		var ajaxQueryString =
		'user_company_id=' + encodeURIComponent(user_company_id) +
		'&project_id=' + encodeURIComponent(project_id) +
		'&contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&attributeName=' + encodeURIComponent(attributeName) +
		'&attributeId=' + encodeURIComponent(attributeId) +
		'&newValue=' + encodeURIComponent(newValue);
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
			success: updateCostCodeAliasDataSuccess,
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

function updateCostCodeAliasDataSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var attributeId = json.attributeId;
			var attributeName = json.attributeName;
			var aliasedRecordId = json.aliasedRecordId;
			var htmlContent = json.htmlContent;

			if (attributeName == "division_number_alias") {

				loadCostCodes();

			} else {

				var updatedHref = 'javascript:deleteCostCodeAliasData("cost_code_alias_id", "'+aliasedRecordId+'");';
				$("#hrefDeleteCostCodeAlias"+attributeId).attr('href', updatedHref);

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

function updateCostCodeAlias(element, options)
{
	// Debug

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		window.savePending = true;

		var arrParts = $(element).attr('id').split('--');
		var attributeName = arrParts[0];
		var attributeId = arrParts[1];
		var newValue = $(element).val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=updateCostCodeAlias';
		var ajaxQueryString =
		'attributeId=' + encodeURIComponent(attributeId) +
		'&attributeName=' + encodeURIComponent(attributeName) +
		'&newValue=' + encodeURIComponent(newValue);
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
			success: updateCostCodeAliasSuccess,
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

function updateCostCodeAliasSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			loadGcBudgetLineItems();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteCostCodeAliasData(cost_code_alias_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		window.savePending = true;

		cost_code_alias_id = $.trim(cost_code_alias_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=deleteCostCodeAliasData';
		var ajaxQueryString =
		'cost_code_alias_id=' + encodeURIComponent(cost_code_alias_id);
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
			success: deleteCostCodeAliasDataSuccess,
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

function deleteCostCodeAliasDataSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var cost_code_alias_id = json.cost_code_alias_id;
			var tr = $("#row_cost_code_alias_" + cost_code_alias_id);
			tr.remove();

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteCostCodeAliasData(attributeName, attributeId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		//alert(attributeName + ' ' + attributeId);
		if (attributeId == '') {
			return;
		}

		window.savePending = true;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=deleteCostCodeAliasData';
		var ajaxQueryString =
		'attributeName=' + encodeURIComponent(attributeName) +
		'&attributeId=' + encodeURIComponent(attributeId);
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
			success: deleteCostCodeAliasDataSuccess,
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

function deleteCostCodeAliasDataSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			loadCostCodes();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function fileUploader_DragEnter()
{
	$(".boxViewUploader").find(".qq-upload-drop-area").show();
}

function fileUploader_DragLeave()
{
	$(".boxViewUploader").find(".qq-upload-drop-area").hide();
}

function renderAllDocumentsForSelectedSubcontract(subcontract_id)
{
	$("#container--subcontracts--main--" + subcontract_id + " .buttonRenderDocument").each(function(i) {
		this.onclick();
	});
}

function initializePopovers()
{
	$(".btnAddSubcontractTemplatePopover").popover({
		html: true,
		title: 'Subcontract Templates',
		content: function() {
			var content = getPopoverContent(this, 'divAddSubcontractTemplatePopover');
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddGcContactCompanyOfficePopover").popover({
		html: true,
		title: 'Add Office',
		content: function() {
			var content = getPopoverContent(this, 'divAddGcContactCompanyOfficePopover');
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddGcContactCompanyOfficePhoneNumberPopover").popover({
		html: true,
		title: 'Add Office Phone Number',
		content: function() {
			if ($(this).hasClass('disabled')) {
				var content = 'Please select an office first.';
			} else {
				var subcontract_id = $('#activeGcBudgetLineSubcontractor').val();
				var content = getPopoverContentEditDynamic(this, 'divAddGcContactCompanyOfficePhoneNumberPopover', subcontract_id);
			}
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddGcContactCompanyOfficeFaxNumberPopover").popover({
		html: true,
		title: 'Add Office Fax Number',
		content: function() {
			if ($(this).hasClass('disabled')) {
				var content = 'Please select an office first.';
			} else {
				var subcontract_id = $('#activeGcBudgetLineSubcontractor').val();
				var content = getPopoverContentEditDynamic(this, 'divAddGcContactCompanyOfficeFaxNumberPopover', subcontract_id);
			}
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddContactPopover").popover({
		html: true,
		title: 'Add Contact',
		content: function() {
			var content = getPopoverContent(this, 'divAddContactPopover');
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddGcContactMobilePhoneNumberPopover").popover({
		html: true,
		title: 'Add Mobile Phone Number',
		content: function() {
			if ($(this).hasClass('disabled')) {
				var content = 'Please select a contact first.';
			} else {
				var subcontract_id = $('#activeGcBudgetLineSubcontractor').val();
				var content = getPopoverContentEditDynamic(this, 'divAddGcContactMobilePhoneNumberPopover', subcontract_id);
			}
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddVendorPopover").popover({
		html: true,
		title: 'Add Company',
		content: function() {
			var content = getPopoverContent(this, 'divAddVendorPopover');
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddVendorContactCompanyOfficePopover").popover({
		html: true,
		title: 'Add Office',
		content: function() {
			if ($(this).hasClass('disabled')) {
				var content = 'Please select a vendor first.';
			} else {
				var subcontract_id = $('#activeGcBudgetLineSubcontractor').val();
				var content = getPopoverContentEditDynamic(this, 'divAddVendorContactCompanyOfficePopover', subcontract_id);
			}
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddVendorContactCompanyOfficePhoneNumberPopover").popover({
		html: true,
		title: 'Add Office Phone Number',
		content: function() {
			if ($(this).hasClass('disabled')) {
				var content = 'Please select an office first.';
			} else {
				var subcontract_id = $('#activeGcBudgetLineSubcontractor').val();
				var content = getPopoverContentEditDynamic(this, 'divAddVendorContactCompanyOfficePhoneNumberPopover', subcontract_id);
			}
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddVendorContactCompanyOfficeFaxNumberPopover").popover({
		html: true,
		title: 'Add Office Fax Number',
		content: function() {
			if ($(this).hasClass('disabled')) {
				var content = 'Please select an office first.';
			} else {
				var subcontract_id = $('#activeGcBudgetLineSubcontractor').val();
				var content = getPopoverContentEditDynamic(this, 'divAddVendorContactCompanyOfficeFaxNumberPopover', subcontract_id);
			}
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddVendorContactPopover").popover({
		html: true,
		title: 'Add Contact',
		content: function() {
			var content = getPopoverContent(this, 'divAddVendorContactPopover');
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});
	$(".btnAddVendorContactMobilePhoneNumberPopover").popover({
		html: true,
		title: 'Add Mobile Phone Number',
		content: function() {
			if ($(this).hasClass('disabled')) {
				var content = 'Please select a vendor contact first.';
			} else {
				var subcontract_id = $('#activeGcBudgetLineSubcontractor').val();
				var content = getPopoverContentEditDynamic(this, 'divAddVendorContactMobilePhoneNumberPopover', subcontract_id);
			}
			return content;
		}
	}).click(function (e) {
		$('[data-original-title]').popover('hide');
		$(this).popover('show');
	});


	// Add datepicker and phonenumber widgets when the popover appears.
	$(".popoverButton").on('shown.bs.popover', function() {
		$(this).next().find('input:first').focus();
		var datepickerElement = $(this).next().find('.datepicker');
		datepickerElement.removeClass('hasDatepicker');
		datepickerElement.datepicker({ dateFormat: 'yy-mm-dd' });
		var phoneNumberElement = $(this).next().find('.phoneNumber');
		phoneNumberElement.mask('?(999) 999-9999');
	})
	// Add autocomplete widget when the Add Vendor popover appears.

	$("#btnAddVendorPopover").on('shown.bs.popover', function() {
		var ddlVendorContactCompanies = $(this).prev()[0];
		var arrCompanies = getArrCompaniesFromDropdown(ddlVendorContactCompanies);
		var popoverElement = $(this).next();
		var inputCompanyName = popoverElement.find('.companyNameModal');
		var appendToElement = inputCompanyName.closest('div').next();
		inputCompanyName.autocomplete({
			source: arrCompanies,
			select: function(event, ui) {
				$("#btnAddVendorPopover").popover('hide');
				$(ddlVendorContactCompanies).val(ui.item.id);
				updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(ddlVendorContactCompanies);
			},
			appendTo: appendToElement,
			position: {
				of: appendToElement
			}
		});
	});

	$(".bs-tooltip").tooltip();
}

function createContactCompanyOfficeAndUpdateContactCompanyOfficeDdlViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		var subcontractCompanyGroupName = options.subcontractCompanyGroupName;
		var subcontract_id = $("#activeGcBudgetLineSubcontractor").val();
		var promise = createContactCompanyOffice(attributeGroupName, uniqueId, options);
		promise.then(function(json) {

			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var htmlRecordOption = json.htmlRecordOption;
				var popoverElementId = options.popoverElementId;
				$("." + popoverElementId).popover('hide');
				// var ddl = $("#" + popoverElementId).prev();
				var ddl = $("#" + subcontractCompanyGroupName + subcontract_id);
				var htmlRecordOption = json.htmlRecordOption;
				ddl.append(htmlRecordOption);
				var ddlElement = ddl[0];
				updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(ddlElement);
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

function createContactCompanyOfficePhoneNumberAndUpdateContactCompanyOfficePhoneNumberDdlViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		var subcontractCompanyGroupName = options.subcontractCompanyGroupName;
		var subcontract_id = $("#activeGcBudgetLineSubcontractor").val();
		var ajaxQueryString = '';
		var phone_number_element_id = attributeGroupName + '--contact_company_office_phone_numbers--phone_number--' + uniqueId;
		if ($("#" + phone_number_element_id).length) {
			var phoneNumber = $("#" + phone_number_element_id).val();
			var tokens = parsePhoneNumber(phoneNumber);
			var area_code = tokens[0];
			var prefix = tokens[1];
			var number = tokens[2];
			ajaxQueryString = ajaxQueryString + '&area_code=' + encodeURIComponent(area_code);
			ajaxQueryString = ajaxQueryString + '&prefix=' + encodeURIComponent(prefix);
			ajaxQueryString = ajaxQueryString + '&number=' + encodeURIComponent(number);
		}

		var popoverElementId = options.popoverElementId;
		if (popoverElementId) {
			ajaxQueryString = ajaxQueryString + '&popoverElementId=' + encodeURIComponent(popoverElementId);
		}
		options.adHocQueryParameters = ajaxQueryString;

		var promise = createContactCompanyOfficePhoneNumber(attributeGroupName, uniqueId, options);
		promise.then(function(json) {

			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var htmlRecordOption = json.htmlRecordOption;
				var popoverElementId = options.popoverElementId;
				$("." + popoverElementId).popover('hide');
				// var ddl = $("#" + popoverElementId).prev();
				var ddl = $("#" + subcontractCompanyGroupName + subcontract_id);
				ddl.append(htmlRecordOption);
				var ddlElement = ddl[0];
				updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(ddlElement);
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

function createContactPhoneNumberAndUpdateContactPhoneNumberDdlViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		var subcontractCompanyGroupName = options.subcontractCompanyGroupName;
		var subcontract_id = $("#activeGcBudgetLineSubcontractor").val();

		var ajaxQueryString = '';
		var phone_number_element_id = attributeGroupName + '--contact_phone_numbers--phone_number--' + uniqueId;
		if ($("#" + phone_number_element_id).length) {
			var phoneNumber = $("#" + phone_number_element_id).val();
			var tokens = parsePhoneNumber(phoneNumber);
			var area_code = tokens[0];
			var prefix = tokens[1];
			var number = tokens[2];
			ajaxQueryString = ajaxQueryString + '&area_code=' + encodeURIComponent(area_code);
			ajaxQueryString = ajaxQueryString + '&prefix=' + encodeURIComponent(prefix);
			ajaxQueryString = ajaxQueryString + '&number=' + encodeURIComponent(number);
		}

		var popoverElementId = options.popoverElementId;
		if (popoverElementId) {
			ajaxQueryString = ajaxQueryString + '&popoverElementId=' + encodeURIComponent(popoverElementId);
		}
		options.adHocQueryParameters = ajaxQueryString;

		var promise = createContactPhoneNumber(attributeGroupName, uniqueId, options);
		promise.then(function(json) {

			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var htmlRecordOption = json.htmlRecordOption;
				var uniqueId = json.uniqueId;
				var contact_phone_number_contact_id = json.contact_phone_number_contact_id;
				var popoverElementId = options.popoverElementId;
				$("." + popoverElementId).popover('hide');
				var ddl = $("#" + subcontractCompanyGroupName + subcontract_id);
				ddl.append(htmlRecordOption);
				var ddlElement = ddl[0];
				updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(ddlElement);

				// Not sure if this is necessary.
				var dummyId = generateDummyElementId();
				var mobilePhoneNumberInputs = '<div class="hidden">' +
				'<input type="hidden" id="create-mobile_phone_number-record--mobile_phone_numbers--contact_id--'+dummyId+'" value="'+contact_phone_number_contact_id+'">' +
				'<input type="hidden" id="create-mobile_phone_number-record--mobile_phone_numbers--contact_phone_number_id--'+dummyId+'" value="'+uniqueId+'">' +
				'<input type="hidden" id="create-mobile_phone_number-record--mobile_phone_numbers--verified_flag--'+dummyId+'" value="N">' +
				'</div>';
				$(document.body).append(mobilePhoneNumberInputs);
				createMobilePhoneNumber('create-mobile_phone_number-record', dummyId);
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

function createContactCompanyAndUpdateVendorDdlViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		var subcontractCompanyGroupName = options.subcontractCompanyGroupName;
		var subcontract_id = $("#activeGcBudgetLineSubcontractor").val();
		var promise = createContactCompany(attributeGroupName, uniqueId, options);
		promise.then(function(json) {

			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var popoverElementId = options.popoverElementId;
				$("." + popoverElementId).popover('hide');

				var ddl = $("#" + subcontractCompanyGroupName + subcontract_id);
				var htmlRecordOption = json.htmlRecordOption;
				ddl.append(htmlRecordOption);
				var ddlElement = ddl[0];
				updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(ddlElement);
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

function filterGcBudgetLineItems(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var cost_code_division_id = '-1';
		var order_by_attribute = $("#order_by_attribute").val();
		var order_by_direction = $("#order_by_direction").val();
		var scheduledValuesOnly = $("#scheduledValuesOnly").is(':checked');
		var needsBuyOutOnly = $("#needsBuyOutOnly").is(':checked');
		var needsSubValue  =$("#needsSubValue").is(':checked');
		var activeProjectId = $("#currentlySelectedProjectId").val();
			
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=filterGcBudgetLineItems';
		var ajaxQueryString =
			'cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
			'&order_by_attribute=' + encodeURIComponent(order_by_attribute) +
			'&order_by_direction=' + encodeURIComponent(order_by_direction) +
			'&scheduledValuesOnly=' + encodeURIComponent(scheduledValuesOnly) +
			'&needsBuyOutOnly=' + encodeURIComponent(needsBuyOutOnly)+
			'&needsSubValue=' + encodeURIComponent(needsSubValue)+
			'pID='+btoa(encodeURIComponent(activeProjectId));
			
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		/*reload*/
		var url = location.protocol + '//' + location.host + location.pathname;
		if (url.indexOf('?') > -1){
			url += '&order_by_direction='+order_by_direction
		}else{
			url += '?order_by_direction='+order_by_direction
		}
		if (url.indexOf('?') > -1){
			url += '&order_by_attribute='+order_by_attribute
		}else{
			url += '?order_by_attribute='+order_by_attribute
		}
		if (url.indexOf('?') > -1){
			url += '&scheduledValuesOnly='+scheduledValuesOnly
		}else{
			url += '?scheduledValuesOnly='+scheduledValuesOnly
		}
		if (url.indexOf('?') > -1){
			url += '&needsBuyOutOnly='+needsBuyOutOnly
		}else{
			url += '?needsBuyOutOnly='+needsBuyOutOnly
		}
		if (url.indexOf('?') > -1){
			url += '&needsSubValue='+needsSubValue
		}else{
			url += '?needsSubValue='+needsSubValue
		}

		if (url.indexOf('?') > -1){
			url += '&pID='+btoa(encodeURIComponent(activeProjectId))
		}else{
			url += '?pID='+btoa(encodeURIComponent(activeProjectId))
		}
		window.location.href = url;
		return;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: filterGcBudgetLineItemsSuccess,
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
function calculateValueSubtotal(calVal){
	var typeFld = calVal.split('+');
	var pcsvORfe = typeFld[0];
	var count = typeFld[1];
	var loopLength = $(".pcsvSubFld"+count).length;
	if(pcsvORfe == 'pcsv'){
		var total = 0;
		for(var i=1; i<=loopLength; i++){
			var value = $(".pcsvSubFld"+count+"-"+i).val();
			if(value == undefined || value=="undefined")
			value = 0;
			value = value.replace(/[^0-9\.-]+/g, "");
			total = Number(total) + Number(value);

		}

		total = total.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
		$("#pcsvSubtotal"+count).empty().html(total);
	}
	if(pcsvORfe == 'fe'){
		var total = 0;
		for(var i=1; i<=loopLength; i++){
			var value = $(".feSubFld"+count+"-"+i).val();
			if(value == undefined || value=="undefined")
			value = 0;
			value = value.replace(/[^0-9\.-]+/g, "");
			total = Number(total) + Number(value);
		}
		if(total < 0)
		$("#feSubtotal"+count).addClass("red");
		else
		$("#feSubtotal"+count).removeClass("red");
		total = total.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
		$("#feSubtotal"+count).empty().html(total);
	}
	// For buyout expenses
	if(pcsvORfe == 'be'){
		var total = 0;
		for(var i=1; i<=loopLength; i++){
			var value = $(".beSubFld"+count+"-"+i).val();
			if(value == undefined || value=="undefined")
			value = 0;
			value = value.replace(/[^0-9\.-]+/g, "");
			total = Number(total) + Number(value);
		}
		if(total < 0)
		$("#beSubtotal"+count).addClass("red");
		else
		$("#beSubtotal"+count).removeClass("red");
		total = total.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
		$("#beSubtotal"+count).empty().html(total);
	}
	var total = 0;
	for(var i=1; i<=loopLength; i++){
		var value = $(".vSubFld"+count+"-"+i).html();
		if(value == undefined || value=="undefined")
		value = 0;
		value = value.replace(/[^0-9\.-]+/g, "");
		total = Number(total) + Number(value);
	}
	if(total < 0)
	$("#vSubtotal"+count).addClass("red");
	else
	$("#vSubtotal"+count).removeClass("red");
	total = total.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
	$("#vSubtotal"+count).empty().html(total);

}

function navigateToBudget(pID)
{
	window.location.href = window.ajaxUrlPrefix + 'modules-gc-budget-form.php?pID='+btoa(pID);
		return;
}
function filterGcBudgetLineItemsSuccess(data, textStatus, jqXHR)
{
	try {

		$("#tblTabularData tbody").html(data);
		$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd', numberOfMonths: 1 });
		var checkBox=$("#subtotalview").is(':checked');
		if (checkBox) {
			jQuery('.bottom-content').show();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createSubcontractAndVendorAndSubcontractDocumentsAndReloadSubcontractDetailsDialogViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var gc_budget_line_item_id = 0;
		showSpinner();

		var is_po = $('#is_PO--'+uniqueId).val();
		var is_gl_account_available = $('#is_gl_account_available--'+uniqueId).val();
		if(is_po =='1'){
			if($('#project_customer_exist').val() =='0'){
				messageAlert('Please select Customer:Project in Project Admin.', 'errorMessage');
				hideSpinner();
				return false;
			} else if($('#project_customer').val() ==''){
				messageAlert('Customer:Project is required.', 'errorMessage');
				hideSpinner();
				return false;
			}else if(is_gl_account_available == '0'){
				messageAlert('Please map the GL account in Accounting Portal.', 'errorMessage');
				hideSpinner();
				return false;
			}
		}
		var promise1 = createSubcontractAndVendorAndSubcontractDocuments(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function(json) {

			try {
				var gc_budget_line_item_id = json.gc_budget_line_item_id;
				var innerPromise = loadSubcontractDetails(gc_budget_line_item_id, options);
				$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd', numberOfMonths: 1 });
				return innerPromise;

			} catch (error) {

				window.location.reload();

			}

		});
		promise2.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}



function deleteSubcontractAndReloadSubcontractDetailsDialogViaPromiseChain(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		showSpinner();
		var promise1 = deleteSubcontract(recordContainerElementId, attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function() {

			try {
				var active_gc_budget_line_item_id = $("#active_gc_budget_line_item_id").val();
				var innerPromise = loadSubcontractDetails(active_gc_budget_line_item_id, options);
				return innerPromise;
			} catch (error) {
				window.location.reload();
			}

		});
		promise2.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function loadSubcontractDetails(gc_budget_line_item_id, options)
{
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadSubcontractDetails';
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
			success: loadSubcontractDetailsSuccess,
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

function loadSubcontractDetailsSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divModalWindow").html(data);

		// File Uploaders
		createUploaders();

		// Sortable
		$(".tbodySortable").sortable({
			axis: 'y',
			distance: 10,
			helper: sortHelper,
			update: function(event, ui) {
				var trElement = $(ui.item)[0];
				var endIndex = $(ui.item).index();
				endIndex = endIndex.toString();
				var options = { endIndex: endIndex };
				updateSubcontractDocument(trElement, options);
			}
		});
		$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd', numberOfMonths: 1 });
		initializePopovers();

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(element, options,checks, subid, checkModalOpen)
{
	try {
		if(checkModalOpen == '' || checkModalOpen == undefined || checkModalOpen == 'null'){
			checkModalOpen = false;
		}
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = checkModalOpen;
		options.responseDataType = 'json';
		//For contract tracking
		if(checks =='1')
		{
			var old=$("#manage-subcontract-record--subcontracts--general_insurance_date--"+subid).val();
			var newval=$("#manage-subcontract-record--subcontracts--general_insurance_date_expiry--"+subid).val();
			var updateData=$("#manage-subcontract-record--subcontracts--general_insurance_date_expiry--"+subid);
			var msg="GENLIB";
		}if(checks =='2')
		{
			var old=$("#manage-subcontract-record--subcontracts--worker_date--"+subid).val();
			var newval=$("#manage-subcontract-record--subcontracts--worker_date_expiry--"+subid).val();
			var updateData=$("#manage-subcontract-record--subcontracts--worker_date_expiry--"+subid);
			var msg="WRKCHP";
		}if(checks =='3')
		{
			var old=$("#manage-subcontract-record--subcontracts--car_insurance_date--"+subid).val();
			var newval=$("#manage-subcontract-record--subcontracts--car_insurance_date_expiry--"+subid).val();
			var updateData=$("#manage-subcontract-record--subcontracts--car_insurance_date_expiry--"+subid);
			var msg="CARINS";
		}if(checks =='4')
		{
			var old=$("#manage-subcontract-record--subcontracts--city_license_date--"+subid).val();
			var newval=$("#manage-subcontract-record--subcontracts--city_license_date_expiry--"+subid).val();
			var updateData=$("#manage-subcontract-record--subcontracts--city_license_date_expiry--"+subid);
			var msg="CTYBUS";
		}
		if(Number(checks) == 5)
		{
			var newValueText = $(element).val();
			var checkDateMinimze = new Date();
			var dateObj = new Date();
			var month = dateObj.getUTCMonth() + 1; //months from 1-12
			var day = dateObj.getUTCDate();
			var year = dateObj.getUTCFullYear();

			var currentDate = month + "/" + day + "/" + year;
			currentDate = new Date(currentDate);
			newValueText = new Date(newValueText);
			if(newValueText < currentDate)
			{
				$(element).css('color','red');
			}else{
				$(element).css('color','');
			}
		}
		

		showSpinner();
		var promise1 = Gc_Budget__updateSubcontract(element, options);
		var promise2 = promise1.then(function(data) {

			try {
				var json = data;
				var uniqueId = json.uniqueId;
				var activeGcBudgetLineItem = $('#activeGcBudgetLineItem').val();
				var ary = activeGcBudgetLineItem.split("-");
				var gc_budget_line_item_id = ary[0];
				var cost_code_division_id = ary[1];
				var cost_code_id = ary[2];
				// Debug
				var innerPromise = openSubcontractsDialog(gc_budget_line_item_id, cost_code_division_id, cost_code_id);
				return innerPromise;
			} catch (error) {
				//For insurance it should not load
				if((checks ==0) || (checks ==1) || (checks ==2) ||(checks ==3) || (checks ==4))
				{

				}else{
					window.location.reload();
				}
			}

		});
		promise2.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function Gc_Budget__updateSubcontract(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';

		// @todo Confirm that no other patters (record_container-- with sort_order or ddl--) are needed here
		var arrParts = $(element).attr('id').split('--');
		var attributeGroupName = arrParts[0];
		var attributeSubgroupName = arrParts[1];
		var attributeName = arrParts[2];
		var uniqueId = arrParts[3];

		if (attributeSubgroupName == 'subcontracts') {

			// Filter Input - attributes of type: decimal(10,2)
			if ((attributeName == 'subcontract_forecasted_value') || (attributeName == 'subcontract_actual_value') || (attributeName == 'subcontract_retention_percentage')) {

				objElementValue = filterAndFormatMonetaryValueInPlace(element);

			}

		}

		if (options.promiseChain) {

			var promise = updateSubcontract(element, options);
			return promise;

		} else {

			var promise =updateSubcontract(element, options);
			return promise;

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadSubcontractDetailsWidget(subcontract_id, options)
{
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadSubcontractDetailsWidget';
		var ajaxQueryString =
		'subcontract_id=' + encodeURIComponent(subcontract_id);
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
			success: loadSubcontractDetailsWidgetSuccess,
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

function loadSubcontractDetailsWidgetSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var subcontract_id = json.subcontract_id;
			var html = json.html;
			$("#container--subcontracts--" + subcontract_id).html(html);
			$('.datepicker').not('.hasDatepicker').datepicker({ dateFormat: 'yy-mm-dd' });
			initializePopovers();

		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function subcontractDocumentUploaded(arrFileManagerFiles, containerElementId,Idval)
{
	var fileManagerFile = arrFileManagerFiles[0];
	var virtual_file_name = fileManagerFile.virtual_file_name;
	var fileUrl = fileManagerFile.fileUrl;
	var a = '<a class="underline" target="_blank" href="' + fileUrl + '">' + virtual_file_name + '</a>';
	$("#" + containerElementId).html(a);
	$("#"+Idval).css('display','block');
}


function createSubcontractDocumentsForSubcontract(subcontract_id, options)
{
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=createSubcontractDocumentsForSubcontract';
		var ajaxQueryString =
		'subcontract_id=' + encodeURIComponent(subcontract_id);
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
			success: createSubcontractDocumentsForSubcontractSuccess,
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

function createSubcontractDocumentsForSubcontractSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var subcontract_id = json.subcontract_id;
		var csvSubcontractDocumentIds = json.csvSubcontractDocumentIds;
		// Do something?

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function addOrUpdateProjectstatsDetails(fileId,template_id)
{
	var ajaxUrl = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php';
	$.ajax({
		method:'GET',
		url:ajaxUrl,
		data:'method=updateorAddprjStaticfile&fileId='+fileId+'&template_id='+template_id,
		success:function(data)
		{

		}

	});
}

function unsignedSubcontractDocumentUploaded(arrFileManagerFiles, containerElementId,update,template_id)
{
	var fileManagerFile = arrFileManagerFiles[0];
	var virtual_file_name = fileManagerFile.virtual_file_name;
	var fileUrl = fileManagerFile.fileUrl;
	var a = '<a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="' + fileUrl + '" title="' + virtual_file_name + '">Document</a>';
	$("#" + containerElementId).html(a);
	$('.bs-tooltip').tooltip();

	var element = $("#" + containerElementId)[0];
	flashHighlightElement(element);
	var fileId = fileManagerFile.file_manager_file_id;
	if(update =="1")
	{
		addOrUpdateProjectstatsDetails(fileId,template_id);
	}
}

function signedSubcontractDocumentUploaded(arrFileManagerFiles, containerElementId)
{
	var fileManagerFile = arrFileManagerFiles[0];
	var virtual_file_name = fileManagerFile.virtual_file_name;

	var fileUrl = fileManagerFile.fileUrl;
	var fileId = fileManagerFile.file_manager_file_id;

	var a = '<a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="' + fileUrl + '" title="' + virtual_file_name + '">Link To Document</a>';
	$("#" + containerElementId).html(a);
	$("#" + containerElementId+"_id").val(fileId);
	$('.bs-tooltip').tooltip();

	var element = $("#" + containerElementId)[0];
	flashHighlightElement(element);
}

function flashHighlightElement(element)
{
	var initialBackgroundColor = $(element).css('backgroundColor');
	$(element).css('backgroundColor', 'yellow');
	$(element).animate({ backgroundColor: initialBackgroundColor }, 2000);
}

function projectBidInvitationFileUploaded(arrFileManagerFiles, containerElementId)
{
	var fileManagerFile = arrFileManagerFiles[0];
	var virtual_file_name = fileManagerFile.virtual_file_name;
	var fileUrl = fileManagerFile.fileUrl;
	var a = '<a href="' + fileUrl + '" target="_blank">' + virtual_file_name + '</a>';
	$('.' + containerElementId).html(a);
}

function moveToNextRowIfEnterKeyWasPressed(event)
{
	// keyCode 13 is the enter key (standard across all browsers and platforms).
	if (event.keyCode != 13) {
		return;
	}

	// Get the class of the element that should get focus.
	var targetElement = event.target;
	if ($(targetElement).hasClass('autosum-pcsv')) {
		var nextElementClass = 'autosum-pcsv';
	} else if ($(targetElement).hasClass('autosum-fe')) {
		var nextElementClass = 'autosum-fe';
	} else {
		return;
	}

	// If the shift key was pressed, focus the element of the previous row.
	// Otherwise, focus the element of the next row.
	var tr = $(targetElement).closest('tr');
	if (event.shiftKey) {
		tr.prev().find('.' + nextElementClass).focus();
	} else {
		tr.next().find('.' + nextElementClass).focus();
	}
}

function showSubcontractDetails(element, subcontract_id, activeWidget)
{
	$('#activeGcBudgetLineSubcontractor').val(subcontract_id);
	$('#activeGcBudgetLineWidget').val(activeWidget);
	$('[id^="container--subcontracts--main--"]').each(function() {
		if (this.id != 'container--subcontracts--main--' + subcontract_id) {
			$(this).addClass('hidden');
		}
	});
	$("#container--subcontracts--main--" + subcontract_id).toggleClass('hidden');
	$(element).parent().find('a').each(function() {
		if (this != element) {
			$(this).removeClass('active');
		}
	});
	$(element).toggleClass('active');
}
//Method to call Transmittal Notice popup
function TransmittalNotice(type,id,subcontract_id,primary_contact_id, primary_contact_name)
{

	var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-operations.php';
	var request_id=$('#request_for_information_id').val();
	var address_id=$('#manage-subcontract-record--subcontracts--subcontract_vendor_contact_company_office_id--'+subcontract_id).val();
	$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:'method=subcontractorNotice&budget_id='+id+'&type='+type+'&address_id='+address_id+'&subcontract_id='+subcontract_id,
		success:function(res)
		{
			$('#Viewsubcontractor-'+subcontract_id).empty().html(res);
			$('#Viewsubcontractor-'+subcontract_id).css('display','block');
			createUploaders();
			automaticEmailSubcontractorRecipient(primary_contact_id, primary_contact_name);
			$('head').append('<link href="/css/modules-requests-for-information.css" id="rfi_css_email" rel="stylesheet">');
			$('.emailGroup').fSelect();
		}

	});
}
function automaticEmailSubcontractorRecipient(element,html){
	try {
		var suDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();

		var ul = $('#record_container--request_for_information_recipients--Cc');
		var a = '<a href="#" onclick="Delays__removeRecipient(this); return false;">X</a>';
		var span = '<span id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id_span--dummy_id_' + suDummyId + '">' + html + '</span>';
		var input = '<input id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--dummy_id_' + suDummyId + '" class="cc_recipients" type="hidden" value="' + element + '">';
		var li = '<li id="' + element + '">' + a + '&nbsp;&nbsp;' + span + input + '</li>';
		var found = ul.find('li[id='+element+']').length > 0;
		if (!found) {
			ul.append(li);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function modal_Close(subcontract_id) {
	$('#Viewsubcontractor-'+subcontract_id).css('display','none');
	$('#Viewsubcontractor-'+subcontract_id).empty();
	$('#rfi_css_email').remove();
}
function emailfilters(id,val)
{
	var text=$('#'+id+' option:selected').text();
	if(text=='Roles')
	{
		$('#project_role').show();
		$('#projectCompany').hide();
		$('#project_role').prop('selectedIndex',0);
	}else if(text=='Company')
	{
		$('#projectCompany').show();
		$('#project_role').hide();
		$('#projectCompany').prop('selectedIndex',0);
	}
	else if(text=='All')
	{
		$('#projectCompany').hide();
		$('#project_role').hide();
		var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-operations.php';
		$.ajax({
			method:'POST',
			url:ajaxUrl,
			data:'method=allemail&software_module=subcontracts',
			success:function(data)
			{
				$('.to_contact').empty().append(data);
				$('.cc_contact').empty().append(data);
				$('.fs-search').empty();
				$('.emailGroup').fSelect('reload');
			}

		});
	}

}
function emailroles(val)
{
	var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-operations.php';
	$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:'method=rolesemail&val='+val+'&software_module=subcontracts',
		success:function(data)
		{
			$('.to_contact').empty().append(data);
			$('.cc_contact').empty().append(data);
			$('.fs-search').empty();
			$('.emailGroup').fSelect('reload');
		}

	});
}
function emailcompany(val)
{
	var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-operations.php';
	$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:'method=projectsemail&val='+val+'&software_module=subcontracts',
		success:function(data)
		{
			$('.to_contact').empty().append(data);
			$('.cc_contact').empty().append(data);
			$('.fs-search').empty();
			$('.emailGroup').fSelect('reload');
		}

	});
}

function email_subcontractor(uniqueId, subcontract_id)
{
	var emailTo = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
	var address_id=$('#address_id').val();
	var type=$('#type').val();

	var err=false;
	if(emailTo == '' || emailTo == 0){
		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
		err = true;
	}

	$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).change(function(){
		var emailVal = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
		if(emailVal)
		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').removeClass('redBorderThick');
	});
	var emailCcArr = {};
	var ccCount = 0;
	$( ".cc_recipients" ).each(function( index ) {
		var cc = $(this).val();
		emailCcArr[ccCount] =  parseInt(cc) ;
		ccCount++;
	});
	var emailCc = JSON.stringify(emailCcArr);

	var emailBCcArr = {};
	var bccCount = 0;
	$( ".bcc_recipients" ).each(function( index ) {
		var bcc = $(this).val();
		emailBCcArr[bccCount] =  parseInt(bcc) ;
		bccCount++;
	});
	var emailBCc = JSON.stringify(emailBCcArr);
	var upfileval=$('#upfile').val();
	var i =0;
	var attachmentsArr = {};
	attachmentsArr[i] =  parseInt(upfileval) ;

	var attachments = JSON.stringify(attachmentsArr);
	var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-operations.php';
	if(err){

		messageAlert('Please fill in the highlighted areas .', 'errorMessage');
	}else{
		showSpinner();
		$.ajax({
			method:'POST',
			url:ajaxUrl,
			data:'method=email_subcontractor&emailTo='+emailTo+"&emailCc="+emailCc+"&emailBCc="+emailBCc+"&attachments="+attachments+"&address_id="+address_id+"&type="+type+"&subcontract_id="+subcontract_id,
			success:function(data)
			{
				if(data=='1')
				{
					hideSpinner();
					modal_Close(subcontract_id);
					messageAlert('Mail Send Successfully.', 'successMessage');
				}
			}

		});
	}
}
function addRecipient(element)
{
	try {

		var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();

		// Get ul.
		var val = $("#" + element.id + " option:selected").val();
		if (val == '' || val == 0) {
			return;
		}
		var html = $("#" + element.id + " option:selected").html();
		var div = $(element).closest('div').parent().parent();
		var ul = div.find('ul');
		var ulId = $(ul).attr('id');
		var a = '<a href="#" onclick="Delays__removeRecipient(this); return false;">X</a>';
		var span = '<span id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id_span--' + rfiDummyId + '">' + html + '</span>';

		if(ulId == 'record_container--request_for_information_recipients--Cc')
		var input = '<input class="cc_recipients" id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--' + rfiDummyId + '" type="hidden" value="' + val + '">';
		else if(ulId == 'record_container--request_for_information_recipients--Bcc')
		var input = '<input class="bcc_recipients" id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--' + rfiDummyId + '" type="hidden" value="' + val + '">';
		else
		var input = '<input id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--' + rfiDummyId + '" type="hidden" value="' + val + '">';


		var li = '<li id="' + val + '">' + a + '&nbsp;&nbsp;' + span + input + '</li>';

		var found = ul.find('li[id='+val+']').length > 0;
		if (!found) {
			ul.append(li);
			$("#" + element.id + " option:selected").attr('disabled',true);
			$("#" + element.id).val('');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function Delays__removeRecipient(element)
{
	try {

		var dummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
		var cc_dropdownId = "#ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Cc-"+dummyId;
		var bcc_dropdownId = "#ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Bcc-"+dummyId;


		var ul_id = $(element).parent().parent().attr('id');
		var id = $(element).parent().attr('id');
		if(ul_id == 'record_container--request_for_information_recipients--Cc'){
			$(cc_dropdownId).find("option[value=" + id +"]").attr('disabled', false);

		}else if(ul_id == 'record_container--request_for_information_recipients--Bcc'){
			$(bcc_dropdownId).find("option[value=" + id +"]").attr('disabled', false);
		}
		$(element).parent().remove();


	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
// Prime contract schedule value allow or restrict
function allowToUserEditPrimeValue(allow){
	if(allow){
		$('#entypo-edit-icon').css('display','none');
		$('#entypo-lock-icon').css('display','block');
		$('.prime_contract_scheduled_value-text').css('display','none');
		$('.prime_contract_scheduled_value-edit').css('display','block');
	}else{
		$('#entypo-edit-icon').css('display','block');
		$('#entypo-lock-icon').css('display','none');
		$('.prime_contract_scheduled_value-text').css('display','block');
		$('.prime_contract_scheduled_value-edit').css('display','none');
	}
}



//update scheduled value in draw items

function updateScheduledValueInDraws(data, options){
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		var gcBudgetLineItemId = data.uniqueId;
		var scheduledValue = data.newValue;
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=updateScheduledValueInDraws';
		var ajaxQueryString =
		'gcBudgetLineItemId=' + encodeURIComponent(gcBudgetLineItemId) +
		'&scheduledValue=' + encodeURIComponent(scheduledValue);
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
			success: updateScheduledValueInDrawsSuccess,
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
};

function updateScheduledValueInDrawsSuccess(data, textStatus, jqXHR){
	try {



	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
};

function deleteGcBudgetFromDraws(data, options){
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;
		var activeProjectId = $("#currentlySelectedProjectId").val();

		var gcBudgetLineItemId = data.uniqueId;
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=deleteGcBudgetFromDraws';
		var ajaxQueryString =
		'gcBudgetLineItemId=' + encodeURIComponent(gcBudgetLineItemId) + '&pID='+btoa(encodeURIComponent(activeProjectId));
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
			success: deleteGcBudgetFromDrawSuccess,
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
};

function deleteGcBudgetFromDrawSuccess(data, textStatus, jqXHR){
	try {



	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
};
//import cost code popup
function loadImportCostCodesFromExcel(){
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadUploadCostCode';
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
			success: loadImportCostCodesFromExcelSuccess,
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

function loadImportCostCodesFromExcelSuccess(data, textStatus, jqXHR){
	try {

		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").html(data);
		$("#divModalWindow").dialog({
			height: 600,
			width: 1000,
			modal: true,
			title: 'Import Cost Codes',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divModalWindow").dialog('destroy');
				$("#divModalWindow").html('');
				$("#divModalWindow").addClass('hidden');
				deleteCostCodeFile();
				$("#costCodeTemplate").val('');
        $("#costCodeTemplateErrorValid").val('');
			}
		});
		createUploaders();
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
};
/*Delete temp file*/
function deleteCostCodeFile(){
	$("#record_list_container--manage-costcode-file-import-record").empty();
	var filePath = $("#costCodeTemplate").val();
	var ajaxQueryString = "method=deleteCostCodeFile&filePath="+filePath+"&deleteFlag=Y";
	var ajaxHandler = "modules-gc-budget-ajax.php";
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function(html){
			$("#costCodeTemplate").val('');
			$('#record_list_container--manage-costcode-file-import-record').empty();
			$("#costCodeTemplateErrorValid").val('');
			$('#stepOneNextButton').attr('disabled','disabled');
			$('#stepOneNextButton').addClass('btn-disable');
			$('#costCodeUploadStepTwo').empty();
			$('#costCodeUploadStepThree').empty();
		},
		async:true,
		error: errorHandler
	});
};
/*append upload file name*/
function costCodeExcelFileRefresh(arrFileManagerFiles){
	$("#costCodeTemplateErrorValid").val('');
	var filePath = arrFileManagerFiles['virtualFilePath'];
	var filename = arrFileManagerFiles['virutalFileName'];
	var liData = arrFileManagerFiles['liData'];
	$("#costCodeTemplate").val(filePath);
	$("#record_list_container--manage-costcode-file-import-record").empty().append(liData);

	var costCodeTemplate = $("#costCodeTemplate").val();
	if(costCodeTemplate == '' || costCodeTemplate == null){
		messageAlert('Please select excel(.xlsx) file','errorMessage');
		return false;
	}
	$('#stepOneNextButton').attr('disabled',false);
	$('#stepOneNextButton').removeClass('btn-disable');
};

function mapExcelHeaders(){
	$("#costCodeTemplateErrorValid").val('');
	var costCodeTemplate = $("#costCodeTemplate").val();
	if(costCodeTemplate == '' || costCodeTemplate == null){
		messageAlert('Please select excel(.xlsx) file','errorMessage');
		return false;
	}
	var filePath = $("#costCodeTemplate").val();
	var ajaxQueryString = "method=mapExcelHeaders&filePath="+costCodeTemplate;
	var ajaxHandler = "modules-gc-budget-ajax.php";
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function(html){
			var JsonData = $.parseJSON(html);
			var headers = JsonData.headers;
			var headerCount = JsonData.headerCount;
			if(headerCount == 1){
				$('#costCodeUploadStepTwo').empty().html(headers);
				gotoStepTwo();
			}else{
				messageAlert('The 1st and 2nd row of the excel sheet are reserved for headers','errorMessage');
				return false;
			}
		},
		async:true,
		error: errorHandler
	});
};

//import cost code excel
function importCostCodeExcel(divisionNumber,costcodeNumber,divisionHeadingNumber,divisionName,costCodeDescription,costCodeDescriptionAbbreviation,divisionAbbreviation){
	var costCodeTemplate = $("#costCodeTemplate").val();
	var invalid = $("#costCodeTemplateErrorValid").val();
	if(invalid!=0){
		messageAlert('Please upload excel, valid data with mandatory field','errorMessage');
		return false;
	}
	if(costCodeTemplate == '' || costCodeTemplate == null){
		messageAlert('Please select excel(.xlsx) file','errorMessage');
		return false;
	}
	var ajaxQueryString = "method=uploadCostCode&filePath="+costCodeTemplate+
	"&divisionNumber="+divisionNumber+
	"&costcodeNumber="+costcodeNumber+
	"&divisionHeadingNumber="+divisionHeadingNumber+
	"&divisionName="+divisionName+
	"&divisionAbbreviation="+divisionAbbreviation+
	"&costCodeDescription="+costCodeDescription+
	"&costCodeDescriptionAbbreviation="+costCodeDescriptionAbbreviation;
	var ajaxHandler = "modules-gc-budget-ajax.php";
	var updateMessage = 'Your cost codes import is in progress. ';
	$("#divAjaxLoading").html(updateMessage);
	$("#progressbarMessage").html(updateMessage);
	$('#importButton').attr('disabled','disabled');
	$('#importButton').addClass('btn-disable');
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		async:true,
		success: function(data){
 		  if(data == 0){
				$('.costCodeUploadSteps').empty();
				$("#costCodeTemplate").val('');
				messageAlert('Imported Successfully','successMessage');
				$('#divModalWindow').dialog("close");
				window.location.reload(false);
			}

		},
		error: errorHandler
	});
};
/*Download excel file for reference import default template*/
function downloadCostcodeTemplate(){
	var linktogenerate = 'xlsx/Import Cost Code default template.xlsx';
	document.location = linktogenerate;
};

function mapCostcodeExcel(){
	var costCodeTemplate = $("#costCodeTemplate").val();
	var divisionNumber = $('#division_number').val();
	var costcodeNumber = $('#cost_code').val();
	var divisionHeadingNumber = $('#division_heading_number').val();
	var divisionName = $('#division_name').val();
	var divisionAbbreviation= $('#division_abbreviation').val();
	var costCodeDescription = $('#cost_code_description').val();
	var costCodeDescriptionAbbreviation = $('#cost_code_description_abbreviation').val();

	if(!divisionNumber || !costcodeNumber || !divisionName || !costCodeDescription){
		messageAlert('Please select division number, division name, cost code and cost code description','errorMessage');
		return false;
	}

	var ajaxUrl = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php';
	var selectedFieldsCount = 0;
	$('.importCostCodeDropdown').each(function(){
		 if($(this).val()){
			 selectedFieldsCount++;
		 }
	});

	$.ajax({
		method:'GET',
		url:ajaxUrl,
		data:"method=checkCostCodeExist&filePath="+costCodeTemplate+
		"&divisionNumber="+divisionNumber+
		"&costcodeNumber="+costcodeNumber+
		"&divisionHeadingNumber="+divisionHeadingNumber+
		"&divisionName="+divisionName+
		"&divisionAbbreviation="+divisionAbbreviation+
		"&costCodeDescription="+costCodeDescription+
		"&costCodeDescriptionAbbreviation="+costCodeDescriptionAbbreviation+
		"&selectedFieldsCount="+selectedFieldsCount,
		success:function(html){
			var JsonData = $.parseJSON(html);
			var data = JsonData.data;
			var invalid = JsonData.invalid;
			$("#costCodeTemplateErrorValid").val(invalid);
			$('#costCodeUploadStepThree').empty().html(data);
      		gotoStepThree();
		}
	});
};
function gotoStepThree(){
	var divisionNumber = $('#division_number').val();
	var costcodeNumber = $('#cost_code').val();
	var divisionName = $('#division_name').val();
	var costCodeDescription = $('#cost_code_description').val();

	if(!divisionNumber || !costcodeNumber || !divisionName || !costCodeDescription){
		messageAlert('Please select division number, division name, cost code and cost code description','errorMessage');
		return false;
	}

	$('.costCodeUploadSteps').addClass('displayNone');
	$('#costCodeUploadStepThree').removeClass('displayNone');
	$('.importSteps').removeClass('active');
	$('#importStepThree').addClass('active');
};
function gotoStepTwo(){
	$('.costCodeUploadSteps').addClass('displayNone');
	$('#costCodeUploadStepTwo').removeClass('displayNone');
	$('.importSteps').removeClass('active');
	$('#importStepTwo').addClass('active');
};
function gotoStepOne(){
	$('.costCodeUploadSteps').addClass('displayNone');
	$('#costCodeUploadStepOne').removeClass('displayNone');
	$('.importSteps').removeClass('active');
	$('#importStepOne').addClass('active');
};

function cancelImportCostCode(){
	var filePath = $("#costCodeTemplate").val();
	if(filePath){
		var ajaxQueryString = "method=deleteCostCodeFile&filePath="+filePath+"&deleteFlag=Y";
		var ajaxHandler = "modules-gc-budget-ajax.php";
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(html){
				$("#costCodeTemplate").val('');
				$('#divModalWindow').dialog("close");
			},
			async:true,
			error: errorHandler
		});
	}

};

function Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDivider(element, attributeGroupName, uniqueId){
	try {

		var dividerId = $("#ddl--create-cost_code-record--cost_codes--cost_code_divider_id--" + uniqueId).val();
		// If the options object was not passed as an argument, create it here.
		var options = options || {};

		options.promiseChain = true;
		options.responseDataType = 'json';
		options.includeHtmlContent = 'Y';
		options.htmlRecordType = 'tr';
		options.moduleName = 'Gc_Budget';
		options.scenarioName = 'Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDivider';
		options.successCallback = Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDividerSuccess;

		var ajaxHandlerScript = 'modules-gc-budget-ajax.php?method=updateCostCodeDivider';

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&divider_id=' + encodeURIComponent(dividerId);

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
			success: Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDividerSuccess,
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
};

function Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDividerSuccess(data, textStatus, jqXHR){
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
      		loadManageGcCostCodesDialog(null, true);
			var messageText = 'Cost Code Divider has been successfully updated.';
			messageAlert(messageText, 'successMessage');
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
};
//get selected cost code divider
function getSelectedCostCodeDivider(element){
	try {
		var selectedValue = $("#"+element.id+" option:selected").html();
		var selectedDivider = '-';
		if(selectedValue){
			var divider = selectedValue.match(/\(([^)]+)\)/);
			selectedDivider = divider ? selectedValue.match(/\(([^)]+)\)/)[1] : '';
		}
		$('#cost-code-divider-example').html("(eg : 00"+selectedDivider+"000)");
	} catch (e) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
};


function validateBuyoutForecast(evt) {
	var theEvent = evt || window.event;
  
	// Handle paste
	if (theEvent.type === 'paste') {
		key = event.clipboardData.getData('text/plain');
	} else {
	// Handle key press
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode(key);
	}
	var regex = /[0-9]|\.|\$/;
	if( !regex.test(key) ) {
	  theEvent.returnValue = false;
	  if(theEvent.preventDefault) theEvent.preventDefault();
	}
  }

$('.w9_form_option').on('click', function (e) {
	
	if($(this).val()=='exempt'){
		$(".reason_class").show();
	}else{
		$(".reason_class").hide();
	}

	
	

});