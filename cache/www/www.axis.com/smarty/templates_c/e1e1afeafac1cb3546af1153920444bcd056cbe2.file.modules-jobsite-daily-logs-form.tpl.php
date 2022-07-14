<?php /* Smarty version Smarty-3.0.8, created on 2017-06-17 12:49:45
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/modules-jobsite-daily-logs-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5198773105944d811b9bc90-02134524%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1e1afeafac1cb3546af1153920444bcd056cbe2' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/modules-jobsite-daily-logs-form.tpl',
      1 => 1454384372,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5198773105944d811b9bc90-02134524',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="dcr" style="width: 1150px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableDateSelection">

		<tr>
		<td width="16%" rowspan="2">
			<select id="ddlDate" onchange="ddlDateChanged();" style="margin-right:15px">
				<option value="0"><?php echo $_smarty_tpl->getVariable('today')->value;?>
</option>
				<option value="1"><?php echo $_smarty_tpl->getVariable('yesterday')->value;?>
</option>
				<option value="2"><?php echo $_smarty_tpl->getVariable('twoDaysAgo')->value;?>
</option>
			</select>
		</td>
		<td width="23%" align="left"><span>CREATED BY:</span> <?php echo $_smarty_tpl->getVariable('createdBy')->value;?>
</td>
		<td width="22%" align="left"><span>CREATED ON:</span> <?php echo $_smarty_tpl->getVariable('createdAt')->value;?>
</td>
		<td width="14%" align="left"><span>AM TEMP:</span> <?php echo $_smarty_tpl->getVariable('amTemperature')->value;?>
</td>
		<td width="25%" align="left"><span>AM CONDITION:</span> <?php echo $_smarty_tpl->getVariable('amCondition')->value;?>
</td>
		</tr>

		<tr>
		<td align="left"><span>MODIFIED BY:</span> <?php echo $_smarty_tpl->getVariable('modifiedBy')->value;?>
</td>
		<td align="left" nowrap><span>MODIFIED ON:</span> <?php echo $_smarty_tpl->getVariable('modifiedAt')->value;?>
&nbsp;&nbsp;</td>
		<td align="left"><span>PM TEMP:</span> <?php echo $_smarty_tpl->getVariable('pmTemperature')->value;?>
</td>
		<td align="left"><span>PM CONDITION:</span> <?php echo $_smarty_tpl->getVariable('pmCondition')->value;?>
</td>
		</tr>

	</table>
	<div class="divTabs">
		<ul>
			<li><a id="manpowerTab" class="tab <?php echo $_smarty_tpl->getVariable('manpowerSelected')->value;?>
" onclick="tabClicked(this, '1');">Manpower</a></li>
			<li><a id="siteworkTab" class="tab <?php echo $_smarty_tpl->getVariable('siteworkSelected')->value;?>
" onclick="tabClicked(this, '2');">Sitework</a></li>
			<li><a id="buildingTab" class="tab <?php echo $_smarty_tpl->getVariable('buildingSelected')->value;?>
" onclick="tabClicked(this, '3');">Building</a></li>
			<li><a id="detailsTab" class="tab <?php echo $_smarty_tpl->getVariable('detailsSelected')->value;?>
"  onclick="tabClicked(this, '4');">Details</a></li>
			<li><a id="dcrPreviewTab" class="tab <?php echo $_smarty_tpl->getVariable('previewSelected')->value;?>
"  onclick="tabClicked(this, '5');">DCR Preview</a></li>
<?php if ((isset($_smarty_tpl->getVariable('displayJobsiteDailyLogAdminTab',null,true,false)->value)&&$_smarty_tpl->getVariable('displayJobsiteDailyLogAdminTab')->value)){?>
			<li><a id="adminTab" class="tab <?php echo $_smarty_tpl->getVariable('adminSelected')->value;?>
" onclick="tabClicked(this, '6');">Admin</a></li>
<?php }?>
		</ul>
	</div>
	<div id="tabContent">
		<?php echo $_smarty_tpl->getVariable('tabContent')->value;?>

	</div>
	<input type="hidden" id="selectedDateIndex" value="<?php echo $_smarty_tpl->getVariable('selectedDateIndex')->value;?>
">
	<input type="hidden" id="jobsite_daily_log_id" value="<?php echo $_smarty_tpl->getVariable('jobsite_daily_log_id')->value;?>
">
	<input type="hidden" id="activeTab" value="<?php echo $_smarty_tpl->getVariable('activeTab')->value;?>
">

	<?php echo $_smarty_tpl->getVariable('fineUploaderTemplate')->value;?>


</div>
