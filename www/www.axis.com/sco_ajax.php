<?php 
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Message.php');

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


if(isset($_GET['method']) && $_GET['method']=="changeSAV")
{
	$subid = $_GET['subid'];
	$db = DBI::getInstance($database);
	$q1="SELECT `subcontract_actual_value` FROM `subcontracts_old` where `id`='$subid'";
	$db->execute($q1);
	$row =$db->fetch();
	$sav_value=$row['subcontract_actual_value'];
	$query="UPDATE `subcontracts` SET `subcontract_actual_value`='$sav_value' WHERE id='$subid'";
	if($db->execute($query))
	{
		echo 1;
	}else
	{
		echo 0;
	}
}