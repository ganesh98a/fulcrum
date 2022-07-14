<?php 
include_once('../PHPClasses/PHPExcel/IOFactory.php');
include_once('../PHPClasses/PHPExcel.php');
include_once('../PHPClasses/PHPExcel/Writer/Excel2007.php');
include_once('lib/common/Logo.php');
$gcLogo = Logo::logoByUserCompanyIDUsingSoftlinkPath($database,$user->user_company_id, true);
$fulcrumLogo = Logo::logoByFulcrumByBasePathOnly();
$gcLogoReal = Logo::logoByUserCompanyIDUsingSoftlinkPath($database,$user->user_company_id);
/*get the image property*/
$path= realpath($gcLogoReal);
$info   = getimagesize($path);
$mime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
$width  = $info[0]; // width as integer for ex. 512
$height = $info[1]; // height as integer for ex. 384
$type   = $info[2]; // same as exif_imagetype

$fulcrum = $gcLogo;
/*GC logo*/
$db_add = DBI::getInstance($database);
$address = "SELECT address_line_1,address_city,address_state_or_region,address_postal_code ,project_name FROM projects where  id='".$RN_project_id."'  ";
$db_add->execute($address);
$row_add = $db_add->fetch();
$add_val = $row_add['address_line_1'].','.$row_add['address_city'].','.$row_add['address_postal_code'];
$add_val=trim($add_val,',');
$project_name=$row_add['project_name'];
$date = date('m/d/Y', strtotime($RN_reportsStartDate));
$date1 = date('m/d/Y', strtotime($RN_reportsEndDate));
// echo $type_mention;
switch ($RN_reportType) {
    case 'Project Delay Log':
        $delayTableTbody = '';
        $delayTableTbody1 = '';
        $incre_id=1; 
        include_once('excel/delaylog-xlsx.php');
        break;
    case 'Weekly Manpower':
        include_once('weeklyManpower-xlsx.php');
        break;
    case 'Monthly Manpower':
        include_once('monthlyManpower-xlsx.php');
        break;
    case 'Detailed Weekly':
        include_once('detailedweekly-xlsx.php');
        break;
    case 'Manpower summary':
        include_once('manpowersummary-xlsx.php');
        break;
    case 'Contact List':
        include_once('contactlist-xlsx.php');
        break;
    case 'Sub List':
        include_once('excel/sublist-xlsx.php');
        break;
    case 'Bidder List':
        $sort_by_status = $get->sbs;
        $sort_by_order = $get->sbo;
        include_once('excel/bidlist-xlsx.php');
        break;
    case 'Submittal Log - by ID':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        $filter_status = $RN_filter_type;
        include_once('excel/submittal_by_id-xlsx.php');
        break;
    case 'Submittal Log - by Notes':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        $filter_status = $RN_filter_type;
        include_once('excel/submittal_by_notes-xlsx.php');
        break;
    case 'Submittal Log - by status':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        $filter_status = $RN_filter_type;
        include_once('excel/submittal_by_status-xlsx.php');
        break;
    case 'Submittal log - by Cost Code':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        $filter_status = $RN_filter_type;
        include_once('excel/submittal_by_costcode-xlsx.php');
        break;
    case 'RFI Report - by ID':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        include_once('excel/request_for_information_by_id-xlsx.php');
        break;
    case 'RFI Report - QA':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        include_once('excel/request_for_information_by_qa-xlsx.php');
        break;
    case 'RFI Report - QA - Open':
    if($RN_filter_type =="")
    {
         $RN_filter_type = null;
    }
        include_once('excel/request_for_information_by_qa-xlsx.php');
        break;
    case 'Bidder List':
        $sort_by_status = $RN_bid_filter_by_status;
        $sort_by_order = $RN_bid_sort_by;
        include_once('excel/bidlist-xlsx.php');
        break;
    case 'Change Order':
        switch ($RN_version) {
        case '1.0':
            $db = DBI::getInstance($database);
            $con_querys="SELECT * from projects where id = $RN_project_id";
            $db->execute($con_querys);
            $rowvalue=$db->fetch();
            $db->free_result();
            if(isset($rowvalue))
                $RN_reportsStartDate=$rowvalue['project_start_date'];

            $currentdate = date('Y-m-d');
            if($RN_reportsStartDate == '' || $RN_reportsStartDate == 'null'){
                $RN_reportsStartDate = $currentdate;
                $date = date('m/d/Y', strtotime($RN_reportsStartDate));
           }
            if($RN_reportsEndDate == '' || $RN_reportsEndDate == 'null'){
                $RN_reportsEndDate = $currentdate;
                $date1 = date('m/d/Y', strtotime($RN_reportsEndDate));
            }
            break;
        default:
            break;
        }
        $cot = $RN_filter_type;
        //$codesp = false;
        $coShowRejected = $RN_show_rejected;
        $codesp = $RN_reportsDescription;
        include_once('excel/changeorder-xlsx.php');
        break;
    case 'Buyout':
        include_once('excel/buyout_report-xlsx.php');
        break;
    case 'Current Budget':
        include_once('excel/current_budget_report-xlsx.php');
        break;
    case 'Vector Report':
        $includegrp = filter_var($RN_groupco, FILTER_VALIDATE_BOOLEAN);
        $includegeneral = filter_var($RN_generalco, FILTER_VALIDATE_BOOLEAN);
        $includeNotes = filter_var($RN_includeNotes, FILTER_VALIDATE_BOOLEAN);
        $includesubTotal = filter_var($RN_subTotal, FILTER_VALIDATE_BOOLEAN);
        
        if($includegrp == true && $includegeneral == false){
            $checkboxcond = 2;
        }else if($includegrp == true && $includegeneral == true){
            $checkboxcond = 3;
        }else{
            $checkboxcond = 1;
        }
        include_once('excel/vectorlist-xlsx.php');
        if($RN_jsonEC['status'] == 400) {
            return false;
        }
        break;
    default:
        # code...
        break;
}

$type_mention=str_replace(' ', "-", $type_mention);
$filename = urlencode($type_mention)."-".$dates."".$i."".$s.".xlsx";
// $filename=str_replace(' ', "-", $filename);
// $filename = 'report.xlsx';
$filenameSheet = $type_mention;
$objPHPExcel->getActiveSheet()->setTitle($filenameSheet);
if (!file_exists($fulcrum)) {
    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(-1);
}
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel,'Excel5');
$config = Zend_Registry::get('config');
$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
$baseDirectory = $config->system->base_directory;
$fileManagerBasePath = $config->system->file_manager_base_path;
$tempFileName = File::getTempFileName();
$tempDir = $fileManagerBasePath.'temp/reports/'.$tempFileName.'/';
$removetempDir = $fileManagerBasePath.'temp/reports/'.$tempFileName;
$fileObject = new File();
$fileObject->mkdir($tempDir, 0777);
$tempPdfFile = File::getTempFileName().'.xlsx';
            // Files come from the autogen pdf
$tempFilePath = $tempDir.$tempPdfFile;

$uri = Zend_Registry::get('uri');
/* @var $uri Uri */
if($uri->sslFlag){
	$baseCdnUrl = $uri->https;
}else{
	$baseCdnUrl = $uri->cdn_absolute_url;
}
$RN_sha1 = sha1_file($tempFilePath);

$RN_fileExtension = 'xlsx';
$RN_virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($RN_fileExtension);

$tempFileNameDirNameOnly = 'reports/'.$tempFileName.'/'.$tempPdfFile;
$url = '__temp_file__?tempFileSha1='.$RN_sha1.'&tempFilePath='.$tempFileNameDirNameOnly.'&tempFileName='.$tempFileName.'&tempFileMimeType='.$RN_virtual_file_mime_type.'&tempFileDir=reports&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';

/*if (!file_exists($baseDirectory.'www/www.axis.com/reports')) {
    mkdir($baseDirectory.'www/www.axis.com/reports', 0777, true);
}
if (!file_exists($baseDirectory.'www/www.axis.com/reports/excel')) {
    mkdir($baseDirectory.'www/www.axis.com/reports/excel', 0777, true);
}*/
// $RN_fileUrl=$baseCdnUrl.'reports/excel/'.$filename;
$RN_fileUrl = $baseCdnUrl.$url;
// $RN_path1=$baseDirectory.'www/www.axis.com/reports/excel/'.$filename;
$objWriter->save($tempFilePath);
$RN_size = filesize($tempFilePath);
$RN_jsonEC['data']['reportResponse']['filename'] = $filename;
$RN_jsonEC['data']['reportResponse']['fileUrl'] = $RN_fileUrl;
$RN_jsonEC['data']['reportResponse']['fileSize'] = $RN_size;

?>
