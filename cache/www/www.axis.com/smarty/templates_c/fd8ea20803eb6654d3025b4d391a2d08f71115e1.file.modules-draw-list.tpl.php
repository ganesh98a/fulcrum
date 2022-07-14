<?php /* Smarty version Smarty-3.0.8, created on 2022-07-05 13:44:57
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-draw-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1265762c424393f7b14-24495201%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd8ea20803eb6654d3025b4d391a2d08f71115e1' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-draw-list.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1265762c424393f7b14-24495201',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="draws_list" class="custom_delay_padding grid_view custom_datatable_style">
  <?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
  <div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
  <?php }else{ ?>
  <?php if (($_smarty_tpl->getVariable('userCanViewDraws')->value)||($_smarty_tpl->getVariable('userCanEditDraws')->value)){?>
  <div id="drawStatusDropdown"><?php echo $_smarty_tpl->getVariable('drawStatus')->value;?>
</div>
  <?php }?>
  <?php if (($_smarty_tpl->getVariable('userCanEditDraws')->value)){?>
  <input type="button" onclick="checkProjectRetainerRate()" value="Create Draws" style="margin-bottom:15px;margin-left:10px">
   <input type="button" onclick="createRetentionDraw()" value="Create Retention Draw" style="margin-bottom:15px;margin-left:10px">
  <?php }?>
  <?php if (($_smarty_tpl->getVariable('userCanViewDraws')->value)||($_smarty_tpl->getVariable('userCanEditDraws')->value)){?>
  <input type="button" onclick="printDrawList()" value="Print List View" style="margin-bottom:15px">
  <?php }?>
  <input id="drawDraftCount" value="<?php echo $_smarty_tpl->getVariable('drawDraftCount')->value;?>
" type="hidden">
  <input id="drawRetentionCount" value="" type="hidden">
  <div id="drawListTable" style="max-width: 1080px !important;"><?php echo $_smarty_tpl->getVariable('drawListTable')->value;?>
</div>
  <div id="retainer-rate-confirm"></div>
  <?php }?>
</div>
<div id="dialog-confirmation"></div>
