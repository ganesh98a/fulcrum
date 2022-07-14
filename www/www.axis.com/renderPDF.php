<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
function GetCountOfValue($project_id, $jobsiteDailyLogCreatedDate, $database){
	
	// echo $project_id;
	$db = DBI::getInstance($database);
	$date = date('Y-m-d');
	/*Get daily log id*/
	$query = "SELECT * FROM  `jobsite_daily_logs` where date(jobsite_daily_log_created_date) = '$jobsiteDailyLogCreatedDate' AND project_id='$project_id'";
	$db->execute($query);
	$row = $db->fetch();
	$Id=$row['id'];
	$db->free_result();
	return $Id;
}
function getlogscount($jobsiteID, $database){
	$date = date('Y-m-d');
		$db = DBI::getInstance($database);
		/*Get manpower count*/
		$query = "SELECT count(*) as count FROM jobsite_man_power where jobsite_daily_log_id = '$jobsiteID' ";
		$db->execute($query);
		$row = $db->fetch();
		$Countval=$row['count'];
		$db->free_result();		
		/*Get building act count*/
		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count FROM jobsite_daily_building_activity_logs where jobsite_daily_log_id = '$jobsiteID' ";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		/*Get sitework act count*/
		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count FROM jobsite_daily_sitework_activity_logs where jobsite_daily_log_id = '$jobsiteID' ";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		/*Get inspection act count*/
		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count FROM jobsite_inspections where jobsite_daily_log_id = '$jobsiteID' ";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		/*Get notes act count*/
		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count FROM jobsite_notes where jobsite_daily_log_id = '$jobsiteID' ";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		/*Get delays act count*/
		$db = DBI::getInstance($database);
		$query = "SELECT count(*) as count FROM jobsite_delays where jobsite_daily_log_id = '$jobsiteID' ";
		$db->execute($query);
		$row = $db->fetch();
		$Countval +=$row['count'];
		$db->free_result();
		return $Countval;
}
?>
