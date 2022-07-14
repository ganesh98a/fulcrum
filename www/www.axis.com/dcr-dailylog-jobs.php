<?php
/**
 * cron job to generate jobsite daily log dcr report
 */

// Secret key via url allows access to this script
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = $_GET['id'];
	if ($id == '76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C') {
		$init['access_level'] = 'anon';
	} else {
		$init['access_level'] = 'auth';
	}
} else {
	$init['access_level'] = 'auth';
}

//$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');

require_once('./modules-jobsite-daily-logs-functions.php');
require_once('lib/common/Mail.php');
require_once('lib/common/Permissions.php');
require_once('lib/common/SoftwareModuleFunction.php');
require_once('lib/common/Module.php');
require_once('app/models/permission_mdl.php');
require_once('renderPDF.php');


// Debug
//$get->date = '2016-02-16';

// we will get the date on the fly to pass it to the function
if (isset($get)) {
	$dcrReportDate = trim($get->date);
} else {
	$dcrReportDate = '';
}

if (isset($get->project_id)) {
	$project_id = $get->project_id;
}else{
	$project_id = '';
}

if (!empty($dcrReportDate)) {
	if (!preg_match("/\d{4}-\d{2}-\d{2}/", $dcrReportDate)) {
		throw new Exception('parameter for date requested [' . $_REQUEST['date'] . '] is an invalid date.');
	}
	$time = '';
} else {
	$dcrReportDate = date('Y-m-d');
	$min = date('i');
	if ($min % 5 == 0) {
		$time = date('H:i').':00';
	}else{
		$mod_min = 5 * ((int)($min / 5));
		$time = date('H').':'.$mod_min.':00';
	}	
}
echo $time;

$arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate = JobsiteDailyLog::loadJobsiteDailyLogsByJobsiteDailyLogCreatedDate($database, $dcrReportDate, $time, $project_id);

// arr of created and not mailed project
$arrFromDcrFile = JobsiteDailyLog::getProjectFromDcrFile($database, $dcrReportDate,1);

$fromEmail = 'Alert@MyFulcrum.com';
$fromName = 'Fulcrum AutoMessage';

foreach($arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate as $jobsite_daily_log_id => $jobsiteDailyLog) {

	//To generate DCR, Only if any changes made in Daliy log tab
	$GenerateId = GetCountOfValue($jobsiteDailyLog->project_id,$jobsiteDailyLog->jobsite_daily_log_created_date, $database);
	$GetCount = getlogscount($GenerateId, $database);

	if($GetCount!=0){
	/* @var $jobsiteDailyLog JobsiteDailyLog */

	// $fileManagerFile = generateDailyConstructionReport($database, $jobsiteDailyLog);
	$project_id = $jobsiteDailyLog->project_id;
	if (array_key_exists($project_id, $arrFromDcrFile)) {
		$fileManagerFile = '';
	}else{
		$fileManagerFile = getDcrFileDetails($database, $dcrReportDate, $project_id);
	}
	/* @var $fileManagerFile FileManagerFile */

	// PDF Link
	if ($fileManagerFile && $fileManagerFile != '') {

		$project = $jobsiteDailyLog->getProject();
		/* @var $project Project */
		$project->htmlEntityEscapeProperties();
		$escaped_project_name = $project->escaped_project_name;

		$user_company_id = $project->user_company_id;
		
		$software_module_id = 17;
		$software_module_function_id = SoftwareModuleFunction::getIdbyfunctionName('daily_construction_report',$database);

		$arrContacts  = toGetAllUserForSoftwareModuele($database,$user_company_id, $project_id, $software_module_function_id);

		// for file size greater than 17 mb
			$attachmentFileName = $fileManagerFile['dcr_file_name'];
			$cdnFileUrl = $fileManagerFile['dcr_file'];
            $filemaxSize= $fileManagerFile['file_size_status'];
            if(!$filemaxSize)
            {

            if (strpos($cdnFileUrl,"?"))
            {
                $virtual_file_name_url = $cdnFileUrl."&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
            }else
            {
                $virtual_file_name_url = $cdnFileUrl."?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
            }
            $daliyPDF ="<div>  </div>
			<table style=width:80%;>
            <tr>
            <td style='padding:2px;'>Please find the DCR PDF  Link:</td>
            <td style='padding:2px;'><a href='".$virtual_file_name_url."'>$attachmentFileName</a></td></tr>
            </table><br>";
            }else
            {
               $daliyPDF="" ;
            }
            //End of file size

		// Project Manager Email/Name

		$formattedDateCompact = date('m/d/Y', strtotime($dcrReportDate));
		$formattedDate = date("F j, Y", strtotime($dcrReportDate));

		// Send out email to DCR Recipients
		$messageSubject = $escaped_project_name . ' DCR - ' . $formattedDateCompact;

		 //To generate logo
            $uri = Zend_Registry::get('uri');
            if ($uri->sslFlag) {
                $cdn = 'https:' . $uri->cdn;
            } else {
                $cdn = 'http:' . $uri->cdn;
            }
        $main_company = Project::ProjectsMainCompany($database,$project_id);
            require_once('lib/common/Logo.php');
         $mail_image = Logo::logoByUserCompanyIDforemail($database,$main_company);
            if($mail_image !=''){
            $logodata="<td style=width:55%;>
            <a href='".$uri->https."login-form.php'><img style='border: 0; float: left;'  border=0 src='".$cdn.$mail_image."'></a>
            </td>";
           }
            $companyLogoData="
            <table style='width:100%;'>
            <tbody>
            <tr>
             $logodata
            <td style='width:45%;' align='right'>
            <a href='".$uri->https."login-form.php'><img style='border: 0; border: none;float: right;' width='200' height='50' border='0' src='".$cdn."images/logos/fulcrum-blue-icon-silver-text.gif' alt=Fulcrum Construction Management Software></a>
            </td>
            </tr>
            </tbody>
            </table>
            <div style='margin:5px 0 0;float: left;'></div>
<div style='margin: 5px 0 0; text-align: right;'><small style='color: #666666;font-size: 13px;'>Construction Management Software</small></div>
<table style='border:1px solid #DBDBDC;width:100%;padding:6px 10px;'>
<tr><td>
<div style='color:#3b90ce;'><b> DCR - ".$escaped_project_name."</b></div><br>
<div> Please find the attached DCR for ".$formattedDate."  </div><br><br>
$daliyPDF
<small>Thank you for using <a href=".$uri->http." style='text-decoration:none; color:#3b90ce; font-size:15px; font-weight: bold;'>FULCRUM</a> Construction Management&trade; Software</small></td></tr></table>
";



		$htmlMessageBody = $companyLogoData;

		/**/
		$mail = new Mail();
		$mail->setFrom($fromEmail, $fromName);
		$mail->setReplyTo($fromEmail, $fromName);
		$mail->setSubject($messageSubject);
		$mail->setBodyText($messageBody);
		$mail->setBodyHtml($htmlMessageBody, 'UTF-8', Zend_Mime::MULTIPART_RELATED);

		if($filemaxSize)
        	{
		$attachmentFileName = $fileManagerFile['dcr_file_name'];
		$cdnFileUrl = $fileManagerFile['dcr_file'];
		if (is_int(strpos($cdnFileUrl, '?'))) {
			$urlSeparator = '&';
		} else {
			$urlSeparator = '?';
		}
		$cdnFileUrl .= $urlSeparator . 'id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
		$fileContents = file_get_contents($cdnFileUrl);

		// File Attachment
		$mail->createAttachment($attachmentFileName, $fileContents);
		}

		// Place this code after the file operations below when done
		foreach ($arrContacts as $contact_id => $contact) {
			/* @var $contact Contact */
			// if (
			// 	isset($arrContactPermissionsMatrix['role_based']['software_module_function_ids_to_contact_ids'][$software_module_function_id][$contact_id])
			// 	||
			// 		isset($arrContactPermissionsMatrix['ad_hoc']['software_module_function_ids_to_contact_ids'][$software_module_function_id][$contact_id])
			// 	// ||
			// 		// isset($arrContactPermissionsMatrix['admin_contact_ids'][$contact_id]) //to remove admin user because they will come under roles
			// ) {

				// Mail Recipient
				$toEmail = $contact->email;
				$toEmail=trim($toEmail," ");
				if (isset($toEmail) && !empty($toEmail)) {
						$toName = $contact->getContactFullName();
						$mail->addTo($toEmail, $toName);

						// File Attachment
						//$mail->createAttachment($attachmentFileName, $fileContents);

						// $mail->send();
					// }
				}
			// }
		}

		$mail->send();
		
		// Function to insert and update DCR cron details into Logs.
		$loadDCRIntoLogs = JobsiteDailyLog::loadDCRIntoLogs($database, $project_id, $dcrReportDate);	

		// Update mail send status in dcr file table
		$loadDCRfileDetails = JobsiteDailyLog::loadDCRfileDetails($database, $project_id, '', '', '', $dcrReportDate, 2); 

		//To delete the img
		$config = Zend_Registry::get('config');
		$file_manager_back = $config->system->backend_directory;
		$path=$file_manager_back.$mail_image;
		unlink($path);
		// Debug
		//$x = 1;

		//$htmlContent = '<a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="'.$fileUrl.'" title="'.$virtual_file_name.'">DCR PDF</a>';
		//echo $htmlContent;
	}
}

}
