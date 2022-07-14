<?php 
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');
require_once('lib/common/File.php');

if(isset($_GET))
{
	if((isset($_GET['method'])) && $_GET['method'] =="uploadimgforesign")
	{
		$type= (isset($_GET['type']))?$_GET['type']:"";
		$tempDirectoryPrefix="";
		$arrFiles = File::parseUploadedFiles($tempDirectoryPrefix);
		if (empty($arrFiles)) {

			$message->enqueueError('Please upload a valid file.', 'modules-file-manager-file-browser.php');

		}
		if (!empty($arrFiles)) {
			$arrFilesMetaData = array();
			foreach ($arrFiles as $file) {
				$tmpFileError = $file->error;
				$fileExtension = $file->fileExtension;
				$actualFileName = rawurldecode($file->name);
				$fileSha1 = $file->sha1;
				$tmpFileSize = $file->size;
				$tmpFilePath = $file->tempFilePath;
				$tmpFileName = $file->tmp_name;
				$fileType = $file->type;

				$path= realpath($tmpFilePath);
				$info   = getimagesize($path);
        	$mime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
        	$width  = $info[0]; // width as integer for ex. 512
        	$height = $info[1]; // height as integer for ex. 384
        	// $type   = $info[2];      // same as exif_imagetype
        	$checkDeleteFlag = 'N';
        	// print_r($info);
        	if($width < 150 || $width > 500){
        		$checkDeleteFlag = 'Y';
        	}
        	if($height < 40 || $height > 100){
        		$checkDeleteFlag = 'Y';
        	}
        	if($checkDeleteFlag == 'Y'){
        		$errorMessage = 'Size is '.$width.'x'.$height.', upload valid image size. Image size allowed from 150x40 to 500x100';
        		unlink($tmpFilePath);
        		// $message->enqueueError($errorMessage, $currentPhpScript);
        		$arrJsonOutput = array(
        			'error' => $errorMessage
        		);
        		$ajaxError = json_encode($arrJsonOutput);
        		exit($ajaxError);
        	}
        }

        $imagedata = file_get_contents($tmpFilePath);
			// Delete temp file if it is still present
        if (is_file($tmpFilePath)) {
				//
        	$fileDeletedFlag = unlink($tmpFilePath);
        }
        
    }
}
	$contact_id ="";
	if(isset($_GET['contact_id']))
	{
		$contact_id = $_GET['contact_id'];
	}
}
if(isset($_POST))
{

	$imagedata = base64_decode($_POST['img_data']);
	$type= $_POST['type'];
	$contact_id ="";
	if(isset($_POST['contact_id']))
	{
		$contact_id = $_POST['contact_id'];
	}
}
		$result = array();

		if($contact_id !="")
		{
			$currentlyActiveContactId = $contact_id;
		}else
		{
		$session = Zend_Registry::get('session');
		$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
		}
		$filename = md5($currentlyActiveContactId);
			// echo "id : ".$filename;

		$config = Zend_Registry::get('config');	
		$file_manager_base_path = $config->system->file_manager_base_path;
		$save = $file_manager_base_path.'backend/procedure/';
		$fileObject = new File();
		$fileObject->mkdir($save, 0777);
			//Location to where you want to created sign image
		$signfile_name = $save.$filename.'.png';
		file_put_contents($signfile_name,$imagedata);
		$result['status'] = 1;
		$result['file_name'] = $signfile_name;
		$result['file_path'] = $signfile_name;

		$db = DBI::getInstance($database);
		$query ="Select * from  signature_data where `contact_id`= ?";
		$arrValues = array($currentlyActiveContactId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if($row)
		{
			$query ="Update  signature_data set `count`=count+1,`type`=? where `contact_id`= ?";
			$arrValues = array($type,$currentlyActiveContactId);
			$db->execute($query, $arrValues);
			$db->free_result();
		}else{
			$query ="INSERT into signature_data (`contact_id`, `count`,`type`)  Values (?, ?, ?)";
			$arrValues = array($currentlyActiveContactId,'1',$type);
			$db->execute($query, $arrValues);
			$db->free_result();
		}
		$query ="Select `date` from  signature_data where `contact_id`= ?";
		$arrValues = array($currentlyActiveContactId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$updated_date =$row['date'];
		if($updated_date !="")
		{
			$dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $updated_date);
			$updated_date = $dateObj->format('m/d/Y');
		}
		$db->free_result();


		$filegetcontent = file_get_contents($signfile_name);
		$base64 = 'data:image;base64,' . base64_encode($filegetcontent);
		if(isset($_POST))
		{

			echo $base64.'~'.$updated_date;
		}
		if(isset($_GET))
		{
			$arrJsonOutput = array(
				'success' => 'File upload successful.',
				'fileMetadata' => $base64
			);
			$ajaxMessage = json_encode($arrJsonOutput);
			echo $ajaxMessage;
		}

?>
