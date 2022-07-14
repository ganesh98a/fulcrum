<?php

require_once('lib/common/ActionItem.php');
require_once('lib/common/ActionItemAssignment.php');
require_once('lib/common/ActionItemPriority.php');
require_once('lib/common/ActionItemStatus.php');
require_once('lib/common/ActionItemType.php');
require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/DiscussionItem.php');
require_once('lib/common/DiscussionItemComment.php');
require_once('lib/common/DiscussionItemPriority.php');
require_once('lib/common/DiscussionItemRelationship.php');
require_once('lib/common/DiscussionItemStatus.php');
require_once('lib/common/DiscussionItemToActionItem.php');
require_once('lib/common/DiscussionItemToDiscussionItemComment.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/Log.php');
require_once('lib/common/Meeting.php');
require_once('lib/common/MeetingAttendee.php');
require_once('lib/common/MeetingLocation.php');
require_once('lib/common/MeetingLocationTemplate.php');
require_once('lib/common/MeetingType.php');
require_once('lib/common/MeetingTypeTemplate.php');
require_once('lib/common/MobileNetworkCarrier.php');
require_once('lib/common/MobilePhoneNumber.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/ProjectToWeatherUndergroundReportingStation.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/RequestForInformation.php');
require_once('lib/common/RequestForInformationAttachment.php');
require_once('lib/common/RequestForInformationNotification.php');
require_once('lib/common/RequestForInformationPriority.php');
require_once('lib/common/RequestForInformationRecipient.php');
require_once('lib/common/RequestForInformationResponse.php');
require_once('lib/common/RequestForInformationResponseType.php');
require_once('lib/common/RequestForInformationStatus.php');
require_once('lib/common/RequestForInformationType.php');
require_once('lib/common/Submittal.php');
require_once('lib/common/SubmittalStatus.php');
require_once('lib/common/Service/TableService.php');


require_once('page-components/dropDownListWidgets.php');
require_once('page-components/fileUploader.php');
require_once('app/models/permission_mdl.php');
require_once('lib/common/BidSpread.php');


function buildMeetingActionItemsTableByDiscussionItemId($arrActionItemsByDiscussionItemIds, $discussion_item_id, Input $input)
{
	$database = $input->database;
	$arrContactOptions = $input->arrContactOptions;
	$userCanCreateActionItems = $input->userCanCreateActionItems;
	$userCanManageMeetings = $input->userCanManageMeetings;
	$actionShowElement = $input->actionShowElement;
	$actionEditElement = $input->actionEditElement;
	$isPrintView = $input->isPrintView;

	if (isset($arrActionItemsByDiscussionItemIds[$discussion_item_id])) {
		$arrActionItemsByDiscussionItemId = $arrActionItemsByDiscussionItemIds[$discussion_item_id];
		$actionItemCount = count($arrActionItemsByDiscussionItemId);
	} else {
		$arrActionItemsByDiscussionItemId = array();
		$actionItemCount = 0;
	}

	$actionItemsTableByDiscussionItemIdTdAssignmentStyle = "action-table-td-assignment";
	$actionItemsTableByDiscussionItemIdTdDescriptionStyle = "action-table-td-description";
	if (isset($isPrintView) && $isPrintView) {
		$actionItemsTableByDiscussionItemIdTdAssignmentStyle = "action-table-td-assignment printView";
		$actionItemsTableByDiscussionItemIdTdDescriptionStyle = "action-table-td-description printView";
	}

	// Build the contacts drop down for new action items
	$selName = 'selNewAssignedTo_' . $discussion_item_id;
	//$selContacts = PageComponents::dropDownList($selName, $arrContactOptions, '', '', 'class="'.$actionEditElement.'" style="display: none;"');
	$selContacts = PageComponents::dropDownList($selName, $arrContactOptions);

	$dummyId = Data::generateDummyPrimaryKey();
	$attributeGroupName = 'create-action_item-record';

	$newActionItemTable = <<<END_NEW_ACTION_ITEM_TABLE

		<form id="frmNewActionItem_$discussion_item_id" name="frmNewActionItem_$discussion_item_id" style="display:none;">
		<table class="action-table-new">
			<tr>
				<th class="columnHeader">New Action</th>
				<th class="columnHeader">Assign To</th>
				<th class="columnHeader">Due Date</th>
				<th>&nbsp;</th>
			</tr>
			<tr valign="top">
				<td>
					<textarea id="$attributeGroupName--action_items--action_item--$dummyId" name="newAction_$discussion_item_id" class="autogrow" style="width:90%;"></textarea>
				</td>
				<td class="$actionItemsTableByDiscussionItemIdTdAssignmentStyle">
					$selContacts <input type="button" value="Assign" onclick="addAssigneeToNewAction('$discussion_item_id');">
					<ul id="record_list_container--action_item_assignments"></ul>
				</td>
				<td class="action-table-td-assignment-date">
					<input id="$attributeGroupName--action_items--action_item_due_date--$dummyId" name="newActionDueDate_$discussion_item_id" class="datepicker auto-hint" title="MM/DD/YYYY">
				</td>
				<td class="action-table-td-assignment-date">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<input id="create-action_item_assignment-record--action_item_assignments--discussion_item_id--$dummyId" type="hidden" value="$discussion_item_id">
					<input id="create-action_item_assignment-record--action_item_assignments--action_item_id--$dummyId" type="hidden" value="$dummyId">
					<input type="button" value="Save New Action Item" onclick="createActionItem('$attributeGroupName', '$dummyId', { responseDataType : 'json' });">
					<input type="button" value="Cancel" onclick="cancelNewActionItem('$discussion_item_id');">
				</td>
			</tr>
		</table>
		</form>

END_NEW_ACTION_ITEM_TABLE;

	if (!empty($arrActionItemsByDiscussionItemId)) {
		$actionItemsTableByDiscussionItemId = '
			<div class="headerActions" style="padding: 2px 25px 4px; font-size: 0.9em; font-weight: bold;">
				<a href="#">Action Items ('.$actionItemCount.')</a>
			</div>
			<div>
		';
		if ($userCanCreateActionItems || $userCanManageMeetings) {
			$actionItemsTableByDiscussionItemId .= $newActionItemTable;
		}
		$actionItemsTableByDiscussionItemId .= '
				<table class="action-table-list">
					<tr>
		';
		if (!isset($isPrintView) || !$isPrintView) {
			$actionItemsTableByDiscussionItemId .= '
						<th class="'.$actionEditElement.'">&nbsp;</th>
			';
		}
		$actionItemsTableByDiscussionItemId .= '
						<th class="columnHeader">Task</th>
						<th class="columnHeader">Assigned To</th>
						<th class="columnHeader">Due Date</th>
						<th class="columnHeader">Completed</th>
					</tr>
		';

		foreach ($arrActionItemsByDiscussionItemId AS $action_item_id => $actionItem) {
			/* @var $actionItem ActionItem */

			$project = $actionItem->getProject();
			/* @var $project Project */

			$actionItemType = $actionItem->getActionItemType();
			/* @var $actionItemType ActionItemType */

			$actionItemStatus = $actionItem->getActionItemStatus();
			/* @var $actionItemStatus ActionItemStatus */

			$actionItemPriority = $actionItem->getActionItemPriority();
			/* @var $actionItemPriority ActionItemPriority */

			$actionItemCostCode = $actionItem->getActionItemCostCode();
			/* @var $actionItemCostCode CostCode */

			$createdByContact = $actionItem->getCreatedByContact();
			/* @var $createdByContact Contact */

			//$created_by = $arrActions[$discussion_item_id][$action_item_id]['creatorName'];
			$created_by = $createdByContact->getContactFullName();

			$created = $actionItem->created;

			// Encoded Action Item Data
			// Encoded Action Item Data
			$actionItem->htmlEntityEscapeProperties();
			$action_item_title = $actionItem->action_item_title;
			$escaped_action_item_title = $actionItem->escaped_action_item_title;
			$action_item = $actionItem->action_item;
			$escaped_action_item = $actionItem->escaped_action_item;

			//$arrAssignees = $arrActions[$discussion_item_id][$action_item_id]['assignees'];
			$loadActionItemAssignmentsByActionItemIdOptions = new Input();
			$loadActionItemAssignmentsByActionItemIdOptions->forceLoadFlag = true;
			$arrActionItemAssignmentsByActionItemId = ActionItemAssignment::loadActionItemAssignmentsByActionItemId($database, $action_item_id, $loadActionItemAssignmentsByActionItemIdOptions);

			$action_item_due_date = $actionItem->action_item_due_date;
			$action_item_completed_timestamp = $actionItem->action_item_completed_timestamp;

			if (!isset($created_date) || $created_date == '0000-00-00') {
				$created_date = '';
			} else {
				$createdUnixTimestamp = strtotime($created);
				// $created_date = date('M j, Y g:ia', $createdUnixTimestamp);
				$created_date = date("m/d/Y",strtotime($created_date));
			}
			if (!isset($action_item_due_date) || $action_item_due_date == '0000-00-00') {
				$action_item_due_date = '';
			} else {
				// $action_item_due_date = date('M j, Y g:ia', strtotime($action_item_due_date));
				$action_item_due_date = date('m/d/Y g:ia', strtotime($action_item_due_date));
			}
			if (!isset($action_item_completed_timestamp) || $action_item_completed_timestamp == '0000-00-00 00:00:00') {
				$action_item_completed_timestamp = '';
			} else {
				// $action_item_completed_timestamp = date('M j, Y g:ia', strtotime($action_item_completed_timestamp));
				$action_item_completed_timestamp = date('m/d/Y g:ia', strtotime($action_item_completed_timestamp));
			}

			if ($userCanCreateActionItems || $userCanManageMeetings) {
				// Build the contacts drop down for each action item
				$selName = 'selActionAssignees_' . $action_item_id;
				$selContacts = PageComponents::dropDownList($selName, $arrContactOptions);
				$actionItemsTableByDiscussionItemId .= '
					<tr id="rowAction_'.$action_item_id.'" valign="top">
				';

				if (!isset($isPrintView) || !$isPrintView) {
					$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID
						<td class="$actionEditElement action-table-td-delete">
							<a class="smallerFont" onclick="Collaboration_Manager__Meetings__deleteActionItem($action_item_id);">X</a>
						</td>
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;
				}

				$actionItemsTableByDiscussionItemId .= '
						<td title="Created By '.$created_by.' On '.$created_date.'" class="'.$actionItemsTableByDiscussionItemIdTdDescriptionStyle.'">
							<span id="manage-action_item-record-read_only--action_items--action_item--'.$action_item_id.'" class="'.$actionShowElement.'">'.$escaped_action_item.'</span>
							<textarea id="manage-action_item-record--action_items--action_item--'.$action_item_id.'" name="edit_action_'.$action_item_id.'" onchange="updateCorrespondingElement(this);" class="action_item_textarea autogrow '.$actionEditElement.'" style="display:none; width:95%; ">'.$escaped_action_item.'</textarea>
						</td>
						<td class="'.$actionItemsTableByDiscussionItemIdTdAssignmentStyle.'">
				';
				if (!isset($isPrintView) || !$isPrintView) {

					$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

							<div class="$actionEditElement" style="display: none;">
								$selContacts
								<input id="btnAddAssignee_$discussion_item_id_$action_item_id" type="button" value="Assign" onclick="addAssigneeToAction('$action_item_id');">
							</div>
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;

				}
				$actionItemsTableByDiscussionItemId .= '
							<ul id="ulActionAssignees_'.$action_item_id.'">
				';
				$actionItemsTableByDiscussionItemId .= buildAssigneeListItemsForActionItem($arrActionItemAssignmentsByActionItemId, $action_item_id, $input);
				$actionItemsTableByDiscussionItemId .= '
							</ul>
						</td>
						<td class="action-table-td-assignment-date">
							<span id="manage-action_item-record-read_only--action_items--due_date--'.$action_item_id.'" class="'.$actionShowElement.'">'.$action_item_due_date.'</span>
							<input id="manage-action_item-record--action_items--action_item_due_date--'.$action_item_id.'" name="action_item_due_date-'.$action_item_id.'" onchange="updateActionItem(this); updateCorrespondingElement(this);" value="'.$action_item_due_date.'" class="'.$actionEditElement.' datepicker auto-hint" style="display:none;" title="MM/DD/YYYY">
						</td>
						<td class="action-table-td-assignment-date">
							<span id="manage-action_item-record-read_only--action_items--action_item_completed_timestamp--'.$action_item_id.'" class="'.$actionShowElement.'">'.$action_item_completed_timestamp.'</span>
							<input id="manage-action_item-record--action_items--action_item_completed_timestamp--'.$action_item_id.'" name="action_item_completed_timestamp-'.$action_item_id.'" onchange="updateActionItem(this); updateCorrespondingElement(this);" value="'.$action_item_completed_timestamp.'" class="'.$actionEditElement.' datepicker auto-hint" style="display:none;" title="MM/DD/YYYY">
						</td>
					</tr>
				';
			} else {
				$listItems = buildAssigneeListItemsForActionItem($arrActionItemAssignmentsByActionItemId, $action_item_id, $input);
				$actionItemsTableByDiscussionItemId .= '
					<tr>
						<td title="Created By '.$created_by.' On '.$created_date.'" class="'.$actionItemsTableByDiscussionItemIdTdDescriptionStyle.'">'.$escaped_action_item.'</td>
						<td class="'.$actionItemsTableByDiscussionItemIdTdAssignmentStyle.'">
							<ul id="ulActionAssignees_'.$action_item_id.'">
								'.$listItems.'
							</ul>
						</td>
						<td class="action-table-td-assignment-date">'.$action_item_due_date.'</td>
						<td class="action-table-td-assignment-date">'.$action_item_completed_timestamp.'</td>
					</tr>
				';
			}
		}

		$actionItemsTableByDiscussionItemId .= '
				</table>
			</div>
		';
	} else {
		$actionItemsTableByDiscussionItemId = '
			<div class="headerActions" style="display:none; padding: 2px 25px 4px; font-size: 0.9em; font-weight: bold;">
				<a href="#">Action Items (0)</a>
			</div>
		';

		if ($userCanCreateActionItems || $userCanManageMeetings) {
			$actionItemsTableByDiscussionItemId .= '
				<div>'.$newActionItemTable.'</div>
			';
		}
	}

	return $actionItemsTableByDiscussionItemId;
}

function buildMeetingActionItemsTableByDiscussionItemIdPdf($arrActionItemsByDiscussionItemIds, $discussion_item_id, Input $input)
{

	$database = $input->database;
	$arrContactOptions = $input->arrContactOptions;
	$userCanCreateActionItems = $input->userCanCreateActionItems;
	$userCanManageMeetings = $input->userCanManageMeetings;
	$actionShowElement = $input->actionShowElement;
	$actionEditElement = $input->actionEditElement;
	$isPrintView = $input->isPrintView;
	//$filterByIsVisibleFlag = $meetingInput->filterByIsVisibleFlag;

	/*
	if (!isset($filterByIsVisibleFlag)) {
		$filterByIsVisibleFlag = false;
	}
	*/

	if (isset($arrActionItemsByDiscussionItemIds[$discussion_item_id])) {
		$arrActionItemsByDiscussionItemId = $arrActionItemsByDiscussionItemIds[$discussion_item_id];
		$actionItemCount = count($arrActionItemsByDiscussionItemId);
	} else {
		$arrActionItemsByDiscussionItemId = array();
		$actionItemCount = 0;
	}

	$actionItemsTableByDiscussionItemIdTdAssignmentStyle = 'action-table-td-assignment';
	$actionItemsTableByDiscussionItemIdTdDescriptionStyle = 'action-table-td-description';
	if (isset($isPrintView) && $isPrintView) {
		$actionItemsTableByDiscussionItemIdTdAssignmentStyle = 'action-table-td-assignment printView';
		$actionItemsTableByDiscussionItemIdTdDescriptionStyle = 'action-table-td-description printView';
	}

	// Build the contacts drop down for new action items
	$selName = 'selNewAssignedTo_' . $discussion_item_id;
	//$selContacts = PageComponents::dropDownList($selName, $arrContactOptions,'','','class="'.$actionEditElement.'" style="display:none;"');
	$selContacts = PageComponents::dropDownList($selName, $arrContactOptions);

	$actionItemCreationForm = <<<END_ACTION_ITEM_CREATION_FORM

			<form id="frmNewActionItem_$discussion_item_id" name="frmNewActionItem_$discussion_item_id" style="display: none;">
			<table class="action-table-new">
				<tr>
					<th class="columnHeader">New Action</th>
					<th class="columnHeader">Assign To</th>
					<th class="columnHeader">Due Date</th>
					<th>&nbsp;</th>
				</tr>
				<tr valign="top">
					<td>
						<textarea id="newAction_$discussion_item_id" name="newAction_$discussion_item_id" class="autogrow"></textarea>
					</td>
					<td class="$actionItemsTableByDiscussionItemIdTdAssignmentStyle">
						$selContacts <input type="button" value="Assign" onclick="addAssigneeToNewAction('$discussion_item_id');">
						<ul id="ulNewActionAssignees_$discussion_item_id"></ul>
						<input id="newActionAssignees_$discussion_item_id" name="newActionAssignees_$discussion_item_id" type="hidden" value="">
					</td>
					<td class="action-table-td-assignment-date">
						<input id="newActionDueDate_$discussion_item_id" name="newActionDueDate_$discussion_item_id" class="datepicker auto-hint" title="MM/DD/YYYY">
					</td>
					<td class="action-table-td-assignment-date">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<input type="button" value="Save New Action Item" onclick="saveNewActionItem('$discussion_item_id');">
						<input type="button" value="Cancel" onclick="cancelNewActionItem('$discussion_item_id');">
					</td>
				</tr>
			</table>
			</form>
END_ACTION_ITEM_CREATION_FORM;

	if (!empty($arrActionItemsByDiscussionItemId)) {
		$actionItemsTableByDiscussionItemId = <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

		<div>
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;

		if ($userCanCreateActionItems || $userCanManageMeetings) {
			$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

			$actionItemCreationForm
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;
		}
//		$actionItemsTableByDiscussionItemId .= '
//				<table class="action-table-list">
//					<thead>
//					<tr>
//		';
//		if (!isset($isPrintView) || !$isPrintView) {
//			$actionItemsTableByDiscussionItemId .= '
//						<th class="'.$actionEditElement.'">&nbsp;</th>
//			';
//		}
//		$actionItemsTableByDiscussionItemId .= '
//						<th class="columnHeader">Action Items ('.$actionItemCount.')</th>
//						<th class="columnHeader">Assigned To</th>
//						<th class="columnHeader">Due Date</th>
//						<th class="columnHeader">Completed</th>
//					</tr>
//					</thead>
//					<tbody>
//		';

		$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

			<div style="font-weight: bold; color: black;">
				<div style="display: inline-block; width: 40%;">Action Items ($actionItemCount)</div>
				<div style="display: inline-block; width: 25%;">Assigned To</div>
				<div style="display: inline-block; width: 18%;">Due Date</div>
				<div style="display: inline-block; width: 18%;">Completed</div>
			</div>
			<hr class="hr-small">
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;

		foreach ($arrActionItemsByDiscussionItemId AS $action_item_id => $actionItem) {
			/* @var $actionItem ActionItem */

			$project = $actionItem->getProject();
			/* @var $project Project */

			$actionItemType = $actionItem->getActionItemType();
			/* @var $actionItemType ActionItemType */

			$actionItemStatus = $actionItem->getActionItemStatus();
			/* @var $actionItemStatus ActionItemStatus */

			$actionItemPriority = $actionItem->getActionItemPriority();
			/* @var $actionItemPriority ActionItemPriority */

			$actionItemCostCode = $actionItem->getActionItemCostCode();
			/* @var $actionItemCostCode CostCode */

			$createdByContact = $actionItem->getCreatedByContact();
			/* @var $createdByContact Contact */

			//$created_by = $arrActions[$discussion_item_id][$action_item_id]['creatorName'];
			$created_by = $createdByContact->getContactFullName();

			$created = $actionItem->created;

			// Encoded Action Item Data
			$actionItem->htmlEntityEscapeProperties();
			$action_item_title = $actionItem->action_item_title;
			$escaped_action_item_title = $actionItem->escaped_action_item_title;
			$action_item = $actionItem->action_item;
			$escaped_action_item = $actionItem->escaped_action_item;

			//$arrAssignees = $arrActions[$discussion_item_id][$action_item_id]['assignees'];
			$loadActionItemAssignmentsByActionItemIdOptions = new Input();
			$loadActionItemAssignmentsByActionItemIdOptions->forceLoadFlag = true;
			$arrActionItemAssignmentsByActionItemId = ActionItemAssignment::loadActionItemAssignmentsByActionItemId($database, $action_item_id, $loadActionItemAssignmentsByActionItemIdOptions);

			$action_item_due_date = $actionItem->action_item_due_date;
			$action_item_completed_timestamp = $actionItem->action_item_completed_timestamp;

			if (!isset($created_date) || $created_date == '0000-00-00') {
				$created_date = '';
			} else {
				$createdUnixTimestamp = strtotime($created);
				$created_date = date('M j, Y g:ia', $createdUnixTimestamp);
				//$created_date = date("m/d/Y",strtotime($created_date));
			}
			if (!isset($action_item_due_date) || $action_item_due_date == '0000-00-00') {
				$action_item_due_date = '';
			} else {
				$action_item_due_date = date('M j, Y', strtotime($action_item_due_date));
			}
			if (!isset($action_item_completed_timestamp) || $action_item_completed_timestamp == '0000-00-00 00:00:00') {
				$action_item_completed_timestamp = '';
			} else {
				$action_item_completed_timestamp = date('M j, Y',strtotime($action_item_completed_timestamp));
			}

			if ($userCanCreateActionItems || $userCanManageMeetings) {
				// Build the contacts drop down for each action item
				$selName = 'selActionAssignees_' . $action_item_id;
				$selContacts = PageComponents::dropDownList($selName, $arrContactOptions);
//				$actionItemsTableByDiscussionItemId .= '
//					<tr id="rowAction_'.$action_item_id.'" valign="top" style="color:black; ">
//				';

				$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

			<div style="margin: 3px 0px;">
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;

//				if (!isset($isPrintView) || !$isPrintView) {
//					$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID
//						<td class="$actionEditElement action-table-td-delete">
//							<a class="smallerFont" onclick="Collaboration_Manager__Meetings__deleteActionItem($action_item_id);">X</a>
//						</td>
//END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;
//				}
//				$actionItemsTableByDiscussionItemId .= '
//						<td title="Created By '.$created_by.' On '.$created_date.'" class="'.$actionItemsTableByDiscussionItemIdTdDescriptionStyle.'" style="width:40%;">
//							<span id="show_action_'.$action_item_id.'" class="'.$actionShowElement.'">'.$arrActions[$discussion_item_id][$action_item_id]['action'].'</span>
//						</td>
//						<td class="'.$actionItemsTableByDiscussionItemIdTdAssignmentStyle.'" style="width:10%;">
//				';

				$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

				<div style="width: 40%; display: inline-block;">
					<span id="show_action_$action_item_id" class="$actionShowElement">$escaped_action_item</span>
				</div>
				<div style="width: 25%; display: inline-block;">
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;

//				if (!isset($isPrintView) || !$isPrintView) {
//					$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID
//							<div class="$actionEditElement" style="display:none;">
//								$selContacts
//								<input id="btnAddAssignee_$discussion_item_id_$action_item_id" type="button" value="Assign" onclick="addAssigneeToAction('$action_item_id');">
//							</div>
//END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;
//				}

				$actionItemAssigneesTableByActionItemId = buildAssigneeListItemsForActionItem($arrActionItemAssignmentsByActionItemId, $action_item_id, $input);

				$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

					<ul id="ulActionAssignees_$action_item_id" style="padding: 0px; margin: 0px; list-style-type: none;">
						$actionItemAssigneesTableByActionItemId
					</ul>
				</div>
				<div style="width: 18%; display: inline-block;">
					<span id="show_due_date_$action_item_id" class="$actionShowElement">$action_item_due_date</span>
				</div>
				<div style="width: 18%; display: inline-block;">
					<span id="show_action_item_completed_timestamp_$action_item_id" class="$actionShowElement">$action_item_completed_timestamp</span>
				</div>
			</div>
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;

			} else {

				$actionItemAssigneesTableByActionItemId = buildAssigneeListItemsForActionItem($arrActionItemAssignmentsByActionItemId, $action_item_id, $input);
				$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

			<div>
				<div style="display:inline-block; " title="Created By $created_by On $created_date" class="$actionItemsTableByDiscussionItemIdTdDescriptionStyle">$escaped_action_item</div>
				<div style="display:inline-block; " class="$actionItemsTableByDiscussionItemIdTdAssignmentStyle">
					<ul id="ulActionAssignees_$action_item_id">
						$actionItemAssigneesTableByActionItemId
					</ul>
				</div>
				<div style="display:inline-block;" class="action-table-td-assignment-date">$action_item_due_date</div>
				<div style="display:inline-block;" class="action-table-td-assignment-date">$action_item_completed_timestamp</div>
			</div>
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;

			}
		}

		$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

		</div>
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;

	} else {
		$actionItemsTableByDiscussionItemId = <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

		<div class="headerActions" style="display: none;">
			<a href="#">Action Items (0)</a>
		</div>
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;

		if ($userCanCreateActionItems || $userCanManageMeetings) {
			$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID

		<div>
			$actionItemCreationForm
		</div>
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;
		}
	}

	return $actionItemsTableByDiscussionItemId;
}

function buildDiscussionItemCommentsTableByDiscussionItemId($arrDiscussionItemCommentsByDiscussionItemIds, $discussion_item_id, Input $input)
{
	$userCanManageMeetings = $input->userCanManageMeetings;
	$currentlyActiveContactId = $input->currentlyActiveContactId;

	if (isset($arrDiscussionItemCommentsByDiscussionItemIds[$discussion_item_id])) {
		$arrDiscussionItemCommentsByDiscussionItemId = $arrDiscussionItemCommentsByDiscussionItemIds[$discussion_item_id];
		$arrDiscussionItemCommentsByDiscussionItemIdCount = count($arrDiscussionItemCommentsByDiscussionItemId);

		$discussionItemCommentsTable = <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

			<div class="headerComments" style="padding: 5px 30px;">
				<a href="#">Comments (<span id="numComments--$discussion_item_id">$arrDiscussionItemCommentsByDiscussionItemIdCount</span>)</a>
			</div>
			<div>
				<table class="comment-table" id="record_list_container--manage-discussion_item_comment-record--discussion_item_comments--discussion_item_id--$discussion_item_id">
END_DISCUSSION_ITEM_COMMENTS_TABLE;

		foreach ($arrDiscussionItemCommentsByDiscussionItemId AS $discussion_item_comment_id => $discussionItemComment) {
			/* @var $discussionItemComment DiscussionItemComment */

			$discussionItem = $discussionItemComment->getDiscussionItem();
			/* @var $discussionItem DiscussionItem */

			$createdByContact = $discussionItemComment->getCreatedByContact();
			/* @var $createdByContact Contact */

			$commentCreatorContactFullNameHtmlEscaped = $createdByContact->getContactFullNameHtmlEscaped();

			//$commentCreated = $arrComments[$discussion_item_id][$discussion_item_comment_id]['created_date'];
			$created = $discussionItemComment->created;
			if (!isset($created) || $created == '0000-00-00 00:00:00') {
				$commentCreated = '';
			} else {
				$createdUnixTimestamp = strtotime($created);
				$commentCreated = date('m/d/Y g:ia', $createdUnixTimestamp);
			}

			$is_visible_flag = $discussionItemComment->is_visible_flag;

			$checkboxChecked = '';
			if ($is_visible_flag == 'Y') {
				$checkboxChecked = ' checked';
			}

			$discussionItemComment->htmlEntityEscapeProperties();

			$escaped_discussion_item_comment = $discussionItemComment->escaped_discussion_item_comment;
			$escaped_discussion_item_comment_nl2br = $discussionItemComment->escaped_discussion_item_comment_nl2br;

			if (isset($isPrintView) && $isPrintView) {
				if ($is_visible_flag == 'Y') {

					$discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

					<tr valign="top" id="record_container--manage-discussion_item_comment-record--discussion_item_comments--$discussion_item_comment_id" style="color: black;">
						<td nowrap class="comment-table-commentor">$commentCreatorContactFullNameHtmlEscaped<br>$commentCreated</td>
						<td width="90%">$escaped_discussion_item_comment_nl2br</td>
					</tr>
END_DISCUSSION_ITEM_COMMENTS_TABLE;

				}
			} else {

				// Standard HTML View of Comments

				// Delete Comment
				// Discussion Item Comment Creator can delete their own comments.
				if ($createdByContact->contact_id == $currentlyActiveContactId) {
					//<a class="bs-tooltip" href="javascript:deleteDiscussionItemComment('record_container--manage-discussion_item_comment-record--discussion_item_comments--$discussion_item_comment_id', 'manage-discussion_item_comment-record', '$discussion_item_comment_id', { responseDataType : 'json', confirmation: true });" title="Delete Comment">X</a>
					//<a class="bs-tooltip" href="javascript:Collaboration_Manager__Meetings__deleteDiscussionItemComment($discussion_item_id, $discussion_item_comment_id);" title="Delete Comment">X</a>
					$deleteCommentHtml = <<<END_DELETE_COMMENT_HTML

						<td>
							<span class="bs-tooltip colorDarkGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant" onclick="Collaboration_Manager__Meetings__deleteDiscussionItemComment($discussion_item_id, $discussion_item_comment_id);" title="Delete Comment">&nbsp;</span>
						</td>
END_DELETE_COMMENT_HTML;
				} else {
				  $deleteCommentHtml =	<<<END_DELETE_COMMENT_HTML
						<td colspan='1'></td>
END_DELETE_COMMENT_HTML;
				}

				// Toggle Comment visibility in PDFs
				if ($userCanManageMeetings) {

					// Checkbox to toggle comment in printed out meeting minutes
					$toggleCommentVisibilityHtml = <<<END_TOGGLE_COMMENT_VISIBILITY_HTML

						<td>
							<input id="manage-discussion_item_comment-record--discussion_item_comments--is_visible_flag--$discussion_item_comment_id" class="bs-tooltip verticalAlignMiddle" data-toggle="tooltip" data-placement="right" onchange="updateDiscussionItemComment(this, { responseDataType : 'json' });" title="Checked Comments Are Visible To Other Users" type="checkbox" value="$is_visible_flag"$checkboxChecked>
						</td>
END_TOGGLE_COMMENT_VISIBILITY_HTML;

				}

				// Edit Comment
				$editableCommentHtml = <<<END_EDITABLE_COMMENT_HTML

					<tr valign="top" id="record_container--manage-discussion_item_comment-record--discussion_item_comments--$discussion_item_comment_id" class="displayNone record_container--manage-discussion_item_comment-record--discussion_item_comments--discussion_item_id--$discussion_item_id">
						$deleteCommentHtml
						$toggleCommentVisibilityHtml
						<td nowrap class="comment-table-commentor">$commentCreatorContactFullNameHtmlEscaped<br>$commentCreated</td>
						<td width="90%">
							<textarea id="manage-discussion_item_comment-record--discussion_item_comments--discussion_item_comment--$discussion_item_comment_id" class="textAlignLeft" onchange="Collaboration_Manager__Meetings__updateDiscussionItemComment(this, { responseDataType : 'json' });" style="width: 98.5% !important;">$escaped_discussion_item_comment</textarea>
						</td>
					</tr>
END_EDITABLE_COMMENT_HTML;

				// Read Only Comments
				$unEditableCommentHtml = <<<END_UNEDITABLE_COMMENT_HTML

					<tr valign="top" id="record_container--manage-discussion_item_comment-record-read_only--discussion_item_comments--$discussion_item_comment_id" class="record_container--manage-discussion_item_comment-record-read_only--discussion_item_comments--discussion_item_id--$discussion_item_id">
						<td>&nbsp;</td>
						$toggleCommentVisibilityHtml
						<td nowrap class="comment-table-commentor">$commentCreatorContactFullNameHtmlEscaped<br>$commentCreated</td>
						<td id="manage-discussion_item_comment-record-read_only--discussion_item_comments--discussion_item_comment--$discussion_item_comment_id" width="90%">$escaped_discussion_item_comment_nl2br</td>
					</tr>
END_UNEDITABLE_COMMENT_HTML;

				// Comments table
				$discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

					$editableCommentHtml
					$unEditableCommentHtml
END_DISCUSSION_ITEM_COMMENTS_TABLE;

			}
		}

		$discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

				</table>
			</div>
END_DISCUSSION_ITEM_COMMENTS_TABLE;

	} else {

		$discussionItemCommentsTable = <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

			<div class="headerComments hidden" style="padding:2px 25px 4px; font-size:0.9em; font-weight:bold;">
				<a href="#">Comments (<span id="numComments--$discussion_item_id">0</span>)</a>
			</div>
			<div>
				<table class="comment-table" id="record_list_container--manage-discussion_item_comment-record--discussion_item_comments--discussion_item_id--$discussion_item_id"></table>
			</div>
END_DISCUSSION_ITEM_COMMENTS_TABLE;

	}

	return $discussionItemCommentsTable;
}

function buildDiscussionItemCommentsTableByDiscussionItemIdPdf($arrDiscussionItemCommentsByDiscussionItemIds, $discussion_item_id, Input $input)
{

	$database = $input->database;
	$arrContactOptions = $input->arrContactOptions;
	$userCanCreateActionItems = $input->userCanCreateActionItems;
	$userCanManageMeetings = $input->userCanManageMeetings;
	$actionShowElement = $input->actionShowElement;
	$actionEditElement = $input->actionEditElement;
	$isPrintView = $input->isPrintView;

	$discussionItemCommentsTable = <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

	<div style="margin: 10px 0 0 50px;">
		<div class="headerComments" style="display: none;">
			<a href="#">Comments (0)</a>
		</div>
	</div>
END_DISCUSSION_ITEM_COMMENTS_TABLE;

	if (isset($arrDiscussionItemCommentsByDiscussionItemIds[$discussion_item_id])) {
		$arrDiscussionItemCommentsByDiscussionItemId = $arrDiscussionItemCommentsByDiscussionItemIds[$discussion_item_id];
		$arrDiscussionItemCommentsByDiscussionItemIdCount = count($arrDiscussionItemCommentsByDiscussionItemId);

		$discussionItemCommentsTable = <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

	<div style="margin: 10px 0 0 50px;">
		<div class="headerComments">
			<a href="#">Comments ($arrDiscussionItemCommentsByDiscussionItemIdCount)</a>
		</div>
		<hr class="hr-small"><hr class="hr-small">
		<div>
			<table class="comment-table">
END_DISCUSSION_ITEM_COMMENTS_TABLE;

		foreach ($arrDiscussionItemCommentsByDiscussionItemId AS $discussion_item_comment_id => $discussionItemComment) {
			/* @var $discussionItemComment DiscussionItemComment */

			$discussionItem = $discussionItemComment->getDiscussionItem();
			/* @var $discussionItem DiscussionItem */

			$createdByContact = $discussionItemComment->getCreatedByContact();
			/* @var $createdByContact Contact */

			$commentCreatorContactFullNameHtmlEscaped = $createdByContact->getContactFullNameHtmlEscaped();

			$created = $discussionItemComment->created;
			if (!isset($created) || $created == '0000-00-00 00:00:00') {
				$commentCreated = '';
			} else {
				$createdUnixTimestamp = strtotime($created);
				$commentCreated = date('M j, Y g:ia', $createdUnixTimestamp);
			}

			$is_visible_flag = $discussionItemComment->is_visible_flag;

			$checkboxChecked = '';
			if ($is_visible_flag == 'Y') {
				$checkboxChecked = ' checked';
			}

			$discussionItemComment->htmlEntityEscapeProperties();

			$escaped_discussion_item_comment = $discussionItemComment->escaped_discussion_item_comment;
			$escaped_discussion_item_comment_nl2br = $discussionItemComment->escaped_discussion_item_comment_nl2br;

			if (isset($isPrintView) && $isPrintView) {
				if ($is_visible_flag == 'Y') {

					$discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

				<tr valign="top" id="record_container--manage-discussion_item_comment-record--discussion_item_comments--$discussion_item_comment_id" style="color: black;">
					<td nowrap class="comment-table-commentor">$commentCreatorContactFullNameHtmlEscaped<br>$commentCreated</td>
					<td width="90%">$escaped_discussion_item_comment_nl2br</td>
				</tr>
END_DISCUSSION_ITEM_COMMENTS_TABLE;

				}
			} else {

				$discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

				<tr valign="top" id="record_container--manage-discussion_item_comment-record--discussion_item_comments--$discussion_item_comment_id">
END_DISCUSSION_ITEM_COMMENTS_TABLE;

				if ($userCanManageMeetings) {
					$discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

					<td>
						<input id="manage-discussion_item_comment-record--discussion_item_comments--is_visible_flag--$discussion_item_comment_id" class="bs-tooltip verticalAlignMiddle" data-toggle="tooltip" data-placement="right" onchange="updateDiscussionItemComment(this, { responseDataType : 'json' });" title="Checked Comments Are Visible To Other Users" type="checkbox" value="$is_visible_flag"$checkboxChecked>
					</td>
END_DISCUSSION_ITEM_COMMENTS_TABLE;
				}

				$discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

					<td nowrap class="comment-table-commentor">$commentCreatorContactFullNameHtmlEscaped<br>$commentCreated</td>
					<td width="90%">$escaped_discussion_item_comment_nl2br</td>
				</tr>
END_DISCUSSION_ITEM_COMMENTS_TABLE;

			}
		}

		$discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE

			</table>
		</div>
	</div>
END_DISCUSSION_ITEM_COMMENTS_TABLE;

	}

	return $discussionItemCommentsTable;
}

function buildAssigneeListItemsForActionItem($arrActionItemAssignmentsByActionItemId, $action_item_id, Input $input)
{

	$database = $input->database;
	$arrContactOptions = $input->arrContactOptions;
	$userCanCreateActionItems = $input->userCanCreateActionItems;
	$userCanManageMeetings = $input->userCanManageMeetings;
	$actionShowElement = $input->actionShowElement;
	$actionEditElement = $input->actionEditElement;
	$isPrintView = $input->isPrintView;

	// Remove any assignees that had a contact_id value of 0
	//unset($arrAssignees[0]);

	$actionAssigneesListItems = '';
	if (count($arrActionItemAssignmentsByActionItemId) > 0) {

		foreach ($arrActionItemAssignmentsByActionItemId AS $actionItemAssignment) {
			/* @var $actionItemAssignment ActionItemAssignment */

			$action_item_id = $actionItemAssignment->action_item_id;
			$action_item_assignee_contact_id = $actionItemAssignment->action_item_assignee_contact_id;

			$actionItem = $actionItemAssignment->getActionItem();
			/* @var $actionItem ActionItem */

			$actionItemAssigneeContact = $actionItemAssignment->getActionItemAssigneeContact();
			/* @var $actionItemAssigneeContact Contact */

			$actionItemAssigneeContactId = $actionItemAssigneeContact->contact_id;

			$actionItemAssigneeContactFullNameHtmlEscaped = $actionItemAssigneeContact->getContactFullNameHtmlEscaped();

			$actionAssigneesListItems .= <<<END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS

							<li>
END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS;

			if ( ($userCanCreateActionItems || $userCanManageMeetings) && (!isset($isPrintView) || !$isPrintView) ) {

				$actionAssigneesListItems .= <<<END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS

								<a href="#" onclick="removeAssigneeFromAction(this, '$action_item_id', '$actionItemAssigneeContactId'); return false;" class="smallerFont $actionEditElement" style="display: none;">X</a>
END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS;

			}

			$actionAssigneesListItems .= <<<END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS

								$actionItemAssigneeContactFullNameHtmlEscaped
							</li>
END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS;
		}

	} else {
			$actionAssigneesListItems .= <<<END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS

							<li>Not assigned</li>
END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS;
	}

	return $actionAssigneesListItems;
}

function buildMeetingActionItemsTableByDiscussionItemId1($database, $project_id, $discussion_item_id, $arrContactOptions)
{
	// Set permission variables

	$userCanViewDiscussionItems = checkPermissionForAllModuleAndRole($database,'meetings_view');
	$userCanCreateDiscussionItems = checkPermissionForAllModuleAndRole($database,'meetings_add_discussion_item');
	$userCanCreateActionItems = checkPermissionForAllModuleAndRole($database,'meetings_add_action_item');
	$userCanCreateDiscussionItemComments = checkPermissionForAllModuleAndRole($database,'meetings_add_comment');
	$userCanManageMeetings = checkPermissionForAllModuleAndRole($database,'meetings_manage');
	$session = Zend_Registry::get('session');
	$userRole = $session->getUserRole();
	if($userRole == "global_admin")
	{
		$userCanViewDiscussionItems = $userCanCreateDiscussionItems = $userCanCreateActionItems = $userCanCreateDiscussionItemComments =$userCanManageMeetings =1;
	}

	$loadDiscussionItemsToActionItemsByDiscussionItemIdOptions = new Input();
	$loadDiscussionItemsToActionItemsByDiscussionItemIdOptions->forceLoadFlag = true;
	$arrDiscussionItemsToActionItemsByDiscussionItemId = DiscussionItemToActionItem::loadDiscussionItemsToActionItemsByDiscussionItemId($database, $discussion_item_id, $loadDiscussionItemsToActionItemsByDiscussionItemIdOptions);
	$numDiscussionItemsToActionItemsByDiscussionItemId = count($arrDiscussionItemsToActionItemsByDiscussionItemId);

	$count_action_item_type_none = DiscussionItemToActionItem::countActionItemType($database, $discussion_item_id, 1);
	$count_action_item_type_rfi = DiscussionItemToActionItem::countActionItemType($database, $discussion_item_id, 5);
	$count_action_item_type_submittal = DiscussionItemToActionItem::countActionItemType($database, $discussion_item_id, 7);

	$actionItemsTableTbody = '';
	$oddMTEven = 1;
	$first = 'false';
	$curcompany = '';

	if ($arrDiscussionItemsToActionItemsByDiscussionItemId == 0) {
		$actionItemsTableTbody .= <<<ADD_ACTION_ITEM_HTML
		<tr class="hidden" id="append-$discussion_item_id"><td colspan="6"></td></tr>
ADD_ACTION_ITEM_HTML;
	}

	foreach ($arrDiscussionItemsToActionItemsByDiscussionItemId as $discussionItemToActionItem) {
		/* @var $discussionItemToActionItem DiscussionItemToActionItem */
		if($oddMTEven%2){
			$styleMt = "oddMT";
		}else{
			$styleMt = "evenMT";
		}
		$action_item_type_id = $discussionItemToActionItem->action_item_type_id;
		if($curcompany <> $action_item_type_id){
			$curcompany=$action_item_type_id;
			if ($first) {
				$first = 'true';
			}
		}else{
			$first = 'false';
		}

		$oddMTEven++;
		$action_item_id = $discussionItemToActionItem->action_item_id;
		$actionItemsTableTr = buildActionItemsTableTr($database, $project_id, $action_item_id, $discussion_item_id, $styleMt, $first, $count_action_item_type_none, $count_action_item_type_rfi, $count_action_item_type_submittal);
		$actionItemsTableTbody .= $actionItemsTableTr;
	}

	if ($count_action_item_type_rfi == 0 && $count_action_item_type_submittal == 0 && $arrDiscussionItemsToActionItemsByDiscussionItemId != 0) {
		$actionItemsTableTbody .= <<<ADD_ACTION_ITEM_HTML
		<tr class="hidden" id="append-$discussion_item_id"><td colspan="6"></td></tr>
ADD_ACTION_ITEM_HTML;
	}

	$dummyId = Data::generateDummyPrimaryKey();

	$js = <<<END_JAVASCRIPT
		onchange="createActionItemAssignmentHelper('create-action_item_assignment-record', '$dummyId', this);"
END_JAVASCRIPT;

	$ddlActionItemAssignmentsId = "create-action_item_assignment-record--action_item_assignments--action_item_assignee_contact_id--$dummyId";
	$ddlActionItemAssignments = PageComponents::dropDownList($ddlActionItemAssignmentsId, $arrContactOptions, '', '', $js, false);


	if ($userCanCreateActionItems || $userCanManageMeetings) {

		//<a class="smallerFont bold showElement action-item-add-button fakeHref" href="javascript:showCreateActionItemDialog('$discussion_item_id');">Add Action</a>

		$addActionItemHtml = <<<ADD_ACTION_ITEM_HTML
	<div class="header-edit-container">
		<button class="action-item-add-button-mt" onclick="showCreateActionItemDialog('$discussion_item_id');" type="button" value="Add Action">Add Action</button>
	</div>
ADD_ACTION_ITEM_HTML;

	} else {
		$addActionItemHtml = '';
	}


	$htmlContent = <<<END_HTML_CONTENT

	$addActionItemHtml
	<div class="accordionActionItem widgetContainer">
		<h3 class="title" style="padding:5px 30px;color:#fff;">
			<a href="#">Action Items (<span id="numActionItems--$discussion_item_id">$numDiscussionItemsToActionItemsByDiscussionItemId</span>)</a>
		</h3>
		<div class="content" style="margin:0; padding:0">
			<form id="formCreateActionItem--$dummyId">
			<input type="hidden" id="input-check-record_list_container--action_items--discussion_item_id--$discussion_item_id" value="0">
				<table border="0" id="record_list_container--action_items--discussion_item_id--$discussion_item_id" class="content" cellpadding="5" style="margin:0; padding:15px" width="100%">
					<thead class="borderBottom">
						<tr>
							<th class="trEditable hidden" width="5%"></th>
							<th class="textAlignLeft" width="8%">#</th>
							<th class="textAlignLeft" width="50%">Task</th>						
							<th class="textAlignLeft">Assigned To</th>
							<th class="textAlignLeft">Due Date</th>
							<th class="textAlignLeft">Completed</th>
						</tr>
					</thead>
					<tbody class="customNthChild">
						<tr class="trCreateActionItem--$discussion_item_id hidden">
							<td class="trEditable hidden"></td>
							<td width="8%"></td>
							<td>
								<textarea id="create-action_item-record--action_items--action_item--$dummyId" class="textareaCreateActionItem--$discussion_item_id" style="width:90%"></textarea><br><br>
							</td>
							<td>
								$ddlActionItemAssignments
								<br>
								<ul id="record_list_container--action_item_assignments--$dummyId" style="margin:0; padding:0; list-style:none;"></ul>
								<input type="hidden" id="create-action_item_assignment-record--action_item_assignments--action_item_id--$dummyId" value="-1">
							</td>
							<td><input id="create-action_item-record--action_items--action_item_due_date--$dummyId" class="datepicker"></td>
							<td><input id="create-action_item-record--action_items--action_item_completed_timestamp--$dummyId" class="datepicker"></td>
						</tr>
						<tr class="trCreateActionItem--$discussion_item_id hidden">
							<td class="trUneditable backgroundColorWhite" align="right" colspan="5">
								<button  type="button" class="action-item-save-button-mt-act save_action_$dummyId" onclick="create_ActionItem_And_ActionItemAssignment_And_DiscussionItemToActionItem_ViaPromiseChain('create-action_item-record', '$dummyId', { discussion_item_id: '$discussion_item_id' });" value="Create Action Item">Create Action Item</button>
								<button type="button" class="action-item-save-button-mt-act" onclick="cancelCreateActionItem('$discussion_item_id');" value="Cancel">Cancel</button>
								<hr>
							</td>
							<td class="trEditable hidden backgroundColorWhite" align="right" colspan="6">
								<button  type="button" class="action-item-save-button-mt-act save_action_$dummyId" onclick="create_ActionItem_And_ActionItemAssignment_And_DiscussionItemToActionItem_ViaPromiseChain('create-action_item-record', '$dummyId', { discussion_item_id: '$discussion_item_id' });" value="Create Action Item">Create Action Item</button>
								<button type="button" class="action-item-save-button-mt-act" onclick="cancelCreateActionItem('$discussion_item_id');" value="Cancel">Cancel</button>
								<hr>
							</td>
						</tr>
						$actionItemsTableTbody
					</tbody>
				</table>
			</form>
			<input type="hidden" id="create-discussion_item_to_action_item-record--discussion_items_to_action_items--discussion_item_id--$dummyId" value="$discussion_item_id">
			<input type="hidden" id="create-discussion_item_to_action_item-record--discussion_items_to_action_items--action_item_id--$dummyId" value="-1">
		</div>
	</div>
	<div id="divEditActionItemDialog" class="hidden"></div>
END_HTML_CONTENT;

	return $htmlContent;
}

function buildActionItemsTableTr($database, $project_id, $action_item_id, $discussion_item_id, $styleMt, $first=false, $countNone=0, $countRfi=0, $countSub=0)
{
	$discussionItem = DiscussionItem::findDiscussionItemByIdExtended($database, $discussion_item_id);
	/* @var $discussionItem DiscussionItem */

	$meeting = $discussionItem->getMeeting();
	/* @var $meeting Meeting */

	$meeting_type_id = $meeting->meeting_type_id;

	$arrContactOptions[0] = 'Select Assignee';
	$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id);
	foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
		/* @var $contact Contact */
		if ($contact['is_archive'] == 'N') {
			$contactFullName = $contact->getContactFullName();
			$arrContactOptions[$contact_id] = $contactFullName;
		}
	}

	$actionItem = ActionItem::findActionItemByIdExtended($database, $action_item_id);
	/* @var $actionItem ActionItem */
	$action_item = $actionItem->action_item;
	$action_item_type_id = $actionItem->action_item_type_id;
	$action_item_type_reference_id = $actionItem->action_item_type_reference_id;
	$sort_order = $actionItem->sort_order;
	$action_item_due_date = $actionItem->action_item_due_date;
	if ($action_item_due_date == '') {
		$dueDateUneditable = 'N/A';
		$dueDateEditable = '';
	} else {
		$dueDateUneditable = date('m/d/Y', strtotime($action_item_due_date));
		$dueDateEditable = date('m/d/Y', strtotime($action_item_due_date));
	}
	$action_item_completed_timestamp = $actionItem->action_item_completed_timestamp;
	if ($action_item_completed_timestamp == '0000-00-00 00:00:00') {
		$completedDateUneditable = 'N/A';
		$completedDateEditable = '';
	} else {
		$completedDateUneditable = date('m/d/Y', strtotime($action_item_completed_timestamp));
		$completedDateEditable = date('m/d/Y', strtotime($action_item_completed_timestamp));
	}
	$loadActionItemAssignmentsByActionItemIdOptions = new Input();
	$loadActionItemAssignmentsByActionItemIdOptions->forceLoadFlag = true;
	$arrActionItemAssignmentsByActionItemId = ActionItemAssignment::loadActionItemAssignmentsByActionItemId($database, $action_item_id, $loadActionItemAssignmentsByActionItemIdOptions);
	$ulActionItemAssigneesUneditable = '';
	$ulActionItemAssigneesEditable = '';
	foreach ($arrActionItemAssignmentsByActionItemId as $actionItemAssignment) {
		/* @var $actionItemAssignment ActionItemAssignment */

		$actionItemAssigneeContact = $actionItemAssignment->getActionItemAssigneeContact();
		/* @var $actionItemAssigneeContact Contact */

		$actionItemAssigneeFullName = $actionItemAssigneeContact->getContactFullNameHtmlEscaped();
		$action_item_assignee_contact_id = $actionItemAssigneeContact->contact_id;

		$uniqueId = $action_item_id.'-'.$action_item_assignee_contact_id;
		$elementId = "record_container--manage-action_item_assignment-record--action_item_assignments--$uniqueId";

		$ulActionItemAssigneesEditable .= <<<END_UL_ACTION_ITEM_ASSIGNEES_EDITABLE

		<li id="$elementId">
			<a href="javascript:Collaboration_Manager__Meetings__deleteActionItemAssignment('$elementId', 'manage-action_item_assignment-record', '$uniqueId');">X</a>
			$actionItemAssigneeFullName
		</li>
END_UL_ACTION_ITEM_ASSIGNEES_EDITABLE;

		$elementId = "record_container--manage-action_item_assignment-record-read_only--action_item_assignments--$uniqueId";
		$ulActionItemAssigneesUneditable .= '<li id="'.$elementId.'">'.$actionItemAssigneeFullName.'</li>';
	}
	if($ulActionItemAssigneesUneditable=='')
		$ulActionItemAssigneesUneditable = "<li id='Delete_action_NA-$action_item_id'> N/A</li>";
	$dummyId = Data::generateDummyPrimaryKey();

	$ddlActionItemAssignmentsId = "create-action_item_assignment-record--action_item_assignments--action_item_assignee_contact_id--$dummyId";

	$js = <<<END_JAVASCRIPT
		onchange="Collaboration_Manager__Meetings__createActionItemAssignment('create-action_item_assignment-record', '$dummyId', '$action_item_id');"
END_JAVASCRIPT;

	$ddlActionItemAssignments = PageComponents::dropDownList($ddlActionItemAssignmentsId, $arrContactOptions, '', '', $js, false);

	$elementIdEditable = "record_container--manage-action_item-record--action_items--sort_order--$action_item_id";
	$elementIdUneditable = "record_container--manage-action_item-record-read_only--action_items--sort_order--$action_item_id";

	$options = array();

	if ($action_item_type_id == 5) {		
	 	$options['table'] = 'requests_for_information';
	 	$options['filter'] = array('id = ?'=> $action_item_type_reference_id);
	 	$options['fields'] = array('rfi_sequence_number as reference');
	 	$headername = 'Open RFIs';
	}
	if ($action_item_type_id == 7) {
	 	$options['table'] = 'submittals';
	 	$options['filter'] = array('id = ?'=> $action_item_type_reference_id);
	 	$options['fields'] = array('su_sequence_number as reference');
	 	$headername = 'Open Submittals';
	}	 
	$referenceName ="";
	$actionItemsTableTr ="";
	if($action_item_type_id == 5 || $action_item_type_id == 7){
		$referenceOutput = TableService::GetTabularData($database,$options);
		$referenceName = $referenceOutput['reference'];
	}

	if(($action_item_type_id == 5 || $action_item_type_id == 7) && $first == 'true'){
		if ( ($countRfi != 0 && $countSub != 0 && $action_item_type_id == 5) || 
			 ($countRfi != 0 && $countSub == 0 && $action_item_type_id == 5) ||	
			 ($countRfi == 0 && $countSub != 0 && $action_item_type_id == 7)) {
				$actionItemsTableTr = <<<END_ACTION_ITEMS_TABLE_TR
					<tr class="hidden" id="append-$discussion_item_id"><td colspan="6"></td></tr>
END_ACTION_ITEMS_TABLE_TR;
			}	

	$actionItemsTableTr .= <<<END_ACTION_ITEMS_TABLE_TR
	<tr style="color: #fff;background-color: #8b8e90"><td colspan='6'>$headername</td></tr>
	<tr class="hidden"><td colspan='6'>$headername</td></tr>
END_ACTION_ITEMS_TABLE_TR;
}

	$actionItemsTableTr .= <<<END_ACTION_ITEMS_TABLE_TR

	<tr id="$elementIdUneditable" class="trUneditable">
		<td class="textAlignLeft verticalAlignTop" width="8%">$referenceName</td>
		<td class="textAlignLeft verticalAlignTop" width="50%" id="manage-action_item-record-read_only--action_items--action_item--$action_item_id">$action_item</td>		
		<td class="textAlignLeft verticalAlignTop" id="manage-action_item-record-read_only--action_items--action_item_assignees--$action_item_id">
			<ul id="record_list_container--action_item_assignments--$action_item_id" style="margin:0; padding:0; list-style:none;">$ulActionItemAssigneesUneditable</ul>
		</td>
		<td class="textAlignLeft verticalAlignTop" id="manage-action_item-record-read_only--action_items--action_item_due_date--$action_item_id">$dueDateUneditable</td>
		<td class="textAlignLeft verticalAlignTop" id="manage-action_item-record-read_only--action_items--action_item_completed_timestamp--$action_item_id">$completedDateUneditable</td>
	</tr>
	<tr id="$elementIdEditable" class="trEditable hidden">
		<td>
			<span class="bs-tooltip colorDarkGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant" onclick="Collaboration_Manager__Meetings__deleteActionItem($action_item_id);" title="Delete Action Item">&nbsp;</span>
		</td>
		<td class="textAlignLeft verticalAlignTop" width="8%">$referenceName</td>
		<td class="textAlignLeft verticalAlignTop" width="50%"><textarea id="manage-action_item-record--action_items--action_item--$action_item_id" style="width:90%" onchange="updateCorrespondingElement(this);" class="action_item_textarea">$action_item</textarea></td>		
		<td class="textAlignLeft verticalAlignTop">
			$ddlActionItemAssignments<br>
			<ul id="record_list_container--action_item_assignments--$dummyId" class="record_Editable_container--$action_item_id" style="margin:0; padding:0; list-style:none;">$ulActionItemAssigneesEditable</ul>
			<input type="hidden" id="create-action_item_assignment-record--action_item_assignments--action_item_id--$dummyId" value="$action_item_id">
		</td>
		<td class="textAlignLeft verticalAlignTop"><input id="manage-action_item-record--action_items--action_item_due_date--$action_item_id" value="$dueDateEditable" class="datepicker" onchange="updateActionItem(this); updateCorrespondingElement(this);"></td>
		<td class="textAlignLeft verticalAlignTop"><input id="manage-action_item-record--action_items--action_item_completed_timestamp--$action_item_id" value="$completedDateEditable" class="datepicker" onchange="updateActionItem(this); updateCorrespondingElement(this);"></td>
	</tr>
END_ACTION_ITEMS_TABLE_TR;

	return $actionItemsTableTr;
}

function MeetingPermissionModal($database,$project_id,$role_spec="all",$role_filter="")
{
	$rolesarr = getAllRoles($database,'all',$role_spec,$role_filter);
	$meetingArr = MeetingType::LoadMeetingType($database,$project_id);
	$arrMeetingPermission = MeetingAttendee::loadAllMeetingRolesForProject($database,$project_id);


	$htmlContent = <<<END_HTML_CONTENT
	
	<table width="100%" border="1" class="table-theme">
	<thead>
	<tr><th>Roles</th>
END_HTML_CONTENT;

foreach ($meetingArr as $meet) {
	$mmeting_type =  $meet['meeting_type'];
	$htmlContent .= <<<END_HTML_CONTENT
	<th style="font-size:12px;">$mmeting_type</th>
END_HTML_CONTENT;
}
$htmlContent .= <<<END_HTML_CONTENT
</tr></thead><tbody>	
END_HTML_CONTENT;
foreach ($rolesarr as $key => $rolevalue) {
	$role_name = $rolevalue['role'];
	$role_pst = $rolevalue['project_specific_flag'];
		if($role_pst == 'Y')
		{
			$prclass = "pspecify";
		}else
		{
			$prclass = "nonspecify";
		}
		// GA roles shuld not come in dropdown
		if($rolevalue['role'] =='Global Admin'){
			continue;
		}
	
	$htmlContent .= <<<END_HTML_CONTENT
		<tr><td class="$prclass">$role_name</td>
END_HTML_CONTENT;

foreach ($meetingArr as $mkey => $meet) {
	
	if((isset($arrMeetingPermission[$key][$mkey]['role_id']))&&($arrMeetingPermission[$key][$mkey]['role_id'] == $key)) {
			$meetTag ="checked";
	}else{
		$meetTag ="";
 	}
		$htmlContent .= <<<END_HTML_CONTENT
		<td class="textAlignCenter">
			<label class="control control--checkbox col-sm-12 p-0 m-b-15">
			<input id="meetrolep-$mkey-$key" type="checkbox" onclick="updateMeetingPermission(this.id,'$mkey','$key','$project_id');" $meetTag>
			<div class="control__indicator"></div>
			 </label>
			</td>
END_HTML_CONTENT;

}
$htmlContent .= <<<END_HTML_CONTENT
</tr></tbody>
END_HTML_CONTENT;

}

	$htmlContent .= <<<END_HTML_CONTENT
</table>
	
END_HTML_CONTENT;

return $htmlContent;
}

function taskSummaryarr($database, $project_id, $userId, $userRole,$projManager,$options){
	$returnTaskSummaryarr = array();
	$arrDiscussionItemsByProjectUserId = DiscussionItem::loadDiscussionItemsByProjectUserId($database, $project_id, $userId,$userRole,$projManager,$options);
	return $arrDiscussionItemsByProjectUserId;
	
}

function rfitaskSummaryarr($database, $project_id, $userId, $userRole,$projManager,$options){
	$returnTaskSummaryarr = array();
	$arrDiscussionItemsByProjectUserId = RequestForInformation::loadDiscussionItemsByProjectUserId($database, $project_id, $userId,$userRole,$projManager,$options);
	return $arrDiscussionItemsByProjectUserId;
}

function bstaskSummaryarr($database, $project_id, $userId, $userRole,$projManager,$options){
	$returnTaskSummaryarr = array();
	$arrDiscussionItemsByProjectUserId = BidSpread::loadDiscussionItemsByProjectUserId($database, $project_id, $userId,$userRole,$projManager,$options);
	return $arrDiscussionItemsByProjectUserId;
}

function submittaltaskSummaryarr($database, $project_id, $userId, $userRole,$projManager,$options){
	$returnTaskSummaryarr = array();
	$arrDiscussionItemsByProjectUserId = Submittal::loadDiscussionItemsByProjectUserId($database, $project_id, $userId,$userRole,$projManager,$options);
	return $arrDiscussionItemsByProjectUserId;
}
