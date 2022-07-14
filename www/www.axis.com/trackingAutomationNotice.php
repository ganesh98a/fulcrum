<?php
/**
 * Report  Module.
 */

$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');

require_once('lib/common/Message.php');
require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Mail.php');
require_once('dompdf/dompdf_config.inc.php');
require_once('lib/common/Pdf.php');
require_once('image-resize-functions.php');




// $message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;


// DATABASE VARIABLES
$db = DBI::getInstance($database);
// To update contact table 
$query="SELECT id,subcontract_vendor_contact_id,gc_budget_line_item_id from subcontracts order by id desc";
$db->execute($query);
$subcontracts=array();
while($row = $db->fetch())
    {
        $subcontracts[] = $row;
    }
   $db->free_result();

// echo "<pre>";
// print_r($subcontracts);

foreach ($subcontracts as $key => $subcontract) {
$sub_id=$subcontract['id'];
$emailTo=$subcontract_contact_id=$subcontract['subcontract_vendor_contact_id'];
$gc_budget_line_item_id=$subcontract['gc_budget_line_item_id'];
//To get the company id and project Name
$query2="SELECT p.id as project_id,p.project_name,p.is_active_flag,uc.company,uc.id as user_company,cc.cost_code_description from gc_budget_line_items as gc
 inner join `projects` as p on gc.project_id=p.id 
 inner join `user_companies` as uc on p.user_company_id=uc.id
 inner join `cost_codes` as cc on gc.cost_code_id =cc.id
  where gc.id=$gc_budget_line_item_id ";
$db->execute($query2);
$row2 = $db->fetch();
$userCompanyId=$row2['user_company'];
$projectName=$row2['project_name'];
$is_active_flag=$row2['is_active_flag'];
$cost_code_description=$row2['cost_code_description'];


$db->free_result();
if($subcontract_contact_id)
{
$query1 = "SELECT st.subcontract_item, st.subcontract_item_abbreviation,sd.signed_subcontract_document_file_manager_file_id,sd.id FROM `subcontract_documents` as sd inner join subcontract_item_templates as st on sd.subcontract_item_template_id=st.id WHERE sd.`subcontract_id` = $sub_id and sd.signed_subcontract_document_file_manager_file_id IS NULL  ORDER BY `signed_subcontract_document_file_manager_file_id` ASC ";
$db->execute($query1);
$records = array();
	while($row = $db->fetch())
	{
		$records[] = $row;
	}
	$document='';
	foreach ($records as $key => $value) {
		$document .= "<br>".$value['subcontract_item'];
	}
	//End To get the missing Documents
	$config = Zend_Registry::get('config');
    $fulcrum_user = $config->system->fulcrum_user;
	$companyQuery = "SELECT email,primary_contact_id FROM users where email='$fulcrum_user'  limit 1 ";
   			$db->execute($companyQuery);
   	 		$row = $db->fetch();
   	 		$user_email=$row['email'];
   	 		$contact_id=$row['primary_contact_id'];
     		$db->free_result();

	//To insert into the notes
     		$query4 = "Insert into `subcontractor_notes` (`subcontractor_id`, `created_by_contact_id`, `subcontractor_note`) VALUES ($sub_id,$contact_id,'User – Missing Documents Notification Sent')";
   			$db->execute($query4);
   	 		$db->free_result();
    //End to insert into notes


	$emailToInfo = Contact::findContactById($database,$contact_id);
	$regardsUsername = $emailToInfo['first_name'].' '.$emailToInfo['last_name'];
	$regardsEmail = $emailToInfo['email'];
	$toCompanyId = $emailToInfo['contact_company_id'];
	//$fromuserContactId = $fromuserInfo->contact_id;
	
	$contactPhoneInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$contact_id,'1');
	
	if($contactPhoneInfo)
		$contactPhoneNo = '('.$contactPhoneInfo['area_code'].') '.$contactPhoneInfo['prefix'].'-'.$contactPhoneInfo['number'];
	else
		$contactPhoneNo = '';
	
	$contactFaxInfo = ContactPhoneNumber::findByContactIdAndPhoneNumberTypeId($database,$contact_id,'2');

	if($contactFaxInfo)
		$contactFaxNo = 'Fx: ('.$contactFaxInfo['area_code'].') '.$contactFaxInfo['prefix'].'-'.$contactFaxInfo['number'];
	else
		$contactFaxNo = '';
$data=footer_content($database, $userCompanyId);
$address=$data['address'];
$number=$data['number'];
$footer_cont=$address.' '.$number;

	
	/*GCLogo copy to temp path*/
        require_once('lib/common/Logo.php');
        // $gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$userCompanyId, true);
        $fulcrum = Logo::logoByFulcrum();
        /*Fetch ids*/
        $ArrayLogoIDs = Logo::filelocationID($database,$userCompanyId);
        $file_location_id = $ArrayLogoIDs['file_location_id'];
        $image_manager_image_id = $ArrayLogoIDs['image_manager_image_id'];
        /*config path get*/
        $config = Zend_Registry::get('config');
        $basedircs = $config->system->file_manager_base_path;
        $basepathcs = $config->system->file_manager_backend_storage_path ;
        $file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
        $baseDirectory = $config->system->base_directory;
        
        $fileManagerBackendFolderPath = $basedircs.$basepathcs;
        $objFileOperation = new File();
        /*validate dir*/
        $urlDirectory = 'downloads/'.'temp/';
        $outputDirectory = $baseDirectory.'www/www.axis.com/'.$urlDirectory;
        if (!is_dir($outputDirectory)) {
            $directoryCreatedFlag = $objFileOperation->mkdir($outputDirectory, 0777);
        }
        
        $tempFileNameLogo = '_Logo'.round(microtime(true)*5000);
        $LogoDestination = $outputDirectory.$tempFileNameLogo;

        /*uri path*/
        $uri = Zend_Registry::get('uri');
        $cdn_origin_node_absolute_url = $uri->cdn_origin_node_absolute_url;
        if($image_manager_image_id!=''){
            $imageManagerImage = ImageManagerImage::findById($database, $image_manager_image_id);            
            $arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
            $arrPath = $arrFilePath['file_path'].$arrFilePath['file_name'];
            $path = $arrPath;
            // $filegetcontent = file_get_contents($path);
            $infopath= realpath($path);
            $info   = getimagesize($infopath);
            $Logomime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
            $Logowidth  = $info[0]; // width as integer for ex. 512
            $Logoheight = $info[1]; // height as integer for ex. 384
            $Logotype   = $info[2];      // same as exif_imagetype
            // if(intval($width) > 800 || intval($height) > 800){
            resize($path,$LogoDestination,$Logowidth,$Logoheight);
            $fileLogoPath = $urlDirectory.$tempFileNameLogo;
            $base64 = 'data:image;base64,' . base64_encode($filegetcontent);
            $gcLogo = <<<gcLogo
            <img src="$fileLogoPath"  alt="Logo" style="margin-left:0px;">
gcLogo;
        }else{
            $nologo = Logo::$_nologo;
            $gcLogo = <<<gcLogo
           
gcLogo;
        }
        $headerLogo=<<<headerLogo
            <table width="100%" class="table-header">
            <tr>
            <td>$gcLogo</td>
            <td align="right"><span style="margin-top:10px;">$fulcrum</span></td>
            </tr>
            </table>
            <hr>
headerLogo;
	//End of new

$htmlContent = <<<END_HTML_CONTENT
<html>
<head>
<title>Notification</title>
<style>
.tr{
	border-bottom:1px solid;
	text-align:left;
}
.pad{
	padding:10px;
	border-bottom: 1px solid;
}
.margin{
	border-right:1px solid;
}
.tab_mar{
	margin-bottom:3%;
}
.footer { position: fixed;  bottom: 5px;align:center; right: 30px; height: 10px;font-size:10px;left:30px;}
</style>
<body>
$headerLogo
<div class="footer"><table width="100%"><tr><td align="center">$footer_cont</td></tr></table></div>
	<div style="font-family:Helvetica;font-size:12px;">
		
		<div style="width:100%;padding:1% 0;">
			<span class="title" style="font-size:12px; color:#3b90ce;">NOTIFICATION SUMMARY
(To Change Project Notifications Please Login To Our Website)</span>
		</div>
		<span style="margin-bottom:10px;font-size:12px;">$projectName</span>
		<hr>
		<div style="width:100%;padding:1% 0;">
			<span class="title" style="font-size:12px;color:#3b90ce;margin-bottom:10px;">MISSING DOCUMENTS</span>
		<br>

		<span style="margin-bottom:10px;font-size:12px;">$document</span>
		</div>
		<hr>
		Thank you,<br />
		$regardsUsername<br />
		$regardsEmail<br />
		$contactPhoneNo<br />
		$contactFaxNo
		</div>

		

</body>
</html>
END_HTML_CONTENT;

 $htmlContent = html_entity_decode($htmlContent);
        $htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");
        $dompdf = new DOMPDF();
        $dompdf->load_html($htmlContent);
        $dompdf->set_paper("A4", "portrait");
        $dompdf->render();
        $pdf_content = $dompdf->output();

        //start of email 
        if($document && $is_active_flag=='Y')
        {
		$fromEmail = 'Alert@MyFulcrum.com';
		$fromName = 'Fulcrum AutoMessage';

    $mailToQuery = "SELECT email,first_name,last_name FROM contacts where id='$emailTo'  limit 1 ";
    $db->execute($mailToQuery);
    $mailToResult = array();
    while($row = $db->fetch())
    {
        $mailToResult[] = $row;
    }
    $db->free_result();
    $mailToEmail = $mailToResult[0]['email']; 
   	$mailToName = $mailToResult[0]['first_name'].' '.$mailToResult[0]['last_name']; 
    
    if($mailToName == ' ')
        $mailToName = $mailToEmail;
    //Mail Body 
    $greetingLine = 'Hi '.$mailToName.',<br><br>';
    $htmlAlertMessageBody = <<<END_HTML_MESSAGE
    <table style="border:1px solid #DBDBDC;width:650px;padding:6px 10px;"><tr><td>
    $greetingLine
    <span style="margin:2%"></span>
    Attached is the PDF with the list of missing documents. <br><br>
 	Thanks,<br>
	Fulcrum Team</td></tr>
    </table>
END_HTML_MESSAGE;
echo "<br><br>Email : ".$mailToEmail;
//To get the project Company Id
    require_once('lib/common/Logo.php');
    $mail_image = Logo::logoByUserCompanyIDforemail($database,$userCompanyId);

    ob_start();
    include('templates/mail-template.php');
    $mail_image=$mail_image;
    $bodyHtml = ob_get_clean();

    $mail = new Mail();
    $mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED);
       $mail->setFrom($fromEmail, $fromName);
    $mail->addTo($mailToEmail, $mailToName);
    $mail->setSubject("Account Update -$projectName");
    $fileContents = $pdf_content;
    $mailAttachmentName="$cost_code_description-Summary".'.pdf';
    $mail->createAttachment($mailAttachmentName, $fileContents);
    $mail->send();
    echo "<br>success";

    //To delete the img
    $config = Zend_Registry::get('config');
    $file_manager_back = $config->system->base_directory;
    $file_manager_back =$file_manager_back.'www/www.axis.com/';
    $path=$file_manager_back.$mail_image;
    unlink($path);
}
        //End of email
//	exit;

}


}
function footer_content($database, $user_company_id)
{
    $db = DBI::getInstance($database);
    //To get the contact company_id
     $query1="SELECT id FROM `contact_companies` WHERE `user_user_company_id` = $user_company_id AND `contact_user_company_id` = $user_company_id ";
    $db->execute($query1);
    $row1=$db->fetch();
    $ContactCompId=$row1['id'];
    //To get the compant address
    $Footeraddress='';
    $query2="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId and `head_quarters_flag`='Y'  order by id desc limit 1";
    $db->execute($query2);
    $row2=$db->fetch();
    if($row2)
    {
    $CompanyOfficeId=$row2['id'];
    if($row2['address_line_1']!='')
    {
    $Footeraddress.=$row2['address_line_1'];
    }
    if($row2['address_city']!='')
    {
    $Footeraddress.=' | '.$row2['address_city'];
    }
    if($row2['address_state_or_region']!='')
    {
    $Footeraddress.=' , '.$row2['address_state_or_region'];
    }
    if($row2['address_postal_code']!='')
    {
    $Footeraddress.='  '.$row2['address_postal_code'];
    }
    }else{
        $query4="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId   order by id desc limit 1";
    $db->execute($query4);
    $row4=$db->fetch();
    
    $CompanyOfficeId=$row4['id'];
    if($row4['address_line_1']!='')
    {
    $Footeraddress.=$row4['address_line_1'];
    }
    if($row4['address_city']!='')
    {
    $Footeraddress.=' | '.$row4['address_city'];
    }
    if($row4['address_state_or_region']!='')
    {
    $Footeraddress.=' , '.$row4['address_state_or_region'];
    }
    if($row4['address_postal_code']!='')
    {
    $Footeraddress.='  '.$row4['address_postal_code'];
    }
    }
    
   $query3="SELECT * FROM `contact_company_office_phone_numbers` WHERE `contact_company_office_id` = $CompanyOfficeId";
    $db->execute($query3);
    $business='';
    $fax='';
     while ($row3 = $db->fetch()) 
        {
           if($row3['phone_number_type_id']=='1')
            {
            $business = $row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
            } 
            if($row3['phone_number_type_id']=='2')
            {
            $fax = ' | (F)'.$row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
            }   
        }
    $Footeraddress=trim($Footeraddress,'| ');
   $faxPhone =$business.$fax;
   return array('address'=>strtoupper($Footeraddress),'number'=>$faxPhone);
}

     
