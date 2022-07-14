
<div style="padding: 0 7px;"><strong>Required Account Information</strong></div>
<div class="requiredAccountInfoBox">
<table border="0" cellspacing="2" cellpadding="2">

<tr>
<td nowrap>Alerts</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><b><input id="emailAlert" type="checkbox" value="emailAlert" name="alertTypes[]" {$alertsEmailChecked} tabindex="115"></b></td>
	<td><b>Receive Alerts via Email</b>* Required Field</td>
	<td></td>
	</tr>

	<tr>
	<td><b><input id="smsAlert" onclick="updateSmsAlertRows();" type="checkbox" value="smsAlert" name="alertTypes[]" {$alertsSmsChecked} tabindex="114"></b></td>
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
<input id="mobile_phone_area_code" style="display: inline;" maxlength="3" size="3" name="mobile_phone_area_code" value="{$mobile_phone_area_code}" tabindex="104">
<input style="display: inline-block;" maxlength="3" size="3" name="mobile_phone_prefix" value="{$mobile_phone_prefix}" tabindex="105">
<input style="display: inline-block;" maxlength="4" size="4" name="mobile_phone_number" value="{$mobile_phone_number}" tabindex="106">
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
	$select = '<select tabindex="107" name="mobile_network_carrier_id">';
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
	<td width="10%"><input maxlength="50" size="25" name="email" value="{$email}" tabindex="108" style="width:150px;"></td>
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
	<td width="10%"><input maxlength="50" size="25" name="screen_name" value="{$screen_name}" tabindex="109" style="width:150px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

{*
<tr>
<td nowrap>Password</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input type="password" name="password" value="{$password}" maxlength="14" size="25" tabindex="110" style="width:150px;"></td>
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
	<td><input type="password" name="password2" value="{$password2}" maxlength="14" size="25" tabindex="111" style="width:150px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

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
		$select = '<select tabindex="112" name="security_question">';
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
	<td><input maxlength="50" size="25" name="security_answer" value="{$security_answer}" tabindex="113" style="width:150px;"></td>
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
	<td width="10%"><input type="hidden" name="MAX_FILE_SIZE" value="4000000"><input type="file" name="picture" tabindex="219"></td>
	<td>&nbsp;(Optional)</td>
	</tr>
	</table>
</td>
</tr>
*}

</table>
</div>

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
