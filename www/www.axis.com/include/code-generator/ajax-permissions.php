<?php

// Check for interface-name permissions include file
$permissionsCheckedFlag = false;
if (isset($interfaceName) && !empty($interfaceName)) {

	$interfaceNamePermissionsIncludeFile = "$interfaceName-permissions.php";
	$interfaceNamePermissionsIncludeFilePath = 'interface-specific-includes/' . $interfaceNamePermissionsIncludeFile;
	if (is_file($interfaceNamePermissionsIncludeFilePath)) {
		include($interfaceNamePermissionsIncludeFilePath);
		$permissionsCheckedFlag = true;
	}

}

if (!$permissionsCheckedFlag) {

	if ($enforcePermissions) {

		$userHasPermission = false;

		if (isset($arrRequiredAndPermissions) && !empty($arrRequiredAndPermissions)) {
			foreach ($arrRequiredAndPermissions as $requiredAndPermission => $dummy) {
				$userHasPermission = $permissions->determineAccessToSoftwareModuleFunction($requiredAndPermission);
				// Default to Enforcing all permissions
				if (!$userHasPermission) {
					break;
				}
			}
		} elseif (isset($arrRequiredOrPermissions) && !empty($arrRequiredOrPermissions)) {
			foreach ($arrRequiredOrPermissions as $requiredAndPermission => $dummy) {
				$userHasPermission = $permissions->determineAccessToSoftwareModuleFunction($requiredAndPermission);
				// Default to Permissive
				if ($userHasPermission) {
					break;
				}
			}
		}

		if (!$userHasPermission) {
			// Error and exit
			foreach ($arrErrorMessages as $errorMessage) {
				$message->enqueueError($errorMessage, $currentPhpScript);
			}
			throw new Exception($errorMessage);
			//$error->outputErrorMessages();
			//exit;
		}

	}
}
