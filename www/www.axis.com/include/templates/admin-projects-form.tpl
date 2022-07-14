
<!--<form name="frm_account_update" action="account-management-projects-form-submit.php" method="post">-->
<table border="0" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td width="100%" height="20"><div class="headerStyle">ACCOUNT ADMIN - Manage Projects</div></td>
</tr>
<tr>
<td align="left" width="100%">

	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{/if}

	{include file="dropdown-projects-list.tpl"}

	<!--<div align="right">
	<br>
	<input type="reset" value="    Reset Form    " name="Reset" tabindex="3002" onclick="window.location='account-management-projects-form-reset.php'">&nbsp;|&nbsp;<input type="submit" value="   Save Changes   " name="Submit" tabindex="3001">
	</div>-->

</td>
</tr>
</table>
<!--</form>-->
