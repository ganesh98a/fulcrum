<?php /* Smarty version Smarty-3.0.8, created on 2022-07-13 13:41:22
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-file-manager-file-browser.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3228462ceaf62c8b2c3-28087506%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b817b82a552ec3b5828abd0314795a1075c508f9' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-file-manager-file-browser.tpl',
      1 => 1632488495,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3228462ceaf62c8b2c3-28087506',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('rightClickMenu')->value;?>


<form id="windowNewFolder" title="Create New Folder" style="display:none;">
	<table>
		<tr>
			<td>
				Parent Folder: <span id="parentFolderName"></span>
			</td>
		</tr>
		<tr>
			<td>
				<input id="newFolderName" name="newFolderName" type="text" onkeydown="newFolderNameKeyDown(event);" onkeyup="validateFilePath(this);">
				<input id="parent_file_manager_folder_id" name="parent_file_manager_folder_id" type="hidden">
			</td>
		</tr>
	</table>
</form>
<form id="windowGetLink" title="Get Link" style="display:none;">
	<table>
		<tr>
			<td>
				<b>Copy this link:</b> <span id="linkPath"></span>
			</td>
		</tr>
	</table>
</form>
		<?php if ((!$_smarty_tpl->getVariable('guest')->value)){?>

<table border="0" cellpadding="5" style="width:100%;">
	<tr>
		<td>
			<input id="btnUpload" type="button" value="Upload" onclick="uploadButtonClicked(0);">
		</td>
		<td>
			<input id="btnDownload" type="button" value="Download" onclick="downloadRightClickSelected();">
		</td>
		<td>
			<input id="btnFolder" type="button" value="New Folder" onclick="newFolderButtonClicked();">
		</td>
		<td>
			<input id="btnRename" type="button" value="Rename" onclick="renameButtonClicked();">
		</td>
		<td style="display:none;">
			<input id="btnMove" type="button" value="Move" onclick="notYetImplemented();">
		</td>
		<td>
			<input id="btnDelete" type="button" value="Delete" onclick="deleteButtonClicked();">
		</td>
		<td>
			<input id="btnRestore" type="button" value="Restore" style="display:none;" onclick="restoreButtonClicked();">
		</td>
		<td>
			<input id="btnToggleDetails" type="button" value="Show Info" onclick="toggleFileSystemDetails();">
		</td>
		<td align="right" style="width:100%;">
			<input name="filenameSearch" id="filenameSearch" type="text" onclick="filenameSearchClicked();">
		</td>
	</tr>
</table>
<?php }?>


<table id="tblFileModule" border="0" width="100%">
	<tr valign="top">
		<td id="tdFileTreeMenu" style="width:350px;">
			<div id="fileTreeMenu" rel="/"></div>
		</td>
		<td>
			<div id="infoContainer">
				<div id="fileDetails" style="display:none;"></div>
				<div id="filePreview" style="width:100%;"></div>
			</div>
		</td>
	</tr>
</table>

<div id="uploadProgressWindow" class="uploadResult" style="display: none;">
	<h3>FILE UPLOAD PROGRESS: <input type="button" value="Close File Progress Window" onclick="document.getElementById('uploadProgressWindow').style.display='none';"></h3>
	<ul id="UL-FileList" class="qq-upload-list"></ul>
	<span id="uploadProgressErrorMessage"></span>
</div>
