$(document).ready(function() {
	createUploaders();
	setTimeout(function(){
		$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90},1000);
	});
	
});
var token = $("#token").val();
var pt_token = $("#pt_token").val();
var subcontract_id = $("#subid").val();
var conid = $("#conid").val();
function Ajaxloadsubcontract()
{
	var value=$("#view_status").val();
	var filteropt=$("#sco_filter").val();
	showSpinner();
	var ajaxUrl = window.ajaxUrlPrefix + 'budget-subcontractor-guest-ajax.php';
		$.ajax({
		method:'GET',
		url:ajaxUrl,
		data:'method=Ajaxloadsubcontract&token='+token+'&pt_token='+pt_token+'&conid='+conid+'&subcontract_id='+subcontract_id,
		success:function(data)
		{
				$('#subcontContent').empty().append(data);
				hideSpinner();
		        createUploaders();
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

			
		}

	});
}

function guestupdateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(element, options,checks, subid, checkModalOpen)
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
			// var checkDateMinimze = Date.now()-Date.parse(newValueText);
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
		// if(old != newval)
		// {
		// 	if(Date.parse(old)-Date.parse(newval) >= 0)
		// 	{
		// 		updateData.val('');
		// 		messageAlert('Please select the expiry date equal or after '+msg+' date ', 'errorMessage');
		// 		return false;
		// 	}
		// }

		showSpinner();
		var promise1 = Gc_Budget__updateSubcontract_guest(element, options);
		var promise2 = promise1.then(function(data) {

			try {
				var json = data;
				var uniqueId = json.uniqueId;
				// var innerPromise = loadSubcontractDetailsWidget(uniqueId, options);
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

function Gc_Budget__updateSubcontract_guest(element, options)
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

			var promise = GuestupdateSubcontract(element, options);
			return promise;

		} else {

			var promise =GuestupdateSubcontract(element, options);
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

/**
 * element is the HTML ELement itself passed in ("this")
 * options is an object with a collection of optional directives
 */
function GuestupdateSubcontract(element, options)
{
	// Debug
	//return;

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.element									= element;
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Subcontract';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Subcontracts';
			htmlRecordMetaAttributesOptions.formattedAttributeName					= '';
			var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('update', htmlRecordMetaAttributesOptions);
		}

		var attributeGroupName 				= htmlRecordMetaAttributes.attributeGroupName;
		var attributeName 					= htmlRecordMetaAttributes.attributeName;
		var uniqueId 						= htmlRecordMetaAttributes.uniqueId;
		var formattedAttributeGroupName 	= htmlRecordMetaAttributes.formattedAttributeGroupName;
		var formattedAttributeSubgroupName	= htmlRecordMetaAttributes.formattedAttributeSubgroupName;
		var formattedAttributeName			= htmlRecordMetaAttributes.formattedAttributeName;
		var newValueText					= htmlRecordMetaAttributes.newValueText;

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else if (htmlRecordMetaAttributes.attributeSubgroupName) {
			var attributeSubgroupName 		= htmlRecordMetaAttributes.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'subcontracts';
		}

		var inputDataFiltered = false;
		if (!optionsObjectIsEmpty && options.newValue) {

			// Assume final input
			var newValue = options.newValue;
			inputDataFiltered = true;

		} else if (!optionsObjectIsEmpty && options.endIndex && (attributeName == 'sort_order')) {

			// sort_order case
			newValue = options.endIndex;
			inputDataFiltered = true;

		} else if ((typeof element !== 'undefined') && $(element).is(':checkbox')) {

			// Checkbox input element
			// Test for application-specific standardized cases
			var index = attributeName.indexOf('_flag');
			if (index > -1) {
				var newValue = 'N';
				if ($(element).is(':checked')) {
					newValue = 'Y';
				}
				inputDataFiltered = true;
			} else {

				// Get the value of the element that was updated.
				var tmpValue = $(element).val();

			}

		} else  {

			// Get the value of the element that was updated.
			var tmpValue = $(element).val();

		}

		if (!inputDataFiltered) {
			var objReturn = filterSubcontractHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue);
			var inputDataFiltered = objReturn.inputDataFiltered;
			var newValue = objReturn.newValue;

			if (!inputDataFiltered) {
				var objReturn = parseInputToTemporalDataTypeByAttributeName(attributeName, tmpValue);
				var inputDataFiltered = objReturn.inputDataFiltered;
				var newValue = objReturn.newValue;
			}
		}

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'N';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'budget-subcontractor-guest-ajax.php?method=updateSubcontract';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&attributeName=' + encodeURIComponent(attributeName) +
			'&sortOrderFlag=' + encodeURIComponent(sortOrderFlag) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newValue=' + encodeURIComponent(newValue) +
			'&newValueText=' + encodeURIComponent(newValueText) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName) +
			'&formattedAttributeName=' + encodeURIComponent(formattedAttributeName)+
			'&token='+token+'&pt_token='+pt_token+'&conid='+conid+'&subcontract_id='+subcontract_id;

		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options) {
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

		// Optional $.ajax callbacks may be passed in via the options object
		if (skipDefaultSuccessCallback) {
			var arrSuccessCallbacks = [ ];
		} else {
			var arrSuccessCallbacks = [ defaultAjaxCallback_updateSuccess ];
		}
		if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function()
			{
				Ajaxloadsubcontract();
			},
			error: errorHandler
		});

		// if (promiseChain) {
			return returnedJqXHR;
		// }

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function GuestverifyFinalSubcontract(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie)
{
	if(GCsign == 'Y' || Vendorsign == 'Y' )
	{
	    var	htmltext = "Already you have a signature! click Proceed to E-sign or modify to change the signature ";
				

	$("#dialog-confirm").html(htmltext);
	$("#dialog-confirm").dialog({
		resizable: false,
		modal: true,
		title: "Confirmation",
		dialogClass : 'dialog1',
		buttons: {

			"Modify": function () {
				$(this).dialog('close');
				$("body").removeClass('noscroll');
				GuestshowsetSignature(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie);

			},
			"Proceed": function () {
				$(this).dialog('close');
				$("body").removeClass('noscroll');
				GuestgenerateFinalSubcontract(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie);
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
			GuestshowsetSignature(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie);

		}
	
}

function GuestgenerateFinalSubcontract(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,GCsign,Vendorsign,cancomplie,esign)
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
		var ajaxHandler = window.ajaxUrlPrefix + 'budget-subcontractor-guest-ajax.php?method=generateFinalSubcontract';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
		'&cost_code_id=' + encodeURIComponent(cost_code_id) +
		'&subcontract_id=' + encodeURIComponent(subcontract_id) +
		'&execution_date=' + encodeURIComponent(execution_date) +
		'&signatory_check=' + encodeURIComponent(signatory_check) +
		'&esign=' + encodeURIComponent(esign) +
		'&mailed_date=' + encodeURIComponent(mailed_date)+
		'&token='+token+'&pt_token='+pt_token+'&conid='+conid;
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
			success: function()
			{
				Ajaxloadsubcontract();
			},
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



//To get the signature
function GuestshowsetSignature(gc_budget_line_item_id,cost_code_division_id,cost_code_id,subcontract_id,subcontract_execution_date,subcontract_mailed_date,GCsign,Vendorsign,cancomplie)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'budget-subcontractor-guest-ajax.php?method=setSignaturedata';
	var ajaxQueryString ='&token='+token+'&pt_token='+pt_token+'&conid='+conid+'&subcontract_id='+subcontract_id;
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	$.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,

		success: function(data){
			var json = data;
			var htmlContent = json.htmlContent;


			$("#divsignature").empty().append(htmlContent);	
			$("#divsignature").removeClass('hidden');

			// var dialogContainer = $("#divModalWindow").parent();

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
					// if (dialogContainer.hasClass('ui-dialog')) {
					// 	dialogContainer.hide();
				//start
				$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90},3000);
			// }
		},
		close: function() {
			$("body").removeClass('noscroll');
			$(this).dialog('destroy');
			$("#divsignature").html('');
			$("#divsignature").addClass('hidden');
			// if (dialogContainer.hasClass('ui-dialog')) {
			// 	dialogContainer.show();
			// }
		},
		buttons: {
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
function GuestshowsetSignaturewithdialog(gc_budget_line_item_id,cost_code_division_id,cost_code_id,subcontract_id,subcontract_execution_date,subcontract_mailed_date,GCsign,Vendorsign,cancomplie)
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
			GuestshowsetSignature(gc_budget_line_item_id,cost_code_division_id,cost_code_id,subcontract_id,subcontract_execution_date,subcontract_mailed_date,GCsign,Vendorsign,cancomplie)	

			}

		}
	});
	if($('.ui-dialog').length)
	{
		$('.ui-dialog').css("top", '100px');
	}


}

//type signature start
function guestshowTextPreview(val)
{
	var element = $("#html-content-holder"); 
	var getCanvas; 

			$("#previewImage").empty().append(val);
	

}

function guestsaveTextAsSign()
{
		var element = $("#html-content-holder"); 
		var getCanvas; 
		html2canvas(element, {
			onrendered: function (canvas) {
				var imgageData = canvas.toDataURL("image/png");
				var img_data = imgageData.replace(/^data:image\/(png|jpg);base64,/, "");
		//ajax call to save image inside folder
		$.ajax({
			url: window.ajaxUrlPrefix +'esignature/sign_src/save_sign.php',
			data: { img_data:img_data,type:'1',contact_id:conid },
			type: 'post',
			success: function (response) {
				resarr = response.split('~');
				messageAlert('Successfully saved the E-signature', 'successMessage');

			}
		});
	}
});
}
//type signature End

function guestloadpreviewAfterimgupload()
{
$.ajax({
		url: window.ajaxUrlPrefix +'esignature/sign_src/esigncontent.php',
		data: { method:"esigncontent",type:"3",contact_id:conid },
		type: 'get',
		success: function (response) {

			messageAlert('Successfully saved the E-signature', 'successMessage');
			resarr = response.split('~');
			$(".sign-preview").css("display","");
			$('.sign-preview').attr("src",resarr[0]);
			$('.eupdatedate').html(resarr[1]);
		}
	});
}

function guestsaveDrawSign(event)
{
	
	if($('.ui-dialog').length)
	{
		$('.ui-dialog').css("top", '100px');
	}
	html2canvas([document.getElementById('sign-pad')], {
		onrendered: function (canvas) {
			var canvas_img_data = canvas.toDataURL('image/png');
			var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
						//ajax call to save image inside folder
						$.ajax({
							url: window.ajaxUrlPrefix +'esignature/sign_src/save_sign.php',
							data: { img_data:img_data,type:'2',contact_id:conid },
							type: 'post',
							success: function (response) {
								$('.ui-dialog').css("top", '100px');
								resarr = response.split('~');
								$("#signArea").signaturePad().clearCanvas ();  //clear the signature place
								$(".sign-preview").css("display","");
								$('.sign-preview').attr("src",resarr[0]);
								$('.eupdatedate').html(resarr[1]);
								messageAlert('Successfully saved the E-signature', 'successMessage');
							}
						});
					}
				});
}
function GuestToclearDrawSign()
{
	$("#signArea").signaturePad().clearCanvas ();
}




//For global_admin separating the KPI
function signsetchanges()
{
	var signupvalue = $('input[name=signset]:checked').val();
	if(signupvalue=='type_my_signature')
	{
		$('.type_my_signature').show();
		$('.draw_signimage').hide();
		$('.upload_signimage').hide();
	}
	else if(signupvalue=='draw_signimage')
	{
		$('.type_my_signature').hide();
		$('.draw_signimage').show();
		$('.upload_signimage').hide();	
	}
	else if(signupvalue=='upload_signimage')
	{
		$('.type_my_signature').hide();
		$('.draw_signimage').hide();
		$('.upload_signimage').show();		
	}
}


