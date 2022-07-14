<?php

class PdfToImg 
{

	/* This function will convert all the pages of the Pdf to images
	arrPdfFilepaths - contains PDF files as a array
	tempDir - temp Path in which the pdf is stored
	*/
	public static function PDF2Img($arrPdfFilepaths, $tempdir)
	{
		$currentDir = getcwd();
		$pdfFileList = '';
		$config = Zend_Registry::get('config');
		$filePathDefaultBaseDirectory = $config->system->base_directory . 'www/www.axis.com';
		$imgpath = array();
		foreach ($arrPdfFilepaths as $pdfFilelist) {
			
			$pdfFilelist ='/'.$pdfFilelist;
			$tempdir = rtrim($tempdir, '/');
			$filenamearr = explode('.pdf', $pdfFilelist);
			$imagename = $filenamearr[0];

			$pdfmergeDir = $filePathDefaultBaseDirectory."/app/vendor/pdfmerge/pdftoimg2.py";
			$commandLineCommand = "python $pdfmergeDir $tempdir $pdfFilelist $imagename";
			shell_exec($commandLineCommand);
			}
	}
}
