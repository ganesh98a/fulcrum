<?php

/*
<cfquery name="badSubs" datasource="#APPLICATION.AdventDSN#">
	SELECT *
	FROM bad_subcontractors
	ORDER BY name
</cfquery>

*/

?>
<html>
<head>

	<title><?php echo $general_contractor_company_name; ?> No Bid List</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $uri->http; ?>css/subcontract-item-templates.css">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>

	<center>
		<table width="90%" style="font-size: 16pt;">
			<tr>
				<th style="border-bottom: 2px solid black;">EXHIBIT F - NO BID LIST</th>
			</tr>
		</table>
		<table width="90%">
			<tr>
				<td>
					In connection with Subcontractor's Work on the Project, Subcontractor will not
					subcontract with or purchase materials from the following companies or their affiliates on <?php echo $general_contractor_company_name; ?>'s
					No-Bid list:
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<cfloop query="badSubs">
				<tr><td>#Trim(name)#</td></tr>
			</cfloop>
		</table>
		<br><br><br>
		<table width="90%">
			<tr>
				<td>Subcontractor Initial: _____________</td>
			</tr>
		</table>
	</center>

</body>
</html>
