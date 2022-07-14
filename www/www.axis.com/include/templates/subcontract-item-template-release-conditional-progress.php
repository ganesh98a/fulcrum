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
<title><?php echo $project_name; ?> Waivers and Releases - Conditional Progress</title>
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
<body>
	<center>
		<p>
			<div class="waiverTitle">
				CONDITIONAL WAIVER AND RELEASE
				<br>
				UPON PROGRESS PAYMENT
			</div>
			<div class="waiverSubTitle">
				CALIFORNIA CIVIL CODE SECTION 8132
			</div>
		</p>
		<p>
			<div class="waiverWarningBox">
				NOTICE:  THIS DOCUMENT WAIVES THE CLAIMANT’S LIEN, STOP PAYMENT NOTICE, AND PAYMENT BOND RIGHTS EFFECTIVE ON RECEIPT OF PAYMENT.
				A PERSON SHOULD NOT RELY ON THIS DOCUMENT UNLESS SATISFIED THAT THE CLAIMANT HAS RECEIVED PAYMENT.
			</div>
		</p>
		<br>
		<table border="0" cellspacing="0" cellpadding="1" class="populateTable">
			<tr>
				<td nowrap>Name of Claimant:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $vendor_company_name; ?></td>
			</tr>
			<tr>
				<td nowrap>Name of Customer:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $general_contractor_company_name; ?></td>
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
			<tr>
				<td nowrap>Through Date:</td>
				<td class="populateLine">&nbsp;&nbsp;</td>
			</tr>
		</table>
		<br>
		<p style="text-align:justify;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			This document waives and releases lien, stop payment notice and payment bond rights the claimant has for labor and service provided,
			and equipment and material delivered, to the customer on this job through the Through Date of this document. Rights based upon labor
			or service provided, or equipment or materials delivered, pursuant to a written change order that has been fully executed by the
			parties prior to the date that this document is signed by the claimant, are waived and released by this document, unless listed as
			an Exception below. This document is effective only on the claimant’s receipt of payment from the financial institution on which the
			following check is drawn:
		</p>
		<br>
		<table border="0" cellspacing="0" cellpadding="1" class="populateTable">
			<tr>
				<td nowrap>Maker of Check:</td>
				<td class="populateLine">&nbsp;&nbsp;<?php echo $general_contractor_company_name; ?></td>
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

		<table cellpadding="1" cellspacing="0" border="0" style="margin-left:20px;">
			<tr><td colspan="3">This document does not affect any of the following:</td></tr>
			<tr>
				<td>(1)</td>
				<td colspan="2">Retentions.</td>
			</tr>
			<tr>
				<td>(2)</td>
				<td colspan="2">Extras for which the claimant has not received payment.</td>
			</tr>
			<tr valign="top">
				<td>(3)</td>
				<td colspan="2">
					The following progress payments for which the claimant has previously given a conditional waiver and release but has not received payment:
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;Date(s) of waiver and release:</td>
				<td class="populateLine">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;Amount(s) of unpaid progress payment(s): $</td>
				<td class="populateLine">&nbsp;</td>
			</tr>
			<tr valign="top">
				<td>(4)</td>
				<td colspan="2">
					Contract rights, including (A) a right based on rescission, abandonment, or breach of contract, and (B) the right to recover compensation for work not compensated by the payment.
				</td>
			</tr>
		</table>

		<br><br>
		<table border="0" cellspacing="0" cellpadding="1" class="populateTable">
			<tr>
				<td nowrap>Claimant’s Signature:</td>
				<td class="populateLine">&nbsp;</td>
			</tr>
			<tr>
				<td nowrap>Claimant’s Title:</td>
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
