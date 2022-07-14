
$(document).ready(function() {
	addWidgets();
});
function NoDataToGenerate(){
	messageAlert('No more change for PDF generation', 'errorMessage');
}
function addWidgets()
{
	createUploaders();
}
function createJobsitePhoto(attributeGroupName, uniqueId, options)
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

		var valid = validateForm(attributeGroupName, uniqueId);
		if (!valid) {
			if (promiseChain) {
				var promise = getDummyRejectedPromise();
				return promise;
			} else {
				return;
			}
		}
		window.savePending = true;

		// create case attribute group - E.g. "create-project-record"
		attributeGroupName = $.trim(attributeGroupName);
		// Dummy ID placeholder (instead of a candidate key) - E.g. "dummy_id-5492a6d72da39"
		uniqueId = $.trim(uniqueId);

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Jobsite Photo';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Jobsite Photos';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-jobsite_photo-record';
			htmlRecordMetaAttributesOptions.attributeGroupName = attributeGroupName;
			htmlRecordMetaAttributesOptions.uniqueId = uniqueId;
			var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('create', htmlRecordMetaAttributesOptions);
		}

		var formattedAttributeGroupName 	= htmlRecordMetaAttributes.formattedAttributeGroupName;
		var formattedAttributeSubgroupName	= htmlRecordMetaAttributes.formattedAttributeSubgroupName;
		var newAttributeGroupName			= htmlRecordMetaAttributes.newAttributeGroupName;

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'Y';
		}

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'jobsite_photos';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'jobsite_photos-ajax.php?method=createJobsitePhoto';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
		'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
		'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
		'&sortOrderFlag=' + encodeURIComponent(sortOrderFlag) +
		'&uniqueId=' + encodeURIComponent(uniqueId) +
		'&newAttributeGroupName=' + encodeURIComponent(newAttributeGroupName) +
		'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
		'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName);

		if (!optionsObjectIsEmpty && options.skipBuildHtmlRecordAttributesAsAjaxQueryString) {
			var htmlRecordAttributesAsAjaxQueryString = '';
		} else {
			if (!optionsObjectIsEmpty && options.htmlRecordAttributeOptions) {
				htmlRecordAttributeOptions = options.htmlRecordAttributeOptions;
			} else {
				htmlRecordAttributeOptions = { };
			}
			var htmlRecordAttributesAsAjaxQueryString = buildJobsitePhotoHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
			var ajaxQueryString = ajaxQueryString + htmlRecordAttributesAsAjaxQueryString;
		}

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
			var arrSuccessCallbacks = [ defaultAjaxCallback_createSuccess ];
		}
		if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}
		alert(arrSuccessCallbacks);
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

function ImageLogoRefresh(arrFileManagerFiles){
	var oldlogo = $("#gc_logo").val();
	var logoDelete='';
	var deleteFlag = 'N';
	if(oldlogo!='')
	{
		logoDelete = oldlogo;
		deleteFlag = 'Y';
		UpdateLogoPhoto(logoDelete,arrFileManagerFiles);
	}
	for (var i = 0; i < arrFileManagerFiles.length; i++) {
		var fileManagerFile = arrFileManagerFiles[i];

		var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
		var virtual_file_path      = fileManagerFile.virtual_file_path;
		var file_manager_file_id   = fileManagerFile.file_manager_file_id;
		var virtual_file_name      = fileManagerFile.virtual_file_name;
		var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
		var ajaxQueryString = "image_manager_image_id="+file_manager_file_id+"&method=LoadLogo&logoDelete="+logoDelete+"&deleteFlag="+deleteFlag;
		var ajaxHandler = "image-photo-ajax.php";
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(html){	
				$("#record_list_container--manage-jobsite_photo-record").empty().append(html);
				$("#gc_logo").val(file_manager_file_id);
			},
			async:true,
			error: errorHandler
		});
	}
}
function deleteLogoPhoto(id)
{
	// Debug
	//return;
	var file_manager_file_id = id;
	var ajaxQueryString = "image_manager_image_id="+file_manager_file_id+"&method=deleteJobsitePhoto&cur_manager_file_id=";
	var ajaxHandler = "image-photo-ajax.php";
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function(html){	
			$("#record_list_container--manage-jobsite_photo-record").empty().append(html);
			$("#gc_logo").val('');
		},
		error: errorHandler
	});
		// var errorMessage = error.message;
		// alert('Exception Thrown: ' + errorMessage);
	}
	function UpdateLogoPhoto(id,arrFileManagerFiles)
	{
	// Debug
	//return;
	var cur_manager_file_id   = '';
	for (var i = 0; i < arrFileManagerFiles.length; i++) {
		var fileManagerFile = arrFileManagerFiles[i];
		cur_manager_file_id   = fileManagerFile.file_manager_file_id;
	}
	var file_manager_file_id = id;
	var ajaxQueryString = "image_manager_image_id="+file_manager_file_id+"&method=deleteJobsitePhoto&cur_manager_file_id="+cur_manager_file_id;
	var ajaxHandler = "image-photo-ajax.php";
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		async:true,
		success: function(html){	
				// $("#record_list_container--manage-jobsite_photo-record").empty().append(html);
				// $("#gc-logo").val('');
			},
			error: errorHandler
		});
		// var errorMessage = error.message;
		// alert('Exception Thrown: ' + errorMessage);
	}
	function Daily_Log__ManPower__photoUploaded(arrFileManagerFiles)
	{
		try {

			var options = options || {};
			options.responseDataType = 'json';
			options.moduleName = 'Daily_Log';
			options.includeHtmlContent = 'Y';
			options.scenarioName = 'Daily_Log__ManPower__createJobsitePhoto';
			options.successCallback = Daily_Log__ManPower__createJobsitePhotoSuccess;

			for (var i = 0; i < arrFileManagerFiles.length; i++) {
				var fileManagerFile = arrFileManagerFiles[i];

				var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
				var virtual_file_path      = fileManagerFile.virtual_file_path;
				var file_manager_file_id   = fileManagerFile.file_manager_file_id;
				var virtual_file_name      = fileManagerFile.virtual_file_name;
				var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;

				var jobsite_daily_log_id = $("#jobsite_daily_log_id").val();
				var dummyId = generateDummyElementId();
				var recordContainerElementId = 'record_container--create-jobsite_photo-record--jobsite_photos--' + dummyId;
				var attributeGroupName = 'manage-jobsite_photo-record';

				var input1 = '<input id="' + attributeGroupName + '--jobsite_photos--jobsite_daily_log_id--' + dummyId + '" type="hidden" value="' + jobsite_daily_log_id + '">';
				var input2 = '<input id="' + attributeGroupName + '--jobsite_photos--jobsite_photo_file_manager_file_id--' + dummyId + '" type="hidden" value="' + file_manager_file_id + '">';
				var htmlRecordLi = '<li id="' + recordContainerElementId + '" class="hidden">' + input1 + input2 + '</li>';

				$("#record_list_container--" + attributeGroupName).append(htmlRecordLi);

				createJobsitePhoto(attributeGroupName, dummyId, options);
			}

		} catch(error) {

			if (window.showJSExceptions) {
				var errorMessage = error.message;
				alert('Exception Thrown: ' + errorMessage);
				return;
			}

		}
	}

	function Daily_Log__ManPower__createJobsitePhotoSuccess(data, textStatus, jqXHR)
	{
		try {

			var json = data;
			var errorNumber = json.errorNumber;

			if (errorNumber == 0) {
			var attributeGroupName = json.attributeGroupName; // E.g. "manage-project-record"
			var attributeSubgroupName = json.attributeSubgroupName; // E.g. "projects"
			var uniqueId = json.uniqueId; // New Id, E.g. "--1234"
			var previousAttributeGroupName = json.previousAttributeGroupName; // E.g. "create-project-record"
			var dummyId = json.dummyId; // Old pk/uk dummy placeholder
			var htmlRecordLi = json.htmlRecordLi;

			// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
			var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;
			var recordContainerElementIdOld = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + dummyId;

			$("#" + recordContainerElementIdOld).remove();
			$("#liUploadedPhotoPlaceholder").remove();
			$("#record_list_container--" + attributeGroupName).append(htmlRecordLi);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function initializePopovers()
{
	try {

		$("#btnAddJobsiteSiteworkActivityPopover").popover({
			html: true,
			placement: 'left',
			content: function() {
				var content = getPopoverContent(this, 'divAddJobsiteSiteworkActivityPopover');
				return content;
			}
		});

		$("#btnAddJobsiteBuildingActivityPopover").popover({
			html: true,
			placement: 'left',
			content: function() {
				var content = getPopoverContent(this, 'divAddJobsiteBuildingActivityPopover');
				return content;
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

function initializeTooltips()
{
	$('.entypo-check').on('mouseenter', function() {
		if ($(this).hasClass('inUse')) {
			$(this).removeClass('entypo-check');
			$(this).addClass('entypo-block');
		} else {
			$(this).removeClass('entypo-check');
			$(this).addClass('entypo-minus-circled');
		}

	});
	$('.entypo-check').on('mouseleave', function() {
		if ($(this).hasClass('inUse')) {
			$(this).removeClass('entypo-block');
			$(this).addClass('entypo-check');
		} else {
			$(this).removeClass('entypo-minus-circled');
			$(this).addClass('entypo-check');
		}

	});

	$('[title^="Add"], [title^="Remove"]').tooltip({
		//delay: { show: 250, hide: 0 }
	});
	$('[rel="tooltip"]').tooltip();
}

function hideTooltips()
{
	var tooltipElements = $('[rel="tooltip"]');
	tooltipElements.tooltip('hide');
}


function setTimeoutForSaveJobsiteManPower(attributeGroupName, uniqueId)
{
	clearTimeout(timerForSaveJobsiteManPower);
	timerForSaveJobsiteManPower = setTimeout(function() {
		saveJobsiteManPower(attributeGroupName, uniqueId);
	}, 500);
}

function jobsitePhotoFileManagerFileUploadComplete(id, name, responseJSON, xhr)
{
	var arrFileManagerFiles = responseJSON.fileMetadata;
	Daily_Log__ManPower__photoUploaded(arrFileManagerFiles);
	$("#uploaderJobsitePhotos .qq-upload-list li:last").fadeOut(1200);
}

function fileManagerFileUploadError(id, name, errorReason, xhr) {
	Console.log('fileManagerFileUploadError: ' + errorReason);
}

function removeFineUploaders()
{
	var arrUploaderElements = [];
	$(".qq-uploader").each(function() {
		var uploader = $(this).parent()[0];
		arrUploaderElements.push(uploader);
	});

	$(arrUploaderElements).fineUploader('destroy');
}
