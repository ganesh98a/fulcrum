<?php 
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Contact.php');
require_once('dashboard-chart-functions.php');
require_once('./modules-collaboration-manager-functions.php');

$session = Zend_Registry::get('session');
$userRole = $session->getUserRole();
$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$user_company_id = $session->getUserCompanyId();
$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
$primary_contact_id = $session->getPrimaryContactId();
$user_id = $session->getUserId();
$db = DBI::getInstance($database);
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


//Method for Project index Global_admin
if(isset($_POST['method']) && $_POST['method']=="project")
{
	$year=date('Y');
	$month=date('n');
	
	if($_POST['period']=="monthly")
	{
		$projMonthlyData='';
		for($i=0;$i<=4;$i++)
		{
			if($i=='0')
			{
				$date="And day(project_start_date) between '1' and '7'";
			}else if($i=='1')
			{
				$date="And day(project_start_date) between '8' and '14'";
			}else if($i=='2')
			{
				$date="And day(project_start_date) between '15' and '21'";
			}else if($i=='3')
			{
				$date="And day(project_start_date) between '22' and '28'";
			}
			else if($i=='4')
			{
				$date="And day(project_start_date) between '29' and '31'";
			}
			$db = DBI::getInstance($database);
			$query = "SELECT count(*) as count from projects where year(project_start_date)='".$year."' AND  Month(project_start_date)='".$month."' $date And is_active_flag='Y' ";
			$db->execute($query);
			$row = $db->fetch();
			if($row['count']!='')
			{
				$projMonthlyData.=$row['count'].'~';
			}else
			{
				$projMonthlyData.='0'.'~';
			}
		}

		$projMonthlyData=rtrim($projMonthlyData,'~');
		echo $projMonthlyData;
		
	}
	if($_POST['period']=="quarter")
	{
		
		$quart= CurrentQuarter($month);
		$qmon=QuaterYear($quart);
		$ival=explode(',',$qmon);
		$projQuaterData='';
		$monthNames='';
		
		for($j=$ival[0];$j<=$ival[2];$j++){

		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count from projects where year(project_start_date)='".$year."' AND  Month(project_start_date)='".$j."'  And is_active_flag='Y' ";
			$db->execute($query);
			$row = $db->fetch();
			if($row['count']!='')
			{
				$projQuaterData.=$row['count'].'~';
			}else
			{
				$projQuaterData.='0'.'~';
			}
			$dateObj   = DateTime::createFromFormat('!m', $j);
			$monthName = $dateObj->format('M');
			$monthNames.=$monthName.'~';
			
		}
		 $projQuaterData=rtrim($projQuaterData,'~');
		 $monthNames=rtrim($monthNames,'~');
		$projQuatData=$projQuaterData.'~'.$monthNames;
		echo $projQuatData;
		
	}
	if($_POST['period']=="yearly")
	{
		$db = DBI::getInstance($database);
	 $query = "SELECT count(*) as count FROM projects where is_active_flag='Y' and  year(project_start_date)='".$year."' ";
		$db->execute($query);
		$row = $db->fetch();
		$ActiveProject=$row['count'];
		echo $ActiveProject;
	}
}
// Active and dormant functions
if(isset($_POST['customer']) && $_POST['customer']=="project")
{
	$year=date('Y');
	$month=date('m');
	$type= '';
	if(!empty($_POST['type'])){
		$type=$_POST['type'];
	}
	$nodata='';
	$db = DBI::getInstance($database);
	if($_POST['period']=="yearly")
	{
		$que1 = "SELECT *  FROM  user_companies where year(created_date)='$year'";
		$db->execute($que1);
		$GeneralCompanies=array();
		while($rowc1 = $db->fetch())
		{
			$GeneralCompanies[]=$rowc1;
		}

		$activeData=array();
		$dormantData=array();
		foreach ($GeneralCompanies as $key => $comp) {
			$company=$comp['id'];
			$company_name=$comp['company'];
		// To the projects associated with the company
			$que2 = "SELECT *  FROM  projects where year(project_start_date)='$year' and user_company_id='$company'";
			$db->execute($que2);

			$Generalprojects=array();
			while($rowc2 = $db->fetch())
			{
				$Generalprojects[]=$rowc2;
			}

			$projectDetailsCount='0';
			$median=0;
			$median_inv=0;
			$invite_count=0;


			foreach ($Generalprojects as $key1 => $proj) {
				$project=$proj['id'];
				$median_arr=array();
				$median_inv_arr=array();
		 // to get the Dcr count
				for($m=1;$m<=12;$m++)
				{
					$innerque1 = "SELECT count(*) as count FROM  `jobsite_daily_logs`  as jdl  where year(jdl.jobsite_daily_log_created_date)='$year' and month(jdl.jobsite_daily_log_created_date)='$m' and jdl.project_id='$project'";
					$db->execute($innerque1);
					$rowi1 = $db->fetch();
					$median_arr[]=$rowi1['count'];
					$projectDetailsCount=$projectDetailsCount+$rowi1['count'];

				}
				$median =$median+calculate_mediannew($median_arr);
		// To get the invited to bidders count
				$innerque2 = "SELECT count( * ) AS count FROM `gc_budget_line_items` gbli INNER JOIN `subcontractor_bids` sb ON gbli.`id` = sb.`gc_budget_line_item_id` INNER JOIN `subcontractor_bid_statuses` sbs ON sb.`subcontractor_bid_status_id` = sbs.`id` WHERE gbli.`user_company_id` = '$company' AND gbli.`project_id` = '$project' AND  year(gbli.`created`) = '$year' And sb.`subcontractor_bid_status_id` IN ( 2 ) ";
				$db->execute($innerque2);
				$rowi2 = $db->fetch();
				$median_inv_arr[]=$rowi2['count'];
				$invite_count=$invite_count+$rowi2['count'];
				$median_inv =$median_inv+calculate_mediannew($median_inv_arr);


			}

			if(($type=='active')&&(($median >='7')||($median_inv >='10')))
			{
				$activeData[$key]['company']=$company_name;
				$activeData[$key]['count']=$projectDetailsCount;
			}
			if(($type=='dormant') &&(($median >='0' && $median < '7' ) || ($median_inv >='0' && $median_inv < '10') && ($median >='0' && $median < '7' )))
			{
				$activeData[$key]['company']=$company_name;
				$activeData[$key]['count']=$projectDetailsCount;
			}

		}
	}
	if($_POST['period']=="quarter")
	{
		$quart= CurrentQuarter($month);
		$qmon=QuaterYear($quart);
		$ival=explode(',',$qmon);
		$month_string='';

		foreach ($ival as $key => $value) {
			$month_string.="'".$value."',";
		}
		
		$month_string=rtrim($month_string,',');
		$que1 = "SELECT *  FROM  user_companies where year(created_date)='$year' and month(created_date) IN ($month_string)";
		$db->execute($que1);
		$GeneralCompanies=array();
		while($rowc1 = $db->fetch())
		{
			$GeneralCompanies[]=$rowc1;
		}

		$activeData=array();
		$dormantData=array();
		foreach ($GeneralCompanies as $key => $comp) {
			$company=$comp['id'];
			$company_name=$comp['company'];
		// To the projects associated with the company
			$que2 = "SELECT *  FROM  projects where year(project_start_date)='$year' and user_company_id='$company' and month(project_start_date) IN ($month_string)";
			$db->execute($que2);

			$Generalprojects=array();
			while($rowc2 = $db->fetch())
			{
				$Generalprojects[]=$rowc2;
			}

			$projectDetailsCount='0';
			$invite_count=0;
			foreach ($Generalprojects as $key1 => $proj) {
				$project=$proj['id'];

		 // to get the Dcr count
				for($m=$ival[0];$m<=$ival[2];$m++)
				{
					$innerque1 = "SELECT count(*) as count FROM  `jobsite_daily_logs`  as jdl  where year(jdl.jobsite_daily_log_created_date)='$year' and month(jdl.jobsite_daily_log_created_date)='$m' and jdl.project_id='$project'";
					$db->execute($innerque1);
					$rowi1 = $db->fetch();
					$projectDetailsCount=$projectDetailsCount+$rowi1['count'];

			// To get the invited to bidders count
					$innerque2 = "SELECT count( * ) AS count FROM `gc_budget_line_items` gbli INNER JOIN `subcontractor_bids` sb ON gbli.`id` = sb.`gc_budget_line_item_id` INNER JOIN `subcontractor_bid_statuses` sbs ON sb.`subcontractor_bid_status_id` = sbs.`id` WHERE gbli.`user_company_id` = '$company' AND gbli.`project_id` = '$project' AND  year(gbli.`created`) = '$year' And month(gbli.`created`)='$m' AND sb.`subcontractor_bid_status_id` IN ( 2 ) ";
					$db->execute($innerque2);
					$rowi2 = $db->fetch();
					$invite_count=$invite_count+$rowi2['count'];



				}

				$median =$median+calculate_mediannew($median_arr);
			}

			if(($type=='active')&&(($projectDetailsCount >='7')||($invite_count >='10')))
			{
				
				$activeData[$key]['company']=$company_name;
				$activeData[$key]['count']=$projectDetailsCount;
			}
			if(($type=='dormant') &&((($projectDetailsCount >='0' && $projectDetailsCount < '7' )) || (($invite_count >='0' && $invite_count < '10' ) && ($projectDetailsCount >='0' && $projectDetailsCount < '7' ))))
			{

				$activeData[$key]['company']=$company_name;
				$activeData[$key]['count']=$projectDetailsCount;
			}

		}

	}
	if($_POST['period']=="monthly")
	{


		$que1 = "SELECT *  FROM  user_companies where year(created_date)='$year' and month(created_date)='$month'";
		$db->execute($que1);
		$GeneralCompanies=array();
		while($rowc1 = $db->fetch())
		{
			$GeneralCompanies[]=$rowc1;
		}

		$activeData=array();
		$dormantData=array();
		foreach ($GeneralCompanies as $key => $comp) {
			$company=$comp['id'];
			$company_name=$comp['company'];
		// To the projects associated with the company
			$que2 = "SELECT *  FROM  projects where year(project_start_date)='$year'and month(project_start_date)='$month' and user_company_id='$company'";
			$db->execute($que2);

			$Generalprojects=array();
			while($rowc2 = $db->fetch())
			{
				$Generalprojects[]=$rowc2;
			}

			$projectDetailsCount='0';
			$invite_count=0;
			foreach ($Generalprojects as $key1 => $proj) {
				$project=$proj['id'];

		// to get the Dcr count
				for($i=0;$i<=4;$i++)
				{
					if($i=='0')
					{
						$date="And day(jdl.jobsite_daily_log_created_date) between '1' and '7'";
						$date1="And day(gbli.`created`) between '1' and '7'";
					}else if($i=='1')
					{
						$date="And day(jdl.jobsite_daily_log_created_date) between '8' and '14'";
						$date1="And day(gbli.`created`) between '8' and '14'";
					}else if($i=='2')
					{
						$date="And day(jdl.jobsite_daily_log_created_date) between '15' and '21'";
						$date1="And day(gbli.`created`) between '15' and '21'";
					}else if($i=='3')
					{
						$date="And day(jdl.jobsite_daily_log_created_date) between '22' and '28'";
						$date1="And day(gbli.`created`) between '22' and '28'";
					}
					else if($i=='4')
					{
						$date="And day(jdl.jobsite_daily_log_created_date) between '29' and '31'";
						$date1="And day(gbli.`created`) between '29' and '31'";
					}
					$innerque1 = "SELECT count(*) as count FROM  `jobsite_daily_logs`  as jdl  where year(jdl.jobsite_daily_log_created_date)='$year' and month(jdl.jobsite_daily_log_created_date)='$month' $date and jdl.project_id='$project'";
					$db->execute($innerque1);
					$rowi1 = $db->fetch();
					$projectDetailsCount=$projectDetailsCount+$rowi1['count'];
		// To get the invited to bidders count
					$innerque2 = "SELECT count( * ) AS count FROM `gc_budget_line_items` gbli INNER JOIN `subcontractor_bids` sb ON gbli.`id` = sb.`gc_budget_line_item_id` INNER JOIN `subcontractor_bid_statuses` sbs ON sb.`subcontractor_bid_status_id` = sbs.`id` WHERE gbli.`user_company_id` = '$company' AND gbli.`project_id` = '$project' AND  year(gbli.`created`) = '$year' And month(gbli.`created`)='$month' $date1 AND sb.`subcontractor_bid_status_id` IN ( 2 ) ";
					$db->execute($innerque2);
					$rowi2 = $db->fetch();
					$invite_count=$invite_count+$rowi2['count'];

				}


			}
			if(($type=='active')&&(($projectDetailsCount >='2'  ) ||($invite_count >='2')))
			{
				
				$activeData[$key]['company']=$company_name;
				$activeData[$key]['count']=$projectDetailsCount;
	} //Once a company goes to active it should not be in Dormant
	if(($type=='dormant') &&(($projectDetailsCount >='0' && $projectDetailsCount < '2' )||($invite_count=='0' && ($projectDetailsCount >='0' && $projectDetailsCount < '2'))))
	{
		
		$activeData[$key]['company']=$company_name;
		$activeData[$key]['count']=$projectDetailsCount;
	}

}

}
$chart_date='';
$company_datas='';


foreach ($activeData as $key => $value) {
	$chart_date.=$value['count'].",";
	$company_datas.="\"".str_replace(","," ",$value['company'])."\",";
}
if($chart_date!='')
{
$chart_date = rtrim($chart_date,',');
$chart_date='['.$chart_date.']';
}
else
{
	$chart_date='[]';

}
if($company_datas!='')
{
$company_datas = rtrim($company_datas,',');
$company_datas='['.$company_datas.']';
}
else
{
	$company_datas="[]";
	$nodata="},
	function(chart) { // on complete

		chart.renderer.text('No Data Available', 140, 100)
		.css({
			color: '#FFFFFF',
			fontSize: '13px'
		})
		.add();";

}


echo "<div id='DCRCharts' ></div>";
?>		
<script>
	Highcharts.chart('DCRCharts', {
		chart: {
			backgroundColor:'rgba(255, 255, 255, 0.0)'
		},
		title: {
			text: 'Customer Health Index'
		},
		subtitle: {
			text: ''
		},
		colors:['#FFFFFF'],
		yAxis: {
			gridLineColor: 'transparent',
			lineColor: 'transparent',
			title: {
        		text: ''
        	},
			labels:
			{
				style: {
        			color: '#FFFFFF'
        		} 
			}



		},
		xAxis: {
			gridLineColor: 'transparent',
			lineColor: 'transparent',
			minorGridLineWidth: 0,
			minorTickLength: 0,
			tickLength: 0,
			
			title: {
				
				style: {
					color: '#FFFFFF'
				} 
			},
			categories: <?php echo $company_datas?>,
			labels:
			{
				enabled: false
			}


		},
		series: [{
			showInLegend: false,
			name: ' ',
			data: <?php echo $chart_date?>,
		}]
	<?php echo $nodata;?>
	});
	</script>
	<?php
	
}

//SignUp Function
if(isset($_POST['method']) && $_POST['method']=="SignUp")
{
	/*Variable*/
	$period=$_POST['period'];
	$SlideContent='';
	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$CompaniesCount = GetCompaniesOverAllCount();
		$SlideContent = <<<YearTillCount
		<div class="SlideContent FirstInTop">
			<div class="CountNo">
				$CompaniesCount
			</div>
			<div class="DaysCount">
			</div>
		</div>
		<div class="SlideContentSec FirstInDown">
			<div class="IndexContent">
				SignUp
			</div>
			<div class="DaysCount">
			</div>
		</div>
YearTillCount;
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthAndWeekCompanies($quatorArray);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthAndWeekCompanies($weekArray, 'Week');
	}
	echo $SlideContent;
}
//ActiveProjects count for Admin Function
if(isset($_POST['method']) && $_POST['method']=="ProjectAdmin")
{
	
	/*Variable*/
	$period=$_POST['period'];
	$SlideContent='';
	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$CompaniesCount = GetCompaniesActiveProjectAllCount($user_company_id, $primary_contact_id, $user_id);
		$SlideContent = <<<YearTillCount
		<div class="SlideContent FirstInTop">
			<div class="CountNo">
				$CompaniesCount
			</div>
			<div class="DaysCount">
			</div>
		</div>
		<div class="SlideContentSec FirstInDown">
			<div class="IndexContent">
				Active Project
			</div>
			<div class="DaysCount">
			</div>
		</div>
YearTillCount;
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthAndWeekCompaniesActiveProjects($database, $quatorArray, $user_company_id, $primary_contact_id, $user_id);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthAndWeekCompaniesActiveProjects($database, $weekArray, $user_company_id, $primary_contact_id, $user_id, 'Week');
	}
	echo $SlideContent;
}
// To get the total RFI count
if(isset($_POST['method']) && $_POST['method']=="RFIAdmin")
{
	
	/*Variable*/
	if(isset($_POST['period']))
	{
		$period = $_POST['period'];
	}else{
		$period = '';
	}
	$SlideContent='';
	//to get the project ids
	$project_ids="";
	$db = DBI::getInstance($database);
	$queryYear = "SELECT pr.id as project_id FROM contacts c, projects_to_contacts_to_roles p2c2r,projects pr WHERE p2c2r.contact_id <> $primary_contact_id AND c.user_company_id <> $user_company_id AND c.user_id = $user_id AND c.`id` <> $primary_contact_id AND c.`id` = p2c2r.contact_id  AND p2c2r.project_id = pr.id ";
	$db->execute($queryYear);
	while($rowc1 = $db->fetch())
		{
	$project_ids.="'".$rowc1['project_id']."',";
	}
	$db->free_result();

	 $query = "SELECT id as project_id FROM projects where user_company_id = $user_company_id  ";
	$db->execute($query);
	while($rowc2 = $db->fetch())
		{
	$project_ids .="'".$rowc2['project_id']."',";
	}
	$db->free_result();
	$project_ids=rtrim($project_ids,',');
	
	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$CompaniesCount = GetProjectRFICount($user_company_id, $primary_contact_id, $user_id,$project_ids);
		$SlideContent = <<<YearTillCount
		<div class="SlideContent FirstInTop">
			<div class="CountNo">
				$CompaniesCount
			</div>
			<div class="DaysCount">
			</div>
		</div>
		<div class="SlideContentSec FirstInDown">
			<div class="IndexContent">
				Open RFI
			</div>
			<div class="DaysCount">
			</div>
		</div>
YearTillCount;
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthRFI($quatorArray, $user_company_id, $primary_contact_id, $user_id,$project_ids);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthRFI($weekArray, $user_company_id, $primary_contact_id, $user_id,$project_ids, 'Week');
	}
	echo $SlideContent;
}
// To get the total RFI count for project manager
if(isset($_POST['method']) && $_POST['method']=="RFIManager")
{
	
	/*Variable*/
	if(isset($_POST['period']))
	{
		$period = $_POST['period'];
	}else{
		$period = '';
	}
	$SlideContent='';
    //to get the project ids where a contact is project manager
	$project_ids="";
	$db = DBI::getInstance($database);
	$queryYear = "SELECT * FROM `projects_to_contacts_to_roles` WHERE `contact_id` =$primary_contact_id and `role_id`='5'";
	$db->execute($queryYear);
	while($rowc1 = $db->fetch())
	{
	$project_ids.="'".$rowc1['project_id']."',";
	}
	$db->free_result();
	$project_ids=rtrim($project_ids,',');
	
	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$CompaniesCount = GetProjectRFICount($user_company_id, $primary_contact_id, $user_id,$project_ids);
		$SlideContent = <<<YearTillCount
		<div class="SlideContent FirstInTop">
			<div class="CountNo">
				$CompaniesCount
			</div>
			<div class="DaysCount">
			</div>
		</div>
		<div class="SlideContentSec FirstInDown">
			<div class="IndexContent">
				Open RFI
			</div>
			<div class="DaysCount">
			</div>
		</div>
YearTillCount;
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthRFI($quatorArray, $user_company_id, $primary_contact_id, $user_id,$project_ids);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthRFI($weekArray, $user_company_id, $primary_contact_id, $user_id,$project_ids, 'Week');
	}
	echo $SlideContent;
}

// To get the total closed RFIs
if(isset($_POST['method']) && $_POST['method']=="ClosedRFI")
{
	
	/*Variable*/
	$period=(isset($_POST['period']))?$_POST['period']:"";
	$SlideContent='';
	$PM_project_ids='';

	if($userRole == 'user'){
	$db = DBI::getInstance($database);
	$queryYear = "SELECT `project_id` FROM `projects_to_contacts_to_roles` WHERE `contact_id` = $primary_contact_id AND `role_id` = 5"; 
	$db->execute($queryYear);
	while($rowc1 = $db->fetch())
	{
	$PM_project_ids.="'".$rowc1['project_id']."',";
	}
	$PM_project_ids=trim($PM_project_ids,',');
	$inQuery="AND r.`project_id` IN ($PM_project_ids)";
	}


   	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$closedRFiCount = GetProjectClosedRFICount($database, $user_company_id, $primary_contact_id, $user_id,$PM_project_ids);
		//To get the closed RFI data
		$db = DBI::getInstance($database);
		$getCurdate = date('Y-m-d');
		$getstartdate = date('Y-01-01');
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `requests_for_information` as r 
		inner join projects as p on r.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE r.request_for_information_status_id='4' $inQuery and date(r.rfi_closed_date) BETWEEN '$getstartdate' AND '$getCurdate'  group by p.id order by count desc limit 3";
	$db->execute($sq1);
	$closedrfi='';
	while($rs2 = $db->fetch())
	{
		$labelTextRfiC = $rs2['project_name'].' ('.$rs2['company'].')';
		$projectName = $rs2['project_name'];
		$closedrfi.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextRfiC."'>".$projectName."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}
	// end of closed
		$SlideContent = <<<YearTillCount
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
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthclosedRFI($database, $quatorArray, $user_company_id, $primary_contact_id, $user_id,$PM_project_ids);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthclosedRFI($database, $weekArray, $user_company_id, $primary_contact_id,$user_id,$PM_project_ids, 'Week');
	}
	echo $SlideContent;
}

// To get the total closed Submittal
if(isset($_POST['method']) && $_POST['method']=="ClosedSubmittal")
{
	
	/*Variable*/
	$period=$_POST['period'];
	$SlideContent='';
	$project_ids='';
   	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$closedsubCount = GetProjectClosedSubmittalCount($database, $user_company_id, $primary_contact_id, $user_id,$project_ids);
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
		$SlideContent = <<<YearTillCount
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
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthclosedSubmittal($database, $quatorArray, $user_company_id, $primary_contact_id, $user_id,$project_ids);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthclosedSubmittal($database, $weekArray, $user_company_id, $primary_contact_id,$user_id,$project_ids, 'Week');
	}
	echo $SlideContent;
}

// To get the total closed Submittal for User
if(isset($_POST['method']) && $_POST['method']=="ClosedUserSubmittal")
{
	
	/*Variable*/
	$period =(isset($_POST['period']))?$_POST['period']:"";
	$SlideContent='';
	$db = DBI::getInstance($database);
	$queryYear = "SELECT `project_id` FROM `projects_to_contacts_to_roles` WHERE `contact_id` = $primary_contact_id AND `role_id` = 5"; 
	$db->execute($queryYear);
	$PM_project_ids='';
	while($rowc1 = $db->fetch())
	{
	$PM_project_ids.="'".$rowc1['project_id']."',";
	}
	$PM_project_ids=trim($PM_project_ids,',');


   	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$closedusersubCount = GetProjectClosedSubmittalCount($db,$user_company_id, $primary_contact_id, $user_id,$PM_project_ids);
		//To get the closed RFI data
		$db = DBI::getInstance($database);
		$getCurdate = date('Y-m-d');
		$getstartdate = date('Y-01-01');
		$sq1="SELECT count(*) as count, p.id,p.project_name,u.company FROM `submittals` as s
		inner join projects as p on s.project_id=p.id
		inner join user_companies as u on p.user_company_id=u.id
		 WHERE s.submittal_status_id IN ('2','3') and project_id IN ($PM_project_ids) and date(s.su_closed_date) BETWEEN '$getstartdate' AND '$getCurdate'  group by p.id order by count desc limit 3";
	$db->execute($sq1);
	$closedsub='';
	while($rs2 = $db->fetch())
	{
		$comdata=$rs2['project_name'].' - '.$rs2['company'];
		$closedsub.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$comdata."'>".$rs2['project_name']."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}
	// end of closed
		$SlideContent = <<<YearTillCount
		<div class="splitthrdleft">
		<div class=" bottomAlign">
		{$closedusersubCount}
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
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthclosedSubmittal($db,$quatorArray, $user_company_id, $primary_contact_id, $user_id,$PM_project_ids);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthclosedSubmittal($db,$weekArray, $user_company_id, $primary_contact_id,$user_id,$PM_project_ids, 'Week');
	}
	echo $SlideContent;
}


// To get the total Submittal count
if(isset($_POST['method']) && $_POST['method']=="SubmittalAdmin")
{
	
	/*Variable*/
	if(isset($_POST['period']))
	{
		$period = $_POST['period'];
	}else{
		$period = '';
	}
	$SlideContent='';
	//to get the project ids
	$project_ids="";
	$db = DBI::getInstance($database);
	$queryYear = "SELECT pr.id as project_id FROM contacts c, projects_to_contacts_to_roles p2c2r,projects pr WHERE p2c2r.contact_id <> $primary_contact_id AND c.user_company_id <> $user_company_id AND c.user_id = $user_id AND c.`id` <> $primary_contact_id AND c.`id` = p2c2r.contact_id  AND p2c2r.project_id = pr.id ";
	$db->execute($queryYear);
	while($rowc1 = $db->fetch())
		{
	$project_ids.="'".$rowc1['project_id']."',";
	}
	$db->free_result();

	 $query = "SELECT id as project_id FROM projects where user_company_id = $user_company_id  ";
	$db->execute($query);
	while($rowc2 = $db->fetch())
		{
	$project_ids .="'".$rowc2['project_id']."',";
	}
	$db->free_result();
	$project_ids=rtrim($project_ids,',');
	
	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$CompaniesCount = GetProjectsubmittalCount($user_company_id, $primary_contact_id, $user_id,$project_ids);
		$SlideContent = <<<YearTillCount
		<div class="SlideContent FirstInTop">
			<div class="CountNo">
				$CompaniesCount
			</div>
			<div class="DaysCount">
			</div>
		</div>
		<div class="SlideContentSec FirstInDown">
			<div class="IndexContent">
				Open Submittal
			</div>
			<div class="DaysCount">
			</div>
		</div>
YearTillCount;
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthSubmittal($quatorArray, $user_company_id, $primary_contact_id, $user_id,$project_ids);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthSubmittal($weekArray, $user_company_id, $primary_contact_id, $user_id,$project_ids, 'Week');
	}
	echo $SlideContent;
}
// To get the total Submittal count For user
if(isset($_POST['method']) && $_POST['method']=="SubmittalUser")
{
	
	/*Variable*/
	if(isset($_POST['period']))
	{
		$period = $_POST['period'];
	}else{
		$period = '';
	}	$SlideContent='';
	//to get the project ids where a contact is project manager
	$project_ids="";
	$db = DBI::getInstance($database);
	$queryYear = "SELECT * FROM `projects_to_contacts_to_roles` WHERE `contact_id` =$primary_contact_id and `role_id`='5' ";
	$db->execute($queryYear);
	while($rowc1 = $db->fetch())
		{
	$project_ids.="'".$rowc1['project_id']."',";
	}
	$db->free_result();

	$project_ids=rtrim($project_ids,',');
	
	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$CompaniesCount = GetProjectsubmittalCount($user_company_id, $primary_contact_id, $user_id,$project_ids);
		$SlideContent = <<<YearTillCount
		<div class="SlideContent FirstInTop">
			<div class="CountNo">
				$CompaniesCount
			</div>
			<div class="DaysCount">
			</div>
		</div>
		<div class="SlideContentSec FirstInDown">
			<div class="IndexContent">
				Open Submittal
			</div>
			<div class="DaysCount">
			</div>
		</div>
YearTillCount;
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthSubmittal($quatorArray, $user_company_id, $primary_contact_id, $user_id,$project_ids);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthSubmittal($weekArray, $user_company_id, $primary_contact_id, $user_id,$project_ids, 'Week');
	}
	echo $SlideContent;
}
/*Chart View*/
if(isset($_POST['method']) && $_POST['method']=="DCRChart")
{
	/*Variable*/
	if(isset($_POST['period']))
	{
		$period = $_POST['period'];
	}else{
		$period = '';
	}
	$countArray = 0;
	echo $SlideContent='<div id="DCRChart" class="DCRChart"></div>';
	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		$getCountYear = GetMonthsTillYear();
		$countArray = GetCountOfValue($database, $getCountYear,$period);
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the chart html from return function*/
		$countArray = GetCountOfValue($database, $quatorArray,$period);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$countArray = GetCountOfValue($database, $weekArray, $period);
	}
	$AllCount=count($countArray);
	$strdays='';
	$strval='';
	$actstrdays='';
	for($intvasl=0;$intvasl<($AllCount-1);$intvasl++){	
	if($countArray['curdate'] == $intvasl){
		$color = ",color:'#ffffff'";
		$actstrdays = $countArray[$intvasl][0];
	}
	else{
		$color = ",color:'#686d70'";
	}
		if($intvasl!=($AllCount-1)){
			$strdays.="'".$countArray[$intvasl][0]."',";
			$strval.="{y:".$countArray[$intvasl][1]."$color},";
		}
		else{
			$strdays.="'".$countArray[$intvasl][0]."'";
			$strval.="{y:".$countArray[$intvasl][1]."$color},";
		}
}
	?>
<script type="text/javascript">
var activeDate ='<?php echo $actstrdays;?>';
Highcharts.chart('DCRChart', {
		chart: {
			type: 'column',
			backgroundColor:'rgba(255, 255, 255, 0.0)'
		},
		title: {
			text: 'DCR Generated',
			align: 'left'
		},
		colors:['#666666'],	
        xAxis: {
        	gridLineColor: 'transparent',
        	lineColor: 'transparent',
        	minorGridLineWidth: 0,
        	lineWidth: 0,
        	minorTickLength: 0,
        	tickLength: 0,    	
        	categories: [<?php echo $strdays?>
        	],
        	crosshair: true,
        	labels:
        	{
        		rotation: -45,
        		style: {
        			color: ''
        		},
        		formatter: function () {
        			if ( activeDate === this.value) {
            			return '<span style="fill: #ffffff;">' + this.value + '</span>';
        			} else {
            			return '<span style="fill: #3F343D;">' + this.value + '</span>';
        			}
			    }
        	}
        },
        yAxis: {
        	gridLineColor: 'transparent',
        	lineColor: 'transparent',
        	min: 0,
        	title: {
        		text: ''
        	},
        	labels:
        	{
        		enabled: false
        	}
        },
        tooltip: {
        	pointFormat: '<tr><td style="color:{series.color};padding:0">DCR {point.name}: </td>' +
        	'<td style="padding:0"><b>{point.y:f}</b></td></tr>',
        	footerFormat: '</table>',
        	shared: true,
        	useHTML: true
        },
        plotOptions: {
        	column: {
        		pointPadding: 0.2,
        		borderWidth: 0,
        		
    }
},
series: [{
	showInLegend: false,
        data: [<?php echo $strval?> ]
    }]
});
</script>
	<?php
}
//View Open submittal for Global_Admin
if(isset($_POST['method']) && $_POST['method']=="ViewOpenSubmittal")
{
	$db = DBI::getInstance($database);
	
	$k=1;
	$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `submittals` as s 
	inner join projects as p on s.project_id=p.id
	inner join user_companies as uc on uc.id = p.user_company_id
	WHERE s.submittal_status_id='5' group by p.id order by count desc  ";
	$db->execute($sq1);
	$tableBody='';
	$prj_data=array();
	while($rs2 = $db->fetch())
	{
		$prj_data[]=$rs2;
	}
	$tot_count=count($prj_data);
	foreach ($prj_data as$rs2) {
	
	$project_id=$rs2['id'];
	$project_name=$rs2['project_name'];
	$count = $rs2['count'];
	$company = $rs2['company'];
	if($tot_count==$k && $tot_count!='1')
		{
			$class="up_sub_open";
		}else
		{
			$class="";
		}
		$tableBody.=<<<TableContent
		<tr class="">
		<td>$k</td>
		<td><span data-toggle=tooltip title='' data-original-title="$company">$project_name</span></td>
		<td style="position:relative;" class="$class"><span id="prj_sub_$project_id" class="dropbtn_$project_id tooltip-user hyperdown" onclick="load_openSubmital($project_id)">$count</span>
		<div id="submittalOpenItem_$project_id" class="dropdown-content">
		</div></td>
		</tr>
TableContent;

	$k++;
	}
	$db->free_result();
	if($tableBody!=''){
		$style='style="height:400px;overflow-y:scroll;overflow-x:hidden;"';
	}else{
		$style='';
		$tableBody ="<tr><td colspan='3'>Data's Not Available</td></tr>";
	}
$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="dashboardmodalClose();">&times;</span>
      <h3>Open Submittal Index</h3>
    </div>
    <div class="modal-body" $style>
    <div class="tableview" >
     <table class="UserViews" width="100%" cellpadding="5">
     <thead>
     <tr>
     <td >No</td>
     <td >Projects</td>
     <td >No of Item Open</td>
     </tr>
     </thead>
     <tbody>
     $tableBody
     </tbody>
     </table>
     </div>
    </div>
    <div class="myPopover hidden" id="pop_data"></div>
    <div class="modal-footer">
    	   <button class="buttonClose" onclick="dashboardmodalClose();">Close</button>
    </div>
  </div>
modalContent;
echo $modalContent;
}

//View Open Submittal for User
if(isset($_POST['method']) && $_POST['method']=="ViewUserOpensubmittal")
{
	$db = DBI::getInstance($database);
	$queryYear = "SELECT `project_id` FROM `projects_to_contacts_to_roles` WHERE `contact_id` = $primary_contact_id AND `role_id` = 5"; 
	$db->execute($queryYear);
	$PM_project_ids='';
	while($rowc1 = $db->fetch())
	{
	$PM_project_ids.="'".$rowc1['project_id']."',";
	}
	$PM_project_ids=trim($PM_project_ids,',');
	
	$k=1;
	$sq1="SELECT count(*) as count, p.id,p.project_name,u.company FROM `submittals` as s inner join projects as p on s.project_id=p.id inner join user_companies as u on p.user_company_id=u.id 
	WHERE s.submittal_status_id='5' and s.project_id IN ($PM_project_ids) group by p.id order by count desc";
	$db->execute($sq1);
	$tableBody='';
	$prj_data=array();
	while($rs2 = $db->fetch())
	{
		$prj_data[]=$rs2;
	}
	$tot_count=count($prj_data);
	foreach ($prj_data as$rs2) {
	
	$project_id=$rs2['id'];
	$project_name=$rs2['project_name'];
	$com_data=$rs2['project_name'].' - '.$rs2['company'];
	$count = $rs2['count'];
	if($tot_count==$k && $tot_count!='1')
		{
			$class="up_sub_open";
		}else
		{
			$class="";
		}
		$tableBody.=<<<TableContent
		<tr class="">
		<td>$k</td>
		<td ><span data-toggle='tooltip'  title='' data-original-title='$com_data'>$project_name</span></td>
		<td style="position:relative;" class="$class"><span id="prj_sub_$project_id" class="dropbtn_$project_id tooltip-user hyperdown" onclick="load_openSubmital($project_id)">$count</span>
		<div id="submittalOpenItem_$project_id" class="dropdown-content">
		</div></td>
		</tr>
TableContent;

	$k++;
	}
	$db->free_result();
	if($tableBody!=''){
		$style='style="height:150px;overflow-y:scroll;overflow-x:hidden;"';
	}else{
		$style='';
		$tableBody ="<tr><td colspan='3'>Data's Not Available</td></tr>";
	}
$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="dashboardmodalClose();">&times;</span>
      <h3>Open Submittal Index</h3>
    </div>
    <div class="modal-body" $style>
    <div class="tableview" >
     <table class="UserViews" width="100%" cellpadding="5">
     <thead>
     <tr>
     <td >No</td>
     <td width="60%">Projects</td>
     <td >No of Item Open</td>
     </tr>
     </thead>
     <tbody>
     $tableBody
     </tbody>
     </table>
     </div>
    </div>
    <div class="myPopover hidden" id="pop_data"></div>
    <div class="modal-footer">
    	   <button class="buttonClose" onclick="dashboardmodalClose();">Close</button>
    </div>
  </div>
modalContent;
echo $modalContent;
}


//View Open RFI for Global_Admin
if(isset($_POST['method']) && $_POST['method']=="ViewOpenRFI")
{
	$db = DBI::getInstance($database);
	
	$k=1;
	$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `requests_for_information` as r 
	inner join projects as p on r.project_id=p.id
	inner join user_companies as uc on uc.id = p.user_company_id
	WHERE r.request_for_information_status_id='2' group by p.id order by count desc";
	$db->execute($sq1);
	$tableBody='';
	$prj_data=array();
	while($rs2 = $db->fetch())
	{
		$prj_data[]=$rs2;
	}
	$tot_count=count($prj_data);
	foreach ($prj_data as$rs2) {
	
	$project_id=$rs2['id'];
	$project_name=$rs2['project_name'];
	$count = $rs2['count'];
	$company = $rs2['company'];
	if($tot_count==$k && $tot_count!='1')
		{
			$class="up_sub_open";
		}else
		{
			$class="";
		}
		$tableBody.=<<<TableContent
		<tr class="">
		<td>$k</td>
		<td><span data-toggle=tooltip data-original-title="$company">$project_name</span></td>
		<td style="position:relative;" class="$class"><span id="prj_sub_$project_id" class="dropbtn_$project_id tooltip-user hyperdown" onclick="load_openRFI($project_id)">$count</span>
		<div id="rfiOpenItem_$project_id" class="dropdown-content">
		</div></td>
		</tr>
TableContent;

	$k++;
	}
	$db->free_result();
	if($tableBody!=''){
		$style='style="height:400px;overflow-y:scroll;overflow-x:hidden;"';
	}else{
		$style='';
		$tableBody ="<tr><td colspan='3'>Data's Not Available</td></tr>";
	}
$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="dashboardmodalClose();">&times;</span>
      <h3>Open RFI Index</h3>
    </div>
    <div class="modal-body" $style>
    <div class="tableview" >
     <table class="UserViews" width="100%" cellpadding="5">
     <thead>
     <tr>
     <td >No</td>
     <td >Projects</td>
     <td >No of Item Open</td>
     </tr>
     </thead>
     <tbody>
     $tableBody
     </tbody>
     </table>
     </div>
    </div>
    <div class="myPopover hidden" id="pop_data"></div>
    <div class="modal-footer">
    	   <button class="buttonClose" onclick="dashboardmodalClose();">Close</button>
    </div>
  </div>
modalContent;
echo $modalContent;
}

//View Open RFI for User
if(isset($_POST['method']) && $_POST['method']=="ViewUserOpenRFI")
{
	$db = DBI::getInstance($database);
	$queryYear = "SELECT `project_id` FROM `projects_to_contacts_to_roles` WHERE `contact_id` = $primary_contact_id AND `role_id` = 5"; 
	$db->execute($queryYear);
	$PM_project_ids='';
	while($rowc1 = $db->fetch())
	{
	$PM_project_ids.="'".$rowc1['project_id']."',";
	}
	$PM_project_ids=trim($PM_project_ids,',');
	
	$k=1;
	$sq1="SELECT count(*) as count, p.id,p.project_name,u.company FROM `requests_for_information` as r inner join projects as p on r.project_id=p.id
	inner join user_companies as u on p.user_company_id=u.id 
	WHERE r.request_for_information_status_id='2' and r.project_id IN ($PM_project_ids) group by p.id order by count desc";
	$db->execute($sq1);
	$tableBody='';
	$prj_data=array();
	while($rs2 = $db->fetch())
	{
		$prj_data[]=$rs2;
	}
	$tot_count=count($prj_data);
	foreach ($prj_data as$rs2) {
	
	$project_id=$rs2['id'];
	$project_name=$rs2['project_name'];
	$com_data=$rs2['project_name'].' - '.$rs2['company'];
	$count = $rs2['count'];
	if($tot_count==$k && $tot_count!='1')
		{
			$class="up_sub_open";
		}else
		{
			$class="";
		}
		$tableBody.=<<<TableContent
		<tr class="">
		<td>$k</td>
		<td ><span data-toggle='tooltip'  title='' data-original-title='$com_data'>$project_name</span></td>
		<td style="position:relative;" class="$class"><span id="prj_sub_$project_id" class="dropbtn_$project_id tooltip-user hyperdown" onclick="load_openRFI($project_id)">$count</span>
		<div id="rfiOpenItem_$project_id" class="dropdown-content">
		</div></td>
		</tr>
TableContent;

	$k++;
	}
	$db->free_result();
	if($tableBody!=''){
		$style='style="height:150px;overflow-y:scroll;overflow-x:hidden;"';
	}else{
		$style='';
		$tableBody ="<tr><td colspan='3'>Data's Not Available</td></tr>";
	}
$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="dashboardmodalClose();">&times;</span>
      <h3>Open RFI Index</h3>
    </div>
    <div class="modal-body" $style>
    <div class="tableview" >
     <table class="UserViews" width="100%" cellpadding="5">
     <thead>
     <tr>
     <td >No</td>
     <td width="60%">Projects</td>
     <td >No of Item Open</td>
     </tr>
     </thead>
     <tbody>
     $tableBody
     </tbody>
     </table>
     </div>
    </div>
    <div class="myPopover hidden" id="pop_data"></div>
    <div class="modal-footer">
    	   <button class="buttonClose" onclick="dashboardmodalClose();">Close</button>
    </div>
  </div>
modalContent;
echo $modalContent;
}

//View Closed RFI for Global_Admin
if(isset($_POST['method']) && $_POST['method']=="ViewClosedRFI")
{
	$inQuery = '';
	if($userRole == 'admin'){
		$inQuery = "AND r.`project_id` IN ($arrProjectsIdIndexJoin)";
	}
	if($userRole == 'user'){
	$db = DBI::getInstance($database);
	$queryYear = "SELECT `project_id` FROM `projects_to_contacts_to_roles` WHERE `contact_id` = $primary_contact_id AND `role_id` = 5"; 
	$db->execute($queryYear);
	$PM_project_ids='';
	while($rowc1 = $db->fetch())
	{
	$PM_project_ids.="'".$rowc1['project_id']."',";
	}
	$PM_project_ids=trim($PM_project_ids,',');
	$inQuery = "AND r.`project_id` IN ($PM_project_ids)";
	}
	/*Variable*/
	$period=$_POST['period'];
	$tableBody='';
   	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		
		//To get the closed RFI data
		$db = DBI::getInstance($database);
		$getCurdate = date('Y-m-d');
		$getstartdate = date('Y-01-01');
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `requests_for_information` as r
		inner join projects as p on r.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE r.request_for_information_status_id='4' $inQuery and date(r.rfi_closed_date) BETWEEN '$getstartdate' AND '$getCurdate'  group by p.id order by count desc ";
	$db->execute($sq1);
	$k='1';
	
	while($rs2 = $db->fetch())
	{
		$company = $rs2['company'];
		$project_name = $rs2['project_name'];
		$tableBody .= "<tr><td>$k</td><td class=''><span data-toggle=tooltip title='' data-original-title='".$company."'>$project_name</span></td><td class=''>".$rs2['count']."</td></tr>";
		$k++;
	}

	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		$filterStartDate=$quatorArray['Months']['StartDate'];
		$filterEndDate=$quatorArray['Months']['EndDate'];
		$tableBody='';

		//To get the closed RFI Project Wise
		$db = DBI::getInstance($database);
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `requests_for_information` as r
		inner join projects as p on r.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE r.request_for_information_status_id='4' $inQuery and date(r.rfi_closed_date) BETWEEN '$filterStartDate' AND '$filterEndDate'  group by p.id order by count desc";
		$db->execute($sq1);
		$k='1';
		while($rs2 = $db->fetch())
		{
			$company = $rs2['company'];
			$project_name = $rs2['project_name'];
			$tableBody .= "<tr><td>$k</td><td class=''><span data-toggle=tooltip title='' data-original-title='".$company."'>$project_name</span></td><td class=''>".$rs2['count']."</td></tr>";
			$k++;	
		}
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$filterStartDate=$weekArray['Months']['StartDate'];
		$filterEndDate=$weekArray['Months']['EndDate'];
		$tableBody='';
		//To get the closed RFI Project Wise
		$db = DBI::getInstance($database);
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `requests_for_information` as r
		inner join projects as p on r.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE r.request_for_information_status_id='4' $inQuery and date(r.rfi_closed_date) BETWEEN '$filterStartDate' AND '$filterEndDate'  group by p.id order by count desc";
		$db->execute($sq1);
		$k='1';
		while($rs2 = $db->fetch())
		{
	
			$company = $rs2['company'];
			$project_name = $rs2['project_name'];
			$tableBody .= "<tr><td>$k</td><td class=''><span data-toggle=tooltip title='' data-original-title='".$company."'>$project_name</span></td><td class=''>".$rs2['count']."</td></tr>";
			$k++;
		}
	}
$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="dashboardmodalClose();">&times;</span>
      <h3>Closed RFI Index</h3>
    </div>
    <div class="modal-body" $style>
    <div class="tableview" >
     <table class="UserViews" width="100%" cellpadding="5">
     <thead>
     <tr>
     <td >No</td>
     <td >Projects</td>
     <td >No of Items Closed</td>
     </tr>
     </thead>
     <tbody>
     $tableBody
     </tbody>
     </table>
     </div>
    </div>
    <div class="myPopover hidden" id="pop_data"></div>
    <div class="modal-footer">
    	   <button class="buttonClose" onclick="dashboardmodalClose();">Close</button>
    </div>
  </div>
modalContent;
echo $modalContent;
}


//View Closed Submittal for Global_Admin
if(isset($_POST['method']) && $_POST['method']=="ViewClosedSubmittal")
{
	$inQuery = '';
	if($userRole == 'admin'){
		$inQuery = "AND s.`project_id` IN ($arrProjectsIdIndexJoin)";
	}
	if($userRole == 'user'){
		$db = DBI::getInstance($database);
	$queryYear = "SELECT `project_id` FROM `projects_to_contacts_to_roles` WHERE `contact_id` = $primary_contact_id AND `role_id` = 5"; 
	$db->execute($queryYear);
	$PM_project_ids='';
	while($rowc1 = $db->fetch())
	{
	$PM_project_ids.="'".$rowc1['project_id']."',";
	}
	$PM_project_ids=trim($PM_project_ids,',');
	$inQuery = "AND s.`project_id` IN ($PM_project_ids)";
	}
	/*Variable*/
	$period=$_POST['period'];
	$tableBody='';
   	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		
		//To get the closed Submittal data
		$db = DBI::getInstance($database);
		$getCurdate = date('Y-m-d');
		$getstartdate = date('Y-01-01');

		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `submittals` as s 
		inner join projects as p on s.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE s.submittal_status_id IN ('2','3') $inQuery and date(s.su_closed_date) BETWEEN '$getstartdate' AND '$getCurdate'  group by p.id order by count desc";
	$db->execute($sq1);
	$k='1';
	
	while($rs2 = $db->fetch())
	{
	$company = $rs2['company'];
	$project_name = $rs2['project_name'];
	$tableBody .= "<tr><td>$k</td><td class=''><span data-toggle=tooltip title='' data-original-title='".$company."'>$project_name</span></td><td class=''>".$rs2['count']."</td></tr>";
	$k++;

	}

	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		$filterStartDate=$quatorArray['Months']['StartDate'];
		$filterEndDate=$quatorArray['Months']['EndDate'];
		$tableBody='';

		//To get the closed Submittal Project Wise
		$db = DBI::getInstance($database);
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `submittals` as s 
		inner join projects as p on s.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE s.submittal_status_id IN ('2','3') $inQuery and date(s.su_closed_date) BETWEEN '$filterStartDate' AND '$filterEndDate'  group by p.id order by count desc";
		$db->execute($sq1);
		$k='1';
		while($rs2 = $db->fetch())
		{
			$company = $rs2['company'];
			$project_name = $rs2['project_name'];
			$tableBody .= "<tr><td>$k</td><td class=''><span data-toggle=tooltip title='' data-original-title='".$company."'>$project_name</span></td><td class=''>".$rs2['count']."</td></tr>";
			$k++;	
		}
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$filterStartDate=$weekArray['Months']['StartDate'];
		$filterEndDate=$weekArray['Months']['EndDate'];
		$tableBody='';
		//To get the closed RFI Project Wise
		$db = DBI::getInstance($database);
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `submittals` as s
		inner join projects as p on s.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE s.submittal_status_id IN ('2','3') $inQuery and date(s.su_closed_date) BETWEEN '$filterStartDate' AND '$filterEndDate'  group by p.id order by count desc";
		$db->execute($sq1);
		$k='1';
		while($rs2 = $db->fetch())
		{
	
			$company = $rs2['company'];
			$project_name = $rs2['project_name'];
			$tableBody .= "<tr><td>$k</td><td class=''><span data-toggle=tooltip title='' data-original-title='".$company."'>$project_name</span></td><td class=''>".$rs2['count']."</td></tr>";
			$k++;
		}
	}
$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="dashboardmodalClose();">&times;</span>
      <h3>Closed Submittal Index</h3>
    </div>
    <div class="modal-body" $style>
    <div class="tableview" >
     <table class="UserViews" width="100%" cellpadding="5">
     <thead>
     <tr>
     <td >No</td>
     <td >Projects</td>
     <td >No of Items Closed</td>
     </tr>
     </thead>
     <tbody>
     $tableBody
     </tbody>
     </table>
     </div>
    </div>
    <div class="myPopover hidden" id="pop_data"></div>
    <div class="modal-footer">
    	   <button class="buttonClose" onclick="dashboardmodalClose();">Close</button>
    </div>
  </div>
modalContent;
echo $modalContent;
}

//open RFI for Global Admin tooltip
if(isset($_POST['method']) && $_POST['method']=="load_openRFI")

{
	$db = DBI::getInstance($database);
	$project=$_POST['val'];
	 $query3 = "SELECT * FROM `requests_for_information` WHERE `project_id` = '$project' and request_for_information_status_id='2'  ORDER BY `created` ASC";
	$db->execute($query3);
	
	$signCompanies='<ul style="list-style:none; margin:0; padding:0"><li><span class="dropcont"><b>Index</b></span><span class="dropcont"><b>Title</b>
	</span></li>';
	$i='1';
	while($row3 = $db->fetch())
	{
		$signCompanies.="<li class=drop-inner><span class=dropcont style='float:left'>".$row3['rfi_sequence_number'].')</span><span class=drop-title> '.$row3['rfi_title'].'</span></li>';
		$i++;
	}
	$signCompanies .='</ul>';
	echo $signCompanies;
}
//ViewUsers for Global_Admin
if(isset($_POST['method']) && $_POST['method']=="ViewUsers")
{
	//To get Top 3 companies with highest users 
	$tableBody='';
	$db = DBI::getInstance($database);
	$pastDays=date('Y-m-d', strtotime('today - 30 days'));
	$cur_date=date('Y-m-d');
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
	$signCompanies[$k]['user_company_id']=$Companies_id;
	$signCompanies[$k]['count']=($row3['count'])?$row3['count']:'0';
	$k++;
	
}
$signCompanies[]=usort($signCompanies, function ($a, $b) { return $b['count'] - $a['count']; });

	
	$intValue=1;
	foreach ($signCompanies as $key => $Company) {
	
		if($Company['company']!='')
		{
		$company_id=$Company['user_company_id'];
		$company = $Company['company'];
		$count = $Company['count'];
		$tableBody.=<<<TableContent
		<tr class="load">
		<td>$intValue</td>
		<td>$company</td>
		<td><span id="comp_$company_id" class="tooltip-user hyperdown" onclick="load_user($company_id)">$count</span></td>
		</tr>
TableContent;
$intValue++;
}
	}
	$db->free_result();
	if($tableBody!=''){
		$style='style="height:400px;overflow-y:scroll;"';
	}else{
		$style='';
		$tableBody ="<tr><td colspan='3'>Data's Not Available</td></tr>";
	}
$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="dashboardmodalClose();">&times;</span>
      <h3>User Index</h3>
    </div>
    <div class="modal-body">
    <div class="tableview" $style>
     <table class="UserViews" width="100%" cellpadding="5">
     <thead>
     <tr>
     <td>No</td>
     <td>General Contractor</td>
     <td>Active Users</td>
     </tr>
     </thead>
     <tbody>
     $tableBody
     </tbody>
     </table>
     </div>
    </div>
    <div class="myPopover hidden" id="pop_data"></div>
    <div class="modal-footer">
    	   <button class="buttonClose" onclick="dashboardmodalClose();">Close</button>
    </div>
  </div>
modalContent;
echo $modalContent;
}
//method for user Index for Admin
if(isset($_POST['method']) && $_POST['method']=="ViewadminUsers")
{
	$user_company_id = $session->getUserCompanyId();
	$user_id = $session->getUserId();

	//To get Top 3 companies with highest users 
	$tableBody='';
	$db = DBI::getInstance($database);
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
	 $que4 = "SELECT  count(distinct contact_id) as count, project_id from projects_to_contacts_to_roles WHERE project_id IN ($next_proj_id) and role_id Not IN ('3') and contact_id Not IN($primary_id_taken)group by project_id";
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
	
	$other_company_projects=rtrim($other_company_projects,',');
	//to get other company projects
	  $que5 = "SELECT user_company_id FROM `projects` WHERE id IN ($other_company_projects)";
	$db->execute($que5);
	
	$signProject3=array();
	$def_company_id='';
	
	while($rowad5 = $db->fetch())
	{
		$signProject3[]=$rowad5;
	}
	foreach ($signProject3 as $key => $prj3) {
		$def_company_id.="'".$prj3['user_company_id']."',";
		
	}
	$def_company_id=rtrim($def_company_id,',');

	  $que6 = "SELECT u.user_company_id,p.project_name, p.is_active_flag,p.id ,(select count(*) from users where user_company_id IN ($def_company_id) and  role_id not IN ('3')) as count FROM `users`as u inner join projects as p on p.user_company_id = u.user_company_id where u.user_company_id IN ($def_company_id) and p.id IN($other_company_projects) and u.role_id not IN ('3') group by p.id ";
	$db->execute($que6);
	
	$signProject4=array();
	$projcountarr2=array();

	while($rowad6 = $db->fetch())
	{
		$signProject4[]=$rowad6;
	}
	foreach ($signProject4 as $key => $prj4) {
		$projcountarr2[$prj4['id']]=$prj4['count'];
		
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
	// output and 3 array
	foreach ($output as $k1 => $val1) {
		foreach ($projcountarr2 as $k2 => $val2) {
			if($k1==$k2)
			{
			
				$output[$k2]=$val1+$val2;
			}
	
	}
}
$outCount=count($output);

$output[]=arsort($output);
		$intValue=1;

	foreach ($output as $key => $Company) {
		
		if($intValue>$outCount)
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
	$tableBody.=<<<TableContent
		<tr>
		<td>$intValue</td>
		<td>$signProject5</td>
		<td>$Company</td>
		</tr>
TableContent;
$intValue++;
		
		
	}
	
	$signCompanies=array();
	$intValue=1;
	while($row3 = $db->fetch())
	{
		$signCompanies[]=$row3;
		$company = $row3['project_name'];
		$count = $row3['count'];
		$tableBody.=<<<TableContent
		<tr>
		<td>$intValue</td>
		<td>$company</td>
		<td>$count</td>
		</tr>
TableContent;
$intValue++;
	}
	$db->free_result();
	if($tableBody!=''){
		$style='style="max-height:400px;overflow-y:scroll;"';
	}else{
		$style='';
		$tableBody ="<tr><td colspan='3'>Data's Not Available</td></tr>";
	}
$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="dashboardmodalClose();">&times;</span>
      <h3>User Index</h3>
    </div>
    <div class="modal-body">
    <div class="tableview" $style>
     <table class="UserViews" width="100%" cellpadding="5">
     <thead>
     <tr>
     <td>No</td>
     <td>Project </td>
     <td>Users</td>
     </tr>
     </thead>
     <tbody>
     $tableBody
     </tbody>
     </table>
     </div>
    </div>
    <div class="modal-footer">
    	   <button class="buttonClose" onclick="dashboardmodalClose();">Close</button>
    </div>
  </div>
modalContent;
echo $modalContent;
}
//open Submittal for Global Admin tooltip
if(isset($_POST['method']) && $_POST['method']=="load_openSubmital")

{
	$db = DBI::getInstance($database);
	$project=$_POST['val'];
	 $query3 = "SELECT * FROM `submittals` WHERE `project_id` = '$project' and submittal_status_id='5'  ORDER BY `created` ASC";
	$db->execute($query3);
	
	$signCompanies='<ul style="list-style:none; margin:0; padding:0">
	<li><span class="dropcont"><b>Index</b></span><span class="dropcont"><b>Title
	</b></span> </li>';
	$i='1';
	while($row3 = $db->fetch())
	{
		$signCompanies.="<li class=drop-inner><span class=dropcont style='float:left'>".$row3['su_sequence_number'].')</span><span class=drop-title> '.$row3['su_title'].'</span></li>';
		$i++;
	}
	$signCompanies .='</ul>';
	echo $signCompanies;
}
//Users Pop up
if(isset($_POST['method']) && $_POST['method']=="loaduser")

{
	
	$pastDays=date('Y-m-d', strtotime('today - 30 days'));
	$cur_date=date('Y-m-d');
	$db = DBI::getInstance($database);
	$user_company=$_POST['val'];
	 $query3 = "SELECT screen_name, email FROM `users` WHERE user_company_id = '$user_company' AND date( accessed ) BETWEEN '$pastDays' AND '$cur_date' LIMIT 0 , 30";
	$db->execute($query3);
	
	$signCompanies='';
	$i='1';
	while($row3 = $db->fetch())
	{
		$signCompanies.=$i.') '.$row3['screen_name'].' - '.$row3['email'].'<br/>';
		$i++;
	}
	
	echo $signCompanies;
}
//RFI REdirection
if(isset($_POST['method']) && $_POST['method']=="rfichecks")
{
		$db = DBI::getInstance($database);

	$rfi_id=$_POST['rfi_id'];
	$query1 = "SELECT r.project_id,p.project_name FROM `requests_for_information` as r inner join projects as p on p.id=r.project_id where r.id=$rfi_id ";
	$db->execute($query1);
	
	while($row1 = $db->fetch())
	{
	$project_id=$row1['project_id'];
	$project_name=$row1['project_name'];
	}
	echo $project_name.'~'.$project_id;
}
// View Open Submittal for Admin
if(isset($_POST['method']) && $_POST['method']=="ViewOpenSubmittalAdmin")
{
	// Open submittals
	$db = DBI::getInstance($database);

	$subOpenDetail = "SELECT count(*) AS count, p.id,p.project_name,company FROM `submittals` AS s 
	INNER JOIN projects AS p ON s.project_id = p.id
	INNER JOIN user_companies AS uc ON uc.id = p.user_company_id
	WHERE s.submittal_status_id='5' AND s.`project_id` IN ($arrProjectsIdIndexJoin) GROUP BY p.id ORDER BY count DESC LIMIT 3 ";
	$db->execute($subOpenDetail);
	$subOpenDetails = '';
	$tableBody = '';
	$prj_data = array();
	while($resultSubOpenDetails = $db->fetch())
	{
		$prj_data[] = $resultSubOpenDetails;
	}
	$k = 1;
	$tot_count=count($prj_data);
	foreach ($prj_data as$rs2) {		
		$project_id = $rs2['id'];
		$project_name = $rs2['project_name'];
		$count = $rs2['count'];
		$company = $rs2['company'];
		if($tot_count == $k)
		{
			// $class = "up_sub_open";
			$class = "";
		}else
		{
			$class = "";
		}
		$tableBody.=<<<TableContent
		<tr class="">
		<td>$k</td>
		<td><span data-toggle=tooltip title='' data-original-title="$company">$project_name</span></td>
		<td style="position:relative;" class="$class"><span id="prj_sub_$project_id" class="dropbtn_$project_id tooltip-user hyperdown" onclick="load_openSubmital($project_id)">$count</span>
		<div id="submittalOpenItem_$project_id" class="dropdown-content">
		</div></td>
		</tr>
TableContent;
		$k++;
	}
	$db->free_result();
	if($tableBody!=''){
		$style='style="height:400px;overflow-y:scroll;overflow-x:hidden;"';
	}else{
		$style='';
		$tableBody ="<tr><td colspan='3'>Data's Not Available</td></tr>";
	}
	$modalContent=<<<modalContent
	<div class="modal-content">
	<div class="modal-header">
	<span class="close" onclick="dashboardmodalClose();">&times;</span>
	<h3>Open Submittal Index</h3>
	</div>
	<div class="modal-body" $style>
	<div class="tableview" >
	<table class="UserViews" width="100%" cellpadding="5">
	<thead>
	<tr>
	<td >No</td>
	<td width="50%">Projects</td>
	<td >No of Item Open</td>
	</tr>
	</thead>
	<tbody>
	$tableBody
	</tbody>
	</table>
	</div>
	</div>
	<div class="myPopover hidden" id="pop_data"></div>
	<div class="modal-footer">
	<button class="buttonClose" onclick="dashboardmodalClose();">Close</button>
	</div>
	</div>
modalContent;
	echo $modalContent;
	// End Open submittals
}
// View Open Rfi for Admin
if(isset($_POST['method']) && $_POST['method']=="ViewOpenRfiAdmin")
{
	// Open submittals
	$db = DBI::getInstance($database);

	$rfiOpenDe = "SELECT count(*) AS count, p.id,p.project_name,company FROM `requests_for_information` AS r 
	INNER JOIN projects AS p ON r.project_id = p.id
	INNER JOIN user_companies AS uc ON uc.id = p.user_company_id
	WHERE r.request_for_information_status_id='2' AND r.`project_id` IN ($arrProjectsIdIndexJoin) GROUP BY p.id ORDER BY count DESC LIMIT 3";
	$db->execute($rfiOpenDe);

	$subOpenDetails = '';
	$tableBody = '';
	$prj_data = array();
	while($resultRfiOpenDetails = $db->fetch())
	{
		$prj_data[] = $resultRfiOpenDetails;
	}
	$k = 1;
	$tot_count=count($prj_data);
	foreach ($prj_data as$rs2) {		
		$project_id = $rs2['id'];
		$project_name = $rs2['project_name'];
		$count = $rs2['count'];
		$company = $rs2['company'];
		if($tot_count == $k)
		{
			// $class = "up_sub_open";
			$class = "";
		}else
		{
			$class = "";
		}
		$tableBody.=<<<TableContent
		<tr class="">
		<td>$k</td>
		<td><span data-toggle=tooltip title='' data-original-title="$company">$project_name</span></td>
		<td style="position:relative;" class="$class"><span id="prj_sub_$project_id" class="dropbtn_$project_id tooltip-user hyperdown" onclick="load_openRFI($project_id)">$count</span>
		<div id="rfiOpenItem_$project_id" class="dropdown-content">
		</div></td>
		</tr>
TableContent;
		$k++;
	}
	$db->free_result();
	if($tableBody!=''){
		$style='style="height:400px;overflow-y:scroll;overflow-x:hidden;"';
	}else{
		$style='';
		$tableBody ="<tr><td colspan='3'>Data's Not Available</td></tr>";
	}
	$modalContent=<<<modalContent
	<div class="modal-content">
	<div class="modal-header">
	<span class="close" onclick="dashboardmodalClose();">&times;</span>
	<h3>Open Submittal Index</h3>
	</div>
	<div class="modal-body" $style>
	<div class="tableview" >
	<table class="UserViews" width="100%" cellpadding="5">
	<thead>
	<tr>
	<td >No</td>
	<td width="50%">Projects</td>
	<td >No of Item Open</td>
	</tr>
	</thead>
	<tbody>
	$tableBody
	</tbody>
	</table>
	</div>
	</div>
	<div class="myPopover hidden" id="pop_data"></div>
	<div class="modal-footer">
	<button class="buttonClose" onclick="dashboardmodalClose();">Close</button>
	</div>
	</div>
modalContent;
	echo $modalContent;
	// End Open submittals
}

// To get the total closed RFIs for Admin
if(isset($_POST['method']) && $_POST['method']=="ClosedRFIAdmin")
{

	/*Variable*/
	$period=$_POST['period'];
	$SlideContent='';
	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$closedRFiCount = GetProjectClosedRFICount($database, $user_company_id, $primary_contact_id, $user_id, $arrProjectsIdIndexJoin, $userRole);
		//To get the closed RFI data
		$db = DBI::getInstance($database);
		$getCurdate = date('Y-m-d');
		$getstartdate = date('Y-01-01');
		$sq1="SELECT count(*) AS count, p.id,p.project_name,company FROM `requests_for_information` AS r 
		INNER JOIN projects AS p ON r.project_id = p.id
		INNER JOIN user_companies AS uc ON uc.id = p.user_company_id
		WHERE r.request_for_information_status_id = '4' AND r.`project_id` IN ($arrProjectsIdIndexJoin) AND date(r.rfi_closed_date) BETWEEN '$getstartdate' AND '$getCurdate'  GROUP BY p.id ORDER BY count DESC LIMIT 3";
		$db->execute($sq1);
		$closedrfi='';
		while($rs2 = $db->fetch())
		{
			$labelTextRfiC = $rs2['project_name'].' ('.$rs2['company'].')';
			$projectName = $rs2['project_name'];
			$closedrfi.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextRfiC."'>".$rs2['project_name']."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
		}
	// end of closed
		$SlideContent = <<<YearTillCount
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
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthclosedRFI($database, $quatorArray, $user_company_id, $primary_contact_id, $user_id, $arrProjectsIdIndexJoin, $userRole);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthclosedRFI($database, $weekArray, $user_company_id, $primary_contact_id, $user_id, $arrProjectsIdIndexJoin, $userRole);
	}
	echo $SlideContent;
}
// To get the total closed Submittal
if(isset($_POST['method']) && $_POST['method']=="ClosedSubmittalAdmin")
{
	
	/*Variable*/
	$period=$_POST['period'];
	$SlideContent='';
   	/*Get the count againtsed checked value */
	if($period=="YearTill"){
		/*Get the count of companies using function*/
		$closedsubCount = GetProjectClosedSubmittalCount($database, $user_company_id, $primary_contact_id, $user_id, $arrProjectsIdIndexJoin, $userRole);
		//To get the closed RFI data
		$db = DBI::getInstance($database);
		$getCurdate = date('Y-m-d');
		$getstartdate = date('Y-01-01');
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `submittals` as s 
		inner join projects as p on s.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE s.submittal_status_id IN (2,3) AND s.`project_id` IN ($arrProjectsIdIndexJoin) and date(s.su_closed_date) BETWEEN '$getstartdate' AND '$getCurdate'  group by p.id order by count desc limit 3";
	$db->execute($sq1);
	$closedsub='';
	while($rs2 = $db->fetch())
	{
		$labelTextSubC = $rs2['project_name'].' ('.$rs2['company'].')';
		$projectName = $rs2['project_name'];
		$closedsub.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextSubC."'>".$rs2['project_name']."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}
	// end of closed
		$SlideContent = <<<YearTillCount
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
	}
	if($period=="QuatorTill"){
		$curMonth=date('m');
		/*Get the Quator Months start and end date*/
		$quatorArray = QuatorCalculation($curMonth);
		/*Get the slide html from return function*/
		$SlideContent = QuatorMonthclosedSubmittal($database, $quatorArray, $user_company_id, $primary_contact_id, $user_id, $arrProjectsIdIndexJoin, $userRole);
	}
	if($period=="MonthTill"){
		$curMonth = date('Y-m-d');
		/*Get the Current month week dates*/
		$weekArray = MonthWeekdate($curMonth);
		$SlideContent = QuatorMonthclosedSubmittal($database, $weekArray, $user_company_id, $primary_contact_id,$user_id, $arrProjectsIdIndexJoin, $userRole);
	}
	echo $SlideContent;
}

if(!empty($_POST['method']) && $_POST['method'] == 'filter_task_summary'){


	$sort_cond = '';
	if(!empty($_POST['sort_type']) && !empty($_POST['sort_column'])){
		if ($_POST['task_summary_type'] == 'meetings') {
			$sort_cond = "\nORDER BY ai.`action_item_due_date` ".$_POST['sort_type'];
		}else if ($_POST['task_summary_type'] == 'rfis') {
			$sort_cond = "\nORDER BY rfi.`rfi_due_date` ".$_POST['sort_type'];
		}else if ($_POST['task_summary_type'] == 'bs') {
			$sort_cond = "\nORDER BY rfi.`rfi_due_date` ".$_POST['sort_type'];
		}else{
			$sort_cond = "\nORDER BY su.`su_due_date` ".$_POST['sort_type'];
		}
	}
	 
	$condition_arr = array('task'=>'','task_summary_type'=>'','assigned_to'=>'','due_date'=>'','complete_date'=>'',
		'discussion'=>'','meeting_type'=>'');
	
	$user_role = $project_manager = $project_id =  $user_id = $err_msg = '';
	
	if(!empty($_POST['task'])){
		$condition_arr['task'] = $_POST['task'];
	}
	if(!empty($_POST['task_summary_type'])){
		$condition_arr['task_summary_type'] = $_POST['task_summary_type'];
	}
	if(!empty($_POST['assigned_to'])){
		$condition_arr['assigned_to'] =  $_POST['assigned_to'];
	}
	if(!empty($_POST['due_date'])){
		$condition_arr['due_date'] =  $_POST['due_date'];
	}
	if(!empty($_POST['complete_date'])){
		$condition_arr['complete_date'] =  $_POST['complete_date'];
	}
	if(!empty($_POST['discussion'])){
		$condition_arr['discussion'] =  $_POST['discussion'];
	}
	if(!empty($_POST['meeting_type'])){
		$condition_arr['meeting_type'] =  $_POST['meeting_type'];
	}
	

	if(!empty($_POST['project_manager'])){
		$project_manager = $_POST['project_manager'];
	}

	if(!empty($_POST['project_id'])){
		$project_id = $_POST['project_id'];
		if(!empty($_POST['user_id'])){
			$user_id = $_POST['user_id'];

			if(!empty($_POST['user_role'])){
				$user_role = $_POST['user_role'];

				$options = array();
				$options['conditions'] = $condition_arr;
				$options['sort_task'] = $sort_cond;
				
				if ($condition_arr['task_summary_type'] == 'meetings') {
					$ret_arr = tasksummary($database, $project_id, $user_id,$user_role,$project_manager, $options );					
				}else if ($condition_arr['task_summary_type'] == 'rfis') {
					$user_id = $currentlyActiveContactId;
					$ret_arr = rfitasksummary($database, $project_id, $user_id,$user_role,$project_manager, $options );
				}else if ($condition_arr['task_summary_type'] == 'bs') {
					$user_id = $currentlyActiveContactId;
					$ret_arr = bstasksummary($database, $project_id, $user_id,$user_role,$project_manager, $options );
				}else{
					$user_id = $currentlyActiveContactId;
					$ret_arr = submittaltasksummary($database, $project_id, $user_id,$user_role,$project_manager, $options );
				}
				echo json_encode($ret_arr);
			
			}else{
				$err_msg = 'User Role is Required!';
			}
		}else{
			$err_msg = 'User Id is Required!';
		}
	}else{
		$err_msg = 'Project Id is Required!';
	}

	
}

function submittaltasksummary($database, $project_id, $user_id,$userRole,$projManager = 0,$options = null){
	$task_summary_arr = submittaltaskSummaryarr($database, $project_id, $user_id,$userRole,$projManager,$options);
	$assignedtohead = '<th nowrap>Assigned To</th>';
	$taskwidth = 'style="width: 25%;"';
	$discussionwidth = 'style="width: 20%;"';
	if(!empty($userRole) && (($userRole=="user" && empty($projManager)) ||  $userRole=="admin" )){
		$assignedtohead = "";
		$taskwidth = 'style="width: 35%;"';
		$discussionwidth = 'style="width: 30%;"';
	}
	$tasksummary = '<tr class="borderBottom border-thead">
				'.$assignedtohead.'	
				<th nowrap>Task</th>
				<th nowrap><span onclick="sorttaskTable(&quot;action_item_due_date&quot;);" style=" text-decoration: underline;">Due Date</span></th>
				<th nowrap>Topic</th>
				<th nowrap>Mark as completed</th>
			</tr>';
	if(!empty($task_summary_arr) && count($task_summary_arr) > 0){
		foreach($task_summary_arr as $eachtasksummary){

			$due_date = '';
			if(!empty($eachtasksummary['su_due_date'])){
				$due_date = date('m/d/Y',strtotime($eachtasksummary['su_due_date']));
			}
			$due_date_style = '';
			if(!empty($due_date)){
				
				if(strtotime($due_date) > strtotime('+7 days') && strtotime($due_date) <= strtotime('+15 days')) { // 7 - 15

				  $due_date_style = "due-date-clr-2";
				}else if(strtotime($due_date) >= strtotime('-1 days') && strtotime($due_date)  <= strtotime('+7 days') ) { // 0 to 7

				    $due_date_style = "due-date-clr-1";
				} elseif(strtotime($due_date) < strtotime('now')) { // over due
				   $due_date_style = "due-date-clr-3";

				} 
			}

			$act_complete ='';
			if($eachtasksummary['submittal_status_id'] == '2' || $eachtasksummary['submittal_status_id'] == '3'){
				$act_complete = date("m/d/Y",strtotime($eachtasksummary['su_closed_date']));
				$isDissabled = 'disabled';
			}

			$assigned_to = '';
			if(!empty($userRole) && $userRole=="user" && !empty($projManager)){
				if(!empty($eachtasksummary['ac_id'])){
					$assigned_to = Contact::ContactNameByIdList($database,$eachtasksummary['ac_id']);
				}
			}
			$tasksummary .= "<tr id='su_row_".$eachtasksummary['id']."'>";

			if(!empty($userRole) && $userRole=="user" && !empty($projManager)){
				$tasksummary .= "<td>".$assigned_to."</td>";
			}

			$tasksummary .= "<td><a href='/modules-submittals-form.php?submittal_id=".$eachtasksummary['id']."' target='_blank' style='text-decoration: underline;'>".$eachtasksummary['su_title']."</a></td>";

			$tasksummary .= "<td >
						<div class='datepicker_style_custom' style='display: block;''>
							<input type='text' value='".$due_date."' class='tduedate form-control' id='dueSu_".$eachtasksummary['id']."'  style='width:95%;' ".$isDissabled.">
							<div class='calender-icon ".$due_date_style."'>
								<img class='datepicker datedivseccal_icon_gk' width='13' alt='' src='./images/cal.png' id='dp1562147413179'>
							</div>
						</div>
					</td>";
			$tasksummary .= "<td>".$eachtasksummary['su_statement']."</td>";
			$tasksummary .= "<td>
						<div class='datepicker_style_custom' style='display: block;''>
							<input type='text' value='".$act_complete."' class='tcomp_dateRfiSu form-control' id='compdateSu_".$eachtasksummary['id']."'  style='width:95%;' readonly><img class='datepicker datedivseccal_icon_gk' width='13' alt='' src='./images/cal.png' id='dp1562147413179'>
						</div>
					</td>";
			$tasksummary .= "</tr>";
		}
	}else{
		if(!empty($userRole) && $userRole=="user" && !empty($projManager)){
			$tasksummary .= "<tr><td colspan='7' style='text-align: center;'>No Task Summary found</td></tr>";		
		}else{
			$tasksummary .= "<tr><td colspan='6' style='text-align: center;'>No Task Summary found</td></tr>";
		}
	}
$return_arr = array();
$return_arr['task_summary_html'] = $tasksummary;
$summary_cnt = count($task_summary_arr);
$return_arr['task_summary_count'] = sprintf("%02d", $summary_cnt);
return $return_arr;
}

function bstasksummary($database, $project_id, $user_id,$userRole,$projManager = 0,$options = null)
{
	$task_summary_arr=[];
	$task_summary_arr = bstaskSummaryarr($database, $project_id, $user_id,$userRole,$projManager,$options);	
	$tasksummary='';
	$return_arr = array();
	$tasksummary = '<tr class="borderBottom border-thead">
			<th style="width: 20%;">S.no</th>
			<th colspan="6">Description</th>
		</tr>
		';
	if(!empty($task_summary_arr) && count($task_summary_arr) > 0){
		foreach($task_summary_arr as $key => $eachtasksummary){

			$tasksummary .= "<tr><td colspan='1'>".($key+1)."</td><td colspan='6'>Bid spread for ".$eachtasksummary['short_cost_code']." was ".$eachtasksummary['bid_spread_status']." by ".$eachtasksummary['pe_name']." on ".date('m/d/Y',strtotime($eachtasksummary['modified']))."</td></tr>";
		}
	}else{
		if(!empty($userRole) && $userRole=="user" && !empty($projManager)){
			$tasksummary .= "<tr><td colspan='7' style='text-align: center;'>No Task Summary found</td></tr>";		
		}else{
			$tasksummary .= "<tr><td colspan='6' style='text-align: center;'>No Task Summary found</td></tr>";
		}
	}
	$return_arr['task_summary_html'] = $tasksummary;
	$summary_cnt = count($task_summary_arr);
	$return_arr['task_summary_count'] = sprintf("%02d", $summary_cnt);
	return $return_arr;
}

function rfitasksummary($database, $project_id, $user_id,$userRole,$projManager = 0,$options = null){
	$task_summary_arr = rfitaskSummaryarr($database, $project_id, $user_id,$userRole,$projManager,$options);
	$assignedtohead = '<th nowrap>Assigned To</th>';
	$taskwidth = 'style="width: 25%;"';
	$discussionwidth = 'style="width: 20%;"';
	if(!empty($userRole) && (($userRole=="user" && empty($projManager)) ||  $userRole=="admin" )){
		$assignedtohead = "";
		$taskwidth = 'style="width: 35%;"';
		$discussionwidth = 'style="width: 30%;"';
	}
	$tasksummary = '<tr class="borderBottom border-thead">
			'.$assignedtohead.'	
			<th nowrap>Task</th>
			<th nowrap><span onclick="sorttaskTable(&quot;action_item_due_date&quot;);" style=" text-decoration: underline;">Due Date</span></th>
			<th nowrap>Topic</th>
			<th nowrap>Mark as completed</th>
		</tr>
		';
	if(!empty($task_summary_arr) && count($task_summary_arr) > 0){
		foreach($task_summary_arr as $eachtasksummary){

			$due_date = '';
			if(!empty($eachtasksummary['rfi_due_date'])){
				$due_date = date('m/d/Y',strtotime($eachtasksummary['rfi_due_date']));
			}
			$due_date_style = '';
			if(!empty($due_date)){
				
				if(strtotime($due_date) > strtotime('+7 days') && strtotime($due_date) <= strtotime('+15 days')) { // 7 - 15

				  $due_date_style = "due-date-clr-2";
				}else if(strtotime($due_date) >= strtotime('-1 days') && strtotime($due_date)  <= strtotime('+7 days') ) { // 0 to 7

				    $due_date_style = "due-date-clr-1";
				} elseif(strtotime($due_date) < strtotime('now')) { // over due
				   $due_date_style = "due-date-clr-3";

				} 
			}

			$act_complete ='';
			if($eachtasksummary['request_for_information_status_id'] == '4'){
				$act_complete = date("m/d/Y",strtotime($eachtasksummary['rfi_closed_date']));
				$isDissabled = 'disabled';
			}

			$assigned_to = '';
			if(!empty($userRole) && $userRole=="user" && !empty($projManager)){
				if(!empty($eachtasksummary['ac_id'])){
					$assigned_to = Contact::ContactNameByIdList($database,$eachtasksummary['ac_id']);					
				}
			}
			$tasksummary .= "<tr id='rfi_row_".$eachtasksummary['id']."'>";

			if(!empty($userRole) && $userRole=="user" && !empty($projManager)){
				$tasksummary .= "<td>".$assigned_to."</td>";
			}

			$tasksummary .= "<td><a href='/modules-requests-for-information-form.php?request_for_information_id=".$eachtasksummary['id']."' target='_blank' style='text-decoration: underline;'>".$eachtasksummary['rfi_title']."</a></td>";

			$tasksummary .= "<td >
						<div class='datepicker_style_custom' style='display: block;''>
							<input type='text' value='".$due_date."' class='tduedate form-control' id='dueRfi_".$eachtasksummary['id']."'  style='width:95%;' ".$isDissabled.">
							<div class='calender-icon ".$due_date_style."'>
								<img class='datepicker datedivseccal_icon_gk' width='13' alt='' src='./images/cal.png' id='dp1562147413179'>
							</div>
						</div>
					</td>";
			$tasksummary .= "<td>".$eachtasksummary['rfi_statement']."</td>";
			$tasksummary .= "<td>
						<div class='datepicker_style_custom' style='display: block;''>
							<input type='text' value='".$act_complete."' class='tcomp_dateRfiSu form-control' id='compdateRfi_".$eachtasksummary['id']."'  style='width:95%;' readonly><img class='datepicker datedivseccal_icon_gk' width='13' alt='' src='./images/cal.png' id='dp1562147413179'>
						</div>
					</td>";
			$tasksummary .= "</tr>";
		}
	}else{
		if(!empty($userRole) && $userRole=="user" && !empty($projManager)){
			$tasksummary .= "<tr><td colspan='7' style='text-align: center;'>No Task Summary found</td></tr>";		
		}else{
			$tasksummary .= "<tr><td colspan='6' style='text-align: center;'>No Task Summary found</td></tr>";
		}
	}
$return_arr = array();
$return_arr['task_summary_html'] = $tasksummary;
$summary_cnt = count($task_summary_arr);
$return_arr['task_summary_count'] = sprintf("%02d", $summary_cnt);
return $return_arr;
}

function tasksummary($database, $project_id, $user_id,$userRole,$projManager = 0,$options = null){
	$task_summary_arr = taskSummaryarr($database, $project_id, $user_id,$userRole,$projManager,$options);
	$assignedtohead = '<th nowrap>Assigned To</th>';
	$taskwidth = 'style="width: 25%;"';
	$discussionwidth = 'style="width: 20%;"';
	if(!empty($userRole) && (($userRole=="user" && empty($projManager)) ||  $userRole=="admin" )){
		$assignedtohead = "";
		$taskwidth = 'style="width: 35%;"';
		$discussionwidth = 'style="width: 30%;"';
	}
/*	<th nowrap style="width: 5%;">#</th>*/
	$tasksummary = '<tr class="borderBottom border-thead">						
						'.$assignedtohead.'
						<th nowrap>Task</th>
						<th nowrap><span onclick="sorttaskTable(&quot;action_item_due_date&quot;);" style=" text-decoration: underline;">Due Date</span></th>
						<th nowrap>Task Source</th>
						<th nowrap>Topic</th>
						<th nowrap>Mark as completed</th>
					</tr>
					';
					$i = 1;
	if(!empty($task_summary_arr) && count($task_summary_arr) > 0){

	foreach($task_summary_arr as $eachtasksummary){

		$due_date = '';
		if(!empty($eachtasksummary['action_item_due_date'])){
			$due_date = date('m/d/Y',strtotime($eachtasksummary['action_item_due_date']));
		}
		$due_date_style = '';
		if(!empty($due_date)){
			
			if(strtotime($due_date) > strtotime('+7 days') && strtotime($due_date) <= strtotime('+15 days')) { // 7 - 15

			  $due_date_style = "due-date-clr-2";
			}else if(strtotime($due_date) >= strtotime('-1 days') && strtotime($due_date)  <= strtotime('+7 days') ) { // 0 to 7

			    $due_date_style = "due-date-clr-1";
			} elseif(strtotime($due_date) < strtotime('now')) { // over due
			   $due_date_style = "due-date-clr-3";

			} 
		}
		if(!empty($userRole) && $userRole=="user" && !empty($projManager)){
			$assigned_arr = array();
			if(!empty($eachtasksummary['ac_id'])){
				
				$db = DBI::getInstance($database);


				$query = "SELECT `action_item_assignments`.*,`contacts`.`id`,`contacts`.`email`,`contacts`.`first_name`,`contacts`.`last_name` FROM `action_item_assignments` INNER JOIN contacts ON `action_item_assignments`.`action_item_assignee_contact_id` = `contacts`.`id` WHERE `action_item_assignments`.`action_item_id` =  '".$eachtasksummary['ac_id']."' ";
				$db->execute($query);
				
				while($each_contact_row = $db->fetch()){
					$assigned_to = '';
					if(empty($each_contact_row['first_name']) && empty($each_contact_row['last_name']) && !empty($each_contact_row['email'])){
						$assigned_to = $each_contact_row['email'];
					}elseif(!empty($each_contact_row['first_name']) && !empty($each_contact_row['last_name'])){

						$assigned_to = $each_contact_row['first_name'].' '.$each_contact_row['last_name'];
					}
					$assigned_arr[] = $assigned_to;
				}
				$db->free_result();
				/*echo '<pre>';
				print_r($assigned_arr);*/
				
			}
		}
		$action_item = 'N/A';
		if(!empty($eachtasksummary['action_item'])){
			$action_item = $eachtasksummary['action_item'];
		}
		$tasksummary .= "<tr>";
			/*<td>".$i."</td>*/
		if(!empty($userRole) && $userRole=="user" && !empty($projManager)){
			$tasksummary .= "<td>".implode('<br/>',$assigned_arr)."</td>";
		}
		$act_complete ='';
		if(!empty($eachtasksummary['action_item_completed_timestamp']) && $eachtasksummary['action_item_completed_timestamp'] != '0000-00-00 00:00:00'){
			$act_complete = date("m/d/Y",strtotime($eachtasksummary['action_item_completed_timestamp']));
		}
/*style=".$due_date_style."
*/			$tasksummary .= "<td><a href='/modules-collaboration-manager-form.php?meeting_id=".$eachtasksummary['meeting_id']."&meeting_type_id=".$eachtasksummary['meeting_type_id']."' target='_blank' style='text-decoration: underline;'>".$action_item."</td>
				<td >
					<div class='datepicker_style_custom' style='display: block;''>
						<input type='text' value='".$due_date."' class='tduedate form-control' id='due_".$eachtasksummary['ac_id']."'  style='width:95%;'>
						<div class='calender-icon ".$due_date_style."'>
							<img class='datepicker datedivseccal_icon_gk' width='13' alt='' src='./images/cal.png' id='dp1562147413179'>
						</div>
					</div>
				</td>
				<td>".$eachtasksummary['meeting_type']."</td>
				<td>".$eachtasksummary['discussion_item_title']."</td>
				<td>
					<div class='datepicker_style_custom' style='display: block;''>
						<input type='text' value='".$act_complete."' class='tcomp_date form-control' id='compdate_".$eachtasksummary['ac_id']."'  style='width:95%;'><img class='datepicker datedivseccal_icon_gk' width='13' alt='' src='./images/cal.png' id='dp1562147413179'>
					</div>
				</td>
			</tr>";
			$i++;
		}
	}else{
		if(!empty($userRole) && $userRole=="user" && !empty($projManager)){
			$tasksummary .= "<tr>
								<td colspan='7' style='text-align: center;'>No Task Summary found</td>
							</tr>";
		
		}else{
			$tasksummary .= "<tr>
								<td colspan='6' style='text-align: center;'>No Task Summary found</td>
							</tr>";
		}


	}
	$return_arr = array();
	$return_arr['task_summary_html'] = $tasksummary;
	$summary_cnt = count($task_summary_arr);
	$return_arr['task_summary_count'] = sprintf("%02d", $summary_cnt);
	return $return_arr;
}
