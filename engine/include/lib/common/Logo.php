<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * A "Logo" is a unique way to identify a given Companies.
 *
 * GUIDS:
 * 	email
 * 	mobile_phone_number
 *
 * @category   Framework
 * @package    User
 */

/**
 * @see IntegratedMapper
 */
require_once('lib/common/ImageManagerImage.php');

class Logo extends IntegratedMapper
{
	/*static var fulcrum path*/
	public static $_fulcrumLogo = "images/logos/axis-green-white-background2.png";
	// public static $_fulcrumLogo = "images/home/splash-page-axis-logo-white.gif";
	/*static nolo image path*/
	public static $_nologo = "images/logos/nologo.png";
	
	/*Fetch logo id*/
	public static function filelocationID($database,$user_company_id){
		/*GC logo*/
		$db = DBI::getInstance($database);
		$db->begin();
		$query = "select ctl.*,imi.* ".
		"FROM `contacts_to_logo` ctl ".
		"INNER JOIN `image_manager_images` imi ON imi.id = ctl.image_manager_image_id ".
		"WHERE ctl.`user_company_id` = $user_company_id ";
		$db->execute($query);
		$row = $db->fetch();
		$image_manager_image_id = $row['image_manager_image_id'];
		$virtual_file_name = $row['virtual_file_name'];
		$file_location_id = $row['file_location_id'];
		$db->free_result();
		$Arry['image_manager_image_id'] = $image_manager_image_id;
		$Arry['file_location_id'] = $file_location_id;
		return $Arry;
	/*GC logo*/

	}
	/*get the logo file path in softlink format*/
	public static function logoByUserCompanyIDUsingSoftlink($database,$user_company_id){
		
		$ArrayLogoIDs = Logo::filelocationID($database,$user_company_id);
		$file_location_id = $ArrayLogoIDs['file_location_id'];
		$image_manager_image_id = $ArrayLogoIDs['image_manager_image_id'];
		if($image_manager_image_id!=''){
			$imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);
			$cdnFileUrl = $imageManagerImage->generateUrl(true);
			$gcLogo = $cdnFileUrl;
		}else{
			$uri = Zend_Registry::get('uri');
			/* @var $uri Uri */
			if($uri->sslFlag){
				$baseCdnUrl = $uri->https;
			}else{
				$baseCdnUrl = $uri->cdn_absolute_url;	
			}

			$nologo = self::$_nologo;
			$gcLogo="";
		}
		return $gcLogo;
	}	
	/*get the logo file path in softlink format*/
	public static function logoByUserCompanyIDUsingSoftlinkOnlyLink($database,$user_company_id){
		
		$ArrayLogoIDs = Logo::filelocationID($database,$user_company_id);
		$file_location_id = $ArrayLogoIDs['file_location_id'];
		$image_manager_image_id = $ArrayLogoIDs['image_manager_image_id'];
		if($image_manager_image_id!=''){
			$imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);
			$cdnFileUrl = $imageManagerImage->generateUrl(true);
			$gcLogo = <<<gcLogo
			<img src="$cdnFileUrl" style="margin-left:0px">
gcLogo;
		}else{
			$nologo = self::$_nologo;
			$gcLogo="";

		}
		return $gcLogo;
	}	
	/*get the logo file path from base format*/
	public static function logoByUserCompanyIDUsingBasePath($database,$user_company_id){
		/*Fetch ids*/
		$ArrayLogoIDs = Logo::filelocationID($database,$user_company_id);
		$file_location_id = $ArrayLogoIDs['file_location_id'];
		$image_manager_image_id = $ArrayLogoIDs['image_manager_image_id'];
		if($image_manager_image_id!=''){
			$imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);
			$config = Zend_Registry::get('config');
			// $file_manager_file_id = Data::parseInt($this->file_manager_file_id);
			$file_manager_base_path = $config->system->file_manager_base_path;
			$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
			$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
			$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;
			require_once('lib/common/FileManager.php');
			$arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
			$arrPath = $arrFilePath['file_path'].$arrFilePath['file_name'];
			$path = $arrPath;
			$filegetcontent = '';
			if (file_exists($path)) {
				$filegetcontent = file_get_contents($path);
			}
			$base64 = 'data:image;base64,' . base64_encode($filegetcontent);
			$gcLogo = <<<gcLogo
			<img src="$base64"  alt="Logo" style="margin-left:0px;" class="drawpdftoplogo">
gcLogo;
		}else{
			$nologo = self::$_nologo;
			$gcLogo="";

		}
		return $gcLogo;
	}

	/*get the logo file path to include in TCPDF*/
	public static function logoByUserCompanyIDForTCPDF($database,$user_company_id){
		/*Fetch ids*/
		$ArrayLogoIDs = Logo::filelocationID($database,$user_company_id);
		$file_location_id = $ArrayLogoIDs['file_location_id'];
		$image_manager_image_id = $ArrayLogoIDs['image_manager_image_id'];
		if($image_manager_image_id!=''){
			$imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);
			$config = Zend_Registry::get('config');
			// $file_manager_file_id = Data::parseInt($this->file_manager_file_id);
			$file_manager_base_path = $config->system->file_manager_base_path;
			$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
			$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
			$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;
			require_once('lib/common/FileManager.php');
			$arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
			$arrPath = $arrFilePath['file_path'].$arrFilePath['file_name'];
			$path = $arrPath;
			$filegetcontent = file_get_contents($path);
			
		}else{
			
			$filegetcontent="";

		}
		return $filegetcontent;
	}
	/*get the GC_logo for Excel*/
	public static function logoByUserCompanyIDforExcel($database,$user_company_id,$useAbsoluteCdnUrl)
	{
		$gcLogo_src =Logo::logoByUserCompanyIDforemail($database,$user_company_id);
		// Create URL to image or pdf on the CDN
		$useAbsoluteCdnUrl = (bool) $useAbsoluteCdnUrl;
		$baseCdnUrl='';
		$gcLogo ='';
		$uri = Zend_Registry::get('uri');
		/* @var $uri Uri */
		if ($useAbsoluteCdnUrl) {
			if($uri->sslFlag){
				$baseCdnUrl = $uri->https;
			}else{
				$baseCdnUrl = $uri->cdn_absolute_url;	
			}
		} else {
			$baseCdnUrl = $uri->cdn;
		}
		if($gcLogo_src !='')
		{
		$gcLogo = $baseCdnUrl.$gcLogo_src;
		}else
		{
			$gcLogo = "";
		}
		return $gcLogo;
	}

	/*get the logo file path from base format*/
	public static function logoByUserCompanyIDforemail($database,$user_company_id, $checkWithImage = false, $useAbsoluteCdnUrl = false){
		/*Fetch ids*/
		$ArrayLogoIDs = Logo::filelocationID($database,$user_company_id);
		$file_location_id = $ArrayLogoIDs['file_location_id'];
		$image_manager_image_id = $ArrayLogoIDs['image_manager_image_id'];
		if($image_manager_image_id!=''){
			$imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);
			$config = Zend_Registry::get('config');
			// $file_manager_file_id = Data::parseInt($this->file_manager_file_id);
			$file_manager_base_path = $config->system->file_manager_base_path;
			$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
			$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
			$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;
			$file_manager_back = $config->system->base_directory;
			require_once('lib/common/FileManager.php');
			$arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
			
			$arrPath = $arrFilePath['file_path'].$arrFilePath['file_name'];
			$path = $arrPath;
			$filegetcontent = file_get_contents($path);
 			
		    $save = $file_manager_back.'www/www.axis.com/images/logos/';
		   
		    $fileObject = new File();
		    $fileObject->mkdir($save, 0777);
		   	file_put_contents($save.'/'.$arrFilePath['file_name'].'.png', $filegetcontent);
		   	if($checkWithImage){
		   		// Create URL to image or pdf on the CDN
		   		$uri = Zend_Registry::get('uri');
		   		/* @var $uri Uri */
		   		if ($useAbsoluteCdnUrl) {
		   			if($uri->sslFlag){
		   				$baseCdnUrl = $uri->https;
		   			}else{
		   				$baseCdnUrl = $uri->cdn_absolute_url;	
		   			}
		   		} else {
		   			$baseCdnUrl = $uri->cdn;
		   		}
		   		$logo = 'images/logos/'.$arrFilePath['file_name'].'.png';
		   		return $fulcrum = <<<gcLogo
		   			<img src="$baseCdnUrl$logo" style="margin-left:0px;">
gcLogo;
		   	}
		   	return 'images/logos/'.$arrFilePath['file_name'].'.png';

		}else
		{
			return '';
		}
	}
	/*get the width custome width sepcific*/
	public static function logoByUserCompanyIDUsingSoftlinkWidthCustome($database,$user_company_id, $trueFlag = false){
		/*GC logo*/
		$ArrayLogoIDs = Logo::filelocationID($database,$user_company_id);
		$file_location_id = $ArrayLogoIDs['file_location_id'];
		$image_manager_image_id = $ArrayLogoIDs['image_manager_image_id'];
		if($image_manager_image_id!=''){
			$imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);
			$cdnFileUrl = $imageManagerImage->generateUrl($trueFlag);
			$gcLogo = <<<gcLogo
			<img src="$cdnFileUrl" style="margin-left:0px;">
gcLogo;
		}else{
		$trueFlag = (bool) $trueFlag;
		$baseCdnUrl='';
		// Create URL to image or pdf on the CDN
		$uri = Zend_Registry::get('uri');
		/* @var $uri Uri */
		if ($trueFlag) {
			if($uri->sslFlag){
				$baseCdnUrl = $uri->https;
			}else{
				$baseCdnUrl = $uri->cdn_absolute_url;	
			}
		} else {
			$baseCdnUrl = $uri->cdn;
		}
			$nologo = self::$_nologo;
			$gcLogo="";

		}
		return $gcLogo;
	}
	/*get the fulcrum logo*/
	public static function logoByFulcrum(){
		$fulcrumLogo = self::$_fulcrumLogo;
		$fulcrum = <<<gcLogo
	<img src="$fulcrumLogo" style="margin-left:0px;">
gcLogo;
return $fulcrum;
	}

	/*get the fulcrum logo for footer*/
	public static function logoByFulcrumforFooter(){
		$fulcrumLogo = self::$_fulcrumLogo;
		$fulcrum = <<<gcLogo
	<img src="$fulcrumLogo" style="margin-left:0px;width:100px;">
gcLogo;
return $fulcrum;
	}
	/*get the fulcrum in full path*/
	public static function logoByFulcrumByBasePath($useAbsoluteCdnUrl=false){
		$useAbsoluteCdnUrl = (bool) $useAbsoluteCdnUrl;
		$baseCdnUrl='';
		// Create URL to image or pdf on the CDN
		$uri = Zend_Registry::get('uri');
		/* @var $uri Uri */
		if ($useAbsoluteCdnUrl) {
			if($uri->sslFlag){
				$baseCdnUrl = $uri->https;
			}else{
				$baseCdnUrl = $uri->cdn_absolute_url;	
			}
		} else {
			$baseCdnUrl = $uri->cdn;
		}
		$fulcrumLogo = self::$_fulcrumLogo;
		$fulcrum = <<<gcLogo
	<img src="$baseCdnUrl/$fulcrumLogo" style="margin-left:0px;">
gcLogo;
return $fulcrum;
	}
	
	/*get the fulcrum in full path Pi(PunchItem) Api*/
	public static function logoByFulcrumByBasePathPiApi($useAbsoluteCdnUrl=false){
		$useAbsoluteCdnUrl = (bool) $useAbsoluteCdnUrl;
		$baseCdnUrl='';
		// Create URL to image or pdf on the CDN
		$uri = Zend_Registry::get('uri');
		/* @var $uri Uri */
		if ($useAbsoluteCdnUrl) {
			if($uri->sslFlag){
				$baseCdnUrl = $uri->https;
			}else{
				$baseCdnUrl = $uri->cdn_absolute_url;	
			}
		} else {
			$baseCdnUrl = $uri->cdn;
		}
		$fulcrumLogo = self::$_fulcrumLogo;
		$fulcrum = <<<gcLogo
	<img src="$baseCdnUrl$fulcrumLogo" style="margin-left:0px;">
gcLogo;
return $fulcrum;
	}
	/*get the fulcrum  logo for footer in full path*/
	public static function fulcrumlogoforfooterByBasePath($useAbsoluteCdnUrl=false){
		$useAbsoluteCdnUrl = (bool) $useAbsoluteCdnUrl;
		$baseCdnUrl='';
		// Create URL to image or pdf on the CDN
		$uri = Zend_Registry::get('uri');
		/* @var $uri Uri */
		if ($useAbsoluteCdnUrl) {
			if($uri->sslFlag){
				$baseCdnUrl = $uri->https;
			}else{
				$baseCdnUrl = $uri->cdn_absolute_url;	
			}
		} else {
			$baseCdnUrl = $uri->cdn;
		}
		$fulcrumLogo = self::$_fulcrumLogo;
		$fulcrum = <<<gcLogo
$baseCdnUrl/$fulcrumLogo
gcLogo;
return $fulcrum;
	}
	/*get the fulcrum in full path*/
	public static function logoByFulcrumByBasePathOnlyLink($useAbsoluteCdnUrl=false){
		$useAbsoluteCdnUrl = (bool) $useAbsoluteCdnUrl;
		$baseCdnUrl='';
		// Create URL to image or pdf on the CDN
		$uri = Zend_Registry::get('uri');
		/* @var $uri Uri */
		if ($useAbsoluteCdnUrl) {
			if($uri->sslFlag){
				$baseCdnUrl = $uri->https;
			}else{
				$baseCdnUrl = $uri->cdn_absolute_url;	
			}
		} else {
			$baseCdnUrl = $uri->cdn;
		}
		$fulcrumLogo = self::$_fulcrumLogo;
		$fulcrum = "$baseCdnUrl/$fulcrumLogo";
return $fulcrum;
	}
	/*get the fulcrum image path without image tag*/
	public static function logoByFulcrumByBasePathOnly(){
		$config = Zend_Registry::get('config');
		$file_manager_base_path = $config->system->backend_directory;
		$fulcrum = $file_manager_base_path.self::$_fulcrumLogo;
	return $fulcrum;
	}
	/*get the logo paht without image tag*/
	public static function logoByUserCompanyIDUsingSoftlinkPath($database,$user_company_id, $trueFlag =false){
		/*Fetch ids*/
		$ArrayLogoIDs = Logo::filelocationID($database,$user_company_id);
		$file_location_id = $ArrayLogoIDs['file_location_id'];
		$image_manager_image_id = $ArrayLogoIDs['image_manager_image_id'];
		if($image_manager_image_id!=''){
			$imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);
			$config = Zend_Registry::get('config');
			// $file_manager_file_id = Data::parseInt($this->file_manager_file_id);
			$file_manager_base_path = $config->system->file_manager_base_path;
			// $file_manager_backend_directory_path = $config->system->file_manager_backend_directory_path;
			$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
			$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
			$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;
			require_once('lib/common/FileManager.php');
			$arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
			// $arrPath = implode('',$arrFilePath);
			$arrPath = $arrFilePath['file_path'].$arrFilePath['file_name'];
			// $cdnFileUrl = $imageManagerImage->generateUrl($trueFlag);
			$gcLogo = $arrPath;
		}else{
			/*$config = Zend_Registry::get('config');
			$file_manager_base_path = $config->system->backend_directory;*/
			$nologo = self::$_nologo;
			$gcLogo="";

		}
		return $gcLogo;
	}
}
?>
