$(document).ready(function() {
	$("#softwareModuleHeadline").html('Punch List Admin');
	$("#softwareModuleHeadline").css('display','block');
	Defects__addDataTablesdefectsListView();
	//Active the selected Rows
	var punchTableTrActive;
	$("#punchTable tbody tr").click(function() {
		$("#punchTable tbody tr").each(function(i) {
			$(this).removeClass('trActive');
		});
		$(this).addClass('trActive');
		punchTableTrActive = this;
	});

	if (punchTableTrActive) {
		$("#"+punchTableTrActive.id).addClass('trActive');
	}
	$('[data-toggle="tooltip"]').tooltip(); 
});

// Method to generate url for uploading files
function convertFileToDataURLviaFileReader(url,callback) {
	
	var xhr = new XMLHttpRequest();
	xhr.onload = function() {
		var reader = new FileReader();
		reader.onloadend = function() {

			callback(reader.result);
		}
		reader.readAsDataURL(xhr.response);
	};
	xhr.open('GET', url);
	xhr.responseType = 'blob';
	xhr.send();
}
//Method To generate Transmittal List
function Defects__addDataTablesdefectsListView()
{
	var url = window.ajaxUrlPrefix +"images/logos/pdf_logo.jpg";
	convertFileToDataURLviaFileReader(url,function(base64Image){

		console.log(base64Image);
		var table = $("#Building_data-record").DataTable({
			"initComplete": function(settings, json) {
    // $(".pod_loader_img").hide();
    hideSpinner();
},
'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
'order': [[ 0, 'desc' ]],
'pageLength': 50,
'pagingType': 'full_numbers',
dom: 'Blftip',
buttons: [
{
	extend: 'pdfHtml5',

	customize: function ( doc ) {
		var cols = [];
		cols[0] = {text: 'Left part', alignment: 'left', margin:[20] };
		cols[1] = {text: 'Right part', alignment: 'right', margin:[0,0,20] };

		doc.defaultStyle.alignment = 'left',
		doc.styles.tableHeader.alignment = 'left',
		doc.defaultStyle.noWrap = false;
		doc.defaultStyle.width = '100px';
		doc.styles.title = {
			color: '#4e4e4e',
			fontSize: '16',     
			alignment: 'left'
		},   
		doc.content.splice( 0, 0, {
			margin: [ 0, 0, 0, 15 ],
			alignment: 'right',
			image:base64Image
		} );
	},
	download: 'open',
	exportOptions: {
		columns: [0,1,2,3,4,5,6,7,8,9],
	},
	orientation: 'landscape',
	pageSize: 'LEGAL'
},
],
columnDefs: [
{ orderable: false, targets: -1 },
   // {
   //      targets: 2,
   //      render: $.fn.dataTable.render.ellipsis_trans( 10 )
   //  }
   ],
   drawCallback: function () {
   	$('[data-toggle="tooltip"]').tooltip(); 
   	$('[data-toggle="tooltip"]').hover(function(){
   		$('.tooltip-inner').css('width', 'auto');
   		$('.tooltip-inner').css('max-width', '250px');
   	}); 
   }
});
		table.on( 'buttons-action', function ( e, buttonApi, dataTable, node, config ) {
    // $(".pod_loader_img").hide();
    hideSpinner();
    
} );
  // Then you'll be able to handle the myimage.png file as base64
});

	$("#record_list_container--manage-request_for_information-record").DataTable({
		'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		'order': [[ 0, 'desc' ]],
		'pageLength': 50,
		'pagingType': 'full_numbers',
		
	});
	
}



// Method for Create building Dialog box ajax
function CreatebuildingsDialog(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var building_id = '';
		if (element) {
			building_id = $(element).val();
			if (building_id == '-1') {
				return;
			}
			$(element).val(-1);
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=CreatebuildingDialog';
		var ajaxQueryString =
		'building_id=' + encodeURIComponent(building_id) +
		'&attributeGroupName=create-building-record' +
		'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}
		var arrSuccessCallbacks = [ arrbuildingSuccessCallbacks ];
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


// Method for open Create buildings Dialog
function arrbuildingSuccessCallbacks(data, textStatus, jqXHR)
{
	try {
		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var htmlContent = json.htmlContent;

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			// var dialogWidth = windowWidth * 0.99;
			// var dialogHeight = windowHeight * 0.98;
			var dialogWidth ='500';
			var dialogHeight = '520';

			$("#divdefect").html(htmlContent);
			$("#divdefect").removeClass('hidden');
			$("#divdefect").dialog({
				modal: true,
				title: 'Create Building and Unit',
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("#divdefect").parent().addClass('jqueryPopupHead');
					$("body").addClass('noscroll');
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divdefect").parent().removeClass('jqueryPopupHead');
					$("#divdefect").addClass('hidden');
					$("#divdefect").dialog('destroy');

				},
				buttons: {
					
					'Create Unit': function() {
						$("#unitsub").click();
					},
					'Close': function() {
						$("#divdefect").dialog('close');
						$("#divdefect").parent().removeClass('jqueryPopupHead');
					},
					'Reset': function() {
						$("#formCreatebuilding")[0].reset();
						$('#building_data').prop('selectedIndex',0);
						$(".htCore tbody > tr td").empty();
						$(".htCore tbody > tr td").css("background-color","");
						
					},
				}
			});

			$("#show_building").click(function() {

				$('.add_build').css('display','block');

			});


			$( "#building_data" ).change(function() {
				$("#building_data").removeClass('redBorderThick');
			});
			$( "#room_name" ).click(function() {
				$("#room_name").removeClass('redBorderThick');
			});
			$( "#description" ).click(function() {
				$("#description").removeClass('redBorderThick');
			});


			createUploaders();
			$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });

			//for jquery handsome table
			(function ( $ ) {
				var container = $("#excelTable").handsontable({

					minRows: 8,
					minCols: 1,
					startRows: 2,
					startCols: 1,
					rowHeaders: true,
					colHeaders: true,
				minSpareRows: 1, //To generate auto row
				minSpareCols: 0, //To generate auto column
				contextMenu: false, //To get the menu to insert rows and columns
				manualColumnResize: true,
    			useFormula: true,			// This is the line you are looking for

    			cells: function (row, col, prop) {
    				var cellProperties = {};

    				cellProperties.type = 'excel';
    				return cellProperties;
    			},

    			onChange: function (data, source) {
    				if (source === 'loadData') {
		        return; //don't show this change in console
		    }
		}

	});
			})(jQuery);



		}
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			console.log('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

//Import building and unit
function importBuildingandUnit(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=importbuildingUnitDialog';
		var ajaxQueryString ='';
			// '&attributeGroupName=create-building-record' +
			// '&responseDataType=json';
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}
			var arrSuccessCallbacks = [ importBuildingandUnitSuccess ];
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


// Method for open impor buildings and unit Dialog
function importBuildingandUnitSuccess(data, textStatus, jqXHR)
{
	try {
		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var htmlContent = json.htmlContent;

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			// var dialogWidth = windowWidth * 0.99;
			// var dialogHeight = windowHeight * 0.98;
			// var dialogWidth ='500';
			// var dialogHeight = '550';

			$("#divdefect").html(htmlContent);
			$("#divdefect").removeClass('hidden');
			$("#divdefect").dialog({
				modal: true,
				title: 'Import Building and Unit',
				height: $(window).height() * 0.95,
				width: 600,
				// width: dialogWidth,
				// height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divdefect").addClass('hidden');
					$("#divdefect").dialog('destroy');

				},
				buttons: {
					'Cancel': function() {
						$("#divdefect").dialog('close');
					},
					'Import Selected Items': function() {
						importbuildingandUnit();

					}


				}
			});

			
			
		}
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			console.log('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function importbuildingandUnit()
{
	var imp_arr = {};
	var build = {};
	// var imp_unialone = {};
	var allunitarr = {};
	var k =0;

	$( ".build_check" ).each(function( index ) {

		
		var units= {};
		var i =0;

		var build_id = this.id;
		var bu_spl=build_id.split('_');
		var bspl_id=bu_spl[1];
		
		if($("#"+build_id).prop('checked') == true){

			$( ".unit_"+bspl_id ).each(function( index ) {

				var room_id = this.id;
				if($("#"+room_id).prop('checked') == true){
					var room =$("#"+room_id).val();
					units[i] =  parseInt(room) ;
					i++;
				}
				
			});
			build[bspl_id]=units;

		}else
		{
			//To get the id of unchecked units of a building
			$( ".unit_"+bspl_id ).each(function( index ) {
				var unid = this.id;
				if($("#"+unid).prop('checked') == true){
					var room =$("#"+unid).val();
					allunitarr[k] =  parseInt(room) ;
					k++;
				}
				
			});
			
		}
		imp_arr[0] =build;

	});

	//All  units without building
	if(!jQuery.isEmptyObject(allunitarr))
	{
		// imp_unialone[0] = allunitarr;
		var arrunits = JSON.stringify(allunitarr);
		modalfornewbuildorexist(arrunits);
	}

		//For building and units import
		var importItems = JSON.stringify(imp_arr);
		allbuildandunit(importItems);


	}

	function modalfornewbuildorexist(arrunits)
	{
		showSpinner();
		var modal = document.getElementById('divCreatepunch');
		$("#divCreatepunch").removeClass('hidden');


		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=dialogUploadOrCreatebuilding';
		var ajaxQueryString ='importarrunit='+arrunits;
			// '&responseDataType=json';
	// var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	var ajaxUrl = ajaxHandler ;


	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
			// dataType: "json",
			success: function(data)
			{
				$('#divCreatepunch').empty().html(data);
				modal.style.display = "block";
				$("body").addClass('noscroll');
				hideSpinner();	

				$("#show_building").click(function() {

					$('.add_build').css('display','block');

				});

			},
			error: errorHandler
		});
	
}

//to import unit alone
function allunitimp(arrunits)
{
	//All  units without building
	var building_data = $("#building_data").val();
	var newarrimp ='{"'+building_data+'":'+arrunits+'}';
	if(building_data =="")
	{
		messageAlert('Please select the building.', 'errorMessage');	
		return false;
	}else
	{
		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=importItems';
		var ajaxQueryString ='importarr='+newarrimp+
		'&item=unit';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;


		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			// dataType: "json",
			success: function(data)
			{
				impmodalClose();
				messageAlert('Imported  Successfully.', 'successMessage');
				ListBuildingandUnitupdate();
			},
			error: errorHandler
		});
		//end of unit alone
	}
}

//To import building and unit
function allbuildandunit(importItems)
{
	//start of importing buildings and buildings and unit


	var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=importItems';
	var ajaxQueryString ='importarr='+importItems+'&item=both';
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
			// dataType: "json",
			success: function(data)
			{
				$("body").removeClass('noscroll');
				$("#divdefect").dialog('close');
				messageAlert('Imported  Successfully.', 'successMessage');
				ListBuildingandUnitupdate();
			},
			error: errorHandler
		});
			//End of importing buildings and buildings and unit
		}


//Import building and unit
function updateProjectbasedImports(element, options)
{
	var changeprjid = $("#projectList").val();
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=updateimportProjectonbuildingunit';
		var ajaxQueryString ='changeprjid='+changeprjid ;
			// '&responseDataType=json';
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
				success: function(data)
				{
					$("#impbuilddata").empty().append(data);
					$('.build_check').click(function(){


					});
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

	function selectAllbuild(build_id)
	{
		$("#build_"+build_id).prop('checked',true);
		selectAllunits(build_id)
	}

//To update the All rooms based on building 
function selectAllunits(build_id){

	if($("#build_"+build_id).prop('checked') == true){
		$(".unit_"+build_id).prop('checked',true);
	}else{
		$(".unit_"+build_id).removeProp('checked');
	}

}


//to close the building data
function closebuilding()
{
	$('.add_build').css('display','none');
}

//To edit building data
function updatebuildingdata(build_id)
{
	var options = options || {};
	var promiseChain = options.promiseChain;
	
	var building_name = $("#building_name").val();
	var location = $("#location").val();
	var description = $("#description").val();
	var valPair =[];
	var j='0';
	if(building_name =="")
	{
		$("#building_name").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}else{
		$("#building_name").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 
	
	if(valPair.indexOf('0') !='-1'){
		messageAlert('Please fill in the highlighted areas.', 'errorMessage');	
		return false;
	}else if(valPair.indexOf('0')=='-1')
	{
		showSpinner();
		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=updatebuilding';
		var ajaxQueryString =
		'responseDataType=json&building_name='+encodeURIComponent(building_name)+'&location='+encodeURIComponent(location)+'&build_id='+build_id+'&description='+description;
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
				hideSpinner();
				messageAlert('Building Updated Successfully.', 'successMessage');
				punchmodalClose();
				ListBuildingandUnitupdate();
			},
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}
	}

}

//To add building data
function submitbuildingdata()
{
	var options = options || {};
	var promiseChain = options.promiseChain;
	
	var building_name = $("#building_name").val();
	var location = $("#location").val();
	var description = $("#description").val();
	var valPair =[];
	var j='0';
	if(building_name =="")
	{
		$("#building_name").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}else{
		$("#building_name").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 
	
	if(valPair.indexOf('0') !='-1'){
		messageAlert('Please fill in the highlighted areas.', 'errorMessage');	
		return false;
	}else if(valPair.indexOf('0')=='-1')
	{
		showSpinner();
		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=Insertbuilding';
		var ajaxQueryString =
		'responseDataType=json&building_name='+encodeURIComponent(building_name)+'&location='+encodeURIComponent(location)+'&description='+encodeURIComponent(description);
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
				hideSpinner();
				if(data.id =="0")
				{
					messageAlert('Building Already Exist.', 'errorMessage');
					$("#building_name").addClass('redBorderThick');	
				}else
				{

					$('#building_data').append(data.res);
					$('.add_build').css('display','none');
			//To make the option selectable
			$("#building_data option[value="+data.id+"]").attr('selected','selected');
			$("#building_name").val("");
			$("#location").val("");
			$("#description").val("");
			messageAlert('Building Added Successfully.', 'successMessage');
		}


	},
	error: errorHandler
});

		if (promiseChain) {
			return returnedJqXHR;
		}
	}
}

//To edit room data
function updateRoomData(room_id)
{
	var options = options || {};
	var promiseChain = options.promiseChain;

	var building_data = $("#building_data").val();
	var room_name = $("#room_name").val();
	var description = $("#description").val();
	
	var valPair =[];
	var j='0';
	
	if(building_data =="")
	{
		$("#building_data").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}else{
		$("#building_data").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 
	if(room_name =="")
	{
		$("#room_name").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}else{
		$("#room_name").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 
	if(description =="")
	{
		$("#description").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}else{
		$("#description").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 
	
	if(valPair.indexOf('0') !='-1'){
		messageAlert('Please fill in the highlighted areas.', 'errorMessage');	
		return false;
	}else if(valPair.indexOf('0')=='-1')
	{
		showSpinner();
		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=updateRoomData';
		var ajaxQueryString =
		'responseDataType=json&room_name='+encodeURIComponent(room_name)+'&description='+encodeURIComponent(description)+'&room_id='+room_id+'&building_id='+building_data;
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

				hideSpinner();
				punchmodalClose();
				messageAlert('Unit Updated Successfully', 'successMessage');
			ListBuildingandUnitupdate(); //To update the list view			
			
		},
		error: errorHandler
	});

		if (promiseChain) {
			return returnedJqXHR;
		}
	}
}

//Function to add  rooms
function submitRoomdata()
{
	var options = options || {};
	var promiseChain = options.promiseChain;
	var building_data = $("#building_data").val();
	
	//To fetch the data from handsontable
	var $container = $("#excelTable");
	var handsontable = $container.data('handsontable');
	var handval=handsontable.getData();
	var unitvalues = JSON.stringify(handval)

	// console.log($container.data('handsontable').getData());
	
	var valPair =[];
	var j='0';
	if(building_data =="")
	{
		$("#building_data").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}else{
		$("#building_data").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 

	if(valPair.indexOf('0') !='-1'){
		messageAlert('Please fill in the highlighted areas.', 'errorMessage');	
		return false;
	}else if(valPair.indexOf('0')=='-1')
	{
		showSpinner();
		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=Insertrooms';
		var ajaxQueryString =
		'responseDataType=json&building_data='+encodeURIComponent(building_data)+'&unit='+encodeURIComponent(unitvalues);
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

				hideSpinner();
				if(data=="0")
				{
					messageAlert('Unit already exist.', 'errorMessage');	
					$("#room_name").addClass('redBorderThick');
				}else
				{

					$("#divdefect").dialog('close');
					messageAlert('Unit Added Successfully', 'successMessage');
			ListBuildingandUnitupdate(); //To update the list view	
		}		

	},
	error: errorHandler
});

		if (promiseChain) {
			return returnedJqXHR;
		}
	}
}

//Dialog for create default defeat list
function CreateDefectsDialog(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=defectsDialog';
		var ajaxQueryString ='responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}
		var arrSuccessCallbacks = [ AddDefectSuccessCallbacks ];
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


// Method for open Create buildings Dialog
function AddDefectSuccessCallbacks(data, textStatus, jqXHR)
{
	try {
		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var htmlContent = json.htmlContent;

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			// var dialogWidth = windowWidth * 0.99;
			// var dialogHeight = windowHeight * 0.98;
			var dialogWidth ='500';
			var dialogHeight = '430';

			$("#divdefect").html(htmlContent);
			$("#divdefect").removeClass('hidden');
			$("#divdefect").dialog({
				modal: true,
				title: 'Create Defect',
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("#divdefect").parent().addClass('jqueryPopupHead');
					$("body").addClass('noscroll');
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divdefect").parent().removeClass('jqueryPopupHead');
					$("#divdefect").addClass('hidden');
					$("#divdefect").dialog('destroy');

				},
				buttons: {
					
					'Add Defect': function() {
						addpunchDefects();
					},
					'Close': function() {
						$("#divdefect").dialog('close');
						$("#divdefect").parent().removeClass('jqueryPopupHead');
					},
					
				}
			});

			

			//for jquery handsome table
			(function ( $ ) {
				var container = $("#excelTable").handsontable({

					minRows: 8,
					minCols: 1,
					startRows: 2,
					startCols: 1,
					rowHeaders: true,
					colHeaders: true,
				minSpareRows: 1, //To generate auto row
				minSpareCols: 0, //To generate auto column
				contextMenu: false, //To get the menu to insert rows and columns
				manualColumnResize: true,
    			useFormula: true,			// This is the line you are looking for

    			cells: function (row, col, prop) {
    				var cellProperties = {};

    				cellProperties.type = 'excel';
    				return cellProperties;
    			},

    			onChange: function (data, source) {
    				if (source === 'loadData') {
		        return; //don't show this change in console
		    }
		}

	});
			})(jQuery);



		}
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			console.log('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

// When the user clicks on <span> (x), close the modal
function punchmodalClose() {
	var modal = document.getElementById('divdefect');
	modal.style.display = "none";
	$("body").removeClass('noscroll');
}

// When the user clicks on <span> (x), close the modal
function impmodalClose() {
	var modal = document.getElementById('divCreatepunch');
	$('#divCreatepunch').empty().html();
	modal.style.display = "none";
	$("body").removeClass('noscroll');

}



//Function to Insert defect description  rooms
function addpunchDefects()
{
	var options = options || {};
	var promiseChain = options.promiseChain;
	
	//To fetch the data from handsontable
	var $container = $("#excelTable");
	var handsontable = $container.data('handsontable');
	var handval=handsontable.getData();
	var defectvalues = JSON.stringify(handval);

	var valPair =0;
	for(i=0;i<handval.length;i++)
	{
		if(handval[i]!="")
		{
			valPair++;
		}
	}

	if(valPair=='0'){
		messageAlert('Please add the defect name.', 'errorMessage');	
		return false;
	}else if(valPair >'0')
	{
		showSpinner();
		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=InsertpunchDefects';
		var ajaxQueryString =
		'responseDataType=json&defect='+encodeURIComponent(defectvalues);
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
				hideSpinner();
				messageAlert('Defect Added Successfully.', 'successMessage');	
				$("body").removeClass('noscroll');
				$("#divdefect").parent().removeClass('jqueryPopupHead');
				$("#divdefect").addClass('hidden');
				$("#divdefect").dialog('destroy');
				Listviewupdate();

			},
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}
	}
}

function showDefectEditdialog(id, allow){
	if(!allow){
		messageAlert('You don\'t have a permission to edit', 'errorMessage');
		return;
	}
	showSpinner();
	var modal = document.getElementById('divdefect');
	$("#divdefect").removeClass('hidden');
	var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=EditdefectsDialog';
	var ajaxQueryString =
	'responseDataType=json&defect_id='+id;
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
			
			$('#divdefect').empty().html(data);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			hideSpinner();			
		},
		error: errorHandler
	});
}
function DefectEdit(id)
{
	var options = options || {};
	var promiseChain = options.promiseChain;
	
	var defect = $("#defect").val();

	var valPair =[];
	var j='0';
	if(defect =="")
	{
		$("#defect").addClass('redBorderThick');
		valPair[j]='0';
		j++;
	}else{
		$("#defect").removeClass('redBorderThick');
		valPair[j]='1';
		j++;
	} 

	if(valPair.indexOf('0') !='-1'){
		messageAlert('Please fill in the highlighted areas.', 'errorMessage');	
		return false;
	}else if(valPair.indexOf('0')=='-1')
	{
		showSpinner();
		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=UpdatepunchDefects';
		var ajaxQueryString =
		'responseDataType=json&defect='+encodeURIComponent(defect)+'&id='+id;
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
				hideSpinner();
				messageAlert('Defect Updated Successfully.', 'successMessage');	
				punchmodalClose();
				Listviewupdate();


			},
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}
	}
}

//To update list view
function Listviewupdate(){
	var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=Listviewupdate';
	var ajaxQueryString =
	'responseDataType=json';
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
			$('#defectTable').empty().append(data.Defectdata);
			Defects__addDataTablesdefectsListView();

		},
		error: errorHandler
	});
}

function ListBuildingandUnitupdate(){
	var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=Listviewupdate';
	var ajaxQueryString =
	'responseDataType=json';
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
			$('#punchTable').empty().append(data.Roomsdata);
			$('[data-toggle="tooltip"]').tooltip(); 

		},
		error: errorHandler
	});
}

//show edit building
function showEditBuilding(building_id)
{
	showSpinner();
	var modal = document.getElementById('divdefect');
	$("#divdefect").removeClass('hidden');
	var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=showEditBuilding';
	var ajaxQueryString =
	'responseDataType=json&building_id='+building_id;
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
			
			$('#divdefect').empty().html(data);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			hideSpinner();			
		},
		error: errorHandler
	});
}

// show edit Room
function showEditRooms(room_id)
{
	showSpinner();
	var modal = document.getElementById('divdefect');
	$("#divdefect").removeClass('hidden');
	var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=showEditRooms';
	var ajaxQueryString =
	'responseDataType=json&room_id='+room_id;
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
			
			$('#divdefect').empty().html(data);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			hideSpinner();			
		},
		error: errorHandler
	});
}

//warning message to Defect cannot be deleted
function existDefectwarn(id, allow)
{
	if(!allow){
		messageAlert('You don\'t have a permission to delete', 'errorMessage');
		return;
	}
	$("#dialog-confirm").html("The Defect item is currently in use. Cannot delete it.");

    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
    	resizable: false,
    	modal: true,
    	title: "Warning",
    	open: function() {
    		$("#dialog-confirm").parent().addClass("jqueryPopupHead");
    		$("body").addClass('noscroll');

    	},
    	close: function() {
    		$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    		$("body").removeClass('noscroll');

    	},
    	buttons: {

    		"close": function () {
    			$(this).dialog('close');
    			$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    			$("body").removeClass('noscroll');

    		}
    	}
    });
}

//Method will show confirm alert box for delete
function DelDefectconfirm(id, allow) {
	if(!allow){
		messageAlert('You don\'t have a permission to delete', 'errorMessage');
		return;
	}
	$("#dialog-confirm").html("Are you sure to delete the Defect item?");

    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
    	resizable: false,
    	modal: true,
    	title: "Confirmation",
    	open: function() {
    		$("#dialog-confirm").parent().addClass("jqueryPopupHead");
    		$("body").addClass('noscroll');

    	},
    	close: function() {
    		$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    		$("body").removeClass('noscroll');

    	},
    	buttons: {

    		"No": function () {
    			$(this).dialog('close');
    			$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    			$("body").removeClass('noscroll');

    		},
    		"Yes": function () {
    			$(this).dialog('close');
    			$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    			$("body").removeClass('noscroll');
    			deleteDefect(true,id);
    		}
    	}
    });
  //   return false;
}
// Common Callback Method
function deleteDefect(value,id) {

	if (value) {

		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=DeleteDefects';
		var ajaxQueryString =
		'responseDataType=json&id='+id;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				if (data == 1) { 
					messageAlert('Defect Deleted successfully', 'successMessage');	
					Listviewupdate();

				}	
			},
			error: errorHandler
		});

	} 
}
// unit name value allow or restrict
function allowToUserEditunits(allow){
	if(allow){
		$('#entypo-edit-icon').css('display','none');
		$('#entypo-lock-icon').css('display','block');
		$('.unit-text').css('display','none');
		$('.unit-edit').css('display','block');
	}else{
		$('#entypo-edit-icon').css('display','block');
		$('#entypo-lock-icon').css('display','none');
		$('.unit-text').css('display','block');
		$('.unit-edit').css('display','none');
	}
}

//to update a unit name 
function unit_update(id,value,unit_id){
	var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=updateUnitName';
	var ajaxQueryString =
	'responseDataType=json&unit_id='+unit_id+'&unit_name='+encodeURIComponent(value);
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
			if(data=='1')
			{
				$(".unit_name--"+unit_id).empty().html(value);
				messageAlert('Unit Name Updated successfully', 'successMessage');	

			}
			
		},
		error: errorHandler
	});

}


//warning message to Defect cannot be deleted
function existpunchwarn(type,name)
{
	var msgtext;
	if(type =="build")
	{
		var name = $('#manage-unit-record--punch_room_data--building_name--'+name).val();
		msgtext= " The building <span style='color:#06c'>"+name+"</span> cannot be deleted as it is associated with punch list.";		
	}else
	{
		var name = $('#manage-unit-record--punch_room_data--room_name--'+name).val();
		msgtext= "<span style='color:#06c'>"+name+"</span> cannot be deleted as it is associated with punch list.";		
	}

	
	$("#dialog-confirm").html(msgtext);
	
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
    	resizable: false,
    	modal: true,
    	title: "Warning",
    	open: function() {
    		$("#dialog-confirm").parent().addClass("jqueryPopupHead");

    	},
    	close: function() {
    		$("#dialog-confirm").parent().removeClass("jqueryPopupHead");

    	},
    	buttons: {

    		"close": function () {
    			$(this).dialog('close');
    			$("#dialog-confirm").parent().removeClass("jqueryPopupHead");

    		}
    	}
    });
}

//Method will show confirm alert box for delete
function Delpunchconfirm(type,id) {
	var msgtext;
	if(type =="build")
	{
		var name = $('#manage-unit-record--punch_room_data--building_name--'+id).val();
		msgtext= " Are you sure you want to delete the building <span style='color:#06c'>"+name+"</span>?";		
	}else
	{
		var name = $('#manage-unit-record--punch_room_data--room_name--'+id).val();
		msgtext= "Are you sure you want to delete the <span style='color:#06c'>"+name+"</span>?";		
	}
	$("#dialog-confirm").html(msgtext);
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
    	resizable: false,
    	modal: true,
    	title: "Confirmation",
    	open: function() {
    		$("#dialog-confirm").parent().addClass("jqueryPopupHead");

    	},
    	close: function() {
    		$("#dialog-confirm").parent().removeClass("jqueryPopupHead");

    	},
    	buttons: {

    		
    		"Yes": function () {
    			$(this).dialog('close');
    			$("#dialog-confirm").parent().removeClass("jqueryPopupHead");
    			deleteBuildingandunit(true,type,id);
    		},
    		"Cancel": function () {
    			$(this).dialog('close');
    			$("#dialog-confirm").parent().removeClass("jqueryPopupHead");

    		}
    	}
    });
  //   return false;
}
// Common Callback Method
function deleteBuildingandunit(value,type,id) {

	if (value) {

		var ajaxHandler = window.ajaxUrlPrefix + 'punch_card_ajax.php?method=deleteBuildingandunit';
		var ajaxQueryString =
		'responseDataType=json&id='+id+'&type='+type;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				if (type == "build") { 
					messageAlert('Building Deleted successfully', 'successMessage');	
				}else
				{
					messageAlert('Unit Deleted successfully', 'successMessage');
				}
				ListBuildingandUnitupdate();
			},
			error: errorHandler
		});

	} 
}
