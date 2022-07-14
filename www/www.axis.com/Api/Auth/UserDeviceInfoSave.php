<?php
// save the user device details id
$RN_httpGetInputData = $RN_params;
if(isset($RN_httpGetInputData['device_id']) && $RN_httpGetInputData['device_id'] != null) {
	// Retrieve all of the $RN__GET inputs automatically for the Submittal record
	foreach ($RN_httpGetInputData as $RN_k => $RN_v) {
		if (empty($RN_v)) {
			unset($RN_httpGetInputData[$RN_k]);
		}
	}
	$RN_userDeviceInfoId = UsersDeviceInfo::findByUserDeviceId($database, $RN_httpGetInputData['device_id']);
	if ($RN_userDeviceInfoId !== null) {
		$RN_userDevieInfo = UsersDeviceInfo:: findById($database, $RN_userDeviceInfoId);
	} else {
		$RN_userDevieInfo = new UsersDeviceInfo($database);
	}
	
	$RN_userDevieInfo->setData($RN_httpGetInputData);
	$RN_userDevieInfo->convertDataToProperties();
	
	$RN_userDevieInfo->convertPropertiesToData();
	$RN_data = $RN_userDevieInfo->getData();
	// $RN_userDevieInfo->findByUniqueIndex();

	if ($RN_userDevieInfo->isDataLoaded()) {
		// Error code here
		$RN_message = null;
		$RN_errorMessage = 'User Device already exists.';
		$RN_user_device_id = $RN_userDevieInfo->getPrimaryKeyAsString();
		// $RN_userDevieInfo->setKey($RN_user_device_id);
	} else {
		$RN_userDevieInfo->setKey(null);
	}
	if (isset($u) && !empty($u)) {
		$RN_data['user_id'] = $u->user_id;	
	} else {
		$RN_data['user_id'] = $user->user_id;
	}
	
	$RN_data['modified_date'] = date('Y-m-d h:i:s', time());
	$RN_data['is_active'] = 'Y';
	$RN_userDevieInfo->setData($RN_data);
	$RN_message = 'User Device Saved Successfully';
	$RN_errorMessage = null;
	$RN_status = 200;
	$RN_user_device_id = $RN_userDevieInfo->save();
}
