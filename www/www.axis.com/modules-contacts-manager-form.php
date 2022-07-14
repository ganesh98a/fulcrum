<?php
/**
 * Contact Management.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['ajax'] = false;
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

require_once('modules-contacts-manager-functions.php');
require_once('lib/common/Validate.php');
require_once('lib/common/Address.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/PhoneNumber.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/Contact.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactToContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/Role.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

// DATABASE VARIABLES
$db = DBI::getInstance($database);
// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();

if (isset($get) && $get->contact_company_id) {
	$contact_company_id = $get->contact_company_id;
}

// PERMISSION VARIABLES
require_once('app/models/permission_mdl.php');
$userCanManageContacts = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contacts_manage');
$userCanExportContacts = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contacts_export');
$userCanImportContacts = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contacts_import');
$userCanManageMyContactRoles = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contact_roles_manage');
if($userRole =="global_admin")
{
	$userCanManageContacts = $userCanExportContacts = $userCanImportContacts = $userCanManageMyContactRoles= 1;
}

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link rel="stylesheet" href="/css/modules-contacts-manager.css">
<style>
.ui-autocomplete {
	overflow-y: auto;
	max-height: 150px;
	height: 150px;
	width: 300px;
}
#softwareModuleHeadline
{
	display:none;
}
</style>
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/generated/contact_companies-js.js"></script>
	<script src="/js/generated/contact_company_offices-js.js"></script>
	<script src="/js/generated/contacts-js.js"></script>
	<script src="/js/generated/contacts_to_roles-js.js"></script>
	<script src="/js/generated/projects_to_contacts_to_roles-js.js"></script>

	<script src="/js/modules-contacts-manager.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Contact Creation - MyFulcrum.com';
$htmlBody = '';


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

// Load a drop with this user's contact companies
$arrContactCompaniesByUserUserCompanyId = ContactCompany::loadContactCompaniesByUserUserCompanyId($database, $user_company_id);
$dropdownContactCompaniesList = '
	<select id="ddlContactCompanies" onchange="ddlContactCompanyChanged();">
		<option value="0">Please Select A Company / Vendor</option>
';
	foreach ($arrContactCompaniesByUserUserCompanyId AS $contact_company_id => $contactCompany) {
		if ($contactCompany->user_user_company_id == $contactCompany->contact_user_company_id) {
			$companyName = $contactCompany->contact_company_name . " (My Company)";
		} else {
			$companyName = $contactCompany->contact_company_name;
		}
		$dropdownContactCompaniesList .= '
			<option value="'.$contactCompany->contact_company_id.'">'.$companyName.'</option>
		';
	}
$dropdownContactCompaniesList .= '
	</select>
	<input id="userCanManageContacts" type="hidden" value="'.$userCanManageContacts.'">
';

// to load email list
$arrContactEmailByUserUserCompanyId = Contact::EmailContactbasedonUserCompany($database, $user_company_id);


$dropdownEmailCompaniesList = '
	<select id="ddlEmail" onchange="contactEmailChanged();">
		<option value="0" name ="">Please Select A Email</option>
';
	foreach ($arrContactEmailByUserUserCompanyId AS $contact_company_id => $contact) {
		
			$contactName = $contact['email'];
		
		$dropdownEmailCompaniesList .= '
			<option value="'.$contact['contact_company_id'].'" name="'.$contact['company'].'">'.$contactName.'</option>
		';
	}
$dropdownEmailCompaniesList .= '
	</select>
	
';
$template->assign('ddlContactCompaniesListDiv',$dropdownContactCompaniesList);
$template->assign('ddlEmailListDiv',$dropdownEmailCompaniesList);
// @todo: Get this from a contact company record for my comany
$myCompanyName = "";
$template->assign('myCompanyName',$myCompanyName);
$template->assign('userCanImportContacts',$userCanImportContacts);
$template->assign('userCanExportContacts',$userCanExportContacts);
// Tool tip help hints
require('template-assignments/main.php');

require_once('include/page-components/FineUploader.php');

$input = new Input();
$input->action = '/modules-import-admin-contact-uploader-ajax.php?method=uploadTempFilesOnly';
$input->method = 'uploadFiles';
// Create FileManagerFolder
$input->id = 'import_default';
$input->allowed_extensions = 'xlsx';
$input->folder_id = $image_photo_file_manager_folder_id;
$input->style="width:250px;";
$input->post_upload_js_callback = 'fileRefresh(arrFileManagerFiles);';
require_once('include/page-components/fileUploader.php');

$uploaderPhotos = buildFileUploader($input);

$uploadWindow = buildFileUploaderProgressWindow();
$liUploadedPhotos = '';

$fineUploaderTemplate = FineUploader::renderTemplate();
$template->assign('uploadWindow', $uploadWindow);
$template->assign('uploaderPhotos', $uploaderPhotos);
$template->assign('liUploadedPhotos', $liUploadedPhotos);

$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
$fineUploaderTemplate
END_HTML_JAVASCRIPT_BODY;
/*file uploader end*/

ob_start();
include "./modules-contacts-manager-help-hints.php";
$contactsManagerHelpHints = ob_get_clean();
$template->assign('contactsManagerHelpHints',$contactsManagerHelpHints);


//$template->assign('htmlMessages', $htmlMessages);

if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
	$htmlContent = $template->fetch('modules-contacts-manager-form-mobile.tpl');
} else {
	$htmlContent = $template->fetch('modules-contacts-manager-form.tpl');
}
$template->assign('htmlContent', $htmlContent);

//require_once('page-components/axis/footer_smarty.php');
$template->display('master-web-html5.tpl');
exit;
