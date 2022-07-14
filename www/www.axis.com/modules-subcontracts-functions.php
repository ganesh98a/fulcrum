<?php

require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/SubcontractItemTemplate.php');
require_once('lib/common/SubcontractTemplate.php');
require_once('lib/common/SubcontractTemplateToSubcontractItemTemplate.php');
require_once('lib/common/SubcontractType.php');

require_once('lib/common/UserCompanyFileTemplate.php');

require_once('include/page-components/fileUploader.php');
require_once('lib/common/Date.php');

function loadSubcontractTemplatesFlipped($database, $user_company_id)
{
	$arrSubcontractTemplates = SubcontractTemplate::loadSubcontractTemplatesByUserCompanyId($database, $user_company_id);

	$subcontractTemplatesTable = <<<END_SUBCONTRACT_TEMPLATES_TABLE

<table id="record_list_container--view-subcontract_template-record" border="1" cellpadding="5">
END_SUBCONTRACT_TEMPLATES_TABLE;

	foreach ($arrSubcontractTemplates as $subcontractTemplate) {
		/* @var $subcontractTemplate SubcontractTemplate */

		$subcontract_template_id = (int) $subcontractTemplate->subcontract_template_id;
		$user_company_id = (int) $subcontractTemplate->user_company_id;
		$subcontract_type_id = (int) $subcontractTemplate->subcontract_type_id;
		$subcontract_template_name = (string) $subcontractTemplate->subcontract_template_name;
		$disabled_flag = (string) $subcontractTemplate->disabled_flag;

		if ($disabled_flag == 'N') {
			$enabledForUse = 'Enabled';
		} else {
			$enabledForUse = 'Disabled';
		}

		$subcontract_type = (string) $subcontractTemplate->subcontract_type;

		$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE

		<tr>
			<td><b>Subcontract Template Name</b></td>
			<td id="view-subcontract_template-record--subcontract_templates--subcontract_template_name--$subcontract_template_id">$subcontract_template_name</td>
		</tr>
		<tr>
			<td><b>Subcontract Type</b></td>
			<td id="view-subcontract_template-record--subcontract_templates--subcontract_type_id--$subcontract_template_id">$subcontract_type</td>
		</tr>
		<tr>
			<td><b>Enabled For Use</b></td>
			<td id="view-subcontract_template-record--subcontract_templates--disabled_flag--$subcontract_template_id">$enabledForUse</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><a href="javascript:Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template('$subcontract_template_id');">Edit</a></td>
		</tr>
END_SUBCONTRACT_TEMPLATES_TABLE;
	}

	$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE

</table>
END_SUBCONTRACT_TEMPLATES_TABLE;

	return $subcontractTemplatesTable;
}

function loadSubcontractTemplatesWithSubcontractTemplateItems($database, $user_company_id,$currentlyActiveContactId)
{
	//$arrSubcontractTemplates = SubcontractTemplate::loadSubcontractTemplatesByUserCompanyId($database, $user_company_id);
	$db = DBI::getInstance($database);
	//Fulcrum global admin
		$config = Zend_Registry::get('config');
   		$fulcrum_user = $config->system->fulcrum_user;
	$companyQuery = "SELECT email FROM users where primary_contact_id='$currentlyActiveContactId'  limit 1 ";
   			$db->execute($companyQuery);
   	 		$row = $db->fetch();
   	 		$user_email=$row['email'];
     		$db->free_result();
     		if($user_email == $fulcrum_user)
     		{
     			$globalAccess="1";
     			$widthSub="width:1100px;";
     		}else
     		{
     			$globalAccess="0";
				$widthSub="width:1000px;";     		}
	$subcontractTemplatesTbody = buildSubcontractTemplates__AsTableRows($database, $user_company_id,$currentlyActiveContactId,$globalAccess);

	$subcontractTemplatesTable = <<<END_SUBCONTRACT_TEMPLATES_TABLE

<div class="widgetContainer" style="$widthSub margin-left:0">
	<h3 class="title">Manage Subcontract Templates</h3>
	<table id="record_list_container--view-subcontract_template-record" class="content" cellpadding="5" width="95%">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th style="width: 300px;" class="textAlignLeft">Subcontract Template Name</th>
				<th style="width: 300px;" class="textAlignLeft">Subcontract Type</th>
				<th style="width: 170px;" class="textAlignCenter">Enabled For Use</th>
END_SUBCONTRACT_TEMPLATES_TABLE;
if($globalAccess)
{
$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE
<th style="width: 170px;" class="textAlignCenter">Make Default </th>
END_SUBCONTRACT_TEMPLATES_TABLE;
}

	$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE
				<th style="width: 50px;" class="textAlignCenter">Edit</th>
				<th style="width: 50px;" class="textAlignCenter">Delete</th>
			</tr>
		</thead>
		<tbody>
$subcontractTemplatesTbody
		</tbody>
	</table>
</div>
END_SUBCONTRACT_TEMPLATES_TABLE;

	return $subcontractTemplatesTable;
}

// Note: This functions is not in active use.
function loadSubcontractTemplateSummary($database, $subcontract_template_id)
{
	$subcontractTemplate = SubcontractTemplate::findSubcontractTemplateByIdExtended($database, $subcontract_template_id);
	$arrSubcontractTemplates = array($subcontractTemplate);

	$subcontractTemplatesTable =
'
';
	foreach ($arrSubcontractTemplates as $subcontractTemplate) {
		/* @var $subcontractTemplate SubcontractTemplate */
		$subcontract_template_id = (int) $subcontractTemplate->subcontract_template_id;
		$user_company_id = (int) $subcontractTemplate->user_company_id;
		$subcontract_type_id = (int) $subcontractTemplate->subcontract_type_id;
		$subcontract_template_name = (string) $subcontractTemplate->subcontract_template_name;
		$disabled_flag = (string) $subcontractTemplate->disabled_flag;

		if ($disabled_flag == 'N') {
			$enabledForUse = 'Enabled';
		} else {
			$enabledForUse = 'Disabled';
		}

		$subcontract_type = (string) $subcontractTemplate->subcontract_type;

		$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE

<table id="record_list_container--view-subcontract_template-record" border="1" cellpadding="5" style="width: 950px;">
	<tr>
		<th style="width: 300px;">Subcontract Template Name</th>
		<th style="width: 300px;">Subcontract Type</th>
		<th style="width: 300px;">Enabled For Use</th>
		<th style="width: 50px;">&nbsp;</th>
	</tr>
	<tr>
		<td id="view-subcontract_template-record--subcontract_templates--subcontract_template_name--$subcontract_template_id">$subcontract_template_name</td>
		<td id="view-subcontract_template-record--subcontract_templates--subcontract_type_id--$subcontract_template_id">$subcontract_type</td>
		<td id="view-subcontract_template-record--subcontract_templates--disabled_flag--$subcontract_template_id">$enabledForUse</td>
		<td><a href="javascript:Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template('$subcontract_template_id');">Edit</a></td>
	</tr>
END_SUBCONTRACT_TEMPLATES_TABLE;

		$loadSubcontractItemTemplatesBySubcontractTemplateIdOptions = new Input();
		$loadSubcontractItemTemplatesBySubcontractTemplateIdOptions->forceLoadFlag = true;
		$arrSubcontractItemTemplates = SubcontractItemTemplate::loadSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id, $loadSubcontractItemTemplatesBySubcontractTemplateIdOptions);
		if (isset($arrSubcontractItemTemplates) && !empty($arrSubcontractItemTemplates)) {

			$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE

	<tr>
		<td colspan="4">
			<table id="record_list_container--subcontract_item_templates" border="1" cellpadding="5">
				<thead>
					<tr>
						<th>Order</th>
						<th>Subcontract Item</th>
						<th>Subcontract Item Abbreviation</th>
						<th>Enabled For Use</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
END_SUBCONTRACT_TEMPLATES_TABLE;

		} else {
			$arrSubcontractItemTemplates = array();
		}

		foreach ($arrSubcontractItemTemplates as $subcontractItemTemplate) {
			/* @var $subcontractItemTemplate SubcontractTemplate */

			$subcontract_item_template_id = (int) $subcontractItemTemplate->subcontract_item_template_id;
			$user_company_id = (int) $subcontractItemTemplate->user_company_id;
			$user_company_file_template_id = (int) $subcontractItemTemplate->user_company_file_template_id;
			$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
			$subcontract_item_abbreviation = (string) $subcontractItemTemplate->subcontract_item_abbreviation;
			$auto_generated_flag = (string) $subcontractItemTemplate->auto_generated_flag;
			$disabled_flag = (string) $subcontractItemTemplate->disabled_flag;

			if ($disabled_flag == 'N') {
				$enabledForUse = 'Enabled';
			} else {
				$enabledForUse = 'Disabled';
			}

			//$file_template_name = (string) $subcontractItemTemplate->file_template_name;
			//$file_template_path = (string) $subcontractItemTemplate->file_template_path;

			$subcontractTemplateToSubcontractItemTemplate =
				SubcontractTemplateToSubcontractItemTemplate::findBySubcontractTemplateIdAndSubcontractItemTemplateId($database, $subcontract_template_id, $subcontract_item_template_id);
			$sort_order = $subcontractTemplateToSubcontractItemTemplate->sort_order;

			$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE

					<tr id="record_container--subcontract_item_templates--sort_order--$subcontract_item_template_id--$sort_order" class="trSortable">
						<td class="tdSortBars" align="center"><img src="/images/sortbars.png"></td>
						<td id="record-details--subcontract_item_templates--subcontract_item_template_name--$subcontract_item_template_id">$subcontract_item</td>
						<td id="record-details--subcontract_item_templates--subcontract_item_template_type--$subcontract_item_template_id">$subcontract_item_abbreviation</td>
						<td id="record-details--subcontract_item_templates--disabled_flag--$subcontract_item_template_id">$enabledForUse</td>
						<td><a href="javascript:Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Item_Template('$subcontract_item_template_id');">Edit</a></td>
					</tr>
END_SUBCONTRACT_TEMPLATES_TABLE;
		}

		if (isset($arrSubcontractItemTemplates) && !empty($arrSubcontractItemTemplates)) {
			$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE

				</tbody>
			</table>
		</td>
	</tr>
END_SUBCONTRACT_TEMPLATES_TABLE;
		}

		$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE

</table>
END_SUBCONTRACT_TEMPLATES_TABLE;

	}

	return $subcontractTemplatesTable;
}

function loadSubcontractTemplates($database, $user_company_id)
{
	$arrSubcontractTemplates = SubcontractTemplate::loadSubcontractTemplatesByUserCompanyId($database, $user_company_id);

	$subcontractTemplatesTable = <<<END_SUBCONTRACT_TEMPLATES_TABLE

<table id="record_list_container--subcontract_templates_summary" border="1" cellpadding="5">
	<thead>
		<tr>
			<th>Order</th>
			<th>Subcontract Template Name</th>
			<th>Subcontract Type</th>
			<th>Enabled For Use</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
END_SUBCONTRACT_TEMPLATES_TABLE;

	foreach ($arrSubcontractTemplates as $subcontractTemplate) {
		/* @var $subcontractTemplate SubcontractTemplate */

		$subcontract_template_id = (int) $subcontractTemplate->subcontract_template_id;
		$user_company_id = (int) $subcontractTemplate->user_company_id;
		$subcontract_type_id = (int) $subcontractTemplate->subcontract_type_id;
		$subcontract_template_name = (string) $subcontractTemplate->subcontract_template_name;
		$disabled_flag = (string) $subcontractTemplate->disabled_flag;

		if ($disabled_flag == 'N') {
			$enabledForUse = 'Enabled';
		} else {
			$enabledForUse = 'Disabled';
		}

		$subcontract_type = (string) $subcontractTemplate->subcontract_type;

		$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE

		<tr class="trSortable">
			<td class="tdSortBars" align="center"><img src="/images/sortbars.png"></td>
			<td id="view-subcontract_template-record--subcontract_templates--subcontract_template_name--$subcontract_template_id">$subcontract_template_name</td>
			<td id="view-subcontract_template-record--subcontract_templates--subcontract_type_id--$subcontract_template_id">$subcontract_type</td>
			<td id="view-subcontract_template-record--subcontract_templates--disabled_flag--$subcontract_template_id">$enabledForUse</td>
			<td><a href="javascript:Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template('$subcontract_template_id');">Edit</a></td>
		</tr>
END_SUBCONTRACT_TEMPLATES_TABLE;

	}

	$subcontractTemplatesTable .= <<<END_SUBCONTRACT_TEMPLATES_TABLE

	</tbody>
</table>
END_SUBCONTRACT_TEMPLATES_TABLE;

	return $subcontractTemplatesTable;
}

//To clone a subcontract item
function clonedSubcontractTemplateDetails($database, $subcontract_template_id, $user_company_id=null)
{
	$subcontractTemplate = SubcontractTemplate::findSubcontractTemplateByIdExtended($database, $subcontract_template_id);
	/* @var $subcontractTemplate SubcontractTemplate */

	$subcontractTemplateDetailsTable = <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

<div class="widgetContainer" style="margin:10px 0px; font-size:0.9em;">
	<h3 class="title">Subcontract Template Details</h3>
	<table id="record_list_container--subcontract_templates--$subcontract_template_id" class="content" width="95%">
		<thead>
			<tr>
				<th class="textAlignLeft" style="padding:0px 10px">Subcontract Template Name</th>
				<th class="textAlignLeft" style="padding:0px 10px">Subcontract Type</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

	if ($subcontractTemplate) {
		$subcontract_template_id = (int) $subcontractTemplate->subcontract_template_id;
		$user_company_id = (int) $subcontractTemplate->user_company_id;
		$subcontract_type_id = (int) $subcontractTemplate->subcontract_type_id;
		$subcontract_template_name = (string) $subcontractTemplate->subcontract_template_name;
		$disabled_flag = (string) $subcontractTemplate->disabled_flag;
	}
	if ($disabled_flag == 'N') {
		$nChecked = '';
		$yChecked = 'checked';
	} else {
		$nChecked = 'checked';
		$yChecked = '';
	}



	$subcontract_type_id = (int) $subcontractTemplate->subcontract_type_id;
	$subcontract_type = (string) $subcontractTemplate->subcontract_type;
	$is_trackable = (string) $subcontractTemplate->is_trackable;

	$loadAllSubcontractTypesOptions = new Input();
	$loadAllSubcontractTypesOptions->forceLoadFlag = true;
	$arrSubcontractTypes = SubcontractType::loadAllSubcontractTypes($database, $loadAllSubcontractTypesOptions);
	$ddlSubcontractTypeElementId = "ddl--edit-subcontract_template--subcontract_templates--subcontract_type_id--{$subcontract_template_id}";
	$js = 'onchange="Subcontracts__Admin__updateSubcontractTemplate(this);"';
	$ddlSubcontractType = PageComponents::dropDownListFromObjects($ddlSubcontractTypeElementId, $arrSubcontractTypes, 'subcontract_type_id', null, 'subcontract_type', null, $subcontract_type_id, '', $js);

	$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

			<tr>
				<td style="padding: 0px 5px;">
					<input id="edit-subcontract_template--subcontract_templates--subcontract_template_name--$subcontract_template_id" type="text" onchange="Subcontracts__Admin__updateSubcontractTemplate(this);" value="$subcontract_template_name" style="width: 250px; padding:4px;">
				</td>
				<td id="view-subcontract_template-record--subcontract_templates--subcontract_type_id--$subcontract_template_id" style="padding:0px 10px">
					$ddlSubcontractType
				</td>
				
			</tr>
		</tbody>
	</table>

END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;
if($is_trackable =='Y')
{
	$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE
	<table class="content" width="95%"><tr><td align="center">
	<input onclick="cloneSubcontractTemplate('$subcontract_template_id','record_container--edit-subcontract_template--subcontract_templates--$subcontract_template_id');" type="button" value="Clone this Template">
	</td></tr></table>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;
}


	// subcontract_templates_to_subcontract_item_templates
	$arrSubcontractTemplatesToSubcontractItemTemplates =
		SubcontractTemplateToSubcontractItemTemplate::loadSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id);

	// subcontract_item_templates
	//$arrSubcontractItemTemplates = SubcontractItemTemplate::loadSubcontractItemTemplatesByUserCompanyId($database, $user_company_id);

	$db = DBI::getInstance($database);
	$query =
"
SELECT sit.`id`, sit.`subcontract_item`, sit.`subcontract_item_abbreviation`, sit.`disabled_flag`, st2sit.`sort_order`
FROM `subcontract_item_templates` sit
INNER JOIN `subcontract_templates_to_subcontract_item_templates` st2sit
WHERE sit.`id` = st2sit.`subcontract_item_template_id`
AND st2sit.`subcontract_template_id` = ?
ORDER BY st2sit.`sort_order`;
";
	$arrValues = array($subcontract_template_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$arrSubcontractItemTemplates = array();
	while ($row = $db->fetch()) {
		$subcontractItemTemplate = SubcontractItemTemplate::instantiateOrm($database, 'SubcontractItemTemplate', $row);
		/* @var $subcontractItemTemplate SubcontractItemTemplate */
		$subcontract_item_template_id = $row['id'];
		$arrSubcontractItemTemplates[$subcontract_item_template_id] = $subcontractItemTemplate;
	}
	$db->free_result();

	$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

	<br>
	<table id="record_list_container--manage-subcontract_template_to_subcontract_item_template-record--$subcontract_template_id" class="content" cellpadding="5" style="width:95%">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th class="textAlignLeft">Subcontract Item</th>
				<th class="textAlignLeft">Subcontract Item Abbreviation</th>
				<th class="textAlignCenter">Remove</th>
			</tr>
		</thead>
		<tbody class="altColors">
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

	if (count($arrSubcontractItemTemplates) == 0) {
		$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

			<tr id="record_container--manage-subcontract_template_to_subcontract_item_template-record--subcontract_templates_to_subcontract_item_templates--sort_order---1">
				<td colspan="4">Add items from the list below</td>
			</tr>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;
	}

	foreach ($arrSubcontractItemTemplates as $subcontractItemTemplate) {
		/* @var $subcontractItemTemplate SubcontractItemTemplate */

		$subcontract_item_template_id = (int) $subcontractItemTemplate->subcontract_item_template_id;
		//$user_company_id = (int) $subcontractItemTemplate->user_company_id;
		$user_company_file_template_id = (int) $subcontractItemTemplate->user_company_file_template_id;
		$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
		$subcontract_item_abbreviation = (string) $subcontractItemTemplate->subcontract_item_abbreviation;
		$auto_generated_flag = (string) $subcontractItemTemplate->auto_generated_flag;
		$disabled_flag = (string) $subcontractItemTemplate->disabled_flag;

		$sort_order = 1000;
		$checked = '';
		if (isset($arrSubcontractTemplatesToSubcontractItemTemplates[$subcontract_item_template_id])) {
			$subcontractTemplateToSubcontractItemTemplate = $arrSubcontractTemplatesToSubcontractItemTemplates[$subcontract_item_template_id];
			/* @var $SubcontractTemplateToSubcontractItemTemplate SubcontractTemplateToSubcontractItemTemplate */
			$sort_order = $subcontractTemplateToSubcontractItemTemplate->sort_order;
			$subcontract_template_id = $subcontractTemplateToSubcontractItemTemplate->subcontract_template_id;
			$uniqueId = $subcontract_template_id . '-' . $subcontract_item_template_id;
			$checked = ' checked';
		}

		// The below code chunk is not in use ($linked)
		$linked = <<<END_LINKED
					<input type="checkbox" onclick="toggleSubcontractTemplateToSubcontractItemTemplate('$subcontract_template_id', '$subcontract_item_template_id');" $checked>
END_LINKED;

		$elementId = "record_container--manage-subcontract_template_to_subcontract_item_template-record--subcontract_templates_to_subcontract_item_templates--sort_order--$uniqueId";

		$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

			<tr id="$elementId">
				<td class="tdSortBars" align="center"><img src="/images/sortbars.png"></td>
				<td>$subcontract_item</td>
				<td>$subcontract_item_abbreviation</td>
				<td class="textAlignCenter"><a href="javascript:Subcontracts__Admin__deleteSubcontractTemplateToSubcontractItemTemplate('$elementId', 'subcontract_templates_to_subcontract_item_templates', '$uniqueId');" style="color:#0e66c8;">Remove</a></td>
			</tr>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

	}

	$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

		</tbody>
	</table>
</div>
<!--/div-->
<div class="widgetContainer" style="margin:40px 0 0 0; font-size:0.9em;">
	<h3 class="title">Add Items To The Above Subcontract Template</h3>
	<table id="record_list_container--subcontract_item_templates" class="content" cellpadding="5" style="width:95%">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignLeft">Subcontract Item</th>
				<th class="textAlignLeft">Subcontract Item Abbreviation</th>
				<th class="textAlignCenter">Add</th>
			</tr>
		</thead>
		<tbody class="altColors">
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

	$loadSubcontractItemTemplatesByUserCompanyIdOptions = new Input();
	$loadSubcontractItemTemplatesByUserCompanyIdOptions->forceLoadFlag = true;
	$arrSubcontractItemTemplatesRemaining = SubcontractItemTemplate::loadSubcontractItemTemplatesByUserCompanyId($database, $user_company_id, $loadSubcontractItemTemplatesByUserCompanyIdOptions);

	foreach ($arrSubcontractItemTemplatesRemaining as $subcontractItemTemplate) {
		/* @var $subcontractItemTemplate SubcontractItemTemplate */

		$subcontract_item_template_id = $subcontractItemTemplate->subcontract_item_template_id;
		if (!isset($arrSubcontractTemplatesToSubcontractItemTemplates[$subcontract_item_template_id])) {
			$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
			$subcontract_item_abbreviation = (string) $subcontractItemTemplate->subcontract_item_abbreviation;
			$uniqueId = $subcontract_template_id . '-' . $subcontract_item_template_id;

			$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

			<tr>
				<td>$subcontract_item</td>
				<td>$subcontract_item_abbreviation</td>
				<td class="textAlignCenter"><a href="javascript:Subcontracts__Admin__createSubcontractTemplateToSubcontractItemTemplate('create-subcontract_template_to_subcontract_item_template-record', '$uniqueId');" style="color:#0e66c8;">Add</a></td>
			</tr>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;
		}
	}

	$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

		</tbody>
	</table>
</div>

END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

	return $subcontractTemplateDetailsTable;
}

function loadSubcontractTemplateDetails($database, $subcontract_template_id, $user_company_id=null)
{
	$subcontractTemplate = SubcontractTemplate::findSubcontractTemplateByIdExtended($database, $subcontract_template_id);
	/* @var $subcontractTemplate SubcontractTemplate */

	$subcontractTemplateDetailsTable = <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

<div class="widgetContainer" style="margin:10px 0px; font-size:0.9em;">
	<h3 class="title">Subcontract Template Details</h3>
	<table id="record_list_container--subcontract_templates--$subcontract_template_id" class="content" width="95%">
		<thead>
			<tr>
				<th class="textAlignLeft" style="padding:0px 10px">Subcontract Template Name</th>
				<th class="textAlignLeft" style="padding:0px 10px">Subcontract Type</th>
				<th class="textAlignCenter" style="padding:0px 10px">Enabled For Use</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

	if ($subcontractTemplate) {
		$subcontract_template_id = (int) $subcontractTemplate->subcontract_template_id;
		$user_company_id = (int) $subcontractTemplate->user_company_id;
		$subcontract_type_id = (int) $subcontractTemplate->subcontract_type_id;
		$subcontract_template_name = (string) $subcontractTemplate->subcontract_template_name;
		$disabled_flag = (string) $subcontractTemplate->disabled_flag;
	}
	if ($disabled_flag == 'N') {
		$nChecked = '';
		$yChecked = 'checked';
	} else {
		$nChecked = 'checked';
		$yChecked = '';
	}
	//To check whether subcontract template is linked to any subcontracts

	$subres=SubcontractTemplate::checkforSubcontractTemplateLinkwithSubcontacts($database,$subcontract_template_id);
	if($subres=='1')
	{
		$delsub="deleteSubcontractTemplate('record_container--edit-subcontract_template--subcontract_templates--$subcontract_template_id', 'edit-subcontract_template', '$subcontract_template_id', { performRefreshOperation: 'Y', responseDataType: 'json' });";
	}else{
	//restrict the delete
		$delsub ="Subcontracts__Admin__deleteSubcontractTemplate(this, event, $subcontract_template_id,'$subres');";
	}

	$enabledForUse = <<<END_ENABLED_FOR_USE

					<input id="edit-subcontract_template--subcontract_templates--disabled_flag--$subcontract_template_id" displayedValue="Enabled" name="disabled_flag" value="N" type="radio" $yChecked onclick="Subcontracts__Admin__updateSubcontractTemplate(this);">Enabled &nbsp;&nbsp;
					<input id="edit-subcontract_template--subcontract_templates--disabled_flag--$subcontract_template_id" displayedValue="Disabled" name="disabled_flag" value="Y" type="radio" $nChecked onclick="Subcontracts__Admin__updateSubcontractTemplate(this);">Disabled
END_ENABLED_FOR_USE;

	$subcontract_type_id = (int) $subcontractTemplate->subcontract_type_id;
	$subcontract_type = (string) $subcontractTemplate->subcontract_type;
	$is_trackable = (string) $subcontractTemplate->is_trackable;

	$loadAllSubcontractTypesOptions = new Input();
	$loadAllSubcontractTypesOptions->forceLoadFlag = true;
	$arrSubcontractTypes = SubcontractType::loadAllSubcontractTypes($database, $loadAllSubcontractTypesOptions);
	$ddlSubcontractTypeElementId = "ddl--edit-subcontract_template--subcontract_templates--subcontract_type_id--{$subcontract_template_id}";
	$js = 'onchange="Subcontracts__Admin__updateSubcontractTemplate(this);"';
	$ddlSubcontractType = PageComponents::dropDownListFromObjects($ddlSubcontractTypeElementId, $arrSubcontractTypes, 'subcontract_type_id', null, 'subcontract_type', null, $subcontract_type_id, '', $js);
	
	$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

			<tr>
				<td style="padding: 0px 5px;">
					<input id="edit-subcontract_template--subcontract_templates--subcontract_template_name--$subcontract_template_id" type="text" onchange="Subcontracts__Admin__updateSubcontractTemplate(this);" value="$subcontract_template_name" style="width: 250px; padding:4px;">
				</td>
				<td id="view-subcontract_template-record--subcontract_templates--subcontract_type_id--$subcontract_template_id" style="padding:0px 10px">
					$ddlSubcontractType
				</td>
				<td id="view-subcontract_template-record--subcontract_templates--disabled_flag--$subcontract_template_id" style="padding:10px 10px 0px">
					$enabledForUse
				</td>
				<td style="padding:0px 10px">
					<input onclick="$delsub" type="button" value="Delete">
				</td>
			</tr>
		</tbody>
	</table>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

if($is_trackable =='Y')
{
	$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE
	<table class="content" width="95%"><tr><td align="center">
	<input onclick="cloneSubcontractTemplate('$subcontract_template_id','record_container--edit-subcontract_template--subcontract_templates--$subcontract_template_id');" type="button" value="Clone this Template">
	</td></tr></table>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;
}


	// subcontract_templates_to_subcontract_item_templates
	$arrSubcontractTemplatesToSubcontractItemTemplates =
		SubcontractTemplateToSubcontractItemTemplate::loadSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id);

	// subcontract_item_templates
	//$arrSubcontractItemTemplates = SubcontractItemTemplate::loadSubcontractItemTemplatesByUserCompanyId($database, $user_company_id);

	$db = DBI::getInstance($database);
	$query =
"
SELECT sit.`id`, sit.`subcontract_item`, sit.`is_trackable`,sit.`subcontract_item_abbreviation`, sit.`disabled_flag`, st2sit.`sort_order`
FROM `subcontract_item_templates` sit
INNER JOIN `subcontract_templates_to_subcontract_item_templates` st2sit
WHERE sit.`id` = st2sit.`subcontract_item_template_id`
AND st2sit.`subcontract_template_id` = ?
ORDER BY st2sit.`sort_order`;
";
	$arrValues = array($subcontract_template_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$arrSubcontractItemTemplates = array();
	while ($row = $db->fetch()) {
		$subcontractItemTemplate = SubcontractItemTemplate::instantiateOrm($database, 'SubcontractItemTemplate', $row);
		/* @var $subcontractItemTemplate SubcontractItemTemplate */
		$subcontract_item_template_id = $row['id'];
		$arrSubcontractItemTemplates[$subcontract_item_template_id] = $subcontractItemTemplate;
	}
	$db->free_result();

	
	$updated_time=Date::convertDateTimeFormat(subcontractorUpdated($subcontract_template_id,'date'), 'html_form_datetime');
	  $fromuserInfo=subcontractorUpdated($subcontract_template_id,'user');       
	$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE
	<div class="content"  style="float: right;""><label><b>Last Updated</b></label>
	<label>$fromuserInfo  on  $updated_time</label> </div>
	<table id="record_list_container--manage-subcontract_template_to_subcontract_item_template-record--$subcontract_template_id" class="content" cellpadding="5" style="width:95%">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th class="textAlignLeft">Subcontract Item</th>
				<th class="textAlignLeft">Subcontract Item Abbreviation</th>
				<th class="textAlignCenter">Track</th>
				<th class="textAlignCenter">Remove</th>
			</tr>
		</thead>
		<tbody class="altColors">
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

	if (count($arrSubcontractItemTemplates) == 0) {
		$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

			<tr id="record_container--manage-subcontract_template_to_subcontract_item_template-record--subcontract_templates_to_subcontract_item_templates--sort_order---1">
				<td colspan="5">Add items from the list below</td>
			</tr>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;
	}

	foreach ($arrSubcontractItemTemplates as $subcontractItemTemplate) {
		/* @var $subcontractItemTemplate SubcontractItemTemplate */

		$subcontract_item_template_id = (int) $subcontractItemTemplate->subcontract_item_template_id;
		//$user_company_id = (int) $subcontractItemTemplate->user_company_id;
		$user_company_file_template_id = (int) $subcontractItemTemplate->user_company_file_template_id;
		$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
		$subcontract_item_abbreviation = (string) $subcontractItemTemplate->subcontract_item_abbreviation;
		$auto_generated_flag = (string) $subcontractItemTemplate->auto_generated_flag;
		$disabled_flag = (string) $subcontractItemTemplate->disabled_flag;
		$trackable = $subcontractItemTemplate->is_trackable;

		$sort_order = 1000;
		$checked = '';
		if (isset($arrSubcontractTemplatesToSubcontractItemTemplates[$subcontract_item_template_id])) {
			$subcontractTemplateToSubcontractItemTemplate = $arrSubcontractTemplatesToSubcontractItemTemplates[$subcontract_item_template_id];
			/* @var $SubcontractTemplateToSubcontractItemTemplate SubcontractTemplateToSubcontractItemTemplate */
			$sort_order = $subcontractTemplateToSubcontractItemTemplate->sort_order;
			$subcontract_template_id = $subcontractTemplateToSubcontractItemTemplate->subcontract_template_id;
			$uniqueId = $subcontract_template_id . '-' . $subcontract_item_template_id;
			$checked = ' checked';
		}

		// The below code chunk is not in use ($linked)
		$linked = <<<END_LINKED
					<input type="checkbox" onclick="toggleSubcontractTemplateToSubcontractItemTemplate('$subcontract_template_id', '$subcontract_item_template_id');" $checked>
END_LINKED;

		$elementId = "record_container--manage-subcontract_template_to_subcontract_item_template-record--subcontract_templates_to_subcontract_item_templates--sort_order--$uniqueId";

		$track_temp = SubcontractTemplateToSubcontractItemTemplate::getItemTrackable($database,$subcontract_item_template_id,$subcontract_template_id);

		if($track_temp =='Y')
		{
			$tempchecked = 'checked';
		}else
		{
			$tempchecked = '';
		}

		$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

			<tr id="$elementId">
				<td class="tdSortBars" align="center"><img src="/images/sortbars.png"></td>
				<td>$subcontract_item</td>
				<td>$subcontract_item_abbreviation</td>
				<td align="center"><input type="checkbox" id="track-$subcontract_template_id-$subcontract_item_template_id" onclick="TrackSubcontractitemTemplate('$subcontract_template_id', '$subcontract_item_template_id');" $tempchecked></td>

				<td class="textAlignCenter"><a href="javascript:Subcontracts__Admin__deleteSubcontractTemplateToSubcontractItemTemplate('$elementId', 'subcontract_templates_to_subcontract_item_templates', '$uniqueId');" style="color:#0e66c8;">Remove</a></td>
			</tr>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

	}

	$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

		</tbody>
	</table>
</div>
<!--/div-->
<div class="widgetContainer" style="margin:40px 0 0 0; font-size:0.9em;">
	<h3 class="title">Add Items To The Above Subcontract Template</h3>
	<table id="record_list_container--subcontract_item_templates" class="content" cellpadding="5" style="width:95%">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignLeft">Subcontract Item</th>
				<th class="textAlignLeft">Subcontract Item Abbreviation</th>
				<th class="textAlignCenter">Add</th>
			</tr>
		</thead>
		<tbody class="altColors">
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

	$loadSubcontractItemTemplatesByUserCompanyIdOptions = new Input();
	$loadSubcontractItemTemplatesByUserCompanyIdOptions->forceLoadFlag = true;
	$arrSubcontractItemTemplatesRemaining = SubcontractItemTemplate::loadSubcontractItemTemplatesByUserCompanyId($database, $user_company_id, $loadSubcontractItemTemplatesByUserCompanyIdOptions);

	foreach ($arrSubcontractItemTemplatesRemaining as $subcontractItemTemplate) {
		/* @var $subcontractItemTemplate SubcontractItemTemplate */

		$subcontract_item_template_id = $subcontractItemTemplate->subcontract_item_template_id;
		$trackable = $subcontractItemTemplate->is_trackable;
		if (!isset($arrSubcontractTemplatesToSubcontractItemTemplates[$subcontract_item_template_id])) {
			$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
			$subcontract_item_abbreviation = (string) $subcontractItemTemplate->subcontract_item_abbreviation;
			$uniqueId = $subcontract_template_id . '-' . $subcontract_item_template_id;

			$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

			<tr>
				<td>$subcontract_item</td>
				<td>$subcontract_item_abbreviation</td>
				<td class="textAlignCenter"><a href="javascript:Subcontracts__Admin__createSubcontractTemplateToSubcontractItemTemplate('create-subcontract_template_to_subcontract_item_template-record', '$uniqueId');" style="color:#0e66c8;">Add</a></td>
			</tr>
END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;
		}
	}

	$subcontractTemplateDetailsTable .= <<<END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE

		</tbody>
	</table>
</div>

END_SUBCONTRACT_TEMPLATE_DETAILS_TABLE;

	return $subcontractTemplateDetailsTable;
}

function loadSubcontractItemTemplates($database, $user_company_id, $project_id,$currentlyActiveContactId,$globalAccess)
{
	$arrSubcontractItemTemplates = SubcontractItemTemplate::loadSubcontractItemTemplatesByUserCompanyId($database, $user_company_id);
	if($globalAccess)
	{
		$tabMessage ="Manage Subcontract Item Templates - Global Admin";
	}else
	{
		$tabMessage ="Manage Subcontract Item Templates";
	}

	$subcontractItemTemplatesTable = <<<END_SUBCONTRACT_ITEM_TEMPLATES_TABLE

<div class="widgetContainer" style="width: 1000px; margin-left: 0">
	<h3 class="title">$tabMessage</h3>
	<table id="record_list_container--subcontract_item_templates" class="content" cellpadding="5" width="95%">
		<thead class="borderBottom">
			<tr>
				<th class="textAlignCenter">Sort</th>
				<th class="textAlignLeft">Subcontract Item</th>
				<th class="textAlignLeft">Subcontract Item Abbreviation</th>
				<th class="textAlignCenter">Enabled For Use</th>
				<th class="textAlignCenter">Edit</th>
				<th class="textAlignCenter">Delete</th>
			</tr>
		</thead>
		<tbody class="altColors">
END_SUBCONTRACT_ITEM_TEMPLATES_TABLE;

	foreach ($arrSubcontractItemTemplates as $subcontractItemTemplate) {
		/* @var $subcontractItemTemplate SubcontractTemplate */

		$subcontract_item_template_id = (int) $subcontractItemTemplate->subcontract_item_template_id;
		$user_company_id = (int) $subcontractItemTemplate->user_company_id;
		$user_company_file_template_id = (int) $subcontractItemTemplate->user_company_file_template_id;
		$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
		$subcontract_item_abbreviation = (string) $subcontractItemTemplate->subcontract_item_abbreviation;
		$auto_generated_flag = (string) $subcontractItemTemplate->auto_generated_flag;
		$disabled_flag = (string) $subcontractItemTemplate->disabled_flag;
		$is_trackable = (string) $subcontractItemTemplate->is_trackable;

		if ($disabled_flag == 'N') {
			$enabledForUse = 'Enabled';
		} else {
			$enabledForUse = 'Disabled';
		}
		if($is_trackable == 'Y')
		{
			$Defaultset="Checked";
		}else
		{
			$Defaultset='';
		}
		//$file_template_name = (string) $subcontractItemTemplate->file_template_name;
		//$file_template_path = (string) $subcontractItemTemplate->file_template_path;

		$subcontractItemTemplatesTable .= <<<END_SUBCONTRACT_ITEM_TEMPLATES_TABLE

			<tr id="record_container--manage-subcontract_item_template-record--subcontract_item_templates--sort_order--$subcontract_item_template_id">
				<td class="tdSortBars" nowrap align="center"><img src="/images/sortbars.png"></td>
				<td class="textAlignLeft">$subcontract_item</td>
				<td class="textAlignLeft">$subcontract_item_abbreviation</td>
				<td class="textAlignCenter">$enabledForUse</td>
				<td class="textAlignCenter"><a href="javascript:Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Item_Template('$subcontract_item_template_id');" style="color: #0e66c8;">Edit</a></td>
				<td class="textAlignCenter">
					<span class="bs-tooltip colorLightGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant" onclick="Subcontracts__Admin__deleteSubcontractItemTemplate(this, event, $subcontract_item_template_id);" title="Delete Subcontract Item Template">&nbsp;</span>
				</td>
			</tr>
END_SUBCONTRACT_ITEM_TEMPLATES_TABLE;
	}

	$subcontractItemTemplatesTable .= <<<END_SUBCONTRACT_ITEM_TEMPLATES_TABLE
		<input type="hidden" id='curcontact_id' value='$currentlyActiveContactId'>
		</tbody>
	</table>
</div>
END_SUBCONTRACT_ITEM_TEMPLATES_TABLE;

	return $subcontractItemTemplatesTable;
}

// Note: This function is not in use.
function buildSubcontractItemTemplateDetailsDialog($database, $user_company_id, $project_id, $subcontract_item_template_id=null)
{
	$subcontractItemTemplate = false;
	if ($subcontract_item_template_id) {
		$subcontractItemTemplate = SubcontractItemTemplate::findSubcontractItemTemplateByIdExtended($database, $subcontract_item_template_id);
		/* @var $subcontractItemTemplate SubcontractItemTemplate */
	}

	$fileUploaderRowHidden = 'hidden';

	if ($subcontractItemTemplate) {
		$user_company_id = $subcontractItemTemplate->user_company_id;
		$file_manager_file_id = $subcontractItemTemplate->file_manager_file_id;
		$user_company_file_template_id = $subcontractItemTemplate->user_company_file_template_id;
		$subcontract_item = $subcontractItemTemplate->subcontract_item;
		$subcontract_item_abbreviation = $subcontractItemTemplate->subcontract_item_abbreviation;
		$subcontract_item_template_type = $subcontractItemTemplate->subcontract_item_template_type;
		$sort_order = $subcontractItemTemplate->sort_order;
		$disabled_flag = $subcontractItemTemplate->disabled_flag;

		$userCompany = $subcontractItemTemplate->getUserCompany();
		/* @var $userCompany UserCompany */

		$fileManagerFile = $subcontractItemTemplate->getFileManagerFile();
		/* @var $fileManagerFile FileManagerFile */

		$userCompanyFileTemplate = $subcontractItemTemplate->getUserCompanyFileTemplate();
		/* @var $userCompanyFileTemplate UserCompanyFileTemplate */

		//'File Uploaded During Subcontract Creation','Immutable Static Subcontract Document','By Project Static Subcontract Document','Dynamic Template File'
		if ($subcontract_item_template_type == 'File Uploaded During Subcontract Creation') {
			$type0Selected = '';
			$type1Selected = ' selected';
			$type2Selected = '';
			$type3Selected = '';
			$type4Selected = '';
			$fileUploaderRowHidden = '';
		} elseif ($subcontract_item_template_type == 'Immutable Static Subcontract Document') {
			$type0Selected = '';
			$type1Selected = '';
			$type2Selected = ' selected';
			$type3Selected = '';
			$type4Selected = '';
		} elseif ($subcontract_item_template_type == 'By Project Static Subcontract Document') {
			$type0Selected = '';
			$type1Selected = '';
			$type2Selected = '';
			$type3Selected = ' selected';
			$type4Selected = '';
		} elseif ($subcontract_item_template_type == 'Dynamic Template File') {
			$type0Selected = '';
			$type1Selected = '';
			$type2Selected = '';
			$type3Selected = '';
			$type4Selected = ' selected';
		} else {
			$type0Selected = ' selected';
			$type1Selected = '';
			$type2Selected = '';
			$type3Selected = '';
			$type4Selected = '';
		}

		$attributeGroupName = 'manage-subcontract_item_template-record';
		$post_upload_js_callback = 'fileUploadedForExistingSubcontractItemTemplate(arrFileManagerFiles)';

		$deleteButton = <<<END_DELETE_BUTTON

			<input type="button" value="Delete Subcontract Item Template" onclick="deleteSubcontractItemTemplate('', '$attributeGroupName', '$subcontract_item_template_id');">
END_DELETE_BUTTON;

	} else {

		$subcontract_item_template_id = Data::generateDummyPrimaryKey();
		$user_company_id = '';
		$file_manager_file_id = '';
		$user_company_file_template_id = '';
		$subcontract_item = '';
		$subcontract_item_abbreviation = '';
		$subcontract_item_template_type = '';
		$sort_order = '';
		$disabled_flag = '';
		$userCompany = '';
		$fileManagerFile = '';
		$userCompanyFileTemplate = '';

		$type0Selected = ' selected';
		$type1Selected = '';
		$type2Selected = '';
		$type3Selected = '';
		$type4Selected = '';

		$attributeGroupName = 'create-subcontract_item_template-record';
		$post_upload_js_callback = 'fileUploadedForNewSubcontractItemTemplate(arrFileManagerFiles)';
		$deleteButton = '';
	}

	$itemName = '';
	$currentlySelectedProjectId = '';
	$fileTemplateRowHidden = 'hidden';
	$isAllProjectsChecked = '';
	$isRequiredChecked = '';
	$isTrackedChecked = '';
	$isChangeableChecked = '';
	$disabled_flag = '';

	// Create FileManagerFolder
	$virtual_file_path = '/Subcontract Item Templates/';
	//$subcontractItemTemplateFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
	/* @var $subcontractItemTemplateFileManagerFolder FileManagerFolder */

	// Input for File Uploader HTML Widget
	$input = new Input();
	$input->id = 'subcontract_item_template_upload';
	//$input->folder_id = $subcontractItemTemplateFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = $virtual_file_path;
	$input->virtual_file_name = date('Y-m-d H:i') . '.pdf';
	$input->prepend_date_to_filename = true;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadFiles';
	$input->allowed_extensions = 'gif,jpg,jpeg,pdf,png,tif,tiff';
	$input->post_upload_js_callback = $post_upload_js_callback;

	$uploader = buildFileUploader($input);
	$uploadWindow = buildFileUploaderProgressWindow();

	$htmlContent = <<<END_HTML_CONTENT

<form id="formSubcontractItemTemplateDetails" class="widgetContainer" style="border:0; font-size:0.9em; margin:0">
	<table id="container--$attributeGroupName--$subcontract_item_template_id" width="100%" class="content" cellpadding="5" style="margin:0; padding:0">
		<tbody>
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Subcontract Item:</th>
			<td width="60%"><input type="text" id="$attributeGroupName--subcontract_item_templates--subcontract_item--$subcontract_item_template_id" name="subcontract_item" value="$subcontract_item" style="width:96%;" class="required"></td>
		</tr>
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Subcontract Item Abbreviation:</th>
			<td><input type="text" id="$attributeGroupName--subcontract_item_templates--subcontract_item_abbreviation--$subcontract_item_template_id" name="subcontract_item_abbreviation" value="$subcontract_item_abbreviation" style="width:96%;"></td>
		</tr>
		<tr>
			<td class="textAlignRight verticalAlignMiddle">File Name:</th>
			<td>
				<input type="text" name="item_name" value="$itemName" style="width:96%;">
			</td>
		</tr>
		<tr>
			<td class="textAlignRight verticalAlignMiddle">File Source:</th>
			<td>
				<select id="ddl--$attributeGroupName--subcontract_item_templates--subcontract_item_template_type--$subcontract_item_template_id" class="ddlFileSource required" onchange="ddlOnChange_UpdateHiddenInputValue(this); toggleFileSource();" style="width:97%">
					<option value="0"$type0Selected>Please Select Item Source</option>
					<option value="1"$type1Selected>From PDF File (Now)</option>
					<option value="2"$type2Selected>From PDF File (At Contract Creation)</option>
					<option value="3"$type3Selected>From Template File</option>
					<option value="4"$type4Selected>Dynamic Template File</option>
				</select>
				<input id="$attributeGroupName--subcontract_item_templates--subcontract_item_template_type--$subcontract_item_template_id" type="hidden" value="$subcontract_item_template_type">
			</td>
		</tr>
		<tr id="rowAddFile" class="$fileUploaderRowHidden">
			<td class="textAlignRight verticalAlignMiddle">&nbsp;</td>
			<td>
				$uploader
			</td>
		</tr>
		<tr id="rowAddTemplate" class="$fileTemplateRowHidden">
			<td class="textAlignRight verticalAlignMiddle">&nbsp;</td>
			<td>
				<select style="width:97%">
					<option value="0">Please Select Template</option>
					<option value="1">Cover Sheet</option>
					<option value="2">Contract Face</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Use With All Project Contracts?</th>
			<td>
				<input type="checkbox"$isAllProjectsChecked name="use_with_all_project_contracts">
			</td>
		</tr>
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Is It Required?</th>
			<td>
				<input type="checkbox"$isRequiredChecked name="is_required">
			</td>
		</tr>
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Track Receipt?</th>
			<td>
				<input type="checkbox"$isTrackedChecked name="is_tracked">
			</td>
		</tr>
		<tr>
			<td class="textAlignRight verticalAlignMiddle">Can It Be Changed At Contract Creation?</th>
			<td>
				<input type="checkbox"$isChangeableChecked name="is_changeable">
			</td>
		</tr>
		<tr>
			<td class="textAlignRight" colspan="2">
				$deleteButton
			</td>
		</tr>
		</tbody>
	</table>

	<input type="hidden" id="subcontractItemTemplateUniqueId" value="$subcontract_item_template_id">
	<input type="hidden" id="$attributeGroupName--subcontract_item_templates--user_company_id--$subcontract_item_template_id" value="$user_company_id">
	<input type="hidden" id="$attributeGroupName--subcontract_item_templates--file_manager_file_id--$subcontract_item_template_id" value="$file_manager_file_id">
	<input type="hidden" id="$attributeGroupName--subcontract_item_templates--user_company_file_template_id--$subcontract_item_template_id" value="$user_company_file_template_id">

</form>
END_HTML_CONTENT;

	return $htmlContent;
}

function buildSubcontractItemTemplateDetailsDialogVersion2($database, $user_company_id, $project_id, $currentlyActiveContactId, $subcontract_item_template_id=null)
{
	$subcontractItemTemplate = false;
	if ($subcontract_item_template_id) {
		$subcontractItemTemplate = SubcontractItemTemplate::findSubcontractItemTemplateByIdExtended($database, $subcontract_item_template_id);
		/* @var $subcontractItemTemplate SubcontractItemTemplate */
	}

	$fileManagerFileUrl = '';
	$virtual_file_name = '';
	$escaped_virtual_file_name = '';

	if ($subcontractItemTemplate) {
		$user_company_id = $subcontractItemTemplate->user_company_id;
		$file_manager_file_id = $subcontractItemTemplate->file_manager_file_id;
		$user_company_file_template_id = $subcontractItemTemplate->user_company_file_template_id;
		$subcontract_item = $subcontractItemTemplate->subcontract_item;
		$subcontract_item_abbreviation = $subcontractItemTemplate->subcontract_item_abbreviation;
		$subcontract_item_template_type = $subcontractItemTemplate->subcontract_item_template_type;
		$sort_order = $subcontractItemTemplate->sort_order;
		$is_trackable = $subcontractItemTemplate->is_trackable;

		$disabled_flag = $subcontractItemTemplate->disabled_flag;

		$userCompany = $subcontractItemTemplate->getUserCompany();
		/* @var $userCompany UserCompany */

		$fileManagerFile = $subcontractItemTemplate->getFileManagerFile();
		/* @var $fileManagerFile FileManagerFile */
		if ($fileManagerFile) {
			$fileManagerFile->htmlEntityEscapeProperties();
			$fileManagerFileUrl = $fileManagerFile->generateUrl();
			$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
		}

		$userCompanyFileTemplate = $subcontractItemTemplate->getUserCompanyFileTemplate();
		/* @var $userCompanyFileTemplate UserCompanyFileTemplate */

		$attributeGroupName = 'manage-subcontract_item_template-record';
		$post_upload_js_callback = 'fileUploadedForExistingSubcontractItemTemplate(arrFileManagerFiles)';
		$deleteButton = <<<END_DELETE_BUTTON

			<input type="button" value="Delete Subcontract Item Template" onclick="deleteSubcontractItemTemplate('', '$attributeGroupName', '$subcontract_item_template_id');">
END_DELETE_BUTTON;

	} else {

		$subcontract_item_template_id = Data::generateDummyPrimaryKey();
		//$user_company_id = '';
		$file_manager_file_id = '';
		$user_company_file_template_id = '';
		$subcontract_item = '';
		$subcontract_item_abbreviation = '';
		$subcontract_item_template_type = '';
		$sort_order = '';
		$disabled_flag = '';

		$userCompany = '';
		$fileManagerFile = '';
		$userCompanyFileTemplate = false;

		$attributeGroupName = 'create-subcontract_item_template-record';
		$post_upload_js_callback = 'fileUploadedForNewSubcontractItemTemplate(arrFileManagerFiles)';
		$deleteButton = '';

	}

	// Create FileManagerFolder
	$virtual_file_path = '/Subcontract Item Templates/';
	$subcontractItemTemplateFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
	/* @var $subcontractItemTemplateFileManagerFolder FileManagerFolder */

	// Input for File Uploader HTML Widget
	$input = new Input();
	$input->id = 'subcontract_item_template_upload';
	$input->folder_id = $subcontractItemTemplateFileManagerFolder->file_manager_folder_id;
	$input->project_id = $project_id;
	$input->virtual_file_path = $virtual_file_path;
	// $input->virtual_file_name = date('Y-m-d H:i') . '.pdf';
	$input->prepend_date_to_filename = false;
	$input->action = '/modules-file-manager-file-uploader-ajax.php';
	$input->method = 'uploadFiles';
	$input->allowed_extensions = 'gif,jpg,jpeg,pdf,png,tif,tiff';
	$input->post_upload_js_callback = $post_upload_js_callback;
  $input->multiple = 'false';
	$uploader = buildFileUploader($input);
	$uploadWindow = buildFileUploaderProgressWindow();

	$arrSubcontractItemTemplateTypes = SubcontractItemTemplate::loadSubcontractItemTemplateTypes();
	$ddlSubcontractItemTemplateTypesElementId = "ddl--$attributeGroupName--subcontract_item_templates--subcontract_item_template_type--$subcontract_item_template_id";
	$hiddenSubcontractItemTemplateTypesElementId =   "$attributeGroupName--subcontract_item_templates--subcontract_item_template_type--$subcontract_item_template_id";
	$js = 'class="ddl--subcontract_item_template_type_id" onchange="ddlOnChange_UpdateHiddenInputValue(this); toggleSubcontractItemTemplateFormRows();" style="width: 99%;"';
	$ddlSubcontractItemTemplateTypes = PageComponents::dropDownList($ddlSubcontractItemTemplateTypesElementId, $arrSubcontractItemTemplateTypes, $subcontract_item_template_type, '', $js);

	$loadUserCompanyFileTemplatesByUserCompanyIdOptions = new Input();
	$loadUserCompanyFileTemplatesByUserCompanyIdOptions->forceLoadFlag = true;
	$arrUserCompanyFileTemplates = UserCompanyFileTemplate::loadUserCompanyFileTemplatesByUserCompanyId($database, $user_company_id, $loadUserCompanyFileTemplatesByUserCompanyIdOptions);

	$ddlUserCompanyFileTemplatesElementId = "ddl--$attributeGroupName--subcontract_item_templates--user_company_file_template_id--$subcontract_item_template_id";
	$hiddenUserCompanyFileTemplatesElementId =   "$attributeGroupName--subcontract_item_templates--user_company_file_template_id--$subcontract_item_template_id";
	$prependedOption = '<option value="0">Please Select a Template</option>';
	$js = ' onchange="ddlOnChange_UpdateHiddenInputValue(this);" style="width: 99%;"';
	$ddlUserCompanyFileTemplates = PageComponents::dropDownListFromObjects($ddlUserCompanyFileTemplatesElementId, $arrUserCompanyFileTemplates, 'user_company_file_template_id', null, 'template_name', null, $user_company_file_template_id, '', $js, $prependedOption);
	if($is_trackable=='Y')
	{
		$trackyes='checked="true"';
		$trackno='';
	}else
	{
		$trackno='checked="true"';
		$trackyes='';
	}

	$htmlContent = <<<END_HTML_CONTENT

<form id="formSubcontractItemTemplateDetails" class="widgetContainer" style="border:0; font-size:0.9em; margin:0">
	<table id="container--$attributeGroupName--$subcontract_item_template_id" width="100%" class="content" cellpadding="5" style="margin:0; padding:0">
		<tbody>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Subcontract Item:</th>
				<td width="60%"><input type="text" id="$attributeGroupName--subcontract_item_templates--subcontract_item--$subcontract_item_template_id" name="subcontract_item" value="$subcontract_item" style="width:96%;" class="required"></td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Subcontract Item Abbreviation:</th>
				<td><input type="text" id="$attributeGroupName--subcontract_item_templates--subcontract_item_abbreviation--$subcontract_item_template_id" name="subcontract_item_abbreviation" value="$subcontract_item_abbreviation" style="width:96%;"></td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Subcontract Item Template Type:</th>
				<td>
					$ddlSubcontractItemTemplateTypes
					<input id="$hiddenSubcontractItemTemplateTypesElementId" type="hidden" value="$subcontract_item_template_type">
				</td>
			</tr>
			<tr id="trFileUploader">
				<td class="textAlignRight verticalAlignMiddle">Upload a File:</th>
				<td>
					$uploader $uploadWindow
					<a href="$fileManagerFileUrl" id="$attributeGroupName--subcontract_item_templates--file_manager_file--$subcontract_item_template_id" target="_blank">$escaped_virtual_file_name</a>
					<input type="hidden" id="$attributeGroupName--subcontract_item_templates--file_manager_file_id--$subcontract_item_template_id" value="$file_manager_file_id">
				</td>
			</tr>
			<tr id="trUserCompanyFileTemplates">
				<td class="textAlignRight verticalAlignMiddle">File Template:</th>
				<td>
					$ddlUserCompanyFileTemplates
					<input id="$hiddenUserCompanyFileTemplatesElementId" type="hidden" value="$user_company_file_template_id">
				</td>
			</tr>
			<tr id="trUserCompanyDefaultTemplates" style="display:none;">
				<td class="textAlignRight verticalAlignMiddle"> Default:</th>
				<td>
				<input type="radio" value="Y" name="trackdata" class="radioLable" $trackyes>
				<span class="DCRtext">Yes</span>
				<input type="radio" value="N" name="trackdata" class="radioLable" $trackno><span class="DCRtext">No</span>
				
					<input id="$hiddenUserCompanyDefaultTemplatesElementId" type="hidden" value="">
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" id="subcontract_item_template_id" value="$subcontract_item_template_id">
	<input type="hidden" id="contactID" value="$currentlyActiveContactId">
	
</form>
END_HTML_CONTENT;

	$arrOutput = array(
		'content' => $htmlContent,
		'subcontract_item_template_id' => $subcontract_item_template_id,
		'attributeGroupName' => $attributeGroupName,
	);

	return $arrOutput;
}

function buildCreateSubcontractTemplateDialog($database,$currentlyActiveContactId)
{
	$loadAllSubcontractTypesOptions = new Input();
	$loadAllSubcontractTypesOptions->forceLoadFlag = true;
	$arrSubcontractTypes = SubcontractType::loadAllSubcontractTypes($database, $loadAllSubcontractTypesOptions);

	$ddlSubcontractTypeElementId = "ddl--create-subcontract_template-record--subcontract_templates--subcontract_type_id--dummy";
	$js = ' class="required" onchange="ddlOnChange_UpdateHiddenInputValue(this);" style="width:400px;"';
	$prependedOption = '<option value="">Please Select a Subcontract Type</option>';
	$ddlSubcontractType = PageComponents::dropDownListFromObjects($ddlSubcontractTypeElementId, $arrSubcontractTypes, 'subcontract_type_id', null, 'subcontract_type', null, '', '', $js, $prependedOption);
	$db = DBI::getInstance($database);
	//Fulcrum global admin
		$config = Zend_Registry::get('config');
   		$fulcrum_user = $config->system->fulcrum_user;
			 $companyQuery = "SELECT email FROM users where primary_contact_id='$currentlyActiveContactId'  limit 1 ";
   			$db->execute($companyQuery);
   	 		$row = $db->fetch();
   	 		$user_email=$row['email'];
     		$db->free_result();
     		if($user_email == $fulcrum_user)
     		{
     			$showDefault='1';
     		}else
     		{
     			$showDefault='0';
     		}

	$htmlContent = <<<END_HTML_CONTENT

<div class="widgetContainer textAlignCenter" style="margin-left:0; width:500px; border:0">
	<form id="record_creation_form_container--create-subcontract_template-record--dummy">
		<table class="content" width="95%" cellpadding="5">
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Name:</td>
				<td><input type="text" id="create-subcontract_template-record--subcontract_templates--subcontract_template_name--dummy" class="required" style="width: 390px;"></td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Type:</td>
				<td>$ddlSubcontractType<input id="create-subcontract_template-record--subcontract_templates--subcontract_type_id--dummy" type="hidden" value=""></td>
			</tr>
END_HTML_CONTENT;

			if($showDefault == '1')
			{
			$htmlContent .= <<<END_HTML_CONTENT

			<tr id="trUserCompanyDefaultTemplates">
				<td class="textAlignRight verticalAlignMiddle"> Default:</th>
				<td align="left"> 
				<input type="radio" value="Y" name="trackdata" id="trackdata" class="radioLable" $trackyes>
				<span class="DCRtext">Yes</span>
				<input type="radio" value="N" name="trackdata" id="trackdata" class="radioLable" $trackno><span class="DCRtext">No</span>
				</td>
			</tr>
END_HTML_CONTENT;
	}
	$htmlContent .= <<<END_HTML_CONTENT

		</table>
	</form>
</div>
END_HTML_CONTENT;

	return $htmlContent;
}

function buildSubcontractTemplates__AsTableRows($database, $user_company_id,$currentlyActiveContactId,$globalAccess, $subcontract_template_id=null)
{
	if (isset($subcontract_template_id) && !empty($subcontract_template_id)) {
		$subcontractTemplate = SubcontractTemplate::findById($database, $subcontract_template_id);
		$arrSubcontractTemplates = array($subcontractTemplate);
	} else {
		$arrSubcontractTemplates = SubcontractTemplate::loadSubcontractTemplatesByUserCompanyId($database, $user_company_id,$currentlyActiveContactId);
	}

	$subcontractTemplatesTbody = '';
	foreach ($arrSubcontractTemplates as $subcontractTemplate) {
		/* @var $subcontractTemplate SubcontractTemplate */

		$subcontract_template_id = (int) $subcontractTemplate->subcontract_template_id;
		$user_company_id = (int) $subcontractTemplate->user_company_id;
		$subcontract_type_id = (int) $subcontractTemplate->subcontract_type_id;
		$subcontract_template_name = (string) $subcontractTemplate->subcontract_template_name;
		$disabled_flag = (string) $subcontractTemplate->disabled_flag;
		$is_trackable = (string) $subcontractTemplate->is_trackable;
		// To check whether subcontract template is linked to any subcontracts
		$subres=SubcontractTemplate::checkforSubcontractTemplateLinkwithSubcontacts($database,$subcontract_template_id);

		if ($disabled_flag == 'N') {
			$enabledForUse = 'Enabled';
		} else {
			$enabledForUse = 'Disabled';
		}
		if($is_trackable == 'Y')
		{
			$defaultData='Yes';
			$Defaultset='checked=true';
		}else
		{
			$defaultData='No';
			$Defaultset='';
		}

		$subcontract_type = (string) $subcontractTemplate->subcontract_type;

		$subcontractTemplatesTbody .= <<<END_SUBCONTRACT_TEMPLATES_TBODY

		<tr id="record_container--view-subcontract_template-record--subcontract_templates--sort_order--$subcontract_template_id">
			<td class="tdSortBars" nowrap align="center"><img src="/images/sortbars.png"></td>
			<td id="view-subcontract_template-record--subcontract_templates--subcontract_template_name--$subcontract_template_id">$subcontract_template_name</td>
			<td id="view-subcontract_template-record--subcontract_templates--subcontract_type_id--$subcontract_template_id">$subcontract_type</td>
			<td id="view-subcontract_template-record--subcontract_templates--disabled_flag--$subcontract_template_id" class="textAlignCenter">$enabledForUse</td>
END_SUBCONTRACT_TEMPLATES_TBODY;
if($globalAccess == '1' && $user_company_id=='1')
{
$subcontractTemplatesTbody .= <<<END_SUBCONTRACT_TEMPLATES_TBODY
			
			<td class="textAlignCenter">
				<input type="checkbox" name="trackable" id="makedefault_$subcontract_template_id" class="checkbox_check" $Defaultset onclick="subcontractortemplateDefault($subcontract_template_id)"></td>
			
END_SUBCONTRACT_TEMPLATES_TBODY;
}if($globalAccess == '1' && $user_company_id !='1')
{
$subcontractTemplatesTbody .= <<<END_SUBCONTRACT_TEMPLATES_TBODY
			
			<td class="textAlignCenter"></td>
			
END_SUBCONTRACT_TEMPLATES_TBODY;
}
$subcontractTemplatesTbody .= <<<END_SUBCONTRACT_TEMPLATES_TBODY
			<td class="textAlignCenter"><a href="javascript:Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template('$subcontract_template_id');" style="color: #0e66c8;">Edit</a></td>
END_SUBCONTRACT_TEMPLATES_TBODY;


if($user_company_id !='1')
{
$subcontractTemplatesTbody .= <<<END_SUBCONTRACT_TEMPLATES_TBODY
			<td class="textAlignCenter">
				<span class="bs-tooltip colorLightGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant" onclick="Subcontracts__Admin__deleteSubcontractTemplate(this, event, $subcontract_template_id,'$subres');" title="Delete Subcontract Template">&nbsp;</span>
			</td>
END_SUBCONTRACT_TEMPLATES_TBODY;
}
if($globalAccess == '1' && $user_company_id=='1')
{
	$subcontractTemplatesTbody .= <<<END_SUBCONTRACT_TEMPLATES_TBODY
			<td class="textAlignCenter">
				<span class="bs-tooltip colorLightGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant" onclick="Subcontracts__Admin__deleteSubcontractTemplate(this, event, $subcontract_template_id,'$subres');" title="Delete Subcontract Template">&nbsp;</span>
			</td>
END_SUBCONTRACT_TEMPLATES_TBODY;

}

$subcontractTemplatesTbody .= <<<END_SUBCONTRACT_TEMPLATES_TBODY
		</tr>
END_SUBCONTRACT_TEMPLATES_TBODY;

	}

	return $subcontractTemplatesTbody;
}
 function ContactNameByuserId($database,$raised_by){
		$db = DBI::getInstance($database);
		$first_name = '';
        $query = "SELECT * FROM contacts where id='$raised_by'";
        $db->execute($query);
		while($row = $db->fetch())
		{
			if($row['first_name']!='' || $row['last_name']!='')
		   	$first_name = $row['first_name'].' '.$row['last_name'];
		   else
		   	$first_name=$row['email'];
		   	
		}
		return $first_name;

	}
	function subcontractorUpdated($subcontract_template_id,$attribute)
	{
		$db = DBI::getInstance($database);
	$query1 ="SELECT st2sit.`updated_by`, st2sit.`date`
FROM `subcontract_item_templates` sit
INNER JOIN `subcontract_templates_to_subcontract_item_templates` st2sit
WHERE sit.`id` = st2sit.`subcontract_item_template_id`
AND st2sit.`subcontract_template_id` = $subcontract_template_id
ORDER BY st2sit.`date` DESC limit 1";
	// $arrValues = array($subcontract_template_id);
	$db->execute($query1);
	$row1 = $db->fetch();
	 $updated_by=$row1['updated_by'];
	$updated_time=$row1['date'];
	
	$fromuserInfo = ContactNameByuserId($database,$updated_by);
	$db->free_result();
	if($attribute == "user")
	return $fromuserInfo;
	else
	return $updated_time;
	}

	function cloneDefaultTemplateForcurrentProject($database,$user_company_id)
	{
		//Fulcrum global admin
		$config = Zend_Registry::get('config');
		$fulcrum_user = $config->system->fulcrum_user;
		$db = DBI::getInstance($database);
		$companyQuery = "SELECT primary_contact_id  FROM users where email='$fulcrum_user'  limit 1 ";
		$db->execute($companyQuery);
		$row = $db->fetch();
		$fulcrum_globalUser=$row['primary_contact_id'];
		$db->free_result();

		$db = DBI::getInstance($database);
		$query1 ="SELECT * FROM `subcontract_templates` WHERE `user_company_id` = $user_company_id ";
		$db->execute($query1);
		$row1 = $db->fetch();
		$db->free_result();
		if($row1) 
		{
			return ;
		}
		else
		{
			//create templete for those company which has no templete
			$query2 ="SELECT * FROM `subcontract_templates` WHERE `user_company_id` = '1' and is_trackable='Y'";
			$db->execute($query2);
			$records=array();
			while($row2 = $db->fetch())
			{
				$records[]=$row2['id'];
			}
			$db->free_result();
			$sort=0;
			foreach ($records as $key => $row2) {
				
				$subClone=$row2;
				$db = DBI::getInstance($database);
				//To create a subcontract template
				$query3 ="INSERT INTO `subcontract_templates`(`user_company_id`, `subcontract_type_id`, `subcontract_template_name`, `sort_order`, `is_trackable`, `is_purchased`, `disabled_flag`) 
				select  $user_company_id, `subcontract_type_id`, `subcontract_template_name`, $sort, `is_trackable`, 'N', `disabled_flag`
				from subcontract_templates where id ='$subClone'";
				$db->execute($query3);
				$new_template = $db->insertId; 
				$db->free_result();
				$sort++;

				//To select the default item templates
				$db = DBI::getInstance($database);
				$query4 ="SELECT subcontract_item_template_id FROM subcontract_templates_to_subcontract_item_templates WHERE `subcontract_template_id` = $subClone";
				$db->execute($query4);
				$in_sort =0;
				$item_record=array();
				while ($row3 = $db->fetch()) {
					$item_record[]=$row3;
				}
				foreach ($item_record as $key => $row3) {
					
					$item_id=$row3['subcontract_item_template_id'];
					if($item_id !='2')
					{

						//To insert a item template
						$query3 ="INSERT INTO `subcontract_item_templates`(`user_company_id`, `file_manager_file_id`, `user_company_file_template_id`, `subcontract_item`, `subcontract_item_abbreviation`, `subcontract_item_template_type`, `sort_order`, `is_trackable`, `is_purchased`, `updated_by`, `disabled_flag`) 
						select  $user_company_id, NULL, `user_company_file_template_id`, `subcontract_item`, `subcontract_item_abbreviation`, `subcontract_item_template_type`, $in_sort, `is_trackable`, 'N', $fulcrum_globalUser, `disabled_flag`
						from subcontract_item_templates where id ='$item_id'";
						$db->execute($query3);
						$newitem_template = $db->insertId; 
						$db->free_result();
						

				//To insert a subcontract_templates_to_subcontract_item_templates
						$query4 ="INSERT INTO `subcontract_templates_to_subcontract_item_templates`(`subcontract_template_id`, `subcontract_item_template_id`, `sort_order`,  `updated_by`) 
						VAlues ($new_template, $newitem_template, $in_sort,  $fulcrum_globalUser)";
						$db->execute($query4);
						$db->free_result();
						$in_sort++;
					}
				}

				$db->free_result();
			}
			
			
			
		}
		
	}
