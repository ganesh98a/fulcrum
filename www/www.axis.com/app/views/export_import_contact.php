<?php
/**
 * Export / Import  Module.
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

require_once('../models/permission_mdl.php');
require_once('../controllers/export_import_contact_cntrl.php');




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



$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
// /* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;
// PERMISSION VARIABLES
require_once('../models/permission_mdl.php');

$userCanExportContacts = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contacts_export');
$userCanImportContacts = checkPermissionForAllModuleAndRole($database,'admin_contacts_my_contacts_import');


if($userRole =="global_admin")
{
    $userCanExportContacts = $userCanImportContacts =  1;
}

if(!$userCanExportContacts && !$userCanImportContacts)
{
    $errorMessage = 'Permission denied.';
    $message->enqueueError($errorMessage, $currentPhpScript);
}

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);


if (!isset($htmlCss)) {
	$htmlCss = '<link href="../css/export_import_contact.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/fSelect.css">
    ';
}
$htmlCss .= <<<END_HTML_CSS

END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
    $htmlJavaScriptBody = 	'';
}

$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
    <script src="../../js/fSelect.js"></script>
    <script src="../js/export_import_contact.js"></script>
    <script src="../../js/generated/file_manager_files-js.js"></script>
    <script>
    (function($) {
      $(function() {
        showSpinner();
        $('.mutipleselect').fSelect({
            placeholder: 'Select Contact Companies',
            numDisplayed: 2,
            overflowText: '{n} Companies Selected'
        });
        hideSpinner();
      });
    })(jQuery);
  </script>
    
END_HTML_JAVASCRIPT_BODY;
$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Export  / Import Contact - MyFulcrum.com';
$htmlBody = '';

$innerStructure = 1;
require("../../include/template-assignments/main.php");

    // Convert to temp file upload with temp GUID
    require_once('../../include/page-components/FineUploader.php');

    $input = new Input();
    $input->id = 'import_default';
    $input->allowed_extensions = 'xlsx';
    $input->style="width:250px;";
    $input->action = '/modules-import-admin-contact-uploader-ajax.php?method=uploadTempFilesOnly';
    $input->method = 'uploadFiles';
    $input->post_upload_js_callback = 'fileRefresh(arrFileManagerFiles);';
    require_once('../../include/page-components/fileUploader.php');

    $fileUploader = buildFileUploader($input);
    $fileUploaderProgressWindow = buildFileUploaderProgressWindow();
    //* Get the Dropdown Data --End*/


    $liUploadedPhotos = '';
    $fineUploaderTemplate = FineUploader::renderTemplate();
    $htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
$fineUploaderTemplate
END_HTML_JAVASCRIPT_BODY;
    $importHtmlContent = import_section($database, $user_company_id, $fileUploader,$fileUploaderProgressWindow, $liUploadedPhotos, $userCanExportContacts, $userCanImportContacts);

$template->assign('htmlMessages',$htmlMessages);
$template->assign('importHtmlContent', $importHtmlContent); 

$htmlContent = $template->fetch('export_import_contact.tpl');
$template->assign('htmlContent', $htmlContent); 
$template->display('master-web-html5.tpl');

?>
