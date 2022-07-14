
{if isset($dropdownUserCompanyListOnChange) && !empty($dropdownUserCompanyListOnChange)}
{html_options id="ddl_user_company_id" name=ddl_user_company_id options=$arrUserCompanyOptions selected=$selectedUserCompany onchange="{$dropdownUserCompanyListOnChange}"}
{else}
{html_options id="ddl_user_company_id" name=ddl_user_company_id options=$arrUserCompanyOptions selected=$selectedUserCompany}
{/if}
