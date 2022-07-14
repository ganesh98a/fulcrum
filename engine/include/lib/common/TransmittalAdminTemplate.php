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
 * RequestForInformation.
 *
 * @category   Framework
 * @package    RequestForInformation
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class TransmittalAdminTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'TransmittalAdminTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'transmittal_admin_templates';

	/**
	 * primary key (`id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'id' => 'int'
		);

	/**
	 * Standard attributes list.
	 *
	 * Metadata mapper pattern maps db attributes to object properties.
	 *
	 * Key - database attribute/field
	 * Value - object property
	 *
	 * @var array
	 */
	protected $arrAttributesMap = array(
		'template_type_id' => 'transmittal_admin_template_id',
		'template_content' => 'template_content',
		'transmittal_category' => 'transmittal_category',
		'templateContent' => 'template_content',
		'uniqueId' => 'transmittal_admin_template_id',
		'typeName' => 'transmittal_category',
		);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $transmittal_admin_template_id;
	public $template_content;
	public $transmittal_category;
	public $typeName;
	public $uniqueId;
	public $templateContent;
	/**
	 * Constructor
	 */
	public function __construct($database, $table='transmittal_admin_templates')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	public function getTransmittalAdminType()
	{
		if (isset($this->_transmittalAdminType)) {
			return $this->_transmittalAdminType;
		} else {
			return null;
		}
	}

	public function setTransmittalAdminType($transmittalAdminType)
	{
		$this->_transmittalAdminType = $transmittalAdminType;
	}
	//update template data
	public function updateOnDuplicateKeyUpdate($httpGetInputData)
	{
		// print_r($httpGetInputData);
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		$templateContent = ($httpGetInputData['templateContent']);
		//replace ;&ldquo; &rdquo;
		$templateContent = preg_replace("/&ldquo;/",'"',$templateContent);
		$templateContent = preg_replace("/&rdquo;/",'"',$templateContent);

		// $templateContent = base64_decode($templateContent);
		$uniqueId = $httpGetInputData['uniqueId'];
		$templatetype = $httpGetInputData['typeName'];
		$arrValues = array($templateContent, $uniqueId);
		$arrValType = array($templatetype, $uniqueId);
		$arrValTypere = array('', $uniqueId);
		$query="Select * from transmittal_admin_templates WHERE template_type_id = '".$uniqueId."' ";
		$db->execute($query);
		$row = $db->fetch();
		$oldContent ='';
		$queryType="Select * from transmittal_types WHERE id = '".$uniqueId."' ";
		$db->execute($queryType);
		$rowType = $db->fetch();
		$oldCategory = $rowType['transmittal_category'];
		/*session*/
		$session = Zend_Registry::get('session');
		$user_id = $session->getUserId();
		$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

		if(!empty($row) && $row!=''){
			$oldContent = $row['template_content'];
			$db->free_result();
			$query="UPDATE transmittal_admin_templates set template_content = ? WHERE template_type_id = ?";
			$db->execute($query, $arrValues);
		}else{
			$db->free_result();
			$query="INSERT INTO transmittal_admin_templates (template_content,template_type_id) VALUES(?,?)";
			$db->execute($query, $arrValues);
		}
		$arrlogs=array($currentlyActiveContactId,$oldContent,$uniqueId,$oldCategory);
		$db->free_result();
		$query="UPDATE transmittal_types set transmittal_category = ? WHERE id = ?";
		$db->execute($query, $arrValTypere);
		$db->free_result();
		$query="UPDATE transmittal_types set transmittal_category = ? WHERE id = ?";
		$db->execute($query, $arrValType);
		$db->free_result();
		if($oldContent!=$templateContent || $oldCategory!=$templatetype){
			$query="INSERT INTO transmittal_admin_template_logs (modified_by_contact_id,before_content_changes,template_type_id,template_category_change) VALUES(?,?,?,?)";
			$db->execute($query, $arrlogs);
			$db->free_result();
		}
		return $uniqueId;
	}
		// Save: insert on duplicate key update
	public function insertOnDuplicateKeyUpdate()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		//todo
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$request_for_information_id = $db->insertId;
		$db->free_result();

		return $request_for_information_id;
	}
}
