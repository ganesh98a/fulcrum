<?php
try {


/*
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['display'] = true;
*/

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');
require_once('lib/common/RetentionDraws.php');
require_once('lib/common/DrawSignatureType.php');
require_once('lib/common/RetentionSignatureBlocks.php');
require_once('lib/common/RetentionSignatureBlocksConstructionLender.php');
require_once('lib/common/DrawActionTypeTemplates.php');
require_once('lib/common/DrawFileManagerFiles.php');
require_once('lib/common/RetentionDrawFileManagerFiles.php');
require_once("dompdf/dompdf_config.inc.php");
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/Project.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/UserCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/Logo.php');
require_once('lib/common/ImageManagerImage.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/Format.php');
require_once('lib/common/Contact.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/ContractingEntities.php');

require_once('modules-draw-signature-block-functions.php');
require_once('modules-draw-list-function.php');

$user_company_id = $session->getUserCompanyId();
$currently_active_contact_id = $session->getCurrentlyActiveContactId();

$ret_id = intVal($get->ret_id);
$application_number = intVal($get->ret_app_id);
$draw_action_type_id = intVal($get->draw_action_type_id);
$draw_action_type_option_id = intVal($get->draw_action_type_option_id);

$last_draw_id = RetentionDraws::findLastDrawIdforRetention($database,$ret_id);
$draw_application_number = DrawItems::getDrawApplicationNumber($database,$last_draw_id);

/* get retention*/
$getDrawArr = RetentionDraws::findById($database, $ret_id);
$drawThroughDate = $getDrawArr->through_date;
$drawThroughDateFormat = date('m-d-Y', strtotime($drawThroughDate));
$drawStatus = $getDrawArr->status;
$drawIsDeletedFlag = $getDrawArr->is_deleted_flag;
$drawEntityId = $getDrawArr->contracting_entity_id;

/*session value*/
$project_id = $session->getCurrentlySelectedProjectId();
$project = Project::findProjectByIdExtended($database, $project_id);
$corDisplay = $project->COR_type;

$contact = new Contact($database);
$key = array('id' => $currently_active_contact_id);
$contact->setKey($key);
$contact->load();
$contact->convertDataToProperties();
$currentUserName = $contact->getContactFullName();


$projectOwnerName = $project->project_owner_name;
$projectContractDate = $project->project_contract_date;
if($projectContractDate != '0000-00-00' && $projectContractDate != ''){
	$projectContractDate = date('m/d/Y', strtotime($projectContractDate));
} else {
	$projectContractDate = '';
}
$periodTo = date('m/d/Y');
$projectName = $project->project_name;
$project_address_line_1 = $project->address_line_1;
$project_address_city = $project->address_city;
$project_address_state_or_region = $project->address_state_or_region;
$project_address_county = $project->address_county;
$project_address_postal_code = $project->address_postal_code;
$project_address_postal_code_extension = $project->address_postal_code_extension;
$addressArr = array();
if($project_address_line_1 != '') {
	$addressArr[] = $project_address_line_1;
}
if($project_address_city != '') {
	$addressArr[] = $project_address_city;
}
if($project_address_state_or_region != '') {
	$addressArr[] = $project_address_state_or_region;
}

$arrImplode = implode(', ', $addressArr);
$projectAddressHtml = <<<PROJECTADDRESS
$arrImplode $project_address_postal_code
PROJECTADDRESS;
$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $project->user_company_id);
  // /* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$loadContactCompanyOfficesByContactCompanyIdOptions = new Input();
$loadContactCompanyOfficesByContactCompanyIdOptions->forceLoadFlag = true;
$arrGCContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $project->user_company_id, $loadContactCompanyOfficesByContactCompanyIdOptions);

$officeAddressHtml = '';
$i = 0;
foreach($arrGCContactCompanyOffices as $officeId => $officeAddress) {
	if($i > 0){
		break;
	}
	$office_address_line_1 = $officeAddress->address_line_1;
	$office_address_line_2 = $officeAddress->address_line_2;
	$office_address_city = $officeAddress->address_city;
	$office_address_state_or_region = $officeAddress->address_state_or_region;
	$office_address_country = $officeAddress->address_country;
	$office_address_postal_code = $officeAddress->address_postal_code;
	$addressOfficeArr = array();
	if($office_address_line_1 != '') {
		$addressOfficeArr[] = $office_address_line_1;
	}
	if($office_address_line_2 != '') {
		$addressOfficeArr[] = $office_address_line_2;
	}
	if($office_address_city != '') {
		$addressOfficeArr[] = $office_address_city;
	}
	if($office_address_state_or_region != '') {
		$addressOfficeArr[] = $office_address_state_or_region;
	}
	$arrImplodeOff = implode(', ', $addressOfficeArr);
	$officeAddressHtml = <<<PROJECTADDRESS
	$arrImplodeOff $office_address_postal_code
PROJECTADDRESS;
	$i++;
}

$uri = Zend_Registry::get('uri');

$htmlContentCss = <<<HTMLCONTENT
<link href="{$uri->http}css/draw-print-pdf.css" rel="stylesheet" type="text/css">
HTMLCONTENT;

// get Signature Blocks
$loadSignatureBlockOptions = new Input();
$loadSignatureBlockOptions->forceLoadFlag = true;
$getAllDrawSignatureBlockArr = RetentionSignatureBlocks::loadAllRetentionSignatureBlocks($database, $ret_id, $loadSignatureBlockOptions);

$arrSignatureBlockList = array();
$contractorName = "";
$ownerName = "";
$architectName = "";

foreach($getAllDrawSignatureBlockArr as $signatureBlockId => $signatureBlock) {
	$signature_type_id = $signatureBlock->signature_type_id;
	$arrSignatureBlockList[$signature_type_id]['signature_block_description'] = $signatureBlock->signature_block_description;
	if($signature_type_id == 1 && $signatureBlock->signature_block_description == 'N') {
		$arrSignatureBlockList[$signature_type_id]['signature_block_description'] = $userCompanyName;
	}
	if($signature_type_id == 2 && $signatureBlock->signature_block_description == 'N') {
		$arrSignatureBlockList[$signature_type_id]['signature_block_description'] = $projectOwnerName;
	}
	$arrSignatureBlockList[$signature_type_id]['signature_block_id'] = $signatureBlock->signature_block_id;
	$arrSignatureBlockList[$signature_type_id]['signature_type_id'] = $signatureBlock->signature_type_id;
	
	$arrSignatureBlockList[$signature_type_id]['enable_flag'] = $signatureBlock->enable_flag;
	$arrSignatureBlockList[$signature_type_id]['signature_block_desc_update_flag'] = $signatureBlock->signature_block_desc_update_flag;
	$signBlockConstructionLender = $signatureBlock->getSignatureBlockConstructionLender();

	if($signature_type_id == 5 && isset($signBlockConstructionLender) && !empty($signBlockConstructionLender)) {
		$arrSignatureBlockList[$signature_type_id]['address_1'] = $signBlockConstructionLender->signature_block_construction_lender_address_1;
		$arrSignatureBlockList[$signature_type_id]['address_2'] = $signBlockConstructionLender->signature_block_construction_lender_address_2;
		$arrSignatureBlockList[$signature_type_id]['city_state_zip'] = $signBlockConstructionLender->signature_block_construction_lender_city_state_zip;
	}
}


//  Contractor Name
	$entityName = ContractingEntities::getcontractEntityNameforProject($database,$drawEntityId);
	$contractorName = $entityName;

// Owner Name
$ownerEnableFalg = false;
if(isset($arrSignatureBlockList[2]) && !empty($arrSignatureBlockList[2])){
	if($arrSignatureBlockList[2]['enable_flag'] == 'Y' && $arrSignatureBlockList[2]['signature_block_desc_update_flag'] == 'Y') {
		$ownerName = $arrSignatureBlockList[2]['signature_block_description'];
		$ownerEnableFalg = true;
	} else if($arrSignatureBlockList[2]['enable_flag'] == 'Y' && $arrSignatureBlockList[2]['signature_block_desc_update_flag'] == 'N') {
		$ownerName = $projectOwnerName;
		$ownerEnableFalg = true;
	} else {
		$ownerName = "";
		$ownerEnableFalg = false;
	}
} else {
	$ownerEnableFalg = false;
}
$ownerHtml = '';
$ownerNameHtml = '';
$ownerTdHtml = '';
if($ownerEnableFalg) {
	$ownerHtml = <<<OWNERHTML
	<td class="fontSize11 width10per">TO (OWNER):</td>
OWNERHTML;
	$ownerNameHtml = <<<OWNERHTML
	<td rowspan="3" class="fontSize11">$ownerName</td>
OWNERHTML;

}

//  Architect Name
if(isset($arrSignatureBlockList[3]) && !empty($arrSignatureBlockList[3])){
	if($arrSignatureBlockList[3]['enable_flag'] == 'Y' && $arrSignatureBlockList[3]['signature_block_desc_update_flag'] == 'Y') {
		$architectName = $arrSignatureBlockList[3]['signature_block_description'];	
	} else {
		$architectName = "";
	}
}

// Notary Block Enable
if(isset($arrSignatureBlockList[4]) && !empty($arrSignatureBlockList[4])){
	if($arrSignatureBlockList[4]['enable_flag'] == 'Y' ) {
		$notaryBlock = true;
	} else {
		$notaryBlock = false;
	}
} else {
	$notaryBlock = false;
}

// Construction Lender Block Enable
if(isset($arrSignatureBlockList[5]) && !empty($arrSignatureBlockList[5])){
	if($arrSignatureBlockList[5]['enable_flag'] == 'Y' ) {
		$clBlock = true;
		$clName = $arrSignatureBlockList[5]['signature_block_description'];
		// print_r($arrSignatureBlockList[5]);
		$address_1 = $arrSignatureBlockList[5]['address_1'];
		$address_2 = $arrSignatureBlockList[5]['address_2'];
		$city_state_zip = $arrSignatureBlockList[5]['city_state_zip'];
		$arrayClAddress = array();
		if($address_1!= '' && $address_1 != Null && $address_1 !=NULL){
			$arrayClAddress[] = $address_1;	
		}
		if($address_2!= '' && $address_2 != Null && $address_2 !=NULL){
			$arrayClAddress[] = $address_2;	
		}
		if($city_state_zip!= '' && $city_state_zip != Null && $city_state_zip !=NULL){
			$arrayClAddress[] = $city_state_zip;	
		}
		$arrImplodeCl = implode(', ', $arrayClAddress);
		$clAddressHtml = <<<CLHTML
	<span>
		$arrImplodeCl
	</span>
CLHTML;
	} else {
		$clBlock = false;
		$clName = '';
		$clAddressHtml = '';
	}
	
} else {
	$clBlock = false;
	$clName = '';
	$clAddressHtml = '';
}

$clHeaderHtml = '';
$clNameHtml = '';
$clAddressTdHtml = '';
if($clBlock) {
	$clHeaderHtml = <<<CLHTML
	<td class="fontSize11">CONSTRUCTION LENDER:</td>
CLHTML;
	$clNameHtml = <<<CLHTML
	<td class="fontSize11" rowspan="3">$clName <br> $clAddressHtml</td>
CLHTML;
}

/** Draw Grid Html Content */
$drawArr = RetentionDraws::findById($database, $ret_id);
$drawThroughDate = '';
if(isset($drawArr) && !empty($drawArr)){
	$drawThroughDate = $drawArr->through_date;
	if($drawThroughDate != '0000-00-00'){
		$drawThroughDate = date('m/d/Y',strtotime($drawThroughDate));
	}
}

$drawGridRawContent = renderRetentionDrawGridHtmlForPDF($database,$project_id, $last_draw_id, $draw_application_number,false,'',$corDisplay,'',$ret_id);

$drawCOGridRawContent = renderRetentionChangeOrderGridHtmlForPDF($database,$project_id, $last_draw_id, $draw_application_number,false,'',$corDisplay,'',$ret_id);


$totalCompAndStoredToDate = $drawGridRawContent['totalCoCompletedAppValue'] + $drawCOGridRawContent['totalCoCompletedAppValue'];
$totalRetention = $drawGridRawContent['totalCoRetainageValue'] + $drawCOGridRawContent['totalCoRetainageValue'];
$prevDrawRetention = $drawGridRawContent['totalPrevRetainerValue'] + $drawCOGridRawContent['totalPrevRetainerValue'];

$contractApTotalEarnedValue = $totalCompAndStoredToDate - $totalRetention;

$lessPrevCertForPayment = $totalCompAndStoredToDate - $prevDrawRetention;

$currentPaymentDue = $contractApTotalEarnedValue - $lessPrevCertForPayment;
$currentPaymentDueFormatted = $currentPaymentDue ? formatNegativeValues($currentPaymentDue) : '$0.00';

/* Html Content */
//Fulcrum logo and footer content
$fulcrum = Logo::fulcrumlogoforfooterByBasePath(true);
$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database, $user_company_id);

$headerLogo=<<<headerLogo
	<table width="100%" class="table-header">
	<tr>
	<td>$gcLogo</td>
	</tr>
	</table>
headerLogo;
	/* Get Action type */
	$loadActionTypeOptions = new Input();
	$loadActionTypeOptions->forceLoadFlag = true;
	$arrActionType = DrawActionTypes::findById($database, $draw_action_type_id);
	$actionTypeName = '';
	if(isset($arrActionType) && !empty($arrActionType)) {
		$actionTypeName = $arrActionType->action_name;
	}	
	/* Get Action type options */
	$actionTypeOptionName = '';
	if($draw_action_type_option_id != '') {
		$loadActionTypeOptions = new Input();
		$loadActionTypeOptions->forceLoadFlag = true;
		$arrActionTypeOption = DrawActionTypeOptions::findById($database, $draw_action_type_option_id);
		$actionTypeOptionName = '';
		if(isset($arrActionType) && !empty($arrActionType)) {
			$actionTypeOptionName = $arrActionTypeOption->option_name;
		}
	}
	$fileNameAdd = array();
	if($actionTypeName != ''){
		$fileNameAdd[] = $actionTypeName;
	}
	if($actionTypeOptionName != ''){
		$fileNameAdd[] = $actionTypeOptionName;
	}
	$fileNameAddString = '';
	if(isset($fileNameAdd) && !empty($fileNameAdd)){
		$fileNameAddString = implode(' - ', $fileNameAdd);
		$fileNameAddString = $fileNameAddString.' - ';
	}
	/* Get template Content */
	$loadActionTypeTemplateOptions = new Input();
	$loadActionTypeTemplateOptions->forceLoadFlag = true;
	$arrActionTypeTemplate = DrawActionTypeTemplates::loadAllDrawActionTypeTemplatesByIds($database, $draw_action_type_id, $draw_action_type_option_id, $loadActionTypeTemplateOptions);
	if(isset($arrActionTypeTemplate) && !empty($arrActionTypeTemplate)){
		$templateContent = $arrActionTypeTemplate['template_content'];
		$templateContent = base64_decode($templateContent);
	} else {
		// exit;
	}
	
	$currentDate = date('m/d/Y');
	$templateContent = str_replace('*CONTRACTOR_NAME*', $contractorName, $templateContent);
	$templateContent = str_replace('*PROJECT_NAME*', $projectName, $templateContent);
	$templateContent = str_replace('*PROJECT_ADDRESS*', $projectAddressHtml, $templateContent);
	$templateContent = str_replace('*OWNER_NAME*', $ownerName, $templateContent);
	$templateContent = str_replace('*THROUGH_DATE*', $drawThroughDate, $templateContent);
	$templateContent = str_replace('*TOTAL_COMPLETED_APP*', $currentPaymentDueFormatted, $templateContent);
	$templateContent = str_replace('*CURRENT_USER_NAME*', $currentUserName, $templateContent);
	$templateContent = str_replace('*CURRENT_DATE*', $currentDate, $templateContent);


$bodyContent = <<<BODYHTML
$templateContent
BODYHTML;
$htmlContent = <<<END_HTML_CONTENT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="{$uri->http}css/draw-print-pdf.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		$headerLogo
		<div style="float:right;display:none;"><img src='$fulcrum'></div>
		$bodyContent
	</body>
</html>
END_HTML_CONTENT;
// echo $htmlContent;
// exit;
$config = Zend_Registry::get('config');
$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
$baseDirectory = $config->system->base_directory;
$fileManagerBasePath = $config->system->file_manager_base_path;
$tempFileName = File::getTempFileName();
$tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
$removetempDir = $fileManagerBasePath.'temp/'.$tempFileName;
$fileObject = new File();
$fileObject->mkdir($tempDir, 0777);
$tempPdfFile = File::getTempFileName().'.pdf';
            // Files come from the autogen pdf
$tempFilePath = $tempDir.$tempPdfFile;
$bid_spreadsheet_data_sha1 = sha1($htmlContent);

$usePhantomJS = true;
if ($usePhantomJS) {
    $pdfPhantomJS = new PdfPhantomJS();
    $pdfPhantomJS->setPdfPaperSize('8.5in', '11in');
  	// $pdfPhantomJS->setPdffooter($footer_cont);
  	$pdfPhantomJS->setMargin('10px', '60px', '60px', '10px');
  	$pdfPhantomJS->setPdffooter('', $fulcrum);
    $pdfPhantomJS->writeTempFileContentsToDisk($htmlContent, $bid_spreadsheet_data_sha1);
    $pdfPhantomJS->setCompletePdfFilePath($tempFilePath);
    $result = $pdfPhantomJS->execute();
    $pdfPhantomJS->deleteTempFile();
}

$typeName = DrawActionTypes::getTypeName($database,$draw_action_type_id);
$typeOptionName = DrawActionTypeOptions::getDrawActionOptionName($database,$draw_action_type_option_id);

if ($draw_action_type_id == 3) {
	$typeFileName = $typeName;
}else{
	$typeFileName = $typeName.' - '.$typeOptionName;
}

// To open the created File path 
$timezone = date_default_timezone_get();
$dates = date('d-m-Y h', time());
$date = date('d-m-Y', time());
$i=date('i', time());
$s=date('s a', time());
$a=date('a', time());
$downloadFilename = 'Retention #'.$application_number.' - '.$typeFileName." - ".$drawThroughDateFormat.".pdf";

$filename = 'Retention #'.$application_number.' - '.$typeName.' - '.$typeOptionName." - ".$drawThroughDateFormat.".pdf";
// Overrite the virtual file name when through date change 
$drawFileMangerFileOptions = new Input();
$drawFileMangerFileOptions->forceLoadFlag = true;
$drawFileMangerFile = RetentionDrawFileManagerFiles::findByIdsRetentionFileManagerFile($database, $ret_id, $draw_action_type_id, $draw_action_type_option_id, $drawFileMangerFileOptions);
if(isset($drawFileMangerFile) && !empty($drawFileMangerFile)){
	$file_manager_file_id = $drawFileMangerFile->file_manager_file_id;
	$drawFileMangerFile->convertPropertiesToData();
	// $data = $drawFileMangerFile->getData();
	// update filemanager file name
	$getFileManagerFileUpdate = FileManagerFile::findById($database, $file_manager_file_id);
	if(isset($getFileManagerFileUpdate) && !empty($getFileManagerFileUpdate)) {
		$virtual_file_name_update = $getFileManagerFileUpdate->virtual_file_name;
		$getFileManagerFileUpdate->convertPropertiesToData();
		$updateData = $getFileManagerFileUpdate->getData();
		FileManagerFile::restoreFromTrash($database,$file_manager_file_id);
		if ($virtual_file_name_update != $filename) {
			$updateData['virtual_file_name'] = $filename;
			$getFileManagerFileUpdate->setData($updateData);
			$getFileManagerFileUpdate->save();
		}
	}
}


/*get the details of folder*/
$draw_virtual_file_path = "/Retention/";
$drawUploadFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $draw_virtual_file_path);

/* Create folder path*/
$arrVirtualPath = array(1 => "In Draft", 2 => "Post Draw");
$curVirtualPath = $arrVirtualPath[$drawStatus];
// $virtual_file_path = '/Draws/'.$curVirtualPath.'/Draw #'. $application_number.'/';
$addFolder = '';
if($draw_action_type_id == 1){
	$addFolder = $actionTypeName.'/';
}
$virtual_file_path = '/Retention/Retention #'. $application_number.'/'.$addFolder;
// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
$currentVirtualFilePath = '/';
foreach ($arrFolders as $folder) {
	$tmpVirtualFilePath = array_shift($arrFolders);
	$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
	// Save the file_manager_folders record (virtual_file_path) to the db and get the id
	$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $currently_active_contact_id, $project_id, $currentVirtualFilePath);
}
$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

$sha1 = sha1_file($tempFilePath);
$size = filesize($tempFilePath);
$fileExtension = 'pdf';
$virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);

// Final pdf document
$virtual_file_name_tmp = $filename;
$tmpFileManagerFile = new FileManagerFile($database);
$tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
$virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();

// Convert file content to File object
$error = null;

$file = new File();
$file->sha1 = $sha1;
$file->name = $virtual_file_name;
$file->size = $size;
//$file->tmp_name = $tmp_name;
$file->type = $virtual_file_mime_type;
$file->tempFilePath = $tempFilePath;
$file->fileExtension = $fileExtension;

//$arrFiles = File::parseUploadedFiles();
$file_location_id = FileManager::saveUploadedFileToCloud($database, $file, false);

// save the file information to the file_manager_files db table
$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $user_company_id, $currently_active_contact_id, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
/* @var $fileManagerFile FileManagerFile */

$file_manager_file_id = $fileManagerFile->file_manager_file_id;
$fileDownloadPath = $fileManagerFile->generateUrlBasePath(true);
// Potentially update file_location_id
if ($file_location_id <> $fileManagerFile->file_location_id) {
	$fileManagerFile->file_location_id = $file_location_id;
	$data = array('file_location_id' => $file_location_id);
	$fileManagerFile->setData($data);
	$fileManagerFile->save();
}

// Set Permissions of the file to match the parent folder.
$parent_file_manager_folder_id = $fileManagerFolder->getParentFolderId();
FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);

// Update $punchItem->su_file_manager_file_id
$data = array(
	'file_manager_file_id' => $file_manager_file_id
);
// echo $file_manager_file_id;
/* draw file manage file save */
$data = array();
$data['ret_id'] = $ret_id;
$data['ret_action_type_id'] = $draw_action_type_id;
$data['ret_action_type_option_id'] = $draw_action_type_option_id;
$data['file_manager_file_id'] = $file_manager_file_id;
$data['file_manager_folder_id'] = $file_manager_folder_id;
$data['created_contact_id'] = $currently_active_contact_id;
$data['updated_contact_id'] = $currently_active_contact_id;

/* find by ids */
$drawFileMangerFileOptions = new Input();
$drawFileMangerFileOptions->forceLoadFlag = true;
$drawFileMangerFile = RetentionDrawFileManagerFiles::findByIdsRetentionFileManagerFile($database, $ret_id, $draw_action_type_id, $draw_action_type_option_id, $drawFileMangerFileOptions);
if(isset($drawFileMangerFile) && !empty($drawFileMangerFile)){

	$drawFileMangerFile->convertPropertiesToData();
	$data = $drawFileMangerFile->getData();
	$data['updated_date'] = date('Y-m-d h:i:s');
	$data['file_manager_file_id'] = $file_manager_file_id;
	$data['file_manager_folder_id'] = $file_manager_folder_id;
	$drawFileMangerFile->setData($data);
	$drawFileMangerFile->convertDataToProperties();
} else {
	$drawFileMangerFile = new RetentionDrawFileManagerFiles($database);
	$drawFileMangerFile->setData($data);
	$drawFileMangerFile->convertDataToProperties();
}
$drawFileMangerFile->save();
// Delete temp files
header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
header("Content-Disposition: attachment; filename=\"" . $downloadFilename . "\";");
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($fileDownloadPath));
ob_clean();
flush();
readfile($fileDownloadPath); //showing the path to the server where the file is to be download
// unlink($fileDownloadPath); //To remove temp file
rmdir($removetempDir); //To remove temp folder
$fileObject->rrmdir($tempDir);

exit;
} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}
