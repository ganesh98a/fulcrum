<?php

class Esign 
{

	/* This function will Esign a existing PDF
	PdfFilepath - Path of the PDF need to be signed
	tempDir - temp Path in which the pdf is stored
	*/
	// To esignature a merged PDF

 	public static function externalPDFEsign($PdfFilepath, $tempdir,$filename)
	{
		$currentDir = getcwd();
		$config = Zend_Registry::get('config');
		$filePathDefaultBaseDirectory = $config->system->base_directory . 'www/www.axis.com';
		$backend_directory = $config->system->backend_directory;
		$dirpath  =  __DIR__;
			 $dir = str_replace("\\", "/", $backend_directory);
			$pdfmergeDir = $filePathDefaultBaseDirectory."/app/vendor/pdfmerge/digisign.py";
			$commandLineCommand = "python $pdfmergeDir $PdfFilepath $tempdir $filename $dir";

			exec($commandLineCommand);
			shell_exec($commandLineCommand);
	}

}
