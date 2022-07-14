<?php
if (!isset($noSubContentBreak) || !$noSubContentBreak) {
	echo '<br>';
}
if (isset($headline) && !empty($headline)) {
	/*
		<h2 class="subcontentHeadline"><?php echo $headline; ?></h2>
 			-> color: #666699; font-size: 15px; font-weight: bold; margin-top: 5px; margin-bottom: 0; padding: 2px 10px;
 			-> <h2 style="color: #666699; font-size: 15px; font-weight: bold; margin: 0; padding: 0;">'.$headline.'</h2>
 	*/
	echo '<h2 style="color: #666699; font-size: 15px; font-weight: bold; margin: 5px 0 0 10px; padding: 0;">'.$headline.'</h2>';
}
if (isset($headlineRight) && !empty($headlineRight)) {
	echo $headlineRight;
}
?>

<table style="border-collapse: separate !important; border-spacing: 0; table-layout: auto; ^width: 10%;" align="left" border="0" cellpadding="0" cellspacing="0">
<tr>
<td style="font-size: 8px; height: 9px; line-height: 8px; padding: 0; width: 10px;" align="left" valign="top" width="9" height="9"><img style="border: 0; border: none; vertical-align: top;" src="<?php echo $uri->cdn; ?>images/gray-top-left.cdn_1.0.png" width="10" height="10"></td>
<td style="border-top: 1px solid #DBDBDC; empty-cells: show; font-size: 8px; height: 9px; line-height: 8px; padding: 0; width: auto; ^width: 99%;" width="99%" height="9"><img style="border: 0; border: none; vertical-align: baseline; width: auto;" src="<?php echo $uri->cdn; ?>images/1px.cdn_1.0.gif" width="1" height="1"></td>
<td style="font-size: 8px; height: 9px; line-height: 8px; padding: 0; width: 10px;" align="right" valign="top" width="9" height="9"><img style="border: 0; border: none; vertical-align: top;" src="<?php echo $uri->cdn; ?>images/gray-top-right.cdn_1.0.png" width="10" height="10"></td>
</tr>

<tr>
<td style="border-left: 1px solid #DBDBDC; border-right: 1px solid #DBDBDC; overflow: visible;" colspan="3">
<div style="padding: 0px 10px;">
<h2 style="margin: 0 0 10px 0; padding: 0;"><?php echo $htmlAlertHeadline; ?></h2>

<?php echo $subcontent; ?>

<br>
<small>Thank you for using Fulcrum Construction Management Software</small>
</div>
</td>
</tr>

<tr>
<td style="font-size: 8px; height: 9px; line-height: 8px; padding: 0; width: 10px;" align="left" valign="bottom" width="9" height="9"><img style="border: 0; border: none; vertical-align: bottom;" src="<?php echo $uri->cdn; ?>images/gray-bottom-left.cdn_1.0.png" width="10" height="10"></td>
<td style="border-bottom: 1px solid #DBDBDC; font-size: 8px; height: 9px; line-height: 8px; padding: 0;" height="9"><img style="border: 0; border: none; vertical-align: baseline;" src="<?php echo $uri->cdn; ?>images/1px.cdn_1.0.gif" width="1" height="1"></td>
<td style="font-size: 8px; height: 9px; line-height: 8px; padding: 0; width: 10px;" align="right" valign="bottom" width="9" height="9"><img style="border: 0; border: none; vertical-align: bottom;" src="<?php echo $uri->cdn; ?>images/gray-bottom-right.cdn_1.0.png" width="10" height="10"></td>
</tr>
</table>
