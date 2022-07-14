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
 * Page components widget generation class.
 *
 * Generate things such as a tag cloud, etc.
 *
 * PHP versions 5
 *
 */

/**
 * AbstractWebToolkit
 */
require_once('lib/common/AbstractWebToolkit.php');

/**
 * Data
 */
// Already Included...commented out for performance gain
//require_once('lib/common/Data.php');

class ModulesBiddingDocumentHelper extends Model
{
	private $_arrProjectBidInvitationsDocumentEntry = array();

	private $_projectBidInvitationFilesHtml = "";

	private $_gcBudgetLineItemBidInvitationsFilesHtml = "";

	private $_projectBidInvitationsCount = 0;

	private $_arrProjectBidInvitations = array();

	private $_arrGcBudgetLineItemBidInvitations = array();

	private $_gcBudgetLineItemBidInvitationsCount = 0;

	private $_arrBidderGcBudgetLineItemSelectedBitInvitation = array();

	private $_arrHtmlGcBudgetLineItemBidInvitations = array();

	private $_arrCostCodeBidderDocumentRelationship = array();

	private $_arrGcLineItemCostCodeSubcontractorBids = array();

	private $_arrGcBudgetLineItemUnsignedScopeOfWorkDocuments = array();

	private $_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = array();

	private $_gcBudgetLineItemUnsignedScopeOfWorkDocumentFilesHtml = "";

	private $_arrHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentById = array();

	private $_arrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments = array();

	private $_arrSubcontractorBids = array();

	private $_arrSubcontractorBidIdDocuments = array();

	private $_arrSubcontractorsEmailSpan = array();

	private $_arrUniqueBiddersByContact = array();

	// private $_arrCostCodeBidderDocumentRelationship = array();

	private $_arrUniqueBiddersByContactHtmlByGroupDocuments = array();

	private $_gcBudgetLineItemIdToSubcontractorBidIdMap = array();

	private $_arrSubcontractorDocumentFormInput = array();

	// need to store store Data to use
	private $_formDataArrSubcontractorBidDocumentIds;

	private $_arrSubcontractorBidDocuments;

	public $debugMode;

	protected $_projectId;

	protected $_arrGcBudgetLineItemId;

	protected $arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments;

	protected $_latestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode;

	protected $_latestGcBudgetLineItemBidInvitationHtmlCode;

	protected $_biddingModuleFormInputSelection;
	/**
	 * Constructor
	 *
	 * @param String $database
	 * @param Int selected project Id $projectId
	 * @param string CSV $csvBiddingModuleFormInputSelection from bidding module form selection
	 */
	public function __construct($database, $projectId, $csvBiddingModuleFormInputSelection)
	{
		$this->_database = $database;

		$this->_projectId = $projectId;
		$session = Zend_Registry::get('session');
		/* @var $session Session */
		$this->debugMode = $session->getDebugMode();
		$this->storeBiddingModuleFormInputSelection($csvBiddingModuleFormInputSelection);

	}
	/**
	 * assgin form input to object for retrieve
	 *
	 * @param unknown_type $csvBiddingModuleFormInputSelection
	 */
	protected function storeBiddingModuleFormInputSelection($csvBiddingModuleFormInputSelection)
	{
		$this->_biddingModuleFormInputSelection['projectBidInvitationIds'] = explode(',', $csvBiddingModuleFormInputSelection['csvProjectBidInvitationIds']);
		$this->_biddingModuleFormInputSelection['gcBudgetLineItemBidInvitationIds'] = explode(',', $csvBiddingModuleFormInputSelection['csvGcBudgetLineItemBidInvitationIds']);
		$this->_biddingModuleFormInputSelection['gcBudgetLineItemUnsignedScopeOfWorkDocumentIds'] = explode(',', $csvBiddingModuleFormInputSelection['csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds']);
		$this->_biddingModuleFormInputSelection['subcontractorBidIds'] = explode(',', $csvBiddingModuleFormInputSelection['csvSubcontractorBidIds']);
		$this->_biddingModuleFormInputSelection['subcontractorBidDocumentIds'] = explode(',', $csvBiddingModuleFormInputSelection['csvSubcontractorBidDocumentIds']);

	}
	public function getProjectBidInvitationFilesHtml()
	{
		return $this->_projectBidInvitationFilesHtml;
	}

	public function getArrProjectBidInvitationsDocumentEntry()
	{
		return $this->_arrProjectBidInvitationsDocumentEntry;
	}

	public function getArrBidderGcBudgetLineItemSelectedBitInvitation()
	{
		return $this->_arrBidderGcBudgetLineItemSelectedBitInvitation;
	}

	public function getArrHtmlGcBudgetLineItemBidInvitations()
	{
		return $this->_arrHtmlGcBudgetLineItemBidInvitations;
	}

	public function getGcBudgetLineItemBidInvitationsFilesHtml()
	{
		return $this->_gcBudgetLineItemBidInvitationsFilesHtml;
	}
	public function getArrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments()
	{
		return $this->_arrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments;
	}
	public function getArrHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentById()
	{
		return $this->_arrHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentById;
	}
	public function getGcBudgetLineItemUnsignedScopeOfWorkDocumentFilesHtml()
	{
		return $this->_gcBudgetLineItemUnsignedScopeOfWorkDocumentFilesHtml;
	}


	public function setCostCodeBidderDocumentRelationship($arrCostCodeBidderDocumentRelationship)
	{
		$this->_arrCostCodeBidderDocumentRelationship = $arrCostCodeBidderDocumentRelationship;
	}

	public function getarrUniqueBiddersByContactHtmlByGroupDocuments($arrCostCodeBidderDocumentRelationship)
	{
		return $this->_arrUniqueBiddersByContactHtmlByGroupDocuments;
	}

	public function loadSubcontractorBids($csvSubcontractorBidIds)
	{
		if (!isset($csvSubcontractorBidIds) || empty($csvSubcontractorBidIds)) {
			return;
		}

		$arrSubcontractorBidIds = explode(',', $csvSubcontractorBidIds);

		if (isset($arrSubcontractorBidIds) && !empty($arrSubcontractorBidIds)) {
			$loadSubcontractorBidsByArrSubcontractorBidIdsInput = new Input();
			$loadSubcontractorBidsByArrSubcontractorBidIdsInput->arrOrderByAttributes = array(
			'codes_fk_ccd.`division_number`' => 'ASC',
			'sb_fk_gbli__fk_codes.`cost_code`' => 'ASC',
			'sb_fk_subcontractor_c__fk_cc.`company`' => 'ASC',
			'sb_fk_subcontractor_c.`last_name`' => 'ASC',
			'sb_fk_subcontractor_c.`first_name`' => 'ASC',
			'sb_fk_subcontractor_c.`email`' => 'ASC',
			);
			$this->_arrSubcontractorBids =
			SubcontractorBid::loadSubcontractorBidsByArrSubcontractorBidIds($this->_database, $arrSubcontractorBidIds, $loadSubcontractorBidsByArrSubcontractorBidIdsInput);

		}
	}
	/**
	 * process subcontractor_bid_documents from csv string from form input
	 *
	 */
	public function processCSVSubcontractBidDocument($csvSubcontractorBidDocumentIds)
	{

		// subcontractor_bid_documents
		if (isset($csvSubcontractorBidDocumentIds) && !empty($csvSubcontractorBidDocumentIds)) {
			$this->_formDataArrSubcontractorBidDocumentIds = explode(',', $csvSubcontractorBidDocumentIds);
		}
		if (isset($this->_formDataArrSubcontractorBidDocumentIds) && !empty($this->_formDataArrSubcontractorBidDocumentIds)) {
			$loadSubcontractorBidDocumentsByArrSubcontractorBidDocumentIdsInput = new Input();
			$loadSubcontractorBidDocumentsByArrSubcontractorBidDocumentIdsInput->arrOrderByAttributes = array(
			'subcontractor_bid_document_sequence_number' => 'DESC'
			);
			$this->_arrSubcontractorBidDocuments =
			SubcontractorBidDocument::loadSubcontractorBidDocumentsByArrSubcontractorBidDocumentIds($this->_database, $this->_formDataArrSubcontractorBidDocumentIds, $loadSubcontractorBidDocumentsByArrSubcontractorBidDocumentIdsInput);
			//echo "<pre>";
			//print_r($this->_arrSubcontractorBidDocuments);
			if ($this->_arrSubcontractorBidDocuments) {
				foreach($this->_arrSubcontractorBidDocuments as $subcontractor_bid_document_id => $subcontractorBidDocuments) {
					$subcontractorBidDocumentType = $subcontractorBidDocuments->getSubcontractorBidDocumentType();
					$subcontractor_bid_id = $subcontractorBidDocuments->subcontractor_bid_id;
					if ($subcontractorBidDocumentType->subcontractor_bid_document_type == Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION) {
						$this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasBidInvitionDoc'] = true;
						$this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasSubBidDoc'] = true;
						continue;
					} elseif ($subcontractorBidDocumentType->subcontractor_bid_document_type == Constants::SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK) {
						$this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasUnsignedScopeOfWorkDoc'] = true;
						$this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasSubBidDoc'] = true;
						continue;
					} elseif ($subcontractorBidDocumentType->subcontractor_bid_document_type == Constants::SUBCONTRACTOR_BID_DOCUMENT_SUBCONTRACTOR_BID) {

						$this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasSubContractorBidDoc'] = true;
						$this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasSubBidDoc'] = true;
						continue;
					} elseif ($subcontractorBidDocumentType->subcontractor_bid_document_type == Constants::SUBCONTRACTOR_BID_DOCUMENT_SIGNED_SCOPE_OF_WORK) {

						$this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasSignedScopeOfWorkDoc'] = true;
						$this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasSubBidDoc'] = true;
						continue;
					}

				}
			}
		}
	}

	public function getarrSubcontractorBidDocuments() {
		return $this->_arrSubcontractorBidDocuments;
	}
	/*
	private $_subcontractorsEmailSpan = array();

	private $_arrCostCodeBidderDocumentRelationship = array();

	private $_arrUniqueBidders = array();
	*/

	public function getArrSubcontractorsEmailSpan()
	{
		return $this->_arrSubcontractorsEmailSpan;
	}
	public function getArrCostCodeBidderDocumentRelationship()
	{
		return $this->_arrCostCodeBidderDocumentRelationship;
	}

	public function getArrUniqueBidders()
	{
		return $this->_arrUniqueBidders;
	}

	public function formatSubcontractorBidsContact()
	{
		if (count($this->_arrSubcontractorBids) > 0) {
			foreach ($this->_arrSubcontractorBids as $subcontractor_bid_id => $subcontractorBid) {

				$this->_arrSubcontractorBidIdDocuments[$subcontractor_bid_id] = array();
				// capture unique gc_budget_line_item_id
				$gc_budget_line_item_id = $subcontractorBid->gc_budget_line_item_id;

				$this->_arrGcBudgetLineItemId[] = $gc_budget_line_item_id;


				$this->_gcBudgetLineItemIdToSubcontractorBidIdMap[$gc_budget_line_item_id][] = $subcontractor_bid_id;
				/* @var $subcontractorBid SubcontractorBid */

				$gcBudgetLineItem = $subcontractorBid->getGcBudgetLineItem();
				/* @var $gcBudgetLineItem GcBudgetLineItem */

				$costCode = $gcBudgetLineItem->getCostCode();
				/* @var $costCode CostCode */

				$costCodeDivision = $costCode->getCostCodeDivision();
				/* @var $costCodeDivision CostCodeDivision */

				$subcontractorContact = $subcontractorBid->getSubcontractorContact();
				/* @var $subcontractorContact Contact */

				$subcontractorContactCompany = $subcontractorContact->getContactCompany();
				/* @var $subcontractorContactCompany ContactCompany */

				$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
				/* @var $subcontractorBidStatus SubcontractorBidStatus */

				// assign subcontractors to this relationship for associated bid documents by gcBudgetLineItem and costcode
				$this->_arrCostCodeBidderDocumentRelationship[$subcontractorBid->gc_budget_line_item_id][$costCode->cost_code_id][] = $subcontractor_bid_id;

				// assign subcontractors bid based on gc_budget_line_item and cost code
				$this->_arrGcLineItemCostCodeSubcontractorBids[$subcontractorBid->gc_budget_line_item_id][$costCode->cost_code_id][] = $subcontractorBid;

				if ($subcontractorContact) {

					if (!isset($arrUniqueBidders[$subcontractorContact->contact_id])) {

						$subcontractorContact->htmlEntityEscapeProperties();

						$contactFullNameHtmlEscaped = $subcontractorContact->getContactFullNameHtmlEscaped();
						$escaped_email = $subcontractorContact->escaped_email;

						//$formattedEmail = "x $contactFullNameHtmlEscaped <$escaped_email>";
						//$arrTo[] = $formattedEmail;

						$contactFullName = $subcontractorContact->getContactFullName();
						$email = $subcontractorContact->email;
						$subcontractor_contact_id = $subcontractorContact->contact_id;

						$subcontractorBidderEmailHtml = <<<END_SUBCONTRACTOR_BIDDER_EMAIL_HTML

						<div id="record_container--bidding-module-email-modal-dialog-subcontractor-contact-email--subcontractor_bids--subcontractor_bid_id--$subcontractor_bid_id" class="bidding-module-email-modal-dialog-bidders--subcontractor_bids--subcontractor_bid_id">
							<img class="fakeHref" onclick="deleteBidderFrom_BiddingModuleEmailModalDialog('$subcontractor_bid_id', '$contactFullNameHtmlEscaped &lt;$escaped_email&gt;');" src="/images/icons/icon-delete-x-circle.png">
							<a href="mailto:$escaped_email">$contactFullNameHtmlEscaped &lt;$escaped_email&gt;</a>
						</div>

END_SUBCONTRACTOR_BIDDER_EMAIL_HTML;
						//$formattedEmail = "x $contactFullName <$email>";
						$this->_arrSubcontractorsEmailSpan[] = $subcontractorBidderEmailHtml;

						$this->_arrUniqueBidders[$subcontractorContact->contact_id] = 1;

					}
				}
			}
		}
	}
	public function getArrSubcontractorBids()
	{
		return $this->_arrSubcontractorBids;
	}

	public function loadProjectBidInvitationDocuments($csvProjectBidInvitationIds)
	{
		$arrProjectBidInvitationIds = explode(',', $csvProjectBidInvitationIds);

		if (isset($arrProjectBidInvitationIds) && !empty($arrProjectBidInvitationIds)) {
			$loadProjectBidInvitationsByArrProjectBidInvitationIdsInput = new Input();
			$loadProjectBidInvitationsByArrProjectBidInvitationIdsInput->arrOrderByAttributes = array(
			'project_bid_invitation_sequence_number' => 'DESC'
			);
			$this->_arrProjectBidInvitations = ProjectBidInvitation::loadProjectBidInvitationsByArrProjectBidInvitationIds($this->_database, $arrProjectBidInvitationIds, $loadProjectBidInvitationsByArrProjectBidInvitationIdsInput);
			$this->_projectBidInvitationsCount = count($this->_arrProjectBidInvitations);

			if ($this->_projectBidInvitationsCount > 0) {
				// indicate if there is project bid invitation
				$this->_arrSubcontractorDocumentFormInput[0]['projectBidInvitation'] = true;
				$this->formatProjectBidInvitationDocuments();
			}
		} else {
			$this->_projectBidInvitationsCount = 0;
		}
	}

	public function loadDefaultProjectBidInvitationDocument()
	{
		//loadAllProjectBidInvitations($database,
		//$options = new stdObject();
		//$options->limit = 1;
		//if (isset($arrProjectBidInvitationIds) && !empty($arrProjectBidInvitationIds)) {
		$loadProjectBidInvitationsByArrProjectBidInvitationIdsInput = new Input();
		$loadProjectBidInvitationsByArrProjectBidInvitationIdsInput->arrOrderByAttributes = array(
		'project_bid_invitation_sequence_number' => 'DESC'
		);
		$loadProjectBidInvitationsByArrProjectBidInvitationIdsInput->limit = 1;

		$defaultProjectBidInvitation = ProjectBidInvitation::loadAllProjectBidInvitations($this->_database, $loadProjectBidInvitationsByArrProjectBidInvitationIdsInput);

		if (isset($defaultProjectBidInvitation) && !empty($defaultProjectBidInvitation)) {
			foreach($defaultProjectBidInvitation as $defaultProjectBidInvitationId => $objProjectBidInvitation) {
				$this->_arrProjectBidInvitations = ProjectBidInvitation::loadProjectBidInvitationsByArrProjectBidInvitationIds($this->_database, array($defaultProjectBidInvitationId), $loadProjectBidInvitationsByArrProjectBidInvitationIdsInput);
				$this->_projectBidInvitationsCount = count($this->_arrProjectBidInvitations);
			}

			//$this->_arrProjectBidInvitations = ProjectBidInvitation::loadAllProjectBidInvitations($this->_database, $loadProjectBidInvitationsByArrProjectBidInvitationIdsInput);
			//print_r($this->_arrProjectBidInvitations);exit;
			//$this->_projectBidInvitationsCount = count($this->_arrProjectBidInvitations);

			if ($this->_projectBidInvitationsCount > 0) {
				$this->formatProjectBidInvitationDocuments();
			}
		}
		else {
			$this->_projectBidInvitationsCount = 0;
		}
	}
	public function loadGcBudgetLineItemBidInvitations($csvGcBudgetLineItemBidInvitationIds) {
		$arrGcBudgetLineItemBidInvitationIds = explode(',', $csvGcBudgetLineItemBidInvitationIds);

		if (isset($arrGcBudgetLineItemBidInvitationIds) && !empty($arrGcBudgetLineItemBidInvitationIds)) {
			$loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIdsInput = new Input();
			$loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIdsInput->arrOrderByAttributes = array(
			'gc_budget_line_item_bid_invitation_sequence_number' => 'DESC'
			);
			$this->_arrGcBudgetLineItemBidInvitations =
			GcBudgetLineItemBidInvitation::loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIds($this->_database, $arrGcBudgetLineItemBidInvitationIds, $loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIdsInput);
			if (count($this->_arrGcBudgetLineItemBidInvitations) > 0) {
				$this->formatGcBudgetLineItemBidInvitations();
			}
		}
	}

	public function loadDefaultGcBudgetLineItemUnsignedScopeOfWorkDocuments()
	{

		// return; don't return
		// load default
		$arrGcBudgetLineItemId = array_unique($this->_arrGcBudgetLineItemId);
		foreach($arrGcBudgetLineItemId as $gc_budget_line_item_id) {
			$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions = new Input();
			$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
			$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions->limit = 1;
			$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions->arrOrderByAttributes = array(
			'unsigned_scope_of_work_document_sequence_number' => 'DESC'
			);
			$arrGcBudgetLineItemUnsignedScopeOfWorkDocuments =
			GcBudgetLineItemUnsignedScopeOfWorkDocument::loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId($this->_database, $gc_budget_line_item_id, $loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions);
			if (isset($arrGcBudgetLineItemUnsignedScopeOfWorkDocuments) && count($arrGcBudgetLineItemUnsignedScopeOfWorkDocuments) > 0) {
				//foreach ($arrGcBudgetLineItemUnsignedScopeOfWorkDocuments as $gc_budget_line_item_unsigned_scope_of_work_document_id) {
				//echo "<pre> aaaaa";
				//print_r($gc_budget_line_item_unsigned_scope_of_work_document_id);
				//exit;
				//$checkboxCSSClass = "bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id--{$gc_budget_line_item_unsigned_scope_of_work_document_id}";
				//$this->_arrUniqueBiddersByContactHtmlByGroupDocuments[$htmlEntityEscapedFormattedCostCode][$contactFullNameHtmlEscaped]['gc_budget_line_item_unsigned_scope_of_work_documents'][] =
				//'<input type="checkbox" value="' . $subcontractor_bid_id . '" class="' . $checkboxCSSClass . '" onclick="biddingModuleEmailDialogCheckboxState(this);">' . $this->_arrHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentById[$gc_budget_line_item_unsigned_scope_of_work_document_id];
				//}
				$this->_arrGcBudgetLineItemUnsignedScopeOfWorkDocuments = array_merge($this->_arrGcBudgetLineItemUnsignedScopeOfWorkDocuments, $arrGcBudgetLineItemUnsignedScopeOfWorkDocuments);
			}
		}

		if (count($this->_arrGcBudgetLineItemUnsignedScopeOfWorkDocuments) > 0) {
			$this->formatGcBudgetLineItemUnsignedScopeOfWorkDocuments();
		}

	}

	public function loadGcBudgetLineItemUnsignedScopeOfWorkDocuments($csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds)
	{
		if (!isset($csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds) || empty($csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds)) {
			return;
		} else {
			$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = explode(',', $csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds);
			// assign this for later used
			// so we know the checked gc_budget_line_item unsigned doc id
			$this->_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds;

			if (isset($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds) && !empty($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds)) {
				$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByArrGcBudgetLineItemUnsignedScopeOfWorkDocumentIdsInput = new Input();
				$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByArrGcBudgetLineItemUnsignedScopeOfWorkDocumentIdsInput->arrOrderByAttributes = array(
				'unsigned_scope_of_work_document_sequence_number' => 'DESC'
				);
				$this->_arrGcBudgetLineItemUnsignedScopeOfWorkDocuments =
				GcBudgetLineItemUnsignedScopeOfWorkDocument::loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByArrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds($this->_database, $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds, $loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByArrGcBudgetLineItemUnsignedScopeOfWorkDocumentIdsInput);
				if (count($this->_arrGcBudgetLineItemUnsignedScopeOfWorkDocuments) > 0) {
					$this->formatGcBudgetLineItemUnsignedScopeOfWorkDocuments();
				}
			}
		}
	}

	/**
 	* return format entry for Project Bid Invitations Document
 	*
 	* @param array $arrProjectBidInvitations
 	* @return array String html and array objects
 	*/
	public function formatProjectBidInvitationDocuments()
	{

		// project_bid_invitations
		$trHtml = '';
		$arrProjectBidInvitationsDocumentEntry = array();
		// $projectBidInvitationsCount = count($arrProjectBidInvitations);
		foreach ($this->_arrProjectBidInvitations as $project_bid_invitation_id => $projectBidInvitation) {
			/* @var $projectBidInvitation ProjectBidInvitation */

			$project = $projectBidInvitation->getProject();
			/* @var $project Project */

			$projectBidInvitationFileManagerFile = $projectBidInvitation->getProjectBidInvitationFileManagerFile();
			/* @var $projectBidInvitationFileManagerFile FileManagerFile */

			$projectBidInvitationFileManagerFile->htmlEntityEscapeProperties();

			$file_manager_file_id = $projectBidInvitationFileManagerFile->file_manager_file_id;
			$virtual_file_name = $projectBidInvitationFileManagerFile->virtual_file_name;
			$escaped_virtual_file_name = $projectBidInvitationFileManagerFile->escaped_virtual_file_name;
			$cdnFileUrl = $projectBidInvitationFileManagerFile->generateUrl();

			$trHtml .= <<<END_TR_HTML

						<tr id="bidding-module-email-modal-dialog-files--project_bid_invitations--project_bid_invitation_id--$project_bid_invitation_id" class="bidding-module-email-modal-dialog-files--project_bid_invitations--project_bid_invitation_id">
							<td>
								<a class="l m bs-tooltip" style="margin: 0px 0 0px 0px;" href="$cdnFileUrl" target="_blank" title="This file will be an attachment."><img src="/images/icons/icon-file-pdf-gray.gif" width="18" height="18" alt=""> $escaped_virtual_file_name</a>
								<img class="fakeHref" src="/images/icons/icon-delete-x-circle.png" width="12" height="12" alt="" title="Remove this file attachment from the list." onclick="removeDomElement('bidding-module-email-modal-dialog-files--project_bid_invitations--project_bid_invitation_id--$project_bid_invitation_id');">
							</td>
						</tr>

END_TR_HTML;
			// the following line collect ProjectBidInvitation into array for group by contact display area later
			// put into array so we can apply flexible layout
			$this->_arrProjectBidInvitationsDocumentEntry[$project_bid_invitation_id] = outputEmailProjectBidInvitationDocumentEntry($cdnFileUrl, $escaped_virtual_file_name);
		}

		if ($this->_projectBidInvitationsCount > 0) {
			$this->_projectBidInvitationFilesHtml = <<<END_FILES_HTML
					<br>
					<b>Default Project Bid Invitation File Attachments</b>
					<table class="" border="0" cellpadding="0" cellspacing="0" width="100%">
					$trHtml
					</table>

END_FILES_HTML;
} else {
	$this->_projectBidInvitationFilesHtml = '';
}

	}

	public function formatGcBudgetLineItemBidInvitations()
	{
		//$arrGcBudgetLineItemBidInvitations;
		// $arrHtmlGcBudgetLineItemBidInvitations = array();
		$arrBidderGcBudgetLineItemSelectedBitInvitation = array();

		$trHtmlGcBudgetLineItemBidInvitationsFilesHtml = '';

		if (count($this->_arrGcBudgetLineItemBidInvitations) > 0) {
			$arrTDHtmlGcBudgetLineItemBidInvitations = array();
			foreach ($this->_arrGcBudgetLineItemBidInvitations as $gc_budget_line_item_bid_invitation_id => $gcBudgetLineItemBidInvitation) {
				// need cost code id and gc Budget line item id to assign and find association with sub_contractor_id
				$gcBudgetLineItem = $gcBudgetLineItemBidInvitation->getGcBudgetLineItem();

				$gc_budget_line_item_id = $gcBudgetLineItem->gc_budget_line_item_id;

				// assign this to a subcontractbid_id;
				//echo "<pre>";
				if (isset($this->_gcBudgetLineItemIdToSubcontractorBidIdMap[$gc_budget_line_item_id])) {
					$arrSubcontractorBidId = $this->_gcBudgetLineItemIdToSubcontractorBidIdMap[$gc_budget_line_item_id];
					foreach($arrSubcontractorBidId as $subcontractor_bid_id) {
						$this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasGcBudgetLineItemBidInvitation'] = true;
					}
				}
				$cost_code_id = $gcBudgetLineItem->cost_code_id;

				$budgetLineItemBidInvitationVirtualFileName = getBudgetLineItemBidInvitationVirtualFileName($gcBudgetLineItemBidInvitation);
				$arrTDHtmlGcBudgetLineItemBidInvitations[] = "$budgetLineItemBidInvitationVirtualFileName\n";

				// assign html for $arrHtmlGcBudgetLineItemBidInvitations using key $gc_budget_line_item_bid_invitation_id
				// in order to get that to the bidder via $arrBidderGcBudgetLineItemSelectedBitInvitation
				$this->_arrHtmlGcBudgetLineItemBidInvitations[$gc_budget_line_item_bid_invitation_id] = getBudgetLineItemBidInvitationVirtualFileName($gcBudgetLineItemBidInvitation);
				// assign relationship for $arrBidderGcBudgetLineItemSelectedBitInvitation to bidders;
				// HC
				if (isset($this->_arrCostCodeBidderDocumentRelationship[$gcBudgetLineItem->gc_budget_line_item_id][$cost_code_id])) {
					foreach ($this->_arrCostCodeBidderDocumentRelationship[$gcBudgetLineItem->gc_budget_line_item_id][$cost_code_id] as $subcontractor_bid_id) {
						$this->_arrBidderGcBudgetLineItemSelectedBitInvitation[$subcontractor_bid_id][] = $gc_budget_line_item_bid_invitation_id;
					}
				}
			}

			$trHtmlGcBudgetLineItemBidInvitationsFilesHtml = $this->outputDocumentRow($arrTDHtmlGcBudgetLineItemBidInvitations, '');
			$this->_gcBudgetLineItemBidInvitationsFilesHtml = <<<END_FILES_HTML
					<br>
					<b>Default GC Budget Line Item Bid Invitation File Attachments</b>
					<table class="" border="0" cellpadding="0" cellspacing="0" width="100%">
						$trHtmlGcBudgetLineItemBidInvitationsFilesHtml
					</table>

END_FILES_HTML;
		}
	}

	public function formatGcBudgetLineItemUnsignedScopeOfWorkDocuments()
	{
		$trHtml = "";

		foreach ($this->_arrGcBudgetLineItemUnsignedScopeOfWorkDocuments as $gc_budget_line_item_unsigned_scope_of_work_document_id => $gcBudgetLineItemUnsignedScopeOfWorkDocument) {
			/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */
			$gcBudgetLineItem = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getGcBudgetLineItem();
			$gc_budget_line_item_id = $gcBudgetLineItem->gc_budget_line_item_id;

			// assign this to a subcontractbid_id;
			//echo "<pre>";
			if (isset($this->_gcBudgetLineItemIdToSubcontractorBidIdMap[$gc_budget_line_item_id])) {
				$arrSubcontractorBidId = $this->_gcBudgetLineItemIdToSubcontractorBidIdMap[$gc_budget_line_item_id];
				foreach($arrSubcontractorBidId as $subcontractor_bid_id) {
					$this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasGcBudgetLineItemUnsignedScopeOfWorkDocument'] = true;
				}
			}

			$cost_code_id = $gcBudgetLineItem->cost_code_id;

			$gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getUnsignedScopeOfWorkDocumentFileManagerFile();
			/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile FileManagerFile */

			$gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->htmlEntityEscapeProperties();

			$file_manager_file_id = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->file_manager_file_id;
			$virtual_file_name = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->virtual_file_name;
			$escaped_virtual_file_name = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->escaped_virtual_file_name;
			$cdnFileUrl = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->generateUrl();


			$trHtml .= <<<END_TR_HTML
						<tr>
							<td>
								<a class="l m bs-tooltip" style="margin: 0px 0 0px 0px;" href="$cdnFileUrl" target="_blank" title="This file will be an attachment."><img src="/images/icons/icon-file-pdf-gray.gif" width="18" height="18" alt=""> $escaped_virtual_file_name</a>
								<img class="fakeHref" src="/images/icons/icon-delete-x-circle.png" width="12" height="12" alt="" title="Remove this file attachment from the list." onclick="removeParentElement(this,'tr');">
							</td>
						</tr>
END_TR_HTML;

			// assign html for GcBudgetLineItemUnsignedScopeOfWorkDocuments using key $gc_budget_line_item_unsigned_scope_of_work_document_id
			// in order to get that to the bidder via $arrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments
			$this->_arrHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentById[$gc_budget_line_item_unsigned_scope_of_work_document_id] = outputHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentByid($cdnFileUrl, $escaped_virtual_file_name, $gc_budget_line_item_unsigned_scope_of_work_document_id);
			// assign relationship for GcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments to bidders;
			if (isset($this->_arrCostCodeBidderDocumentRelationship[$gcBudgetLineItem->gc_budget_line_item_id][$cost_code_id])) {
				foreach ($this->_arrCostCodeBidderDocumentRelationship[$gcBudgetLineItem->gc_budget_line_item_id][$cost_code_id] as $subcontractor_bid_id) {
					$this->_arrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments[$subcontractor_bid_id][] = $gc_budget_line_item_unsigned_scope_of_work_document_id;
				}
			}
		}

		if (count($this->_arrGcBudgetLineItemUnsignedScopeOfWorkDocuments) > 0) {
			$this->_gcBudgetLineItemUnsignedScopeOfWorkDocumentFilesHtml = <<<END_FILES_HTML
					<br>
					<b>Default Unsigned Scope Of Work File Attachments</b>
					<table class="" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr id="bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id--$gc_budget_line_item_unsigned_scope_of_work_document_id" class="bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id">

$trHtml
						</tr>
					</table>

END_FILES_HTML;

		} else {
			$this->_gcBudgetLineItemUnsignedScopeOfWorkDocumentFilesHtml = '';
		}
	}

	public function outputDocumentRow($arrayRowRecords, $tabSpace)
	{

		$tmpHtml = '';
		foreach ($arrayRowRecords as $rowRecord) {
			$rowRecord = $tabSpace . $rowRecord;
			$tmpHtml .= <<<END_FILES_HTML
				<tr>
					<td>$rowRecord
					</td>
				</tr>
END_FILES_HTML;
		}
		return $tmpHtml;

	}
	public function mergeBidderDocumentsByContact($arrHtmlSubcontractorBidDocuments)
	{
		// local or member?
		$arrUniqueBiddersByContact = array();
		foreach ($this->_arrSubcontractorBids as $subcontractor_bid_id => $subcontractorBid) {
			/* @var $subcontractorBid SubcontractorBid */

			$gcBudgetLineItem = $subcontractorBid->getGcBudgetLineItem();
			/* @var $gcBudgetLineItem GcBudgetLineItem */

			$costCode = $gcBudgetLineItem->getCostCode();
			/* @var $costCode CostCode */

			$costCodeDivision = $costCode->getCostCodeDivision();
			/* @var $costCodeDivision CostCodeDivision */

			if ($costCode) {
				$costCode->htmlEntityEscapeProperties();
				$htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCode();
			}

			$subcontractorContact = $subcontractorBid->getSubcontractorContact();
			/* @var $subcontractorContact Contact */

			$subcontractorContactCompany = $subcontractorContact->getContactCompany();
			/* @var $subcontractorContactCompany ContactCompany */

			$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
			/* @var $subcontractorBidStatus SubcontractorBidStatus */

			$subcontractorContact->htmlEntityEscapeProperties();
			$subcontractorContactCompany->htmlEntityEscapeProperties();

			$contactFullNameHtmlEscaped = $subcontractorContact->getContactFullNameHtmlEscaped();
			$escaped_email = $subcontractorContact->escaped_email;

			$escaped_contact_company_name = $subcontractorContactCompany->escaped_contact_company_name;

			$subcontractorBidStatus->htmlEntityEscapeProperties();
			$escaped_subcontractor_bid_status = $subcontractorBidStatus->escaped_subcontractor_bid_status;

			$subcontractor_contact_id = $subcontractorContact->contact_id;

			// !!! check flag in $arrUniqueBiddersByContact to avoid mulitple global bid invitation and header
			if (!isset($arrUniqueBiddersByContact[$subcontractor_contact_id])) {

				$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] = '';

				if ($this->debugMode) {
					$tmpDebugHtml = "[subcontractor_bid_id: $subcontractor_bid_id] [subcontractor_contact_id: $subcontractor_contact_id] ";
				} else {
					$tmpDebugHtml = '';
				}

				$subcontractorBidHtmlHeader = <<<END_SUBCONTRACTOR_BID_HTML_HEADER

<table id="record_container--bidding-module-email-modal-dialog-subcontractor-bid-details--subcontractor_bids--subcontractor_bid_id--$subcontractor_bid_id" class="subaccordion-header bidding-module-email-modal-dialog-files-subcontractor-bid-documents-table" style="width: 100%;">
	<tr>
		<td>
			<h3 style="margin: 0;">
				{$tmpDebugHtml}{$escaped_contact_company_name} &mdash; $contactFullNameHtmlEscaped [$htmlEntityEscapedFormattedCostCode] &mdash; $escaped_subcontractor_bid_status
				<img class="fakeHref" width="12" height="12" onclick="deleteBidderFrom_BiddingModuleEmailModalDialog('$subcontractor_bid_id', '$contactFullNameHtmlEscaped &lt;$escaped_email&gt;');" title="Remove this bidder from the list." alt="" src="/images/icons/icon-delete-x-circle.png">
			</h3>
		</td>
	</tr>

END_SUBCONTRACTOR_BID_HTML_HEADER;

				// flag to avoid mulitple global bid invitation and header
				$arrUniqueBiddersByContact[$subcontractor_contact_id] = 1;
				$this->_arrUniqueBiddersByContactHtmlByGroupDocuments[$subcontractor_contact_id]['header'] = $subcontractorBidHtmlHeader;

				if (count($this->_arrProjectBidInvitationsDocumentEntry) > 0) {
					$outputSubcontractorProjectBidInvitationsDocumentEntry = $this->outputSubcontractorProjectBidInvitationsDocumentEntry($this->_arrProjectBidInvitationsDocumentEntry, $subcontractor_bid_id);
					// contact might have multiple entries due to cost code and group id
					// for group by contact, we want only one global bid invitation document
					$this->_arrUniqueBiddersByContactHtmlByGroupDocuments[$subcontractor_contact_id]['projectBidInvitations'][] = $outputSubcontractorProjectBidInvitationsDocumentEntry;
					//$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $outputSubcontractorProjectBidInvitationsDocumentEntry;
				}


			} else {

			}

			if (isset($this->_arrBidderGcBudgetLineItemSelectedBitInvitation[$subcontractor_bid_id])) {
				foreach ($this->_arrBidderGcBudgetLineItemSelectedBitInvitation[$subcontractor_bid_id] as $gc_budget_line_item_bid_invitation_id) {
					$checkboxCSSClass = "bidding-module-email-modal-dialog-files--gc_budget_line_item_bid_invitations--gc_budget_line_item_bid_invitation_id--{$gc_budget_line_item_bid_invitation_id}";
					$this->_arrUniqueBiddersByContactHtmlByGroupDocuments[$subcontractor_contact_id]['gc_budget_line_item_bid_invitation'][] =  '<input type="checkbox" value="' . $subcontractor_bid_id . '" onclick="biddingModuleEmailDialogCheckboxState(this);" class="' . $checkboxCSSClass . '">' . $this->_arrHtmlGcBudgetLineItemBidInvitations[$gc_budget_line_item_bid_invitation_id];
				}
			}

			if (isset($this->_arrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments[$subcontractor_bid_id])) {
				foreach ($this->_arrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments[$subcontractor_bid_id] as $gc_budget_line_item_unsigned_scope_of_work_document_id) {
					$checkboxCSSClass = "bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id--{$gc_budget_line_item_unsigned_scope_of_work_document_id}";
					$this->_arrUniqueBiddersByContactHtmlByGroupDocuments[$subcontractor_contact_id]['gc_budget_line_item_unsigned_scope_of_work_documents'][$gc_budget_line_item_unsigned_scope_of_work_document_id] =
					'<input type="checkbox" value="' . $subcontractor_bid_id . '" class="' . $checkboxCSSClass . '" onclick="biddingModuleEmailDialogCheckboxState(this);">' . $this->_arrHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentById[$gc_budget_line_item_unsigned_scope_of_work_document_id];
				}
			}

			// $arrHtmlSubcontractorBidDocuments
			if (isset($arrHtmlSubcontractorBidDocuments[$subcontractor_bid_id])) {
				foreach ($arrHtmlSubcontractorBidDocuments[$subcontractor_bid_id] as $subcontractor_bid_document_type => $arrHtmlSubcontractorBidDocumentsEntries) {
					foreach ($arrHtmlSubcontractorBidDocumentsEntries as $htmlSubcontractorBidDocumentsEntry) {
						$this->_arrUniqueBiddersByContactHtmlByGroupDocuments[$subcontractor_contact_id][$subcontractor_bid_document_type][] = $htmlSubcontractorBidDocumentsEntry;
					}
				}
			}
		}
	}

	public function outputEmailDocumentBlocksByContact()
	{
		$arrUniqueBiddersByContactHtml = array();
		foreach ($this->_arrUniqueBiddersByContactHtmlByGroupDocuments as $subcontractor_contact_id => $documents) {

			// check if we have subDocument under gc budget line item
			if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION]) || isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK])) {
				$hasSubcontractorBidDocument = true;
			} else {
				$hasSubcontractorBidDocument = false;
			}

			// check if we have gc budget line item level
			if (isset($documents['gc_budget_line_item_bid_invitation']) || isset($documents['gc_budget_line_item_unsigned_scope_of_work_documents'])) {
				$hasGcBudgetLineItemDocument = true;
			} else {
				$hasGcBudgetLineItemDocument = false;
			}

			// 1. start with header
			$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] = $documents['header'];

			// 2. ProjectBidInvitations
			$level = 0;
			if (isset($documents['projectBidInvitations'])) {
				$level = 1;
				$tmpHeader = '<tr><td class="bidding-module-email-modal-dialog-files-document-header">Default Project Bid Invitation Files</td></tr>';
				$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $tmpHeader;
				foreach ($documents['projectBidInvitations'] as $htmlProjectBidInvitations) {
					if ($hasGcBudgetLineItemDocument || $hasSubcontractorBidDocument) {
						$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= str_replace('<td', '<td class="strike-through"', $htmlProjectBidInvitations);
					} else {

						$tmpHtml = str_replace('type="checkbox"', 'type="checkbox" checked', $htmlProjectBidInvitations);
						$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $tmpHtml;
					}
				}
			}

			// 2.
			if (isset($documents['gc_budget_line_item_bid_invitation']) || isset($documents['gc_budget_line_item_unsigned_scope_of_work_documents'])) {
				$level += 1;
			}
			$indentationSpace = generateIndentationByLevel($level);
			if (isset($documents['gc_budget_line_item_bid_invitation'])) {

				$tmpHeader = '<tr><td class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . 'GC Budget Line Item -- Bid Invitations</td></tr>';
				$tmpHtmlGcBudgetLineItemBidInvitation = '';
				$tmpHtmlGcBudgetLineItemBidInvitation .= outputDocumentRow($documents['gc_budget_line_item_bid_invitation'], $indentationSpace);
				// we now perform sub document $hasSubcontractorBidDocument check
				if ($hasSubcontractorBidDocument) {
					$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $tmpHeader . str_replace('<td', '<td class="strike-through"', $tmpHtmlGcBudgetLineItemBidInvitation);
				} else {
					$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $tmpHeader . str_replace('type="checkbox"', 'type="checkbox" checked', $tmpHtmlGcBudgetLineItemBidInvitation);
				}
			}

			if (isset($documents['gc_budget_line_item_unsigned_scope_of_work_documents'])) {
				// _arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds
				$checkGcBudgetLineItemUnsignedScopeOfWorkDocument = false;
				$key_gc_budget_line_item_unsigned_scope_of_work_documents = array_keys($documents['gc_budget_line_item_unsigned_scope_of_work_documents']);
				if (in_array($key_gc_budget_line_item_unsigned_scope_of_work_documents[0], $this->_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds)) {
					$checkGcBudgetLineItemUnsignedScopeOfWorkDocument = true;
				}
				$tmpHeader = '<tr><td colspan="3" class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . 'GC Budget Line Item -- Unsigned Scope Of Work Files</td></tr>';
				$tmpHtmlGcBudgetLineItemUnsignedScopeOfWorkDocuments = "";
				$tmpHtmlGcBudgetLineItemUnsignedScopeOfWorkDocuments .= outputDocumentRow($documents['gc_budget_line_item_unsigned_scope_of_work_documents'], $indentationSpace);
				// we now perform sub document $hasSubcontractorBidDocument check
				if (!$checkGcBudgetLineItemUnsignedScopeOfWorkDocument) {
					$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $tmpHeader . str_replace('<td', '<td class="strike-through"', $tmpHtmlGcBudgetLineItemUnsignedScopeOfWorkDocuments);
				}
				else {
					$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $tmpHeader . str_replace('type="checkbox"', 'type="checkbox" checked', $tmpHtmlGcBudgetLineItemUnsignedScopeOfWorkDocuments);
				}
			}

			// subcontract bid invitation
			if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION]) || isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK])) {
				$level += 1;
			}
			// make indentation
			$indentationSpace = generateIndentationByLevel($level);
			if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION])) {

				$tmpHtmlSubcontractorBidInvitation = '';
				$tmpHtmlSubcontractorBidInvitation .= '<tr><td class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . 'Bid Invitation -- Bidder Specific</td></tr>';
				$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $tmpHtmlSubcontractorBidInvitation . outputDocumentRow($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION], $indentationSpace);

			}
			if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK])) {

				$tmpHtmlSubcontractorBidInvitation = '';
				$tmpHtmlSubcontractorBidInvitation .= '<tr><td colspan="3" class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . 'Unsigned Scope Of Work -- Bidder Specific</td></tr>';
				$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $tmpHtmlSubcontractorBidInvitation . outputDocumentRow($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK], $indentationSpace);

			}
			if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_SUBCONTRACTOR_BID])) {

				$tmpHtmlSubcontractorBidInvitation = '';
				$tmpHtmlSubcontractorBidInvitation .= '<tr><td class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . '</td></tr>';
				$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $tmpHtmlSubcontractorBidInvitation . outputDocumentRow($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_SUBCONTRACTOR_BID], $indentationSpace);

			}
			if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_SIGNED_SCOPE_OF_WORK])) {

				$tmpHtmlSubcontractorBidInvitation = '';
				$tmpHtmlSubcontractorBidInvitation .= '<tr><td colspan="3" class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . 'Signed Scope Of Work</td></tr>';
				$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $tmpHtmlSubcontractorBidInvitation . outputDocumentRow($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_SIGNED_SCOPE_OF_WORK], $indentationSpace);

			}


			$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= "</table>\n";
		}
		return $arrUniqueBiddersByContactHtml;
	}


	public function getLatestGcBudgetLineItemBidInvitationHtmlCode($gc_budget_line_item_id, $subcontractor_bid_id, $checkboxChecked = false)
	{
		if (!isset($this->_latestGcBudgetLineItemBidInvitationHtmlCode[$gc_budget_line_item_id])) {
			$loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIdsInput = new Input();
			$loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIdsInput->limit = 1;
			$loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIdsInput->arrOrderByAttributes = array(
			'gc_budget_line_item_bid_invitation_sequence_number' => 'DESC'
			);
			$arrGcBudgetLineItemBidInvitations =
			GcBudgetLineItemBidInvitation::loadGcBudgetLineItemBidInvitationsByGcBudgetLineItemId($this->_database, $gc_budget_line_item_id, $loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIdsInput);
			if (isset($arrGcBudgetLineItemBidInvitations) && count($arrGcBudgetLineItemBidInvitations) > 0) {
				foreach ($arrGcBudgetLineItemBidInvitations as $gc_budget_line_item_bid_invitation_id => $gcBudgetLineItemBidInvitation) {
					// need cost code id and gc Budget line item id to assign and find association with sub_contractor_id
					$gcBudgetLineItem = $gcBudgetLineItemBidInvitation->getGcBudgetLineItem();

					$gc_budget_line_item_id = $gcBudgetLineItem->gc_budget_line_item_id;
					$cost_code_id = $gcBudgetLineItem->cost_code_id;

					$budgetLineItemBidInvitationVirtualFileName = getBudgetLineItemBidInvitationVirtualFileName($gcBudgetLineItemBidInvitation);

					$this->_latestGcBudgetLineItemBidInvitationHtmlCode[$gc_budget_line_item_id][$gc_budget_line_item_bid_invitation_id] = $budgetLineItemBidInvitationVirtualFileName;
					break;
				}
			}

		}
		if (isset($this->_latestGcBudgetLineItemBidInvitationHtmlCode[$gc_budget_line_item_id])) {
			foreach($this->_latestGcBudgetLineItemBidInvitationHtmlCode[$gc_budget_line_item_id] as $gc_budget_line_item_bid_invitation_id => $gcBudgetLineItemBidInvitationHtml) {
				$checkboxCSSClass = "bidding-module-email-modal-dialog-files--gc_budget_line_item_bid_invitations--gc_budget_line_item_bid_invitation_id--{$gc_budget_line_item_bid_invitation_id}";
				$html = '<input type="checkbox" value="' . $subcontractor_bid_id . '" onclick="biddingModuleEmailDialogCheckboxState(this);" class="' . $checkboxCSSClass . '">' .
				$gcBudgetLineItemBidInvitationHtml;
				return $html;
			}
		}

	}
	public function getLatestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode($gc_budget_line_item_id, $subcontractor_bid_id, $checkboxChecked = false)
	{

		if (!isset($this->_latestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode[$gc_budget_line_item_id])) {
			$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions = new Input();

			$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
			$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions->limit = 1;
			$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions->arrOrderByAttributes = array(
			'unsigned_scope_of_work_document_sequence_number' => 'DESC'
			);
			$arrGcBudgetLineItemUnsignedScopeOfWorkDocuments =
			GcBudgetLineItemUnsignedScopeOfWorkDocument::loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId($this->_database, $gc_budget_line_item_id, $loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions);
			if (isset($arrGcBudgetLineItemUnsignedScopeOfWorkDocuments) && count($arrGcBudgetLineItemUnsignedScopeOfWorkDocuments) > 0) {
				foreach ($arrGcBudgetLineItemUnsignedScopeOfWorkDocuments as $gc_budget_line_item_unsigned_scope_of_work_document_id => $gcBudgetLineItemUnsignedScopeOfWorkDocuments) {
					$gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile = $gcBudgetLineItemUnsignedScopeOfWorkDocuments->getUnsignedScopeOfWorkDocumentFileManagerFile();
					/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile FileManagerFile */

					$gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->htmlEntityEscapeProperties();

					$file_manager_file_id = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->file_manager_file_id;
					$virtual_file_name = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->virtual_file_name;
					$escaped_virtual_file_name = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->escaped_virtual_file_name;
					$cdnFileUrl = $gcBudgetLineItemUnsignedScopeOfWorkDocumentFileManagerFile->generateUrl();

					$fileHtml = outputHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentByid($cdnFileUrl,$escaped_virtual_file_name,$gc_budget_line_item_unsigned_scope_of_work_document_id);

					$checkboxCSSClass = "bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id--{$gc_budget_line_item_unsigned_scope_of_work_document_id}";
					$this->_latestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode[$gc_budget_line_item_id]['checkboxCSSClass'] = $checkboxCSSClass;
					$this->_latestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode[$gc_budget_line_item_id]['fileHtml'] = $fileHtml;
					//$this->_latestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode[$gc_budget_line_item_id]['fileHtml'] = $fileHtml;
					break;
					//'<input type="checkbox" value="' . $subcontractor_bid_id . '" class="' . $checkboxCSSClass . '" onclick="biddingModuleEmailDialogCheckboxState(this);">'
					//. $fileHtml; // the file put
					// $this->_arrHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentById[$gc_budget_line_item_unsigned_scope_of_work_document_id];
				}
			}
		}
		if (isset($this->_latestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode[$gc_budget_line_item_id])) {
			if ($checkboxChecked) {
				$checkboxCheckedHtml = ' checked';
			} else {
				$checkboxCheckedHtml = '';
			}

			$strHtml = '<input type="checkbox" value="' . $subcontractor_bid_id . '" class="' . $this->_latestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode[$gc_budget_line_item_id]['checkboxCSSClass'] . '" onclick="biddingModuleEmailDialogCheckboxState(this);" ' . $checkboxCheckedHtml .'>'
				. $this->_latestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode[$gc_budget_line_item_id]['fileHtml'];
			return $strHtml;
		}
	}
	public function mergeBidderDocumentsByCostcode($arrHtmlSubcontractorBidDocuments)
	{
		// local or member?

		foreach ($this->_arrGcLineItemCostCodeSubcontractorBids as $gc_budget_line_item_id => $codecodeItems) {
			foreach($codecodeItems as $codecodeId => $subcontractorBids) {
				foreach($subcontractorBids as $subcontractorBid) {

					//print_r($subcontractorBid);
					//exit;
					/* @var $subcontractorBid SubcontractorBid */
					$subcontractor_bid_id = $subcontractorBid->subcontractor_bid_id;
					$gcBudgetLineItem = $subcontractorBid->getGcBudgetLineItem();

					$gc_budget_line_item_id = $gcBudgetLineItem->gc_budget_line_item_id;
					/* @var $gcBudgetLineItem GcBudgetLineItem */
					//print_r($gcBudgetLineItem); exit;
					$costCode = $gcBudgetLineItem->getCostCode();
					/* @var $costCode CostCode */

					$costCodeDivision = $costCode->getCostCodeDivision();
					/* @var $costCodeDivision CostCodeDivision */

					if ($costCode) {
						$costCode->htmlEntityEscapeProperties();
						$htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCode();
					}

					$subcontractorContact = $subcontractorBid->getSubcontractorContact();
					/* @var $subcontractorContact Contact */

					$subcontractorContactCompany = $subcontractorContact->getContactCompany();
					/* @var $subcontractorContactCompany ContactCompany */

					$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
					/* @var $subcontractorBidStatus SubcontractorBidStatus */

					$subcontractorContact->htmlEntityEscapeProperties();
					$subcontractorContactCompany->htmlEntityEscapeProperties();

					$contactFullNameHtmlEscaped = $subcontractorContact->getContactFullNameHtmlEscaped();
					$escaped_email = $subcontractorContact->escaped_email;

					$escaped_contact_company_name = $subcontractorContactCompany->escaped_contact_company_name;

					$subcontractorBidStatus->htmlEntityEscapeProperties();
					$escaped_subcontractor_bid_status = $subcontractorBidStatus->escaped_subcontractor_bid_status;

					$subcontractor_contact_id = $subcontractorContact->contact_id;


					if ($this->debugMode) {
						$tmpDebugHtml = "[subcontractor_bid_id: $subcontractor_bid_id] [subcontractor_contact_id: $subcontractor_contact_id] ";
					} else {
						$tmpDebugHtml = '';
					}

					$subcontractorBidHtmlHeader = <<<END_SUBCONTRACTOR_BID_HTML_HEADER

<table id="record_container--bidding-module-email-modal-dialog-subcontractor-bid-details--subcontractor_bids--subcontractor_bid_id--$subcontractor_bid_id" class="subaccordion-header bidding-module-email-modal-dialog-files-subcontractor-bid-documents-table" style="width: 100%;">
	<tr>
		<td>
			<h3 style="margin: 0;">
				{$tmpDebugHtml}{$escaped_contact_company_name} &mdash; $contactFullNameHtmlEscaped [$htmlEntityEscapedFormattedCostCode] &mdash; $escaped_subcontractor_bid_status
				<img class="fakeHref" width="12" height="12" onclick="deleteBidderFrom_BiddingModuleEmailModalDialog('$subcontractor_bid_id', '$contactFullNameHtmlEscaped &lt;$escaped_email&gt;');" title="Remove this bidder from the list." alt="" src="/images/icons/icon-delete-x-circle.png">
			</h3>
		</td>
	</tr>

END_SUBCONTRACTOR_BID_HTML_HEADER;

					// flag to avoid mulitple global bid invitation and header
					//$arrUniqueBiddersByContact[$subcontractor_contact_id] = 1;
					//echo "$costCodeDivision<br>";
					//echo "$contactFullNameHtmlEscaped<br>";
					$key_subcontractor_bid_id_contact_name = $subcontractor_bid_id . "--" . $contactFullNameHtmlEscaped;
					//echo "<pre>[$key_subcontractor_bid_id_contact_name]\n";
					$this->arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments[$htmlEntityEscapedFormattedCostCode][$key_subcontractor_bid_id_contact_name]['header'] = $subcontractorBidHtmlHeader;

					// use these variables to contract documents layout
					// see function $this->processCSVSubcontractBidDocument()

					$hasSubBidDoc = false;
					if (isset($this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasSubBidDoc'])) {
						$hasSubBidDoc = true;
					}
					$hasOtherDocs = false;
					if(isset($this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasGcBudgetLineItemBidInvitation']) || isset($this->_arrSubcontractorDocumentFormInput[0]['projectBidInvitation'])) {
						$hasOtherDocs = true;
					}

					//// ProjectBidInvitationsDocument
					// function outputSubcontractorProjectBidInvitationsDocumentEntry
					// will decide on strike-through or checked property
					// see for reference

					if (count($this->_arrProjectBidInvitationsDocumentEntry) > 0 && !$hasSubBidDoc) {
						$outputSubcontractorProjectBidInvitationsDocumentEntry = $this->outputSubcontractorProjectBidInvitationsDocumentEntry($this->_arrProjectBidInvitationsDocumentEntry, $subcontractor_bid_id);
						// contact might have multiple entries due to cost code and group id
						// for group by contact, we want only one global bid invitation document
						$this->arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments[$htmlEntityEscapedFormattedCostCode][$key_subcontractor_bid_id_contact_name]['projectBidInvitations'][] = $outputSubcontractorProjectBidInvitationsDocumentEntry;
						//$arrUniqueBiddersByContactHtml[$subcontractor_contact_id] .= $outputSubcontractorProjectBidInvitationsDocumentEntry;
					}

					// has a subcontract bid invitation document selected
					if (isset($this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasBidInvitionDoc']) && count($this->_arrProjectBidInvitationsDocumentEntry) > 0) {
						$outputSubcontractorProjectBidInvitationsDocumentEntry = $this->outputSubcontractorProjectBidInvitationsDocumentEntry($this->_arrProjectBidInvitationsDocumentEntry, $subcontractor_bid_id);
						// contact might have multiple entries due to cost code and group id
						// for group by contact, we want only one global bid invitation document
						$this->arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments[$htmlEntityEscapedFormattedCostCode][$key_subcontractor_bid_id_contact_name]['projectBidInvitations'][] = $outputSubcontractorProjectBidInvitationsDocumentEntry;

					}

					//////////// GcBudgetLineItemSelectedBitInvitation
					if (isset($this->_arrBidderGcBudgetLineItemSelectedBitInvitation[$subcontractor_bid_id])) {
						foreach ($this->_arrBidderGcBudgetLineItemSelectedBitInvitation[$subcontractor_bid_id] as $gc_budget_line_item_bid_invitation_id) {
							$checkboxCSSClass = "bidding-module-email-modal-dialog-files--gc_budget_line_item_bid_invitations--gc_budget_line_item_bid_invitation_id--{$gc_budget_line_item_bid_invitation_id}";
							$this->arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments[$htmlEntityEscapedFormattedCostCode][$key_subcontractor_bid_id_contact_name]['gc_budget_line_item_bid_invitation'][] =  '<input type="checkbox" value="' . $subcontractor_bid_id . '" onclick="biddingModuleEmailDialogCheckboxState(this);" class="' . $checkboxCSSClass . '" checked>' . $this->_arrHtmlGcBudgetLineItemBidInvitations[$gc_budget_line_item_bid_invitation_id];
						}
					} elseif (isset($this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasBidInvitionDoc'])) {
						// load a default
						$this->arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments[$htmlEntityEscapedFormattedCostCode][$key_subcontractor_bid_id_contact_name]['gc_budget_line_item_bid_invitation'][] = $this->getLatestGcBudgetLineItemBidInvitationHtmlCode($gc_budget_line_item_id, $subcontractor_bid_id);
					}

					//////////// GcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments
					if (isset($this->_arrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments[$subcontractor_bid_id])) {
						foreach ($this->_arrBidderGcBudgetLineItemSelectedUnsignedScopeOfWorkDocuments[$subcontractor_bid_id] as $gc_budget_line_item_unsigned_scope_of_work_document_id) {
							$checkboxCSSClass = "bidding-module-email-modal-dialog-files--gc_budget_line_item_unsigned_scope_of_work_documents--gc_budget_line_item_unsigned_scope_of_work_document_id--{$gc_budget_line_item_unsigned_scope_of_work_document_id}";
							$this->arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments[$htmlEntityEscapedFormattedCostCode][$key_subcontractor_bid_id_contact_name]['gc_budget_line_item_unsigned_scope_of_work_documents'][$gc_budget_line_item_unsigned_scope_of_work_document_id] =
							'<input type="checkbox" value="' . $subcontractor_bid_id . '" class="' . $checkboxCSSClass . '" onclick="biddingModuleEmailDialogCheckboxState(this);" checked>' . $this->_arrHtmlGcBudgetLineItemUnsignedScopeOfWorkDocumentById[$gc_budget_line_item_unsigned_scope_of_work_document_id];
						}
					} else {
						// if we have $this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasUnsignedScopeOfWorkDoc']
						// load the gc line item unsigned work doc
						if (isset($this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasUnsignedScopeOfWorkDoc']) && $this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasUnsignedScopeOfWorkDoc']) {
							$this->arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments[$htmlEntityEscapedFormattedCostCode][$key_subcontractor_bid_id_contact_name]['gc_budget_line_item_unsigned_scope_of_work_documents_default'][] = $this->getLatestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode($gc_budget_line_item_id, $subcontractor_bid_id);
						}
						elseif(!$hasSubBidDoc && !$hasOtherDocs) {
							// we output a default if there is no doc selected at all
							$this->arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments[$htmlEntityEscapedFormattedCostCode][$key_subcontractor_bid_id_contact_name]['gc_budget_line_item_unsigned_scope_of_work_documents'][] = $this->getLatestGcBudgetLineItemUnsignedScopeOfWorkDocumentsHtmlCode($gc_budget_line_item_id, $subcontractor_bid_id, true);


						}
					}

					// $arrHtmlSubcontractorBidDocuments
					if (isset($arrHtmlSubcontractorBidDocuments[$subcontractor_bid_id])) {
						foreach ($arrHtmlSubcontractorBidDocuments[$subcontractor_bid_id] as $subcontractor_bid_document_type => $arrHtmlSubcontractorBidDocumentsEntries) {
							foreach ($arrHtmlSubcontractorBidDocumentsEntries as $htmlSubcontractorBidDocumentsEntry) {
								$this->arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments[$htmlEntityEscapedFormattedCostCode][$key_subcontractor_bid_id_contact_name][$subcontractor_bid_document_type][] = $htmlSubcontractorBidDocumentsEntry;
							}
						}
					}
				}
			}
		}

	}
	public function outputEmailDocumentBlocksByCostcode()
	{
		$subcontractorHtmlEntry = array();

		$subcontractorIndex = 0;
		foreach ($this->arrUniqueBiddersBySubcontractorBidIdHtmlByGroupDocuments as $costcodeDivisionDescription => $subcontractors) {

			$subcontractorHtmlEntry[$subcontractorIndex] = <<<END_SUBCONTRACTOR_BID_HTML_HEADER
				<div>
					<div class='costCodeHeader'>$costcodeDivisionDescription
					</div>

END_SUBCONTRACTOR_BID_HTML_HEADER;

			//foreach($subcontractors as $subcontractName => $documents) {
			//echo "<pre>";
			//print_r($subcontractors);exit;
			foreach($subcontractors as $subcontractNameIdPair => $documents) {
				list($subcontractor_bid_id, $subcontractName) = explode('--', $subcontractNameIdPair);
				$subcontractorIndex++;
				// check if we have subDocument under gc budget line item
				if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION]) || isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK])) {
					$hasSubcontractorBidDocument = true;
				} else {
					$hasSubcontractorBidDocument = false;
				}

				// check if we have gc budget line item level
				if (isset($documents['gc_budget_line_item_bid_invitation']) || isset($documents['gc_budget_line_item_unsigned_scope_of_work_documents'])) {
					$hasGcBudgetLineItemDocument = true;
				} else {
					$hasGcBudgetLineItemDocument = false;
				}

				// 1. start with header
				$subcontractorHtmlEntry[$subcontractorIndex] = $documents['header'];

				// 2. ProjectBidInvitations
				$level = 0;
				//if(!isset($this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasSubBidDoc'])) {)
				if (isset($documents['projectBidInvitations']) //&& (!isset($this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasSubBidDoc']))
				) {
					$level = 1;
					$tmpHeader = '<tr><td class="bidding-module-email-modal-dialog-files-document-header">Default Project Bid Invitation Files</td></tr>';
					$subcontractorHtmlEntry[$subcontractorIndex]  .= $tmpHeader;
					foreach ($documents['projectBidInvitations'] as $htmlProjectBidInvitations) {
						$subcontractorHtmlEntry[$subcontractorIndex]  .= $htmlProjectBidInvitations;
					}
				}

				// 2. gc_budget_line_item_bid_invitation
				if (isset($documents['gc_budget_line_item_bid_invitation']) || isset($documents['gc_budget_line_item_unsigned_scope_of_work_documents'])) {
					$level += 1;
				}
				$indentationSpace = generateIndentationByLevel($level);
				if (isset($documents['gc_budget_line_item_bid_invitation'])) {
					// does bidder has selected the doc?
					$hasGcBudgetLineItemBidInvitation = false;
					if (isset($this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasGcBudgetLineItemBidInvitation'])) {
						$hasGcBudgetLineItemBidInvitation = true;
					}
					$tmpHeader = '<tr><td class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . 'GC Budget Line Item -- Bid Invitations</td></tr>';
					$tmpHtmlGcBudgetLineItemBidInvitation = '';
					$tmpHtmlGcBudgetLineItemBidInvitation .= outputDocumentRow($documents['gc_budget_line_item_bid_invitation'], $indentationSpace);
					// we now perform sub document $hasSubcontractorBidDocument check
					if ($hasSubcontractorBidDocument && !$hasGcBudgetLineItemBidInvitation) {
						$subcontractorHtmlEntry[$subcontractorIndex]  .= $tmpHeader . str_replace('<td', '<td class="strike-through"', $tmpHtmlGcBudgetLineItemBidInvitation);
					} else {
						$subcontractorHtmlEntry[$subcontractorIndex]  .= $tmpHeader . str_replace('type="checkbox"', 'type="checkbox" checked', $tmpHtmlGcBudgetLineItemBidInvitation);
					}
				}

				// 3. subcontract bid invitation
				if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION]) || isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK])) {
					$level += 1;
				}
				// make indentation
				$indentationSpace = generateIndentationByLevel($level);


				if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION])) {

					$tmpHtmlSubcontractorBidInvitation = '';
					$tmpHtmlSubcontractorBidInvitation .= '<tr><td class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . 'Bid Invitation -- Bidder Specific</td></tr>';
					$subcontractorHtmlEntry[$subcontractorIndex]  .= $tmpHtmlSubcontractorBidInvitation . outputDocumentRow($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_BID_INVITION], $indentationSpace);

				}

				// 4. gc_budget_line_item_unsigned_scope_of_work_documents
				$gcBudgetLineItemUnsignedDocIndentationSpace = generateIndentationByLevel(0);
				if (isset($documents['gc_budget_line_item_unsigned_scope_of_work_documents'])) {

					$tmpHeader = '<tr><td colspan="3" class="bidding-module-email-modal-dialog-files-document-header">' . $gcBudgetLineItemUnsignedDocIndentationSpace . 'GC Budget Line Item -- Unsigned Scope Of Work Files</td></tr>';
					$tmpHtmlGcBudgetLineItemUnsignedScopeOfWorkDocuments = "";
					$tmpHtmlGcBudgetLineItemUnsignedScopeOfWorkDocuments .= outputDocumentRow($documents['gc_budget_line_item_unsigned_scope_of_work_documents'], $gcBudgetLineItemUnsignedDocIndentationSpace);
					$subcontractorHtmlEntry[$subcontractorIndex]  .= $tmpHeader . $tmpHtmlGcBudgetLineItemUnsignedScopeOfWorkDocuments;
				} elseif (isset($documents['gc_budget_line_item_unsigned_scope_of_work_documents_default'])) {
					// gc_budget_line_item_unsigned_scope_of_work_documents_default
					$tmpHeader = '<tr><td colspan="3" class="bidding-module-email-modal-dialog-files-document-header">' . $gcBudgetLineItemUnsignedDocIndentationSpace . 'GC Budget Line Item -- Unsigned Scope Of Work Files</td></tr>';
					$tmpHtmlGcBudgetLineItemUnsignedScopeOfWorkDocuments = "";
					$tmpHtmlGcBudgetLineItemUnsignedScopeOfWorkDocuments .= outputDocumentRow($documents['gc_budget_line_item_unsigned_scope_of_work_documents_default'], $gcBudgetLineItemUnsignedDocIndentationSpace, "strike-through");
					$subcontractorHtmlEntry[$subcontractorIndex]  .= $tmpHeader . $tmpHtmlGcBudgetLineItemUnsignedScopeOfWorkDocuments;
				}

				if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK])) {

					$tmpHtmlSubcontractorBidInvitation = '';
					$tmpHtmlSubcontractorBidInvitation .= '<tr><td colspan="3" class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . 'Unsigned Scope Of Work -- Bidder Specific</td></tr>';
					$unsignDocindentationSpace = generateIndentationByLevel(1);
					$subcontractorHtmlEntry[$subcontractorIndex]  .= $tmpHtmlSubcontractorBidInvitation . outputDocumentRow($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_UNSIGNED_SCOPE_OF_WORK], $indentationSpace);

				}
				if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_SUBCONTRACTOR_BID])) {
					$indentationSpace = generateIndentationByLevel(0);
					$tmpHtmlSubcontractorBidInvitation = '';
					$tmpHtmlSubcontractorBidInvitation .= '<tr><td class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . 'SUBCONTRACTOR_BID</td></tr>';
					$subcontractorHtmlEntry[$subcontractorIndex]  .= $tmpHtmlSubcontractorBidInvitation . outputDocumentRow($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_SUBCONTRACTOR_BID], $indentationSpace);

				}
				if (isset($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_SIGNED_SCOPE_OF_WORK])) {
					$indentationSpace = generateIndentationByLevel(0);
					$tmpHtmlSubcontractorBidInvitation = '';
					$tmpHtmlSubcontractorBidInvitation .= '<tr><td colspan="3" class="bidding-module-email-modal-dialog-files-document-header">' . $indentationSpace . 'signed Scope Of Work -- Bidder Specific</td></tr>';
					$subcontractorHtmlEntry[$subcontractorIndex]  .= $tmpHtmlSubcontractorBidInvitation . outputDocumentRow($documents[Constants::SUBCONTRACTOR_BID_DOCUMENT_SIGNED_SCOPE_OF_WORK], $indentationSpace);

				}
				$subcontractorHtmlEntry[$subcontractorIndex]  .= "</table>\n";
				$subcontractorIndex++;
			}
			$subcontractorIndex++;
			// end of cost code
			$subcontractorHtmlEntry[$subcontractorIndex] = "\t\t\t</div>\n";
			//return $arrUniqueBiddersByContactHtml;
		}
		return $subcontractorHtmlEntry;
	}

	public function outputSubcontractorProjectBidInvitationsDocumentEntry($arrProjectBidInvitationsDocumentEntry, $subcontractor_bid_id)
	{

		$tmpHtml = "";


		$arrProjectBidInvitationsDocumentEntryCount = count($arrProjectBidInvitationsDocumentEntry);

		foreach ($arrProjectBidInvitationsDocumentEntry as $project_bid_invitation_id => $htmlProjectBidInvitationsDocumentEntry) {
			$isSelectedDocument = false;
			$hasLowerLevelDoc = false;
			// check to see if document is selected
			if (in_array($project_bid_invitation_id, $this->_biddingModuleFormInputSelection['projectBidInvitationIds'])) {
				$isSelectedDocument = true;
			}

			// does user contain selection of hasGcBudgetLineItemBidInvitation or contract level bid invitation?
			if (isset($this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasGcBudgetLineItemBidInvitation']) || isset($this->_arrSubcontractorDocumentFormInput[$subcontractor_bid_id]['hasBidInvitionDoc'])) {
				$hasLowerLevelDoc = true;
			}

			// projectBidInvitationIds document is selected: checked
			$checkboxChecked = '';
			if ($isSelectedDocument) {
				$checkboxChecked = ' checked';
			}


			$classTd = '';
			// has child doc for the subcontract_bid
			// so we do a strike through class td
			if (!$isSelectedDocument && $hasLowerLevelDoc) {
				$classTd = ' class="strike-through"';
			}

			// if no doc selected, we select the doc for default
			if (!$isSelectedDocument && !$hasLowerLevelDoc) {
				$checkboxChecked = ' checked';
			}

			$tmpHtml .= <<<END_TR_HTML
						<tr>
							<td{$classTd}>
								<input type="checkbox" onclick="biddingModuleEmailDialogCheckboxState(this);" value="$subcontractor_bid_id" class="bidding-module-email-modal-dialog-files--project_bid_invitations bidding-module-email-modal-dialog-files--project_bid_invitations--project_bid_invitation_id--{$project_bid_invitation_id}" {$checkboxChecked}>
								$htmlProjectBidInvitationsDocumentEntry
							</td>
						</tr>
END_TR_HTML;
		}
		return $tmpHtml;
	}

}
