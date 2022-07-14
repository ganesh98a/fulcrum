<?php
/**
 * SubContract  Invoice.
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
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/ContactCompany.php');
require_once('../templates/dropdown_tmp.php');
require_once('../controllers/subcontract_invoice_cntrl.php');
require_once('../models/subcontract_invoice_model.php');
require_once('../functions/subcontract_invoice.php');
require_once('page-components/fileUploader.php');





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
$currentlySelectedProjectTypeIndex = $session->getCurrentlySelectedProjectTypeIndex();

$config = Zend_Registry::get('config');



$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
// /* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;
// PERMISSION VARIABLES
require_once('../models/permission_mdl.php');

//Check the permisson for view delay
$userCanViewSubcontractInvoice = checkPermissionForAllModuleAndRole($database,'view_subcontract_invoice');
$userCanCreateSubcontractInvoice = checkPermissionForAllModuleAndRole($database,'create_subcontract_invoice');
$userCanManageSubcontractInvoice = checkPermissionForAllModuleAndRole($database,'manage_subcontract_invoice');
if($userRole != "global_admin"){
	if(!$userCanViewSubcontractInvoice && !$userCanCreateSubcontractInvoice && !$userCanManageSubcontractInvoice){
		$errorMessage = 'Permission denied.';
		$message->enqueueError($errorMessage, $currentPhpScript);
	}	
}else{
	$userCanViewSubcontractInvoice = 1;
	$userCanCreateSubcontractInvoice = 1;
	$userCanManageSubcontractInvoice = 1;
}

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);



if (!isset($htmlCss)) {
	$htmlCss = '<link href="../css/subcontract_invoice.css" rel="stylesheet">
	<link rel="stylesheet" href="../../css/fSelect.css">';
}
$htmlCss .= <<<END_HTML_CSS

END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	
	
	$htmlJavaScriptBody = 	'<script src="../js/subcontract_invoice.js"></script>
							<script src="../../js/generated/file_manager_files-js.js"></script>
							<script src="../../js/fSelect.js"></script>';
}

$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY

END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Subcontract Invoice Log - '.$userCompanyName;
$htmlBody = '';

$innerStructure = 1;
require_once("../../include/template-assignments/main.php");

/* Get the Dropdown Data -- Start*/
$res_vendor = getVendorArr($database, $user_company_id,$project_id);


$res_contract = getContractsArr($database,$user_company_id, $project_id);

$get_subcont_invoice = getSubContInvoice($database, $project_id,$userCanManageSubcontractInvoice,'','false',$user_company_id,$currentlyActiveContactId);
$get_subcont_invoice_SecTwo = getSubContInvoiceSecTwo($database, $project_id,$userCanManageSubcontractInvoice,'',$user_company_id,$currentlyActiveContactId);

$subcont_status = SubcontractInvoiceStatus($database,'subcontract_invoice_status');

// FileManagerFolder
	$virtual_file_path = '/Subcontract Invoice/Draft/';
	$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);


	// Convert to temp file upload with temp GUID
	$input = new Input();
	$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record';
	$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = $virtual_file_path;	
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadRequestForInformationAttachment';
	$input->allowed_extensions = 'pdf';
	$input->multiple = 'false';
	$input->post_upload_js_callback = "Sub__rfiDraftAttachmentUploaded(arrFileManagerFiles, 'container--request_for_information_attachments--create-request_for_information-record')";

	$fileUploader = buildFileUploader($input);
	$fileUploaderProgressWindow = buildFileUploaderProgressWindow();
	//* Get the Dropdown Data --End*/

	/* Project Mapped Customers - Start */
	$projectCustArr = getProjectCustomers($database,$user_company_id);
	$qb_cust_html = "<select id='qb_customer'>
						<option value=''>Select a QB Customer</option>";
	foreach($projectCustArr as $qb_customer_id => $qb_customer){
		$qb_cust_html .= "<option value='".$qb_customer_id."'>".$qb_customer."</option>";
	}
	$qb_cust_html .= "</select>";
	/* Project Mapped Customers - End */

	$supplierSel = "<div id='supitem'><select id='supplier_id' class='multi-drop'>
			<option value=''>ier</option>";
	$supplierSel .= "</select></div>";


$template->assign('fileUploader', $fileUploader);
$template->assign('fileUploaderProgressWindow',$fileUploaderProgressWindow);
$template->assign('vendorsel', $res_vendor);
$template->assign('contractsel', $res_contract);
$template->assign('user_company_id',$user_company_id);
$template->assign('get_subcont_invoice',$get_subcont_invoice);
$template->assign('get_subcont_invoice_SecTwo',$get_subcont_invoice_SecTwo);
$template->assign('project_id',$project_id);
$template->assign('htmlMessages',$htmlMessages);
$template->assign('subcont_status',$subcont_status);
$template->assign('userCanViewSubcontractInvoice',$userCanViewSubcontractInvoice);
$template->assign('userCanCreateSubcontractInvoice',$userCanCreateSubcontractInvoice);
$template->assign('userCanManageSubcontractInvoice',$userCanManageSubcontractInvoice);
$template->assign('currentlyActiveContactId',$currentlyActiveContactId);
$template->assign('qb_cust_html',$qb_cust_html);
$template->assign('supplierSel',$supplierSel);



$htmlContent = $template->fetch('subcontract-invoice.tpl');
$template->assign('htmlContent', $htmlContent); 
$template->display('master-web-html5.tpl');

?>
