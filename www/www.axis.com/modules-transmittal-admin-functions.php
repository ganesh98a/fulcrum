<?php
/**
 * TAM Module.
 */
/*View the template type in grid format*/
function renderTemplateTypeListView_AsHtml($userCanManageTAM = null,$database,$userRole)
{
	$incre_id=1;
	$TAMTableBobyContent = '';
	$db = DBI::getInstance($database);
	$query = "SELECT * FROM transmittal_types ORDER BY sort_order ASC";
	$db->execute($query);
	$records = array();
	
	while($row = $db->fetch())
	{
		$records[] = $row;
		$transmittal_admin_template_id = $row['id'];
		$transmittal_category = $row['transmittal_category'];
		$last_updated = Date::convertDateTimeFormat($row['last_updated'], 'html_form_datetime');
		if($userCanManageTAM == null && ($userRole !="global_admin")){
			$onclick = "";
			$cursorClass = "table-default-cursor";
		}else{
			$onclick = <<<OnclickFunction
			onclick="TAMs__loadTransmittalTemplateDialog('$transmittal_admin_template_id','$incre_id');"
OnclickFunction;
			$cursorClass = "";
		}
		$TAMTableBobyContent .= <<<TransmittalBodyContentRow
		<tr id="container--manage-transmittal_admin_template-record--$transmittal_admin_template_id" class="$incre_id" $onclick >
			<td>$incre_id</td>
			<td>$transmittal_category</td>
			<td>$last_updated</td>
		</tr>
TransmittalBodyContentRow;
$incre_id++;
	}
	$TAMTableView=<<<TransmittalTable
	<table id="transmittal_tmeplates-record" class="content TAMTableGrid $cursorClass" border="0" cellpadding="5" cellspacing="0" width="100%">
	<thead class="borderBottom">
		<tr>
		<th class="textAlignCenter">#</th>
		<th class="textAlignLeft">Template Name</th>
		<th class="textAlignLeft">Last edited</th>
		</tr>
	</thead>
	<tbody class="altColors">
		$TAMTableBobyContent
	</tbody>
	</table>
TransmittalTable;
return $TAMTableView;
}
/*Get the template content for dialog*/
function loadTransmittalAdminTemplatesDialog($database, $transmittal_admin_template_id, $tam_sequence_id){
	$db = DBI::getInstance($database);
	$query = "SELECT * FROM transmittal_types where id = $transmittal_admin_template_id";
	$db->execute($query);
	$records = array();
	$row = $db->fetch();
	$db->free_result();
	$query = "SELECT * FROM transmittal_admin_templates where template_type_id = $transmittal_admin_template_id";
	$db->execute($query);
	$records = array();
	$row_temp = $db->fetch();
	$tempcontent = $row_temp['template_content'];
	$templateTypeName=$row['transmittal_category'];
	$transmittal_admin_template_id=$transmittal_admin_template_id;
	$htmlContent = <<<END_HTML_CONTENT
<div class="TAM_table" id="record_creation_form_container--update-transmittal_admin-record--$transmittal_admin_template_id">
	<div class="TAM_table_dark_header">TAT #$tam_sequence_id &mdash; $templateTypeName</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="4">
		<tr>
		<td class="TAM_table_header2">Edit Content <div id="help-company-name" class="help-hint">?</div></td>
		<td width="50%"  class="TAM_table_header2">Content Preview <span class="spanOpenTab"><a class="OpenTab" target="_blank" id="OpenTab">Open Link In New Tab</span></a></td>
		</tr>
		<tr>
		<td colspan="1" class="TAM_table2_content">
			<textarea id="TAMeditor" name="TAMeditor" class="RFI_table2" onkeydown="LoadTAMSPDF();">$tempcontent</textarea><br>
			<div class="textAlignRight" style="margin-top:10px; font-size: 10pt">
			<label><input type="checkbox" name="autorefresh" id="autorefresh"> Auto Refresh</label>
				<input type="button" id="refreshPreview" value="Refresh Preview" style="font-size: 10pt;">&nbsp;
				<input type="button" value="Save Changes" style="font-size: 10pt;" onclick="TAMs__updateTransmittalAdminTemplateViaPromiseChain('update-transmittal_admin-record','$transmittal_admin_template_id')">
			</div>
		</td>
		<td rowspan="3">
				<div id="contentPreview" class="contentPreview"></div>
			</td>
		</tr>
	</table>
	<input type="hidden" id="$transmittal_admin_template_id" value="$transmittal_admin_template_id">
	<input id="update-transmittal_admin-record--transmittal_admin--template_type--$transmittal_admin_template_id" name="" class="TAM_table2" type="hidden" value="$templateTypeName" $duedatestatus>
</div>
<div id="dialogHelp"></div>

END_HTML_CONTENT;
	return $htmlContent;
}
?>
