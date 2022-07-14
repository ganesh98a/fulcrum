
{if isset($dropdownProjectTypeListOnChange) && !empty($dropdownProjectTypeListOnChange)}
{html_options id="ddl_project_type_id" name=ddl_project_type_id options=$arrProjectTypeOptions selected=$selectedProjectType onchange="{$dropdownProjectTypeListOnChange}"}
{else}
{html_options id="ddl_project_type_id" name=ddl_project_type_id options=$arrProjectTypeOptions selected=$selectedProjectType}
{/if}
