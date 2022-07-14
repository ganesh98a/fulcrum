<?php

/*

*/

?>
<html>
<head>
<title><?php echo $project_name; ?> Warranty Letter</title>
<link rel="stylesheet" type="text/css" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">
<meta http-equiv="imagetoolbar" content="false">
</head>
<body style="margin: 0px; padding: 0px;">
	<div>
		<p>
			<div class="textAlignCenter waiverSubTitle" style="background-color: yellow; border:1px solid black; padding: 5px;">
				PUT THIS FORM ON YOUR LETTERHEAD
			</div>
		</p>
		<br>
		<p>
			<div class="textAlignCenter waiverTitle">
				WARRANTY LETTER
			</div>
		</p>
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="textAlignCenter"><strong><?php echo $project_name; ?></strong></td>
			</tr>
			<tr>
				<td class="textAlignCenter"><?php echo $project_address_line_1; ?></td>
			</tr>
			<tr>
				<td class="textAlignCenter"><?php echo $project_address_city; ?>, <?php echo $project_address_state_or_region; ?> <?php echo $project_address_postal_code; ?></td>
			</tr>
		</table>
		<br>
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="textAlignJustify">
					KNOW ALL MEN BY THESE PRESENT:
					<br><br>
					Whereas we the undersigned,_________________________, has been employed by <?php echo $general_contractor_company_name; ?>.  We hereby
					guarantee that the ____________________________ which we have installed at
					<strong><span style="text-decoration:underline;padding-left:5px;"><?php echo $project_name; ?></span></strong>
					has been done in accordance with the drawings, specification and contract documents. We agree
					to repair or replace any or all of our work, together with any other adjacent work which may
					be displaced by so doing, that may prove to be defective within a period of ONE YEAR from the
					date of acceptance by the Owner, ordinary wear and tear, unusual abuse, neglect, earthquake,
					and Act of God excepted.
					<br><br>
					We hereby will perform emergency* calls seven (7) days per week, within twenty-four (24) hours;
					and non-emergency** calls within seventy-two (72) hours, as needed.  In the event of our
					failure to comply with the above conditions, we authorize the Owner and/or Owner's Agent to
					have the defects repaired and made good at our expense.  We will honor and pay the costs and
					charges for it upon demand.
					<br><br>
					*Emergency call is anything that may inconvenience the tenant or may cause further damage if
					not reacted upon within twenty-four (24) hours.
					<br><br>
					**Non-emergency call is anything that does not inconvenience the tenant or will not cause
					further damage if not reacted upon within twenty-four (24) hours.
				</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr valign="top">
		    	<td width="30%">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr><td class="borderBottomBlack">&nbsp;</td></tr>
						<tr><td class="sigBlock">Dated:</td></tr>
					</table>
				</td>
				<td width="5%">&nbsp;</td>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr><td class="borderBottomBlack">&nbsp;</td></tr>
						<tr><td class="sigBlock">Company Name:</td></tr>

						<tr><td class="borderBottomBlack">&nbsp;</td></tr>
						<tr><td class="sigBlock">Signature:</td></tr>

						<tr><td class="borderBottomBlack">&nbsp;</td></tr>
						<tr><td class="sigBlock">Title:</td></tr>

						<tr><td class="borderBottomBlack">&nbsp;</td></tr>
						<tr><td class="sigBlock">Emergency Phone:</td></tr>

						<tr><td class="borderBottomBlack">&nbsp;</td></tr>
						<tr><td class="sigBlock">Non-Emergency Phone:</td></tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
