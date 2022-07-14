<?php

/*

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
<title><?php echo $project_name; ?> Waivers and Releases - Unconditional Final</title>
<link rel="stylesheet" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
<style>
.populateTable2 {
	width: 95%;
}
.tdLabel {
	width: 22%;
}
.tdSignatureLine {
	width: 50%;
	border-bottom: 1px solid black;
}
</style>
</head>
<body>
	<center>
		<p>
			<div class="waiverTitle">
				UNCONDITIONAL WAIVER AND RELEASE
				<br>
				UPON FINAL PAYMENT
			</div>
			<div class="waiverSubTitle">
				CALIFORNIA CIVIL CODE SECTION 8138
			</div>
		</p>
		<p>
			<div class="waiverWarningBox">
				NOTICE TO CLAIMANT: THIS DOCUMENT WAIVES AND RELEASES LIEN, STOP PAYMENT NOTICE, AND PAYMENT BOND RIGHTS UNCONDITIONALLY AND
				STATES THAT YOU HAVE BEEN PAID FOR GIVING UP THOSE RIGHTS. THIS DOCUMENT IS ENFORCEABLE AGAINST YOU IF YOU SIGN IT, EVEN IF
				YOU HAVE NOT BEEN PAID. IF YOU HAVE NOT BEEN PAID, USE A CONDITIONAL WAIVER AND RELEASE FORM.
			</div>
		</p>
		<br>
		<table border="0" cellspacing="0" cellpadding="1" class="populateTable2">
			<tr>
				<td nowrap width="25%">Name of Claimant:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $vendor_company_name; ?></td>
			</tr>
			<tr>
				<td nowrap width="25%">Name of Customer:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $EntityName; ?></td>
			</tr>
			<tr>
				<td nowrap width="25%">Job Name:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $project_name; ?></td>
			</tr>
			<tr>
				<td nowrap width="25%">Job Location:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $project_address_line_1; ?>, <?php echo $project_address_city; ?>, <?php echo $project_address_state_or_region; ?>, <?php echo $project_address_postal_code; ?></td>
			</tr>
			<tr>
				<td nowrap width="25%">Owner:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $project_owner_name; ?></td>
			</tr>
		</table>
		<br>
		<p style="text-align:justify;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			This document waives and releases lien, stop payment notice, and payment bond rights the claimant has for all labor and service
			provided, and equipment and material delivered, to the customer on this job. Rights based upon labor or service provided, or
			equipment or material delivered, pursuant to a written change order that has been fully executed by the parties prior to the date
			that this document is signed by the claimant, are waived and released by this document, unless listed as an Exception below. The
			claimant has been paid in full.
		</p>
		<br>
		<p class="textAlignLeft" style="font-weight: bold;">Exceptions:</p>
		<table cellpadding="1" cellspacing="0" border="0" style="width: 99%;">
			<tr><td style="padding-left: 20px;">This document does not affect the following:</td></tr>
		</table>
		<table border="0" cellspacing="0" cellpadding="1" class="populateTable2">
			<tr>
				<td width="45%" class="textAlignRight" nowrap>Disputed claims for extras in the amount of: $</td>
				<td class="populateLine" style="width:27%;">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<br><br><br>
		<table border="0" cellspacing="0" cellpadding="1" class="populateTable2">
			<tr>
				<td class="tdLabel" nowrap>Claimant's Signature:</td>
				<td class="tdSignatureLine">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tdLabel" nowrap>Claimant's Title:</td>
				<td class="tdSignatureLine">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="tdLabel" nowrap>Date of Signature:</td>
				<td class="tdSignatureLine">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<table width="99%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td style="text-align: center;" class="waiverTitle">
					<strong>
						<center>**** THIS FORM MUST BE NOTARIZED ****</center>
					</strong>
				</td>
			</tr>
		</table>
	</center>
</body>
</html>
