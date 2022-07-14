
<table border="0" cellpadding="0" cellspacing="0" width="100%">

<tr>
<td>
	<div class="headerStyle">UNIT TEST FORM</div>
</td>
</tr>

{if (isset($htmlMessages) && !empty($htmlMessages)) }
	<tr><td>{$htmlMessages|strip}</td></tr>
{/if}

<tr>
<td>
	{$unitTestFormContent}
</td>
</tr>

</table>
