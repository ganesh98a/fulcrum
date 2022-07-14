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
<div style="font-family:Times New Roman;font-size:12px;">
	&nbsp;
	<table width="100%">
		<tr>
			<td width="50%">
				<b class="caps" style="font-size:14px;"><?php echo $change_order_type.' - '.$sequence_data; ?></b>
				<br>
				<span style="font-size:12px;">Construction Contract Between Owner and Contractor</span>
			</td>
			<td width="50%" valign="top" align="right">
				<b class="caps" style="font-size:14px;"><?php echo $escaped_project_name; ?></b>
				<br>
				<span style="font-size:12px;"><?php echo $curdate; ?></span>
			</td>
		</tr>
	</table>

	<br>

	<table width="100%" style="">
		<tr>
			<td width="50%" style="text-transform:uppercase;font-size:12px;">
				<b>To : </b>
			</td>
			<td width="50%" style="text-transform:uppercase;font-size:12px;">
				<b>From : </b>
			</td>
		</tr>
		<tr>
			<td width="50%">
				<span style="font-size:12px;"><?php echo $coRecipientContactFullNameHtmlEscaped.','; ?></span>
				<br>
			</td>
			<td width="50%">
				<span style="font-size:12px;"><?php echo $coCreatorContactFullNameHtmlEscaped.','; ?></span>
				<br>
			</td>
		</tr>
		<tr>
			<td width="50%">
				<span style="text-transform:uppercase;font-size:12px;"><?php echo $coRecipientContactCompanyNameHtmlEscaped; ?></span>
			</td>
			<td width="50%">
				<span style="text-transform:uppercase;font-size:12px;"><?php echo $entityName; ?></span>
			</td>
		</tr>
		<tr>
			<td width="50%">
				<span style="font-size:12px;"><?php echo $coRecipientContactCompanyOfficeAddressHtmlEscaped; ?></span>
			</td>
			<td width="50%">
				<span style="font-size:12px;"><?php echo $coCreatorContactCompanyOfficeAddressHtmlEscaped; ?></span>
			</td>
		</tr>
	</table>

	<br>

	<p>We are hereby submitting this <?php echo $change_order_type; ?> (<?php echo $sequence_data; ?>) for the amount of <b><?php echo $coAmt; ?></b> for your approval. Attached to this cover sheet is the backup for this Change Order Request. Please review the backup and sign below for approval</p>

	<div style="margin: 15px 0;">
		<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr>
				<td align="Left" nowrap style="font-weight: bold;font-size:12px; text-transform: uppercase;" width="30%"><?php echo $coRecipientContactCompanyNameHtmlEscaped; ?></td>
				<td align="Left" nowrap style="font-weight: bold;font-size:12px; text-transform: uppercase;" width="30%"><?php echo $entityName; ?></td>
				<td align="Left" nowrap style="font-weight: bold;font-size:12px; text-transform: uppercase;" width="30%"><?php echo $architechName; ?></td>
			</tr>
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td nowrap width="20%" style="font-size:12px;">Signature:</td>
							<td style="border-bottom: 1px solid black;font-size:12px;" width="75%">&nbsp;</td>
							<td width="5%">&nbsp;</td>
						</tr>
						<tr>
							<td nowrap style="font-size:12px;">Name:</td>
							<td style="border-bottom: 1px solid black;font-size:12px;" width="75%"><?php echo $coRecipientContactFullNameHtmlEscaped; ?></td>
							<td width="5%">&nbsp;</td>
						</tr>
						<tr>
							<td nowrap style="font-size:12px;">Title:</td>
							<td style="border-bottom: 1px solid black;font-size:12px;" width="75%"><?php echo $co_rep_title; ?></td>
							<td width="5%">&nbsp;</td>
						</tr>
						<tr>
							<td nowrap style="font-size:12px;">Date:</td>
							<td style="border-bottom: 1px solid black;font-size:12px;" width="75%">&nbsp;</td>
							<td width="5%">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td nowrap style="font-size:12px;" width="20%">Signature:</td>
						<td style="border-bottom: 1px solid black;font-size:12px;" width="75%">&nbsp;</td>
						<td width="5%">&nbsp;</td>
					</tr>
					<tr>
						<td nowrap style="font-size:12px;">Name:</td>
						<td style="border-bottom: 1px solid black;font-size:12px;" width="75%"><?php echo $coCreatorContactFullNameHtmlEscaped; ?></td>
						<td width="5%">&nbsp;</td>
					</tr>
					<tr>
						<td nowrap style="font-size:12px;">Title:</td>
						<td style="border-bottom: 1px solid black;font-size:12px;" width="75%"><?php echo $co_create_title; ?></td>
						<td width="5%">&nbsp;</td>
					</tr>
					<tr>
						<td nowrap style="font-size:12px;">Date:</td>
						<td style="border-bottom: 1px solid black;font-size:12px;" width="75%"><?php echo $curdate; ?></td>
						<td width="5%">&nbsp;</td>
					</tr>
					</table>
				</td>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td nowrap style="font-size:12px;" width="20%">Signature:</td>
						<td style="border-bottom: 1px solid black;font-size:12px;" width="75%">&nbsp;</td>
						<td width="5%">&nbsp;</td>
					</tr>
					<tr>
						<td nowrap style="font-size:12px;">Name:</td>
						<td style="border-bottom: 1px solid black;font-size:12px;" width="75%">&nbsp;</td>
						<td width="5%">&nbsp;</td>
					</tr>
					<tr>
						<td nowrap style="font-size:12px;">Title:</td>
						<td style="border-bottom: 1px solid black;font-size:12px;" width="75%">&nbsp;</td>
						<td width="5%">&nbsp;</td>
					</tr>
					<tr>
						<td nowrap style="font-size:12px;">Date:</td>
						<td style="border-bottom: 1px solid black;font-size:12px;" width="75%">&nbsp;</td>
						<td width="5%">&nbsp;</td>
					</tr>
					</table>
				</td>
			</tr>
		</table>

		<br>
		<hr>

		<table border="0" cellspacing="0" cellpadding="5" width="100%">
			<tr>
				<td width="50%">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td width="35%" class="font-12-pad-10"><b>Name</b></td>
							<td width="5%" class="font-12-pad-10">:</td>
							<td width="60%" class="font-12-pad-10"><?php echo $escaped_co_title; ?></td>	
						</tr>
						<tr>
							<td width="35%" class="font-12-pad-10"><b>Amount</b></td>
							<td width="5%" class="font-12-pad-10">:</td>
							<td width="60%" class="font-12-pad-10"><?php echo $co_total; ?></td>
						</tr>
						<tr>
							<td width="35%" class="font-12-pad-10"><b>Reason</b></td>
							<td width="5%" class="font-12-pad-10">:</td>
							<td width="60%" class="font-12-pad-10"><?php echo $change_order_priority; ?></td>
						</tr>
						<tr>
							<td width="35%" class="font-12-pad-10"><b>Schedule Impact</b></td>
							<td width="5%" class="font-12-pad-10">:</td>
							<td width="60%" class="font-12-pad-10"><?php echo $delayDays; ?></td>
						</tr>
					</table>
				</td>
				<td width="50%">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>		
							<td width="35%" class="font-12-pad-10"><b>COR</b></td>
							<td width="5%" class="font-12-pad-10">:</td>
							<td width="60%" class="font-12-pad-10"><?php echo $sequence_data; ?></td>
						</tr>
						<tr>		
							<td width="35%" class="font-12-pad-10"><b>Created</b></td>
							<td width="5%" class="font-12-pad-10">:</td>
							<td width="60%" class="font-12-pad-10"><?php echo $co_created_date; ?></td>
						</tr>
						<tr>		
							<td width="35%" class="font-12-pad-10"><b>Status</b></td>
							<td width="5%" class="font-12-pad-10">:</td>
							<td width="60%" class="font-12-pad-10"><?php echo $change_order_status; ?></td>
						</tr>
						<tr>	
							<td width="35%" class="font-12-pad-10"><b>Ref. Docs</b></td>
							<td width="5%" class="font-12-pad-10">:</td>
							<td width="60%" class="font-12-pad-10"><?php echo $ref_doc; ?></td>
						</tr>
					</table>
				</td>
			</tr>		
		</table>
		
		<br>
		<?php echo $descData; ?>		

		<div class="headsty">
			<b>COST ANALYSIS:</b>
		</div>

		<br>

		<table id="changeOrderTable" width="100%" border="1">
			<tr>
				<td align="center" style="font-size:12px;"><b>#</b></td>
				<td align="center" style="font-size:12px;width: 25%;"><b>CostCode</b></td>
				<td align="center" style="font-size:12px;"><b>Description</b></td>
				<td align="center" style="font-size:12px;"><b>Sub.</b></td>
				<td align="center" style="font-size:12px;"><b>Ref.</b></td>
				<td align="center" style="font-size:12px;"><b>Amount $</b></td>
			</tr>
			<?php echo $costbreakitems; ?>
			<tr>
				<td colspan='5' align="right" style="font-size:12px;padding:3px;"><b>Subtotal:</b> </td>
				<td align="right" style="font-size:12px;padding:3px;"><?php echo $co_subtotal; ?></td>
			</tr>
			<?php echo $cost_item; ?>
			<tr>
				<td colspan='5' align="right" style="font-size:12px;padding:3px;"><b>Total:</b> </td>
				<td align="right" style="font-size:12px;padding:3px;"><?php echo $co_total; ?></td>
			</tr>
		</table>
	</div>
</div>
