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
 * Images manipulation class.
 *
 * Convert between image formats.
 *
 * @category	Framework
 * @package		File
 *
 */

/**
 * @see File
 */
require_once('lib/common/File.php');

class File_Image extends File {
	/**
	 * Class name.
	 */
	protected $_className = 'File_Image';

	public function cropImage($newWidth, $newHeight)
	{
		$filePath = $this->filePath;
		$fileExtension = $this->fileExtension;

		switch ($fileExtension) {
			case 'jpg':
				$srcImage = imagecreatefromjpeg($filePath);
				break;

			case 'png':
				$srcImage = imagecreatefrompng($filePath);
				break;

			case 'gif':
				$srcImage = imagecreatefromgif($filePath);
				break;

			default:
				$srcImage = imagecreatefromjpeg($filePath);
				break;
		}

		// crop the image to the imput dimensions
		// Get new dimensions
		list($width, $height) = getimagesize($filePath);
		$ratio_orig = $width/$height;
		if ($newWidth/$newHeight > $ratio_orig) {
			$newWidth = $newHeight*$ratio_orig;
		} else {
			$newHeight = $newWidth/$ratio_orig;
		}

		$tmpImage = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($tmpImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

		$newFileName = 'thumb-'.$this->fileName;
		$newFileName = str_replace('.jpg', '.png', $newFileName);
		$fileUploadDirectory = $this->fileUploadDirectory;
		$newFilePath = $fileUploadDirectory.$newFileName;

		//imagejpeg($tmpImage, $newFilePath, 100);
		imagepng($tmpImage, $newFilePath);

		imagedestroy($srcImage);
		imagedestroy($tmpImage);

		// overlay the original image on top of the drop shadow
		//imagecopymerge($shadow_image, $newFilePath, 0,0, 0,0, $newWidth, $newHeight, 100);


		// add chmod to image file...

		// create and return a new file object with the cropped images information
		$newFile = new File();
		$newFile->fileExtension = 'jpg';
		$newFile->fileName = $newFileName;
		$newFile->filePath = $newFilePath;
		$newFile->fileUploadDirectory = $fileUploadDirectory;

		$this->croppedImage = $newFile;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
