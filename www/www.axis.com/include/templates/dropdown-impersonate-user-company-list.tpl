
{if isset($dropdownImpersonateUserCompanyListOnChange) && !empty($dropdownImpersonateUserCompanyListOnChange)}
{html_options id="impersonated_user_company_id" name=impersonated_user_company_id options=$arrImpersonatedUserCompanyOptions selected=$selectedImpersonatedUserCompany onchange="{$dropdownImpersonateUserCompanyListOnChange}" tabindex="1"}
{else}
{html_options id="impersonated_user_company_id" name=impersonated_user_company_id options=$arrImpersonatedUserCompanyOptions selected=$selectedImpersonatedUserCompany tabindex="1"}
{/if}
