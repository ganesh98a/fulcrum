<?php
$RN_file_id = $RN_params['fileid'];
$RN_jobsitephotoid = $RN_params['jobsitephotoid'];
$RN_captionval = $RN_params['captionval'];

$file_id = $RN_file_id;
$jobsite_photo_id  = $RN_jobsitephotoid;
$captionval = $RN_captionval;
$db = DBI::getInstance($database);
$result  = TableService::UpdateTabularData($db,'jobsite_photos','caption',$jobsite_photo_id,$captionval);
echo $result;
?>