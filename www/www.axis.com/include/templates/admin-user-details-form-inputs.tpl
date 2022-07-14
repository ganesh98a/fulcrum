
<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
<tr>
<td colspan="2"><strong>Optional User Information</strong></td>
</tr>

{*
<tr>
<td width="10%" nowrap>Credit Card Number</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%"><input maxlength="50" size="25" name="creditCardNumber" value="" tabindex="220" style="width:150px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td width="10%" nowrap>Credit Card Expiration Date</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%" nowrap>{html_select_date prefix='ccExpirationDate' time="0000-00-00" month_empty='' year_empty='' start_year='+0' end_year='+10' display_days=false}</td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td width="10%" nowrap>3 digit Card Security Code</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%" nowrap><input maxlength="50" size="25" name="creditCardSecurityCode" value="" tabindex="220" style="width:30px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td width="10%" nowrap>Full Name</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%"><input maxlength="50" size="25" name="creditCardName" value="{$first_name}" tabindex="220" style="width:150px;"></td>
	<td>&nbsp;</td>
	</tr>
	</table>
</td>
</tr>
*}

{*<tr>
<td width="10%" nowrap>Picture</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%"><input type="hidden" name="MAX_FILE_SIZE" value="4000000"><input type="file" name="picture" tabindex="219"></td>
	<td>&nbsp;</td>
	</tr>
	</table>
</td>
</tr>*}

<tr>
<td width="10%" nowrap>First Name</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%"><input maxlength="50" size="25" name="first_name" value="{$first_name}" tabindex="220" style="width:150px;"></td>
	<td>&nbsp;</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Last Name</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="last_name" value="{$last_name}" tabindex="221" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

{*
<tr>
<td nowrap>Address Line 1</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="address_line_1" value="{$address_line_1}" tabindex="222" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Address Line 2</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="address_line_2" value="{$address_line_2}" tabindex="223" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Address Line 3</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="address_line_3" value="{$address_line_3}" tabindex="224" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>City</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="address_city" value="{$address_city}" tabindex="225" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>State/Region</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="address_state" value="{$address_state}" tabindex="226" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Zip Code/Postal Code</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="10" size="9" name="address_zip" value="{$address_zip}" tabindex="227" style="width:65px;">
	</td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Country</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>
	{php}
		global $address_country;
		require_once('page-components/select_country_list.php');
		echo getCountrySelectBox($address_country, 228);
	{/php}
	</td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>
*}

<tr>
<td nowrap>Title/Position</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="title" value="{$job_title}" tabindex="229" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

{*
<tr>
<td nowrap>Company/Employer</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="company_name" value="{$company_name}" tabindex="230" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Website/Blog</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="website" value="{$website}" tabindex="231" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>
*}

</table>
