<?php /* Smarty version Smarty-3.0.8, created on 2022-07-13 13:41:22
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/rightclick-menu-entypo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:705562ceaf62bded58-28114305%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4303e06c3404370f2b62742cc3d9f3a8f4b14297' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/rightclick-menu-entypo.tpl',
      1 => 1637146413,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '705562ceaf62bded58-28114305',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<ul id="rightClickMenu" class="rightClickMenu">
	<?php if ((!$_smarty_tpl->getVariable('guest')->value)){?>
	<li class="new">				<span class="entypo entypo-folder"></span>			<a href="#newFolder">New Subfolder</a></li>
	<li class="upload">				<span class="entypo entypo-upload"></span>			<a href="#upload">Upload</a></li>
	<?php }?>
	<li class="download">			<span class="entypo entypo-download"></span>		<a href="#download">Download</a></li>	
	<?php if ((!$_smarty_tpl->getVariable('guest')->value)){?>
	<li class="link">				<span class="entypo entypo-link"></span>			<a href="#getLink">Get Link</a></li>
	<li class="restore separator">	<span class="entypo entypo-level-up"></span>		<a href="#restore">Restore</a></li>
	<li class="delete separator">	<span class="entypo entypo-trash"></span>			<a href="#delete">Delete</a></li>
	<!-- <li class="deletePermanent">	<span class="entypo entypo-trash"></span> 			<a href="#deletePermanent">Annihilate!</a></li> -->
	<li class="deletePermanent">	<span class="entypo entypo-trash"></span> 			<a href="#deletePermanent">Vanquish!</a></li>
	<li class="edit">				<span class="entypo entypo-pencil"></span>			<a href="#rename">Rename</a></li>
	<li class="zip separator">		<span class="entypo entypo-install"></span>			<a href="#extract">Extract</a></li>
	<li class="details separator">	<span class="entypo entypo-list"></span>	<a id="btnMenuShowInfo" href="#loadDetails">Show Properties</a></li>
	<li class="emptyTrash">			<span class="entypo entypo-flash"></span>			<a href="#emptyTrash">Empty Trash</a></li>
	<li class="cancel">				<span class="entypo entypo-cancel-circled"></span>	<a href="#cancel">Cancel</a></li>
	<?php }?>
</ul>
