<?php
/**
 * Reusable page widgets via ajax.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['ajax'] = true;
$init['get_required'] = true;
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

$db = DBI::getInstance($database);

/* @var $session Session */

$loopMax = 10000;

// Start output buffering to prevent output from being echo'd out
ob_start();

switch ($methodCall) {
	case 'searchForUserCompanyContactsByCompanyTextOrContactText':

		$htmlContent = '';

		// Responds to page-component: contact_search_by_contact_company_name_or_contact_name.php

		$company = (string) $get->company;
		$first_name = (string) $get->first_name;
		$last_name = (string) $get->last_name;
		$email = (string) $get->email;
		$javaScriptHandler = $get->jsHandler;

		//$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
		$user_company_id = $session->getUserCompanyId();

		$arrQueryFilter = array();

		if (strlen($company) > 1) {
			$escapedCompany = $db->escape($company);
			$arrQueryFilter[] = "(cc.`company` LIKE '%$escapedCompany%')";
		}
		if (strlen($first_name) > 1) {
			$escapedFirstName = $db->escape($first_name);
			$arrQueryFilter[] = "(c.`first_name` LIKE '%$escapedFirstName%')";
		}
		if (strlen($last_name) > 1) {
			$escapedLastName = $db->escape($last_name);
			$arrQueryFilter[] = "(c.`last_name` LIKE '%$escapedLastName%')";
		}
		if (strlen($email) > 1) {
			$escapedemail = $db->escape($email);
			$arrQueryFilter[] = "(c.`email` LIKE '%$escapedemail%')";
		}

		if (!empty($arrQueryFilter)) {
			$queryFilter = join(' AND ', $arrQueryFilter);
			$queryFilter = "AND ($queryFilter)";
		} else {
			$queryFilter = '';
		}

		$query =
"
SELECT
	c.*,
	cc.*,
	c.`id` as 'contact_id',
	cc.`id` as 'contact_company_id'
FROM `contacts` c
	INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
WHERE c.`user_company_id` = ? AND c.`is_archive` = 'N'
$queryFilter
ORDER BY cc.`company` ASC, c.`first_name` ASC, c.`last_name` ASC
";
		$arrValues = array($user_company_id);
		$result = $db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$resultCount = $db->rowCount;
		//$resultCount = mysqli_num_rows($result);
		$showingCount = $resultCount;
		if ($resultCount > $loopMax) {
			$showingCount = $loopMax;
		}

		$htmlContent .= <<<END_HTML_CONTENT

			Viewing $showingCount of $resultCount (NOTE: Companies without contacts not included)
			<div id="divContactListSearchResults">
			<table class="listTable" style="width:100%;">
				<tr>
					<th nowrap>Company Name</th>
					<th nowrap>First Name</th>
					<th nowrap>Last Name</th>
					<th nowrap>Email Address</th>
				</tr>
END_HTML_CONTENT;

		$loopCounter = 0;
		while ($row = $db->fetch()) {
			if ($loopCounter == $loopMax) {
				break;
			}

			if ($loopCounter%2) {
				$rowStyle = 'oddRow';
			} else {
				$rowStyle = 'evenRow';
			}

			$contact_id = $row['contact_id'];
			$contact_company_id = $row['contact_company_id'];

			$row['id'] = $contact_id;
			$contact = IntegratedMapper::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			$row['id'] = $contact_company_id;
			$contactCompany = IntegratedMapper::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$contactCompany->convertPropertiesToData();
			//$contact->setContactCompany($contactCompany);

			$company = $contactCompany->contact_company_name;
			$encodedCompanyName = rawurlencode($company);
			$contact_first_name = $contact->first_name;
			$encodedContactFirstName = rawurlencode($contact_first_name);
			$contact_last_name = $contact->last_name;
			$encodedContactLastName = rawurlencode($contact_last_name);
			$email = $row['email'];
			$is_archive = $row['is_archive'];
			$encodedEmail = rawurlencode($email);

			$htmlContent .= <<<END_HTML_CONTENT

				<tr id="searchContactRow_$contact_id" class="$rowStyle" onclick="searchContactSelected(this, '$javaScriptHandler', '$contact_id', '$encodedCompanyName', '$encodedContactFirstName', '$encodedContactLastName', '$encodedEmail','$is_archive');">
					<td nowrap>$company</td>
					<td nowrap>$contact_first_name</td>
					<td nowrap>$contact_last_name</td>
					<td nowrap>$email</td>
				</tr>
END_HTML_CONTENT;
			$loopCounter ++;
		}
		$db->free_result();

		$htmlContent .= <<<END_HTML_CONTENT

			</table>
			</div>
END_HTML_CONTENT;

		echo $htmlContent;

	break;

	case 'searchForContactsByCostCodeData':

		$htmlContent = '';

		/**
		 Responds to page-component: contact_search_by_cost_code_association.php
		 */

		$searchedDivisionNumber = $get->divisionNumber;
		$searchedDivision = $get->division;
		$searchedCostCode = $get->costCode;
		$searchedCostCodeDescription = $get->costCodeDescription;
		$javaScriptHandler = $get->jsHandler;

		//$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
		$user_company_id = $session->getUserCompanyId();

		$arrQueryFilter = array();

		if (strlen($searchedDivisionNumber) > 1) {
			$escapedSearchedDivisionNumber = $db->escape($searchedDivisionNumber);
			$arrQueryFilter[] = "(ccd.`division_number` LIKE '%$escapedSearchedDivisionNumber%')";
		}
		if (strlen($searchedDivision) > 1) {
			$escapedSearchedDivision = $db->escape($searchedDivision);
			$arrQueryFilter[] = "(ccd.`division` LIKE '%$escapedSearchedDivision%')";
		}
		if (strlen($searchedCostCode) > 1) {
			$escapedSearchedCostCode = $db->escape($searchedCostCode);
			$arrQueryFilter[] = "(codes.`cost_code` LIKE '%$escapedSearchedCostCode%')";
		}
		if (strlen($searchedCostCodeDescription) > 1) {
			$escapedSearchedCostCodeDescription = $db->escape($searchedCostCodeDescription);
			$arrQueryFilter[] = "(codes.`cost_code_description` LIKE '%$escapedSearchedCostCodeDescription%')";
		}

		if (!empty($arrQueryFilter)) {
			$queryFilter = join(' AND ', $arrQueryFilter);
			$queryFilter = "AND ($queryFilter)";
		}

		$query =
"
SELECT
	c.`first_name`, c.`last_name`, c.`email`,
	cc.`company`,
	ccd.`division_number`, ccd.`division_code_heading`, ccd.`division`,
	codes.`id` AS 'cost_code_id', codes.`cost_code`, codes.`cost_code_description`,
	c.`id` AS 'contact_id'
FROM `contacts` c
	INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
	INNER JOIN `subcontractor_trades` st ON cc.`id` = st.`contact_company_id`
	INNER JOIN `cost_codes` codes ON st.`cost_code_id` = codes.`id`
	INNER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
WHERE ccd.`user_company_id` = ?
AND codes.`disabled_flag` = 'N'
$queryFilter
UNION
SELECT
	c.`first_name`, c.`last_name`, c.`email`,
	cc.`company`,
	ccd.`division_number`, ccd.`division_code_heading`, ccd.`division`,
	codes.`id` AS 'cost_code_id', codes.`cost_code`, codes.`cost_code_description`,
	c.`id` AS 'contact_id'
FROM `contacts` c
	INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
	INNER JOIN `subcontractor_bids` sb ON c.`id` = sb.`subcontractor_contact_id`
	INNER JOIN `gc_budget_line_items` gbli ON sb.`gc_budget_line_item_id` = gbli.`id`
	INNER JOIN `cost_codes` codes ON gbli.`cost_code_id` = codes.`id`
	INNER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
WHERE ccd.`user_company_id` = ?
AND codes.`disabled_flag` = 'N'
$queryFilter
ORDER BY division_number, cost_code, company, first_name, last_name
";

		$arrValues = array($user_company_id, $user_company_id);
		$result = $db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$resultCount = $db->rowCount;
		$showingCount = $resultCount;
		if ($resultCount > $loopMax) {
			$showingCount = $loopMax;
		}

		$htmlContent .= <<<END_HTML_CONTENT

			<table><tr><td>Viewing $showingCount of $resultCount (NOTE: Companies without contacts not included)</td></tr></table>
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align: left;">
					<tr>
						<th width="12%" style="text-align: center;">Division</th>
						<th width="10%">Division Number</th>
						<th width="10%">Cost Code</th>
						<th width="15%">Cost Code Description</th>
						<th width="15%">Company</th>
						<th width="10%">First Name</th>
						<th width="10%">Last Name</th>
						<th width="15%">Email</th>
					</tr>
				</table>
			<div id="divContactListSearchByTradeResults">
				<table border="0" class="listTable" width="100%">
END_HTML_CONTENT;

		$loopCounter = 0;
		while ($row = $db->fetch()) {
			if ($loopCounter == $loopMax) {
				break;
			}

			if ($loopCounter % 2) {
				$rowStyle = 'oddRow';
			} else {
				$rowStyle = 'evenRow';
			}

			$division_number = $row['division_number'];
			$division = $row['division'];
			$cost_code_id = $row['cost_code_id'];
			$cost_code = $row['cost_code'];
			$cost_code_description = $row['cost_code_description'];
			$company = $row['company'];
			$encodedCompanyName = rawurlencode($company);

			$contact_id = $row['contact_id'];
			$row['id'] = $contact_id;
			$contact = IntegratedMapper::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			$first_name = $contact->first_name;
			$encodedFirstName = rawurlencode($first_name);

			$last_name = $contact->last_name;
			$encodedLastName = rawurlencode($last_name);

			$email = $contact->email;
			$encodedEmail = rawurlencode($email);

			$is_archive = $contact->is_archive;
			$encodedEmail = rawurlencode($is_archive);

			$htmlContent .= <<<END_HTML_CONTENT

					<tr id="searchContactRow_$contact_id" class="$rowStyle" onclick="searchContactSelected(this, '$javaScriptHandler', '$contact_id', '$encodedCompanyName', '$encodedFirstName', '$encodedLastName', '$encodedEmail', '$is_archive');">
						<td nowrap width="12%" class="division">$division</td>
						<td nowrap width="10%" class="division_number">$division_number</td>
						<td nowrap width="10%" class="cost_code">$cost_code</td>
						<!--td nowrap>$division_number-$cost_code</td-->
						<td nowrap width="15%"><span class="cost_code_description">$cost_code_description</span><input type="hidden" class="cost_code_id" value="$cost_code_id"></td>
						<td nowrap width="15%" class="company">$company</td>
						<td nowrap width="10%"><span class="first_name">$first_name</span><input type="hidden" class="contact_id" value="$contact_id"></td>
						<td nowrap width="10%" class="last_name">$last_name</td>
						<td nowrap width="15%" class="email">$email</td>
					</tr>
END_HTML_CONTENT;
			$loopCounter ++;

		}

		$htmlContent .= <<<END_HTML_CONTENT

				</table>
			</div>
END_HTML_CONTENT;

		echo $htmlContent;

	break;

}

ob_flush();
exit;
