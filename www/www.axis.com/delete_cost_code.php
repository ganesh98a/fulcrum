<?php
/**
 * Report  Module.
 */

$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');

require_once('lib/common/Message.php');


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
// To get all Wrong mapped gc_budget_id
echo "<br>".$query="SELECT id FROM `gc_budget_line_items` WHERE `user_company_id` <> 3 AND `cost_code_id` IN (SELECT id FROM `cost_codes` WHERE `cost_code_division_id` IN(SELECT id FROM `cost_code_divisions` WHERE `user_company_id`=3))";
$db->execute($query);
$records=array();
while($row = $db->fetch())
    {
        $records[] = $row['id'];
    }

    // echo "<pre>";
    // print_r($records);
 
    foreach ($records as $key => $value) {
    	echo "<br>val : ".$value;
    	$query1="SELECT gc_budget_line_item_id  FROM `subcontracts` WHERE `gc_budget_line_item_id` = $value";
		$db->execute($query1);
		$row1=$db->fetch();
		if($row1)
		{
			echo "<br>No delete".$value;
		}else
		{
			$query2="SELECT * FROM `gc_budget_line_items` WHERE `id` = '$value' and(( prime_contract_scheduled_value IS NOT NULL AND prime_contract_scheduled_value !='0.00')OR( forecasted_expenses IS NOT NULL And forecasted_expenses !='0.00') OR `purchasing_target_date`!='0000-00-00')";
			$db->execute($query2);
			$row2=$db->fetch();
			if($row2)
			{
				echo "<br>No delete boz it has values".$value;
			}else
			{

				echo "<br>". $query1="DELETE from gc_budget_line_items where id= $value";
						$db->execute($query1);
						$db->free_result();
			}
		}

   
    }

