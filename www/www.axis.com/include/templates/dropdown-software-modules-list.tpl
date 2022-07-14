
{if !isset($dropdownSoftwareModuleListStyle) || empty($dropdownSoftwareModuleListStyle)}
{php}$dropdownSoftwareModuleListStyle = '';{/php}
{/if}

{if isset($dropdownSoftwareModuleListOnChange) && !empty($dropdownSoftwareModuleListOnChange)}
{html_options id="ddl_software_module_id" name=ddl_software_module_id options=$arrSoftwareModuleOptions selected=$selectedSoftwareModule onchange="{$dropdownSoftwareModuleListOnChange}" style="{$dropdownSoftwareModuleListStyle}"}
{else}
{html_options id="ddl_software_module_id" name=ddl_software_module_id options=$arrSoftwareModuleOptions selected=$selectedSoftwareModule style="{$dropdownSoftwareModuleListStyle}"}
{/if}
