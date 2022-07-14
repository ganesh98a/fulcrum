<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
//$init['post_maxlength'] = 100000;
//$init['post_required'] = true;
//$init['sapi'] = 'cli';
//$init['skip_always_include'] = true;
//$init['skip_session'] = true;
//$init['skip_templating'] = true;
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');
$timer->startTimer();
$_SESSION['timer'] = $timer;

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

require_once('lib/common/Message.php');
require_once('lib/common/Esign.php');

$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('modules-change-orders-functions.php');
require_once('image-resize-functions.php');

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewChangeOrders = $permissions->determineAccessToSoftwareModuleFunction('change_orders_view');
$userCanManageChangeOrders = $permissions->determineAccessToSoftwareModuleFunction('change_orders_manage');
*/

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {
	case 'ChangeOrders__loadCreateCoDialog':

		$crudOperation = 'load';
		$errorNumber = 0;
		$errorMessage = '';
		$primaryKeyAsString = '';
		$htmlContent = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			$project_id = (int) $get->currentlySelectedProjectId;
			$user_company_id = (int) $get->user_company_id;
			$currentlyActiveContactId = (int) $get->currentlyActiveContactId;
			$change_order_draft_id = (int) $get->change_order_draft_id;
			$subOrder = (int) $get->subOrder;

			if ($change_order_draft_id) {
				$findChangeOrderDraftByIdExtendedOptions = new Input();
				$findChangeOrderDraftByIdExtendedOptions->forceLoadFlag = true;
				$changeOrderDraft = ChangeOrderDraft::findChangeOrderDraftByIdExtended($database, $change_order_draft_id);
				$htmlContent = buildCreateCoDialog($database, $user_company_id, $project_id, $currentlyActiveContactId, null, $changeOrderDraft);
			} else {

				$htmlContent = buildCreateCoDialog($database, $user_company_id, $project_id, $currentlyActiveContactId,$subOrder);
			}

		} catch(Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Creation Form';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($changeOrderDraft) && $changeOrderDraft instanceof ChangeOrderDraft) {
				$primaryKeyAsString = $changeOrderDraft->getPrimaryKeyAsString();
			}
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

	case 'deleteCOFile':

			$file_id = Data::parseInt($get->file_id);
			$db = DBI::getInstance($database);

			$query_res = "DELETE  FROM change_order_attachments where co_attachment_file_manager_file_id ='$file_id'";
			if( $db->execute($query_res))
			{
			echo $jsonOutput = json_encode(array('status'=>'success'));
			}
	break;

	case 'projectOwnerCheck':

			$project =(int)$get->project;
			$database = DBI::getInstance();

			$project_owner_name = Project::getProjectOwner($database,$project);
			$project_owner_name = trim($project_owner_name);
			if($project_owner_name =="")
			{
				echo "1";
			}else
			{
				echo "0";
			}
			$db->free_result();

    break;


	case 'ChangeOrders__editCoDialog':

		$crudOperation = 'load';
		$errorNumber = 0;
		$errorMessage = '';
		$primaryKeyAsString = '';
		$htmlContent = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			$change_order_draft_id = (int) $get->change_order_draft_id;
			$changeOrder = (int) $get->changeOrder;
			$project_id = (int) $get->project_id;
			$user_company_id = (int) $get->user_company_id;
			if ($changeOrder) {
				$findChangeOrderDraftByIdExtendedOptions = new Input();
				$findChangeOrderDraftByIdExtendedOptions->forceLoadFlag = true;
				$changeOrderDraft = ChangeOrder::findChangeOrderByIdExtended($database, $changeOrder);

				$htmlContent = buildEditCoDialog($database, $user_company_id, $project_id, $currentlyActiveContactId, $changeOrderDraft);
			} else {

				$htmlContent = buildEditCoDialog($database, $user_company_id, $project_id, $currentlyActiveContactId,$changeOrder);
			}

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

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($changeOrderDraft) && $changeOrderDraft instanceof ChangeOrderDraft) {
				$primaryKeyAsString = $changeOrderDraft->getPrimaryKeyAsString();
			}
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

	case 'ChangeOrders__saveCoAsPdf':

		$errorNumber = 0;
		$errorMessage = '';

		try {

			// Check permissions - manage
			/*
			$userCanManageChangeOrders = $permissions->determineAccessToSoftwareModuleFunction('change_orders_manage');
			if (!$userCanManageChangeOrders) {
				// Error and exit
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Change Order data values.';
				$errorMessage = 'Error creating: Change Order.<br>Permission Denied.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
			*/

			// Temp files
			$arrGetData = $get->getData();
			$arrTempFiles = array();
			foreach ($arrGetData as $key => $value) {

				if (is_int(strpos($key, 'tempFileSha1'))) {

					$arrTmp = explode('_', $key);
					$tempFilePosition = $arrTmp[1];
					$tempFileSha1 = $value;
					$arrTempFiles[$tempFilePosition]['tempFileSha1'] = $tempFileSha1;

				} elseif (is_int(strpos($key, 'tempFilePath'))) {

					$arrTmp = explode('_', $key);
					$tempFilePosition = $arrTmp[1];
					$tempFilePath = $value;
					$arrTempFiles[$tempFilePosition]['tempFilePath'] = $tempFilePath;

				} elseif (is_int(strpos($key, 'tempFileName'))) {

					$arrTmp = explode('_', $key);
					$tempFilePosition = $arrTmp[1];
					$tempFileName = $value;
					$arrTempFiles[$tempFilePosition]['tempFileName'] = $tempFileName;

				} elseif (is_int(strpos($key, 'virtual_file_mime_type'))) {

					$arrTmp = explode('_', $key);
					$tempFilePosition = $arrTmp[4];
					$virtual_file_mime_type = $value;
					$arrTempFiles[$tempFilePosition]['virtual_file_mime_type'] = $virtual_file_mime_type;

				}

			}

			$change_order_id = Data::parseInt($get->change_order_id);
			$currentlySelectedProjectId = Data::parseInt($get->currentlySelectedProjectId);
			$user_company_id = Data::parseInt($get->user_company_id);

			// Sort files and save to cloud
			if (!empty($arrTempFiles)) {
				ksort($arrTempFiles);

				$datePrefix = date('Y-m-d H:i A');
				$datePrefix = "$datePrefix - ";

				$co_attachment_source_contact_id = $currentlyActiveContactId;

				$nextCoAttachmentSequenceNumber = ChangeOrderAttachment::findNextChangeOrderAttachmentSequenceNumber($database, $change_order_id);
				foreach ($arrTempFiles as $k => $tempFile) {
					$tempFileSha1 = $tempFile['tempFileSha1'];
					$tempFilePath = $tempFile['tempFilePath'];
					$tempFileName = $tempFile['tempFileName'];
					$virtual_file_mime_type = $tempFile['virtual_file_mime_type'];

					$virtual_file_name = $datePrefix . $virtual_file_name;


				}
			}

			$changeOrder = ChangeOrder::findById($database, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			
			//To fetch the data
			$query = "SELECT ct.`change_order_type`, ct.`abbreviation`, ct.`disabled_flag` FROM `change_orders` as co inner join  change_order_types as ct on co.change_order_type_id =ct.id  WHERE co.`id` = '$change_order_id' ";
			$db->execute($query);
			$row = $db->fetch();
			$abb = $row['abbreviation'];
			$db->free_result();
			if($abb == "COR")
			{
				$sequence =$changeOrder->co_type_prefix;	
			}else
			{				
				$sequence =$changeOrder->co_sequence_number;
			}

			// Change Order Attachments
			// The Change Order document is the Change Order pdf with all attachment appended into it.
			$loadChangeOrderAttachmentsByChangeOrderIdOptions = new Input();
			$loadChangeOrderAttachmentsByChangeOrderIdOptions->forceLoadFlag = true;
			$arrChangeOrderAttachmentsByChangeOrderId = ChangeOrderAttachment::loadChangeOrderAttachmentsByChangeOrderId($database, $change_order_id, $loadChangeOrderAttachmentsByChangeOrderIdOptions);

			// Folder
			// Save the file_manager_folders record (virtual_file_path) to the db and get the id
			$virtual_file_path = '/Change Orders/'.$abb.'/Change Order #' . $sequence . '/';

			// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			$currentVirtualFilePath = '/';
			foreach ($arrFolders as $folder) {
				$tmpVirtualFilePath = array_shift($arrFolders);
				$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
				// Save the file_manager_folders record (virtual_file_path) to the db and get the id

				$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, $currentlySelectedProjectId, $currentVirtualFilePath);
			}
			/* @var $fileManagerFolder FileManagerFolder */

			// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
			$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

			// Copy all pdf files to the server's local disk
			$config = Zend_Registry::get('config');
			$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
			$baseDirectory = $config->system->base_directory;
			$fileManagerBasePath = $config->system->file_manager_base_path;
			$fileManagerFileNamePrefix = $config->system->file_manager_file_name_prefix;
			$basePath = $fileManagerBasePath.'frontend/'.$user_company_id;
			$compressToDir = $fileManagerBasePath.'temp/'.$user_company_id.'/'.$currentlySelectedProjectId.'/';
			$urlDirectory = 'downloads/'.'temp/'.$user_company_id.'/'.$currentlySelectedProjectId.'/';
			$outputDirectory = $baseDirectory.'www/www.axis.com/'.$urlDirectory;

			$tempFileName = File::getTempFileName();
			$tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
			$fileObject = new File();
			$fileObject->mkdir($tempDir, 0777);

			// Copy over the Change Order Attachment files
			// Start with offset 2 to save 1 for the Change Order pdf itself
			$counter = 2;
			$skipOne = false;
			$arrPdfFiles = array();
			$pdfPageCount = 0;
			$arrCoAttachmentFileLocationIds = array();
			
			$fileAttachments    =   json_decode($arrGetData['attachmentsArr']);
			$change_order_id=$arrGetData['change_order_id'];
			$pdf_total_num =0;
			if(!empty($fileAttachments))
        {
        	$sortOrder = 0;
            foreach($fileAttachments as $fileAttachment)
            {
                $db = DBI::getInstance($database);  // Db Initialize
                $selectSql = "SELECT * FROM change_order_attachments WHERE  co_attachment_file_manager_file_id  = $fileAttachment and change_order_id = $change_order_id";
                $db->execute($selectSql);
                $row = $db->fetch();
                $db->free_result();
                if(empty($row)){                 
               	 	$db = DBI::getInstance($database);  // Db Initialize
               		$attachmentSql = "INSERT INTO change_order_attachments(co_attachment_file_manager_file_id,change_order_id,sort_order) VALUES('$fileAttachment','$change_order_id','$sortOrder')";
                	$db->execute($attachmentSql);
                	$db->free_result();
                }else
                {
                	// to change the sort order
                	$attachmentSql = "UPDATE  change_order_attachments set sort_order='$sortOrder' where co_attachment_file_manager_file_id ='$fileAttachment'";
               		$db->execute($attachmentSql);
                	$db->free_result();
                }
                $sortOrder++;
                $fileManagefile = FileManagerFile::findById($database, $fileAttachment);
                $oldData = $fileManagefile;
                $data = array(
                    'file_manager_folder_id' => $file_manager_folder_id
                );
                $fileManagefile->setData($data);
                $fileManagefile->save();    // Update the new folder
            

                // Filename extension
                $tempDelayAttachmentFileExtension = $fileManagefile->getFileExtension();
                $fileNamePrefix = str_pad($counter, 5, '0', STR_PAD_LEFT);
                $tempAttachmentFileName = $fileNamePrefix . '.' . $fileManagefile->file_manager_file_id . '.' . $tempDelayAttachmentFileExtension;
             $tempFilePath = $tempDir.$tempAttachmentFileName;
                // @todo Add png / image to pdf functionality
               $tempPdfFile = $tempAttachmentFileName;

                $file_location_id = $fileManagefile->file_location_id;
                $statusFlag = false;
                // move files from temp folder into virtual file path
                if (isset($file_location_id) && !empty($file_location_id)) 
                {
                    if ($file_manager_front_end_node_file_copy_protocol == 'FTP') {
                        $statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaFtp($fileManagefile, $tempFilePath, $file_location_id);
                    } elseif ($file_manager_front_end_node_file_copy_protocol == 'LocalFileSystem') {
                        $statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaLocalFileSystem($fileManagefile, $tempFilePath, $file_location_id);
                    }
                }
                /*attachment name array*/
                $PDFMergeFormatArray = array('0'=>'PDF','1'=>'pdf');
                if(in_array($tempDelayAttachmentFileExtension,$PDFMergeFormatArray)){
                if($statusFlag) {
                    
                $arrPdfFiles[] = $tempPdfFile;
                    //To get the page Count for pdf
                $pdf_page_file=$tempDir.$tempPdfFile;
                $cc= exec("identify -format %n $pdf_page_file");
                $pdf_total_num=$pdf_total_num+$cc;

                  //End to get the pdf page count
                }
                /*attachment name array*/
            }
            }
        }

        //For upload execute attachment
        $db = DBI::getInstance($database);
		$query1 = "SELECT change_order_status_id FROM `change_orders`   WHERE `id` = '$change_order_id' ";
		$db->execute($query1);
		$row1=$db->fetch();
		$costatus_id=$row1['change_order_status_id'];
		$db->free_result();

      
        $exeAttachments    =   json_decode($arrGetData['exe_attachmentsArr']);
        if($costatus_id == "2" ){   

        if(!empty($exeAttachments))
        {
        	$exsortorder =0;
            foreach($exeAttachments as $fileAttachment)
            {
                $db = DBI::getInstance($database);  // Db Initialize
                $selectSql = "SELECT * FROM change_order_attachments WHERE  co_attachment_file_manager_file_id  = $fileAttachment and change_order_id = $change_order_id";
                $db->execute($selectSql);
                $row = $db->fetch();
                $db->free_result();
                if(empty($row)){                 
                $db = DBI::getInstance($database);  // Db Initialize
               $attachmentSql = "INSERT INTO change_order_attachments(co_attachment_file_manager_file_id,change_order_id,upload_execute,sort_order) VALUES('$fileAttachment','$change_order_id','Y',$exsortorder)";
                $db->execute($attachmentSql);
                $db->free_result();
                }else
                {
                	 $attachmentSql = "UPDATE  change_order_attachments set sort_order=$exsortorder where co_attachment_file_manager_file_id =$fileAttachment";
               		 $db->execute($attachmentSql);
               		 $db->free_result();
                }
                $exsortorder++;
                $fileManagefile = FileManagerFile::findById($database, $fileAttachment);
                $oldData = $fileManagefile;
                $data = array(
                    'file_manager_folder_id' => $file_manager_folder_id
                );
                $fileManagefile->setData($data);
                $fileManagefile->save();    // Update the new folder
            

                // Filename extension
                $tempDelayAttachmentFileExtension = $fileManagefile->getFileExtension();
                $fileNamePrefix = str_pad($counter, 5, '0', STR_PAD_LEFT);
                $tempAttachmentFileName = $fileNamePrefix . '.' . $fileManagefile->file_manager_file_id . '.' . $tempDelayAttachmentFileExtension;
             $tempFilePath = $tempDir.$tempAttachmentFileName;
                // @todo Add png / image to pdf functionality
               $tempPdfFile = $tempAttachmentFileName;

                $file_location_id = $fileManagefile->file_location_id;
                $statusFlag = false;
                // move files from temp folder into virtual file path
                if (isset($file_location_id) && !empty($file_location_id)) 
                {
                    if ($file_manager_front_end_node_file_copy_protocol == 'FTP') {
                        $statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaFtp($fileManagefile, $tempFilePath, $file_location_id);
                    } elseif ($file_manager_front_end_node_file_copy_protocol == 'LocalFileSystem') {
                        $statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaLocalFileSystem($fileManagefile, $tempFilePath, $file_location_id);
                    }
                }
                /*attachment name array*/
                $PDFMergeFormatArray = array('0'=>'PDF','1'=>'pdf');
                if(in_array($tempDelayAttachmentFileExtension,$PDFMergeFormatArray)){
                if($statusFlag) {
                    
                $arrPdfFiles[] = $tempPdfFile;
                    //To get the page Count for pdf
                $pdf_page_file=$tempDir.$tempPdfFile;
                $cc= exec("identify -format %n $pdf_page_file");
                $pdf_total_num=$pdf_total_num+$cc;

                  //End to get the pdf page count
                }
                /*attachment name array*/
            }
            }
        }
    }else
    {
    	$db = DBI::getInstance($database);
		$query1 = "DELETE FROM `change_order_attachments`   WHERE `change_order_id` = '$change_order_id' and `upload_execute`='Y' ";
		$db->execute($query1);
		$db->free_result();
		
    }
         //END for  upload execute attachment


     
        //start of images
          /*GCLogo copy to temp path*/
        require_once('lib/common/Logo.php');
                /*config path get*/
        $config = Zend_Registry::get('config');
        $basedircs = $config->system->file_manager_base_path;
        $basepathcs = $config->system->file_manager_backend_storage_path ;
        $baseDirectory = $config->system->base_directory;
        

         /*validate dir*/
        $urlDirectory = 'downloads/'.'temp/';
        $outputDirectory = $baseDirectory.'www/www.axis.com/'.$urlDirectory;

        /*Mail Attach filelocation id*/
        $arrayMailAttach = array();
        $MailAttachFormatArray = array('0'=>'PDF','1'=>'pdf','2'=>'jpg','3'=>'jpeg','4'=>'png','5'=>'gif');
        /*Photo Add last in pdf format*/
        $pthotoAddFormatArray = array('0'=>'jpg','1'=>'jpeg','2'=>'png','3'=>'gif');
        /*photo addd array*/
        $photoAddPdf = array();
        $indexVal="";
        foreach($fileAttachments as $existAttach => $attachExist)
        {
          $fileManagefile = FileManagerFile::findById($database, $attachExist);
          $tempDelayAttachmentFileExtension = $fileManagefile->getFileExtension();
          if(!in_array($tempDelayAttachmentFileExtension,$MailAttachFormatArray))
          {
            $arrayMailAttach[$indexVal]['file_manager_file_id'] = $fileManagefile->file_manager_file_id;
            $arrayMailAttach[$indexVal]['virtual_file_name'] = $fileManagefile->virtual_file_name;

          }

            if(in_array($tempDelayAttachmentFileExtension,$pthotoAddFormatArray))
            {
                $photoAddPdf[$indexVal]['file_manager_file_id'] = $fileManagefile->file_manager_file_id;
                $photoAddPdf[$indexVal]['virtual_file_name'] = $fileManagefile->virtual_file_name;
            }
        $indexVal++;
        }

        $jobsitePhotoHtmlContents = '';
        $deleteTempPhoto = array();
        $count = count($photoAddPdf);
        foreach($photoAddPdf as $photoAttachPDf){
            $photoAttachPDfId = $photoAttachPDf['file_manager_file_id'];
            $photoAttachPDfIdName = $photoAttachPDf['virtual_file_name'];
            $fileManagerfile = FileManagerFile::findById($database, $photoAttachPDfId);


            $file_location_id = Data::parseInt($fileManagerfile->file_location_id);
            $arrPath = str_split($file_location_id, 2);
            $fileName = array_pop($arrPath);
            $shortFilePath = '';
            foreach ($arrPath as $pathChunk) {
                $path .= $pathChunk.'/';
                $shortFilePath .= $pathChunk.'/';
            }

            $filename=$basedircs.$basepathcs.$shortFilePath.$file_manager_file_name_prefix.'_'.$fileName;
                      /*Resize image start*/
           $jobsitePhotoUrlsize = $filename;
           $path= realpath($jobsitePhotoUrlsize);
            $tempFileNamePhoto = '_temp'.round(microtime(true)*1000);

            $destination = $outputDirectory.$tempFileNamePhoto;
            $finalViewPath = $urlDirectory.$tempFileNamePhoto;
            $deleteTempPhoto[] = $destination;
             // Change the desired "WIDTH" and "HEIGHT"
            $newWidth = 700; // Desired WIDTH
            $newHeight = 700; // Desired HEIGHT
            $info   = getimagesize($path);
            $mime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
            $width  = $info[0]; // width as integer for ex. 512
            $height = $info[1]; // height as integer for ex. 384
            $type   = $info[2];      // same as exif_imagetype
           
            if(intval($width) > 800 || intval($height) > 800){
            	resize($path,$destination,$newWidth,$newHeight);
            }else{
                resize($path,$destination,$width,$height);
            }
            $data = file_get_contents($destination);
            $base64 = 'data:image;base64,' . base64_encode($data);  
            $jobsitePhotoHtml = '<img alt="Jobsite Photo" align="center" src="'.$finalViewPath.'">';
       
            $jobsitePhotoHtmlContents.= <<<END_HTML_CONTENT
            <tr style="margin-bottom:10px 0;backgound:#f0f0f0;">
            <td style="padding: 0;text-align:center;" class="dcrPreviewImagecenter">
            <section style="margin: 10px 0;" class="dcrPreviewTableHeader">$photoAttachPDfIdName</section>
            $jobsitePhotoHtml</td>
            </tr>
END_HTML_CONTENT;
        }
        if($jobsitePhotoHtmlContents!='')
        {
            if($count > 0){
                $counthead="<h4>Attached Photos($count)</h4>";
            }else{
                $counthead='';
            }
            $jobsitePhotoHtmlContent = <<<HtmlPhos
            <div style="margin-bottom:5px;padding-bottom:0;">
            $counthead
            <table class="dcrPreviewTable" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:0;padding-bottom     :0;" >
            $jobsitePhotoHtmlContents
            </table>
            </div>
HtmlPhos;
        }else{
            $jobsitePhotoHtmlContent='';
        }
        //end of images
			// Build the HTML for the Change Order pdf document (html to pdf via DOMPDF)
			$htmlContent = buildCoAsHtmlForPdfConversion($database, $user_company_id, $change_order_id,$jobsitePhotoHtmlContent);
			$htmlContent = html_entity_decode($htmlContent);
			$htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");

			// sha1 of: co html + file_location_id list from co attachments
			// Generate sha1 hash of html to see if a new spread has been created
			// $csvCoAttachmentFileLocationIds = join(',', $arrCoAttachmentFileLocationIds);
			//$change_order_sha1 = sha1($htmlContent);

			// Take the sha1 of the Change Order pdf with the attachments appended
			// Check for existence of $bid_spreadsheet_data_sha1
			//$potentialDuplicateChangeOrder = ChangeOrder::findByChangeOrderSha1($database, $change_order_sha1);

			// @todo Finish sha1 at File Manager File level to support this
			$potentialDuplicateChangeOrder = false;

			// Check for data-level change via sha1 hash
			if ($potentialDuplicateChangeOrder) {
				// Use existing file_manager_file_id
				$co_file_manager_file_id = $potentialDuplicateChangeOrder->co_file_manager_file_id;
			}

			/**/
			// Write Change Order to temp folder as a pdf document
			$dompdf = new DOMPDF();
			$dompdf->load_html($htmlContent);
			//$dompdf->set_paper("letter", "landscape");
			$dompdf->set_paper("letter", "portrait");
			$dompdf->render();
			$pdf_content = $dompdf->output();

			// Filename of temporary co pdf file
			// co pdf file gets 1 in the list
			$tempPdfFile = '00001' . '.' . $tempFileName . '.pdf';
			$tempFilePath = $tempDir . $tempPdfFile;

			// Debug
			// copy the file to a temp file just like a standard file upload
			if (!isset($tempFilePath) || empty($tempFilePath)) {
				$tempFilePath = 'Q:/dev/build_advent/advent-sites/branches/development/www/www.axis.com/downloads/temp/co.pdf';
			}

			//$tempFileName = File::getTempFileName();
			//$tempFilePath = $tempDir.$tempFileName;
			file_put_contents ($tempFilePath, $pdf_content);
			/**/

			// Debug
			// Simulate having written the pdf to disk via dompdf
			//$tempPath = 'Q:/dev/build_advent/advent-sites/branches/development/www/www.axis.com/downloads/temp/co.pdf';
			//$pdf_content = file_get_contents($tempPath);

			if (!empty($arrPdfFiles)) {

				// Put the cover sheet first in the list
				array_unshift($arrPdfFiles, $tempPdfFile);

				$finalCoTempFileName = $tempFileName . '.pdf';
				$finalCoTempFilepath = $tempDir.$finalCoTempFileName;

				// Merge the Change Order pdf and all Change Order attachments into a single Change Order pdf document
				Pdf::merge($arrPdfFiles, $tempDir, $finalCoTempFileName);

				$tempFilePath = $finalCoTempFilepath;

			}
 			// To esign the merged PDF
			Esign::externalPDFEsign($tempFilePath,$tempDir,$finalCoTempFileName);
			// Debug.
			//exit;

			$sha1 = sha1_file($tempFilePath);
			$size = filesize($tempFilePath);
			$fileExtension = 'pdf';
			$virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);

			$query = "SELECT ct.`change_order_type`, ct.`abbreviation`, ct.`disabled_flag` FROM `change_orders` as co inner join  change_order_types as ct on co.change_order_type_id =ct.id  WHERE co.`id` = '$change_order_id' ";
			$db->execute($query);
			$row = $db->fetch();
			$abb = $row['abbreviation'];
			$db->free_result();
			if($abb == "COR")
			{
				$sequence =$changeOrder->co_type_prefix;
			}else
			{				
				$sequence =$changeOrder->co_sequence_number;
			}

			// Final Change Order pdf document
			$virtual_file_name_tmp = 'Change Order #' . $sequence . ' - ' . $changeOrder->co_title . '.pdf';
			$tmpFileManagerFile = new FileManagerFile($database);
			$tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
			$virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();

			// Convert file content to File object
			$error = null;

			$file = new File();
			$file->sha1 = $sha1;
			//$file->form_input_name = $formFileInputName;
			//$file->error = $error;
			$file->name = $virtual_file_name;
			$file->size = $size;
			//$file->tmp_name = $tmp_name;
			$file->type = $virtual_file_mime_type;
			$file->tempFilePath = $tempFilePath;
			$file->fileExtension = $fileExtension;

			//$arrFiles = File::parseUploadedFiles();
			$file_location_id = FileManager::saveUploadedFileToCloud($database, $file);

			// Rename file...for replace case???
			//$virtual_file_name = $file_type_name . " - Old (Uploaded " .$previous_date_added. ").pdf";

			// save the file information to the file_manager_files db table
			$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $user_company_id, $currentlyActiveContactId, $currentlySelectedProjectId, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
			/* @var $fileManagerFile FileManagerFile */

			$file_manager_file_id = $fileManagerFile->file_manager_file_id;

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
			

			// Update $changeOrder->co_file_manager_file_id
			$tmpData = $changeOrder->getData();
			$data = array(
				'co_file_manager_file_id' => $file_manager_file_id
			);
			$changeOrder->setData($data);
			$changeOrder->save();
			$tmpData['co_file_manager_file_id'] = $file_manager_file_id;
			$changeOrder->setData($tmpData);
			$changeOrder->co_file_manager_file_id = $file_manager_file_id;

			/*
			$existingData = $bidSpread->getData();
			if ($nextBidSpreadSequenceNumber > 1) {

				$bidSpread = new BidSpread($database);
				$bidSpread->gc_budget_line_item_id = $gc_budget_line_item_id;
				$bidSpread->bid_spread_sequence_number = $nextBidSpreadSequenceNumber;
				$bidSpread->bid_spreadsheet_data_sha1 = $bid_spreadsheet_data_sha1;
				$bidSpread->bid_spread_status_id = 1;
				if (isset($bid_spread_preferred_subcontractor_bid_id)) {
					$bidSpread->bid_spread_preferred_subcontractor_bid_id = $bid_spread_preferred_subcontractor_bid_id;
				}
				if (isset($bid_spread_preferred_subcontractor_contact_id)) {
					$bidSpread->bid_spread_preferred_subcontractor_contact_id = $bid_spread_preferred_subcontractor_contact_id;
				}
				$bidSpread->bid_spread_bid_total = $bid_spread_bid_total;
				$bidSpread->unsigned_bid_spread_pdf_file_manager_file_id = $file_manager_file_id;
				$bidSpread->convertPropertiesToData();
				$bidSpread['created'] = null;
				$bid_spread_id = $bidSpread->save();

			} else {

				$newData = array(
					'bid_spread_sequence_number' => $nextBidSpreadSequenceNumber,
					'bid_spreadsheet_data_sha1' => $bid_spreadsheet_data_sha1,
					'bid_spread_bid_total' => $bid_spread_bid_total,
					'unsigned_bid_spread_pdf_file_manager_file_id' => $file_manager_file_id,
				);
				if (isset($bid_spread_preferred_subcontractor_bid_id)) {
					$newData['bid_spread_preferred_subcontractor_bid_id'] = $bid_spread_preferred_subcontractor_bid_id;
				}
				if (isset($bid_spread_preferred_subcontractor_contact_id)) {
					$newData['bid_spread_preferred_subcontractor_contact_id'] = $bid_spread_preferred_subcontractor_contact_id;
				}
				$bidSpread->setData($newData);
				$bidSpread->save();

			}
			*/

			// Debug
			//exit;

			// Delete temp files
			$fileObject->rrmdir($tempDir);

			// Load PDF files list
			//$arrBidSpreadPdfFilenames =

			$virtual_file_name_url = $uri->cdn . '_' . $file_manager_file_id;
			$virtual_file_name_url_encoded = urlencode($virtual_file_name_url);

			// Debug
			$primaryKeyAsString = $change_order_id;

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Bid Spread.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
		} catch (Exception $e) {
			$db->rollback();

			$errorNumber = 1;
			//$errorMessage = 'Error creating: Bid Spread.';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			$primaryKeyAsString = '';

			// Delete temp files
			if (isset($tempDir) && !empty($tempDir) && is_dir($tempDir)) {
				$fileObject->rrmdir($tempDir);
			}
		}

	break;

	case 'ChangeOrders__sendCoEmail':

		// This assumes that all Change Order data is captured in the database and Cloud Filesystem
		$errorNumber = 0;
		$errorMessage = '';

		try {

			// Check permissions - manage
			/*
			$userCanManageChangeOrders = $permissions->determineAccessToSoftwareModuleFunction('change_orders_manage');
			if (!$userCanManageChangeOrders) {
				// Error and exit
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Change Order data values.';
				$errorMessage = 'Error creating: Change Order.<br>Permission Denied.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
			*/

			// Get primary key / unique key via get input
			$attributeGroupName = (string) $get->attributeGroupName;
			$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
			$attributeSubgroupName = (string) $get->attributeSubgroupName;
			$formattedAttributeSubgroupName = (string) $get->formattedAttributeSubgroupName;
			$change_order_id = (int) $get->change_order_id;
			$change_order_notification_id = (int) $get->change_order_notification_id;
			$emailBody = (string) $get->emailBody;

			// Use the active contact_id from the session as the current Change Order "Sendor" or SMTP "From"
			$sendor_contact_id = $currentlyActiveContactId;

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Change Order';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Change Orders';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$changeOrderNotification = ChangeOrderNotification::findChangeOrderNotificationByIdExtended($database, $change_order_notification_id);
			/* @var $changeOrderNotification ChangeOrderNotification */

			$change_order_id = $changeOrderNotification->change_order_id;
			if (!isset($change_order_id)) {
				$change_order_id = (int) $get->change_order_id;
			}

			$changeOrder = ChangeOrder::findChangeOrderByIdExtended($database, $change_order_id);
			//$changeOrder = $changeOrderNotification->getChangeOrder();
			/* @var $changeOrder ChangeOrder */
			$changeOrder->htmlEntityEscapeProperties();

			$project = $changeOrder->getProject();
			/* @var $project Project */
			$project->htmlEntityEscapeProperties();
			$formattedProjectName = $project->project_name . ' (' . $project->user_custom_project_id . ')';
			$formattedProjectNameHtmlEscaped = $project->escaped_project_name . ' (' . $project->escaped_user_custom_project_id . ')';

			$changeOrderType = $changeOrder->getChangeOrderType();
			/* @var $changeOrderType ChangeOrderType */

			$changeOrderStatus = $changeOrder->getChangeOrderStatus();
			/* @var $changeOrderStatus ChangeOrderStatus */

			$changeOrderPriority = $changeOrder->getChangeOrderPriority();
			/* @var $changeOrderPriority ChangeOrderPriority */

			// Cloud Filesystem File
			$coFileManagerFile = $changeOrder->getCoFileManagerFile();
			/* @var $coFileManagerFile FileManagerFile */
			$coFileManagerFile->htmlEntityEscapeProperties();

			$coCostCode = $changeOrder->getCoCostCode();
			/* @var $coCostCode CostCode */

			// Cost Code
			if ($coCostCode) {
				$formattedCoCostCode = $coCostCode->getFormattedCostCode($database,true, $user_company_id);
			} else {
				$formattedCoCostCode = '';
			}

			// Toggles back and forth
			// From:
			// To:
			$coCreatorContact = $changeOrder->getCoCreatorContact();
			/* @var $coCreatorContact Contact */

			$coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
			/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */

			$coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
			/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
			/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
			/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

			// Toggles back and forth
			// From:
			// To:
			$coRecipientContact = $changeOrder->getCoRecipientContact();
			/* @var $coRecipientContact Contact */

			$coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
			/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */

			$coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
			/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
			/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
			/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */

			$coInitiatorContact = $changeOrder->getCoInitiatorContact();
			/* @var $coInitiatorContact Contact */

			$coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
			/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */

			$coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
			/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
			/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();
			/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */

			// List of additional Change Order Recipients
			$loadChangeOrderRecipientsByChangeOrderNotificationIdOptions = new Input();
			$loadChangeOrderRecipientsByChangeOrderNotificationIdOptions->forceLoadFlag = true;
			$arrChangeOrderRecipientsByChangeOrderNotificationId = ChangeOrderRecipient::loadChangeOrderRecipientsByChangeOrderNotificationId($database, $change_order_notification_id, $loadChangeOrderRecipientsByChangeOrderNotificationIdOptions);

			// Change Order Attachments
			$loadChangeOrderAttachmentsByChangeOrderIdOptions = new Input();
			$loadChangeOrderAttachmentsByChangeOrderIdOptions->forceLoadFlag = true;
			$arrChangeOrderAttachmentsByChangeOrderId = ChangeOrderAttachment::loadChangeOrderAttachmentsByChangeOrderId($database, $change_order_id, $loadChangeOrderAttachmentsByChangeOrderIdOptions);

			// Timestamp
			$timestamp = date("D, M j g:i A", time());

			$uri = Zend_Registry::get('uri');
			//$url = $uri->https.'account-registration-form-step1.php?guid='.$guid;
			//$smsUrl = $uri->https.'r.php?guid='.$guid;

			// Cloud Filesystem URL & Filename
			$virtual_file_name = $coFileManagerFile->virtual_file_name;
			$escaped_virtual_file_name = $coFileManagerFile->escaped_virtual_file_name;
			//$virtual_file_name_url = $uri->cdn . '_' . $coFileManagerFile->file_manager_file_id;
			$virtual_file_name_url = $coFileManagerFile->generateUrl(true);
			$coUrl =
				$uri->http . 'modules-change_orders-form.php' .
					'?change_order_id='.$change_order_id;

			// Send out a SMS or Email
			// Determine if SMS, Email, or Both
			$emailFlag = true;
			$smsFlag = false;

			// Invitation Initiator/Sender/Inviter's Information
			$inviteFromName = '';

			// @todo Refactor this to inlcude the below HTML template section and SMS
			// Derived above - first in Project Executive list
			// Toggles back and forth
			// From:
			// To:
			if ($sendor_contact_id == $coCreatorContact->contact_id) {
				$toContact = $coRecipientContact;
				$fromContact = $coCreatorContact;
			} else {
				$toContact = $coCreatorContact;
				$fromContact = $coRecipientContact;
			}
			$toContact->htmlEntityEscapeProperties();
			$fromContact->htmlEntityEscapeProperties();

			// From:
			$fromName = $fromContact->getContactFullName();
			$fromEmail = $fromContact->email;
			$fromNameHtmlEscaped = $fromContact->getContactFullNameHtmlEscaped();
			$fromEmailHtmlEscaped = $fromContact->escaped_email;

			$smsFromName = $fromContact->getContactFullName();
			$smsFromEmail = $fromContact->email;
			$fromContactTitle = $fromContact->title;
			$fromContactTitleHtmlEscaped = $fromContact->escaped_title;

			// To:
			$toName = $toContact->getContactFullName();
			$toEmail = $toContact->email;
			$toNameHtmlEscaped = $toContact->getContactFullNameHtmlEscaped();
			$toEmailHtmlEscaped = $toContact->escaped_email;

			$smsToName = $toContact->getContactFullName();
			$smsToEmail = $toContact->email;
			$toContactTitle = $toContact->title;
			$toContactTitleHtmlEscaped = $toContact->escaped_title;

			// Return-To
			$returnName = $fromName;
			$returnEmail = $fromEmail;
			$smsReturnName = $fromName;
			$smsReturnEmail = $fromEmail;
			$returnContactTitle = $fromContactTitle;

			$alertMessageSubject = "Change Order #$changeOrder->co_sequence_number";
			$smsAlertMessageSubject = "Change Order #$changeOrder->co_sequence_number";

			$systemMessage = '';
			$systemMessage2 = '';
			$alertHeadline = '';
			$alertBody = '';

			//$smsAlertMessageBody = "Register: $smsUrl";
			$alertHeadline = $project->project_name.' Change Order #' . $changeOrder->co_sequence_number . '.';
			$systemMessage = $project->project_name.' Change Order #' . $changeOrder->co_sequence_number . '.';

			$bodyHtml = 'Change Order #' . $changeOrder->co_sequence_number . ': ';

			// Subject line has the project name in it
			//$smsAlertMessageBody = "Change Order #$changeOrder->co_sequence_number: $smsUrl";
			//$alertHeadline = 'Please <a href="'.$url.'">Register or Sign In</a> to Bid on '.$inviterUserCompany->company.'&#39;s '.$project->project_name.' project.';
			$systemMessage =
				'Please review this Change Order: <br>';
				//'Project Name: ' . $project->project_name . '<br>' .$costCode
				//' <a href="'.$virtual_file_name_url.'">' . $virtual_file_name . '</a><br>' .
				//'PDF: (<a href="'.$virtual_file_name_url.'">' . $virtual_file_name . '</a>)<br><br>';


			$systemMessage2 = '';

			// Invitation Initiator/Sender/Inviter's Information
			$submitFromSignature = '<div style="font-weight:bold; text-decoration: underline;">Change Order Message Sent By</div>';
			// Full Name
			if (isset($fromName) && !empty($fromName)) {
				$submitFromSignature .= $fromNameHtmlEscaped . '<br>';
			}
			// Title
			if (isset($fromContactTitle)) {
				$submitFromSignature .= $fromContactTitleHtmlEscaped . '<br>';
			}
			// Company
			if ($fromContact->contact_company_id) {
				$fromContactCompany = ContactCompany::findById($database, $fromContact->contact_company_id);
				/* @var $fromContactCompany ContactCompany */
				if ($fromContactCompany) {
					$fromContactCompany->htmlEntityEscapeProperties();
					$submitFromSignature .= $fromContactCompany->escaped_contact_company_name . '<br>';
				}
			}

			// Email
			$submitFromSignature .= $fromContact->escaped_email . '<br>';
			$submitFromSignature .= "Change Order Message Sent: $timestamp" . '<br>';

			$includeAttachment = true;

			$customEmailMessageFromSubmitter = '';
			$htmlAlertHeadline = '';

			// Send email to primary To:
			$toName = trim($toName);
			$greetingLine = '';
			if (isset($toName) && !empty($toName)) {
				$greetingLine = $toNameHtmlEscaped.',<br><br>';
			}

			// Optional Email Body
			if (!isset($emailBody) || empty($emailBody)) {
				$emailBody = '';
			} else {
				$emailBody = Data::entity_encode($emailBody);
				$emailBody = nl2br($emailBody);
				$emailBody .= '<br><br>';
			}

			$coPageLinkText = "Change Order #$changeOrder->co_sequence_number - $changeOrder->escaped_co_title";

// HTML Email output for Email clients that support HTML
$htmlAlertMessageBody = <<<END_HTML_MESSAGE
$greetingLine$emailBody$systemMessage
<br>
<table>
<thead>
<tr>
<th align="left" colspan="2" style="font-weight:bold; text-decoration: underline;">Change Order Summary</th>
</tr>
</thead>

<tbody>
<tr>
<td>Project:</td>
<td>$formattedProjectNameHtmlEscaped</td>
</tr>
<tr>
<td>Cost Code:</td>
<td>$formattedCoCostCode</td>
</tr>
<tr>
<td>Change Order Web Page URL:</td>
<td><a href="$coUrl">$coPageLinkText</a></td>
</tr>
<tr>
<td>Change Order PDF File:</td>
<td><a href="$virtual_file_name_url">$escaped_virtual_file_name</a></td>
</tr>
</tbody>
</table>
$systemMessage2
$customEmailMessageFromSubmitter
<br>
$submitFromSignature
<br>
END_HTML_MESSAGE;

			ob_start();
			//$formattedType = ucfirst($type);
			$headline = 'Change Order (CO)';
			//include('templates/mail-template-bid-spread-approval-request.php');
			include('templates/mail-template.php');
			$bodyHtml = ob_get_clean();

			try {
				//$var1 = $var2;
				// Debug
				/*
				if (strstr($toEmail, 'precision')) {
					throw new Exception('');
				}
				*/
				//throw new Exception('');
			$sendEmail = 'Alert@MyFulcrum.com';
    			$sendName = ($fromName !=" ") ? $fromName : "Fulcrum Message";
				if ($emailFlag) {
					//$toEmail = $email;

					$mail = new Mail();
					$mail->setReturnPath($returnEmail);
					//$mail->setBodyText($alertMessageBody);
					//$mail->setBodyText($bodyHtml);
					$mail->setBodyHtml($bodyHtml);
					//$mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED, false);
					$mail->setFrom($sendEmail, $sendName);
					$mail->addTo($toEmail, $toName);
					$mail->addHeader('Reply-To',$fromEmail);


					// Cc / Bcc
					foreach ($arrChangeOrderRecipientsByChangeOrderNotificationId as $changeOrderRecipient) {
						$change_order_notification_id = $changeOrderRecipient->change_order_notification_id;
						$co_additional_recipient_contact_id = $changeOrderRecipient->co_additional_recipient_contact_id;
						$co_additional_recipient_contact_mobile_phone_number_id = $changeOrderRecipient->co_additional_recipient_contact_mobile_phone_number_id;
						$smtp_recipient_header_type = $changeOrderRecipient->smtp_recipient_header_type;

						$changeOrderNotification = $changeOrderRecipient->getChangeOrderNotification();
						/* @var $changeOrderNotification ChangeOrderNotification */

						$coAdditionalRecipientContact = $changeOrderRecipient->getCoAdditionalRecipientContact();
						/* @var $coAdditionalRecipientContact Contact */

						$coAdditionalRecipientContactMobilePhoneNumber = $changeOrderRecipient->getCoAdditionalRecipientContactMobilePhoneNumber();
						/* @var $coAdditionalRecipientContactMobilePhoneNumber ContactPhoneNumber */

						// Cc or Bcc
						if ($coAdditionalRecipientContact) {
							$additionalTo = $coAdditionalRecipientContact->getContactFullName();
							$additionalEmail = $coAdditionalRecipientContact->email;
						} else {
							continue;
						}

						if (isset($smtp_recipient_header_type)) {
							if ($smtp_recipient_header_type == 'Bcc') {
								$mail->addBcc($additionalEmail, $additionalTo);
							} else {
								$mail->addCc($additionalEmail, $additionalTo);
							}
						} else {
							// Defaul to Cc for bad data case
							$mail->addCc($additionalEmail, $additionalTo);
						}
					}

					$mail->setSubject($alertMessageSubject);
					if ($includeAttachment && isset($coFileManagerFile) && $coFileManagerFile) {
						// Attach Change Order itself
						$cdnFileUrl = $coFileManagerFile->generateUrl();
						$attachmentFileName = $coFileManagerFile->virtual_file_name;

						$cdnFileUrl = str_replace("http:", '', $cdnFileUrl);
						if (strpos($cdnFileUrl, '?')) {
							$separator = '&';
						} else {
							$separator = '?';
						}
						$finalCdnFileUrl = 'http:' . $cdnFileUrl . $separator . 'id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
						$fileContents = file_get_contents($finalCdnFileUrl);
						$mail->createAttachment($attachmentFileName, $fileContents);

						//$file = $mail->createAttachment($fileContents);
						//$file->filename = $attachmentFileName;

						//foreach ($arrChangeOrderAttachmentsByChangeOrderId as $changeOrderAttachment) {
						//	$coAttachmentFileManagerFile = $changeOrderAttachment->getCoAttachmentFileManagerFile();
						//	/* @var $coAttachmentFileManagerFile FileManagerFile */
						//
						//	$coAttachmentSourceContact = $changeOrderAttachment->getCoAttachmentSourceContact();
						//	/* @var $coAttachmentSourceContact Contact */
						//
						//	//$cdnFileUrl = $arrAttachments[$file_manager_file_id]['cdnFileUrl'];
						//	//$attachmentFileName = $arrAttachments[$file_manager_file_id]['fileName'];
						//	$cdnFileUrl = $coAttachmentFileManagerFile->generateUrl();
						//	$attachmentFileName = $coAttachmentFileManagerFile->virtual_file_name;
						//
						//	$cdnFileUrl = str_replace("http:", '', $cdnFileUrl);
						//	$finalCdnFileUrl = 'http:' . $cdnFileUrl . '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
						//	$fileContents = file_get_contents($finalCdnFileUrl);
						//	$mail->createAttachment($attachmentFileName, $fileContents);
						//
						//	//$file = $mail->createAttachment($fileContents);
						//	//$file->filename = $attachmentFileName;
						//}

					}
					$mail->send();
				}

				if ($smsFlag) {
					// MessageGateway_Sms
					MessageGateway_Sms::sendSmsMessage($mobile_phone_number, $mobile_network_carrier_id, $smsToName, $smsFromEmail, $smsFromName, $smsAlertMessageSubject, $smsAlertMessageBody);
				}
			} catch(Exception $e) {
				// Mail/SMS failed to send
				$errorMessage = $e->getMessage();
				throw new Exception($errorMessage);
			}

			// Debug
			//exit;

			$customEmailMessageFromSubmitter = '';

			foreach ($arrChangeOrderRecipientsByChangeOrderNotificationId as $changeOrderRecipient) {

				// SKIP THIS SECTION
				continue;

				$change_order_notification_id = $changeOrderRecipient->change_order_notification_id;
				$co_additional_recipient_contact_id = $changeOrderRecipient->co_additional_recipient_contact_id;
				$co_additional_recipient_contact_mobile_phone_number_id = $changeOrderRecipient->co_additional_recipient_contact_mobile_phone_number_id;
				$smtp_recipient_header_type = $changeOrderRecipient->smtp_recipient_header_type;

				$changeOrderNotification = $changeOrderRecipient->getChangeOrderNotification();
				/* @var $changeOrderNotification ChangeOrderNotification */

				$coAdditionalRecipientContact = $changeOrderRecipient->getCoAdditionalRecipientContact();
				/* @var $coAdditionalRecipientContact Contact */

				$coAdditionalRecipientContactMobilePhoneNumber = $changeOrderRecipient->getCoAdditionalRecipientContactMobilePhoneNumber();
				/* @var $coAdditionalRecipientContactMobilePhoneNumber ContactPhoneNumber */

				// Email/SMS Details
				// To Name
				$toName = $coAdditionalRecipientContact->getContactFullName();
				$smsToName = $toName;
				$toEmail = $coAdditionalRecipientContact->email;
				$toName = trim($toName);
				$greetingLine = '';
				if (isset($toName) && !empty($toName)) {
					$greetingLine = $toName.',<br><br>';
				}

// HTML Email output for Email clients that support HTML
$htmlAlertMessageBody = <<<END_HTML_MESSAGE
$greetingLine$emailBody$systemMessage
<br>
<table>
<thead>
<tr>
<th align="left" colspan="2" style="font-weight: bold; text-decoration: underline;">Change Order Summary</th>
</tr>
</thead>

<tbody>
<tr>
<td>Project:</td>
<td>$formattedProjectNameHtmlEscaped</td>
</tr>
<tr>
<td>Cost Code:</td>
<td>$formattedCoCostCode</td>
</tr>
<tr>
<td>Change Order Web Page URL:</td>
<td><a href="$coUrl">$coPageLinkText</a></td>
</tr>
<tr>
<td>Change Order PDF File:</td>
<td><a href="$virtual_file_name_url">$escaped_virtual_file_name</a></td>
</tr>
</tbody>
</table>
$systemMessage2
$customEmailMessageFromSubmitter
<br>
$submitFromSignature
<br>
END_HTML_MESSAGE;

				ob_start();
				//$formattedType = ucfirst($type);
				$headline = 'Change Order (CO)';
				//include('templates/mail-template-bid-spread-approval-request.php');
				include('templates/mail-template.php');
				$bodyHtml = ob_get_clean();

				try {
					//$var1 = $var2;
					// Debug
					/*
					if (strstr($toEmail, 'precision')) {
						throw new Exception('');
					}
					*/
					//throw new Exception('');
					if ($emailFlag) {
						//$toEmail = $email;

						$mail = new Mail();
						$mail->setReturnPath($returnEmail);
						//$mail->setBodyText($alertMessageBody);
						//$mail->setBodyText($bodyHtml);
						$mail->setBodyHtml($bodyHtml);
						//$mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED, false);
						$mail->setFrom($fromEmail, $fromName);

						// Cc or Bcc
						if (isset($smtp_recipient_header_type)) {
							if ($smtp_recipient_header_type == 'Bcc') {
								$mail->addBcc($toEmail, $toName);
							} else {
								$mail->addCc($toEmail, $toName);
							}
						}

						$mail->setSubject($alertMessageSubject);
						if ($includeAttachment) {
							// Attach Change Order itself
							$cdnFileUrl = $coFileManagerFile->generateUrl();
							$attachmentFileName = $coFileManagerFile->virtual_file_name;

							$cdnFileUrl = str_replace("http:", '', $cdnFileUrl);
							$finalCdnFileUrl = 'http:' . $cdnFileUrl . '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
							$fileContents = file_get_contents($finalCdnFileUrl);
							$mail->createAttachment($attachmentFileName, $fileContents);

							//$file = $mail->createAttachment($fileContents);
							//$file->filename = $attachmentFileName;

							//foreach ($arrChangeOrderAttachmentsByChangeOrderId as $changeOrderAttachment) {
							//	$coAttachmentFileManagerFile = $changeOrderAttachment->getCoAttachmentFileManagerFile();
							//	/* @var $coAttachmentFileManagerFile FileManagerFile */
							//
							//	$coAttachmentSourceContact = $changeOrderAttachment->getCoAttachmentSourceContact();
							//	/* @var $coAttachmentSourceContact Contact */
							//
							//	//$cdnFileUrl = $arrAttachments[$file_manager_file_id]['cdnFileUrl'];
							//	//$attachmentFileName = $arrAttachments[$file_manager_file_id]['fileName'];
							//	$cdnFileUrl = $coAttachmentFileManagerFile->generateUrl();
							//	$attachmentFileName = $coAttachmentFileManagerFile->virtual_file_name;
							//
							//	$cdnFileUrl = str_replace("http:", '', $cdnFileUrl);
							//	$finalCdnFileUrl = 'http:' . $cdnFileUrl . '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
							//	$fileContents = file_get_contents($finalCdnFileUrl);
							//	$mail->createAttachment($attachmentFileName, $fileContents);
							//
							//	//$file = $mail->createAttachment($fileContents);
							//	//$file->filename = $attachmentFileName;
							//}

						}
						$mail->send();
					}

					if ($smsFlag) {
						// MessageGateway_Sms
						MessageGateway_Sms::sendSmsMessage($mobile_phone_number, $mobile_network_carrier_id, $smsToName, $smsFromEmail, $smsFromName, $smsAlertMessageSubject, $smsAlertMessageBody);
					}
				} catch(Exception $e) {
					// Mail/SMS failed to send
					$errorMessage = $e->getMessage();
					throw new Exception($errorMessage);
				}
			}

			$message->reset($currentPhpScript);

			$emailSent = true;


			// Output standard formatted error or success message
			if ($emailSent) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error sending email: Change Order.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: Change Order';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$emailSent|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		echo $output;

	break;

	case 'ChangeOrders__generateChangeOrdersListViewPdf':

		$errorNumber = 0;
		$errorMessage = '';
		$attributeGroupName = '';
		$primaryKeyAsString = '';
		$htmlContent = '';

		// @todo Add sorting paramaters on the query string

		$coType = $get->coType;
		$change_order_type_id = '';
		if (isset($coType) && !empty($coType)) {

			if ($coType == 'all') {
				$change_order_type_id = '';
			} elseif ($coType == 'oco') {
				$change_order_type_id = 3;
			} elseif ($coType == 'cor') {
				$change_order_type_id = 2;
			} elseif ($coType == 'pco') {
				$change_order_type_id = 1;
			}

		}

		$showreject = $get->showreject;

		$pdfFlag = true;
		$coTable = renderCoListView_AsHtml($database, $project_id, $user_company_id, $change_order_type_id, $pdfFlag,'3',$showreject);
		// $htmlContent = $coTable;
		/*GC logo*/
		require_once('lib/common/Logo.php');
	$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$user_company_id,true);
	$fulcrum = Logo::logoByFulcrumByBasePathOnlyLink(true);
	$fulcrum_img="<img src='$fulcrum' style='margin-left:0px;'>";
	$headerLogo=<<<headerLogo
	<table width="100%" class="table-header">
 	<tr>
 	<td>$gcLogo</td>
 	<td align="right"><span style="margin-top:10px;">$fulcrum_img</span></td>
 	</tr>
 	</table>
 	
headerLogo;
		/*GC logo end*/
	//Footer content
	$data=ContactCompany::GenerateFooterData($user_company_id,$database);
	$address=$data['address'];
	$number=$data['number'];
	$footer_cont=$address.' '.$number;
	//End of footer content
	$htmlContent .= <<<END_HTML_CONTENT
	<!DOCTYPE html>

	<html>
	<head>
	<style>
	#SubcontracttblTabularData{	
	border-collapse: collapse;
	border-left: 1px solid #adadad;
	border-top: 1px solid #adadad;
	border-right: 1px solid #adadad;
	}
	#SubcontracttblTabularData thead th{
	border-bottom: 1px solid #adadad !important;
	empty-cells: show !important;
	padding: 4px;
	font-size: 11px;
	vertical-align: bottom;
	}
	#SubcontracttblTabularData td{
	border-bottom: 1px solid #000;
	border-right: 1px solid #000;
	empty-cells: show !important;
	padding: 4px;
	vertical-align: bottom;
	}
	#SubcontracttblTabularData td
	{
	border-bottom: 1px solid #adadad;
	border-right: 1px solid #adadad;
	}
	#SubcontracttblTabularData td
	{
	font-size: 11px !important;
	border-bottom: 1px solid #adadad;
	border-right: 1px solid #adadad;
	}
	.textAlignLeft { text-align: left; }
	.textAlignCenter { text-align: center; }
	.textAlignRight { text-align: right; }
	.purStyle {background: #dfdfdf;}
	.purtotStyle{background: #8B8E90;}
	.headsle{	color: #026dae ;font-size: 12px;}
	.permissionTableMainHeader td{
		font-weight:bold !important;
	}
	.permissionTableMainHeader{
		background: #3b90ce;
		color: white;
		padding: 5px 10px;
		text-align: center;
		vertical-align: bottom;
		border-color:#ffffff;
	}
	</style>
	</head>
	<body>
	$headerLogo
	$coTable
	</body>
	</html>
END_HTML_CONTENT;


		// Place the PDF file in a download directory and output the download link.
		$config = Zend_Registry::get('config');
		$baseDirectory = $config->system->base_directory;
		$fileManagerBasePath = $config->system->file_manager_base_path;

		//$version4_uuid = UniversallyUniqueIdentifier::version4();
		//$tempFolder = $version4_uuid . '/';
		$tempFolder = '';

		$fileDownloadUrlDirectory = '/downloads/temp/'.$user_company_id.'/'.$project_id.'/'.$tempFolder;
		$fileDownloadTempDir = $baseDirectory.'www/www.axis.com'.$fileDownloadUrlDirectory;
		$fileObject = new File();
		$fileObject->mkdir($fileDownloadTempDir, 0777);

		$pdfPhantomJS = new PdfPhantomJS();
		$pdfPhantomJS->setPdfPaperSize('8.5in', '11in');
	  	$pdfPhantomJS->setPdffooter($footer_cont);
	  	$pdfPhantomJS->setMargin('50px', '50px', '50px', '10px');

		$pdfPhantomJS->writeTempFileContentsToDisk($htmlContent);

		// generate url with query_string for phontomJS to read the file with contents from $htmlOutput
		$pdfTempFileUrl = $pdfPhantomJS->getTempFileUrl();

		$pdfPhantomJS->setTempFileUrl($pdfTempFileUrl);
		$htmlTempFileBasePath = $pdfPhantomJS->getTempFileBasePath();
		$htmlTempFileSha1 = $pdfPhantomJS->getTempFileSha1();
		$pdfTempFileFullPath = $htmlTempFileBasePath . $htmlTempFileSha1 . '.pdf';
		$pdfPhantomJS->setCompletePdfFilePath($pdfTempFileFullPath);

		$result = $pdfPhantomJS->execute();

		// delete the html temp file
		$pdfPhantomJS->deleteTempFile();

		$finalFilePath = $fileDownloadTempDir .  $htmlTempFileSha1 . '.pdf';

		rename($pdfTempFileFullPath, $finalFilePath);

		$nowDate = date('m/d/Y');
		$filename = "$userCompanyName - $project_name - $nowDate Change Order.pdf";
		$encodedFilename = rawurlencode($filename);
		$url = $fileDownloadUrlDirectory . $htmlTempFileSha1 . '.pdf?filename=' . $encodedFilename;

		$arrOutput = array(
			'errorNumber' => $errorNumber,
			'errorMessage' => $errorMessage,
			'url' => $url
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;
	case 'updateSubcontractors':
		$costcode = (int) $get->costcode_id;
		$dummyId = $get->dummy;
		$user_company_id = (int) $get->company_id;
		$project_id = (int) $get->project_id;

		$coDraftsHiddenContactsByUserCompanyIdToElementId = "create-change_order_draft-record--change_order_drafts--co_initiator_contact_id--$dummyId";
		$input = new Input();
		$input->database = $database;
		$input->user_company_id = $user_company_id;
		$input->costcode = $costcode;
		$input->project_id = $project_id;
		if(isset($su_initiator_contact_id)){
		$input->selected_contact_id = $su_initiator_contact_id;
		}
		$input->htmlElementId = "create-change_order-record--change_orders--co_initiator_contact_id--$dummyId";
		$input->js = ' class="emailGroup" onchange="ddlOnChange_UpdateHiddenInputValue(this);ddlOnChange_UpdateHiddenInputValue(this, \''.$coDraftsHiddenContactsByUserCompanyIdToElementId.'\');"';
		$input->firstOption = 'Optionally Select A CO Initiator Contact';
		if($costcode){
			$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildSubmittalsContactsFullNameWithEmailByUserCompanyIdDropDownList($input);
		}else{
			$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildContactsFullNameWithEmailByUserCompanyIdDropDownList($input);
		}
		echo $contactsFullNameWithEmailByUserCompanyIdDropDownList;
	break;
}

$htmlOutput = ob_get_clean();
echo $htmlOutput;

while (@ob_end_flush());

exit; // End of PHP Ajax Handler Code

} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}
