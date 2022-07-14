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
<title><?php echo $project_name; ?> Waivers and Releases - Unconditional Progress</title>
<link rel="stylesheet" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
</head>

<body>
	<center>
		<p>
			<div class="waiverTitle">
				UNCONDITIONAL WAIVER AND RELEASE
				<br>
				UPON PROGRESS PAYMENT
			</div>
			<div class="waiverSubTitle">
				CALIFORNIA CIVIL CODE SECTION 8134
			</div>
		</p>
		<p>
			<div class="waiverWarningBox">
				NOTICE TO CLAIMANT:  THIS DOCUMENT WAIVES AND RELEASES LIEN, STOP PAYMENT NOTICE, AND PAYMENT BOND RIGHTS UNCONDITIONALLY AND
				STATES THAT YOU HAVE BEEN PAID FOR GIVING UP THOSE RIGHTS. THIS DOCUMENT IS ENFORCEABLE AGAINST YOU IF YOU SIGN IT, EVEN IF
				YOU HAVE NOT BEEN PAID. IF YOU HAVE NOT BEEN PAID, USE A CONDITIONAL WAIVER AND RELEASE FORM.
			</div>
		</p>
		<br>
		<table border="0" cellspacing="0" cellpadding="1" class="populateTable">
			<tr>
				<td class="tdLabelCell">Name of Claimant:</td>
				<td class="tdSignatureLineCell">&nbsp;&nbsp;<?php echo $vendor_company_name; ?></td>
			</tr>
			<tr>
				<td class="tdLabelCell">Name of Customer:</td>
				<td class="tdSignatureLineCell">&nbsp;&nbsp;<?php echo $EntityName; ?></td>
			</tr>
			<tr>
				<td class="tdLabelCell">Job Name:</td>
				<td class="tdSignatureLineCell">&nbsp;&nbsp;<?php echo $project_name; ?></td>
			</tr>
			<tr>
				<td class="tdLabelCell">Job Location:</td>
				<td class="tdSignatureLineCell">&nbsp;&nbsp;<?php echo $project_address_line_1; ?>, <?php echo $project_address_city; ?>, <?php echo $project_address_state_or_region; ?>, <?php echo $project_address_postal_code; ?></td>
			</tr>
			<tr>
				<td class="tdLabelCell">Owner:</td>
				<td class="tdSignatureLineCell">&nbsp;&nbsp;<?php echo $project_owner_name; ?></td>
			</tr>
			<tr>
				<td class="tdLabelCell">Through Date:</td>
				<td class="tdSignatureLineCell">&nbsp;&nbsp;</td>
			</tr>
		</table>
		<br>
		<p style="text-align:justify;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			This document waives and releases lien, stop payment notice, and payment bond rights the claimant has for labor and service provided,
			and equipment and material delivered, to the customer on this job through the Through Date of this document. Rights based upon labor
			or service provided, or equipment or material delivered, pursuant to a written change order that has been fully executed by the
			parties prior to the date that this document is signed by the claimant, are waived and released by this document, unless listed as an
			Exception below. The claimant has received the following progress payment:
		</p>
		<table border="0" cellspacing="0" cellpadding="1" class="populateTable">
			<tr>
				<td nowrap>Amount:</td>
				<td class="populateLine">&nbsp;&nbsp;</td>
			</tr>
		</table>
		<br>
		<p class="textAlignLeft" style="font-weight: bold;">Exceptions:</p>

		<table cellpadding="1" cellspacing="0" border="0" style="margin-left:20px;">
			<tr><td colspan="2">This document does not affect any of the following:</td></tr>
			<tr>
				<td style="padding-left:40px;">(1)</td>
				<td>Retentions.</td>
			</tr>
			<tr>
				<td style="padding-left:40px;">(2)</td>
				<td>Extras for which the claimant has not received payment.</td>
			</tr>
			<tr valign="top">
				<td style="padding-left:40px;">(3)</td>
				<td>
					Contract rights, including (A) a right based on rescission, abandonment, or breach of contract, and (B) the right to recover compensation for work not compensated by the payment.
				</td>
			</tr>
		</table>

		<br><br>
		<table border="0" cellspacing="0" cellpadding="1" class="populateTable">
			<tr>
				<td class="tdLabelCell">Claimant's Signature:</td>
				<td class="tdSignatureLineCell">&nbsp;</td>
			</tr>
			<tr>
				<td class="tdLabelCell">Claimant's Title:</td>
				<td class="tdSignatureLineCell">&nbsp;</td>
			</tr>
			<tr>
				<td class="tdLabelCell">Date of Signature:</td>
				<td class="tdSignatureLineCell">&nbsp;</td>
			</tr>
		</table>
	</center>
</body>
</html>
