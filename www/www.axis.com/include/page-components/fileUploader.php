<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

function buildFileUploader(Input $input)
{
	// Debug
	//$data = $input->getData();

	$id							= $input->id;
	$folder_id					= $input->folder_id;
	$project_id					= $input->project_id;
	$virtual_file_path			= $input->virtual_file_path;
	$virtual_file_name			= $input->virtual_file_name;
	$action						= $input->action;
	$method						= $input->method;
	$allowed_extensions			= $input->allowed_extensions;
	$prependDateToFilename		= $input->prepend_date_to_filename;
	$appendDateToFilename		= $input->append_date_to_filename;
	$post_upload_js_callback	= $input->post_upload_js_callback;
	$style						= $input->style;
	$custom_label				= $input->custom_label;
	$file_upload_position		= $input->file_upload_position;
	$hidden						= $input->hidden;
	$class						= $input->class;
	$arrStaticUploaderOptions	= $input->static_uploader_options;
  $multiple = $input->multiple;
	if (empty($allowed_extensions)) {
		$allowed_extensions = 'gif,jpg,jpeg,pdf,png,tif,tiff';
	}

	if (isset($prependDateToFilename) && $prependDateToFilename) {
		$prepend_date_to_filename = 1;
	} else {
		$prepend_date_to_filename = 0;
	}

	if (isset($appendDateToFilename) && $appendDateToFilename) {
		$append_date_to_filename = 1;
	} else {
		$append_date_to_filename = 0;
	}

	if (!isset($class) || empty($class)) {
		$class = 'boxViewUploader';
	}

	$htmlContent = <<<END_HTML_CONTENT

<div id="$id"
	class="$class $hidden"
	folder_id="$folder_id"
	project_id="$project_id"
	virtual_file_path="$virtual_file_path"
	virtual_file_name="$virtual_file_name"
	prepend_date_to_filename="$prepend_date_to_filename"
	append_date_to_filename="$append_date_to_filename"
	post_upload_js_callback="$post_upload_js_callback"
	action="$action"
	method="$method"
	allowed_extensions="$allowed_extensions"
	drop_text_prefix=""
	style="$style"
	custom_label="$custom_label"
	multiple = "$multiple"
	file_upload_position="$file_upload_position">
</div>

END_HTML_CONTENT;

	if (!empty($arrStaticUploaderOptions)) {
		$jsFunction = $arrStaticUploaderOptions['jsFunction'];
		$options = $arrStaticUploaderOptions['options'];

		if (isset($arrStaticUploaderOptions['uploadButtonHasRightSibling']) && !empty($arrStaticUploaderOptions['uploadButtonHasRightSibling'])) {
			$uploadButtonHasRightSiblingClass = 'has-right-sibling';
		} else {
			$uploadButtonHasRightSiblingClass = '';
		}

		if (isset($arrStaticUploaderOptions['noOverride']) && !empty($arrStaticUploaderOptions['noOverride'])) {
			$noOverride = 'no-override';
		} else {
			$noOverride = '';
		}

		// Don't show the <input type="file">. Instead show the custom button.
		$tmpHtml = <<<END_HTML_CONTENT

		<input class="button-static-uploader hidden $noOverride" onchange="$jsFunction(this, $options);" type="file">
		<button class="button-static-uploader $uploadButtonHasRightSiblingClass $noOverride" onclick="clickPreviousHiddenFileInput(this);">Choose File</button>

END_HTML_CONTENT;

		$htmlContent .= $tmpHtml;
	}

	return $htmlContent;
}

function buildFileUploaderProgressWindow()
{
	$htmlContent = <<<END_HTML_CONTENT

<div id="uploadProgressWindow" class="uploadResult" style="display: none;">
	<h3>FILE UPLOAD PROGRESS: <input type="button" value="Close File Progress Window" onclick="document.getElementById('uploadProgressWindow').style.display='none';"></h3>
	<ul id="UL-FileList" class="qq-upload-list"></ul>
	<span id="uploadProgressErrorMessage"></span>
</div>

END_HTML_CONTENT;

	return $htmlContent;
}
