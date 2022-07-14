{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
{else}	
<h2>Cloud File Manager Search</h2>

<ol>
	<li>
		<label for="filenameSearch">Filename: </label>
		<span class="ui-widget">
			<input name="filenameSearch" id="filenameSearch" style="width:300px;">
		</span>
		<span><input id="btnFilenameSearch" type="button" value="Search"><span>
	</li>
</ol>

<input name="filenameSearchID" id="filenameSearchID" type="hidden">

<table id="tblFileModule" border="1" width="100%" style="display:none;">
	<tr valign="top">
		<td>
			<div id="fileTreeMenu" rel="/"></div>
		</td>

		<td width="100%" align="center">
			<div id="infoContainer">
				<div id="fileDetails"></div>
				<div id="filePreview"></div>
			</div>
		</td>
	</tr>
</table>
{/if}
