<?php /* Smarty version Smarty-3.0.8, created on 2017-06-15 16:12:00
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/security-information-form-inputs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:136017265359426478284e19-05037031%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '33bfcb98df65b6866067a8295f9ee092f1efb6c9' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/security-information-form-inputs.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '136017265359426478284e19-05037031',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_block_php')) include '/var/www/myfulcrum/engine/include/smarty-3.0.8/plugins/block.php.php';
?>
<div style="padding: 0 7px;"><strong>Required Account Information</strong></div>
<div class="requiredAccountInfoBox">
<table border="0" cellspacing="2" cellpadding="2">

<tr>
<td nowrap>Alerts</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><b><input id="emailAlert" type="checkbox" value="emailAlert" name="alertTypes[]" <?php echo $_smarty_tpl->getVariable('alertsEmailChecked')->value;?>
 tabindex="115"></b></td>
	<td><b>Receive Alerts via Email</b>* Required Field</td>
	<td></td>
	</tr>

	<tr>
	<td><b><input id="smsAlert" onclick="updateSmsAlertRows();" type="checkbox" value="smsAlert" name="alertTypes[]" <?php echo $_smarty_tpl->getVariable('alertsSmsChecked')->value;?>
 tabindex="114"></b></td>
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
<input id="mobile_phone_area_code" style="display: inline;" maxlength="3" size="3" name="mobile_phone_area_code" value="<?php echo $_smarty_tpl->getVariable('mobile_phone_area_code')->value;?>
" tabindex="104">
<input style="display: inline-block;" maxlength="3" size="3" name="mobile_phone_prefix" value="<?php echo $_smarty_tpl->getVariable('mobile_phone_prefix')->value;?>
" tabindex="105">
<input style="display: inline-block;" maxlength="4" size="4" name="mobile_phone_number" value="<?php echo $_smarty_tpl->getVariable('mobile_phone_number')->value;?>
" tabindex="106">
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
	<?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

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
	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

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
	<td width="10%"><input maxlength="50" size="25" name="email" value="<?php echo $_smarty_tpl->getVariable('email')->value;?>
" tabindex="108" style="width:150px;"></td>
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
	<td width="10%"><input maxlength="50" size="25" name="screen_name" value="<?php echo $_smarty_tpl->getVariable('screen_name')->value;?>
" tabindex="109" style="width:150px;"></td>
	<td>* Required Field</td>
	</tr>
	</table>
</td>
</tr>

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
