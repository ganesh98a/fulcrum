
<table class="tblRegistrationSection">
<tr>
<td colspan="2" nowrap><strong>Required User Information</strong> &mdash; <i>passwords are stored securely using one-way encryption</i></td>
</tr>

{if (!isset($contact_user_company_id) || empty($contact_user_company_id) || ($contact_user_company_id == 1)) }

<tr>
<td width="10%" nowrap>Company Name</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%"><input id="user_company_name" maxlength="50" size="25" name="user_company_name" value="{$user_company_name}" tabindex="100" style="width:250px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Employer Identification Number (Fed Tax ID/EIN/SSN)</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%"><input maxlength="50" size="25" name="employer_identification_number" value="{$employer_identification_number}" tabindex="101" style="width:250px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Construction License Number</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input type="text" name="construction_license_number" value="{$construction_license_number}" maxlength="14" size="25" tabindex="102" style="width:250px;"></td>
	<td></td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Construction License Number Expiration Date (0000-00-00)&nbsp;</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>
	{*html_select_date prefix='construction_license_number_expiration_date' time="0000-00-00" month_empty='' year_empty='' start_year='+0' end_year='+10' display_days=true*}
	<input type="text" name="construction_license_number_expiration_date" value="{$construction_license_number_expiration_date}" maxlength="14" size="25" tabindex="103" style="width:250px;">
	</td>
	<td></td>
	</tr>
	</table>
</td>
</tr>

{/if}

<tr>
<td nowrap>Alerts</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><b><input id="emailAlert" type="checkbox" value="emailAlert" name="alertTypes[]" {$alertsEmailChecked} tabindex="104"></b></td>
	<td><b>Receive Alerts via Email</b>* Required Field</td>
	<td></td>
	</tr>

	<tr>
	<td><b><input id="smsAlert" onclick="updateSmsAlertRows();" type="checkbox" value="smsAlert" name="alertTypes[]" {$alertsSmsChecked} tabindex="105"></b></td>
	<td><b>Receive Alerts via SMS Text Messages</b></td>
	<td></td>
	</tr>
	</table>
</td>
</tr>

<tr id="smsAlertRow1">
<td width="10%" nowrap>Mobile Phone Number</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>
<input id="mobile_phone_area_code" style="display: inline;" maxlength="3" size="3" name="mobile_phone_area_code" value="{$mobile_phone_area_code}" tabindex="106">
<input style="display: inline-block;" maxlength="3" size="3" name="mobile_phone_prefix" value="{$mobile_phone_prefix}" tabindex="107">
<input style="display: inline-block;" maxlength="4" size="4" name="mobile_phone_number" value="{$mobile_phone_number}" tabindex="108">
	</td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr id="smsAlertRow2">
<td width="10%" nowrap>Cell Phone Carrier</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>
	{php}
	global $mobile_network_carrier_id, $database;
	require_once('lib/common/MessageGateway/Sms.php');
	$arrOptions = MessageGateway_Sms::generateSmsGatewayList($database, 'mobile_network_carriers');
	//$arrOptions = MessageGateway_Sms::$arrSmsGatewaysDropDownList;
	$select = '<select tabindex="109" name="mobile_network_carrier_id">';
	$first = true;
	foreach ($arrOptions as $optionGroup => $arrOptionList) {
		if ($first) {
			$first = false;
		} else {
			$select .= '</optgroup>';
		}
		$select .= '<optgroup label="'.$optionGroup.'">';
		foreach ($arrOptionList as $optionKey => $optionValue) {
			if ($mobile_network_carrier_id == $optionValue) {
				$selectedCarrier = 'selected';
			} else {
				$selectedCarrier = '';
			}
			$select .= '<option '.$selectedCarrier.' value="'.$optionValue.'">'.$optionKey.'</option>';
		}
	}
	$select .= '</optgroup></select>';
	echo $select;
	{/php}
	</td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td width="10%" nowrap>Email Address</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%"><input maxlength="50" size="25" name="email" value="{$email}" tabindex="114" style="width:250px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Screen Name (login name)</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%"><input maxlength="50" size="25" name="screen_name" value="{$screen_name}" tabindex="115" style="width:250px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Password</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input type="password" name="password" value="{$password}" maxlength="30" size="25" tabindex="116" style="width:250px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Confirm Password</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input type="password" name="password2" value="{$password2}" maxlength="30" size="25" tabindex="117" style="width:250px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

{*
<tr>
<td nowrap>Security Question</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>
	{php}
	global $security_question, $database;
		//generateSecurityQuestionList
		$arrOptions = User::generateSecurityQuestionList($database, 'security_questions');
		$select = '<select tabindex="118" name="security_question">';
		$first = true;
		foreach ($arrOptions as $optionKey => $optionValue) {
			if ($security_question == $optionValue) {
				$selectedQuestion = 'selected';
			} else {
				$selectedQuestion = '';
			}
			$select .= '<option '.$selectedQuestion.' value="'.$optionValue.'">'.$optionKey.'</option>';
		}
		$select .= '</select>';
		echo $select;

		//require_once('page-components/select_security_question.php');
		//getSecurityQuestionSelectBox($postBack->security_question, 'security_question', 8);
	{/php}
	</td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Answer to Security Question</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="security_answer" value="{$security_answer}" tabindex="119" style="width:250px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Picture</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%"><input type="hidden" name="MAX_FILE_SIZE" value="4000000"><input type="file" name="picture" tabindex="120"></td>
	<td>&nbsp;(Optional)</td>
	</tr>
	</table>
</td>
</tr>
*}

</table>

<script>
function updateSmsAlertRows()
{
	var smsAlertChecked = document.getElementById('smsAlert').checked;
	var smsAlertRow1 = document.getElementById('smsAlertRow1');
	var smsAlertRow2 = document.getElementById('smsAlertRow2');
	if (smsAlertChecked) {
		smsAlertRow1.style.display = '';
		smsAlertRow2.style.display = '';
	} else {
		smsAlertRow1.style.display = 'none';
		smsAlertRow2.style.display = 'none';
	}
}
updateSmsAlertRows();
</script>
