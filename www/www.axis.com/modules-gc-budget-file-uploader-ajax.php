<?php
/**
 * Ajax file uploader.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');

require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/Log.php');

// LOGGING UPLOAD TIME TO THE BACKEND FILE DATABASE
$timer->startTimer();
$_SESSION['timer'] = $timer;

// MESSAGING VARIABLES
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

/* @var $get Egpcs */
$get->sessionClear();

// SESSION VARIABLES
/* @var $session Session */
$session->setFormSubmitted(true);
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();

// Debug
//$ajaxError = json_encode(array('error' => '$get:'."\n".print_r($get, true) . "\n\n" . '$_SERVER:'."\n".print_r($_SERVER, true)));
//exit($ajaxError);

// Debug
//$_SERVER['HTTP_X_FILE_NAME'] = 'Sunset.jpg';
//$_SERVER['CONTENT_LENGTH'] = '105542';
//$get->folder_id = 2;

// GET VARIABLES
$project_id = $get->project_id;
$file_manager_folder_id = $get->folder_id;
$virtual_file_path = $get->virtual_file_path;
$virtual_file_name = $get->virtual_file_name;
$allowed_extensions = $get->allowed_extensions;
$methodCall = $get->method;

$folder_id_exists = false;
if (isset($file_manager_folder_id) && !empty($file_manager_folder_id)) {
	$folder_id_exists = true;
}

$project_id_and_virtual_file_path_exists = false;
if (isset($virtual_file_path) && !empty($virtual_file_path) && isset($project_id) && !empty($project_id)) {
	$project_id_and_virtual_file_path_exists = true;
}

if (($folder_id_exists == false) && ($project_id_and_virtual_file_path_exists == false)) {
	// Output an error
	$arrError = array(
		'error'=> 'An error occurred while uploading the file.'
	);
	$ajaxError = json_encode($arrError);
	exit($ajaxError);

	// Debug with bad characters
	/*
	$ajaxError = json_encode(array('error'=> "Missing folder_id's \"value\" for @copy; @amp;<form name=\"test\">blah</form> \\// |.\n\n" .
		print_r($get, true) . "\n\n" .
		print_r($_SERVER, true)));
	exit($ajaxError);
	*/
}

$arrFiles = File::parseUploadedFiles();
if (empty($arrFiles)) {
	$message->enqueueError('Please upload a valid file.', $currentPhpScript);
}

// Debug
//$ajaxError = json_encode(array('error'=> "folder_id: $file_manager_folder_id\nproject_id: $project_id\nUploaded File Name: $uploadedFileName\nUploaded File Size:$uploadedFileSize"));
//exit($ajaxError);

$error = $message->getQueue($currentPhpScript, 'error');
if (isset($error) && !empty($error)) {

	$mode = $config->system->operational_mode;
	if ((isset($debugMode) && $debugMode) || (isset($mode) && ($mode == 'debug'))) {

		// Debug settings.
		$errorMessage = print_r($error, true);
		$arrError = array(
			'error' => $errorMessage
		);
		//$arrError = array('error' => "Please upload a valid file.\n\n" . print_r($get, true) . "\n\n" . print_r($_SERVER, true));
		$ajaxError = json_encode($arrError);
		exit($ajaxError);

	} else {

		// Production settings.
		$arrError = array(
			'error' => 'Please upload a valid file.'
		);
		$ajaxError = json_encode($arrError);
		exit($ajaxError);

	}

} else {
	/**
	 * $_FILES uploaded via forms
	 *
	 * <form enctype="multipart/form-data" name="frm_name" action="form-submit.php" method="post">
	 * <input type="hidden" name="MAX_FILE_SIZE" value="2147483647">
	 * <input type="file" name="picture" tabindex="123">
	 */
	if (!empty($arrFiles)) {

		$htmlElementId = $get->id;
		if (
			isset($methodCall) && (($methodCall == 'unsignedFinalSubcontract') || ($methodCall == 'signedFinalSubcontract') || ($methodCall == 'unsignedSubcontractDocument') || ($methodCall == 'signedSubcontractDocument')) && isset($htmlElementId)) {

			$virtual_file_name = urldecode($virtual_file_name);

			// id="unsigned_subcontract_document_upload_'.$subcontract_id.'_'.
			//     $subcontracted_contact_company_id.'_'.$subcontract_item_template_id.'_'.$cost_code_division_id.'_'.$cost_code_id.'"
			// id="unsigned_subcontract_document_upload_'.$subcontract_id.'_'.$subcontract_item_template_id.'"
			if (($methodCall == 'unsignedSubcontractDocument') || ($methodCall == 'signedSubcontractDocument')) {
				if ($methodCall == 'unsignedSubcontractDocument') {
					$subcontractDocumentIdValues = str_replace('unsigned_subcontract_document_upload_', '', $htmlElementId);
				} elseif ($methodCall == 'signedSubcontractDocument') {
					$subcontractDocumentIdValues = str_replace('signed_subcontract_document_upload_', '', $htmlElementId);
				}

				$arrSubcontractDocumentIdValues = explode('_', $subcontractDocumentIdValues);

				$subcontract_id = $arrSubcontractDocumentIdValues[0];
				$subcontract_item_template_id = $arrSubcontractDocumentIdValues[1];

				require_once('lib/common/SubcontractItemTemplate.php');
				$subcontractItemTemplate = SubcontractItemTemplate::findById($database, $subcontract_item_template_id);
				/* @var $subcontractItemTemplate SubcontractItemTemplate */

				require_once('lib/common/SubcontractDocument.php');
				$subcontractDocument = SubcontractDocument::findBySubcontractIdAndSubcontractItemTemplateId($database, $subcontract_id, $subcontract_item_template_id);
				if ($subcontractDocument) {
					$subcontractDocumentExists = true;
				} else {
					$subcontractDocumentExists = false;
					$subcontractDocument = new SubcontractDocument($database);
				}
				/* @var $subcontractDocument SubcontractDocument */
			}

			if (($methodCall == 'unsignedFinalSubcontract') || ($methodCall == 'signedFinalSubcontract')) {
				if ($methodCall == 'unsignedFinalSubcontract') {
					$subcontractIdValues = str_replace('unsigned_subcontract_upload_', '', $htmlElementId);
				} elseif ($methodCall == 'signedFinalSubcontract') {
					$subcontractIdValues = str_replace('signed_subcontract_upload_', '', $htmlElementId);
				}

				$arrSubcontractIdValues = explode('_', $subcontractIdValues);

				$subcontract_id = $arrSubcontractIdValues[0];
				//$subcontract_item_template_id = $arrSubcontractIdValues[1];
			}

			// Debug
			//$ajaxError = json_encode(array('error' => '$arrSubcontractIdValues:'."\n".print_r($arrSubcontractIdValues, true)));
			//exit($ajaxError);

			require_once('lib/common/Subcontract.php');
			$subcontract = Subcontract::findById($database, $subcontract_id);
			if ($subcontract) {
				$subcontractExists = true;
			} else {
				$subcontractExists = false;
				$subcontract = new Subcontract($database);
			}
			/* @var $subcontract Subcontract */

			/*
			$subcontracted_contact_company_id = $arrSubcontractDocumentIdValues[1];
			$cost_code_division_id = $arrSubcontractDocumentIdValues[3];
			$cost_code_id = $arrSubcontractDocumentIdValues[4];

			require_once('lib/common/ContactCompany.php');
			$contactCompany = ContactCompany::findById($database, $subcontracted_contact_company_id);

			require_once('lib/common/CostCodeDivision.php');
			$costCodeDivision = CostCodeDivision::findById($database, $cost_code_division_id);

			require_once('lib/common/CostCode.php');
			$costCode = CostCode::findById($database, $cost_code_id);
			*/

			/* @var $contactCompany ContactCompany */
			/* @var $costCodeDivision CostCodeDivision */
			/* @var $costCode CostCode */

			/*
			$virtual_file_name =
				$currentlySelectedProjectName . ' : ' .
				$costCodeDivision->division_number . '-' . $costCode->cost_code . ' ' . $costCode->cost_code_description . ' : ' .
				$contactCompany->company . ' : ' .
				$subcontractItemTemplate->subcontract_item;
			*/
		}

		// Debug
		//$ajaxError = json_encode(array('error'=> "About to call File::parseUploadedFiles()."));
		//exit($ajaxError);

		if (isset($file_manager_folder_id) && !empty($file_manager_folder_id)) {
			// We we have a Folder id so we can ignore the virtual_file_path and project_id because they are derived from the file_manager_folder record
			$fileManagerFolder = FileManagerFolder::findById($database, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */

			$project_id = $fileManagerFolder->project_id;
			$virtual_file_path = $fileManagerFolder->virtual_file_path;

		} else {
			// No Folder ID was passed in, but we have project_id and virtualFilePath so we can get/create a FileManagerFolder
			// $project_id = $get->project_id   Which is guaranteed to exist at this point because of check at beginning of script
			// $virtual_file_path = $get->project_id   Which is guaranteed to exist at this point because of check at beginning of script

			// Save the root folder "/" to the database (if not done so already)
			$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, $project_id, '/');
			/* @var $fileManagerFolder FileManagerFolder */

			//$ajaxError = json_encode(array('error' => 'BLA2H'.$virtual_file_path . ' ' . $project_id));
			//exit($ajaxError);

			if ($virtual_file_path != '/') {
				// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
				$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
				$currentVirtualFilePath = '/';
				foreach ($arrFolders as $folder) {
					$tmpVirtualFilePath = array_shift($arrFolders);
					$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
					// Save the file_manager_folders record (virtual_file_path) to the db and get the id
					$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, $project_id, $currentVirtualFilePath);
					$newlycreated = $fileManagerFolder->getVirtualFilePathDidNotExist();
					if($newlycreated)
					{
						//To set the permission for all subfolders within daliy log
						$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;
						$parentFol= $fileManagerFolder->getParentFolderId();
						FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parentFol);
					}


				}
			}
			// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
			/* @var $fileManagerFolder FileManagerFolder */
			$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

			//$ajaxError = json_encode(array('error' => 'BLA2H'.$virtual_file_path . ' ' . $project_id . ' ' . $file_manager_folder_id));
			//exit($ajaxError);
		}

		$arrFileMetadata = array();
		foreach ($arrFiles as $file) {
			if (!isset($virtual_file_name) || empty($virtual_file_name)) {
				$virtual_file_name = rawurldecode($file->name);
			}
			$virtual_file_mime_type = $file->type;

			$file_location_id = FileManager::saveUploadedFileToCloud($database, $file);

			// File names include versioning via: `subcontractor_bid_documents`.`subcontractor_bid_document_sequence_number`
			if ($methodCall == 'subcontractorBidDocuments') {

				$arrTemp = explode('_', $get->id);
				$subcontractor_bid_id = Data::parseInt($get->subcontractor_bid_id);

				$company = '';
				$subcontractorBid = SubcontractorBid::findSubcontractorBidByIdExtended($database, $subcontractor_bid_id);
				/* @var $subcontractorBid SubcontractorBid */
				if ($subcontractorBid) {
					$subcontractorContactCompany = $subcontractorBid->getSubcontractorContactCompany();
					/* @var $subcontractorContactCompany ContactCompany */
					if ($subcontractorContactCompany) {
						$company = $subcontractorContactCompany->contact_company_name;
					}
				}

				$subcontractor_bid_document_type_id = $get->subcontractor_bid_document_type_id;
				$subcontractorBidDocumentType = SubcontractorBidDocumentType::findById($database, $subcontractor_bid_document_type_id);
				$subcontractor_bid_document_type = $subcontractorBidDocumentType->subcontractor_bid_document_type;
				$subcontractor_bid_document_sequence_number = SubcontractorBidDocument::findNextSubcontractorBidDocumentSequenceNumber($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id);

				// Filename format: "<company> - <subcontractor_bid_document_type> #<sequence_number>.pdf"
				$virtual_file_name = $company.' - '.$subcontractor_bid_document_type.' #'.$subcontractor_bid_document_sequence_number.'.pdf';

			} elseif ($methodCall == 'projectBidInvitations') {

				// Filename format: "<project_name> Bid Invitation #<sequence_number>.pdf"
				$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
				$project_bid_invitation_sequence_number = ProjectBidInvitation::findNextProjectBidInvitationSequenceNumber($database, $project_id);
				$virtual_file_name = $currentlySelectedProjectName.' - Bid Invitation #'.$project_bid_invitation_sequence_number.'.pdf';

			} elseif ($methodCall == 'gcBudgetLineItemUnsignedScopeOfWorkDocuments') {

				// Filename format: "<costCodeDescription> Scope Of Work #<sequence_number>.pdf"
				$arrTemp = explode('_', $get->id);
				$gc_budget_line_item_id = $arrTemp[1];
				$unsigned_scope_of_work_document_sequence_number = GcBudgetLineItemUnsignedScopeOfWorkDocument::findNextGcBudgetLineItemUnsignedScopeOfWorkDocumentSequenceNumber($database, $gc_budget_line_item_id);
				$virtual_file_name .= ' Scope Of Work #'.$unsigned_scope_of_work_document_sequence_number.'.pdf';

			}
			elseif ($methodCall == 'AdditionalSubcontractDocument') {
				
				$gc_budget_line_item_id = Data::parseInt($get->gc_budget_line_item_id);
				$sub_id =Data::parseInt($get->sub_id);
				$type_val =Data::parseInt($get->type_val);
				$tmp_file_name = urldecode($virtual_file_name);
				if($type_val =='2') //For prelims document
				{
					$today = date(' H:i:s');
					$virtual_file_name=$tmp_file_name.$today.'.pdf';
					
				}
				if($type_val =='1')//For additional document
				{
				$virtual_file_name=$tmp_file_name;
				}
			}
			elseif ($methodCall == 'InsuranceSubcontractDocument') {
				
				 $gc_budget_line_item_id = Data::parseInt($get->gc_budget_line_item_id);
				$subcontractid =Data::parseInt($get->subcontractid);
				$type_val =Data::parseInt($get->type_val);
				$field_name =(string)$get->field_name;
				$tmp_file_name = urldecode($virtual_file_name);
				$today = date('Y-m-d H:i:s');
				$virtual_file_name=$tmp_file_name;
			}

			// save the file information to the file_manager_files db table
			$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $user_company_id, $currentlyActiveContactId, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
			/* @var $fileManagerFile FileManagerFile */

			$file_manager_file_id = $fileManagerFile->file_manager_file_id;

			// Set Permissions of the file to match the parent folder.
			$parent_file_manager_folder_id = $fileManagerFolder->getParentFolderId();
			FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
			FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);


			$fileUrl = $fileManagerFile->generateUrl();

			$arrFileMetadata[] = array(
				'file_manager_folder_id' => $file_manager_folder_id,
				'virtual_file_path' => $fileManagerFolder->virtual_file_path,
				'file_manager_file_id' => $file_manager_file_id,
				'virtual_file_name' => $virtual_file_name,
				'virtual_file_mime_type' => $virtual_file_mime_type,
				'fileUrl' => $fileUrl
				//'virtual_file_path_sha1' => $fileManagerFolder->virtual_file_path_sha1,
				//'virtual_file_name_sha1' => $virtual_file_name_sha1,
			);

		}
	} else {
		$ajaxError = json_encode(array('error'=> 'File upload failed.'));
		exit($ajaxError);
	}

	switch ($methodCall) {
		case 'unsignedFinalSubcontract':
			$data = array('unsigned_subcontract_file_manager_file_id' => $file_manager_file_id);
			if (!$subcontractExists) {
				$data['gc_budget_line_item_id'] = $gc_budget_line_item_id;
				$data['subcontract_sequence_number'] = 1;
			}
			$subcontract->setData($data);
			$subcontract->save();
			break;

		case 'signedFinalSubcontract':
			$data = array('signed_subcontract_file_manager_file_id' => $file_manager_file_id);
			if (!$subcontractExists) {
				$data['gc_budget_line_item_id'] = $gc_budget_line_item_id;
				$data['subcontract_sequence_number'] = 1;
			}
			$subcontract->setData($data);
			$subcontract->save();
			break;

		case 'unsignedSubcontractDocument':
			$data = array('unsigned_subcontract_document_file_manager_file_id' => $file_manager_file_id);
			if (!$subcontractDocumentExists) {
				$data['subcontract_id'] = $subcontract_id;
				$data['subcontract_item_template_id'] = $subcontract_item_template_id;
			}
			$subcontractDocument->setData($data);
			$subcontractDocument->save();
			break;

		case 'AdditionalSubcontractDocument':
		if($type_val!=2){
		$db = DBI::getInstance($database);
		$query ="INSERT INTO `subcontractor_additional_documents` (`subcontractor_id`, `gc_budget_line_item_id`, `attachment_file_manager_file_id`,`type`)
VALUES ($sub_id, $gc_budget_line_item_id, $file_manager_file_id,$type_val)";

			$db->execute($query);
			$db->free_result();
		}
			break;

			case 'InsuranceSubcontractDocument':

			$db = DBI::getInstance($database);
			$query ="UPDATE  `subcontracts` set $field_name = $file_manager_file_id where id=$subcontractid";
			$db->execute($query);
			$db->free_result();
			break;

		case 'signedSubcontractDocument':
			$data = array('signed_subcontract_document_file_manager_file_id' => $file_manager_file_id);
			if (!$subcontractDocumentExists) {
				$data['subcontract_id'] = $subcontract_id;
				$data['subcontract_item_template_id'] = $subcontract_item_template_id;
			}
			$subcontractDocument->setData($data);
			$subcontractDocument->save();
			break;

		case 'projectBidInvitations':
			$db = DBI::getInstance($database);

			$query =
"
SELECT *
FROM `project_bid_invitations`
WHERE `project_id` = ?
AND `project_bid_invitation_file_manager_file_id` = ?
";
			$arrValues = array($project_id, $file_manager_file_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$insertRecord = true;
			while ($row = $db->fetch()) {
				$insertRecord = false;
				break;
			}
			$db->free_result();

			if ($insertRecord) {
				$query =
"
INSERT
INTO project_bid_invitations
(project_id, project_bid_invitation_file_manager_file_id, project_bid_invitation_sequence_number)
VALUES(?,?,?)
";
				$arrValues = array($project_id, $file_manager_file_id, $project_bid_invitation_sequence_number);
			} else {
				$query =
"
UPDATE project_bid_invitations
SET created = now()
WHERE project_id = ?
AND project_bid_invitation_file_manager_file_id = ?
";
				$arrValues = array($project_id, $file_manager_file_id);
			}

			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
			break;

		case 'gcBudgetLineItemUnsignedScopeOfWorkDocuments':
			$db = DBI::getInstance($database);

			$unsigned_scope_of_work_document_file_manager_file_id = $file_manager_file_id;

			$query =
"
INSERT IGNORE
INTO `gc_budget_line_item_unsigned_scope_of_work_documents` (`gc_budget_line_item_id`, `unsigned_scope_of_work_document_sequence_number`, `unsigned_scope_of_work_document_file_manager_file_id`)
VALUES(?,?,?)
";

			$arrValues = array($gc_budget_line_item_id, $unsigned_scope_of_work_document_sequence_number, $unsigned_scope_of_work_document_file_manager_file_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			break;

		case 'subcontractorBidDocuments':
			$db = DBI::getInstance($database);

			$subcontractor_bid_document_file_manager_file_id = $file_manager_file_id;

			$query =
"
INSERT
INTO `subcontractor_bid_documents` (`subcontractor_bid_id`, `subcontractor_bid_document_type_id`, `subcontractor_bid_document_sequence_number`, `subcontractor_bid_document_file_manager_file_id`)
VALUES (?,?,?,?)
";

			$arrValues = array($subcontractor_bid_id, $subcontractor_bid_document_type_id, $subcontractor_bid_document_sequence_number, $subcontractor_bid_document_file_manager_file_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			break;
	}

	// output a json_encoded() success message
	$arrOutput = array(
		'success'=> 'File upload successful.',
		'fileMetadata' => $arrFileMetadata
	);

	// output a json_encoded() success message
	$jsonOutput = json_encode($arrOutput);
	echo $jsonOutput;

	exit(0);
}
exit(0);
