<?php

/*

<!DOCTYPE html>

*/

?>
<html>
<head>
<title><?php echo $project_name; ?> / <?php echo $vendor_name; ?> Schedule of Values</title>
<link rel="stylesheet" type="text/css" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">
<meta http-equiv="imagetoolbar" content="false">
</head>
<body style="margin: -30px; padding:0;">
	<br><br>
	<table width="100%" style="border-bottom: 2px solid black;" cellpadding="0">
		<tr><th class="textAlignCenter" style="font-size: 16pt;">EXHIBIT C - SCHEDULE OF VALUES</th></tr>
		<tr><td class="textAlignCenter">(Value, distribution and % complete must be approved by Contractor prior to payment)</td></tr>
	</table>
	<table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 5px;">
		<tr valign="top">
			<td width="250">
				<table cellpadding="0" cellspacing="0" style="font-size: 10pt;">
					<tr><th class="textAlignLeft">FROM (SUBCONTRACTOR):</th></tr>
					<tr><td><?php echo $vendor_name; ?></td></tr>
					<tr><td>&nbsp;</td></tr>
				</table>
			</td>
			<td>
				<table cellpadding="0" cellspacing="0" style="font-size: 10pt;">
					<tr><th class="textAlignLeft">PROJECT: <?php echo $user_custom_project_id; ?></th></tr>
					<tr><td><?php echo $project_name; ?></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><th class="textAlignLeft">COST CODE: <?php echo "{$division_number}-{$cost_code} $cost_code_description"; ?></th></tr>
				</table>
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
					<tr><td colspan="2">&nbsp;</td></tr>
				</table>
			</td>
		</tr>
	</table>
	<table class="borderTopBlack borderLeftBlack" width="100%" cellpadding="0" cellspacing="0" style="font-size: 8pt;">
		<tr>
			<th class="borderRightBlack borderBottomBlack">A</th>
			<th class="borderRightBlack borderBottomBlack">B</th>
			<th class="borderRightBlack borderBottomBlack">C</th>
			<th class="borderRightBlack borderBottomBlack">D</th>
			<th class="borderRightBlack borderBottomBlack">E</th>
			<th class="borderRightBlack borderBottomBlack" colspan="2">F</th>
			<th class="borderRightBlack borderBottomBlack">G</th>
		</tr>
		<tr valign="top">
			<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">ITEM<br>NO.</td>
			<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;" nowrap>DESCRIPTION OF WORK</td>
			<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">SCHEDULED<br>VALUE</td>
			<td class="textAlignCenter borderRightBlack borderBottomBlack" colspan="2" style="line-height: 10pt;" nowrap>WORK COMPLETED</td>
			<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">TOTAL<br>COMPLETED<br>TO DATE<br>(D+E)</td>
			<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;" width="100">%<br>(F-C)</td>
			<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">BALANCE<br>TO FINISH<br>(C-F)</td>
		</tr>
		<tr>
			<td class="textAlignCenter borderRightBlack borderBottomBlack" style="line-height: 10pt;">FROM PREVIOUS<br>APPLICATION<br>(D+E)</td>
			<td class="textAlignCenter borderRightBlack borderBottomBlack" style="line-height: 10pt;" nowrap>THIS PERIOD</td>
		</tr>
<?php
			//<cfloop from="1" to="31" index="x">
			for ($tmpI = 0; $tmpI < 31; $tmpI++) {
?>
			<tr>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
			</tr>
<?php
			}
//			</cfloop>
?>
			<tr>
				<th class="borderRightBlack borderBottomBlack textAlignRight" colspan="2">TOTALS:</th>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
				<td class="borderRightBlack borderBottomBlack">&nbsp;</td>
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
				<th style="text-align: right;">PAGE 1 OF 2</th>
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
							<td class="textAlignCenter borderBottomBlack" width="90">Additions</td>
							<td class="textAlignCenter borderBottomBlack" width="90">Deductions</td>
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
							<td style="border-bottom: 1px solid black;" width="125">$</td>
						</tr>
						<tr>
							<td>2.</td>
							<th class="textAlignLeft" colspan="2">NET CHANGE BY CHANGE ORDERS TO DATE:</th>
							<td style="border-bottom: 1px solid black;" width="125">$</td>
						</tr>
						<tr>
							<td>3.</td>
							<th class="textAlignLeft" colspan="2">CONTRACT SUM TO DATE (Line 1 +/- Line 2)</th>
							<td style="border-bottom: 1px solid black;" width="125">$</td>
						</tr>
						<tr>
							<td>4.</td>
							<th class="textAlignLeft" colspan="2">TOTAL COMPLETED & STORED TO DATE</th>
							<td style="border-bottom: 1px solid black;" width="125">$</td>
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
							<td style="border-bottom: 1px solid black;" width="90">$</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>b. _____ % of Stored Materials (Col. F on G703)</td>
							<td style="border-bottom: 1px solid black;" width="90">$</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2">Total Retainage (Line 5a + 5b) OR (Col. I on G703)</td>
							<td style="border-bottom: 1px solid black;" width="125">$</td>
						</tr>
						<tr>
							<td>6.</td>
							<th class="textAlignLeft" colspan="2">TOTAL EARNED LESS RETAINAGE</th>
							<td style="border-bottom: 1px solid black;" width="125">$</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="padding-left: 10px;">(Line 4 less Line 5 Total)</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>7.</td>
							<th class="textAlignLeft" colspan="2">LESS PREVIOUS CERTIFICATES FOR PAYMENT</th>
							<td style="border-bottom: 1px solid black;" width="125">$</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="padding-left: 10px;">(Line 6 From Previous Certificate)</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>8.</td>
							<th class="textAlignLeft" colspan="2">CURRENT PAYMENT DUE</th>
							<td style="border-bottom: 1px solid black;" width="125">$</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="padding-left: 10px;">(Line 6 less Line 7)</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>9.</td>
							<th class="textAlignLeft" colspan="2">BALANCE TO FINISH (INCLUDING RETAINAGE)</th>
							<td style="border-bottom: 1px solid black;" width="125">$</td>
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
				<th style="text-align: right;">PAGE 2 OF 2</th>
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
				<th colspan="2" style="border-right:1px solid black; border-bottom:1px solid black;">G</th>
				<th class="borderRightBlack borderBottomBlack">H</th>
				<th class="borderRightBlack borderBottomBlack">I</th>
			</tr>
			<tr valign="top">
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">ITEM<br>NO.</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" nowrap rowspan="2" style="line-height: 10pt;">DESCRIPTION OF WORK</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">SCHEDULED<br>VALUE</td>
				<td colspan="2" style="text-align: center; line-height: 10pt; border-right:1px solid black; border-bottom:1px solid black;" nowrap>WORK COMPLETED</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">MATERIALS<br>PRESENTLY<br>STORED<br>(NOT IN<br>D OR E)</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">TOTAL<br>COMPLETED<br>AND STORED<br>TO DATE<br>(D+E+F)</td>
				<td rowspan="2" style="text-align: center; line-height: 10pt; border-right:1px solid black; border-bottom:1px solid black;" width="100">%<br>(G-C)</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">BALANCE<br>TO FINISH<br>(C-G)</td>
				<td class="textAlignCenter borderRightBlack borderBottomBlack" rowspan="2" style="line-height: 10pt;">RETAINAGE</td>
			</tr>
			<tr>
				<td style="text-align: center; line-height: 10pt; border-right:1px solid black; border-bottom:1px solid black;">FROM PREVIOUS<br>APPLICATION<br>(D+E)</td>
				<td style="text-align: center; line-height: 10pt; border-right:1px solid black; border-bottom:1px solid black;" nowrap>THIS PERIOD</td>
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
