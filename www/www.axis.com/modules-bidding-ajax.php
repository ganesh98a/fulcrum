<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 20000;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
//$init['post_maxlength'] = 100000;
//$init['post_required'] = true;
//$init['sapi'] = 'cli';
//$init['skip_always_include'] = true;
//$init['skip_session'] = true;
//$init['skip_templating'] = true;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

// Method Call is our switch variable
if (isset($get)) {
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('modules-bidding-functions.php');

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
*/

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {

	case 'sendBidInvitation':

		$crudOperation = 'other';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;

		try {

			$attributeGroupName = (string) $get->attributeGroupName;
			$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
			$attributeSubgroupName = (string) $get->attributeSubgroupName;
			$formattedAttributeSubgroupName = (string) $get->formattedAttributeSubgroupName;
			$uniqueId = (string) $get->uniqueId;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the JobsiteManPower record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: Jobsite Man Power';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadAddNewBidderDialog':

		// @todo Refactor these to come from View objects
		$jsOptions = '{ ajaxHandler: "modules-bidding-ajax.php?method=executeSearchForNewBiddersByCompanyOrContact", callback: contactSearchResultsReceived }';
		$javaScriptHandler = 'biddingAddBiddersToBudget';
		include('page-components/contact_search_by_contact_company_name_or_contact_name.php');
		include('page-components/contact_search_by_cost_code_association.php');

		$htmlContent = <<<END_HTML_CONTENT

			<table border="0" width="100%">
				<tr>
					<td>
						<div id="biddingAddBiddersToBudget" class="contact-search-parent-container" style="width:100%;">
							$contact_search_form_by_contact_company_name_or_contact_name_html
							$contact_search_form_by_contact_company_name_or_contact_name_javascript
							$contact_search_form_by_cost_code_html
							$contact_search_form_by_cost_code_javascript
						</div>
						<input id="listOfSelectedIds" name="listOfSelectedIds" type="hidden">
					</td>
				</tr>
			</table>
			<div class="small-font hidden" style="margin-top:10px">
				<div class="underline">Selected Bidders:</div>
				<ul id="ulSelectedBidders"></ul>
			</div>
END_HTML_CONTENT;

		echo $htmlContent;

	break;

	case 'addBiddersByCsvContactIdsAndCostCodeIds':

		$csvContactIdsAndCostCodeIds = $get->csvContactIdsAndCostCodeIds;
		$arrContactIdsAndCostCodeIds = explode(',', $csvContactIdsAndCostCodeIds);

		$subcontractorBidStatus = SubcontractorBidStatus::findBySubcontractorBidStatus($database, 'Potential Bidder');
		$subcontractor_bid_status_id = $subcontractorBidStatus->subcontractor_bid_status_id;

		$arrSubcontractorBids = array();
		foreach ($arrContactIdsAndCostCodeIds as $id) {
			$arrTemp = explode('-', $id);
			$contact_id = (int) array_shift($arrTemp);
			$cost_code_id = (int) array_shift($arrTemp);

			$gcBudgetLineItem = GcBudgetLineItem::findByUserCompanyIdAndProjectIdAndCostCodeId($database, $user_company_id, $project_id, $cost_code_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */

			$gc_budget_line_item_id = $gcBudgetLineItem->gc_budget_line_item_id;

			$subcontractorBid = new SubcontractorBid($database);
			$data = array(
				'gc_budget_line_item_id' => $gc_budget_line_item_id,
				'subcontractor_contact_id' => $contact_id,
				'subcontractor_bid_status_id' => $subcontractor_bid_status_id,
			);
			$subcontractorBid->setData($data);
			$subcontractorBid->convertDataToProperties();
			$subcontractorBid->convertPropertiesToData();
			$subcontractor_bid_id = $subcontractorBid->save();

			if ($subcontractor_bid_id) {
				$arrSubcontractorBids[$subcontractor_bid_id] = $subcontractorBid;
			}
		}

		if (count($arrSubcontractorBids) == 0) {

			$arrOutput = array(
				'messageText' => 'Something went wrong.',
				'error' => 1
			);

		} else {

			$htmlContent = renderBiddingContent($database, $user_company_id, $project_id, $currentlyActiveContactId);

			$arrOutput = array(
				'messageText' => 'Bidders added.',
				'htmlContent' => $htmlContent
			);
		}

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;

	case 'executeSearchForNewBiddersByCompanyOrContact':

		$company = $get->company;
		$first_name = $get->first_name;
		$last_name = $get->last_name;
		$javaScriptHandler = $get->jsHandler;

		$arrContacts = Contact::loadContactsByUserCompanyIdAndPartialFirstNameAndPartialLastNameAndPartialCompany($database, $user_company_id, $first_name, $last_name, $company);

		$arrCostCodesByProjectId = CostCode::loadCostCodesByProjectId($database, $project_id);

		$searchResultsTbody = '';
		foreach ($arrContacts as $contact_id => $contact) {
			/* @var $contact Contact */

			$contactCompany = $contact->getContactCompany();
			/* @var $contactCompany ContactCompany */
			$contact_company_id = $contactCompany->contact_company_id;
			$company = $contactCompany->company;

			$first_name = $contact->first_name;
			$last_name = $contact->last_name;
			$email = $contact->email;

			$encodedFirstName = rawurlencode($first_name);
			$encodedLastName = rawurlencode($last_name);
			$encodedEmail = rawurlencode($email);
			$encodedCompany = rawurlencode($company);

			$attributeGroupName = 'create-subcontractor_trade-record';
			$dummyId = Data::generateDummyPrimaryKey();
			$ddlElementId = "$attributeGroupName--subcontractor_trades--cost_code_id--$dummyId";
			$popoverButtonElementId = "popoverButton--$attributeGroupName--$dummyId";
			$popoverContentElementId = "popoverContent--$attributeGroupName--$dummyId";
			$popoverElementId = "popoverElement--$attributeGroupName--$dummyId";
			$prependedOption = '<option value="">Please Select A Cost Code</option';
			$ddlCostCodesByProjectId = PageComponents::dropDownListFromObjects($ddlElementId, $arrCostCodesByProjectId, 'cost_code_id', null, null, 'getFormattedCostCode', '', '', 'class="required"', $prependedOption);

			$popoverHtml = <<<END_POPOVER_HTML

			<span id="$popoverButtonElementId" class="popoverButton entypo entypo-click entypo-plus-circled"></span>
			<div id="$popoverContentElementId" class="hidden popover-content">
				<div id="container--create-subcontractor_trade-record--$dummyId">
					Cost Code: $ddlCostCodesByProjectId
					<input type="hidden" id="$attributeGroupName--subcontractor_trades--contact_company_id--$dummyId" value="$contact_company_id">
					<div class="textAlignRight" style="margin-top:5px">
						<input type="submit" onclick="createSubcontractorTradeFromPopover('create-subcontractor_trade-record', '$dummyId', { popoverElementId: '$popoverButtonElementId' });" value="Create Subcontractor Trade">
					</div>
				</div>
			</div>

END_POPOVER_HTML;

			$bidderJsObject = <<<END_BIDDER_JS_OBJECT

			{
				contact_id:   '$contact_id',
				company:      '$company',
				first_name:   '$first_name',
				last_name:    '$last_name',
				email:        '$email'
			}

END_BIDDER_JS_OBJECT;

			$bidderJsObject = preg_replace('/\s+/', ' ', $bidderJsObject);

			$searchResultsTbody .= <<<END_SEARCH_RESULTS_TBODY

				<tr class="no-click" data-onclick="SelectedBidders.add($bidderJsObject);">
					<td nowrap>$popoverHtml</td>
					<td nowrap>$company</td>
					<td nowrap>$first_name</td>
					<td nowrap>$last_name</td>
					<td nowrap>$email</td>
				</tr>

END_SEARCH_RESULTS_TBODY;

			$arrCostCodes = CostCode::loadCostCodesByContactIdAndContactCompanyId($database, $contact_id, $contact_company_id);
			$costCodeHtml = '';
			foreach ($arrCostCodes as $cost_code_id => $costCode) {
				/* @var $costCode CostCode */

				$htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCode($user_company_id);
				$costCodeHtml = $htmlEntityEscapedFormattedCostCode;

				$bidderJsObject = <<<END_BIDDER_JS_OBJECT

				{
					contact_id:   '$contact_id',
					company:      '$company',
					first_name:   '$first_name',
					last_name:    '$last_name',
					email:        '$email',
					cost_code_id: '$cost_code_id',
					formattedCostCode: '$htmlEntityEscapedFormattedCostCode'
				}

END_BIDDER_JS_OBJECT;

				$bidderJsObject = preg_replace('/\s+/', ' ', $bidderJsObject);

				$searchResultsTbody .= <<<END_SEARCH_RESULTS_TBODY

					<tr id="searchContactRow_{$contact_id}" onclick="SelectedBidders.add($bidderJsObject);">
						<td nowrap>$costCodeHtml</td>
						<td nowrap>$company</td>
						<td nowrap>$first_name</td>
						<td nowrap>$last_name</td>
						<td nowrap>$email</td>
					</tr>

END_SEARCH_RESULTS_TBODY;

			}

		}

		$htmlContent = <<<END_HTML_CONTENT

		<div id="divContactListSearchResults">
		<table class="listTable" style="width:100%;">
			<thead>
				<tr>
					<th nowrap>Cost Code</th>
					<th nowrap>Company Name</th>
					<th nowrap>First Name</th>
					<th nowrap>Last Name</th>
					<th nowrap>Email Addresss</th>
				</tr>
			</thead>
			<tbody>
				$searchResultsTbody
			</tbody>
		</table>
		</div>
END_HTML_CONTENT;

		echo $htmlContent;

	break;

	case 'loadSendBidInvitationDialog':

		$csvSubcontractorBidIds = $get->csvSubcontractorBidIds;
		$arrSubcontractorBidIds = explode(',', $csvSubcontractorBidIds);
		$ulContacts  = '';
		foreach ($arrSubcontractorBidIds as $subcontractor_bid_id) {
			$subcontractorBid = SubcontractorBid::findSubcontractorBidByIdExtended($database, $subcontractor_bid_id);
			$contact = $subcontractorBid->getSubcontractorContact();
			$contactFullName = $contact->getContactFullName();
			$email = $contact->email;
			$ulContacts .=
			'
			<li id="subcontractor_bid--'.$subcontractor_bid_id.'">
				<span class="entypo entypo-click entypo-cancel-circled" onclick="removeContactFromEmail(this);"></span>
				<span class="bs-tooltip" title="'.$email.'">' . $contactFullName . '</span>
			</li>
			';
		}

		$emailBody = '';

		$htmlContent =
		'
		<div>To:</div>
		<ul id="subcontractorBidInvitationEmailRecipients" class="contacts">'.$ulContacts.'</ul>
		<div style="margin-top:10px">Body:</div>
		<div>
			<textarea id="emailBody" class="email-body">'.$emailBody.'</textarea>
		</div>
		';

		echo $htmlContent;

	break;

	case 'loadEmailModalDialog_SendSubcontractorBidCorrespondance':

		// @todo Add lookup via address book
		// Always present - Should we have an error if empty? No since we could use an inline "To:" lookup via address book
		// subcontractor_bids
		$csvSubcontractorBidIds = $get->csvSubcontractorBidIds;

		// Usually present - common use case (one only)
		// project_bid_invitations
		$csvProjectBidInvitationIds = $get->csvProjectBidInvitationIds;

		// Usually present - common use case (one per cost code)
		// gc_budget_line_item_unsigned_scope_of_work_documents
		$csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = $get->csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds;

		// gc_budget_line_item_bid_invitations
		$csvGcBudgetLineItemBidInvitationIds = $get->csvGcBudgetLineItemBidInvitationIds;

		// subcontractor_bid_documents
		$csvSubcontractorBidDocumentIds = $get->csvSubcontractorBidDocumentIds;

		// @todo Load default values for missing inputs...

		// Default Subject Line:
		$defaultEmailMessageSubject = $get->defaultEmailMessageSubject;

		// Default Email Message:
		$defaultEmailMessageBody = $get->defaultEmailMessageBody;

		// bidPerference
		$bidPerference = $get->bidPerference;

		$arrSubcontractorBidData = array(
			'csvSubcontractorBidIds' => $csvSubcontractorBidIds,
			'csvSubcontractorBidDocumentIds' => $csvSubcontractorBidDocumentIds,
			'csvProjectBidInvitationIds' => $csvProjectBidInvitationIds,
			'csvGcBudgetLineItemBidInvitationIds' => $csvGcBudgetLineItemBidInvitationIds,
			'csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds' => $csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds,
			'defaultEmailMessageSubject' => $defaultEmailMessageSubject,
			'defaultEmailMessageBody' => $defaultEmailMessageBody,
			'bidPerference' => $bidPerference,
		);

		$renderEmailModalDialogSendInvitationsToBid = renderEmailModalDialogSendInvitationsToBid($database, $user_company_id, $project_id, $arrSubcontractorBidData);

		echo $renderEmailModalDialogSendInvitationsToBid;

	break;

	case 'submitEmailModalDialog_PerformAction':

		// subcontractor_bids
		$csvSubcontractorBidIds = $get->csvSubcontractorBidIds;

		// subcontractor_bid_documents
		$csvSubcontractorBidDocumentIds = $get->csvSubcontractorBidDocumentIds;

		// project_bid_invitations
		$csvProjectBidInvitationIds = $get->csvProjectBidInvitationIds;

		// gc_budget_line_item_bid_invitations
		$csvGcBudgetLineItemBidInvitationIds = $get->csvGcBudgetLineItemBidInvitationIds;

		// gc_budget_line_item_unsigned_scope_of_work_documents
		$csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = $get->csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds;

		// @todo Load default values for missing inputs...

		$arrSubcontractorBidData = array(
			'csvSubcontractorBidIds' => $csvSubcontractorBidIds,
			'csvSubcontractorBidDocumentIds' => $csvSubcontractorBidDocumentIds,
			'csvProjectBidInvitationIds' => $csvProjectBidInvitationIds,
			'csvGcBudgetLineItemBidInvitationIds' => $csvGcBudgetLineItemBidInvitationIds,
			'csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds' => $csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds,
		);

		$successFlag = submitEmailModalDialog_PerformAction($database, $user_company_id, $project_id, $arrSubcontractorBidData);

		// Debug pause line
		$x = 1;

	break;

	case 'loadSendEmailDialog':

		$csvSubcontractorBidIds = $get->csvSubcontractorBidIds;
		$arrSubcontractorBidIds = explode(',', $csvSubcontractorBidIds);
		$ulContacts  = '';
		foreach ($arrSubcontractorBidIds as $subcontractor_bid_id) {
			$subcontractorBid = SubcontractorBid::findSubcontractorBidByIdExtended($database, $subcontractor_bid_id);
			$contact = $subcontractorBid->getSubcontractorContact();
			$contactFullName = $contact->getContactFullName();
			$email = $contact->email;
			$ulContacts .=
			'
			<li id="subcontractor_bid--'.$subcontractor_bid_id.'">
				<span class="entypo entypo-click entypo-cancel-circled" onclick="removeContactFromEmail(this);"></span>
				<span class="bs-tooltip" title="'.$email.'">' . $contactFullName . '</span>
			</li>
			';
		}

		$htmlContent =
		'
		<div>To:</div>
		<ul id="emailRecipients" class="contacts">'.$ulContacts.'</ul>
		<div style="margin-top:10px">Body:</div>
		<div>
			<textarea id="emailBody" class="email-body" placeholder="Message"></textarea>
		</div>
		';

		echo $htmlContent;

	break;

	case 'sendEmail':

		$csvSubcontractorBidIds = $get->csvSubcontractorBidIds;
		$emailBody = $get->emailBody;

		$arrOutput = array(
			'messageText' => 'Success'
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;

	case 'loadBiddingContent':
		if (isset($get->toggleAdvancedMode)) {
			$htmlContent = renderBiddingContent($database, $user_company_id, $project_id, $currentlyActiveContactId, true);
		} else {
			$htmlContent = renderBiddingContent($database, $user_company_id, $project_id, $currentlyActiveContactId);
		}
		echo $htmlContent;

	break;
}

$htmlOutput = ob_get_clean();
echo $htmlOutput;

while (@ob_end_flush());

exit; // End of PHP Ajax Handler Code

} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}
