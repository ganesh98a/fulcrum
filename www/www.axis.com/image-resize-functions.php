<?php
/*resize the image*/
function resizeImage($SrcImage,$DestImage, $thumb_width,$thumb_height,$Quality,$back)
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
    if($back){
        $white = imagecolorallocate($thumb, 255,255,255);
        imagefill($thumb, 0, 0, $white);
    }        
    if(imagecopyresampled($thumb, $NewImage, 0, 0,0, 0, $new_width, $new_height, $width, $height)) {
        if(imagejpeg($thumb,$DestImage,$Quality)) {
            imagedestroy($thumb);
            return true;
        }
    }
}
function resize($source,$destination,$newWidth,$newHeight, $back =  false)
{
    // ini_set('max_execution_time', 0);
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
        if(resizeImage($imagePath,$destPath,$NewImageWidth,$NewImageHeight,$Quality,$back))
            return 'resize success';
        else
            return 'resize failes';
    }
}
