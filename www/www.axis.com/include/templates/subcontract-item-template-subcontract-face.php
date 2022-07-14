<?php

/*

*/

$currentDate = date("m/d/Y");

?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta http-equiv="imagetoolbar" content="false">
<title><?php echo $project_name; ?> Contract Face</title>
<link rel="stylesheet" type="text/css" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
<style>

body {
	font-family: Times;
	font-size: 12px;
}

table {
	font-family: Times;
	font-size: 12px;
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
	<center>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
			<tr><th style="border-top:1px solid black; border-bottom:1px solid black; padding:3px;">SUBCONTRACT AGREEMENT</th></tr>
			<tr>
				<td>
					This Subcontract is made as of <?php echo $currentDate; ?> by
					and between Contractor and Subcontractor named below and is as follows:
				</td>
			</tr>
			<tr>
				<th class="textAlignLeft">I. DEFINITIONS</th>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
<!--- CONTRACTOR INFORMATION --->
			<tr valign="top">
				<th class="textAlignLeft" style="padding-left: 20px; line-height: 12pt; padding-right: 0px;">Contractor:</th>
				<td colspan="2" style="line-height: 12pt;" nowrap>
					<strong><?php echo $EntityName; ?></strong><br>
					<?php echo $general_contractor_address_line_1; ?><br>
					<?php echo $general_contractor_address_city; ?>, <?php echo $general_contractor_address_state_or_region; ?> <?php echo $general_contractor_address_postal_code; ?><br>
					<?php echo $general_contractor_phone_number; ?> Fax: <?php echo $general_contractor_fax_number; ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="4">&nbsp;</td></tr>
<!---
			<tr><td colspan="2">&nbsp;</td><td><?php echo $general_contractor_address_line_1; ?></td><td colspan="5">&nbsp;</td></tr>
			<tr><td colspan="2">&nbsp;</td><td><?php echo $general_contractor_address_city; ?>, CA  92675</td><td colspan="5">&nbsp;</td></tr>
			<tr><td colspan="2">&nbsp;</td><td nowrap>(949) 582-2044  Fax: (949) 582-2041</td><td colspan="5">&nbsp;</td></tr>
--->
<!--- SUBCONTRACTOR INFORMATION --->
			<tr valign="top">
				<th class="textAlignLeft" style="padding-left: 20px; line-height: 12pt; padding-right: 0px;">Subcontractor:</th>
				<td style="line-height: 12pt;" nowrap>
					<strong><?php echo $vendor_name; ?></strong><br>
					<?php echo $vendor_address_line_1; ?><br>
					<?php echo $vendor_address_city; ?>, <?php echo $vendor_address_state_or_region; ?>  <?php echo $vendor_address_postal_code; ?><br>
					<?php echo $vendor_phone_number; ?>  Fax: <?php echo $vendor_fax_number; ?>
				</td>
				<td width="10%">&nbsp;</td>
				<td style="line-height:14pt;" nowrap>
					<strong>Subcontractor Point of Contact</strong><br>
					Name: _________________________________________<br>
					Phone: ________________  Mobile: __________________<br>
					Email: _________________________________________
				</td>
			</tr>
			<tr><td colspan="4">&nbsp;</td></tr>
<!---
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>#vAddr#</td>
				<td>&nbsp;</td>
				<th class="textAlignLeft">Name:</th>
				<td colspan="3" style="border-bottom: 1px solid black;">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>#vCity#, #vState#  #vZip#</td>
				<td>&nbsp;</td>
				<th class="textAlignLeft">Phone:</th>
				<td style="border-bottom: 1px solid black;" width="100">&nbsp;</td>
				<th class="textAlignLeft">Mobile:</th>
				<td style="border-bottom: 1px solid black;" width="100">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td nowrap>#vPhone#  Fax: #vFax#</td>
				<td>&nbsp;</td>
				<th class="textAlignLeft">Email:</th>
				<td colspan="3" style="border-bottom: 1px solid black;">&nbsp;</td>
			</tr>
--->
<!--- PROJECT INFORMATION --->
			<tr valign="top">
				<th class="textAlignLeft" style="padding-left: 20px; line-height: 12pt; padding-right: 0px;">Project:</th>
				<td style="line-height: 12pt;" nowrap>
					<?php echo $project_name; ?><br>
					<?php echo $project_address_line_1; ?><br>
					<?php echo $project_address_city; ?>, <?php echo $project_address_state_or_region; ?>  <?php echo $project_address_postal_code; ?>
				</td>
				<td width="10%">&nbsp;</td>
				<td style="line-height:14pt;" nowrap>
					<strong>Subcontractor 24 Hour Emergency Contact</strong><br>
					Name: _________________________________________<br>
					Phone: _________________  Mobile: _________________<br>
					Email: _________________________________________
				</td>
			</tr>
<!---
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>#jAddr#</td>
				<td>&nbsp;</td>
				<th class="textAlignLeft">Name:</th>
				<td colspan="3" style="border-bottom: 1px solid black;">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td>#jCity#, #jState#  #jZip#</td>
				<td>&nbsp;</td>
				<th class="textAlignLeft">Phone:</th>
				<td style="border-bottom: 1px solid black;" width="100">&nbsp;</td>
				<th class="textAlignLeft">Mobile:</th>
				<td style="border-bottom: 1px solid black;" width="100">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
				<th class="textAlignLeft">Email:</th>
				<td colspan="3" style="border-bottom: 1px solid black;">&nbsp;</td>
			</tr>
--->
<!--- CONTRACT DOCUMENT INFO --->
			<tr>
				<th class="textAlignLeft" style="padding-left: 20px;" colspan="4">The Contract Documents consist of the following:</th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="line-height: 12pt;" colspan="3">
					1. Subcontract Agreement<br>
					2. Subcontract Terms and Conditions<br>
					3. All Exhibits incorporated into the Subcontract Terms and Conditions<br>
					4. Plans and Specifications<br>
					5. All other documents made part of this Subcontract Agreement pursuant to the Subcontract Terms and Conditions
				</td>
			</tr>
			<tr><td colspan="4">&nbsp;</td></tr>
			<tr valign="top">
				<th class="textAlignLeft" style="padding-left: 20px; line-height: 12pt; padding-right: 0px;">Work:</th>
				<td colspan="3" style="line-height: 12pt;">
					Means all work necessary to complete the project described in the Contract Documents
					and all of the Exhibits listed in the Contract Documents for the trade of
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="font-size: 16px; padding-left:55px;">
					<strong><?php echo "{$division_number}-{$cost_code} $cost_code_description"; ?></strong>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="line-height: 12pt;">
					Which includes all work that can reasonably be inferred from the Contract Documents,
					including all labor, materials, equipment, services, taxes, insurance, permits, supervision,
					shop and field labor, engineering, and all other activities to complete the whole or any
					part of the Project.
				</td>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr valign="middle">
				<th class="textAlignLeft" style="line-height: 16pt;" nowrap>
				II. SUBCONTRACT PRICE<span style="display:inline-block; font-size: 16px; padding-left: 15px;"><strong><?php echo $subcontract_actual_value; ?></strong></span>
				</th>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
			<tr>
				<td style="line-height: 12pt;">
					Contractor agrees to pay Subcontractor for the completion of the Work and the performance
					of this Subcontract in the above amount, subject to additions and or deletions for changes
					agreed upon or to be determined pursuant to the Subcontract Terms and Conditions.  Partial progress payments will
					be made to Subcontractor each month subject to the terms and conditions of this Subcontract
					in the amount equal to ninety percent (90%) of the value, computed on the basis of the
					price set forth above, of that portion of the work complete, less the aggregate of all previous
					payments.  All applicable sales and use taxes are included in the above Subcontract Price.
					<br><br>
					Subcontractors are required by law to be licensed and regulated by the Contractors State
					License Board, which has jurisdiction over complaints against contractors for
					 a patent act or omission filed within four years of the date of the
					alleged violation and for a latent act or ommission pertaining to structural
					defects filed within 10 years of date of the alleged violation.  Any questions
					concerning a contractor may be referred to the Registrar, Contractors State License Board,
					P.O. Box 26000, Sacramento, CA  95826.
					<br><br>
					By signing below, Subcontractor agrees to the terms of this Subcontract Agreement, the
					attached Subcontract Terms and Conditions, all Exhibits and other Contract Documents defined above.
				</td>
			</tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px; margin-top:10px;">

		<tr>
		<th class="textAlignLeft" style="height: 30px;">Contractor:</th>
		<td style="height: 30px; border-bottom:1px solid black; padding-left: 10px;" width="35%"><strong><?php echo $EntityName; ?></strong></td>
		<th class="textAlignLeft" style="height: 30px; padding-left:15px;">Subcontractor:</th>
		<td style="height: 30px; border-bottom:1px solid black; padding-left: 10px;" width="35%"><strong><?php echo $vendor_name; ?></strong></td>
		</tr>

		<tr>
		<th class="textAlignLeft" style="height: 30px;">Signed:</th>
		<td style="height: 30px; border-bottom:1px solid black;">&nbsp;</td>
		<th class="textAlignLeft" style="height: 30px; padding-left:15px;">Signed:</th>
		<td style="height: 30px; border-bottom:1px solid black;">&nbsp;</td>
		</tr>

		<tr>
		<th class="textAlignLeft" style="height: 30px;">Dated:</th>
		<td style="height: 30px; border-bottom:1px solid black;">&nbsp;</td>
		<th class="textAlignLeft" style="height: 30px; padding-left:15px;">Dated:</th>
		<td style="height: 30px; border-bottom:1px solid black;">&nbsp;</td>
		</tr>

		<tr>
		<th class="textAlignLeft" style="height: 30px;">Title:</th>
		<td style="height: 30px; border-bottom:1px solid black;">&nbsp;</td>
		<th class="textAlignLeft" style="height: 30px; padding-left:15px;">Title:</th>
		<td style="height: 30px; border-bottom:1px solid black;">&nbsp;</td>
		</tr>

		<tr>
		<th class="textAlignLeft" style="height: 30px;">License:</th>
		<td style="height: 30px; border-bottom:1px solid black; padding-left: 10px;"><?php echo $EntityLicense; ?></td>
		<th style="height: 30px; text-align: left; padding-left:15px;">License:</th>
		<td style="height: 30px; border-bottom:1px solid black;"><?php echo $vendor_License; ?></td>
		</tr>

		</table>
	</center>
</body>
</html>
