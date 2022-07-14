<?php

$RN_jsonEC['status'] = 200;
$RN_status = 200;
$RN_jsonEC['data']['CreatePunchListData'] = null;
if(!isset($RN_params['building_id']) || $RN_params['building_id'] == null ){
	$RN_status = 400;
	$RN_errorMessage = 'Building Id is required';
}
if($RN_status == 400){
	$RN_jsonEC['status'] = $RN_status;
	$RN_jsonEC['data'] = null;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = $RN_errorMessage;
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
$RN_buildingId = $RN_params['building_id'];
try {
	$RN_arrBuldingRoomTmp = array();
	$RN_buildingRoomDefaultId = null;
	$RN_kIncbr = 0;
	$RN_arrPiBuildingRooms = PunchItemBuildingRoom::findByPunchItemRoomByBuildingId($database, $RN_buildingId);
	foreach($RN_arrPiBuildingRooms as $RN_kibr => $RN_buildinRoom){
		$RN_arrBuldingRoomTmp[$RN_kibr]['id'] = $RN_kibr;
		$RN_arrBuldingRoomTmp[$RN_kibr]['name'] = $RN_buildinRoom->room_name;
		if($RN_kIncbr == 0){
			$RN_buildingRoomDefaultId = $RN_kibr;
		}
		$RN_kIncbr++;
	}
	
	$RN_jsonEC['data']['CreatePunchListData']['room'] = array_values($RN_arrBuldingRoomTmp);
	if(isset($RN_params['room_id']) && $RN_params['room_id'] != null ){
		$RN_buildingRoomDefaultId = $RN_params['room_id'];
	}
	$RN_jsonEC['data']['CreatePunchListData']['room_default_id'] = $RN_buildingRoomDefaultId;

}
catch(Exception $e){
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
