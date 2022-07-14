<?php

/*

*/

if (!isset($sendSubcontractMethod)) {
	$sendSubcontractMethod = 'Download';
}

$currentDate = date("m/d/Y");

// Debug
//require_once('templates/subcontract-item-template-dummy-data.php');

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
<style>
.center-align {
	text-align:center;
	font-size:10px;
}
.align-right {
    text-align:right;
}
.header {	
}
.footer { 	
	height: 30px;
	display: block;	
	width: 100%;	
	text-align: center;
}
#footer .page:after { 
	content: counter(page, upper-roman); 
}
#container {
    padding-top:0px !important; 
}
.textAlignCenter {
    text-align: center !important;
}
</style>

</head>
<body style="margin: 30px; padding: 0px;">
<div class="header">
 <table width="100%">
 <tr>
 <td><?php echo $gcLogo; ?></td>
 <td class="align-right"><?php echo $fulcrum; ?></td>
 </tr>
 </table>
 </div>
 <hr />
<p style="font-size:20px;font-weight:300;text-align: center;margin-bottom:5px;margin-top:5px;"><?php echo $project_name; ?></p>
	<table style="font-size:12px;margin-bottom:20px;" border="0" cellpadding="3" cellspacing="0" width="100%" >
		<tr valign="top">
			<td style="border-top:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:17%;"><b>COMPANY</b>
			</td>
			<td style="border-top:1px solid #000000;border-right:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:33%;">
				: <?php echo $vendor_company_name; ?><br>
				<?php echo $vendor_address_line_1; ?> <?php echo $vendor_address_line_2; ?>
						<?php echo $vendorDisplayedAddressCityStateZip; ?>
				
			</td>
			<td style="border-top:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:17%;"><b>DATE</b>
			</td>
			<td style="border-top:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:33%;">: <?php echo $currentDate; ?>
			</td>



			
		</tr>

		<tr valign="top">
			<td style="border-top:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:17%;"><b>TO</b>
			</td>
			<td style="border-top:1px solid #000000;border-right:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:33%;">: <?php echo $vendor_contact_name; ?><br><?php echo $vendor_mobile_phone_number; ?>
			</td>
			<td style="border-top:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:17%;"><b>FROM</b>
			</td>
			<td style="border-top:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:33%;">
				: <?php echo $customer_contact_name; ?>
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
				<br>&nbsp;&nbsp;&nbsp;Fx:&nbsp;<?php echo $customer_contact_fax_number; ?>
				<?php
				}
				?>
			</td>
		</tr>

		<tr valign="top">
			<td style="border-top:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:17%;"><b>Vendor signatory</b>
			</td>
			<td style="border-top:1px solid #000000;border-right:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:33%;">: <?php echo $vendor_signatory_contactName; ?>
			</td>
			
			<td style="border-top:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:17%;"><b>GC signatory</b>
			</td>
			<td style="border-top:1px solid #000000;border-right:none;font-size:12px;height:30px;vertical-align:middle;width:33%;">: <?php echo $gc_signatory_contactName; ?>
			</td>
			
		</tr>

		<tr valign="top">
			<td style="border-top:1px solid #000000;border-bottom:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:17%;" class="">
				<b>PAGES</b>
			</td>
			<td class="" style="border-top:1px solid #000000;border-bottom:1px solid #000000;font-size:12px;border-right:1px solid #000000;height:30px;vertical-align:middle;width:33%;">
				: <?php echo $page_count + 1; ?> (Including Cover)
			</td>
			<td style="border-top:1px solid #000000;border-bottom:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:17%;" class="">
				<b>SENT VIA</b>
			</td>
			<td class="" style="border-top:1px solid #000000;border-bottom:1px solid #000000;font-size:12px;height:30px;vertical-align:middle;width:33%;">
				: <?php echo $sendSubcontractMethod; ?>
			</td>
			
		</tr>
	</table>
<br><br>
	

	<table style="font-size:12px;margin-top:15px;" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td colspan="2"  style="padding-top:15px;">This letter serves as official notification that <?php echo $vendor_company_name; ?> has been awarded the attached contract for the following project:</td>
		</tr>

		<tr><td colspan="2">&nbsp;</td></tr>

		<tr>
			<td cellpadding="10" style="padding-bottom: 15px;padding-left: 15px;" nowrap width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Project Name:</td>
			<td cellpadding="10" style="padding-bottom: 15px;" width="80%"><u> <?php echo $project_name; ?> </u></td>
		</tr>

		<tr>
			<td cellpadding="10" style="padding-bottom: 15px;padding-left: 15px;" width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Located At: </td>
			<td cellpadding="10" style="padding-bottom: 15px;" width="80%"><u><?php echo $project_address_line_1; ?>, <?php echo $project_address_city; ?>, <?php echo $project_address_state_or_region; ?> <?php echo $project_address_postal_code; ?></u></td>
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

	<table style="font-size:12px;" cellpadding="13" cellspacing="0" border="0">
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td>1. &nbsp;Subcontract Agreement</td>
					</tr>
					<tr>
						<td>2. &nbsp;Subcontract Terms and Conditions</td>
					</tr>
					<tr>
						<td>3. &nbsp;All Contract Exhibits</td>
					</tr>
					<tr>
						<td>4. &nbsp;Certificates of Insurance</td>
					</tr>
				</table>
			</td>
			<td>
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td>5. &nbsp;Copy of your State Contractor's License</td>
					</tr>
					<tr>
						<td>6. &nbsp;Material Safety Data Sheet (MSDS)</td>
					</tr>
					<tr>
						<td>7. &nbsp;All Required Product Submittals</td>
					</tr>
					<?php
					if ($city_business_license_required_flag == 'Y') {
					?>
					<tr>
						<td>8. &nbsp;City of <?php echo $project_address_city; ?> Business License</td>
					</tr>
					<?php
					}
					?>
				</table>
			</td>
		</tr>
	</table>

	<table style="font-size:12px;" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2">If any of the above forms are unfamiliar to you, please contact our office immediately. We have also included copies of lien release forms that will be required with all	requests for payment. <u>No payments will be processed until all the above listed documents have been returned to our office.</u></td>
		</tr>
		<tr>
			<td colspan="2" style="padding-bottom: 15px;">
			<br>
			<br>
			Thank you,<br><br>
			<?php echo $customer_contact_name; ?>
			<?php if($customer_contact_email != $customer_contact_name)
			{echo "<br>".$customer_contact_email; }?>
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

	<!-- <br><br><br><br><br><br><br><br><br><br><br> -->
	
<!-- 	<div class="footer">
 <table width="100%">
 <tr>
 <td class="center-align" style="margin-top: 100px;padding-top: 100px;">
 	<?php echo $general_contractor_address_line_1;
 if($general_contractor_address_city!='')
 	echo " | ".$general_contractor_address_city;
 if($general_contractor_address_state_or_region!='')
 	echo " , ".$general_contractor_address_state_or_region;
 if($general_contractor_address_postal_code!='')
 	echo " ".$general_contractor_address_postal_code;
 echo " ".$general_contractor_phone_number;
 if($general_contractor_fax_number!='')
 	echo " ".$general_contractor_fax_number;
 ?> </td>
 </tr>
 </table>
 </div> -->
	

</body>
</html>
