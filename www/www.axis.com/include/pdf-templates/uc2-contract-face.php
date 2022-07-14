<?php

$projectName = '<span style="font-weight: bold; font-style: italic;">PROJECT NAME</span>';
$projectAddress1 = '<span style="font-weight: bold; font-style: italic;">ADDRESS 1</span>';
$projectAddress2 = '<span style="font-weight: bold; font-style: italic;">ADDRESS 2</span>';
$contractDate = '<span style="font-weight: bold; font-style: italic;">CONTRACT DATE</span>';
$userCompanyName = '<span style="font-weight: bold; font-style: italic;">COMPANY NAME</span>';
$userCompanyAddress1 = '<span style="font-weight: bold; font-style: italic;">ADDRESS 1</span>';
$userCompanyAddress2 = '<span style="font-weight: bold; font-style: italic;">ADDRESS 2</span>';
$userCompanyPhone1 = '<span style="font-weight: bold; font-style: italic;">PHONE NUMBERS</span>';
$userCompanyLicense = '<span style="font-weight: bold; font-style: italic;">COMPANY LICENSE</span>';
$contractCompanyName = '<span style="font-weight: bold; font-style: italic;">COMPANY NAME</span>';
$contractCompanyAddress1 = '<span style="font-weight: bold; font-style: italic;">ADDRESS 1</span>';
$contractCompanyAddress2 = '<span style="font-weight: bold; font-style: italic;">ADDRESS 2</span>';
$contractCompanyPhone1 = '<span style="font-weight: bold; font-style: italic;">PHONE NUMBERS</span>';
$contractCompanyLicense = '<span style="font-weight: bold; font-style: italic;">COMPANY LICENSE</span>';
$costCode = '<span style="font-weight: bold; font-style: italic;">COST CODE</span>';
$lineItem = '<span style="font-weight: bold; font-style: italic;">LINE ITEM</span>';
$contractAmount = '<span style="font-weight: bold; font-style: italic;">CONTRACT AMOUNT</span>';

if (isset($get->projectName) && !empty($get->projectName)) {

}

?>

<html>
<head>
	<title><?php echo $projectName; ?> Contract Face</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
			line-height: 13pt;
		}

		p {
			line-height: 13pt;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
		<tr><th class="borderTopBlack borderBottomBlack" style="padding: 3px;">SUBCONTRACT AGREEMENT</th></tr>
		<tr>
			<td>
				This Subcontract is made as of <?php echo $contractDate; ?> by
				and between Contractor and Subcontractor named below and is as follows:
			</td>
		</tr>
		<tr>
			<th class="textAlignLeft">I. DEFINITIONS</th>
		</tr>
	</table>

	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">

		<!-- CONTRACTOR INFORMATION -->
		<tr valign="top">
			<th class="textAlignLeft" style="padding-left: 20px; line-height: 12pt; padding-right: 10px;">Contractor:</th>
			<td style="line-height: 12pt;" nowrap>
				<?php echo strtoupper($userCompanyName); ?><br>
				<?php echo $userCompanyAddress1; ?><br>
				<?php echo $userCompanyAddress2; ?><br>
				<?php echo $userCompanyPhone1; ?>
			</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>

		<!-- SUBCONTRACTOR INFORMATION -->
		<tr valign="top">
			<th class="textAlignLeft" style="padding-left: 20px; line-height: 12pt; padding-right: 10px;">Subcontractor:</th>
			<td style="line-height: 12pt;" nowrap>
				<?php echo strtoupper($contractCompanyName); ?><br>
				<?php echo $contractCompanyAddress1; ?><br>
				<?php echo $contractCompanyAddress2; ?><br>
				<?php echo $contractCompanyPhone1; ?>
			</td>
			<td width="15%">&nbsp;</td>
			<td style="line-height: 12pt;" nowrap>
				<strong>Subcontractor Point of Contact</strong><br>
				Name: _________________________________________<br>
				Phone: ________________  Mobile: __________________<br>
				Email: _________________________________________
			</td>
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>

		<!-- PROJECT INFORMATION -->
		<tr valign="top">
			<th class="textAlignLeft" style="padding-left: 20px; line-height: 12pt; padding-right: 10px;">Project:</th>
			<td style="line-height: 12pt;" nowrap>
				<?php echo strtoupper($projectName); ?><br>
				<?php echo $projectAddress1; ?><br>
				<?php echo $projectAddress2; ?>
			</td>
			<td width="15%">&nbsp;</td>
			<td style="line-height: 12pt;" nowrap>
				<strong>Subcontractor 24 Hour Emergency Contact</strong><br>
				Name: _________________________________________<br>
				Phone: _________________  Mobile: _________________<br>
				Email: _________________________________________
			</td>
		</tr>

		<!-- CONTRACT DOCUMENT INFO -->
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
			<th class="textAlignLeft" style="padding-left: 20px; line-height: 12pt; padding-right: 10px;">Work:</th>
			<td colspan="3" style="line-height: 12pt;">
				Means all work necessary to complete the project described in the Contract Documents
				and all of the Exhibits listed in the Contract Documents for the trade of
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" style="font-size: 16px; padding-left:55px;">
				<?php echo $costCode; ?> <?php echo $lineItem; ?>
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
	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;-size:12px;">
		<tr valign="middle">
			<th class="textAlignLeft" style="line-height: 16pt;" nowrap>II. SUBCONTRACT PRICE</th>
			<td style="font-size: 16px; padding-left: 15px;" width="95%">$<?php echo $contractAmount; ?></td>
		</tr>
	</table>
	<br>
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

	<table width="100%" border="0" cellspacing="10" cellpadding="0" style="font-size: 13px; margin-top:10px;">
		<tr>
			<th class="textAlignLeft">Contractor:</th>
			<td class="borderBottomBlack" style="padding-left: 10px;" width="35%"><?php echo strtoupper($userCompanyName); ?></td>
			<td style="width: 15px;">&nbsp;</td>
			<th class="textAlignLeft" style="margin-left: 10px;">Subcontractor:</th>
			<td class="borderBottomBlack" style="padding-left: 10px;" width="35%"><?php echo strtoupper($contractCompanyName); ?></td>
		</tr>
		<tr>
			<th class="textAlignLeft">Signed:</th>
			<td class="borderBottomBlack" style="position:relative;">
				&nbsp;
				<div style="position:absolute; border:1px solid red; top:-15px; margin-left: 10px;">
					<img style="height:40px;" src="data:image/png;base64,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">
				</div>
			</td>
			<td style="width: 15px;">&nbsp;</td>
			<th class="textAlignLeft" style="margin-left: 10px;">Signed:</th>
			<td class="borderBottomBlack">&nbsp;</td>
		</tr>
		<tr>
			<th class="textAlignLeft">Dated:</th>
			<td class="borderBottomBlack">&nbsp;</td>
			<td style="width: 15px;">&nbsp;</td>
			<th class="textAlignLeft" style="margin-left: 10px;">Dated:</th>
			<td class="borderBottomBlack">&nbsp;</td>
		</tr>
		<tr>
			<th class="textAlignLeft">Title:</th>
			<td class="borderBottomBlack">&nbsp;</td>
			<td style="width: 15px;">&nbsp;</td>
			<th class="textAlignLeft" style="margin-left: 10px;">Title:</th>
			<td class="borderBottomBlack">&nbsp;</td>
		</tr>
		<tr>
			<th class="textAlignLeft">License:</th>
			<td class="borderBottomBlack" style="padding-left: 10px;"><?php echo $userCompanyLicense; ?></td>
			<td style="width: 15px;">&nbsp;</td>
			<th class="textAlignLeft" style="margin-left: 10px;">License:</th>
			<td class="borderBottomBlack" style="padding-left: 10px;"><?php echo $contractCompanyLicense; ?></td>
		</tr>
	</table>
</body>
</html>