<?php

function renderProjectBidInvitationsAsBootstrapDropdown($database, $arrProjectBidInvitations, $debugMode=false)
{
	$htmlContent =
	'
	<button class="btn btn-default dropdown-toggle file-dropdown" type="button" data-toggle="dropdown">
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu dropdown-menu-right" role="menu">
	';
	foreach ($arrProjectBidInvitations as $project_bid_invitation_id => $projectBidInvitation) {
		$project_bid_invitation_file_manager_file_id = $projectBidInvitation->project_bid_invitation_file_manager_file_id;
		$fileManagerFile = FileManagerFile::findById($database, $project_bid_invitation_file_manager_file_id);
		$virtual_file_name = '';
		$fileUrl = '';
		if ($fileManagerFile) {
			$fileUrl = $fileManagerFile->generateUrl();
			$virtual_file_name = $fileManagerFile->virtual_file_name;
		}
		if ($debugMode) {
			$virtual_file_name = '('.$project_bid_invitation_id.') '.$virtual_file_name;
		}
		$htmlContent .= '<li><a tabindex="-1" target="_blank" href="'.$fileUrl.'">'.$virtual_file_name.'</a></li>';
	}
	$htmlContent .= '</ul>';

	return $htmlContent;
}
