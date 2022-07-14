/* Draw Signature Block*/

function createOrUpdateSignatureBlock(element, attributeGroupName, inputAttributGroupName,options){	
	// Debug
	//return;
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);
		// alert(JSON.stringify(options));
		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		if (!optionsObjectIsEmpty && options.signatureTypeId) {
			var signatureTypeId = options.signatureTypeId;
		} else {
			var signatureTypeId = null;
		}

		if (!optionsObjectIsEmpty && options.projectId) {
			var projectId = options.projectId;
		} else {
			var projectId = null;
		}

		if (!optionsObjectIsEmpty && options.drawId) {
			var drawId = options.drawId;
		} else {
			var drawId = null;
		}

		if (!optionsObjectIsEmpty && options.signatureBlockId) {
			var signatureBlockId = options.signatureBlockId;
		} else {
			var signatureBlockId = null;
		}
		

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'Y';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'draw_signature_block-ajax.php?method=CreateOrUpdate';
		}

		if (attributeGroupName != 'manage_draw--signature_include') {
			var checked = true;
		} else {
			var checked = $(element).is(':checked') || false;
		}

		if(signatureTypeId == 5 && checked){
			$('.'+inputAttributGroupName).removeClass('displayNone');
		} else {
			$('.'+inputAttributGroupName).addClass('displayNone');
		}

		if (checked) {
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeAttr('readonly','readonly');
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeClass('readOnly');
			
			var enable_flag = 'Y';
		} else {
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).prop('readonly','readonly');
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).addClass('readOnly');
			var enable_flag = 'N';
		}
		var descUpdateFlag = $('#manage_draw--signature_desc_udate_flag'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		if (attributeGroupName != 'manage_draw--signature_name') {
			var description = $('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeClass('redBorder');
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).focus();
		} else {
			var description = $(element).val();
			descUpdateFlag = 'Y';
			$('#manage_draw--signature_desc_udate_flag'+'--'+inputAttributGroupName+'--'+signatureTypeId).val('Y')
			if(description=='' || description=='null'){
				$(element).addClass('redBorder');
			} else {
				$(element).removeClass('redBorder');
			}
		}
		if ( (descUpdateFlag == 'N' && signatureTypeId==1) || ( descUpdateFlag == 'N' && signatureTypeId == 2))
		{
			description = 'NULL';
		}
		if (!signatureBlockId) {
			signatureBlockId =  $('#manage_draw--signature_block_id'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		}
   		// $("." + checkboxClass).prop('checked', checked);
   		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
   		var ajaxQueryString =
   		'signature_type_id=' + encodeURIComponent(signatureTypeId) +
   		'&project_id=' + encodeURIComponent(projectId) +
   		'&draw_id=' + encodeURIComponent(drawId) +
   		'&signature_block_id=' + encodeURIComponent(signatureBlockId) +
   		'&enable_flag=' + encodeURIComponent(enable_flag) +
   		'&description=' + encodeURIComponent(description) +
   		'&attributeSubgroupName=' + encodeURIComponent(inputAttributGroupName) +
   		'&attributeGroupName=' + encodeURIComponent(attributeGroupName) +
   		'&desc_update_flag=' + encodeURIComponent(descUpdateFlag);
   		
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
		/*if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}*/

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateSignatureBlock,
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
// Signature Block Success
function updateSignatureBlock(data, textStatus, jqXHR){
	var SigBlockId = data.uniqueId;
	var attributeGroupNameRaw = data.attributeGroupName;
	var attributeGroupName = data.attributeGroupName.split('--');
	var inputAttributGroupName = data.attributeSubgroupName;
	var signatureTypeId = data.dummyId;
	var errorNumber = data.errorNumber;
	var checkValNull = $('#'+attributeGroupNameRaw+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
	if(errorNumber == 0){
		// alert('#'+attributeGroupName+'--'+inputAttributGroupName+'--'+signatureTypeId);
		if (checkValNull != '' && attributeGroupName[1] == 'signature_name') {
			var messageText = 'Draw Signature Block Updated Successfully';
			messageAlert(messageText, 'successMessage');
		}		
	} else {
		var messageText = data.errorMessage;
		messageAlert(messageText, 'errorMessage');	
	}	
	$('#'+attributeGroupName[0]+'--signature_block_id--'+inputAttributGroupName+'--'+signatureTypeId).val(SigBlockId);

	// $('#'+attributeGroupName+inputAttributGroupName+'--'+signatureTypeId).val(SigBlockId);
	// var checkDrawBlock = $('#'+attributeGroupName+'--'+inputAttributGroupName+'--'+signatureTypeId).is(':checked') || false;
	// manage_draw--signature_name--Architect1--3
}
//Retention signature block
function createOrUpdateRetentionSignatureBlock(element, attributeGroupName, inputAttributGroupName,options){	
	// Debug
	//return;
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);
		// alert(JSON.stringify(options));
		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		if (!optionsObjectIsEmpty && options.signatureTypeId) {
			var signatureTypeId = options.signatureTypeId;
		} else {
			var signatureTypeId = null;
		}

		if (!optionsObjectIsEmpty && options.projectId) {
			var projectId = options.projectId;
		} else {
			var projectId = null;
		}

		if (!optionsObjectIsEmpty && options.drawId) {
			var drawId = options.drawId;
		} else {
			var drawId = null;
		}

		if (!optionsObjectIsEmpty && options.signatureBlockId) {
			var signatureBlockId = options.signatureBlockId;
		} else {
			var signatureBlockId = null;
		}
		

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'Y';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'draw_signature_block-ajax.php?method=RetentionCreateOrUpdate';
		}

		if (attributeGroupName != 'manage_draw--signature_include') {
			var checked = true;
		} else {
			var checked = $(element).is(':checked') || false;
		}

		if(signatureTypeId == 5 && checked){
			$('.'+inputAttributGroupName).removeClass('displayNone');
		} else {
			$('.'+inputAttributGroupName).addClass('displayNone');
		}

		if (checked) {
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeAttr('readonly','readonly');
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeClass('readOnly');
			
			var enable_flag = 'Y';
		} else {
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).prop('readonly','readonly');
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).addClass('readOnly');
			var enable_flag = 'N';
		}
		var descUpdateFlag = $('#manage_draw--signature_desc_udate_flag'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		if (attributeGroupName != 'manage_draw--signature_name') {
			var description = $('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeClass('redBorder');
			$('#manage_draw--signature_name'+'--'+inputAttributGroupName+'--'+signatureTypeId).focus();
		} else {
			var description = $(element).val();
			descUpdateFlag = 'Y';
			$('#manage_draw--signature_desc_udate_flag'+'--'+inputAttributGroupName+'--'+signatureTypeId).val('Y')
			if(description=='' || description=='null'){
				$(element).addClass('redBorder');
			} else {
				$(element).removeClass('redBorder');
			}
		}
		if ( (descUpdateFlag == 'N' && signatureTypeId==1) || ( descUpdateFlag == 'N' && signatureTypeId == 2))
		{
			description = 'NULL';
		}
		if (!signatureBlockId) {
			signatureBlockId =  $('#manage_draw--signature_block_id'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		}
   		// $("." + checkboxClass).prop('checked', checked);
   		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
   		var ajaxQueryString =
   		'signature_type_id=' + encodeURIComponent(signatureTypeId) +
   		'&project_id=' + encodeURIComponent(projectId) +
   		'&retention_draw_id=' + encodeURIComponent(drawId) +
   		'&signature_block_id=' + encodeURIComponent(signatureBlockId) +
   		'&enable_flag=' + encodeURIComponent(enable_flag) +
   		'&description=' + encodeURIComponent(description) +
   		'&attributeSubgroupName=' + encodeURIComponent(inputAttributGroupName) +
   		'&attributeGroupName=' + encodeURIComponent(attributeGroupName) +
   		'&desc_update_flag=' + encodeURIComponent(descUpdateFlag);
   		
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
		/*if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}*/

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateretSignatureBlock,
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
// Retention Signature Block Success
function updateretSignatureBlock(data, textStatus, jqXHR){
	var SigBlockId = data.uniqueId;
	var attributeGroupNameRaw = data.attributeGroupName;
	var attributeGroupName = data.attributeGroupName.split('--');
	var inputAttributGroupName = data.attributeSubgroupName;
	var signatureTypeId = data.dummyId;
	var errorNumber = data.errorNumber;
	var checkValNull = $('#'+attributeGroupNameRaw+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
	if(errorNumber == 0){
		// alert('#'+attributeGroupName+'--'+inputAttributGroupName+'--'+signatureTypeId);
		if (checkValNull != '' && attributeGroupName[1] == 'signature_name') {
			var messageText = 'Retention Signature Block Updated Successfully';
			messageAlert(messageText, 'successMessage');
		}		
	} else {
		var messageText = data.errorMessage;
		messageAlert(messageText, 'errorMessage');	
	}	
	$('#'+attributeGroupName[0]+'--signature_block_id--'+inputAttributGroupName+'--'+signatureTypeId).val(SigBlockId);


}

/* Draw Signature Block Construction Lender*/

function createOrUpdateSignatureBlockCL(element, attributeGroupName, inputAttributGroupName,options){	
	// Debug
	//return;
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);
		// alert(JSON.stringify(options));
		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		if (!optionsObjectIsEmpty && options.signatureTypeId) {
			var signatureTypeId = options.signatureTypeId;
		} else {
			var signatureTypeId = null;
		}

		if (!optionsObjectIsEmpty && options.projectId) {
			var projectId = options.projectId;
		} else {
			var projectId = null;
		}

		if (!optionsObjectIsEmpty && options.drawId) {
			var drawId = options.drawId;
		} else {
			var drawId = null;
		}

		if (!optionsObjectIsEmpty && options.signatureBlockId) {
			var signatureBlockId = options.signatureBlockId;
		} else {
			var signatureBlockId = null;
		}
		
		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'draw_signature_block-ajax.php?method=CreateOrUpdateCL';
		}

		var address1 = $('#manage_draw--signature_address1'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		if(address1=='' || address1=='null'){
			$('#manage_draw--signature_address1'+'--'+inputAttributGroupName+'--'+signatureTypeId).addClass('redBorder');
		} else {
			$('#manage_draw--signature_address1'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeClass('redBorder');
		}
		var address2 = $('#manage_draw--signature_address2'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		if(address2=='' || address2=='null'){
			$('#manage_draw--signature_address2'+'--'+inputAttributGroupName+'--'+signatureTypeId).addClass('redBorder');
		} else {
			$('#manage_draw--signature_address2'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeClass('redBorder');
		}
		var city_state_zip = $('#manage_draw--signature_city'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();

		if(city_state_zip=='' || city_state_zip=='null'){
			$('#manage_draw--signature_city'+'--'+inputAttributGroupName+'--'+signatureTypeId).addClass('redBorder');
		} else {
			$('#manage_draw--signature_city'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeClass('redBorder');
		}

		if (!signatureBlockId) {
			signatureBlockId =  $('#manage_draw--signature_block_id'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		}
		// if (!signatureBlockCLId) {
		var signatureBlockCLId =  $('#manage_draw--signature_cl_id'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		// var otherCount = $('#manage_draw--signature_block_count--Other1--'+typeId).val();
		// if(signatureTypeId == 6 && Number(otherCount) == 0){
		// 	otherCount = Number(otherCount)+1;
		// 	$('#manage_draw--signature_block_count--Other1--'+typeId).val(otherCount);
		// }
		
		
		// }
   		// $("." + checkboxClass).prop('checked', checked);
   		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
   		var ajaxQueryString =
   		'signature_type_id=' + encodeURIComponent(signatureTypeId) +
   		'&signature_cl_id=' + encodeURIComponent(signatureBlockCLId) +
   		'&signature_block_id=' + encodeURIComponent(signatureBlockId) +
   		'&attributeSubgroupName=' + encodeURIComponent(inputAttributGroupName) +
   		'&attributeGroupName=' + encodeURIComponent(attributeGroupName) +
   		'&address_1=' + encodeURIComponent(address1) +
   		'&address_2=' + encodeURIComponent(address2) +
   		'&city_state_zip=' + encodeURIComponent(city_state_zip);
   		
   		
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
		/*if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}*/

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateSignatureBlockCL,
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
// Signature Block Success
function updateSignatureBlockCL(data, textStatus, jqXHR){
	var SigBlockId = data.uniqueId;
	var attributeGroupNameRaw = data.attributeGroupName;
	var attributeGroupName = data.attributeGroupName.split('--');
	var inputAttributGroupName = data.attributeSubgroupName;
	var signatureTypeId = data.dummyId;
	var errorNumber = data.errorNumber;
	var checkValNull = $('#'+attributeGroupNameRaw+'--'+inputAttributGroupName+'--'+signatureTypeId).val();

	$('#'+attributeGroupName[0]+'--signature_cl_id--'+inputAttributGroupName+'--'+signatureTypeId).val(SigBlockId);

	if(errorNumber == 0){
		// alert('#'+attributeGroupName+'--'+inputAttributGroupName+'--'+signatureTypeId);
		if (checkValNull != '' && attributeGroupName[1] != 'signature_include') {
			var messageText = 'Draw Signature Block Updated Successfully';
			messageAlert(messageText, 'successMessage');
		}		
	} else {
		var messageText = data.errorMessage;
		messageAlert(messageText, 'errorMessage');	
	}	
	// var checkDrawBlock = $('#'+attributeGroupName+'--'+inputAttributGroupName+'--'+signatureTypeId).is(':checked') || false;
	// manage_draw--signature_name--Architect1--3
}
/* Retention Signature Block Construction Lender*/

function createOrUpdateRetSignatureBlockCL(element, attributeGroupName, inputAttributGroupName,options){	
	// Debug
	//return;
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);
		// alert(JSON.stringify(options));
		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		if (!optionsObjectIsEmpty && options.signatureTypeId) {
			var signatureTypeId = options.signatureTypeId;
		} else {
			var signatureTypeId = null;
		}

		if (!optionsObjectIsEmpty && options.projectId) {
			var projectId = options.projectId;
		} else {
			var projectId = null;
		}

		if (!optionsObjectIsEmpty && options.drawId) {
			var drawId = options.drawId;
		} else {
			var drawId = null;
		}

		if (!optionsObjectIsEmpty && options.signatureBlockId) {
			var signatureBlockId = options.signatureBlockId;
		} else {
			var signatureBlockId = null;
		}
		
		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'draw_signature_block-ajax.php?method=CreateOrUpdateRetentionCL';
		}

		var address1 = $('#manage_draw--signature_address1'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		if(address1=='' || address1=='null'){
			$('#manage_draw--signature_address1'+'--'+inputAttributGroupName+'--'+signatureTypeId).addClass('redBorder');
		} else {
			$('#manage_draw--signature_address1'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeClass('redBorder');
		}
		var address2 = $('#manage_draw--signature_address2'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		if(address2=='' || address2=='null'){
			$('#manage_draw--signature_address2'+'--'+inputAttributGroupName+'--'+signatureTypeId).addClass('redBorder');
		} else {
			$('#manage_draw--signature_address2'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeClass('redBorder');
		}
		var city_state_zip = $('#manage_draw--signature_city'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();

		if(city_state_zip=='' || city_state_zip=='null'){
			$('#manage_draw--signature_city'+'--'+inputAttributGroupName+'--'+signatureTypeId).addClass('redBorder');
		} else {
			$('#manage_draw--signature_city'+'--'+inputAttributGroupName+'--'+signatureTypeId).removeClass('redBorder');
		}

		if (!signatureBlockId) {
			signatureBlockId =  $('#manage_draw--signature_block_id'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		}
		// if (!signatureBlockCLId) {
		var signatureBlockCLId =  $('#manage_draw--signature_cl_id'+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
		// var otherCount = $('#manage_draw--signature_block_count--Other1--'+typeId).val();
		// if(signatureTypeId == 6 && Number(otherCount) == 0){
		// 	otherCount = Number(otherCount)+1;
		// 	$('#manage_draw--signature_block_count--Other1--'+typeId).val(otherCount);
		// }
		
		
		// }
   		// $("." + checkboxClass).prop('checked', checked);
   		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
   		var ajaxQueryString =
   		'signature_type_id=' + encodeURIComponent(signatureTypeId) +
   		'&signature_cl_id=' + encodeURIComponent(signatureBlockCLId) +
   		'&signature_block_id=' + encodeURIComponent(signatureBlockId) +
   		'&attributeSubgroupName=' + encodeURIComponent(inputAttributGroupName) +
   		'&attributeGroupName=' + encodeURIComponent(attributeGroupName) +
   		'&address_1=' + encodeURIComponent(address1) +
   		'&address_2=' + encodeURIComponent(address2) +
   		'&city_state_zip=' + encodeURIComponent(city_state_zip);
   		
   		
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
		/*if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}*/

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateRetSignatureBlockCL,
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
// Retention Signature Block construction lender Success
function updateRetSignatureBlockCL(data, textStatus, jqXHR){
	var SigBlockId = data.uniqueId;
	var attributeGroupNameRaw = data.attributeGroupName;
	var attributeGroupName = data.attributeGroupName.split('--');
	var inputAttributGroupName = data.attributeSubgroupName;
	var signatureTypeId = data.dummyId;
	var errorNumber = data.errorNumber;
	var checkValNull = $('#'+attributeGroupNameRaw+'--'+inputAttributGroupName+'--'+signatureTypeId).val();

	$('#'+attributeGroupName[0]+'--signature_cl_id--'+inputAttributGroupName+'--'+signatureTypeId).val(SigBlockId);

	if(errorNumber == 0){
		// alert('#'+attributeGroupName+'--'+inputAttributGroupName+'--'+signatureTypeId);
		if (checkValNull != '' && attributeGroupName[1] != 'signature_include') {
			var messageText = 'Retention Signature Block Updated Successfully';
			messageAlert(messageText, 'successMessage');
		}		
	} else {
		var messageText = data.errorMessage;
		messageAlert(messageText, 'errorMessage');	
	}	
	// var checkDrawBlock = $('#'+attributeGroupName+'--'+inputAttributGroupName+'--'+signatureTypeId).is(':checked') || false;
	// manage_draw--signature_name--Architect1--3
}

//  remove the signature block using id
function removeSignatureBlockOther(signBlockId){
	var ajaxHandlerScript = 'draw_signature_block-ajax.php?method=DeleteSignatureBlockOtherType';
	var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
   		var ajaxQueryString =
   		'signature_block_id=' + encodeURIComponent(signBlockId);
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: deleteSignatureBlockOther,
		error: errorHandler
	});
}
// success of delete signature block other
function deleteSignatureBlockOther(data, textStatus, jqXHR) {
	var messageText = 'Draw signature block deleted successfully';
	messageAlert(messageText, 'successMessage');
}
//  remove the signature block using id
function removeRetentionSignatureBlockOther(signBlockId){
	var ajaxHandlerScript = 'draw_signature_block-ajax.php?method=DeleteRetentionSignatureBlockOtherType';
	var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
   		var ajaxQueryString =
   		'signature_block_id=' + encodeURIComponent(signBlockId);
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: deleteRetentionSignatureBlockOther,
		error: errorHandler
	});
}
// success of delete signature block other
function deleteRetentionSignatureBlockOther(data, textStatus, jqXHR) {
	var messageText = 'Retention signature block deleted successfully';
	messageAlert(messageText, 'successMessage');
}

/* Draw Breakdown Block*/
function createOrUpdateBreakdown(element, attributeGroupName, inputAttributGroupName,options){	
	// Debug
	//return;
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);
		// alert(JSON.stringify(options));
		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		if (!optionsObjectIsEmpty && options.projectId) {
			var projectId = options.projectId;
		} else {
			var projectId = null;
		}

		if (!optionsObjectIsEmpty && options.drawId) {
			var drawId = options.drawId;
		} else {
			var drawId = null;
		}

		if (!optionsObjectIsEmpty && options.drawBreakdownId) {
			var drawBreakdownId = options.drawBreakdownId;
		} else {
			var drawBreakdownId = null;
		}
		
		if (!optionsObjectIsEmpty && options.drawItemId) {
			var drawItemId = options.drawItemId;
		} else {
			var drawItemId = null;
		}

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'Y';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'draw_signature_block-ajax.php?method=CreateOrUpdateBreakdown';
		}

		if (attributeGroupName != 'manage_draw--breakdown_base') {
			var breakdown_base = $('#manage_draw--breakdown_base'+inputAttributGroupName).val();
		} else {
			var breakdown_base = $(element).val();
			var breakdown_base_format = breakdown_base.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
			breakdown_base_format = parseInputToCurrency(breakdown_base);			
			$(element).val(breakdown_base_format);
		}
		if (attributeGroupName != 'manage_draw--breakdown_item') {
			var breakdown_item = $('#manage_draw--breakdown_item'+inputAttributGroupName).val();
		} else {
			var breakdown_item = $(element).val();
		}
		if (attributeGroupName != 'manage_draw--breakdown_prev') {
			var breakdown_prev = $('#manage_draw--breakdown_prev'+inputAttributGroupName).val();
		} else {
			var breakdown_prev = $(element).val();
			var breakdown_base_format = breakdown_base.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
			breakdown_base_format = parseInputToCurrency(breakdown_base);			
			$(element).val(breakdown_base_format);
		}
		if (attributeGroupName != 'manage_draw--breakdown_curr') {
			var breakdown_curr = $('#manage_draw--breakdown_curr'+inputAttributGroupName).val();
		} else {
			var breakdown_curr = $(element).val();
			var breakdown_curr_format = breakdown_curr.toLocaleString('en-US', {maximumFractionDigits: 2, style: 'currency', currency: 'USD'});
			breakdown_curr_format = parseInputToCurrency(breakdown_curr);			
			$(element).val(breakdown_curr_format);
		}

		if (!drawBreakdownId) {
			
			drawBreakdownId =  $('#manage_draw--draw_breakdown_id'+inputAttributGroupName).val();
		}
		// breakdown_base = parseInputToCurrency(breakdown_base);
		// breakdown_prev = parseInputToCurrency(breakdown_base);
		// breakdown_curr = parseInputToCurrency(breakdown_curr);
   		// $("." + checkboxClass).prop('checked', checked);
   		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
   		var ajaxQueryString =
   		'draw_breakdown_id=' + encodeURIComponent(drawBreakdownId) +
   		'&project_id=' + encodeURIComponent(projectId) +
   		'&draw_item_id=' + encodeURIComponent(drawItemId) +
   		'&base_per=' + encodeURIComponent(breakdown_base) +
   		'&item=' + encodeURIComponent(breakdown_item) +
   		'&current_per=' + encodeURIComponent(breakdown_curr)+
   		'&attributeSubgroupName=' + encodeURIComponent(inputAttributGroupName) +
   		'&attributeGroupName=' + encodeURIComponent(attributeGroupName);
   		// alert('#manage_draw--draw_breakdown_id'+inputAttributGroupName);
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
		/*if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}*/

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: updateBreakdownBlock,
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
// Signature Block Success
function updateBreakdownBlock(data, textStatus, jqXHR){
	var SigBlockId = data.uniqueId;
	var attributeGroupNameRaw = data.attributeGroupName;
	var attributeGroupName = data.attributeGroupName.split('--');
	var inputAttributGroupName = data.attributeSubgroupName;
	var signatureTypeId = data.dummyId;
	var errorNumber = data.errorNumber;
	var htmlRecord = data.htmlRecord;
	var checkValNull = $('#'+attributeGroupNameRaw+'--'+inputAttributGroupName+'--'+signatureTypeId).val();
	
	if(errorNumber == 0){
		// alert('#'+attributeGroupName+'--'+inputAttributGroupName+'--'+signatureTypeId);
		// if (checkValNull != '' && attributeGroupName[1] == 'signature_name') {
			var splitId = inputAttributGroupName.split('--');
			$('#breakdownTableContentBodyTotal'+splitId[0]).empty().html(htmlRecord);
			var messageText = 'Draw Breakdown Updated Successfully';
			messageAlert(messageText, 'successMessage');
		// }
	} else {
		var messageText = data.errorMessage;
		messageAlert(messageText, 'errorMessage');	
	}	
	$('#'+attributeGroupName[0]+'--draw_breakdown_id'+inputAttributGroupName).val(SigBlockId);

	// $('#'+attributeGroupName+inputAttributGroupName+'--'+signatureTypeId).val(SigBlockId);
	// var checkDrawBlock = $('#'+attributeGroupName+'--'+inputAttributGroupName+'--'+signatureTypeId).is(':checked') || false;
	// manage_draw--signature_name--Architect1--3
}
//  remove the breakdown using id
function removeBreakDownRow(breakdownId){
	var ajaxHandlerScript = 'draw_signature_block-ajax.php?method=DeleteBreakdownRow';
	var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
   		var ajaxQueryString =
   		'draw_breakdown_id=' + encodeURIComponent(breakdownId);
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: removeBreakDownRowSuccess,
		error: errorHandler
	});
}
// success of delete breakdown
function removeBreakDownRowSuccess(data, textStatus, jqXHR) {
	var messageText = 'Draw Breakdown deleted successfully';
	messageAlert(messageText, 'successMessage');
}
/* QB - Start */
(function($) {
  	$(function() {
	    $('#export_option').fSelect({
	      numDisplayed: 1,
	      overflowText: '{n} selected'
	    });
	    var owner_name = $("#project_customer").val();
	    if($.trim(owner_name) !=''){
		    checkCustomerExist(owner_name);
	    }
    
	    //checkCustomerProjectExist(applicationNumber, owner_name);
	    $('#checkindicator').on('click',function(e){
			var owner_name = $("#project_customer").val();
			checkCustomerExist(owner_name);
			getProjectMappedCust();
			e.preventDefault();

	    });
	    // Check project 
	    $('#project_customer').on('change',function(){
			var owner_name = $("#project_customer").val();
			var drawId = $("#manage_draw--draw_id").val();
	      	checkCustomerExist(owner_name);
	      	if(owner_name){
	      		$.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
	      			{'action':'UpdateQBCustomerID','drawId':drawId,'owner_name':owner_name});
	      	}
	    });
	    $('#project_customer_retention').on('change',function(){
			var owner_name = $("#project_customer_retention").val();
			var drawId = $("#manage_draw--draw_id").val();
	      	checkCustomerExist(owner_name);
	      	if(owner_name){
	      		$.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
	      			{'action':'UpdateQBCustomerID','drawId':drawId,'owner_name':owner_name
	      			,'type':'retention'});
	      	}
	    });

  	});
})(jQuery);
function checkCustomerExist(owner_name){
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
function getProjectMappedCust(){
	$.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
		{'action':'getAllProjectCustomer'},function(data){
			// $("#project_customer").html($.trim(data));
			location.reload();
	});
}


/* QB - End */
