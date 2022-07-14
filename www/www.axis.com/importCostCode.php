<?php 
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
$user_company_id = $session->getUserCompanyId();

if(isset($_GET['project_id']) && $_GET['project_id'])
{
	$project_id=$_GET['project_id'];
	$db = DBI::getInstance($database);
	$que1="SELECT * FROM `gc_budget_line_items` WHERE `project_id` ='".$project_id."'";
	$db->execute($que1);
	$budget=array();
	while($row1=$db->fetch())
	{
		$budget=$row1;
	}
	$bud_count=count($budget);
	if($bud_count=='0')
	{	
		// To get the advent company 
		$que2="SELECT * FROM `user_companies` WHERE `company` ='Advent' order by id Asc limit 1";
	$db->execute($que2);
	$company='';
	while($row2=$db->fetch())
	{
		$company=$row2['id'];
	}
		// To get the Cost Code 
		$que3="SELECT * FROM `cost_code_divisions` WHERE `user_company_id` ='".$company."' ";
	$db->execute($que3);
	$CostCodesDivision=array();
	while($row3=$db->fetch())
	{
		$CostCodesDivision[]=$row3;
	}
	
	foreach ($CostCodesDivision as $key => $CostCodesDivision) {
		
		//To insert into Cost_code_Division
		$que4="Insert into cost_code_divisions (`user_company_id`, `cost_code_type_id`, `division_number`, `division_code_heading`, `division`, `division_abbreviation`, `sort_order`, `disabled_flag`) values ('".$user_company_id."','".$CostCodesDivision['cost_code_type_id']."','".$CostCodesDivision['division_number']."','".$CostCodesDivision['division_code_heading']."','".$CostCodesDivision['division']."','".$CostCodesDivision['division_abbreviation']."','".$CostCodesDivision['sort_order']."','".$CostCodesDivision['disabled_flag']."') ";
			
			if($db->execute($que4)){
            $insertedId = $db->insertId; 
            }

            // To get the Cost_code data 
		$que5="SELECT * FROM `cost_codes` WHERE `cost_code_division_id` ='".$CostCodesDivision['id']."'";
	$db->execute($que5);
	$costCodes=array();
	while($row5=$db->fetch())
	{
		$costCodes[]=$row5;
	}
	foreach ($costCodes as $key => $costCodes) {
		
	// To insert into cost_codes Table
            $que6="INSERT INTO `cost_codes`(`cost_code_division_id`, `cost_code`, `cost_code_description`, `cost_code_description_abbreviation`, `sort_order`, `disabled_flag`) VALUES ('".$insertedId."','".$costCodes['cost_code']."','".$costCodes['cost_code_description']."','".$costCodes['cost_code_description_abbreviation']."','".$costCodes['sort_order']."','".$costCodes['disabled_flag']."') ";
          if($db->execute($que6)){
            $costinsertedId = $db->insertId; 
            }

            // To insert into gc_budget_line_items Table if new cost code is generated
            if($costinsertedId!='')
            {
           $que7="INSERT INTO `gc_budget_line_items`( `user_company_id`, `project_id`, `cost_code_id`,`sort_order`, `disabled_flag`) VALUES ('".$user_company_id."','".$project_id."','".$costinsertedId."','0','N') ";
          if($db->execute($que7)){
            $budgetinsertedId = $db->insertId; 
            }
        }
        else
        {
        	// to insert into cost code for already existed
        	  $que8="INSERT INTO `gc_budget_line_items`( `user_company_id`, `project_id`, `cost_code_id`,`sort_order`, `disabled_flag`) VALUES ('".$user_company_id."','".$project_id."','".$costCodes['id']."','0','N') ";
          if($db->execute($que8)){
            $budgetinsertedId1= $db->insertId; 
            }
        }

    }

	}
	}
	else
	{
		//nothing
	}

}