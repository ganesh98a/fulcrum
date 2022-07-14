<?php
ini_set("memory_limit", "1000M");
/**
* Save and Update the delay 
*/


$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;

require_once('lib/common/init.php');
require_once('modules-requests-for-information-functions.php');
require_once('lib/common/Contact.php');
require_once('lib/common/ContractingEntities.php');
require_once('lib/common/Module.php');
require_once('lib/common/Service/TableService.php');

$timer->startTimer();
$_SESSION['timer'] = $timer;

// Get session Values
$projectId = $session->getCurrentlySelectedProjectId();
$projectName = $session->getCurrentlySelectedProjectName();
$userCompanyId = $session->getUserCompanyId();
$userId = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

$delayDb = DBI::getInstance($database);  // Db Initialize


$formValues = $_POST['formValues'];     // Get the form post values
if($formValues)
{    
    $delayId = $formValues['delayid'];           // Get the delay id for check new delay or update delay 

    $source             =   'Delaylog';
    $sourcelist         =   $formValues['sourceid'];
    $type               =   $formValues['userTypeSelectId'];
    $subcat             =   $formValues['subuserTypeSelectId'];
    $bdate              =   $formValues['bdateId'];
    $edate              =   $formValues['edateId'];
    $days               =   $formValues['daysId'];
    $notes              =   addslashes($formValues['notesId']);
    $status             =   $formValues['statusId'];
    $notified           =   $formValues['notifiedId'];
    $mailText           =   $formValues['mailText'];
    $attachments        =   $formValues['attachments'];
    $fileAttachments    =   json_decode($attachments);
    $emailTo            =   $formValues['emailTo'];
    $methodType         =   $formValues['methodType'];
    $notes              =   nl2br(htmlentities(trim($notes)));
    if($methodType == '1')   // If save as Email Notification, set the column "Notified" as YES.
    {
        $notified = '1';
    }

    $bcc = $formValues['emailBCc'];
    $bccValues = json_decode($bcc);
    $cc  = $formValues['emailCc'];
    $ccValues = json_decode($cc);


    // Get company name
    $companyQuery = "SELECT company FROM user_companies where id='$userCompanyId'  limit 1 ";
    $delayDb->execute($companyQuery);
    $companyResult = array();
    while($row = $delayDb->fetch())
    {
        $companyResult[] = $row;
    }
    $companyName = $companyResult[0]['company']; 
    $delayDb->free_result();

    
    // Get category/type name
    $typeQuery = "SELECT jobsite_delay_category FROM jobsite_delay_category_templates where id='$type' limit 1 ";
    $delayDb->execute($typeQuery);
    $typeResult = array();
    while($row = $delayDb->fetch())
    {
        $typeResult[] = $row;
    }
    $typeName = $typeResult[0]['jobsite_delay_category'];
    $delayDb->free_result();
    
    
    // Convert the date format 
    if($bdate == '')
    {
        $formattedDelaybdate = '';
    }else{
        $formattedDelaybdate = date('Y-m-d', strtotime($bdate));
    }
    if($edate == '')
    {
        $formattedDelayedate = '';
    }
    else
    {
        $formattedDelayedate = date('Y-m-d', strtotime($edate));
    }
    if($days == '' || $days == 'NA')
    {
        $bDate = strtotime($formattedDelaybdate);
        $eDate = strtotime($formattedDelayedate);
        $datediff = $eDate - $bDate;
      $delayDays = floor($datediff / (60 * 60 * 24));
    }else{
        $delayDays = $days;
    }
      // To include contracting Entity
    $contract_entity_id = ContractingEntities::getcontractEntityAgainstProject($database,$projectId);
    if(isset($delayId) && !empty($delayId)){    // Update the delay
        $SequenceNumber= findDelaySequenceNumber($delayDb,$projectId,$delayId);
        $query="UPDATE jobsite_delay_data SET source=?,type=?,subcategory=?,begindate=?,enddate=?,days=?,notes=?,status=?,notified=?,updated_by=?,mail_to=?,contracting_entity_id=? WHERE id=?";
        $arrValues = array($sourcelist,$type,$subcat,$formattedDelaybdate,$formattedDelayedate,$delayDays,$notes,$status,$notified,$userId,$emailTo,$contract_entity_id,$delayId);
        if($delayDb->execute($query,$arrValues)){
            $status = '2';
        }  
        $delayDb->free_result();
    }
    else{               
         // To add the sequence number
   $SequenceNumber= findNextdelaySequenceNumber($delayDb,$projectId);
     // Insert the delay
        $query = "INSERT INTO jobsite_delay_data(source,type,subcategory,begindate,enddate,days,notes,status,notified, project_id,contracting_entity_id, user_id,mail_to,delay_sequence_number) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrValues = array($source,$type,$subcat,$formattedDelaybdate,$formattedDelayedate,$delayDays,$notes,$status,$notified,$projectId,$contract_entity_id,$userId,$emailTo,$SequenceNumber);
        if($delayDb->execute($query,$arrValues)){
            $delayId = $delayDb->insertId; 
            $status = '1';
        }
        $delayDb->free_result();
      
    }
    $Project_delay_days='';
    $query1 = "SELECT * FROM `jobsite_delay_data` WHERE `project_id` =$projectId and `is_deleted`='0' and 
    `notified`='1' ORDER BY `id` DESC LIMIT 0 , 30";
    
    $delayDb->execute($query1);
    while($row_get = $delayDb->fetch())
    {
        $days = $row_get['days'];
        if($days!='')
        {
            $Project_delay_days=$Project_delay_days+$days;
        }else
        {
            $bDate1 = strtotime($row_get['begindate']);
            $eDate1 = strtotime($row_get['enddate']);
            $datediff1 = $eDate1 - $bDate1;
            $prjDays = floor($datediff1 / (60 * 60 * 24));
            $Project_delay_days=$Project_delay_days+$prjDays;
        }
        
    }
    $delayDb->free_result();
    
    
    //To Insert into transmittal table
    if($Project_delay_days > '0')
    {
        $query1 = "SELECT * FROM transmittal_types where transmittal_category='Delay Notice'";
        $delayDb->execute($query1);
        while($row1 = $delayDb->fetch())
        {
           
            $val = $row1['id'];
           
        }
        $delay_notice=$val; // Refer to Transmittal_types table
        $Transmittal_ID=$val;
        // Insert the transmittal
        $sequence_query = "SELECT sequence_number FROM transmittal_data WHERE project_id = $projectId ORDER BY id DESC";
        $delayDb->execute($sequence_query);
        $sequence = $delayDb->fetch();
        $delayDb->free_result();
        if(isset($sequence) && !empty($sequence)){
            $sequence_no = (intVal($sequence['sequence_number']) + 1);
        } else {
            $sequence_no = 1;
        }

        $realSource = TableService::getSingleField($database,'jobsite_delay_data','source','id',$delayId);
        if ($notes != '') {
            $notes = ' | '.$notes;
        }

        $notes_comment = '#'.$SequenceNumber.' - '.$realSource.$notes;

        $query = "INSERT INTO transmittal_data(sequence_number,transmittal_type_id,project_id,contracting_entity_id,comment,raised_by,mail_to,mail_content) VALUES(?,?,?,?,?,?,?,?)";
         $arrValues = array($sequence_no,$delay_notice,$projectId,$contract_entity_id,$notes_comment,$currentlyActiveContactId,$emailTo,$mailText);

        if($delayDb->execute($query,$arrValues)){
            $TransmittalId = $delayDb->insertId; 
            $status = '1';
        }
        $delayDb->free_result();

    }
    if($status)
    {

        // Naming Convention of Virtual File path for upload attachments
         $virtual_file_path = '/Delays/Delay #' . $SequenceNumber . '/';

        

        $arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
        $currentVirtualFilePath = '/';
        foreach ($arrFolders as $folder) {
            $tmpVirtualFilePath = array_shift($arrFolders);
            $currentVirtualFilePath .= $tmpVirtualFilePath.'/';

            // Save the file_manager_folders record (virtual_file_path) to the db and get the id
            $fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $userCompanyId, $currentlyActiveContactId, $projectId, $currentVirtualFilePath);
        }
        // To Creating Transmittal Virtual Folder
        if($Project_delay_days > '0')
        {
         
         $trans_virtual_file_path = 'Transmittals/Transmittal #' . $sequence_no . '/';

         $arrFolders = preg_split('#/#', $trans_virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
         $currentVirtualFilePath = '/';

         foreach ($arrFolders as $folder) {
            $tmpVirtualFilePath = array_shift($arrFolders);
            $currentVirtualFilePath .= $tmpVirtualFilePath.'/';
            // Save the file_manager_folders record (trans_virtual_file_path) to the db and get the id
            $fileManagerFolder_trans = FileManagerFolder::findByVirtualFilePath($database, $userCompanyId, $currentlyActiveContactId, $projectId, $currentVirtualFilePath);
        }
        $file_manager_folder_trans_id = $fileManagerFolder_trans->file_manager_folder_id;
    }
    //End to create transmittal Folder path
       

        // Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
        $file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

        $config = Zend_Registry::get('config');
        $file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
        $tempFileName = File::getTempFileName();
        $fileManagerBasePath = $config->system->file_manager_base_path;
        $tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
        $chmodDir = $fileManagerBasePath.'temp/';
        $unlinkDir = $tempDir;
        $fileObject = new File();
        $fileObject->mkdir($tempDir, 0777);
        $pdf_total_num='';
        $indexVal=0;
        $counter = 2;
        if(!empty($fileAttachments))
        {
            $dsort = 0;
            foreach($fileAttachments as $fileAttachment)
            {
                $delayDb = DBI::getInstance($database);  // Db Initialize
                $delayDb->free_result();
                $selectSql = "SELECT * FROM jobsite_delay_data_attachments WHERE attachment_file_manager_file_id = $fileAttachment and jobsite_delay_data_id = $delayId";
                $delayDb->execute($selectSql);
                $row = $delayDb->fetch();
                $delayDb->free_result();
                if(empty($row)){                 
                $delayDb = DBI::getInstance($database);  // Db Initialize
                $attachmentSql = "INSERT INTO jobsite_delay_data_attachments(attachment_file_manager_file_id,jobsite_delay_data_id,sort_order) VALUES('$fileAttachment','$delayId','$dsort')";
                $delayDb->execute($attachmentSql);
                $delayDb->free_result();
                }else
                {
                    $delayDb = DBI::getInstance($database);  // Db Initialize
                    $attachmentSql = "UPDATE  jobsite_delay_data_attachments set sort_order= ? where attachment_file_manager_file_id = ? and jobsite_delay_data_id = ?";
                    $arrValues = array($dsort,$fileAttachment,$delayId);
                    $delayDb->execute($attachmentSql,$arrValues);
                    $delayDb->free_result();
                }
               
                //For Transmittal attachment
                if($Project_delay_days > '0')
                {
                    //End of newly added
                $attachmentSql = "INSERT INTO transmittal_attachments(attachment_file_manager_file_id,transmittal_data_id,sort_order) VALUES('$fileAttachment','$TransmittalId','$dsort')";
                $delayDb->execute($attachmentSql);
                $delayDb->free_result();
                }
                 $dsort++;
                //End of transmittal attachment
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
                FileManagerFile::restoreFromTrash($database,$fileManagefile->file_manager_file_id);
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
                if(in_array($tempDelayAttachmentFileExtension,$PDFMergeFormatArray))
                if($statusFlag) {
                    
                $arrPdfFiles[] = $tempPdfFile;
                    //To get the page Count for pdf
                $pdf_page_file=$tempDir.$tempPdfFile;
                $cc= exec("identify -format %n $pdf_page_file");
                $pdf_total_num=$pdf_total_num+$cc;

                  //End to get the pdf page count
                }
                /*attachment name array*/
                $counter++;
            }
        }
        /*GCLogo copy to temp path*/
        require_once('lib/common/Logo.php');
        $fulcrum = Logo::logoByFulcrum();
        /*Fetch ids*/
        $main_company = Project::ProjectsMainCompany($database,$projectId);
        $ArrayLogoIDs = Logo::filelocationID($database,$main_company);
        $file_location_id = $ArrayLogoIDs['file_location_id'];
        $image_manager_image_id = $ArrayLogoIDs['image_manager_image_id'];
        /*config path get*/
        $config = Zend_Registry::get('config');
        $basedircs = $config->system->file_manager_base_path;
        $basepathcs = $config->system->file_manager_backend_storage_path ;
        $file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
        $baseDirectory = $config->system->base_directory;
        
        $fileManagerBackendFolderPath = $basedircs.$basepathcs;
        $objFileOperation = new File();
        /*validate dir*/
        $urlDirectory = 'downloads/'.'temp/';
        $outputDirectory = $baseDirectory.'www/www.axis.com/'.$urlDirectory;
        if (!is_dir($outputDirectory)) {
            $directoryCreatedFlag = $objFileOperation->mkdir($outputDirectory, 0777);
        }
        
        $tempFileNameLogo = '_Logo'.round(microtime(true)*5000);
        $LogoDestination = $outputDirectory.$tempFileNameLogo;

        /*uri path*/
        $uri = Zend_Registry::get('uri');
        $cdn_origin_node_absolute_url = $uri->cdn_origin_node_absolute_url;
        if($image_manager_image_id!=''){
            $imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);            
            $arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
            $arrPath = $arrFilePath['file_path'].$arrFilePath['file_name'];
            $path = $arrPath;
            $infopath= realpath($path);
            $info   = getimagesize($infopath);
            $Logomime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
            $Logowidth  = $info[0]; // width as integer for ex. 512
            $Logoheight = $info[1]; // height as integer for ex. 384
            $Logotype   = $info[2];      // same as exif_imagetype
            resize($path,$LogoDestination,$Logowidth,$Logoheight);
            $fileLogoPath = $urlDirectory.$tempFileNameLogo;
            $base64 = 'data:image;base64,' . base64_encode($filegetcontent);
            $gcLogo = <<<gcLogo
            <img src="$fileLogoPath"  alt="Logo" style="margin-left:0px;">
gcLogo;
        }else{
            $gcLogo = <<<gcLogo
           
gcLogo;
        }
        $headerLogo=<<<headerLogo
            <table width="100%" class="table-header">
            <tr>
            <td>$gcLogo</td>
            <td align="right"><span style="margin-top:10px;">$fulcrum</span></td>
            </tr>
            </table>
            <hr>
headerLogo;
        $attachments = json_decode($attachments);
        /*Mail Attach filelocation id*/
        $arrayMailAttach = array();
        $MailAttachFormatArray = array('0'=>'PDF','1'=>'pdf','2'=>'jpg','3'=>'jpeg','4'=>'png','5'=>'gif');
        /*Photo Add last in pdf format*/
        $pthotoAddFormatArray = array('0'=>'jpg','1'=>'jpeg','2'=>'png','3'=>'gif');
        /*photo addd array*/
        $photoAddPdf = array();
        foreach($attachments as $existAttach => $attachExist)
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
            $filename=$basedircs.$basepathcs.$shortFilePath.$file_manager_file_name_prefix.$fileName;
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
        // Naming convention for pdf
        $typeName = str_replace("/","",$typeName);
            $virtual_file_name_tmp = $typeName.'.pdf';
       

        $counter = 2;
        // Pdf conversion
        $htmlContent = buildDelayAsHtmlForPdfConversion('delay',$Transmittal_ID, $database, $userCompanyId, $delayId,$projectName,$projectId,$pdf_total_num,$Project_delay_days,$userId,$headerLogo, $jobsitePhotoHtmlContent, true);
        /*mailcontent*/
        $htmlMailContent = buildDelayAsHtmlForPdfConversion('delay',$Transmittal_ID, $database, $userCompanyId, $delayId,$projectName,$projectId,$pdf_total_num,$Project_delay_days,$userId);
        
        $htmlContent = html_entity_decode($htmlContent);
        $htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");
        $dompdf = new DOMPDF();
        $dompdf->load_html($htmlContent);
        $dompdf->set_paper("letter", "portrait");
        $dompdf->render();
        $pdf_content = $dompdf->output();
        $tempPdfFile = '_temp'.round(microtime(true)*1000).'.pdf';
        $tempFilePath = $tempDir . $tempPdfFile;
        file_put_contents($tempFilePath, $pdf_content); // save pdf to temp folder
        $cc1= exec("identify -format %n $tempFilePath");
        $pdf_total_num=$pdf_total_num+$cc1;
        //start
        $htmlContent = buildDelayAsHtmlForPdfConversion('delay',$Transmittal_ID, $database, $userCompanyId, $delayId,$projectName,$projectId,$pdf_total_num,$Project_delay_days,$userId,$headerLogo, $jobsitePhotoHtmlContent, true);
               
        $htmlContent = html_entity_decode($htmlContent);
        $htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");
        $dompdf = new DOMPDF();
        $dompdf->load_html($htmlContent);
        $dompdf->set_paper("letter", "portrait");
        $dompdf->render();
        $pdf_content = $dompdf->output();
        $tempPdfFile = '_temp'.round(microtime(true)*1000).'.pdf';
        $tempFilePath = $tempDir . $tempPdfFile;
        file_put_contents($tempFilePath, $pdf_content);
        //end
        /*Merge attach pdfs*/
       
        $arrTransPdfFiles=$arrPdfFiles;
        if (!empty($arrPdfFiles)) {

                // Put the cover sheet first in the list
                array_unshift($arrPdfFiles, $tempPdfFile);
                $finalTempFileName = '_temp'.round(microtime(true)*500).'.pdf';
                // Merge the RFI pdf and all RFI attachments into a single RFI pdf document
                Pdf::merge($arrPdfFiles, $tempDir, $finalTempFileName);

                $tempFilePath = $tempDir.$finalTempFileName;

            }
        $sha1 = sha1_file($tempFilePath);
        $size = filesize($tempFilePath);
        $fileExtension = 'pdf';
        $virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);
        $tmpFileManagerFile = new FileManagerFile($database);
        $tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
        $delayFileName= $virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();

        $file = new File();
        $file->sha1 = $sha1;
        $file->name = $virtual_file_name;
        $file->size = $size;
        $file->type = $virtual_file_mime_type;
        $file->tempFilePath = $tempFilePath;
        $file->fileExtension = $fileExtension;

        // Save the pdf into cloud
        $delayFileId = $file_location_id = FileManager::saveUploadedFileToCloud($database, $file);

        // save the file information to the file_manager_files db table
        $fileManagerFile = FileManagerFile::findByVirtualFileName($database, $userCompanyId, $currentlyActiveContactId, $projectId, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
            /* @var $fileManagerFile FileManagerFile */

        $file_manager_file_id = $fileManagerFile->file_manager_file_id;
        FileManagerFile::restoreFromTrash($database,$file_manager_file_id);

            // Potentially update file_location_id
        if ($file_location_id <> $fileManagerFile->file_location_id) 
        {
            $fileManagerFile->file_location_id = $file_location_id;
            $data = array('file_location_id' => $file_location_id);
            $fileManagerFile->setData($data);
            $fileManagerFile->save();
        }
        $attachMentFile = $fileManagerFile->generateUrl(true);
        // Set Permissions of the file to match the parent folder.
        $parent_file_manager_folder_id = $fileManagerFolder->getParentFolderId();
        FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
        FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);
        // Delete temp files
        $chmodDir = rtrim($chmodDir , '/');
        $cmd = "chmod -R 777 '$chmodDir'";
        $cmd=`$cmd`;
        // To create a pdf For Transmittal Module
        if($Project_delay_days > '0')
        {
            /*mailcontent*/
        $htmlTransmittalMailContent = buildDelayAsHtmlForPdfConversion('transmittal',$Transmittal_ID, $database, $userCompanyId, $delayId,$projectName,$projectId,$pdf_total_num,$Project_delay_days,$userId,'','',false,$TransmittalId);
       

        $TransmittalContent = buildDelayAsHtmlForPdfConversion('transmittal',$Transmittal_ID, $database, $userCompanyId, $delayId,$projectName,$projectId,$pdf_total_num,$Project_delay_days,$userId,$headerLogo,$jobsitePhotoHtmlContent, true,$TransmittalId);
        
        $TransmittalContent = html_entity_decode($TransmittalContent);
        $TransmittalContent = mb_convert_encoding($TransmittalContent, "HTML-ENTITIES", "UTF-8");
        $dompdf = new DOMPDF();
        $dompdf->load_html($TransmittalContent);
        $dompdf->set_paper("letter", "portrait");
        $dompdf->render();
        $pdf_contents = $dompdf->output();
        $temptransFile = '_Tranmittal'.round(microtime(true)*1000).'.pdf';
        $tempFilePath = $tempDir . $temptransFile;
        file_put_contents($tempFilePath, $pdf_contents);
        /*Merge attach pdfs*/
        if (!empty($arrTransPdfFiles)) {

                // Put the cover sheet first in the list
                array_unshift($arrTransPdfFiles, $temptransFile);

                $finalTempFileName = '_Transmittal'.round(microtime(true)*500).'.pdf';
                Pdf::merge($arrTransPdfFiles, $tempDir, $finalTempFileName);

                $tempFilePath = $tempDir.$finalTempFileName;

            }
            $cur_date=date('Y-m-d_A');
            $virtual_file_name_transmittal='Delay_Notice'.$cur_date.'.pdf';
        $sha1 = sha1_file($tempFilePath);
        $size = filesize($tempFilePath);
        $fileExtension = 'pdf';
        $virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);
        $tmpFileManagerFile = new FileManagerFile($database);
        $tmpFileManagerFile->virtual_file_name = $virtual_file_name_transmittal;
        $virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();

        $file = new File();
        $file->sha1 = $sha1;
        $file->name = $virtual_file_name;
        $file->size = $size;
        $file->type = $virtual_file_mime_type;
        $file->tempFilePath = $tempFilePath;
        $file->fileExtension = $fileExtension;
         // Save the pdf into cloud
        $file_location_id = FileManager::saveUploadedFileToCloud($database, $file);

        // save the file information to the file_manager_files db table
        $fileManagerFile = FileManagerFile::findByVirtualFileName($database, $userCompanyId, $currentlyActiveContactId, $projectId, $file_manager_folder_trans_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
            /* @var $fileManagerFile FileManagerFile */

        $file_manager_file_id = $fileManagerFile->file_manager_file_id;
        FileManagerFile::restoreFromTrash($database,$file_manager_file_id);
         // Potentially update file_location_id
        if ($file_location_id <> $fileManagerFile->file_location_id) 
        {
            $fileManagerFile->file_location_id = $file_location_id;
            $data = array('file_location_id' => $file_location_id);
            $fileManagerFile->setData($data);
            $fileManagerFile->save();
        }
        $transmittal_attachMentFile = $fileManagerFile->generateUrl(true);
        // Set Permissions of the file to match the parent folder.
        $parent_file_manager_folder_id = $fileManagerFolder_trans->getParentFolderId();
        FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_trans_id, $parent_file_manager_folder_id);
        FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_trans_id);

        }
        /*delete temp files*/
        unlink($LogoDestination);
        foreach($deleteTempPhoto as $deletefileName){
            unlink($deletefileName);
        }

        if(!empty($file_manager_file_id) && !empty($delayId)){
            updateFileManagerId($database, $delayId, $file_manager_file_id);
        }
        // Mail Send functionality
        if($methodType == '1' )
        {
            // for file size greater than 17 mb
            $filemaxSize=Module::getfilemanagerfilesize($delayFileId,$database);
            if(!$filemaxSize)
            {

            if (strpos($attachMentFile,"?"))
            {
                $virtual_file_name_url = $attachMentFile."&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
            }else
            {
                $virtual_file_name_url = $attachMentFile."?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
            }
            $delayPDF="<br><table style=width:80%;> 
            <tr>
            <td style='padding:2px;'>Please find the Delay PDF File Link:</td>
            <td style='padding:2px;'><a href='".$virtual_file_name_url."'>$delayFileName</a></td></tr>
            </table><br>";
            }else
            {
               $delayPDF="" ;
            }
            //End of file size

            $fromuserInfo = Contact::findContactByUserCompanyIdAndUserId($database,$userCompanyId ,$userId);
            $fromUsername = $fromuserInfo['first_name'].' '.$fromuserInfo['last_name'];
            $fromEmail = $fromuserInfo['email'];

            $mailToQuery = "SELECT email,first_name,last_name FROM contacts where id='$emailTo'  limit 1 ";
            $delayDb->execute($mailToQuery);
            $mailToResult = array();
            while($row = $delayDb->fetch())
            {
                $mailToResult[] = $row;
            }
            $delayDb->free_result();
            $mailToEmail = $mailToResult[0]['email']; 
            $mailToName = $mailToResult[0]['first_name'].' '.$mailToResult[0]['last_name']; 
            if($mailToName == ' ')
                $mailToName = $mailToEmail;
            //Mail Body 
            $greetingLine = 'Hi '.$mailToName.',<br><br>';

            //To generate logo
            $uri = Zend_Registry::get('uri');
            if ($uri->sslFlag) {
                $cdn = 'https:' . $uri->cdn;
            } else {
                $cdn = 'http:' . $uri->cdn;
            }
         
           $main_company = Project::ProjectsMainCompany($database,$projectId);
            require_once('lib/common/Logo.php');
           $mail_image = Logo::logoByUserCompanyIDforemail($database,$main_company);
           if($mail_image !=''){
            $logodata="<td style=width:55%;>
            <a href='".$uri->https."login-form.php'><img style='border: 0; float: left;'  border=0 src='".$cdn.$mail_image."'></a>
            </td>";
           }
            $companyLogoData="
            <table style=width:100%;>
            <tbody>
            <tr>
            $logodata
            <td style='width:45%;' align='right'>
            <a href='".$uri->https."login-form.php'><img style='border: 0; border: none;float: right;' width='200' height='50' border='0' src='".$cdn."images/logos/fulcrum-blue-icon-silver-text.gif' alt=Fulcrum Construction Management Software></a>
            </td>
            </tr>
            </tbody>
            </table>
            <div style='margin:5px 0 0;float: left;'></div>
<div style='margin: 5px 0 0; text-align: right;'><small style='color: #666666;font-size: 13px;'>Construction Management Software</small></div>
            $delayPDF
";
            
            $htmlAlertMessageBody = <<<END_HTML_MESSAGE
            $greetingLine$mailText
            <br><span style="margin:2%"></span>
            $companyLogoData
            $htmlMailContent
END_HTML_MESSAGE;

        $sendEmail = 'Alert@MyFulcrum.com';
        $sendName = ($fromUsername !=" ") ? $fromUsername : "Fulcrum Message";

            $mail = new Mail();
            $mail->setBodyHtml($htmlAlertMessageBody, 'UTF-8', Zend_Mime::MULTIPART_RELATED);
            $mail->setFrom($sendEmail, $sendName);
            $mail->addTo($mailToEmail, $mailToName);
            $mail->addHeader('Reply-To',$fromEmail);
            $mail->setSubject('Delay Transmittal');
            if($filemaxSize)
            {
            if (strpos($attachMentFile, '?')) {
                $separator = '&';
            } else {
                $separator = '?';
            }
            $attachMentFile = $attachMentFile .$separator. 'id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
             if(!empty($fileAttachments))
                $fileContents = file_get_contents($attachMentFile);
            else
                $fileContents = $pdf_content;
            $mail->createAttachment($virtual_file_name_tmp, $fileContents);
            }
            foreach($arrayMailAttach as $fileIds => $array){
                $file_manager_file_id = $array['file_manager_file_id'];
                $virtual_file_name = $array['virtual_file_name'];
                $fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
                $cdnFileUrl = $fileManagerFile->generateUrlBasePath(true);
                $fileContentsAta = file_get_contents($cdnFileUrl);
                $mail->createAttachment($virtual_file_name, $fileContentsAta);
            }            

            if(!empty($ccValues)){
                foreach($ccValues as $ccValue){
                    $mailCcQuery = "SELECT email,first_name,last_name FROM contacts where id='$ccValue'  limit 1 ";
                    $delayDb->execute($mailCcQuery);
                    $mailCcResult = array();
                    while($row = $delayDb->fetch())
                    {
                        $mailCcResult[] = $row;
                    }
                    $delayDb->free_result();
                    $mailCcEmail = $mailCcResult[0]['email']; 
                    $mailCcName = $mailCcResult[0]['first_name'].' '.$mailCcResult[0]['last_name']; 
                    $mail->addCc($mailCcEmail,$mailCcName);
                }
            }
            if(!empty($bccValues)){
                foreach($bccValues as $bccValue){
                    $mailBCcQuery = "SELECT email,first_name,last_name FROM contacts where id='$bccValue'  limit 1 ";
                    $delayDb->execute($mailBCcQuery);
                    $mailBCcResult = array();
                    while($row = $delayDb->fetch())
                    {
                        $mailBCcResult[] = $row;
                    }
                    $delayDb->free_result();
                    $mailBCcEmail = $mailBCcResult[0]['email']; 
                    $mailBCcName = $mailBCcResult[0]['first_name'].' '.$mailBCcResult[0]['last_name']; 
                    $mail->addBcc($mailBCcEmail, $mailBCcName);
                }
            }
            $mail->send();
                    
            }
            // Delete temp files
            if(!empty($fileAttachments))
                $fileObject->rrmdir($tempDir);
            //To delete the img
            $config = Zend_Registry::get('config');
            $file_manager_back = $config->system->base_directory;
            $file_manager_back =$file_manager_back.'www/www.axis.com/';
            $path=$file_manager_back.$mail_image;
            unlink($path);
            
            echo $status; 
    }     
}


    function findNextdelaySequenceNumber($database, $project_id)
    {
        $next_delay_sequence_number = 1;

        $db = DBI::getInstance($database);
        /* @var $db DBI_mysqli */

        $query =
"
SELECT MAX(d.delay_sequence_number) AS 'max_delay_sequence_number'
FROM `jobsite_delay_data` d
WHERE d.`project_id` = ?
";
        $arrValues = array($project_id);
        $db->execute($query, $arrValues, MYSQLI_USE_RESULT);

        $row = $db->fetch();
        $db->free_result();

        if ($row) {
            $max_delay_sequence_number = $row['max_delay_sequence_number'];
            $next_delay_sequence_number = $max_delay_sequence_number + 1;
        }

        return $next_delay_sequence_number;
    }
    function findDelaySequenceNumber($database, $project_id,$delayid)
    {

        $db = DBI::getInstance($database);
        /* @var $db DBI_mysqli */

        $query ="SELECT delay_sequence_number as sequence_number FROM `jobsite_delay_data` d WHERE d.`project_id` = ? and id= ?";
        $arrValues = array($project_id,$delayid);
        $db->execute($query, $arrValues, MYSQLI_USE_RESULT);

        $row = $db->fetch();
        $db->free_result();

        if ($row) {
            $sequence_number = $row['sequence_number'];
            
        }

        return $sequence_number;
    }
    
?>
