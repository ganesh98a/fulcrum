<?php
$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;


require_once('lib/common/init.php'); 
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Mail.php');
require_once('lib/common/Contact.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/ContractingEntities.php');
require_once('page-components/fileUploader.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('transmittal-functions.php'); 
require_once('lib/common/Module.php');

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
    $TransmittalId = $formValues['TransmittalId'];           // Get the Transmittal id for check new Transmittal or update Transmittal 

    $type               =   $formValues['transmitalTypeId'];
    $comments              = $formValues['commentsId'];
    $mailText           =   $formValues['mailText'];
    $attachments        =   $formValues['attachments'];
    $fileAttachments    =   json_decode($attachments);
    $emailTo            =   $formValues['emailTo'];
    $methodType         =   $formValues['methodType'];
    $file_attachement_id =$formValues['file_attachement_id'];
    $subject            =   $formValues['subject'];
    $comments           = nl2br(htmlentities(trim($comments)));
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
    $typeQuery = "SELECT transmittal_category FROM transmittal_types where id='$type' limit 1 ";
    $delayDb->execute($typeQuery);
    $typeResult = array();
    while($row = $delayDb->fetch())
    {
        $typeResult[] = $row;
    }
    $typeName = $typeResult[0]['transmittal_category'];
    $delayDb->free_result();
    
    $curdate=date('Y-m-d');
    $status="0";
    $pdf_contents='';
    // To include contracting Entity
    $contract_entity_id = ContractingEntities::getcontractEntityAgainstProject($database,$projectId);

    if(isset($TransmittalId) && !empty($TransmittalId)){    // Update the Transmittal

        $query="UPDATE transmittal_data SET transmittal_type_id=?,project_id=?,contracting_entity_id=?,comment=?,updated_by=?,updated_on=? WHERE id=?";
        $arrValues = array($type,$projectId,$contract_entity_id,$comments,$currentlyActiveContactId,$curdate,$TransmittalId);
        if($delayDb->execute($query,$arrValues)){
            $status = '2';
        }  
        $delayDb->free_result();
        //For pdf Generation
         $config = Zend_Registry::get('config');
        // for pdf
        $pdfBasePath_before = $config->system->image_upload_path;
        $previous_attachment =$formValues['previous_attachment'];
        $pdf_image_data=explode('images/', $pdfBasePath);
        $pdf_image=$pdf_image_data[0].'/'.$TransmittalTemp.'/'; 

        if(strpos($previous_attachment, ','))
                {
                    $previous_attachment_values=explode(',', $previous_attachment);
                }else
                {
                    $previous_attachment_values=array('0'=>$previous_attachment);
                }
       
        $query1="SELECT * from transmittal_attachments WHERE transmittal_data_id='$TransmittalId' order by id Asc";
        $delayDb->execute($query1);
        $i=0;
        while($row1 = $delayDb->fetch())
        {
            $val = '00000.'.$row1['attachment_file_manager_file_id'].'.pdf';
            $pdf_filepath_prev=$pdfBasePath_before.$val;
             $content=pdfdata($pdf_filepath_prev);
             $content = html_entity_decode($content);
             $content = mb_convert_encoding($content, "HTML-ENTITIES", "UTF-8");
             $pdf_contents .="$previous_attachment_values[$i]<br>".$content;
            $i++;
        }
         $delayDb->free_result();
    }
    else{
        // Insert the transmittal
        $sequence_no = getSequenceNumberForTransmittals($database, $projectId);

        $query = "INSERT INTO transmittal_data(sequence_number, transmittal_type_id,project_id,contracting_entity_id,comment,raised_by,mail_to,mail_content,subject) VALUES(?,?,?,?,?,?,?,?,?)";
        $arrValues = array($sequence_no,$type,$projectId,$contract_entity_id,$comments,$currentlyActiveContactId,$emailTo,$mailText,$subject);

        if($delayDb->execute($query,$arrValues)){
            $TransmittalId = $delayDb->insertId; 
            $status = '1';
        }
        $delayDb->free_result();
      
    }


    if($status)
    {

        // Naming Convention of Virtual File path for upload attachments
       
            $virtual_file_path = 'Transmittals/Transmittal #' . $sequence_no . '/';
       

        $arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
        $currentVirtualFilePath = '/';
 
        foreach ($arrFolders as $folder) {
            $tmpVirtualFilePath = array_shift($arrFolders);
            $currentVirtualFilePath .= $tmpVirtualFilePath.'/';
            // Save the file_manager_folders record (virtual_file_path) to the db and get the id
            $fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $userCompanyId, $currentlyActiveContactId, $projectId, $currentVirtualFilePath);
        }
        /* @var $fileManagerFolder FileManagerFolder */

        // Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
        $file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

        $config = Zend_Registry::get('config');
        $file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
        $fileManagerBasePath = $config->system->file_manager_base_path;
        $tempFileName = File::getTempFileName();
        $tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
        $fileObject = new File();
        $fileObject->mkdir($tempDir, 0777);
        // for pdf
        $pdfBasePath = $config->system->image_upload_path;
         $pdf_image_data=explode('images/', $pdfBasePath);
         $pdf_image=$pdf_image_data[0].'/'; 

        // Insert the file attachements and move to virtual file path directory
        $counter = 2;
        $skipOne = false;
        $arrPdfFiles = array();
        $pdfPageCount = 0;
        $tempFilePath='';
        $pdf_total_num='';
        $indexVal=0;
        if(!empty($fileAttachments))
        {    
	    $tsort=0;   
            foreach($fileAttachments as $key => $fileAttachment)
            {

                //newly added 
                if ($skipOne) {
                    $skipOne = false;
                    continue;
                }

                //End of newly added
                $attachmentSql = "INSERT INTO transmittal_attachments(attachment_file_manager_file_id,transmittal_data_id,sort_order) VALUES('$fileAttachment','$TransmittalId','$tsort')";
                $delayDb->execute($attachmentSql);
                $delayDb->free_result();
                $tsort++;

                $fileManagefile = FileManagerFile::findById($database, $fileAttachment);
                $oldData = $fileManagefile;
                $data = array(
                    'file_manager_folder_id' => $file_manager_folder_id
                );
                $fileManagefile->setData($data);
                $fileManagefile->save();    // Update the new folder
            

                // Filename extension
                $tempDelayAttachmentFileExtension = $fileManagefile->getFileExtension();
                $tempDelayAttachmentFileExtension = strtolower($tempDelayAttachmentFileExtension);
                // Skip all but pdf for now
               

                $fileNamePrefix = str_pad($counter, 5, '0', STR_PAD_LEFT);
                $tempAttachmentFileName = $fileNamePrefix . '.' . $fileManagefile->file_manager_file_id . '.' . $tempDelayAttachmentFileExtension;
                $tempFilePath = $tempDir.$tempAttachmentFileName;
                $file_location_id = $fileManagefile->file_location_id;

                // @todo Add png / image to pdf functionality
              $tempPdfFile = $tempAttachmentFileName;

             
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

                // For pdf content attachment 
                 /*attachment name array*/
                $PDFMergeFormatArray = array('0'=>'PDF','1'=>'pdf');
                if(in_array($tempDelayAttachmentFileExtension,$PDFMergeFormatArray))
                if ($statusFlag) {
                    $arrPdfFiles[] = $tempPdfFile;
                    //To get the page Count for pdf
                $pdf_page_file=$tempDir.$tempPdfFile;
                $cc= exec("identify -format %n $pdf_page_file");
                $pdf_total_num=$pdf_total_num+$cc;
                    }
                $counter++;
                // End of pdf Content 

              
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
          
        // make Transmittal directory for pdf upload
        $tempFileName = File::getTempFileName();
        $up_path=$fileManagerBasePath.$virtual_file_path;
        $up_path=rtrim($up_path,'/');
        chmod($up_path, 0777);
        chmod($tempDir, 0777);
        // Naming convention for pdf
        $cur_date=date('Y-m-d_A');
        $typeName = str_replace(" ","_",$typeName);
      $typeName = str_replace("'","",$typeName);
      if(strpos($typeName, '('))
      {
        $typeName_data=explode('(', $typeName);
        $typeName=$typeName_data[0];
      }
      $typeName;
        $virtual_file_name_tmp = $typeName.$cur_date.'.pdf';
       

        $counter = 2;
        // mail Body
        $mailContent = buildTransmittalAsHtmlForPdfConversion($database, $userCompanyId,'', $TransmittalId,$projectName,$projectId,$mailText,$pdf_contents,$pdf_total_num);
        $mailContent= html_entity_decode($mailContent);
        $mailContent = mb_convert_encoding($mailContent, "HTML-ENTITIES", "UTF-8");
 
         //End to get pdf page count
         $htmlContent = buildTransmittalAsHtmlForPdfConversion($database, $userCompanyId, $jobsitePhotoHtmlContent, $TransmittalId,$projectName,$projectId,$mailText,'',$pdf_total_num,$headerLogo,'1');
        $htmlContent = html_entity_decode($htmlContent);
        $htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");
        $dompdf = new DOMPDF();
        $dompdf->load_html($htmlContent);
        $dompdf->set_paper("letter", "portrait");
        $dompdf->render();
        $pdf_content = $dompdf->output();
        $tempPdfFile = '000001'.round(microtime(true)*500).'.pdf';
        $tempFilePath = $tempDir . $tempPdfFile;

        file_put_contents($tempFilePath, $pdf_content); // save pdf to temp folder
        $cc1= exec("identify -format %n $tempFilePath");
        $pdf_total_num=$pdf_total_num+$cc1;
         $htmlContent = buildTransmittalAsHtmlForPdfConversion($database, $userCompanyId, $jobsitePhotoHtmlContent, $TransmittalId,$projectName,$projectId,$mailText,'',$pdf_total_num,$headerLogo,'1');
        $htmlContent = html_entity_decode($htmlContent);
        $htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");
        $dompdf = new DOMPDF();
        $dompdf->load_html($htmlContent);
        $dompdf->set_paper("letter", "portrait");
        $dompdf->render();
        $pdf_content = $dompdf->output();
        $tempPdfFile = '000001'.round(microtime(true)*500).'.pdf';
        $tempFilePath = $tempDir . $tempPdfFile;

        file_put_contents($tempFilePath, $pdf_content);
        
        //newly added to merge pdf
        if (!empty($arrPdfFiles)) {
            // Put the cover sheet first in the list
            array_unshift($arrPdfFiles, $tempPdfFile);
            $finalTransmittalTempFileName = $virtual_file_name_tmp ;
            $finalTransmittalTempFilepath = $tempDir.$finalTransmittalTempFileName;
                // Merge the RFI pdf and all RFI attachments into a single RFI pdf document
            Pdf::merge($arrPdfFiles, $tempDir, $finalTransmittalTempFileName);
            $tempFilePath = $finalTransmittalTempFilepath;
        }
        //End of newly added to merge pdf
        $sha1 = sha1_file($tempFilePath);
        $size = filesize($tempFilePath);
        $fileExtension = 'pdf';
        $virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);
        $tmpFileManagerFile = new FileManagerFile($database);
        $tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
        $virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();

        // Final RFI pdf document        
        $tmpFileManagerFile = new FileManagerFile($database);
        $tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
        $transFileName = $virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();

        // Convert file content to File object
        $error = null;
        $file = new File();
        $file->sha1 = $sha1;
        $file->name = $virtual_file_name;
        $file->size = $size;
        $file->type = $virtual_file_mime_type;
        $file->tempFilePath = $tempFilePath;
        $file->fileExtension = $fileExtension;

        // Save the pdf into cloud
    $transmittalFileId =  $file_location_id = FileManager::saveUploadedFileToCloud($database, $file);
 
        // save the file information to the file_manager_files db table
        $fileManagerFile = FileManagerFile::findByVirtualFileName($database, $userCompanyId, $currentlyActiveContactId, $projectId, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
        //     /* @var $fileManagerFile FileManagerFile */

        $file_manager_file_id = $fileManagerFile->file_manager_file_id;

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
        foreach($deleteTempPhoto as $deletefileName){
            unlink($deletefileName);
        }
        $fileObject->rrmdir($tempDir);
        // Mail Send functionality
        if($methodType == '1')
        {

            // for file size greater than 17 mb
            $filemaxSize=Module::getfilemanagerfilesize($transmittalFileId, $database);
            if(!$filemaxSize)
            {

            if (strpos($attachMentFile,"?"))
            {
                $virtual_file_name_url = $attachMentFile."&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
            }else
            {
                $virtual_file_name_url = $attachMentFile."?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
            }
            $transPDF ="<table style=width:80%;> 
            <tr>
            <td style='padding:2px;'>Please find the Transmittal PDF File Link:</td>
            <td style='padding:2px;'><a href='".$virtual_file_name_url."'>$transFileName</a></td></tr>
            </table><br>";
            }else
            {
               $transPDF="" ;
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
            $transPDF";
            

            $htmlAlertMessageBody = <<<END_HTML_MESSAGE
            $greetingLine$mailText
            <br><span style="margin:2%"></span>
            $companyLogoData
            $mailContent
END_HTML_MESSAGE;
            $sendEmail = 'Alert@MyFulcrum.com';
            $sendName = ($fromUsername !=" ") ? $fromUsername : "Fulcrum Message"; 
            $mail = new Mail();
            $mail->setBodyHtml($htmlAlertMessageBody, 'UTF-8', Zend_Mime::MULTIPART_RELATED);
            $mail->setFrom($sendEmail, $sendName);
            $mail->addTo($mailToEmail, $mailToName);
            $mail->addHeader('Reply-To',$fromEmail);

            $mail->setSubject('Transmittal');
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
            foreach($arrayMailAttach as $fileIds => $array){
                $file_manager_file_id = $array['file_manager_file_id'];
                $virtual_file_name = $array['virtual_file_name'];
                $fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
                $cdnFileUrl = $fileManagerFile->generateUrlBasePath(true);
                $fileContentsAta = file_get_contents($cdnFileUrl);
                $mail->createAttachment($virtual_file_name, $fileContentsAta);
            }
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
?>
