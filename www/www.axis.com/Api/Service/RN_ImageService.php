<?php

function ImageAttachmentToPDF($database,$photoAddPdf,$urlDirectory,$outputDirectory)
{
	 /*config path get*/
    $config = Zend_Registry::get('config');
    $basedircs = $config->system->file_manager_base_path;
    $basepathcs = $config->system->file_manager_backend_storage_path;
    $file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
    $baseDirectory = $config->system->base_directory;

	$PhotoHtmlContents = '';
    $deleteTempPhoto = array();
    $count = count($photoAddPdf);
    $i = 0;
    foreach($photoAddPdf as $photoAttachPDf){
       $photoAttachPDfId = $photoAttachPDf['file_manager_file_id'];
        $photoAttachPDfIdName = $photoAttachPDf['virtual_file_name'];
        $fileManagerfile = FileManagerFile::findById($database, $photoAttachPDfId);

        $file_location_id = Data::parseInt($fileManagerfile->file_location_id);
        $arrPath = str_split($file_location_id, 2);
        $fileName = array_pop($arrPath);
        $shortFilePath = '';
        $path = '';
        foreach ($arrPath as $pathChunk) {
            $path .= $pathChunk.'/';
            $shortFilePath .= $pathChunk.'/';
        }
       $filename=$basedircs.$basepathcs.$shortFilePath.$file_manager_file_name_prefix.$fileName;
                  /*Resize image start*/
        $jobsitePhotoUrlsize = $filename;
        $path = ($jobsitePhotoUrlsize);
        $tempFileNamePhoto = '_temp'.round(microtime(true)*1000);
        // echo "des : ".   $destination = $outputDirectory.$tempFileNamePhoto;
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
            $fileObject = new File();
            $fileObject->mkdir($outputDirectory, 0777);
            resize($path,$destination,$newWidth,$newHeight);
            $data = file_get_contents($destination);
    		//unlink($destination);
        }else{
            resize($path,$destination,$width,$height);
             $data = file_get_contents($jobsitePhotoUrlsize);
             unlink($destination);
        }
       
        $base64 = 'data:image;base64,' . base64_encode($data);  
        $jobsitePhotoHtml = '<img alt="Jobsite Photo" align="center" src="'.$base64.'">';
   
        $countStyle = $i == 0 ? "<h4>Attached Photos($count)</h4>" : '';
         $PhotoHtmlContents.= <<<END_HTML_CONTENT
        <div style="margin-bottom:10px 0;backgound:#f0f0f0;page-break-before: always !important;" class="ImgPreviewImagecenter">
       $countStyle
        <section style="padding: 1px;"  class="ImgPreviewTableHeader">$photoAttachPDfIdName</section>
        $jobsitePhotoHtml
        </div>
END_HTML_CONTENT;
        $i++;
    }

    if($PhotoHtmlContents!='')
    {
        if($count > 0){
            $counthead="<h4>Attached Photos($count)</h4>";
        }else{
            $counthead='';
        }
        $resultPhotoHtmlContent = <<<HtmlPhos
        <div class="ImgPreviewTable" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:0;padding-bottom     :0;" >
        $PhotoHtmlContents
        </div>
HtmlPhos;
    }else{
        $resultPhotoHtmlContent='';
    }
    return $resultPhotoHtmlContent;
}

function resizeImage($SrcImage,$DestImage, $thumb_width,$thumb_height,$Quality)
{
    list($width,$height,$type) = getimagesize($SrcImage);
    switch(strtolower(image_type_to_mime_type($type)))
    {
        case 'image/gif':
            $NewImage = imagecreatefromgif($SrcImage);
            break;
        case 'image/png':
            $NewImage = imagecreatefrompng($SrcImage);
            break;
        case 'image/jpeg':
            $NewImage = imagecreatefromjpeg($SrcImage);
            break;
        default:
            return false;
            break;
    }
    $original_aspect = $width / $height;
    $positionwidth = 0;
    $positionheight = 0;
    if($original_aspect > 1)    {
        $new_width = $thumb_width;
        $new_height = $new_width/$original_aspect;
        while($new_height > $thumb_height) {
            $new_height = $new_height - 0.001111;
            $new_width  = $new_height * $original_aspect;
            while($new_width > $thumb_width) {
                $new_width = $new_width - 0.001111;
                $new_height = $new_width/$original_aspect;
            }

        }
    } else {
        $new_height = $thumb_height;
        $new_width = $new_height/$original_aspect;
        while($new_width > $thumb_width) {
            $new_width = $new_width - 0.001111;
            $new_height = $new_width/$original_aspect;
            while($new_height > $thumb_height) {
                $new_height = $new_height - 0.001111;
                $new_width  = $new_height * $original_aspect;
            }
        }
    }
    if($width < $new_width && $height < $new_height){
        $new_width = $width;
        $new_height = $height;
        $positionwidth = ($thumb_width - $new_width) / 2;
        $positionheight = ($thumb_height - $new_height) / 2;
    }elseif($width < $new_width && $height > $new_height){
        $new_width = $width;
        $positionwidth = ($thumb_width - $new_width) / 2;
        $positionheight = 0;
    }elseif($width > $new_width && $height < $new_height){
        $new_height = $height;
        $positionwidth = 0;
        $positionheight = ($thumb_height - $new_height) / 2;
    } elseif($width > $new_width && $height > $new_height){
        if($new_width < $thumb_width) {
            $positionwidth = ($thumb_width - $new_width) / 2;
        } elseif($new_height < $thumb_height) {
            $positionheight = ($thumb_height - $new_height) / 2;
        }
    }
    // $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
    /*custome change for remove the back black */
    $thumb = imagecreatetruecolor( $new_width, $new_height );

    /********************* FOR WHITE BACKGROUND  *************************/
        //$white = imagecolorallocate($thumb, 255,255,255);
        //imagefill($thumb, 0, 0, $white);
    if(imagecopyresampled($thumb, $NewImage, 0, 0,0, 0, $new_width, $new_height, $width, $height)) {
        if(imagejpeg($thumb,$DestImage,$Quality)) {
            imagedestroy($thumb);
            return true;
        }
    }
}
 function resize($source,$destination,$newWidth,$newHeight)
{
    ini_set('max_execution_time', 0);
    $ImagesDirectory = $source;
    $DestImagesDirectory = $destination;
    $NewImageWidth = $newWidth;
    $NewImageHeight = $newHeight;
    $Quality = 100;
    $imagePath = $ImagesDirectory;
    $destPath = $DestImagesDirectory;
    $checkValidImage = getimagesize($imagePath);

    if(file_exists($imagePath) && $checkValidImage)
    {
        if(resizeImage($imagePath,$destPath,$NewImageWidth,$NewImageHeight,$Quality))
            return 'resize success';
        else
            return 'resize failes';
    }
}
