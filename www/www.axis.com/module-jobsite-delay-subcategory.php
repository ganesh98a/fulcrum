<?php

/**
* Get the subcategory of the category/type.
*/

$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');
$db = DBI::getInstance($database);     	// Db Initialize

//Query for get sub category of category
$query = "SELECT * FROM jobsite_delay_subcategory_templates WHERE jobsite_delay_category_template_id='". $_POST['id']."'";
$db->execute($query);
$option = '';
$c = 0;
while($row = $db->fetch())
{
	if($c == '0'){
		$rowVal = $row['jobsite_delay_subcategory'];
	}
   	$option .= '<option value="'.$row['id'].'">'.$row['jobsite_delay_subcategory'].'</option>';
   	$c++;
}

if($c == '1' && $rowVal == 'Please Describe Delay'){	// Default set as Please Descripe Delay
	echo $option;
}else{
	echo '<option value="">Select a Subcategory</option>';
	echo $option;
}

?>

         