<table border="0" cellpadding="3" cellspacing="0" width="100%">

{*
<tr>
<td height="20" valign="middle" width="100%">
<div class="headerStyle">Authenticated Home Page / Fulcrum User Account Home Page</div>
<div style="float: right; padding: 4px 0;"><!--<a href="account-management.php">Manage Your Account</a>--></div>
</td>
</tr>
*}

{if (isset($htmlMessages) && !empty($htmlMessages)) }
	<tr><td nowrap>{$htmlMessages|strip}</td></tr>
{/if}

{if (isset($accountMessages) && !empty($accountMessages)) }
	<tr>
		<td>
			&nbsp;<b>[Account Summary]</b>
			<br>
			{$accountMessages|strip}
		</td>
	</tr>
{/if}

{if isset($debugMode) && $debugMode }
<tr>
<td style="width: 100%; height: 400px; vertical-align: top;">

{* GLOBAL ADMIN MENU SECTION *}
{if (isset($userRole) && !empty($userRole) && ($userRole == 'global_admin'))}
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	GLOBAL ADMIN MENU SECTION
	<div><a href="/impersonate-users-form.php">Impersonate a Fulcrum User</a></div>
	<div><a href="/admin-user-company-creation-form.php">Create/Edit Fulcrum Customers (User Companies)</a></div>
	<div><a href="/admin-user-creation-form.php">Create/Edit Fulcrum Users</a></div>
	</div>
{/if}

{* ACCOUNT ADMIN MENU SECTION *}
{if (isset($userRole) && !empty($userRole) && (($userRole == 'global_admin') || ($userRole == 'admin')))}
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	ACCOUNT ADMIN MENU SECTION
	<div><a href="/modules-contacts-manager-form.php">Manage Contacts</a></div>
	<div><a href="/modules-permissions-form.php">Manage Project Roles &amp; Permissions</a></div>
	{*<div><a href="/admin-projects-form.php">Manage Projects</a></div>*}
	<div><a href="/admin-projects.php">Manage Projects</a></div>
	<div><a href="/modules-gc-budget-form.php">Manage Project Budgets</a></div>
	{**}
	<div><a href="/modules-gc-budget-import-line-items-form.php">Manage Project Budgets &gt; Import Line Items</a></div>
	{**}
	</div>
{/if}

{* ALL ACCOUNT USER LEVELS MENU SECTION *}
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

{if (isset($userRole) && !empty($userRole) && ($userRole == 'global_admin'))}
	{* INVALID INPUT TEST CASES MENU SECTION (MISSING OR INVALID GET/POST/RAW POST) *}
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

{* HACKER TEST CASES MENU SECTION *}
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	QA: HACKER TEST CASES MENU SECTION
	<div><a href="/impersonate-users-form-submit.php?impersonated_user_company_id=1&impersonated_user_id=6">Impersonate a User</a></div>
	</div>

{* SQL INJECTION TEST CASES MENU SECTION *}
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	QA: SQL INJECTION TEST CASES MENU SECTION
	<div><a href="/impersonate-users-form-submit.php?impersonated_user_company_id=1&impersonated_user_id=6">Impersonate a User</a></div>
	</div>

{* CROSS-SITE SCRIPTING TEST CASES MENU SECTION *}
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	QA: CROSS-SITE SCRIPTING TEST CASES MENU SECTION
	<div><a href="/impersonate-users-form-submit.php?impersonated_user_company_id=1&impersonated_user_id=6">Impersonate a User</a></div>
	</div>

{* SESSION HIJACKING & FIXATION TEST CASES MENU SECTION *}
	<br>
	<div style="border: 2px dashed #ccc; margin: 4px; padding: 4px;">
	QA: SESSION HIJACKING & FIXATION TEST CASES MENU SECTION
	<div><a href="/impersonate-users-form-submit.php?impersonated_user_company_id=1&impersonated_user_id=6">Impersonate a User</a></div>
	</div>

{/if}
</td>
</tr>
{/if}

<tr>
<td><h2 style="color: #111987; float: left;"><i><span id="ajax_include_header_id"></span></i></h2></td>
</tr>

<tr>
<td>
	<div id="ajax_include_body_id"></div>
</td>
</tr>
</table>
