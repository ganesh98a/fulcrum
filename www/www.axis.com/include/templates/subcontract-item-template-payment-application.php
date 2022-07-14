<?php

/*

<!DOCTYPE html>

*/

// Debug
//require_once('./subcontract-item-template-dummy-data.php');

$project_address = '';
if (isset($project_address_city) && !empty($project_address_city)) {
	$project_address = $project_address_city;
}
if (isset($project_address_state_or_region) && !empty($project_address_state_or_region)) {
	$project_address .= ", $project_address_city";
}
if (isset($project_address_postal_code) && !empty($project_address_postal_code)) {
	$project_address .= " $project_address_postal_code";
}
$project_address = trim($project_address, ',');
$project_address = Data::singleSpace($project_address);
?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta http-equiv="imagetoolbar" content="false">
<title><?php echo $project_name; ?> / <?php echo $vendor_name; ?> Payment Application</title>
<link rel="stylesheet" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
<style>

body {
	font-family: Times;
	font-size: 14px;
}

table {
	font-family: Times;
	font-size: 14px;
	page-break-before: auto;
}

td {
	text-align: justify;
}

p {
	line-height: 11pt;
}

.waiverTitle, .waiverWarningBox {
	font-family: Times;
	font-size: 16px;
	font-weight: bold;
	text-transform: uppercase;
}

.waiverSubTitle {
	font-family: Times;
	font-size: 14px;
	text-transform: uppercase;
}

.waiverWarningBox {
	border: 1px solid black;
	text-align: justify;
	padding: 5px;
	margin: 5px;
	line-height: 18px;
}

.populateTable {
	width: 80%;
}

.populateLine {
	width: 100%;
	border-bottom: 1px solid black;
}

.sigBlock {
	font-family: Times;
	font-size: 12px;
	vertical-align: top;
}
</style>
</head>
<body style="margin:-20px; padding: 0px;">

<br>
<br>

<table style="font-size: 16pt; border-bottom: 2px solid black;" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="textAlignCenter">SUBCONTRACTOR'S APPLICATION FOR PAYMENT</td>
	</tr>
</table>

<br>

<table style="border-bottom: 2px solid black;" border="0" cellpadding="0" cellspacing="0" width="100%">

<tr valign="top">
<td class="textAlignLeft" nowrap width="30%" nowrap><b>TO (GENERAL CONTRACTOR):</b></td>
<td class="textAlignLeft" nowrap width="30%" nowrap><b>PROJECT: <?php echo $user_custom_project_id; ?></b></td>
<td class="textAlignRight" nowrap width="30%" nowrap><b>APPLICATION DATE: </b></td>
<td class="borderBottomBlack" width="10%">&nbsp;</td>
</tr>

<tr>
<td nowrap><?php echo $EntityName; ?></td>
<td nowrap><?php echo $project_name; ?></td>
<td class="textAlignRight" nowrap><b>APPLICATION NO:</b> </td>
<td class="borderBottomBlack">&nbsp;</td>
</tr>

<tr>
<td nowrap><?php echo $general_contractor_address_line_1; ?></td>
<td nowrap><?php echo $project_address_line_1; ?></td>
<td class="textAlignRight" nowrap><b>WORK PERFORMED THROUGH: </b></td>
<td class="borderBottomBlack">&nbsp;</td>
</tr>

<tr>
<td style="white-space:nowrap;"><?php echo $general_contractor_address_city; ?>, <?php echo $general_contractor_address_state_or_region; ?> <?php echo $general_contractor_address_postal_code; ?></td>
<td nowrap><?php echo $project_address; ?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr><td colspan="4">&nbsp;</td></tr>

<tr>
<td class="textAlignLeft" nowrap><b>FROM (SUBCONTRACTOR):</b></td>
<td class="textAlignLeft" nowrap><b>COST CODE: <?php echo $costCodeLabel; ?></b></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr>
<td align="left" nowrap><div style="padding-top:10px;"><b><?php echo $vendor_name; ?></b></div></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr><td colspan="4">&nbsp;</td></tr>

<tr><td colspan="4">&nbsp;</td></tr>

<tr><td colspan="4">&nbsp;</td></tr>

</table>

<?php /*
<tr><td nowrap><?php echo $general_contractor_address_line_1; ?></td></tr>
<tr><td nowrap><?php echo $general_contractor_address_city; ?>, <?php echo $general_contractor_address_state_or_region; ?> <?php echo $general_contractor_address_postal_code; ?></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><th class="textAlignLeft" nowrap>FROM (SUBCONTRACTOR):</th></tr>
<tr><td style="padding-top:10px;" nowrap><?php echo $vendor_name; ?></td></tr>
<tr><td style="padding-top:10px;">&nbsp;</td></tr>
<tr><td style="padding-top:10px;">&nbsp;</td></tr>
<tr></tr>
<tr><td nowrap><?php echo $project_name; ?></td></tr>
<tr><td nowrap><?php echo $project_address_line_1; ?></td></tr>
<tr><td nowrap><?php echo $project_address_city; ?>, <?php echo $project_address_state_or_region; ?> <?php echo $project_address_postal_code; ?></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><th class="textAlignLeft" nowrap>COST CODE: <?php echo "{$division_number}-{$cost_code} $cost_code_description"; ?></th></tr>
<tr><td>&nbsp;</td></tr>
			</td>
			<td class="textAlignRight">
				<table cellpadding="0" cellspacing="0" style="font-size: 10pt;" border="0" width="100%">
					<tr>
						<th class="textAlignRight" nowrap>APPLICATION DATE: </th>
						<td class="borderBottomBlack" style="line-height: 18pt;" width="100"&nbsp;</td>
					</tr>
					<tr>
						<th class="textAlignRight" nowrap>APPLICATION NO: </th>
						<td class="borderBottomBlack" style="line-height: 18pt;" width="100"&nbsp;</td>
					</tr>
					<tr>
						<th class="textAlignRight" nowrap>WORK PERFORMED THROUGH: </th>
						<td class="borderBottomBlack" style="line-height: 18pt;" width="100"&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
*/ ?>
<div class="textAlignCenter">
<table border="0" cellspacing="10" cellpadding="0" style="font-size:10pt;">
	<tr>
		<td class="textAlignCenter" colspan="3">
			Application is made for Payment, as shown below, in connection with the Subcontract.
			<br>
			<b>(Approved Schedule of Values must be attached with updated percent complete)</b>
		</td>
	</tr>
	<tr>
		<td width="10">1.</td>
		<th class="textAlignLeft" nowrap>ORIGINAL CONTRACT VALUE</th>
		<td class="borderBottomBlack" width="150">$</td>
	</tr>
	<tr>
		<td>2.</td>
		<th class="textAlignLeft" nowrap>NET CHANGE ORDERS (Do Not Invoice For Unapproved Change Orders)</th>
		<td class="borderBottomBlack" width="150">$</td>
	</tr>
	<tr>
		<td>3.</td>
		<th class="textAlignLeft" nowrap>CONTRACT SUM TO DATE (Line 1 +/- Line 2)</th>
		<td class="borderBottomBlack" width="150">$</td>
	</tr>
	<tr>
		<td>4.</td>
		<th class="textAlignLeft" nowrap>TOTAL COMPLETED & STORED TO DATE (Column F on Schedule of Values)</th>
		<td class="borderBottomBlack" width="150">$</td>
	</tr>
	<tr>
		<td>5.</td>
		<th class="textAlignLeft" nowrap>LESS RETAINAGE:</th>
		<td class="borderBottomBlack" width="150">$</td>
	</tr>

	<tr>
		<td>6.</td>
		<th class="textAlignLeft" nowrap>TOTAL EARNED LESS RETAINAGE (Line 4 Less Line 5 Total)</th>
		<td class="borderBottomBlack" width="150">$</td>
	</tr>
	<tr>
		<td>7.</td>
		<th class="textAlignLeft" nowrap>LESS PREVIOUS CERTIFICATES FOR PAYMENT</th>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<th class="textAlignLeft" style="padding-left: 10px;" nowrap>(Line 6 From Prior Application)</th>
		<td class="borderBottomBlack" width="150">$</td>
	</tr>
	<tr>
		<td>8.</td>
		<th class="textAlignLeft" nowrap>CURRENT PAYMENT DUE (Line 6 Less Line 7)</th>
		<td class="borderBottomBlack" width="150">$</td>
	</tr>
	<tr>
		<td>9.</td>
		<th class="textAlignLeft" nowrap>BALANCE TO FINISH, PLUS RETAINAGE (Line 3 Less Line 6)</th>
		<td class="borderBottomBlack" width="150">$</td>
	</tr>
</table>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="2" style="margin-top: 3px;">
	<tr><td colspan="4" style="border-top: 2px solid black;">&nbsp;</td></tr>
	<tr>
		<td colspan="4" style="font-size:10pt;">
			The undersigned Subcontractor certifies that to the best of the Subcontractor's knowledge,
			information and belief the Work covered by this Application for Payment has been completed
			in accordance with the Contract Documents, that all amounts owed to others have been paid
			by the Subcontractor for Work for which previous Applications for Payment were issued and
			payment received from the Contractor, and that current payment shown herein is now due.
		</td>
	</tr>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr><td colspan="4">SUBCONTRACTOR</td></tr>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr>
		<td class="borderBottomBlack" colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td class="borderBottomBlack">&nbsp;</td>
	</tr>
	<tr>
		<td>Signature:</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Date</td>
	</tr>
	<tr>
		<td class="borderBottomBlack" colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Name:</td>
		<td colspan="3">&nbsp;</td>
	</tr>
									<tr>
		<td class="borderBottomBlack" colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Title:</td>
		<td colspan="3">&nbsp;</td>
	</tr>
</table>

</body>
</html>

<?php

/*
<!--- <html>
<head>

	<title><?php echo $project_name; ?> / <?php echo $vendor_name; ?> Payment Application</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body style="padding:0; margin:0;">

	<center>
		<table width="100%" style="font-size: 16pt; border-bottom: 2px solid black;" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<th class="textAlignLeft">APPLICATION AND CERTIFICATE FOR PAYMENT</th>
				<th><i>AIA DOCUMENT G702</i></th>
				<th class="textAlignRight">PAGE 1 OF 2</th>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 3px; border-bottom: 2px solid black;">
			<tr valign="top">
				<td width="225">
					<table cellpadding="0" cellspacing="0" style="font-size: 10pt;">
						<tr><th class="textAlignLeft">TO (CONTRACTOR):</th></tr>
						<tr><td><?php echo $general_contractor_company_name; ?></td></tr>
						<tr><td><?php echo $general_contractor_address_line_1; ?></td></tr>
						<tr><td><?php echo $general_contractor_address_city; ?>, <?php echo $general_contractor_address_state_or_region; ?> <?php echo $general_contractor_address_postal_code; ?></td></tr>
					</table>
				</td>
				<td width="290">
					<table cellpadding="0" cellspacing="0" style="font-size: 10pt;">
						<tr><th class="textAlignLeft">PROJECT: #project_id#</th></tr>
						<tr><td><?php echo $project_name; ?></td></tr>
						<tr><td>#jAddr#</td></tr>
						<tr><td>#jCity#, #jState#  #jZip#</td></tr>
					</table>
				</td>
				<td width="290">
					<table cellpadding="0" cellspacing="0" style="font-size: 10pt;">
						<tr><th class="textAlignLeft">FROM (SUBCONTRACTOR):</th></tr>
						<tr><td><?php echo $vendor_name; ?></td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><th class="textAlignLeft">COST CODE: <?php echo "{$division_number}-{$cost_code} $cost_code_description"; ?></th></tr>
					</table>
				</td>
				<td align="right">
					<table cellpadding="0" cellspacing="0" style="font-size: 10pt;">
						<tr>
							<th class="textAlignLeft" nowrap>APPLICATION: </th>
							<td class="borderBottomBlack" style="line-height: 18pt;" width="80">&nbsp;</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<th class="textAlignLeft">PERIOD TO:</th>
							<td class="borderBottomBlack" style="line-height: 18pt;" width="80">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 3px;">
			<tr valign="top">
				<td width="49%">
					<table border="0" cellspacing="4" cellpadding="4" style="font-size: 10pt;">
						<tr><th colspan="4" style="border: 2px solid black;">CHANGE ORDER SUMMARY</th></tr>
						<tr>
							<td colspan="2">Previously Approved Totals:</td>
							<td class="borderBottomBlack">$</td>
							<td class="borderBottomBlack">$</td>
						</tr>
						<tr>
							<td class="borderBottomBlack" width="90">New ##</td>
							<td class="borderBottomBlack" nowrap>Date Approved</td>
							<td width="90" style="text-align=:center; border-bottom:1px solid black;">Additions</td>
							<td width="90" style="text-align=:center; border-bottom:1px solid black;">Deductions</td>
						</tr>
						<cfloop from="1" to="3" index="x">
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>$</td>
								<td>$</td>
							</tr>
						</cfloop>
						<tr>
							<td colspan="2" align="right">This Month's Totals:</td>
							<td class="borderBottomBlack" width="90">$</td>
							<td class="borderBottomBlack" width="90">$</td>
						</tr>
						<tr>
							<td align="right" colspan="3" nowrap>Net Change By C.O. To Date: (Copy to Line 2)</td>
							<td class="borderBottomBlack">$</td>
						</tr>
						<tr>
							<td colspan="4" style="border-top: 2px solid black; font-size:10pt;">
								The undersigned Subcontractor certifies that to the best of the Subcontractor's knowledge,
								information, and belief, that (1) the Work covered by this Application for Payment has been
								completed in accordance with the Contract Documents, that all amounts have been paid by
								the Contrator for Work for which previous Certificates of Payment were issued and payment
								received from the Contractor, and that current payment shown herein is now due, and (2)
								this Application for Payment includes all labor and materials furnished through the "Period
								To" date, including all extras and claims for additional compensation by Subcontractor or
								its Sub-subcontractors or suppliers under Sections 9 and 27 of the Subcontract to which
								Subcontractor claims it is entitled, except retention and claims for additional compensation
								for which a claim or change order request has been made in writing but not approved by Contractor.
							</td>
						</tr>
						<tr>
							<td class="borderBottomBlack" colspan="2">&nbsp;</td>
							<td>&nbsp;</td>
							<td class="borderBottomBlack">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">Signature</td>
							<td>&nbsp;</td>
							<td>Date</td>
						</tr>
					</table>
				</td>
				<td width="51%" style="padding-left: 10px;">
					<table border="0" cellpadding="3" cellspacing="0" style="font-size:8pt;">
						<tr>
							<td colspan="4">Application is made for Payment, as shown below, in connection with the Contract.</td>
						</tr>
						<tr>
							<td>1.</td>
							<th class="textAlignLeft" colspan="2">ORIGINAL CONTRACT SUM</th>
							<td class="borderBottomBlack" width="125">$</td>
						</tr>
						<tr>
							<td>2.</td>
							<th class="textAlignLeft" colspan="2">NET CHANGE BY CHANGE ORDERS TO DATE:</th>
							<td class="borderBottomBlack" width="125">$</td>
						</tr>
						<tr>
							<td>3.</td>
							<th class="textAlignLeft" colspan="2">CONTRACT SUM TO DATE (Line 1 +/- Line 2)</th>
							<td class="borderBottomBlack" width="125">$</td>
						</tr>
						<tr>
							<td>4.</td>
							<th class="textAlignLeft" colspan="2">TOTAL COMPLETED & STORED TO DATE</th>
							<td class="borderBottomBlack" width="125">$</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="padding-left: 10px;">(Col. G on G703)</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>5.</td>
							<th class="textAlignLeft" colspan="2">RETAINAGE:</th>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>a. _____ % of Completed Work (Col. D + E on G703)</td>
							<td class="borderBottomBlack" width="90">$</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>b. _____ % of Stored Materials (Col. F on G703)</td>
							<td class="borderBottomBlack" width="90">$</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2">Total Retainage (Line 5a + 5b) OR (Col. I on G703)</td>
							<td class="borderBottomBlack" width="125">$</td>
						</tr>
						<tr>
							<td>6.</td>
							<th class="textAlignLeft" colspan="2">TOTAL EARNED LESS RETAINAGE</th>
							<td class="borderBottomBlack" width="125">$</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="padding-left: 10px;">(Line 4 less Line 5 Total)</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>7.</td>
							<th class="textAlignLeft" colspan="2">LESS PREVIOUS CERTIFICATES FOR PAYMENT</th>
							<td class="borderBottomBlack" width="125">$</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="padding-left: 10px;">(Line 6 From Previous Certificate)</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>8.</td>
							<th class="textAlignLeft" colspan="2">CURRENT PAYMENT DUE</th>
							<td class="borderBottomBlack" width="125">$</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="padding-left: 10px;">(Line 6 less Line 7)</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>9.</td>
							<th class="textAlignLeft" colspan="2">BALANCE TO FINISH (INCLUDING RETAINAGE)</th>
							<td class="borderBottomBlack" width="125">$</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="padding-left: 10px;">(Line 3 less Line 6)</td>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<cfdocumentitem type="pagebreak"></cfdocumentitem>
		<table width="100%" style="font-size: 16pt; border-bottom: 2px solid black;" cellpadding="0">
			<tr>
				<th class="textAlignLeft">EXHIBIT C - PAYMENT SCHEDULE</th>
				<th><i>AIA DOCUMENT G703</i></th>
				<th class="textAlignRight">PAGE 2 OF 2</th>
			</tr>
		</table>
		<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:5px;">
			<tr valign="top">
				<td width="290">
					<table cellpadding="0" cellspacing="0" style="font-size: 10pt;">
						<tr><th class="textAlignLeft">PROJECT: #project_id#</th></tr>
						<tr><td><?php echo $project_name; ?></td></tr>
						<tr><td>#jAddr#</td></tr>
						<tr><td>#jCity#, #jState#  #jZip#</td></tr>
					</table>
				</td>
				<td>
					<table cellpadding="0" cellspacing="0" style="font-size: 10pt;">
						<tr><th class="textAlignLeft">FROM (SUBCONTRACTOR):</th></tr>
						<tr><td><?php echo $vendor_name; ?></td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><th class="textAlignLeft">COST CODE: <?php echo "{$division_number}-{$cost_code} $cost_code_description"; ?></th></tr>
					</table>
				</td>
				<td class="textAlignRight">
					<table cellpadding="0" cellspacing="0" style="font-size: 10pt;">
						<tr>
							<th class="textAlignLeft" nowrap>APP. NUMBER: </th>
							<td class="borderBottomBlack" style="line-height: 18pt;" width="80">&nbsp;</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<th class="textAlignLeft">PERIOD TO:</th>
							<td class="borderBottomBlack" style="line-height: 18pt;" width="80">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table width="100%" cellpadding="0" cellspacing="0" style="font-size: 8pt; border-top:1px solid black; border-left:1px solid black;">
			<tr>
				<th class="borderRightBlack borderBottomBlack">A</th>
				<th class="borderRightBlack borderBottomBlack">B</th>
				<th class="borderRightBlack borderBottomBlack">C</th>
				<th class="borderRightBlack borderBottomBlack">D</th>
				<th class="borderRightBlack borderBottomBlack">E</th>
				<th class="borderRightBlack borderBottomBlack">F</th>
				<th class="borderRightBlack borderBottomBlack" colspan="2">G</th>
				<th class="borderRightBlack borderBottomBlack">H</th>
				<th class="borderRightBlack borderBottomBlack">I</th>
			</tr>
			<tr valign="top">
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">ITEM<br>NO.</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;" nowrap>DESCRIPTION OF WORK</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">SCHEDULED<br>VALUE</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" colspan="2" style="line-height: 10pt;" nowrap>WORK COMPLETED</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">MATERIALS<br>PRESENTLY<br>STORED<br>(NOT IN<br>D OR E)</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">TOTAL<br>COMPLETED<br>AND STORED<br>TO DATE<br>(D+E+F)</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;" width="100">%<br>(G-C)</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">BALANCE<br>TO FINISH<br>(C-G)</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">RETAINAGE</td>
			</tr>
			<tr>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" style="line-height: 10pt;">FROM PREVIOUS<br>APPLICATION<br>(D+E)</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" style="line-height: 10pt;" nowrap>THIS PERIOD</td>
			</tr>
			<cfloop from="1" to="23" index="x">
				<tr>
					<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
					<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
					<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
					<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
					<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
					<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
					<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
					<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
					<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
					<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				</tr>
			</cfloop>
		</table>
	</center>
</body>
</html> --->
*/
?>
