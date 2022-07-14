<?php

/*

<cfparam name="amount" default="">
<cfparam name="through" default="">
<cfparam name="company" default="">
<cfparam name="customer" default="">
<cfparam name="owner" default="">
<cfparam name="project_id" default="">
<cfparam name="projectID" default="">

*/

if (!isset($project_customer_name)) {
	$project_customer_name = '';
}

if (!isset($project_owner_name)) {
	$project_owner_name = '';
}

if (!isset($through_date)) {
	$through_date = '';
}

?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta http-equiv="imagetoolbar" content="false">
<title><?php echo $project_name; ?> Waivers and Releases - Payment Application Affidavit</title>
<link rel="stylesheet" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
</head>
<body>

	<center>
		<p>
			<div class="waiverTitle">
				PROGRESS PAYMENT AFFIDAVIT
				<br>
				SUBMITTED WITH PAYMENT APPLICATION
			</div>
		</p>
		<br>
		<br>
		<table width="99%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="textAlignJustify">
					1.  The undersigned hereby represents and certifies that it has previously received payment in
					cumulative amounts satisfying all previously-submitted invoices and payment applications for labor,
					services, equipment, or material furnished to &nbsp;
<?php
					//<cfif #Len(customer)# EQ 0>
if (empty($project_customer_name)) {
?>
						<br>
						__________________________________ on the job of
<?php
						//<cfif #Len(owner)# GT 0>
	if (empty($project_owner_name)) {
?>
							<u>&nbsp;<?php echo $project_owner_name; ?>&nbsp;</u>&nbsp;located at <br>(Your Customer)
<?php
	}
						//</cfif>
					//<cfelse>
} else {
?>
						<u>&nbsp;#customer#&nbsp;</u>&nbsp;on the job of
<?php
						//<cfif #Len(owner)# GT 0>
	if (!empty($project_owner_name)) {
?>
							<u>&nbsp;<?php echo $project_owner_name; ?>&nbsp;</u>&nbsp;located at
<?php
	}
						//</cfif>
}
					//</cfif>
					//<cfif #Len(owner)# EQ 0>
if (!empty($project_owner_name)) {
?>
						<br>
						________________________________ located at <br>
						(Owner)
<?php
}
					//</cfif>
?>
					<br><br>
					<?php echo $project_name; ?><br>
					<?php echo $project_address_line_1; ?><br>
					<?php echo $project_address_city; ?>, <?php echo $project_address_state_or_region; ?>, <?php echo $project_address_postal_code; ?>
					<br><br>
<?php
					//<cfif #Len(through)# EQ 0>
if (empty($through_date)) {
?>
						through _______________________<br>
						<span style="padding-left:125px;">(Date)</span>
<?php
					//<cfelse>
} else {
?>
						through <u>&nbsp;<?php echo $through_date; ?>&nbsp;</u>
<?php
}
					//</cfif>
?>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td colspan="3">
					2.  The undersigned hereby represents and certifies that to its knowledge there are no claims for
					additional compensation or damages of any kind, (such as extras, changes, disputes, delays, or
					defects), by the undersigned or its sub-subcontractors or suppliers except and only for the claims
					and amounts identified as follows:
								</td>
							</tr>
							<tr>
								<td width="34%" nowrap>
					Retention withheld in the amount of $
								</td>
								<td class="tdDollarCell">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
						</table>
				</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td colspan="3">
					3.  Please list below all sub-subcontractors and suppliers, each subcontract amount, and the amount
					of this payment application to be paid to each. (Attach additional pages if necessary.)
								</td>
							</tr>

							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" class="populateLine">&nbsp;</td>
							</tr>
						</table>

					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
				4.	The undersigned hereby acknowledges that <?php echo $general_contractor_company_name; ?> is relying upon the representations in this
					Affidavit in releasing funds to you or your customer, that failure to detail all claims in paragraph
					2 above may cause <?php echo $general_contractor_company_name; ?> to release money that should have been withheld to pay such claims, and
					that any misrepresentations about the existence or non-existence of such claims may cause <?php echo $general_contractor_company_name; ?>
					damages.

<?php
/*
					<cfif #projectID# EQ "13LY01" OR #project_id# EQ "13LY01">
*/
?>

							</td>
						</tr>
					</table>
<?php
/*
					<cfelse>
					<br><br>
					3.	The undersigned hereby acknowledges that <?php echo $general_contractor_company_name; ?> is relying upon the representations in this
					Affidavit in releasing funds to you or your customer, that failure to detail all claims in paragraph
					2 above may cause <?php echo $general_contractor_company_name; ?> to release money that should have been withheld to pay such claims, and
					that any misrepresentations about the existence or non-existence of such claims may cause <?php echo $general_contractor_company_name; ?>
					damages.
					</cfif>
*/
?>
				</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<table width="99%" border="0" cellpadding="0" cellspacing="0">
			<tr valign="bottom">
		    	<td width="30%">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr><td class="borderBottomBlack">&nbsp;</td></tr>
						<tr><td class="sigBlock" rowspan="4" valign="top">Dated:</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
					</table>
				</td>
				<td width="5%">&nbsp;</td>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr><td class="borderBottomBlack"><?php echo $vendor_company_name; ?>&nbsp;</td></tr>
						<tr><td class="sigBlock">Company Name:</td></tr>

						<tr><td class="borderBottomBlack">&nbsp;</td></tr>
						<tr><td class="sigBlock">Signature:</td></tr>

						<tr><td class="borderBottomBlack">&nbsp;</td></tr>
						<tr><td class="sigBlock">Title:</td></tr>
					</table>
				</td>
			</tr>
		</table>
	</center>

</body>
</html>
