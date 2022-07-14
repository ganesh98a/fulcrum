<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');

/*calculate the Month Weeks*/
function MonthWeekdate($curMonth){
  	$monthArray = Array();
  	$monthArray['Months']['StartDate'] = date('Y-m-01',strtotime($curMonth));
  	$monthArray['Months']['EndDate'] = date('Y-m-t',strtotime($curMonth));
  	$month=date('m');
  	$year=date('Y');
  	/*Get Weekdates*/
	$arrayWeek = getWeeks($month,$year,$curMonth,$monthArray);
	return $arrayWeek;	
}
/*Calculate the Week days*/
function getWeeks($month,$year,$curMonth,$monthArray){
	$month = intval($month);	//force month to single integer if '0x'
	$suff = array('st','nd','rd','th','th','th'); 		//week suffixes
	$end = date('t',mktime(0,0,0,$month,1,$year)); 		//last date day of month: 28 - 31
  	$start = date('w',mktime(0,0,0,$month,1,$year)); //1st day of month: 0 - 6 (Sun - Sat)
	$last = 7 - $start; //get last day date (Sat) of first week
	$noweeks = ceil((($end - ($last + 1))/7) + 1);		//total no. weeks in month
	$output = "";						//initialize string		
	$monthlabel = str_pad($month, 2, '0', STR_PAD_LEFT);
	for($x=1;$x<$noweeks+1;$x++){	
		if($x == 1){
			$startdate = "$year-$monthlabel-01";
			$day = $last - 6;
		}else{
			$day = $last + 1 + (($x-2)*7);
			$day = str_pad($day, 2, '0', STR_PAD_LEFT);
			$startdate = "$year-$monthlabel-$day";
		}
		if($x == $noweeks){
			$enddate = "$year-$monthlabel-$end";
		}else{
			$dayend = $day + 6;
			$dayend = str_pad($dayend, 2, '0', STR_PAD_LEFT);
			$enddate = "$year-$monthlabel-$dayend";
		}
		$output .= "{$x}{$suff[$x-1]} week -> Start date=$startdate End date=$enddate <br />";	
		$monthArray[$x-1][0] = $startdate;
		$monthArray[$x-1][1] = $enddate;
	}
	return $monthArray;
}

/*Calculate the Quator months count For Admin projects*/
function QuatorMonthAndWeekCompaniesActiveProjects($database, $quatorArray, $user_company_id, $primary_contact_id, $user_id, $check=null){
	$ArrayCount = count($quatorArray);
	$totcount = 0;
	$Month = '';
	$MonthCount = '';
	for($val = 1; $val < $ArrayCount; $val++){
		$db = DBI::getInstance($database);
		$queryYear = "SELECT count(*) as count FROM contacts c, projects_to_contacts_to_roles p2c2r,projects pr WHERE p2c2r.contact_id <> $primary_contact_id AND c.user_company_id <> $user_company_id AND c.user_id = $user_id AND c.`id` <> $primary_contact_id AND c.`id` = p2c2r.contact_id AND p2c2r.project_id = pr.id AND pr.is_active_flag = 'Y' AND date(pr.project_start_date) Between '".$quatorArray[$val-1][0]."' AND '".$quatorArray[$val-1	][1]."'";
		$db->execute($queryYear);
		$row = $db->fetch();
		$Countval=$row['count'];
		$db->free_result();

		$query = "SELECT count(id) as count FROM projects where user_company_id = $user_company_id AND is_active_flag = 'Y' AND date(project_start_date) Between '".$quatorArray[$val-1][0]."' AND '".$quatorArray[$val-1	][1]."'";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		$Monthday =date('M',strtotime($quatorArray[$val-1][0]));
		$totcount += $Countval;
		if($check == null)
		$Month.= <<<MonthQuator
		<td class="TdFont">$Monthday</td>
MonthQuator;
		else
		$Month.= <<<MonthQuator
		<td class="TdFont">Week$val</td>
MonthQuator;
		$MonthCount.= <<<MonthQuator
		<td class="TdFont">$Countval</td>
MonthQuator;
	}
	$counthtml = <<<MonthQuator
		<div class="SlideContent FirstInTop">
			<div class="CountNo">
				$totcount
			</div>
			<div class="DaysCount">
				<table class="DaysTable">
					<tr>
						$Month
					</tr>
				</table>
			</div>
		</div>
		<div class="SlideContentSec FirstInDown">
			<div class="IndexContent">
				Active Project
			</div>
			<div class="DaysCount">
				<table class="DaysTableDown">
					<tr>
						$MonthCount
					</tr>							
				</table>
			</div>
		</div>
MonthQuator;
	return $counthtml;
}
/*Calculate the Quator months count*/
function QuatorMonthAndWeekCompanies($quatorArray, $check=null){
	$ArrayCount = count($quatorArray);
	$totcount = 0;
	$Month = '';
	$MonthCount = '';
	for($val = 1; $val < $ArrayCount; $val++){
		$db = DBI::getInstance($database);
		$query = "SELECT count(id) as count FROM user_companies where date(created_date) Between '".$quatorArray[$val-1][0]."' AND '".$quatorArray[$val-1	][1]."'";
		$db->execute($query);
		$row = $db->fetch();
		$Countval=$row['count'];
		$db->free_result();
		$Monthday =date('M',strtotime($quatorArray[$val-1][0]));
		$totcount += $Countval;
		if($check == null)
		$Month.= <<<MonthQuator
		<td class="TdFont">$Monthday</td>
MonthQuator;
		else
		$Month.= <<<MonthQuator
		<td class="TdFont">Week$val</td>
MonthQuator;
		$MonthCount.= <<<MonthQuator
		<td class="TdFont">$Countval</td>
MonthQuator;
	}
	$counthtml = <<<MonthQuator
		<div class="SlideContent FirstInTop">
			<div class="CountNo">
				$totcount
			</div>
			<div class="DaysCount">
				<table class="DaysTable">
					<tr>
						$Month
					</tr>
				</table>
			</div>
		</div>
		<div class="SlideContentSec FirstInDown">
			<div class="IndexContent">
				SignUp
			</div>
			<div class="DaysCount">
				<table class="DaysTableDown">
					<tr>
						$MonthCount
					</tr>							
				</table>
			</div>
		</div>
MonthQuator;
	return $counthtml;
}
/*Calculate companies count*/
function GetCompaniesActiveProjectAllCount($user_company_id, $primary_contact_id, $user_id){
	$getCurdate = date('Y-m-d');
	$getstartdate = date('Y-01-01');
	$db = DBI::getInstance($database);
	$queryYear = "SELECT count(*) as count FROM contacts c, projects_to_contacts_to_roles p2c2r,projects pr WHERE p2c2r.contact_id <> $primary_contact_id AND c.user_company_id <> $user_company_id AND c.user_id = $user_id AND c.`id` <> $primary_contact_id AND c.`id` = p2c2r.contact_id AND pr.is_active_flag = 'Y' AND p2c2r.project_id = pr.id AND date(pr.project_start_date) BETWEEN '$getstartdate' AND '$getCurdate'";
	$db->execute($queryYear);
	$row = $db->fetch();
	$Count=$row['count'];
	$db->free_result();

	$query = "SELECT count(id) as count FROM projects where user_company_id = $user_company_id AND is_active_flag = 'Y' AND date(project_start_date) BETWEEN '$getstartdate' AND '$getCurdate'";
	$db->execute($query);
	$row = $db->fetch();
	$Count +=$row['count'];
	$db->free_result();
	return $Count;
}
/*Calculate Submittal count*/
function GetProjectsubmittalCount($user_company_id, $primary_contact_id, $user_id,$project_ids){
	$getCurdate = date('Y-m-d');
	$getstartdate = date('Y-01-01');
	$db = DBI::getInstance($database);
	
	$query1 = "SELECT count(*) as count FROM `submittals`as su inner join submittal_statuses as s on su.submittal_status_id=s.id where s.submittal_status='Open' and su.project_id IN ($project_ids) and date(su.created) BETWEEN '$getstartdate' AND '$getCurdate' ";
	$db->execute($query1);
	$rowc3 = $db->fetch();
	$Count =$rowc3['count'];
	$db->free_result();
	return $Count;
}
// To get quarter month Open Submittal
function QuatorMonthSubmittal($quatorArray, $user_company_id, $primary_contact_id, $user_id,$project_ids,$check=null){
	$ArrayCount = count($quatorArray);
	$totcount = 0;
	$Month = '';
	$MonthCount = '';
	for($val = 1; $val < $ArrayCount; $val++){
		$db = DBI::getInstance($database);
		$queryYear = "SELECT count(*) as count FROM `submittals`as su inner join submittal_statuses as s on su.submittal_status_id=s.id where s.submittal_status='Open' and su.project_id IN ($project_ids) and date(su.created) BETWEEN '".$quatorArray[$val-1][0]."' AND '".$quatorArray[$val-1	][1]."'";
		
		$db->execute($queryYear);
		$row = $db->fetch();
		$Countval=$row['count'];
		$db->free_result();
			
		$Monthday =date('M',strtotime($quatorArray[$val-1][0]));
		$totcount += $Countval;
		if($check == null)
		$Month.= <<<MonthQuator
		<td class="TdFont">$Monthday</td>
MonthQuator;
		else
		$Month.= <<<MonthQuator
		<td class="TdFont">Week$val</td>
MonthQuator;
		$MonthCount.= <<<MonthQuator
		<td class="TdFont">$Countval</td>
MonthQuator;
	}
	$counthtml = <<<MonthQuator
		<div class="SlideContent FirstInTop">
			<div class="CountNo">
				$totcount
			</div>
			<div class="DaysCount">
				<table class="DaysTable">
					<tr>
						$Month
					</tr>
				</table>
			</div>
		</div>
		<div class="SlideContentSec FirstInDown">
			<div class="IndexContent">
				Open Submittal
			</div>
			<div class="DaysCount">
				<table class="DaysTableDown">
					<tr>
						$MonthCount
					</tr>							
				</table>
			</div>
		</div>
MonthQuator;
	return $counthtml;
}
/*Calculate RFI count*/
function GetProjectRFICount($user_company_id, $primary_contact_id, $user_id,$project_ids){
	$getCurdate = date('Y-m-d');
	$getstartdate = date('Y-01-01');
	$db = DBI::getInstance($database);
	
	$query1 = "SELECT count(*) as count FROM `requests_for_information`as r inner join request_for_information_statuses as s on r.request_for_information_status_id=s.id where s.request_for_information_status='open' and r.project_id IN ($project_ids) and date(r.created) BETWEEN '$getstartdate' AND '$getCurdate' ";
	$db->execute($query1);
	$rowc3 = $db->fetch();
	$Count =$rowc3['count'];
	$db->free_result();
	return $Count;
}



/*Calculate closed Submittal count*/
function GetProjectClosedSubmittalCount($database, $user_company_id, $primary_contact_id, $user_id,$project_ids, $userRole = null){
	$getCurdate = date('Y-m-d');
	$getstartdate = date('Y-01-01');
	$db = DBI::getInstance($database);
	$inQuery = '';
	if($userRole == 'admin' || $project_ids !='' ){
		$inQuery = "AND u.`project_id` IN ($project_ids)";
	}
	$query1 = "SELECT count(*) as count FROM `submittals`as u inner join submittal_statuses as s on u.submittal_status_id = s.id where u.submittal_status_id IN (2,3) $inQuery and date(u.su_closed_date) BETWEEN '$getstartdate' AND '$getCurdate' ";
	$db->execute($query1);
	$rowc3 = $db->fetch();
	$Count =$rowc3['count'];
	$db->free_result();
	return $Count;
}
// To get quarter month Closed Submittal
function QuatorMonthclosedSubmittal($database, $quatorArray, $user_company_id, $primary_contact_id, $user_id, $project_ids, $userRole = null){
	$ArrayCount = count($quatorArray);
	$totcount = 0;
	$Month = '';
	$MonthCount = '';
	$inQuery = '';
	if($userRole == 'admin' || $project_ids !=''){
		$inQuery = "AND s.`project_id` IN ($project_ids)";
	}
	$filterStartDate=$quatorArray['Months']['StartDate'];
	$filterEndDate=$quatorArray['Months']['EndDate'];
	$db = DBI::getInstance($database);
	$totcount=0;
		$queryYear = "SELECT count(*) as count FROM `submittals`as s inner join submittal_statuses as st on  s.submittal_status_id=st.id where s.submittal_status_id IN (2,3) $inQuery and date(s.su_closed_date)  Between '".$filterStartDate."' AND '".$filterEndDate."'";
		
		$db->execute($queryYear);
		$row = $db->fetch();
		$totcount = $row['count'];
		$db->free_result();

		//To get the closed Submittal Project Wise
		$db = DBI::getInstance($database);
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `submittals` as s 
		inner join projects as p on s.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE s.submittal_status_id IN (2,3) $inQuery and date(s.su_closed_date) BETWEEN '$filterStartDate' AND '$filterEndDate'  group by p.id order by count desc limit 3";
	$db->execute($sq1);
	$closedsub='';
	while($rs2 = $db->fetch())
	{
		$labelTextSubC = $rs2['project_name'].' ('.$rs2['company'].')';
		$projectName = $rs2['project_name'];
		$closedsub.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextSubC."'>".$projectName."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}

	$counthtml = <<<MonthQuator
		<div class="splitthrdleft">
		<div class=" bottomAlign">
		{$totcount}
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
MonthQuator;
	return $counthtml;
}

/*Calculate closed RFI count*/
function GetProjectClosedRFICount($database, $user_company_id, $primary_contact_id, $user_id,$project_ids, $userRole = null){
	$getCurdate = date('Y-m-d');
	$getstartdate = date('Y-01-01');
	$db = DBI::getInstance($database);
	$inQuery = '';
	if($userRole == 'admin' || $project_ids!=''){
		$inQuery = "AND r.`project_id` IN ($project_ids)";
	}
	$query1 = "SELECT count(*) as count FROM `requests_for_information`as r inner join request_for_information_statuses as s on r.request_for_information_status_id=s.id where s.request_for_information_status='Closed' $inQuery and date(r.rfi_closed_date) BETWEEN '$getstartdate' AND '$getCurdate' ";
	$db->execute($query1);
	$rowc3 = $db->fetch();
	$Count =$rowc3['count'];
	$db->free_result();
	return $Count;
}

// To get quarter month Closed RFIs
function QuatorMonthclosedRFI($database, $quatorArray, $user_company_id, $primary_contact_id, $user_id, $project_ids, $userRole = null){
	$inQuery = '';
	if($userRole == 'admin' || $project_ids!=''){
		$inQuery = "AND r.`project_id` IN ($project_ids)";
	}
	$ArrayCount = count($quatorArray);
	$totcount = 0;
	$Month = '';
	$MonthCount = '';
	$filterStartDate=$quatorArray['Months']['StartDate'];
	$filterEndDate=$quatorArray['Months']['EndDate'];
		$db = DBI::getInstance($database);
		$queryYear = "SELECT count(*) as count FROM `requests_for_information`as r inner join request_for_information_statuses as s on r.request_for_information_status_id=s.id where s.request_for_information_status='Closed' $inQuery and date(r.rfi_closed_date)  Between '".$filterStartDate."' AND '".$filterEndDate."'";
		
		$db->execute($queryYear);
		$row = $db->fetch();
		$totcount=$row['count'];
		$db->free_result();

		//To get the closed RFI Project Wise
		$db = DBI::getInstance($database);
		$sq1="SELECT count(*) as count, p.id,p.project_name,company FROM `requests_for_information` as r
		inner join projects as p on r.project_id=p.id
		inner join user_companies as uc on uc.id = p.user_company_id
		WHERE r.request_for_information_status_id='4' $inQuery and date(r.rfi_closed_date) BETWEEN '$filterStartDate' AND '$filterEndDate'  group by p.id order by count desc limit 3";
	$db->execute($sq1);
	$closedrfi='';
	while($rs2 = $db->fetch())
	{
		$labelTextRfiC = $rs2['project_name'].' ('.$rs2['company'].')';
		$projectName = $rs2['project_name'];
		$closedrfi.="<tr><td class='tdAlign dashbrd-tooltip'><span class='tdAlign' data-toggle=tooltip title='' data-original-title='".$labelTextRfiC."'>".$projectName."</span></td><td class='tdAlign'>".$rs2['count']."</td></tr>";
	}

	$counthtml = <<<MonthQuator
		<div class="splitthrdleft">
		<div class=" bottomAlign">
		{$totcount}
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
MonthQuator;
	return $counthtml;
}


// To get quarter month Open RFI
function QuatorMonthRFI($quatorArray, $user_company_id, $primary_contact_id, $user_id,$project_ids,$check=null){
	$ArrayCount = count($quatorArray);
	$totcount = 0;
	$Month = '';
	$MonthCount = '';
	for($val = 1; $val < $ArrayCount; $val++){
		$db = DBI::getInstance($database);
		$queryYear = "SELECT count(*) as count FROM `requests_for_information`as r inner join request_for_information_statuses as s on r.request_for_information_status_id=s.id where s.request_for_information_status='open' and r.project_id IN ($project_ids) and date(r.created)  Between '".$quatorArray[$val-1][0]."' AND '".$quatorArray[$val-1	][1]."'";
		
		$db->execute($queryYear);
		$row = $db->fetch();
		$Countval=$row['count'];
		$db->free_result();
			
		$Monthday =date('M',strtotime($quatorArray[$val-1][0]));
		$totcount += $Countval;
		if($check == null)
		$Month.= <<<MonthQuator
		<td class="TdFont">$Monthday</td>
MonthQuator;
		else
		$Month.= <<<MonthQuator
		<td class="TdFont">Week$val</td>
MonthQuator;
		$MonthCount.= <<<MonthQuator
		<td class="TdFont">$Countval</td>
MonthQuator;
	}
	$counthtml = <<<MonthQuator
		<div class="SlideContent FirstInTop">
			<div class="CountNo">
				$totcount
			</div>
			<div class="DaysCount">
				<table class="DaysTable">
					<tr>
						$Month
					</tr>
				</table>
			</div>
		</div>
		<div class="SlideContentSec FirstInDown">
			<div class="IndexContent">
				Open RFI
			</div>
			<div class="DaysCount">
				<table class="DaysTableDown">
					<tr>
						$MonthCount
					</tr>							
				</table>
			</div>
		</div>
MonthQuator;
	return $counthtml;
}
/*Calculate companies count*/
function GetCompaniesOverAllCount(){
	$getCurdate = date('Y-m-d');
	$getstartdate = date('Y-01-01');
	$db = DBI::getInstance($database);
	$query = "SELECT count(id) as count FROM user_companies where date(created_date) BETWEEN '$getstartdate' AND '$getCurdate'";
	$db->execute($query);
	$row = $db->fetch();
	$Count=$row['count'];
	$db->free_result();
	return $Count;
}
/*Quator month calculation*/
function QuatorCalculation($curMonth){
	$quator = 3;
	$divValue = ceil(intval($curMonth)/$quator);
	$multiplyValue = $divValue*$quator;
	$minusValue = $multiplyValue-$quator;
	$addValue = $minusValue;
	$monthArray = Array();
	for($inVal = 1;$inVal <= $quator; $inVal++){
		$Month = $addValue + $inVal;
		$strlen = strlen($Month);
		if($strlen == 1)
			$Month = "0".$Month;
		
		$first_day_this_month = date('Y-'.$Month.'-01'); 
		$last_day_this_month  = date('Y-m-t',strtotime($first_day_this_month));
		 date("Y-m-t", strtotime($first_day_this_month));
		if($inVal == 1)
		 	$monthArray['Months']['StartDate'] = $first_day_this_month;
		if($inVal == $quator)
			$monthArray['Months']['EndDate'] = $last_day_this_month;
		 $monthArray[$inVal-1][0] = $first_day_this_month;
		 $monthArray[$inVal-1][1] = $last_day_this_month;
		 
	}
	return $monthArray;
}
function CurrentQuarter($n){

	if($n < 4){
		return "1";
	} elseif($n > 3 && $n <7){
		return "2";
	} elseif($n >6 && $n < 10){
		return "3";
	} elseif($n >9){
		return "4";
	}
}
function QuaterYear($n)
{

	if($n =='1'){
		return "1,2,3";
	} elseif($n =='2'){
		return "4,5,6";
	} elseif($n =='3'){
		return "7,8,9";
	} elseif($n =='4'){
		return "10,11,12";
	}

}
function calculate_mediannew($invalue)
{

$mid = 0;	
 $num_value=count($invalue);;
	if($num_value%2 == 0)
{
  $temp=round(($num_value/2)-1)*1000/1000;
  
  for($i=0;$i<$num_value;$i++)
    {
        if($temp==$i || ($temp+1)==$i)
        {
            $mid=$mid+$invalue[$i];
        }
    }
    $mid=$mid/2;
    return $mid;
}
else 
{
$temp=floor($num_value/2);
for($i=1;$i<=$num_value;$i++)
{
if($temp==$i)
{
$mid=$invalue[$i];
return $mid;
}
}
}
}
/*Get the Fetch dates for dcr*/
function GetMonthsTillYear(){
	$addValue=00;
	$quator=date('m');
	$quatorMonth=12;
	$monthArray = array();
	for($inVal = 1;$inVal <= $quatorMonth; $inVal++){
		$Month = $addValue + $inVal;
		$strlen = strlen($Month);
		if($strlen == 1)
			$Month = "0".$Month;
		
		$first_day_this_month = date('Y-'.$Month.'-01'); 
		$last_day_this_month  = date('Y-m-t',strtotime($first_day_this_month));
		 date("Y-m-t", strtotime($first_day_this_month));
		 if($inVal == 1)
		 	$monthArray['Months']['StartDate'] = $first_day_this_month;
		if($inVal == $quator)
			$monthArray['Months']['EndDate'] = $last_day_this_month;
		 $monthArray[$inVal-1][0] = $first_day_this_month;
		 $monthArray[$inVal-1][1] = $last_day_this_month;
		 
	}
	return $monthArray;
}
/*Get the countofDCR*/
function GetCountOfValue($database, $monthArray,$period){
	$countArray = count($monthArray);
	$valArray = array();
	for($val=1;$val < $countArray; $val++){
		$monthdatArray = array();
		$startDate = $monthArray[$val-1][0];
		$endDate = $monthArray[$val-1][1];

		$curdate=date('Y-m-d');
		$curstrdate = Strtotime($curdate);
		$endstrDate = Strtotime($endDate);
		

		$db = DBI::getInstance($database);
		/*Get manpower count*/
		$query = "SELECT count(*) as count FROM  `jobsite_daily_logs`  as jdl  inner join jobsite_man_power as  jmp on jmp.jobsite_daily_log_id =jdl.id where date(jdl.jobsite_daily_log_created_date) BETWEEN '$startDate' AND '$endDate'";
		$db->execute($query);
		$row = $db->fetch();
		$Countval=$row['count'];
		$db->free_result();
		$monthdatArray[]=$row['count'];
		/*Get building act count*/
		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count FROM  `jobsite_daily_logs`  as jdl  inner join `jobsite_daily_building_activity_logs` as  jmp on jmp.jobsite_daily_log_id =jdl.id where date(jdl.jobsite_daily_log_created_date) BETWEEN '$startDate' AND '$endDate'";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		$monthdatArray[]=$row['count'];
		/*Get sitework act count*/
		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count FROM  `jobsite_daily_logs`  as jdl  inner join `jobsite_daily_sitework_activity_logs` as  jmp on jmp.jobsite_daily_log_id =jdl.id where date(jdl.jobsite_daily_log_created_date) BETWEEN '$startDate' AND '$endDate'";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		$monthdatArray[]=$row['count'];
		/*Get inspection act count*/
		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count FROM  `jobsite_daily_logs`  as jdl  inner join `jobsite_inspections` as  jmp on jmp.jobsite_daily_log_id =jdl.id where date(jdl.jobsite_daily_log_created_date) BETWEEN '$startDate' AND '$endDate'";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		$monthdatArray[]=$row['count'];
		/*Get notes act count*/
		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count FROM  `jobsite_daily_logs`  as jdl  inner join `jobsite_notes` as  jmp on jmp.jobsite_daily_log_id =jdl.id where date(jdl.jobsite_daily_log_created_date) BETWEEN '$startDate' AND '$endDate'";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		$monthdatArray[]=$row['count'];
		/*Get delays act count*/
		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count FROM  `jobsite_daily_logs`  as jdl  inner join `jobsite_delays` as  jd on jd.jobsite_daily_log_id =jdl.id where date(jdl.jobsite_daily_log_created_date) BETWEEN '$startDate' AND '$endDate'";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		$monthdatArray[]=$row['count'];
		$date = DateTime::createFromFormat('Y-m-d', $startDate);
		if($period != "MonthTill")
			$monthweekquater = $date->format('M');
		else
			$monthweekquater = "Week".$val;
		/*store the values*/
		$valArray[$val-1][0] = $monthweekquater;
		$valArray[$val-1][1] = $Countval;
		if($curstrdate <= $endstrDate)
			if(!isset($valArray['curdate']))
			$valArray['curdate']=$val-1;
	}
	return $valArray;
}
?>
