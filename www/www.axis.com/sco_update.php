<?php
/**
 * SCO Module.
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
// To get gc_budget_line_items table 
$query="SELECT s.id as new_id,s.subcontract_actual_value,s.gc_budget_line_item_id,old.id as old_id ,old.subcontract_actual_value as original_value FROM `subcontracts` as s inner join subcontracts_old as old on s.id=old.id where s.subcontract_actual_value !=old.subcontract_actual_value order by s.id Asc ";
$db->execute($query);
$records=array();
while($row = $db->fetch())
    {
        $records[] = $row;
    }
    $db->free_result();
    $i='1';
    $diff_amt=0;
    foreach ($records as $key => $row) {
    	$new=$row['subcontract_actual_value'];
    	$old=$row['original_value'];
    	$diff_amt =$new - $old;
    	$diff_amt= number_format($diff_amt, 2);

    	 
    	$q2="SELECT sum(estimated_amount) as estimated_amount FROM `subcontract_change_order_data` WHERE `subcontractor_id` ='".$row['new_id']."'";
		$db->execute($q2);
		$row1=$db->fetch();
		$sco_amt = number_format($row1['estimated_amount'], 2);
		

		if($diff_amt == $sco_amt)
		{
			$syt="color:red";
		}else
		{
			$syt="";
		}
    	$TableTbody .= "
    	<tr>
    	<th class=textAlignCenter>".$i."</th>
    	<th class=textAlignCenter>".$row['new_id']."</th>
    	<th class=textAlignCenter>".$row['gc_budget_line_item_id']."</th>
    	<th align='right'>".$row['original_value']."</th>
		<th align='right'>".$row['subcontract_actual_value']."</th>
		<th align='right' style='$syt'>".$diff_amt."</th>
		<th align='right' style='$syt'>".$sco_amt."</th>
		<th class=textAlignCenter id='sub_".$row['new_id']."'><input type='button' value='Update' onclick=updateSAV('".$row['new_id']."');></th>
		</tr>";
		$i++;

    }

    $htmlContent = <<<END_HTML_CONTENT
    <html>
    <head>
    <script src="/js/scripts.js.php"></script>
    <script>
    function updateSAV(subid)
    {
    	var ajaxHandler = window.ajaxUrlPrefix + 'sco_ajax.php?method=changeSAV';
		var ajaxQueryString =
		'responseDataType=json&subid='+subid;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				if(data=='1')
				{
					$('#sub_'+subid).html('success');
				}

			},
			error: errorHandler
		});
    }
    </script>
    </head>
    <body>
<table id="Transmittal_list_container--manage-Transmittal_data-record" class="content cell-border dealy-grid custom_delay_padding custom_table_alignment_delay" border="0" cellpadding="5" cellspacing="0" width="100%">
	<thead class="borderBottom">
	<tr><td colspan='6' style="font-size:20px;" align='center'>Rows that has difference in the Subcontract Actual Value are listed below</td></tr>
		<tr>
		<th class="textAlignLeft">s.no</th>
		<th class="textAlignLeft">subcontracts id</th>
		<th class="textAlignLeft">gc budget line item id</th>
		<th align='right'>Old SAV </th>
		<th align='right'>Current SAV</th>
		<th align='right'>Difference (current-old)</th>
		<th align='right'>SCO AMOUNT</th>
		<th class="textAlignLeft">Action</th>
END_HTML_CONTENT;

$htmlContent .= <<<END_HTML_CONTENT


		</tr>
	</thead>
	<tbody class="altColors">
		$TableTbody
	</tbody>
</table>
</body>


END_HTML_CONTENT;
echo $htmlContent;
