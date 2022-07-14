<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Untitled Document</title>
	<link href="<?php echo $uri->http; ?>css/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $uri->http; ?>css/modules-change-orders-pdf.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php echo $headerLogo; ?>
<?php echo $footerData; ?>	

<br>
<div style="font-family:Times New Roman;font-size:14px;background-color: #dfdfdf;">
	<span style="font-style: italic;font-weight: bold;">Change Order</span>
</div>

<div style="font-family:Times New Roman;">
	<table width="100%">
		<tr>
			<td width="40%">
				<b class="f12">Project : </b>
			</td>
			<td width="15%" align="right">
				<b class="f12">Change Order : </b>
			</td>
			<td width="45%">
				<span class="f12"><?php echo $sequence_data; ?></span>
			</td>
		</tr>
		<tr>
			<td width="40%">
				<span class="f12" style="margin-left:50px;"><?php echo $escaped_project_name; ?></span>
			</td>
			<td width="15%" align="right">
				<b class="f12">Date : </b>
			</td>
			<td width="45%">
				<span class="f12"><?php echo $co_created_date; ?></span>
			</td>
		</tr>
		<tr>
			<td width="40%">
				<span class="f12" style="margin-left:50px;"><?php echo $projectAddress['address']; ?></span>
			</td>
			<td width="15%" align="right">
				<span class="f12"><b>Contract Date : </b></span>
			</td>
			<td width="45%">
				<span class="f12"><?php echo $proj_contract_date; ?></span>
			</td>
		</tr>
		<tr>
			<td width="40%">
				<span class="f12" style="margin-left:50px;"><?php echo $projectAddress['address1']; ?></span>
			</td>
			<td width="15%" align="right"></td>
			<td width="45%"></td>
		</tr>
		<tr>
			<td width="40%">
				<b class="f12">Owner : </b>
			</td>
			<td width="15%" class="f12" align="right"><b>Contractor : </b></td>
			<td width="45%"></td>
		</tr>
		<tr>
			<td width="40%">
				<span class="f12" style="margin-left:50px;"><?php echo $ownerName; ?></span>
			</td>
			<td width="15%" align="right"></td>
			<td width="45%">
				<span class="f12"><?php echo $fromFullName; ?></span>
			</td>
		</tr>
		<tr>
			<td width="40%">
				<span class="f12" style="margin-left:50px;"><?php echo $ownerAddress['address']; ?></span>
			</td>
			<td width="15%" align="right"></td>
			<td width="45%">
				<span class="f12"><?php echo $fromAddress['address']; ?></span>
			</td>
		</tr>
		<tr>
			<td width="40%">
				<span class="f12" style="margin-left:50px;"><?php echo $ownerAddress['address1']; ?></span>
			</td>
			<td width="15%" align="right"></td>
			<td width="45%">
				<span class="f12"><?php echo $fromAddress['address1']; ?></span>
			</td>
		</tr>
	</table>
</div>

<br>
<br>

<div style="font-family:Times New Roman;background-color: #dfdfdf;">
	<span class="f12" style="font-weight: bold;background-color: #dfdfdf;">The Contract is changed as follows:</span>
</div>

<div style="font-family:Times New Roman;">
	<span class="f12"><?php echo $escaped_co_statement; ?></span>
	<br>
	<table width="100%" cellpadding="3">
		<?php foreach ($breakDown as $key => $value) { ?>
			<tr>
				<td width="80%">
					<span class="f12" style="margin-left:50px;"><?php echo $value['costcode']; ?></span>
				</td>
				<td width="20%" align="right">
					<span class="f12"><?php echo $value['cost']; ?></span>
				</td>
			</tr>
		<?php } ?>
		<tr>
			<td width="80%" align="right">
				<span class="f12">Total : </span>
			</td>
			<td width="20%" align="right" style="border-top: 1px solid #000000;">
				<span class="f12"><?php echo $co_total; ?></span>
			</td>
		</tr>
	</table>
</div>

<br>
<hr>

<div style="font-family:Times New Roman;">
	<table cellpadding="3" width="100%">
		<tr>
			<td class="f12">The original Contract Amount was</td>
			<td class="f12" style="text-align:right;"><?php echo $totOriPSCVFormatted; ?></td>
		</tr>
		<tr>
			<td class="f12">Net change by previously authorized Change Orders</td>
			<td class="f12" style="text-align:right;"><?php echo $approvedCORTotalAmtFormatted; ?></td>
		</tr>
		<tr>
			<td class="f12">The Contract Amount prior to this Change Order was</td>
			<td class="f12" style="text-align:right;"><?php echo $contractPriorToCCFormatted; ?></td>
		</tr>
		<tr>
			<td class="f12">The Contract will be increased by this Change Order in the amount of</td>
			<td class="f12" style="text-align:right;"><?php echo $coAmt; ?></td>
		</tr>
		<tr>
			<td class="f12">The new Contract Amount including this Change Order will be</td>
			<td class="f12" style="text-align:right;"><?php echo $newContractAmtFormatted; ?></td>
		</tr>
	</table>

	<br>

	<span class="marLRFive f12" style="font-family:Times New Roman;">The date of Substantial Completion as of the date of this Change Order therefore is</sapn>
	
	<br>
	<br>
	<b class="marLRFive caps f12">NOT VALID UNTIL SIGNED BY THE ARCHITECT , CONTRACT AND OWNER.</b>
	<hr>
</div>
	
<div style="font-family:Times New Roman;">
	<table width="100%">
		<tr>
			<td width="30%" ><span class="marLRFive f12"><?php echo $architechName; ?></span></td>
			<td width="30%"><span class="marLRFive f12"><?php echo $fromFullName; ?></span></td>
			<td width="30%"><span class="marLRFive f12"><?php echo $ownerName; ?></span></td>
		</tr>
		<tr>
			<td width="30%" ><span class="marLRFive f12"><?php echo $architectCompany; ?></span></td>
			<td width="30%"><span class="marLRFive f12"><?php echo $fromCompany; ?></span></td>
			<td width="30%"><span class="marLRFive f12"><?php echo $ownerCompany; ?></span></td>
		</tr>
		<tr>
			<td width="30%"><span class="marLRFive f12">ARCHITECT</span></td>
			<td width="30%"><span class="marLRFive f12">CONTRACTOR</span></td>
			<td width="30%"><span class="marLRFive f12">OWNER</span></td>
		</tr>
		<tr>
			<td width="30%" ><span class="marLRFive f12"><?php echo $architectAddress['address']; ?></span></td>
			<td width="30%" ><span class="marLRFive f12"><?php echo $fromAddress['address']; ?></span></td>
			<td width="30%" ><span class="marLRFive f12"><?php echo $ownerAddress['address']; ?></span></td>
		</tr>
		<tr>
			<td width="30%" ><span class="marLRFive f12"><?php echo $architectAddress['address1']; ?></span></td>
			<td width="30%" ><span class="marLRFive f12"><?php echo $fromAddress['address1']; ?></span></td>
			<td width="30%" ><span class="marLRFive f12"><?php echo $ownerAddress['address1']; ?></span></td>
		</tr>
		<tr>
			<td><br><br><hr class="marLRFive"><span class="marLRFive f12">(Signature)</span></td>
			<td><br><br><hr class="marLRFive"><span class="marLRFive f12">(Signature)</span></td>
			<td><br><br><hr class="marLRFive"><span class="marLRFive f12">(Signature)</span></td>
		</tr>
		<tr>
			<td><br><hr class="marLRFive"><span class="marLRFive f12">By</span></td>
			<td><br><hr class="marLRFive"><span class="marLRFive f12">By</span></td>
			<td><br><hr class="marLRFive"><span class="marLRFive f12">By</span></td>
		</tr>
		<tr>
			<td><hr class="marLRFive"><span class="marLRFive f12">Date</span></td>
			<td><hr class="marLRFive"><span class="marLRFive f12">Date</span></td>
			<td><hr class="marLRFive"><span class="marLRFive f12">Date</span></td>
		</tr>
	</table>
</div>
		
