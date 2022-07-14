<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * This page has three states:
 * 1) Show Nothing
 * 2) Read Only
 * 3) Allow Writes
 */


if ($myCompanyDataCase) {
	if (!$userCanViewMyCompanyTrades && !$userCanManageMyCompanyTrades) {
		// No access so show nothing.
		return '';
	}
}


if (!$myCompanyDataCase) {
	if (!$userCanViewThirdPartyCompanyTrades && !$userCanManageThirdPartyCompanyTrades) {
		// No access so show nothing.
		return '';
	}
}

	if ( $contact_company_id != 0 ) {
?>
		<td>
		<div class="contactSectionHeader">Trades Performed  <?=$companyName;?></div>
		<table class="contactSectionTableTrade width100-per" style="border:none;">
<?php
		if (($myCompanyDataCase && $userCanManageMyCompanyTrades) || (!$myCompanyDataCase && $userCanManageThirdPartyCompanyTrades)) {
			$contactCompanyTradesTable = getContactCompanyTradesTable($database, $user_company_id, $contact_company_id, true);
			$createTradeDropDownForUserCompanyId = createTradeDropDownForUserCompanyId($database, $user_company_id, $userRole);
?>
			<tr>
			<td>
				<input id="search--contact_company_trades" onfocus="clearElementValue(this);" onblur="clearElementValue(this); closeContactCompanyTradesAutocompleteWidget();" placeholder="Search Trades" style="margin-bottom: 10px; width: 395px;" type="text">
				<div id="search--contact_company_trades--results"></div>
				<?=$createTradeDropDownForUserCompanyId;?>
			</td>
			<td class="listTradeTd">
			<input id="search--contact_company_trades--close_button" class="jqueryHidden smallButton" onclick="closeContactCompanyTradesAutocompleteWidget();" type="button" value="clear results">
			<div id="divCompanyTrade" class="listTradeDetails"><?=$contactCompanyTradesTable;?></div>
			</td>
			</tr>

			<tr>
			<td>
			<input id="btnAddTradeToCompany" name="btnAddTradeToCompany" type="button" value="Add Selected Trade" onclick="addTradeToCompany()">
			</td>
			</tr>
<?php
		} elseif (($myCompanyDataCase && $userCanViewMyCompanyTrades) || (!$myCompanyDataCase && $userCanViewThirdPartyCompanyTrades)) {
			// Read-only case.
			$contactCompanyTradesTable = getContactCompanyTradesTable($database, $user_company_id, $contact_company_id, false);
?>
			<tr>
			<td>&nbsp;</td>
			<td class="listTradeTd">
			<div id="divCompanyTrade" class="listTradeDetails"><?=$contactCompanyTradesTable;?></div>
			</td>
			</tr>
<?php
		}
?>
		</table>
		<script>
			initializeContactCompanyTradesAutocompleteWidget();
		</script>
		</td>
<?php
	}
	/**/
?>
