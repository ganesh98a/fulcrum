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
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/Data.php');

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

require_once('lib/common/ImageManagerImage.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		// require_once('jobsite_photos-functions.php');
	}
}

// SESSION VARIABLES
/* @var $session Session */
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
	case 'LoadLogo':
	$logoDelete = $get->logoDelete;
	$deleteFlag = $get->deleteFlag;
	$image_manager_image_id = $get->image_manager_image_id;
	$imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);
	$cdnFileUrl = $imageManagerImage->generateUrl();
	$virtual_file_name = $imageManagerImage->virtual_file_name;
	echo $liUploadedFieldReports .= <<<END_LI_UPLOADED_FIELD_REPORTS
	<li>
		<a onclick="deleteLogoPhoto('$image_manager_image_id');" style="cursor:pointer;" class="entypo-cancel-circled"></a>
		<a href="$cdnFileUrl" target="_blank">$virtual_file_name</a>
	</li>
END_LI_UPLOADED_FIELD_REPORTS;
	$errorNumber = 0;
	$errorMessage = 'Logo Upload Successfully.';
	break;

	case 'deleteJobsitePhoto':

	$crudOperation = 'delete';
	$errorNumber = 0;
	$errorMessage = '';

	try {
		$image_manager_image_id = $get->image_manager_image_id;
		$cur_manager_file_id = $get->cur_manager_file_id;
		if($cur_manager_file_id == $image_manager_image_id)
		{
			$errorMessage = 'Image already exist';
        	$message->enqueueError($errorMessage, $currentPhpScript);
        	$arrJsonOutput = array(
        		'error' => $errorMessage
        		);
        	$ajaxError = json_encode($arrJsonOutput);
        	exit($ajaxError);

		}
		$imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);
		$cdnFileUrl = $imageManagerImage->generateUrl(true);
		$virtual_file_name = $imageManagerImage->virtual_file_name;
		$file_location_id = $imageManagerImage->file_location_id;
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
	    $file_name = $file_location_id;
		$file_location_id = Data::parseInt($file_location_id);
			$arrPath = str_split($file_location_id, 2);
			$fileName = array_pop($arrPath);
			$shortFilePath = '';
			foreach ($arrPath as $pathChunk) {
				$path .= $pathChunk.'/';
				$shortFilePath .= $pathChunk.'/';
			}
			$config = Zend_Registry::get('config');
			$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
			$basedircs = $config->system->file_manager_base_path;
			$basepathcs = $config->system->file_manager_backend_storage_path ;
			$filename=$basedircs.$basepathcs.$shortFilePath.$file_manager_file_name_prefix.$fileName;
			$pdfPhantomJS = new PdfPhantomJS();
			$target = $pdfTempFileUrl = $pdfPhantomJS->getTempFileBasePath();
			$file = $jobsitePhotoUrl;
			/*Resize image start*/
			$jobsitePhotoUrlsize = $filename;
		    $path= realpath($jobsitePhotoUrlsize);

		$db->begin();
		$query = "Delete ".
		"FROM `file_locations` ".
		"WHERE `id` = $file_location_id ";
		$db->execute($query);
		$db->commit();
		$db->free_result();

		$db->begin();
		$query =
			"DELETE FROM `contacts_to_logo` WHERE image_manager_image_id = $image_manager_image_id";
		$db->execute($query);
		$db->commit();
		$db->free_result();
		echo $liUploadedFieldReports .= <<<END_LI_UPLOADED_FIELD_REPORTS
	<li id="liUploadedPhotoPlaceholder">
		Not Yet Uploaded
	</li>
END_LI_UPLOADED_FIELD_REPORTS;
	} catch (Exception $e) {
		// $db->rollback();
		$db->free_result();
	}

	break;

	case 'saveJobsitePhoto':

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
