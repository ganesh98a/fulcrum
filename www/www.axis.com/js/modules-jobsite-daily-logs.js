
var activeTab =  UrlVars.get('tab') || '1';
var activeSubtab = UrlVars.get('subtab') || 'project';
var activeSubsubtab = UrlVars.get('subsubtab') || null;

$(document).ready(function() {

	var selectedDateIndex = $("#selectedDateIndex").val();
	$("#ddlDate").val(selectedDateIndex);
	addWidgets();
	UpdateDaliytab()

	document.addEventListener("click", UpdateDaliytab);
	$(".bs-tooltip").tooltip();



});
function NoDataToGenerate(){
	messageAlert('No more change for PDF generation', 'errorMessage');
}
function addWidgets()
{
	createUploaders();

//	var jobsite_sign_in_sheet_file_manager_folder_id = $("#jobsite_sign_in_sheet_file_manager_folder_id").val();
//	var endpoint = '/modules-file-manager-file-uploader-ajax.php?folder_id=' + jobsite_sign_in_sheet_file_manager_folder_id;
//	var uploaderOptions = {
//		request: {
//			endpoint: endpoint
//		},
//		callbacks: {
//			onComplete: jobsiteSignInSheetFileManagerFileUploadComplete,
//			onError: fileManagerFileUploadError
//		},
//		validation: {
//			allowedExtensions: [ 'pdf' ]
//		}
//	};
//	$("#uploaderJobsiteSignInSheets").fineUploader(uploaderOptions);
//
//	var jobsite_field_report_file_manager_folder_id = $("#jobsite_field_report_file_manager_folder_id").val();
//	uploaderOptions.request.endpoint = '/modules-file-manager-file-uploader-ajax.php?folder_id=' + jobsite_field_report_file_manager_folder_id;
//	uploaderOptions.callbacks.onComplete = jobsiteFieldReportFileManagerFileUploadComplete;
//	$("#uploaderJobsiteFieldReports").fineUploader(uploaderOptions);
//
//	var jobsite_photo_file_manager_folder_id = $("#jobsite_photo_file_manager_folder_id").val();
//	uploaderOptions.request.endpoint = '/modules-file-manager-file-uploader-ajax.php?folder_id=' + jobsite_photo_file_manager_folder_id;
//	uploaderOptions.callbacks.onComplete = jobsitePhotoFileManagerFileUploadComplete;
//	$("#uploaderJobsitePhotos").fineUploader(uploaderOptions);



	updateManpowerTotal();
	addClickHandlers();
	$(".jdlAccordion").accordion({
		collapsible: true,
		heightStyle: 'content'
	});

	addSortableToJobsiteBuildingActivities();
	addSortableToJobsiteOffsiteworkActivities();
	addSortableToJobsiteSiteworkActivities();
	addSortableToJobsiteActivityLabels();

	Daily_Log__addDataTablesToJobsiteBuildingActivities();
	Daily_Log__addDataTablesToJobsiteOffsiteworkActivities();
	Daily_Log__addDataTablesToJobsiteSiteworkActivities();
	Daily_Log__addDataTablesToJobsiteActivityLabels();

	Daily_Log__addDataTablesToJobsiteBuildingActivityTemplates();
	Daily_Log__addDataTablesToJobsiteOffsiteworkActivityTemplates();
	Daily_Log__addDataTablesToJobsiteSiteworkActivityTemplates();

	/*
	$("#record_list_container--manage-jobsite_activity_label-record").dataTable({
		'columns': [
			{ 'orderDataType': 'dom-text', 'orderData': [0, 1] },
			{ 'orderDataType': 'dom-text', 'orderData': [1, 2] },
			{ 'orderDataType': 'dom-text', 'orderData': [2, 1] },
			{ 'orderDataType': 'dom-checkbox' },
			{ 'orderable': false },
			{ 'orderable': false },
		]
	});
	*/

	initializePopovers();
	initializeTooltips();
}

function addSortableToJobsiteBuildingActivities()
{
	$("#record_list_container--manage-jobsite_building_activity-record tbody").sortable({
		axis: 'y',
		distance: 10,
		containment: "#record_list_container--manage-jobsite_building_activity-record",
		helper: sortHelper,
		update: function(event, ui) {
			var element = $(ui.item)[0];
			var endIndex = $(element).index();
			endIndex = endIndex.toString();
			var options = { endIndex: endIndex };
			updateJobsiteBuildingActivity(element, options);
		}
	});
}

function addSortableToJobsiteOffsiteworkActivities()
{
	$("#record_list_container--manage-jobsite_offsitework_activity-record tbody").sortable({
		axis: 'y',
		distance: 10,
		containment: "#record_list_container--manage-jobsite_offsitework_activity-record",
		helper: sortHelper,
		update: function(event, ui) {
			var element = $(ui.item)[0];
			var endIndex = $(element).index();
			endIndex = endIndex.toString();
			var options = { endIndex: endIndex };
			updateJobsiteOffsiteworkActivity(element, options);
		}
	});
}

function addSortableToJobsiteSiteworkActivities()
{
	$("#record_list_container--manage-jobsite_sitework_activity-record tbody").sortable({
		axis: 'y',
		distance: 10,
		containment: "#record_list_container--manage-jobsite_sitework_activity-record",
		helper: sortHelper,
		update: function(event, ui) {
			var element = $(ui.item)[0];
			var endIndex = $(element).index();
			endIndex = endIndex.toString();
			var options = { endIndex: endIndex };
			updateJobsiteSiteworkActivity(element, options);
		}
	});
}

function addSortableToJobsiteActivityLabels()
{
	$("#record_list_container--manage-jobsite_activity_label-record tbody").sortable({
		axis: 'y',
		distance: 10,
		containment: "#record_list_container--manage-jobsite_activity_label-record",
		helper: sortHelper,
		update: function(event, ui) {
			var element = $(ui.item)[0];
			var endIndex = $(element).index();
			endIndex = endIndex.toString();
			var options = { endIndex: endIndex };
			updateJobsiteActivityLabel(element, options);
		}
	});
}

function Daily_Log__addDataTablesToJobsiteBuildingActivities()
{
	if (!$("#record_list_container--manage-jobsite_building_activity-record").hasClass('initialized')) {
		$("#record_list_container--manage-jobsite_building_activity-record").dataTable({
			'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
			'order': [[ 0, 'asc' ]],
			'pageLength': 100,
			'pagingType': 'full_numbers',
			'columns': [
				{ 'orderDataType': 'dom-text', 'orderData': [] },
				null,
				{ 'orderable': false },
				{ 'orderable': false }
			]
		});
		$("#record_list_container--manage-jobsite_building_activity-record").addClass('initialized');
	}
}

function Daily_Log__addDataTablesToJobsiteOffsiteworkActivities()
{
	if (!$("#record_list_container--manage-jobsite_offsitework_activity-record").hasClass('initialized')) {
		$("#record_list_container--manage-jobsite_offsitework_activity-record").dataTable({
			'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
			'order': [[ 0, 'asc' ]],
			'pageLength': 100,
			'pagingType': 'full_numbers',
			'columns': [
				{ 'orderDataType': 'dom-text', 'orderData': [0, 1] },
				null,
				{ 'orderable': false },
				{ 'orderable': false }
			]
		});
		$("#record_list_container--manage-jobsite_offsitework_activity-record").addClass('initialized');
	}
}

function Daily_Log__addDataTablesToJobsiteSiteworkActivities()
{
	if (!$("#record_list_container--manage-jobsite_sitework_activity-record").hasClass('initialized')) {
		$("#record_list_container--manage-jobsite_sitework_activity-record").dataTable({
			'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
			'order': [[ 0, 'asc' ]],
			'pageLength': 100,
			'pagingType': 'full_numbers',
			'columns': [
				{ 'orderDataType': 'dom-text', 'orderData': [] },
				null,
				{ 'orderable': false },
				{ 'orderable': false }
			]
		});
		$("#record_list_container--manage-jobsite_sitework_activity-record").addClass('initialized');
	}
}

function Daily_Log__addDataTablesToJobsiteActivityLabels()
{
	if (!$("#record_list_container--manage-jobsite_activity_label-record").hasClass('initialized')) {
		$("#record_list_container--manage-jobsite_activity_label-record").dataTable({
			'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
			'order': [[ 1, 'asc' ]],
			'pageLength': 100,
			'pagingType': 'full_numbers',
			'columns': [
				{ 'orderDataType': 'dom-text', 'orderData': [0, 1] },
				{ 'orderDataType': 'dom-text', type: 'string' },
				{ 'orderable': false },
				{ 'orderable': false },
				{ 'orderable': false },
				{ 'orderDataType': 'dom-checkbox' },
				{ 'orderable': false }
			]
		});
		$("#record_list_container--manage-jobsite_activity_label-record").addClass('initialized');
	}
}

function Daily_Log__addDataTablesToJobsiteBuildingActivityTemplates()
{
	if (!$("#record_list_container--manage-jobsite_building_activity_template-record").hasClass('initialized')) {
		$("#record_list_container--manage-jobsite_building_activity_template-record").dataTable({
			'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
			'order': [[ 0, 'asc' ]],
			'pageLength': 100,
			'pagingType': 'full_numbers'
		});
		$("#record_list_container--manage-jobsite_building_activity_template-record").addClass('initialized');
	}
/*
			'columns': [
				{ 'orderDataType': 'dom-text', type: 'string' },
				{ 'orderable': false },
				{ 'orderable': false }
			]
*/
}

function Daily_Log__addDataTablesToJobsiteOffsiteworkActivityTemplates()
{
	if (!$("#record_list_container--manage-jobsite_offsitework_activity_template-record").hasClass('initialized')) {
		$("#record_list_container--manage-jobsite_offsitework_activity_template-record").dataTable({
			'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
			'pageLength': 100,
			'pagingType': 'full_numbers'
		});
		$("#record_list_container--manage-jobsite_offsitework_activity_template-record").addClass('initialized');
	}

/*
			'columns': [
				{ 'orderDataType': 'dom-text' },
				{ 'orderable': false },
				{ 'orderable': false }
			]
*/

}

function Daily_Log__addDataTablesToJobsiteSiteworkActivityTemplates()
{
	if (!$("#record_list_container--manage-jobsite_sitework_activity_template-record").hasClass('initialized')) {
		$("#record_list_container--manage-jobsite_sitework_activity_template-record").dataTable({
			'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
			'pageLength': 100,
			'pagingType': 'full_numbers'
		});
		$("#record_list_container--manage-jobsite_sitework_activity_template-record").addClass('initialized');
	}
/*
			'columns': [
				{ 'orderDataType': 'dom-text', type: 'string' },
				{ 'orderable': false },
				{ 'orderable': false }
			]
*/
}

function addClickHandlers()
{
	$(".divBuildingActivity").click(function() {
		var checkboxElement = $(this).find('input[type=checkbox]');
		checkboxElement.click();
	});

}

function updateManpowerTotal()
{
	// Total up the manpower.
	var manpowerTotal = 0;
	$(".jdlTextbox").each(function(index) {
		var element = $(this);
		var manpower = parseInputToInt(element.val());
		element.val(manpower);
		manpowerTotal = parseInt(manpowerTotal) + parseInt(manpower);
	});
	manpowerTotal = parseInputToInt(manpowerTotal);
	$("#manpowerTotal").html(manpowerTotal);
}

function tabClicked(element, tab, filterByManpower, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		// Debug
		//alert(filterByManpower);

		var jobsite_daily_log_id = $("#jobsite_daily_log_id").val();
		$("#activeTab").val(tab);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=renderTabContent';
		var ajaxQueryString =
			'jobsite_daily_log_id=' + encodeURIComponent(jobsite_daily_log_id) +
			'&tab=' + encodeURIComponent(tab);

		if (filterByManpower && filterByManpower == '1') {
			ajaxQueryString = ajaxQueryString + '&filterByManpower=1';
		}

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
			success: tabClickedSuccess,
			error: errorHandler
		});

		if (element) {
			$(".tab").removeClass('activeTabGreen');
			$(element).addClass('activeTabGreen');
			activeTab = tab;
		}

		UrlVars.set('tab', tab);
		UrlVars.remove('subtab');
		UrlVars.remove('subsubtab');
		UrlVars.remove('jobsite_activity_list_template_id');
		if (tab != '3') {
			UrlVars.remove('filterByManpower');
		}

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

function tabClickedSuccess(data, textStatus, jqXHR)
{
	try {

		Console.log('tabClickedSuccess');
		$("#tabContent").html(data);
		addWidgets();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function cellClicked(element, isAdminCell, toggle)
{
	var input = $(element).find('input');
	if (input.length) {
		var checked = input.is(':checked');
		if (checked && isAdminCell) {
			// If the input is a radio button and it's already checked, do nothing.
			return;
		}
		if (toggle) {
			// We only want to manually change the property if the click came from
			// outside the checkbox/radio button.
			input.prop('checked', !checked);
		}
		var id = input.attr('id');
		if (id == 'checkboxFilterActivitiesByManpower') {
			filterActivitiesByManpower();
		} else if (isAdminCell) {
			input = input[0];
			toggleJobsiteAdminActivity(input);
		} else {
			input = input[0];
			toggleJobsiteActivity(input);
		}
	}
}

function ddlDateChanged()
{
	try {

		var date = $("#ddlDate option:selected").html();

		// Strip off date prefix.
		var tokens = date.split(', ');
		date = tokens[1] + ', ' + tokens[2];
		// Change date format.
		date = convertDateToMySQLFormat(date);

		var handler = '/modules-jobsite-daily-logs-form.php';
		var queryString = '' +
			'date=' + encodeURIComponent(date) +
			'&tab=' + encodeURIComponent(activeTab);
		var url = handler + '?' + queryString;
		window.location.assign(url);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function ddlDateChangedSuccess(data, textStatus, jqXHR)
{
	try {

		Console.log('ddlDateChangedSuccess');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleJobsiteActivity(element, javaScriptEvent, options)
{
	// Debug
	//return;

	try {

		// This function gets called from two click handlers: the checkbox itself and the surrounding div.
		// We don't want a checkbox click to bubble up to the div click handler.
		// Trap the event to prevent double click problems
		trapJavaScriptEvent(javaScriptEvent);

		var options = options || {};
		options.promiseChain = true;
		//options.responseDataType = 'json';

		var promiseChain = options.promiseChain;

		window.savePending = true;

		var arrParts = $(element).attr('id').split('--');
		var attributeGroupName = arrParts[0];
		var attributeSubgroupName = arrParts[1];
		var attributeName = arrParts[2];
		var uniqueId = arrParts[3];

		var arrTemp = uniqueId.split('-');
		var jobsite_daily_log_id = arrTemp[0];
		var jobsite_activity_id = arrTemp[1];
		var cost_code_id = arrTemp[2];

		//var jobsite_activity_label = $(element).val();

		var formattedAttributeGroupNameSpecificElementId = 'formattedAttributeGroupName--' + uniqueId;
		var formattedAttributeGroupNameGeneralElementId = 'formattedAttributeGroupName--' + attributeGroupName;
		if ($("#" + formattedAttributeGroupNameSpecificElementId).val()) {
			var formattedAttributeGroupName = $("#" + formattedAttributeGroupNameSpecificElementId).val();
		} else if ($("#" + formattedAttributeGroupNameGeneralElementId).length && $("#" + formattedAttributeGroupNameGeneralElementId).val() != '') {
			var formattedAttributeGroupName = $("#" + formattedAttributeGroupNameGeneralElementId).val();
		} else {
			var formattedAttributeGroupName = '';
		}

		var formattedAttributeSubgroupNameSpecificElementId = 'formattedAttributeSubgroupName--' + uniqueId;
		var formattedAttributeSubgroupNameGeneralElementId = 'formattedAttributeSubgroupName--' + attributeGroupName;
		if ($("#" + formattedAttributeSubgroupNameSpecificElementId).val()) {
			var formattedAttributeSubgroupName = $("#" + formattedAttributeSubgroupNameSpecificElementId).val();
		} else if ($("#" + formattedAttributeSubgroupNameGeneralElementId).length && $("#" + formattedAttributeSubgroupNameGeneralElementId).val() != '') {
			var formattedAttributeSubgroupName = $("#" + formattedAttributeSubgroupNameGeneralElementId).val();
		} else {
			var formattedAttributeSubgroupName = '';
		}

		// Get the value of the element that was updated.
		var tmpValue = $(element).val();
		if($("#"+element.id).prop("checked") == true)
		{
			tmpValue='Y';
			// if($("#checkSurfaceEnvironment-1").prop('checked') == true){)
		}else{
			tmpValue='N';

		}
		// @todo Add validator code here
		if (attributeSubgroupName == 'jobsite_daily_activity_logs') {
			var newValue = tmpValue;
		} else {
			var newValue = tmpValue;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=toggleJobsiteActivity';
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName) +
			'&attributeName=' + encodeURIComponent(attributeName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newValue=' + encodeURIComponent(newValue) +
			'&jobsite_daily_log_id=' + encodeURIComponent(jobsite_daily_log_id) +
			'&cost_code_id='+encodeURIComponent(cost_code_id) +
			'&jobsite_activity_id=' + encodeURIComponent(jobsite_activity_id);
			//'&jobsite_activity_label=' + encodeURIComponent(jobsite_activity_label);
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
			success: defaultAjaxSuccessCallback,
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

function toggleJobsiteActivityToCostCode(element)
{
	// Debug
	//return;

	try {

		window.savePending = true;

		var arrParts = $(element).attr('id').split('--');
		var attributeGroupName = arrParts[0];
		var attributeSubgroupName = arrParts[1];
		var attributeName = arrParts[2];
		var uniqueId = arrParts[3];

		var arrTemp = uniqueId.split('-');
		var jobsite_daily_log_id = arrTemp[0];
		var jobsite_activity_id = arrTemp[1];

		//var jobsite_activity_label = $(element).val();

		var formattedAttributeGroupNameSpecificElementId = 'formattedAttributeGroupName--' + uniqueId;
		var formattedAttributeGroupNameGeneralElementId = 'formattedAttributeGroupName--' + attributeGroupName;
		if ($("#" + formattedAttributeGroupNameSpecificElementId).val()) {
			var formattedAttributeGroupName = $("#" + formattedAttributeGroupNameSpecificElementId).val();
		} else if ($("#" + formattedAttributeGroupNameGeneralElementId).length && $("#" + formattedAttributeGroupNameGeneralElementId).val() != '') {
			var formattedAttributeGroupName = $("#" + formattedAttributeGroupNameGeneralElementId).val();
		} else {
			var formattedAttributeGroupName = '';
		}

		var formattedAttributeSubgroupNameSpecificElementId = 'formattedAttributeSubgroupName--' + uniqueId;
		var formattedAttributeSubgroupNameGeneralElementId = 'formattedAttributeSubgroupName--' + attributeGroupName;
		if ($("#" + formattedAttributeSubgroupNameSpecificElementId).val()) {
			var formattedAttributeSubgroupName = $("#" + formattedAttributeSubgroupNameSpecificElementId).val();
		} else if ($("#" + formattedAttributeSubgroupNameGeneralElementId).length && $("#" + formattedAttributeSubgroupNameGeneralElementId).val() != '') {
			var formattedAttributeSubgroupName = $("#" + formattedAttributeSubgroupNameGeneralElementId).val();
		} else {
			var formattedAttributeSubgroupName = '';
		}

		// Get the value of the element that was updated.
		var tmpValue = $(element).val();

		// @todo Add validator code here
		if (attributeSubgroupName == 'jobsite_daily_activity_logs') {
			var newValue = tmpValue;
		} else {
			var newValue = tmpValue;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=toggleJobsiteActivityToCostCode';
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName) +
			'&attributeName=' + encodeURIComponent(attributeName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newValue=' + encodeURIComponent(newValue) +
			'&jobsite_daily_log_id=' + encodeURIComponent(jobsite_daily_log_id) +
			'&jobsite_activity_id=' + encodeURIComponent(jobsite_activity_id);
			//'&jobsite_activity_label=' + encodeURIComponent(jobsite_activity_label);
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
			success: defaultAjaxSuccessCallback,
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

function filterActivitiesByManpower()
{
	try {



		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=filterActivitiesByManpower';
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&jobsite_activity_id=' + encodeURIComponent(jobsite_activity_id);
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
			success: filterActivitiesByManpowerSuccess,
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

function expandAccordions()
{
	$(".jdlAccordion").each(function(i) {
		$(this).accordion('option', 'active', 0);
	});
}

function collapseAccordions()
{
	$(".jdlAccordion").accordion('option', 'active', false);
}

function filterByManpower(checkboxElement)
{
	var tab = $("#activeTab").val();

	if (tab == '1') {
		element = $("#manpowerTab");
	} else if (tab == '2') {
		element = $("#siteworkTab");
	} else if (tab == '3') {
		element = $("#buildingTab");
	} else if (tab == '4') {
		element = $("#detailsTab");
	} else if (tab == '5') {
		element = $("#dcrPreviewTab");
	} else if (tab == '6') {
		element = $("#adminTab");
	}

	var checkBoxCheckedFlag = $(checkboxElement).is(':checked');
	// Debug
	//alert(checkBoxCheckedFlag);
	if (checkBoxCheckedFlag) {
		UrlVars.set('filterByManpower', '1');
		tabClicked(element, tab, '1');
	} else {
		UrlVars.remove('filterByManpower');
		tabClicked(element, tab, '0');
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

function filterJobsiteDelaySubcategories(element, jsonJobsiteDelayCategoriesAndSubcategories)
{
	var selectDelayCategory = $(".selectJobsiteDelayCategory");
	var selectDelaySubcategory = $(".selectJobsiteDelaySubcategory");

	var selectedCategoryOption = $(".selectJobsiteDelayCategory option:selected");
	var jobsite_delay_category = selectedCategoryOption.html();

	var arrOptions = [];
	var jobsiteDelaySubcategories = jsonJobsiteDelayCategoriesAndSubcategories[jobsite_delay_category];
	for (var jobsite_delay_subcategory_id in jobsiteDelaySubcategories) {
		var jobsite_delay_subcategory = jobsiteDelaySubcategories[jobsite_delay_subcategory_id];
		var option = '<option value="' + jobsite_delay_subcategory_id + '">' + jobsite_delay_subcategory + '</option>';
		arrOptions.push(option);
	}
	var options = arrOptions.join('');
	if (arrOptions.length > 1) {
		options = '<option value="">Please choose a Delay Subcategory Type</option>' + options;
	}
	selectDelaySubcategory.html(options);

	if (arrOptions.length == 1) {
		selectDelaySubcategory.val(jobsite_delay_subcategory_id);
		ddlOnChange_UpdateHiddenInputValue(selectDelaySubcategory);
	}
}

function toggleJobsiteAdminActivity(element)
{
	try {

		window.savePending = true;

		var arrParts = $(element).attr('id').split('--');
		var attributeGroupName = arrParts[0];
		var attributeSubgroupName = arrParts[1];
		var attributeName = arrParts[2];
		var uniqueId = arrParts[3];

		var formattedAttributeGroupNameSpecificElementId = 'formattedAttributeGroupName--' + uniqueId;
		var formattedAttributeGroupNameGeneralElementId = 'formattedAttributeGroupName--' + attributeGroupName;
		if ($("#" + formattedAttributeGroupNameSpecificElementId).val()) {
			var formattedAttributeGroupName = $("#" + formattedAttributeGroupNameSpecificElementId).val();
		} else if ($("#" + formattedAttributeGroupNameGeneralElementId).length && $("#" + formattedAttributeGroupNameGeneralElementId).val() != '') {
			var formattedAttributeGroupName = $("#" + formattedAttributeGroupNameGeneralElementId).val();
		} else {
			var formattedAttributeGroupName = '';
		}

		var formattedAttributeSubgroupNameSpecificElementId = 'formattedAttributeSubgroupName--' + uniqueId;
		var formattedAttributeSubgroupNameGeneralElementId = 'formattedAttributeSubgroupName--' + attributeGroupName;
		if ($("#" + formattedAttributeSubgroupNameSpecificElementId).val()) {
			var formattedAttributeSubgroupName = $("#" + formattedAttributeSubgroupNameSpecificElementId).val();
		} else if ($("#" + formattedAttributeSubgroupNameGeneralElementId).length && $("#" + formattedAttributeSubgroupNameGeneralElementId).val() != '') {
			var formattedAttributeSubgroupName = $("#" + formattedAttributeSubgroupNameGeneralElementId).val();
		} else {
			var formattedAttributeSubgroupName = '';
		}

		// Get the value of the element that was updated.
		var tmpValue = $(element).val();

		// @todo Add validator code here
		if (attributeSubgroupName == 'jobsite_activities') {
			var newValue = tmpValue;
		} else {
			var newValue = tmpValue;
		}

		var tokens = uniqueId.split('-');
		uniqueId = tokens[0];
		var jobsite_activity_type_id = tokens[1];

		var checked = $(element).prop('checked');
		if (checked) {
			newValue = jobsite_activity_type_id;
		} else {
			newValue = 0;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'jobsite_activities-ajax.php?method=updateJobsiteActivity';
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&attributeName=' + encodeURIComponent(attributeName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
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
			success: defaultAjaxSuccessCallback,
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

function updateSelectedCostCode()
{
	var selectedCostCodeOption = $("#ddlCostCodes option:selected");
	var selected_cost_code_id = selectedCostCodeOption.val();
	$("#selected_cost_code_id").val(selected_cost_code_id);

}

function loadImportJobsiteActivitiesDialog(datasource, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=loadImportJobsiteActivitiesDialog';
		var ajaxQueryString =
			'datasource=' + encodeURIComponent(datasource);
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
			success: loadImportJobsiteActivitiesDialogSuccess,
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

function loadImportJobsiteActivitiesDialogSuccess(data, textStatus, jqXHR)
{
	$("#divImportJobsiteActivities").html(data);
	var title = $("#importJobsiteActivitiesDialogTitle").val() || 'Import Jobsite Activities';
	$("#divImportJobsiteActivities").removeClass('hidden');
	$("#divImportJobsiteActivities").dialog({
		modal: true,
		title: title,
		width: 550,
		height: $(window).height() * .95,
		open: function() {
			$("body").addClass('noscroll');
		},
		close: function() {
			$(this).addClass('hidden');
			$(this).dialog('destroy');
			$(this).html('');
			$("body").removeClass('noscroll');
		},
		buttons: {
			'Import': function() {
				importJobsiteActivitiesByCsvJobsiteActivityIds();
			},
			'Cancel': function() {
				$(this).dialog('close');
			}
		}
	});
}

function importJobsiteActivitiesByCsvJobsiteActivityIds(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		// Get all checked checkboxes but ignore the disabled ones.
		var arrJobsiteActivityIds = [];
		$("#tableImportJobsiteActivities tbody input[type=checkbox]:checked:not(:disabled)").each(function(i) {
			var val = $(this).val();
			arrJobsiteActivityIds.push(val);
		});
		if (arrJobsiteActivityIds.length == 0) {
			return;
		}
		var csvJobsiteActivityIds = arrJobsiteActivityIds.join(',');

		// Get primary and secondary datasources.
		var primaryDatasource = $("#primaryDatasource").val(); // building | sitework | offsitework
		var secondaryDatasource = $("#secondaryDatasource").val(); // project | template

		// Get container elementId for success handler.
		var containerElementId = $("#jobsiteActivitiesTableElementId").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=importJobsiteActivitiesByCsvJobsiteActivityIds';
		var ajaxQueryString =
			'csvJobsiteActivityIds=' + encodeURIComponent(csvJobsiteActivityIds) +
			'&primaryDatasource=' + encodeURIComponent(primaryDatasource) +
			'&secondaryDatasource=' + encodeURIComponent(secondaryDatasource) +
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
			success: importJobsiteActivitiesByCsvJobsiteActivityIdsSuccess,
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

function importJobsiteActivitiesByCsvJobsiteActivityIdsSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;
		var messageText = json.messageText;
		var htmlRecords = json.htmlRecords;
		var containerElementId = json.containerElementId;

		messageAlert(messageText, 'successMessage');

		// Remove dataTable plugin before adding rows.
		$("#record_list_container--" + containerElementId).dataTable().api().destroy();
		$("#record_list_container--" + containerElementId).removeClass('initialized');

		$("#record_list_container--" + containerElementId + " tbody").append(htmlRecords);
		$("#divImportJobsiteActivities").dialog('close');

		// Re-add dataTable plugin.
		addWidgets();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadJobsiteActivitiesToCostCodesDialog(jobsiteActivityTableName, jobsite_activity_id, jobsite_activity_label)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=loadJobsiteActivitiesToCostCodesDialog';

		var ajaxQueryString =
			'jobsiteActivityTableName=' + encodeURIComponent(jobsiteActivityTableName) +
			'&jobsite_activity_id=' + encodeURIComponent(jobsite_activity_id);

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var promise = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadJobsiteActivitiesToCostCodesDialogSuccess,
			error: errorHandler
		});

		promise.then(function() {
			$("#divLinkJobsiteActivitiesToCostCodes").dialog('option', 'title', 'Link Cost Codes to "' + jobsite_activity_label + '"');
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function loadJobsiteActivitiesToCostCodesDialogSuccess(data, textStatus, jqXHR)
{
	$("#divLinkJobsiteActivitiesToCostCodes").html(data);
	$("#divLinkJobsiteActivitiesToCostCodes").removeClass('hidden');
	$("#divLinkJobsiteActivitiesToCostCodes").dialog({
		modal: true,
		title: 'Link Jobsite Activities To Cost Codes',
		width: 600,
		height: $(window).height(),
		open: function() {
			$("body").addClass('noscroll');
		},
		close: function() {
			$("body").removeClass('noscroll');
			$("#divLinkJobsiteActivitiesToCostCodes").addClass('hidden');
		},
		buttons: {
			'Close': function() {
				$(this).dialog('close');
			}
		}
	});

	addWidgets();
}

function toggleJobsiteActivityToCostCode1(element, javaScriptEvent, options)
{
	try {

		trapJavaScriptEvent(javaScriptEvent);

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var arrParts = $(element).prop('id').split('--');
		var attributeGroupName = arrParts[0];
		var attributeSubgroupName = arrParts[1];
		var attributeName = arrParts[2];
		var uniqueId = arrParts[3];

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=toggleJobsiteActivityToCostCode1';

		var create = 0;
		var isChecked = $(element).prop('checked');
		if (isChecked) {
			create = 1;
		}

		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&attributeName=' + encodeURIComponent(attributeName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&create=' + encodeURIComponent(create);

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
			success: toggleJobsiteActivityToCostCodeSuccess1,
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

function toggleJobsiteActivityToCostCodeSuccess1(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;
		var messageText = json.messageText;
		if (errorNumber == 0) {
			messageAlert(messageText, 'successMessage');
		} else {
			messageAlert(messageText, 'errorMessage');
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleAllJobsiteActivities(element)
{
	var checked = $(element).prop('checked');
	if (checked) {
		$("#tableImportJobsiteActivities tbody input[type=checkbox]").prop('checked', true);
	} else {
		$("#tableImportJobsiteActivities tbody input[type=checkbox]").prop('checked', false);
	}
}

function loadJobsiteBuildingActivityTemplateDetailsDialog(jobsite_activity_list_template_id)
{
	try {

		var options = { responseDataType: 'json' };

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=loadJobsiteBuildingActivityTemplateDetailsDialog';
		var ajaxQueryString =
			'jobsite_activity_list_template_id=' + encodeURIComponent(jobsite_activity_list_template_id);

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

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: loadJobsiteBuildingActivityTemplateDetailsDialogSuccess,
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

function loadJobsiteBuildingActivityTemplateDetailsDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var htmlContent = json.htmlContent;

		$("#divJobsiteBuildingActivityTemplateDetails").html(htmlContent);
		$("#divJobsiteBuildingActivityTemplateDetails").removeClass('hidden');
		$("#divJobsiteBuildingActivityTemplateDetails").dialog({
			title: 'Jobsite Building Activity Template Details',
			modal: true,
			width: 800,
			height: $(window).height(),
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$(this).addClass('hidden');
				$(this).dialog('destroy');
				$(this).html('');
				$("body").removeClass('noscroll');
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

function Daily_Log__ManPower__signInSheetUploaded(arrFileManagerFiles)
{
	try {

		var options = options || {};
		options.responseDataType = 'json';
		options.moduleName = 'Daily_Log';
		options.includeHtmlContent = 'Y';
		options.scenarioName = 'Daily_Log__ManPower__createJobsiteSignInSheet';
		options.successCallback = Daily_Log__ManPower__createJobsiteSignInSheetSuccess;

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;

			var jobsite_daily_log_id = $("#jobsite_daily_log_id").val();
			var dummyId = generateDummyElementId();
			var recordContainerElementId = 'record_container--create-jobsite_sign_in_sheet-record--jobsite_sign_in_sheets--' + dummyId;
			var attributeGroupName = 'manage-jobsite_sign_in_sheet-record';

			var input1 = '<input id="' + attributeGroupName + '--jobsite_sign_in_sheets--jobsite_daily_log_id--' + dummyId + '" type="hidden" value="' + jobsite_daily_log_id + '">';
			var input2 = '<input id="' + attributeGroupName + '--jobsite_sign_in_sheets--jobsite_sign_in_sheet_file_manager_file_id--' + dummyId + '" type="hidden" value="' + file_manager_file_id + '">';
			var htmlRecordLi = '<li id="' + recordContainerElementId + '" class="hidden">' + input1 + input2 + '</li>';

			$("#record_list_container--" + attributeGroupName).append(htmlRecordLi);

			createJobsiteSignInSheet(attributeGroupName, dummyId, options);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__ManPower__createJobsiteSignInSheetSuccess(data, textStatus, jqXHR)
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
			$("#liUploadedSigninSheetPlaceholder").remove();
			$("#record_list_container--" + attributeGroupName).append(htmlRecordLi);
			$(".bs-tooltip").tooltip();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__ManPower__fieldReportUploaded(arrFileManagerFiles)
{
	try {

		var options = options || {};
		options.responseDataType = 'json';
		options.moduleName = 'Daily_Log';
		options.includeHtmlContent = 'Y';
		options.scenarioName = 'Daily_Log__ManPower__createJobsiteFieldReport';
		options.successCallback = Daily_Log__ManPower__createJobsiteFieldReportSuccess;

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;

			var jobsite_daily_log_id = $("#jobsite_daily_log_id").val();
			var dummyId = generateDummyElementId();
			var recordContainerElementId = 'record_container--create-jobsite_field_report-record--jobsite_field_reports--' + dummyId;
			var attributeGroupName = 'manage-jobsite_field_report-record';

			var input1 = '<input id="' + attributeGroupName + '--jobsite_field_reports--jobsite_daily_log_id--' + dummyId + '" type="hidden" value="' + jobsite_daily_log_id + '">';
			var input2 = '<input id="' + attributeGroupName + '--jobsite_field_reports--jobsite_field_report_file_manager_file_id--' + dummyId + '" type="hidden" value="' + file_manager_file_id + '">';
			var htmlRecordLi = '<li id="' + recordContainerElementId + '" class="hidden">' + input1 + input2 + '</li>';

			$("#record_list_container--" + attributeGroupName).append(htmlRecordLi);

			createJobsiteFieldReport(attributeGroupName, dummyId, options);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__ManPower__createJobsiteFieldReportSuccess(data, textStatus, jqXHR)
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
			$("#liUploadedFieldReportPlaceholder").remove();
			$("#record_list_container--" + attributeGroupName).append(htmlRecordLi);
			$(".bs-tooltip").tooltip();

		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__ManPower__photoUploaded(arrFileManagerFiles,inter)
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
			if(inter=='Y')
			{
			var attributeGroupName = 'manage-jobsite_internal_photo-record';
			}else{
			var attributeGroupName = 'manage-jobsite_photo-record';}

			var input1 = '<input id="' + attributeGroupName + '--jobsite_photos--jobsite_daily_log_id--' + dummyId + '" type="hidden" value="' + jobsite_daily_log_id + '">';
			var input2 = '<input id="' + attributeGroupName + '--jobsite_photos--jobsite_photo_file_manager_file_id--' + dummyId + '" type="hidden" value="' + file_manager_file_id + '">';
			var htmlRecordLi = '<li id="' + recordContainerElementId + '" class="hidden">' + input1 + input2 + '</li>';

			$("#record_list_container--" + attributeGroupName).append(htmlRecordLi);
			createJobsitePhoto(attributeGroupName, dummyId, options,inter);
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
			$(".bs-tooltip").tooltip();
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

function createJobsiteSiteworkActivityAndReloadSiteworkActivitesViaPromiseChain(attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createJobsiteSiteworkActivity(attributeGroupName, uniqueId, options);
		promise.then(function() {
			//$("#btnAddJobsiteSiteworkActivityPopover").popover('hide');
			$("#divAddJobsiteSiteworkActivityPopover form")[0].reset();
			tabClicked(null, '2', '0');
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createJobsiteBuildingActivityAndLinkToCostCodeViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise1 = createJobsiteBuildingActivity(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function(json) {
			var jobsite_building_activity_id = json.uniqueId;
			var innerPromise = toggleJobsiteBuildingActivityToCostCode(jobsite_building_activity_id, options);
			return innerPromise;
		});
		promise2.then(function() {
			//$("#btnAddJobsiteBuildingActivityPopover").popover('hide');
			$("#formCreateJobsiteBuildingActivityViaPopover")[0].reset();
			var filterByManpower = UrlVars.get('filterByManpower') || '0';
			tabClicked(null, '3', filterByManpower);
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleJobsiteBuildingActivityToCostCode(jobsite_building_activity_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var attributeSubgroupName = 'jobsite_building_activities';
		var attributeName = 'jobsite_building_activity_id-cost_code_id';
		var cost_code_id = $("#ddlCostCodes").val();
		var uniqueId = jobsite_building_activity_id + '-' + cost_code_id;
		var create = 1;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=toggleJobsiteActivityToCostCode1';
		var ajaxQueryString =
			'attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&attributeName=' + encodeURIComponent(attributeName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&create=' + encodeURIComponent(create);
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
			success: toggleJobsiteActivityToCostCodeSuccess1,
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

function createJobsiteBuildingActivityFromMasterJobsiteActivityList(element, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createJobsiteBuildingActivity(attributeGroupName, uniqueId, options);
		promise.then(function(json) {
			var jobsite_building_activity_id = json.uniqueId;
			var html = '<span class="entypo entypo-click entypo-check" onclick="deleteJobsiteBuildingActivityFromMasterJobsiteActivityList(this, \'\', \'delete-jobsite_building_activity-record\', \''+jobsite_building_activity_id+'\');" rel="tooltip" title="Remove from Building Activites"></span>';
			var td = $(element).parent();
			hideTooltips();
			$(element).remove();
			td.prepend(html);
			initializeTooltips();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createJobsiteSiteworkActivityFromMasterJobsiteActivityList(element, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createJobsiteSiteworkActivity(attributeGroupName, uniqueId, options);
		promise.then(function(json) {
			var jobsite_sitework_activity_id = json.uniqueId;
			var html = '<span class="entypo entypo-click entypo-check" onclick="deleteJobsiteSiteworkActivityFromMasterJobsiteActivityList(this, \'\', \'delete-jobsite_sitework_activity-record\', \''+jobsite_sitework_activity_id+'\');" rel="tooltip" title="Remove from Sitework Activites"></span>';
			var td = $(element).parent();
			hideTooltips();
			$(element).remove();
			td.prepend(html);
			initializeTooltips();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createJobsiteOffsiteworkActivityFromMasterJobsiteActivityList(element, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createJobsiteOffsiteworkActivity(attributeGroupName, uniqueId, options);
		promise.then(function(json) {
			var jobsite_offsitework_activity_id = json.uniqueId;
			var html = '<span class="entypo entypo-click entypo-check" onclick="deleteJobsiteOffsiteworkActivityFromMasterJobsiteActivityList(this, \'\', \'delete-jobsite_offsitework_activity-record\', \''+jobsite_offsitework_activity_id+'\');" rel="tooltip" title="Remove from Offsitework Activites"></span>';
			var td = $(element).parent();
			hideTooltips();
			$(element).remove();
			td.prepend(html);
			initializeTooltips();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteJobsiteBuildingActivityFromMasterJobsiteActivityList(element, recordContainerElementId, attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = deleteJobsiteBuildingActivity(recordContainerElementId, attributeGroupName, uniqueId, options);
		promise.then(function(json) {
			var td = $(element).parent();
			var input = td.find('input').first();
			var id = input.prop('id');
			var uniqueId = id.split('--')[3];
			var html = '<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteBuildingActivityFromMasterJobsiteActivityList(this, \'create-jobsite_building_activity-record\', \''+uniqueId+'\');" rel="tooltip" title="Add to Building Activites"></span>';
			hideTooltips();
			$(element).remove();
			td.prepend(html);
			initializeTooltips();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteJobsiteSiteworkActivityFromMasterJobsiteActivityList(element, recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = deleteJobsiteSiteworkActivity(recordContainerElementId, attributeGroupName, uniqueId, options);
		promise.then(function(json) {

			var td = $(element).parent();
			var input = td.find('input').first();
			var id = input.prop('id');
			var uniqueId = id.split('--')[3];
			var html = '<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteSiteworkActivityFromMasterJobsiteActivityList(this, \'create-jobsite_sitework_activity-record\', \''+uniqueId+'\');" rel="tooltip" title="Add to Sitework Activites"></span>';
			hideTooltips();
			$(element).remove();
			td.prepend(html);
			initializeTooltips();

		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteJobsiteOffsiteworkActivityFromMasterJobsiteActivityList(element, recordContainerElementId, attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = deleteJobsiteOffsiteworkActivity(recordContainerElementId, attributeGroupName, uniqueId, options);
		promise.then(function(json) {
			var td = $(element).parent();
			var input = td.find('input').first();
			var id = input.prop('id');
			var uniqueId = id.split('--')[3];
			var html = '<span class="entypo entypo-click entypo-plus-circled" onclick="createJobsiteOffsiteworkActivityFromMasterJobsiteActivityList(this, \'create-jobsite_offsitework_activity-record\', \''+uniqueId+'\');" rel="tooltip" title="Add to Offsitework Activites"></span>';
			hideTooltips();
			$(element).remove();
			td.prepend(html);
			initializeTooltips();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function subtabClicked(subtab, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		UrlVars.set('subtab', subtab);
		activeSubtab = subtab;
		activeSubsubtab = null;

		var jobsite_daily_log_id = $("#jobsite_daily_log_id").val();
		var tab = '6';

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=renderTabContent';
		var ajaxQueryString =
			'jobsite_daily_log_id=' + encodeURIComponent(jobsite_daily_log_id) +
			'&tab=' + encodeURIComponent(tab) +
			'&subtab=' + encodeURIComponent(subtab);

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
			success: subtabClickedSuccess,
			error: errorHandler
		});

		UrlVars.remove('subsubtab');
		if (subtab == 'project' || subtab == 'template') {
			UrlVars.remove('jobsite_activity_list_template_id');
		}

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

function subtabClickedSuccess(data, textStatus, jqXHR)
{
	try {

		$("#tabContent").html(data);
		addWidgets();

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

function Daily_Log__Admin__Manage_Jobsite_Activity_Labels__createJobsiteActivityLabel(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};

		//options.promiseChain = true;
		options.promiseChain = false;
		options.responseDataType = 'json';
		options.includeHtmlContent = 'Y';
		options.moduleName = 'Daily_Log';
		options.scenarioName = 'Daily_Log__Admin__Manage_Jobsite_Activity_Labels__createJobsiteActivityLabel';
		options.successCallback = Daily_Log__Admin__Manage_Jobsite_Activity_Labels__createJobsiteActivityLabelSuccess;

//		var promise = createJobsiteActivityLabel(attributeGroupName, uniqueId, options);
//		promise.then(function() {
//			subsubtabClicked(null, 'manageJobsiteActivities');
//		});

		createJobsiteActivityLabel(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__Admin__Manage_Jobsite_Activity_Labels__createJobsiteActivityLabelSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			// Reset the form
			var formCreateJobsiteActivityLabel = $("#formCreateJobsiteActivityLabel")[0];
			formCreateJobsiteActivityLabel.reset();

			// Prepend the html record to the list
			var htmlRecordTr = json.htmlRecordTr;
			$("#record_list_container--manage-jobsite_activity_label-record tbody").prepend(htmlRecordTr);
			//addSortableToJobsiteActivityLabels();
			$("#record_list_container--manage-jobsite_activity_label-record tbody").sortable('refresh');
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__Details__createJobsiteInspection(attributeGroupName, uniqueId, options)
{
	try {
		//var jobsite_inspection_type = $("#" + jobsite_inspection_type_id_element_id + " option:selected").html();

		adHocQueryParameters = '';

		// Description / Inspection Notes
		var jobsite_inspection_note_element_id = attributeGroupName + '--jobsite_inspections--jobsite_inspection_note--' + uniqueId;
		if ($("#" + jobsite_inspection_note_element_id).length) {
			var jobsite_inspection_note = $("#" + jobsite_inspection_note_element_id).val();
			adHocQueryParameters = adHocQueryParameters + '&jobsite_inspection_note=' + encodeURIComponent(jobsite_inspection_note);
		}

		var options = options || {};

		options.adHocQueryParameters = adHocQueryParameters;
		options.promiseChain = false;
		options.responseDataType = 'json';
		//options.includeHtmlContent = 'Y';
		//options.moduleName = 'Daily_Log';
		//options.scenarioName = 'Daily_Log__Details__createJobsiteInspection';
		options.successCallback = Daily_Log__Details__createJobsiteInspectionSuccess;

		createJobsiteInspection(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__Details__createJobsiteInspectionSuccess(data, textStatus, jqXHR)
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
			var htmlRecordTr = json.htmlRecordTr;

			// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
			var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;

			$("#tableJobsiteInspections").append(htmlRecordTr);

			var form = $("#formJobsiteInspections")[0];
			form.reset();
			$("#trJobsiteInspectionsHeader").removeClass('hidden');
		}
		UpdateDaliytab();

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__Details__createJobsiteDelay(attributeGroupName, uniqueId, options)
{
	try {

		adHocQueryParameters = '';

		// jobsite_delay_category_id
		var jobsite_delay_category_id_element_id = 'ddl--' + attributeGroupName + '--jobsite_delays--jobsite_delay_category_id--' + uniqueId;
		if ($("#" + jobsite_delay_category_id_element_id).length) {
			var jobsite_delay_category_id = $("#" + jobsite_delay_category_id_element_id).val();
			adHocQueryParameters = adHocQueryParameters + '&jobsite_delay_category_id=' + encodeURIComponent(jobsite_delay_category_id);
		}

		// Description / Delay Notes
		var jobsite_delay_note_element_id = attributeGroupName + '--jobsite_delays--jobsite_delay_note--' + uniqueId;
		if ($("#" + jobsite_delay_note_element_id).length) {
			var jobsite_delay_note = $("#" + jobsite_delay_note_element_id).val();
			adHocQueryParameters = adHocQueryParameters + '&jobsite_delay_note=' + encodeURIComponent(jobsite_delay_note);
		}

		var options = options || {};

		options.adHocQueryParameters = adHocQueryParameters;
		options.promiseChain = false;
		options.responseDataType = 'json';
		options.includeHtmlContent = 'Y';
		options.moduleName = 'Daily_Log';
		options.scenarioName = 'Daily_Log__Details__createJobsiteDelay';
		options.successCallback = Daily_Log__Details__createJobsiteDelaySuccess;

		createJobsiteDelay(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__Details__createJobsiteDelaySuccess(data, textStatus, jqXHR)
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
			var htmlRecordTr = json.htmlRecordTr;

			// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
			var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;

			var tableJobsiteDelaysTbody = $("#tableJobsiteDelays tbody");
			tableJobsiteDelaysTbody.append(htmlRecordTr);

			var form = $("#formJobsiteDelays")[0];
			form.reset();
			$("#trJobsiteDelaysHeader").removeClass('hidden');

			// Reset the Jobsite Delays Subcategory drop down list (<select>
			// E.g. ddl--create-jobsite_delay-record--jobsite_delays--jobsite_delay_subcategory_id--dummy_id_14521473740288
			var ddlDelaySubcategoryId = 'ddl--' + previousAttributeGroupName + '--jobsite_delays--jobsite_delay_subcategory_id--' + dummyId;
			//alert(ddlDelaySubcategoryId);
			$("#" + ddlDelaySubcategoryId).html('<option value="">Please choose a Delay Subcategory Type</option>');
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleAllJobsiteBuildingActivityTemplatesChecked(element)
{
	var checked = $(element).prop('checked');
	var arrCheckboxes = $(element).closest('table').find('input[type="checkbox"]');
	arrCheckboxes.each(function(i) {
		$(this).prop('checked', checked);
	});
}

function deleteJobsiteBuildingActivityTemplateAndDependentDataAndReloadDataTableViaPromiseChain(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise1 = deleteJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId(uniqueId, options);
		var promise2 = promise1.then(function() {
			$("#record_list_container--manage-jobsite_building_activity_template-record").dataTable().api().destroy();
			var innerPromise = deleteJobsiteBuildingActivityTemplate(recordContainerElementId, attributeGroupName, uniqueId, options);
			return innerPromise;
		});
		promise2.then(function() {
			$("#record_list_container--manage-jobsite_building_activity_template-record").removeClass('initialized');
			addWidgets();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId(jobsite_building_activity_template_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=deleteJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId';
		var ajaxQueryString =
			'jobsite_building_activity_template_id=' + encodeURIComponent(jobsite_building_activity_template_id);
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

function deleteJobsiteSiteworkActivityTemplateAndDependentDataAndReloadDataTableViaPromiseChain(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise1 = deleteJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId(uniqueId, options);
		var promise2 = promise1.then(function() {
			$("#record_list_container--manage-jobsite_sitework_activity_template-record").dataTable().api().destroy();
			var innerPromise = deleteJobsiteSiteworkActivityTemplate(recordContainerElementId, attributeGroupName, uniqueId, options);
			return innerPromise;
		});
		promise2.then(function() {
			$("#record_list_container--manage-jobsite_sitework_activity_template-record").removeClass('initialized');
			addWidgets();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId(jobsite_sitework_activity_template_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=deleteJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId';
		var ajaxQueryString =
			'jobsite_sitework_activity_template_id=' + encodeURIComponent(jobsite_sitework_activity_template_id);
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

function deleteJobsiteOffsiteworkActivityTemplateAndDependentDataAndReloadDataTableViaPromiseChain(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise1 = deleteJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId(uniqueId, options);
		var promise2 = promise1.then(function() {
			$("#record_list_container--manage-jobsite_offsitework_activity_template-record").dataTable().api().destroy();
			var innerPromise = deleteJobsiteOffsiteworkActivityTemplate(recordContainerElementId, attributeGroupName, uniqueId, options);
			return innerPromise;
		});
		promise2.then(function() {
			$("#record_list_container--manage-jobsite_offsitework_activity_template-record").removeClass('initialized');
			addWidgets();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId(jobsite_offsitework_activity_template_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=deleteJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId';
		var ajaxQueryString =
			'jobsite_offsitework_activity_template_id=' + encodeURIComponent(jobsite_offsitework_activity_template_id);
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

function createJobsiteBuildingActivityAndReloadDataTableViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createJobsiteBuildingActivity(attributeGroupName, uniqueId, options);
		promise.then(function(json) {
			var htmlRecord = json.htmlRecord;
			// Remove dataTable plugin before adding rows.
			$("#record_list_container--manage-jobsite_building_activity-record").dataTable().api().destroy();
			$("#record_list_container--manage-jobsite_building_activity-record").removeClass('initialized');

			$("#record_list_container--manage-jobsite_building_activity-record tbody").prepend(htmlRecord);
			$("#formCreateJobsiteBuildingActivity")[0].reset();
			// Re-add dataTable plugin.
			addWidgets();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createJobsiteSiteworkActivityAndReloadDataTableViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createJobsiteSiteworkActivity(attributeGroupName, uniqueId, options);
		promise.then(function(json) {
			var htmlRecord = json.htmlRecord;
			// Remove dataTable plugin before adding rows.
			$("#record_list_container--manage-jobsite_sitework_activity-record").dataTable().api().destroy();
			$("#record_list_container--manage-jobsite_sitework_activity-record").removeClass('initialized');
			hideCreateJobsiteSiteworkActivity();			// $("#record_list_container--manage-jobsite_sitework_activity-record tbody").prepend(htmlRecord);
			$("#formCreateJobsiteSiteworkActivity")[0].reset();
			// Re-add dataTable plugin.
			addWidgets();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createJobsiteOffsiteworkActivityAndReloadDataTableViaPromiseChain(attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createJobsiteOffsiteworkActivity(attributeGroupName, uniqueId, options);
		promise.then(function(json) {

			var htmlRecordTr = json.htmlRecordTr;

			// Remove dataTable plugin before adding rows.
			$("#record_list_container--manage-jobsite_offsitework_activity-record").dataTable().api().destroy();
			$("#record_list_container--manage-jobsite_offsitework_activity-record").removeClass('initialized');

			$("#record_list_container--manage-jobsite_offsitework_activity-record tbody").prepend(htmlRecord);
			$("#formCreateJobsiteOffsiteworkActivity")[0].reset();

			// Re-add dataTable plugin.
			addWidgets();

		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteJobsiteBuildingActivityAndDependentDataAndReloadDataTableViaPromiseChain(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		showSpinner();
		$("#record_list_container--manage-jobsite_building_activity-record").dataTable().api().destroy();
		var promise1 = deleteJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId(uniqueId, options);
		var promise2 = promise1.then(function() {
			var innerPromise = deleteJobsiteBuildingActivity(recordContainerElementId, attributeGroupName, uniqueId, options);
			return innerPromise;
		});
		promise2.then(function() {
			$("#record_list_container--manage-jobsite_building_activity-record").removeClass('initialized');
			$("#record_list_container--manage-jobsite_building_activity-record").dataTable().api().destroy();
			addWidgets();
		});
		promise2.always(function() {
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

function deleteJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId(jobsite_building_activity_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=deleteJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId';
		var ajaxQueryString =
			'jobsite_building_activity_id=' + encodeURIComponent(jobsite_building_activity_id);
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

function deleteJobsiteSiteworkActivityAndDependentDataAndReloadDataTableViaPromiseChain(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		showSpinner();
		$("#record_list_container--manage-jobsite_sitework_activity-record").dataTable().api().destroy();
		var promise1 = deleteJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId(uniqueId, options);
		var promise2 = promise1.then(function() {
			var innerPromise = deleteJobsiteSiteworkActivity(recordContainerElementId, attributeGroupName, uniqueId, options);
			return innerPromise;
		});
		promise2.then(function() {
			$("#record_list_container--manage-jobsite_sitework_activity-record").removeClass('initialized');
			$("#record_list_container--manage-jobsite_sitework_activity-record").dataTable().api().destroy();
			addWidgets();
		});
		promise2.always(function() {
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

function deleteJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId(jobsite_sitework_activity_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=deleteJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId';
		var ajaxQueryString =
			'jobsite_sitework_activity_id=' + encodeURIComponent(jobsite_sitework_activity_id);
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

function deleteJobsiteOffsiteworkActivityAndDependentDataAndReloadDataTableViaPromiseChain(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		showSpinner();
		$("#record_list_container--manage-jobsite_offsitework_activity-record").dataTable().api().destroy();
		var promise1 = deleteJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId(uniqueId, options);
		var promise2 = promise1.then(function() {
			var innerPromise = deleteJobsiteOffsiteworkActivity(recordContainerElementId, attributeGroupName, uniqueId, options);
			return innerPromise;
		});
		promise2.then(function() {
			$("#record_list_container--manage-jobsite_offsitework_activity-record").removeClass('initialized');
			$("#record_list_container--manage-jobsite_offsitework_activity-record").dataTable().api().destroy();
			addWidgets();
		});
		promise2.always(function() {
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

function deleteJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId(jobsite_offsitework_activity_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=deleteJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId';
		var ajaxQueryString =
			'jobsite_offsitework_activity_id=' + encodeURIComponent(jobsite_offsitework_activity_id);
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

function createJobsiteBuildingActivityTemplateAndReloadDataTableViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createJobsiteBuildingActivityTemplate(attributeGroupName, uniqueId, options);
		promise.then(function(json) {

			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {

				var htmlRecord = json.htmlRecord;

				// Remove dataTable plugin before adding rows.
				$("#record_list_container--manage-jobsite_building_activity_template-record").dataTable().api().destroy();
				$("#record_list_container--manage-jobsite_building_activity_template-record").removeClass('initialized');

				$("#record_list_container--manage-jobsite_building_activity_template-record tbody").prepend(htmlRecord);
				$("#formCreateJobsiteBuildingActivityTemplate")[0].reset();
				addWidgets();

			} else {

				// Error Occurred
				var errorMessage = json.errorMessage;
				highlightCreationFormElementOnError(
					'create-jobsite_building_activity_template-record--jobsite_building_activity_templates--jobsite_building_activity_label--dummy',
					'record_creation_form_error_message_container--create-jobsite_building_activity_template-record--dummy',
					'create-jobsite_building_activity_template-record--jobsite_building_activity_templates--errorMessage--dummy',
					errorMessage
				);

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

function loadJobsiteBuildingActivityTemplatesTbody(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var jobsite_activity_list_template_id = $(element).val();
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=loadJobsiteBuildingActivityTemplatesTbody';
		var ajaxQueryString =
			'jobsite_activity_list_template_id=' + encodeURIComponent(jobsite_activity_list_template_id);
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
			success: loadJobsiteBuildingActivityTemplatesTbodySuccess,
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

function loadJobsiteBuildingActivityTemplatesTbodySuccess(data, textStatus, jqXHR)
{
	try {

		$("#record_list_container--manage-jobsite_building_activity_template-record").dataTable().api().destroy();
		$("#record_list_container--manage-jobsite_building_activity_template-record").removeClass('initialized');
		$("#record_list_container--manage-jobsite_building_activity_template-record tbody").html(data);
		addWidgets();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createJobsiteSiteworkActivityTemplateAndReloadDataTableViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createJobsiteSiteworkActivityTemplate(attributeGroupName, uniqueId, options);
		promise.then(function(json) {

			var htmlRecord = json.htmlRecord;
			var errorNumber = json.errorNumber;
			var errorMessage = json.errorMessage;

			if (errorNumber == 0) {

				// Remove dataTable plugin before adding rows.
				$("#record_list_container--manage-jobsite_sitework_activity_template-record").dataTable().api().destroy();
				$("#record_list_container--manage-jobsite_sitework_activity_template-record").removeClass('initialized');

				$("#record_list_container--manage-jobsite_sitework_activity_template-record tbody").prepend(htmlRecord);
				$("#formCreateJobsiteSiteworkActivityTemplate")[0].reset();
				addWidgets();

			} else {

				// Error Occurred
				highlightCreationFormElementOnError(
					'create-jobsite_sitework_activity_template-record--jobsite_sitework_activity_templates--jobsite_sitework_activity_label--dummy',
					'record_creation_form_error_message_container--create-jobsite_sitework_activity_template-record--dummy',
					'create-jobsite_sitework_activity_template-record--jobsite_sitework_activity_templates--errorMessage--dummy',
					errorMessage
				);

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

function loadJobsiteSiteworkActivityTemplatesTbody(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var jobsite_activity_list_template_id = $(element).val();
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=loadJobsiteSiteworkActivityTemplatesTbody';
		var ajaxQueryString =
			'jobsite_activity_list_template_id=' + encodeURIComponent(jobsite_activity_list_template_id);
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
			success: loadJobsiteSiteworkActivityTemplatesTbodySuccess,
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

function loadJobsiteSiteworkActivityTemplatesTbodySuccess(data, textStatus, jqXHR)
{
	try {

		$("#record_list_container--manage-jobsite_sitework_activity_template-record").dataTable().api().destroy();
		$("#record_list_container--manage-jobsite_sitework_activity_template-record").removeClass('initialized');
		$("#record_list_container--manage-jobsite_sitework_activity_template-record tbody").html(data);
		addWidgets();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createJobsiteOffsiteworkActivityTemplateAndReloadDataTableViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createJobsiteOffsiteworkActivityTemplate(attributeGroupName, uniqueId, options);
		promise.then(function(json) {

			var htmlRecord = json.htmlRecord;
			var errorNumber = json.errorNumber;
			var errorMessage = json.errorMessage;

			if (errorNumber == 0) {

				// Remove dataTable plugin before adding rows.
				$("#record_list_container--manage-jobsite_offsitework_activity_template-record").dataTable().api().destroy();
				$("#record_list_container--manage-jobsite_offsitework_activity_template-record").removeClass('initialized');

				$("#record_list_container--manage-jobsite_offsitework_activity_template-record tbody").prepend(htmlRecord);
				$("#formCreateJobsiteOffsiteworkActivityTemplate")[0].reset();
				addWidgets();

			} else {

				// Error Occurred
				highlightCreationFormElementOnError(
					'create-jobsite_offsitework_activity_template-record--jobsite_offsitework_activity_templates--jobsite_offsitework_activity_label--dummy',
					'record_creation_form_error_message_container--create-jobsite_offsitework_activity_template-record--dummy',
					'create-jobsite_offsitework_activity_template-record--jobsite_offsitework_activity_templates--errorMessage--dummy',
					errorMessage
				);

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

function loadJobsiteOffsiteworkActivityTemplatesTbody(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var jobsite_activity_list_template_id = $(element).val();
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=loadJobsiteOffsiteworkActivityTemplatesTbody';
		var ajaxQueryString =
			'jobsite_activity_list_template_id=' + encodeURIComponent(jobsite_activity_list_template_id);
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
			success: loadJobsiteOffsiteworkActivityTemplatesTbodySuccess,
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

function loadJobsiteOffsiteworkActivityTemplatesTbodySuccess(data, textStatus, jqXHR)
{
	try {

		$("#record_list_container--manage-jobsite_offsitework_activity_template-record").dataTable().api().destroy();
		$("#record_list_container--manage-jobsite_offsitework_activity_template-record").removeClass('initialized');
		$("#record_list_container--manage-jobsite_offsitework_activity_template-record tbody").html(data);
		addWidgets();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadImportJobsiteActivitiesTbody(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var primaryDatasource = $("#primaryDatasource").val(); // building | sitework | offsitework
		var secondaryDatasource = $("#secondaryDatasource").val(); // project | template
		var uniqueId = $(element).val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=loadImportJobsiteActivitiesTbody';
		var ajaxQueryString =
			'primaryDatasource=' + encodeURIComponent(primaryDatasource) +
			'&secondaryDatasource=' + encodeURIComponent(secondaryDatasource) +
			'&uniqueId=' + encodeURIComponent(uniqueId);
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
			success: loadImportJobsiteActivitiesTbodySuccess,
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

function loadImportJobsiteActivitiesTbodySuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var htmlRecords = json.htmlRecords;
		$("#tableImportJobsiteActivities tbody").html(htmlRecords);

		$("#tableImportJobsiteActivities tbody input[type=checkbox]:disabled:checked").each(function(i) {
			$(this).wrap('<div class="divTooltipAlreadyImported"></div>');
		});
		$('.divTooltipAlreadyImported').tooltip({
			title: 'Already imported',
			placement: 'right',
			delay: { show: 500, hide: 0 }
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function rbDatasourceClicked(element)
{
	var elementId = $(element).prop('id');
	if (elementId == 'rbTemplate') {
		var datasource = 'template';
		$("#divTemplatesDropdown").removeClass('hidden');
		$("#divProjectsDropdown").addClass('hidden');
		var ddlTemplates = $("#ddlTemplates")[0];
		$("#secondaryDatasource").val('template');
		loadImportJobsiteActivitiesTbody(ddlTemplates);
	} else if (elementId == 'rbProject') {
		var datasource = 'project';
		$("#divTemplatesDropdown").addClass('hidden');
		$("#divProjectsDropdown").removeClass('hidden');
		var ddlProjects = $("#ddlProjects")[0];
		$("#secondaryDatasource").val('project');
		loadImportJobsiteActivitiesTbody(ddlProjects);
	}
}

function loadCreateJobsiteBuildingActivityTemplateDialog(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=loadCreateJobsiteBuildingActivityTemplateDialog';
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
			success: loadCreateJobsiteBuildingActivityTemplateDialogSuccess,
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

function loadCreateJobsiteBuildingActivityTemplateDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divCreateJobsiteBuildingActivityTemplateDialog").html(data);
		$("#divCreateJobsiteBuildingActivityTemplateDialog").removeClass('hidden');
		$("#divCreateJobsiteBuildingActivityTemplateDialog").dialog({
			modal: true,
			title: 'Create Jobsite Building Activity Template',
			width: 600,
			height: 400,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).dialog('destroy');
				$(this).addClass('hidden');
			},
			buttons: {
				'Create Jobsite Building Activity Template': function() {
					createJobsiteBuildingActivityTemplate();
					$(this).dialog('close');
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

// Note: This function is not currently in use.
function loadCreateJobsiteActivityListTemplateDialog(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=loadCreateJobsiteActivityListTemplateDialog';
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
			success: loadCreateJobsiteActivityListTemplateDialogSuccess,
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

// Note: This function is not currently in use.
function loadCreateJobsiteActivityListTemplateDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divCreateJobsiteActivityListTemplateDialog").html(data);
		$("#divCreateJobsiteActivityListTemplateDialog").removeClass('hidden');
		$("#divCreateJobsiteActivityListTemplateDialog").dialog({
			modal: true,
			title: 'Create Jobsite Activity List Template',
			width: 600,
			height: 400,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).dialog('destroy');
				$(this).addClass('hidden');
			},
			buttons: {
				'Create Jobsite Activity List Template': function() {
					createJobsiteActivityListTemplateViaPromiseChain();
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

// Note: This function is not currently in use.
function createJobsiteActivityListTemplateViaPromiseChain()
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var attributeGroupName = 'create-jobsite_activity_list_template-record';
		var uniqueId = 'dummy';
		var promise = createJobsiteActivityListTemplate(attributeGroupName, uniqueId, options);
		promise.then(function(json) {
			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var htmlRecord = json.htmlRecord;
				$("#ddlJobsiteActivityListTemplates").append(htmlRecord);
				$("#divCreateJobsiteActivityListTemplateDialog").dialog('close');
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

function hideManageJobsiteActivityListTemplate()
{
	$("#divManageJobsiteActivityListTemplates").addClass('hidden');
}

function loadManageJobsiteActivityListTemplates(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=loadManageJobsiteActivityListTemplates';
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
			success: loadManageJobsiteActivityListTemplatesSuccess,
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

function loadManageJobsiteActivityListTemplatesSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divManageJobsiteActivityListTemplates").removeClass('hidden');
		$("#divManageJobsiteActivityListTemplates").html(data);
		$("#divManageJobsiteActivityListTemplates").dialog({
			modal: true,
			title: 'Manage Jobsite Activity List Templates',
			width: 1100,
			height: 700,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$(this).addClass('hidden');
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

function Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__Modal_Dialog__Reset_Form(uniqueId, defaultId)
{
	if (typeof defaultId == 'undefined') {
		var defaultId = 1;
	}
	$("#ddl--create-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--" + uniqueId).val(defaultId);
	$("#create-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--" + uniqueId).val(defaultId);
	$("#create-jobsite_activity_list_template-record--jobsite_activity_list_templates--jobsite_activity_list_template--" + uniqueId).val('');
}

function Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__createJobsiteActivityListTemplate(attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.successCallback = Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__createJobsiteActivityListTemplateSuccess;

		createJobsiteActivityListTemplate(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__createJobsiteActivityListTemplateSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var htmlRecordTr = json.htmlRecordTr;
			var htmlRecordOption = json.htmlRecordOption;

			$("#tableJobsiteActivityListTemplates").append(htmlRecordTr);
			$("#ddlJobsiteActivityListTemplates").append(htmlRecordOption);
			var form = $("#formCreateJobsiteActivityListTemplate")[0];
			form.reset();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__deleteJobsiteActivityListTemplate(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.successCallback = Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__deleteJobsiteActivityListTemplateSuccess;

		deleteJobsiteActivityListTemplate(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__deleteJobsiteActivityListTemplateSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;

			$("#ddlJobsiteActivityListTemplates option[value="+uniqueId+"]").remove();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function jobsiteActivityListTemplateSelected(element)
{
	var jobsite_activity_list_template_id = $(element).val();
	if (!jobsite_activity_list_template_id) {
		hideManageJobsiteActivityListTemplate();
		return;
	}
	if (!$("#divManageJobsiteActivityListTemplates").hasClass('hidden')) {
		loadManageJobsiteActivityListTemplates();
	}
	UrlVars.set('jobsite_activity_list_template_id', jobsite_activity_list_template_id);
	if (activeSubsubtab) {
		subsubtabClicked(null, activeSubsubtab);
	}
}

function subsubtabClicked(element, subsubtab, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		activeSubsubtab = subsubtab;

		$(element).closest('ul').find('a').each(function() {
			$(this).removeClass('activeSubtab');
		});
		$(element).addClass('activeSubtab');
		UrlVars.set('subsubtab', subsubtab);

		if (activeSubtab == 'template') {
			var jobsite_activity_list_template_id = $("#ddlJobsiteActivityListTemplates").val();
			if (!jobsite_activity_list_template_id) {
				hideManageJobsiteActivityListTemplate();
				return false;
			}
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=subsubtabClicked';
		var ajaxQueryString =
			'subsubtab=' + encodeURIComponent(subsubtab) +
			'&jobsite_activity_list_template_id=' + encodeURIComponent(jobsite_activity_list_template_id);
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
			success: subsubtabClickedSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return false;
		}

	}
	return false;
}

function subsubtabClickedSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divContent").html(data);
		addWidgets();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showCreateJobsiteActivityLabel()
{
	$("#divCreateJobsiteActivityLabel").toggleClass('hidden');
}

function hideCreateJobsiteActivityLabel()
{
	$("#divCreateJobsiteActivityLabel").addClass('hidden');
}

function showCreateJobsiteBuildingActivity()
{
	$("#divCreateJobsiteBuildingActivity").toggleClass('hidden');
}
function hideCreateJobsiteBuildingActivity()
{
	$("#divCreateJobsiteBuildingActivity").addClass('hidden');
}
function showCreateJobsiteSiteworkActivity()
{
	$("#divCreateJobsiteSiteworkActivity").toggleClass('hidden');
}
function hideCreateJobsiteSiteworkActivity()
{
	$("#formCreateJobsiteSiteworkActivity")[0].reset();
	$("#divCreateJobsiteSiteworkActivity").addClass('hidden');
}
function showCreateJobsiteOffsiteworkActivity()
{
	$("#divCreateJobsiteOffsiteworkActivity").toggleClass('hidden');
}
function hideCreateJobsiteOffsiteworkActivity()
{
	$("#divCreateJobsiteOffsiteworkActivity").addClass('hidden');
}

function showCreateJobsiteBuildingActivityTemplate()
{
	$("#divCreateJobsiteBuildingActivityTemplate").toggleClass('hidden');
}

function hideCreateJobsiteBuildingActivityTemplate()
{
	$("#divCreateJobsiteBuildingActivityTemplate").addClass('hidden');
}

function showCreateJobsiteSiteworkActivityTemplate()
{
	$("#divCreateJobsiteSiteworkActivityTemplate").toggleClass('hidden');
}

function hideCreateJobsiteSiteworkActivityTemplate()
{
	$("#divCreateJobsiteSiteworkActivityTemplate").addClass('hidden');
}

function showCreateJobsiteOffsiteworkActivityTemplate()
{
	$("#divCreateJobsiteOffsiteworkActivityTemplate").toggleClass('hidden');
}

function hideCreateJobsiteOffsiteworkActivityTemplate()
{
	$("#divCreateJobsiteOffsiteworkActivityTemplate").addClass('hidden');
}

function createJobsitePhotoSuccessThenAppendHtmlRecord(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var attributeGroupName = json.attributeGroupName;
		var attributeSubgroupName = json.attributeSubgroupName;
		var dummyId = json.dummyId;
		var htmlRecord = json.htmlRecord;

		var recordContainerElementIdOld = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + dummyId;
		$("#" + recordContainerElementIdOld).remove();
		$("#liUploadedPhotoPlaceholder").remove();
		$("#container--" + attributeGroupName).append(htmlRecord);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

var timerForCreateJobsiteManPower;

/**
 * This wrapper function implements two ways of handling ajax success callbacks.
 * With promises, the callback is inlined in this function. With arrays of
 * jQuery success callbacks, the additional callback function is defined
 * after this function: Daily_Log__ManPower__createJobsiteManPowerSuccess.
 */
function Daily_Log__ManPower__createJobsiteManPower(attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};
		//options.performDomSwapOperation = 'Y';
		//options.onchangeHandlerFunction = 'Daily_Log__ManPower__updateJobsiteManPower';
		//options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = Daily_Log__ManPower__createJobsiteManPowerSuccess;

		//number_of_people = parseInputToInt(number_of_people);
		//$("#" + number_of_people_element_id).val(number_of_people);

		updateManpowerTotal();
		clearTimeout(timerForCreateJobsiteManPower);

		// Set a delay of 0.5s (500ms) to allow for the user to use Chrome's up arrow for a text box number change.
		timerForCreateJobsiteManPower = setTimeout(function() {

			createJobsiteManPower(attributeGroupName, uniqueId, options);
			//var promise = createJobsiteManPower(attributeGroupName, uniqueId, options);
			// If you uncommented the options.successCallback line, then comment out this block of code.
			/*
			promise.then(function(data, textStatus, jqXHR) {
				try {

					var json = data;
					var errorNumber = json.errorNumber;

					if (errorNumber == 0) {
						var attributeGroupName = json.attributeGroupName; // E.g. "manage-project-record"
						var attributeSubgroupName = json.attributeSubgroupName; // E.g. "projects"
						var uniqueId = json.uniqueId; // New Id, E.g. "--1234"
						var previousAttributeGroupName = json.previousAttributeGroupName; // E.g. "create-project-record"
						var dummyId = json.dummyId; // Old pk/uk dummy placeholder

						var elementId = attributeGroupName + '--' + attributeSubgroupName + '--number_of_people--' + uniqueId;
						var elementIdOld = previousAttributeGroupName + '--' + attributeSubgroupName + '--number_of_people--' + dummyId;

						var onchangeHandler = "Daily_Log__ManPower__updateJobsiteManPower(this, { responseDataType : 'json' })";

						// Update the id and onchange handler
						var element = $("#" + elementIdOld);
						element.prop('id', elementId);
						var onchangeOld = element.attr('onchange');
						element.attr('onchange', onchangeHandler);
					}

				} catch (error) {

					if (window.showJSExceptions) {
						var errorMessage = error.message;
						alert('Exception Thrown: ' + errorMessage);
						return;
					}

				}
			});
			*/
			// Comment out to here.
		}, 500);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Daily_Log__ManPower__createJobsiteManPowerSuccess(data, textStatus, jqXHR)
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

			var elementId = attributeGroupName + '--' + attributeSubgroupName + '--number_of_people--' + uniqueId;
			var elementIdOld = previousAttributeGroupName + '--' + attributeSubgroupName + '--number_of_people--' + dummyId;

			var onchangeHandler = "Daily_Log__ManPower__updateJobsiteManPower(this, { responseDataType : 'json' })";

			// Update the id and onchange handler
			var element = $("#" + elementIdOld);
			element.prop('id', elementId);
			var onchangeOld = element.attr('onchange');
			element.attr('onchange', onchangeHandler);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

var timerForUpdateJobsiteManPower;
function Daily_Log__ManPower__updateJobsiteManPower(element)
{
	try {

		var options = options || {};
		options.responseDataType = 'json';

		updateManpowerTotal();

		// Potentially delete the record instead if it is set to 0 or ""
		/*
		$(element).val(newValue.toString());
		if (newValue == '') {
			return;
		}
		*/

		clearTimeout(timerForUpdateJobsiteManPower);
		timerForUpdateJobsiteManPower = setTimeout(function() {
			updateJobsiteManPower(element, options);
		}, 500);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

var timerForSaveJobsiteManPower;
function setTimeoutForSaveJobsiteManPower(attributeGroupName, uniqueId)
{
	clearTimeout(timerForSaveJobsiteManPower);
	timerForSaveJobsiteManPower = setTimeout(function() {
		saveJobsiteManPower(attributeGroupName, uniqueId);
	}, 500);
}

function jobsiteSignInSheetFileManagerFileUploadComplete(id, name, responseJSON, xhr)
{
	var arrFileManagerFiles = responseJSON.fileMetadata;
	Daily_Log__ManPower__signInSheetUploaded(arrFileManagerFiles);
	$("#uploaderJobsiteSignInSheets .qq-upload-list li:last").fadeOut(1200);
}

function jobsiteFieldReportFileManagerFileUploadComplete(id, name, responseJSON, xhr)
{
	var arrFileManagerFiles = responseJSON.fileMetadata;
	Daily_Log__ManPower__fieldReportUploaded(arrFileManagerFiles);
	$("#uploaderJobsiteFieldReports .qq-upload-list li:last").fadeOut(1200);
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
