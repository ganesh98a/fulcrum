/*
module signature block func call
*/
function onClickIncludeBlock(element, attributeGroupName, inputAttributGroupName, options) {
	//  Debug
	// return
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		createOrUpdateSignatureBlock(element, attributeGroupName, inputAttributGroupName, options);
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/*
module signature block func call
*/
function onClickIncludeRetBlock(element, attributeGroupName, inputAttributGroupName, options) {
	//  Debug
	// return
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		createOrUpdateRetentionSignatureBlock(element, attributeGroupName, inputAttributGroupName, options);
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function onClickIncludeBlockCL(element, attributeGroupName, inputAttributGroupName, options) {
	//  Debug
	// return
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}
		createOrUpdateSignatureBlockCL(element, attributeGroupName, inputAttributGroupName, options);
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
// construction lender for retention
function onClickRetIncludeBlockCL(element, attributeGroupName, inputAttributGroupName, options) {
	//  Debug
	// return
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}
		createOrUpdateRetSignatureBlockCL(element, attributeGroupName, inputAttributGroupName, options);
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
// Add New Row for other SB
function addOthersNewRow(attrGorupName, uniqueId, typeId, drawId, projectId, debugMode){
	var htmlContent = "";
	var otherCount = $('#'+attrGorupName+'--signature_block_count--Other1--'+typeId).val();
	var signType = $('#'+attrGorupName+'--signature_block_count--Other1--'+typeId).val();
	otherCount = Number(otherCount)+1;
	var debugData = '';
  if(debugMode){
    debugData ='<td class="text-center">'+typeId+'</td><td class="text-center"></td>';
	}
	htmlContent =
	'<tr id="record_container--removable_draw--Other'+otherCount+'--'+typeId+'">'+debugData+'<td id="manage_draw--draw_signature_type--include" class="text-center"><input type="hidden" id="manage_draw--signature_block_id--Other'+otherCount+'--'+typeId+'" onchange="onClickIncludeBlock(this, &quot;manage_draw--signature_block_id&quot;, &quot;Other'+otherCount+'&quot;, {&quot;signatureTypeId&quot;:'+typeId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;signatureBlockId&quot;:0})" value="0"><input type="checkbox" id="manage_draw--signature_include--Other'+otherCount+'--'+typeId+'" onchange="onClickIncludeBlock(this, &quot;manage_draw--signature_include&quot;, &quot;Other'+otherCount+'&quot;, {&quot;signatureTypeId&quot;:'+typeId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;signatureBlockId&quot;:0})"></td><td>Other:</td><td><input id="manage_draw--signature_desc_udate_flag--Other'+otherCount+'--'+typeId+'" type="hidden" value="N"><input id="manage_draw--signature_name--Other'+otherCount+'--'+typeId+'" class="readOnly" type="text" onchange="onClickIncludeBlock(this, &quot;manage_draw--signature_block_id&quot;, &quot;Other'+otherCount+'&quot;, {&quot;signatureTypeId&quot;:'+typeId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;signatureBlockId&quot;:0})"  onfocusout="checkValueISNull(this, &quot;manage_draw--signature_include&quot;, &quot;Other'+otherCount+'&quot;, &quot;'+typeId+'&quot;)" readonly="readonly" value=""></td><td><a class="cursorPoint" onclick="removeRowSB(&quot;record_container--removable_draw&quot;,&quot;manage_draw--signature_block_id&quot;, &quot;Other'+otherCount+'&quot;,'+typeId+','+debugMode+')"><span class="entypo-cancel-circled"></span></a></td></tr>'
	;
	$('#signatureTableContentBody').append(htmlContent);
	$('#'+attrGorupName+'--signature_block_count--'+uniqueId+'--'+typeId).val(otherCount);
}

function removeRowSB(attrGorupName, attributeGroupName, uniqueId, typeId, debugMode){
	var row = $('#'+attrGorupName+'--'+uniqueId+'--'+typeId);
	var signBlockId = $('#'+attributeGroupName+'--'+uniqueId+'--'+typeId).val();
	signBlockId = Number(signBlockId);
	if(signBlockId) {
		removeSignatureBlockOther(signBlockId);
	}
	row.remove();
}

//To add new Row for retention
function addRetOthersNewRow(attrGorupName, uniqueId, typeId, drawId, projectId, debugMode){
	var htmlContent = "";
	var otherCount = $('#'+attrGorupName+'--signature_block_count--Other1--'+typeId).val();
	var signType = $('#'+attrGorupName+'--signature_block_count--Other1--'+typeId).val();
	otherCount = Number(otherCount)+1;
	var debugData = '';
  if(debugMode){
    debugData ='<td class="text-center">'+typeId+'</td><td class="text-center"></td>';
	}
	htmlContent =
	'<tr id="record_container--removable_draw--Other'+otherCount+'--'+typeId+'">'+debugData+'<td id="manage_draw--draw_signature_type--include" class="text-center"><input type="hidden" id="manage_draw--signature_block_id--Other'+otherCount+'--'+typeId+'" onchange="onClickIncludeRetBlock(this, &quot;manage_draw--signature_block_id&quot;, &quot;Other'+otherCount+'&quot;, {&quot;signatureTypeId&quot;:'+typeId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;signatureBlockId&quot;:0})" value="0"><input type="checkbox" id="manage_draw--signature_include--Other'+otherCount+'--'+typeId+'" onchange="onClickIncludeRetBlock(this, &quot;manage_draw--signature_include&quot;, &quot;Other'+otherCount+'&quot;, {&quot;signatureTypeId&quot;:'+typeId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;signatureBlockId&quot;:0})"></td><td>Other:</td><td><input id="manage_draw--signature_desc_udate_flag--Other'+otherCount+'--'+typeId+'" type="hidden" value="N"><input id="manage_draw--signature_name--Other'+otherCount+'--'+typeId+'" class="readOnly" type="text" onchange="onClickIncludeRetBlock(this, &quot;manage_draw--signature_block_id&quot;, &quot;Other'+otherCount+'&quot;, {&quot;signatureTypeId&quot;:'+typeId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;signatureBlockId&quot;:0})"  onfocusout="checkValueISNull(this, &quot;manage_draw--signature_include&quot;, &quot;Other'+otherCount+'&quot;, &quot;'+typeId+'&quot;)" readonly="readonly" value=""></td><td><a class="cursorPoint" onclick="removeRetRowSB(&quot;record_container--removable_draw&quot;,&quot;manage_draw--signature_block_id&quot;, &quot;Other'+otherCount+'&quot;,'+typeId+','+debugMode+')"><span class="entypo-cancel-circled"></span></a></td></tr>'
	;
	$('#signatureTableContentBody').append(htmlContent);
	$('#'+attrGorupName+'--signature_block_count--'+uniqueId+'--'+typeId).val(otherCount);
}
// to remove the retention rows
function removeRetRowSB(attrGorupName, attributeGroupName, uniqueId, typeId, debugMode){
	var row = $('#'+attrGorupName+'--'+uniqueId+'--'+typeId);
	var signBlockId = $('#'+attributeGroupName+'--'+uniqueId+'--'+typeId).val();
	signBlockId = Number(signBlockId);
	if(signBlockId) {
		removeRetentionSignatureBlockOther(signBlockId);
	}
	row.remove();
}


function checkValueISNull(element, attrGorupName, uniqueId, typeId) {
	var value = $(element).val();
	if($(element)) {
		setTimeout(function(){
			var checked = $('#'+attrGorupName+'--'+uniqueId+'--'+typeId).is(':checked') || false;
		// alert(checked);
		if((value=='' || value=='null') && checked){
			$(element).addClass('redBorder');
			messageAlert('pls fill the highlighted area\'s', 'errorMessage');
		} else {
			$(element).removeClass('redBorder');
		}
	}, 500);
	}

}

function clickToGenerateDraw() {
	var pathname = window.location.host; // Returns path only
	var http=window.location.protocol;
	var include_path='/';
	var full_path=http+pathname+include_path;
	var date=new Date();
	var drawId = $('#manage_draw--draw_id').val();
	var drawAppId = $('#manage_draw--draw_app_id').val();
	var formValues="draw_id="+drawId+"&draw_app_id="+drawAppId;
	var linktogenerate='draw-print-email-notification.php?'+formValues;
	document.location = linktogenerate;
}

// draw action values
function changeSubOptionVal(element,drawTemplateId) {
	//  Debug
	// return
	try {
		var data = $(element).val();
		var option_text = $("#manage_draw--select_action_type option:selected").text();
		

		if(data) {
			data = data.split('--');
			var downPdf = data[2];
			var downxlsx = data[3];
			var actionTypeId = data[0];
			var actionTypeOption = data[1];
			if(downPdf == 'Y'){
				$('.pdfDownload').css('display','block');
			} else {
				$('.pdfDownload').css('display','none');
			}
			if(downxlsx == 'Y'){
				$('.xlsxDownload').css('display','block');
			} else {
				$('.xlsxDownload').css('display','none');
			}
			if(actionTypeOption == 'Y'){
				$('#manage_draw--select_action_type_option').css('display','block');
			} else {
				$('#manage_draw--select_action_type_option').css('display','none');
			}

			if(actionTypeOption == 'Y' && downPdf == 'Y' && downxlsx == 'Y'){
				$('#manage_draw--select_action_type_option').val(drawTemplateId);
			}else{
				$('#manage_draw--select_action_type_option').val('');
			}

			if(option_text =='Print Draw' || option_text == 'Export Excel'){
				$('#multiselectoption').css('display','block');
				//$('#export_option option[value="general_condition_summary"]').attr("selected", "selected");
			}else{
				$('#multiselectoption').css('display','none');
			}

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=drawActionType';
			var ajaxQueryString =
			'draw_action_type_id=' + encodeURIComponent(actionTypeId);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: drawActionTypeSuccess,
				error: errorHandler
			});


			$('.actionTypeDefault').css('display','none');
			$('.selectedActType_'+actionTypeId).prop('style','display: block');
		} else {
			$('.pdfDownload').css('display','none');
			$('.xlsxDownload').css('display','none');
			$('.actionTypeDefault').css('display','none');
			$('#manage_draw--select_action_type_option').css('display','block');
			$('#multiselectoption').css('display','none');
		}
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function drawActionTypeSuccess(data){
	$("#manage_draw--select_action_type_option").html(data);
}

function onchangeSubOrderChangeValue() {
	$('#manage_draw--select_action_type_option').removeClass('redBorder');
}


//  generate pdf
function clickToGenerateDrawPdfBasedActionType() {
	var pathname = window.location.host; // Returns path only
	var http=window.location.protocol;
	var include_path='/';
	var full_path=http+pathname+include_path;
	var date=new Date();
	var drawId = $('#manage_draw--draw_id').val();
	var drawAppId = $('#manage_draw--draw_app_id').val();
	var actionTypeIdData = $('#manage_draw--select_action_type').val();
	var architectureBlock = false;
	var narrative_flag = false;
    var general_condition_flag = false;
    var cost_code_alias = false;

    var report_option = $('#export_option').val();
    if (report_option) {    	
    	if (Object.values(report_option).indexOf('general_condition_summary') > -1) {
		   general_condition_flag = true;
		};
		if (Object.values(report_option).indexOf('narrative_column') > -1) {
		   narrative_flag = true;
		};
		if (Object.values(report_option).indexOf('cost_code_alias') > -1) {
		   cost_code_alias = true;
		};
    }    
    
    
	
	if($("input[id^='manage_draw--signature_include--Architect']").is(':checked')){
		architectureBlock = true;
	}


	if(actionTypeIdData) {
		var data = actionTypeIdData.split('--');
		var downPdf = data[2];
		var downxlsx = data[3];
		var actionTypeId = data[0];
		var actionTypeOption = data[1];
		if(actionTypeOption == 'Y'){
			var actionTypeOptionId = $('#manage_draw--select_action_type_option').val();
			if(actionTypeOptionId == '') {
				$('#manage_draw--select_action_type_option').addClass('redBorder');
				messageAlert('Please select action type', 'errorMessage');
				return;
			}
		} else {
			var actionTypeOptionId = '';
		}
	} else {
		var actionTypeId = '';
		var actionTypeOptionId = '';
		return;
	}
	if((general_condition_flag == true || narrative_flag == true) && actionTypeId == '2' && (actionTypeOptionId == '5' || actionTypeOptionId == '6') ){

		$.get('draw_signature_block-ajax.php',{'method':'checkdrawdownload','narrative_flag':narrative_flag,'general_condition_flag':general_condition_flag,'draw_id':drawId,'type':'pdf'},function(data){
			console.log(data);
			if($.trim(data) =='N' && narrative_flag == true){
				alert(1);
				messageAlert('No Narrative Column Exists', 'errorMessage');
				return false;		
			}else if($.trim(data) =='N' && general_condition_flag == true){
				alert(2);
				messageAlert('Please group all the divisions in the Master Cost Codes list in Budget.', 'errorMessage');
				return false;		
			
			}else{
				alert(3);
				var formValues="draw_id="+drawId+"&draw_app_id="+drawAppId+"&draw_action_type_id="+actionTypeId+"&draw_action_type_option_id="+actionTypeOptionId+"&architectureBlock="+architectureBlock+'&narrative_flag='+narrative_flag+'&general_condition_flag='+general_condition_flag+'&cost_code_alias='+cost_code_alias;
				if(actionTypeId == '2' && actionTypeOptionId == '5') {
					// clickToGenerateDraw();
					alert(4);
					var linktogenerate='draw-print-email-notification.php?'+formValues;
					// return;
				} else if(actionTypeId == '2' && actionTypeOptionId == '6') { 
					alert(5);
					var linktogenerate='draw-print-email-notification2.php?'+formValues;
				} else {
					alert(6);
					var linktogenerate='draw-print-pdf-action-type.php?'+formValues;
				}
				document.location = linktogenerate;
			}
		});
		
		
	}else{
		var formValues="draw_id="+drawId+"&draw_app_id="+drawAppId+"&draw_action_type_id="+actionTypeId+"&draw_action_type_option_id="+actionTypeOptionId+"&architectureBlock="+architectureBlock+'&narrative_flag='+narrative_flag+'&general_condition_flag='+general_condition_flag+'&cost_code_alias='+cost_code_alias;
		if(actionTypeId == '2' && actionTypeOptionId == '5') {
			// clickToGenerateDraw();
			alert(7);
			var linktogenerate='draw-print-email-notification.php?'+formValues;
			console.log(linktogenerate);
			alert(linktogenerate);

			// return;
		} else if(actionTypeId == '2' && actionTypeOptionId == '6') { 
			alert(8);
			var linktogenerate='draw-print-email-notification2.php?'+formValues;
		} else {
			alert(9);
			var linktogenerate='draw-print-pdf-action-type.php?'+formValues;
		}
		document.location = linktogenerate;	
	}
	
}
/*
** BreakDown Structure
*/
function onChangeBDVal(element, attributeGroupName, inputAttributGroupName, options) {
	//  Debug
	// return
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		createOrUpdateBreakdown(element, attributeGroupName, inputAttributGroupName, options);
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
// Add New Row for draw breakdown
function addBreakdownNewRow(attrGorupName, uniqueId, drawId, projectId, debugMode){
	var htmlContent = "";
	var otherCount = $('#'+attrGorupName+'--draw_breakdown_count'+uniqueId).val();
	otherCount = Number(otherCount)+1;
	var debugData = '';
	var uniqueWCount = uniqueId+'--'+otherCount;
  if(debugMode){
    debugData ='<td class="text-center">'+typeId+'</td><td class="text-center"></td>';
	}
	//  onchange="onChangeBDVal(this, "manage_draw--breakdown_base", "'+uniqueWCount+'", $jsOptionJson)
	htmlContent = '<tr id="record_container--removable_draw--breakdown'+uniqueWCount+'"><td><input type="hidden" id="manage_draw--draw_breakdown_id'+uniqueWCount+'" value=""/><input class="breakDownTxt" onchange="onChangeBDVal(this, &quot;manage_draw--breakdown_base&quot;, &quot;'+uniqueWCount+'&quot;, {&quot;drawItemId&quot;:'+uniqueId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;drawBreakdownId&quot;:0, &quot;uniqueId&quot;:'+otherCount+'})"  id="manage_draw--breakdown_base'+uniqueWCount+'" onkeypress="return isNumberKey(this, event)"  type="text" value="" /></td><td><input class="breakDownTxt" id="manage_draw--breakdown_item$uniqueId" type="text" onchange="onChangeBDVal(this, &quot;manage_draw--breakdown_item&quot;, &quot;'+uniqueWCount+'&quot;, {&quot;drawItemId&quot;:'+uniqueId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;drawBreakdownId&quot;:0, &quot;uniqueId&quot;:'+otherCount+'})" value=""/></td><td><input class="breakDownTxt" id="manage_draw--breakdown_prev$uniqueId" type="text" onchange="onChangeBDVal(this, &quot;manage_draw--breakdown_prev&quot;, &quot;'+uniqueWCount+'&quot;, {&quot;drawItemId&quot;:'+uniqueId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;drawBreakdownId&quot;:0, &quot;uniqueId&quot;:'+otherCount+'})" value="" /></td><td><input class="breakDownTxt" id="manage_draw--breakdown_curr$uniqueId" onkeypress="return isNumberKey(this, event)"  type="text" onchange="onChangeBDVal(this, &quot;manage_draw--breakdown_curr&quot;, &quot;'+uniqueWCount+'&quot;, {&quot;drawItemId&quot;:'+uniqueId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;drawBreakdownId&quot;:0, &quot;uniqueId&quot;:'+otherCount+'})" value=""/></td><td><a class="cursorPoint" onclick="removeRowBreakdown(&quot;record_container--removable_draw--breakdown&quot;,&quot;manage_draw--draw_breakdown_id&quot;, &quot;'+uniqueWCount+'&quot;,'+debugMode+')"><span class="entypo-cancel-circled"></span></a></td></tr></tr>';
	// htmlContenttmp =
	// '<tr id="record_container--removable_draw--Other'+otherCount+'--'+typeId+'">'+debugData+'<td id="manage_draw--draw_signature_type--include" class="text-center"><input type="hidden" id="manage_draw--signature_block_id--Other'+otherCount+'--'+typeId+'" onchange="onClickIncludeBlock(this, &quot;manage_draw--signature_block_id&quot;, &quot;Other'+otherCount+'&quot;, {&quot;signatureTypeId&quot;:'+typeId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;signatureBlockId&quot;:0})" value="0"><input type="checkbox" id="manage_draw--signature_include--Other'+otherCount+'--'+typeId+'" onchange="onClickIncludeBlock(this, &quot;manage_draw--signature_include&quot;, &quot;Other'+otherCount+'&quot;, {&quot;signatureTypeId&quot;:'+typeId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;signatureBlockId&quot;:0})"></td><td>Other:</td><td><input id="manage_draw--signature_desc_udate_flag--Other'+otherCount+'--'+typeId+'" type="hidden" value="N"><input id="manage_draw--signature_name--Other'+otherCount+'--'+typeId+'" class="readOnly" type="text" onchange="onClickIncludeBlock(this, &quot;manage_draw--signature_block_id&quot;, &quot;Other'+otherCount+'&quot;, {&quot;signatureTypeId&quot;:'+typeId+',&quot;projectId&quot;:'+projectId+',&quot;drawId&quot;:'+drawId+',&quot;signatureBlockId&quot;:0})"  onfocusout="checkValueISNull(this, &quot;manage_draw--signature_include&quot;, &quot;Other'+otherCount+'&quot;, &quot;'+typeId+'&quot;)" readonly="readonly" value=""></td><td><a class="cursorPoint" onclick="removeRowSB(&quot;record_container--removable_draw&quot;,&quot;manage_draw--signature_block_id&quot;, &quot;Other'+otherCount+'&quot;,'+typeId+','+debugMode+')"><span class="entypo-cancel-circled"></span></a></td></tr>'
	// ;
	$('#breakdownTableContentBody'+uniqueId).append(htmlContent);
	$('#'+attrGorupName+'--draw_breakdown_count--'+uniqueId).val(otherCount);
}

function removeRowBreakdown(attrGorupName, attributeGroupName, uniqueId, debugMode){
	var row = $('#'+attrGorupName+uniqueId);
	var breakdownId = $('#'+attributeGroupName+uniqueId).val();
	breakdownId = Number(breakdownId);
	if(breakdownId) {
		removeBreakDownRow(breakdownId);
	}
	row.remove();
}

function isNumberKey(element, evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
    && (charCode < 48 || charCode > 57)){
     return false;
    }
    var thisVal = $(element).val();
 	var textArr = thisVal.split('.');  
    if (textArr.length > 1 && charCode==46) {
      return false;
    }
  return true;
}

// Retention action values
function retchangeSubOptionVal(element,retTemplateId) {
	//  Debug
	// return
	try {
		var data = $(element).val();
		var option_text = $("#manage_retention--select_action_type option:selected").text();
		

		if(data) {
			data = data.split('--');
			var downPdf = data[2];
			var downxlsx = data[3];
			var actionTypeId = data[0];
			var actionTypeOption = data[1];
			if(downPdf == 'Y'){
				$('.pdfDownload').css('display','block');
			} else {
				$('.pdfDownload').css('display','none');
			}
			if(downxlsx == 'Y'){
				$('.xlsxDownload').css('display','block');
			} else {
				$('.xlsxDownload').css('display','none');
			}
			if(actionTypeOption == 'Y'){
				$('#manage_retention--select_action_type_option').css('display','block');
			} else {
				$('#manage_retention--select_action_type_option').css('display','none');
			}

			if(actionTypeOption == 'Y' && downPdf == 'Y' && downxlsx == 'Y'){
				$('#manage_retention--select_action_type_option').val(retTemplateId);
			}else{
				$('#manage_retention--select_action_type_option').val('');
			}

			if(option_text =='Print Draw' || option_text == 'Export Excel'){
				$('#multiselectoption').css('display','block');
				//$('#export_option option[value="general_condition_summary"]').attr("selected", "selected");
			}else{
				$('#multiselectoption').css('display','none');
			}

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-draw-list-ajax.php?method=drawActionType';
			var ajaxQueryString =
			'draw_action_type_id=' + encodeURIComponent(actionTypeId);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: retActionTypeSuccess,
				error: errorHandler
			});


			$('.actionTypeDefault').css('display','none');
			$('.selectedActType_'+actionTypeId).prop('style','display: block');
		} else {
			$('.pdfDownload').css('display','none');
			$('.xlsxDownload').css('display','none');
			$('.actionTypeDefault').css('display','none');
			$('#manage_retention--select_action_type_option').css('display','block');
			$('#multiselectoption').css('display','none');
		}
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function retActionTypeSuccess(data){
	$("#manage_retention--select_action_type_option").html(data);
}

function onchangeSubOrderChangeValue() {
	$('#manage_retention--select_action_type_option').removeClass('redBorder');
}

//  generate pdf for retention draws
function clickToGenerateRetentionPdfBasedActionType() {
	var pathname = window.location.host; // Returns path only
	var http=window.location.protocol;
	var include_path='/';
	var full_path=http+pathname+include_path;
	var date=new Date();
	var retId = $('#manage_draw--draw_id').val();
	var retAppId = $('#manage_draw--draw_app_id').val();
	var actionTypeIdData = $('#manage_retention--select_action_type').val();
	var architectureBlock = false;
	var narrative_flag = false;
    var general_condition_flag = false;
    var cost_code_alias = false;

    var report_option = $('#export_option').val();
    if (report_option) {    	
    	if (Object.values(report_option).indexOf('general_condition_summary') > -1) {
		   general_condition_flag = true;
		};
		if (Object.values(report_option).indexOf('narrative_column') > -1) {
		   narrative_flag = true;
		};
		if (Object.values(report_option).indexOf('cost_code_alias') > -1) {
		   cost_code_alias = true;
		};
    } 
  
	
	if($("input[id^='manage_draw--signature_include--Architect']").is(':checked')){
		architectureBlock = true;
	}


	if(actionTypeIdData) {
		var data = actionTypeIdData.split('--');
		var downPdf = data[2];
		var downxlsx = data[3];
		var actionTypeId = data[0];
		var actionTypeOption = data[1];
		if(actionTypeOption == 'Y'){
			var actionTypeOptionId = $('#manage_retention--select_action_type_option').val();
			if(actionTypeOptionId == '') {
				$('#manage_retention--select_action_type_option').addClass('redBorder');
				messageAlert('Please select action type', 'errorMessage');
				return;
			}
		} else {
			var actionTypeOptionId = '';
		}
	} else {
		var actionTypeId = '';
		var actionTypeOptionId = '';
		return;
	}
	if((general_condition_flag == true || narrative_flag == true) && actionTypeId == '2' && (actionTypeOptionId == '5' || actionTypeOptionId == '6') ){

		$.get('draw_signature_block-ajax.php',{'method':'checkretentiondrawdownload','narrative_flag':narrative_flag,'general_condition_flag':general_condition_flag,'ret_id':retId,'type':'pdf'},function(data){
			console.log(data);
			if($.trim(data) =='N' && narrative_flag == true){
				messageAlert('No Narrative Column Exists', 'errorMessage');
				return false;		
			}else if($.trim(data) =='N' && general_condition_flag == true){
				messageAlert('Please group all the divisions in the Master Cost Codes list in Budget.', 'errorMessage');
				return false;		
			
			}else{
				var formValues="ret_id="+retId+"&ret_app_id="+retAppId+"&draw_action_type_id="+actionTypeId+"&draw_action_type_option_id="+actionTypeOptionId+"&architectureBlock="+architectureBlock+'&narrative_flag='+narrative_flag+'&general_condition_flag='+general_condition_flag+'&cost_code_alias='+cost_code_alias;
				if(actionTypeId == '2' && actionTypeOptionId == '5') {
					// clickToGenerateDraw();
					var linktogenerate='retention-print-email-notification.php?'+formValues;
					// return;
				} else if(actionTypeId == '2' && actionTypeOptionId == '6') { 
					var linktogenerate='retention-print-email-notification2.php?'+formValues;
				} else {
					var linktogenerate='retention-print-pdf-action-type.php?'+formValues;
				}
				document.location = linktogenerate;
			}
		});
		
		
	}else{
		var formValues="ret_id="+retId+"&ret_app_id="+retAppId+"&draw_action_type_id="+actionTypeId+"&draw_action_type_option_id="+actionTypeOptionId+"&architectureBlock="+architectureBlock+'&narrative_flag='+narrative_flag+'&general_condition_flag='+general_condition_flag+'&cost_code_alias='+cost_code_alias;
		if(actionTypeId == '2' && actionTypeOptionId == '5') {
			// clickToGenerateDraw();
			var linktogenerate='retention-print-email-notification.php?'+formValues;
			// return;
		} else if(actionTypeId == '2' && actionTypeOptionId == '6') { 
			var linktogenerate='retention-print-email-notification2.php?'+formValues;
		} else {
			var linktogenerate='retention-print-pdf-action-type.php?'+formValues;
		}
		document.location = linktogenerate;	
	}
	
}

