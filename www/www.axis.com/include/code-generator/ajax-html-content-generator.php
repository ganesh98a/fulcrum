<?php

if (isset($ajaxHtmlIncludeFilePath) && !empty($ajaxHtmlIncludeFilePath)) {

	$includeFilePath = $_SERVER['DOCUMENT_ROOT'] . '/include/interface-specific-includes/' . $ajaxHtmlIncludeFilePath;
	if (is_file($includeFilePath)) {
		include($includeFilePath);
	}


} elseif (isset($moduleName) && !empty($moduleName) && isset($scenarioName) && !empty($scenarioName)) {

	$includeFile = "$scenarioName.php";
	$includeFilePath = $_SERVER['DOCUMENT_ROOT'] . '/include/interface-specific-includes/' . $moduleName . '/' . $includeFile;
	if (is_file($includeFilePath)) {
		include($includeFilePath);
	}

} else {

	// Sniff for interface-name php include file
	// Check for interface-name html content include file
	if (isset($interfaceName) && !empty($interfaceName)) {

		$interfaceNameHtmlContentIncludeFile = "$interfaceName-html.php";
		$interfaceNameHtmlContentIncludeFilePath = $_SERVER['DOCUMENT_ROOT'] . '/include/interface-specific-includes/' . $interfaceNameHtmlContentIncludeFile;
		if (is_file($interfaceNameHtmlContentIncludeFilePath)) {
			include($interfaceNameHtmlContentIncludeFilePath);
		}

	}
}



/*
// @todo add interface name here as conditionaly include...
$arrCustomizedJsonOutput = array();

// Insert custom HTML Record code here...
// "tr" or "li"
switch ($htmlRecordType) {
	case 'tr':
		// @todo Add renderOrmAsLiElement(...) function to php include
		$function = "render{$ormClassName}AsTrElement";
		$htmlRecord = $function($database, $$ormObjectInstanceName);
		break;
	default:
	case 'li':
		// @todo Add renderOrmAsLiElement(...) function to php include
		$function = "render{$ormClassName}AsLiElement";
		$htmlRecord = $function($database, $$ormObjectInstanceName);
		break;
}
*/

/*
			//\$htmlContent = render{$ormClassName}Form(\$database, \$user_company_id, \$project_id, \$userCompanyName, \$project_name);
			\$htmlContent = render{$ormClassName}Form(\$database);

			//\$htmlContent = render{$ormClassName}Form(\$database, \$user_company_id, \$project_id, \$userCompanyName, \$project_name);
			\$htmlContent = render{$ormClassName}Form(\$database);
			echo \$htmlContent;
*/
