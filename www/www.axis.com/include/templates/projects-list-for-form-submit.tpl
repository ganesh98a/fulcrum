
<select id="{$projectsListForFormSubmitProjectId}" name="{$projectsListForFormSubmitProjectId}">
{foreach $arrProjectsListForFormSubmit as $row}
	{if ({$row.project_id} == {$projectsListForFormSubmitProjectId})}
		<option value="{$row.project_id}" selected>{$row.name}</option>
	{else}
		<option value="{$row.project_id}">{$row.name}</option>
	{/if}
{/foreach}
</select>
