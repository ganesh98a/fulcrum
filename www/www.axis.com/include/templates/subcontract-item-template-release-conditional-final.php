<?php

/*

<cfparam name="adventCompany" default="">
<cfparam name="amount" default="">
<cfparam name="through" default="">
<cfparam name="company" default="">
<cfparam name="customer" default="">
<cfparam name="owner" default="">

*/

?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta http-equiv="imagetoolbar" content="false">
<title><?php echo $project_name; ?> Waivers and Releases - Conditional Final</title>
<link rel="stylesheet" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
</head>
<body>
	<center>
		<p>
			<div class="waiverTitle">
				CONDITIONAL WAIVER AND RELEASE
				<br>
				UPON FINAL PAYMENT
			</div>
			<div class="waiverSubTitle">
				CALIFORNIA CIVIL CODE SECTION 8136
			</div>
		</p>
		<p>
			<div class="waiverWarningBox">
				NOTICE:  THIS DOCUMENT WAIVES THE CLAIMANT'S LIEN, STOP PAYMENT NOTICE, AND PAYMENT BOND RIGHTS EFFECTIVE ON RECEIPT OF PAYMENT.
				A PERSON SHOULD NOT RELY ON THIS DOCUMENT UNLESS SATISFIED THAT THE CLAIMANT HAS RECEIVED PAYMENT.
			</div>
		</p>
		<br>
		<table border="0" cellspacing="0" cellpadding="1" width="100%">
			<tr>
				<td nowrap width="25%">Name of Claimant:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $vendor_company_name; ?></td>
			</tr>
			<tr>
				<td nowrap>Name of Customer:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $EntityName; ?></td>
			</tr>
			<tr>
				<td nowrap>Job Name:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $project_name; ?></td>
			</tr>
			<tr>
				<td nowrap>Job Location:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $project_address_line_1; ?>, <?php echo $project_address_city; ?>, <?php echo $project_address_state_or_region; ?>, <?php echo $project_address_postal_code; ?></td>
			</tr>
			<tr>
				<td nowrap>Owner:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $project_owner_name; ?></td>
			</tr>
		</table>
		<br>
		<p class="textAlignJustify">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			This document waives and releases lien, stop payment notice, and payment bond rights the claimant has for labor and service provided,
			and equipment and material delivered, to the customer on this job. Rights based upon labor or service provided, or equipment or
			material delivered, pursuant to a written change order that has been fully executed by the parties prior to the date that this
			document is signed by the claimant, are waived and released by this document, unless listed as an Exception below. This document is
			effective only on the claimant's receipt of payment from the financial institution on which the following check is drawn:
		</p>
		<br>
		<table border="0" cellspacing="0" cellpadding="1" width="100%">
			<tr>
				<td nowrap width="25%">Maker of Check:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $EntityName; ?></td>
			</tr>
			<tr>
				<td nowrap>Amount of Check: $</td>
				<td class="populateLine">&nbsp;&nbsp;<?php //echo $subcontract_actual_value; ?></td>
			</tr>
			<tr>
				<td nowrap>Check Payable to:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $vendor_company_name; ?></td>
			</tr>
		</table>
		<br>
		<p class="textAlignLeft" style="font-weight: bold;">Exceptions:</p>
		<table cellpadding="1" cellspacing="0" border="0" width="100%">
			<tr>
				<td style="padding-left: 20px;">This document does not affect any of the following:</td>
			</tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="1" width="100%">
			<tr>
				<td nowrap width="75%">Disputed claims for extras in the amount of: $</td>
				<td nowrap class="populateLine">&nbsp;</td>
			</tr>
		</table>
		<br><br><br><br>
		<table border="0" cellspacing="0" cellpadding="1" width="100%">
			<tr>
				<td nowrap width="25%">Claimant's Signature:</td>
				<td class="populateLine">&nbsp;</td>
			</tr>
			<tr>
				<td nowrap>Claimant's Title:</td>
				<td class="populateLine">&nbsp;</td>
			</tr>
			<tr>
				<td nowrap>Date of Signature:</td>
				<td class="populateLine">&nbsp;</td>
			</tr>
		</table>
	</center>
</body>
</html>
