<?php
/**
 * Dashboard management.
 */
try {
/**
 * Software header for:
 * 1) Session
 * 		-Standardization
 * 		-Fixation prevention
 * 		-Hijacking prevention
 * 		-Cross site scripting prevention
 * 2) Data input sanitization
 * 3) SQL injection prevention
 * 4) Standard framework variables and includes
 *
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['skip_permissions_check'] = true;
$init['geo'] = true;
$init['get_maxlength'] = 2048;
$init['get_required'] = false;
$init['https'] = false;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['skip_always_include'] = false;
$init['skip_session'] = false;
$init['skip_templating'] = false;
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');

require_once('lib/common/Message.php');

// Standard variable values that are placed into $_GLOBAL scope by init.php.
// $database;

$message = Message::getInstance();
/* @var $message Message */
// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

// Get the company_id and project_id values
if (isset($get)) {
	$company_id = $get->company_id;
	$project_id = $get->project_id;
} else {
	$company_id = '';
	$project_id = '';
}

require_once('./modules-collaboration-manager-functions.php');

// DATABASE VARIABLES
$db = DBI::getInstance($database);

$forcePasswordChangeFlag = $session->getForgotPassword();
if ($forcePasswordChangeFlag) {
	$message->reset('dashboard.php');
	$message->enqueueInfo('Please update your account password to continue.', 'account-management-password-form.php');
	$message->sessionPut();
	$url = 'account-management-password-form.php'.$uri->queryString;
	header('Location: '.$url);
	exit;
} else {
	$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
}



// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $session->getUserCompanyId());
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

// PERMISSION VARIABLES
require_once('app/models/permission_mdl.php');
$userCanViewDashboard = checkPermissionForAllModuleAndRole($database,'manage_dashboard');
$userCanViewTaskSummary = checkPermissionForAllModuleAndRole($database,'view_task_summary');
if ($userRole == "admin"){
	$db = DBI::getInstance($database);

	$db->free_result();
	$query = "SELECT COUNT(*) as total_user  FROM `projects_to_contacts_to_roles` INNER JOIN `roles` 
ON `roles`.id =  `projects_to_contacts_to_roles`.role_id 
WHERE `projects_to_contacts_to_roles`.`project_id` = '".$project_id."'
AND `projects_to_contacts_to_roles`.contact_id = '".$primary_contact_id."' 
AND `roles`.role IN ('Project Manager') ";
	$db->execute($query);
	$projmanrow = $db->fetch();

	$db->free_result();

	$query = "SELECT COUNT(*) as total_user  FROM `projects_to_contacts_to_roles` INNER JOIN `roles` 
ON `roles`.id =  `projects_to_contacts_to_roles`.role_id 
WHERE `projects_to_contacts_to_roles`.`project_id` = '".$project_id."'
AND `projects_to_contacts_to_roles`.contact_id = '".$primary_contact_id."' 
AND `roles`.role IN ('Sub Contractor', 'Bidder')";
	$db->execute($query);
	$row = $db->fetch();
	if(!empty($row['total_user']) && empty($projmanrow['total_user'])){
		$userCanViewTaskSummary = false;
	}else{
		$userCanViewTaskSummary = true;
	}
}else if ($userRole == "user"){

	//
	$db = DBI::getInstance($database);
	$db->free_result();
	$query = "SELECT COUNT(*) as total_user  FROM `projects_to_contacts_to_roles` INNER JOIN `roles` 
ON `roles`.id =  `projects_to_contacts_to_roles`.role_id 
WHERE `projects_to_contacts_to_roles`.`project_id` = '".$project_id."'
AND `projects_to_contacts_to_roles`.contact_id = '".$primary_contact_id."' 
AND `roles`.role IN ('Project Manager') ";
	$db->execute($query);
	$projmanrow = $db->fetch();

	$db->free_result();

	$query = "SELECT COUNT(*) as total_user  FROM `projects_to_contacts_to_roles` INNER JOIN `roles` 
ON `roles`.id =  `projects_to_contacts_to_roles`.role_id 
WHERE `projects_to_contacts_to_roles`.`project_id` = '".$project_id."'
AND `projects_to_contacts_to_roles`.contact_id = '".$primary_contact_id."' 
AND `roles`.role IN ('Sub Contractor', 'Bidder') ";
	$db->execute($query);
	$row = $db->fetch();
	$db->free_result();
	if(!empty($row['total_user'])){
		$userCanViewTaskSummary = false;

	}else if(!empty($projmanrow['total_user'])){
		$userCanViewTaskSummary = true;
	}

	if(empty($projmanrow['total_user'])){
		$userCanViewDashboard = false;
	}

}
// If No Access
if (!$userCanViewDashboard  && !$userCanViewTaskSummary) {
	$successMessage = 'Click Project Management menu for access to other modules';
	$message->enqueueSuccess($successMessage, $currentPhpScript);

}

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '<link href="app/css/task_summary.css" rel="stylesheet">';
}
$htmlCss .= <<<END_HTML_CSS


END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
	<script src="app/js/task_summary.js"></script>
	<script src="/js/dashboard.js"></script>
	<script src="/js/chart/highcharts.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Dashboard - '.$currentlySelectedProjectName;
$htmlBody = '';
require('template-assignments/main.php');
require('dashboard-ajax.php');


$db = DBI::getInstance($database);
if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
} 


if($userRole=='global_admin')
{
	$year=date('Y');
	$db = DBI::getInstance($database);
	$query = "SELECT count(*) as count FROM projects where is_active_flag='Y' and  year(project_start_date)='".$year."' ";
	$db->execute($query);
	$row = $db->fetch();
	$ActiveProject=$row['count'];
	
	//To get Users Companies
	$getCurdate = date('Y-m-d');
	$getstartdate = date('Y-01-01');
	$db = DBI::getInstance($database);
	$queryear = "SELECT count(id) as count FROM user_companies where date(created_date) BETWEEN '$getstartdate' AND '$getCurdate'";
	$db->execute($queryear);
	$rowyear = $db->fetch();
	$YearlyCount=$rowyear['count'];

	//To get Total Users 
	$pastDays=date('Y-m-d', strtotime('today - 30 days'));
	$cur_date=date('Y-m-d');
	$query2 = "SELECT count(*) as count FROM `users` where date(accessed) BETWEEN '$pastDays' AND '$cur_date'";
	$db->execute($query2);
	$row2 = $db->fetch();
	$totalUsers=$row2['count'];

	//To get Top 3 companies with highest users 
	
	$que1 = "SELECT id, company FROM `user_companies`";
	$db->execute($que1);
	
	$Companies=array();
	$signCompanies=array();
	$i=0;
	while($rowc1 = $db->fetch())
	{
		$Companies[$i]['id']=$rowc1['id'];
		$Companies[$i]['company']=$rowc1['company'];
		$i++;
	}
	$k=0;
	foreach ($Companies as $key => $value) {
		
		$Companies_id=$value['id'];
		$Companies=$value['company'];
		$query3 = "SELECT count(*) as count,u.user_company_id,uc.company FROM `users` as u inner join user_companies as uc on u.user_company_id=uc.id where date(accessed) BETWEEN '$pastDays' AND '$cur_date' and u.user_company_id='$Companies_id' group by  user_company_id order by count desc limit 3";
		$db->execute($query3);
		$row3 = $db->fetch();

		$signCompanies[$k]['company']=$Companies;
		$signCompanies[$k]['count']=($row3['count'])?$row3['count']:'0';
		$k++;

	}
	$signCompanies[]=usort($signCompanies, function ($a, $b) { return $b['count'] - $a['count']; });

	
	$user_company='';
	$j='1';
	foreach ($signCompanies as $key => $Company) {
		if($j>3)
		{
			break;
		}
		else
		{
			$user_company.="<tr><td class='tdAlign'>".$Company['company']."</td><td class='tdAlign'>".$Company['count']."</td></tr>";
		}
		$j++;
	}
	//To get the open submittal count for the project manager
	$queryYear = "SELECT * FROM `projects_to_contacts_to_roles` WHERE `contact_id` =$primary_contact_id and `role_id`='5' ";
	$db->execute($queryYear);
	$project_ids ="";
	while($rowc1 = $db->fetch())
	{
		$project_ids.="'".$rowc1['project_id']."',";
	}
	$db->free_result();
	if($project_ids=='')
	{
		$projManager='';
	}else
	{
		$projManager='1';
	}
	//End of open submittal count for the project manager

	//Open submittals
	$querysub = "SELECT count(*) as count FROM `submittals` WHERE  submittal_status_id='5' ";
	$db->execute($querysub);
	$subCount ="";
	$rs1 = $db->fetch();
	$subCount=$rs1['count'];
	$db->free_result();

	$k=0;
	$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `submittals` as s 
	inner join projects as p on s.project_id=p.id 
	inner join user_companies as uc on uc.id = p.user_company_id
	WHERE s.submittal_status_id='5' group by p.id order by count desc limit 3";
	$db->execute($sq1);
	$topProject='';
	while($rs2 = $db->fetch())
	{
		$labelText = $rs2['project_name'].' ('.$rs2['company'].')';
		$projectName = $rs2['project_name'];

		$topProject.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle='tooltip' title='' data-original-title='".$labelText."'>".$projectName."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}

//End of open submittal index

	//Open RFI
	$querysub = "SELECT count(*) as count FROM `requests_for_information` WHERE  request_for_information_status_id='2' ";
	$db->execute($querysub);
	$rfiCount ="";
	$rs1 = $db->fetch();
	$rfiCount=$rs1['count'];
	$db->free_result();

	$k=0;
	$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `requests_for_information` as r 
	inner join projects as p on r.project_id=p.id
	inner join user_companies as uc on uc.id = p.user_company_id
	WHERE r.request_for_information_status_id='2' group by p.id order by count desc limit 3";
	$db->execute($sq1);
	$rfitopProject='';
	while($rs2 = $db->fetch())
	{
		$labelTextRfi = $rs2['project_name'].' ('.$rs2['company'].')';
		$projectNameRfi = $rs2['project_name'];
		$rfitopProject.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextRfi."'>".$projectNameRfi."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}

	//End of open RFI index

	//closed submmittal

		/*Get the count of companies using function*/
		$closedsubCount = GetProjectClosedSubmittalCount($db, $user_company_id, $currentlyActiveContactId, $user_id,'');
		//To get the closed RFI data
		$db = DBI::getInstance($database);
		$getCurdate = date('Y-m-d');
		$getstartdate = date('Y-01-01');
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `submittals` as s 
		inner join projects as p on s.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE s.submittal_status_id IN ('2','3') and date(s.su_closed_date) BETWEEN '$getstartdate' AND '$getCurdate'  group by p.id order by count desc limit 3";
	$db->execute($sq1);
	$closedsub='';
	while($rs2 = $db->fetch())
	{
		$labelTextSubC = $rs2['project_name'].' ('.$rs2['company'].')';
		$projectName = $rs2['project_name'];
		$closedsub.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextSubC."'>".$projectName."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}
	// end of closed
		$closesub = <<<YearTillCount
		<div class="splitthrdleft">
		<div class=" bottomAlign">
		{$closedsubCount}
		</div>
		</div>
		<div class="splitthrdright">
		<table cellpadding="5" class="full_width_table1" width="100%">
		<tr>
		<td class="thAlign">Projects</td>
		<td class="thAlign">Closed submtl</td>
		</tr>
		{$closedsub}

		</table>
		</div>
YearTillCount;
	
	//end of closed submittal

	//Closed RFI for gA
	
		/*Get the count of companies using function*/
		$closedRFiCount = GetProjectClosedRFICount($db, $user_company_id, $currentlyActiveContactId, $user_id,'');
		//To get the closed RFI data
		$db = DBI::getInstance($database);
		$getCurdate = date('Y-m-d');
		$getstartdate = date('Y-01-01');
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `requests_for_information` as r 
		inner join projects as p on r.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE r.request_for_information_status_id='4' and date(r.rfi_closed_date) BETWEEN '$getstartdate' AND '$getCurdate'  group by p.id order by count desc limit 3";
	$db->execute($sq1);
	$closedrfi='';
	while($rs2 = $db->fetch())
	{
		$labelTextRfiC = $rs2['project_name'].' ('.$rs2['company'].')';
		$projectName = $rs2['project_name'];
		$closedrfi.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextRfiC."'>".$projectName."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}
	// end of closed
		$closeRFI = <<<YearTillCount
		<div class="splitthrdleft">
		<div class=" bottomAlign">
		{$closedRFiCount}
		</div>
		</div>
		<div class="splitthrdright">
		<table cellpadding="5" class="full_width_table1" width="100%">
		<tr>
		<td class="thAlign">Projects</td>
		<td class="thAlign">Closed RFI</td>
		</tr>
		{$closedrfi}

		</table>
		</div>
YearTillCount;
	
	//End of Closed RFI for GA



	if($YearlyCount=='')
		$YearlyCount=0;
	$template->assign('ActiveProject', $ActiveProject);
	$template->assign('totalUsers', $totalUsers);
	$template->assign('userCompany', $user_company);
	$template->assign('YearlyCount', $YearlyCount);
	$template->assign('projManager', $projManager);
// Submittal Open
	$template->assign('subCount', $subCount);
	$template->assign('subPrjName', $currentlySelectedProjectName);
	$template->assign('topProject', $topProject);
//RFI open 
	$template->assign('rfiCount', $rfiCount);
	$template->assign('rfiPrjName', $currentlySelectedProjectName);
	$template->assign('rfitopProject', $rfitopProject);
//closed submittal
	$template->assign('closesub', $closesub);
//closed RFI
	$template->assign('closeRFI', $closeRFI);
	$template->assign('softwareModuleFunctionLabel','Dashboard');


	




	$htmlContent = $template->fetch('theme-axis-master-dashboard.tpl');
}
else 
{
	/*if ($userRole == "admin"){
		if (!$userCanViewDashboard) {
			$errorMessage = 'Dashboard Access Restricted';
			$message->enqueueError($errorMessage, $currentPhpScript);
		}
		$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
	}*/
	

	
	//To get Total Users For an Company
	$que1= "SELECT count(*) as count FROM `users` where `user_company_id`=$user_company_id ";
	$db->execute($que1);
	$rowad1 = $db->fetch();
	$companyUsers=$rowad1['count'];

	//To get Top 3 companies with highest users 
	$que3 = "SELECT count(*) as count,u.user_company_id,p.project_name FROM `users` as u inner join projects as p on u.user_company_id=p.user_company_id group by  user_company_id order by count desc limit 3";
	$db->execute($que3);
	
	$signCompanies=array();
	while($rowad2 = $db->fetch())
	{
		$signCompanies[]=$rowad2;
	}
	$user_company='';
	foreach ($signCompanies as $key => $Company) {
		$user_company.="<tr><td class='tdAlign'>".$Company['project_name']."</td><td class='tdAlign'>".$Company['count']."</td></tr>";
	}
	$year=date('Y');

	//To get Users Active projects
	$getCurdate = date('Y-m-d');
	$getstartdate = date('Y-01-01');
	$db = DBI::getInstance($database);
	$queryYear = "SELECT count(*) as count FROM contacts c, projects_to_contacts_to_roles p2c2r,projects pr WHERE p2c2r.contact_id <> $primary_contact_id AND c.user_company_id <> $user_company_id AND c.user_id = $user_id AND c.`id` <> $primary_contact_id AND c.`id` = p2c2r.contact_id AND pr.is_active_flag = 'Y' AND p2c2r.project_id = pr.id AND date(pr.project_start_date) BETWEEN '$getstartdate' AND '$getCurdate'";
	$db->execute($queryYear);
	$row = $db->fetch();
	$ActiveProject=$row['count'];
	$db->free_result();

	$query = "SELECT count(id) as count FROM projects where user_company_id = $user_company_id AND is_active_flag = 'Y' AND date(project_start_date) BETWEEN '$getstartdate' AND '$getCurdate'";
	$db->execute($query);
	$row = $db->fetch();
	$ActiveProject +=$row['count'];
	
	// To get the global admin and admin default projects for this company
	$que2 = "SELECT u.user_company_id,p.project_name, p.is_active_flag,p.id ,(select count(*) from users where user_company_id='$user_company_id' and  role_id not IN ('3')) as count,(select group_concat(primary_contact_id) from users where user_company_id='$user_company_id' and role_id not IN ('3')) as con_id FROM `users`as u inner join projects as p on p.user_company_id = u.user_company_id where u.user_company_id='$user_company_id' and u.role_id not IN ('3') group by p.id";
	$db->execute($que2);
	
	$signProject=array();
	$projects_id='';
	$projcountarr=array();
	$primary_id_taken=array();
	while($rowad2 = $db->fetch())
	{
		$signProject[]=$rowad2;
	}
	foreach ($signProject as $key => $prj) {
		$projects_id.="'".$prj['id']."',";
		$projcountarr[$prj['id']]=$prj['count'];

		$p_ids=explode(',', $prj['con_id']);
		$primary_id_tak='';
		foreach ($p_ids as $key1 => $prj_id) 
		{
			$primary_id_tak.="'".$prj_id."',"; 
		}
		// $primary_id_taken[$prj['id']]=rtrim($primary_id_tak,',');
		$primary_id_taken=rtrim($primary_id_tak,',');

	}
	
	$next_proj_id=rtrim($projects_id,',');
	// to get the other projects assigned for the admin
	$que3 = "SELECT c.user_id, p.project_name,c.id, c.email, p.id as project_id from contacts as c  inner join projects_to_contacts_to_roles as pc on c.id=pc.contact_id inner join projects as p on pc.project_id=p.id where c.user_id='$user_id' and p.id Not In($next_proj_id)";
	$db->execute($que3);
	
	$signProject1=array();
	while($rowad3 = $db->fetch())
	{
		$signProject1[]=$rowad3;
	}
	foreach ($signProject1 as $key => $prj1) {
		$projects_id.=$other_company_projects="'".$prj1['project_id']."',";
	}
	$next_proj_id=rtrim($projects_id,',');
	// to get the All users assigned for the projects not admin and global admin of the current company
	$que4 = "SELECT  count(distinct contact_id) as count, project_id from projects_to_contacts_to_roles WHERE project_id IN ($next_proj_id) and role_id Not IN ('3') and contact_id Not IN($primary_id_taken) group by project_id";
	$db->execute($que4);
	
	$signProject2=array();
	$projcountarr1=array();
	while($rowad4 = $db->fetch())
	{
		$signProject2[]=$rowad4;
	}
	foreach ($signProject2 as $key => $prj2) {
		$projcountarr1[$prj2['project_id']]=$prj2['count'];
		
	}
	$projcountarr2=array();
	if(!empty($other_company_projects)){
		$other_company_projects=rtrim($other_company_projects,',');
		//to get other company projects
		$que5 = "SELECT user_company_id FROM `projects` WHERE id IN ($other_company_projects)";
		$db->execute($que5);
		$signProject3=array();
		$def_company_id='';
	
		while($rowad5 = $db->fetch()){
			$signProject3[]=$rowad5;
		}
		foreach ($signProject3 as $key => $prj3) {
			$def_company_id.="'".$prj3['user_company_id']."',";
		}
		$def_company_id=rtrim($def_company_id,',');

		$que6 = "SELECT u.user_company_id,p.project_name, p.is_active_flag,p.id ,(select count(*) from users where user_company_id IN ($def_company_id) and  role_id not IN ('3')) as count FROM `users`as u inner join projects as p on p.user_company_id = u.user_company_id where u.user_company_id IN ($def_company_id) and p.id IN($other_company_projects) and u.role_id not IN ('3') group by p.id ";
		$db->execute($que6);
	
		$signProject4=array();
		

		while($rowad6 = $db->fetch()){
			$signProject4[]=$rowad6;
		}
		foreach ($signProject4 as $key => $prj4) {
			$projcountarr2[$prj4['id']]=$prj4['count'];
			
		}

	}
	
	
	
	
	
	$output = array();
	// first 2 arrays
	foreach ($projcountarr as $key => $value) {
		foreach ($projcountarr1 as $key1 => $value1) {
			if($key==$key1)
			{

				$output[$key]=$value+$value1;
			}
			if(!isset($output[$key1])){
				$output[$key1]=$value1;

			}

		}
		if(!isset($output[$key])){
			$output[$key]=$value;

		}
		
	}
	$outCount=count($output);
	$output[]=arsort($output);

	// output and 3 array
	foreach ($output as $k1 => $val1) {
		foreach ($projcountarr2 as $k2 => $val2) {
			if($k1==$k2)
			{

				$output[$k2]=$val1+$val2;
			}

		}
	}


	$user_project='';
	$i='1';
	foreach ($output as $key => $Company) {
		if($i>3|| $i>$outCount)
		{
			break;
		}
		
		$que7 = "SELECT project_name from projects where id= $key";
		$db->execute($que7);

		$signProject5='';
		while($rowad7 = $db->fetch())
		{
			$signProject5=$rowad7['project_name'];
		}

		$user_project.="<tr><td class='tdAlign'>".$signProject5."</td><td class='tdAlign'>".$Company."</td></tr>";
		$i++;
	}
	// End of top 3 
	$project_ids ="";
	//To get the open submittal count for the project manager
	$queryYear = "SELECT * FROM `projects_to_contacts_to_roles` WHERE `contact_id` =$primary_contact_id and `project_id`=$currentlySelectedProjectId and `role_id`='5' ";
	$db->execute($queryYear);
	while($rowc1 = $db->fetch())
	{
		$project_ids.="'".$rowc1['project_id']."',";
	}
	$db->free_result();
	if($project_ids=='')
	{
		$projManager='';
	}else
	{
		$projManager='1';
	}
	
	$currently_project_id = $session->getCurrentlySelectedProjectId();
	
	$tasksummary_arr = tasksummary($database, $currently_project_id, $user_id,$userRole,$projManager);
	$tasksummary = $tasksummary_arr['task_summary_html'];
	$tasksummary_cnt = $tasksummary_arr['task_summary_count'];
	 

	//Open submittals
	$querysub = "SELECT count(*) as count FROM `submittals` WHERE `project_id` = '$project_id' and submittal_status_id='5' ";
	$db->execute($querysub);
	$subCount ="";
	$rs1 = $db->fetch();
	$subCount=$rs1['count'];
	$db->free_result();

	$k=0;
	$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `submittals` as s 
	inner join projects as p on s.project_id=p.id
	inner join user_companies as uc on uc.id = p.user_company_id
	WHERE s.submittal_status_id='5' group by p.id order by count desc limit 3 ";
	$db->execute($sq1);
	$topProject='';
	while($rs2 = $db->fetch())
	{
		$labelTextRfiC = $rs2['project_name'].' ('.$rs2['company'].')';
		$projectName = $rs2['project_name'];
		$topProject.="<tr><td class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextRfiC."'>".$projectName."</td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}

//End of open submittal index

	//Open RFI
	$querysub = "SELECT count(*) as count FROM `requests_for_information` WHERE `project_id` = '$project_id' and request_for_information_status_id='2' ";
	$db->execute($querysub);
	$rfiCount ="";
	$rs1 = $db->fetch();
	$rfiCount=$rs1['count'];
	$db->free_result();

	$k=0;
	$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `requests_for_information` as r 
	inner join projects as p on r.project_id=p.id
	inner join user_companies as uc on uc.id = p.user_company_id
	WHERE r.request_for_information_status_id='2' group by p.id order by count desc limit 3";
	$db->execute($sq1);
	$rfitopProject='';
	while($rs2 = $db->fetch())
	{
		$labelTextSubC = $rs2['project_name'].' ('.$rs2['company'].')';
		$projectName = $rs2['project_name'];
		$rfitopProject.="<tr><td class='tdAlign dashbrd-tooltip' ><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextSubC."'>".$projectName."</td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}
	//End of open RFI index
	/* Admin queries for Submittal, Rfi (open & close)*/
	$loadAllOwnedProjectsFlag = false;
	if ($userRole == "admin"){
		$loadAllOwnedProjectsFlag = true;
	}
	// Load all "Owned Projects if appropriate
	$arrProjectsIdJoin = array();
	$arrOwnedProjectIds = array();
	if ($loadAllOwnedProjectsFlag) {
		$query =
		"
		SELECT distinct(p.`id`)
		FROM `projects` p
		WHERE p.`user_company_id` = $user_company_id
		";
		$db->query($query);
		while ($row = $db->fetch()) {
			$tmpProjectId = $row['id'];
			$arrOwnedProjectIds[$tmpProjectId] = 1;
			$arrProjectsIdJoin[$tmpProjectId] = 1;
		}
		$db->free_result();
	}

	// Load project Data from the project_id list
	$arrProjects = array();
	
	if (!empty($arrOwnedProjectIds)) {
		$arrOwnedProjectIds = array_keys($arrOwnedProjectIds);
		$in = join(',', $arrOwnedProjectIds);
		$query =
		//"SELECT p.`id`, p.`project_name`, p.`user_company_id`
		"
		SELECT p.*
		FROM `projects` p
		WHERE p.`id` IN ($in)
		ORDER BY p.`is_active_flag` DESC, p.`project_name` ASC
		";
		$db->query($query);

		$counter = 0;
		while ($row = $db->fetch()) {
			// Use project_id as the key
			$project_id = $row['id'];
			$arrProjects[$project_id]['user_company_id'] = $row['user_company_id'];
			$arrProjects[$project_id]['project_name'] = $row['project_name'];
			$arrProjects[$project_id]['id'] = $row['id'];
			//$arrProjects[$counter] = $row;
			//$counter++;
		}
		$db->free_result();
	} else {
		$arrProjects = array();
	}
	// load Guest Projects
	$query =
	"
	SELECT distinct(p2c2r.project_id)
	FROM contacts c, projects_to_contacts_to_roles p2c2r
	WHERE p2c2r.contact_id <> $primary_contact_id
	AND c.user_company_id <> $user_company_id
	AND c.user_id = $user_id
	AND c.`id` <> $primary_contact_id
	AND c.`id` = p2c2r.contact_id
	";
	$db->query($query);
	while ($row = $db->fetch()) {
		$project_id = $row['project_id'];
		$arrGuestProjectIds[$project_id] = 1;
		$arrProjectsIdJoin[$project_id] = 1;
	}
	$db->free_result();


	if (!empty($arrGuestProjectIds)) {
		$arrGuestProjectIds = array_keys($arrGuestProjectIds);
		$in = join(',', $arrGuestProjectIds);
		$query =
		//"SELECT p.`id`, p.`project_name`, p.`user_company_id`
		"
		SELECT p.*
		FROM `projects` p
		WHERE p.`id` IN ($in)
		ORDER BY p.`is_active_flag` DESC, p.`project_name` ASC
		";
		$db->query($query);
		$counter = 0;
		while ($row = $db->fetch()) {
			// Use project_id as the key
			$project_id = $row['id'];
			$arrProjects[$project_id] = $row;
			$arrProjects[$project_id]['user_company_id'] = $row['user_company_id'];
			$arrProjects[$project_id]['project_name'] = $row['project_name'];
			$arrProjects[$project_id]['id'] = $row['id'];
		}
		$db->free_result();
	}
	/* load Bidding Project*/
	$arrGuestProjectIds = array();
	// Get guest projects where the contact has been invited and the status is not "1=Potential", "6=Not Bidding", "7=Rejected"
	$query =
	"
	SELECT distinct(gbli.project_id)
	FROM contacts c, subcontractor_bids sb, gc_budget_line_items gbli
	WHERE sb.subcontractor_contact_id <> $primary_contact_id
	AND c.user_company_id <> $user_company_id
	AND c.user_id = $user_id
	AND c.`id` <> $primary_contact_id
	AND c.`id` = sb.subcontractor_contact_id
	AND sb.gc_budget_line_item_id = gbli.`id`
	AND sb.subcontractor_bid_status_id <> 1 AND sb.subcontractor_bid_status_id <> 6 AND sb.subcontractor_bid_status_id <> 7
	";
	$db->query($query);
	while ($row = $db->fetch()) {
		$project_id = $row['project_id'];
		$arrGuestProjectIds[$project_id] = 1;
		$arrProjectsIdJoin[$project_id] = 1;
	}
	$db->free_result();


	if (!empty($arrGuestProjectIds)) {
		$arrGuestProjectIds = array_keys($arrGuestProjectIds);
		$in = join(',', $arrGuestProjectIds);
		$query =
		//"SELECT p.`id`, p.`project_name`, p.`user_company_id`
		"
		SELECT p.*
		FROM `projects` p
		WHERE p.`id` IN ($in)
		ORDER BY p.`is_active_flag` DESC, p.`project_name` ASC
		";
		$db->query($query);
		$counter = 0;
		while ($row = $db->fetch()) {
				// Use project_id as the key
			$project_id = $row['id'];
			$arrProjects[$project_id] = $row;
			$arrProjects[$project_id]['user_company_id'] = $row['user_company_id'];
			$arrProjects[$project_id]['project_name'] = $row['project_name'];
			$arrProjects[$project_id]['id'] = $row['id'];
		}
		$db->free_result();
	}
	/* project arrayIndexKey */
	$arrProjectsIdIndex = array_keys($arrProjectsIdJoin);
	$arrProjectsIdIndexJoin = join(',', $arrProjectsIdIndex);
	$subOpenDetails = '';
	$subCountAd = 0;
	$rfiOpen = 0;
	$rfiOpenDetails = '';
	if(!empty($arrProjectsIdIndexJoin)){
		// Open submittals
		$querySub = "SELECT count(*) as count FROM `submittals` WHERE  submittal_status_id='5' AND `project_id` IN ($arrProjectsIdIndexJoin) ";
		$db->execute($querySub);
		$resultSubOpen = $db->fetch();
		$subCountAd=$resultSubOpen['count'];
		$db->free_result();
		
		$subOpenDetail = "SELECT count(*) AS count, p.id,p.project_name,company FROM `submittals` AS s 
		INNER JOIN projects AS p ON s.project_id = p.id
		INNER JOIN user_companies AS uc ON uc.id = p.user_company_id
		WHERE s.submittal_status_id='5' AND s.`project_id` IN ($arrProjectsIdIndexJoin) GROUP BY p.id ORDER BY count DESC LIMIT 3 ";
		$db->execute($subOpenDetail);

		while($resultSubOpenDetails = $db->fetch()){
			$labelTextSubOpenC = $resultSubOpenDetails['project_name'].' ('.$resultSubOpenDetails['company'].')';
			$projectName = $resultSubOpenDetails['project_name'];
			$subOpenDetails.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextSubOpenC."'>".$projectName."</td><td class='tdAlign'>".$resultSubOpenDetails['count']."</td></tr>";
		}
		// Close submittals
		//Open Rfi
		$queryRfi = "SELECT count(*) AS count FROM `requests_for_information` WHERE `project_id` IN ($arrProjectsIdIndexJoin) AND request_for_information_status_id='2' ";
		$db->execute($queryRfi);
		$resultRfi = $db->fetch();
		$rfiOpen=$resultRfi['count'];
		$db->free_result();
		
		$rfiOpenDe = "SELECT count(*) AS count, p.id,p.project_name,company FROM `requests_for_information` AS r
		INNER JOIN projects AS p ON r.project_id = p.id
		INNER JOIN user_companies AS uc ON uc.id = p.user_company_id
		WHERE r.request_for_information_status_id='2' AND r.`project_id` IN ($arrProjectsIdIndexJoin) GROUP BY p.id ORDER BY count DESC LIMIT 3";
		$db->execute($rfiOpenDe);
		
		while($resultRfiOpenDe = $db->fetch()){
			$labelTextSubOpenC = $resultRfiOpenDe['project_name'].' ('.$resultRfiOpenDe['company'].')';
			$projectName = $resultRfiOpenDe['project_name'];
			$rfiOpenDetails.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextSubOpenC."'>".$projectName."</td><td class='tdAlign'>".$resultRfiOpenDe['count']."</td></tr>";
		}
		// Closed Rfi
	}
	
	
	$template->assign('subCountAd', $subCountAd);
	$template->assign('subOpenDetails', $subOpenDetails);
	
	$template->assign('rfiOpen', $rfiOpen);
	$template->assign('rfiOpenDetails', $rfiOpenDetails);
	// End Open Rfi
	
	/* End Admin queries */

	/* User*/
	//To get the PM  Role for the Project
	$queryYear = "SELECT `project_id` FROM `projects_to_contacts_to_roles` WHERE `contact_id` = $primary_contact_id AND `role_id` = 5"; 
	$db->execute($queryYear);
	$PM_project_ids='';
	while($rowc1 = $db->fetch())
	{
	$PM_project_ids.="'".$rowc1['project_id']."',";
	}
	$PM_project_ids=trim($PM_project_ids,',');
	$rfiCount = $userRfiCount =  0;
	$rfiuserProject='';
	$userSubmittalopen = '';
	$subCount = $subuserCount = 0;
	if(!empty($PM_project_ids)){
		// Open RFI for User
		$querysub = "SELECT count(*) as count FROM `requests_for_information` WHERE `project_id` IN ($PM_project_ids) and request_for_information_status_id='2' ";
		$db->execute($querysub);
		$rs1 = $db->fetch();
		$userRfiCount=$rs1['count'];
		$db->free_result();
		$k=0;
		$sq1="SELECT count(*) as count, p.id,p.project_name,u.company FROM `requests_for_information` as r inner join projects as p on r.project_id=p.id
		inner join user_companies as u on p.user_company_id=u.id 
		WHERE r.request_for_information_status_id='2' and r.project_id IN ($PM_project_ids) group by p.id order by count desc limit 3";
		$db->execute($sq1);
		
		while($rs2 = $db->fetch())
		{
			$comdata=$rs2['project_name'].' - '.$rs2['company'];
			if(strlen( $rs2['project_name']) > '17')
			{
			$rfiuserProject.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle='tooltip'  title='' data-original-title='".$comdata."'>".$rs2['project_name']."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
			}else
			{
				$rfiuserProject.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle='tooltip'  title='' data-original-title='".$comdata."'>".$rs2['project_name']."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";

			}
		}
		//End of Open RFI for User
		// Open Submittal for User

		$querysub = "SELECT count(*) as count FROM `submittals` WHERE `project_id` IN ($PM_project_ids) and submittal_status_id='5' ";
		$db->execute($querysub);
		
		$rs1 = $db->fetch();
		$subuserCount=$rs1['count'];
		$db->free_result();
		$k=0;
		$sq1="SELECT count(*) as count, p.id,p.project_name,u.company FROM `submittals` as s 
		inner join projects as p on s.project_id=p.id 
		inner join user_companies as u on p.user_company_id=u.id 
		WHERE s.submittal_status_id='5' and s.project_id IN ($PM_project_ids) group by p.id order by count desc limit 3 ";
		$db->execute($sq1);
		$userSubmittalopen='';
		while($rs2 = $db->fetch())
		{
			$labelTextSubOpenC = $rs2['project_name'].' ('.$rs2['company'].')';
			$projectName = $rs2['project_name'];
			$userSubmittalopen.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextSubOpenC."'>".$projectName."</td><td class='tdAlign'>".$rs2['count']."</td></tr>";
		}
		//End of Open Submittal for User
	}
	
	
	/* End for User */
	$template->assign('htmlMessages',$htmlMessages);
	$template->assign('userCanViewDashboard',$userCanViewDashboard);
	$template->assign('userCanViewTaskSummary',$userCanViewTaskSummary);
	$template->assign('tasksummary',$tasksummary);
	$template->assign('user_id',$user_id);
	$template->assign('tasksummary_cnt',$tasksummary_cnt);
	$template->assign('ActiveProject', $ActiveProject);
	$template->assign('company', $userCompanyName);
	$template->assign('companyUsers', $companyUsers);
	$template->assign('user_project', $user_project);
	$template->assign('projManager', $projManager);
	$template->assign('userRole', $userRole);
	//Submittal open 
	$template->assign('subCount', $subCount);
	$template->assign('subPrjName', $currentlySelectedProjectName);
	$template->assign('topProject', $topProject);
	//RFI open 
	$template->assign('rfiCount', $rfiCount);
	$template->assign('rfiPrjName', $currentlySelectedProjectName);
	$template->assign('rfitopProject', $rfitopProject);
	//user
	$template->assign('userRfiCount', $userRfiCount);
	$template->assign('rfiuserProject', $rfiuserProject);
	$template->assign('subuserCount', $subuserCount);
	$template->assign('userSubmittalopen', $userSubmittalopen);
	$template->assign('softwareModuleFunctionLabel','Dashboard');
	$htmlContent = $template->fetch('dashboard-admin.tpl');
}
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

} catch (Exception $e) {
	require('./error/500.php');
}
exit;
