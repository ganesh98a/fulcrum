<?php /* Smarty version Smarty-3.0.8, created on 2022-03-24 12:21:50
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-contacts-manager-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4617623c544e748106-76302894%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14b4b4a302cb2ae5aa1cceefd60f642d9abdc7e3' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-contacts-manager-form.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4617623c544e748106-76302894',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('contactsManagerHelpHints')->value;?>


<div>
<?php echo $_smarty_tpl->getVariable('ddlContactCompaniesListDiv')->value;?>

<?php echo $_smarty_tpl->getVariable('ddlEmailListDiv')->value;?>
 
<!--<input id="refreshCompanyDataId" style="display:none;" type="button" value="Refresh Company Data" onclick="ddlContactCompanyChanged();">-->

<div style="padding-bottom:15px;float:right"><input id="btnCreateNewCompany" type="button" value="Create Company " onclick="loadCreateContactCompanyDialog();">
<input id="btnArchivedcontact" type="button" value="Archived Contacts" onclick="loadArchivedContactDialog();">
<input id="btncontact" type="button" value="Contacts" onclick="loadContactDialog();">


</div>
</div>
<table width="100%" cellpadding="3" style="margin-top:10px; margin-bottom:10px;display:none;">
    <tr valign="top">
        <th style="padding-top:7px;" nowrap>COMPANY/VENDOR NAME:<div id="help-company-name" class="help-hint">?</div></th>
        <td style="padding-top:7px;"><input name="company" id="company" style="width:300px;"></td>
        <td><input id="btnCompanySearch" type="button" value="Search"></td>
        <td><input id="btnManageCompany" type="button" value="Manage Company"></td>
        <td width="100%" style="text-align:right; padding-right:10px;">&nbsp;</td>
    </tr>
</table>
        <input name="contact_company_id" id="contact_company_id" type="hidden">
        <input name="myCompanyName" id="myCompanyName" type="hidden" value="<?php echo $_smarty_tpl->getVariable('myCompanyName')->value;?>
">
        <input name="userCanExportContacts" id="userCanExportContacts" type="hidden" value="<?php echo $_smarty_tpl->getVariable('userCanExportContacts')->value;?>
">
        <input name="userCanImportContacts" id="userCanImportContacts" type="hidden" value="<?php echo $_smarty_tpl->getVariable('userCanImportContacts')->value;?>
">
        <table width="100%" id="complist" style="display:block;">
            <tr valign="top">
                <td colspan="2">
                    <div id="divCompanyInfo" style="display:none;"></div>
                </td>
            </tr>
            <tr valign="top">
                <td colspan="2">
                    <div id="divOfficeDetails" style="display:none;" class="fieldsetLeft"></div>
                    <div id="divOfficesList" style="display:none;" class="fieldsetLeft"></div>
                </td>
            </tr>
        </table>
        <table width="100%" id="contact_list" style="display:none;">
            <tr valign="top">
                <td width="300px" style="padding-right:20px;">
                    <div id="divEmployees" style="display:none;"></div>
                </td>
                <td>
                    <div id="divContactInformation" style="display:none;"></div>
                    <div id="divContactPermissions" style="display:none;"></div>
                </td>
            </tr>
        </table>
        <table width="100%" id="non_contact_list" style="display:none;">
            <tr valign="top">
                <td width="300px" style="padding-right:20px;">
                    <div id="divArchivedEmployees" style="display:none;"></div>
                </td>
                <td>
                    <div id="divArchivedContactInformation" style="display:none;"></div>
                    <div id="divArchivedContactPermissions" style="display:none;"></div>
                </td>
            </tr>
        </table>
        <div id="dialogHelp"></div>
        <div id="divCreateContactCompanyDialog" class="hidden"></div>
        <div id="divCreateContactCompanyOfficeDialog" class="hidden"></div>
        
        <div id="importContacts" class="importContacts" style="display:none;">
            <h2 style="margin-top:0;">Import </h2>
            <h3>Step - 1: Download the excel template <span class="fakeHref verticalAlignBottom" onclick="showHideDomElement('rfi_draft_help3');">(?)</span></h3>
                    <span id="rfi_draft_help3" class="displayNone verticalAlignBottom">
                        <h3 class="h3header">Instructions</h3>
                        <ul>
                            <li>Downloading and using the Default Excel Template will make the process easier since all the required information you may need to provide is mentioned here along with the format that the system will accept. Drag down the sample data to copy the cell format and enter your details.</li>
                        </ul>
                    </span>
            <p><button id="downloadExcelRef" class="downloadExcelRef btn-cmn" onclick="downlaodRef()">Downlaod</button></p>
            <h3>Step - 2: Select template  <span class="fakeHref verticalAlignBottom" onclick="showHideDomElement('rfi_draft_help');">(?)</span></h3>
            <span id="rfi_draft_help" class="displayNone verticalAlignBottom">
                        <div class="useDefaultTemplateInstruction">
                            <h4 class="h3header" style="margin:0px;">USE DEFAULT TEMPLATE</h4>
                            <ul>
                            	<li>Fill all the mandatory fields present in all 3 sheet- company ,  Office, Contacts ans upload it. Reset will be taken care by the system.</li>
                            </ul>
<h4 class="h3header" style="margin:0px;">USE MY TEMPLATE</h4>
                            <ul>
                            	<li>Any excel file you create can be uploaded provided it must meet the mentioned rules.</li>
                            </ul></div>
                            	<div class="useDefaultTemplateInstruction">
<h4 class="h3header" style="margin:0px;" >Rules</h4>
<ul style="list-style: none;">
<li>1. Excel file (XLSX) you create should have 3 sheets - Company, Office, Contacts(in same order)</li>
<li>2. All the mandatory fields within corresponding sheets should be available with data. Provide the Headings in 2nd row of the excel.</li>
<li>a. Mandatory fields for sheet- Company:Company</li>
<li>b. Mandatory Fields for sheet- Office :Company (should carry the same data you created in sheet 'company')</li>
<li>c. Mandatory fields for sheet- Contacts:Company(should carry the same data you created in sheet 'company'), Email</li>


<li>3. After uploading, we have shown the Redundant and Wrong data For Default Template.
    <p><div class='errorCode'><span class='alreadyExist'>( <div class='circleBlack'></div> ) - Data Already Exist.</span><span class='alreadyExist'>( <div class='circleRed'></div> ) - Data is Mandatory.</span><span class='alreadyExist'>( <div class='circleRed'></div>&nbsp;<div class='circleRed'></div> ) - Invalid Data.</span> </div></p>
</li>


		<input name="contact_company_id" id="contact_company_id" type="hidden">
		<input name="myCompanyName" id="myCompanyName" type="hidden" value="<?php echo $_smarty_tpl->getVariable('myCompanyName')->value;?>
">
		<input name="userCanExportContacts" id="userCanExportContacts" type="hidden" value="<?php echo $_smarty_tpl->getVariable('userCanExportContacts')->value;?>
">
		<input name="userCanImportContacts" id="userCanImportContacts" type="hidden" value="<?php echo $_smarty_tpl->getVariable('userCanImportContacts')->value;?>
">

                              
                            </ul>
                        </div></span>
            <div class="optionColumn">
                <div class="optionColumnIn">
                    <label><input type="radio" name="importOption" value="useDefaultTemplate" checked class="radioImport" onchange="contactImportData()">Use Default Template
                   </label>
                    <label><input type="radio" name="importOption" onchange="contactImportData()" value="useMyTemplate" class="radioImport">Use My Template
                    
                </label>
                </div>
            </div>
            <!-- Default Template -->
            <div class="UseDefaultTemplate" id="UseDefaultTemplateSH">
                <input id="defaultTemplatePath" name="defaultTemplatePath" type="hidden" value="xlsx/My Template.xlsx">
                <input type="hidden" id="defaultTemplate" name="defaultTemplate" value="">
                <input type="hidden" id="defaultTemplateErrorValid" name="defaultTemplateErrorValid" value="">
                <div class="optionColumn">
                    <div class="optionColumnIn">
                        <?php echo $_smarty_tpl->getVariable('uploadWindow')->value;?>

                        <div id="uploaderJobsitePhotos"></div>
                        <?php echo $_smarty_tpl->getVariable('uploaderPhotos')->value;?>

                        <ul id="record_list_container--manage-file-import-record" class="ulUploadedFiles" style="margin:10px 0 5px 0px;list-style:none;padding:0;"><?php echo $_smarty_tpl->getVariable('liUploadedPhotos')->value;?>
</ul>
                        
                    </div>
                    <div class="optionColumnIn">
                        <input id="importSubmit" type="button" value="Proceed">
                    </div>
                    
                    </div>
                    <div id="defaultTemplateError"></div>
                </div>
                <!-- Use my template -->
                <div class="UseDefaultTemplate UseMyTemplate" id="UseMyTemplateSH" style="">
                    <input type="file" name="excelupload" id="excelupload" onchange="uploadexcel(this.id,this.value)">                    
                    
                    <div id="excelval"></div>
                </div>                
            </div>
            <?php echo $_smarty_tpl->getVariable('fineUploaderTemplate')->value;?>


