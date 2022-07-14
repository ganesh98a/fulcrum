<?php

function renderGcBudgetLineItemBidInvitationsAsBootstrapDropdown($database, $arrGcBudgetLineItemBidInvitations, $debugMode=false)
{
	$htmlContent =
	'
	<button class="btn btn-default dropdown-toggle file-dropdown" type="button" data-toggle="dropdown">
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu dropdown-menu-right" role="menu">
	';
	foreach ($arrGcBudgetLineItemBidInvitations as $gc_budget_line_item_bid_invitation_id => $gcBudgetLineItemBidInvitation) {
		$gc_budget_line_item_bid_invitation_file_manager_file_id = $gcBudgetLineItemBidInvitation->gc_budget_line_item_bid_invitation_file_manager_file_id;
		$fileManagerFile = FileManagerFile::findById($database, $gc_budget_line_item_bid_invitation_file_manager_file_id);
		$virtual_file_name = '';
		$fileUrl = '';
		if ($fileManagerFile) {
			$fileUrl = $fileManagerFile->generateUrl();
			$virtual_file_name = $fileManagerFile->virtual_file_name;
		}
		if ($debugMode) {
			$virtual_file_name = '('.$gc_budget_line_item_bid_invitation_id.') '.$virtual_file_name;
		}
		$htmlContent .= '<li><a tabindex="-1" target="_blank" href="'.$fileUrl.'">'.$virtual_file_name.'</a></li>';
	}
	$htmlContent .= '</ul>';

	return $htmlContent;
}
