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
 * Programmatically load, manipulate, and render PDF documents.
 *
 * @category   Pdf
 * @package    Pdf
 *
 */



class PdfTools
{

	// Max dimensions for pdf to render well
	// Max width is dialed in here...
	const maxPTWidth = 524;
	// Really need to re-evaluate the max height
	const maxPTHeight = 393;

	public static function renderDomPDFSaveImageSize($pdfImage)
	{
		list($imageWidth, $imageHeight) = getimagesize($pdfImage);
		/* captured it. For Justin to review
		this logic does not work for long image
		$ratio_orig = $width/$height;


		if ($maxWidth/$maxHeight > $ratio_orig) {
		$actualWidth = $maxHeight*$ratio_orig;
		$actualHeight = $maxHeight;
		} else {
		$actualHeight = $maxWidth/$ratio_orig;
		$actualWidth = $maxWidth;
		}
		*/
		$widthRatio = $imageWidth / self::maxPTWidth;
		$heightRatio = $imageHeight / self::maxPTHeight;
		if ($widthRatio > 1 || $heightRatio > 1) {
			/*SQ Fix*/
			/*if ($heightRatio > $heightRatio) {
				// widht ratio is larger
				$divisor = $heightRatio;
			} else {*/
				// height ratio is larger
				$divisor = $heightRatio;
			/*}*/
			$imageWidth = round($imageWidth / $divisor);
			$imageHeight = round($imageHeight / $divisor);
		}
		return array($imageWidth , $imageHeight);

	}


}
/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
