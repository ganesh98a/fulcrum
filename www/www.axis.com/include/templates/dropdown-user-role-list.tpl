
{if isset($dropdownUserRoleListOnChange) && !empty($dropdownUserRoleListOnChange)}
{html_options id="ddl_user_role_id" name=ddl_user_role_id options=$arrUserRoles selected=$selectedUserRole onchange="{$dropdownUserRoleListOnChange}"}
{else}
{html_options id="ddl_user_role_id" name=ddl_user_role_id options=$arrUserRoles selected=$selectedUserRole}
{/if}
