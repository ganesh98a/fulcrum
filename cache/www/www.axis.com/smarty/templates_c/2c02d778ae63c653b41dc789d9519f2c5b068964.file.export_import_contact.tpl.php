<?php /* Smarty version Smarty-3.0.8, created on 2022-01-25 13:59:18
         compiled from "export_import_contact.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1767461eff426b4f171-38655205%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c02d778ae63c653b41dc789d9519f2c5b068964' => 
    array (
      0 => 'export_import_contact.tpl',
      1 => 1631167903,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1767461eff426b4f171-38655205',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="div_permission" class="custom_delay_padding grid_view custom_datatable_style">
	<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo $_smarty_tpl->getVariable('importHtmlContent')->value;?>

			</div>
		</div
		
	</div>   <!-- manage role div -->
    <?php }?>
</div>