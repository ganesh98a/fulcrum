<?php

/*

*/

?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta http-equiv="imagetoolbar" content="false">
<title><?php echo $project_name; ?> Subcontractor's Supplier List</title>
<link rel="stylesheet" href="<?php echo $uri->http; ?>css/transmittal-forms.css">
<link rel="stylesheet" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
</head>
<body style="margin: 30px; padding: 0px;">
	<center>
		<br>
		<br>
		<p>
			<div class="waiverTitle">
				LIST OF VENDORS
			</div>
		</p>
		<br>
		<br>
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr><td>Subcontractor: ______________________________</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td style="text-align:justify;">
					List all major suppliers, including material, equipment rentals, etc. who will
					be paid over $500 by the above named subcontractor on
					<strong><span style="text-decoration:underline;padding-left:5px;"><?php echo $project_name; ?></span></strong>
					project.  List the type or description of materials purchased from each and the
					approximate dollar value of the purchases you expect to make for the
					<strong><span style="text-decoration:underline;padding-left:5px;"><?php echo $project_name; ?></span></strong>
					project.
				</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<th valign="left">Vendor Name</th>
				<th valign="left">Phone Number</th>
				<th valign="left">Description</th>
				<th valign="left">Approximate Value</th>
			</tr>
<?php
			//<cfloop from="1" to="12" index="x">
			for ($tmpI = 0; $tmpI < 12; $tmpI++) {
?>
				<tr>
					<td class="borderBottomBlack" colspan="4">&nbsp;</td>
				</tr>
<?php
			}
//			</cfloop>
?>
		</table>
		<br>
		<br>
		<br>
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr><td>I agree to notify <?php echo $general_contractor_company_name; ?> of any additions or changes to the above information.</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr valign="bottom">
				<td>
					<table width="300" cellpadding="0" cellspacing="0">
						<tr><td class="borderBottomBlack">&nbsp;</td></tr>
						<tr><td class="sigBlock">Date:</td></tr>

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
