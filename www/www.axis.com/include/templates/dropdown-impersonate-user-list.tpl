
{if isset($dropdownImpersonateUserListOnChange) && !empty($dropdownImpersonateUserListOnChange)}
{html_options id="impersonated_user_id" name=impersonated_user_id options=$arrImpersonatedUserOptions selected=$selectedImpersonatedUser onchange="{$dropdownImpersonateUserListOnChange}" tabindex="2"}
{else}
{html_options id="impersonated_user_id" name=impersonated_user_id options=$arrImpersonatedUserOptions selected=$selectedImpersonatedUser tabindex="2"}
{/if}
