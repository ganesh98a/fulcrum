<?php
/**
 * SmartPhone Apps - Downloads.
 *
 *
 *
 */
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = false;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

$htmlTitle = 'SmartPhone Apps - Downloads';
$htmlBody = "onload='setFocus();'";
require_once('page-components/axis/header.php');
?>
<table border="0" width="100%" cellspacing="0" cellpadding="5">
<tr>
<th align="left">
<div class="headerStyle">Download SmartPhone Apps</div>
</th>
</tr>
<tr>
<td>
<a href="#"><img src="/images/logos/android-logo.png" border="0"></a>
</td>
</tr>
<tr>
<td>
<a href="#"><img src="/images/logos/blackberry-logo.png" border="0"></a>
</td>
</tr>
<tr>
<td>
<a href="#"><img src="/images/logos/iphone-logo.png" border="0"></a>
</td>
</tr>
</table>
<?php require_once('page-components/axis/footer.php'); ?>