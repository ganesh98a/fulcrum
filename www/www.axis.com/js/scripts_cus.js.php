<?php

/*
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 2000;
$init['get_required'] = false;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
//$init['post_maxlength'] = 100000;
//$init['post_required'] = true;
//$init['sapi'] = 'cli';
//$init['skip_always_include'] = true;
//$init['skip_session'] = true;
//$init['skip_templating'] = true;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');
*/


// SESSION VARIABLES
/* @var $session Session */
//$session = Zend_Registry::get('session');
//$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
//$project_name = $session->getCurrentlySelectedProjectName();
//$project_id = $session->getCurrentlySelectedProjectId();
//$user_id = $session->getUserId();
//$user_company_id = $session->getUserCompanyId();
//$debugMode = $session->getDebugMode();

// Debug
//$debugMode = true;


$ie6 = false;
$ie7 = false;
$oldIe = false;

/*
// Detect browser version
// browscap.ini
$browser = get_browser();
if ($browser->browser == 'IE' && $browser->majorver == 6) {
	$ie6 = true;
} elseif ($browser->browser == 'IE' && $browser->majorver == 7) {
	$ie7 = true;
} elseif ($browser->browser == 'IE' && $browser->majorver < 8) {
	$oldIe = true;
}
*/


$oldExampleJavaScriptIncludes = <<<END_EXAMPLE_JAVASCRIPT_INCLUDES
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script src="/js/ddaccordion.js">
		/***********************************************
		* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
		* This notice must stay intact for legal use
		***********************************************/
	</script>
	<script src="/js/library-main.js"></script>
	<script src="/js/permissions.js"></script>
	<script src="/js/admin-projects-team-management.js"></script>

	<!--[if lt IE 8]>
	<script src="/js/json2.js"></script>
	<![endif]-->

	<script src="/js/accounting.js"></script>
	<script src="/js/library-tabular_data.js"></script>
	<script src="/js/modules-gc-budget.js"></script>
	<script src="/js/modules-purchasing.js"></script>
	<!--script src="/js/generated/subcontracts-js.js"></script-->
	<script src="/js/fileuploader.js"></script>
	<script src="/js/ajaxq.js"></script>
	<script src="/js/bootstrap-dropdown.js"></script>
	<script src="/js/bootstrap-popover.js"></script>
	<script src="/js/bootstrap-tooltip.js"></script>
	<script src="/js/generated/contact_companies-js.js"></script>
	<script src="/js/generated/contact_company_offices-js.js"></script>
	<script src="/js/generated/contact_company_office_phone_numbers-js.js"></script>
	<script src="/js/generated/contact_phone_numbers-js.js"></script>
	<script src="/js/generated/mobile_phone_numbers-js.js"></script>
	<script src="/js/jquery.maskedinput.js"></script>
	<script src="/js/generated/subcontract_documents-js.js"></script>
	<script src="/js/generated/subcontracts-js.js"></script>
	<script src="/js/generated/gc_budget_line_items-js.js"></script>
END_EXAMPLE_JAVASCRIPT_INCLUDES;


$literalJavaScriptIncludes = <<<END_LITERAL_JAVASCRIPT_INCLUDES

	<script src="/js/jquery-1.11.2.js"></script>
	<script src="/js/jquery-ui-1.11.4.js"></script>
	<script src="/js/jquery.maskedinput.js"></script>

	<script src="/js/ddaccordion.js">
		/***********************************************
		* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
		* This notice must stay intact for legal use
		***********************************************/
	</script>

	<script src="/js/library-main.js"></script>

	<script src="/js/permissions.js"></script>
	<script src="/js/admin-projects-team-management.js"></script>

	<!--[if lt IE 8]>
	<script src="/js/json2.js"></script>
	<![endif]-->

	<script src="/js/accounting.js"></script>
	<script src="/js/library-data_types.js"></script>
	<script src="/js/library-tabular_data.js"></script>

	<script src="/js/fileuploader.js"></script>

	<script src="/js/bootstrap-dropdown.js"></script>
	<script src="/js/bootstrap-popover.js"></script>
	<script src="/js/bootstrap-tooltip.js"></script>

	<script src="/js/ajaxq.js"></script>
	<script src="/js/history.js"></script>

	<script src="/js/library-code-generator.js"></script>

END_LITERAL_JAVASCRIPT_INCLUDES;


/*
// Debug alternative is implemented in the smarty template.
if ($debugMode) {
	$template->assign('literalJavaScriptIncludes', $literalJavaScriptIncludes);
	// echo $literalJavaScriptIncludes;
	exit;
}
*/


// Read files into variables in alphabetical order
// The include order at the bottom will be different based on dependencies

// <script src="/js/accounting.js"></script>
ob_start();
$accountingJsFileSize = readfile('./accounting.js');
$accountingJs = ob_get_clean();

// <script src="/js/admin-projects-team-management.js"></script>
ob_start();
$adminProjectsTeamManagementJsFileSize = readfile('./admin-projects-team-management.js');
$adminProjectsTeamManagementJs = ob_get_clean();

// <script src="/js/ajaxq.js"></script>
ob_start();
$ajaxqJsFileSize = readfile('./ajaxq.js');
$ajaxqJs = ob_get_clean();

// <script src="/js/bootstrap-dropdown.js"></script>
ob_start();
$bootstrapDropdownJsFileSize = readfile('./bootstrap-dropdown.js');
$bootstrapDropdownJs = ob_get_clean();

// <script src="/js/bootstrap-popover.js"></script>
ob_start();
$bootstrapPopoverJsFileSize = readfile('./bootstrap-popover.js');
$bootstrapPopoverJs = ob_get_clean();

// <script src="/js/bootstrap-tooltip.js"></script>
ob_start();
$bootstrapTooltipJsFileSize = readfile('./bootstrap-tooltip.js');
$bootstrapTooltipJs = ob_get_clean();

// <script src="/js/ddaccordion.js"></script>
ob_start();
$ddaccordionJsFileSize = readfile('./ddaccordion.js');
$ddaccordionJs = ob_get_clean();

// <script src="/js/fileuploader.js"></script>
ob_start();
$fileuploaderJsFileSize = readfile('./fileuploader.js');
$fileuploaderJs = ob_get_clean();

// <script src="/js/history.js"></script>
ob_start();
$historyJsFileSize = readfile('./history.js');
$historyJs = ob_get_clean();

// <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
// <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
// <script src="/js/jquery-1.11.2.js"></script>
ob_start();
$jqueryJsFileSize = readfile('./jquery-1.11.2.js');
$jqueryJs = ob_get_clean();

// @todo Upgrade/Redo jQuery UI css and themes, etc.
// <script src="/js/jquery-ui-1.10.4.js"></script>
// <script src="/js/jquery-ui-1.11.4.js"></script>
ob_start();
$jqueryUiJsFileSize = readfile('./jquery-ui-1.11.4.js');
$jqueryUiJs = ob_get_clean();

// <script src="/js/jquery.dataTables.js"></script>


// <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
// <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
// <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>


ob_start();
$jqueryDataTablesJsFileSize = readfile('./datatable/jquery.dataTables.min.js');
$jqueryDataTablesJs = ob_get_clean();

ob_start();
$jqueryDataTablesButtonJsFileSize = readfile('./datatable/dataTables.buttons.min.js');
$jqueryDataTablesButtonJs = ob_get_clean();

ob_start();
$jqueryDataTablesPdfJsFileSize = readfile('./datatable/pdfmake.min.js');
$jqueryDataTablesPdfJs = ob_get_clean();

ob_start();
$jqueryDataTablesFontJsFileSize = readfile('./datatable/vfs_fonts.js');
$jqueryDataTablesFontJs = ob_get_clean();

ob_start();
$jqueryDataTablesButtonhtmlJsFileSize = readfile('./datatable/buttons.html5.min.js');
$jqueryDataTablesButtonhtmlJs = ob_get_clean();

ob_start();
$jqueryDataTablesEllipsishtmlJsFileSize = readfile('./datatable/ellipsis.js');
$jqueryDataTablesEllipsishtmlJs = ob_get_clean();


// <script src="/js/jquery.dataTables.natural.js"></script>
ob_start();
$jqueryDataTablesNaturalSortJsFileSize = readfile('./jquery.dataTables.natural.js');
$jqueryDataTablesNaturalSortJs = ob_get_clean();

// <script src="/js/jquery.maskedinput.js"></script>
ob_start();
$jqueryMaskedInputJsFileSize = readfile('./jquery.maskedinput.js');
$jqueryMaskedInputJs = ob_get_clean();

// <script src="/js/json2.js"></script>
$json2Js = '';
if ($oldIe || $ie6 || $ie7) {
	// <script src="/js/json2.js"></script>
	ob_start();
	$fileSize = readfile('./json2.js');
	$json2Js = ob_get_clean();
}

// <script src="/js/library-code-generator.js"></script>
ob_start();
$libraryCodeGeneratorJsFileSize = readfile('./library-code-generator.js');
$libraryCodeGeneratorJs = ob_get_clean();

// <script src="/js/library-data_types.js"></script>
ob_start();
$libraryDataTypesJsFileSize = readfile('./library-data_types.js');
$libraryDataTypesJs = ob_get_clean();

// <script src="/js/library-file-uploads.js"></script>
ob_start();
$libraryFileUploadsJsFileSize = readfile('./library-file-uploads.js');
$libraryFileUploadsJs = ob_get_clean();

// <script src="/js/library-main.js"></script>
ob_start();
$libraryMainJsFileSize = readfile('./library-main.js');
$libraryMainJs = ob_get_clean();

// <script src="/js/library-tabular_data.js"></script>
ob_start();
$libraryTabularDataJsFileSize = readfile('./library-tabular_data.js');
$libraryTabularDataJs = ob_get_clean();

// <script src="/js/permissions.js"></script>
ob_start();
$permissionsJsFileSize = readfile('./permissions.js');
$permissionsJs = ob_get_clean();


// This array structure facilitates super fast comment out or re-ordering of source file code
$arrJavascript = array(
	$jqueryJs,
	$jqueryUiJs,
	$jqueryDataTablesJs,
	$jqueryDataTablesButtonJs,
	$jqueryDataTablesPdfJs,
	$jqueryDataTablesFontJs,
	$jqueryDataTablesButtonhtmlJs,
	$jqueryDataTablesEllipsishtmlJs,
	$jqueryDataTablesNaturalSortJs,
	$jqueryMaskedInputJs,
	$ddaccordionJs, // Must come before library-main.js
	$libraryMainJs,
	$permissionsJs,
	$adminProjectsTeamManagementJs,
	$json2Js,
	$accountingJs,
	$libraryDataTypesJs,
	$libraryTabularDataJs,
	$libraryFileUploadsJs,
	$fileuploaderJs,
	$bootstrapDropdownJs,
	$bootstrapPopoverJs,
	$bootstrapTooltipJs,
	$ajaxqJs,
	$historyJs, // seems to include json2.js
	$libraryCodeGeneratorJs
);

$javascript = join("\n", $arrJavascript);

// Debug
// Send compressed output?
//$sendCompressedOutputFlag = false;
$sendCompressedOutputFlag = true;

if ($sendCompressedOutputFlag) {

	$gzippedJavascript = gzencode($javascript, 9);
	$contentLength = strlen($gzippedJavascript);

	header('Content-Type: application/javascript');
	header('Content-Encoding: gzip');
	header("Content-Length: $contentLength");
	echo $gzippedJavascript;

} else {

	// Output CSS Mime Type
	header('Content-Type: application/javascript');
	echo $javascript;

}
exit;
