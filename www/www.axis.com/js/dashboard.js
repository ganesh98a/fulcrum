/*ready function*/
$( document ).ready(function() {
	// To make the Dashboard Title without the project Name
	var userAcess=$('#userRole').val();
	//to hide the projects
	if(userAcess !='user')
	{
	// $('.selectedProject').hide();
	}
	//to make dashboard tab active
	$('#navBoxModuleGroup .categoryitems2').css('display','none');
	$('#navBoxModuleGroup .arrowlistmenu .menuheader').removeClass('openheader2');
	$('#navBoxModuleGroup .arrowlistmenu .openheader2').next('ul').css('display','block');
	var hreader_content = $("#currentlySelectedProjectName").val()+':Dashboard';
	$("#softwareModuleHeadline").html($hreader_content);

	closedRfis();  //Closed RFI
	closedsubmittal();  //Closed Submittals
	userclosedsubmittal();  //Closed Submittals for user
	userclosedRFI();  //Closed RFI for user
	



	Genrficount(); // To get rfi count for admin
	Gensubmittalcount(); // To get submittal count for admin
	GetCountChart();
	activecustomer('yearly','project');
	Gensubmittalusercount(); // To get submittal count for project manager
	rfimanagercount(); // To get RFI count for project manager
	projectmonthly('monthly','project');
	GetCountSlideProject();

	$('[data-toggle="tooltip"]').tooltip(); 

});
//Call the function on change the signup index rario button
$('input[name=signup]').change(function(){
	GetCountSlide();
});
//Call the function on change the project index rario button
$('input[name=project]').change(function(){
	GetCountSlideProject();
});
//Call the function on change the Chart rario button
$('input[name=dcrchart]').change(function(){
	GetCountChart();
});
/*call to RFI Function */
$('input[name=rfi_index]').change(function(){
	Genrficount();
});
/*call to Submittal Function */
$('input[name=submittal_index]').change(function(){
	Gensubmittalcount();
});
/*call to Submittal Function */
$('input[name=submittal_user]').change(function(){
	Gensubmittalusercount();
});
/*call to RFI Function for project manager*/
$('input[name=rfi_manager]').change(function(){
	rfimanagercount();
});
/*call to dashboard KPI*/
$('input[name=dashboardkpi]').change(function(){
	dashboardkpi();
});


/*call to closed RFI Function for Global Admin*/
$('input[name=rfi_closed]').change(function(){
	closedRfis();
});

/*call to closed Submittal Function for Global Admin*/
$('input[name=sub_closed]').change(function(){
	closedsubmittal();
});

/*call to closed Submittal Function for User*/
$('input[name=subuser_closed]').change(function(){
	userclosedsubmittal();
});
/*call to closed RFI Function for User*/
$('input[name=rfi_userclosed]').change(function(){
	userclosedRFI();
});




$('.DcrCheck').click(function ()
{
	var radio = $(this).find('input[type=radio]');
	if(radio.prop("checked") != true)
		radio.prop("checked", !radio.prop("checked"));
	GetCountChart();
});
$('.TopCheck').click(function ()
{
	var radio = $(this).find('input[type=radio]');
	if(radio.prop("checked") != true)
		radio.prop("checked", !radio.prop("checked"));
	dashboardkpi();
});

$('#task_summary_type').change(function(){

	var task_summary_type = $("#task_summary_type").val();	
	if(task_summary_type=='bs'){
		$('#tasksummary_filter_tr').hide();
	}else{
		$('#tasksummary_filter_tr').show();
	}
	var user_role = $("#userRole").val();
	var project_id = $("#currentlySelectedProjectId").val();
	var project_manager = $("#projManager").val();
	var user_id = $("#user_id").val();
	$.post('dashboard-ajax.php',{'method':'filter_task_summary','task_summary_type':task_summary_type,'user_role':user_role,'project_id':project_id,
			'project_manager':project_manager,'user_id':user_id},
		function(data){
			var obj = JSON.parse(data);
			$("#assigned_to").val('');
			if (task_summary_type != 'meetings') {
				$("#not_meeting").hide();
			}else{
				$("#not_meeting").show();
			}			
			$("#task_item").val('');
			$("#due_date").val('');
			$("#meeting_type").val('');
			$("#discussion").val('');
			$(".complete_date").attr('id','uncomplete');
			$(".complete_date").text('Show Completed Tasks');
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

//Method for Project Index
function projectmonthly(value,data)
{
	$.ajax({

		method:"POST",
		url	 :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data : {method:data,period:value},
		success:function(res)
		{
			var res=res.trim();
			if(value=="monthly")
			{
				$('.projectshow').show();
				$('.project_month').show();
				var monData=res.split('~');
				$('#pweek1').text(monData[0]);
				$('#pweek2').text(monData[1]);
				$('#pweek3').text(monData[2]);
				$('#pweek4').text(monData[3]);
				$('#pweek4').text(monData[4]);
				$('#ptab1').text('Week1');
				$('#ptab2').text('Week2');
				$('#ptab3').text('Week3');
				var i,count_month=0;
				for(i=0;i<=3;i++)
				{
					count_month=count_month+Number(monData[i]);
				}
				$('#project_data').html(count_month);
			}else if(value=="quarter")
			{
				$('.project_month').hide();
				$('.projectshow').show();

				var monData=res.split('~');
				$('#pweek1').text(monData[0]);
				$('#pweek2').text(monData[1]);
				$('#pweek3').text(monData[2]);
				$('#ptab1').text(monData[3]);
				$('#ptab2').text(monData[4]);
				$('#ptab3').text(monData[5]);

				var i,count_month=0;
				for(i=0;i<3;i++)
				{
					count_month=count_month+Number(monData[i]);
				}
				$('#project_data').html(count_month);
			}else if(value=="yearly")
			{
				$('.projectshow').hide();

				$('#project_data').html(res);
			}
		}
	});
	
}
//Method for customer Index - Active
function activecustomer(value,data)
{
	var type=$('#type_det').val();
	$.ajax({

		method:"POST",
		url	 :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data : {customer:data,period:value,type:type},
		success:function(res)
		{
			
			$('#DCRCharts').empty().html(res);
		}
	});

}
//To highlight customer index active and Dormant
function setCont(val)
{
	$('#type_det').val(val);
	var cust_val=$("input[name='proActive']:checked").val();
	if(val=='active')
	{
		$('#active').addClass('actgen');
		$('#dormant').removeClass('actgen');
		activecustomer(cust_val,'project');
	}else
	{
		$('#active').removeClass('actgen');
		$('#dormant').addClass('actgen');
		activecustomer(cust_val,'project');

	}
	
	
}
/*Function of get count slide*/
function GetCountSlide(){
	var signupvalue = $('input[name=signup]:checked').val();
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'SignUp',period:signupvalue},
		async : true,
		success:function(res)
		{	
			$('#SignupAdd').empty().html(res);
		}
	});
}
/*Function of get count slide*/
function GetCountSlideProject(){
	var signupvalue = $('input[name=project]:checked').val();
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ProjectAdmin',period:signupvalue},
		async : true,
		success:function(res)
		{	
			$('#ProjectAdd').empty().html(res);
		}
	});
}
// For open RFI KPI
function Genrficount()
{
	var signupvalue = $('input[name=rfi_index]:checked').val();
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'RFIAdmin',period:signupvalue},
		async : true,
		success:function(res)
		{	
			$('#rfiAdd').empty().html(res);
		}
	});
}
// For open Submittal KPI

function Gensubmittalcount()
{
	var signupvalue = $('input[name=submittal_index]:checked').val();
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'SubmittalAdmin',period:signupvalue},
		async : true,
		success:function(res)
		{	
			$('#submittalAdd').empty().html(res);
		}
	});
}

function Gensubmittalusercount()
{
	var signupvalue = $('input[name=submittal_user]:checked').val();
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'SubmittalUser',period:signupvalue},
		async : true,
		success:function(res)
		{	
			$('#submittaluser').empty().html(res);
		}
	});
}
// For open RFI KPI

function rfimanagercount()
{
	var signupvalue = $('input[name=rfi_manager]:checked').val();
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'RFIManager',period:signupvalue},
		async : true,
		success:function(res)
		{	
			$('#RFImanager').empty().html(res);
		}
	});
}


//Closed RFI
function closedRfis()
{
	var signupvalue = $('input[name=rfi_closed]:checked').val();
	/*Call the Ajax function*/
	var userAcess=$('#userRole').val();
	var methodValue = '';
	if(userAcess == 'Admin' || userAcess == 'admin'){
		methodValue = 'ClosedRFIAdmin';
	}else{
		methodValue = 'ClosedRFI';
	}
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:methodValue,period:signupvalue},
		async : true,
		success:function(res)
		{	
			$('#closedrfidata').empty().html(res);
			$('[data-toggle="tooltip"]').tooltip(); 
		}
	});
}


//Closed Submittal
function closedsubmittal()
{
	var signupvalue = $('input[name=sub_closed]:checked').val();
	/*Call the Ajax function*/
	var userAcess=$('#userRole').val();
	var methodValue = '';
	if(userAcess == 'Admin' || userAcess == 'admin'){
		methodValue = 'ClosedSubmittalAdmin';
	}else{
		methodValue = 'ClosedSubmittal';
	}
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:methodValue,period:signupvalue},
		async : true,
		success:function(res)
		{	
			$('#closedsubmittaldata').empty().html(res);
			$('[data-toggle="tooltip"]').tooltip(); 
		}
	});
}


//Closed Submittal for user
function userclosedsubmittal()
{
	var signupvalue = $('input[name=subuser_closed]:checked').val();
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ClosedUserSubmittal',period:signupvalue},
		async : true,
		success:function(res)
		{	
			$('#userclosedsubmittaldata').empty().html(res);
			$('[data-toggle="tooltip"]').tooltip(); 
		}
	});
}

//Closed RFI for user
function userclosedRFI()
{
	var signupvalue = $('input[name=rfi_userclosed]:checked').val();
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ClosedRFI',period:signupvalue},
		async : true,
		success:function(res)
		{	
			$('#closeduserrfidata').empty().html(res);
			$('[data-toggle="tooltip"]').tooltip(); 
		}
	});
}

/*Function of get count chart*/
function GetCountChart(){
	var dcrchart = $('input[name=dcrchart]:checked').val();
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'DCRChart',period:dcrchart},
		async : true,
		success:function(res)
		{	
			$('#DCRChartd').empty().html(res);
		}
	});
}
/*Viewall user model*/
function view_allUsers(){
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewUsers'},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";

		}
	});
	// window.location.href=window.ajaxUrlPrefix+"dashboard-userindex.php";
}

/*Viewall Submittal model*/
function view_allSubmittal(){
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewOpenSubmittal'},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			$('[data-toggle="tooltip"]').tooltip(); 
		}
	});
	// window.location.href=window.ajaxUrlPrefix+"dashboard-userindex.php";
}
//To get the open submittals for the projects
function load_openSubmital(val)
{
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'load_openSubmital',val:val},
		async : true,
		success:function(res)
		{	

			$('#submittalOpenItem_'+val).empty().append(res);
			$("body").addClass('noscroll');
			document.getElementById("submittalOpenItem_"+val).classList.toggle("show_cont");
			    // Close the dropdown if the user clicks outside of it
			    window.onclick = function(event) {
			    	if (!event.target.matches('.dropbtn_'+val)) {

			    		var dropdowns = document.getElementsByClassName("dropdown-content");
			    		var i;
			    		for (i = 0; i < dropdowns.length; i++) {
			    			var openDropdown = dropdowns[i];
			    			if (openDropdown.classList.contains('show_cont')) {
			    				openDropdown.classList.remove('show_cont');
			    			}
			    		}
			    		$("modal-body").css('noscroll');
			    	}
			    }

			}
		});
}

/*Viewall RFI model*/
function view_allRFI(){
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewOpenRFI'},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
}

/*Viewall user RFI model*/
function view_userRFI(){
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewUserOpenRFI'},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			$('[data-toggle="tooltip"]').tooltip(); 


		}
	});
}

/*Viewall user Submittal  model*/
function view_userSubmittal(){
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewUserOpensubmittal'},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			$('[data-toggle="tooltip"]').tooltip(); 
		}
	});
}

/*Viewall Closed Submittal model*/
function view_allclosedSubmittal(){
	var period = $('input[name=sub_closed]:checked').val();
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewClosedSubmittal',period:period},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
}


/*Viewall Closed Submittal model*/
function view_allclosedUserSubmittal(){
	var period = $('input[name=subuser_closed]:checked').val();
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewClosedSubmittal',period:period},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
}
/*Viewall Closed RFI model*/
function view_allclosedRFI(){
	var period = $('input[name=rfi_closed]:checked').val();
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewClosedRFI',period:period},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
}
/*Viewall Closed RFI for user*/
function view_alluserclosedRFI (){
	var period = $('input[name=rfi_userclosed]:checked').val();
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewClosedRFI',period:period},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
}
//To get the open RFI for the projects
function load_openRFI(val)
{
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'load_openRFI',val:val},
		async : true,
		success:function(res)
		{	

			$('#rfiOpenItem_'+val).empty().append(res);
			$("body").addClass('noscroll');
			document.getElementById("rfiOpenItem_"+val).classList.toggle("show_cont");
			    // Close the dropdown if the user clicks outside of it
			    window.onclick = function(event) {
			    	if (!event.target.matches('.dropbtn_'+val)) {

			    		var dropdowns = document.getElementsByClassName("dropdown-content");
			    		var i;
			    		for (i = 0; i < dropdowns.length; i++) {
			    			var openDropdown = dropdowns[i];
			    			if (openDropdown.classList.contains('show_cont')) {
			    				openDropdown.classList.remove('show_cont');
			    			}
			    		}
			    		$("modal-body").css('noscroll');
			    	}
			    }

			}
		});
}


//To get the users data
function load_user(val)
{
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'loaduser',val:val},
		async : true,
		success:function(res)
		{	
			
			$('#pop_data').empty().append(res);
			$('#comp_'+val).attr('data-original-title',res);	
			$('#comp_'+val).attr('data-placement','bottom');	
			$('#comp_'+val).tooltip({
				container : 'body',
				html: true
			});
			$('#comp_'+val).tooltip('show');
			$('#comp_'+val).mouseleave(function(){
				$('#comp_'+val).removeAttr('data-original-title');
			});
			
		}
	});
}
//Method to load Admin Users
function view_adminUsers()
{
	var modal = document.getElementById('ViewUser');
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewadminUsers'},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";

		}
	});
}
// When the user clicks on <span> (x), close the modal
function dashboardmodalClose() {
	var modal = document.getElementById('ViewUser');
	modal.style.display = "none";
	$("body").removeClass('noscroll');
}
// When the user clicks anywhere outside of the modal, close it
var modal = document.getElementById('ViewUser');
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}

//For global_admin separating the KPI
function dashboardkpi()
{
	var signupvalue = $('input[name=dashboardkpi]:checked').val();
	if(signupvalue=='operational')
	{
		$('.operate').show();
		$('.busines').hide();
		$('.tasksummary').hide();
	}
	else if(signupvalue=='business')
	{
		$('.busines').show();	
		$('.operate').hide();
		$('.tasksummary').hide();		
	}
	else if(signupvalue=='tasksummary')
	{
		$('.busines').hide();	
		$('.operate').hide();
		$('.tasksummary').show();		
	}
}

/*Viewall Submittal model*/
function viewOpenSubmittalAdmin(){
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewOpenSubmittalAdmin'},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
}

/*Viewall RFI model*/
function viewOpenRfiAdmin(){
	var modal = document.getElementById('ViewUser');
	/*Call the Ajax function*/
	$.ajax({			
		method: "POST",
		url	  :  window.ajaxUrlPrefix+"dashboard-ajax.php",
		data  : {method:'ViewOpenRfiAdmin'},
		async : true,
		success:function(res)
		{	
			$('#ViewUser').empty().html(res);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
	// window.location.href=window.ajaxUrlPrefix+"dashboard-userindex.php";
}
