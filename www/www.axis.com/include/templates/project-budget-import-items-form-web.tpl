<table border="0" cellpadding="3" cellspacing="0" width="100%">
	<tr>
		<td colspan="2" height="20" valign="middle" width="100%">
			<div class="headerStyle">Development BudgetsHERE &mdash; Import Budget Items</div>
			<div style="float: right; padding: 4px 0;">TEST<!--<a href="account-management.php">Manage Your Account</a>--></div>
		</td>
	</tr>
	<tr>
		<td id="messageList" colspan="2" nowrap>{$htmlMessages|strip}</td>
	</tr>

	<tr>
		<td valign="top">
			<table id="tblSystemDefaultBudgetItems" border="1" cellpadding="3" cellspacing="0" width="100%">
				<tr>
					<th></th>
					<th height="20" valign="middle">
						<h2 style="color: #111987; text-align: left;">{$currentlySelectedProjectName} (import into this project)</h2>
					</th>
				</tr>

				{foreach $arrCurrentlySelectedGcBudgetLineItems as $row}
					{assign var='i' value={counter}}
					<tr>
						<td><input type="checkbox" name="row_{$i}_checkbox" value="{$row.gc_budget_line_item_id}"></td>
						<td>{$row.cost_code} &mdash; {$row.cost_code_description}</td>
					</tr>
				{/foreach}
			</table>
		</td>
		<td valign="top">
			<form action="/modules-gc-budget-import-line-items-form-submit.php?importFromProjectUserCompanyId={$importFromProjectUserCompanyId}&importFromProjectId={$importFromProjectId}" method="post" name="frmTabularData">
				<table id="tblSystemDefaultBudgetItems" border="1" cellpadding="3" cellspacing="0" width="100%">
					<tr>
						<th></th>
						<th height="20" valign="middle">
							<h2 style="color: #111987; text-align: left;">Import From Project Budget {include file="dropdown-projects-list.tpl"}</h2>
						</th>
					</tr>

					{foreach $arrImportFromGcBudgetLineItems as $row}
						{assign var='i' value={counter}}
						<tr>
							<td><input type="checkbox" name="row_{$i}_checkbox" value="{$row.gc_budget_line_item_id}"></td>
							<td>{$row.cost_code} &mdash; {$row.cost_code_description}</td>
						</tr>
					{/foreach}
				</table>
				<br>
				<div>
					<input type="submit" value="Import Selected Budget Items">
					<input class="button" onclick="window.location='modules-gc-budget-import-line-items-form-reset.php?importFromProjectUserCompanyId={$importFromProjectUserCompanyId}&importFromProjectId={$importFromProjectId}'" type="button" value="Reset Form">
				</div>
			</form>
		</td>
	</tr>
</table>