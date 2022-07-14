<?php

/**
 * Roles permission  Module.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = true;
$init['get_maxlength'] = 2048;
$init['get_required'] = false;
$init['https'] = false;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['skip_always_include'] = false;
$init['skip_session'] = false;
$init['skip_templating'] = false;
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Message.php');
require_once('page-components/fileUploader.php');
// require_once('../controllers/permission_cntrl.php');
// require_once('../models/permission_mdl.php');

$message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;
// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();


$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="../../esignature/sign_src/css/jquery.signaturepad.css" rel="stylesheet">

END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}

$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="../../esignature/sign_src/js/numeric-1.2.6.min.js"></script> 
<script src="../../esignature/sign_src/js/bezier.js"></script>
<script src="../../esignature/sign_src/js/texthtml2canvas.js"></script>
<script src="../../esignature/sign_src/js/json2.min.js"></script>
<script src="../../esignature/sign_src/js/jquery.signaturepad.js"></script>

<script src="../js/account-management-esign.js"></script>
<script src="../js/generated/file_manager_files-js.js"></script>

END_HTML_JAVASCRIPT_BODY;
$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'MY E-Signature - '.$currentlySelectedProjectName;
$htmlBody = '';
$dummyId = Data::generateDummyPrimaryKey();

	
if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
} 
	$filename = md5($currentlyActiveContactId);
	$config = Zend_Registry::get('config');	
	$file_manager_base_path = $config->system->file_manager_base_path;
	$save = $file_manager_base_path.'backend/procedure/';
	
	$signfile_name = $save.$filename.'.png';


	$filegetcontent = file_get_contents($signfile_name);
	$base64 = 'data:image;base64,' . base64_encode($filegetcontent);
	if($filegetcontent =="")
	{
		$dispcheck ="display:none;";
	}else
	{
		$dispcheck ="";
	}
	$db = DBI::getInstance($database);
	$query ="Select * from  signature_data where `contact_id`= ?";
	$arrValues = array($currentlyActiveContactId);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$updated_date = $row['date'];
	$type = $row['type'];
	$db->free_result();

	//to check which method user had signed
	$uploadstyle = ($type=='1')?"display:block;":"display:none;";
	$drawstyle = ($type=='2')?"display:block;":"display:none;";
	$imgstyle = ($type=='3')?"display:block;":"display:none;";

	$uploadcheck = ($type=='1')?"checked='true'":"";
	$drawcheck = ($type=='2')?"checked='true'":"";
	$imgcheck = ($type=='3')?"checked='true'":"";
	

	if($updated_date !="")
	{
		$dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $updated_date);
		$updated_date = $dateObj->format('m/d/Y');
	}
	

//For Esignature
	// To upload a image
	$input = new Input();
	$input->id = 'uploader--esignature';
	$input->folder_id = '';
	$input->project_id = $project_id;
	$input->virtual_file_path = '/Subcontract Change Order/Attachments/';
	$input->prepend_date_to_filename = true;
	$input->action = '/esignature/sign_src/save_sign.php';
	$input->method = 'uploadimgforesign';
	$input->allowed_extensions = 'gif,jpg,jpeg,png';
	$input->post_upload_js_callback = "loadpreviewAfterimgupload()";
	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

	$signdata = <<<Table_Date_Through_End
	<label class="headsle" style="font-size:20px;">E-Signature</label>
	<table id="signTblTabularData" class="detailed_week content  
	signature-table-head cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
		<tr class="">
        <td colspan='2' class="" style="font-weight: bold;padding-bottom: 15px;padding-top: 10px;">How would you like to create your signature?</td>
         </tr>
         <tr class="">
         <td class="">
         <label class="DCRtext"><input type="radio" value="type_my_signature" name="signset" class="radioLable" onclick="signsetchanges()" $uploadcheck>Type my signature</label></td>
       
          </tr>
         <tr class="">
          <td class="">
         <label class="DCRtext"><input type="radio" value="draw_signimage" name="signset" class="radioLable" onclick="signsetchanges()" $drawcheck>Draw my signature</label></td>
          </tr>
         <tr class="">
          <td class="">
         <label class="DCRtext"><input type="radio" value="upload_signimage" name="signset" class="radioLable" onclick="signsetchanges()" $imgcheck >Use a image</label></td>
       
      	</tr>
      	</table>

 	<div id="upload_signimage" class="upload_signimage uploadimg-sinature textAlignCenter actions" style="margin-top:20px;$imgstyle">
		{$fileUploader}
		{$fileUploaderProgressWindow}
		<div>
		<img src="$base64" class="sign-preview" width="300px" height="100px" style="margin:0px 0px 0px 100px;$dispcheck"/>
		<div id="signdata" style="margin-top: 7px;font-size: 12px;margin-left: 60px;">Last Updated : <div class="eupdatedate" style="display: inline-block;">$updated_date</div></div></div>
	</div>

	<div id="draw_signimage" class="draw_signimage textAlignCenter actions draw-mysign-section" style="margin-top:20px;width:800px;$drawstyle" >
	
		<div id="signArea" style="width:40%;">
		<h4 class="tag-ingo">Put signature below,</h4>
		<div class="sig sigWrapper" style="height:auto;float:left;">
		<div class="typed"></div>
		<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
		</div>
		</div>

		<div class="sign-container" >
		<img src="$base64" class="sign-preview" width="300px" height="100px" style="$dispcheck"/>
		<div id="signdata" style="margin-top: 7px;font-size: 12px;">Last Updated : <div class="eupdatedate" style="display: inline-block;">$updated_date</div></div>
		</div>
		
		<div class="textAlignCenter actions" style="margin-top:20px;">
		<input type="button" id="btnSaveSign" value="Save Signature" onclick="saveDrawSign(event)">
		<input type="button" id="btnClearSign" value="Clear" onclick="ToclearDrawSign()">
		</div>
		</div>


 <div id="type_my_signature" class="type_my_signature enter-name-signsection" style="$uploadstyle">
 <label style="font-weight: bold;width: 190px;text-align: left;">Enter Your Name:</label>
 <input type="text" class="RFI_table2 required target signtext" id="html-content-holder" onkeyup="showTextPreview(this.value)"> 		
 <div class="" style="width: 100%;overflow: hidden;text-align: center;margin: 25px 0 0;">
    <label style="font-weight: bold;width: 190px;text-align: left;">Review Your Signature:</label>
    <div id="previewImage" style="float:left;">
    </div>
    </div>
    <div style="width: 100%;margin: 25px 0 15px 205px;overflow: hidden;">
    <input type="button" id="btn-Convert-Html2Image" value="Save Signature" onclick="saveTextAsSign()">
    </div>
 </div>

Table_Date_Through_End;







$innerStructure = 1;
require("../../include/template-assignments/main.php");

$template->assign('signdata', $signdata);
$template->assign('updated_date', $updated_date);



$htmlContent = $template->fetch('esignature_template.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

exit;



