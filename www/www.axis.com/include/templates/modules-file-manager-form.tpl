
{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
{else}	
{*<form action="modules-file-manager-form-submit.php{$queryString}" enctype="multipart/form-data" method="post" name="frm_project_file_manager">*}
<form action="modules-file-manager-file-uploader-ajax.php" enctype="multipart/form-data" method="post" name="frm_project_file_manager" onsubmit="return submitUnitTestFileUploadForm(this, event);">
<input type="hidden" name="MAX_FILE_SIZE" value="2147483647">

<!-- fine uploader ajax url paramaters: allows us to test with our actual ajax file upload handler -->
<!-- jQuery.(formElement).serialize(); requires a name attribute for a given form element to be included in the query string -->
<input type="hidden" name="id" value="file-uploader--unit-test-file-uploader">
<input type="hidden" name="folder_id" value="1">
<!-- project_id comes from the ddl for this test page -->
<!-- input type="hidden" name="project_id" value="" -->
<input type="hidden" name="virtual_file_path" value="/">
<input type="hidden" name="virtual_file_name" value="test.jpg">
<input type="hidden" name="prepend_date_to_filename" value="">
<input type="hidden" name="action" value="/modules-file-manager-file-uploader-ajax.php">
<input id="temp-file-uploader--method" type="hidden" name="method" value="">
<input type="hidden" name="allowed_extensions" value="jpg,pdf">
<input type="hidden" name="post_upload_js_callback" value="appendTempFileIds(arrFileManagerFiles, { htmlAttributeGroup: 'uploaded-temp-file', uploadedTempFilesContainerElementId: 'record_list_container--uploaded-temp-file' });">

<table border="0" cellpadding="3" cellspacing="0" height="73" width="100%">

<tr>
<td height="20"><div class="headerStyle">Manage Files &mdash; Upload a New File</div></td>
</tr>

<tr>
<td>

	
</td>
</tr>

<tr>
<td height="20">
{include file="dropdown-projects-list.tpl"}
</td>
</tr>

<tr>
<td>
	Upload a Project File
	<br>
	<input type="file" name="project_file" tabindex="1000">
	<br>
	User Defined File Path:<input type="text" name="file_path">
	<input type="radio" name="file_grouping" onclick="toggleFileUploaderMethodValue(this, event, 'temp-file-uploader', '');"  value="project_file">Project File
	<input type="radio" name="file_grouping" onclick="toggleFileUploaderMethodValue(this, event, 'temp-file-uploader', '');"  value="company_file">Company File
	<input type="radio" name="file_grouping" onclick="toggleFileUploaderMethodValue(this, event, 'temp-file-uploader', 'uploadTempFilesOnly');" value="temp_file">Temp File
	<!-- input type="radio" name="file_grouping" onclick="toggleTempFileFormUrl(this, event);" value="temp_file">Temp File -->
	<br>
	<input type="reset" value="    Reset Form    " name="Submit" tabindex="1002" onclick="window.location='modules-file-manager-form-reset.php{$queryString}'">&nbsp;&nbsp;
	<input name="Submit" onclick="submitUnitTestFileUploadForm(this, event);" tabindex="1001" type="submit" value="       Upload File       ">
	<input name="ajaxSubmit" onclick="ajaxFormSubmit(this, event);" tabindex="1003" type="button" value="Ajax Submit">
</td>
</tr>

</table>
</form>

<!-- Temp Files -->
<ul id="record_list_container--uploaded-temp-file" style="display: none;">
<!-- li id="uploaded-temp-file--unit-test-files--position--i" tempFileName="" tempFileUploadPosition="" type="hidden" value="" virtual_file_mime_type="" --><!-- /li -->
</ul>
{/if}
