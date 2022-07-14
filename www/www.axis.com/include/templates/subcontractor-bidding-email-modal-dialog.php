<?php $emailModalHtmlContent = <<<END_HTML_CONTENT

<style>
body {
	background-color: #fff;
	color: #000;
	font-family: Arial, Helvetica, Verdana, sans-serif;
	font-style: normal;
	text-decoration: none;
}
#subcontractorBidInvitationEmail .header {
	background:#cee4f1;
}
#subcontractorBidInvitationEmail .header p {
	margin: 0px; padding:12px;
	color:#000;
	font-size:16px;
	font-weight: bold;
}
input[type=button], input[type=submit], input[type=reset] {
	background: rgb(32,169,223); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(32,169,223,1) 0%, rgba(4,114,178,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(32,169,223,1)), color-stop(100%,rgba(4,114,178,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(32,169,223,1) 0%,rgba(4,114,178,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(32,169,223,1) 0%,rgba(4,114,178,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(32,169,223,1) 0%,rgba(4,114,178,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(32,169,223,1) 0%,rgba(4,114,178,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#20a9df', endColorstr='#0472b2',GradientType=0 ); /* IE6-9 */
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px; /* future proofing */
	-khtml-border-radius: 5px;
	color: white;
	cursor: hand;
	cursor: pointer;
	border: 1px solid #2985b4;
	padding: 5px 10px;
	margin:10px 0px;
}
input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover, input[type=file]:hover {
	background: rgb(4,114,178); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(4,114,178,1) 0%, rgba(32,169,223,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(4,114,178,1)), color-stop(100%,rgba(32,169,223,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(4,114,178,1) 0%,rgba(32,169,223,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(4,114,178,1) 0%,rgba(32,169,223,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(4,114,178,1) 0%,rgba(32,169,223,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(4,114,178,1) 0%,rgba(32,169,223,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0472b2', endColorstr='#20a9df',GradientType=0 ); /* IE6-9 */
}
#subcontractorBidInvitationEmail .listHeader {
	background: #cee4f1;
	font-size:16px;
	font-weight: bold;
	text-align: center;
	color:#000;
	padding:8px;
	text-transform:uppercase;
}
#subcontractorBidInvitationEmail .list .listSubheader {
	height:10px;
	color:#5c5c5c;
	padding:10px 10px;
	font-size: 13px;
	font-weight: bold;
	text-transform:uppercase;
	text-align: center;
	background:#daebf5;
	border-left:1px solid #d0dde4;
}
#subcontractorBidInvitationEmail .list, #subcontractorBidInvitationEmail .list th, #subcontractorBidInvitationEmail .list td {
	border: 1px solid #d0dde4;
}
#subcontractorBidInvitationEmail .list td {
	color:#4e4f51;
	font-size: 13px;
	font-weight:normal;
	height:32px;
	vertical-align:middle;
	padding:3px 10px;
	background:#eef6fa;
}
#subcontractorBidInvitationEmail .infoNote {
	background:url(../images/icons/icon-info-red.gif) no-repeat;
	padding-left: 25px;
	color:#d75c40;
	font-style: italic;
}
a[href$='.pdf'] {
	background:transparent url(../images/icons/icon-file-pdf-gray.gif) center left no-repeat;
	display:inline-block;
	padding-left: 28px;
	line-height:18px;
}
#subcontractorBidInvitationEmail .emailBody {
	background:#eef6fa;
	margin-top:0px;
}
#subcontractorBidInvitationEmail .emailBody td {
	color:#4e4f51;
	font-size: 13px;
	font-weight:normal;
	padding-top:6px;
}
#subcontractorBidInvitationEmail .textAreaRecipient, #subcontractorBidInvitationEmail .inputTextSubject {
	width:100%;
	height:20px;
	margin-top:-5px;
	border:1px solid #B9B9B9;
	padding:4px 0px 0px 4px;
	background:#FFFFFF;
	height:auto;
}
#subcontractorBidInvitationEmail .textAreaRecipient a {
	text-decoration:underline;
}
#subcontractorBidInvitationEmail .textAreaRecipient a img {
	border:none;
}
#subcontractorBidInvitationEmail .textAreaRecipient div {
	display: inline-block;
}
#subcontractorBidInvitationEmail .textareaMessageBody {
	width:100%;
	height:80px;
	border:0px;
	border:1px solid #B9B9B9;
}
#subcontractorBidInvitationEmail .footer {
	margin-top: 20px;
}

</style>
	<div id="subcontractorBidInvitationEmail">
		<!--input onclick="toggleConfirmRemoveElement();" type="button"-->
		<!--<table border="0" cellpadding="0" cellspacing="0" width="100%" class="header">
			<tr>
				<td width="27%"><p>02-101 Asbestos/Lead Abtmnt</p></td>
				<td width="73%" colspan="4" align="left" valign="middle"><p>Scheduled Value: 30000.00</p></td>
			</tr>
		</table>

		<input type="button" value="Add Bidder" onclick="" class="button_createNewProject" >

		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="listHeader">bidding subcontractors</td>
			</tr>
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="list">
						<tr>
							<td class="listSubheader"><img src="images/icons/modules-bidding-email-modal-dialogs/arrow.png"></td>
							<td class="listSubheader">COMPANY</td>
							<td class="listSubheader">CONTACT</td>
							<td class="listSubheader">STATUS</td>
							<td class="listSubheader">SEND INVITATION</td>
							<td class="listSubheader">&nbsp;</td>
							<td class="listSubheader">SCOPE</td>
							<td class="listSubheader">SUBMITTAL</td>
							<td class="listSubheader">BID</td>
							<td class="listSubheader">BID AMT</td>
							<td class="listSubheader">&nbsp;</td>
						</tr>
						<tr>
							<td><img src="images/icons/modules-bidding-email-modal-dialogss/arrow.png"></td>
							<td>Advent</td>
							<td>Bart Boshkey<span class="DCRbody2light"> <input type="text" value="Bart Boshkey" name="projectName" id="projectName" tabindex="1"></td>
							<td><input type="text" value="Potential Bidder" name="projectName" id="projectName" tabindex="1"></td>
							<td align="center"><input type="checkbox" tabindex="8" class="checkbox2"></td>
							<td><a href="#">Add Files</a></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td align="center">&nbsp;</td>
							<td>x</td>
						</tr>
						<tr>
							<td><img src="images/icons/modules-bidding-email-modal-dialogs/arrow.png"></td>
							<td>Advent</td>
							<td>Bart Boshkey<span class="DCRbody2light"> <input type="text" value="Bart Boshkey" name="projectName" id="projectName" tabindex="1"></td>
							<td><input type="text" value="Potential Bidder" name="projectName" id="projectName" tabindex="1"></td>
							<td align="center"><input type="checkbox" tabindex="8" class="checkbox2"></td>
							<td><a href="#">Add Files</a></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td align="center">&nbsp;</td>
							<td>x</td>
						</tr>
						<tr>
							<td><img src="images/icons/modules-bidding-email-modal-dialogs/arrow.png"></td>
							<td>Advent</td>
							<td>Bart Boshkey<span class="DCRbody2light"> <input type="text" value="Bart Boshkey" name="projectName" id="projectName" tabindex="1"></td>
							<td><input type="text" value="Potential Bidder" name="projectName" id="projectName" tabindex="1"></td>
							<td align="center"><input type="checkbox" tabindex="8" class="checkbox2"></td>
							<td><a href="#">Add Files</a></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td align="center">&nbsp;</td>
							<td>x</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>-->

		<table width="100%" border="0" cellspacing="11" cellpadding="12" class="emailBody">
			<tr>
				<td align="right">&nbsp;</td>
				<td>
					<div class="infoNote">Note: Each recipient will receive a custom email.</div>
				</td>
			</tr>
			<tr>
				<td width="6%" align="right">Recipients:</td>
				<td width="94%">
					<div class="textAreaRecipient">
						$subcontractorBidRecipients
					</div>
				</td>
			</tr>
			<tr>
				<td align="right">Subject:</td>
				<td><input value="$defaultEmailMessageSubject" type="text" name="projectName5" id="bidding-module-email-modal-dialog-form--subject-line" tabindex="1" class="inputTextSubject">
					<div class="textAlignRight" style="margin: 0; padding: 0;">
						<input style="margin: 3px 0 0 0; padding: 1px;" type="button" value="Clear Subject" onclick="clearInputValue('bidding-module-email-modal-dialog-form--subject-line');">
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					Message:<br>
					<textarea name="textarea" id="bidding-module-email-modal-dialog-files-subcontractor-bid-documents-textarea" class="textareaMessageBody">$defaultEmailMessageBody</textarea>
					<div class="textAlignRight"><input style="margin: 3px 0 0 0; padding: 1px;" type="button" value="Clear Message" onclick="clearInputValue('bidding-module-email-modal-dialog-files-subcontractor-bid-documents-textarea');"></div>
$projectBidInvitationFilesHtml
$gcBudgetLineItemBidInvitationsFilesHtml
$gcBudgetLineItemUnsignedScopeOfWorkDocumentFilesHtml
					<!--br>
					<br>
					Project Bid Invitation Files
					<table class="" border="1" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td><a href="test.pdf">01-000 General requirement - Scope of work - Advent - 2015-01-25 08:25 AM.pdf</a></td>
							<td><a href="test.pdf">01-000 General requirement - Scope of work - Advent - 2015-01-25 08:25 AM.pdf</a></td>
						</tr>
						<tr>
							<td><a href="test.pdf">01-000 General requirement - Scope of work - Advent - 2015-01-25 08:25 AM.pdf</a></td>
							<td><a href="test.pdf">01-000 General requirement - Scope of work - Advent - 2015-01-25 08:25 AM.pdf</a></td>
						</tr>
					</table>
					<br>
					<table width="100%" border="0" cellspacing="0" cellpadding="6">
						<tr>
							<td width="11%" align="right"> <strong>ATTACHMENT:</strong></td>
							<td width="89%"><span class="textAlignleft"><img src="images/icons/file-upload.png" width="15" height="17" alt=""><a href="#" class="dropFile"> Drop or Click Files</a></span></td>
						</tr>
						<tr>
							<td align="right"> <strong>AUTOFILL:</strong></td>
							<td>BID INVITE</td>
						</tr>
					</table-->
				</td>
			</tr>
		</table>

		<!--<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
			<tr>
				<td><input type="button" value="Done" onclick="" class="button_createNewProject" ></td>
				<td><input type="button" value="Send" onclick="" class="button_createNewProject" ></td>
			</tr>
		</table>-->
	</div>
	$subcontractorBidDiv
END_HTML_CONTENT;

return $emailModalHtmlContent;
