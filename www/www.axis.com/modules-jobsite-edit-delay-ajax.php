<?php

$data = array();
		
		$id = $_POST['delid'];
		$dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = 'db@dm1n';   //$dbpass = 'db@dm1n';
        $conn = mysql_connect($dbhost, $dbuser, $dbpass);
        if(! $conn ) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db('fulcrum');
        $selectQuery = "SELECT * FROM jobsite_delay_data WHERE id = " . $id;
		$editData =  mysql_query($selectQuery,$conn);
		while($row3 = mysql_fetch_array($editData, MYSQL_ASSOC)){
			$data['editData'][] =$row3;
		}
        $query = "SELECT * FROM jobsite_delay_category_templates";
        $retval = mysql_query( $query, $conn );
        	if(! $retval ) {
		      die('Could not get data: ' . mysql_error());
		   }
		while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
		   		$data['userTypes'][] = $row;
		}
		$data['userSubcategory'] = array();
		$query1 = "SELECT * FROM jobsite_delay_subcategory_templates WHERE jobsite_delay_category_template_id = " . $data['editData'][0]['type'];
		$result = mysql_query($query1,$conn);
		while($row1 = mysql_fetch_array($result, MYSQL_ASSOC)){
			$data['userSubcategory'][] =$row1;
		}

		// $data['userSource'] = array();
		// $query2 = "SELECT * FROM jobsite_delay_source ";
		// $result2 = mysql_query($query2,$conn);
		// while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){
		// 	$data['userSource'][] =$row2;
		// }

echo json_encode($data);
exit;

?>
