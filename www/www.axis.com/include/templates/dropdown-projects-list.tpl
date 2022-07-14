
{if !isset($dropdownProjectListStyle) || empty($dropdownProjectListStyle)}
	{php}
		$dropdownProjectListStyle = '';
		$template->assign("dropdownProjectListStyle", $dropdownProjectListStyle);
	{/php}
{/if}

{if isset($dropdownProjectListOnChange) && !empty($dropdownProjectListOnChange)}
{html_options id="project_id" name=project_id options=$arrProjectOptions selected=$selectedProject onchange="{$dropdownProjectListOnChange}" style="{$dropdownProjectListStyle}"}
{else}
{html_options id="project_id" name=project_id options=$arrProjectOptions selected=$selectedProject style="{$dropdownProjectListStyle}"}
{/if}
