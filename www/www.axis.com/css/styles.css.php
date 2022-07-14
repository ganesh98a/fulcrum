<?php


// Original CSS File Order
$oldExampleCssIncludes = <<<END_EXAMPLE_CSS_INCLUDES
	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/library-user_messages.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/jquery-ui-1.10.0.custom.css">

	<link rel="stylesheet" href="/css/fileuploader.css">
	<!--<link rel="stylesheet" href="/css/custom.fineuploader-5.0.8.css">-->
	<link rel="stylesheet" href="/css/modules-bidding.css">
	<link rel="stylesheet" href="/css/bootstrap-dropdown.css">
	<link rel="stylesheet" href="/css/bootstrap-popover.css">
	<link rel="stylesheet" href="/css/entypo.css">
END_EXAMPLE_CSS_INCLUDES;

// New CSS File Order
$exampleCssIncludes = <<<END_EXAMPLE_CSS_INCLUDES
	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/bootstrap-dropdown.css">
	<link rel="stylesheet" href="/css/bootstrap-popover.css">
	<link rel="stylesheet" href="/css/entypo.css">
	<link rel="stylesheet" href="/css/fileuploader.css">
	<link rel="stylesheet" href="/css/library-icons.css">
	<link rel="stylesheet" href="/css/library-user_messages.css">
	<link rel="stylesheet" href="/css/modules-permissions.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/jquery-ui-1.10.0.custom.css">
END_EXAMPLE_CSS_INCLUDES;


// HTML5 Boilerplate - normalize.css
// <link rel="stylesheet" href="/css/normalize.css">
ob_start();
$normalizeCssFileSize = readfile('./normalize.css');
$normalizeCss = ob_get_clean();

// HTML5 Boilerplate - main.css
// <link rel="stylesheet" href="/css/main.css">
ob_start();
$mainCssFileSize = readfile('./main.css');
$mainCss = ob_get_clean();

// Bootstrap Drop Down List
// <link rel="stylesheet" href="/css/bootstrap-dropdown.css">
ob_start();
$bootstrapDropDownCssFileSize = readfile('./bootstrap-dropdown.css');
$bootstrapDropDownCss = ob_get_clean();

// Bootstrap Popover
// <link rel="stylesheet" href="/css/bootstrap-popover.css">
ob_start();
$bootstrapPopoverCssFileSize = readfile('./bootstrap-popover.css');
$bootstrapPopoverCss = ob_get_clean();

// Entypo
// <link rel="stylesheet" href="/css/entypo.css">
ob_start();
$entypoCssFileSize = readfile('./entypo.css');
$entypoCss = ob_get_clean();

// File Uploader - Currently customized Fine Uploader
// <link rel="stylesheet" href="/css/fileuploader.css">
ob_start();
$fileuploaderCssFileSize = readfile('./fileuploader.css');
$fileuploaderCss = ob_get_clean();

// <link rel="stylesheet" href="/css/library-icons.css">
ob_start();
$libraryIconsCssFileSize = readfile('./library-icons.css');
$libraryIconsCss = ob_get_clean();

// <link rel="stylesheet" href="/css/library-user_messages.css">
ob_start();
$libraryUserMessagesCssFileSize = readfile('./library-user_messages.css');
$libraryUserMessagesCss = ob_get_clean();

// <link rel="stylesheet" href="/css/modules-permissions.css">
ob_start();
$modulesPermissionsCssFileSize = readfile('./modules-permissions.css');
$modulesPermissionsCss = ob_get_clean();

// <link rel="stylesheet" href="/css/styles.css">
ob_start();
$stylesCssFileSize = readfile('./styles.css');
$stylesCss = ob_get_clean();

// @todo Upgrade/Redo jQuery UI css and themes, etc.
// <link rel="stylesheet" href="/css/jquery-ui-1.10.0.custom.css">
// <link rel="stylesheet" href="/css/jquery-ui-1.11.4.custom.css">
ob_start();
$jqueryUiCssFileSize = readfile('./jquery-ui-1.10.0.custom.css');
$jqueryUiCss = ob_get_clean();

// 	<link href="/css/jquery.dataTables.css" rel="stylesheet">
ob_start();
$jqueryDataTablesCssFileSize = readfile('./jquery.dataTables.css');
$jqueryDataTablesCss = ob_get_clean();


ob_start();
$jqueryDataTablesButtonCssFileSize = readfile('./delay_css/buttons.dataTables.min.css');
$jqueryDataTablesButtonCss = ob_get_clean();





// This array structure facilitates super fast comment out or re-ordering of source file code
$arrCss = array(
	$normalizeCss,
	$mainCss,
	$bootstrapDropDownCss,
	$bootstrapPopoverCss,
	$entypoCss,
	$libraryIconsCss,
	$libraryUserMessagesCss,
	$stylesCss,
	$jqueryUiCss,
	$fileuploaderCss,
	$modulesPermissionsCss,
	$jqueryDataTablesCss,
	$jqueryDataTablesButtonCss
);

$css = join("\n", $arrCss);


/*
$css .=
"

a:link, a:visited {
	color: blue;
	text-decoration: underline;
}

a:hover {
	color: red;
	text-decoration: none;
}

a:active {
	color: red;
	text-decoration: none;
}

";
*/

// Output CSS Mime Type
header('Content-Type: text/css');
echo $css;
exit;
