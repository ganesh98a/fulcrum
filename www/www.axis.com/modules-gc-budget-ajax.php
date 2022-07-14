<?php
try {

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

// Method Call is our switch variable
if (isset($get)) {
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}

setlocale(LC_MONETARY, 'en_US');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);
require_once 'PHPClasses/PHPExcel/IOFactory.php';
require_once('modules-gc-budget-functions.php');
require_once('lib/common/Esignature.php');
require_once('lib/common/PdfToImg.php');
require_once('lib/common/Contact.php');
require_once('lib/common/SubmittalRegistry.php');
require_once('lib/common/ActionItemAssignment.php');
require_once('lib/common/ActionItemType.php');

require_once('lib/common/Api/UsersNotifications.php');

require_once('lib/common/Api/UsersDeviceInfo.php');

require_once('lib/common/Service/TableService.php');

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('submittals-functions.php');
	}
}

// LOGGING UPLOAD TIME TO THE BACKEND FILE DATABASE
$timer->startTimer();
$_SESSION['timer'] = $timer;



// SESSION VARIABLES
/* @var $session Session */
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$primary_contact_id = $session->getPrimaryContactId();
$primary_contact_name = $session->getLoginName();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompany->htmlEntityEscapeProperties();
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

switch ($methodCall) {
	case 'generateFinalSubcontract':

		$gc_budget_line_item_id = $get->gc_budget_line_item_id;
		$cost_code_division_id = $get->cost_code_division_id;
		$cost_code_id = $get->cost_code_id;
		$subcontract_id = $get->subcontract_id;
		$execution_date = $get->execution_date;
		$mailed_date = $get->mailed_date;
		$esign = $get->esign;
		$costCodeDivision = CostCodeDivision::findById($database, $cost_code_division_id);
		/* @var $costCodeDivision CostCodeDivision */

		$costCode = CostCode::findById($database, $cost_code_id);
		/* @var $costCode CostCode */

		$findSubcontractByIdExtendedOptions = new Input();
		$findSubcontractByIdExtendedOptions->forceLoadFlag = true;
		$subcontract = Subcontract::findSubcontractByIdExtended($database, $subcontract_id);
		/* @var $subcontract Subcontract */

		$vendor = $subcontract->getVendor();
		if ($vendor) {
			/* @var $vendor Vendor */

			$vendorContactCompany = $vendor->getVendorContactCompany();
			/* @var $vendorContactCompany ContactCompany */

			$vendor_company_name = $vendorContactCompany->company;
		} else {
			$vendor_company_name = '';
		}
		

		$loadSubcontractDocumentsBySubcontractIdOptions = new Input();
		$loadSubcontractDocumentsBySubcontractIdOptions->forceLoadFlag = true;
		$arrSubcontractDocuments = SubcontractDocument::loadSubcontractDocumentsBySubcontractId($database, $subcontract_id, $loadSubcontractDocumentsBySubcontractIdOptions,'all');

		$division_number = $costCodeDivision->division_number;
		$cost_code = $costCode->cost_code;
		$cost_code_description = $costCode->cost_code_description;
		$costCodeLabel = $division_number.'-'.$cost_code.' '.$cost_code_description;

		// Copy all pdf files to the server's local disk
		$config = Zend_Registry::get('config');
		$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
		$baseDirectory = $config->system->base_directory;
		$fileManagerBasePath = $config->system->file_manager_base_path;
		$fileManagerFileNamePrefix = $config->system->file_manager_file_name_prefix;
		$basePath = $fileManagerBasePath.'frontend/'.$user_company_id;
		$compressToDir = $fileManagerBasePath.'temp/'.$user_company_id.'/'.$project_id.'/';
		$urlDirectory = 'downloads/'.'temp/'.$user_company_id.'/'.$project_id.'/';
		$outputDirectory = $baseDirectory.'www/www.axis.com/'.$urlDirectory;

		$arrMasterFileManagerFiles = array();
		foreach ($arrSubcontractDocuments as $subcontract_document_id => $subcontractDocument) {
			/* @var $subcontractDocument SubcontractDocument */

			$subcontract_document_id = $subcontractDocument->subcontract_document_id;
			$subcontract_item_template_id = $subcontractDocument->subcontract_item_template_id;
			$unsigned_subcontract_document_file_manager_file_id = $subcontractDocument->unsigned_subcontract_document_file_manager_file_id;
			$signed_subcontract_document_file_manager_file_id = $subcontractDocument->signed_subcontract_document_file_manager_file_id;
			$auto_generated_flag = $subcontractDocument->auto_generated_flag;
			$disabled_flag = $subcontractDocument->disabled_flag;
			$sort_order = $subcontractDocument->sort_order;

			// Signed vs unsigned subcontract docs ???
			$unsignedSubcontractDocumentFileManagerFile = $subcontractDocument->getUnsignedSubcontractDocumentFileManagerFile();
			/* @var $unsignedSubcontractDocumentFileManagerFile FileManagerFile */


			/* @var $signedSubcontractDocumentFileManagerFile FileManagerFile */

			if ($unsignedSubcontractDocumentFileManagerFile) {
				$arrMasterFileManagerFiles[$unsignedSubcontractDocumentFileManagerFile->file_manager_file_id] = $unsignedSubcontractDocumentFileManagerFile;
			}
		}

		// Copy over the files

		$tempFileName = File::getTempFileName();
		$tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
		$fileObject = new File();
		$fileObject->mkdir($tempDir, 0777);
		// Start with offset 2 to save 1 for the cover sheet
		$counter = 2;
		$skipOne = true;
		$arrPdfFiles = array();
		$pdfPageCount = 0;
		foreach ($arrMasterFileManagerFiles as $file_manager_file_id => $fileManagerFile) {
			// Debug

			// Start with offset 2 to save 1 for the cover sheet
			

			// 00001 formatted string
			$fileNamePrefix = str_pad($counter, 5, '0', STR_PAD_LEFT);
			$tempPdfFile = $fileNamePrefix.'.'.$file_manager_file_id.'.pdf';
			$tempFilePath = $tempDir.$tempPdfFile;

			// Copy the file from the backend to the physical temp folder
			//@todo Remove the portion of the $virtual_file_path that is the starting relative directory
			$file_location_id = $fileManagerFile->file_location_id;
			$statusFlag = false;
			if (isset($file_location_id) && !empty($file_location_id)) {
				if ($file_manager_front_end_node_file_copy_protocol == 'FTP') {
					$statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaFtp($fileManagerFile, $tempFilePath, $file_location_id);
				} elseif ($file_manager_front_end_node_file_copy_protocol == 'LocalFileSystem') {
					$statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaLocalFileSystem($fileManagerFile, $tempFilePath, $file_location_id);
				}
			}

			if ($statusFlag) {
				$arrPdfFiles[] = $tempPdfFile;
				//To get the page Count for pdf
               			$pdf_page_file=$tempDir.$tempPdfFile;
               			$cc= exec("identify -format %n $pdf_page_file");
               			$pdfPageCount=$pdfPageCount+$cc;

				// Track page count

			}

			$counter++;
		}
		// Debug
		// Generate Cover Page
		$subcontract_item_template_id = 2;
		$coverPageSubcontractDocument = generateDynamicSubcontractDocument($database, $user_company_id, $project_id, $user_id, $userCompanyName, $gc_budget_line_item_id, $cost_code_division_id, $cost_code_id, $subcontract_id, $subcontract_item_template_id, $pdfPageCount,$esign);
		//To get the cover data
		$loadSubcontractDocumentsBySubcontractIdOptions = new Input();
		$loadSubcontractDocumentsBySubcontractIdOptions->forceLoadFlag = true;
		$arrSubcontractDocuments = SubcontractDocument::loadSubcontractDocumentsBySubcontractId($database, $subcontract_id, $loadSubcontractDocumentsBySubcontractIdOptions,'cover');

		$coverarrMasterFileManagerFiles= array();
		foreach ($arrSubcontractDocuments as $subcontract_document_id => $subcontractDocument) {

			$subcontract_document_id = $subcontractDocument->subcontract_document_id;
			$subcontract_item_template_id = $subcontractDocument->subcontract_item_template_id;
			$unsigned_subcontract_document_file_manager_file_id = $subcontractDocument->unsigned_subcontract_document_file_manager_file_id;
			$signed_subcontract_document_file_manager_file_id = $subcontractDocument->signed_subcontract_document_file_manager_file_id;
			$auto_generated_flag = $subcontractDocument->auto_generated_flag;
			$disabled_flag = $subcontractDocument->disabled_flag;
			$sort_order = $subcontractDocument->sort_order;

			// Signed vs unsigned subcontract docs ???
			$unsignedSubcontractDocumentFileManagerFile = $subcontractDocument->getUnsignedSubcontractDocumentFileManagerFile();

			if ($unsignedSubcontractDocumentFileManagerFile) {
				$coverarrMasterFileManagerFiles[$unsignedSubcontractDocumentFileManagerFile->file_manager_file_id] = $unsignedSubcontractDocumentFileManagerFile;
			}
		}
		foreach ($coverarrMasterFileManagerFiles as $file_manager_file_id => $fileManagerFile) {

			// 00001 formatted string
			$fileNamePrefix = str_pad($counter, 5, '0', STR_PAD_LEFT);
			$tempPdfFile = $fileNamePrefix.'.'.$file_manager_file_id.'.pdf';
			$tempFilePath = $tempDir.$tempPdfFile;

			// Copy the file from the backend to the physical temp folder

			$file_location_id = $fileManagerFile->file_location_id;
			$statusFlag = false;
			if (isset($file_location_id) && !empty($file_location_id)) {
				if ($file_manager_front_end_node_file_copy_protocol == 'FTP') {
					$statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaFtp($fileManagerFile, $tempFilePath, $file_location_id);
				} elseif ($file_manager_front_end_node_file_copy_protocol == 'LocalFileSystem') {
					$statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaLocalFileSystem($fileManagerFile, $tempFilePath, $file_location_id);
				}
			}

			if ($statusFlag) {
				 // Put the cover sheet first in the list
                array_unshift($arrPdfFiles, $tempPdfFile);
				//To get the page Count for pdf
             $pdf_page_file=$tempDir.$tempPdfFile;

			}

			$counter++;
		}

		// Signed Subcontract Uploader
		$virtual_file_name =
			$vendor_company_name . ' : ' .
			'Unsigned Subcontract #'.
			$subcontract->subcontract_sequence_number . '.pdf';

		$tempFileName = File::getTempFileName();
		$tempFinalSubcontractPdfFileName = "temp001" . '.pdf';
		$finalSubcontractFilepath = $tempDir.$tempFinalSubcontractPdfFileName;

		// PdfToImg::PDF2Img($arrPdfFiles, $tempDir);
		// GeneratePDFUsignImage($database,$arrPdfFiles, $tempDir, $finalSubcontractFilepath,$subcontract_id,$currentlyActiveContactId,$esign);
	
		Pdf::merge($arrPdfFiles, $tempDir, $tempFinalSubcontractPdfFileName);

		// Copy final Compiled Unsigned contract to the cloud
		$tempFilePath = $finalSubcontractFilepath;
		$sha1 = sha1_file($finalSubcontractFilepath);
		$size = filesize($finalSubcontractFilepath);
		$fileExtension = 'pdf';
		$virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);

		// Convert file content to File object
		$error = null;

		$file = new File();
		$file->sha1 = $sha1;
	
		$file->name = $virtual_file_name;
		$file->size = $size;
		$file->type = $virtual_file_mime_type;
		$file->tempFilePath = $tempFilePath;
		$file->fileExtension = $fileExtension;

		$file_location_id = FileManager::saveUploadedFileToCloud($database, $file);

		// Folder
		// Save the file_manager_folders record (virtual_file_path) to the db and get the id
		$subcontractFoldername = "/Subcontracts/$costCodeLabel/";
		$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, $project_id, $subcontractFoldername);
		/* @var $fileManagerFolder FileManagerFolder */

		// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
		$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

		// save the file information to the file_manager_files db table
		$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $user_company_id, $currentlyActiveContactId, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
		/* @var $fileManagerFile FileManagerFile */

		$file_manager_file_id = $fileManagerFile->file_manager_file_id;

		// This never gets true since the $file_location_id is passed in above and the update occurs there
		// Potentially update file_location_id
		if ($file_location_id <> $fileManagerFile->file_location_id) {
			$version_number = $fileManagerFile->version_number;
			$version_number++;
			$fileManagerFile->version_number = $version_number;
			$fileManagerFile->file_location_id = $file_location_id;
			$data = array(
				'file_location_id' => $file_location_id,
				'version_number' => $version_number
			);
			$fileManagerFile->setData($data);
			$fileManagerFile->save();
		}

			// Set Permissions of the file to match the parent folder.
		FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);

		// Update $subcontractDocument
		$data = $subcontract->getData();
		$newData = array('unsigned_subcontract_file_manager_file_id' => $file_manager_file_id);
		$subcontract->setData($newData);
		$subcontract->save();

		// Delete temp files
		$file->rrmdir($tempDir);
		break;

	case 'generateDynamicSubcontractDocument':

		$crudOperation = 'save';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			$gc_budget_line_item_id = $get->gc_budget_line_item_id;
			$cost_code_division_id = $get->cost_code_division_id;
			$cost_code_id = $get->cost_code_id;
			$subcontract_id = $get->subcontract_id;
			$subcontract_item_template_id = $get->subcontract_item_template_id;

			$subcontractDocument = generateDynamicSubcontractDocument($database, $user_company_id, $project_id, $user_id, $userCompanyName, $gc_budget_line_item_id, $cost_code_division_id, $cost_code_id, $subcontract_id, $subcontract_item_template_id);

			$unsigned_subcontract_document_file_manager_file_id = $subcontractDocument->unsigned_subcontract_document_file_manager_file_id;
			$fileManagerFile = FileManagerFile::findFileManagerFileByIdExtended($database, $unsigned_subcontract_document_file_manager_file_id);
			$htmlContent = '';
			if ($fileManagerFile) {
				$virtual_file_name = $fileManagerFile->virtual_file_name;
				$fileUrl = $fileManagerFile->generateUrl();
				$htmlContent = '<a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="'.$fileUrl.'" title="'.$virtual_file_name.'">Document</a>';
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		// @todo Fix this section
		$errorMessage = '';
		$attributeGroupName = '';
		$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
		$formattedAttributeGroupName = '';

		$arrCustomizedJsonOutput = array(
			'gc_budget_line_item_id' => $gc_budget_line_item_id,
			'cost_code_division_id' => $cost_code_division_id,
			'cost_code_id' => $cost_code_id
		);

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadGcBudgetLineItems':
		$htmlContent = renderGcBudgetForm($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $project_name);
		echo $htmlContent;

	break;

	case 'NotesData':
		$budget_id  = $get->Budget_id;
		$table ='gc_budget_line_items';
		$notes =TableService::getSingleField($database,$table,'notes','id',$budget_id);
		echo $notes;
	break;

	case 'updateIsDcrFlag':

		$id=(int)$get->attributeId;
		$updateData=(string)$get->updateData;

		$db = DBI::getInstance($database);
		// $query ="UPDATE `gc_budget_line_items` SET `is_dcr_flag`='$updateData' WHERE id ='$id'";
		$query ="UPDATE `subcontracts` SET `is_dcr_flag`='$updateData' WHERE id ='$id'";
		$db->execute($query);
		echo "success";

		break;

	case 'updateAllIsDcrFlag':

		$id=(int)$get->attributeId;
		$updateData=(string)$get->updateData;

		$db = DBI::getInstance($database);
		$query ="SELECT group_concat(id) AS ids FROM `gc_budget_line_items` WHERE `project_id` = $project_id";
		$db->execute($query);
		$row = $db->fetch();
		$db->free_result();
		if (isset($row) && !empty($row)) {
			$gc_budget_line_item_ids = $row['ids'];
			$query ="UPDATE `subcontracts` SET `is_dcr_flag`='$updateData' WHERE `gc_budget_line_item_id` IN ($gc_budget_line_item_ids)";
			$db->execute($query);
			$db->free_result();
		}
		// $query ="UPDATE `gc_budget_line_items` SET `is_dcr_flag`='$updateData' WHERE project_id ='$id'";
		// $query ="UPDATE `subcontracts` SET `is_dcr_flag`='$updateData' WHERE `gc_budget_line_item_id` IN (SELECT group_concat(id) FROM `gc_budget_line_items` WHERE `project_id` = $project_id)";
		// $db->execute($query);
		echo "success";

		break;

	case 'countAllIsDcrFlag':

		$project_id=(int)$get->attributeId;
		$isAllDcrCount = GcBudgetLineItem::countAllIsDcrFlag($database, $project_id);
		echo $isAllDcrCount;

	break;

	case 'loadImportCostCodesIntoBudgetDialog':

		$message->enqueueError("Unable to the load budget import options.", $currentPhpScript);
		$importCostCodesFromId = $get->importFromProjectId;
		$project_id= base64_decode($get->pID);
		$db = DBI::getInstance($database);

		$userCompany = UserCompany::findById($database, $user_company_id);
		$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

		# Cost codes by GC Master List
		$query =
"
SELECT cctypes.*
FROM cost_code_types cctypes
WHERE EXISTS (
	SELECT 1
	FROM `cost_code_divisions` ccd
	INNER JOIN `cost_codes` codes ON codes.`cost_code_division_id` = ccd.`id`
	WHERE ccd.`user_company_id` = ?
	AND cctypes.`id` = ccd.`cost_code_type_id`
)
ORDER BY cctypes.cost_code_type
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodesByGCMasterList = array();
		while ($row = $db->fetch()) {
			$cost_code_type_id = $row['id'];
			$cost_code_type = $row['cost_code_type'];
			$costCodeKey = "gc_cct_id:$cost_code_type_id";
			$arrCostCodesByGCMasterList[$costCodeKey] = "$userCompany->company Codes :: $cost_code_type";
		}
		$db->free_result();

		# Cost codes by template
		$query =
"
SELECT cctypes.*
FROM cost_code_types cctypes
WHERE EXISTS (
	SELECT 1
	FROM cost_code_division_templates ccdt
	INNER JOIN cost_code_templates cct ON cct.cost_code_division_template_id = ccdt.`id`
	WHERE cctypes.`id` = ccdt.cost_code_type_id
)
ORDER BY cctypes.cost_code_type
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodesByType = array();
		while ($row = $db->fetch()) {
			$cost_code_type_id = $row['id'];
			$cost_code_type = $row['cost_code_type'];
			$costCodeKey = "t_cct_id:$cost_code_type_id";
			$arrCostCodesByType[$costCodeKey] = "Template Codes :: $cost_code_type";
		}
		$db->free_result();


		# Cost codes by project
		$query =
"
SELECT p.`id` as 'project_id', p.`project_name`, gbli.`cost_code_id`, ccd.`division_number`, ccd.`division_code_heading`, ccd.`division`, codes.`cost_code`, codes.`cost_code_description`
FROM `gc_budget_line_items` gbli INNER JOIN `projects` p ON p.`id` = gbli.`project_id`
INNER JOIN `cost_codes` codes ON gbli.`cost_code_id` = codes.`id`
INNER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
WHERE gbli.`user_company_id` = ?
AND gbli.`project_id` <> ?
AND project_id <> 2
ORDER BY project_name, ccd.`division_number`, codes.`cost_code`
";
		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodesByPreviousProject = array();
		while ($row = $db->fetch()) {
			$project_id = $row['project_id'];
			$project_name = $row['project_name'];
			$costCodeKey = "p_id:$project_id";
			$arrCostCodesByPreviousProject[$costCodeKey] = "Project Codes from :: $project_name";
		}
		$db->free_result();

		// Determine which list of cost codes to load
		if (!isset($importCostCodesFromId) || empty($importCostCodesFromId) || ($importCostCodesFromId == -1)) {
			// Load GC Master List
			$importHeadline = $arrCostCodesByGCMasterList["gc_cct_id:5"];
			$query =
"
SELECT ccd.`division_number`, ccd.`division_code_heading`, ccd.`division`, codes.`id` as 'cost_code_id', codes.`cost_code`, codes.`cost_code_description`
FROM `cost_code_divisions` ccd INNER JOIN `cost_codes` codes ON ccd.`id` = codes.`cost_code_division_id`
WHERE ccd.`user_company_id` = ?
AND ccd.`cost_code_type_id` = ?
AND codes.`disabled_flag` = 'N'
ORDER BY ccd.`division_number` ASC, codes.`cost_code` ASC 
";
			// hard code cost_code_type_id for now
			$cost_code_type_id = 5;
			$arrValues = array($user_company_id, $cost_code_type_id);
		} else {
			// split on ":"
			$arrTempCostCodeImport = explode(':', $importCostCodesFromId);
			$importCostCodesType = $arrTempCostCodeImport[0];
			$importCostCodesTypeId = $arrTempCostCodeImport[1];

			if ($importCostCodesType == 'gc_cct_id') {
				// GC Master List with a cost_code_type_id value (may be more than one for a GC)
				$importHeadline = $arrCostCodesByGCMasterList["gc_cct_id:$importCostCodesTypeId"];
				$query =
"
SELECT ccd.`division_number`, ccd.`division_code_heading`, ccd.`division`, codes.`id` as 'cost_code_id', codes.`cost_code`, codes.`cost_code_description`
FROM `cost_code_divisions` ccd INNER JOIN `cost_codes` codes ON ccd.`id` = codes.`cost_code_division_id`
WHERE ccd.`user_company_id` = ?
AND ccd.`cost_code_type_id` = ?
AND codes.`disabled_flag` = 'N'
ORDER BY ccd.`division_number` ASC, codes.`cost_code` ASC
";
				// hard code cost_code_type_id for now
				// @todo: Verify this fix. No longer hard-coded.
				$cost_code_type_id = $importCostCodesTypeId;
				$arrValues = array($user_company_id, $cost_code_type_id);
			} elseif ($importCostCodesType == 'p_id') {
				$importHeadline = $arrCostCodesByPreviousProject["p_id:$importCostCodesTypeId"];
				// Past project list
				$query =
"
SELECT p.`id` as 'project_id', p.`project_name`, gbli.`cost_code_id`, ccd.`division_number`, ccd.`division_code_heading`, ccd.`division`, codes.`cost_code`, codes.`cost_code_description`
FROM `gc_budget_line_items` gbli INNER JOIN `projects` p ON p.`id` = gbli.`project_id`
INNER JOIN `cost_codes` codes ON gbli.`cost_code_id` = codes.`id`
INNER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
WHERE gbli.`user_company_id` = ?
AND gbli.`project_id` = ?
ORDER BY project_name, ccd.`division_number`+0, codes.`cost_code`
";
				$existingBudgetProjectId = $importCostCodesTypeId;
				$arrValues = array($user_company_id, $existingBudgetProjectId);
			} elseif ($importCostCodesType == 't_cct_id') {
				$importHeadline = $arrCostCodesByType["t_cct_id:$importCostCodesTypeId"];
				// Template List from cost_code_templates
				$query =
"
SELECT ccdt.division_number, ccdt.division_code_heading, ccdt.division, cct.`id` AS 'cost_code_id', cct.cost_code, cct.cost_code_description
FROM cost_code_division_templates ccdt INNER JOIN cost_code_templates cct ON ccdt.`id` = cct.cost_code_division_template_id
WHERE ccdt.cost_code_type_id = ?
ORDER BY ccdt.`division_number` ASC, cct.`cost_code` ASC
";
				// hard code cost_code_type_id for now
				$cost_code_type_id = $importCostCodesTypeId;
				$arrValues = array($cost_code_type_id);
			}
		}


		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrBudgetItems = array();
		$arrCostCodes = array();
		$tmpDivisionNumber = '';
		$counter = -1;
		while ($row = $db->fetch()) {
			$cost_code_id = $row['cost_code_id'];
			$division_number = $row['division_number'];
			$division_code_heading = $row['division_code_heading'];
			$division = $row['division'];
			$cost_code = $row['cost_code'];
			$cost_code_description = $row['cost_code_description'];

			$budgetName = $cost_code . ' ' . $cost_code_description;
			$arrBudgetItems[$cost_code_id] = $budgetName;

			$arrTmpCostCode = array(
				'cost_code_id' => $cost_code_id,
				'cost_code' => $cost_code,
				'cost_code_description' => $cost_code_description,
			);

			if ($tmpDivisionNumber <> $division_number) {
				$counter++;
				$tmpDivisionNumber = $division_number;
				$arrDivisionInfo = array(
					'division_number' => $division_number,
					'division_code_heading' => $division_code_heading,
					'division' => $division,
				);
				$arrCostCodes[$counter]['division_info'] = $arrDivisionInfo;
			}

			$arrCostCodes[$counter]['cost_codes'][] = $arrTmpCostCode;
		}
		$db->free_result();

		echo '
			<table width="100%" cellpadding="5" cellspacing="0" style="margin-bottom:10px;">
				<tr>
					<th class="textAlignLeft">Import Cost Codes:</th>
					<td align="right">
						<select id="ddlImportProjectList" onchange="loadImportCostCodesIntoBudgetDialog();">
		';
		$arrDropDownList = $arrCostCodesByGCMasterList + $arrCostCodesByPreviousProject + $arrCostCodesByType;
		foreach ($arrDropDownList AS $costCodeSourceId => $costCodeSourceName) {
			if ($costCodeSourceId == $importCostCodesFromId) {
				echo '
							<option value="'.$costCodeSourceId.'" selected>'.$costCodeSourceName.'</option>
				';
			} else {
				echo '
							<option value="'.$costCodeSourceId.'">'.$costCodeSourceName.'</option>
				';
			}
		}

		echo '
						</select>
					</td>
				</tr>
			</table>
		';

		echo '
			<table id="tblImportCostCodes" cellpadding="3px" cellspacing="0" border="0" width="100%" style="margin-bottom:0px;">
				<tr>
					<th width="30px"><input id="chkImportDefault" type="checkbox" onclick="checkAllImportItems();"></th>
					<th class="textAlignLeft">Import ALL '.$importHeadline.'</th>
				</tr>
		';
		$divisionHeading = '';
		foreach ($arrCostCodes AS $counter => $arrTmp) {

			$arrDivisionInfo = $arrTmp['division_info'];
			$arrCostCodeValues = $arrTmp['cost_codes'];

			$division_number = $arrDivisionInfo['division_number'];
			$division_code_heading = $arrDivisionInfo['division_code_heading'];
			$division = $arrDivisionInfo['division'];

			$currentDivisionHeading = "Division $division_number - $division";
			if ($currentDivisionHeading <> $divisionHeading) {
				$divisionHeading = $currentDivisionHeading;
				echo '<tr><th colspan="2" align="left" class="borderBottom" style="padding:15px 0 0 0">'.$divisionHeading.'</th></tr>';
			}

			$first = true;
			foreach ($arrCostCodeValues as $tmpCostCode) {
				$cost_code_id = $tmpCostCode['cost_code_id'];
				$cost_code = $tmpCostCode['cost_code'];
				$cost_code_description = $tmpCostCode['cost_code_description'];
				$style = '';
				if ($first) {
					$first = false;
					$style = 'style="padding-top:15px"';
				}
				echo '
					<tr>
						<td class="textAlignCenter" '.$style.'><input id="chkImport_'.$cost_code_id.'" class="input-import-checkbox" type="checkbox" value="'.$cost_code_id.'"></td>
						<td '.$style.'><label for="chkImport_'.$cost_code_id.'" style="float:none">'.$division_number.$costCodeDividerType.$cost_code.' '.$cost_code_description.'</label></td>
					</tr>
				';
			}
		}
		
		echo '
			</table>
		';

	break;

	case 'importCostCodesIntoBudget':

		$csvCostCodeIds = $get->csvCostCodeIds;
		$project_id= base64_decode($get->pID);
		$db = DBI::getInstance($database);
		//To check Whether the cost code Exist
		if(strpos($csvCostCodeIds,','))
		{
			$csvCostCodeIdsVal=explode(',', $csvCostCodeIds);
			foreach ($csvCostCodeIdsVal as $key => $csvCostCodeIds) {

				$que1="SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id', cost_codes.`id` AS 'cost_code_id', null AS 'created'
						FROM `cost_codes`
							INNER JOIN `cost_code_divisions` ON cost_codes.`cost_code_division_id` = cost_code_divisions.`id`
						WHERE cost_code_divisions.`user_company_id` = $user_company_id
							AND cost_codes.`id`
						IN ($csvCostCodeIds)";
				$arrValues = array();
				$db->execute($que1, $arrValues);
				$records=array();
				while($row1=$db->fetch())
				{
					$records=$row1;
				}
				$rec_count=count($records);
				//Insert to the costCost and Cost Division table if Does not exists
				if($rec_count=='0')
				{
					$que2="SELECT * FROM `cost_codes` WHERE `id` ='".$csvCostCodeIds."'";
					$db->execute($que2);
					$CostCodeValue=array();
					while($row2=$db->fetch())
					{
						$CostCodeValue=$row2;
					}

					$cost_id=$CostCodeValue['cost_code_division_id'];
					$que3="SELECT * FROM `cost_code_divisions` WHERE `id` ='".$cost_id."'";
					$db->execute($que3);
					$CostdivisionValue=array();
					while($row3=$db->fetch())
					{
						$CostdivisionValue=$row3;
					}

		 			// To insert into cost_code_divisions Table
			  		$que4="Insert into cost_code_divisions (`user_company_id`, `cost_code_type_id`, `division_number`, `division_code_heading`, `division`, `division_abbreviation`, `sort_order`, `disabled_flag`) values ('".$user_company_id."','".$CostdivisionValue['cost_code_type_id']."','".$CostdivisionValue['division_number']."','".$CostdivisionValue['division_code_heading']."','".$CostdivisionValue['division']."','".$CostdivisionValue['division_abbreviation']."','".$CostdivisionValue['sort_order']."','".$CostdivisionValue['disabled_flag']."') ";
					if($db->execute($que4)){
	        			$insertedId = $db->insertId;
	      			}
	      			//To insert into cost_codes Table
	      			$que5="INSERT INTO `cost_codes`(`cost_code_division_id`, `cost_code`, `cost_code_description`, `cost_code_description_abbreviation`, `sort_order`, `disabled_flag`) VALUES ('".$insertedId."','".$CostCodeValue['cost_code']."','".$CostCodeValue['cost_code_description']."','".$CostCodeValue['cost_code_description_abbreviation']."','".$CostCodeValue['sort_order']."','".$CostCodeValue['disabled_flag']."') ";
	      			if($db->execute($que5)){
	       				$costinsertedId = $db->insertId;
	      			}
					$query =
						" INSERT IGNORE
						INTO `gc_budget_line_items` (`user_company_id`, `project_id`, `cost_code_id`, `created`)
						SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id', cost_codes.`id` AS 'cost_code_id', null AS 'created'
						FROM `cost_codes`
							INNER JOIN `cost_code_divisions` ON cost_codes.`cost_code_division_id` = cost_code_divisions.`id`
						WHERE cost_code_divisions.`user_company_id` = $user_company_id
						AND cost_codes.`id`
						IN ($costinsertedId)
						";
					$arrValues = array();
					$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
					$db->free_result();

				} else {
					$query =
						" INSERT IGNORE
						INTO `gc_budget_line_items` (`user_company_id`, `project_id`, `cost_code_id`, `created`)
						SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id', cost_codes.`id` AS 'cost_code_id', null AS 'created'
						FROM `cost_codes`
							INNER JOIN `cost_code_divisions` ON cost_codes.`cost_code_division_id` = cost_code_divisions.`id`
						WHERE cost_code_divisions.`user_company_id` = $user_company_id
						AND cost_codes.`id`
						IN ($csvCostCodeIds)
						";
					$arrValues = array();
			 		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				}
			}
		}
		else
		{
			$que1="SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id', cost_codes.`id` AS 'cost_code_id', null AS 'created'
			FROM `cost_codes`
			INNER JOIN `cost_code_divisions` ON cost_codes.`cost_code_division_id` = cost_code_divisions.`id`
			WHERE cost_code_divisions.`user_company_id` = $user_company_id
			AND cost_codes.`id`
			IN ($csvCostCodeIds)";
			$arrValues = array();
			$db->execute($que1, $arrValues);
			$records=array();
			while($row1=$db->fetch())
			{
				$records=$row1;
			}
			$rec_count=count($records);
			//Insert to the costCost and Cost Division table if Does not exists
			if($rec_count=='0')
			{
				$que2="SELECT * FROM `cost_codes` WHERE `id` ='".$csvCostCodeIds."'";
				$db->execute($que2);
				$CostCodeValue=array();
				while($row2=$db->fetch())
				{
					$CostCodeValue=$row2;
				}

				$cost_id=$CostCodeValue['cost_code_division_id'];
				$que3="SELECT * FROM `cost_code_divisions` WHERE `id` ='".$cost_id."'";
				$db->execute($que3);
				$CostdivisionValue=array();
				while($row3=$db->fetch())
				{
					$CostdivisionValue=$row3;
				}

				// To insert into cost_code_divisions Table
				$que4="Insert into cost_code_divisions (`user_company_id`, `cost_code_type_id`, `division_number`, `division_code_heading`, `division`, `division_abbreviation`, `sort_order`, `disabled_flag`) values ('".$user_company_id."','".$CostdivisionValue['cost_code_type_id']."','".$CostdivisionValue['division_number']."','".$CostdivisionValue['division_code_heading']."','".$CostdivisionValue['division']."','".$CostdivisionValue['division_abbreviation']."','".$CostdivisionValue['sort_order']."','".$CostdivisionValue['disabled_flag']."') ";
				if($db->execute($que4)){
	        		$insertedId = $db->insertId;
	      		}
		        // To insert into cost_codes Table
	        	$que5=
					"
					INSERT INTO `cost_codes`(`cost_code_division_id`, `cost_code`, `cost_code_description`, `cost_code_description_abbreviation`, `sort_order`, `disabled_flag`)
					VALUES ('".$insertedId."','".$CostCodeValue['cost_code']."','".$CostCodeValue['cost_code_description']."','".$CostCodeValue['cost_code_description_abbreviation']."','".$CostCodeValue['sort_order']."','".$CostCodeValue['disabled_flag']."')";
	      		if($db->execute($que5)){
	        		$costinsertedId = $db->insertId;
	      		}
			  	$query =
						"
						INSERT IGNORE
						INTO `gc_budget_line_items` (`user_company_id`, `project_id`, `cost_code_id`, `created`)
						SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id', cost_codes.`id` AS 'cost_code_id', null AS 'created'
						FROM `cost_codes`
							INNER JOIN `cost_code_divisions` ON cost_codes.`cost_code_division_id` = cost_code_divisions.`id`
						WHERE cost_code_divisions.`user_company_id` = $user_company_id
						AND cost_codes.`id`
						IN ($costinsertedId)
						";
				$arrValues = array();
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				$db->free_result();
			} else{
				$query =
					"
					INSERT IGNORE
					INTO `gc_budget_line_items` (`user_company_id`, `project_id`, `cost_code_id`, `created`)
					SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id', cost_codes.`id` AS 'cost_code_id', null AS 'created'
					FROM `cost_codes`
						INNER JOIN `cost_code_divisions` ON cost_codes.`cost_code_division_id` = cost_code_divisions.`id`
					WHERE cost_code_divisions.`user_company_id` = $user_company_id
					AND cost_codes.`id`
					IN ($csvCostCodeIds)
					";
				$arrValues = array();
			 	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			}
		}
		$db->free_result();

	break;
	case 'importCostCodesTemplatesIntoBudget':

		$csvCostCodeIds = $get->csvCostCodeIds;

		$db = DBI::getInstance($database);
		//To check Whether the cost code Exist
		if(strpos($csvCostCodeIds,','))
		{
			$csvCostCodeIdsVal=explode(',', $csvCostCodeIds);
			foreach ($csvCostCodeIdsVal as $key => $csvCostCodeIds) {

				$que1="
					SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id',
					cost_code_templates.`id` AS 'cost_code_id', null AS 'created'
					FROM `cost_code_templates`
					INNER JOIN `cost_code_division_templates` ON cost_code_templates.`cost_code_division_template_id` = cost_code_division_templates.`id`
					WHERE cost_code_division_templates.`user_company_id` = $user_company_id
					AND cost_code_templates.`id`
					IN ($csvCostCodeIds)";
				$arrValues = array();
				$db->execute($que1, $arrValues);
				$records=array();
				while($row1=$db->fetch())
				{
					$records=$row1;
				}
				$rec_count=count($records);
				//Insert to the costCost and Cost Division table if Does not exists
				if($rec_count=='0')
				{
					$que2="SELECT * FROM `cost_code_templates` WHERE `id` ='".$csvCostCodeIds."'";
					$db->execute($que2);
					$CostCodeValue=array();
					while($row2=$db->fetch())
					{
						$CostCodeValue=$row2;
					}

					$cost_id=$CostCodeValue['cost_code_division_template_id'];
					$que3="SELECT * FROM `cost_code_division_templates` WHERE `id` ='".$cost_id."'";
					$db->execute($que3);
					$CostdivisionValue=array();
					while($row3=$db->fetch())
					{
						$CostdivisionValue=$row3;
					}

				  	//To insert into cost_code_divisions Table
				  	$que4="Insert into cost_code_divisions (`user_company_id`, `cost_code_type_id`, `division_number`, `division_code_heading`, `division`, `division_abbreviation`, `sort_order`, `disabled_flag`) values ('".$user_company_id."','".$CostdivisionValue['cost_code_type_id']."','".$CostdivisionValue['division_number']."','".$CostdivisionValue['division_code_heading']."','".$CostdivisionValue['division']."','".$CostdivisionValue['division_abbreviation']."','".$CostdivisionValue['sort_order']."','".$CostdivisionValue['disabled_flag']."') ";
					if($db->execute($que4)){
        				$insertedId = $db->insertId;
  					}
      				//To insert into cost_codes Table
			     	$que5="INSERT INTO `cost_codes`(`cost_code_division_id`, `cost_code`, `cost_code_description`, `cost_code_description_abbreviation`, `sort_order`, `disabled_flag`) VALUES
						('".$insertedId."','".$CostCodeValue['cost_code']."','".$CostCodeValue['cost_code_description']."','".$CostCodeValue['cost_code_description_abbreviation']."','".$CostCodeValue['sort_order']."','".$CostCodeValue['disabled_flag']."') ";
      				if($db->execute($que5)){
       					$costinsertedId = $db->insertId;
      				}
					$query =
						"
						INSERT IGNORE
						INTO `gc_budget_line_items` (`user_company_id`, `project_id`, `cost_code_id`, `created`)
						SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id', cost_codes.`id` AS 'cost_code_id', null AS 'created'
						FROM `cost_codes`
							INNER JOIN `cost_code_divisions` ON cost_codes.`cost_code_division_id` = cost_code_divisions.`id`
						WHERE cost_code_divisions.`user_company_id` = $user_company_id
						AND cost_codes.`id`
						IN ($costinsertedId)
						";
					$arrValues = array();
					$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
					$db->free_result();

				}
				else
				{
					$query =
						"
						INSERT IGNORE
						INTO `gc_budget_line_items` (`user_company_id`, `project_id`, `cost_code_id`, `created`)
						SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id', cost_codes.`id` AS 'cost_code_id', null AS 'created'
						FROM `cost_codes`
							INNER JOIN `cost_code_divisions` ON cost_codes.`cost_code_division_id` = cost_code_divisions.`id`
						WHERE cost_code_divisions.`user_company_id` = $user_company_id
						AND cost_codes.`id`
						IN ($csvCostCodeIds)
						";
					$arrValues = array();
					$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				}
 			}
		}
		else
		{
			$que1="
				SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id',
			  cost_code_templates.`id` AS 'cost_code_id', null AS 'created'
				FROM `cost_code_templates`
				INNER JOIN `cost_code_division_templates` ON cost_code_templates.`cost_code_division_template_id` = cost_code_division_templates.`id`
				WHERE cost_code_division_templates.`user_company_id` = $user_company_id
				AND cost_code_templates.`id`
				IN ($csvCostCodeIds)";
			$arrValues = array();
			$db->execute($que1, $arrValues);
			$records=array();
			while($row1=$db->fetch())
			{
				$records=$row1;
			}
			$rec_count=count($records);
			//Insert to the costCost and Cost Division table if Does not exists
			if($rec_count=='0')
			{
				$que2="SELECT * FROM `cost_code_templates` WHERE `id` ='".$csvCostCodeIds."'";
				$db->execute($que2);
				$CostCodeValue=array();
				while($row2=$db->fetch())
				{
					$CostCodeValue=$row2;
				}
				$cost_id=$CostCodeValue['cost_code_division_template_id'];
				$que3="SELECT * FROM `cost_code_division_templates` WHERE `id` ='".$cost_id."'";
				$db->execute($que3);
				$CostdivisionValue=array();
				while($row3=$db->fetch())
				{
					$CostdivisionValue=$row3;
				}

		 		// To insert into cost_code_divisions Table
				$que4="Insert into cost_code_divisions (`user_company_id`, `cost_code_type_id`, `division_number`, `division_code_heading`, `division`, `division_abbreviation`, `sort_order`, `disabled_flag`) values ('".$user_company_id."','".$CostdivisionValue['cost_code_type_id']."','".$CostdivisionValue['division_number']."','".$CostdivisionValue['division_code_heading']."','".$CostdivisionValue['division']."','".$CostdivisionValue['division_abbreviation']."','".$CostdivisionValue['sort_order']."','".$CostdivisionValue['disabled_flag']."') ";
				if($db->execute($que4)){
    				$insertedId = $db->insertId;
  				}
        		// To insert into cost_codes Table
		        $que5=
						"
						INSERT INTO `cost_codes`(`cost_code_division_id`, `cost_code`, `cost_code_description`, `cost_code_description_abbreviation`, `sort_order`, `disabled_flag`)
						VALUES ('".$insertedId."','".$CostCodeValue['cost_code']."','".$CostCodeValue['cost_code_description']."','".$CostCodeValue['cost_code_description_abbreviation']."','".$CostCodeValue['sort_order']."','".$CostCodeValue['disabled_flag']."')";
      			if($db->execute($que5)){
        			$costinsertedId = $db->insertId;
      			}
		  		$query =
					"
					INSERT IGNORE
					INTO `gc_budget_line_items` (`user_company_id`, `project_id`, `cost_code_id`, `created`)
					SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id', cost_codes.`id` AS 'cost_code_id', null AS 'created'
					FROM `cost_codes`
						INNER JOIN `cost_code_divisions` ON cost_codes.`cost_code_division_id` = cost_code_divisions.`id`
					WHERE cost_code_divisions.`user_company_id` = $user_company_id
					AND cost_codes.`id`
					IN ($costinsertedId)
					";
				$arrValues = array();
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				$db->free_result();
			}
			else{
				$query =
					"
					INSERT IGNORE
					INTO `gc_budget_line_items` (`user_company_id`, `project_id`, `cost_code_id`, `created`)
					SELECT $user_company_id AS 'user_company_id', $project_id AS 'project_id', cost_codes.`id` AS 'cost_code_id', null AS 'created'
					FROM `cost_codes`
						INNER JOIN `cost_code_divisions` ON cost_codes.`cost_code_division_id` = cost_code_divisions.`id`
					WHERE cost_code_divisions.`user_company_id` = $user_company_id
					AND cost_codes.`id`
					IN ($csvCostCodeIds)
					";
				$arrValues = array();
		 		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			}
		}
		$db->free_result();

	break;

	case 'loadManageGcCostCodesDialog':

		// Dummy dom id
		$uniqueId = Data::generateDummyPrimaryKey();

		$db = DBI::getInstance($database);

		$message->enqueueError("Unable to the load the master cost codes list.", $currentPhpScript);
		$cost_code_type_id = (int) preg_replace("/[^-0-9]/", '', $get->cost_code_type_id, -1);
		$cost_code_type_id = (int) $cost_code_type_id;
		$create_item_style = $get->create_item_style;
		$project_id = base64_decode($get->pID);
		if ($cost_code_type_id == -1) {
			// default cost_code_type_id to 5 for now
			$cost_code_type_id = 5;
		}

		$loadCostCodeDivisionsByUserCompanyIdOptions = new Input();
		$loadCostCodeDivisionsByUserCompanyIdOptions->arrOrderByAttributes = array(
			'ccd.`division_number`+0' => 'ASC'
		);
		$loadCostCodeDivisionsByUserCompanyIdOptions->filterval = $cost_code_type_id;
		$arrCostCodeDivisionsByUserCompanyId = CostCodeDivision::loadCostCodeDivisionsByUserCompanyId($database, $user_company_id, $loadCostCodeDivisionsByUserCompanyIdOptions);

    	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

		// Cost Code Divisions for delete or disable
		$ddlDivisions__DeleteOrDisable = <<<END_DDL_COST_CODE_DIVISIONS

<select id="ddl--delete_or_disable-cost_code_division-record--cost_code_divisions--cost_code_division_id--$uniqueId" onchange="ddlOnChange_UpdateHiddenInputValue(this, 'delete_or_disable-cost_code_division-record--cost_code_divisions--cost_code_division_id--$uniqueId');" style="margin: 0px;">
	<option value="">Please Select a Division To Delete Or Disable</option>
END_DDL_COST_CODE_DIVISIONS;

		$current_cost_code_division_id = -1;
		foreach($arrCostCodeDivisionsByUserCompanyId as $cost_code_division_id => $costCodeDivision) {
			/* @var $costCodeDivision CostCodeDivision */

			$costCodeDivision->htmlEntityEscapeProperties();

			// Division DDL
			if ($current_cost_code_division_id <> $cost_code_division_id) {

				$escaped_division_number = $costCodeDivision->escaped_division_number;
				$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
				$escaped_division = $costCodeDivision->escaped_division;
				$escaped_division_abbreviation = $costCodeDivision->escaped_division_abbreviation;

				if ($costCodeDivision->disabled_flag == 'Y') {
					$enabledFlag = 'Disabled';
				} else {
					$enabledFlag = 'Enabled';
				}
        		$costCodeDivisionsOption = $escaped_division_number.$costCodeDividerType.$escaped_division_code_heading.'&nbsp;'.$escaped_division .'&nbsp;&mdash;&nbsp;'. $enabledFlag;
				$ddlDivisions__DeleteOrDisable .= <<<END_DDL_COST_CODE_DIVISIONS

	<option value="$cost_code_division_id">$costCodeDivisionsOption</option>
END_DDL_COST_CODE_DIVISIONS;

			}
		}

		$ddlDivisions__DeleteOrDisable .= <<<END_DDL_COST_CODE_DIVISIONS

</select>
END_DDL_COST_CODE_DIVISIONS;


		// Cost Code Divisions for Cost Code Creation
		$ddlDivisions = <<<END_DDL_COST_CODE_DIVISIONS

<select id="ddl--create-cost_code-record--cost_codes--cost_code_division_id--$uniqueId" onchange="ddlOnChange_UpdateHiddenInputValue(this, 'create-cost_code-record--cost_codes--cost_code_division_id--$uniqueId');" style="margin: 0px;">
	<option value="">Please Select a Division</option>
END_DDL_COST_CODE_DIVISIONS;

		$current_cost_code_division_id = -1;
		foreach($arrCostCodeDivisionsByUserCompanyId as $cost_code_division_id => $costCodeDivision) {
			/* @var $costCodeDivision CostCodeDivision */

			$costCodeDivision->htmlEntityEscapeProperties();

			// Division DDL
			if ($current_cost_code_division_id <> $cost_code_division_id) {

				$escaped_division_number = $costCodeDivision->escaped_division_number;
				$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
				$escaped_division = $costCodeDivision->escaped_division;
				$escaped_division_abbreviation = $costCodeDivision->escaped_division_abbreviation;
        		$divisionOptions = $escaped_division_number. $costCodeDividerType. $escaped_division_code_heading. '&nbsp;' .$escaped_division;
				$ddlDivisions .= <<<END_DDL_COST_CODE_DIVISIONS

	<option value="$cost_code_division_id">$divisionOptions</option>
END_DDL_COST_CODE_DIVISIONS;

			}
		}

		$ddlDivisions .= <<<END_DDL_COST_CODE_DIVISIONS

</select>
END_DDL_COST_CODE_DIVISIONS;

$userCompanyDivider = CostCodeDividerForUserCompany::findCostCodeDividerForUserCompanyById($database, $user_company_id);
if(isset($userCompanyDivider) && !empty($userCompanyDivider)){
	$userCompanyDividerId = $userCompanyDivider->divider_id;
}else{
	$userCompanyDividerId = 1;
}
$costCodeDividerNote = "Note: This will change the divider <span id='cost-code-divider-example'>(eg : 00".$costCodeDividerType."000)</span> <br> across all cost codes in all projects, modules, reports, etc.";
// Cost Code Divider for Cost Code Creation
$loadCostCodeDividerByUserCompanyIdOptions = new Input();
$loadCostCodeDividerByUserCompanyIdOptions->arrOrderByAttributes = array(
	`cct`.`id` => 'ASC'
);
$arrCostCodeDividerByUserCompanyId = CostCodeDivider::loadAllCostCodeDividers($database, $loadCostCodeDividerByUserCompanyIdOptions);
$ddlDivider = <<<END_DDL_COST_CODE_DIVIDER

<select id="ddl--create-cost_code-record--cost_codes--cost_code_divider_id--$uniqueId" onchange="ddlOnChange_UpdateHiddenInputValue(this, 'create-cost_code-record--cost_codes--cost_code_divider_id--$uniqueId');getSelectedCostCodeDivider(this)" style="margin: 0px;">
<!--<option value="">Please Select a Divider</option>-->
END_DDL_COST_CODE_DIVIDER;
foreach($arrCostCodeDividerByUserCompanyId as $cost_code_divider_id => $costCodeDivider) {
	/* @var $costCodeDivider CostCodeDivider */
  $selectedOption = $cost_code_divider_id == $userCompanyDividerId ? 'selected' : '';
	$costCodeDivider->htmlEntityEscapeProperties();
	$escaped_divider_type = $costCodeDivider->divider_type;
	$ddlDivider .= <<<END_DDL_COST_CODE_DIVIDER
			<option value="$cost_code_divider_id" $selectedOption>$escaped_divider_type</option>
END_DDL_COST_CODE_DIVIDER;

}

$ddlDivider .= <<<END_DDL_COST_CODE_DIVIDER

</select>
END_DDL_COST_CODE_DIVIDER;

		# Cost codes by GC Master List
		$query =
"
SELECT cctypes.*
FROM cost_code_types cctypes
WHERE EXISTS (
	SELECT 1
	FROM `cost_code_divisions` ccd
	INNER JOIN `cost_codes` codes ON codes.`cost_code_division_id` = ccd.`id`
	WHERE ccd.`user_company_id` = ?
	AND cctypes.`id` = ccd.`cost_code_type_id`
)
ORDER BY cctypes.cost_code_type
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodesByGCMasterList = array();
		while ($row = $db->fetch()) {
			$cost_code_type_id_new = $row['id'];
			$cost_code_type = $row['cost_code_type'];
			$costCodeKey = "gc_cct_id:$cost_code_type_id_new";
			$arrCostCodesByGCMasterList[$costCodeKey] = "$userCompany->escaped_user_company_name Codes :: $cost_code_type";
		}
		$db->free_result();

		// Owner cost code list
		$company_arr = Contact::OwnerContactInGCProjectForadminProject($database,$project_id);
		$company_list = <<<END_COMPANY
		<table id="tblownercost" border="0" cellpadding="5" cellspacing="0" style="margin-bottom:10px;" width="100%">
				<tr>
					<th colspan="6" style="text-align: left;">
						Select Company :
		<select id="ddlCompanylist" class="ddlCompanylist" onchange="updateownerdata()">
		<option value="" >Select Company</option>
END_COMPANY;
		foreach ($company_arr as $key => $compval) {
			$compid = $key;
			$compName = $compval;
			if($compid == $user_company_id)
			{
				$select ="selected";
			}else
			{
				$select ="";
			}
			$company_list .= <<<END_COMPANY
			<option value="$compid" $select>$compName</option>
END_COMPANY;

		}


$company_list .= <<<END_COMPANY
		</select>
		</th></tr></table>
END_COMPANY;


		$htmlContent = <<<END_HTML_CONTENT

			<table id="tblImportCostCodes" border="1" cellpadding="5" cellspacing="0" style="margin-bottom:10px;" width="100%">
				<tr>
					<th colspan="6" style="text-align: left;">
						Manage Cost Codes:
						<select id="ddlCostCodeTypeId" onchange="loadManageGcCostCodesDialog();">
END_HTML_CONTENT;

		$arrDropDownList = $arrCostCodesByGCMasterList;
		$importCostCodesFromId = "gc_cct_id:$cost_code_type_id";
		foreach ($arrDropDownList AS $costCodeSourceId => $costCodeSourceName) {
			if ($costCodeSourceId == $importCostCodesFromId) {

				$htmlContent .= <<<END_HTML_CONTENT

							<option value="$costCodeSourceId" selected>$costCodeSourceName</option>
END_HTML_CONTENT;

			} else {
				$htmlContent .= <<<END_HTML_CONTENT

							<option value="$costCodeSourceId">$costCodeSourceName</option>
END_HTML_CONTENT;

			}
		}

		$htmlContent .= <<<END_HTML_CONTENT

						</select>

						<script>
							$('.numbers-only').on('input',function() {
								this.value = this.value.replace(/[^\d]/g, '');
							});
							function toggleCreateNewCostCodeDatum()
							{
								$("#createNewCostCodesContainer").toggle();

							}
							function toggleCreateOwnerCostCodeDatum()
							{
								$("#createOwnerCostCodesContainer").toggle();
								$(".owner_data").toggle();
								updateownerdata();

							}
						</script>

						<input id="createNewCostCodes" name="createNewCostCodes" onclick="toggleCreateNewCostCodeDatum();" type="button" value="Show / Hide Cost Code Management Forms">
						<input id="createOwnerCostCodes" name="createOwnerCostCodes" onclick="toggleCreateOwnerCostCodeDatum();" type="button" value="Create Owner Cost code">
						<input id="refreshCreateNewCostCodes" name="refreshCreateNewCostCodes" onclick="loadManageGcCostCodesDialog();" type="button" value="Refresh">
						<div id="createOwnerCostCodesContainer" style="$create_item_style">
						$company_list
						</div>
						<div id="createNewCostCodesContainer" style="$create_item_style">
						<br>

						<form id="record_management_form_container--cost_code_divisions">
							<input id="delete-cost_code_division-record--cost_code_divisions--cost_code_type_id--$uniqueId" type="hidden" value="$cost_code_type_id">
							<table cellpadding="2" cellspacing="2" style="border: 1px #ccc dashed;">
								<tr>
									<td colspan="2">[Delete or Disable a Division]</td>
								</tr>
								<tr>
									<td align="right">Division: </td>
									<td>
										$ddlDivisions__DeleteOrDisable
										<input id="delete_or_disable-cost_code_division-record--cost_code_divisions--cost_code_division_id--$uniqueId" type="hidden">
									</td>
								</tr>
								<tr>
									<td align="right" colspan="2">
										<input type="reset" value="Reset">&nbsp;
										<input type="button" onclick="Gc_Budget__Cost_Codes_Admin_Modal__deleteOrDisableCostCodeDivision(this, event, '$uniqueId', { crudOperation: 'update' });" value="Toggle Enabled/Disabled">
										<input type="button" onclick="Gc_Budget__Cost_Codes_Admin_Modal__deleteOrDisableCostCodeDivision(this, event, '$uniqueId', { crudOperation: 'delete' });" value="Delete This Division">
									</td>
								</tr>
							</table>
						</form>

						<br>

						<form id="record_creation_form_container--cost_code_divisions">
							<input id="create-cost_code_division-record--cost_code_divisions--cost_code_type_id--$uniqueId" type="hidden" value="$cost_code_type_id">
							<table cellpadding="2" cellspacing="2" style="border: 1px #ccc dashed;">
								<tr>
									<td colspan="2">[Create a New Division]</td>
								</tr>
								<tr>
									<td align="right">Division Number: </td>
									<td><input class="numbers-only" id="create-cost_code_division-record--cost_code_divisions--division_number--$uniqueId" type="text"></td>
								</tr>
								<tr>
									<td align="right">Division Code Heading Number: </td>
									<td><input class="numbers-only" id="create-cost_code_division-record--cost_code_divisions--division_code_heading--$uniqueId" type="text" value="000"></td>
								</tr>
								<tr>
									<td align="right">Division Name: </td>
									<td><input id="create-cost_code_division-record--cost_code_divisions--division--$uniqueId" type="text"></td>
								</tr>
								<tr>
									<td align="right">Division Abbreviation: </td>
									<td><input id="create-cost_code_division-record--cost_code_divisions--division_abbreviation--$uniqueId" type="text"></td>
								</tr>
								<!--tr>
									<td align="right">Sort Order: </td>
									<td><input id="create-cost_code_division-record--cost_code_divisions--sort_order--$uniqueId" type="text"></td>
								</tr>
								<tr>
									<td align="right">Disabled Flag: </td>
									<td><input id="create-cost_code_division-record--cost_code_divisions--disabled_flag--$uniqueId" type="text"></td>
								</tr-->
								<tr>
									<td align="right" colspan="2">
										<input type="reset" value="Reset">&nbsp;
										<input type="button" onclick="Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDivision(this, event, 'create-cost_code_division-record', '$uniqueId');" value="Create New Cost Code Division">
									</td>
								</tr>
							</table>
						</form>

						<br>
						<form id="record_creation_form_container--cost_code_divider">
						<table cellpadding="2" cellspacing="2" style="border: 1px #ccc dashed;">
							<tr>
								<td colspan="2">[Set Cost Code Divider]</td>
							</tr>
							<tr>
								<td align="right">Cost Code Divider: </td>
								<td>
									$ddlDivider
									<input id="create-cost_code-record--cost_codes--cost_code_divider_id--$uniqueId" type="hidden">
								</td>
							</tr>
							<tr>
								<td align="right" colspan="2">
									<input type="button" onclick="Gc_Budget__Cost_Codes_Admin_Modal__createCostCodeDivider(this, 'create-cost_code_divider-record', '$uniqueId');" value="Save Cost Code Divider">
								</td>
							</tr>
							<tr>
							 <td colspan="2">
						  	<span style="font-weight: normal;font-size: 11px;">
								 $costCodeDividerNote
								</span>
							 </td>
							</tr>
						</table>
						</form>

						<br>

						<form id="record_creation_form_container--cost_codes">
						<table cellpadding="2" cellspacing="2" style="border: 1px #ccc dashed;">
							<tr>
								<td colspan="2">[Create a New Cost Code]</td>
							</tr>
							<tr>
								<td align="right">Division: </td>
								<td>
									$ddlDivisions
									<input id="create-cost_code-record--cost_codes--cost_code_division_id--$uniqueId" type="hidden">
								</td>
							</tr>
							<tr>
								<td align="right">Cost Code: </td>
								<td><input id="create-cost_code-record--cost_codes--cost_code--$uniqueId" type="text"></td>
							</tr>
							<tr>
								<td align="right">Cost Code Description: </td>
								<td><input id="create-cost_code-record--cost_codes--cost_code_description--$uniqueId" type="text"></td>
							</tr>
							<tr>
								<td align="right">Cost Code Description Abbreviation: </td>
								<td><input id="create-cost_code-record--cost_codes--cost_code_description_abbreviation--$uniqueId" type="text"></td>
							</tr>
							<tr>
								<td align="right" colspan="2">
									<input type="reset" value="Reset">&nbsp;
									<input type="button" onclick="Gc_Budget__Cost_Codes_Admin_Modal__createCostCode(this, event, 'create-cost_code-record', '$uniqueId');" value="Create New Cost Code">
								</td>
							</tr>
						</table>
						</form>
						<br>
					</div>
				</th>
			</tr>
			<tr>
				<th width="2%">&nbsp;</th>
				<th style="text-align: right;" width= 10%;>Division Number</th>
				<th style="text-align: left;" width=10%;>Cost Code</th>
				<th style="text-align: left;" width= 25%;>Cost Code Description</th>
				<th style="text-align: left;" width= 25%;>Cost Code Description Abbreviation</th>
				<th style="text-align: left;$create_item_style;" width= 25%  class="owner_data" >Owner Cost Code</th>
			</tr>
END_HTML_CONTENT;

		$arrCostCodesByUserCompanyIdAndCostCodeTypeId = CostCode::loadCostCodesByUserCompanyIdAndCostCodeTypeIdCustomize($database, $user_company_id, $cost_code_type_id);

		$divisionHeading = '';
		$current_cost_code_division_id = -1;
		foreach ($arrCostCodesByUserCompanyIdAndCostCodeTypeId AS $cost_code_id => $costCode) {
			
			$cost_code_id = $costCode->id;
			/* @var $costCode CostCode */

			$costCode->htmlEntityEscapeProperties();

			$escaped_cost_code = $costCode->escaped_cost_code;
			$escaped_cost_code_description = $costCode->escaped_cost_code_description;
			$escaped_cost_code_description_abbreviation = $costCode->escaped_cost_code_description_abbreviation;

			$costCodeDivision = $costCode->getCostCodeDivision();
			/* @var $costCodeDivision CostCodeDivision */

			$costCodeDivision->htmlEntityEscapeProperties();

			$cost_code_division_id = $costCodeDivision->cost_code_division_id;
			$escaped_division_number = $costCodeDivision->escaped_division_number;
			$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
			$escaped_division = $costCodeDivision->escaped_division;
			$escaped_division_abbreviation = $costCodeDivision->escaped_division_abbreviation;

			if ($current_cost_code_division_id <> $cost_code_division_id) {
				$noCostCode = '';
				$style = 'style="margin-left: 5%;"';
				if (!$cost_code_id) {
					$noCostCode = "( No Cost Code Mapping )";
					$style = '';
				}
				/* Vector Report - Start */
				//
				$vectorreportgroup_arr = array(
											'1'=>'GENERAL CONDITIONS',
											'2'=>'SITEWORK COSTS',
											'3'=>'BUILDING COSTS',
											'4'=>'SOFT COSTS'
										);
				$vectorreportgroup = '<span '.$style.'>Group - 
										<select id="manage-cost_code_division-record--cost_code_divisions--division_number_group_id--'.$cost_code_division_id.'" data-origin-id="cost_code_divisions--division_number_group_id--'.$cost_code_division_id.'" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCodeDivision(this);">
											<option value="">Select a Group</option>';
				foreach($vectorreportgroup_arr as $key=>$value){
					$selected = '';
					if(!empty($costCodeDivision->division_number_group_id) && $key ==$costCodeDivision->division_number_group_id){
						$selected = 'selected';
					}
					$vectorreportgroup .='<option value="'.$key.'" '.$selected.' >'.$value.'</option>';
				}
				$vectorreportgroup .= 	'</select>
									</span>';
				/* Vector Report - End */
				$divisionHeading = <<<END_CURRENT_DIVISION_HEADING

						<a style="font-weight: normal;" href="javascript:Gc_Budget__Cost_Codes_Admin_Modal__deleteCostCodeDivision('record_container--manage-cost_code_division-record--cost_code_divisions--sort_order--$cost_code_division_id', 'manage-cost_code_division-record', '$cost_code_division_id', { dummy_id: '$uniqueId' });">X</a>
						Division
						<input id="division_number_previous-$cost_code_division_id" type="hidden" value="$escaped_division_number">
						<input id="division_code_heading_previous-$cost_code_division_id" type="hidden" value="$escaped_division_code_heading">
						<input id="division_previous-$cost_code_division_id" type="hidden" value="$escaped_division">
						<input id="division_abbreviation_previous-$cost_code_division_id" type="hidden" value="$escaped_division_abbreviation">

						<input class="numbers-only" id="manage-cost_code_division-record--cost_code_divisions--division_number--$cost_code_division_id" data-origin-id="cost_code_divisions--division_number--$cost_code_division_id" style="margin: 0 3px 0 10px; text-align: right; width: 40px;" type="text" value="$escaped_division_number" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCodeDivision(this);">$costCodeDividerType<input class="numbers-only" id="manage-cost_code_division-record--cost_code_divisions--division_code_heading--$cost_code_division_id" data-origin-id="cost_code_divisions--division_code_heading--$cost_code_division_id" style="margin: 0 20px 0 3px; text-align: left; width: 40px;" type="text" value="$escaped_division_code_heading" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCodeDivision(this);">
						<input id="manage-cost_code_division-record--cost_code_divisions--division--$cost_code_division_id" data-origin-id="cost_code_divisions--division--$cost_code_division_id" style="width: 250px;" type="text" value="$escaped_division" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCodeDivision(this);">
						<input id="manage-cost_code_division-record--cost_code_divisions--division_abbreviation--$cost_code_division_id" data-origin-id="cost_code_divisions--division_abbreviation--$cost_code_division_id" style="width: 200px;" type="text" value="$escaped_division_abbreviation" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCodeDivision(this);"> $noCostCode
							$vectorreportgroup
END_CURRENT_DIVISION_HEADING;

				$htmlContent .= <<<END_HTML_CONTENT

				<tr id="record_container--manage-cost_code_division-record--cost_code_divisions--sort_order--$cost_code_division_id" style="background: #D2DF9A;">
					<th colspan="6" align="left">
						$divisionHeading
					</th>
				</tr>
END_HTML_CONTENT;

				$current_cost_code_division_id = $cost_code_division_id;

			}
			if(!$cost_code_id)
			{
				continue;
			}
			$htmlContent .= <<<END_HTML_CONTENT

				<tr id="record_container--manage-cost_code-record--cost_codes--sort_order--$cost_code_id">
					<td class="textAlignCenter"><a href="javascript:Gc_Budget__Cost_Codes_Admin_Modal__deleteCostCode('record_container--manage-cost_code-record--cost_codes--sort_order--$cost_code_id', 'manage-cost_code-record', '$cost_code_id');">X</a></td>
					<td align="right">$escaped_division_number</td>
					<td>
						<input id="previous--manage-cost_code-record--cost_codes--cost_code--$cost_code_id" type="hidden" value="$escaped_cost_code">
						<input id="manage-cost_code-record--cost_codes--cost_code--$cost_code_id" data-origin-id="cost_codes--cost_code--$cost_code_id" type="text" value="$escaped_cost_code" class="input-costCode" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCode(this);">
					</td>
					<td>
						<input id="previous--manage-cost_code-record--cost_codes--cost_code_description--$cost_code_id" type="hidden" value="$escaped_cost_code_description">
						<input id="manage-cost_code-record--cost_codes--cost_code_description--$cost_code_id" data-origin-id="cost_codes--cost_code_description--$cost_code_id" style="width: 96%;" type="text" value="$escaped_cost_code_description" class="input-lineItem" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCode(this);">
					</td>
					<td>
						<input id="previous--manage-cost_code-record--cost_codes--cost_code_description_abbreviation--$cost_code_id" type="hidden" value="$escaped_cost_code_description_abbreviation">
						<input id="manage-cost_code-record--cost_codes--cost_code_description_abbreviation--$cost_code_id" data-origin-id="cost_codes--cost_code_description_abbreviation--$cost_code_id" style="width: 96%;" type="text" value="$escaped_cost_code_description_abbreviation" class="input-lineItem" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCode(this);">
					</td>
					<td class="owner_data" style="$create_item_style">
						
						<input id="manage-cost_code-record--cost_code_alias--owner_cost_code--$cost_code_id" data-origin-id="cost_codes--owner_cost_code--$cost_code_id" style="width: 96%;" type="text" value="" class="input-lineItem owner_ccode" onchange="Gc_Budget__updateOwnerCostCode($cost_code_id,$cost_code_division_id,this.value);">
					</td>
				</tr>
END_HTML_CONTENT;

		}

		$htmlContent .= <<<END_HTML_CONTENT
			</table>
END_HTML_CONTENT;

		echo $htmlContent;

	break;

	case 'createOwnerCostCode':
	$user_company = $get->user_company_id;
	$cost_id = $get->cost_id;
	$division_id = $get->division_id;
	$newValue = $get->newValue;
		$db = DBI::getInstance($database);
		$Query = "SELECT * from `cost_code_alias`where  `cost_code_id` =? and  `cost_code_divison_id`=? and  `user_company_id`=? ";
		$arrValues = array($cost_id,$division_id,$user_company);
		$db->execute($Query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		if($row)
		{
			$db = DBI::getInstance($database);
			$Query = "UPDATE `cost_code_alias` SET  `owner_cost_code` = ? where `cost_code_id` = ? and  `cost_code_divison_id` =?  and `user_company_id`=? ";
			$arrValues = array($newValue,$cost_id,$division_id,$user_company);
			if($db->execute($Query, $arrValues))
			{
				$res ='1';
			}else
			{
				$res ='0';
			}
			$db->free_result();
		}else
		{
			$db = DBI::getInstance($database);
			$Query = "INSERT INTO `cost_code_alias`( `cost_code_id`, `cost_code_divison_id`, `user_company_id`, `owner_cost_code`) VALUES (?,?,?,?)";
			
			$arrValues = array($cost_id,$division_id,$user_company,$newValue);
			if($db->execute($Query, $arrValues))
			{
				$res ='1';
			}
			else
			{
				$res ='0';
			}
			$db->free_result();
		}
	echo $res;

	break;

	case 'UpdateOwnerCostCode':
	$user_company = $get->user_company_id;
	$db = DBI::getInstance($database);
		$Query = "SELECT * from `cost_code_alias`where  `user_company_id`=? ";
		$arrValues = array($user_company);
		$db->execute($Query, $arrValues, MYSQLI_USE_RESULT);
		$ownerdata  = '';
		while($row = $db->fetch())
		{
			$id = $row['id'];
			$ownerdata .= $row['cost_code_id'].'~'.$row['owner_cost_code'].'~~';

		}
		$db->free_result();
		echo $ownerdata;

	break;

	case 'deleteCostCode':

		$cost_code_id = $get->cost_code_id;
		$allowDelete = true;



		// Check budgets
		$query =
			"
			SELECT *
			FROM gc_budget_line_items
			WHERE cost_code_id = ?
			LIMIT 1
			";
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row) {
			// Do not allow cost code to be deleted
			$allowDelete = false;
		}

		// Check bid lists
		$query =
			"
			SELECT *
			FROM subcontractor_trades
			WHERE cost_code_id = ?
			LIMIT 1
			";
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row) {
			// Do not allow cost code to be deleted
			$allowDelete = false;
		}

		if ($allowDelete) {
			// Deletion of cost code is allowed since it is not in active use
			$query =
				"
				DELETE FROM cost_codes
				WHERE id = ?
				";
			$arrValues = array($cost_code_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			echo $cost_code_id;
		} else {
			$errorMessage = "Cost code is in active use and cannot be deleted.";
			$message->enqueueError($errorMessage, $currentPhpScript);
			$error->outputErrorMessages();
			exit;
		}

	break;

	case 'deleteCostCodeDivision':

		$cost_code_division_id = $get->cost_code_division_id;
		$allowDelete = true;


		// Check budgets
		$query =
			"
			SELECT *
			FROM `gc_budget_line_items` gbli INNER JOIN `cost_codes` codes ON gbli.`cost_code_id` = codes.`id`
			INNER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
			WHERE ccd.`id` = ?
			LIMIT 1
			";
		$arrValues = array($cost_code_division_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row) {
			// Do not allow cost code to be deleted
			$allowDelete = false;
		}

		// Check bid lists
		$query =
			"
			SELECT *
			FROM `subcontractor_trades` st INNER JOIN `cost_codes` codes ON st.`cost_code_id` = codes.`id`
			INNER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
			WHERE ccd.`id` = ?
			LIMIT 1
			";
		$arrValues = array($cost_code_division_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row) {
			// Do not allow cost code to be deleted
			$allowDelete = false;
		}

		// Debug


		if ($allowDelete) {
			// Deletion of cost code is allowed since it is not in active use
			$db->begin();

			$query =
				"
				DELETE FROM cost_codes
				WHERE cost_code_division_id = ?
				";
			$arrValues = array($cost_code_division_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$query =
				"
				DELETE FROM cost_code_divisions
				WHERE id = ?
				";
			$arrValues = array($cost_code_division_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$db->commit();

			echo $cost_code_division_id;
		} else {
			$errorMessage = "Cost code division contains cost codes that are in active use and cannot be deleted.";
			$message->enqueueError($errorMessage, $currentPhpScript);
			$error->outputErrorMessages();
			exit;
		}

	break;

	case 'loadManageGcCostCodeAliasesDialog':

		$db = DBI::getInstance($database);

		$message->enqueueError("Unable to the load the master cost codes list.", $currentPhpScript);
		$cost_code_type_id = (int) preg_replace("/[^-0-9]/", '', $get->cost_code_type_id, -1);
		$cost_code_type_id = (int) $cost_code_type_id;

		if ($cost_code_type_id == -1) {
			// default cost_code_type_id to 5 for now
			$cost_code_type_id = 5;
		}

		$query =
			"
			SELECT
				ccd.*,
				codes.*,
				ccda.*,
				cca.*,
				ccd.`id` as 'cost_code_division_id',
				codes.`id` AS 'cost_code_id',
				ccda.`id` as 'cost_code_division_alias_id',
				cca.`id` as 'cost_code_alias_id'
			FROM `cost_code_divisions` ccd
				INNER JOIN `cost_codes` codes ON ccd.`id` = codes.`cost_code_division_id`
				LEFT OUTER JOIN `cost_code_division_aliases` ccda ON
					(ccd.`user_company_id` = ccda.`user_company_id` AND ccda.`project_id` = ? AND ccd.`id` = ccda.`cost_code_division_id`)
				LEFT OUTER JOIN `cost_code_aliases` cca ON
					(ccd.`user_company_id` = cca.`user_company_id` AND cca.`project_id` = ? AND codes.`id` = cca.`cost_code_id`)
			WHERE ccd.`user_company_id` = ?
			AND ccd.`cost_code_type_id` = ?
			ORDER BY ccd.`division_number` ASC, codes.`cost_code` ASC
			";
		// Debug
		$arrValues = array($project_id, $project_id, $user_company_id, $cost_code_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrMasterCostCodes = array();
		while ($row = $db->fetch()) {
			$arrMasterCostCodes[] = $row;
		}
		$db->free_result();



		# Cost codes by GC Master List
		$query =
			"
			SELECT cctypes.*
			FROM cost_code_types cctypes
			WHERE EXISTS (
				SELECT 1
				FROM `cost_code_divisions` ccd
				INNER JOIN `cost_codes` codes ON codes.`cost_code_division_id` = ccd.`id`
				WHERE ccd.`user_company_id` = ?
				AND cctypes.`id` = ccd.`cost_code_type_id`
			)
			ORDER BY cctypes.cost_code_type
			";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodesByGCMasterList = array();
		while ($row = $db->fetch()) {
			$cost_code_type_id = $row['id'];
			$cost_code_type = $row['cost_code_type'];
			$costCodeKey = "gc_cct_id:$cost_code_type_id";
			$arrCostCodesByGCMasterList[$costCodeKey] = "$userCompany->company Codes :: $cost_code_type";
		}
		$db->free_result();

		// @todo Add ddl of contact companies to drive the aliases feature
		$arrContactCompaniesByUserUserCompanyId = ContactCompany::loadContactCompaniesByUserUserCompanyId($database, $user_company_id);
		
		$ddlHtmlName = "ddlContactCompanyId";
		$contactsByContactCompanyIdDropDownList =
			PageComponents::dropDownListFromObjects($ddlHtmlName, $arrContactCompaniesByUserUserCompanyId, 'contact_company_id', null, 'company', null, '', '', '', '<option value="">Please Select a Company</option>');


		echo '
			<input id="gc_cost_codes--user_companies--user_company_id--'.$user_company_id.'" type="hidden" value="'.$user_company_id.'">
			<input id="aliases_project_id" type="hidden" value="'.$project_id.'">
			<input id="aliases_cost_code_division_alias_id" type="hidden" value="">
			<div id="costCodesContainer">
			<table id="tblImportCostCodes" border="1" cellpadding="5" cellspacing="0" style="margin-bottom:10px;" width="100%">
				<tr>
					<th colspan="5" style="text-align: left;">
						Manage Cost Code Aliases:
						<select id="ddlCostCodeTypeId" onchange="loadManageGcCostCodesDialog();">
		';
		$arrDropDownList = $arrCostCodesByGCMasterList;
		$importCostCodesFromId = "gc_cct_id:$cost_code_type_id";
		foreach ($arrDropDownList AS $costCodeSourceId => $costCodeSourceName) {
			if ($costCodeSourceId == $importCostCodesFromId) {
				echo '
							<option value="'.$costCodeSourceId.'" selected>'.$costCodeSourceName.'</option>
				';
			} else {
				echo '
							<option value="'.$costCodeSourceId.'">'.$costCodeSourceName.'</option>
				';
			}
		}

		echo '
						</select>
						<br>Company to Alias Cost Codes for: '.$contactsByContactCompanyIdDropDownList.'
					</th>
				</tr>
				<tr>
					<th width="30px">&nbsp;</th>
					<th style="text-align: right; width: 85px;">Division<br>Number Alias</th>
					<th style="text-align: left; width: 85px;">Cost<br>Code Alias</th>
					<th style="text-align: left; width: 425px;">Cost Code<br>Description Alias</th>
					<th style="text-align: left; width: 325px;">Cost Code Description<br>Abbreviation Alias</th>
				</tr>
		';

		$divisionHeading = '';
		foreach ($arrMasterCostCodes AS $row) {
			$cost_code_division_id = $row['cost_code_division_id'];
			$cost_code_id = $row['cost_code_id'];
			$division_number = $row['division_number'];
			$division_code_heading = $row['division_code_heading'];
			$division = $row['division'];
			$division_abbreviation = $row['division_abbreviation'];
			$cost_code = $row['cost_code'];
			$cost_code_description = $row['cost_code_description'];
			$cost_code_description_abbreviation = $row['cost_code_description_abbreviation'];

			// Aliased values
			$cost_code_division_alias_id = $row['cost_code_division_alias_id'];
			$cost_code_alias_id = $row['cost_code_alias_id'];
			$division_number_alias = $row['division_number_alias'];
			$division_code_heading_alias = $row['division_code_heading_alias'];
			$division_alias = $row['division_alias'];
			$division_abbreviation_alias = $row['division_abbreviation_alias'];
			$cost_code_alias = $row['cost_code_alias'];
			$cost_code_description_alias = $row['cost_code_description_alias'];
			$cost_code_description_abbreviation_alias = $row['cost_code_description_abbreviation_alias'];

			$currentDivisionHeading = <<<END_CURRENT_DIVISION_HEADING

				<table border="3">
					<tr>
						<td>
							Division
							<input id="previous--gc_cost_codes--cost_code_divisons--division_number--$cost_code_division_id" type="hidden" value="$division_number">
							<input id="previous--gc_cost_codes--cost_code_divisons--division_code_heading--$cost_code_division_id" type="hidden" value="$division_code_heading">
							<input id="previous--gc_cost_codes--cost_code_divisons--division--$cost_code_division_id" type="hidden" value="$division">
							<input id="previous--gc_cost_codes--cost_code_divisons--division_abbreviation--$cost_code_division_id" type="hidden" value="$division_abbreviation">
						</td>
						<td>
							<input id="gc_cost_codes--cost_code_divisons--division_number--$cost_code_division_id" style="margin: 0 3px 0 10px; text-align: right; width: 40px;" type="text" value="$division_number" readonly>
						</td>
						<td>-</td>
						<td>
							<input id="gc_cost_codes--cost_code_divisons--division_code_heading--$cost_code_division_id" style="margin: 0 20px 0 3px; text-align: left; width: 40px;" type="text" value="$division_code_heading" readonly>
						</td>
						<td>
							<input id="gc_cost_codes--cost_code_divisons--division--$cost_code_division_id" style="width: 250px;" type="text" value="$division" readonly>
						</td>
						<td>
							<input id="gc_cost_codes--cost_code_divisons--division_abbreviation--$cost_code_division_id" style="width: 200px;" type="text" value="$division_abbreviation" readonly>
						</td>
					</tr>
					<tr>
						<td>
							<a id="hrefDeleteCostCodeDivisionAlias$cost_code_division_id" style="font-weight: normal;" href="javascript:deleteCostCodeAliasData('cost_code_division_alias_id', '$cost_code_division_alias_id');">X</a>&nbsp;Alias
							<input id="previous--gc_cost_codes--cost_code_divison_aliases--division_number_alias--$cost_code_division_id" type="hidden" value="$division_number_alias">
							<input id="previous--gc_cost_codes--cost_code_divison_aliases--division_code_heading_alias--$cost_code_division_id" type="hidden" value="$division_code_heading_alias">
							<input id="previous--gc_cost_codes--cost_code_divison_aliases--division_alias--$cost_code_division_id" type="hidden" value="$division_alias">
							<input id="previous--gc_cost_codes--cost_code_divison_aliases--division_abbreviation_alias--$cost_code_division_id" type="hidden" value="$division_abbreviation_alias">
						</td>
						<td>
							<input id="gc_cost_codes--cost_code_divison_aliases--division_number_alias--$cost_code_division_id" style="margin: 0 3px 0 10px; text-align: right; width: 40px;" type="text" value="$division_number_alias" onchange="updateCostCodeAliasData(this);">
						</td>
						<td>-</td>
						<td>
							<input id="gc_cost_codes--cost_code_divison_aliases--division_code_heading_alias--$cost_code_division_id" style="margin: 0 20px 0 3px; text-align: left; width: 40px;" type="text" value="$division_code_heading_alias" onchange="updateCostCodeAliasData(this);">
						</td>
						<td>
							<input id="gc_cost_codes--cost_code_divison_aliases--division_alias--$cost_code_division_id" style="width: 250px;" type="text" value="$division_alias" onchange="updateCostCodeAliasData(this);">
						</td>
						<td>
							<input id="gc_cost_codes--cost_code_divison_aliases--division_abbreviation_alias--$cost_code_division_id" style="width: 200px;" type="text" value="$division_abbreviation_alias" onchange="updateCostCodeAliasData(this);">
						</td>
					</tr>
				</table>
END_CURRENT_DIVISION_HEADING;

			if ($currentDivisionHeading <> $divisionHeading) {
				$divisionHeading = $currentDivisionHeading;
				echo '
				<tr id="record_container--gc_cost_codes--cost_code_division_aliases--cost_code_division_alias--'.$cost_code_division_alias_id.'" style="background: #D2DF9A;"><th colspan="5" align="left">'.$divisionHeading.'</th></tr>
				';
			}

			$htmlContent = <<<END_HTML_CONTENT

				<tr id="record_container--gc_cost_codes--cost_code_aliases--cost_code_alias--$cost_code_id">
				<td colspan="5">
					<table>
					<tr>
					<td width="30px">&nbsp;</td>
					<td style="text-align: right; width: 85px;">$division_number</td>
					<td style="text-align: right; width: 85px;">
						<input id="previous--manage-cost_code-record--cost_codes--cost_code--$cost_code_id" type="hidden" value="$cost_code">
						<input id="manage-cost_code-record--cost_codes--cost_code--$cost_code_id" type="text" value="$cost_code" class="input-costCode" readonly>
					</td>
					<td style="text-align: right; width: 425px;">
						<input id="previous--manage-cost_code-record--cost_codes--cost_code_description--$cost_code_id" type="hidden" value="$cost_code_description">
						<input id="manage-cost_code-record--cost_codes--cost_code_description--$cost_code_id" style="width: 96%;" type="text" value="$cost_code_description" class="input-lineItem" readonly>
					</td>
					<td style="text-align: right; width: 325px;">
						<input id="previous--manage-cost_code-record--cost_codes--cost_code_description_abbreviation--$cost_code_id" type="hidden" value="$cost_code_description_abbreviation">
						<input id="manage-cost_code-record--cost_codes--cost_code_description_abbreviation--$cost_code_id" style="width: 96%;" type="text" value="$cost_code_description_abbreviation" class="input-lineItem" readonly>
					</td>
					</tr>

					<tr>
					<td width="30px"><a id="hrefDeleteCostCodeAlias$cost_code_id" href="javascript:deleteCostCodeAliasData('cost_code_alias_id', '$cost_code_alias_id');">X</a></td>
					<td style="text-align: right; width: 85px;">$division_number_alias</td>
					<td style="text-align: right; width: 85px;">
						<input id="previous--gc_cost_codes--cost_code_aliases--cost_code_alias--$cost_code_id" type="hidden" value="$cost_code_alias">
						<input id="gc_cost_codes--cost_code_aliases--cost_code_alias--$cost_code_id" type="text" value="$cost_code_alias" class="input-costCode" onchange="updateCostCodeAliasData(this);">
					</td>
					<td style="text-align: right; width: 425px;">
						<input id="previous--gc_cost_codes--cost_code_aliases--cost_code_description_alias--$cost_code_id" type="hidden" value="$cost_code_description_alias">
						<input id="gc_cost_codes--cost_code_aliases--cost_code_description_alias--$cost_code_id" style="width: 100%;" type="text" value="$cost_code_description_alias" class="input-lineItem" onchange="updateCostCodeAliasData(this);">
					</td>
					<td style="text-align: right; width: 325px;">
						<input id="previous--gc_cost_codes--cost_code_aliases--cost_code_description_abbreviation_alias$cost_code_id" type="hidden" value="$cost_code_description_abbreviation_alias">
						<input id="gc_cost_codes--cost_code_aliases--cost_code_description_abbreviation_alias$cost_code_id" style="width: 100%;" type="text" value="$cost_code_description_abbreviation_alias" class="input-lineItem" onchange="updateCostCodeAliasData(this);">
					</td>
					</tr>
					</table>
				</td>
				</tr>
END_HTML_CONTENT;
			echo $htmlContent;

		}

		echo '
			</table>
			</div>
		';

	break;

	case 'loadCostCodeDivisionAliases':

		$db = DBI::getInstance($database);

		$message->enqueueError("Unable to the load the cost code division aliases.", $currentPhpScript);
		$cost_code_type_id = (int) preg_replace("/[^-0-9]/", '', $get->cost_code_type_id, -1);
		$cost_code_type_id = (int) $cost_code_type_id;

		$user_company_id = $get->user_company_id;
		$project_id = $get->project_id;
		$contact_company_id = $get->contact_company_id;

		if ($cost_code_type_id == -1) {
			// default cost_code_type_id to 5 for now
			$cost_code_type_id = 5;
		}

		$query =
			"
			SELECT
				ccd.*,
				ccda.*,
				ccd.`id` as 'cost_code_division_id',
				ccda.`id` as 'cost_code_division_alias_id'
			FROM `cost_code_divisions` ccd INNER JOIN `cost_code_division_aliases` ccda ON
				(ccd.`user_company_id` = ccda.`user_company_id` AND ccda.`project_id` = ? AND ccda.contact_company_id = ? AND ccd.`id` = ccda.`cost_code_division_id`)
			WHERE ccd.`user_company_id` = ?
			AND ccd.`cost_code_type_id` = ?
			ORDER BY ccd.`division_number` ASC, ccda.division_number_alias ASC
			";

		$arrValues = array($project_id, $contact_company_id, $user_company_id, $cost_code_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrCostCodeDivisionAliases = array();
		while ($row = $db->fetch()) {
			$arrCostCodeDivisionAliases[] = $row;
		}
		$db->free_result();

		echo '
			<div id="costCodeDivisionAliasesContainer">
			<table id="tblCostCodeDivisionAliases" border="1" cellpadding="5" cellspacing="0" style="margin-bottom:10px;" width="100%">
				<tr>
					<th colspan="5" style="text-align: left;">
						Cost Code Division Aliases:
						<select id="ddlCostCodeDivisionAliasId" onchange="updateAliasesCostCodeDivisionAliasId;">
							<option value="">Please select a Division Alias below</option>
		';

		foreach ($arrCostCodeDivisionAliases AS $row) {
			$cost_code_division_alias_id = $row['cost_code_division_alias_id'];
			$division_number_alias = $row['division_number_alias'];
			$division_code_heading_alias = $row['division_code_heading_alias'];
			$division_alias = $row['division_alias'];
			$division_abbreviation_alias = $row['division_abbreviation_alias'];

			$division_number = $row['division_number'];
			$division_code_heading = $row['division_code_heading'];
			$division = $row['division'];
			$division_abbreviation = $row['division_abbreviation'];

			$option = "<option value=\"$cost_code_division_alias_id\">$division_number_alias-$division_code_heading_alias $division_alias</option>";
		}

		echo '
						</select>
					</th>
				</tr>
		';
		echo '
			</table>
			</div>
		';

	break;

	case 'updateCostCodeAliasData':
		$attributeName = $get->attributeName;
		$attributeId = $get->attributeId;
		$newValue = $get->newValue;
		$user_company_id = $get->user_company_id;
		$project_id = $get->project_id;
		$contact_company_id = $get->contact_company_id;

		$save = true;

		

		$arrAllowableAttributes = array(
			'division_number_alias' => 'division number alias',
			'division_code_heading_alias' => 'division code heading alias',
			'division_alias' => 'division alias',
			'division_abbreviation_alias' => 'division abbreviation alias',
			'cost_code_alias' => 'cost code alias',
			'cost_code_description_alias' => 'cost code description alias',
			'cost_code_description_abbreviation_alias' => 'cost code description abbreviation alias',
		);

		if (isset($arrAllowableAttributes[$attributeName])) {
			$formattedAttributeName = ucfirst($arrAllowableAttributes[$attributeName]);
		} else {
			$errorMessage = "Invalid attribute.";
			$message->enqueueError($errorMessage, $currentPhpScript);
			$error->outputErrorMessages();
			exit;
		}

		switch ($attributeName) {

			case 'division_number_alias':
			case 'division_code_heading_alias':
			case 'division_alias':
			case 'division_abbreviation_alias':

				$costCodeDivisionAlias =
					CostCodeDivisionAlias::findByUserCompanyIdAndProjectIdAndCostCodeDivisionId($database, $user_company_id, $project_id, $attributeId);
				if ($costCodeDivisionAlias) {
					$data = array($attributeName => $newValue);
					$costCodeDivisionAlias->setData($data);
				} else {
					$costCodeDivisionAlias = new CostCodeDivisionAlias($database);
					$costCodeDivisionAlias->user_company_id = $user_company_id;
					$costCodeDivisionAlias->project_id = $project_id;
					$costCodeDivisionAlias->cost_code_division_id = $attributeId;
					$costCodeDivisionAlias->$attributeName = $newValue;
					$costCodeDivisionAlias->convertPropertiesToData();
				}
				$aliasedRecordId = $costCodeDivisionAlias->save();

				break;

			case 'cost_code_alias':
			case 'cost_code_description_alias':
			case 'cost_code_description_abbreviation_alias':

				$costCodeAlias =
					CostCodeAlias::findByUserCompanyIdAndProjectIdAndCostCodeId($database, $user_company_id, $project_id, $attributeId);
				if ($costCodeAlias) {
					$data = array($attributeName => $newValue);
					$costCodeAlias->setData($data);
				} else {
					$costCodeAlias = new CostCodeAlias($database);
					$costCodeAlias->user_company_id = $user_company_id;
					$costCodeAlias->project_id = $project_id;
					$costCodeAlias->cost_code_id = $attributeId;
					$costCodeAlias->$attributeName = $newValue;
					$costCodeAlias->convertPropertiesToData();
				}
				$aliasedRecordId = $costCodeAlias->save();

				break;

			default:
				break;
		}

		// Debug
		$errorMessage = '';
		$resetToPreviousValue = 0;

		echo "$attributeName|$attributeId|$aliasedRecordId|$formattedAttributeName|$errorMessage|$resetToPreviousValue";

	break;

	case 'deleteCostCodeAliasData':
		$attributeName = $get->attributeName;
		$attributeId = $get->attributeId;

		$arrAllowableAttributes = array(
			'cost_code_division_alias_id' => 'cost code division alias',
			'cost_code_alias_id' => 'cost code alias',
		);

		if (isset($arrAllowableAttributes[$attributeName])) {
			$formattedAttributeName = ucfirst($arrAllowableAttributes[$attributeName]);
		} else {
			$errorMessage = "Invalid attribute.";
			$message->enqueueError($errorMessage, $currentPhpScript);
			$error->outputErrorMessages();
			exit;
		}

		$successFlag = false;

		switch ($attributeName) {
			case 'cost_code_division_alias_id':
				$costCodeDivisionAlias = CostCodeDivisionAlias::findById($database, $attributeId);
				if ($costCodeDivisionAlias) {
					$costCodeDivisionAlias->delete();
					$successFlag = true;
				}

				break;

			case 'cost_code_alias_id':
				$costCodeAlias = CostCodeAlias::findById($database, $attributeId);
				if ($costCodeAlias) {
					$costCodeAlias->delete();
					$successFlag = true;
				}

				break;

			default:
				break;
		}

		// Debug
		$errorMessage = '';

		if ($successFlag) {
			echo "{$attributeName}|{$attributeId}|$formattedAttributeName|$errorMessage";
		} else {
			$message->enqueueError('Error occurred.', $currentPhpScript);
			$error->outputErrorMessages();
			exit;
		}

	break;

	case 'updateCostCodeAliasDatum':
		$attributeName = $get->attributeName;
		$attributeId = $get->attributeId;
		$newValue = $get->newValue;

		switch ($attributeName) {

			case 'division_number_alias':
			case 'division_code_heading_alias':
			case 'division_alias':
			case 'division_abbreviation_alias':

				$costCodeDivisionAlias =
					CostCodeDivisionAlias::findByUserCompanyIdAndProjectIdAndCostCodeDivisionId($database, $user_company_id, $project_id, $attributeId);
				if ($costCodeDivisionAlias) {
					$data = array($attributeName => $newValue);
					$costCodeDivisionAlias->setData($data);
				} else {
					$costCodeDivisionAlias = new CostCodeDivisionAlias($database);
					$costCodeDivisionAlias->user_company_id = $user_company_id;
					$costCodeDivisionAlias->project_id = $project_id;
					$costCodeDivisionAlias->cost_code_division_id = $attributeId;
					$costCodeDivisionAlias->$attributeName = $newValue;
					$costCodeDivisionAlias->convertPropertiesToData();
				}
				$costCodeDivisionAlias->save();

				break;

			case 'cost_code_alias':
			case 'cost_code_description_alias':
			case 'cost_code_description_abbreviation_alias':

				$costCodeAlias =
					CostCodeAlias::findByUserCompanyIdAndProjectIdAndCostCodeId($database, $user_company_id, $project_id, $attributeId);
				if ($costCodeAlias) {
					$data = array($attributeName => $newValue);
					$costCodeAlias->setData($data);
				} else {
					$costCodeAlias = new CostCodeAlias($database);
					$costCodeAlias->user_company_id = $user_company_id;
					$costCodeAlias->project_id = $project_id;
					$costCodeAlias->cost_code_id = $attributeId;
					$costCodeAlias->$attributeName = $newValue;
					$costCodeAlias->convertPropertiesToData();
				}
				$costCodeAlias->save();

				break;

			default:
				break;
		}

		$htmlContent = renderGcBudgetForm($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $project_name);
		echo $htmlContent;

	break;

	case 'deleteCostCodeAliasDatum':
		$attributeName = $get->attributeName;
		$attributeId = $get->attributeId;

		$successFlag = false;

		switch ($attributeName) {
			case 'cost_code_division_alias_id':
				$costCodeDivisionAlias = CostCodeDivisionAlias::findById($database, $attributeId);
				if ($costCodeDivisionAlias) {
					$costCodeDivisionAlias->delete();
					$successFlag = true;
				}

			break;

			case 'cost_code_alias_id':
				$costCodeAlias = CostCodeAlias::findById($database, $attributeId);
				if ($costCodeAlias) {
					$costCodeAlias->delete();
					$successFlag = true;
				}

			break;

			default:
			break;
		}

		if ($successFlag) {
			$htmlContent = renderGcBudgetForm($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $project_name);
			echo $htmlContent;
		} else {
			$message->enqueueError('Error occurred.', $currentPhpScript);
			$error->outputErrorMessages();
			exit;
		}

	break;

	case 'loadSubcontractDetails':

		$gc_budget_line_item_id = $get->gc_budget_line_item_id;
		$vendor_contact_company_id = $get->vendor_contact_company_id;
		$vendor_contact_id = $get->vendor_contact_id;
		$cost_code_division_id = $get->cost_code_division_id;
		$cost_code_id = $get->cost_code_id;
		$subcontractor_bid_id = $get->subcontractor_bid_id;
		if(isset($get->active_widget_number))
		{
			$active_widget_number = $get->active_widget_number;
		}else{
			$active_widget_number = 0;
		}

		if ($subcontractor_bid_id == 'undefined') {
			$subcontractor_bid_id = null;
		}

		

		$gcBudgetLineItem = GcBudgetLineItem::findGcBudgetLineItemByIdExtended($database, $gc_budget_line_item_id);

		$costCode = $gcBudgetLineItem->getCostCode();
		/* @var $costCode CostCode */
		$cost_code_id = $costCode->cost_code_id;
		$cost_code = $costCode->cost_code;
		$cost_code_description = $costCode->cost_code_description;
		$cost_code_description_abbreviation = $costCode->cost_code_description_abbreviation;

		$costCodeDivision = $gcBudgetLineItem->getCostCodeDivision();
		/* @var $costCodeDivision CostCodeDivision */
		$cost_code_division_id = $costCodeDivision->cost_code_division_id;
		$division_number = $costCodeDivision->division_number;
		$division_code_heading = $costCodeDivision->division_code_heading;
		$division = $costCodeDivision->division;
		$division_abbreviation = $costCodeDivision->division_abbreviation;

		$division_number = $costCodeDivision->division_number;
		$cost_code = $costCode->cost_code;
		$cost_code_description = $costCode->cost_code_description;
		$fileUploadDirectory = '/Subcontracts/' . $division_number . '-' . $cost_code . ' ' . $cost_code_description . '/';

		$arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id);


		if (!empty($arrSubcontracts)) {
			$subcontract_sequence_number = Subcontract::findNextSubcontractSequenceNumber($database, $gc_budget_line_item_id);

			$subcontract = new Subcontract($database);
			$subcontract->gc_budget_line_item_id = $gc_budget_line_item_id;
			$subcontract->subcontract_sequence_number = $subcontract_sequence_number;

			$createSubcontractForm = renderCreateSubcontractForm($database, $user_company_id, $subcontract, $cost_code_division_id, $cost_code_id, $subcontractor_bid_id);

			echo
'
			<input id="formattedAttributeGroupName--manage-subcontract-record" type="hidden" value="Subcontract">

			<div id="createAdditionalSubcontractForm" style="display: none;">
			'.$createSubcontractForm.'
			</div>
			<div id="messageDiv" class="userMessage"></div>
';
		}

		if (count($arrSubcontracts) > 1) {
			$listView = '<div style="font-weight:bold">Subcontracts List</div><div class="list-group subcontract-list-group " >';

			$first = true;
			$activeSubcontractId = '';
			$countWidget = 0;
			foreach ($arrSubcontracts as $subcontract) {
				$tmp_subcontract_id = $subcontract->subcontract_id;
				$tmp_subcontract_sequence_number = $subcontract->subcontract_sequence_number;
				$tmp_subcontract_actual_value = $subcontract->subcontract_actual_value;
				$vendor = $subcontract->getVendor();
				/* @var $vendor Vendor */
				$vendor_company_name = '';

				if ($vendor) {
					$vendorContactCompany = $vendor->getVendorContactCompany();
					/* @var $vendorContactCompany ContactCompany */
					if ($vendorContactCompany) {
					$vendor_company_name = " | ".$vendorContactCompany->company;
					}
				}
				if($active_widget_number == $countWidget){
					$activeClass = 'active';
					$activeSubcontractId = $tmp_subcontract_id;
				}else{
					$activeClass = '';
				}
				$subheader = "Sub #".$tmp_subcontract_sequence_number." (".$tmp_subcontract_actual_value.") ".$vendor_company_name;

				if ($first) {
					$first = false;
					$listView .= '<a onclick="showSubcontractDetails(this, \''.$tmp_subcontract_id.'\','.$countWidget.');" class="fakeHref list-group-item '.$activeClass.'">'.$subheader.'</a>';
				} else {
					$listView .= '<a onclick="showSubcontractDetails(this, \''.$tmp_subcontract_id.'\','.$countWidget.');" class="fakeHref list-group-item '.$activeClass.'">'.$subheader.'</a>';
				}
				$countWidget++;
			}

			$listView .= '</div>';
			echo $listView;
			echo '
			<input type="hidden" id="activeGcBudgetLineSubcontractor" value="'.$activeSubcontractId.'">
			<input type="hidden" id="activeGcBudgetLineWidget" value="'.$active_widget_number.'">';
		}

		$first = true;
		$countWidget = 0;
		$gc_signatory =$vendor_signatory="";

		foreach ($arrSubcontracts as $subcontract) {

			$subcontract_id = $subcontract->subcontract_id;
			$gc_signatory = $subcontract->gc_signatory;
			$vendor_signatory  = $subcontract->vendor_signatory;

			$subcontractDetailsWidget = buildSubcontractDetailsWidget($database, $user_company_id, $subcontract_id);
			if($active_widget_number != $countWidget){
				$hiddenClass = 'class="hidden"';
			} else {
				$hiddenClass = '';
			}

			if ($first) {
				$first = false;
				if (count($arrSubcontracts) == 1) {
					echo '<input type="hidden" id="activeGcBudgetLineSubcontractor" value="'.$subcontract_id.'">';
				}
				echo '<div id="container--subcontracts--main--'.$subcontract_id.'" '.$hiddenClass.'><div style="width:47%;float:left;padding-right: 35px;margin-top:10px;" id="container--subcontracts--'.$subcontract_id.'">'.$subcontractDetailsWidget;
			} else {
				echo '<div id="container--subcontracts--main--'.$subcontract_id.'" '.$hiddenClass.'><div style="width:47%;float:left;padding-right: 35px;margin-top:10px;" id="container--subcontracts--'.$subcontract_id.'">'.$subcontractDetailsWidget;
			}


			$vendor = $subcontract->getVendor();
			/* @var $vendor Vendor */
			$vendor_company_name = '';
			if ($vendor) {
				$vendorContactCompany = $vendor->getVendorContactCompany();
				/* @var $vendorContactCompany ContactCompany */
				if ($vendorContactCompany) {
					$vendor_company_name = $vendorContactCompany->company;
				}
			}

			// Unsigned Subcontract Uploader
			$virtual_file_name =
				$vendor_company_name . ' : ' .
				'Unsigned Subcontract #'.
				$subcontract->subcontract_sequence_number . '.pdf';
			$encoded_virtual_file_name = urlencode($virtual_file_name);

			$finalUnsignedSubcontractFileUploader =
				'
				<div
					id="unsigned_subcontract_upload_'.$subcontract_id.'"
					class="boxViewUploader"
					folder_id=""
					project_id="'.$project_id.'"
					virtual_file_path="'.$fileUploadDirectory.'Unsigned/"
					virtual_file_name="'.$encoded_virtual_file_name.'"
					action="/modules-gc-budget-file-uploader-ajax.php"
					method="unsignedFinalSubcontract"
					allowed_extensions="pdf"
					drop_text_prefix=""
					multiple="false"
					post_upload_js_callback="subcontractDocumentUploaded(arrFileManagerFiles, \'manage-subcontract-record--subcontracts--unsigned_subcontract_file_manager_file--'.$subcontract_id.'\',\'unsign\')"
					style=""></div>
				';

			// Signed Subcontract Uploader
			$virtual_file_name =
				$vendor_company_name . ' : ' .
				'Signed Subcontract #'.
				$subcontract->subcontract_sequence_number . '.pdf';
			$encoded_virtual_file_name = urlencode($virtual_file_name);
			$finalSignedSubcontractFileUploader =
				'
				<div
					id="signed_subcontract_upload_'.$subcontract_id.'"
					class="boxViewUploader"
					folder_id=""
					project_id="'.$project_id.'"
					virtual_file_path="'.$fileUploadDirectory.'Executed/"
					virtual_file_name="'.$encoded_virtual_file_name.'"
					action="/modules-gc-budget-file-uploader-ajax.php"
					method="signedFinalSubcontract"
					allowed_extensions="pdf"
					drop_text_prefix=""
					multiple="false"
					post_upload_js_callback="subcontractDocumentUploaded(arrFileManagerFiles, \'manage-subcontract-record--subcontracts--signed_subcontract_file_manager_file--'.$subcontract_id.'\',\'sign\')"
					style=""></div>
				';

			$unsignedSubcontractFileManagerFile = $subcontract->getUnsignedSubcontractFileManagerFile();
			$signedSubcontractFileManagerFile = $subcontract->getSignedSubcontractFileManagerFile();
			/* @var $unsignedSubcontractFileManagerFile FileManagerFile */
			/* @var $signedSubcontractFileManagerFile FileManagerFile */

			if ($unsignedSubcontractFileManagerFile) {
				$unsigned_version_number = $unsignedSubcontractFileManagerFile->version_number;
				$file_location_id = $unsignedSubcontractFileManagerFile->file_location_id;
				if (!isset($unsigned_version_number) || ($unsigned_version_number == 1)) {
					$unsignedSubcontractUrl = $uri->cdn . '_' . $unsignedSubcontractFileManagerFile->file_manager_file_id;
				} else {
					$unsignedSubcontractUrl = $uri->cdn . '_' . $unsignedSubcontractFileManagerFile->file_manager_file_id . '?v=' . $unsigned_version_number;
				}

				$unsignedSubcontractFilename = $unsignedSubcontractFileManagerFile->virtual_file_name;
				$unsignedSubcontractFileManagerFileLink =
					'<a class="underline" target="_blank" href="'.$unsignedSubcontractUrl.'">'.$unsignedSubcontractFilename.'</a>';
				if($file_location_id=="")
				{
					$unsignedSubcontractUrl = '';
				}
			} else {
				$unsignedSubcontractFileManagerFileLink = '';
				$unsignedSubcontractUrl ='';
			}

			if ($signedSubcontractFileManagerFile) {
				$signed_version_number = $signedSubcontractFileManagerFile->version_number;
				if (!isset($signed_version_number) || ($signed_version_number == 1)) {
					$signedSubcontractUrl = $uri->cdn . '_' . $signedSubcontractFileManagerFile->file_manager_file_id;
				} else {
					$signedSubcontractUrl = $uri->cdn . '_' . $signedSubcontractFileManagerFile->file_manager_file_id . '?v=' . $signed_version_number;
				}

				$signedSubcontractFilename = $signedSubcontractFileManagerFile->virtual_file_name;
				$signedSubcontractFileManagerFileLink =
					'<a class="underline" target="_blank" href="'.$signedSubcontractUrl.'">'.$signedSubcontractFilename.'</a>';
			} else {
				$signedSubcontractFileManagerFileLink = '';
			}
			if($unsignedSubcontractFileManagerFileLink!=''){
			 $email_notice_unsign='display:block;';

			}else
			{
				$email_notice_unsign='display:none;';
			}
			if($signedSubcontractFileManagerFileLink!='')
			{
				$email_notice_sign='display:block;';
			}else
			{
				$email_notice_sign='display:none;';
			}

			$config = Zend_Registry::get('config');	
		$file_manager_base_path = $config->system->file_manager_base_path;
		$save = $file_manager_base_path.'backend/procedure/';

		//GC signatory
		$gc_filename = md5($gc_signatory);
		$signfile_name = $save.$gc_filename.'.png';
		$gcexist  = $vendorexist ='N';
		
		if(file_exists($signfile_name))
		{
			$gcexist  = 'Y';
		}

		$vendor_filename = md5($vendor_signatory);
		$vendorsignfile_name = $save.$vendor_filename.'.png';
		if(file_exists($vendorsignfile_name))
		{
			$vendorexist  = 'Y';
		}
		

		if(($currentlyActiveContactId == $gc_signatory) || ($currentlyActiveContactId == $vendor_signatory ))
		{
			
			$canComplie= "Y";
			$signatory_text='<a href="#" id="use_sign" class="use_sign underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="GC Signed" value ="Apply e-signature" onclick="showsetSignaturewithdialog('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;&apos;,&apos;&apos;,&apos;'.$canComplie.'&apos;)">Apply/Modify E-sign</a>';
		}else
		{
			
			$canComplie= "N";
			$signatory_text="";
		}


			echo
'

<div id="Viewsubcontractor-'.$subcontract_id.'" class="modal" style="display: none;"></div>
<div class="widgetContainer" style="margin:20px 0;">
	<h3 class="title">Final Subcontract</h3>
	<table class="content" width:"100%" cellpadding="5">
	<tr>
		<th class="textAlignLeft" width="30%">Compile Final Subcontract:</th>
		<td width="70%" colspan="2"><input type="button" onclick="verifyFinalSubcontract('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;'.$gcexist.'&apos;,&apos;'.$vendorexist.'&apos;,&apos;'.$canComplie.'&apos;);" value="Compile Final Subcontract">
		<input type="button" class="Compile_'.$subcontract_id.'" onclick="generateFinalSubcontract('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;'.$gcexist.'&apos;,&apos;'.$vendorexist.'&apos;,&apos;'.$canComplie.'&apos;);" value="Compile Final Subcontract" style="display:none;">

		
		<input type="checkbox" id="signatory_'.$subcontract_id.'" name="signatory_'.$subcontract_id.'" style="display:none;" >

	</td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="30%">Upload Unsigned Subcontract:</th>
		<td nowrap width="70%" colspan="2">'.$finalUnsignedSubcontractFileUploader.'</td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="33%">View Unsigned Subcontract:</th>
		<td id="manage-subcontract-record--subcontracts--unsigned_subcontract_file_manager_file--'.$subcontract_id.'"  class="tooltip-user" nowrap width="33%">'.$unsignedSubcontractFileManagerFileLink.'</td>
		<td id="unsign" style="'.$email_notice_unsign.'" width="33%"><input type="button" id="save" onclick="TransmittalNotice(\'unsigned\','.$gc_budget_line_item_id.','.$subcontract_id.','.$primary_contact_id.',\''.$primary_contact_name.'\');" style="font-size: 10pt;"  value="Email Subcontract Notice"></td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="30%">Upload Final Signed Subcontract:</th>
		<td nowrap width="70%" colspan="2">'.$finalSignedSubcontractFileUploader.'</td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="30%">Subcontract Execution Date:</th>

		<td nowrap width="70%" colspan="2"><input id="manage-subcontract-record--subcontracts--subcontract_execution_date--'.$subcontract_id.'" type="text"  class="datepicker" value="'.Date::convertDateTimeFormat($subcontract->subcontract_execution_date, 'html_form').'"  onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, \'\', \'\', \'\', false);"></td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="30%">Subcontract Mailed Date:</th>

		<td nowrap width="70%" colspan="2"><input id="manage-subcontract-record--subcontracts--subcontract_mailed_date--'.$subcontract_id.'" type="text" class="datepicker" value="'.Date::convertDateTimeFormat($subcontract->subcontract_mailed_date, 'html_form').'" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, \'\', \'\', \'\', false);"></td>
	</tr>
	<tr>
		<th class="textAlignLeft" width="33%">View Final Signed Subcontract:</th>
		<td id="manage-subcontract-record--subcontracts--signed_subcontract_file_manager_file--'.$subcontract_id.'" class="tooltip-user" nowrap width="33%">'.$signedSubcontractFileManagerFileLink.'</td>
		<td id="sign" style="'.$email_notice_sign.'" width="33%"><input type="button" id="save" onclick="TransmittalNotice(\'signed\','.$gc_budget_line_item_id.','.$subcontract_id.','.$primary_contact_id.',\''.$primary_contact_name.'\');" style="font-size: 10pt;"  value="Email Subcontract Notice" ></td>
	</tr>
	</table>
</div>
</div>';

		if($unsignedSubcontractUrl =="")
		{
			echo '<div id="pdfcontainer" class="pdfcontainer preview-subcontract">
			<div style="margin-top:10px;margin-bottom:10px;text-align: right;">'.$signatory_text.'</div>
			No Preview Available
			</div>
		';
		}else{
			echo'
				<div id="pdfcontainer" class="pdfcontainer preview-subcontract">
					<div style="margin-top:10px;margin-bottom:10px;text-align: right;">'.$signatory_text.'</div>
						<iframe id="iframeFilePreview" src="'.$unsignedSubcontractUrl.'" style="border:0;" width="100%" height="1050px;"></iframe>
					</div>';
		}


		echo'
		<div class="widgetContainer subdoclist" style="margin:0;clear: both;">
			
			<table class="content subcontract-document" cellpadding="5" width="100%" style="margin:0;">
			<thead class="borderBottom">
			<tr><h3 class="title">Subcontract Documents</h3></tr>
			<tr>
			<th nowrap style="width: 4%;" class="textAlignCenter">Order</th>
			<th nowrap  style="width: 15%;"class="textAlignLeft">Subcontract Document</th>
			<th nowrap class="textAlignCenter">
				Auto Gen.
				<div class="dropdown" style="display:inline">
				  <button class="btn btn-default dropdown-toggle bs-dropdown-notitle" type="button" id="dropdownMenu1" data-toggle="dropdown">
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
				    <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="renderAllDocumentsForSelectedSubcontract(\''.$subcontract_id.'\'); return false;">Render all</a></li>
				  </ul>
				</div>
			</th>
			<th class="textAlignCenter"  style="width: 10%;">Upload Unsigned Doc.</th>
			<th  style="width: 10%;" nowrap class="textAlignCenter">View<br> Unsigned Doc.</th>

			<th class="textAlignCenter">GC <br> E-sign</th>
			<th class="textAlignCenter">Vendor <br>E-sign</th>

			<th class="textAlignCenter"  style="width: 10%;">Upload Signed Doc.</th>
			<th nowrap class="textAlignCenter"  style="width: 10%;">View <br>Signed Doc.</th>
			</tr>
			</thead>
			<tbody class="tbodySortable altColors">
		';

		$loadSubcontractDocumentsBySubcontractIdOptions = new Input();
		$loadSubcontractDocumentsBySubcontractIdOptions->forceLoadFlag = true;
		$arrSubcontractDocuments = SubcontractDocument::loadSubcontractDocumentsBySubcontractId($database, $subcontract_id, $loadSubcontractDocumentsBySubcontractIdOptions);

			
		//Get Subcontract cover template id
		$coverId = SubcontractDocument::SubcontractDocumentcoverId($database,$subcontract_id,'2');

		$counter = 0;
		foreach ($arrSubcontractDocuments as $subcontract_document_id => $subcontractDocument) {
			/* @var $subcontractDocument SubcontractDocument */
			$subcontractItemTemplate = $subcontractDocument->getSubcontractItemTemplate();

			/* @var $subcontractItemTemplate SubcontractItemTemplate */
			$subcontract_item_template_id = $subcontractDocument->subcontract_item_template_id;
			$unsigned_subcontract_document_file_manager_file_id = $subcontractDocument->unsigned_subcontract_document_file_manager_file_id;
			$signed_subcontract_document_file_manager_file_id = $subcontractDocument->signed_subcontract_document_file_manager_file_id;
			$auto_generated_flag = $subcontractDocument->auto_generated_flag;
			$disabled_flag = $subcontractDocument->disabled_flag;
			$sort_order = $subcontractDocument->sort_order;

			$tempgc_signatory = $subcontractDocument->gc_signatory;
			$tempvendor_signatory = $subcontractDocument->vendor_signatory;
			$gc_signatory_check="";
			$vendor_signatory_check="";
			$gc_signatory_text= $vendor_signatory_text = "-";
			if($coverId == $subcontract_document_id){
				if($tempgc_signatory=='Y' )
				{
					
					if($currentlyActiveContactId == $gc_signatory)
					{					
						$gc_signatory_check="checked='true'";
						$gc_signatory_text='<a href="#" id="use_sign" class="use_sign underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="GC Signed" value ="Apply e-signature" onclick="showsetSignaturewithdialog('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;'.$gcexist.'&apos;,&apos;'.$vendorexist.'&apos;,&apos;'.$canComplie.'&apos;)">Signed</a>';
					}else
					{
						$gc_signatory_text= "Signed";
					}
				}else if($currentlyActiveContactId == $gc_signatory)
				{

					$gc_signatory_text='<a href="#" id="use_sign" class="use_sign underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="GC yet to sign" value ="Apply e-signature" onclick="showsetSignature('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;'.$gcexist.'&apos;,&apos;'.$vendorexist.'&apos;,&apos;'.$canComplie.'&apos;)">Apply E-sign</a>';
				}else
				{
					$gc_signatory_text='Awaiting';
				}
				if($tempvendor_signatory=='Y')
				{
					$vendor_signatory_check="checked='true'";

					if($currentlyActiveContactId == $vendor_signatory)
					{
					$vendor_signatory_text='<a href="#" id="use_sign" class="use_sign underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="vendor Signed" value ="Apply e-signature" onclick="showsetSignaturewithdialog('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;'.$gcexist.'&apos;,&apos;'.$vendorexist.'&apos;,&apos;'.$canComplie.'&apos;)">Signed</a>';
					}else
					{
						$vendor_signatory_text='Signed';
					}
				}else if($currentlyActiveContactId == $vendor_signatory)
				{
					$vendor_signatory_text='<a href="#" id="use_sign" class="use_sign underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="vendor yet to sign" value ="Apply e-signature" onclick="showsetSignature('.$gc_budget_line_item_id.', '.$cost_code_division_id.', '.$cost_code_id.', '.$subcontract_id.', '.$subcontract->subcontract_execution_date.', '.$subcontract->subcontract_mailed_date.',&apos;'.$gcexist.'&apos;,&apos;'.$vendorexist.'&apos;,&apos;'.$canComplie.'&apos;)">Apply E-sign</a>';
				}else
				{
					$vendor_signatory_text = "Awaiting";
				}
			}
		
			

			$unsignedSubcontractDocumentFileManagerFile = $subcontractDocument->getUnsignedSubcontractDocumentFileManagerFile();
				/* @var $unsignedSubcontractDocumentFileManagerFile FileManagerFile */

			if ($unsignedSubcontractDocumentFileManagerFile) {
				$unsigned_version_number = $unsignedSubcontractDocumentFileManagerFile->version_number;
				if (!isset($unsigned_version_number) || ($unsigned_version_number == 1)) {
					$unsignedSubcontractDocumentUrl = $uri->cdn . '_' . $unsignedSubcontractDocumentFileManagerFile->file_manager_file_id;
				} else {
					$unsignedSubcontractDocumentUrl = $uri->cdn . '_' . $unsignedSubcontractDocumentFileManagerFile->file_manager_file_id . '?v=' . $unsigned_version_number;
				}
				$unsignedSubcontractDocumentFilename = $unsignedSubcontractDocumentFileManagerFile->virtual_file_name;
				$unsignedSubcontractDocumentFileManagerFileLink =
					'<a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="'.$unsignedSubcontractDocumentUrl.'" title="'.$unsignedSubcontractDocumentFilename.'"> Document</a>';
			} else {
				$unsignedSubcontractDocumentFileManagerFileLink = '';
			}

			$signedSubcontractDocumentFileManagerFile = $subcontractDocument->getSignedSubcontractDocumentFileManagerFile();
				/* @var $signedSubcontractDocumentFileManagerFile FileManagerFile */

			if ($signedSubcontractDocumentFileManagerFile) {
				$signed_version_number = $signedSubcontractDocumentFileManagerFile->version_number;
				if (!isset($signed_version_number) || ($signed_version_number == 1)) {
					$signedSubcontractDocumentUrl = $uri->cdn . '_' . $signedSubcontractDocumentFileManagerFile->file_manager_file_id;
				} else {
					$signedSubcontractDocumentUrl = $uri->cdn . '_' . $signedSubcontractDocumentFileManagerFile->file_manager_file_id . '?v=' . $signed_version_number;
				}
				$signedSubcontractDocumentFilename = $signedSubcontractDocumentFileManagerFile->virtual_file_name;
				$signedSubcontractDocumentFileManagerFileLink =
					'<a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="'.$signedSubcontractDocumentUrl.'" title="'.$signedSubcontractDocumentFilename.'">Document</a>';
					if($coverId != $subcontract_document_id){
					$gc_signatory_text= $vendor_signatory_text = "NA";
					}
			} else {
				$signedSubcontractDocumentFileManagerFileLink = '';
			}


			$subcontract_item_template_id = (int) $subcontractItemTemplate->subcontract_item_template_id;
			$user_company_id_template = (int) $subcontractItemTemplate->user_company_id;
			$file_manager_file_id = (int) $subcontractItemTemplate->file_manager_file_id;
			$user_company_file_template_id = (int) $subcontractItemTemplate->user_company_file_template_id;
			$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
			$subcontract_item_abbreviation = (string) $subcontractItemTemplate->subcontract_item_abbreviation;
			$subcontract_item_template_type = (string) $subcontractItemTemplate->subcontract_item_template_type;
			$disabled_flag = (string) $subcontractItemTemplate->disabled_flag;

			$fileManagerFile = $subcontractItemTemplate->getFileManagerFile();
			/* @var $fileManagerFile FileManagerFile */
			$userCompanyFileTemplate = $subcontractItemTemplate->getUserCompanyFileTemplate();
			/* @var $userCompanyFileTemplate UserCompanyFileTemplate */

			echo
				'
				<tr id="manage-subcontract-document-record--subcontract_documents--sort_order--'.$subcontract_document_id.'--'.$counter.'" class="trSortable">
				<td class="tdSortBars textAlignCenter verticalAlignMiddle" nowrap><img src="/images/sortbars.png"></td>
				<td nowrap class="textAlignLeft verticalAlignMiddle">'.$subcontract_item.'</td>
				<td nowrap class="textAlignCenter verticalAlignMiddle">
				';
			$counter++;

			if (($subcontract_item_template_type == 'Dynamic Template File') && (!is_int(strpos($subcontract_item, 'Cover Letter')))) {
				echo
					'<input id="buttonGenerateDynamicSubcontractDocument--'.$subcontract_document_id.'" onclick="generateDynamicSubcontractDocument(\''.$gc_budget_line_item_id.'\', \''.$cost_code_division_id.'\', \''.$cost_code_id.'\', \''.$subcontract_id.'\', \''.$subcontract_item_template_id.'\');" type="button" class="buttonRenderDocument" value="Render Document">
					';
				}

				echo
					'
						</td>
						<td class="textAlignLeft verticalAlignMiddle" width="200px">
					';

				if (($subcontract_item_template_type == 'File Uploaded During Subcontract Creation')||($subcontract_item_template_type == 'By Project Static Subcontract Document')) {
					// Pass in id values for the ajax file uploader to easily find data
					//File name shorter to be subcontractor and doc name
					$virtual_file_name =
						$vendor_company_name . ' : ' .
						$subcontractItemTemplate->subcontract_item . '.pdf';
					$encoded_virtual_file_name = urlencode($virtual_file_name);

					$byPrjSt ="0";
					if ($subcontract_item_template_type == 'By Project Static Subcontract Document') {
						$byPrjSt ="1";

					}
					echo
						'
						<div
							id="unsigned_subcontract_document_upload_'.$subcontract_id.'_'.$subcontract_item_template_id.'"
							class="boxViewUploader"
							folder_id=""
							project_id="'.$project_id.'"
							virtual_file_path="'.$fileUploadDirectory.'Unsigned/"
							virtual_file_name="'.$encoded_virtual_file_name.'"
							action="/modules-gc-budget-file-uploader-ajax.php"
							method="unsignedSubcontractDocument"
							allowed_extensions="pdf"
							drop_text_prefix=""
							multiple="false"
							post_upload_js_callback="unsignedSubcontractDocumentUploaded(arrFileManagerFiles, \'tdLinkToUnsignedDocument--'.$subcontract_id.'-'.$subcontract_item_template_id.'\','.$byPrjSt.','.$subcontract_item_template_id.')"
							style=""></div>
						';
				}

				echo '
					</td>
					<td nowrap class="textAlignCenter verticalAlignMiddle tdLinkToUnsignedDocument" id="tdLinkToUnsignedDocument--'.$subcontract_id.'-'.$subcontract_item_template_id.'">
				';


				echo $unsignedSubcontractDocumentFileManagerFileLink;

				echo '
					</td>
					<td nowrap class="textAlignCenter verticalAlignMiddle"> ' .
					$gc_signatory_text.'

					</td>
					<td nowrap class="textAlignCenter verticalAlignMiddle"> '.
					$vendor_signatory_text
					.'</td>
					<td nowrap class="textAlignLeft verticalAlignMiddle" width="200px">
				';


				$virtual_file_name =
				$vendor_company_name . ' : ' .
				$subcontractItemTemplate->subcontract_item . '.pdf';
				$encoded_virtual_file_name = urlencode($virtual_file_name);
				echo
					'
					<div
						id="signed_subcontract_document_upload_'.$subcontract_id.'_'.$subcontract_item_template_id.'"
						class="boxViewUploader"
						folder_id=""
						project_id="'.$project_id.'"
						virtual_file_path="'.$fileUploadDirectory.'Executed/"
						virtual_file_name="'.$encoded_virtual_file_name.'"
						action="/modules-gc-budget-file-uploader-ajax.php"
						method="signedSubcontractDocument"
						allowed_extensions="pdf"
						drop_text_prefix=""
						multiple="false"
						post_upload_js_callback="signedSubcontractDocumentUploaded(arrFileManagerFiles, \'tdLinkToSignedDocument--'.$subcontract_id.'-'.$subcontract_item_template_id.'\')"
						style=""></div>
					';

					echo '
						</td>
						<td nowrap class="textAlignCenter verticalAlignMiddle tdLinkToSignedDocument" id="tdLinkToSignedDocument--'.$subcontract_id.'-'.$subcontract_item_template_id.'">
					';


					echo $signedSubcontractDocumentFileManagerFileLink;

					echo '
						</td>
					</tr>
					';
			}

			echo
				'
				</tbody>
			</table>
		</div>
		<br>
		<input type="hidden" id="active_gc_budget_line_item_id" value="'.$gc_budget_line_item_id.'">
	</div>
</div>
				';
			$countWidget++;
		}

		if (empty($arrSubcontracts)) {

			// Create Subcontract / Form

			$subcontract_sequence_number = 1;
			$subcontractorBid = false;
			$vendor = false;

			// Vendor
			if (isset($vendor_id) && !empty($vendor_id)) {
				$vendor = Vendor::findById($database, $vendor_id);
			} elseif (isset($vendor_contact_company_id) || isset($vendor_contact_id)) {
				$vendor = Vendor::findByVendorContactCompanyIdAndVendorContactId($database, $vendor_contact_company_id, $vendor_contact_id);

				if ($vendor) {

					$vendor_id = $vendor->vendor_id;

				} else {

					$vendor = new Vendor($database);

					if (isset($vendor_contact_company_id) || isset($vendor_contact_id)) {
						$vendor->vendor_contact_company_id = $vendor_contact_company_id;
					}
					if (isset($vendor_contact_id)) {
						$vendor->vendor_contact_id = $vendor_contact_id;
					}

					$vendor->convertPropertiesToData();

					$vendor_id = $vendor->save();

				}
			} elseif (isset($subcontractor_bid_id)) {
				$subcontractorBid = SubcontractorBid::findSubcontractorBidByIdExtended($database, $subcontractor_bid_id);
				if ($subcontractorBid) {
					$subcontractorContact = $subcontractorBid->getSubcontractorContact();
					/* @var $subcontractorContact Contact */

					$subcontractorContactCompany = $subcontractorBid->getSubcontractorContactCompany();
					/* @var $subcontractorContactCompany ContactCompany */

					if ($subcontractorContact) {
						$vendor_contact_id = $subcontractorContact->contact_id;
					}

					if ($subcontractorContactCompany) {
						$vendor_contact_company_id = $subcontractorContactCompany->contact_company_id;
					}

					$vendor = Vendor::findByVendorContactCompanyIdAndVendorContactId($database, $vendor_contact_company_id, $vendor_contact_id);

					if ($vendor) {

						$vendor_id = $vendor->vendor_id;

					} else {

						$vendor = new Vendor($database);

						if (isset($vendor_contact_company_id) || isset($vendor_contact_id)) {
							$vendor->vendor_contact_company_id = $vendor_contact_company_id;
						}
						if (isset($vendor_contact_id)) {
							$vendor->vendor_contact_id = $vendor_contact_id;
						}

						$vendor->convertPropertiesToData();

						$vendor_id = $vendor->save();

					}
				}
			} else {
				$vendor = false;
			}

			$subcontract = new Subcontract($database);
			$subcontract->gc_budget_line_item_id = $gc_budget_line_item_id;
			$subcontract->subcontract_sequence_number = $subcontract_sequence_number;
			$subcontract->setVendor($vendor);
			if ($subcontractorBid) {
				$subcontract->setSubcontractorBid($subcontractorBid);
			}
			if($user_company_id_template == null || $user_company_id_template == ''){
				$user_company_id_template = $user_company_id;
			}
			$createSubcontractForm = renderCreateSubcontractForm($database, $user_company_id_template, $subcontract, $cost_code_division_id, $cost_code_id, $subcontractor_bid_id);
			echo $createSubcontractForm;

		}

	break;

	case 'loadCreateSubcontractForm':

		$gc_budget_line_item_id = $get->gc_budget_line_item_id;
		$vendor_contact_company_id = $get->vendor_contact_company_id;
		$vendor_contact_id = $get->vendor_contact_id;
		$cost_code_division_id = $get->cost_code_division_id;
		$cost_code_id = $get->cost_code_id;
		$subcontractor_bid_id = $get->subcontractor_bid_id;

		$subcontract_sequence_number = Subcontract::findNextSubcontractSequenceNumber($database, $gc_budget_line_item_id);

		$subcontract = new Subcontract($database);
		$subcontract->gc_budget_line_item_id = $gc_budget_line_item_id;
		$subcontract->subcontract_sequence_number = $subcontract_sequence_number;
		$subcontract->setVendor($vendor);

		$htmlContent = renderCreateSubcontractForm($database, $user_company_id, $subcontract, $cost_code_division_id, $cost_code_id, $subcontractor_bid_id);
		echo $htmlContent;

		break;

	case 'createSubcontractAndVendorAndSubcontractDocuments':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';
		$htmlRecordTr = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');


			// Get primary key / unique key via get input
			$attributeGroupName = (string) $get->attributeGroupName;
			$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
			$attributeSubgroupName = (string) $get->attributeSubgroupName;
			$uniqueId = (string) $get->uniqueId;
			$cost_code_division_id = $get->cost_code_division_id;
			$cost_code_id = $get->cost_code_id;
			$gc_budget_line_item_id = $get->gc_budget_line_item_id;
			$vendor_contact_company_id = $get->vendor_contact_company_id;
			$subcontract_mailed_date = $get->subcontract_mailed_date;
			$subcontract_execution_date = $get->subcontract_execution_date;

			$subcontractor_bid_id = $get->subcontractor_bid_id;
			
			$fileId = $get->fileId;
			$fileType = $get->fileType;
			$fileReason = $get->fileReason;

			// subcontract_actual_value
			$subcontract_actual_value = Data::parseFloat($get->subcontract_actual_value);
			$get->subcontract_actual_value = $subcontract_actual_value;


			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Vendor
			if (isset($vendor_contact_company_id) && !empty($vendor_contact_company_id)) {

				if ($vendor) {
					$vendor_id = $vendor->vendor_id;
				} else {
					$vendor = new Vendor($database);

					if (isset($vendor_contact_company_id)) {
						$vendor->vendor_contact_company_id = $vendor_contact_company_id;
					} else {
						$vendor->vendor_contact_company_id = null;
					}
					if (isset($vendor_contact_id)) {
						$vendor->vendor_contact_id = $vendor_contact_id;
					} else {
						$vendor->vendor_contact_id = null;
					}
					if(isset($mailedDate)) {
						$vendor->subcontract_mailed_date = $subcontract_mailed_date;
					} else {
						$vendor->subcontract_mailed_date = '';
					}
					if(isset($executionDate)) {
						$vendor->subcontract_execution_date = $subcontract_execution_date;
					} else {
						$vendor->subcontract_execution_date = '';
					}

					$vendor->convertPropertiesToData();

					$vendor_id = $vendor->save();
				}

				if (isset($vendor_id) && !empty($vendor_id)) {
					$get->vendor_id = $vendor_id;
				}
			}

			$subcontract = new Subcontract($database);

			// Retrieve all of the $_GET inputs automatically for the Subcontract record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			// Assign $_GET inputs to $subcontracts record
			$subcontract->setData($httpGetInputData);
			$subcontract->convertDataToProperties();

			// Check for required attributes

			// Verify gc_budget_line_item_id
			if (!isset($subcontract->gc_budget_line_item_id)) {
				$errorMessage = 'Missing gc_budget_line_item_id.';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}

			// Verify subcontract_sequence_number
			if (!isset($subcontract->subcontract_sequence_number)) {
				$subcontract_sequence_number = Subcontract::findNextSubcontractSequenceNumber($database, $gc_budget_line_item_id);
				$subcontract->subcontract_sequence_number = $subcontract_sequence_number;
			}

			// GC Contact Company office if have only one set it to default
			$gCContactCompany = ContactCompany::findContactCompanyByUserCompanyIdValues($database, $user_company_id, $user_company_id);
			$gc_contact_company_id = $gCContactCompany->contact_company_id;

			$loadContactCompanyOfficesByContactCompanyIdOptions = new Input();
			$loadContactCompanyOfficesByContactCompanyIdOptions->forceLoadFlag = true;
			$arrGCContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $gc_contact_company_id, $loadContactCompanyOfficesByContactCompanyIdOptions);

			$officecount = count($arrGCContactCompanyOffices);
			if($officecount == '1')
			{
				list($first_key) = each($arrGCContactCompanyOffices);
				$subcontract_gc_contact_company_office_id = $first_key;
				$subcontract->subcontract_gc_contact_company_office_id = $subcontract_gc_contact_company_office_id;
			}

			// Verify subcontractor_bid_id
			// @todo Figure out PO case which does not need this attribute
		

			// Verify subcontract_template_id
			if (!isset($subcontract->subcontract_template_id)) {
				$errorMessage = 'Missing subcontract_template_id.';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}

			// Verify vendor_id
			if (!isset($subcontract->vendor_id)) {
				$errorMessage = 'Missing vendor_id.';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}

			// Check for errors due to missing required attributes
			$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
			if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
				throw new Exception('Verification of required attributes failed.');
			}

			$subcontract->convertPropertiesToData();
			$data = $subcontract->getData();

			// Test for existence via standard findByUniqueIndex method
			$subcontract->findByUniqueIndex();
			if ($subcontract->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Subcontract already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception('Not Unique');
			} else {
				$subcontract->setKey(null);
				$subcontract->setData($data);
			}

			$subcontract->federal_tax_id = $fileType;
			$subcontract->reason = $fileReason;

			$subcontract_id = $subcontract->save();
			$subcontract->convertDataToProperties();
			if (isset($subcontract_id) && !empty($subcontract_id)) {
				$subcontract->subcontract_id = $subcontract_id;
				$subcontract->setId($subcontract_id);
				$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();

				// Create subcontract_documents for subcontract_document_types:
				// 1) Immutable Static Subcontract Document
				// 2) By Project Static Subcontract Document
				$subcontract_template_id = $subcontract->subcontract_template_id;
				
				$loadSubcontractItemTemplatesBySubcontractTemplateIdOptions = new Input();
				$loadSubcontractItemTemplatesBySubcontractTemplateIdOptions->forceLoadFlag = true;
				 $arrSubcontractItemTemplates = SubcontractItemTemplate::loadSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id, $loadSubcontractItemTemplatesBySubcontractTemplateIdOptions);


				 //To get the subcontract Document for project static
				$statDocument= SubcontractByStaticprjDocument($project_id);


				foreach ($arrSubcontractItemTemplates as $subcontract_item_template_id => $subcontractItemTemplate) {
					/* @var $subcontractItemTemplate SubcontractItemTemplate */
					$tmpSubcontractDocument = new SubcontractDocument($database);
					$tmpSubcontractDocument->subcontract_id = $subcontract_id;
					$tmpSubcontractDocument->subcontract_item_template_id = $subcontract_item_template_id;

					//For project static documents
					if(array_key_exists($subcontract_item_template_id,$statDocument))
					{
						$staticFileId = $statDocument[$subcontract_item_template_id];
						$tmpSubcontractDocument->unsigned_subcontract_document_file_manager_file_id = $staticFileId;
					}else
					{
					$tmpSubcontractDocument->unsigned_subcontract_document_file_manager_file_id = $subcontractItemTemplate->file_manager_file_id;
					}
					$tmpSubcontractDocument->sort_order = $subcontractItemTemplate->subcontract_document_sort_order;
					$tmpSubcontractDocument->convertPropertiesToData();
					$subcontract_document_id = $tmpSubcontractDocument->save();
				}

				if($fileId>0 || $fileId!=''){
					
					$subcontract_item_template_idW9='';
					$db = DBI::getInstance($database);
					$query ="SELECT * FROM `subcontract_item_templates` WHERE `subcontract_item` LIKE '%W9%' OR  `subcontract_item` LIKE '%W-9%' LIMIT 1 ";
					$db->execute($query);
					$row1 = $db->fetch();
					$subcontract_item_template_idW9 = $row1['id'];
					$subcontract_item_sort_orderW9 = $row1['sort_order'];

					$tmpSubcontractDocumentW9 = new SubcontractDocument($database);
					$tmpSubcontractDocumentW9->subcontract_id = $subcontract_id;
					$tmpSubcontractDocumentW9->subcontract_item_template_id = $subcontract_item_template_idW9;

					//For project static documents
					
					$tmpSubcontractDocumentW9->signed_subcontract_document_file_manager_file_id = $fileId;
					$tmpSubcontractDocumentW9->sort_order = $subcontract_item_sort_orderW9;
					$tmpSubcontractDocumentW9->convertPropertiesToData();
					$subcontract_document_id = $tmpSubcontractDocumentW9->save();
					$db->free_result();
				}
				

			}


			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success

			} else {
				// Error code here
				$errorNumber = 1;
				throw new Exception('No Primary Key');
			}
		} catch (Exception $e) {
			$db->rollback();

			$errorNumber = 1;
			$errorMessage = "Error creating: Subcontract";
			$message->enqueueError($errorMessage, $currentPhpScript);
			$primaryKeyAsString = '';
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorMessage = join('<br>', $arrErrorMessages);
			
		}

		$arrCustomizedJsonOutput = array(
			'gc_budget_line_item_id' => $gc_budget_line_item_id,
			'cost_code_division_id' => $cost_code_division_id,
			'cost_code_id' => $cost_code_id
		);

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}
		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|subcontracts|$primaryKeyAsString|$formattedAttributeGroupName|Subcontract|$gc_budget_line_item_id|$cost_code_division_id|$cost_code_id";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'updateSubcontract':

		$errorMessage = "Error updating: Subcontract";
		$message->enqueueError($errorMessage, $currentPhpScript);

		// Check permissions - manage
		

		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		// Get primary key / unique key via get input
		$attributeGroupName = (string) $get->attributeGroupName;
		$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
		$attributeSubgroupName = (string) $get->attributeSubgroupName;
		$attributeName = (string) $get->attributeName;
		$uniqueId = (string) $get->uniqueId;
		$newValue = (string) $get->newValue;


		// Unique index attibutes
		$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
		$cost_code_division_id = (int) $get->cost_code_division_id;
		$cost_code_id = (int) $get->cost_code_id;
		$subcontract_sequence_number = (int) $get->subcontract_sequence_number;

		if ($newValue == '') {
			$newValue = null;
		}

		$arrAllowableAttributes = array(
			'subcontract_id' => 'subcontract id',
			'gc_budget_line_item_id' => 'gc budget line item id',
			'subcontract_sequence_number' => 'subcontract sequence number',
			'subcontractor_bid_id' => 'subcontractor bid id',
			'subcontract_template_id' => 'subcontract template id',
			'subcontract_gc_contact_company_office_id' => 'subcontract gc contact company office id',
			'subcontract_gc_phone_contact_company_office_phone_number_id' => 'subcontract gc phone contact company office phone number id',
			'subcontract_gc_fax_contact_company_office_phone_number_id' => 'subcontract gc fax contact company office phone number id',
			'subcontract_gc_contact_id' => 'subcontract gc contact id',
			'subcontract_gc_contact_mobile_phone_number_id' => 'subcontract gc contact mobile phone number id',
			'vendor_id' => 'vendor id',
			'subcontract_vendor_contact_company_office_id' => 'subcontract vendor contact company office id',
			'subcontract_vendor_phone_contact_company_office_phone_number_id' => 'subcontract vendor phone contact company office phone number id',
			'subcontract_vendor_fax_contact_company_office_phone_number_id' => 'subcontract vendor fax contact company office phone number id',
			'subcontract_vendor_contact_id' => 'subcontract vendor contact id',
			'subcontract_vendor_contact_mobile_phone_number_id' => 'subcontract vendor contact mobile phone number id',
			'unsigned_subcontract_file_manager_file_id' => 'unsigned subcontract file manager file id',
			'signed_subcontract_file_manager_file_id' => 'signed subcontract file manager file id',
			'subcontract_forecasted_value' => 'subcontract forecasted value',
			'subcontract_actual_value' => 'subcontract actual value',
			'subcontract_retention_percentage' => 'subcontract retention percentage',
			'subcontract_issued_date' => 'subcontract issued date',
			'subcontract_target_execution_date' => 'subcontract target execution date',
			'subcontract_execution_date' => 'subcontract execution date',
			'active_flag' => 'active flag',

			// Derived Attributes
			'vendor_contact_company_id' => 'vendor contact company id',
			'contact_phone_number_id' => 'contact phone number id'
		);

		if (isset($arrAllowableAttributes[$attributeName])) {
			$formattedAttributeName = ucfirst($arrAllowableAttributes[$attributeName]);
		} else {
			$errorMessage = "Invalid attribute.";
			$message->enqueueError($errorMessage, $currentPhpScript);
			$error->outputErrorMessages();
			exit;
		}

		$message->reset($currentPhpScript);
		$errorMessage = "Error updating: Subcontract";
		$message->enqueueError($errorMessage, $currentPhpScript);

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->throwExceptionOnDbError = true;

		try {
			// Vendor
			if (($attributeSubgroupName == 'subcontracts') && ($attributeName == 'vendor_contact_company_id')) {
				// Convert 'vendor_contact_company_id' to 'vendor_id'

				// @todo Figure out Vendor implementation
				$vendor = false;
				$vendor_contact_company_id = (int) $get->vendor_contact_company_id;
				$vendor_contact_id = null;

				if (isset($vendor_id) && !empty($vendor_id)) {
					$vendor = Vendor::findById($database, $vendor_id);
				} elseif ((isset($vendor_contact_company_id) && !empty($vendor_contact_company_id)) || (isset($vendor_contact_id) && !empty($vendor_contact_id))) {
					$vendor = Vendor::findByVendorContactCompanyIdAndVendorContactId($database, $vendor_contact_company_id, $vendor_contact_id);
				} else {
					$vendor_id = null;
				}

				if ($vendor) {
					/* @var vendor Vendor */
					$vendor_id = $vendor->vendor_id;

					// Set dependent data points here...
					$vendor_contact_company_id = $vendor->vendor_contact_company_id;
					$vendor_contact_company_office_id = $vendor->vendor_contact_company_office_id;
					$vendor_contact_id = $vendor->vendor_contact_id;

					if ($vendor_contact_company_id) {
						$vendorContactCompany = ContactCompany::findContactCompanyByIdExtended($database, $vendor_contact_company_id);
					}

				} elseif ($vendor_contact_company_id <> 0) {

					$vendor = new Vendor($database);

					if (isset($vendor_contact_company_id) && !isset($vendor_contact_id)) {
						$vendor->vendor_contact_company_id = $vendor_contact_company_id;
						$vendor->vendor_contact_id = null;
					} elseif (!isset($vendor_contact_company_id) && isset($vendor_contact_id)) {
						$vendor->vendor_contact_company_id = null;
						$vendor->vendor_contact_id = $vendor_contact_id;
					} else {
						$vendor->vendor_contact_company_id = $vendor_contact_company_id;
						$vendor->vendor_contact_id = $vendor_contact_id;
					}

					$vendor->convertPropertiesToData();

					$vendor_id = $vendor->save();

				}

				if ($vendor_contact_company_id == 0) {
					$attributeName = 'vendor_id';
					$vendor_id = null;

					$errorMessage = "Subcontracts Must Have a Vendor";
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception('Do not proceed with the save operation.');
				} else {
					if ($vendor_id) {
						$attributeName = 'vendor_id';
						$newValue = $vendor_id;
					} else {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$error->outputErrorMessages();
						exit;
					}
				}
			}

			if ($attributeSubgroupName == 'subcontracts') {
				$subcontract_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$subcontract = Subcontract::findSubcontractByIdExtended($database, $subcontract_id);

				if ($subcontract) {
					// Check if the value actually changed
					$existingValue = $subcontract->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$error->outputErrorMessages();
						exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'gc_budget_line_item_id' => 1,
						'subcontract_sequence_number' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $subcontract->$attributeName;
						$subcontract->$attributeName = $newValue;
						$possibleDuplicateSubcontract = Subcontract::findByGcBudgetLineItemIdAndSubcontractSequenceNumber($database, $subcontract->gc_budget_line_item_id, $subcontract->subcontract_sequence_number);
						if ($possibleDuplicateSubcontract) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Subcontract $newValue already exists.";
						} else {
							$subcontract->$attributeName = $existingValue;
						}
					}

					if ($save) {
						// Reset dependent data points
						$data = array($attributeName => $newValue);
						// GC Office
						if ($attributeName == 'subcontract_gc_contact_company_office_id') {
							$data['subcontract_gc_phone_contact_company_office_phone_number_id'] = null;
							$data['subcontract_gc_fax_contact_company_office_phone_number_id'] = null;
						}
						// GC Contact
						if ($attributeName == 'subcontract_gc_contact_id') {
							$data['subcontract_gc_contact_mobile_phone_number_id'] = null;
						}
						// Vendor
						if ($attributeName == 'vendor_id') {
							if ($newValue == '') {
								$data['vendor_id'] = null;
							}
							$data['subcontract_vendor_contact_company_office_id'] = null;
							$data['subcontract_vendor_phone_contact_company_office_phone_number_id'] = null;
							$data['subcontract_vendor_fax_contact_company_office_phone_number_id'] = null;
							$data['subcontract_vendor_contact_id'] = null;
							$data['subcontract_vendor_contact_mobile_phone_number_id'] = null;
						}
						// Vendor Office
						if ($attributeName == 'subcontract_vendor_contact_company_office_id') {
							$data['subcontract_vendor_phone_contact_company_office_phone_number_id'] = null;
							$data['subcontract_vendor_fax_contact_company_office_phone_number_id'] = null;
						}
						// Vendor
						if ($attributeName == 'subcontract_vendor_contact_id') {
							$data['subcontract_vendor_contact_mobile_phone_number_id'] = null;
						}

						$subcontract->setData($data);
						$subcontract->convertDataToProperties();
						$subcontract->save();
						$errorMessage = '';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = "Subcontract record does not exist.";
					$message->enqueueError($errorMessage, $currentPhpScript);
					$error->outputErrorMessages();
					exit;
				}

				$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();

				$subcontract = Subcontract::findSubcontractByIdExtended($database, $subcontract->subcontract_id);
				$subcontractDetailsWidget = buildSubcontractDetailsWidget($database, $user_company_id, $subcontract_id);
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$db->throwExceptionOnDbError = false;

		$error = $message->getQueue($currentPhpScript, 'error');
		if (isset($error) && !empty($error)) {
			$errorMessage = join('<br>', $error);
			$resetToPreviousValue = 'Y';
		}

	break;

	case 'deleteSubcontract':

		// Get primary key / unique key via get input
		$recordContainerElementId = (string) $get->recordContainerElementId;
		$attributeGroupName = (string) $get->attributeGroupName;
		$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
		$attributeSubgroupName = (string) $get->attributeSubgroupName;
		$uniqueId = (string) $get->uniqueId;

		// Unique index attibutes
		$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
		$subcontract_sequence_number = (int) $get->subcontract_sequence_number;

		$errorNumber = 0;
		$errorMessage = '';

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->throwExceptionOnDbError = true;

		$message->reset($currentPhpScript);

		try {
			if ($attributeSubgroupName == 'subcontracts') {
				$subcontract_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$subcontract = Subcontract::findById($database, $subcontract_id);

				if ($subcontract) {
					// Delete subcontract_documents records
					$loadSubcontractDocumentsBySubcontractIdOptions = new Input();
					$loadSubcontractDocumentsBySubcontractIdOptions->forceLoadFlag = true;
					$arrSubcontractDocuments = SubcontractDocument::loadSubcontractDocumentsBySubcontractId($database, $subcontract_id, $loadSubcontractDocumentsBySubcontractIdOptions);
					foreach ($arrSubcontractDocuments as $subcontract_document_id => $subcontractDocument) {
						$subcontractDocument->delete();
					}

					// Delete subcontracts record
					$subcontract->delete();
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = "Subcontract record does not exist.";
					$message->enqueueError($errorMessage, $currentPhpScript);
					$error->outputErrorMessages();
					exit;
				}
			}
		} catch (Exception $e) {
			$db->rollback();

			$errorNumber = 1;
			$errorMessage = "Error deleting: Subcontract";
			$message->enqueueError($errorMessage, $currentPhpScript);
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
		}

		$primaryKeyAsString = $subcontract->getPrimaryKeyAsString();
		echo "$errorNumber|$errorMessage|$recordContainerElementId|$attributeGroupName|subcontracts|{$primaryKeyAsString}|$formattedAttributeGroupName|Subcontract";

	break;

	case 'updateSubcontractDocument':

		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Subcontract Document';
			$message->enqueueError($errorMessage, $currentPhpScript);

		

			// Get primary key / unique key via get input
			$attributeGroupName = (string) $get->attributeGroupName;
			$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
			$attributeSubgroupName = (string) $get->attributeSubgroupName;
			$attributeName = (string) $get->attributeName;
			$uniqueId = (string) $get->uniqueId;
			$newValue = (string) $get->newValue;

			// Primary key attibutes
			$subcontract_document_id = (int) $get->uniqueId;
			

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'subcontract_document_id' => 'subcontract document id',
				'subcontract_id' => 'subcontract id',
				'subcontract_item_template_id' => 'subcontract item template id',
				'unsigned_subcontract_document_file_manager_file_id' => 'unsigned subcontract document file manager file id',
				'signed_subcontract_document_file_manager_file_id' => 'signed subcontract document file manager file id',
				'auto_generated_flag' => 'auto generated flag',
				'disabled_flag' => 'disabled flag',
				'sort_order' => 'sort order',
			);

			if (isset($arrAllowableAttributes[$attributeName])) {
				$formattedAttributeName = ucfirst($arrAllowableAttributes[$attributeName]);
			} else {
				$errorMessage = 'Invalid attribute.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			if ($attributeSubgroupName == 'subcontract_documents') {
				$subcontract_document_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$subcontractDocument = SubcontractDocument::findById($database, $subcontract_document_id);
				/* @var $subcontractDocument SubcontractDocument */

				if ($subcontractDocument) {
					// Check if the value actually changed
					$existingValue = $subcontractDocument->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						throw new Exception($errorMessage);
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'subcontract_id' => 1,
						'subcontract_item_template_id' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $subcontractDocument->$attributeName;
						$subcontractDocument->$attributeName = $newValue;
						$possibleDuplicateSubcontractDocument = SubcontractDocument::findBySubcontractIdAndSubcontractItemTemplateId($database, $subcontractDocument->subcontract_id, $subcontractDocument->subcontract_item_template_id);
						if ($possibleDuplicateSubcontractDocument) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Subcontract Document $newValue already exists.";
							$message->enqueueError($errorMessage, $currentPhpScript);
							throw new Exception($errorMessage);
						} else {
							$subcontractDocument->$attributeName = $existingValue;
						}
					}

					if ($attributeName == 'sort_order') {
						$new_sort_order = (int) $newValue;

						// Set natural sort order on all records first
						$arrSubcontractDocuments = SubcontractDocument::loadSubcontractDocumentSortOrdersBySubcontractId($database, $subcontractDocument->subcontract_id);
						$i = 0;
						foreach ($arrSubcontractDocuments as $subcontract_document_id => $tmpSubcontractDocument) {
							/* @var $tmpSubcontractDocument SubcontractDocument */

							$sort_order = $tmpSubcontractDocument->sort_order;
							if ($sort_order != $i) {
								$data = array('sort_order' => $i);
								$tmpSubcontractDocument->setData($data);
								$tmpSubcontractDocument->save();
							}
							// Get the original sort_order value after updating to sane values
							if ($tmpSubcontractDocument->subcontract_document_id == $subcontractDocument->subcontract_document_id) {
								$original_sort_order = $i;
							}
							$i++;
						}

						if ($new_sort_order > $original_sort_order) {
							$movedDown = true;
							$movedUp = false;
						} elseif ($new_sort_order < $original_sort_order) {
							$movedDown = false;
							$movedUp = true;
						}

						$db->begin();
						if ($movedDown) {
							$query =
								"
								UPDATE `subcontract_documents`
								SET `sort_order` = (`sort_order`-1)
								WHERE `subcontract_id` = ?
								AND `sort_order` > ?
								AND `sort_order` <= ?
								";
							$arrValues = array($subcontractDocument->subcontract_id, $original_sort_order, $new_sort_order);
							$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
							$db->free_result();
						} elseif ($movedUp) {
							$query =
								"
								UPDATE `subcontract_documents`
								SET `sort_order` = (`sort_order`+1)
								WHERE `subcontract_id` = ?
								AND `sort_order` < ?
								AND `sort_order` >= ?
								";
							$arrValues = array($subcontractDocument->subcontract_id, $original_sort_order, $new_sort_order);
							$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
							$db->free_result();
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$subcontractDocument->setData($data);
						$subcontractDocument->save();
						$db->commit();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Subcontract Document record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';
		}

	break;

	case 'loadSubcontractItemTemplatesBySubcontractTemplateId':
		$subcontract_template_id = (int) $get->subcontract_template_id;
		$arrSubcontractItemTemplates = SubcontractItemTemplate::loadSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id);

		echo
			'<br>
			<div align="center"><b>Subcontract Documents</b></div>
			<table border="1" cellpadding="5">
				<tr>
					<th nowrap>Sort Order</th>
					<th nowrap>Subcontract Document</th>
					<th>Unsigned Droppable</th>
					<th nowrap>Preview Link</th>
					<th nowrap>Auto-Gen</th>
					<th>Signed Droppable</th>
				</tr>';
		$arrSubcontractItemTemplates = SubcontractItemTemplate::loadSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id);

		foreach ($arrSubcontractItemTemplates as $subcontract_item_template_id => $subcontractItemTemplate) {
				/* @var $subcontractItemTemplate SubcontractItemTemplate */

			$subcontract_item_template_id = (int) $subcontractItemTemplate->subcontract_item_template_id;
			$user_company_id = (int) $subcontractItemTemplate->user_company_id;
			$file_manager_file_id = (int) $subcontractItemTemplate->file_manager_file_id;
			$user_company_file_template_id = (int) $subcontractItemTemplate->user_company_file_template_id;
			$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
			$subcontract_item_abbreviation = (string) $subcontractItemTemplate->subcontract_item_abbreviation;
			$subcontract_item_template_type = (string) $subcontractItemTemplate->subcontract_item_template_type;
			$disabled_flag = (string) $subcontractItemTemplate->disabled_flag;

			$fileManagerFile = $subcontractItemTemplate->getFileManagerFile();
			/* @var $fileManagerFile FileManagerFile */
			$userCompanyFileTemplate = $subcontractItemTemplate->getUserCompanyFileTemplate();
			/* @var $userCompanyFileTemplate UserCompanyFileTemplate */

			echo
			' 	<tr>
					<td nowrap align="center"><img src="/images/sortbars.png"></td>
					<th nowrap style="text-align: right;">'.$subcontract_item.'</th>
					<td nowrap>Unsigned Droppable</td>
					<td nowrap>
					<a target="_blank" href="'.$uri->http.'_'.$unsignedSubcontractDocumentFileManagerFile->file_manager_file_id.'">'.$unsignedSubcontractDocumentFileManagerFile->virtual_file_name.'</a>
					</td>
					<td nowrap><input type="button" value="Render Document"></td>
					<td nowrap>Signed Droppable</td>
				</tr>
			';
		}

		echo '</table>';


	break;

	case 'filterGcBudgetLineItems':

		$cost_code_division_id = $get->cost_code_division_id;
		$order_by_attribute = $get->order_by_attribute;
		$order_by_direction = $get->order_by_direction;
		$scheduledValuesOnly = $get->scheduledValuesOnly;
		$needsBuyOutOnly = $get->needsBuyOutOnly;
		$needsSubValue = $get->needsSubValue;

		if ($cost_code_division_id == '-1') {
			$cost_code_division_id = null;
		}
		if ($order_by_attribute == '-1') {
			$order_by_attribute = false;
		}
		if ($scheduledValuesOnly == 'true') {
			$scheduledValuesOnly = true;
			$_SESSION['scheduledValuesOnly']='checked=true;';
		} else {
			$scheduledValuesOnly = false;
			$_SESSION['scheduledValuesOnly']='';
		}
		if ($needsBuyOutOnly == 'true') {
			$needsBuyOutOnly = true;
		} else {
			$needsBuyOutOnly = false;
		}

		if ($needsSubValue == 'true') {
			$needsSubValue = true;
		} else {
			$needsSubValue = false;
		}

		$htmlContent = renderGcBudgetLineItemsTbody($database, $user_company_id, $project_id, $cost_code_division_id, $order_by_attribute, $order_by_direction, $scheduledValuesOnly, $needsBuyOutOnly,$needsSubValue);
		echo $htmlContent;

	break;

	case 'loadSubcontractDetailsWidget':

		$subcontract_id = (int) $get->subcontract_id;
		$htmlContent = buildSubcontractDetailsWidget($database, $user_company_id, $subcontract_id);
		$arrOutput = array(
			'subcontract_id' => $subcontract_id,
			'html' => $htmlContent,
			'errorNumber' => 0
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;

	case 'createSubcontractDocumentsForSubcontract':

		$subcontract_id = (int) $get->subcontract_id;
		$csvSubcontractDocumentIds = createSubcontractDocumentsForSubcontract($database, $subcontract_id);
		$arrOutput = array(
			'subcontract_id' => $subcontract_id,
			'csvSubcontractDocumentIds' => $csvSubcontractDocumentIds
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;
	case 'updateorAddprjStaticfile':
		$template_id = (int) $get->template_id;
		$fileId = (int) $get->fileId;

		$db = DBI::getInstance();
		$up_query = "SELECT * FROM subcontract_document_to_project WHERE project_id = $project_id and subcontract_item_template_id = $template_id ";
		$db->execute($up_query);
		$up_fet = $db->fetch();
		$update_id=$up_fet['id'];
		$db->free_result();
		if($update_id)
		{
			$up_query1 = "UPDATE `subcontract_document_to_project` SET `file_manager_file_id`=$fileId WHERE `id`=$update_id";
			$db->execute($up_query1);
			$db->free_result();

		}else
		{
			$up_query1 = "INSERT INTO `subcontract_document_to_project`( `project_id`, `subcontract_item_template_id`, `file_manager_file_id`) VALUES ($project_id,$template_id,$fileId)";
			$db->execute($up_query1);
			$db->free_result();
		}

	break;

	case 'loadUploadCostCode':
		$input = new Input();
		$input->action = '/modules-gc-budget-ajax.php';
		$input->method = 'uploadCostCodeExcel';
		// Create FileManagerFolder
		$input->id = 'import_default';
		$input->allowed_extensions = 'xlsx,csv';
		$input->style="width:250px;";
		$input->post_upload_js_callback = 'costCodeExcelFileRefresh(arrFileManagerFiles);';
    	$input->multiple = 'false';
		$uploaderPhotos = buildFileUploader($input);
		$uploadWindow = buildFileUploaderProgressWindow();
    	$htmlContent = <<<END_HTML_CONTENT

		<input type="hidden" id="costCodeTemplate" name="costCodeTemplate" value="">
		<input type="hidden" id="costCodeTemplateErrorValid" name="costCodeTemplateErrorValid" value="">
		<div class="process-step">
			<div class="line"></div>
			<ul>
				<li class="importSteps active" id="importStepOne">
					<span class="number">1</span>
					<span class="name">upload</span>
				</li>
				<li class="importSteps" id="importStepTwo">
					<span class="number">2</span>
					<span class="name">map data</span>
				</li>
				<li class="importSteps" id="importStepThree">
					<span class="number">3</span>
					<span class="name">import</span>
				</li>
			</ul>
		</div>
		<div id="costCodeUploadStepOne" class="costCodeUploadSteps">
	    <div>
				<h4>Select a CSV or Excel file to upload</h4>
				<div class="input-group-default" style="width: 35%;">
					 $uploaderPhotos
					 $uploadWindow
					 <ul id="record_list_container--manage-costcode-file-import-record" style="margin:10px 0 5px 0px;list-style:none;padding:0;"></ul>
		    </div>
		    <a href="javascript:void(0)" onclick="downloadCostcodeTemplate()"><u>Download a sample file</u></a>
			</div>
			<button style="float:left;margin:15px 0;" class="btn-cmn" onclick="cancelImportCostCode()">Cancel</button>
			<button class="btn-cmn btn-disable" style="float: right;margin: 15px 0;" disabled="disabled" id="stepOneNextButton" onclick="mapExcelHeaders()">Next</button>
    </div>
		<div id="costCodeUploadStepTwo" class="costCodeUploadSteps">
		</div>
		<div id="costCodeUploadStepThree" class="costCodeUploadSteps">
		</div>
END_HTML_CONTENT;
	   echo $htmlContent;
	break;

	case 'uploadCostCodeExcel':

		$uploadTempFilesOnly = true;
		// Temp directory prefix to help have a balanced filesystem on the server
		$tempDirectoryPrefix = "$user_company_id/$user_id/$currentlyActiveContactId/";

		$arrFiles = array();

		$arrFiles = File::parseUploadedFiles($tempDirectoryPrefix);

		$arrayFileImport = array();
		foreach ($arrFiles as $file) {
			$fileSizePath = $file->tempFilePath;
			$virtual_file_name = urldecode($file->name);
		}
		$liUploadedFieldReports .= <<<END_LI_UPLOADED_FIELD_REPORTS
		<script>
		 $(".bs-tooltip").tooltip();
		</script>
		<li>
		<a href="javascript:deleteCostCodeFile();" class="bs-tooltip entypo-cancel-circled" data-placement="right" data-original-title="Delete this file"></a>
		$virtual_file_name
		</li>
END_LI_UPLOADED_FIELD_REPORTS;
		$arrayFileImport = array(
			'virtualFileName' => $virtual_file_name,
			'virtualFilePath' => $fileSizePath,
			'liData' => $liUploadedFieldReports
		);
		$errorMessage = 'File upload successfully';
		$message->enqueueError($errorMessage, $currentPhpScript);
		$arrJsonOutput = array(
			'success' => $errorMessage,
			'fileMetadata' => $arrayFileImport
		);
		echo $arrJsonOutput = json_encode($arrJsonOutput);
		exit(0);
	break;
	case 'mapExcelHeaders':
			$errorNumber = 0;
			$errorMessage = '';
			$filePath = $get->filePath;
			$JsonValid = 0;
			try{
				$valid = file_exists($filePath);
				if($valid){
					$mapData = <<<END_HTML_MAP_CONTENT
	        		<script>
						$(".importCostCodeDropdown").change(function(){
					  		$(".importCostCodeDropdown option").show();
							var arr = $.map(
								$(".importCostCodeDropdown option:selected"), function(n){
									return n.value;
								});
							$(".importCostCodeDropdown").filter(function(){
								var dropdownId = $(this).attr('id');
								var dropdownValue = $('#'+dropdownId).val();
								$(this).children().filter(function(){
									if($(this).val() && $(this).val() != dropdownValue){
										return $.inArray($(this).val(),arr)>-1;
									}
								}).hide();
							});
						});
					</script>
END_HTML_MAP_CONTENT;
					$mapData .= <<<END_HTML_MAP_CONTENT
					<h4>Map your fields to Fulcrum fields</h4>
					<div style="width:50%;">
	 				 <table class="qb-table" border="1">
	 					 <thead>
	 						 <tr>
	 							 <th>Fulcrum Online field</th>
	 							 <th>Your field</th>
	 						 </tr>
	 					</thead>
END_HTML_MAP_CONTENT;
				$objPHPExcel = PHPExcel_IOFactory::load($filePath);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				$costCodeAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$costCodei = 2;
				$sheet = $objPHPExcel->getActiveSheet();
				$highestRow = $sheet->getHighestDataRow();
				$highestColumn = $sheet->getHighestDataColumn();

				$htmlOptions = '';
				//check if first and second row has headers
				$firstRowData = $sheet->rangeToArray('A1' . ':' . $highestColumn . '1',NULL,TRUE,FALSE);
				if(trim(isEmptyRow(reset($firstRowData))) == false) {
				  $htmlOptions = getCostCodeHeaders(1,$objPHPExcel);
				}else{
					$secondRowData = $sheet->rangeToArray('A2' . ':' . $highestColumn . '2',NULL,TRUE,FALSE);
					if(trim(isEmptyRow(reset($secondRowData))) == false) {
					  $htmlOptions = getCostCodeHeaders(2,$objPHPExcel);
				  	}
				}

				$selectDropdown .= <<<END_HTML_MAP_CONTENT
						 <option value="">Select</option>
						 $htmlOptions
END_HTML_MAP_CONTENT;
				$mapData .= <<<END_HTML_MAP_CONTENT
				 <tbody>
				   <tr align='left'>
					  <td>Division Number</td>
						<td><select id="division_number" name="division_number" class="importCostCodeDropdown">$selectDropdown</select></td>
					 </tr>
					 <tr align='left'>
						 <td>Division Code Heading Number</td>
						 <td><select id="division_heading_number" name="division_heading_number" class="importCostCodeDropdown">$selectDropdown</select></td>
					 </tr>
						<tr align='left'>
						 <td>Cost Code</td>
						 <td><select id="cost_code" name="cost_code" class="importCostCodeDropdown">$selectDropdown</select></td>
						</tr>
						<tr align='left'>
						 <td>Division Name</td>
						 <td><select id="division_name" name="division_name" class="importCostCodeDropdown">$selectDropdown</select></td>
						</tr>
						<tr align='left'>
						 <td>Division Abbrevation</td>
						 <td><select id="division_abbreviation" name="division_abbreviation" class="importCostCodeDropdown">$selectDropdown</select></td>
						</tr>
						<tr align='left'>
						 <td>Cost Code Description</td>
						 <td><select id="cost_code_description" name="cost_code_description" class="importCostCodeDropdown">$selectDropdown</select></td>
						</tr>
						<tr align='left'>
						 <td>Cost Code Description Abbrevation</td>
						 <td><select id="cost_code_description_abbreviation" name="cost_code_description_abbreviation" class="importCostCodeDropdown">$selectDropdown</select></td>
						</tr>
				 	</tbody>
    			</table>
			</div>
END_HTML_MAP_CONTENT;
				$mapData .= <<<END_HTML_MAP_CONTENT
				  <button style="float:left;margin-bottom:20px;" class="btn-cmn" onclick="gotoStepOne()">Back</button>
				  <button style="float:right;margin-bottom:20px;" class="btn-cmn" onclick="mapCostcodeExcel()">Next</button>
END_HTML_MAP_CONTENT;

		        	if($htmlOptions == ''){
							$headerCount = 0;
					}else{
							$headerCount = 1;
					}
					$json_encode = array(
						'headerCount' => $headerCount,
						'headers' => $mapData
					);
					echo json_encode($json_encode);
				}else{
					$errorNumber = 1;
					$errorMessage = 'File not exists';
					$message->enqueueError($errorMessage, $currentPhpScript);
				}
			} catch(Exception $e){
				$errorNumber = 1;
			}
	break;
	case 'mapSubmittalExcelHeaders':
			$errorNumber = 0;
			$errorMessage = '';
			$filePath = $get->filePath;
			$JsonValid = 0;
			try{
				$valid = file_exists($filePath);
				if($valid){
					$mapData = <<<END_HTML_MAP_CONTENT
	        		<script>
						$(".importCostCodeDropdown").change(function(){
					  		$(".importCostCodeDropdown option").show();
							var arr = $.map(
								$(".importCostCodeDropdown option:selected"), function(n){
									return n.value;
								});
							$(".importCostCodeDropdown").filter(function(){
								var dropdownId = $(this).attr('id');
								var dropdownValue = $('#'+dropdownId).val();
								$(this).children().filter(function(){
									if($(this).val() && $(this).val() != dropdownValue){
										return $.inArray($(this).val(),arr)>-1;
									}
								}).hide();
							});
						});
					</script>
END_HTML_MAP_CONTENT;
					$mapData .= <<<END_HTML_MAP_CONTENT
					<h4>Map your fields to Fulcrum fields</h4>
					<div style="width:50%;">
	 				 <table class="qb-table" border="1">
	 					 <thead>
	 						 <tr>
	 							 <th>Fulcrum Online field</th>
	 							 <th>Your field</th>
	 						 </tr>
	 					</thead>
END_HTML_MAP_CONTENT;
				$objPHPExcel = PHPExcel_IOFactory::load($filePath);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				$costCodeAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$costCodei = 2;
				$sheet = $objPHPExcel->getActiveSheet();
				$highestRow = $sheet->getHighestDataRow();
				$highestColumn = $sheet->getHighestDataColumn();

				$htmlOptions = '';
				//check if first and second row has headers
				$firstRowData = $sheet->rangeToArray('A1' . ':' . $highestColumn . '1',NULL,TRUE,FALSE);
				if(trim(isEmptyRow(reset($firstRowData))) == false) {
				  $htmlOptions = getCostCodeHeaders(2,$objPHPExcel);
				}else{
					$secondRowData = $sheet->rangeToArray('A2' . ':' . $highestColumn . '2',NULL,TRUE,FALSE);
					if(trim(isEmptyRow(reset($secondRowData))) == false) {
					  $htmlOptions = getCostCodeHeaders(2,$objPHPExcel);
				  	}
				}

				$selectDropdown .= <<<END_HTML_MAP_CONTENT
						 <option value="">Select</option>
						 $htmlOptions
END_HTML_MAP_CONTENT;
				$mapData .= <<<END_HTML_MAP_CONTENT
				 <tbody>
						<tr align='left'>
						 <td>Cost Code</td>
						 <td><select id="cost_code" name="cost_code" class="importCostCodeDropdown">$selectDropdown</select></td>
						</tr>
						<tr align='left'>
						 <td>Specification Number</td>
						 <td><select id="specification_number" name="specification_number" class="importCostCodeDropdown">$selectDropdown</select></td>
						</tr>
						<tr align='left'>
						 <td>Submittal Title</td>
						 <td><select id="submittal_title" name="submittal_title" class="importCostCodeDropdown">$selectDropdown</select></td>
						</tr>
						<tr align='left'>
						 <td>Submittal Notes</td>
						 <td><select id="submittal_notes" name="submittal_notes" class="importCostCodeDropdown">$selectDropdown</select></td>
						</tr>
				 	</tbody>
    			</table>
			</div>
END_HTML_MAP_CONTENT;
				$mapData .= <<<END_HTML_MAP_CONTENT
				  <button style="float:left;margin-bottom:20px;" class="btn-cmn" onclick="gotoStepOne()">Back</button>
				  <button style="float:right;margin-bottom:20px;" class="btn-cmn" onclick="mapCostcodeExcel()">Next</button>
END_HTML_MAP_CONTENT;

		        	if($htmlOptions == ''){
							$headerCount = 0;
					}else{
							$headerCount = 1;
					}
					$json_encode = array(
						'headerCount' => $headerCount,
						'headers' => $mapData
					);
					echo json_encode($json_encode);
				}else{
					$errorNumber = 1;
					$errorMessage = 'File not exists';
					$message->enqueueError($errorMessage, $currentPhpScript);
				}
			} catch(Exception $e){
				$errorNumber = 1;
			}
	break;
	case 'checkCostCodeExist':
		$errorNumber = 0;
		$errorMessage = '';
		$filePath = $get->filePath;
		$divisionNumberField = (int) $get->divisionNumber;
		$costCodeNumberField = (int) $get->costcodeNumber;
		$divisionHeadingNumberField = (int) $get->divisionHeadingNumber;
		$divisionNameField = (int) $get->divisionName;
		$costCodeDescriptionField = (int) $get->costCodeDescription;
		$costCodeDescriptionAbbreviationField = (int) $get->costCodeDescriptionAbbreviation;
		$divisionAbbreviationField = (int) $get->divisionAbbreviation;
		$selectedFieldsCount = (int) $get->selectedFieldsCount;
		$JsonValid = 0;
		try{
			$valid = file_exists($filePath);
			if($valid){
				$db = DBI::getInstance($database);
				/* @var $db DBI_mysqli */
				$db->throwExceptionOnDbError = true;
				$message->reset($currentPhpScript);
				$objPHPExcel = PHPExcel_IOFactory::load($filePath);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

				$costCodeAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$arrayCount = count($costCodeAllDataInSheet);
				$costCodeArray = array();
				$importHints = <<<END_HTML_CONTENT
			   	<div class="useDefaultTemplateInstruction">
		            <h4 class="h3header" style="margin:0px;">USE DEFAULT TEMPLATE</h4>
	             	<ul>
	              		<li>Ensure you have a value for each of the mandatory fields in the sheet (Division Number, Cost Code, Division Name and Cost Code Description).</li>
						<li>Any excel file you create can be uploaded provided it meets the guidelines below.</li>
	              	</ul>
				</div>
          		<div class="useDefaultTemplateInstruction">
					<h4 class="h3header" style="margin:0px;">Guidelines for Import</h4>
					<ul style="list-style: none;">
						<li>1. All mandatory cells within corresponding sheet should have a value.</li>
						<li>a. Mandatory fields for sheet- Division Number, Cost Code, Division Name and Cost Code Description</li>
						<li>2. The 1st and 2nd row of the excel sheet are reserved for headers, your data must begin on row 3.
						</li>
						<li>3. After uploading review the list for missing, duplicate, or invalid data. Correct your excel file and try uploading again.
							<p></p><div class="errorCode"><span class="alreadyExist">( <div class="circleBlack"></div> ) - Data Already Exist.</span><span class="alreadyExist">( <div class="circleRed"></div> ) - Data is Mandatory.</span><span class="alreadyExist">( <div class="circleRed"></div>&nbsp;<div class="circleRed"></div> ) - Invalid Data.</span> </div><p></p>
						</li>
            		</ul>
          		</div>
END_HTML_CONTENT;
				$costCodeTableData ="<div class='content cell-border tableborder costCodeImport table-fixed-thead' width='100%'>";
				$costCodeTableDataIn = 1;
        		$sheet = $objPHPExcel->getActiveSheet();
				$highestRow = $sheet->getHighestDataRow();
				$highestColumn = $sheet->getHighestDataColumn();
			  	switch($selectedFieldsCount){
					case 4:
						$width = 'style="width:22%"';
					break;
					case 5:
					 	$width = 'style="width:18%"';
					break;
					case 6:
					 	$width = 'style="width:15%"';
					break;
					case 7:
					 	$width = 'style="width:12%"';
					break;
					default:
					break;
				}
				/*Cost code information*/
				$costCodeHeaders = '';
				if($divisionNumberField){
					$costCodeHeaders .= "<li $width>Division Number</li>";
				}
				if($divisionHeadingNumberField){
					$costCodeHeaders .= "<li $width>Division Code<br> Heading Number</li>";
				}
				if($costCodeNumberField){
					$costCodeHeaders .= "<li $width>Cost Code</li>";
				}
				if($divisionNameField){
	        		$costCodeHeaders .= $selectedFieldsCount == 4? "<li $width>Division Name</li>" : "<li $width>Division<br> Name</li>";
				}
				if($divisionAbbreviationField){
	        		$costCodeHeaders .= "<li $width>Division<br> Abbrevation</li>";
				}
				if($costCodeDescriptionField){
	         	$costCodeHeaders .= $selectedFieldsCount == 4? "<li $width>Cost Code Description</li>" : "<li $width>Cost Code<br> Description</li>";
				}
			  	if($costCodeDescriptionAbbreviationField){
          			$costCodeHeaders .= "<li $width>Cost Code<br> Description Abbrevation</li>";
				}
        		$costCodeTableDataDiv = '<div class="view-list">';
				for($costCodei = 3; $costCodei <= $arrayCount; $costCodei++){
					$rowData = $sheet->rangeToArray('A' . $costCodei . ':' . $highestColumn . $costCodei,NULL,TRUE,FALSE);

	 				if(isEmptyRow(reset($rowData))) {
						 continue;
					}
					$tableYes = 0;
					$divisonNumber = $divisonHeadingNumber = $costCode = $divisionName = $divisionAbbreviation = $costCodeDescription = $costCodeAbbreviation = '' ;
					$divisionNumberSpan = "";
					$costCodeData = '';
					if($divisionNumberField){
						$divisonNumberColumn = $divisionNumberField-1;
						$divisonNumber = $sheet->getCellByColumnAndRow($divisonNumberColumn,$costCodei)->getFormattedValue();
						$indexCom = $divisonNumber;
						$costCodeArray[$indexCom]['division_number'] = $divisonNumber;
						if($divisonNumber == ''){
							$JsonValid = 1;
							$divisionNumberSpan = "<span class='circleRed floadCircle'></span>";
						} else if(preg_match('/^[0-9]{1,2}$/',$divisonNumber) == 0){
							$JsonValid = 1;
							$divisionNumberSpan = "<span class='circleRed floadCircle'></span><span class='circleRed floadCircle'></span>";
						}
						$costCodeData .= "<li $width>$divisonNumber $divisionNumberSpan</li>";
					}

					$costCodeArray[$indexCom]['cost_code_type_id'] = 5;
					$costCodeTypeId = 5;

					$possibleDuplicateCostCodeDivision = CostCodeDivision::checkDuplicateCostCodeDivision($database, $user_company_id, $costCodeTypeId, $divisonNumber);

					$divisonHeadingNumberSpan = "";
					if($divisionHeadingNumberField){
						$divisionHeadingNumberColumn = $divisionHeadingNumberField-1;
						$divisonHeadingNumber = $costCodeArray[$indexCom]['division_code_heading'] = $sheet->getCellByColumnAndRow($divisionHeadingNumberColumn,$costCodei)->getFormattedValue();
						if($divisonHeadingNumber && preg_match('/^\d+$/',$divisonHeadingNumber) == 0){
							$JsonValid = 1;
							$divisonHeadingNumberSpan = "<span class='circleRed floadCircle'></span><span class='circleRed floadCircle'></span>";
						}
						$costCodeData .= "<li $width>$divisonHeadingNumber $divisonHeadingNumberSpan</li>";
					}

					$costCodeSpan = "";
          			if($costCodeNumberField){
						$costCodeNumberColumn = $costCodeNumberField - 1;
						$costCodeNumber = $costCodeArray[$indexCom]['cost_code'] = $sheet->getCellByColumnAndRow($costCodeNumberColumn,$costCodei)->getFormattedValue();
						if(isset($possibleDuplicateCostCodeDivision) && !empty($possibleDuplicateCostCodeDivision['id'])){
							$costCodeDivisionId = $possibleDuplicateCostCodeDivision['id'];
							$possibleDuplicateCostCode = CostCode::checkDuplicateCostCode($database, $costCodeDivisionId, $costCodeNumber);
						}
						if($costCodeNumber == ''){
							$JsonValid = 1;
							$costCodeSpan = "<span class='circleRed floadCircle'></span>";
						} else if(isset($possibleDuplicateCostCode) && !empty($possibleDuplicateCostCode['id'])){
							$JsonValid = 1;
	 					  $costCodeSpan = "<span class='circleBlack floadCircle'></span>";
						}
						$costCodeData .="<li $width>$costCodeNumber $costCodeSpan</li>";
					}

					$divisionNameSpan = '';
					if($divisionNameField){
						$divisionNameColumn = $divisionNameField - 1;
						$divisionName = $costCodeArray[$indexCom]['division'] = $sheet->getCellByColumnAndRow($divisionNameColumn,$costCodei)->getFormattedValue();
						if($divisionName == ''){
							$JsonValid = 1;
							$divisionNameSpan = "<span class='circleRed floadCircle'></span>";
						}
						$costCodeData .= "<li $width>$divisionName $divisionNameSpan</li>";
					}

					if($divisionAbbreviationField){
						$divisionAbbreviationColumn = $divisionAbbreviationField - 1;
						$divisionAbbreviation = $costCodeArray[$indexCom]['division_abbreviation'] = $sheet->getCellByColumnAndRow($divisionAbbreviationColumn,$costCodei)->getFormattedValue();
						$costCodeData .= "<li $width>$divisionAbbreviation</li>";
					}

					$costCodeDescriptionSpan = '';
					if($costCodeDescriptionField){
						$costCodeDescriptionColumn = $costCodeDescriptionField - 1;
						$costCodeDescription = $costCodeArray[$indexCom]['cost_code_description'] = $sheet->getCellByColumnAndRow($costCodeDescriptionColumn,$costCodei)->getFormattedValue();
						if($costCodeDescription == ''){
							$JsonValid = 1;
							$costCodeDescriptionSpan = "<span class='circleRed floadCircle'></span>";
						}
						$costCodeData .= "<li $width>$costCodeDescription $costCodeDescriptionSpan</li>";
					}

				  if($costCodeDescriptionAbbreviationField){
						$costCodeDescriptionAbbreviationColumn = $costCodeDescriptionAbbreviationField - 1;
						$costCodeAbbreviation = $costCodeArray[$indexCom]['cost_code_description_abbreviation'] = $sheet->getCellByColumnAndRow($costCodeDescriptionAbbreviationColumn,$costCodei)->getFormattedValue();
						$costCodeData .= "<li $width>$costCodeAbbreviation</li>";
					}

					$costCodeTableDataIn++;
          $costCodeTableDataDiv.="<ul>
					   $costCodeData
					</ul>";
				}
				if(count($costCodeArray) == 0){
					$costCodeTableDataDiv .= "<ul><li>No records found</li></ul>";
				}
        		$costCodeUl .= "<div class='borderBottom'>
						<ul class='table-headerinner'>
						 <li class='textAlignLeft'>Cost Code List</li>
						</ul>
						<ul align='left' class='t-head'>
						 $costCodeHeaders
						</ul>
					 </div>
						 $costCodeTableDataDiv
					 </div>
					</ul>
				</div>";
				$costCodeTableData .= <<<END_HTML_CONTENT
				  $costCodeUl
				 <button style="float:left;margin:15px 0;" class="btn-cmn" onclick="gotoStepTwo()">Back</button>
				 <button style="float:right;margin:15px 0;" class="btn-cmn" id="importButton"
onclick="importCostCodeExcel($divisionNumberField,$costCodeNumberField,$divisionHeadingNumberField,$divisionNameField,$costCodeDescriptionField,$costCodeDescriptionAbbreviationField,$divisionAbbreviationField)">Import</button>
END_HTML_CONTENT;
        $table .= $importHints;
				$table .= $costCodeTableData;
				$table;
				$json_encode = array(
					'data' => $table,
					'invalid' => $JsonValid
				);
				echo json_encode($json_encode);
			}else{
				$errorNumber = 1;
				$errorMessage = 'File not exists';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}
		} catch(Exception $e){
			$errorNumber = 1;
		}
  	break;
	case 'checkSubmittalRegistryExist':
		$errorNumber = 0;
		$errorMessage = '';
		$filePath = $get->filePath;
		$divisionNumberField = (int) $get->divisionNumber;
		$costCodeNumberField = (int) $get->costcodeNumber;
		$divisionHeadingNumberField = (int) $get->divisionHeadingNumber;
		$specificationNumberField = (int) $get->specificationNumber;

		$submittalTitleField = (int) $get->submittalTitle;
		$submittalNotesField = (int) $get->submittalNotes;
		$selectedFieldsCount = (int) $get->selectedFieldsCount;
		$JsonValid = 0;
		try{
			$valid = file_exists($filePath);
			if($valid){
				$db = DBI::getInstance($database);
				/* @var $db DBI_mysqli */
				$db->throwExceptionOnDbError = true;
				$message->reset($currentPhpScript);
				$objPHPExcel = PHPExcel_IOFactory::load($filePath);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

				$costCodeAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$arrayCount = count($costCodeAllDataInSheet);
				$costCodeArray = array();
				$importHints = <<<END_HTML_CONTENT
			   	<div class="useDefaultTemplateInstruction">
		            <h4 class="h3header" style="margin:0px;">USE DEFAULT TEMPLATE</h4>
	             	<ul>
	              		<li>Ensure you have a value for each of the mandatory fields in the sheet (Division Number, Cost Code, Division Name and Cost Code Description).</li>
						<li>Any excel file you create can be uploaded provided it meets the guidelines below.</li>
	              	</ul>
				</div>
          		<div class="useDefaultTemplateInstruction">
					<h4 class="h3header" style="margin:0px;">Guidelines for Import</h4>
					<ul style="list-style: none;">
						<li>1. All mandatory cells within corresponding sheet should have a value.</li>
						<li>a. Mandatory fields for sheet- Division Number, Cost Code, Specification Number, Submittal Title and Submittal Notes</li>
						<li>2. The 1st and 2nd row of the excel sheet are reserved for headers, your data must begin on row 3.
						</li>
						<li>3. After uploading review the list for missing, duplicate, or invalid data. Correct your excel file and try uploading again.
							<p></p><div class="errorCode"><span class="alreadyExist">( <div class="circleBlack"></div> ) - Cost Code Already Exist in submittal registry.( <div class="circleBlack"></div>&nbsp;<div class="circleBlack"></div> ) - Cost Code not available in generic master.</span><span class="alreadyExist">( <div class="circleRed"></div> ) - Cost Code and Submittal title is Mandatory.</span><span class="alreadyExist">( <div class="circleRed"></div>&nbsp;<div class="circleRed"></div> ) - Invalid Cost Code.</span> </div><p></p>
						</li>
            		</ul>
          		</div>
END_HTML_CONTENT;
				$costCodeTableData ="<div class='content cell-border tableborder costCodeImport table-fixed-thead' width='100%'>";
				$costCodeTableDataIn = 1;
        		$sheet = $objPHPExcel->getActiveSheet();
				$highestRow = $sheet->getHighestDataRow();
				$highestColumn = $sheet->getHighestDataColumn();
			  	switch($selectedFieldsCount){
					case 4:
						$width = 'style="width:22%"';
					break;
					case 5:
					 	$width = 'style="width:18%"';
					break;
					case 6:
					 	$width = 'style="width:15%"';
					break;
					case 7:
					 	$width = 'style="width:12%"';
					break;
					default:
					break;
				}
				/*Cost code information*/
				$costCodeHeaders = '';
				if($divisionNumberField){
					$costCodeHeaders .= "<li $width>Division Number</li>";
				}
				if($divisionHeadingNumberField){
					$costCodeHeaders .= "<li $width>Division Code<br> Heading Number</li>";
				}
				if($costCodeNumberField){
					$costCodeHeaders .= "<li $width>Cost Code</li>";
				}
				if($specificationNumberField){
	        		$costCodeHeaders .= $selectedFieldsCount == 4? "<li $width>Specification Number</li>" : "<li $width>Specification<br> Number</li>";
				}
				if($submittalTitleField){
	         	$costCodeHeaders .="<li $width>Submittal Title</li>";
				}
			  	if($submittalNotesField){
          			$costCodeHeaders .= "<li $width>Submittal Notes</li>";
				}
        		$costCodeTableDataDiv = '<div class="view-list">';
				for($costCodei = 3; $costCodei <= $arrayCount; $costCodei++){
					$rowData = $sheet->rangeToArray('A' . $costCodei . ':' . $highestColumn . $costCodei,NULL,TRUE,FALSE);

	 				if(isEmptyRow(reset($rowData))) {
						 continue;
					}
					$tableYes = 0;
					$divisonNumber = $divisonHeadingNumber = $costCode = $divisionName = $divisionAbbreviation = $costCodeDescription = $costCodeAbbreviation = '' ;
					$divisionNumberSpan = "";
					$costCodeData = '';
					$delimiters = ['-', '_', '.', ':', ' '];
					if($costCodeNumberField){
						$divisonNumberColumn = $costCodeNumberField-1;
						$divisonNumberCC = $sheet->getCellByColumnAndRow($divisonNumberColumn,$costCodei)->getFormattedValue();
						$divisonNumberS = str_replace($delimiters,"-", $divisonNumberCC);
						$divisonNumber = explode("-", $divisonNumberS)[0];
						$indexCom = $divisonNumber;
						$costCodeArray[$indexCom]['division_number'] = $divisonNumber;						
					}

					$costCodeArray[$indexCom]['cost_code_type_id'] = 5;
					$costCodeTypeId = 5;

					$possibleDuplicateCostCodeDivision = CostCodeDivision::checkDuplicateCostCodeDivision($database, $user_company_id, $costCodeTypeId, $divisonNumber);

					$costCodeSpan = "";
          			if($costCodeNumberField){
						$costCodeNumberColumn = $costCodeNumberField - 1;
						$costCodeNumberCC = $costCodeArray[$indexCom]['cost_code'] = $sheet->getCellByColumnAndRow($costCodeNumberColumn,$costCodei)->getFormattedValue();
						$costCodeNumberS = str_replace($delimiters,"-", $costCodeNumberCC);
						$costCodeNumber = explode("-", $costCodeNumberS)[1];
						$possibleDuplicateCostCode=[];
						if(isset($possibleDuplicateCostCodeDivision) && !empty($possibleDuplicateCostCodeDivision['id'])){
							$costCodeDivisionId = $possibleDuplicateCostCodeDivision['id'];
							$possibleDuplicateCostCode = CostCode::checkDuplicateCostCode($database, $costCodeDivisionId, $costCodeNumber);
						}
						if($costCodeNumber == ''){
							$JsonValid = 1;
							$costCodeSpan = "<span class='circleRed floadCircle'></span>";
						} else if(isset($possibleDuplicateCostCode) && !empty($possibleDuplicateCostCode['id'])){

							$submittalRegistry = CostCode::checkDuplicateCostCodeSR($database, $possibleDuplicateCostCode['id']);
							if(isset($submittalRegistry) && !empty($submittalRegistry['id'])){
								$JsonValid = 1;
	 					  		$costCodeSpan = "<span class='circleBlack floadCircle'></span>";
							}else{
								$costCodeSpan = $submittalRegistry['id'];
							}
							
						}else{
							$JsonValid = 1;
	 					  $costCodeSpan = "<span class='circleBlack floadCircle'></span> <span class='circleBlack floadCircle'></span>";
						}
						$costCodeData .="<li $width>$costCodeNumberCC $costCodeSpan </li>";
					}

					$specificationNumberSpan = '';
					if($specificationNumberField){
						$specificationNumberColumn = $specificationNumberField - 1;
						$specificationNumber = $costCodeArray[$indexCom]['division'] = $sheet->getCellByColumnAndRow($specificationNumberColumn,$costCodei)->getFormattedValue();
						if($specificationNumber == ''){
							$JsonValid = 1;
							$specificationNumberSpan = "<span class='circleRed floadCircle'></span>";
						}
						$costCodeData .= "<li $width>$specificationNumber $specificationNumberSpan</li>";
					}

					$submittalTitleSpan = '';
					if($submittalTitleField){
						$submittalTitleColumn = $submittalTitleField - 1;
						$submittalTitle = $costCodeArray[$indexCom]['cost_code_description'] = $sheet->getCellByColumnAndRow($submittalTitleColumn,$costCodei)->getFormattedValue();
						if($submittalTitle == ''){
							$JsonValid = 1;
							$submittalTitleSpan = "<span class='circleRed floadCircle'></span>";
						}
						$costCodeData .= "<li $width>$submittalTitle $submittalTitleSpan</li>";
					}

				  if($submittalNotesField){
						$costCodeDescriptionAbbreviationColumn = $submittalNotesField - 1;
						$costCodeAbbreviation = $costCodeArray[$indexCom]['cost_code_description_abbreviation'] = $sheet->getCellByColumnAndRow($costCodeDescriptionAbbreviationColumn,$costCodei)->getFormattedValue();
						$costCodeData .= "<li $width>$costCodeAbbreviation</li>";
					}

					$costCodeTableDataIn++;
          $costCodeTableDataDiv.="<ul>
					   $costCodeData
					</ul>";
				}
				if(count($costCodeArray) == 0){
					$costCodeTableDataDiv .= "<ul><li>No records found</li></ul>";
				}
        		$costCodeUl .= "<div class='borderBottom'>
						<ul class='table-headerinner'>
						 <li class='textAlignLeft'>Cost Code List</li>
						</ul>
						<ul align='left' class='t-head'>
						 $costCodeHeaders
						</ul>
					 </div>
						 $costCodeTableDataDiv
					 </div>
					</ul>
				</div>";
				$costCodeTableData .= <<<END_HTML_CONTENT
				  $costCodeUl
				 <button style="float:left;margin:15px 0;" class="btn-cmn" onclick="gotoStepTwo()">Back</button>
				 <button style="float:right;margin:15px 0;" class="btn-cmn" id="importButton"
onclick="importCostCodeExcel($divisionNumberField,$costCodeNumberField,$specificationNumberField,$submittalTitleField,$submittalNotesField)">Import</button>
END_HTML_CONTENT;
        $table .= $importHints;
				$table .= $costCodeTableData;
				$table;
				$json_encode = array(
					'data' => $table,
					'invalid' => $JsonValid
				);
				echo json_encode($json_encode);
			}else{
				$errorNumber = 1;
				$errorMessage = 'File not exists';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}
		} catch(Exception $e){
			$errorNumber = 1;
		}
  	break;
  	case 'uploadCostCodeSubmittalRegistry':
		$errorNumber = 0;
		$errorMessage = '';
		$filePath = $get->filePath;
		$divisionNumberField = (int) $get->divisionNumber;
		$costCodeNumberField = (int) $get->costcodeNumber;
		$specificationNumberField = (int) $get->specificationNumber;
		$submittalTitleField = (int) $get->submittalTitle;
		$submittalNotesField = (int) $get->submittalNotes;

		$JsonValid = 0;

		try{
			$valid = file_exists($filePath);
			if($valid){
				$db = DBI::getInstance($database);
				/* @var $db DBI_mysqli */
				$db->throwExceptionOnDbError = true;
				$message->reset($currentPhpScript);

				$objPHPExcel = PHPExcel_IOFactory::load($filePath);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				$costCodeAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$arrayCount = count($costCodeAllDataInSheet);
				$costCodeArray = array();

				$sheet = $objPHPExcel->getActiveSheet();
				$highestRow = $sheet->getHighestDataRow();
				$highestColumn = $sheet->getHighestDataColumn();

				$delimiters = ['-', '_', '.', ':', ' '];
				/*Cost code information*/
				for($costCodei = 3; $costCodei <= $arrayCount; $costCodei++){
					$tableYes = 0;
					$rowData = $sheet->rangeToArray('A' . $costCodei . ':' . $highestColumn . $costCodei,NULL,TRUE,FALSE);

					if(isEmptyRow(reset($rowData))) {
						 continue;
					}
					$divisonNumber = $divisonHeadingNumber = $costCode = $specificationNumber = $submittalTitle = $submittalNotes = '' ;
					if($costCodeNumberField){
						$divisonNumberColumn = $costCodeNumberField-1;
						$divisonNumberCC = $sheet->getCellByColumnAndRow($divisonNumberColumn,$costCodei)->getFormattedValue();
						$divisonNumberS = str_replace($delimiters,"-", $divisonNumberCC);
						$divisonNumber= explode("-", $divisonNumberS)[0];
						$indexCom = $divisonNumber;
						$costCodeArray[$indexCom]['division_number'] = $divisonNumber;
					}

					$costCodeArray[$indexCom]['cost_code_type_id'] = 5;
					$costCodeTypeId = 5;

					if($specificationNumberField){
						$specificationNumberColumn = $specificationNumberField-1;
						$specificationNumber = $costCodeArray[$indexCom]['specification_Number'] = $sheet->getCellByColumnAndRow($specificationNumberColumn,$costCodei)->getFormattedValue();
					}

					if($costCodeNumberField){
						$costCodeNumberColumn = $costCodeNumberField - 1;
						$costCodeNumberCC = $costCodeArray[$indexCom]['cost_code'] = $sheet->getCellByColumnAndRow($costCodeNumberColumn,$costCodei)->getFormattedValue();
						$costCodeNumberS = str_replace($delimiters,"-", $costCodeNumberCC);
						$costCodeNumber = explode("-", $costCodeNumberS)[1];
					}

					if($submittalTitleField){
						$submittalTitleColumn = $submittalTitleField - 1;
						$submittalTitle = $costCodeArray[$indexCom]['submittal_title'] = $sheet->getCellByColumnAndRow($submittalTitleColumn,$costCodei)->getFormattedValue();
					}

					if($submittalNotesField){
						$submittalNotesColumn = $submittalNotesField - 1;
						$submittalNotes = $costCodeArray[$indexCom]['submittal_notes'] = $sheet->getCellByColumnAndRow($submittalNotesColumn,$costCodei)->getFormattedValue();
					}					

					
					$costCodeArray[$indexCom]['cost_code_type_id'] = 5;

					$costCodeTypeId = 5;
	        		$possibleDuplicateCostCodeDivision = CostCodeDivision::checkDuplicateCostCodeDivision($database, $user_company_id, $costCodeTypeId, $divisonNumber);

		      		if(isset($possibleDuplicateCostCodeDivision) && !empty($possibleDuplicateCostCodeDivision['id'])){
						$costCodeDivisionId = $possibleDuplicateCostCodeDivision['id'];
						$possibleDuplicateCostCode = CostCode::checkDuplicateCostCode($database, $costCodeDivisionId, $costCodeNumber);						
					}

					if(isset($possibleDuplicateCostCode) && !empty($possibleDuplicateCostCode['id'])){
						$costCodeId = $possibleDuplicateCostCode['id'];

						$httpGetInputData['su_spec_no'] = $specificationNumber;
						$httpGetInputData['submittal_type_id'] = 1;
						$httpGetInputData['submittal_status_id'] = 5;
						$httpGetInputData['submittal_priority_id'] = 1;
						$httpGetInputData['submittal_distribution_method_id'] = 1;
						$httpGetInputData['su_cost_code_id'] = $costCodeId;
						$httpGetInputData['su_title'] = $submittalTitle;
						$httpGetInputData['su_statement'] = $submittalNotes;


						// to include contracting entity
						$entityId = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);
						$httpGetInputData['contracting_entity_id']=$entityId;

						$submittal = new SubmittalRegistry($database);

						$submittal->setData($httpGetInputData);
						$submittal->convertDataToProperties();


						$submittal->project_id = $project_id;
						$submittal->su_creator_contact_id = $currentlyActiveContactId;

						// Begin total hacks.
						$suCreatorContact = Contact::findContactByIdExtended($database, $currentlyActiveContactId);
						$suCreatorContactCompany = $suCreatorContact->getContactCompany();
						$su_creator_contact_company_id = $suCreatorContactCompany->contact_company_id;
						$arrSuCreatorContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $su_creator_contact_company_id);
						$hqFlagIndex = 0;
						foreach ($arrSuCreatorContactCompanyOffices as $i => $suCreatorContactCompanyOffice) {
							/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
							$head_quarters_flag = $suCreatorContactCompanyOffice->head_quarters_flag;
							if ($head_quarters_flag == 'Y') {
								$hqFlagIndex = $i;
								continue;
							}
						}
						$su_creator_contact_company_office_id = $arrSuCreatorContactCompanyOffices[$hqFlagIndex]->contact_company_office_id;
						$submittal->su_creator_contact_company_office_id = $su_creator_contact_company_office_id;


						$su_recipient_contact_company_office_id = $arrSuRecipientContactCompanyOffices[$hqFlagIndex]->contact_company_office_id;
						$submittal->su_recipient_contact_company_office_id = $su_recipient_contact_company_office_id;


						$nextSuSequenceNumber = SubmittalRegistry::findNextSubmittalSequenceNumber($database, $project_id);
						$nextSuSequenceNumber = str_pad($nextSuSequenceNumber, 3, 0, STR_PAD_LEFT);
						$submittal->su_sequence_number = $nextSuSequenceNumber;


						$submittal->convertPropertiesToData();
						$data = $submittal->getData();

						// Test for existence via standard findByUniqueIndex method
						$submittal->findByUniqueIndex();
						if ($submittal->isDataLoaded()) {
				// Error code here
							$errorMessage = 'Submittal Registry already exists.';
							$message->enqueueError($errorMessage, $currentPhpScript);
							$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
							throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
						} else {
							$submittal->setKey(null);
							$data['created'] = null;
							$submittal->setData($data);
						}

						$submittal_id = $submittal->save();


						// save notification
			$su_recipient_contact_id = $submittal->su_recipient_contact_id;
			$su_title = $submittal->su_title;
			$contact = Contact::findById($database, $su_recipient_contact_id);
			/* @var $contact Contact */

			$user_notification_user_id = $contact->user_id;
			// get ActionItemType 
			$action_item_type = 'Submittal';
			$actionItemType = ActionItemType::findByActionItemType($database, $action_item_type);
			$action_item_type_id = null;
			if (isset($actionItemType) && !empty($actionItemType)) {
				$action_item_type_id = $actionItemType->action_item_type_id;
			}
			
			
			// get the device Token using ids
			$userDeviceInfoFcmToken = UsersDeviceInfo::findByIdUsingUserId($database, $user_notification_user_id);
			if($userDeviceInfoFcmToken != null) {
				$arrFcmToken  = $userDeviceInfoFcmToken;
			}
			if(isset($arrFcmToken) && !empty($arrFcmToken)){
				$user = User::findById($database, $user_notification_user_id);
				$user->currentlySelectedProjectUserCompanyId = $currentlySelectedProjectUserCompanyId;
				$user->currentlyActiveContactId = $su_recipient_contact_id;
				
				/* @var $contact User */
				
				$checkPermissionTaskSummary = checkPermissionTaskSummary($database, $user, $project_id);
				/* check permission to view tasksummary */
				
				/* get action item*/
				$title = $action_item_type;
				// $bodyContent = 'You have new task to visit';
				$bodyContent = $su_title;
				$bodyContent = strlen($bodyContent) > 50 ? substr($bodyContent,0,50). "... Read More" : $bodyContent;
				$options = array();
				$options['task'] = $title;
				$options['project_id'] = $project_id;
				$options['project_name'] = $project_name;
				$options['task_id'] = $submittal_id;
				$options['task_title'] = $su_title;
				$options['navigate'] = $checkPermissionTaskSummary;
				$fcm_notification = send_notification($database, $arrFcmToken, $title, $bodyContent, $options);
			}
			
			if (isset($submittal_id) && !empty($submittal_id)) {
				$submittal->submittal_id = $submittal_id;
				$submittal->setId($submittal_id);
			}
			// $submittal->save();

			$submittal->convertDataToProperties();
			$primaryKeyAsString = $submittal->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal Registry.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}
					}
				}
				$errorNumber = 0;
				unlink($filePath);
			}else{
				$errorNumber = 1;
				$errorMessage = 'File not exists';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}
			echo $errorNumber;
		} catch(Exception $e){
			$errorNumber = 1;
		}
	break;
	case 'uploadCostCode':
		$errorNumber = 0;
		$errorMessage = '';
		$filePath = $get->filePath;
		$divisionNumberField = (int) $get->divisionNumber;
		$costCodeNumberField = (int) $get->costcodeNumber;
		$divisionHeadingNumberField = (int) $get->divisionHeadingNumber;
		$divisionNameField = (int) $get->divisionName;
		$costCodeDescriptionField = (int) $get->costCodeDescription;
		$costCodeDescriptionAbbreviationField = (int) $get->costCodeDescriptionAbbreviation;
		$divisionAbbreviationField = (int) $get->divisionAbbreviation;
		$JsonValid = 0;

		try{
			$valid = file_exists($filePath);
			if($valid){
				$db = DBI::getInstance($database);
				/* @var $db DBI_mysqli */
				$db->throwExceptionOnDbError = true;
				$message->reset($currentPhpScript);

				$objPHPExcel = PHPExcel_IOFactory::load($filePath);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				$costCodeAllDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$arrayCount = count($costCodeAllDataInSheet);
				$costCodeArray = array();

				$sheet = $objPHPExcel->getActiveSheet();
				$highestRow = $sheet->getHighestDataRow();
				$highestColumn = $sheet->getHighestDataColumn();
				/*Cost code information*/
				for($costCodei = 3; $costCodei <= $arrayCount; $costCodei++){
					$tableYes = 0;
					$rowData = $sheet->rangeToArray('A' . $costCodei . ':' . $highestColumn . $costCodei,NULL,TRUE,FALSE);

					if(isEmptyRow(reset($rowData))) {
						 continue;
					}
					$divisonNumber = $divisonHeadingNumber = $costCode = $divisionName = $divisionAbbreviation = $costCodeDescription = $costCodeAbbreviation = '' ;
					if($divisionNumberField){
						$divisonNumberColumn = $divisionNumberField-1;
						$divisonNumber = $sheet->getCellByColumnAndRow($divisonNumberColumn,$costCodei)->getFormattedValue();
						$indexCom = $divisonNumber;
						$costCodeArray[$indexCom]['division_number'] = $divisonNumber;
					}

					$costCodeArray[$indexCom]['cost_code_type_id'] = 5;
					$costCodeTypeId = 5;

					if($divisionHeadingNumberField){
						$divisionHeadingNumberColumn = $divisionHeadingNumberField-1;
						$divisonHeadingNumber = $costCodeArray[$indexCom]['division_code_heading'] = $sheet->getCellByColumnAndRow($divisionHeadingNumberColumn,$costCodei)->getFormattedValue();
					}

					if($costCodeNumberField){
						$costCodeNumberColumn = $costCodeNumberField - 1;
						$costCodeNumber = $costCodeArray[$indexCom]['cost_code'] = $sheet->getCellByColumnAndRow($costCodeNumberColumn,$costCodei)->getFormattedValue();
					}

					if($divisionNameField){
						$divisionNameColumn = $divisionNameField - 1;
						$divisionName = $costCodeArray[$indexCom]['division'] = $sheet->getCellByColumnAndRow($divisionNameColumn,$costCodei)->getFormattedValue();
					}

					if($divisionAbbreviationField){
						$divisionAbbreviationColumn = $divisionAbbreviationField - 1;
						$divisionAbbreviation = $costCodeArray[$indexCom]['division_abbreviation'] = $sheet->getCellByColumnAndRow($divisionAbbreviationColumn,$costCodei)->getFormattedValue();
					}

					if($costCodeDescriptionField){
						$costCodeDescriptionColumn = $costCodeDescriptionField - 1;
						$costCodeDescription = $costCodeArray[$indexCom]['cost_code_description'] = $sheet->getCellByColumnAndRow($costCodeDescriptionColumn,$costCodei)->getFormattedValue();
					}

					if($costCodeDescriptionAbbreviationField){
						$costCodeDescriptionAbbreviationColumn = $costCodeDescriptionAbbreviationField - 1;
						$costCodeAbbreviation = $costCodeArray[$indexCom]['cost_code_description_abbreviation'] = $sheet->getCellByColumnAndRow($costCodeDescriptionAbbreviationColumn,$costCodei)->getFormattedValue();
					}

					$costCodeArray[$indexCom]['cost_code_type_id'] = 5;

					$costCodeTypeId = 5;
	        		$possibleDuplicateCostCodeDivision = CostCodeDivision::checkDuplicateCostCodeDivision($database, $user_company_id, $costCodeTypeId, $divisonNumber);

		      		if(isset($possibleDuplicateCostCodeDivision) && !empty($possibleDuplicateCostCodeDivision['id'])){
						$costCodeDivisionId = $possibleDuplicateCostCodeDivision['id'];
						$possibleDuplicateCostCode = CostCode::checkDuplicateCostCode($database, $costCodeDivisionId, $costCodeNumber);
						$updateCostCodeDivision = CostCodeDivision::updateCostCodeDivision($database, $divisonNumber, $divisonHeadingNumber, $divisionName, $divisionAbbreviation, $costCodeDivisionId);
					}else{
						$costCodeDivisionId = CostCodeDivision::addCostCodeDivision($database, $user_company_id, $costCodeTypeId, $divisonNumber, $divisonHeadingNumber,
							 $divisionName, $divisionAbbreviation);
					}

					if(isset($possibleDuplicateCostCode) && !empty($possibleDuplicateCostCode['id'])){
						$costCodeId = $possibleDuplicateCostCode['id'];
					}else{
						$costCodeId = CostCode::addCostCode($database, $user_company_id, $costCodeDivisionId, $costCodeNumber, $costCodeDescription, $costCodeAbbreviation);
					}
				}
				$errorNumber = 0;
				unlink($filePath);
			}else{
				$errorNumber = 1;
				$errorMessage = 'File not exists';
				$message->enqueueError($errorMessage, $currentPhpScript);
			}
			echo $errorNumber;
		} catch(Exception $e){
			$errorNumber = 1;
		}
	break;
	case 'deleteCostCodeFile':
		try{
			$deletePath = $get->filePath;
			unlink($deletePath);
		}
		catch(Exception $e){
			// Be sure to get the exception error message when Global Admin debug mode.
			$message->outputErrorMessages();
			exit;
		}
	break;
	case 'updateCostCodeDivider':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';
		$htmlRecordOption = '';
		$htmlRecordTr = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the CostCodeDivision record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}
			$divider_id = (int) $get->divider_id;
		  	$costCodeDividerForUserCompany = CostCodeDividerForUserCompany::findCostCodeDividerForUserCompanyById($database, $user_company_id);

			if($costCodeDividerForUserCompany){
				$data = array('divider_id' => $divider_id);
			}else{
				$costCodeDividerForUserCompany = new CostCodeDividerForUserCompany($database);

				$costCodeDividerForUserCompany->setData($httpGetInputData);
				$costCodeDividerForUserCompany->convertDataToProperties();

				$costCodeDividerForUserCompany->user_company_id = $user_company_id;
				$costCodeDividerForUserCompany->convertPropertiesToData();
				$data = $costCodeDividerForUserCompany->getData();
				$costCodeDividerForUserCompany->setKey(null);
			}
			$costCodeDividerForUserCompany->setData($data);
			$cost_code_divider_id = $costCodeDividerForUserCompany->save();
			if (isset($cost_code_divider_id) && !empty($cost_code_divider_id)) {
				$costCodeDividerForUserCompany->$cost_code_divider_id = $cost_code_divider_id;
				$costCodeDividerForUserCompany->setId($cost_code_divider_id);
			}

			$costCodeDividerForUserCompany->convertDataToProperties();
			$primaryKeyAsString = $costCodeDividerForUserCompany->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Cost Code Divider.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($costCodeDivision) && $costCodeDivision instanceof CostCodeDividerForUserCompany) {
				$primaryKeyAsString = $costCodeDivision->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'setSignaturedata':
		$crudOperation = 'load';
		$errorNumber = 0;
		$errorMessage = '';
		$primaryKeyAsString = '';
		$htmlContent = '';
		try {
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			$htmlContent = LoadEsignaturecontents($database, $project_id);

		} catch(Exception $e) {
			$db->rollback();
			$db->free_result();
			$errorNumber = 1;
		}

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;
	
	break;

	case 'updateIsSubtotal':
		$is_subtotal = $get->is_subtotal;
		TableService::UpdateTabularData($database,'projects','is_subtotal',$project_id,$is_subtotal);
	break;
}

$htmlOutput = ob_get_clean();
echo $htmlOutput;
ob_flush();

exit;

} catch (Exception $e) {
	$error->outputErrorMessages();
	exit;
}
