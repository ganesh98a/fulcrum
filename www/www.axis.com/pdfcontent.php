<?php

ini_set('display_errors',true);
 ini_set('error_reporting', E_ALL);

// // include 'vendor/autoload.php';
// require_once "pdfparser-master/src/Smalot/PdfParser/Parser.php";
// include 'vendor/autoload.php';
// $parser = new \Smalot\PdfParser\Parser();

// $pdf    = $parser->parseFile('pdf/sample.pdf');  
// $pages  = $pdf->getPages();
 
// // Loop over each page to extract text.
// foreach ($pages as $page) {
//     echo $page->getText();
// }
// $text = $pdf->getText();
// echo "text : ".$text;//all text from mypdf.pdf

// require_once "class.pdf2text.php.php";
// $a = new PDF2Text();
// $a->setFilename('pdf/sample.pdf'); 
// $a->decodePDF();
// echo $a->output();
// $string = "";
// $fd = popen("pdf/sample.pdf","r");
// while (!feof($fd)) { 
// echo "buff : ".$buffer = fgets($fd, 4096); 
// echo "here : ".$string .= $buffer;
// }
// echo "this :".$string;
?>

<?php
echo date_default_timezone_get();
echo "<br>".$current_date = date('m/d/Y == H:i:s A');
$source_pdf="twilio-php/sample.pdf";
$output_folder="TransmittalTemp";

    if (!file_exists($output_folder)) { mkdir($output_folder, 0777, true);}
passthru("pdftohtml $source_pdf $output_folder/new");
// var_dump($a);
echo file_get_contents("TransmittalTemp/news.html");

?>