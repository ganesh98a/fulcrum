<?php /* Smarty version Smarty-3.0.8, created on 2017-06-19 17:36:19
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/account-web.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9743020095947be3b3f12e9-04517542%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '858487f436f0553feac76357eae596554c8f4334' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/account-web.tpl',
      1 => 1454599050,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9743020095947be3b3f12e9-04517542',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table border="0" cellpadding="3" cellspacing="0" width="100%">

<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))){?>
	<tr><td nowrap><?php echo preg_replace('!\s+!u', ' ',$_smarty_tpl->getVariable('htmlMessages')->value);?>
</td></tr>
<?php }?>

<?php if ((isset($_smarty_tpl->getVariable('accountMessages',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('accountMessages',null,true,false)->value))){?>
	<tr>
		<td>
			&nbsp;<b>[Account Summary]</b>
			<br>
			<?php echo preg_replace('!\s+!u', ' ',$_smarty_tpl->getVariable('accountMessages')->value);?>

		</td>
	</tr>
<?php }?>

<?php if (isset($_smarty_tpl->getVariable('debugMode',null,true,false)->value)&&$_smarty_tpl->getVariable('debugMode')->value){?>
<tr>
<td style="width: 100%; height: 400px; vertical-align: top;">
<?php if ((isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=='global_admin'))){?>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	GLOBAL ADMIN MENU SECTION
	<div><a href="/impersonate-users-form.php">Impersonate a Fulcrum User</a></div>
	<div><a href="/admin-user-company-creation-form.php">Create/Edit Fulcrum Customers (User Companies)</a></div>
	<div><a href="/admin-user-creation-form.php">Create/Edit Fulcrum Users</a></div>
	</div>
<?php }?>
<?php if ((isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&(($_smarty_tpl->getVariable('userRole')->value=='global_admin')||($_smarty_tpl->getVariable('userRole')->value=='admin')))){?>
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	ACCOUNT ADMIN MENU SECTION
	<div><a href="/modules-contacts-manager-form.php">Manage Contacts</a></div>
	<div><a href="/modules-permissions-form.php">Manage Project Roles &amp; Permissions</a></div>
	<div><a href="/admin-projects.php">Manage Projects</a></div>
	<div><a href="/modules-gc-budget-form.php">Manage Project Budgets</a></div>
	<div><a href="/modules-gc-budget-import-line-items-form.php">Manage Project Budgets &gt; Import Line Items</a></div>
	</div>
<?php }?>
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	ALL ACCOUNT USER LEVELS MENU SECTION
	<div><a href="modules-file-manager-form.php">File Manager Module - Test File Uploader</a></div>
	<div><a href="modules-file-manager-file-browser.php">File Manager Module - Web-based Virtual File System with CAS</a></div>
	<div><a href="ajax-file-upload.php">File Manager Module - Ajax Upload Tester</a></div>
	<div><a href="account-management-email-form.php">Change Your Email Address</a></div>
	<div><a href="account-management-password-form.php">Change Your Password</a></div>
	<div><a href="account-management-security-information-form.php">Manage Your Required Account Information</a></div>
	<div><a href="account-management-user-details-form.php">Manage Your Optional Account Information</a></div>
	</div>

<?php if ((isset($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('userRole',null,true,false)->value)&&($_smarty_tpl->getVariable('userRole')->value=='global_admin'))){?>
	<br>
	<br>
	<br>
	<br>
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	QA: INVALID INPUT TEST CASES MENU SECTION (MISSING OR INVALID GET/POST/RAW POST)
	<div><a href="/account-management-email-form-submit.php">Change Your Email Address</a></div>
	<div><a href="/account-management-password-form-submit.php">Change Your Password</a></div>
	<div><a href="/account-management-security-information-form-submit.php">Manage Your Required Account Information</a></div>
	<div><a href="/account-management-user-details-form-submit.php">Manage Your Optional Account Information</a></div>
	<div><a href="/admin-user-company-creation-form-submit.php">Create/Edit Fulcrum Customers (User Companies)</a></div>
	<div><a href="/admin-user-creation-form-submit.php">Create a New Fulcrum User</a></div>
	<div><a href="/impersonate-users-form-submit.php">Impersonate a User</a></div>
	<div><a href="/modules-gc-budget-form-submit.php">Manage Project Budgets</a></div>
	<div><a href="/modules-gc-budget-import-line-items-form-submit.php">Manage Project Budgets &gt; Import Line Items</a></div>
	</div>
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	QA: HACKER TEST CASES MENU SECTION
	<div><a href="/impersonate-users-form-submit.php?impersonated_user_company_id=1&impersonated_user_id=6">Impersonate a User</a></div>
	</div>
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	QA: SQL INJECTION TEST CASES MENU SECTION
	<div><a href="/impersonate-users-form-submit.php?impersonated_user_company_id=1&impersonated_user_id=6">Impersonate a User</a></div>
	</div>
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	QA: CROSS-SITE SCRIPTING TEST CASES MENU SECTION
	<div><a href="/impersonate-users-form-submit.php?impersonated_user_company_id=1&impersonated_user_id=6">Impersonate a User</a></div>
	</div>
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	QA: SESSION HIJACKING & FIXATION TEST CASES MENU SECTION
	<div><a href="/impersonate-users-form-submit.php?impersonated_user_company_id=1&impersonated_user_id=6">Impersonate a User</a></div>
	</div>

<?php }?>
</td>
</tr>
<?php }?>

<tr>
<td><h2 style="color: #111987; float: left;"><i><span id="ajax_include_header_id"></span></i></h2></td>
</tr>

<tr>
<td>
	<div id="ajax_include_body_id"></div>
</td>
</tr>
</table>
