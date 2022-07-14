<?php

$arrOutput = array(
	'errorNumber' => $errorNumber,
	'errorMessage' => $errorMessage,
	'attributeGroupName' => $attributeGroupName,
	'attributeSubgroupName' => $attributeSubgroupName,
	'containerElementId' => $containerElementId,
	'formattedAttributeGroupName' => $formattedAttributeGroupName,
	'formattedAttributeSubgroupName' => $formattedAttributeSubgroupName,
	'htmlContent' => $htmlContent,
);

// Potentially override the defaults
if (isset($arrCustomizedJsonOutput) && !empty($arrCustomizedJsonOutput)) {
	$arrOutput = array_merge($arrOutput, $arrCustomizedJsonOutput);
}

$output = json_encode($arrOutput);
$jsonFlag = true;
