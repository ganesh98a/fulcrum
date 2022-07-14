<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * The following objects / variable drive this template:
 *
 * $database
 * $user_company_id
 * $project_id
 * $user_id
 *
 * Permissions:
 * $userCanViewProjects
 * $userCanCreateProjects
 * $userCanManageProjects
 * $userCanManageThirdPartyProjects
 *
 * $AXIS_NON_EXISTENT_PROJECT_ID
 * $AXIS_NON_EXISTENT_PROJECT_TYPE_ID
 *
 * $checkboxStyle
 * $fromCreateLink
 */
require_once('lib/common/Contact.php');
require_once('lib/common/Service/TableService.php');

function buildProjectInformationWidget(Input $input)
{

	$database = $input->database;
	$user_company_id = $input->user_company_id;
	$project_id = $input->project_id;
	$user_id = $input->user_id;

	$userCanViewProjects = $input->userCanViewProjects;
	$userCanCreateProjects = $input->userCanCreateProjects;
	$userCanManageProjects = $input->userCanManageProjects;
	$userCanManageThirdPartyProjects = $input->userCanManageThirdPartyProjects;
	$userCreateProjects =$input->userCreateProjects;

	$AXIS_NON_EXISTENT_PROJECT_ID = $input->nonExistentProjectId;
	$AXIS_NON_EXISTENT_PROJECT_TYPE_ID = $input->nonExistentProjectTypeId;
	$checkboxStyle = $input->checkboxStyle;


	if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {

		$project_type_id = $AXIS_NON_EXISTENT_PROJECT_TYPE_ID;
		$user_custom_project_id = '';
		$project_name = '';
		$project_owner_name = '';
		$owner_address = '';
		$owner_city = '';
		$owner_state_or_region = '';
		$owner_postal_code = '';
		$latitude = '';
		$longitude = '';
		$address_line_1 = '';
		$address_city = '';
		$address_state_or_region = '';
		$address_postal_code = '';
		$project_qb_customer_id = '';
		$building_count = '';
		$unit_count = '';
		$gross_square_footage = '';
		$net_rentable_square_footage = '';
		$is_active_flag_checked = '';
		$public_plans_flag_checked = '';
		$prevailing_wage_flag_checked = '';
		$project_contract_date = '';
		$project_start_date = '';
		$project_completed_date = '';
		$attributeGroupName = 'create-project-record';
		$onchange = '';
		$retainerRateOnChange = '';
		$retainer_rate = '';
		$draw_template_id = '';
		$time_zone_id = 1;
		$delivery_time_id = 7;
		$architect_cmpy_id = '';
		$architect_cont_id = '';
		$delivery_time = '19:00:00';
		$max_photos_displayed = '';
		$photos_displayed_per_page = '';
		$topButtons = <<<END_TOP_BUTTONS
		<input id="btnManageProjectTypes" class="buttonProjectInfoWidget" name="btnManageProjectTypes" tabindex="101" type="button" value="Manage Project Types" onclick="loadManageProjectTypesDialog();">
		<input class="buttonProjectInfoWidget" tabindex="102" type="button" value="Manage Meeting Types" onclick="loadManageMeetingTypesDialog();">
END_TOP_BUTTONS;

	} else {

		$project = Project::findProjectByIdExtended($database, $project_id);

		/* @var $project Project */
		$project_type_id = $project->project_type_id;
		$project_typeName = Project::getProjectTypeName($database,$project->project_type_id);
		$user_custom_project_id = $project->user_custom_project_id;
		$project_name = $project->project_name;
		$project_owner_name = $project->project_owner_name;
		$owner_address = $project->owner_address;
		$owner_city = $project->owner_city;
		$owner_state_or_region = $project->owner_state_or_region;
		$owner_postal_code = $project->owner_postal_code;
		$contract_entity_id = $project->contracting_entity_id;
		$project_qb_customer_id = $project->qb_customer_id;
		$max_photos_displayed = $project->max_photos_displayed;
		$photos_displayed_per_page = $project->photos_displayed_per_page;
		$COR_type = $project->COR_type;
		$alias_type =$project->alias_type;

		$latitude = (float) $project->latitude;
		$longitude = (float) $project->longitude;
		$address_line_1 = (string) $project->address_line_1;
		$address_city = (string) $project->address_city;
		$address_state_or_region = (string) $project->address_state_or_region;
		$address_postal_code = (string) $project->address_postal_code;

		$building_count = $project->building_count;
		$unit_count = $project->unit_count;
		$gross_square_footage = $project->gross_square_footage;
		$net_rentable_square_footage = $project->net_rentable_square_footage;

		$is_active_flag = (string) $project->is_active_flag;
		$public_plans_flag = (string) $project->public_plans_flag;
		$prevailing_wage_flag = (string) $project->prevailing_wage_flag;

		$project_contract_date = Date::convertDateTimeFormat($project->project_contract_date, 'html_form');
		$project_start_date = Date::convertDateTimeFormat($project->project_start_date, 'html_form');
		$project_completed_date = Date::convertDateTimeFormat($project->project_completed_date, 'html_form');

		$is_active_flag_checked = '';
		if ($is_active_flag == 'Y') {
			$is_active_flag_checked = 'checked';
		}
		$public_plans_flag_checked = '';
		if ($public_plans_flag == 'Y') {
			$public_plans_flag_checked = 'checked';
		}
		$prevailing_wage_flag_checked = '';
		if ($prevailing_wage_flag == 'Y') {
			$prevailing_wage_flag_checked = 'checked';
		}

		$encodedProjectName = Data::entity_encode($project_name);
    	$retainer_rate = $project->retainer_rate;
		$attributeGroupName = 'manage-project-record';
		$onchange = 'Projects_Admin__updateProject(this);';
    	$retainerRateOnChange = "showRetainerRateWarning(this,'$attributeGroupName',$project_id)";
		$draw_template_id = $project->draw_template_id;
		$time_zone_id = $project->time_zone_id;
		$delivery_time_id = $project->delivery_time_id;
		$delivery_time= $project->delivery_time;
		$architect_cmpy_id = $project->architect_cmpy_id;
		$architect_cont_id = $project->architect_cont_id;

		if ($userCanManageThirdPartyProjects || $userCanManageProjects || $userCanCreateProjects || $userCreateProjects) {
		$topButtons = <<<END_TOP_BUTTONS
		<input style="margin-bottom:10px;" tabindex="101" type="button" id="btnCreateNewProject" name="btnCreateNewProject" value="Create A New Project" onclick="showNewProject();" class="buttonProjectInfoWidget">
		<input style="margin-bottom:10px;" tabindex="102" type="button" id="btnManageProjectTypes" name="btnManageProjectTypes" value="Manage Project Types" onclick="loadManageProjectTypesDialog();" class="buttonProjectInfoWidget">
		<input style="margin-bottom:10px;" tabindex="103" type="button" value="Manage Meeting Types For $encodedProjectName" onclick="loadManageMeetingTypesDialog();" class="buttonProjectInfoWidget">
		<input style="margin-bottom:10px;" class="buttonProjectInfoWidget" tabindex="103" type="button" value="Manage buildings and units" onclick="document.location.href='building_unit.php'">
		<input style="margin-bottom:10px;" class="buttonProjectInfoWidget" tabindex="104" type="button" value="Manage Tags" onclick="document.location.href='ProjectTags.php'">
END_TOP_BUTTONS;
		}
	}

	$loadProjectTypesByUserCompanyIdOptions = new Input();
	$loadProjectTypesByUserCompanyIdOptions->forceLoadFlag = true;
	$loadProjectTypesByUserCompanyIdOptions->arrOrderByAttributes = array('id' => 'ASC');
	$arrProjectTypes = ProjectType::loadProjectTypesByUserCompanyId($database, $user_company_id, $loadProjectTypesByUserCompanyIdOptions);
	$ddlProjectTypesElementId = "$attributeGroupName--projects--project_type_id--$project_id";
	$js = 'onchange="'.$onchange.'" class="moduleProjectInformationDropdown required" width="92%"';
	$prependedOption = '<option value="-1">Select a Project Type</option>';
	$ddlProjectTypes = PageComponents::dropDownListFromObjects($ddlProjectTypesElementId, $arrProjectTypes, 'project_type_id', null, 'project_type', null, $project_type_id, 203, $js, $prependedOption);


	/* Contracting Entity - Start */
	$contracting_entity_name = '';
	if(!empty($contract_entity_id)){
		$contracting_entity_name = ContractingEntities::getcontractEntityNameforProject($database,$contract_entity_id);
		$arrcontracting_entity = ContractingEntities::getAllcontractEntitydata($database,$contract_entity_id);
		$contract_entity_license_number = $arrcontracting_entity['construction_license_number'];
		$contract_entity_state_number  = $arrcontracting_entity['state'];
	}
	//To get the project Main Company
	if($project_id =="1"){
		$parent_user_company_id = $user_company_id;
	}else
	{
		$parent_user_company_id = Project::ProjectsMainCompany($database,$project_id);
	}
	$contracting_entities = ContractingEntities::getContractEntityByUserCompanyId($database, $parent_user_company_id);
	// To make the contracting entity disable for those bidding projects
	if($parent_user_company_id != $user_company_id)
	{
		$entityDisable ='disabled="true"';
	}else
	{
		$entityDisable ='';
	}
	
	$entityonchange = 'Projects_Admin__contactEntity(this);';
	$contracting_entitiesElementId = "$attributeGroupName--projects--contracting_entity_id--$project_id";
	$js = 'onchange="'.$entityonchange.'" class="moduleProjectInformationDropdown required contract_id Contracting_Entity"  data-project_id="'.$project_id.'" style="width:94.3%;"'.$entityDisable;
	$prependedOption = '';
	$contracting_entities_drop = PageComponents::dropDownList($contracting_entitiesElementId, $contracting_entities, $contract_entity_id, '', $js, true,$prependedOption);

	$projectCustArr = getProjectCustomers($database,$user_company_id);
	
	if ($userCanManageThirdPartyProjects || $userCanManageProjects || $userCanCreateProjects ||$userCreateProjects) {
		$qb_cust_html = "<select id='$attributeGroupName--projects--qb_customer_id--".$project_id."' class='qb_customer_edit moduleProjectInformationDropdown' onchange='Projects_Admin__updateProject(this);' style='width: 94%;'>
			<option value=''>Select a QB Customer</option>";
		foreach($projectCustArr as $qb_customer_id => $qb_customer){
			$project_cust_selected = '';
			if(!empty($project_qb_customer_id) && $qb_customer_id == $project_qb_customer_id){
				$project_cust_selected = " selected='selected'";
			}
			$qb_cust_html .= "<option value='".$qb_customer_id."' ".$project_cust_selected.">".$qb_customer."</option>";
		}
		$qb_cust_html .= "</select> <a href='javascript:void(0);' onclick='refreshProjectCustomer();'  title='Click to Check Availability &amp; get Project Customer from QB'  style='margin-left: 10px;'><img src='/images/refresh_icon.png' style='height:25px; width:25px;'></a>";

				
	} elseif ($userCanViewProjects) {
		$qb_cust_html = 'No Project:customer Selected';
		if(!empty($projectCustArr[$project_qb_customer_id])){
			$qb_cust_html = $projectCustArr[$project_qb_customer_id];
		}
	}
	

	/* Contracting Entity - End */
	require_once('lib/common/DrawActionTypeOptions.php');
	require_once('lib/common/DrawSignatureType.php');
	$loadarrDrawActionOptionRows = new Input();
	$loadarrDrawActionOptionRows->forceLoadFlag = true;
	$loadarrDrawActionOptionRows->arrOrderByAttributes = array(
		'dato.`id`' => 'ASC'
	);
	$draw_action_type_id = 2;
	$arrDrawActionTypeOptions = DrawActionTypeOptions::loadAllDrawActionTypeOptionsByActId($database, $draw_action_type_id, $loadarrDrawActionOptionRows);

	$ddlDrawTemplatesElementId = "$attributeGroupName--projects--draw_template_id--$project_id";
	$jsDrawTemplate = 'onchange="'.$onchange.'viewDefaultDrawTemplate(this);" class="moduleProjectInformationDropdown"';
	$prependedTemplateOption = '<option value="">Set Default Template</option>';
	$ddlDrawTemplates = PageComponents::dropDownListFromObjects($ddlDrawTemplatesElementId, $arrDrawActionTypeOptions
	, 'id', null, 'option_name', null, $draw_template_id, 509, $jsDrawTemplate, $prependedTemplateOption);

	$arrTimeZoneTypeOptions = DrawActionTypeOptions::loadAllTimeZone($database);
	$ddlTimeZoneElementId = "$attributeGroupName--projects--time_zone_id--$project_id";
	$jsTimeZone = "onchange='".$onchange."setDeliveryTime(&apos;".$attributeGroupName."&apos;,".$project_id.");' class='moduleProjectInformationDropdown' style='width:100%;'";
	$ddlTimeZone = PageComponents::dropDownListFromArray($ddlTimeZoneElementId, $arrTimeZoneTypeOptions
	, 'id', null, 'name', null, $time_zone_id, 509, $jsTimeZone);

	$arrDeliveryTimeTypeOptions = DrawActionTypeOptions::loadAllDeliveryTime($database);
	$ddlDeliveryTimeElementId = "$attributeGroupName--projects--delivery_time_id--$project_id";
	$jsDeliveryTime = "onchange='".$onchange."setDeliveryTime(&apos;".$attributeGroupName."&apos;,".$project_id.");' class='moduleProjectInformationDropdown' style='width:100%;'";
	$ddlDeliveryTime = PageComponents::dropDownListFromArray($ddlDeliveryTimeElementId, $arrDeliveryTimeTypeOptions
	, 'id', null, 'value', null, $delivery_time_id, 509, $jsDeliveryTime);

	$drawActionOptionName = DrawActionTypeOptions::getDrawActionOptionName($database,$draw_template_id);

	$ddlTimeZoneName = DrawActionTypeOptions::getTimeZone($database,$time_zone_id);

	$arrArchitectCmpyOptions = ContactCompany::loadContactCompaniesByUserUserCompanyId($database, $user_company_id);
	$ddlArchitectCmpyId = "$attributeGroupName--projects--architect_cmpy_id--$project_id";
	$jsArchitectCmpy = "onchange='".$onchange."renderCmpyContact(this,".$user_company_id.",".$project_id.");' class='moduleProjectInformationDropdown' style='width:100%;'";
	$prependedTemplateOption = '<option value="">Please Select A Company / Vendor</option>';
	$architectCmpyName = PageComponents::dropDownListFromArray($ddlArchitectCmpyId, $arrArchitectCmpyOptions
	, 'id', null, 'company', null, $architect_cmpy_id, 509, $jsArchitectCmpy,$prependedTemplateOption);
	$architectCmpyNameRaw = ContactCompany::findByContactUserCompanyId($database, $architect_cmpy_id);


	$arrArchitectContOptions = Contact::loadContactsByUserCompanyIdAndContactCompanyId($database, $user_company_id, $architect_cmpy_id, 1);
	$ddlArchitectContId = "$attributeGroupName--projects--architect_cont_id--$project_id";
	$jsArchitectCont = "onchange='".$onchange."' class='moduleProjectInformationDropdown' style='width:100%;'";
	$prependedTemplateOption = '<option value="">Please Select A Contact</option>';
	$architectContName = PageComponents::dropDownListFromArray($ddlArchitectContId, $arrArchitectContOptions
	, 'id', null, 'name', null, $architect_cont_id, 509, $jsArchitectCont,$prependedTemplateOption);
	$contactName = Contact::findById($database, $architect_cont_id);
	$architectContNameRaw = ($contactName == '') ? '' : $contactName->getContactFullName();

	$ddlDeliveryTimeName = DrawActionTypeOptions::getDeliveryTime($database,$delivery_time_id);
	
	if ($userCanManageThirdPartyProjects || $userCanManageProjects || $userCanCreateProjects ||$userCreateProjects) {
		$projectNameHtml				= '<input id="'.$attributeGroupName.'--projects--project_name--'				.$project_id.'" type="text" tabindex="201"  value="'.$project_name.'" class="required" onchange="'.$onchange.'">';
		$userCustomProjectIdHtml		= '<input id="'.$attributeGroupName.'--projects--user_custom_project_id--'		.$project_id.'" type="text" tabindex="202"  value="'.$user_custom_project_id.'" onchange="'.$onchange.'" maxlength="12">';
		$buildingCountHtml				= '<input id="'.$attributeGroupName.'--projects--building_count--'				.$project_id.'" type="text" tabindex="204"  value="'.$building_count.'" class="positive-integer" onchange="'.$onchange.'">';
		$unitCountHtml					= '<input id="'.$attributeGroupName.'--projects--unit_count--'					.$project_id.'" type="text" tabindex="205"  value="'.$unit_count.'" class="positive-integer" onchange="'.$onchange.'">';
		$grossSquareFootageHtml			= '<input id="'.$attributeGroupName.'--projects--gross_square_footage--'		.$project_id.'" type="text" tabindex="206"  value="'.$gross_square_footage.'" class="positive-integer" onchange="'.$onchange.'">';
		$netRentableSquareFootageHtml	= '<input id="'.$attributeGroupName.'--projects--net_rentable_square_footage--'	.$project_id.'" type="text" tabindex="207"  value="'.$net_rentable_square_footage.'" class="positive-integer" onchange="'.$onchange.'">';
		$isActiveFlagHtml				= '<input id="'.$attributeGroupName.'--projects--is_active_flag--'				.$project_id.'" type="checkbox" tabindex="302" '.$checkboxStyle.' '.$is_active_flag_checked.' onchange="'.$onchange.'">';
		$publicPlansFlagHtml			= '<input id="'.$attributeGroupName.'--projects--public_plans_flag--'			.$project_id.'" type="checkbox" tabindex="303" '.$checkboxStyle.' '.$public_plans_flag_checked.' onchange="'.$onchange.'">';
		$prevailingWageFlagHtml			= '<input id="'.$attributeGroupName.'--projects--prevailing_wage_flag--'		.$project_id.'" type="checkbox" tabindex="304" '.$checkboxStyle.' '.$prevailing_wage_flag_checked.' onchange="'.$onchange.'">';
		$contractDateHtml				= '<input id="'.$attributeGroupName.'--projects--project_contract_date--'		.$project_id.'" type="text" tabindex="401"  value="'.$project_contract_date.'" class="datepicker" onchange="'.$onchange.'" style="width: 150px">';
		$projectStartDateHtml			= '<input id="'.$attributeGroupName.'--projects--project_start_date--'			.$project_id.'" type="text" tabindex="402"  value="'.$project_start_date.'" class="datepicker" onchange="'.$onchange.'" style="width: 150px">';
		$completionDateHtml				= '<input id="'.$attributeGroupName.'--projects--project_completed_date--'		.$project_id.'" type="text" tabindex="403" value="'.$project_completed_date.'" class="datepicker" onchange="'.$onchange.'" style="width: 150px">';
		$addressLineOneHtml				= '<input id="'.$attributeGroupName.'--projects--address_line_1--'				.$project_id.'" type="text" tabindex="501" value="'.$address_line_1.'" onchange="'.$onchange.'">';
		$addressCityHtml				= '<input id="'.$attributeGroupName.'--projects--address_city--'				.$project_id.'" type="text" tabindex="502" value="'.$address_city.'" onchange="'.$onchange.'">';
		$addressStateOrRegionHtml		= '<input id="'.$attributeGroupName.'--projects--address_state_or_region--'		.$project_id.'" type="text" tabindex="503" value="'.$address_state_or_region.'" onchange="'.$onchange.'">';
		$addressPostalCodeHtml			= '<input id="'.$attributeGroupName.'--projects--address_postal_code--'			.$project_id.'" type="text" tabindex="504" value="'.$address_postal_code.'" onchange="'.$onchange.'">';
		$projectOwnerNameHtml			= '<input id="'.$attributeGroupName.'--projects--project_owner_name--'			.$project_id.'" type="text" tabindex="505" value="'.$project_owner_name.'" onchange="'.$onchange.'">';
		$ownerAddressHtml			= '<input id="'.$attributeGroupName.'--projects--owner_address--'			.$project_id.'" type="text" tabindex="505" value="'.$owner_address.'" onchange="'.$onchange.'">';
		$ownerCityHtml			= '<input id="'.$attributeGroupName.'--projects--owner_city--'			.$project_id.'" type="text" tabindex="505" value="'.$owner_city.'" onchange="'.$onchange.'">';
		$ownerStateOrRegionHtml			= '<input id="'.$attributeGroupName.'--projects--owner_state_or_region--'			.$project_id.'" type="text" tabindex="505" value="'.$owner_state_or_region.'" onchange="'.$onchange.'">';
		$ownerPostalCodeHtml			= '<input id="'.$attributeGroupName.'--projects--owner_postal_code--'			.$project_id.'" type="text" tabindex="505" value="'.$owner_postal_code.'" onchange="'.$onchange.'">';
		$latitudeHtml					= '<input id="'.$attributeGroupName.'--projects--latitude--'					.$project_id.'" type="text" tabindex="506" value="'.$latitude.'" onchange="'.$onchange.'">';
		$longitudeHtml					= '<input id="'.$attributeGroupName.'--projects--longitude--'					.$project_id.'" type="text" tabindex="507" value="'.$longitude.'" onchange="'.$onchange.'">';
		$ddlProjectTypesHtml			= $ddlProjectTypes;
		$contracting_entities_Html = $contracting_entities_drop;
		$hiddenReatinerRate = '<input type="hidden" id="'.$attributeGroupName.'--projects--retainer_rate_hidden--'.$project_id.'" type="text" value="'.$retainer_rate.'">';
		if(!empty($project_id) && ($parent_user_company_id == $user_company_id)){
			$contracting_entities_Html .= '<span id="btnAddContractEntityPopover" class="btnAddContractEntityPopover btn entypo entypo-click entypo-plus-circled popoverButton" data-toggle="popover" style="margin-left:7px"></span>';
		}

		$contracting_entity_license = '<span>Contracting Entity </span> License Number:';
		$contracting_entity_license_html = '<span id="span_contract_license"><input id="'.$attributeGroupName.'--contracting_entities--construction_license_number--'.$contract_entity_id.'" type="text" tabindex="508" value="'.$contract_entity_license_number.'" onchange="ContractingEntityUpdate(this)"'. $entityDisable.' class="Contracting_Entity"></span>';

		$contracting_entity_state = '<span>Contracting Entity </span> State :';
		$contracting_entity_state_html = '<span id="span_contract_state"><input id="'.$attributeGroupName.'--contracting_entities--state--'.$contract_entity_id.'" type="text" tabindex="508" value="'.$contract_entity_state_number.'" onchange="ContractingEntityUpdate(this)"'. $entityDisable.' class="Contracting_Entity"></span>';


		$projectCustomerHtml = $qb_cust_html;
		
    	$retainerRateHtml = '<input id="'.$attributeGroupName.'--projects--retainer_rate--'.$project_id.'" type="text" tabindex="508"  value="'.$retainer_rate.'" class="retainer_rate_value" onchange="'.$retainerRateOnChange.'">';
		$retainerRateHtml = $hiddenReatinerRate.$retainerRateHtml;
		
		$ddlDrawTemplatesHtml =$ddlDrawTemplates;
		$ddlTimeZoneHtml =$ddlTimeZone;
		$ddlDeliveryTimeHtml =$ddlDeliveryTime;
		$architectCmpyNameHtml = $architectCmpyName;
		$architectContNameHtml = $architectContName;


		$ddlphotosDisplayedPerPageId = "$attributeGroupName--projects--photos_displayed_per_page--$project_id";
		$jsphotosDisplayedPerPage = "onchange='Projects_Admin__updateProject(this);' class='moduleProjectInformationDropdown' style='width:100%;'";

		$ddlphotosDisplayedPerPage =  PageComponents::dropDownList($ddlphotosDisplayedPerPageId, array('1'=>'1','2'=>'2'), $photos_displayed_per_page, '511', $jsphotosDisplayedPerPage);

		$ddlmaxRecentPhotosDisplayedId = "$attributeGroupName--projects--max_photos_displayed--$project_id";
		$jsmaxRecentPhotosDisplayed = " onchange='Projects_Admin__updateProject(this);' class='moduleProjectInformationDropdown' style='width:100%;'";
		
		$ddlmaxRecentPhotosDisplayed =  PageComponents::dropDownList($ddlmaxRecentPhotosDisplayedId, array('4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12'), $max_photos_displayed, '512', $jsmaxRecentPhotosDisplayed);

		$drawStatus = Draws::getFirstDrawStatus($database,$project_id);
		$drawDisableStatus = 'disabled="true"';
		if ($drawStatus) {
			$drawDisableStatus = '';
		}
		
		$ddlCORTypeId = "$attributeGroupName--projects--COR_type--$project_id";
		$jsCORDisplayed = " onchange='Projects_Admin__updateProject(this);' class='moduleProjectInformationDropdown' style='width:100%;' $drawDisableStatus";

		$ddlCORType =  PageComponents::dropDownList($ddlCORTypeId, array('1'=>'COR below the line','2'=>'COR Above the line'), $COR_type, '512', $jsCORDisplayed);

		$aliasCompany = Contact::OwnerContactInGCProjectForadminProject($database,$project_id);


		$ddlAliasTypeId = "$attributeGroupName--projects--alias_type--$project_id";
		$jsAliasDisplayed = " onchange='Projects_Admin__updateProject(this);' class='moduleProjectInformationDropdown' style='width:100%;'";

		$ddlaliasType =  PageComponents::dropDownList($ddlAliasTypeId, $aliasCompany, $alias_type, '513', $jsAliasDisplayed,'','<option value="0">select</option>');


		$photosDisplayedPerPageHtml = $ddlphotosDisplayedPerPage;
		$maxRecentPhotosDisplayedHtml = $ddlmaxRecentPhotosDisplayed;
	} elseif ($userCanViewProjects) {
		$COR_type = ($COR_type =='1')?'COR below the line':'COR Above the line';
		// to get the alias company id
		$ddlaliasType_data = TableService::getSingleField($database,'user_companies','company','id',$alias_type);
		$projectNameHtml = $project_name;
		$userCustomProjectIdHtml = $user_custom_project_id;
		$ddlProjectTypesHtml = $project_typeName;
		$contracting_entities_Html = $contracting_entity_name;
		$contracting_entity_license = '<span>Contracting Entity </span> License Number:';
		$contracting_entity_license_html = $contract_entity_license_number;
		$contracting_entity_state = '<span>Contracting Entity </span> State :';
		$contracting_entity_state_html = $contract_entity_state;
		$projectCustomerHtml = $qb_cust_html;
		$buildingCountHtml = $building_count;
		$unitCountHtml = $unit_count;
		$grossSquareFootageHtml = $gross_square_footage;
		$netRentableSquareFootageHtml = $net_rentable_square_footage;
		$isActiveFlagHtml = $is_active_flag;
		$publicPlansFlagHtml = $public_plans_flag;
		$prevailingWageFlagHtml = $prevailing_wage_flag;
		$contractDateHtml = $project_contract_date;
		$projectStartDateHtml = $project_start_date;
		$completionDateHtml = $project_completed_date;
		$addressLineOneHtml = $address_line_1;
		$addressCityHtml = $address_city;
		$addressStateOrRegionHtml = $address_state_or_region;
		$addressPostalCodeHtml = $address_postal_code;
		$latitudeHtml = $latitude;
		$longitudeHtml = $longitude;
		$retainerRateHtml = $retainer_rate;
		$ddlDrawTemplatesHtml =$drawActionOptionName;
		$ddlTimeZoneHtml =$ddlTimeZoneName;
		$architectCmpyNameHtml = $architectCmpyNameRaw;
		$architectContNameHtml = $architectContNameRaw;
		$ddlDeliveryTimeHtml =$ddlDeliveryTimeName;
		$photosDisplayedPerPageHtml = $photos_displayed_per_page;
		$maxRecentPhotosDisplayedHtml = $max_photos_displayed;
		$ddlCORType = $COR_type;
		$ddlaliasType = $ddlaliasType_data;
	}

	if ($userCanViewProjects && ( isset($arrProjectTypesOptions[$project_type_id]) && !empty($arrProjectTypesOptions[$project_type_id]) ) ) {
		$ddlProjectTypesHtml = $arrProjectTypesOptions[$project_type_id];
	}

	$bottomButtons = '';
	if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
		$bottomButtons = <<<END_BOTTOM_BUTTONS
			<input name="btnCancelNewProject" id="btnCancelNewProject" class="buttonProjectInfoWidget" tabindex="602" type="button" value="Cancel New Project" onclick="cancelNewProject();">
			<input name="btnSaveNewProject" id="btnSaveNewProject" class="buttonProjectInfoWidget" tabindex="601" type="button" value="Save New Project" onclick="Projects_Admin__createProject('$attributeGroupName', '$project_id');">
END_BOTTOM_BUTTONS;
	}

	$user = User::findUserById($database, $user_id);
	$isDefaultChecked = '';
	if ($user->default_project_id == $project_id) {
		$isDefaultChecked = ' checked';
	}
	$myDefaultProjectHtml = <<<END_MY_DEFAULT_PROJECT_HTML
	<input  id="$attributeGroupName--users--default_project_id--$project_id" type="checkbox"$isDefaultChecked tabindex="301" value="$project_id" onchange="$onchange">
END_MY_DEFAULT_PROJECT_HTML;


	$htmlContent = <<<END_HTML_CONTENT

<div id="container--$attributeGroupName--$project_id" class="moduleProjectInformation">
	<div style="margin:25px 0px;">
		$topButtons
	</div>

	<table class="moduleProjectInformation" border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td class="formAttributeKey" width="12%">Project Name:</td>
			<td class="formAttributeValue" width="37%">$projectNameHtml</td>
			<td class="formAttributeKey" width="12%">Active?:</td>
			<td class="formAttributeValue" width="3%">$isActiveFlagHtml</td>
			<td class="formAttributeKey" width="3%">Contract Date:</td>
			<td class="formAttributeValue" width="29%">$contractDateHtml</td>
		</tr>
		<tr>
			<td class="formAttributeKey">Project ID:</td>
			<td class="formAttributeValue">$userCustomProjectIdHtml</td>
			<td class="formAttributeKey">Bidding?:</td>
			<td class="formAttributeValue">$publicPlansFlagHtml</td>
			<td class="formAttributeKey">Start Date:</td>
			<td class="formAttributeValue">$projectStartDateHtml</td>
		</tr>
		<tr>
			<td class="formAttributeKey">Project Type:</td>
			<td class="formAttributeValue">$ddlProjectTypesHtml</td>
			<td class="formAttributeKey">Prevailing Wage?:</td>
			<td class="formAttributeValue">$prevailingWageFlagHtml</td>
			<td class="formAttributeKey">Completion Date:</td>
			<td class="formAttributeValue">$completionDateHtml</td>
		</tr>
		<tr>
			<td class="formAttributeKey">Building Count:</td>
			<td class="formAttributeValue">$buildingCountHtml</td>
			<td class="formAttributeKey">Project Address:</td>
			<td class="formAttributeValue" colspan="3">$addressLineOneHtml</td>
		</tr>
		<tr>
			<td class="formAttributeKey">Unit Count:</td>
			<td class="formAttributeValue">$unitCountHtml</td>
			<td class="formAttributeKey">City:</td>
			<td class="formAttributeValue" colspan="3">$addressCityHtml</td>
		</tr>
		<tr>
			<td class="formAttributeKey">Gross Square Feet:</td>
			<td class="formAttributeValue">$grossSquareFootageHtml</td>
			<td class="formAttributeKey">State:</td>
			<td class="formAttributeValue" colspan="3">$addressStateOrRegionHtml</td>
		</tr>
		<tr>
			<td class="formAttributeKey" nowrap>Net Rentable Square Feet:</td>
			<td class="formAttributeValue">$netRentableSquareFootageHtml</td>
			<td class="formAttributeKey">Zip:</td>
			<td class="formAttributeValue" colspan="3">$addressPostalCodeHtml</td>
		</tr>
		<tr>
			<td class="formAttributeKey">My Default Project?</td>
			<td class="formAttributeValue">$myDefaultProjectHtml</td>
			<td class="formAttributeKey">Latitude:</td>
			<td class="formAttributeValue" colspan="3">$latitudeHtml</td>
		</tr>
		<tr>
			<td class="formAttributeKey">Contracting Entity:</td>
			<td class="formAttributeValue">$contracting_entities_Html</td>
			<td class="formAttributeKey">Longtitude:</td>
			<td class="formAttributeValue" colspan="3">$longitudeHtml</td>			
		</tr>
		<tr>
			<td class="formAttributeKey">$contracting_entity_state</td>
			<td class="formAttributeValue">$contracting_entity_state_html</td>
			
		</tr>
		<tr>
			<td class="formAttributeKey">$contracting_entity_license</td>
			<td class="formAttributeValue">$contracting_entity_license_html</td>
			
		</tr>
		<tr>
			<td class="formAttributeKey current_indicator"><img src="/images/QBOlogo.png" style="height:25px; width:25px;" title="QB" alt="QB"> Customer:Project</td>
			<td class="formAttributeValue">$projectCustomerHtml</td>
			<td class="formAttributeKey"></td>
			<td class="formAttributeValue" colspan="3"></td>
		</tr>
	</table>
	<div class="">
	<h3 class="form-heading">Project Owner</h3>
		<table class = "moduleManageDraws m-b-15" border = "0" cellpadding = "4" cellspacing="0" style="width: 100%;">
			<tr>
				<td class="formAttributeKey" style="width: 22%;">Project Owner:</td>
				<td class="formAttributeValue" style="width: 32%;">$projectOwnerNameHtml</td>
				<td class="formAttributeKey" style="width: 12%;">Owner Address:</td>
				<td class="formAttributeValue" >$ownerAddressHtml</td>
			</tr>
			<tr>
				<td class="formAttributeKey" style="width: 22%;">City:</td>
				<td class="formAttributeValue" style="width: 32%;">$ownerCityHtml</td>
				<td class="formAttributeKey" style="width: 12%;">State:</td>
				<td class="formAttributeValue" >$ownerStateOrRegionHtml</td>
			</tr>
			<tr>
				<td class="formAttributeKey" style="width: 22%;">Zip:</td>
				<td class="formAttributeValue" style="width: 32%;">$ownerPostalCodeHtml</td>
			</tr>
		</table>
	</div>
	<div>
	<h3 class="form-heading">Project Architect</h3>
		<table class = "moduleManageDraws m-b-15" border = "0" cellpadding = "4" cellspacing="0" style="width: 100%;">
			<tr>
				<td class="formAttributeKey" style="width: 22%;">Company:</td>
				<td class="formAttributeValue" style="width: 32%;">$architectCmpyNameHtml</td>
				<td class="formAttributeKey" style="width: 12%;">Contact:</td>
				<td class="formAttributeValue" id="architect_cont_$project_id">$architectContNameHtml</td>
			</tr>
		</table>
	<div>
	<div class="">
	<h3 class="form-heading">Manage Draws</h3>
		<table class = "moduleManageDraws m-b-15" border = "0" cellpadding = "4" cellspacing="0" style="width: 100%;">
			<tr>
				<td class="formAttributeKey" style="width: 22%;">Retention Rate%:</td>
				<td class="formAttributeValue" style="width: 32%;">$retainerRateHtml</td>
				<td class="formAttributeKey" style="width: 12%;">Print Draw:</td>
				<td class="formAttributeValue" >
				$ddlDrawTemplatesHtml
				<a id="viewTemplate" href="/draw-templates.php?templateId=$draw_template_id" target="_blank">View default template</a>
				</td>
			</tr>
		</table>
	</div>
	<div class="">
		<h3 class="form-heading">Manage DCR</h3>
		<table class="moduleManageDraws m-b-15" border="0" cellpadding="4" cellspacing="0" style="width:97%;">
			<tr>			
				<td class="formAttributeKey" style="width:20%;">Time Zone:</td>
				<td class="formAttributeValue" style="width:34%;">$ddlTimeZoneHtml</td>
				<td class="formAttributeKey" style="width:15%;">Delivery Time:</td>
				<td class="formAttributeValue" style="width:30%;">
					$ddlDeliveryTimeHtml
					<input type="hidden" onchange="$onchange" value="$delivery_time" id="$attributeGroupName--projects--delivery_time--$project_id">
				</td>		
			</tr>
			<tr>
				<td class="formAttributeKey">Max Photos displayed:</td>
				<td class="formAttributeKey">$maxRecentPhotosDisplayedHtml</td>
			</tr>					
		</table>
	</div>
	<div class="">
		<h3 class="form-heading">Manage COR</h3>
		<table class="moduleManageDraws m-b-15" border="0" cellpadding="4" cellspacing="0" style="width:97%;">
			<tr>			
				<td class="formAttributeKey" style="width:20%;">Type :</td>
				<td class="formAttributeValue" style="width:34%;">$ddlCORType</td>	
				<td colspan='2'></td>		
			</tr>
							
		</table>
	</div>
	<div class="">
		<h3 class="form-heading">Manage Alias</h3>
		<table class="moduleManageDraws m-b-15" border="0" cellpadding="4" cellspacing="0" style="width:97%;">
			<tr>			
				<td class="formAttributeKey" style="width:20%;">Select :</td>
				<td class="formAttributeValue" style="width:34%;">$ddlaliasType</td>	
				<td colspan='2'></td>		
			</tr>
							
		</table>
	</div>
	<div>
		$bottomButtons
	</div>
</div>
<div id="ContractEntity-$project_id" class="hidden">
	<div id="record_creation_form_container--create-contact_company_office_phone_number-record--$project_id">
		<input type="hidden" id="user_company_id" value="$user_company_id">
		<div>
		<label>Entity:</label> <input type="text" id="contract_entity_val" style="width: 239px; float: initial;">
		</div>
		<div style="margin-top:5px;">
			<label>State:</label> <input type="text" id="entity_state" style="width: 239px; float: initial;" >
		</div>
		<div style="margin-top:5px;">
			<label>License Number:</label> <input type="text" id="construction_license_number" style="width: 239px; float: initial;" maxlength="14">
		</div>
		<div class="textAlignRight" style="margin-top:5px"><input type="submit" value="Create Contracting Entity" onclick="addContractEntity();" style="width: 400px; padding: 4px;"></div>
	</div>
</div>
<script>
$(".btnAddContractEntityPopover").popover({
	html: true,
	title: 'Add New Contracting Entity',
	content: function() {
		var project_id = $('#the_project_id').val();
		var content = $("#ContractEntity-"+ project_id).html();
		$("#ContractEntity-" + project_id).html('');
		$(this).on('hide.bs.popover', function() {
			$("#ContractEntity-" + project_id).html(content);
		});
		return content;
	}
}).click(function (e) {
	$('[data-original-title]').popover('hide');
	$(this).popover('show');
});
</script>

END_HTML_CONTENT;

	return $htmlContent;
}
