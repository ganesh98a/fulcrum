<?php

/*submittal cover sheet */

?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta http-equiv="imagetoolbar" content="false">
<title>Submittal</title>
<link href="<?php echo $uri->http; ?>css/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $uri->http; ?>css/modules-submittals-pdf.css" rel="stylesheet" type="text/css">

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

<body>
<?php echo $headerLogo; ?>
	<div id="" style="font-family: Helvetica,sans;">
	<span class="highlight"><b><?php echo $escaped_project_name."- Submittal"; ?></b></span>
		<table border="0" class="submittalDesc" cellspacing="0" cellpadding="4" class="" width="100%">
			<tr>
				<td class="thhighlight textAlignLeft" width="10%">Description  </td>
				<td width="2%">:</td>
				<td class="textAlignLeft thhighlight" align="left"><?php echo $escaped_su_title; ?></td>
				<td class="thhighlight textAlignLeft" width="15%"  >Submittal Number </td>
				<td width="2%">:</td>
				<td width="20%" class="textAlignLeft thhighlight"><?php echo $su_sequence_number;?></td>
			</tr>
			<tr>
				<td class="thhighlight textAlignLeft" >Priority </td>
				<td >:</td>
				<td class="textAlignLeft thhighlight"><?php echo $submittal_priority; ?></td>
				<td class="thhighlight textAlignLeft" >Due Date</td>
				<td >:</td>
				<td class="textAlignLeft thhighlight" align="left"><?php echo $su_due_date; ?></td>
			</tr>
			<tr>
				<td class="thhighlight textAlignLeft" >Plan Ref</td>
				<td>:</td>
				<td class="textAlignLeft thhighlight"><?php echo $escaped_su_plan_page_reference; ?></td>
				<td class="thhighlight textAlignLeft" >Opened Date</td>
				<td>:</td>
				<td class="textAlignLeft thhighlight"><?php echo $su_created_on; ?></td>
			</tr>
			<tr>
				<td class="thhighlight textAlignLeft">Status</td>
				<td>:</td>
				<td class="thhighlight"><?php echo $submittal_status; ?></td>
				<td class="thhighlight textAlignLeft" >Closed Date</td>
				<td>:</td>
				<td class="textAlignLeft thhighlight"><?php echo $su_closed_date; ?></td>
			</tr>
		</table><hr>
		<div style="margin: 15px 0;">
			<table border="0" cellpadding="2" cellspacing="0" width="100%">
				<tr>
					<td class="thhightlightColortd"><span class="thhightlightColor">Created By :</span></td>
 		<?php 	if($updatedsubmittal == "yes" && empty($suInitiatorContact)) { ?>
					<td class="thhightlightColortd"><span class="thhightlightColor">Updated By :</span></td>
		<?php  	} 
				if($updatedsubmittal != "yes" && !empty($suInitiatorContact)){ ?>

					<td class="thhightlightColortd"><span class="thhightlightColor">Received from :</span></td>
		<?php 	} ?>
					<td class="thhightlightColortd"><span class="thhightlightColor">To :</span></td>
				</tr>
				<tr>
					<td style="font-size:12px;" nowrap>
					<?php echo $suCreatorContactFullNameHtmlEscaped; ?></td>
		<?php 	if($updatedsubmittal == "yes" && empty($suInitiatorContact)) { ?>
					<td style="font-size:12px;" nowrap><?php echo $suUpdatedContactName; ?></td>
		<?php 	} 
				if($updatedsubmittal != "yes" && !empty($suInitiatorContact)){ ?>
					<td style="font-size:12px;" nowrap><?php echo $suInitiatorContactFullNameHtmlEscaped; ?></td>
		<?php 	} ?>
					<td style="font-size:12px;"><span style="word-break: keep-all;"><?php echo $suRecipientContactFullNameHtmlEscaped; ?></span></td>
				</tr>
				<tr>
					<td style="font-size:12px;" nowrap><?php echo $suCreatorContactCompanyOfficeAddressHtmlEscaped; ?></td>
		<?php 	if($updatedsubmittal == "yes" && empty($suInitiatorContact)) { ?>
					<td style="font-size:12px;" nowrap><?php echo $suUpdatedContactCompanyOfficeAddressHtmlEscaped; ?></td>
		<?php  	}
					if($updatedsubmittal != "yes" && !empty($suInitiatorContact)){ ?>
					<td style="font-size:12px;" nowrap><?php echo $suInitiatorContactCompanyOfficeAddressHtmlEscaped; ?></td>
		<?php 	} ?>
					<td style="font-size:12px;" nowrap><?php echo $suRecipientContactCompanyOfficeAddressHtmlEscaped; ?></td>
				</tr>
		<?php 	if($updatedsubmittal == "yes" && !empty($suInitiatorContact)) { ?>
				<tr>
					<td class="thhightlightColortd" style="padding-top:8px;"><span class="thhightlightColor">Received from :</span></td>
					<td class="thhightlightColortd" style="padding-top:8px;"><span class="thhightlightColor">Updated By :</span></td>
				</tr>
				<tr>
					<td style="font-size:12px;" nowrap><?php echo $suInitiatorContactFullNameHtmlEscaped; ?></td>
					<td style="font-size:12px;" nowrap><?php echo $suUpdatedContactName; ?></td>
				</tr>
				<tr>
					<td style="font-size:12px;" nowrap><?php echo $suInitiatorContactCompanyOfficeAddressHtmlEscaped; ?></td>
					<td style="font-size:12px;" nowrap><?php echo $suUpdatedContactCompanyOfficeAddressHtmlEscaped; ?></td>
				</tr>
		<?php 	} 
				if(!empty($recipient_name_arr)){
					$recipient_name = implode(', ',$recipient_name_arr);
		?>
				<tr>
					<td class="thhightlightColortd" colspan="3"><span class="thhightlightColor">Team :</span></td>
				</tr>
				<tr>
					<td style="font-size:12px;" colspan="3"><?php echo $recipient_name; ?></td>
				</tr>
		<?php 	} ?>
			</table>
		</div>
		<div>
			<div class="topicHeader">Topic</div>
			<div class="topicHeaderIn"><p class="plinkTag"><?php echo $escaped_su_statement_nl2br; ?></p></div>

		</div>
		<div>
			<div class="topicHeadernotes">Note(s)</div>
			<div style="background: #f0f0f0; padding: 0 15px;">
				<table width="100%">
					<?php echo $tableSuResponses; ?>
				</table>
			</div>
		</div>
	</div>
	<div class='stamp--footer' >
	<table id="stamp">
	<tbody>
	<tr>
	<td>
Corrections or comments made on the shop drawings during this review do not relieve subcontractor from compliance with requirements of the Contract Documents. This is only a review of the general conformance with the design concept of the project and general compliance with the information given in the Contract Documents. The subcontractor is responsible for: conforming and correlating all quantities and dimensions; compliance with all code, statutory and regulatory legal requirements; selecting fabrication processes and techniques of construction; and performing all work in a safe and satisfactory manner.<br><br>
</td>
</tr>
</tbody>
</table>
</div>
</body>
</html>

