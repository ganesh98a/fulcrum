<?php
/**
 * footer include.
 *
 *
 *
 */
?>
<br>
<table border="0" width="100%" cellpadding="0" cellspacing="0" height="1">
<tr>
<td style="background-image: url('images/footerSubBCK.gif')" colSpan="2"><img alt="" src="images/footerSub.gif" width="769" height="28"></td>
</tr>
<tr>
<td><img height="1" alt="" src="images/1px.gif" width="23"></td>
<td><img height="1" alt="" src="images/1px.gif" width="769"></td>
</tr>
<tr>
<td colspan="2"><div class="sshareFooter">&nbsp;&nbsp;<a class="sshareFooter" tabindex="0" href="/">Home</a> | <a class="sshareFooter" tabindex="0" href="login-form.php">Login</a> | <a class="sshareFooter" tabindex="0" href="account.php">Account</a> | <a class="sshareFooter" tabindex="0" href="smartphone-apps.php">SmartPhone Apps</a> | <a class="sshareFooter" tabindex="0" href="account-registration-form.php">Sign Up</a> | <a class="sshareFooter" target="_parent" tabindex="0" href="/help.php">Help</a> | <a class="sshareFooter" target="_parent" tabindex="0" href="/terms-and-conditions.php">Terms &amp; Conditions</a></div></td>
</tr>
<tr>
<td colspan="2" nowrap>
<div id="footer">
<div id="footerLinks">
<a href="/">Home</a>
<a href="/about-us.php">About Us</a>
<a href="/contact-us.php">Contact Us</a>
<?php /*<a href="/help.php">Help</a> */ ?>
<a href="/sitemap.php">Site Map</a>
</div>
&copy;<?php echo date("Y"); ?> MyFulcrum.com&trade;
<a id="privacy" href="/privacy.php">Privacy</a>
<a id="privacy" href="/terms-and-conditions.php">Terms And Conditions</a>
</div>
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php echo ((isset($htmlJavaScriptBody) && !empty($htmlJavaScriptBody)) ? $htmlJavaScriptBody : ''); ?>
</body>
</html>