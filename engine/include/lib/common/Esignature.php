<?php
/*Manually increase the execution time for pdf generation*/
ini_set('max_execution_time', 300);
ini_set("memory_limit", "1000M");
require_once('lib/common/SubcontractDocument.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/Contact.php');
require_once('esignature/TCPDF-master/examples/tcpdf_include.php');
require_once('esignature/TCPDF-master/tcpdf.php');

/** This function will merge the Images to PDF and Apply Esignature for Subcontractors
	$arrPdfFilepaths : contains the PDF path
	$tempdir: Directory path
	$tempFilePath : temporary file name
	$subcontract_id : contains subcontractor id
	$currentlyActiveContactId : currently Activated contact id
*/
	function GeneratePDFUsignImage($database,$arrPdfFilepaths, $tempdir,$tempFilePath,$subcontract_id,$currentlyActiveContactId,$signatory_check)
	{
		$subcontract = Subcontract::findSubcontractByIdExtended($database, $subcontract_id);
		$subcontract_gc_signatory = $subcontract->gc_signatory;
		$subcontract_vendor_signatory = $subcontract->vendor_signatory;
		$gc_signatory_contactName = Contact::ContactNameById($database,$subcontract_gc_signatory);
		$vendor_signatory_contactName = Contact::ContactNameById($database,$subcontract_vendor_signatory);

		$config = Zend_Registry::get('config');	
		$file_manager_base_path = $config->system->file_manager_base_path;
		$save = $file_manager_base_path.'backend/procedure/';
		//GC signatory
		$gc_filename = md5($subcontract_gc_signatory);
		$signfile_name = $save.$gc_filename.'.png';
		$signgetcontent = file_get_contents($signfile_name);
		
		//vendor signatory
		$vendor_filename = md5($subcontract_vendor_signatory);
		$vendorfile_name = $save.$vendor_filename.'.png';
		$vendorgetcontent = file_get_contents($vendorfile_name);
		//To arrange the img path as array to generate the pdf
		$imgpath = array();
		$pagesizeforpdf =array();
		foreach ($arrPdfFilepaths as $pdfFilelist) {
			
			$pdfFilelist ='/'.$pdfFilelist;

			$pdf_page_file=$tempdir.$pdfFilelist;
			  //To get the page Count for pdf
            $cc= exec("identify -format %n $pdf_page_file");
            $orientcommand= "pdfinfo ".$pdf_page_file.' | grep "Page.*size:"';
            $orientation= exec($orientcommand);
            $arrorinentaion = explode(" ", $orientation);
          
            $orx = $arrorinentaion[7];
            $ory = $arrorinentaion[9];
       	    $width =ConvertPTSToInch($orx);
            $height =ConvertPTSToInch($ory);
            $orientationPage = ($width < $height)?'P':'L';
			$pdfsize = "'".$orientationPage."',array(".$width.",".$height.")";

			$filenamearr = explode('.pdf', $pdfFilelist);
			$i = 1;
			
			do{ 
				$pdfimgfile_name = $tempdir.$filenamearr[0].'_'.$i.'.jpg';
				$pdfgetcontent = file_get_contents($pdfimgfile_name);
				$imgpath[] = $pdfgetcontent;
				$reformat[]=$pdfsize;
				// $imgpath[] = $tempdir.$filenamearr[0].'_'.$i.'.jpg';
				$i++;

			}while ($i <= $cc);
			
		}
		
		
		$config = Zend_Registry::get('config');	
		$backend_directory = $config->system->backend_directory;
		// ob_start();
		// Extend the TCPDF class to create custom Header and Footer

		class MYPDFI extends TCPDF {

			 public $vendorcontent ;//<-- to save your data
			 public $GCFilecontact ;
			 public $footertext ;

			 function setImag($vendorcontent){
			 	$this->vendor = $vendorcontent;
			 }

			 function getImag(){
			 	echo $this->vendor ."<br/>";
			 }
			 function setGCcont($GCFilecontact){
			 	$this->GC = $GCFilecontact;
			 }

			 function getGCcont(){
			 	echo $this->GC ."<br/>";
			 }
			 function setfootercont($footertext){
			 	$this->foottext = $footertext;
			 }

			 function getfootercont(){
			 	echo $this->foottext ."<br/>";
			 }

    		 //Page header
			 public function Header() {
			 	if ($this->page == 1) {

			 		$this->Image('@'.$this->GC, 10, 10, 130, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			 	}
			 }

    		// Page footer
			 public function Footer() {


			 	$this->Cell(230, 10, $this->foottext, 0, false, 'C', 0, '', 0, false, 'T', 'M');
			 	$logo = $this->Image('@'.$this->vendor,150, 275, 20,20, 'PNG');
			 }
			}
			
			// create new PDF document
			$pdf = new MYPDFI(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Fulcrum');
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			$dirpath  =  __DIR__;
			$dir = str_replace("\\", "/", $backend_directory);


			$certificate ="file://".realpath($dir."/esignature/data/cert/Fulcrum.pem");
			$certificate = str_replace("\\", "/", $certificate);


			// set margins
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set document signature
			$pdf->setSignature($certificate, $certificate, 'tcpdfdemo', '', 2);


			
			foreach ($imgpath as $key => $imgvalue) {
				$pageformat = $pagesizeforpdf[$key];
			$ref = $reformat[$key];
				$pdf->AddPage($reformat);
			// $pdf->AddPage('L',array($ref));

				$pdf->Image('@'.$imgvalue,0, 0,240,300, 'JPG');
				// $pdf->Image($imgvalue, 0, 0, 245, 300, '', '', '', false, 300, '', false, false, 0);
				$pdf->setPageMark();
				if($key == 0){
					//To add the signature
					if($signatory_check == "Y" )
					{
						$date = date('m/d/Y');
						$vendor = '<span style="font-size:10px;">vendor-sign  :'.$vendor_signatory_contactName.'</span>';
						$dategenerated = '<span style="font-size:10px;">'.$date.'</span>';
						$pdf->writeHTMLCell(0, 0, 18, 220, $vendor,  0,0, false, true,  '', 0, false, 'T', 'M');
						if(($subcontract_vendor_signatory == $currentlyActiveContactId) || ($vendorsigncheck =='Y'))
						{
							$pdf->Image('@'.$vendorgetcontent,20, 230, 20, 15, 'PNG');
							$pdf->setSignatureAppearance(20, 230, 20, 15);

						}
						$pdf->writeHTMLCell(0, 0, 20, 245, $dategenerated,  0,0, false, true,  '', 0, false, 'T', 'M');


						//GC
						$GC = '<span style="font-size:10px;" align="right">GC-sign :'.$gc_signatory_contactName.'</span>';
						$pdf->writeHTMLCell(0, 0, 150, 220,$GC,  0,0, false, true,  '', 0, false, 'T', 'M');
						if(($subcontract_gc_signatory == $currentlyActiveContactId)||($GCsigncheck=='Y' ))
						{
							$pdf->Image('@'.$signgetcontent ,175, 230, 20, 15, 'PNG');
							$pdf->setSignatureAppearance(175, 230, 20, 15);

						}
						$pdf->writeHTMLCell(0, 0, 175, 245, $dategenerated,  0,0, false, true,  '', 0, false, 'T', 'M');
					}
		} // for first page alone signature should be there
	}


		//Close and output PDF document
		// ob_end_clean();

		//For saving the file in TCPDF 'F' is used
	$pdf_content =$pdf->Output($tempFilePath, 'F');


	
}
//To convert the PTS to inches
function ConvertPTSToInch($val)
{
	
	$retval = $val *  0.0138889;
	$retval = number_format($retval, 2, '.', '');
	return $retval;
}
/* function used to check the Page size of a pdf
$orx - width of a PDf
$ory - height of a PDf
*/

function checkOrientationForPDF($orx,$ory)
{
	$width = $orx *  0.0138889;
	$height = $ory *  0.0138889;
	$orientationPage = ($width < $height)?'P':'L';
	
	$pageform  = checkPageSizePDF($width,$height);
	$pdfsize = "'".$orientationPage."','".$pageform."'";
	return $pdfsize;

}

/* function used to check the Page size of a pdf
$width - width of a PDf
$height - height of a PDf
*/
function checkPageSizePDF($width,$height)
{
	
	$pageformat = "";
	if(($width >= 33 && $width <= 34) && ($height >= 46 && $height <= 47))
	{
		$pageformat= 'A0';
	}
	if(($width >= 23 && $width <= 24) && ($height >= 33 && $height <= 34))
	{
		$pageformat= 'A1';
	}
	if(($width >= 16 && $width <= 17) && ($height >= 23 && $height <= 24))
	{
		$pageformat= 'A2';
	}
	if(($width >= 11 && $width <= 12) && ($height >= 16 && $height <= 17))
	{
		$pageformat= 'A3';
	}
	if(($width >= 8 && $width <= 9) && ($height >= 11 && $height <= 12))
	{
		$pageformat= 'A4';
	}
	if(($width >= 5 && $width <= 6) && ($height >= 8 && $height <= 9))
	{
		$pageformat= 'A5';
	}
	if(($width >= 4 && $width <= 5) && ($height >= 5 && $height <= 6))
	{
		$pageformat= 'A6';
	}
	if(($width >= 2 && $width <= 3) && ($height >= 4 && $height <= 5))
	{
		$pageformat= 'A7';
	}
	if(($width >= 2 && $width <= 3) && ($height >= 2 && $height <= 3))
	{
		$pageformat= 'A8';
	}
	return $pageformat;
}

