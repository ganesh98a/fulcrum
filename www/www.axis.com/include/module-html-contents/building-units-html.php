<?php

$cssDebugMode = false;
$javaScriptDebugMode = false;

// Display html as usual.
$buildUnitsHtml = '';


$htmlHead = <<<END_HTML_HEAD
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<title>Buildings and Units -$project_name</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Bid Spread">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="imagetoolbar" content="false">
	<link rel="dns-prefetch" href="//ajax.googleapis.com">
END_HTML_HEAD;

if ($cssDebugMode) {

	$htmlHead .= <<<END_HTML_HEAD

	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/library-user_messages.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/jquery-ui-1.10.0.custom.css">
	<link href="/css/modules-requests-for-information.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/fileuploader.css">
	<link rel="stylesheet" href="/css/bootstrap-popover.css">
	<link rel="stylesheet" href="/css/bootstrap-dropdown.css">
	<link rel="stylesheet" href="/css/entypo.css">

	
	<link rel="stylesheet" media="screen" href="handsontable/css/jquery.handsontable.full.css">
	<link rel="stylesheet" media="screen" href="handsontable/css/demo-style.css">
END_HTML_HEAD;

} else {
	$htmlHead .= <<<END_HTML_HEAD

	<link rel="stylesheet" href="/css/styles.css.php">
	<link href="/css/modules-requests-for-information.css" rel="stylesheet">

	
	<link rel="stylesheet" media="screen" href="handsontable/css/jquery.handsontable.full.css">
	<link rel="stylesheet" media="screen" href="handsontable/css/demo-style.css">
END_HTML_HEAD;

}

$htmlHead .= <<<END_HTML_HEAD

	<style>
		body {
			/**/display: none;/**/
		}
	</style>
	<script>
		var arrBidSpreadStatuses = '';
	</script>
</head>
<body>
<div id="modalDialogContainer" class="hidden"></div>
END_HTML_HEAD;

//echo $htmlHead;
$buildUnitsHtml .= $htmlHead;


// @todo Figure Out Subtotals  // overlay-table
$buildUnitsHtml .= <<<BID_SPREAD_HTML
<div class="">
<div id="purchasingBidSpreadContainer" style="margin:20px; margin-bottom:5px;" class="">
	<div id="punchSpreadButtons" style="float:left;">
		
		<input type="button" value="Go Back To Projects Admin" onclick="document.location.href='admin-projects.php'" >
		<input type="button" onclick="CreatebuildingsDialog(null);" value="Create Building and Unit" style="margin-bottom:15px">	
		
		
	</div>
	<div id="sendpopup" class="modal"></div>
	<div id="createPrelims" class="modal"></div>
	<div id="uploadProgressWindow" class="uploadResult" style="display:none;">
	<h3>FILE UPLOAD PROGRESS: <input type="button" value="Close File Progress Window" onclick="document.getElementById(\'uploadProgressWindow\').style.display=\'none\';"></h3>
	<ul id="UL-FileList" class="qq-upload-list"></ul>
	<span id="uploadProgressErrorMessage"></span>
</div>
<div id="dialog-confirm" ></div>
<div id="divCreatepunch" class="hidden modal"></div>
	<div id="divdefect" class="modal"></div>

	<div id="dataTable"></div>
	<div id="myconsole"></div>

	
BID_SPREAD_HTML;
//<input type="button" onclick="importBuildingandUnit(null)" value="Import Building and Unit" style="margin-bottom:15px">	

$buildRoomTable= renderBuildingRoomsListView($project_id,$user_company_id,$currentlyActiveContactId,$userCanManagePunch);

$buildUnitsHtml .="<div id='punchTable' >". $buildRoomTable."</div>";
	

$buildUnitsHtml .= <<<END_BID_SPREAD_HTML


	<input id="project_id" type="hidden" value="$currentlySelectedProjectId">
	<input id="openModal" type="hidden" value="$openModal">
	
	
	<input id="csvSubcontractorBidIds" type="hidden" value="$csvSubcontractorBidIds">

	<div id="messageDiv" class="userMessage"></div>
	<div id="divModalWindow" class="hidden" rel="tooltip" title="">&nbsp;</div>
	<div id="divModalWindow2" class="hidden divModalWindow2Tracking" rel="tooltip" title="">&nbsp;</div>
	<div id="divAjaxLoading">Loading . . . <img alt="Loading..." src="/images/ajax-loader.gif"></div>
	<div id="divBidSpreadApprovalProcessDialog" class="hidden"></div>
END_BID_SPREAD_HTML;

	//$javaScriptDebugMode = true;
if ($javaScriptDebugMode) {

	$htmlBodyFooter = <<<END_HTML_BODY_FOOTER


	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
	<script src="/js/ddaccordion.js"></script>
	<script src="/js/library-main.js"></script>

	<script src="/js/punch_card_admin.js"></script>


	<!--[if lt IE 8]>
	<script src="/js/json2.js"></script>
	<![endif]-->


	<script src="/js/library-data_types.js"></script>
	<script src="/js/library-tabular_data.js"></script>

	<script src="/js/fileuploader.js"></script>
	<script src="/js/bootstrap-dropdown.js"></script>
	<script src="/js/bootstrap-popover.js"></script>
	<script src="/js/bootstrap-tooltip.js"></script>

	<script src="/js/library-code-generator.js"></script>

	

	<script src="/js/modules-purchasing-bid-spread.js"></script>
	<script src="/js/generated/file_manager_files-js.js"></script>

	<script src="handsontable/js/jquery-ui.custom.min.js"></script>
	<script src="handsontable/js/jquery.handsontable.full.js"></script>
	<script src="handsontable/js/numeral.js"></script>
	<script src="handsontable/js/jquery.handsontable-excel.js"></script>
END_HTML_BODY_FOOTER;

} else {

		$htmlBodyFooter = <<<END_HTML_BODY_FOOTER


	<script src="/js/scripts.js.php"></script>
	<script src="/js/punch_card_admin.js"></script>
	<script src="/js/modules-purchasing-bid-spread.js"></script>
	<script src="/js/generated/file_manager_files-js.js"></script>

	<script src="handsontable/js/jquery-ui.custom.min.js"></script>
	<script src="handsontable/js/jquery.handsontable.full.js"></script>
	<script src="handsontable/js/numeral.js"></script>
	<script src="handsontable/js/jquery.handsontable-excel.js"></script>
	

END_HTML_BODY_FOOTER;

}

$htmlBodyFooter .= <<<END_HTML_BODY_FOOTER

	<script>
		window.debugMode = false;
		window.showJSExceptions = true;
		window.modalDialogUrlDebugMode = false;
		window.ajaxUrlDebugMode = false;
	</script>

</body>
</html>
END_HTML_BODY_FOOTER;

$buildUnitsHtml .= $htmlBodyFooter;

