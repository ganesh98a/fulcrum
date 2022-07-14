<?php $emailModalHtmlContent = <<<END_HTML_CONTENT

<style>
.BIV_header{
	background:#cee4f1;
}
.BIV_header p{
	margin: 0px; padding:12px;
	color:#000;
	font-size:16px;
	font-weight: bold;
}

input[type=button], input[type=submit], input[type=reset] {
background: rgb(32,169,223); /* Old browsers */

background: -moz-linear-gradient(top,  rgba(32,169,223,1) 0%, rgba(4,114,178,1) 100%); /* FF3.6+ */

background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(32,169,223,1)), color-stop(100%,rgba(4,114,178,1))); /* Chrome,Safari4+ */

background: -webkit-linear-gradient(top,  rgba(32,169,223,1) 0%,rgba(4,114,178,1) 100%); /* Chrome10+,Safari5.1+ */

background: -o-linear-gradient(top,  rgba(32,169,223,1) 0%,rgba(4,114,178,1) 100%); /* Opera 11.10+ */

background: -ms-linear-gradient(top,  rgba(32,169,223,1) 0%,rgba(4,114,178,1) 100%); /* IE10+ */

background: linear-gradient(to bottom,  rgba(32,169,223,1) 0%,rgba(4,114,178,1) 100%); /* W3C */

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

background: -moz-linear-gradient(top,  rgba(4,114,178,1) 0%, rgba(32,169,223,1) 100%); /* FF3.6+ */

background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(4,114,178,1)), color-stop(100%,rgba(32,169,223,1))); /* Chrome,Safari4+ */

background: -webkit-linear-gradient(top,  rgba(4,114,178,1) 0%,rgba(32,169,223,1) 100%); /* Chrome10+,Safari5.1+ */

background: -o-linear-gradient(top,  rgba(4,114,178,1) 0%,rgba(32,169,223,1) 100%); /* Opera 11.10+ */

background: -ms-linear-gradient(top,  rgba(4,114,178,1) 0%,rgba(32,169,223,1) 100%); /* IE10+ */

background: linear-gradient(to bottom,  rgba(4,114,178,1) 0%,rgba(32,169,223,1) 100%); /* W3C */

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0472b2', endColorstr='#20a9df',GradientType=0 ); /* IE6-9 */

}
.biddingSubcontractors{
background: #cee4f1;

	font-size:16px;
	font-weight: bold;
	text-align: center;
	color:#000;
	padding:8px;
	text-transform:uppercase;

}
.BIPmain{
}
.BIPmain .BIP_contentdark{
}
.BIPmain .BIP_header{
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
table.BIPmain, table.BIPmain th, table.BIPmain td {
   border: 1px solid #d0dde4;
}
.BIPmain td{
	color:#4e4f51;
	font-size: 13px;
	font-weight:normal;
	height:32px;
	vertical-align:middle;
	padding:3px 10px;
	background:#eef6fa;

}

.infoNote{
	background:url(/images/icons/icon-info-red.gif) no-repeat;
	padding-left: 25px;
	color:#d75c40;
	font-style: italic;
}
a[href$='.pdf']{
background:transparent url(/images/icons/icon-file-pdf-gray.gif) center left no-repeat;
display:inline-block;
padding-left: 28px;
line-height:18px;
}
.BIPmain2{
	background:#eef6fa;
}
.BIPmain2 td{
	color:#4e4f51;
	font-size: 13px;
	font-weight:normal;
	padding-top:12px;
}
.BIPmain2text{
	width:100%;
	height:20px;
	margin-top:-5px;
}
.BIPmain2textarea{
	width:100%;
	height:80px;
	border:0px;
}

</style>

<table width="100%" border="0" cellspacing="11" cellpadding="12" class="BIPmain2">
	<tr>
		<td align="right">&nbsp;</td>
		<td><div class="infoNote">Note: Each recipient will receive a custom email.</div> </td>
	</tr>
	<tr>
		<td width="6%" align="right">Recipients:</td>
		<td width="94%"><span class="DCRbody2light">
		<input type="text" name="projectName2" id="projectName2" tabindex="1" class="BIPmain2text" value="$to">
		</span></td>
	</tr>
	<tr>
		<td align="right">Subject:</td>
		<td>
		<input type="text" name="projectName5" id="projectName5" tabindex="1" class="BIPmain2text">
		</td>
	</tr>
	<tr>
	<td colspan="2">
	<textarea name="textarea" id="textarea" class="BIPmain2textarea"></textarea>
	<br>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="">
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
			<td width="89%"><span class="textAlignleft"><img src="/images/icons/file-upload.png" width="15" height="17" alt=""><a href="#" class="dropFile"> Drop or Click Files</a></span></td>
		</tr>
		<tr>
			<td align="right"> <strong>AUTOFILL:</strong></td>
			<td>BID INVITE</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<br>
<!--table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td><input type="button" value="Done" onclick="" class="button_createNewProject" >   </td>
		<td><input type="button" value="Send" onclick="" class="button_createNewProject" >   </td>
	</tr>
</table-->

END_HTML_CONTENT;

return $emailModalHtmlContent;
