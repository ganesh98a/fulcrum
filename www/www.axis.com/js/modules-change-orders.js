var coTableTrActive;

$(document).ready(function() {

	createUploaders();
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
	ChangeOrders__addCoTableClickHandlers();
	// ChangeOrders__addDataTablesToCOListView();

	$(document).on('change','input#showreject' ,function() {
		var showreject = $('#showreject').prop('checked');
		var currentlySelectedProjectId = $('#currentlySelectedProjectId').val();
		var user_company_id = $('#currentlySelectedProjectUserCompanyId').val();
		$.get('change_orders-ajax.php',{'method':'ChangeOrderContent','showreject':showreject,'currentlySelectedProjectId':currentlySelectedProjectId,'user_company_id':user_company_id},function(data){
			//console.log(data);
			$('.co_content').html(data);
			//$('.co_content').append(data);
		});

	});

});

function ChangeOrders__addCoTableClickHandlers()
{
	// $("#coTable tbody tr").click(function() {
	// 	$("#coTable tbody tr").each(function(i) {
	// 		$(this).removeClass('trActive');
	// 	});
	// 	$(this).addClass('trActive');
	// 	coTableTrActive = this;
	// });

	// if (coTableTrActive) {
	// 	$("#"+coTableTrActive.id).addClass('trActive');
	// }
}

function ChangeOrders__addDataTablesToCOListView()
{
	$("#record_list_container--manage-change_order-record").DataTable({
		'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		'order': [[ 0, 'desc' ]],
		'pageLength': 50,
		'pagingType': 'full_numbers'
	});
}

function ChangeOrders__loadCreateCoDialog(element, options,subOrder)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var change_order_draft_id = '';
		if (element) {
			change_order_draft_id = $(element).val();
			if (change_order_draft_id == '-1') {
				return;
			}
			$(element).val(-1);
		}
		var currentlySelectedProjectId = $('#currentlySelectedProjectId').val();
		var user_company_id = $('#currentlySelectedProjectUserCompanyId').val();
		var currentlyActiveContactId = $('#currentlyActiveContactId').val();
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-change-orders-ajax.php?method=ChangeOrders__loadCreateCoDialog';
		var ajaxQueryString =
			'currentlySelectedProjectId=' + encodeURIComponent(currentlySelectedProjectId) +
			'&user_company_id=' + encodeURIComponent(user_company_id) +
			'&currentlyActiveContactId=' + encodeURIComponent(currentlyActiveContactId) +
			'&change_order_draft_id=' + encodeURIComponent(change_order_draft_id) +
			'&attributeGroupName=create-request-for-information-record' +
			'&subOrder=' +encodeURIComponent(subOrder) +
			'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var arrSuccessCallbacks = [ ChangeOrders__loadCreateCoDialogSuccess ];
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

function ChangeOrders__loadCreateCoDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var htmlContent = json.htmlContent;

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			var dialogWidth = windowWidth * 0.99;
			var dialogHeight = windowHeight * 0.98;

			$("#divCreateCo").html(htmlContent);
			$("#divCreateCo").removeClass('hidden');
			$("#divCreateCo").dialog({
				modal: true,
				title: 'Create A New Change Order — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
					$('.emailGroup').fSelect();
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divCreateCo").addClass('hidden');
					$("#divCreateCo").dialog('destroy');
				},
				buttons: {
					'Save Change Order': function() {
						$(".savebtn").click();
					},
					'Close': function() {
						$("#divCreateCo").dialog('close');
					},
					'Reset': function() {
						$("#formCreateCo")[0].reset();
						$('.emailGroup').fSelect();
						$(".fileatt").empty().append('<li class="placeholder">No Files Attached</li>');
					}
				}
			});

			createUploaders();
			$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });

			 //for cost breakdown
	   
		    //Once remove button is clicked
		    $('.field_wrapper').on('click', '.remove_button', function(e){
		    	e.preventDefault();
		        $(this).closest('.cost_div').remove(); //Remove field html
		        calcSubtotal();
		        var ccIncValue = $('#cocode-inc-value').val();
				ccIncValue = Number(ccIncValue) - 1;
				$('#cocode-inc-value').val(ccIncValue);
		       
		    });

		    $('.cont_wrapper').on('click', '.remove_button', function(e){
		    	e.preventDefault();
		        $(this).closest('.cont_div').remove(); //Remove field html
		        calcSubtotal();
		        var ccIncValue = $('#taxcode-inc-value').val();
				ccIncValue = Number(ccIncValue) - 1;
				$('#taxcode-inc-value').val(ccIncValue);
		       
		    });

		    $('.Number').keyup(function(e)
		    {
		    	var input = this.value;
		    	setTimeout(function(e){
		    	var tmpValue = input.replace(/[^-0-9\.]+/g, '');
				tmpValue = tmpValue.replace(/[-]+/g, '-');
				this.value = tmpValue.replace(/[^0-9]+$/g, '');
			},1000);
			});

			// sortable
			$(".divslides").sortable({
				placeholder: 'divdrag-placeholder',
				axis: "y",
				revert: 150,
				start: function(e, ui){
					
					placeholderHeight = ui.item.outerHeight();
					ui.placeholder.height(placeholderHeight + 15);
					$('<div class="divdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
					
				},
				change: function(event, ui) {
					
					ui.placeholder.stop().height(0).animate({
						height: ui.item.outerHeight() + 15
					}, 300);
					
					placeholderAnimatorHeight = parseInt($(".divdrag-placeholder-animator").attr("data-height"));
					
					$(".divdrag-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
						height: 0
					}, 300, function() {
						$(this).remove();
						placeholderHeight = ui.item.outerHeight();
						$('<div class="divdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
					});
					
				},
				stop: function(e, ui) {
					
					$(".divdrag-placeholder-animator").remove();
					
				},
			});

		// tag sortable
		$(".contslides").sortable({
			placeholder: 'contdrag-placeholder',
			axis: "y",
			revert: 150,
			start: function(e, ui){
				
				placeholderHeight = ui.item.outerHeight();
				ui.placeholder.height(placeholderHeight + 15);
				$('<div class="contdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
				
			},
			change: function(event, ui) {
				
				ui.placeholder.stop().height(0).animate({
					height: ui.item.outerHeight() + 15
				}, 300);
				
				placeholderAnimatorHeight = parseInt($(".contdrag-placeholder-animator").attr("data-height"));
				
				$(".contdrag-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
					height: 0
				}, 300, function() {
					$(this).remove();
					placeholderHeight = ui.item.outerHeight();
					$('<div class="contdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
				});
				
			},
			stop: function(e, ui) {
				
				$(".contdrag-placeholder-animator").remove();
				
			},
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
//To add  breakdown
function addbreakdown()
{	
		var ccoptionList = $('#cost-code-options-list').val();
		var ccIncValue = $('#cocode-inc-value').val();
		ccIncValue = Number(ccIncValue) + 1;
		$('#cocode-inc-value').val(ccIncValue);
		//New input field html 
		
    	var fieldHTML ="<div class='cost_div trow'><div class='tcol' style='width: 0.5%;'><img src='/images/sortbars.png' style='cursor: pointer;' rel='tooltip' title='' data-original-title='Drag bars to change sort order'></div><div class='tcol' style='width: 25%;'><input class='required' type='hidden' name='costcode[]' id='costcode"+ccIncValue+"' value=''/><select class='costcode-select"+ccIncValue+" costcode-select' onchange='updateCostCodeValue(this.value, "+ccIncValue+")'>"+ccoptionList+"</select></div><div class='tcol' style='width: 22%;'><input type='text' name='descript[]' id='descript[]' class='required' value=''/></div><div class='tcol'><input type='text' class='' name='sub[]' id='sub[]' value=''/></div><div class='tcol'><input type='text' class='' name='ref[]' id='ref[]' value=''/></div><div class='tcol'><input type='text' class='Number required' name='cost[]' id='cost[]' value='' onkeyup='setTimeout(calcSubtotal(),2000)'/></div><div class='tcol'><a href='javascript:void(0);' class='remove_button entypo-minus-circled ' title='Remove field' ></a></div></div>";
    	$(".field_wrapper").append(fieldHTML); //Add field html
    	$('.Number').keyup(function(e)
		    {
		    	setTimeout(function(){
		    	var input = this.value;
		    	var tmpValue = input.replace(/[^-0-9\.]+/g, '');
				tmpValue = tmpValue.replace(/[-]+/g, '-');
				this.value = tmpValue.replace(/[^0-9]+$/g, '');
			},1000);
		    	
			});
		
}

// to update the costcode value in breakdown
function updateCostCodeValue(selectedValue, incValue) {
	$('#costcode'+incValue).val(selectedValue);
	$('.costcode-select'+incValue).removeClass('redBorderThick');
}

// to update the tax cost code value in breakdown
function updateTaxCostCodeValue(selectedValue, incValue) {
	$('#taxcode'+incValue).val(selectedValue);
	$('.taxcode-select'+incValue).removeClass('redBorderThick');
}

//To add description breakdown
function addcostbreakdown()
{	
		var ccoptionList = $('#tax-code-options-list').val();
		var ccIncValue = $('#taxcode-inc-value').val();
		ccIncValue = Number(ccIncValue) + 1;
		$('#taxcode-inc-value').val(ccIncValue);
		console.log(ccIncValue,'ccIncValue')
		//New input field html 
    	var fieldHTML ="<div class='cont_div trow contdrag'><div class='tcol' style='width: 0.5%;'><img src='/images/sortbars.png' style='cursor: pointer;' rel='tooltip' title='' data-original-title='Drag bars to change sort order'></div><div class='tcol' style='width: 14%;'><input class='required' type='hidden' name='taxcode[]' id='taxcode"+ccIncValue+"' value=''/><select class='taxcode-select"+ccIncValue+" taxcode-select ' onchange='updateTaxCostCodeValue(this.value, "+ccIncValue+")'>"+ccoptionList+"</select></div><div class='tcol' style='width: 11%;'><input type='text' class='required' name='content[]' id='content"+ccIncValue+"' class='' value=''/></div><div class='tcol' style='width: 1%;'>%</div><div class='tcol' style='width: 9%;'> <input type='text' class='Number' name='percentage[]' id='percentage[]' value='' onkeyup='calcSubtotal()'/></div> <div class='tcol' style='width: 8%; text-align: center;'><b>OR</b></div><div class='tcol' style='width: 1%;'>$</div><div class='tcol' style='width: 9%;'> <input type='text' class='Number' name='contotal[]' id='contotal[]' value='' onkeyup=setTimeout(&apos;calcSubtotal()&apos;,2000)></div><div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'><a href='javascript:void(0);' class='remove_button entypo-minus-circled ' title='Remove field' ></a></div></div>";
    	$(".cont_wrapper").append(fieldHTML); //Add field html
    	$('.Number').keyup(function(e)
		    {
		    	setTimeout(function(){
		    	var input = this.value;
		    	var tmpValue = input.replace(/[^-0-9\.]+/g, '');
				tmpValue = tmpValue.replace(/[-]+/g, '-');
				this.value = tmpValue.replace(/[^0-9]+$/g, '');
			},1000);
		    	
			});
		
}

function calcSubtotal()
{
	setTimeout(function(){

	var stotal =0;
	$("input[name^='cost']").each(function (index, elem) {
		
		if($(this).attr('id')=="cost[]")
		{
			var val=parseFloat($(this).val());
		}
		if(!isNaN(val))
		{
			stotal += val;
		}
		
	});
	$("#subtotal").val(stotal.toFixed(2));
	$("#subhidden").val(stotal.toFixed(2));

	var k=0;
	var genperval=0;

	$("input[name^='percentage']").each(function () {
		var perval=parseFloat($(this).val());
		if(!isNaN(perval)  && perval!='')
		{
			genperval = stotal*(perval/100);
			genperval= genperval.toFixed(2);
			$('input[name="contotal[]"]').eq(k).val(genperval);
			
		}
		k++;
	});
	var genpertotal=0;
	$("input[name^='contotal']").each(function () {
		var totval=parseFloat($(this).val());
		if(!isNaN(totval))
		{
			genpertotal += totval;
		}
		
	});

	//To generate the grand Total
	var grandTotal=stotal+genpertotal;
	grandTotal=grandTotal.toFixed(2); 
	$('#total').val(grandTotal);
	$('#maintotal').val(grandTotal);
	var formattedAmount = grandTotal;
	$('.inputDollarAmount ').val(formattedAmount);
	},1000);

}

// To show the document upload is a popup
function showFileDropdown(changeOrder){
	$('.holdChangeOrder').removeClass("show_cont_change_order");
	document.getElementById("fileLinkShow_"+changeOrder).classList.toggle("show_cont_change_order");
	window.onclick = function(event) {
    	if (!event.target.matches('.changeOrderbtn_'+changeOrder)) {

    		var dropdowns = document.getElementsByClassName("dropdown-content-change-order");
    		var i;
    		for (i = 0; i < dropdowns.length; i++) {
    			var openDropdown = dropdowns[i];
    			if (openDropdown.classList.contains('show_cont_change_order')) {
    				openDropdown.classList.remove('show_cont_change_order');
    			}
    		}
    	}
    }
}





//To edit the change order
function ChangeOrders__EditCoDialog(changeOrder,element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var change_order_draft_id = '';
		if (element) {
			change_order_draft_id = $(element).val();
			if (change_order_draft_id == '-1') {
				return;
			}
			$(element).val(-1);
		}
		var project_id_element_id = 'currentlySelectedProjectId';
		if ($("#" + project_id_element_id).length) {
			var project_id = $("#" + project_id_element_id).val();
			project_id = parseInputToInt(project_id);
		}
		var user_company_element_id = 'currentlySelectedProjectUserCompanyId';
		if ($("#" + user_company_element_id).length) {
			var user_company_id = $("#" + user_company_element_id).val();
			user_company_id = parseInputToInt(user_company_id);
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-change-orders-ajax.php?method=ChangeOrders__editCoDialog';
		var ajaxQueryString =
			'project_id='+ encodeURIComponent(project_id)+
			'&user_company_id=' + encodeURIComponent(user_company_id) +
			'&change_order_draft_id=' + encodeURIComponent(change_order_draft_id) +
			'&attributeGroupName=create-request-for-information-record' +
			'&changeOrder=' +encodeURIComponent(changeOrder) +
			'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var arrSuccessCallbacks = [ ChangeOrders__EditCoDialogSuccess ];
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

function ChangeOrders__EditCoDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var htmlContent = json.htmlContent;

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			var dialogWidth = windowWidth * 0.99;
			var dialogHeight = windowHeight * 0.98;

			$("#divCreateCo").html(htmlContent);
			$("#divCreateCo").removeClass('hidden');
			$("#divCreateCo").dialog({
				modal: true,
				title: 'Edit Change Order — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
					$('.emailGroup').fSelect();
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divCreateCo").addClass('hidden');
					$("#divCreateCo").dialog('destroy');
				},
				buttons: {
					'View CO PDF': function() {
						$(".viewpdf").click();
					},
					'Save Change Order': function() {
						$(".editsavebtn").click();
					},
					'Close': function() {
						$("#divCreateCo").dialog('close');
					},
					'Reset': function() {
						$("#formCreateCo")[0].reset();
						$('.emailGroup').fSelect();
					}
				}
			});

			createUploaders();
			$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });

			 //for cost breakdown
	   
		    //Once remove button is clicked
		    $('.field_wrapper').on('click', '.remove_button', function(e){
		    	e.preventDefault();
		        $(this).closest('.cost_div').remove(); //Remove field html
		        calcSubtotal();
		        var ccIncValue = $('#cocode-inc-value').val();
				ccIncValue = Number(ccIncValue) - 1;
				$('#cocode-inc-value').val(ccIncValue);
		       
		    });
		     $('.cont_wrapper').on('click', '.remove_button', function(e){
		    	e.preventDefault();
		        $(this).closest('.cont_div').remove(); //Remove field html
		        calcSubtotal();
		        var ccIncValue = $('#taxcode-inc-value').val();
				ccIncValue = Number(ccIncValue) - 1;
				$('#taxcode-inc-value').val(ccIncValue);
		       
		    });

		    $('.Number').keyup(function(e)
		    {
		    	setTimeout(function(){
		    	var input = this.value;
		    	var tmpValue = input.replace(/[^-0-9\.]+/g, '');
				tmpValue = tmpValue.replace(/[-]+/g, '-');
				this.value = tmpValue.replace(/[^0-9]+$/g, '');
			},1000);
			});
			$(".bs-tooltip").tooltip();
			// sortable
			$(".divslides").sortable({
				placeholder: 'divdrag-placeholder',
				axis: "y",
				revert: 150,
				start: function(e, ui){
					
					placeholderHeight = ui.item.outerHeight();
					ui.placeholder.height(placeholderHeight + 15);
					$('<div class="divdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
					
				},
				change: function(event, ui) {
					
					ui.placeholder.stop().height(0).animate({
						height: ui.item.outerHeight() + 15
					}, 300);
					
					placeholderAnimatorHeight = parseInt($(".divdrag-placeholder-animator").attr("data-height"));
					
					$(".divdrag-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
						height: 0
					}, 300, function() {
						$(this).remove();
						placeholderHeight = ui.item.outerHeight();
						$('<div class="divdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
					});
					
				},
				stop: function(e, ui) {
					
					$(".divdrag-placeholder-animator").remove();
					
				},
			});

		// tag sortable
		$(".contslides").sortable({
			placeholder: 'contdrag-placeholder',
			axis: "y",
			revert: 150,
			start: function(e, ui){
				
				placeholderHeight = ui.item.outerHeight();
				ui.placeholder.height(placeholderHeight + 15);
				$('<div class="contdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
				
			},
			change: function(event, ui) {
				
				ui.placeholder.stop().height(0).animate({
					height: ui.item.outerHeight() + 15
				}, 300);
				
				placeholderAnimatorHeight = parseInt($(".contdrag-placeholder-animator").attr("data-height"));
				
				$(".contdrag-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
					height: 0
				}, 300, function() {
					$(this).remove();
					placeholderHeight = ui.item.outerHeight();
					$('<div class="contdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
				});
				
			},
			stop: function(e, ui) {
				
				$(".contdrag-placeholder-animator").remove();
				
			},
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
//End to edit the change orders

function loadAllCORecords()
{
	
		var project_id=$("#currentlySelectedProjectId").val();
		var user_company_id=$("#currentlySelectedProjectUserCompanyId").val();
		var showreject = $('#showreject').prop('checked');
		showSpinner();
		var ajaxUrl = window.ajaxUrlPrefix + 'change_orders-ajax.php';
		$.ajax({
		method:'GET',
		url:ajaxUrl,
		data:'method=loadAllCORecords&project_id='+project_id+'&showreject='+showreject+'&user_company_id='+user_company_id,
		success:function(data)
		{
				$('#coTable').empty().append(data);
				hideSpinner();
                $('[data-toggle="tooltip"]').tooltip(); 
		}

	});
}

function ChangeOrders__loadChangeOrder(change_order_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = true;
		options.successCallback = ChangeOrders__loadChangeOrderSuccess;
		options.adHocQueryParameters = '&change_order_id=' + encodeURIComponent(change_order_id);

		var recordContainerElementId = '';
		var attributeGroupName = 'manage-change_order-record';
		var uniqueId = change_order_id;

		loadChangeOrder(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
 * This may not be used if direct element load is used instead.
 */
function ChangeOrders__loadChangeOrderSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var change_order_id = json.change_order_id;
			var htmlContent = json.htmlContent;

			UrlVars.set('change_order_id', change_order_id);

			$("#coDetails").html(htmlContent);
			var len = $("#tableRequestsForInformation tbody").children().length;
			if (len) {
				$("#tableRequestsForInformation").removeClass('hidden');
			}
			createUploaders();

			$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
new ajax call modal dialog function for CO
It will call the new success function to call modal dialog upon success
**/
function ChangeOrders__loadChangeOrderModalDialog(change_order_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = true;
		options.successCallback = ChangeOrders__loadChangeOrderModalDialogSuccess;
		options.adHocQueryParameters = '&change_order_id=' + encodeURIComponent(change_order_id);

		var recordContainerElementId = '';
		var attributeGroupName = 'manage-change_order-record';
		var uniqueId = change_order_id;

		loadChangeOrder(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
new ajax call modal dialog sucess function for CO
upon success: modal dialog for CO will be displayed
**/
function ChangeOrders__loadChangeOrderModalDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var change_order_id = json.change_order_id;
			var htmlContent = json.htmlContent;
			var modalTitle = json.formattedAttributeGroupName + ' -- Details/Edit';

			UrlVars.set('change_order_id', change_order_id);

			$("#coDetails").html(htmlContent);
			if($("#coDetails").hasClass('hidden')) {
				$("#coDetails").removeClass('hidden');
			}

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			var dialogWidth = windowWidth * 0.99;
			var dialogHeight = windowHeight * 0.98;

			createUploaders();
			//$("#coDetails").removeClass('hidden');
			$("#coDetails").dialog({
				height: dialogHeight,
				width: dialogWidth,
				modal: true,
				title: modalTitle,
				open: function() {
					$("body").addClass('noscroll');
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#coDetails").dialog('destroy');
					$("#coDetails").html('');
					$("#coDetails").addClass('hidden');
					loadAllCORecords();
		        },
		        buttons: {
		        	'Close': function() {
		        		$(this).dialog('close');
						loadAllCORecords();

		        	}
		        }
			});

			var len = $("#tableRequestsForInformation tbody").children().length;
			if (len) {
				$("#tableRequestsForInformation").removeClass('hidden');
			}
			//createUploaders();

			$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__manualSaveButtonClick(attributeGroupName, uniqueId)
{

	successMessage = 'Change Order Successfully saved.';
	messageAlert(successMessage, 'successMessage');

	$("body").removeClass('noscroll');
	$("#coDetails").dialog('destroy');
	$("#coDetails").html('');
	$("#coDetails").addClass('hidden');

	//closeCreateCoDialog();
	//showSpinner();
	//hideSpinner();

}

function ChangeOrders__createCoResponseViaPromiseChain(attributeGroupName, uniqueId)
{
	try {

		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json' };

		showSpinner();
		var promise1 = createChangeOrderResponse(attributeGroupName, uniqueId, options);

		promise1.fail(function() {
			// Debug
			//alert('promise1.fail');

			hideSpinner();
		});

		// promise2 is instantiated as a promise object via .then
		// this occurs before the promise1 ajax calls even fires since everything is asynchronous
		var promise2 = promise1.then(function(json) {
			var change_order_id = json.change_order_id;
			$("#active_change_order_id").val(change_order_id);
			// Debug
			//alert('promise1.then');

			// Inner Promise Only:
			// Any returned value other than a rejected promise will continue with subsequent .then calls
			// .fail will only be invoked if a rejected promise is returned
			var innerPromise = ChangeOrders__saveCoAsPdfHelper(options);
			return innerPromise;
		});

		var promise3 = promise2.then(function() {
			var change_order_id = $("#active_change_order_id").val();
			var innerPromise = ChangeOrders__loadChangeOrder(change_order_id, options);
			return innerPromise;
		});

		// Always executes via existence of promise2 by .then returning a promise or inner function returning a promise that replaces the .then promise instance
		promise3.always(function() {
			// Debug
			//alert('promise2.always');
			hideSpinner();
		});

	} catch (error) {

		hideSpinner();

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__createCoResponseAndSendEmailViaPromiseChain(attributeGroupName, uniqueId)
{
	try {

		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json' };

		showSpinner();
		var promise1 = createChangeOrderResponse(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function(json) {
			var change_order_id = json.change_order_id;
			$("#active_change_order_id").val(change_order_id);

			var innerPromise = ChangeOrders__saveCoAsPdfHelper(options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			var innerPromise = ChangeOrders__createChangeOrderNotificationHelper(options);
			return innerPromise;
		});
		var promise4 = promise3.then(function() {
			var innerPromise = ChangeOrders__sendCoEmail(options);
			return innerPromise;
		});
		promise4.always(function() {
			hideSpinner();
		});

		// This function is outside of the rest of the promise chain. The loadChangeOrder
		// operation is only dependent on the success of promise2. It isn't related to promise3 or promise4.
		promise2.then(function() {
			var change_order_id = $("#active_change_order_id").val();
			ChangeOrders__loadChangeOrder(change_order_id, options);
		});

	} catch (error) {

		hideSpinner();

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

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

function ChangeOrders__coDraftAttachmentUploaded(arrFileManagerFiles, containerElementId)
{
	try {

		var coDummyId = $("#create-change_order-record--change_orders--dummy_id").val();

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];
			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var fileUrl                = fileManagerFile.fileUrl;

			var csvCoFileManagerFileIds = $("#create-change_order_attachment-record--change_order_attachments--csvCoFileManagerFileIds--" + coDummyId).val();
			var arrCoFileManagerFileIds = csvCoFileManagerFileIds.split(',');
			arrCoFileManagerFileIds.push(file_manager_file_id);
			csvCoFileManagerFileIds = arrCoFileManagerFileIds.join(',');
			$("#create-change_order_attachment-record--change_order_attachments--csvCoFileManagerFileIds--" + coDummyId).val(csvCoFileManagerFileIds);

			// Remove the placeholder li.
			$("#" + containerElementId).children().each(function(i) {
				if ($(this).hasClass('placeholder')) {
					$(this).remove();
				}
			});

			var elementId = 'record_container--manage-file_manager_file-record--file_manager_files--' + file_manager_file_id;
			var htmlRecord = '' +
			'<li id="' + elementId + '">' +
				'<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order"><a href="javascript:deleteFileManagerFile(\'' + elementId + '\', \'manage-file_manager_file-record\', \'' + file_manager_file_id + '\');">X</a>&nbsp;' +
				'<a href="' + fileUrl + '" target="_blank">' + virtual_file_name + '</a>' +
			'</li>';

			// Append the file manager file element.
			$("#" + containerElementId).append(htmlRecord);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

// @todo Update this to support a list of files
function ChangeOrders__postProcessCoAttachmentsViaPromiseChain(arrFileManagerFiles, containerElementId)
{
	try {

		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json' };
		var attributeGroupName = 'create-change_order_attachment-record';

		if (containerElementId) {
			var ajaxQueryString = '&containerElementId=' + encodeURIComponent(containerElementId);
		} else {
			var ajaxQueryString = '';
		}

		// These are constant for the files list, so place outside the for loop
		var change_order_id = $("#change_order_id").val();
		var coDummyId = $("#create-change_order-record--change_orders--dummy_id").val();
		var co_attachment_source_contact_id = $("#create-change_order-record--change_orders--co_attachment_source_contact_id--" + coDummyId).val();

		showSpinner();
		var arrPromises = [];
		var arrFileManagerFileIds = [];
		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var fileUrl                = fileManagerFile.fileUrl;

			/*
			var dummyId = generateDummyElementId();
			var recordContainerElementId = 'record_container--create-change_order_attachment-record--change_order_attachments--sort_order--' + dummyId;
			var input1 = '<input id="create-change_order_attachment-record--change_order_attachments--change_order_id--' + dummyId + '" type="hidden" value="' + change_order_id + '">';
			var input2 = '<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_file_manager_file_id--' + dummyId + '" type="hidden" value="' + file_manager_file_id + '">';
			var input3 = '<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_source_contact_id--' + dummyId + '" type="hidden" value="' + co_attachment_source_contact_id + '">';
			var li = '<li id="' + recordContainerElementId + '" class="hidden">' + input1 + input2 + input3 + '</li>';
			$("#" + containerElementId).append(li);
			*/

			arrFileManagerFileIds.push(file_manager_file_id);

			/*
			var csvCoFileManagerFileIdsElementId = attributeGroupName + '--change_order_attachments--csvCoFileManagerFileIds--' + dummyId;
			if ($("#" + csvCoFileManagerFileIdsElementId).length) {
				var csvCoFileManagerFileIds = $("#" + csvCoFileManagerFileIdsElementId).val();
				if (csvCoFileManagerFileIds.length == 0) {
					// No attachments to create.
					return;
				}
				ajaxQueryString = ajaxQueryString + '&csvCoFileManagerFileIds=' + encodeURIComponent(csvCoFileManagerFileIds);
			}
			*/
		}
		var csvCoFileManagerFileIds = arrFileManagerFileIds.join(',');
		if (csvCoFileManagerFileIds.length == 0) {
			// No attachments to create.
			return;
		} else {
			ajaxQueryString = ajaxQueryString + '&csvCoFileManagerFileIds=' + encodeURIComponent(csvCoFileManagerFileIds);
		}


		var dummyId = generateDummyElementId();
		var recordContainerElementId = 'record_container--create-change_order_attachment-record--change_order_attachments--sort_order--' + dummyId;

		var input1 = '<input id="create-change_order_attachment-record--change_order_attachments--change_order_id--' + dummyId + '" type="hidden" value="' + change_order_id + '">';
		// We are building a files list in case the uploader supports multiple concurrent file uploads in the future
		var input2 = ''; //'<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_file_manager_file_id--' + dummyId + '" type="hidden" value="' + file_manager_file_id + '">';
		var input3 = '<input id="create-change_order_attachment-record--change_order_attachments--co_attachment_source_contact_id--' + dummyId + '" type="hidden" value="' + co_attachment_source_contact_id + '">';
		var li = '<li id="' + recordContainerElementId + '" class="hidden">' + input1 + input2 + input3 + '</li>';

		$("#" + containerElementId).append(li);


		options.adHocQueryParameters = ajaxQueryString;
		//options.successCallback = ChangeOrders__createChangeOrderAttachmentSuccess;
		var promise = createChangeOrderAttachment('create-change_order_attachment-record', dummyId, options);
		arrPromises.push(promise);

		var promise1 = $.when.apply($, arrPromises);
		var promise2 = promise1.then(function() {
			var innerPromise = ChangeOrders__saveCoAsPdf(change_order_id, options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			var innerPromise = ChangeOrders__loadChangeOrder(change_order_id, options);
			return innerPromise;
		});
		promise3.always(function() {
			hideSpinner();
		});

	} catch(error) {

		hideSpinner();
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

// This function may not be in active use.
function ChangeOrders__createChangeOrderAttachmentSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			// @todo Update this to support a list of files
			var htmlRecord = json.htmlRecord;
			var containerElementId = json.containerElementId;

			$("#" + containerElementId).append(htmlRecord);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__createCoDraftViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = 'Y';

 		showSpinner();

		// Update case
		if (!optionsObjectIsEmpty && (options.crudOperation == 'update')) {

			var crudOperation = 'update';
			var change_order_draft_id = options.change_order_draft_id;
			//options.htmlRecordMetaAttributes
			options.adHocQueryParameters = '&uniqueId=' + change_order_draft_id;
			options.htmlRecordAttributeOptions = { attributeSubgroupName: 'change_orders' };
			var promise1 = updateAllChangeOrderDraftAttributes(attributeGroupName, uniqueId, options);

		} else {

			// Create case
			// change_order_drafts is a clone of change_orders
			var crudOperation = 'create';
			options.htmlRecordAttributeOptions = { attributeSubgroupName: 'change_orders' };
			var promise1 = createChangeOrderDraft(attributeGroupName, uniqueId, options);

		}

		// Recreate options
		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json', skipDefaultSuccessCallback: 'Y' };

		// promise1 gets two .then success callbacks. The first one is for doing custom DOM manipulations.
		// The second one is for the ajax call that needs to be made in sequence. I separated them
		// into different callbacks because they each perform individual, disjoint actions.
		promise1.then(function(json) {
			try {

				var errorNumber = json.errorNumber;
				// 0 is okay, 2 is data already saved on server
				if ((errorNumber == 0) || (errorNumber == 2)) {
					var uniqueId = json.uniqueId;
					var htmlRecord = json.htmlRecord;
					var buttonDeleteCoDraft = json.buttonDeleteCoDraft;

					if (crudOperation == 'create') {
						// Add the Draft to DDL
						var ddlCoDrafts = $("#ddl--manage-change_order_draft-record--change_order_drafts--change_order_draft_id--dummy");
						ddlCoDrafts.append(htmlRecord);
						$("#spanDeleteCoDraft").html(buttonDeleteCoDraft);
					}

					$("#formCreateCo .redBorder").removeClass('redBorder');
					$("#active_change_order_draft_id").val(uniqueId);

					successMessage = 'CO Draft Successfully saved.';
					messageAlert(successMessage, 'successMessage');

				} else if (errorNumber == 1) {
					// Error
				}

			} catch (error) {

				if (window.showJSExceptions) {
					var errorMessage = error.message;
					alert('Exception Thrown: ' + errorMessage);
					return;
				}

			}
		});
		var promise2 = promise1.then(function() {
			var innerPromise = ChangeOrders__createChangeOrderDraftAttachmentHelper(options);
			return innerPromise;
		});
		promise2.then(function() {
			// Close the modal dialog
			closeCreateCoDialog();
		})
		promise2.fail(function() {
		});
		promise2.always(function() {
			hideSpinner();
		});

	} catch (error) {

		hideSpinner();
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__createChangeOrderDraftAttachmentHelper(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		// change_order_draft_attachments is a clone of change_order_attachments
		options.htmlRecordAttributeOptions = { attributeSubgroupName: 'change_order_attachments' };

		var attributeGroupName = 'create-change_order_attachment-record';
		var active_change_order_draft_id = $("#active_change_order_draft_id").val();
		var coDummyId = $("#create-change_order-record--change_orders--dummy_id").val();
		$("#create-change_order_attachment-record--change_order_attachments--change_order_draft_id--" + coDummyId).val(active_change_order_draft_id);

		ajaxQueryString = '';
		var uniqueId = coDummyId;
		var csvCoFileManagerFileIdsElementId = attributeGroupName + '--change_order_attachments--csvCoFileManagerFileIds--' + uniqueId;
		if ($("#" + csvCoFileManagerFileIdsElementId).length) {
			var csvCoFileManagerFileIds = $("#" + csvCoFileManagerFileIdsElementId).val();
			if (csvCoFileManagerFileIds.length == 0) {
				// No attachments to create.
				return;
			}
			ajaxQueryString = ajaxQueryString + '&csvCoFileManagerFileIds=' + encodeURIComponent(csvCoFileManagerFileIds);
		}
		options.adHocQueryParameters = ajaxQueryString;

		var promise = createChangeOrderDraftAttachment(attributeGroupName, coDummyId, options);

		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__createCoViaPromiseChain(attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		//options.successCallback = ChangeOrders__createChangeOrderSuccess;

 		showSpinner();
		var promise1 = ChangeOrders__createChangeOrder(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function() {
			options.successCallback = '';
			var innerPromise = ChangeOrders__createChangeOrderAttachmentHelper(options);
			return innerPromise;
		})
		var promise3 = promise2.then(function() {
			var innerPromise = ChangeOrders__saveCoAsPdfHelper(options);
			return innerPromise;
		})
		var promise4 = promise3.then(function() {
			var innerPromise = ChangeOrders__deleteChangeOrderDraftHelper(options);
			options.successCallback = '';
			return innerPromise;
		})
		var promise5 = promise4.then(function() {
			closeCreateCoDialog();
		})
		var promise6 = promise5.then(function() {
			loadAllCORecords();
		})
		promise7.fail(function() {
		})
		promise7.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

//To edit the change order
function ChangeOrders__EditCoViaPromiseChain(attributeGroupName, uniqueId,change_order_id)
{
	showSpinner();
	try {
		
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		//options.successCallback = ChangeOrders__createChangeOrderSuccess;

		var approved_date = $("#"+attributeGroupName+'--change_orders--co_approved_date--'+uniqueId).val();

		$("#active_change_order_id").val(change_order_id);

		var promise1 = ChangeOrders__editChangeOrder(attributeGroupName, uniqueId, options,change_order_id);
		var promise2 = promise1.then(function() {
			options.successCallback = '';
			var innerPromise = ChangeOrders__createChangeOrderAttachmentHelper(options);
			return innerPromise;
		})
		var promise3 = promise2.then(function() {
			updateChangeOrderInDraws(change_order_id,approved_date);//update CO in draws
			var innerPromise = ChangeOrders__saveCoAsPdfHelper(options);
			return innerPromise;
		})
		// var promise3 = promise2.then(function() {
		// 	var innerPromise = ChangeOrders__deleteChangeOrderDraftHelper(options);
		// 	options.successCallback = '';
		// 	return innerPromise;
		// })
		var promise4 = promise3.then(function() {
			closeCreateCoDialog();
		})
		var promise5 = promise4.then(function() {
			loadAllCORecords();
		})
		promise6.fail(function() {
		})
		promise6.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}


function ChangeOrders__createCoAndSendEmailViaPromiseChain(attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		//options.successCallback = ChangeOrders__createChangeOrderSuccess;

		showSpinner();
		var promise1 = ChangeOrders__createChangeOrder(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function() {
			options.successCallback = '';
			var innerPromise = ChangeOrders__createChangeOrderAttachmentHelper(options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			var innerPromise = ChangeOrders__saveCoAsPdfHelper(options);
			return innerPromise;
		});
		var promise4 = promise3.then(function() {
			var innerPromise = ChangeOrders__createChangeOrderNotificationHelper(options);
			return innerPromise;
		});
		var promise5 = promise4.then(function() {
			var innerPromise = ChangeOrders__createChangeOrderRecipientHelper(options);
			return innerPromise;
		});
		var promise6 = promise5.then(function() {
			var innerPromise = ChangeOrders__sendCoEmail(options);
			return innerPromise;
		});
		var promise7 = promise6.then(function() {
			var innerPromise = ChangeOrders__deleteChangeOrderDraftHelper(options);
			options.successCallback = '';
			return innerPromise;
		});
		var promise8 = promise7.then(function() {
			closeCreateCoDialog();
		});
		promise8.fail(function() {
			// Debug
			//alert('promise8.fail');
		});
		promise8.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function ChangeOrders__createChangeOrderAttachmentHelper(options)
{
	try {

		var active_change_order_id = $("#active_change_order_id").val();
		var coDummyId = $("#create-change_order-record--change_orders--dummy_id").val();
		$("#create-change_order_attachment-record--change_order_attachments--change_order_id--" + coDummyId).val(active_change_order_id);
		var ajaxQueryString = '';

		// Build the URL with a files list
		var arrFileManagerFileIds = [];
		$("#container--change_order_attachments--create-change_order-record li").each(function() {
			var elementId = this.id;
			var arrParts = elementId.split('--');
			var attributeGroupName = arrParts[0];
			var attributeSubgroupName = arrParts[1];
			var attributeName = arrParts[2];
			var uniqueId = arrParts[3];

			var file_manager_file_id = uniqueId;
			arrFileManagerFileIds.push(file_manager_file_id);
		});
		var csvCoFileManagerFileIds = arrFileManagerFileIds.join(',');
		//var csvCoFileManagerFileIds = $("#create-change_order_attachment-record--change_order_attachments--csvCoFileManagerFileIds--" + coDummyId).val();
		if (csvCoFileManagerFileIds.length == 0) {
			// No attachments to create.
			var promise = getDummyResolvedPromise();
			return promise;
		} else {
			ajaxQueryString = ajaxQueryString + '&csvCoFileManagerFileIds=' + encodeURIComponent(csvCoFileManagerFileIds);
		}
		options.adHocQueryParameters = ajaxQueryString;

		var promise = createChangeOrderAttachment('create-change_order_attachment-record', coDummyId, options);

		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__saveCoAsPdfHelper(options)
{
	var active_change_order_id = $("#active_change_order_id").val();
	var promise = ChangeOrders__saveCoAsPdf(active_change_order_id, options);

	return promise;
}

function ChangeOrders__createChangeOrderNotificationHelper(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var active_change_order_id = $("#active_change_order_id").val();
		var coDummyId = $("#create-change_order-record--change_orders--dummy_id").val();
		$("#create-change_order_notification-record--change_order_notifications--change_order_id--" + coDummyId).val(active_change_order_id);

		var promise1 = createChangeOrderNotification('create-change_order_notification-record', coDummyId, options);

		promise1.then(function(json) {
			var uniqueId = json.uniqueId;
			$("#active_change_order_notification_id").val(uniqueId);
		});

		return promise1;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__createChangeOrderRecipientHelper(options)
{
	var options = options || {};
	var promiseChain = options.promiseChain;

	var active_change_order_notification_id = $("#active_change_order_notification_id").val();
	var coDummyId = $("#create-change_order-record--change_orders--dummy_id").val();
	$("#create-change_order_recipient-record--change_order_recipients--change_order_notification_id--" + coDummyId).val(active_change_order_notification_id);
	var attributeGroupName = 'create-change_order_recipient-record';
	var smtp_recipient_header_type_element_id = attributeGroupName + '--change_order_recipients--smtp_recipient_header_type--' + coDummyId;
	var arrPromises = [];

	// Cc recipients.
	$("#" + smtp_recipient_header_type_element_id).val('Cc');
	var arrCoRecipientIds = [];
	$("#record_container--change_order_recipients--Cc li input").each(function(i) {
		arrCoRecipientIds.push($(this).val());
	});
	if (arrCoRecipientIds.length) {
		var csvCoRecipientIds = arrCoRecipientIds.join(',');
		options.adHocQueryParameters = '&csvCoRecipientIds=' + encodeURIComponent(csvCoRecipientIds);
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createChangeOrderRecipient(attributeGroupName, coDummyId, options);
		arrPromises.push(promise);
	}

	// Bcc recipients.
	$("#" + smtp_recipient_header_type_element_id).val('Bcc');
	arrCoRecipientIds = [];
	$("#record_container--change_order_recipients--Bcc li input").each(function(i) {
		arrCoRecipientIds.push($(this).val());
	});
	if (arrCoRecipientIds.length) {
		var csvCoRecipientIds = arrCoRecipientIds.join(',');
		options.adHocQueryParameters = '&csvCoRecipientIds=' + encodeURIComponent(csvCoRecipientIds);
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createChangeOrderRecipient(attributeGroupName, coDummyId, options);
		arrPromises.push(promise);
	}

	options.adHocQueryParameters = '';

	if (promiseChain) {
		var promise = $.when.apply($, arrPromises);
		return promise.then(function() {
			var promise = getDummyResolvedPromise();
			return promise;
		});
	}

}

function ChangeOrders__sendCoEmail(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		/*
		var valid = validateForm(attributeGroupName, uniqueId);
		if (!valid) {
			if (promiseChain) {
				var promise = getDummyRejectedPromise();
				return promise;
			} else {
				return;
			}
		}
		*/

		var active_change_order_notification_id = $("#active_change_order_notification_id").val();
		var emailBody = $("#textareaEmailBody").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-change-orders-ajax.php?method=ChangeOrders__sendCoEmail';
		var ajaxQueryString =
			'change_order_notification_id=' + encodeURIComponent(active_change_order_notification_id) +
			'&emailBody=' + encodeURIComponent(emailBody);
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
			success: ChangeOrders__sendCoEmailSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch (error) {
		var responseText = 'An error occurred while sending the email.';
		var promise = getDummyRejectedPromise(responseText);
		return promise;
	}
}

function ChangeOrders__sendCoEmailSuccess(data, textStatus, jqXHR)
{
	try {

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(data);
			if (continueDebug != true) {
				return;
			}
		}

		/*
		// @todo Make this section work for true error handling
		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			messageAlert('Email Sent', 'successMessage');
		} else {
			messageAlert(data, 'errorMessage');
		}
		*/

		messageAlert('Email Sent', 'successMessage');
		return;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__deleteChangeOrderDraftHelper(options)
{
	try {

		// @todo Verify this top code section
		var coDummyId = $("#create-change_order-record--change_orders--dummy_id").val();
		var change_order_draft_id = $("#create-change_order-record--change_orders--change_order_draft_id--" + coDummyId).val();
		if (!change_order_draft_id) {
			var promise = getDummyResolvedPromise();
			return promise;
		}

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = ChangeOrders__deleteChangeOrderDraftSuccess;

		var promise = deleteChangeOrderDraft('', '', change_order_draft_id, options);
		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__deleteChangeOrderDraft(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = ChangeOrders__deleteChangeOrderDraftSuccess;

		var promise = deleteChangeOrderDraft(recordContainerElementId, attributeGroupName, uniqueId, options);
		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__deleteChangeOrderDraftSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var uniqueId = json.uniqueId;
			//ChangeOrders__loadCreateCoDialog();
			$("#spanDeleteCoDraft").html('');
			var form = $("#formCreateCo")[0];
			form.manualReset();
			$("#container--change_order_attachments--create-change_order-record").html('');
			$("#ddl--manage-change_order_draft-record--change_order_drafts--change_order_draft_id--dummy option").each(function(i) {
				var val = $(this).val();
				if (val == uniqueId) {
					$(this).remove();
				}
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

function ChangeOrders__addRecipient(element)
{
	try {

		var coDummyId = $("#create-change_order-record--change_orders--dummy_id").val();

		// Get ul.
		var val = $("#" + element.id + " option:selected").val();
		if (val == '') {
			return;
		}
		var html = $("#" + element.id + " option:selected").html();
		var div = $(element).closest('div');
		var ul = div.find('ul');
		var a = '<a href="#" onclick="ChangeOrders__removeRecipient(this); return false;">X</a>';
		var span = '<span id="create-change_order_recipient-record--change_order_recipients--co_additional_recipient_contact_id_span--' + coDummyId + '">' + html + '</span>';
		var input = '<input id="create-change_order_recipient-record--change_order_recipients--co_additional_recipient_contact_id--' + coDummyId + '" type="hidden" value="' + val + '">';
		var li = '<li id="' + val + '">' + a + '&nbsp;&nbsp;' + span + input + '</li>';

		var found = ul.find('li[id='+val+']').length > 0;
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

function ChangeOrders__removeRecipient(element)
{
	try {

		$(element).parent().remove();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__saveCoAsPdf(change_order_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var change_order_id = parseInputToInt(change_order_id);
		if (!change_order_id) {
			change_order_id = $("#change_order_id").val();
		}
		//To get attchment data
		var attachmentsArr = {};
		var i =0;
		$( ".upfileid" ).each(function( index ) {
		var upfileval = $(this).val();
  		
  		attachmentsArr[i] =  parseInt(upfileval) ;
  		i++;
		});
		var attachments = JSON.stringify(attachmentsArr);

		//To get attchment data
		var executeuploadArr = {};
		var i =0;
		$( ".exefileid" ).each(function( index ) {
		var exefileval = $(this).val();
  		
  		executeuploadArr[i] =  parseInt(exefileval) ;
  		i++;
		});
		var exe_attachments = JSON.stringify(executeuploadArr);


		// @todo Parse temp files out of a list of hidden input elements

		var currentlySelectedProjectId = $('#currentlySelectedProjectId').val();
		var user_company_id = $('#currentlySelectedProjectUserCompanyId').val();
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-change-orders-ajax.php?method=ChangeOrders__saveCoAsPdf';
		var ajaxQueryString =
		'currentlySelectedProjectId=' + encodeURIComponent(currentlySelectedProjectId)+'&user_company_id=' + encodeURIComponent(user_company_id)+'&change_order_id=' + encodeURIComponent(change_order_id)+'&attachmentsArr=' + attachments+'&exe_attachmentsArr=' + exe_attachments;
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
			success: ChangeOrders__saveCoAsPdfSuccess,
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

function ChangeOrders__saveCoAsPdfSuccess(data, textStatus, jqXHR)
{
	try {

		messageAlert('CO PDF saved.', 'successMessage');

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__openCoPdfInNewTab(url)
{
	window.open(url, '_blank');
}

function ChangeOrders__showEditCoStatement(element)
{
	$("#divEditCoStatement").removeClass('hidden');
	$("#divShowCoStatement").addClass('hidden');
}

function ChangeOrders__cancelEditCoStatement(element)
{
	$("#divEditCoStatement").addClass('hidden');
	$("#divShowCoStatement").removeClass('hidden');
}

function ChangeOrders__deleteChangeOrderAttachmentViaPromiseChain(recordContainerElementId, attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var change_order_id = $("#change_order_id").val();
		showSpinner();
		var promise1 = deleteChangeOrderAttachment(recordContainerElementId, attributeGroupName, uniqueId, options)
		var promise2 = promise1.then(function() {
			var innerPromise = ChangeOrders__saveCoAsPdf(change_order_id, options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			var innerPromise = ChangeOrders__loadChangeOrder(change_order_id, options);
			return innerPromise;
		});
		promise3.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function closeCreateCoDialog()
{
	if ($("#divCreateCo").hasClass('ui-dialog-content')) {
		$("#divCreateCo").dialog('close');
	}
}

function ChangeOrders__updateCoViaPromiseChain(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		if (options.change_order_status_id) {
			var change_order_status_id = options.change_order_status_id;
			if (change_order_status_id) {
				options.adHocQueryParameters = '&attributeName=change_order_status_id&newValue=' + encodeURIComponent(change_order_status_id);
			}
		}

		showSpinner();
		var promise1 = updateChangeOrder(element, options);
		var promise2 = promise1.then(function(json) {

			options.adHocQueryParameters = '';
			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var uniqueId = json.uniqueId;
				$("#active_change_order_id").val(uniqueId);

				var attributeGroupName = json.attributeGroupName;
				var attributeSubgroupName = json.attributeSubgroupName;
				var attributeName = json.attributeName;
				var newLabel = json.newLabel;

				var attributeLabelName = attributeName.replace('_id', '');
				var elementLabelId = attributeGroupName + '--' + attributeSubgroupName + '--' + attributeLabelName + '--' + uniqueId;
				$("#" + elementLabelId).html(newLabel);

				var innerPromise = ChangeOrders__saveCoAsPdfHelper(options);
				return innerPromise;
			}

		});
		var promise3 = promise2.then(function() {
			var change_order_id = $("#active_change_order_id").val();
			var innerPromise = ChangeOrders__loadChangeOrder(change_order_id, options);
			return innerPromise;
		});
		promise3.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function appendCoTempFileIds(arrFileManagerFiles, options)
{
	try {

		var options = options || {};
		//options.promiseChain = true;

		$("#file-uploader-container--temp-files").show();

		var htmlAttributeGroup = options.htmlAttributeGroup;
		var tempFileUploaderElementId = options.tempFileUploaderElementId;
		var uploadedTempFilesContainerElementId = options.uploadedTempFilesContainerElementId;

		var tempFileUploadPosition = $("#temp-files-next-position--change_order_attachments").val();

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var tempFileName = fileManagerFile.tempFileName;
			var tempFileSha1 = fileManagerFile.tempFileSha1;
			var tempFilePath = fileManagerFile.tempFilePath;
			//var tempFileUploadPosition = fileManagerFile.tempFileUploadPosition;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var coAttachmentSourceContactFullName = fileManagerFile.coAttachmentSourceContactFullName;

			// Encode for HTML
			var urlEncodedTempFileName = encodeURIComponent(tempFileName);
			var encodedTempFileName = htmlEncode(tempFileName);
			var encoded_virtual_file_mime_type = htmlEncode(virtual_file_mime_type);
			var encodedCoAttachmentSourceContactFullName = htmlEncode(coAttachmentSourceContactFullName);

			/*
			var hiddenLiElement =
			' \
			<li id="' + htmlAttributeGroup + '--position--' + tempFileUploadPosition + '" \
				class="hidden" \
				tempFileName="' + encodedTempFileName + '" \
				tempFileUploadPosition="' + tempFileUploadPosition + '" \
				virtual_file_mime_type="' + encoded_virtual_file_mime_type + '"></li>';

			$("#" + uploadedTempFilesContainerElementId).append(hiddenLiElement);
			*/

			var fileUrl = '/__temp_file__?tempFileSha1=' + tempFileSha1 + '&tempFilePath=' + tempFilePath + '&tempFileName=' + urlEncodedTempFileName + '&tempFileMimeType=' + encoded_virtual_file_mime_type;
			var trElementId = 'record_container--' + htmlAttributeGroup + '--change_order_attachments--position--' + tempFileUploadPosition;

			var trElement =
			' \
			<tr id="' + trElementId + '" \
				class="record_container--uploaded-temp-file--change_order_attachments" \
				tempFileName="' + encodedTempFileName + '" \
				tempFileUploadPosition="' + tempFileUploadPosition + '" \
				virtual_file_mime_type="' + encoded_virtual_file_mime_type + '"> \
				<td width="60%"> \
					<a href="javascript:removeDomElement(\'' + trElementId + '\');">X</a> \
					<a href="' + fileUrl + '" target="_blank">' + tempFileName + '</a> \
				</td> \
				<td width="40%">' + encodedCoAttachmentSourceContactFullName + '</td> \
			</tr>';

			if (tempFileUploadPosition == 1) {
				$("#" + uploadedTempFilesContainerElementId).append(trElement);
			} else {
				$("#" + uploadedTempFilesContainerElementId + ' tr:last').after(trElement);
			}
		}

		// Update position
		var nextTempFileUploadPosition = parseInt(tempFileUploadPosition) + 1;
		$("#temp-files-next-position--change_order_attachments").val(nextTempFileUploadPosition);
		//$("#" + tempFileUploaderElementId).attr('file_upload_position', nextTempFileUploadPosition);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__generateCoTempFileListAsJsonEncodedString(htmlAttributeGroup, options)
{
	try {

		var options = options || {};
		//options.promiseChain = true;


		var arrTempFileLiElements = $("#record_container--uploaded-temp-file--change_order_attachments");

		var arrTempFileObjects = [];
		$(arrTempFileLiElements).each ( function( tmpIndex, tmpElement ) {
			var encodedTempFileName = $(tmpElement).attr('tempFileName');
			var encodedTempFileUploadPosition = $(tmpElement).attr('tempFileUploadPosition');
			var encoded_virtual_file_mime_type = $(tmpElement).attr('virtual_file_mime_type');

			// Decode for HTML
			var tempFileName = htmlDecode(tempFileName);
			var tempFileUploadPosition = htmlDecode(tempFileUploadPosition);
			var virtual_file_mime_type = htmlDecode(virtual_file_mime_type);

			// Create javascript object
			var tempFileObject = { 'tempFileName': tempFileName, 'tempFileUploadPosition': tempFileUploadPosition, 'virtual_file_mime_type': virtual_file_mime_type };

			arrTempFileObjects.push(tempFileObject);
		});

		var tempFileListAsJsonEncodedString = JSON.stringify(arrTempFileObjects);

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(tempFileListAsJsonEncodedString);
			if (continueDebug != true) {
				return;
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

//For Change order edit
function ChangeOrders__editChangeOrder(attributeGroupName, uniqueId, options,change_order_id)
{
	
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = ChangeOrders__createChangeOrderSuccess;

		var isEmailTo = $("#ddl--create-change_order-record--change_orders--co_recipient_contact_id--"+uniqueId).val();
		var isEmailFrom = $("#create-change_order-record--change_orders--co_signator_contact_id--"+uniqueId).val();

		if (isEmailTo == '') {
			$("#ddl--create-change_order-record--change_orders--co_recipient_contact_id--"+uniqueId).parent().children().parent().children(':first-child').addClass('redBorderThick');
		}else{
			$("#ddl--create-change_order-record--change_orders--co_recipient_contact_id--"+uniqueId).parent().children().parent().children(':first-child').removeClass('redBorderThick');
		}

		if (isEmailFrom == '') {
			$("#create-change_order-record--change_orders--co_signator_contact_id--"+uniqueId).parent().children().parent().children(':first-child').addClass('redBorderThick');
		}else{
			$("#create-change_order-record--change_orders--co_signator_contact_id--"+uniqueId).parent().children().parent().children(':first-child').removeClass('redBorderThick');
		}

		var promise = editChangeOrder(attributeGroupName, uniqueId, options,change_order_id);

		var promiseChain = options.promiseChain;
		if (promiseChain) {
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

function changeOrder_isMailToError(element){
	var DummyId = $("#create-change_order-record--change_orders--dummy_id").val();
	$("#ddl--create-change_order-record--change_orders--co_recipient_contact_id--"+DummyId).parent().children(':first-child').removeClass('redBorderThick');
}

function changeOrder_isMailFromError(element){
	var DummyId = $("#create-change_order-record--change_orders--dummy_id").val();
	$("#create-change_order-record--change_orders--co_signator_contact_id--"+DummyId).parent().children(':first-child').removeClass('redBorderThick');
}

function ChangeOrders__createChangeOrder(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = ChangeOrders__createChangeOrderSuccess;

		var isEmail = $("#ddl--create-change_order-record--change_orders--co_recipient_contact_id--"+uniqueId).val();
		var isEmailFrom = $("#create-change_order-record--change_orders--co_signator_contact_id--"+uniqueId).val();

		if (isEmail == '') {
			$("#ddl--create-change_order-record--change_orders--co_recipient_contact_id--"+uniqueId).parent().children().parent().children(':first-child').addClass('redBorderThick');
		}else{
			$("#ddl--create-change_order-record--change_orders--co_recipient_contact_id--"+uniqueId).parent().children().parent().children(':first-child').removeClass('redBorderThick');
		}

		if (isEmailFrom == '') {
			$("#create-change_order-record--change_orders--co_signator_contact_id--"+uniqueId).parent().children().parent().children(':first-child').addClass('redBorderThick');
		}else{
			$("#create-change_order-record--change_orders--co_signator_contact_id--"+uniqueId).parent().children().parent().children(':first-child').removeClass('redBorderThick');
		}

		var promise = createChangeOrder(attributeGroupName, uniqueId, options);

		var promiseChain = options.promiseChain;
		if (promiseChain) {
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

function ChangeOrders__createChangeOrderSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			var coTable = json.coTable;

			if (coTable) {
				$("#coTable").html(coTable);
			}

			ChangeOrders__addCoTableClickHandlers();
			$("#active_change_order_id").val(uniqueId);

			ChangeOrders__addDataTablesToCOListView();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__performAction(element)
{

	// Get the desired action
	var action = $(element).val();

	if (action == -1) {
		return;
	}

	// Reset the <select>
	$(element).val(-1);
	var showreject = $('#showreject').prop('checked');

	var options = { coType: action,showreject:showreject };

	//var options = { element: element };
	//ChangeOrders__generateChangeOrdersListViewPdf(options);

	ChangeOrders__generateChangeOrdersListViewPdf(options);

}

function ChangeOrders__generateChangeOrdersListViewPdf(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		//options.responseDataType = 'json';

		if (options.coType) {
			var coType = options.coType;
		} else {
			var coType = '';
		}
		if(options.showreject){
			var showreject = options.showreject;
		}else {
			var showreject = '';
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-change-orders-ajax.php?method=ChangeOrders__generateChangeOrdersListViewPdf';
		var ajaxQueryString =
			'coType=' + encodeURIComponent(coType) +
			'&showreject=' + encodeURIComponent(showreject) +
			'&responseDataType=json';
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
			success: ChangeOrders__generateChangeOrdersListViewPdfSuccess,
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

function ChangeOrders__generateChangeOrdersListViewPdfSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var url = json.url;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(url);
				if (continueDebug != true) {
					return;
				}
			}

			document.location = url;

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ChangeOrders__formatCoScheduledValue(element)
{
	try {

		var amount = $(element).val();

		var formattedAmount = parseInputToCurrency(amount);
		var formattedAmount = formatDollar(amount);

		$(element).val(formattedAmount);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function change__orderDraftAttachmentUploaded(arrFileManagerFiles, containerElementId,execute)
{
	try {

		var DummyId = $("#create-change_order-record--change_orders--dummy_id").val();

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];
			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var fileUrl                = fileManagerFile.fileUrl;

			var csvRfiFileManagerFileIds = $("#create-change_order_attachment-record--change_order_attachments--csvCoFileManagerFileIds--" + DummyId).val();
			var arrRfiFileManagerFileIds = csvRfiFileManagerFileIds.split(',');
			arrRfiFileManagerFileIds.push(file_manager_file_id);
			csvRfiFileManagerFileIds = arrRfiFileManagerFileIds.join(',');
			$("#create-change_order_attachment-record--change_order_attachments--csvCoFileManagerFileIds--" + DummyId).val(csvRfiFileManagerFileIds);

			// Remove the placeholder li.
			$("#" + containerElementId).children().each(function(i) {
				if ($(this).hasClass('placeholder')) {
					$(this).remove();
				}
			});

			var elementId = 'record_container--manage-file_manager_file-record--file_manager_files--' + file_manager_file_id;
			if(execute=='N')
			{
			var htmlRecord = '' +
			'<li id="' + elementId + '">' +
				'<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">&nbsp;<input type="hidden" class="upfileid" value="'+ file_manager_file_id +'" ><a href="javascript:deleteFileManagerFile(\'' + elementId + '\', \'manage-file_manager_file-record\', \'' + file_manager_file_id + '\');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;' +
				'<a href="' + fileUrl + '" target="_blank">' + virtual_file_name + '</a>' +
			'</li>';
		}else{
			var htmlRecord = '' +
			'<li id="' + elementId + '">' +
				'<img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">&nbsp;<input type="hidden" class="exefileid" value="'+ file_manager_file_id +'" ><a href="javascript:deleteFileManagerFile(\'' + elementId + '\', \'manage-file_manager_file-record\', \'' + file_manager_file_id + '\');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;' +
				'<a href="' + fileUrl + '" target="_blank">' + virtual_file_name + '</a>' +
			'</li>';
		}

			// Append the file manager file element.
			$("#" + containerElementId).append(htmlRecord);
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


function deleteCOFile(attr, subattr, file,tabledata)
{

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-change-orders-ajax.php?method=deleteCOFile'
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
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				deleteFileManagerFile(attr,subattr,file);
				// $('#'+attr).remove();
					
				
			},
			error: errorHandler
		});

}
function COstatusCheck(val)
{
	var dummId = $('#create-change_order-record--change_orders--dummy_id').val();
	var coTypeId = $('#ddl--create-change_order-record--change_orders--change_order_type_id--'+dummId).val();
	var day = new Date().getDate();
	var month = new Date().getMonth();
	month = month+1;
	var year = new Date().getFullYear();
	var date = year+'-'+month+'-'+day;
	
	if(val=='2')
	{
		$(".up_exe").css('display','block');
		$(".bs-tooltip").tooltip();
		$("#create-change_order-record--change_orders--co_submitted_date--"+dummId).prop('disabled', true);
		$('#create-change_order-record--change_orders--co_approved_date--'+dummId).val(date);
	}else{
		$(".up_exe").css('display','none');
		$("#create-change_order-record--change_orders--co_submitted_date--"+dummId).prop('disabled', false);
	}

	if (val=='2' && coTypeId == '2') {
		$('.app_exe').css('display','block');
	}else{
		$(".app_exe").css('display','none');
	}
}

function COsubmittedDate(val){
	var dummId = $('#create-change_order-record--change_orders--dummy_id').val();
	var coTypeId = $('#create-change_order-record--change_orders--change_order_status_id--'+dummId).val();
	if(val=='2'){
		$(".sub_exe").css('display','block');
	}else{
		$(".sub_exe").css('display','none');
	}
	if (val=='2' && coTypeId == '2') {
		$('.app_exe').css('display','block');
	}else{
		$(".app_exe").css('display','none');
	}
}


//To check the projectowner 
function project_ownerCheck()
{
	var project = $('#currentlySelectedProjectId').val();
	var ajaxUrl = window.ajaxUrlPrefix + 'modules-change-orders-ajax.php';
		$.ajax({
		method:'GET',
		url:ajaxUrl,
		data:'method=projectOwnerCheck&project='+project,
		success:function(data)
		{
			if(data=="1")
			{

				$("#dialog-confirm").html("The project owner is not assigned, Please assign and continue");

	    		// Define the Dialog and its properties.
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
	    				"Assign": function () {
	    					$(this).dialog('close');
							window.location.href="/admin-projects.php";
		    				},
	    			}
	    		});
			}else{
				ChangeOrders__loadCreateCoDialog(null);
			}
		}

	});
}

//update CO in draws
function updateChangeOrderInDraws(changeOrderId,approved_date,options){
  try {

    var options = options || {};
    var promiseChain = options.promiseChain;

    var changeOrderId = changeOrderId;
    var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=updateChangeOrderInDraws';
    var ajaxQueryString =
    'changeOrderId=' + encodeURIComponent(changeOrderId) +
    '&approved_date=' + encodeURIComponent(approved_date);
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
      success: updateChangeOrderInDrawsSuccess,
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

function updateChangeOrderInDrawsSuccess(data, textStatus, jqXHR){
  try {



  } catch (error) {

    if (window.showJSExceptions) {
      var errorMessage = error.message;
      alert('Exception Thrown: ' + errorMessage);
      return;
    }

  }
};
//load subcontractors depends on selected cost code
function updateSubcontractors(val, dummy, company_id, project_id){
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-change-orders-ajax.php?method=updateSubcontractors';
	var ajaxQueryString =
	'costcode_id=' + encodeURIComponent(val) +
	'&dummy=' + encodeURIComponent(dummy) +
	'&company_id=' + encodeURIComponent(company_id) +
	'&project_id=' + encodeURIComponent(project_id);
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	$.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success:function(res)
		{
			$('#subCoList').empty().append(res);
			$('.emailGroup').fSelect();
		},
		error: errorHandler
	});
};
