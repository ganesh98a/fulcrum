<?php

if ($meetingType) {

// @todo Convert this to use a view class
// @todo May need to have different attributeGroup names for each widget

$meeting_type_id = $meetingType->meeting_type_id;

$meetingType->htmlEntityEscapeProperties();
$escaped_meeting_type = $meetingType->escaped_meeting_type;
$elementId = "record_container--manage-meeting_type-record--meeting_types--sort_order--$meeting_type_id";

$htmlRecordTr = <<<END_HTML_RECORD_TR

				<tr id="$elementId">
					<td class="textAlignLeft">$escaped_meeting_type</td>
					<td class="textAlignCenter"><a href="javascript:Collaboration_Manager__deleteMeetingType('$elementId', 'manage-meeting_type-record', '$meeting_type_id');">Delete</a></td>
				</tr>
END_HTML_RECORD_TR;

$htmlRecordOption = <<<END_HTML_RECORD_OPTION
<option value="$meeting_type_id">$escaped_meeting_type</option>
END_HTML_RECORD_OPTION;

}
