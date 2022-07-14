$(function(){
	
	$( "#due_date,#complete_date,.tcomp_date,.tduedate").datepicker({
    	changeMonth: true, 
    	changeYear: true, 
    	dateFormat: 'mm/dd/yy', 
    	numberOfMonths: 1
	});
	$( ".tcomp_dateRfiSu").datepicker({ minDate: 0,maxDate:0 });

	$(document).on('change',".tcomp_date",function(){
		var comp_id = $(this).attr('id');
		var completed_date = $(this).val();
		completed_date = convertTimestampToMySQLFormat(completed_date);
		completed_date = completed_date.replace("+", "%20");
		var comp_id_arr = comp_id.split('_');
		var comp_date = $(".complete_date").attr('id');		
		if(comp_id_arr[1]){			
			$.get('/action_items-ajax.php', {'method':'updateActionItem', 
				'attributeGroupName':'manage-action_item-record','attributeSubgroupName':'action_items', 
				'attributeName':'action_item_completed_timestamp', 'sortOrderFlag':'Y',
				'uniqueId':comp_id_arr[1],'newValue':completed_date,'newValueText':'',
				'formattedAttributeGroupName':'Action Item', 
				'formattedAttributeSubgroupName':'Action Items', 'formattedAttributeName':''},
			function(data){
				messageAlert('Action Item - '+data.formattedAttributeName+' Successfully updated.', 'successMessage');
			});					
		}else{
			messageAlert('Completed Date update Error.', 'errorMessage');
				return false;
		}		
	});

	$(document).on('change',".tcomp_dateRfiSu",function(){
		var comp_id = $(this).attr('id');
		var completed_date = $(this).val();
		completed_date = convertTimestampToMySQLFormat(completed_date);
		completed_date = completed_date.replace("+", "%20");
		var comp_id_arr = comp_id.split('_');
		var task_summary_type = $("#task_summary_type").val();
		var comp_date = $(".complete_date").attr('id');		
		if(comp_id_arr[1]){
			if (task_summary_type == 'rfis') {
				if (comp_date =='completed') {
					comp_date = 2;
				}else{
					comp_date = 4;
				}
				$.get('/requests_for_information-ajax.php', {'method':'updateRequestForInformation', 'attributeGroupName':'manage-request_for_information-record','attributeSubgroupName':'requests_for_information', 
					'attributeName':'request_for_information_status_id', 'sortOrderFlag':'Y',
					'uniqueId':comp_id_arr[1],'newValue':'','newValueText':'',
					'formattedAttributeGroupName':'Request For Information', 
					'formattedAttributeSubgroupName':'Request For Information', 'formattedAttributeName':'','attributeName': 'request_for_information_status_id','newValue':comp_date},
				function(data){	
					// $('#rfi_row_'+comp_id_arr[1]).hide();			
					messageAlert('Action Item - '+data.formattedAttributeName+' Successfully updated.', 'successMessage');											
				});
				updateRfiInMeeting(comp_id_arr[1],comp_date,'action_item_completed_timestamp',comp_date);
			}else{
				if (comp_date =='completed') {
					comp_date = 5;
				}else{
					comp_date = 2;
				}
				$.get('/submittals-ajax.php', {'method':'updateSubmittal', 'attributeGroupName':'manage-submittal-record','attributeSubgroupName':'submittals', 
					'attributeName':'submittal_status_id', 'sortOrderFlag':'Y',
					'uniqueId':comp_id_arr[1],'newValue':comp_date,'newValueText':'',
					'formattedAttributeGroupName':'Submittal', 
					'formattedAttributeSubgroupName':'Submittals', 'formattedAttributeName':''},
				function(data){	
					// $('#su_row_'+comp_id_arr[1]).hide();					
					messageAlert('Action Item - '+data.formattedAttributeName+' Successfully updated.', 'successMessage');
				});
				updateSubmittalInMeeting(comp_id_arr[1],comp_date,'action_item_completed_timestamp',comp_date);
			}			
		}else{
			messageAlert('Completed Date update Error.', 'errorMessage');
				return false;
		}		
	});

	$(document).on('change',".tduedate",function(){
		var comp_id = $(this).attr('id');
		var due_date = $(this).val();
		var duedate_arr = due_date.split('/');
		due_date = duedate_arr[2]+"/"+duedate_arr[0]+"/"+duedate_arr[1];
		/*due_date = convertTimestampToMySQLFormat(due_date);
		due_date = due_date.replace("+", "%20");*/
		var due_id_arr = comp_id.split('_');
		var task_summary_type = $("#task_summary_type").val();	
		if(due_id_arr[1]){
			if (task_summary_type == 'meetings') {
				$.get('/action_items-ajax.php', {'method':'updateActionItem', 
					'attributeGroupName':'manage-action_item-record','attributeSubgroupName':'action_items', 
					'attributeName':'action_item_due_date', 'sortOrderFlag':'Y',
					'uniqueId':due_id_arr[1],'newValue':due_date,'newValueText':'',
					'formattedAttributeGroupName':'Action Item', 
					'formattedAttributeSubgroupName':'Action Items', 'formattedAttributeName':''},
				function(data){					
					dateChangeSuccess(data,comp_id);						
				});
			}else if (task_summary_type == 'rfis') {
				$.get('/requests_for_information-ajax.php', {'method':'updateRequestForInformation', 'attributeGroupName':'create-request_for_information-record','attributeSubgroupName':'requests_for_information', 
					'attributeName':'rfi_due_date', 'sortOrderFlag':'Y',
					'uniqueId':due_id_arr[1],'newValue':due_date,'newValueText':'',
					'formattedAttributeGroupName':'Request For Information', 
					'formattedAttributeSubgroupName':'Request For Information', 'formattedAttributeName':''},
				function(data){					
					dateChangeSuccess(data,comp_id);						
				});
				updateRfiInMeeting(due_id_arr[1],due_date,'action_item_due_date','');
			}else{
				$.get('/submittals-ajax.php', {'method':'updateSubmittal', 'attributeGroupName':'manage-submittal-record','attributeSubgroupName':'submittals', 
					'attributeName':'su_due_date', 'sortOrderFlag':'Y',
					'uniqueId':due_id_arr[1],'newValue':due_date,'newValueText':'',
					'formattedAttributeGroupName':'Submittal', 
					'formattedAttributeSubgroupName':'Submittals', 'formattedAttributeName':''},
				function(data){					
					dateChangeSuccess(data,comp_id);						
				});
				updateSubmittalInMeeting(due_id_arr[1],due_date,'action_item_due_date','');
			}	
		}else{
			messageAlert('Due Date Update Error', 'errorMessage');
				return false;
		}
		
	});

	function dateChangeSuccess(data,comp_id){

		messageAlert('Action Item - '+data.formattedAttributeName+' Successfully updated.', 'successMessage');

		var myDate=data.newValue; //2019-07-15
		var currentDate = new Date();
		
		currentDate.setDate(currentDate.getDate() - 1);
		var currenDateTime = currentDate.getTime();
		var sevenDate = new Date();
			sevenDate.setDate(sevenDate.getDate() + 7);
		var sevenDateTime = sevenDate.getTime();
		var fifteenDate = new Date();
			fifteenDate.setDate(fifteenDate.getDate()+15);
		var fifteenDateTime = fifteenDate.getTime();
			myDate=myDate.split("/");
		var newDate=myDate[1]+"/"+myDate[2]+"/"+myDate[0];
		var dueDate = new Date(newDate).getTime();

		if(dueDate > sevenDateTime && dueDate <= fifteenDateTime){
			$('#'+comp_id).next('div').removeClass().addClass('calender-icon due-date-clr-2');
		}else if(dueDate >= currenDateTime && dueDate <= sevenDateTime){
			$('#'+comp_id).next('div').removeClass().addClass('calender-icon due-date-clr-1');
		}else if(dueDate < currenDateTime){
			$('#'+comp_id).next('div').removeClass().addClass('calender-icon due-date-clr-3');
		}else{
			$('#'+comp_id).next('div').removeClass().addClass('calender-icon');
		}
	}

	$("#assigned_to,#task_item,#due_date,#discussion,#meeting_type").bind("keyup change",function(){
		var task_summary_type = $("#task_summary_type").val();	
		var task = $("#task_item").val();
		var assigned_to = $("#assigned_to").val();
		var user_role = $("#userRole").val();
		var project_id = $("#currentlySelectedProjectId").val();
		var project_manager = $("#projManager").val();
		var user_id = $("#user_id").val();
		var due_date = $("#due_date").val();
		var comp_date = $(".complete_date").attr('id');
		var discussion = $("#discussion").val();
		var meeting_type = $("#meeting_type").val();
		if(comp_date =='completed'){
			comp_date = 'uncomplete';
		}else{
			comp_date = 'completed';
		}
		$.post('dashboard-ajax.php',{'method':'filter_task_summary','task_summary_type':task_summary_type,'task':task,'assigned_to':assigned_to,'user_role':user_role,'project_id':project_id,'project_manager':project_manager,'user_id':user_id,'due_date':due_date,'complete_date':comp_date,'discussion':discussion,'meeting_type':meeting_type},
			function(data){
				console.log(data);
				var obj = JSON.parse(data);
				//console.log(obj.task_summary_count);
				
				$("#tasksummary_bod").html(obj.task_summary_html);				
				$("#task_cnt").html(obj.task_summary_count);
				$( "#due_date,#complete_date,.tcomp_date,.tduedate").datepicker({
			    	changeMonth: true, 
			    	changeYear: true, 
			    	dateFormat: 'mm/dd/yy', 
			    	numberOfMonths: 1
				});
				$( ".tcomp_dateRfiSu").datepicker({ minDate: 0,maxDate:0 });
				
		});

	});
	$(".complete_date").on('click',function(e){
		var task_summary_type = $("#task_summary_type").val();	
		var task = $("#task_item").val();
		var assigned_to = $("#assigned_to").val();
		var user_role = $("#userRole").val();
		var project_id = $("#currentlySelectedProjectId").val();
		var project_manager = $("#projManager").val();
		var user_id = $("#user_id").val();
		var due_date = $("#due_date").val();
		var comp_date = $(".complete_date").attr('id');
		var discussion = $("#discussion").val();
		var meeting_type = $("#meeting_type").val();
		if(comp_date =='completed'){
			$(".complete_date").attr('id','uncomplete');
			$(".complete_date").text('Show Completed Tasks');
		}else{
			$(".complete_date").attr('id','completed');
			$(".complete_date").text('Hide Completed Tasks');

		}
		$.post('dashboard-ajax.php',{'method':'filter_task_summary','task_summary_type':task_summary_type,'task':task,'assigned_to':assigned_to,'user_role':user_role,'project_id':project_id,'project_manager':project_manager,'user_id':user_id,'due_date':due_date,'complete_date':comp_date,'discussion':discussion,'meeting_type':meeting_type},
			function(data){
				//console.log(data);
				var obj = JSON.parse(data);
				//console.log(obj);
				//console.log(obj.task_summary_count);
				
				$("#tasksummary_bod").html(obj.task_summary_html);				
				$("#task_cnt").html(obj.task_summary_count);
				$( "#due_date,#complete_date,.tcomp_date,.tduedate").datepicker({
			    	changeMonth: true, 
			    	changeYear: true, 
			    	dateFormat: 'mm/dd/yy', 
			    	numberOfMonths: 1
				});
				$( ".tcomp_dateRfiSu").datepicker({ minDate: 0,maxDate:0 });
				e.preventDefault();
				
				
		});

	});
	

});
function sorttaskTable(columnName){
	var task_summary_type = $("#task_summary_type").val();	
	var task = $("#task_item").val();
	var assigned_to = $("#assigned_to").val();
	var user_role = $("#userRole").val();
	var project_id = $("#currentlySelectedProjectId").val();
	var project_manager = $("#projManager").val();
	var user_id = $("#user_id").val();
	var due_date = $("#due_date").val();
	var comp_date = $(".complete_date").attr('id');
	var discussion = $("#discussion").val();
	var meeting_type = $("#meeting_type").val();
	var sort = $("#sort").val();
	if(comp_date =='completed'){
		comp_date = 'uncomplete';
	}else{
		comp_date = 'completed';
	}

	$.post('dashboard-ajax.php',{'method':'filter_task_summary','task_summary_type':task_summary_type,'task':task,'assigned_to':assigned_to,'user_role':user_role,'project_id':project_id,'project_manager':project_manager,'user_id':user_id,'due_date':due_date,'complete_date':comp_date,'discussion':discussion,'meeting_type':meeting_type,'sort_type':sort,'sort_column':columnName
		},
			function(data){
				//console.log(data);
				var obj = JSON.parse(data);
				//console.log(obj.task_summary_count);				
				$("#tasksummary_bod").html(obj.task_summary_html);				
				$("#task_cnt").html(obj.task_summary_count);

				if(sort == "asc"){
					$("#sort").val("desc");
				}else{
					$("#sort").val("asc");
				}
				$( "#due_date,#complete_date,.tcomp_date,.tduedate").datepicker({
			    	changeMonth: true, 
			    	changeYear: true, 
			    	dateFormat: 'mm/dd/yy', 
			    	numberOfMonths: 1
				});
				$( ".tcomp_dateRfiSu").datepicker({ minDate: 0,maxDate:0 });
		});
}

/* Function to update submittal details to meeting */
function updateSubmittalInMeeting(uniqueId,newValue,attName,su_status_id){

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-ajax.php?method=updateActionItemSu';
	var ajaxQueryString =
		'su_id=' + encodeURIComponent(uniqueId)+
		'&su_field_value=' + encodeURIComponent(newValue)+
		'&su_field_name=' + encodeURIComponent(attName)+
		'&su_status_id=' + encodeURIComponent(su_status_id);

	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString
	});
}

/* Function to update rfi details to meeting */
function updateRfiInMeeting(uniqueId,newValue,attName,rfi_status_id){

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=updateActionItemRfi';
	var ajaxQueryString =
		'rfi_id=' + encodeURIComponent(uniqueId)+
		'&rfi_field_value=' + encodeURIComponent(newValue)+
		'&rfi_field_name=' + encodeURIComponent(attName)+
		'&rfi_status_id=' + encodeURIComponent(rfi_status_id);

	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString
	});
}
