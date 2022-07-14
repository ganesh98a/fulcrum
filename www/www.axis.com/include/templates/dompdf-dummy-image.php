<?php

/*

*/

if (!isset($sendSubcontractMethod)) {
	$sendSubcontractMethod = 'Download';
}

$currentDate = date("m/d/Y");

// Debug
require_once('templates/subcontract-item-template-dummy-data.php');

/*
<link rel="stylesheet" href="<?php echo $uri->http; ?>css/pdf-us-letter.css">
<link rel="stylesheet" type="text/css" href="<?php echo $uri->http; ?>css/transmittal-forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
*/

// Vendor Address
// Normalize variables
if (!isset($vendor_address_city) || empty($vendor_address_city)) {
	$vendor_address_city = '';
}
if (!isset($vendor_address_state_or_region) || empty($vendor_address_state_or_region)) {
	$vendor_address_state_or_region = '';
}
if (!isset($vendor_address_postal_code) || empty($vendor_address_postal_code)) {
	$vendor_address_postal_code = '';
}

$vendorDisplayedAddressCityStateZip = '';
if (!empty($vendor_address_city)) {
	$vendorDisplayedAddressCityStateZip .= $vendor_address_city;
}
if (!empty($vendor_address_state_or_region)) {
	$vendorDisplayedAddressCityStateZip .= ", $vendor_address_state_or_region";
}
if (!empty($vendor_address_postal_code)) {
	$vendorDisplayedAddressCityStateZip .= " $vendor_address_postal_code";
}
$vendorDisplayedAddressCityStateZip = trim($vendorDisplayedAddressCityStateZip, ',');
$vendorDisplayedAddressCityStateZip = Data::singleSpace($vendorDisplayedAddressCityStateZip);

?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta http-equiv="imagetoolbar" content="false">
<title>CONTRACT CREATION TRANSMITTAL</title>
<link rel="stylesheet" href="<?php echo $uri->http; ?>css/transmittal-forms.css">
<link rel="stylesheet" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
</head>
<body style="margin: 30px; padding: 0px;">
<div id="container">
	<div align="center"><img src="<?php echo $uri->http; ?>cms-gc-images/advent-header.gif" style="width:570px; height:60px;"></div>
	<br>

	<div class="textAlignCenter" style="border-top: 2px solid black; border-bottom: 2px solid black; width:100%;">
		<p><span class="title"><?php echo $project_name; ?></span></p>
	</div>

	<table border="0" cellpadding="3" cellspacing="0" width="100%">
		<tr valign="top">
			<td class="verticalAlignTop" style="height: 40px;" width="20%">
				<b>COMPANY:</b>
			</td>
			<td class="verticalAlignTop" width="30%">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><?php echo $vendor_company_name; ?></td>
					</tr>

					<tr>
						<td><?php echo $vendor_address_line_1; ?> <?php echo $vendor_address_line_2; ?></td>
					</tr>

					<tr>
						<td><?php echo $vendorDisplayedAddressCityStateZip; ?></td>
					</tr>
				</table>
			</td>
			<td class="verticalAlignTop borderLeftBlack" style="height: 40px;" width="20%">
				<b>FROM:</b>
			</td>
			<td class="verticalAlignTop" width="30%">
				<?php echo $customer_contact_name; ?>
				<?php
				if (isset($customer_contact_phone_number) && !empty($customer_contact_phone_number)) {
				?>
				<br><?php echo $customer_contact_phone_number; ?>
				<?php
				}
				?>
				<?php
				if (isset($customer_contact_fax_number) && !empty($customer_contact_fax_number)) {
				?>
				&nbsp;&nbsp;&nbsp;Fx:&nbsp;<?php echo $customer_contact_fax_number; ?><br><br>
				<?php
				}
				?>
			</td>
		</tr>

		<tr valign="top">
			<td class="verticalAlignTop borderTopBlack" style="height: 40px;" width="20%">
				<b>TO:</b>
			</td>
			<td class="verticalAlignTop borderTopBlack" style="height: 40px;" width="30%">
				<?php echo $vendor_contact_name; ?><br><?php echo $vendor_mobile_phone_number; ?>
			</td>
			<td class="verticalAlignTop borderTopBlack borderLeftBlack" style="height: 40px;" width="20%">
				<b>DATE:</b>
			</td>
			<td class="verticalAlignTop borderTopBlack" style="height: 40px;" width="30%">
				<?php echo $currentDate; ?>
			</td>
		</tr>

		<tr valign="top">
			<td class="verticalAlignTop borderTopBlack borderBottomBlack" style="height: 40px;" width="20%">
				<b>SENT VIA:</b>
			</td>
			<td class="verticalAlignTop borderTopBlack borderBottomBlack" style="height: 40px;" width="30%">
				<?php echo $sendSubcontractMethod; ?>
			</td>
			<td class="verticalAlignTop borderTopBlack borderBottomBlack borderLeftBlack" style="height: 40px;" width="20%">
				<b>PAGES:</b>
			</td>
			<td class="verticalAlignTop borderTopBlack borderBottomBlack" style="height: 40px;" width="30%">
				<?php echo $page_count + 1; ?> (Including Cover)
			</td>
		</tr>
	</table>

	<br>

	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td colspan="2">This letter serves as official notification that <?php echo $vendor_company_name; ?> has been awarded the attached contract for the following project:</td>
		</tr>

		<tr><td colspan="2">&nbsp;</td></tr>

		<tr>
			<td style="padding-left: 30px;" nowrap>Project Name:</td>
			<td style=" width: 80%;"><u> <?php echo $project_name; ?> </u></td>
		</tr>

		<tr>
			<td style="padding-left: 30px;">Located At: </td>
			<td><u><?php echo $project_address_line_1; ?>, <?php echo $project_address_city; ?>, <?php echo $project_address_state_or_region; ?> <?php echo $project_address_postal_code; ?></u></td>
		</tr>

		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>

		<tr>
			<td colspan="2">
			Please confirm your acceptance of this contract offer by executing the Subcontract Agreement,
			initialing the pages of the Subcontract Terms and Conditions and Exhibits where indicated,
			completing the blanks in the forms provided, and providing the other required documentation.
			The Subcontract Agreement will not be effective, no labor or materials may be furnished, and
			no payments will be made until Advent receives the following completed and fully executed documents:
			</td>
		</tr>
	</table>

	<table cellpadding="13" cellspacing="0" border="0">
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="textAlignRight">1.</td><td>&nbsp;Subcontract Agreement</td>
					</tr>
					<tr>
						<td class="textAlignRight">2.</td><td>&nbsp;Subcontract Terms and Conditions</td>
					</tr>
					<tr>
						<td class="textAlignRight">3.</td><td>&nbsp;All Contract Exhibits</td>
					</tr>
					<tr>
						<td class="textAlignRight">4.</td><td>&nbsp;Certificates of Insurance</td>
					</tr>
				</table>
			</td>
			<td>
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td class="textAlignRight">5.</td><td>&nbsp;Copy of your State Contractor's License</td>
					</tr>
					<tr>
						<td class="textAlignRight">6.</td><td>&nbsp;Material Safety Data Sheet (MSDS)</td>
					</tr>
					<tr>
						<td class="textAlignRight">7.</td><td>&nbsp;All Required Product Submittals</td>
					</tr>
					<?php
					if ($city_business_license_required_flag == 'Y') {
					?>
					<tr>
						<td class="textAlignRight">8.</td><td>&nbsp;City of <?php echo $project_address_city; ?> Business License</td>
					</tr>
					<?php
					}
					?>
				</table>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="5">
		<tr>
			<td colspan="2">Image attachments Phantom JS:</td>
		</tr>

		<tr>
			<td colspan="2" cellpadding="5" cellspacing="5" width="100%">
				<img src="http://localdev.myfulcrum.com/images/photos/4.jpg" width="600">
			</td>
		</tr>
		<tr>
			<td colspan="2" cellpadding="5" cellspacing="5" width="100%">
				<img src="http://localdev.myfulcrum.com/images/photos/6.jpg" width="600">
			</td>
		</tr>
		<tr>
			<td colspan="2" cellpadding="5" cellspacing="5" width="100%">
				<img src="http://localdev.myfulcrum.com/images/photos/4.jpg" width="600">
			</td>
		</tr>
		<tr>
			<td colspan="2" cellpadding="5" cellspacing="5" width="100%">
				<img src="http://localdev.myfulcrum.com/images/photos/6.jpg" width="600">
			</td>
		</tr>
		<tr>
			<td colspan="2" cellpadding="5" cellspacing="5" width="100%">
				<img src="http://localdev.myfulcrum.com/images/photos/4.jpg" width="600">
			</td>
		</tr>
		<tr>
			<td colspan="2" cellpadding="5" cellspacing="5" width="100%">
				<img src="http://localdev.myfulcrum.com/images/photos/6.jpg" width="600">
			</td>
		</tr>
		<tr>
			<td colspan="2" cellpadding="5" cellspacing="5" width="100%">
				<img src="http://localdev.myfulcrum.com/images/photos/4.jpg" width="600">
			</td>
		</tr>
		<tr>
			<td colspan="2" cellpadding="5" cellspacing="5" width="100%">
				<img src="http://localdev.myfulcrum.com/images/photos/6.jpg" width="600">
			</td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2">If any of the above forms are unfamiliar to you, please contact our office immediately. We have also included copies of lien release forms that will be required with all	requests for payment. <u>No payments will be processed until all the above listed documents have been returned to our office.</u></td>
		</tr>
		<tr>
			<td colspan="2">
			<br>
			Thank you,<br><br>
			<?php echo $customer_contact_name; ?>
			<br><?php echo $customer_contact_email; ?>
			<?php
			if (isset($customer_contact_phone_number) && !empty($customer_contact_phone_number)) {
			?>
			<br><?php echo $customer_contact_phone_number; ?>
			<?php
			}
			?>
			</td>
		</tr>
	</table>

	<br>
	<div align="center"><img src="<?php echo $uri->http; ?>cms-gc-images/advent-footer.gif"></div>
</div>

</body>
</html>
