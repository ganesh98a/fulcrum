<?php
/**
 * User profile.
 *
 */
$init['access_level'] = 'global_admin';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

require_once('lib/common/PageComponents.php');
require_once('lib/common/SoftwareModule.php');
require_once('lib/common/UserCompanyToSoftwareModule.php');
require_once('lib/common/ImageManagerImage.php');



// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

// Load a list of all software_modules
$arrSoftwareModulesTmp = SoftwareModule::loadSoftwareModulesList($database);
$arrSoftwareModuleObjects = $arrSoftwareModulesTmp['objects_list'];
$arrSoftwareModuleOptions = $arrSoftwareModulesTmp['options_list'];
$arrSelectedSoftwareModuleCheckboxes = array();

$arrAllSoftwareModules = $arrSoftwareModuleObjects;

// retrieve any postback data from the session store.
$postBack = Egpcs::sessionGet($applicationLabel, 'admin-user-company-creation-form.php', 'post');
/* @var $postBack Egpcs */
// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
$payingCustomerCheckboxChecked = '';
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	$managed_user_company_id = $postBack->ddl_user_company_id;
	$user_company_name = $postBack->user_company_name;
	$employer_identification_number = $postBack->employer_identification_number;
	$construction_license_number = $postBack->construction_license_number;
	$construction_license_number_expiration_date = $postBack->construction_license_number_expiration_date;
	$paying_customer_flag = $postBack->paying_customer_flag;
	if (isset($paying_customer_flag) && $paying_customer_flag == 'on') {
		$payingCustomerCheckboxChecked = 'checked';
	}

	// software_modules
	if ($postBack->software_modules) {
		$arrSoftwareModules = $postBack->software_modules;
		foreach ($arrSoftwareModules as $software_module_id) {
			$arrSelectedSoftwareModuleIds[$software_module_id] = 1;
		}
	} else {
		$arrSelectedSoftwareModuleIds = array();
	}

	// software_modules

	// Construction License Number Expiration Date
	if ($postBack->construction_license_number_expiration_date && is_int(strpos('-', $postBack->construction_license_number_expiration_date))) {
		$tmpDate = $postBack->construction_license_number_expiration_date;
		$arrTmpDate = explode('-', $tmpDate);
		$tempDate = $arrTmpDate[1] . '/' . $arrTmpDate[2] . '/' . $arrTmpDate[0];
		$postBack->construction_license_number_expiration_date = $tempDate;
	}
} else {
	// Check if update mode
	if (isset($get) && $get->mode && ($get->mode == 'update')) {
		$managed_user_company_id = $get->managed_user_company_id;
		$uc = UserCompany::findUserCompanyByUserCompanyId($database, $managed_user_company_id);
		/* @var $uc UserCompany */

		$user_company_name = $uc->user_company_name;
		$employer_identification_number = $uc->employer_identification_number;
		$construction_license_number = $uc->construction_license_number;
		$construction_license_number_expiration_date = $uc->construction_license_number_expiration_date;
		$paying_customer_flag = $uc->paying_customer_flag;
		if (isset($paying_customer_flag) && $paying_customer_flag == 'Y') {
			$payingCustomerCheckboxChecked = 'checked';
		}

		// software_modules
		$arrSelectedSoftwareModuleIds = UserCompanyToSoftwareModule::loadSoftwareModuleIdListByUserCompany($database, $managed_user_company_id);
		$arrSelectedSoftwareModuleCheckboxes = array_keys($arrSelectedSoftwareModuleIds);

		// Construction License Number Expiration Date
		if ($construction_license_number_expiration_date) {
			$tmpDate = $construction_license_number_expiration_date;
			$arrTmpDate = explode('-', $tmpDate);
			$tempDate = $arrTmpDate[1] . '/' . $arrTmpDate[2] . '/' . $arrTmpDate[0];
			$construction_license_number_expiration_date = $tempDate;
		}
	} else {
		$managed_user_company_id = '';
		$user_company_name = '';
		$employer_identification_number = '';
		$construction_license_number = '';
		$construction_license_number_expiration_date = '';
		$payingCustomerCheckboxChecked = '';
		$arrSelectedSoftwareModuleCheckboxes = array();

		// software_modules
		$softwareModule = new SoftwareModule($database);
		$softwareModule->setAttributes(array('id'));
		$key = array(
			'purchased_module_flag' => 'N',
			''
		);
		$arrSelectedSoftwareModuleIds = SoftwareModule::loadSoftwareModuleIdListByPurchasedModuleFlag($database, 'N', 'N');
		$arrSelectedSoftwareModuleCheckboxes = array_keys($arrSelectedSoftwareModuleIds);
	}
}

$htmlCheckboxes = '';
foreach ($arrAllSoftwareModules as $software_module_id => $softwareModule) {
	/* @var $softwareModule SoftwareModule */

	$software_module_label = $softwareModule->software_module_label;
	$purchased_module_flag = $softwareModule->purchased_module_flag;

	if (isset($arrSelectedSoftwareModuleIds[$software_module_id])) {
		$checked = ' checked';
	} else {
		$checked = '';
	}

	if ($purchased_module_flag == 'Y') {
		if (($software_module_label <> 'Application Audit Trails') && ($software_module_label <> 'Unit Testing')) {
			$checkboxClass = 'payingCustomerModuleCheckbox';
		}
	} else {
		$checkboxClass = '';
	}

	$htmlCheckboxes .=
'<input class="'.$checkboxClass.'" type="checkbox" value="'.$software_module_id.'" name="software_modules[]"'.$checked.'> '.$software_module_label.'<br>
';
}
$template->assign('htmlCheckboxes', $htmlCheckboxes);


$htmlTitle = 'User Admin';
$htmlBody = "";

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS

<style>
input[type=checkbox] {
	display: inline-block;
	margin-right: 4px;
	vertical-align: baseline;
}
</style>
END_HTML_CSS;

$htmlCss .= <<<END_HTML_CSS
<link href="/css/modules-jobsite-daily-logs.css" rel="stylesheet">
	<link href="/css/modules-daily-construction-report.css" rel="stylesheet">
END_HTML_CSS;
if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
	<script src="/js/modules-company-company-creation.js"></script>
<script>
(function($) {
	$(document).ready(function() {
		$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
	});
})(jQuery);

function checkAllPayingCustomerModules(element)
{
	var checked = $(element).is(':checked') || false;
	$(".payingCustomerModuleCheckbox").prop('checked', checked);
}
</script>
END_HTML_JAVASCRIPT_BODY;


require('template-assignments/main.php');
// Input for File Uploader HTML Widget
require_once('include/page-components/FineUploader.php');
require_once('lib/common/ImageManagerFolder.php');

$input = new Input();
$input->action = '/modules-image-manager-image-uploader-ajax.php';
$input->method = 'uploadFiles';
// Create FileManagerFolder
$virtual_file_path = '/GC Logos/';

$imagePhotoUploadFileManagerFolder = ImageManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $virtual_file_path);
/* @var $imagePhotoUploadFileManagerFolder imageManagerFolder */

$image_photo_file_manager_folder_id = $imagePhotoUploadFileManagerFolder->file_manager_folder_id;
$input->id = 'photo_upload';
$input->allowed_extensions = 'gif,jpg,jpeg,png';
$input->folder_id = $image_photo_file_manager_folder_id;
$input->virtual_file_path = $virtual_file_path;
$input->style="width:170px;";
$input->post_upload_js_callback = 'ImageLogoRefresh(arrFileManagerFiles);';
require_once('include/page-components/fileUploader.php');

$uploaderPhotos = buildFileUploader($input);

$uploadWindow = buildFileUploaderProgressWindow();
$liUploadedPhotos = '';
if($managed_user_company_id!=''){
	$db->begin();
	$query = "select ctl.*,imi.* ".
	"FROM `contacts_to_logo` ctl ".
	"INNER JOIN `image_manager_images` imi ON imi.id = ctl.image_manager_image_id ".
	"WHERE ctl.`user_company_id` = $managed_user_company_id ";
	$db->execute($query);
	$row = $db->fetch();
	$image_manager_image_id = $row['image_manager_image_id'];
	$virtual_file_name = $row['virtual_file_name'];
	$file_location_id = $row['file_location_id'];
	$db->free_result();
	if($image_manager_image_id!=''){
	$imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);
	$cdnFileUrl = $imageManagerImage->generateUrl();
	// if(is_file($cdnFileUrl))
	$liUploadedPhotos .= <<<END_LI_UPLOADED_FIELD_REPORTS
	<li>
		<a onclick="deleteLogoPhoto('$image_manager_image_id');" class="entypo-cancel-circled"></a>
		<a href="$cdnFileUrl" target="_blank">$virtual_file_name</a>
	</li>
END_LI_UPLOADED_FIELD_REPORTS;
}else{
		$liUploadedPhotos = '<li id="liUploadedPhotoPlaceholder">No uploads yet.</li>';
	}
}else{
	$image_manager_image_id = '';
	$liUploadedPhotos = '<li id="liUploadedPhotoPlaceholder">No uploads yet.</li>';
}
$fineUploaderTemplate = FineUploader::renderTemplate();
$template->assign('image_manager_image_id', $image_manager_image_id);
$template->assign('uploadWindow', $uploadWindow);
$template->assign('uploaderPhotos', $uploaderPhotos);
$template->assign('liUploadedPhotos', $liUploadedPhotos);

$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
$fineUploaderTemplate
END_HTML_JAVASCRIPT_BODY;
/*file uploader end*/

$template->assign('queryString', $uri->queryString);

// user_companies table
$template->assign('user_company_name', $user_company_name);
$template->assign('employer_identification_number', $employer_identification_number);
$template->assign('construction_license_number', $construction_license_number);
$template->assign('construction_license_number_expiration_date', $construction_license_number_expiration_date);
$template->assign('paying_customer_flag', $payingCustomerCheckboxChecked);


// user_companies_to_software_modules
$arrSoftwareModuleCheckboxes = $arrSoftwareModuleOptions;
$template->assign('arrSoftwareModuleCheckboxes', $arrSoftwareModuleCheckboxes);
$template->assign('arrSelectedSoftwareModuleCheckboxes', $arrSelectedSoftwareModuleCheckboxes);


// Load a list of User Companies
$arrTmp = UserCompany::loadUserCompaniesList($database);
$arrUserCompanyOptions = $arrTmp['options_list'];
$arrTemp = array('' => 'Please Select a Registered Company to Edit');
$arrUserCompanyOptions = $arrTemp + $arrUserCompanyOptions;
$selectedUserCompany = $managed_user_company_id;
$template->assign('selectedUserCompany', $selectedUserCompany);
$template->assign('arrUserCompanyOptions', $arrUserCompanyOptions);
$dropdownUserCompanyListOnChange = 'window.location=\'admin-user-company-creation-form.php?mode=update&managed_user_company_id=\'+(this.options[this.selectedIndex].value)';
$template->assign('dropdownUserCompanyListOnChange', $dropdownUserCompanyListOnChange);

// Query strings for new and edit cases
if ($uri->queryString) {
	$createUserCompanyQueryString = $uri->queryString . '&mode=insert';
	$editUserCompanyQueryString = $uri->queryString . '&mode=update';
} else {
	$createUserCompanyQueryString = '?mode=insert';
	$editUserCompanyQueryString = '?mode=update';
}
$template->assign('createUserCompanyQueryString', $createUserCompanyQueryString);
$template->assign('editUserCompanyQueryString', $editUserCompanyQueryString);

$htmlContent = $template->fetch('admin-user-company-creation-form.tpl');
$template->assign('htmlContent', $htmlContent);

$template->display('master-web-html5.tpl');
exit;
