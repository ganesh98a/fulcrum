<?php

$uri = Zend_Registry::get('uri');

if (!isset($noSubContentBreak) || !$noSubContentBreak) {
	
}
if (isset($headline) && !empty($headline)) {
	
}
if (isset($headlineRight) && !empty($headlineRight)) {
	echo $headlineRight;
}
?>

<?php echo $subcontent; ?>

<table><tr><td>
<small>Thank you for using <a href="<?php echo $uri->http; ?>" style="text-decoration:none; color:#3b90ce; font-size:15px; font-weight: bold;">FULCRUM</a> Construction Management&trade; Software</small>
</div>
</td>
</tr>
</table>
<!-- !end-->
