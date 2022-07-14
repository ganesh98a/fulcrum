/*
Report Module Function
In this module have to show the records against selected report type 
It's have the feature to export the recored as
	* PDF
	* XLSX
	* HTML (Only show in browser)
PDF, we are using DOMPDF plugin for export the records with .PDF extension
	*It's have the details of
		Company
		project
		Date
		AND Their Logo if uploaded
	*In bottom of the PDF have footer on each page for show the page no and generated date & time.
	*This PDF has generated as landscape mode
XLSX, We have using PHPExcel 2007 plugin for export the records with .XLSX extension
	*This is for user's convinience
	*The records have stored with formatting.
Both type have displied or generated with Helvatica font
*/
var project_id=$('#project_id').val();
/*Call ajax report call function to fetch the content on load page */
$(document).ready(function() {
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
	$(".dcrdatepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 , maxDate:0});
	/*Filterdate(project_id);*/
	$( "#ddl_report_id" ).change(SelectedReportChange);
	$("#view_status").change(SelectedReportChange);
	SelectedReportChange();
	$( "#vendor_id" ).change(loadSelectedReportCompany);
	setTimeout(function(){
		GenerateReport(project_id,'1');
	},1000);
		$(".envelop").css('display','none');

});
// To hide the datepicker After selection
function hidedate()
{
	$("#ui-datepicker-div").hide();
}
function triggerdateCalendar(){
	$("#ui-datepicker-div").show();
}
/*Bidder List script*/
function Purchasing_Subcontractor_Bid_List_Report__updateBidderListReport(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		//options.responseDataType = 'json';

		var theStatus = $("#ddlStatus").val();
		if (theStatus == null) {
			theStatus = '';
		}

		var theSortBy = $("#ddlSortBy").val();
		if (theSortBy == null) {
			theSortBy = '';
		}
		var projectId = $("#project_id").val().trim();
		var projectName =$('#projectName').val();
		var ajaxHandler = window.ajaxUrlPrefix + 'module-report-function.php';
		var ajaxQueryString =
		'responseDataType=json' +
		'&sbs=' + encodeURIComponent(theStatus) +
		'&sbo=' + encodeURIComponent(theSortBy)+
		'&ReportType=Bidder List'+
		'&date='+ MMDDYYYY(new Date())+ 
		'&date1='+ MMDDYYYY(new Date())+
		'&report_view=Bidder List'+
		"&projectName="+projectName+
		"&project_id="+projectId
		;
		var ReportType=$('#ddl_report_id').val();
		var Reportoption=$("input[name='ReportOption']:checked").val();
		var ajaxUrl = ajaxHandler;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}
		/*Ajax call*/
		var methodType = 'POST';
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			type: methodType,
			success: function(data, textStatus, jqXHR){
				$('#Delays_html').empty().html(data);
				genratePDF(Reportoption,ReportType,ajaxQueryString);
			},
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

//To Genarate the report
function GenerateReport(projectId)
{
	var type = $('#ddl_report_id').val();
	var explode = type.split(',');
	/*report type name*/
	var ReportType=explode[0];
	var value = explode[0];
	/*select date type*/
	var datetype = explode[1];
	/*export pdf permission -Y || N */
	var pdf = explode[2];
	/*export xlsx permission - Y || N*/
	var xlsx = explode[3];
	var ReportText=$("#ddl_report_id option:selected").text();
	var Reportoption=$("input[name='ReportOption']:checked").val();
	var date=$('#date').val();
	var bdate=$('#bdate').val();
	var edate=$('#edate').val();
	var projectName=$('#projectName').val();
	var dateerr='';
	var reallocationDrawId = $('#reallocationDrawId').val();
	var reallocationStatus = $('#cost_code_alias').prop('checked');
	var typeoferr = false;
	var despco = $('#despco').prop('checked');
	var showreject = $('#showChangeOrderReject').prop('checked');
	var showCodeCodeAmt = $('#showChangeOrderCostCodeAmount').prop('checked');

	if(ReportType =="Change Order"){
		var view_option =  $("#view_status").val();
	}
	if(datetype == 'Project' || datetype == 'Custom' || datetype == 'Filter'){
		typeoferr = true;
	}

	if(ReportType=="Bidder List"){
		$(".envelop").css('display','block');
		getEmailbasedonselection();
		Purchasing_Subcontractor_Bid_List_Report__updateBidderListReport();
		return false;
	}
	if(ReportType=="Meetings - Tasks"){
		loadMeetingDetails();
		return false;
	}
	if(ReportType == "Current Budget"){
		loadCurrentBudgetReport();
		return false;
	}
	if(ReportType == "Vector Report"){
		loadVectorReport();
		return false;
	}
	if(ReportType=="SCO"){
		loadSCODetails();
		return false;
	}
	if(ReportType == ''){		
		$('#ddl_report_id').addClass('redBorderThick');
		dateerr =true;
	}
	if(date==''){
		$('#date').addClass('redBorderThick');
		dateerr =true;
	}
	if (reallocationDrawId=='' && ReportType=="Reallocation") {		
		$('#reallocationDrawId').addClass('redBorderThick');
		dateerr =true;
	}
	if(bdate==''){
		$('#bdate').addClass('redBorderThick');
		dateerr =true;
	}
	if(edate=='' && typeoferr == true){
		$('#edate').addClass('redBorderThick');
		dateerr =true;
	}
	if(ReportType=="Manpower summary" || ReportType=="Contact List" || ReportType=="Sub List" || ReportType=="Current Budget" || ReportType=="Prelim Report"){
		var value_check=0;
	}else{
		var value_check=1;
	}
	var vendor_id = $("#vendor_id").val();
	var qb_customer = $("#qb_customer").val();
	var cc_id = $("#cc_id").val();
	var vendor = $("#vendor_id :selected").text();
	var theCot = $("#cotype").val();
	if(theCot!='' && theCot!=null){
		theCot = theCot.join();
	}
	if (theCot == null) {
		theCot = '';
	}
	if(ReportType && ReportType.startsWith('Submittal')){
		theCot = $("#submittalStatus").val();
		if(theCot!='' && theCot!=null){
			theCot = theCot.join();
		}
	}
	if(ReportType && ReportType.startsWith('RFI Report') && ReportType != 'RFI Report - QA - Open'){
		theCot = $("#requestForInformationStatus").val();
	}
	if(ReportType == 'Project Delay Log'){
		theCot = $("#DelayStatuses").val();
	}
	if (ReportType=="Reallocation") {		
		theCot = reallocationDrawId;
		despco = reallocationStatus;
	}

	if (ReportType=="Subcontract Invoice") {		
		theCot = $("#subcontractinvoicestatus").val();
	}

	if(ReportType =="Buyout Log"){
	 	var theCot = $("#buyoutlog_sub_amt").prop('checked');
	 	var despco = $("#buyoutlog_cc_alias").prop('checked');
	}

	if(ReportType =="Buyout Summary"){
	 	var theCot = $("#buyoutSum_cc_alias").prop('checked');
	}

	$( "#ddl_report_id" ).change(function() {
		$("#ddl_report_id").removeClass('redBorderThick');		
	});
	$( "#date" ).change(function() {
		$("#date").removeClass('redBorderThick');		
	});
	$( "#bdate" ).change(function() {
		$("#bdate").removeClass('redBorderThick');		
	});
	$( "#edate" ).change(function() {
		$("#edate").removeClass('redBorderThick');		
	});
	$('#reallocationDrawId').change(function() {
		$("#reallocationDrawId").removeClass('redBorderThick');		
	});
	if(dateerr && value_check!=0)
	{
		messageAlert('Please fill in the highlighted areas .', 'errorMessage');
	}
	else 
	{
		if(bdate == 'NA')
			bdate="00/00/0000";
		$('#ddl_report_id').removeClass('redBorderThick');
		$('#bdate').removeClass('redBorderThick');
		$("#reallocationDrawId").removeClass('redBorderThick');	
		$('#edate').removeClass('redBorderThick');
		$('#errMessage').html('');
		$.ajax({
			type : "post",
			url	 :  window.ajaxUrlPrefix+"module-report-function.php",
			data : {
				method:'delays',
				projectId:projectId,
				ReportType:ReportType,
				date:bdate,
				report_view:ReportType,
				date1:edate,
				cot:theCot,
				codesp:despco,
				coshowreject:showreject,
				dateDCR: date,
				coshowcostcode:showCodeCodeAmt,
				view_option:view_option,
				vendor_id:vendor_id,
				vendor:vendor,
				cc_id:cc_id,
			},
			cache :false,
			async : true,
			success :function(html)
			{
				 var res= html.split('~');
				$('#Delays_html').empty().html(res[0]);
				$(".dealy-grid").dataTable({
					
					drawCallback: function () {
						$('[data-toggle="tooltip"]').tooltip(); 
						$('[data-toggle="tooltip"]').hover(function(){
							$('.tooltip-inner').css('width', 'auto');
							$('.tooltip-inner').css('max-width', '250px');
						}); 
					}
				});
				var formValues="report_view="+ReportType+"&date="+bdate+"&project_id="+projectId+"&permission=1"+"&projectName="+projectName+"&date1="+edate+"&cot="+theCot+"&codesp="+despco+"&coshowreject="+showreject+"&dateDCR="+date+"&coshowcostcode="+showCodeCodeAmt+"&view_option="+view_option+"&vendor_id="+vendor_id+"&vendor="+vendor+"&cc_id="+cc_id;
				if(ReportType=="Contact List")
				{
					$(".envelop").css('display','block');
					getEmailbasedonselection();
				}
				if(ReportType=="Subcontractor Audit List")
				{
					
					getQBreport(vendor,qb_customer,res[1]);
				}
				genratePDF(Reportoption,ReportType,formValues);
			}
		});
	}
}

$('input#generalco').on('change', function() {
	 $('input#groupco').prop('checked', true); 
});
$('input#groupco').on('change', function() {
	var groupco = $('#groupco').prop('checked');
	if(!groupco){
		$('input#generalco').prop('checked', false);  
	}
});

function loadCurrentBudgetReport(){
	// Check the Group Division set.
	var ReportType=$('#ddl_report_id').val();
	/*report type name*/
	var explode = ReportType.split(',');
	var ReportType=explode[0];
	var Reportoption=$("input[name='ReportOption']:checked").val();
	var projectName =$('#projectName').val();
	var projectId = $("#currentlySelectedProjectId").val();
	var crntNotes = $('#crntBgtNotes').prop('checked');
	var crntSubtotal = $('#crntBgt_sub_total').prop('checked');
	var crntBgt_val_only = $('#crntBgt_val_only').prop('checked');
	var costCodeAlias = $('#crntBgt_cc_alias').prop('checked');

	
	var ajaxQueryString =
	'responseDataType=json' +
	'&ReportType='+ReportType+
	'&report_view='+ReportType+
	"&projectName="+projectName+
	"&project_id="+projectId+
	"&crntNotes="+crntNotes+
	"&crntBgt_val_only="+crntBgt_val_only+
	"&crntSubtotal="+crntSubtotal+
	"&costCodeAlias="+costCodeAlias;
	$.post(
		window.ajaxUrlPrefix+"module-report-function.php",
		{"ReportType":"Current Budget","crntBgt_val_only":crntBgt_val_only,"crntNotes":crntNotes,"crntSubtotal":crntSubtotal,"costCodeAlias":costCodeAlias},
		function(data){
			if($.trim(data) == 'groupdivnotmap'){
				messageAlert('Please group all the divisions in the Master Cost Codes list in Budget.', 'errorMessage');
				$('#Delays_html').empty().html('');
			}else{
				$('#Delays_html').empty().html(data);
				genratePDF(Reportoption,ReportType,ajaxQueryString);
			}
	});
}

function loadVectorReport(){
	// Check the Group Division set.
	var ReportType=$('#ddl_report_id').val();
	/*report type name*/
	var explode = ReportType.split(',');
	var ReportType=explode[0];
	var Reportoption=$("input[name='ReportOption']:checked").val();
	var projectName =$('#projectName').val();
	var projectId = $("#currentlySelectedProjectId").val();
	var grouprowval = $('#grouprowval').prop('checked');
	var groupco = $('#groupco').prop('checked');
	var generalco = $('#generalco').prop('checked');
	var inotes = $('#inotes').prop('checked');
	var subtotal = $('#vector_sub_total').prop('checked');
	var costCodeAlias = $('#vector_cc_alias').prop('checked');

	
	var ajaxQueryString =
	'responseDataType=json' +
	'&ReportType='+ReportType+
	'&report_view='+ReportType+
	"&projectName="+projectName+
	"&project_id="+projectId+
	"&grouprowval="+grouprowval+
	"&groupco="+groupco+
	"&generalco="+generalco+
	"&inotes="+inotes+
	"&subtotal="+subtotal+
	"&costCodeAlias="+costCodeAlias;
	$.post(
		window.ajaxUrlPrefix+"module-report-function.php",
		{"ReportType":"Vector Report","grouprowval":grouprowval,"groupco":groupco,"generalco":generalco,"inotes":inotes,"subtotal":subtotal,"costCodeAlias":costCodeAlias},
		function(data){
			if($.trim(data) == 'groupdivnotmap'){
				messageAlert('Please group all the divisions in the Master Cost Codes list in Budget.', 'errorMessage');
				$('#Delays_html').empty().html('');
			}else{
				$('#Delays_html').empty().html(data);
				genratePDF(Reportoption,ReportType,ajaxQueryString);
			}
	});


}
/*PDF Generation*/
function genratePDF(Reportoption,ReportType,formValues){
	if(Reportoption=="PDF")
	{
			var pathname = window.location.host; // Returns path only
			var http= window.location.protocol+'//';
			var include_path='/';
			var full_path=http+pathname+include_path;
			var date=new Date();
			var linktogenerate=full_path+'download-report.php?'+formValues;
			// var importantStuff = window.open(full_path+'download-report.php?'+formValues,'_blank');
			// importantStuff.document.write('Loading preview...');
			// importantStuff.location.href = linktogenerate;
			/*alert(linktogenerate);
			return false;*/
			document.location = linktogenerate;

			// window.open(full_path+'download-report.php?'+formValues,'_blank');

		}else if(Reportoption=="CSV"){
			var pathname = window.location.host; // Returns path only
			var http= window.location.protocol+'//';
			var include_path='/';
			var full_path=http+pathname+include_path;
			var date=new Date();
			var linktogenerate=full_path+'download-csv.php?'+formValues;
			document.location = linktogenerate;
		}else if(Reportoption=="XLSX"){
			var pathname = window.location.host; // Returns path only
			var http= window.location.protocol+'//';
			var include_path='/';
			var full_path=http+pathname+include_path;
			var date=new Date();
			var linktogenerate=full_path+'download-xlsx.php?'+formValues;
			document.location = linktogenerate;
		}
	}
	/*Seltect report type change*/
	var SelectedReportChange = function(){
		$('#bdate').removeClass('redBorderThick');
		$('#edate').removeClass('redBorderThick');
		$("#reallocationDrawId").removeClass('redBorderThick');	
		$("#reallocationDrawId").val('');
		$('#report_name').val('');
		$('#Delays_html').empty();
		$('#bdate').removeAttr('placeholder');
		$('#edate').removeAttr('placeholder');
		/*check the radio button default html*/
		$("input[name=ReportOption][value=Html]").prop('checked', true);
		$(".envelop").css('display','none');

		var type = $('#ddl_report_id').val();
		var cotype = $('#view_status').val();
		var explode = type.split(',');
		/*report type name*/
		var value = explode[0];
		/*select date type*/
		var datetype = explode[1];
		/*export pdf permission -Y || N */
		var pdf = explode[2];
		/*export xlsx permission - Y || N*/
		var xlsx = explode[3];
		var i=0;

		
    if(value=="Subcontractor Audit List"){
			$('.costcode').css('display','block');
			$('.subcontractor').css('display','block');
			$('.commonDate').css('display','none');
			$('.particularDate').css('display','none');			
			$('.fs-option').removeClass('selected');
			$('.multiple').addClass('fs-default');
			$('.fs-label').empty().html('Select Options');
			$('#ddlSortBy').val('');
			$('#ddlStatus').val('');
		}else{
			$('.costcode').css('display','none');
			$('.subcontractor').css('display','none');
		}
		if(value=="Reallocation"){
			$('.reallocation').css('display','block');
			$('#cost_code_alias').prop('checked', false);
		}else{
			$('.reallocation').css('display','none');
		}
		/*PDF radio button enable*/
		if(pdf == 'Y'){
			$('.hidden_pdfradio').css('display','block');
		}
		else{
			$('.hidden_pdfradio').css('display','none');	
		}
		/*csv radio button enable*/
		if(xlsx == 'Y'){
			$('.hidden_xlsxradio').css('display','block');
		}
		else{
			$('.hidden_xlsxradio').css('display','none');	
		}

		if(value == 'Buyout Log'){
			$('.BuyoutLogchk').css('display','block');
			$('#buyoutlog_sub_amt').prop('checked', false);
			$('#buyoutlog_cc_alias').prop('checked', false);
		}else{
			$('.BuyoutLogchk').css('display','none');
		}

		if(value == 'Buyout Summary'){
			$('.BuyoutSummarychk').css('display','block');
			$('#buyoutSum_cc_alias').prop('checked', false);
		}else{
			$('.BuyoutSummarychk').css('display','none');
		}

		if(value=="Change Order"){
			$('.table_report').css('min-width','132%');
			$('.co_rt').css('display','block');
			$('.changechk').css('display','block');
			$('#despco').prop('checked', false);
			$('#showChangeOrderReject').prop('checked', false);
			$('#showChangeOrderCostCodeAmount').prop('checked', false);
			if(cotype =="subcontractor")
			{
				$("#showChangeOrderCost").hide();
				$('#showChangeOrderCostCodeAmount').prop('checked', false);
			}else{
				$("#showChangeOrderCost").show();
			}
			
		}else{
			$('.table_report').css('min-width','110%');
			$('.co_rt').css('display','none');
			$('.changechk').css('display','none');
		}
		if(value && value.startsWith("RFI Report") && value != 'RFI Report - QA - Open'){
			$('.requestForInformationStatuslist').css('display','block');
		}else{
			$('.requestForInformationStatuslist').css('display','none');
		}

		if(value && value.startsWith("Submittal")){
			$('.submittalStatuslist').css('display','block');
			$('.fs-option').removeClass('selected');
			$('.multiple').addClass('fs-default');
			$('.fs-label').empty().html('Select Options');
		}else{
			$('.submittalStatuslist').css('display','none');
		}

		if(value =="Project Delay Log"){
			$('.delayStatuslist').css('display','block');
		}else{
			$('.delayStatuslist').css('display','none');
		}
		if(value =="Subcontract Invoice"){
			$('.subcontract_inv').css('display','block');
		}else{
			$('.subcontract_inv').css('display','none');
		}
		if (value =="Current Budget") {
			$('.crntBgtChkGrp').css('display','block');
			$('#crntBgtNotes').prop('checked', false);
			$('#crntBgt_val_only').prop('checked', true);
			$('#crntBgt_sub_total').prop('checked', false);
			$('#crntBgt_cc_alias').prop('checked',false);
		}else{
			$('.crntBgtChkGrp').css('display','none');
		}

		if(value=="Vector Report"){
			$('.changechkgrp').css('display','block');
			$('#grouprowval').prop('checked', true);
			$('#groupco').prop('checked', true);
			$('#generalco').prop('checked', true);
			$('#inotes').prop('checked', false);
			$('#vector_sub_total').prop('checked', false);
			$('#vector_cc_alias').prop('checked', false);
		}else{
			$('.changechkgrp').css('display','none');
		}
		if(value=="Meetings - Tasks"){
			$('.MT_rt').css('display','block');
		}else{
			$('.MT_rt').css('display','none');
		}
		if(value=="SCO"){
			$('.SCO_rt').css('display','block');
			$('.SCOchk').css('display','block');
			
		}
		else
		{
			$('.SCO_rt').css('display','none');
			$('.SCOchk').css('display','none');
		}
		
		if(value=="Bidder List"){
			$('.bidlist').css('display','block');
			$('.commonDate').css('display','none');
			$('.particularDate').css('display','none');			
			$('.fs-option').removeClass('selected');
			$('.multiple').addClass('fs-default');
			$('.fs-label').empty().html('Select Options');
			$('#ddlSortBy').val('');
			$('#ddlStatus').val('');
		}else
		{
			if(datetype!="None")
				$('.commonDate').css('display','block');
			$('.particularDate').css('display','none');
			$('.bidlist').css('display','none');
			
		}
		/*
		Date Picker types
		Week type
		Month type
		Custom type (Any date selection)
		Project (start and till date of the project).
		None (hide the datepicker option for select another type)
		*/
		if(datetype=="Week"){
			$('#edate').attr('disabled',true);
			$('.datedivseccal_icon_gk1').attr('disabled',true);
			$('#bdate').val('');
			$('#edate').val('');
			$('#bdate').after('<input type="text" value="" class="bcus_date cus_date_report">');
			$('#bdate').remove();
			$('.bcus_date').attr('id','bdate');
			$('#bdate').attr('placeholder','Pick a Date');
        // datepicker
        $('#bdate').datepicker({
        	changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 ,
        	beforeShowDay: function(_date) {
        		var checkid=$('#report_name').val();
        		if(checkid==''){
        			setTimeout(function() {
        				$('.select-week').attr('class','');
        			},100);
        		}
        		if ($.inArray(_date.getTime(), Weekpicker._dates) >= 0) 
        			return [true, "highlighted-week select-week", "Week Range"];
        		return [true, "", ""];
        	},
        	onSelect: function(_selectedDate) {
        		var _date = new Date(_selectedDate);
        		Weekpicker._dates = Weekpicker(_date,_date.getDay());
        		$('#report_name').val(value);
        	},
        	onClose: function(selectedDate) {
        		$('.select-week').children(':first').addClass('ui-state-act');

        	}
        });
        i=1;
    }else if(datetype=="Month"){
    	$('#edate').attr('disabled',true);
    	$('.datedivseccal_icon_gk1').attr('disabled',true);
    	$('#bdate').val('');
    	$('#edate').val('');
    	$('#bdate').after('<input type="text" value="" class="bcus_date cus_date_report">');
    	$('#bdate').remove();
    	$('.bcus_date').attr('id','bdate');
    	$('#bdate').attr('placeholder','Pick a Date');
        // datepicker
        $('#bdate').datepicker({
        	changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 ,
        	beforeShowDay: function(_date) {
        		var checkid=$('#report_name').val();
        		if(checkid==''){
        			setTimeout(function() {
        				$('.select-week').attr('class','');
        			},100);
        		}
        		if ($.inArray(_date.getTime(), Monthpicker._dates) >= 0) 
        			return [true, "highlighted-week select-week", "Month Range"];
        		return [true, "", ""];
        	},
        	onSelect: function(_selectedDate) {
        		var _date = new Date(_selectedDate);
        		Monthpicker._dates = Monthpicker(_date);
        		$('#report_name').val(value);
        	},
        	onClose: function(selectedDate) {
        		$('.select-week').children(':first').addClass('ui-state-act');

        	}
        });
        i=1;
    }else if(datetype=="None")
    {
    	$('.datepicker_style_custom').hide();
    	$('.commonDate').css('display','none');

    }else if(datetype=="Project"){
    	/*$('#edate').attr('disabled','disabled');
    	$('#bdate').attr('disabled','disabled');
    	$('.datedivseccal_icon_gk1').attr('disabled',true);
    	$('.datedivseccal_icon_gk').attr('disabled',true);*/
    	$('#bdate').val($('#projectcreateddate').val());
    	$('#edate').val($('#tilldate').val());
    	$('#bdate').attr('placeholder','Pick a Date');
    	$('#edate').attr('placeholder','Pick a Date');
    	$('.datedivseccal_icon_gk1').removeAttr('disabled','disabled');
    	$('.datedivseccal_icon_gk').removeAttr('disabled','disabled');
    	$('#edate').removeAttr('disabled','disabled');
    	$('#bdate').removeAttr('disabled','disabled');
    	i=1;
    }
    else if(datetype=="Filter"){
    	if(($('#delayFirstProject').val())!=''){
    		$('#bdate').val($('#delayFirstProject').val());
    	}
    	else{
    		$('#bdate').val($('#tilldate').val());
    	}
    	$('#edate').val($('#tilldate').val());
    	$('#bdate').attr('placeholder','Pick a Date');
    	$('#edate').attr('placeholder','Pick a Date');
    	$('.datedivseccal_icon_gk1').removeAttr('disabled','disabled');
    	$('.datedivseccal_icon_gk').removeAttr('disabled','disabled');
    	$('#edate').removeAttr('disabled','disabled');
    	$('#bdate').removeAttr('disabled','disabled');
    	i=1;    	
    }else if(datetype == "Custom"){
    	$('.datedivseccal_icon_gk1').removeAttr('disabled','disabled');
    	$('.datedivseccal_icon_gk').removeAttr('disabled','disabled');
    	$('#edate').removeAttr('disabled','disabled');
    	$('#bdate').removeAttr('disabled','disabled');
    	$('#edate').val('');

    	$('#bdate').after('<input type="text" value="" class="bcus_date cus_date_report">');
    	$('#bdate').remove();
    	$('.bcus_date').attr('id','bdate')
    	$("#bdate").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
    	$('#edate').removeAttr('disabled','disabled');
    	$('#bdate').val(MMDDYYYY(new Date()));
    	$('#edate').val(MMDDYYYY(new Date()));
    	$('#bdate').attr('placeholder','Pick a Date');
    	$('#edate').attr('placeholder','Pick a Date');
    	i=1;

    } else if (datetype == "Particular Date") {
    	$('.particularDate').show();
    	$('.datepicker_style_particular').show();
    	$('.datepicker_style_custom').hide();
    	$('.commonDate').hide();
    }
    if(i=='1')
    {

    	$('.datepicker_style_custom').show();
    	$('.commonDate').css('display','block');
    	$("#bdate").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });

    }


};
/*Weekly datepicker date selection*/
var Weekpicker = function(_selectedDate,count) {
	var week = new Array();
	var today=new Date($("#bdate").val());
	var countDay=count;
	if(countDay==0){
		var mondayOfWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay()-6);
		var sundayOfWeek = new Date(mondayOfWeek.getFullYear(), mondayOfWeek.getMonth(), mondayOfWeek.getDate() - mondayOfWeek.getDay()+7);
	}else{
		var mondayOfWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay()+1);
		var sundayOfWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay()+7);
	}
	for (i = 0; i < 7; i++) {
		var tempDate = new Date(mondayOfWeek.getTime());
		tempDate.setDate(tempDate.getDate() + i);
		week.push(tempDate.getTime());
	}
	$('#bdate').val(MMDDYYYY(mondayOfWeek));
	$('#edate').val(MMDDYYYY(sundayOfWeek));

	return week;
};
/*Monthly datepicker selection date*/
var Monthpicker = function(_selectedDate) {
	var montharray = new Array();
	var today=new Date($("#bdate").val());
	var date = today, year = date.getFullYear(), month = date.getMonth();
	var days=new Date(date.getFullYear(), date.getMonth()+1, 0).getDate();
	var firstDay = new Date(year, month, 1);
	var lastDay = new Date(year, month + 1, 0);
	for (i = 0; i < days; i++) {
		var tempDate = new Date(firstDay.getTime());
		tempDate.setDate(tempDate.getDate() + i);
		montharray.push(tempDate.getTime());
	}
	$('#bdate').val(MMDDYYYY(firstDay));
	$('#edate').val(MMDDYYYY(lastDay));
	return montharray;
};
function DateFromString(str){ 
	str = str.split(/\D+/);
	str = new Date(str[2],str[0]-1,(parseInt(str[1])+6));
	return MMDDYYYY(str);

}
/*change the date format*/    
function MMDDYYYY(str) {
	var ndateArr = str.toString().split(' ');
	var Months = 'Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec';
	var monvalu=(Months.indexOf(ndateArr[1])/4)+1;
	monvalu=monvalu.toString();
	if(monvalu.length == 1)
		monvalu='0'+monvalu;
	return monvalu+'/'+ndateArr[2]+'/'+ndateArr[3];
}

function Add7Days() {
	var date = $('#bdate').val();
	var ndate = DateFromString(date);
	return ndate;
}
$('.datedivseccal_icon_gk').click(function(){
	$('#bdate').focus();
});
$('.datedivseccal_icon_gk1').click(function(){
	$('#edate').focus();
});
$( "#ddl_meeting_type_id" ).change(function() {
	$("#ddl_meeting_type_id").removeClass('redBorderThick');		
});
$( "#ddl_meeting_id" ).change(function() {
	$("#ddl_meeting_id").removeClass('redBorderThick');		
});
/*Meeting type report*/
function loadMeetingsByMeetingTypeId(options)
{
	try {

		var options = options || {};
		var promiseChain = options.promiseChain;

		var meeting_type_id = $("#ddl_meeting_type_id").val();
		var projectId = $("#project_id").val().trim();
		meeting_type_id = $.trim(meeting_type_id);

		$("#divMeetingDetails").html('');
		$("#discussionList").html('');
		if (meeting_type_id == '-2') {
			return;
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-collaboration-manager-ajax.php?method=loadMeetingsByMeetingTypeId';
		var ajaxQueryString =
		'pID='+encodeURIComponent(projectId)+'&meeting_type_id=' + encodeURIComponent(meeting_type_id);
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
		UrlVars.set('pID', encodeURIComponent(btoa(projectId)));
		UrlVars.set('meeting_type_id', meeting_type_id);

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
/*load meeting data's*/
function loadMeetingDetails()
{
	
	var meeting_type_id = $("#ddl_meeting_type_id").val();
	meeting_type_id = $.trim(meeting_type_id);
	var meeting_id = $("#ddl_meeting_id").val();
	meeting_id = $.trim(meeting_id);
	var ReportType=$('#ddl_report_id').val();
	var explode = ReportType.split(',');
	/*report type name*/
	var ReportType=explode[0];
	var value = explode[0];
	/*select date type*/
	var datetype = explode[1];
	/*export pdf permission -Y || N */
	var pdf = explode[2];
	/*export xlsx permission - Y || N*/
	var xlsx = explode[3];
	var projectId = $("#currentlySelectedProjectId").val();
	var projectName =$('#projectName').val();
	var ajaxHandler = window.ajaxUrlPrefix + 'module-report-function.php';
	var ajaxQueryString =
	'responseDataType=json' +
	'&ReportType='+ReportType+
	'&date='+ MMDDYYYY(new Date())+ 
	'&date1='+ MMDDYYYY(new Date())+
	'&report_view='+ReportType+
	"&projectName="+projectName+
	"&project_id="+projectId+
	"&meeting_type_id="+meeting_type_id+
	"&meeting_id="+meeting_id
	;
	var Reportoption=$("input[name='ReportOption']:checked").val();
	var ajaxUrl = ajaxHandler;
	var err = false;
	if(meeting_type_id=='')
	{		
		$('#ddl_meeting_type_id').addClass('redBorderThick');
		err =true;
	}
	if(meeting_id=='')
	{		
		$('#ddl_meeting_id').addClass('redBorderThick');
		err =true;
	}
	if(err)
	{
		messageAlert('Please fill in the highlighted areas .', 'errorMessage');
	}
	else{
		/*Ajax call*/
		var methodType = 'POST';
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			type: methodType,
			success: function(data, textStatus, jqXHR){
				$('#Delays_html').empty().html(data);
				genratePDF(Reportoption,ReportType,ajaxQueryString);
			},
			error: errorHandler
		});
	}
}

/*load SCO data's*/
function loadSCODetails()
{

	var ReportType=$('#ddl_report_id').val();
	var explode = ReportType.split(',');
	/*report type name*/
	var ReportType=explode[0];
	var value = explode[0];
	/*select date type*/
	var datetype = explode[1];
	
	var view_option = $("#sview_status").val();
	var filteropt = $("#sco_filter").val();
	var inc_pot = $("#in_potential").prop("checked"); 
	var ch_potential;
	if(inc_pot)
	{
		ch_potential ="Y";
	}else
	{
      		ch_potential ="N";
	}

	
	var projectId = $("#currentlySelectedProjectId").val();
	var projectName =$('#projectName').val();
	var ajaxHandler = window.ajaxUrlPrefix + 'module-report-function.php';
	var ajaxQueryString =
	'responseDataType=json' +
	'&ReportType='+ReportType+
	'&view_option='+view_option+
	'&report_view='+ReportType+
	"&projectName="+projectName+
	"&filteropt="+filteropt+
	"&checkpotential="+ch_potential+
	"&project_id="+projectId;
	var Reportoption=$("input[name='ReportOption']:checked").val();
	var ajaxUrl = ajaxHandler;
	var err = false;
	
		/*Ajax call*/
		var methodType = 'POST';
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			type: methodType,
			success: function(data, textStatus, jqXHR){
				$('#Delays_html').empty().html(data);
				genratePDF(Reportoption,ReportType,ajaxQueryString);
			},
			error: errorHandler
		});
	
}

//To Get the Email
function getEmailbasedonselection()
{
	var type = $('#ddl_report_id').val();
	var explode = type.split(',');
	var ReportType=explode[0];
	var projectId = $("#project_id").val().trim();
	if(ReportType=="Bidder List"){

		var theStatus = $("#ddlStatus").val();
		if (theStatus == null) {
			theStatus = '';
		}

		var theSortBy = $("#ddlSortBy").val();
		if (theSortBy == null) {
			theSortBy = '';
		}
		var ajaxQueryString =
		'responseDataType=json' +
		'&sbs=' + encodeURIComponent(theStatus) +
		'&sbo=' + encodeURIComponent(theSortBy)+
		'&ReportType=Bidder Email'+
		"&project_id="+projectId;
	}
	if(ReportType=="Contact List")
	{
		var ajaxQueryString =
		'responseDataType=json' +
		'&ReportType=Contact Email'+
		"&project_id="+projectId;
	}

	var ajaxHandler = window.ajaxUrlPrefix + 'module-report-function.php';
	var methodType = 'POST';
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		type: methodType,
		success: function(data, textStatus, jqXHR){
			$("#divemailcontentforbidPopover").empty().append(data);
				// $('#emailData').attr('data-content',data);
				// $('[data-toggle="popover"]').popover({ html : true});

				$('[data-toggle="popover"]').popover({
					html: true,
					title: 'Email id of '+ReportType,
					content: function() {
						var content = getPopoverContent(this, 'divemailcontentforbidPopover');
						return content;
					}
				}).click(function (e) {
					$('[data-original-title]').popover('hide');
					$(this).popover('show');
				});

				
			},
			error: errorHandler
		});


}

//To Get QB bills
function getQBreport(vendor,qb_customer, revised_subcontract_total)
{
	// var type = $('#ddl_report_id').val();
	// var explode = type.split(',');
	// var ReportType=explode[0];
	// var projectId = $("#currentlySelectedProjectId").val();	

	var ajaxQueryString ='vendor='+vendor+'&qb_customer='+qb_customer+'&revised_subcontract_total='+revised_subcontract_total;

	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/accounting_cntrl.php?action=getAllQbBill';
	var methodType = 'POST';
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		type: methodType,
		success: function(html){
					$('#QB_html').empty().html(html);	
		},
		error: errorHandler
	});
}

function openpopover()
{
	var type = $('#ddl_report_id').val();
	var explode = type.split(',');
	var ReportType=explode[0];
	$('[data-toggle="popover"]').popover({
					html: true,
					title: 'Email id of '+ReportType,
					content: function() {
						var content = getPopoverContent(this, 'divemailcontentforbidPopover');
						return content;
					}
				}).click(function (e) {
					$('[data-original-title]').popover('hide');
					$('[data-original-title] ').addClass('des-email');
					$(this).popover('show');
				});

}

function SelectallEmail()
{	$(".actselect").prop('checked',true);
}

function copycontent()
{
	var connector = $('input[name=emcom]:checked').val();
	var text="";
	var cont=0;
	$(".actselect").each(function(){
		var ids=this.id;
		if($('#'+ids).prop('checked') == true){
			text +=this.value+connector;
			cont++;
		}
	});
	if(cont =='0')
	{
		messageAlert('Please select Email ID(s) .', 'infoMessage');
		return false;
	}
	text = $.trim(text).substring(0, text.length -1);
	$('#emaildataforcopy').empty().append(text);
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val($('#emaildataforcopy').text()).select();
	document.execCommand("copy");
	$temp.remove();
	$('[data-original-title]').popover('hide');
	messageAlert('Successfully Copied Email ID(s) .', 'successMessage');
}

function loadSelectedReportCompany()
{
	
	try {
		var ReportType = "Company";
		var vendor_id = $("#vendor_id").val();

		$.ajax({
			type : "post",
			url	 :  window.ajaxUrlPrefix+"module-report-function.php",
			data : {
				method:'loadSelectedReportCompany',
				ReportType:ReportType,
				vendor_id:vendor_id,
				
			},
			cache :false,
			async : true,
			success :function(html)
			{

				//alert("SSSS");
				$('#costCodeHtml').empty().html(html);
				style="display:none;"
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
