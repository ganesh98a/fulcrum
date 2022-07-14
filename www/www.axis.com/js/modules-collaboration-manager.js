
var setAccordions = true;
var setAccordionEmail = true;
var discussionsToOpen = '';
var cancelCloneMeetingDataToNextMeeting = false;

if (!jQuery) {
	alert('JQuery is either not loaded or unavailable.');
}

// Document.ready
(function($) {
	$(document).ready( function() {

		resetMeetingPermission();

		$("#ddl_meeting_type_id").on('change', function() {
			if ($(this).val() == '-2') {
				$("#buttonRefreshMeetingDetails").attr('disabled', 'true');
				$("#ddl_meeting_id").attr('disabled', 'true');
			} else {
				$("#ddl_meeting_id").removeAttr('disabled');
			}
		});

		var meeting_type_id = UrlVars.get('meeting_type_id');
		if (!meeting_type_id) {
			if ((typeof(default_meeting_type_id) != 'undefined') && (default_meeting_type_id != '')) {
				meeting_type_id = default_meeting_type_id;
			}
		}

		if (meeting_type_id) {
			$("#ddl_meeting_type_id").val(meeting_type_id);
			$("#ddl_meeting_id").attr('disabled', false);
			var options = { promiseChain: true };
			var promise = loadMeetingsByMeetingTypeId(options);
			promise.then(function() {
				var meeting_id = UrlVars.get('meeting_id');
				if (meeting_id) {
					$("#ddl_meeting_id").val(meeting_id);
					loadMeetingDetails();
					loadDiscussionItemsByMeetingId();
				}
			});
		}

		$(document).bind('ajaxStop', function() {
			//alert(discussionsToOpen);

			if (setAccordions) {
				$(".accordion").accordion({
					header: '.header',
					collapsible: true,
					heightStyle: 'content',
					//autoHeight: false,
					change: accordionChanged,
					active: 'none'
				});

				$(".accordionActions").accordion({
					header: '.headerActions',
					collapsible: true,
					heightStyle: 'content',
					//autoHeight: false,
					active: 'none',
					animated: false
				});

				$(".accordionComments").accordion({
					header: '.headerComments',
					collapsible: true,
					heightStyle: 'content',
					//autoHeight: false,
					active: 'none'
				});

				if ( $("#userCanSort").length > 0 && $("#userCanSort").val() == 1 ) {
					$("#discussionList").sortable({
						axis: 'y',
						distance: 10,
						containment: "#discussionListContainer",
						helper: sortHelper,
						update: function(event, ui) {
							var element = $(ui.item)[0];
							var endIndex = $(element).index();
							endIndex = endIndex.toString();
							var options = { endIndex: endIndex };
							Collaboration_Manager__Meetings__updateDiscussionItem(element, options);
						}
					});
				}

				if (typeof discussionsToOpen != 'undefined' && discussionsToOpen.length > 0) {
					var ary = discussionsToOpen.split(',');
					for(var i=0; i < ary.length; i++) {
						$("#item_" + ary[i]).accordion({ active: 0 });
						$("#accordionAction_" + ary[i]).accordion({ active: 0 });
					}
				}

				setAccordions = false;

			}

			if (setAccordionEmail) {
				if ($(".accordionEmailOptions").length) {
					$(".accordionEmailOptions").accordion({
						header: '.emailGroupSubcategory',
						collapsible: true,
						autoHeight: false,
						active: 'none'
					});
				}
				setAccordionEmail = false;
			}

			$(".accordion").not('.editElement').show();
			$(".sortableContainer").find('select').removeClass('ui-helper-reset');
			$(".sortableContainer").find('input').removeClass('ui-helper-reset');

			$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1,minDate: 0});
			if(jQuery().timepicker) {
				$(".timepicker").timepicker({
					'scrollDefaultTime': 44100, // Seconds from midnight to 12:15pm
					'step': 15,
					'modifyTimepickerCss': modifyTimepickerCss
				});
				//$(".timepicker").on('changeTime', function() {
				//	var id = this.id;
				//	var time = $(this).val();
				//	timeSelected(id, time);
				//});
			}
			initializeAutoHintFields();
			//$(".autogrow").jtextarea();
			if(jQuery().elastic) {
				$(".autogrow").elastic();
			}
			//$(".autogrow").css('max-height','200');
			$(".positive-integer").numeric({ decimal: false, negative: false }, function() { alert('Positive integers only'); this.value = ''; this.focus(); });
			//$(".hideMeAfterLoad").hide();

			$("#td-discussion-editOption").hide();
			$("#td-discussion-expandOptions").hide();
			$(".sortableContainer").each(function() {
				$("#td-discussion-editOption").show();
				$("#td-discussion-expandOptions").show();
				if ($(this).find('.editElement').length == 0) {
					$(this).find('.discussion-item-edit-button').hide();
				} else {
					$(this).find('.discussion-item-edit-button').show();
				}
			});

			activateHelpHints();

			var collapseAllDiscussionItems = ClientVars.get('collapseAllDiscussionItems');
			if (!collapseAllDiscussionItems) {
				expandAllItems();
			}

		});

	});
})(jQuery);

function resetMeetingPermission(){
	$.ajax({
		type : "post",
		url	 :  window.ajaxUrlPrefix+"modules-collaboration-manager-ajax.php?method=resetMeetingPermission",
		data : '',
		cache :false,
		success :function(html) { }
	});
}

function trimAutoGrows()
{
	$(".autogrow").each( function() {
		if ($(this).hasClass('auto-hint') == false) {
			$(this).focus();
		}
	});
}

function accordionChanged(element, javaScriptEvent, ui)
{
	trimAutoGrows();
}

function timeSelected(elementId, newTime)
{
	//alert(elementId + ' ' + newTime);
	if ( ( $("#btnSaveNewMeeting").length == 0 || !$("#btnSaveNewMeeting").is(':visible') ) && elementId.indexOf('meeting') >= 0 ) {
		// Update the meeting date info (edit only) / Not when new meeting.
		var meeting_id = $("#ddl_meeting_id").val();
		var elementId = elementId.replace('edit_','');
		//alert(elementId);
		updateMeetingItem(elementId, meeting_id);
	}
}

function loadMeetingsByMeetingTypeId(options)
{
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		var meeting_type_id = $("#ddl_meeting_type_id").val();
		var project_id = $("#currentlySelectedProjectId").val();
		meeting_type_id = $.trim(meeting_type_id);

		$("#divMeetingDetails").html('');
		$("#discussionList").html('');
		if (meeting_type_id == '-2') {
			return;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadMeetingsByMeetingTypeId';
		var ajaxQueryString =
			'meeting_type_id=' + encodeURIComponent(meeting_type_id)+'&project_id=' + encodeURIComponent(project_id);
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
			success: loadMeetingsByMeetingTypeIdSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}
		
		UrlVars.setmultiple('meeting_type_id', meeting_type_id);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadMeetingsByMeetingTypeIdSuccess(data, textStatus, jqXHR)
{
	try {

		$("#ddl_meeting_id").html(data);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadMeetingsLoaded()
{
	if ($("#ddl_meeting_id").val() == -2) {
		$("#btnShowNewDiscussionItem").hide();
		$("#btnImportDiscussionItem").hide();
	} else {
		$("#btnShowNewDiscussionItem").show();
		$("#btnImportDiscussionItem").show();
	}
	loadDiscussionItemsByMeetingId('');
	loadMeetingDetails();
}

function loadMeetingDetails()
{
	try {

		var meeting_id = $("#ddl_meeting_id").val();
		meeting_id = $.trim(meeting_id);
		var project_id = $("#currentlySelectedProjectId").val();
		$("#buttonRefreshMeetingDetails").attr('disabled', 'true');

		if (meeting_id.length > 0 && meeting_id != '-2') {
			var meeting_type_id = $("#ddl_meeting_type_id").val();
			meeting_type_id = $.trim(meeting_type_id);
			$("#divMeetingDetails").show();

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadMeetingDetails';
			var ajaxQueryString =
				'meeting_id=' + encodeURIComponent(meeting_id) +
				'&meeting_type_id=' + encodeURIComponent(meeting_type_id)+
				'&project_id=' + encodeURIComponent(project_id);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			$("#divMeetingDetails").load(ajaxUrl, meetingDetailsLoaded);
			//$("#divMeetingDetails").load('/modules-collaboration-manager-ajax.php?method=loadMeetingDetails&meeting_id=' +
			// encodeURIComponent(meeting_id) + '&meeting_type_id=' + encodeURIComponent(meeting_type_id), meetingDetailsLoaded);
		} else {
			//alert('it should hide');
			//$("#divMeetingDetails").hide();
			$("#divMeetingDetails").html('');
			$("#discussionList").html('');
		}
		$("#btnShowNewMeetingItem").show();
		$(".exportOptions").show();
		UrlVars.set('meeting_id', meeting_id);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function meetingDetailsLoaded()
{
	try {

		// If it is not the first meeting of this type then they can import items from previous meetings.
		if ($("#ddl_meeting_id").prop('selectedIndex') + 1 == $("#ddl_meeting_id option").size() ) {
			$('#btnImportDiscussionItem').hide();
		} else {
			$('#btnImportDiscussionItem').show();
		}

		$(".nextMeetingData").on('change', function(e) {
			$("#buttonCreateNextMeeting").removeClass('hidden');
		});

		$("#buttonRefreshMeetingDetails").removeAttr('disabled');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadDiscussionItemsByMeetingId(toOpen)
{
	try {

		setAccordions = true;
		discussionsToOpen = toOpen;
		var showAll = false;
		if ($("#chkShowAll").length) {
			showAll = $("#chkShowAll").is(':checked');
		} else {
			showAll = true;
		}

		var meeting_type_id = $("#ddl_meeting_type_id").val();
		var meeting_id = $("#ddl_meeting_id").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadDiscussionItemsByMeetingId';
		var ajaxQueryString =
			'showAll=' + showAll +
			'&meeting_type_id=' + encodeURIComponent(meeting_type_id) +
			'&meeting_id=' + encodeURIComponent(meeting_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#discussionList").load(ajaxUrl, loadDiscussionItemsByMeetingIdSuccess);
		//$("#discussionList").load('/modules-collaboration-manager-ajax.php?method=loadDiscussionItemsByMeetingId&showAll='+showAll+
		// '&meeting_type_id=' + encodeURIComponent(meeting_type_id) + '&meeting_id=' + encodeURIComponent(meeting_id) );

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadDiscussionItemsByMeetingIdSuccess()
{
	$(".bs-tooltip").tooltip();

	$(".accordionActionItem").accordion({
		collapsible: true,
		heightStyle: 'content'
	});
}

function showNewMeeting()
{
	try {

		var meeting_id = '0';

		var meeting_type_id = $("#ddl_meeting_type_id").val();
		meeting_type_id = $.trim(meeting_type_id);
		$("#divMeetingDetails").show();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadMeetingDetails';
		var ajaxQueryString =
			'meeting_id=' + encodeURIComponent(meeting_id) +
			'&meeting_type_id=' + encodeURIComponent(meeting_type_id);
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
			success: showNewMeetingSuccess,
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

function showNewMeetingSuccess(data, textStatus, jqXHR)
{
	//alert('newMeetElements');
	$("#divMeetingDetails").html(data);
	$("#divMeetingDetails .editElement").show();
	$("#divMeetingDetails .showElement").hide();
	$("#btnShowNewMeetingItem").hide();
	$(".exportOptions").hide();
	$("#btnDeleteMeeting").hide();
	$("#btnEditMeetingInformation").hide();
}

function Collaboration_Manager__createMeeting(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__createMeetingSuccess;

		ajaxQueryString = '';
		if (options.ddl_meeting_type_id) {
			var meeting_type_id = $('#ddl_meeting_type_id').val();
			ajaxQueryString = ajaxQueryString + '&meeting_type_id=' + encodeURIComponent(meeting_type_id);
		}

		var next_meeting_location_id_element_id = attributeGroupName + '--meetings--next_meeting_location_id--' + uniqueId;
		if ($("#" + next_meeting_location_id_element_id).length) {
			var next_meeting_location_id = $("#" + next_meeting_location_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&next_meeting_location_id=' + encodeURIComponent(next_meeting_location_id);
		}

		// Meeting start date (meeting_start_date)
		var meeting_start_date_element_id = attributeGroupName + '--meetings--meeting_start_date--' + uniqueId;
		if ($("#" + meeting_start_date_element_id).length) {
			var meeting_start_date = $("#" + meeting_start_date_element_id).val();
			meeting_start_date = convertDateToMySQLFormat(meeting_start_date);			
		}

		// Meeting start time (meeting_start_time)
		var meeting_start_time_element_id = attributeGroupName + '--meetings--meeting_start_time--' + uniqueId;
		if ($("#" + meeting_start_time_element_id).length) {
			var meeting_start_time = $("#" + meeting_start_time_element_id).val();
			meeting_start_time = convertTimeToMySQLFormat(meeting_start_time);
		}

		// Meeting end date (meeting_end_date)
		var meeting_end_date_element_id = attributeGroupName + '--meetings--meeting_end_date--' + uniqueId;
		if ($("#" + meeting_end_date_element_id).length) {
			var meeting_end_date = $("#" + meeting_end_date_element_id).val();
			meeting_end_date = convertDateToMySQLFormat(meeting_end_date);
		}

		// Meeting end time (meeting_end_time)
		var meeting_end_time_element_id = attributeGroupName + '--meetings--meeting_end_time--' + uniqueId;
		if ($("#" + meeting_end_time_element_id).length) {
			var meeting_end_time = $("#" + meeting_end_time_element_id).val();
			meeting_end_time = convertTimeToMySQLFormat(meeting_end_time);
		}

		// Next meeting start date (next_meeting_start_date)
		var next_meeting_start_date_element_id = attributeGroupName + '--meetings--next_meeting_start_date--' + uniqueId;
		if ($("#" + next_meeting_start_date_element_id).length) {
			var next_meeting_start_date = $("#" + next_meeting_start_date_element_id).val();
			next_meeting_start_date = convertDateToMySQLFormat(next_meeting_start_date);
			ajaxQueryString = ajaxQueryString + '&next_meeting_start_date=' + encodeURIComponent(next_meeting_start_date);
		}

		// Next meeting start time (next_meeting_start_time)
		var next_meeting_start_time_element_id = attributeGroupName + '--meetings--next_meeting_start_time--' + uniqueId;
		if ($("#" + next_meeting_start_time_element_id).length) {
			var next_meeting_start_time = $("#" + next_meeting_start_time_element_id).val();
			next_meeting_start_time = convertTimeToMySQLFormat(next_meeting_start_time);
			ajaxQueryString = ajaxQueryString + '&next_meeting_start_time=' + encodeURIComponent(next_meeting_start_time);
		}

		// Next meeting end date (next_meeting_end_date)
		var next_meeting_end_date_element_id = attributeGroupName + '--meetings--next_meeting_end_date--' + uniqueId;
		if ($("#" + next_meeting_end_date_element_id).length) {
			var next_meeting_end_date = $("#" + next_meeting_end_date_element_id).val();
			next_meeting_end_date = convertDateToMySQLFormat(next_meeting_end_date);
			ajaxQueryString = ajaxQueryString + '&next_meeting_end_date=' + encodeURIComponent(next_meeting_end_date);
		}

		// Next meeting end time (next_meeting_end_time)
		var next_meeting_end_time_element_id = attributeGroupName + '--meetings--next_meeting_end_time--' + uniqueId;
		if ($("#" + next_meeting_end_time_element_id).length) {
			var next_meeting_end_time = $("#" + next_meeting_end_time_element_id).val();
			next_meeting_end_time = convertTimeToMySQLFormat(next_meeting_end_time);
			ajaxQueryString = ajaxQueryString + '&next_meeting_end_time=' + encodeURIComponent(next_meeting_end_time);
		}

		var next_all_day_event_flag_element_id = attributeGroupName + '--meetings--next_all_day_event_flag--' + uniqueId;
		if ($("#" + next_all_day_event_flag_element_id).length) {
			var next_all_day_event_flag = $("#" + next_all_day_event_flag_element_id).is(':checked') ? 'Y' : 'N';
			ajaxQueryString = ajaxQueryString + '&next_all_day_event_flag=' + encodeURIComponent(next_all_day_event_flag);
		}

		// Meeting id in case hidden meeting exists.
		var meeting_id_element_id = attributeGroupName + '--meetings--meeting_id--' + uniqueId;
		if ($("#" + meeting_id_element_id).length) {
			var meeting_id = $("#" + meeting_id_element_id).val();
			if (meeting_id != '-1') {
				ajaxQueryString = ajaxQueryString + '&meeting_id=' + encodeURIComponent(meeting_id);
				ajaxQueryString = ajaxQueryString + '&createFromHidden=1';
			}
		}

		// Meeting Attendees
		var meetingAttendeeClassSelector = attributeGroupName + '--meetingAttendee';
		var arrMeetingAttendees = [];
		$("." + meetingAttendeeClassSelector + ":checked").each(function () {
			arrMeetingAttendees.push($(this).val());
		});
		var csvMeetingAttendees = arrMeetingAttendees.join(',');
		ajaxQueryString = ajaxQueryString + '&csvMeetingAttendees=' + encodeURIComponent(csvMeetingAttendees);

		var requireAttendees = options.requireAttendees;
		if (requireAttendees && arrMeetingAttendees.length == 0) {
			messageAlert('At least one attendee is required.', 'errorMessage');
			return;
		}

		var check = checkTimeForMeeting(meeting_start_date,meeting_start_time,meeting_end_date,meeting_end_time,next_meeting_start_date,next_meeting_start_time,next_meeting_end_date,next_meeting_end_time);

		if (check == 0) {
			options.adHocQueryParameters = ajaxQueryString;
			createMeeting(attributeGroupName, uniqueId, options);
		}

		

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function checkTimeForMeeting(meeting_start_date,meeting_start_time,meeting_end_date,meeting_end_time,next_meeting_start_date,next_meeting_start_time,next_meeting_end_date,next_meeting_end_time){

	var startDate 		= meeting_start_date+' '+meeting_start_time;
	var endDate 		= meeting_end_date+' '+meeting_end_time;
	var nextStartDate 	= next_meeting_start_date+' '+next_meeting_start_time;
	var nextEndDate 	= next_meeting_end_date+' '+next_meeting_end_time;

	if (meeting_start_date == '' || meeting_start_time == '') {
		messageAlert('Start Time is required.', 'errorMessage');
		return 1;
	}else if (meeting_end_date == '' || meeting_end_time == '') {
		messageAlert('End Time is required.', 'errorMessage');
		return 1;
	}else if (next_meeting_start_date == '' || next_meeting_start_time == '') {
		messageAlert('Next Meeting Start Time is required.', 'errorMessage');
		return 1;
	}else if (next_meeting_end_date == '' || next_meeting_end_time == '') {
		messageAlert('Next Meeting End Time is required.', 'errorMessage');
		return 1;
	}else if (startDate > endDate) {
		messageAlert('End Time is less than Start Time.', 'errorMessage');
		return 1;
	}else if (nextStartDate > nextEndDate) {
		messageAlert('Next Meeting End Time is less than Next Meeting Start Time.', 'errorMessage');
		return 1;
	}else if(startDate == endDate) {
		messageAlert('End Time is same as Start Time.', 'errorMessage');
		return 1;
	}else if (nextStartDate == nextEndDate) {
		messageAlert('Next Meeting End Time is same as Next Meeting Start Time.', 'errorMessage');
		return 1;
	}else if(nextStartDate < endDate){
		messageAlert('Next Meeting Start Time is less than End Time.', 'errorMessage');
		return 1;
	}else if(nextStartDate < startDate){
		messageAlert('Next Meeting Start Time is less than Start Time.', 'errorMessage');
		return 1;
	}else{
		return 0;
	}
}

function Collaboration_Manager__createMeetingSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var htmlSelectOptions = json.htmlSelectOptions;
			$("#ddl_meeting_id").html(htmlSelectOptions);
			$("#ddl_meeting_id").removeAttr('disabled');
			$("#buttonRefreshMeetingDetails").removeAttr('disabled');
			$("#divCreateMeetingDialog").dialog('close');
			loadMeetingDetails();
			loadDiscussionItemsByMeetingId();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__deleteMeeting(element, javaScriptEvent, meeting_id)
{
	try {

		trapJavaScriptEvent(javaScriptEvent);

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__deleteMeetingSuccess;

		var meetingType = $("#ddl_meeting_type_id option:selected").text();
		var meetingLabel = $("#ddl_meeting_id option:selected").text();

		var confirmationDialogMessage = '' +
		'<br>Are you sure you want to delete the following meeting?' +
		'<br><br>' +
		'&ldquo;' + meetingType + ' &mdash; ' + meetingLabel + '&rdquo;' +
		'<br><br>' +
		'This will delete all discussion items and comments for this meeting. ' +
		'<br><br>' +
		'It will also delete all action items if the action items are not associated with other discussion items.';

		options.confirmationDialogMessage = confirmationDialogMessage;
		options.confirmationDialogTitle = 'Delete Meeting?';
		options.confirmButtonText = 'Delete';
		options.cancelButtonText = 'Cancel';
		options.confirmationDialogWidth = 600;
		options.confirmationDialogHeight = 400;

		var confirmationDialogPromise = confirmationDialog(options);

		confirmationDialogPromise.done(function() {
			// They pressed Delete
			var recordContainerElementId = 'record_container--manage-meeting-record--meetings--meeting_id--' + meeting_id;
			var attributeGroupName = 'manage-meeting-record';
			var uniqueId = meeting_id;

			deleteMeeting(recordContainerElementId, attributeGroupName, uniqueId, options);
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

function Collaboration_Manager__deleteMeetingSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			$("#ddl_meeting_id option[value="+uniqueId+"]").remove();
			loadMeetingDetails();

			// Or this one?
			//var messageText = 'Meeting successfully deleted';
			//messageAlert(messageText, 'successMessage');
			//loadMeetings(0);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function cancelNewMeeting()
{
	$("#btnShowNewMeetingItem").show();
	$(".exportOptions").show();
	loadMeetingDetails();
}

function expandAllItems()
{
	$(".header").each(function() {
		if ($(this).hasClass('ui-state-active') == false) {
			//$(this).parent().accordion('activate',0);
			$(this).parent().accordion('option', 'active', 0);
		}
	});

	$(".headerActions").each(function() {
		if ($(this).css('display') != 'none') {
			if ($(this).hasClass('ui-state-active') == false) {
				//$(this).parent().accordion('activate',0);
				$(this).parent().accordion('option', 'active', 0);
			}
		}
	});

	$(".headerComments").each(function() {
		if ($(this).css('display') != 'none') {
			if ($(this).hasClass('ui-state-active') == false) {
				//$(this).parent().accordion('activate',0);
				$(this).parent().accordion('option', 'active', 0);
			}
		}
	});

	ClientVars.remove('collapseAllDiscussionItems');
}

function collapseAllItems()
{
	//$(".accordion").accordion('activate', false);
	$(".accordion").accordion('option', 'active', false);
	ClientVars.set('collapseAllDiscussionItems', true);
}

function updateMeetingItem(elementId, meeting_id)
{
	try {

		elementId = $.trim(elementId);
		meeting_id = $.trim(meeting_id);

		if (meeting_id != 0) {
			//alert("updateMeetingItem: " + elementId + ' ' + meeting_id);
			var newValue = $("#edit_" + elementId).val();
			//alert('newValue ' + newValue);

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=updateMeetingItem';
			var ajaxQueryString =
				'elementId=' + encodeURIComponent(elementId) +
				'&meeting_id=' + encodeURIComponent(meeting_id) +
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
				success: updateMeetingItemSuccess,
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

function updateMeetingItemSuccess(result, textStatus, jqXHR)
{
	try {

		var ary = result.split('|');
		var editElement = $("#edit_" + ary[0]);
		var showElement = $("#show_" + ary[0]);
		if (ary[0] == 'status') {
			var newStatus = 'Open';
			if ($(editElement).val() == 0) {
				newStatus = 'Closed';
			}
			$(showElement).html(newStatus);
		} else {
			$(showElement).html($(editElement).val());
		}
		var messageText = 'Meeting ' + ary[1] + ' was successfully updated';
		//messageAlert(messageText,'successMessage','successMessageLabel', $(editElement).attr('id') );
		messageAlert(messageText,'successMessage');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleAttendee(contact_id)
{
	try {

		if ( $("#btnSaveNewMeeting").length == 0 || !$("#btnSaveNewMeeting").is(':visible') ) {
			// Update the meeting date info (edit only) / Not when new meeting.
			contact_id = $.trim(contact_id);
			var meeting_id = $("#ddl_meeting_id").val();
			meeting_id = $.trim(meeting_id);

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=toggleAttendee';
			var ajaxQueryString =
				'meeting_id=' + encodeURIComponent(meeting_id) + '&contact_id=' + encodeURIComponent(contact_id);
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
				success: toggleAttendeeSuccess,
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

function toggleAttendeeSuccess(result, textStatus, jqXHR)
{
	try {

		var ary = result.split('|');
		var contact_id = ary[0];
		if (ary[1] == 0) {
			$("#show_meetingAttendee_" + contact_id).hide();
		} else {
			$("#show_meetingAttendee_" + contact_id).show();
		}
		var messageText = 'Meeting attendee was successfully updated';
		//messageAlert(messageText,'successMessage','successMessageLabel', $("#edit_meetingAttendee_" + contact_id).attr('id') );
		messageAlert(messageText,'successMessage');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function reloadComments(discussion_item_id)
{
	try {
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=reloadComments';
		var ajaxQueryString =
			'discussion_item_id=' + encodeURIComponent(discussion_item_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}
		$("#accordionCommment_" + discussion_item_id).accordion('destroy');
		$("#accordionCommment_" + discussion_item_id).load(ajaxUrl, reloadCommentsDone);
		//$("#accordionCommment_" + discussion_item_id).load( '/modules-collaboration-manager-ajax.php?method=reloadComments&discussion_item_id=' + encodeURIComponent(discussion_item_id), reloadCommentsDone );

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function reloadCommentsDone()
{
	try {

		$("#" + this.id).accordion({
			header: '.headerComments',
			collapsible: true,
			autoHeight: false,
			active: 0
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function reloadActions(discussion_item_id)
{
	try {

		discussion_item_id = $.trim(discussion_item_id);
		var meeting_type_id = $("#ddl_meeting_type_id").val();
		meeting_type_id = $.trim(meeting_type_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=reloadActions';
		var ajaxQueryString =
			'discussion_item_id=' + encodeURIComponent(discussion_item_id) +
			'&meeting_type_id=' + encodeURIComponent(meeting_type_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#accordionAction_" + discussion_item_id).accordion('destroy');
		$("#accordionAction_" + discussion_item_id).load(ajaxUrl, reloadActionsDone);
		//$("#accordionAction_" + discussion_item_id).load( '/modules-collaboration-manager-ajax.php?method=reloadActions&discussion_item_id=' +
		// encodeURIComponent(discussion_item_id) + '&meeting_type_id=' + encodeURIComponent(meeting_type_id), reloadActionsDone );

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function reloadActionsDone()
{
	try {

		$("#" + this.id).accordion({
			header: '.headerActions',
			collapsible: true,
			heightStyle: 'content',
			//autoHeight: false,
			active: 'none'
		});

		var ary = this.id.split("_");
		var discussion_item_id = ary[1];
		if ($("#btnEditDiscussion_" + discussion_item_id).html() == 'Done') {
			$("#edit_BtnContainer_" + discussion_item_id + ' .editElement').show();
			$("#item_" + discussion_item_id + ' .editElement').show();
			$("#item_" + discussion_item_id + ' .showElement').hide();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showNewDiscussion()
{
	$("#formNewDiscussionItem").show();
	$("#btnShowNewDiscussionItem").hide();
	$("#btnImportDiscussionItem").hide();
	$('#formNewDiscussionItem').trigger("reset");
	$('#rfi_value').hide();
	$('#submittal_value').hide();
	$('.fs-option').removeClass("selected");
	$('.fs-label').html('Select some options');
	
}

function cancelNewDiscussionItem()
{
	$("#formNewDiscussionItem").hide();
	$("#btnShowNewDiscussionItem").show();
	$("#btnImportDiscussionItem").show();
}

function showNewActionItem(discussion_item_id)
{
	$("#accordionAction_" + discussion_item_id).find('.headerActions').show();
	$("#accordionAction_" + discussion_item_id).find('.ui-accordion-content').show();
	$("#frmNewActionItem_" + discussion_item_id).show();
	$("#btnNewAction_" + discussion_item_id).hide();

	if ( $("#accordionAction_" + discussion_item_id + " :first").hasClass('ui-state-active') == false ) {
		$("#accordionAction_" + discussion_item_id).accordion('activate',0);
	}
}

function cancelNewActionItem(discussion_item_id)
{
	if ($("#accordionAction_" + discussion_item_id).find('.headerActions').html().indexOf('(0)') > 0) {
		$("#accordionAction_" + discussion_item_id).find('.headerActions').hide();
		$("#accordionAction_" + discussion_item_id).find('.ui-accordion-content').hide();
	}
	$("#frmNewActionItem_" + discussion_item_id).hide();
	$("#btnNewAction_" + discussion_item_id).show();
}

function saveNewActionItem(discussion_item_id)
{
	try {

		discussion_item_id = $.trim(discussion_item_id);
		var action = $("#newAction_" + discussion_item_id).val();
		action = $.trim(action);
		if (action.length > 0) {
			var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=newAction';
			var ajaxQueryString =
				'&discussion_item_id=' + encodeURIComponent(discussion_item_id) +
				'&' + $("#frmNewActionItem_" + discussion_item_id).serialize();
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
				success: saveNewActionItemSuccess,
				error: errorHandler
			});
		} else {
			var messageText = 'You must enter a description for your action item';
			//messageAlert(messageText, 'errorMessage', 'errorMessageLabel', $("#newAction_" + discussion_item_id).attr('id') );
			messageAlert(messageText, 'errorMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function saveNewActionItemSuccess(result, textStatus, jqXHR)
{
	try {

		var discussion_item_id = result;
		// Clear form inputs
		$("#frmNewActionItem_" + discussion_item_id + ' :input').each(function() {
			switch(this.type) {
				case 'text':
					$(this).val('');
				break;
				case 'hidden':
					$(this).val('');
				break;
				case 'textarea':
					$(this).val('');
				break;
			}
		});
		$("#frmNewActionItem_" + discussion_item_id).hide();
		$("#btnNewAction_" + discussion_item_id).show();
		reloadActions(discussion_item_id);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function addAssigneeToNewAction(discussion_item_id)
{
	var contact_id = $("#selNewAssignedTo_" + discussion_item_id).val();
	var contactName = $("#selNewAssignedTo_" + discussion_item_id).children('option').filter(':selected').text();

	if (contact_id != 0) {

		if ($("#newActionAssignees_" + discussion_item_id).val() == '') {
			var contactList = new Array();
		} else {
			var contactList = $("#newActionAssignees_" + discussion_item_id).val().split(',');
		}
		var addNewID = true;
		for(var i=0; i<contactList.length;i++) {
			if (contactList[i] == contact_id) {
				addNewID = false;
			}
		}
		if (addNewID) {
			contactList.push(contact_id);
			$("#ulNewActionAssignees_" + discussion_item_id).append('<li id="'+discussion_item_id+'_'+contact_id+'"><a href="javascript:removeAssigneeFromNewAction(\''+discussion_item_id+'_'+contact_id+'\');" class="smallerFont">X</a> '+contactName+'</li>')
		}

		$("#newActionAssignees_" + discussion_item_id).val(contactList.join(','));
	}
}

function removeAssigneeFromNewAction(elementId)
{
	var ary = elementId.split('_');
	var discussion_item_id = ary[0];
	var contact_id = ary[1];
	var contactList = $("#newActionAssignees_" + discussion_item_id).val().split(',');
	var newContactList = new Array();
	for(var i=0; i<contactList.length;i++) {
		if (contactList[i] != contact_id) {
			newContactList.push(contactList[i]);
		}
	}
	$("#newActionAssignees_" + discussion_item_id).val(newContactList.join(','));
	$("#" + elementId).remove();
}



function globalShowEditDiscussion()
{
	if ($("#btnGlobalEdit").text() == 'Edit Discussion Items') {
		showEditDiscussion(0);
		$("#btnGlobalEdit").text('Done Editing');
		$(".discussion-item-edit-button").html('Done');
		showEditActionItems(false);
	} else {
		cancelDiscussionItemChanges(0);
		$("#btnGlobalEdit").text('Edit Discussion Items');
		$(".discussion-item-edit-button").html('Edit');
		//$(".discussion-item-edit-button").val('Edit');
		hideEditActionItems(false);
	}

}

function showEditDiscussion(discussion_item_id)
{
	if (discussion_item_id == 0) {
		$("#discussionList .editElement").show();
		$("#discussionList .showElement").not('.discussion-item-edit-button').hide();
	} else {

		var tmpDiscussionItemContainerHtmlLabel = $("#btnEditDiscussion_" + discussion_item_id).html();
		var tmpDiscussionItemContainerButtonLabel = $("#btnEditDiscussion_" + discussion_item_id).val();
		if ((tmpDiscussionItemContainerHtmlLabel == 'Edit') || (tmpDiscussionItemContainerButtonLabel == 'Edit')) {
			var editDiscussionItemFlag = true;
		} else {
			var editDiscussionItemFlag = false;
		}

		if (editDiscussionItemFlag) {

			$("#btnGlobalEdit").text('Done Editing');
			$("#edit_BtnContainer_" + discussion_item_id + ' .editElement').show();
			$("#item_" + discussion_item_id + ' .editElement').show();
			$("#item_" + discussion_item_id + ' .showElement').hide();
			$("#btnEditDiscussion_" + discussion_item_id).html('Done');
			//$("#btnEditDiscussion_" + discussion_item_id).val('Done');
			showEditActionItems(discussion_item_id);

			$(".record_container--manage-discussion_item_comment-record--discussion_item_comments--discussion_item_id--" + discussion_item_id).show();
			$(".record_container--manage-discussion_item_comment-record-read_only--discussion_item_comments--discussion_item_id--" + discussion_item_id).hide();

		} else {
			// They are done editing

			// Let's trigger the change on the last element to fire any onchange event if they didn't tab out causing a onchange event
//			$("#" + document.activeElement.id).change();

			$("#edit_BtnContainer_" + discussion_item_id + ' .editElement').hide();
			$("#item_" + discussion_item_id + ' .editElement').hide();
			$("#item_" + discussion_item_id + ' .showElement').show();
			$("#btnEditDiscussion_" + discussion_item_id).html('Edit');
			//$("#btnEditDiscussion_" + discussion_item_id).val('Edit');
			var oneStillInEditMode = false;
			$(".discussion-item-edit-button").each(function() {
				if ($(this).html() == 'Done') {
				//if ($(this).val() == 'Done') {
					oneStillInEditMode = true;
				}
			});
			if (oneStillInEditMode == false) {
				$("#btnGlobalEdit").text('Edit Discussion Items');
			}

			// If status is closed and show all is not checked then we should remove the discussion item
			if ($("#edit_status_" + discussion_item_id + ' option:selected').val() == 0 && !$("#chkShowAll").is(':checked')) {
				$("#edit_BtnContainer_" + discussion_item_id).remove();
				$("#item_" + discussion_item_id).remove();
			}
			hideEditActionItems(discussion_item_id);

			$(".record_container--manage-discussion_item_comment-record--discussion_item_comments--discussion_item_id--" + discussion_item_id).hide();
			$(".record_container--manage-discussion_item_comment-record-read_only--discussion_item_comments--discussion_item_id--" + discussion_item_id).show();
		}
	}
	//trimAutoGrows();
	if(jQuery().elastic) {
		$(".autogrow").elastic();
	}
}

function showEditActionItems(discussion_item_id)
{
	if (discussion_item_id) {
		var tableActionItems = $("#record_list_container--action_items--discussion_item_id--" + discussion_item_id);
		tableActionItems.find('.trUneditable').addClass('hidden');
		tableActionItems.find('.trEditable').removeClass('hidden');
		$("#input-check-record_list_container--action_items--discussion_item_id--"+discussion_item_id).val(1);
	} else {
		$("#input-check-record_list_container--action_items--discussion_item_id--"+discussion_item_id).val(0);
		$(".trUneditable").addClass('hidden');
		$(".trEditable").removeClass('hidden');
	}

}

function hideEditActionItems(discussion_item_id)
{
	if (discussion_item_id) {
		var tableActionItems = $("#record_list_container--action_items--discussion_item_id--" + discussion_item_id);
		tableActionItems.find('.trUneditable').removeClass('hidden');
		tableActionItems.find('.trEditable').addClass('hidden');
		$("#input-check-record_list_container--action_items--discussion_item_id--"+discussion_item_id).val(0);
	} else {
		$(".trUneditable").removeClass('hidden');
		$(".trEditable").addClass('hidden');
	}
}

function cancelDiscussionItemChanges(discussion_item_id)
{
	$("#discussionList .editElement").hide();
	$("#discussionList .showElement").show();
	//$("#editItem_" + discussion_item_id).hide();
	//$("#editBtnContainer_" + discussion_item_id).show();
	//$("#item_" + discussion_item_id).show();
}

function addAssigneeToAction(action_item_id)
{
	try {

		action_item_id = $.trim(action_item_id);
		var contact_id = $("#selActionAssignees_" + action_item_id).val();
		if (contact_id != 0) {
			var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=addActionAssignee';
			var ajaxQueryString =
				'action_item_id=' + encodeURIComponent(action_item_id) +
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
				success: changeActionAssigneesSuccess,
				error: errorHandler
			});

			// Add element to DOM.
			var ul = $("#ulActionAssignees_" + action_item_id);
			var html = ul.html();
			if (html.indexOf('Not Assigned') != -1) {
				ul.html('');
			}
			var contactName = $("#selActionAssignees_" + action_item_id + ' option:selected').html();
			if (html.indexOf(contactName) == -1) {
				html = '<a href="#" onclick="removeAssigneeFromAction(this, \''+action_item_id+'\', \''+contact_id+'\'); return false;" class="smallerFont editElement" style="display:inline;">X</a> ' + contactName;
				ul.append('<li>' + html + '</li>');
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

function removeAssigneeFromAction(element, action_item_id, contact_id)
{
	try {
		action_item_id = $.trim(action_item_id);
		contact_id = $.trim(contact_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=removeActionAssignee';
		var ajaxQueryString =
			'action_item_id=' + encodeURIComponent(action_item_id) +
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
			success: changeActionAssigneesSuccess,
			error: errorHandler
		});

		// Remove element from DOM.
		var anchor = $(element);
		var li = anchor.parent();
		var ul = li.parent();
		li.remove();
		if (ul.children().length == 0) {
			ul.html('<li>Not Assigned</li>');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function changeActionAssigneesSuccess(result, textStatus, jqXHR)
{
	try {

		var ary = result.split('|');
		if (ary[0] == 1) {
			var messageText = 'Action Assignees Successfully Updated';
			messageAlert(messageText, 'successMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function actionAssigneesReloaded(result, textStatus, jqXHR)
{
	// If we are in edit mode then we want to make sure the refresh list is also in edit mode
	//var ary = $(this).parents().find(".accordionActions").first().attr("id").split("_");
	//var discussion_item_id = ary[1];
	//if ($("#btnEditDiscussion_" + discussion_item_id).text() != "Edit") {
		//showEditDiscussion(discussion_item_id);
	//}
	$(this).find('.editElement').show();
}

function updateDiscussionItem1(elementId, discussion_item_id)
{
	try {
		elementId = $.trim(elementId);
		discussion_item_id = $.trim(discussion_item_id);
		var newValue = $("#edit_" + elementId + '_' + discussion_item_id).val();
		newValue = $.trim(newValue);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=updateDiscussionItem';
		var ajaxQueryString =
			'elementId=' + encodeURIComponent(elementId) +
			'&discussion_item_id=' + encodeURIComponent(discussion_item_id) +
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
			success: updateDiscussionItemSuccess1,
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

function updateDiscussionItemSuccess1(result, textStatus, jqXHR)
{
	try {

		//alert(result);
		/*
		var ary = result.split('|');
		var editElement = $('#edit_' + ary[0] + '_' + ary[1]);
		var showElement = $('#show_' + ary[0] + '_' + ary[1]);
		*/
		var meeting_type_id = result;
		var ary = result.split('_');
		var meeting_type_name = ary[0];
		var editElement = $("#edit_" + meeting_type_id);
		var showElement = $("#show_" + meeting_type_id);
		if (ary[0] == 'status') {
			var newStatus = 'Open';
			if ($(editElement).val() == 0) {
				newStatus = 'Closed';
			}
			$(showElement).html(newStatus);
		} else {
			$(showElement).html($(editElement).val());
		}
		var messageText = 'Discussion ' + meeting_type_name + ' was successfully updated';
		//messageAlert(messageText,'successMessage','successMessageLabel', $(editElement).prop('id') );
		messageAlert(messageText, 'successMessage');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function openMeetingPdfInNewTab()
{
	var meeting_id = $("#ddl_meeting_id").val();
	var meeting_type = $("#ddl_meeting_type_id option:selected").text();
	var showAll = $("#chkShowAll").is(':checked')?1:0;

	$("#meeting_id").val(meeting_id);
	$("#sAll").val(showAll);
	$("#theAction").val('print');

	document.formExport.submit();
}

function loadEmailMeetingPdfDialog()
{
	try {

		var meeting_type = $("#ddl_meeting_type_id option:selected").text();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadEmailWindow';
		var ajaxQueryString =
			'meeting_type=' + encodeURIComponent(meeting_type);
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
			success: loadEmailMeetingPdfDialogSuccess,
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

/*Render PDF*/
function loadRenderPDF()
{
	try {

		var meeting_id = $("#ddl_meeting_id").val();
		var meeting_type = $("#ddl_meeting_type_id option:selected").text();
		var showAll = $("#chkShowAll").is(':checked')?1:0;

		/*$("#meeting_id").val(meeting_id);
		$("#sAll").val(showAll);
		$("#theAction").val('print');*/

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadRenderPDF';
		var ajaxQueryString =
			'meeting_type=' + encodeURIComponent(meeting_type) +
			'&theAction=renderPDF'+
			'&meeting_id= '+encodeURIComponent(meeting_id)
			;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}
		// $("#divAjaxLoading").html('Loading . . .');
		showSpinner();
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: renderPdfDialogSuccess,
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

function renderPdfDialogSuccess(result, textStatus, jqXHR)
{
	try {
		hideSpinner();
		if (result == 0) {
			var messageText = 'Render pdf successfully';
			messageAlert(messageText, 'successMessage');
			loadDiscussionItemsByMeetingId('');
		} else {
			var messageText = result;
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

function loadEmailMeetingPdfDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.80;
		var dialogHeight = windowHeight * 0.80;

		$("#dialog").removeClass('hidden');
		$("#dialog").html(data);
		setAccordionEmail = true;
		var meeting_type = $("#ddl_meeting_type_id option:selected").text();
		var meetingNumberName = $("#ddl_meeting_id option:selected").text();
		$("#dialog").dialog({
			modal: true,
			width: dialogWidth,
			height: dialogHeight,
			title: 'Email ' + meeting_type + ' - ' + meetingNumberName + ' Report' ,
			open: function(event, ui) {
				$("body").addClass('noscroll');
			},
			close: function(event, ui) {
				$("body").removeClass('noscroll');
				$("#dialog").addClass('hidden');
				$("#dialog").html('');
			},
			buttons: {
				'Send Email To Selected Recipients': function() {
					btnSendEmailClicked();
				},
				'Cancel': function() {
					$("#dialog").dialog('close');
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

//function searchContactSelected_emailMeetingReport(element, id, company, name, email)
function searchContactSelected_emailMeetingReport(element, contact_id, company, contactFirstName, contactLastName, email, is_archive)
{
	var fullName = contactFirstName + ' ' + contactLastName;
	var decodedFirstName = decodeURIComponent(contactFirstName);
	var decodedLastName = decodeURIComponent(contactLastName);
	var decodedFullName = decodeURIComponent(fullName);
	var decodedEmailAdress = decodeURIComponent(email);
	var decodedCompany = decodeURIComponent(company);
	addItemToSelectedList(contact_id, decodedFirstName, decodedLastName, decodedEmailAdress, decodedCompany, is_archive);
}

function addItemToSelectedList(contact_id, firstName, lastName, email, company, is_archive)
{
	company = $.trim(company);
	email = $.trim(email);
	firstName = $.trim(firstName);
	lastName = $.trim(lastName);

	// @todo Add logic to test for
	if ((firstName != '') && (lastName != '')) {
		var name = firstName + ' ' + lastName;
	} else if (firstName != '') {
		var name = firstName;
	} else if (lastName != '') {
		var name = lastName;
	} else {
		var name = '';
	}

	if (company != '') {
		var displayedName = name + ' &mdash; ' + company;
	} else {
		var displayedName = name;
	}

	$("#btnSendEmail").show();

	var csvContactIds = $("#csvContactIds").val();
	csvContactIds = $.trim(csvContactIds);
	if (csvContactIds.length == 0) {
		var arrContactIds = [];
	} else {
		var arrContactIds = csvContactIds.split(',');
	}

	var csvNoContactIds = $("#csvNoContactIds").val();
	csvNoContactIds = $.trim(csvNoContactIds);
	if (csvNoContactIds.length == 0) {
		var arrNoContactIds = [];
	} else {
		var arrNoContactIds = csvNoContactIds.split(',');
	}

	if ($.inArray(contact_id, arrContactIds) == -1 && is_archive == 'N') {
		arrContactIds.push(contact_id);
		var hasEmail = '';
		var emailTip = email;
		if ($.trim(email).length < 2) {
			hasEmail = ' style="color:red;"';
			emailTip = 'No Email On Record';
		}
		$("#tblSelectedItems tr:last").after(
				'<tr id="selItem_'+contact_id+'" name="selItem_'+contact_id+'" title="'+emailTip+'">'+
					'<td nowrap><a href="javascript:removeItemFromSelectedList(\''+contact_id+'\',\''+is_archive+'\');">X</a></td>'+
					'<td nowrap'+hasEmail+'>'+displayedName+'</td>'+
					'<td nowrap>('+email+')</td>'+
				'</tr>');

	}
	if ($.inArray(contact_id, arrNoContactIds) == -1 && is_archive == 'Y') {
		arrNoContactIds.push(contact_id);
		var hasEmail = '';
		var emailTip = email;
		if ($.trim(email).length < 2) {
			hasEmail = ' style="color:red;"';
			emailTip = 'No Email On Record';
		}
		$("#tblSelectedItems tr:last").after(
				'<tr id="selItem_'+contact_id+'" name="selItem_'+contact_id+'" title="'+emailTip+'">'+
					'<td nowrap><a href="javascript:removeArchivedItemFromSelectedList(\''+contact_id+'\',\''+is_archive+'\');">X</a></td>'+
					'<td nowrap'+hasEmail+'>'+displayedName+'</td>'+
					'<td nowrap>('+email+')</td>'+
				'</tr>');
	}
	csvContactIds = arrContactIds.join(',');
	$("#csvContactIds").val(csvContactIds);
	csvNoContactIds = arrNoContactIds.join(',');
	$("#csvNoContactIds").val(csvNoContactIds);
}

function removeItemFromSelectedList(contact_id,is_archive)
{
	var csvContactIds = $("#csvContactIds").val();
	csvContactIds = $.trim(csvContactIds);
	if (csvContactIds.length == 0) {
		var arrContactIds = [];
	} else {
		var arrContactIds = csvContactIds.split(',');
	}

	if ($.inArray(contact_id, arrContactIds) > -1) {
		arrContactIds.splice($.inArray(contact_id, arrContactIds), 1);
		$("#selItem_" + contact_id).remove();
	}
	if (arrContactIds.length < 1) {
		$("#btnSendEmail").hide();
	}
	csvContactIds = arrContactIds.join(',');
	$("#csvContactIds").val(csvContactIds);
}

function removeArchivedItemFromSelectedList(contact_id,is_archive)
{
	var csvNoContactIds = $("#csvNoContactIds").val();
	csvNoContactIds = $.trim(csvNoContactIds);
	if (csvNoContactIds.length == 0) {
		var arrNoContactIds = [];
	} else {
		var arrNoContactIds = csvNoContactIds.split(',');
	}

	if ($.inArray(contact_id, arrNoContactIds) > -1) {
		arrNoContactIds.splice($.inArray(contact_id, arrNoContactIds), 1);
		$("#selItem_" + contact_id).remove();
	}
	if (arrNoContactIds.length < 1) {
		$("#btnSendEmail").hide();
	}
	csvNoContactIds = arrNoContactIds.join(',');
	$("#csvNoContactIds").val(csvNoContactIds);
}

function addMeetingAttendeesToSelectedList()
{
	try {

		var meeting_id = $("#ddl_meeting_id").val();
		meeting_id = $.trim(meeting_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=addMeetingAttendeesToList';
		var ajaxQueryString =
			'meeting_id=' + encodeURIComponent(meeting_id);
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
			success: loadContactsToAddAsEmailRecipientsSuccess,
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

function addProjectContactsToSelectedList()
{
	try {

		var meeting_type_id = $("#ddl_meeting_type_id").val();
		meeting_type_id = $.trim(meeting_type_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=addProjectContactsToList';
		var ajaxQueryString =
			'meeting_type_id=' + encodeURIComponent(meeting_type_id);
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
			success: loadContactsToAddAsEmailRecipientsSuccess,
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

function addContactsWithRoleToSelectedList(role_id)
{
	try {

		role_id = $.trim(role_id);
		var meeting_type_id = $("#ddl_meeting_type_id").val();
		meeting_type_id = $.trim(meeting_type_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=addContactsWithRoleToSelectedList';
		var ajaxQueryString =
			'meeting_type_id=' + encodeURIComponent(meeting_type_id) +
			'&role_id=' + encodeURIComponent(role_id);
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
			success: loadContactsToAddAsEmailRecipientsSuccess,
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

function loadContactsToAddAsEmailRecipientsSuccess(data, textStatus, jqXHR)
{
	try {

		// data is JSON
		var arrContacts = data;
		for (var i = 0; i < arrContacts.length; i++) {
			var contact = arrContacts[i];

			var contact_id = contact.contact_id.toString();
			var company_name = contact.company_name.toString();
			var fullName = contact.fullName;
			var first_name = contact.first_name;
			var last_name = contact.last_name;
			var email = contact.email;
			var is_archive = contact.is_archive;

			addItemToSelectedList(contact_id, first_name, last_name, email, company_name, is_archive);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function btnSendEmailClicked()
{
	try {

		var csvContactIds = $("#csvContactIds").val();
		csvContactIds = $.trim(csvContactIds);

		var meeting_id = $("#ddl_meeting_id").val();
		var meeting_type = $("#ddl_meeting_type_id option:selected").text();
		var showAll = $("#chkShowAll").is(':checked') ? 1 : 0;

		$("#meeting_id").val(meeting_id);
		$("#sAll").val(showAll);
		$("#theAction").val('email');

		if (csvContactIds.length == 0) {
			var messageText = 'You have not selected any recipients';
			messageAlert(messageText, 'warningMessage');
			return;
		}

		var arrContactIds = csvContactIds.split(',');
		var numOfEmails = arrContactIds.length - 1;
		if (numOfEmails > 1) {
			$("#divAjaxLoading").html('Sending (' + numOfEmails + ') Emails. Please wait . . .');
		} else {
			$("#divAjaxLoading").html('Sending (' + numOfEmails + ') Email. Please wait . . .');
		}

		var adHocEmailMessageText = $("#adHocEmailMessageText").val();
		adHocEmailMessageText = $.trim(adHocEmailMessageText);

		var ajaxHandler =
			'/modules-collaboration-manager-report.php?recipients=' + encodeURIComponent(csvContactIds) +
			'&adHocEmailMessageText=' + encodeURIComponent(adHocEmailMessageText);
		var ajaxQueryString = $("#formExport").serialize();
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
			success: processEmailSuccess,
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

function processEmailSuccess(result, textStatus, jqXHR)
{
	try {

		var ary = result.split('|');
		messageAlert(ary[1],ary[0]);
		$("#dialog").dialog('close');
		$("#divAjaxLoading").html('Loading . . .');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showImportDiscussionOptions(meeting_id, previous_meeting_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadImportDiscussionOptionsWindow';
		var ajaxQueryString =
			'meeting_id=' + encodeURIComponent(meeting_id) +
			'&previous_meeting_id=' + encodeURIComponent(previous_meeting_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#dialog").load(ajaxUrl, openImportWindow);
		//$("#dialog").load('/modules-collaboration-manager-ajax.php?method=loadImportDiscussionOptionsWindow',openImportWindow);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function openImportWindow()
{
	try {

		$("#dialog").removeClass('hidden');
		$("#dialog").dialog({
			modal: true,
			width: 500,
			height: 300,
			title: 'Import Items — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
			open: function(event, ui) {
				$("body").addClass('noscroll');
			},
			close: function(event, ui) {
				$("body").removeClass('noscroll');
				$("#dialog").addClass('hidden');
				$("#dialog").dialog('destroy');
				$("#dialog").html('');
			},
			buttons: {
				'Import Discussion Items': function() {
					btnImportItemsClicked();
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

/*
function btnCancelImportItemsClicked()
{
	$("#dialog").dialog("close");
}
*/

function btnImportItemsClicked()
{
	try {

		var meeting_id = $("#ddl_meeting_id").val();
		meeting_id = $.trim(meeting_id);

		var prevMtgIndex = $("#ddl_meeting_id").prop('selectedIndex') + 1;
		var previous_meeting_id = $("#ddl_meeting_id option:eq("+prevMtgIndex+")").val();
		previous_meeting_id = $.trim(previous_meeting_id);

		var selOption = $("#frmImportItems input[type=radio]:checked");
		var importType = selOption.prop('id');

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=importDiscussionItems';
		var ajaxQueryString =
			'meeting_id=' + encodeURIComponent(meeting_id) +
			'&previous_meeting_id=' + encodeURIComponent(previous_meeting_id) +
			'&importType=' + encodeURIComponent(importType);
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
			success: importDiscussionItemsSuccess,
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

function importDiscussionItemsSuccess(result, textStatus, jqXHR)
{
	try {

		if (result.length < 2) {
			var messageText = 'Discussion item(s) successfully imported';
			messageAlert(messageText, 'successMessage');
			loadDiscussionItemsByMeetingId('');
		} else {
			var messageText = result;
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

function editMeetingInfo()
{
	$("#divMeetingDetails .editElement").toggle();
	$("#divMeetingDetails .showElement").toggle();
	if ($("#btnEditMeetingInformation").html() == 'Edit Meeting Information') {
		$("#btnEditMeetingInformation").html('Done Editing Information');
		$(".containerEditCls").attr('class','containerEditCls containerEdit');
	} else {
		$("#btnEditMeetingInformation").html('Edit Meeting Information');
		$(".containerEditCls").attr('class','containerEditCls');
	}
	$(".toggleDisabledElement").each(function(i) {
		var disabled = $(this).attr('disabled');
		$(this).attr('disabled', !disabled);
	});
}

function permissionModalClosed()
{
	loadMeetingDetails();
	loadDiscussionItemsByMeetingId('');
}

function loadManageMeetingLocationsDialogHelper()
{
	var options = {
		callback: loadManageMeetingLocationsDialogHelperSuccess,
		reopenCreateMeetingDialog: '1'
	};
	loadManageMeetingLocationsDialog(options);
}

function loadManageMeetingLocationsDialogHelperSuccess(data, textStatus, jqXHR)
{
	$("#divCreateMeetingDialog").parent().hide();
	$("#divCreateMeetingDialog").parent().prev().hide();
}

function loadManageMeetingLocationsDialog(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadManageMeetingLocationsDialog';
		var ajaxQueryString = '';

		var arrSuccessCallbacks = [ loadManageMeetingLocationsDialogSuccess ];
		var successCallback = options.successCallback;
		if (successCallback) {
			arrCallbacks.unshift(callback);
		}
		var reopenCreateMeetingDialog = options.reopenCreateMeetingDialog;
		if (reopenCreateMeetingDialog) {
			ajaxQueryString += '&reopenCreateMeetingDialog=' + encodeURIComponent(reopenCreateMeetingDialog);
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
			success: arrSuccessCallbacks,
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

function loadManageMeetingLocationsDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divMeetingLocationsDialog").removeClass('hidden');
		$("#divMeetingLocationsDialog").html(data);
		$("#divMeetingLocationsDialog").dialog({
			modal: true,
			title: 'Manage Meeting Locations — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
			width: 600,
			height: $(window).height() * 0.99,
			open: function(event, ui) {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divMeetingLocationsDialog").addClass('hidden');
				$("#divMeetingLocationsDialog").dialog('destroy');
				var reopenCreateMeetingDialog = $("#reopenCreateMeetingDialog").val();
				if (reopenCreateMeetingDialog) {
					$("#divCreateMeetingDialog").parent().show();
					$("#divCreateMeetingDialog").parent().prev().show();
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

function loadManageMeetingTypesDialog()
{
	try {
		var project_id = $("#currentlySelectedProjectId").val();
		var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-ajax.php?method=loadManageMeetingTypesDialog';
		var ajaxQueryString = 'project_id=' + encodeURIComponent(project_id);
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
			success: loadManageMeetingTypesDialogSuccess,
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

function loadManageMeetingTypesDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();
		var modalDialogWidth = 700;
		var modalDialogHeight = windowHeight * 0.98;

		$("#divMeetingTypesDialog").html(data);
		$("#divMeetingTypesDialog").removeClass('hidden');
		$("#divMeetingTypesDialog").dialog({
			modal: true,
			title: 'Manage Meeting Types — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
			width: modalDialogWidth,
			height: modalDialogHeight,
			open: function(event, ui) {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divMeetingTypesDialog").addClass('hidden');
				$("#divMeetingTypesDialog").html('');
				$("#divMeetingTypesDialog").dialog('destroy');
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

function updateMeetingHelper(element, uniqueId, nextUniqueId)
{

	var options = { promiseChain: true, responseDataType: 'json', successCallback: updateMeetingHelperSuccess };

	// Meeting start date (meeting_start_date)
	var meeting_start_date_element_id = 'manage-meeting-record--meetings--meeting_start_date--' + uniqueId;
	if ($("#" + meeting_start_date_element_id).length) {
		var meeting_start_date = $("#" + meeting_start_date_element_id).val();
		meeting_start_date = convertDateToMySQLFormat(meeting_start_date);			
	}

	// Meeting start time (meeting_start_time)
	var meeting_start_time_element_id = 'manage-meeting-record--meetings--meeting_start_time--' + uniqueId;
	if ($("#" + meeting_start_time_element_id).length) {
		var meeting_start_time = $("#" + meeting_start_time_element_id).val();
		meeting_start_time = convertTimeToMySQLFormat(meeting_start_time);
	}

	// Meeting end date (meeting_end_date)
	var meeting_end_date_element_id = 'manage-meeting-record--meetings--meeting_end_date--' + uniqueId;
	if ($("#" + meeting_end_date_element_id).length) {
		var meeting_end_date = $("#" + meeting_end_date_element_id).val();
		meeting_end_date = convertDateToMySQLFormat(meeting_end_date);
	}

	// Meeting end time (meeting_end_time)
	var meeting_end_time_element_id = 'manage-meeting-record--meetings--meeting_end_time--' + uniqueId;
	if ($("#" + meeting_end_time_element_id).length) {
		var meeting_end_time = $("#" + meeting_end_time_element_id).val();
		meeting_end_time = convertTimeToMySQLFormat(meeting_end_time);
	}

	// Next meeting start date (next_meeting_start_date)
	var next_meeting_start_date_element_id = 'manage-next_meeting-record--meetings--meeting_start_date--' + nextUniqueId;
	if ($("#" + next_meeting_start_date_element_id).length) {
		var next_meeting_start_date = $("#" + next_meeting_start_date_element_id).val();
		next_meeting_start_date = convertDateToMySQLFormat(next_meeting_start_date);
	}

	// Next meeting start time (next_meeting_start_time)
	var next_meeting_start_time_element_id = 'manage-next_meeting-record--meetings--meeting_start_time--' + nextUniqueId;
	if ($("#" + next_meeting_start_time_element_id).length) {
		var next_meeting_start_time = $("#" + next_meeting_start_time_element_id).val();
		next_meeting_start_time = convertTimeToMySQLFormat(next_meeting_start_time);
	}

	// Next meeting end date (next_meeting_end_date)
	var next_meeting_end_date_element_id = 'manage-next_meeting-record--meetings--meeting_end_date--' + nextUniqueId;
	if ($("#" + next_meeting_end_date_element_id).length) {
		var next_meeting_end_date = $("#" + next_meeting_end_date_element_id).val();
		next_meeting_end_date = convertDateToMySQLFormat(next_meeting_end_date);		
	}

	// Next meeting end time (next_meeting_end_time)
	var next_meeting_end_time_element_id = 'manage-next_meeting-record--meetings--meeting_end_time--' + nextUniqueId;
	if ($("#" + next_meeting_end_time_element_id).length) {
		var next_meeting_end_time = $("#" + next_meeting_end_time_element_id).val();
		next_meeting_end_time = convertTimeToMySQLFormat(next_meeting_end_time);
	}

	var check = checkTimeForMeeting(meeting_start_date,meeting_start_time,meeting_end_date,meeting_end_time,next_meeting_start_date,next_meeting_start_time,next_meeting_end_date,next_meeting_end_time);

	if (check == 0) {
		updateMeeting(element, options);
	}else{
		var id = element.id;
		var hasDate = element.placeholder;
		var value = $('#'+id).prev( "span" ).html();
		if (hasDate == 'MM/DD/YYYY') {			
			value = convertStringToDate(value);			
		}			
		$('#'+id).val(value);
	}
}

function updateMeetingHelperSuccess(data, textStatus, jqXHR)
{
	try {
		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var attributeGroupName = json.attributeGroupName;
			var attributeSubgroupName = json.attributeSubgroupName;
			var attributeName = json.attributeName;
			var uniqueId = json.uniqueId;
			var htmlContent = json.htmlContent;

			var elementId = attributeGroupName + '--' + attributeSubgroupName + '--' + attributeName + '--' + uniqueId;
			var readOnlyElementId = attributeGroupName + '-read_only--' + attributeSubgroupName + '--' + attributeName + '--' + uniqueId;
			$("#" + readOnlyElementId).html(htmlContent);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateNextMeetingLocation(element, next_meeting_location_element_id)
{
	try {

		var newValue = $(element).val();
		var next_meeting_location_element = $("#" + next_meeting_location_element_id);
		next_meeting_location_element.val(newValue);
		updateMeetingHelper(next_meeting_location_element);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showCreateActionItemDialog(discussion_item_id)
{
	$(".trCreateActionItem--" + discussion_item_id).removeClass('hidden');
	$(".textareaCreateActionItem--" + discussion_item_id).focus();
}

function cancelCreateActionItem(discussion_item_id)
{
	$(".trCreateActionItem--" + discussion_item_id).addClass('hidden');
	$(".textareaCreateActionItem--"+discussion_item_id).removeClass('redBorderThick');
}

function createActionItemAssignmentHelper(attributeGroupName, uniqueId, element)
{
	try {

		var ul = $("#record_list_container--action_item_assignments--" + uniqueId);
		var selectedOption = $("#" + element.id + " option:selected");
		var selectedOptionHtml = selectedOption.html();
		var selectedOptionValue = selectedOption.val();
		if (selectedOptionValue == '0') {
			return;
		}

		var liId = uniqueId + '-' + selectedOptionValue;
		var existingLi = $("#" + liId);
		if (existingLi.length) {
			return;
		}

		var input = '<input type="hidden" id="create-action_item_assignment-record--action_item_assignments--action_item_assignee_contact_id--'+uniqueId+'" class="action_item_assignee_contact_id" value="'+selectedOptionValue+'">';
		var a = '<a href="javascript:deleteActionItemAssignmentHelper(\'' + liId + '\');">X</a> ';
		var li = '<li id="' + liId + '">' + input + a + selectedOptionHtml + '</li>';
		ul.append(li);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteActionItemAssignmentHelper(elementId)
{
	$("#" + elementId).remove();
}

function Collaboration_Manager__Meetings__createDiscussionItem(attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__Meetings__createDiscussionItemSuccess;

		// Set meeting_id value in hidden from element
		var meeting_id = $("#ddl_meeting_id").val();
		$('#btnNewDiscussionItemSave').attr('disabled', 'disabled');
		var meeting_id_element_id = attributeGroupName + '--discussion_items--meeting_id--' + uniqueId;
		$("#" + meeting_id_element_id).val(meeting_id);

		createDiscussionItem(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__createDiscussionItemSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;
		$('#btnNewDiscussionItemSave').removeAttr('disabled');
		if (errorNumber == 0) {
			cancelNewDiscussionItem();
			loadDiscussionItemsByMeetingId();
			$("#formNewDiscussionItem")[0].reset();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__updateDiscussionItem(element, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__Meetings__updateDiscussionItemSuccess;

		updateDiscussionItem(element, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__updateDiscussionItemSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var attributeGroupName = json.attributeGroupName;
			var attributeSubgroupName = json.attributeSubgroupName;
			var attributeName = json.attributeName;
			var uniqueId = json.uniqueId;
			var htmlRecord = json.htmlRecord;

			// manage-discussion_item-record-read_only--discussion_items--discussion_item_title--68
			var elementId = attributeGroupName + '--' + attributeSubgroupName + '--' + attributeName + '--' + uniqueId;
			var readOnlyElementId = attributeGroupName + '-read_only--' + attributeSubgroupName + '--' + attributeName + '--' + uniqueId;
			//readOnlyElementId = readOnlyElementId.replace('_id', '');
			$("#" + readOnlyElementId).html(htmlRecord);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__deleteDiscussionItem(element, javaScriptEvent, discussion_item_id)
{
	try {

		trapJavaScriptEvent(javaScriptEvent);

		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		//options.confirmation = true;
		options.successCallback = Collaboration_Manager__Meetings__deleteDiscussionItemSuccess;

		var discussion_item_title = $("#manage-discussion_item-record--discussion_items--discussion_item_title--" + discussion_item_id).val();
		var discussion_item = $("#manage-discussion_item-record--discussion_items--discussion_item--" + discussion_item_id).html();

		var confirmationDialogMessage = '' +
		'<br>Are you sure that you want to delete the following discussion item?' +
		'<br><br>[' + discussion_item_title + ']' +
		'<br>&ldquo;' + discussion_item + '&rdquo;<br><br>' +
		"This will permanently delete the discussion item, its action items, and comments from this meeting. If you would prefer to not see the discussion item then you may also change the status to &ldquo;Closed&rdquo;.";
		options.confirmationDialogMessage = confirmationDialogMessage;
		options.confirmationDialogTitle = 'Delete Discussion Item?';
		options.confirmButtonText = 'Delete';
		options.cancelButtonText = 'Cancel';
		options.confirmationDialogWidth = 600;
		options.confirmationDialogHeight = 400;

		var confirmationDialogPromise = confirmationDialog(options);

		confirmationDialogPromise.done(function() {
			// They pressed Delete
			var recordContainerElementId = 'record_container--manage-discussion_item-record--discussion_items--sort_order--discussion_item_id--' + discussion_item_id;
			var attributeGroupName = 'manage-discussion_item-record';
			var uniqueId = discussion_item_id;

			deleteDiscussionItem(recordContainerElementId, attributeGroupName, uniqueId, options);
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

function Collaboration_Manager__Meetings__deleteDiscussionItemSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			var discussion_item_id = uniqueId;

			$("#record_container--manage-discussion_item-record--discussion_items--sort_order--" + discussion_item_id).remove();

			//loadDiscussionItemsByMeetingId();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__createDiscussionItemComment(attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.interfaceName = 'Collaboration_Manager__Meetings__createDiscussionItemComment';
		options.includeHtmlContent = 'Y';
		options.successCallback = Collaboration_Manager__Meetings__createDiscussionItemCommentSuccess;

		createDiscussionItemComment(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__createDiscussionItemCommentSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var attributeGroupName = json.attributeGroupName;
			var attributeSubgroupName = json.attributeSubgroupName;
			var uniqueId = json.uniqueId;
			var previousAttributeGroupName = json.previousAttributeGroupName;
			var dummyId = json.dummyId;
			var htmlRecord = json.htmlRecord;
			var discussion_item_id = json.discussion_item_id;

			// id="create-discussion_item_comment-record--discussion_item_comments--discussion_item_comment--dummy_id_14383104244511"
			var discussionItemCommentAttributeContainerElementIdOld = previousAttributeGroupName + '--' + attributeSubgroupName + '--discussion_item_comment--' + dummyId;
			$("#" + discussionItemCommentAttributeContainerElementIdOld).val('');
			$('.headerComments').removeClass('hidden');
			$("#record_list_container--manage-discussion_item_comment-record--discussion_item_comments--discussion_item_id--" + discussion_item_id).append(htmlRecord);
			$(".bs-tooltip").tooltip();

			// Change comments accordion header. E.g. "Comments (0)" to "Comments (1)".
			var numCommentsElementId = 'numComments--' + discussion_item_id;
			var numCommentsString = $("#" + numCommentsElementId).html();
			var numComments = parseInt(numCommentsString, 10);
			numComments++;
			$("#numComments--" + discussion_item_id).html(numComments);
			// var discussion_item_id = $("#"+attributeGroupName+"--discussion_item_comments--discussion_item_id--"+uniqueId).val();
			$('#save_comment_'+discussion_item_id).removeAttr('disabled');
			// Expand comments accordion if not already.
			var accordionElement = $("#numComments--" + discussion_item_id).closest('.headerComments');
			if (!$(accordionElement).hasClass('ui-state-active')) {
				$(accordionElement).parent().accordion('option', 'active', 0);
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

function Collaboration_Manager__Meetings__updateDiscussionItemComment(element, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__Meetings__updateDiscussionItemCommentSuccess;

		updateDiscussionItemComment(element, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__updateDiscussionItemCommentSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var attributeGroupName = json.attributeGroupName;
			var attributeSubgroupName = json.attributeSubgroupName;
			var attributeName = json.attributeName;
			var uniqueId = json.uniqueId;
			var previousId = json.previousId;
			var htmlRecord = json.htmlRecord;

			if (uniqueId != previousId) {
				var readOnlyElementId = attributeGroupName + '-read_only--' + attributeSubgroupName + '--' + attributeName + '--' + previousId;
				var updatedReadOnlyElementId = attributeGroupName + '-read_only--' + attributeSubgroupName + '--' + attributeName + '--' + uniqueId;
				$("#" + readOnlyElementId).html(htmlRecord);
				$("#" + readOnlyElementId).id(updatedReadOnlyElementId);

				// @todo update id of other elements in the record_container

			} else {
				// manage-discussion_item_comment-record--discussion_item_comments--discussion_item_comment--98
				var elementId = attributeGroupName + '--' + attributeSubgroupName + '--' + attributeName + '--' + uniqueId;
				var updatedValue = $("#" + elementId).val();

				// manage-discussion_item_comment-record-read_only--discussion_item_comments--discussion_item_comment--98
				var readOnlyElementId = attributeGroupName + '-read_only--' + attributeSubgroupName + '--' + attributeName + '--' + uniqueId;
				if ($("#" + readOnlyElementId).length) {
					//$("#" + readOnlyElementId).html(htmlRecord);
					$("#" + readOnlyElementId).html(updatedValue);
				}
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

//function Collaboration_Manager__Meetings__deleteDiscussionItemComment(element, javaScriptEvent, discussion_item_comment_id)
function Collaboration_Manager__Meetings__deleteDiscussionItemComment(discussion_item_id, discussion_item_comment_id)
{
	try {

		var options = options || {};

		//trapJavaScriptEvent(javaScriptEvent);

		options.promiseChain = true;
		options.responseDataType = 'json';
		//options.confirmation = true;
		options.successCallback = Collaboration_Manager__Meetings__deleteDiscussionItemCommentSuccess;

		options.confirmationDialogMessage = 'Are You Sure That You Want To Delete This Discussion Item Comment?';
		options.confirmationDialogTitle = 'Confirm Delete';
		options.confirmButtonText = 'Delete';
		options.cancelButtonText = 'Cancel';
		options.confirmationDialogWidth = 400;
		options.confirmationDialogHeight = 200;

		var confirmationDialogPromise = confirmationDialog(options);
		//var confirmationDialogPromise = confirmationDialog({ confirmationDialogMessage : confirmationDialogMessageValue, confirmationDialogTitle : confirmationDialogTitleValue, confirmButtonText : confirmButtonTextValue, cancelButtonText : cancelButtonTextValue }).done(function() {

		confirmationDialogPromise.done(function() {
			// They pressed Delete
			var recordContainerElementId = 'record_container--manage-discussion_item_comment-record--discussion_item_comments--' + discussion_item_comment_id;
			var attributeGroupName = 'manage-discussion_item_comment-record';
			var uniqueId = discussion_item_comment_id;

			// Testing: defaultAjaxCallback_deleteSuccess(data, textStatus, jqXHR)
			// Testing deletion of the read_only record version by its detection within the recordListContainerElementId
			options.recordListContainerElementId = 'record_list_container--manage-discussion_item_comment-record--discussion_item_comments--discussion_item_id--' + discussion_item_id;

			deleteDiscussionItemComment(recordContainerElementId, attributeGroupName, uniqueId, options);
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

function Collaboration_Manager__Meetings__deleteDiscussionItemCommentSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__createMeetingLocation(attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__Meetings__createMeetingLocationSuccess;

		createMeetingLocation(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__createMeetingLocationSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var htmlRecord = json.htmlRecord;
			var htmlSelectOption = json.htmlSelectOption;

			$("#tableMeetingLocations tbody").append(htmlRecord);
			$("#formCreateMeetingLocation")[0].reset();
			$(".meetingLocations").append(htmlSelectOption);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__deleteMeetingLocation(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__Meetings__deleteMeetingLocationSuccess;

		deleteMeetingLocation(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__deleteMeetingLocationSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;

			// Remove the deleted meeting location from the meetingLocations dropdowns.
			$(".meetingLocations option").each(function(i) {
				var val = $(this).prop('value');
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

function create_ActionItem_And_ActionItemAssignment_And_DiscussionItemToActionItem_ViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var discussion_item_id = options.discussion_item_id;
		var checkEdit = $("#input-check-record_list_container--action_items--discussion_item_id--"+discussion_item_id).val();
		var task_content = $(".textareaCreateActionItem--"+discussion_item_id).val();
		if (task_content == '' || task_content.trim().length < 1) {
			$(".textareaCreateActionItem--"+discussion_item_id).addClass('redBorderThick');
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');
			return;
		}else{
			$(".textareaCreateActionItem--"+discussion_item_id).removeClass('redBorderThick');
		}
		// @todo Test and verify this code...
		/*
		var action_item_assignee_contact_id_element_id = attributeGroupName + '--action_item_assignments--action_item_assignee_contact_id--' + uniqueId;
		if ($("#" + action_item_assignee_contact_id_element_id).length) {
			var action_item_assignee_contact_id = $("#" + action_item_assignee_contact_id_element_id).val();
			if (action_item_assignee_contact_id == 0) {
				return;
			}
		}
		*/

		// Debug
		//alert(discussion_item_id);

		var promise = createActionItem(attributeGroupName, uniqueId, options);

		// This is not our typical promise chain pattern. The following three units
		// of work are dependent only on the newly created action_items record.

		promise.then(function(json) {

			// Update the UI.
			try {

				// Hide create action item elements.
				$(".trCreateActionItem--" + discussion_item_id).addClass('hidden');
				// Increment number of action items.
				var strNumActionItems = $("#numActionItems--" + discussion_item_id).html();
				var intNumActionItems = parseInputToInt(strNumActionItems) + 1;
				var tmpHtml = intNumActionItems.toString();
				$("#numActionItems--" + discussion_item_id).html(tmpHtml);

			} catch(error) {

				if (window.showJSExceptions) {
					var errorMessage = error.message;
					alert('Exception Thrown: ' + errorMessage);
					return;
				}

			}
		});

		promise.then(function(json) {

			// Create action_item_assignments record(s).
			try {

				var uniqueId = json.uniqueId;
				var dummyId = json.dummyId;

				// Get csv of contact ids, create action item assignments.
				var arrContactIds = [];
				$("#record_list_container--action_item_assignments--" + dummyId + " .action_item_assignee_contact_id").each(function() {
					var contact_id = $(this).val();
					arrContactIds.push(contact_id);
				});
				// Error check for existence of contact_id values
				if (arrContactIds.length == 0) {
					return;
				}
				var csvContactIds = arrContactIds.join(',');
				// Update action_item_id for createActionItemAssignment.
				$("#create-action_item_assignment-record--action_item_assignments--action_item_id--" + dummyId).val(uniqueId);

				options.adHocQueryParameters = '&csvContactIds=' + encodeURIComponent(csvContactIds);
				//options.csvContactIds = csvContactIds;
				options.successCallback = createActionItemAssignmentHelperSuccess;
				createActionItemAssignment('create-action_item_assignment-record', dummyId, options);

			} catch(error) {

				if (window.showJSExceptions) {
					var errorMessage = error.message;
					alert('Exception Thrown: ' + errorMessage);
					return;
				}

			}
		});

		promise.then(function(json) {

			// Create a discussion_items_to_action_items record.
			try {

				var uniqueId = json.uniqueId;
				var dummyId = json.dummyId;

				// Update action_item_id for createDiscussionItemToActionItem.
				$("#create-discussion_item_to_action_item-record--discussion_items_to_action_items--action_item_id--" + dummyId).val(uniqueId);
				options.successCallback = createDiscussionItemToActionItemHelperSuccess;
				createDiscussionItemToActionItem('create-discussion_item_to_action_item-record', dummyId, options);

			} catch(error) {

				if (window.showJSExceptions) {
					var errorMessage = error.message;
					alert('Exception Thrown: ' + errorMessage);
					return;
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

function createActionItemAssignmentHelperSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			var dummyId = json.dummyId;
			var liEditable = json.liEditable;
			var liUneditable = json.liUneditable;
			$('.save_action_'+dummyId).removeAttr('disabled');
			$("#formCreateActionItem--" + dummyId)[0].reset();
			$("#record_list_container--action_item_assignments--" + dummyId).html('');

			var tokens = uniqueId.split('-');
			var action_item_id = tokens[0];
			// $("#record_list_container--action_item_assignments--" + dummyId).append(liEditable);
			// To restrict the double entry 
			$("#record_list_container--action_item_assignments--" + action_item_id).empty().append(liUneditable);
			$(".record_Editable_container--" + action_item_id).empty().append(liEditable);

		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createDiscussionItemToActionItemHelperSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var htmlRecord = json.htmlRecord;
			var dummyId = json.dummyId;
			$('.save_action_'+dummyId).removeAttr('disabled');
			$("#formCreateActionItem--" + dummyId)[0].reset();
			var discussion_item_id = json.discussion_item_id;
			// $("#record_list_container--action_items--discussion_item_id--" + discussion_item_id + " tbody").append(htmlRecord);
			$("#append-" + discussion_item_id).before(htmlRecord);
			var checkEdit = $("#input-check-record_list_container--action_items--discussion_item_id--"+discussion_item_id).val();
			if(Number(checkEdit) == 1){
				showEditActionItems(discussion_item_id);
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

function Collaboration_Manager__Meetings__createActionItemAssignment(attributeGroupName, uniqueId, discussionItemId, options)
{
	try {

		var options = options || {};
		var discussion_item_id = options.discussion_item_id;

		options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__Meetings__createActionItemAssignmentSuccess;

		// Debug
		//alert(discussion_item_id);

		var promise = createActionItemAssignment(attributeGroupName, uniqueId, options);

		var task_content= $("#manage-action_item-record--action_items--action_item--"+discussionItemId).val();

		if (task_content == '' || task_content.trim().length < 1) {
			$("#manage-action_item-record--action_items--action_item--"+discussionItemId).addClass('redBorderThick').focus();
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__createActionItemAssignmentSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			var dummyId = json.dummyId;
			var liEditable = json.liEditable;
			var liUneditable = json.liUneditable;

			var tokens = uniqueId.split('-');
			var action_item_id = tokens[0];
			$("#record_list_container--action_item_assignments--" + dummyId).append(liEditable);
			$("#record_list_container--action_item_assignments--" + action_item_id).append(liUneditable);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__deleteActionItemAssignment(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};

		options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__Meetings__deleteActionItemAssignmentSuccess;

		var promise = deleteActionItemAssignment(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__deleteActionItemAssignmentSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var attributeGroupName = json.attributeGroupName;
			var attributeSubgroupName = json.attributeSubgroupName;
			var uniqueId = json.uniqueId;

			// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
			var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;
			var readOnlyRecordContainerElementId = 'record_container--' + attributeGroupName + '-read_only--' + attributeSubgroupName + '--' + uniqueId;
			$("#" + recordContainerElementId).remove();
			$("#" + readOnlyRecordContainerElementId).remove();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__Meetings__deleteActionItem(action_item_id)
{
	try {

		var options = options || {};

		options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__Meetings__deleteActionItemSuccess;

		// manage-action_item-record--action_items--action_item--94
		var action_item = $("#manage-action_item-record--action_items--action_item--" + action_item_id).text();

		var confirmationDialogMessage = '' +
		'<br>Are you sure that you want to delete the following action item?' +
		'<br><br>&ldquo;' + action_item + '&rdquo;<br><br>' +
		'This will permanently delete the action item from this discussion item and any other discussion items it may be associated with in other meetings.';

		options.confirmationDialogMessage = confirmationDialogMessage;
		options.confirmationDialogTitle = 'Delete Action Item?';
		options.confirmButtonText = 'Delete';
		options.cancelButtonText = 'Cancel';
		options.confirmationDialogWidth = 600;
		options.confirmationDialogHeight = 400;

		var confirmationDialogPromise = confirmationDialog(options);

		confirmationDialogPromise.done(function() {
			// They pressed Delete
			var recordContainerElementId = 'record_container--manage-action_item-record--action_items--sort_order--' + action_item_id;
			var attributeGroupName = 'manage-action_item-record';
			var uniqueId = action_item_id;

			deleteActionItem(recordContainerElementId, attributeGroupName, uniqueId, options);
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

function Collaboration_Manager__Meetings__deleteActionItemSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var attributeGroupName = json.attributeGroupName;
			var attributeSubgroupName = json.attributeSubgroupName;
			var uniqueId = json.uniqueId;

			// HTML Record Container Element id Format:
			//	id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
			//	id="record_container--attributeGroupName-read_only--attributeSubgroupName--sort_order--uniqueId"

			/*
			var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;
			var readOnlyRecordContainerElementId = 'record_container--' + attributeGroupName + '-read_only--' + attributeSubgroupName + '--sort_order--' + uniqueId;
			$("#" + recordContainerElementId).remove();
			$("#" + readOnlyRecordContainerElementId).remove();
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

function updateMeetingPermission(id,meeting_type_id,role_id,project_id)
{	
	var check = $("#meetrolep-"+meeting_type_id+"-"+role_id).prop('checked');
	var is_check ="";
	if(check == true)
	{
		is_check ="Y";
	}else
	{
		is_check ="N";
	}
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=updateMeetingPermission';
		var ajaxQueryString =
			'meeting_type_id=' + encodeURIComponent(meeting_type_id)+
			'&role_id=' + encodeURIComponent(role_id)+
			'&is_check='+is_check+
			'&project_id=' + encodeURIComponent(project_id);
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
			success: function(){

			},
			error: errorHandler
		});

}
function filtermeetingroles(alpha)
{
	if(alpha==undefined ||alpha=="undefined")
	{
		 alpha ="";

	}else
	{
		if(alpha =="all")
		{
			alpha ="";
		}
		$('.filrol').removeClass('perseleted');
		$("#per"+alpha).addClass('perseleted');
	}
	var role="";
	if(alpha=="")
	{
		$.each($(".perseleted"), function(){ 
			role = this.id;
			if($('#'+role).hasClass('perseleted'))
			{
				role = role.replace("per", "");
			}

		});
	}

	if(role!="")
	{
		alpha = role;
	}
	var role_spec = $("#specify_sel").val();
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=filterMeetingPermission';
		var ajaxQueryString ='role_spec=' + encodeURIComponent(role_spec)+
			'&role_filter=' + encodeURIComponent(alpha);
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
				$('.nonProSpecTable').empty().append(data);
			},
			error: errorHandler
		});

}
// For display meeting permission
function loadMeetingPermissionModal(element)
{
	try {
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadMeetingPermission';
		var ajaxQueryString ="";
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
			success: loadMeetingPermissionModalSuccess,
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

function loadMeetingPermissionModalSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var htmlContent = json.htmlContent;


		var windowHeight = $(window).height();
		var dialogHeight = windowHeight * 0.80;

		$("#divCreateMeetingDialog").html(htmlContent);
		$("#divCreateMeetingDialog").removeClass('hidden');
		$("#divCreateMeetingDialog").dialog({
			modal: true,
			title: 'Meeting Permission — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
			width: 1100,
			height: dialogHeight,
			open: function(event, ui) {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("#divCreateMeetingDialog").dialog('destroy');
				$("#divCreateMeetingDialog").html('');
				$("#divCreateMeetingDialog").addClass('hidden');
				$("body").removeClass('noscroll');
				window.location.reload();
			},
			
		});

		

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadCreateMeetingDialog(element)
{
	try {

		if (element) {
			var meeting_type_id = $(element).val();
		} else {
			var meeting_type_id = $("#ddl_meeting_type_id").val();
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadCreateMeetingDialog';
		var ajaxQueryString =
			'meeting_type_id=' + encodeURIComponent(meeting_type_id);
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
			success: loadCreateMeetingDialogSuccess,
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

function loadCreateMeetingDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var htmlContent = json.htmlContent;
		var attributeGroupName = json.attributeGroupName;
		var uniqueId = json.uniqueId;
		var options = json.options;

		var windowHeight = $(window).height();
		var dialogHeight = windowHeight * 0.80;

		$("#divCreateMeetingDialog").html(htmlContent);
		$("#divCreateMeetingDialog").removeClass('hidden');
		$("#divCreateMeetingDialog").dialog({
			modal: true,
			title: 'Create Meeting — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
			width: 1100,
			height: dialogHeight,
			open: function(event, ui) {
				$("#buttonCreateMeeting").focus();
				$("body").addClass('noscroll');
			},
			close: function() {
				$("#divCreateMeetingDialog").dialog('destroy');
				$("#divCreateMeetingDialog").html('');
				$("#divCreateMeetingDialog").addClass('hidden');
				$("body").removeClass('noscroll');
			},
			buttons: {
				'Create Meeting': function() {
					Collaboration_Manager__createMeeting(attributeGroupName, uniqueId, options);
				},
				'Cancel': function() {
					$(this).dialog('close');
				}
			}
		});

		cancelCloneMeetingDataToNextMeeting = false;
		$(".nextMeetingDataCreateCase").on('change', function(e) {
			cancelCloneMeetingDataToNextMeeting = true;
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function createMeetingToggleAllAttendees(element, attributeGroupName)
{
	var checked = $(element).prop('checked');
	$("." + attributeGroupName + '--meetingAttendee').prop('checked', checked);
}

function modifyTimepickerCss(element)
{
	$(element).css('z-index', '410');
}

function loadMeetingAttendeesByMeetingTypeId(element)
{
	try {

		var meeting_type_id = $(element).val();

		if (!meeting_type_id) {
			return;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadMeetingAttendeesByMeetingTypeId';
		var ajaxQueryString =
			'meeting_type_id=' + encodeURIComponent(meeting_type_id);
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
			success: loadMeetingAttendeesByMeetingTypeIdSuccess,
			error: errorHandler
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadMeetingAttendeesByMeetingTypeIdSuccess(data, textStatus, jqXHR)
{
	try {

		$("#tableMeetingAttendees").html(data);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function clearMeetingTimes(className)
{
	$("." + className).val('');
	cancelCloneMeetingDataToNextMeeting = true;
}

function changeDataTonext(timeId)
{
	cloneMeetingDataToNextMeeting(timeId,'1')
}

function cloneMeetingDataToNextMeeting(element,DateFil)
{
	if (cancelCloneMeetingDataToNextMeeting) {
		return;
	}
	if(DateFil)
		{
			var meetingStartTimeElementId = element;
		}else{
	var meetingStartTimeElementId = $(element).prop('id');
	}
	var meetingStartDateElementId = meetingStartTimeElementId.replace('time', 'date');
	var meetingEndTimeElementId = meetingStartTimeElementId.replace('start', 'end');
	var meetingEndDateElementId = meetingEndTimeElementId.replace('time', 'date');
	var nextMeetingStartTimeElementId = meetingStartTimeElementId.replace('meeting_start_time', 'next_meeting_start_time');
	var nextMeetingStartDateElementId = nextMeetingStartTimeElementId.replace('time', 'date');
	var nextMeetingEndTimeElementId = nextMeetingStartTimeElementId.replace('start', 'end');
	var nextMeetingEndDateElementId = nextMeetingEndTimeElementId.replace('time', 'date');

	// Set meeting end date.
	var meetingStartDate = $("#" + meetingStartDateElementId).val();
	$("#" + meetingEndDateElementId).val(meetingStartDate);
	var addDate=0;
	// Set meeting end time.
	if(DateFil)
	{
		var meetingStartTime = $("#"+element).val();
	}else{
	var meetingStartTime = $(element).val();
	}
	var meetingEndTime = meetingStartTime;
	if (meetingEndTime.substring(0, 2) == '11') {
		meetingEndTime = meetingEndTime.replace('11', '12');
		if (meetingEndTime.indexOf('a') > 0) {
			meetingEndTime = meetingEndTime.replace('a', 'p');
		} else {
			meetingEndTime = meetingEndTime.replace('p', 'a');
			addDate=86400000;
		//To get the next day
   		var mnewdate = new Date(meetingStartDate);
            	mnewdate.setDate(mnewdate.getDate() + 1);
         	var dd =((mnewdate.getDate()) < 10 ? '0': '')+ (mnewdate.getDate());
	    	var mm = ((mnewdate.getMonth() + 1 ) < 10 ? '0': '') + (mnewdate.getMonth() + 1);
	     	var y = mnewdate.getFullYear();
	    	var endmeetday=mm + '/' + dd + '/' + y;
	     	$("#" + meetingEndDateElementId).val(endmeetday);
		
		}
	} else if (meetingEndTime.substring(0, 2) == '12') {
		meetingEndTime = meetingEndTime.replace('12', '1');
	} else {
		var colonIndex = meetingEndTime.indexOf(':');
		var hour = meetingEndTime.substring(0, colonIndex);
		var oldHour = parseInputToInt(hour);
		if(oldHour == '')
		{
		var newHour = oldHour;}
		else
		{
		var newHour = oldHour + 1;
		}
		meetingEndTime = meetingEndTime.replace(hour, newHour);
	}
	$("#" + meetingEndTimeElementId).val(meetingEndTime);

	// Set next meeting start date.
	var meetingStartDateMillis = new Date(meetingStartDate).getTime();
	var oneWeekMillis = 604800 * 1000;
	var nextMeetingStartDateMillis = meetingStartDateMillis + oneWeekMillis;
	var nextMeetingStartDateObj = new Date(nextMeetingStartDateMillis);
	var nextMeetingMonth =((nextMeetingStartDateObj.getMonth() + 1 ) < 10 ? '0': '') +(nextMeetingStartDateObj.getMonth() + 1);
	var nextMeetingDay =((nextMeetingStartDateObj.getDate()) < 10 ? '0': '')+ nextMeetingStartDateObj.getDate();
	var nextMeetingYear = nextMeetingStartDateObj.getFullYear();
	var nextMeetingStartDate = nextMeetingMonth + '/' + nextMeetingDay + '/' + nextMeetingYear;
	//To add a day if it is am
	if(addDate)
	{
		nextMeetingStartDateMillisfute=nextMeetingStartDateMillis+addDate
		var nextMeetingfutureObj = new Date(nextMeetingStartDateMillisfute);
		var nextMeetingDayft =((nextMeetingfutureObj.getDate()) < 10 ? '0': '')+ nextMeetingfutureObj.getDate();
		var nextMeetingEndDate = nextMeetingMonth + '/' + nextMeetingDayft + '/' + nextMeetingYear;
	}else
	{
		var nextMeetingEndDate = nextMeetingMonth + '/' + nextMeetingDay + '/' + nextMeetingYear;
	}
	$("#" + nextMeetingStartDateElementId).val(nextMeetingStartDate);

	// Set next meeting start time.
	$("#" + nextMeetingStartTimeElementId).val(meetingStartTime);

	// Set next meeting end date.
	$("#" + nextMeetingEndDateElementId).val(nextMeetingEndDate);

	// Set next meeting end time.
	$("#" + nextMeetingEndTimeElementId).val(meetingEndTime);
}

function setNextMeetingLocation(element)
{
	if (cancelCloneMeetingDataToNextMeeting) {
		return;
	}
	var elementId = $(element).prop('id');
	var nextMeetingLocationElementId = elementId.replace('meeting_location_id', 'next_meeting_location_id');
	var val = $(element).val();
	$("#" + nextMeetingLocationElementId).val(val);
}

function setNextMeetingAllDayEventFlag(element)
{
	if (cancelCloneMeetingDataToNextMeeting) {
		return;
	}
	var elementId = $(element).prop('id');
	var nextMeetingAllDayEventFlagElementId = elementId.replace('all_day_event_flag', 'next_all_day_event_flag');
	var checked = $(element).prop('checked');
	$("#" + nextMeetingAllDayEventFlagElementId).prop('checked', checked);
}

function showDeleteMeetingDialog(recordContainerElementId, attributeGroupName, uniqueId)
{
	$("#divDeleteMeetingDialog").removeClass('hidden');
	$("#divDeleteMeetingDialog").dialog({
		modal: true,
		title: 'Delete Meeting — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
		width: 500,
		height: 190,
		open: function() {
			$("#divDeleteMeetingDialog input").blur();
			$("body").addClass('noscroll');
		},
		close: function() {
			$("#divDeleteMeetingDialog").addClass('hidden');
			$("#divDeleteMeetingDialog").html('');
			$("#divDeleteMeetingDialog").dialog('destroy');
			$("body").removeClass('noscroll');
		},
		buttons: {
			'Cancel': function () {
				$("#divDeleteMeetingDialog").dialog('close');
			},
			'Delete': function() {
				deleteMeetingHelper(recordContainerElementId, attributeGroupName, uniqueId);
			}
		}
	});
}

function deleteMeetingHelper(recordContainerElementId, attributeGroupName, uniqueId)
{
	var radioButton = $("#formDeleteMeeting input[type=radio]:checked");
	var elementId = radioButton.prop('id');
	var options = {};
	if (elementId == 'radioDeleteMeetingThisMeetingOnly') {
		options.deleteThisMeetingOnly = true;
	} else if (elementId == 'radioDeleteMeetingAndSubsequentMeetings') {
		options.deleteMeetingAndSubsequentMeetings = true;
	} else {
		return;
	}

	deleteMeeting(recordContainerElementId, attributeGroupName, uniqueId, options);
}

function loadDdlMeetingTypes()
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadDdlMeetingTypes';
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
			success: loadDdlMeetingTypesSuccess,
			error: errorHandler
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadDdlMeetingTypesSuccess(data, textStatus, jqXHR)
{
	try {

		$("#ddl_meeting_type_id").html(data);

		var arrOptions = [];
		$("#ddl_meeting_type_id option").each(function(i) {
			arrOptions.push(this.outerHTML);
		});
		if (arrOptions.length == 1) {
			$("#buttonNewMeeting").attr('disabled', 'true');
		} else {
			$("#buttonNewMeeting").removeAttr('disabled');
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function meetingTypeSelectedInCreateMeetingDialog(element)
{
	var modalMeetingTypeVal = $(element).val();
	var meetingTypeVal = $("#ddl_meeting_type_id").val();
	if (modalMeetingTypeVal != meetingTypeVal) {
		$("#ddl_meeting_type_id").val(modalMeetingTypeVal);
		// Populate <select> on main screen, not the modal dialog.
		loadMeetingsByMeetingTypeId();
	}
}

function updateCorrespondingElement(element)
{
	try {

		var elementId = $(element).attr('id');
		var arrTemp = elementId.split('--');
		var attributeGroupName = arrTemp[0];
		var attributeSubgroupName = arrTemp[1];
		var attributeName = arrTemp[2];
		var uniqueId = arrTemp[3];

		attributeGroupName += '-read_only';
		arrTemp[0] = attributeGroupName;

		var correspondingElementId = arrTemp.join('--');
		var correspondingElement = $("#" + correspondingElementId);

		var action_item_val = $("#manage-action_item-record--action_items--action_item--"+uniqueId).val();

		var htmlContent = $(element).val();
		if(htmlContent!='' && htmlContent != null){
		if ((attributeName.indexOf('_date') > -1) || (attributeName.indexOf('timestamp') > -1 )) {
			var date = new Date(htmlContent);
			var m = date.getShortMonthName();
			var d = date.getDate();
			var y = date.getFullYear();
			var dateString = m + ' ' + d + ', ' + y;
			htmlContent = dateString;
		}
		}else{
			htmlContent = 'N/A';
		}
		correspondingElement.html(htmlContent);

		if ((action_item_val == '' || action_item_val.trim().length < 1)) {
			$("#manage-action_item-record--action_items--action_item--"+uniqueId).addClass('redBorderThick').focus();
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');
			return;
		}else{
			$("#manage-action_item-record--action_items--action_item--"+uniqueId).removeClass('redBorderThick');
		}

		if (attributeName == 'action_item') {
			// $(".action_item_textarea").removeClass('redBorderThick');
			updateActionItem(element); 
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__createMeetingTypeFromMeetingTypeTemplate__createMeetingType(meeting_type_template_id)
{
	try {

		meeting_type_template_id = $.trim(meeting_type_template_id);

		var options = options || {};

		options.responseDataType = 'json';
		options.includeHtmlContent = 'Y';
		options.adHocQueryParameters = '&meeting_type_template_id=' + encodeURIComponent(meeting_type_template_id);
		options.scenarioName = 'createMeetingTypeFromMeetingTypeTemplate';
		options.successCallback = Collaboration_Manager__createMeetingTypeSuccess;

		var attributeGroupName = 'clone-meeting_type_template-record';
		var uniqueId = 'nonExistentId';

		createMeetingType(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert(errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__createMeetingTypeSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			var htmlRecordTr = json.htmlRecordTr;
			var htmlRecordOption = json.htmlRecordOption;

			$("#record_creation_form_container--create-meeting_type-record").find('input[type=text], textarea').val('');
			$("#record_list_container--manage-meeting_type-record tbody").prepend(htmlRecordTr);
			$("#ddl_meeting_type_id").prepend(htmlRecordOption);

			//loadDdlMeetingTypes();
			//loadManageMeetingTypesDialog();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert(errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__deleteMeetingType(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.successCallback = Collaboration_Manager__deleteMeetingTypeSuccess;

		deleteMeetingType(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Collaboration_Manager__deleteMeetingTypeSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;

			// Note: the standard <tr> record is DOM deleted by the default ajax delete callback

			// Remove <option>
			$("#ddl_meeting_type_id option[value="+uniqueId+"]").remove();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
