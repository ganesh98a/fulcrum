<?php

$discussion_item_id = $discussionItemComment->discussion_item_id;
$discussion_item_comment = $discussionItemComment->discussion_item_comment;
$is_visible_flag = $discussionItemComment->is_visible_flag;

$discussionItemComment->htmlEntityEscapeProperties();

$escaped_discussion_item_comment = $discussionItemComment->escaped_discussion_item_comment;
$escaped_discussion_item_comment_nl2br = $discussionItemComment->escaped_discussion_item_comment_nl2br;

$created = $discussionItemComment->created;
$createdUnixTimestamp = strtotime($created);
$commentCreated = date('M j, Y g:ia', $createdUnixTimestamp);

$createdByContact = Contact::findById($database, $discussionItemComment->created_by_contact_id);
/* @var $createdByContact Contact */

$commentCreatorContactFullNameHtmlEscaped = $createdByContact->getContactFullNameHtmlEscaped();
$checkboxChecked = '';
if ($is_visible_flag == 'Y') {
	$checkboxChecked = ' checked';
}

// This comment was just created so the "creator" can delete it.
//<a class="bs-tooltip" href="javascript:deleteDiscussionItemComment('record_container--manage-discussion_item_comment-record--discussion_item_comments--$discussion_item_comment_id', 'manage-discussion_item_comment-record', '$discussion_item_comment_id', { responseDataType : 'json', confirmation: true });" title="Delete Comment">X</a>
//<a class="bs-tooltip" href="javascript:Collaboration_Manager__Meetings__deleteDiscussionItemComment($discussion_item_id, $discussion_item_comment_id);" title="Delete Comment">X</a>
$deleteCommentHtml = <<<END_DELETE_COMMENT_HTML
					<td>
						<span class="colorDarkGray entypo-cancel-squared fakeHrefBox" onclick="Collaboration_Manager__Meetings__deleteDiscussionItemComment($discussion_item_id, $discussion_item_comment_id);" title="Delete Comment">&nbsp;</span>
					</td>
END_DELETE_COMMENT_HTML;

$userCanManageMeetings = $permissions->determineAccessToSoftwareModuleFunction('meetings_manage');
if ($userCanManageMeetings) {

	$toggleCommentVisibilityHtml = <<<END_TD_COMMENT_CHECK_BOX

					<td>
						<input id="manage-discussion_item_comment-record--discussion_item_comments--is_visible_flag--$discussion_item_comment_id" class="bs-tooltip verticalAlignMiddle" data-toggle="tooltip" data-placement="right" onchange="updateDiscussionItemComment(this, { responseDataType : 'json' });" title="Checked Comments Are Visible To Other Users" type="checkbox" value="$is_visible_flag"$checkboxChecked>
					</td>
END_TD_COMMENT_CHECK_BOX;

} else {
	$toggleCommentVisibilityHtml = '';
}

$htmlRecord = <<<END_HTML_RECORD

					<tr valign="top" id="record_container--manage-discussion_item_comment-record--discussion_item_comments--$discussion_item_comment_id" class="displayNone record_container--manage-discussion_item_comment-record--discussion_item_comments--discussion_item_id--$discussion_item_id">
						$deleteCommentHtml
						$toggleCommentVisibilityHtml
						<td nowrap class="comment-table-commentor">$commentCreatorContactFullNameHtmlEscaped<br>$commentCreated</td>
						<td width="90%">
							<textarea id="manage-discussion_item_comment-record--discussion_item_comments--discussion_item_comment--$discussion_item_comment_id" class="textAlignLeft" onchange="Collaboration_Manager__Meetings__updateDiscussionItemComment(this, { responseDataType : 'json' });" style="width: 98.5% !important;">$escaped_discussion_item_comment</textarea>
						</td>
					</tr>
					<tr valign="top" id="record_container--manage-discussion_item_comment-record-read_only--discussion_item_comments--$discussion_item_comment_id" class="record_container--manage-discussion_item_comment-record-read_only--discussion_item_comments--discussion_item_id--$discussion_item_id">
						<td>&nbsp;</td>
						$toggleCommentVisibilityHtml
						<td nowrap class="comment-table-commentor">$commentCreatorContactFullNameHtmlEscaped<br>$commentCreated</td>
						<td id="manage-discussion_item_comment-record-read_only--discussion_item_comments--discussion_item_comment--$discussion_item_comment_id" width="90%">$escaped_discussion_item_comment_nl2br</td>
					</tr>
END_HTML_RECORD;

$arrCustomizedJsonOutput = array();
if (isset($discussion_item_id) && !empty($discussion_item_id)) {
	$arrCustomizedJsonOutput['discussion_item_id'] = $discussion_item_id;
}
