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
 * OrmView class for the HTML Record pattern.
 *
 * @category	Framework
 * @package		OrmView
 */

class OrmView
{
	const ContainerPrefix = 'container--';
	const RecordListContainerPrefix = 'record_list_container--';
	const RecordContainerPrefix = 'record_container--';

	private $_orm;

	public function getOrm()
	{
		if (isset($this->_orm)) {
			return $this->_orm;
		} else {
			return false;
		}
	}

	public function setOrm($orm)
	{
		$this->_orm = $orm;
	}

	// Standard HMTL Widget variables
	public $creationFormAttributeGroup;
	public $creationFormOnchangeHandler;

	public $attributeGroup;
	public $attributeSubgroup;
	public $attribute;
	public $onchangeHandler;

	public function __construct($orm, $attributeGroup=null, $attributeSubgroup=null, $onchangeHandler=null)
	{
		/* @var $orm IntegratedMapper */
		$orm->htmlEntityEscapeProperties();
		$this->_orm = $orm;

		//updateProject(this, { responseDataType : 'json' });

		// E.g. manage-project-record
		if (!isset($attributeGroup)) {
			$attributeGroup = $orm->deriveHtmlAttributeGroup();
		}

		// E.g. projects
		if (!isset($attributeSubgroup)) {
			$attributeSubgroup = $orm->deriveHtmlAttributeSubgroup();
		}
	}

	public function __destruct()
	{
	}

	/**
	 * Output HTML as a <td></td> for one attribute only.
	 *
	 * Options:
	 * <input>
	 * <textarea>
	 * pure text only
	 *
	 * nl2br version
	 *
	 */
	//public function renderAttributeAsTd($attributeName, $attributeValue, $uniqueId, Input $options)
	public function renderHtmlRecordAttributeAsTd($attributeName, Input $options=null)
	{
		$orm = $this->_orm;
		/* @var $orm IntegratedMapper */

		$ormProperty = $attributeName;
		$verified = $orm->verifyExistenceOfProperty($ormProperty);

		$escapedOrmProperty = "escaped_{$attributeName}";
		$escapedOrmPropertyNl2br = "escaped_{$attributeName}_nl2br";

		$attributeValue = $orm->$ormProperty;

		$escapedAttributeValue = $orm->$escapedOrmProperty;
		$escapedAttributeValueNl2br = $orm->$escapedOrmPropertyNl2br;
		$uniqueId = $orm->getPrimaryKeyAsString();

		$attributeGroup = $this->attributeGroup;
		$attributeSubgroup = $this->attributeSubgroup;
		$onchangeHandler = $this->onchangeHandler;

		if (isset($options)) {
			$whitespacePrefix = $options->whitespacePrefix;
		}

		// E.g.
		//<td width="1%">
		//	<input id="manage-project-record--projects--project_name--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="Fern Tree Court">
		//	<input id="previous--manage-project-record--projects--project_name--3" type="hidden" value="Fern Tree Court">
		//</td>

		$htmlContent = <<<END_HTML_CONTENT

			<td>
				<input id="$attributeGroup--$attributeSubgroup--$attributeName--$uniqueId" onchange="$onchangeHandler(this, { responseDataType : 'json' });" type="text" value="$attributeValue">
				<input id="previous--$attributeGroup--$attributeSubgroup--$attributeName--$uniqueId" type="hidden" value="$attributeValue">
			</td>
END_HTML_CONTENT;

		return $htmlContent;
	}

	/**
	 * Output HTML as a <td></td> for one attribute only.
	 *
	 * Options:
	 * <input>
	 * <textarea>
	 * pure text only
	 *
	 */
	public function renderHtmlRecordAsTableRowTr($attributeName, $attributeValue, $uniqueId, Input $options)
	{
		$recordContainerPrefix = self::RecordContainerPrefix;

		$attributeGroup = $this->attributeGroup;
		$attributeSubgroup = $this->attributeSubgroup;
		$onchangeHandler = $this->onchangeHandler;

		$whitespacePrefix = $options->whitespacePrefix;

//<tr id="record_container--manage-project-record--projects--sort_order--3" class="ui-sortable-handle"><input id="formattedAttributeName--manage-action_item_assignment-record--action_item_assignments--sort_order--3" type="hidden" value="Sort Order"><td class="tdSortBars textAlignCenter"><input type="hidden" id="manage-action_item_assignment-record--action_item_assignments--sort_order--3" value="10000"><img class="bs-tooltip" src="/images/sortbars.png" title="" data-original-title="Drag bars to change sort order" aria-describedby="tooltip563529"><div class="tooltip fade top in" role="tooltip" id="tooltip563529" style="top: 391px; left: 0px; display: block;"><div class="tooltip-arrow" style="left: 5.43478260869565%;"></div><div class="tooltip-inner">Drag bars to change sort order</div></div></td>
//<td><span class="entypo entypo-click entypo-plus-circled bs-tooltip" onclick="renderProjectCreationForm('tabularDataRowHorizontalCreationForm', 'record_container--manage-project-record--projects--sort_order--3');" title="" data-original-title="Insert Blank Row"></span></td>
//
//<td width="5"><a class="bs-tooltip" title="" href="javascript:deleteProject('record_container--manage-project-record--projects--sort_order--3', 'manage-project-record', '3', { responseDataType : 'json' });" data-original-title="Delete Project Record">X</a></td>
//<td width="5"><a class="bs-tooltip" title="" href="javascript:Module__InterfaceName__deleteProject(this, event, '3');" data-original-title="Custom Delete Project Record">X</a></td>
//<td width="5"><a class="bs-tooltip" title="" href="#" onclick="Module__InterfaceName__deleteProject(this, event, '3');" data-original-title="Custom Delete Project Record">X</a></td>
//<td width="5"><a class="bs-tooltip" title="" href="javascript:void(0);" onclick="Module__InterfaceName__deleteProject(this, event, '3');" data-original-title="Custom Delete Project Record">X</a></td>
//
//<td><span class="entypo entypo-click entypo-cancel-circled bs-tooltip" title="" onclick="Module__InterfaceName__deleteProject(this, event, '3');" data-original-title="Custom Delete Project Record"></span></td>
//<td width="1%"><input id="manage-project-record--projects--project_id--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="3"><input id="previous--manage-project-record--projects--project_id--3" type="hidden" value="3"></td>
//<td width="1%"><input id="manage-project-record--projects--project_type_id--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="13"><input id="previous--manage-project-record--projects--project_type_id--3" type="hidden" value="13"></td>
//<td width="1%"><input id="manage-project-record--projects--user_company_id--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="3"><input id="previous--manage-project-record--projects--user_company_id--3" type="hidden" value="3"></td>
//<td width="1%"><input id="manage-project-record--projects--user_custom_project_id--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="15MD01"><input id="previous--manage-project-record--projects--user_custom_project_id--3" type="hidden" value="15MD01"></td>
//<td width="1%"><input id="manage-project-record--projects--project_name--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="Fern Tree Court"><input id="previous--manage-project-record--projects--project_name--3" type="hidden" value="Fern Tree Court"></td>
//<td width="1%"><input id="manage-project-record--projects--project_owner_name--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="Mega Developer"><input id="previous--manage-project-record--projects--project_owner_name--3" type="hidden" value="Mega Developer"></td>
//<td width="1%"><input id="manage-project-record--projects--latitude--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--latitude--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--longitude--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--longitude--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--address_line_1--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--address_line_1--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--address_line_2--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--address_line_2--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--address_line_3--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--address_line_3--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--address_line_4--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--address_line_4--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--address_city--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--address_city--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--address_county--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--address_county--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--address_state_or_region--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--address_state_or_region--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--address_postal_code--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--address_postal_code--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--address_postal_code_extension--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--address_postal_code_extension--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--address_country--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value=""><input id="previous--manage-project-record--projects--address_country--3" type="hidden" value=""></td>
//<td width="1%"><input id="manage-project-record--projects--building_count--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="10"><input id="previous--manage-project-record--projects--building_count--3" type="hidden" value="10"></td>
//<td width="1%"><input id="manage-project-record--projects--unit_count--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="350"><input id="previous--manage-project-record--projects--unit_count--3" type="hidden" value="350"></td>
//<td width="1%"><input id="manage-project-record--projects--gross_square_footage--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="200000"><input id="previous--manage-project-record--projects--gross_square_footage--3" type="hidden" value="200000"></td>
//<td width="1%"><input id="manage-project-record--projects--net_rentable_square_footage--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="150000"><input id="previous--manage-project-record--projects--net_rentable_square_footage--3" type="hidden" value="150000"></td>
//<td width="1%"><input id="manage-project-record--projects--is_active_flag--3" onchange="updateProject(this, { responseDataType : 'json' });" type="checkbox" checked=""><input id="previous--manage-project-record--projects--is_active_flag--3" type="hidden" value="Y"></td>
//<td width="1%"><input id="manage-project-record--projects--public_plans_flag--3" onchange="updateProject(this, { responseDataType : 'json' });" type="checkbox"><input id="previous--manage-project-record--projects--public_plans_flag--3" type="hidden" value="N"></td>
//<td width="1%"><input id="manage-project-record--projects--prevailing_wage_flag--3" onchange="updateProject(this, { responseDataType : 'json' });" type="checkbox" checked=""><input id="previous--manage-project-record--projects--prevailing_wage_flag--3" type="hidden" value="Y"></td>
//<td width="1%"><input id="manage-project-record--projects--city_business_license_required_flag--3" onchange="updateProject(this, { responseDataType : 'json' });" type="checkbox" checked=""><input id="previous--manage-project-record--projects--city_business_license_required_flag--3" type="hidden" value="Y"></td>
//<td width="1%"><input id="manage-project-record--projects--is_internal_flag--3" onchange="updateProject(this, { responseDataType : 'json' });" type="checkbox"><input id="previous--manage-project-record--projects--is_internal_flag--3" type="hidden" value="N"></td>
//<td width="1%"><input id="manage-project-record--projects--project_contract_date--3" class="datepicker hasDatepicker" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="2015-06-01"><input id="previous--manage-project-record--projects--project_contract_date--3" type="hidden" value="2015-06-01"></td>
//<td width="1%"><input id="manage-project-record--projects--project_start_date--3" class="datepicker hasDatepicker" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="2015-07-13"><input id="previous--manage-project-record--projects--project_start_date--3" type="hidden" value="2015-07-13"></td>
//<td width="1%"><input id="manage-project-record--projects--project_completed_date--3" class="datepicker hasDatepicker" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="0000-00-00"><input id="previous--manage-project-record--projects--project_completed_date--3" type="hidden" value="0000-00-00"></td>
//<td width="1%"><input id="manage-project-record--projects--sort_order--3" onchange="updateProject(this, { responseDataType : 'json' });" type="text" value="10000"><input id="previous--manage-project-record--projects--sort_order--3" type="hidden" value="10000"></td>
//<td><input type="button" onclick="updateAllProjectAttributes('manage-project-record', '3');" value="Update all Fields"></td>
//</tr>

		$htmlContent = <<<END_HTML_CONTENT

			<td>
				<input id="$attributeGroup--$attributeSubgroup--$attributeName--$uniqueId" onchange="$onchangeHandler(this, { responseDataType : 'json' });" type="text" value="$attributeValue">
				<input id="previous--$attributeGroup--$attributeSubgroup--$attributeName--$uniqueId" type="hidden" value="$attributeValue">
			</td>
END_HTML_CONTENT;

		return $htmlContent;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
