<?php /* Smarty version Smarty-3.0.8, created on 2022-07-05 13:45:08
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-create-draw.tpl" */ ?>
<?php /*%%SmartyHeaderCode:677162c424443eefe7-15228083%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d4fd88e2f8f59982ab28cb41b42b63732c3e165' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-create-draw.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '677162c424443eefe7-15228083',
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
   <!-- Application Number:
   Through Date: -->
   <div class="paymentapp-detail">
      <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('drawId')->value;?>
" id="manage_draw--draw_id">
      <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('applicationId')->value;?>
" id="manage_draw--draw_app_id">
      <div class="gridview">
        <div id="createDrawForm" class="appdetail">
        <?php echo $_smarty_tpl->getVariable('createDrawForm')->value;?>

      </div>
  <div id="completion-percentage-confirm"></div>
      </div>
      <div class="signblock">
       <?php if ((isset($_smarty_tpl->getVariable('type',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('type',null,true,false)->value)){?>
       <h3>Retention Signature Blocks</h3>
       <?php }else{ ?>
        <h3>Draw Signature Blocks</h3>
        <?php }?>
        <?php echo $_smarty_tpl->getVariable('signatureDrawContent')->value;?>

      </div>
   </div>
  <?php }?>
</div>
<div id="dialog-confirmation"></div>

