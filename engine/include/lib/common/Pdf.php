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

/**
 * Zend_Pdf
 */
require_once('Zend/Pdf.php');

class Pdf extends Zend_Pdf
{

	public static function merge($arrPdfFilepaths, $pdfFilepath, $pdfFilename)
	{
		$operatingSystem = Application::getOperatingSystem();
		$pdfFileList = '';
		$increMent = 1;
		foreach ($arrPdfFilepaths as $pdfFilePath) {
			$pdfFileList .= " $pdfFilePath";
		}
		$count = count($arrPdfFilepaths);
		$pdfFileList = $arrPdfFilepaths[0];
		for($i = 1;$i < $count;$i++){
			$pdfFileDecrypt = '_temp'.round(microtime(true)*$increMent).'.pdf';
			$pdfFileListDe = $arrPdfFilepaths[$i];
			 
			if ($operatingSystem == 'Windows') {
				$commandLineCommand = '"C:/bin/qpdf-7.0.0/bin/qpdf"' . " --decrypt $pdfFileListDe $pdfFileDecrypt";
				$currentDir = getcwd();
				chdir($pdfFilepath);
				shell_exec($commandLineCommand);
				chdir($currentDir);
			} else {
				$commandLineCommand = '"/usr/bin/qpdf"' . " --decrypt $pdfFileListDe $pdfFileDecrypt";

				$currentDir = getcwd();
				chdir($pdfFilepath);
				shell_exec($commandLineCommand);
				chdir($currentDir);
			}
			// unlink($pdfFileListDe);
			$filedecryptpath = $pdfFilepath.$pdfFileDecrypt;
			
			if(file_exists($filedecryptpath)){
				$pdfFileList .=" $pdfFileDecrypt";
			}
			$increMent++; 
		}
		$pdfFileList = trim($pdfFileList);
		

		if ($operatingSystem == 'Windows') {
			// windows
			$outputFile = $pdfFilepath.$pdfFilename;
			$commandLineCommand = '"C:/bin/PDFtk Server/bin/pdftk"' . " $pdfFileList cat output $pdfFilename";
			$currentDir = getcwd();
			chdir($pdfFilepath);
			shell_exec($commandLineCommand);
			chdir($currentDir);
		} else {
			// ... Linux implementation
			$outputFile = $pdfFilepath.$pdfFilename;
			

			/*$commandLineCommand = '"/usr/local/bin/pdftk"' . " $pdfFileList cat output $pdfFilename";*/
			 //$commandLineCommand = '"/usr/bin/pdftk"' . " $pdfFileList cat output $pdfFilename";

			// GhostScript $commandLineCommand = "gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=$outputFile $pdfFileList";
			$config = Zend_Registry::get('config');
			$filePathDefaultBaseDirectory = $config->system->base_directory . 'www/www.axis.com';

			// $currentDir = getcwd();
			$pdfmergeDir = $filePathDefaultBaseDirectory."/app/vendor/pdfmerge/merge-new.py";
			$commandLineCommand = "python3.6 $pdfmergeDir $pdfFileList";
			chdir($pdfFilepath);
			shell_exec($commandLineCommand);

			rename('output.pdf', $outputFile);
			chdir($currentDir);
		}

		return;


		/*
		//exec($commandLineCommand, $arrOutput, $returnValue);
		//$cd = "cd \"$pdfFilepath\"; ";
		//$commandLineCommand = "$cd\"C:\Program Files\PDFtk Server\bin\pdftk\"$pdfFileList cat output $outputFile";

		//$commandLineCommand = "C:\dev\build\advent-sites\branches\development\engine\include\lib\common\Pdf\pdf_merge.bat $pdfFilepath $pdfFileList $outputFile";

		$cmd = '"C:\Program Files\PDFtk Server\bin\pdftk" ' . "$commandLineCommand ";
		$WshShell = new COM("WScript.Shell");
		$oExec = $WshShell->Run("cmd /C $cmd ", 3, true);
		*/
	}

	public static function getPdfMetaData($pdfFilepath, $pdfFilename)
	{
		$operatingSystem = Application::getOperatingSystem();
		if ($operatingSystem == 'Windows') {
			// windows
			$commandLineCommand = '"C:\Program Files\PDFtk Server\bin\pdftk"' . " $pdfFilename dump_data";
			$currentDir = getcwd();
			chdir($pdfFilepath);
			exec($commandLineCommand, $arrOutput, $returnValue);
			chdir($currentDir);

			//print_r($arrOutput);
			//exit;
		} else {
			// ... Linux implementation
			$commandLineCommand = '"/usr/local/bin/pdftk"' . " $pdfFilename dump_data";
			$currentDir = getcwd();
			chdir($pdfFilepath);
			exec($commandLineCommand, $arrOutput, $returnValue);
			chdir($currentDir);
		}

		$arrPdfMetaData = array();
		if (!empty($arrOutput)) {
			$arrPdfMetaDataMap = array(
				'Author' => 'author',
				'Producer' => 'producer',
				'Creator' => 'created_by',
				'Title' => 'title',
				'Subject' => 'subject',
				'ModDate' => 'modified',
				'CreationDate' => 'created',
				'NumberOfPages' => 'page_count',
				'PageMediaNumber' => 'page_media_number',
				'PageMediaRotation' => 'page_media_rotation',
				'PageMediaRect' => 'page_media_rectangle',
				'PageMediaDimensions' => 'page_media_dimensions',
			);

			$reset = false;
			foreach ($arrOutput as $line) {
				if ($line == 'InfoBegin') {
					$reset = true;
					continue;
				}
				if ($reset && is_int(strpos($line, 'InfoKey'))) {
					$tmpKey = str_replace('InfoKey: ', '', $line);
				}
				if ($reset && is_int(strpos($line, 'InfoValue'))) {
					$value = str_replace('InfoValue: ', '', $line);
					if (isset($arrPdfMetaDataMap[$tmpKey])) {
						$key = $arrPdfMetaDataMap[$tmpKey];
						$arrPdfMetaData[$key] = $value;
					} else {
						// @todo Log these...
					}
					$reset = false;
				}
				if (is_int(strpos($line, 'NumberOfPages'))) {
					$value = str_replace('NumberOfPages: ', '', $line);
					$arrPdfMetaData['page_count'] = $value;
				}
			}
		}

		return $arrPdfMetaData;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
